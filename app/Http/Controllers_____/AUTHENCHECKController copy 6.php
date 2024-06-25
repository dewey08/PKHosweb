<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\DB; 
use App\Models\Visit_pttype_authen;
use App\Models\Visit_pttype_authen_report;
use App\Models\Patient;
use App\Models\Vn_stat;
use App\Models\Ovst;
use App\Models\Visit_pttype_token_authen;
use Stevebauman\Location\Facades\Location;
use Http;
use SoapClient;
use File;
use SplFileObject;
use Arr;
use Storage;
use GuzzleHttp\Client;

class AUTHENCHECKController extends Controller
{
    public function screening_cigarette(Request $request)
    {
        $date = date('Y-m-d');
       
        $countalls_data = DB::connection('mysql3')->select('
            SELECT COUNT(o.vn) as VN
            FROM ovst o
            LEFT OUTER JOIN ovst_queue_server_authen oq on oq.vn=o.vn
            LEFT OUTER JOIN kskdepartment sk on sk.depcode=o.main_dep
            LEFT OUTER JOIN patient p on p.hn=o.hn
            WHERE o.vstdate = CURDATE()
            ORDER BY o.vsttime
        ');
 
        return view('ppsf.screening_cigarette',[
            'countalls_data'       => $countalls_data,           
        ] );
    }
   
    public function checkauthen_main(Request $request)
    {
        $date_now = date("Y-m-d");
        $data_spsch = DB::connection('mysql3')->select(' 
                SELECT o.vn,o.hn,o.vstdate,o.vsttime,p.cid,concat(p.pname,p.fname," ",p.lname) as fullname,oq.claim_code,vp.visit_pttype_authen_auth_code,oq.mobile,
                oq.claim_type,oq.authen_type,os.is_appoint,o.staff,op.name as fullname_staff,os.opd_dep,sk.department
                FROM ovst o
                LEFT OUTER JOIN visit_pttype_authen vp on vp.visit_pttype_authen_vn = o.vn
                LEFT OUTER JOIN ovst_queue_server os on os.vn = o.vn
                LEFT OUTER JOIN ovst_queue_server_authen oq on oq.vn = os.vn
                LEFT OUTER JOIN kskdepartment sk on sk.depcode=o.main_dep
                LEFT OUTER JOIN patient p on p.hn=o.hn
                LEFT OUTER JOIN opduser op on op.loginname = o.staff
                WHERE o.vstdate = CURDATE()
                ORDER BY o.vsttime  
                ');

        return view('authen.checkauthen_main',[ 
        'data_spsch'  => $data_spsch
        ]);

    } 
    public function checkauthen_auto(Request $request)
    {
        // SELECT v.vn ,v.hn ,v.cid
        //         ,vp.claim_code
        //         ,p.pttype ,p.hipdata_code
        //         ,cab.*
        //         FROM vn_stat v
        //         LEFT JOIN visit_pttype vp ON v.vn=vp.vn
        //         LEFT JOIN pttype p ON v.pttype=p.pttype
        //         LEFT JOIN z_check_authen_bamnet cab ON v.vn=cab.z_vn
        //         WHERE v.vstdate = "'.$date_now.'"
        //         AND (vp.claim_code IS NULL OR vp.claim_code="")  
        //         ORDER BY z_time 
        //         LIMIT 5

        // SELECT o.vn,o.hn,o.an,vs.cid,o.vstdate,o.pttype,o.main_dep,v.claim_code,v.auth_code,v.Auth_DateTime 
        // FROM ovst o 
        // LEFT JOIN visit_pttype v on v.vn = o.vn
        // LEFT JOIN vn_stat vs on vs.vn = o.vn
        // WHERE o.vstdate = CURDATE() 
        // $date_now = date("Y-m-d");
        $date_now = date("Y-m-d");
        set_time_limit(60000);
        $datashow = DB::connection('mysql3')->select('             
                        SELECT o.vn,o.hn,o.an,o.vstdate,o.vsttime,p.cid,sk.depcode,concat(p.pname,p.fname,"  ",p.lname) as fullname
                        ,oq.claim_code,oq.mobile,oq.claim_type,oq.authen_type,op.name as fullname_staff,sk.department
                        FROM ovst o
                        LEFT OUTER JOIN visit_pttype v on v.vn=o.vn
                        LEFT OUTER JOIN ovst_queue_server os on os.vn = o.vn
                        LEFT OUTER JOIN ovst_queue_server_authen oq on oq.vn = os.vn
                        LEFT OUTER JOIN kskdepartment sk on sk.depcode=o.main_dep
                        LEFT OUTER JOIN patient p on p.hn=o.hn
                        LEFT OUTER JOIN opduser op on op.loginname = o.staff
                    
                        WHERE o.vstdate = CURDATE() 
                        ORDER BY o.vsttime limit 1500       
                    ');
                    // LEFT OUTER JOIN visit_pttype_authen vp on vp.visit_pttype_authen_vn=o.vn
                    // set_time_limit(20);
                    // while ($i<=10)
                    // {
                    //         echo "i=$i ";
                    //         sleep(100);
                    //         $i++;           "2022-12-01"
                    // }
                foreach ($datashow as $key => $value) {
                        $cid = $value->cid;
                        $vn = $value->vn;
                        $hn = $value->hn;
                        $an = $value->an;
                        $maindep = $value->depcode;
                        $vstdate = $value->vstdate;
                        $ft = $value->fullname;
                        $staff = $value->fullname_staff;
                        $department = $value->department;
                        $tel = $value->mobile;
                        $claimtype = $value->claim_type;
                        // dd($cid);
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                            CURLOPT_URL => "http://localhost:8189/api/nhso-service/latest-authen-code/$cid",
                            CURLOPT_RETURNTRANSFER => 1,
                            CURLOPT_SSL_VERIFYHOST => 0,
                            CURLOPT_SSL_VERIFYPEER => 0,
                            CURLOPT_CUSTOMREQUEST => 'GET',
                        ));
                        // dd($curl);
                        $response = curl_exec($curl);
                        curl_close($curl);
                        $content = $response;
                    
                        $result = json_decode($content, true); 
                        //  dd($result);
                        @$hcode = $result['hcode'];
                        // dd(@$hcode);
                        @$ex_claimDateTime = explode("T",$result['claimDateTime']);
                        // dd(@$ex_claimDateTime);
                        $claimDate = $ex_claimDateTime[0];
                        if ($claimDate == '') {
                            $claimDate = $ex_claimDateTime[0];
                            $checkTime = '00:00:00';
                            // $checkTime = $ex_claimDateTime[2];
                            // dd($claimDate);
                        } else {
                            // dd(@$ex_claimDateTime);
                            $claimDate2 = $ex_claimDateTime[0];
                            $checkTime = $ex_claimDateTime[1];
                            // dd($checkTime);
                        }
                        
                        // $claimDate = $ex_claimDateTime[0];
                        // $checkTime = $ex_claimDateTime[1];         
                        // dd($claimDate);
                        @$claimCode = $result['claimCode'];
        
                        // $ex_checkDate = explode("T",$result['checkDate']);
                        // $claimDate2=$ex_checkDate[0];
                        // $checkTime2=$ex_checkDate[1];
                    
                        // $ex_checkDate = explode("T",$result['checkDate']);
                        // $check_getDate = $ex_checkDate[0];
                        // $checkTime = $ex_checkDate[1];            
         
                        $checkvn = Visit_pttype_authen::where('visit_pttype_authen_vn','=',$vn)->count();
                        // where('visit_pttype_authen_cid','=',$cid)
                        // where('visit_pttype_authen_vn','=',$vn)
                        // dd($checkvn);
                        // $staff = $value->fullname_staff;
                        // $department = $value->department;
            
                        if ($checkvn == '0') {
                            $data_add = Visit_pttype_authen::create([
                                'visit_pttype_authen_cid'       => $cid,
                                'visit_pttype_authen_vn'        => $vn,
                                'visit_pttype_authen_hn'        => $hn,
                                'visit_pttype_authen_an'        => $an,
                                'visit_pttype_authen_auth_code' => @$claimCode,
                                'claim_type'                    => $claimtype,
                                'checkTime'                     => $checkTime,
                                'claimDate'                     => $claimDate,
                                'main_dep'                      => $maindep,
                                'visit_pttype_authen_staff'      => $staff,
                                'visit_pttype_authen_department' => $department,
                                'visit_pttype_authen_fullname'  => $ft,
                                'mobile'                        => $tel,
                                'vstdate'                       => $vstdate,
                                'created_at'                    => $date_now
                            ]);
                            $data_add->save();
                        } else {
                            Visit_pttype_authen::where('visit_pttype_authen_vn', $vn) 
                            ->update([
                                'visit_pttype_authen_cid'            => $cid,
                                'visit_pttype_authen_hn'             => $hn,
                                'visit_pttype_authen_an'             => $an,
                                'visit_pttype_authen_auth_code'      => @$claimCode,
                                'claim_type'                         => $claimtype,
                                'checkTime'                          => $checkTime,
                                'claimDate'                          => $claimDate,
                                'main_dep'                           => $maindep,
                                'visit_pttype_authen_staff'          => $staff,
                                'visit_pttype_authen_department'     => $department,
                                'visit_pttype_authen_fullname'       => $ft,
                                'mobile'                             => $tel,
                                'vstdate'                            => $vstdate,
                                'updated_at'                         => $date_now
                            ]);
                        }                        
                    // return response()->json([
                    //     'data_add' => $data_add 
                    // ]);
                }                                     
        
                $data_spsch = DB::connection('mysql3')->select(' 
                        SELECT o.vn,o.hn,o.vstdate,o.vsttime,p.cid,concat(p.pname,p.fname," ",p.lname) as fullname,oq.claim_code,vp.visit_pttype_authen_auth_code,oq.mobile,
                        oq.claim_type,oq.authen_type,os.is_appoint,o.staff,op.name as fullname_staff,os.opd_dep,sk.department
                        FROM ovst o
                        LEFT OUTER JOIN visit_pttype_authen vp on vp.visit_pttype_authen_vn = o.vn
                        LEFT OUTER JOIN ovst_queue_server os on os.vn = o.vn
                        LEFT OUTER JOIN ovst_queue_server_authen oq on oq.vn = os.vn
                        LEFT OUTER JOIN kskdepartment sk on sk.depcode=o.main_dep
                        LEFT OUTER JOIN patient p on p.hn=o.hn
                        LEFT OUTER JOIN opduser op on op.loginname = o.staff
                        WHERE o.vstdate = CURDATE()
                        ORDER BY o.vsttime LIMIT 10 
                ');               
            return view('authen.checkauthen_auto',[
                'response'  => $response,
                'result'  => $result,
                'data_spsch'  => $data_spsch
            ]);
        
    }

    public function checkauthen_autospsch(Request $request)
    {
        // date_default_timezone_set('UTC');
    
        $date_now = date('Y-m-d');
        // $date_start = "2023-04-05";
        // $date_now = "2023-04-09";
        // $date = date_create("2013-03-15");
        // $dates = $date_format($date,'Y-m-d');
        // dd($date_now);

        // $url = "https://authenservice.nhso.go.th/authencode/api/authencode-report?hcode=10978&provinceCode=3600&zoneCode=09&claimDateFrom=$date_now&claimDateTo=$date_now&page=0&size=100000";
        $url = "https://authenservice.nhso.go.th/authencode/api/erm-reg-claim?claimStatus=E&claimDateFrom=$date_now&claimDateTo=$date_now&page=0&size=1000&sort=claimDate,desc";

        // dd($url);
        $curl = curl_init();
        curl_setopt_array($curl, array(
            // CURLOPT_URL => 'https://authenservice.nhso.go.th/authencode/api/authencode-report?hcode=10978&provinceCode=3600&zoneCode=09&claimDateFrom=2023-01-05&claimDateTo=2023-01-05&page=0&size=1000',
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Accept: application/json, text/plain, */*',
                'Accept-Language: th-TH,th;q=0.9,en-US;q=0.8,en;q=0.7',
                'Connection: keep-alive',
                'Cookie: SESSION=ZDA2NDFkYjAtZmIzNC00ODliLThmNzEtZmM4MzJmZmIyNTAz; TS01bfdc7f=013bd252cb2f635ea275a9e2adb4f56d3ff24dc90de5421d2173da01a971bc0b2d397ab2bfbe08ef0e379c3946b8487cf4049afe9f2b340d8ce29a35f07f94b37287acd9c2; _ga_B75N90LD24=GS1.1.1665019756.2.0.1665019757.0.0.0; _ga=GA1.3.1794349612.1664942850; TS01e88bc2=013bd252cb8ac81a003458f85ce451e7bd5f66e6a3930b33701914767e3e8af7b92898dd63a6258beec555bbfe4b8681911d19bf0c; SESSION=YmI4MjUyNjYtODY5YS00NWFmLTlmZGItYTU5OWYzZmJmZWNh; TS01bfdc7f=013bd252cbc4ce3230a1e9bdc06904807c8155bd7d0a8060898777cf88368faf4a94f2098f920d5bbd729fbf29d55a388f507d977a65a3dbb3b950b754491e7a240f8f72eb; TS01e88bc2=013bd252cbe2073feef8c43b65869a02b9b370d9108007ac6a34a07f6ae0a96b2967486387a6a0575c46811259afa688d09b5dfd21',
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
        dd($contents);
        $result = json_decode($contents, true);

        @$content = $result['content']; 
        // dd($content);
        // @$transId = $content['transId']; 
        // @$content = explode($content['content']);
        // $transId=$transId[0];
        // $hmain=$hmain[1];
        // foreach ($request->input('product_id', []) as $key => $product_id)
        foreach ($content as $key => $value) {
            $transId = $value['transId'];  
            // $hmain = $value['hmain'];
            // $hname = $value['hname']; 
            $pid = $value['pid'];   
            $titleName = $value['titleName'];

            isset( $value['fname'] ) ? $fname = $value['fname'] : $fname = "";
            isset( $value['lname'] ) ? $lname = $value['lname'] : $lname = "";
            isset( $value['claimCode'] ) ? $claimCode = $value['claimCode'] : $claimCode = "";
            isset( $value['claimType'] ) ? $claimType = $value['claimType'] : $claimType = "";
            isset( $value['claimTypeName'] ) ? $claimTypeName = $value['claimTypeName'] : $claimTypeName = "";
         
            isset( $value['claimStatus'] ) ? $claimStatus = $value['claimStatus'] : $claimStatus = "";
            isset( $value['hospName'] ) ? $hospName = $value['hospName'] : $hospName = "";
            isset( $value['hospCode'] ) ? $hospCode = $value['hospCode'] : $hospCode = "";
            isset( $value['claimAuthen'] ) ? $claimAuthen = $value['claimAuthen'] : $claimAuthen = "";
            isset( $value['fullName'] ) ? $fullName = $value['fullName'] : $fullName = "";
            isset( $value['daysBetweenClaimDateAndSysdate'] ) ? $daysBetweenClaimDateAndSysdate = $value['daysBetweenClaimDateAndSysdate'] : $daysBetweenClaimDateAndSysdate = "";
            isset( $value['cancelable'] ) ? $cancelable = $value['cancelable'] : $cancelable = "";
           

            // isset( $value['addrNo'] ) ? $addrNo = $value['addrNo'] : $addrNo = "";
            // isset( $value['moo'] ) ? $moo = $value['moo'] : $moo = "";
            // isset( $value['moonanName'] ) ? $moonanName = $value['moonanName'] : $moonanName = "";
            // isset( $value['tumbonName'] ) ? $tumbonName = $value['tumbonName'] : $tumbonName = "";
            // isset( $value['amphurName'] ) ? $amphurName = $value['amphurName'] : $amphurName = "";
            // isset( $value['changwatName'] ) ? $changwatName = $value['changwatName'] : $changwatName = "";
            // isset( $value['birthdate'] ) ? $birthdate = $value['birthdate'] : $birthdate = "";
            // isset( $value['tel'] ) ? $tel = $value['tel'] : $tel = "";
            // isset( $value['mainInscl'] ) ? $mainInscl = $value['mainInscl'] : $mainInscl = "";
            // isset( $value['mainInsclName'] ) ? $mainInsclName = $value['mainInsclName'] : $mainInsclName = "";
            // isset( $value['subInscl'] ) ? $subInscl = $value['subInscl'] : $subInscl = "";
            // isset( $value['subInsclName'] ) ? $subInsclName = $value['subInsclName'] : $subInsclName = "";
            // isset( $value['claimStatus'] ) ? $claimStatus = $value['claimStatus'] : $claimStatus = "";
            // isset( $value['patientType'] ) ? $patientType = $value['patientType'] : $patientType = "";
            // isset( $value['claimCode'] ) ? $claimCode = $value['claimCode'] : $claimCode = "";
            // isset( $value['claimType'] ) ? $claimType = $value['claimType'] : $claimType = "";
            // isset( $value['claimTypeName'] ) ? $claimTypeName = $value['claimTypeName'] : $claimTypeName = "";
            // isset( $value['claimAuthen'] ) ? $claimAuthen = $value['claimAuthen'] : $claimAuthen = "";
            // isset( $value['mainInsclWithName'] ) ? $mainInsclWithName = $value['mainInsclWithName'] : $mainInsclWithName = "";
         

            // $moonanName = $value['moonanName'];
            // $tumbonName = $value['tumbonName'];
            // $amphurName = $value['amphurName'];
            // $changwatName = $value['changwatName'];
            // $birthdate = $value['birthdate'];
            // $tel = $value['tel'];
            // $mainInscl = $value['mainInscl'];   //"SSS",
            // $mainInsclName = $value['mainInsclName']; //"สิทธิประกันสังคม",
            // $subInscl = $value['subInscl']; //"S1",
            // $subInsclName = $value['subInsclName']; //"สิทธิเบิกกองทุนประกันสังคม (ผู้ประกันตน)",
            // $claimStatus = $value['claimStatus']; //"E",
            // $patientType = $value['patientType']; //"PP",
            // $claimCode = $value['claimCode']; //"PP1120917330",
            // $claimType = $value['claimType']; //"PG0060001",
            // $claimTypeName = $value['claimTypeName']; //"เข้ารับบริการรักษาทั่วไป (OPD/ IPD/ PP)",
 
            // $hnCode = $value['hnCode']; //"0361147",
            // $claimDate = $value['claimDate']; //"2023-01-03T11:47:07",
            // $createDate = $value['createDate']; //"2023-01-03T11:47:07",
            // $sourceChannel = $value['sourceChannel']; //"AUTHENCODE",
            // $claimAuthen = $value['claimAuthen']; //"KOS",
            // $mainInsclWithName = $value['mainInsclWithName']; // "(SSS) สิทธิประกันสังคม"
            // $createBy = $value['createBy']; // "3361000018557"

            $claimDate = explode("T",$value['claimDate']);
            $checkdate = $claimDate[0];
            $checktime = $claimDate[1];
 
                $datenow = date("Y-m-d");
               
                    $checktransId = Visit_pttype_authen_report::where('transId','=',$transId)->count();
                    if ($checktransId > 0) {
                        Visit_pttype_authen_report::where('transId', $transId) 
                            ->update([
                                'transId'                          => $transId,
                                'hmain'                            => $hmain,
                                'hname'                            => $hname,
                                'personalId'                       => $personalId,
                                'patientName'                      => $patientName,
                                'addrNo'                           => $addrNo,
                                'moo'                              => @$moo,
                                'moonanName'                       => $moonanName,
                                'tumbonName'                       => $tumbonName,
                                'amphurName'                       => $amphurName,
                                'changwatName'                     => $changwatName,
                                'birthdate'                        => $birthdate,
                                'tel'                              => $tel,
                                'mainInscl'                        => $mainInscl,
                                'mainInsclName'                    => $mainInsclName,
                                'subInscl'                         => $subInscl,
                                'subInsclName'                     => $subInsclName,
                                'claimStatus'                      => $claimStatus,
                                'patientType'                      => $patientType,
                                'claimCode'                        => $claimCode,
                                'claimType'                        => $claimType,
                                'claimTypeName'                    => $claimTypeName,
                                'hnCode'                           => $hnCode, 
                                'claimDate'                       => $checkdate,
                                'claimTime'                        => $checktime,
                                'date_data'                        => $datenow
                            ]);
                    } else {
                        $data_add = Visit_pttype_authen_report::create([
                            'transId'                          => $transId,
                            'hmain'                            => $hmain,
                            'hname'                            => $hname,
                            'personalId'                       => $personalId,
                            'patientName'                      => $patientName,
                            'addrNo'                           => $addrNo,
                            'moo'                              => @$moo,
                            'moonanName'                       => $moonanName,
                            'tumbonName'                       => $tumbonName,
                            'amphurName'                       => $amphurName,
                            'changwatName'                     => $changwatName,
                            'birthdate'                        => $birthdate,
                            'tel'                              => $tel,
                            'mainInscl'                        => $mainInscl,
                            'mainInsclName'                    => $mainInsclName,
                            'subInscl'                         => $subInscl,
                            'subInsclName'                     => $subInsclName,
                            'claimStatus'                      => $claimStatus,
                            'patientType'                      => $patientType,
                            'claimCode'                        => $claimCode,
                            'claimType'                        => $claimType,
                            'claimTypeName'                    => $claimTypeName,
                            'hnCode'                           => $hnCode, 
                            'claimDate'                       => $checkdate,
                            'claimTime'                        => $checktime,
                            'date_data'                        => $datenow
                        ]);
                        $data_add->save();
                    }   
        }
        return view('authen.checkauthen_autospsch',[
            'response'  => $response,
            'result'  => $result, 
        ]); 
    
        
    }

    public function getauthen_auto(Request $request)
    {
        $date_now = date("Y-m-d");
        $datashow = DB::connection('mysql3')->select('
            SELECT v.vn ,v.hn ,v.cid
                ,vp.claim_code
                ,p.pttype ,p.hipdata_code
                ,cab.*
                FROM vn_stat v
                LEFT JOIN visit_pttype vp ON v.vn=vp.vn
                LEFT JOIN pttype p ON v.pttype=p.pttype
                LEFT JOIN z_check_authen_bamnet cab ON v.vn=cab.z_vn
                WHERE v.vstdate = "'.$date_now.'"
                AND (vp.claim_code IS NULL OR vp.claim_code="")  
                ORDER BY z_time 
                LIMIT 10
        ');
                foreach ($datashow as $key => $value) {
                    $cid = $value->cid;
                    $vn = $value->vn;
                    $hn = $value->hn;
                    // dd($cid);
                    $curl = curl_init();
                    curl_setopt_array($curl, array(
                        CURLOPT_URL => "http://localhost:8189/api/nhso-service/latest-5-authen-code-all-hospital/$cid",
                        CURLOPT_RETURNTRANSFER => 1,
                        CURLOPT_SSL_VERIFYHOST => 0,
                        CURLOPT_SSL_VERIFYPEER => 0,
                        CURLOPT_CUSTOMREQUEST => 'GET',
                    ));
                // dd($curl);
                $response = curl_exec($curl);
                curl_close($curl);
                $content = $response;
                $result = json_decode($content, true);

                dd($result);

                @$hcode = $result['hcode'];

                @$ex_claimDateTime = explode("T",$result['claimDateTime']);
                $claimDate=$ex_claimDateTime[0];
                $checkTime=$ex_claimDateTime[1];
 
                @$claimCode = $result['claimCode'];

                $ex_checkDate = explode("T",$result['checkDate']);
                $claimDate2=$ex_checkDate[0];
                $checkTime2=$ex_checkDate[1];

                dd($result);
                
                    return response()->json( );

                 
               
                }
        
    }

    public function authen_getbar(Request $request)
    {
        $y = date('Y');
        $date = date('Y-m-d');
        // $chart = Visit_pttype_authen::select([
        //     DB::raw('COUNT(visit_pttype_authen_vn) as count'),
        //     DB::raw('COUNT(visit_pttype_authen_auth_code) as count_auth_code'), 
        //     DB::raw('COUNT(mobile) as count_mobile'), 
        //     DB::raw('MONTH(vstdate) as month'), 
        //     // DB::raw('YEAR(vstdate) as year') 
        // ])
        // ->whereYear('vstdate',$y)
        // ->groupBy([
        //     // 'month' ,'year'
        //     'month' 
        // ])
        // ->orderBy('month')
        // ->get();

        // $chart = Ovst::select([
        //     DB::raw('COUNT(ovst.vn) as count'),
        //     DB::raw('COUNT(visit_pttype_authen_report.claimCode) as count_auth_code'), 
        //     DB::raw('COUNT(visit_pttype_authen_report.tel) as count_mobile'), 
        //     DB::raw('MONTH(visit_pttype_authen_report.claimDate) as month'),  
        // ])
        // ->leftjoin('visit_pttype','visit_pttype.vn','=','ovst.vn')

        // ->leftjoin('ovst_queue_server','ovst_queue_server.vn','=','ovst.vn')
        // ->leftjoin('ovst_queue_server_authen','ovst_queue_server_authen.vn','=','ovst_queue_server.vn')

        // ->leftjoin('kskdepartment','kskdepartment.depcode','=','ovst.main_dep')
        // ->leftjoin('opduser','opduser.loginname','=','ovst.staff')
        // ->leftjoin('patient','patient.hn','=','ovst.hn')
        // ->leftjoin('visit_pttype_authen_report','visit_pttype_authen_report.personalId','=','patient.cid')      
        // ->whereYear('ovst.vstdate',$y)
        // ->groupBy([
        //     // 'month' ,'year'
        //     'month' 
        // ])
        // // ->orderBy('month')
        // ->get();

        $chart = DB::connection('mysql3')->select(' 
            SELECT 
                COUNT(o.vn) as count
                ,COUNT(wr.claimType) as UserAuthen
                ,COUNT(oq.claim_code) as KiosAuthen 
                ,COUNT((wr.claimType)+(oq.claim_code)) as Authensend
                ,COUNT(DISTINCT transId) as TransId
                ,COUNT(wr.tel) as Tel

                ,MONTH(o.vstdate) as month
                ,YEAR(o.vstdate) as year

                FROM ovst o
                LEFT OUTER JOIN visit_pttype v on v.vn=o.vn
                LEFT OUTER JOIN ovst_queue_server os on os.vn = o.vn
                LEFT OUTER JOIN ovst_queue_server_authen oq on oq.vn = os.vn
                LEFT OUTER JOIN kskdepartment sk on sk.depcode=o.main_dep
                LEFT OUTER JOIN patient p on p.hn=o.hn
                LEFT OUTER JOIN visit_pttype_authen_report wr ON wr.personalId = p.cid and wr.claimDate = o.vstdate
                LEFT OUTER JOIN opduser op on op.loginname = o.staff
               
                WHERE YEAR(o.vstdate) = "'.$y.'"
                GROUP BY month
        ');
        // WHERE o.vstdate = "2023-01-04"

        $labels = [
          1 => "ม.ค", "ก.พ", "มี.ค", "เม.ย", "พ.ย", "มิ.ย", "ก.ค","ส.ค","ก.ย","ต.ค","พ.ย","ธ.ค"
        ];
        $count  = $KiosAuthen = $UserAuthen = $Tel = $Authensend = $TransId = [];
        // $count_mobile = [];
        // $count_auth_code = [];
        // $count  = [];

        foreach ($chart as $key => $chartitems) {
            $count[$chartitems->month] = $chartitems->count;
            $UserAuthen[$chartitems->month] = $chartitems->UserAuthen;
            $KiosAuthen[$chartitems->month] = $chartitems->KiosAuthen;
            $Tel[$chartitems->month] = $chartitems->Tel; 
            $TransId[$chartitems->month] = $chartitems->TransId;

            $Authensends = $UserAuthen[$chartitems->month] +  $KiosAuthen[$chartitems->month];
            // $aa = $count[$chartitems->month];

            $Authensend[$chartitems->month] = $Authensends;
            // dd($Authensend);
        }
      
        
        foreach ($labels as $month => $name) {
        // foreach ($labels as $key => $month) {
           if (!array_key_exists($month,$count)) {
            $count[$month] = 0;
           }
           if (!array_key_exists($month,$UserAuthen)) {
            $UserAuthen[$month] = 0;
           }
           if (!array_key_exists($month,$KiosAuthen)) {
            $KiosAuthen[$month] = 0;
           }
           if (!array_key_exists($month,$Tel)) {
            $Tel[$month] = 0;
           }

           if (!array_key_exists($month,$Authensend)) {
            $Authensend[$month] = 0;
           }
           if (!array_key_exists($month,$TransId)) {
            $TransId[$month] = 0;
           }
          
        }

        ksort($count);
        ksort($UserAuthen);
        ksort($KiosAuthen);
        ksort($Tel); 
        ksort($Authensend);
        ksort($TransId);
      
        return [
            'labels'          =>  array_values($labels),
            'datasets'     =>  [
                [ 
                    'label'           =>  'visit ทั้งหมด',
                    'borderColor'     => 'rgba(255, 26, 104, 1)',
                    'backgroundColor' => 'rgba(255, 26, 104, 0.2)',
                    'borderWidth'     => '1',
                    'barPercentage'   => '0.9',
                    'data'            =>  array_values($count)
                ],
                [ 
                    'label'           =>  'Authen',
                    'borderColor'     => 'rgba(75, 192, 192, 1)',
                    'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                    'borderWidth'     => '1',
                    'barPercentage'   => '0.9',
                    'data'            => array_values($TransId) 
                ],
                // [
                //     'label'   =>  'UserAuthen',
                //     'borderColor'     => 'rgba(54, 162, 235, 1)',
                //     'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                //     'borderWidth'     => '1',
                //     'barPercentage'   => '0.9',
                //     'data'    =>   array_values($UserAuthen)
                // ],
                // [
                //     'label'   =>  'UserAuthen Success',
                //     'borderColor'     => 'rgba(153, 102, 255, 1)',
                //     'backgroundColor' => 'rgba(153, 102, 255, 0.2)',
                //     'borderWidth'     => '1',
                //     'barPercentage'   => '0.9',
                //     'data'    =>   array_values($Tel)
                // ],
                // [
                //     'label'   =>  'KiosAuthen',
                //     'borderColor'     => 'rgba(31, 120, 50,1)',
                //     'backgroundColor' => 'rgba(31, 120, 50, 0.2)',
                //     'borderWidth'     => '1',
                //     'barPercentage'   => '0.9',
                //     'data'    =>   array_values($KiosAuthen)
                // ]

                // 'rgba(255, 26, 104, 0.2)'
                // 'rgba(54, 162, 235, 0.2)',
                // 'rgba(255, 206, 86, 0.2)',
                // 'rgba(75, 192, 192, 0.2)',
                // 'rgba(153, 102, 255, 0.2)',
                // 'rgba(255, 159, 64, 0.2)',
                // 'rgba(155, 26, 104, 0.2)'
            
            ],
        ];

 
    }

    public function authen_getbar_days(Request $request)
    {
        $y = date('Y');
        $date = date('Y-m-d');
        
        $chartDay = DB::connection('mysql3')->select(' 
            SELECT 
                COUNT(DISTINCT o.vn) as count
                ,COUNT(wr.claimType) as UserAuthen
                ,COUNT(oq.claim_code) as KiosAuthen 
                ,COUNT((wr.claimType)+(oq.claim_code)) as Authensend
                ,COUNT(wr.tel) as Tel
                ,COUNT(DISTINCT transId) as TransId

                ,MONTH(o.vstdate) as month
                ,YEAR(o.vstdate) as year
				,DAY(o.vstdate) as day
                ,o.vstdate

                FROM ovst o
                LEFT OUTER JOIN visit_pttype v on v.vn=o.vn
                LEFT OUTER JOIN ovst_queue_server os on os.vn = o.vn
                LEFT OUTER JOIN ovst_queue_server_authen oq on oq.vn = os.vn
                LEFT OUTER JOIN kskdepartment sk on sk.depcode=o.main_dep
                LEFT OUTER JOIN patient p on p.hn=o.hn
                LEFT OUTER JOIN visit_pttype_authen_report wr ON wr.personalId = p.cid and wr.claimDate = o.vstdate
                LEFT OUTER JOIN opduser op on op.loginname = o.staff
               
                WHERE YEAR(o.vstdate) = "'.$y.'"
                GROUP BY day
        ');

        // $labels = [
        //   1 => "จันทร์", "อังคาร", "พุธ", "พฤหัสบดี", "ศุกร์", "เสาร์", "อาทิตย์"
        // ];

        $count  = $KiosAuthen = $UserAuthen = $Tel = $Authensend = $TransId = [];
        // $count_mobile = [];
        // $count_auth_code = [];
        // $count  = [];

        foreach ($chartDay as $key => $chartitems) {
            $count[$chartitems->day] = $chartitems->count;
            $UserAuthen[$chartitems->day] = $chartitems->UserAuthen;
            $KiosAuthen[$chartitems->day] = $chartitems->KiosAuthen;
            $Tel[$chartitems->day] = $chartitems->Tel; 
            $TransId[$chartitems->day] = $chartitems->TransId;

            $Authensends = $UserAuthen[$chartitems->day] +  $KiosAuthen[$chartitems->day];
            // $aa = $count[$chartitems->month]; 
            $Authensend[$chartitems->day] = $Authensends;

            $labels[$chartitems->day] = $chartitems->vstdate;
            // dd($Authensend);
        }
      
        
        // foreach ($labels as $day => $name) {
        // // foreach ($labels as $key => $month) {
        //    if (!array_key_exists($day,$count)) {
        //     $count[$day] = 0;
        //    }
        //    if (!array_key_exists($day,$UserAuthen)) {
        //     $UserAuthen[$day] = 0;
        //    }
        //    if (!array_key_exists($day,$KiosAuthen)) {
        //     $KiosAuthen[$day] = 0;
        //    }
        //    if (!array_key_exists($day,$Tel)) {
        //     $Tel[$day] = 0;
        //    }

        //    if (!array_key_exists($day,$Authensend)) {
        //     $Authensend[$day] = 0;
        //    }
        //     // $Authensend;
        // }

        ksort($count);
        ksort($UserAuthen);
        ksort($KiosAuthen);
        ksort($Tel); 
        ksort($Authensend);
        ksort($TransId);  
     
        return [
            'labels'          =>  array_values($labels),
            'datasets'     =>  [
                [ 
                    'label'           =>  'visit ทั้งหมด',
                    'borderColor'     => 'rgb(255, 26, 104)',
                    // 'backgroundColor' => 'rgba(255, 26, 104, 0.2)',
                    // 'borderWidth'     => '1',
                    'tension'   => '0.1',
                    'fill'      => false,
                    'data'            =>  array_values($count)
                ],
                // [ 
                //     'label'           =>  'Authen',
                //     'borderColor'     => 'rgb(153, 102, 255)',
                //     // 'backgroundColor' => 'rgba(75, 192, 192, 0.5)',
                //     // 'borderWidth'     => '1',
                //     'tension'   => '0.1',
                //     'fill'      => false,
                //     'data'            => array_values($Authensend) 
                // ],
                [ 
                    'label'           =>  'Authen Success',
                    'borderColor'     => 'rgb(75, 192, 192)',
                    // 'backgroundColor' => 'rgba(75, 192, 192, 0.5)',
                    // 'borderWidth'     => '1',
                    'tension'   => '0.1',
                    'fill'      => false,
                    'data'            => array_values($TransId) 
                ],
               
            
            ],
        ];

 
    }

    public function authencode_index(Request $request)
    {
        $ip = $request->ip(); 
        // $terminals = Http::get('http://localhost:8189/api/smartcard/terminals')->collect(); 
        // $cardcid = Http::get('http://localhost:8189/api/smartcard/read')->collect();  
        // $cardcidonly = Http::get('http://localhost:8189/api/smartcard/read-card-only')->collect(); 

        $terminals = Http::get('http://'.$ip.':8189/api/smartcard/terminals')->collect(); 
        $cardcid = Http::get('http://'.$ip.':8189/api/smartcard/read')->collect();  
        $cardcidonly = Http::get('http://'.$ip.':8189/api/smartcard/read-card-only')->collect(); 

        $output = Arr::sort($terminals);
        $outputcard = Arr::sort($cardcid);
        $outputcardonly = Arr::sort($cardcidonly);
        if ($output == []) {
            // if ($output == "") {
                $smartcard = 'NO_CONNECT';
                $smartcardcon = '';
            } else {
                $smartcard = 'CONNECT';
                foreach ($output as $key => $value) {
                    $terminalname = $value['terminalName'];
                    $cardcids = $value['isPresent']; 
                }
                if ($cardcids != 'false') {
                    $smartcardcon = 'NO_CID';
                } else {
                    $smartcardcon = 'CID_OK';
                }          
            }
            
        return view('authencode',[  
            'smartcard'            =>   $smartcard, 
            'cardcid'            =>  $cardcid,
            'smartcardcon'            =>  $smartcardcon,
            'output'            =>  $output,
        ]);
    }

    public function token_add(Request $request)
    {
        return view('token_add');
    }

    public function token_save(Request $request)
    {
        $add = new Visit_pttype_token_authen();
        $add->cid = $request->cid;
        $add->token = $request->token; 
        $add->save(); 
        return response()->json([
            'status'    => '200' 
        ]); 
    }
    public function getsmartcard_authencode(Request $request)
    {
        $ip = $request->ip(); 
        $collection = Http::get('http://'.$ip.':8189/api/smartcard/read?readImageFlag=true')->collect(); 
        $data['patient'] =  DB::connection('mysql3')->select('select cid,hometel from patient limit 10');

        $year = substr(date("Y"),2) +43;
        $mounts = date('m');
        $day = date('d');
        $time = date("His");  
        $vn = $year.''.$mounts.''.$day.''.$time;
       
        $getvn_stat =  DB::connection('mysql3')->select('select * from vn_stat limit 2');
        $get_ovst =  DB::connection('mysql3')->select('select * from ovst limit 2');
        $get_opdscreen =  DB::connection('mysql3')->select('select * from opdscreen limit 2');
        $get_ovst_seq =  DB::connection('mysql3')->select('select * from ovst_seq limit 2');        
        $get_spclty =  DB::connection('mysql3')->select('select * from spclty');
        ///// เจน  hos_guid  จาก Hosxp
        $data_key = DB::connection('mysql3')->select('SELECT uuid() as keygen');  
        $output4 = Arr::sort($data_key); 
        foreach ($output4 as $key => $value) { 
            $hos_guid = $value->keygen; 
        }            
        $datapatient = DB::connection('mysql3')->table('patient')->where('cid','=',$collection['pid'])->first();
            if ($datapatient->hometel != null) {
                $cid = $datapatient->hometel;
            } else {
                $cid = '';
            }   
            if ($datapatient->hn != null) {
                $hn = $datapatient->hn;
            } else {
                $hn = '';
            }  
            if ($datapatient->hcode != null) {
                $hcode = $datapatient->hcode;
            } else {
                $hcode = '';
            } 
                    $curl = curl_init();
                    curl_setopt_array($curl, array(
                        CURLOPT_URL => "http://localhost:8189/api/smartcard/read?readImageFlag=true",
                        CURLOPT_RETURNTRANSFER => 1,
                        CURLOPT_SSL_VERIFYHOST => 0,
                        CURLOPT_SSL_VERIFYPEER => 0,
                        CURLOPT_CUSTOMREQUEST => 'GET',
                    ));

                    $response = curl_exec($curl);
                    curl_close($curl);
                    $content = $response;
                    $result = json_decode($content, true);

                    // dd($result);
                    @$pid = $result['pid'];
                    @$titleName = $result['titleName'];
                    @$fname = $result['fname'];
                    @$lname = $result['lname'];
                    @$nation = $result['nation'];
                    @$birthDate = $result['birthDate'];
                    @$sex = $result['sex'];
                    @$transDate = $result['transDate'];
                    @$mainInscl = $result['mainInscl'];
                    @$subInscl = $result['subInscl'];
                    @$age = $result['age'];
                    @$checkDate = $result['checkDate'];
                    @$image = $result['image'];
                    @$correlationId = $result['correlationId'];
                    @$startDateTime = $result['startDateTime'];
                    @$claimTypes = $result['claimTypes'];
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
                    $pid        = @$pid;
                    $fname      = @$fname;
                    $lname      = @$lname;
                    $birthDate      = @$birthDate;
                    $sex      = @$sex;
                    $mainInscl      = @$mainInscl;
                    $subInscl      = @$subInscl;
                    $age      = @$age;
                    $image      = @$image;
                    $correlationId      = @$correlationId;
                     
                    // dd($correlationId);
 
        return view('getsmartcard_authencode',$data,[ 
            'ip' => $ip,
            'pid'           => $pid,
            'fname'         => $fname, 
            'lname'         => $lname, 
            'birthDate'     => $birthDate,
            'sex'           => $sex,  
            'mainInscl'     => $mainInscl,
            'subInscl'      => $subInscl,
            'age'           => $age,
            'image'         => $image,
            'correlationId' => $correlationId, 
        ]);
    }

    //เอาไว้เช็คสิทธิ์ด้วย
    public function getsmartcard_authencode_BACKUP (Request $request)
    {
        $ip = $request->ip(); 
        $collection = Http::get('http://'.$ip.':8189/api/smartcard/read?readImageFlag=true')->collect(); 
        $data['patient'] =  DB::connection('mysql3')->select('select cid,hometel from patient limit 10');

        $year = substr(date("Y"),2) +43;
        $mounts = date('m');
        $day = date('d');
        $time = date("His");  
        $vn = $year.''.$mounts.''.$day.''.$time;
       
        $getvn_stat =  DB::connection('mysql3')->select('select * from vn_stat limit 2');
        $get_ovst =  DB::connection('mysql3')->select('select * from ovst limit 2');
        $get_opdscreen =  DB::connection('mysql3')->select('select * from opdscreen limit 2');
        $get_ovst_seq =  DB::connection('mysql3')->select('select * from ovst_seq limit 2');        
        $get_spclty =  DB::connection('mysql3')->select('select * from spclty');
        ///// เจน  hos_guid  จาก Hosxp
        $data_key = DB::connection('mysql3')->select('SELECT uuid() as keygen');  
        $output4 = Arr::sort($data_key); 
        foreach ($output4 as $key => $value) { 
            $hos_guid = $value->keygen; 
        }            
        $datapatient = DB::connection('mysql3')->table('patient')->where('cid','=',$collection['pid'])->first();
            if ($datapatient->hometel != null) {
                $cid = $datapatient->hometel;
            } else {
                $cid = '';
            }   
            if ($datapatient->hn != null) {
                $hn = $datapatient->hn;
            } else {
                $hn = '';
            }  
            if ($datapatient->hcode != null) {
                $hcode = $datapatient->hcode;
            } else {
                $hcode = '';
            } 

            $contents = file('D:\UCAuthenticationMX\nhso_token.txt', FILE_SKIP_EMPTY_LINES|FILE_IGNORE_NEW_LINES);
            foreach($contents as $line) {  
            }
            $chars = preg_split('//', $line, -1, PREG_SPLIT_NO_EMPTY);
            $output = Arr::sort($chars,2);

            $data['data17'] = $chars['17']; $data['data18'] = $chars['18']; $data['data19'] = $chars['19']; $data['data20'] = $chars['20'];
            $data['data21'] = $chars['21']; $data['data22'] = $chars['22']; $data['data23'] = $chars['23']; $data['data24'] = $chars['24'];
            $data['data25'] = $chars['25']; $data['data26'] = $chars['26']; $data['data27'] = $chars['27']; $data['data28'] = $chars['28'];
            $data['data29'] = $chars['29']; $data['data30'] = $chars['30']; $data['data31'] = $chars['31']; $data['data32'] = $chars['32'];

            $token_ = $chars['17'].''.$data['data18'].''.$data['data19'].''.$data['data20'].''.$data['data21'].''.$data['data22'].''.$data['data23'].''.$data['data24'].''.$data['data25'].''.$data['data26'].''.$data['data27']
            .''.$data['data28'].''.$data['data29'].''.$data['data30'].''.$data['data31'].''.$data['data32'];

            $pid = $collection['pid'];
            // dd($pid);
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
                        "user_person_id" => "$pid",
                        "smctoken" => "$token_",
                        "person_id" => "$pid",
                )
            );         
            $result = $client->__soapCall('searchCurrentByPID',$params);
        
            foreach ($result as $key => $value) { 
                $birthday                 = $value->birthdate;
                $fname                    = $value->fname;
                $lname                    = $value->lname;
                $hmain                    = $value->hmain;
                $hmain_name               = $value->hmain_name;
                $title                    = $value->title;
                $title_name               = $value->title_name;
                $maininscl                = $value->maininscl;
                $maininscl_main           = $value->maininscl_main;
                $maininscl_name           = $value->maininscl_name;
                $nation                   = $value->nation; 
                $primary_amphur_name      = $value->primary_amphur_name; 
                $primary_moo              = $value->primary_moo; 
                $primary_mooban_name      = $value->primary_mooban_name; 
                $primary_province_name    = $value->primary_province_name; 
                $primary_tumbon_name      = $value->primary_tumbon_name;
                $primaryprovince          = $value->primaryprovince;
                $purchaseprovince         = $value->purchaseprovince;
                $purchaseprovince_name    = $value->purchaseprovince_name;
                $sex                      = $value->sex;
                $startdate                = $value->startdate;
                $person_id                = $value->person_id; 
                $startdate_sss            = $value->startdate_sss; 
                $subinscl                 = $value->subinscl;
                $subinscl_name            = $value->subinscl_name;
                $ws_data_source           = $value->ws_data_source;
                $ws_date_request          = $value->ws_date_request;
                $ws_status                = $value->ws_status;
                $ws_status_desc           = $value->ws_status_desc;
                $wsid                     = $value->wsid;
                $wsid_batch               = $value->wsid_batch;

            } 
        return view('getsmartcard_authencode',$data,[
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
            'hos_guid'     => $hos_guid, 
            'collection12' => $collection['hospMain']['hcode'],
            'collection13' => $collection['image'], 
            'get_spclty'   => $get_spclty,
            'maininscl'    => $maininscl, 
            'subinscl'     => $subinscl, 
            'hmain'        => $hmain,
            'person_id'    => $person_id            
        ]);
    }
    public function smartcard_authencode_save(Request $request)
    {
        $ip = $request->ip(); 
        // $authen = Http::post("http://localhost:8189/api/nhso-service/save-as-draft");
        $cid = $request->person_id;
        $tel = $request->mobile;  
        $claimType = $request->claimType;        
        $correlationId = $request->correlationId;
        $hn = $request->hn;
        $hcode = $request->hcode;
 
        $authen = Http::post("http://localhost:8189/api/nhso-service/confirm-save",
        [
            'pid'              =>  $cid,
            'claimType'        =>  $claimType,
            'mobile'           =>  $tel,
            'correlationId'    =>  $correlationId,
            // 'hcode'            =>  $hcode,
            'hn'               =>  $hn
        ]);
        
        Patient::where('cid', $cid)
            ->update([
                'hometel'         => $tel 
            ]);
  
        return response()->json([
            'status'     => '200'
        ]);
    }

}