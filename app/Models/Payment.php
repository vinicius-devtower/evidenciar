<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['subscription_id', 'provider', 'external_id', 'amount', 'status', 'paid_at'];
    protected $casts = ['paid_at' => 'datetime'];
    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }
}
