<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\support\Facades\Hash;
use Illuminate\support\Facades\Validator;
use App\Models\User;
use App\Models\Acc_debtor;
use App\Models\Pttype_eclaim;
use App\Models\Account_listpercen;
use App\Models\Leave_month;
use App\Models\Acc_debtor_stamp;
use App\Models\Acc_debtor_sendmoney;
use App\Models\Pttype;
use App\Models\Pttype_acc;
use App\Models\Acc_stm_ti;
use App\Models\Acc_stm_ti_total;
use App\Models\Acc_opitemrece;
use App\Models\Acc_1102050101_202;
use App\Models\Acc_1102050101_217;
use App\Models\Acc_1102050101_2166;
use App\Models\Acc_stm_ucs;
use App\Models\Acc_1102050101_301;
use App\Models\Acc_1102050101_304;
use App\Models\Acc_1102050101_308;
use App\Models\Acc_1102050101_4011;
use App\Models\Acc_1102050101_3099;
use App\Models\Acc_1102050101_401;
use App\Models\Acc_1102050101_402;
use App\Models\Acc_1102050102_801;
use App\Models\Acc_1102050102_802;
use App\Models\Acc_1102050102_803;
use App\Models\Acc_1102050102_804;
use App\Models\Acc_1102050101_4022;
use App\Models\Acc_1102050102_602;
use App\Models\Acc_1102050102_603;
use App\Models\Acc_stm_prb;
use App\Models\Acc_stm_ti_totalhead;
use App\Models\Acc_stm_ti_excel;
use App\Models\Acc_stm_ofc;
use App\Models\acc_stm_ofcexcel;
use App\Models\Acc_stm_lgo;
use App\Models\Acc_stm_lgoexcel;
use App\Models\Check_sit_auto;
use App\Models\Acc_stm_ucs_excel;

use PDF;
use setasign\Fpdi\Fpdi;
use App\Models\Budget_year;
use Illuminate\Support\Facades\File;
use DataTables;
use Intervention\Image\ImageManagerStatic as Image;
use App\Mail\DissendeMail;
use Mail;
use Illuminate\Support\Facades\Storage;
use Auth;
use Http;
use SoapClient;
// use File;
// use SplFileObject;
use Arr;
// use Storage;
use GuzzleHttp\Client;

use App\Imports\ImportAcc_stm_ti;
use App\Imports\ImportAcc_stm_tiexcel_import;
use App\Imports\ImportAcc_stm_ofcexcel_import;
use App\Imports\ImportAcc_stm_lgoexcel_import;
use App\Models\Acc_1102050101_217_stam;
use App\Models\Acc_opitemrece_stm;

use SplFileObject;
use PHPExcel;
use PHPExcel_IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\IOFactory;

date_default_timezone_set("Asia/Bangkok");


class InstrumentController extends Controller
 { 
    
    public function ins_dashboard(Request $request)
    {  
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -5 months')); //ย้อนหลัง 5 เดือน
        $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี
        $yearnew = date('Y');
        $yearold = date('Y')-1;
        $start = (''.$yearold.'-10-01');
        $end = (''.$yearnew.'-09-30'); 

        if ($startdate != '') {
            $datashow = DB::connection('mysql2')->select('
                    SELECT v.vn,op.an,v.hn,pt.cid as cid
                    ,concat(pt.pname,pt.fname," ",pt.lname) as ptname,v.spclty,sp.name as spcltyname
                    ,i.ward,vp.pttype,o.main_dep,k.department,v.vstdate  
                    ,op.icode,n.name as insname,op.qty,op.unitprice,v.income,v.discount_money,v.rcpt_money
                    ,v.income-v.discount_money-v.rcpt_money as debit              
                    
                    from hos.ovst o
                    left join hos.vn_stat v on v.vn=o.vn
                    left join hos.patient pt on pt.hn=o.hn
                    LEFT JOIN hos.visit_pttype vp on vp.vn = v.vn
                    LEFT JOIN hos.pttype ptt on o.pttype=ptt.pttype 
                    LEFT JOIN hos.opitemrece op ON op.vn = o.vn
                    LEFT JOIN nondrugitems n ON n.icode = op.icode
                    LEFT JOIN spclty sp on sp.spclty = v.spclty
                    LEFT JOIN kskdepartment k ON k.depcode = o.main_dep
                    LEFT JOIN ipt i ON i.vn = v.vn
                    WHERE o.vstdate BETWEEN "'.$startdate.'" AND "'.$enddate.'"
                    AND n.nhso_adp_code IN("5701","5702","5703A","5703B") 
                    and (o.an="" or o.an is null)
                    GROUP BY v.vn
            ');
        } else {
            $datashow = DB::connection('mysql2')->select('
                    SELECT v.vn,op.an,v.hn,pt.cid as cid
                    ,concat(pt.pname,pt.fname," ",pt.lname) as ptname,v.spclty,sp.name as spcltyname
                    ,i.ward,vp.pttype,o.main_dep,k.department,v.vstdate  
                    ,op.icode,n.name as insname,op.qty,op.unitprice,v.income,v.discount_money,v.rcpt_money
                    ,v.income-v.discount_money-v.rcpt_money as debit              
                    
                    from hos.ovst o
                    left join hos.vn_stat v on v.vn=o.vn
                    left join hos.patient pt on pt.hn=o.hn
                    LEFT JOIN hos.visit_pttype vp on vp.vn = v.vn
                    LEFT JOIN hos.pttype ptt on o.pttype=ptt.pttype 
                    LEFT JOIN hos.opitemrece op ON op.vn = o.vn
                    LEFT JOIN nondrugitems n ON n.icode = op.icode
                    LEFT JOIN spclty sp on sp.spclty = v.spclty
                    LEFT JOIN kskdepartment k ON k.depcode = o.main_dep
                    LEFT JOIN ipt i ON i.vn = v.vn
                    WHERE o.vstdate BETWEEN "'.$start.'" AND "'.$end.'"
                    AND n.nhso_adp_code IN("5701","5702","5703A","5703B") 
                    and (o.an="" or o.an is null)
                    GROUP BY v.vn
            ');
        }
        
        $datadep = DB::connection('mysql2')->select('SELECT depcode,department FROM kskdepartment');
            

        return view('instrument.ins_dashboard',[
            'datashow'      =>  $datashow,
            'startdate'     =>  $startdate,
            'enddate'       =>  $enddate, 
            'datadep'       =>  $datadep, 
        ]);
    }
    public function ins_a(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $depcode = $request->depcode;
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -5 months')); //ย้อนหลัง 5 เดือน
        $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี
        $yearnew = date('Y');
        $yearold = date('Y')-1;
        $start = (''.$yearold.'-10-01');
        $end = (''.$yearnew.'-09-30'); 

        if ($startdate != '') {
            if ($depcode != '') {
                $datashow = DB::connection('mysql2')->select('
                        SELECT v.vn,op.an,v.hn,pt.cid as cid
                        ,concat(pt.pname,pt.fname," ",pt.lname) as ptname,v.spclty,sp.name as spcltyname
                        ,i.ward,vp.pttype,o.main_dep,k.department,v.vstdate  
                        ,op.icode,n.name as insname,op.qty,op.unitprice,v.income,v.discount_money,v.rcpt_money
                        ,v.income-v.discount_money-v.rcpt_money as debit              
                        
                        from hos.ovst o
                        left join hos.vn_stat v on v.vn=o.vn
                        left join hos.patient pt on pt.hn=o.hn
                        LEFT JOIN hos.visit_pttype vp on vp.vn = v.vn
                        LEFT JOIN hos.pttype ptt on o.pttype=ptt.pttype 
                        LEFT JOIN hos.opitemrece op ON op.vn = o.vn
                        LEFT JOIN nondrugitems n ON n.icode = op.icode
                        LEFT JOIN spclty sp on sp.spclty = v.spclty
                        LEFT JOIN kskdepartment k ON k.depcode = o.main_dep
                        LEFT JOIN ipt i ON i.vn = v.vn
                        WHERE o.vstdate BETWEEN "'.$startdate.'" AND "'.$enddate.'"
                        AND o.main_dep = "'.$depcode.'"
                        AND n.nhso_adp_code IN("5701","5702","5703","5703A","5703B")
                        and (o.an="" or o.an is null)
                        GROUP BY v.vn,op.icode
                ');
            } else {
                $datashow = DB::connection('mysql2')->select('
                        SELECT v.vn,op.an,v.hn,pt.cid as cid
                        ,concat(pt.pname,pt.fname," ",pt.lname) as ptname,v.spclty,sp.name as spcltyname
                        ,i.ward,vp.pttype,o.main_dep,k.department,v.vstdate  
                        ,op.icode,n.name as insname,op.qty,op.unitprice,v.income,v.discount_money,v.rcpt_money
                        ,v.income-v.discount_money-v.rcpt_money as debit             
                        
                        from hos.ovst o
                        left join hos.vn_stat v on v.vn=o.vn
                        left join hos.patient pt on pt.hn=o.hn
                        LEFT JOIN hos.visit_pttype vp on vp.vn = v.vn
                        LEFT JOIN hos.pttype ptt on o.pttype=ptt.pttype 
                        LEFT JOIN hos.opitemrece op ON op.vn = o.vn
                        LEFT JOIN nondrugitems n ON n.icode = op.icode
                        LEFT JOIN spclty sp on sp.spclty = v.spclty
                        LEFT JOIN kskdepartment k ON k.depcode = o.main_dep
                        LEFT JOIN ipt i ON i.vn = v.vn
                        WHERE o.vstdate BETWEEN "'.$startdate.'" AND "'.$enddate.'"                    
                        AND n.nhso_adp_code IN("5701","5702","5703","5703A","5703B") 
                        and (o.an="" or o.an is null)
                        GROUP BY v.vn,op.icode
                ');
            }
             
            
        } else {
            $datashow = DB::connection('mysql2')->select('
                    SELECT v.vn,op.an,v.hn,pt.cid as cid
                    ,concat(pt.pname,pt.fname," ",pt.lname) as ptname,v.spclty,sp.name as spcltyname
                    ,i.ward,vp.pttype,o.main_dep,k.department,v.vstdate  
                    ,op.icode,n.name as insname,op.qty,op.unitprice,v.income,v.discount_money,v.rcpt_money
                    ,v.income-v.discount_money-v.rcpt_money as debit              
                    
                    from hos.ovst o
                    left join hos.vn_stat v on v.vn=o.vn
                    left join hos.patient pt on pt.hn=o.hn
                    LEFT JOIN hos.visit_pttype vp on vp.vn = v.vn
                    LEFT JOIN hos.pttype ptt on o.pttype=ptt.pttype 
                    LEFT JOIN hos.opitemrece op ON op.vn = o.vn
                    LEFT JOIN nondrugitems n ON n.icode = op.icode
                    LEFT JOIN spclty sp on sp.spclty = v.spclty
                    LEFT JOIN kskdepartment k ON k.depcode = o.main_dep
                    LEFT JOIN ipt i ON i.vn = v.vn
                    WHERE o.vstdate BETWEEN "'.$start.'" AND "'.$end.'"
                    AND n.nhso_adp_code IN("5701","5702","5703","5703A","5703B") 
                    and (o.an="" or o.an is null)
                    GROUP BY v.vn,op.icode
            ');
        }
        $datadep = DB::connection('mysql2')->select('SELECT depcode,department FROM kskdepartment');
            
        return view('instrument.ins_a',[
            'datashow'      =>  $datashow,
            'startdate'     =>  $startdate,
            'enddate'       =>  $enddate, 
            'datadep'       =>  $datadep, 
            'depcode'       =>  $depcode
        ]);
    }
    public function ins_b(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $ward = $request->ward;
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -5 months')); //ย้อนหลัง 5 เดือน
        $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี
        $yearnew = date('Y');
        $yearold = date('Y')-1;
        $start = (''.$yearold.'-10-01');
        $end = (''.$yearnew.'-09-30'); 

        if ($startdate != '') {
            if ($ward != '') {
                $datashow = DB::connection('mysql2')->select('
                    SELECT v.vn,i.an,i.hn,pt.cid
                        ,concat(pt.pname,pt.fname," ",pt.lname) as ptname,ip.pttype,i.ipt_spclty,sp.name as spcltyname,i.ward,w.name as wname  
                        ,v.vstdate,i.dchdate,ip.pttype,op.icode,n.name as insname,op.qty,op.unitprice,a.income,a.rcpt_money
                        ,a.income-a.discount_money-a.rcpt_money as debit 
                        FROM ipt i 
                        LEFT JOIN an_stat a on a.an=i.an
                        LEFT JOIN ipt_pttype ip on ip.an = i.an
                        LEFT JOIN patient pt on pt.hn=a.hn
                        LEFT JOIN pttype ptt on ip.pttype = ptt.pttype
                        LEFT JOIN pttype_eclaim e on e.code=ptt.pttype_eclaim_id
                        LEFT JOIN opitemrece op ON op.an = i.an
                        LEFT JOIN nondrugitems n on n.icode=op.icode
                        LEFT JOIN vn_stat v on v.vn = i.vn
                        LEFT JOIN spclty sp on sp.spclty = i.ipt_spclty
                        LEFT JOIN ward w ON w.ward = i.ward 
                        WHERE i.dchdate BETWEEN "'.$startdate.'" AND "'.$enddate.'"
                        AND n.nhso_adp_code IN("5701","5702","5703","5703A","5703B") 
                        AND i.ward = "'.$ward.'"
                        GROUP BY i.an,op.icode
 
                ');
            } else {
                $datashow = DB::connection('mysql2')->select('
                    SELECT v.vn,i.an,i.hn,pt.cid
                        ,concat(pt.pname,pt.fname," ",pt.lname) as ptname,ip.pttype,i.ipt_spclty,sp.name as spcltyname,i.ward,w.name as wname  
                        ,v.vstdate,i.dchdate,ip.pttype,op.icode,n.name as insname,op.qty,op.unitprice,a.income,a.rcpt_money
                        ,a.income-a.discount_money-a.rcpt_money as debit 
                        FROM ipt i 
                        LEFT JOIN an_stat a on a.an=i.an
                        LEFT JOIN ipt_pttype ip on ip.an = i.an
                        LEFT JOIN patient pt on pt.hn=a.hn
                        LEFT JOIN pttype ptt on ip.pttype = ptt.pttype
                        LEFT JOIN pttype_eclaim e on e.code=ptt.pttype_eclaim_id
                        LEFT JOIN opitemrece op ON op.an = i.an
                        LEFT JOIN nondrugitems n on n.icode=op.icode
                        LEFT JOIN vn_stat v on v.vn = i.vn
                        LEFT JOIN spclty sp on sp.spclty = i.ipt_spclty
                        LEFT JOIN ward w ON w.ward = i.ward 
                        WHERE i.dchdate BETWEEN "'.$startdate.'" AND "'.$enddate.'"
                        AND n.nhso_adp_code IN("5701","5702","5703","5703A","5703B") 
                        GROUP BY i.an,op.icode
 
                ');
            }
             
            
        } else {
            $datashow = DB::connection('mysql2')->select('
                SELECT v.vn,i.an,i.hn,pt.cid
                        ,concat(pt.pname,pt.fname," ",pt.lname) as ptname,ip.pttype,i.ipt_spclty,sp.name as spcltyname,i.ward,w.name as wname  
                        ,v.vstdate,i.dchdate,ip.pttype,op.icode,n.name as insname,op.qty,op.unitprice,a.income,a.rcpt_money
                        ,a.income-a.discount_money-a.rcpt_money as debit 
                        FROM ipt i 
                        LEFT JOIN an_stat a on a.an=i.an
                        LEFT JOIN ipt_pttype ip on ip.an = i.an
                        LEFT JOIN patient pt on pt.hn=a.hn
                        LEFT JOIN pttype ptt on ip.pttype = ptt.pttype
                        LEFT JOIN pttype_eclaim e on e.code=ptt.pttype_eclaim_id
                        LEFT JOIN opitemrece op ON op.an = i.an
                        LEFT JOIN nondrugitems n on n.icode=op.icode
                        LEFT JOIN vn_stat v on v.vn = i.vn
                        LEFT JOIN spclty sp on sp.spclty = i.ipt_spclty
                        LEFT JOIN ward w ON w.ward = i.ward 
                        WHERE i.dchdate BETWEEN "'.$start.'" AND "'.$end.'"
                        AND n.nhso_adp_code IN("5701","5702","5703","5703A","5703B") 
                        GROUP BY i.an,op.icode
 
            ');
        }
        $dataward = DB::connection('mysql2')->select('SELECT ward,name FROM ward');
            
        return view('instrument.ins_b',[
            'datashow'      =>  $datashow,
            'startdate'     =>  $startdate,
            'enddate'       =>  $enddate, 
            'ward'       =>  $ward, 
            'dataward'      =>  $dataward
        ]);
    }
    
}