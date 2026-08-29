<?php

namespace App\Http\Requests\Admin;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;

class SuspendUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $target = $this->route('user');
        $actor = $this->user();

        if ($target instanceof Collection) {
            $target = $target->first();
        }

        if (! $target instanceof User && is_numeric($target)) {
            $target = User::query()->find($target);
        }

        if ($target instanceof Model && ! $target instanceof User) {
            $target = User::query()->find($target->getKey());
        }

        if ($target === null || $actor === null) {
            return false;
        }

        return $target instanceof User
            && ! $target->isAdmin()
            && $actor->getKey() !== $target->getKey()
            && $actor->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'reason' => ['required', 'string', 'max:500'],
            'is_suspended' => ['sometimes', 'boolean'],
        ];
    }
}
