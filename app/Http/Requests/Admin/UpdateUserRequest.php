<?php

namespace App\Http\Requests\Admin;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $target = $this->route('user');
        $actor = $this->user();

        if ($target instanceof Collection) {
            $target = $target->first();
        }

        if (! $target instanceof User && is_numeric($target)) {
            $target = User::query()->find($target);
        }

        if ($target instanceof Model && ! $target instanceof User) {
            $target = User::query()->find($target->getKey());
        }

        if (! $target instanceof User) {
            return false;
        }

        // Prevent demoting the sole super admin
        if ($this->has('roles') && $target->isSuperAdmin()) {
            $roles = $this->input('roles') ?? [];
            $superAdminRoleId = Role::query()->where('name', Role::SUPER_ADMIN)->first()?->getKey();
            if (empty($roles) || ! in_array($superAdminRoleId, $roles, true)) {
                if (User::query()->whereHas('roles', fn ($q) => $q->where('name', Role::SUPER_ADMIN))->count() <= 1) {
                    abort(403, 'Cannot demote the sole super administrator.');
                }
            }
        }

        if ($actor && $actor->isSuperAdmin()) {
            return true;
        }

        if ($actor && $actor->isAdmin() && $target->isAdmin()) {
            return false;
        }

        if ($actor && $actor->isAdmin() && $this->hasAdministrativeRoleAssignment()) {
            return false;
        }

        if ($actor && $actor->isAdmin()) {
            return true;
        }

        return false;
    }

    private function hasAdministrativeRoleAssignment(): bool
    {
        $administrativeRoleIds = Role::query()
            ->whereIn('name', [Role::ADMIN, Role::SUPER_ADMIN])
            ->pluck('id');

        return collect($this->input('roles', []))->contains(fn (mixed $roleId): bool => $administrativeRoleIds->contains((int) $roleId));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $routeUser = $this->route('user');
        $userId = $routeUser instanceof User ? $routeUser->getKey() : (int) $routeUser;

        return [
            'name' => ['sometimes', 'string', 'max:255'],
            'email' => ['sometimes', 'email', 'max:255', 'unique:users,email,'.$userId],
            'roles' => ['sometimes', 'array'],
            'roles.*' => ['integer', 'exists:roles,id'],
            'is_suspended' => ['sometimes', 'boolean'],
            'suspension_reason' => ['nullable', 'string', 'max:500'],
        ];
    }
}
