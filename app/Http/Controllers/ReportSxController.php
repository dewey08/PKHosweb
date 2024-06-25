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

class ReportSxController extends Controller
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

    public function report_sx(Request $request)
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
        $data['report_sx']   = DB::connection('mysql')->select('SELECT * FROM report_hos Where report_department_sub = "45"'); 

        return view('report_all.report_sx',$data,[    
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate, 
        ]);
    }
    public function report_hos_sx(Request $request,$id)
    // public function report_hos_sx(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $data['users']     = User::get();  
        // $data['d_claim']   = DB::connection('mysql')->select('
        //     SELECT d.vn,d.hn,d.an,d.cid,d.ptname,d.vstdate,d.pttype,d.sum_price,s.rep_a,s.tranid_c,s.price1_k,s.income_ad,s.pp_gep_ae,s.claim_true_af,s.claim_false_ag,s.cash_money_ah
        //     ,s.pay_ai,s.IPCS_ao,s.IPCS_ORS_ap,s.OPCS_aq,s.PACS_ar,s.INSTCS_as,s.OTCS_at,s.PP_au,s.DRUG_av,s.errorcode_m
        //     FROM d_claim d
        //     LEFT OUTER JOIN d_ofc_rep s ON s.hn_d = d.hn AND s.vstdate_i = d.vstdate
        //     WHERE d.vstdate BETWEEN "'.$startdate.'" and "'.$enddate.'"
        //     ORDER BY s.tranid_c DESC
        // '); 
        // $data['report_sx']   = DB::connection('mysql')->select(
        //     'SELECT * FROM report_hos WHERE report_hos_id ="'.$id.'" AND report_department_sub = "45"' 
        // );
        // $id = '92';

        if ($id == '91') {
        //     $data['datashow']   = DB::connection('mysql2')->select('
        //             SELECT
                 
        //     ');
        //     $data['report_name'] = DB::connection('mysql')->table('report_hos')->where('report_hos_id', '=',91)->first();

        }elseif($id == '92') {
            // dd($id );
            $datashow = DB::connection('mysql2')->select(' 
                    SELECT a.hn,a.an,concat(p.pname,p.fname," ",p.lname) as ptname,s.name as sexname,a.age_y,a.pdx,dx0,dx1,dx2,dx3,dx4,dx5,d.name as dctype
                    from an_stat a 
                    left outer join ipt t on t.an=a.an 
                    left outer join dchstts d on d.dchstts=t.dchstts 
                    left outer join patient p on p.hn=a.hn
                    left outer join icd101 i1 on i1.code in (a.pdx,a.dx0,a.dx1,a.dx2,a.dx3,a.dx4,a.dx5) 
                    left outer join icd101 i on i.code in (a.dx0,a.dx1,a.dx2,a.dx3,a.dx4,a.dx5)
                    left outer join sex s on s.code=p.sex 
                    where a.dchdate between "2024-01-20" and "2024-03-27" 
                    AND (SELECT i1.code BETWEEN "M7260" AND "M7269" OR i1.code3 in ("L03") OR i1.code3 in ("L89")
                    OR i1.code in ("E105","E115","E125","E135","E145"))
                    and i.code = "R572" 
                    group by a.an
            '); 
            // AND (SELECT i1.code BETWEEN "M7260" AND "M7269" OR i1.code3 in ("L03") OR i1.code3 in ("L89")
            // OR i1.code in ("E105","E115","E125","E135","E145") 
            // )
            // dd($datashow);
            $report_name = DB::connection('mysql')->table('report_hos')->where('report_hos_id', '=',92)->first();
            $report_name_show = $report_name->report_hos_name;
            // dd($report_name_show );
            // return view('report_all.report_hos_sx',$data,[
            //     'startdate'          =>    $startdate,
            //     'enddate'            =>    $enddate, 
            //     'report_name_show'   =>    $report_name_show, 
            //     'datashow'           =>    $datashow, 
            //     'id'            =>    $id
            // ]);
                   
        // }elseif($id == '93') {
        //     $data['datashow'] = DB::connection('mysql2')->select('
        //             SELECT a.hn,a.an,concat(p.pname,p.fname," ",p.lname) as ptname,s.name as sexname,a.age_y,a.pdx,dx0,dx1,dx2,dx3,dx4,dx5,d.name as dctype
        //             from an_stat a 
        //             left outer join ipt t on t.an=a.an 
        //             left outer join dchstts d on d.dchstts=t.dchstts 
        //             left outer join patient p on p.hn=a.hn
        //             left outer join icd101 i1 on i1.code in (a.pdx,a.dx0,a.dx1,a.dx2,a.dx3,a.dx4,a.dx5) 
        //             LEFT OUTER JOIN sex s on s.code=p.sex
        //             where a.dchdate between "'.$startdate.'" and "'.$enddate.'" 
        //             AND (SELECT i1.code BETWEEN "M7260" AND "M7269" OR i1.code3 in ("L03")
        //             OR i1.code in ("E105","E115","E125","E135","E145") ) 
        //             group by a.an  
        //     ');
        //     $data['report_name'] = DB::connection('mysql')->table('report_hos')->where('report_hos_id', '=',93)->first();
                   
        // }elseif($id == '94') {
        //     $data['datashow'] = DB::connection('mysql2')->select('
        //             SELECT a.hn,a.an,concat(p.pname,p.fname," ",p.lname) as ptname,s.name as sexname,a.age_y,a.pdx,dx0,dx1,dx2,dx3,dx4,dx5,d.name as dctype
        //             from an_stat a 
        //             left outer join ipt t on t.an=a.an 
        //             left outer join dchstts d on d.dchstts=t.dchstts 
        //             left outer join patient p on p.hn=a.hn
        //             left outer join icd101 i1 on i1.code in (a.pdx,a.dx0,a.dx1,a.dx2,a.dx3,a.dx4,a.dx5) 
        //             left outer join icd101 i on i.code in (a.dx0,a.dx1,a.dx2,a.dx3,a.dx4,a.dx5) 
        //             left outer join sex s on s.code=p.sex
        //             where a.dchdate between "'.$startdate.'" and "'.$enddate.'"
        //             AND a.pdx="T793"  
        //             AND i.code BETWEEN "E100" AND "E149"
        //             group by a.an  
        //     ');
        //     $data['report_name'] = DB::connection('mysql')->table('report_hos')->where('report_hos_id', '=',94)->first();
                   
        // }elseif($id == '95') {
        //     $data['datashow'] = DB::connection('mysql2')->select('
        //             SELECT 
        //     ');
        //     $data['report_name'] = DB::connection('mysql')->table('report_hos')->where('report_hos_id', '=',95)->first();
                   
        // }elseif($id == '96') {
        //     $data['datashow'] = DB::connection('mysql2')->select('
        //             SELECT count(DISTINCT a.hn) as totalHN,SUM(a.admdate)as AdmitDate
        //             from an_stat a
        //             left outer join icd101 i1 on i1.code in (a.pdx,a.dx0,a.dx1,a.dx2,a.dx3,a.dx4,a.dx5) 
        //             where a.dchdate between "'.$startdate.'" and "'.$enddate.'"  
        //             AND (SELECT i1.code BETWEEN "K352" and "K352")
        //     ');
        //     $data['report_name'] = DB::connection('mysql')->table('report_hos')->where('report_hos_id', '=',96)->first();
                   
        // }elseif($id == '97') {
        //     $data['datashow'] = DB::connection('mysql2')->select('
        //             SELECT count(DISTINCT a.hn) as totalHN,SUM(a.admdate)as AdmitDate
        //             from an_stat a
        //             left outer join icd101 i1 on i1.code in (a.pdx,a.dx0,a.dx1,a.dx2,a.dx3,a.dx4,a.dx5) 
        //             where a.dchdate between "'.$startdate.'" and "'.$enddate.'"
        //             AND (SELECT i1.code BETWEEN "K352" and "K358")
        //     ');
        //     $data['report_name'] = DB::connection('mysql')->table('report_hos')->where('report_hos_id', '=',97)->first();
                   
        // }elseif($id == '98') {
        //     $data['datashow'] = DB::connection('mysql2')->select('
        //             SELECT 
        //     ');
        //     $data['report_name'] = DB::connection('mysql')->table('report_hos')->where('report_hos_id', '=',98)->first();
                   
        // }elseif($id == '99') {
        //     $data['datashow'] = DB::connection('mysql2')->select('
        //             SELECT a.hn,a.an,a.regdate,concat(p.pname,p.fname," ",p.lname) as ptname,a.age_y,a.pdx,dx0,dx1,dx2,dx3,dx4,dx5
        //             ,a.op0,a.op1,a.op2,a.op3,a.op4,a.op5,a.op6
        //             ,DATEDIFF(enter_date,a.regdate) as dateoper
        //              from an_stat a 
        //              left outer join ipt t on t.an=a.an 
        //              left outer join ovst v on v.vn=a.vn
        //              left outer join operation_list o on o.an=a.an
        //              left outer join dchstts d on d.dchstts=t.dchstts
        //              left outer join patient p on p.hn=a.hn
        //              left outer join icd101 i1 on i1.code in (a.pdx,a.dx0,a.dx1,a.dx2,a.dx3,a.dx4,a.dx5) 
        //              left outer join icd101 i2 on i2.code in (a.pdx,a.dx0,a.dx1,a.dx2,a.dx3,a.dx4,a.dx5)
        //              left outer join icd9cm1 i3 on i3.code in (a.op0,a.op1,a.op2,a.op3,a.op4,a.op5,a.op6)
        //              where a.dchdate between "'.$startdate.'" and "'.$enddate.'"
        //              AND (SELECT i1.code BETWEEN "K250" AND "K289" OR i1.code BETWEEN "I850" AND "I859" OR i1.code ="K922")
        //              AND (SELECT i2.code = "R571" OR i2.code ="R578")
        //              AND i3.code in ("4233","4291","4440","4441","4442","4513","4516")
        //              AND DATEDIFF(enter_date,a.regdate) <= 1
        //              group by a.an 
        //     ');
        //     $data['report_name'] = DB::connection('mysql')->table('report_hos')->where('report_hos_id', '=',99)->first();
                   
        // }elseif($id == '100') {
        //     $data['datashow'] = DB::connection('mysql2')->select('
        //             SELECT a.hn,a.an,a.regdate,concat(p.pname,p.fname," ",p.lname) as ptname,a.age_y,a.pdx,dx0,dx1,dx2,dx3,dx4,dx5
        //             ,a.op0,a.op1,a.op2,a.op3,a.op4,a.op5,a.op6
        //              from an_stat a 
        //              left outer join ipt t on t.an=a.an 
        //              left outer join ovst v on v.vn=a.vn
        //              left outer join operation_list o on o.an=a.an
        //              left outer join dchstts d on d.dchstts=t.dchstts
        //              left outer join patient p on p.hn=a.hn
        //              left outer join icd101 i1 on i1.code in (a.pdx,a.dx0,a.dx1,a.dx2,a.dx3,a.dx4,a.dx5) 
        //              left outer join icd101 i2 on i2.code in (a.pdx,a.dx0,a.dx1,a.dx2,a.dx3,a.dx4,a.dx5)
        //              where a.dchdate between "'.$startdate.'" and "'.$enddate.'"
        //              AND (SELECT i1.code BETWEEN "K250" AND "K289" OR i1.code BETWEEN "I850" AND "I859" OR i1.code ="K922")
        //              AND (SELECT i2.code = "R571" OR i2.code ="R578")
        //              group by a.an
        //     ');
        //     $data['report_name'] = DB::connection('mysql')->table('report_hos')->where('report_hos_id', '=',100)->first();
                   
        // }elseif($id == '101') {
        //     $data['datashow'] = DB::connection('mysql2')->select('
        //             SELECT a.hn,a.an,a.regdate,concat(p.pname,p.fname," ",p.lname) as ptname,a.age_y,a.pdx,dx0,dx1,dx2,dx3,dx4,dx5
        //             ,a.op0,a.op1,a.op2,a.op3,a.op4,a.op5,a.op6
        //             ,DATEDIFF(enter_date,a.regdate) as dateoper
        //              from an_stat a 
        //              left outer join ipt t on t.an=a.an 
        //              left outer join ovst v on v.vn=a.vn
        //              left outer join operation_list o on o.an=a.an
        //              left outer join dchstts d on d.dchstts=t.dchstts
        //              left outer join patient p on p.hn=a.hn
        //              left outer join icd101 i1 on i1.code in (a.pdx,a.dx0,a.dx1,a.dx2,a.dx3,a.dx4,a.dx5) 
        //              left outer join icd101 i2 on i2.code in (a.pdx,a.dx0,a.dx1,a.dx2,a.dx3,a.dx4,a.dx5)
        //              left outer join icd9cm1 i3 on i3.code in (a.op0,a.op1,a.op2,a.op3,a.op4,a.op5,a.op6)
        //              where a.dchdate between "'.$startdate.'" and "'.$enddate.'"
        //              AND (SELECT i1.code BETWEEN "K250" AND "K289" OR i1.code BETWEEN "I850" AND "I859" OR i1.code ="K922")
        //              AND (SELECT i2.code = "R571" OR i2.code ="R578")
        //              AND i3.code in ("4233","4291","4440","4441","4442","4513","4516")
        //              AND DATEDIFF(enter_date,a.regdate) > 1
        //              group by a.an 
        //     ');
        //     $data['report_name'] = DB::connection('mysql')->table('report_hos')->where('report_hos_id', '=',101)->first();
                   
        // }elseif($id == '102') {
        //     $data['datashow'] = DB::connection('mysql2')->select('
        //             SELECT 
        //     ');
        //     $data['report_name'] = DB::connection('mysql')->table('report_hos')->where('report_hos_id', '=',102)->first();
                       
        // }elseif($id == '103') {
        //     $data['datashow'] = DB::connection('mysql2')->select('
        //             SELECT count(a.an) as totalAN,SUM(a.admdate)as AdmitDate
        //             from an_stat a
        //             left outer join icd101 i1 on i1.code in (a.pdx,a.dx0,a.dx1,a.dx2,a.dx3,a.dx4,a.dx5) 
        //             where a.dchdate between "'.$startdate.'" and "'.$enddate.'" 
        //             AND (SELECT i1.code BETWEEN "K352" and "K358")
        //     ');
        //     $data['report_name'] = DB::connection('mysql')->table('report_hos')->where('report_hos_id', '=',103)->first();
                   
        // }elseif($id == '104') {
        //     $data['datashow'] = DB::connection('mysql2')->select('
        //             SELECT count(DISTINCT a.hn) as total_HN,count(DISTINCT a.an) as total_AN
        //             from an_stat a
        //             left outer join icd101 i1 on i1.code in (a.pdx,a.dx0,a.dx1,a.dx2,a.dx3,a.dx4,a.dx5) 
        //             where a.dchdate between "'.$startdate.'" and "'.$enddate.'" 
        //             AND (SELECT i1.code BETWEEN "K352" and "K358")
        //             AND a.admdate > 4
        //     ');
        //     $data['report_name'] = DB::connection('mysql')->table('report_hos')->where('report_hos_id', '=',104)->first();
                   
        // }elseif($id == '105') {
        //     $data['datashow'] = DB::connection('mysql2')->select('
        //             SELECT count(a.an)as totalAN,SUM(a.admdate) as Admitdate
        //             from an_stat a
        //             left outer join icd101 i1 on i1.code in (a.pdx,a.dx0,a.dx1,a.dx2,a.dx3,a.dx4,a.dx5)  
        //             where a.dchdate between "'.$startdate.'" and "'.$enddate.'"
        //             AND (SELECT i1.code ="E105" or i1.code="E115" or i1.code="E125" or i1.code="E135" or i1.code="E145")
        //     ');
        //     $data['report_name'] = DB::connection('mysql')->table('report_hos')->where('report_hos_id', '=',105)->first();
                   
        // }elseif($id == '106') {
        //     $data['datashow'] = DB::connection('mysql2')->select('
        //             SELECT count(a.an) as totalAN,SUM(a.admdate) as Admitdate
        //             from an_stat a
        //             left outer join icd101 i1 on i1.code in (a.dx0,a.dx1,a.dx2,a.dx3,a.dx4,a.dx5) 
        //             where a.dchdate between "'.$startdate.'" and "'.$enddate.'"   
        //             AND a.pdx = "T793" 
        //             AND (SELECT i1.code BETWEEN "E100" and "E149" )
        //     ');
        //     $data['report_name'] = DB::connection('mysql')->table('report_hos')->where('report_hos_id', '=',106)->first();
                   
        // }elseif($id == '107') {
        //     $data['datashow'] = DB::connection('mysql2')->select('
        //             SELECT count(DISTINCT a.hn)as total_HN,count(a.an)as total_AN,SUM(a.admdate) as Admitdate
        //             from an_stat a
        //             left outer join icd101 i1 on i1.code in (a.pdx,a.dx0,a.dx1,a.dx2,a.dx3,a.dx4,a.dx5)  
        //             where a.dchdate between "'.$startdate.'" and "'.$enddate.'"
        //             AND (SELECT i1.code ="E105" or i1.code="E115" or i1.code="E125" or i1.code="E135" or i1.code="E145" )
        //             AND a.admdate > 14
        //     ');
        //     $data['report_name'] = DB::connection('mysql')->table('report_hos')->where('report_hos_id', '=',107)->first();
                   
        // }elseif($id == '108') {
        //     $data['datashow'] = DB::connection('mysql2')->select('
        //             SELECT count(DISTINCT a.hn)as total_HN,count(a.an)as total_AN,SUM(a.admdate) as Admitdate
        //             from an_stat a
        //             left outer join icd101 i1 on i1.code in (a.dx0,a.dx1,a.dx2,a.dx3,a.dx4,a.dx5) 
        //             where a.dchdate between "'.$startdate.'" and "'.$enddate.'" 
        //             AND a.pdx = "T793" 
        //             AND (SELECT i1.code BETWEEN "E100" and "E149" )
        //             AND a.admdate > 14
        //     ');
        //     $data['report_name'] = DB::connection('mysql')->table('report_hos')->where('report_hos_id', '=',108)->first();
                   
        // }elseif($id == '109') {
        //     $data['datashow'] = DB::connection('mysql2')->select('
        //             SELECT 
        //     ');
        //     $data['report_name'] = DB::connection('mysql')->table('report_hos')->where('report_hos_id', '=',109)->first();
                   
        // }elseif($id == '110') {
        //     $data['datashow'] = DB::connection('mysql2')->select('
        //             SELECT v.hn,v.vn,v.vstdate,concat(p.pname,p.fname," ",p.lname) as ptname,v.age_y
        //             ,v.pdx,v.dx0,v.dx1,v.dx2,v.dx3,v.dx4,v.dx5,o.vsttime,r.refer_time
        //             ,TIMEDIFF(r.refer_time,o.vsttime) as time
        //             ,r.refer_date,h.name as referhos
        //             from vn_stat v 
        //             LEFT OUTER JOIN ovst o on o.vn=v.vn
        //             LEFT OUTER JOIN referout r on r.vn=v.vn
        //             left outer join patient p on p.hn=v.hn
        //             left outer join icd101 i on i.code in (v.pdx,v.dx0,v.dx1,v.dx2,v.dx3,v.dx4,v.dx5) 
        //             LEFT OUTER JOIN hospcode h on h.hospcode=r.refer_hospcode
        //             where v.vstdate between "'.$startdate.'" and "'.$enddate.'" 
        //             AND (SELECT i.code ="S0600" or i.code = "S0691")
        //             AND DATEDIFF(r.refer_date,o.vstdate) < 1
        //             AND TIMEDIFF(r.refer_time,o.vsttime) < "01:31:00"
        //             AND r.refer_date is not null
        //             group by v.vn
        //             order by v.vstdate 
        //     ');
        //     $data['report_name'] = DB::connection('mysql')->table('report_hos')->where('report_hos_id', '=',110)->first();
                   
        // }elseif($id == '111') {
        //     $data['datashow'] = DB::connection('mysql2')->select('
        //             SELECT v.hn,v.vn,v.vstdate,concat(p.pname,p.fname," ",p.lname) as ptname,v.age_y
        //             ,v.pdx,v.dx0,v.dx1,v.dx2,v.dx3,v.dx4,v.dx5,o.vsttime,r.refer_time
        //             ,TIMEDIFF(r.refer_time,o.vsttime) as time
        //             ,r.refer_date,h.name as referhos
        //             from vn_stat v 
        //             LEFT OUTER JOIN ovst o on o.vn=v.vn
        //             LEFT OUTER JOIN referout r on r.vn=v.vn
        //             left outer join patient p on p.hn=v.hn
        //             left outer join icd101 i on i.code in (v.pdx,v.dx0,v.dx1,v.dx2,v.dx3,v.dx4,v.dx5) 
        //             LEFT OUTER JOIN hospcode h on h.hospcode=r.refer_hospcode
        //             where v.vstdate between "'.$startdate.'" and "'.$enddate.'"
        //             AND (SELECT i.code BETWEEN "S3700" AND "S3791" or i.code BETWEEN "s2700" and "s2791")
        //             AND DATEDIFF(r.refer_date,o.vstdate) < 1
        //             AND TIMEDIFF(r.refer_time,o.vsttime) < "01:31:00"
        //             AND r.refer_date is not null
        //             group by v.vn
        //             order by v.vstdate
        //     ');
        //     $data['report_name'] = DB::connection('mysql')->table('report_hos')->where('report_hos_id', '=',111)->first();
                   
        // }elseif($id == '112') {
        //     $data['datashow'] = DB::connection('mysql2')->select('
        //             SELECT v.hn,v.vn,v.vstdate,concat(p.pname,p.fname," ",p.lname) as ptname,v.age_y
        //             ,v.pdx,v.dx0,v.dx1,v.dx2,v.dx3,v.dx4,v.dx5
        //             ,r.refer_date,h.name as referhos
        //             from vn_stat v 
        //             LEFT OUTER JOIN ovst o on o.vn=v.vn
        //             LEFT OUTER JOIN referout r on r.vn=v.vn
        //             left outer join patient p on p.hn=v.hn
        //             left outer join icd101 i on i.code in (v.pdx,v.dx0,v.dx1,v.dx2,v.dx3,v.dx4,v.dx5) 
        //             LEFT OUTER JOIN hospcode h on h.hospcode=r.refer_hospcode
        //             where v.vstdate between "'.$startdate.'" and "'.$enddate.'"
        //             AND (SELECT i.code BETWEEN "S3700" AND "S3791" or i.code BETWEEN "s2700" and "s2791" or i.code ="S0600" or i.code ="S0691")
        //             AND r.refer_date is not null
        //             group by v.vn
        //             order by v.vstdate  
        //     ');
        //     $data['report_name'] = DB::connection('mysql')->table('report_hos')->where('report_hos_id', '=',112)->first();
                   
        // }elseif($id == '113') {
        //     $data['datashow'] = DB::connection('mysql2')->select('
        //             SELECT v.hn,v.vn,v.vstdate,concat(p.pname,p.fname," ",p.lname) as ptname,v.age_y
        //             ,v.pdx,v.dx0,v.dx1,v.dx2,v.dx3,v.dx4,v.dx5,o.vsttime,r.refer_time
        //             ,TIMEDIFF(r.refer_time,o.vsttime) as time
        //             ,r.refer_date,h.name as referhos
        //             from vn_stat v 
        //             LEFT OUTER JOIN ovst o on o.vn=v.vn
        //             LEFT OUTER JOIN referout r on r.vn=v.vn
        //             left outer join patient p on p.hn=v.hn
        //             left outer join icd101 i on i.code in (v.pdx,v.dx0,v.dx1,v.dx2,v.dx3,v.dx4,v.dx5) 
        //             LEFT OUTER JOIN hospcode h on h.hospcode=r.refer_hospcode
        //             where v.vstdate between "'.$startdate.'" and "'.$enddate.'"
        //             AND (SELECT i.code ="S0600" or i.code = "S0691")
        //             AND DATEDIFF(r.refer_date,o.vstdate) < 1
        //             AND TIMEDIFF(r.refer_time,o.vsttime) > "01:30:00"
        //             AND r.refer_date is not null
        //             group by v.vn
        //             order by v.vstdate 
        //     ');
        //     $data['report_name'] = DB::connection('mysql')->table('report_hos')->where('report_hos_id', '=',113)->first();
                   
        // }elseif($id == '114') {
        //     $data['datashow'] = DB::connection('mysql2')->select('
        //             SELECT v.hn,v.vn,v.vstdate,concat(p.pname,p.fname," ",p.lname) as ptname,v.age_y
        //             ,v.pdx,v.dx0,v.dx1,v.dx2,v.dx3,v.dx4,v.dx5,o.vsttime,r.refer_time
        //             ,TIMEDIFF(r.refer_time,o.vsttime) as time
        //             ,r.refer_date,h.name as referhos
        //             from vn_stat v 
        //             LEFT OUTER JOIN ovst o on o.vn=v.vn
        //             LEFT OUTER JOIN referout r on r.vn=v.vn
        //             left outer join patient p on p.hn=v.hn
        //             left outer join icd101 i on i.code in (v.pdx,v.dx0,v.dx1,v.dx2,v.dx3,v.dx4,v.dx5) 
        //             LEFT OUTER JOIN hospcode h on h.hospcode=r.refer_hospcode
        //             where v.vstdate between "'.$startdate.'" and "'.$enddate.'"
        //             AND (SELECT i.code BETWEEN "S3700" AND "S3791" or i.code BETWEEN "s2700" and "s2791")
        //             AND DATEDIFF(r.refer_date,o.vstdate) < 1
        //             AND TIMEDIFF(r.refer_time,o.vsttime) > "01:30:00"
        //             AND r.refer_date is not null
        //             group by v.vn
        //             order by v.vstdate
        //     ');
        //     $data['report_name'] = DB::connection('mysql')->table('report_hos')->where('report_hos_id', '=',114)->first();
                   
        // }elseif($id == '115') {
        //     $data['datashow'] = DB::connection('mysql2')->select('
        //             SELECT 
        //     ');
        //     $data['report_name'] = DB::connection('mysql')->table('report_hos')->where('report_hos_id', '=',115)->first();
                   
        // }elseif($id == '116') {
        //     $data['datashow'] = DB::connection('mysql2')->select('
        //             SELECT a.hn,a.an,b.dchdate as lastdate,a.regdate,a.dchdate,concat(p.pname,p.fname," ",p.lname) as ptname,a.age_y,a.pdx,a.dx0,a.dx1,a.dx2,a.dx3,a.dx4,a.dx5
        //             ,d.name
        //             ,DATEDIFF(a.regdate,b.dchdate) as date_readmit
        //             from an_stat a
        //             left outer join an_stat b on a.hn=b.hn and a.pdx=b.pdx and a.an>b.an
        //             left outer join ipt t on t.an=a.an
        //             left outer join dchstts d on d.dchstts=t.dchstts
        //             left outer join patient p on p.hn=a.hn
        //             left outer join icd101 i1 on i1.code in (a.pdx)
        //             where a.dchdate between "'.$startdate.'" and "'.$enddate.'"
        //             AND (SELECT i1.code = "K250" OR i1.code="K252" OR i1.code="K254" OR i1.code="K256" OR i1.code="K260" OR i1.code = "K262" OR i1.code = "K264"
        //             OR i1.code="K266" OR i1.code="K270" OR i1.code = "K272" OR i1.code= "K274" OR i1.code = "K276" OR i1.code = "K280" OR i1.code="K282" OR i1.code="K284"
        //             OR i1.code="K286" OR i1.code="I850" OR i1.code = "I983" OR i1.code= "K922")
        //             and ((to_days(a.regdate))-(to_days(b.dchdate)))<=365
        //             group by a.hn 
        //     ');
        //     $data['report_name'] = DB::connection('mysql')->table('report_hos')->where('report_hos_id', '=',116)->first();
                   
        // }elseif($id == '117') {
        //     $data['datashow'] = DB::connection('mysql2')->select('
        //             SELECT a.hn,a.an,a.regdate,a.dchdate,concat(p.pname,p.fname," ",p.lname) as ptname,a.age_y,a.pdx,a.dx0,a.dx1,a.dx2,a.dx3,a.dx4,a.dx5
        //             ,d.name
        //             from an_stat a
        //             left outer join ipt t on t.an=a.an
        //             left outer join dchstts d on d.dchstts=t.dchstts
        //             left outer join patient p on p.hn=a.hn
        //             left outer join icd101 i1 on i1.code in (a.pdx,a.dx0,a.dx1,a.dx2,a.dx3,a.dx4,a.dx5)
        //             where a.dchdate between "'.$startdate.'" and "'.$enddate.'"
        //             AND (SELECT i1.code = "K250" OR i1.code="K252" OR i1.code="K254" OR i1.code="K256" OR i1.code="K260" OR i1.code = "K262" OR i1.code = "K264"
        //             OR i1.code="K266" OR i1.code="K270" OR i1.code = "K272" OR i1.code= "K274" OR i1.code = "K276" OR i1.code = "K280" OR i1.code="K282" OR i1.code="K284"
        //             OR i1.code="K286" OR i1.code="I850" OR i1.code = "I983" OR i1.code= "K922")
        //             group by a.hn
        //     ');
        //     $data['report_name'] = DB::connection('mysql')->table('report_hos')->where('report_hos_id', '=',117)->first();
                   
        } 
        else {
            # code...
        }        

        // return view('report_all.report_hos_sx',$data,[
        //     'startdate'          =>    $startdate,
        //     'enddate'            =>    $enddate, 
        //     // 'report_name_show'   =>    $report_name_show, 
        //     // 'id'            =>    $id
        // ]);
        return view('report_all.report_hos_sx',$data,[
            'startdate'          =>    $startdate,
            'enddate'            =>    $enddate, 
            'report_name_show'   =>    $report_name_show, 
            'datashow'           =>    $datashow, 
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
