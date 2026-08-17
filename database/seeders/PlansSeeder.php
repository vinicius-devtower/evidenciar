<?php

namespace Database\Seeders;

use App\Models\Plan;
use App\Models\Template;
use Illuminate\Database\Seeder;

class PlansSeeder extends Seeder
{
    public function run()
    {
        $plans = [
            [
                'slug'               => Plan::SLUG_START,
                'name'               => 'Start',
                'description'        => 'O essencial para existir no Google.',
                'price_cents'        => 4990,  // R$49,90 — conforme plano de negócios
                'annual_price_cents' => 49900, // R$499,00 (10x — "pague 10, leve 12")
                'billing_cycle'      => 'monthly',
                'is_active'          => true,
                'templates'          => ['clean'],
            ],
            [
                'slug'               => Plan::SLUG_PROFISSIONAL,
                'name'               => 'Profissional',
                'description'        => 'Para quem quer passar mais autoridade e conteúdo.',
                'price_cents'        => 8990,  // R$89,90 — conforme plano de negócios
                'annual_price_cents' => 89900, // R$899,00
                'billing_cycle'      => 'monthly',
                'is_active'          => true,
                'templates'          => ['clean', 'moderno'],
            ],
            [
                'slug'               => Plan::SLUG_GESTAO_VIP,
                'name'               => 'Gestão VIP',
                'description'        => 'Para quem não tem tempo a perder — nós editamos pra você.',
                'price_cents'        => 18990,  // R$189,90 — conforme plano de negócios
                'annual_price_cents' => 189900, // R$1.899,00
                'billing_cycle'      => 'monthly',
                'is_active'          => true,
                'templates'          => ['clean', 'moderno', 'elegante'],
            ],
        ];

        // Limpa slugs legados caso o banco já tenha passado por um seed anterior
        // que populou 'essencial' / 'premium' sem rodar a migration de rename.
        Plan::whereIn('slug', ['essencial', 'premium'])->delete();

        foreach ($plans as $data) {
            $slugs = $data['templates'];
            unset($data['templates']);

            $plan = Plan::updateOrCreate(['slug' => $data['slug']], $data);

            $templateIds = Template::whereIn('slug', $slugs)->pluck('id')->all();
            $plan->templates()->sync($templateIds);
        }
    }
}
