<?php

namespace App\Livewire;

use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class TaskStats extends Component
{
    public int $refreshToken = 0;

    #[On('task-created')]
    #[On('task-updated')]
    #[On('task-deleted')]
    public function refreshStats(): void
    {
        $this->refreshToken++;
    }

    public function render()
    {
        $tasks = Task::query()->where('user_id', Auth::id());

        return view('livewire.task-stats', [
            'stats' => [
                'total' => (clone $tasks)->count(),
                'pending' => (clone $tasks)->byStatus('pending')->count(),
                'in_progress' => (clone $tasks)->byStatus('in_progress')->count(),
                'completed' => (clone $tasks)->byStatus('completed')->count(),
            ],
        ]);
    }
}
