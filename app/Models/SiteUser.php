<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SiteUser extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'site_users';
    protected $fillable = ['site_id', 'user_id', 'role'];
}
