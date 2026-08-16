<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ActivityLog extends Model
{
    use HasFactory;
    protected $fillable = [
        'event',
        'description',
        'subject_type',
        'subject_id',
        'user_id',
    ];
    /**
     * Entidade relacionada ao evento (polimórfico)
     */
    public function subject(): MorphTo
    {
        return $this->morphTo();
    }
    /**
     * Usuário responsável pelo evento (opcional)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    /**
     * Método centralizado para registro de eventos
     */
    public static function record(
        string $event,
        string $description,
        Model $subject,
        ?User $user = null
    ): self {
        return self::create([
            'event'        => $event,
            'description'  => $description,
            'subject_type' => get_class($subject),
            'subject_id'   => $subject->getKey(),
            'user_id'      => $user?->id,
        ]);
    }
}
