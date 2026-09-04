<?php

namespace App\Livewire;

use App\Models\Task;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;

class EditTask extends Component
{
    public bool $isOpen = false;

    public bool $isPage = false;

    public ?int $taskId = null;

    public string $title = '';

    public string $description = '';

    public string $status = 'pending';

    public function mount(?int $taskId = null): void
    {
        if ($taskId !== null) {
            $this->loadTask($taskId);
            $this->isOpen = true;
            $this->isPage = true;
        }
    }

    protected function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:3', 'max:255'],
            'description' => ['nullable', 'string', 'max:5000'],
            'status' => ['required', Rule::in(['pending', 'in_progress', 'completed'])],
        ];
    }

    #[On('edit-task')]
    public function openEditor(int $taskId): void
    {
        $this->loadTask($taskId);
        $this->isOpen = true;
    }

    private function loadTask(int $taskId): void
    {
        $task = $this->tasks()->findOrFail($taskId);
        $this->taskId = $task->getKey();
        $this->title = $task->title;
        $this->description = $task->description ?? '';
        $this->status = $task->status;
    }

    public function update(): void
    {
        $this->validate();

        $this->tasks()->findOrFail($this->taskId)->update([
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
        ]);

        $this->close();
        $this->dispatch('task-updated');
        session()->flash('success', 'Task updated successfully.');

        if ($this->isPage) {
            $this->redirectRoute('tasks.index');
        }
    }

    public function deleteTask(): void
    {
        $this->tasks()->findOrFail($this->taskId)->delete();
        $this->close();
        $this->dispatch('task-deleted');
        session()->flash('success', 'Task deleted successfully.');

        if ($this->isPage) {
            $this->redirectRoute('tasks.index');
        }
    }

    public function close(): void
    {
        $this->reset(['isOpen', 'taskId', 'title', 'description', 'status']);
        $this->status = 'pending';
    }

    private function tasks(): Builder
    {
        return Task::query()->where('user_id', Auth::id());
    }

    public function render()
    {
        return view('livewire.edit-task');
    }
}
