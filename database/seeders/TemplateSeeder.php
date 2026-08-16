<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Template;

class TemplateSeeder extends Seeder
{
    public function run()
    {
        Template::create([
            'name' => 'Demo',
            'slug' => 'demo',
            'description' => 'Template padrão',
            'status' => 'active',
        ]);
    }
}
