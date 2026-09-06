<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SuspendUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\AuditLog;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class UserManagementController extends Controller
{
    /**
     * Display the user management list.
     */
    public function index(): View
    {
        $users = User::query()->with('roles')->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Return all users for the admin API.
     */
    public function apiIndex(): JsonResponse
    {
        return UserResource::collection(User::query()->with('roles')->latest()->paginate(20))->response();
    }

    /**
     * Display the user edit form.
     */
    public function edit(User $user): View
    {
        $this->ensureAdministratorTargetIsProtected($user, request());

        return view('admin.users.edit', [
            'user' => $user->load('roles'),
            'roles' => Role::query()->get(),
        ]);
    }

    /**
     * Return a single user for the admin API.
     */
    public function apiShow(User $user): JsonResponse
    {
        return (new UserResource($user->load('roles')))->response();
    }

    /**
     * Update a user record.
     */
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $before = [
            'name' => $user->name,
            'email_hash' => hash('sha256', mb_strtolower($user->email)),
            'roles' => $user->roles()->pluck('name')->all(),
        ];

        $data = $request->validated();

        if (isset($data['roles'])) {
            $user->roles()->sync($data['roles']);
            unset($data['roles']);
        }

        if (array_key_exists('is_suspended', $data)) {
            $data['is_suspended'] = (bool) $data['is_suspended'];
        }

        $user->fill($data);
        $user->save();

        $after = [
            'name' => $user->fresh()->name,
            'email_hash' => hash('sha256', mb_strtolower((string) $user->fresh()->email)),
            'roles' => $user->fresh()->roles()->pluck('name')->all(),
        ];

        $this->logUserAction($user, 'user_updated', $before, $after, $request);

        return redirect()->route('admin.users.index')->with('status', 'User updated successfully.');
    }

    /**
     * Update a user via the admin API.
     */
    public function apiUpdate(UpdateUserRequest $request, User $user): JsonResponse
    {
        $before = [
            'name' => $user->name,
            'email_hash' => hash('sha256', mb_strtolower($user->email)),
            'roles' => $user->roles()->pluck('name')->all(),
        ];

        $data = $request->validated();

        if (isset($data['roles'])) {
            $user->roles()->sync($data['roles']);
            unset($data['roles']);
        }

        $user->fill($data);
        $user->save();

        $after = [
            'name' => $user->fresh()->name,
            'email_hash' => hash('sha256', mb_strtolower((string) $user->fresh()->email)),
            'roles' => $user->fresh()->roles()->pluck('name')->all(),
        ];

        $this->logUserAction($user, 'user_updated', $before, $after, $request);

        return (new UserResource($user->fresh()->load('roles')))->response();
    }

    /**
     * Suspend a user account.
     */
    public function suspend(SuspendUserRequest $request, User $user): RedirectResponse
    {
        $before = [
            'is_suspended' => (bool) $user->is_suspended,
            'suspension_reason' => $user->suspension_reason,
        ];

        $user->update([
            'is_suspended' => true,
            'suspended_at' => now(),
            'suspension_reason' => $request->input('reason'),
        ]);
        $user->tokens()->delete();

        $after = [
            'is_suspended' => true,
            'reason' => $request->input('reason'),
            'suspension_reason' => $request->input('reason'),
            'suspended_at' => $user->fresh()->suspended_at?->toDateTimeString(),
        ];

        $this->logUserAction($user, 'user_suspended', $before, $after, $request);

        return redirect()->back()->with('status', 'User suspended successfully.');
    }

    /**
     * Suspend a user via the admin API.
     */
    public function apiSuspend(SuspendUserRequest $request, User $user): JsonResponse
    {
        $before = [
            'is_suspended' => (bool) $user->is_suspended,
            'suspension_reason' => $user->suspension_reason,
        ];

        $user->update([
            'is_suspended' => true,
            'suspended_at' => now(),
            'suspension_reason' => $request->input('reason'),
        ]);

        $user->tokens()->delete();

        $after = [
            'is_suspended' => true,
            'reason' => $request->input('reason'),
            'suspension_reason' => $request->input('reason'),
            'suspended_at' => $user->fresh()->suspended_at?->toDateTimeString(),
        ];

        $this->logUserAction($user, 'user_suspended', $before, $after, $request);

        return response()->json(['message' => 'User suspended successfully.', 'user' => (new UserResource($user->fresh()))->resolve($request)]);
    }

    /**
     * Unsuspend a user account.
     */
    public function unsuspend(User $user, Request $request): RedirectResponse
    {
        $before = [
            'is_suspended' => (bool) $user->is_suspended,
            'suspension_reason' => $user->suspension_reason,
        ];

        $user->update([
            'is_suspended' => false,
            'suspended_at' => null,
            'suspension_reason' => null,
        ]);

        $after = [
            'is_suspended' => false,
            'suspension_reason' => null,
            'suspended_at' => null,
        ];

        $this->logUserAction($user, 'user_unsuspended', $before, $after, $request);

        return redirect()->back()->with('status', 'User unsuspended successfully.');
    }

    /**
     * Unsuspend a user via the admin API.
     */
    public function apiUnsuspend(User $user, Request $request): JsonResponse
    {
        $before = [
            'is_suspended' => (bool) $user->is_suspended,
            'suspension_reason' => $user->suspension_reason,
        ];

        $user->update([
            'is_suspended' => false,
            'suspended_at' => null,
            'suspension_reason' => null,
        ]);

        $after = [
            'is_suspended' => false,
            'suspension_reason' => null,
            'suspended_at' => null,
        ];

        $this->logUserAction($user, 'user_unsuspended', $before, $after, $request);

        return response()->json(['message' => 'User unsuspended successfully.', 'user' => (new UserResource($user->fresh()))->resolve($request)]);
    }

    /**
     * Assign a role to a user.
     */
    public function assignRole(User $user, Role $role, Request $request): JsonResponse
    {
        $this->ensureAdministratorTargetIsProtected($user, $request);

        $before = ['role_name' => $user->roles()->pluck('name')->all()];
        $user->roles()->syncWithoutDetaching([$role->getKey() => ['assigned_at' => now()]]);
        $after = ['role_name' => $user->fresh()->roles()->pluck('name')->all()];

        $this->logUserAction($user, 'role_assigned', $before, $after, $request);

        return response()->json(['message' => 'Role assigned.']);
    }

    /**
     * Assign a role through the admin API.
     */
    public function apiAssignRole(User $user, string $role, Request $request): JsonResponse
    {
        $this->ensureAdministratorTargetIsProtected($user, $request);

        if (in_array($role, [Role::ADMIN, Role::SUPER_ADMIN], true) && ! $request->user()?->isSuperAdmin()) {
            abort(403, 'Only super administrators can assign administrative roles.');
        }

        $before = ['role_name' => $user->roles()->pluck('name')->first()];
        $roleModel = Role::query()->where('name', $role)->firstOrFail();
        $user->roles()->syncWithoutDetaching([$roleModel->getKey() => ['assigned_at' => now()]]);
        $after = ['role_name' => $role];

        $this->logUserAction($user, 'role_assigned', $before, $after, $request);

        return response()->json(['message' => 'Role assigned.', 'user' => (new UserResource($user->fresh()->load('roles')))->resolve($request)]);
    }

    /**
     * Remove a role from a user.
     */
    public function removeRole(User $user, string $role, Request $request)
    {
        $this->ensureAdministratorTargetIsProtected($user, $request);

        DB::transaction(function () use ($user, $role, $request): void {
            $lockedUser = User::query()->whereKey($user->getKey())->lockForUpdate()->firstOrFail();

            if ($role === Role::SUPER_ADMIN && $lockedUser->hasRole(Role::SUPER_ADMIN) && User::query()->whereHas('roles', fn ($query) => $query->where('name', Role::SUPER_ADMIN))->lockForUpdate()->count() < 3) {
                abort(403, 'A second super administrator is required before removing this role.');
            }

            $roleModel = Role::query()->where('name', $role)->firstOrFail();
            $before = ['role_name' => $lockedUser->roles()->pluck('name')->first()];
            $lockedUser->roles()->detach($roleModel->getKey());
            $after = ['role_name' => $lockedUser->fresh()->roles()->pluck('name')->first()];

            $this->logUserAction($lockedUser, 'role_removed', $before, $after, $request);
        });

        return redirect()->back()->with('status', 'Role removed successfully.');
    }

    /**
     * Remove a role through the admin API.
     */
    public function apiRemoveRole(User $user, string $role, Request $request): JsonResponse
    {
        $this->ensureAdministratorTargetIsProtected($user, $request);

        DB::transaction(function () use ($user, $role, $request): void {
            $lockedUser = User::query()->whereKey($user->getKey())->lockForUpdate()->firstOrFail();

            if ($role === Role::SUPER_ADMIN && $lockedUser->hasRole(Role::SUPER_ADMIN) && User::query()->whereHas('roles', fn ($query) => $query->where('name', Role::SUPER_ADMIN))->lockForUpdate()->count() < 3) {
                abort(403, 'A second super administrator is required before removing this role.');
            }

            $roleModel = Role::query()->where('name', $role)->firstOrFail();
            $before = ['role_name' => $lockedUser->roles()->pluck('name')->first()];
            $lockedUser->roles()->detach($roleModel->getKey());
            $after = ['role_name' => $lockedUser->fresh()->roles()->pluck('name')->first()];

            $this->logUserAction($lockedUser, 'role_removed', $before, $after, $request);
        });

        return response()->json(['message' => 'Role removed.', 'user' => (new UserResource($user->fresh()->load('roles')))->resolve($request)]);
    }

    /**
     * Delete a user record.
     */
    public function destroy(User $user, Request $request): RedirectResponse
    {
        $this->ensureAdministratorTargetIsProtected($user, $request);

        DB::transaction(function () use ($user, $request): void {
            $lockedUser = User::query()->whereKey($user->getKey())->lockForUpdate()->firstOrFail();

            if ($lockedUser->isSuperAdmin() && User::query()->whereHas('roles', fn ($query) => $query->where('name', Role::SUPER_ADMIN))->lockForUpdate()->count() <= 1) {
                abort(403, 'The sole super administrator cannot be deleted.');
            }

            $before = ['name' => $lockedUser->name, 'email_hash' => hash('sha256', mb_strtolower($lockedUser->email))];
            $this->logUserAction($lockedUser, 'user_deleted', $before, ['status' => 'deleted'], $request);
            $lockedUser->tokens()->delete();
            $lockedUser->delete();
        });

        return redirect()->route('admin.users.index')->with('status', 'User deleted.');
    }

    /**
     * Delete a user via the admin API.
     */
    public function apiDestroy(User $user, Request $request): JsonResponse
    {
        $this->ensureAdministratorTargetIsProtected($user, $request);

        DB::transaction(function () use ($user, $request): void {
            $lockedUser = User::query()->whereKey($user->getKey())->lockForUpdate()->firstOrFail();

            if ($lockedUser->isSuperAdmin() && User::query()->whereHas('roles', fn ($query) => $query->where('name', Role::SUPER_ADMIN))->lockForUpdate()->count() <= 1) {
                abort(403, 'The sole super administrator cannot be deleted.');
            }

            $before = ['name' => $lockedUser->name, 'email_hash' => hash('sha256', mb_strtolower($lockedUser->email))];
            $this->logUserAction($lockedUser, 'user_deleted', $before, ['status' => 'deleted'], $request);
            $lockedUser->tokens()->delete();
            $lockedUser->delete();
        });

        return response()->json(['message' => 'User deleted.'], 200);
    }

    private function logUserAction(User $user, string $action, array $before, array $after, Request $request): void
    {
        AuditLog::create([
            'admin_id' => $request->user()?->getKey(),
            'action' => $action,
            'model_type' => 'User',
            'model_id' => $user->getKey(),
            'changes' => ['before' => $before, 'after' => $after],
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'created_at' => now(),
        ]);
    }

    private function ensureAdministratorTargetIsProtected(User $user, Request $request): void
    {
        if ($user->isAdmin() && ! $request->user()?->isSuperAdmin()) {
            abort(403, 'Only super administrators can manage administrator accounts.');
        }
    }
}
