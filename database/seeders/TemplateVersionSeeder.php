<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Template;
use App\Models\TemplateVersion;

class TemplateVersionSeeder extends Seeder
{
    public function run()
    {
        $template = Template::forUser(auth()->user())->first();
        
        TemplateVersion::create([
            'template_id' => $template->id,
            'version' => '1.0.0',
            'path' => 'demo/v1',
            'is_active' => true,
        ]);
    }
}
