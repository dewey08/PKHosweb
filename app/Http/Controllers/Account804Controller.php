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


class Account804Controller extends Controller
 {
    // *************************** 804 ********************************************    
   
    public function account_804_dash(Request $request)
    {
        //  $datenow = date('Y-m-d');
        //  $startdate = $request->startdate;
        //  $enddate = $request->enddate;
        //  $dabudget_year = DB::table('budget_year')->where('active','=',true)->first();
        // $date_start = $dabudget_year->date_begin;
        // $date_end   = $dabudget_year->date_end;

        //  $leave_month_year = DB::table('leave_month')->orderBy('MONTH_ID', 'ASC')->get();
 
        //  $y = date('Y') + 543; 
        //  $yearnew = date('Y');
        //  $yearnew = date('Y')+1;
        //  $yearold = date('Y')-1;
        // $start = (''.$yearold.'-10-01');
        // $end = (''.$yearnew.'-09-30'); 
 
        //  if ($startdate == '') {
        //      $datashow = DB::select('
        //              SELECT month(a.dchdate) as months,year(a.dchdate) as year,l.MONTH_NAME
        //              ,count(distinct a.hn) as hn
        //              ,count(distinct a.vn) as vn
        //              ,count(distinct a.an) as an
        //              ,sum(a.income) as income
        //              ,sum(a.paid_money) as paid_money
        //              ,sum(a.income)-sum(a.discount_money)-sum(a.rcpt_money) as total
 
        //              FROM acc_debtor a
        //              left outer join leave_month l on l.MONTH_ID = month(a.dchdate)
        //              WHERE a.dchdate between "'.$date_start.'" and "'.$date_end.'"
        //              and account_code="1102050102.804"
 
        //              group by month(a.dchdate) order by a.dchdate desc limit 3;
        //      ');
        //      // and stamp = "N"
        //  } else {
        //      $datashow = DB::select('
        //              SELECT month(a.dchdate) as months,year(a.dchdate) as year,l.MONTH_NAME
        //              ,count(distinct a.hn) as hn
        //              ,count(distinct a.vn) as vn
        //              ,count(distinct a.an) as an
        //              ,sum(a.income) as income
        //              ,sum(a.paid_money) as paid_money
        //              ,sum(a.income)-sum(a.discount_money)-sum(a.rcpt_money) as total
 
        //              FROM acc_debtor a
        //              left outer join leave_month l on l.MONTH_ID = month(a.dchdate)
        //              WHERE a.dchdate between "'.$startdate.'" and "'.$enddate.'"
        //              and account_code="1102050102.804"
 
                     
        //      ');
        //  }
        $budget_year   = $request->budget_year;
            
        $datenow       = date("Y-m-d");
        $y             = date('Y') + 543;
        $dabudget_year = DB::table('budget_year')->where('active','=',true)->get(); 
        $leave_month_year = DB::table('leave_month')->orderBy('MONTH_ID', 'ASC')->get();
        $date = date('Y-m-d'); 
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -5 months')); //ย้อนหลัง 5 เดือน
        $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี
        
        $months_now = date('m');
        $year_now = date('Y'); 
        //    dd($budget_year);
        if ($budget_year == '') {  
            $yearnew = date('Y');
            $year_old = date('Y')-1;
            $months_old  = ('10');
            $startdate = (''.$year_old.'-10-01');
            $enddate = (''.$yearnew.'-09-30');
            $datashow = DB::select(' 
                    SELECT MONTH(a.dchdate) as months,YEAR(a.dchdate) as years
                    ,count(DISTINCT a.an) as total_an,l.MONTH_NAME
                    ,sum(a.debit_total) as tung_looknee  
                    FROM acc_debtor a 
                    LEFT OUTER JOIN leave_month l on l.MONTH_ID = month(a.dchdate)
                    WHERE a.dchdate BETWEEN "'.$startdate.'" AND "'.$enddate.'"
                    AND a.account_code ="1102050102.804"
                    GROUP BY months ORDER BY a.dchdate DESC
            ');    
        } else {
            $bg           = DB::table('budget_year')->where('leave_year_id','=',$budget_year)->first();
            $startdate    = $bg->date_begin;
            $enddate      = $bg->date_end; 
            $datashow = DB::select(' 
                    SELECT MONTH(a.dchdate) as months,YEAR(a.dchdate) as years
                    ,count(DISTINCT a.an) as total_an,l.MONTH_NAME
                    ,sum(a.debit_total) as tung_looknee  
                    FROM acc_debtor a 
                    LEFT OUTER JOIN leave_month l on l.MONTH_ID = month(a.dchdate)
                    WHERE a.dchdate BETWEEN "'.$startdate.'" AND "'.$enddate.'"
                    AND a.account_code ="1102050102.804"
                    GROUP BY months ORDER BY a.dchdate DESC 
            ');  
        }
        
             return view('account_804.account_804_dash',[
                'enddate'          =>  $enddate, 
                'datashow'         =>  $datashow,
                'dabudget_year'    =>  $dabudget_year,
                'budget_year'      =>  $budget_year,
                'y'                =>  $y,
             ]);
    }
    public function account_804_pull(Request $request)
    {
         $datenow = date('Y-m-d');
         $months = date('m');
         $year = date('Y');
         // dd($year);
         $startdate = $request->startdate;
         $enddate = $request->enddate;
         if ($startdate == '') {
             // $acc_debtor = Acc_debtor::where('stamp','=','N')->whereBetween('dchdate', [$datenow, $datenow])->get();
             $acc_debtor = DB::select('
                 SELECT a.* from acc_debtor a 
                 WHERE account_code="1102050102.804"
                 AND stamp = "N" AND a.debit_total > 0
                 group by an
                 order by vstdate desc; 
             '); 
         } else {
             $acc_debtor = DB::select('
                 SELECT a.*
                 from acc_debtor a 
                 WHERE a.account_code="1102050102.804" and a.dchdate BETWEEN "' . $startdate . '" AND "' . $enddate . '"
                 AND a.stamp = "N" AND a.debit_total > 0
                 group by a.an
                 order by a.dchdate desc; 
             '); 
         }  
         return view('account_804.account_804_pull',[
             'startdate'     =>     $startdate,
             'enddate'       =>     $enddate,
             'acc_debtor'    =>     $acc_debtor,
         ]);
    }
    public function account_804_pulldata(Request $request)
    {
         $datenow = date('Y-m-d');
         $startdate = $request->datepicker;
         $enddate = $request->datepicker2;
            $acc_debtor = DB::connection('mysql2')->select('
                SELECT i.vn,a.an,a.hn,pt.cid,concat(pt.pname,pt.fname," ",pt.lname) ptname
                    ,a.regdate,a.dchdate,v.vstdate,op.income as income_group
                    ,ipt.pttype,ipt.pttype_number,ipt.max_debt_amount,i.rw,i.adjrw,i.adjrw*9000 as total_adjrw_income 
                    ,pt.hcode,o.vsttime
                    ,"19" as acc_code
                    ,"1102050102.804" as account_code
                    ,"เบิกจ่ายตรง อปท.รูปแบบพิเศษ (กทม)" as account_name
                    ,a.income,a.uc_money,a.discount_money,a.paid_money,a.rcpt_money
                    ,a.rcpno_list as rcpno
                    ,a.income-a.discount_money-a.rcpt_money as debit
                    ,if(op.icode IN ("3010058"),sum_price,0) as fokliad
                    ,sum(if(op.income="02",sum_price,0)) as debit_instument
                    ,sum(if(op.icode IN("1560016","1540073","1530005","1540048","1620015","1600012","1600015"),sum_price,0)) as debit_drug
                    ,sum(if(op.icode IN("3001412","3001417"),sum_price,0)) as debit_toa
                    ,sum(if(op.icode IN("3010829","3011068","3010864","3010861","3010862","3010863","3011069","3011012","3011070"),sum_price,0)) as debit_refer
                    ,ptt.max_debt_money
                    from ipt i
                    LEFT JOIN ovst o on o.an = i.an
                    left join an_stat a on a.an=i.an
                    left join patient pt on pt.hn=o.hn
                    LEFT JOIN pttype ptt on o.pttype=ptt.pttype
                    LEFT JOIN pttype_eclaim e on e.code=ptt.pttype_eclaim_id
                    LEFT JOIN ipt_pttype ipt ON ipt.an = a.an
                    LEFT JOIN opitemrece op ON op.an = i.an
                    LEFT JOIN drugitems d on d.icode=op.icode
                    LEFT JOIN hos.vn_stat v on v.vn = i.vn
                    WHERE a.dchdate BETWEEN "' . $startdate . '" AND "' . $enddate . '" 
                    AND ipt.pttype IN(SELECT pttype FROM pkbackoffice.acc_setpang_type WHERE pang ="1102050102.804" AND opdipd ="IPD")
                    GROUP BY i.an
                
            ');
    
            foreach ($acc_debtor as $key => $value) {
                        $check = Acc_debtor::where('an', $value->an)->where('account_code','1102050102.804')->whereBetween('dchdate', [$startdate, $enddate])->count();
                        if ($check == 0) {
                            Acc_debtor::insert([
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
                                'account_name'       => $value->account_name,
                                // 'income_group'       => $value->income_group,
                                'income'             => $value->income,
                                'uc_money'           => $value->uc_money,
                                'discount_money'     => $value->discount_money,
                                'paid_money'         => $value->paid_money,
                                'rcpt_money'         => $value->rcpt_money,
                                'debit'              => $value->debit,
                                'debit_drug'         => $value->debit_drug,
                                'debit_instument'    => $value->debit_instument,
                                'debit_toa'          => $value->debit_toa,
                                'debit_refer'        => $value->debit_refer,
                                'debit_total'        => $value->debit,
                                'max_debt_amount'    => $value->max_debt_money,
                                'rw'                 => $value->rw,
                                'adjrw'              => $value->adjrw,
                                'total_adjrw_income' => $value->total_adjrw_income,
                                'acc_debtor_userid'  => Auth::user()->id
                            ]);
                        }
            } 
             return response()->json([
 
                 'status'    => '200'
             ]);
    }    
    public function account_804_stam(Request $request)
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
              $check = acc_1102050102_804::where('an', $value->an)->count(); 
                 if ($check > 0) {
                 # code...
                 } else {
                     acc_1102050102_804::insert([
                             'vn'                => $value->vn,
                             'hn'                => $value->hn,
                             'an'                => $value->an,
                             'cid'               => $value->cid,
                             'ptname'            => $value->ptname,
                             'vstdate'           => $value->vstdate,
                             'regdate'           => $value->regdate,
                             'dchdate'           => $value->dchdate,
                             'pttype'            => $value->pttype,
                             'pttype_nhso'       => $value->pttype_spsch,
                             'acc_code'          => $value->acc_code,
                             'account_code'      => $value->account_code,
                             'income'            => $value->income, 
                             'uc_money'          => $value->uc_money,
                             'discount_money'    => $value->discount_money,
                             'rcpt_money'        => $value->rcpt_money,
                             'debit'             => $value->debit,
                             'debit_drug'        => $value->debit_drug,
                             'debit_instument'   => $value->debit_instument,
                             'debit_refer'       => $value->debit_refer,
                             'debit_toa'         => $value->debit_toa,
                             'debit_total'       => $value->debit_total,
                             'max_debt_amount'   => $value->max_debt_amount,
                             'rw'                => $value->rw,
                             'adjrw'             => $value->adjrw,
                             'total_adjrw_income'=> $value->total_adjrw_income,
                             'acc_debtor_userid' => $value->acc_debtor_userid
                     ]);
                 }
 
         }
         return response()->json([
             'status'    => '200'
         ]);
    }
    public function account_804_detail(Request $request,$months,$year)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $data['users'] = User::get();

        $data = DB::select('
            SELECT U1.an,U1.vn,U1.hn,U1.cid,U1.ptname,U1.vstdate,U1.dchdate,U1.pttype,U1.debit_total
                from acc_1102050102_804 U1
                WHERE month(U1.dchdate) = "'.$months.'" AND year(U1.dchdate) = "'.$year.'" 
                GROUP BY U1.an
        ');
     
        return view('account_804.account_804_detail', $data, [ 
            'data'          =>     $data,
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate
        ]);
    }
    public function account_804_search (Request $request)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $date = date('Y-m-d'); 
        $new_day = date('Y-m-d', strtotime($date . ' -5 day')); //ย้อนหลัง 1 วัน
        $data['users'] = User::get();
        if ($startdate =='') {
           $datashow = DB::select(' 
           SELECT U1.*,U2.claim_true_af,U2.STMdoc 
           from acc_1102050102_804 U1
           LEFT JOIN acc_stm_lgo U2 ON U2.an_e = U1.an
               WHERE dchdate BETWEEN "'.$new_day.'" AND  "'.$date.'" 
               group by U1.an 
           ');
        } else {
           $datashow = DB::select(' 
           SELECT U1.*,U2.claim_true_af,U2.STMdoc 
           from acc_1102050102_804 U1
           LEFT JOIN acc_stm_lgo U2 ON U2.an_e = U1.an
               WHERE dchdate BETWEEN "'.$startdate.'" AND  "'.$enddate.'"  
               group by U1.an
           ');
        } 
        return view('account_804.account_804_search ', $data, [
            'startdate'     => $startdate,
            'enddate'       => $enddate,
            'datashow'      => $datashow,
            'startdate'     => $startdate,
            'enddate'       => $enddate
        ]);
    }
    public function account_804_stm(Request $request,$months,$year)
    {
        $datenow = date('Y-m-d');        
        $data['users'] = User::get();

        $datashow = DB::select('
            SELECT U1.an,U1.vn,U1.hn,U1.cid,U1.ptname,U1.vstdate,U1.dchdate,U1.pttype,U1.debit_total,U2.pricereq_all,U2.STMdoc 
                from acc_1102050102_804 U1
                LEFT JOIN acc_stm_ofc U2 ON U2.cid = U1.cid AND U2.vstdate = U1.vstdate  
                WHERE month(U1.dchdate) = "'.$months.'" AND year(U1.dchdate) = "'.$year.'" 
                AND U2.pricereq_all is not null 
                group by U1.an
        ');
       
        return view('account_804.account_804_stm', $data, [ 
            'datashow'      =>     $datashow,
            'months'        =>     $months,
            'year'          =>     $year
        ]);
    }
    public function account_804_stmnull(Request $request,$months,$year)
    {
        $datenow = date('Y-m-d');        
        $data['users'] = User::get();

        $datashow = DB::select('
            SELECT U1.an,U1.vn,U1.hn,U1.cid,U1.ptname,U1.vstdate,U1.dchdate,U1.pttype,U1.debit_total,U2.pricereq_all,U2.STMdoc 
                from acc_1102050102_804 U1
                LEFT JOIN acc_stm_ofc U2 ON U2.cid = U1.cid AND U2.vstdate = U1.vstdate  
                WHERE month(U1.dchdate) = "'.$months.'" AND year(U1.dchdate) = "'.$year.'" 
                AND U2.pricereq_all is null 
                group by U1.an
        ');
       
        return view('account_804.account_804_stmnull', $data, [ 
            'datashow'      =>     $datashow,
            'months'        =>     $months,
            'year'          =>     $year
        ]);
    }
    public function account_804_detail_date(Request $request,$startdate,$enddate)
    { 

        $data = DB::select('
            SELECT U1.an,U1.vn,U1.hn,U1.cid,U1.ptname,U1.vstdate,U1.dchdate,U1.pttype,U1.debit_total
                from acc_1102050102_804 U1
                WHERE dchdate BETWEEN "'.$startdate.'" AND "'.$enddate.'" 
                GROUP BY U1.an
        ');
     
        return view('account_804.account_804_detail_date',[ 
            'data'          =>     $data,
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate
        ]);
    }
    public function account_804_stm_date(Request $request,$startdate,$enddate)
    {
        $datenow = date('Y-m-d');        
        $data['users'] = User::get();

        $datashow = DB::select('
            SELECT U1.an,U1.vn,U1.hn,U1.cid,U1.ptname,U1.vstdate,U1.dchdate,U1.pttype,U1.debit_total,U2.pricereq_all,U2.STMdoc 
                from acc_1102050102_804 U1
                LEFT JOIN acc_stm_ofc U2 ON U2.cid = U1.cid AND U2.vstdate = U1.vstdate  
                WHERE U1.dchdate BETWEEN "'.$startdate.'" AND "'.$enddate.'" 
                AND U2.pricereq_all is not null 
                group by U1.an
        ');
       
        return view('account_804.account_804_stm_date', $data, [ 
            'datashow'         =>     $datashow,
            'startdate'        =>     $startdate,
            'enddate'          =>     $enddate
        ]);
    }
    public function account_804_stmnull_date(Request $request,$startdate,$enddate)
    {
        $datenow = date('Y-m-d');        
        $data['users'] = User::get();

        $datashow = DB::select('
            SELECT U1.an,U1.vn,U1.hn,U1.cid,U1.ptname,U1.vstdate,U1.dchdate,U1.pttype,U1.debit_total,U2.pricereq_all,U2.STMdoc 
                from acc_1102050102_804 U1
                LEFT JOIN acc_stm_ofc U2 ON U2.cid = U1.cid AND U2.vstdate = U1.vstdate  
                WHERE U1.dchdate BETWEEN "'.$startdate.'" AND "'.$enddate.'" 
                AND U2.pricereq_all is null 
                group by U1.an
        ');
       
        return view('account_804.account_804_stmnull_date', $data, [ 
            'datashow'         =>     $datashow,
            'startdate'        =>     $startdate,
            'enddate'          =>     $enddate
        ]);
    }
    public function account_804_destroy(Request $request)
    {
        $id = $request->ids; 
        $data = Acc_debtor::whereIn('acc_debtor_id',explode(",",$id))->get();
            Acc_debtor::whereIn('acc_debtor_id',explode(",",$id))->delete();
                  
        return response()->json([
            'status'    => '200'
        ]);
    }

    public function account_804_checksit(Request $request)
    {
        $datestart = $request->datestart;
        $dateend = $request->dateend;
        $date = date('Y-m-d');
        
        $data_sitss = DB::connection('mysql')->select('SELECT vn,an,cid,vstdate,dchdate FROM acc_debtor WHERE account_code="1102050102.804" AND subinscl IS NULL GROUP BY an');
        // $data_sitss = DB::connection('mysql')->select('SELECT vn,an,cid,vstdate,dchdate FROM acc_debtor WHERE account_code="1102050102.804" AND stamp = "N" GROUP BY an');
        $token_data = DB::connection('mysql10')->select('SELECT * FROM nhso_token ORDER BY update_datetime desc limit 1');
        foreach ($token_data as $key => $value) { 
            $cid_    = $value->cid;
            $token_  = $value->token;
        }
        foreach ($data_sitss as $key => $item) {
            $pids = $item->cid;
            $vn   = $item->vn; 
            $an   = $item->an; 
                
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
                          
                            Acc_debtor::where('an', $an)
                            ->update([
                                'status'         => 'จำหน่าย/เสียชีวิต',
                                'maininscl'      => @$maininscl,
                                'pttype_spsch'   => @$subinscl,
                                'hmain'          => @$hmain,
                                'subinscl'       => @$subinscl, 
                            ]);
                            
                        }elseif(@$maininscl !="" || @$subinscl !=""){
                           Acc_debtor::where('an', $an)
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
    
   
 

 }