<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BulkTaskActionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'task_ids' => ['required', 'array', 'max:100'],
            'task_ids.*' => ['integer', 'distinct', Rule::exists('tasks', 'id')->whereNull('deleted_at')],
            'action' => ['required', 'string', Rule::in(['delete', 'reassign'])],
            'user_id' => ['required_if:action,reassign', 'nullable', 'integer', 'exists:users,id'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'task_ids.required' => 'At least one task must be selected.',
            'task_ids.max' => 'You may bulk-act on at most 100 tasks at a time.',
            'action.required' => 'A bulk action is required.',
            'action.in' => 'The bulk action must be delete or reassign.',
            'user_id.required_if' => 'A target user is required when reassigning tasks.',
            'user_id.exists' => 'The selected user does not exist.',
        ];
    }
}
