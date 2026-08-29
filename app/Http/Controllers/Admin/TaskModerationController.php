<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TaskModerationController extends Controller
{
    /**
     * Display all tasks for moderation.
     */
    public function index(): View
    {
        $tasks = Task::query()->with('user')->latest()->paginate(20);

        return view('admin.tasks.index', compact('tasks'));
    }

    /**
     * Return all tasks for the admin API.
     */
    public function apiIndex(): JsonResponse
    {
        return response()->json(Task::query()->with('user')->latest()->paginate(20));
    }

    /**
     * Display a single task for moderation.
     */
    public function show(Task $task): View
    {
        return view('admin.tasks.show', [
            'task' => $task->load('user'),
        ]);
    }

    /**
     * Return a single task for the admin API.
     */
    public function apiShow(Task $task): JsonResponse
    {
        return response()->json($task->load('user'));
    }

    /**
     * Reassign a task to another user.
     */
    public function reassignTask(Request $request, Task $task): RedirectResponse
    {
        $request->validate([
            'user_id' => ['required', 'exists:users,id'],
        ]);

        $before = ['user_id' => $task->user_id];
        $task->update(['user_id' => $request->input('user_id')]);
        $after = ['user_id' => $task->fresh()->user_id];

        $this->logTaskAction($task, 'task_reassigned', $before, $after, $request);

        return redirect()->route('admin.tasks.index')->with('status', 'Task reassigned.');
    }

    /**
     * Reassign a task through the admin API.
     */
    public function apiReassign(Request $request, Task $task): JsonResponse
    {
        $request->validate([
            'user_id' => ['required', 'exists:users,id'],
        ]);

        $before = ['user_id' => $task->user_id];
        $task->update(['user_id' => $request->input('user_id')]);
        $after = ['user_id' => $task->fresh()->user_id];

        $this->logTaskAction($task, 'task_reassigned', $before, $after, $request);

        return response()->json(['message' => 'Task reassigned.', 'task' => $task->fresh()->load('user')], 200);
    }

    /**
     * Update the task status.
     */
    public function updateStatus(Request $request, Task $task): RedirectResponse
    {
        $request->validate([
            'status' => ['required', 'in:pending,in_progress,completed'],
        ]);

        $before = ['status' => $task->status];
        $task->update(['status' => $request->input('status')]);
        $after = ['status' => $task->fresh()->status];

        $this->logTaskAction($task, 'task_status_updated', $before, $after, $request);

        return redirect()->route('admin.tasks.index')->with('status', 'Task status updated.');
    }

    /**
     * Update the task status through the admin API.
     */
    public function apiUpdateStatus(Request $request, Task $task): JsonResponse
    {
        $request->validate([
            'status' => ['required', 'in:pending,in_progress,completed'],
        ]);

        $before = ['status' => $task->status];
        $task->update(['status' => $request->input('status')]);
        $after = ['status' => $task->fresh()->status];

        $this->logTaskAction($task, 'task_status_updated', $before, $after, $request);

        return response()->json(['message' => 'Task status updated.', 'task' => $task->fresh()->load('user')], 200);
    }

    /**
     * Restore a soft deleted task.
     */
    public function restore(Task $task): RedirectResponse
    {
        $task->restore();
        $this->logTaskAction($task, 'task_restored', ['deleted_at' => $task->deleted_at], ['deleted_at' => null], request());

        return redirect()->route('admin.tasks.index')->with('status', 'Task restored.');
    }

    /**
     * Restore a soft deleted task through the admin API.
     */
    public function apiRestore(Task $task): JsonResponse
    {
        $task->restore();
        $this->logTaskAction($task, 'task_restored', ['deleted_at' => $task->deleted_at], ['deleted_at' => null], request());

        return response()->json(['message' => 'Task restored.', 'task' => $task->fresh()->load('user')], 200);
    }

    /**
     * Delete a task record.
     */
    public function deleteTask(Task $task): RedirectResponse
    {
        $this->logTaskAction($task, 'task_deleted', ['deleted_at' => $task->deleted_at], ['deleted_at' => now()->toDateTimeString()], request());
        $task->delete();

        return redirect()->route('admin.tasks.index')->with('status', 'Task deleted.');
    }

    /**
     * Delete a task through the admin API.
     */
    public function apiDelete(Task $task): JsonResponse
    {
        $this->logTaskAction($task, 'task_deleted', ['deleted_at' => $task->deleted_at], ['deleted_at' => now()->toDateTimeString()], request());
        $task->delete();

        return response()->json(['message' => 'Task deleted.'], 200);
    }

    /**
     * Perform a bulk task action.
     */
    public function bulkAction(Request $request): RedirectResponse
    {
        $request->validate([
            'task_ids' => ['required', 'array'],
            'task_ids.*' => ['integer', 'exists:tasks,id'],
            'action' => ['required', 'in:delete,reassign'],
            'user_id' => ['nullable', 'exists:users,id'],
        ]);

        $taskIds = $request->input('task_ids', []);
        $tasks = Task::query()->whereIn('id', $taskIds)->get();

        foreach ($tasks as $task) {
            if ($request->input('action') === 'delete') {
                $this->logTaskAction($task, 'task_deleted', ['deleted_at' => $task->deleted_at], ['deleted_at' => now()->toDateTimeString()], $request);
                $task->delete();
            }

            if ($request->input('action') === 'reassign' && $request->filled('user_id')) {
                $before = ['user_id' => $task->user_id];
                $task->update(['user_id' => $request->input('user_id')]);
                $after = ['user_id' => $task->fresh()->user_id];
                $this->logTaskAction($task, 'task_reassigned', $before, $after, $request);
            }
        }

        return redirect()->route('admin.tasks.index')->with('status', 'Bulk task action completed.');
    }

    /**
     * Execute a bulk task action through the admin API.
     */
    public function apiBulkAction(Request $request): JsonResponse
    {
        $request->validate([
            'task_ids' => ['required', 'array'],
            'task_ids.*' => ['integer', 'exists:tasks,id'],
            'action' => ['required', 'in:delete,reassign'],
            'user_id' => ['nullable', 'exists:users,id'],
        ]);

        $taskIds = $request->input('task_ids', []);
        $tasks = Task::query()->whereIn('id', $taskIds)->get();

        foreach ($tasks as $task) {
            if ($request->input('action') === 'delete') {
                $this->logTaskAction($task, 'task_deleted', ['deleted_at' => $task->deleted_at], ['deleted_at' => now()->toDateTimeString()], $request);
                $task->delete();
            }

            if ($request->input('action') === 'reassign' && $request->filled('user_id')) {
                $before = ['user_id' => $task->user_id];
                $task->update(['user_id' => $request->input('user_id')]);
                $after = ['user_id' => $task->fresh()->user_id];
                $this->logTaskAction($task, 'task_reassigned', $before, $after, $request);
            }
        }

        return response()->json(['message' => 'Bulk task action completed.', 'count' => $tasks->count()], 200);
    }

    private function logTaskAction(Task $task, string $action, array $before, array $after, Request $request): void
    {
        AuditLog::create([
            'admin_id' => $request->user()?->getKey(),
            'action' => $action,
            'model_type' => 'Task',
            'model_id' => $task->getKey(),
            'changes' => ['before' => $before, 'after' => $after],
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'created_at' => now(),
        ]);
    }
}
