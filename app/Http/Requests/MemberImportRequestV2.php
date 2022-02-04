<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;


class MemberImportRequestV2 extends FormRequest
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
            'data.*.first_name' => 'required',
            'data.*.last_name' => 'required',
            'data.*.gender' => 'required|in:male,female',
            'data.*.mobile_number' => 'required|regex:[09]|numeric|digits:11|unique:members,mobile_number',
            'data.*.birthday' => 'required',
            'data.*.barangay' => 'required',
            'data.*.municipality' => 'required',
            'data.*.province' => 'required',
            'data.*.email' => 'required|email',
            
        ];
    }

    public function messages()
    {
        //'mobile_number.regex' => 'Contact No. must start with 63!!'
   return [
        'data.*.mobile_number.regex' => 'Contact No. must start with 09!!',
        'data.*.gender.in' => 'Gender must be Male and Female only!!',
        'data.*.mobile_number.unique' => ':attribute is already exist!',
       // 'data.*.mobile_number.unique' => ['data.*.mobile_number.unique' =>':attribute :input is already exist!']
        
    ];
   
    }
    

    // protected function failedValidation(Validator $validator)
    // {
    //     if($this->wantsJson())
    //      {     

    //      //  $test = $validator->errors()->array_fill_keys();
           
    //          $response = response()->json([
    //             'message' => 'The given data is invalid.',
    //             'errors' => $validator->errors()->array_fill_keys()
    //          ]);        
    //      }else{
    //         $response = redirect()
    //             ->route('guest.login')
    //             ->with('message', 'Ops! Some errors occurred')
    //             ->withErrors($validator);
    //      }
            
    //      throw (new ValidationException($validator, $response))
    //         ->errorBag($this->errorBag)
    //         ->redirectTo($this->getRedirectUrl());
    // }


}
