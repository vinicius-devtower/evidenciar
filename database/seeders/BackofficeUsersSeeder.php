<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Cria usuários internos da equipe: admin, support, finance, dev.
 * Todos sem client_id (não são assinantes).
 */
class BackofficeUsersSeeder extends Seeder
{
    public function run()
    {
        $profiles = [
            'admin'   => ['Admin Evidenciar',       'admin@evidenciar.com.br'],
            'support' => ['Suporte Evidenciar',     'suporte@evidenciar.com.br'],
            'finance' => ['Financeiro Evidenciar',  'financeiro@evidenciar.com.br'],
            'dev'     => ['Dev Evidenciar',         'dev@evidenciar.com.br'],
        ];

        foreach ($profiles as $role => [$name, $email]) {
            User::updateOrCreate(
                ['email' => $email],
                [
                    'name'      => $name,
                    'password'  => Hash::make('password'),
                    'role'      => $role,
                    'client_id' => null,
                ],
            );
        }
    }
}
