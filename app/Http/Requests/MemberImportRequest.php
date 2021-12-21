<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MemberImportRequest extends FormRequest
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
            '*.first_name' => 'required',
            '*.last_name' => 'required',
            '*.gender' => 'required|in:male,female',
            '*.mobile_number' => 'required|regex:[09]|numeric|digits:11',
            '*.birthday' => 'required',
            '*.barangay' => 'required',
            '*.municipality' => 'required',
            '*.province' => 'required',
            '*.email' => 'required|email',
            
        ];
    }

    public function messages()
    {
        //'mobile_number.regex' => 'Contact No. must start with 63!!'
    return [
        '*.mobile_number.regex' => 'Contact No. must start with 09!!',
        '*.gender.in' => 'Gender must be Male and Female only!!'
        
    ];
    }
}
