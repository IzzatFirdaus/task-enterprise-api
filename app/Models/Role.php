<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;

class Role extends Model
{
    public const SUPER_ADMIN = 'super_admin';

    public const ADMIN = 'admin';

    public const MODERATOR = 'moderator';

    public const USER = 'user';

    protected $fillable = [
        'name',
        'description',
        'is_system',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withPivot(['assigned_at'])->withTimestamps();
    }

    public function scopeIsSystem(Builder $query): Builder
    {
        return $query->where('is_system', true);
    }

    public function scopeNotSystem(Builder $query): Builder
    {
        return $query->where('is_system', false);
    }

    public function hasPermission(string $permission): bool
    {
        return $this->name === self::SUPER_ADMIN || $permission === 'view';
    }

    public function isSuperAdmin(): bool
    {
        return $this->name === self::SUPER_ADMIN;
    }

    public function isAdmin(): bool
    {
        return in_array($this->name, [self::SUPER_ADMIN, self::ADMIN], true);
    }

    public function isModerator(): bool
    {
        return $this->name === self::MODERATOR;
    }

    public static function seedDefaults(): void
    {
        $roles = [
            [
                'name' => self::SUPER_ADMIN,
                'description' => 'Full system access and security control.',
                'is_system' => true,
            ],
            [
                'name' => self::ADMIN,
                'description' => 'Administrative access for managing users and tasks.',
                'is_system' => true,
            ],
            [
                'name' => self::MODERATOR,
                'description' => 'Moderation access for task oversight.',
                'is_system' => true,
            ],
            [
                'name' => self::USER,
                'description' => 'Standard user access for personal task management.',
                'is_system' => true,
            ],
        ];

        foreach ($roles as $role) {
            DB::table('roles')->updateOrInsert(
                ['name' => $role['name']],
                [
                    'description' => $role['description'],
                    'is_system' => $role['is_system'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }

    protected static function booted(): void
    {
        static::deleting(function (self $role): void {
            if ($role->is_system) {
                throw new \RuntimeException('System roles cannot be deleted.');
            }
        });
    }
}
