<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $user = auth()->user();

        return [
            'name' => ['required', 'max:255', Rule::unique('users')->ignore($user->id)],
            'username' => ['required', 'max:255', Rule::unique('users')->ignore($user->id)],
            'email' => ['required_with:reminder', 'nullable', 'email', Rule::unique('users')->ignore($user->id)],
            'reminder' => ['nullable'],
        ];
    }

    /**
     * Get custom error messages.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'email.required_with' => 'An e-mail address is required when you want to receive reminders.',
        ];
    }
}
