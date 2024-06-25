<?php

namespace App\Imports;

use App\Models\Acc_stm_lgoexcel;
use Maatwebsite\Excel\Concerns\ToModel;

use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ImportAcc_stm_lgoexcel_import implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    // public function model(array $row)
    // {
    //     return new Acc_stm_lgoexcel([
    //         //
    //     ]);
    // }
    public function model(array $row)
    { 
         #ตัดขีด, ตัด : ออก แล้วเรียงใหม่
         $vstdate_ = $row[8];
         $starttime = substr($vstdate_, 0,5);
         $day = substr($vstdate_, 0, 2);
         $mo = substr($vstdate_, 3, 2);
         $year = substr($vstdate_, 6, 10);
         $vstdate = $year.'-'.$mo.'-'.$day; 

         $dchdate_ = $row[9];
         $starttime = substr($dchdate_, 0, 5);
         $regday = substr($dchdate_, 0, 2);
         $regmo = substr($dchdate_, 3, 2);
         $regyear = substr($dchdate_, 6, 10);            
         $dchdate = $regyear.'-'.$regmo.'-'.$regday;
 
            return new Acc_stm_lgoexcel([ 
                'rep'         => $row[0],
                'no'          => $row[1],
                'tranid'      => $row[2],
                'hn'          => $row[3],
                'an'          => $row[4],
                'cid'         => $row[5],
                'fullname'    => $row[6], 
                'type'        => $row[7],          
                'vstdate'     => $vstdate,
                'dchdate'     => $dchdate, 
                // 'vstdate'     => $row[8],
                // 'dchdate'     => $row[9], 
                'price1'      => $row[10],
                'pp_spsch'    => $row[11],
                'errorcode'   => $row[12],
                'kongtoon'    => $row[13], 
                'typeservice' => $row[14], 
                'refer'       => $row[15], 
                'pttype_have' => $row[16], 
                'pttype_true' => $row[17], 
                'mian_pttype' => $row[18], 
                'secon_pttype' => $row[19], 
                'href'        => $row[20], 
                'HCODE'       => $row[21],  
                'prov1'       => $row[22],  
                'code_dep'    => $row[23],  
                'name_dep'    => $row[24],  
                'proj'        => $row[25],  
                'pa'          => $row[26],  
                'drg'         => $row[27],  
                'rw'          => $row[28],  
                'income'      => $row[29],  
                'pp_gep'      => $row[30],  
                'claim_true'  => $row[31],  
                'claim_false' => $row[32],  
                'cash_money'  => $row[33],  
                'pay'         => $row[34],  
                'ps'          => $row[35],  
                'ps_percent'  => $row[36],  
                'ccuf'        => $row[37],  
                'AdjRW'       => $row[38],  
                'plb'         => $row[39],  
                'IPLG'        => $row[40],  
                'OPLG'        => $row[41],  
                'PALG'        => $row[42],  
                'INSTLG'      => $row[43],  
                'OTLG'        => $row[44],  
                'PP'          => $row[45], 
                'DRUG'        => $row[46],   
                'IPLG2'       => $row[47],  
                'OPLG2'       => $row[48],  
                'PALG2'       => $row[49],  
                'INSTLG2'     => $row[50],  
                'OTLG2'       => $row[51],  
                'ORS'         => $row[52],  
                'VA'          => $row[53],  
                'STMdoc'      => $row[54]   
            ]);  
         
    }
}
