<?php

namespace App\Imports;

use App\Models\Acc_stm_ti;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
class ImportAcc_stm_ti implements ToModel,WithHeadingRow
{ 
    public function model(array $row)
    {
        return new Acc_stm_ti([
            // 'acc_stm_ti_id'   => $row['acc_stm_ti_id'],
            'repno'              => $row['repno'],
            'tranid'             => $row['tranid'],
            'hn'                 => $row['hn' ],
            'cid'                => $row['cid' ],
            'fullname'           => $row['fullname'],
            'subinscl'           => $row['subinscl'],

         #ตัดขีด, ตัด : ออก
        // $pattern_date = '/-/i';
        // $aipn_date_now_preg = preg_replace($pattern_date, '', $sss_date_now);
        // $pattern_time = '/:/i';
        // $aipn_time_now_preg = preg_replace($pattern_time, '', $aipn_time_now);
 

            'vstdate'            => $row['vstdate'],
            'regdate'            => $row['regdate'],
            'type_req'           => $row['type_req'],
            'price_req'          => $row['price_req'],
            'price_approve'      => $row['price_approve'],
            'price_approve_no'   => $row['price_approve_no'],
            'comment'            => $row['comment'],
            'date_save'          => $row['date_save' ],
            'vn'                 => $row['vn'],
            'active'             => $row['active']
            
        ]);
    }
}
 