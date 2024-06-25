<?php

namespace App\Exports;

use App\Models\Ot_one;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class Otform1Export implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // return Ot_one::all();
        return Ot_one::select('ot_one_date','ot_one_fullname','ot_one_sign','ot_one_starttime','ot_one_sign2','ot_one_endtime','ot_one_total','ot_one_detail')
        ->get();
    }
    public function headings(): array
    {
        return ["วันที่","ชื่อ-นามสกุล","รายมือชื่อ" ,"เวลามา","รายมือชื่อ","เวลากลับ","ชั่วโมง","หน้าที่ที่ปฎิบัติ"];

    }

}
