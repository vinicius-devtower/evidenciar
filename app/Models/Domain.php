<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\BelongsToClient;

class Domain extends Model
{
    use HasFactory, SoftDeletes, BelongsToClient;
    public $timestamps = false;
    protected $fillable = ['site_id', 'domain', 'status'];
    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
