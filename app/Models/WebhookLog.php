<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class WebhookLog extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['provider', 'event', 'payload', 'received_at'];
    protected $casts = [
        'payload'     => 'array',
        'received_at' => 'datetime',
    ];
}
