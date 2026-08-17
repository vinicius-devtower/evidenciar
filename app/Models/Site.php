<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\ActivityLog;
use App\Models\Traits\BelongsToClient;

class Site extends Model
{
    use HasFactory, SoftDeletes, BelongsToClient;
    protected $fillable = [
        'client_id',
        'template_version_id',
        'name',
        'slug',
        'status',
        'content',
        'compiled_html',
    ];
    protected $casts = [
        'content' => 'array',
    ];
    
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    public function templateVersion()
    {
        return $this->belongsTo(TemplateVersion::class);
    }
    public function users()
    {
        return $this->belongsToMany(User::class, 'site_users')
            ->withPivot('role')
            ->wherePivotNull('deleted_at');
    }
    public function domain()
    {
        return $this->hasOne(Domain::class);
    }
    public function subscription()
    {
        return $this->hasOne(Subscription::class);
    }
    public function publicationRequests()
    {
        return $this->hasMany(PublicationRequest::class);
    }
    public function hasPendingPublicationRequest(): bool
    {
        return $this->publicationRequests()
            ->where('status', 'pending')
            ->exists();
    }
    public function hasOpenPublicationRequest(): bool
    {
        return $this->publicationRequests()
            ->whereIn('status', ['requested', 'in_progress'])
            ->exists();
    }
    public function activityLogs()
    {
        return $this->morphMany(ActivityLog::class, 'subject')
            ->latest();
    }
}