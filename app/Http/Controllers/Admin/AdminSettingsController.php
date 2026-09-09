<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminSettingsRequest;
use App\Models\AuditLog;
use App\Models\Setting;
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

        return view('admin.settings', [
            'settings' => $this->settings(),
        ]);
    }

    /**
     * Return current settings for the admin API.
     */
    public function apiIndex(Request $request): JsonResponse
    {
        $this->ensureSuperAdmin($request);

        return response()->json($this->settings());
    }

    /**
     * Update application system settings.
     */
    public function update(AdminSettingsRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $before = $this->settings();

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => (string) $value]);
        }

        AuditLog::create([
            'admin_id' => $request->user()->getKey(),
            'action' => 'update',
            'model_type' => Setting::class,
            'model_id' => $request->user()->getKey(),
            'changes' => [
                'before' => $before,
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
        $before = $this->settings();

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => (string) $value]);
        }

        AuditLog::create([
            'admin_id' => $request->user()->getKey(),
            'action' => 'update',
            'model_type' => Setting::class,
            'model_id' => $request->user()->getKey(),
            'changes' => [
                'before' => $before,
                'after' => $data,
            ],
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'created_at' => now(),
        ]);

        return response()->json(['message' => 'Settings saved successfully.', 'settings' => $this->settings()], 200);
    }

    private function ensureSuperAdmin(Request $request): void
    {
        abort_unless($request->user()?->isSuperAdmin(), 403, 'Super administrator access is required.');
    }

    /**
     * @return array<string, mixed>
     */
    private function settings(): array
    {
        $stored = Setting::query()->pluck('value', 'key');

        return [
            'site_name' => $stored->get('site_name', config('app.name')),
            'admin_email' => $stored->get('admin_email', config('mail.from.address', 'admin@example.com')),
            'maintenance_mode' => filter_var($stored->get('maintenance_mode', config('app.env') === 'production'), FILTER_VALIDATE_BOOLEAN),
            'max_users' => (int) $stored->get('max_users', 500),
        ];
    }
}
