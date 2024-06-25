<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\DB;
use Http;
use SoapClient;
use File;
use SplFileObject;
use Arr;
use Storage;
use App\Models\Visit_pttype_authen;

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
        $datashow = DB::connection('mysql3')->select('             
                        SELECT o.vn,o.hn,o.vstdate,o.vsttime,p.cid,o.main_dep
                        FROM ovst o
                        LEFT OUTER JOIN visit_pttype v on v.vn=o.vn
                        LEFT OUTER JOIN ovst_queue_server os on os.vn = o.vn
                        LEFT OUTER JOIN ovst_queue_server_authen oq on oq.vn = os.vn
                        LEFT OUTER JOIN kskdepartment sk on sk.depcode=o.main_dep
                        LEFT OUTER JOIN patient p on p.hn=o.hn
                        LEFT OUTER JOIN opduser op on op.loginname = o.staff
                        LEFT OUTER JOIN visit_pttype_authen vp on vp.visit_pttype_authen_vn=o.vn
                        WHERE o.vstdate = CURDATE()
                        ORDER BY o.vsttime limit 50        
                    ');
                foreach ($datashow as $key => $value) {
                        $cid = $value->cid;
                        $vn = $value->vn;
                        $hn = $value->hn;
                        $main_dep = $value->main_dep;
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
                        // dd($result);
                        @$hcode = $result['hcode'];

                        @$ex_claimDateTime = explode("T",$result['claimDateTime']);
                        // dd(@$ex_claimDateTime[0]);
                        
                        $claimDate=$ex_claimDateTime[0];
                        // dd($claimDate);     
                        @$claimCode = $result['claimCode'];
                        // $checkdate = $result['checkDate'];
                        // dd($checkdate);
            
                        $ex_checkDate = explode("T",$result['checkDate']);
                        $check_getDate = $ex_checkDate[0];
                        $checkTime = $ex_checkDate[1];
            
         
                        $checkvn = Visit_pttype_authen::where('visit_pttype_authen_vn','=',$vn)->count();
                        // where('visit_pttype_authen_cid','=',$cid)
                        // where('visit_pttype_authen_vn','=',$vn)
                        // dd($checkvn);
            
                        if ($checkvn == '0') {
                            $data_add = Visit_pttype_authen::create([
                                'visit_pttype_authen_cid'       => $cid,
                                'visit_pttype_authen_vn'        => $vn,
                                'visit_pttype_authen_hn'        => $hn,
                                'visit_pttype_authen_auth_code' => @$claimCode,
                                'checkTime'                     => $checkTime,
                                'claimDate'                     => $check_getDate,
                                'main_dep'                      => $main_dep
                            ]);
                            $data_add->save();
                        } else {
                            Visit_pttype_authen::where('visit_pttype_authen_vn', $vn) 
                            ->update([
                                'visit_pttype_authen_cid'            => $cid,
                                'visit_pttype_authen_hn'             => $hn,
                                'visit_pttype_authen_auth_code'      => @$claimCode,
                                // 'checkTime'                          => $checkTime,
                                'claimDate'                          => $check_getDate,
                                'main_dep'                           => $main_dep
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

                @$hcode = $result['hcode'];

                @$ex_claimDateTime = explode("T",$result['claimDateTime']);
                $claimDate=$ex_claimDateTime[0];
                          
                @$claimCode = $result['claimCode'];
                $ex_checkDate = explode("T",$result['checkDate']);
                $checkTime=$ex_checkDate[1];

                // dd($claimDate);
                $checkvn = Visit_pttype_authen::where('visit_pttype_authen_cid','=',$cid)->where('visit_pttype_authen_vn','=',$vn)->count();
                // dd($checkvn);
                if ($checkvn == 0) {
                    $data_add = Visit_pttype_authen::create([
                        'visit_pttype_authen_cid'       => $cid,
                        'visit_pttype_authen_vn'        => $vn,
                        'visit_pttype_authen_hn'        => $hn,
                        'visit_pttype_authen_auth_code' => @$claimCode,
                        'checkTime'                     => $checkTime,
                        'claimDate'                     => $claimDate
                    ]);
                    $data_add->save();

                    return response()->json([
                        'data_add' => $data_add 
                    ]);

                } else {
                    
                }
                        
                }
        
            
        
    }

    public function authen_getbar(Request $request)
    {
        $date = date("Y-m-d");
        $newDate = date('Y-m-d', strtotime($date . ' -1 months')); //ย้อนหลัง 1 เดือน  
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์  
        $newday = date('Y-m-d', strtotime($date . ' -1 day')); //ย้อนหลัง 1 สัปดาห์  

        $type_chart5 = DB::connection('mysql3')->table('pttype')->select('pttype', 'name', 'pcode')->get(); 
        $visit_today = DB::connection('mysql3')->select(' 
            SELECT o.vn,o.hn,o.vstdate,o.vsttime,p.cid,concat(p.pname,p.fname," ",p.lname) as fullname,oq.claim_code,oq.mobile,
                    oq.claim_type,oq.authen_type,os.is_appoint,o.staff,op.name as fullname_staff,os.opd_dep,sk.department
                    FROM ovst o
                    LEFT OUTER JOIN ovst_queue_server os on os.vn = o.vn
                    LEFT OUTER JOIN ovst_queue_server_authen oq on oq.vn = os.vn
                    LEFT OUTER JOIN kskdepartment sk on sk.depcode=o.main_dep
                    LEFT OUTER JOIN patient p on p.hn=o.hn
                    LEFT OUTER JOIN opduser op on op.loginname = o.staff
                    WHERE o.vstdate = CURDATE()
                    ORDER BY o.vsttime 
        ');
        foreach($visit_today as $item_)
        {
            $visitcount = DB::connection('mysql3')->select('
                    SELECT COUNT(o.vn) as VN FROM ovst o
                    LEFT OUTER JOIN kskdepartment sk on sk.depcode=o.main_dep
                    LEFT OUTER JOIN patient p on p.hn=o.hn
                    LEFT OUTER JOIN opduser op on op.loginname = o.staff
                    WHERE o.vstdate = CURDATE()
                    ORDER BY o.vsttime
            ');
        }

        foreach ($type_chart5 as $item) {

            $data_count = DB::connection('mysql3')->table('ovst')->where('pttype', '=', $item->pttype)->WhereBetween('vstdate', [$newDate, $date])->count(); //ย้อนหลัง 1 เดือน  
            $data_count_week = DB::connection('mysql3')->table('ovst')->where('pttype', '=', $item->pttype)->WhereBetween('vstdate', [$newweek, $date])->count();  //ย้อนหลัง 1 สัปดาห์

            if ($data_count > 0) {
                $dataset[] = [
                    'label' => $item->name,
                    'count' => $data_count
                ];
            }

            if ($data_count_week > 0) {
                $dataset_2[] = [
                    'label_week' => $item->name,
                    'count_week' => $data_count_week
                ];
            }
        }
 
        $chartData_dataset = $dataset;
        $chartData_dataset_week = $dataset_2; 
        return response()->json([
            'status'             => '200', 
            'chartData_dataset_week'    => $chartData_dataset_week,
            'chartData_dataset'  => $chartData_dataset
        ]);
    }



}