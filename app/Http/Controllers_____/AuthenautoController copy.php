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

class AuthenautoController extends Controller
{

    // public function checkauthen_auto(Request $request)
    // {

    //     $date_now = date("Y-m-d");
    //     set_time_limit(60000);
    //     $datashow = DB::connection('mysql3')->select('
    //                     SELECT o.vn,o.hn,o.an,o.vstdate,o.vsttime,p.cid,sk.depcode,concat(p.pname,p.fname,"  ",p.lname) as fullname
    //                     ,oq.claim_code,oq.mobile,oq.claim_type,oq.authen_type,op.name as fullname_staff,sk.department
    //                     FROM ovst o
    //                     LEFT OUTER JOIN visit_pttype v on v.vn=o.vn
    //                     LEFT OUTER JOIN ovst_queue_server os on os.vn = o.vn
    //                     LEFT OUTER JOIN ovst_queue_server_authen oq on oq.vn = os.vn
    //                     LEFT OUTER JOIN kskdepartment sk on sk.depcode=o.main_dep
    //                     LEFT OUTER JOIN patient p on p.hn=o.hn
    //                     LEFT OUTER JOIN opduser op on op.loginname = o.staff

    //                     WHERE o.vstdate = CURDATE()
    //                     ORDER BY o.vsttime limit 1500
    //                 ');
    //                 // LEFT OUTER JOIN visit_pttype_authen vp on vp.visit_pttype_authen_vn=o.vn
    //                 // set_time_limit(20);
    //                 // while ($i<=10)
    //                 // {
    //                 //         echo "i=$i ";
    //                 //         sleep(100);
    //                 //         $i++;           "2022-12-01"
    //                 // }
    //             foreach ($datashow as $key => $value) {
    //                     $cid = $value->cid;
    //                     $vn = $value->vn;
    //                     $hn = $value->hn;
    //                     $an = $value->an;
    //                     $maindep = $value->depcode;
    //                     $vstdate = $value->vstdate;
    //                     $ft = $value->fullname;
    //                     $staff = $value->fullname_staff;
    //                     $department = $value->department;
    //                     $tel = $value->mobile;
    //                     $claimtype = $value->claim_type;
    //                     // dd($cid);
    //                     $curl = curl_init();
    //                     curl_setopt_array($curl, array(
    //                         CURLOPT_URL => "http://localhost:8189/api/nhso-service/latest-authen-code/$cid",
    //                         CURLOPT_RETURNTRANSFER => 1,
    //                         CURLOPT_SSL_VERIFYHOST => 0,
    //                         CURLOPT_SSL_VERIFYPEER => 0,
    //                         CURLOPT_CUSTOMREQUEST => 'GET',
    //                     ));
    //                     // dd($curl);
    //                     $response = curl_exec($curl);
    //                     curl_close($curl);
    //                     $content = $response;

    //                     $result = json_decode($content, true);
    //                     //  dd($result);
    //                     @$hcode = $result['hcode'];
    //                     // dd(@$hcode);
    //                     @$ex_claimDateTime = explode("T",$result['claimDateTime']);
    //                     // dd(@$ex_claimDateTime);
    //                     $claimDate = $ex_claimDateTime[0];
    //                     if ($claimDate == '') {
    //                         $claimDate = $ex_claimDateTime[0];
    //                         $checkTime = '00:00:00';
    //                         // $checkTime = $ex_claimDateTime[2];
    //                         // dd($claimDate);
    //                     } else {
    //                         // dd(@$ex_claimDateTime);
    //                         $claimDate2 = $ex_claimDateTime[0];
    //                         $checkTime = $ex_claimDateTime[1];
    //                         // dd($checkTime);
    //                     }

    //                     // $claimDate = $ex_claimDateTime[0];
    //                     // $checkTime = $ex_claimDateTime[1];
    //                     // dd($claimDate);
    //                     @$claimCode = $result['claimCode'];

    //                     // $ex_checkDate = explode("T",$result['checkDate']);
    //                     // $claimDate2=$ex_checkDate[0];
    //                     // $checkTime2=$ex_checkDate[1];

    //                     // $ex_checkDate = explode("T",$result['checkDate']);
    //                     // $check_getDate = $ex_checkDate[0];
    //                     // $checkTime = $ex_checkDate[1];

    //                     $checkvn = Visit_pttype_authen::where('visit_pttype_authen_vn','=',$vn)->count();
    //                     // where('visit_pttype_authen_cid','=',$cid)
    //                     // where('visit_pttype_authen_vn','=',$vn)
    //                     // dd($checkvn);
    //                     // $staff = $value->fullname_staff;
    //                     // $department = $value->department;

    //                     if ($checkvn == '0') {
    //                         $data_add = Visit_pttype_authen::create([
    //                             'visit_pttype_authen_cid'       => $cid,
    //                             'visit_pttype_authen_vn'        => $vn,
    //                             'visit_pttype_authen_hn'        => $hn,
    //                             'visit_pttype_authen_an'        => $an,
    //                             'visit_pttype_authen_auth_code' => @$claimCode,
    //                             'claim_type'                    => $claimtype,
    //                             'checkTime'                     => $checkTime,
    //                             'claimDate'                     => $claimDate,
    //                             'main_dep'                      => $maindep,
    //                             'visit_pttype_authen_staff'      => $staff,
    //                             'visit_pttype_authen_department' => $department,
    //                             'visit_pttype_authen_fullname'  => $ft,
    //                             'mobile'                        => $tel,
    //                             'vstdate'                       => $vstdate,
    //                             'created_at'                    => $date_now
    //                         ]);
    //                         $data_add->save();
    //                     } else {
    //                         Visit_pttype_authen::where('visit_pttype_authen_vn', $vn)
    //                         ->update([
    //                             'visit_pttype_authen_cid'            => $cid,
    //                             'visit_pttype_authen_hn'             => $hn,
    //                             'visit_pttype_authen_an'             => $an,
    //                             'visit_pttype_authen_auth_code'      => @$claimCode,
    //                             'claim_type'                         => $claimtype,
    //                             'checkTime'                          => $checkTime,
    //                             'claimDate'                          => $claimDate,
    //                             'main_dep'                           => $maindep,
    //                             'visit_pttype_authen_staff'          => $staff,
    //                             'visit_pttype_authen_department'     => $department,
    //                             'visit_pttype_authen_fullname'       => $ft,
    //                             'mobile'                             => $tel,
    //                             'vstdate'                            => $vstdate,
    //                             'updated_at'                         => $date_now
    //                         ]);
    //                     }
    //                 // return response()->json([
    //                 //     'data_add' => $data_add
    //                 // ]);
    //             }

    //             $data_spsch = DB::connection('mysql3')->select('
    //                     SELECT o.vn,o.hn,o.vstdate,o.vsttime,p.cid,concat(p.pname,p.fname," ",p.lname) as fullname,oq.claim_code,vp.visit_pttype_authen_auth_code,oq.mobile,
    //                     oq.claim_type,oq.authen_type,os.is_appoint,o.staff,op.name as fullname_staff,os.opd_dep,sk.department
    //                     FROM ovst o
    //                     LEFT OUTER JOIN visit_pttype_authen vp on vp.visit_pttype_authen_vn = o.vn
    //                     LEFT OUTER JOIN ovst_queue_server os on os.vn = o.vn
    //                     LEFT OUTER JOIN ovst_queue_server_authen oq on oq.vn = os.vn
    //                     LEFT OUTER JOIN kskdepartment sk on sk.depcode=o.main_dep
    //                     LEFT OUTER JOIN patient p on p.hn=o.hn
    //                     LEFT OUTER JOIN opduser op on op.loginname = o.staff
    //                     WHERE o.vstdate = CURDATE()
    //                     ORDER BY o.vsttime LIMIT 10
    //             ');
    //         return view('authen.checkauthen_auto',[
    //             'response'  => $response,
    //             'result'  => $result,
    //             'data_spsch'  => $data_spsch
    //         ]);

    // }


    // public function getauthen_auto(Request $request)
    // {
    //     $date_now = date("Y-m-d");
    //     $datashow = DB::connection('mysql3')->select('
    //         SELECT v.vn ,v.hn ,v.cid
    //             ,vp.claim_code
    //             ,p.pttype ,p.hipdata_code
    //             ,cab.*
    //             FROM vn_stat v
    //             LEFT JOIN visit_pttype vp ON v.vn=vp.vn
    //             LEFT JOIN pttype p ON v.pttype=p.pttype
    //             LEFT JOIN z_check_authen_bamnet cab ON v.vn=cab.z_vn
    //             WHERE v.vstdate = "'.$date_now.'"
    //             AND (vp.claim_code IS NULL OR vp.claim_code="")
    //             ORDER BY z_time
    //             LIMIT 10
    //     ');
    //             foreach ($datashow as $key => $value) {
    //                 $cid = $value->cid;
    //                 $vn = $value->vn;
    //                 $hn = $value->hn;
    //                 // dd($cid);
    //                 $curl = curl_init();
    //                 curl_setopt_array($curl, array(
    //                     CURLOPT_URL => "http://localhost:8189/api/nhso-service/latest-5-authen-code-all-hospital/$cid",
    //                     CURLOPT_RETURNTRANSFER => 1,
    //                     CURLOPT_SSL_VERIFYHOST => 0,
    //                     CURLOPT_SSL_VERIFYPEER => 0,
    //                     CURLOPT_CUSTOMREQUEST => 'GET',
    //                 ));
    //             // dd($curl);
    //             $response = curl_exec($curl);
    //             curl_close($curl);
    //             $content = $response;
    //             $result = json_decode($content, true);
    //             // dd($result);
    //             @$hcode = $result['hcode'];
    //             @$ex_claimDateTime = explode("T",$result['claimDateTime']);
    //             $claimDate = $ex_claimDateTime[0];
    //             $checkTime = $ex_claimDateTime[1];
    //             @$claimCode = $result['claimCode'];
    //             $ex_checkDate = explode("T",$result['checkDate']);
    //             $claimDate2 = $ex_checkDate[0];
    //             $checkTime2 = $ex_checkDate[1];
    //             // dd($result);
    //                 return response()->json( );


    //             }

    // }


    public function authencode_auto(Request $request)
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

        return view('authen.authencode_auto',[
            'smartcard'            =>   $smartcard,
            'cardcid'            =>  $cardcid,
            'smartcardcon'            =>  $smartcardcon,
            'output'            =>  $output,
        ]);
    }

    public function authencode_auto_detail(Request $request)
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

        return view('authen.authencode_auto_detail',$data,[
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

    // public function getsmartcard_authencode(Request $request)
    // {
    //     $ip = $request->ip();
    //     $collection = Http::get('http://'.$ip.':8189/api/smartcard/read?readImageFlag=true')->collect();
    //     $data['patient'] =  DB::connection('mysql3')->select('select cid,hometel from patient limit 10');

    //     $year = substr(date("Y"),2) +43;
    //     $mounts = date('m');
    //     $day = date('d');
    //     $time = date("His");
    //     $vn = $year.''.$mounts.''.$day.''.$time;

    //     $getvn_stat =  DB::connection('mysql3')->select('select * from vn_stat limit 2');
    //     $get_ovst =  DB::connection('mysql3')->select('select * from ovst limit 2');
    //     $get_opdscreen =  DB::connection('mysql3')->select('select * from opdscreen limit 2');
    //     $get_ovst_seq =  DB::connection('mysql3')->select('select * from ovst_seq limit 2');
    //     $get_spclty =  DB::connection('mysql3')->select('select * from spclty');
    //     ///// เจน  hos_guid  จาก Hosxp
    //     $data_key = DB::connection('mysql3')->select('SELECT uuid() as keygen');
    //     $output4 = Arr::sort($data_key);
    //     foreach ($output4 as $key => $value) {
    //         $hos_guid = $value->keygen;
    //     }
    //     $datapatient = DB::connection('mysql3')->table('patient')->where('cid','=',$collection['pid'])->first();
    //         if ($datapatient->hometel != null) {
    //             $cid = $datapatient->hometel;
    //         } else {
    //             $cid = '';
    //         }
    //         if ($datapatient->hn != null) {
    //             $hn = $datapatient->hn;
    //         } else {
    //             $hn = '';
    //         }
    //         if ($datapatient->hcode != null) {
    //             $hcode = $datapatient->hcode;
    //         } else {
    //             $hcode = '';
    //         }
    //                 $curl = curl_init();
    //                 curl_setopt_array($curl, array(
    //                     CURLOPT_URL => "http://localhost:8189/api/smartcard/read?readImageFlag=true",
    //                     CURLOPT_RETURNTRANSFER => 1,
    //                     CURLOPT_SSL_VERIFYHOST => 0,
    //                     CURLOPT_SSL_VERIFYPEER => 0,
    //                     CURLOPT_CUSTOMREQUEST => 'GET',
    //                 ));

    //                 $response = curl_exec($curl);
    //                 curl_close($curl);
    //                 $content = $response;
    //                 $result = json_decode($content, true);

    //                 // dd($result);
    //                 @$pid = $result['pid'];
    //                 @$titleName = $result['titleName'];
    //                 @$fname = $result['fname'];
    //                 @$lname = $result['lname'];
    //                 @$nation = $result['nation'];
    //                 @$birthDate = $result['birthDate'];
    //                 @$sex = $result['sex'];
    //                 @$transDate = $result['transDate'];
    //                 @$mainInscl = $result['mainInscl'];
    //                 @$subInscl = $result['subInscl'];
    //                 @$age = $result['age'];
    //                 @$checkDate = $result['checkDate'];
    //                 @$image = $result['image'];
    //                 @$correlationId = $result['correlationId'];
    //                 @$startDateTime = $result['startDateTime'];
    //                 @$claimTypes = $result['claimTypes'];
    //                 // $hcode=@$hospMain[1];
    //                 // @$hcode = $result['hcode'];

    //                 // @$claimTypes = explode($result['claimType'],$result['claimTypeName']);
    //                 // $claimDate=$ex_claimDateTime[0];
    //                 // $checkTime=$ex_claimDateTime[1];
    //                 // dd(@$claimTypes);
    //                 // foreach (@$claimTypes as $key => $value) {
    //                 //     $s = $value['claimType']['0'];
    //                 //     $ss = $value['claimType']['1'];
    //                 // }
    //                 // dd($ss);
    //                 $pid        = @$pid;
    //                 $fname      = @$fname;
    //                 $lname      = @$lname;
    //                 $birthDate      = @$birthDate;
    //                 $sex      = @$sex;
    //                 $mainInscl      = @$mainInscl;
    //                 $subInscl      = @$subInscl;
    //                 $age      = @$age;
    //                 $image      = @$image;
    //                 $correlationId      = @$correlationId;

    //                 // dd($correlationId);

    //     return view('getsmartcard_authencode',$data,[
    //         'ip' => $ip,
    //         'pid'           => $pid,
    //         'fname'         => $fname,
    //         'lname'         => $lname,
    //         'birthDate'     => $birthDate,
    //         'sex'           => $sex,
    //         'mainInscl'     => $mainInscl,
    //         'subInscl'      => $subInscl,
    //         'age'           => $age,
    //         'image'         => $image,
    //         'correlationId' => $correlationId,
    //     ]);
    // }


}
