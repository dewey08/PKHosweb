<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RewardRequest extends FormRequest
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
            'REWARD_NAME' => 'required',
            'DATE_RECEIVE'=> 'required',
            // 'START_DATE'=> 'required',
            // 'END_DATE'=> 'required',
        ];
    }

    public function messages() 
    {           
        return [                    
         
                'REWARD_NAME.required' => 'required',             
        ];     
    } 
}
