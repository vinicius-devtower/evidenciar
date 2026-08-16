<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;

/**
 * Controla a "Jornada do Cliente" — formulário multi-etapas que coleta
 * os dados do futuro cliente antes de gerar a cobrança (PIX/Boleto/Cartão)
 * via Mercado Pago.
 *
 * Os dados de cada etapa ficam em sessão (chave "jornada") até o usuário
 * finalizar o passo 3, quando são enviados ao CheckoutController que gera
 * o pagamento e dispara o e-mail de instruções.
 */
class JornadaController extends Controller
{
    protected const SESSION_KEY = 'jornada';

    /**
     * Tela inicial ("Olá! Sou a Eva").
     * Aceita opcionalmente:
     *   ?template=slug  — fixa o template escolhido
     *   ?plan=slug      — fixa o plano escolhido na LP (start/profissional/gestao_vip)
     *   ?cycle=annual   — fixa o ciclo de cobrança anual (padrão: mensal)
     */
    public function start(Request $request)
    {
        // Plano vindo da LP — só aceita slugs conhecidos.
        if ($request->filled('plan')) {
            $planSlug = $request->input('plan');
            if (in_array($planSlug, Plan::ALL_SLUGS, true)) {
                $plan = Plan::where('slug', $planSlug)->where('is_active', true)->first();
                if ($plan) {
                    $this->mergeSession(['plan_id' => $plan->id, 'plan_slug' => $plan->slug]);
                }
            }
        }

        // Ciclo de cobrança — só aceita 'monthly'/'annual', padrão 'monthly'.
        // Uma vez fixado (LP com ?cycle=annual), fica valendo o resto da
        // jornada mesmo que o usuário volte pra essa tela sem o parâmetro.
        if ($request->filled('cycle')) {
            $cycle = $request->input('cycle') === 'annual' ? 'annual' : 'monthly';
            $this->mergeSession(['cycle' => $cycle]);
        } elseif (!Session::has(self::SESSION_KEY . '.cycle')) {
            $this->mergeSession(['cycle' => 'monthly']);
        }

        // Se não veio plano e nada ainda em sessão, deixamos em branco —
        // as etapas seguintes exigem que plan_id exista e redirecionam.

        // Template (MVP): primeiro ativo ou o informado.
        if ($request->filled('template')) {
            $template = Template::where('slug', $request->input('template'))
                ->where('status', 'active')
                ->firstOrFail();
            $this->mergeSession(['template_id' => $template->id]);
        } else {
            $template = Template::where('status', 'active')->first();
            if ($template && !Session::get(self::SESSION_KEY . '.template_id')) {
                $this->mergeSession(['template_id' => $template->id]);
            }
        }

        return view('jornada.start', [
            'template' => $template,
            'plan'     => $this->currentPlan(),
            'cycle'    => $this->currentCycle(),
        ]);
    }

    public function step1()
    {
        if (!$plan = $this->currentPlan()) {
            return $this->redirectMissingPlan();
        }

        return view('jornada.step-1', [
            'data'  => Session::get(self::SESSION_KEY, []),
            'plan'  => $plan,
            'cycle' => $this->currentCycle(),
        ]);
    }

    public function saveStep1(Request $request): RedirectResponse
    {
        if (!$this->currentPlan()) {
            return $this->redirectMissingPlan();
        }

        $validated = $request->validate([
            'area_atuacao' => ['required', 'string', 'max:255'],
            'especialidade' => ['nullable', 'string', 'max:255'],
            'categorias' => ['nullable', 'array'],
            'categorias.*' => ['string', 'max:100'],
        ], [
            'area_atuacao.required' => 'Informe sua área de atuação.',
        ]);

        $this->mergeSession([
            'step1' => $validated,
        ]);

        return redirect()->route('jornada.step2');
    }

    public function step2()
    {
        if (!$plan = $this->currentPlan()) {
            return $this->redirectMissingPlan();
        }
        if (!Session::has(self::SESSION_KEY . '.step1')) {
            return redirect()->route('jornada.step1')
                ->with('warning', 'Preencha o passo 1 antes de continuar.');
        }

        return view('jornada.step-2', [
            'data'  => Session::get(self::SESSION_KEY, []),
            'plan'  => $plan,
            'cycle' => $this->currentCycle(),
        ]);
    }

    public function saveStep2(Request $request): RedirectResponse
    {
        if (!$this->currentPlan()) {
            return $this->redirectMissingPlan();
        }

        $validated = $request->validate([
            'dominio_opcao' => ['required', 'in:possuo,registrar,sem_dominio'],
            'dominio' => ['nullable', 'string', 'max:255'],
        ], [
            'dominio_opcao.required' => 'Escolha uma das opções de domínio.',
        ]);

        $this->mergeSession([
            'step2' => $validated,
        ]);

        return redirect()->route('jornada.step3');
    }

    public function step3()
    {
        if (!$plan = $this->currentPlan()) {
            return $this->redirectMissingPlan();
        }
        if (!Session::has(self::SESSION_KEY . '.step1') || !Session::has(self::SESSION_KEY . '.step2')) {
            return redirect()->route('jornada.step1')
                ->with('warning', 'Preencha os passos anteriores antes de continuar.');
        }

        return view('jornada.step-3', [
            'data'  => Session::get(self::SESSION_KEY, []),
            'plan'  => $plan,
            'cycle' => $this->currentCycle(),
        ]);
    }

    /**
     * Finaliza a jornada: valida dados pessoais + método de pagamento,
     * consolida com steps anteriores e encaminha para o CheckoutController.
     */
    public function saveStep3(Request $request): RedirectResponse
    {
        if (!$this->currentPlan()) {
            return $this->redirectMissingPlan();
        }

        $rules = [
            'name'           => ['required', 'string', 'max:255'],
            'email'          => ['required', 'email', 'max:255'],
            'whatsapp'       => ['nullable', 'string', 'max:50'],
            'documento'      => ['nullable', 'string', 'max:30'],
            'payment_method' => ['required', 'in:pix,boleto,credit_card'],
            'aceite'         => ['accepted'],
        ];

        // Campos só são obrigatórios quando o método é cartão.
        if ($request->input('payment_method') === 'credit_card') {
            $rules['card_token']   = ['required', 'string'];
            $rules['card_last4']   = ['required', 'string', 'size:4'];
            $rules['card_brand']   = ['required', 'string', 'max:30'];
            $rules['installments'] = ['required', 'integer', 'min:1', 'max:12'];
        }

        $validated = $request->validate($rules, [
            'name.required'           => 'Informe seu nome completo.',
            'email.required'          => 'Informe um e-mail válido.',
            'payment_method.required' => 'Escolha uma forma de pagamento.',
            'payment_method.in'       => 'Forma de pagamento inválida.',
            'aceite.accepted'         => 'Você precisa aceitar os termos para continuar.',
        ]);

        $this->mergeSession([
            'step3' => $validated,
        ]);

        // Delega ao CheckoutController a criação do pagamento.
        return redirect()->route('checkout.create');
    }

    /**
     * Retorna o Plan atual armazenado na sessão, ou null se não houver.
     */
    protected function currentPlan(): ?Plan
    {
        $planId = Session::get(self::SESSION_KEY . '.plan_id');
        if (!$planId) {
            return null;
        }
        return Plan::where('is_active', true)->find($planId);
    }

    /**
     * Ciclo de cobrança atual da sessão ('monthly' ou 'annual').
     */
    protected function currentCycle(): string
    {
        $cycle = Session::get(self::SESSION_KEY . '.cycle', 'monthly');
        return $cycle === 'annual' ? 'annual' : 'monthly';
    }

    /**
     * Redireciona o usuário de volta para a LP quando nenhum plano foi escolhido.
     */
    protected function redirectMissingPlan(): RedirectResponse
    {
        return redirect('/#pricing')
            ->with('warning', 'Escolha um plano para começar sua jornada.');
    }

    /**
     * Helper: faz merge de dados na chave de sessão "jornada".
     */
    protected function mergeSession(array $data): void
    {
        $current = Session::get(self::SESSION_KEY, []);
        Session::put(self::SESSION_KEY, array_replace_recursive($current, $data));
    }
}
