<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Client;
use Illuminate\Http\Request;

class ImpersonateController extends Controller
{
    /**
     * Entra no painel do cliente como o tenant informado (view impersonation).
     * Restrito a admin — ver rota em routes/web.php.
     */
    public function start(Client $assinante)
    {
        session([
            'impersonate_client_id'   => $assinante->id,
            'impersonate_client_name' => $assinante->name,
        ]);

        ActivityLog::record(
            event:       'client.impersonate_start',
            description: auth()->user()->name . ' acessou o painel do cliente como ' . $assinante->name,
            subject:     $assinante,
            user:        auth()->user(),
        );

        return redirect()->route('app.inicio')
            ->with('success', 'Você está vendo o painel como ' . $assinante->name . '.');
    }

    /**
     * Sai do modo "ver como cliente" e volta pro Painel Suporte.
     */
    public function stop(Request $request)
    {
        $clientId   = session('impersonate_client_id');
        $clientName = session('impersonate_client_name');

        if ($clientId && ($client = Client::find($clientId))) {
            ActivityLog::record(
                event:       'client.impersonate_stop',
                description: auth()->user()->name . ' saiu do painel do cliente ' . $clientName,
                subject:     $client,
                user:        auth()->user(),
            );
        }

        session()->forget(['impersonate_client_id', 'impersonate_client_name']);

        return redirect()->route('suporte.assinantes.index')
            ->with('success', 'Você voltou ao Painel Suporte.');
    }
}
