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
use App\Models\Acc_1102050101_203;
use App\Models\Acc_1102050101_307;

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


class Account203Controller extends Controller
 {     
    public function account_203_dash(Request $request)
    { 
        $startdate = $request->startdate;
        $enddate = $request->enddate; 
        $dabudget_year = DB::table('budget_year')->where('active','=',true)->first();
        $leave_month_year = DB::table('leave_month')->orderBy('MONTH_ID', 'ASC')->get();
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -5 months')); //ย้อนหลัง 5 เดือน
        $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี
        $yearnew = date('Y')+1;
        $yearold = date('Y')-1;
        $start = (''.$yearold.'-10-01');
        $end = (''.$yearnew.'-09-30');  
        if ($startdate == '') {
            $datashow = DB::select('
                    SELECT month(a.vstdate) as months,year(a.vstdate) as year,l.MONTH_NAME
                    ,count(distinct a.hn) as hn ,count(distinct a.vn) as vn ,count(distinct a.an) as an
                    ,sum(a.income) as income ,sum(a.paid_money) as paid_money
                    ,sum(a.income)-sum(a.discount_money)-sum(a.rcpt_money) as total ,sum(a.debit) as debit
                    FROM acc_debtor a
                    left outer join leave_month l on l.MONTH_ID = month(a.vstdate)
                    WHERE a.vstdate between "'.$start.'" and "'.$end.'"
                    and account_code="1102050101.203"
                    group by month(a.vstdate)                     
                    order by a.vstdate desc limit 9;
            ');  
        } else {
            $datashow = DB::select('
                    SELECT month(a.vstdate) as months,year(a.vstdate) as year,l.MONTH_NAME
                    ,count(distinct a.hn) as hn ,count(distinct a.vn) as vn
                    ,count(distinct a.an) as an ,sum(a.income) as income ,sum(a.paid_money) as paid_money
                    ,sum(a.income)-sum(a.discount_money)-sum(a.rcpt_money) as total ,sum(a.debit) as debit
                    FROM acc_debtor a
                    left outer join leave_month l on l.MONTH_ID = month(a.vstdate)
                    WHERE a.vstdate between "'.$startdate.'" and "'.$enddate.'"
                    and account_code="1102050101.203"                    
                    order by a.vstdate desc;
            ');
        }
        return view('account_203.account_203_dash',[
            'startdate'         =>  $startdate,
            'enddate'           =>  $enddate, 
            'leave_month_year'  =>  $leave_month_year, 
            'datashow'          =>  $datashow,
        ]);
    }
    public function account_203_pull(Request $request)
    {
        $datenow = date('Y-m-d');
        $months = date('m');
        $year = date('Y'); 
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        if ($startdate == '') { 
            $acc_debtor = DB::select('
                SELECT * from acc_debtor a 
                WHERE a.account_code="1102050101.203"
                AND a.stamp = "N" AND a.debit_total > 0
                group by a.vn
                order by a.vstdate desc; 
            '); 
        } else { 
        }
        return view('account_203.account_203_pull',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'acc_debtor'      =>     $acc_debtor,
        ]);
    }
    public function account_203_pull_m(Request $request,$months,$year)
    { 
        $startdate = $request->startdate;
        $enddate = $request->enddate;
  
            $acc_debtor = DB::select('
                SELECT a.*,c.subinscl from acc_debtor a
                left join checksit_hos c on c.vn = a.vn
                WHERE a.account_code="1102050101.203"
                AND a.stamp = "N" AND month(a.vstdate) = "'.$months.'" AND year(a.vstdate) = "'.$year.'"
                order by a.vstdate desc;

            '); 

        return view('account_203.account_203_pull_m',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'acc_debtor'    =>     $acc_debtor,
        ]);
    }
    public function account_203_checksit(Request $request)
    {
        $datestart = $request->datestart;
        $dateend = $request->dateend;
        $date = date('Y-m-d');
        
        $data_sitss = DB::connection('mysql')->select('SELECT vn,an,cid,vstdate,dchdate FROM acc_debtor WHERE account_code="1102050101.203" AND stamp = "N" GROUP BY vn');
       //  AND subinscl IS NULL
           //  LIMIT 30
        // WHERE vstdate = CURDATE()
        // BETWEEN "2024-02-03" AND "2024-02-15"
        // $token_data = DB::connection('mysql')->select('SELECT cid,token FROM ssop_token');
        $token_data = DB::connection('mysql10')->select('SELECT * FROM nhso_token ORDER BY update_datetime desc limit 1');
        foreach ($token_data as $key => $value) { 
            $cid_    = $value->cid;
            $token_  = $value->token;
        }
        foreach ($data_sitss as $key => $item) {
            $pids = $item->cid;
            $vn   = $item->vn; 
            $an   = $item->an; 
                // $token_data = DB::connection('mysql10')->select('SELECT cid,token FROM hos.nhso_token where token <> ""');
                // foreach ($token_data as $key => $value) { 
                    $client = new SoapClient("http://ucws.nhso.go.th/ucwstokenp1/UCWSTokenP1?wsdl",
                        array("uri" => 'http://ucws.nhso.go.th/ucwstokenp1/UCWSTokenP1?xsd=1',"trace" => 1,"exceptions" => 0,"cache_wsdl" => 0)
                        );
                        $params = array(
                            'sequence' => array(
                                "user_person_id"   => "$cid_",
                                "smctoken"         => "$token_",
                                // "user_person_id" => "$value->cid",
                                // "smctoken"       => "$value->token",
                                "person_id"        => "$pids"
                        )
                    );
                    $contents = $client->__soapCall('searchCurrentByPID',$params);
                    foreach ($contents as $v) {
                        @$status = $v->status ;
                        @$maininscl = $v->maininscl;
                        @$startdate = $v->startdate;
                        @$hmain = $v->hmain ;
                        @$subinscl = $v->subinscl ;
                        @$person_id_nhso = $v->person_id;

                        @$hmain_op = $v->hmain_op;  //"10978"
                        @$hmain_op_name = $v->hmain_op_name;  //"รพ.ภูเขียวเฉลิมพระเกียรติ"
                        @$hsub = $v->hsub;    //"04047"
                        @$hsub_name = $v->hsub_name;   //"รพ.สต.แดงสว่าง"
                        @$subinscl_name = $v->subinscl_name ; //"ช่วงอายุ 12-59 ปี"

                        IF(@$maininscl == "" || @$maininscl == null || @$status == "003" ){ #ถ้าเป็นค่าว่างไม่ต้อง insert
                            $date = date("Y-m-d");
                          
                            Acc_debtor::where('vn', $vn)
                            ->update([
                                'status'         => 'จำหน่าย/เสียชีวิต',
                                'maininscl'      => @$maininscl,
                                'pttype_spsch'   => @$subinscl,
                                'hmain'          => @$hmain,
                                'subinscl'       => @$subinscl, 
                            ]);
                            
                        }elseif(@$maininscl !="" || @$subinscl !=""){
                           Acc_debtor::where('vn', $vn)
                           ->update([
                               'status'         => @$status,
                               'maininscl'      => @$maininscl,
                               'pttype_spsch'   => @$subinscl,
                               'hmain'          => @$hmain,
                               'subinscl'       => @$subinscl,
                           
                           ]); 
                                    
                        }

                    }
           
        }

        return response()->json([

           'status'    => '200'
       ]);

    }
    public function account_203_pulldata(Request $request)
    {
        $datenow = date('Y-m-d');
        $datetimenow = date('Y-m-d H:i:s');
        
        $startdate = $request->datepicker;
        $enddate = $request->datepicker2; 
            $acc_debtor = DB::connection('mysql2')->select(' 
                    SELECT * FROM
                    (
                        SELECT ot.an,v.hn,v.vn,v.cid,v.vstdate,concat(p.pname,p.fname," ",p.lname) as ptname,v.pttype,d.cc,h.hospcode,ro.icd10 as referin_no,h.name as hospmain
                        ,"07" as acc_code,"1102050101.203" as account_code,"UC นอก CUP ในจังหวัด" as account_name,v.pdx,v.dx0
                        ,v.income,v.uc_money ,v.discount_money,v.rcpt_money,v.paid_money  
                        ,ov.name as active_status 

                        ,CASE WHEN (SELECT SUM(sum_price) sum_price FROM opitemrece WHERE icode = "3009147" AND vn = v.vn) THEN "1200" 
                        ELSE "0.00" 
                        END as debit_without
                        ,CASE WHEN (SELECT SUM(sum_price) sum_price FROM opitemrece WHERE icode = "3009148" AND vn = v.vn) THEN "1200" 
                        ELSE "0.00" 
                        END as debit_with
                        ,CASE WHEN (SELECT SUM(sum_price) sum_price FROM opitemrece WHERE icode = "3010860" AND vn = v.vn) THEN "2500" 
                        ELSE "0.00" 
                        END as debit_upper
                        ,CASE WHEN (SELECT SUM(sum_price) sum_price FROM opitemrece WHERE icode = "3009187" AND vn = v.vn) THEN "2500" 
                        ELSE "0.00" 
                        END as debit_lower
                        ,CASE WHEN (SELECT SUM(sum_price) sum_price FROM opitemrece WHERE icode = "3009143" AND vn = v.vn) THEN "1000" 
                        ELSE "0.00" 
                        END as debit_multiphase
                        ,CASE WHEN (SELECT SUM(sum_price) sum_price FROM opitemrece WHERE icode = "3011265" AND vn = v.vn) THEN "1100" 
                        ELSE "0.00" 
                        END as debit_drug100
                        ,CASE WHEN (SELECT SUM(sum_price) sum_price FROM opitemrece WHERE icode = "3011266" AND vn = v.vn) THEN "1100" 
                        ELSE "0.00" 
                        END as debit_drug150
                        ,CASE WHEN (SELECT SUM(sum_price) sum_price FROM opitemrece WHERE icode IN("3009178","3009148") AND vn = v.vn) THEN "2500" 
                        ELSE "0.00" 
                        END as ct_cwith_bwith

                        ,CASE WHEN (SELECT SUM(sum_price) sum_price FROM opitemrece WHERE icode IN("3001180","3002625","3002626","3002627","3010136") AND vn = v.vn) THEN SUM(sum_price)
                        ELSE "0.00" 
                        END as ct_cxr
                        
                        ,(SELECT SUM(rcptamt) sumprice FROM incoth WHERE income <> "08" AND vn = v.vn) AS price_noct121212
                        ,(
                            SELECT SUM(ot.sum_price) FROM opitemrece ot
                            LEFT JOIN xray_items xr ON xr.icode = ot.icode
                            WHERE ot.vn =r.vn AND ot.income ="08" AND xr.xray_items_group ="1"
                        ) as price_xray
                        
                        ,case
                        when v.uc_money < 1000 then v.uc_money
                        else "1000"
                        end as toklong
                        from vn_stat v
                      
                        left outer join patient p on p.hn = v.hn
                        left outer join pttype pt on pt.pttype =v.pttype 
                        left outer join icd101 oo on oo.code IN(v.pdx,v.dx0,v.dx1,v.dx2,v.dx3,v.dx4,v.dx5 )
                        left outer join opdscreen d on d.vn = v.vn
                        left outer join hospcode h on h.hospcode = v.hospmain 
                        left outer join referin ro on ro.vn = v.vn 
                        left outer join opitemrece om on om.vn = v.vn  
                        LEFT OUTER JOIN ovst ot on ot.vn = v.vn
                        LEFT OUTER JOIN ovstost ov on ov.ovstost = ot.ovstost
                        LEFT OUTER JOIN xray_report x on x.vn = v.vn 
			            LEFT OUTER JOIN xray_items xi on xi.xray_items_code = x.xray_items_code 
                        where v.vstdate BETWEEN "' . $startdate . '" AND "' . $enddate . '"
                        and (ot.an is null OR ot.an ="") AND v.uc_money <> 0 AND p.nationality = "99"   
                        and v.pttype IN (SELECT pttype FROM pkbackoffice.acc_setpang_type WHERE pang ="1102050101.203" AND opdipd ="OPD")
                        and (v.pdx not like "c%" and v.pdx not like "b24%" and v.pdx not like "n185%" )                        
                        and (oo.code  BETWEEN "E110" and "E149" or oo.code  BETWEEN "I10" and "I150" or oo.code  BETWEEN "J440" and "J449")
                        group by v.vn
                
                        UNION
                
                        SELECT ot.an,v.hn,v.vn,v.cid,v.vstdate,concat(p.pname,p.fname," ",p.lname) as ptname,v.pttype,d.cc,h.hospcode,ro.icd10 as referin_no,h.name as hospmain
                        ,"07" as acc_code,"1102050101.203" as account_code,"UC นอก CUP ในจังหวัด" as account_name,v.pdx,v.dx0
                        ,v.income,v.uc_money ,v.discount_money,v.rcpt_money,v.paid_money  
                        ,ov.name as active_status 
                        
                        ,CASE WHEN (SELECT SUM(sum_price) sum_price FROM opitemrece WHERE icode = "3009147" AND vn = v.vn) THEN "1200" 
                        ELSE "0.00" 
                        END as debit_without
                        
                        ,CASE WHEN (SELECT SUM(sum_price) sum_price FROM opitemrece WHERE icode = "3009148" AND vn = v.vn) THEN "1200" 
                        ELSE "0.00" 
                        END as debit_with
                        
                        ,CASE WHEN (SELECT SUM(sum_price) sum_price FROM opitemrece WHERE icode = "3010860" AND vn = v.vn) THEN "2500" 
                        ELSE "0.00" 
                        END as debit_upper
                        
                        ,CASE WHEN (SELECT SUM(sum_price) sum_price FROM opitemrece WHERE icode = "3009187" AND vn = v.vn) THEN "2500" 
                        ELSE "0.00" 
                        END as debit_lower
                       
                        ,CASE WHEN (SELECT SUM(sum_price) sum_price FROM opitemrece WHERE icode = "3009143" AND vn = v.vn) THEN "1000" 
                        ELSE "0.00" 
                        END as debit_multiphase
                        
                        ,CASE WHEN (SELECT SUM(sum_price) sum_price FROM opitemrece WHERE icode = "3011265" AND vn = v.vn) THEN "1100" 
                        ELSE "0.00" 
                        END as debit_drug100
                       
                        ,CASE WHEN (SELECT SUM(sum_price) sum_price FROM opitemrece WHERE icode = "3011266" AND vn = v.vn) THEN "1100" 
                        ELSE "0.00" 
                        END as debit_drug150
                        
                        ,CASE WHEN (SELECT SUM(sum_price) sum_price FROM opitemrece WHERE icode IN("3009178","3009148") AND vn = v.vn) THEN "2500" 
                        ELSE "0.00" 
                        END as ct_cwith_bwith

                        ,CASE WHEN (SELECT SUM(sum_price) sum_price FROM opitemrece WHERE icode IN("3001180","3002625","3002626","3002627","3010136") AND vn = v.vn) THEN SUM(sum_price)
                        ELSE "0.00" 
                        END as ct_cxr
                        
                        ,(SELECT SUM(rcptamt) sumprice FROM incoth WHERE income <> "08" AND vn = v.vn) AS price_noct121212
                        ,(
                            SELECT SUM(ot.sum_price) FROM opitemrece ot
                            LEFT JOIN xray_items xr ON xr.icode = ot.icode
                            WHERE ot.vn =r.vn AND ot.income ="08" AND xr.xray_items_group ="1"
                        ) as price_xray

                        ,case
                        when v.uc_money < 700 then v.uc_money
                        else "700"
                        end as toklong
                        from vn_stat v
                      
                        left outer join patient p on p.hn = v.hn
                        left outer join pttype pt on pt.pttype =v.pttype 
                        left outer join ovstdiag oo on oo.vn = v.vn
                        left outer join opdscreen d on d.vn = v.vn
                        left outer join hospcode h on h.hospcode = v.hospmain 
                        left outer join referin ro on ro.vn = v.vn 
                        left outer join opitemrece om on om.vn = v.vn 
                        LEFT OUTER JOIN ovst ot on ot.vn = v.vn
                        LEFT OUTER JOIN ovstost ov on ov.ovstost = ot.ovstost
                        LEFT OUTER JOIN xray_report x on x.vn = v.vn 
			            LEFT OUTER JOIN xray_items xi on xi.xray_items_code = x.xray_items_code 
                        where v.vstdate BETWEEN "' . $startdate . '" AND "' . $enddate . '"
                        and (ot.an is null OR ot.an ="") AND v.uc_money <> 0  AND p.nationality = "99"  
                        and v.pttype IN (SELECT pttype FROM pkbackoffice.acc_setpang_type WHERE pang ="1102050101.203" AND opdipd ="OPD")
                        and (v.pdx not like "c%" and v.pdx not like "b24%" and v.pdx not like "n185%" )                        
                        AND v.pdx NOT BETWEEN "E110" AND "E149" AND v.pdx NOT BETWEEN "J440" AND "J449" AND v.pdx NOT BETWEEN "I10" AND "I159"
                        AND v.dx0 NOT BETWEEN "E110" AND "E149" AND v.dx0 NOT BETWEEN "J440" AND "J449" AND v.dx0 NOT BETWEEN "I10" AND "I159"
                        AND v.dx1 NOT BETWEEN "E110" AND "E149" AND v.dx1 NOT BETWEEN "J440" AND "J449" AND v.dx1 NOT BETWEEN "I10" AND "I159"
                        AND v.dx2 NOT BETWEEN "E110" AND "E149" AND v.dx2 NOT BETWEEN "J440" AND "J449" AND v.dx2 NOT BETWEEN "I10" AND "I159"
                        AND v.dx3 NOT BETWEEN "E110" AND "E149" AND v.dx3 NOT BETWEEN "J440" AND "J449" AND v.dx3 NOT BETWEEN "I10" AND "I159"
                        AND v.dx4 NOT BETWEEN "E110" AND "E149" AND v.dx4 NOT BETWEEN "J440" AND "J449" AND v.dx4 NOT BETWEEN "I10" AND "I159"
                        AND v.dx5 NOT BETWEEN "E110" AND "E149" AND v.dx5 NOT BETWEEN "J440" AND "J449" AND v.dx5 NOT BETWEEN "I10" AND "I159"
                        group by v.vn
                    ) As Refer 
            ');         
            // ,(SELECT SUM(sum_price) sum_price FROM opitemrece WHERE icode NOT IN("3009147","3009148","3010860","3009187","3009143","3011265","3011266") AND vn = v.vn) as pricenoct           
            foreach ($acc_debtor as $key => $value) { 
                // if ($value->an == '') { 
                            $check = Acc_debtor::where('vn', $value->vn)->where('account_code','1102050101.203')->count();

                            if ($check > 0 ) { 
                            } else {
                                if ($value->debit_without > 0 || $value->debit_with > 0 || $value->debit_upper > 0 || $value->debit_lower > 0 || $value->debit_multiphase > 0 || $value->debit_drug100 > 0 || $value->debit_drug150 > 0 || $value->ct_cwith_bwith > 0) {
                                   
                                    $data_ = ($value->price_xray)- $value->rcpt_money;
                                    if ($data_ > '700') {
                                        $price_noct_ = '700';
                                    } else {
                                        $price_noct_ = $data_;
                                    }                                    
                                    Acc_debtor::insert([
                                        'hn'                 => $value->hn,
                                        'an'                 => $value->an,
                                        'vn'                 => $value->vn,
                                        'cid'                => $value->cid,
                                        'ptname'             => $value->ptname,
                                        'pttype'             => $value->pttype,
                                        'vstdate'            => $value->vstdate,
                                        // 'dchdate'            => $value->dchdate,
                                        'acc_code'           => $value->acc_code,
                                        'account_code'       => $value->account_code,
                                        'account_name'       => $value->account_name, 
                                        'hospcode'           => $value->hospcode,
                                        'income'             => $value->income,
                                        'uc_money'           => $value->uc_money,
                                        'discount_money'     => $value->discount_money,
                                        'paid_money'         => $value->paid_money,
                                        'rcpt_money'         => $value->rcpt_money,
                                        'debit'              => $value->uc_money, 
                                        // 'debit_total'        => $value->price_xray, 
                                        'debit_total'        => $price_noct_, 
                                        'referin_no'         => $value->referin_no, 
                                        'pdx'                => $value->pdx, 
                                        'dx0'                => $value->dx0, 
                                        'cc'                 => $value->cc, 
                                        'ct_price'           => ($value->debit_without+$value->debit_with+$value->debit_upper+$value->debit_lower+$value->debit_multiphase+$value->debit_drug100+$value->debit_drug150+$value->ct_cwith_bwith), 
                                        'ct_sumprice'        => '100',  
                                        'sauntang'           => ($value->uc_money)-($value->debit_without+$value->debit_with+$value->debit_upper+$value->debit_lower+$value->debit_multiphase+$value->debit_drug100+$value->debit_drug150+$value->ct_cwith_bwith)-('100'), 
                                        'acc_debtor_userid'  => Auth::user()->id,
                                        'date_pull'          => $datetimenow,
                                        'active_status'      => $value->active_status,
                                        'referin_no'         => $value->referin_no,
                                    ]);

                                }else{
                                    // $data_ = $value->price_noct + $value->ct_cxr;
                                    // if ($data_ > '700') {
                                    //     $price_noct_ = '700';
                                    // } else {
                                    //     $price_noct_ = $data_;
                                    // }    

                                    Acc_debtor::insert([
                                        'hn'                 => $value->hn,
                                        'an'                 => $value->an,
                                        'vn'                 => $value->vn,
                                        'cid'                => $value->cid,
                                        'ptname'             => $value->ptname,
                                        'pttype'             => $value->pttype,
                                        'vstdate'            => $value->vstdate,
                                        // 'dchdate'            => $value->dchdate,
                                        'acc_code'           => $value->acc_code,
                                        'account_code'       => $value->account_code,
                                        'account_name'       => $value->account_name, 
                                        'hospcode'           => $value->hospcode,
                                        'income'             => $value->income,
                                        'uc_money'           => $value->uc_money,
                                        'discount_money'     => $value->discount_money,
                                        'paid_money'         => $value->paid_money,
                                        'rcpt_money'         => $value->rcpt_money,
                                        'debit'              => $value->uc_money, 
                                        'debit_total'        => $value->toklong, 
                                        'referin_no'         => $value->referin_no, 
                                        'pdx'                => $value->pdx, 
                                        'dx0'                => $value->dx0, 
                                        'cc'                 => $value->cc, 
                                        'ct_price'           => ($value->debit_without+$value->debit_with+$value->debit_upper+$value->debit_lower+$value->debit_multiphase+$value->debit_drug100+$value->debit_drug150+$value->ct_cwith_bwith), 
                                        'ct_sumprice'        => '100',  
                                        'sauntang'           => ($value->uc_money)-($value->debit_without+$value->debit_with+$value->debit_upper+$value->debit_lower+$value->debit_multiphase+$value->debit_drug100+$value->debit_drug150+$value->ct_cwith_bwith)-('100'), 
                                        'acc_debtor_userid'  => Auth::user()->id,
                                        'date_pull'          => $datetimenow,
                                        'active_status'      => $value->active_status,
                                        'referin_no'         => $value->referin_no,
                                    ]);
                                
                                }
                                
                            } 
                // } else {
                //     # code...
                // }               
                  
            }

            
            return response()->json([

                'status'    => '200'
            ]);
    }
    public function account_203_stam(Request $request)
    {
        $id = $request->ids;
        $iduser = Auth::user()->id;
        $data = Acc_debtor::whereIn('acc_debtor_id',explode(",",$id))->get();
            Acc_debtor::whereIn('acc_debtor_id',explode(",",$id))
                    ->update([
                        'stamp' => 'Y'
                    ]);
        foreach ($data as $key => $value) {
                $date = date('Y-m-d H:m:s');
             
                $check = Acc_1102050101_203::where('vn', $value->vn)->count();
                if ($check > 0) {
                # code...
                } else {
                    if ($value->ct_sumprice > 0) {
                        $ct_sumprice = 'C';
                    } else {
                        $ct_sumprice = 'R';
                    }                    
                    Acc_1102050101_203::insert([ 
                            'hn'                 => $value->hn,
                            'an'                 => $value->an,
                            'vn'                 => $value->vn,
                            'cid'                => $value->cid,
                            'ptname'             => $value->ptname,
                            'pttype'             => $value->pttype,
                            'vstdate'            => $value->vstdate,
                            'dchdate'            => $value->dchdate,
                            'acc_code'           => $value->acc_code,
                            'account_code'       => $value->account_code, 
                            'income'             => $value->income,
                            'uc_money'           => $value->uc_money,
                            'discount_money'     => $value->discount_money, 
                            'rcpt_money'         => $value->rcpt_money,
                            'debit'              => $value->debit, 
                            'debit_total'        => $value->debit_total, 
                            'hospcode'           => $value->hospcode, 
                            'cc'                 => $value->cc, 
                            'sauntang'           => $value->sauntang, 
                            'referin_no'         => $value->referin_no, 
                            'ct_price'           => $value->ct_price, 
                            'ct_sumprice'        => $value->ct_sumprice, 
                            'pdx'                => $value->pdx, 
                            'dx0'                => $value->dx0, 
                            'acc_debtor_userid'  => $iduser
                    ]);
                }

        }
        return response()->json([
            'status'    => '200'
        ]);
    }
    public function account_203_detail(Request $request,$months,$year)
    {
        $datenow = date('Y-m-d');
      
        $data['users'] = User::get();
 
        $data = DB::select('
                SELECT U1.ct_price,U1.uc_money 
                ,U1.vn,U1.an,U1.hn,U1.cid,U1.ptname,U1.vstdate,U1.pttype,U1.income,U1.rcpt_money,U1.hospcode,U1.debit_total,U1.nhso_docno,U1.nhso_ownright_pid,U1.recieve_true,U1.difference,U1.recieve_no,U1.recieve_date,U1.dchdate
                from acc_1102050101_203 U1             
                WHERE month(U1.vstdate) = "'.$months.'" AND year(U1.vstdate) = "'.$year.'"
               
        ');
  
        return view('account_203.account_203_detail', $data, [ 
            'data'       =>     $data,
            'months'     =>     $months,
            'year'       =>     $year
        ]);
    }
    public function account_203_hoscode(Request $request,$months,$year)
    { 
        $data['users'] = User::get(); 
        $datashow = DB::select('
                SELECT 
                    U1.hospcode,U2.name as hname,month(U1.vstdate) as months,year(U1.vstdate) as years,COUNT(DISTINCT U1.vn) as Cvn,SUM(U1.income) as S_income,SUM(U1.uc_money) as S_uc_money
                    ,SUM(U1.debit) as S_debit,SUM(U1.debit_total) as S_debit_total,SUM(U1.sauntang) as S_sauntang
                from acc_1102050101_203 U1    
                LEFT OUTER JOIN hospcode U2 ON U2.hospcode = U1.hospcode         
                WHERE month(U1.vstdate) = "'.$months.'" AND year(U1.vstdate) = "'.$year.'"
                GROUP BY U1.hospcode 
        ');
        $data['sumct_price'] = DB::table('acc_1102050101_203')->WhereMonth('vstdate',$months)->WhereYear('vstdate',$year)->sum('ct_price');
  
        return view('account_203.account_203_hoscode', $data, [ 
            'datashow'       => $datashow,
            'months'         => $months,
            'year'           => $year
        ]);
    }
    public function account_203_hoscode_date(Request $request,$startdate,$enddate)
    { 
        $data['users'] = User::get(); 
        $datashow = DB::select('
                SELECT 
                    U1.hospcode,U2.name as hname,month(U1.vstdate) as months,year(U1.vstdate) as years,COUNT(DISTINCT U1.vn) as Cvn,SUM(U1.income) as S_income,SUM(U1.uc_money) as S_uc_money
                    ,SUM(U1.debit) as S_debit,SUM(U1.debit_total) as S_debit_total,SUM(U1.sauntang) as S_sauntang
                from acc_1102050101_203 U1    
                LEFT OUTER JOIN hospcode U2 ON U2.hospcode = U1.hospcode         
                WHERE U1.vstdate BETWEEN "'.$startdate.'" AND "'.$enddate.'"
                GROUP BY U1.hospcode 
        ');
  
        return view('account_203.account_203_hoscode_date', $data, [ 
            'datashow'          => $datashow,
            'startdate'         => $startdate,
            'enddate'           => $enddate
        ]);
    }
    public function account_203_hcode_group_date(Request $request,$startdate,$enddate,$hospcode)
    { 
        $data['users'] = User::get(); 
        $datashow = DB::select('
                SELECT 
                U1.vn,U1.an,U1.hn,U1.cid,U1.ptname,U1.vstdate,U1.pttype,U1.income,U1.rcpt_money,U1.hospcode,U1.debit_total,U1.nhso_docno,U1.nhso_ownright_pid,U1.recieve_true,U1.difference,U1.recieve_no,U1.recieve_date,U1.dchdate
                from acc_1102050101_203 U1    
                LEFT OUTER JOIN hospcode U2 ON U2.hospcode = U1.hospcode         
                WHERE U1.vstdate BETWEEN "'.$startdate.'" AND "'.$enddate.'" AND U1.hospcode = "'.$hospcode.'"
                GROUP BY U1.hospcode 
        ');
  
        return view('account_203.account_203_hcode_group_date', $data, [ 
            'datashow'          => $datashow,
            'startdate'         => $startdate,
            'enddate'           => $enddate
        ]);
    }
    public function account_203_hcode_group(Request $request,$months,$year,$hcode)
    { 
        $data['users'] = User::get();
        $data_hos = DB::select('SELECT name as hname from hospcode WHERE hospcode= "'.$hcode.'"');
        $datashow = DB::select('
                SELECT 
                    U2.name as hname,
                    U1.vn,U1.an,U1.hn,U1.cid,U1.ptname,U1.vstdate,U1.pttype,U1.income,U1.rcpt_money,U1.hospcode,U1.debit_total,U1.nhso_docno,U1.nhso_ownright_pid,U1.recieve_true,U1.difference,U1.recieve_no,U1.recieve_date,U1.dchdate
                     
                from acc_1102050101_203 U1    
                LEFT OUTER JOIN hospcode U2 ON U2.hospcode = U1.hospcode         
                WHERE month(U1.vstdate) = "'.$months.'" AND year(U1.vstdate) = "'.$year.'" AND U1.hospcode = "'.$hcode.'"                
        ');
        foreach ($data_hos as $key => $value) {
            $datahos_name = $value->hname;
        }
  
        return view('account_203.account_203_hcode_group', $data, [ 
            'datashow'       => $datashow,
            'datahos_name'   => $datahos_name,
            'months'         => $months,
            'year'           => $year
        ]);
    }
    public function account_203_hcode_detail(Request $request,$months,$year,$hcode)
    { 
        $data['users'] = User::get();
 
        $datashow = DB::select('
                SELECT 
                    U2.name as hname,
                    U1.vn,U1.an,U1.hn,U1.cid,U1.ptname,U1.vstdate,U1.pttype,U1.income,U1.rcpt_money,U1.hospcode,U1.debit_total,U1.nhso_docno,U1.nhso_ownright_pid,U1.recieve_true,U1.difference,U1.recieve_no,U1.recieve_date,U1.dchdate
                     
                from acc_1102050101_203 U1    
                LEFT OUTER JOIN hospcode U2 ON U2.hospcode = U1.hospcode         
                WHERE month(U1.vstdate) = "'.$months.'" AND year(U1.vstdate) = "'.$year.'" AND U1.hospcode = "'.$hcode.'"
                
        ');
  
        return view('account_203.account_203_hcode_detail', $data, [ 
            'datashow'       => $datashow,
            'months'         => $months,
            'year'           => $year
        ]);
    }

    public function account_203_detail_date(Request $request,$startdate,$enddate)
    {
        $datenow = date('Y-m-d');      
        $data['users'] = User::get();
 
        $data = DB::select('
                SELECT 
                U1.ct_price,U1.uc_money,U1.vn,U1.an,U1.hn,U1.cid,U1.ptname,U1.vstdate,U1.pttype,U1.income,U1.rcpt_money,U1.hospcode,U1.debit_total,U1.nhso_docno,U1.nhso_ownright_pid,U1.recieve_true,U1.difference,U1.recieve_no,U1.recieve_date,U1.dchdate
                from acc_1102050101_203 U1             
                WHERE U1.vstdate BETWEEN "'.$startdate.'" AND  "'.$enddate.'"
                GROUP BY U1.vn 
        ');
  
        return view('account_203.account_203_detail_date', $data, [ 
            'data'          => $data,
            'startdate'     => $startdate,
            'enddate'       => $enddate
        ]);
    }
    public function account_203_form(Request $request)
    { 
        $startdate    = $request->startdate;
        $enddate      = $request->enddate;
        if ($startdate != '') { 
            $acc_debtor = DB::select(' 
                SELECT 
                U1.vn,U1.an,U1.hn,U1.cid,U1.ptname,U1.vstdate,U1.pttype,U1.income,U1.rcpt_money,U1.hospcode,U1.debit_total,U1.nhso_docno,U1.nhso_ownright_pid,U1.recieve_true,U1.difference,U1.recieve_no,U1.recieve_date,U1.dchdate
                ,U1.referin_no,U2.name as hospname,U1.pdx,U1.dx0,U1.sauntang
                from acc_1102050101_203 U1  
                left join hospcode U2 on U2.hospcode = U1.hospcode   
                WHERE U1.vstdate BETWEEN "'.$startdate.'" AND "'.$enddate.'"
                GROUP BY U1.vn 
            '); 
        } else { 
            $acc_debtor = DB::select(' 
                SELECT 
                U1.vn,U1.an,U1.hn,U1.cid,U1.ptname,U1.vstdate,U1.pttype,U1.income,U1.rcpt_money,U1.hospcode,U1.debit_total,U1.nhso_docno,U1.nhso_ownright_pid,U1.recieve_true,U1.difference,U1.recieve_no,U1.recieve_date,U1.dchdate
                ,U1.referin_no,U2.name as hospname,U1.pdx,U1.dx0,U1.sauntang
                from acc_1102050101_203 U1  
                left join hospcode U2 on U2.hospcode = U1.hospcode   
                WHERE U1.vstdate BETWEEN "'.$startdate.'" AND "'.$enddate.'"
                GROUP BY U1.vn 
            '); 
        }
        return view('account_203.account_203_form',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'acc_debtor'      =>     $acc_debtor,
        ]);
    }










    public function account_307_stm(Request $request,$months,$year)
    {
        $datenow = date('Y-m-d');
        // $startdate = $request->startdate;
        // $enddate = $request->enddate;
        // dd($id);
        $data['users'] = User::get();

        $data = DB::select('

        SELECT U1.vn,U1.an,U1.hn,U1.cid,U1.ptname,U1.vstdate,U1.pttype,U1.debit_total,U1.nhso_docno,U1.nhso_ownright_pid,U1.recieve_true,U1.difference,U1.recieve_no,U1.recieve_date,U1.dchdate
                from acc_1102050101_307 U1
             
                WHERE month(U1.vstdate) = "'.$months.'" AND year(U1.vstdate) = "'.$year.'"
                AND U1.recieve_true is not null
                GROUP BY U1.vn

                UNION

                SELECT U2.vn,U2.an,U2.hn,U2.cid,U2.ptname,U2.vstdate,U2.pttype,U2.debit_total,U2.nhso_docno,U2.nhso_ownright_pid,U2.recieve_true,U2.difference,U2.recieve_no,U2.recieve_date,U2.dchdate
                from acc_1102050101_307 U2
             
                WHERE month(U2.dchdate) = "'.$months.'" AND year(U2.dchdate) = "'.$year.'"
                AND U2.recieve_true is not null
                GROUP BY U2.an

           
        ');
        // WHERE month(U1.vstdate) = "'.$months.'" and year(U1.vstdate) = "'.$year.'"
        return view('account_307.account_307_stm', $data, [ 
            'data'       =>     $data,
            'months'     =>     $months,
            'year'       =>     $year
        ]);
    }

    public function account_307_sync(Request $request)
    {
        $vn = $request->vn;
        $sync = DB::connection('mysql3')->select('
                SELECT vn,nhso_docno 
                from visit_pttype
                WHERE vn = "' . $vn . '"  
            ');
            foreach ($sync as $key => $value) {
                if ($value->nhso_docno != '') {
                    // Acc_1102050101_307::where('vn','=',$value->vn)->update([
                    //     'nhso_docno' => $value->nhso_docno
                    // ]);
                    $update = Acc_1102050101_307::find($value->vn);
                    $update->nhso_docno = $value->nhso_docno;
                    $update->save();

                    return response()->json([
                        'status'    => '200'
                    ]);
                } else {
                    return response()->json([
                        'status'    => '100'
                    ]);
                } 
            }
            
        
        
    }

    public function account_307_syncall(Request $request)
    {
        $months = $request->months;
        $year = $request->year;
        $sync = DB::connection('mysql')->select('
                SELECT ac.acc_1102050101_307_id,o.an,v.vn,ac.vstdate,v.pttype,v.nhso_ownright_pid,v.nhso_docno 
                from hos.visit_pttype v
                LEFT JOIN hos.ovst o ON o.vn = v.vn
                LEFT JOIN pkbackoffice.acc_1102050101_307 ac ON ac.vn = v.vn                   
                WHERE month(o.vstdate) = "'.$months.'"  
                AND year(o.vstdate) = "'.$year.'"
                AND v.nhso_docno  <> ""
                AND ac.acc_1102050101_307_id <> ""
                GROUP BY v.vn

                UNION all
 
                SELECT ac.acc_1102050101_307_id,a.an,ac.vn,ac.vstdate,a.pttype,ip.nhso_ownright_pid,ip.nhso_docno 
                FROM hos.an_stat a
                LEFT JOIN hos.ipt_pttype ip ON ip.an = a.an
                LEFT JOIN pkbackoffice.acc_1102050101_307 ac ON ac.an = a.an
                WHERE month(a.dchdate) = "'.$months.'" 
                AND year(a.dchdate) = "'.$year.'"
                AND ip.nhso_ownright_pid  <> "" AND ip.nhso_docno  <> "" AND ac.acc_1102050101_307_id <> ""
                GROUP BY a.an
            ');
            foreach ($sync as $key => $value) {
               
                // if ($value->nhso_docno != '') {
                     
                    Acc_1102050101_307::where('vn',$value->vn) 
                        ->update([ 
                            'nhso_docno'           => $value->nhso_docno,
                            'nhso_ownright_pid'    => $value->nhso_ownright_pid 
                    ]);
                    // return response()->json([
                    //     'status'    => '200'
                    // ]);
                // } else {
                //     return response()->json([
                //         'status'    => '100'
                //     ]);
                // } 
            }
            return response()->json([
                'status'    => '200'
            ]);
        
        
    }

    public function account_307_detail_date(Request $request,$startdate,$enddate)
    { 
        $data['users'] = User::get();

        $data = DB::select('
            SELECT U1.vn,U1.an,U1.hn,U1.cid,U1.ptname,U1.vstdate,U1.pttype,U1.debit_total,U1.nhso_docno,U1.nhso_ownright_pid,U1.recieve_true,U1.difference,U1.recieve_no,U1.recieve_date,U1.dchdate
                from acc_1102050101_307 U1
             
                WHERE U1.vstdate BETWEEN "'.$startdate.'" AND "'.$enddate.'"
                GROUP BY U1.vn

                UNION

                SELECT U2.vn,U2.an,U2.hn,U2.cid,U2.ptname,U2.vstdate,U2.pttype,U2.debit_total,U2.nhso_docno,U2.nhso_ownright_pid,U2.recieve_true,U2.difference,U2.recieve_no,U2.recieve_date,U2.dchdate
                from acc_1102050101_307 U2
                
                WHERE U2.dchdate BETWEEN "'.$startdate.'" AND "'.$enddate.'"
                GROUP BY U2.an
        ');
        // SELECT U1.vn,U1.an,U1.hn,U1.cid,U1.ptname,U1.vstdate,U1.pttype,U1.debit_total,U1.nhso_docno,U1.nhso_ownright_pid,U1.recieve_true,U1.difference,U1.recieve_no,U1.recieve_date,U1.dchdate
        //         from acc_1102050101_307 U1
             
        //         WHERE month(U1.vstdate) = "'.$months.'" AND year(U1.vstdate) = "'.$year.'"
        //         GROUP BY U1.vn

        //         UNION

        //         SELECT U2.vn,U2.an,U2.hn,U2.cid,U2.ptname,U2.vstdate,U2.pttype,U2.debit_total,U2.nhso_docno,U2.nhso_ownright_pid,U2.recieve_true,U2.difference,U2.recieve_no,U2.recieve_date,U2.dchdate
        //         from acc_1102050101_307 U2
             
        //         WHERE month(U2.dchdate) = "'.$months.'" AND year(U2.dchdate) = "'.$year.'"
        //         GROUP BY U2.an

        // WHERE month(U1.vstdate) = "'.$months.'" and year(U1.vstdate) = "'.$year.'"
        return view('account_307.account_307_detail_date', $data, [ 
            'data'          =>     $data,
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate
        ]);
    }
    public function account_307_stm_date(Request $request,$startdate,$enddate)
    {
        $datenow = date('Y-m-d'); 
        $data['users'] = User::get();

        $data = DB::select('
        SELECT U1.vn,U1.an,U1.hn,U1.cid,U1.ptname,U1.vstdate,U1.pttype,U1.debit_total,U1.nhso_docno,U1.nhso_ownright_pid,U1.recieve_true,U1.difference,U1.recieve_no,U1.recieve_date,U1.dchdate
        from acc_1102050101_307 U1
     
        WHERE U1.vstdate BETWEEN "'.$startdate.'" AND "'.$enddate.'"
        AND U1.recieve_true is not null
        GROUP BY U1.vn

        UNION

        SELECT U2.vn,U2.an,U2.hn,U2.cid,U2.ptname,U2.vstdate,U2.pttype,U2.debit_total,U2.nhso_docno,U2.nhso_ownright_pid,U2.recieve_true,U2.difference,U2.recieve_no,U2.recieve_date,U2.dchdate
        from acc_1102050101_307 U2
        
        WHERE U2.dchdate BETWEEN "'.$startdate.'" AND "'.$enddate.'"
        AND U2.recieve_true is not null
        GROUP BY U2.an
 
        ');
        // WHERE month(U1.vstdate) = "'.$months.'" and year(U1.vstdate) = "'.$year.'"
        return view('account_307.account_307_stm_date', $data, [ 
            'data'          =>     $data,
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate
        ]);
    }
    public function account_203_destroy(Request $request)
    {
        $id = $request->ids; 
        $data = Acc_debtor::whereIn('acc_debtor_id',explode(",",$id))->get();
            Acc_debtor::whereIn('acc_debtor_id',explode(",",$id))->delete();
                  
        return response()->json([
            'status'    => '200'
        ]);
    }




 }