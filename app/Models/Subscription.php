<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\BelongsToClient;

class Subscription extends Model
{
    use HasFactory, SoftDeletes, BelongsToClient;

    protected $fillable = [
        'client_id',
        'site_id',
        'plan_id',
        'payment_method',
        'status',
        'started_at',
        'ended_at',
    ];

    protected $dates = ['started_at', 'ended_at'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
