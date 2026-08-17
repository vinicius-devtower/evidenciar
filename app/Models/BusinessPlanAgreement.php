<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessPlanAgreement extends Model
{
    public const CURRENT_VERSION = '1.0';

    protected $fillable = ['user_id', 'version', 'agreed_at'];

    protected $casts = [
        'agreed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
