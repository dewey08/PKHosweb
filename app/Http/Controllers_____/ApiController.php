<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Authencode;
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
                ,concat(i.dchdate," ",i.dchtime) AS dc_time, CASE WHEN  p.sex="1" then "ชาย" else "หญิง" end as sexname,a.age_y,a.los,i.adjrw
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
}





