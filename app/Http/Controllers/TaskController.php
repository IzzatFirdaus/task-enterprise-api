<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse|View
    {
        $tasks = Task::query()
            ->forUser($request->user())
            ->latest()
            ->paginate(15);

        return $request->expectsJson()
            ? response()->json($tasks)
            : view('tasks.index', ['tasks' => $tasks]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $validated['user_id'] = $request->user()->getKey();

        $task = Task::create($validated);

        return response()->json($task, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Task $task): JsonResponse|View
    {
        $this->ensureOwnership($request, $task);

        return $request->expectsJson()
            ? response()->json($task)
            : view('tasks.show', ['task' => $task]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Task $task): View
    {
        $this->ensureOwnership($request, $task);

        return view('tasks.edit', ['task' => $task]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task): JsonResponse
    {
        $this->ensureOwnership($request, $task);
        $task->update($request->validated());

        return response()->json($task->refresh());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Task $task): Response
    {
        $this->ensureOwnership($request, $task);
        $task->delete();

        return response()->noContent();
    }

    private function ensureOwnership(Request $request, Task $task): void
    {
        abort_unless($task->isOwnedBy($request->user()), 403);
    }
}
