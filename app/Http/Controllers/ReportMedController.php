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

class ReportMedController extends Controller
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

    public function report_med(Request $request)
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
        $data['report_med']   = DB::connection('mysql')->select('SELECT * FROM report_hos Where report_department_sub = "44"'); 

        return view('report_all.report_med',$data,[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate, 
        ]);
    }
    public function report_hos_med(Request $request,$id)
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
        $data['report_med']   = DB::connection('mysql')->select(
            'SELECT * FROM report_hos WHERE report_hos_id ="'.$id.'" and report_department_sub = "44"' );
        
        if ($id == '35') {
            $data['datashow']   = DB::connection('mysql2')->select('
                    SELECT
                 
            ');
            $data['report_name'] = DB::connection('mysql')->table('report_hos')->where('report_hos_id', '=',36)->first();

        }elseif($id == '36') {
            $data['datashow'] = DB::connection('mysql2')->select('
                    SELECT a.hn,a.an,concat(p.pname,p.fname," ",p.lname) as ptname,a.age_y,a.pdx,dx0,dx1,dx2,dx3,dx4,dx5
                    from an_stat a 
                    left outer join ipt t on t.an=a.an 
                    left outer join patient p on p.hn=a.hn
                    left outer join icd101 i1 on i1.code in (a.pdx,a.dx0,a.dx1,a.dx2,a.dx3,a.dx4,a.dx5)  
                    left outer join icd101 i2 on i2.code in (a.pdx,a.dx0,a.dx1,a.dx2,a.dx3,a.dx4,a.dx5) 
                    where a.regdate between "'.$startdate.'" and "'.$enddate.'"
                    AND (SELECT i1.code = "I214")
                    AND (SELECT i2.code = "R571" OR i2.code BETWEEN "I460" AND "I469")
                    group by a.an
                    ORDER BY a.regdate  
            ');
            $data['report_name'] = DB::connection('mysql')->table('report_hos')->where('report_hos_id', '=',36)->first();
            
        
        }elseif($id == '37'){
            $data['datashow'] = DB::connection('mysql2')->select('
                    SELECT a.hn,a.an,concat(p.pname,p.fname," ",p.lname) as ptname,a.age_y,a.pdx,dx0,dx1,dx2,dx3,dx4,dx5
                    from an_stat a 
                    left outer join ipt t on t.an=a.an 
                    left outer join patient p on p.hn=a.hn
                    left outer join icd101 i1 on i1.code in (a.pdx,a.dx0,a.dx1,a.dx2,a.dx3,a.dx4,a.dx5)  
                    where a.regdate between "'.$startdate.'" and "'.$enddate.'"
                    AND (SELECT i1.code = "I214")
                    group by a.an
                    ORDER BY a.regdate  
            ');
            $data['report_name'] = DB::connection('mysql')->table('report_hos')->where('report_hos_id', '=',37)->first();
        
        }elseif($id == '38'){
            $data['datashow'] = DB::connection('mysql2')->select('
                    SELECT a.hn,a.an,concat(p.pname,p.fname," ",p.lname) as ptname,a.age_y,a.pdx,dx0,dx1,dx2,dx3,dx4,dx5,d.name
                    from an_stat a 
                    left outer join ipt t on t.an=a.an 
                    left outer join patient p on p.hn=a.hn
                    left outer join dchstts d on d.dchstts=t.dchstts
                    left outer join icd101 i1 on i1.code in (a.pdx,a.dx0,a.dx1,a.dx2,a.dx3,a.dx4,a.dx5)  
                    left outer join icd101 i2 on i2.code in (a.pdx,a.dx0,a.dx1,a.dx2,a.dx3,a.dx4,a.dx5) 
                    where a.regdate between "'.$startdate.'" and "'.$enddate.'"
                    AND (SELECT i1.code = "I214")
                    AND (SELECT i2.code = "R571" OR i2.code BETWEEN "I460" AND "I469")
                    AND p.death = "Y"
                    group by a.hn
                    ORDER BY a.regdate 
            ');
            $data['report_name'] = DB::connection('mysql')->table('report_hos')->where('report_hos_id', '=',38)->first();

        }elseif($id == '39'){
            $data['datashow'] = DB::connection('mysql2')->select('
                    SELECT e  
            ');
            $data['report_name'] = DB::connection('mysql')->table('report_hos')->where('report_hos_id', '=',39)->first();

        }elseif($id == '40'){
            $data['datashow'] = DB::connection('mysql2')->select('
                    SELECT count(DISTINCT a.an) as an,count(DISTINCT a.hn) as hn
                    from an_stat a
                    left outer join icd101 i1 on i1.code in (a.pdx,a.dx0,a.dx1,a.dx2,a.dx3,a.dx4,a.dx5)
                    left outer join icd9cm1 i2 on i2.code in (a.op0,a.op1,a.op2,a.op3,a.op4,a.op5,a.op6)
                    where a.dchdate between "'.$startdate.'" and "'.$enddate.'"  
                    AND (SELECT i1.code = "N185")
                    AND (SELECT i2.code = "3995" OR i2.code = "5498")
                    AND a.age_y < 70  
            ');
            $data['report_name'] = DB::connection('mysql')->table('report_hos')->where('report_hos_id', '=',40)->first();

        }elseif($id == '41'){
            $data['datashow'] = DB::connection('mysql2')->select('
                    SELECT 
            ');
            $data['report_name'] = DB::connection('mysql')->table('report_hos')->where('report_hos_id', '=',41)->first();

        }elseif($id == '42'){
            $data['datashow'] = DB::connection('mysql2')->select('
                    SELECT a.hn,a.an,a.regdate,a.dchdate,concat(p.pname,p.fname," ",p.lname) as ptname,a.age_y,a.pdx,a.dx0,a.dx1,a.dx2,a.dx3,a.dx4,a.dx5
                    ,d.name
                    from an_stat a
                    left outer join ipt t on t.an=a.an
                    left outer join dchstts d on d.dchstts=t.dchstts
                    left outer join patient p on p.hn=a.hn
                    left outer join icd101 i1 on i1.code in (a.pdx,a.dx0,a.dx1,a.dx2,a.dx3,a.dx4,a.dx5)
                    left outer join icd101 i2 on i2.code in (a.pdx,a.dx0,a.dx1,a.dx2,a.dx3,a.dx4,a.dx5)
                    where a.dchdate between "'.$startdate.'" and "'.$enddate.'"
                    AND (SELECT i1.code = "N185")
                    AND (SELECT i2.code = "J81")
                    AND a.age_y < 70
                    group by a.an
                    ORDER BY a.regdate
            ');
            $data['report_name'] = DB::connection('mysql')->table('report_hos')->where('report_hos_id', '=',42)->first();

        }elseif($id == '43'){
            $data['datashow'] = DB::connection('mysql2')->select('
                    SELECT a.hn,a.an,a.regdate,a.dchdate,concat(p.pname,p.fname," ",p.lname) as ptname,a.age_y,a.pdx,a.dx0,a.dx1,a.dx2,a.dx3,a.dx4,a.dx5
                    ,d.name
                    from an_stat a
                    left outer join ipt t on t.an=a.an
                    left outer join dchstts d on d.dchstts=t.dchstts
                    left outer join patient p on p.hn=a.hn
                    left outer join icd101 i1 on i1.code in (a.pdx,a.dx0,a.dx1,a.dx2,a.dx3,a.dx4,a.dx5)
                    left outer join icd101 i2 on i2.code in (a.pdx,a.dx0,a.dx1,a.dx2,a.dx3,a.dx4,a.dx5)
                    where a.dchdate between "'.$startdate.'" and "'.$enddate.'"
                    AND (SELECT i1.code = "N185")
                    AND (SELECT i2.code = "E875")
                    AND a.age_y < 70
                    group by a.an
                    ORDER BY a.regdate 
            ');
            $data['report_name'] = DB::connection('mysql')->table('report_hos')->where('report_hos_id', '=',43)->first();

        }elseif($id == '44'){
            $data['datashow'] = DB::connection('mysql2')->select('
                    SELECT v.hn,concat(p.pname,p.fname," ",p.lname) as ptname,v.age_y,o1.icd10,v.age_y as age
                    FROM vn_stat v
                    LEFT OUTER JOIN patient p on v.hn=p.hn
                    LEFT OUTER JOIN ovstdiag o1 on o1.vn=v.vn
                    WHERE v.vstdate BETWEEN "'.$startdate.'" and "'.$enddate.'"
                    AND o1.icd10 = "N185"
                    AND v.age_y < 70
                    UNION
                    SELECT 
                    a.hn,concat(p1.pname,p1.fname," ",p1.lname) as ptname,a.age_y,i1.icd10,a.age_y as age
                    FROM an_stat a
                    LEFT OUTER JOIN patient p1 on p1.hn=a.hn
                    LEFT OUTER JOIN iptdiag i1 on i1.an=a.an
                    WHERE a.regdate BETWEEN "'.$startdate.'" and "'.$enddate.'"
                    AND i1.icd10 = "N185"
                    AND a.age_y < 70
            ');
            $data['report_name'] = DB::connection('mysql')->table('report_hos')->where('report_hos_id', '=',44)->first();

        }elseif($id == '45'){
            $data['datashow'] = DB::connection('mysql2')->select('
                    SELECT a.hn,a.an,a.regdate,a.dchdate,concat(p.pname,p.fname," ",p.lname) as ptname,a.age_y,a.pdx,a.dx0,a.dx1,a.dx2,a.dx3,a.dx4,a.dx5
                    ,d.name
                    from an_stat a
                    left outer join ipt t on t.an=a.an
                    left outer join dchstts d on d.dchstts=t.dchstts
                    left outer join patient p on p.hn=a.hn
                    left outer join icd101 i1 on i1.code in (a.pdx,a.dx0,a.dx1,a.dx2,a.dx3,a.dx4,a.dx5)
                    left outer join icd101 i2 on i2.code in (a.pdx,a.dx0,a.dx1,a.dx2,a.dx3,a.dx4,a.dx5)
                    where a.dchdate between "'.$startdate.'" and "'.$enddate.'"
                    AND (SELECT i1.code = "N185")
                    AND (SELECT i2.code = "E877")
                    AND a.age_y < 70
                    group by a.an
                    ORDER BY a.regdate 
            ');
            $data['report_name'] = DB::connection('mysql')->table('report_hos')->where('report_hos_id', '=',45)->first();

        }elseif($id == '46'){
            $data['datashow'] = DB::connection('mysql2')->select('
                    SELECT  
            ');
            $data['report_name'] = DB::connection('mysql')->table('report_hos')->where('report_hos_id', '=',46)->first();

        }elseif($id == '47'){
            $data['datashow'] = DB::connection('mysql2')->select('
                    SELECT a.hn,a.an,a.regdate,a.dchdate,concat(p.pname,p.fname," ",p.lname) as ptname,a.age_y,a.pdx,a.dx0,a.dx1,a.dx2,a.dx3,a.dx4,a.dx5,d.name
                    from an_stat a
                    left outer join ipt t on t.an=a.an
                    left outer join dchstts d on d.dchstts=t.dchstts
                    left outer join patient p on p.hn=a.hn
                    left outer join icd101 i1 on i1.code in (a.pdx,a.dx0,a.dx1,a.dx2,a.dx3,a.dx4,a.dx5)
                    left outer join icd9cm1 i2 on i2.code in (a.op0,a.op1,a.op2,a.op3,a.op4,a.op5,a.op6)
                    where a.dchdate between "'.$startdate.'" and "'.$enddate.'"
                    AND (SELECT i1.code = "N185")
                    AND (SELECT i2.code = "3995" OR i2.code = "5498")
                    AND a.age_y < 70
                    AND p.death = "N"
                    group by a.hn
                    ORDER BY a.regdate
            ');
            $data['report_name'] = DB::connection('mysql')->table('report_hos')->where('report_hos_id', '=',47)->first();

        }elseif($id == '48'){
            $data['datashow'] = DB::connection('mysql2')->select('
                    SELECT a.hn,a.an,a.regdate,a.dchdate,concat(p.pname,p.fname," ",p.lname) as ptname,a.age_y,a.pdx,a.dx0,a.dx1,a.dx2,a.dx3,a.dx4,a.dx5,d.name
                    from an_stat a
                    left outer join ipt t on t.an=a.an
                    left outer join dchstts d on d.dchstts=t.dchstts
                    left outer join patient p on p.hn=a.hn
                    left outer join icd101 i1 on i1.code in (a.pdx,a.dx0,a.dx1,a.dx2,a.dx3,a.dx4,a.dx5)
                    left outer join icd9cm1 i2 on i2.code in (a.op0,a.op1,a.op2,a.op3,a.op4,a.op5,a.op6)
                    where a.dchdate between "'.$startdate.'" and "'.$enddate.'"
                    AND (SELECT i1.code = "N185")
                    AND (SELECT i2.code = "3995" OR i2.code = "5498")
                    AND a.age_y < 70
                    group by a.hn
                    ORDER BY a.regdate 
            ');
            $data['report_name'] = DB::connection('mysql')->table('report_hos')->where('report_hos_id', '=',48)->first();

        }elseif($id == '49'){
            $data['datashow'] = DB::connection('mysql2')->select('
                    SELECT a.hn,a.an,a.regdate,a.dchdate,concat(p.pname,p.fname," ",p.lname) as ptname,a.age_y,a.pdx,a.dx0,a.dx1,a.dx2,a.dx3,a.dx4,a.dx5
                    ,d.name,d3.death_date
                    from an_stat a
                    left outer join ipt t on t.an=a.an
                    left outer join dchstts d on d.dchstts=t.dchstts
                    left outer join patient p on p.hn=a.hn
                    left outer join icd101 i1 on i1.code in (a.pdx,a.dx0,a.dx1,a.dx2,a.dx3,a.dx4,a.dx5)
                    left outer join icd9cm1 i2 on i2.code in (a.op0,a.op1,a.op2,a.op3,a.op4,a.op5,a.op6)
                    left outer join death d3 on d3.hn=p.hn
                    where a.dchdate between "'.$startdate.'" and "'.$enddate.'"
                    AND (SELECT i1.code = "N185")
                    AND (SELECT i2.code = "3995" OR i2.code = "5498")
                    AND a.age_y < 70
                    AND p.death = "Y"
                    AND p.hn in (SELECT d2.hn FROM death d2 WHERE d2.death_date BETWEEN "'.$startdate.'" and "'.$enddate.'")
                    group by a.hn
                    ORDER BY a.regdate 
            ');
            $data['report_name'] = DB::connection('mysql')->table('report_hos')->where('report_hos_id', '=',49)->first();

        }elseif($id == '50'){
            $data['datashow'] = DB::connection('mysql2')->select('
                    SELECT 
            ');
            $data['report_name'] = DB::connection('mysql')->table('report_hos')->where('report_hos_id', '=',50)->first();

        }elseif($id == '51'){
            $data['datashow'] = DB::connection('mysql2')->select('
                    SELECT v.hn,v.vn,concat(p.pname,p.fname," ",p.lname) as ptname,v.age_y
                    ,v.pdx,v.dx0,v.dx1,v.dx2,v.dx3,o.vstdate,o.vsttime,r.refer_date,r.refer_time,o.ovstost,h.name as referhos
                    ,TIMEDIFF(r.refer_time,o.vsttime) as timerefer
                     from vn_stat v 
                     LEFT OUTER JOIN ovst o on o.vn=v.vn
                     LEFT OUTER JOIN referout r on r.vn=v.vn
                     left outer join patient p on p.hn=v.hn
                     left outer join icd101 i on i.code in (v.pdx,v.dx0,v.dx1,v.dx2,v.dx3,v.dx4,v.dx5) 
                     LEFT OUTER JOIN hospcode h on h.hospcode=r.refer_hospcode
                     where v.vstdate between "'.$startdate.'" and "'.$enddate.'"
                     and i.code between "I210" and "I213" 
                     AND r.refer_date is not null
                     AND DATEDIFF(r.refer_date,o.vstdate) < 1
                     AND TIMEDIFF(r.refer_time,o.vsttime) < "01:00:59"
                     group by v.hn
                     order by v.vstdate  
            ');
            $data['report_name'] = DB::connection('mysql')->table('report_hos')->where('report_hos_id', '=',51)->first();

        }elseif($id == '52'){
            $data['datashow'] = DB::connection('mysql2')->select('
                    SELECT v.hn,v.vn,v.vstdate,concat(p.pname,p.fname," ",p.lname) as ptname,v.age_y
                    ,v.pdx,v.dx0,v.dx1,v.dx2,v.dx3,v.dx4,v.dx5,o.vsttime,r.refer_time,r.refer_date,o.ovstost,h.name as referhos
                     from vn_stat v 
                     LEFT OUTER JOIN ovst o on o.vn=v.vn
                     LEFT OUTER JOIN referout r on r.vn=v.vn
                     left outer join patient p on p.hn=v.hn
                     left outer join icd101 i on i.code in (v.pdx,v.dx0,v.dx1,v.dx2,v.dx3,v.dx4,v.dx5) 
                     LEFT OUTER JOIN hospcode h on h.hospcode=r.refer_hospcode
                     where v.vstdate between "'.$startdate.'" and "'.$enddate.'"
                     and i.code between "I210" and "I213" 
                     AND r.refer_date is not null
                     group by v.hn
                     order by v.vstdate 
            ');
            $data['report_name'] = DB::connection('mysql')->table('report_hos')->where('report_hos_id', '=',52)->first();

        }elseif($id == '53'){
            $data['datashow'] = DB::connection('mysql2')->select('
                    SELECT  
            ');
            $data['report_name'] = DB::connection('mysql')->table('report_hos')->where('report_hos_id', '=',53)->first();

        }elseif($id == '54'){
            $data['datashow'] = DB::connection('mysql2')->select('
                    SELECT count(DISTINCT a.hn)as totalHN
                    from an_stat a
                    left outer join an_stat b on a.hn=b.hn and a.pdx=b.pdx and a.an>b.an
                    left outer join icd101 i1 on i1.code in (a.pdx,a.dx0,a.dx1,a.dx2,a.dx3,a.dx4,a.dx5)
                    where a.dchdate between "'.$startdate.'" and "'.$enddate.'"
                    AND (SELECT i1.code = "F100" or i1.code= "F103")
                    and a.lastvisit <= 365
                    and ((to_days(a.regdate))-(to_days(b.dchdate)))<=365  
            ');
            $data['report_name'] = DB::connection('mysql')->table('report_hos')->where('report_hos_id', '=',54)->first();

        }elseif($id == '55'){
            $data['datashow'] = DB::connection('mysql2')->select('
                    SELECT count(DISTINCT a.hn)as totalHN
                    from an_stat a
                    left outer join icd101 i1 on i1.code in (a.pdx,a.dx0,a.dx1,a.dx2,a.dx3,a.dx4,a.dx5)
                    where a.dchdate between "'.$startdate.'" and "'.$enddate.'"
                    AND (SELECT i1.code = "F100" or i1.code= "F103")  
            ');
            $data['report_name'] = DB::connection('mysql')->table('report_hos')->where('report_hos_id', '=',55)->first();

        }elseif($id == '56'){
            $data['datashow'] = DB::connection('mysql2')->select('
                    SELECT 
            ');
            $data['report_name'] = DB::connection('mysql')->table('report_hos')->where('report_hos_id', '=',56)->first();

        }elseif($id == '57'){
            $data['datashow'] = DB::connection('mysql2')->select('
                    SELECT a.hn,a.an,concat(p.pname,p.fname," ",p.lname) as ptname,a.age_y,s.name as sexname,a.pdx,dx0,dx1,dx2,dx3,dx4,dx5,d.name
                    ,a.op0,a.op1,a.op2,a.op3,a.op4,a.op5,a.op6 
                    from an_stat a 
                    left outer join ipt t on t.an=a.an 
                    left outer join dchstts d on d.dchstts=t.dchstts 
                    left outer join patient p on p.hn=a.hn
                    left outer join icd101 i1 on i1.code in (a.pdx,a.dx0,a.dx1,a.dx2,a.dx3,a.dx4,a.dx5) 
                    left outer join icd9cm1 i on i.code in (a.op0,a.op1,a.op2,a.op3,a.op4,a.op5,a.op6)
                    left outer join sex s on s.code=p.sex 
                    where a.dchdate between "'.$startdate.'" and "'.$enddate.'"
                    and i1.code = "J441" 
                    group by a.an
            ');
            $data['report_name'] = DB::connection('mysql')->table('report_hos')->where('report_hos_id', '=',57)->first();

        }elseif($id == '58'){
            $data['datashow'] = DB::connection('mysql2')->select('
                    SELECT v.vn,v.hn,v.cid,v.vstdate,v.age_y,concat(pt.pname,pt.fname,"  ",pt.lname) as fullname,v.pdx,v.dx0,v.dx1,v.dx2,v.dx3,v.dx4,v.dx5,op0,op1,op2,op3,op4,op5,d.shortname
                    from vn_stat v 
                    left outer join patient pt on pt.hn=v.hn 
                    left outer join doctor d on d.code=v.dx_doctor 
                    left outer join icd101 i on i.code in (pdx,dx0,dx1,dx2,dx3,dx4,dx5) 
                    left outer join icd9cm1 ii on ii.code in (op0,op1,op2,op3,op4,op5) 
                    where v.vstdate between "'.$startdate.'" and "'.$enddate.'"  
                    and i.code = "J441" 
                    group by v.vn 
                    order by v.vstdate 
            ');
            $data['report_name'] = DB::connection('mysql')->table('report_hos')->where('report_hos_id', '=',58)->first();

        }elseif($id == '59'){
            $data['datashow'] = DB::connection('mysql2')->select('
                    SELECT v.hn,v.vn,v.vstdate,concat(p.pname,p.fname," ",p.lname) as ptname,v.age_y,s.name as sexname
                    from vn_stat v 
                    left outer join patient p on p.hn=v.hn 
                    left outer join icd101 i on i.code in (pdx,dx0,dx1,dx2,dx3,dx4,dx5) 
                    LEFT OUTER JOIN sex s on s.code=p.sex
                    where v.vstdate between "'.$startdate.'" and "'.$enddate.'" 
                    and i.code between "J440" and "J449" 
                    group by v.vn
                    order by v.vstdate 
            ');
            $data['report_name'] = DB::connection('mysql')->table('report_hos')->where('report_hos_id', '=',59)->first();

        }elseif($id == '60'){
            $data['datashow'] = DB::connection('mysql2')->select('
                    SELECT 
            ');
            $data['report_name'] = DB::connection('mysql')->table('report_hos')->where('report_hos_id', '=',60)->first();
    
            
        }elseif($id == '61'){
            $data['datashow'] = DB::connection('mysql2')->select('
                    SELECT a.hn,a.regdate,a.dchdate,a.an,concat(p.pname,p.fname," ",p.lname) as ptname,a.age_y,a.pdx,dx0,dx1,dx2,dx3,dx4,dx5
                    from an_stat a 
                    left outer join ipt t on t.an=a.an 
                    left outer join patient p on p.hn=a.hn
                    left outer join icd101 i1 on i1.code in (a.pdx,a.dx0,a.dx1,a.dx2,a.dx3,a.dx4,a.dx5)
                    left outer join icd101 i2 on i2.code in (a.pdx,a.dx0,a.dx1,a.dx2,a.dx3,a.dx4,a.dx5)
                    where a.dchdate between "'.$startdate.'" and "'.$enddate.'" 
                    AND (SELECT i1.code BETWEEN "T620" AND "T620")
                    AND (SELECT i2.code BETWEEN "K720" AND "K729")
                    group by a.an
                    ORDER BY a.regdate
            ');
            $data['report_name'] = DB::connection('mysql')->table('report_hos')->where('report_hos_id', '=',61)->first();

        }elseif($id == '62'){
            $data['datashow'] = DB::connection('mysql2')->select('
                    SELECT a.hn,a.regdate,a.dchdate,a.an,concat(p.pname,p.fname," ",p.lname) as ptname,a.age_y,a.pdx,dx0,dx1,dx2,dx3,dx4,dx5
                    from an_stat a 
                    left outer join ipt t on t.an=a.an 
                    left outer join patient p on p.hn=a.hn
                    left outer join icd101 i1 on i1.code in (a.pdx,a.dx0,a.dx1,a.dx2,a.dx3,a.dx4,a.dx5)  
                    where a.dchdate between "'.$startdate.'" and "'.$enddate.'" 
                    AND (SELECT i1.code = "T620")
                    group by a.an
                    ORDER BY a.regdate
            ');
            $data['report_name'] = DB::connection('mysql')->table('report_hos')->where('report_hos_id', '=',62)->first();

        }elseif($id == '63'){
            $data['datashow'] = DB::connection('mysql2')->select('
                    SELECT  
            ');
            $data['report_name'] = DB::connection('mysql')->table('report_hos')->where('report_hos_id', '=',63)->first();
        }
        
        else {
            # code...
        }        

        return view('report_all.report_hos_med',$data,[
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
