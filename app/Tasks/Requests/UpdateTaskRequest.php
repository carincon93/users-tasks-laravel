<?php

namespace App\Tasks\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['sometimes', 'string', 'max:255'],
            'description' => ['sometimes', 'string'],
            'completed' => ['sometimes', 'boolean'],
        ];
    }

    protected function prepareForValidation(): void
    {
        // 
    }
}
