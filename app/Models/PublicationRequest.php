<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\BelongsToClient;

class PublicationRequest extends Model
{
    use HasFactory, SoftDeletes, BelongsToClient;

    /**
     * Transições conhecidas do workflow.
     *
     *  requested              → suporte ainda não pegou
     *  awaiting_client_info   → suporte devolveu pedindo mais dados
     *  in_progress            → suporte assumiu
     *  dns_pending            → aguardando propagação/validação de DNS
     *  ready_to_publish       → configurado, falta clicar publicar
     *  published              → site no ar
     *  rejected               → suporte recusou (cliente pode reabrir)
     *  cancelled              → cliente cancelou antes do atendimento
     */
    public const STATUSES = [
        'requested',
        'awaiting_client_info',
        'in_progress',
        'dns_pending',
        'ready_to_publish',
        'published',
        'rejected',
        'cancelled',
    ];

    public const OPEN_STATUSES = [
        'requested', 'awaiting_client_info', 'in_progress',
        'dns_pending', 'ready_to_publish',
    ];

    public const STATUS_LABELS = [
        'requested'            => 'Solicitado',
        'awaiting_client_info' => 'Aguardando dados do cliente',
        'in_progress'          => 'Em atendimento',
        'dns_pending'          => 'Aguardando DNS',
        'ready_to_publish'     => 'Pronto para publicar',
        'published'            => 'Publicado',
        'rejected'             => 'Rejeitado',
        'cancelled'            => 'Cancelado',
    ];

    protected $fillable = [
        'site_id',
        'client_id',
        'status',
        'notes',
        'domain_info',
        'checklist',
        'assigned_to',
        'last_status_at',
    ];

    protected $casts = [
        'domain_info'   => 'array',
        'checklist'     => 'array',
        'last_status_at'=> 'datetime',
    ];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function messages()
    {
        return $this->hasMany(PublicationMessage::class)
            ->orderBy('created_at', 'asc');
    }

    public function statusLabel(): string
    {
        return self::STATUS_LABELS[$this->status] ?? ucfirst($this->status);
    }

    public function isOpen(): bool
    {
        return in_array($this->status, self::OPEN_STATUSES, true);
    }
}
