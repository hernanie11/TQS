<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MemberRequest extends FormRequest
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
        //     'mobile_number' => 'required|regex:[63]|numeric|digits:12',
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'gender' => 'required|in:male,female',
            'mobile_number' => 'required|regex:[09]|numeric|digits:11',
            'birthday' => 'required',
            'barangay' => 'required',
            'municipality' => 'required',
            'province' => 'required',
            'email' => 'required|email',
        ];
    }

    public function messages()
    {
        //'mobile_number.regex' => 'Contact No. must start with 63!!'
    return [
        'first_name.required' => 'Firstname is required',
        'last_name.required' => 'Lastname is required',
        'mobile_number.regex' => 'Contact No. must start with 09!!',
        'gender.in' => 'Gender must be Male and Female only!!'
        
    ];
    }
}
