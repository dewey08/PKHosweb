<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\support\Facades\Hash;
use Illuminate\support\Facades\Validator;
use App\Models\User;
use App\Models\Ot_one;
use PDF;
use setasign\Fpdi\Fpdi;
use App\Models\Budget_year;
use Illuminate\Support\Facades\File;
use DataTables;
use Intervention\Image\ImageManagerStatic as Image;
// use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\OtExport;
// use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Article;
use App\Models\Product_prop;
use App\Models\Product_decline;
use App\Models\Department_sub_sub;
use App\Models\Products_vendor;
use App\Models\Status;
use App\Models\Products_request;
use App\Models\Products_request_sub;
use App\Models\Leave_leader;
use App\Models\Leave_leader_sub;
use App\Models\Check_sit_auto;
use App\Models\Check_sit;
use App\Models\Ssop_stm;
use App\Models\Ssop_session;
use App\Models\Ssop_opdx;
use App\Models\Pang_stamp_temp;
use App\Models\Ssop_token;
use App\Models\Ssop_opservices;
use App\Models\Ssop_dispenseditems;
use App\Models\Ssop_dispensing;
use App\Models\Ssop_billtran;
use App\Models\Ssop_billitems;
use App\Models\Claim_ssop;
use App\Models\Claim_sixteen_dru;
use App\Models\claim_sixteen_adp;
use App\Models\Claim_sixteen_cha;
use App\Models\Claim_sixteen_cht;
use App\Models\Claim_sixteen_oop;
use App\Models\Claim_sixteen_odx;
use App\Models\Claim_sixteen_orf;
use App\Models\Claim_sixteen_pat;
use App\Models\Claim_sixteen_ins;
use App\Models\Claim_temp_ssop;
use App\Models\Claim_sixteen_opd;
use App\Models\Dashboard_authen_day;
use App\Models\Dashboard_department_authen;
use App\Models\Visit_pttype_authen_report;
use App\Models\Dashboard_authenstaff_day;
use App\Models\Acc_debtor;
use App\Models\Check_sit_auto_claim;
use App\Models\Db_year;
use App\Models\Db_authen;
use App\Models\Db_authen_detail;
use App\Models\Check_authen;
use App\Models\Check_sithos_auto;
use App\Models\Check_sit_tiauto;
use App\Models\Check_authen_ti;
use App\Models\Checksit_hos;
use Auth;
use ZipArchive;
use Storage;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Stevebauman\Location\Facades\Location;
use SoapClient;
use SplFileObject;
// use File;

class Auto_authenController extends Controller
{
    // ***************** Check_sit_auto   // ดึงข้อมูลมาไว้เช็คสิทธิ์***************************
   
    public function pull_hosauto(Request $request)
    {          
            $data_sits = DB::connection('mysql3')->select('
                SELECT o.an,o.vn,p.hn,p.cid,o.vstdate,o.vsttime,o.pttype,p.pname,p.fname,concat(p.pname,p.fname," ",p.lname) as fullname,op.name as staffname,p.hometel
                ,pt.nhso_code,o.hospmain,o.hospsub,p.birthday
                ,o.staff,op.name as sname
                ,o.main_dep,v.income-v.discount_money-v.rcpt_money debit
                FROM ovst o
                LEFT JOIN vn_stat v on v.vn = o.vn
                join patient p on p.hn=o.hn
                JOIN pttype pt on pt.pttype=o.pttype
                JOIN opduser op on op.loginname = o.staff
                WHERE o.vstdate = CURDATE()
                AND o.main_dep NOT IN("011","036","107")
                AND o.pttype NOT IN("M1","M2","M3","M4","M5","M6","13","23","91","X7","10")
                AND p.nationality = "99"
                AND p.birthday <> CURDATE()
                group by o.vn
                    
            ');  
            foreach ($data_sits as $key => $value) {
                $check = Check_sit_auto::where('vn', $value->vn)->count();

                if ($check > 0) {
                    // Check_sit_auto::where('vn', $value->vn)
                    //     ->update([ 
                    //         'hometel'       => $value->hometel, 
                    //         'staff_name'    => $value->staffname,
                    //         'main_dep'      => $value->main_dep,
                    //         'staff'         => $value->staff,
                    //         'debit'         => $value->debit
                    //     ]);
                } else {
                    Check_sit_auto::insert([
                        'vn'         => $value->vn,
                        'an'         => $value->an,
                        'hn'         => $value->hn,
                        'cid'        => $value->cid,
                        'vstdate'    => $value->vstdate,
                        'hometel'    => $value->hometel,
                        'vsttime'    => $value->vsttime,
                        'fullname'   => $value->fullname,
                        'pttype'     => $value->pttype,
                        'hospmain'   => $value->hospmain,
                        'hospsub'    => $value->hospsub,
                        'main_dep'   => $value->main_dep,
                        'staff'      => $value->staff,
                        'staff_name' => $value->staffname,
                        'debit'      => $value->debit
                    ]);

                }

            }
            $data_ti = DB::connection('mysql3')->select('
                SELECT o.an,o.vn,p.hn,p.cid,o.vstdate,o.vsttime,o.pttype,concat(p.pname,p.fname," ",p.lname) as fullname,op.name as staffname,p.hometel
                    ,pt.nhso_code,o.hospmain,o.hospsub
                    ,o.staff 
                    ,o.main_dep,v.income-v.discount_money-v.rcpt_money debit
                    FROM ovst o
                    LEFT JOIN vn_stat v on v.vn = o.vn
                    join patient p on p.hn=o.hn
                    JOIN pttype pt on pt.pttype=o.pttype
                    JOIN opduser op on op.loginname = o.staff
                    WHERE o.vstdate = CURDATE() 
                    AND o.pttype IN("M1","M2","M3","M4","M5","M6")
                    AND p.nationality = "99"
                    AND p.birthday <> CURDATE()
                    group by o.vn
                    
            ');
            foreach ($data_ti as $key => $val) {
                $check = Check_sit_tiauto::where('vn', $val->vn)->count();

                if ($check > 0) {
                    
                } else {
                    Check_sit_tiauto::insert([
                        'vn'         => $val->vn,
                        'an'         => $val->an,
                        'hn'         => $val->hn,
                        'cid'        => $val->cid,
                        'vstdate'    => $val->vstdate,
                        'hometel'    => $val->hometel,
                        'vsttime'    => $val->vsttime,
                        'fullname'   => $val->fullname,
                        'pttype'     => $val->pttype,
                        'hospmain'   => $val->hospmain,
                        'hospsub'    => $val->hospsub,
                        'main_dep'   => $val->main_dep,
                        'staff'      => $val->staff,
                        'staff_name' => $val->staffname,
                        'debit'      => $val->debit
                    ]);

                }

            }
            return view('auto.pull_hosauto');
    }

    // ***************** Check_sit_auto   // เช็คสิทธิ์ สปสช ***************************
 
    public function checksit_auto(Request $request)
    {
        $datestart = $request->datestart;
        $dateend = $request->dateend;
        $date = date('Y-m-d');
        // $token_data = DB::connection('mysql')->select('
        //     SELECT cid,token FROM ssop_token
        // ');
       
        // foreach ($token_data as $key => $valuetoken) {
        //     $cid_ = $valuetoken->cid;
        //     $token_ = $valuetoken->token;
        // }
        $data_sitss = DB::connection('mysql')->select('
            SELECT cid,vn,an
            FROM check_sit_auto
            WHERE vstdate = CURDATE()
            AND subinscl IS NULL
            LIMIT 30
        ');
        // BETWEEN "2023-07-01" AND "2023-05-16"       CURDATE()
        foreach ($data_sitss as $key => $item) {
            $pids = $item->cid;
            $vn = $item->vn;
            $an = $item->an;
                $token_data = DB::connection('mysql10')->select('SELECT cid,token FROM hos.nhso_token where token <> ""');
                foreach ($token_data as $key => $value) { 
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
                                // "user_person_id"   => "$cid_",
                                // "smctoken"         => "$token_",
                                "user_person_id" => "$value->cid",
                                "smctoken"       => "$value->token",
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
                            Check_sit_auto::where('vn', $vn)
                                ->update([
                                    'status' => 'จำหน่าย/เสียชีวิต',
                                    'maininscl' => @$maininscl,
                                    'startdate' => @$startdate,
                                    'hmain' => @$hmain,
                                    'subinscl' => @$subinscl,
                                    'person_id_nhso' => @$person_id_nhso,
                                    'hmain_op' => @$hmain_op,
                                    'hmain_op_name' => @$hmain_op_name,
                                    'hsub' => @$hsub,
                                    'hsub_name' => @$hsub_name,
                                    'subinscl_name' => @$subinscl_name,
                                    'upsit_date'    => $date
                            ]);
                            
                        }elseif(@$maininscl !="" || @$subinscl !=""){
                                $date2 = date("Y-m-d");
                                    Check_sit_auto::where('vn', $vn)
                                    ->update([
                                        'status' => @$status,
                                        'maininscl' => @$maininscl,
                                        'startdate' => @$startdate,
                                        'hmain' => @$hmain,
                                        'subinscl' => @$subinscl,
                                        'person_id_nhso' => @$person_id_nhso,
                                        'hmain_op' => @$hmain_op,
                                        'hmain_op_name' => @$hmain_op_name,
                                        'hsub' => @$hsub,
                                        'hsub_name' => @$hsub_name,
                                        'subinscl_name' => @$subinscl_name,
                                        'upsit_date'    => $date2
                                    ]);
                                    
                        }

                    }
                }
        }

        return view('auto.checksit_auto');

    }



    public function pullauthen_spsch(Request $request)
    {
        
        $date_now = date('Y-m-d');
        $date_start = "2023-12-12";
        $date_end = "2023-09-21";
        $url = "https://authenservice.nhso.go.th/authencode/api/authencode-report?hcode=10978&provinceCode=3600&zoneCode=09&claimDateFrom=$date_now&claimDateTo=$date_now&page=0&size=1000&sort=transId,desc";
        // $url = "https://authenservice.nhso.go.th/authencode/api/erm-reg-claim?claimStatus=E&claimDateFrom=$date_now&claimDateTo=$date_now&page=0&size=1000&sort=claimDate,desc";

        // dd($url);https://authenservice.nhso.go.th/authencode/api/authencode-report?hcode=10978&provinceCode=3600&zoneCode=09&claimDateFrom=2023-05-09&claimDateTo=2023-05-09
        $curl = curl_init();
        curl_setopt_array($curl, array(
            // CURLOPT_URL => 'https://authenservice.nhso.go.th/authencode/api/authencode-report?hcode=10978&provinceCode=3600&zoneCode=09&claimDateFrom=2023-05-09&claimDateTo=2023-01-05&page=0&size=1000',
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Accept: application/json, text/plain, */*',
                'Accept-Language: th-TH,th;q=0.9,en-US;q=0.8,en;q=0.7',
                'Connection: keep-alive',
                'Cookie: SESSION=ZDBjZWE3NzktMDVlMy00OTU2LTkwMWEtOTgzN2RiNDY4MGMz; TS01bfdc7f=013bd252cb2f635ea275a9e2adb4f56d3ff24dc90de5421d2173da01a971bc0b2d397ab2bfbe08ef0e379c3946b8487cf4049afe9f2b340d8ce29a35f07f94b37287acd9c2; _ga_B75N90LD24=GS1.1.1665019756.2.0.1665019757.0.0.0; _ga=GA1.3.1794349612.1664942850; TS01e88bc2=013bd252cb8ac81a003458f85ce451e7bd5f66e6a3930b33701914767e3e8af7b92898dd63a6258beec555bbfe4b8681911d19bf0c; SESSION=YmI4MjUyNjYtODY5YS00NWFmLTlmZGItYTU5OWYzZmJmZWNh; TS01bfdc7f=013bd252cbc4ce3230a1e9bdc06904807c8155bd7d0a8060898777cf88368faf4a94f2098f920d5bbd729fbf29d55a388f507d977a65a3dbb3b950b754491e7a240f8f72eb; TS01e88bc2=013bd252cbe2073feef8c43b65869a02b9b370d9108007ac6a34a07f6ae0a96b2967486387a6a0575c46811259afa688d09b5dfd21',
                'Referer: https://authenservice.nhso.go.th/authencode/',
                'Sec-Fetch-Dest: empty',
                'Sec-Fetch-Mode: cors',
                'Sec-Fetch-Site: same-origin',
                'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36',
                'sec-ch-ua: "Not?A_Brand";v="8", "Chromium";v="108", "Google Chrome";v="108"',
                'sec-ch-ua-mobile: ?0',
                'sec-ch-ua-platform: "Windows"'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        // dd($curl);
        $contents = $response;
        // dd($contents);
        $result = json_decode($contents, true);

        @$content = $result['content'];
        // dd($content);

        foreach ($content as $key => $value) {
            $transId = $value['transId'];

            isset( $value['hmain'] ) ? $hmain = $value['hmain'] : $hmain = "";
            isset( $value['hname'] ) ? $hname = $value['hname'] : $hname = "";
            isset( $value['personalId'] ) ? $personalId = $value['personalId'] : $personalId = "";
            isset( $value['patientName'] ) ? $patientName = $value['patientName'] : $patientName = "";
            isset( $value['addrNo'] ) ? $addrNo = $value['addrNo'] : $addrNo = "";
            isset( $value['moo'] ) ? $moo = $value['moo'] : $moo = "";
            isset( $value['moonanName'] ) ? $moonanName = $value['moonanName'] : $moonanName = "";
            isset( $value['tumbonName'] ) ? $tumbonName = $value['tumbonName'] : $tumbonName = "";
            isset( $value['amphurName'] ) ? $amphurName = $value['amphurName'] : $amphurName = "";
            isset( $value['changwatName'] ) ? $changwatName = $value['changwatName'] : $changwatName = "";
            isset( $value['birthdate'] ) ? $birthdate = $value['birthdate'] : $birthdate = "";
            isset( $value['tel'] ) ? $tel = $value['tel'] : $tel = "";
            isset( $value['mainInscl'] ) ? $mainInscl = $value['mainInscl'] : $mainInscl = "";
            isset( $value['mainInsclName'] ) ? $mainInsclName = $value['mainInsclName'] : $mainInsclName = "";
            isset( $value['subInscl'] ) ? $subInscl = $value['subInscl'] : $subInscl = "";
            isset( $value['subInsclName'] ) ? $subInsclName = $value['subInsclName'] : $subInsclName = "";
            isset( $value['claimStatus'] ) ? $claimStatus = $value['claimStatus'] : $claimStatus = "";
            isset( $value['patientType'] ) ? $patientType = $value['patientType'] : $patientType = "";
            isset( $value['claimCode'] ) ? $claimCode = $value['claimCode'] : $claimCode = "";
            isset( $value['claimType'] ) ? $claimType = $value['claimType'] : $claimType = "";
            isset( $value['claimTypeName'] ) ? $claimTypeName = $value['claimTypeName'] : $claimTypeName = "";
            isset( $value['hnCode'] ) ? $hnCode = $value['hnCode'] : $hnCode = "";
            isset( $value['createDate'] ) ? $createDate = $value['createDate'] : $createDate = "";
            isset( $value['claimAuthen'] ) ? $claimAuthen = $value['claimAuthen'] : $claimAuthen = "";
            isset( $value['createBy'] ) ? $createBy = $value['createBy'] : $createBy = "";
            isset( $value['mainInsclWithName'] ) ? $mainInsclWithName = $value['mainInsclWithName'] : $mainInsclWithName = "";
            isset( $value['sourceChannel'] ) ? $sourceChannel = $value['sourceChannel'] : $sourceChannel = "";

            $claimDate = explode("T",$value['claimDate']);
            $checkdate = $claimDate[0];
            $checktime = $claimDate[1];
            // dd($transId);
                $datenow = date("Y-m-d");

                                if ($claimType == 'PG0130001') {
                                    // $checkc = Check_sit_tiauto::where('claimcode','=',$claimCode)->count();
                                    // if ($checkc > 0) {                                       

                                    // } else {
                                    //     Check_sit_tiauto::create([
                                    //         'cid'                        => $personalId,
                                    //         'fullname'                   => $patientName,
                                    //         'hosname'                    => $hname,
                                    //         'hcode'                      => $hmain,
                                    //         'vstdate'                    => $checkdate,
                                    //         'regdate'                    => $checkdate,
                                    //         'claimcode'                  => $claimCode,
                                    //         'claimtype'                  => $claimType,
                                    //         'birthday'                   => $birthdate,
                                    //         'homtel'                     => $tel,
                                    //         'repcode'                    => $claimStatus,
                                    //         'hncode'                     => $hnCode,
                                    //         'servicerep'                 => $patientType,
                                    //         'servicename'                => $claimTypeName,
                                    //         'mainpttype'                 => $mainInsclWithName,
                                    //         'subpttype'                  => $subInsclName,
                                    //         'requestauthen'              => $sourceChannel,
                                    //         'authentication'             => $claimAuthen, 
                                    //     ]);
                                    // }

                                } else {
                                    $checkcs = Check_authen::where('claimcode','=',$claimCode)->where('cid','=',$personalId)->count();
                                    if ($checkcs > 0) {                                       
                                        Check_sit_auto::where('cid','=',$personalId)->where('vstdate','=',$checkdate)->where('claimcode','=',NULL)->update([
                                            'claimcode'       => $claimCode,
                                            'claimtype'       => $claimType,
                                            'servicerep'      => $patientType,
                                            'servicename'     => $claimTypeName,
                                            'authentication'  => $claimAuthen,
                                        ]);  
                                    } else {
                                        Check_authen::create([
                                            'cid'                        => $personalId,
                                            'fullname'                   => $patientName,
                                            'hosname'                    => $hname,
                                            'hcode'                      => $hmain,
                                            'vstdate'                    => $checkdate,
                                            'regdate'                    => $checkdate,
                                            'claimcode'                  => $claimCode,
                                            'claimtype'                  => $claimType,
                                            'birthday'                   => $birthdate,
                                            'homtel'                     => $tel,
                                            'repcode'                    => $claimStatus,
                                            'hncode'                     => $hnCode,
                                            'servicerep'                 => $patientType,
                                            'servicename'                => $claimTypeName,
                                            'mainpttype'                 => $mainInsclWithName,
                                            'subpttype'                  => $subInsclName,
                                            'requestauthen'              => $sourceChannel,
                                            'authentication'             => $claimAuthen, 
                                        ]);

                                        // Check_sit_auto::where('cid','=',$personalId)->where('vstdate','=',$checkdate)->update([
                                        //     'claimcode'       => $claimCode,
                                        //     'claimtype'       => $claimType,
                                        //     'servicerep'      => $patientType,
                                        //     'servicename'     => $claimTypeName,
                                        //     'authentication'  => $claimAuthen,
                                        // ]);  
                                    }

                               
                                }
                    }

        return view('auto.pullauthen_spsch',[
            'response'  => $response,
            'result'  => $result,
        ]);

    }

    public function updaet_authen_to_checksitauto(Request $request)
    {
        $date_now = date('Y-m-d');
        $date_start = "2023-12-12";
        $date_end = "2566-07-22";        
        // $data_ = Check_authen
        // $count = Check_sit_auto::where('vn','<>','')->count(); 
        $data_ = DB::connection('mysql')->select('
                SELECT c.cid,c.vstdate,c.claimcode,c.claimtype,c.servicerep,c.servicename,c.authentication ,ca.claimcode as Caclaimcode
                FROM check_authen c   
                LEFT JOIN check_sit_auto ca ON ca.cid = c.cid and c.vstdate = ca.vstdate
                WHERE c.vstdate = CURDATE()
                AND c.claimtype <> "PG0130001"  
                AND ca.claimcode IS NULL
        '); 
        // SELECT c.cid,c.vstdate,c.claimcode,c.claimtype,c.servicerep,c.servicename,c.authentication,ca.claimcode as Caclaimcode
        //         FROM check_authen c   
        //         LEFT JOIN check_sit_auto ca ON ca.cid = c.cid and c.vstdate = ca.vstdate
        //         WHERE c.vstdate = "2023-12-12"
        //         AND c.claimtype <> "PG0130001" 
        //         AND ca.claimcode IS NULL
        // CURDATE()
        foreach ($data_ as $key => $value) {   
            //  $count = Check_sit_auto::where('claimcode','=',$value->claimcode)->count(); 
            //  if ($count>0) {
            //     Check_sit_auto::where('claimcode','=',$value->claimcode)->update([ 
            //         'claimtype'       => $value->claimtype,
            //         'servicerep'      => $value->servicerep,
            //         'servicename'     => $value->servicename,
            //         'authentication'  => $value->authentication,
            //     ]);   
            //  } else {
                Check_sit_auto::where('cid','=',$value->cid)->where('vstdate','=',$value->vstdate)->update([
                    'claimcode'       => $value->claimcode,
                    'claimtype'       => $value->claimtype,
                    'servicerep'      => $value->servicerep,
                    'servicename'     => $value->servicename,
                    'authentication'  => $value->authentication,
                ]);   
            //  }             
             
        }

        return view('auto.updaet_authen_to_checksitauto');

    }


    public function checksithos_auto(Request $request)
    {
        $date_now = date('Y-m-d');
        $date_start = "2023-08-14";
        $date_end = "2566-07-22";
        
        $data_ = DB::connection('mysql')->select('
            SELECT vn,an,hn,cid,vstdate,hometel,vsttime,fullname,pttype,hospmain,hospsub,main_dep,staff,staff_name,claimcode,claimtype,servicerep,servicename,authentication,debit 
            FROM check_sit_auto   
            WHERE vstdate = CURDATE()  
            LIMIT 100    
        '); 
        foreach ($data_ as $key => $value) {   
             $count = Check_sithos_auto::where('vn','=',$value->vn)->count(); 
             if ($count>0) {
                # code...
             } else {
                // Check_sithos_auto::where('cid','=',$value->cid)->where('vstdate','=',$value->vstdate)->update([
                //     'claimcode'       => $value->claimcode,
                //     'claimtype'       => $value->claimtype,
                //     'servicerep'      => $value->servicerep,
                //     'servicename'     => $value->servicename,
                //     'authentication'  => $value->authentication,
                // ]);  
                Check_sithos_auto::insert([
                    'vn'                => $value->vn,
                    'an'                => $value->an,
                    'hn'                => $value->hn,
                    'cid'               => $value->cid,
                    'vstdate'           => $value->vstdate,
                    'hometel'           => $value->hometel,
                    'vsttime'           => $value->vsttime,
                    'fullname'          => $value->fullname,
                    'pttype'            => $value->pttype,
                    'hospmain'          => $value->hospmain,
                    'hospsub'           => $value->hospsub,
                    'main_dep'          => $value->main_dep,
                    'staff'             => $value->staff,
                    'staff_name'        => $value->staffname,
                    'claimcode'         => $value->claimcode,
                    'claimtype'         => $value->claimtype,
                    'servicerep'        => $value->servicerep,
                    'servicename'       => $value->servicename,
                    'authentication'    => $value->authentication,
                    'debit'             => $value->debit
                ]); 

             }
             
             
        }

        return view('auto.checksithos_auto');

    }


    // ไตเทียม
    
    public function pullauthen_tispsch(Request $request)
    {
        $date_now = date('Y-m-d');
        $date_start = "2023-08-14";
        $date_end = "2023-08-13";
        $url = "https://authenservice.nhso.go.th/authencode/api/authencode-report?hcode=10978&provinceCode=3600&zoneCode=09&claimDateFrom=$date_now&claimDateTo=$date_now&page=0&size=1000&sort=transId,desc";
        // $url = "https://authenservice.nhso.go.th/authencode/api/erm-reg-claim?claimStatus=E&claimDateFrom=$date_now&claimDateTo=$date_now&page=0&size=1000&sort=claimDate,desc";

        // dd($url);https://authenservice.nhso.go.th/authencode/api/authencode-report?hcode=10978&provinceCode=3600&zoneCode=09&claimDateFrom=2023-05-09&claimDateTo=2023-05-09
        $curl = curl_init();
        curl_setopt_array($curl, array(
            // CURLOPT_URL => 'https://authenservice.nhso.go.th/authencode/api/authencode-report?hcode=10978&provinceCode=3600&zoneCode=09&claimDateFrom=2023-05-09&claimDateTo=2023-01-05&page=0&size=1000',
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Accept: application/json, text/plain, */*',
                'Accept-Language: th-TH,th;q=0.9,en-US;q=0.8,en;q=0.7',
                'Connection: keep-alive',
                'Cookie: SESSION=OTc0NTYxMjgtNzJhMi00YzY0LWIzZjgtMWVmNWU3MzIwZjZi; TS01bfdc7f=013bd252cb2f635ea275a9e2adb4f56d3ff24dc90de5421d2173da01a971bc0b2d397ab2bfbe08ef0e379c3946b8487cf4049afe9f2b340d8ce29a35f07f94b37287acd9c2; _ga_B75N90LD24=GS1.1.1665019756.2.0.1665019757.0.0.0; _ga=GA1.3.1794349612.1664942850; TS01e88bc2=013bd252cb8ac81a003458f85ce451e7bd5f66e6a3930b33701914767e3e8af7b92898dd63a6258beec555bbfe4b8681911d19bf0c; SESSION=YmI4MjUyNjYtODY5YS00NWFmLTlmZGItYTU5OWYzZmJmZWNh; TS01bfdc7f=013bd252cbc4ce3230a1e9bdc06904807c8155bd7d0a8060898777cf88368faf4a94f2098f920d5bbd729fbf29d55a388f507d977a65a3dbb3b950b754491e7a240f8f72eb; TS01e88bc2=013bd252cbe2073feef8c43b65869a02b9b370d9108007ac6a34a07f6ae0a96b2967486387a6a0575c46811259afa688d09b5dfd21',
                'Referer: https://authenservice.nhso.go.th/authencode/',
                'Sec-Fetch-Dest: empty',
                'Sec-Fetch-Mode: cors',
                'Sec-Fetch-Site: same-origin',
                'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36',
                'sec-ch-ua: "Not?A_Brand";v="8", "Chromium";v="108", "Google Chrome";v="108"',
                'sec-ch-ua-mobile: ?0',
                'sec-ch-ua-platform: "Windows"'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        // dd($curl);
        $contents = $response;
        // dd($contents);
        $result = json_decode($contents, true);

        @$content = $result['content'];
        // dd($content);

        foreach ($content as $key => $value) {
            $transId = $value['transId'];

            isset( $value['hmain'] ) ? $hmain = $value['hmain'] : $hmain = "";
            isset( $value['hname'] ) ? $hname = $value['hname'] : $hname = "";
            isset( $value['personalId'] ) ? $personalId = $value['personalId'] : $personalId = "";
            isset( $value['patientName'] ) ? $patientName = $value['patientName'] : $patientName = "";
            isset( $value['addrNo'] ) ? $addrNo = $value['addrNo'] : $addrNo = "";
            isset( $value['moo'] ) ? $moo = $value['moo'] : $moo = "";
            isset( $value['moonanName'] ) ? $moonanName = $value['moonanName'] : $moonanName = "";
            isset( $value['tumbonName'] ) ? $tumbonName = $value['tumbonName'] : $tumbonName = "";
            isset( $value['amphurName'] ) ? $amphurName = $value['amphurName'] : $amphurName = "";
            isset( $value['changwatName'] ) ? $changwatName = $value['changwatName'] : $changwatName = "";
            isset( $value['birthdate'] ) ? $birthdate = $value['birthdate'] : $birthdate = "";
            isset( $value['tel'] ) ? $tel = $value['tel'] : $tel = "";
            isset( $value['mainInscl'] ) ? $mainInscl = $value['mainInscl'] : $mainInscl = "";
            isset( $value['mainInsclName'] ) ? $mainInsclName = $value['mainInsclName'] : $mainInsclName = "";
            isset( $value['subInscl'] ) ? $subInscl = $value['subInscl'] : $subInscl = "";
            isset( $value['subInsclName'] ) ? $subInsclName = $value['subInsclName'] : $subInsclName = "";
            isset( $value['claimStatus'] ) ? $claimStatus = $value['claimStatus'] : $claimStatus = "";
            isset( $value['patientType'] ) ? $patientType = $value['patientType'] : $patientType = "";
            isset( $value['claimCode'] ) ? $claimCode = $value['claimCode'] : $claimCode = "";
            isset( $value['claimType'] ) ? $claimType = $value['claimType'] : $claimType = "";
            isset( $value['claimTypeName'] ) ? $claimTypeName = $value['claimTypeName'] : $claimTypeName = "";
            isset( $value['hnCode'] ) ? $hnCode = $value['hnCode'] : $hnCode = "";
            isset( $value['createDate'] ) ? $createDate = $value['createDate'] : $createDate = "";
            isset( $value['claimAuthen'] ) ? $claimAuthen = $value['claimAuthen'] : $claimAuthen = "";
            isset( $value['createBy'] ) ? $createBy = $value['createBy'] : $createBy = "";
            isset( $value['mainInsclWithName'] ) ? $mainInsclWithName = $value['mainInsclWithName'] : $mainInsclWithName = "";
            isset( $value['sourceChannel'] ) ? $sourceChannel = $value['sourceChannel'] : $sourceChannel = "";

            $claimDate = explode("T",$value['claimDate']);
            $checkdate = $claimDate[0];
            $checktime = $claimDate[1];
            // dd($transId);
                $datenow = date("Y-m-d");

                                if ($claimType == 'PG0130001') {
                                    $checkc = Check_authen_ti::where('cid','=',$personalId)->where('vstdate','=',$checkdate)->count();
                                    if ($checkc > 0) {                                       
                                        Check_authen_ti::where('cid','=',$personalId)->where('vstdate','=',$checkdate)->update([
                                            'cid'                        => $personalId,
                                            'fullname'                   => $patientName,
                                            'hosname'                    => $hname,
                                            'hcode'                      => $hmain,
                                            'vstdate'                    => $checkdate,
                                            'regdate'                    => $checkdate,
                                            'claimcode'                  => $claimCode,
                                            'claimtype'                  => $claimType,
                                            'birthday'                   => $birthdate,
                                            'homtel'                     => $tel,
                                            'repcode'                    => $claimStatus,
                                            'hncode'                     => $hnCode,
                                            'servicerep'                 => $patientType,
                                            'servicename'                => $claimTypeName,
                                            'mainpttype'                 => $mainInsclWithName,
                                            'subpttype'                  => $subInsclName,
                                            'requestauthen'              => $sourceChannel,
                                            'authentication'             => $claimAuthen, 
                                        ]);
                                    } else {
                                        Check_authen_ti::create([
                                            'cid'                        => $personalId,
                                            'fullname'                   => $patientName,
                                            'hosname'                    => $hname,
                                            'hcode'                      => $hmain,
                                            'vstdate'                    => $checkdate,
                                            'regdate'                    => $checkdate,
                                            'claimcode'                  => $claimCode,
                                            'claimtype'                  => $claimType,
                                            'birthday'                   => $birthdate,
                                            'homtel'                     => $tel,
                                            'repcode'                    => $claimStatus,
                                            'hncode'                     => $hnCode,
                                            'servicerep'                 => $patientType,
                                            'servicename'                => $claimTypeName,
                                            'mainpttype'                 => $mainInsclWithName,
                                            'subpttype'                  => $subInsclName,
                                            'requestauthen'              => $sourceChannel,
                                            'authentication'             => $claimAuthen, 
                                        ]);
                                    }

                                } else { 
                               
                                }
                    }

        return view('auto.pullauthen_tispsch',[
            'response'  => $response,
            'result'  => $result,
        ]);

    }
    public function updaet_authen_to_checksittiauto(Request $request)
    {
        $date_now = date('Y-m-d');
        $date_start = "2023-08-14";
        $date_end = "2566-07-22";
        
        // $data_ = Check_authen
        // $count = Check_sit_auto::where('vn','<>','')->count(); 

        $data_ = DB::connection('mysql')->select(' 
            SELECT c.cid,c.vstdate,c.claimcode,c.claimtype,c.servicerep,c.servicename,c.authentication,ca.claimcode as Caclaimcode
                FROM check_authen c   
                LEFT JOIN check_sit_auto ca ON ca.cid = c.cid and c.vstdate = ca.vstdate
                WHERE c.vstdate = CURDATE()
                AND c.claimtype = "PG0130001"  
                AND ca.claimcode IS NULL  
        '); 
        foreach ($data_ as $key => $value) {   
            //  $count = Check_sit_tiauto::where('claimcode','=',$value->claimcode)->count(); 
            //  if ($count>0) {
            //     # code...
            //  } else {
                Check_sit_tiauto::where('cid','=',$value->cid)->where('vstdate','=',$value->vstdate)->update([
                    'claimcode'       => $value->claimcode,
                    'claimtype'       => $value->claimtype,
                    'servicerep'      => $value->servicerep,
                    'servicename'     => $value->servicename,
                    'authentication'  => $value->authentication,
                ]);   
            //  }
             
             
        }

        return view('auto.updaet_authen_to_checksittiauto');

    }


    
    

}
