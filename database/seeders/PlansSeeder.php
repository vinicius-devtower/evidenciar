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
                'description'        => 'Site enxuto, ideal para começar sua presença digital.',
                'price_cents'        => 4790,
                'annual_price_cents' => 45984, // 20% OFF sobre 12x R$47,90
                'billing_cycle'      => 'monthly',
                'is_active'          => true,
                'templates'          => ['clean'],
            ],
            [
                'slug'               => Plan::SLUG_PROFISSIONAL,
                'name'               => 'Profissional',
                'description'        => 'Para quem quer crescer com mais recursos e EVA incluída.',
                'price_cents'        => 9790,
                'annual_price_cents' => 93984, // 20% OFF sobre 12x R$97,90
                'billing_cycle'      => 'monthly',
                'is_active'          => true,
                'templates'          => ['clean', 'moderno'],
            ],
            [
                'slug'               => Plan::SLUG_GESTAO_VIP,
                'name'               => 'Gestão VIP',
                'description'        => 'Atendimento VIP, blog, e-mail profissional e todos os recursos.',
                'price_cents'        => 29790,
                'annual_price_cents' => 285984, // 20% OFF sobre 12x R$297,90
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
