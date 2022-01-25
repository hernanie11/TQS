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

        //$all = $this->request->all();
        return [
           

            'data.*.id' => 'required|numeric|exists:earnedpoints,id',
            'data.*.member_id' => 'required|numeric|exists:earnedpoints,member_id',
            'data.*.amount' => 'required',
            'data.*.points_earn' => 'required'
        ];
    
    }

    public function messages(){
        return [
          
        'data.*.id.exists' => 'id is not exist',     
        'data.*.member_id.exists' => 'member_id is not exist'
        ];
    }

   
}
