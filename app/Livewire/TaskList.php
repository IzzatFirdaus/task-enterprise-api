<?php

namespace App\Livewire;

use App\Models\Task;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class TaskList extends Component
{
    use WithPagination;

    public string $status = 'all';

    #[On('status-changed')]
    public function updateStatus(string $status): void
    {
        $this->status = $status;
        $this->resetPage();
    }

    #[On('task-created')]
    #[On('task-updated')]
    #[On('task-deleted')]
    public function refreshTasks(): void
    {
        $this->resetPage();
    }

    public function editTask(int $taskId): void
    {
        $this->dispatch('edit-task', taskId: $taskId);
    }

    public function deleteTask(int $taskId): void
    {
        $this->tasks()->findOrFail($taskId)->delete();
        $this->dispatch('task-deleted');
        session()->flash('success', 'Task deleted successfully.');
    }

    private function tasks(): Builder
    {
        return Task::query()
            ->where('user_id', Auth::id())
            ->when($this->status !== 'all', fn (Builder $query) => $query->byStatus($this->status));
    }

    public function render()
    {
        return view('livewire.task-list', [
            'tasks' => $this->tasks()->latest()->paginate(10),
        ]);
    }
}
