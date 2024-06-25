<?php

namespace App\Imports;

use App\Models\Acc_stm_ti_excel; 
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ImportAcc_stm_tiexcel_import implements ToModel
// class ImportAcc_stm_tiexcel_import implements ToCollection
{ 
    
    public function model(array $row)
    {
        // Acc_stm_ti_excel::truncate();
        $cid       = $row[5];
        $filename  = $row[24];
        #ตัดขีด, ตัด : ออก แล้วเรียงใหม่
        $regdate_ = $row[9];
        $starttime = substr($regdate_, 0, 5);
        $regday = substr($regdate_, 0, 2);
        $regmo = substr($regdate_, 3, 2);
        $regyear = substr($regdate_, 6, 10);            
        $regdate = $regyear.'-'.$regmo.'-'.$regday;
        
        $vstdate_ = $row[10];
        $starttime = substr($vstdate_, 0, 5);
        $day = substr($vstdate_, 0, 2);
        $mo = substr($vstdate_, 3, 2);
        $year = substr($vstdate_, 6, 10);
        $vstdate = $year.'-'.$mo.'-'.$day; 
        // $check = Acc_stm_ti_excel::where('cid','=',$cid)->where('vstdate','=',$vstdate)->count();
        // if ($check > 0) {
        //     # code...
        // } else {             
            return new Acc_stm_ti_excel([ 
                'repno' => $row[1],
                'tranid' => $row[2],
                'hn' => $row[3],
                'an' => $row[4],
                'cid' => $row[5],
                'fullname' => $row[6], 
                'hipdata_code' => $row[7],             
                'regdate' =>$regdate,
                'vstdate' => $vstdate, 
                'no' => $row[0],
                'list' => $row[12],
                'qty' => $row[13],
                'unitprice' => $row[14], 
                'unitprice_max' => $row[15], 
                'price_request' => $row[16], 
                'pscode' => $row[17], 
                'percent' => $row[18], 
                'pay_amount' => $row[19], 
                'nonpay_amount' => $row[20], 
                'payplus_amount' => $row[21],  
                'payback_amount' => $row[22], 
                'active' => $row[23], 
                'filename' => $row[24]
            ]);
        // } 
        
    }
   
}
