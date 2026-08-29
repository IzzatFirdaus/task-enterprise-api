<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function dashboard(): View
    {
        return view('admin.dashboard', [
            'stats' => $this->statsData(),
            'recentActivity' => AuditLog::query()->with('admin')->latest('created_at')->limit(10)->get(),
        ]);
    }

    /**
     * Return JSON summary data for admin cards.
     */
    public function stats(): JsonResponse
    {
        return response()->json($this->statsData());
    }

    /**
     * Build the dashboard metric payload.
     *
     * @return array<string, mixed>
     */
    protected function statsData(): array
    {
        return [
            'total_users' => User::query()->count(),
            'total_tasks' => Task::query()->count(),
            'suspended_users' => User::query()->where('is_suspended', true)->count(),
            'recent_activity' => AuditLog::query()->count(),
            'tasks_by_status' => Task::query()
                ->selectRaw('status, COUNT(*) as total')
                ->groupBy('status')
                ->pluck('total', 'status')
                ->toArray(),
            'users_by_status' => User::query()
                ->selectRaw('CASE WHEN is_suspended = 1 THEN "suspended" ELSE "active" END as status, COUNT(*) as total')
                ->groupBy('status')
                ->pluck('total', 'status')
                ->toArray(),
        ];
    }
}
