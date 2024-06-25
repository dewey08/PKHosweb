<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\DB;
use Http;
use SoapClient;
use File;
use SplFileObject;
use Arr;
use Storage;

class AuthenController extends Controller
{
    public function authen_dashboard(Request $request)
    {
        $date = date('Y-m-d');
        // $countalls = DB::connection('mysql3')->table('ovst_queue_server')
        // ->leftjoin('ovst_queue_server_authen','ovst_queue_server_authen.vn','=','ovst_queue_server.vn')
        // ->where('date_visit','=',$date)
        // ->count();

        $countalls_data = DB::connection('mysql3')->select('
            SELECT COUNT(o.vn) as VN
            FROM ovst o
            LEFT OUTER JOIN ovst_queue_server_authen oq on oq.vn=o.vn
            LEFT OUTER JOIN kskdepartment sk on sk.depcode=o.main_dep
            LEFT OUTER JOIN patient p on p.hn=o.hn
            WHERE o.vstdate = CURDATE()
            ORDER BY o.vsttime
        ');

        foreach ($countalls_data as $key => $value) {
            $countalls = $value->VN;
        }


        $authen = DB::connection('mysql3')->select('
            SELECT os.vn,os.hn,os.date_visit,os.time_visit,os.fullname,oq.claim_code,oq.mobile,oq.claim_type,oq.authen_type,os.opd_dep,os.is_appoint,os.staff,sk.department
            FROM ovst_queue_server os
            LEFT OUTER JOIN ovst_queue_server_authen oq on oq.vn=os.vn
            LEFT OUTER JOIN kskdepartment sk on sk.depcode=os.opd_dep
            WHERE os.date_visit = CURDATE()
            ORDER BY os.time_visit
        ');
        $authensuccess_data = DB::connection('mysql3')->select('         
            SELECT COUNT(o.vn) as VN
                FROM ovst_queue_server o
                LEFT OUTER JOIN ovst_queue_server_authen v on v.vn=o.vn
                LEFT OUTER JOIN vn_stat vn on vn.vn=o.vn
                LEFT OUTER JOIN patient p on p.hn=o.hn
                WHERE o.date_visit = CURDATE()
                AND v.claim_code is not null
                AND v.authen_type ="s"
        ');
        foreach ($authensuccess_data as $key => $value) {
            $authensuccess = $value->VN;
        }
        if ($authensuccess == 0) {
            $authensuccesstt = 1;
        } else {
            $countonus = 100 / $countalls ; 
            $authensuccesstt = $countonus * $authensuccess;
            // dd($countkiosallst);
        }
        $authensuccess_alldata = DB::connection('mysql3')->select('         
            SELECT os.vn,os.hn,os.date_visit,os.time_visit,os.fullname,oq.claim_code,oq.mobile,oq.claim_type,oq.authen_type,os.opd_dep,os.is_appoint,os.staff,sk.department
                FROM ovst_queue_server os
                LEFT OUTER JOIN ovst_queue_server_authen oq on oq.vn=os.vn
                LEFT OUTER JOIN kskdepartment sk on sk.depcode=os.opd_dep
                LEFT OUTER JOIN vn_stat vn on vn.vn=os.vn
                LEFT OUTER JOIN patient p on p.hn=os.hn
                WHERE os.date_visit = CURDATE()
                AND oq.claim_code is not null
                AND oq.authen_type ="s"
            ');

        $authen_nosuccess_data = DB::connection('mysql3')->select('         
            SELECT COUNT(o.vn) as VN
                FROM ovst_queue_server o
                LEFT OUTER JOIN ovst_queue_server_authen v on v.vn=o.vn
                LEFT OUTER JOIN vn_stat vn on vn.vn=o.vn
                LEFT OUTER JOIN patient p on p.hn=o.hn
                WHERE o.date_visit = CURDATE() 
                AND v.authen_type <>"s"
        ');
        foreach ($authen_nosuccess_data as $key => $value) {
            $authen_nosuccess = $value->VN;
        }
          
 
        $countkiosallsdata = DB::connection('mysql3')->select('
            SELECT COUNT(o.vn) as VN
            FROM ovst o
            LEFT OUTER JOIN ovst_queue_server os on os.vn = o.vn
            LEFT OUTER JOIN ovst_queue_server_authen oq on oq.vn = os.vn
            LEFT OUTER JOIN kskdepartment sk on sk.depcode=o.main_dep
            LEFT OUTER JOIN patient p on p.hn=o.hn
            LEFT OUTER JOIN opduser op on op.loginname = o.staff
            WHERE o.vstdate = CURDATE()
            AND os.staff LIKE "kiosk%"
            ORDER BY o.vsttime
        ');
        foreach ($countkiosallsdata as $key => $value) {
            $countkiosalls = $value->VN;
        }

        if ($countkiosalls == 0) {
            $countkiosallst = 1;
        } else {
            $countonus = 100 / $countalls ; 
            $countkiosallst = $countonus * $countkiosalls;
            // dd($countkiosallst);
        }
 
        $countkiosfinishdata = DB::connection('mysql3')->select('
            SELECT COUNT(o.vn) as VN
            FROM ovst o
            LEFT OUTER JOIN ovst_queue_server os on os.vn = o.vn
            LEFT OUTER JOIN ovst_queue_server_authen oq on oq.vn = os.vn
            LEFT OUTER JOIN kskdepartment sk on sk.depcode=o.main_dep
            LEFT OUTER JOIN patient p on p.hn=o.hn
            LEFT OUTER JOIN opduser op on op.loginname = o.staff
            WHERE o.vstdate = CURDATE()
            AND os.staff LIKE "kiosk%"
            AND oq.authen_type="S"
            ORDER BY o.vsttime       
        ');
        foreach ($countkiosfinishdata as $key => $value) {
            $countkiosfinish = $value->VN;
        }

        if ($countkiosfinish == 0) {
            $countkiosfinisht = 1;
        } else {
            $countonus = 100 / $countalls ; 
            $countkiosfinisht = $countonus * $countkiosfinish;
            // dd($countkiosallst);
        }

        $countkiosnofinishdata1 = DB::connection('mysql3')->select('
            SELECT COUNT(os.vn) as VN
            FROM ovst_queue_server os
            LEFT OUTER JOIN ovst_queue_server_authen oq on oq.vn=os.vn
            WHERE os.date_visit = "'.$date.'"
            AND os.staff LIKE "kiosk%"
            AND oq.authen_type <>"S" 
            ORDER BY os.time_visit
 
        ');
        foreach ($countkiosnofinishdata1 as $key => $value) {
            $countkiosnofinish1 = $value->VN;
        }
        $countkiosnofinishdata2 = DB::connection('mysql3')->select('
            SELECT COUNT(os.vn) as VN
            FROM ovst_queue_server os
            LEFT OUTER JOIN ovst_queue_server_authen oq on oq.vn=os.vn
            WHERE os.date_visit = "'.$date.'"
            AND os.staff LIKE "kiosk%"
            AND oq.authen_type IS NULL 
            ORDER BY os.time_visit

        ');
        foreach ($countkiosnofinishdata2 as $key => $value) {
            $countkiosnofinish2 = $value->VN;
        }

        $countkiosnofinish = $countkiosnofinish1 + $countkiosnofinish2;
       
        if ($countkiosnofinish == 0) {
            $countkiosnofinisht = 1;
        } else {
            $countonus = 100 / $countalls ; 
            $countkiosnofinisht = $countonus * $countkiosnofinish;
            // dd($countkiosallst);
        }

        $countonusers = DB::connection('mysql3')->table('ovst_queue_server')
            ->leftjoin('ovst_queue_server_authen','ovst_queue_server_authen.vn','=','ovst_queue_server.vn')
            ->where('date_visit','=',$date)
            ->where('staff','<>',['kioskopd1','kioskopd','kioskncd','kioskpcc'])
            // ->where('authen_type','<>','S')
            ->count();
        $countonusersdata = DB::connection('mysql3')->select('
            SELECT COUNT(os.vn) as VN
            FROM ovst_queue_server os
            LEFT OUTER JOIN ovst_queue_server_authen oq on oq.vn=os.vn
            LEFT OUTER JOIN kskdepartment sk on sk.depcode=os.opd_dep
            WHERE os.date_visit = "'.$date.'"
            and staff <>"kioskopd1" and staff <>"kioskopd" and staff <> "kioskncd" and staff <> "kioskpcc" 
            ORDER BY os.time_visit
        ');

        foreach ($countonusersdata as $key => $value) {
            $countonusers = $value->VN;
        }
        // $countonuserssuccess = DB::connection('mysql3')->table('ovst_queue_server')
        // ->leftjoin('ovst_queue_server_authen','ovst_queue_server_authen.vn','=','ovst_queue_server.vn')
        // ->where('date_visit','=',$date)
        // ->where('staff','<>',['kioskopd1','kioskopd','kioskncd','kioskpcc'])
        // ->where('authen_type','=','S')
        // ->count();

        $countonuserssuccessdata = DB::connection('mysql3')->select('
            SELECT COUNT(os.vn) as VN
            FROM ovst_queue_server os
            LEFT OUTER JOIN ovst_queue_server_authen oq on oq.vn=os.vn
            LEFT OUTER JOIN kskdepartment sk on sk.depcode=os.opd_dep
            WHERE os.date_visit = "'.$date.'"
            and staff not in("kioskopd1","kioskopd","kioskncd","kioskpcc") 
            and authen_type = "S"
            ORDER BY os.time_visit
        ');
        foreach ($countonuserssuccessdata as $key => $value) {
            $countonuserssuccess2 = $value->VN;
        }
        //   dd($countonuserssuccess);

        $countonusersnosuccessdata1 = DB::connection('mysql3')->select('
            SELECT COUNT(os.vn) as VN
            FROM ovst_queue_server os
            LEFT OUTER JOIN ovst_queue_server_authen oq on oq.vn=os.vn
            LEFT OUTER JOIN kskdepartment sk on sk.depcode=os.opd_dep
            WHERE os.date_visit = "'.$date.'"
            and staff not in("kioskopd1","kioskopd","kioskncd","kioskpcc")            
            and authen_type <> "S"
            ORDER BY os.time_visit
        ');
        // and staff <>"kioskopd1" and staff <>"kioskopd" and staff <> "kioskncd" and staff <> "kioskpcc"
        foreach ($countonusersnosuccessdata1 as $key => $value) {
            $countonusersnosuccess1 = $value->VN;
        }
        $countonusersnosuccessdata2 = DB::connection('mysql3')->select('
            SELECT COUNT(os.vn) as VN
            FROM ovst_queue_server os
            LEFT OUTER JOIN ovst_queue_server_authen oq on oq.vn=os.vn
            LEFT OUTER JOIN kskdepartment sk on sk.depcode=os.opd_dep
            WHERE os.date_visit = "'.$date.'"
            and staff not in("kioskopd1","kioskopd","kioskncd","kioskpcc")            
            AND oq.authen_type IS NULL 
            ORDER BY os.time_visit
        ');
        // and staff <>"kioskopd1" and staff <>"kioskopd" and staff <> "kioskncd" and staff <> "kioskpcc"
        foreach ($countonusersnosuccessdata2 as $key => $value) {
            $countonusersnosuccess2 = $value->VN;
        }

        $countonusersnosuccess = $countonusersnosuccess1 + $countonusersnosuccess2;
     
        if ($countonusers == 0) {
            $countonuserst = 1;
        } else {
            $countonus = 100 / $countalls ; 
            $countonuserst = $countonus * $countonusers;
            // dd($countonuserst);
        }
        if ($countonuserssuccess2 == 0) {
            $countonuserssuccesstt = 1;
        } else {
            $countonuss = 100 / $countalls ; 
            $countonuserssuccesstt = $countonuss * $countonuserssuccess2;
            // dd($countonuserssuccesstt);
        }

        if ($countonusersnosuccess == 0) {
            $countonusersnosuccesstt = 1;
        } else {
            $countonusss = 100 / $countalls ; 
            $countonusersnosuccesstt = $countonusss * $countonusersnosuccess;
            // dd($countonuserssuccesstt);
        }
        
        $authenusernosuccess = DB::connection('mysql3')->select('
                SELECT os.vn,os.hn,os.date_visit,os.time_visit,os.fullname,oq.claim_code,oq.mobile,oq.claim_type,oq.authen_type,os.opd_dep,os.is_appoint,os.staff,sk.department
                FROM ovst_queue_server os
                LEFT OUTER JOIN ovst_queue_server_authen oq on oq.vn=os.vn
                LEFT OUTER JOIN kskdepartment sk on sk.depcode=os.opd_dep
                WHERE os.date_visit = "'.$date.'"
                and staff not in("kioskopd1","kioskopd","kioskncd","kioskpcc")  
                and authen_type is null
                ORDER BY os.time_visit
        ');
        $authenusernosuccess2 = DB::connection('mysql3')->select('
            SELECT os.vn,os.hn,os.date_visit,os.time_visit,os.fullname,oq.claim_code,oq.mobile,oq.claim_type,oq.authen_type,os.opd_dep,os.is_appoint,os.staff,sk.department
            FROM ovst_queue_server os
            LEFT OUTER JOIN ovst_queue_server_authen oq on oq.vn=os.vn
            LEFT OUTER JOIN kskdepartment sk on sk.depcode=os.opd_dep
            WHERE os.date_visit = "'.$date.'"
            and staff not in("kioskopd1","kioskopd","kioskncd","kioskpcc")  
            and authen_type <> "S"
            ORDER BY os.time_visit
        ');

        $authenusersuccess = DB::connection('mysql3')->select('
                SELECT os.vn,os.hn,os.date_visit,os.time_visit,os.fullname,oq.claim_code,oq.mobile,oq.claim_type,oq.authen_type,os.opd_dep,os.is_appoint,os.staff,sk.department
                FROM ovst_queue_server os
                LEFT OUTER JOIN ovst_queue_server_authen oq on oq.vn=os.vn
                LEFT OUTER JOIN kskdepartment sk on sk.depcode=os.opd_dep
                WHERE os.date_visit = "'.$date.'"
                and staff <>"kioskopd1" and staff <>"kioskopd" and staff <> "kioskncd" and staff <> "kioskpcc"
                and authen_type = "S"
                ORDER BY os.time_visit
        ');
        
        $authen_kiosnofinish = DB::connection('mysql3')->select('
            SELECT os.vn,os.hn,os.date_visit,os.time_visit,os.fullname,oq.claim_code,oq.mobile,oq.claim_type,oq.authen_type,os.opd_dep,os.is_appoint,os.staff,sk.department
            FROM ovst_queue_server os
                LEFT OUTER JOIN ovst_queue_server_authen oq on oq.vn=os.vn
                LEFT OUTER JOIN kskdepartment sk on sk.depcode=os.opd_dep
                WHERE os.date_visit = "'.$date.'"
                AND os.staff LIKE "kiosk%"
                AND oq.authen_type <>"S" 
                ORDER BY os.time_visit
 
        ');
        $authen_kiosnofinish2 = DB::connection('mysql3')->select('
         
            SELECT os.vn,os.hn,os.date_visit,os.time_visit,os.fullname,oq.claim_code,oq.mobile,oq.claim_type,oq.authen_type,os.opd_dep,os.is_appoint,os.staff,sk.department
            FROM ovst_queue_server os
            LEFT OUTER JOIN ovst_queue_server_authen oq on oq.vn=os.vn
            LEFT OUTER JOIN kskdepartment sk on sk.depcode=os.opd_dep
            WHERE os.date_visit = "'.$date.'"
            AND os.staff LIKE "kiosk%"
            AND oq.authen_type IS NULL 
            ORDER BY os.time_visit
        ');
        $authen_kios_finish = DB::connection('mysql3')->select('
                SELECT os.vn,os.hn,os.date_visit,os.time_visit,os.fullname,oq.claim_code,oq.mobile,oq.claim_type,oq.authen_type,os.opd_dep,os.is_appoint,os.staff,sk.department
                FROM ovst_queue_server os
                    LEFT OUTER JOIN ovst_queue_server_authen oq on oq.vn=os.vn
                    LEFT OUTER JOIN kskdepartment sk on sk.depcode=os.opd_dep
                    WHERE os.date_visit = "'.$date.'"
                    AND os.staff LIKE "kiosk%"
                    AND oq.authen_type ="S" 
                    ORDER BY os.time_visit

        ');

        $collection = Http::get('http://localhost:8189/api/nhso-service/latest-5-authen-code-all-hospital/3361000851691')->collect();
        $output = Arr::sort($collection);
        
        foreach ($output as $key => $value) {
            $claimType = $value['claimType'];
            $claimCode = $value['claimCode']; 
            $claimDateTime = $value['claimDateTime']; 
            $hcode = $value['hcode']; 
            $checkDate = $value['checkDate']; 
        }
        dd($claimDateTime);
        
        return view('authen_dashboard',[
            'authen'                   => $authen,
            'countalls'                => $countalls,
            'countkiosalls'            => $countkiosalls,
            'countkiosfinish'          => $countkiosfinish,
            'countkiosnofinish'        => $countkiosnofinish,
            'countonusers'             => $countonusers,
            'countonuserssuccess'      => $countonuserssuccess2,
            'countonusersnosuccess'    => $countonusersnosuccess,
            'countonuserst'            => $countonuserst,
            'countonuserssuccesstt'    => $countonuserssuccesstt,
            'countonusersnosuccesstt'  => $countonusersnosuccesstt,
            'authenusernosuccess'      => $authenusernosuccess,
            'authenusersuccess'        => $authenusersuccess,
            'countkiosallst'           => $countkiosallst,
            'countkiosfinisht'         => $countkiosfinisht,
            'countkiosnofinisht'       => $countkiosnofinisht,
            'authen_kiosnofinish'      => $authen_kiosnofinish,
            'countonuserssuccessdata'  => $countonuserssuccessdata,
            'authen_kiosnofinish2'     => $authen_kiosnofinish2,
            'authen_kios_finish'       => $authen_kios_finish,
            'authensuccess'            => $authensuccess,
            'authen_nosuccess'         => $authen_nosuccess,
            'authensuccesstt'          => $authensuccesstt,
            'authenusernosuccess2'     => $authenusernosuccess2,
            'authensuccess_alldata'    => $authensuccess_alldata          
        ] );
    }
    




}