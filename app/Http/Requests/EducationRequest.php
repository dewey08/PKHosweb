<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EducationRequest extends FormRequest
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
            'VUT_ID' => 'required',
            'UNIVER_NAME' => 'required',
            'FAUCULTY' => 'required',
            'LAVEL' => 'required',
            'GRADE' => 'required',
        ];
    }

    public function messages() 
    {           
        return [                    
         
                'GRADE.required' => 'กรุณาเลือกไฟล์ภาพนามสกุล jpeg,jpg,png',             
        ];     
    } 
}
