<?php

namespace App\Imports;

use App\Models\Check_authen;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ImportAuthenexcel_import implements ToModel,WithHeadingRow
// class ImportAuthenexcel_import implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
    //      #ตัดขีด, ตัด : ออก แล้วเรียงใหม่
    //     //  $vstdate_ = $row[15];
    //     //  $starttime = substr($vstdate_, 0,5);
    //     //  $day = substr($vstdate_, 0, 2);
    //     //  $mo = substr($vstdate_, 3, 2);
    //     //  $year_ = substr($vstdate_, 6, 10);
    //     // //  $year = ($year_)-543;
    //     //  $vstdate = $year_.'-'.$mo.'-'.$day;
    //     //  $vstdate = preg_replace($vstdate_);
    //     //  $regdate_ = $row[16];
    //     //  $starttime = substr($regdate_, 0, 5);
    //     //  $regday = substr($regdate_, 0, 2);
    //     //  $regmo = substr($regdate_, 3, 2);
    //     //  $regyear_ = substr($regdate_, 6, 10);
    //     //  $regdate = $regyear_.'-'.$regmo.'-'.$regday;
    //     // $sss_date_now = date("Y-m-d");
    //     // $aipn_time_now = date("H:i:s");

    //     // $pattern_date = '/-/i';
    //     // $aipn_date_now_preg = preg_replace($pattern_date, '', $sss_date_now);
    //     // $pattern_time = '/:/i';
    //     // $aipn_time_now_preg = preg_replace($pattern_time, '', $aipn_time_now);


    //     // $string = $row[15];
    //     // $pattern = '/(\w+) (\d+), (\d+)/i';
    //     // $replacement = '${1} 02, $3';
    //     // $vstdate = preg_replace($pattern, $replacement, $string);

        return new Check_authen([
            'hcode'             => $row[0],
            'hosname'           => $row[1],
            'cid'               => $row[2],
            'fullname'          => $row[3],
            'birthday'          => $row[4],
            'homtel'            => $row[5],
            'mainpttype'        => $row[6],
            'subpttype'         => $row[7],
            'repcode'           => $row[8],
            'claimcode'         => $row[9],
            'claimtype'         => $row[10],
            'servicerep'        => $row[11],
            'servicename'       => $row[12],
            'hncode'            => $row[13],
            'ancode'            => $row[14],
            'vstdate'           => $row[15],
            // 'regdate'           => $regdate_,
            'status'            => $row[17],
            'requestauthen'     => $row[18],
            'authentication'    => $row[19],
            'staff_service'     => $row[20],
            'date_editauthen'   => $row[21],
            'name_editauthen'   => $row[22],
            'comment'           => $row[23]
        ]);
    }
    // public function collection(Collection $rows)
    // {
        // foreach ($rows as $row)
        // {
        //     #ตัดขีด, ตัด : ออก แล้วเรียงใหม่
        //     // $regdate_ = $row[9];
        //     // $starttime = substr($regdate_, 0, 5);
        //     // $regday = substr($regdate_, 0, 2);
        //     // $regmo = substr($regdate_, 3, 2);
        //     // $regyear = substr($regdate_, 6, 10);

        //     // $regdate = $regyear.'-'.$regmo.'-'.$regday;

        //     $vstdate_ = $row[15];
        //     // $starttime = substr($vstdate_, 0, 5);
        //     $day = substr($vstdate_, 0, 2);
        //     $mo = substr($vstdate_, 3, 2);
        //     $year = substr($vstdate_, 6, 10);

        //     $vstdate = $year.'-'.$mo.'-'.$day;
            #ตัดขีด, ตัด : ออก แล้วเรียงใหม่
            // dd($vstdate);

            // Check_authen::creat([
            //     'hcode'             => $row[0],
            //     'hosname'           => $row[1],
            //     'cid'               => $row[2],
            //     'fullname'          => $row[3],
            //     'birthday'          => $row[4],
            //     'homtel'            => $row[5],
            //     'mainpttype'        => $row[6],
            //     'subpttype'         => $row[7],
            //     'repcode'           => $row[8],
            //     'claimcode'         => $row[9],
            //     'claimtype'         => $row[10],
            //     'servicerep'        => $row[11],
            //     'servicename'       => $row[12],
            //     'hncode'            => $row[13],
            //     'ancode'            => $row[14],
            //     'vstdate'           => $vstdate,
            //     // 'regdate'           => $regdate_,
            //     'status'            => $row[17],
            //     'requestauthen'     => $row[18],
            //     'authentication'    => $row[19],
            //     'staff_service'     => $row[20],
            //     'date_editauthen'   => $row[21],
            //     'name_editauthen'   => $row[22],
            //     'comment'           => $row[23]
        // ]);
        //          Check_authen::insert([
        //     'hcode'             => $row[0],
        //     'hosname'           => $row[1],
        //     'cid'               => $row[2],
        //     'fullname'          => $row[3],
        //     'birthday'          => $row[4],
        //     'homtel'            => $row[5],
        //     'mainpttype'        => $row[6],
        //     'subpttype'         => $row[7],
        //     'repcode'           => $row[8],
        //     'claimcode'         => $row[9],
        //     'claimtype'         => $row[10],
        //     'servicerep'        => $row[11],
        //     'servicename'       => $row[12],
        //     'hncode'            => $row[13],
        //     'ancode'            => $row[14],
        //     'vstdate'           => $vstdate,
        //     // 'regdate'           => $regdate_,
        //     'status'            => $row[17],
        //     'requestauthen'     => $row[18],
        //     'authentication'    => $row[19],
        //     'staff_service'     => $row[20],
        //     'date_editauthen'   => $row[21],
        //     'name_editauthen'   => $row[22],
        //     'comment'           => $row[23]
        // ]);

        // }
    // }
}
