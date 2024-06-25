<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Visit_pttype_authen;
use App\Models\Visit_pttype_import;
use Illuminate\Support\Facades\DB;
use Http;
use SoapClient;
use File;
use SplFileObject;
use Arr;
use Storage;
use GuzzleHttp\Client;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportVisit_pttype_import;
// use Excel;

class AuthenController extends Controller
{
    public function authen_dashboard(Request $request)
    {
        $date = date('Y-m-d');
        
        $data_dep = DB::connection('mysql3')->select(' 
                SELECT o.main_dep,sk.department,COUNT(o.vn) as VN   
                FROM ovst o 
                LEFT JOIN visit_pttype v on v.vn=o.vn
                LEFT JOIN vn_stat vs on vs.vn=o.vn
                LEFT JOIN visit_pttype_authen vpa on vpa.visit_pttype_authen_vn=o.vn
                LEFT OUTER JOIN kskdepartment sk on sk.depcode=o.main_dep
                WHERE o.vstdate = CURDATE()  
                
                GROUP BY o.main_dep
        ');
        
        foreach ($data_dep as $key => $value2) {
            $maindep = $value2->main_dep;
        }
        $data_ = DB::connection('mysql')->select(' 
                SELECT *   
                FROM dashboard_authen_day 
                WHERE vstdate = CURDATE()   
        ');
         foreach ($data_ as $key => $value) {
            $vn_ = $value->vn;
            $Kios_ = $value->Kios;
            $Staff_ = $value->Staff;
            $Success_ = $value->Total_Success;
           
            if ($vn_ == '') {
                $vnnew_ = '0';         
            } else {
                $vnnew_ = $vn_;
            }
    
            if ($Kios_ == '') {
                $Kiosnew_ = '0';         
            } else {
                $Kiosnew_ = $Kios_;
            }
    
            if ($Staff_ == '') {
                $Staffnew_ = '0';         
            } else {
                $Staffnew_ = $Staff_;
            }
    
            if ($Success_ == '') {
                $Successnew_ = '0';         
            } else {
                $Successnew_ = $Success_;
            }
        } 
        $data_department = DB::connection('mysql')->select(' 
                SELECT *   
                FROM dashboard_department_authen 
                WHERE vstdate = CURDATE()  
                ORDER BY main_dep DESC 
        ');
        $data_staff = DB::connection('mysql')->select(' 
                SELECT *
                FROM dashboard_authenstaff_day 
                WHERE vstdate = CURDATE() 
                ORDER BY length(vn) DESC, vn DESC 
        ');
 
        return view('authen_dashboard',[ 
            'vn'               => $vnnew_,
            'Kios'             => $Kiosnew_,
            'Staff'            => $Staff_,
            'Success'          => $Successnew_,
            'data_dep'         => $data_dep,
            'data_department'  => $data_department,
            'data_staff'       => $data_staff,
        ] );
    }
    
   
    public function authen_detail(Request $request,$dep)
    {
        $datadetail = DB::connection('mysql3')->select(' 
                SELECT                
                o.main_dep,o.vn as VN,o.vstdate,o.vsttime
                ,p.cid,o.hn,vp.patientName,vp.claimCode,vp.tel,o.staff,concat(p.pname,p.fname," ",p.lname) as fullname 
                 FROM ovst o 
                 LEFT OUTER JOIN kskdepartment sk on sk.depcode=o.main_dep
                 LEFT OUTER JOIN patient p on p.hn=o.hn
                 LEFT OUTER JOIN visit_pttype_authen_report vp ON vp.personalId = p.cid and vp.claimDate = o.vstdate
                 LEFT OUTER JOIN opduser op on op.loginname = o.staff
                WHERE o.vstdate = CURDATE() 
                and o.main_dep = "'.$dep.'"
                GROUP BY o.vn                
        ');               
        $output ='
        <table style="width: 100%;" class="table table-hover table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ลำดับ</th>
                            <th>เวลารับบริการ</th>
                            <th>VN</th>
                            <th>CID</th>
                            <th>HN</th> 
                            <th>Fullname</th>
                            <th>AuthenCode</th>
                            <th>Mobile</th> 
                            <th>Staff</th>                        
                        </tr>
                    </thead>
                    <tbody>';
                    $count = 1;
                    foreach ($datadetail as $key => $value) {
                        $output.='  <tr height="15">
                        <td class="text-font" align="center">'.$count.'</td>
                        <td class="text-font text-pedding">'.$value->vsttime.'</td>
                        <td class="text-font text-pedding">'.$value->VN.'</td>
                        <td class="text-font" align="center" >'.$value->cid.'</td>
                        <td class="text-font" align="center" >'.$value->hn.'</td>
                        <td class="text-font text-pedding">'.$value->fullname.'</td>
                        ';
                        if ($value->claimCode > 0 ) {
                            $output.='<td class="text-font text-pedding"><label for="" style="color:black">'.$value->claimCode.'</label></td>';
                        } else {
                            $output.='<td class="text-font text-pedding" style="color:white;background-color: rgb(255, 58, 58)"><label for="" >'.$value->claimCode.'</label></td>';
                        }     
                                                
                        if ($value->tel > 0 ) {
                            $output.='<td class="text-font" align="center" ><label for="" style="color:black">'.$value->tel.'</label></td>';
                        } else {
                            $output.='<td class="text-font" align="center" style="color:white;background-color: rgb(255, 58, 58)" ><label for="" >'.$value->tel.'</label></td>';
                        }  

                        $output.='                        
                        </td>
                        <td class="text-font text-pedding">'.$value->staff.'</td>
                        </tr>';
                        $count++;
                    }
                                        
                    $output.='</tbody>            
                </table>        
        ';
        echo $output;
 
    }

    public function authen_user(Request $request,$iduser)
    {
        $datadetail = DB::connection('mysql3')->select(' 
                SELECT                
                o.main_dep,o.vn as VN,o.vstdate,o.vsttime
                ,p.cid,o.hn,vp.patientName,vp.claimCode,vp.tel,o.staff,concat(p.pname,p.fname," ",p.lname) as fullname 
                 FROM ovst o 
                 LEFT OUTER JOIN kskdepartment sk on sk.depcode=o.main_dep
                 LEFT OUTER JOIN patient p on p.hn=o.hn
                 LEFT OUTER JOIN visit_pttype_authen_report vp ON vp.personalId = p.cid and vp.claimDate = o.vstdate
                 LEFT OUTER JOIN opduser op on op.loginname = o.staff
                WHERE o.vstdate = CURDATE() 
                and o.staff = "'.$iduser.'"
                GROUP BY o.vn                
        ');               
        $output ='
        <table style="width: 100%;" class="table table-hover table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ลำดับ</th>
                            <th>เวลารับบริการ</th>
                            <th>VN</th>
                            <th>CID</th>
                            <th>HN</th> 
                            <th>Fullname</th>
                            <th>AuthenCode</th>
                            <th>Mobile</th> 
                            <th>Staff</th>                        
                        </tr>
                    </thead>
                    <tbody>';
                    $count = 1;
                    foreach ($datadetail as $key => $value) {
                        $output.='  <tr height="15">
                        <td class="text-font" align="center">'.$count.'</td>
                        <td class="text-font text-pedding">'.$value->vsttime.'</td>
                        <td class="text-font text-pedding">'.$value->VN.'</td>
                        <td class="text-font" align="center" >'.$value->cid.'</td>
                        <td class="text-font" align="center" >'.$value->hn.'</td>
                        <td class="text-font text-pedding">'.$value->fullname.'</td>
                        ';
                        if ($value->claimCode > 0 ) {
                            $output.='<td class="text-font text-pedding"><label for="" style="color:black">'.$value->claimCode.'</label></td>';
                        } else {
                            $output.='<td class="text-font text-pedding" style="color:white;background-color: rgb(255, 58, 58)"><label for="" >'.$value->claimCode.'</label></td>';
                        }     
                                                
                        if ($value->tel > 0 ) {
                            $output.='<td class="text-font" align="center" ><label for="" style="color:black">'.$value->tel.'</label></td>';
                        } else {
                            $output.='<td class="text-font" align="center" style="color:white;background-color: rgb(255, 58, 58)" ><label for="" >'.$value->tel.'</label></td>';
                        }  

                        $output.='                        
                        </td>
                        <td class="text-font text-pedding">'.$value->staff.'</td>
                        </tr>';
                        $count++;
                    }
                                        
                    $output.='</tbody>            
                </table>        
        ';
        echo $output;
 
    }

    public function import(Request $request)
    {
        Excel::import(new ImportVisit_pttype_import, $request->file('file')->store('files'));
        
        return response()->json([
            'status'    => '200',
            // 'borrow'    =>  $borrow
        ]); 
    }
    public function authen_check(Request $request)
    {
        // return $request->all();
        if($request->cid != '' || $request->cid != null){
        
        $cid        = $request->cid;
        $vn         = $request->vn;
        $hn         = $request->hn;
        $auth_code  = $request->auth_code;
        $fullname   = $request->fullname;
        $department = $request->department;
        $staff      = $request->staff;
        $name       = $request->name;

            $number =count($cid);
            $i = 0;
            for($i = 0; $i< $number; $i++)
            { 
                // $data = DB::table('visit_pttype_authen')->get();
                $dataauthen = Visit_pttype_authen::where('visit_pttype_authen_cid','=',$cid[$i])->first();
 
            }
 
        }

        return  $cid;
    }
    
    public function checkauthen_auto(Request $request)
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
                    } else {
                        # code...
                    }
                            
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
            
     
         return view('import_authen_auto',[
            'response'  => $response,
            'result'  => $result,
            'data_spsch'  => $data_spsch
        ]);
    }
    // public function authen_realtime(Request $request)
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
    //             WHERE v.vstdate = CURDATE()
    //             AND (vp.claim_code IS NULL OR vp.claim_code="")  
    //             ORDER BY z_time 
    //     ');
    //     foreach ($datashow as $key => $value) {
    //         $cid = $value->VN;
    //     }
            
    //     return response()->json([
    //         'status'     => '200',
    //     ]);
        
    // }
    public function checkauthen_auto0000(Request $request)
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
                WHERE v.vstdate = "2022-12-22"
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
            echo "<BR>";
            
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
            } else {
                # code...
            }
                
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
                ORDER BY o.vsttime desc limit 10
        ');

     return view('authen.checkauthen_auto',[
        'response'  => $response,
        'result'  => $result,
        'data_spsch'  => $data_spsch
     ]);
    //  return response()->json([
    //     'status'     => '200',
    // ]);
    
}


}