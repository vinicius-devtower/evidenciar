<?php

namespace App\Http\Controllers\Suporte;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\PublicationMessage;
use App\Models\PublicationRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PublicacaoController extends Controller
{
    /**
     * Fila de solicitações de publicação com filtros por status.
     */
    public function index(Request $request)
    {
        $query = PublicationRequest::with([
            'site.client',
            'site.templateVersion.template',
            'assignee',
        ])->orderByDesc('created_at');

        $status = $request->query('status');
        if ($status === 'open') {
            $query->whereIn('status', PublicationRequest::OPEN_STATUSES);
        } elseif ($status === 'mine') {
            $query->where('assigned_to', auth()->id());
        } elseif ($status && in_array($status, PublicationRequest::STATUSES, true)) {
            $query->where('status', $status);
        } else {
            // default: mostra apenas abertas
            $query->whereIn('status', PublicationRequest::OPEN_STATUSES);
            $status = 'open';
        }

        $requests = $query->paginate(20)->withQueryString();

        $counts = [
            'open'                 => PublicationRequest::whereIn('status', PublicationRequest::OPEN_STATUSES)->count(),
            'requested'            => PublicationRequest::where('status', 'requested')->count(),
            'in_progress'          => PublicationRequest::where('status', 'in_progress')->count(),
            'awaiting_client_info' => PublicationRequest::where('status', 'awaiting_client_info')->count(),
            'dns_pending'          => PublicationRequest::where('status', 'dns_pending')->count(),
            'ready_to_publish'     => PublicationRequest::where('status', 'ready_to_publish')->count(),
            'published'            => PublicationRequest::where('status', 'published')->count(),
        ];

        return view('backoffice.suporte.publicacoes.index', [
            'requests' => $requests,
            'counts'   => $counts,
            'status'   => $status,
            'area'     => 'suporte',
            'page'     => $status === 'dns_pending' ? 'dns' : 'publicacoes',
        ]);
    }

    /**
     * Detalhe da solicitação: dados do assinante, domínio, checklist,
     * thread de mensagens e ações de transição.
     */
    public function show(PublicationRequest $publicacao)
    {
        $publicacao->load([
            'site.client.users',
            'site.templateVersion.template',
            'site.domain',
            'assignee',
            'messages.user',
        ]);

        return view('backoffice.suporte.publicacoes.show', [
            'pub'  => $publicacao,
            'area' => 'suporte',
            'page' => 'publicacoes',
            'statusLabels' => PublicationRequest::STATUS_LABELS,
        ]);
    }

    /**
     * Atribui a si mesmo e marca como em atendimento.
     */
    public function assign(PublicationRequest $publicacao)
    {
        $publicacao->update([
            'assigned_to'    => auth()->id(),
            'status'         => 'in_progress',
            'last_status_at' => now(),
        ]);

        ActivityLog::record(
            event:      'publication.assigned',
            description: 'Solicitação assumida pelo suporte',
            subject:    $publicacao,
            user:       auth()->user(),
        );

        return back()->with('success', 'Solicitação atribuída a você.');
    }

    /**
     * Transição genérica de status com justificativa opcional.
     */
    public function transition(Request $request, PublicationRequest $publicacao)
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(PublicationRequest::STATUSES)],
            'notes'  => ['nullable', 'string', 'max:2000'],
        ]);

        $from = $publicacao->status;

        $publicacao->update([
            'status'         => $data['status'],
            'notes'          => $data['notes'] ?? $publicacao->notes,
            'last_status_at' => now(),
        ]);

        // Se publicou, compila e grava HTML
        if ($data['status'] === 'published') {
            $site = $publicacao->site;
            try {
                $builder = app(\App\Services\SiteBuilderService::class);
                $html = $builder->build($site);
                // 'compiled_html' não está no $fillable do model Site —
                // update() descartaria o valor silenciosamente. Setando
                // o atributo direto pra garantir que persiste de verdade.
                $site->status = 'published';
                $site->compiled_html = $html;
                $site->save();
            } catch (\Throwable $e) {
                // Não quebramos a transição: log + sinalização
                ActivityLog::record(
                    event:      'publication.build_failed',
                    description: 'Falha ao compilar HTML: ' . $e->getMessage(),
                    subject:    $publicacao,
                    user:       auth()->user(),
                );
            }
        }

        ActivityLog::record(
            event:      'publication.status_changed',
            description: "Status alterado de {$from} para {$data['status']}",
            subject:    $publicacao,
            user:       auth()->user(),
        );

        return back()->with('success', 'Status atualizado.');
    }

    /**
     * Salva o apontamento DNS sugerido (dentro de domain_info.dns_target).
     */
    public function saveDns(Request $request, PublicationRequest $publicacao)
    {
        $data = $request->validate([
            'dns_type'     => ['nullable', 'string', 'max:20'],    // A, CNAME
            'dns_host'     => ['nullable', 'string', 'max:200'],   // @, www
            'dns_value'    => ['nullable', 'string', 'max:300'],   // IP ou hostname alvo
            'dns_notes'    => ['nullable', 'string', 'max:1000'],
            'dns_verified' => ['nullable', 'in:0,1'],
        ]);

        $info = $publicacao->domain_info ?? [];
        $info['dns_target'] = array_filter([
            'type'  => $data['dns_type']  ?? null,
            'host'  => $data['dns_host']  ?? null,
            'value' => $data['dns_value'] ?? null,
            'notes' => $data['dns_notes'] ?? null,
        ], fn ($v) => $v !== null && $v !== '');
        $info['dns_verified'] = ($data['dns_verified'] ?? '0') === '1';
        $info['dns_verified_at'] = $info['dns_verified'] ? now()->toDateTimeString() : null;

        $publicacao->update(['domain_info' => $info]);

        ActivityLog::record(
            event:      'publication.dns_updated',
            description: $info['dns_verified'] ? 'DNS verificado' : 'Apontamento DNS registrado',
            subject:    $publicacao,
            user:       auth()->user(),
        );

        return back()->with('success', 'Dados de DNS salvos.');
    }

    /**
     * Posta uma mensagem na thread (suporte → cliente).
     */
    public function message(Request $request, PublicationRequest $publicacao)
    {
        $data = $request->validate([
            'body'               => ['required', 'string', 'max:4000'],
            'change_status_to'   => ['nullable', Rule::in(PublicationRequest::STATUSES)],
        ]);

        $msg = PublicationMessage::create([
            'publication_request_id' => $publicacao->id,
            'user_id'                => auth()->id(),
            'author_role'            => auth()->user()->role,
            'body'                   => $data['body'],
        ]);

        if (!empty($data['change_status_to'])) {
            $publicacao->update([
                'status'         => $data['change_status_to'],
                'last_status_at' => now(),
            ]);
        }

        ActivityLog::record(
            event:      'publication.message_sent',
            description: 'Mensagem do suporte enviada',
            subject:    $publicacao,
            user:       auth()->user(),
        );

        // TODO: disparar Notification por email para o cliente.

        return back()->with('success', 'Mensagem enviada.');
    }
}
