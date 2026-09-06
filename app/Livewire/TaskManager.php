<?php

namespace App\Livewire;

use App\Models\Task;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class TaskManager extends Component
{
    public string $title = '';

    public string $description = '';

    public string $status = 'pending';

    protected function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:3', 'max:255'],
            'description' => ['nullable', 'string', 'max:5000'],
            'status' => ['required', Rule::in(['pending', 'in_progress', 'completed'])],
        ];
    }

    public function addTask(): void
    {
        $this->validate();

        $this->tasks()->create([
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
            'user_id' => Auth::id(),
        ]);

        $this->reset(['title', 'description', 'status']);
        session()->flash('success', 'Task added successfully.');
    }

    public function toggleStatus(int $taskId): void
    {
        $task = $this->tasks()->findOrFail($taskId);
        $statuses = ['pending', 'in_progress', 'completed'];
        $task->update(['status' => $statuses[(array_search($task->status, $statuses, true) + 1) % count($statuses)]]);
    }

    public function deleteTask(int $taskId): void
    {
        $this->tasks()->findOrFail($taskId)->delete();
        session()->flash('success', 'Task deleted.');
    }

    private function tasks(): Builder
    {
        return Task::query()->where('user_id', Auth::id());
    }

    public function render()
    {
        $stats = $this->tasks()
            ->selectRaw(
                'COUNT(*) as total, SUM(CASE WHEN status = ? THEN 1 ELSE 0 END) as pending, SUM(CASE WHEN status = ? THEN 1 ELSE 0 END) as in_progress, SUM(CASE WHEN status = ? THEN 1 ELSE 0 END) as completed',
                ['pending', 'in_progress', 'completed'],
            )
            ->first();

        return view('livewire.task-manager', [
            'tasks' => $this->tasks()->latest()->get(),
            'counts' => [
                'all' => (int) ($stats->total ?? 0),
                'pending' => (int) ($stats->pending ?? 0),
                'in_progress' => (int) ($stats->in_progress ?? 0),
                'completed' => (int) ($stats->completed ?? 0),
            ],
        ]);
    }
}
