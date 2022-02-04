<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class EarnedPointRequestV2 extends FormRequest
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
    public function rules(Request $request)
    {
      
        $rules = [
            'data.*.member_id' => 'required|exists:members,id',
            'data.*.transaction_no' => 'required|unique:earnedpoints,transaction_no',
            'data.*.amount' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'data.*.points_earn' => 'required',
            'data.*.transaction_datetime' => 'required|date_format:Y-m-d H:i:s',
            'data.*.store_code' => 'required',
        ];
        foreach($this->request->get('data') as $key => $val)
        {
            $rules['data.'.$key] = 'unique:earnedpoints,member_id,NULL,id,points_earn,'.request('data.'.$key.'.points_earn').',transaction_datetime,'.request('data.'.$key.'.transaction_datetime');
        }
        return $rules;

    }
}
