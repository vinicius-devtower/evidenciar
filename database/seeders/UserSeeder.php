<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Client;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        $client = Client::first();

        User::create([
            'client_id' => $client->id,
            'name' => 'Admin Demo',
            'email' => 'admin@demo.com',
            'password' => Hash::make('password'),
        ]);
    }
}
