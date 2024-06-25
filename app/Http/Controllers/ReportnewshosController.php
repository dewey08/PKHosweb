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

class ReportnewshosController extends Controller
{ 
    // public function report_db(Request $request)
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


    //     return view('report_all.report_db',$data,[
    //         'startdate'     =>     $startdate,
    //         'enddate'       =>     $enddate, 
    //     ]);
    // }

    public function report_hos_01(Request $request)
    {
        $startdate   = $request->startdate;
        $enddate     = $request->enddate;        
        
        $hos_a = DB::connection('mysql2')->select('
                SELECT v.refer_date,a.hn,a.an,CONCAT(p.pname,p.fname," ",p.lname) as ptname,s.name as sexname,h.name as referhos,
                    a.pdx,a.dx0,a.dx1,a.dx2,a.dx3,a.dx4,a.dx5,DATEDIFF(v.refer_date,ip.regdate) as datereg,TIMEDIFF(v.refer_time,ip.regtime) as timerefer
                    FROM referout v 
                    LEFT OUTER JOIN an_stat a on a.an=v.vn
                    LEFT OUTER JOIN ipt ip on ip.an=a.an
                    LEFT OUTER JOIN patient p on p.hn=a.hn 
                    LEFT OUTER JOIN icd101 i on i.code in (a.pdx,a.dx0,a.dx1,a.dx2,a.dx3,a.dx4,a.dx5)
                    LEFT OUTER JOIN hospcode h on h.hospcode=v.refer_hospcode
                    LEFT OUTER JOIN sex s on s.code=p.sex
                    WHERE v.refer_date BETWEEN "'. $startdate.'" AND "'. $enddate.'"
                    AND v.department ="IPD"
                    AND DATEDIFF(v.refer_date,ip.regdate) <= "0"
                    AND TIMEDIFF(v.refer_time,ip.regtime) < "06:00:00"
                    AND TIMEDIFF(v.refer_time,ip.regtime) not LIKE "-%"
                    AND h.hospcode not in ("04038","04039","04040","04041","04042","04043","04044","04045","04046","04047","04048","04049",
                    "04051","10970","10971","10972","10973","10974","10975","10976","10977","10979","10980","10981","10982","10983")
                    GROUP BY a.an 
                    ORDER BY v.refer_date 
        ');
 
        return view('report_all.report_hos_01',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'hos_a'        =>     $hos_a,             
        ]);
    }
    
    public function report_hos_02(Request $request)
    {
        $startdate   = $request->startdate;
        $enddate     = $request->enddate;        
        
        $hos_a = DB::connection('mysql2')->select('
                SELECT d.hn,d.death_date,concat(p.pname,p.fname," ",p.lname) as ptname,s.name as sexname,a.age_y,
                d.death_diag_1,d.death_diag_2,d.death_diag_3,d.death_diag_4,d.an,a.regdate,a.dchdate,a.admdate,w.name as wardname,CONCAT(t.pname,t.fname," ",t.lname) as doctorname
                 from death d  
                 left outer join patient p on p.hn=d.hn 
                 left outer join icd101 i on i.code in (d.death_diag_1,d.death_diag_2,d.death_diag_3,d.death_diag_4)
                 left outer join icd101 i1 on i1.code in (d.death_diag_1,d.death_diag_2,d.death_diag_3,d.death_diag_4) 
                 left outer join doctor t on t.code=d.death_cert_doctor 
                 LEFT OUTER JOIN an_stat a on a.an=d.an
                 LEFT OUTER JOIN ward w on w.ward=a.ward
                 left outer join sex s on s.code=p.sex 
                 where d.death_date between "'. $startdate.'" AND "'. $enddate.'"
                 and (SELECT i.code BETWEEN "J120" and "J189" or i.code in ("J690"))
                 and i1.code in ("U071","U072")
                 and d.death_place="1" 
                 and a.age_y >= "15"
                 group by d.hn 
                 order by d.death_date  
        ');
 
        return view('report_all.report_hos_02',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'hos_a'        =>     $hos_a,             
        ]);
    }
    
    public function report_hos_03(Request $request)
    {
        $startdate   = $request->startdate;
        $enddate     = $request->enddate;        
        
        $hos_a = DB::connection('mysql2')->select('
                SELECT d.hn,d.death_date,concat(p.pname,p.fname," ",p.lname) as ptname,s.name as sexname,d.death_diag_1
                ,d.death_diag_2,d.death_diag_3,d.death_diag_4,t.name,a.regdate,a.dchdate,a.admdate
                ,w1.name as firstward,w.name as wardname
                 from death d  
                 left outer join patient p on p.hn=d.hn 
                 left outer join an_stat a on a.an=d.an
                 left outer join ipt ip on ip.an=d.an  
                 left outer join icd101 i on i.code in (d.death_diag_1,d.death_diag_2,d.death_diag_3,d.death_diag_4) 
                 left outer join doctor t on t.code=d.death_cert_doctor
                 left outer join ward w on w.ward=a.ward
                 left outer join ward w1 on w1.ward=ip.first_ward 
                 left outer join sex s on s.code=p.sex
                 where d.death_date between "'. $startdate.'" AND "'. $enddate.'"
                 and d.an<>"" and d.death_place="1" 
                 and (w.name<>w1.name)
                 group by d.hn 
                 order by d.death_date  
        ');
 
        return view('report_all.report_hos_03',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'hos_a'         =>     $hos_a,             
        ]);
    }

    public function report_hos_04(Request $request)
    {
        $startdate   = $request->startdate;
        $enddate     = $request->enddate;        
        
        $hos_a = DB::connection('mysql2')->select('
                SELECT d.hn,d.death_date,concat(p.pname,p.fname," ",p.lname) as ptname,s.name as sexname,a.age_y,
                d.death_diag_1,d.death_diag_2,d.death_diag_3,d.death_diag_4,d.an,a.regdate,a.dchdate,a.admdate,w.name as wardname,CONCAT(t.pname,t.fname," ",t.lname) as doctorname
                from death d  
                left outer join patient p on p.hn=d.hn 
                left outer join icd101 i on i.code in (d.death_diag_1,d.death_diag_2,d.death_diag_3,d.death_diag_4) 
                left outer join doctor t on t.code=d.death_cert_doctor 
                LEFT OUTER JOIN an_stat a on a.an=d.an
                LEFT OUTER JOIN ward w on w.ward=a.ward
                left outer join sex s on s.code=p.sex 
                where d.death_date between "'. $startdate.'" AND "'. $enddate.'"
                AND (SELECT i.code BETWEEN "M7260" AND "M7269" OR i.code3 in ("L03")
                OR i.code in ("E105","E115","E125","E135","E145") )
                and d.death_place="1" 
                group by d.hn 
                order by d.death_date   
        ');
 
        return view('report_all.report_hos_04',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'hos_a'         =>     $hos_a,             
        ]);
    }

    public function report_hos_05(Request $request)
    {
        $startdate   = $request->startdate;
        $enddate     = $request->enddate;        
        
        $hos_a = DB::connection('mysql2')->select('
                SELECT pt.hn,d.an,concat(pt.pname,pt.fname,"  ",pt.lname) as ptname,s.name as sexname,YEAR(d.death_date)-YEAR(pt.birthday) as age ,d.death_date,d.death_diag_1,d.death_diag_2,d.death_diag_3,d.death_diag_4,d.death_diag_other,dr.name as doctorname
                from death d    
                left outer join patient pt on pt.hn = d.hn  
                left outer join doctor dr on dr.code=d.death_cert_doctor 
                left outer join sex s on s.code=pt.sex
                where d.death_date between "'. $startdate.'" AND "'. $enddate.'"
                AND d.death_place="1" 
                and d.an=""  
                group by d.hn
                order by d.death_date   
        ');
 
        return view('report_all.report_hos_05',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'hos_a'         =>     $hos_a,             
        ]);
    }

    public function report_hos_06(Request $request)
    {
        $startdate   = $request->startdate;
        $enddate     = $request->enddate;        
        
        $hos_a = DB::connection('mysql2')->select('
                SELECT d.hn,d.death_date,concat(p.pname,p.fname," ",p.lname) as ptname,s.name as sexname,d.death_diag_1,d.death_diag_2,d.death_diag_3,d.death_diag_4,t.name,a.regdate,dchdate,a.admdate,w.name as wardname
                from death d  
                left outer join patient p on p.hn=d.hn 
                left outer join an_stat a on a.an=d.an 
                left outer join icd101 i on i.code in (d.death_diag_1,d.death_diag_2,d.death_diag_3,d.death_diag_4) 
                left outer join doctor t on t.code=d.death_cert_doctor
                left outer join ward w on w.ward=a.ward 
                left outer join sex s on s.code=p.sex
                where d.death_date between "'. $startdate.'" AND "'. $enddate.'"
                and d.an<>"" and d.death_place="1" 
                group by d.hn 
                order by d.death_date   
        ');
 
        return view('report_all.report_hos_06',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'hos_a'         =>     $hos_a,             
        ]);
    }

    public function report_hos_07(Request $request)
    {
        $startdate   = $request->startdate;
        $enddate     = $request->enddate;        
        
        $hos_a = DB::connection('mysql2')->select('
                SELECT a.hn,a.an,concat(p.pname,p.fname," ",p.lname) as ptname,a.age_y,a.pdx,dx0,dx1,dx2,dx3,dx4,dx5,d.name
                from an_stat a 
                left outer join ipt t on t.an=a.an 
                left outer join dchstts d on d.dchstts=t.dchstts 
                left outer join patient p on p.hn=a.hn
                left outer join icd101 i on i.code in (a.pdx,a.dx0,a.dx1,a.dx2,a.dx3,a.dx4,a.dx5)
                where a.dchdate between "'. $startdate.'" AND "'. $enddate.'"
                AND (SELECT i.code BETWEEN "O800" and "O849")
                group by a.an  
        ');
 
        return view('report_all.report_hos_07',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'hos_a'         =>     $hos_a,             
        ]);
    }

    public function report_hos_08(Request $request)
    {
        $startdate   = $request->startdate;
        $enddate     = $request->enddate;        
        
        $hos_a = DB::connection('mysql2')->select('
                SELECT a.hn,a.an,concat(p.pname,p.fname," ",p.lname) as ptname,s.name as sexname,a.age_y,a.pdx,dx0,dx1,dx2,dx3,dx4,dx5,d.name as dctype
                from an_stat a 
                left outer join ipt t on t.an=a.an 
                left outer join dchstts d on d.dchstts=t.dchstts 
                left outer join patient p on p.hn=a.hn
                left outer join icd101 i1 on i1.code in (a.pdx,a.dx0,a.dx1,a.dx2,a.dx3,a.dx4,a.dx5) 
                left outer join icd101 i on i.code in (a.pdx,a.dx0,a.dx1,a.dx2,a.dx3,a.dx4,a.dx5) 
                left outer join sex s on s.code=p.sex 
                where a.dchdate between "'. $startdate.'" AND "'. $enddate.'"
                AND i1.code = "O364"
                AND i.code in ("O244")
                group by a.an 
                ORDER BY a.regdate  
        ');
 
        return view('report_all.report_hos_08',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'hos_a'         =>     $hos_a,             
        ]);
    }

    public function report_hos_09(Request $request)
    {
        $startdate   = $request->startdate;
        $enddate     = $request->enddate;        
        
        $hos_a = DB::connection('mysql2')->select('
                SELECT a.hn,a.an,concat(p.pname,p.fname," ",p.lname) as ptname,s.name as sexname,a.age_y,a.pdx,dx0,dx1,dx2,dx3,dx4,dx5,d.name as dctype
                from an_stat a 
                left outer join ipt t on t.an=a.an 
                left outer join dchstts d on d.dchstts=t.dchstts 
                left outer join patient p on p.hn=a.hn
                left outer join icd101 i1 on i1.code in (a.pdx,a.dx0,a.dx1,a.dx2,a.dx3,a.dx4,a.dx5) 
                left outer join sex s on s.code=p.sex 
                where a.dchdate between  "'. $startdate.'" AND "'. $enddate.'"
                AND i1.code = "O364"
                group by a.an 
                ORDER BY a.regdate  
        ');
 
        return view('report_all.report_hos_09',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'hos_a'         =>     $hos_a,             
        ]);
    }

    public function report_hos_10(Request $request)
    {
        $startdate   = $request->startdate;
        $enddate     = $request->enddate;        
        
        $hos_a = DB::connection('mysql2')->select('
                SELECT a.hn,a.an,concat(p.pname,p.fname," ",p.lname) as ptname,a.age_y,a.pdx,dx0,dx1,dx2,dx3,dx4,dx5,d.name
                from an_stat a 
                left outer join ipt t on t.an=a.an 
                left outer join dchstts d on d.dchstts=t.dchstts 
                left outer join patient p on p.hn=a.hn
                left outer join icd101 i on i.code in (a.pdx,a.dx0,a.dx1,a.dx2,a.dx3,a.dx4,a.dx5)
                where a.dchdate between "'. $startdate.'" AND "'. $enddate.'"
                AND (SELECT i.code = "O244")
                group by a.an  
        ');
 
        return view('report_all.report_hos_10',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'hos_a'         =>     $hos_a,             
        ]);
    }

    public function report_hos_11(Request $request)
    {
        $startdate   = $request->startdate;
        $enddate     = $request->enddate;        
        
        $hos_a = DB::connection('mysql2')->select('
                SELECT a.hn,a.an,concat(p.pname,p.fname," ",p.lname) as ptname,a.age_y,a.pdx,dx0,dx1,dx2,dx3,dx4,dx5,d.name
                from an_stat a 
                left outer join ipt t on t.an=a.an 
                left outer join dchstts d on d.dchstts=t.dchstts 
                left outer join patient p on p.hn=a.hn
                left outer join icd101 i on i.code in (a.pdx,a.dx0,a.dx1,a.dx2,a.dx3,a.dx4,a.dx5)
                left outer join icd101 i1 on i1.code in (a.dx0,a.dx1,a.dx2,a.dx3,a.dx4,a.dx5) 
                where a.dchdate between ""'. $startdate.'" AND "'. $enddate.'"
                AND (SELECT i.code BETWEEN "J120" and "J189" or i.code in ("J690"))
                and i1.code in ("U071","U072")
                AND a.age_y >= "15"
                group by a.an   
        ');
 
        return view('report_all.report_hos_11',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'hos_a'         =>     $hos_a,             
        ]);
    }

    public function report_hos_12(Request $request)
    {
        $startdate   = $request->startdate;
        $enddate     = $request->enddate;        
        
        $hos_a = DB::connection('mysql2')->select('
                SELECT a.hn,a.an,concat(p.pname,p.fname," ",p.lname) as ptname,a.age_y,a.pdx,dx0,dx1,dx2,dx3,dx4,dx5,d.name
                ,a.op0,a.op1,a.op2,a.op3,a.op4,a.op5,a.op6 
                 from an_stat a 
                 left outer join ipt t on t.an=a.an 
                 left outer join dchstts d on d.dchstts=t.dchstts 
                 left outer join patient p on p.hn=a.hn
                 left outer join icd101 i1 on i1.code in (a.pdx,a.dx0,a.dx1,a.dx2,a.dx3,a.dx4,a.dx5) 
                 left outer join icd9cm1 i on i.code in (a.op0,a.op1,a.op2,a.op3,a.op4,a.op5,a.op6) 
                 where a.dchdate between "'. $startdate.'" AND "'. $enddate.'"
                 AND (SELECT i1.code BETWEEN "U071" and "U072")
                 AND i.code in ("9604","9670","9671","9672")
                 AND a.age_y >= "15"
                 group by a.an    
        ');
 
        return view('report_all.report_hos_12',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'hos_a'         =>     $hos_a,             
        ]);
    }

    public function report_hos_13(Request $request)
    {
        $startdate   = $request->startdate;
        $enddate     = $request->enddate;        
        
        $hos_a = DB::connection('mysql2')->select('
                SELECT a.hn,a.an,concat(p.pname,p.fname," ",p.lname) as ptname,s.name as sexname,a.age_y,a.pdx,dx0,dx1,dx2,dx3,dx4,dx5,d.name as dctype
                from an_stat a 
                left outer join ipt t on t.an=a.an 
                left outer join dchstts d on d.dchstts=t.dchstts 
                left outer join patient p on p.hn=a.hn
                left outer join icd101 i1 on i1.code in (a.pdx,a.dx0,a.dx1,a.dx2,a.dx3,a.dx4,a.dx5) 
                left outer join sex s on s.code=p.sex 
                where a.dchdate between "'. $startdate.'" AND "'. $enddate.'"
                AND i1.code BETWEEN "P210" AND "P210"
                group by a.an 
                ORDER BY a.regdate    
        ');
 
        return view('report_all.report_hos_13',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'hos_a'         =>     $hos_a,             
        ]);
    }

    public function report_hos_14(Request $request)
    {
        $startdate   = $request->startdate;
        $enddate     = $request->enddate;        
        
        $hos_a = DB::connection('mysql2')->select('
                SELECT a.hn,a.an,b.an as lastan,b.dchdate as lastdate,a.regdate,a.age_y,concat(p.pname,p.fname," ",p.lname) as ptname,s.name as sexname,a.lastvisit,a.admdate 
                from an_stat a 
                left outer join an_stat b on a.hn=b.hn and a.pdx=b.pdx and a.an>b.an 
                left outer join ipt i on i.an=b.an 
                left outer join patient p on p.hn=a.hn
                left outer join icd101 i1 on i1.code in (a.pdx,a.dx0,a.dx1,a.dx2,a.dx3,a.dx4,a.dx5)  
                LEFT OUTER JOIN sex s on s.code=p.sex
                where a.dchdate between "'. $startdate.'" AND "'. $enddate.'"
                and i1.code BETWEEN "J440" AND "J449"
                and a.lastvisit <= 30
                and ((to_days(a.regdate))-(to_days(b.dchdate)))<=30
                and i.dchstts = 02 
                group by a.hn
        ');
 
        return view('report_all.report_hos_14',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'hos_a'         =>     $hos_a,             
        ]);
    }

    public function report_hos_15(Request $request)
    {
        $startdate   = $request->startdate;
        $enddate     = $request->enddate;        
        
        $hos_a = DB::connection('mysql2')->select('
                SELECT a.hn,a.an,concat(p.pname,p.fname," ",p.lname) as ptname,a.age_y,a.pdx,dx0,dx1,dx2,dx3,dx4,dx5,d.name
                from an_stat a 
                left outer join ipt t on t.an=a.an 
                left outer join dchstts d on d.dchstts=t.dchstts 
                left outer join patient p on p.hn=a.hn
                left outer join icd101 i1 on i1.code in (a.pdx,a.dx0,a.dx1,a.dx2,a.dx3,a.dx4,a.dx5) 
                where a.dchdate between "'. $startdate.'" AND "'. $enddate.'"
                AND (SELECT i1.code BETWEEN "O720" and "O723")
                AND (SELECT i1.code in ("R571") or i1.code in ("R578"))
                group by a.an 
        ');
 
        return view('report_all.report_hos_15',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'hos_a'         =>     $hos_a,             
        ]);
    }

    public function report_hos_16(Request $request)
    {
        $startdate   = $request->startdate;
        $enddate     = $request->enddate;        
        
        $hos_a = DB::connection('mysql2')->select('
                SELECT a.hn,a.an,concat(p.pname,p.fname," ",p.lname) as ptname,a.age_y,a.pdx,dx0,dx1,dx2,dx3,dx4,dx5,d.name
                ,a.op0,a.op1,a.op2,a.op3,a.op4,a.op5,a.op6 
                 from an_stat a 
                 left outer join ipt t on t.an=a.an 
                 left outer join dchstts d on d.dchstts=t.dchstts 
                 left outer join patient p on p.hn=a.hn
                 left outer join icd101 i1 on i1.code in (a.pdx,a.dx0,a.dx1,a.dx2,a.dx3,a.dx4,a.dx5) 
                 left outer join icd9cm1 i on i.code in (a.op0,a.op1,a.op2,a.op3,a.op4,a.op5,a.op6) 
                 where a.dchdate between "'. $startdate.'" AND "'. $enddate.'"
                 AND (SELECT i1.code BETWEEN "J120" and "J189" or i1.code in ("J690"))
                 AND i.code in ("9604","9670","9671","9672")
                 AND a.age_y >= "15"
                 group by a.an  
        ');
 
        return view('report_all.report_hos_16',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'hos_a'         =>     $hos_a,             
        ]);
    }

    public function report_hos_17(Request $request)
    {
        $startdate   = $request->startdate;
        $enddate     = $request->enddate;        
        
        $hos_a = DB::connection('mysql2')->select('
                SELECT  a.hn,a.an,concat(p.pname,p.fname," ",p.lname) as ptname,a.age_y,a.pdx,dx0,dx1,dx2,dx3,dx4,dx5,d.name
                ,a.op0,a.op1,a.op2,a.op3,a.op4,a.op5,a.op6 
                 from an_stat a 
                 left outer join ipt t on t.an=a.an 
                 left outer join dchstts d on d.dchstts=t.dchstts 
                 left outer join patient p on p.hn=a.hn
                 left outer join icd101 i1 on i1.code in (a.pdx,a.dx0,a.dx1,a.dx2,a.dx3,a.dx4,a.dx5) 
                 left outer join icd9cm1 i on i.code in (a.op0,a.op1,a.op2,a.op3,a.op4,a.op5,a.op6) 
                 where a.dchdate between "'. $startdate.'" AND "'. $enddate.'"  
                 AND (SELECT i1.code BETWEEN "J120" and "J189" or i1.code in ("J690"))
                 AND i.code in ("9604","9670","9671","9672")
                 AND a.age_y < "15"
                 group by a.an  
        ');
 
        return view('report_all.report_hos_17',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'hos_a'         =>     $hos_a,             
        ]);
    }

    public function report_hos_18(Request $request)
    {
        $startdate   = $request->startdate;
        $enddate     = $request->enddate;        
        
        $hos_a = DB::connection('mysql2')->select('
                SELECT a.hn,a.an,concat(p.pname,p.fname," ",p.lname) as ptname,a.age_y,a.pdx,dx0,dx1,dx2,dx3,dx4,dx5,d.name
                from an_stat a 
                left outer join ipt t on t.an=a.an 
                left outer join dchstts d on d.dchstts=t.dchstts 
                left outer join patient p on p.hn=a.hn
                left outer join icd101 i1 on i1.code in (a.pdx,a.dx0,a.dx1,a.dx2,a.dx3,a.dx4,a.dx5) 
                where a.dchdate between "'. $startdate.'" AND "'. $enddate.'"  
                AND (SELECT i1.code BETWEEN "O720" and "O723")
                group by a.an
        ');
 
        return view('report_all.report_hos_18',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'hos_a'         =>     $hos_a,             
        ]);
    }

    public function report_hos_19(Request $request)
    {
        $startdate   = $request->startdate;
        $enddate     = $request->enddate;        
        
        $hos_a = DB::connection('mysql2')->select('
                SELECT COUNT(ipt.an) as totIPDAN
                FROM ipt
                WHERE ipt.dchdate BETWEEN "'. $startdate.'" AND "'. $enddate.'" 
        ');
 
        return view('report_all.report_hos_19',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'hos_a'         =>     $hos_a,             
        ]);
    }

    public function report_hos_20(Request $request)
    {
        $startdate   = $request->startdate;
        $enddate     = $request->enddate;        
        
        $hos_a = DB::connection('mysql2')->select('
                SELECT op.hn,op.vstdate,concat(p.pname,p.fname," ",p.lname) as ptname,year(op.vstdate)-year(p.birthday) as age
                ,n.name as ctname,op.sum_price,d.name as doctor,op.icode
                 from opitemrece op 
                 left outer join patient p on p.hn=op.hn 
                 left outer join doctor d on d.code=op.doctor 
                 left outer join nondrugitems n on n.icode=op.icode 
                 where op.vstdate between "'. $startdate.'" AND "'. $enddate.'" 
                 and op.qty > "0" 
                 and op.sum_price <> "0" 
                 and op.icode between "3009139" and "3009198" 
                 and op.icode not in ("3009152","3009153","3009154") 
                 group by op.vn,op.hn,op.an 
                 order by op.vstdate 
        ');
 
        return view('report_all.report_hos_20',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'hos_a'         =>     $hos_a,             
        ]);
    }

    public function report_hos_21(Request $request)
    {
        $startdate   = $request->startdate;
        $enddate     = $request->enddate;        
        
        $hos_a = DB::connection('mysql2')->select('
                SELECT v.vn,v.hn,v.vstdate,concat(p.pname,p.fname," ",p.lname) as ptname,v.age_y,lo.lab_order_result
                from vn_stat v 
                left outer join patient p on p.hn=v.hn 
                left outer join lab_head lh on lh.vn=v.vn
                left outer join lab_order lo on lo.lab_order_number=lh.lab_order_number
                LEFT OUTER JOIN icd101 i on i.code in (v.pdx,v.dx0,v.dx1,v.dx2,v.dx3,v.dx4,v.dx5)
                LEFT OUTER JOIN icd9cm1 ii on ii.code in (v.op0,v.op1,v.op2,v.op3,v.op4,v.op5)
                where v.vstdate between "'. $startdate.'" AND "'. $enddate.'" 
                AND i.code = "N185"
                AND ii.code in ("3995","5498")
                and lo.lab_items_code = "1277" 
                and lo.lab_order_result < 6
                group by v.hn 
                order by v.vstdate
        ');
 
        return view('report_all.report_hos_21',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'hos_a'         =>     $hos_a,             
        ]);
    }

    public function report_hos_22(Request $request)
    {
        $startdate   = $request->startdate;
        $enddate     = $request->enddate;        
        
        $hos_a = DB::connection('mysql2')->select('
                SELECT v.vn,v.hn,v.vstdate,concat(p.pname,p.fname," ",p.lname) as ptname,v.age_y,lo.lab_order_result
                from vn_stat v 
                left outer join patient p on p.hn=v.hn 
                left outer join lab_head lh on lh.vn=v.vn
                left outer join lab_order lo on lo.lab_order_number=lh.lab_order_number
                LEFT OUTER JOIN icd101 i on i.code in (v.pdx,v.dx0,v.dx1,v.dx2,v.dx3,v.dx4,v.dx5)
                where v.vstdate between "'. $startdate.'" AND "'. $enddate.'"
                AND i.code = "N185"
                and lo.lab_items_code = "1277" 
                and lo.lab_order_result < 6
                group by v.hn 
                order by v.vstdate
        ');
 
        return view('report_all.report_hos_22',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'hos_a'         =>     $hos_a,             
        ]);
    }

    public function report_hos_23(Request $request)
    {
        $startdate   = $request->startdate;
        $enddate     = $request->enddate;        
        
        $hos_a = DB::connection('mysql2')->select('
                SELECT v.an,v.hn,v.dchdate,v.age_y,concat(pt.pname,pt.fname,"  ",pt.lname) as fullname,v.pdx,v.dx0,v.dx1,v.dx2,v.dx3,v.dx4,v.dx5,d.name as doctorname,w.name as wardname
                from an_stat v 
                left outer join patient pt on pt.hn=v.hn 
                left outer join doctor d on d.code=v.dx_doctor 
                left outer join icd101 i on i.code in (pdx,dx0,dx1,dx2,dx3,dx4,dx5) 
                LEFT OUTER JOIN ward w on w.ward=v.ward 
                where v.dchdate between "'. $startdate.'" AND "'. $enddate.'"
                and i.code between "I460" and "I469" 
                group by v.an 
                order by v.dchdate
        ');
 
        return view('report_all.report_hos_23',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'hos_a'         =>     $hos_a,             
        ]);
    }

    public function report_hos_24(Request $request)
    {
        $startdate   = $request->startdate;
        $enddate     = $request->enddate;        
        
        $hos_a = DB::connection('mysql2')->select('
                SELECT a.hn,a.an,concat(p.pname,p.fname," ",p.lname) as ptname,a.age_y,a.pdx,dx0,dx1,dx2,dx3,dx4,dx5,w.name as wardname,dr.name as dcdoctor
                from an_stat a 
                left outer join ipt t on t.an=a.an 
                left outer join dchstts d on d.dchstts=t.dchstts 
                left outer join patient p on p.hn=a.hn
                left outer join doctor dr on dr.code=t.dch_doctor
                left outer join icd101 i1 on i1.code in (a.pdx,a.dx0,a.dx1,a.dx2,a.dx3,a.dx4,a.dx5) 
                left outer join ward w on w.ward=a.ward
                where a.dchdate between "'. $startdate.'" AND "'. $enddate.'"
                AND (SELECT i1.code BETWEEN "M7260" AND "M7269" )
                group by a.an
        ');
 
        return view('report_all.report_hos_24',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'hos_a'         =>     $hos_a,             
        ]);
    }

    public function report_hos_25(Request $request)
    {
        $startdate   = $request->startdate;
        $enddate     = $request->enddate;        
        
        $hos_a = DB::connection('mysql2')->select('
                SELECT o.hn,a.an,concat(p.pname,p.fname," ",lname) as ptname,i.code,a.regdate,t.regtime,o.enter_date,o.enter_time 
                ,DATEDIFF(o.enter_date,t.regdate)as date
                from operation_list o
                LEFT OUTER JOIN operation_detail od on od.operation_id=o.operation_id 
                left outer join patient p on p.hn=o.hn 
                left outer join an_stat a on a.an=o.an 
                left outer join ipt t on t.an=o.an 
                left outer join icd101 i on i.code in (pdx,dx0,dx1,dx2,dx3,dx4,dx5)
                LEFT OUTER JOIN ward w on w.ward=a.ward 
                where o.request_date between "'. $startdate.'" AND "'. $enddate.'"
                and i.code between "m7260" and "m7269" 
                AND od.icdcode in ("8622","8628")
                and o.status_id="3"
                AND DATEDIFF(o.enter_date,t.regdate) <= 1
                AND DATEDIFF(o.enter_time,t.regtime) not like "-%"
                GROUP BY a.an
        ');
 
        return view('report_all.report_hos_25',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'hos_a'         =>     $hos_a,             
        ]);
    }

    public function report_hos_26(Request $request)
    {
        $startdate   = $request->startdate;
        $enddate     = $request->enddate;        
        
        $hos_a = DB::connection('mysql2')->select('
                SELECT e.vn,v.hn,pt.cid,e.vstdate,v.age_y,concat(pt.pname,pt.fname,"  ",pt.lname) as fullname,v.pdx,v.dx0,v.dx1,v.dx2,v.dx3,v.dx4,v.dx5,d.name as doctorname
                from er_regist e
                left outer join vn_stat v on v.vn=e.vn
                left outer join patient pt on pt.hn=v.hn 
                left outer join doctor d on d.code=v.dx_doctor 
                left outer join icd101 i on i.code in (pdx,dx0,dx1,dx2,dx3,dx4,dx5) 
                where e.vstdate between "'. $startdate.'" AND "'. $enddate.'"
                and i.code between "I460" and "I469"
                group by e.vn 
                order by e.vstdate
        ');
 
        return view('report_all.report_hos_26',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'hos_a'         =>     $hos_a,             
        ]);
    }

    public function report_hos_28(Request $request)
    {
        $startdate   = $request->startdate;
        $enddate     = $request->enddate;        
        
        $hos_a = DB::connection('mysql2')->select('
                SELECT a.hn,a.an,concat(p.pname,p.fname," ",p.lname) as ptname,a.age_y,b.dchdate as lastdate,a.regdate,a.lastvisit,a.dchdate,a.admdate,w.name as wardname
                from an_stat a 
                left outer join an_stat b on a.hn=b.hn and a.pdx=b.pdx and a.an>b.an 
                left outer join patient p on p.hn=a.hn
                left outer join ward w on w.ward=a.ward
                where a.dchdate between "'. $startdate.'" AND "'. $enddate.'"
                and a.pdx between "A00" and "Z999" 
                and a.lastvisit <= 28 
                and ((to_days(a.regdate))-(to_days(b.dchdate)))<=28 
                group by a.an
        ');
 
        return view('report_all.report_hos_28',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'hos_a'         =>     $hos_a,             
        ]);
    }

    public function report_hos_29(Request $request)
    {
        $startdate   = $request->startdate;
        $enddate     = $request->enddate;        
        
        $hos_a = DB::connection('mysql2')->select('
                SELECT i.an,i.hn,i.regdate,i.dchdate,concat(p.pname,p.fname," ",p.lname) as ptname,a.age_y
                ,a.admdate,a.pdx,c.name,d.name as doc,w.name as firstward,w1.name as wardname,ib.movetime,i.regtime
                ,DATEDIFF(ib.movedate,i.regdate) as datemove
                ,TIMEDIFF(ib.movetime,i.regtime) as timemove
                from ipt i 
                left outer join an_stat a on a.an=i.an 
                left outer join patient p on p.hn=i.hn 
                LEFT OUTER JOIN iptbedmove ib on ib.an=i.an
                left outer join icd101 c on c.code=a.pdx 
                LEFT OUTER JOIN ward w on w.ward=i.first_ward 
                LEFT OUTER JOIN ward w1 on w1.ward=a.ward
                left outer join doctor d on d.code=i.incharge_doctor 
                where i.regdate between "'. $startdate.'" AND "'. $enddate.'"
                and i.ward in ("08","14") 
                and i.first_ward not in ("08","14") 
                AND TIMEDIFF(ib.movetime,i.regtime) < "06:00:00"
                AND TIMEDIFF(ib.movetime,i.regtime) not LIKE "-%"
                AND DATEDIFF(ib.movedate,i.regdate) <= "0"
                group by i.an 
                order by i.regdate
        ');
 
        return view('report_all.report_hos_29',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'hos_a'         =>     $hos_a,             
        ]);
    }

    public function report_hos_30(Request $request)
    {
        $startdate   = $request->startdate;
        $enddate     = $request->enddate;        
        
        $hos_a = DB::connection('mysql2')->select('
                SELECT a.hn,a.an,concat(p.pname,p.fname," ",p.lname) as ptname,a.age_y,a.pdx,dx0,dx1,dx2,dx3,dx4,dx5,d.name 
                ,a.op0,a.op1,a.op2,a.op3,a.op4,a.op5,a.op6
                from an_stat a 
                left outer join ipt t on t.an=a.an 
                left outer join dchstts d on d.dchstts=t.dchstts 
                left outer join patient p on p.hn=a.hn
                left outer join icd101 i1 on i1.code in (a.pdx,a.dx0,a.dx1,a.dx2,a.dx3,a.dx4,a.dx5) 
                left outer join icd9cm1 i on i.code in (a.op0,a.op1,a.op2,a.op3,a.op4,a.op5,a.op6) 
                where a.dchdate between "'. $startdate.'" AND "'. $enddate.'"
                AND (SELECT i1.code BETWEEN "J120" AND "J189" OR i1.code in ("J690") OR i1.code in ("J981") )
                AND i.code in ("4440","4441","4442","5121","5122") 
                group by a.an 
        ');
 
        return view('report_all.report_hos_30',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'hos_a'         =>     $hos_a,             
        ]);
    }

    public function report_hos_31(Request $request)
    {
        $startdate   = $request->startdate;
        $enddate     = $request->enddate;        
        
        $hos_a = DB::connection('mysql2')->select('
                SELECT o.hn,o.enter_date,CONCAT(p.pname,p.fname," ",p.lname) as ptname,o.an,s.name,a.age_y
                from operation_list o 
                LEFT OUTER JOIN operation_detail od on od.operation_id=o.operation_id  
                LEFT OUTER JOIN operation_item oi on oi.operation_item_id=od.operation_item_id 
                LEFT OUTER JOIN an_stat a on a.an=o.an
                LEFT OUTER JOIN patient p on p.hn=o.hn
                LEFT OUTER JOIN sex s on s.code=p.sex
                where o.enter_date between "'. $startdate.'" AND "'. $enddate.'" 
                and o.operation_type_id = "1" 
                and o.status_id = "3"
                and oi.icd9 in ("4440","4441","4442","5121","5122")
                GROUP BY o.an 
        ');
 
        return view('report_all.report_hos_31',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'hos_a'         =>     $hos_a,             
        ]);
    }

    public function report_hos_32(Request $request)
    {
        $startdate   = $request->startdate;
        $enddate     = $request->enddate;        
        
        $hos_a = DB::connection('mysql2')->select('
                SELECT COUNT(ipt.hn) as totIPDHN
                FROM ipt
                WHERE ipt.dchdate BETWEEN "'. $startdate.'" AND "'. $enddate.'" 
        ');
 
        return view('report_all.report_hos_32',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'hos_a'         =>     $hos_a,             
        ]);
    }

    public function report_hos_33(Request $request)
    {
        $startdate   = $request->startdate;
        $enddate     = $request->enddate;        
        
        $hos_a = DB::connection('mysql2')->select('
                SELECT COUNT(DISTINCT a.an) as total
                FROM an_stat a 
                LEFT OUTER JOIN patient p on p.hn=a.hn 
                LEFT OUTER JOIN icd101 i on i.code in (a.pdx,a.dx0,a.dx1,a.dx2,a.dx3,a.dx4,a.dx5)
                LEFT OUTER JOIN sex s on s.code=p.sex
                WHERE a.dchdate BETWEEN  "'. $startdate.'" AND "'. $enddate.'"  
                AND (SELECT i.code  in ("K251","K252","K255","K256","K261","K262","K265"
                ,"K266","K271","K272","K275","K276","K281","K282","K285","K286") ) 
                ORDER BY a.dchdate 
        ');
 
        return view('report_all.report_hos_33',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'hos_a'         =>     $hos_a,             
        ]);
    }

    public function report_hos_34(Request $request)
    {
        $startdate   = $request->startdate;
        $enddate     = $request->enddate;        
        
        $hos_a = DB::connection('mysql2')->select('
                SELECT count(distinct v.hn) as total
                from ovst v 
                left outer join opdscreen o on o.vn=v.vn
                left outer join patient p on p.hn=v.hn 
                where v.vstdate between "'. $startdate.'" AND "'. $enddate.'"  
                and o.bmi> "25"
                AND p.chwpart = "36"
                AND p.amppart = "10" 
        ');
 
        return view('report_all.report_hos_34',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'hos_a'         =>     $hos_a,             
        ]);
    }
 
}
