<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Alinha o catálogo de planos com a Landing Page.
 *
 * - essencial      -> start           (R$ 46,32)
 * - profissional   -> profissional    (R$ 97,70)
 * - premium        -> gestao_vip      (R$ 297,90)
 *
 * Também adiciona uma coluna `features` JSON, caso queiramos no futuro
 * sobrescrever a matriz padrão definida no model Plan.
 */
return new class extends Migration
{
    public function up()
    {
        if (Schema::hasTable('plans')) {
            if (!Schema::hasColumn('plans', 'features')) {
                Schema::table('plans', function (Blueprint $table) {
                    $table->json('features')->nullable()->after('is_active');
                });
            }

            // Mapeamento slug antigo => [slug novo, nome, descrição, preço em centavos]
            $map = [
                'essencial' => [
                    'slug'        => 'start',
                    'name'        => 'Start',
                    'description' => 'Site enxuto, ideal para começar sua presença digital.',
                    'price_cents' => 4632,
                ],
                'profissional' => [
                    'slug'        => 'profissional',
                    'name'        => 'Profissional',
                    'description' => 'Para quem quer crescer com mais recursos e EVA incluída.',
                    'price_cents' => 9770,
                ],
                'premium' => [
                    'slug'        => 'gestao_vip',
                    'name'        => 'Gestão VIP',
                    'description' => 'Atendimento VIP, blog, e-mail profissional e todos os recursos.',
                    'price_cents' => 29790,
                ],
            ];

            foreach ($map as $oldSlug => $data) {
                DB::table('plans')
                    ->where('slug', $oldSlug)
                    ->update([
                        'slug'        => $data['slug'],
                        'name'        => $data['name'],
                        'description' => $data['description'],
                        'price_cents' => $data['price_cents'],
                        'updated_at'  => now(),
                    ]);
            }
        }
    }

    public function down()
    {
        if (Schema::hasTable('plans')) {
            // Reverte os slugs/preços/nomes para o estado anterior.
            $reverseMap = [
                'start' => [
                    'slug'        => 'essencial',
                    'name'        => 'Essencial',
                    'description' => 'Site de uma página com template Clean.',
                    'price_cents' => 4990,
                ],
                'profissional' => [
                    'slug'        => 'profissional',
                    'name'        => 'Profissional',
                    'description' => 'Inclui Clean e Moderno.',
                    'price_cents' => 8990,
                ],
                'gestao_vip' => [
                    'slug'        => 'premium',
                    'name'        => 'Premium',
                    'description' => 'Todos os templates disponíveis.',
                    'price_cents' => 14990,
                ],
            ];

            foreach ($reverseMap as $oldSlug => $data) {
                DB::table('plans')
                    ->where('slug', $oldSlug)
                    ->update([
                        'slug'        => $data['slug'],
                        'name'        => $data['name'],
                        'description' => $data['description'],
                        'price_cents' => $data['price_cents'],
                        'updated_at'  => now(),
                    ]);
            }

            if (Schema::hasColumn('plans', 'features')) {
                Schema::table('plans', function (Blueprint $table) {
                    $table->dropColumn('features');
                });
            }
        }
    }
};
