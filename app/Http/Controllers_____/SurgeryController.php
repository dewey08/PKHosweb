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

class SurgeryController extends Controller
{
    public function surgery_index(Request $request)
    {
        $date = date('Y-m-d');
       
        $department = DB::connection('mysql3')->select('
            SELECT depcode,department FROM kskdepartment
            WHERE depcode in("098","055","056")            
        '); 
        return view('surgery.surgery_index',[
            'department'       => $department,           
        ] );
    }
    public function surgery_page(Request $request,$dep)
    {
        $date = date('Y-m-d');       
        $department = DB::connection('mysql3')->select('
            SELECT depcode,department FROM kskdepartment
            WHERE depcode in("098","055","056")            
        ');
 
        return view('surgery.surgery_page',[
            'department'       => $department,           
        ] );
    }
    
    // public function screening_spirits(Request $request)
    // {
    //     $date = date('Y-m-d');
       
    //     $data_spirits = DB::connection('mysql3')->select('
    //             select p.person_id,p.patient_hn,p.cid,concat(p.pname,p.fname,"",p.lname) ptname
    //                 ,thaiage(p.birthdate,"'.$date.'") age
    //                 ,p.house_regist_type_id typearea,h.address,v.village_moo moo,v.village_name
    //                 ,cast(group_concat(distinct if(t.pp_special_code like"1B6%","Y",null)) as char(1))  Drink
    //                 ,cast(group_concat(distinct if(t.pp_special_code="1B600","Y",null)) as char(1))  Social 
    //                 ,cast(group_concat(distinct if(t.pp_special_code="1B601","Y",null)) as char(1))  Home 
    //                 ,cast(group_concat(distinct if(t.pp_special_code in("1B602","1B603","1B604"),"Y",null)) as char(1))  Bed 
    //                 ,group_concat(distinct if(t.pp_special_code in ("1B600","1B601","1B602","1B603","1B604"),t.pp_special_code,null) order by pp.entry_datetime desc) Code
    //                 ,group_concat(distinct if(t.pp_special_code in ("1B600","1B601","1B602","1B603","1B604"),t.pp_special_type_name,null) order by pp.entry_datetime desc) Cname
    //                 ,group_concat(distinct if(t.pp_special_code in ("1B600","1B601","1B602","1B603","1B604"),ce2be(pp.entry_datetime),null) order by pp.entry_datetime desc) Vstdate
    //                 ,cast(group_concat(distinct if(t.pp_special_code ="1B602","Y",null)) as char(1))  low
    //                 ,cast(group_concat(distinct if(t.pp_special_code ="1B610","Y",null)) as char(1)) be
    //                 ,cast(group_concat(distinct if(t.pp_special_code="1B603","Y",null)) as char(1))  mid
    //                 ,cast(group_concat(distinct if(t.pp_special_code ="1B611","Y",null)) as char(1)) co
    //                 ,cast(group_concat(distinct if(t.pp_special_code="1B604","Y",null)) as char(1))  Height 
    //                 ,cast(group_concat(distinct if(t.pp_special_code ="1B611","Y",null)) as char(1)) cco
    //                 ,cast(group_concat(distinct if(t.pp_special_code ="1B612","Y",null)) as char(1)) re
    //                 from person p
    //                 LEFT JOIN village v on v.village_id=p.village_id
    //                 LEFT JOIN house h on h.house_id=p.house_id
    //                 left join pp_special pp on pp.hn=p.patient_hn and pp.entry_datetime between "'.$date.'" and "'.$date.'"
    //                 left join pp_special_type t on t.pp_special_type_id=pp.pp_special_type_id
    //                 where p.nationality="99" and TIMESTAMPDIFF(YEAR,p.birthdate,"'.$date.'")>14
    //                 and p.house_regist_type_id in(1,3) and p.person_discharge_id=9
    //                 group by p.person_id
    //                 order by v.village_moo,p.birthdate
            
    //     ');
 
    //     return view('ppsf.screening_spirits',[
    //         'data_spirits'       => $data_spirits,           
    //     ] );
    // }
    




}