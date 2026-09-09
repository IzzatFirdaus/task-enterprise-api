<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BulkTaskActionRequest;
use App\Http\Requests\Admin\ReassignTaskRequest;
use App\Http\Requests\Admin\UpdateTaskStatusRequest;
use App\Http\Resources\TaskResource;
use App\Jobs\ProcessAuditLog;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class TaskModerationController extends Controller
{
    private array $auditEntries = [];

    public function index(): View
    {
        $tasks = Task::query()->with('user')->latest()->paginate(20);

        return view('admin.tasks.index', compact('tasks'));
    }

    public function show(Task $task): View
    {
        return view('admin.tasks.show', [
            'task' => $task->load('user'),
        ]);
    }

    public function reassignTask(ReassignTaskRequest $request, Task $task): RedirectResponse|JsonResponse
    {
        $before = ['user_id' => $task->user_id];
        $task->update(['user_id' => $request->integer('user_id')]);
        $after = ['user_id' => $task->fresh()->user_id];

        $this->queueAuditLog($task, 'task_reassigned', $before, $after, $request);

        return $this->respond(
            $request,
            redirect()->route('admin.tasks.index')->with('status', 'Task reassigned.'),
            fn () => response()->json(['message' => 'Task reassigned.', 'task' => (new TaskResource($task->fresh()))->resolve($request)])
        );
    }

    public function updateStatus(UpdateTaskStatusRequest $request, Task $task): RedirectResponse|JsonResponse
    {
        $before = ['status' => $task->status];
        $task->update(['status' => $request->string('status')]);
        $after = ['status' => $task->fresh()->status];

        $this->queueAuditLog($task, 'task_status_updated', $before, $after, $request);

        return $this->respond(
            $request,
            redirect()->route('admin.tasks.index')->with('status', 'Task status updated.'),
            fn () => response()->json(['message' => 'Task status updated.', 'task' => (new TaskResource($task->fresh()))->resolve($request)])
        );
    }

    public function restore(Task $task): RedirectResponse|JsonResponse
    {
        $deletedAt = $task->deleted_at;
        $task->restore();

        $this->queueAuditLog($task, 'task_restored', ['deleted_at' => $deletedAt], ['deleted_at' => null], request());

        return $this->respond(
            request(),
            redirect()->route('admin.tasks.index')->with('status', 'Task restored.'),
            fn () => response()->json(['message' => 'Task restored.', 'task' => (new TaskResource($task->fresh()))->resolve(request())])
        );
    }

    public function deleteTask(Task $task): RedirectResponse|JsonResponse
    {
        $deletedAt = $task->deleted_at;
        $this->queueAuditLog($task, 'task_deleted', ['deleted_at' => $deletedAt], ['deleted_at' => now()->toDateTimeString()], request());
        $task->delete();

        return $this->respond(
            request(),
            redirect()->route('admin.tasks.index')->with('status', 'Task deleted.'),
            fn () => response()->json(['message' => 'Task deleted.'], 200)
        );
    }

    public function bulkAction(BulkTaskActionRequest $request): RedirectResponse|JsonResponse
    {
        $validated = $request->validated();
        $taskIds = $validated['task_ids'];
        $action = $validated['action'];
        $targetUserId = $validated['user_id'] ?? null;

        $processed = 0;
        $failed = [];

        foreach ($taskIds as $taskId) {
            $success = DB::transaction(function () use ($taskId, $action, $targetUserId, $request): bool {
                $task = Task::query()->where('id', $taskId)->lockForUpdate()->first();

                if (! $task) {
                    return false;
                }

                if ($action === 'delete') {
                    $this->queueAuditLog($task, 'task_deleted', ['deleted_at' => $task->deleted_at], ['deleted_at' => now()->toDateTimeString()], $request);
                    $task->delete();
                } elseif ($action === 'reassign') {
                    $before = ['user_id' => $task->user_id];
                    $task->update(['user_id' => $targetUserId]);
                    $after = ['user_id' => $task->fresh()->user_id];
                    $this->queueAuditLog($task, 'task_reassigned', $before, $after, $request);
                }

                return true;
            });

            if ($success) {
                $processed++;
            } else {
                $failed[] = $taskId;
            }
        }

        $this->flushAuditLogs();

        $message = "Bulk task action completed. Processed: {$processed}";
        if ($failed !== []) {
            $message .= '. Failed (locked or missing): '.implode(', ', $failed);
        }

        return $this->respond(
            $request,
            redirect()->route('admin.tasks.index')->with('status', $message),
            fn () => response()->json(['message' => $message, 'processed' => $processed, 'failed' => $failed], 200)
        );
    }

    private function queueAuditLog(Task $task, string $action, array $before, array $after, Request $request): void
    {
        $this->auditEntries[] = [
            'admin_id' => $request->user()?->getKey(),
            'action' => $action,
            'model_type' => 'Task',
            'model_id' => $task->getKey(),
            'changes' => ['before' => $before, 'after' => $after],
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'created_at' => now(),
        ];
    }

    private function flushAuditLogs(): void
    {
        if ($this->auditEntries !== []) {
            ProcessAuditLog::dispatchAfterResponse($this->auditEntries);
            $this->auditEntries = [];
        }
    }

    private function respond(Request $request, RedirectResponse $webResponse, callable $jsonResponse): RedirectResponse|JsonResponse
    {
        return $request->expectsJson() ? $jsonResponse() : $webResponse;
    }
}
