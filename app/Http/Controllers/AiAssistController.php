<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * EVA — assistente de conteúdo do editor.
 *
 * Recebe o texto atual de um campo + uma instrução ("reescrever", "encurtar",
 * "gerar do zero", etc.) e devolve uma sugestão.
 *
 * Estado atual: STUB. Se houver OPENAI_API_KEY configurada no .env, faz a
 * chamada real; caso contrário, devolve um placeholder determinístico para
 * permitir integração do front-end antes de ligar o provedor de IA.
 */
class AiAssistController extends Controller
{
    public function suggest(Request $request): JsonResponse
    {
        $data = $request->validate([
            'action'       => ['required', 'string', 'in:rewrite,shorten,expand,generate'],
            'field_label'  => ['nullable', 'string', 'max:120'],
            'current_text' => ['nullable', 'string', 'max:4000'],
            'max_chars'    => ['nullable', 'integer', 'min:10', 'max:4000'],
            'context'      => ['nullable', 'string', 'max:500'],
        ]);

        $action   = $data['action'];
        $current  = trim((string)($data['current_text'] ?? ''));
        $maxChars = $data['max_chars'] ?? 0;
        $label    = $data['field_label'] ?? 'campo';

        $apiKey = env('OPENAI_API_KEY');

        if (!$apiKey) {
            // Sem provedor configurado → devolve placeholder visível no editor
            return response()->json([
                'suggestion' => $this->fallback($action, $current, $label, $maxChars),
                'source'     => 'stub',
            ]);
        }

        try {
            $prompt = $this->buildPrompt($action, $label, $current, $maxChars, $data['context'] ?? null);

            $response = Http::withToken($apiKey)
                ->timeout(20)
                ->post('https://api.openai.com/v1/chat/completions', [
                    'model'       => env('OPENAI_MODEL', 'gpt-4o-mini'),
                    'messages'    => [
                        ['role' => 'system', 'content' => 'Você é a EVA, assistente de copywriting da Evidenciar. Responda SOMENTE com o texto sugerido, sem comentários ou aspas.'],
                        ['role' => 'user',   'content' => $prompt],
                    ],
                    'temperature' => 0.7,
                ]);

            if (!$response->ok()) {
                Log::warning('EVA: OpenAI respondeu com erro', ['status' => $response->status(), 'body' => $response->body()]);
                return response()->json([
                    'suggestion' => $this->fallback($action, $current, $label, $maxChars),
                    'source'     => 'stub-fallback',
                ]);
            }

            $suggestion = (string) ($response->json('choices.0.message.content') ?? '');
            $suggestion = trim($suggestion, " \t\n\r\0\x0B\"'");

            if ($maxChars && Str::length($suggestion) > $maxChars) {
                $suggestion = Str::limit($suggestion, $maxChars, '');
            }

            return response()->json([
                'suggestion' => $suggestion,
                'source'     => 'openai',
            ]);
        } catch (\Throwable $e) {
            Log::error('EVA: falha chamando OpenAI', ['error' => $e->getMessage()]);
            return response()->json([
                'suggestion' => $this->fallback($action, $current, $label, $maxChars),
                'source'     => 'stub-exception',
            ]);
        }
    }

    /**
     * Placeholder determinístico quando não há API key.
     */
    protected function fallback(string $action, string $current, string $label, int $maxChars): string
    {
        $base = $current !== '' ? $current : "Texto padrão para \"{$label}\".";

        $suggestion = match ($action) {
            'shorten'  => Str::limit($base, max(30, (int) ($maxChars ?: 80)), '...'),
            'expand'   => $base . ' (versão expandida com mais contexto e detalhes relevantes para o cliente).',
            'generate' => "Sugestão inicial para {$label}. Ajuste conforme o tom da sua marca.",
            default    => $base . ' — versão reescrita (EVA ainda em modo de demonstração).',
        };

        if ($maxChars && Str::length($suggestion) > $maxChars) {
            $suggestion = Str::limit($suggestion, $maxChars, '');
        }

        return $suggestion;
    }

    protected function buildPrompt(string $action, string $label, string $current, int $maxChars, ?string $context): string
    {
        $lines = [];
        $lines[] = "Campo: {$label}.";

        if ($context) {
            $lines[] = "Contexto adicional: {$context}.";
        }

        $lines[] = match ($action) {
            'rewrite'  => "Reescreva o texto abaixo de forma mais clara e persuasiva, mantendo o sentido.",
            'shorten'  => "Encurte o texto abaixo mantendo a essência.",
            'expand'   => "Expanda o texto abaixo com mais detalhes úteis, sem ficar genérico.",
            'generate' => "Gere um texto novo para este campo considerando o contexto acima.",
        };

        if ($maxChars) {
            $lines[] = "Limite: no máximo {$maxChars} caracteres.";
        }

        if ($current !== '') {
            $lines[] = "Texto atual:\n{$current}";
        }

        return implode("\n", $lines);
    }
}
