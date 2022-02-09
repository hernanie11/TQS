<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'code' => 'required|unique:stores,code',
            'name' => 'required',
            'area' => 'required',
            'region' => 'required',
            'cluster' => 'required'
            //'business_model' => 'required|exists:business_categories,name'
        ];
    }

    public function messages()
    {
        return [
            //'business_model.exists' => 'business model not found in business_categories',

        ];
    }
}
