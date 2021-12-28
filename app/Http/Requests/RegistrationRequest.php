<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'password' => 'required',
            'username' => 'required',
            'role' => 'required|in:admin,cashier',
            'access_permission' => 'required'
        ];
    
    }

    public function messages()
    {
        return [
            'password.required' => 'Password is required!',
            'username.required' => 'Username is required!',
            'first_name.required' => 'Firstname is required!',
            'last_name.required' => 'Lastname is required!',
            'access_permission.required' => 'Access Permission is required!',
            'role.in' => 'Role is must be admin and cashier!',

        ];
    }


}
