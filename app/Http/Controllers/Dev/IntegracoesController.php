<?php

namespace App\Http\Controllers\Dev;

use App\Http\Controllers\Controller;
use App\Models\IntegrationSetting;
use Illuminate\Http\Request;

class IntegracoesController extends Controller
{
    public function mercadoPago()
    {
        $setting = IntegrationSetting::firstOrNew(['provider' => 'mercadopago']);

        return view('backoffice.dev.integracoes.mercadopago', [
            'setting' => $setting,
            'area'    => 'dev',
            'page'    => 'integracoes-mercadopago',
        ]);
    }

    public function updateMercadoPago(Request $request)
    {
        $data = $request->validate([
            'public_key'        => ['nullable', 'string'],
            'access_token'      => ['nullable', 'string'],
            'client_id'         => ['nullable', 'string'],
            'client_secret'     => ['nullable', 'string'],
            'webhook_secret'    => ['nullable', 'string'],
            'notification_url'  => ['nullable', 'string', 'max:255'],
        ]);

        $setting = IntegrationSetting::firstOrNew(['provider' => 'mercadopago']);

        // Campos sensíveis: só sobrescreve se o usuário digitou algo novo.
        // A view manda esses inputs vazios por padrão (mostra só um preview
        // mascarado do valor salvo) — sem isso, salvar o form sem mexer
        // apagaria a credencial.
        foreach (['access_token', 'client_secret', 'webhook_secret'] as $sensitive) {
            if (blank($data[$sensitive] ?? null)) {
                unset($data[$sensitive]);
            }
        }

        $setting->fill($data);
        $setting->provider = 'mercadopago';
        $setting->updated_by = $request->user()->id;
        $setting->save();

        return redirect()
            ->route('dev.integracoes.mercadopago')
            ->with('success', 'Configuração do Mercado Pago salva.');
    }
}
