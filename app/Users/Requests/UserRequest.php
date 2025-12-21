<?php

namespace App\Users;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'password_hash' => 'required|string|max:255',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'password_hash' => password_hash($this->password, PASSWORD_DEFAULT),
        ]);
    }
}