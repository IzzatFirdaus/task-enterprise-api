<?php

namespace App\Livewire;

use Illuminate\Validation\Rule;
use Livewire\Component;

class TaskFilter extends Component
{
    public string $status = 'all';

    public function updatedStatus(string $status): void
    {
        validator(['status' => $status], [
            'status' => [Rule::in(['all', 'pending', 'in_progress', 'completed'])],
        ])->validate();

        $this->dispatch('status-changed', status: $status);
    }

    public function render()
    {
        return view('livewire.task-filter');
    }
}
