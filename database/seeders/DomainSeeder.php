<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Domain;
use App\Models\Site;

class DomainSeeder extends Seeder
{
    public function run()
    {
        Domain::create([
            'site_id' => Site::first()->id,
            'domain' => 'demo.local',
            'status' => 'pending',
        ]);
    }
}
