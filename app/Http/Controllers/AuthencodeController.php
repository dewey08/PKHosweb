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
use GuzzleHttp\Client;
// http://192.168.121.111:8189/
class AuthencodeController extends Controller
{
    public function authen_main(Request $request)
    {
        $ip = $request->ip();
        // dd($ip);
        $terminals = Http::get('http://' . $ip . ':8189/api/smartcard/terminals')->collect();
        $cardcid = Http::get('http://' . $ip . ':8189/api/smartcard/read')->collect();
        $cardcidonly = Http::get('http://' . $ip . ':8189/api/smartcard/read-card-only')->collect();
        // $terminals = Http::get('http://localhost:8189/api/smartcard/terminals')->collect();
        // $cardcid = Http::get('http://localhost:8189/api/smartcard/read')->collect();
        // $cardcidonly = Http::get('http://localhost:8189/api/smartcard/read-card-only')->collect();
        $output = Arr::sort($terminals);
        $outputcard = Arr::sort($cardcid);
        $outputcardonly = Arr::sort($cardcidonly);
        // dd($outputcardonly);
        if ($output == []) {

            $smartcard = 'NO_CONNECT';
            $smartcardcon = '';
            // dd($smartcard);
            return view('authen.authen_main', [
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

                return view('authen.authen_main', [
                    'smartcard'          =>  $smartcard,
                    'cardcid'            =>  $cardcid,
                    'smartcardcon'       =>  $smartcardcon,
                    'output'             =>  $output,
                ]);
                // dd($smartcardcon);   
            } else {
                $smartcardcon = 'CID_OK';
                // dd($smartcardcon);  
                $collection = Http::get('http://' . $ip . ':8189/api/smartcard/read?readImageFlag=true')->collect();
                // $patient =  DB::connection('mysql')->select('select cid,hometel from patient limit 10');
                $output2 = Arr::sort($collection);
                $hcode = $output2['hospMain']['hcode'];
                //  dd($collection['pid']);   
                $pidscheck = $collection['pid'];            
                $token_data = DB::connection('mysql10')->select('SELECT * FROM nhso_token ORDER BY update_datetime desc limit 1');
                foreach ($token_data as $key => $value) {
                    $cid_    = $value->cid;
                    $token_  = $value->token;
                }
                // dd($token_data);  
                $client = new SoapClient(
                    "http://ucws.nhso.go.th/ucwstokenp1/UCWSTokenP1?wsdl",
                    array("uri" => 'http://ucws.nhso.go.th/ucwstokenp1/UCWSTokenP1?xsd=1', "trace" => 1, "exceptions" => 0, "cache_wsdl" => 0)
                );
                $params = array(
                    'sequence' => array(
                        "user_person_id" => "$cid_",
                        "smctoken"       => "$token_",
                        "person_id"      => "$pidscheck"
                    )
                );
                $contents = $client->__soapCall('searchCurrentByPID', $params);
                // dd($contents);
                //   dd($hcode);
                foreach ($contents as $v) {
                    @$status                   = $v->status;
                    @$maininscl                = $v->maininscl;  // maininscl": "WEL"
                    @$startdate                = $v->startdate;  //"25650728"
                    @$hmain                    = $v->hmain;   //"11066"
                    @$subinscl                 = $v->subinscl;    //subinscl": "73"
                    @$person_id_nhso           = $v->person_id;
                    if (@$maininscl == 'WEL') {
                        @$cardid               = $v->cardid;  // "R73450035286038"
                    } else {
                        $cardid = '';
                    } 
                    @$hmain_op                 = $v->hmain_op;  //"10978"
                    @$hmain_op_name            = $v->hmain_op_name;  //"รพ.ภูเขียวเฉลิมพระเกียรติ"
                    @$hsub                     = $v->hsub;    //"04047"
                    @$hsub_name                = $v->hsub_name;   //"รพ.สต.แดงสว่าง"
                    @$subinscl_name            = $v->subinscl_name; //"ช่วงอายุ 12-59 ปี"
                    @$primary_amphur_name      = $v->primary_amphur_name;  // อำเภอ  "โพนทอง"
                    @$primary_moo              = $v->primary_moo;    //หมู่ที่ 01
                    @$primary_mooban_name      = $v->primary_mooban_name;  // ชื่อหมู่บ้าน  "หนองนกแก้ว"
                    @$primary_tumbon_name      = $v->primary_tumbon_name;   //ชื่อตำบล   "สระนกแก้ว"
                    @$primary_province_name    = $v->primary_province_name;  //ชื่อจังหวัด
                }
                $check_cid = DB::connection('mysql2')->table('patient')->where('cid','=',$collection['pid'])->count();
                $check_hcode = DB::connection('mysql')->table('orginfo')->where('orginfo_id','=','1')->first();
                // dd($check_cid);
                if ($check_cid > 0) {
                            $data_patient_ = DB::connection('mysql2')->select(' 
                                        SELECT p.hn ,pe.pttype_expire_date as expiredate ,pe.pttype_hospmain as hospmain ,pe.pttype_hospsub as hospsub 
                                        ,p.pttype,pt.name as ptname,pt.hipdata_pttype, pe.pttype_no as pttypeno ,pe.pttype_begin_date as begindate,p.cid,p.hcode,p.last_visit,p.hometel
                                        ,p.bloodgrp,p.addrpart,p.informname,p.informrelation,p.informtel,p.fathername,p.fatherlname
                                        ,p.father_cid,p.mathername,p.motherlname,p.mother_cid,p.spsname,p.spslname
                                        ,h.chwpart,h.amppart,h.tmbpart,h.po_code
                                        FROM patient p 
                                        LEFT OUTER JOIN person pe ON pe.patient_hn = p.hn 
                                        LEFT OUTER JOIN pttype pt ON pt.pttype = p.pttype
                                        LEFT OUTER JOIN hospcode h ON h.chwpart = p.chwpart AND h.amppart = p.amppart AND h.tmbpart = p.tmbpart
                                        WHERE p.cid = "'.$collection['pid'].'"
                                        GROUP BY p.hn
                            ');
                            // dd($data_patient_);
                            foreach ($data_patient_ as $key => $value) {
                                $pids          = $value->cid;
                                $hcode         = $value->hcode;
                                $hn            = $value->hn;
                                $last_visit    = $value->last_visit;
                                $hometel       = $value->hometel;
                                $chwpart       = $value->chwpart;
                                $amppart       = $value->amppart;
                                $tmbpart       = $value->tmbpart;
                                $addrpart       = $value->addrpart;
                                $po_code       = $value->po_code;
                                $bloodgrp      = $value->bloodgrp;

                                $informname      = $value->informname;
                                $informrelation  = $value->informrelation;
                                $informtel       = $value->informtel;
                                $fathername      = $value->fathername;
                                $fatherlname     = $value->fatherlname;
                                $father_cid      = $value->father_cid;
                                $mathername      = $value->mathername;
                                $motherlname     = $value->motherlname;
                                $mother_cid      = $value->mother_cid;
                                $spsname         = $value->spsname;
                                $spslname        = $value->spslname;
                                $ptname          = $value->ptname;
                                $hipdata_pttype  = $value->hipdata_pttype;
                                $pttype_s        = $value->pttype;

                            }
                           
                            $check_pttype = DB::connection('mysql10')->table('pttype')->where('hipdata_pttype','=',$subinscl)->where('pttype','=',$pttype_s)->get();


                } else {
                        $pids            = $collection['pid'];
                        $hcode           = $check_hcode->orginfo_code;
                        $hn              = '';
                        $last_visit      = '';
                        $hometel         = '';
                        $chwpart         = $primary_province_name;
                        $amppart         = $primary_amphur_name;
                        $tmbpart         = $primary_tumbon_name;
                        $addrpart        = '';
                        $po_code         = '';
                        $bloodgrp        = '';
                        $informname      = '';
                        $informrelation  = '';
                        $informtel       = '';
                        $fathername      = '';
                        $fatherlname     = '';
                        $father_cid      = '';
                        $mathername      = '';
                        $motherlname     = '';
                        $mother_cid      = '';
                        $spsname         = '';
                        $spslname        = '';
                        $ptname          = '';
                        $hipdata_pttype  = '';
                        $pttype_s        = '';

                        // $check_pttype = DB::connection('mysql10')->table('pttype')->where('hipdata_pttype','=',$subinscl)->get();
                    
                }
                
                
                // dd($pids);
                // $check_pttype = DB::connection('mysql10')->table('pttype')->where('hipdata_pttype','=',$subinscl)->where('pttype','=',$pttype)->get();
                // $data['check_pttype'] = DB::connection('mysql10')->table('pttype')->where('hipdata_pttype','=',$subinscl)->get();
                // dd($hcode);
                $year = substr(date("Y"), 2) + 43;
                $mounts = date('m');
                $day = date('d');
                $time = date("His");
                $vn = $year . '' . $mounts . '' . $day . '' . $time;
                $time_s = date("H:i:s");
                // dd($time_s);
                $date = date('Y-m-d');
                // dd($vn);
                // $getvn_stat =  DB::connection('mysql10')->select('select * from vn_stat limit 2');
                // $get_ovst =  DB::connection('mysql10')->select('select * from ovst limit 2');
                // $get_opdscreen =  DB::connection('mysql10')->select('select * from opdscreen limit 2');
                // $get_ovst_seq =  DB::connection('mysql10')->select('select * from ovst_seq limit 2');
                // $get_spclty =  DB::connection('mysql10')->select('select * from spclty');
                $data['ovstist'] =  DB::connection('mysql10')->select('select * from ovstist');
                $data['spclty'] =  DB::connection('mysql10')->select('select * from spclty');
                $data['kskdepartment'] =  DB::connection('mysql10')->select('select * from kskdepartment');
                $data['pt_priority'] =  DB::connection('mysql10')->select('select * from pt_priority order by id');
                $data['pt_walk'] =  DB::connection('mysql10')->select('select * from pt_walk');
                $data['pt_subtype'] =  DB::connection('mysql10')->select('select * from pt_subtype order by pt_subtype');
                $data['pname'] =  DB::connection('mysql10')->select('select * from pname order by name');
                $data['marrystatus'] =  DB::connection('mysql10')->select('select code,name from marrystatus');
                $data['nationality'] =  DB::connection('mysql10')->select(' select nationality as code,name from nationality order by nationality desc');
                $data['thaiaddress_provine'] =  DB::connection('mysql10')->select('select chwpart,name from thaiaddress WHERE codetype="1"');
                $data['thaiaddress_amphur'] =  DB::connection('mysql10')->select('select amppart,name from thaiaddress WHERE codetype="2"');
                $data['thaiaddress_tumbon'] =  DB::connection('mysql10')->select('select tmbpart,name from thaiaddress WHERE codetype="3"');
                $data['thaiaddress_po_code'] =  DB::connection('mysql10')->select('SELECT chwpart,amppart,tmbpart,po_code FROM hospcode WHERE po_code <>"" GROUP BY po_code');
                $data['blood_group'] =  DB::connection('mysql10')->select('select name from blood_group order by name');
                $data['informrelation_list'] =  DB::connection('mysql10')->select('select name from informrelation_list');
                $data['religion'] =  DB::connection('mysql10')->select('SELECT * FROM religion');
                $data['occupation'] =  DB::connection('mysql10')->select('SELECT * FROM occupation');
                $data_patient =  DB::connection('mysql10')->select('SELECT pttype FROM patient WHERE cid = "'.$collection['pid'].'" ');
                $data['pttype'] =  DB::connection('mysql10')->select('SELECT * FROM pttype');
                // dd($data_patient);
                foreach ($data_patient as $key => $value_pat) {
                    $check_pttype_ = DB::connection('mysql10')->table('pttype')->where('hipdata_pttype','=',$subinscl)->where('pttype','=',$value_pat->pttype)->first();
                }
                // $ori_pttype  = $check_pttype_->pttype;
                $ori_pttype  = $data_patient;
                // dd($ori_pttype);
                // $data['thaiaddress_provinces'] =  DB::connection('mysql10')->select(' select * from thaiaddress_provinces');
                // $data['thaiaddress_amphures'] =  DB::connection('mysql10')->select(' select * from thaiaddress_amphures');
                // $data['thaiaddress_districts'] =  DB::connection('mysql10')->select(' select * from thaiaddress_districts');
                // dd($getvn_stat);

                //ที่เก็บรูปภาพ
                $data['patient_image'] =  DB::connection('mysql10')->select('select * from patient_image where image_name = "OPD" limit 100');
                // dd($data_patient);
                if ($hn == '') {
                    $ovst_key = '';
                } else {
                     ///// เจน  ovst_key  จาก Hosxp
                    // $getovst_key_ = Http::get('https://cloud4.hosxp.net/api/ovst_key?Action=get_ovst_key&hospcode="' . $hcode . '"&vn="' . $vn . '"&computer_name=abcde&app_name=AppName&fbclid=IwAR2SvX7NJIiW_cX2JYaTkfAduFqZAi1gVV7ftiffWPsi4M97pVbgmRBjgY8')->collect();
                    // $output5 = Arr::sort($getovst_key_);                  
                    // $ovst_key = $output5['result']['ovst_key'];
                    $ovst_key = '';
                    // dd($ovst_key);
                }
                 
                ///// เจน  hos_guid  จาก Hosxp
                $data_key = DB::connection('mysql10')->select('SELECT uuid() as keygen');
                $output4 = Arr::sort($data_key);
                // dd($output4);
                foreach ($output4 as $key => $value_) {
                    $hos_guid = $value_->keygen;
                }

                
              
                // foreach ($output5 as $key => $value_ovst_key) { 
                //     $ovst_key = $value_ovst_key->ovst_key; 
                // }
                // dd($hos_guid);
                return view('authen.authen_main', $data, [
                    'smartcard'                  =>  $smartcard,
                    'cardcid'                    =>  $cardcid,
                    'smartcardcon'               =>  $smartcardcon,
                    'hometel'                    =>  $hometel,
                    'vn'                         =>  $vn,
                    'hn'                         =>  $hn,
                    'chwpart'                    =>  $chwpart,
                    'amppart'                    =>  $amppart,
                    'tmbpart'                    =>  $tmbpart,
                    'po_code'                    =>  $po_code,
                    'bloodgrp'                   =>  $bloodgrp,
                    'addrpart'                   =>  $addrpart,
                    'last_visit'                 =>  $last_visit,
                    'hcode'                      =>  $hcode,
                    'hos_guid'                   =>  $hos_guid,
                    'ovst_key'                   =>  $ovst_key,
                    'time'                       =>  $time,
                    'collection1'                => $collection['pid'],
                    'collection2'                => $collection['fname'],
                    'collection3'                => $collection['lname'],
                    'collection4'                => $collection['birthDate'],
                    'collection5'                => $collection['transDate'],
                    'collection6'                => $collection['mainInscl'],
                    'collection7'                => $collection['subInscl'],
                    'collection8'                => $collection['age'],
                    'collection9'                => $collection['checkDate'],
                    'collection10'               => $collection['correlationId'],
                    'collection11'               => $collection['checkDate'],
                    'collection12'               => $collection['image'],
                    'collection13'               => $collection['sex'],
                    'collection14'               => $collection['nation'],
                    'collection15'               => $collection['titleName'],
                    'time_s'                     => $time_s,
                    'date'                       => $date,
                    'primary_moo'                => $primary_moo ,
                    'primary_tumbon_name'        => $primary_tumbon_name ,
                    'primary_amphur_name'        => $primary_amphur_name ,
                    'primary_province_name'      => $primary_province_name ,
                    // 'check_pttype'               => $check_pttype, 
                    'informname'                 =>$informname,
                    'informrelation'             =>$informrelation,
                    'informtel'                  =>$informtel ,
                    'fathername'                 =>$fathername ,
                    'fatherlname'                =>$fatherlname ,
                    'father_cid'                 =>$father_cid,
                    'mathername'                 =>$mathername,
                    'motherlname'                =>$motherlname,
                    'mother_cid'                 =>$mother_cid,
                    'spsname'                    =>$spsname,
                    'spslname'                   =>$spslname,
                    'ptname'                     =>$ptname,
                    'hipdata_pttype'             =>$hipdata_pttype,
                    'subinscl'                   =>$subinscl,
                    'ori_pttype'                 =>$ori_pttype,
                    'pttype_s'                   =>$pttype_s
                ]);
            }
        }
    }
    public function authen_index(Request $request)
    {
        // $ip = $request()->ip();
        $ip = $request->ip();
        $collection = Http::get('http://' . $ip . ':8189/api/smartcard/read?readImageFlag=true')->collect();
        $patient =  DB::connection('mysql10')->select('select cid,hometel from patient limit 10');

        // $terminals = Http::get('http://'.$ip.':8189/api/smartcard/terminals')->collect();
        // $cardcid = Http::get('http://'.$ip.':8189/api/smartcard/read')->collect();
        // $cardcidonly = Http::get('http://'.$ip.':8189/api/smartcard/read-card-only')->collect();
        return view('authen.authen_index', [
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
    public function authencode(Request $request)
    {
  
        // $authen = Http::post(
        //     "http://' . $ip . ':8189/api/nhso-service/confirm-save/",
        //     [
        //         'pid'              =>  $request->pid,
        //         'claimType'        =>  $request->claimType,
        //         'mobile'           =>  $request->mobile,
        //         'correlationId'    =>  $request->correlationId,
        //         'hn'               =>  $request->hn,
        //         'hcode'            =>  $request->hcode
        //     ]
        // );
        $ip = $request->ip();
           // dd($ip);
        $response = Http::withHeaders([ 
            'User-Agent:<platform>/<version> <10978>',
            'Accept' => 'application/json',
        ])->post('http://' . $ip . ':8189/api/nhso-service/confirm-save/', [
            'pid'              =>  $request->pid,
            'claimType'        =>  $request->claimType,
            'mobile'           =>  $request->mobile,
            'correlationId'    =>  $request->correlationId,
            'hn'               =>  $request->hn,
            'hcode'            =>  $request->hcode
        ]);  
  
        Patient::where('cid', $request->pid)
            ->update([
                'hometel'    => $request->mobile
            ]); 
     
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

    public function authencode_patient_save(Request $request)
    {       
        $hos_guid                  = $request->hos_guid_p;
        $pname                     = $request->pname_p;
        $fname                     = $request->fname_p;
        $lname                     = $request->lname_p;
        $cid                       = $request->cid_p;
        $marrystatus               = $request->marrystatus_p;
        $citizenship               = $request->citizenship_p;
        $nationality               = $request->nationality_p;
        $sex                       = $request->sex_p;
        $addrpart                  = $request->addrpart_p;
        $moopart                   = $request->moopart_p;
        $hometel                   = $request->hometel_p;
        $bloodgrp                  = $request->bloodgrp_p;
        $chwpart                   = $request->chwpart_p;
        $amppart                   = $request->amppart_p;
        $tmbpart                   = $request->tmbpart_p;
        $po_code                   = $request->po_code_p;
        $hcode                     = $request->hcode_p;
        $lang                      = $request->lang_p;
        $country_p                 = $request->country_p;
        $informname                = $request->informname_p;
        $informrelation            = $request->informrelation_p;
        $fathername                = $request->fathername_p;
        $fatherlname               = $request->fatherlname_p;
        $mathername                = $request->mothername_p;
        $motherlname               = $request->motherlname_p; 
        $spsname_p                 = $request->spsname_p;
        $spslname_p                = $request->spslname_p;
        $father_cid                = $request->father_cid_p;
        $mother_cid                = $request->mother_cid_p;
        $religion                  = $request->religion_p;
        $occupation                = $request->occupation_p;
        $informtel                 = $request->informtel_p;
        $pttype                    = $request->pttype_p;
        
        // dd($amppart);

        $data['thaiaddress_provine'] =  DB::connection('mysql10')->select('select chwpart,name from thaiaddress WHERE codetype="1"');
        $data['thaiaddress_amphur'] =  DB::connection('mysql10')->select('select amppart,name from thaiaddress WHERE codetype="2"');
        $data['thaiaddress_tumbon'] =  DB::connection('mysql10')->select('select tmbpart,name from thaiaddress WHERE codetype="3"');

        $chwpart_ =  DB::connection('mysql10')->table('thaiaddress')->where('codetype','=','1')->where('chwpart','=',$chwpart)->first(); 
        $amphur_ =  DB::connection('mysql10')->table('thaiaddress')->where('codetype','=','2')->where('chwpart','=',$chwpart)->where('amppart','=',$amppart)->first(); 
        $tumbon_ =  DB::connection('mysql10')->table('thaiaddress')->where('codetype','=','3')->where('chwpart','=',$chwpart)->where('amppart','=',$amppart)->where('tmbpart','=',$tmbpart)->first(); 

        // dd($tumbon_->name);
        $informaddr_               = $addrpart.' หมู่ '.$moopart.' ต.'.$tumbon_->name.' อ.'.$amphur_->name.' จ.'.$chwpart_->name;            
        
        $birthday_                  = $request->birthDate_p; 
        $ye      = substr($birthday_, 0, 4)-543;
        $mo      = substr($birthday_, 4, 2);
        $day     = substr($birthday_, 6, 2);            
        $birthday = $ye.'-'.$mo.'-'.$day;
     
        $max_hn          = Patient::whereNotIn('hn',['1111111', '2222222','3333333','4444444'])->max('hn')+1;
        $date            = date('Y-m-d');
        $reg_time        = date("H:i:s");
        $last_update     = date('Y-m-d H:i:s');
        Patient::insert([
            'hos_guid'             => '{'.$hos_guid.'}',
            'hn'                   => $max_hn,
            'pname'                => $pname,
            'fname'                => $fname,
            'lname'                => $lname,
            'cid'                  => $cid,
            'marrystatus'          => $marrystatus,
            'citizenship'          => $citizenship,
            'nationality'          => $nationality,
            'sex'                  => $sex,
            'addrpart'             => $addrpart,
            'moopart'              => $moopart,
            'informname'           => $informname,
            'informrelation'       => $informrelation,
            'fathername'           => $fathername,
            'fatherlname'          => $fatherlname, 
            'father_cid'           => $father_cid, 
            'mathername'           => $mathername,
            'motherlname'          => $motherlname, 
            'mother_cid'           => $mother_cid, 
            'spsname'              => $spsname_p,
            'spslname'             => $spslname_p,
            'hometel'              => $hometel,
            'informaddr'           => $informaddr_,
            'bloodgrp'             => $bloodgrp,
            'chwpart'              => $chwpart,
            'amppart'              => $amppart,
            'tmbpart'              => $tmbpart,
            'po_code'              => $po_code,
            'hcode'                => $hcode,
            'birthday'             => $birthday_,
            'firstday'             => $date,
            'religion'             => $religion,
            'occupation'           => $occupation,
            'informtel'            => $informtel,
            'pttype'               => $pttype,
            'last_update'          => $last_update,
            'country'              => $country_p,
            'death'                => 'N',
            'last_visit'           => $date,
            'reg_time'             => $reg_time,
            'lang'                 => $lang,
           
        ]);
        return response()->json([
            'status'     => '200',
        ]);
    }

    public function authencode_visit_save(Request $request)
    {
        $hos_guid       = $request->hos_guid;
        $ovst_key       = $request->ovst_key;
        $vn             = $request->vn;
        $hcode          = $request->hcode;
        $pid            = $request->pid;
        $mainInscl      = $request->mainInscl; //สิทธิหลัก
        $subInscl       = $request->subInscl;   //สิทธิ์ย่อย
        $claimType      = $request->claimType;
        $claimType2     = $request->claimType2;
        $claimType3     = $request->claimType3;
        
        if ($claimType != '') {
            $claimType_ = $request->claimType;
          }else if ($claimType2 != '') {
            $claimType_ = $request->claimType2;
        } else {
            $claimType_ = $request->claimType3;
        }
                
        $mobile         = $request->mobile;
        $hn             = $request->hn;
        $main_dep_queue = $request->main_dep_queue; //ส่งต่อไปยัง
        $spclty         = $request->spclty;  //แผนก
        $pt_subtype     = $request->pt_subtype;  //ประเภท
        $ovstist        = $request->ovstist;  //ประเภทการมา
        $pt_priority    = $request->pt_priority;  //ความเร่งด่วน
        $pt_walk        = $request->pt_walk; //สภาพผู้ป่วย
        $cc             = $request->cc; //อาการที่มา 
        $time           = substr($request->vn,6,6);
        $vstdate = date('Y-m-d');
        $outtime = date("His");
        $datetime = date('Y-m-d H:i:s');




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
                WHERE p.cid = "' . $pid . '"
        ');
        foreach ($data_patient_ as $key => $value) {
            $expiredate    = $value->expiredate;
            $hospmain      = $value->hospmain;
            $hospsub       = $value->hospsub;
            $pttype        = $value->pttype;
            $pttypeno      = $value->pttypeno;
            $begindate     = $value->begindate;
            // $cid           = $value->cid;
        }
        $token_data = DB::connection('mysql10')->select('SELECT * FROM nhso_token ORDER BY update_datetime desc limit 1');
        foreach ($token_data as $key => $value) {
            $cid_    = $value->cid;
            $token_  = $value->token;
        }
        $client = new SoapClient(
            "http://ucws.nhso.go.th/ucwstokenp1/UCWSTokenP1?wsdl",
            array("uri" => 'http://ucws.nhso.go.th/ucwstokenp1/UCWSTokenP1?xsd=1', "trace" => 1, "exceptions" => 0, "cache_wsdl" => 0)
        );
        $params = array(
            'sequence' => array(
                "user_person_id" => "$cid_",
                "smctoken"       => "$token_",
                "person_id"      => "$pid"
            )
        );
        $contents = $client->__soapCall('searchCurrentByPID', $params);
        foreach ($contents as $v) {
            @$status           = $v->status;
            @$maininscl        = $v->maininscl;
            @$startdate        = $v->startdate;
            @$hmain            = $v->hmain;
            @$subinscl         = $v->subinscl;
            @$person_id_nhso   = $v->person_id;
            @$hmain_op         = $v->hmain_op;  //"10978"
            @$hmain_op_name    = $v->hmain_op_name;  //"รพ.ภูเขียวเฉลิมพระเกียรติ"
            @$hsub             = $v->hsub;    //"04047"
            @$hsub_name        = $v->hsub_name;   //"รพ.สต.แดงสว่าง"
            @$subinscl_name    = $v->subinscl_name; //"ช่วงอายุ 12-59 ปี"
        }

        Vn_insert::insert([
            'vn'         => $vn,
            'hos_guid'   => $hos_guid 
        ]);
        $check_ptt = Pttypehistory::where('hn',$hn)->count();
        if ($check_ptt > 0) {
            # code...
        } else {
            Pttypehistory::insert([ 
                'hn'                => $hn,
                'expiredate'        => $expiredate,
                'hospmain'          => $hospmain,
                'hospsub'           => $hospsub,
                'pttype'            => $pttype,
                'pttypeno'          => $pttypeno,
                'begindate'         => $begindate, 
                'hos_guid'          => $hos_guid 
            ]);
        }
        
       
        $max_q = Ovst::max('oqueue')+1;
        Ovst::insert([
            'hos_guid'          => $hos_guid,
            'vn'                => $vn,
            'hn'                => $hn,
            'vstdate'           => $vstdate,
            'vsttime'           => $time,
            'hospmain'          => $hospmain,
            'hospsub'           => $hospsub,
            'oqueue'            => $max_q,
            'ovstist'           => $ovstist,
            // 'ovstost'           => $value->begindate,
            'pttype'            => $pttype,
            'pttypeno'          => $pttypeno,
            'spclty'            => $spclty,
            'hcode'             => $hcode,
            // 'last_dep'          => $value->begindate,
            'pt_subtype'        => $pt_subtype,
            'main_dep_queue'    => $main_dep_queue,
            'visit_type'        => 'I',
            'node_id'           => '',
            'waiting'           => 'Y',
            'has_insurance'     => 'N',
            // 'staff'             => $value->staff,
            'pt_priority'       => $pt_priority,
            'ovst_key'          => $ovst_key,
        ]);

        Ptdepart::insert([ 
            'vn'                => $vn,
            // 'depcode'           => $depcode,
            'hn'                => $hn,
            'intime'            => $time,
            // 'outdepcode'        => $outdepcode,
            'outtime'           => $outtime,
            // 'staff'             => $staff, 
            'outdate'           => $vstdate,
            'hos_guid'          => $hos_guid, 
        ]);

        Service_time::insert([ 
            'vn'                => $vn, 
            'hn'                => $hn,
            'vstdate'           => $vstdate ,
            'vsttime'           => $time,
            //'service3'        => $service3,
             //'staff'          => $staff, 
            'last_send_time'    => $datetime,
           //'service3_dep'        => $service3_dep,
            
        ]);

        Visit_pttype::insert([ 
            'vn'                => $vn, 
            'pttype'            => $pttype,
            'begin_date'        => $begindate ,
            'expire_date'       => $expiredate,
            'hospmain'          => $hospmain,
            'hospsub'           => $hospsub, 
            'pttypeno'          => $pttypeno,
            'hos_guid'          => $hos_guid,
            'claim_code'        => $claimType_,
           'pttype_number'      => '1',
             'contract_id'      => '0',
        ]);

        // dd($contents);
        return response()->json([
            'status'     => '200',
        ]);
        
    }
    // จังหวัด
    function fetch_province(Request $request)
    { 
            // =  DB::connection('mysql10')->select(' select chwpart,name from thaiaddress WHERE codetype="1"');
            $id = $request->get('select');
            $result=array();
            // $query=DB::connection('mysql10')->select('select chwpart,name,amppart from thaiaddress WHERE codetype IN("1","2")');
            $query= DB::connection('mysql10')->table('thaiaddress')
            // ->join('hrd_amphur','hrd_province.ID','=','hrd_amphur.PROVINCE_ID')
            // ->select('hrd_amphur.AMPHUR_NAME','hrd_amphur.ID')
            ->where('chwpart',$id)
            ->where('codetype','=','2')
            // ->groupBy('hrd_amphur.AMPHUR_NAME','hrd_amphur.ID')
            ->get();

            $output='<option value="">--Choose--</option> ';
            // $output=''; 
            foreach ($query as $row){ 
                    $output.= '<option value="'.$row->amppart.'">'.$row->name.'</option>';
            } 
            echo $output; 
    }
    // อำเภอ
    function fetch_amphur(Request $request)
    { 
            $id          = $request->get('select');
            $province    = $request->get('province');
            $result=array();
            $query= DB::connection('mysql10')->table('thaiaddress')
            // ->join('hrd_amphur','hrd_province.ID','=','hrd_amphur.PROVINCE_ID')
            // ->select('hrd_amphur.AMPHUR_NAME','hrd_amphur.ID')
            ->where('chwpart',$province)
            ->where('amppart',$id)
            ->where('codetype','=','3')
            ->get();
            $output='<option value="">--Choose--</option> ';
            
            foreach ($query as $row){

                    $output.= '<option value="'.$row->tmbpart.'">'.$row->name.'</option>';
            } 
            echo $output; 
    }

    function fetch_tumbon(Request $request)
    { 
            $id          = $request->get('select');
            $amphur    = $request->get('amphur');
            $province    = $request->get('province');
            $result=array();
            // $query= DB::connection('mysql10')->table('hospcode') 
            // ->where('chwpart',$province)
            // ->where('amppart',$amphur)
            // ->where('tmbpart',$id)
            // // ->where('codetype','=','3')
            // ->groupBy('po_code');
            // $output='<input value=""></>';

            $query = DB::connection('mysql10')->select('SELECT chwpart,amppart,tmbpart,po_code FROM hospcode WHERE chwpart ="'.$province.'" AND amppart ="'.$amphur.'" AND tmbpart ="'.$id.'" AND po_code <> "-" GROUP BY po_code');
            // $output=' ';
            $output='<option value="">--Choose--</option> ';
            foreach ($query as $row){
                $output.= '<option value="'.$row->po_code.'">'.$row->po_code.'</option>';
                    // $output.= '<input value="'.$row->pocode.'" class="form-control" >'.$row->pocode.'</>';
            } 
            echo $output; 
    }
    // <input type="text" class="form-control form-control-sm pocode" id="po_code" name="po_code" >

    // public function authencode_visit(Request $request)
    // {
    //     $ip = $request->ip();  

    //     $terminals = Http::get('http://'.$ip.':8189/api/smartcard/terminals')->collect();        
    //     $cardcidonly = Http::get('http://'.$ip.':8189/api/smartcard/read-card-only')->collect(); 
    //     $cardcid = Http::get('http://'.$ip.':8189/api/smartcard/read')->collect(); 
    //     $output = Arr::sort($terminals);
    //     $outputcard = Arr::sort($cardcid);
    //     $outputcardonly = Arr::sort($cardcidonly); 

    //             $collection = Http::get('http://'.$ip.':8189/api/smartcard/read?readImageFlag=true')->collect();
    //             $patient =  DB::connection('mysql10')->select('select cid,hometel from patient limit 10'); 

    //             $output2 = Arr::sort($collection);
    //             // $output3 = Arr::sort($cardcidonly);
    //             // dd($output2['hospMain']['hcode']);
    //             $hcode = $output2['hospMain']['hcode'];
    //             // dd($hcode);
    //             $year = substr(date("Y"),2) +43;
    //             $mounts = date('m');
    //             $day = date('d');
    //             $time = date("His");  
    //             $vn = $year.''.$mounts.''.$day.''.$time;

    //             $date = date('Y-m-d');
    //             // dd($vn);OK
    //             $getvn_stat =  DB::connection('mysql10')->select('select * from vn_stat limit 2');
    //             $get_ovst =  DB::connection('mysql10')->select('select * from ovst limit 2');
    //             $get_opdscreen =  DB::connection('mysql10')->select('select * from opdscreen limit 2');
    //             $get_ovst_seq =  DB::connection('mysql10')->select('select * from ovst_seq limit 2');        
    //             $get_spclty =  DB::connection('mysql10')->select('select * from spclty');
    //             ///// เจน  hos_guid  จาก Hosxp
    //             $data_key = DB::connection('mysql10')->select('SELECT uuid() as keygen');  
    //             $output4 = Arr::sort($data_key); 

    //             foreach ($output4 as $key => $value) { 
    //                 $hos_guid = $value->keygen; 
    //             }    
    //             // dd($hos_guid);OK    
    //             $data_patient_ = DB::connection('mysql10')->select(' 
    //                     SELECT p.hn
    //                     ,pe.pttype_expire_date as expiredate
    //                     ,pe.pttype_hospmain as hospmain
    //                     ,pe.pttype_hospsub as hospsub 
    //                     ,p.pttype
    //                     ,pe.pttype_no as pttypeno
    //                     ,pe.pttype_begin_date as begindate,pe.cid
    //                     FROM hos.patient p 
    //                     LEFT OUTER JOIN hos.person pe ON pe.patient_hn = p.hn 
    //                     WHERE p.cid = "'.$collection['pid'].'"
    //             ');
    //             foreach ($data_patient_ as $key => $value) {
    //                 $pids = $value->cid;
    //             }
    //             $token_data = DB::connection('mysql10')->select('SELECT * FROM nhso_token ORDER BY update_datetime desc limit 1');
    //             foreach ($token_data as $key => $value) { 
    //                 $cid_    = $value->cid;
    //                 $token_  = $value->token;
    //             }
    //             $client = new SoapClient("http://ucws.nhso.go.th/ucwstokenp1/UCWSTokenP1?wsdl",
    //                 array("uri" => 'http://ucws.nhso.go.th/ucwstokenp1/UCWSTokenP1?xsd=1', "trace"=> 1,"exceptions"=> 0,"cache_wsdl"=> 0)
    //                 );
    //                 $params = array(
    //                     'sequence' => array(
    //                         "user_person_id" => "$cid_",
    //                         "smctoken"       => "$token_", 
    //                         "person_id"      => "$pids"
    //                 ) 
    //             ); 
    //             $contents = $client->__soapCall('searchCurrentByPID',$params);               
    //             foreach ($contents as $v) {
    //                 @$status           = $v->status ;
    //                 @$maininscl        = $v->maininscl;
    //                 @$startdate        = $v->startdate;
    //                 @$hmain            = $v->hmain;
    //                 @$subinscl         = $v->subinscl ;
    //                 @$person_id_nhso   = $v->person_id;        
    //                 @$hmain_op         = $v->hmain_op;  //"10978"
    //                 @$hmain_op_name    = $v->hmain_op_name;  //"รพ.ภูเขียวเฉลิมพระเกียรติ"
    //                 @$hsub             = $v->hsub;    //"04047"
    //                 @$hsub_name        = $v->hsub_name;   //"รพ.สต.แดงสว่าง"
    //                 @$subinscl_name    = $v->subinscl_name ; //"ช่วงอายุ 12-59 ปี"
    //             }

    //             Vn_insert::insert([
    //                 'vn'         => $vn
    //             ]);
    //             // Pttypehistory::insert([ 
    //             //     'hn'                => $value->hn,
    //             //     'expiredate'        => $value->expiredate,
    //             //     'hospmain'          => $value->hospmain,
    //             //     'hospsub'           => $value->hospsub,
    //             //     'pttype'            => $value->pttype,
    //             //     'pttypeno'          => $value->pttypeno,
    //             //     'begindate'         => $value->begindate, 
    //             //     'hos_guid'          => $hos_guid 
    //             // ]);
    //             $max_q = Ovst::max('oqueue');
    //             Ovst::insert([ 
    //                 'hos_guid'          => $hos_guid ,
    //                 'vn'                => $vn,
    //                 'hn'                => $value->hn,
    //                 'vstdate'           => $date,
    //                 'vsttime'           => $time,
    //                 'hospmain'          => $value->hospmain, 
    //                 'hospsub'           => $value->hospsub,
    //                 'oqueue'            => $max_q,
    //                 'ovstist'           => $value->pttypeno,
    //                 'ovstost'           => $value->begindate, 
    //                 'pttype'            => $value->begindate, 
    //                 'pttypeno'          => $value->begindate, 
    //                 'spclty'            => $value->begindate, 
    //                 'hcode'             => $value->begindate, 
    //                 'last_dep'          => $value->begindate, 
    //                 'pt_subtype'        => $value->begindate, 
    //                 'main_dep_queue'    => $value->begindate, 
    //                 'visit_type'        => $value->begindate, 
    //                 'node_id'           => $value->begindate, 
    //                 'waiting'           => $value->begindate, 
    //                 'has_insurance'     => $value->begindate, 
    //                 'staff'             => $value->begindate, 
    //                 'pt_priority'       => $value->begindate, 
    //                 'ovst_key'          => $value->begindate,                     
    //             ]);

    //             dd($contents);

    //             return view('authen.authencode_visit',[  
    //                 'smartcard'          =>  $smartcard, 
    //                 'cardcid'            =>  $cardcid,
    //                 'smartcardcon'       =>  $smartcardcon,
    //                 'output'             =>  $output, 


    //             ]);
    // }          





    // public function authen_cid(Request $req)
    // { 
    //    $collection = Http::get('http://localhost:8189/api/smartcard/read')->collect();
    //    $status            = '';
    //    $birthday          = '';
    //    $fname             = '';
    //    $lname             = '';
    //    $hmain             = '';
    //    $hmain_name        = '';
    //    $hsub              = '';
    //    $hsub_name         = '';
    //    $maininscl         = '';
    //    $maininscl_main    = '';
    //    $maininscl_name    = '';
    //    $expdate           = '';

    //     // str_pad(string , length , pad_string , pad_type)
    //     // string คือ สตริงที่ต้องการเติมคำ
    //     // length คือ ความยาวของสตริงที่ต้องการ
    //     // pad_string คือ ตัวอักษรหรือคำที่ต้องการเติม
    //     // pad_type คือ รูปแบบการเติม ค่าที่เป็นไปได้คือ
    //     // STR_PAD_BOTH - เติมทั้งสองข้าง ถ้าไม่ลงตัวข้างขวาจะถูกเติมมากกว่า
    //     // STR_PAD_LEFT - เติมด้านซ้าย
    //     // STR_PAD_RIGHT - เติมด้านขวา (default)

    //     //    $contents = File::get('D:\Authen\nhso_token.txt');
    //     $ip = $req->ip();
    //     // $path = ($ip.'/PKAuthen'.'/public/'.'Authen/nhso_token.txt');
    //     $contents = file('D:\UCAuthenticationMX\nhso_token.txt', FILE_SKIP_EMPTY_LINES|FILE_IGNORE_NEW_LINES);  
    //     // $contents = file($path, FILE_SKIP_EMPTY_LINES|FILE_IGNORE_NEW_LINES);  

    //     foreach($contents as $line) { 
    //         // echo str_pad($count, 2, 0, STR_PAD_LEFT).". ".$line;
    //         // echo $line;
    //     }

    //     // $mani = str_pad($line, 5); 
    //     // echo $mani . "#" . "\n";

    //     // $a="3451000002897#";
    //     // $count_a = strlen($a);
    //     // echo $count_a;
    //     // echo str_pad($count_a, 15, 0, STR_PAD_LEFT);
    //     // echo "<br>";
    //     $chars = preg_split('//', $line, -1, PREG_SPLIT_NO_EMPTY);
    //     // print_r($chars);
    //     // echo "<br>";
    //     // $data['output'] = Arr::sort($chars,2);
    //     $output = Arr::sort($chars,2);
    //     // dd($output,$chars['17']);
    //     // dd($data['output']); 
    //     $data['data1'] = $chars['1']; $data['data2'] = $chars['2']; $data['data3'] = $chars['3']; $data['data4'] = $chars['4'];
    //     $data['data5'] = $chars['5']; $data['data6'] = $chars['6']; $data['data7'] = $chars['7']; $data['data8'] = $chars['8'];
    //     $data['data9'] = $chars['9']; $data['data10'] = $chars['10']; $data['data11'] = $chars['11']; $data['data12'] = $chars['12'];
    //     $data['data13'] = $chars['13']; $data['data14'] = $chars['14']; $data['data15'] = $chars['15']; 
    //     // $data['data16'] = $chars['16'];

    //     $data['datacid'] = $data['data3'].''.$data['data4'].''.$data['data5'].''.$data['data6'].''.$data['data7'].''.$data['data8'].''.$data['data9'].''.$data['data10'].''.$data['data11']
    //     .''.$data['data12'].''.$data['data13'].''.$data['data14'].''.$data['data15'];

    //     // dd($data['datacid']);

    //     $data['data17'] = $chars['17'];
    //     $data['data18'] = $chars['18'];
    //     $data['data19'] = $chars['19'];
    //     $data['data20'] = $chars['20'];
    //     $data['data21'] = $chars['21'];
    //     $data['data22'] = $chars['22'];
    //     $data['data23'] = $chars['23'];
    //     $data['data24'] = $chars['24'];
    //     $data['data25'] = $chars['25'];
    //     $data['data26'] = $chars['26'];
    //     $data['data27'] = $chars['27'];
    //     $data['data28'] = $chars['28'];
    //     $data['data29'] = $chars['29'];
    //     $data['data30'] = $chars['30'];
    //     $data['data31']= $chars['31'];
    //     $data['data32'] = $chars['32'];

    //     $data['datatotal'] = $chars['17'].''.$data['data18'].''.$data['data19'].''.$data['data20'].''.$data['data21'].''.$data['data22'].''.$data['data23'].''.$data['data24'].''.$data['data25'].''.$data['data26'].''.$data['data27']
    //     .''.$data['data28'].''.$data['data29'].''.$data['data30'].''.$data['data31'].''.$data['data32'];

    //     // dd($data['datatotal']);
    //     // echo "function:".str_pad($line,14,".",STR_PAD_RIGHT);  
    //     // echo "<br>";

    //     // if(strlen($line) > 15){
    //     //     $line = mb_substr($line, 0, 15).'...';
    //     //     }
    //     //     echo $line;
    //     //     echo "<br>";


    //     // for($i = 1;$i <$count_a;$i++)
    //     // {
    //     //     echo $line[$i];
    //     //     echo "<br>";
    //     // }
    //     // $ar = array();
    //     // for($i = 0;$i < strlen($line); $i++)
    //     // {
    //     //     echo array_push($ar, substr($line,$i,1));
    //     // }
    //     // echo str_pad($mani,15,".");  

    //     // echo str_pad("line", 11, "pp", STR_PAD_BOTH )."\n";
    //     // echo str_pad($line, 20, "-=", STR_PAD_LEFT)."\n";
    //     // echo str_pad($line,  15, "*"). "\n"; 
    //     // echo str_pad($line,5,"$",STR_PAD_LEFT);
    //     // $myFile = new SplFileObject('D:\Authen\nhso_token.txt');
    //     // while (!$myFile->eof()) {
    //     //     echo $myFile->fgets() . PHP_EOL;
    //     // }

    //     // $file_handle = fopen('D:\Authen\nhso_token.txt', 'r'); 
    //     // function get_all_lines($file_handle) { 
    //     //     while (!feof($file_handle)) {
    //     //         yield fgets($file_handle);
    //     //     }
    //     // }        
    //     // $count = 0;        
    //     // foreach (get_all_lines($file_handle) as $line) {
    //     //     $count += 1;
    //     //     echo $count.". ".$line;
    //     // }        
    //     // fclose($file_handle);

    //     // dd($line);
    //    return view('authen_cid',$data,
    //     [
    //         $status            = $status,
    //         $birthday          =  $birthday ,
    //         $fname             = $fname,
    //         $lname             = $lname,
    //         $hmain             = $hmain,
    //         $hmain_name        =  $hmain_name,
    //         $hsub              = $hsub,
    //         $hsub_name         = $hsub_name,
    //         $maininscl         = $maininscl,
    //         $maininscl_main    = $maininscl_main,
    //         $maininscl_name    =  $maininscl_name,
    //         $expdate           = $expdate,
    //     ]
    // );  
    // }



}
