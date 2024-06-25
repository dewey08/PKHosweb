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
use App\Models\Acc_1102050101_503;

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


class Account503Controller extends Controller
 {
        
    public function account_503_dash(Request $request)
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
                    ,count(distinct a.hn) as hn
                    ,count(distinct a.vn) as vn
                    ,sum(a.paid_money) as paid_money
                    ,sum(a.income) as income
                    ,sum(a.income)-sum(a.discount_money)-sum(a.rcpt_money) as total
                    FROM acc_debtor a
                    left outer join leave_month l on l.MONTH_ID = month(a.vstdate)
                    WHERE a.vstdate between "'.$start.'" and "'.$end.'"
                    and account_code="1102050101.503"
                    and income <> 0
                    group by month(a.vstdate) order by a.vstdate desc limit 6;
            ');
        } else {
            $datashow = DB::select('
                SELECT month(a.vstdate) as months,year(a.vstdate) as year,l.MONTH_NAME
                    ,count(distinct a.hn) as hn
                    ,count(distinct a.vn) as vn
                    ,sum(a.paid_money) as paid_money
                    ,sum(a.income) as income
                    ,sum(a.income)-sum(a.discount_money)-sum(a.rcpt_money) as total
                    FROM acc_debtor a
                    left outer join leave_month l on l.MONTH_ID = month(a.vstdate)
                    WHERE a.vstdate between "'.$startdate.'" and "'.$enddate.'"
                    and account_code="1102050101.503"
                    and income <>0
                    
            ');
        }

        return view('account_503.account_503_dash',[
            'startdate'        => $startdate,
            'enddate'          => $enddate,
            'leave_month_year' => $leave_month_year,
            'datashow'         => $datashow,
            'newyear'          => $newyear,
            'date'             => $date,
        ]);
    }
    public function account_503_pull(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        if ($startdate == '') { 
                $acc_debtor = DB::select(' 
                    SELECT a.acc_debtor_id,a.vn,a.an,a.hn,a.cid,a.ptname,a.vstdate,a.pttype,a.debit_total,c.subinscl,a.hospmain,a.income,a.rcpt_money,a.nationality,a.toklong                  
                    from acc_debtor a
                    left join check_sit_auto c on c.vn = a.vn  
                    WHERE a.account_code="1102050101.503"
                    AND a.stamp = "N"
                    GROUP BY a.vn
                    order by a.vstdate asc; 
                ');            
        } else {
        }

        return view('account_503.account_503_pull',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'acc_debtor'    =>     $acc_debtor,
        ]);
    }

    public function account_503_pulldata(Request $request)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->datepicker;
        $enddate = $request->datepicker2; 
        // $acc_debtor = DB::connection('mysql2')->select('  
        //             SELECT o.vn,o.an,o.hn,pt.cid,concat(pt.pname,pt.fname," ",pt.lname) ptname
        //             ,o.vstdate,o.vsttime,pt.nationality
        //             ,v.hospmain,"" regdate,"" dchdate,op.income as income_group  
        //             ,ptt.pttype_eclaim_id,vp.pttype
        //             ,"22" as acc_code
        //             ,"1102050101.503" as account_code
        //             ,"ลูกหนี้ค่ารักษา-แรงงานต่างด้าว OPนอกCUP" as account_name
        //             ,v.income,v.uc_money,v.discount_money,v.paid_money,v.rcpt_money 
        //             ,v.income-v.discount_money-v.rcpt_money as debit
        //             ,if(op.icode IN ("3010058"),sum_price,0) as fokliad
        //             ,sum(if(op.income="02",sum_price,0)) as debit_instument
        //             ,sum(if(op.icode IN("1560016","1540073","1530005","1540048","1620015","1600012","1600015"),sum_price,0)) as debit_drug
        //             ,sum(if(op.icode IN("3001412","3001417"),sum_price,0)) as debit_toa
        //             ,sum(if(op.icode IN("3010829","3011068","3010864","3010861","3010862","3010863","3011069","3011012","3011070"),sum_price,0)) as debit_refer
        //             ,ptt.max_debt_money
        //             from ovst o
        //             left join vn_stat v on v.vn=o.vn
        //             left join patient pt on pt.hn=o.hn
        //             LEFT JOIN visit_pttype vp on vp.vn = v.vn
        //             LEFT JOIN pttype ptt on o.pttype=ptt.pttype
        //             LEFT JOIN pttype_eclaim e on e.code=ptt.pttype_eclaim_id
        //             LEFT JOIN opitemrece op ON op.vn = o.vn
        //             WHERE o.vstdate BETWEEN "' . $startdate . '" AND "' . $enddate . '"
        //             AND vp.pttype IN(SELECT pttype FROM pkbackoffice.acc_setpang_type WHERE pang ="1102050101.503" AND opdipd = "OPD")
        //             AND v.hospmain IN(SELECT hospmain FROM pkbackoffice.acc_setpang_type WHERE pang ="1102050101.503") 
        //             AND pt.nationality <> "99"
        //             AND v.income <> 0
        //             and (o.an="" or o.an is null)
        //             GROUP BY v.vn
 
        // ');
        // AND v.hospmain IN(SELECT hospmain FROM pkbackoffice.acc_setpang_type WHERE pang ="1102050101.701")
        $acc_debtor = DB::connection('mysql2')->select(' 
                SELECT * FROM
                (
                    SELECT i.an,v.hn,v.vn,v.cid,v.vstdate,i.dchdate,concat(p.pname,p.fname," ",p.lname) as ptname,v.pttype,d.cc,h.hospcode,ro.icd10 as referin_no,h.name as hospmain,p.nationality
                    ,"07" as acc_code,"1102050101.503" as account_code,"ลูกหนี้ค่ารักษา-คนต่างด้าวและแรงงานต่างด้าว OP นอก CUP" as account_name,v.pdx,v.dx0
                    ,v.income,v.uc_money ,v.discount_money,v.rcpt_money,v.paid_money,v.income-v.discount_money-v.rcpt_money as debit  
                   
                    ,case
                    when v.uc_money < 1000 then v.uc_money
                    else "1000"
                    end as toklong

                    from vn_stat v
                    left outer join ipt i on i.vn = v.vn
                    left outer join patient p on p.hn = v.hn
                    left outer join pttype pt on pt.pttype =v.pttype 
                    left outer join icd101 oo on oo.code IN(v.pdx,v.dx0,v.dx1,v.dx2,v.dx3,v.dx4,v.dx5 )
                    left outer join opdscreen d on d.vn = v.vn
                    left outer join hospcode h on h.hospcode = v.hospmain 
                    left outer join referin ro on ro.vn = v.vn  
                    where v.vstdate BETWEEN "' . $startdate . '" AND "' . $enddate . '"
                    and i.an is null AND v.uc_money <> 0 AND p.nationality <> "99"   
                    and v.pttype IN(SELECT pttype FROM pkbackoffice.acc_setpang_type WHERE pang ="1102050101.503" AND opdipd = "OPD")
                    and (v.pdx not like "c%" and v.pdx not like "b24%" and v.pdx not like "n185%" )                        
                    and (oo.code  BETWEEN "E110" and "E149" or oo.code  BETWEEN "I10" and "I150" or oo.code  BETWEEN "J440" and "J449")
                    group by v.vn
            
                    UNION
            
                    SELECT i.an,v.hn,v.vn,v.cid,v.vstdate,i.dchdate,concat(p.pname,p.fname," ",p.lname) as ptname,v.pttype,d.cc,h.hospcode,ro.icd10 as referin_no,h.name as hospmain,p.nationality
                    ,"07" as acc_code,"1102050101.503" as account_code,"ลูกหนี้ค่ารักษา-คนต่างด้าวและแรงงานต่างด้าว OP นอก CUP" as account_name,v.pdx,v.dx0
                    ,v.income,v.uc_money ,v.discount_money,v.rcpt_money,v.paid_money,v.income-v.discount_money-v.rcpt_money as debit  
                    
                    ,case
                    when v.uc_money < 700 then v.uc_money
                    else "700"
                    end as toklong
                    
                    from vn_stat v
                    left outer join ipt i on i.vn = v.vn
                    left outer join patient p on p.hn = v.hn
                    left outer join pttype pt on pt.pttype =v.pttype 
                    left outer join ovstdiag oo on oo.vn = v.vn
                    left outer join opdscreen d on d.vn = v.vn
                    left outer join hospcode h on h.hospcode = v.hospmain 
                    left outer join referin ro on ro.vn = v.vn 
            
                    where v.vstdate BETWEEN "' . $startdate . '" AND "' . $enddate . '"
                    and i.an is null AND v.uc_money <> 0  AND p.nationality <> "99"  
                    and v.pttype IN(SELECT pttype FROM pkbackoffice.acc_setpang_type WHERE pang ="1102050101.503" AND opdipd = "OPD")
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
        foreach ($acc_debtor as $key => $value) {
            // $check = Acc_debtor::where('vn', $value->vn)->where('account_code','1102050101.503')->whereBetween('vstdate', [$startdate, $enddate])->count();
                    $check = Acc_debtor::where('vn', $value->vn)->where('account_code','1102050101.503')->count();
                    if ($check == 0) {
                        Acc_debtor::insert([
                            'hn'                 => $value->hn,
                            'an'                 => $value->an,
                            'vn'                 => $value->vn,
                            'cid'                => $value->cid,
                            'ptname'             => $value->ptname,
                            'pttype'             => $value->pttype,
                            'nationality'        => $value->nationality,
                            'hospmain'           => $value->hospmain,
                            'vstdate'            => $value->vstdate,
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
                            // 'debit_drug'         => $value->debit_drug,
                            // 'debit_instument'    => $value->debit_instument,
                            // 'debit_toa'          => $value->debit_toa,
                            // 'debit_refer'        => $value->debit_refer,
                            'debit_total'        => $value->debit,
                            'toklong'            => $value->toklong, 
                            // 'max_debt_amount'    => $value->max_debt_money,
                            'acc_debtor_userid'  => Auth::user()->id
                        ]);
                    }

        }

            return response()->json([

                'status'    => '200'
            ]);
    }
    public function account_503_stam(Request $request)
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
             $check = Acc_1102050101_503::where('vn', $value->vn)->count();
                
                if ($check > 0) {
                # code...
                } else {
                    Acc_1102050101_503::insert([
                            'vn'                => $value->vn,
                            'hn'                => $value->hn,
                            'an'                => $value->an,
                            'cid'               => $value->cid,
                            'ptname'            => $value->ptname,
                            'vstdate'           => $value->vstdate,
                            'regdate'           => $value->regdate,
                            'dchdate'           => $value->dchdate,
                            'hospmain'          => $value->hospmain,
                            'nationality'       => $value->nationality,
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
                            'toklong'           => $value->toklong,
                            'max_debt_amount'   => $value->max_debt_amount,
                            'acc_debtor_userid' => $iduser
                    ]);
                }

        }
        return response()->json([
            'status'    => '200'
        ]);
    }
    public function account_503_detail(Request $request,$months,$year)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        // dd($id);
        $data['users'] = User::get();

        $data = DB::select('
        SELECT U1.vn,U1.an,U1.hn,U1.cid,U1.ptname,U1.vstdate,U1.pttype,U1.debit_total,U1.hospmain,U1.hospmain,U1.income,U1.rcpt_money,U1.nationality,U1.toklong
            from acc_1102050101_503 U1
            WHERE month(U1.vstdate) = "'.$months.'" AND year(U1.vstdate) = "'.$year.'" 
            GROUP BY U1.vn
        ');
        // WHERE month(U1.vstdate) = "'.$months.'" and year(U1.vstdate) = "'.$year.'"
        return view('account_503.account_503_detail', $data, [ 
            'data'          =>     $data,
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate
        ]);
    }
   

    public function account_503_detail_date(Request $request,$startdate,$enddate)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        // dd($id);
        $data['users'] = User::get();

        $data = DB::select('
        SELECT U1.vn,U1.an,U1.hn,U1.cid,U1.ptname,U1.vstdate,U1.pttype,U1.debit_total,U1.hospmain,U1.hospmain,U1.income,U1.rcpt_money ,U1.nationality,U1.toklong
            from acc_1102050101_503 U1
            WHERE U1.vstdate BETWEEN "'.$startdate.'" AND  "'.$enddate.'" 
            GROUP BY U1.vn
        ');
        // WHERE month(U1.vstdate) = "'.$months.'" and year(U1.vstdate) = "'.$year.'"
        return view('account_503.account_503_detail_date', $data, [ 
            'data'          =>     $data,
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate
        ]);
    }
    public function account_503_destroy(Request $request)
    {
        $id = $request->ids;
        // $iduser = Auth::user()->id;
        // $data = Acc_debtor::whereIn('acc_debtor_id',explode(",",$id))->get();
        Acc_debtor::whereIn('acc_debtor_id',explode(",",$id))->delete();
               
        return response()->json([
            'status'    => '200'
        ]);
    }
    
 

 }