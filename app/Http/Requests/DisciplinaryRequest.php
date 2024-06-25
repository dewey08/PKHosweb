<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DisciplinaryRequest extends FormRequest
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
            'DISCIPLINARY_DATE' => 'required',
            'DISCIPLINARY_DETAIL' => 'required',
            'DISCIPLINARY_BLAME' => 'required',
            'DISCIPLINARY_NUMBER' => 'required',
            'DISCIPLINARY_REMARK' => 'required'
        ];
    }
}
