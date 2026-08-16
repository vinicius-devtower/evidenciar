<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Template;
use App\Models\TemplateVersion;
use App\Models\Client;

/**
 * Popula a biblioteca de templates padrão (Clean, Moderno, Elegante).
 * Cada template tem uma versão v1 (pasta resources/templates/<slug>/v1).
 *
 * Idempotente: reexecuções não duplicam registros.
 * Também associa todos os templates aos clientes existentes via client_templates.
 */
class TemplatesLibrarySeeder extends Seeder
{
    public function run(): void
    {
        $library = [
            [
                'slug'        => 'clean',
                'name'        => 'Clean',
                'description' => 'Visual minimalista com paleta azul/branco. Foco em clareza e leitura.',
                'path'        => 'clean/v1',
            ],
            [
                'slug'        => 'moderno',
                'name'        => 'Moderno',
                'description' => 'Estilo vibrante com paleta quente — roxo e laranja, ideal para marcas criativas.',
                'path'        => 'moderno/v1',
            ],
            [
                'slug'        => 'elegante',
                'name'        => 'Elegante',
                'description' => 'Tons escuros com detalhes dourados — visual sóbrio para marcas premium.',
                'path'        => 'elegante/v1',
            ],
        ];

        $createdTemplates = [];

        foreach ($library as $item) {
            $template = Template::withTrashed()->updateOrCreate(
                ['slug' => $item['slug']],
                [
                    'name'        => $item['name'],
                    'description' => $item['description'],
                    'status'      => 'active',
                    'deleted_at'  => null,
                ]
            );

            TemplateVersion::updateOrCreate(
                [
                    'template_id' => $template->id,
                    'version'     => '1.0.0',
                ],
                [
                    'path'      => $item['path'],
                    'is_active' => true,
                ]
            );

            $createdTemplates[] = $template->id;
        }

        // Associa todos os templates a todos os clientes existentes
        // (assinatura = acesso à biblioteca completa)
        Client::query()->get()->each(function (Client $client) use ($createdTemplates) {
            foreach ($createdTemplates as $templateId) {
                DB::table('client_templates')->updateOrInsert(
                    [
                        'client_id'   => $client->id,
                        'template_id' => $templateId,
                    ],
                    [
                        'status'      => 'active',
                        'acquired_at' => now(),
                    ]
                );
            }
        });
    }
}
