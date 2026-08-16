<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Uploads feitos pelo painel do cliente (editor, identidade visual, etc).
 *
 * Armazenamento: disco "public" → storage/app/public/uploads/{client_id}/...
 * O link simbólico public/storage → storage/app/public já está configurado
 * via config/filesystems.php. Basta rodar `php artisan storage:link` em deploy.
 */
class UploadController extends Controller
{
    /**
     * Upload de imagem (logo, imagens de seção).
     *
     * POST /app/uploads/image
     * Campo:  file  (arquivo)
     * Retorna: { url: "https://.../storage/uploads/123/abc.png" }
     */
    public function image(Request $request): JsonResponse
    {
        $data = $request->validate([
            'file' => [
                'required',
                'file',
                'mimes:jpg,jpeg,png,webp,gif,svg',
                'max:5120', // 5 MB
            ],
        ]);

        $user   = Auth::user();
        $client = $user?->client;

        if (!$client) {
            return response()->json([
                'message' => 'Cliente não encontrado para o usuário autenticado.',
            ], 422);
        }

        $file = $data['file'];
        $ext  = strtolower($file->getClientOriginalExtension() ?: 'bin');
        $name = Str::random(24) . '.' . $ext;
        $dir  = "uploads/{$client->id}";

        // Salva no disk público → storage/app/public/uploads/{client_id}/{name}
        $path = $file->storeAs($dir, $name, 'public');

        return response()->json([
            'url'      => Storage::disk('public')->url($path),
            'path'     => $path,
            'filename' => $file->getClientOriginalName(),
            'size'     => $file->getSize(),
        ]);
    }
}
