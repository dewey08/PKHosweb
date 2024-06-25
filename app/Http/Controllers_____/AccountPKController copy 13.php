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
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportAcc_stm_ti; 

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
       
        if ($startdate == '') {
            $acc_debtor = Acc_debtor::where('stamp','=','N')->whereBetween('vstdate', [$datenow, $datenow])->get();
        } else {
            $acc_debtor = Acc_debtor::where('stamp','=','N')->whereBetween('vstdate', [$startdate, $enddate])->get();
        }                        
         
        return view('account_pk.account_pk', $data, [
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'acc_debtor'      =>     $acc_debtor,
            // 'datashow'       =>     $datashow
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
                    ,v.hospmain
                    ,o.vstdate as vstdatesave 
                    ,seekname(o.pt_subtype,"pt_subtype") as ptsubtype 
                    ,ptt.pttype_acc_eclaimid 
                    ,o.pttype,ptt.pttype_acc_name
                    ,e.gf_opd as gfmis,e.code as acc_code
                    ,e.ar_opd as account_code
                    ,e.name as account_name 
                    ,v.income,v.uc_money,v.discount_money,v.paid_money,v.rcpt_money
                    ,v.rcpno_list as rcpno            
                    ,v.income-v.discount_money-v.rcpt_money as debit 
                from ovst o 
                left join vn_stat v on v.vn=o.vn
                left join patient pt on pt.hn=o.hn
                left join pttype_acc ptt on ptt.pttype_acc_code=o.pttype
                left join pttype_eclaim e on e.code=ptt.pttype_acc_eclaimid 

            where o.vstdate between "' . $startdate . '" and "' . $enddate . '" 
            and an IS NULL
            group by o.vn        
        ');
            foreach ($datashow as $key => $value) {
                $check = Acc_debtor::where('vn', $value->vn)->count();
                if ($check > 0) {
                    Acc_debtor::where('vn', $value->vn)
                    ->update([   
                        'hn'                => $value->hn,
                        'an'                => $value->an,
                        'cid'               => $value->cid,
                        'ptname'            => $value->ptname,
                        'ptsubtype'         => $value->ptsubtype,
                        'pttype_eclaim_id'  => $value->pttype_acc_eclaimid,
                        // 'pttype_eclaim_name' => $value->pttype_eclaim_name,
                        'hospmain'          => $value->hospmain,
                        'pttype'            => $value->pttype,
                        'pttypename'        => $value->pttype_acc_name,
                        'vstdate'           => $value->vstdatesave,
                        'vsttime'           => $value->vsttime,
                        'gfmis'             => $value->gfmis,
                        'acc_code'          => $value->acc_code,
                        'account_code'      => $value->account_code,
                        'account_name'      => $value->account_name, 
                        'income'            => $value->income,
                        'uc_money'          => $value->uc_money,
                        'discount_money'    => $value->discount_money,
                        'paid_money'        => $value->paid_money,
                        'rcpt_money'        => $value->rcpt_money,
                        'rcpno'             => $value->rcpno,
                        'debit'             => $value->debit 
                    ]); 
                } else {
                    Acc_debtor::insert([
                        'vn' => $value->vn,
                        'hn'                => $value->hn,
                        'an'                => $value->an,
                        'cid'               => $value->cid,
                        'ptname'            => $value->ptname,
                        'ptsubtype'         => $value->ptsubtype,
                        'pttype_eclaim_id'  => $value->pttype_acc_eclaimid,
                        // 'pttype_eclaim_name' => $value->pttype_eclaim_name,
                        'hospmain'          => $value->hospmain,
                        'pttype'            => $value->pttype,
                        'pttypename'        => $value->pttype_acc_name,
                        'vstdate'           => $value->vstdatesave,
                        'vsttime'           => $value->vsttime,
                        'gfmis'             => $value->gfmis,
                        'acc_code'          => $value->acc_code,
                        'account_code'      => $value->account_code,
                        'account_name'      => $value->account_name, 
                        'income'            => $value->income,
                        'uc_money'          => $value->uc_money,
                        'discount_money'    => $value->discount_money,
                        'paid_money'        => $value->paid_money,
                        'rcpt_money'        => $value->rcpt_money,
                        'rcpno'             => $value->rcpno,
                        'debit'             => $value->debit 
                    ]);
                }
                
            }
 
        return response()->json([
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'status'        => '200' 
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
        //    dd($contents);
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

    public function account_pkCheck_sitipd(Request $request)
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
        $data_sitss = Acc_debtor::whereBetween('dchdate', [$startdate, $enddate])
        ->whereNull('pttype_spsch')
        ->get();
        //   dd($data_sitss);
        foreach ($data_sitss as $key => $item) {
            $pids = $item->cid;
            $an = $item->an;
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
                        Acc_debtor::where('an', $an) 
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
                        Acc_debtor::where('an', $an) 
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
                // }elseif(@$maininscl !="" || @$subinscl !=""){ 
                //             $date_now2 = date('Y-m-d');
                //             Acc_debtor::where('an', $an) 
                //                 ->update([    
                //                     'status'        => @$status,
                //                     'maininscl'     => @$maininscl,
                //                     'pttype_spsch'     => @$subinscl,
                //                     'hmain'         => @$hmain,
                //                     'subinscl'      => @$subinscl, 
                //                     'hmain_op'      => @$hmain_op,
                //                     'hmain_op_name' => @$hmain_op_name,
                //                     'hsub'          => @$hsub,
                //                     'hsub_name'     => @$hsub_name,
                //                     'subinscl_name' => @$subinscl_name 
                //                 ]);   
                    }else{
                        $date_now2 = date('Y-m-d');
                        Acc_debtor::where('an', $an) 
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
    
    // ***************** และ stam OPD********************************
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
                    // 'stamp_vn' => $value->vn,
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
                    'acc_debtor_userid' => $iduser
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
                    'created_at'=> $date,
                    'acc_debtor_userid' => $iduser
                     
                ]);
            }                        
        }
       
        return response()->json([
            'status'    => '200' 
        ]);
    }
  
    // ***************** Send การเงิน ********************************
    public function acc_debtor_send(Request $request)
    {
        $id = $request->ids;
        $iduser = Auth::user()->id;
        $data = Acc_debtor::whereIn('acc_debtor_id',explode(",",$id))->get();

            // Acc_debtor::whereIn('acc_debtor_id',explode(",",$id)) 
            //         ->update([   
            //             'stamp' => 'Y'
            //         ]); 
       
        foreach ($data as $key => $value) {
            $check = Acc_debtor_sendmoney::where('send_vn', $value->vn)->count();
            if ($check > 0) {
                Acc_debtor_stamp::where('send_vn', $value->vn) 
                ->update([   
                    'send_vn' => $value->vn,
                    'send_hn' => $value->hn,
                    'send_an' => $value->an,
                    'send_cid' => $value->cid,
                    'send_ptname' => $value->ptname,
                    'send_vstdate' => $value->vstdate,
                    'send_vsttime' => $value->vsttime,
                    'send_dchdate' => $value->dchdate,
                    'send_pttype' => $value->pttype,
                    'send_pttype_nhso' => $value->pttype_spsch,                   
                    'send_acc_code' => $value->acc_code,
                    'send_account_code' => $value->account_code, 
                    'send_income' => $value->income,
                    'send_uc_money' => $value->uc_money,
                    'send_discount_money' => $value->discount_money,
                    'send_paid_money' => $value->paid_money,
                    'send_rcpt_money' => $value->rcpt_money,
                    'send_rcpno' => $value->rcpno,
                    'send_debit' => $value->debit,
                    'max_debt_amount' => $value->max_debt_amount,
                    'acc_debtor_userid' => $iduser
                ]);  
            } else {
                $date = date('Y-m-d H:m:s');
                Acc_debtor_sendmoney::insert([
                    'send_vn' => $value->vn,
                    'send_hn' => $value->hn,
                    'send_an' => $value->an,
                    'send_cid' => $value->cid,
                    'send_ptname' => $value->ptname,
                    'send_vstdate' => $value->vstdate,
                    'send_vsttime' => $value->vsttime, 
                    'send_dchdate' => $value->dchdate,
                    'send_pttype' => $value->pttype,
                    'send_pttype_nhso' => $value->pttype_spsch,                   
                    'send_acc_code' => $value->acc_code,
                    'send_account_code' => $value->account_code, 
                    'send_income' => $value->income,
                    'send_uc_money' => $value->uc_money,
                    'send_discount_money' => $value->discount_money,
                    'send_paid_money' => $value->paid_money,
                    'send_rcpt_money' => $value->rcpt_money,
                    'send_rcpno' => $value->rcpno,
                    'send_debit' => $value->debit,
                    'max_debt_amount' => $value->max_debt_amount,
                    'created_at'=> $date,
                    'acc_debtor_userid' => $iduser                     
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
        if ($startdate == '') {
            $acc_debtor = Acc_debtor::where('stamp','=','N')->whereBetween('dchdate', [$datenow, $datenow])->get();
        } else {
            $acc_debtor = Acc_debtor::where('stamp','=','N')->whereBetween('dchdate', [$startdate, $enddate])->get();
        }   
                  
        return view('account_pk.account_pk_ipd',[
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
        $acc_debtor = DB::connection('mysql3')->select('
                SELECT a.vn,a.an,a.hn,pt.cid,concat(pt.pname,pt.fname," ",pt.lname) fullname                 
                ,a.regdate as admdate,a.dchdate as dchdate,v.vstdate
                ,a.pttype,ptt.max_debt_money,ec.code,ec.ar_ipd as account_code
                ,ec.name as account_name,ifnull(ec.ar_ipd,"") pang_debit 
                ,a.income as income ,a.uc_money,a.rcpt_money as cash_money,a.discount_money
                ,a.income-a.rcpt_money-a.discount_money as looknee_money 
                ,sum(if(op.income="02",sum_price,0)) as debit_instument  
                ,sum(if(op.icode IN("1560016","1540073","1530005","1540048","1620015","1600012","1600015"),sum_price,0)) as debit_drug
                ,sum(if(op.icode IN ("3001412","3001417"),sum_price,0)) as debit_toa 

                from ipt ip
                LEFT JOIN hos.an_stat a ON ip.an = a.an
                LEFT JOIN patient pt on pt.hn=a.hn
                LEFT JOIN pttype ptt on a.pttype=ptt.pttype 
                LEFT JOIN pttype_eclaim ec on ec.code=ptt.pttype_eclaim_id
                LEFT JOIN hos.ipt_pttype ipt ON ipt.an = a.an
                LEFT JOIN hos.opitemrece op ON ip.an = op.an
                LEFT JOIN hos.vn_stat v on v.vn = a.vn
            WHERE a.dchdate BETWEEN "' . $startdate . '" AND "' . $enddate . '" 
            GROUP BY a.an;  
        ');

        foreach ($acc_debtor as $key => $value) { 
            $check = Acc_debtor::where('an', $value->an) ->count();
            if ($check > 0) {
                Acc_debtor::where('an', $value->an) 
                    ->update([  
                        'income'             => $value->income,
                        'uc_money'           => $value->uc_money,
                        'discount_money'     => $value->discount_money,
                        'paid_money'         => $value->cash_money,
                        'rcpt_money'         => $value->cash_money, 
                        'debit'              => $value->looknee_money,
                        'max_debt_amount'    => $value->max_debt_money
                    ]);     
            } else {
                // $add = new Acc_debtor();
                // $add->hn                = $value->hn;   
                // $add->an                = $value->an; 
                // $add->vn                = $value->vn; 
                // $add->cid               = $value->cid; 
                // $add->ptname            = $value->ptname; 
                // $add->pttype            = $value->pttype; 
                // $add->vstdate           = $value->vstdate; 
                // $add->regdate           = $value->regdate; 
                // $add->dchdate           = $value->dchdate; 
                // $add->account_code      = $value->pang_debit; 
                // $add->account_name      = $value->account_name; 
                // $add->income            = $value->income; 
                // $add->uc_money          = $value->uc_money; 
                // $add->discount_money    = $value->discount_money; 
                // $add->paid_money        = $value->cash_money; 
                // $add->rcpt_money        = $value->cash_money; 
                // $add->debit             = $value->looknee_money; 
                // $add->debit_drug        = $value->debit_drug; 
                // $add->debit_instument   = $value->debit_instument; 
                // $add->debit_toa         = $value->debit_toa; 
                // $add->debit_ipd_total   = $value->looknee_money; 
                // $add->max_debt_amount   = $value->max_debt_money; 
                // $add->save();
                                
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
                    'account_code'       => $value->pang_debit,
                    'account_name'       => $value->account_name,
                    'income'             => $value->income,
                    'uc_money'           => $value->uc_money,
                    'discount_money'     => $value->discount_money,
                    'paid_money'         => $value->cash_money,
                    'rcpt_money'         => $value->cash_money, 
                    'debit'              => $value->looknee_money,
                    'debit_drug'         => $value->debit_drug,
                    'debit_instument'    => $value->debit_instument,
                    'debit_toa'          => $value->debit_toa,
                    'debit_refer'        => "",
                    'debit_ipd_total'    => $value->looknee_money,
                    'max_debt_amount'    => $value->max_debt_money
                ]); 
                if ($value->debit_toa > 0) {
                        Acc_debtor::where('an', $value->an)->where('account_code', '1102050101.202')->whereBetween('dchdate', [$startdate, $enddate])
                        ->update([ 
                            'account_code'     => "1102050101.217" 
                        ]);
                } else { 
                }
                if ($value->debit_instument > 0) {
                      $datains_ = DB::connection('mysql')->select('
                            SELECT *               
                                    from Acc_debtor 
                                    where dchdate between "' . $startdate . '" and "' . $enddate . '"   
                                    and debit_instument >0
                                    AND account_code ="1102050101.202" 
                                    GROUP BY an;     
                        ');
                    // Acc_debtor::where('an', $value->an)->where('account_code', '1102050101.202')->whereBetween('dchdate', [$startdate, $enddate])
                    // ->update([ 
                    //     'account_code'     => "1102050101.217" 
                    // ]);
                // $datains_ = Acc_debtor::where('account_code', '1102050101.202')->where('debit_instument', '<>','')->whereBetween('dchdate', [$startdate, $enddate])->get();
                    foreach ($datains_ as $key => $ins) {
                        Acc_debtor::insert([
                            'hn'                 => $ins->hn,
                            'an'                 => $ins->an,
                            'vn'                 => $ins->vn,
                            'cid'                => $ins->cid,
                            'ptname'             => $ins->fullname,  
                            'pttype'             => $ins->pttype, 
                            'vstdate'            => $ins->vstdate,
                            'regdate'            => $ins->admdate,
                            'dchdate'            => $ins->dchdate,  
                            'account_code'       => '1102050101.217',
                            'account_name'       => 'บริการเฉพาะ(CR)', 
                            'debit'              => $ins->debit_instument, 
                            'debit_ipd_total'    => $ins->debit_instument  
                        ]);
                    }
                } else {
                    # code...
                }
            }                        
        }
        // $opitemrece_ = DB::connection('mysql3')->select('
        //     SELECT SUM(op.sum_price) as debit_drug,a.vn,a.an,a.hn,pt.cid,concat(pt.pname,pt.fname," ",pt.lname) fullname
        //     ,ec.ar_ipd as account_code,a.regdate as admdate
        //     ,a.dchdate as dchdate,v.vstdate
        //     ,a.pttype,ptt.max_debt_money               
        //             from hos.opitemrece op
        //             LEFT JOIN hos.ipt ip ON ip.an = op.an
        //             LEFT JOIN hos.an_stat a ON ip.an = a.an 
        //             LEFT JOIN patient pt on pt.hn=a.hn
        //             LEFT JOIN pttype ptt on a.pttype = ptt.pttype 
        //             LEFT JOIN pttype_eclaim ec on ec.code = ptt.pttype_eclaim_id
        //             LEFT JOIN hos.vn_stat v on v.vn = a.vn
        //             where a.dchdate between "' . $startdate . '" and "' . $enddate . '"   
        //             and op.icode IN("1560016","1540073","1530005","1540048","1620015","1600012","1600015") 
                                   
        //             GROUP BY a.an;     
        // ');
        // foreach ($opitemrece_ as $key => $drug) { 
        //     $check2 = Acc_debtor::where('an', $drug->an)->where('account_code', $drug->account_code)->count();
        //     if ($check2 > 0) {
                  
        //     } else {
        //         Acc_debtor::insert([
        //             'hn'                 => $drug->hn,
        //             'an'                 => $drug->an,
        //             'vn'                 => $drug->vn,
        //             'cid'                => $drug->cid,
        //             'ptname'             => $drug->fullname,  
        //             'pttype'             => $drug->pttype, 
        //             'vstdate'            => $drug->vstdate,
        //             'regdate'            => $drug->admdate,
        //             'dchdate'            => $drug->dchdate,  
        //             'account_code'       => '1102050101.217', 
        //             'debit'              => $drug->debit_drug,             
        //             'debit_drug'         => $drug->debit_drug 
        //         ]);
                
        //     }  

        //     $deb = Acc_debtor::where('an', $drug->an)->first(); 
        //         $de = $deb->debit - $deb->debit_drug;
        //         Acc_debtor::where('an', $drug->an)->where('account_code', $drug->account_code) 
        //         ->update([ 
        //             'debit_ipd_total'     => $de 
        //         ]);
        // }

        // $opitemrece_ins = DB::connection('mysql3')->select('
        //     SELECT SUM(op.sum_price) as debit_instument,a.vn,a.an,a.hn,pt.cid,concat(pt.pname,pt.fname," ",pt.lname) fullname
        //     ,ec.ar_ipd as account_code,a.regdate as admdate
        //     ,a.dchdate as dchdate,v.vstdate
        //     ,a.pttype,ptt.max_debt_money                              
        //             from hos.opitemrece op
        //             LEFT JOIN hos.ipt ip ON ip.an = op.an
        //             LEFT JOIN hos.an_stat a ON ip.an = a.an 
        //             LEFT JOIN patient pt on pt.hn=a.hn
        //             LEFT JOIN pttype ptt on a.pttype = ptt.pttype 
        //             LEFT JOIN pttype_eclaim ec on ec.code = ptt.pttype_eclaim_id
        //             LEFT JOIN hos.vn_stat v on v.vn = a.vn
        //             where a.dchdate between "' . $startdate . '" and "' . $enddate . '"   
        //             AND op.income ="02"                 
        //             GROUP BY a.an;     
        // ');
        // foreach ($opitemrece_ins as $key => $val) { 
        //     $check3 = Acc_debtor::where('an', $val->an)->where('account_code','1102050101.217')->count();
        //     // ->where('account_code', $val->account_code)
        //     if ($check3 > 0) {
        //         # code...
        //     } else {
        //         Acc_debtor::insert([
        //             'hn'                 => $val->hn,
        //             'an'                 => $val->an,
        //             'vn'                 => $val->vn,
        //             'cid'                => $val->cid,
        //             'ptname'             => $val->fullname,  
        //             'pttype'             => $val->pttype, 
        //             'vstdate'            => $val->vstdate,
        //             'regdate'            => $val->admdate,
        //             'dchdate'            => $val->dchdate,  
        //             'account_code'       => '1102050101.217',
        //             'debit'              => $val->debit_instument, 
        //             'debit_ipd_total'    => $val->debit_instument,               
        //             'debit_instument'    => $val->debit_instument 
        //         ]);
        //     }
        //     // $debins = Acc_debtor::where('an', $val->an)->where('account_code','1102050101.202') ->first(); 
        //     // $debins_ = $debins->debit - $val->debit_instument;
        //     // Acc_debtor::where('an', $val->an)->where('account_code','1102050101.217') 
        //     // ->update([ 
        //     //     'debit'              => $debins_,
        //     //     'debit_ipd_total'    => $debins_ 
        //     // ]);
        // }

        // $opitemrece_toa = DB::connection('mysql3')->select('
        //         SELECT a.vn,a.an,a.hn,pt.cid,concat(pt.pname,pt.fname," ",pt.lname) fullname
        //         ,ec.ar_ipd as account_code,a.regdate as admdate
        //         ,a.dchdate as dchdate ,a.pttype,ptt.max_debt_money,SUM(op.sum_price) as debit_toa,v.vstdate                              
        //                 from hos.opitemrece op
        //                 LEFT JOIN hos.ipt ip ON ip.an = op.an
        //                 LEFT JOIN hos.an_stat a ON ip.an = a.an 
        //                 LEFT JOIN patient pt on pt.hn=a.hn
        //                 LEFT JOIN pttype ptt on a.pttype = ptt.pttype 
        //                 LEFT JOIN pttype_eclaim ec on ec.code = ptt.pttype_eclaim_id
        //                 LEFT JOIN hos.vn_stat v on v.vn = a.vn
        //             where a.dchdate between "' . $startdate . '" and "' . $enddate . '"  
        //             and op.icode IN ("3001412","3001417")
        //             and ec.ar_ipd ="1102050101.202" 	 
        //             GROUP BY a.an;     
        // ');
        // foreach ($opitemrece_toa as $key => $toa) { 
        //      Acc_debtor::where('an', $toa->an) 
        //             ->update([ 
        //                 'account_code'     => '1102050101.217'
        //             ]); 
        //  }

            // $check4 = Acc_debtor::where('an', $toa->an)->where('account_code', $toa->account_code)->count();
            // if ($check4 > 0) {
            //     # code...
            // } else {
            //     Acc_debtor::insert([
            //         'hn'                 => $toa->hn,
            //         'an'                 => $toa->an,
            //         'vn'                 => $toa->vn,
            //         'cid'                => $toa->cid,
            //         'ptname'             => $toa->fullname,  
            //         'pttype'             => $toa->pttype, 
            //         'vstdate'            => $toa->vstdate,
            //         'regdate'            => $toa->admdate,
            //         'dchdate'            => $toa->dchdate,  
            //         'account_code'       => '1102050101.217',
            //         'debit'              => $toa->debit_toa               
                     
            //     ]);
            // }
            
        // }
        
            return response()->json([
                 
                'status'    => '200' 
            ]); 
    }
     // *************************** 217 ********************************************
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
                        and income <> 0
                        group by month(a.dchdate) asc;
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
                        and income <>0
                        group by month(a.dchdate) asc;
                '); 
            }
           
         return view('account_pk.account_pkucs217_dash',[
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
             SELECT a.*,c.subinscl from acc_debtor a 
             left outer join check_sit_auto c on c.cid = a.cid and c.vstdate = a.vstdate  
             WHERE a.account_code="1102050101.217"             
             AND a.stamp = "N" and a.income <>0
             and a.account_code="1102050101.217" 
             and month(a.dchdate) = "'.$months.'" and year(a.dchdate) = "'.$year.'";            
         ');        
            
         return view('account_pk.account_pkucs217', $data, [
             'startdate'     =>     $startdate,
             'enddate'       =>     $enddate,
             'acc_debtor'    =>     $acc_debtor,
             'months'        =>     $months,
             'year'          =>     $year
         ]);
     }
      // *************************** 202 ********************************************
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
                    WHERE a.dchdate between "'.$newyear.'" and "'.$date.'"
                    and account_code="1102050101.202"                    
                    and income <> 0
                    group by month(a.dchdate) asc;
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
                    and income <>0
                    group by month(a.dchdate) asc;
            '); 
        }
            
          return view('account_pk.account_pkucs202_dash',[
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
              and a.account_code="1102050101.202" 
              and month(a.dchdate) = "'.$months.'" and year(a.dchdate) = "'.$year.'";
             
          ');        
             
          return view('account_pk.account_pkucs202', $data, [
              'startdate'     =>     $startdate,
              'enddate'       =>     $enddate,
              'acc_debtor'    =>     $acc_debtor,
              'months'        =>     $months,
              'year'          =>     $year
          ]);
      }

     // ***************** และ stam IPD********************************
     public function account_pk_debtor_ipd(Request $request)
     {
         $id = $request->ids;
         $iduser = Auth::user()->id;
         $data = Acc_debtor::whereIn('acc_debtor_id',explode(",",$id))->get();
 
             Acc_debtor::whereIn('acc_debtor_id',explode(",",$id)) 
                     ->update([   
                         'stamp' => 'Y'
                     ]); 
        
         foreach ($data as $key => $value) {
             $check = Acc_debtor_stamp::where('stamp_an', $value->an)->count();
             if ($check > 0) {
                 Acc_debtor_stamp::where('stamp_an', $value->an) 
                 ->update([   
                     'stamp_vn' => $value->vn,
                     'stamp_hn' => $value->hn,
                     // 'stamp_an' => $value->an,
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
                     'acc_debtor_userid' => $iduser
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
                     'created_at'=> $date,
                     'acc_debtor_userid' => $iduser
                      
                 ]);
             }                        
         }
        
         return response()->json([
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
                WHERE stamp="N"  
                and account_code="1102050101.401" ;
            ');
            foreach ($acc_debtors as $key => $value) {
                $acc_debtor = $value->VN;
            }
          
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
                SELECT month(a.vstdate) as months,year(a.vstdate) as year,l.MONTH_NAME
                    ,count(distinct a.hn) as hn
                    ,count(distinct a.vn) as vn 
                    ,sum(a.paid_money) as paid_money 
                    ,sum(a.income) as income                 
                    ,sum(a.income)-sum(a.discount_money)-sum(a.rcpt_money) as total  
                    FROM acc_debtor a  
                    left outer join leave_month l on l.MONTH_ID = month(a.vstdate) 
                    WHERE a.vstdate between "'.$newyear.'" and "'.$date.'"
                    and account_code="1102050102.801"                    
                    and income <> 0
                    group by month(a.vstdate) asc;
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
                    and account_code="1102050102.801"                    
                    and income <> 0
                    group by month(a.vstdate) asc; 
            '); 
        }
                   
        return view('account_pk.account_pklgo801_dash',[
            'startdate'        => $startdate,
            'enddate'          => $enddate,
            'leave_month_year' => $leave_month_year,
            'datashow'         => $datashow,
            'newyear'          => $newyear,
            'date'             => $date,
        ]);
    }
    public function account_pk801(Request $request,$months,$year)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;        
     
        $acc_debtor = DB::select('
            SELECT a.*,c.subinscl from acc_debtor a 
            left outer join check_sit_auto c on c.vn = a.vn 
            WHERE a.account_code="1102050102.801"             
            AND a.stamp = "N" and a.income <>0
            and a.account_code="1102050102.801" 
            and month(a.vstdate) = "'.$months.'" and year(a.vstdate) = "'.$year.'";
           
        ');        
        
        return view('account_pk.account_pk801',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'acc_debtor'    =>     $acc_debtor,
            'months'        =>     $months,
            'year'          =>     $year
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
                

                WHERE ps.pang_stamp_stm_file_name ="'.$filename.'";
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


        // $data_file_ = DB::connection('mysql9')->table('pang_stamp')
        // ->leftjoin('stm','stm.stm_file_name','=','pang_stamp.pang_stamp_stm_file_name')
        // ->where('pang_stamp_stm_file_name','=',$filename)->first();
        // $file_n = $data_file_->stm_file_name;


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
            // 'file_n'  =>  $file_n
        ]);
    }

    public function acc_repstm(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate; 
        $filename = $request->filename;
        $pang_stamp = $request->pang_stamp;
        $dabudget_year = DB::table('budget_year')->where('active','=',true)->first();
        $data_startdate = $dabudget_year->date_begin;
        $data_enddate = $dabudget_year->date_end;
        $leave_month_year = DB::table('leave_month_year')->get();
        $data_month = DB::table('leave_month')->get();
        $pang = DB::connection('mysql9')->table('pang')->get();

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
                ,SUM(ati.price_approve) as price_approve
                ,CONCAT(ps.pang_stamp_pname,ps.pang_stamp_fname," ",ps.pang_stamp_lname) AS pt_name
                
                FROM pang_stamp ps
                LEFT JOIN receipt_number rn ON ps.pang_stamp_stm_file_name = rn.receipt_number_stm_file_name                 
                LEFT JOIN acc_stm_ti ati ON ati.hn = ps.pang_stamp_hn and ati.vstdate = ps.pang_stamp_vstdate
                WHERE ati.vstdate BETWEEN "'.$startdate.'" AND "'.$enddate.'"
                
                AND pang_stamp = "'.$pang_stamp.'"
                GROUP BY ati.cid,ati.vstdate
                ORDER BY ps.pang_stamp_hn ;
        '); 
        $filen_ = DB::connection('mysql9')->select('SELECT pang_stamp_stm_file_name FROM pang_stamp group by pang_stamp_stm_file_name');
        $sum_uc_money_ = DB::connection('mysql9')->select('
            SELECT SUM(pang_stamp_uc_money) as sumuc_money
            FROM pang_stamp 
            WHERE pang_stamp_vstdate BETWEEN "'.$startdate.'" AND "'.$enddate.'"
            AND pang_stamp_send IS NOT NULL
            AND pang_stamp_uc_money <> 0
            AND pang_stamp = "'.$pang_stamp.'"
        ');
        foreach ($sum_uc_money_ as $key => $value) {
            $sum_uc_money = $value->sumuc_money;
           
        }

        $sum_stmuc_money_ = DB::connection('mysql9')->select('
            SELECT SUM(ps.pang_stamp_stm_money) as sumstmuc_money ,SUM(ati.price_approve) as price_approve
            FROM pang_stamp ps
            LEFT JOIN acc_stm_ti ati ON ati.hn = ps.pang_stamp_hn and ati.vstdate = ps.pang_stamp_vstdate
            WHERE ati.vstdate BETWEEN "'.$startdate.'" AND "'.$enddate.'"
            AND ps.pang_stamp_send IS NOT NULL
            AND ps.pang_stamp_uc_money <> 0
            AND ps.pang_stamp = "'.$pang_stamp.'"
           
        ');
        foreach ($sum_stmuc_money_ as $key => $value2) {
            $sum_stmuc_money = $value2->sumstmuc_money;
            $price_approve = $value2->price_approve;
        }

        $sum_hiegt_money_ = DB::connection('mysql9')->select('
            SELECT SUM(pang_stamp_uc_money_minut_stm_money) as sumsthieg_money 
            FROM pang_stamp 
            WHERE pang_stamp_vstdate BETWEEN "'.$startdate.'" AND "'.$enddate.'"
            AND pang_stamp_send IS NOT NULL
            AND pang_stamp_uc_money <> 0
            AND pang_stamp = "'.$pang_stamp.'"
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
            'price_approve'    =>  $price_approve,
            'sum_hiegt_money'  =>  $sum_hiegt_money,
            'pang'             =>  $pang,
            'pang_stamp'       =>  $pang_stamp
        ]);
    }

    public function upstm(Request $request)
    {
         return view('account_pk.upstm');
    }
    public function upstm_save(Request $request)
    {
        if ($request->hasfile('file')) {
             
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
     // *************************** account_pkti 4011*******************************************
 
     public function account_pkti4011_dash(Request $request)
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
                     WHERE a.vstdate between "'.$newyear.'" and "'.$date.'"
                     and account_code="1102050101.4011"                    
                     and income <> 0
                     group by month(a.vstdate) asc;
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
                     and account_code="1102050101.4011"                     
                     and income <>0
                     group by month(a.vstdate) asc;
             '); 
         }          
 
         return view('account_pk.account_pkti4011_dash',[
             'startdate'        => $startdate,
             'enddate'          => $enddate,
             'leave_month_year' => $leave_month_year,
             'datashow'         => $datashow,
             'newyear'          => $newyear,
             'date'             => $date,
         ]);
     }
     public function account_pkti4011(Request $request,$months,$year)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;   
        $acc_debtor = DB::select('
            SELECT a.*,c.subinscl from acc_debtor a 
            left outer join check_sit_auto c on c.vn = a.vn

            WHERE a.account_code="1102050101.4011"             
            AND a.stamp = "N" and a.income <>0
            and a.account_code="1102050101.4011" 
            and month(a.vstdate) = "'.$months.'" and year(a.vstdate) = "'.$year.'";
           
        ');        
      
        return view('account_pk.account_pkti4011',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'acc_debtor'    =>     $acc_debtor,
            'months'        =>     $months,
            'year'          =>     $year
        ]);
    }

    public function account_pkti8011_dash(Request $request)
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
                    WHERE a.vstdate between "'.$newyear.'" and "'.$date.'"
                    and account_code="1102050102.8011"                    
                    and income <> 0
                    group by month(a.vstdate) asc;
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
                    and account_code="1102050102.8011"                     
                    and income <>0
                    group by month(a.vstdate) asc;
            '); 
        }          
 
        return view('account_pk.account_pkti8011_dash',[
            'startdate'        => $startdate,
            'enddate'          => $enddate,
            'leave_month_year' => $leave_month_year,
            'datashow'         => $datashow,
            'newyear'          => $newyear,
            'date'             => $date,
 
        ]);
    }

    // *************************** account_pkti2166 ********************************************
    public function account_pkti2166_dash(Request $request)
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
                    WHERE a.vstdate between "'.$newyear.'" and "'.$date.'"
                    and account_code="1102050101.2166"                    
                    and income <> 0
                    group by month(a.vstdate) asc;
            ');
            // and stamp = "N"
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
                    and account_code="1102050101.2166"                     
                    and income <>0
                    group by month(a.vstdate) asc;
            '); 
        }
        
 

        return view('account_pk.account_pkti2166_dash',[
            'startdate'        => $startdate,
            'enddate'          => $enddate,
            'leave_month_year' => $leave_month_year,
            'datashow'         => $datashow,
            'newyear'          => $newyear,
            'date'             => $date,
        ]);
    }
    public function account_pkti2166(Request $request,$months,$year)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;        
        // dd($id);            
        $data['users'] = User::get();
        
        $acc_debtor = DB::select('
            SELECT a.*,c.subinscl from acc_debtor a 
            left outer join check_sit_auto c on c.vn = a.vn

            WHERE a.account_code="1102050101.2166"             
            AND a.stamp = "N" and a.income <>0
            and a.account_code="1102050101.2166" 
            and month(a.vstdate) = "'.$months.'" and year(a.vstdate) = "'.$year.'";
           
        ');        
        
        return view('account_pk.account_pkti2166', $data, [
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'acc_debtor'    =>     $acc_debtor,
            'months'        =>     $months,
            'year'          =>     $year
        ]);
    }
    public function account_pkti2166_stm(Request $request,$months,$year)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;        
        // dd($id);            
        $data['users'] = User::get();
        
        $acc_debtor = DB::select('
        SELECT a.acc_debtor_id,a.vn,a.an,a.hn,a.vstdate,a.ptname,a.pttype,a.subinscl
        ,a.income,a.uc_money
        FROM acc_debtor a  
        left join acc_stm_ti ac ON ac.cid = a.cid and ac.vstdate = a.vstdate

           SELECT sum(a.price_approve) as priceapprove 
            from acc_stm_ti a 
            LEFT JOIN acc_debtor ad ON ad.cid = a.cid AND ad.vstdate = a.vstdate
                    WHERE ad.account_code="1102050101.2166"             
                    AND ad.stamp = "Y" and ad.income <> 0 
                    and month(ad.vstdate) = "'.$months.'" 
                    and year(ad.vstdate) = "'.$year.'" 
           
        ');  
                    
        return view('account_pk.account_pkti2166_stm', $data, [
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'acc_debtor'    =>     $acc_debtor,
            'months'        =>     $months,
            'year'          =>     $year
        ]);
    }
    public function ti2166_send(Request $request,$id)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;        
        // dd($id);            
        $data['users'] = User::get();
        
        $acc_debtor = DB::select('
                SELECT * from acc_debtor a                
                WHERE stamp="Y"  
                and account_code="1102050101.2166" 
                and month(vstdate) = "'.$id.'";
            ');         
            // left join acc_debtor_stamp ad on ad.stamp_vn=a.vn
        return view('account_pk.ti2166_send', $data, [
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'acc_debtor'      =>     $acc_debtor,
            'id'       =>     $id
        ]);
    }

    public function ti2166_detail(Request $request,$id)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate; 
        $dabudget_year = DB::table('budget_year')->where('active','=',true)->first();

        $data_startdate = $dabudget_year->date_begin;
        $data_enddate = $dabudget_year->date_end;
        $leave_month_year = DB::table('leave_month_year')->get();
        $data_month = DB::table('leave_month')->get();       
        // dd($id);            
        $data['users'] = User::get();
        
        $acc_debtor = DB::select('
                SELECT * from acc_debtor a                
                WHERE account_code="1102050101.2166" 
                and income <> 0
                and month(vstdate) = "'.$id.'";
            ');         
      
        return view('account_pk.ti2166_detail', $data, [
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'acc_debtor'      =>     $acc_debtor,
            'leave_month_year' =>  $leave_month_year,
            'id'       =>     $id
        ]);
    }
   
    // Acc_stm_ti
    public function upstm_ti(Request $request)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate; 
        
        return view('account_pk.upstm_ti',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,            
        ]);
    }
    public function upstm_hn(Request $request)
    { 
        $startdate = $request->datepicker;
        $enddate = $request->datepicker2; 
       
        $acc_debtor = DB::select('
            SELECT tranid,hn,cid,vstdate from acc_stm_ti                
            WHERE vstdate BETWEEN "'.$startdate.'" AND "'.$enddate.'" 
            AND hn is null;
        '); 
        // AND hn is null; 
        foreach ($acc_debtor as $key => $value) {

            $data_ = DB::table('acc_stm_ti')->where('hn','<>','')->where('cid','=',$value->cid)->first();
            $datahn = $data_->hn;
            
            Acc_stm_ti::where('cid', $value->cid)
            // ->where('vstdate', $value->vstdate)
            // ->where('hn','=',$datahn) 
                    ->update([   
                            'hn'   => $datahn  
                ]);
        }
        return view('account_pk.upstm_ti',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,            
        ]);
        // return response()->json([
        //     'status'    => '200'
        // ]);
    }

    public function upstm_ti_import(Request $request)
    {
        // dd($request->file('file'));
        Excel::import(new ImportAcc_stm_ti, $request->file('file')->store('files')); 

        $data_ = DB::connection('mysql')->select('
            SELECT repno,hn,cid,fullname,vstdate,SUM(price_approve) as Sumprice
            FROM acc_stm_ti 
            WHERE price_approve <> ""
            GROUP BY cid,vstdate       
        ');
        foreach ($data_ as $key => $value) {
            // $check = Acc_stm_ti_total::where('cid',$value->cid)->where('vstdate',$value->vstdate);
            // if ($check > 0) {
            //     Acc_stm_ti_total::where('cid',$value->cid)->where('vstdate',$value->vstdate)
            //         ->update([   
            //             'repno'             => $value->repno, 
            //             'hn'                => $value->hn,
            //             'cid'               => $value->cid,
            //             'fullname'          => $value->fullname, 
            //             'vstdate'           => $value->vstdate,  
            //             'sum_price_approve' => $value->Sumprice
            //         ]); 
            // } else {
                Acc_stm_ti_total::create([                
                    'repno'             => $value->repno, 
                    'hn'                => $value->hn,
                    'cid'               => $value->cid,
                    'fullname'          => $value->fullname, 
                    'vstdate'           => $value->vstdate,  
                    'sum_price_approve' => $value->Sumprice
                ]);
            // }
        }

        return response()->json([
            'status'    => '200',
            // 'borrow'    =>  $borrow
        ]); 
    }
    public function upstm_tixml(Request $request)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate; 
        
        return view('account_pk.upstm_tixml',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,            
        ]);
    }
    public function upstm_tixml_import(Request $request)
    {  
            $tar_file_ = $request->file; 
            $file_ = $request->file('file')->getClientOriginalName(); //ชื่อไฟล์
            $filename = pathinfo($file_, PATHINFO_FILENAME);
            $extension = pathinfo($file_, PATHINFO_EXTENSION);  
            $xmlString = file_get_contents(($tar_file_));
            $xmlObject = simplexml_load_string($xmlString);
            $json = json_encode($xmlObject); 
            $result = json_decode($json, true); 
        
            // dd($result);
            @$stmAccountID = $result['stmAccountID'];
            @$hcode = $result['hcode'];
            @$hname = $result['hname'];
            @$AccPeriod = $result['AccPeriod']; 
            @$STMdoc = $result['STMdoc'];
            @$dateStart = $result['dateStart'];
            @$dateEnd = $result['dateEnd'];
            @$dateData = $result['dateData'];
            @$dateIssue = $result['dateIssue'];
            @$acount = $result['acount'];
            @$Total_amount = $result['amount'];
            @$Total_thamount = $result['thamount'];
            @$STMdat = $result['STMdat'];
            @$TBills = $result['TBills']['TBill']; 
            $bills_       = @$TBills;              
                foreach ($bills_ as $value) {                     
                    $hreg = $value['hreg'];
                    $station = $value['station'];
                    $invno = $value['invno'];
                    $hn = $value['hn']; 
                    $amount = $value['amount'];
                    $paid = $value['paid'];
                    $rid = $value['rid']; 
                    $HDflag = $value['HDflag']; 
                    $dttran = $value['dttran'];                     
                    $dttranDate = explode("T",$value['dttran']);
                    $dttdate = $dttranDate[0];
                    $dtttime = $dttranDate[1];
                    $checkc = Acc_stm_ti::where('hn', $hn)->where('vstdate', $dttdate)->count();
                    if ( $checkc > 0) {
                        Acc_stm_ti::where('hn', $hn)->where('vstdate', $dttdate) 
                            ->update([   
                                'invno'            => $invno,
                                'dttran'           => $dttran, 
                                'hn'               => $hn, 
                                'amount'           => $amount, 
                                'paid'             => $paid,
                                'rid'              => $rid, 
                                'HDflag'           => $HDflag,
                                'vstdate'          => $dttdate                                
                            ]);
                        Acc_stm_ti_total::where('hn',$hn)->where('vstdate',$dttdate)
                            ->update([   
                                'invno'             => $invno, 
                                'hn'                => $hn, 
                                'STMdoc'            => @$STMdoc, 
                                'vstdate'           => $dttdate,  
                                'paid'              => $paid,
                                'rid'               => $rid,
                                'HDflag'            => $HDflag,
                                'amount'            => $amount 
                            ]); 
                    } else {
                            Acc_stm_ti::insert([
                                'invno'            => $invno,
                                'dttran'           => $dttran, 
                                'hn'               => $hn, 
                                'amount'           => $amount, 
                                'paid'             => $paid,
                                'rid'              => $rid, 
                                'HDflag'           => $HDflag,
                                'vstdate'          => $dttdate 
                            ]);       
                            
                            Acc_stm_ti_total::insert([                
                                'invno'             => $invno, 
                                'hn'                => $hn, 
                                'STMdoc'            => @$STMdoc, 
                                'vstdate'           => $dttdate,  
                                'paid'              => $paid,
                                'rid'               => $rid,
                                'HDflag'            => $HDflag,
                                'amount'            => $amount 
                            ]);
                         
                    } 
                }
               
                return redirect()->back();
         
    }
   
    public function acc_setting(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $datashow = DB::connection('mysql3')->select('
            SELECT pt.pttype_acc_id,pt.pttype_acc_code,pt.pttype_acc_name as ptname 
            ,pt.pttype_acc_eclaimid,e.name as eclaimname
            ,e.ar_opd,e.ar_ipd
            from pttype_acc pt 
            left join pttype_eclaim e on e.code = pt.pttype_acc_eclaimid 
        ');
        // ,pt.pcode,pt.paidst,pt.hipdata_code,pt.max_debt_money,pt.nhso_code
        $aropd = Pttype_eclaim::where('pttype_eclaim.ar_opd','<>',NULL)->groupBy('pttype_eclaim.ar_opd')->get();
        $aripd = Pttype_eclaim::where('pttype_eclaim.ar_ipd','<>',NULL)->groupBy('pttype_eclaim.ar_ipd')->get();
        // left join pttype_eclaim e on e.code = ptt.pttype_eclaim_id  
         return view('account_pk.acc_setting',[
            'datashow'      =>     $datashow,
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'aropd'         =>     $aropd,
            'aripd'         =>     $aripd,
         ]);
    }
    public function acc_setting_edit(Request $request,$id)
    {
        $type = Pttype_acc::find($id);
              
        return response()->json([
            'status'     => '200',
            'type'       =>  $type,
        ]);
    }
    public function acc_setting_update(Request $request)
    { 
        $accid = $request->input('acc_id');
        $code = $request->input('ar_opd');         
           
        $update = pttype_acc::find($accid);
        $update->pttype_acc_eclaimid = $code;
        $update->save();

        return response()->json([
            'status'     => '200', 
        ]);
    }
    public function acc_setting_save(Request $request)
    { 
        $accid = $request->input('insertpttype');
        $code = $request->input('insertar_opd');         
           
        $add = pttype_acc::find($accid);
        $add->pttype_acc_eclaimid = $code;
        $add->save();

        return response()->json([
            'status'     => '200', 
        ]);
    }
    

}
  