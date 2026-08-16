<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\BelongsToClient;
class ClientTemplate extends Model
{
    use HasFactory, SoftDeletes, BelongsToClient;
    protected $table = 'client_templates';
    protected $fillable = ['client_id', 'template_id', 'status', 'acquired_at'];
}
