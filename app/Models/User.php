<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Seuls les super admins et admins peuvent entrer dans le back-office.
     * Les agents et clients ont un compte mais pas d'acces a /admin.
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return $this->hasAnyRole(['super_admin', 'admin']);
    }

    /**
     * Biens que ce client a mis en favoris.
     */
    public function favoriteProperties(): BelongsToMany
    {
        return $this->belongsToMany(Property::class, 'favorites')->withTimestamps();
    }

    /**
     * Biens soumis par ce client (en attente de validation, publies ou refuses).
     */
    public function submittedProperties(): HasMany
    {
        return $this->hasMany(Property::class, 'submitted_by');
    }

    /**
     * Biens geres par cet agent une fois assignes par un admin.
     */
    public function assignedProperties(): HasMany
    {
        return $this->hasMany(Property::class, 'assigned_agent_id');
    }
}
