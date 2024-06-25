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
use App\Models\Acc_1102050101_216;
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
use App\Models\Acc_1102050101_209;
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


class Account209Controller extends Controller
 { 
    public function account_pkucs209_dash(Request $request)
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
                    and account_code="1102050101.209"
                    group by month(a.vstdate) order by a.vstdate desc limit 3;
            ');
            // and stamp = "N"
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
                    and account_code="1102050101.209"
                    
                   order by a.vstdate desc;
            ');
        }
        // group by month(a.vstdate) 
        return view('account_209.account_pkucs209_dash',[
            'startdate'        =>  $startdate,
            'enddate'          =>  $enddate,
            'datashow'         =>  $datashow,
            'leave_month_year' =>  $leave_month_year,
        ]);
    }
    public function account_pkucs209_pull(Request $request)
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
                SELECT *
                from acc_debtor a 
                WHERE a.account_code="1102050101.209"
                AND a.stamp = "N" AND a.debit_total > 0
                group by a.vn
                order by a.vstdate desc;
            ');
            // a.acc_debtor_id,a.vn,a.hn,a.cid,a.vstdate,a.ptname,a.pttype,a.income,a.debit_total,a.debit_instument
            //     ,a.debit_drug,a.debit_toa,a.debit_refer,c.subinscl 
        } else {
            $acc_debtor = DB::select('
            SELECT *
             from acc_debtor a  
                WHERE a.account_code="1102050101.209"
                AND a.stamp = "N" AND a.debit_total > 0
                group by a.vn
                order by a.vstdate desc;
            ');
            // $acc_debtor = Acc_debtor::where('stamp','=','N')->whereBetween('dchdate', [$startdate, $enddate])->get();
        }
        return view('account_209.account_pkucs209_pull',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'acc_debtor'    =>     $acc_debtor,
        ]);
    }
    public function account_pkucs209_checksit(Request $request)
    {
        $datestart = $request->datestart;
        $dateend = $request->dateend;
        $date = date('Y-m-d');
        
        $data_sitss = DB::connection('mysql')->select('SELECT vn,an,cid,vstdate,dchdate FROM acc_debtor WHERE account_code="1102050101.209" AND stamp = "N" GROUP BY vn');
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
    public function account_pkucs209_pulldata(Request $request)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->datepicker;
        $enddate = $request->datepicker2;
        $acc_debtor = DB::connection('mysql2')->select(' 
                SELECT 
                v.vn,ifnull(o.an,"") as an,o.hn,pt.cid
                ,concat(pt.pname,pt.fname," ",pt.lname) as ptname
                ,v.vstdate,v.hospmain 
                ,vp.pttype 
                ,e.code as acc_code
                ,e.ar_opd as account_code 
                ,e.`name` as account_name
                ,v.income,v.uc_money,v.discount_money,v.paid_money,v.rcpt_money 								
                ,v.income-v.discount_money-v.rcpt_money
                -sum(if(op.income="02",sum_price,0))
                -sum(if(op.icode IN("1560016","1540073","1530005","1540048","1620015"),sum_price,0))
                -sum(if(op.icode IN("3001412","3001417"),sum_price,0))
                -sum(if(op.icode IN("3010829","3011068","3010864","3010861","3010862","3010863","3011069","3011012","3011070"),sum_price,0)) as debit
                
                ,sum(if(op.income="02",sum_price,0)) as debit_instument
                ,sum(if(op.icode IN("1560016","1540073","1530005","1540048","1620015"),sum_price,0)) as debit_drug
                ,sum(if(op.icode IN("3001412","3001417"),sum_price,0)) as debit_toa
                ,sum(if(op.icode IN("3010829","3011068","3010864","3010861","3010862","3010863","3011069","3011012","3011070"),sum_price,0)) as debit_refer
                ,vp.max_debt_amount
                from ovst o
                left outer join vn_stat v on v.vn=o.vn
                left outer join visit_pttype vp on vp.vn = v.vn
                left outer join patient pt on pt.hn=o.hn
                left outer join pttype ptt on o.pttype=ptt.pttype
                left outer join pttype_eclaim e on e.code = ptt.pttype_eclaim_id
                left outer join opitemrece op ON op.vn = o.vn
                left outer join s_drugitems s on s.icode = op.icode
                
                WHERE v.vstdate BETWEEN "' . $startdate . '" AND "' . $enddate . '"
                AND v.income-v.discount_money-v.rcpt_money <> 0
                AND vp.pttype IN (SELECT pttype FROM pkbackoffice.acc_setpang_type WHERE pang ="1102050101.209")
                
                AND op.icode NOT like "c%" 
                AND op.icode NOT IN("3003661","3003662","3003336","3002896","3002897","3002898","3002910","3002911","3002912","3002913","3002914","3002915","3002916","3002917","3002918","3003608","3010102","3010353")
                AND (o.an="" or o.an is null)
                GROUP BY v.vn  
                
        ');
   
        foreach ($acc_debtor as $key => $value) {
            if ($value->debit >0) {
                $check = Acc_debtor::where('vn', $value->vn)->where('account_code', '1102050101.209')->whereBetween('vstdate', [$startdate, $enddate])->count();
                if ($check == 0) {
                    Acc_debtor::insert([
                        'hn'                 => $value->hn,
                        'an'                 => $value->an,
                        'vn'                 => $value->vn,
                        'cid'                => $value->cid,
                        'ptname'             => $value->ptname,
                        'pttype'             => $value->pttype,
                        'vstdate'            => $value->vstdate,
                        // 'regdate'            => $value->regdate,
                        // 'dchdate'            => $value->dchdate,
                        'acc_code'           => $value->acc_code,
                        'account_code'       => $value->account_code,
                        'account_name'       => $value->account_name,
                        // 'income_group'       => $value->income_group,
                        'income'             => $value->income,
                        'uc_money'           => $value->uc_money,
                        'discount_money'     => $value->discount_money,
                        // 'paid_money'         => $value->cash_money,
                        'rcpt_money'         => $value->rcpt_money,
                        'debit'              => $value->debit,
                        'debit_drug'         => $value->debit_drug,
                        'debit_instument'    => $value->debit_instument,
                        'debit_toa'          => $value->debit_toa,
                        'debit_refer'        => $value->debit_refer,
                        'debit_total'        => $value->debit,
                        'max_debt_amount'    => $value->max_debt_amount,
                        // 'rw'                 => $value->rw,
                        // 'adjrw'              => $value->adjrw,
                        // 'total_adjrw_income' => $value->total_adjrw_income,
                        'acc_debtor_userid'  => Auth::user()->id
                    ]);
                }
            } else {
                # code...
            }  
        }
        return response()->json([
            'status'    => '200'
        ]);
    } 
    public function account_pkucs209_stam(Request $request)
    {
        $id = $request->ids;
        $iduser = Auth::user()->id;
        
        $data = Acc_debtor::whereIn('acc_debtor_id',explode(",",$id))->get();
            Acc_debtor::whereIn('acc_debtor_id',explode(",",$id))
                    ->update([
                        'stamp' => 'Y'
                    ]);
        foreach ($data as $key => $value) {
            Acc_1102050101_209::insert([
                'vn'                => $value->vn,
                'hn'                => $value->hn,
                'an'                => $value->an,
                'cid'               => $value->cid,
                'ptname'            => $value->ptname,
                'vstdate'           => $value->vstdate,
                'regdate'           => $value->regdate,
                'dchdate'           => $value->dchdate,
                'pttype'            => $value->pttype,
                'acc_code'          => $value->acc_code,
                'account_code'      => $value->account_code,
                'rw'                 => $value->rw,
                'adjrw'              => $value->adjrw,
                'total_adjrw_income' => $value->total_adjrw_income,
                'debit_drug'         => $value->debit_drug,
                'debit_instument'    => $value->debit_instument,
                'debit_toa'          => $value->debit_toa,
                'debit_refer'        => $value->debit_refer,
                'income'             => $value->income,
                'uc_money'           => $value->uc_money,
                'discount_money'     => $value->discount_money,
                'rcpt_money'         => $value->rcpt_money, 
                'debit'              => $value->debit,
                'debit_total'        => $value->debit_total,
                'acc_debtor_userid'  => $value->acc_debtor_userid
            ]);
        }
        
        return response()->json([
            'status'    => '200'
        ]);
    } 
    
    public function account_pkucs209_detail(Request $request,$months,$year)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        // dd($id);
        $data['users'] = User::get();

        $data = DB::select('
            SELECT *  from acc_1102050101_209 
            WHERE month(vstdate) = "'.$months.'" and year(vstdate) = "'.$year.'" 
           
        ');
        // GROUP BY vn
        return view('account_209.account_pkucs209_detail', $data, [
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'data'          =>     $data,
            'months'        =>     $months,
            'year'          =>     $year
        ]);
    }
    
    public function account_pkucs209_stm(Request $request,$months,$year)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        // dd($id);
        $data['users'] = User::get();

        $datashow = DB::select(' 
            SELECT s.tranid,a.vn,a.an,a.hn,a.cid,a.ptname,a.vstdate,a.dchdate,s.dmis_money2
            ,a.income_group,s.inst,s.hc,s.hc_drug,s.ae,s.ae_drug,s.STMdoc,a.debit_total,s.ip_paytrue as STM202
            ,s.inst+s.hc+s.hc_drug+s.ae+s.ae_drug+s.dmis_money2+s.dmis_drug as stm217,s.pp,s.fs
            ,s.total_approve STM_TOTAL
            from acc_1102050101_209 a
            LEFT JOIN acc_stm_ucs s ON s.hn = a.hn AND s.vstdate = a.vstdate
            WHERE month(a.vstdate) = "'.$months.'" and year(a.vstdate) = "'.$year.'"
            
            AND s.pp > 0
            group by a.vn
        ');
        // AND s.rep IS NOT NULL
       
            return view('account_209.account_pkucs209_stm', $data, [
                'startdate'         =>     $startdate,
                'enddate'           =>     $enddate,
                'datashow'          =>     $datashow,
                'months'            =>     $months,
                'year'              =>     $year, 
            ]);
    }
    public function account_pkucs209_stmnull(Request $request,$months,$year)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        // dd($id);
        $data['users'] = User::get();

        $data = DB::select('
                SELECT s.tranid,a.vn,a.an,a.hn,a.cid,a.ptname,a.vstdate,a.dchdate,a.debit_total,s.dmis_money2,s.total_approve,a.income_group,s.inst,s.ip_paytrue
                ,s.inst + s.hc + s.hc_drug + s.ae + s.ae_drug + s.dmis_money2 + s.dmis_drug as stm217,s.pp,s.fs
                from acc_1102050101_209 a
                LEFT JOIN acc_stm_ucs s ON s.hn = a.hn AND s.vstdate = a.vstdate
                WHERE a.status ="N"
                AND month(a.vstdate) = "'.$months.'" and year(a.vstdate) = "'.$year.'"
             
                AND (s.pp is null or s.pp = "0.00")
                group by a.vn
        ');
       

        return view('account_209.account_pkucs209_stmnull', $data, [
            'startdate'         =>     $startdate,
            'enddate'           =>     $enddate,
            'data'              =>     $data,
            'months'            =>     $months,
            'year'              =>     $year, 
        ]);
    }

    public function account_pkucs209_detail_date(Request $request,$startdate,$enddate)
    {
        $datenow = date('Y-m-d');
      
        $data['users'] = User::get();

        $data = DB::select('
            SELECT *  from acc_1102050101_209 
            WHERE vstdate between "'.$startdate.'" and  "'.$enddate.'" 
            GROUP BY vn
        ');
        // GROUP BY vn
        return view('account_209.account_pkucs209_detail_date', $data, [
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'data'          =>     $data, 
        ]);
    }
    public function account_209_destroy(Request $request)
    {
        $id = $request->ids; 
        $data = Acc_debtor::whereIn('acc_debtor_id',explode(",",$id))->get();
            Acc_debtor::whereIn('acc_debtor_id',explode(",",$id))->delete();
                  
        return response()->json([
            'status'    => '200'
        ]);
    }
 

 }