<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WorksRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'DATEDO_WORK' => 'required',
            'DATEDO_EXIT' => 'required',
            'BECOURSE_EXIT' => 'required',
            'POSITION_WORK' => 'required',
            'LOCATION_WORK' => 'required',
            'SALARY' => 'required||numeric'
 
            ];
    }

    public function messages()

    {
        return [
            'DATEDO_WORK.required' => 'วันเริ่มทำงานจำเป็นต้องระบุ *',
            'DATEDO_EXIT.required' => 'วันที่หมดวาระจำเป็นต้องระบุ *',
            'POSITION_WORK.required' => 'ตำแหน่งจำเป็นต้องระบุ *',
            'BECOURSE_EXIT.required' => 'เหตุผลที่หมดวาระจำเป็นต้องระบุ *',
            'LOCATION_WORK.required' => 'สถานที่จำเป็นต้องระบุ *',
            'SALARY.required' => 'เงินเดือนจำเป็นต้องระบุ *',
            'SALARY.numeric' => 'ต้องระบุเป็นตัวเลข',

        ];

    }
}
