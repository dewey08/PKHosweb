<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Visit_pttype_authen;
use App\Models\Visit_pttype_import;
use Illuminate\Support\Facades\DB;
use Http;
use SoapClient;
use File;
use SplFileObject;
use Arr;
use Storage;
use GuzzleHttp\Client;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportVisit_pttype_import;
// use Excel;

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
            LEFT OUTER JOIN kskdepartment sk on sk.depcode=o.main_dep
            LEFT OUTER JOIN patient p on p.hn=o.hn
            LEFT OUTER JOIN opduser op on op.loginname = o.staff
            WHERE o.vstdate = CURDATE()
            ORDER BY o.vsttime
        ');

        foreach ($countalls_data as $key => $value) {
            $countalls = $value->VN;
        }
        // SELECT os.vn,os.hn,os.date_visit,os.time_visit,os.fullname,oq.claim_code,oq.mobile,oq.claim_type,oq.authen_type,os.opd_dep,os.is_appoint,os.staff,sk.department
        // FROM ovst_queue_server os
        // LEFT OUTER JOIN ovst_queue_server_authen oq on oq.vn=os.vn
        // LEFT OUTER JOIN kskdepartment sk on sk.depcode=os.opd_dep
        // WHERE os.date_visit = CURDATE()
        // ORDER BY os.time_visit

        $authen = DB::connection('mysql3')->select('           
            SELECT o.vn,o.hn,o.vstdate,o.vsttime,p.cid,concat(p.pname,p.fname," ",p.lname) as fullname,oq.claim_code,oq.mobile,
                oq.claim_type,oq.authen_type,os.is_appoint,o.staff,op.name as fullname_staff,os.opd_dep,sk.department
                FROM ovst o
                LEFT OUTER JOIN ovst_queue_server os on os.vn = o.vn
                LEFT OUTER JOIN ovst_queue_server_authen oq on oq.vn = os.vn
                LEFT OUTER JOIN kskdepartment sk on sk.depcode=o.main_dep
                LEFT OUTER JOIN patient p on p.hn=o.hn
                LEFT OUTER JOIN opduser op on op.loginname = o.staff
                WHERE o.vstdate = CURDATE()
                ORDER BY o.vsttime
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
            LEFT OUTER JOIN kskdepartment sk on sk.depcode=o.main_dep
            LEFT OUTER JOIN patient p on p.hn=o.hn
            LEFT OUTER JOIN opduser op on op.loginname = o.staff
            WHERE o.vstdate = CURDATE()
            AND o.staff LIKE "kiosk%"
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
            LEFT OUTER JOIN visit_pttype v on v.vn=o.vn
            LEFT OUTER JOIN kskdepartment sk on sk.depcode=o.main_dep
            LEFT OUTER JOIN patient p on p.hn=o.hn
            LEFT OUTER JOIN visit_pttype_import vp on vp.cid = p.cid
            LEFT OUTER JOIN opduser op on op.loginname = o.staff
            WHERE o.vstdate = CURDATE()
            AND o.staff LIKE "kiosk%" 
            AND vp.claimcode is not null 
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

        $countkiosnofinish_newdata_show = DB::connection('mysql3')->select('
                SELECT o.vn,o.hn,vp.claimcode,p.hometel,v.project_code,o.vstdate,o.vsttime,p.cid,o.staff,concat(p.pname,p.fname," ",p.lname) as fullname,sk.department
                FROM ovst o
                LEFT OUTER JOIN visit_pttype v on v.vn=o.vn
                LEFT OUTER JOIN kskdepartment sk on sk.depcode=o.main_dep
                LEFT OUTER JOIN patient p on p.hn=o.hn
                LEFT OUTER JOIN visit_pttype_import vp on vp.cid = p.cid
                LEFT OUTER JOIN opduser op on op.loginname = o.staff
                WHERE o.vstdate = CURDATE()
                AND o.staff LIKE "kiosk%"
                AND vp.claimcode is null 
                ORDER BY o.vsttime
        ');

        $countkiosnofinish_newdata = DB::connection('mysql3')->select('
            SELECT COUNT(o.vn) as VN
            FROM ovst o
            LEFT OUTER JOIN visit_pttype v on v.vn=o.vn
            LEFT OUTER JOIN kskdepartment sk on sk.depcode=o.main_dep
            LEFT OUTER JOIN patient p on p.hn=o.hn
            LEFT OUTER JOIN visit_pttype_import vp on vp.cid = p.cid
            LEFT OUTER JOIN opduser op on op.loginname = o.staff
            WHERE o.vstdate = CURDATE()
            AND o.staff LIKE "kiosk%"
            AND vp.claimcode is null 
            ORDER BY o.vsttime
        ');
        foreach ($countkiosnofinish_newdata as $key => $value) {
            $countkiosnofinish_new = $value->VN;
        }
        if ($countkiosnofinish_new == 0) {
            $countkiosnofinish_newt = 1;
        } else {
            $countonus = 100 / $countalls ; 
            $countkiosnofinish_newt = $countonus * $countkiosnofinish_new;
            // dd($countkiosallst);
        }

        // $countonusers = DB::connection('mysql3')->table('ovst_queue_server')
        //     ->leftjoin('ovst_queue_server_authen','ovst_queue_server_authen.vn','=','ovst_queue_server.vn')
        //     ->where('date_visit','=',$date)
        //     ->where('staff','<>',['kioskopd1','kioskopd','kioskncd','kioskpcc'])
        //     // ->where('authen_type','<>','S')
        //     ->count();

        $countonusersdata = DB::connection('mysql3')->select('
            SELECT COUNT(o.vn) as VN
            FROM ovst o
            LEFT OUTER JOIN visit_pttype v on v.vn=o.vn
            LEFT OUTER JOIN patient p on p.hn=o.hn
            LEFT OUTER JOIN kskdepartment k on k.depcode=o.main_dep
            left outer join opduser ou on ou.loginname=o.staff
            WHERE o.vstdate = CURDATE()
            AND o.staff not LIKE "kiosk%"
        ');
        // $countonusersdata = DB::connection('mysql3')->select('
        //     SELECT COUNT(os.vn) as VN
        //     FROM ovst_queue_server os
        //     LEFT OUTER JOIN ovst_queue_server_authen oq on oq.vn=os.vn
        //     LEFT OUTER JOIN kskdepartment sk on sk.depcode=os.opd_dep
        //     WHERE os.date_visit = "'.$date.'"
        //     and staff <>"kioskopd1" and staff <>"kioskopd" and staff <> "kioskncd" and staff <> "kioskpcc" 
        //     ORDER BY os.time_visit
        // ');

        foreach ($countonusersdata as $key => $value) {
            $countonusers = $value->VN;
        }
        // $countonuserssuccess = DB::connection('mysql3')->table('ovst_queue_server')
        // ->leftjoin('ovst_queue_server_authen','ovst_queue_server_authen.vn','=','ovst_queue_server.vn')
        // ->where('date_visit','=',$date)
        // ->where('staff','<>',['kioskopd1','kioskopd','kioskncd','kioskpcc'])
        // ->where('authen_type','=','S')
        // ->count();

        $countonuserssuccessdatanew = DB::connection('mysql3')->select('
            SELECT COUNT(o.vn) as VN
            FROM ovst o
            LEFT OUTER JOIN kskdepartment sk on sk.depcode=o.main_dep
            LEFT OUTER JOIN patient p on p.hn=o.hn
            LEFT OUTER JOIN visit_pttype_import vp on vp.cid = p.cid
            LEFT OUTER JOIN opduser op on op.loginname = o.staff
            WHERE o.vstdate = CURDATE()
            AND vp.claimcode is not null
            ORDER BY o.vsttime
        ');
        foreach ($countonuserssuccessdatanew as $key => $value) {
            $countonuserssuccessnew = $value->VN;
        }

        if ($countonuserssuccessnew == 0) {
            $countonuserssuccesstt = 1;
        } else {
            $countonuss = 100 / $countalls ; 
            $countonuserssuccesstt = $countonuss * $countonuserssuccessnew;
            // dd($countonuserssuccesstt);
        }


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
        // if ($countonuserssuccess2 == 0) {
        //     $countonuserssuccesstt = 1;
        // } else {
        //     $countonuss = 100 / $countalls ; 
        //     $countonuserssuccesstt = $countonuss * $countonuserssuccess2;
        //     // dd($countonuserssuccesstt);
        // }

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
            SELECT o.vn,o.hn,o.vstdate,o.vsttime,p.cid,concat(p.pname,p.fname," ",p.lname) as fullname,oq.claim_code,vp.claimcode,oq.mobile,
            oq.claim_type,oq.authen_type,os.is_appoint,o.staff,op.name as fullname_staff,os.opd_dep,sk.department
            FROM ovst o
            LEFT OUTER JOIN ovst_queue_server os on os.vn = o.vn
            LEFT OUTER JOIN ovst_queue_server_authen oq on oq.vn = os.vn
            LEFT OUTER JOIN kskdepartment sk on sk.depcode=o.main_dep
            LEFT OUTER JOIN patient p on p.hn=o.hn
            LEFT OUTER JOIN visit_pttype_import vp on vp.cid = p.cid
            LEFT OUTER JOIN opduser op on op.loginname = o.staff
            WHERE o.vstdate = CURDATE()
            AND vp.claimcode is not null
            ORDER BY o.vsttime
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
            SELECT o.vn,o.hn,vp.claimcode,p.hometel,v.project_code,o.vstdate,o.vsttime,p.cid,o.staff,concat(p.pname,p.fname," ",p.lname) as fullname,sk.department
            FROM ovst o
            LEFT OUTER JOIN visit_pttype v on v.vn=o.vn
            LEFT OUTER JOIN kskdepartment sk on sk.depcode=o.main_dep
            LEFT OUTER JOIN patient p on p.hn=o.hn
            LEFT OUTER JOIN visit_pttype_import vp on vp.cid = p.cid
            LEFT OUTER JOIN opduser op on op.loginname = o.staff
            WHERE o.vstdate = CURDATE()
            AND o.staff LIKE "kiosk%" 
            AND vp.claimcode is not null
            ORDER BY o.vsttime

        ');

        $user_all = DB::connection('mysql3')->select('
                SELECT o.hn,o.vn,p.cid,v.auth_code,concat(p.pname,p.fname," ",p.lname) as fullname,o.staff,ou.name,k.department
                FROM ovst o
                LEFT OUTER JOIN visit_pttype v on v.vn=o.vn
                LEFT OUTER JOIN patient p on p.hn=o.hn
                LEFT OUTER JOIN kskdepartment k on k.depcode=o.main_dep
                left outer join opduser ou on ou.loginname=o.staff
                WHERE o.vstdate = CURDATE()
                AND o.staff not LIKE "kiosk%"
            ');
        // dd($user_all);
        foreach ($user_all as $key => $value) {
            $cid = $value->cid;
            // dd($cid);
            // $collection = Http::get('http://localhost:8189/api/nhso-service/latest-5-authen-code-all-hospital/"'.$cid.'"')->collect();
            // $output = Arr::sort($collection);
        }
        // dd($cid);latest-authen-code
        // $collection = Http::get('http://localhost:8189/api/nhso-service/latest-authen-code/"'.$cid.'"')->collect();
        // $collection = Http::get('http://localhost:8189/api/nhso-service/latest-5-authen-code-all-hospital/3361000463241')->collect();
        // $output = Arr::sort($collection);
        
        // foreach ($output as $key => $value) {
        //     $claimType = $value['claimType'];
        //     $claimCode = $value['claimCode']; 
        //     $claimDateTime = $value['claimDateTime']; 
        //     $hcode = $value['hcode']; 
        //     $checkDate = $value['checkDate']; 
        // }
        // dd($output);
        $countonusersnosuccess_showdata = DB::connection('mysql3')->select('
            SELECT COUNT(os.vn) as VN
            FROM ovst_queue_server os
            LEFT OUTER JOIN ovst_queue_server_authen oq on oq.vn=os.vn
            LEFT OUTER JOIN kskdepartment sk on sk.depcode=os.opd_dep
            WHERE os.date_visit = "'.$date.'"
            and staff not in("kioskopd1","kioskopd","kioskncd","kioskpcc")            
            and authen_type <> "S"
            ORDER BY os.time_visit
        ');
        foreach ($countonusersnosuccess_showdata as $key => $value) {
            $usersnosuccess = $value->VN;
        }
        
        return view('authen_dashboard',[
            'user_all'                   => $user_all,
            'countkiosnofinish_new'           => $countkiosnofinish_new,
            'countkiosnofinish_newt'          => $countkiosnofinish_newt,
            'countkiosnofinish_newdata_show'  => $countkiosnofinish_newdata_show,
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
            'authensuccess_alldata'    => $authensuccess_alldata ,
            'countonuserssuccessnew'   => $countonuserssuccessnew         
        ] );
    }
    public function import(Request $request)
    {
        Excel::import(new ImportVisit_pttype_import, $request->file('file')->store('files'));
        // Excel::import(new ImportVisit_pttype_import, $request->file('select_file')->store('files'));
        // $this->validate($request, [
        //     'select_file'  => 'required|mimes:xls,xlsx'
        //    ]);
      
        //    $path = $request->file('select_file')->getRealPath();
        //    $data = Excel::load($path)->get();
        //    $data = Excel::import(new ImportVisit_pttype_import,$path);
        //    $data = Excel::import($path);
      
        //    if($data->count() > 0)
        //    {
        //     foreach($data->toArray() as $key => $value)
        //     {
        //      foreach($value as $row)
        //      {
        //       $insert_data[] = array(
        //        'hcode'           => $row['hcode'],
        //        'hosname'         => $row['hosname'],
        //        'cid'             => $row['cid'],
        //        'fullname'        => $row['fullname'],
        //        'birthday'        => $row['birthday'],
        //        'homtel'          => $row['homtel'],
        //        'mainpttype'      => $row['mainpttype'],
        //        'subpttype'       => $row['subpttype'],
        //        'repcode'         => $row['repcode'],
        //        'claimcode'       => $row['claimcode'],
        //        'claimtype'       => $row['claimtype'],
        //        'servicerep'      => $row['servicerep'],
        //        'servicename'     => $row['servicename'],
        //        'hncode'          => $row['hncode'],
        //        'ancode'          => $row['ancode'],
        //        'vstdate'         => $row['vstdate'],
        //        'regdate'         => $row['regdate'],
        //        'status'          => $row['status'],
        //        'repauthen'       => $row['repauthen'],
        //        'authentication'  => $row['authentication'],
        //        'staffservice'    => $row['staffservice'],
        //        'dateeditauthen'  => $row['dateeditauthen'],
        //        'nameeditauthen'  => $row['nameeditauthen'],
        //        'comment'         => $row['comment'] 
        //       );
        //      }
        //     }
      
        //     if(!empty($insert_data))
        //     {
        //      DB::table('visit_pttype_import')->insert($insert_data);
        //     }
        //    }
        return response()->json([
            'status'    => '200',
            // 'borrow'    =>  $borrow
        ]); 
    }
    public function authen_check(Request $request)
    {
        // return $request->all();
        if($request->cid != '' || $request->cid != null){
        
        $cid        = $request->cid;
        $vn         = $request->vn;
        $hn         = $request->hn;
        $auth_code  = $request->auth_code;
        $fullname   = $request->fullname;
        $department = $request->department;
        $staff      = $request->staff;
        $name       = $request->name;

            $number =count($cid);
            $i = 0;
            for($i = 0; $i< $number; $i++)
            { 
                // $data = DB::table('visit_pttype_authen')->get();
                $dataauthen = Visit_pttype_authen::where('visit_pttype_authen_cid','=',$cid[$i])->first();


            }

 
            // $cids = $cid[$count];

        }

        return  $cid;
    }
    public function import_authen_auto(Request $request)
    {
        return view('import_authen_auto');
    }
    public function authen_realtime(Request $request)
    {
        $date_now = date("Y-m-d");
        $s_cid = "SELECT 
		v.vn ,v.hn ,v.cid
		,vp.claim_code
		,p.pttype ,p.hipdata_code
		,cab.*
		FROM vn_stat v
		LEFT JOIN visit_pttype vp ON v.vn=vp.vn
		LEFT JOIN pttype p ON v.pttype=p.pttype
		LEFT JOIN 
         cab ON v.vn=cab.z_vn
		WHERE v.vstdate = '$date_now'
		AND (vp.claim_code IS NULL OR vp.claim_code='')
		-- AND hipdata_code='UCS' 
		ORDER BY z_time
		LIMIT 10";
        -- $s_cid = DB::connection('mysql3')->select('
        --     SELECT
        --     v.vn ,v.hn ,v.cid
        --     ,vp.claim_code
        --     ,p.pttype ,p.hipdata_code
        --     ,cab.*
        --     FROM vn_stat v
        --     LEFT JOIN visit_pttype vp ON v.vn = vp.vn
        --     LEFT JOIN pttype p ON v.pttype = p.pttype
        --     LEFT JOIN cab ON v.vn = cab.z_vn
        --     WHERE v.vstdate = "'.$date_now.'"
        --     AND (vp.claim_code IS NULL OR vp.claim_code =" ")
          
        --     ORDER BY z_time
        --     LIMIT 10');

        -- // $q_cid = mysqli_query($con_hos, $s_cid) or die(mysqli_error($con_hos));
     
        -- // while($r_cid = mysqli_fetch_array($q_cid)){
        -- // $cid=$r_cid['cid'];
        -- // $vn=$r_cid['vn'];

        --     // $curl = curl_init();
        --     //     curl_setopt_array($curl, array(
        --     //     CURLOPT_URL => "http://localhost:8189/api/nhso-service/latest-authen-code/$cid",
            -- //     CURLOPT_RETURNTRANSFER => 1,
            -- //     CURLOPT_SSL_VERIFYHOST => 0,
            -- //     CURLOPT_SSL_VERIFYPEER => 0,
            -- //     CURLOPT_CUSTOMREQUEST => 'GET',
            -- // ));
		 
            -- // $response = curl_exec($curl);
            -- // curl_close($curl);
            -- // $content = $response;
            -- // $result = json_decode($content, true);
            -- // @$hcode = $result['hcode'];

            -- // @$ex_claimDateTime = explode("T",$result['claimDateTime']);
            -- // $claimDate=$ex_claimDateTime[0];
            -- // echo "<BR>";
            
            -- // @$claimCode = $result['claimCode'];

            -- // $ex_checkDate = explode("T",$result['checkDate']);
            -- // $checkTime=$ex_checkDate[1];

        return view('authen_realtime');
        -- // return response([ 
        -- //     $getovst_key 
        -- // ]);
    }
    -- // public function authen_check(Request $request)
    -- // { 
    -- //     $client = new \GuzzleHttp\Client();
    -- //     $request = $client->get('http://localhost:8189/api/nhso-service/latest-5-authen-code-all-hospital/3361000463241');
    -- //     $response = $request->getBody();
    
    -- //     dd($response);
    -- //     // $collection = Http::get('http://localhost:8189/api/nhso-service/latest-5-authen-code-all-hospital/3361000463241')->collect();
    -- //     // $output = Arr::sort($collection);
        
    -- //     // foreach ($output as $key => $value) {
    -- //     //     $claimType = $value['claimType'];
    -- //     //     $claimCode = $value['claimCode']; 
    -- //     //     $claimDateTime = $value['claimDateTime']; 
    -- //     //     $hcode = $value['hcode']; 
    -- //     //     $checkDate = $value['checkDate']; 
    -- //     // }
    -- //     $cid = $request->cid;

    -- //     $client = new Client();
    -- //     $response = $client->request( 'GET', $url, $options );
    -- //     echo $response->getBody();


    -- //     $apiURL = Http::get('http://localhost:8189/api/nhso-service/latest-5-authen-code-all-hospital/3361000463241')->collect();
    -- //     $postInput = [
    -- //         'cid' => 'cid',
    -- //         'vn' => 'vn' 
    -- //     ];
  
    -- //     $headers = [
    -- //         'X-header' => 'value'
    -- //     ];
  
    -- //     $response = Http::withHeaders($headers)->post($apiURL, $postInput);
  
    -- //     $statusCode = $response->status();
    -- //     $responseBody = json_decode($response->getBody(), true);
     
    -- //     dd($responseBody);

    -- //     // $data = [
    -- //     //     'cid' => $request->cid,
    -- //     //     'vn' => $request->vn,
    -- //     // ];
    -- //     // $curl = curl_init();

    -- //     // curl_setopt_array($curl, array(
    -- //     //     CURLOPT_URL => "http://localhost:8189/api/nhso-service/latest-5-authen-code-all-hospital/'.$cid.'",// your preferred url
    -- //     //     CURLOPT_RETURNTRANSFER => true,
    -- //     //     CURLOPT_ENCODING => "",
    -- //     //     CURLOPT_MAXREDIRS => 10,
    -- //     //     CURLOPT_TIMEOUT => 30000,
    -- //     //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    -- //     //     CURLOPT_CUSTOMREQUEST => "POST",
    -- //     //     CURLOPT_POSTFIELDS => json_encode($cid),
    -- //     //     CURLOPT_HTTPHEADER => array(
    -- //     //         // Set here requred headers
    -- //     //         "accept: */*",
    -- //     //         "accept-language: en-US,en;q=0.8",
    -- //     //         "content-type: application/json",
    -- //     //     ),
    -- //     // ));
    -- //     // $response = curl_exec($curl);
    -- //     // $err = curl_error($curl);
        
    -- //     // curl_close($curl);
    -- //     // if ($err) {
    -- //     //     echo "cURL Error #:" . $err;
    -- //     // } else {
    -- //     //   print_r(json_decode($response));
    -- //     // }

    -- //     // dd($cid);

    -- //     $collection = Http::get('http://localhost:8189/api/nhso-service/latest-5-authen-code-all-hospital/',['cid' => $cid]);
    -- //     $output = Arr::sort($collection);
    -- //     dd($output);

    -- //     if($request->cid != '' || $request->cid != null){
       
    -- //         $cid = $request->cid;
    -- //         $vn = $request->vn;
    -- //         // dd($cid);
    -- //         // foreach ($cid as $key => $value) {
    -- //             // dd($value);
                

    -- //             // $collection = Http::get('http://localhost:8189/api/nhso-service/latest-5-authen-code-all-hospital/"'.$cid.'"')->collect();
    -- //             // $output = Arr::sort($collection);
    -- //             // dd($output);
    -- //         // }


    -- //         $number =count($cid);
    -- //         $count = 0;
    -- //         for($count = 0; $count< $number; $count++)
    -- //             {
    -- //                 $cids = $cid[$count];

    -- //                 // $curl = curl_init();

    -- //                 // curl_setopt_array($curl, array(
    -- //                 //     CURLOPT_URL => "http://localhost:8189/api/nhso-service/latest-5-authen-code-all-hospital/'.$cids.'",// your preferred url
    -- //                 //     CURLOPT_RETURNTRANSFER => true,
    -- //                 //     CURLOPT_ENCODING => "",
    -- //                 //     CURLOPT_MAXREDIRS => 10,
    -- //                 //     CURLOPT_TIMEOUT => 30000,
    -- //                 //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    -- //                 //     CURLOPT_CUSTOMREQUEST => "POST",
    -- //                 //     CURLOPT_POSTFIELDS => json_encode($cids),
    -- //                 //     CURLOPT_HTTPHEADER => array(
    -- //                 //         // Set here requred headers
    -- //                 //         "accept: */*",
    -- //                 //         "accept-language: en-US,en;q=0.8",
    -- //                 //         "content-type: application/json",
    -- //                 //     ),
    -- //                 // ));
    -- //                 // $response = curl_exec($curl);
    -- //                 // $err = curl_error($curl);
                    
    -- //                 // curl_close($curl);
    -- //                 // if ($err) {
    -- //                 //     echo "cURL Error #:" . $err;
    -- //                 // } else {
    -- //                 // print_r(json_decode($response));
    -- //                 // }

    -- //                 // dd($cids);
    -- //                 // $collection = Http::get('http://localhost:8189/api/nhso-service/latest-5-authen-code-all-hospital/3361001014636')->collect();
    -- //                 // $output = Arr::sort($collection);
    -- //                 // dd($output);
    -- //                 // $collection = Http::get('http://localhost:8189/api/nhso-service/latest-5-authen-code-all-hospital/"'.$cids.'"')->collect();
    -- //                 // $output = Arr::sort($collection);
    -- //                 // $add= new Clinic_drug();
    -- //                 // $add->DRUG_CODE = $d_icode[$count];
    -- //                 // $add->DRUG_NAME = $d_name[$count]; 
    -- //                 // $add->save();
    -- //             }
    -- //             dd($output);
    -- //     }

        
    -- //     return view('authen_dashboard');
    -- // }



}