<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Template;
use App\Models\TemplateVersion;

/**
 * Cria (ou atualiza, se já existir) o template padrão "Clean" e a versão v1.
 *
 * Idempotente: pode ser executado várias vezes sem duplicar registros.
 */
class CleanTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $template = Template::withTrashed()->updateOrCreate(
            ['slug' => 'clean'],
            [
                'name'        => 'Clean',
                'description' => 'Template padrão com 4 seções: apresentação, sobre, serviços e contato.',
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
                'path'      => 'clean/v1',
                'is_active' => true,
            ]
        );
    }
}
