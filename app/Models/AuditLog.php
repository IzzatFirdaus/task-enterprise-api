<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuditLog extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'admin_id',
        'action',
        'model_type',
        'model_id',
        'changes',
        'ip_address',
        'user_agent',
        'created_at',
    ];

    protected $casts = [
        'changes' => 'array',
        'created_at' => 'datetime',
    ];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function getModelAttribute(): ?Model
    {
        if ($this->model_type === null || $this->model_id === null) {
            return null;
        }

        $className = '\\App\\Models\\'.$this->model_type;

        if (! class_exists($className)) {
            return null;
        }

        return $className::query()->find($this->model_id);
    }

    public function scopeRecent(Builder $query): Builder
    {
        return $query->orderByDesc('created_at');
    }

    public function scopeByAdmin(Builder $query, int $adminId): Builder
    {
        return $query->where('admin_id', $adminId);
    }

    public function scopeByModel(Builder $query, string $modelType): Builder
    {
        return $query->where('model_type', $modelType);
    }

    public function scopeByAction(Builder $query, string $action): Builder
    {
        return $query->where('action', $action);
    }

    protected function humanAction(): Attribute
    {
        return Attribute::make(
            get: fn () => ucfirst(str_replace('_', ' ', (string) $this->action))
        );
    }
}
