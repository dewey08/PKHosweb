<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\support\Facades\Hash;
use Illuminate\support\Facades\Validator;
use App\Models\User;
use App\Models\Acc_debtor;
use App\Models\Acc_1102050101_201;
use App\Models\Account_listpercen;
use App\Models\Leave_month;
use App\Models\Acc_debtor_stamp;
use App\Models\Leave_month_year;
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
use SoapClient; 
use SplFileObject;
use PHPExcel; 
use PHPExcel_IOFactory;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

date_default_timezone_set("Asia/Bangkok");
  

class AccountPKController extends Controller
{
    public function account_pk(Request $request)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $pang = $request->pang_id;
        if ($pang == '') {
            // $pang_id = '';
        } else {
            $pangtype = DB::connection('mysql5')->table('pang')->where('pang_id', '=', $pang)->first();
            $pang_type = $pangtype->pang_type;
            $pang_id = $pang;
        }
        // dd($enddate);        
        $data['com_tec'] = DB::table('com_tec')->get();
        $data['users'] = User::get();
      
        $check = Acc_debtor::count();
        // dd($check);  
        // if ($check > 0) { 
        //     if ($startdate == '') {
        //         $acc_debtor = Acc_debtor::where('stamp','=','N')->limit(300)->get();
        //     } else {
        //         $acc_debtor = Acc_debtor::where('stamp','=','N')->whereBetween('vstdate', [$startdate, $enddate])->get();
        //     }                        
        // } else {
            $acc_debtor = DB::connection('mysql3')->select('
                SELECT o.vn,ifnull(o.an,"") as an,o.hn,showcid(pt.cid) as cid
                    ,concat(pt.pname,pt.fname," ",pt.lname) as ptname
                    ,o.vstdate,totime(o.vsttime) as vsttime
                    ,seekname(o.pt_subtype,"pt_subtype") as ptsubtype 
                    ,ptt.pttype_eclaim_id,e.name as pttype_eclaim_name
                    ,o.pttype,ptt.name pttypename
                    ,e.gf_opd as gfmis,e.code as acc_code
                    ,e.ar_opd as account_code,seekname(e.ar_opd,"account") as account_name 
                    ,v.income,v.uc_money,v.discount_money,v.paid_money,v.rcpt_money
                    ,v.rcpno_list as rcpno                
                    ,v.income-v.discount_money-v.rcpt_money as debit
                    ,(select max(max_debt_amount) cc from visit_pttype where vn=o.vn) as max_debt_amount
                from ovst o 
                left join vn_stat v on v.vn=o.vn
                left join patient pt on pt.hn=o.hn
                left join pttype ptt on ptt.pttype=o.pttype
                left join pttype_eclaim e on e.code=ptt.pttype_eclaim_id 
                where o.vstdate between "' . $startdate . '" and "' . $enddate . '" 
                group by o.vn        
            ');
            // dd($acc_debtor);   
        // }
        // dd($startdate);     
        // $data['acc_debtor'] = Acc_debtor::get();
        return view('account_pk.account_pk', $data, [
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'acc_debtor'      =>     $acc_debtor,
            // 'pang_id'       =>     $pang_id
        ]);
    }
    public function account_pksave(Request $request)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->datepicker;
        $enddate = $request->datepicker2;
        $datashow = DB::connection('mysql3')->select('
            SELECT o.vn,ifnull(o.an,"") as an,o.hn,showcid(pt.cid) as cid
                ,concat(pt.pname,pt.fname," ",pt.lname) as ptname
                ,setdate(o.vstdate) as vstdate,totime(o.vsttime) as vsttime
                ,o.vstdate as vstdatesave
                ,seekname(o.pt_subtype,"pt_subtype") as ptsubtype 
                ,ptt.pttype_eclaim_id,e.name as pttype_eclaim_name
                ,o.pttype,ptt.name pttypename
                ,e.gf_opd as gfmis,e.code as acc_code
                ,e.ar_opd as account_code,seekname(e.ar_opd,"account") as account_name 
                ,v.income,v.uc_money,v.discount_money,v.paid_money,v.rcpt_money
                ,v.rcpno_list as rcpno            
                ,v.income-v.discount_money-v.rcpt_money as debit
                ,(select max(max_debt_amount) cc from visit_pttype where vn=o.vn) as max_debt_amount
            from ovst o 
            left join vn_stat v on v.vn=o.vn
            left join patient pt on pt.hn=o.hn
            left join pttype ptt on ptt.pttype=o.pttype
            left join pttype_eclaim e on e.code=ptt.pttype_eclaim_id 
            where o.vstdate between "' . $startdate . '" and "' . $enddate . '" 
            group by o.vn        
        ');

        foreach ($datashow as $key => $value) {
            // Check_sit_auto::truncate();
            $check = Acc_debtor::where('vn', $value->vn)->count();
            if ($check > 0) {
                if ($value->pttype == "M1") {
                    Acc_debtor::where('vn', $value->vn) 
                    ->update([   
                        'hn' => $value->hn,
                        'an' => $value->an,
                        'cid' => $value->cid,
                        'ptname' => $value->ptname,
                        'ptsubtype' => $value->ptsubtype,
                        'pttype_eclaim_id' => $value->pttype_eclaim_id,
                        'pttype_eclaim_name' => $value->pttype_eclaim_name,
                        'pttype' => $value->pttype,
                        'pttypename' => $value->pttypename,
                        'vstdate' => $value->vstdatesave,
                        'vsttime' => $value->vsttime,
                        'gfmis' => $value->gfmis,
                        'acc_code' => '',
                        'account_code' => '1102050101.4011',
                        'account_name' => 'เบิกจ่ายตรงกรมบัญชีกลาง OP (ฟอกไต)', 
                        'income' => $value->income,
                        'uc_money' => $value->uc_money,
                        'discount_money' => $value->discount_money,
                        'paid_money' => $value->paid_money,
                        'rcpt_money' => $value->rcpt_money,
                        'rcpno' => $value->rcpno,
                        'debit' => $value->debit,
                        'max_debt_amount' => $value->max_debt_amount
                    ]); 
                }elseif ($value->pttype == "M6" || $value->pttype == "M7") {
                    Acc_debtor::where('vn', $value->vn) 
                    ->update([   
                        'hn' => $value->hn,
                        'an' => $value->an,
                        'cid' => $value->cid,
                        'ptname' => $value->ptname,
                        'ptsubtype' => $value->ptsubtype,
                        'pttype_eclaim_id' => $value->pttype_eclaim_id,
                        'pttype_eclaim_name' => $value->pttype_eclaim_name,
                        'pttype' => $value->pttype,
                        'pttypename' => $value->pttypename,
                        'vstdate' => $value->vstdatesave,
                        'vsttime' => $value->vsttime,
                        'gfmis' => $value->gfmis,
                        'acc_code' => '',
                        'account_code' => '1102050102.8011',
                        'account_name' => 'เบิกจ่ายตรง อปท. OP(ฟอกไต)',  
                        'income' => $value->income,
                        'uc_money' => $value->uc_money,
                        'discount_money' => $value->discount_money,
                        'paid_money' => $value->paid_money,
                        'rcpt_money' => $value->rcpt_money,
                        'rcpno' => $value->rcpno,
                        'debit' => $value->debit,
                        'max_debt_amount' => $value->max_debt_amount
                    ]);
                }elseif ($value->pttype == "M3" || $value->pttype == "M4") {
                    Acc_debtor::where('vn', $value->vn) 
                    ->update([   
                        'hn' => $value->hn,
                        'an' => $value->an,
                        'cid' => $value->cid,
                        'ptname' => $value->ptname,
                        'ptsubtype' => $value->ptsubtype,
                        'pttype_eclaim_id' => $value->pttype_eclaim_id,
                        'pttype_eclaim_name' => $value->pttype_eclaim_name,
                        'pttype' => $value->pttype,
                        'pttypename' => $value->pttypename,
                        'vstdate' => $value->vstdatesave,
                        'vsttime' => $value->vsttime,
                        'gfmis' => $value->gfmis,
                        'acc_code' => '',
                        'account_code' => '1102050101.2166',
                        'account_name' => 'UC OP บริการเฉพาะ (CR)(ฟอกไต)',  
                        'income' => $value->income,
                        'uc_money' => $value->uc_money,
                        'discount_money' => $value->discount_money,
                        'paid_money' => $value->paid_money,
                        'rcpt_money' => $value->rcpt_money,
                        'rcpno' => $value->rcpno,
                        'debit' => $value->debit,
                        'max_debt_amount' => $value->max_debt_amount
                    ]);
                }elseif ($value->pttype == "M2" || $value->pttype == "M5") {
                    Acc_debtor::where('vn', $value->vn) 
                    ->update([   
                        'hn' => $value->hn,
                        'an' => $value->an,
                        'cid' => $value->cid,
                        'ptname' => $value->ptname,
                        'ptsubtype' => $value->ptsubtype,
                        'pttype_eclaim_id' => $value->pttype_eclaim_id,
                        'pttype_eclaim_name' => $value->pttype_eclaim_name,
                        'pttype' => $value->pttype,
                        'pttypename' => $value->pttypename,
                        'vstdate' => $value->vstdatesave,
                        'vsttime' => $value->vsttime,
                        'gfmis' => $value->gfmis,
                        'acc_code' => '',
                        'account_code' => '1102050101.3099',
                        'account_name' => 'ประกันสังคม-ค่าใช้จ่ายสูง OP(ฟอกไต)',  
                        'income' => $value->income,
                        'uc_money' => $value->uc_money,
                        'discount_money' => $value->discount_money,
                        'paid_money' => $value->paid_money,
                        'rcpt_money' => $value->rcpt_money,
                        'rcpno' => $value->rcpno,
                        'debit' => $value->debit,
                        'max_debt_amount' => $value->max_debt_amount
                    ]);
                } else {
                    Acc_debtor::where('vn', $value->vn) 
                    ->update([   
                        'hn' => $value->hn,
                        'an' => $value->an,
                        'cid' => $value->cid,
                        'ptname' => $value->ptname,
                        'ptsubtype' => $value->ptsubtype,
                        'pttype_eclaim_id' => $value->pttype_eclaim_id,
                        'pttype_eclaim_name' => $value->pttype_eclaim_name,
                        'pttype' => $value->pttype,
                        'pttypename' => $value->pttypename,
                        'vstdate' => $value->vstdatesave,
                        'vsttime' => $value->vsttime,
                        'gfmis' => $value->gfmis,
                        'acc_code' => $value->acc_code,
                        'account_code' => $value->account_code,
                        'account_name' => $value->account_name,
                        'income' => $value->income,
                        'uc_money' => $value->uc_money,
                        'discount_money' => $value->discount_money,
                        'paid_money' => $value->paid_money,
                        'rcpt_money' => $value->rcpt_money,
                        'rcpno' => $value->rcpno,
                        'debit' => $value->debit,
                        'max_debt_amount' => $value->max_debt_amount
                    ]);   
                }
                
                  
            } else {

                if ($value->pttype == "M1") {
                    Acc_debtor::insert([
                        'vn' => $value->vn,
                        'hn' => $value->hn,
                        'an' => $value->an,
                        'cid' => $value->cid,
                        'ptname' => $value->ptname,
                        'ptsubtype' => $value->ptsubtype,
                        'pttype_eclaim_id' => $value->pttype_eclaim_id,
                        'pttype_eclaim_name' => $value->pttype_eclaim_name,
                        'pttype' => $value->pttype,
                        'pttypename' => $value->pttypename,
                        'vstdate' => $value->vstdatesave,
                        'vsttime' => $value->vsttime,
                        'gfmis' => $value->gfmis,                            
                        'acc_code' => '',
                        'account_code' => '1102050101.4011',
                        'account_name' => 'เบิกจ่ายตรงกรมบัญชีกลาง OP (ฟอกไต)',    
                        'income' => $value->income,
                        'uc_money' => $value->uc_money,
                        'discount_money' => $value->discount_money,
                        'paid_money' => $value->paid_money,
                        'rcpt_money' => $value->rcpt_money,
                        'rcpno' => $value->rcpno,
                        'debit' => $value->debit,
                        'max_debt_amount' => $value->max_debt_amount
                    ]);
                }elseif ($value->pttype == "M6" || $value->pttype == "M7") {
                    Acc_debtor::insert([
                        'vn' => $value->vn,
                        'hn' => $value->hn,
                        'an' => $value->an,
                        'cid' => $value->cid,
                        'ptname' => $value->ptname,
                        'ptsubtype' => $value->ptsubtype,
                        'pttype_eclaim_id' => $value->pttype_eclaim_id,
                        'pttype_eclaim_name' => $value->pttype_eclaim_name,
                        'pttype' => $value->pttype,
                        'pttypename' => $value->pttypename,
                        'vstdate' => $value->vstdatesave,
                        'vsttime' => $value->vsttime,
                        'gfmis' => $value->gfmis,                            
                        'acc_code' => '',
                        'account_code' => '1102050102.8011',
                        'account_name' => 'เบิกจ่ายตรง อปท. OP(ฟอกไต)',    
                        'income' => $value->income,
                        'uc_money' => $value->uc_money,
                        'discount_money' => $value->discount_money,
                        'paid_money' => $value->paid_money,
                        'rcpt_money' => $value->rcpt_money,
                        'rcpno' => $value->rcpno,
                        'debit' => $value->debit,
                        'max_debt_amount' => $value->max_debt_amount
                    ]);
               
                }elseif ($value->pttype == "M3" || $value->pttype == "M4") {
                    Acc_debtor::insert([
                        'vn' => $value->vn,
                        'hn' => $value->hn,
                        'an' => $value->an,
                        'cid' => $value->cid,
                        'ptname' => $value->ptname,
                        'ptsubtype' => $value->ptsubtype,
                        'pttype_eclaim_id' => $value->pttype_eclaim_id,
                        'pttype_eclaim_name' => $value->pttype_eclaim_name,
                        'pttype' => $value->pttype,
                        'pttypename' => $value->pttypename,
                        'vstdate' => $value->vstdatesave,
                        'vsttime' => $value->vsttime,
                        'gfmis' => $value->gfmis,                            
                        'acc_code' => '',
                        'account_code' => '1102050101.2166',
                        'account_name' => 'UC OP บริการเฉพาะ (CR)(ฟอกไต)',    
                        'income' => $value->income,
                        'uc_money' => $value->uc_money,
                        'discount_money' => $value->discount_money,
                        'paid_money' => $value->paid_money,
                        'rcpt_money' => $value->rcpt_money,
                        'rcpno' => $value->rcpno,
                        'debit' => $value->debit,
                        'max_debt_amount' => $value->max_debt_amount
                    ]);
                }elseif ($value->pttype == "M2" || $value->pttype == "M5") {
                    Acc_debtor::insert([
                        'vn' => $value->vn,
                        'hn' => $value->hn,
                        'an' => $value->an,
                        'cid' => $value->cid,
                        'ptname' => $value->ptname,
                        'ptsubtype' => $value->ptsubtype,
                        'pttype_eclaim_id' => $value->pttype_eclaim_id,
                        'pttype_eclaim_name' => $value->pttype_eclaim_name,
                        'pttype' => $value->pttype,
                        'pttypename' => $value->pttypename,
                        'vstdate' => $value->vstdatesave,
                        'vsttime' => $value->vsttime,
                        'gfmis' => $value->gfmis,                            
                        'acc_code' => '',
                        'account_code' => '1102050101.3099',
                        'account_name' => 'ประกันสังคม-ค่าใช้จ่ายสูง OP(ฟอกไต)',    
                        'income' => $value->income,
                        'uc_money' => $value->uc_money,
                        'discount_money' => $value->discount_money,
                        'paid_money' => $value->paid_money,
                        'rcpt_money' => $value->rcpt_money,
                        'rcpno' => $value->rcpno,
                        'debit' => $value->debit,
                        'max_debt_amount' => $value->max_debt_amount
                    ]);
                } else {
                    Acc_debtor::insert([
                        'vn' => $value->vn,
                        'hn' => $value->hn,
                        'an' => $value->an,
                        'cid' => $value->cid,
                        'ptname' => $value->ptname,
                        'ptsubtype' => $value->ptsubtype,
                        'pttype_eclaim_id' => $value->pttype_eclaim_id,
                        'pttype_eclaim_name' => $value->pttype_eclaim_name,
                        'pttype' => $value->pttype,
                        'pttypename' => $value->pttypename,
                        'vstdate' => $value->vstdatesave,
                        'vsttime' => $value->vsttime,
                        'gfmis' => $value->gfmis,  
                        'acc_code' => $value->acc_code,
                        'account_code' => $value->account_code,
                        'account_name' => $value->account_name,
                        'income' => $value->income,
                        'uc_money' => $value->uc_money,
                        'discount_money' => $value->discount_money,
                        'paid_money' => $value->paid_money,
                        'rcpt_money' => $value->rcpt_money,
                        'rcpno' => $value->rcpno,
                        'debit' => $value->debit,
                        'max_debt_amount' => $value->max_debt_amount
                    ]);
                }

                
            }                        
        }
        return response()->json([
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'status'    => '200' 
        ]); 
    }
    public function account_pkCheck_sit(Request $request)
    {
        $startdate = $request->datepicker;
        $enddate = $request->datepicker2;
        $date = date('Y-m-d');

        $token_data = DB::connection('mysql7')->select('
            SELECT cid,token FROM ssop_token 
        '); 
        foreach ($token_data as $key => $valuetoken) {
            $cid_ = $valuetoken->cid;
            $token_ = $valuetoken->token;
        } 
        // $data_sitss = DB::connection('mysql')->select(' 
        //     SELECT *
        //     FROM acc_debtor  
        //     WHERE vstdate BETWEEN "'.$datestart.'" AND "'.$dateend.'"  
        //     AND pttype_spsch IS NULL  
        // ');  
        $data_sitss = Acc_debtor::whereBetween('vstdate', [$startdate, $enddate])
        ->whereNull('pttype_spsch')
        ->get();
        //   dd($data_sitss);
        foreach ($data_sitss as $key => $item) {
            $pids = $item->cid;
            $vn = $item->vn;
            $hn = $item->hn;
            $vsttime = $item->vsttime;
            $vstdate = $item->vstdate;
            $ptname = $item->ptname; 
      
            $client = new SoapClient("http://ucws.nhso.go.th/ucwstokenp1/UCWSTokenP1?wsdl",
                array(
                    "uri" => 'http://ucws.nhso.go.th/ucwstokenp1/UCWSTokenP1?xsd=1',
                                    "trace"      => 1,    
                                    "exceptions" => 0,    
                                    "cache_wsdl" => 0 
                    )
                );
                $params = array(
                    'sequence' => array(
                        "user_person_id" => "$cid_",
                        "smctoken" => "$token_",
                        "person_id" => "$pids"
                )
            ); 
            $contents = $client->__soapCall('searchCurrentByPID',$params);    
       
            foreach ($contents as $key => $v) {  
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
                IF(@$maininscl =="" || @$maininscl==null || @$status =="003" ){ #ถ้าเป็นค่าว่างไม่ต้อง insert                   
                        $date_now = date('Y-m-d');
                        Acc_debtor::where('vn', $vn) 
                            ->update([    
                                'status'         => 'จำหน่าย/เสียชีวิต',
                                'maininscl'      => @$maininscl,
                                'pttype_spsch'      => @$subinscl,
                                'hmain'          => @$hmain,
                                'subinscl'       => @$subinscl, 
                                'hmain_op'       => @$hmain_op,
                                'hmain_op_name'  => @$hmain_op_name,
                                'hsub'           => @$hsub,
                                'hsub_name'      => @$hsub_name,
                                'subinscl_name'  => @$subinscl_name 
                            ]);      
                  }elseif(@$maininscl !="" || @$subinscl !=""){ 
                        $date_now2 = date('Y-m-d');
                        Acc_debtor::where('vn', $vn) 
                            ->update([    
                                'status'        => @$status,
                                'maininscl'     => @$maininscl,
                                'pttype_spsch'     => @$subinscl,
                                'hmain'         => @$hmain,
                                'subinscl'      => @$subinscl, 
                                'hmain_op'      => @$hmain_op,
                                'hmain_op_name' => @$hmain_op_name,
                                'hsub'          => @$hsub,
                                'hsub_name'     => @$hsub_name,
                                'subinscl_name' => @$subinscl_name 
                            ]);    
                         
                  }

            }           
        }
        $acc_debtor = Acc_debtor::whereBetween('vstdate', [$startdate, $enddate])->get();
 
        return response()->json([
            'status'     => '200',
            'acc_debtor'    => $acc_debtor, 
            'start'     => $startdate, 
            'end'        => $enddate, 
        ]); 
    }
    
    public function account_pk_debtor(Request $request)
    {
        $id = $request->ids;
        $iduser = Auth::user()->id;
        $data = Acc_debtor::whereIn('acc_debtor_id',explode(",",$id))->get();

            Acc_debtor::whereIn('acc_debtor_id',explode(",",$id)) 
                    ->update([   
                        'stamp' => 'Y'
                    ]); 
       
        foreach ($data as $key => $value) {
            $check = Acc_debtor_stamp::where('stamp_vn', $value->vn)->count();
            if ($check > 0) {
                Acc_debtor_stamp::where('stamp_vn', $value->vn) 
                ->update([   
                    'stamp_vn' => $value->vn,
                    'stamp_hn' => $value->hn,
                    'stamp_an' => $value->an,
                    'stamp_cid' => $value->cid,
                    'stamp_ptname' => $value->ptname,
                    'stamp_vstdate' => $value->vstdate,
                    'stamp_vsttime' => $value->vsttime,
                    'stamp_pttype' => $value->pttype,
                    'stamp_pttype_nhso' => $value->pttype_spsch,                   
                    'stamp_acc_code' => $value->acc_code,
                    'stamp_account_code' => $value->account_code, 
                    'stamp_income' => $value->income,
                    'stamp_uc_money' => $value->uc_money,
                    'stamp_discount_money' => $value->discount_money,
                    'stamp_paid_money' => $value->paid_money,
                    'stamp_rcpt_money' => $value->rcpt_money,
                    'stamp_rcpno' => $value->rcpno,
                    'stamp_debit' => $value->debit,
                    'max_debt_amount' => $value->max_debt_amount
                    // 'acc_debtor_userid' => $iduser
                ]);  
            } else {
                $date = date('Y-m-d H:m:s');
                Acc_debtor_stamp::insert([
                    'stamp_vn' => $value->vn,
                    'stamp_hn' => $value->hn,
                    'stamp_an' => $value->an,
                    'stamp_cid' => $value->cid,
                    'stamp_ptname' => $value->ptname,
                    'stamp_vstdate' => $value->vstdate,
                    'stamp_vsttime' => $value->vsttime, 
                    'stamp_pttype' => $value->pttype,
                    'stamp_pttype_nhso' => $value->pttype_spsch,                   
                    'stamp_acc_code' => $value->acc_code,
                    'stamp_account_code' => $value->account_code, 
                    'stamp_income' => $value->income,
                    'stamp_uc_money' => $value->uc_money,
                    'stamp_discount_money' => $value->discount_money,
                    'stamp_paid_money' => $value->paid_money,
                    'stamp_rcpt_money' => $value->rcpt_money,
                    'stamp_rcpno' => $value->rcpno,
                    'stamp_debit' => $value->debit,
                    'max_debt_amount' => $value->max_debt_amount,
                    'created_at'=> $date
                    // 'acc_debtor_userid' => $iduser
                     
                ]);
            }                        
        }
       
        return response()->json([
            'status'    => '200' 
        ]);
    }

// *************************** IPD *******************************************

    public function account_pk_ipd(Request $request)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $pang = $request->pang_id;
        if ($pang == '') {
            // $pang_id = '';
        } else {
            $pangtype = DB::connection('mysql5')->table('pang')->where('pang_id', '=', $pang)->first();
            $pang_type = $pangtype->pang_type;
            $pang_id = $pang;
        }
        // dd($startdate);        
        $data['com_tec'] = DB::table('com_tec')->get();
        $data['users'] = User::get();
        $data['pang'] = DB::connection('mysql5')->table('pang')->get();

        // $check = Acc_debtor::count();
        $check =  DB::select('
            SELECT count(an) as an from acc_debtor 
            WHERE an != 0 and stamp = "N";
        ');
        if ($check > 0) { 
            if ($startdate == '') {
                $acc_debtor = DB::select('
                    SELECT * from acc_debtor 
                    WHERE an != 0 and stamp = "N" limit 300;
                ');
            } else {
                 
                $acc_debtor = DB::select('
                    SELECT * from acc_debtor 
                    WHERE an != 0 and stamp = "N" 
                    and vstdate BETWEEN "'.$startdate.'" and "'.$enddate.'";
                ');
            }                        
        } else {
            $acc_debtor = DB::connection('mysql3')->select('
                    SELECT o.vn,ifnull(o.an,"") as an,o.hn,showcid(pt.cid) as cid
                            ,concat(pt.pname,pt.fname," ",pt.lname) as ptname
                            ,setdate(o.vstdate) as vstdate,totime(o.vsttime) as vsttime
                            ,seekname(o.pt_subtype,"pt_subtype") as ptsubtype 
                            ,ptt.pttype_eclaim_id,e.name as pttype_eclaim_name
                            ,o.pttype,ptt.name pttypename
                            ,e.gf_opd as gfmis,e.code as acc_code
                            ,e.ar_opd as account_code,seekname(e.ar_opd,"account") as account_name 
                            ,a.income,a.uc_money,a.discount_money,a.paid_money,a.rcpt_money
                            ,a.rcpno_list as rcpno
                    
                            ,a.income-a.discount_money-a.rcpt_money as debit
                            ,(select max(max_debt_amount) cc from visit_pttype where vn=o.vn) as max_debt_amount
                    from ovst o 
                    left join an_stat a on a.an=o.an
                    left join patient pt on pt.hn=o.hn
                    left join pttype ptt on ptt.pttype=o.pttype
                    left join pttype_eclaim e on e.code=ptt.pttype_eclaim_id 
                where o.vstdate between "' . $startdate . '" and "' . $enddate . '" 
                group by o.an        
            ');
        } 
        return view('account_pk.account_pk_ipd', $data, [
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'acc_debtor'      =>     $acc_debtor, 
        ]);
    }

    public function account_pk_ipdsave(Request $request)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->datepicker;
        $enddate = $request->datepicker2;
        $datashow = DB::connection('mysql3')->select('
                SELECT o.vn,ifnull(o.an,"") as an,o.hn,showcid(pt.cid) as cid
                ,concat(pt.pname,pt.fname," ",pt.lname) as ptname
                ,setdate(o.vstdate) as vstdate,totime(o.vsttime) as vsttime
                ,seekname(o.pt_subtype,"pt_subtype") as ptsubtype 
                ,ptt.pttype_eclaim_id,e.name as pttype_eclaim_name
                ,o.pttype,ptt.name pttypename
                ,e.gf_opd as gfmis,e.code as acc_code
                ,e.ar_opd as account_code,seekname(e.ar_opd,"account") as account_name 
                ,a.income,a.uc_money,a.discount_money,a.paid_money,a.rcpt_money
                ,a.rcpno_list as rcpno

                ,a.income-a.discount_money-a.rcpt_money as debit
                ,(select max(max_debt_amount) cc from visit_pttype where vn=o.vn) as max_debt_amount
            from ovst o 
            left join an_stat a on a.an=o.an
            left join patient pt on pt.hn=o.hn
            left join pttype ptt on ptt.pttype=o.pttype
            left join pttype_eclaim e on e.code=ptt.pttype_eclaim_id 
            where o.vstdate between "' . $startdate . '" and "' . $enddate . '" 
            group by o.an        
        ');

        foreach ($datashow as $key => $value) {
            // Check_sit_auto::truncate();
            $check = Acc_debtor::where('vn', $value->vn)->count();
            if ($check > 0) {
                Acc_debtor::where('vn', $value->vn) 
                    ->update([   
                        'hn' => $value->hn,
                        'an' => $value->an,
                        'cid' => $value->cid,
                        'ptname' => $value->ptname,
                        'ptsubtype' => $value->ptsubtype,
                        'pttype_eclaim_id' => $value->pttype_eclaim_id,
                        'pttype_eclaim_name' => $value->pttype_eclaim_name,
                        'pttype' => $value->pttype,
                        'pttypename' => $value->pttypename,
                        'vstdate' => $value->vstdatesave,
                        'vsttime' => $value->vsttime,
                        'gfmis' => $value->gfmis,
                        'acc_code' => $value->acc_code,
                        'account_code' => $value->account_code,
                        'account_name' => $value->account_name,
                        'income' => $value->income,
                        'uc_money' => $value->uc_money,
                        'discount_money' => $value->discount_money,
                        'paid_money' => $value->paid_money,
                        'rcpt_money' => $value->rcpt_money,
                        'rcpno' => $value->rcpno,
                        'debit' => $value->debit,
                        'max_debt_amount' => $value->max_debt_amount
                    ]);     
            } else {

                Acc_debtor::insert([
                    'vn' => $value->vn,
                    'hn' => $value->hn,
                    'an' => $value->an,
                    'cid' => $value->cid,
                    'ptname' => $value->ptname,
                    'ptsubtype' => $value->ptsubtype,
                    'pttype_eclaim_id' => $value->pttype_eclaim_id,
                    'pttype_eclaim_name' => $value->pttype_eclaim_name,
                    'pttype' => $value->pttype,
                    'pttypename' => $value->pttypename,
                    'vstdate' => $value->vstdatesave,
                    'vsttime' => $value->vsttime,
                    'gfmis' => $value->gfmis,
                    'acc_code' => $value->acc_code,
                    'account_code' => $value->account_code,
                    'account_name' => $value->account_name,
                    'income' => $value->income,
                    'uc_money' => $value->uc_money,
                    'discount_money' => $value->discount_money,
                    'paid_money' => $value->paid_money,
                    'rcpt_money' => $value->rcpt_money,
                    'rcpno' => $value->rcpno,
                    'debit' => $value->debit,
                    'max_debt_amount' => $value->max_debt_amount
                ]);
            }                        
        }
        return response()->json([
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'status'    => '200' 
        ]); 
    }
// *************************** 401 ********************************************
    public function account_pkofc401_dash(Request $request)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate; 
        $dabudget_year = DB::table('budget_year')->where('active','=',true)->first();

        $data_startdate = $dabudget_year->date_begin;
        $data_enddate = $dabudget_year->date_end;
        $leave_month_year = DB::table('leave_month_year')->get();
        $data_month = DB::table('leave_month')->get();
      
        // foreach ($data_eave_month_year as $key => $value) {
            $acc_debtors = DB::select('
                SELECT count(vn) as VN from acc_debtor 
                WHERE stamp="N" and pttype_eclaim_id = "17" 
                and account_code="1102050101.401" ;
            ');
            foreach ($acc_debtors as $key => $value) {
                $acc_debtor = $value->VN;
            }
           
            // dd($acc_debtor);
        // }
        // and month(vstdate) = "01";
        // and month(vstdate) = "'.$value->month_year_code.'";
        //   dd($acc_debtor);

        return view('account_pk.account_pkofc401_dash',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'acc_debtor'    =>     $acc_debtor,
            'leave_month_year' =>  $leave_month_year,
            // 'acc_stam_'     =>     $acc_stam_ 
        ]);
    }
    public function account_pkofc401(Request $request,$id)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $pang = $request->pang_id;
        if ($pang == '') {
            // $pang_id = '';
        } else {
            $pangtype = DB::connection('mysql5')->table('pang')->where('pang_id', '=', $pang)->first();
            $pang_type = $pangtype->pang_type;
            $pang_id = $pang;
        }
        // dd($id);        
        $data['com_tec'] = DB::table('com_tec')->get();
        $data['users'] = User::get();
        $data['pang'] = DB::connection('mysql5')->table('pang')->get();
        // $date = date('Y-m-d');
        // $strM = date('m', strtotime($startdate));
        // $strY = date('Y', strtotime($startdate)) + 543;
            // $acc_debtor = Acc_debtor::where('stamp','=','N')->where('pttype_eclaim_id','=',17)
            // ->where('account_code','=',1102050101.401)
            // ->limit(1000)->get();

            $acc_debtor = DB::select('
                SELECT * from acc_debtor a
                
                WHERE stamp="N" and pttype_eclaim_id = "17" 
                and account_code="1102050101.401" 
                and month(vstdate) = "'.$id.'";
            ');
         
            // left join acc_debtor_stamp ad on ad.stamp_vn=a.vn
        return view('account_pk.account_pkofc401', $data, [
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'acc_debtor'      =>     $acc_debtor,
            'id'       =>     $id
        ]);
    }

// *************************** 801 ********************************************
    public function account_pklgo801_dash(Request $request)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate; 
        $dabudget_year = DB::table('budget_year')->where('active','=',true)->first();

        $data_startdate = $dabudget_year->date_begin;
        $data_enddate = $dabudget_year->date_end;
        $leave_month_year = DB::table('leave_month_year')->get();
        $data_month = DB::table('leave_month')->get();
       
            $acc_debtors = DB::select('
                SELECT count(vn) as VN from acc_debtor 
                WHERE stamp="N" and pttype_eclaim_id = "18" 
                and account_code="1102050102.801" ;
            ');
            foreach ($acc_debtors as $key => $value) {
                $acc_debtor = $value->VN;
            }
            
       
        return view('account_pk.account_pklgo801_dash',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'acc_debtor'    =>     $acc_debtor,
            'leave_month_year' =>$leave_month_year 
        ]);
    }
    public function account_pklgo801(Request $request,$id)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate; 
        // dd($startdate);        
        $data['com_tec'] = DB::table('com_tec')->get();
        $data['users'] = User::get(); 

        // $check = Acc_debtor::count();
        // if ($check > 0) { 
        //     if ($startdate == '') {
        //         $acc_debtor = Acc_debtor::where('stamp','=','N')->where('pttype_eclaim_id','=',18)->where('account_code','=',1102050102.801)->limit(1000)->get();
        //     } else {
        //         $acc_debtor = Acc_debtor::where('stamp','=','N')->where('pttype_eclaim_id','=',18)->where('account_code','=',1102050102.801)->whereBetween('vstdate', [$startdate, $enddate])->get();
        //     }                        
        // } else {
            
        // }
                
        $acc_debtor = DB::select('
                SELECT * from acc_debtor 
                WHERE stamp="N" and pttype_eclaim_id = "18" 
                and account_code="1102050102.801" 
                and month(vstdate) = "'.$id.'";
            ');
        // $data['acc_debtor'] = Acc_debtor::get();
        return view('account_pk.account_pklgo801', $data, [
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'acc_debtor'      =>     $acc_debtor,
            // 'pang_id'       =>     $pang_id
        ]);
    }

    public function acc_stm(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate; 
        $filename = $request->filename;
        $dabudget_year = DB::table('budget_year')->where('active','=',true)->first();
        $data_startdate = $dabudget_year->date_begin;
        $data_enddate = $dabudget_year->date_end;
        $leave_month_year = DB::table('leave_month_year')->get();
        $data_month = DB::table('leave_month')->get();


        $acc_stm = DB::connection('mysql9')->select('
        SELECT IF(ps.pang_stamp_vn IS NULL,"","Y")AS Stamp
                ,ps.pang_stamp_vn AS "vn"
                ,ps.pang_stamp_hn AS "hn"
                ,ps.pang_stamp_an AS "an"
                ,ps.pang_stamp_vstdate
                ,ps.pang_stamp_nhso
                ,ps.pang_stamp_uc_money ,ps.pang_stamp_uc_money_kor_tok
                ,ps.pang_stamp_stm_money AS stm
                ,ps.pang_stamp_uc_money_minut_stm_money
                ,ps.pang_stamp_send
                ,ps.pang_stamp_id
                ,ps.pang_stamp
                ,ps.pang_stamp_stm_file_name ,ps.pang_stamp_stm_rep
                ,ps.pang_stamp_edit_send_id
                ,CONCAT(rn.receipt_book_id,"/",rn.receipt_number_id) AS receipt_n
                ,rn.receipt_date
                ,ps.pang_stamp_rcpt
                ,CONCAT(ps.pang_stamp_pname,ps.pang_stamp_fname," ",ps.pang_stamp_lname) AS pt_name
                
                FROM pang_stamp ps
                LEFT JOIN receipt_number rn ON ps.pang_stamp_stm_file_name = rn.receipt_number_stm_file_name
                WHERE  ps.pang_stamp_stm_file_name ="'.$filename.'"
               
                AND ps.pang_stamp_send IS NOT NULL
                AND ps.pang_stamp_uc_money <> 0
                ORDER BY ps.pang_stamp_hn ;
        ');
        // WHERE ps.pang_stamp = "1102050101.202"
        // AND ps.pang_stamp_vstdate BETWEEN "'.$startdate.'" AND "'.$enddate.'"
        $filen_ = DB::connection('mysql9')->select('SELECT pang_stamp_stm_file_name FROM pang_stamp group by pang_stamp_stm_file_name');
        $sum_uc_money_ = DB::connection('mysql9')->select('
            SELECT SUM(pang_stamp_uc_money) as sumuc_money 
            FROM pang_stamp 
            WHERE pang_stamp_stm_file_name ="'.$filename.'"
        ');
        foreach ($sum_uc_money_ as $key => $value) {
            $sum_uc_money = $value->sumuc_money;
        }

        $sum_stmuc_money_ = DB::connection('mysql9')->select('
            SELECT SUM(pang_stamp_stm_money) as sumstmuc_money 
            FROM pang_stamp 
            WHERE pang_stamp_stm_file_name ="'.$filename.'"
        ');
        foreach ($sum_stmuc_money_ as $key => $value2) {
            $sum_stmuc_money = $value2->sumstmuc_money;
        }

        $sum_hiegt_money_ = DB::connection('mysql9')->select('
            SELECT SUM(pang_stamp_uc_money_minut_stm_money) as sumsthieg_money 
            FROM pang_stamp 
            WHERE pang_stamp_stm_file_name ="'.$filename.'"
        ');
        foreach ($sum_hiegt_money_ as $key => $value3) {
            $sum_hiegt_money = $value3->sumsthieg_money;
        }
        $data_file_ = DB::connection('mysql9')->table('pang_stamp')
        ->leftjoin('stm','stm.stm_file_name','=','pang_stamp.pang_stamp_stm_file_name')
        ->where('pang_stamp_stm_file_name','=',$filename)->first();
        $file_n = $data_file_->stm_file_name;
        // $file_n = $data_file_->pang_stamp_stm_file_name;

        // $data_file_ = DB::connection('mysql9')->select('
        //     SELECT * FROM stm s 
        //     LEFT JOIN pang_stamp p ON p.pang_stamp_stm_file_name = s.stm_file_name
        //     WHERE pang_stamp_stm_file_name ="'.$filename.'"
        // ');

        return view('account_pk.acc_stm',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'acc_stm'       =>     $acc_stm,
            'filen_'        =>     $filen_,
            'sum_uc_money'  =>     $sum_uc_money,
            'sum_stmuc_money'  =>  $sum_stmuc_money,
            'sum_hiegt_money'  =>  $sum_hiegt_money,
            'file_n'  =>  $file_n
        ]);
    }

    public function acc_repstm(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate; 
        $filename = $request->filename;
        $dabudget_year = DB::table('budget_year')->where('active','=',true)->first();
        $data_startdate = $dabudget_year->date_begin;
        $data_enddate = $dabudget_year->date_end;
        $leave_month_year = DB::table('leave_month_year')->get();
        $data_month = DB::table('leave_month')->get();


        $acc_stm = DB::connection('mysql9')->select('
        SELECT IF(ps.pang_stamp_vn IS NULL,"","Y")AS Stamp
                ,ps.pang_stamp_vn AS "vn"
                ,ps.pang_stamp_hn AS "hn"
                ,ps.pang_stamp_an AS "an"
                ,ps.pang_stamp_vstdate
                ,ps.pang_stamp_nhso
                ,ps.pang_stamp_uc_money ,ps.pang_stamp_uc_money_kor_tok
                ,ps.pang_stamp_stm_money AS stm
                ,ps.pang_stamp_uc_money_minut_stm_money
                ,ps.pang_stamp_send
                ,ps.pang_stamp_id
                ,ps.pang_stamp
                ,ps.pang_stamp_stm_file_name ,ps.pang_stamp_stm_rep
                ,ps.pang_stamp_edit_send_id
                ,CONCAT(rn.receipt_book_id,"/",rn.receipt_number_id) AS receipt_n
                ,rn.receipt_date
                ,ps.pang_stamp_rcpt
                ,CONCAT(ps.pang_stamp_pname,ps.pang_stamp_fname," ",ps.pang_stamp_lname) AS pt_name
                
                FROM pang_stamp ps
                LEFT JOIN receipt_number rn ON ps.pang_stamp_stm_file_name = rn.receipt_number_stm_file_name
                WHERE pang_stamp_vstdate BETWEEN "'.$startdate.'" AND "'.$enddate.'"
               
                AND ps.pang_stamp_send IS NOT NULL
                AND ps.pang_stamp_uc_money <> 0
                ORDER BY ps.pang_stamp_hn ;
        '); 
        $filen_ = DB::connection('mysql9')->select('SELECT pang_stamp_stm_file_name FROM pang_stamp group by pang_stamp_stm_file_name');
        $sum_uc_money_ = DB::connection('mysql9')->select('
            SELECT SUM(pang_stamp_uc_money) as sumuc_money 
            FROM pang_stamp 
            WHERE pang_stamp_vstdate BETWEEN "'.$startdate.'" AND "'.$enddate.'"
        ');
        foreach ($sum_uc_money_ as $key => $value) {
            $sum_uc_money = $value->sumuc_money;
        }

        $sum_stmuc_money_ = DB::connection('mysql9')->select('
            SELECT SUM(pang_stamp_stm_money) as sumstmuc_money 
            FROM pang_stamp 
            WHERE pang_stamp_vstdate BETWEEN "'.$startdate.'" AND "'.$enddate.'"
        ');
        foreach ($sum_stmuc_money_ as $key => $value2) {
            $sum_stmuc_money = $value2->sumstmuc_money;
        }

        $sum_hiegt_money_ = DB::connection('mysql9')->select('
            SELECT SUM(pang_stamp_uc_money_minut_stm_money) as sumsthieg_money 
            FROM pang_stamp 
            WHERE pang_stamp_vstdate BETWEEN "'.$startdate.'" AND "'.$enddate.'"
        ');
        foreach ($sum_hiegt_money_ as $key => $value3) {
            $sum_hiegt_money = $value3->sumsthieg_money;
        }
        // $data_file_ = DB::connection('mysql9')->table('pang_stamp')->where('pang_stamp_stm_file_name','=',$filename)->first();
        // $file_n = $data_file_->pang_stamp_stm_file_name;

        return view('account_pk.acc_repstm',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'acc_stm'       =>     $acc_stm,
            'filen_'        =>     $filen_,
            'sum_uc_money'  =>     $sum_uc_money,
            'sum_stmuc_money'  =>  $sum_stmuc_money,
            'sum_hiegt_money'  =>  $sum_hiegt_money,
            // 'file_n'  =>  $file_n
        ]);
    }

    public function upstm(Request $request)
    {
         return view('account_pk.upstm');
    }
    public function upstm_save(Request $request)
    {
        if ($request->hasfile('file')) {
             // Upload path
            // $destinationPath = 'files/';
            // // Create directory if not exists
            // if (!file_exists($destinationPath)) {
            //     mkdir($destinationPath, 0755, true);
            // }
            //  // Get file extension
            // $extension = $request->file('file')->getClientOriginalExtension();
            // // Valid extensions
            // $validextensions = array("jpeg","jpg","png","pdf","xls");
            // // Check extension
            // if(in_array(strtolower($extension), $validextensions)){
            //     // Rename file 
            //     $fileName = str_slug(Carbon::now()->toDayDateTimeString()).rand(11111, 99999) .'.' . $extension;

            //     // Uploading file to given path
            //     $request->file('file')->move($destinationPath, $fileName); 
            // }

            $image = $request->file('file');        
            $imageName = time().'.'.$image->extension();
            $image->move(public_path('Stm'),$imageName);

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setCellValue('A1', 'Hello World !');

            $writer = new Xlsx($spreadsheet);
            $writer->save('hello world.xlsx');

        }

        // I have a table and therefore model to list all excels
        // $excelfile = ExcelFile::fromForm($request->file('file'));

        return response()->json(['success'=>$imageName]);
    }
    public function upstm_import(Request $request)
    {

        // $objPHPExcel = PHPExcel_IOFactory::load($path);
        // $objWorksheet = $objPHPExcel->getActiveSheet();
        // $highestRow = $objWorksheet->getHighestRow();
        // for ($row = 1; $row <= $highestRow; ++$row) {
        //      var_dump($objWorksheet->getCellByColumnAndRow(1, $row));
        // }
        if ($request->hasfile('file')) {
            $inputFileName = time().'.'.$image->extension();
            $inputFileType = PHPExcel_IOFactory::identify($inputFileName);  
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);  
            $objReader->setReadDataOnly(true);  
            $objPHPExcel = $objReader->load($inputFileName);  

            $objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
            $highestRow = $objWorksheet->getHighestRow();
            $highestColumn = $objWorksheet->getHighestColumn();

            $headingsArray = $objWorksheet->rangeToArray('A1:'.$highestColumn.'1',null, true, true, true);
            $headingsArray = $headingsArray[1];

            $r = -1;
            $namedDataArray = array();
            for ($row = 2; $row <= $highestRow; ++$row) {
                $dataRow = $objWorksheet->rangeToArray('A'.$row.':'.$highestColumn.$row,null, true, true, true);
                if ((isset($dataRow[$row]['A'])) && ($dataRow[$row]['A'] > '') && (is_numeric($dataRow[$row]['A'])) && (empty($dataRow[$row]['X'])) ) { //ตรวจคอลัมน์ Excel
                    ++$r;
                    foreach($headingsArray as $columnKey => $columnHeading) {
                        //$namedDataArray[$r][$columnHeading] = $dataRow[$row][$columnKey];
                        foreach (range('A', 'W') as $column){
                            $namedDataArray[$r][$column] = $dataRow[$row][$column];
                        }  
                    }
                }elseif( isset($dataRow[$row]['X']) ){
                    $show_error = "<font style='background-color: red'>ไม่ใช่ STM ข้าราชการ</font>";
                }
            }
        }
        // dd( $namedDataArray);

     return view('account_pk.upstm');
    }
    // *************************** account_pkti2166 ********************************************
    public function account_pkti2166_dash(Request $request)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate; 
        $dabudget_year = DB::table('budget_year')->where('active','=',true)->first();

        $data_startdate = $dabudget_year->date_begin;
        $data_enddate = $dabudget_year->date_end;
        $leave_month_year = DB::table('leave_month_year')->get();
        $data_month = DB::table('leave_month')->get();
      
        // foreach ($data_eave_month_year as $key => $value) {
            $acc_debtors = DB::select('
                SELECT count(vn) as VN from acc_debtor 
                WHERE stamp="N"  
                and account_code="1102050101.2166" ;
            ');
            foreach ($acc_debtors as $key => $value) {
                $acc_debtor = $value->VN;
            }
           
            // dd($acc_debtor);
        // }
        // and month(vstdate) = "01";
        // and month(vstdate) = "'.$value->month_year_code.'";
        //   dd($acc_debtor);

        return view('account_pk.account_pkti2166_dash',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'acc_debtor'    =>     $acc_debtor,
            'leave_month_year' =>  $leave_month_year,
            // 'acc_stam_'     =>     $acc_stam_ 
        ]);
    }
    public function account_pkti2166(Request $request,$id)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $pang = $request->pang_id;
        if ($pang == '') {
            // $pang_id = '';
        } else {
            $pangtype = DB::connection('mysql5')->table('pang')->where('pang_id', '=', $pang)->first();
            $pang_type = $pangtype->pang_type;
            $pang_id = $pang;
        }
        // dd($id);        
        $data['com_tec'] = DB::table('com_tec')->get();
        $data['users'] = User::get();
        $data['pang'] = DB::connection('mysql5')->table('pang')->get(); 
            
        $acc_debtor = DB::select('
                SELECT * from acc_debtor a
                
                WHERE stamp="N"  
                and account_code="1102050101.2166" 
                and month(vstdate) = "'.$id.'";
            ');
         
            // left join acc_debtor_stamp ad on ad.stamp_vn=a.vn
        return view('account_pk.account_pkti2166', $data, [
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'acc_debtor'      =>     $acc_debtor,
            'id'       =>     $id
        ]);
    }
   
   
   
   
   
   
   
   
   
   
    // public function testexcel(){

    //     Excel::create('testfile', function($excel) {
    //         // Set the title
    //         $excel->setTitle('no title');
    //         $excel->setCreator('no no creator')->setCompany('no company');
    //         $excel->setDescription('report file');
    
    //         $excel->sheet('sheet1', function($sheet) {
    //             $data = array(
    //                 array('header1', 'header2','header3','header4','header5','header6','header7'),
    //                 array('data1', 'data2', 300, 400, 500, 0, 100),
    //                 array('data1', 'data2', 300, 400, 500, 0, 100),
    //                 array('data1', 'data2', 300, 400, 500, 0, 100),
    //                 array('data1', 'data2', 300, 400, 500, 0, 100),
    //                 array('data1', 'data2', 300, 400, 500, 0, 100),
    //                 array('data1', 'data2', 300, 400, 500, 0, 100)
    //             );
    //             $sheet->fromArray($data, null, 'A1', false, false);
    //             $sheet->cells('A1:G1', function($cells) {
    //             $cells->setBackground('#AAAAFF');
    
    //             });
    //         });
    //     })->download('xlsx');
    // }

}
 