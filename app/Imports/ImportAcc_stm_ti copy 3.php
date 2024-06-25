<?php

namespace App\Imports;

use App\Models\Acc_stm_ti;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
// class ImportAcc_stm_ti implements ToModel,WithHeadingRow
class ImportAcc_stm_ti implements ToCollection
{ 
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        { 
            // #ตัดขีด, ตัด : ออก แล้วเรียงใหม่
            $regdate_ = $row[7];
            $starttime = substr($regdate_, 0, 5);
            $regday = substr($regdate_, 0, 2);
            $regmo = substr($regdate_, 3, 2);
            $regyear = substr($regdate_, 6, 10);
            
            $regdate = $regyear.'-'.$regmo.'-'.$regday;

            $vstdate_ = $row[8];
            $starttime = substr($vstdate_, 0, 5);
            $day = substr($vstdate_, 0, 2);
            $mo = substr($vstdate_, 3, 2);
            $year = substr($vstdate_, 6, 10);

            $vstdate = $year.'-'.$mo.'-'.$day; 
            // #ตัดขีด, ตัด : ออก แล้วเรียงใหม่
            // dd($regdate);
            // $check = Acc_stm_ti::where('cid',$row[4])->where('vstdate',$vstdate);
            // if ($check > 0) {
            //     Acc_stm_ti::where('cid', $row[4])->where('vstdate',$vstdate)
            //         ->update([   
            //             'repno' => $row[1],
            //             'tranid' => $row[2],
            //             'hn' => $row[3],
            //             'cid' => $row[4],
            //             'fullname' => $row[5],
            //             'subinscl' => $row[6],
            //             'vstdate' => $vstdate,
            //             'regdate' => $regdate,
            //             'type_req' => $row[9],
            //             'price_req' => $row[10],
            //             'price_approve' => $row[11],
            //             'price_approve_no' => $row[12]
            //         ]); 
            // } else {
                Acc_stm_ti::create([                
                    'repno' => $row[1],
                    'tranid' => $row[2],
                    'hn' => $row[3],
                    'cid' => $row[4],
                    'fullname' => $row[5],
                    'subinscl' => $row[6],
                    'vstdate' => $vstdate,
                    'regdate' => $regdate,
                    'type_req' => $row[9],
                    'price_req' => $row[10],
                    'price_approve' => $row[11],
                    'price_approve_no' => $row[12], 
                ]);
            // }
        }
    }
    // public function model(array $row)
    // {
    //     return new Acc_stm_ti([
    //         // 'acc_stm_ti_id'   => $row['acc_stm_ti_id'],
    //         'repno'              => $row['repno'],
    //         'tranid'             => $row['tranid'],
    //         'hn'                 => $row['hn' ],
    //         'cid'                => $row['cid' ],
    //         'fullname'           => $row['fullname'],
    //         'subinscl'           => $row['subinscl'],

    //      #ตัดขีด, ตัด : ออก
    //     // $pattern_date = '/-/i';
    //     // $aipn_date_now_preg = preg_replace($pattern_date, '', $sss_date_now);
    //     // $pattern_time = '/:/i';
    //     // $aipn_time_now_preg = preg_replace($pattern_time, '', $aipn_time_now);
 

    //         'vstdate'            => $row['vstdate'],
    //         'regdate'            => $row['regdate'],
    //         'type_req'           => $row['type_req'],
    //         'price_req'          => $row['price_req'],
    //         'price_approve'      => $row['price_approve'],
    //         'price_approve_no'   => $row['price_approve_no'],
    //         'comment'            => $row['comment'],
    //         'date_save'          => $row['date_save' ],
    //         'vn'                 => $row['vn'],
    //         'active'             => $row['active']
            
    //     ]);
    // }
}
 