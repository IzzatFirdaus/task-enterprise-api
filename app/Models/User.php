<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

#[Fillable(['name', 'email', 'password', 'is_suspended', 'suspended_at', 'suspension_reason', 'last_admin_action_at'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class)->withPivot(['assigned_at'])->withTimestamps();
    }

    public function auditLogs(): HasMany
    {
        return $this->hasMany(AuditLog::class, 'admin_id');
    }

    public function hasRole(string|array $roles): bool
    {
        if (is_array($roles)) {
            return collect($roles)->contains(fn (mixed $role): bool => $this->hasRole((string) $role));
        }

        $role = (string) $roles;

        if ($this->relationLoaded('roles')) {
            return $this->roles->contains(fn (Role $assignedRole): bool => $assignedRole->name === $role);
        }

        if ($this->roles()->exists()) {
            return $this->roles()->where('name', $role)->exists();
        }

        if ($role === Role::ADMIN && (bool) $this->getRawOriginal('is_admin')) {
            return true;
        }

        return $this->getRawOriginal('role') === $role;
    }

    /**
     * Determine whether the user has at least one of the given roles.
     *
     * @param  array<int, string>  $roles
     */
    public function hasAnyRole(array $roles): bool
    {
        return $this->hasRole($roles);
    }

    public function isSuperAdmin(): bool
    {
        return $this->hasRole(Role::SUPER_ADMIN);
    }

    public function isAdmin(): bool
    {
        return $this->hasRole([Role::ADMIN, Role::SUPER_ADMIN]);
    }

    public function canModerate(): bool
    {
        return $this->hasRole([Role::MODERATOR, Role::ADMIN, Role::SUPER_ADMIN]);
    }

    public function getIsAdminAttribute(): bool
    {
        return $this->isAdmin();
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
            'is_suspended' => 'boolean',
            'suspended_at' => 'datetime',
            'last_admin_action_at' => 'datetime',
        ];
    }
}
