<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\PasswordCheckRule;

class SavePasswordRequest extends FormRequest
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
        return [
            'password' => ['required', 'min:3', new PasswordCheckRule()],
            'newpassword' => ['required', 'min:3', 'confirmed'],
            'newpassword_confirmation' => ['required', 'same:newpassword'],
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
            'newpassword.min' => 'The new password must be at least :min characters.',
        ];
    }
}
