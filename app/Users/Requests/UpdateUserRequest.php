<?php

namespace App\Users\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'username' =>   ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')
                    ->ignore($this->route('user')->id, 'id'),
            ],
            'password' => ['required', 'string', 'max:255'],
        ];
    }

    protected function prepareForValidation(): void
    {
        // 
    }
}
