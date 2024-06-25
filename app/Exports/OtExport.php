<?php

namespace App\Exports;

use App\Models\Ot_one;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OtExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    // public function collection( )
    // {
    //     $month = date('Y-m-d');
    //     return Ot_one::select( "ot_one_date","ot_one_fullname",  "ot_one_starttime" ,"ot_one_endtime","ot_one_detail")->get();        
    // }
     // return Ot_one::all();
        // return new User([
        //     'ot_one_id'         => $row['ot_one_id'],
        //     'ot_one_date'       => $row['ot_one_date'],  
        //     'ot_one_starttime'  => $row['ot_one_starttime'], 
        //     'ot_one_endtime'    => $row['ot_one_endtime'], 
        //     'ot_one_fullname'   => $row['ot_one_fullname'], 
        // ]);
    public function collection()
    {
        return Ot_one::all();
    }
    public function headings(): array
    {
        return ["OT_ONE_ID", "OT_ONE_DATE", "OT_ONE_STARTTIME"];
    }
}
