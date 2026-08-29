<?php

namespace App\Livewire;

use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;

class CreateTask extends Component
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

    public function save(): void
    {
        $this->validate();

        Task::create([
            'user_id' => Auth::id(),
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
        ]);

        $this->reset(['title', 'description', 'status']);
        $this->dispatch('task-created');
        session()->flash('success', 'Task created successfully.');
    }

    public function render()
    {
        return view('livewire.create-task');
    }
}
