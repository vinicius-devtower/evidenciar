<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['name', 'document', 'status'];

    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function sites()
    {
        return $this->hasMany(Site::class);
    }
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
    public function templates()
    {
        return $this->belongsToMany(Template::class, 'client_templates')
            ->wherePivotNull('deleted_at');
    }

    /**
     * Retorna o plano ativo do cliente (última assinatura ativa).
     * Retorna null se o cliente ainda não tiver assinatura.
     */
    public function currentPlan(): ?Plan
    {
        $sub = $this->subscriptions()
            ->where('status', 'active')
            ->whereNotNull('plan_id')
            ->latest('started_at')
            ->first();

        return $sub?->plan;
    }

    /**
     * Verifica se o cliente tem direito a uma feature via seu plano corrente.
     */
    public function hasFeature(string $key): bool
    {
        return (bool) ($this->currentPlan()?->hasFeature($key));
    }
}
