<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Site;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class SiteUserSeeder extends Seeder
{
    public function run()
    {
        DB::table('site_users')->insert([
            'site_id' => Site::first()->id,
            'user_id' => User::first()->id,
            'role' => 'owner',
        ]);
    }
}