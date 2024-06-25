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
        // $client = new \GuzzleHttp\Client();
        // $url = "https://nhsoapi.nhso.go.th/FMU/ecimp/v1/auth";
       
        // $data['username'] = "6508634296688";
        // $data['password'] = "a12345";
        // $request = $client->post($url,  ['body'=>$data]);
        // $response = $request->send();
      
        // dd($response);
        // $contents = Http::withHeaders([
        //     'User-Agent:<platform>/<version> <10978>',
        //     'Content-Type: application/json'
        // ])->post('https://nhsoapi.nhso.go.th/FMU/ecimp/v1/auth', [
        //     'username'    =>  $username ,
        //     'password'    =>  $password 
        // ]);
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


        
        //Create Client object to deal with
        $client = new Client();

        // Define the request parameters
        $url = 'https://nhsoapi.nhso.go.th/FMU/ecimp/v1/auth';
        // dd($url);
        $headers = [
            'User-Agent:<platform>/<version> <10978>',
            'Content-Type' => 'application/json',
        ];

        $data = [
            'username' => $request->input('username'),
            'password' => $request->input('password'),
        ];
        
        // POST request using the created object
        $postResponse = $client->post($url, [
            'headers'   => $headers,
            'json'      => $data,
        ]);

        // Get the response
        dd($postResponse)->json();

        // Get the response code
        $responseCode = $postResponse->getStatusCode();
        // Get OK
        $responsebody = $postResponse->getReasonPhrase();

        $responseheeader = $postResponse->getheaders();
        // $responsetoken = $postResponse->json_decode();
         
        return response()->json([
            'status'       => '200',
            //  'response'    => $response,
            //  'result'      => $result,
        ]);
    }





 }
