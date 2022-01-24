<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReportRequest extends FormRequest
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
        //     'selectedReport' => 'required|in:Earned-Points,Redeemed-Points,Cleared-Points',
        //     'dateRangedBased' => 'nullable|required_if:selectedReport,==,Earned-Points|required_if:selectedReport,==,Redeemed-Points|in:Date Synched,Date Earned,Date Cleared Points,Date Redeemed,Date Synched / Upload',
        //     'dateRanged.start' => 'required|date_format:Y-m-d',
        //     'dateRanged.end' => 'required|date_format:Y-m-d',
        //     'category.*' => 'nullable|in:Synched,Uploaded',
        //     'status.*' => 'nullable|in:Cleared,Not Cleared'
        // ];
    
        $selectedReport = $this->request->get('selectedReport');

     
            $rules = [
                'selectedReport' => 'required|in:Earned-Points,Redeemed-Points,Cleared-Points',
                'dateRanged.start' => 'required|date_format:Y-m-d',
                'dateRanged.end' => 'required|date_format:Y-m-d'
            ];


            if($selectedReport == 'Earned-Points'){
                $rules['dateRangedBased'] = 'required|in:Date Earned,Date Cleared Points,Date Synched / Upload';
                $rules['category.*'] = 'nullable|in:Synched,Uploaded';
                $rules['status.*'] = 'nullable|in:Cleared,Not Cleared';
            }

            if($selectedReport == 'Redeemed-Points'){
                $rules['dateRangedBased'] = 'required|in:Date Synched,Date Redeemed';
                $rules['category.*'] = 'nullable';
                $rules['status.*'] = 'nullable';
            }

            if($selectedReport == 'Cleared-Points'){
                $rules['dateRangedBased'] = 'nullable';
                $rules['category.*'] = 'nullable';
                $rules['status.*'] = 'nullable';
            }


        return $rules;
        
    }

    public function messages()
    {
        $selectedReport = $this->request->get('selectedReport');

        $message = [
            'selectedReport.required' => 'selectedReport is required'
    

        ];

        if($selectedReport == 'Earned-Points'){
            $message = [
                'dateRangedBased.in' => 'dateRangedBased must be Date Earned,Date Cleared Points,Date Synched / Upload only!!',
                'category.*.in' => 'category must be Synched, Uploaded only!!',
                'status.*.in' => 'status must be Cleared,Not Cleared only!!'  
            ];     

        }

        if($selectedReport == 'Redeemed-Points'){
            $message = [
                'dateRangedBased.in' => 'dateRangedBased must be Date Synched,Date Redeemed only!!'  
            ];     

        }


        return $message;
    }



//     //     if($selectedReport == 'Earned-Points'){
//     //         return [
//     //             'selectedReport.in' => 'selectedReport must be Earned-Points, Redeemed-Points, Cleared-Points only!!',
//     //             'dateRangedBased.in' => 'dateRangedBased must be Date Earned,Date Cleared Points,Date Synched / Upload only!!',
//     //             'category.*.in' => 'category must be Synched, Uploaded only!!',
//     //             'status.*.in' => 'status must be Cleared,Not Cleared only!!'  
//     //         ];

//     //         if($selectedReport == 'Redeemed-Points'){
//     //             return [
//     //                 'selectedReport.in' => 'selectedReport must be Earned-Points, Redeemed-Points, Cleared-Points only!!',
//     //                 'dateRangedBased.in' => 'dateRangedBased must be Date Synched,Date Redeemed only!!'
//     //             ];
//     //         }

//     //         if($selectedReport == 'Cleared-Points'){
//     //             return [
//     //                 'selectedReport.in' => 'selectedReport must be Earned-Points, Redeemed-Points, Cleared-Points only!!'
            
//     //             ];
//     //         }
//     //     }
//      }
 }
