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
use App\Models\Department;
use App\Models\Departmentsub;
use App\Models\Departmentsubsub;
use App\Models\Position;
use App\Models\Product_spyprice;
use App\Models\Products;
use App\Models\Products_type;
use App\Models\Product_group;
use App\Models\Product_unit;
use App\Models\Products_category;
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
use App\Models\Book_type;
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
use Auth;
use ZipArchive;
use Storage;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Stevebauman\Location\Facades\Location; 
use SoapClient; 
use SplFileObject;
use App\Models\D_dru;
use App\Models\D_adp;
use App\Models\D_aer;
use App\Models\D_cha;  
use App\Models\D_cht;
use App\Models\D_idx;
use App\Models\D_iop;
use App\Models\D_ipd;
use App\Models\D_opd;
use App\Models\D_oop;
use App\Models\D_odx;
use App\Models\D_orf;
use App\Models\D_pat;
use App\Models\D_ins; 
use App\Models\D_irf;
use App\Models\D_lvd;
use App\Models\Export_temp;
 
 

class PediaricsController extends Controller
{

    public function prenatal_care_db(Request $request)
    {
        $dabyear = $request->dabyear;
        // $enddate = $request->enddate;
        $yearnew = date('Y')+1;
        $yearold = date('Y');
        $start = (''.$yearold.'-10-01');
        $end = (''.$yearnew.'-09-30'); 
        $budget_year = DB::table('budget_year')->where('active','=',true)->first();
        $date_start = $budget_year->date_begin;
        $date_end   = $budget_year->date_end;
        
         
        return view('anc.prenatal_care_db',[
            'dabyear'   => $dabyear,
            // 'enddate'     => $enddate, 
            // 'dabyear'       => $dabyear, 
        ]);
    }
    
  
    public function prenatal_care(Request $request)
    {
        $dabyear = $request->dabyear;
        // $enddate = $request->enddate;
        $yearnew = date('Y')+1;
        $yearold = date('Y');
        $start = (''.$yearold.'-10-01');
        $end = (''.$yearnew.'-09-30'); 
        $budget_year = DB::table('budget_year')->where('active','=',true)->first();
        $date_start = $budget_year->date_begin;
        $date_end   = $budget_year->date_end;
        // $data['dabyear'] = DB::table('budget_year')->orderBy('')->get();

       
        $data['dabyears'] = DB::table('budget_year')->get();
        // dd( $dabyear);
        if ($dabyear =='') {
            // $dabyear = $request->dabyear;
            $data['data_anc'] = DB::connection('mysql10')->select('  
                    SELECT w.ward,i.incharge_doctor,d.`name` as doctor,GROUP_CONCAT(DISTINCT(w.name)) as wardname
                    ,count(distinct(i.an))as total_an
                    ,sum(i.adjrw)as sum_adjrw
                    ,sum(i.adjrw)/count(distinct(i.an)) as total_cmi
                    ,count(DISTINCT(ii.an))as total_noadjre 
                    FROM ipt i
                    LEFT JOIN an_stat a on  i.an=a.an
                    LEFT JOIN ward w on i.ward=w.ward 
                    LEFT JOIN ipt ii on i.an=ii.an  and  ii.adjrw = ""
                    LEFT JOIN doctor d on i.incharge_doctor=d.code
                    WHERE i.dchdate BETWEEN "'.$date_start.'" AND "'.$date_end.'"
                    and a.age_y <= "15"
                    GROUP BY i.incharge_doctor  
                    ORDER BY count(distinct(i.an)) DESC
            '); 
        } else {
            $budget_ = DB::table('budget_year')->where('leave_year_id','=', $dabyear)->first();
            $date_start_ = $budget_->date_begin;
            $date_end_   = $budget_->date_end;
            $data['data_anc'] = DB::connection('mysql10')->select(' 
                    SELECT w.ward,i.incharge_doctor,d.`name` as doctor,GROUP_CONCAT(DISTINCT(w.name)) as wardname
                    ,count(distinct(i.an))as total_an
                    ,sum(i.adjrw)as sum_adjrw
                    ,sum(i.adjrw)/count(distinct(i.an)) as total_cmi
                    ,count(DISTINCT(ii.an))as total_noadjre 
                    FROM ipt i
                    LEFT JOIN an_stat a on i.an=a.an
                    LEFT JOIN ward w on i.ward=w.ward 
                    LEFT JOIN ipt ii on i.an=ii.an  and  ii.adjrw = ""
                    LEFT JOIN doctor d on i.incharge_doctor=d.code
                    WHERE i.dchdate BETWEEN "'.$date_start_.'" AND "'.$date_end_.'"
                    and a.age_y <= "15"
                    GROUP BY  i.incharge_doctor   
                    ORDER BY count(distinct(i.an)) DESC
            '); 
        }
         
        return view('anc.prenatal_care',$data,[
            'dabyear'   => $dabyear,
            // 'enddate'     => $enddate, 
            // 'dabyear'       => $dabyear, 
        ]);
    }

    public function prenatal_care_doctor(Request $request,$doctor,$dabyear)
    {
        // $dabyear = $request->dabyear;
        // $enddate = $request->enddate;
        $yearnew = date('Y')+1;
        $yearold = date('Y');
        $start = (''.$yearold.'-10-01');
        $end = (''.$yearnew.'-09-30'); 
        $budget_ = DB::table('budget_year')->where('leave_year_id','=', $dabyear)->first();
        $date_start_ = $budget_->date_begin;
        $date_end_   = $budget_->date_end;
        
        $data['dabyears'] = DB::table('budget_year')->get();
        
            $data['data_anc'] = DB::connection('mysql10')->select('   
                    
                    SELECT i.an,a.pdx,ic.`name` as namet,GROUP_CONCAT(DISTINCT(w.`name`)) as ward
                    ,count(distinct(i.an))as total_an
                    ,sum(i.adjrw)as sum_adjrw
                    ,sum(i.adjrw)/count(distinct(i.an)) as total_cmi
                    ,count(DISTINCT(ii.an))as total_noadjre 
                    FROM  ipt i
                    LEFT JOIN  an_stat a  on  i.an=a.an
                    LEFT JOIN  icd101 ic  on  a.pdx=ic.`code`
                    LEFT JOIN  ward  w  on  i.ward=w.ward
                    #LEFT JOIN  ward_backup1872566  ww on  i.ward=ww.ward
                    LEFT JOIN  ipt  ii  on  i.an=ii.an  and  ii.adjrw =""
                    LEFT JOIN  doctor  d  on  i.incharge_doctor=d.`code`
                    WHERE  i.dchdate  BETWEEN "'.$date_start_.'" AND "'.$date_end_.'"
                    AND i.incharge_doctor="'.$doctor.'"
                    and a.age_y<="15"
                    GROUP BY  a.pdx
                    ORDER BY count(distinct(i.an)) DESC
            '); 
       
         
        return view('anc.prenatal_care_doctor',$data,[ 
            'dabyear'   => $dabyear,
            'doctor'    => $doctor,
        ]);
    }

    public function prenatal_care_pdx(Request $request,$pdx,$doctor,$dabyear)
    {
        // $dabyear = $request->dabyear;
        // $enddate = $request->enddate;
        $yearnew = date('Y')+1;
        $yearold = date('Y');
        $start = (''.$yearold.'-10-01');
        $end = (''.$yearnew.'-09-30'); 
        $budget_ = DB::table('budget_year')->where('leave_year_id','=', $dabyear)->first();
        $date_start_ = $budget_->date_begin;
        $date_end_   = $budget_->date_end;
        
        $data['dabyears'] = DB::table('budget_year')->get();
        
            $data['data_anc'] = DB::connection('mysql10')->select(' 
                SELECT i.an,i.hn,CONCAT(p.pname,p.fname," ",p.lname)as ptname,i.regdate,i.dchdate,a.admdate,CONCAT(a.age_y,"  ป.  ",a.age_m," ด."  ,a.age_d,"  ว.")as age
                    ,o.height,o.bw
                    ,GROUP_CONCAT(DISTINCT(ia.icd10) ORDER BY ia.diagtype ASC)as total_diag
                    ,sum(i.adjrw)as sum_adjrw
                    ,sum(i.adjrw)/count(distinct(i.an)) as total_cmi
                    ,count(DISTINCT(ii.an))as total_noadjre 
                    FROM  ipt i
                    LEFT JOIN  an_stat a  on  i.an=a.an
                    LEFT JOIN  opdscreen o on  i.vn=o.vn
                    LEFT JOIN  iptdiag  ia  on i.an=ia.an
                    LEFT JOIN  icd101 ic  on  a.pdx=ic.`code`
                    LEFT JOIN  ward  w  on  i.ward=w.ward
                    LEFT JOIN  patient  p  on  i.hn=p.hn
                    LEFT JOIN  ipt  ii  on  i.an=ii.an  and  ii.adjrw = ""
                    LEFT JOIN  doctor  d  on  i.incharge_doctor=d.`code`
                    WHERE  i.dchdate  BETWEEN "'.$date_start_.'" AND "'.$date_end_.'"
                    -- AND i.incharge_doctor is null
                    AND i.incharge_doctor ="'.$doctor.'"
                    AND a.pdx="'.$pdx.'"
                    and a.age_y<="15"
                    GROUP BY  i.an  
                    ORDER BY i.dchdate DESC
            '); 
       
         
        return view('anc.prenatal_care_pdx',$data,[ 
            'dabyear'   => $dabyear,
            'doctor'    => $doctor,
        ]);
    }
    public function prenatal_care_an(Request $request,$pdx,$doctor,$dabyear)
    {
        // $dabyear = $request->dabyear;
        // $enddate = $request->enddate;
        $yearnew = date('Y')+1;
        $yearold = date('Y');
        $start = (''.$yearold.'-10-01');
        $end = (''.$yearnew.'-09-30'); 
        $budget_ = DB::table('budget_year')->where('leave_year_id','=', $dabyear)->first();
        $date_start_ = $budget_->date_begin;
        $date_end_   = $budget_->date_end;
        
        $data['dabyears'] = DB::table('budget_year')->get();
        if ($pdx == 'xxx') {
            $data['data_anc'] = DB::connection('mysql10')->select(' 
                SELECT i.an,i.hn,CONCAT(p.pname,p.fname," ",p.lname)as ptname,i.regdate,i.dchdate,a.admdate,CONCAT(a.age_y,"  ป.  ",a.age_m," ด."  ,a.age_d,"  ว.")as age
                    ,o.height,o.bw
                    ,GROUP_CONCAT(DISTINCT(ia.icd10) ORDER BY ia.diagtype ASC)as total_diag
                    ,sum(i.adjrw)as sum_adjrw
                    ,sum(i.adjrw)/count(distinct(i.an)) as total_cmi
                    ,count(DISTINCT(ii.an))as total_noadjre ,a.pdx
                    FROM  ipt i
                    LEFT JOIN  an_stat a  on  i.an=a.an
                    LEFT JOIN  opdscreen o on  i.vn=o.vn
                    LEFT JOIN  iptdiag  ia  on i.an=ia.an
                    LEFT JOIN  icd101 ic  on  a.pdx=ic.`code`
                    LEFT JOIN  ward  w  on  i.ward=w.ward
                    LEFT JOIN  patient  p  on  i.hn=p.hn
                    LEFT JOIN  ipt  ii  on  i.an=ii.an  and  ii.adjrw = ""
                    LEFT JOIN  doctor  d  on  i.incharge_doctor=d.`code`
                    WHERE  i.dchdate  BETWEEN "'.$date_start_.'" AND "'.$date_end_.'" 
                    AND i.incharge_doctor ="'.$doctor.'"
                    AND a.pdx =""
                    and a.age_y<="15"
                    GROUP BY  i.an  
                    ORDER BY i.dchdate DESC
            '); 
        } else {
            $data['data_anc'] = DB::connection('mysql10')->select(' 
                SELECT i.an,i.hn,CONCAT(p.pname,p.fname," ",p.lname)as ptname,i.regdate,i.dchdate,a.admdate,CONCAT(a.age_y,"  ป.  ",a.age_m," ด."  ,a.age_d,"  ว.")as age
                    ,o.height,o.bw
                    ,GROUP_CONCAT(DISTINCT(ia.icd10) ORDER BY ia.diagtype ASC)as total_diag
                    ,sum(i.adjrw)as sum_adjrw
                    ,sum(i.adjrw)/count(distinct(i.an)) as total_cmi
                    ,count(DISTINCT(ii.an))as total_noadjre ,a.pdx
                    FROM  ipt i
                    LEFT JOIN  an_stat a  on  i.an=a.an
                    LEFT JOIN  opdscreen o on  i.vn=o.vn
                    LEFT JOIN  iptdiag  ia  on i.an=ia.an
                    LEFT JOIN  icd101 ic  on  a.pdx=ic.`code`
                    LEFT JOIN  ward  w  on  i.ward=w.ward
                    LEFT JOIN  patient  p  on  i.hn=p.hn
                    LEFT JOIN  ipt  ii  on  i.an=ii.an  and  ii.adjrw = ""
                    LEFT JOIN  doctor  d  on  i.incharge_doctor=d.`code`
                    WHERE  i.dchdate  BETWEEN "'.$date_start_.'" AND "'.$date_end_.'" 
                    AND i.incharge_doctor ="'.$doctor.'"
                    AND a.pdx ="'.$pdx.'"
                    and a.age_y<="15"
                    GROUP BY  i.an  
                    ORDER BY i.dchdate DESC
            '); 
        }
        
            
       
         
        return view('anc.prenatal_care_an',$data,[ 
            'dabyear'   => $dabyear,
            'doctor'    => $doctor,
        ]);
    }

    public function prenatal_care_andiag(Request $request,$an)
    { 
        $yearnew = date('Y')+1;
        $yearold = date('Y');
        $start = (''.$yearold.'-10-01');
        $end = (''.$yearnew.'-09-30'); 
        // $budget_ = DB::table('budget_year')->where('leave_year_id','=', $dabyear)->first();
        // $date_start_ = $budget_->date_begin;
        // $date_end_   = $budget_->date_end;
     
                    $data['data_anc'] = DB::connection('mysql10')->select(' 
                            SELECT i.icd10,ic.name,ic.tname,i.diagtype FROM iptdiag i
                            LEFT JOIN  icd101 ic  on  i.icd10=ic.`code`
                            WHERE i.an="'.$an.'"
                            GROUP BY  i.icd10
                            ORDER BY i.diagtype  ASC
                            limit 1000
                        
                    ');  
         
        return view('anc.prenatal_care_andiag',$data,[ 
            // 'dabyear'   => $dabyear,
            // 'doctor'    => $doctor,
        ]);
    }

    public function prenatal_care_ankph(Request $request,$an)
    { 
        $yearnew = date('Y')+1;
        $yearold = date('Y');
        $start = (''.$yearold.'-10-01');
        $end = (''.$yearnew.'-09-30'); 
      
     
                    $data['data_anc'] = DB::connection('mysql10')->select(' 
                        SELECT principal_diagnosis
                        ,pre_admission_comorbidity
                        ,if(s.tracheostomy="Y","TRACHEOSTOMY","")as TRACHEOSTOMY
                        ,if(s.mechanical_ventilation="Y","MECHANICAL VENTILATION","") as MECHANICAL_VENTILATION  
                        ,if(s.mechanical_ventilation1="Y","มากกว่า 96 ชม.","")as "a96hra" 
                        ,if(s.mechanical_ventilation2="Y","น้อยกว่า 96 ชม.","")as "b96hrb" 
                        ,if(s.packed_redcells="Y","PACKED RED CELLS","")as PACKED_RED_CELLS
                        ,if(s.fresh_frozen_plasma="Y","PACKED RED CELLS","")as FRESH_FROZEN_PLASMA
                        ,if(s.platelets="Y","PLATELETS","")as PLATELETS
                        ,if(s.cryoprecipitate="Y","CRYOPRECIPITATE","")as CRYOPRECIPITATE
                        ,if(s.whole_blood="Y","Whole Blood","")as whole_blood
                        ,if(s.computer_tomography="Y","Computer Tomography","")as Computer_Tomography
                        ,s.computer_tomography_text 
                        ,if(s.chemotherapy="Y","CHEMOTHERAPY","")as CHEMOTHERAPY
                        ,if(s.mri="Y","MRI","")as MRI
                        ,if(s.hemodialysis="Y","Hemodialysis","")as Hemodialysis
                        ,if(s.non_or_other="Y","อื่น ๆ","")as outers
                        ,s.non_or_other_text
                        ,s.*
                        FROM  kphis.ipd_summary s 
                        where an = "'.$an.'"
                        
                    ');  
         
        return view('anc.prenatal_care_ankph',$data,[ 
            // 'dabyear'   => $dabyear,
            // 'doctor'    => $doctor,
        ]);
    }


    // public function prenatal_care_an(Request $request,$an)
    // {
        
    //     $data['dabyear'] = DB::table('budget_year')->get();
        
    //         $data['data_anc'] = DB::connection('mysql10')->select('   
                    
    //                 SELECT a.pdx,ic.`name` as namet,GROUP_CONCAT(DISTINCT(w.`name`)) as ward
    //                 ,count(distinct(i.an))as total_an
    //                 ,sum(i.adjrw)as sum_adjrw
    //                 ,sum(i.adjrw)/count(distinct(i.an)) as total_cmi
    //                 ,count(DISTINCT(ii.an))as total_noadjre 
    //                 FROM  ipt i
    //                 LEFT JOIN  an_stat a  on  i.an=a.an
    //                 LEFT JOIN  icd101 ic  on  a.pdx=ic.`code`
    //                 LEFT JOIN  ward  w  on  i.ward=w.ward
    //                 #LEFT JOIN  ward_backup1872566  ww on  i.ward=ww.ward
    //                 LEFT JOIN  ipt  ii  on  i.an=ii.an  and  ii.adjrw =""
    //                 LEFT JOIN  doctor  d  on  i.incharge_doctor=d.`code`
    //                 WHERE  i.dchdate  BETWEEN "'.$date_start_.'" AND "'.$date_end_.'"
    //                 AND i.incharge_doctor="'.$doctor.'"
    //                 and a.age_y<="15"
    //                 GROUP BY  a.pdx
    //         '); 
       
         
    //     return view('anc.prenatal_care_an',$data,[ 
    //     ]);
    // }

    public function prenatal_care_sub(Request $request,$ward,$startdate,$enddate)
    {  
            $data['data_anc'] = DB::connection('mysql2')->select('   
                SELECT  d.name as doctor,w.ward,w.`name` as wardname
                    ,count(distinct(i.an))as total_an
                    ,sum(i.adjrw)as sum_adjrw
                    ,sum(i.adjrw)/count(distinct(i.an)) as total_cmi
                    ,count(DISTINCT(ii.an))as total_noadjre 
                    FROM  ipt i
                    LEFT JOIN an_stat a on  i.an=a.an
                    LEFT JOIN ward w on i.ward=w.ward
                    LEFT JOIN doctor d on i.incharge_doctor=d.`code`
                    #LEFT JOIN ward_backup1872566 ww on i.ward=ww.ward
                    LEFT JOIN ipt ii on i.an=ii.an and ii.adjrw = ""

                    WHERE 
                    i.ward = "'.$ward.'"
                    AND i.dchdate  BETWEEN "'.$startdate.'" AND "'.$enddate.'"
                    GROUP BY  i.incharge_doctor
 
            '); 
         
         
        return view('anc.prenatal_care_sub',$data,[
            'startdate'   => $startdate,
            'enddate'     => $enddate, 
        ]);
    }

    public function prenatal_care_bar(Request $request)
    {
        $dabyear = $request->dabyear;
       

        if ($dabyear != '') {
            $budget_ = DB::table('budget_year')->where('leave_year_id','=', $dabyear)->first();
            $date_start_ = $budget_->date_begin;
            $date_end_   = $budget_->date_end;
            $chart = DB::connection('mysql2')->select(' 
                SELECT i.incharge_doctor,d.`name` as doctor
                    ,count(distinct(i.an))as total_an
                    ,sum(i.adjrw)as sum_adjrw
                    ,sum(i.adjrw)/count(distinct(i.an)) as total_cmi
                    ,count(DISTINCT(ii.an))as total_noadjre,month(i.dchdate) as month,year(i.dchdate) as year
                    FROM  ipt i
                    LEFT JOIN  an_stat a  on  i.an=a.an
                    LEFT JOIN  ward  w  on  i.ward=w.ward 
                    LEFT JOIN  ipt  ii  on  i.an=ii.an  and  ii.adjrw = ""
                    LEFT JOIN  doctor  d  on  i.incharge_doctor=d.code
                    WHERE  i.dchdate BETWEEN "'.$date_start_.'" AND "'.$date_end_.'"
                    and a.age_y<="15"
                    GROUP BY  i.incharge_doctor, month
 
            ');
        } else {
            $y = date('Y')+543;
        
            $budget_ = DB::table('budget_year')->where('leave_year_id','=', $y)->first();
            $date_start2_ = $budget_->date_begin;
            $date_end2_   = $budget_->date_end;
            // dd( $y);
            $chart = DB::connection('mysql2')->select(' 
                SELECT i.incharge_doctor,d.`name` as doctor
                    ,count(distinct(i.an))as total_an
                    ,sum(i.adjrw)as sum_adjrw
                    ,sum(i.adjrw)/count(distinct(i.an)) as total_cmi
                    ,count(DISTINCT(ii.an))as total_noadjre
                    ,month(i.dchdate) as month,year(i.dchdate) as year
                    FROM  ipt i
                    LEFT JOIN  an_stat a  on  i.an=a.an
                    LEFT JOIN  ward  w  on  i.ward=w.ward 
                    LEFT JOIN  ipt  ii  on  i.an=ii.an  and  ii.adjrw = ""
                    LEFT JOIN  doctor  d  on  i.incharge_doctor=d.code
                    WHERE  i.dchdate BETWEEN "'.$date_start2_.'" AND "'.$date_end2_.'"
                    and a.age_y<="15"
                    GROUP BY  i.incharge_doctor, month
 
            ');
            
        }
         
   
        $labels = [
          1 => "ม.ค", "ก.พ", "มี.ค", "เม.ย", "พ.ย", "มิ.ย", "ก.ค","ส.ค","ก.ย","ต.ค","พ.ย","ธ.ค"
        ];
         $count_total_noadjre = $count_an = $total_cmi =$sum_adjrw = [];

        foreach ($chart as $key => $chartitems) {
            $count_an[$chartitems->month] = $chartitems->total_an;
            $count_total_noadjre[$chartitems->month] = $chartitems->total_noadjre;
            $total_cmi[$chartitems->month] = $chartitems->total_cmi;
            $sum_adjrw[$chartitems->month] = $chartitems->sum_adjrw;
        }
        foreach ($labels as $month => $name) {
           if (!array_key_exists($month,$count_an)) {
            $count_an[$month] = 0;
           }
           if (!array_key_exists($month,$count_total_noadjre)) {
            $count_total_noadjre[$month] = 0;
           }
           if (!array_key_exists($month,$total_cmi)) {
            $total_cmi[$month] = 0;
           }
           if (!array_key_exists($month,$sum_adjrw)) {
            $sum_adjrw[$month] = 0;
           }
        }
        ksort($count_an);
        ksort($count_total_noadjre);
        ksort($total_cmi);
        ksort($sum_adjrw);

        return [
            'labels'          =>  array_values($labels),
            'datasets'     =>  [
                [
                    'label'           =>  'total_cmi',
                    'borderColor'     => 'rgba(255, 205, 86 , 1)',
                    'backgroundColor' => 'rgba(255, 205, 86 , 0.2)',
                    'borderWidth'     => '1',
                    'barPercentage'   => '0.9',
                    'data'            =>  array_values($total_cmi)
                ],
                [
                    'label'           =>  'total_noadjre',
                    'borderColor'     => 'rgba(75, 192, 192, 1)',
                    'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                    'borderWidth'     => '1',
                    'barPercentage'   => '0.9',
                    'data'            => array_values($sum_adjrw)
                ],
                // [
                //     'label'           =>  'ไม่ขอ Authen',
                //     'borderColor'     => 'rgba(255, 99, 132, 1)',
                //     'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                //     'borderWidth'     => '1',
                //     'barPercentage'   => '0.9',
                //     'data'            => array_values($total_cmi)
                // ],
            ],
        ];      
    }
   
     

}
