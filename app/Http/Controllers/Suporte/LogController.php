<?php

namespace App\Http\Controllers\Suporte;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\EmailLog;
use App\Models\ErrorLog;
use App\Models\User;
use App\Models\WebhookLog;
use Illuminate\Http\Request;

/**
 * Tela de Logs do Suporte — inspirada no console de logs do OMIE.
 *
 * Unifica quatro fontes:
 *  - error_logs        (exceções da app, reportadas pelo ExceptionHandler)
 *  - webhook_logs      (payloads recebidos do Mercado Pago / outros providers)
 *  - activity_logs     (ações humanas registradas via ActivityLog::record)
 *  - email_logs        (ciclo de vida dos e-mails enviados via Mail/Notification)
 */
class LogController extends Controller
{
    /** Visão geral — contadores por tipo e por severidade das últimas 24h e 7 dias. */
    public function index()
    {
        $errorsModel = $this->errorModelExists() ? ErrorLog::query() : null;
        $emailsModel = $this->emailModelExists() ? EmailLog::query() : null;

        $stats = [
            'excecoes_24h'    => $errorsModel ? (clone $errorsModel)->where('occurred_at', '>=', now()->subDay())->count() : 0,
            'excecoes_7d'     => $errorsModel ? (clone $errorsModel)->where('occurred_at', '>=', now()->subDays(7))->count() : 0,
            'webhooks_24h'    => WebhookLog::where('received_at', '>=', now()->subDay())->count(),
            'webhooks_7d'     => WebhookLog::where('received_at', '>=', now()->subDays(7))->count(),
            'atividade_24h'   => ActivityLog::where('created_at', '>=', now()->subDay())->count(),
            'atividade_7d'    => ActivityLog::where('created_at', '>=', now()->subDays(7))->count(),
            'emails_24h'      => $emailsModel ? (clone $emailsModel)->where('created_at', '>=', now()->subDay())->count() : 0,
            'emails_7d'       => $emailsModel ? (clone $emailsModel)->where('created_at', '>=', now()->subDays(7))->count() : 0,
            'emails_falhados' => $emailsModel ? (clone $emailsModel)->where('status', 'failed')->count() : 0,
        ];

        $topCodes = [];
        if ($errorsModel) {
            $topCodes = ErrorLog::query()
                ->selectRaw('code, MAX(exception_class) as exception_class, MAX(message) as message, COUNT(*) as total, MAX(occurred_at) as last_seen')
                ->where('occurred_at', '>=', now()->subDays(7))
                ->groupBy('code')
                ->orderByDesc('total')
                ->limit(5)
                ->get();
        }

        return view('backoffice.suporte.logs.index', [
            'stats'    => $stats,
            'topCodes' => $topCodes,
            'area'     => 'suporte',
            'page'     => 'logs',
        ]);
    }

    // =========================================================================
    // EXCEÇÕES
    // =========================================================================

    public function excecoes(Request $request)
    {
        $code     = $request->query('code');
        $severity = $request->query('severity');
        $userId   = $request->query('user_id');
        $from     = $request->query('from');
        $to       = $request->query('to');
        $search   = $request->query('q');

        $query = ErrorLog::query()
            ->with('user')
            ->byCode($code)
            ->bySeverity($severity)
            ->when($userId, fn ($q) => $q->where('user_id', $userId))
            ->when($from, fn ($q) => $q->whereDate('occurred_at', '>=', $from))
            ->when($to,   fn ($q) => $q->whereDate('occurred_at', '<=', $to))
            ->when($search, fn ($q) => $q->where(function ($qq) use ($search) {
                $qq->where('message', 'like', "%{$search}%")
                   ->orWhere('exception_class', 'like', "%{$search}%")
                   ->orWhere('url', 'like', "%{$search}%");
            }))
            ->recent();

        $logs = $query->paginate(25)->withQueryString();

        $codes = ErrorLog::query()
            ->select('code')
            ->distinct()
            ->orderBy('code')
            ->pluck('code');

        return view('backoffice.suporte.logs.excecoes.index', [
            'logs'      => $logs,
            'codes'     => $codes,
            'filters'   => compact('code', 'severity', 'userId', 'from', 'to', 'search'),
            'area'      => 'suporte',
            'page'      => 'logs-excecoes',
        ]);
    }

    public function excecao(int $id)
    {
        $log = ErrorLog::with('user')->findOrFail($id);

        // Outras ocorrências do mesmo code nos últimos 30 dias (pra diagnóstico).
        $similares = ErrorLog::where('code', $log->code)
            ->where('id', '!=', $log->id)
            ->where('occurred_at', '>=', now()->subDays(30))
            ->orderByDesc('occurred_at')
            ->limit(20)
            ->get();

        return view('backoffice.suporte.logs.excecoes.show', [
            'log'       => $log,
            'similares' => $similares,
            'area'      => 'suporte',
            'page'      => 'logs-excecoes',
        ]);
    }

    // =========================================================================
    // WEBHOOKS
    // =========================================================================

    public function webhooks(Request $request)
    {
        $provider = $request->query('provider');
        $event    = $request->query('event');
        $from     = $request->query('from');
        $to       = $request->query('to');

        $logs = WebhookLog::query()
            ->when($provider, fn ($q) => $q->where('provider', $provider))
            ->when($event,    fn ($q) => $q->where('event', $event))
            ->when($from, fn ($q) => $q->whereDate('received_at', '>=', $from))
            ->when($to,   fn ($q) => $q->whereDate('received_at', '<=', $to))
            ->orderByDesc('received_at')
            ->paginate(25)
            ->withQueryString();

        $providers = WebhookLog::select('provider')->distinct()->pluck('provider');
        $events    = WebhookLog::select('event')->distinct()->pluck('event');

        return view('backoffice.suporte.logs.webhooks.index', [
            'logs'      => $logs,
            'providers' => $providers,
            'events'    => $events,
            'filters'   => compact('provider', 'event', 'from', 'to'),
            'area'      => 'suporte',
            'page'      => 'logs-webhooks',
        ]);
    }

    public function webhook(int $id)
    {
        $log = WebhookLog::findOrFail($id);

        return view('backoffice.suporte.logs.webhooks.show', [
            'log'  => $log,
            'area' => 'suporte',
            'page' => 'logs-webhooks',
        ]);
    }

    // =========================================================================
    // ATIVIDADE (activity_logs)
    // =========================================================================

    public function atividade(Request $request)
    {
        $event   = $request->query('event');
        $userId  = $request->query('user_id');
        $subject = $request->query('subject_type');
        $from    = $request->query('from');
        $to      = $request->query('to');

        $logs = ActivityLog::query()
            ->with('user')
            ->when($event,   fn ($q) => $q->where('event', $event))
            ->when($userId,  fn ($q) => $q->where('user_id', $userId))
            ->when($subject, fn ($q) => $q->where('subject_type', $subject))
            ->when($from, fn ($q) => $q->whereDate('created_at', '>=', $from))
            ->when($to,   fn ($q) => $q->whereDate('created_at', '<=', $to))
            ->orderByDesc('created_at')
            ->paginate(25)
            ->withQueryString();

        $events   = ActivityLog::select('event')->distinct()->pluck('event');
        $subjects = ActivityLog::select('subject_type')->distinct()->pluck('subject_type');

        return view('backoffice.suporte.logs.atividade.index', [
            'logs'     => $logs,
            'events'   => $events,
            'subjects' => $subjects,
            'filters'  => compact('event', 'userId', 'subject', 'from', 'to'),
            'area'     => 'suporte',
            'page'     => 'logs-atividade',
        ]);
    }

    public function atividadeItem(int $id)
    {
        $log = ActivityLog::with('user', 'subject')->findOrFail($id);

        return view('backoffice.suporte.logs.atividade.show', [
            'log'  => $log,
            'area' => 'suporte',
            'page' => 'logs-atividade',
        ]);
    }

    // =========================================================================
    // E-MAILS
    // =========================================================================

    public function emails(Request $request)
    {
        $status = $request->query('status');
        $to     = $request->query('to');
        $from   = $request->query('from');
        $until  = $request->query('until');

        $logs = EmailLog::query()
            ->with('user')
            ->byStatus($status)
            ->byRecipient($to)
            ->when($from,  fn ($q) => $q->whereDate('created_at', '>=', $from))
            ->when($until, fn ($q) => $q->whereDate('created_at', '<=', $until))
            ->recent()
            ->paginate(25)
            ->withQueryString();

        return view('backoffice.suporte.logs.emails.index', [
            'logs'    => $logs,
            'filters' => compact('status', 'to', 'from', 'until'),
            'area'    => 'suporte',
            'page'    => 'logs-emails',
        ]);
    }

    public function email(int $id)
    {
        $log = EmailLog::with('user')->findOrFail($id);

        return view('backoffice.suporte.logs.emails.show', [
            'log'  => $log,
            'area' => 'suporte',
            'page' => 'logs-emails',
        ]);
    }

    // =========================================================================
    // Helpers defensivos — se o dev ainda não rodou a migration, as rotas
    // continuam respondendo com "0" em vez de explodir.
    // =========================================================================

    protected function errorModelExists(): bool
    {
        try {
            return \Illuminate\Support\Facades\Schema::hasTable('error_logs');
        } catch (\Throwable $e) {
            return false;
        }
    }

    protected function emailModelExists(): bool
    {
        try {
            return \Illuminate\Support\Facades\Schema::hasTable('email_logs');
        } catch (\Throwable $e) {
            return false;
        }
    }
}
