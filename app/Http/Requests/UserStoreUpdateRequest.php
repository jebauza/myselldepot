<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserStoreUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;//auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $user_id = $this->route('id') ?? null;
        return [
            'firstname' => 'required|string|max:255',
            'secondname' => 'nullable|string|max:255',
            'lastname' => 'required|string|max:255',
            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users', 'username')->ignore($user_id)
            ],
            'email' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users', 'email')->ignore($user_id)
            ],
            'password' => 'required|string|max:255',
            'image' => 'nullable|file',
        ];
    }
}
