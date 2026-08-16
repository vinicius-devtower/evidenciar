<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Template extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'slug', 'description', 'status'];
    
    public function versions()
    {
        return $this->hasMany(TemplateVersion::class);
    }
    public function clients()
    {
        return $this->belongsToMany(Client::class, 'client_templates')
            ->wherePivotNull('deleted_at');
    }

    public function plans()
    {
        return $this->belongsToMany(Plan::class, 'plan_templates')
            ->withTimestamps();
    }

    public function activeVersion()
    {
        return $this->hasOne(TemplateVersion::class)->where('is_active', true);
    }
}
