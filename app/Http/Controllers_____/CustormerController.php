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
use App\Models\Patientpk;

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


class CustormerController extends Controller
 { 
    
    public function contact_save(Request $request)
    {
        $datenow = date('Y-m-d');
        
        $add = new Patientpk();
        $add->patientpk_name = $request->patientpk_name;
        $add->patientpk_email = $request->patientpk_email;
        $add->patientpk_subject = $request->patientpk_subject;
        $add->patientpk_message = $request->patientpk_message;
        $add->patientpk_date = $datenow;
        $add->save();

        $linetoken = "9WhX0dXO7HwwdRRgKyqEwt9madYkd893vNmnKKkKnDt"; //ใส่ token line ENV แล้ว       
           
            $smessage = [];
            $header = "ติดต่อเรา";
            $smessage =  $header. 
                    "\n"."ชื่อผู้ติดต่อ : "    . $request->patientpk_name. 
                   "\n"."อีเมล์ : "         . $request->patientpk_email . 
                   "\n"."เรื่อง : "          . $request->patientpk_subject .
                   "\n"."ข้อความ : "       . $request->patientpk_message .
                   "\n"."วันที่ : "          . $datenow ; 
 
                if($linetoken == null){
                    $send_line ='';
                }else{
                    $send_line = $linetoken;
                }  
                if($send_line !== '' && $send_line !== null){ 
 
                        $chOne = curl_init();
                        curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
                        curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0);
                        curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0);
                        curl_setopt( $chOne, CURLOPT_POST, 1);
                        // curl_setopt( $chOne, CURLOPT_POSTFIELDS, $message);
                        curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=$smessage");
                        curl_setopt( $chOne, CURLOPT_FOLLOWLOCATION, 1);
                        $headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$linetoken.'', );
                        curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
                        curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1);
                        $result = curl_exec( $chOne );
                        if(curl_error($chOne)) { echo 'error:' . curl_error($chOne); }
                        else { $result_ = json_decode($result, true);
                        echo "status : ".$result_['status']; 
                        echo "message : ". $result_['message']; }
                        curl_close( $chOne );
                        // return response()->json([
                        //     'status'    => '200'
                        // ]); 
                }  
                return redirect()->route('index');       
        // return response()->json([
        //     'status'    => '200'
        // ]); 
    }
    

   
 


 }