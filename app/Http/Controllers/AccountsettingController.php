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
use App\Models\Book_control;

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
use App\Models\Acc_setpang_type;
use App\Models\Acc_setpang;

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


class AccountsettingController extends Controller
 {  
    public function acc_settingpang(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;
         
        $datashow = DB::connection('mysql')->select('
            SELECT 
             a.acc_setpang_id,a.pang,a.pangname,a.active,b.acc_setpang_type_id,b.acc_setpang_id as acc_setpang_id2,b.pang as pang2
             ,b.pttype as pttype2,b.hipdata_code,b.icode as icode2,b.icode,b.hospmain
            from acc_setpang a
            LEFT JOIN acc_setpang_type b ON b.acc_setpang_id = a.acc_setpang_id
            GROUP BY a.pang
            ORDER BY b.pang DESC
            '); 
        $data_sit = DB::connection('mysql')->select('SELECT * from pttype');
         return view('account_set.acc_settingpang',[
            'datashow'      =>     $datashow,
            'data_sit'      =>     $data_sit,
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate, 
         ]);
    }
    public function acc_settingpang_save(Request $request)
    {  
        $add = new Acc_setpang(); 
        $add->pang             = $request->input('pang');
        $add->pangname         = $request->input('pangname');
        $add->pttype           = $request->input('pttype');
        $add->icode            = $request->input('icode'); 
        $add->save();

        return response()->json([
            'status'     => '200',
        ]);
    }

    public function acc_settingpang_edit(Request $request,$id)
    {
        $data_show = Acc_setpang::find($id);
        return response()->json([
            'status'               => '200', 
            'data_show'            =>  $data_show,
        ]);
    }

    public function acc_settingpang_update(Request $request)
    {  
        $id = $request->input('acc_setpang_id');
         
        $update = Acc_setpang::find($id); 
        $update->pang             = $request->input('pang');
        $update->pangname         = $request->input('pangname');
        $update->pttype           = $request->input('pttype');
        $update->icode            = $request->input('icode'); 
        $update->save();

        return response()->json([
            'status'     => '200',
        ]);
    }
    public function acc_settingpang_destroy(Request $request,$id)
    { 
        $del = Acc_setpang::find($id);  
        $del->delete();  
        return response()->json(['status' => '200']);
    }

    // **********************************
    public function acc_pang_addtype(Request $request,$id)
    {
        $data_type = Acc_setpang::find($id);
        return response()->json([
            'status'               => '200', 
            'data_type'            =>  $data_type,
        ]);
    }
    public function acc_pang_addtypesave(Request $request)
    {  
        $add = new Acc_setpang_type(); 
        $add->pang             = $request->input('addtypepang');
        $add->acc_setpang_id   = $request->input('acc_setpang_id');
        $add->pttype           = $request->input('addpttype'); 
        $add->opdipd           = $request->input('opdipd'); 
        $add->save();

        return response()->json([
            'status'     => '200',
        ]);
    }
    public function sub_destroy(Request $request,$id)
    { 
        $del = Acc_setpang_type::find($id);  
        $del->delete();  
        return response()->json(['status' => '200']);
    }

    // *********************** icode *************
    public function acc_pang_addicode(Request $request,$id)
    {
        $data_icode = Acc_setpang::find($id);
        return response()->json([
            'status'                => '200', 
            'data_icode'            =>  $data_icode,
        ]);
    }
    public function acc_pang_addicodesave(Request $request)
    {  
        $add = new Acc_setpang_type(); 
        $add->pang             = $request->input('addpangcode');
        $add->acc_setpang_id   = $request->input('acc_setpang_id');
        $add->icode           = $request->input('addicodepang'); 
        $add->save();

        return response()->json([
            'status'     => '200',
        ]);
    }    
   
    public function subicode_destroy(Request $request,$id)
    { 
        // $idd = Acc_setpang_type::where('icode',$id)->first();
        $del = Acc_setpang_type::find($id);  
        $del->delete();  
        return response()->json(['status' => '200']);
    }
    public function acc_pang_addnoicodesave(Request $request)
    {  
        $add = new Acc_setpang_type(); 
        $add->pang             = $request->input('addnopangcode');
        $add->acc_setpang_id   = $request->input('acc_setpang_id');
        $add->no_icode         = $request->input('addnoicodepang'); 
        $add->save();

        return response()->json([
            'status'     => '200',
        ]);
    }

    // *********************** hospmain *************
    public function acc_pang_addhospmain(Request $request,$id)
    {
        $data_hospmain = Acc_setpang::find($id);
        return response()->json([
            'status'                => '200', 
            'data_hospmain'         =>  $data_hospmain,
        ]);
    }
    public function acc_pang_addhospmainsave(Request $request)
    {  
        $add = new Acc_setpang_type(); 
        $add->pang             = $request->input('pang');
        $add->acc_setpang_id   = $request->input('acc_setpang_id');
        $add->hospmain           = $request->input('addhospmainpang'); 
        $add->save();

        return response()->json([
            'status'     => '200',
        ]);
    }
    // hospmain_destroy
    public function hospmain_destroy(Request $request,$id)
    { 
        // $idd = Acc_setpang_type::where('icode',$id)->first();
        $del = Acc_setpang_type::find($id);  
        $del->delete();  
        return response()->json(['status' => '200']);
    }

 }