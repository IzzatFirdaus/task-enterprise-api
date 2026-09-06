<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use App\Models\AuditLog;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
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
        return TaskResource::collection(Task::query()->latest()->paginate(20))->response();
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
        return (new TaskResource($task))->response();
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

        return response()->json(['message' => 'Task reassigned.', 'task' => (new TaskResource($task->fresh()))->resolve($request)]);
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

        return response()->json(['message' => 'Task status updated.', 'task' => (new TaskResource($task->fresh()))->resolve($request)]);
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

        return response()->json(['message' => 'Task restored.', 'task' => (new TaskResource($task->fresh()))->resolve(request())]);
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
        $validated = $request->validate([
            'task_ids' => ['required', 'array', 'max:100'],
            'task_ids.*' => ['integer', 'distinct', Rule::exists('tasks', 'id')->whereNull('deleted_at')],
            'action' => ['required', 'in:delete,reassign'],
            'user_id' => ['required_if:action,reassign', 'nullable', 'exists:users,id'],
        ]);

        DB::transaction(function () use ($validated, $request): void {
            $tasks = Task::query()->whereIn('id', $validated['task_ids'])->lockForUpdate()->get();

            foreach ($tasks as $task) {
                if ($validated['action'] === 'delete') {
                    $this->logTaskAction($task, 'task_deleted', ['deleted_at' => $task->deleted_at], ['deleted_at' => now()->toDateTimeString()], $request);
                    $task->delete();
                }

                if ($validated['action'] === 'reassign') {
                    $before = ['user_id' => $task->user_id];
                    $task->update(['user_id' => $validated['user_id']]);
                    $after = ['user_id' => $task->fresh()->user_id];
                    $this->logTaskAction($task, 'task_reassigned', $before, $after, $request);
                }
            }
        });

        return redirect()->route('admin.tasks.index')->with('status', 'Bulk task action completed.');
    }

    /**
     * Execute a bulk task action through the admin API.
     */
    public function apiBulkAction(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'task_ids' => ['required', 'array', 'max:100'],
            'task_ids.*' => ['integer', 'distinct', Rule::exists('tasks', 'id')->whereNull('deleted_at')],
            'action' => ['required', 'in:delete,reassign'],
            'user_id' => ['required_if:action,reassign', 'nullable', 'exists:users,id'],
        ]);

        $count = DB::transaction(function () use ($validated, $request): int {
            $tasks = Task::query()->whereIn('id', $validated['task_ids'])->lockForUpdate()->get();

            foreach ($tasks as $task) {
                if ($validated['action'] === 'delete') {
                    $this->logTaskAction($task, 'task_deleted', ['deleted_at' => $task->deleted_at], ['deleted_at' => now()->toDateTimeString()], $request);
                    $task->delete();
                }

                if ($validated['action'] === 'reassign') {
                    $before = ['user_id' => $task->user_id];
                    $task->update(['user_id' => $validated['user_id']]);
                    $after = ['user_id' => $task->fresh()->user_id];
                    $this->logTaskAction($task, 'task_reassigned', $before, $after, $request);
                }
            }

            return $tasks->count();
        });

        return response()->json(['message' => 'Bulk task action completed.', 'count' => $count], 200);
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
