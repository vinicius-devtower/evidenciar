<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Site;
use App\Models\Client;
use App\Models\TemplateVersion;

class SiteSeeder extends Seeder
{
    public function run()
    {
        Site::create([
            'client_id' => Client::first()->id,
            'template_version_id' => TemplateVersion::first()->id,
            'name' => 'Site Demo',
            'slug' => 'site-demo',
            'status' => 'draft',
            'content' => [
                'hero_title' => 'Bem-vindo ao Site Demo',
                'hero_subtitle' => 'Este é um site de exemplo',
            ],
        ]);
    }
}

