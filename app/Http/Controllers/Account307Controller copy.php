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
use App\Models\Acc_1102050101_302;
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


class Account307Controller extends Controller
 { 
    
    public function account_307_dash(Request $request)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $acc_trimart_id = $request->acc_trimart_id;

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
    
        // $data_trimart = DB::table('acc_trimart')->limit(3)->orderBy('acc_trimart_id','desc')->get();
        if ($acc_trimart_id == '') {
            $data_trimart = DB::table('acc_trimart')->limit(3)->orderBy('acc_trimart_id','desc')->get();
            $trimart = DB::table('acc_trimart')->orderBy('acc_trimart_id','desc')->get();
        } else {
            // $data_trimart = DB::table('acc_trimart')->whereBetween('dchdate', [$startdate, $enddate])->orderBy('acc_trimart_id','desc')->get();
            $data_trimart = DB::table('acc_trimart')->where('acc_trimart_id','=',$acc_trimart_id)->orderBy('acc_trimart_id','desc')->get();
            $trimart = DB::table('acc_trimart')->orderBy('acc_trimart_id','desc')->get();
        }
        if ($startdate == '') {
            $datashow = DB::select('
                    SELECT month(a.vstdate) as months,year(a.vstdate) as year,l.MONTH_NAME
                    ,count(distinct a.hn) as hn
                    ,count(distinct a.vn) as vn
                    ,count(distinct a.an) as an
                    ,sum(a.income) as income
                    ,sum(a.paid_money) as paid_money
                    ,sum(a.income)-sum(a.discount_money)-sum(a.rcpt_money) as total
                    ,sum(a.debit) as debit
                    FROM acc_debtor a
                    left outer join leave_month l on l.MONTH_ID = month(a.vstdate)
                    WHERE a.vstdate between "'.$start.'" and "'.$end.'"
                    and account_code="1102050101.307"
                    group by month(a.vstdate) 
                    
                    order by a.vstdate desc limit 6;
            '); 
            // 
            // order by month(a.vstdate),year(a.vstdate) desc limit 6;
        } else {
            $datashow = DB::select('
                    SELECT month(a.vstdate) as months,year(a.vstdate) as year,l.MONTH_NAME
                    ,count(distinct a.hn) as hn
                    ,count(distinct a.vn) as vn
                    ,count(distinct a.an) as an
                    ,sum(a.income) as income
                    ,sum(a.paid_money) as paid_money
                    ,sum(a.income)-sum(a.discount_money)-sum(a.rcpt_money) as total
                    ,sum(a.debit) as debit
                    FROM acc_debtor a
                    left outer join leave_month l on l.MONTH_ID = month(a.vstdate)
                    WHERE a.vstdate between "'.$startdate.'" and "'.$enddate.'"
                    and account_code="1102050101.307"
                    
                    order by a.vstdate desc;
            ');
        }
        return view('account_307.account_307_dash',[
            'startdate'        =>     $startdate,
            'enddate'          =>     $enddate,
            'trimart'          => $trimart,
            'leave_month_year' =>  $leave_month_year,
            'data_trimart'     =>  $data_trimart,
            'datashow'         =>  $datashow,
        ]);
    }
    public function account_307_pull(Request $request)
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
                SELECT a.*,c.subinscl from acc_debtor a
                left join checksit_hos c on c.vn = a.vn
                WHERE a.account_code="1102050101.307"
                AND a.stamp = "N"
                order by a.vstdate desc;

            ');
            // and month(a.dchdate) = "'.$months.'" and year(a.dchdate) = "'.$year.'"
        } else {
            // $acc_debtor = Acc_debtor::where('stamp','=','N')->whereBetween('dchdate', [$startdate, $enddate])->get();
        }

        return view('account_307.account_307_pull',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'acc_debtor'      =>     $acc_debtor,
        ]);
    }

    public function account_307_pulldata(Request $request)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->datepicker;
        $enddate = $request->datepicker2;
        // Acc_opitemrece::truncate();
            $acc_debtor = DB::connection('mysql2')->select(' 
                SELECT o.vn,o.an,o.hn,pt.cid,concat(pt.pname,pt.fname," ",pt.lname) ptname
                    ,o.vstdate,o.vsttime
                    ,v.hospmain,"" regdate,"" dchdate,op.income as income_group  
                    ,ptt.pttype_eclaim_id,v.pttype
                    ,"13" as acc_code,"1102050101.307" as account_code,"ประกันสังคม กองทุนทดแทน" as account_name
                    ,v.income,v.uc_money,v.discount_money,v.paid_money,v.rcpt_money 
                    ,v.income-v.discount_money-v.rcpt_money as debit
                    ,if(op.icode IN ("3010058"),sum_price,0) as fokliad
                    ,sum(if(op.income="02",sum_price,0)) as debit_instument
                    ,sum(if(op.icode IN("1560016","1540073","1530005","1540048","1620015","1600012","1600015"),sum_price,0)) as debit_drug
                    ,sum(if(op.icode IN ("3001412","3001417"),sum_price,0)) as debit_toa
                    ,sum(if(op.icode IN ("3010829","3010726 "),sum_price,0)) as debit_refer
                    ,ptt.max_debt_money
                    
                    ,CASE 
                    WHEN (vp.pttype ="ss" OR vp.pttype ="SS") AND v.income-v.discount_money-v.rcpt_money < "900" THEN v.income-v.discount_money-v.rcpt_money
                    WHEN (vp.pttype ="ss" OR vp.pttype ="SS") AND v.income-v.discount_money-v.rcpt_money > "900" THEN "900" 
                    WHEN vp.pttype <> "ss"  THEN v.income-v.discount_money-v.rcpt_money
                    ELSE v.income-v.discount_money-v.rcpt_money
                    END as looknee

                    from ovst o
                    LEFT OUTER JOIN vn_stat v on v.vn=o.vn
                    LEFT OUTER JOIN visit_pttype vp on vp.vn = v.vn
                    LEFT OUTER JOIN patient pt on pt.hn=o.hn
                    LEFT OUTER JOIN pttype ptt on o.pttype=ptt.pttype
                    LEFT OUTER JOIN pttype_eclaim e on e.code=ptt.pttype_eclaim_id
                    LEFT OUTER JOIN opitemrece op ON op.vn = o.vn
                    WHERE o.vstdate BETWEEN "' . $startdate . '" AND "' . $enddate . '"
                    AND vp.pttype IN(SELECT pttype FROM pkbackoffice.acc_setpang_type WHERE pang ="1102050101.307" AND opdipd ="OPD") 
                    AND v.income <> 0
                    and (o.an="" or o.an is null)
                    GROUP BY o.vn

                    UNION all

                    SELECT a.vn,a.an,a.hn,pt.cid,concat(pt.pname,pt.fname," ",pt.lname) ptname
                    ,o.vstdate,o.vsttime
                    ,v.hospmain,a.regdate,a.dchdate ,op.income as income_group
                    ,ptt.pttype_eclaim_id,a.pttype
                  
                    ,"13" as acc_code,"1102050101.307" as account_code,"ประกันสังคม กองทุนทดแทน" as account_name
                    ,a.income,a.uc_money,a.discount_money,a.paid_money,a.rcpt_money
                   
                    ,sum(if(op.icode ="3010058",sum_price,0)) as fokliad
                    ,sum(if(op.income="02",sum_price,0)) as debit_instument
                    ,sum(if(op.icode IN("1560016","1540073","1530005","1540048","1620015","1600012","1600015"),sum_price,0)) as debit_drug
                    ,sum(if(op.icode IN ("3001412","3001417"),sum_price,0)) as debit_toa
                    ,sum(if(op.icode IN("3010829","3011068","3010864","3010861","3010862","3010863","3011069","3011012","3011070"),sum_price,0)) as debit_refer
                    ,ipt.max_debt_amount as max_debt_money

                    ,a.income-a.rcpt_money-a.discount_money as debit
                    
                    ,CASE 
                    WHEN a.income-a.discount_money-a.rcpt_money < 50000 THEN a.income-a.discount_money-a.rcpt_money 
                    WHEN  ipt.pttype_number ="1" AND ipt.pttype IN ("35")  THEN ipt.max_debt_amount 
                    WHEN (ipt.pttype ="ss" OR ipt.pttype ="SS") AND a.income-a.rcpt_money-a.discount_money < "900" THEN a.income-a.rcpt_money-a.discount_money 
                    WHEN (ipt.pttype ="ss" OR ipt.pttype ="SS") AND a.income-a.rcpt_money-a.discount_money > "900" THEN "900"
                    WHEN ipt.pttype <> "ss" THEN a.income-a.rcpt_money-a.discount_money 
                    ELSE a.income-a.discount_money-a.rcpt_money  
                    END as looknee
 
                    from ipt ip
                    LEFT OUTER JOIN an_stat a ON ip.an = a.an
                    LEFT OUTER JOIN ovst o ON o.an = a.an
                    LEFT OUTER JOIN patient pt on pt.hn=a.hn
                    LEFT OUTER JOIN pttype ptt on a.pttype=ptt.pttype
                    LEFT OUTER JOIN pttype_eclaim ec on ec.code=ptt.pttype_eclaim_id
                    LEFT OUTER JOIN ipt_pttype ipt ON ipt.an = a.an
                    LEFT OUTER JOIN opitemrece op ON ip.an = op.an
                    LEFT OUTER JOIN vn_stat v on v.vn = a.vn
                    WHERE a.dchdate BETWEEN "' . $startdate . '" AND "' . $enddate . '"
                   
                    AND ipt.pttype IN(SELECT pttype FROM pkbackoffice.acc_setpang_type WHERE pang ="1102050101.307" AND opdipd ="IPD")
                    GROUP BY a.an; 
                    
            ');
                    // ,ptt.max_debt_money
                    // ,CASE 
                    //     WHEN (ipt.pttype ="ss" OR ipt.pttype ="SS") AND a.income-a.rcpt_money-a.discount_money < "900" THEN a.income-a.rcpt_money-a.discount_money 
                    //     WHEN (ipt.pttype ="ss" OR ipt.pttype ="SS") AND a.income-a.rcpt_money-a.discount_money > "900" THEN "900"
                    //     WHEN ipt.pttype <> "ss" THEN a.income-a.rcpt_money-a.discount_money 
                    //     ELSE a.income-a.rcpt_money-a.discount_money
                    // END as looknee

            // AND v.pttype IN("35","ss","06","C4","C5") 
            // AND a.pttype IN("35","06","C5")
            // AND v.hospmain = "10702"
            foreach ($acc_debtor as $key => $value) {
                    $check = Acc_debtor::where('vn', $value->vn)->where('account_code','1102050101.307')->count();
                    if ($value->pttype == 'SS') {
                        $pttype = 'ss';
                        // if ( $value->looknee < "900") {
                        //     $data_debit = $value->debit;
                        //  } else {
                        //      $data_debit = $value->looknee;
                        //  }
                    } else {
                        $pttype = $value->pttype;
                        // if ( $value->looknee < "900") {
                        //     $data_debit = $value->debit;
                        //  } else {
                        //      $data_debit = $value->looknee;
                        //  }
                    }
                    if ( $value->looknee < "900") {
                       $data_debit = $value->debit;
                    } else {
                        $data_debit = $value->looknee;
                    }
                    
                    
                    // ->where('account_code','1102050101.307')
                    if ($check == 0) {
                        Acc_debtor::insert([
                            'hn'                 => $value->hn,
                            'an'                 => $value->an,
                            'vn'                 => $value->vn,
                            'cid'                => $value->cid,
                            'ptname'             => $value->ptname,
                            'pttype'             => $pttype,
                            'vstdate'            => $value->vstdate,
                            'dchdate'            => $value->dchdate,
                            'acc_code'           => $value->acc_code,
                            'account_code'       => $value->account_code,
                            'account_name'       => $value->account_name,
                            'income_group'       => $value->income_group,
                            'income'             => $value->income,
                            'uc_money'           => $value->uc_money,
                            'discount_money'     => $value->discount_money,
                            'paid_money'         => $value->paid_money,
                            'rcpt_money'         => $value->rcpt_money,
                            'debit'              => $data_debit,
                            'debit_drug'         => $value->debit_drug,
                            'debit_instument'    => $value->debit_instument,
                            'debit_toa'          => $value->debit_toa,
                            'debit_refer'        => $value->debit_refer, 
                            'fokliad'            => $value->fokliad, 
                            'debit_total'        => $data_debit,
                            'max_debt_amount'    => $value->max_debt_money,
                            'acc_debtor_userid'  => Auth::user()->id
                        ]);
                    }
 
            }
            return response()->json([

                'status'    => '200'
            ]);
    }
    public function account_307_stam(Request $request)
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
             
                $check = Acc_1102050101_307::where('vn', $value->vn)->count();
                if ($check > 0) {
                # code...
                } else {
                    Acc_1102050101_307::insert([
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
                            'income_group'      => $value->income_group,
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
                            'acc_debtor_userid' => $iduser
                    ]);
                }

        }
        return response()->json([
            'status'    => '200'
        ]);
    }

    public function account_307_detail(Request $request,$months,$year)
    {
        $datenow = date('Y-m-d');
        // $startdate = $request->startdate;
        // $enddate = $request->enddate;
        // dd($id);
        $data['users'] = User::get();

        // $data = DB::select('
        //         SELECT U1.vn,U1.an,U1.hn,U1.cid,U1.ptname,U1.vstdate,U1.pttype,U1.debit_total,U1.nhso_docno,U1.nhso_ownright_pid,U1.recieve_true,U1.difference,U1.recieve_no,U1.recieve_date,U1.dchdate
        //         from acc_1102050101_307 U1             
        //         WHERE month(U1.vstdate) = "'.$months.'" AND year(U1.vstdate) = "'.$year.'"
        //         GROUP BY U1.vn
        //         UNION
        //         SELECT U2.vn,U2.an,U2.hn,U2.cid,U2.ptname,U2.vstdate,U2.pttype,U2.debit_total,U2.nhso_docno,U2.nhso_ownright_pid,U2.recieve_true,U2.difference,U2.recieve_no,U2.recieve_date,U2.dchdate
        //         from acc_1102050101_307 U2
             
        //         WHERE month(U2.dchdate) = "'.$months.'" AND year(U2.dchdate) = "'.$year.'"
        //         GROUP BY U2.an
        // ');
        $data = DB::select('
                SELECT U1.vn,U1.an,U1.hn,U1.cid,U1.ptname,U1.vstdate,U1.pttype,U1.debit_total,U1.nhso_docno,U1.nhso_ownright_pid,U1.recieve_true,U1.difference,U1.recieve_no,U1.recieve_date,U1.dchdate
                from acc_1102050101_307 U1             
                WHERE month(U1.vstdate) = "'.$months.'" AND year(U1.vstdate) = "'.$year.'"
                GROUP BY U1.vn 
        ');
        // WHERE month(U1.vstdate) = "'.$months.'" and year(U1.vstdate) = "'.$year.'"
        return view('account_307.account_307_detail', $data, [ 
            'data'       =>     $data,
            'months'     =>     $months,
            'year'       =>     $year
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




 }