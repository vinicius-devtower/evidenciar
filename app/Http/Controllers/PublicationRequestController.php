<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\PublicationMessage;
use App\Models\PublicationRequest;
use App\Models\Site;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

/**
 * Fluxo do ASSINANTE: solicitar publicação (wizard), acompanhar e
 * trocar mensagens com o suporte. A interface de atendimento fica em
 * App\Http\Controllers\Suporte\PublicacaoController.
 */
class PublicationRequestController extends Controller
{
    /**
     * Página "Publicação" no painel do cliente: mostra o pedido corrente
     * (se houver) ou um call-to-action para iniciar.
     */
    public function index()
    {
        $user   = Auth::user();
        $client = $user->client;
        $site   = $client?->sites()->latest()->first();

        $current = null;
        if ($site) {
            $current = $site->publicationRequests()
                ->with(['messages.user', 'assignee'])
                ->whereIn('status', PublicationRequest::OPEN_STATUSES)
                ->latest()
                ->first()
                ?? $site->publicationRequests()->latest()->first();
        }

        return view('sistema.publicacao.index', [
            'site'    => $site,
            'current' => $current,
            'page'    => 'publicacao',
        ]);
    }

    /**
     * Passo 1 do wizard: pergunta se o cliente já tem domínio próprio.
     */
    public function wizardStep1()
    {
        $site = $this->siteOrFail();

        // Se já existe solicitação aberta, envia direto para o acompanhamento.
        if ($site->hasOpenPublicationRequest()) {
            return redirect()->route('app.publicacao.index')
                ->with('info', 'Já existe uma solicitação em andamento.');
        }

        $draft = session('publicacao_wizard', []);
        return view('sistema.publicacao.wizard.step1', [
            'draft' => $draft,
            'site'  => $site,
            'page'  => 'publicacao',
        ]);
    }

    public function saveStep1(Request $request)
    {
        $this->siteOrFail();

        $data = $request->validate([
            'has_domain' => ['required', 'in:yes,no'],
        ]);

        $draft = array_merge(session('publicacao_wizard', []), [
            'has_domain' => $data['has_domain'],
        ]);
        session(['publicacao_wizard' => $draft]);

        return redirect()->route('app.publicacao.wizard.step2');
    }

    /**
     * Passo 2: se tem domínio → informa dados; se não → preferência de registro.
     */
    public function wizardStep2()
    {
        $site = $this->siteOrFail();
        $draft = session('publicacao_wizard', []);
        if (empty($draft['has_domain'])) {
            return redirect()->route('app.publicacao.wizard.step1');
        }

        return view('sistema.publicacao.wizard.step2', [
            'draft' => $draft,
            'site'  => $site,
            'page'  => 'publicacao',
        ]);
    }

    public function saveStep2(Request $request)
    {
        $this->siteOrFail();
        $draft = session('publicacao_wizard', []);
        $has = $draft['has_domain'] ?? null;

        if ($has === 'yes') {
            $data = $request->validate([
                'domain_name'  => ['required', 'string', 'max:200'],
                'registrar'    => ['nullable', 'string', 'max:100'],
                'access_notes' => ['nullable', 'string', 'max:2000'],
            ]);
        } elseif ($has === 'no') {
            $data = $request->validate([
                'desired_domain' => ['required', 'string', 'max:200'],
                'extension'      => ['required', Rule::in(['.com.br', '.com', 'outro'])],
                'register_help'  => ['required', 'in:yes,no'],
                'access_notes'   => ['nullable', 'string', 'max:2000'],
            ]);
        } else {
            return redirect()->route('app.publicacao.wizard.step1');
        }

        $draft = array_merge($draft, $data);
        session(['publicacao_wizard' => $draft]);

        return redirect()->route('app.publicacao.wizard.step3');
    }

    /**
     * Passo 3: checklist de prontidão.
     */
    public function wizardStep3()
    {
        $site = $this->siteOrFail();
        $draft = session('publicacao_wizard', []);
        if (empty($draft['has_domain'])) {
            return redirect()->route('app.publicacao.wizard.step1');
        }
        return view('sistema.publicacao.wizard.step3', [
            'draft' => $draft,
            'site'  => $site,
            'page'  => 'publicacao',
        ]);
    }

    public function saveStep3(Request $request)
    {
        $this->siteOrFail();
        $data = $request->validate([
            'check_content'  => ['nullable', 'in:0,1'],
            'check_images'   => ['nullable', 'in:0,1'],
            'check_contacts' => ['nullable', 'in:0,1'],
            'check_branding' => ['nullable', 'in:0,1'],
        ]);

        $draft = array_merge(session('publicacao_wizard', []), [
            'checklist' => [
                'content'  => ($data['check_content']  ?? '0') === '1',
                'images'   => ($data['check_images']   ?? '0') === '1',
                'contacts' => ($data['check_contacts'] ?? '0') === '1',
                'branding' => ($data['check_branding'] ?? '0') === '1',
            ],
        ]);
        session(['publicacao_wizard' => $draft]);

        return redirect()->route('app.publicacao.wizard.review');
    }

    /**
     * Revisão e envio final.
     */
    public function wizardReview()
    {
        $site = $this->siteOrFail();
        $draft = session('publicacao_wizard', []);
        if (empty($draft['has_domain']) || empty($draft['checklist'])) {
            return redirect()->route('app.publicacao.wizard.step1');
        }
        return view('sistema.publicacao.wizard.review', [
            'draft' => $draft,
            'site'  => $site,
            'page'  => 'publicacao',
        ]);
    }

    public function submit(Request $request)
    {
        $site  = $this->siteOrFail();
        $draft = session('publicacao_wizard', []);

        abort_if(empty($draft['has_domain']) || empty($draft['checklist']), 422,
            'Fluxo guiado incompleto.');
        abort_if($site->hasOpenPublicationRequest(), 409,
            'Já existe uma solicitação em andamento.');

        $domainInfo = array_filter([
            'has_domain'     => $draft['has_domain'] ?? null,
            'domain_name'    => $draft['domain_name'] ?? null,
            'registrar'      => $draft['registrar'] ?? null,
            'desired_domain' => $draft['desired_domain'] ?? null,
            'extension'      => $draft['extension'] ?? null,
            'register_help'  => $draft['register_help'] ?? null,
            'access_notes'   => $draft['access_notes'] ?? null,
        ], fn ($v) => $v !== null && $v !== '');

        $pub = PublicationRequest::create([
            'site_id'        => $site->id,
            'client_id'      => $site->client_id,
            'status'         => 'requested',
            'domain_info'    => $domainInfo,
            'checklist'      => $draft['checklist'] ?? [],
            'last_status_at' => now(),
        ]);

        ActivityLog::record(
            event:      'publication.requested',
            description: 'Solicitação de publicação criada pelo cliente (wizard)',
            subject:    $pub,
            user:       auth()->user(),
        );
        ActivityLog::record(
            event:      'site.publication_requested',
            description: 'Solicitação de publicação enviada',
            subject:    $site,
            user:       auth()->user(),
        );

        session()->forget('publicacao_wizard');

        return redirect()->route('app.publicacao.index')
            ->with('success', 'Solicitação enviada ao suporte!');
    }

    /**
     * Cliente posta mensagem na thread da sua solicitação.
     */
    public function message(Request $request, PublicationRequest $publicacao)
    {
        abort_unless(
            $publicacao->client_id === auth()->user()->client_id,
            403
        );

        $data = $request->validate([
            'body' => ['required', 'string', 'max:4000'],
        ]);

        PublicationMessage::create([
            'publication_request_id' => $publicacao->id,
            'user_id'                => auth()->id(),
            'author_role'            => 'client',
            'body'                   => $data['body'],
        ]);

        // Se o suporte estava aguardando o cliente, move para in_progress.
        if ($publicacao->status === 'awaiting_client_info') {
            $publicacao->update([
                'status'         => 'in_progress',
                'last_status_at' => now(),
            ]);
        }

        ActivityLog::record(
            event:      'publication.message_sent',
            description: 'Mensagem do cliente enviada',
            subject:    $publicacao,
            user:       auth()->user(),
        );

        return back()->with('success', 'Mensagem enviada.');
    }

    /**
     * Cliente cancela a solicitação se ainda estiver aberta.
     */
    public function cancel(PublicationRequest $publicacao)
    {
        abort_unless(
            $publicacao->client_id === auth()->user()->client_id,
            403
        );
        abort_unless($publicacao->isOpen(), 409);

        $publicacao->update([
            'status'         => 'cancelled',
            'last_status_at' => now(),
        ]);

        ActivityLog::record(
            event:      'publication.cancelled',
            description: 'Solicitação cancelada pelo cliente',
            subject:    $publicacao,
            user:       auth()->user(),
        );

        return redirect()->route('app.publicacao.index')
            ->with('success', 'Solicitação cancelada.');
    }

    // ------------------------------------------------------------------
    //  Helpers
    // ------------------------------------------------------------------

    /**
     * Entrada legada (POST /app/sites/{site}/request-publication)
     * Mantida por compatibilidade caso alguém chame direto. Agora redireciona
     * para o wizard.
     */
    public function store(Site $site)
    {
        abort_unless(
            $site->client_id === auth()->user()->client_id,
            403
        );
        return redirect()->route('app.publicacao.wizard.step1');
    }

    private function siteOrFail(): Site
    {
        $user   = Auth::user();
        $client = $user->client;
        $site   = $client?->sites()->latest()->first();

        if (!$site) {
            abort(redirect()->route('app.templates')
                ->with('error', 'Escolha um template antes de solicitar publicação.'));
        }
        return $site;
    }
}
