<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckoutIntent extends Model
{
    use HasFactory;

    /** Métodos de pagamento aceitos. */
    public const METHOD_PIX    = 'pix';
    public const METHOD_BOLETO = 'boleto';
    public const METHOD_CARD   = 'credit_card';

    public const ALL_METHODS = [
        self::METHOD_PIX,
        self::METHOD_BOLETO,
        self::METHOD_CARD,
    ];

    protected $fillable = [
        'template_id',
        'plan_id',
        'external_id',
        'name',
        'email',
        'whatsapp',
        'documento',
        'amount',
        'payment_method',
        'qr_code',
        'qr_code_base64',
        'boleto_url',
        'boleto_line',
        'card_last4',
        'card_brand',
        'installments',
        'journey_data',
        'expires_at',
        'status',
    ];

    protected $casts = [
        'journey_data' => 'array',
        'expires_at'   => 'datetime',
        'amount'       => 'decimal:2',
        'installments' => 'integer',
    ];

    public function template()
    {
        return $this->belongsTo(Template::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function isPix(): bool    { return $this->payment_method === self::METHOD_PIX; }
    public function isBoleto(): bool { return $this->payment_method === self::METHOD_BOLETO; }
    public function isCard(): bool   { return $this->payment_method === self::METHOD_CARD; }
}
