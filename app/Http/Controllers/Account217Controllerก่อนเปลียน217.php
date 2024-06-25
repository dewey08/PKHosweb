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


class Account217Controller extends Controller
 { 
    public function account_pkucs217_pull(Request $request)
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
                left join checksit_hos c on c.an = a.an
                WHERE a.account_code="1102050101.217"
                AND a.stamp = "N"
                group by a.an
                order by a.vstdate desc;
            ');
            // AND a.dchdate BETWEEN "'.$startdate.'" AND "'.$enddate.'"

            // SELECT a.*,c.subinscl from acc_debtor a
            // left outer join check_sit_auto c on c.cid = a.cid and c.vstdate = a.vstdate
            // WHERE a.account_code="1102050101.217"
            // AND a.stamp = "N"
            // and month(a.dchdate) = "'.$months.'" and year(a.dchdate) = "'.$year.'"
            // order by a.dchdate asc;
        } else {
            $acc_debtor = DB::select('
                SELECT a.*,c.subinscl from acc_debtor a
                left join checksit_hos c on c.an = a.an
                WHERE a.account_code="1102050101.217"
                AND a.stamp = "N"
                group by a.an
                order by a.vstdate desc;
            ');
            // $acc_debtor = Acc_debtor::where('stamp','=','N')->whereBetween('dchdate', [$startdate, $enddate])->get();
        }
        return view('account_217.account_pkucs217_pull',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'acc_debtor'    =>     $acc_debtor,
        ]);
    }
    public function account_pkucs217_pulldata(Request $request)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->datepicker;
        $enddate = $request->datepicker2;
        $acc_debtor = DB::connection('mysql3')->select('
                SELECT a.vn,a.an,a.hn,pt.cid,concat(pt.pname,pt.fname," ",pt.lname) fullname
                    ,a.regdate as admdate,a.dchdate as dchdate,v.vstdate,op.income as income_group
                    ,a.pttype,ptt.max_debt_money,ec.code,ec.ar_ipd as account_code
                    ,ec.name as account_name,ifnull(ec.ar_ipd,"") pang_debit
                    ,a.income as income ,a.uc_money,a.rcpt_money as cash_money,a.discount_money
                    ,a.income-a.rcpt_money-a.discount_money as looknee_money
                    ,sum(if(op.income="02",sum_price,0)) as debit_instument
                    ,sum(if(op.icode IN("1560016","1540073","1530005","1540048","1620015","1600012","1600015"),sum_price,0)) as debit_drug
                    ,sum(if(op.icode IN ("3001412","3001417"),sum_price,0)) as debit_toa
                    ,sum(if(op.icode IN ("3010829","3010726 "),sum_price,0)) as debit_refer
                    from ipt ip
                    LEFT JOIN hos.an_stat a ON ip.an = a.an
                    LEFT JOIN patient pt on pt.hn=a.hn
                    LEFT JOIN pttype ptt on a.pttype=ptt.pttype
                    LEFT JOIN pttype_eclaim ec on ec.code=ptt.pttype_eclaim_id
                    LEFT JOIN hos.ipt_pttype ipt ON ipt.an = a.an
                    LEFT JOIN hos.opitemrece op ON ip.an = op.an
                    LEFT JOIN hos.vn_stat v on v.vn = a.vn
                WHERE a.dchdate BETWEEN "' . $startdate . '" AND "' . $enddate . '"
                AND ec.ar_ipd IN("1102050101.217","1102050101.202")
                GROUP BY a.an;
        ');
        foreach ($acc_debtor as $key => $value) {
                    $check = Acc_debtor::where('an', $value->an)->whereBetween('dchdate', [$startdate, $enddate])->count();
                    if ($check == 0) {
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
                            'acc_code'           => $value->code,
                            'account_code'       => $value->account_code,
                            'account_name'       => $value->account_name,
                            'income_group'       => $value->income_group,
                            'income'             => $value->income,
                            'uc_money'           => $value->uc_money,
                            'discount_money'     => $value->discount_money,
                            'paid_money'         => $value->cash_money,
                            'rcpt_money'         => $value->cash_money,
                            'debit'              => $value->looknee_money,
                            'debit_drug'         => $value->debit_drug,
                            'debit_instument'    => $value->debit_instument,
                            'debit_toa'          => $value->debit_toa,
                            'debit_refer'        => $value->debit_refer,
                            'debit_total'        => $value->looknee_money,
                            'max_debt_amount'    => $value->max_debt_money,
                            'acc_debtor_userid'  => Auth::user()->id
                        ]);
                    }
                    if ($value->debit_toa > 0) {
                            Acc_debtor::where('an', $value->an)->where('account_code', '1102050101.202')->whereBetween('dchdate', [$startdate, $enddate])
                            ->update([
                                'acc_code'         => "03",
                                'account_code'     => "1102050101.217",
                                'account_name'     => "บริการเฉพาะ(CR)"
                            ]);
                    }
                    if ($value->debit_instument > 0 && $value->pang_debit =='1102050101.202') {
                            $checkins = Acc_debtor::where('an', $value->an)->where('account_code', '1102050101.217')->count();
                            if ($checkins == 0) {
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
                                    'acc_code'           => "03",
                                    'account_code'       => '1102050101.217',
                                    'account_name'       => 'บริการเฉพาะ(CR)',
                                    'income_group'       => '02',
                                    'debit'              => $value->debit_instument,
                                    'debit_total'        => $value->debit_instument
                                ]);
                            }
                    }
                    if ($value->debit_drug > 0 && $value->pang_debit =='1102050101.202') {
                            $checkindrug = Acc_debtor::where('an', $value->an)->where('account_code', '1102050101.217')->where('debit','=',$value->debit_drug)->count();
                            if ($checkindrug == 0) {
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
                                    'acc_code'           => "03",
                                    'account_code'       => '1102050101.217',
                                    'account_name'       => 'บริการเฉพาะ(CR)',
                                    'income_group'       => '03',
                                    'debit'              => $value->debit_drug,
                                    'debit_total'    => $value->debit_drug
                                ]);
                            }
                    }
                    if ($value->debit_refer > 0 && $value->pang_debit =='1102050101.202') {
                        $checkinrefer = Acc_debtor::where('an', $value->an)->where('account_code', '1102050101.217')->where('debit','=',$value->debit_refer)->count();
                        if ($checkinrefer == 0) {
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
                                'acc_code'           => "03",
                                'account_code'       => '1102050101.217',
                                'account_name'       => 'บริการเฉพาะ(CR)',
                                'income_group'       => '20',
                                'debit'              => $value->debit_refer,
                                'debit_total'        => $value->debit_refer
                            ]);
                        }
                    }

                    // Acc_opitemrece::where('an', '=', $value->an)->delete();

                    // $acc_opitemrece_ = DB::connection('mysql3')->select('
                    //         SELECT a.vn,o.an,o.hn,o.vstdate,o.rxdate,a.dchdate,o.income as income_group,o.pttype,o.paidst
                    //         ,o.icode,s.name as iname,o.qty,o.cost,o.finance_number,o.unitprice,o.discount,o.sum_price
                    //         FROM opitemrece o
                    //         LEFT JOIN an_stat a ON o.an = a.an
                    //         left outer join s_drugitems s on s.icode = o.icode
                    //         WHERE o.an ="'.$value->an.'"
                    // ');
                    // foreach ($acc_opitemrece_ as $key => $va2) {
                    //     Acc_opitemrece::insert([
                    //         'hn'                 => $va2->hn,
                    //         'an'                 => $va2->an,
                    //         'vn'                 => $va2->vn,
                    //         'pttype'             => $va2->pttype,
                    //         'paidst'             => $va2->paidst,
                    //         'rxdate'             => $va2->rxdate,
                    //         'vstdate'            => $va2->vstdate,
                    //         'dchdate'            => $va2->dchdate,
                    //         'income'             => $va2->income_group,
                    //         'icode'              => $va2->icode,
                    //         'name'               => $va2->iname,
                    //         'qty'                => $va2->qty,
                    //         'cost'               => $va2->cost,
                    //         'finance_number'     => $va2->finance_number,
                    //         'unitprice'          => $va2->unitprice,
                    //         'discount'           => $va2->discount,
                    //         'sum_price'          => $va2->sum_price,
                    //     ]);
                    // }
        }
        return response()->json([
            'status'    => '200'
        ]);
    }
    public function account_pkucs217_dash(Request $request)
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

        if ($startdate == '') {
            $datashow = DB::select('
                    SELECT month(a.dchdate) as months,year(a.dchdate) as year,l.MONTH_NAME
                    ,count(distinct a.hn) as hn
                    ,count(distinct a.vn) as vn
                    ,count(distinct a.an) as an
                    ,sum(a.income) as income
                    ,sum(a.paid_money) as paid_money
                    ,sum(a.income)-sum(a.discount_money)-sum(a.rcpt_money) as total
                    ,sum(a.debit) as debit
                    FROM acc_debtor a
                    left outer join leave_month l on l.MONTH_ID = month(a.dchdate)
                    WHERE a.dchdate between "'.$newyear.'" and "'.$date.'"
                    and account_code="1102050101.217"
                    group by month(a.dchdate) order by month(a.dchdate) desc limit 3;
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
                    ,sum(a.debit) as debit
                    FROM acc_debtor a
                    left outer join leave_month l on l.MONTH_ID = month(a.dchdate)
                    WHERE a.dchdate between "'.$startdate.'" and "'.$enddate.'"
                    and account_code="1102050101.217"
                    group by month(a.dchdate) order by month(a.dchdate) desc;
            ');
        }

        return view('account_217.account_pkucs217_dash',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'datashow'    =>     $datashow,
            'leave_month_year' =>  $leave_month_year,
        ]);
    }
    public function account_pkucs217(Request $request,$months,$year)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        // dd($id);
        $data['users'] = User::get();

        $acc_debtor = DB::select('
            SELECT * from acc_debtor
            WHERE account_code="1102050101.217"
            AND stamp = "N"
            and account_code="1102050101.217"
            and month(dchdate) = "'.$months.'" and year(dchdate) = "'.$year.'"
            order by dchdate asc;
        ');

        return view('account_217.account_pkucs217', $data, [
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'acc_debtor'    =>     $acc_debtor,
            'months'        =>     $months,
            'year'          =>     $year
        ]);
    }
    public function account_pkucs217_detail(Request $request,$months,$year)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        // dd($id);
        $data['users'] = User::get();

        $data = DB::select('
            SELECT *  from acc_1102050101_217
            WHERE month(dchdate) = "'.$months.'" and year(dchdate) = "'.$year.'"
            AND status = "N"
        ');

        return view('account_217.account_pkucs217_detail', $data, [
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'data'          =>     $data,
            'months'        =>     $months,
            'year'          =>     $year
        ]);
    }
    public function account_pkucs217_stam(Request $request)
    {
        $id = $request->ids;
        $iduser = Auth::user()->id;
        Acc_1102050101_217_stam::truncate();
        $data = Acc_debtor::whereIn('acc_debtor_id',explode(",",$id))->get();
            Acc_debtor::whereIn('acc_debtor_id',explode(",",$id))
                    ->update([
                        'stamp' => 'Y'
                    ]);

        foreach ($data as $key => $value) {
            Acc_1102050101_217_stam::insert([
                'vn'                => $value->vn,
                'hn'                => $value->hn,
                'an'                => $value->an,
                'cid'               => $value->cid,
                'ptname'            => $value->ptname,
                'vstdate'           => $value->vstdate,
                'regdate'           => $value->regdate,
                'dchdate'           => $value->dchdate,
                'pttype'            => $value->pttype,
                'income_group'      => $value->income_group,
                'account_code'      => $value->account_code,
                'debit'             => $value->debit,
                'debit_total'       => $value->debit_total,
                'acc_debtor_userid' => $iduser
            ]);
        }
        $acc_217_stam = DB::connection('mysql')->select('
            SELECT vn,an,hn,cid,ptname,vstdate,dchdate,pttype,income_group,account_code,sum(debit) as debit,sum(debit_total) as debit_total,acc_debtor_userid
            from acc_1102050101_217_stam
            GROUP BY an;
        ');
        foreach ($acc_217_stam as $key => $value2) {
                Acc_1102050101_217::insert([
                'vn'                => $value2->vn,
                'hn'                => $value2->hn,
                'an'                => $value2->an,
                'cid'               => $value2->cid,
                'ptname'            => $value2->ptname,
                'vstdate'           => $value2->vstdate,
                'dchdate'           => $value2->dchdate,
                'pttype'            => $value2->pttype,
                'income_group'      => $value2->income_group,
                'account_code'      => $value2->account_code,
                'debit'             => $value2->debit,
                'debit_total'       => $value2->debit_total,
                'acc_debtor_userid' => $value2->acc_debtor_userid
            ]);

        }
        $acc_opitemrece_ = DB::connection('mysql')->select('
                SELECT * from

                (SELECT ao.an,ao.vn,ao.hn,ao.vstdate,ao.pttype,ao.paidst,ao.finance_number,ao.income,ao.icode,ao.name as dname,ao.qty,ao.unitprice,ao.cost,ao.discount,ao.sum_price
                FROM acc_opitemrece ao
                LEFT JOIN acc_1102050101_217_stam a On ao.an = a.an
                WHERE income ="02"

                union

                SELECT ao.an,ao.vn,ao.hn,ao.vstdate,ao.pttype,ao.paidst,ao.finance_number,ao.income,ao.icode,ao.name as dname,ao.qty,ao.unitprice,ao.cost,ao.discount,ao.sum_price
                FROM acc_opitemrece ao
                LEFT JOIN acc_1102050101_217_stam a On ao.an = a.an
                WHERE icode IN("1560016","1540073","1530005","1540048","1620015","1600012","1600015","3001412","3001417","3010829","3010726")

                ) as tmp

        ');
        foreach ($acc_opitemrece_ as $va2) {
            Acc_opitemrece_stm::insert([
                'hn'                 => $va2->hn,
                'an'                 => $va2->an,
                'vn'                 => $va2->vn,
                'vstdate'            => $va2->vstdate,
                'pttype'             => $va2->pttype,
                'paidst'             => $va2->paidst,
                'finance_number'     => $va2->finance_number,
                'income'             => $va2->income,
                'icode'              => $va2->icode,
                'name'               => $va2->dname,
                'qty'                => $va2->qty,
                'cost'               => $va2->cost,
                'unitprice'          => $va2->unitprice,
                'discount'           => $va2->discount,
                'sum_price'          => $va2->sum_price
            ]);

        }
        return response()->json([
            'status'    => '200'
        ]);
    }
    public function account_pkucs217_stm(Request $request,$months,$year)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        // dd($id);
        $data['users'] = User::get();

        $datashow = DB::select('
            SELECT s.tranid,a.vn,a.an,a.hn,a.cid,a.ptname,a.vstdate,a.dchdate,a.debit_total,s.dmis_money2
            ,s.total_approve,a.income_group,s.inst,s.hc,s.hc_drug,s.ae,s.ae_drug,s.ip_paytrue,s.STMdoc
            ,s.inst+s.hc+s.hc_drug+s.ae+s.ae_drug as stm217
            from acc_1102050101_217 a
            LEFT JOIN acc_stm_ucs s ON s.an = a.an
            WHERE month(a.dchdate) = "'.$months.'" and year(a.dchdate) = "'.$year.'"
            AND (s.hc_drug >0 or s.hc >0 or s.ae >0 or s.ae_drug >0 or s.inst >0)
            group by a.an
        ');
        // AND s.rep IS NOT NULL

        $sum_money_ = DB::connection('mysql')->select('
            SELECT SUM(a.debit_total) as total
            from acc_1102050101_217 a
            LEFT JOIN acc_stm_ucs au ON au.an = a.an
            WHERE month(a.dchdate) = "'.$months.'" and year(a.dchdate) = "'.$year.'" AND au.rep IS NOT NULL;
        ');
        foreach ($sum_money_ as $key => $value) {
            $sum_debit_total = $value->total;
        }
            $sum_stm_ = DB::connection('mysql')->select('
            SELECT SUM(au.inst) as stmtotal
            from acc_1102050101_217 a
            LEFT JOIN acc_stm_ucs au ON au.an = a.an
            WHERE month(a.dchdate) = "'.$months.'" and year(a.dchdate) = "'.$year.'" AND au.rep IS NOT NULL;
        ');
        foreach ($sum_stm_ as $key => $value) {
            $sum_stm_total = $value->stmtotal;
        }
        // $sum_stm_ = DB::connection('mysql')->select('
        //     SELECT SUM(au.total_approve) as total
        //     from acc_1102050101_217 a
        //     LEFT JOIN acc_stm_ucs au ON au.an = a.an
        //     WHERE month(a.dchdate) = "'.$months.'" and year(a.dchdate) = "'.$year.'" AND au.rep IS NOT NULL;
        // ');
        // foreach ($sum_stm_ as $key => $value) {
        //     $sum_debit_total = $value->total;
        // }

            return view('account_217.account_pkucs217_stm', $data, [
                'startdate'         =>     $startdate,
                'enddate'           =>     $enddate,
                'datashow'          =>     $datashow,
                'months'            =>     $months,
                'year'              =>     $year,
                'sum_debit_total'   =>     $sum_debit_total,
                'sum_stm_total'     =>     $sum_stm_total
            ]);
    }
    public function account_pkucs217_stmnull(Request $request,$months,$year)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        // dd($id);
        $data['users'] = User::get();

        $data = DB::select('
                SELECT au.tranid,a.vn,a.an,a.hn,a.cid,a.ptname,a.vstdate,a.dchdate,a.debit_total,au.dmis_money2,au.total_approve,a.income_group,au.inst,au.ip_paytrue
                from acc_1102050101_217 a
                LEFT JOIN acc_stm_ucs au ON au.an = a.an
                WHERE a.status ="N"
                AND month(a.dchdate) = "'.$months.'" and year(a.dchdate) = "'.$year.'"
                GROUP BY a.an
        ');

        $sum_money_ = DB::connection('mysql')->select('
            SELECT SUM(a.debit_total) as total
            from acc_1102050101_217 a
            LEFT JOIN acc_stm_ucs au ON au.an = a.an
            WHERE month(a.dchdate) = "'.$months.'" and year(a.dchdate) = "'.$year.'" AND au.rep IS NULL;
        ');
        foreach ($sum_money_ as $key => $value) {
            $sum_debit_total = $value->total;
        }
        $sum_stm_ = DB::connection('mysql')->select('
            SELECT SUM(au.inst) as stmtotal
            from acc_1102050101_217 a
            LEFT JOIN acc_stm_ucs au ON au.an = a.an
            WHERE month(a.dchdate) = "'.$months.'" and year(a.dchdate) = "'.$year.'" AND au.rep IS NULL;
        ');
        foreach ($sum_stm_ as $key => $value) {
            $sum_stm_total = $value->stmtotal;
        }

        return view('account_217.account_pkucs217_stmnull', $data, [
            'startdate'         =>     $startdate,
            'enddate'           =>     $enddate,
            'data'              =>     $data,
            'months'            =>     $months,
            'year'              =>     $year,
            'sum_debit_total'   =>     $sum_debit_total,
            'sum_stm_total'     =>     $sum_stm_total
        ]);
    }
    public function account_pkucs217_stmnull_all(Request $request,$months,$year)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        // dd($id);
        $data['users'] = User::get();
        $mototal = $months + 1;
        $datashow = DB::connection('mysql')->select('
                SELECT au.tranid,a.vn,a.an,a.hn,a.cid,a.ptname,a.vstdate,a.dchdate,a.debit_total,au.dmis_money2,au.total_approve,a.income_group,au.inst,au.ip_paytrue,au.STMdoc
                    from acc_1102050101_217 a
                    LEFT JOIN acc_stm_ucs au ON au.an = a.an
                    WHERE a.status ="N"
                    AND month(a.dchdate) < "'.$mototal.'"
                    and year(a.dchdate) = "'.$year.'"
                    AND au.ip_paytrue IS NULL
                    GROUP BY a.an

            ');
        return view('account_217.account_pkucs217_stmnull_all', $data, [
            'startdate'         =>     $startdate,
            'enddate'           =>     $enddate,
            'datashow'          =>     $datashow,
            'months'            =>     $months,
            'year'              =>     $year,
        ]);
    }
 

 }