<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Authencode;
use App\Models\Vn_insert;
use App\Models\Pttypehistory;
use App\Models\Ovst;
use App\Models\Ptdepart;
use App\Models\Service_time;
use App\Models\Opitemrece;
use App\Models\Visit_pttype;
use App\Models\Ovst_finance;
use App\Models\Opd_regist_sendlist;
use App\Models\Opdscreen;
use App\Models\Patient;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\support\Facades\Hash;
use Illuminate\support\Facades\Validator;
// use Illuminate\support\Facades\Http;
use Stevebauman\Location\Facades\Location;
use Http;
use SoapClient;
use File;
use SplFileObject;
use Arr;
use Storage;

class AuthencodeController extends Controller
{    
    public function authen_main(Request $request)
    {
        $ip = $request->ip();  

        $terminals = Http::get('http://'.$ip.':8189/api/smartcard/terminals')->collect(); 
        $cardcid = Http::get('http://'.$ip.':8189/api/smartcard/read')->collect();  
        $cardcidonly = Http::get('http://'.$ip.':8189/api/smartcard/read-card-only')->collect(); 

        $output = Arr::sort($terminals);
        $outputcard = Arr::sort($cardcid);
        $outputcardonly = Arr::sort($cardcidonly);
        // dd($outputcard);
        if ($output == []) {
        
                $smartcard = 'NO_CONNECT';
                $smartcardcon = '';
                // dd($smartcard);
                return view('authen.authen_main',[  
                    'smartcard'          =>  $smartcard, 
                    'cardcid'            =>  $cardcid,
                    'smartcardcon'       =>  $smartcardcon,
                    'output'             =>  $output,
 
                ]);
                // dd($smartcard);
        } else {
               
                $smartcard = 'CONNECT';
                // dd($smartcard);
                foreach ($output as $key => $value) {
                    $terminalname = $value['terminalName'];
                    $cardcids = $value['isPresent']; 
                }

                // dd($cardcids);
                if ($cardcids != 'false') {
                    $smartcardcon = 'NO_CID';
                    
                            return view('authen.authen_main',[  
                                'smartcard'          =>  $smartcard, 
                                'cardcid'            =>  $cardcid,
                                'smartcardcon'       =>  $smartcardcon,
                                'output'             =>  $output, 
                            ]);
                            // dd($smartcardcon);   
                } else {
                    $smartcardcon = 'CID_OK';
                    // dd($smartcardcon);  
                        $collection = Http::get('http://'.$ip.':8189/api/smartcard/read?readImageFlag=true')->collect();
                        $patient =  DB::connection('mysql10')->select('select cid,hometel from patient limit 10');

                        // $cardcid = Http::get('http://'.$ip.':8189/api/smartcard/read')->collect();   

                        // $output2 = Arr::sort($collection);
                        // // $output3 = Arr::sort($cardcidonly);
                        // // dd($output2['hospMain']['hcode']);
                        // $hcode = $output2['hospMain']['hcode'];
                        // // dd($hcode);
                        // $year = substr(date("Y"),2) +43;
                        // $mounts = date('m');
                        // $day = date('d');
                        // $time = date("His");  
                        // $vn = $year.''.$mounts.''.$day.''.$time;
                        // // dd($vn);OK
                        // $getvn_stat =  DB::connection('mysql10')->select('select * from vn_stat limit 2');
                        // $get_ovst =  DB::connection('mysql10')->select('select * from ovst limit 2');
                        // $get_opdscreen =  DB::connection('mysql10')->select('select * from opdscreen limit 2');
                        // $get_ovst_seq =  DB::connection('mysql10')->select('select * from ovst_seq limit 2');        
                        // $get_spclty =  DB::connection('mysql10')->select('select * from spclty');
                        // ///// เจน  hos_guid  จาก Hosxp
                        // $data_key = DB::connection('mysql10')->select('SELECT uuid() as keygen');  
                        // $output4 = Arr::sort($data_key); 

                        // foreach ($output4 as $key => $value) { 
                        //     $hos_guid = $value->keygen; 
                        // }    
                        // // dd($hos_guid);OK    
                        // $data_patient_ = DB::connection('mysql10')->select(' 
                        //         SELECT p.hn
                        //         ,pe.pttype_expire_date as expiredate
                        //         ,pe.pttype_hospmain as hospmain
                        //         ,pe.pttype_hospsub as hospsub 
                        //         ,p.pttype
                        //         ,pe.pttype_no as pttypeno
                        //         ,pe.pttype_begin_date as begindate,pe.cid
                        //         FROM hos.patient p 
                        //         LEFT OUTER JOIN hos.person pe ON pe.patient_hn = p.hn 
                        //         WHERE p.cid = "'.$collection['pid'].'"
                        // ');
                        // foreach ($data_patient_ as $key => $value) {
                        //     $pids = $value->cid;
                        // }
                      
                        // Vn_insert::insert([
                        //     'vn'         => $vn
                        // ]);
                        // Pttypehistory::insert([ 
                        //     'hn'                => $value->hn,
                        //     'expiredate'        => $value->expiredate,
                        //     'hospmain'          => $value->hospmain,
                        //     'hospsub'           => $value->hospsub,
                        //     'pttype'            => $value->pttype,
                        //     'pttypeno'          => $value->pttypeno,
                        //     'begindate'         => $value->begindate, 
                        //     'hos_guid'          => $hos_guid 
                        // ]);
    
                // } 
                        // dd($pids);OK
                        
                        // if ($datapatient->hometel != null) {
                        //     $tel = $datapatient->hometel;
                        // } else {
                        //     $tel = '';
                        // }   
                         
                        // if ($datapatient->hn != null) {
                        //     $hn = $datapatient->hn;
                        // } else {
                        //     $hn = '';
                        // }  
                        // if ($datapatient->hcode != null) {
                        //     $hcode = $datapatient->hcode;
                        // } else {
                        //     $hcode = '';
                        // } 
                       
                        // $token_data = DB::connection('mysql10')->select('SELECT * FROM nhso_token ORDER BY update_datetime desc limit 1');
                        // foreach ($token_data as $key => $value) { 
                        //     $cid_    = $value->cid;
                        //     $token_  = $value->token;
                        // }
                        // $client = new SoapClient("http://ucws.nhso.go.th/ucwstokenp1/UCWSTokenP1?wsdl",
                        //     array("uri" => 'http://ucws.nhso.go.th/ucwstokenp1/UCWSTokenP1?xsd=1', "trace"=> 1,"exceptions"=> 0,"cache_wsdl"=> 0)
                        //     );
                        //     $params = array(
                        //         'sequence' => array(
                        //             "user_person_id" => "$cid_",
                        //             "smctoken"       => "$token_", 
                        //             "person_id"      => "$pids"
                        //     ) 
                        // ); 
                        // $contents = $client->__soapCall('searchCurrentByPID',$params);
                        // dd($contents);
                        // foreach ($contents as $v) {
                        //     @$status           = $v->status ;
                        //     @$maininscl        = $v->maininscl;
                        //     @$startdate        = $v->startdate;
                        //     @$hmain            = $v->hmain;
                        //     @$subinscl         = $v->subinscl ;
                        //     @$person_id_nhso   = $v->person_id;        
                        //     @$hmain_op         = $v->hmain_op;  //"10978"
                        //     @$hmain_op_name    = $v->hmain_op_name;  //"รพ.ภูเขียวเฉลิมพระเกียรติ"
                        //     @$hsub             = $v->hsub;    //"04047"
                        //     @$hsub_name        = $v->hsub_name;   //"รพ.สต.แดงสว่าง"
                        //     @$subinscl_name    = $v->subinscl_name ; //"ช่วงอายุ 12-59 ปี"
                        // }
                        // dd($hmain);
                        // $curl = curl_init();
                        // curl_setopt_array($curl, array(
                        //     CURLOPT_URL => "http://localhost:8189/api/smartcard/read?readImageFlag=true",
                        //     CURLOPT_RETURNTRANSFER => 1,
                        //     CURLOPT_SSL_VERIFYHOST => 0,
                        //     CURLOPT_SSL_VERIFYPEER => 0,
                        //     CURLOPT_CUSTOMREQUEST => 'GET',
                        // ));

                        // $response = curl_exec($curl);
                        // curl_close($curl);
                        // $content = $response;
                        // $result = json_decode($content, true);

                        // dd($result);
                        // @$pid = $result['pid'];
                        // @$titleName = $result['titleName'];
                        // @$fname = $result['fname'];
                        // @$lname = $result['lname'];
                        // @$nation = $result['nation'];
                        // @$birthDate = $result['birthDate'];
                        // @$sex = $result['sex'];
                        // @$transDate = $result['transDate'];
                        // @$mainInscl = $result['mainInscl'];
                        // @$subInscl = $result['subInscl'];
                        // @$age = $result['age'];
                        // @$checkDate = $result['checkDate'];
                        // @$image = $result['image'];
                        // @$correlationId = $result['correlationId'];
                        // @$startDateTime = $result['startDateTime'];
                        // @$claimTypes = $result['claimTypes'];
                        // $hcode=@$hospMain[1];
                        // @$hcode = $result['hcode'];
                        
                        // @$claimTypes = explode($result['claimType'],$result['claimTypeName']);
                        // $claimDate=$ex_claimDateTime[0];
                        // $checkTime=$ex_claimDateTime[1];
                        // dd(@$claimTypes);
                        // foreach (@$claimTypes as $key => $value) {
                        //     $s = $value['claimType']['0'];
                        //     $ss = $value['claimType']['1'];
                        // }
                        // dd($ss);
                        // $pid        = @$pid;
                        // $fname      = @$fname;
                        // $lname      = @$lname;
                        // $birthDate      = @$birthDate;
                        // $sex      = @$sex;
                        // $mainInscl      = @$mainInscl;
                        // $subInscl      = @$subInscl;
                        // $age      = @$age;
                        // $image      = @$image;
                        // $correlationId      = @$correlationId;
                  
                        return view('authen.authen_main',[  
                            'smartcard'          =>  $smartcard, 
                            'cardcid'            =>  $cardcid,
                            'smartcardcon'       =>  $smartcardcon,
                            'output'             =>  $output, 

                            'collection1'  => $collection['pid'],
                            'collection2'  => $collection['fname'],
                            'collection3'  => $collection['lname'],
                            'collection4'  => $collection['birthDate'],
                            'collection5'  => $collection['transDate'],
                            'collection6'  => $collection['mainInscl'],
                            'collection7'  => $collection['subInscl'],
                            'collection8'  => $collection['age'],
                            'collection9'  => $collection['checkDate'],
                            'collection10' => $collection['correlationId'],
                            'collection11' => $collection['checkDate'],
                            'collection12' => $collection['image'],
                            'collection'   => $collection,
                            'patient'      => $patient,
                         
                        ]);
                }          
        }
        
  
    } 
    public function authen_index(Request $request)
    { 
        // $ip = $request()->ip();
        $ip = $request->ip();
        $collection = Http::get('http://'.$ip.':8189/api/smartcard/read?readImageFlag=true')->collect();
        $patient =  DB::connection('mysql10')->select('select cid,hometel from patient limit 10');
        
        // $terminals = Http::get('http://'.$ip.':8189/api/smartcard/terminals')->collect();
        // $cardcid = Http::get('http://'.$ip.':8189/api/smartcard/read')->collect();
        // $cardcidonly = Http::get('http://'.$ip.':8189/api/smartcard/read-card-only')->collect();
        return view('authen.authen_index',[
            'collection1'  => $collection['pid'],
            'collection2'  => $collection['fname'],
            'collection3'  => $collection['lname'],
            'collection4'  => $collection['birthDate'],
            'collection5'  => $collection['transDate'],
            'collection6'  => $collection['mainInscl'],
            'collection7'  => $collection['subInscl'],
            'collection8'  => $collection['age'],
            'collection9'  => $collection['checkDate'],
            'collection10' => $collection['correlationId'],
            'collection11' => $collection['checkDate'],
           
            'collection'   => $collection,
            'patient'      => $patient
        ]);
   
    }
    public function authencode(Request $req)
    {
        // $authen = Http::post("http://localhost:8189/api/nhso-service/save-as-draft");
        // $cid = $req->pid;
        // $tel = $req->mobile;
        // $cid = '3451000002897';
        // $claimType = 'PG0060001';
        // $mobile = '0832411548';
        // $correlationId = '2341dc4e-9f38-4b93-ad61-5284e68ac5e4';
        // $hcode = '10978';  
        // 124242
        // $cid = '1360400223487';
         
         $authen = Http::post("http://localhost:8189/api/nhso-service/confirm-save/",
        [
            'pid'              =>  $req->pid,
            'claimType'        =>  $req->claimType,
            'mobile'           =>  $req->mobile,
            'correlationId'    =>  $req->correlationId,
            // 'hcode'            =>  $req->hcode
        ]);
 
        Patient::where('cid', $req->pid)
            ->update([
                'hometel'    => $req->mobile
            ]);
 
        // return $authen->json();
        return response()->json([
            'status'     => '200'
        ]);
        
       
        // $authen = Http::post("http://localhost:8189/api/nhso-service/save-as-draft/",[
        //     'pid'              =>  "pid",
        //     'claimType'        =>  "claimType",
        //     'mobile'           =>  "mobile",
        //     'correlationId'    =>  "correlationId",
        //     'hcode'            =>  "hcode"
        // ]);
        // $authen = new Authencode;
        // $authen->pid = $req->pid;
        // $authen->claimType = $req->claimType;
        // $authen->mobile = $req->mobile;
        // $authen->correlationId = $req->correlationId;
        // $authen->hcode = $req->hcode;

        // $result = $authen->save();

        // if ($result) {
        //     return ["result" => "Data Save success"];
        // } else {
        //     return ["result" => "Data Save Fail"];
        // }
        
    }
    public function authencode_visit(Request $request)
    {
        $ip = $request->ip();  

        $terminals = Http::get('http://'.$ip.':8189/api/smartcard/terminals')->collect();        
        $cardcidonly = Http::get('http://'.$ip.':8189/api/smartcard/read-card-only')->collect(); 
        $cardcid = Http::get('http://'.$ip.':8189/api/smartcard/read')->collect(); 
        $output = Arr::sort($terminals);
        $outputcard = Arr::sort($cardcid);
        $outputcardonly = Arr::sort($cardcidonly); 
                
                $collection = Http::get('http://'.$ip.':8189/api/smartcard/read?readImageFlag=true')->collect();
                $patient =  DB::connection('mysql10')->select('select cid,hometel from patient limit 10'); 

                $output2 = Arr::sort($collection);
                // $output3 = Arr::sort($cardcidonly);
                // dd($output2['hospMain']['hcode']);
                $hcode = $output2['hospMain']['hcode'];
                // dd($hcode);
                $year = substr(date("Y"),2) +43;
                $mounts = date('m');
                $day = date('d');
                $time = date("His");  
                $vn = $year.''.$mounts.''.$day.''.$time;

                $date = date('Y-m-d');
                // dd($vn);OK
                $getvn_stat =  DB::connection('mysql10')->select('select * from vn_stat limit 2');
                $get_ovst =  DB::connection('mysql10')->select('select * from ovst limit 2');
                $get_opdscreen =  DB::connection('mysql10')->select('select * from opdscreen limit 2');
                $get_ovst_seq =  DB::connection('mysql10')->select('select * from ovst_seq limit 2');        
                $get_spclty =  DB::connection('mysql10')->select('select * from spclty');
                ///// เจน  hos_guid  จาก Hosxp
                $data_key = DB::connection('mysql10')->select('SELECT uuid() as keygen');  
                $output4 = Arr::sort($data_key); 

                foreach ($output4 as $key => $value) { 
                    $hos_guid = $value->keygen; 
                }    
                // dd($hos_guid);OK    
                $data_patient_ = DB::connection('mysql10')->select(' 
                        SELECT p.hn
                        ,pe.pttype_expire_date as expiredate
                        ,pe.pttype_hospmain as hospmain
                        ,pe.pttype_hospsub as hospsub 
                        ,p.pttype
                        ,pe.pttype_no as pttypeno
                        ,pe.pttype_begin_date as begindate,pe.cid
                        FROM hos.patient p 
                        LEFT OUTER JOIN hos.person pe ON pe.patient_hn = p.hn 
                        WHERE p.cid = "'.$collection['pid'].'"
                ');
                foreach ($data_patient_ as $key => $value) {
                    $pids = $value->cid;
                }
                $token_data = DB::connection('mysql10')->select('SELECT * FROM nhso_token ORDER BY update_datetime desc limit 1');
                foreach ($token_data as $key => $value) { 
                    $cid_    = $value->cid;
                    $token_  = $value->token;
                }
                $client = new SoapClient("http://ucws.nhso.go.th/ucwstokenp1/UCWSTokenP1?wsdl",
                    array("uri" => 'http://ucws.nhso.go.th/ucwstokenp1/UCWSTokenP1?xsd=1', "trace"=> 1,"exceptions"=> 0,"cache_wsdl"=> 0)
                    );
                    $params = array(
                        'sequence' => array(
                            "user_person_id" => "$cid_",
                            "smctoken"       => "$token_", 
                            "person_id"      => "$pids"
                    ) 
                ); 
                $contents = $client->__soapCall('searchCurrentByPID',$params);               
                foreach ($contents as $v) {
                    @$status           = $v->status ;
                    @$maininscl        = $v->maininscl;
                    @$startdate        = $v->startdate;
                    @$hmain            = $v->hmain;
                    @$subinscl         = $v->subinscl ;
                    @$person_id_nhso   = $v->person_id;        
                    @$hmain_op         = $v->hmain_op;  //"10978"
                    @$hmain_op_name    = $v->hmain_op_name;  //"รพ.ภูเขียวเฉลิมพระเกียรติ"
                    @$hsub             = $v->hsub;    //"04047"
                    @$hsub_name        = $v->hsub_name;   //"รพ.สต.แดงสว่าง"
                    @$subinscl_name    = $v->subinscl_name ; //"ช่วงอายุ 12-59 ปี"
                }
                
                Vn_insert::insert([
                    'vn'         => $vn
                ]);
                // Pttypehistory::insert([ 
                //     'hn'                => $value->hn,
                //     'expiredate'        => $value->expiredate,
                //     'hospmain'          => $value->hospmain,
                //     'hospsub'           => $value->hospsub,
                //     'pttype'            => $value->pttype,
                //     'pttypeno'          => $value->pttypeno,
                //     'begindate'         => $value->begindate, 
                //     'hos_guid'          => $hos_guid 
                // ]);
                $max_q = Ovst::max('oqueue');
                Ovst::insert([ 
                    'hos_guid'          => $hos_guid ,
                    'vn'                => $vn,
                    'hn'                => $value->hn,
                    'vstdate'           => $date,
                    'vsttime'           => $time,
                    'hospmain'          => $value->hospmain, 
                    'hospsub'           => $value->hospsub,
                    'oqueue'            => $max_q,
                    'ovstist'           => $value->pttypeno,
                    'ovstost'           => $value->begindate, 
                    'pttype'            => $value->begindate, 
                    'pttypeno'          => $value->begindate, 
                    'spclty'            => $value->begindate, 
                    'hcode'             => $value->begindate, 
                    'last_dep'          => $value->begindate, 
                    'pt_subtype'        => $value->begindate, 
                    'main_dep_queue'    => $value->begindate, 
                    'visit_type'        => $value->begindate, 
                    'node_id'           => $value->begindate, 
                    'waiting'           => $value->begindate, 
                    'has_insurance'     => $value->begindate, 
                    'staff'             => $value->begindate, 
                    'pt_priority'       => $value->begindate, 
                    'ovst_key'          => $value->begindate,                     
                ]);

                dd($contents);
                
                return view('authen.authencode_visit',[  
                    'smartcard'          =>  $smartcard, 
                    'cardcid'            =>  $cardcid,
                    'smartcardcon'       =>  $smartcardcon,
                    'output'             =>  $output, 

                    
                ]);
            }          
        
 

   

    public function authen_cid(Request $req)
    { 
       $collection = Http::get('http://localhost:8189/api/smartcard/read')->collect();
       $status            = '';
       $birthday          = '';
       $fname             = '';
       $lname             = '';
       $hmain             = '';
       $hmain_name        = '';
       $hsub              = '';
       $hsub_name         = '';
       $maininscl         = '';
       $maininscl_main    = '';
       $maininscl_name    = '';
       $expdate           = '';

        // str_pad(string , length , pad_string , pad_type)
        // string คือ สตริงที่ต้องการเติมคำ
        // length คือ ความยาวของสตริงที่ต้องการ
        // pad_string คือ ตัวอักษรหรือคำที่ต้องการเติม
        // pad_type คือ รูปแบบการเติม ค่าที่เป็นไปได้คือ
        // STR_PAD_BOTH - เติมทั้งสองข้าง ถ้าไม่ลงตัวข้างขวาจะถูกเติมมากกว่า
        // STR_PAD_LEFT - เติมด้านซ้าย
        // STR_PAD_RIGHT - เติมด้านขวา (default)
     
        //    $contents = File::get('D:\Authen\nhso_token.txt');
        $ip = $req->ip();
        // $path = ($ip.'/PKAuthen'.'/public/'.'Authen/nhso_token.txt');
        $contents = file('D:\UCAuthenticationMX\nhso_token.txt', FILE_SKIP_EMPTY_LINES|FILE_IGNORE_NEW_LINES);  
        // $contents = file($path, FILE_SKIP_EMPTY_LINES|FILE_IGNORE_NEW_LINES);  
        
        foreach($contents as $line) { 
            // echo str_pad($count, 2, 0, STR_PAD_LEFT).". ".$line;
            // echo $line;
        }

        // $mani = str_pad($line, 5); 
        // echo $mani . "#" . "\n";
       
        // $a="3451000002897#";
        // $count_a = strlen($a);
        // echo $count_a;
        // echo str_pad($count_a, 15, 0, STR_PAD_LEFT);
        // echo "<br>";
        $chars = preg_split('//', $line, -1, PREG_SPLIT_NO_EMPTY);
        // print_r($chars);
        // echo "<br>";
        // $data['output'] = Arr::sort($chars,2);
        $output = Arr::sort($chars,2);
        // dd($output,$chars['17']);
        // dd($data['output']); 
        $data['data1'] = $chars['1']; $data['data2'] = $chars['2']; $data['data3'] = $chars['3']; $data['data4'] = $chars['4'];
        $data['data5'] = $chars['5']; $data['data6'] = $chars['6']; $data['data7'] = $chars['7']; $data['data8'] = $chars['8'];
        $data['data9'] = $chars['9']; $data['data10'] = $chars['10']; $data['data11'] = $chars['11']; $data['data12'] = $chars['12'];
        $data['data13'] = $chars['13']; $data['data14'] = $chars['14']; $data['data15'] = $chars['15']; 
        // $data['data16'] = $chars['16'];

        $data['datacid'] = $data['data3'].''.$data['data4'].''.$data['data5'].''.$data['data6'].''.$data['data7'].''.$data['data8'].''.$data['data9'].''.$data['data10'].''.$data['data11']
        .''.$data['data12'].''.$data['data13'].''.$data['data14'].''.$data['data15'];

        // dd($data['datacid']);

        $data['data17'] = $chars['17'];
        $data['data18'] = $chars['18'];
        $data['data19'] = $chars['19'];
        $data['data20'] = $chars['20'];
        $data['data21'] = $chars['21'];
        $data['data22'] = $chars['22'];
        $data['data23'] = $chars['23'];
        $data['data24'] = $chars['24'];
        $data['data25'] = $chars['25'];
        $data['data26'] = $chars['26'];
        $data['data27'] = $chars['27'];
        $data['data28'] = $chars['28'];
        $data['data29'] = $chars['29'];
        $data['data30'] = $chars['30'];
        $data['data31']= $chars['31'];
        $data['data32'] = $chars['32'];

        $data['datatotal'] = $chars['17'].''.$data['data18'].''.$data['data19'].''.$data['data20'].''.$data['data21'].''.$data['data22'].''.$data['data23'].''.$data['data24'].''.$data['data25'].''.$data['data26'].''.$data['data27']
        .''.$data['data28'].''.$data['data29'].''.$data['data30'].''.$data['data31'].''.$data['data32'];

        // dd($data['datatotal']);
        // echo "function:".str_pad($line,14,".",STR_PAD_RIGHT);  
        // echo "<br>";

        // if(strlen($line) > 15){
        //     $line = mb_substr($line, 0, 15).'...';
        //     }
        //     echo $line;
        //     echo "<br>";

      
        // for($i = 1;$i <$count_a;$i++)
        // {
        //     echo $line[$i];
        //     echo "<br>";
        // }
        // $ar = array();
        // for($i = 0;$i < strlen($line); $i++)
        // {
        //     echo array_push($ar, substr($line,$i,1));
        // }
        // echo str_pad($mani,15,".");  

        // echo str_pad("line", 11, "pp", STR_PAD_BOTH )."\n";
        // echo str_pad($line, 20, "-=", STR_PAD_LEFT)."\n";
        // echo str_pad($line,  15, "*"). "\n"; 
        // echo str_pad($line,5,"$",STR_PAD_LEFT);
        // $myFile = new SplFileObject('D:\Authen\nhso_token.txt');
        // while (!$myFile->eof()) {
        //     echo $myFile->fgets() . PHP_EOL;
        // }

        // $file_handle = fopen('D:\Authen\nhso_token.txt', 'r'); 
        // function get_all_lines($file_handle) { 
        //     while (!feof($file_handle)) {
        //         yield fgets($file_handle);
        //     }
        // }        
        // $count = 0;        
        // foreach (get_all_lines($file_handle) as $line) {
        //     $count += 1;
        //     echo $count.". ".$line;
        // }        
        // fclose($file_handle);
        
        // dd($line);
       return view('authen_cid',$data,
        [
            $status            = $status,
            $birthday          =  $birthday ,
            $fname             = $fname,
            $lname             = $lname,
            $hmain             = $hmain,
            $hmain_name        =  $hmain_name,
            $hsub              = $hsub,
            $hsub_name         = $hsub_name,
            $maininscl         = $maininscl,
            $maininscl_main    = $maininscl_main,
            $maininscl_name    =  $maininscl_name,
            $expdate           = $expdate,
        ]
    );  
    }

    

}

