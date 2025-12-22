<?php

namespace App\Users\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255' . $this->route('user')->id . ',id',
            'password' => 'required|string|max:255',
        ];
    }

    protected function prepareForValidation(): void
    {
        // 
    }
}
