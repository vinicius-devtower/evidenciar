<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Client;
use App\Models\Template;
use Illuminate\Support\Facades\DB;

class ClientTemplateSeeder extends Seeder
{
    public function run()
    {
        
        DB::table('client_templates')->insert([
            'client_id' => Client::first()->id,
            'template_id' =>  Template::forUser(auth()->user())->first()->id,
            'status' => 'active',
            'acquired_at' => now(),
        ]);
    }
}