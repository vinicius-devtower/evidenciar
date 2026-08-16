<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PublicationRequest;
use Illuminate\Http\Request;
use App\Models\ActivityLog;

class PublicationQueueController extends Controller
{
    public function index()
    {
        $requests = PublicationRequest::with([
            'site.client',
            'site.templateVersion.template'
        ])
            ->orderBy('created_at', 'asc')
            ->get();
        return view('admin.publication_requests.index', compact('requests'));
    }
    public function start(PublicationRequest $publicationRequest)
    {
        abort_unless($publicationRequest->status === 'requested', 403);

        abort_unless(
            $publicationRequest->client_id === $publicationRequest->site->client_id,
            500
        );

        $publicationRequest->update([
            'status' => 'in_progress',
        ]);
        ActivityLog::record(
            event: 'publication.started',
            description: 'Atendimento de publicação iniciado pela equipe',
            subject: $publicationRequest,
            user: auth()->user()
        );
        return back()->with('success', 'Atendimento iniciado.');
    }

    public function publish(Request $request, PublicationRequest $publicationRequest)
    {
        abort_unless($publicationRequest->status === 'in_progress', 403);

        $site = $publicationRequest->site;

        // consistência crítica
        abort_unless(
            $publicationRequest->client_id === $site->client_id,
            500
        );

        $builder = app(\App\Services\SiteBuilderService::class);
        $html = $builder->build($site);

        \DB::transaction(function () use ($publicationRequest, $request, $site, $html) {

            // Atualiza a solicitação
            $publicationRequest->update([
                'status' => 'published',
                'notes'  => $request->input('notes'),
            ]);

            // Atualiza o site com HTML compilado
            $site->update([
                'status' => 'published',
                'compiled_html' => $html,
            ]);

            // Logs
            ActivityLog::record(
                event: 'publication.published',
                description: 'Site publicado manualmente pela equipe',
                subject: $publicationRequest,
                user: auth()->user()
            );

            ActivityLog::record(
                event: 'site.published',
                description: 'Site publicado e disponibilizado ao público',
                subject: $site,
                user: auth()->user()
            );
        });

        return back()->with('success', 'Site publicado com sucesso.');
    }

    public function reject(Request $request, PublicationRequest $publicationRequest)
    {
        abort_unless($publicationRequest->status === 'in_progress', 403);

        abort_unless(
            $publicationRequest->client_id === $publicationRequest->site->client_id,
            500
        );

        $publicationRequest->update([
            'status' => 'rejected',
            'notes'  => $request->input('notes'),
        ]);
        ActivityLog::record(
            event: 'publication.rejected',
            description: 'Solicitação de publicação rejeitada pela equipe',
            subject: $publicationRequest,
            user: auth()->user()
        );
        return back()->with('success', 'Solicitação rejeitada.');
    }
}
