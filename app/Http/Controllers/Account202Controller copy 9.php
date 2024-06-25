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
use App\Models\Acc_ucep24;
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
use App\Models\Acc_ucep_24;

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


class Account202Controller extends Controller
 {
     // *************************** 202 ********************************************
     public function account_pkucs202_pull(Request $request)
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
               
                 WHERE account_code="1102050101.202"
                 AND stamp = "N"
                 group by a.an
                 order by vstdate desc;
 
             ');
            //  left join checksit_hos c on c.an = a.an

             // left outer join check_sit_auto c on c.hn = a.hn and c.vstdate = a.vstdate
             // left outer join check_sit_auto c on c.hn = a.hn and c.vstdate = a.vstdate
             // AND a.dchdate BETWEEN "'.$startdate.'" AND "'.$enddate.'"
             // SELECT a.*,c.subinscl from acc_debtor a
             // left outer join check_sit_auto c on c.cid = a.cid and c.vstdate = a.vstdate
 
             // WHERE a.account_code="1102050101.202"
             // AND a.stamp = "N"
             // and month(a.dchdate) = "'.$months.'" and year(a.dchdate) = "'.$year.'"
             // order by a.dchdate asc;
         } else {
             $acc_debtor = DB::select('
                 SELECT 
                 a.acc_debtor_id,a.an,a.vn,a.hn,a.cid,a.ptname,a.pttype,a.dchdate,a.income,a.debit_total,a.debit_instument,a.debit_drug,a.debit_toa,a.debit_refer,a.debit_ucep  
                 from acc_debtor a               
                 left join check_sit_auto c on c.an = a.an
                 WHERE a.account_code="1102050101.202" and a.dchdate BETWEEN "' . $startdate . '" AND "' . $enddate . '"
                 AND a.stamp = "N"
                 group by a.an
                 order by a.dchdate desc;
                 
             ');
            //  ,c.subinscl
            //  left join checksit_hos c on c.an = a.an
            //  a.*,c.subinscl  
            //  left outer join check_sit_auto c on c.hn = a.hn and c.vstdate = a.vstdate
             // ,c.subinscl
             // left outer join check_sit_auto c on c.hn = a.hn and c.vstdate = a.vstdate
             // $acc_debtor = Acc_debtor::where('stamp','=','N')->whereBetween('dchdate', [$startdate, $enddate])->get();
         }
 
 
         return view('account_202.account_pkucs202_pull',[
             'startdate'     =>     $startdate,
             'enddate'       =>     $enddate,
             'acc_debtor'      =>     $acc_debtor,
         ]);
     }
     public function account_pkucs202_pulldata(Request $request)
     {
         $date              = date('Y-m-d H:i:s');
         $startdate         = $request->datepicker;
         $enddate           = $request->datepicker2; 
        $data_main = DB::connection('mysql2')->select('
                SELECT o.an,a.vn,o.rxdate,o.rxtime,a.vstdate,a.vsttime,i.dchdate
                FROM opitemrece o
                LEFT JOIN ipt i on i.an = o.an
                LEFT JOIN ovst a on a.an = o.an
                left JOIN er_regist e on e.vn = i.vn 
                LEFT JOIN pttype p on p.pttype = i.pttype 
                WHERE i.dchdate BETWEEN "'.$startdate.'" and "'.$enddate.'"
                AND o.an is not null  
                AND p.hipdata_code ="ucs"
                AND DATEDIFF(o.rxdate,a.vstdate)<="1"
                AND TIMEDIFF(o.rxtime,a.vsttime)<="24" 
                AND e.er_emergency_level_id IN("1","2")
                AND o.income NOT IN("02")
                GROUP BY o.an 
        ');
        Acc_ucep_24::truncate();
        foreach ($data_main as $key => $val) {   
                $data_ = DB::connection('mysql2')->select('    
                        SELECT o.an,a.vn,o.rxdate,o.rxtime,a.vstdate,a.vsttime,i.dchdate
                        ,(
                                SELECT SUM(o.sum_price) sum_price
                                FROM opitemrece o
                                LEFT JOIN ipt i on i.an = o.an
                                LEFT JOIN ovst a on a.an = o.an
                                left JOIN er_regist e on e.vn = i.vn 
                                LEFT JOIN pttype p on p.pttype = i.pttype 
                                WHERE o.an = "'.$val->an.'" 
                                AND o.an is not null  
                                AND p.hipdata_code ="ucs" 
                                AND o.income NOT IN("02")
                        ) as sum_price_ipd
                        ,(
                            SELECT SUM(o.sum_price) sum_price
                            FROM opitemrece o
                            LEFT JOIN ipt i on i.an = o.an
                            LEFT JOIN ovst a on a.an = o.an
                            left JOIN er_regist e on e.vn = i.vn 
                            LEFT JOIN pttype p on p.pttype = i.pttype 
                            WHERE o.an = "'.$val->an.'" 
                            AND o.an is not null  
                            AND p.hipdata_code ="ucs"
                            AND DATEDIFF(o.rxdate,a.vstdate)<="1"
                            AND TIMEDIFF(o.rxtime,a.vsttime)<="24" 
                            AND e.er_emergency_level_id IN("1","2")
                            AND o.income NOT IN("02")
                        ) as sum_price_ucep_all
                        ,(
                                SELECT SUM(o.sum_price) sum_price
                                FROM opitemrece o
                                LEFT JOIN ipt i on i.an = o.an
                                LEFT JOIN ovst a on a.an = o.an
                                left JOIN er_regist e on e.vn = i.vn 
                                LEFT JOIN pttype p on p.pttype = i.pttype 
                                WHERE o.an = "'.$val->an.'" 
                                AND (o.income IN("02") OR icode IN("1560016","1540073","1530005","3001412","3001417","3010829","3011068","3010864","3010861","3010862","3010863","3011069","3011012","3011070"))
                                AND o.an is not null  
                                AND p.hipdata_code ="ucs"
                                AND DATEDIFF(o.rxdate,a.vstdate)<="1"
                                AND TIMEDIFF(o.rxtime,a.vsttime)<="24" 
                                AND e.er_emergency_level_id IN("1","2")
                                AND o.income NOT IN("02")
                        ) as sum_price_ucep_cr
                        ,(
                                SELECT SUM(o.sum_price) sum_price
                                FROM opitemrece o
                                LEFT JOIN ipt i on i.an = o.an
                                LEFT JOIN ovst a on a.an = o.an
                                left JOIN er_regist e on e.vn = i.vn 
                                LEFT JOIN pttype p on p.pttype = i.pttype 
                                WHERE o.an = "'.$val->an.'" 
                                AND o.income NOT IN("02") AND o.icode NOT IN("1560016","1540073","1530005","3001412","3001417","3010829","3011068","3010864","3010861","3010862","3010863","3011069","3011012","3011070")
                                AND o.an is not null  
                                AND p.hipdata_code ="ucs"
                                AND DATEDIFF(o.rxdate,a.vstdate)<="1"
                                AND TIMEDIFF(o.rxtime,a.vsttime)<="24" 
                                AND e.er_emergency_level_id IN("1","2")
                                AND o.income NOT IN("02")
                        ) as sum_price_ucep_normal                           

                        FROM opitemrece o
                        LEFT JOIN ipt i on i.an = o.an
                        LEFT JOIN ovst a on a.an = o.an
                        left JOIN er_regist e on e.vn = i.vn 
                        LEFT JOIN pttype p on p.pttype = i.pttype 
                        WHERE o.an = "'.$val->an.'" 
                        AND o.an is not null  
                        AND p.hipdata_code ="ucs"
                        AND DATEDIFF(o.rxdate,a.vstdate)<="1"
                        AND TIMEDIFF(o.rxtime,a.vsttime)<="24" 
                        AND e.er_emergency_level_id IN("1","2")
                        AND p.pttype NOT IN ("31","33","36","39")
                        AND o.income NOT IN("02")
                        GROUP BY o.an  
                ');             
                foreach ($data_ as $key => $val2) {    
                    Acc_ucep_24::insert([
                            'vn'                        => $val2->vn, 
                            'an'                        => $val2->an, 
                            'vstdate'                   => $val2->vstdate, 
                            'vsttime'                   => $val2->vsttime, 
                            'dchdate'                   => $val2->dchdate, 
                            'rxdate'                    => $val2->rxdate, 
                            'rxtime'                    => $val2->rxtime, 
                            'sum_price_ipd'             => $val2->sum_price_ipd, 
                            'sum_price_ucep_all'        => $val2->sum_price_ucep_all, 
                            'sum_price_ucep_cr'         => $val2->sum_price_ucep_cr,  
                            'sum_price_ucep_normal'     => $val2->sum_price_ucep_normal,  
                            'sum_price_ipd_202'         => $val2->sum_price_ipd - $val2->sum_price_ucep_all,
                    ]);
                }
                // $data_more = DB::connection('mysql2')->select('    
                //         SELECT o.an                             
                //         ,(
                //                 SELECT SUM(o.sum_price) sum_price
                //                 FROM opitemrece o
                //                 LEFT JOIN ipt i on i.an = o.an
                //                 LEFT JOIN ovst a on a.an = o.an
                //                 left JOIN er_regist e on e.vn = i.vn 
                //                 LEFT JOIN pttype p on p.pttype = i.pttype 
                //                 WHERE o.an = "'.$val->an.'" 
                //                 AND (o.income IN("02") OR icode IN("1560016","1540073","1530005","3001412","3001417","3010829","3011068","3010864","3010861","3010862","3010863","3011069","3011012","3011070"))
                //                 AND o.an is not null  
                //                 AND p.hipdata_code ="ucs"
                //                 AND DATEDIFF(o.rxdate,a.vstdate)>="1"
                //                 AND TIMEDIFF(o.rxtime,a.vsttime)>="24" 
                //                 AND e.er_emergency_level_id IN("1","2")
                //         ) as sum_price_ucep_cr2
                //         ,(
                //                 SELECT SUM(o.sum_price) sum_price
                //                 FROM opitemrece o
                //                 LEFT JOIN ipt i on i.an = o.an
                //                 LEFT JOIN ovst a on a.an = o.an
                //                 left JOIN er_regist e on e.vn = i.vn 
                //                 LEFT JOIN pttype p on p.pttype = i.pttype 
                //                 WHERE o.an = "'.$val->an.'" 
                //                 AND o.income NOT IN("02") AND o.icode NOT IN("1560016","1540073","1530005","3001412","3001417","3010829","3011068","3010864","3010861","3010862","3010863","3011069","3011012","3011070")
                //                 AND o.an is not null  
                //                 AND p.hipdata_code ="ucs"
                //                 AND DATEDIFF(o.rxdate,a.vstdate)>="1"
                //                 AND TIMEDIFF(o.rxtime,a.vsttime)>="24" 
                //                 AND e.er_emergency_level_id IN("1","2")
                //         ) as sum_price_ucep_normal2                          

                //         FROM opitemrece o
                //         LEFT JOIN ipt i on i.an = o.an
                //         LEFT JOIN ovst a on a.an = o.an
                //         left JOIN er_regist e on e.vn = i.vn 
                //         LEFT JOIN pttype p on p.pttype = i.pttype 
                //         WHERE o.an = "'.$val->an.'" 
                //         AND o.an is not null  
                //         AND p.hipdata_code ="ucs"
                //         AND DATEDIFF(o.rxdate,a.vstdate)>="1"
                //         AND TIMEDIFF(o.rxtime,a.vsttime)>="24" 
                //         AND e.er_emergency_level_id IN("1","2")
                //         GROUP BY o.an  
                // ');  
                // foreach ($data_more as $key => $val_up) {
                //     Acc_ucep_24::where('an',$val_up->an)->update([  
                //         'sum_price_ucep_cr2'         => $val_up->sum_price_ucep_cr2,  
                //         'sum_price_ucep_normal2'     => $val_up->sum_price_ucep_normal2,  
                // ]);
                // }   
        }
             
        $acc_debtor = DB::connection('mysql2')->select(' 
                    SELECT ip.vn,a.an,a.hn,pt.cid,concat(pt.pname,pt.fname," ",pt.lname) ptname,a.regdate as admdate,a.dchdate,v.vstdate,op.income as income_group
                    ,ipt.pttype,ipt.pttype_number,ipt.max_debt_amount ,ip.rw,ip.adjrw,ip.adjrw*8350 as total_adjrw_income ,ipt.nhso_ownright_pid ,a.income,a.uc_money,a.rcpt_money,a.discount_money
                    
                    ,"01" as acc_code
                    ,"1102050101.202" as account_code
                    ,"UC ใน CUP" as account_name

                    ,CASE 
                    WHEN  ipt.pttype_number ="1" AND ipt.pttype IN ("31","33","36","39") THEN ipt.max_debt_amount 
                    ELSE a.income - ipt.max_debt_amount 
                    END as debit_prb

                    ,CASE  
					WHEN  ipt.pttype_number ="2" THEN a.income - a.rcpt_money - a.discount_money - ipt.max_debt_amount
                    ELSE a.income - a.rcpt_money - a.discount_money  
                    END as debit                   

                    ,sum(if(op.icode IN("3002895","3002896","3002897","3002898","3002909","3002910","3002911","3002912","3002913","3002914","3002915","3002916","3002918"),sum_price,0)) as portex
                    ,sum(if(op.income="02",sum_price,0)) as debit_instument
                    ,sum(if(op.icode IN("1560016","1540073","1530005"),sum_price,0)) as debit_drug
                    ,sum(if(op.icode IN ("3001412","3001417"),sum_price,0)) as debit_toa
                    ,sum(if(op.icode IN("3010829","3011068","3010864","3010861","3010862","3010863","3011069","3011012","3011070"),sum_price,0)) as debit_refer
 
                    from ipt ip
                    LEFT JOIN an_stat a ON ip.an = a.an
                    LEFT JOIN patient pt on pt.hn=a.hn
                    LEFT JOIN pttype ptt on a.pttype=ptt.pttype
                    LEFT JOIN pttype_eclaim ec on ec.code=ptt.pttype_eclaim_id
                    LEFT JOIN ipt_pttype ipt ON ipt.an = a.an
                    LEFT JOIN opitemrece op ON ip.an = op.an
                    LEFT JOIN vn_stat v on v.vn = ip.vn
                WHERE a.dchdate BETWEEN "' . $startdate . '" AND "' . $enddate . '"              
                AND ipt.pttype IN(SELECT pttype FROM pkbackoffice.acc_setpang_type WHERE pang ="1102050101.202" AND opdipd ="IPD" AND pttype <>"")                              
                GROUP BY a.an
        '); 
        // ,CASE  
        // WHEN  ipt.pttype_number ="2" THEN a.income - a.rcpt_money - a.discount_money - ipt.max_debt_amount
        // ELSE a.income - a.rcpt_money - a.discount_money - (sum(if(op.income="02",sum_price,0)))
        // END as debit 

        // ,a.income-a.rcpt_money-a.discount_money as debit
        // ,a.income-a.rcpt_money-a.discount_money-IFNULL(ipt.max_debt_amount,"0") as debit
         foreach ($acc_debtor as $key => $value) {
            // $count_pttype = DB::connection('mysql2')->select('SELECT COUNT(an) as C_an FROM  ipt_pttype WHERE an = "'.$value->an.'" ');
            $count_pttype = DB::connection('mysql2')->table('ipt_pttype')->where('an', $value->an)->count();
            // $total_ = $value->debit-$value->debit_drug-$value->debit_instument-$value->debit_toa-$value->debit_refer-$value->debit_ucep;
            // dd($count_pttype);
            if ($count_pttype > 1) {
                $check = Acc_debtor::where('an', $value->an)->where('account_code', '1102050101.202')->count();
                    if ($check == 0) {
                        if ($value->pttype_number == '2') {
                            if ($value->debit_toa > 0 ) {                     
                            } else {
                                if ($value->debit > 0) {                                   
                               
                                    if ($value->debit_prb > $value->debit) {
                                        # code...
                                    } else { 
                                        Acc_debtor::insert([
                                            'hn'                 => $value->hn,
                                            'an'                 => $value->an,
                                            'vn'                 => $value->vn,
                                            'cid'                => $value->cid,
                                            'ptname'             => $value->ptname,
                                            'pttype'             => $value->pttype,
                                            'vstdate'            => $value->vstdate,
                                            'rxdate'             => $value->admdate,
                                            'dchdate'            => $value->dchdate,
                                            'acc_code'           => $value->acc_code,
                                            'account_code'       => $value->account_code,
                                            'account_name'       => $value->account_name, 
                                            'income'             => $value->income,
                                            'uc_money'           => $value->uc_money,
                                            'discount_money'     => $value->discount_money, 
                                            'rcpt_money'         => $value->rcpt_money,
                                            'debit'              => $value->debit,
                                            'debit_drug'         => $value->debit_drug,
                                            'debit_instument'    => $value->debit_instument,
                                            'debit_toa'          => $value->debit_toa,
                                            'debit_refer'        => $value->debit_refer,
                                            // 'debit_total'        => $value->debit-$value->debit_drug-$value->debit_instument-$value->debit_toa-$value->debit_refer,
                                            'debit_total'        => $value->debit,   
                                            // 'debit_ucep'         => $value->debit_ucep,                         
                                            'max_debt_amount'    => $value->max_debt_amount,
                                            'rw'                 => $value->rw,
                                            'adjrw'              => $value->adjrw,
                                            'total_adjrw_income' => $value->total_adjrw_income, 
                                            'acc_debtor_userid'  => Auth::user()->id
                                        ]);
                                    } 
                                }
                            }   
                        } else {
                            if ($value->debit_toa > 0 ) {                     
                            } else {
                                   
                                if ($value->debit > 0) {                                       
                                    Acc_debtor::insert([
                                        'hn'                 => $value->hn,
                                        'an'                 => $value->an,
                                        'vn'                 => $value->vn,
                                        'cid'                => $value->cid,
                                        'ptname'             => $value->ptname,
                                        'pttype'             => $value->pttype,
                                        'vstdate'            => $value->vstdate,
                                        'rxdate'             => $value->admdate,
                                        'dchdate'            => $value->dchdate,
                                        'acc_code'           => $value->acc_code,
                                        'account_code'       => $value->account_code,
                                        'account_name'       => $value->account_name, 
                                        'income'             => $value->income,
                                        'uc_money'           => $value->uc_money,
                                        'discount_money'     => $value->discount_money, 
                                        'rcpt_money'         => $value->rcpt_money,
                                        'debit'              => $value->debit,
                                        'debit_drug'         => $value->debit_drug,
                                        'debit_instument'    => $value->debit_instument,
                                        'debit_toa'          => $value->debit_toa,
                                        'debit_refer'        => $value->debit_refer,
                                        // 'debit_total'        => $value->debit,
                                        'debit_total'        => $value->debit-$value->debit_drug-$value->debit_instument-$value->debit_toa-$value->debit_refer,  
                                        // 'debit_ucep'         => $value->debit_ucep,                                                             
                                        'max_debt_amount'    => $value->max_debt_amount,
                                        'rw'                 => $value->rw,
                                        'adjrw'              => $value->adjrw,
                                        'total_adjrw_income' => $value->total_adjrw_income, 
                                        'acc_debtor_userid'  => Auth::user()->id
                                    ]);
                                }
                            }   
                        }
                    }                
            } else { 
                if ($value->debit > 0) {                 
                        $check22 = Acc_debtor::where('an', $value->an)->where('account_code', '1102050101.202')->count();
                        if ($check22 == '0') { 
                            if ($value->debit_toa > '0' ) {                     
                            } else { 
                                if ($value->debit < '1') {                                     
                                } else {
                                    Acc_debtor::insert([
                                        'hn'                 => $value->hn,
                                        'an'                 => $value->an,
                                        'vn'                 => $value->vn,
                                        'cid'                => $value->cid,
                                        'ptname'             => $value->ptname,
                                        'pttype'             => $value->pttype,
                                        'vstdate'            => $value->vstdate,
                                        'rxdate'             => $value->admdate,
                                        'dchdate'            => $value->dchdate,
                                        'acc_code'           => $value->acc_code,
                                        'account_code'       => $value->account_code,
                                        'account_name'       => $value->account_name, 
                                        'income'             => $value->income,
                                        'uc_money'           => $value->uc_money,
                                        'discount_money'     => $value->discount_money, 
                                        'rcpt_money'         => $value->rcpt_money,
                                        'debit'              => $value->debit,
                                        'debit_drug'         => $value->debit_drug,
                                        'debit_instument'    => $value->debit_instument,
                                        'debit_toa'          => $value->debit_toa,
                                        'debit_refer'        => $value->debit_refer,
                                        'debit_total'        => $value->debit,
                                                          
                                        'max_debt_amount'    => $value->max_debt_amount,
                                        'rw'                 => $value->rw,
                                        'adjrw'              => $value->adjrw,
                                        'total_adjrw_income' => $value->total_adjrw_income, 
                                        'acc_debtor_userid'  => Auth::user()->id
                                    ]);
                                }
                            }                                                
                        }
                }
            }       
         }
         $acc_ucep = DB::connection('mysql')->select('SELECT an,sum_price_ipd,sum_price_ucep_all FROM acc_ucep_24');
         foreach ($acc_ucep as $key => $val_up) {
            $count_u = Acc_debtor::where('account_code', '1102050101.202')->where('an', $val_up->an)->count();
            if ($count_u > 0) {
                Acc_debtor::where('an',$val_up->an)->where('account_code', '1102050101.202')->update([  
                    'debit_total'    => $val_up->sum_price_ipd - $val_up->sum_price_ucep_all,
                    'debit_ucep'     => $val_up->sum_price_ucep_all,     
                ]);  
            }
           
         }
        $acc_norget = DB::connection('mysql')->select('
            SELECT an,debit,debit_instument,debit_drug,debit_toa,debit_refer,debit_ucep 
            FROM acc_debtor 
            WHERE dchdate BETWEEN "' . $startdate . '" AND "' . $enddate . '" 
            AND account_code = "1102050101.202"
            AND (debit_ucep IS NULL OR debit_ucep = "")
        ');
        foreach ($acc_norget as $key => $value_get) {   
                    Acc_debtor::where('an',$value_get->an)->where('account_code', '1102050101.202')->update([  
                        'debit_total'    => (($value_get->debit - $value_get->debit_instument) - ($value_get->debit_drug - $value_get->debit_toa)) - ($value_get->debit_refer),
                        'debit_cr'       => ($value_get->debit_instument + $value_get->debit_drug) + ($value_get->debit_toa + $value_get->debit_refer),     
                    ]); 
                    Acc_debtor::where('an',$value_get->an)->where('debit_total', '<', 0)->delete(); 
        }   
        // $deleted = DB::table('users')->where('votes', '>', 100)->delete();           
 
        return response()->json([

            'status'    => '200'
        ]);
     }
     public function account_pkucs202_pulldata_old(Request $request)
     {
         $date              = date('Y-m-d H:i:s');
         $startdate         = $request->datepicker;
         $enddate           = $request->datepicker2;
        //  $now_timestamp     = strtotime(date('Y-m-d H:i:s'));
        //  $now_timestamp     = strtotime(date('2023-09-25 18:19:00'));
        //  $diff_timestamp    = $now_timestamp - strtotime($date);
        //  if ($diff_timestamp < (86400 * 24)) {
        //      $data_ = DB::connection('mysql2')->select('   
        //                 SELECT SUM(op.sum_price) as sum_price
        //                 FROM ipt i
        //                 LEFT JOIN opitemrece op on i.an = op.an  
        //                 WHERE i.dchdate BETWEEN "'.$startdate.'" and "'.$enddate.'"                        
        //     '); 
        //  } else {
        //     # code...
        //  }        

        // dd($diff_timestamp);
        $data_ = DB::connection('mysql2')->select('   
                        SELECT i.vn,i.an,o.vstdate,i.dchdate,op.rxdate,op.rxtime
                        FROM ipt i
                        LEFT JOIN opitemrece op on i.an = op.an 
                        LEFT JOIN ovst o on o.an = op.an
                        left JOIN er_regist e on e.vn = i.vn
                        LEFT JOIN ipt_pttype ii on ii.an = i.an
                        LEFT JOIN pttype p on p.pttype = ii.pttype
                        WHERE i.dchdate BETWEEN "'.$startdate.'" and "'.$enddate.'"
                        and op.an is not null
                        and op.paidst ="02"
                        and p.hipdata_code ="ucs"                       
                        and e.er_emergency_level_id in("1","2")                       
                        group BY i.an
                        ORDER BY op.rxdate,op.rxtime ASC;
        '); 
        Acc_ucep_24::truncate();
        foreach ($data_ as $key => $val) {    
            Acc_ucep_24::insert([
                'vn'                => $val->vn, 
                'an'                => $val->an, 
                'vstdate'           => $val->vstdate, 
                'dchdate'           => $val->dchdate, 
                'rxdate'            => $val->rxdate, 
                'rxtime'            => $val->rxtime, 
            ]);
        }

        $data_2 = DB::connection('mysql')->select('SELECT an,dchdate,rxdate,rxtime FROM acc_ucep_24');
        foreach ($data_2 as $key => $val2) {   
            // $newweek = date('Y-m-d', strtotime($date . ' -1 week'));  
            $d1 = $val2->rxdate;
            $t1 = $val2->rxtime;
            $old_time2          = strtotime($t1);
            $now_timestamp     = strtotime(date($d1.''.$t1));
            $last_timestamp    = date('Y-m-d',strtotime($val2->dchdate));       
            // $diff_timestamp    = $now_timestamp - strtotime($val2->dchdate);
            // $old_time          = strtotime(date($d1.''.$t1));
            $last_time         = strtotime($val2->dchdate);
            $old_time          = strtotime($val2->rxdate);
            $diff_timestamp    = $last_time - $old_time;
            $dt = date('Y-m-d',strtotime($diff_timestamp));                //"2023-10-01" 
            $dtt = date('Y-m-d',$diff_timestamp); 
            // $dt24 = date($last_time,strtotime($diff_timestamp));  
            $hours = floor($diff_timestamp/(60*60));    
            // $old_timestamp2     = strtotime(date("2023-09-25"));
            // $now_timestamp2     = strtotime(date("'.$val2->dchdate.'"));
            // dd($hours);
            // dd($diff_timestamp);
            // if ($diff_timestamp < (86400 * 24)) {
                $data_3 = DB::connection('mysql2')->select('   
                           SELECT i.an,i.dchdate,op.vstdate,(select SUM(sum_price) from opitemrece where an = "'.$val2->an.'" and rxdate ="'.$val2->rxdate.'") as sum_price
                           FROM opitemrece op  
                            LEFT JOIN ovst o on o.an = op.an
                            LEFT JOIN ipt i on i.an = o.an
                            WHERE op.an = "'.$val2->an.'"
                            AND DATEDIFF(i.dchdate,op.vstdate)<="1"
                            AND hour(TIMEDIFF(concat(op.vstdate," ",o.vsttime),concat(op.rxdate," ",op.rxtime))) <="24"
                            GROUP BY op.an 
               '); 
               foreach($data_3 as $key => $val3) {
                    Acc_ucep_24::where('an',$val3->an)->update(['sum_price' => $val3->sum_price]);
               }
            // } else {
            //    # code...
            // }            
        }

        $acc_debtor = DB::connection('mysql2')->select(' 
                    SELECT ip.vn,a.an,a.hn,pt.cid,concat(pt.pname,pt.fname," ",pt.lname) ptname,a.regdate as admdate,a.dchdate as dchdate,v.vstdate,op.income as income_group
                    ,ipt.pttype,ipt.pttype_number,ipt.max_debt_amount ,ip.rw,ip.adjrw,ip.adjrw*8350 as total_adjrw_income ,ipt.nhso_ownright_pid ,a.income as income ,a.uc_money,a.rcpt_money,a.discount_money
                    ,CASE 
                    WHEN  ipt.pttype_number ="2" THEN "01" 
                    ELSE ec.code
                    END as code
                    ,CASE 
                    WHEN  ipt.pttype_number ="2" THEN "1102050101.202" 
                    ELSE ec.ar_ipd
                    END as account_code	
                    ,CASE 
                    WHEN  ipt.pttype_number ="2" THEN "UC ใน CUP" 
                    ELSE ec.name
                    END as account_name	 

                    ,CASE 
                    WHEN  ipt.pttype_number ="1" AND ipt.pttype IN ("31","33","36","39") THEN ipt.max_debt_amount 
                    ELSE a.income -IFNULL(ipt.max_debt_amount,"0") 
                    END as debit_prb 

                    ,(a.income-a.rcpt_money-a.discount_money-IFNULL(ipt.max_debt_amount,"0"))-
                    (sum(if(op.income="02",sum_price,0))) -
                    (sum(if(op.icode IN("1560016","1540073","1530005"),sum_price,0))) -
                    (sum(if(op.icode IN("3001412","3001417"),sum_price,0))) -
                    (sum(if(op.icode IN("3010829","3011068","3010864","3010861","3010862","3010863","3011069","3011012","3011070"),sum_price,0))) +
                    (sum(if(op.icode IN("3002895","3002896","3002897","3002898","3002909","3002910","3002911","3002912","3002913","3002914","3002915","3002916","3002918"),sum_price,0)))  
                    as debit

                    ,sum(if(op.icode IN("3002895","3002896","3002897","3002898","3002909","3002910","3002911","3002912","3002913","3002914","3002915","3002916","3002918"),sum_price,0)) as portex
                    ,sum(if(op.income="02",sum_price,0)) as debit_instument
                    ,sum(if(op.icode IN("1560016","1540073","1530005"),sum_price,0)) as debit_drug
                    ,sum(if(op.icode IN ("3001412","3001417"),sum_price,0)) as debit_toa
                    ,sum(if(op.icode IN("3010829","3011068","3010864","3010861","3010862","3010863","3011069","3011012","3011070"),sum_price,0)) as debit_refer

                    ,(
                        SELECT SUM(o.sum_price) as ucepprice
                                FROM ipt i
                                LEFT JOIN opitemrece o on i.an = o.an 
                                LEFT JOIN ovst a on a.an = o.an
                                left JOIN er_regist e on e.vn = i.vn
                                LEFT JOIN ipt_pttype ii on ii.an = i.an
                                LEFT JOIN pttype p on p.pttype = ii.pttype 
                                LEFT JOIN s_drugitems n on n.icode = o.icode
                                LEFT JOIN patient pt on pt.hn = a.hn 
                                WHERE i.dchdate BETWEEN "' . $startdate . '" AND "' . $enddate . '"
                                AND i.an = ip.an
                                AND o.income NOT IN ("02")
                                AND op.icode NOT IN ("3002895","3002896","3002897","3002898","3002909","3002910","3002911","3002912","3002913","3002914","3002915","3002916","3002918","1560016","1540073","1530005","3001412","3001417","3010829","3011068","3010864","3010861","3010862","3010863","3011069","3011012","3011070")
                                AND o.an is not null
                                AND o.paidst ="02"
                                AND p.hipdata_code ="ucs"
                                AND DATEDIFF(o.rxdate,a.vstdate)<="1"
                                AND hour(TIMEDIFF(concat(a.vstdate," ",a.vsttime),concat(o.rxdate," ",o.rxtime))) <="24"
                                AND e.er_emergency_type in("1","2","5")     
                    ) as debit_ucep

                    from ipt ip
                    LEFT JOIN an_stat a ON ip.an = a.an
                    LEFT JOIN patient pt on pt.hn=a.hn
                    LEFT JOIN pttype ptt on a.pttype=ptt.pttype
                    LEFT JOIN pttype_eclaim ec on ec.code=ptt.pttype_eclaim_id
                    LEFT JOIN ipt_pttype ipt ON ipt.an = a.an
                    LEFT JOIN opitemrece op ON ip.an = op.an
                    LEFT JOIN vn_stat v on v.vn = ip.vn
                WHERE a.dchdate BETWEEN "' . $startdate . '" AND "' . $enddate . '"              
                AND ipt.pttype IN (SELECT pttype FROM pkbackoffice.acc_setpang_type WHERE pang ="1102050101.202" AND opdipd ="IPD")                              
                GROUP BY a.an;
        ');
  
 
         foreach ($acc_debtor as $key => $value) {
            // $count_pttype = DB::connection('mysql2')->select('SELECT COUNT(an) as C_an FROM  ipt_pttype WHERE an = "'.$value->an.'" ');
            $count_pttype = DB::connection('mysql2')->table('ipt_pttype')->where('an', $value->an)->count();
            $total_ = $value->debit-$value->debit_drug-$value->debit_instument-$value->debit_toa-$value->debit_refer-$value->debit_ucep;
            // dd($count_pttype);
            if ($count_pttype > 1) {
                $check = Acc_debtor::where('an', $value->an)->where('account_code', '1102050101.202')->count();
                    if ($check == 0) {
                        if ($value->pttype_number == 2) {
                            if ($value->debit_toa > 0 ) {                     
                            } else {
                                if ($value->debit > 0) {    
                                    Acc_debtor::insert([
                                        'hn'                 => $value->hn,
                                        'an'                 => $value->an,
                                        'vn'                 => $value->vn,
                                        'cid'                => $value->cid,
                                        'ptname'             => $value->ptname,
                                        'pttype'             => $value->pttype,
                                        'vstdate'            => $value->vstdate,
                                        'rxdate'             => $value->admdate,
                                        'dchdate'            => $value->dchdate,
                                        'acc_code'           => $value->code,
                                        'account_code'       => $value->account_code,
                                        'account_name'       => $value->account_name, 
                                        'income'             => $value->income,
                                        'uc_money'           => $value->uc_money,
                                        'discount_money'     => $value->discount_money, 
                                        'rcpt_money'         => $value->rcpt_money,
                                        'debit'              => $value->debit,
                                        'debit_drug'         => $value->debit_drug,
                                        'debit_instument'    => $value->debit_instument,
                                        'debit_toa'          => $value->debit_toa,
                                        'debit_refer'        => $value->debit_refer,
                                        'debit_total'        => $value->debit,   
                                        'debit_ucep'         => $value->debit_ucep,                         
                                        'max_debt_amount'    => $value->max_debt_amount,
                                        'rw'                 => $value->rw,
                                        'adjrw'              => $value->adjrw,
                                        'total_adjrw_income' => $value->total_adjrw_income, 
                                        'acc_debtor_userid'  => Auth::user()->id
                                    ]);
                                } else {
                                    
                                }
                            }   
                        } else {
                            if ($value->debit_toa > 0 ) {                     
                            } else {
                                if ($total_ < 1) {   

                                } else {
                                    if ($value->debit > 0) {    
                                        Acc_debtor::insert([
                                            'hn'                 => $value->hn,
                                            'an'                 => $value->an,
                                            'vn'                 => $value->vn,
                                            'cid'                => $value->cid,
                                            'ptname'             => $value->ptname,
                                            'pttype'             => $value->pttype,
                                            'vstdate'            => $value->vstdate,
                                            'rxdate'             => $value->admdate,
                                            'dchdate'            => $value->dchdate,
                                            'acc_code'           => $value->code,
                                            'account_code'       => $value->account_code,
                                            'account_name'       => $value->account_name, 
                                            'income'             => $value->income,
                                            'uc_money'           => $value->uc_money,
                                            'discount_money'     => $value->discount_money, 
                                            'rcpt_money'         => $value->rcpt_money,
                                            'debit'              => $value->debit,
                                            'debit_drug'         => $value->debit_drug,
                                            'debit_instument'    => $value->debit_instument,
                                            'debit_toa'          => $value->debit_toa,
                                            'debit_refer'        => $value->debit_refer,
                                            'debit_total'        => $value->debit-$value->debit_drug-$value->debit_instument-$value->debit_toa-$value->debit_refer-$value->debit_ucep,  
                                            'debit_ucep'         => $value->debit_ucep,                                                             
                                            'max_debt_amount'    => $value->max_debt_amount,
                                            'rw'                 => $value->rw,
                                            'adjrw'              => $value->adjrw,
                                            'total_adjrw_income' => $value->total_adjrw_income, 
                                            'acc_debtor_userid'  => Auth::user()->id
                                        ]);
                                    } else {
                                       
                                    }
                                }
                            }   
                        }
                    }
                
            } else { 
                if ($value->debit > 0) {                 
                        $check = Acc_debtor::where('an', $value->an)->where('account_code', '1102050101.202')->count();
                        if ($check == '0') { 
                            if ($value->debit_toa > '0' ) {                     
                            } else {
                                if ($total_ < '1') {                                    
                                } else {
                                    Acc_debtor::insert([
                                        'hn'                 => $value->hn,
                                        'an'                 => $value->an,
                                        'vn'                 => $value->vn,
                                        'cid'                => $value->cid,
                                        'ptname'             => $value->ptname,
                                        'pttype'             => $value->pttype,
                                        'vstdate'            => $value->vstdate,
                                        'rxdate'             => $value->admdate,
                                        'dchdate'            => $value->dchdate,
                                        'acc_code'           => $value->code,
                                        'account_code'       => $value->account_code,
                                        'account_name'       => $value->account_name, 
                                        'income'             => $value->income,
                                        'uc_money'           => $value->uc_money,
                                        'discount_money'     => $value->discount_money, 
                                        'rcpt_money'         => $value->rcpt_money,
                                        'debit'              => $value->debit,
                                        'debit_drug'         => $value->debit_drug,
                                        'debit_instument'    => $value->debit_instument,
                                        'debit_toa'          => $value->debit_toa,
                                        'debit_refer'        => $value->debit_refer,
                                        'debit_total'        => $value->debit-$value->debit_drug-$value->debit_instument-$value->debit_toa-$value->debit_refer-$value->debit_ucep,  
                                        'debit_ucep'         => $value->debit_ucep,                          
                                        'max_debt_amount'    => $value->max_debt_amount,
                                        'rw'                 => $value->rw,
                                        'adjrw'              => $value->adjrw,
                                        'total_adjrw_income' => $value->total_adjrw_income, 
                                        'acc_debtor_userid'  => Auth::user()->id
                                    ]);
                                }
                            }                                                
                        }
                } else { 

                }
            }
                    
         }
        
 
        return response()->json([

            'status'    => '200'
        ]);
     }
     public function account_pkucs202_dash(Request $request)
     {
         $datenow = date('Y-m-d');
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
                     SELECT month(a.dchdate) as months,year(a.dchdate) as year,l.MONTH_NAME
                     ,count(distinct a.hn) as hn
                     ,count(distinct a.vn) as vn
                     ,count(distinct a.an) as an
                     ,sum(a.income) as income
                     ,sum(a.paid_money) as paid_money
                     ,sum(a.income)-sum(a.discount_money)-sum(a.rcpt_money) as total 
                     FROM acc_debtor a
                     left outer join leave_month l on l.MONTH_ID = month(a.dchdate)
                     WHERE a.dchdate between "'.$start.'" and "'.$end.'"
                     and account_code="1102050101.202" 
                     group by month(a.dchdate) order by a.dchdate desc limit 7;
             ');
             // and stamp = "N"
         } else {
             $datashow = DB::select('
                     SELECT month(a.dchdate) as months,year(a.dchdate) as year,l.MONTH_NAME
                     ,count(distinct a.hn) as hn
                     ,count(distinct a.vn) as vn
                     ,count(distinct a.an) as an
                     ,sum(a.income) as income
                     ,sum(a.paid_money) as paid_money
                     ,sum(a.income)-sum(a.discount_money)-sum(a.rcpt_money) as total 
                     FROM acc_debtor a
                     left outer join leave_month l on l.MONTH_ID = month(a.dchdate)
                     WHERE a.dchdate between "'.$startdate.'" and "'.$enddate.'"
                     and account_code="1102050101.202" 
             ');
         }
        //  group by month(a.dchdate) order by month(a.dchdate) desc;
             return view('account_202.account_pkucs202_dash',[
                 'startdate'     =>     $startdate,
                 'enddate'       =>     $enddate,
                 'datashow'    =>     $datashow,
                 'leave_month_year' =>  $leave_month_year,
             ]);
     }
     public function account_pkucs202(Request $request,$months,$year)
     {
         $datenow = date('Y-m-d');
         $startdate = $request->startdate;
         $enddate = $request->enddate;
         // dd($id);
         $data['users'] = User::get();
 
         $acc_debtor = DB::select('
             SELECT a.*,c.subinscl from acc_debtor a
             left outer join check_sit_auto c on c.cid = a.cid and c.vstdate = a.vstdate
 
             WHERE a.account_code="1102050101.202"
             AND a.stamp = "N"
             and month(a.dchdate) = "'.$months.'" and year(a.dchdate) = "'.$year.'"
             order by a.dchdate asc;
 
         ');
 
         return view('account_202.account_pkucs202', $data, [
             'startdate'     =>     $startdate,
             'enddate'       =>     $enddate,
             'acc_debtor'    =>     $acc_debtor,
             'months'        =>     $months,
             'year'          =>     $year
         ]);
     }
     public function account_pkucs202_detail(Request $request,$months,$year)
     {
         $datenow = date('Y-m-d');
         $startdate = $request->startdate;
         $enddate = $request->enddate;
         // dd($id);
         $data['users'] = User::get();
 
         $data = DB::select(' 
             SELECT *  from acc_1102050101_202
             WHERE month(dchdate) = "'.$months.'" and year(dchdate) = "'.$year.'"           
             GROUP BY an
         ');
        //  AND stamp = "Y"
         // SELECT *,au.subinscl  from acc_1102050101_202 a
         //     LEFT JOIN acc_debtor au ON au.an = a.an
         //     WHERE month(a.dchdate) = "'.$months.'" and year(a.dchdate) = "'.$year.'";
 
         return view('account_202.account_pkucs202_detail', $data, [
             'startdate'     =>     $startdate,
             'enddate'       =>     $enddate,
             'data'          =>     $data,
             'months'        =>     $months,
             'year'          =>     $year
         ]);
     }
     public function account_pkucs202_detail_date(Request $request,$startdate,$enddate)
     {
         $datenow = date('Y-m-d');
         $startdate = $request->startdate;
         $enddate = $request->enddate;
         // dd($id);
         $data['users'] = User::get();
 
         $data = DB::select(' 
             SELECT *  from acc_1102050101_202 
             WHERE dchdate BETWEEN "'.$startdate.'" AND  "'.$enddate.'" 
             AND status = "N"
         ');
         // SELECT *,au.subinscl  from acc_1102050101_202 a
         //     LEFT JOIN acc_debtor au ON au.an = a.an
         //     WHERE month(a.dchdate) = "'.$months.'" and year(a.dchdate) = "'.$year.'";
 
         return view('account_202.account_pkucs202_detail_date', $data, [
             'startdate'     =>     $startdate,
             'enddate'       =>     $enddate,
             'data'          =>     $data,
             'startdate'     =>     $startdate,
             'enddate'       =>     $enddate
         ]);
     }
     public function account_pkucs202_stam(Request $request)
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
                 $check = Acc_1102050101_202::where('an', $value->an)->count();
                 if ($check>0) {
                    # code...
                 } else {
                    Acc_1102050101_202::insert([
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
                        'income_group'      => $value->income_group,
                        'income'            => $value->income,
                        'uc_money'          => $value->uc_money,
                        'discount_money'    => $value->discount_money,
                        'rcpt_money'        => $value->rcpt_money,
                        'debit'             => $value->debit,
                        'debit_drug'        => $value->debit_drug,
                        'debit_instument'   => $value->debit_instument,
                        'debit_refer'       => $value->debit_refer,
                        'debit_toa'         => $value->debit_toa,
                       //  'debit_total'       => $value->debit - $value->debit_drug - $value->debit_instument - $value->debit_refer - $value->debit_toa,
                        'debit_total'       => $value->debit_total,
                        'debit_ucep'        => $value->debit_ucep,
                        'max_debt_amount'   => $value->max_debt_amount,
                        'rw'                => $value->rw,
                        'adjrw'             => $value->adjrw,
                        'total_adjrw_income'=> $value->total_adjrw_income,
                        'acc_debtor_userid' => $value->acc_debtor_userid

                          
                    ]);
                 }
                 
                    
                    //  $acc_opitemrece_ = DB::connection('mysql')->select('
                    //          SELECT a.stamp,ao.an,ao.vn,ao.hn,ao.vstdate,ao.pttype,ao.paidst,ao.finance_number,ao.income,ao.icode,ao.name as dname,ao.qty,ao.unitprice,ao.cost,ao.discount,ao.sum_price
                    //          FROM acc_opitemrece ao
                    //          LEFT JOIN acc_debtor a ON ao.an = a.an
                    //          WHERE a.account_code ="1102050101.202" AND a.stamp ="Y"
                    //          AND ao.an ="'.$value->an.'"
                    //  ');
                    //  foreach ($acc_opitemrece_ as $va2) {
                    //      Acc_opitemrece_stm::insert([
                    //          'hn'                 => $va2->hn,
                    //          'an'                 => $va2->an,
                    //          'vn'                 => $va2->vn,
                    //          'vstdate'            => $va2->vstdate,
                    //          'pttype'             => $va2->pttype,
                    //          'paidst'             => $va2->paidst,
                    //          'finance_number'     => $va2->finance_number,
                    //          'income'             => $va2->income,
                    //          'icode'              => $va2->icode,
                    //          'name'               => $va2->dname,
                    //          'qty'                => $va2->qty,
                    //          'cost'               => $va2->cost,
                    //          'unitprice'          => $va2->unitprice,
                    //          'discount'           => $va2->discount,
                    //          'sum_price'          => $va2->sum_price
                    //      ]);
 
                    //  }
         }
 
 
         return response()->json([
             'status'    => '200'
         ]);
     }
     public function account_pkucs202_stm(Request $request,$months,$year)
     {
         $datenow = date('Y-m-d');
         $startdate = $request->startdate;
         $enddate = $request->enddate;
         // dd($id);
         $data['users'] = User::get();
 
         $datashow = DB::select('
                SELECT s.tranid,a.vn,a.an,a.hn,a.cid,a.ptname,a.vstdate,a.dchdate,a.debit_total,s.dmis_money2
                ,s.total_approve,a.income_group,s.inst,s.hc,s.hc_drug,s.ae,s.ae_drug,s.ip_paytrue,s.STMdoc,a.adjrw,a.total_adjrw_income
                from acc_1102050101_202 a
             LEFT JOIN acc_stm_ucs s ON s.an = a.an
             WHERE month(a.dchdate) = "'.$months.'" and year(a.dchdate) = "'.$year.'" 
             AND s.ip_paytrue > "0.00"
             GROUP BY a.an
         ');
        //  AND s.rep IS NOT NULL 
        //  $sum_money_ = DB::connection('mysql')->select('
        //     SELECT SUM(a.debit_total) as total
        //     from acc_1102050101_202 a
        //     LEFT JOIN acc_stm_ucs au ON au.an = a.an
        //     WHERE month(a.dchdate) = "'.$months.'" and year(a.dchdate) = "'.$year.'" 
        //     AND au.rep IS NOT NULL;
        // ');
        // foreach ($sum_money_ as $key => $value) {
        //     $sum_debit_total = $value->total;
        // }
        //  $sum_stm_ = DB::connection('mysql')->select('
        //     SELECT SUM(au.inst) as stmtotal
        //     from acc_1102050101_202 a
        //     LEFT JOIN acc_stm_ucs au ON au.an = a.an
        //     WHERE month(a.dchdate) = "'.$months.'" and year(a.dchdate) = "'.$year.'" 
        //     AND au.rep IS NOT NULL;
        // ');
        // foreach ($sum_stm_ as $key => $value) {
        //     $sum_stm_total = $value->stmtotal;
        // }
 
         return view('account_202.account_pkucs202_stm', $data, [
             'startdate'         =>     $startdate,
             'enddate'           =>     $enddate,
             'datashow'          =>     $datashow,
             'months'            =>     $months,
             'year'              =>     $year,
            //  'sum_debit_total'   =>     $sum_debit_total,
            //  'sum_stm_total'     =>     $sum_stm_total
         ]);
     }
     public function account_pkucs202_stm_date(Request $request,$startdate,$enddate)
     { 
         $data['users'] = User::get();
 
         $datashow = DB::select('
                SELECT s.tranid,a.vn,a.an,a.hn,a.cid,a.ptname,a.vstdate,a.dchdate,a.debit_total,s.dmis_money2
                ,s.total_approve,a.income_group,s.inst,s.hc,s.hc_drug,s.ae,s.ae_drug,s.ip_paytrue,s.STMdoc,a.adjrw,a.total_adjrw_income
                from acc_1102050101_202 a
             LEFT JOIN acc_stm_ucs s ON s.an = a.an
             WHERE a.dchdate BETWEEN "'.$startdate.'" AND  "'.$enddate.'" 
            
             AND s.ip_paytrue > "0.00"
            
         ');
        //  AND s.rep IS NOT NULL
        // GROUP BY a.an
         return view('account_202.account_pkucs202_stm_date', $data, [
             'startdate'         =>     $startdate,
             'enddate'           =>     $enddate,
             'datashow'          =>     $datashow, 
         ]);
     }
     public function account_pkucs202_stmnull(Request $request,$months,$year)
     {
         $datenow = date('Y-m-d');
         $startdate = $request->startdate;
         $enddate = $request->enddate;
         // dd($id);
         $data['users'] = User::get();
 
            $data = DB::connection('mysql')->select('
                SELECT au.tranid,a.vn,a.an,a.hn,a.cid,a.ptname,a.vstdate,a.dchdate,a.debit_total,au.dmis_money2,au.total_approve,a.income_group,au.inst,au.ip_paytrue,a.adjrw,a.total_adjrw_income
                from acc_1102050101_202 a
                LEFT JOIN acc_stm_ucs au ON au.an = a.an
                WHERE month(a.dchdate) = "'.$months.'" and year(a.dchdate) = "'.$year.'"            
                AND (au.rep IS NULL OR au.ip_paytrue = "0.00")
                GROUP BY a.an 
             ');
            //  AND au.rep IS NULL 
             // SELECT vn,an,hn,cid,ptname,dchdate,income_group,debit_total
             // ,inst
             // FROM acc_1102050101_202
             // WHERE status ="N"
            $sum_money_ = DB::connection('mysql')->select('
                SELECT SUM(a.debit_total) as total
                from acc_1102050101_202 a
                LEFT JOIN acc_stm_ucs au ON au.an = a.an
                WHERE month(a.dchdate) = "'.$months.'" and year(a.dchdate) = "'.$year.'" AND au.rep IS NULL;
            ');
            foreach ($sum_money_ as $key => $value) {
                $sum_debit_total = $value->total;
            }
            $sum_stm_ = DB::connection('mysql')->select('
                SELECT SUM(au.inst) as stmtotal
                from acc_1102050101_202 a
                LEFT JOIN acc_stm_ucs au ON au.an = a.an
                WHERE month(a.dchdate) = "'.$months.'" and year(a.dchdate) = "'.$year.'" AND au.rep IS NULL;
            ');
            foreach ($sum_stm_ as $key => $value) {
                $sum_stm_total = $value->stmtotal;
            }
 
         return view('account_202.account_pkucs202_stmnull', $data, [
             'startdate'         =>     $startdate,
             'enddate'           =>     $enddate,
             'data'              =>     $data,
             'months'            =>     $months,
             'year'              =>     $year,
             'sum_debit_total'   =>     $sum_debit_total,
             'sum_stm_total'     =>     $sum_stm_total
         ]);
     }
     public function account_pkucs202_stmnull_date(Request $request,$startdate,$enddate)
     { 
         $data['users'] = User::get();
 
            $data = DB::connection('mysql')->select('
            SELECT au.tranid,a.vn,a.an,a.hn,a.cid,a.ptname,a.vstdate,a.dchdate,a.debit_total,au.dmis_money2,au.total_approve,a.income_group
            ,au.hc,au.hc_drug,au.ae,au.ae_drug,au.inst,au.ip_paytrue,au.STMdoc,a.adjrw,a.total_adjrw_income
            from acc_1102050101_202 a
            LEFT JOIN acc_stm_ucs au ON au.an = a.an
            WHERE a.dchdate BETWEEN "'.$startdate.'" AND  "'.$enddate.'"   
            AND au.ip_paytrue <= "0.00"
          
             ');
            //  GROUP BY a.an
            //  WHERE status ="N" AND a.dchdate BETWEEN "'.$startdate.'" AND  "'.$enddate.'"  
 
         return view('account_202.account_pkucs202_stmnull_date', $data, [
             'startdate'         =>     $startdate,
             'enddate'           =>     $enddate,
             'data'              =>     $data, 
         ]);
     }
     public function account_pkucs202_stmnull_all(Request $request,$months,$year)
     {
         $datenow = date('Y-m-d');
         $startdate = $request->startdate;
         $enddate = $request->enddate;
         // dd($id);
         $data['users'] = User::get();
         $mototal = $months + 1;
         $datashow = DB::connection('mysql')->select(' 
 
                 SELECT au.tranid,a.vn,a.an,a.hn,a.cid,a.ptname,a.vstdate,a.dchdate,a.debit_total,au.dmis_money2,au.total_approve,a.income_group
                 ,au.hc,au.hc_drug,au.ae,au.ae_drug,au.inst,au.ip_paytrue ,au.STMdoc,a.adjrw,a.total_adjrw_income
                from acc_1102050101_202 a
                LEFT JOIN acc_stm_ucs au ON au.an = a.an
                WHERE month(a.dchdate) < "'.$mototal.'"
                and year(a.dchdate) = "'.$year.'"
                AND (au.ip_paytrue IS NULL OR au.ip_paytrue <= "0.00")
                GROUP BY a.an  
             ');
         return view('account_202.account_pkucs202_stmnull_all', $data, [
             'startdate'         =>     $startdate,
             'enddate'           =>     $enddate,
             'datashow'          =>     $datashow,
             'months'            =>     $months,
             'year'              =>     $year,
         ]);
     }
     public function account_202_destroy(Request $request)
    {
        $id = $request->ids; 
        $data = Acc_debtor::whereIn('acc_debtor_id',explode(",",$id))->get();
            Acc_debtor::whereIn('acc_debtor_id',explode(",",$id))->delete();
                  
        return response()->json([
            'status'    => '200'
        ]);
    }
    
   
 

 }