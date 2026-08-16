<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PublicationMessage extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'publication_request_id',
        'user_id',
        'author_role',
        'body',
        'attachments',
        'read_at',
    ];

    protected $casts = [
        'attachments' => 'array',
        'read_at'     => 'datetime',
    ];

    public function publicationRequest()
    {
        return $this->belongsTo(PublicationRequest::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function fromClient(): bool
    {
        return $this->author_role === 'client';
    }

    public function fromSupport(): bool
    {
        return in_array($this->author_role, ['support', 'admin'], true);
    }
}
