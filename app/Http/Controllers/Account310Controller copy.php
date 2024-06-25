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
use App\Models\Acc_1102050101_310;
use App\Models\Acc_1102050101_302;

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


class Account310Controller extends Controller
 { 
    // ***************** 310********************************
    public function account_310_dash(Request $request)
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
            $yearnew = date('Y');
            $yearold = date('Y')-1;
            $start = (''.$yearold.'-10-01');
            $end = (''.$yearnew.'-09-30'); 
        
            // $data_trimart = DB::table('acc_trimart')->limit(3)->orderBy('acc_trimart_id','desc')->get();
            if ($acc_trimart_id == '') {
                $data_trimart = DB::select('SELECT *,year(acc_trimart_start_date) as year FROM acc_trimart order by acc_trimart_id desc');
                // $data_trimart = DB::table('acc_trimart')->limit(6)->orderBy('acc_trimart_id','desc')->get();
                $trimart = DB::table('acc_trimart')->orderBy('acc_trimart_id','desc')->get();
            } else {
                // $data_trimart = DB::table('acc_trimart')->whereBetween('dchdate', [$startdate, $enddate])->orderBy('acc_trimart_id','desc')->get();
                // $data_trimart = DB::table('acc_trimart')->where('acc_trimart_id','=',$acc_trimart_id)->orderBy('acc_trimart_id','desc')->get();
                $data_trimart = DB::select('SELECT *,year(acc_trimart_start_date) as year FROM acc_trimart where acc_trimart_id = "'.$acc_trimart_id.'" order by acc_trimart_id desc');
                $trimart = DB::table('acc_trimart')->orderBy('acc_trimart_id','desc')->get();
            }

            return view('account_310.account_310_dash',[
                'startdate'        =>     $startdate,
                'enddate'          =>     $enddate,
                'trimart'          => $trimart,
                'leave_month_year' =>  $leave_month_year,
                'data_trimart'     =>  $data_trimart,
            ]);
    }
    public function account_302_dashsub(Request $request,$startdate,$enddate)
    {
        $datenow = date('Y-m-d');
        
        $dabudget_year = DB::table('budget_year')->where('active','=',true)->first();
        $leave_month_year = DB::table('leave_month')->orderBy('MONTH_ID', 'ASC')->get();
        $date = date('Y-m-d'); 
        // dd($end );
       
            $datashow = DB::select('
                    SELECT month(a.dchdate) as months,year(a.dchdate) as year,l.MONTH_NAME,l.MONTH_ID
                    ,count(distinct a.hn) as hn
                    ,count(distinct a.vn) as vn
                    ,count(distinct a.an) as an
                    ,sum(a.income) as income
                    ,sum(a.paid_money) as paid_money
                    ,sum(a.income)-sum(a.discount_money)-sum(a.rcpt_money) as total
                    ,sum(a.debit) as debit
                    FROM acc_debtor a
                    left outer join leave_month l on l.MONTH_ID = month(a.dchdate)
                    WHERE a.dchdate between "'.$startdate.'" and "'.$enddate.'"
                    and account_code="1102050101.302"
                    group by month(a.dchdate) order by month(a.dchdate) desc;
            ');
            

        return view('account_302.account_302_dashsub',[
            'startdate'          =>  $startdate,
            'enddate'            =>  $enddate,
            'datashow'           =>  $datashow,
            'leave_month_year'   =>  $leave_month_year,
        ]);
    }
    public function account_302_dashsubdetail(Request $request,$months,$year)
    {
        $datenow = date('Y-m-d'); 
        // dd($id);
        $data['users'] = User::get();

        $data = DB::select('
        SELECT 
            month(dchdate) as months,year(dchdate) as year
            ,an,vn,hn,cid,ptname,dchdate,pttype,debit_total
            from acc_1102050101_302
        
            WHERE month(dchdate) = "'.$months.'"  
            AND year(dchdate) = "'.$year.'"
        ');
        // WHERE month(U1.vstdate) = "'.$months.'" and year(U1.vstdate) = "'.$year.'"
        return view('account_302.account_302_dashsubdetail', $data, [ 
            'data'          =>     $data,
            'year'          =>     $year,
            'months'        =>     $months
        ]);
    }

    public function account_310_pull(Request $request)
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
                left outer join check_sit_auto c on c.an = a.an 
                WHERE a.account_code="1102050101.310"
                AND a.stamp = "N"
                order by a.dchdate asc;

            ');
            // and month(a.dchdate) = "'.$months.'" and year(a.dchdate) = "'.$year.'"
        } else {
            // $acc_debtor = Acc_debtor::where('stamp','=','N')->whereBetween('dchdate', [$startdate, $enddate])->get();
        }

        return view('account_310.account_310_pull',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'acc_debtor'    =>     $acc_debtor,
        ]);
    }
    public function account_310_pulldata(Request $request)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->datepicker;
        $enddate = $request->datepicker2;
        // Acc_opitemrece::truncate();
            $acc_debtor = DB::connection('mysql2')->select('
                SELECT a.vn,a.an,a.hn,pt.cid,concat(pt.pname,pt.fname," ",pt.lname) ptname
                    ,a.regdate as admdate,a.dchdate as dchdate,v.vstdate,op.income as income_group,ip.rw
                    ,ipt.pttype,ptt.max_debt_money
                    ,"15" as acc_code 
                    ,"1102050101.310" as account_code 
                    ,"ประกันสังคม HC/AE" as account_name  
                    ,a.income as income ,a.uc_money,a.rcpt_money as cash_money,a.discount_money
                    ,a.income-a.rcpt_money-a.discount_money as debit
                    ,sum(if(op.icode IN ("3001758"),sum_price,0)) as looknee
                    ,sum(if(op.icode ="3010058",sum_price,0)) as fokliad
                    ,sum(if(op.income="02",sum_price,0)) as debit_instument
                    ,sum(if(op.icode IN("1560016","1540073","1530005","1540048","1620015","1600012","1600015"),sum_price,0)) as debit_drug
                    ,sum(if(op.icode IN ("3001412","3001417"),sum_price,0)) as debit_toa
                    ,sum(if(op.icode IN ("3010829","3010726 "),sum_price,0)) as debit_refer

                    from ipt ip
                    LEFT JOIN an_stat a ON ip.an = a.an
                    LEFT JOIN patient pt on pt.hn=a.hn
                    LEFT JOIN pttype ptt on a.pttype=ptt.pttype
                    LEFT JOIN pttype_eclaim ec on ec.code=ptt.pttype_eclaim_id
                    LEFT JOIN ipt_pttype ipt ON ipt.an = a.an
                    LEFT JOIN opitemrece op ON ip.an = op.an
                    LEFT JOIN iptoprt io on io.an = ip.an
                    LEFT JOIN vn_stat v on v.vn = a.vn
                    WHERE a.dchdate BETWEEN "' . $startdate . '" AND "' . $enddate . '"
                    AND ipt.pttype IN("A7","15")
                    AND v.hospmain = "10702"
                    and io.icd9 like "%6632%"
                    GROUP BY a.an;
                
            ');

            foreach ($acc_debtor as $key => $value) {
                // if ($value->debit_instument > 0 || $value->debit_drug > 0 || $value->debit_toa > 0 || $value->debit_refer > 0) {    
                    // $check = Acc_debtor::where('an', $value->an)->whereBetween('dchdate', [$startdate, $enddate])->count();
                    // $check = Acc_debtor::where('an', $value->an)->whereIn('account_code', ['1102050102.107','1102050101.302'])->count();
                    $check =  Acc_debtor::where('an', $value->an)
                    // ->where('debit_instument', '>','0')
                    ->where('dchdate', $value->dchdate)
                    ->where('account_code','1102050101.310')
                    // ->where('debit', '=',$value->debit_instument)->where('debit', '=',$value->debit_drug)->where('debit', '=',$value->debit_refer)
                    ->count(); 

                    $check = Acc_debtor::where('an', $value->an)
                    // ->where('debit_instument', '>','0')->where('debit_drug', '>','0')->where('debit_refer', '>','0')
                    ->count(); 
                    // dd( $checkins );
                    if ($check == 0) {
                        // if ($check == 0) {
                            // if ($value->debit_instument > 0) {
                                Acc_debtor::insert([
                                    'hn'                 => $value->hn,
                                    'an'                 => $value->an,
                                    'vn'                 => $value->vn,
                                    'cid'                => $value->cid,
                                    'ptname'             => $value->fullname,
                                    'pttype'             => $value->pttype,
                                    'vstdate'            => $value->vstdate,
                                    'regdate'            => $value->admdate,
                                    'dchdate'            => $value->dchdate,
                                    'acc_code'           => $value->acc_code,
                                    'account_code'       => $value->account_code,
                                    'account_name'       => $value->account_name,
                                    'income_group'       => $value->income_group,
                                    'income'             => $value->income,
                                    'uc_money'           => $value->uc_money,
                                    'discount_money'     => $value->discount_money,
                                    'paid_money'         => $value->cash_money,
                                    'rcpt_money'         => $value->cash_money,
                                    'debit'              => $value->debit,
                                    'debit_drug'         => $value->debit_drug,
                                    'debit_instument'    => $value->debit_instument,
                                    'debit_toa'          => $value->debit_toa,
                                    'debit_refer'        => $value->debit_refer,
                                    'fokliad'            => $value->fokliad,
                                    'debit_total'        => $value->looknee,
                                    // 'max_debt_amount'    => $value->max_debt_money,
                                    'acc_debtor_userid'  => Auth::user()->id
                                ]);
                            // }elseif ($value->debit_drug > 0) {
                            //     Acc_debtor::insert([
                            //         'hn'                 => $value->hn,
                            //         'an'                 => $value->an,
                            //         'vn'                 => $value->vn,
                            //         'cid'                => $value->cid,
                            //         'ptname'             => $value->fullname,
                            //         'pttype'             => $value->pttype,
                            //         'vstdate'            => $value->vstdate,
                            //         'regdate'            => $value->admdate,
                            //         'dchdate'            => $value->dchdate,
                            //         'acc_code'           => '15',
                            //         'account_code'       => '1102050101.310',
                            //         'account_name'       => 'ประกันสังคม HC/AE',
                            //         'income_group'       => $value->income_group,
                            //         'income'             => $value->income,
                            //         'uc_money'           => $value->uc_money,
                            //         'discount_money'     => $value->discount_money,
                            //         'paid_money'         => $value->cash_money,
                            //         'rcpt_money'         => $value->cash_money,
                            //         'debit'              => $value->debit_drug,
                            //         'debit_drug'         => $value->debit_drug,
                            //         'debit_instument'    => $value->debit_instument,
                            //         'debit_toa'          => $value->debit_toa,
                            //         'debit_refer'        => $value->debit_refer,
                            //         'fokliad'            => $value->fokliad,
                            //         'debit_total'        => $value->debit_drug,
                            //         'max_debt_amount'    => $value->max_debt_money,
                            //         'acc_debtor_userid'  => Auth::user()->id
                            //     ]);
                            // }elseif ($value->debit_refer > 0) {
                            //     Acc_debtor::insert([
                            //         'hn'                 => $value->hn,
                            //         'an'                 => $value->an,
                            //         'vn'                 => $value->vn,
                            //         'cid'                => $value->cid,
                            //         'ptname'             => $value->fullname,
                            //         'pttype'             => $value->pttype,
                            //         'vstdate'            => $value->vstdate,
                            //         'regdate'            => $value->admdate,
                            //         'dchdate'            => $value->dchdate,
                            //         'acc_code'           => '15',
                            //         'account_code'       => '1102050101.310',
                            //         'account_name'       => 'ประกันสังคม HC/AE',
                            //         'income_group'       => $value->income_group,
                            //         'income'             => $value->income,
                            //         'uc_money'           => $value->uc_money,
                            //         'discount_money'     => $value->discount_money,
                            //         'paid_money'         => $value->cash_money,
                            //         'rcpt_money'         => $value->cash_money,
                            //         'debit'              => $value->debit_refer,
                            //         'debit_drug'         => $value->debit_drug,
                            //         'debit_instument'    => $value->debit_instument,
                            //         'debit_toa'          => $value->debit_toa,
                            //         'debit_refer'        => $value->debit_refer,
                            //         'fokliad'            => $value->fokliad,
                            //         'debit_total'        => $value->debit_refer,
                            //         'max_debt_amount'    => $value->max_debt_money,
                            //         'acc_debtor_userid'  => Auth::user()->id
                            //     ]);
                            // } else {
                            //     # code...
                            // } 
                    }
                    // } else { 
                    
                        // if ($check == 0) {
                        //     if ($value->debit_instument > 0) {
                        //         Acc_debtor::insert([
                        //             'hn'                 => $value->hn,
                        //             'an'                 => $value->an,
                        //             'vn'                 => $value->vn,
                        //             'cid'                => $value->cid,
                        //             'ptname'             => $value->fullname,
                        //             'pttype'             => $value->pttype,
                        //             'vstdate'            => $value->vstdate,
                        //             'regdate'            => $value->admdate,
                        //             'dchdate'            => $value->dchdate,
                        //             'acc_code'           => '15',
                        //             'account_code'       => '1102050101.310',
                        //             'account_name'       => 'ประกันสังคม HC/AE',
                        //             'income_group'       => $value->income_group,
                        //             'income'             => $value->income,
                        //             'uc_money'           => $value->uc_money,
                        //             'discount_money'     => $value->discount_money,
                        //             'paid_money'         => $value->cash_money,
                        //             'rcpt_money'         => $value->cash_money,
                        //             'debit'              => $value->debit_instument,
                        //             'debit_drug'         => $value->debit_drug,
                        //             'debit_instument'    => $value->debit_instument,
                        //             'debit_toa'          => $value->debit_toa,
                        //             'debit_refer'        => $value->debit_refer,
                        //             'fokliad'            => $value->fokliad,
                        //             'debit_total'        => $value->debit_instument,
                        //             'max_debt_amount'    => $value->max_debt_money,
                        //             'acc_debtor_userid'  => Auth::user()->id
                        //         ]);
                        //     }elseif ($value->debit_drug > 0) {
                        //         Acc_debtor::insert([
                        //             'hn'                 => $value->hn,
                        //             'an'                 => $value->an,
                        //             'vn'                 => $value->vn,
                        //             'cid'                => $value->cid,
                        //             'ptname'             => $value->fullname,
                        //             'pttype'             => $value->pttype,
                        //             'vstdate'            => $value->vstdate,
                        //             'regdate'            => $value->admdate,
                        //             'dchdate'            => $value->dchdate,
                        //             'acc_code'           => '15',
                        //             'account_code'       => '1102050101.310',
                        //             'account_name'       => 'ประกันสังคม HC/AE',
                        //             'income_group'       => $value->income_group,
                        //             'income'             => $value->income,
                        //             'uc_money'           => $value->uc_money,
                        //             'discount_money'     => $value->discount_money,
                        //             'paid_money'         => $value->cash_money,
                        //             'rcpt_money'         => $value->cash_money,
                        //             'debit'              => $value->debit_drug,
                        //             'debit_drug'         => $value->debit_drug,
                        //             'debit_instument'    => $value->debit_instument,
                        //             'debit_toa'          => $value->debit_toa,
                        //             'debit_refer'        => $value->debit_refer,
                        //             'fokliad'            => $value->fokliad,
                        //             'debit_total'        => $value->debit_drug,
                        //             'max_debt_amount'    => $value->max_debt_money,
                        //             'acc_debtor_userid'  => Auth::user()->id
                        //         ]);
                        //     }elseif ($value->debit_refer > 0) {
                        //         Acc_debtor::insert([
                        //             'hn'                 => $value->hn,
                        //             'an'                 => $value->an,
                        //             'vn'                 => $value->vn,
                        //             'cid'                => $value->cid,
                        //             'ptname'             => $value->fullname,
                        //             'pttype'             => $value->pttype,
                        //             'vstdate'            => $value->vstdate,
                        //             'regdate'            => $value->admdate,
                        //             'dchdate'            => $value->dchdate,
                        //             'acc_code'           => '15',
                        //             'account_code'       => '1102050101.310',
                        //             'account_name'       => 'ประกันสังคม HC/AE',
                        //             'income_group'       => $value->income_group,
                        //             'income'             => $value->income,
                        //             'uc_money'           => $value->uc_money,
                        //             'discount_money'     => $value->discount_money,
                        //             'paid_money'         => $value->cash_money,
                        //             'rcpt_money'         => $value->cash_money,
                        //             'debit'              => $value->debit_refer,
                        //             'debit_drug'         => $value->debit_drug,
                        //             'debit_instument'    => $value->debit_instument,
                        //             'debit_toa'          => $value->debit_toa,
                        //             'debit_refer'        => $value->debit_refer,
                        //             'fokliad'            => $value->fokliad,
                        //             'debit_total'        => $value->debit_refer,
                        //             'max_debt_amount'    => $value->max_debt_money,
                        //             'acc_debtor_userid'  => Auth::user()->id
                        //         ]);
                        //     } else {
                        //         # code...
                        //     } 
                        // }
                    
                    // }
                    
                // } else {
                    # code...
                // }
 
                // if ($value->debit_instument > 0 ) {
                //         $checkins = Acc_debtor::where('an', $value->an)->where('debit_instument', '>','0')->count();

                //         if ($checkins == 0) {
                //             Acc_debtor::insert([
                //                 'hn'                 => $value->hn,
                //                 'an'                 => $value->an,
                //                 'vn'                 => $value->vn,
                //                 'cid'                => $value->cid,
                //                 'ptname'             => $value->fullname,
                //                 'pttype'             => $value->pttype,
                //                 'vstdate'            => $value->vstdate,
                //                 'regdate'            => $value->admdate,
                //                 'dchdate'            => $value->dchdate,
                //                 'acc_code'           => $value->code,
                //                 'account_code'       => $value->account_code,
                //                 'account_name'       => $value->account_name,
                //                 'income_group'       => $value->income_group,
                //                 'debit'              => $value->debit_instument,
                //                 'debit_total'       => $value->debit_instument
                //             ]);
                //         }
                // }
                // if ($value->debit_drug > 0) {
                //         $checkindrug = Acc_debtor::where('an', $value->an)->where('debit_drug','>','0')->count();
                //         if ($checkindrug == 0) {
                //             Acc_debtor::insert([
                //                 'hn'                 => $value->hn,
                //                 'an'                 => $value->an,
                //                 'vn'                 => $value->vn,
                //                 'cid'                => $value->cid,
                //                 'ptname'             => $value->fullname,
                //                 'pttype'             => $value->pttype,
                //                 'vstdate'            => $value->vstdate,
                //                 'regdate'            => $value->admdate,
                //                 'dchdate'            => $value->dchdate,
                //                 'acc_code'           => $value->code,
                //                 'account_code'       => $value->account_code,
                //                 'account_name'       => $value->account_name,
                //                 'income_group'       => $value->income_group,
                //                 'debit'              => $value->debit_drug,
                //                 'debit_total'        => $value->debit_drug
                //             ]);
                //         }
                // }
                // if ($value->debit_refer > 0) {
                //     $checkinrefer = Acc_debtor::where('an', $value->an)->where('debit_refer','>','0')->count();
                //     if ($checkinrefer == 0) {
                //         Acc_debtor::insert([
                //             'hn'                 => $value->hn,
                //             'an'                 => $value->an,
                //             'vn'                 => $value->vn,
                //             'cid'                => $value->cid,
                //             'ptname'             => $value->fullname,
                //             'pttype'             => $value->pttype,
                //             'vstdate'            => $value->vstdate,
                //             'regdate'            => $value->admdate,
                //             'dchdate'            => $value->dchdate,
                //             'acc_code'           => $value->code,
                //             'account_code'       => $value->account_code,
                //             'account_name'       => $value->account_name,
                //             'income_group'       => $value->income_group,
                //             'debit'              => $value->debit_refer,
                //             'debit_total'        => $value->debit_refer
                //         ]);
                //     }
                // }
            }
            return response()->json([

                'status'    => '200'
            ]);
    }
    public function account_310_stam(Request $request)
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
             
                $check = Acc_1102050101_310::where('an', $value->an)->count();
                if ($check > 0) {
                # code...
                } else {
                    Acc_1102050101_310::insert([
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
                            'debit_total'       => $value->debit,
                            'max_debt_amount'   => $value->max_debt_amount,
                            'acc_debtor_userid' => $iduser
                    ]);
                }

        }
        return response()->json([
            'status'    => '200'
        ]);
    }
   
    // public function account_302_detail(Request $request,$startdate,$enddate)
    // {
    //     $datenow = date('Y-m-d');
    //     // $startdate = $request->startdate;
    //     // $enddate = $request->enddate;
    //     // dd($id);
    //     $data['users'] = User::get();

    //     $data = DB::select('
    //     SELECT U1.vn,U1.hn,U1.cid,U1.ptname,U1.vstdate,U1.pttype,U1.debit_total
    //         from acc_1102050101_302 U1
        
    //         WHERE U1.vstdate BETWEEN "'.$startdate.'" and "'.$enddate.'"
    //         GROUP BY U1.vn
    //     ');
    //     // WHERE month(U1.vstdate) = "'.$months.'" and year(U1.vstdate) = "'.$year.'"
    //     return view('account_302.account_302_detail', $data, [ 
    //         'data'          =>     $data,
    //         'startdate'     =>     $startdate,
    //         'enddate'       =>     $enddate
    //     ]);
    // }
    public function account_310_dashsub(Request $request,$startdate,$enddate)
    {
        $datenow = date('Y-m-d');
        
        $dabudget_year = DB::table('budget_year')->where('active','=',true)->first();
        $leave_month_year = DB::table('leave_month')->orderBy('MONTH_ID', 'ASC')->get();
        $date = date('Y-m-d'); 
        // dd($end );
       
            $datashow = DB::select('
                    SELECT month(a.dchdate) as months,year(a.dchdate) as year,l.MONTH_NAME,l.MONTH_ID
                    ,count(distinct a.hn) as hn
                    ,count(distinct a.vn) as vn
                    ,count(distinct a.an) as an
                    ,sum(a.income) as income
                    ,sum(a.paid_money) as paid_money
                    ,sum(a.income)-sum(a.discount_money)-sum(a.rcpt_money) as total
                    ,sum(a.debit) as debit
                    FROM acc_debtor a
                    left outer join leave_month l on l.MONTH_ID = month(a.dchdate)
                    WHERE a.dchdate between "'.$startdate.'" and "'.$enddate.'"
                    and account_code="1102050101.310"
                    group by month(a.dchdate) order by month(a.dchdate) desc;
            ');
            

        return view('account_310.account_310_dashsub',[
            'startdate'          =>  $startdate,
            'enddate'            =>  $enddate,
            'datashow'           =>  $datashow,
            'leave_month_year'   =>  $leave_month_year,
        ]);
    }

    public function account_310_dashsubdetail(Request $request,$months,$year)
    {
        $datenow = date('Y-m-d'); 
        // dd($id);
        $data['users'] = User::get();

        $data = DB::select('
        SELECT 
            month(dchdate) as months,year(dchdate) as year
            ,an,vn,hn,cid,ptname,dchdate,pttype,debit_total
            from acc_1102050101_310
        
            WHERE month(dchdate) = "'.$months.'"  
            AND year(dchdate) = "'.$year.'"
        ');
        // WHERE month(U1.vstdate) = "'.$months.'" and year(U1.vstdate) = "'.$year.'"
        return view('account_310.account_310_dashsubdetail', $data, [ 
            'data'          =>     $data,
            'year'          =>     $year,
            'months'        =>     $months
        ]);
    }
   
 }