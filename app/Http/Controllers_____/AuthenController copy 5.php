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
        
        $data_dep = DB::connection('mysql3')->select(' 
                SELECT o.main_dep,sk.department,COUNT(o.vn) as VN   
                FROM ovst o 
                LEFT JOIN visit_pttype v on v.vn=o.vn
                LEFT JOIN vn_stat vs on vs.vn=o.vn
                LEFT JOIN visit_pttype_authen vpa on vpa.visit_pttype_authen_vn=o.vn
                LEFT OUTER JOIN kskdepartment sk on sk.depcode=o.main_dep
                WHERE o.vstdate = CURDATE()  
                
                GROUP BY o.main_dep
        ');
        
        foreach ($data_dep as $key => $value2) {
            $maindep = $value2->main_dep;
        }
        $data_ = DB::connection('mysql')->select(' 
                SELECT *   
                FROM dashboard_authen_day 
                WHERE vstdate = CURDATE()   
        ');
         foreach ($data_ as $key => $value) {
            $vn_ = $value->vn;
            $Kios_ = $value->Kios;
            $Staff_ = $value->Staff;
            $Success_ = $value->Total_Success;
            // $Unsuccess_ = $value->Unsuccess;
        } 
        $data_department = DB::connection('mysql')->select(' 
                SELECT *   
                FROM dashboard_department_authen 
                WHERE vstdate = CURDATE()  
                ORDER BY main_dep DESC 
        ');
        $data_staff = DB::connection('mysql')->select(' 
                SELECT *
                FROM dashboard_authenstaff_day 
                WHERE vstdate = CURDATE() 
                ORDER BY length(vn) DESC, vn DESC 
        ');
        // $data_staff = DB::connection('mysql3')->select(' 
        //         SELECT o.main_dep,o.staff,op.name as Staffname,s.name as Spclty 
        //         FROM ovst o 
        //         LEFT OUTER JOIN kskdepartment sk on sk.depcode=o.main_dep
        //         LEFT OUTER JOIN spclty s ON s.spclty = sk.spclty
        //         LEFT OUTER JOIN patient p on p.hn=o.hn
        //         LEFT OUTER JOIN visit_pttype_authen_report vp ON vp.personalId = p.cid and vp.claimDate = o.vstdate
        //         LEFT OUTER JOIN opduser op on op.loginname = o.staff
        //         WHERE o.vstdate = CURDATE() GROUP BY op.name
        // ');

        return view('authen_dashboard',[ 
            'vn'               => $vn_,
            'Kios'             => $Kios_,
            'Staff'            => $Staff_,
            'Success'          => $Success_,
            'data_dep'         => $data_dep,
            'data_department'  => $data_department,
            'data_staff'       => $data_staff,
        ] );
    }
    // public function authen_dashboard(Request $request)
    // {
    //     $date = date('Y-m-d');
       
        // $countalls_data = DB::connection('mysql3')->select('
          
            // SELECT 
            // COUNT(DISTINCT o.vn) as VN
            // ,COUNT(wr.claimType) as UserAuthen
            // ,COUNT(oq.claim_code) as KiosAuthen 
            // ,COUNT((wr.claimType)+(oq.claim_code)) as Authensend
            // ,COUNT(wr.tel) as Tel
            // ,MONTH(o.vstdate) as month
            // ,YEAR(o.vstdate) as year
            // ,DAY(o.vstdate) as day
            // ,o.vstdate

            // FROM ovst o
            // LEFT OUTER JOIN visit_pttype v on v.vn=o.vn
            // LEFT OUTER JOIN ovst_queue_server os on os.vn = o.vn
            // LEFT OUTER JOIN ovst_queue_server_authen oq on oq.vn = os.vn
            // LEFT OUTER JOIN kskdepartment sk on sk.depcode=o.main_dep
            // LEFT OUTER JOIN patient p on p.hn=o.hn
            // LEFT OUTER JOIN visit_pttype_authen_report wr ON wr.personalId = p.cid
            // LEFT OUTER JOIN opduser op on op.loginname = o.staff
           
            // WHERE o.vstdate = CURDATE()
            

        // ');

        // foreach ($countalls_data as $key => $value) {
        //     $countallstt = $value->VN;

        //     if ($countallstt == 0) {
        //         $countalls = 1;
        //     } else {
        //         $countalls = $countallstt;
        //     }
            
        // }
       
        // $authen = DB::connection('mysql3')->select('           
        //     SELECT o.vn,o.hn,o.vstdate,o.vsttime,p.cid,concat(p.pname,p.fname," ",p.lname) as fullname,oq.claim_code,oq.mobile,
        //         oq.claim_type,oq.authen_type,os.is_appoint,o.staff,op.name as fullname_staff,os.opd_dep,sk.department
        //         FROM ovst o
        //         LEFT OUTER JOIN ovst_queue_server os on os.vn = o.vn
        //         LEFT OUTER JOIN ovst_queue_server_authen oq on oq.vn = os.vn
        //         LEFT OUTER JOIN kskdepartment sk on sk.depcode=o.main_dep
        //         LEFT OUTER JOIN patient p on p.hn=o.hn
        //         LEFT OUTER JOIN opduser op on op.loginname = o.staff
        //         WHERE o.vstdate = CURDATE()
        //         ORDER BY o.vsttime
        // ');
        // $authensuccess_data = DB::connection('mysql3')->select('         
        //     SELECT COUNT(o.vn) as VN
        //         FROM ovst_queue_server o
        //         LEFT OUTER JOIN ovst_queue_server_authen v on v.vn=o.vn
        //         LEFT OUTER JOIN vn_stat vn on vn.vn=o.vn
        //         LEFT OUTER JOIN patient p on p.hn=o.hn
        //         WHERE o.date_visit = CURDATE()
        //         AND v.claim_code is not null
        //         AND v.authen_type ="s"
        // ');
        // foreach ($authensuccess_data as $key => $value) {
        //     $authensuccess = $value->VN;
        // }
        // if ($authensuccess == 0) {
        //     $authensuccesstt = 1;
        // } else {
        //     $countonus = 100 / $countalls ; 
            
        //     $authensuccesstt = $countonus * $authensuccess;
           
        // }
        // $authensuccess_alldata = DB::connection('mysql3')->select('         
        //     SELECT os.vn,os.hn,os.date_visit,os.time_visit,os.fullname,oq.claim_code,oq.mobile,oq.claim_type,oq.authen_type,os.opd_dep,os.is_appoint,os.staff,sk.department
        //         FROM ovst_queue_server os
        //         LEFT OUTER JOIN ovst_queue_server_authen oq on oq.vn=os.vn
        //         LEFT OUTER JOIN kskdepartment sk on sk.depcode=os.opd_dep
        //         LEFT OUTER JOIN vn_stat vn on vn.vn=os.vn
        //         LEFT OUTER JOIN patient p on p.hn=os.hn
        //         WHERE os.date_visit = CURDATE()
        //         AND oq.claim_code is not null
        //         AND oq.authen_type ="s"
        //     ');

        // $authen_nosuccess_data = DB::connection('mysql3')->select('         
        //     SELECT COUNT(o.vn) as VN
        //         FROM ovst_queue_server o
        //         LEFT OUTER JOIN ovst_queue_server_authen v on v.vn=o.vn
        //         LEFT OUTER JOIN vn_stat vn on vn.vn=o.vn
        //         LEFT OUTER JOIN patient p on p.hn=o.hn
        //         WHERE o.date_visit = CURDATE() 
        //         AND v.authen_type <>"s"
        // ');
        // foreach ($authen_nosuccess_data as $key => $value) {
        //     $authen_nosuccess = $value->VN;
        // }
          
 
        // $countkiosallsdata = DB::connection('mysql3')->select('
        //     SELECT COUNT(DISTINCT o.vn) as VN
        //             ,COUNT(wr.claimType) as UserAuthen
        //             ,COUNT(oq.claim_code) as KiosAuthen 
        //             ,COUNT((wr.claimType)+(oq.claim_code)) as Authensend
        //             ,COUNT(wr.tel) as Tel
        //             ,MONTH(o.vstdate) as month
        //             ,YEAR(o.vstdate) as year
        //             ,DAY(o.vstdate) as day
        //             ,o.vstdate

        //         FROM ovst o
        //             LEFT OUTER JOIN visit_pttype v on v.vn=o.vn					
        //             LEFT OUTER JOIN ovst_queue_server os on os.vn = o.vn
        //             LEFT OUTER JOIN ovst_queue_server_authen oq on oq.vn = os.vn					
        //             LEFT OUTER JOIN kskdepartment sk on sk.depcode=o.main_dep
        //             LEFT OUTER JOIN patient p on p.hn=o.hn
        //             LEFT OUTER JOIN visit_pttype_authen_report wr ON wr.personalId = p.cid
        //             LEFT OUTER JOIN opduser op on op.loginname = o.staff
        //             WHERE o.vstdate = CURDATE()
        //             AND os.staff LIKE "kiosk%"
        //             ORDER BY o.vsttime
        //         ');
        //         foreach ($countkiosallsdata as $key => $value) {
        //             $countkiosalls = $value->VN;
        //         }

        //         if ($countkiosalls == 0) {
        //             $countkiosallst = 1;
        //         } else {
        //             $countonus = 100 / $countalls ; 
        //             $countkiosallst = $countonus * $countkiosalls;
        //             // dd($countkiosallst);
        //         }
        
        //         $countkiosfinishdata = DB::connection('mysql3')->select('
        //             SELECT COUNT(o.vn) as VN
        //             FROM ovst o
        //             LEFT OUTER JOIN visit_pttype v on v.vn=o.vn
        //             LEFT OUTER JOIN kskdepartment sk on sk.depcode=o.main_dep
        //             LEFT OUTER JOIN patient p on p.hn=o.hn
        //             LEFT OUTER JOIN visit_pttype_authen_report vp on vp.personalId = p.cid
        //             LEFT OUTER JOIN opduser op on op.loginname = o.staff
        //             WHERE o.vstdate = CURDATE()
        //             AND o.staff LIKE "kiosk%" 
        //             AND vp.claimCode is not null 
        //         ');
        //         foreach ($countkiosfinishdata as $key => $value) {
        //             $countkiosfinish = $value->VN;
        //         }

        //         if ($countkiosfinish == 0) {
        //             $countkiosfinisht = 1;
        //         } else {
        //             $countonus = 100 / $countalls ; 
        //             $countkiosfinisht = $countonus * $countkiosfinish;
        //             // dd($countkiosallst);
        //         }

        //         $countkiosnofinishdata1 = DB::connection('mysql3')->select('
        //             SELECT COUNT(os.vn) as VN
        //             FROM ovst_queue_server os
        //             LEFT OUTER JOIN ovst_queue_server_authen oq on oq.vn=os.vn
        //             WHERE os.date_visit = "'.$date.'"
        //             AND os.staff LIKE "kiosk%"
        //             AND oq.authen_type <>"S" 
        //             ORDER BY os.time_visit
        
        //         ');
        //         foreach ($countkiosnofinishdata1 as $key => $value) {
        //             $countkiosnofinish1 = $value->VN;
        //         }
        //         $countkiosnofinishdata2 = DB::connection('mysql3')->select('
        //             SELECT COUNT(os.vn) as VN
        //             FROM ovst_queue_server os
        //             LEFT OUTER JOIN ovst_queue_server_authen oq on oq.vn=os.vn
        //             WHERE os.date_visit = "'.$date.'"
        //             AND os.staff LIKE "kiosk%"
        //             AND oq.authen_type IS NULL 
        //             ORDER BY os.time_visit

        //         ');
        //         foreach ($countkiosnofinishdata2 as $key => $value) {
        //             $countkiosnofinish2 = $value->VN;
        //         }

        //         $countkiosnofinish = $countkiosnofinish1 + $countkiosnofinish2;
            
        //         if ($countkiosnofinish == 0) {
        //             $countkiosnofinisht = 1;
        //         } else {
        //             $countonus = 100 / $countalls ; 
        //             $countkiosnofinisht = $countonus * $countkiosnofinish;
        //             // dd($countkiosallst);
        //         }

        //         $countkiosnofinish_newdata_show = DB::connection('mysql3')->select('
        //                 SELECT o.vn,o.hn,vp.claimCode,p.hometel,v.project_code,o.vstdate,o.vsttime,p.cid,o.staff,concat(p.pname,p.fname," ",p.lname) as fullname,sk.department
        //                 FROM ovst o
        //                 LEFT OUTER JOIN visit_pttype v on v.vn=o.vn
        //                 LEFT OUTER JOIN kskdepartment sk on sk.depcode=o.main_dep
        //                 LEFT OUTER JOIN patient p on p.hn=o.hn
        //                 LEFT OUTER JOIN visit_pttype_authen_report vp on vp.personalId = p.cid

        //                 LEFT OUTER JOIN opduser op on op.loginname = o.staff
        //                 WHERE o.vstdate = CURDATE()
        //                 AND o.staff LIKE "kiosk%"
        //                 AND vp.claimCode is null 
        //                 ORDER BY o.vsttime
        //         ');

        //         $countkiosnofinish_newdata = DB::connection('mysql3')->select('
        //             SELECT COUNT(o.vn) as VN
        //             FROM ovst o
        //             LEFT OUTER JOIN visit_pttype v on v.vn=o.vn
        //             LEFT OUTER JOIN kskdepartment sk on sk.depcode=o.main_dep
        //             LEFT OUTER JOIN patient p on p.hn=o.hn
        //             LEFT OUTER JOIN visit_pttype_authen_report vp on vp.personalId = p.cid
        //             LEFT OUTER JOIN opduser op on op.loginname = o.staff
        //             WHERE o.vstdate = CURDATE()
        //             AND o.staff LIKE "kiosk%"
        //             AND vp.claimCode is null 
        //             ORDER BY o.vsttime
        //         ');
        //         foreach ($countkiosnofinish_newdata as $key => $value) {
        //             $countkiosnofinish_new = $value->VN;
        //         }
        //         if ($countkiosnofinish_new == 0) {
        //             $countkiosnofinish_newt = 1;
        //         } else {
        //             $countonus = 100 / $countalls ; 
        //             $countkiosnofinish_newt = $countonus * $countkiosnofinish_new;
        //             // dd($countkiosallst);
        //         }
        
        //         $count_success_data = DB::connection('mysql3')->select('
        //                 SELECT COUNT(*) as VN
        //                     FROM visit_pttype_authen_report
        //                     WHERE claimDate = CURDATE()
                                
        //     ');
        // foreach ($count_success_data as $key => $value) {
        //     $count_success = $value->VN;
        // }

        // if ($count_success == 0) {
        //     $count_successt = 1;
        // } else {
           
        //     $countonusss = 100 / $countalls ; 
            
        //     $count_successt = $countonusss * $count_success; 
        // }
 

        // $countonusers = $countalls - $countkiosalls;
 
        // $countonuserssuccessdatanew = DB::connection('mysql3')->select('
        //     SELECT COUNT(o.vn) as VN
        //     FROM ovst o
        //     LEFT OUTER JOIN kskdepartment sk on sk.depcode=o.main_dep
        //     LEFT OUTER JOIN patient p on p.hn=o.hn
        //     LEFT OUTER JOIN visit_pttype_authen_report vp on vp.personalId = p.cid
        //     LEFT OUTER JOIN opduser op on op.loginname = o.staff
        //     WHERE o.vstdate = CURDATE()
        //     AND vp.claimCode is not null
        //     ORDER BY o.vsttime
        // ');
        // foreach ($countonuserssuccessdatanew as $key => $value) {
        //     $countonuserssuccessnew = $value->VN;
        // }

        // if ($countonuserssuccessnew == 0) {
        //     $countonuserssuccesstt = 1;
        // } else {
        //     $countonuss = 100 / $countalls ; 
        //     $countonuserssuccesstt = $countonuss * $countonuserssuccessnew;
            
        // }


        // $countonuserssuccessdata = DB::connection('mysql3')->select('
        //     SELECT COUNT(os.vn) as VN
        //     FROM ovst_queue_server os
        //     LEFT OUTER JOIN ovst_queue_server_authen oq on oq.vn=os.vn
        //     LEFT OUTER JOIN kskdepartment sk on sk.depcode=os.opd_dep
        //     WHERE os.date_visit = "'.$date.'"
        //     and staff not in("kioskopd1","kioskopd","kioskncd","kioskpcc") 
        //     and authen_type = "S"
        //     ORDER BY os.time_visit
        // ');
        // foreach ($countonuserssuccessdata as $key => $value) {
        //     $countonuserssuccess2 = $value->VN;
        // }
        
        // $countonusersnosuccessdata1 = DB::connection('mysql3')->select('
        //     SELECT COUNT(os.vn) as VN
        //     FROM ovst_queue_server os
        //     LEFT OUTER JOIN ovst_queue_server_authen oq on oq.vn=os.vn
        //     LEFT OUTER JOIN kskdepartment sk on sk.depcode=os.opd_dep
        //     WHERE os.date_visit = "'.$date.'"
        //     and staff not in("kioskopd1","kioskopd","kioskncd","kioskpcc")            
        //     and authen_type <> "S"
        //     ORDER BY os.time_visit
        // ');
       
        // foreach ($countonusersnosuccessdata1 as $key => $value) {
        //     $countonusersnosuccess1 = $value->VN;
        // }
        // $countonusersnosuccessdata2 = DB::connection('mysql3')->select('
        //     SELECT COUNT(os.vn) as VN
        //     FROM ovst_queue_server os
        //     LEFT OUTER JOIN ovst_queue_server_authen oq on oq.vn=os.vn
        //     LEFT OUTER JOIN kskdepartment sk on sk.depcode=os.opd_dep
        //     WHERE os.date_visit = "'.$date.'"
        //     and staff not in("kioskopd1","kioskopd","kioskncd","kioskpcc")            
        //     AND oq.authen_type IS NULL 
        //     ORDER BY os.time_visit
        // ');
       
        // foreach ($countonusersnosuccessdata2 as $key => $value) {
        //     $countonusersnosuccess2 = $value->VN;
        // }

        // $countonusersnosuccess = $countonusersnosuccess1 + $countonusersnosuccess2;
     
        // if ($countonusers == 0) {
        //     $countonuserst = 1;
        // } else {
        //     $countonus = 100 / $countalls ; 
        //     $countonuserst = $countonus * $countonusers;
           
        // }
         
        // if ($countonusersnosuccess == 0) {
        //     $countonusersnosuccesstt = 1;
        // } else {
        //     $countonusss = 100 / $countalls ; 
        //     $countonusersnosuccesstt = $countonusss * $countonusersnosuccess;
            
        // }
        
        // $authenusernosuccess = DB::connection('mysql3')->select('
        //         SELECT os.vn,os.hn,os.date_visit,os.time_visit,os.fullname,oq.claim_code,oq.mobile,oq.claim_type,oq.authen_type,os.opd_dep,os.is_appoint,os.staff,sk.department
        //         FROM ovst_queue_server os
        //         LEFT OUTER JOIN ovst_queue_server_authen oq on oq.vn=os.vn
        //         LEFT OUTER JOIN kskdepartment sk on sk.depcode=os.opd_dep
        //         WHERE os.date_visit = "'.$date.'"
        //         and staff not in("kioskopd1","kioskopd","kioskncd","kioskpcc")  
        //         and authen_type is null
        //         ORDER BY os.time_visit
        // ');
        // $authenusernosuccess2 = DB::connection('mysql3')->select('
        //     SELECT os.vn,os.hn,os.date_visit,os.time_visit,os.fullname,oq.claim_code,oq.mobile,oq.claim_type,oq.authen_type,os.opd_dep,os.is_appoint,os.staff,sk.department
        //     FROM ovst_queue_server os
        //     LEFT OUTER JOIN ovst_queue_server_authen oq on oq.vn=os.vn
        //     LEFT OUTER JOIN kskdepartment sk on sk.depcode=os.opd_dep
        //     WHERE os.date_visit = "'.$date.'"
        //     and staff not in("kioskopd1","kioskopd","kioskncd","kioskpcc")  
        //     and authen_type <> "S"
        //     ORDER BY os.time_visit
        // ');

        // $authenusersuccess = DB::connection('mysql3')->select('
        //     SELECT o.vn,o.hn,o.vstdate,o.vsttime,p.cid,concat(p.pname,p.fname," ",p.lname) as fullname,oq.claim_code,vp.claimCode,oq.mobile,
        //     oq.claim_type,oq.authen_type,os.is_appoint,o.staff,op.name as fullname_staff,os.opd_dep,sk.department
        //     FROM ovst o
        //     LEFT OUTER JOIN ovst_queue_server os on os.vn = o.vn
        //     LEFT OUTER JOIN ovst_queue_server_authen oq on oq.vn = os.vn
        //     LEFT OUTER JOIN kskdepartment sk on sk.depcode=o.main_dep
        //     LEFT OUTER JOIN patient p on p.hn=o.hn
        //     LEFT OUTER JOIN visit_pttype_authen_report vp on vp.personalId = p.cid
        //     LEFT OUTER JOIN opduser op on op.loginname = o.staff
        //     WHERE o.vstdate = CURDATE()
        //     AND vp.claimCode is not null
        //     ORDER BY o.vsttime
        // ');
        
        // $authen_kiosnofinish = DB::connection('mysql3')->select('
        //     SELECT os.vn,os.hn,os.date_visit,os.time_visit,os.fullname,oq.claim_code,oq.mobile,oq.claim_type,oq.authen_type,os.opd_dep,os.is_appoint,os.staff,sk.department
        //     FROM ovst_queue_server os
        //         LEFT OUTER JOIN ovst_queue_server_authen oq on oq.vn=os.vn
        //         LEFT OUTER JOIN kskdepartment sk on sk.depcode=os.opd_dep
        //         WHERE os.date_visit = "'.$date.'"
        //         AND os.staff LIKE "kiosk%"
        //         AND oq.authen_type <>"S" 
        //         ORDER BY os.time_visit
 
        // ');
        // $authen_kiosnofinish2 = DB::connection('mysql3')->select('
         
        //     SELECT os.vn,os.hn,os.date_visit,os.time_visit,os.fullname,oq.claim_code,oq.mobile,oq.claim_type,oq.authen_type,os.opd_dep,os.is_appoint,os.staff,sk.department
        //     FROM ovst_queue_server os
        //     LEFT OUTER JOIN ovst_queue_server_authen oq on oq.vn=os.vn
        //     LEFT OUTER JOIN kskdepartment sk on sk.depcode=os.opd_dep
        //     WHERE os.date_visit = "'.$date.'"
        //     AND os.staff LIKE "kiosk%"
        //     AND oq.authen_type IS NULL 
        //     ORDER BY os.time_visit
        // ');
        // $authen_kios_finish = DB::connection('mysql3')->select('
        //     SELECT o.vn,o.hn,vp.claimCode,p.hometel,v.project_code,o.vstdate,o.vsttime,p.cid,o.staff,concat(p.pname,p.fname," ",p.lname) as fullname,sk.department
        //     FROM ovst o
        //     LEFT OUTER JOIN visit_pttype v on v.vn=o.vn
        //     LEFT OUTER JOIN kskdepartment sk on sk.depcode=o.main_dep
        //     LEFT OUTER JOIN patient p on p.hn=o.hn
        //     LEFT OUTER JOIN visit_pttype_authen_report vp on vp.personalId = p.cid
        //     LEFT OUTER JOIN opduser op on op.loginname = o.staff
        //     WHERE o.vstdate = CURDATE()
        //     AND o.staff LIKE "kiosk%" 
        //     AND vp.claimCode is not null
        //     ORDER BY o.vsttime

        // ');

        // $user_all = DB::connection('mysql3')->select('
        //         SELECT o.hn,o.vn,p.cid,v.auth_code,concat(p.pname,p.fname," ",p.lname) as fullname,o.staff,ou.name,k.department
        //         FROM ovst o
        //         LEFT OUTER JOIN visit_pttype v on v.vn=o.vn
        //         LEFT OUTER JOIN patient p on p.hn=o.hn
        //         LEFT OUTER JOIN kskdepartment k on k.depcode=o.main_dep
        //         left outer join opduser ou on ou.loginname=o.staff
        //         WHERE o.vstdate = CURDATE()
        //         AND o.staff not LIKE "kiosk%"
        //     ');
     
        // foreach ($user_all as $key => $value) {
        //     $cid = $value->cid; 
        // } 
        
        // $countonusersnosuccess_showdata = DB::connection('mysql3')->select('
        //     SELECT COUNT(os.vn) as VN
        //     FROM ovst_queue_server os
        //     LEFT OUTER JOIN ovst_queue_server_authen oq on oq.vn=os.vn
        //     LEFT OUTER JOIN kskdepartment sk on sk.depcode=os.opd_dep
        //     WHERE os.date_visit = "'.$date.'"
        //     and staff not in("kioskopd1","kioskopd","kioskncd","kioskpcc")            
        //     and authen_type <> "S"
        //     ORDER BY os.time_visit
        // ');
        // foreach ($countonusersnosuccess_showdata as $key => $value) {
        //     $usersnosuccess = $value->VN;
        // }
 
 
        // $data_spsch = DB::connection('mysql3')->select(' 
        //         SELECT o.vn,o.hn,o.vstdate,o.vsttime,p.cid,concat(p.pname,p.fname," ",p.lname) as fullname,oq.claim_code,vp.visit_pttype_authen_auth_code,oq.mobile,
        //         oq.claim_type,oq.authen_type,os.is_appoint,o.staff,op.name as fullname_staff,os.opd_dep,sk.department
        //         FROM ovst o
        //         LEFT OUTER JOIN visit_pttype_authen vp on vp.visit_pttype_authen_vn = o.vn
        //         LEFT OUTER JOIN ovst_queue_server os on os.vn = o.vn
        //         LEFT OUTER JOIN ovst_queue_server_authen oq on oq.vn = os.vn
        //         LEFT OUTER JOIN kskdepartment sk on sk.depcode=o.main_dep
        //         LEFT OUTER JOIN patient p on p.hn=o.hn
        //         LEFT OUTER JOIN opduser op on op.loginname = o.staff
        //         WHERE o.vstdate = CURDATE()
        //         ORDER BY o.vsttime limit 10
        // ');
        // $data_dep = DB::connection('mysql3')->select(' 
        //         SELECT o.main_dep,sk.department,COUNT(o.vn) as VN   
        //         FROM ovst o 
        //         LEFT JOIN visit_pttype v on v.vn=o.vn
        //         LEFT JOIN vn_stat vs on vs.vn=o.vn
        //         LEFT JOIN visit_pttype_authen vpa on vpa.visit_pttype_authen_vn=o.vn
        //         LEFT OUTER JOIN kskdepartment sk on sk.depcode=o.main_dep
        //         WHERE o.vstdate = CURDATE()   
                
        //         GROUP BY o.main_dep
        // ');
          
        // foreach ($data_dep as $key => $value2) {
        //     $maindep = $value2->main_dep;
        // }
      
        // $count_authen_success_data = DB::connection('mysql3')->select(' 
        //     SELECT COUNT(visit_pttype_authen_vn) as VN
        //     FROM visit_pttype_authen 
        //     WHERE vstdate = CURDATE()
        //     AND visit_pttype_authen_auth_code IS NOT NULL
        //     AND mobile <> ""
           
        // ');
        // foreach ($count_authen_success_data as $key => $value2) {
        //     $count_authen_success = $value2->VN;
        // }

        // if ($count_authen_success == 0) {
        //     $count_authen_successt = 1;
        // } else {
        //     $count_authen_per = 100 / $countalls ; 
        //     $count_authen_successt = $count_authen_per * $count_authen_success;
         
        // }

       
        // return view('authen_dashboard',[
            // 'count_success'           => $count_success,
            // 'count_successt'                    => $count_successt,
            // 'count_authen_successt'      => $count_authen_successt,
            // 'count_authen_success'       => $count_authen_success,
            // 'data_dep'                   => $data_dep,
            // 'user_all'                   => $user_all,
            // 'countkiosnofinish_new'           => $countkiosnofinish_new,
            // 'countkiosnofinish_newt'          => $countkiosnofinish_newt,
            // 'countkiosnofinish_newdata_show'  => $countkiosnofinish_newdata_show,
            // 'authen'                   => $authen,
            // 'countalls'                => $countalls,
            // 'countkiosalls'            => $countkiosalls,
            // 'countkiosfinish'          => $countkiosfinish,
            // 'countkiosnofinish'        => $countkiosnofinish,
            // 'countonusers'             => $countonusers,
            // 'countonuserssuccess'      => $countonuserssuccess2,
            // 'countonusersnosuccess'    => $countonusersnosuccess,
            // 'countonuserst'            => $countonuserst,
            // 'countonuserssuccesstt'    => $countonuserssuccesstt,
            // 'countonusersnosuccesstt'  => $countonusersnosuccesstt,
            // 'authenusernosuccess'      => $authenusernosuccess,
            // 'authenusersuccess'        => $authenusersuccess,
            // 'countkiosallst'           => $countkiosallst,
            // 'countkiosfinisht'         => $countkiosfinisht,
            // 'countkiosnofinisht'       => $countkiosnofinisht,
            // 'authen_kiosnofinish'      => $authen_kiosnofinish,
            // 'countonuserssuccessdata'  => $countonuserssuccessdata,
            // 'authen_kiosnofinish2'     => $authen_kiosnofinish2,
            // 'authen_kios_finish'       => $authen_kios_finish,
            // 'authensuccess'            => $authensuccess,
            // 'authen_nosuccess'         => $authen_nosuccess,
            // 'authensuccesstt'          => $authensuccesstt,
            // 'authenusernosuccess2'     => $authenusernosuccess2,
            // 'authensuccess_alldata'    => $authensuccess_alldata ,
            // 'countonuserssuccessnew'   => $countonuserssuccessnew         
    //     ] );
    // }
   
    public function authen_detail(Request $request,$dep)
    {
        $datadetail = DB::connection('mysql3')->select(' 
                SELECT                
                o.main_dep,o.vn as VN,o.vstdate,o.vsttime
                ,p.cid,o.hn,vp.patientName,vp.claimCode,vp.tel,o.staff,concat(p.pname,p.fname," ",p.lname) as fullname 
                 FROM ovst o 
                 LEFT OUTER JOIN kskdepartment sk on sk.depcode=o.main_dep
                 LEFT OUTER JOIN patient p on p.hn=o.hn
                 LEFT OUTER JOIN visit_pttype_authen_report vp ON vp.personalId = p.cid and vp.claimDate = o.vstdate
                 LEFT OUTER JOIN opduser op on op.loginname = o.staff
                WHERE o.vstdate = CURDATE() 
                and o.main_dep = "'.$dep.'"
                GROUP BY o.vn
                
        ');
                // AND wr.claimCode is not null
                // AND wr.tel is not null

         // (DISTINCT o.vn) as VN
        // FROM ovst o 
        // LEFT JOIN visit_pttype v on v.vn=o.vn
        // LEFT JOIN vn_stat vs on vs.vn=o.vn
        // LEFT JOIN visit_pttype_authen vpa on vpa.visit_pttype_authen_vn=o.vn
        // LEFT OUTER JOIN kskdepartment sk on sk.depcode=o.main_dep
        // WHERE o.vstdate = CURDATE()   
        // and o.main_dep = "'.$dep.'"  

        $output ='
        <table style="width: 100%;" class="table table-hover table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ลำดับ</th>
                            <th>เวลารับบริการ</th>
                            <th>VN</th>
                            <th>CID</th>
                            <th>HN</th> 
                            <th>Fullname</th>
                            <th>AuthenCode</th>
                            <th>Mobile</th> 
                            <th>Staff</th>                        
                        </tr>
                    </thead>
                    <tbody>';
                    $count = 1;
                    foreach ($datadetail as $key => $value) {
                        $output.='  <tr height="15">
                        <td class="text-font" align="center">'.$count.'</td>
                        <td class="text-font text-pedding">'.$value->vsttime.'</td>
                        <td class="text-font text-pedding">'.$value->VN.'</td>
                        <td class="text-font" align="center" >'.$value->cid.'</td>
                        <td class="text-font" align="center" >'.$value->hn.'</td>
                        <td class="text-font text-pedding">'.$value->fullname.'</td>
                        ';
                        if ($value->claimCode > 0 ) {
                            $output.='<td class="text-font text-pedding"><label for="" style="color:black">'.$value->claimCode.'</label></td>';
                        } else {
                            $output.='<td class="text-font text-pedding" style="color:white;background-color: rgb(255, 58, 58)"><label for="" >'.$value->claimCode.'</label></td>';
                        }     
                                                
                        if ($value->tel > 0 ) {
                            $output.='<td class="text-font" align="center" ><label for="" style="color:black">'.$value->tel.'</label></td>';
                        } else {
                            $output.='<td class="text-font" align="center" style="color:white;background-color: rgb(255, 58, 58)" ><label for="" >'.$value->tel.'</label></td>';
                        }  

                        $output.='                        
                        </td>
                        <td class="text-font text-pedding">'.$value->staff.'</td>
                        </tr>';
                        $count++;
                    }
                                        
                    $output.='</tbody>            
                </table>        
        ';
        echo $output;

        // return response()->json([
        //     'status'       => '200',
        //     'datadetail'   => $datadetail
        // ]);
        // return view('authen_dashboard');
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
    // public function import_authen_auto(Request $request)
    // {
    //     $date_now = date("Y-m-d");
    //     $datashow = DB::connection('mysql3')->select('
    //         SELECT v.vn ,v.hn ,v.cid
    //             ,vp.claim_code
    //             ,p.pttype ,p.hipdata_code
    //             ,cab.*
    //             FROM vn_stat v
    //             LEFT JOIN visit_pttype vp ON v.vn=vp.vn
    //             LEFT JOIN pttype p ON v.pttype=p.pttype
    //             LEFT JOIN z_check_authen_bamnet cab ON v.vn=cab.z_vn
    //             WHERE v.vstdate = "2022-12-22"
    //             AND (vp.claim_code IS NULL OR vp.claim_code="")  
    //             ORDER BY z_time 
    //             LIMIT 10
    //     ');
    //     foreach ($datashow as $key => $value) {
    //         $cid = $value->cid;
    //         $vn = $value->vn;
    //         $hn = $value->hn;
         
    //         $curl = curl_init();
    //         curl_setopt_array($curl, array(
    //             CURLOPT_URL => "http://localhost:8189/api/nhso-service/latest-authen-code/$cid",
    //             CURLOPT_RETURNTRANSFER => 1,
    //             CURLOPT_SSL_VERIFYHOST => 0,
    //             CURLOPT_SSL_VERIFYPEER => 0,
    //             CURLOPT_CUSTOMREQUEST => 'GET',
    //         ));
 
    //     $response = curl_exec($curl);
    //     curl_close($curl);
    //     $content = $response;
    //     $result = json_decode($content, true);

    //     @$hcode = $result['hcode'];

    //     @$ex_claimDateTime = explode("T",$result['claimDateTime']);
    //     $claimDate=$ex_claimDateTime[0];
    
        
    //     @$claimCode = $result['claimCode'];
    //     $ex_checkDate = explode("T",$result['checkDate']);
    //     $checkTime=$ex_checkDate[1];

    //     $checkvn = Visit_pttype_authen::where('visit_pttype_authen_cid','=',$cid)->where('visit_pttype_authen_vn','=',$vn)->count();

    //     if ($checkvn == 0) {
    //         $data_add = Visit_pttype_authen::create([
    //             'visit_pttype_authen_cid'       => $cid,
    //             'visit_pttype_authen_vn'        => $vn,
    //             'visit_pttype_authen_hn'        => $hn,
    //             'visit_pttype_authen_auth_code' => @$claimCode,
    //             'checkTime'                     => $checkTime,
    //             'claimDate'                     => $claimDate
    //         ]);
    //         $data_add->save();
    //     } else {       
    //     }               
    //     } 
    //     $data_spsch = DB::connection('mysql3')->select(' 
    //             SELECT o.vn,o.hn,o.vstdate,o.vsttime,p.cid,concat(p.pname,p.fname," ",p.lname) as fullname,oq.claim_code,vp.visit_pttype_authen_auth_code,oq.mobile,
    //             oq.claim_type,oq.authen_type,os.is_appoint,o.staff,op.name as fullname_staff,os.opd_dep,sk.department
    //             FROM ovst o
    //             LEFT OUTER JOIN visit_pttype_authen vp on vp.visit_pttype_authen_vn = o.vn
    //             LEFT OUTER JOIN ovst_queue_server os on os.vn = o.vn
    //             LEFT OUTER JOIN ovst_queue_server_authen oq on oq.vn = os.vn
    //             LEFT OUTER JOIN kskdepartment sk on sk.depcode=o.main_dep
    //             LEFT OUTER JOIN patient p on p.hn=o.hn
    //             LEFT OUTER JOIN opduser op on op.loginname = o.staff
    //             WHERE o.vstdate = CURDATE()
    //             ORDER BY o.vsttime desc limit 10
    //     ');
    // }
    public function checkauthen_auto(Request $request)
    {
            $date_now = date("Y-m-d");
            $datashow = DB::connection('mysql3')->select('
                SELECT v.vn ,v.hn ,v.cid
                    ,vp.claim_code
                    ,p.pttype ,p.hipdata_code
                    ,cab.*
                    FROM vn_stat v
                    LEFT JOIN visit_pttype vp ON v.vn=vp.vn
                    LEFT JOIN pttype p ON v.pttype=p.pttype
                    LEFT JOIN z_check_authen_bamnet cab ON v.vn=cab.z_vn
                    WHERE v.vstdate = "'.$date_now.'"
                    AND (vp.claim_code IS NULL OR vp.claim_code="")  
                    ORDER BY z_time 
                    LIMIT 10
            ');
                    foreach ($datashow as $key => $value) {
                        $cid = $value->cid;
                        $vn = $value->vn;
                        $hn = $value->hn;
                        // dd($cid);
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                            CURLOPT_URL => "http://localhost:8189/api/nhso-service/latest-authen-code/$cid",
                            CURLOPT_RETURNTRANSFER => 1,
                            CURLOPT_SSL_VERIFYHOST => 0,
                            CURLOPT_SSL_VERIFYPEER => 0,
                            CURLOPT_CUSTOMREQUEST => 'GET',
                        ));
                    // dd($curl);
                    $response = curl_exec($curl);
                    curl_close($curl);
                    $content = $response;
                    $result = json_decode($content, true);
    
                    @$hcode = $result['hcode'];
    
                    @$ex_claimDateTime = explode("T",$result['claimDateTime']);
                    $claimDate=$ex_claimDateTime[0];
                              
                    @$claimCode = $result['claimCode'];
                    $ex_checkDate = explode("T",$result['checkDate']);
                    $checkTime=$ex_checkDate[1];
    
                    // dd($claimDate);
                    $checkvn = Visit_pttype_authen::where('visit_pttype_authen_cid','=',$cid)->where('visit_pttype_authen_vn','=',$vn)->count();
                    // dd($checkvn);
                    if ($checkvn == 0) {
                        $data_add = Visit_pttype_authen::create([
                            'visit_pttype_authen_cid'       => $cid,
                            'visit_pttype_authen_vn'        => $vn,
                            'visit_pttype_authen_hn'        => $hn,
                            'visit_pttype_authen_auth_code' => @$claimCode,
                            'checkTime'                     => $checkTime,
                            'claimDate'                     => $claimDate
                        ]);
                        $data_add->save();
                    } else {
                        # code...
                    }
                            
                    }
            
                    $data_spsch = DB::connection('mysql3')->select(' 
                            SELECT o.vn,o.hn,o.vstdate,o.vsttime,p.cid,concat(p.pname,p.fname," ",p.lname) as fullname,oq.claim_code,vp.visit_pttype_authen_auth_code,oq.mobile,
                            oq.claim_type,oq.authen_type,os.is_appoint,o.staff,op.name as fullname_staff,os.opd_dep,sk.department
                            FROM ovst o
                            LEFT OUTER JOIN visit_pttype_authen vp on vp.visit_pttype_authen_vn = o.vn
                            LEFT OUTER JOIN ovst_queue_server os on os.vn = o.vn
                            LEFT OUTER JOIN ovst_queue_server_authen oq on oq.vn = os.vn
                            LEFT OUTER JOIN kskdepartment sk on sk.depcode=o.main_dep
                            LEFT OUTER JOIN patient p on p.hn=o.hn
                            LEFT OUTER JOIN opduser op on op.loginname = o.staff
                            WHERE o.vstdate = CURDATE()
                            ORDER BY o.vsttime LIMIT 10 
                    ');
    
                return view('authen.checkauthen_auto',[
                    'response'  => $response,
                    'result'  => $result,
                    'data_spsch'  => $data_spsch
                ]);
            
     
         return view('import_authen_auto',[
            'response'  => $response,
            'result'  => $result,
            'data_spsch'  => $data_spsch
        ]);
    }
    // public function authen_realtime(Request $request)
    // {

    //     $date_now = date("Y-m-d");
    //     $datashow = DB::connection('mysql3')->select('
    //         SELECT v.vn ,v.hn ,v.cid
    //             ,vp.claim_code
    //             ,p.pttype ,p.hipdata_code
    //             ,cab.*
    //             FROM vn_stat v
    //             LEFT JOIN visit_pttype vp ON v.vn=vp.vn
    //             LEFT JOIN pttype p ON v.pttype=p.pttype
    //             LEFT JOIN z_check_authen_bamnet cab ON v.vn=cab.z_vn
    //             WHERE v.vstdate = CURDATE()
    //             AND (vp.claim_code IS NULL OR vp.claim_code="")  
    //             ORDER BY z_time 
    //     ');
    //     foreach ($datashow as $key => $value) {
    //         $cid = $value->VN;
    //     }
            
    //     return response()->json([
    //         'status'     => '200',
    //     ]);
        
    // }
    public function checkauthen_auto0000(Request $request)
    {
        $date_now = date("Y-m-d");
        $datashow = DB::connection('mysql3')->select('
            SELECT v.vn ,v.hn ,v.cid
                ,vp.claim_code
                ,p.pttype ,p.hipdata_code
                ,cab.*
                FROM vn_stat v
                LEFT JOIN visit_pttype vp ON v.vn=vp.vn
                LEFT JOIN pttype p ON v.pttype=p.pttype
                LEFT JOIN z_check_authen_bamnet cab ON v.vn=cab.z_vn
                WHERE v.vstdate = "2022-12-22"
                AND (vp.claim_code IS NULL OR vp.claim_code="")  
                ORDER BY z_time 
                LIMIT 10
        ');
        foreach ($datashow as $key => $value) {
            $cid = $value->cid;
            $vn = $value->vn;
            $hn = $value->hn;
            // dd($cid);
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "http://localhost:8189/api/nhso-service/latest-authen-code/$cid",
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_CUSTOMREQUEST => 'GET',
            ));
            // dd($curl);
            $response = curl_exec($curl);
            curl_close($curl);
            $content = $response;
            $result = json_decode($content, true);

            @$hcode = $result['hcode'];

            @$ex_claimDateTime = explode("T",$result['claimDateTime']);
            $claimDate=$ex_claimDateTime[0];
            echo "<BR>";
            
            @$claimCode = $result['claimCode'];
            $ex_checkDate = explode("T",$result['checkDate']);
            $checkTime=$ex_checkDate[1];

            // dd($claimDate);
            $checkvn = Visit_pttype_authen::where('visit_pttype_authen_cid','=',$cid)->where('visit_pttype_authen_vn','=',$vn)->count();
            // dd($checkvn);
            if ($checkvn == 0) {
                $data_add = Visit_pttype_authen::create([
                    'visit_pttype_authen_cid'       => $cid,
                    'visit_pttype_authen_vn'        => $vn,
                    'visit_pttype_authen_hn'        => $hn,
                    'visit_pttype_authen_auth_code' => @$claimCode,
                    'checkTime'                     => $checkTime,
                    'claimDate'                     => $claimDate
                ]);
                $data_add->save();
            } else {
                # code...
            }
                
        }
 
        $data_spsch = DB::connection('mysql3')->select(' 
                SELECT o.vn,o.hn,o.vstdate,o.vsttime,p.cid,concat(p.pname,p.fname," ",p.lname) as fullname,oq.claim_code,vp.visit_pttype_authen_auth_code,oq.mobile,
                oq.claim_type,oq.authen_type,os.is_appoint,o.staff,op.name as fullname_staff,os.opd_dep,sk.department
                FROM ovst o
                LEFT OUTER JOIN visit_pttype_authen vp on vp.visit_pttype_authen_vn = o.vn
                LEFT OUTER JOIN ovst_queue_server os on os.vn = o.vn
                LEFT OUTER JOIN ovst_queue_server_authen oq on oq.vn = os.vn
                LEFT OUTER JOIN kskdepartment sk on sk.depcode=o.main_dep
                LEFT OUTER JOIN patient p on p.hn=o.hn
                LEFT OUTER JOIN opduser op on op.loginname = o.staff
                WHERE o.vstdate = CURDATE()
                ORDER BY o.vsttime desc limit 10
        ');

     return view('authen.checkauthen_auto',[
        'response'  => $response,
        'result'  => $result,
        'data_spsch'  => $data_spsch
     ]);
    //  return response()->json([
    //     'status'     => '200',
    // ]);
    
}


}