<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ErrorLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'severity',
        'exception_class',
        'message',
        'file',
        'line',
        'trace',
        'url',
        'method',
        'request_payload',
        'context',
        'user_id',
        'occurred_at',
    ];

    protected $casts = [
        'request_payload' => 'array',
        'context'         => 'array',
        'occurred_at'     => 'datetime',
    ];

    /** Gerar code curto estável (6 chars hex) a partir de origem do erro. */
    public static function makeCode(string $class, ?string $file, ?int $line): string
    {
        $key = $class . '|' . ($file ?? '') . '|' . ($line ?? '');
        return 'EVD-' . strtoupper(substr(md5($key), 0, 6));
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeByCode(Builder $q, ?string $code): Builder
    {
        return $code ? $q->where('code', $code) : $q;
    }

    public function scopeBySeverity(Builder $q, ?string $severity): Builder
    {
        return $severity ? $q->where('severity', $severity) : $q;
    }

    public function scopeRecent(Builder $q): Builder
    {
        return $q->orderByDesc('occurred_at');
    }
}
