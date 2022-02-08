<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RedeemPointRequest extends FormRequest
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
        // return [
            
        //     '*.member_id' => 'required',
        //     '*.points_redeemed' => 'required',
        //     '*.transaction_datetime' => 'required|date_format:Y-m-d H:i:s',
        //     '*.store_code' => 'required',
        //     '*.store_name' => 'required',
            
        // ];
        
        return [
//'*.*' => 'unique:redeeming_transaction,member_id,points_redeemed,transaction_datetime',
            'member_id' => 'required',
            'points_redeemed' => 'required',
            'transaction_datetime' => 'required|date_format:Y-m-d H:i:s|after_or_equal:today',
            'store_code' => 'required',
            'store_name' => 'required',
            
        ];
    }

    public function messages()
    {
    return [
        
        '*.member_id.required' => 'member is required',
        
    ];
    }

}
