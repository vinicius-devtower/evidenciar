<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailLog extends Model
{
    use HasFactory;

    public const STATUSES = ['sending', 'sent', 'failed'];

    protected $fillable = [
        'to',
        'subject',
        'mailable_class',
        'status',
        'error',
        'meta',
        'user_id',
        'sent_at',
    ];

    protected $casts = [
        'meta'    => 'array',
        'sent_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeByStatus(Builder $q, ?string $status): Builder
    {
        return $status ? $q->where('status', $status) : $q;
    }

    public function scopeByRecipient(Builder $q, ?string $to): Builder
    {
        return $to ? $q->where('to', 'like', '%' . $to . '%') : $q;
    }

    public function scopeRecent(Builder $q): Builder
    {
        return $q->orderByDesc('created_at');
    }
}
