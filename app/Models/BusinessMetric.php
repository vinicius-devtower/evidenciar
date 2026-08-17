<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessMetric extends Model
{
    protected $fillable = [
        'month',
        'new_clients',
        'active_clients',
        'mrr_cents',
        'marketing_spend_cents',
        'leads_contacted',
        'meetings_held',
        'notes',
        'updated_by',
    ];

    protected $casts = [
        'month' => 'date',
    ];

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function mrrFormatted(): string
    {
        return 'R$ ' . number_format(($this->mrr_cents ?? 0) / 100, 2, ',', '.');
    }

    public function marketingSpendFormatted(): string
    {
        return 'R$ ' . number_format(($this->marketing_spend_cents ?? 0) / 100, 2, ',', '.');
    }
}
