<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class AdminAnalyticsController extends Controller
{
    /**
     * Return the overview dashboard metrics.
     */
    public function dashboard(): JsonResponse
    {
        return response()->json([
            'total_users' => User::query()->count(),
            'total_tasks' => Task::query()->count(),
            'active_users' => User::query()->where('is_suspended', false)->count(),
            'suspended_users' => User::query()->where('is_suspended', true)->count(),
            'recent_activity' => AuditLog::query()->count(),
            'tasks_by_status' => Task::query()->selectRaw('status, COUNT(*) as total')->groupBy('status')->pluck('total', 'status')->toArray(),
        ]);
    }

    /**
     * Return analytics for user activity.
     */
    public function users(): JsonResponse
    {
        return response()->json([
            'total_users' => User::query()->count(),
            'active_users' => User::query()->where('is_suspended', false)->count(),
            'suspended_users' => User::query()->where('is_suspended', true)->count(),
            'new_users_this_week' => User::query()->where('created_at', '>=', now()->subWeek())->count(),
        ]);
    }

    /**
     * Return analytics for task operations.
     */
    public function tasks(): JsonResponse
    {
        return response()->json([
            'total_tasks' => Task::query()->count(),
            'pending_tasks' => Task::query()->where('status', 'pending')->count(),
            'in_progress_tasks' => Task::query()->where('status', 'in_progress')->count(),
            'completed_tasks' => Task::query()->where('status', 'completed')->count(),
            'tasks_by_status' => Task::query()->selectRaw('status, COUNT(*) as total')->groupBy('status')->pluck('total', 'status')->toArray(),
        ]);
    }
}
