<?php

namespace App\Exports;

use App\Models\Checkin_export;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class Checkinexport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // return Checkin_export::all();
        return collect(Checkin_export::getCheckin_export());
    }
    public function headings():array{
        return [
            'วันที่','ชื่อ-นามสกุล','เวลาเข้า','เวลาออก','ประเภท'     
        ];
    }
}
