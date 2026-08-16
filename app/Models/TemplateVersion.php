<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemplateVersion extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['template_id', 'version', 'path', 'is_active'];
    public function template()
    {
        return $this->belongsTo(Template::class);
    }
    public function templateVersion()
    {
        return $this->belongsTo(TemplateVersion::class);
    }
    public function sites()
    {
        return $this->hasMany(Site::class);
    }
}
