<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClearedPointRequest extends FormRequest
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
         
            '*.id' => 'required|numeric|exists:earnedpoints,id',
            '*.member_id' => 'required|numeric|exists:earnedpoints,member_id',
            '*.amount' => 'required',
            '*.points_earn' => 'required'
            
        ];
    }

    public function messages(){
        return [
          
        '*.id.exists' => 'id is not exist',     
        '*.member_id.exists' => 'member_id is not exist'
        ];
    }

   
}
