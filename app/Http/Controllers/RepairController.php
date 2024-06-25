<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Person;
use App\Models\Informrepairindex;
use App\Models\Informcomrepair;
use App\Models\Assetcarerepair;
use App\Models\Informrepairother;
use App\Models\Infomrepair_functionnormal;
use App\Models\Infomrepair_functioncom;
use App\Models\Infomrepair_functionmedical;

date_default_timezone_set("Asia/Bangkok");

class RepairController extends Controller
{
   
    public function infoindex(Request $request,$iduser)
    {
        $inforpersonuserid =  Person::where('ID','=',$iduser)->first();
        $id = $inforpersonuserid->ID;

        
        $inforpersonuser=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_sex','hrd_person.SEX','=','hrd_sex.SEX_ID')
        ->leftJoin('hrd_status','hrd_person.HR_STATUS_ID','=','hrd_status.HR_STATUS_ID')
        ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
        ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->leftJoin('hrd_department','hrd_person.HR_DEPARTMENT_ID','=','hrd_department.HR_DEPARTMENT_ID')
        ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
        ->leftJoin('hrd_bloodgroup','hrd_person.HR_BLOODGROUP_ID','=','hrd_bloodgroup.HR_BLOODGROUP_ID')
        ->leftJoin('hrd_marry_status','hrd_person.HR_MARRY_STATUS_ID','=','hrd_marry_status.HR_MARRY_STATUS_ID')
        ->leftJoin('hrd_religion','hrd_person.HR_RELIGION_ID','=','hrd_religion.HR_RELIGION_ID')
        ->leftJoin('hrd_nationality','hrd_person.HR_NATIONALITY_ID','=','hrd_nationality.HR_NATIONALITY_ID')
        ->leftJoin('hrd_citizenship','hrd_person.HR_CITIZENSHIP_ID','=','hrd_citizenship.HR_CITIZENSHIP_ID')
        ->leftJoin('hrd_tumbon','hrd_person.TUMBON_ID','=','hrd_tumbon.ID')
        ->leftJoin('hrd_amphur','hrd_person.AMPHUR_ID','=','hrd_amphur.ID')
        ->leftJoin('hrd_province','hrd_person.PROVINCE_ID','=','hrd_province.ID')
        ->leftJoin('hrd_kind','hrd_person.HR_KIND_ID','=','hrd_kind.HR_KIND_ID')
        ->leftJoin('hrd_kind_type','hrd_person.HR_KIND_TYPE_ID','=','hrd_kind_type.HR_KIND_TYPE_ID')
        ->leftJoin('hrd_person_type','hrd_person.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
        ->where('hrd_person.ID','=',$iduser)->first();

 


        return view('general_repair.geninforepairindex',[
            'inforpersonuser' => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid, 
         
            
        ]);
    }



    public function infotype(Request $request,$iduser)
    {
        $inforpersonuserid =  Person::where('ID','=',$iduser)->first();
        $id = $inforpersonuserid->ID;
 
        $inforpersonuser=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_sex','hrd_person.SEX','=','hrd_sex.SEX_ID')
        ->leftJoin('hrd_status','hrd_person.HR_STATUS_ID','=','hrd_status.HR_STATUS_ID')
        ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
        ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->leftJoin('hrd_department','hrd_person.HR_DEPARTMENT_ID','=','hrd_department.HR_DEPARTMENT_ID')
        ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
        ->leftJoin('hrd_bloodgroup','hrd_person.HR_BLOODGROUP_ID','=','hrd_bloodgroup.HR_BLOODGROUP_ID')
        ->leftJoin('hrd_marry_status','hrd_person.HR_MARRY_STATUS_ID','=','hrd_marry_status.HR_MARRY_STATUS_ID')
        ->leftJoin('hrd_religion','hrd_person.HR_RELIGION_ID','=','hrd_religion.HR_RELIGION_ID')
        ->leftJoin('hrd_nationality','hrd_person.HR_NATIONALITY_ID','=','hrd_nationality.HR_NATIONALITY_ID')
        ->leftJoin('hrd_citizenship','hrd_person.HR_CITIZENSHIP_ID','=','hrd_citizenship.HR_CITIZENSHIP_ID')
        ->leftJoin('hrd_tumbon','hrd_person.TUMBON_ID','=','hrd_tumbon.ID')
        ->leftJoin('hrd_amphur','hrd_person.AMPHUR_ID','=','hrd_amphur.ID')
        ->leftJoin('hrd_province','hrd_person.PROVINCE_ID','=','hrd_province.ID')
        ->leftJoin('hrd_kind','hrd_person.HR_KIND_ID','=','hrd_kind.HR_KIND_ID')
        ->leftJoin('hrd_kind_type','hrd_person.HR_KIND_TYPE_ID','=','hrd_kind_type.HR_KIND_TYPE_ID')
        ->leftJoin('hrd_person_type','hrd_person.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
        ->where('hrd_person.ID','=',$iduser)->first();


        return view('general_repair.genrepairtype',[
            'inforpersonuser' => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid, 
         
            
        ]);
    }

  //-------------------ซ่อมทั่วไป
    public function inforepairnomal(Request $request,$iduser)
    {
        $inforpersonuserid =  Person::where('ID','=',$iduser)->first();
        $id = $inforpersonuserid->ID;

        
        $inforpersonuser=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_sex','hrd_person.SEX','=','hrd_sex.SEX_ID')
        ->leftJoin('hrd_status','hrd_person.HR_STATUS_ID','=','hrd_status.HR_STATUS_ID')
        ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
        ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->leftJoin('hrd_department','hrd_person.HR_DEPARTMENT_ID','=','hrd_department.HR_DEPARTMENT_ID')
        ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
        ->leftJoin('hrd_bloodgroup','hrd_person.HR_BLOODGROUP_ID','=','hrd_bloodgroup.HR_BLOODGROUP_ID')
        ->leftJoin('hrd_marry_status','hrd_person.HR_MARRY_STATUS_ID','=','hrd_marry_status.HR_MARRY_STATUS_ID')
        ->leftJoin('hrd_religion','hrd_person.HR_RELIGION_ID','=','hrd_religion.HR_RELIGION_ID')
        ->leftJoin('hrd_nationality','hrd_person.HR_NATIONALITY_ID','=','hrd_nationality.HR_NATIONALITY_ID')
        ->leftJoin('hrd_citizenship','hrd_person.HR_CITIZENSHIP_ID','=','hrd_citizenship.HR_CITIZENSHIP_ID')
        ->leftJoin('hrd_tumbon','hrd_person.TUMBON_ID','=','hrd_tumbon.ID')
        ->leftJoin('hrd_amphur','hrd_person.AMPHUR_ID','=','hrd_amphur.ID')
        ->leftJoin('hrd_province','hrd_person.PROVINCE_ID','=','hrd_province.ID')
        ->leftJoin('hrd_kind','hrd_person.HR_KIND_ID','=','hrd_kind.HR_KIND_ID')
        ->leftJoin('hrd_kind_type','hrd_person.HR_KIND_TYPE_ID','=','hrd_kind_type.HR_KIND_TYPE_ID')
        ->leftJoin('hrd_person_type','hrd_person.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
        ->where('hrd_person.ID','=',$iduser)->first();

           $inforepairnomal = Informrepairindex::where('REPAIR_STATUS','=','REQUEST')
            ->orderBy('ID', 'desc')->get(); 

            $infostatus = DB::table('informrepair_status')->get();

        
            
            $m_budget = date("m");
            if($m_budget>9){
            $yearbudget = date("Y")+544;
            }else{
            $yearbudget = date("Y")+543;
            }
            
            $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
            $displaydate_bigen = ($yearbudget-544).'-10-01';
            $displaydate_end = ($yearbudget-543).'-09-30';
            $status = 'REQUEST';
            $search = '';
            $year_id = $yearbudget;

            $openform_function = Infomrepair_functionnormal::where('FUNCT_REPNORMAL_STATUS','=','True' )->first();

            if ($openform_function != '') {       
                $code = $openform_function->FUNCT_REPNORMAL_CODE;  
            } else {                      
                $code = '';
            }
                                                                                                                                                    
        return view('general_repair.inforepairnomal',[
            'inforepairnomals' => $inforepairnomal,
            'inforpersonuser' => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid, 
            'infostatuss' => $infostatus, 
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'budgets' =>  $budget,
            'codes'=>$code,
            'year_id'=>$year_id
         
            
        ]);
    }



    public function inforepairnomalsearch(Request $request,$iduser)
    {

        $inforpersonuserid =  Person::where('ID','=',$iduser)->first();
        $id = $inforpersonuserid->ID;

        
        $inforpersonuser=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_sex','hrd_person.SEX','=','hrd_sex.SEX_ID')
        ->leftJoin('hrd_status','hrd_person.HR_STATUS_ID','=','hrd_status.HR_STATUS_ID')
        ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
        ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->leftJoin('hrd_department','hrd_person.HR_DEPARTMENT_ID','=','hrd_department.HR_DEPARTMENT_ID')
        ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
        ->leftJoin('hrd_bloodgroup','hrd_person.HR_BLOODGROUP_ID','=','hrd_bloodgroup.HR_BLOODGROUP_ID')
        ->leftJoin('hrd_marry_status','hrd_person.HR_MARRY_STATUS_ID','=','hrd_marry_status.HR_MARRY_STATUS_ID')
        ->leftJoin('hrd_religion','hrd_person.HR_RELIGION_ID','=','hrd_religion.HR_RELIGION_ID')
        ->leftJoin('hrd_nationality','hrd_person.HR_NATIONALITY_ID','=','hrd_nationality.HR_NATIONALITY_ID')
        ->leftJoin('hrd_citizenship','hrd_person.HR_CITIZENSHIP_ID','=','hrd_citizenship.HR_CITIZENSHIP_ID')
        ->leftJoin('hrd_tumbon','hrd_person.TUMBON_ID','=','hrd_tumbon.ID')
        ->leftJoin('hrd_amphur','hrd_person.AMPHUR_ID','=','hrd_amphur.ID')
        ->leftJoin('hrd_province','hrd_person.PROVINCE_ID','=','hrd_province.ID')
        ->leftJoin('hrd_kind','hrd_person.HR_KIND_ID','=','hrd_kind.HR_KIND_ID')
        ->leftJoin('hrd_kind_type','hrd_person.HR_KIND_TYPE_ID','=','hrd_kind_type.HR_KIND_TYPE_ID')
        ->leftJoin('hrd_person_type','hrd_person.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
        ->where('hrd_person.ID','=',$iduser)->first();

        $search = $request->get('search');
        $status = $request->SEND_STATUS;
        $datebigin = $request->get('DATE_BIGIN');
        $dateend = $request->get('DATE_END');
        $yearbudget = $request->BUDGET_YEAR;

        if($search==''){
            $search="";
        }
 
        $date_bigen_c = Carbon::createFromFormat('d/m/Y', $datebigin)->format('Y-m-d');
        $date_arrary=explode("-",$date_bigen_c);
        $y_sub_st = $date_arrary[0];

        if($y_sub_st >= 2500){
            $y = $y_sub_st-543;
        }else{
            $y = $y_sub_st;
        }

        $m = $date_arrary[1];
        $d = $date_arrary[2];  
        $displaydate_bigen= $y."-".$m."-".$d;
  
        $date_end_c = Carbon::createFromFormat('d/m/Y', $dateend)->format('Y-m-d');
        $date_arrary_e=explode("-",$date_end_c); 

        $y_sub_e = $date_arrary_e[0];

        if($y_sub_e >= 2500){
            $y_e = $y_sub_e-543;
        }else{
            $y_e = $y_sub_e;
        }
        $m_e = $date_arrary_e[1];
        $d_e = $date_arrary_e[2];  
        $displaydate_end= $y_e."-".$m_e."-".$d_e;

           $from = date($displaydate_bigen);
           $to = date($displaydate_end);   
                      
            if($status == null){

                $inforepairnomal = Informrepairindex::where(function($q) use ($search){
                    $q->where('REPAIR_ID','like','%'.$search.'%');
                    $q->orwhere('REPAIR_NAME','like','%'.$search.'%');
                    $q->orwhere('SYMPTOM','like','%'.$search.'%');
                    $q->orwhere('USRE_REQUEST_NAME','like','%'.$search.'%');
                    })
                    ->WhereBetween('DATE_TIME_REQUEST',[$from.' 00:00:00',$to.' 23:59:00']) 
                ->orderBy('ID', 'desc')->get(); 

            }else{

                $inforepairnomal = Informrepairindex::where('REPAIR_STATUS','=',$status)
                ->where(function($q) use ($search){
                    $q->where('REPAIR_ID','like','%'.$search.'%');
                    $q->orwhere('REPAIR_NAME','like','%'.$search.'%');
                    $q->orwhere('SYMPTOM','like','%'.$search.'%');
                    $q->orwhere('USRE_REQUEST_NAME','like','%'.$search.'%');
                    })
                    ->WhereBetween('DATE_TIME_REQUEST',[$from.' 00:00:00',$to.' 23:59:00']) 
                ->orderBy('ID', 'desc')->get(); 
                        
            }
  
        $infostatus = DB::table('informrepair_status')->get();

        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $year_id = $yearbudget;

        $openform_function = Infomrepair_functionnormal::where('FUNCT_REPNORMAL_STATUS','=','True' )->first();

        // dd($openform_function->FUNCT_REPNORMAL_CODE);
        if ($openform_function != '') {       
            $code = $openform_function->FUNCT_REPNORMAL_CODE;  
        } else {                      
            $code = '';
            // dd($code);
        }
        
        return view('general_repair.inforepairnomal',[
            'inforepairnomals' => $inforepairnomal,
            'inforpersonuser' => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid, 
            'infostatuss' => $infostatus, 
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'codes'=>$code,
            'year_id'=>$year_id, 
                
        ]);

    }


public function detailrepairnomal(Request $request)
{
    function DateThai($strDate)
    {
        $strYear = date("Y",strtotime($strDate))+543;
        $strMonth= date("n",strtotime($strDate));
        $strDay= date("j",strtotime($strDate));

        $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
        $strMonthThai=$strMonthCut[$strMonth];
    return "$strDay $strMonthThai $strYear";
    }

    function formateDatetime($strDate)
    {
        $strYear = date("Y",strtotime($strDate))+543;
        $strMonth= date("n",strtotime($strDate));
        $strDay= date("j",strtotime($strDate));
    
        $H= date("H",strtotime($strDate));
        $I= date("i",strtotime($strDate));
  
        $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
        $strMonthThai=$strMonthCut[$strMonth];
  
    return  "$strDay $strMonthThai $strYear $H:$I";
      }

    $inforepairnomal = Informrepairindex::where('informrepair_index.ID','=',$request->id)
        ->leftjoin('informrepair_priority','informrepair_priority.PRIORITY_ID','=','informrepair_index.PRIORITY_ID')
        ->leftjoin('hrd_person','informrepair_index.USER_REQUEST_ID','=','hrd_person.ID')
        ->leftjoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_SUB_ID')
        ->leftjoin('asset_article','informrepair_index.ARTICLE_ID','=','asset_article.ARTICLE_ID')
        ->leftjoin('asset_building','informrepair_index.LOCATION_SEE_ID','=','asset_building.ID')
        ->leftjoin('supplies_location_level','informrepair_index.LOCATIONLEVEL_SEE_ID','=','supplies_location_level.LOCATION_LEVEL_ID')
        ->leftjoin('supplies_location_level_room','informrepair_index.LOCATIONLEVELROOM_SEE_ID','=','supplies_location_level_room.LEVEL_ROOM_ID')

        ->first(); 
    
    $output='    

    <div class="row push" style="font-family: \'Kanit\', sans-serif;">

    <div class="col-sm-9">

  <div class="row">
      <div class="col-lg-2" align="right">
      <label>เลขที่ส่ง :</label>
      </div> 
      <div class="col-lg-8" align="left">
      '.$inforepairnomal->REPAIR_ID.'
      </div> 
  </div>    
  <div class="row">
      <div class="col-lg-2" align="right">
      <label>วันที่แจ้ง :</label>
      </div> 
      <div class="col-lg-4" align="left">
      '.formateDatetime($inforepairnomal->DATE_TIME_REQUEST).'
      </div> 
      <div class="col-lg-2" align="right">
      <label>อาคาร :</label>
      </div> 
      <div class="col-lg-4" align="left">
      '.$inforepairnomal->BUILD_NAME.'
      </div> 
  </div>    
  
  <div class="row">
      <div class="col-lg-2" align="right">
      <label>ชั้น :</label>
      </div> 
      <div class="col-lg-4" align="left">     
      '.$inforepairnomal->LOCATION_LEVEL_NAME.'
      </div> 
      <div class="col-lg-2" align="right">
      <label>ห้อง :</label>
      </div> 
      <div class="col-lg-4" align="left">
      '.$inforepairnomal->LEVEL_ROOM_NAME.'
      </div> 
 
  </div>    

    <div class="row">
        <div class="col-lg-2" align="right">
        <label>แจ้งซ่อม :</label>
        </div> 
        <div class="col-lg-8" align="left">
        '.$inforepairnomal->REPAIR_NAME.'
        </div> 
    </div>  
        

    <div class="row">
        <div class="col-lg-2" align="right">
        <label>รหัสครุภัณฑ์ :</label>
        </div> 
        <div class="col-lg-4" align="left">
            '.$inforepairnomal->ARTICLE_NUM.'
        </div> 
        <div class="col-lg-2" align="right">
        <label>ชื่อครุภัณฑ์ :</label>
        </div> 
        <div class="col-lg-4" align="left">
        '.$inforepairnomal->ARTICLE_NAME.'
        </div> 
    </div>  






    <div class="row">
            <div class="col-lg-2" align="right">
            <label>อาการ :</label>
            </div> 
            <div class="col-lg-10" align="left">
            '.$inforepairnomal->SYMPTOM.'
            </div> 

            </div>  

            <div class="row">
            <div class="col-lg-2" align="right">
            <label>ความเร่งด่วน :</label>
            </div> 
            <div class="col-lg-6" align="left">
            '.$inforepairnomal->PRIORITY_NAME.'
            </div> 
    </div>   

    <div class="row">
    <div class="col-lg-2" align="right">
    <label>ผู้แจ้งซ่อม :</label>
    </div> 
    <div class="col-lg-4" align="left">
    '.$inforepairnomal->USRE_REQUEST_NAME.'
    </div>
    <div class="col-lg-2" align="right">
    <label>ฝ่าย/แผนก  :</label>
    </div> 
    <div class="col-lg-4" align="left">
    '.$inforepairnomal->HR_DEPARTMENT_SUB_SUB_NAME.'
    </div>  
    </div>     
  

    <div class="row">
    <div class="col-lg-2" align="right">
    <label>รายละเอียดซ่อม  :</label>
    </div> 
    <div class="col-lg-10" align="left">
    '.$inforepairnomal->REPAIR_COMMENT.'
    </div>
    
    </div>     
    </div>

    <div class="col-sm-3">

    <div class="form-group">

    <img src="data:image/png;base64,'. chunk_split(base64_encode($inforepairnomal->REPAIR_IMG)) .'" id="image_upload_preview" alt="กรุณาเพิ่มรูปภาพ" height="200" width="200"/>
    </div>
    </div>
    </div>
    </div>

    </div>

    ';

    echo $output;

}
  //-------------------

    //---------------------------เพิ่มข้อมูลงานซ่อมทัวไป------------------------------


    public function createinforepairnomal (Request $request,$iduser)
    {
        //$email = Auth::user()->email;
        $inforpersonuserid =  Person::where('ID','=',$iduser)->first();
        $id = $inforpersonuserid->ID;

        
        $inforpersonuser=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_sex','hrd_person.SEX','=','hrd_sex.SEX_ID')
        ->leftJoin('hrd_status','hrd_person.HR_STATUS_ID','=','hrd_status.HR_STATUS_ID')
        ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
        ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->leftJoin('hrd_department','hrd_person.HR_DEPARTMENT_ID','=','hrd_department.HR_DEPARTMENT_ID')
        ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
        ->leftJoin('hrd_bloodgroup','hrd_person.HR_BLOODGROUP_ID','=','hrd_bloodgroup.HR_BLOODGROUP_ID')
        ->leftJoin('hrd_marry_status','hrd_person.HR_MARRY_STATUS_ID','=','hrd_marry_status.HR_MARRY_STATUS_ID')
        ->leftJoin('hrd_religion','hrd_person.HR_RELIGION_ID','=','hrd_religion.HR_RELIGION_ID')
        ->leftJoin('hrd_nationality','hrd_person.HR_NATIONALITY_ID','=','hrd_nationality.HR_NATIONALITY_ID')
        ->leftJoin('hrd_citizenship','hrd_person.HR_CITIZENSHIP_ID','=','hrd_citizenship.HR_CITIZENSHIP_ID')
        ->leftJoin('hrd_tumbon','hrd_person.TUMBON_ID','=','hrd_tumbon.ID')
        ->leftJoin('hrd_amphur','hrd_person.AMPHUR_ID','=','hrd_amphur.ID')
        ->leftJoin('hrd_province','hrd_person.PROVINCE_ID','=','hrd_province.ID')
        ->leftJoin('hrd_kind','hrd_person.HR_KIND_ID','=','hrd_kind.HR_KIND_ID')
        ->leftJoin('hrd_kind_type','hrd_person.HR_KIND_TYPE_ID','=','hrd_kind_type.HR_KIND_TYPE_ID')
        ->leftJoin('hrd_person_type','hrd_person.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
        ->where('hrd_person.ID','=',$iduser)->first();

         $infoasset = DB::table('asset_article')->where('DECLINE_ID','<>',17)->where('DECLINE_ID','<>',18)->get(); 


         $infolocation = DB::table('supplies_location')->get();
         $infolocationlevel = DB::table('supplies_location_level')->get();
         $infolocationlevelroom = DB::table('supplies_location_level_room')->get();

         $informrepair_tech = DB::table('informrepair_tech')
         ->leftJoin('hrd_person','hrd_person.ID','=','informrepair_tech.PERSON_ID')
         ->get();

         $infotypesystem = DB::table('informrepair_systemtype')->get();


        return view('general_repair.inforepairnomal_add',[
            'infoassets' => $infoasset,
            'inforpersonuser' => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid,
            'infolocations' => $infolocation,
            'infolocationlevels' => $infolocationlevel,
            'infolocationlevelrooms' => $infolocationlevelroom, 
            'informrepair_techs' => $informrepair_tech,
            'infotypesystems' => $infotypesystem,
         
            
        ]);
    }

   
    public function saveinforepairnomal(Request $request)
    {
        // $request->validate([
        //     'REPAIR_NAME' => 'required',
        //     'LOCATION_SEE_ID' => 'required',
        //     'LOCATIONLEVEL_SEE_ID' => 'required',
        //     'LOCATIONLEVELROOM_SEE_ID' => 'required',
        //     'SYMPTOM' => 'required',
        //     'TECH_REPAIR_ID' => 'required',
        // ]);

        // dd($request);

       $DATE_1 = $request->DATE_REQUEST;

       if($DATE_1 != ''){
        $STARTDAY = Carbon::createFromFormat('d/m/Y', $DATE_1)->format('Y-m-d');
        $date_arrary_st=explode("-",$STARTDAY);  
        $y_sub_st = $date_arrary_st[0]; 
        
        if($y_sub_st >= 2500){
            $y_st = $y_sub_st-543;
        }else{
            $y_st = $y_sub_st;
        }
        $m_st = $date_arrary_st[1];
        $d_st = $date_arrary_st[2];  
        $DATE_1= $y_st."-".$m_st."-".$d_st;
        }else{
        $DATE_1= null;
    }
     
            $datere = $DATE_1." ".$request->TIME_REQUEST.":00";
      //------------------------------------------------------------------
            $m = date('m');
            if($m > 9 && $m < 12 ){
                $YEAR_ID = date('Y')+544;
            }else{
                $YEAR_ID = date('Y')+543;
            }
             
           
            //===================================
                    $year = date('Y');
                    $maxnumber = DB::table('informrepair_index')->where('DATE_TIME_REQUEST','like',$year.'%')->max('ID');  
                    if($maxnumber != '' ||  $maxnumber != null){                        
                            $refmax = DB::table('informrepair_index')->where('ID','=',$maxnumber)->first();  
                        if($refmax->REPAIR_ID != '' ||  $refmax->REPAIR_ID != null){
                            $maxref = substr($refmax->REPAIR_ID, -4)+1;
                        }else{
                            $maxref = 1;
                        }
                        $ref = str_pad($maxref, 5, "0", STR_PAD_LEFT);
                    }else{
                        $ref = '00001';
                    }

                    $ye = date('Y')+543;
                    $y = substr($ye, -2);
                    $refnumber ='R'.$y.'-'.$ref;

            //===================================

            $addinforepair = new Informrepairindex(); 
            $addinforepair->REPAIR_ID =  $refnumber;
            $addinforepair->YEAR_ID =  $YEAR_ID;

            $addinforepair->DATE_TIME_REQUEST = $datere;

               $addinforepair->USER_REQUEST_ID = $request->USER_REQUEST_ID;

               //----------------------------------
               $USRE_REQUEST_NAME =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
               ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
               ->where('hrd_person.ID','=',$request->USER_REQUEST_ID)->first();
               $addinforepair->USRE_REQUEST_NAME   = $USRE_REQUEST_NAME->HR_PREFIX_NAME.''.$USRE_REQUEST_NAME->HR_FNAME.' '.$USRE_REQUEST_NAME->HR_LNAME;
   
               //----------------------------------

            $addinforepair->REPAIR_NAME = $request->REPAIR_NAME;


            $addinforepair->LOCATION_SEE_ID = $request->LOCATION_SEE_ID;
            $addinforepair->LOCATIONLEVEL_SEE_ID = $request->LOCATIONLEVEL_SEE_ID;
            $addinforepair->LOCATIONLEVELROOM_SEE_ID = $request->LOCATIONLEVELROOM_SEE_ID;

            if($request->ARTICLE_ID != ''){ 
                $addinforepair->ARTICLE_ID = $request->ARTICLE_ID;
                }


            $addinforepair->OTHER_NAME = $request->OTHER_NAME;

        
            
         if($request->hasFile('picture')){
            //$newFileName = $picid.'.'.$request->picture->extension();
            
            $file = $request->file('picture');  
            $contents = $file->openFile()->fread($file->getSize());
            $addinforepair->REPAIR_IMG = $contents;   
            //$request->picture->storeAs('images',$newFileName,'public');
            //$inforpersonedit->HR_IMAGE_NAME = $newFileName; 
        }
       
        $addinforepair->SYMPTOM = $request->SYMPTOM;
        $addinforepair->TECH_REPAIR_ID = $request->TECH_REPAIR_ID;


        if($request->TECH_REPAIR_ID != 'not'){
            //----------------------------------
            $TECH_REPAIR_NAME =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
            ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
            ->where('hrd_person.ID','=',$request->TECH_REPAIR_ID)->first();
            $addinforepair->TECH_REPAIR_NAME   = $TECH_REPAIR_NAME->HR_PREFIX_NAME.''.$TECH_REPAIR_NAME->HR_FNAME.' '.$TECH_REPAIR_NAME->HR_LNAME;

            //----------------------------------
        }
        $addinforepair->PRIORITY_ID = $request->PRIORITY_ID;
        $addinforepair->REPAIR_SYSTEM = $request->REPAIR_SYSTEM;
        $addinforepair->REPAIR_STATUS = 'REQUEST';
        $addinforepair->save();

             // dd($addinfocar);



                  
             
            $header = "ระบบแจ้งซ่อมทั่วไป";
            $REPAIRID = $request->REPAIR_ID;
            $REPAIRNAME = $request->REPAIR_NAME; 
            $SYMPTOM = $request->SYMPTOM;  
            $USREREQUESTNAME = $USRE_REQUEST_NAME->HR_PREFIX_NAME.''.$USRE_REQUEST_NAME->HR_FNAME.' '.$USRE_REQUEST_NAME->HR_LNAME;
           
            if($request->TECH_REPAIR_ID == 'not'){
                $TECHREPAIRNAME   = '';
            }else{
                $TECHREPAIRNAME   = $TECH_REPAIR_NAME->HR_PREFIX_NAME.''.$TECH_REPAIR_NAME->HR_FNAME.' '.$TECH_REPAIR_NAME->HR_LNAME;
            }
          
            
            if($request->ARTICLE_ID != ''){
                    $ARTICLE_ID = $request->ARTICLE_ID;
                }else{
                    $ARTICLE_ID = '';   
                }

             
                 
                $infolocation = DB::table('supplies_location')->where('LOCATION_ID','=',$request->LOCATION_SEE_ID)->first();
                $LOCATION_SEE_NAME = $infolocation->LOCATION_NAME;

                $infolocationlevel = DB::table('supplies_location_level')->where('LOCATION_LEVEL_ID','=',$request->LOCATIONLEVEL_SEE_ID)->first();
                $LOCATIONLEVEL_SEE_NAME = $infolocationlevel->LOCATION_LEVEL_NAME;

                $infolocationlevelroom = DB::table('supplies_location_level_room')->where('LEVEL_ROOM_ID','=',$request->LOCATIONLEVELROOM_SEE_ID)->first();
                $LOCATIONLEVELROOM_SEE_NAME = $infolocationlevelroom->LEVEL_ROOM_NAME;

                $infoinformrepairpriority = DB::table('informrepair_priority')->where('PRIORITY_ID','=',$request->PRIORITY_ID)->first();
                $PRIORITY_NAME = $infoinformrepairpriority->PRIORITY_NAME;

                $infohrddepartmentsubsub = DB::table('hrd_department_sub_sub')->where('HR_DEPARTMENT_SUB_SUB_ID','=',$USRE_REQUEST_NAME->HR_DEPARTMENT_SUB_SUB_ID)->first();   
                $HR_DEPARTMENT_SUB_SUB_NAME = $infohrddepartmentsubsub->HR_DEPARTMENT_SUB_SUB_NAME;

            $message = $header.
                "\n"."รหัส : " . $REPAIRID .
                "\n"."แจ้งซ่อม : " . $REPAIRNAME .
                "\n"."ครุภัณฑ์ : " . $ARTICLE_ID .
                "\n"."อาการ : " . $SYMPTOM .  
                "\n"."สถานที่พบ : " . $LOCATION_SEE_NAME .
                "\n"."ชั้น : " . $LOCATIONLEVEL_SEE_NAME .
                "\n"."ห้อง : " . $LOCATIONLEVELROOM_SEE_NAME .
                "\n"."ความเร่งด่วน : " . $PRIORITY_NAME .           
                "\n"."ผู้ร้องขอ : " . $USREREQUESTNAME .
                "\n"."หน่วยงาน : " . $HR_DEPARTMENT_SUB_SUB_NAME . 
                "\n"."ช่างที่ถูกร้องขอ : " . $TECHREPAIRNAME ;

                
        
                    $name = DB::table('line_token')->where('ID_LINE_TOKEN','=',4)->first();        
                    $test =$name->LINE_TOKEN;
        
                    $chOne = curl_init();
                    curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
                    curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0);
                    curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0);
                    curl_setopt( $chOne, CURLOPT_POST, 1);
                    curl_setopt( $chOne, CURLOPT_POSTFIELDS, $message);
                    curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=$message");
                    curl_setopt( $chOne, CURLOPT_FOLLOWLOCATION, 1);
                    $headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$test.'', );
                    curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1);
                    $result = curl_exec( $chOne );
                    if(curl_error($chOne)) { echo 'error:' . curl_error($chOne); }
                    else { $result_ = json_decode($result, true);
                    echo "status : ".$result_['status']; echo "message : ". $result_['message']; }
                    curl_close( $chOne );


                        //แจ้งเตือนกลุ่มหน่วยงาน
                $name_re = DB::table('hrd_person')->where('ID','=',$request->USER_REQUEST_ID)->first();  
                $name_request = DB::table('hrd_department_sub_sub')->where('HR_DEPARTMENT_SUB_SUB_ID','=',$name_re->HR_DEPARTMENT_SUB_SUB_ID)->first();        
                $tokendepsubsub =$name_request->LINE_TOKEN;

                $chOne3 = curl_init();
              curl_setopt( $chOne3, CURLOPT_URL, "https://notify-api.line.me/api/notify");
              curl_setopt( $chOne3, CURLOPT_SSL_VERIFYHOST, 0);
              curl_setopt( $chOne3, CURLOPT_SSL_VERIFYPEER, 0);
              curl_setopt( $chOne3, CURLOPT_POST, 1);
              curl_setopt( $chOne3, CURLOPT_POSTFIELDS, $message);
              curl_setopt( $chOne3, CURLOPT_POSTFIELDS, "message=$message");
              curl_setopt( $chOne3, CURLOPT_FOLLOWLOCATION, 1);
              $headers3 = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$tokendepsubsub.'', );
              curl_setopt($chOne3, CURLOPT_HTTPHEADER, $headers3);
              curl_setopt( $chOne3, CURLOPT_RETURNTRANSFER, 1);
              $result3 = curl_exec( $chOne3 );
              if(curl_error($chOne3)) { echo 'error:' . curl_error($chOne3); }
              else { $result_ = json_decode($result3, true);
              echo "status : ".$result_['status']; echo "message : ". $result_['message']; }
              curl_close( $chOne3 );



            return redirect()->route('repair.inforepairnomal',[
                'iduser' => $request->USER_REQUEST_ID
            ]); 

    }

    //---------------------------------แก้ไข----------------------------------

    public function editinforepairnomal (Request $request,$id,$iduser)
    {
        //$email = Auth::user()->email;
        $inforpersonuserid =  Person::where('ID','=',$iduser)->first();
        //$id = $inforpersonuserid->ID;

        
        $inforpersonuser=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_sex','hrd_person.SEX','=','hrd_sex.SEX_ID')
        ->leftJoin('hrd_status','hrd_person.HR_STATUS_ID','=','hrd_status.HR_STATUS_ID')
        ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
        ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->leftJoin('hrd_department','hrd_person.HR_DEPARTMENT_ID','=','hrd_department.HR_DEPARTMENT_ID')
        ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
        ->leftJoin('hrd_bloodgroup','hrd_person.HR_BLOODGROUP_ID','=','hrd_bloodgroup.HR_BLOODGROUP_ID')
        ->leftJoin('hrd_marry_status','hrd_person.HR_MARRY_STATUS_ID','=','hrd_marry_status.HR_MARRY_STATUS_ID')
        ->leftJoin('hrd_religion','hrd_person.HR_RELIGION_ID','=','hrd_religion.HR_RELIGION_ID')
        ->leftJoin('hrd_nationality','hrd_person.HR_NATIONALITY_ID','=','hrd_nationality.HR_NATIONALITY_ID')
        ->leftJoin('hrd_citizenship','hrd_person.HR_CITIZENSHIP_ID','=','hrd_citizenship.HR_CITIZENSHIP_ID')
        ->leftJoin('hrd_tumbon','hrd_person.TUMBON_ID','=','hrd_tumbon.ID')
        ->leftJoin('hrd_amphur','hrd_person.AMPHUR_ID','=','hrd_amphur.ID')
        ->leftJoin('hrd_province','hrd_person.PROVINCE_ID','=','hrd_province.ID')
        ->leftJoin('hrd_kind','hrd_person.HR_KIND_ID','=','hrd_kind.HR_KIND_ID')
        ->leftJoin('hrd_kind_type','hrd_person.HR_KIND_TYPE_ID','=','hrd_kind_type.HR_KIND_TYPE_ID')
        ->leftJoin('hrd_person_type','hrd_person.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
        ->where('hrd_person.ID','=',$iduser)->first();

         $infoasset = DB::table('asset_article')->where('DECLINE_ID','<>',17)->where('DECLINE_ID','<>',18)->get(); 


         $infolocation = DB::table('supplies_location')->get();
         //$infolocationlevel = DB::table('supplies_location_level')->get();
         //$infolocationlevelroom = DB::table('supplies_location_level_room')->get();

         $informrepair_tech = DB::table('informrepair_tech')
         ->leftJoin('hrd_person','hrd_person.ID','=','informrepair_tech.PERSON_ID')
         ->get();


         $informrepairindex = Informrepairindex::where('informrepair_index.ID','=',$id)
         ->leftJoin('asset_article','asset_article.ARTICLE_ID','=','informrepair_index.ARTICLE_ID')

         ->leftjoin('hrd_person','hrd_person.ID','=','informrepair_index.TECH_REPAIR_ID')
         ->leftjoin('asset_building','informrepair_index.LOCATION_SEE_ID','=','asset_building.ID')
         ->leftjoin('supplies_location_level','informrepair_index.LOCATIONLEVEL_SEE_ID','=','supplies_location_level.LOCATION_LEVEL_ID')
         ->leftjoin('supplies_location_level_room','informrepair_index.LOCATIONLEVELROOM_SEE_ID','=','supplies_location_level_room.LEVEL_ROOM_ID')

         ->first();


          $infoassetother = DB::table('informrepair_other')->get();

          

          if($informrepairindex->LOCATION_SEE_ID != ''){
            $infolocationlevel= DB::table('supplies_location_level')->where('LOCATION_ID','=',$informrepairindex->LOCATION_SEE_ID)->get();
          }
          else{
            $infolocationlevel= '';      
          }   
          

          if($informrepairindex->LOCATIONLEVEL_SEE_ID != ''){
            $infolocationlevelroom= DB::table('supplies_location_level_room')->where('LOCATION_LEVEL_ID','=',$informrepairindex->LOCATIONLEVEL_SEE_ID)->get();
          }
          else{
            $infolocationlevelroom= '';      
          }   

          $infotypesystem = DB::table('informrepair_systemtype')->get();
          
        return view('general_repair.inforepairnomal_edit',[
            'infoassets' => $infoasset,
            'id' => $id,
            'inforpersonuser' => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid,
            'infolocations' => $infolocation,
            'infolocationlevels' => $infolocationlevel,
            'infolocationlevelrooms' => $infolocationlevelroom, 
            'informrepair_techs' => $informrepair_tech,
            'informrepairindex' => $informrepairindex,
            'infoassetothers' => $infoassetother,
            'infotypesystems' => $infotypesystem,
     
        ]);
    }


    
    public function updateinforepairnomal(Request $request)
    {
       // return $request->all();

       $DATE_1 = $request->DATE_REQUEST;


       if($DATE_1 != ''){
        $STARTDAY = Carbon::createFromFormat('d/m/Y', $DATE_1)->format('Y-m-d');
        $date_arrary_st=explode("-",$STARTDAY);  
        $y_sub_st = $date_arrary_st[0]; 
        
        if($y_sub_st >= 2500){
            $y_st = $y_sub_st-543;
        }else{
            $y_st = $y_sub_st;
        }
        $m_st = $date_arrary_st[1];
        $d_st = $date_arrary_st[2];  
        $DATE_1= $y_st."-".$m_st."-".$d_st;
        }else{
        $DATE_1= null;
    }
 

            $datere = $DATE_1." ".$request->TIME_REQUEST.":00";
      
            $ID = $request->ID;
            // dd($ID);
            $addinforepair = Informrepairindex::find($ID);
        
            $addinforepair->DATE_TIME_REQUEST = $datere;

               $addinforepair->USER_REQUEST_ID = $request->USER_REQUEST_ID;

               //----------------------------------
               $USRE_REQUEST_NAME =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
               ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
               ->where('hrd_person.ID','=',$request->USER_REQUEST_ID)->first();
               $addinforepair->USRE_REQUEST_NAME   = $USRE_REQUEST_NAME->HR_PREFIX_NAME.''.$USRE_REQUEST_NAME->HR_FNAME.' '.$USRE_REQUEST_NAME->HR_LNAME;
   
               //----------------------------------

            $addinforepair->REPAIR_NAME = $request->REPAIR_NAME;
            $addinforepair->LOCATION_SEE_ID = $request->LOCATION_SEE_ID;
            $addinforepair->LOCATIONLEVEL_SEE_ID = $request->LOCATIONLEVEL_SEE_ID;
            $addinforepair->LOCATIONLEVELROOM_SEE_ID = $request->LOCATIONLEVELROOM_SEE_ID;

         
            if($request->ARTICLE_ID != ''){
                $addinforepair->ARTICLE_ID = $request->ARTICLE_ID;
                }

            $nonarticle = $request->OTHER_NAME;
            if ( $nonarticle != '') {
                $addinforepair->ARTICLE_ID = '';
                $addinforepair->OTHER_NAME = $request->OTHER_NAME;
            }
            



        
            
         if($request->hasFile('picture')){
            //$newFileName = $picid.'.'.$request->picture->extension();
            
            $file = $request->file('picture');  
            $contents = $file->openFile()->fread($file->getSize());
            $addinforepair->REPAIR_IMG = $contents;   
            //$request->picture->storeAs('images',$newFileName,'public');
            //$inforpersonedit->HR_IMAGE_NAME = $newFileName; 
        }
       
         $addinforepair->SYMPTOM = $request->SYMPTOM;
         $addinforepair->TECH_REPAIR_ID = $request->TECH_REPAIR_ID;

        if($request->TECH_REPAIR_ID != 'not'){
            //----------------------------------
            $TECH_REPAIR_NAME =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
            ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
            ->where('hrd_person.ID','=',$request->TECH_REPAIR_ID)->first();
            $addinforepair->TECH_REPAIR_NAME   = $TECH_REPAIR_NAME->HR_PREFIX_NAME.''.$TECH_REPAIR_NAME->HR_FNAME.' '.$TECH_REPAIR_NAME->HR_LNAME;
        }
            //----------------------------------

           $addinforepair->PRIORITY_ID = $request->PRIORITY_ID;
           $addinforepair->REPAIR_SYSTEM = $request->REPAIR_SYSTEM;
           $addinforepair->REPAIR_STATUS = 'REQUEST';
           $addinforepair->save();

            return redirect()->route('repair.inforepairnomal',[
                'iduser' => $request->USER_REQUEST_ID
            ]); 

    }

    

        //---------------------------ความพึงพอใจซ่อมทัวไป------------------------------

    public function repairnomalfansave(Request $request)
{
       
         
        $ID = $request->ID;
    //dd($ID);
        $addfanrepairnomalnomal = Informrepairindex::find($ID);
        $addfanrepairnomalnomal->FANCINESS_SCORE = $request->FANCINESS_SCORE;
        $addfanrepairnomalnomal->FANCINESS_REMARK = $request->FANCINESS_REMARK;
        $addfanrepairnomalnomal->FANCINESS_PERSON_ID = $request->FANCINESS_PERSON_ID;
        $addfanrepairnomalnomal->FANCINESS_DATE = date('Y-m-d H:i:s');
        $addfanrepairnomalnomal->save();


        return redirect()->route('repair.inforepairnomal',[
            'iduser' => $request->FANCINESS_PERSON_ID
        ]); 

}

//---------------------------แจ้งยกเลิกซ่อมทัวไป------------------------------


public function cancel(Request $request,$id,$iduser)
{
    //$email = Auth::user()->email;
   $inforpersonuserid =  Person::where('ID','=',$iduser)->first();
   // $iduser = $inforpersonuserid->ID;

    
    $inforpersonuser=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->leftJoin('hrd_sex','hrd_person.SEX','=','hrd_sex.SEX_ID')
    ->leftJoin('hrd_status','hrd_person.HR_STATUS_ID','=','hrd_status.HR_STATUS_ID')
    ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
    ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
    ->leftJoin('hrd_department','hrd_person.HR_DEPARTMENT_ID','=','hrd_department.HR_DEPARTMENT_ID')
    ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
    ->leftJoin('hrd_bloodgroup','hrd_person.HR_BLOODGROUP_ID','=','hrd_bloodgroup.HR_BLOODGROUP_ID')
    ->leftJoin('hrd_marry_status','hrd_person.HR_MARRY_STATUS_ID','=','hrd_marry_status.HR_MARRY_STATUS_ID')
    ->leftJoin('hrd_religion','hrd_person.HR_RELIGION_ID','=','hrd_religion.HR_RELIGION_ID')
    ->leftJoin('hrd_nationality','hrd_person.HR_NATIONALITY_ID','=','hrd_nationality.HR_NATIONALITY_ID')
    ->leftJoin('hrd_citizenship','hrd_person.HR_CITIZENSHIP_ID','=','hrd_citizenship.HR_CITIZENSHIP_ID')
    ->leftJoin('hrd_tumbon','hrd_person.TUMBON_ID','=','hrd_tumbon.ID')
    ->leftJoin('hrd_amphur','hrd_person.AMPHUR_ID','=','hrd_amphur.ID')
    ->leftJoin('hrd_province','hrd_person.PROVINCE_ID','=','hrd_province.ID')
    ->leftJoin('hrd_kind','hrd_person.HR_KIND_ID','=','hrd_kind.HR_KIND_ID')
    ->leftJoin('hrd_kind_type','hrd_person.HR_KIND_TYPE_ID','=','hrd_kind_type.HR_KIND_TYPE_ID')
    ->leftJoin('hrd_person_type','hrd_person.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
    ->where('hrd_person.ID','=',$iduser)->first();

    //dd($id);

    $inforepairnomaldetail = Informrepairindex::where('informrepair_index.ID','=',$id)
    ->leftjoin('informrepair_priority','informrepair_priority.PRIORITY_ID','=','informrepair_index.PRIORITY_ID')
    ->leftjoin('hrd_person','informrepair_index.USER_REQUEST_ID','=','hrd_person.ID')
    ->leftjoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_SUB_ID')
    ->leftjoin('asset_building','informrepair_index.LOCATION_SEE_ID','=','asset_building.ID')
    ->leftjoin('supplies_location_level','informrepair_index.LOCATIONLEVEL_SEE_ID','=','supplies_location_level.LOCATION_LEVEL_ID')
    ->leftjoin('supplies_location_level_room','informrepair_index.LOCATIONLEVELROOM_SEE_ID','=','supplies_location_level_room.LEVEL_ROOM_ID')
    ->leftjoin('asset_article','informrepair_index.ARTICLE_ID','=','asset_article.ARTICLE_ID')
    ->first(); 
      
    //dd($inforepairnomal);
        
        

    return view('general_repair.genrepairnomalcancel_check',[
        'inforpersonuser' => $inforpersonuser,
        'inforpersonuserid' => $inforpersonuserid, 
        'inforepairnomaldetail' => $inforepairnomaldetail,
        'infoid' => $id
    ]);
}


public function updatecancel(Request $request)
{
    //$email = Auth::user()->email;
    //return $request->all();
    $id = $request->ID; 

   
      $updatecancel = Informrepairindex::find($id);
      $updatecancel->CANCEL_COMMENT = $request->CANCEL_COMMENT;    
      $updatecancel->CANCEL_USER_EDIT_ID = $request->CANCEL_USER_EDIT_ID; 
      $updatecancel->REPAIR_STATUS = 'REPAIR_OUT'; 

  
  
      $updatecancel->save();
      
          //
          return redirect()->route('repair.inforepairnomal',[
            'iduser' => $request->CANCEL_USER_EDIT_ID
        ]); 

        }



 //---------------------------ฟังชัน------------------------------
    function repairnomal(Request $request)
    {
       
      $id = $request->get('select');
      $result=array();
      $query= DB::table('supplies_location_level')
      ->where('LOCATION_ID','=',$id)
      ->get();


      $output='<option value="">--กรุณาเลือกชั้น--</option>';
      
      foreach ($query as $row){

            $output.= '<option value="'.$row->LOCATION_LEVEL_ID.'">'.$row->LOCATION_LEVEL_NAME.'</option>';
    }

    echo $output;
        
    }

    function repairnomalsub(Request $request)
    {
       
      $id = $request->get('select');
      $result=array();
      $query= DB::table('supplies_location_level_room')
      ->where('LOCATION_LEVEL_ID','=',$id)
      ->get();


      $output='<option value="">--กรุณาเลือกห้อง--</option>';
      
      foreach ($query as $row){

            $output.= '<option value="'.$row->LEVEL_ROOM_ID.'">'.$row->LEVEL_ROOM_NAME.'</option>';
    }

    echo $output;
        
    }


    function repairnomalasset(Request $request)
    {
       
      $asset = $request->get('asset');

      if($asset == 'asset'){
       $infoassets = DB::table('asset_article')->get();
       $output=' <div class="col-sm-2">
       <label>ครุภัณฑ์ทะเบียน :</label>
       </div> 
       <div class="col-lg-10">
       <select name="ARTICLE_ID" id="ARTICLE_ID" class="form-control input-lg "
       style=" font-family: \'Kanit\', sans-serif;" required>
       <option value="">--กรุณาเลือกครุภัณฑ์--</option>';

       foreach ($infoassets as $infoasset){

        $output.= '<option value="'.$infoasset->ARTICLE_ID.'">'.$infoasset->ARTICLE_NUM.' :: '.$infoasset->ARTICLE_NAME.'</option>';
    }
        $output.='</select>
        
        <input type="hidden" value="" name="OTHER_NAME" class="form-control input-lg" >
        </div>';
 
    }else{
     
        $infoassets = DB::table('informrepair_other')->get();
        $output=' <div class="col-sm-2">
        <label>รายการอื่น :</label>
        </div> 
        <div class="col-lg-4">
        <select name="OTHER_NAME" id="OTHER_NAME" class="form-control input-lg other_re" style=" font-family: \'Kanit\', sans-serif;" >
        <option value="">--กรุณาเลือกรายการ--</option>';
       
        foreach ($infoassets as $infoasset){
 
             $output.= '<option value="'.$infoasset->OTHER_NAME.'">'.$infoasset->OTHER_NAME.'</option>';
         }
 
         $output.='</select>
         </div>
         <div class="col-sm-4">
         <input name="ADD_OTHER_NAME" id="ADD_OTHER_NAME" class="form-control input-lg" style=" font-family: \'Kanit\', sans-serif; background-color: #CCFFFF;" placeholder="ระบุรายการหากต้องการเพิ่ม">
         </div> 
         <div class="col-lg-2">
         <a class="btn btn-hero-sm btn-hero-info" style="font-family: \'Kanit\', sans-serif; font-size: 10px;font-size: 1.0rem;font-weight:normal;color:#FFFFFF;" onclick="addother();"><i class="fas fa-plus"></i> เพิ่ม</a>
         </div> 
         <input type="hidden" value="" name="ARTICLE_ID" class="form-control input-lg" >
         </div>';


    }
    echo $output;
        
    }


    function addother(Request $request)
    {

        if($request->other_re!= null || $request->other_re != ''){
            $addrecord = new Informrepairother(); 
            $addrecord->OTHER_NAME = $request->other_re;
            $addrecord->save(); 
         }
            $query =  DB::table('informrepair_other')->get();
         
            $output='<option value="">--กรุณาเลือกรายการ--</option>';
            
            foreach ($query as $row){
                  if($request->other_re == $row->OTHER_NAME){
                    $output.= '<option value="'.$row->OTHER_NAME.'" selected>'.$row->OTHER_NAME.'</option>';
                  }else{
                    $output.= '<option value="'.$row->OTHER_NAME.'">'.$row->OTHER_NAME.'</option>';
                  }
    
                  
          }
    
            echo $output;


    } 



    //-------------------------------------ฟังชั่นรันเลขอ้างอิงซ่อมทั่วไป--------------------
    
    public static function refnumbernumal()
    {
        $year = date('Y');

        $maxnumber = DB::table('informrepair_index')->where('DATE_TIME_REQUEST','like',$year.'%')->max('ID');  

     

        if($maxnumber != '' ||  $maxnumber != null){
            
            $refmax = DB::table('informrepair_index')->where('ID','=',$maxnumber)->first();  


            if($refmax->REPAIR_ID != '' ||  $refmax->REPAIR_ID != null){
                $maxref = substr($refmax->REPAIR_ID, -4)+1;
             }else{
                $maxref = 1;
             }

            $ref = str_pad($maxref, 5, "0", STR_PAD_LEFT);
       
        }else{
            $ref = '00001';
        }

        $ye = date('Y')+543;
        $y = substr($ye, -2);
        //$m = date('m');
        // = date('d');

     $refnumber ='R'.$y.'-'.$ref;



     return $refnumber;
    }


  //-------------------ซ่อมคอม

  public function inforepaircom(Request $request,$iduser)
  {
      //$email = Auth::user()->email;
      $inforpersonuserid =  Person::where('ID','=',$iduser)->first();
      $id = $inforpersonuserid->ID;

      
      $inforpersonuser=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
      ->leftJoin('hrd_sex','hrd_person.SEX','=','hrd_sex.SEX_ID')
      ->leftJoin('hrd_status','hrd_person.HR_STATUS_ID','=','hrd_status.HR_STATUS_ID')
      ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
      ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
      ->leftJoin('hrd_department','hrd_person.HR_DEPARTMENT_ID','=','hrd_department.HR_DEPARTMENT_ID')
      ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
      ->leftJoin('hrd_bloodgroup','hrd_person.HR_BLOODGROUP_ID','=','hrd_bloodgroup.HR_BLOODGROUP_ID')
      ->leftJoin('hrd_marry_status','hrd_person.HR_MARRY_STATUS_ID','=','hrd_marry_status.HR_MARRY_STATUS_ID')
      ->leftJoin('hrd_religion','hrd_person.HR_RELIGION_ID','=','hrd_religion.HR_RELIGION_ID')
      ->leftJoin('hrd_nationality','hrd_person.HR_NATIONALITY_ID','=','hrd_nationality.HR_NATIONALITY_ID')
      ->leftJoin('hrd_citizenship','hrd_person.HR_CITIZENSHIP_ID','=','hrd_citizenship.HR_CITIZENSHIP_ID')
      ->leftJoin('hrd_tumbon','hrd_person.TUMBON_ID','=','hrd_tumbon.ID')
      ->leftJoin('hrd_amphur','hrd_person.AMPHUR_ID','=','hrd_amphur.ID')
      ->leftJoin('hrd_province','hrd_person.PROVINCE_ID','=','hrd_province.ID')
      ->leftJoin('hrd_kind','hrd_person.HR_KIND_ID','=','hrd_kind.HR_KIND_ID')
      ->leftJoin('hrd_kind_type','hrd_person.HR_KIND_TYPE_ID','=','hrd_kind_type.HR_KIND_TYPE_ID')
      ->leftJoin('hrd_person_type','hrd_person.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
      ->where('hrd_person.ID','=',$iduser)->first();



      $inforepaircom = Informcomrepair::where('REPAIR_STATUS','=','REQUEST')
      ->orderBy('ID', 'desc')->get(); 

      $infostatus = DB::table('informrepair_status')->get();

   

        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;
        }
        
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';
        $status = 'REQUEST';
        $search = '';
        $year_id = $yearbudget;

        
        $openform_function = Infomrepair_functioncom::where('FUNCT_REPCOM_STATUS','=','True' )->first();
        if ($openform_function != '') {       
            $code = $openform_function->FUNCT_REPCOM_CODE;  
        } else {                      
            $code = '';
        }



      return view('general_repair.inforepaircom',[
          'inforepaircoms' => $inforepaircom,
          'inforpersonuser' => $inforpersonuser,
          'inforpersonuserid' => $inforpersonuserid, 
          'infostatuss' => $infostatus, 
          'displaydate_bigen'=> $displaydate_bigen, 
          'displaydate_end'=> $displaydate_end,
          'status_check'=> $status,
          'search'=> $search,
          'budgets' =>  $budget,
          'codes'=>$code,
          'year_id'=>$year_id
       
          
      ]);
  }

  
  public function inforepaircomsearch(Request $request,$iduser)
  {

   

      $inforpersonuserid =  Person::where('ID','=',$iduser)->first();
      $id = $inforpersonuserid->ID;

      
      $inforpersonuser=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
      ->leftJoin('hrd_sex','hrd_person.SEX','=','hrd_sex.SEX_ID')
      ->leftJoin('hrd_status','hrd_person.HR_STATUS_ID','=','hrd_status.HR_STATUS_ID')
      ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
      ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
      ->leftJoin('hrd_department','hrd_person.HR_DEPARTMENT_ID','=','hrd_department.HR_DEPARTMENT_ID')
      ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
      ->leftJoin('hrd_bloodgroup','hrd_person.HR_BLOODGROUP_ID','=','hrd_bloodgroup.HR_BLOODGROUP_ID')
      ->leftJoin('hrd_marry_status','hrd_person.HR_MARRY_STATUS_ID','=','hrd_marry_status.HR_MARRY_STATUS_ID')
      ->leftJoin('hrd_religion','hrd_person.HR_RELIGION_ID','=','hrd_religion.HR_RELIGION_ID')
      ->leftJoin('hrd_nationality','hrd_person.HR_NATIONALITY_ID','=','hrd_nationality.HR_NATIONALITY_ID')
      ->leftJoin('hrd_citizenship','hrd_person.HR_CITIZENSHIP_ID','=','hrd_citizenship.HR_CITIZENSHIP_ID')
      ->leftJoin('hrd_tumbon','hrd_person.TUMBON_ID','=','hrd_tumbon.ID')
      ->leftJoin('hrd_amphur','hrd_person.AMPHUR_ID','=','hrd_amphur.ID')
      ->leftJoin('hrd_province','hrd_person.PROVINCE_ID','=','hrd_province.ID')
      ->leftJoin('hrd_kind','hrd_person.HR_KIND_ID','=','hrd_kind.HR_KIND_ID')
      ->leftJoin('hrd_kind_type','hrd_person.HR_KIND_TYPE_ID','=','hrd_kind_type.HR_KIND_TYPE_ID')
      ->leftJoin('hrd_person_type','hrd_person.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
      ->where('hrd_person.ID','=',$iduser)->first();



      $search = $request->get('search');
      $status = $request->SEND_STATUS;
      $datebigin = $request->get('DATE_BIGIN');
      $dateend = $request->get('DATE_END');
      $yearbudget = $request->BUDGET_YEAR;

      if($search==''){
          $search="";
      }

      if($datebigin == '' || $dateend == ''){
          $displaydate_bigen = '';
          $displaydate_end = '';
      }else{    

      $date_bigen_c = Carbon::createFromFormat('d/m/Y', $datebigin)->format('Y-m-d');
      $date_arrary=explode("-",$date_bigen_c);

      $y_sub_st = $date_arrary[0];

      if($y_sub_st >= 2500){
          $y = $y_sub_st-543;
      }else{
          $y = $y_sub_st;
      }

      $m = $date_arrary[1];
      $d = $date_arrary[2];  
      $displaydate_bigen= $y."-".$m."-".$d;

      $date_end_c = Carbon::createFromFormat('d/m/Y', $dateend)->format('Y-m-d');
      $date_arrary_e=explode("-",$date_end_c); 

      $y_sub_e = $date_arrary_e[0];

      if($y_sub_e >= 2500){
          $y_e = $y_sub_e-543;
      }else{
          $y_e = $y_sub_e;
      }

      $m_e = $date_arrary_e[1];
      $d_e = $date_arrary_e[2];  
      $displaydate_end= $y_e."-".$m_e."-".$d_e;



      $date = date('Y-m-d');
      $date_bigen_checks = strtotime($displaydate_bigen);
      $date_end_checks =  strtotime($displaydate_end);
      $dates =  strtotime($date);
         
  }
     //dd($displaydate_bigen);

    
          $from = date($displaydate_bigen);
          $to = date($displaydate_end);

          
          if($status == null){


              $inforepaircom = Informcomrepair::where(function($q) use ($search){
                  $q->where('REPAIR_ID','like','%'.$search.'%');
                  $q->orwhere('REPAIR_NAME','like','%'.$search.'%');
                  $q->orwhere('SYMPTOM','like','%'.$search.'%');
                  $q->orwhere('USRE_REQUEST_NAME','like','%'.$search.'%');
                  })
                  ->WhereBetween('DATE_TIME_REQUEST',[$from.' 00:00:00',$to.' 23:59:00']) 
              ->orderBy('ID', 'desc')->get(); 



          }else{


              $inforepaircom = Informcomrepair::where('REPAIR_STATUS','=',$status)
              ->where(function($q) use ($search){
                  $q->where('REPAIR_ID','like','%'.$search.'%');
                  $q->orwhere('REPAIR_NAME','like','%'.$search.'%');
                  $q->orwhere('SYMPTOM','like','%'.$search.'%');
                  $q->orwhere('USRE_REQUEST_NAME','like','%'.$search.'%');
                  })
                  ->WhereBetween('DATE_TIME_REQUEST',[$from.' 00:00:00',$to.' 23:59:00']) 
              ->orderBy('ID', 'desc')->get(); 

          
          }
  

   
     
      $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
    $year_id = $yearbudget;
    

      $infostatus = DB::table('informrepair_status')->get();


      $openform_function = Infomrepair_functioncom::where('FUNCT_REPCOM_STATUS','=','True' )->first();
      if ($openform_function != '') {       
          $code = $openform_function->FUNCT_REPCOM_CODE;  
      } else {                      
          $code = '';
      }


     
      return view('general_repair.inforepaircom',[
         'inforepaircoms' => $inforepaircom,
         'inforpersonuser' => $inforpersonuser,
         'inforpersonuserid' => $inforpersonuserid, 
          'infostatuss' => $infostatus, 
          'budgets' =>  $budget,
        'displaydate_bigen'=> $displaydate_bigen,
        'displaydate_end'=> $displaydate_end,
        'status_check'=> $status,
        'search'=> $search,
        'codes'=>$code,
        'year_id'=>$year_id, 
       
          
      ]);


  }



  public function detailrepaircom(Request $request)
  {
      function DateThai($strDate)
      {
      $strYear = date("Y",strtotime($strDate))+543;
      $strMonth= date("n",strtotime($strDate));
      $strDay= date("j",strtotime($strDate));
  
      $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
      $strMonthThai=$strMonthCut[$strMonth];
      return "$strDay $strMonthThai $strYear";
      }
  
      function formateDatetime($strDate)
      {
        $strYear = date("Y",strtotime($strDate))+543;
        $strMonth= date("n",strtotime($strDate));
        $strDay= date("j",strtotime($strDate));
    
        $H= date("H",strtotime($strDate));
        $I= date("i",strtotime($strDate));
    
      $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
      $strMonthThai=$strMonthCut[$strMonth];
    
      return  "$strDay $strMonthThai $strYear $H:$I";
        }
  
  
  
  
  
  
  
             $inforepaircom = Informcomrepair::where('informcom_repair.ID','=',$request->id)
             ->leftjoin('informrepair_priority','informrepair_priority.PRIORITY_ID','=','informcom_repair.PRIORITY_ID')
             ->leftjoin('hrd_person','informcom_repair.USER_REQUEST_ID','=','hrd_person.ID')
             ->leftjoin('asset_article','asset_article.ARTICLE_ID','=','informcom_repair.ARTICLE_ID')
             ->leftjoin('supplies_location','asset_article.LOCATION_ID','=','supplies_location.LOCATION_ID')
             ->leftjoin('supplies_location_level','asset_article.LOCATION_LEVEL_ID','=','supplies_location_level.LOCATION_LEVEL_ID')
             ->leftjoin('supplies_location_level_room','asset_article.LEVEL_ROOM_ID','=','supplies_location_level_room.LEVEL_ROOM_ID')
             ->leftjoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_SUB_ID')
             ->first(); 
  
  
  
        
  
  
  $output='    
  
  <div class="row push" style="font-family: \'Kanit\', sans-serif;">
  
  <div class="col-sm-9">
  
    <div class="row">
        <div class="col-lg-2" align="right">
        <label>รหัสรายการ :</label>
        </div> 
        <div class="col-lg-8" align="left">
        '.$inforepaircom->REPAIR_ID.'
        </div> 
    </div>    
 
    
    <div class="row">
    <div class="col-lg-2" align="right">
    <label>วันที่แจ้ง :</label>
    </div> 
    <div class="col-lg-4" align="left">
    '.formateDatetime($inforepaircom->DATE_TIME_REQUEST).'
    </div> 
    <div class="col-lg-2" align="right">
    <label>อาคาร :</label>
    </div> 
    <div class="col-lg-4" align="left">
    '.$inforepaircom->LOCATION_NAME.'
    </div> 
    </div>    

    <div class="row">
        <div class="col-lg-2" align="right">
    <label>ชั้น :</label>
    </div> 
    <div class="col-lg-4" align="left">
    '.$inforepaircom->LOCATION_LEVEL_NAME.'
    </div> 
    <div class="col-lg-2" align="right">
    <label>ห้อง :</label>
    </div> 
    <div class="col-lg-4" align="left">
    '.$inforepaircom->LEVEL_ROOM_NAME.'
    </div> 

</div>    

<div class="row">
<div class="col-lg-2" align="right">
<label>แจ้งซ่อม :</label>
</div> 
<div class="col-lg-8" align="left">
'.$inforepaircom->REPAIR_NAME.'
</div> 
</div>  

<div class="row">
<div class="col-lg-2" align="right">
<label>รหัสครุภัณฑ์ :</label>
</div> 
<div class="col-lg-4" align="left">
'.$inforepaircom->ARTICLE_NUM.'
</div> 
<div class="col-lg-2" align="right">
<label>ชื่อครุภัณฑ์ :</label>
</div> 
<div class="col-lg-4" align="left">
'.$inforepaircom->ARTICLE_NAME.'
</div> 
</div>  

  <div class="row">
  <div class="col-lg-2" align="right">
  <label>ครุภัณฑ์อื่น :</label>
  </div> 
  <div class="col-lg-4" align="left">
 '.$inforepaircom->OTHER_NAME.'
  </div> 
  
 </div>  
  
  <div class="row">
  <div class="col-lg-2" align="right">
  <label>อาการ :</label>
  </div> 
  <div class="col-lg-10" align="left">
  '.$inforepaircom->SYMPTOM.'
  </div> 
  
  </div>  
  
  <div class="row">
  <div class="col-lg-2" align="right">
  <label>ความเร่งด่วน :</label>
  </div> 
  <div class="col-lg-6" align="left">
  '.$inforepaircom->PRIORITY_NAME.'
  </div> 
  
  </div>   
  
  <div class="row">
  <div class="col-lg-2" align="right">
  <label>ผู้รับเรื่อง :</label>
  </div> 
  <div class="col-lg-4" align="left">
  '.$inforepaircom->USRE_REQUEST_NAME.'
  </div>
  </div>     
  
  
  <div class="row">
  <div class="col-lg-2" align="right">
  <label>รายละเอียดซ่อม  :</label>
  </div> 
  <div class="col-lg-10" align="left">
  '.$inforepaircom->REPAIR_COMMENT.'
  </div>
  
  </div>     
  </div>

  <div class="col-sm-3">
  
  <div class="form-group">
  
  <img src="data:image/png;base64,'. chunk_split(base64_encode($inforepaircom->COM_IMG)) .'" id="image_upload_preview" alt="กรุณาเพิ่มรูปภาพ" height="200" width="200"/>
  </div>
  
  </div>
  </div>
  
  
  
  
  </div>
  
  
  </div>
  
  ';
  
  echo $output;
  
  
  }

  //-------------------------เพิ่มข้อมูลซ่อมคอม

  public function createinforepaircom (Request $request,$iduser)
    {
        //$email = Auth::user()->email;
        $inforpersonuserid =  Person::where('ID','=',$iduser)->first();
        $id = $inforpersonuserid->ID;

        
        $inforpersonuser=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_sex','hrd_person.SEX','=','hrd_sex.SEX_ID')
        ->leftJoin('hrd_status','hrd_person.HR_STATUS_ID','=','hrd_status.HR_STATUS_ID')
        ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
        ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->leftJoin('hrd_department','hrd_person.HR_DEPARTMENT_ID','=','hrd_department.HR_DEPARTMENT_ID')
        ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
        ->leftJoin('hrd_bloodgroup','hrd_person.HR_BLOODGROUP_ID','=','hrd_bloodgroup.HR_BLOODGROUP_ID')
        ->leftJoin('hrd_marry_status','hrd_person.HR_MARRY_STATUS_ID','=','hrd_marry_status.HR_MARRY_STATUS_ID')
        ->leftJoin('hrd_religion','hrd_person.HR_RELIGION_ID','=','hrd_religion.HR_RELIGION_ID')
        ->leftJoin('hrd_nationality','hrd_person.HR_NATIONALITY_ID','=','hrd_nationality.HR_NATIONALITY_ID')
        ->leftJoin('hrd_citizenship','hrd_person.HR_CITIZENSHIP_ID','=','hrd_citizenship.HR_CITIZENSHIP_ID')
        ->leftJoin('hrd_tumbon','hrd_person.TUMBON_ID','=','hrd_tumbon.ID')
        ->leftJoin('hrd_amphur','hrd_person.AMPHUR_ID','=','hrd_amphur.ID')
        ->leftJoin('hrd_province','hrd_person.PROVINCE_ID','=','hrd_province.ID')
        ->leftJoin('hrd_kind','hrd_person.HR_KIND_ID','=','hrd_kind.HR_KIND_ID')
        ->leftJoin('hrd_kind_type','hrd_person.HR_KIND_TYPE_ID','=','hrd_kind_type.HR_KIND_TYPE_ID')
        ->leftJoin('hrd_person_type','hrd_person.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
        ->where('hrd_person.ID','=',$iduser)->first();

         $infoasset = DB::table('asset_article')->where('DECLINE_ID','=',18)->get();  


         $infolocation = DB::table('supplies_location')->get();
         $infolocationlevel = DB::table('supplies_location_level')->get();
         $infolocationlevelroom = DB::table('supplies_location_level_room')->get();

         $infotypesystem = DB::table('informcom_systemtype')->get();

         $informrepair_tech = DB::table('informcom_engineer')
         ->leftJoin('hrd_person','hrd_person.ID','=','informcom_engineer.PERSON_ID')
         ->where('ACTIVE','=',True)
         ->get();

        return view('general_repair.inforepaircom_add',[
            'infoassets' => $infoasset,
            'inforpersonuser' => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid,
            'infolocations' => $infolocation,
            'infolocationlevels' => $infolocationlevel,
            'infolocationlevelrooms' => $infolocationlevelroom, 
            'informrepair_techs' => $informrepair_tech,
            'infotypesystems' => $infotypesystem,
         
            
        ]);
    }

     //-------------------------------------ฟังชั่นรันเลขอ้างอิงคอมพิวเตอร์--------------------
    
     public static function refnumbercom()
     {
         $year = date('Y');
 
         $maxnumber = DB::table('informcom_repair')->where('DATE_TIME_REQUEST','like',$year.'%')->max('ID');  
 
      
 
         if($maxnumber != '' ||  $maxnumber != null){
             
             $refmax = DB::table('informcom_repair')->where('ID','=',$maxnumber)->first();  
 
             
             if($refmax->REPAIR_ID != '' ||  $refmax->REPAIR_ID != null){
                $maxref = substr($refmax->REPAIR_ID, -4)+1;
             }else{
                $maxref = 1;
             }
             
 
             $ref = str_pad($maxref, 5, "0", STR_PAD_LEFT);
        
         }else{
             $ref = '00001';
         }
 
         $ye = date('Y')+543;
         $y = substr($ye, -2);
         //$m = date('m');
         // = date('d');
 
     $refnumber ='C'.$y.'-'.$ref;
 
      return $refnumber;
     }
 

   
    public function saveinforepaircom(Request $request)
    {
       // return $request->all();

       $DATE_1 = $request->DATE_REQUEST;


       if($DATE_1 != ''){
        $STARTDAY = Carbon::createFromFormat('d/m/Y', $DATE_1)->format('Y-m-d');
        $date_arrary_st=explode("-",$STARTDAY);  
        $y_sub_st = $date_arrary_st[0]; 
        
        if($y_sub_st >= 2500){
            $y_st = $y_sub_st-543;
        }else{
            $y_st = $y_sub_st;
        }
        $m_st = $date_arrary_st[1];
        $d_st = $date_arrary_st[2];  
        $DATE_1= $y_st."-".$m_st."-".$d_st;
        }else{
        $DATE_1= null;
        }
     
            $datere = $DATE_1." ".$request->TIME_REQUEST.":00";
      //------------------------------------------------------------------
            $m = date('m');
            if($m > 9 && $m < 12 ){
                $YEAR_ID = date('Y')+544;
            }else{
                $YEAR_ID = date('Y')+543;
            }
          //===========================================================   
            $year = date('Y');
            $maxnumber = DB::table('informcom_repair')->where('DATE_TIME_REQUEST','like',$year.'%')->max('ID');  
            if($maxnumber != '' ||  $maxnumber != null){       
                    $refmax = DB::table('informcom_repair')->where('ID','=',$maxnumber)->first();    
                if($refmax->REPAIR_ID != '' ||  $refmax->REPAIR_ID != null){
                   $maxref = substr($refmax->REPAIR_ID, -4)+1;
                }else{
                   $maxref = 1;
                }
                    $ref = str_pad($maxref, 5, "0", STR_PAD_LEFT);
            }else{
                    $ref = '00001';
            }
            $ye = date('Y')+543;
            $y = substr($ye, -2);
            $refnumber ='C'.$y.'-'.$ref;
            
           //=============================================

            $addinforepair = new Informcomrepair(); 
            $addinforepair->REPAIR_ID =  $refnumber;
            $addinforepair->YEAR_ID =  $YEAR_ID;

            $addinforepair->DATE_TIME_REQUEST = $datere;
            $addinforepair->DATE_SAVE = $DATE_1;
            $addinforepair->USER_REQUEST_ID = $request->USER_REQUEST_ID;
              
               
               //----------------------------------
               $USRE_REQUEST_NAME =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
               ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
               ->where('hrd_person.ID','=',$request->USER_REQUEST_ID)->first();
               $addinforepair->USRE_REQUEST_NAME   = $USRE_REQUEST_NAME->HR_PREFIX_NAME.''.$USRE_REQUEST_NAME->HR_FNAME.' '.$USRE_REQUEST_NAME->HR_LNAME;
   
               //----------------------------------

            $addinforepair->REPAIR_NAME = $request->REPAIR_NAME;


            $addinforepair->LOCATION_SEE_ID = $request->LOCATION_SEE_ID;
            $addinforepair->LOCATIONLEVEL_SEE_ID = $request->LOCATIONLEVEL_SEE_ID;
            $addinforepair->LOCATIONLEVELROOM_SEE_ID = $request->LOCATIONLEVELROOM_SEE_ID;

            if($request->ARTICLE_ID != ''){
            $addinforepair->ARTICLE_ID = $request->ARTICLE_ID;
            }
           
            $addinforepair->OTHER_NAME = $request->OTHER_NAME;

        
            
         if($request->hasFile('picture')){
            //$newFileName = $picid.'.'.$request->picture->extension();
            
            $file = $request->file('picture');  
            $contents = $file->openFile()->fread($file->getSize());
            $addinforepair->COM_IMG = $contents;   
            //$request->picture->storeAs('images',$newFileName,'public');
            //$inforpersonedit->HR_IMAGE_NAME = $newFileName; 
        }
       
        $addinforepair->SYMPTOM = $request->SYMPTOM;
        $addinforepair->TECH_REPAIR_ID = $request->TECH_REPAIR_ID;
        $addinforepair->REPAIR_SYSTEM = $request->REPAIR_SYSTEM;

      
            //----------------------------------
            if($request->TECH_REPAIR_ID != 'not'){
                $TECH_REPAIR_NAME =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
                ->where('hrd_person.ID','=',$request->TECH_REPAIR_ID)->first();
                $addinforepair->TECH_REPAIR_NAME   = $TECH_REPAIR_NAME->HR_PREFIX_NAME.''.$TECH_REPAIR_NAME->HR_FNAME.' '.$TECH_REPAIR_NAME->HR_LNAME;
            }
            //----------------------------------

        $addinforepair->PRIORITY_ID = $request->PRIORITY_ID;

        $addinforepair->REPAIR_STATUS = 'REQUEST';
  

            $addinforepair->save();

             // dd($addinfocar);


             $header = "ระบบแจ้งซ่อมอุปกรณ์คอมพิวเตอร์";
             $REPAIRID = $request->REPAIR_ID;
             $REPAIRNAME = $request->REPAIR_NAME; 
             $SYMPTOM = $request->SYMPTOM;  
             $USREREQUESTNAME = $USRE_REQUEST_NAME->HR_PREFIX_NAME.''.$USRE_REQUEST_NAME->HR_FNAME.' '.$USRE_REQUEST_NAME->HR_LNAME;
             
             if($request->TECH_REPAIR_ID == 'not'){
                $TECHREPAIRNAME   = '';
             }else{
                $TECHREPAIRNAME   = $TECH_REPAIR_NAME->HR_PREFIX_NAME.''.$TECH_REPAIR_NAME->HR_FNAME.' '.$TECH_REPAIR_NAME->HR_LNAME;
             }
             
             
          
         
             if($request->ARTICLE_ID != ''){
                $ARTICLE_ID = $request->ARTICLE_ID;
                }else{
                    $ARTICLE_ID = '';
                }

             
                 
                $infolocation = DB::table('supplies_location')->where('LOCATION_ID','=',$request->LOCATION_SEE_ID)->first();
                $LOCATION_SEE_NAME = $infolocation->LOCATION_NAME;

                $infolocationlevel = DB::table('supplies_location_level')->where('LOCATION_LEVEL_ID','=',$request->LOCATIONLEVEL_SEE_ID)->first();
                $LOCATIONLEVEL_SEE_NAME = $infolocationlevel->LOCATION_LEVEL_NAME;

                $infolocationlevelroom = DB::table('supplies_location_level_room')->where('LEVEL_ROOM_ID','=',$request->LOCATIONLEVELROOM_SEE_ID)->first();
                $LOCATIONLEVELROOM_SEE_NAME = $infolocationlevelroom->LEVEL_ROOM_NAME;

                $infoinformrepairpriority = DB::table('informrepair_priority')->where('PRIORITY_ID','=',$request->PRIORITY_ID)->first();
                $PRIORITY_NAME = $infoinformrepairpriority->PRIORITY_NAME;

                $infohrddepartmentsubsub = DB::table('hrd_department_sub_sub')->where('HR_DEPARTMENT_SUB_SUB_ID','=',$USRE_REQUEST_NAME->HR_DEPARTMENT_SUB_SUB_ID)->first();   
                $HR_DEPARTMENT_SUB_SUB_NAME = $infohrddepartmentsubsub->HR_DEPARTMENT_SUB_SUB_NAME;

            $message = $header.
                "\n"."รหัส : " . $REPAIRID .
                "\n"."แจ้งซ่อม : " . $REPAIRNAME .
                "\n"."ครุภัณฑ์ : " . $ARTICLE_ID .
                "\n"."อาการ : " . $SYMPTOM .  
                "\n"."สถานที่พบ : " . $LOCATION_SEE_NAME .
                "\n"."ชั้น : " . $LOCATIONLEVEL_SEE_NAME .
                "\n"."ห้อง : " . $LOCATIONLEVELROOM_SEE_NAME .
                "\n"."ความเร่งด่วน : " . $PRIORITY_NAME .           
                "\n"."ผู้ร้องขอ : " . $USREREQUESTNAME .
                "\n"."หน่วยงาน : " . $HR_DEPARTMENT_SUB_SUB_NAME . 
                "\n"."ช่างที่ถูกร้องขอ : " . $TECHREPAIRNAME ;
         
                     $name = DB::table('line_token')->where('ID_LINE_TOKEN','=',5)->first();        
                     $test =$name->LINE_TOKEN;
         
                     $chOne = curl_init();
                     curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
                     curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0);
                     curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0);
                     curl_setopt( $chOne, CURLOPT_POST, 1);
                     curl_setopt( $chOne, CURLOPT_POSTFIELDS, $message);
                     curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=$message");
                     curl_setopt( $chOne, CURLOPT_FOLLOWLOCATION, 1);
                     $headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$test.'', );
                     curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
                     curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1);
                     $result = curl_exec( $chOne );
                     if(curl_error($chOne)) { echo 'error:' . curl_error($chOne); }
                     else { $result_ = json_decode($result, true);
                     echo "status : ".$result_['status']; echo "message : ". $result_['message']; }
                     curl_close( $chOne );




                //แจ้งเตือนกลุ่มหน่วยงาน
                $name_re = DB::table('hrd_person')->where('ID','=',$request->USER_REQUEST_ID)->first();  
                $name_request = DB::table('hrd_department_sub_sub')->where('HR_DEPARTMENT_SUB_SUB_ID','=',$name_re->HR_DEPARTMENT_SUB_SUB_ID)->first();        
                $tokendepsubsub =$name_request->LINE_TOKEN;

                $chOne3 = curl_init();
              curl_setopt( $chOne3, CURLOPT_URL, "https://notify-api.line.me/api/notify");
              curl_setopt( $chOne3, CURLOPT_SSL_VERIFYHOST, 0);
              curl_setopt( $chOne3, CURLOPT_SSL_VERIFYPEER, 0);
              curl_setopt( $chOne3, CURLOPT_POST, 1);
              curl_setopt( $chOne3, CURLOPT_POSTFIELDS, $message);
              curl_setopt( $chOne3, CURLOPT_POSTFIELDS, "message=$message");
              curl_setopt( $chOne3, CURLOPT_FOLLOWLOCATION, 1);
              $headers3 = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$tokendepsubsub.'', );
              curl_setopt($chOne3, CURLOPT_HTTPHEADER, $headers3);
              curl_setopt( $chOne3, CURLOPT_RETURNTRANSFER, 1);
              $result3 = curl_exec( $chOne3 );
              if(curl_error($chOne3)) { echo 'error:' . curl_error($chOne3); }
              else { $result_ = json_decode($result3, true);
              echo "status : ".$result_['status']; echo "message : ". $result_['message']; }
              curl_close( $chOne3 );
 

            return redirect()->route('repair.inforepaircom',[
                'iduser' => $request->USER_REQUEST_ID
            ]); 

    }


    //---------------------------------แก้ไข----------------------------------

    public function editinforepaircom (Request $request,$id,$iduser)
    {
   
      
        $inforpersonuserid =  Person::where('ID','=',$iduser)->first();
     

        $inforpersonuser=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_sex','hrd_person.SEX','=','hrd_sex.SEX_ID')
        ->leftJoin('hrd_status','hrd_person.HR_STATUS_ID','=','hrd_status.HR_STATUS_ID')
        ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
        ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->leftJoin('hrd_department','hrd_person.HR_DEPARTMENT_ID','=','hrd_department.HR_DEPARTMENT_ID')
        ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
        ->leftJoin('hrd_bloodgroup','hrd_person.HR_BLOODGROUP_ID','=','hrd_bloodgroup.HR_BLOODGROUP_ID')
        ->leftJoin('hrd_marry_status','hrd_person.HR_MARRY_STATUS_ID','=','hrd_marry_status.HR_MARRY_STATUS_ID')
        ->leftJoin('hrd_religion','hrd_person.HR_RELIGION_ID','=','hrd_religion.HR_RELIGION_ID')
        ->leftJoin('hrd_nationality','hrd_person.HR_NATIONALITY_ID','=','hrd_nationality.HR_NATIONALITY_ID')
        ->leftJoin('hrd_citizenship','hrd_person.HR_CITIZENSHIP_ID','=','hrd_citizenship.HR_CITIZENSHIP_ID')
        ->leftJoin('hrd_tumbon','hrd_person.TUMBON_ID','=','hrd_tumbon.ID')
        ->leftJoin('hrd_amphur','hrd_person.AMPHUR_ID','=','hrd_amphur.ID')
        ->leftJoin('hrd_province','hrd_person.PROVINCE_ID','=','hrd_province.ID')
        ->leftJoin('hrd_kind','hrd_person.HR_KIND_ID','=','hrd_kind.HR_KIND_ID')
        ->leftJoin('hrd_kind_type','hrd_person.HR_KIND_TYPE_ID','=','hrd_kind_type.HR_KIND_TYPE_ID')
        ->leftJoin('hrd_person_type','hrd_person.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
        ->where('hrd_person.ID','=',$iduser)->first();

         $infoasset = DB::table('asset_article')->where('DECLINE_ID','=',18)->get();  


         $infolocation = DB::table('supplies_location')->get();
        

         $informrepair_tech = DB::table('informcom_engineer')
         ->leftJoin('hrd_person','hrd_person.ID','=','informcom_engineer.PERSON_ID')
         ->where('ACTIVE','=',True)
         ->get();

       
         $informcomrepair = Informcomrepair::leftJoin('asset_article','asset_article.ARTICLE_ID','=','informcom_repair.ARTICLE_ID')
         ->leftjoin('hrd_person','hrd_person.ID','=','informcom_repair.TECH_REPAIR_ID')
         ->leftjoin('supplies_location','informcom_repair.LOCATION_SEE_ID','=','supplies_location.LOCATION_ID')
         ->leftjoin('supplies_location_level','informcom_repair.LOCATIONLEVEL_SEE_ID','=','supplies_location_level.LOCATION_LEVEL_ID')
         ->leftjoin('supplies_location_level_room','informcom_repair.LOCATIONLEVELROOM_SEE_ID','=','supplies_location_level_room.LEVEL_ROOM_ID')
         ->where('informcom_repair.ID','=',$id)
         ->first();

         
       

          $infoassetother = DB::table('informrepair_other')->get();

          

          if($informcomrepair->LOCATION_SEE_ID != ''){
            $infolocationlevel= DB::table('supplies_location_level')->where('LOCATION_ID','=',$informcomrepair->LOCATION_SEE_ID)->get();
          }
          else{
            $infolocationlevel= '';      
          }   
          

          if($informcomrepair->LOCATIONLEVEL_SEE_ID != ''){
            $infolocationlevelroom= DB::table('supplies_location_level_room')->where('LOCATION_LEVEL_ID','=',$informcomrepair->LOCATIONLEVEL_SEE_ID)->get();
          }
          else{
            $infolocationlevelroom= '';      
          }   


          $infotypesystem = DB::table('informcom_systemtype')->get();
          
        return view('general_repair.inforepaircom_edit',[
            'infoassets' => $infoasset,
            'inforpersonuser' => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid,
            'infolocations' => $infolocation,
            'infolocationlevels' => $infolocationlevel,
            'infolocationlevelrooms' => $infolocationlevelroom, 
            'informrepair_techs' => $informrepair_tech,
            'informcomrepair' => $informcomrepair,
            'infoassetothers' => $infoassetother,
            'idlist' => $id,
            'infotypesystems' => $infotypesystem,
         
            
            
        ]);
    }


    
    public function updateinforepaircom(Request $request)
    {
       // return $request->all();

       $DATE_1 = $request->DATE_REQUEST;


       if($DATE_1 != ''){
        $STARTDAY = Carbon::createFromFormat('d/m/Y', $DATE_1)->format('Y-m-d');
        $date_arrary_st=explode("-",$STARTDAY);  
        $y_sub_st = $date_arrary_st[0]; 
        
        if($y_sub_st >= 2500){
            $y_st = $y_sub_st-543;
        }else{
            $y_st = $y_sub_st;
        }
        $m_st = $date_arrary_st[1];
        $d_st = $date_arrary_st[2];  
        $DATE_1= $y_st."-".$m_st."-".$d_st;
        }else{
        $DATE_1= null;
    }

  

            $datere = $DATE_1." ".$request->TIME_REQUEST.":00";

            $m = date('m');
            if($m > 9 && $m < 12 ){
                $YEAR_ID = date('Y')+544;
            }else{
                $YEAR_ID = date('Y')+543;
            }
             
      
            $ID = $request->ID;

            $addinforepair = Informcomrepair::find($ID);
        

            $addinforepair->YEAR_ID =  $YEAR_ID;

            $addinforepair->DATE_TIME_REQUEST = $datere;
            $addinforepair->DATE_SAVE = $DATE_1;
            $addinforepair->USER_REQUEST_ID = $request->USER_REQUEST_ID;
              
               
               //----------------------------------
               
               $USRE_REQUEST_NAME =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
               ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
               ->where('hrd_person.ID','=',$request->USER_REQUEST_ID)->first();
               $addinforepair->USRE_REQUEST_NAME   = $USRE_REQUEST_NAME->HR_PREFIX_NAME.''.$USRE_REQUEST_NAME->HR_FNAME.' '.$USRE_REQUEST_NAME->HR_LNAME;
               
               //----------------------------------

            $addinforepair->REPAIR_NAME = $request->REPAIR_NAME;


            $addinforepair->LOCATION_SEE_ID = $request->LOCATION_SEE_ID;
            $addinforepair->LOCATIONLEVEL_SEE_ID = $request->LOCATIONLEVEL_SEE_ID;
            $addinforepair->LOCATIONLEVELROOM_SEE_ID = $request->LOCATIONLEVELROOM_SEE_ID;

           

           
            if($request->ARTICLE_ID != ''){
                $addinforepair->ARTICLE_ID = $request->ARTICLE_ID;
                }


            $addinforepair->OTHER_NAME = $request->OTHER_NAME;

        
            
         if($request->hasFile('picture')){
            //$newFileName = $picid.'.'.$request->picture->extension();
            
            $file = $request->file('picture');  
            $contents = $file->openFile()->fread($file->getSize());
            $addinforepair->COM_IMG = $contents;   
            //$request->picture->storeAs('images',$newFileName,'public');
            //$inforpersonedit->HR_IMAGE_NAME = $newFileName; 
        }
       
        $addinforepair->SYMPTOM = $request->SYMPTOM;
        $addinforepair->TECH_REPAIR_ID = $request->TECH_REPAIR_ID;

            //----------------------------------
            if($request->TECH_REPAIR_ID != 'not'){
            $TECH_REPAIR_NAME =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
            ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
            ->where('hrd_person.ID','=',$request->TECH_REPAIR_ID)->first();
            $addinforepair->TECH_REPAIR_NAME   = $TECH_REPAIR_NAME->HR_PREFIX_NAME.''.$TECH_REPAIR_NAME->HR_FNAME.' '.$TECH_REPAIR_NAME->HR_LNAME;
            }
            //----------------------------------

        $addinforepair->PRIORITY_ID = $request->PRIORITY_ID;

        $addinforepair->REPAIR_STATUS = 'REQUEST';
  

           $addinforepair->save();

             // dd($addinfocar);

            return redirect()->route('repair.inforepaircom',[
                'iduser' => $request->USER_REQUEST_ID
            ]); 

    }



            //---------------------------ความพึงพอใจซ่อมคอม------------------------------

            public function repaircomfansave(Request $request)
            {
                   
                     
                    $ID = $request->ID;
                //dd($ID);
                    $addfanrepairnomalnomal = Informcomrepair::find($ID);
                    $addfanrepairnomalnomal->FANCINESS_SCORE = $request->FANCINESS_SCORE;
                    $addfanrepairnomalnomal->FANCINESS_REMARK = $request->FANCINESS_REMARK;
                    $addfanrepairnomalnomal->FANCINESS_PERSON_ID = $request->FANCINESS_PERSON_ID;
                    $addfanrepairnomalnomal->FANCINESS_DATE = date('Y-m-d H:i:s');
                    $addfanrepairnomalnomal->save();
            
            
                    return redirect()->route('repair.inforepaircom',[
                        'iduser' => $request->FANCINESS_PERSON_ID
                    ]); 
            
            }


            //---------------------------แจ้งยกเลิกซ่อมทัวไป------------------------------


public function cancelcom(Request $request,$id,$iduser)
{
    //$email = Auth::user()->email;
   $inforpersonuserid =  Person::where('ID','=',$iduser)->first();
   // $iduser = $inforpersonuserid->ID;

    
    $inforpersonuser=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->leftJoin('hrd_sex','hrd_person.SEX','=','hrd_sex.SEX_ID')
    ->leftJoin('hrd_status','hrd_person.HR_STATUS_ID','=','hrd_status.HR_STATUS_ID')
    ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
    ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
    ->leftJoin('hrd_department','hrd_person.HR_DEPARTMENT_ID','=','hrd_department.HR_DEPARTMENT_ID')
    ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
    ->leftJoin('hrd_bloodgroup','hrd_person.HR_BLOODGROUP_ID','=','hrd_bloodgroup.HR_BLOODGROUP_ID')
    ->leftJoin('hrd_marry_status','hrd_person.HR_MARRY_STATUS_ID','=','hrd_marry_status.HR_MARRY_STATUS_ID')
    ->leftJoin('hrd_religion','hrd_person.HR_RELIGION_ID','=','hrd_religion.HR_RELIGION_ID')
    ->leftJoin('hrd_nationality','hrd_person.HR_NATIONALITY_ID','=','hrd_nationality.HR_NATIONALITY_ID')
    ->leftJoin('hrd_citizenship','hrd_person.HR_CITIZENSHIP_ID','=','hrd_citizenship.HR_CITIZENSHIP_ID')
    ->leftJoin('hrd_tumbon','hrd_person.TUMBON_ID','=','hrd_tumbon.ID')
    ->leftJoin('hrd_amphur','hrd_person.AMPHUR_ID','=','hrd_amphur.ID')
    ->leftJoin('hrd_province','hrd_person.PROVINCE_ID','=','hrd_province.ID')
    ->leftJoin('hrd_kind','hrd_person.HR_KIND_ID','=','hrd_kind.HR_KIND_ID')
    ->leftJoin('hrd_kind_type','hrd_person.HR_KIND_TYPE_ID','=','hrd_kind_type.HR_KIND_TYPE_ID')
    ->leftJoin('hrd_person_type','hrd_person.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
    ->where('hrd_person.ID','=',$iduser)->first();

    //dd($id);

    $inforepaircomdetail = Informcomrepair::where('informcom_repair.ID','=',$id)
    ->leftjoin('informrepair_priority','informrepair_priority.PRIORITY_ID','=','informcom_repair.PRIORITY_ID')
    ->leftJoin('asset_article','asset_article.ARTICLE_ID','=','informcom_repair.ARTICLE_ID')
         ->leftjoin('hrd_person','hrd_person.ID','=','informcom_repair.TECH_REPAIR_ID')
         ->leftjoin('supplies_location','informcom_repair.LOCATION_SEE_ID','=','supplies_location.LOCATION_ID')
         ->leftjoin('supplies_location_level','informcom_repair.LOCATIONLEVEL_SEE_ID','=','supplies_location_level.LOCATION_LEVEL_ID')
         ->leftjoin('supplies_location_level_room','informcom_repair.LOCATIONLEVELROOM_SEE_ID','=','supplies_location_level_room.LEVEL_ROOM_ID')
         ->leftjoin('asset_building','informcom_repair.LOCATION_SEE_ID','=','asset_building.ID')
    ->first(); 
      
    //dd($inforepairnomal);
        
        

    return view('general_repair.genrepaircomcancel_check',[
        'inforpersonuser' => $inforpersonuser,
        'inforpersonuserid' => $inforpersonuserid, 
        'inforepaircomdetail' => $inforepaircomdetail,
        'infoid' => $id
    ]);
}


public function updatecancelcom(Request $request)
{
    //$email = Auth::user()->email;
    //return $request->all();
    $id = $request->ID; 

   
      $updatecancel = Informcomrepair::find($id);
      $updatecancel->CANCEL_COMMENT = $request->CANCEL_COMMENT;    
      $updatecancel->CANCEL_USER_EDIT_ID = $request->CANCEL_USER_EDIT_ID; 
      $updatecancel->REPAIR_STATUS = 'REPAIR_OUT'; 

  
  
      $updatecancel->save();
      
          //
          return redirect()->route('repair.inforepaircom',[
            'iduser' => $request->CANCEL_USER_EDIT_ID
        ]); 

        }


//=======================อุปกรณ์เครื่องมือแพทย์================================

        public function inforepairmedical (Request $request,$iduser)
        {
            //$email = Auth::user()->email;
            $inforpersonuserid =  Person::where('ID','=',$iduser)->first();
            $id = $inforpersonuserid->ID;
      
            
            $inforpersonuser=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
            ->leftJoin('hrd_sex','hrd_person.SEX','=','hrd_sex.SEX_ID')
            ->leftJoin('hrd_status','hrd_person.HR_STATUS_ID','=','hrd_status.HR_STATUS_ID')
            ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
            ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
            ->leftJoin('hrd_department','hrd_person.HR_DEPARTMENT_ID','=','hrd_department.HR_DEPARTMENT_ID')
            ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
            ->leftJoin('hrd_bloodgroup','hrd_person.HR_BLOODGROUP_ID','=','hrd_bloodgroup.HR_BLOODGROUP_ID')
            ->leftJoin('hrd_marry_status','hrd_person.HR_MARRY_STATUS_ID','=','hrd_marry_status.HR_MARRY_STATUS_ID')
            ->leftJoin('hrd_religion','hrd_person.HR_RELIGION_ID','=','hrd_religion.HR_RELIGION_ID')
            ->leftJoin('hrd_nationality','hrd_person.HR_NATIONALITY_ID','=','hrd_nationality.HR_NATIONALITY_ID')
            ->leftJoin('hrd_citizenship','hrd_person.HR_CITIZENSHIP_ID','=','hrd_citizenship.HR_CITIZENSHIP_ID')
            ->leftJoin('hrd_tumbon','hrd_person.TUMBON_ID','=','hrd_tumbon.ID')
            ->leftJoin('hrd_amphur','hrd_person.AMPHUR_ID','=','hrd_amphur.ID')
            ->leftJoin('hrd_province','hrd_person.PROVINCE_ID','=','hrd_province.ID')
            ->leftJoin('hrd_kind','hrd_person.HR_KIND_ID','=','hrd_kind.HR_KIND_ID')
            ->leftJoin('hrd_kind_type','hrd_person.HR_KIND_TYPE_ID','=','hrd_kind_type.HR_KIND_TYPE_ID')
            ->leftJoin('hrd_person_type','hrd_person.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
            ->where('hrd_person.ID','=',$iduser)->first();
      
      
      
            $inforepairmedical = Assetcarerepair::where('REPAIR_STATUS','=','REQUEST')
            ->orderBy('ID', 'desc')->get(); 
      
            $infostatus = DB::table('informrepair_status')->get();
      
           
    
            $m_budget = date("m");
            if($m_budget>9){
            $yearbudget = date("Y")+544;
            }else{
            $yearbudget = date("Y")+543;
            }
            
            $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
            $displaydate_bigen = ($yearbudget-544).'-10-01';
            $displaydate_end = ($yearbudget-543).'-09-30';
            $status = 'REQUEST';
            $search = '';
            $year_id = $yearbudget;


            
                $openform_function = Infomrepair_functionmedical::where('FUNCT_REPMEDICAL_STATUS','=','True' )->first();

                // dd($openform_function->FUNCT_REPMEDICAL_CODE);
                if ($openform_function != '') {       
                    $code = $openform_function->FUNCT_REPMEDICAL_CODE;  
                } else {                      
                    $code = '';
                    // dd($code);
                }
        
    
            return view('general_repair.inforepairmedical',[
                'inforepairmedicals' => $inforepairmedical,
                'inforpersonuser' => $inforpersonuser,
                'inforpersonuserid' => $inforpersonuserid, 
                'infostatuss' => $infostatus, 
                'budgets' =>  $budget,
        'displaydate_bigen'=> $displaydate_bigen,
        'displaydate_end'=> $displaydate_end,
        'status_check'=> $status,
        'search'=> $search,
        'year_id'=>$year_id, 
        'codes'=>$code,
             
                
            ]);
        }


        
  public function inforepairmedicalsearch(Request $request,$iduser)
  {

   

      $inforpersonuserid =  Person::where('ID','=',$iduser)->first();
      $id = $inforpersonuserid->ID;

      
      $inforpersonuser=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
      ->leftJoin('hrd_sex','hrd_person.SEX','=','hrd_sex.SEX_ID')
      ->leftJoin('hrd_status','hrd_person.HR_STATUS_ID','=','hrd_status.HR_STATUS_ID')
      ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
      ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
      ->leftJoin('hrd_department','hrd_person.HR_DEPARTMENT_ID','=','hrd_department.HR_DEPARTMENT_ID')
      ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
      ->leftJoin('hrd_bloodgroup','hrd_person.HR_BLOODGROUP_ID','=','hrd_bloodgroup.HR_BLOODGROUP_ID')
      ->leftJoin('hrd_marry_status','hrd_person.HR_MARRY_STATUS_ID','=','hrd_marry_status.HR_MARRY_STATUS_ID')
      ->leftJoin('hrd_religion','hrd_person.HR_RELIGION_ID','=','hrd_religion.HR_RELIGION_ID')
      ->leftJoin('hrd_nationality','hrd_person.HR_NATIONALITY_ID','=','hrd_nationality.HR_NATIONALITY_ID')
      ->leftJoin('hrd_citizenship','hrd_person.HR_CITIZENSHIP_ID','=','hrd_citizenship.HR_CITIZENSHIP_ID')
      ->leftJoin('hrd_tumbon','hrd_person.TUMBON_ID','=','hrd_tumbon.ID')
      ->leftJoin('hrd_amphur','hrd_person.AMPHUR_ID','=','hrd_amphur.ID')
      ->leftJoin('hrd_province','hrd_person.PROVINCE_ID','=','hrd_province.ID')
      ->leftJoin('hrd_kind','hrd_person.HR_KIND_ID','=','hrd_kind.HR_KIND_ID')
      ->leftJoin('hrd_kind_type','hrd_person.HR_KIND_TYPE_ID','=','hrd_kind_type.HR_KIND_TYPE_ID')
      ->leftJoin('hrd_person_type','hrd_person.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
      ->where('hrd_person.ID','=',$iduser)->first();



      $search = $request->get('search');
      $status = $request->SEND_STATUS;
      $datebigin = $request->get('DATE_BIGIN');
      $dateend = $request->get('DATE_END');
      $yearbudget = $request->BUDGET_YEAR;

      if($search==''){
          $search="";
      }

      if($datebigin == '' || $dateend == ''){
          $displaydate_bigen = '';
          $displaydate_end = '';
      }else{    

      $date_bigen_c = Carbon::createFromFormat('d/m/Y', $datebigin)->format('Y-m-d');
      $date_arrary=explode("-",$date_bigen_c);

      $y_sub_st = $date_arrary[0];

      if($y_sub_st >= 2500){
          $y = $y_sub_st-543;
      }else{
          $y = $y_sub_st;
      }

      $m = $date_arrary[1];
      $d = $date_arrary[2];  
      $displaydate_bigen= $y."-".$m."-".$d;

      $date_end_c = Carbon::createFromFormat('d/m/Y', $dateend)->format('Y-m-d');
      $date_arrary_e=explode("-",$date_end_c); 

      $y_sub_e = $date_arrary_e[0];

      if($y_sub_e >= 2500){
          $y_e = $y_sub_e-543;
      }else{
          $y_e = $y_sub_e;
      }

      $m_e = $date_arrary_e[1];
      $d_e = $date_arrary_e[2];  
      $displaydate_end= $y_e."-".$m_e."-".$d_e;



      $date = date('Y-m-d');
      $date_bigen_checks = strtotime($displaydate_bigen);
      $date_end_checks =  strtotime($displaydate_end);
      $dates =  strtotime($date);
         
  }


          $from = date($displaydate_bigen);
          $to = date($displaydate_end);

          
          if($status == null){


              $inforepairmedical = Assetcarerepair::where(function($q) use ($search){
                  $q->where('REPAIR_ID','like','%'.$search.'%');
                  $q->orwhere('REPAIR_NAME','like','%'.$search.'%');
                  $q->orwhere('SYMPTOM','like','%'.$search.'%');
                  $q->orwhere('USRE_REQUEST_NAME','like','%'.$search.'%');
                  })
                  ->WhereBetween('DATE_TIME_REQUEST',[$from.' 00:00:00',$to.' 23:59:00']) 
              ->orderBy('ID', 'desc')->get(); 



          }else{


              $inforepairmedical = Assetcarerepair::where('REPAIR_STATUS','=',$status)
              ->where(function($q) use ($search){
                  $q->where('REPAIR_ID','like','%'.$search.'%');
                  $q->orwhere('REPAIR_NAME','like','%'.$search.'%');
                  $q->orwhere('SYMPTOM','like','%'.$search.'%');
                  $q->orwhere('USRE_REQUEST_NAME','like','%'.$search.'%');
                  })
                  ->WhereBetween('DATE_TIME_REQUEST',[$from.' 00:00:00',$to.' 23:59:00']) 
              ->orderBy('ID', 'desc')->get(); 

          
          }
  

    
     
      
    

      $infostatus = DB::table('informrepair_status')->get();

      $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
      $year_id = $yearbudget;

      $openform_function = Infomrepair_functionmedical::where('FUNCT_REPMEDICAL_STATUS','=','True' )->first();

      // dd($openform_function->FUNCT_REPMEDICAL_CODE);
      if ($openform_function != '') {       
          $code = $openform_function->FUNCT_REPMEDICAL_CODE;  
      } else {                      
          $code = '';
          // dd($code);
      }
     
      return view('general_repair.inforepairmedical',[
         'inforepairmedicals' => $inforepairmedical,
         'inforpersonuser' => $inforpersonuser,
         'inforpersonuserid' => $inforpersonuserid, 
          'infostatuss' => $infostatus, 
          'budgets' =>  $budget,
          'displaydate_bigen'=> $displaydate_bigen,
          'displaydate_end'=> $displaydate_end,
          'status_check'=> $status,
          'search'=> $search,
          'year_id'=>$year_id, 
          'codes'=>$code,
       
          
      ]);


  }
    
    
        public function detailrepairmedical(Request $request)
        {
            function DateThai($strDate)
            {
            $strYear = date("Y",strtotime($strDate))+543;
            $strMonth= date("n",strtotime($strDate));
            $strDay= date("j",strtotime($strDate));
        
            $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
            $strMonthThai=$strMonthCut[$strMonth];
            return "$strDay $strMonthThai $strYear";
            }
        
            function formateDatetime($strDate)
            {
              $strYear = date("Y",strtotime($strDate))+543;
              $strMonth= date("n",strtotime($strDate));
              $strDay= date("j",strtotime($strDate));
          
              $H= date("H",strtotime($strDate));
              $I= date("i",strtotime($strDate));
          
            $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
            $strMonthThai=$strMonthCut[$strMonth];
          
            return  "$strDay $strMonthThai $strYear $H:$I";
              }
        
        
        
        
                 $inforepairmedical = Assetcarerepair::where('asset_care_repair.ID','=',$request->id)
                 ->leftjoin('informrepair_priority','informrepair_priority.PRIORITY_ID','=','asset_care_repair.PRIORITY_ID')
                 ->leftJoin('asset_article','asset_article.ARTICLE_ID','=','asset_care_repair.ARTICLE_ID')
                 ->leftjoin('supplies_location','asset_care_repair.LOCATION_SEE_ID','=','supplies_location.LOCATION_ID')
                 ->leftjoin('supplies_location_level','asset_care_repair.LOCATIONLEVEL_SEE_ID','=','supplies_location_level.LOCATION_LEVEL_ID')
                 ->leftjoin('supplies_location_level_room','asset_care_repair.LOCATIONLEVELROOM_SEE_ID','=','supplies_location_level_room.LEVEL_ROOM_ID')                 
                 ->leftjoin('hrd_person','asset_care_repair.USER_REQUEST_ID','=','hrd_person.ID')
                 ->leftjoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_SUB_ID')
                //  ->leftjoin('asset_building','asset_care_repair.LOCATION_SEE_ID','=','asset_building.ID')
                 ->first(); 
        
              
              
        
        
  $output='    
  
  <div class="row push" style="font-family: \'Kanit\', sans-serif;">
  
  <div class="col-sm-9">
  
    <div class="row">
        <div class="col-lg-2" align="right">
        <label>รหัสรายการ :</label>
        </div> 
        <div class="col-lg-8" align="left">
        '.$inforepairmedical->REPAIR_ID.'
        </div> 
    </div>    
    <div class="row">
        <div class="col-lg-2" align="right">
        <label>วันที่แจ้ง :</label>
        </div> 
        <div class="col-lg-4" align="left">
        '.formateDatetime($inforepairmedical->DATE_TIME_REQUEST).'
        </div> 
        <div class="col-lg-2" align="right">
        <label>อาคาร :</label>
        </div> 
        <div class="col-lg-4" align="left">
        '.$inforepairmedical->LOCATION_NAME.'
        </div> 
    </div>    
    
    <div class="row">
        <div class="col-lg-2" align="right">
        <label>ชั้น :</label>
        </div> 
        <div class="col-lg-4" align="left">
        '.$inforepairmedical->LOCATION_LEVEL_NAME.'
        </div> 
        <div class="col-lg-2" align="right">
        <label>ห้อง :</label>
        </div> 
        <div class="col-lg-4" align="left">
        '.$inforepairmedical->LEVEL_ROOM_NAME.'
        </div> 
   
    </div>    
  
    <div class="row">
    <div class="col-lg-2" align="right">
    <label>แจ้งซ่อม :</label>
    </div> 
    <div class="col-lg-8" align="left">
   '.$inforepairmedical->REPAIR_NAME.'
    </div> 
   </div>  
   
   <div class="row">
   <div class="col-lg-2" align="right">
   <label>รหัสครุภัณฑ์ :</label>
   </div> 
   <div class="col-lg-4" align="left">
  '.$inforepairmedical->ARTICLE_NUM.'
   </div> 
   <div class="col-lg-2" align="right">
   <label>ชื่อครุภัณฑ์ :</label>
   </div> 
   <div class="col-lg-4" align="left">
   '.$inforepairmedical->ARTICLE_NAME.'
   </div> 
  </div>  

  <div class="row">
  <div class="col-lg-2" align="right">
  <label>ครุภัณฑ์อื่น :</label>
  </div> 
  <div class="col-lg-4" align="left">
 '.$inforepairmedical->OTHER_NAME.'
  </div> 
  
 </div>  
  
  <div class="row">
  <div class="col-lg-2" align="right">
  <label>อาการ :</label>
  </div> 
  <div class="col-lg-10" align="left">
  '.$inforepairmedical->SYMPTOM.'
  </div> 
  
  </div>  
  
  <div class="row">
  <div class="col-lg-2" align="right">
  <label>ความเร่งด่วน :</label>
  </div> 
  <div class="col-lg-6" align="left">
  '.$inforepairmedical->PRIORITY_NAME.'
  </div> 
  
  </div>   
  
  <div class="row">
  <div class="col-lg-2" align="right">
  <label>ผู้แจ้งซ่อม :</label>
  </div> 
  <div class="col-lg-4" align="left">
  '.$inforepairmedical->USRE_REQUEST_NAME.'
  </div>
  <div class="col-lg-2" align="right">
  <label>ฝ่าย/แผนก :</label>
  </div> 
  <div class="col-lg-4" align="left">
  '.$inforepairmedical->HR_DEPARTMENT_SUB_SUB_NAME.'
  </div>
  </div>     
  
  
  
  <div class="row">
  <div class="col-lg-2" align="right">
  <label>รายละเอียดซ่อม  :</label>
  </div> 
  <div class="col-lg-10" align="left">
  '.$inforepairmedical->REPAIR_COMMENT.'
  </div>
  
  </div>     
  </div>

  
  <div class="col-sm-3">
  
  <div class="form-group">
  
  <img src="data:image/png;base64,'. chunk_split(base64_encode($inforepairmedical->MED_IMG)) .'" id="image_upload_preview" alt="กรุณาเพิ่มรูปภาพ" height="200" width="200"/>
  </div>
  
  </div>
  </div>
  
  
  
  
  </div>
  
  
  </div>
  
  ';
  
  echo $output;
        
        
        }

        //-------------------------เพิ่มข้อมูลอุปกรณ์เครื่องมือแพทย์

  public function createinforepairmedical (Request $request,$iduser)
  {
      //$email = Auth::user()->email;
      $inforpersonuserid =  Person::where('ID','=',$iduser)->first();
      $id = $inforpersonuserid->ID;

      
      $inforpersonuser=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
      ->leftJoin('hrd_sex','hrd_person.SEX','=','hrd_sex.SEX_ID')
      ->leftJoin('hrd_status','hrd_person.HR_STATUS_ID','=','hrd_status.HR_STATUS_ID')
      ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
      ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
      ->leftJoin('hrd_department','hrd_person.HR_DEPARTMENT_ID','=','hrd_department.HR_DEPARTMENT_ID')
      ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
      ->leftJoin('hrd_bloodgroup','hrd_person.HR_BLOODGROUP_ID','=','hrd_bloodgroup.HR_BLOODGROUP_ID')
      ->leftJoin('hrd_marry_status','hrd_person.HR_MARRY_STATUS_ID','=','hrd_marry_status.HR_MARRY_STATUS_ID')
      ->leftJoin('hrd_religion','hrd_person.HR_RELIGION_ID','=','hrd_religion.HR_RELIGION_ID')
      ->leftJoin('hrd_nationality','hrd_person.HR_NATIONALITY_ID','=','hrd_nationality.HR_NATIONALITY_ID')
      ->leftJoin('hrd_citizenship','hrd_person.HR_CITIZENSHIP_ID','=','hrd_citizenship.HR_CITIZENSHIP_ID')
      ->leftJoin('hrd_tumbon','hrd_person.TUMBON_ID','=','hrd_tumbon.ID')
      ->leftJoin('hrd_amphur','hrd_person.AMPHUR_ID','=','hrd_amphur.ID')
      ->leftJoin('hrd_province','hrd_person.PROVINCE_ID','=','hrd_province.ID')
      ->leftJoin('hrd_kind','hrd_person.HR_KIND_ID','=','hrd_kind.HR_KIND_ID')
      ->leftJoin('hrd_kind_type','hrd_person.HR_KIND_TYPE_ID','=','hrd_kind_type.HR_KIND_TYPE_ID')
      ->leftJoin('hrd_person_type','hrd_person.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
      ->where('hrd_person.ID','=',$iduser)->first();

       $infoasset = DB::table('asset_article')->where('DECLINE_ID','=',17)->get();  


       $infolocation = DB::table('supplies_location')->get();
       $infolocationlevel = DB::table('supplies_location_level')->get();
       $infolocationlevelroom = DB::table('supplies_location_level_room')->get();

       $informrepair_tech = DB::table('asset_care_enginer')
       ->leftJoin('hrd_person','hrd_person.ID','=','asset_care_enginer.PERSON_ID')
       ->get();

       $infotypesystem = DB::table('asset_care_systemtype')->get();

      return view('general_repair.inforepairmedical_add',[
          'infoassets' => $infoasset,
          'inforpersonuser' => $inforpersonuser,
          'inforpersonuserid' => $inforpersonuserid,
          'infolocations' => $infolocation,
          'infolocationlevels' => $infolocationlevel,
          'infolocationlevelrooms' => $infolocationlevelroom, 
          'informrepair_techs' => $informrepair_tech,
          'infotypesystems' => $infotypesystem,
          
      ]);
  }

   //-------------------------------------ฟังชั่นรันเลขอ้างอิงอุปกรณ์เครื่องมือแพทย์--------------------
  
   public static function refnumbermedical()
   {
       $year = date('Y');

       $maxnumber = DB::table('asset_care_repair')->where('DATE_TIME_REQUEST','like',$year.'%')->max('ID');  

    

       if($maxnumber != '' ||  $maxnumber != null){
           
           $refmax = DB::table('asset_care_repair')->where('ID','=',$maxnumber)->first();  

           
           if($refmax->REPAIR_ID != '' ||  $refmax->REPAIR_ID != null){
              $maxref = substr($refmax->REPAIR_ID, -4)+1;
           }else{
              $maxref = 1;
           }
           

           $ref = str_pad($maxref, 5, "0", STR_PAD_LEFT);
      
       }else{
           $ref = '00001';
       }

       $ye = date('Y')+543;
       $y = substr($ye, -2);
       //$m = date('m');
       // = date('d');

   $refnumber ='M'.$y.'-'.$ref;

    return $refnumber;
   }


 
  public function saveinforepairmedical(Request $request)
  {
     // return $request->all();

     $DATE_1 = $request->DATE_REQUEST;


     if($DATE_1 != ''){
      $STARTDAY = Carbon::createFromFormat('d/m/Y', $DATE_1)->format('Y-m-d');
      $date_arrary_st=explode("-",$STARTDAY);  
      $y_sub_st = $date_arrary_st[0]; 
      
      if($y_sub_st >= 2500){
          $y_st = $y_sub_st-543;
      }else{
          $y_st = $y_sub_st;
      }
      $m_st = $date_arrary_st[1];
      $d_st = $date_arrary_st[2];  
      $DATE_1= $y_st."-".$m_st."-".$d_st;
      }else{
      $DATE_1= null;
  }
   
          $datere = $DATE_1." ".$request->TIME_REQUEST.":00";
    //------------------------------------------------------------------
          $m = date('m');
          if($m > 9 && $m < 12 ){
              $YEAR_ID = date('Y')+544;
          }else{
              $YEAR_ID = date('Y')+543;
          }
           

          //========================================

          $year = date('Y');
          $maxnumber = DB::table('asset_care_repair')->where('DATE_TIME_REQUEST','like',$year.'%')->max('ID');   
          if($maxnumber != '' ||  $maxnumber != null){       
              $refmax = DB::table('asset_care_repair')->where('ID','=',$maxnumber)->first();        
              if($refmax->REPAIR_ID != '' ||  $refmax->REPAIR_ID != null){
                 $maxref = substr($refmax->REPAIR_ID, -4)+1;
              }else{
                 $maxref = 1;
              }
              $ref = str_pad($maxref, 5, "0", STR_PAD_LEFT);
          }else{
              $ref = '00001';
          }
   
          $ye = date('Y')+543;
          $y = substr($ye, -2);
      $refnumber ='M'.$y.'-'.$ref;


          //=============================================
         

          $addinforepair = new Assetcarerepair(); 
          $addinforepair->REPAIR_ID =  $refnumber;
          $addinforepair->YEAR_ID =  $YEAR_ID;

          $addinforepair->DATE_TIME_REQUEST = $datere;
          $addinforepair->DATE_SAVE = $DATE_1;
             $addinforepair->USER_REQUEST_ID = $request->USER_REQUEST_ID;
            
             
             //----------------------------------
             $USRE_REQUEST_NAME =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
             ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
             ->where('hrd_person.ID','=',$request->USER_REQUEST_ID)->first();
             $addinforepair->USRE_REQUEST_NAME   = $USRE_REQUEST_NAME->HR_PREFIX_NAME.''.$USRE_REQUEST_NAME->HR_FNAME.' '.$USRE_REQUEST_NAME->HR_LNAME;
 
             //----------------------------------

          $addinforepair->REPAIR_NAME = $request->REPAIR_NAME;


          $addinforepair->LOCATION_SEE_ID = $request->LOCATION_SEE_ID;
          $addinforepair->LOCATIONLEVEL_SEE_ID = $request->LOCATIONLEVEL_SEE_ID;
          $addinforepair->LOCATIONLEVELROOM_SEE_ID = $request->LOCATIONLEVELROOM_SEE_ID;

         
          if($request->ARTICLE_ID != ''){
            $addinforepair->ARTICLE_ID = $request->ARTICLE_ID;
            }

          $addinforepair->OTHER_NAME = $request->OTHER_NAME;

      
          
       if($request->hasFile('picture')){
          //$newFileName = $picid.'.'.$request->picture->extension();
          
          $file = $request->file('picture');  
          $contents = $file->openFile()->fread($file->getSize());
          $addinforepair->MED_IMG = $contents;   
          //$request->picture->storeAs('images',$newFileName,'public');
          //$inforpersonedit->HR_IMAGE_NAME = $newFileName; 
      }
     
      $addinforepair->SYMPTOM = $request->SYMPTOM;
      $addinforepair->TECH_REPAIR_ID = $request->TECH_REPAIR_ID;

          //----------------------------------
          if($request->TECH_REPAIR_ID != 'not'){
          $TECH_REPAIR_NAME =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
          ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
          ->where('hrd_person.ID','=',$request->TECH_REPAIR_ID)->first();
          $addinforepair->TECH_REPAIR_NAME   = $TECH_REPAIR_NAME->HR_PREFIX_NAME.''.$TECH_REPAIR_NAME->HR_FNAME.' '.$TECH_REPAIR_NAME->HR_LNAME;
          }
          //----------------------------------

      $addinforepair->PRIORITY_ID = $request->PRIORITY_ID;
      $addinforepair->REPAIR_SYSTEM = $request->REPAIR_SYSTEM;

      $addinforepair->REPAIR_STATUS = 'REQUEST';


          $addinforepair->save();

           // dd($addinfocar);


           $header = "ระบบแจ้งซ่อมเครื่องมือแพทย์";
           $REPAIRID = $request->REPAIR_ID;
           $REPAIRNAME = $request->REPAIR_NAME; 
           $SYMPTOM = $request->SYMPTOM;  
           $USREREQUESTNAME = $USRE_REQUEST_NAME->HR_PREFIX_NAME.''.$USRE_REQUEST_NAME->HR_FNAME.' '.$USRE_REQUEST_NAME->HR_LNAME;
          
           if($request->TECH_REPAIR_ID == 'not'){
                $TECHREPAIRNAME   = '';
           }else{
                $TECHREPAIRNAME   = $TECH_REPAIR_NAME->HR_PREFIX_NAME.''.$TECH_REPAIR_NAME->HR_FNAME.' '.$TECH_REPAIR_NAME->HR_LNAME;
           }
           
       
           if($request->ARTICLE_ID != ''){
            $ARTICLE_ID = $request->ARTICLE_ID;
            }else{
                $ARTICLE_ID = '';
            }

         
             
            $infolocation = DB::table('supplies_location')->where('LOCATION_ID','=',$request->LOCATION_SEE_ID)->first();
            $LOCATION_SEE_NAME = $infolocation->LOCATION_NAME;

            $infolocationlevel = DB::table('supplies_location_level')->where('LOCATION_LEVEL_ID','=',$request->LOCATIONLEVEL_SEE_ID)->first();
            $LOCATIONLEVEL_SEE_NAME = $infolocationlevel->LOCATION_LEVEL_NAME;

            $infolocationlevelroom = DB::table('supplies_location_level_room')->where('LEVEL_ROOM_ID','=',$request->LOCATIONLEVELROOM_SEE_ID)->first();
            $LOCATIONLEVELROOM_SEE_NAME = $infolocationlevelroom->LEVEL_ROOM_NAME;

            $infoinformrepairpriority = DB::table('informrepair_priority')->where('PRIORITY_ID','=',$request->PRIORITY_ID)->first();
            $PRIORITY_NAME = $infoinformrepairpriority->PRIORITY_NAME;

            $infohrddepartmentsubsub = DB::table('hrd_department_sub_sub')->where('HR_DEPARTMENT_SUB_SUB_ID','=',$USRE_REQUEST_NAME->HR_DEPARTMENT_SUB_SUB_ID)->first();   
            $HR_DEPARTMENT_SUB_SUB_NAME = $infohrddepartmentsubsub->HR_DEPARTMENT_SUB_SUB_NAME;

        $message = $header.
            "\n"."รหัส : " . $REPAIRID .
            "\n"."แจ้งซ่อม : " . $REPAIRNAME .
            "\n"."ครุภัณฑ์ : " . $ARTICLE_ID .
            "\n"."อาการ : " . $SYMPTOM .  
            "\n"."สถานที่พบ : " . $LOCATION_SEE_NAME .
            "\n"."ชั้น : " . $LOCATIONLEVEL_SEE_NAME .
            "\n"."ห้อง : " . $LOCATIONLEVELROOM_SEE_NAME .
            "\n"."ความเร่งด่วน : " . $PRIORITY_NAME .           
            "\n"."ผู้ร้องขอ : " . $USREREQUESTNAME .
            "\n"."หน่วยงาน : " . $HR_DEPARTMENT_SUB_SUB_NAME . 
            "\n"."ช่างที่ถูกร้องขอ : " . $TECHREPAIRNAME ;
       
                   $name = DB::table('line_token')->where('ID_LINE_TOKEN','=',6)->first();        
                   $test =$name->LINE_TOKEN;
       
                   $chOne = curl_init();
                   curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
                   curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0);
                   curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0);
                   curl_setopt( $chOne, CURLOPT_POST, 1);
                   curl_setopt( $chOne, CURLOPT_POSTFIELDS, $message);
                   curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=$message");
                   curl_setopt( $chOne, CURLOPT_FOLLOWLOCATION, 1);
                   $headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$test.'', );
                   curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
                   curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1);
                   $result = curl_exec( $chOne );
                   if(curl_error($chOne)) { echo 'error:' . curl_error($chOne); }
                   else { $result_ = json_decode($result, true);
                   echo "status : ".$result_['status']; echo "message : ". $result_['message']; }
                   curl_close( $chOne );



                           //แจ้งเตือนกลุ่มหน่วยงาน
                $name_re = DB::table('hrd_person')->where('ID','=',$request->USER_REQUEST_ID)->first();  
                $name_request = DB::table('hrd_department_sub_sub')->where('HR_DEPARTMENT_SUB_SUB_ID','=',$name_re->HR_DEPARTMENT_SUB_SUB_ID)->first();        
                $tokendepsubsub =$name_request->LINE_TOKEN;

                $chOne3 = curl_init();
              curl_setopt( $chOne3, CURLOPT_URL, "https://notify-api.line.me/api/notify");
              curl_setopt( $chOne3, CURLOPT_SSL_VERIFYHOST, 0);
              curl_setopt( $chOne3, CURLOPT_SSL_VERIFYPEER, 0);
              curl_setopt( $chOne3, CURLOPT_POST, 1);
              curl_setopt( $chOne3, CURLOPT_POSTFIELDS, $message);
              curl_setopt( $chOne3, CURLOPT_POSTFIELDS, "message=$message");
              curl_setopt( $chOne3, CURLOPT_FOLLOWLOCATION, 1);
              $headers3 = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$tokendepsubsub.'', );
              curl_setopt($chOne3, CURLOPT_HTTPHEADER, $headers3);
              curl_setopt( $chOne3, CURLOPT_RETURNTRANSFER, 1);
              $result3 = curl_exec( $chOne3 );
              if(curl_error($chOne3)) { echo 'error:' . curl_error($chOne3); }
              else { $result_ = json_decode($result3, true);
              echo "status : ".$result_['status']; echo "message : ". $result_['message']; }
              curl_close( $chOne3 );


          return redirect()->route('repair.inforepairmedical',[
              'iduser' => $request->USER_REQUEST_ID
          ]); 

  }

        //---------------------------ความพึงพอใจซ่อมเครื่องมือแพทย์-----------------------------

        public function repairmedicalfansave(Request $request)
        {
               
                 
                $ID = $request->ID;
            //dd($ID);
                $addfanrepair = Assetcarerepair::find($ID);
                $addfanrepair->FANCINESS_SCORE = $request->FANCINESS_SCORE;
                $addfanrepair->FANCINESS_REMARK = $request->FANCINESS_REMARK;
                $addfanrepair->FANCINESS_PERSON_ID = $request->FANCINESS_PERSON_ID;
                $addfanrepair->FANCINESS_DATE = date('Y-m-d H:i:s');
                $addfanrepair->save();
        
        
                return redirect()->route('repair.inforepairmedical',[
                    'iduser' => $request->FANCINESS_PERSON_ID
                ]); 
        
        }



        //---------------------------------แก้ไข----------------------------------

    public function editinforepairmedical (Request $request,$id,$iduser)
    {
        //$email = Auth::user()->email;
        $inforpersonuserid =  Person::where('ID','=',$iduser)->first();
        //$id = $inforpersonuserid->ID;

        
        $inforpersonuser=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_sex','hrd_person.SEX','=','hrd_sex.SEX_ID')
        ->leftJoin('hrd_status','hrd_person.HR_STATUS_ID','=','hrd_status.HR_STATUS_ID')
        ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
        ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->leftJoin('hrd_department','hrd_person.HR_DEPARTMENT_ID','=','hrd_department.HR_DEPARTMENT_ID')
        ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
        ->leftJoin('hrd_bloodgroup','hrd_person.HR_BLOODGROUP_ID','=','hrd_bloodgroup.HR_BLOODGROUP_ID')
        ->leftJoin('hrd_marry_status','hrd_person.HR_MARRY_STATUS_ID','=','hrd_marry_status.HR_MARRY_STATUS_ID')
        ->leftJoin('hrd_religion','hrd_person.HR_RELIGION_ID','=','hrd_religion.HR_RELIGION_ID')
        ->leftJoin('hrd_nationality','hrd_person.HR_NATIONALITY_ID','=','hrd_nationality.HR_NATIONALITY_ID')
        ->leftJoin('hrd_citizenship','hrd_person.HR_CITIZENSHIP_ID','=','hrd_citizenship.HR_CITIZENSHIP_ID')
        ->leftJoin('hrd_tumbon','hrd_person.TUMBON_ID','=','hrd_tumbon.ID')
        ->leftJoin('hrd_amphur','hrd_person.AMPHUR_ID','=','hrd_amphur.ID')
        ->leftJoin('hrd_province','hrd_person.PROVINCE_ID','=','hrd_province.ID')
        ->leftJoin('hrd_kind','hrd_person.HR_KIND_ID','=','hrd_kind.HR_KIND_ID')
        ->leftJoin('hrd_kind_type','hrd_person.HR_KIND_TYPE_ID','=','hrd_kind_type.HR_KIND_TYPE_ID')
        ->leftJoin('hrd_person_type','hrd_person.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
        ->where('hrd_person.ID','=',$iduser)->first();

         $infoasset = DB::table('asset_article')->where('DECLINE_ID','=',17)->get();  


         $infolocation = DB::table('supplies_location')->get();
         //$infolocationlevel = DB::table('supplies_location_level')->get();
         //$infolocationlevelroom = DB::table('supplies_location_level_room')->get();

         $informrepair_tech = DB::table('asset_care_enginer')
         ->leftJoin('hrd_person','hrd_person.ID','=','asset_care_enginer.PERSON_ID')
         ->get();


         $informmedicalrepair = Assetcarerepair::where('ID','=',$id)
         ->leftJoin('asset_article','asset_article.ARTICLE_ID','=','asset_care_repair.ARTICLE_ID')
         ->first();


          $infoassetother = DB::table('informrepair_other')->get();

          $infotypesystem = DB::table('asset_care_systemtype')->get();
          

          if($informmedicalrepair->LOCATION_SEE_ID != ''){
            $infolocationlevel= DB::table('supplies_location_level')->where('LOCATION_ID','=',$informmedicalrepair->LOCATION_SEE_ID)->get();
          }
          else{
            $infolocationlevel= '';      
          }   
          

          if($informmedicalrepair->LOCATIONLEVEL_SEE_ID != ''){
            $infolocationlevelroom= DB::table('supplies_location_level_room')->where('LOCATION_LEVEL_ID','=',$informmedicalrepair->LOCATIONLEVEL_SEE_ID)->get();
          }
          else{
            $infolocationlevelroom= '';      
          }   


          
          
        return view('general_repair.inforepairmedical_edit',[
            'infoassets' => $infoasset,
            'id' => $id,
            'inforpersonuser' => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid,
            'infolocations' => $infolocation,
            'infolocationlevels' => $infolocationlevel,
            'infolocationlevelrooms' => $infolocationlevelroom, 
            'informrepair_techs' => $informrepair_tech,
            'informmedicalrepair' => $informmedicalrepair,
            'infoassetothers' => $infoassetother,
            'infotypesystems' => $infotypesystem,
           
         
            
            
        ]);
    }


    
    public function updateinforepairmedical(Request $request)
    {
       // return $request->all();

       $DATE_1 = $request->DATE_REQUEST;


       if($DATE_1 != ''){
        $STARTDAY = Carbon::createFromFormat('d/m/Y', $DATE_1)->format('Y-m-d');
        $date_arrary_st=explode("-",$STARTDAY);  
        $y_sub_st = $date_arrary_st[0]; 
        
        if($y_sub_st >= 2500){
            $y_st = $y_sub_st-543;
        }else{
            $y_st = $y_sub_st;
        }
        $m_st = $date_arrary_st[1];
        $d_st = $date_arrary_st[2];  
        $DATE_1= $y_st."-".$m_st."-".$d_st;
        }else{
        $DATE_1= null;
    }

  

            $datere = $DATE_1." ".$request->TIME_REQUEST.":00";

            $m = date('m');
            if($m > 9 && $m < 12 ){
                $YEAR_ID = date('Y')+544;
            }else{
                $YEAR_ID = date('Y')+543;
            }
             
      
            $ID = $request->ID;

            $addinforepair = Assetcarerepair::find($ID);
        

            $addinforepair->YEAR_ID =  $YEAR_ID;

            $addinforepair->DATE_TIME_REQUEST = $datere;
            $addinforepair->DATE_SAVE = $DATE_1;
               $addinforepair->USER_REQUEST_ID = $request->USER_REQUEST_ID;
              
               
               //----------------------------------
               $USRE_REQUEST_NAME =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
               ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
               ->where('hrd_person.ID','=',$request->USER_REQUEST_ID)->first();
               $addinforepair->USRE_REQUEST_NAME   = $USRE_REQUEST_NAME->HR_PREFIX_NAME.''.$USRE_REQUEST_NAME->HR_FNAME.' '.$USRE_REQUEST_NAME->HR_LNAME;
   
               //----------------------------------

            $addinforepair->REPAIR_NAME = $request->REPAIR_NAME;


            $addinforepair->LOCATION_SEE_ID = $request->LOCATION_SEE_ID;
            $addinforepair->LOCATIONLEVEL_SEE_ID = $request->LOCATIONLEVEL_SEE_ID;
            $addinforepair->LOCATIONLEVELROOM_SEE_ID = $request->LOCATIONLEVELROOM_SEE_ID;

          
            if($request->ARTICLE_ID != ''){
                $addinforepair->ARTICLE_ID = $request->ARTICLE_ID;
                }

            $addinforepair->OTHER_NAME = $request->OTHER_NAME;

        
            
         if($request->hasFile('picture')){
          
            $file = $request->file('picture');  
            $contents = $file->openFile()->fread($file->getSize());
            $addinforepair->COM_IMG = $contents;   
         
        }
       
        $addinforepair->SYMPTOM = $request->SYMPTOM;
        $addinforepair->TECH_REPAIR_ID = $request->TECH_REPAIR_ID;

            //----------------------------------
            if($request->TECH_REPAIR_ID != 'not'){
            $TECH_REPAIR_NAME =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
            ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
            ->where('hrd_person.ID','=',$request->TECH_REPAIR_ID)->first();
            $addinforepair->TECH_REPAIR_NAME   = $TECH_REPAIR_NAME->HR_PREFIX_NAME.''.$TECH_REPAIR_NAME->HR_FNAME.' '.$TECH_REPAIR_NAME->HR_LNAME;
            }
            //----------------------------------

        $addinforepair->PRIORITY_ID = $request->PRIORITY_ID;
        $addinforepair->REPAIR_SYSTEM = $request->REPAIR_SYSTEM;

        $addinforepair->REPAIR_STATUS = 'REQUEST';
  

           $addinforepair->save();

             // dd($addinfocar);

            return redirect()->route('repair.inforepairmedical',[
                'iduser' => $request->USER_REQUEST_ID
            ]); 

    }


         //---------------------------แจ้งยกเลิกซ่อมอุปกรณ์การแพทย์------------------------------


public function cancelmedical(Request $request,$id,$iduser)
{
    //$email = Auth::user()->email;
   $inforpersonuserid =  Person::where('ID','=',$iduser)->first();
   // $iduser = $inforpersonuserid->ID;

    
    $inforpersonuser=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->leftJoin('hrd_sex','hrd_person.SEX','=','hrd_sex.SEX_ID')
    ->leftJoin('hrd_status','hrd_person.HR_STATUS_ID','=','hrd_status.HR_STATUS_ID')
    ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
    ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
    ->leftJoin('hrd_department','hrd_person.HR_DEPARTMENT_ID','=','hrd_department.HR_DEPARTMENT_ID')
    ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
    ->leftJoin('hrd_bloodgroup','hrd_person.HR_BLOODGROUP_ID','=','hrd_bloodgroup.HR_BLOODGROUP_ID')
    ->leftJoin('hrd_marry_status','hrd_person.HR_MARRY_STATUS_ID','=','hrd_marry_status.HR_MARRY_STATUS_ID')
    ->leftJoin('hrd_religion','hrd_person.HR_RELIGION_ID','=','hrd_religion.HR_RELIGION_ID')
    ->leftJoin('hrd_nationality','hrd_person.HR_NATIONALITY_ID','=','hrd_nationality.HR_NATIONALITY_ID')
    ->leftJoin('hrd_citizenship','hrd_person.HR_CITIZENSHIP_ID','=','hrd_citizenship.HR_CITIZENSHIP_ID')
    ->leftJoin('hrd_tumbon','hrd_person.TUMBON_ID','=','hrd_tumbon.ID')
    ->leftJoin('hrd_amphur','hrd_person.AMPHUR_ID','=','hrd_amphur.ID')
    ->leftJoin('hrd_province','hrd_person.PROVINCE_ID','=','hrd_province.ID')
    ->leftJoin('hrd_kind','hrd_person.HR_KIND_ID','=','hrd_kind.HR_KIND_ID')
    ->leftJoin('hrd_kind_type','hrd_person.HR_KIND_TYPE_ID','=','hrd_kind_type.HR_KIND_TYPE_ID')
    ->leftJoin('hrd_person_type','hrd_person.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
    ->where('hrd_person.ID','=',$iduser)->first();

    //dd($id);

    $inforepairmedicaldetail = Assetcarerepair::where('asset_care_repair.ID','=',$id)
    ->leftjoin('informrepair_priority','informrepair_priority.PRIORITY_ID','=','asset_care_repair.PRIORITY_ID')
    ->leftjoin('hrd_person','asset_care_repair.USER_REQUEST_ID','=','hrd_person.ID')
    ->leftjoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_SUB_ID')
    ->leftJoin('asset_article','asset_article.ARTICLE_ID','=','asset_care_repair.ARTICLE_ID')
    ->leftjoin('supplies_location','asset_care_repair.LOCATION_SEE_ID','=','supplies_location.LOCATION_ID')
    ->leftjoin('supplies_location_level','asset_care_repair.LOCATIONLEVEL_SEE_ID','=','supplies_location_level.LOCATION_LEVEL_ID')
    ->leftjoin('supplies_location_level_room','asset_care_repair.LOCATIONLEVELROOM_SEE_ID','=','supplies_location_level_room.LEVEL_ROOM_ID')  
    ->leftjoin('asset_building','asset_care_repair.LOCATION_SEE_ID','=','asset_building.ID')  
    ->first(); 
      
    //dd($inforepairnomal);
                 
   


    return view('general_repair.genrepairmedicalcancel_check',[
        'inforpersonuser' => $inforpersonuser,
        'inforpersonuserid' => $inforpersonuserid, 
        'inforepairmedicaldetail' => $inforepairmedicaldetail,
        'infoid' => $id
    ]);
}


public function updatecancelmedical(Request $request)
{
    //$email = Auth::user()->email;
    //return $request->all();
    $id = $request->ID; 

   
      $updatecancel = Assetcarerepair::find($id);
      $updatecancel->CANCEL_COMMENT = $request->CANCEL_COMMENT;    
      $updatecancel->CANCEL_USER_EDIT_ID = $request->CANCEL_USER_EDIT_ID; 
      $updatecancel->REPAIR_STATUS = 'REPAIR_OUT'; 

  
  
      $updatecancel->save();
      
          //
          return redirect()->route('repair.inforepairmedical',[
            'iduser' => $request->CANCEL_USER_EDIT_ID
        ]); 

        }




}
