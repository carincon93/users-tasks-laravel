<?php

namespace App\Tasks\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexTaskRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'nullable|string',
            'description' => 'nullable|string',
            'is_completed' => 'nullable|boolean',
            'offset' => 'nullable|integer',
            'limit' => 'nullable|integer',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_completed' => $this->is_completed === NULL ? NULL : ($this->is_completed === 'true' ? true : false),
            'offset' => $this->offset === NULL ? 0 : $this->offset,
            'limit' => $this->limit === NULL ? 10 : $this->limit,
        ]);
    }
}
