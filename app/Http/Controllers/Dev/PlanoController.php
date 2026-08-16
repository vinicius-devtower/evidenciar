<?php

namespace App\Http\Controllers\Dev;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Plan;
use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PlanoController extends Controller
{
    public function index()
    {
        $plans = Plan::with('templates')->orderBy('name')->get();
        return view('backoffice.dev.planos.index', [
            'plans' => $plans,
            'area'  => 'dev',
            'page'  => 'planos',
        ]);
    }

    public function create()
    {
        return view('backoffice.dev.planos.form', [
            'plan'      => new Plan(['is_active' => true, 'billing_cycle' => 'monthly']),
            'templates' => Template::orderBy('name')->get(),
            'area'      => 'dev',
            'page'      => 'planos',
        ]);
    }

    public function store(Request $request)
    {
        $plan = $this->persist($request, new Plan());
        return redirect()->route('dev.planos.edit', $plan)
            ->with('success', 'Plano criado.');
    }

    public function edit(Plan $plano)
    {
        return view('backoffice.dev.planos.form', [
            'plan'      => $plano,
            'templates' => Template::orderBy('name')->get(),
            'area'      => 'dev',
            'page'      => 'planos',
        ]);
    }

    public function update(Request $request, Plan $plano)
    {
        $this->persist($request, $plano);
        return redirect()->route('dev.planos.edit', $plano)
            ->with('success', 'Plano atualizado.');
    }

    private function persist(Request $request, Plan $plan): Plan
    {
        $data = $request->validate([
            'slug'               => ['required', 'string', 'max:50'],
            'name'               => ['required', 'string', 'max:100'],
            'description'        => ['nullable', 'string', 'max:500'],
            'price_cents'        => ['required', 'integer', 'min:0'],
            'annual_price_cents' => ['nullable', 'integer', 'min:0'],
            'billing_cycle'      => ['required', Rule::in(['monthly', 'yearly'])],
            'is_active'          => ['nullable', 'in:0,1'],
            'template_ids'       => ['nullable', 'array'],
            'template_ids.*'     => ['integer', 'exists:templates,id'],
        ]);

        $plan->fill([
            'slug'               => $data['slug'],
            'name'               => $data['name'],
            'description'        => $data['description'] ?? null,
            'price_cents'        => $data['price_cents'],
            // Vazio = cai no fallback de 20% OFF calculado (ver Plan::annualPriceCents()).
            'annual_price_cents' => $data['annual_price_cents'] ?? null,
            'billing_cycle'      => $data['billing_cycle'],
            'is_active'          => ($data['is_active'] ?? '0') === '1',
        ])->save();

        $plan->templates()->sync($data['template_ids'] ?? []);

        ActivityLog::record(
            event:      $plan->wasRecentlyCreated ? 'plan.created' : 'plan.updated',
            description: "Plano {$plan->slug}",
            subject:    $plan,
            user:       auth()->user(),
        );

        return $plan;
    }
}
