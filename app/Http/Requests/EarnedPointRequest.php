<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class EarnedPointRequest extends FormRequest
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

            '*.member_id' => 'required',
            '*.transaction_no' => 'required',
            '*.amount' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            '*.points_earn' => 'required',
            '*.transaction_datetime' => 'required|date_format:Y-m-d H:i:s',
            
        ];
       
 
    }

    public function messages()
    {
    return [
        
        '*.member_id.required' => 'member is required',

    ];
    }


}
