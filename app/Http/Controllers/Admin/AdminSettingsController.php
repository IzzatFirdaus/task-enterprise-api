<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminSettingsRequest;
use App\Models\AuditLog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminSettingsController extends Controller
{
    /**
     * Display the settings view.
     */
    public function edit(Request $request): View
    {
        $this->ensureSuperAdmin($request);

        return view('admin.settings');
    }

    /**
     * Return current settings for the admin API.
     */
    public function apiIndex(Request $request): JsonResponse
    {
        $this->ensureSuperAdmin($request);

        return response()->json([
            'site_name' => config('app.name'),
            'admin_email' => config('mail.from.address', 'admin@example.com'),
            'maintenance_mode' => config('app.env') === 'production',
            'max_users' => config('app.max_users', 500),
        ]);
    }

    /**
     * Update application system settings.
     */
    public function update(AdminSettingsRequest $request): RedirectResponse
    {
        $data = $request->validated();

        foreach ($data as $key => $value) {
            config(["admin.$key" => $value]);
        }

        AuditLog::create([
            'admin_id' => $request->user()->getKey(),
            'action' => 'update',
            'model_type' => 'AdminSettings',
            'model_id' => $request->user()->getKey(),
            'changes' => [
                'before' => [],
                'after' => $data,
            ],
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'created_at' => now(),
        ]);

        return redirect()->route('admin.settings.index')->with('status', 'Settings saved successfully.');
    }

    /**
     * Update settings through the admin API.
     */
    public function apiUpdate(AdminSettingsRequest $request): JsonResponse
    {
        $data = $request->validated();

        foreach ($data as $key => $value) {
            config(["admin.$key" => $value]);
        }

        AuditLog::create([
            'admin_id' => $request->user()->getKey(),
            'action' => 'update',
            'model_type' => 'AdminSettings',
            'model_id' => $request->user()->getKey(),
            'changes' => [
                'before' => [],
                'after' => $data,
            ],
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'created_at' => now(),
        ]);

        return response()->json(['message' => 'Settings saved successfully.', 'settings' => $data], 200);
    }

    private function ensureSuperAdmin(Request $request): void
    {
        abort_unless($request->user()?->isSuperAdmin(), 403, 'Super administrator access is required.');
    }
}
