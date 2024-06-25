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
use App\Models\Acc_1102050101_3011;
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


class Account3011Controller extends Controller
 {
    // ***************** 3011********************************
     
    public function account_3011_dash(Request $request)
    {
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
       
        $data_ = DB::table('acc_trimart')->where('acc_trimart_id','=',$acc_trimart_id)->first();
        
       if ($acc_trimart_id == '') {
            $data_trimart = DB::table('acc_trimart')->where('active','Y')->limit(12)->orderBy('acc_trimart_id','desc')->get();
            $trimart = DB::table('acc_trimart')->orderBy('acc_trimart_id','desc')->get();
       } else {
            // $data_trimart = DB::table('acc_trimart')->whereBetween('dchdate', [$startdate, $enddate])->orderBy('acc_trimart_id','desc')->get();
            $data_trimart = DB::table('acc_trimart')->where('active','Y')->where('acc_trimart_id','=',$acc_trimart_id)->orderBy('acc_trimart_id','desc')->get();
            $trimart = DB::table('acc_trimart')->orderBy('acc_trimart_id','desc')->get();
       }       

        return view('account_3011.account_3011_dash',[
            'startdate'        => $startdate,
            'enddate'          => $enddate,
            'leave_month_year' => $leave_month_year,
            'data_trimart'     => $data_trimart,
            'newyear'          => $newyear,
            'date'             => $date,
            'trimart'          => $trimart,
        ]);
    }
 
    // public function account_301_dashsubdetail(Request $request,$months,$year)
    // {
    //     $datenow = date('Y-m-d'); 
    //     // dd($id);
    //     $data['users'] = User::get();

    //     $data = DB::select('
    //     SELECT 
    //         vn,hn,cid,ptname,vstdate,pttype,debit_total
    //         from acc_1102050101_301 
    //         WHERE month(vstdate) = "'.$months.'"  
    //         AND year(vstdate) = "'.$year.'"
    //     ');
    //     // WHERE month(U1.vstdate) = "'.$months.'" and year(U1.vstdate) = "'.$year.'"
    //     return view('account_301.account_301_dashsubdetail', $data, [ 
    //         'data'          =>     $data,
    //         'year'          =>     $year,
    //         'months'        =>     $months
    //     ]);
    // }
    public function account_3011_pull(Request $request)
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
                SELECT * from acc_debtor a  
                WHERE a.account_code="1102050101.3011"
                AND a.stamp = "N"
                group by a.vn
                order by a.vstdate desc
            ');
            // and month(a.dchdate) = "'.$months.'" and year(a.dchdate) = "'.$year.'"     left join checksit_hos c on c.vn = a.vn
        } else {
            $acc_debtor = DB::select('
                SELECT * from acc_debtor a 
                WHERE a.account_code="1102050101.3011"
                AND a.stamp = "N"
                group by a.vn
                order by a.vstdate desc
            ');
            // $acc_debtor = Acc_debtor::where('stamp','=','N')->whereBetween('dchdate', [$startdate, $enddate])->get();
        }

        return view('account_3011.account_3011_pull',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'acc_debtor'    =>     $acc_debtor,
        ]);
    }
    public function account_3011_pulldata(Request $request)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->datepicker;
        $enddate = $request->datepicker2;
  
        // $acc_debtor = DB::connection('mysql2')->select(
        //     'SELECT v.vn,ifnull(o.an,"") as an,o.hn,pt.cid
        //             ,concat(pt.pname,pt.fname," ",pt.lname) as ptname
        //             ,v.vstdate ,o.vsttime ,v.hospmain,op.income as income_group                     
        //             ,ptt.pttype_eclaim_id ,vp.pttype 
        //             ,e.code as acc_code
        //             ,e.ar_opd as account_code 
        //             ,e.name as account_name
        //             ,v.income,v.uc_money,v.discount_money,v.paid_money,v.rcpt_money
        //             ,v.rcpno_list as rcpno
        //             ,v.income-v.discount_money-v.rcpt_money as debit
        //             ,if(op.icode IN ("3010058"),sum_price,0) as fokliad
        //             ,sum(if(op.income="02",sum_price,0)) as debit_instument
        //             ,sum(if(op.icode IN("1560016","1540073","1530005","1540048","1620015","1600012","1600015"),sum_price,0)) as debit_drug
        //             ,sum(if(op.icode IN("3001412","3001417"),sum_price,0)) as debit_toa
        //             ,sum(if(op.icode IN("3010829","3011068","3010864","3010861","3010862","3010863","3011069","3011012","3011070"),sum_price,0)) as debit_refer
        //             ,ptt.max_debt_money
        //     from ovst o
        //     left join vn_stat v on v.vn=o.vn
        //     LEFT JOIN visit_pttype vp on vp.vn = v.vn
        //     left join patient pt on pt.hn=o.hn
        //     LEFT JOIN pttype ptt on o.pttype=ptt.pttype
        //     LEFT JOIN pttype_eclaim e on e.code=ptt.pttype_eclaim_id
        //     LEFT JOIN opitemrece op ON op.vn = o.vn
        //     WHERE v.vstdate BETWEEN "' . $startdate . '" AND "' . $enddate . '"
        //     AND vp.pttype IN (SELECT pttype FROM pkbackoffice.acc_setpang_type WHERE pang ="1102050101.301")             
        //     AND v.income-v.discount_money-v.rcpt_money <> 0
        //     and (o.an="" or o.an is null)
        //     GROUP BY v.vn
        //     HAVING debit_instument > 0
        // '); 
        $acc_debtor = DB::connection('mysql2')->select(
            'SELECT v.vn,ifnull(o.an,"") as an,o.hn,v.cid,concat(pt.pname,pt.fname," ",pt.lname) as ptname
                        ,v.vstdate ,o.vsttime ,v.hospmain,op.income as income_group ,ptt.pttype_eclaim_id ,vp.pttype,ptt.max_debt_money
                        ,e.code as acc_code ,e.ar_opd as account_code,e.name as account_name ,v.income,v.uc_money,v.discount_money,v.paid_money,v.rcpt_money ,v.rcpno_list as rcpno
                        ,v.income-v.discount_money-v.rcpt_money as debit
                        ,if(op.icode IN ("3010058"),sum_price,0) as fokliad
                        ,sum(if(op.income="02",sum_price,0)) as debit_instument
                        ,sum(if(op.icode IN("1560016","1540073","1530005","1540048","1620015","1600012","1600015"),sum_price,0)) as debit_drug
                        ,sum(if(op.icode IN("3001412","3001417"),sum_price,0)) as debit_toa
                        ,sum(if(op.icode IN("3010829","3011068","3010864","3010861","3010862","3010863","3011069","3011012","3011070"),sum_price,0)) as debit_refer
                        ,(SELECT SUM(o.sum_price) FROM opitemrece o LEFT JOIN nondrugitems n on n.icode = o.icode WHERE o.vn=v.vn AND o.pttype="A7" AND (n.billcode like "8%" OR n.billcode ="2509") and n.billcode not in ("8608","8307") and o.an is null) as debit_ins_sss
                        ,(SELECT SUM(ot.sum_price) FROM opitemrece ot WHERE EXISTS (SELECT icode FROM xray_items WHERE icode = ot.icode AND xray_items_group ="3") AND vn =v.vn) as debit_ct_sss
                from ovst o
                left join vn_stat v on v.vn=o.vn
                LEFT JOIN visit_pttype vp on vp.vn = v.vn
                left join patient pt on pt.hn=o.hn
                LEFT JOIN pttype ptt on o.pttype=ptt.pttype
                LEFT JOIN pttype_eclaim e on e.code=ptt.pttype_eclaim_id
                LEFT JOIN opitemrece op ON op.vn = o.vn
                WHERE v.vstdate BETWEEN "' . $startdate . '" AND "' . $enddate . '"
                AND vp.pttype IN (SELECT pttype FROM pkbackoffice.acc_setpang_type WHERE pang ="1102050101.301" AND pttype IS NOT NULL)             
                AND v.income-v.discount_money-v.rcpt_money <> 0 
                AND (v.cid IS NOT NULL or v.cid <>"")
                and (o.an="" or o.an is null)
                GROUP BY v.vn
        ');
        foreach ($acc_debtor as $key => $value) {
            // if ($value->debit_instument > 0) {
            //     $check = Acc_debtor::where('vn', $value->vn)->where('account_code','1102050101.3011')->count(); 
            //     if ($check == 0) {                        
            //         Acc_debtor::insert([
            //             'hn'                 => $value->hn,
            //             'an'                 => $value->an,
            //             'vn'                 => $value->vn,
            //             'cid'                => $value->cid,
            //             'ptname'             => $value->ptname,
            //             'pttype'             => $value->pttype,
            //             'vstdate'            => $value->vstdate,
            //             'acc_code'           => $value->acc_code,
            //             'account_code'       => $value->account_code,
            //             'account_name'       => $value->account_name, 
            //             'income'             => $value->income,
            //             'uc_money'           => $value->uc_money,
            //             'discount_money'     => $value->discount_money,
            //             'paid_money'         => $value->paid_money,
            //             'rcpt_money'         => $value->rcpt_money,
            //             'debit'              => $value->debit,
            //             'debit_drug'         => $value->debit_drug,
            //             'debit_instument'    => $value->debit_instument,
            //             'debit_toa'          => $value->debit_toa,
            //             'debit_refer'        => $value->debit_refer, 
            //             'fokliad'            => $value->fokliad,
            //             'debit_total'        => $value->debit - $value->debit_instument, 
            //             'max_debt_amount'    => $value->max_debt_money,
            //             'acc_debtor_userid'  => Auth::user()->id
            //         ]);
            //     }
            // }      
            if ($value->debit_ins_sss > 0) {
                $check_sss = Acc_debtor::where('vn', $value->vn)->where('account_code','1102050101.3011')->count();
                if ($check_sss > 0) { 
                } else {
                    Acc_debtor::insert([
                        'hn'                 => $value->hn,
                        'an'                 => $value->an,
                        'vn'                 => $value->vn,
                        'cid'                => $value->cid,
                        'ptname'             => $value->ptname,
                        'pttype'             => $value->pttype,
                        'vstdate'            => $value->vstdate,
                        // 'acc_code'           => $value->acc_code,
                        'account_code'       => "1102050101.3011", 
                        'account_name'       => $value->account_name, 
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
                        'fokliad'            => $value->fokliad, 
                        'debit_total'        => $value->debit_ins_sss, 
                        'debit_ins_sss'      => $value->debit_ins_sss,
                        'debit_ct_sss'       => $value->debit_ct_sss, 
                        'max_debt_amount'    => $value->max_debt_money,
                        'acc_debtor_userid'  => Auth::user()->id
                    ]); 
                } 
            } 
        }

        return response()->json([

            'status'    => '200'
        ]);
    }
    public function account_3011_stam(Request $request)
    {
        $id = $request->ids;
        $iduser = Auth::user()->id;
        $data = Acc_debtor::whereIn('acc_debtor_id',explode(",",$id))->get();
            Acc_debtor::whereIn('acc_debtor_id',explode(",",$id))
                    ->update([
                        'stamp' => 'Y'
                    ]);
        foreach ($data as $key => $value) { 
            $check = Acc_1102050101_3011::where('vn', $value->vn)->count();
            if ($check > 0) { 
            } else {
                Acc_1102050101_3011::insert([
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
                        'debit_ins_sss'     => $value->debit_ins_sss,
                        'debit_ct_sss'      => $value->debit_ct_sss,
                        // 'fokliad'           => $value->fokliad,
                        'max_debt_amount'   => $value->max_debt_amount,
                        'acc_debtor_userid' => $iduser
                ]);
            } 
        }
        return response()->json([
            'status'    => '200'
        ]);
    }
    public function account_3011_destroy(Request $request)
    {
        $id = $request->ids;
        $iduser = Auth::user()->id;
        $data = Acc_debtor::whereIn('acc_debtor_id',explode(",",$id))->get();
            Acc_debtor::whereIn('acc_debtor_id',explode(",",$id))->delete();
                   
        return response()->json([
            'status'    => '200'
        ]);
    }
    public function account_301_detail(Request $request,$startdate,$enddate)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        // dd($id);
        $data['users'] = User::get();

        $data = DB::select('
        SELECT U1.vn,U1.hn,U1.cid,U1.ptname,U1.vstdate,U1.pttype,U1.debit_total
            from acc_1102050101_301 U1
        
            WHERE U1.vstdate BETWEEN "'.$startdate.'" and "'.$enddate.'"
            GROUP BY U1.vn
        ');
        // WHERE month(U1.vstdate) = "'.$months.'" and year(U1.vstdate) = "'.$year.'"
        return view('account_301.account_301_detail', $data, [ 
            'data'          =>     $data,
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate
        ]);
    }

    public function account_3011_detail_date(Request $request)
    { 
        $data['users'] = User::get();
        $startdate = $request->startdate;
        $enddate = $request->enddate;

        $data = DB::select('
        SELECT *
            from acc_1102050101_3011 U1
        
            WHERE U1.vstdate BETWEEN "'.$startdate.'" and "'.$enddate.'"
            GROUP BY U1.vn
        ');
        return view('account_3011.account_3011_detail_date', $data, [ 
            'data'           =>     $data,
            'startdate'      =>     $startdate,
            'enddate'        =>     $enddate
        ]);
    }
    
   
 

 }