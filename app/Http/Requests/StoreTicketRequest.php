<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTicketRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'title' => 'required|string|max:255',
            'status' => 'required|string',
            'reporter_id' => 'required|exists:users,id',
            'assignee_id' => 'nullable|exists:users,id',
            'categories' => 'required|array|min:1', 
            'categories.*' => 'exists:categories,id',
        ];

        if ($this->user && $this->user()->is_admin) {
            $rules['assignee_id'] = 'nullable|exists:users,id';
        }

        return $rules;
    }

    protected function prepareForValidation()
    {
        if (! $this->user() || ! $this->user()->is_admin) {
            $this->merge([
                'assignee_id' => null,
            ]);
        }
    }
}
