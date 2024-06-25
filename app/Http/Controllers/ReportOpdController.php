<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\support\Facades\Hash;
use Illuminate\support\Facades\Validator;
use App\Models\User;
use App\Models\Ot_one;
use PDF;
use setasign\Fpdi\Fpdi;
use App\Models\Budget_year;
use Illuminate\Support\Facades\File;
use DataTables;
use Intervention\Image\ImageManagerStatic as Image;
// use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\OtExport;
// use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Department;
use App\Models\Departmentsub;
use App\Models\Departmentsubsub;
use App\Models\Position;
use App\Models\Product_spyprice;
use App\Models\Products;
use App\Models\Products_type;
use App\Models\Product_group;
use App\Models\Product_unit;
use App\Models\Products_category;
use App\Models\Article;
use App\Models\Product_prop;
use App\Models\Product_decline;
use App\Models\Department_sub_sub;
use App\Models\Products_vendor;
use App\Models\Status; 
use App\Models\Products_request;
use App\Models\Products_request_sub;   
use App\Models\Leave_leader;
use App\Models\Leave_leader_sub;
use App\Models\Book_type;
use App\Models\Book_import_fam;
use App\Models\Book_signature;
use App\Models\Bookrep;
use App\Models\Book_objective; 
use Auth;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http; 
use SoapClient;
use Arr; 
use App\Imports\ImportAcc_stm_ti;
use App\Imports\ImportAcc_stm_tiexcel_import;
use App\Imports\ImportAcc_stm_ofcexcel_import;
use App\Imports\ImportAcc_stm_lgoexcel_import;
use App\Models\D_ofc_repexcel;
use App\Models\D_ofc_rep;
use SplFileObject;
use PHPExcel;
use PHPExcel_IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx; 
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\IOFactory; 
use ZipArchive;  
use Illuminate\Support\Facades\Redirect;
use PhpParser\Node\Stmt\If_;
use Stevebauman\Location\Facades\Location; 
use Illuminate\Filesystem\Filesystem;

use Mail;
use Illuminate\Support\Facades\Storage;
  
 
date_default_timezone_set("Asia/Bangkok");

class ReportOpdController extends Controller
{ 
    public function report_db(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $data['users']     = User::get();  
        $data['d_claim']   = DB::connection('mysql')->select('
            SELECT d.vn,d.hn,d.an,d.cid,d.ptname,d.vstdate,d.pttype,d.sum_price,s.rep_a,s.tranid_c,s.price1_k,s.income_ad,s.pp_gep_ae,s.claim_true_af,s.claim_false_ag,s.cash_money_ah
            ,s.pay_ai,s.IPCS_ao,s.IPCS_ORS_ap,s.OPCS_aq,s.PACS_ar,s.INSTCS_as,s.OTCS_at,s.PP_au,s.DRUG_av,s.errorcode_m
            FROM d_claim d
            LEFT OUTER JOIN d_ofc_rep s ON s.hn_d = d.hn AND s.vstdate_i = d.vstdate
            WHERE d.vstdate BETWEEN "'.$startdate.'" and "'.$enddate.'"
            ORDER BY s.tranid_c DESC
        '); 


        return view('report_all.report_db',$data,[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate, 
        ]);
    }

    public function report_opd(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $data['users']     = User::get();  
        $data['d_claim']   = DB::connection('mysql')->select('
            SELECT d.vn,d.hn,d.an,d.cid,d.ptname,d.vstdate,d.pttype,d.sum_price,s.rep_a,s.tranid_c,s.price1_k,s.income_ad,s.pp_gep_ae,s.claim_true_af,s.claim_false_ag,s.cash_money_ah
            ,s.pay_ai,s.IPCS_ao,s.IPCS_ORS_ap,s.OPCS_aq,s.PACS_ar,s.INSTCS_as,s.OTCS_at,s.PP_au,s.DRUG_av,s.errorcode_m
            FROM d_claim d
            LEFT OUTER JOIN d_ofc_rep s ON s.hn_d = d.hn AND s.vstdate_i = d.vstdate
            WHERE d.vstdate BETWEEN "'.$startdate.'" and "'.$enddate.'"
            ORDER BY s.tranid_c DESC
        '); 
        $data['report_opd']   = DB::connection('mysql')->select('SELECT * FROM report_hos Where report_department_sub = "39"'); 

        return view('report_all.report_opd',$data,[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate, 
        ]);
    }
    public function report_hos_opd(Request $request,$id)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $data['users']     = User::get();  
        $data['d_claim']   = DB::connection('mysql')->select('
            SELECT d.vn,d.hn,d.an,d.cid,d.ptname,d.vstdate,d.pttype,d.sum_price,s.rep_a,s.tranid_c,s.price1_k,s.income_ad,s.pp_gep_ae,s.claim_true_af,s.claim_false_ag,s.cash_money_ah
            ,s.pay_ai,s.IPCS_ao,s.IPCS_ORS_ap,s.OPCS_aq,s.PACS_ar,s.INSTCS_as,s.OTCS_at,s.PP_au,s.DRUG_av,s.errorcode_m
            FROM d_claim d
            LEFT OUTER JOIN d_ofc_rep s ON s.hn_d = d.hn AND s.vstdate_i = d.vstdate
            WHERE d.vstdate BETWEEN "'.$startdate.'" and "'.$enddate.'"
            ORDER BY s.tranid_c DESC
        '); 

        // dd($id);
        $data['report_med']   = DB::connection('mysql')->select(
            'SELECT * FROM report_hos WHERE report_hos_id ="'.$id.'" and report_department_sub = "39"' );
        
        if ($id == '64') {
            $data['datashow']   = DB::connection('mysql2')->select('
                    SELECT
                 
            ');
            $data['report_name'] = DB::connection('mysql')->table('report_hos')->where('report_hos_id', '=',64)->first();

        }elseif($id == '65') {
            $data['datashow'] = DB::connection('mysql2')->select('
                    SELECT s.spclty,s.name AS ประเภทแผนกผู้ป่วย,COUNT(DISTINCT(v.hn)) AS คน,COUNT(v.vn) AS ครั้ง
                    FROM vn_stat v
                    LEFT JOIN spclty s ON s.spclty = v.spclty
                    WHERE v.vstdate BETWEEN "'.$startdate.'" and "'.$enddate.'"
                    AND v.spclty IN (SELECT spclty FROM spclty)
                    GROUP BY s.name
                    ORDER BY s.spclty  
            ');
            $data['report_name'] = DB::connection('mysql')->table('report_hos')->where('report_hos_id', '=',65)->first();
                   
        }elseif($id == '66') {
            // dd($id);
            $data['datashow'] = DB::connection('mysql2')->select('
                    SELECT *
                    FROM vn_stat v
                    LEFT JOIN spclty s ON s.spclty = v.spclty
                    WHERE v.vstdate BETWEEN "'.$startdate.'" and "'.$enddate.'"
                    AND v.spclty IN (SELECT spclty FROM spclty)
                    AND v.hn NOT IN (SELECT hn FROM clinicmember)
                    GROUP BY s.name
                    ORDER BY s.spclty  
            ');
            // SELECT s.spclty,s.name AS ประเภทแผนกผู้ป่วย,COUNT(DISTINCT(v.hn)) AS "คน",COUNT(v.vn) AS "ครั้ง"
            $data['report_name'] = DB::connection('mysql')->table('report_hos')->where('report_hos_id', '=',66)->first();
            // dd($data['datashow']);      
        }elseif($id == '67') {
            $data['datashow'] = DB::connection('mysql2')->select('
                    SELECT m.clinic,c.name AS Clinic_name,COUNT(DISTINCT(v.hn)) AS คน,COUNT(v.vn) AS ครั้ง
                    FROM vn_stat v
                    LEFT JOIN clinicmember m ON m.hn=v.hn
                    LEFT JOIN clinic c ON c.clinic=m.clinic
                    WHERE v.hn IN (SELECT hn FROM clinicmember)
                    AND c.chronic = "Y"
                    AND v.vstdate BETWEEN "'.$startdate.'" and "'.$enddate.'"
                    GROUP BY c.clinic  
            ');
            $data['report_name'] = DB::connection('mysql')->table('report_hos')->where('report_hos_id', '=',67)->first();
                   
        }elseif($id == '68') {
            $data['datashow'] = DB::connection('mysql2')->select('
                    SELECT m.clinic,c.name AS Clinic_name,COUNT(DISTINCT(v.hn)) AS คน,COUNT(v.vn) AS ครั้ง
                    FROM vn_stat v
                    LEFT JOIN clinicmember m ON m.hn=v.hn
                    LEFT JOIN clinic c ON c.clinic=m.clinic
                    WHERE v.hn IN (SELECT hn FROM clinicmember)
                    AND c.chronic="Y" AND m.clinic IN ("001","002","007")
                    AND v.vstdate BETWEEN "'.$startdate.'" and "'.$enddate.'"
                    GROUP BY c.clinic  
            ');
            $data['report_name'] = DB::connection('mysql')->table('report_hos')->where('report_hos_id', '=',68)->first();
                   
        }elseif($id == '69') {
            $data['datashow'] = DB::connection('mysql2')->select('
                    SELECT o.doctor,d.name,
                    sum(o.vsttime BETWEEN "08:30:00" AND "12:59:59") AS morning,
                    sum(o.vsttime BETWEEN "13:00:00" AND "16:30:00") AS afternoon,
                    sum(o.vsttime BETWEEN "08:30:00" AND "16:30:00") AS morning_to_afternoon
                    FROM ovst o
                    LEFT OUTER JOIN doctor d ON d.code = o.doctor
                    WHERE o.vstdate BETWEEN "'.$startdate.'" and "'.$enddate.'"	
                    AND d.position_id="1" 
                    GROUP BY o.doctor
                    ORDER BY morning_to_afternoon DESC 
            ');
            $data['report_name'] = DB::connection('mysql')->table('report_hos')->where('report_hos_id', '=',69)->first();
                   
        }elseif($id == '70') {
            $data['datashow'] = DB::connection('mysql2')->select('
                    SELECT o.doctor,d.name,COUNT(o.vn) AS Treatment_count
                    FROM ovst o
                    LEFT OUTER JOIN doctor d ON d.code = o.doctor
                    WHERE o.vstdate BETWEEN "'.$startdate.'" and "'.$enddate.'" 	
                    AND d.position_id="1" 
                    GROUP BY o.doctor
                    ORDER BY Treatment_count DESC 
            ');
            $data['report_name'] = DB::connection('mysql')->table('report_hos')->where('report_hos_id', '=',70)->first();
                   
        }elseif($id == '71') {
            $data['datashow'] = DB::connection('mysql2')->select('
                    SELECT o.doctor,d.name,COUNT(o.vn) AS Treatment_count
                    FROM ovst o
                    LEFT OUTER JOIN doctor d ON d.code = o.doctor
                    WHERE o.vstdate BETWEEN "'.$startdate.'" and "'.$enddate.'"	
                    AND d.position_id="5" AND d.active="Y"
                    GROUP BY o.doctor
                    ORDER BY Treatment_count DESC
            ');
            $data['report_name'] = DB::connection('mysql')->table('report_hos')->where('report_hos_id', '=',71)->first();
                   
        }elseif($id == '72') {
            $data['datashow'] = DB::connection('mysql2')->select('
                    SELECT v.pdx,i.name AS icdname,COUNT(v.pdx) AS pdx_count 				
                    FROM vn_stat v 				
                    JOIN icd101 i ON i.code=v.pdx 				
                    WHERE v.vstdate BETWEEN "'.$startdate.'" and "'.$enddate.'" 	
                    AND v.pdx NOT LIKE "Z%"	
                    AND v.pdx IS NOT NULL 
                    AND v.pdx <> ""
                    GROUP BY v.pdx,i.name 				
                    ORDER BY pdx_count DESC LIMIT  30
            ');
            $data['report_name'] = DB::connection('mysql')->table('report_hos')->where('report_hos_id', '=',72)->first();
                   
        }elseif($id == '73') {
            $data['datashow'] = DB::connection('mysql2')->select('
                    SELECT v.pdx,i.name AS icdname,COUNT(v.pdx) AS pdx_count 				
                    FROM vn_stat v 				
                    JOIN icd101 i ON i.code=v.pdx 				
                    WHERE v.vstdate BETWEEN "'.$startdate.'" and "'.$enddate.'"	
                    AND v.pdx NOT LIKE "Z%"	
                    AND v.pdx NOT LIKE "U%"	
                    AND v.pdx IS NOT NULL 
                    AND v.pdx <> " "
                    AND v.vn NOT IN (SELECT vn FROM er_regist)
                    AND v.vn NOT IN (SELECT vn FROM physic_main)
                    AND v.vn NOT IN (SELECT vn FROM dtmain)
                    GROUP BY v.pdx,i.name 				
                    ORDER BY pdx_count DESC LIMIT  30
            ');
            $data['report_name'] = DB::connection('mysql')->table('report_hos')->where('report_hos_id', '=',73)->first();
                   
        }elseif($id == '74') {
            $data['datashow'] = DB::connection('mysql2')->select('
                    SELECT 
            ');
            $data['report_name'] = DB::connection('mysql')->table('report_hos')->where('report_hos_id', '=',74)->first();
                   
        }elseif($id == '75') {
            $data['datashow'] = DB::connection('mysql2')->select('
                    SELECT 
            ');
            $data['report_name'] = DB::connection('mysql')->table('report_hos')->where('report_hos_id', '=',75)->first();
                   
        }elseif($id == '76') {
            $data['datashow'] = DB::connection('mysql2')->select('
                    SELECT select s.hn, s.vstdate, s.vsttime, s.service4 as startscreen ,
                    s.service11 as send2doctor, s.service5 as startexam,s.service12 as finishexam,
                    (time_to_sec(service4)-time_to_sec(vsttime))/60 as card2screen,
                    (time_to_sec(service11)-time_to_sec(service4))/60 as screen2senddoctor,
                    (time_to_sec(service5)-time_to_sec(service11))/60 as senddoctor2doctor,
                    (time_to_sec(service12)-time_to_sec(service5))/60 as doctor2finishdoctor,
                    (time_to_sec(service5)-time_to_sec(service4))/60 as screen2doctor,
                    (time_to_sec(service5)-time_to_sec(vsttime))/60 as card2doctor
                    from service_time s
                    where s.vstdate between "'.$startdate.'" and "'.$enddate.'"
                    and s.vsttime between "08:30:00" and "16:30:00"
                    and s.vstdate not in (select holiday_date from holiday)
                    and s.service3 is not null 
                    and s.service4 is not null and
                    s.service5 is not null 
                    and s.service11 is not null 
                    and s.service12 is not null 
                    and s.service11>=s.service4 
                    and s.service5>=s.service11 
                    and s.service12>=s.service5
            ');
            $data['report_name'] = DB::connection('mysql')->table('report_hos')->where('report_hos_id', '=',76)->first();
                   
        }elseif($id == '77') {
            $data['datashow'] = DB::connection('mysql2')->select('
                    SELECT o.hn,CONCAT(p.pname," ",p.fname,"  ",p.lname) AS ptname,op.vstdate AS day_1,op.vsttime AS time_1,i1.code AS icd10_1,i1.name AS icdname_1,d1.name AS doctor_name1,
                    op2.vstdate AS day_2,op2.vsttime AS time_2,i2.code AS icd10_2,i2.name AS icdname_2,d2.name AS doctor_name2,
                    (((to_days(op2.vstdate)*24)- ((to_days(op.vstdate)*24)) + ((time_to_sec(op2.vsttime))/3600)) - ((time_to_sec(op.vsttime))/3600))
                    AS revist_time
                    FROM opitemrece op
                    LEFT JOIN vn_stat v ON v.vn=op.vn
                    LEFT JOIN ovst o ON o.hn = v.hn AND o.vn>v.vn AND o.vn IS NOT NULL
                    LEFT JOIN vn_stat v2 ON v2.vn=o.vn
                    LEFT JOIN opitemrece op2 ON o.vn=op2.vn AND op2.vn IS NOT NULL
                    LEFT JOIN icd101 i1 ON i1.code=v.pdx
                    LEFT JOIN icd101 i2 ON i2.code=v2.pdx
                    LEFT JOIN doctor d1 ON d1.code=v.dx_doctor
                    LEFT JOIN doctor d2 ON d2.code=v2.dx_doctor
                    LEFT JOIN patient p ON p.hn=o.hn
                    WHERE op.vstdate BETWEEN "'.$startdate.'" and "'.$enddate.'"	
                    AND op.vsttime BETWEEN "08:30:00" AND "16:30:00"
                    AND op2.vsttime BETWEEN "08:30:00" AND "16:30:00"
                    AND v.vn NOT IN (SELECT vn FROM er_regist)
                    AND v2.vn NOT IN (SELECT vn FROM dtmain)
                    AND v2.vn NOT IN (SELECT vn FROM physic_main)
                    AND (((to_days(op2.vstdate)*24)- ((to_days(op.vstdate)*24)) + (( time_to_sec(op2.vsttime))/3600)) - (( time_to_sec(op.vsttime))/3600)) 
                    BETWEEN 0.001 AND 48 
                    AND v2.pdx NOT LIKE "Z%" AND v2.pdx NOT LIKE "U%"
                    AND v.pdx NOT LIKE "Z%" AND v.pdx NOT LIKE "U%" AND i1.code=i2.code
                    GROUP BY v.hn
                    HAVING count(v.hn) > 1
                    ORDER BY op.vstdate,op.vsttime
            ');
            $data['report_name'] = DB::connection('mysql')->table('report_hos')->where('report_hos_id', '=',77)->first();
                   
        }elseif($id == '78') {
            $data['datashow'] = DB::connection('mysql2')->select('
                    SELECT v.pdx,i.name AS icdname,COUNT(v.pdx) AS pdx_count 				
                    FROM vn_stat v 				
                    JOIN icd101 i ON i.code=v.pdx 				
                    WHERE v.vstdate BETWEEN "'.$startdate.'" and "'.$enddate.'"	
                    AND v.pdx NOT LIKE "Z%"	
                    AND v.pdx IS NOT NULL 
                    AND v.pdx <> ""
                    GROUP BY v.pdx,i.name 				
                    ORDER BY pdx_count DESC LIMIT  10
            ');
            $data['report_name'] = DB::connection('mysql')->table('report_hos')->where('report_hos_id', '=',78)->first();
                   
        }elseif($id == '79') {
            $data['datashow'] = DB::connection('mysql2')->select('
                    SELECT v.pdx,i.name AS icdname,COUNT(v.pdx) AS pdx_count 				
                    FROM vn_stat v 				
                    JOIN icd101 i ON i.code=v.pdx 	
                    JOIN patient p on p.hn=v.hn			
                    WHERE v.vstdate BETWEEN "'.$startdate.'" and "'.$enddate.'" 	
                    AND v.pdx NOT LIKE "Z%"	
                    AND v.pdx IS NOT NULL 
                    AND v.pdx <> ""
                    AND p.chwpart=36 AND p.amppart =10 AND p.tmbpart =01
                    GROUP BY v.pdx,i.name 				
                    ORDER BY pdx_count DESC LIMIT  10
            ');
            $data['report_name'] = DB::connection('mysql')->table('report_hos')->where('report_hos_id', '=',79)->first();
                   
        }elseif($id == '80') {
            $data['datashow'] = DB::connection('mysql2')->select('
                    SELECT op.hn,t.vn,op.vstdate,concat(p.pname,p.fname," ",p.lname) as ptname,pt.name as pttype,year(op.vstdate)-year(p.birthday) as age
                    ,n.name as ctname,concat(p.addrpart,"หมู่ที่ ",p.moopart," ต.",t3.name,"อ.",t2.name,"จ.",t1.name) as fulladdressname
                     from opitemrece op 
                     left outer join vn_stat t on t.vn=op.vn
                     left outer join patient p on p.hn=op.hn 
                     left outer join nondrugitems n on n.icode=op.icode
                     LEFT OUTER JOIN pttype pt on pt.pttype=t.pttype
                     left outer join thaiaddress t1 on t1.chwpart=p.chwpart and t1.amppart= "00" and t1.tmbpart= "00"
                     left outer join thaiaddress t2 on t2.chwpart=p.chwpart and t2.amppart=p.amppart and t2.tmbpart= "00"
                     left outer join thaiaddress t3 on t3.chwpart=p.chwpart and t3.amppart=p.amppart and t3.tmbpart=p.tmbpart 
                     where op.vstdate between "'.$startdate.'" and "'.$enddate.'"
                     and op.qty > "0" 
                     and op.sum_price <> "0"
                     and op.icode between "3009139" and "3009198" 
                     and op.icode not in ("3009152","3009153","3009154")
                     AND op.vn is not null
                     AND p.chwpart = "36"
                     AND p.amppart = "12"
                     group by op.vn 
                     order by op.vstdate
            ');
            $data['report_name'] = DB::connection('mysql')->table('report_hos')->where('report_hos_id', '=',80)->first();
                   
        }elseif($id == '81') {
            $data['datashow'] = DB::connection('mysql2')->select('
                    SELECT a.regdate,a.hn,concat(p.pname,p.fname," ",p.lname) AS ptname,
                    a.age_y,pt.`name` AS pttname,concat(a.pdx," : ",i.`name`) AS icd10name
                    FROM an_stat a
                    LEFT OUTER JOIN patient p ON p.hn=a.hn
                    LEFT OUTER JOIN pttype pt ON pt.pttype=a.pttype
                    LEFT OUTER JOIN icd101 i ON i.`code`=a.pdx
                    WHERE a.regdate=CURDATE()
                    AND a.hn in(SELECT hn FROM patient_hospital_officer)
            ');
            $data['report_name'] = DB::connection('mysql')->table('report_hos')->where('report_hos_id', '=',81)->first();
                   
        }elseif($id == '82') {
            $data['datashow'] = DB::connection('mysql2')->select('
                    SELECT v.vstdate,v.hn,concat(p.pname,p.fname," ",p.lname) AS ptname,
                    v.age_y,pt.`name` AS pttname,concat(v.pdx," : ",i.`name`) AS icd10name,
                    k.department,sum(v.income) AS income
                    FROM vn_stat v
                    LEFT OUTER JOIN patient p ON p.hn=v.hn
                    LEFT OUTER JOIN ovst o ON o.vn=v.vn
                    LEFT OUTER JOIN kskdepartment k ON k.depcode=o.main_dep
                    LEFT OUTER JOIN pttype pt ON pt.pttype=v.pttype
                    LEFT OUTER JOIN icd101 i ON i.`code`=v.pdx
                    WHERE v.vstdate=CURDATE()
                    AND v.hn in(SELECT hn FROM patient_hospital_officer)
                    GROUP BY v.vn
            ');
            $data['report_name'] = DB::connection('mysql')->table('report_hos')->where('report_hos_id', '=',82)->first();
                   
        }elseif($id == '83') {
            $data['datashow'] = DB::connection('mysql2')->select('
                    SELECT o.hn,o.vn,o.vstdate,CONCAT(p.pname,p.fname," ",p.lname) as fullname,CONCAT(v.age_y," ","ปี"," ",v.age_m," ","ด") as age
                    ,d.name,o1.rxtime
                    ,SUBSTRING_INDEX(GROUP_CONCAT((SELECT CONCAT(o2.rxtime) WHERE o2.icode = "3002761" or o2.icode = "3002762")),",",1) AS timeoper
                    ,k.department
                    FROM ovst o
                    LEFT OUTER JOIN patient p on p.hn=o.hn
                    LEFT OUTER JOIN vn_stat v on v.vn=o.vn
                    LEFT OUTER JOIN opitemrece o1 on o1.vn=o.vn
                    LEFT OUTER JOIN opitemrece o2 on o2.vn=o.vn
                    LEFT OUTER JOIN drugitems d on d.icode=o1.icode
                    LEFT OUTER JOIN nondrugitems d1 on d1.icode=o2.icode
                    LEFT OUTER JOIN kskdepartment k on k.depcode=o.main_dep
                    WHERE o.vstdate BETWEEN "'.$startdate.'" and "'.$enddate.'"
                    AND d.icode in ("1440403","1490311","1000033","1000034","1480189","1000044","1152002","1480053","1500072","1480185"
                    ,"1000060","1460109","1530010","1460120","1000082","1460073","1600021","1510030","1530040","1530013","1480032","1000140","1015001","1000231")
                    AND o.vn not in (SELECT e.vn FROM er_regist e)
                    GROUP BY o.vn
                    ORDER BY o.vstdate
            ');
            $data['report_name'] = DB::connection('mysql')->table('report_hos')->where('report_hos_id', '=',83)->first();
                   
        }elseif($id == '84') {
            $data['datashow'] = DB::connection('mysql2')->select('
                    SELECT v.vstdate,v.hn,concat(p.pname,p.fname," ",p.lname) AS ptname,
                    v.age_y,pt.`name` AS pttname,concat(v.pdx," : ",i.`name`) AS icd10name,
                    n.`name` AS nationname,n1.`name` AS citizen_name,r.`name` AS region_name
                    FROM vn_stat v
                    LEFT OUTER JOIN patient p ON p.hn=v.hn
                    LEFT OUTER JOIN pttype pt ON pt.pttype=v.pttype
                    LEFT OUTER JOIN icd101 i ON i.`code`=v.pdx
                    LEFT OUTER JOIN nationality n ON n.nationality=p.nationality
                    LEFT OUTER JOIN religion r ON r.religion=p.religion
                    LEFT OUTER JOIN nationality n1 ON n1.nationality=p.citizenship
                    WHERE v.vstdate=CURDATE()
                    AND p.nationality<>"99" 
            ');
            $data['report_name'] = DB::connection('mysql')->table('report_hos')->where('report_hos_id', '=',84)->first();
                   
        }elseif($id == '85') {
            $data['datashow'] = DB::connection('mysql2')->select('
                    SELECT v.hn,p.cid,p.pname,p.fname,p.lname,o1.icd10 as dx,p.addrpart as add,p.moopart as moo,t3.name as t3,t2.name as t2,t1.name as t1
                    ,v.age_y as age_y,v.regdate
                    FROM an_stat v
                    LEFT OUTER JOIN patient p on v.hn=p.hn
                    LEFT OUTER JOIN iptdiag o1 on o1.an=v.an
                    LEFT OUTER JOIN lab_head l on l.vn=v.an
                    LEFT OUTER JOIN lab_order l2 on l2.lab_order_number=l.lab_order_number
                    left outer join thaiaddress t1 on t1.chwpart=p.chwpart and t1.amppart= "00" and t1.tmbpart= "00"
                    left outer join thaiaddress t2 on t2.chwpart=p.chwpart and t2.amppart=p.amppart and t2.tmbpart= "00"
                    left outer join thaiaddress t3 on t3.chwpart=p.chwpart and t3.amppart=p.amppart and t3.tmbpart=p.tmbpart
                    WHERE v.regdate BETWEEN "'.$startdate.'" and "'.$enddate.'"
                    AND (SELECT o1.icd10 in ("J121","J205","J210","B947") ) # OR l2.lab_items_code="1852")
                    GROUP BY v.an
                    ORDER BY v.regdate  
            ');
            $data['report_name'] = DB::connection('mysql')->table('report_hos')->where('report_hos_id', '=',85)->first();
                   
        }elseif($id == '86') {
            $data['datashow'] = DB::connection('mysql2')->select('
                    SELECT v.hn,p.cid,p.pname,p.fname,p.lname,o1.icd10 as dx,p.addrpart as บ้านเลขที่,p.moopart as หมู่ที่,t3.name as ตำบล,t2.name as อำเภอ,t1.name as จังหวัด
                    ,v.age_y as อายุ,v.vstdate
                    FROM vn_stat v
                    LEFT OUTER JOIN patient p on v.hn=p.hn
                    LEFT OUTER JOIN ovstdiag o1 on o1.vn=v.vn
                    LEFT OUTER JOIN lab_head l on l.vn=v.vn
                    LEFT OUTER JOIN lab_order l2 on l2.lab_order_number=l.lab_order_number
                    left outer join thaiaddress t1 on t1.chwpart=p.chwpart and t1.amppart= "00" and t1.tmbpart= "00"
                    left outer join thaiaddress t2 on t2.chwpart=p.chwpart and t2.amppart=p.amppart and t2.tmbpart= "00"
                    left outer join thaiaddress t3 on t3.chwpart=p.chwpart and t3.amppart=p.amppart and t3.tmbpart=p.tmbpart
                    WHERE v.vstdate BETWEEN "'.$startdate.'" and "'.$enddate.'"
                    AND (SELECT o1.icd10 in ("J121","J205","J210","B947") ) # OR l2.lab_items_code="1852")
                    GROUP BY v.vn
                    ORDER BY v.vstdate  
            ');
            $data['report_name'] = DB::connection('mysql')->table('report_hos')->where('report_hos_id', '=',86)->first();
                   
        }elseif($id == '87') {
            $data['datashow'] = DB::connection('mysql2')->select('
                    SELECT COUNT(DISTINCT a.hn) as totalHN,COUNT(a.an) as totalAN
                    from an_stat a 
                    left outer join ipt t on t.an=a.an 
                    left outer join dchstts d on d.dchstts=t.dchstts 
                    left outer join patient p on p.hn=a.hn
                    left outer join icd101 i on i.code in (a.pdx,a.dx0,a.dx1,a.dx2,a.dx3,a.dx4,a.dx5) 
                    where a.dchdate between "'.$startdate.'" and "'.$enddate.'" 
                    AND (SELECT i.code BETWEEN "U071" and "U072") 
            ');
            $data['report_name'] = DB::connection('mysql')->table('report_hos')->where('report_hos_id', '=',87)->first();
                   
        }elseif($id == '88') {
            $data['datashow'] = DB::connection('mysql2')->select('
                    SELECT COUNT(DISTINCT a.hn) as totalHN,COUNT(a.vn) as totalVN
                    from vn_stat a 
                    left outer join ovst t on t.vn=a.vn  
                    left outer join patient p on p.hn=a.hn
                    left outer join icd101 i on i.code in (a.pdx,a.dx0,a.dx1,a.dx2,a.dx3,a.dx4,a.dx5) 
                    where a.vstdate between "'.$startdate.'" and "'.$enddate.'" 
                    AND (SELECT i.code BETWEEN "U071" and "U072") 
            ');
            $data['report_name'] = DB::connection('mysql')->table('report_hos')->where('report_hos_id', '=',88)->first();
                   
        }elseif($id == '89') {
            $data['datashow'] = DB::connection('mysql2')->select('
                    SELECT p.pname,p.fname,p.lname,v.hn
                    FROM opitemrece o
                    LEFT OUTER JOIN vn_stat v on v.vn=o.vn
                    LEFT OUTER JOIN patient p on p.hn=v.hn
                    WHERE v.vstdate BETWEEN "'.$startdate.'" and "'.$enddate.'"
                    AND o.icode in ("3000800","3002682","3009218") 
            ');
            $data['report_name'] = DB::connection('mysql')->table('report_hos')->where('report_hos_id', '=',89)->first();
                   
        }elseif($id == '90') {
            $data['datashow'] = DB::connection('mysql2')->select('
                    SELECT a.hn,concat(p.pname,p.fname," ",p.lname) as ptname,a.age_y,a.pdx,dx0,dx1,dx2
                    ,concat(p.addrpart,"หมู่ที่ ",p.moopart," ต.",t3.name,"อ.",t2.name,"จ.",t1.name) as fulladdressname
                    from vn_stat a 
                    left outer join ovst t on t.vn=a.vn 
                    left outer join patient p on p.hn=a.hn
                    left outer join icd101 i1 on i1.code in (a.pdx,a.dx0,a.dx1,a.dx2,a.dx3,a.dx4,a.dx5) 
                    left outer join icd9cm1 i on i.code in (a.op0,a.op1,a.op2,a.op3,a.op4,a.op5) 
                    left outer join thaiaddress t1 on t1.chwpart=p.chwpart and t1.amppart= "00" and t1.tmbpart= "00"
                    left outer join thaiaddress t2 on t2.chwpart=p.chwpart and t2.amppart=p.amppart and t2.tmbpart= "00"
                    left outer join thaiaddress t3 on t3.chwpart=p.chwpart and t3.amppart=p.amppart and t3.tmbpart=p.tmbpart
                    where a.vstdate between "'.$startdate.'" and "'.$enddate.'"
                    AND (SELECT i1.code BETWEEN "F900" AND "F909")
                    AND a.age_y BETWEEN "0" and "14"
                    group by a.hn
                    ORDER BY a.vstdate 
            ');
            $data['report_name'] = DB::connection('mysql')->table('report_hos')->where('report_hos_id', '=',90)->first();
                   
        }
        
        else {
            # code...
        }        

        return view('report_all.report_hos_opd',$data,[
            'startdate'     =>    $startdate,
            'enddate'       =>    $enddate, 
            'id'            =>    $id
        ]);
    }

    // public function report_hos_01(Request $request)
    // {
    //     $startdate = $request->startdate;
    //     $enddate = $request->enddate;
    //     $data['users']     = User::get();  
    //     $data['d_claim']   = DB::connection('mysql')->select('
    //         SELECT d.vn,d.hn,d.an,d.cid,d.ptname,d.vstdate,d.pttype,d.sum_price,s.rep_a,s.tranid_c,s.price1_k,s.income_ad,s.pp_gep_ae,s.claim_true_af,s.claim_false_ag,s.cash_money_ah
    //         ,s.pay_ai,s.IPCS_ao,s.IPCS_ORS_ap,s.OPCS_aq,s.PACS_ar,s.INSTCS_as,s.OTCS_at,s.PP_au,s.DRUG_av,s.errorcode_m
    //         FROM d_claim d
    //         LEFT OUTER JOIN d_ofc_rep s ON s.hn_d = d.hn AND s.vstdate_i = d.vstdate
    //         WHERE d.vstdate BETWEEN "'.$startdate.'" and "'.$enddate.'"
    //         ORDER BY s.tranid_c DESC
    //     '); 


    //     return view('report_all.report_hos',$data,[
    //         'startdate'     =>     $startdate,
    //         'enddate'       =>     $enddate, 
    //     ]);
    // }
    
    
    
 
}
