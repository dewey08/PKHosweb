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
use App\Models\Book_control;

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


class BooktrollController extends Controller
 {
    public function book_inside_manage(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        if ( $startdate != '') {
            $datashow = DB::connection('mysql')->select('SELECT * from book_control b LEFT JOIN users u ON u.id = b.user_id WHERE daterep BETWEEN "'.$startdate.'" AND "'.$enddate.'" ORDER BY daterep DESC'); 
        } else {
            $datashow = DB::connection('mysql')->select('SELECT * from book_control b LEFT JOIN users u ON u.id = b.user_id ORDER BY daterep DESC'); 
        }
        
         return view('bookcontrol.book_inside_manage',[
            'datashow'      =>     $datashow,
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate, 
         ]);
    }
    public function book_inside_manage_save(Request $request)
    {  
        $add = new Book_control(); 
        $add->bookno             = $request->input('bookno');
        $add->datebook           = $request->input('datebook');
        $add->daterep            = $request->input('daterep');
        $add->department_from    = $request->input('department_from');
        $add->bookname           = $request->input('bookname');
        $add->comment            = $request->input('comment');
        $add->user_id            = $request->input('user_id');
        $add->save();

        return response()->json([
            'status'     => '200',
        ]);
    }

    public function book_inside_manage_edit(Request $request,$id)
    {
        $data_show = Book_control::find($id);
        return response()->json([
            'status'               => '200', 
            'data_show'            =>  $data_show,
        ]);
    }

    public function book_inside_manage_update(Request $request)
    {  
        $id = $request->input('book_control_id');
         
        $update = Book_control::find($id); 
        $update->bookno             = $request->input('bookno');
        $update->datebook           = $request->input('datebook');
        $update->daterep            = $request->input('daterep');
        $update->department_from    = $request->input('department_from');
        $update->bookname           = $request->input('bookname');
        $update->comment            = $request->input('comment');
        $update->user_id            = $request->input('user_id');
        $update->save();

        return response()->json([
            'status'     => '200',
        ]);
    }
    public function book_inside_manage_destroy(Request $request,$id)
    {
        
        // $file_ = Acc_stm_repmoney_file::find($id);  
        // $file_name = $file_->filename; 
        // $filepath = public_path('storage/account/'.$file_name);
        // $description = File::delete($filepath);

        $del = Book_control::find($id);  
        $del->delete(); 

        // return redirect()->route('acc.uprep_money');
        return response()->json(['status' => '200']);
    }

 }