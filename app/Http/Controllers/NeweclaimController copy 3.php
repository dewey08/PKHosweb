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
 
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\RequestException;

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


 

    public function check_authapi(Request $request)
    {
        $username        = $request->username;
        $password        = $request->password;        
        $response = Http::withHeaders([ 
            'User-Agent:<platform>/<version> <10978>',
            'Accept' => 'application/json',
        ])->post('https://nhsoapi.nhso.go.th/FMU/ecimp/v1/auth', [
            'username'    =>  $username ,
            'password'    =>  $password 
        ]);        
        // $response = Http::withToken('thetoken')->post('https://nhsoapi.nhso.go.th/FMU/ecimp/v1/auth');
        $token = $response->json('token');
        // dump($response->json('token'));
        // dump($response->status());
        // dump($response->message());
        $check = Api_neweclaim::where('api_neweclaim_user',$username)->where('api_neweclaim_pass',$password)->count();
        if ($check > 0) { 
            Api_neweclaim::where('api_neweclaim_user',$username)->update([ 
                'api_neweclaim_token'       => $token,
                'user_id'                   => Auth::user()->id,
            ]); 
        } else {
            Api_neweclaim::insert([
                'api_neweclaim_user'        => $username,
                'api_neweclaim_pass'        => $password,
                'api_neweclaim_token'       => $token,
                'user_id'                   => Auth::user()->id,
            ]); 
        }
         //     // ***************************** send *******************
         
        $fam_file = array("ins","pat","opd","orf","odx","oop","ipd","irf","idx","iop","cht","cha","aer","adp","lvd","dru");
        foreach ($fam_file as $fam_file_value) {
                // echo "$value <br>";
                // $tp_ins = "temp_opd_".str_replace(".","_",$pang)."_export_".$fam_file_value."_base64";
                // $s_fam_file_value ="SELECT base_64, file_size FROM $tp_ins LIMIT 1 ";
                // @$q_fam_file_value = mysqli_query($con_money, $s_fam_file_value) ; #or die(nl2br ($s_fam_file_value))
                // @$r_fam_file_value = mysqli_fetch_assoc($q_fam_file_value);
                
                @$fam_file_base64[] = $r_fam_file_value["base_64"];

                if(@$r_fam_file_value["file_size"]==''){
                    @$fam_file_size[] = 0;
                }else{
                    @$fam_file_size[] = $r_fam_file_value["file_size"];
                }
                
        }

 
        //     #https://tnhsoapi.nhso.go.th/ecimp/v1/auth  #test_zone
        //     #https://nhsoapi.nhso.go.th/FMU/ecimp/v1/auth  #product

        $fame_send = curl_init();

        $postData_send = [
            "fileType" => "txt",
            "maininscl" => "",
            "dataTypes" => ["OP","IP"],
            "opRefer" => false,
            "importDup" => true,
            "assignToMe" => true,           
            "file" => [
                "ins" => [
                    "blobName" => "INS.txt",
                    "blobType" => "text/plain",
                    "blob" => "$fam_file_base64[0]",
                    "size" => $fam_file_size[0],
                    "encoding" => "UTF-8"
                ]
                ,"pat" => [
                        "blobName" => "PAT.txt",
                        "blobType" => "text/plain",
                        "blob" => "$fam_file_base64[1]",
                        "size" => $fam_file_size[1],
                        "encoding" => "UTF-8"
                ]
                ,"opd" => [
                        "blobName" => "OPD.txt",
                        "blobType" => "text/plain",
                        "blob" => "$fam_file_base64[2]",
                        "size" => $fam_file_size[2],
                        "encoding" => "UTF-8"
                    ]   
                ,"orf" => [
                        "blobName" => "ORF.txt",
                        "blobType" => "text/plain",
                        "blob" => "$fam_file_base64[3]",
                        "size" => $fam_file_size[3],
                        "encoding" => "UTF-8"
                ]
                ,"odx" => [
                        "blobName" => "ODX.txt",
                        "blobType" => "text/plain",
                        "blob" => "$fam_file_base64[4]",
                        "size" => $fam_file_size[4],
                        "encoding" => "UTF-8"
                ]
                ,"oop" => [
                        "blobName" => "OOP.txt",
                        "blobType" => "text/plain",
                        "blob" => "$fam_file_base64[5]",
                        "size" => $fam_file_size[5],
                        "encoding" => "UTF-8"
                ]
                ,"ipd" => [
                        "blobName" => "IPD.txt",
                        "blobType" => "text/plain",
                        "blob" => "$fam_file_base64[6]",
                        "size" => $fam_file_size[6],
                        "encoding" => "UTF-8"
                ]
                ,"irf" => [
                        "blobName" => "IRF.txt",
                        "blobType" => "text/plain",
                        "blob" => "$fam_file_base64[7]",
                        "size" => $fam_file_size[7],
                        "encoding" => "UTF-8"
                ]
                ,"idx" => [
                        "blobName" => "IDX.txt",
                        "blobType" => "text/plain",
                        "blob" => "$fam_file_base64[8]",
                        "size" => $fam_file_size[8],
                        "encoding" => "UTF-8"
                ]
                ,"iop" => [
                        "blobName" => "IOP.txt",
                        "blobType" => "text/plain",
                        "blob" => "$fam_file_base64[9]",
                        "size" => $fam_file_size[9],
                        "encoding" => "UTF-8"
                ]
                ,"cht" => [
                        "blobName" => "CHT.txt",
                        "blobType" => "text/plain",
                        "blob" => "$fam_file_base64[10]",
                        "size" => $fam_file_size[10],
                        "encoding" => "UTF-8"
                ]
                ,"cha" => [
                        "blobName" => "CHA.txt",
                        "blobType" => "text/plain",
                        "blob" => "$fam_file_base64[11]",
                        "size" => $fam_file_size[11],
                        "encoding" => "UTF-8"
                ]
                ,"aer" => [
                        "blobName" => "AER.txt",
                        "blobType" => "text/plain",
                        "blob" => "$fam_file_base64[12]",
                        "size" => $fam_file_size[12],
                        "encoding" => "UTF-8"
                ]
                ,"adp" => [
                        "blobName" => "ADP.txt",
                        "blobType" => "text/plain",
                        "blob" => "$fam_file_base64[13]",
                        "size" => $fam_file_size[13],
                        "encoding" => "UTF-8"
                ]
                ,"lvd" => [
                        "blobName" => "LVD.txt",
                        "blobType" => "text/plain",
                        "blob" => "$fam_file_base64[14]",
                        "size" => $fam_file_size[14],
                        "encoding" => "UTF-8"
                ]
                ,"dru" => [
                        "blobName" => "DRUG.txt",
                        "blobType" => "text/plain",
                        "blob" => "$fam_file_base64[15]",
                        "size" => $fam_file_size[15],
                        "encoding" => "UTF-8"
                ]
                ,"lab" => null
                ]
            ];

        
            // $headers_send  = [
            //     'Authorization : Bearer '.$token,
            //     'Content-Type: application/json',            
            //     'User-Agent:<platform>/<version><10975>'
                    
            // ];

            #https://tnhsoapi.nhso.go.th/ecimp/v1/send  test_zone
            #https://nhsoapi.nhso.go.th/FMU/ecimp/v1/send
            // curl_setopt($fame_send, CURLOPT_URL,"https://nhsoapi.nhso.go.th/FMU/ecimp/v1/send");
            // curl_setopt($fame_send, CURLOPT_POST, 1);
            // curl_setopt($fame_send, CURLOPT_RETURNTRANSFER, 1);
            // curl_setopt($fame_send, CURLOPT_POSTFIELDS, json_encode($postData_send, JSON_UNESCAPED_SLASHES));
            // curl_setopt($fame_send, CURLOPT_HTTPHEADER, $headers_send);
            // $send_fame_outp     = curl_exec ($fame_send);
            // $statusCode_send_fame_outp = curl_getinfo($fame_send, CURLINFO_HTTP_CODE);
            // $content_send_fame_outp = $send_fame_outp;
            // $result_send_fame_outp = json_decode($content_send_fame_outp, true);
            // #echo "<BR>";
            // @$status_send = "status_send :".$result_send_fame_outp['status'];
            // #echo "<BR>";
            // @$message_send = "message_send :".$result_send_fame_outp['message'];

            // ************************
            // $response_send = Http::withHeaders([ 
            //     'Authorization : Bearer '.$token,
            //     'Content-Type: application/json',            
            //     'User-Agent:<platform>/<version><10978>'  
            // ])->post('https://nhsoapi.nhso.go.th/FMU/ecimp/v1/send', [
            //     'postData_send'    =>  $postData_send , 
            // ]);    
            // $token = $response_send->json('token');
            // dump($response_send->json('token'));
            // dump($response_send->status());
            // dump($response_send->message());


        return response()->json([
            'status'       => '200',
             'response'    => $response, 
        ]);
    }

        // $authen = Http::post("https://nhsoapi.nhso.go.th/FMU/ecimp/v1/auth",
        // [
            // 'username'    =>  $username ,
            // 'password'    =>  $password 
        // ]);
        // $contents = $authen;
        //  dd($contents['statusCode']);
        // $result = json_decode($contents, true);
        // @$content = $result['statusCode'];
        // dd( @$content);

        // @$status = $result['status'];
        // @$message = $result['message'];
        // $token = $result['token'];

        // $client = new GuzzleHttp\Client();
        // $res = $client->request('POST', 'https://nhsoapi.nhso.go.th/FMU/ecimp/v1/auth', [
        //     'auth' => ['username', 'password']
        // ]);
        // echo $res->getStatusCode();
        // // "200"
        // echo $res->getHeader('content-type')[0];
        // // 'application/json; charset=utf8'
        // echo $res->getBody();

        // $response = Http::withToken($this->getToken())->retry(2, 0, function (Exception $exception, PendingRequest $request) {
        //     if (! $exception instanceof RequestException || $exception->response->status() !== 401) {
        //         return false;
        //     }
         
        //     $request->withToken($this->getNewToken());
         
        //     return true;
        // })->post('POST', 'https://nhsoapi.nhso.go.th/FMU/ecimp/v1/auth', [
        //         'auth' => ['username', 'password']
        //     ]);


 //   $username        = '6508634296688';
        // $password        = 'a12345';
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
        // $content = $response;

        // $result = json_decode($content, true);
        
        //  @$status = $result['status'];
        // @$message = $result['message'];
        // @$token = $result['token'];
        // dd(@$token);
        // $client = new \GuzzleHttp\Client();
        // $url = "https://nhsoapi.nhso.go.th/FMU/ecimp/v1/auth";
       
        // $data['username'] = "6508634296688";
        // $data['password'] = "a12345";
        // $request = $client->post($url,  ['body'=>$data]);
        // $response = $request->send();
      
        // dd($response);



        //Create Client object to deal with
        // $client = new Client();

        // // Define the request parameters
        // $url = 'https://nhsoapi.nhso.go.th/FMU/ecimp/v1/auth';
        // // dd($url);
        // $headers = [
        //     'User-Agent:<platform>/<version> <10978>',
        //     'Content-Type' => 'application/json',
        // ];

        // $data = [
        //     'username' => $request->input('username'),
        //     'password' => $request->input('password'),
        // ];
        
        // // POST request using the created object
        // $postResponse = $client->post($url, [
        //     'headers'   => $headers,
        //     'json'      => $data,
        // ]);

        // // Get the response
        // dd($postResponse)->json();

        // // Get the response code
        // $responseCode = $postResponse->getStatusCode();
        // // Get OK
        // $responsebody = $postResponse->getReasonPhrase();

        // $responseheeader = $postResponse->getheaders();
        // $responsetoken = $postResponse->json_decode();
         
        // return response()->json([
        //     'status'       => '200',
        //     //  'response'    => $response,
        //     //  'result'      => $result,
        // ]);
    // }





 }
