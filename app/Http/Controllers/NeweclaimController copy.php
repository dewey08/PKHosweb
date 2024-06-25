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
use App\Models\Pttype;
 
use App\Models\Api_neweclaim;
use App\Models\Oapp;
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
use Arr; 
use GuzzleHttp\Client;
 
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

class NeweclaimController extends Controller
 { 
    public function check_auth (Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;

        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -5 months')); //ย้อนหลัง 5 เดือน
        $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี

        $data_auth = DB::connection('mysql')->select('
            SELECT *
            FROM api_neweclaim
        ');
        return view('neweclaim.check_auth',[
            'startdate'        => $startdate,
            'enddate'          => $enddate,
            'data_auth'        => $data_auth,
        ]);
    }
    public function check_authapi_2222(Request $request)
    {
        $username        = $request->username;
        $password        = $request->password;
        // $username        = '6508634296688';
        // $password        = 'a12345';
        $ch = curl_init();
        $headers  = [
                    'User-Agent:<platform>/<version> <10978>',
                    'Content-Type: application/json'
                ];
        $postData = [
            'username' => $username,
            'password' => $password
        ];
        curl_setopt($ch, CURLOPT_URL,"https://nhsoapi.nhso.go.th/FMU/ecimp/v1/auth");
        // curl_setopt($ch, CURLOPT_URL,"https://uat-fdh.inet.co.th/hospital/");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response     = curl_exec ($ch);
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE); //200
        $contents = $response;

        $result = json_decode($contents, true);
        @$content = $result['content'];
        // dd($content);

        @$status = $result['status'];
        @$message = $result['message'];
        $token = $result['token'];

        // dd($contents);
        // dd($statusCode);
        // dd($token);
        // dd($result);
        $check = Api_neweclaim::where('api_neweclaim_user',$username)->where('api_neweclaim_pass',$password)->count();
        if ($check > 0) {
            // return response()->json([
            //     'status'       => '100',
            //      'response'    => $response,
            //      'result'      => $result,
            // ]);
            Api_neweclaim::where('api_neweclaim_user',$username)->update([
                // 'api_neweclaim_user'        => $username,
                // 'api_neweclaim_pass'        => $password,
                'api_neweclaim_token'       => $token,
                'user_id'                   => Auth::user()->id,
            ]);
            return response()->json([
                'status'       => '100',
                 'response'    => $response,
                 'result'      => $result,
            ]);
        } else {
            Api_neweclaim::insert([
                'api_neweclaim_user'        => $username,
                'api_neweclaim_pass'        => $password,
                'api_neweclaim_token'       => $token,
                'user_id'                   => Auth::user()->id,
            ]);
            return response()->json([
                'status'       => '200',
                 'response'    => $response,
                 'result'      => $result,
            ]);
        }

    }


    // public function check_authapi_send(Request $request)
    // {
    //     $username        = $request->username;
    //     $password        = $request->password;
    //     // $username        = '6508634296688';
    //     // $password        = 'a12345';
    //     $ch = curl_init();
    //     $headers  = [
    //                 'User-Agent:<platform>/<version> <10978>',
    //                 'Content-Type: application/json'
    //             ];
    //     $postData = [
    //         'username' => $username,
    //         'password' => $password
    //     ];
    //     curl_setopt($ch, CURLOPT_URL,"https://nhsoapi.nhso.go.th/FMU/ecimp/v1/auth");
    //     // curl_setopt($ch, CURLOPT_URL,"https://uat-fdh.inet.co.th/hospital/");
    //     curl_setopt($ch, CURLOPT_POST, 1);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    //     curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
    //     curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    //     $response     = curl_exec ($ch);
    //     $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE); //200
    //     $contents = $response;

    //     $result = json_decode($contents, true);
    //     @$content = $result['content'];
    //     // dd($content);

    //     @$status = $result['status'];
    //     @$message = $result['message'];
    //     $token = $result['token'];

    //     // dd($contents);
    //     // dd($statusCode);
    //     // dd($token);
       
    //     // ***************************** send *******************
    //     #https://tnhsoapi.nhso.go.th/ecimp/v1/auth  #test_zone
    //     #https://nhsoapi.nhso.go.th/FMU/ecimp/v1/auth  #product

    //     // $fame_send = curl_init();

    //     // $postData_send = [
    //     //     "fileType" => "txt",
    //     //     "maininscl" => "",
    //     //     "importDup" => true,
    //     //     "assignToMe" => true,
    //     //     "dataTypes" => ["OP","IP"],
    //     //     "opRefer" => false,
    //     //     "file" => [
    //     //         "ins" => [
    //     //             "blobName" => "INS.txt",
    //     //             "blobType" => "text/plain",
    //     //             "blob" => "$fam_file_base64[0]",
    //     //             "size" => $fam_file_size[0],
    //     //             "encoding" => "UTF-8"
    //     //     ]
    //     //     ,"pat" => [
    //     //             "blobName" => "PAT.txt",
    //     //             "blobType" => "text/plain",
    //     //             "blob" => "$fam_file_base64[1]",
    //     //             "size" => $fam_file_size[1],
    //     //             "encoding" => "UTF-8"
    //     //     ]
    //     //     ,"opd" => [
    //     //             "blobName" => "OPD.txt",
    //     //             "blobType" => "text/plain",
    //     //             "blob" => "$fam_file_base64[2]",
    //     //             "size" => $fam_file_size[2],
    //     //             "encoding" => "UTF-8"
    //     //         ]   
    //     //     ,"orf" => [
    //     //             "blobName" => "ORF.txt",
    //     //             "blobType" => "text/plain",
    //     //             "blob" => "$fam_file_base64[3]",
    //     //             "size" => $fam_file_size[3],
    //     //             "encoding" => "UTF-8"
    //     //     ]
    //     //     ,"odx" => [
    //     //             "blobName" => "ODX.txt",
    //     //             "blobType" => "text/plain",
    //     //             "blob" => "$fam_file_base64[4]",
    //     //             "size" => $fam_file_size[4],
    //     //             "encoding" => "UTF-8"
    //     //     ]
    //     //     ,"oop" => [
    //     //             "blobName" => "OOP.txt",
    //     //             "blobType" => "text/plain",
    //     //             "blob" => "$fam_file_base64[5]",
    //     //             "size" => $fam_file_size[5],
    //     //             "encoding" => "UTF-8"
    //     //     ]
    //     //     ,"ipd" => [
    //     //             "blobName" => "IPD.txt",
    //     //             "blobType" => "text/plain",
    //     //             "blob" => "$fam_file_base64[6]",
    //     //             "size" => $fam_file_size[6],
    //     //             "encoding" => "UTF-8"
    //     //     ]
    //     //     ,"irf" => [
    //     //             "blobName" => "IRF.txt",
    //     //             "blobType" => "text/plain",
    //     //             "blob" => "$fam_file_base64[7]",
    //     //             "size" => $fam_file_size[7],
    //     //             "encoding" => "UTF-8"
    //     //     ]
    //     //     ,"idx" => [
    //     //             "blobName" => "IDX.txt",
    //     //             "blobType" => "text/plain",
    //     //             "blob" => "$fam_file_base64[8]",
    //     //             "size" => $fam_file_size[8],
    //     //             "encoding" => "UTF-8"
    //     //     ]
    //     //     ,"iop" => [
    //     //             "blobName" => "IOP/plain.txt",
    //     //             "blobType" => "text",
    //     //             "blob" => "$fam_file_base64[9]",
    //     //             "size" => $fam_file_size[9],
    //     //             "encoding" => "UTF-8"
    //     //     ]
    //     //     ,"cht" => [
    //     //             "blobName" => "CHT/plain.txt",
    //     //             "blobType" => "text",
    //     //             "blob" => "$fam_file_base64[10]",
    //     //             "size" => $fam_file_size[10],
    //     //             "encoding" => "UTF-8"
    //     //     ]
    //     //     ,"cha" => [
    //     //             "blobName" => "CHA.txt",
    //     //             "blobType" => "text/plain",
    //     //             "blob" => "$fam_file_base64[11]",
    //     //             "size" => $fam_file_size[11],
    //     //             "encoding" => "UTF-8"
    //     //     ]
    //     //     ,"aer" => [
    //     //             "blobName" => "AER.txt",
    //     //             "blobType" => "text/plain",
    //     //             "blob" => "$fam_file_base64[12]",
    //     //             "size" => $fam_file_size[12],
    //     //             "encoding" => "UTF-8"
    //     //     ]
    //     //     ,"adp" => [
    //     //             "blobName" => "ADP.txt",
    //     //             "blobType" => "text/plain",
    //     //             "blob" => "$fam_file_base64[13]",
    //     //             "size" => $fam_file_size[13],
    //     //             "encoding" => "UTF-8"
    //     //     ]
    //     //     ,"lvd" => [
    //     //             "blobName" => "LVD.txt",
    //     //             "blobType" => "text/plain",
    //     //             "blob" => "$fam_file_base64[14]",
    //     //             "size" => $fam_file_size[14],
    //     //             "encoding" => "UTF-8"
    //     //     ]
    //     //     ,"dru" => [
    //     //             "blobName" => "DRU.txt",
    //     //             "blobType" => "text/plain",
    //     //             "blob" => "$fam_file_base64[15]",
    //     //             "size" => $fam_file_size[15],
    //     //             "encoding" => "UTF-8"
    //     //     ]
    //     //     ,"lab" => null
    //     //     ]
    //     // ];

        

    //     #echo json_encode($postData_send, JSON_UNESCAPED_SLASHES);   

    //     // $headers_send  = [
    //     //     'Authorization : Bearer '.$token,
    //     //     'Content-Type: application/json',            
    //     //     'User-Agent:<platform>/<version><10975>'
                
    //     // ];

    //     // #https://tnhsoapi.nhso.go.th/ecimp/v1/send  test_zone
    //     // #https://nhsoapi.nhso.go.th/FMU/ecimp/v1/send
    //     // curl_setopt($fame_send, CURLOPT_URL,"https://nhsoapi.nhso.go.th/FMU/ecimp/v1/send");
    //     // curl_setopt($fame_send, CURLOPT_POST, 1);
    //     // curl_setopt($fame_send, CURLOPT_RETURNTRANSFER, 1);
    //     // curl_setopt($fame_send, CURLOPT_POSTFIELDS, json_encode($postData_send, JSON_UNESCAPED_SLASHES));
    //     // curl_setopt($fame_send, CURLOPT_HTTPHEADER, $headers_send);
    //     // $send_fame_outp     = curl_exec ($fame_send);
    //     // $statusCode_send_fame_outp = curl_getinfo($fame_send, CURLINFO_HTTP_CODE);

    //     // $content_send_fame_outp = $send_fame_outp;
    //     // $result_send_fame_outp = json_decode($content_send_fame_outp, true);

    //     // #echo "<BR>";
    //     // @$status_send = "status_send :".$result_send_fame_outp['status'];
    //     // #echo "<BR>";
    //     // @$message_send = "message_send :".$result_send_fame_outp['message'];
    //     return response()->json([
    //         'status'       => '200',
    //          'response'    => $response,
    //          'result'      => $result,
    //     ]);
    // }

    public function check_authapi(Request $request)
    {
        $username        = $request->username;
        $password        = $request->password; 
        // $ch = curl_init();
        // $headers  = [
        //             'User-Agent:<platform>/<version> <10978>',
        //             'Content-Type: application/json'
        //         ];
        // $postData = [
        //     'username' => $username,
        //     'password' => $password
        // ];
        // curl_setopt($ch, CURLOPT_URL,"https://nhsoapi.nhso.go.th/FMU/ecimp/v1/auth");
        // // curl_setopt($ch, CURLOPT_URL,"https://uat-fdh.inet.co.th/hospital/");
        // curl_setopt($ch, CURLOPT_POST, 1);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
        // curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        // $response     = curl_exec ($ch);
        // $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE); //200
        // $contents = $response;

        // $result = json_decode($contents, true);
        // @$content = $result['content'];
        // // dd($content);

        // @$status = $result['status'];
        // @$message = $result['message'];
        // $token = $result['token'];

        // dd($contents);
        // dd($statusCode);
        // dd($token);
        $authen = Http::post("https://nhsoapi.nhso.go.th/FMU/ecimp/v1/auth",
        [
            'username'    =>  $username ,
            'password'    =>  $password 
        ]);
        $contents = $authen;
         dd($contents);
        $result = json_decode($contents, true);
        @$content = $result['content'];
       

        @$status = $result['status'];
        @$message = $result['message'];
        $token = $result['token'];

         
        return response()->json([
            'status'       => '200',
            //  'response'    => $response,
             'result'      => $result,
        ]);
    }





 }
