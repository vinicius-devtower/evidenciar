<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IntegrationSetting extends Model
{
    protected $fillable = [
        'provider',
        'public_key',
        'access_token',
        'client_id',
        'client_secret',
        'webhook_secret',
        'notification_url',
        'updated_by',
    ];

    // Campos sensíveis ficam criptografados em repouso no banco.
    protected $casts = [
        'access_token'   => 'encrypted',
        'client_secret'  => 'encrypted',
        'webhook_secret' => 'encrypted',
    ];

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Preview mascarado de um segredo pra exibir na tela sem vazar o
     * valor inteiro (ex.: "abcd••••••••wxyz").
     */
    public static function maskSecret(?string $value): string
    {
        if (blank($value)) {
            return '';
        }
        $len = strlen($value);
        return $len <= 8
            ? str_repeat('•', $len)
            : substr($value, 0, 4) . str_repeat('•', $len - 8) . substr($value, -4);
    }
}
