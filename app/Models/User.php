<?php
namespace App\Models;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Mail\PasswordResetMail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;
    protected $fillable = ['client_id', 'name', 'email', 'password', 'role'];
    protected $hidden = [
        'password',
    ];

    /** Perfis reconhecidos pelo sistema. */
    public const ROLES = ['client', 'admin', 'support', 'finance', 'dev'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    public function sites()
    {
        return $this->belongsToMany(Site::class, 'site_users')
            ->withPivot('role')->wherePivotNull('deleted_at');
    }
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function hasAccessToSite($site): bool
    {
        return $this->client_id === $site->client_id;
    }

    /**
     * Verifica se o usuário possui um (ou qualquer um dos) role(s) informado(s).
     * Admin é tratado como um superperfil que tem acesso a TODAS as áreas.
     */
    public function hasRole(string ...$roles): bool
    {
        if (empty($roles)) {
            return false;
        }
        if ($this->role === 'admin') {
            return true;
        }
        return in_array($this->role, $roles, true);
    }

    /** Atalhos convenientes para views/middleware. */
    public function isClient(): bool   { return $this->role === 'client'; }
    public function isAdmin(): bool    { return $this->role === 'admin'; }
    public function isSupport(): bool  { return in_array($this->role, ['support', 'admin'], true); }
    public function isFinance(): bool  { return in_array($this->role, ['finance', 'admin'], true); }
    public function isDev(): bool      { return in_array($this->role, ['dev', 'admin'], true); }
    public function isBackoffice(): bool
    {
        return in_array($this->role, ['admin', 'support', 'finance', 'dev'], true);
    }

    /**
     * Envia o e-mail de recuperação de senha usando o Mailable Evidenciar
     * (PT-BR + identidade visual), sobrescrevendo a notificação default do Laravel.
     */
    public function sendPasswordResetNotification($token): void
    {
        $resetUrl = url(route('password.reset', [
            'token' => $token,
            'email' => $this->getEmailForPasswordReset(),
        ], false));

        Mail::to($this->getEmailForPasswordReset())
            ->send(new PasswordResetMail($this, $resetUrl));
    }
}
