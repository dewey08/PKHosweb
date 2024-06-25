<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Api_neweclaim;
use App\Models\Patient;
use App\Models\Check_sit_auto;
use App\Models\Visit_pttype;
use App\Models\Fdh_mini_dataset;



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
use PHPExcel;
use PHPExcel_IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\IOFactory;
use ZipArchive;
use Illuminate\Support\Facades\Redirect;
use PhpParser\Node\Stmt\If_; 

use Auth;
 
use Illuminate\Filesystem\Filesystem;

class ApiController extends Controller
{ 
    public function patient_readonly(Request $request)
    { 
        $year = substr(date("Y"),2) +43;
        $mounts = date('m');
        $day = date('d');
        $time = date("His");
        $ip = $request->ip();
        // $detallot = 'L'.substr(date("Ymd"),2).'-'.date("His");
        $hcode = '10978';
        $vn = $year.''.$mounts.''.$day.''.$time;
        $getpatient =  DB::connection('mysql3')->select('select cid,hometel from patient limit 2');
        $getvn_stat =  DB::connection('mysql3')->select('select hos_guid,vn,hn,vstdate,pttype,pttypeno from vn_stat limit 2');
        $get_ovst =  DB::connection('mysql3')->select('select hos_guid,vn,hn,vstdate,pttype,pttypeno from ovst limit 2');
        $get_opdscreen =  DB::connection('mysql3')->select('select hos_guid,vn,hn,vstdate from opdscreen limit 2');
        $get_ovst_seq =  DB::connection('mysql3')->select('select vn,seq_id,last_opdcard_depcode from ovst_seq limit 2');

        $getovst_key = Http::get('https://cloud4.hosxp.net/api/ovst_key?Action=get_ovst_key&hospcode="'.$hcode.'"&vn="'.$vn.'"&computer_name=abcde&app_name=AppName&fbclid=IwAR2SvX7NJIiW_cX2JYaTkfAduFqZAi1gVV7ftiffWPsi4M97pVbgmRBjgY8')->collect();
       
        // เจน  hos_guid  จาก Hosxp
        $data_key = DB::connection('mysql3')->select('SELECT uuid() as keygen'); 
        // $output = Arr::sort($data_key); 
        // $output2 = Arr::query($data_key);       
        // $output3 = Arr::sort($data_key['keygen']);
        $output4 = Arr::sort($data_key); 

        foreach ($output4 as $key => $value) { 
            $output_show = $value->keygen; 
        }
        // dd($output_show);
       
        return response([
            // $getpatient,
            $getvn_stat
            ,$get_ovst
            ,$get_opdscreen
            ,$vn,$get_ovst_seq,
            $getovst_key,$output_show
        ]);
    }
    public function ovst_key(Request $request)
    {
        $data['patient'] =  DB::connection('mysql')->select('select cid,hometel from patient limit 10');

        $year = substr(date("Y"),2) +43;
        $mounts = date('m');
        $day = date('d');
        $time = date("His"); 
        $hcode = '10978';
        $vn = $year.''.$mounts.''.$day.''.$time;
        $ip = $request->ip();

        $collection = Http::get('http://'.$ip.':8189/api/smartcard/read')->collect();
        // $collection = Http::get('http://localhost:8189/api/smartcard/read')->collect();
        $datapatient = DB::table('patient')->where('cid','=',$collection['pid'])->first();
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

          $getovst_key = Http::get('https://cloud4.hosxp.net/api/ovst_key?Action=get_ovst_key&hospcode="'.$hcode.'"&vn="'.$vn.'"&computer_name=abcde&app_name=AppName&fbclid=IwAR2SvX7NJIiW_cX2JYaTkfAduFqZAi1gVV7ftiffWPsi4M97pVbgmRBjgY8')->collect();    
        
          $outputcard = Arr::sort($getovst_key);
          // $outputcard = Arr::sort($getovst_key['ovst_key']);
        //    foreach ($outputcard as $values) { 
              // $showovst_key = $values['result']; 
        //   }
        
          return response([
            'getovst_key'  => $getovst_key['result']['ovst_key'],
              $outputcard
             ]);
    }
    public function home_rpst(Request $request)
    {
        $client = new Client();
        $headers = [
          'Cookie' => 'SESSION=MDFlYmFiOTktYTMzMi00OTNjLWI3NTItYTNlOTNkNmVjZmZm;; SESSION=ZjRmZGY0MzYtZDM4MC00ZTdiLTg4NTktNWFmYzYyYTJjOWEz; TS01bfdc7f=013bd252cb5e0993bc9f743b1fe1d2514f9c150318795ffc6305061036c85d1758ad7f12b372d8689fe16d42e6dd4d4e2fc9e7c7cbfb56b0e4620f72139484b6dc43da09c1; TS01e88bc2=013bd252cb9511ad9731c8c3ff667fc273280abef217711456cad3d247a329de5329f9421f27164ea9d20eea07a2dd8e96cb32e0b4'
        ];
        $home_rpst = Http::get('https://authenservice.nhso.go.th/authencode/api/erm-reg-claim?claimStatus=E&claimDateFrom=2022-12-18&page=0&size=10&sort=claimDate,desc', $headers)->collect();
        return response([
            $home_rpst 
        ]);
    }
    public function pimc(Request $request)
    {
        $date = date("Y-m-d");
        $dayback = date('Y-m-d', strtotime($date . ' -1 day')); //ย้อนหลัง 1 วัน  
        // $dayback = date('Y-m-d', strtotime($date . ' -1 year')); 
        // dd($date);
        $data_api = DB::connection('mysql3')->select('   
                SELECT nr.*,EXTRACT(hour FROM nr.ortime - nr.admit_time) AS waiting_time
                FROM (SELECT i.an,i.hn,concat(p.pname,p.fname," ",p.lname)as fullname, p.pname,p.fname,p.lname,p.cid
                ,p.birthday,p.hometel,p.addrpart,p.moopart, address3.name AS tmbpart,address2.name AS amppart,address1.name AS chwpart
                , concat(p.addrpart,"หมู่ที่",p.moopart," ต. ",address3.name," อ. ",address2.name," จ. ",address1.name) as fulladdress,ptt.name as pttype
                ,d.name as doctor_name,a.pdx,oi.icd9,oi.name,concat(a.regdate," ",i.regtime) AS admit_time, a.admdate,a.income,min(ot.in_datetime) AS ortime
                ,concat(i.dchdate," ",i.dchtime) AS dc_time, 
                CASE WHEN  p.sex="1" then "ชาย" 
                else "หญิง" 
                end as sexname
                ,a.age_y,a.los,i.adjrw
                ,i.ward,ward.name as wardname, " " as id,"Hip" as type, " " as operation,"yes" as find,"ชัยภูมิ" as fr_province
                , "10978" as hospcode, "36" as provincecode
                
                FROM ipt i
                LEFT JOIN operation_list ol on i.an=ol.an 
                LEFT JOIN operation_detail od on ol.operation_id=od.operation_id  
                INNER JOIN operation_item oi on od.operation_item_id=oi.operation_item_id  
                LEFT JOIN operation_team ot on ot.operation_detail_id=od.operation_detail_id  
                LEFT OUTER JOIN operation_anes_physical_status ops on ops.operation_anes_physical_status_id=ol.operation_anes_physical_status_id
                LEFT JOIN operation_position op on op.position_id=ot.position_id  
                LEFT JOIN doctor d on ot.doctor=d.code
                LEFT JOIN patient p on p.hn=ol.hn  
                LEFT JOIN ward on ward.ward = i.ward
                LEFT JOIN pttype ptt on ptt.pttype = i.pttype 
                LEFT JOIN an_stat a on a.an=i.an
                LEFT OUTER JOIN thaiaddress address1 ON address1.chwpart = p.chwpart AND address1.amppart = "00" AND address1.tmbpart = "00" 
                LEFT OUTER JOIN thaiaddress address2 ON address2.chwpart = p.chwpart AND address2.amppart = p.amppart AND address2.tmbpart = "00" 
                LEFT OUTER JOIN thaiaddress address3 ON address3.chwpart = p.chwpart AND address3.amppart = p.amppart AND address3.tmbpart = p.tmbpart 
                WHERE i.dchdate BETWEEN "'.$dayback.'" and "'.$date.'" 
                AND ot.position_id="1" AND a.age_y > 49
                GROUP BY  concat(p.pname,p.fname," ",p.lname),p.pname, p.fname, p.lname,i.hn,a.pdx,oi.icd9,oi.name,i.an,a.income,a.admdate
                ,i.prediag,doctor_name,d.name,a.regdate,admit_time,dc_time,sexname,a.age_y,a.los,i.adjrw,ptt.name
                ,p.cid,address3.name,address2.name,address1.name,p.addrpart,p.moopart,p.birthday,p.hometel,i.ward,ward.name) as nr
                ORDER BY dc_time DESC 
        ');
        // INNER JOIN operation_item oi on od.operation_item_id=oi.operation_item_id and oi.operation_item_id in("1057","1058","1059","973","989","990","991") 
        // and  oi.operation_item_id in("1057","1058","1059","973","989","990","991")
        return response([
            $data_api 
        ]);
    }
    public function adp(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        if ($startdate == '') {
            $adp_api = DB::connection('mysql3')->select('
                    SELECT HN,AN,DATEOPD,TYPE,CODE,sum(QTY) QTY,RATE,SEQ,"" "" a1,"" a2,"" a3,"" a4,"0" a5,"" a6,"0" a7 ,"" a8,"" TMLTCODE
                    ,"" STATUS1,"" BI,"" CLINIC,"" ITEMSRC,"" PROVIDER,"" GLAVIDA,"" GA_WEEK,"" DCIP,"0000-00-00" LMP,SP_ITEM
                    from (SELECT v.hn HN
                    ,if(v.an is null,"",v.an) AN
                    ,DATE_FORMAT(v.rxdate,"%Y%m%d") DATEOPD
                    ,n.nhso_adp_type_id TYPE
                    ,n.nhso_adp_code CODE
                    ,sum(v.QTY) QTY
                    ,round(v.unitprice,2) RATE
                    ,if(v.an is null,v.vn,"") SEQ
                    ,"" a1,"" a2,"" a3,"" a4,"0" a5,"" a6,"0" a7 ,"" a8
                    ,"" TMLTCODE,"" STATUS1,"" BI,"" CLINIC,"" ITEMSRC
                    ,"" PROVIDER,"" GLAVIDA,"" GA_WEEK,"" DCIP,"0000-00-00" LMP
                    ,(SELECT "01" from dtemp_hosucep where an = v.an and icode = v.icode and rxdate = v.rxdate and rxtime = v.rxtime  limit 1) SP_ITEM
                    from opitemrece v
                    inner JOIN nondrugitems n on n.icode = v.icode and n.nhso_adp_code is not null
                    left join ipt i on i.an = v.an
                    AND i.an is not NULL
                
                    WHERE v.vstdate = CURDATE() 
                    AND n.icode <> "XXXXXX"
                    GROUP BY i.vn,n.nhso_adp_code,rate) a
                    GROUP BY an,CODE,rate
                    
                    UNION

                    SELECT HN,AN,DATEOPD,TYPE,CODE,sum(QTY) QTY,RATE,SEQ,"" a1,"" a2,"" a3,"" a4,"0" a5,"" a6,"0" a7 ,"" a8,"" TMLTCODE
                    ,"" STATUS1,"" BI,"" CLINIC,"" ITEMSRC,"" PROVIDER,"" GLAVIDA,"" GA_WEEK,"" DCIP,"0000-00-00" LMP,"" SP_ITEM
                    from
                    (SELECT v.hn HN
                    ,if(v.an is null,"",v.an) AN
                    ,DATE_FORMAT(v.vstdate,"%Y%m%d") DATEOPD
                    ,n.nhso_adp_type_id TYPE
                    ,n.nhso_adp_code CODE
                    ,sum(v.QTY) QTY
                    ,round(v.unitprice,2) RATE
                    ,if(v.an is null,v.vn,"") SEQ,"" a1,"" a2,"" a3,"" a4,"0" a5,"" a6,"0" a7 ,"" a8
                    ,"" TMLTCODE,"" STATUS1,"" BI,"" CLINIC,"" ITEMSRC,"" PROVIDER,"" GLAVIDA,"" GA_WEEK,"" DCIP,"0000-00-00" LMP,"" SP_ITEM
                    from opitemrece v
                    inner JOIN nondrugitems n on n.icode = v.icode and n.nhso_adp_code is not null
                    left join ipt i on i.an = v.an
                    
                    WHERE v.vstdate = CURDATE()  
                    AND n.icode <> "XXXXXX"
                    AND i.an is NULL
                    GROUP BY v.vn,n.nhso_adp_code,rate) b
                    GROUP BY seq,CODE,rate;
            ');
           
        } else {
            $adp_api = DB::connection('mysql3')->select('
                    SELECT HN,AN,DATEOPD,TYPE,CODE,sum(QTY) QTY,RATE,SEQ,"" "" a1,"" a2,"" a3,"" a4,"0" a5,"" a6,"0" a7 ,"" a8,"" TMLTCODE
                    ,"" STATUS1,"" BI,"" CLINIC,"" ITEMSRC,"" PROVIDER,"" GLAVIDA,"" GA_WEEK,"" DCIP,"0000-00-00" LMP,SP_ITEM
                    from (SELECT v.hn HN
                    ,if(v.an is null,"",v.an) AN
                    ,DATE_FORMAT(v.rxdate,"%Y%m%d") DATEOPD
                    ,n.nhso_adp_type_id TYPE
                    ,n.nhso_adp_code CODE
                    ,sum(v.QTY) QTY
                    ,round(v.unitprice,2) RATE
                    ,if(v.an is null,v.vn,"") SEQ
                    ,"" a1,"" a2,"" a3,"" a4,"0" a5,"" a6,"0" a7 ,"" a8
                    ,"" TMLTCODE,"" STATUS1,"" BI,"" CLINIC,"" ITEMSRC
                    ,"" PROVIDER,"" GLAVIDA,"" GA_WEEK,"" DCIP,"0000-00-00" LMP
                    ,(SELECT "01" from dtemp_hosucep where an = v.an and icode = v.icode and rxdate = v.rxdate and rxtime = v.rxtime  limit 1) SP_ITEM
                    from opitemrece v
                    inner JOIN nondrugitems n on n.icode = v.icode and n.nhso_adp_code is not null
                    left join ipt i on i.an = v.an
                    AND i.an is not NULL
                
                    WHERE v.vstdate BETWEEN "'.$startdate.'" AND "'.$enddate.'" 
                    AND n.icode <> "XXXXXX"
                    GROUP BY i.vn,n.nhso_adp_code,rate) a
                    GROUP BY an,CODE,rate
                    
                    UNION

                    SELECT HN,AN,DATEOPD,TYPE,CODE,sum(QTY) QTY,RATE,SEQ,"" a1,"" a2,"" a3,"" a4,"0" a5,"" a6,"0" a7 ,"" a8,"" TMLTCODE
                    ,"" STATUS1,"" BI,"" CLINIC,"" ITEMSRC,"" PROVIDER,"" GLAVIDA,"" GA_WEEK,"" DCIP,"0000-00-00" LMP,"" SP_ITEM
                    from
                    (SELECT v.hn HN
                    ,if(v.an is null,"",v.an) AN
                    ,DATE_FORMAT(v.vstdate,"%Y%m%d") DATEOPD
                    ,n.nhso_adp_type_id TYPE
                    ,n.nhso_adp_code CODE
                    ,sum(v.QTY) QTY
                    ,round(v.unitprice,2) RATE
                    ,if(v.an is null,v.vn,"") SEQ,"" a1,"" a2,"" a3,"" a4,"0" a5,"" a6,"0" a7 ,"" a8
                    ,"" TMLTCODE,"" STATUS1,"" BI,"" CLINIC,"" ITEMSRC,"" PROVIDER,"" GLAVIDA,"" GA_WEEK,"" DCIP,"0000-00-00" LMP,"" SP_ITEM
                    from opitemrece v
                    inner JOIN nondrugitems n on n.icode = v.icode and n.nhso_adp_code is not null
                    left join ipt i on i.an = v.an
                    
                    WHERE v.vstdate BETWEEN "'.$startdate.'" AND "'.$enddate.'" 
                    AND n.icode <> "XXXXXX"
                    AND i.an is NULL
                    GROUP BY v.vn,n.nhso_adp_code,rate) b
                    GROUP BY seq,CODE,rate;
            ');
           
        }        
        
        return response([$query_ucep,$adp_api]);

    }
    public function ucep(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        if ($startdate == '') {
            $query_ucep = DB::connection('mysql3')->select('
                SELECT o.vn,o.an,o.hn,p.cid,o.vstdate,o.pttype
                        ,concat(p.pname," ",p.fname," ", p.lname) as ptname
                        ,a.pdx ,g.er_screen,ee.er_emergency_level_name
                        from ovst o
                        left outer join an_stat a on a.an = o.an
                        left outer join spclty s on s.spclty=o.spclty
                        left outer join patient p on o.hn=p.hn
                        left outer join er_regist g on g.vn=o.vn
                        left outer join er_emergency_level ee on ee.er_emergency_level_id = g.er_emergency_level_id
                        left outer join pttype pt on pt.pttype = a.pttype
                        where a.dchdate = CURDATE() 
                        AND g.er_emergency_level_id IN("1","2")
                        AND o.an <>"" and pt.hipdata_code ="UCS"
                        group by o.vn;
            ');
        } else {
            $query_ucep = DB::connection('mysql3')->select('
                SELECT o.vn,o.an,o.hn,p.cid,o.vstdate,o.pttype
                        ,concat(p.pname," ",p.fname," ", p.lname) as ptname
                        ,a.pdx ,g.er_screen,ee.er_emergency_level_name
                        from ovst o
                        left outer join an_stat a on a.an = o.an
                        left outer join spclty s on s.spclty=o.spclty
                        left outer join patient p on o.hn=p.hn
                        left outer join er_regist g on g.vn=o.vn
                        left outer join er_emergency_level ee on ee.er_emergency_level_id = g.er_emergency_level_id
                        left outer join pttype pt on pt.pttype = a.pttype
                        where a.dchdate BETWEEN "'.$startdate.'" AND "'.$enddate.'"
                        AND g.er_emergency_level_id IN("1","2")
                        AND o.an <>"" and pt.hipdata_code ="UCS"
                        group by o.vn;
            ');
        }        
        
        return response([$query_ucep]);

    }
    public function getfire(Request $request,$firenum)
    {    
        // $firedata = Fire::where('fire_num','=', $firenum)->first();      
        // $fire_ = Fire::where('fire_num','=', $firenum)->get();
        $fire_ = Fire::get();
         return response([$fire_]);
          
    }
    public function authen_spsch(Request $request)
    {
            $date_now = date('Y-m-d'); 
            // $date_now = date('2024-05-10'); 
            $data_ = DB::connection('mysql')->select('SELECT vn,cid,hn,vstdate FROM check_sit_auto WHERE vstdate = "'.$date_now.'" AND (claimcode IS NULL OR claimcode ="") AND pttype NOT IN("M1","M2","M3","M4","M5","M6","O1","O2","O3","O4","O5","O6","L1","L2","L3","L4","L5","L6") GROUP BY vn'); 
            // $data_ = DB::connection('mysql')->select('SELECT vn,cid,hn,vstdate FROM fdh_mini_dataset WHERE vstdate = "'.$date_now.'" AND (claimcode IS NULL OR claimcode ="") AND pttype NOT IN("M1","M2","M3","M4","M5","M6","O1","O2","O3","O4","O5","O6","L1","L2","L3","L4","L5","L6") GROUP BY vn'); 
            $ch = curl_init(); 
            foreach ($data_ as $key => $value) {
                    $cid         = $value->cid;
                    $vn          = $value->vn;
                    $vstdate     = $value->vstdate; 
                    $headers = array();
                    $headers[] = "Accept: application/json";
                    $headers[] = "Authorization: Bearer 3045bba2-3cac-4a74-ad7d-ac6f7b187479";    
                    curl_setopt($ch, CURLOPT_URL, "https://authenucws.nhso.go.th/authencodestatus/api/check-authen-status?personalId=$cid&serviceDate=$vstdate&serviceCode=PG0060001");
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); 
                    $response = curl_exec($ch); 
                    $contents = $response; 
                    $result = json_decode($contents, true);  
                    if ($result != null ) {  
                            isset( $result['statusAuthen'] ) ? $statusAuthen = $result['statusAuthen'] : $statusAuthen = ""; 
                            if ($statusAuthen =='false') { 
                                $his = $result['serviceHistories']; 
                                // dd($his); 
                                foreach ($his as $key => $value_s) {
                                    $cd	           = $value_s["claimCode"];
                                    $sv_code	   = $value_s["service"]["code"];
                                    $sv_name	   = $value_s["service"]["name"];
                                        
                                    Visit_pttype::where('vn','=', $vn)
                                        ->update([
                                            'claim_code'     => $cd, 
                                    ]);
                                    
                                    Check_sit_auto::where('vn','=', $vn)
                                        ->update([
                                            'claimcode'     => $cd,
                                            'claimtype'     => $sv_code,
                                            'servicename'   => $sv_name, 
                                    ]);
                                    // Fdh_mini_dataset::where('vn','=', $vn)
                                    //     ->update([
                                    //         'claimcode'     => $cd,
                                    //         'claimtype'     => $sv_code,
                                    //         'servicename'   => $sv_name, 
                                    // ]);
                                    
                                }  
                            } 
                    } 
            }  
            
            
            $datati_ = DB::connection('mysql')->select('SELECT vn,cid,hn,vstdate FROM check_sit_auto WHERE vstdate = "'.$date_now.'" AND (claimcode IS NULL OR claimcode ="") AND pttype IN("M1","M2","M3","M4","M5","M6") GROUP BY vn'); 
            // $datati_ = DB::connection('mysql')->select('SELECT vn,cid,hn,vstdate FROM fdh_mini_dataset WHERE vstdate = "'.$date_now.'" AND (claimcode IS NULL OR claimcode ="") AND pttype IN("M1","M2","M3","M4","M5","M6") GROUP BY vn'); 
            
                
            $chti = curl_init(); 
                foreach ($datati_ as $key => $valueti) {
                        $cidti         = $valueti->cid;
                        $vnti          = $valueti->vn;
                        $vstdateti     = $valueti->vstdate; 
                        $headers = array();
                        $headers[] = "Accept: application/json";
                        $headers[] = "Authorization: Bearer 3045bba2-3cac-4a74-ad7d-ac6f7b187479";    
                        curl_setopt($chti, CURLOPT_URL, "https://authenucws.nhso.go.th/authencodestatus/api/check-authen-status?personalId=$cidti&serviceDate=$vstdateti&serviceCode=PG0130001");
                        curl_setopt($chti, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($chti, CURLOPT_CUSTOMREQUEST, "GET");
                        curl_setopt($chti, CURLOPT_HTTPHEADER, $headers);  
                        $responseti = curl_exec($chti);
                        // // curl_close($chti);
                        // dd($ccde);
                        $contents_ti = $responseti; 
                        $result_ti = json_decode($contents_ti, true); 
                        if ($result_ti != null ) {  
                                    isset( $result_ti['statusAuthen'] ) ? $statusAuthen_ti = $result_ti['statusAuthen'] : $statusAuthen_ti = "";
                                     
                                    if ($statusAuthen_ti =='false') { 
                                        $his_ti = $result_ti['serviceHistories']; 
                                        // dd($his); 
                                        foreach ($his_ti as $key => $value_ss) {
                                            $cd_ti	        = $value_ss["claimCode"];
                                            $sv_code_ti	    = $value_ss["service"]["code"];
                                            $sv_name_ti	    = $value_ss["service"]["name"];
                                            Visit_pttype::where('vn','=', $vnti)
                                                ->update([
                                                    'claim_code'     => $cd_ti, 
                                            ]);                                    
                                            Check_sit_auto::where('vn','=', $vnti)
                                                ->update([
                                                    'claimcode'     => $cd_ti,
                                                    'claimtype'     => $sv_code_ti,
                                                    'servicename'   => $sv_name_ti, 
                                            ]);
                                        //     Fdh_mini_dataset::where('vn','=', $vnti)
                                        //     ->update([
                                        //         'claimcode'     => $cd_ti,
                                        //         'claimtype'     => $sv_code_ti,
                                        //         'servicename'   => $sv_name_ti, 
                                        // ]);
                                        }  
                                    }
                                // }
                        }
                        
                } 
            return response()->json('true');
                
    }
    public function authen_spsch_mini(Request $request)
    {
            $date_now = date('Y-m-d'); 
            // $date_now = date('2024-05-10'); 
            // $data_ = DB::connection('mysql')->select('SELECT vn,cid,hn,vstdate FROM check_sit_auto WHERE vstdate = "'.$date_now.'" AND (claimcode IS NULL OR claimcode ="") AND pttype NOT IN("M1","M2","M3","M4","M5","M6","O1","O2","O3","O4","O5","O6","L1","L2","L3","L4","L5","L6") GROUP BY vn'); 
            $data_ = DB::connection('mysql')->select('SELECT vn,cid,hn,vstdate FROM fdh_mini_dataset WHERE vstdate = "'.$date_now.'" AND (claimcode IS NULL OR claimcode ="") AND pttype NOT IN("M1","M2","M3","M4","M5","M6","O1","O2","O3","O4","O5","O6","L1","L2","L3","L4","L5","L6") GROUP BY vn'); 
            $ch = curl_init(); 
            foreach ($data_ as $key => $value) {
                    $cid         = $value->cid;
                    $vn          = $value->vn;
                    $vstdate     = $value->vstdate; 
                    $headers = array();
                    $headers[] = "Accept: application/json";
                    $headers[] = "Authorization: Bearer 3045bba2-3cac-4a74-ad7d-ac6f7b187479";    
                    curl_setopt($ch, CURLOPT_URL, "https://authenucws.nhso.go.th/authencodestatus/api/check-authen-status?personalId=$cid&serviceDate=$vstdate&serviceCode=PG0060001");
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); 
                    $response = curl_exec($ch); 
                    $contents = $response; 
                    $result = json_decode($contents, true);  
                    if ($result != null ) {  
                            isset( $result['statusAuthen'] ) ? $statusAuthen = $result['statusAuthen'] : $statusAuthen = ""; 
                            if ($statusAuthen =='false') { 
                                $his = $result['serviceHistories']; 
                                // dd($his); 
                                foreach ($his as $key => $value_s) {
                                    $cd	           = $value_s["claimCode"];
                                    $sv_code	   = $value_s["service"]["code"];
                                    $sv_name	   = $value_s["service"]["name"];
                                        
                                    // Visit_pttype::where('vn','=', $vn)
                                    //     ->update([
                                    //         'claim_code'     => $cd, 
                                    // ]);
                                    
                                    // Check_sit_auto::where('vn','=', $vn)
                                    //     ->update([
                                    //         'claimcode'     => $cd,
                                    //         'claimtype'     => $sv_code,
                                    //         'servicename'   => $sv_name, 
                                    // ]);
                                    Fdh_mini_dataset::where('vn','=', $vn)
                                        ->update([
                                            'claimcode'     => $cd,
                                            'claimtype'     => $sv_code,
                                            'servicename'   => $sv_name, 
                                    ]);
                                    
                                }  
                            } 
                    } 
            }  
            
            
            // $datati_ = DB::connection('mysql')->select('SELECT vn,cid,hn,vstdate FROM check_sit_auto WHERE vstdate = "'.$date_now.'" AND (claimcode IS NULL OR claimcode ="") AND pttype IN("M1","M2","M3","M4","M5","M6") GROUP BY vn'); 
            $datati_ = DB::connection('mysql')->select('SELECT vn,cid,hn,vstdate FROM fdh_mini_dataset WHERE vstdate = "'.$date_now.'" AND (claimcode IS NULL OR claimcode ="") AND pttype IN("M1","M2","M3","M4","M5","M6") GROUP BY vn'); 
                            
            $chti = curl_init(); 
                foreach ($datati_ as $key => $valueti) {                      
                        $vnti          = $valueti->vn;
                        $cidti         = $valueti->cid;
                        $vstdateti     = $valueti->vstdate; 

                        // $cidti         = '5361090032186';
                        // $vstdateti     = '2024-05-12'; 

                        $headers = array();
                        // $headers[] = "Accept: application/json";
                        // $headers[] = "Authorization: Bearer 3045bba2-3cac-4a74-ad7d-ac6f7b187479";    
                        // curl_setopt($chti, CURLOPT_URL, "https://authenucws.nhso.go.th/authencodestatus/api/check-authen-status?personalId=$cidti&serviceDate=$vstdateti&serviceCode=PG0130001");
                        
                        $headers = array();
                        $headers[] = "Accept: application/json";
                        $headers[] = "Authorization: Bearer 3045bba2-3cac-4a74-ad7d-ac6f7b187479";    
                        curl_setopt($chti, CURLOPT_URL, "https://authenucws.nhso.go.th/authencodestatus/api/check-authen-status?personalId=$cidti&serviceDate=$vstdateti&serviceCode=PG0130001");
                        
                        curl_setopt($chti, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($chti, CURLOPT_CUSTOMREQUEST, "GET");
                        curl_setopt($chti, CURLOPT_HTTPHEADER, $headers);  
                        $responseti = curl_exec($chti);
                        // // curl_close($chti);
                        // dd($ccde);
                        $contents_ti = $responseti; 
                        $result_ti = json_decode($contents_ti, true); 
                        if ($result_ti != null ) {  
                                    isset( $result_ti['statusAuthen'] ) ? $statusAuthen_ti = $result_ti['statusAuthen'] : $statusAuthen_ti = "";
                                     
                                    if ($statusAuthen_ti =='false') { 
                                        $his_ti = $result_ti['serviceHistories']; 
                                        // dd($his); 
                                        foreach ($his_ti as $key => $value_ss) {
                                            $cd_ti	        = $value_ss["claimCode"];
                                            $sv_code_ti	    = $value_ss["service"]["code"];
                                            $sv_name_ti	    = $value_ss["service"]["name"];
                                            
                                            Fdh_mini_dataset::where('vn','=', $vnti)
                                            ->update([
                                                'claimcode'     => $cd_ti,
                                                'claimtype'     => $sv_code_ti,
                                                'servicename'   => $sv_name_ti, 
                                        ]);
                                        }  
                                    }
                                // }
                        }
                        
                } 
            return response()->json('true');
                
    }
    public function pull_hosapi(Request $request)
    {        
                $date_now = date('Y-m-d'); 
                // $date_now = date('2024-05-11');

                $data_sits = DB::connection('mysql10')->select(
                    'SELECT o.an,v.vn,p.hn,p.cid,o.vstdate,o.vsttime,o.pttype,p.pname,p.fname,concat(p.pname,p.fname," ",p.lname) as fullname,op.name as staffname,p.hometel,v.pdx,s.cc
                    ,pt.nhso_code,o.hospmain,o.hospsub,p.birthday
                    ,o.staff,op.name as sname
                    ,o.main_dep,v.income-v.discount_money-v.rcpt_money debit
                    FROM vn_stat v
                    LEFT JOIN visit_pttype vs on vs.vn = v.vn
                    LEFT JOIN ovst o on o.vn = v.vn
                    LEFT JOIN opdscreen s ON s.vn = v.vn
                    LEFT JOIN patient p on p.hn=v.hn
                    LEFT JOIN pttype pt on pt.pttype = v.pttype AND v.pttype 
                    LEFT JOIN opduser op on op.loginname = o.staff
                    WHERE o.vstdate = "'.$date_now.'" AND pt.hipdata_code ="UCS"  
                    AND (o.an IS NULL OR o.an = "")
                    group by o.vn
                
                
                ');   
                // NOT IN("M1","M4","M5") 
                // LIMIT 100
                foreach ($data_sits as $key => $value) {
                    $check = Check_sit_auto::where('vn', $value->vn)->count();
                    if ($check > 0) {   
                        Check_sit_auto::where('vn', $value->vn)->update([  
                            'pttype'              => $value->pttype,
                            'debit'               => $value->debit, 
                        ]);              
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
                            'debit'      => $value->debit,
                            'pdx'        => $value->pdx,
                            'cc'         => $value->cc
                        ]);
                        
                        // Fdh_mini_dataset::insert([
                        //     'service_date_time'   => $value->vstdate . ' ' . $value->vsttime,
                        //     'cid'                 => $value->cid,
                        //     'hcode'               => $value->hcode,
                        //     'total_amout'         => $value->total_amout,
                        //     'invoice_number'      => $value->invoice_number,
                        //     'vn'                  => $value->vn,
                        //     'pttype'              => $value->pttype,
                        //     'ptname'              => $value->ptname,
                        //     'hn'                  => $value->hn,
                        //     'vstdate'             => $value->vstdate,
                        //     'vsttime'             => $value->vsttime,
                        //     'datesave'            => $date_now,
                          
                        // ]);
                       
                    }
                }
                return response()->json('200');
                // $data_ = DB::connection('mysql')->select('SELECT vn,cid,hn,vstdate FROM check_sit_auto WHERE vstdate = "'.$date_now.'" AND (claimcode IS NULL OR claimcode ="") AND pttype NOT IN("M1","M2","M3","M4","M5","M6") GROUP BY vn'); 
                // return response()->json('200');
                // return response()->json(['status'=>'200']);
                //   return response()->json($data_, 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
                // JSON_UNESCAPED_UNICODE);
    }
//    ***************** Mini Dataset ********************
    public function pull_hosminiapi(Request $request)
    {        
                $date_now = date('Y-m-d'); 
                // $date_now = date('2024-05-11');
                $data_sits = DB::connection('mysql10')->select(
                    'SELECT v.vstdate,o.vsttime
                        ,Time_format(o.vsttime ,"%H:%i") vsttime2
                        ,v.cid,"10978" as hcode
                        ,rd.total_amount as total_amout
                        ,rd.finance_number as invoice_number
                        ,v.vn,concat(pt.pname,pt.fname," ",pt.lname) as ptname,v.hn,v.pttype
                        FROM vn_stat v 
                        LEFT OUTER JOIN ovst o ON v.vn = o.vn 
                        LEFT OUTER JOIN patient pt on pt.hn = v.hn
                        LEFT OUTER JOIN pttype ptt ON v.pttype=ptt.pttype   
                        LEFT OUTER JOIN rcpt_debt rd ON v.vn = rd.vn 
                    WHERE o.vstdate = "' . $date_now . '" 
                    AND ptt.hipdata_code ="UCS" AND v.income > 0 AND pt.nationality = "99"
                    GROUP BY o.vn 
                ');   
                // LIMIT 100
                foreach ($data_sits as $key => $value) {
                    $check = Fdh_mini_dataset::where('vn', $value->vn)->count();
                    if ($check >0) {                    
                        Fdh_mini_dataset::where('vn', $value->vn)->update([  
                            'pttype'              => $value->pttype,
                            'total_amout'         => $value->total_amout,
                            'invoice_number'      => $value->invoice_number,
                        ]);              
                    } else {
                        Fdh_mini_dataset::insert([
                            'service_date_time'   => $value->vstdate . ' ' . $value->vsttime,
                            'cid'                 => $value->cid,
                            'hcode'               => $value->hcode,
                            'total_amout'         => $value->total_amout,
                            'invoice_number'      => $value->invoice_number,
                            'vn'                  => $value->vn,
                            'pttype'              => $value->pttype,
                            'ptname'              => $value->ptname,
                            'hn'                  => $value->hn,
                            'vstdate'             => $value->vstdate,
                            'vsttime'             => $value->vsttime,
                            'datesave'            => $date_now, 
                        ]);
                    
                    }
                }
                return response()->json('200');
            
    }
    public function fdh_mini_auth(Request $request)
    {  
        $username        = 'pradit.10978';
        $password        = '8Uk&8Fr&';
        $password_hash   = strtoupper(hash_hmac('sha256', $password, '$jwt@moph#'));

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://fdh.moph.go.th/token?Action=get_moph_access_token&user=' . $username . '&password_hash=' . $password_hash . '&hospital_code=10978',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => array(
                'Cookie: __cfruid=bedad7ad2fc9095d4827bc7be4f52f209543768f-1714445470'
            ),
        ));
        $token = curl_exec($curl);
        // dd($token); 
        curl_close($curl);
 
        $check = Api_neweclaim::where('api_neweclaim_user', $username)->where('api_neweclaim_pass', $password)->count();
        if ($check > 0) {
            Api_neweclaim::where('api_neweclaim_user', $username)->update([
                'api_neweclaim_token'       => $token, 
                'password_hash'             => $password_hash,
                'hospital_code'             => '10978',
                'active_mini'               => 'Y',
            ]);
        } else {
            Api_neweclaim::insert([
                'api_neweclaim_user'        => $username,
                'api_neweclaim_pass'        => $password,
                'api_neweclaim_token'       => $token,
                'password_hash'             => $password_hash,
                'hospital_code'             => '10978',
                'active_mini'               => 'Y', 
            ]);
        }
        
        return response()->json('200');
    }
    public function fdh_mini_pullhosinv(Request $request)
    { 
            $date_now = date('Y-m-d');           
            $datashow_ = DB::connection('mysql2')->select(
                'SELECT v.vstdate,o.vsttime
                    ,Time_format(o.vsttime ,"%H:%i") vsttime2
                    ,v.cid,"10978" as hcode
                    ,v.income as total_amout
                    ,rd.finance_number as invoice_number
                    ,v.vn,concat(pt.pname,pt.fname," ",pt.lname) as ptname,v.hn,v.pttype
                    FROM vn_stat v 
                    LEFT OUTER JOIN ovst o ON v.vn = o.vn 
                    LEFT OUTER JOIN patient pt on pt.hn = v.hn
                    LEFT OUTER JOIN pttype ptt ON v.pttype=ptt.pttype 
                    LEFT OUTER JOIN rcpt_debt rd ON v.vn = rd.vn 
                WHERE o.vstdate = "' . $date_now . '"
                AND ptt.hipdata_code ="UCS" AND pt.nationality = "99"
                GROUP BY o.vn 
            '); 
            // AND v.pttype NOT IN("M1","M4","M5") 
            // AND v.income > 0 
            // AND rd.total_amount IS NOT NULL
            foreach ($datashow_ as $key => $value) {
                $check_opd = Fdh_mini_dataset::where('vn', $value->vn)->count();
                if ($check_opd > 0) {
                    Fdh_mini_dataset::where('vn', $value->vn)->update([  
                        'pttype'              => $value->pttype,
                        'total_amout'         => $value->total_amout,
                        'invoice_number'      => $value->invoice_number, 
                    ]);
                } else {
                    Fdh_mini_dataset::insert([
                        'service_date_time'   => $value->vstdate . ' ' . $value->vsttime,
                        'cid'                 => $value->cid,
                        'hcode'               => $value->hcode,
                        'total_amout'         => $value->total_amout,
                        'invoice_number'      => $value->invoice_number,
                        'vn'                  => $value->vn,
                        'pttype'              => $value->pttype,
                        'ptname'              => $value->ptname,
                        'hn'                  => $value->hn,
                        'vstdate'             => $value->vstdate,
                        'vsttime'             => $value->vsttime,
                        'datesave'            => $date_now,
                      
                    ]);
                }
            }
            return response()->json('200');      
    }
    public function fdh_minipullhosnoinv(Request $request)
    { 
            $date_now  = date('Y-m-d'); 
            $datashow_ = DB::connection('mysql2')->select(
                'SELECT v.vstdate,o.vsttime
                    ,Time_format(o.vsttime ,"%H:%i") vsttime2
                    ,v.cid,"10978" as hcode
                    ,IFNULL(rd.total_amount,v.income) as total_amout
                    ,IFNULL(rd.finance_number,v.vn) as invoice_number
                    ,v.vn,concat(pt.pname,pt.fname," ",pt.lname) as ptname,v.hn,v.pttype
                    FROM vn_stat v 
                    LEFT OUTER JOIN ovst o ON v.vn = o.vn 
                    LEFT OUTER JOIN patient pt on pt.hn = v.hn
                    LEFT OUTER JOIN pttype ptt ON v.pttype = ptt.pttype 
                    LEFT OUTER JOIN rcpt_debt rd ON v.vn = rd.vn 
                WHERE o.vstdate = "' . $date_now . '" AND (o.an IS NULL OR o.an = "") 
                AND pt.nationality = "99"
                AND ptt.hipdata_code ="UCS" AND v.income > 0 and rd.finance_number IS NULL  
                GROUP BY o.vn   
            ');
            // AND v.pttype NOT IN("M1","M4","M5")  
            foreach ($datashow_ as $key => $value) {
                $check_opd = Fdh_mini_dataset::where('vn', $value->vn)->count();
                if ($check_opd > 0) {
                    Fdh_mini_dataset::where('vn', $value->vn)->update([  
                        'total_amout'         => $value->total_amout,
                        'invoice_number'      => $value->invoice_number, 
                    ]);
                } else {
                    Fdh_mini_dataset::insert([
                        'service_date_time'   => $value->vstdate . ' ' . $value->vsttime,
                        'cid'                 => $value->cid,
                        'hcode'               => $value->hcode,
                        'total_amout'         => $value->total_amout,
                        'invoice_number'      => $value->invoice_number,
                        'vn'                  => $value->vn,
                        'pttype'              => $value->pttype,
                        'ptname'              => $value->ptname,
                        'hn'                  => $value->hn,
                        'vstdate'             => $value->vstdate,
                        'vsttime'             => $value->vsttime,
                        'datesave'            => $date_now,
                      
                    ]);
                }
            }
     
            return response()->json('200'); 
    }
    public function fdh_mini_pidsit(Request $request)
    { 
           $date_now = date('Y-m-d');
        //    $data_vn_1 = Fdh_mini_dataset::where('vstdate','=',$date_now)->where('invoice_number','<>','')->get();
           $data_vn_1 = DB::connection('mysql')->select('SELECT * FROM fdh_mini_dataset WHERE invoice_number IS NOT NULL AND vstdate = "'.$date_now.'"');
           $data_token_ = DB::connection('mysql')->select(' SELECT * FROM api_neweclaim WHERE active_mini = "Y"');
           foreach ($data_token_ as $key => $val_to) {
               $token_   = $val_to->api_neweclaim_token;
           }
           $token = $token_;   
           $startcount = 1;
           $data_claim = array();
           foreach ($data_vn_1 as $key => $val) {
               $service_date_time_      = $val->service_date_time;   
               $service_date_time    = substr($service_date_time_,0,16);
               $cid                  = $val->cid;
               $hcode                = $val->hcode;
               $total_amout          = $val->total_amout;
               $invoice_number       = $val->invoice_number;
               $vn                   = $val->vn;  
           
               $curl = curl_init();
                   $postData_send = [ 
                       "service_date_time"  => $service_date_time,
                       "cid"                => $cid,
                       "hcode"              => $hcode,
                       "total_amout"        => $total_amout,
                       "invoice_number"     => $invoice_number,
                       "vn"                 => $vn 
                   ];
                   curl_setopt($curl, CURLOPT_URL,"https://fdh.moph.go.th/api/v1/reservation");
                   curl_setopt($curl, CURLOPT_POST, 1);
                   curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                   curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($postData_send, JSON_UNESCAPED_SLASHES));
                   curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                       'Content-Type: application/json',
                       'Authorization: Bearer '.$token,
                       'Cookie: __cfruid=bedad7ad2fc9095d4827bc7be4f52f209543768f-1714445470'
                   ));
       
                   $server_output     = curl_exec ($curl);
                   $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE); 
                   $content = $server_output;
                   $result = json_decode($content, true); 
                   @$status = $result['status']; 
                   @$message = $result['message'];
                   @$data = $result['data'];
                   @$uid = $data['transaction_uid']; 
                   if (@$message == 'success') {
                           Fdh_mini_dataset::where('vn', $vn)
                           ->update([
                               'transaction_uid' =>  @$uid,
                               'active'          => 'Y'
                           ]); 
                   } elseif ($status == '400') {
                           Fdh_mini_dataset::where('vn', $vn)
                               ->update([
                                   'transaction_uid' =>  @$uid,
                                   'active'          => 'Y'
                               ]);
                   } else {
                   }
           }       
           return response()->json('200');              

    }
    public function fdh_mini_pullbookid(Request $request)
    {
            $date = date('Y-m-d');
            $data_vn_1 = Fdh_mini_dataset::where('vstdate','=',$date)->where('transaction_uid','<>','')->get();
            $data_token_ = DB::connection('mysql')->select(' SELECT * FROM api_neweclaim WHERE active_mini = "Y"');
            foreach ($data_token_ as $key => $val_to) {
                $token_   = $val_to->api_neweclaim_token;
            }
            $token = $token_; 
            foreach ($data_vn_1 as $key => $val) { 
                $transaction_uid      = $val->transaction_uid;
                $hcode                = $val->hcode; 

                    $curl = curl_init(); 
                    curl_setopt_array($curl, array(
                        CURLOPT_URL => 'https://fdh.moph.go.th/api/v1/reservation',
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'GET',
                        CURLOPT_POSTFIELDS => '{
                            "transaction_uid": "'.$transaction_uid.'", 
                            "hcode"          : "'.$hcode.'" 
                        }',
                        CURLOPT_HTTPHEADER => array(
                            'Content-Type: application/json',
                            'Authorization: Bearer '.$token,
                            'Cookie: __cfruid=bedad7ad2fc9095d4827bc7be4f52f209543768f-1714445470'
                        ),
                    ));
                    $response = curl_exec($curl);
                    // dd($response); 
                    $result            = json_decode($response, true); 
                    @$status           = $result['status']; 
                    @$message          = $result['message'];
                    @$data             = $result['data'];
                    @$uidrep           = $data['transaction_uid'];
                    @$id_booking       = $data['id_booking'];
                    @$uuid_booking     = $data['uuid_booking']; 
                    if (@$message == 'success') {
                            Fdh_mini_dataset::where('transaction_uid', $uidrep)
                            ->update([
                                'id_booking'     => @$id_booking,
                                'uuid_booking'   => @$uuid_booking
                            ]);  
                    } elseif ($status == '400') {
                            Fdh_mini_dataset::where('transaction_uid', $uidrep)
                                ->update([
                                    'id_booking'     => @$id_booking,
                                    'uuid_booking'   => @$uuid_booking
                                ]);
                    } else {
                        # code...
                    }
            }
            return response()->json('200'); 
    }
    public function fdh_countvn(Request $request)
    { 
           $date_now = date('Y-m-d');
           
           $data_vn_1 = DB::connection('mysql')->select(
            'SELECT COUNT(DISTINCT vn) as count_vn FROM fdh_mini_dataset 
            WHERE vstdate = "'.$date_now.'" AND pttype NOT IN("M1","M4","M5","M6","O1","O2","O3","O4","O5","O6","L1","L2","L3","L4","L5","L6","13","23","91","x7","10")
            ');
           foreach ($data_vn_1 as $key => $value) {
            $countvn = $value->count_vn;
           }                 
           return response()->json($countvn); 
    }
    public function fdh_sumincome(Request $request)
    { 
           $date_now = date('Y-m-d');
           
           $data_vn_1 = DB::connection('mysql')->select(
            'SELECT CONCAT(FORMAT(SUM(total_amout), 2)) as total FROM fdh_mini_dataset 
            WHERE vstdate = "'.$date_now.'" AND pttype NOT IN("M1","M4","M5","M6","O1","O2","O3","O4","O5","O6","L1","L2","L3","L4","L5","L6","13","23","91","x7","10")
            ');
           foreach ($data_vn_1 as $key => $value) {
            $sumincome = $value->total;
            
           }                 
           return response()->json($sumincome); 
    }
    public function fdh_countpidsit(Request $request)
    { 
           $date_now = date('Y-m-d');
           
           $data_vn_1 = DB::connection('mysql')->select(
            'SELECT COUNT(DISTINCT vn) as count_vn FROM fdh_mini_dataset 
            WHERE vstdate = "'.$date_now.'" AND transaction_uid IS NOT NULL AND pttype NOT IN("M1","M4","M5","M6","O1","O2","O3","O4","O5","O6","L1","L2","L3","L4","L5","L6","13","23","91","x7","10")');
           foreach ($data_vn_1 as $key => $value) {
            $countpidsit = $value->count_vn;
           }                 
           return response()->json($countpidsit); 
    }
    public function fdh_countbookid(Request $request)
    { 
           $date_now = date('Y-m-d');
           
           $data_vn_1 = DB::connection('mysql')->select(
            'SELECT COUNT(DISTINCT vn) as count_vn FROM fdh_mini_dataset 
            WHERE vstdate = "'.$date_now.'" AND id_booking IS NOT NULL AND pttype NOT IN("M1","M4","M5","M6","O1","O2","O3","O4","O5","O6","L1","L2","L3","L4","L5","L6","13","23","91","x7","10")');
           foreach ($data_vn_1 as $key => $value) {
            $countpidsit = $value->count_vn;
           }                 
           return response()->json($countpidsit); 
    }
    public function fdh_countauthen(Request $request)
    { 
           $date_now = date('Y-m-d');
           
           $data_vn_1 = DB::connection('mysql')->select(
            'SELECT COUNT(DISTINCT vn) as count_authen FROM fdh_mini_dataset 
            WHERE vstdate = "'.$date_now.'" AND pttype NOT IN("M1","M4","M5","M6","O1","O2","O3","O4","O5","O6","L1","L2","L3","L4","L5","L6","13","23","91","x7","10")
            AND claimcode IS NOT NULL');
           foreach ($data_vn_1 as $key => $value) {
            $countauthen = $value->count_authen;
           }                 
           return response()->json($countauthen); 
    }
    public function fdh_countauthennull(Request $request)
    { 
           $date_now = date('Y-m-d');
           
           $data_vn_1 = DB::connection('mysql')->select(
            'SELECT COUNT(DISTINCT vn) as count_authen FROM fdh_mini_dataset 
            WHERE vstdate = "'.$date_now.'" AND claimcode IS NULL AND pttype NOT IN("M1","M4","M5","M6","O1","O2","O3","O4","O5","O6","L1","L2","L3","L4","L5","L6","13","23","91","x7","10")');
           foreach ($data_vn_1 as $key => $value) {
            $countauthen = $value->count_authen;
           }                 
           return response()->json($countauthen); 
    }
    public function fdh_sumincome_authen(Request $request)
    { 
           $date_now = date('Y-m-d');
           
           $data_vn_1 = DB::connection('mysql')->select(
            'SELECT CONCAT(FORMAT(SUM(total_amout), 2)) as total FROM fdh_mini_dataset 
            WHERE vstdate = "'.$date_now.'" AND claimcode IS NOT NULL AND pttype NOT IN("M1","M4","M5","M6","O1","O2","O3","O4","O5","O6","L1","L2","L3","L4","L5","L6","13","23","91","x7","10")');
           foreach ($data_vn_1 as $key => $value) {
            $sumincome = $value->total;
            
           }                 
           return response()->json($sumincome); 
    }
    public function fdh_sumincome_noauthen(Request $request)
    { 
           $date_now = date('Y-m-d');
           
           $data_vn_1 = DB::connection('mysql')->select(
            'SELECT CONCAT(FORMAT(SUM(total_amout), 2)) as total FROM fdh_mini_dataset 
            WHERE vstdate = "'.$date_now.'" AND claimcode IS NULL AND pttype NOT IN("M1","M4","M5","M6","O1","O2","O3","O4","O5","O6","L1","L2","L3","L4","L5","L6","13","23","91","x7","10")');
           foreach ($data_vn_1 as $key => $value) {
            $sumincome = $value->total;
            
           }                 
           return response()->json($sumincome); 
    }
    public function countfiregreenall(Request $request)
    { 
           $date_now = date('Y-m-d');
           
           $data_vn_1 = DB::connection('mysql')->select('SELECT COUNT(fire_id) fire_id FROM fire WHERE fire_color = "green"');
           foreach ($data_vn_1 as $key => $value) {
            $firegreen = $value->fire_id; 
           }                 
           return response()->json($firegreen); 
    }
    public function countfiregreen(Request $request)
    { 
           $date_now = date('Y-m-d');
           
           $data_vn_1 = DB::connection('mysql')->select('SELECT COUNT(fire_id) fire_id FROM fire WHERE fire_color = "green" AND active ="Y"');
           foreach ($data_vn_1 as $key => $value) {
            $firegreen = $value->fire_id; 
           }                 
           return response()->json($firegreen); 
    }
    public function countfiregreenrepaire(Request $request)
    { 
           $date_now = date('Y-m-d');
           
           $data_vn_1 = DB::connection('mysql')->select('SELECT COUNT(fire_id) fire_id FROM fire WHERE fire_color = "green" AND active ="R"');
           foreach ($data_vn_1 as $key => $value) {
            $firegreenre = $value->fire_id; 
           }                 
           return response()->json($firegreenre); 
    }
    public function countfireredall(Request $request)
    { 
           $date_now = date('Y-m-d');
           
           $data_vn_1 = DB::connection('mysql')->select('SELECT COUNT(fire_id) fire_id FROM fire WHERE fire_color = "red"');
           foreach ($data_vn_1 as $key => $value) {
            $firered = $value->fire_id; 
           }                 
           return response()->json($firered); 
    }
    public function countfirered(Request $request)
    { 
           $date_now = date('Y-m-d');
           
           $data_vn_1 = DB::connection('mysql')->select('SELECT COUNT(fire_id) fire_id FROM fire WHERE fire_color = "red" AND active ="Y"');
           foreach ($data_vn_1 as $key => $value) {
            $firered = $value->fire_id; 
           }                 
           return response()->json($firered); 
    }
    public function countfireredrepaire(Request $request)
    { 
           $date_now = date('Y-m-d');
           
           $data_vn_1 = DB::connection('mysql')->select('SELECT COUNT(fire_id) fire_id FROM fire WHERE fire_color = "red" AND active ="R"');
           foreach ($data_vn_1 as $key => $value) {
            $fireredre = $value->fire_id; 
           }                 
           return response()->json($fireredre); 
    }
    public function getfirenum(Request $request,$firenum)
    { 
           $date_now = date('Y-m-d');           
           $data_vn_1 = DB::connection('mysql')->select('SELECT * FROM fire WHERE fire_num = "'.$firenum.'" ');
           foreach ($data_vn_1 as $key => $value) {
                $fireactive = $value->active; 
           }                 
           return response()->json($fireactive); 
    }

}





