<?php

namespace App\Exceptions;

use App\Models\ErrorLog;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * Exceções com nível customizado de log.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * Exceções que não são reportadas.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * Inputs que nunca são persistidos (logs/flash).
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
        'pix_code',
        'api_token',
        'token',
        'secret',
    ];

    public function register()
    {
        $this->reportable(function (Throwable $e) {
            $this->persistErrorLog($e);
        });
    }

    /**
     * Grava a exceção na tabela error_logs.
     * Roda num try/catch defensivo — se a persistência falhar, o log de arquivo
     * do Laravel ainda registra tudo (não queremos erro dentro do handler).
     */
    protected function persistErrorLog(Throwable $e): void
    {
        try {
            // Se a tabela ainda não foi migrada (ex.: primeira migração rodando),
            // não tenta escrever. Evita loop durante setup.
            if (!Schema::hasTable('error_logs')) {
                return;
            }

            $request = request();
            $user    = Auth::user();

            $payload = null;
            if ($request && $request->isMethod('get') === false) {
                $raw = $request->input();
                $payload = Arr::except($raw, $this->dontFlash);
            }

            ErrorLog::create([
                'code'            => ErrorLog::makeCode(get_class($e), $e->getFile(), $e->getLine()),
                'severity'        => 'error',
                'exception_class' => get_class($e),
                'message'         => mb_substr($e->getMessage() ?: $e::class, 0, 4000),
                'file'            => $e->getFile(),
                'line'            => $e->getLine(),
                'trace'           => mb_substr($e->getTraceAsString(), 0, 16000),
                'url'             => $request?->fullUrl(),
                'method'          => $request?->method(),
                'request_payload' => $payload,
                'context'         => [
                    'ip'         => $request?->ip(),
                    'user_agent' => mb_substr($request?->userAgent() ?? '', 0, 500),
                    'route'      => optional($request?->route())->getName(),
                ],
                'user_id'         => $user?->id,
                'occurred_at'     => now(),
            ]);
        } catch (Throwable $inner) {
            // Silencioso de propósito. A exceção original ainda vai pro laravel.log.
            Log::warning('Falha ao persistir ErrorLog: ' . $inner->getMessage());
        }
    }
}
