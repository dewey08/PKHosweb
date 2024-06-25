<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Person;
use App\Models\Recordindex;
use App\Models\Recordindexperson;
use App\Models\Recordindexcapacity;
use App\Models\Recordindexbranch;
use App\Models\Recordindexmoney;
use App\Models\Recordorglocation;
use App\Models\Recordorg;
use App\Models\Permislist;
use App\Models\Recordback;
use App\Models\Recordbackperson;
use App\Models\Recordbackobjective;
use App\Models\Recordbackimportant;
use App\Models\Recordbackknow;
use App\Models\Recordbackbenefit;
use App\Models\Recordbackmoney;
use App\Models\Recordbackfile;
use App\Models\Grecordstatus;
use App\Models\Meetting_inside_type;
use App\Models\Meetting_inside_index;
use App\Models\Meetting_inside_performancesub;
use App\Models\Meetting_inside_professionsub;
use App\Models\Meetting_inside_useroutsub;
use App\Models\Meetting_inside_usersub;
use App\Models\Openformperdev;
use PDF;

date_default_timezone_set("Asia/Bangkok");
class PerdevController extends Controller
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

      

        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;
        }

        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';

        
        $from = date($displaydate_bigen);
        $to = date($displaydate_end);

        $countout = DB::table('grecord_index')
        ->WhereBetween('DATE_GO', [$from,$to])     
        ->where('STATUS','=','SUCCESS')
        ->where('RECORD_USER_ID','=',$iduser)                          
        ->count();

        $counttype = DB::table('grecord_index')  
        ->leftJoin('grecord_type','grecord_index.RECORD_TYPE_ID','grecord_type.RECORD_TYPE_ID') 
        ->WhereBetween('DATE_GO', [$from,$to])   
        ->where('STATUS','=','SUCCESS') 
        ->where('grecord_index.RECORD_TYPE_ID','=',3)  
        ->where('RECORD_USER_ID','=',$iduser)                          
        ->count();

        $countinside1 = DB::table('meetting_inside_index')         
        ->where('MEETING_INSIDE_USERSAVE','=',$iduser)                              
        ->count();

        $countinside2 = DB::table('meetting_inside_usersub')->where('MEETING_INSIDE_USERSUB_IDNAME','=',$iduser)->count(); 
        $countinside = $countinside1 + $countinside2;

       $grecordstatus = Grecordstatus::get();

        return view('person_develop.personinfodevindex',[
            'inforpersonuser' => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid, 
            'countout' => $countout,
            'counttype' => $counttype,
            'grecordstatus' => $grecordstatus,
            'countinsides'=>$countinside
         
        ]);
}
 

public function persondevreport(Request $request,$iduser)
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

        $mo = date('Y-m');
      
        $inforrecordindex =  DB::table('grecord_index_person')
                    ->leftJoin('grecord_index','grecord_index_person.RECORD_ID','=','grecord_index.ID')
                    ->leftJoin('grecord_org_location','grecord_index.RECORD_LOCATION_ID','=','grecord_org_location.LOCATION_ID')  
                    ->where('DATE_GO','like',$mo.'%')
                    ->orderBy('grecord_index_person.RECORD_ID', 'desc')  
                    ->get();
                        
        $grecordstatus = DB::table('grecord_status')->get();
        
    
        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;
        }
        
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';
        $status = '';
        $search = '';
        $year_id = $yearbudget;

        return view('person_develop.persondevreport',[
            'inforpersonuser' => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid,
            'inforrecordindexs'=> $inforrecordindex ,
            'grecordstatuss' => $grecordstatus ,
            'displaydate_bigen'=> $displaydate_bigen, 
            'displaydate_end'=> $displaydate_end,
            'status_check' => $status,
            'search' => $search,
            'budgets' =>  $budget,
            'year_id'=>$year_id             
        ]);
    }

 
public function persondevreport_search(Request $request,$iduser)
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

    $mo = date('Y-m');
  
                $datebigin = $request->get('DATE_BIGIN');
                $dateend = $request->get('DATE_END'); 
              
            
                if ($datebigin != '' && $dateend != '') {
                        $date_bigen_c = Carbon::createFromFormat('d/m/Y', $datebigin)->format('Y-m-d');
                        $date_arrary=explode("-", $date_bigen_c);
                        $y_sub_st = $date_arrary[0];
                
                        if ($y_sub_st >= 2500) {
                            $y = $y_sub_st-543;
                        } else {
                            $y = $y_sub_st;
                        }
                
                        $m = $date_arrary[1];
                        $d = $date_arrary[2];
                        $displaydate_bigen= $y."-".$m."-".$d;
                
                        $date_end_c = Carbon::createFromFormat('d/m/Y', $dateend)->format('Y-m-d');
                        $date_arrary_e=explode("-", $date_end_c);
                
                        $y_sub_e = $date_arrary_e[0];
                
                        if ($y_sub_e >= 2500) {
                            $y_e = $y_sub_e-543;
                        } else {
                            $y_e = $y_sub_e;
                        }
                        $m_e = $date_arrary_e[1];
                        $d_e = $date_arrary_e[2];
                        $displaydate_end= $y_e."-".$m_e."-".$d_e;
                    
                        $from = date($displaydate_bigen);
                        $to = date($displaydate_end);

                        $inforrecordindex =  DB::table('grecord_index_person')
                        ->leftJoin('grecord_index','grecord_index_person.RECORD_ID','=','grecord_index.ID')
                        ->leftJoin('grecord_org_location','grecord_index.RECORD_LOCATION_ID','=','grecord_org_location.LOCATION_ID')  
                        ->WhereBetween('DATE_GO', [$from,$to])
                        ->orderBy('grecord_index_person.RECORD_ID', 'desc')                      
                        ->get();

                }


    $grecordstatus = DB::table('grecord_status')->get();
    

    $m_budget = date("m");
    if($m_budget>9){
    $yearbudget = date("Y")+544;
    }else{
    $yearbudget = date("Y")+543;
    }
    
    $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
    $displaydate_bigen = ($yearbudget-544).'-10-01';
    $displaydate_end = ($yearbudget-543).'-09-30';
    $status = '';
    $search = '';
    $year_id = $yearbudget;

    return view('person_develop.persondevreport',[
        'inforpersonuser' => $inforpersonuser,
        'inforpersonuserid' => $inforpersonuserid,
        'inforrecordindexs'=> $inforrecordindex ,
        'grecordstatuss' => $grecordstatus ,
        'displaydate_bigen'=> $displaydate_bigen, 
        'displaydate_end'=> $displaydate_end,
        'status_check' => $status,
        'search' => $search,
        'budgets' =>  $budget,
        'year_id'=>$year_id             
    ]);
}

public function persondevreport_excel(Request $request,$iduser)
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

        $mo = date('Y-m');
      
        $inforrecordindex =  DB::table('grecord_index_person')
                    ->leftJoin('grecord_index','grecord_index_person.RECORD_ID','=','grecord_index.ID')
                    ->leftJoin('grecord_org_location','grecord_index.RECORD_LOCATION_ID','=','grecord_org_location.LOCATION_ID')  
                    ->where('DATE_GO','like',$mo.'%')
                    ->orderBy('grecord_index_person.RECORD_ID', 'desc')  
                    ->get();
                        
        $grecordstatus = DB::table('grecord_status')->get();
        
    
        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;
        }
        
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';
        $status = '';
        $search = '';
        $year_id = $yearbudget;

        return view('person_develop.persondevreport_excel',[
            'inforpersonuser' => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid,
            'inforrecordindexs'=> $inforrecordindex ,
            'grecordstatuss' => $grecordstatus ,
            'displaydate_bigen'=> $displaydate_bigen, 
            'displaydate_end'=> $displaydate_end,
            'status_check' => $status,
            'search' => $search,
            'budgets' =>  $budget,
            'year_id'=>$year_id             
        ]);
    }

public function personmeetinginside(Request $request,$iduser)
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
        ->leftJoin('hrd_kind','hrd_person.HR_KIND_ID','=','hrd_kind.HR_KIND_ID')
        ->leftJoin('hrd_kind_type','hrd_person.HR_KIND_TYPE_ID','=','hrd_kind_type.HR_KIND_TYPE_ID')
        ->leftJoin('hrd_person_type','hrd_person.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
        ->where('hrd_person.ID','=',$iduser)->first();

     
                        
        $meettingstatus = DB::table('grecord_status')->get();
        
    
        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;
        }
        
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';
        $status = '';
        $search = '';
        $year_id = $yearbudget;

        $meetinginside = DB::table('meetting_inside_index')
        ->leftJoin('meetting_inside_usersub','meetting_inside_usersub.MEETING_INSIDE_ID','meetting_inside_index.MEETING_INSIDE_ID') 
        ->leftJoin('hrd_person','meetting_inside_index.MEETING_INSIDE_PRESIDENT','=','hrd_person.ID')
        ->leftJoin('meetting_inside_type','meetting_inside_index.MEETING_INSIDE_TYPE','=','meetting_inside_type.MEETTINGSIDE_ID')
        ->leftjoin('grecord_org_location','meetting_inside_index.MEETING_INSIDE_LOCATION','=','grecord_org_location.LOCATION_ID')
        ->leftjoin('meetingroom_index','meetting_inside_index.ROOM_ID','=','meetingroom_index.ROOM_ID')
        ->leftjoin('grecord_status','meetting_inside_index.MEETING_STATUS','=','grecord_status.STATUS')
        ->where('MEETING_INSIDE_USERSUB_IDNAME','=',$iduser) 
        ->orderBy('meetting_inside_index.MEETING_INSIDE_ID', 'desc')
        ->get();

        $room = DB::table('meetingroom_index')->get();
        $infopresident =  DB::table('hrd_person')->get();

        return view('person_develop.personmeetinginside',[
            'rooms' =>$room,
            'meetinginsides' => $meetinginside,
            'infopresidents' => $infopresident,
            'inforpersonuser' => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid,           
            'meettingstatuss' => $meettingstatus ,
            'displaydate_bigen'=> $displaydate_bigen, 
            'displaydate_end'=> $displaydate_end,
            'status_check' => $status,
            'search' => $search,
            'budgets' =>  $budget,
            'year_id'=>$year_id   
         
        ]);
}

public function personmeetinginside_search(Request $request,$iduser)
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

     
                        
        $meettingstatus = DB::table('grecord_status')->get();

        $room = DB::table('meetingroom_index')->get();
        
    
        $search = $request->get('search');
        $status = $request->STATUS_CODE;
        $datebigin = $request->get('DATE_BIGIN');
        $dateend = $request->get('DATE_END'); 
        $yearbudget = $request->BUDGET_YEAR; 



        if($search==''){
            $search="";
        }         

        if( $datebigin != '' && $dateend != ''){
             
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
            $meetinginside = DB::table('meetting_inside_index')
                        ->leftJoin('hrd_person','meetting_inside_index.MEETING_INSIDE_PRESIDENT','=','hrd_person.ID')
                        ->leftJoin('meetting_inside_type','meetting_inside_index.MEETING_INSIDE_TYPE','=','meetting_inside_type.MEETTINGSIDE_ID')
                        ->leftjoin('grecord_org_location','meetting_inside_index.MEETING_INSIDE_LOCATION','=','grecord_org_location.LOCATION_ID')
                        ->leftjoin('meetingroom_index','meetting_inside_index.ROOM_ID','=','meetingroom_index.ROOM_ID')
                        ->leftjoin('grecord_status','meetting_inside_index.MEETING_STATUS','=','grecord_status.STATUS')
                        ->where('meetting_inside_index.MEETING_INSIDE_USERSAVE','=',$iduser)                                             
                        ->where(function($q) use ($search){
                            $q->where('HR_FNAME','like','%'.$search.'%');
                            $q->orwhere('MEETING_INSIDE_TITLE','like','%'.$search.'%');  
                            $q->orwhere('ROOM_NAME','like','%'.$search.'%');
                            $q->orwhere('MEETTINGSIDE_NAME','like','%'.$search.'%');                                                
                        })
                        ->WhereBetween('MEETING_INSIDE_DATE',[$from,$to]) 
                        ->orderBy('MEETING_INSIDE_ID', 'desc')    
                        ->get();
    }else{    
            $meetinginside = DB::table('meetting_inside_index')
                ->leftJoin('hrd_person','meetting_inside_index.MEETING_INSIDE_PRESIDENT','=','hrd_person.ID')
                ->leftJoin('meetting_inside_type','meetting_inside_index.MEETING_INSIDE_TYPE','=','meetting_inside_type.MEETTINGSIDE_ID')
                ->leftjoin('grecord_org_location','meetting_inside_index.MEETING_INSIDE_LOCATION','=','grecord_org_location.LOCATION_ID')
                ->leftjoin('meetingroom_index','meetting_inside_index.ROOM_ID','=','meetingroom_index.ROOM_ID')
                ->leftjoin('grecord_status','meetting_inside_index.MEETING_STATUS','=','grecord_status.STATUS')
                ->where('meetting_inside_index.MEETING_INSIDE_USERSAVE','=',$iduser)   
                ->where('MEETING_STATUS','=',$status)                                          
                ->where(function($q) use ($search){
                    $q->where('HR_FNAME','like','%'.$search.'%');
                    $q->orwhere('MEETING_INSIDE_TITLE','like','%'.$search.'%');  
                    $q->orwhere('ROOM_NAME','like','%'.$search.'%');
                    $q->orwhere('MEETTINGSIDE_NAME','like','%'.$search.'%');                                                
                })
                ->WhereBetween('MEETING_INSIDE_DATE',[$from,$to]) 
                ->orderBy('MEETING_INSIDE_ID', 'desc')    
                ->get();
        }      
    }else{

       if($status == null){ 
                $meetinginside = DB::table('meetting_inside_index')
                ->leftJoin('hrd_person','meetting_inside_index.MEETING_INSIDE_PRESIDENT','=','hrd_person.ID')
                ->leftJoin('meetting_inside_type','meetting_inside_index.MEETING_INSIDE_TYPE','=','meetting_inside_type.MEETTINGSIDE_ID')
                ->leftjoin('grecord_org_location','meetting_inside_index.MEETING_INSIDE_LOCATION','=','grecord_org_location.LOCATION_ID')
                ->leftjoin('meetingroom_index','meetting_inside_index.ROOM_ID','=','meetingroom_index.ROOM_ID')
                ->leftjoin('grecord_status','meetting_inside_index.MEETING_STATUS','=','grecord_status.STATUS')
                ->where('meetting_inside_index.MEETING_INSIDE_USERSAVE','=',$iduser)                                             
                ->where(function($q) use ($search){
                    $q->where('HR_FNAME','like','%'.$search.'%');
                    $q->orwhere('MEETING_INSIDE_TITLE','like','%'.$search.'%');  
                    $q->orwhere('ROOM_NAME','like','%'.$search.'%');
                    $q->orwhere('MEETTINGSIDE_NAME','like','%'.$search.'%');                                                
                })
                ->orderBy('MEETING_INSIDE_ID', 'desc')    
                ->get();

            }else{
                    $meetinginside = DB::table('meetting_inside_index')
                    ->leftJoin('hrd_person','meetting_inside_index.MEETING_INSIDE_PRESIDENT','=','hrd_person.ID')
                    ->leftJoin('meetting_inside_type','meetting_inside_index.MEETING_INSIDE_TYPE','=','meetting_inside_type.MEETTINGSIDE_ID')
                    ->leftjoin('grecord_org_location','meetting_inside_index.MEETING_INSIDE_LOCATION','=','grecord_org_location.LOCATION_ID')
                    ->leftjoin('meetingroom_index','meetting_inside_index.ROOM_ID','=','meetingroom_index.ROOM_ID')
                    ->leftjoin('grecord_status','meetting_inside_index.MEETING_STATUS','=','grecord_status.STATUS')
                    ->where('meetting_inside_index.MEETING_INSIDE_USERSAVE','=',$iduser)   
                    ->where('MEETING_STATUS','=',$status)                                          
                    ->where(function($q) use ($search){
                        $q->where('HR_FNAME','like','%'.$search.'%');
                        $q->orwhere('MEETING_INSIDE_TITLE','like','%'.$search.'%');  
                        $q->orwhere('ROOM_NAME','like','%'.$search.'%');
                        $q->orwhere('MEETTINGSIDE_NAME','like','%'.$search.'%');                                                
                    })
                    ->orderBy('MEETING_INSIDE_ID', 'desc')    
                    ->get();        
                }        
            }
            $year_id = $yearbudget;

            $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        return view('person_develop.personmeetinginside',[
            'rooms' =>$room,
            'meetinginsides' => $meetinginside,
            'inforpersonuser' => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid,           
            'meettingstatuss' => $meettingstatus ,
            'displaydate_bigen'=> $displaydate_bigen, 
            'displaydate_end'=> $displaydate_end,
            'status_check' => $status,
            'search' => $search,
            'budgets' =>  $budget,
            'year_id'=>$year_id   
         
        ]);
}


public static function refnuminside()
    {   
            $m_budget = date("m");
            if($m_budget>9){
            $yearbudget = date("Y")+544;
            }else{
            $yearbudget = date("Y")+543;
            }
        $maxnumber = DB::table('meetting_inside_index')->where('MEETING_INSIDE_BUDGET','=',$yearbudget)->max('MEETING_INSIDE_ID');  

        if($maxnumber != '' ||  $maxnumber != null){
            
            $refmax = DB::table('meetting_inside_index')->where('MEETING_INSIDE_ID','=',$maxnumber)->first();  
            if($refmax->MEETING_INSIDE_ID != '' ||  $refmax->MEETING_INSIDE_ID != null){
                $maxref = substr($refmax->MEETING_INSIDE_ID, -4)+1;
            }else{
                $maxref = 1;
            }
            $ref = str_pad($maxref, 4, "0", STR_PAD_LEFT);
        
        }else{
            $ref = '0001';
        }  
        $y = substr($yearbudget, -2);

        $refnumber ='M'.$y.'-'.$ref;
        return $refnumber;
    }

public function personmeetinginside_add(Request $request,$iduser)
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

        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;
        }
        
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';
        $status = '';
        $search = '';
        $year_id = $yearbudget;

        $meetting_inside_type =  DB::table('meetting_inside_type')->get();
        $location =  DB::table('grecord_org_location')->get();

        $infopresident =  DB::table('hrd_person')->get();
        $room = DB::table('meetingroom_index')->get();

        return view('person_develop.personmeetinginside_add',[
            'rooms' =>$room,
            'locations' =>  $location,
            'meetting_inside_types' =>  $meetting_inside_type,
            'infopresidents' =>  $infopresident,
            'inforpersonuser' => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid,
            'displaydate_bigen'=> $displaydate_bigen, 
            'displaydate_end'=> $displaydate_end,
            'status_check' => $status,
            'search' => $search,
            'budgets' =>  $budget,
            'year_id'=>$year_id            
        ]);
}

function addtype(Request $request)
{
 
    if($request->record_type!= null || $request->record_type != ''){

        $count_check = Meetting_inside_type::where('MEETTINGSIDE_NAME','=',$request->record_type)->count();
        
            if($count_check == 0){

        $addrecord = new Meetting_inside_type(); 
        $addrecord->MEETTINGSIDE_NAME = $request->record_type;
        $addrecord->save(); 
            }
    }
        $query =  DB::table('meetting_inside_type')->get();
    
        $output='<option value="">--กรุณาเลือก--</option>';
        
        foreach ($query as $row){
            if($request->record_type == $row->MEETTINGSIDE_NAME){
                $output.= '<option value="'.$row->MEETTINGSIDE_ID.'" selected>'.$row->MEETTINGSIDE_NAME.'</option>';
            }else{
                $output.= '<option value="'.$row->MEETTINGSIDE_ID.'">'.$row->MEETTINGSIDE_NAME.'</option>';
            }          
    }
        echo $output;
    
}



public function personmeetinginside_save(Request $request)
{

    $iduser = $request->iduser;
 
    $ic_date = $request->MEETING_INSIDE_DATE;

    if($ic_date != ''){
    $STARTDAY = Carbon::createFromFormat('d/m/Y', $ic_date)->format('Y-m-d');
    $date_arrary_st=explode("-",$STARTDAY);  
    $y_sub_st = $date_arrary_st[0]; 
    
    if($y_sub_st >= 2500){
        $y_st = $y_sub_st-543;
    }else{
        $y_st = $y_sub_st;
    }
    $m_st = $date_arrary_st[1];
    $d_st = $date_arrary_st[2];  
    $icontrol_date= $y_st."-".$m_st."-".$d_st;
    }else{
    $icontrol_date= null;
    }

    $usersave = Person::where('ID','=',$iduser)->first();

    
    $add = new Meetting_inside_index(); 
    $add->MEETING_INSIDE_CODE = $request->MEETING_INSIDE_CODE;
    $add->MEETING_INSIDE_NO = $request->MEETING_INSIDE_NO;
    $add->MEETING_INSIDE_BUDGET = $request->MEETING_INSIDE_BUDGET;
    $add->ROOM_ID = $request->ROOM_ID;
    $add->MEETING_INSIDE_DATE = $icontrol_date;
    $add->MEETING_INSIDE_STARTTIME = $request->MEETING_INSIDE_STARTTIME;
    $add->MEETING_INSIDE_ENDTIME = $request->MEETING_INSIDE_ENDTIME;
    $add->MEETING_INSIDE_TITLE = $request->MEETING_INSIDE_TITLE;
    $add->MEETING_INSIDE_PRESIDENT = $request->MEETING_INSIDE_PRESIDENT;
    $add->MEETING_INSIDE_TYPE = $request->MEETING_INSIDE_TYPE;
    $add->MEETING_INSIDE_LOCATION = $request->MEETING_INSIDE_LOCATION;
    $add->MEETING_INSIDE_USERSAVE = $usersave->ID;
    $add->MEETING_INSIDE_USERSAVE_NAME = $usersave->HR_FNAME.' ' .$usersave->HR_LNAME;
    $add->MEETING_STATUS = 'APPLY';
           
    $maxid = Meetting_inside_index::max('MEETING_INSIDE_ID');  
        $idfile = $maxid+1;

    if($request->hasFile('pdfupload')){
        $newFileName = 'meetinside_'.$idfile.'.'.$request->pdfupload->extension();          
        $request->pdfupload->storeAs('meettinginsidepdf',$newFileName,'public');     
        $add->MEETING_INSIDE_FILE = $newFileName;        
    }
   
    $add->save();

 
    if($request->MEETING_INSIDE_USER != '' || $request->MEETING_INSIDE_USER != null)
    {        
        $MEETING_INSIDE_USER = $request->MEETING_INSIDE_USER;   

        $number =count($MEETING_INSIDE_USER);
        $count = 0;    
            for($count = 0; $count< $number; $count++)
                { 
                    $usersub = Person::where('ID','=',$MEETING_INSIDE_USER[$count])->first();

                    $add_usersub = new Meetting_inside_usersub();    
                    $add_usersub->MEETING_INSIDE_ID = $idfile;   
                    $add_usersub->MEETING_INSIDE_USERSUB_IDNAME = $usersub->ID; 
                    $add_usersub->MEETING_INSIDE_USERSUB_FNAME = $usersub->HR_FNAME; 
                    $add_usersub->MEETING_INSIDE_USERSUB_LNAME = $usersub->HR_LNAME;
                    $add_usersub->save(); 
                }
    } 

    if($request->MEETING_INSIDE_USEROUT != '' || $request->MEETING_INSIDE_USEROUT != null)
    {        
        $MEETING_INSIDE_USEROUT = $request->MEETING_INSIDE_USEROUT;                         
        $number =count($MEETING_INSIDE_USEROUT);
        $count = 0;    
            for($count = 0; $count< $number; $count++)
                { 
                    $add_useroutsub = new Meetting_inside_useroutsub();    
                    $add_useroutsub->MEETING_INSIDE_ID = $maxid;   
                    $add_useroutsub->MEETING_INSIDE_USEROUT_NAME = $MEETING_INSIDE_USEROUT[$count];   
                    $add_useroutsub->save(); 
                }
    } 
    
    if($request->MEETING_INSIDE_PERFORMANCE != '' || $request->MEETING_INSIDE_PERFORMANCE != null)
    {        
        $MEETING_INSIDE_PERFORMANCE = $request->MEETING_INSIDE_PERFORMANCE;                         
        $number =count($MEETING_INSIDE_PERFORMANCE);
        $count = 0;    
            for($count = 0; $count< $number; $count++)
                { 
                    $add_performancesub = new Meetting_inside_performancesub();    
                    $add_performancesub->MEETING_INSIDE_ID = $maxid;   
                    $add_performancesub->MEETING_INSIDE_PERFORMANCE_NAME = $MEETING_INSIDE_PERFORMANCE[$count];   
                    $add_performancesub->save(); 
                }
    }

    if($request->MEETING_INSIDE_PROFESSION != '' || $request->MEETING_INSIDE_PROFESSION != null)
    {        
        $MEETING_INSIDE_PROFESSION = $request->MEETING_INSIDE_PROFESSION;                         
        $number =count($MEETING_INSIDE_PROFESSION);
        $count = 0;    
            for($count = 0; $count< $number; $count++)
                { 
                    $add_performancesub = new Meetting_inside_professionsub();    
                    $add_performancesub->MEETING_INSIDE_ID = $maxid;   
                    $add_performancesub->MEETING_INSIDE_PROFESSION_NAME = $MEETING_INSIDE_PROFESSION[$count];   
                    $add_performancesub->save(); 
                }
    }




    return redirect()->route('perdev.personmeetinginside',['iduser'=>$iduser]);
}

public function personmeetinginside_edit(Request $request,$id,$iduser)
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
        ->leftJoin('hrd_kind','hrd_person.HR_KIND_ID','=','hrd_kind.HR_KIND_ID')
        ->leftJoin('hrd_kind_type','hrd_person.HR_KIND_TYPE_ID','=','hrd_kind_type.HR_KIND_TYPE_ID')
        ->leftJoin('hrd_person_type','hrd_person.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
        ->where('hrd_person.ID','=',$iduser)->first();

        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;
        }
        
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';
        $status = '';
        $search = '';
        $year_id = $yearbudget;

        $meetting_inside_type =  DB::table('meetting_inside_type')->get();
        $location =  DB::table('grecord_org_location')->get();

        $infopresident =  DB::table('hrd_person')->get();

        $meetinginside = DB::table('meetting_inside_index')
        ->leftJoin('hrd_person','meetting_inside_index.MEETING_INSIDE_PRESIDENT','=','hrd_person.ID')
        ->leftJoin('meetting_inside_type','meetting_inside_index.MEETING_INSIDE_TYPE','=','meetting_inside_type.MEETTINGSIDE_ID')
        ->leftjoin('grecord_status','meetting_inside_index.MEETING_STATUS','=','grecord_status.STATUS')
        ->where('meetting_inside_index.MEETING_INSIDE_ID','=',$id)->first();


        $inside_usersub =  DB::table('meetting_inside_usersub') ->where('meetting_inside_usersub.MEETING_INSIDE_ID','=',$id)->get();
        $inside_useroutsub =  DB::table('meetting_inside_useroutsub') ->where('meetting_inside_useroutsub.MEETING_INSIDE_ID','=',$id)->get();


        $inside_performance =  DB::table('meetting_inside_performancesub') ->where('meetting_inside_performancesub.MEETING_INSIDE_ID','=',$id)->get();
        $inside_professionsub =  DB::table('meetting_inside_professionsub') ->where('meetting_inside_professionsub.MEETING_INSIDE_ID','=',$id)->get();

        $room = DB::table('meetingroom_index')->get();

    return view('person_develop.personmeetinginside_edit',[
        'rooms' =>$room,
        'inside_usersubs' =>  $inside_usersub,
        'inside_useroutsubs' =>  $inside_useroutsub,
        'meetinginsides' =>  $meetinginside,
        'inside_performances' =>  $inside_performance,
        'inside_professionsubs' =>  $inside_professionsub,
        'iduser'=>$iduser,
        'locations' =>  $location,
        'meetting_inside_types' =>  $meetting_inside_type,
        'infopresidents' =>  $infopresident,
        'inforpersonuser' => $inforpersonuser,
        'inforpersonuserid' => $inforpersonuserid,
        'displaydate_bigen'=> $displaydate_bigen, 
        'displaydate_end'=> $displaydate_end,
        'status_check' => $status,
        'search' => $search,
        'budgets' =>  $budget,
        'year_id'=>$year_id    

    ]);
}

public function personmeetinginside_cancel(Request $request,$id,$iduser)
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

        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;
        }
        
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';
        $status = '';
        $search = '';
        $year_id = $yearbudget;

        $meetting_inside_type =  DB::table('meetting_inside_type')->get();
        $location =  DB::table('grecord_org_location')->get();

        $infopresident =  DB::table('hrd_person')->get();

        $meetinginside = DB::table('meetting_inside_index')
        ->leftJoin('hrd_person','meetting_inside_index.MEETING_INSIDE_PRESIDENT','=','hrd_person.ID')
        ->leftJoin('meetting_inside_type','meetting_inside_index.MEETING_INSIDE_TYPE','=','meetting_inside_type.MEETTINGSIDE_ID')
        ->leftjoin('grecord_org_location','meetting_inside_index.MEETING_INSIDE_LOCATION','=','grecord_org_location.LOCATION_ID')
        ->leftjoin('meetingroom_index','meetting_inside_index.ROOM_ID','=','meetingroom_index.ROOM_ID')
        ->leftjoin('grecord_status','meetting_inside_index.MEETING_STATUS','=','grecord_status.STATUS')
        ->where('meetting_inside_index.MEETING_INSIDE_ID','=',$id)->first();

        $inside_usersub =  DB::table('meetting_inside_usersub') ->where('meetting_inside_usersub.MEETING_INSIDE_ID','=',$id)->get();
        $inside_useroutsub =  DB::table('meetting_inside_useroutsub') ->where('meetting_inside_useroutsub.MEETING_INSIDE_ID','=',$id)->get();
        $inside_performance =  DB::table('meetting_inside_performancesub') ->where('meetting_inside_performancesub.MEETING_INSIDE_ID','=',$id)->get();
        $inside_professionsub =  DB::table('meetting_inside_professionsub') ->where('meetting_inside_professionsub.MEETING_INSIDE_ID','=',$id)->get();

        

    return view('person_develop.personmeetinginside_cancel',[
        'inside_usersubs' =>  $inside_usersub,
        'inside_useroutsubs' =>  $inside_useroutsub,
        'meetinginsides' =>  $meetinginside,
        'inside_performances' =>  $inside_performance,
        'inside_professionsubs' =>  $inside_professionsub,
        'iduser'=>$iduser,
        'locations' =>  $location,
        'meetting_inside_types' =>  $meetting_inside_type,
        'infopresidents' =>  $infopresident,
        'inforpersonuser' => $inforpersonuser,
        'inforpersonuserid' => $inforpersonuserid,
        'displaydate_bigen'=> $displaydate_bigen, 
        'displaydate_end'=> $displaydate_end,
        'status_check' => $status,
        'search' => $search,
        'budgets' =>  $budget,
        'year_id'=>$year_id    

    ]);
}
public function personmeetinginside_updatecancel(Request $request)
    {
 
    $id = $request->MEETING_INSIDE_ID; 

      $updatecancel = Meetting_inside_index::find($id);
      $updatecancel->MEETING_STATUS = 'CANCEL'; 
      $updatecancel->MEETING_INSIDE_COMMENT = $request->MEETING_INSIDE_COMMENT;
      $updatecancel->save();
               
          return redirect()->route('perdev.personmeetinginside',['iduser'=>  $request->PERSON_ID]);

}



public function personmeetinginside_update(Request $request)
{

  $request->validate([
     
    ]);

    $iduser = $request->iduser;
    $id = $request->MEETING_INSIDE_ID;
 
    $ic_date = $request->MEETING_INSIDE_DATE;

    if($ic_date != ''){
    $STARTDAY = Carbon::createFromFormat('d/m/Y', $ic_date)->format('Y-m-d');
    $date_arrary_st=explode("-",$STARTDAY);  
    $y_sub_st = $date_arrary_st[0]; 
    
    if($y_sub_st >= 2500){
        $y_st = $y_sub_st-543;
    }else{
        $y_st = $y_sub_st;
    }
    $m_st = $date_arrary_st[1];
    $d_st = $date_arrary_st[2];  
    $icontrol_date= $y_st."-".$m_st."-".$d_st;
    }else{
    $icontrol_date= null;
    }

 
    $usersave = Person::where('ID','=',$iduser)->first();

    $id_metindex = Meetting_inside_index::max('MEETING_INSIDE_ID');

    $update = Meetting_inside_index::find($id); 
    $update->MEETING_INSIDE_CODE = $request->MEETING_INSIDE_CODE;
    $update->MEETING_INSIDE_NO = $request->MEETING_INSIDE_NO;
    $update->MEETING_INSIDE_BUDGET = $request->MEETING_INSIDE_BUDGET;
    $update->MEETING_INSIDE_DATE = $icontrol_date;
    $update->MEETING_INSIDE_STARTTIME = $request->MEETING_INSIDE_STARTTIME;
    $update->MEETING_INSIDE_ENDTIME = $request->MEETING_INSIDE_ENDTIME;
    $update->MEETING_INSIDE_TITLE = $request->MEETING_INSIDE_TITLE;
    $update->MEETING_INSIDE_PRESIDENT = $request->MEETING_INSIDE_PRESIDENT;
    $update->MEETING_INSIDE_TYPE = $request->MEETING_INSIDE_TYPE;
    $update->MEETING_INSIDE_LOCATION = $request->MEETING_INSIDE_LOCATION;
    $update->ROOM_ID = $request->ROOM_ID;
    $update->MEETING_INSIDE_USERSAVE = $usersave->ID;
    $update->MEETING_INSIDE_USERSAVE_NAME = $usersave->HR_FNAME.' ' .$usersave->HR_LNAME;
    $update->MEETING_STATUS = 'APPLY';


    if($request->hasFile('pdfupload')){
        $newFileName = 'meetinside_'.$id.'.'.$request->pdfupload->extension();          
        $request->pdfupload->storeAs('meettinginsidepdf',$newFileName,'public');     
        $update->MEETING_INSIDE_FILE = $newFileName;        
    }



    $update->save();                     
   
    Meetting_inside_usersub::where('MEETING_INSIDE_ID','=',$id)->delete();

    if($request->MEETING_INSIDE_USER != '' || $request->MEETING_INSIDE_USER != null)
    {        
        $MEETING_INSIDE_USER = $request->MEETING_INSIDE_USER;                         
        $number =count($MEETING_INSIDE_USER);
        $count = 0;    
            for($count = 0; $count< $number; $count++)
                { 
                    $usersub = Person::where('ID','=',$MEETING_INSIDE_USER[$count])->first();

                    $update_usersub = new Meetting_inside_usersub();    
                    $update_usersub->MEETING_INSIDE_ID = $id;   
                    $update_usersub->MEETING_INSIDE_USERSUB_IDNAME = $usersub->ID; 
                    $update_usersub->MEETING_INSIDE_USERSUB_FNAME = $usersub->HR_FNAME; 
                    $update_usersub->MEETING_INSIDE_USERSUB_LNAME = $usersub->HR_LNAME;
                    $update_usersub->save(); 
                }
    } 

    Meetting_inside_useroutsub::where('MEETING_INSIDE_ID','=',$id)->delete();

    if($request->MEETING_INSIDE_USEROUT != '' || $request->MEETING_INSIDE_USEROUT != null)
    {        
        $MEETING_INSIDE_USEROUT = $request->MEETING_INSIDE_USEROUT;                         
        $number =count($MEETING_INSIDE_USEROUT);
        $count = 0;    
            for($count = 0; $count< $number; $count++)
                { 
                    $update_useroutsub = new Meetting_inside_useroutsub();    
                    $update_useroutsub->MEETING_INSIDE_ID = $id;   
                    $update_useroutsub->MEETING_INSIDE_USEROUT_NAME = $MEETING_INSIDE_USEROUT[$count];   
                    $update_useroutsub->save(); 
                }
    } 

    Meetting_inside_performancesub::where('MEETING_INSIDE_ID','=',$id)->delete();
    
    if($request->MEETING_INSIDE_PERFORMANCE != '' || $request->MEETING_INSIDE_PERFORMANCE != null)
    {        
        $MEETING_INSIDE_PERFORMANCE = $request->MEETING_INSIDE_PERFORMANCE;                         
        $number =count($MEETING_INSIDE_PERFORMANCE);
        $count = 0;    
            for($count = 0; $count< $number; $count++)
                { 
                    $update_performancesub = new Meetting_inside_performancesub();    
                    $update_performancesub->MEETING_INSIDE_ID = $id;   
                    $update_performancesub->MEETING_INSIDE_PERFORMANCE_NAME = $MEETING_INSIDE_PERFORMANCE[$count];   
                    $update_performancesub->save(); 
                }
    }

    Meetting_inside_professionsub::where('MEETING_INSIDE_ID','=',$id)->delete();

    if($request->MEETING_INSIDE_PROFESSION != '' || $request->MEETING_INSIDE_PROFESSION != null)
    {        
        $MEETING_INSIDE_PROFESSION = $request->MEETING_INSIDE_PROFESSION;                         
        $number =count($MEETING_INSIDE_PROFESSION);
        $count = 0;    
            for($count = 0; $count< $number; $count++)
                { 
                    $update_performancesub = new Meetting_inside_professionsub();    
                    $update_performancesub->MEETING_INSIDE_ID = $id;   
                    $update_performancesub->MEETING_INSIDE_PROFESSION_NAME = $MEETING_INSIDE_PROFESSION[$count];   
                    $update_performancesub->save(); 
                }
    }




    return redirect()->route('perdev.personmeetinginside',['iduser'=>$iduser]);
}


public function personmeetinginside_type(Request $request)
{
    $iduser = $request->iduser;
    $add = new Meetting_inside_type(); 
    $add->MEETTINGSIDE_NAME = $request->MEETTINGSIDE_NAME;
    $add->save();                     

    return redirect()->route('perdev.personmeetinginside_add',['iduser'=>$iduser]);
}

public static function countgrecordmonth($yearbudget,$type,$i,$iduser)
    {     
        

        if($i<10){
            $month = '0'.$i;  
         }else{
            $month = $i;
         }
      
                $m_budget = date("m");
            if($m_budget>9){           
                   
                if($i<10){
                    $year = date("Y")-1;
                 }else{
                    $year = date("Y");
                 } 

            }else{
            
                if($i<10){
                    $year = date("Y");
                 }else{
                    $year = date("Y")-1;
                 }

            } 
        
  
        
        $count =  Recordindex::where('DATE_GO','like',$year.'-'.$month.'-%' )
                                   ->where('STATUS','=','SUCCESS')
                                    ->where('RECORD_TYPE_ID','=',$type ) 
                                    ->where('RECORD_USER_ID','=',$iduser)   
                                 ->count();  
                                
        return $count;
     
        
        $count =  Recordindex::where('DATE_GO','like',$year.'-'.$month.'-%' )
                                   ->where('STATUS','=','SUCCESS')
                                    ->where('RECORD_TYPE_ID','=',$type ) 
                                    ->where('RECORD_USER_ID','=',$iduser)   
                                 ->count();  
                                
        return $count;
}

public static function sumcountgrecordmonth($yearbudget,$type,$iduser)
    {   
	
                $m_budget = date("m");
            if($m_budget>9){
                $yearbudget = date("Y")+1;
            }else{
                $yearbudget = date("Y");
			}
			$year = $yearbudget-1;
        $displaydate_bigen = $year.'-10-01';
        $displaydate_end = $yearbudget.'-09-30';

        
        $from = date($displaydate_bigen);
        $to = date($displaydate_end);

        $count =  Recordindex::where('STATUS','=','SUCCESS')
                                    ->where('RECORD_TYPE_ID','=',$type ) 
                                    ->where('RECORD_USER_ID','=',$iduser)  
                                    ->WhereBetween('DATE_GO', [$from,$to])   
                                    ->count();      
        return $count;
    }

public function infouser(Request $request,$iduser)
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

        $inforrecordindex =  Recordindex::select('grecord_index.ID','grecord_index.STATUS','STATUS_NAME','RECORD_TYPE_NAME','grecord_index.RECORD_TYPE_ID','USER_POST_NAME','RECORD_HEAD_USE','LOCATION_ORG_NAME'
            ,'RECORD_LEVEL_NAME','RECORD_ORG_NAME','RECORD_ORGANIZER_NAME','gleave_location.LOCATION_NAME','DATE_GO','DATE_BACK','RECORD_COMMENT','RECORD_GO_NAME','RECORD_VEHICLE_NAME','WITHDRAW_NAME'
            ,'LEADER_HR_NAME','OFFER_WORK_HR_NAME','SAVE_BACK')
                        ->leftJoin('grecord_org','grecord_org.RECORD_ORG_ID','=','grecord_index.RECORD_ORG_ID')
                        ->leftJoin('grecord_status','grecord_index.STATUS','=','grecord_status.STATUS')
                        ->leftJoin('grecord_type','grecord_index.RECORD_TYPE_ID','=','grecord_type.RECORD_TYPE_ID')
                        ->leftJoin('grecord_org_location','grecord_org_location.LOCATION_ID','=','grecord_index.RECORD_LOCATION_ID')
                        ->leftJoin('grecord_level','grecord_level.ID','=','grecord_index.RECORD_LEVEL_ID')
                        ->leftJoin('gleave_location','gleave_location.LOCATION_ID','=','grecord_index.LOCATION_PROV_ID')
                        ->leftJoin('grecord_go','grecord_go.RECORD_GO_ID','=','grecord_index.RECORD_GO_ID')
                        ->leftJoin('grecord_vehicle','grecord_vehicle.RECORD_VEHICLE_ID','=','grecord_index.RECORD_VEHICLE_ID')
                        ->leftJoin('grecord_withdraw','grecord_withdraw.WITHDRAW_ID','=','grecord_index.RECORD_MONEY_ID')
                        ->where('grecord_index.RECORD_USER_ID','=',$iduser)
                        ->orderBy('grecord_index.ID', 'desc')  
                        ->get();
                        
        $grecordstatus = DB::table('grecord_status')
        ->get();
        
    
        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;
        }
        
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';
        $status = '';
        $search = '';
        $year_id = $yearbudget;

        $openform_function = Openformperdev::where('OPENFORMDEV_STATUS','=','True' )->first();


        if ($openform_function != '') {
        
            $code = $openform_function->OPENFORMDEV_CODE;      

        } else {                      
            $code = '';
        }

        return view('person_develop.personinfodevinfo',[
            'inforpersonuser' => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid,
            'inforrecordindexs'=> $inforrecordindex ,
            'grecordstatuss' => $grecordstatus ,
            'displaydate_bigen'=> $displaydate_bigen, 
            'displaydate_end'=> $displaydate_end,
            'status_check' => $status,
            'search' => $search,
            'budgets' =>  $budget,
            'year_id'=>$year_id ,
            'codes' => $code,           
        ]);
    }
 public function searchinfo(Request $request,$iduser)
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
            $status = $request->STATUS_CODE;
            $datebigin = $request->get('DATE_BIGIN');
            $dateend = $request->get('DATE_END'); 
            $yearbudget = $request->BUDGET_YEAR; 
    
            if($search==''){
                $search="";
            }         

            if( $datebigin != '' && $dateend != ''){
                 
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
                        $inforrecordindex =  Recordindex::select('grecord_index.ID','grecord_index.STATUS','STATUS_NAME','RECORD_TYPE_NAME','grecord_index.RECORD_TYPE_ID','USER_POST_NAME','RECORD_HEAD_USE','LOCATION_ORG_NAME'
                                    ,'RECORD_LEVEL_NAME','RECORD_ORGANIZER_NAME','gleave_location.LOCATION_NAME','DATE_GO','DATE_BACK','RECORD_COMMENT','RECORD_GO_NAME','RECORD_VEHICLE_NAME','WITHDRAW_NAME'
                                    ,'LEADER_HR_NAME','OFFER_WORK_HR_NAME','SAVE_BACK')
                                                ->leftJoin('grecord_status','grecord_index.STATUS','=','grecord_status.STATUS')
                                                ->leftJoin('grecord_type','grecord_index.RECORD_TYPE_ID','=','grecord_type.RECORD_TYPE_ID')
                                                ->leftJoin('grecord_org_location','grecord_org_location.LOCATION_ID','=','grecord_index.RECORD_LOCATION_ID')
                                                ->leftJoin('grecord_level','grecord_level.ID','=','grecord_index.RECORD_LEVEL_ID')
                                                ->leftJoin('gleave_location','gleave_location.LOCATION_ID','=','grecord_index.LOCATION_PROV_ID')
                                                ->leftJoin('grecord_go','grecord_go.RECORD_GO_ID','=','grecord_index.RECORD_GO_ID')
                                                ->leftJoin('grecord_vehicle','grecord_vehicle.RECORD_VEHICLE_ID','=','grecord_index.RECORD_VEHICLE_ID')
                                                ->leftJoin('grecord_withdraw','grecord_withdraw.WITHDRAW_ID','=','grecord_index.RECORD_MONEY_ID')  
                                        
                                                ->where('grecord_index.RECORD_USER_ID','=',$iduser)                                          
                                                ->where(function($q) use ($search){
                                                    $q->where('grecord_index.ID','like','%'.$search.'%');
                                                    $q->orwhere('USER_POST_NAME','like','%'.$search.'%');  
                                                    $q->orwhere('RECORD_TYPE_NAME','like','%'.$search.'%');
                                                    $q->orwhere('RECORD_HEAD_USE','like','%'.$search.'%');                                                
                                                })
                                                ->WhereBetween('DATE_GO',[$from,$to]) 
                                                ->orderBy('grecord_index.ID', 'desc')    
                                                ->get();
                }else{
                                    
                        $inforrecordindex =  Recordindex::select('grecord_index.ID','grecord_index.STATUS','STATUS_NAME','RECORD_TYPE_NAME','USER_POST_NAME','RECORD_HEAD_USE','LOCATION_ORG_NAME'
                                        ,'RECORD_LEVEL_NAME','RECORD_ORGANIZER_NAME','gleave_location.LOCATION_NAME','DATE_GO','DATE_BACK','RECORD_COMMENT','RECORD_GO_NAME','RECORD_VEHICLE_NAME','WITHDRAW_NAME'
                                        ,'LEADER_HR_NAME','OFFER_WORK_HR_NAME','SAVE_BACK')
                                                    ->leftJoin('grecord_status','grecord_index.STATUS','=','grecord_status.STATUS')
                                                    ->leftJoin('grecord_type','grecord_index.RECORD_TYPE_ID','=','grecord_type.RECORD_TYPE_ID')
                                                    ->leftJoin('grecord_index_person','grecord_index.ID','=','grecord_index_person.RECORD_ID')
                                                    ->leftJoin('grecord_org_location','grecord_org_location.LOCATION_ID','=','grecord_index.RECORD_LOCATION_ID')
                                                    ->leftJoin('grecord_level','grecord_level.ID','=','grecord_index.RECORD_LEVEL_ID')
                                                    ->leftJoin('gleave_location','gleave_location.LOCATION_ID','=','grecord_index.LOCATION_PROV_ID')
                                                    ->leftJoin('grecord_go','grecord_go.RECORD_GO_ID','=','grecord_index.RECORD_GO_ID')
                                                    ->leftJoin('grecord_vehicle','grecord_vehicle.RECORD_VEHICLE_ID','=','grecord_index.RECORD_VEHICLE_ID')
                                                    ->leftJoin('grecord_withdraw','grecord_withdraw.WITHDRAW_ID','=','grecord_index.RECORD_MONEY_ID') 
                                                    ->where('grecord_index.RECORD_USER_ID','=',$iduser)
                                                    ->where('ID_STATUS','=',$status)                                          
                                                    ->where(function($q) use ($search){
                                                        $q->where('grecord_index.ID','like','%'.$search.'%');
                                                        $q->orwhere('USER_POST_NAME','like','%'.$search.'%');  
                                                        $q->orwhere('RECORD_TYPE_NAME','like','%'.$search.'%');
                                                        $q->orwhere('RECORD_HEAD_USE','like','%'.$search.'%');                                                
                                                    })
                                                    ->WhereBetween('DATE_GO',[$from,$to]) 
                                                    ->orderBy('grecord_index.ID', 'desc')    
                                                    ->get();
                }    
                
                }else{
                    if($status == null){ 
                        $inforrecordindex =  Recordindex::select('grecord_index.ID','grecord_index.STATUS','STATUS_NAME','RECORD_TYPE_NAME','USER_POST_NAME','RECORD_HEAD_USE','LOCATION_ORG_NAME'
                                        ,'RECORD_LEVEL_NAME','RECORD_ORGANIZER_NAME','gleave_location.LOCATION_NAME','DATE_GO','DATE_BACK','RECORD_COMMENT','RECORD_GO_NAME','RECORD_VEHICLE_NAME','WITHDRAW_NAME'
                                        ,'LEADER_HR_NAME','OFFER_WORK_HR_NAME','SAVE_BACK')
                                                    ->leftJoin('grecord_status','grecord_index.STATUS','=','grecord_status.STATUS')
                                                    ->leftJoin('grecord_type','grecord_index.RECORD_TYPE_ID','=','grecord_type.RECORD_TYPE_ID')
                                                    ->leftJoin('grecord_index_person','grecord_index.ID','=','grecord_index_person.RECORD_ID')
                                                    ->leftJoin('grecord_org_location','grecord_org_location.LOCATION_ID','=','grecord_index.RECORD_LOCATION_ID')
                                                    ->leftJoin('grecord_level','grecord_level.ID','=','grecord_index.RECORD_LEVEL_ID')
                                                    ->leftJoin('gleave_location','gleave_location.LOCATION_ID','=','grecord_index.LOCATION_PROV_ID')
                                                    ->leftJoin('grecord_go','grecord_go.RECORD_GO_ID','=','grecord_index.RECORD_GO_ID')
                                                    ->leftJoin('grecord_vehicle','grecord_vehicle.RECORD_VEHICLE_ID','=','grecord_index.RECORD_VEHICLE_ID')
                                                    ->leftJoin('grecord_withdraw','grecord_withdraw.WITHDRAW_ID','=','grecord_index.RECORD_MONEY_ID')                                                                                           
                                                    ->where('grecord_index.RECORD_USER_ID','=',$iduser)
                                                    ->where(function($q) use ($search){
                                                        $q->where('grecord_index.ID','like','%'.$search.'%');
                                                        $q->orwhere('USER_POST_NAME','like','%'.$search.'%');  
                                                        $q->orwhere('RECORD_TYPE_NAME','like','%'.$search.'%');
                                                        $q->orwhere('RECORD_HEAD_USE','like','%'.$search.'%');                                                
                                                    })                                                   
                                                    ->orderBy('grecord_index.ID', 'desc')    
                                                    ->get();
                }else{
                        $inforrecordindex =  Recordindex::select('grecord_index.ID','grecord_index.STATUS','STATUS_NAME','RECORD_TYPE_NAME','USER_POST_NAME','RECORD_HEAD_USE','LOCATION_ORG_NAME'
                                            ,'RECORD_LEVEL_NAME','RECORD_ORGANIZER_NAME','gleave_location.LOCATION_NAME','DATE_GO','DATE_BACK','RECORD_COMMENT','RECORD_GO_NAME','RECORD_VEHICLE_NAME','WITHDRAW_NAME'
                                            ,'LEADER_HR_NAME','OFFER_WORK_HR_NAME','SAVE_BACK')
                                                        ->leftJoin('grecord_status','grecord_index.STATUS','=','grecord_status.STATUS')
                                                        ->leftJoin('grecord_type','grecord_index.RECORD_TYPE_ID','=','grecord_type.RECORD_TYPE_ID')
                                                        ->leftJoin('grecord_index_person','grecord_index.ID','=','grecord_index_person.RECORD_ID')
                                                        ->leftJoin('grecord_org_location','grecord_org_location.LOCATION_ID','=','grecord_index.RECORD_LOCATION_ID')
                                                        ->leftJoin('grecord_level','grecord_level.ID','=','grecord_index.RECORD_LEVEL_ID')
                                                        ->leftJoin('gleave_location','gleave_location.LOCATION_ID','=','grecord_index.LOCATION_PROV_ID')
                                                        ->leftJoin('grecord_go','grecord_go.RECORD_GO_ID','=','grecord_index.RECORD_GO_ID')
                                                        ->leftJoin('grecord_vehicle','grecord_vehicle.RECORD_VEHICLE_ID','=','grecord_index.RECORD_VEHICLE_ID')
                                                        ->leftJoin('grecord_withdraw','grecord_withdraw.WITHDRAW_ID','=','grecord_index.RECORD_MONEY_ID')                                                                                           
                                                        ->where('grecord_index.RECORD_USER_ID','=',$iduser)
                                                        ->where('ID_STATUS','=',$status)  
                                                        ->where(function($q) use ($search){
                                                            $q->where('grecord_index.ID','like','%'.$search.'%');
                                                            $q->orwhere('USER_POST_NAME','like','%'.$search.'%');  
                                                            $q->orwhere('RECORD_TYPE_NAME','like','%'.$search.'%');
                                                            $q->orwhere('RECORD_HEAD_USE','like','%'.$search.'%');                                                
                                                        })                                                   
                                                        ->orderBy('grecord_index.ID', 'desc')    
                                                        ->get();                       
                }        
            }
                  $grecordstatus = DB::table('grecord_status')
                  ->get();   
                  
                  $year_id = $yearbudget;

                  $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
      
        
                  $openform_function = Openformperdev::where('OPENFORMDEV_STATUS','=','True' )->first();

                    if ($openform_function != '') {
                    
                        $code = $openform_function->OPENFORMDEV_CODE;      

                    } else {                      
                        $code = '';
                    }
                return view('person_develop.personinfodevinfo',[ 
                     'inforpersonuser' => $inforpersonuser, 
                     'inforpersonuserid' => $inforpersonuserid,            
                    'inforrecordindexs' => $inforrecordindex,
                     'grecordstatuss' => $grecordstatus,
                     'displaydate_bigen'=> $displaydate_bigen, 
                    'displaydate_end'=> $displaydate_end,
                    'status_check' => $status,
                    'search' => $search,
                    'year_id'=>$year_id, 
                    'budgets' =>  $budget,
                    'codes' => $code,  
                ]);
               
    }
    



public function create(Request $request,$iduser)
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

        $location =  DB::table('grecord_org_location')->get();
        $org = DB::table('grecord_org')->get();
         $province = DB::table('hrd_province')->get();
        $type_location =  DB::table('gleave_location')->get();
        $type =  DB::table('grecord_type')->get();
        $day_type =  DB::table('gleave_day_type')->get();
        $go =  DB::table('grecord_go')->get();
        $level =  DB::table('grecord_level')->get();
        $vehicle =  DB::table('grecord_vehicle')->get();
        $capacity =  DB::table('grecord_capacity')->get();
        $branch =  DB::table('grecord_branch')->get();
        $moneyset =  DB::table('grecord_money_set')->get(); 
        
        
        $infoprovince =  DB::table('hrd_province')->get();



        
        
        $department = $inforpersonuser -> HR_DEPARTMENT_SUB_ID; 
        $LEAVEWORK_SEND =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->where('HR_STATUS_ID','=',1)
        ->where('HR_DEPARTMENT_SUB_ID','=',$department)->get();

        $leader_all =  DB::table('gleave_leader')
        ->leftJoin('hrd_person','hrd_person.ID','=','gleave_leader.LEADER_ID')
        ->get();

        $withdraw =  DB::table('grecord_withdraw')->get(); //ตารางสร้างขึ้นใหม่
     
        $PERSONALL =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->where('HR_STATUS_ID','=',1)
        ->get();

        $year = date('Y')+543;

        $book =  DB::table('gbook_index')
        ->select('BOOK_NAME','BOOK_NUMBER','BOOK_DATE','BOOK_ID')
        ->where('BOOK_YEAR_ID','=',$year)
        ->orderBy('gbook_index.BOOK_ID', 'desc') 
        ->get();


        return view('person_develop.personinfodev_add',[
            'inforpersonuser' => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid,
            'locations' => $location,
             'provinces' => $province,
            'type_locations' => $type_location,
            'types' => $type,
            'day_types' => $day_type,
            'gos' => $go,
            'levels' => $level,
            'vehicles' => $vehicle,
            'LEAVEWORK_SENDs' => $LEAVEWORK_SEND,
            'leader_alls' =>$leader_all,
            'withdraws' =>$withdraw,
            'PERSONALLs' => $PERSONALL,
            'capacitys' => $capacity,
            'branchs' => $branch,
            'infoprovinces' => $infoprovince,
            'moneysets'=> $moneyset,
            'orgs'=> $org,
            'books' => $book
            
            
        ]);
    }

function vehicle(Request $request)
    {
        $type_vehicle = $request->type_vehicle_id;
        if($type_vehicle == '2' ||  $type_vehicle == '7'){
         
            $output='
            <div class="col-lg-10">
            <input type="text" name="CAR_REG" id="CAR_REG" class="form-control input-lg" style=" font-family: \'Kanit\', sans-serif;" placeholder="กรุณาระบุ" >
            </div>';
           
        }else{
            $output=' <input type="hidden" name ="CAR_REG" id="CAR_REG" class="form-control input-lg" style=" font-family: \'Kanit\', sans-serif;" >';
        }
      
    echo $output;
        
    }

    function vehicle_edit(Request $request)
    {
        $type_vehicle = $request->type_vehicle_id;
        $id = $request->id;
        if($type_vehicle == '2' ||  $type_vehicle == '7'){
          
            $infoindex  =  Recordindex::where('ID','=',$id)                 
                                        ->first();  
            $output='
            <div class="col-lg-10">
            <input type="text" name ="CAR_REG" id="CAR_REG" class="form-control input-lg" style=" font-family: \'Kanit\', sans-serif;" placeholder="กรุณาระบุ" value="'.$infoindex->CAR_REG.'">
            </div>';
           
        }else{
            $output='<input type="hidden" name ="CAR_REG" id="CAR_REG" class="form-control input-lg" style=" font-family: \'Kanit\', sans-serif;" >';
        }
      
    echo $output;
        
}

function addlocation(Request $request)
    {
     
     if($request->record_location != null || $request->record_location != ''){

        $count_check = Recordorglocation::where('LOCATION_ORG_NAME','=',$request->record_location)->count();
       
        if($count_check == 0){

            $addrecord = new Recordorglocation(); 
            $addrecord->LOCATION_ORG_NAME = $request->record_location;
            $addrecord->save(); 

        }
       

     }
        $query =  DB::table('grecord_org_location')->get();
     
        $output='<option value="">--กรุณาเลือกสถานที่--</option>';
        
        foreach ($query as $row){
              if($request->record_location == $row->LOCATION_ORG_NAME){
                $output.= '<option value="'.$row->LOCATION_ID.'" selected>'.$row->LOCATION_ORG_NAME.'</option>';
              }else{
                $output.= '<option value="'.$row->LOCATION_ID.'">'.$row->LOCATION_ORG_NAME.'</option>';
              }

              
      }

        echo $output;
        
    }

    function addorg(Request $request)
    {
     
     if($request->record_org!= null || $request->record_org != ''){

        $count_check = Recordorg::where('RECORD_ORG_NAME','=',$request->record_org)->count();
       
        if($count_check == 0){

        $addrecord = new Recordorg(); 
        $addrecord->RECORD_ORG_NAME = $request->record_org;
        $addrecord->save(); 

        }
     }
        $query =  DB::table('grecord_org')->get();
     
        $output='<option value="">--กรุณาเลือกหน่วยงาน--</option>';
        
        foreach ($query as $row){
              if($request->record_org == $row->RECORD_ORG_NAME){
                $output.= '<option value="'.$row->RECORD_ORG_ID.'" selected>'.$row->RECORD_ORG_NAME.'</option>';
              }else{
                $output.= '<option value="'.$row->RECORD_ORG_ID.'">'.$row->RECORD_ORG_NAME.'</option>';
              }

              
      }

        echo $output;
        
    }

    function checkposition(Request $request)
    {
        $iduser = $request->PERSON_ID;
        $inforposition=  Person::where('ID','=',$iduser)->first();
        echo $inforposition->POSITION_IN_WORK;
        
    }

    function checklevel(Request $request)
    {
        $iduser = $request->PERSON_ID;
        $inforlevel=  Person::leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
        ->where('hrd_person.ID','=',$iduser)->first();
        echo $inforlevel->HR_LEVEL_NAME;
        
}

public function save(Request $request)
    {

        $DATE_GO= $request->DATE_GO;
        
        if($DATE_GO != ''){
           
            $date_bigen_c = Carbon::createFromFormat('d/m/Y', $DATE_GO)->format('Y-m-d');
            $date_arrary=explode("-",$date_bigen_c);  
            $y = $date_arrary[0]-543;
            $m = $date_arrary[1];
            $d = $date_arrary[2];  
            $DATE_GO= $y."-".$m."-".$d;    
            }else{
            $DATE_GO= null;
        }


        $DATE_BACK= $request->DATE_BACK;
        
        if($DATE_BACK != ''){
           
            $date_bigen_c = Carbon::createFromFormat('d/m/Y', $DATE_BACK)->format('Y-m-d');
            $date_arrary=explode("-",$date_bigen_c);  
            $y = $date_arrary[0]-543;
            $m = $date_arrary[1];
            $d = $date_arrary[2];  
            $DATE_BACK= $y."-".$m."-".$d;    
            }else{
            $DATE_BACK= null;
        }



        $DATE_TRAVEL_GO = $request->DATE_TRAVEL_GO;
        
        if($DATE_TRAVEL_GO != ''){
           
            $date_bigen_c = Carbon::createFromFormat('d/m/Y', $DATE_TRAVEL_GO)->format('Y-m-d');
            $date_arrary=explode("-",$date_bigen_c);  
            $y = $date_arrary[0]-543;
            $m = $date_arrary[1];
            $d = $date_arrary[2];  
            $DATE_TRAVEL_GO= $y."-".$m."-".$d;    
            }else{
            $DATE_TRAVEL_GO= null;
        }


        $DATE_TRAVEL_BACK = $request->DATE_TRAVEL_BACK;
        
        if($DATE_TRAVEL_BACK != ''){
           
            $date_bigen_c = Carbon::createFromFormat('d/m/Y', $DATE_TRAVEL_BACK)->format('Y-m-d');
            $date_arrary=explode("-",$date_bigen_c);  
            $y = $date_arrary[0]-543;
            $m = $date_arrary[1];
            $d = $date_arrary[2];  
            $DATE_TRAVEL_BACK= $y."-".$m."-".$d;    
            }else{
            $DATE_TRAVEL_BACK= null;
        } 


        $BOOKDATEREG = $request->BOOK_DATE_REG;
    
        if($BOOKDATEREG != ''){
           
            $date_bigen_c = Carbon::createFromFormat('d/m/Y', $BOOKDATEREG)->format('Y-m-d');
            $date_arrary=explode("-",$date_bigen_c);  
            
            $y_sub = $date_arrary[0]; 
                
            if($y_sub >= 2500){
                $y = $y_sub-543;
            }else{
                $y = $y_sub;
            }
    
            $m = $date_arrary[1];
            $d = $date_arrary[2];  
            $BOOK_DATE_REG= $y."-".$m."-".$d;    
            }else{
            $BOOK_DATE_REG= null;
        } 
    



        $addrecord = new Recordindex(); 
        $addrecord->RECORD_HEAD_USE = $request->RECORD_HEAD_USE;
        $addrecord->RECORD_LOCATION_ID = $request->RECORD_LOCATION_ID;
        $addrecord->PROVINCE_ID = $request->PROVINCE_ID;
        $addrecord->RECORD_LEVEL_ID = $request->RECORD_LEVEL_ID;
        $addrecord->RECORD_TYPE_ID = $request->RECORD_TYPE_ID;
        $addrecord->LOCATION_PROV_ID = $request->LOCATION_PROV_ID;
        $addrecord->RECORD_ORG_ID = $request->RECORD_ORG_ID;


        $addrecord->BOOK_ID = $request->BOOK_ID;
        $addrecord->BOOK_NAME = $request->BOOK_NAME;
        $addrecord->BOOK_NUM = $request->BOOK_NUM;
        $addrecord->BOOK_DATE_REG = $BOOK_DATE_REG;
    

        $addrecord->DATE_GO = $DATE_GO;
        $addrecord->DATE_BACK = $DATE_BACK; 

        $addrecord->DAY_TYPE_ID = $request->DAY_TYPE_ID;

        $addrecord->DATE_TRAVEL_GO = $DATE_TRAVEL_GO;
        $addrecord->DATE_TRAVEL_BACK = $DATE_TRAVEL_BACK; 

        $addrecord->RECORD_GO_ID = $request->RECORD_GO_ID; 
        $addrecord->RECORD_VEHICLE_ID = $request->RECORD_VEHICLE_ID; 
       
        $addrecord->RECORD_MONEY_ID = $request->RECORD_MONEY_ID; 
        $addrecord->RECORD_COMMENT = $request->RECORD_COMMENT;
        
        $addrecord->LEADER_HR_ID = $request->LEADER_HR_ID; 
        $addinforpersonleader=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
        ->where('hrd_person.ID','=',$request->LEADER_HR_ID)->first();
        $addrecord->LEADER_HR_NAME = $addinforpersonleader->HR_PREFIX_NAME.''.$addinforpersonleader->HR_FNAME.' '.$addinforpersonleader->HR_LNAME;
        $addrecord->LEADER_HR_POSITION = $addinforpersonleader->POSITION_IN_WORK;

        $addrecord->OFFER_WORK_HR_ID = $request->OFFER_WORK_HR_ID;
        $addinforpersonoffer=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
        ->where('hrd_person.ID','=',$request->OFFER_WORK_HR_ID)->first();
        $addrecord->OFFER_WORK_HR_NAME = $addinforpersonoffer->HR_PREFIX_NAME.''.$addinforpersonoffer->HR_FNAME.' '.$addinforpersonoffer->HR_LNAME;

    //-----------------------------------------------------
        $addrecord->RECORD_USER_ID = $request->PERSON_ID_CREATE;
        $addinforperson=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
        ->where('hrd_person.ID','=',$request->PERSON_ID_CREATE)->first();
        
        $addrecord->USER_POST_NAME = $addinforperson->HR_PREFIX_NAME.''.$addinforperson->HR_FNAME.' '.$addinforperson->HR_LNAME;
    
    
        //-----------------------------------------------------

        $addrecord->STATUS = 'APPLY'; 

    //--------------------------------------------------

        $addrecord->FROM_BAN_NUM = $request->FROM_BAN_NUM;
        $addrecord->FROM_TAMBON_ID = $request->FROM_TAMBON_ID; 
        $addrecord->FROM_AMPHUR_ID = $request->FROM_AMPHUR_ID; 
        $addrecord->FROM_PROVINCE_ID = $request->FROM_PROVINCE_ID; 

        $addrecord->BACK_BAN_NUM = $request->BACK_BAN_NUM;
        $addrecord->BACK_TAMBON_ID = $request->BACK_TAMBON_ID; 
        $addrecord->BACK_AMPHUR_ID = $request->BACK_AMPHUR_ID; 
        $addrecord->BACK_PROVINCE_ID = $request->BACK_PROVINCE_ID;

        $addrecord->BACK_TIME = $request->BACK_TIME; 
        $addrecord->FROM_TIME = $request->FROM_TIME;
        $addrecord->DISTANCE = $request->DISTANCE;
        $addrecord->CAR_REG = $request->CAR_REG;
        $addrecord->DR_PROVINCE_USE = $request->DR_PROVINCE_USE;
        $addrecord->save(); 

        $idrecorde = Recordindex::max('ID'); 

        if($request->PERSON_ID != '' || $request->PERSON_ID !=null){

         $PERSON_ID = $request->PERSON_ID;
         $number =count($PERSON_ID);
         $count = 0;
         for($count = 0; $count < $number; $count++)
         {  
            $id_person = $PERSON_ID[$count];

            $inforpersonuser=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                                    ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
                                    ->where('hrd_person.ID','=',$id_person)->first();


            $add = new Recordindexperson();
            $add->RECORD_ID = $idrecorde;
            $add->HR_PERSON_ID = $PERSON_ID[$count];
            $add->HR_FULLNAME = $inforpersonuser->HR_PREFIX_NAME.''.$inforpersonuser->HR_FNAME.' '.$inforpersonuser->HR_LNAME;
            $add->HR_POSITION = $inforpersonuser->POSITION_IN_WORK;
            $add->HR_LAVEL = $inforpersonuser->HR_LEVEL_NAME;
            $add->save(); 

           
         }

        }


        if($request->RECORD_CAPACITY_ID != '' || $request->RECORD_CAPACITY_ID != null){

         $RECORD_CAPACITY_ID = $request->RECORD_CAPACITY_ID;
         $number_2 =count($RECORD_CAPACITY_ID);
         $count_2 = 0;
         for($count_2 = 0; $count_2 < $number_2; $count_2++)
         {  
          
            $add_2 = new Recordindexcapacity();
            $add_2->RECORD_ID = $idrecorde;
            $add_2->RECORD_CAPACITY_ID = $RECORD_CAPACITY_ID[$count_2];
            $add_2->save(); 

         }

        }


        if($request->RECORD_BRANCH_ID != '' || $request->RECORD_BRANCH_ID != null){

         $RECORD_BRANCH_ID = $request->RECORD_BRANCH_ID;
         $number_3 =count($RECORD_BRANCH_ID);
         $count_3 = 0;
         for($count_3 = 0; $count_3 < $number_3; $count_3++)
         {  
          
            $add_3 = new Recordindexbranch();
            $add_3->RECORD_ID = $idrecorde;
            $add_3->RECORD_BRANCH_ID = $RECORD_BRANCH_ID[$count_3];
            $add_3->save(); 

         }
           
        }



         if($request->MONEY_ID != '' || $request->MONEY_ID != null){

         $MONEY_ID = $request->MONEY_ID;
         $SUMDAY = $request->SUMDAY;
         $SUMMONEY = $request->SUMMONEY;

         $number_4 =count($MONEY_ID);
         $count_4 = 0;
         for($count_4 = 0; $count_4 < $number_4; $count_4++)
         {  
          
            $add_4 = new Recordindexmoney();
            $add_4->RECORD_ID = $idrecorde;
            $add_4->MONEY_ID = $MONEY_ID[$count_4];
            $add_4->SUMDAY = $SUMDAY[$count_4];
            $add_4->SUMMONEY = $SUMMONEY[$count_4];
            $add_4->save(); 

         }

        }



 
        
         return redirect()->route('perdev.inforuser',['iduser'=>  $request->PERSON_ID_CREATE]);

}
    //---------------------แก้ไข-----------------------------------------

public function edit(Request $request,$id,$iduser)
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

        $location =  DB::table('grecord_org_location')->get();
        $org = DB::table('grecord_org')->get();
        $province =  DB::table('hrd_province')->get();
        $type_location =  DB::table('gleave_location')->get();
        $type =  DB::table('grecord_type')->get();
        $day_type =  DB::table('gleave_day_type')->get();
        $go =  DB::table('grecord_go')->get();
        $level =  DB::table('grecord_level')->get();
        $vehicle =  DB::table('grecord_vehicle')->get();
        $capacity =  DB::table('grecord_capacity')->get();
        $branch =  DB::table('grecord_branch')->get();
        $moneyset =  DB::table('grecord_money_set')->get();   
        $infoprovince =  DB::table('hrd_province')->get();
        


        $department = $inforpersonuser -> HR_DEPARTMENT_SUB_ID; 
        $LEAVEWORK_SEND =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->where('HR_STATUS_ID','=',1)
        ->where('HR_DEPARTMENT_SUB_ID','=',$department)->get();

        $leader_all =  DB::table('gleave_leader')
        ->leftJoin('hrd_person','hrd_person.ID','=','gleave_leader.LEADER_ID')
        ->get();
        $withdraw =  DB::table('grecord_withdraw')->get(); //ตารางสร้างขึ้นใหม่
     
        $PERSONALL =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->where('HR_STATUS_ID','=',1)
        ->get();

        $infoindex=  DB::table('grecord_index')
        ->leftJoin('hrd_amphur','hrd_amphur.ID','=','grecord_index.FROM_AMPHUR_ID')
        ->leftJoin('hrd_tumbon','hrd_tumbon.ID','=','grecord_index.FROM_TAMBON_ID')
       
        ->where('grecord_index.ID','=',$id)
        ->first();

        $infoindex_pro=  DB::table('grecord_index')->where('grecord_index.ID','=',$id)
        ->first();

        $infoindex_back=  DB::table('grecord_index')
        ->leftJoin('hrd_amphur','hrd_amphur.ID','=','grecord_index.BACK_AMPHUR_ID')
        ->leftJoin('hrd_tumbon','hrd_tumbon.ID','=','grecord_index.BACK_TAMBON_ID')
       
        ->where('grecord_index.ID','=',$id)
        ->first();

        $infoconcludeperson =  DB::table('grecord_index_person')
        ->where('RECORD_ID','=',$id)
        ->get();

        $infocapacity =  DB::table('grecord_index_capacity')
        ->where('RECORD_ID','=',$id)
        ->get();

        $infobranch=  DB::table('grecord_index_branch')
        ->where('RECORD_ID','=',$id)
        ->get();

        $infoconcludemoney = DB::table('grecord_index_money')
        ->where('RECORD_ID','=',$id)
        ->get();

        $year = date('Y')+543;


        $book =  DB::table('gbook_index')
        ->select('BOOK_NAME','BOOK_NUMBER','BOOK_DATE','BOOK_ID')
        ->where('BOOK_YEAR_ID','=',$year)
        ->orderBy('gbook_index.BOOK_ID', 'desc') 
        ->get();


        return view('person_develop.personinfodev_edit',[
            'inforpersonuser' => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid,
            'locations' => $location,
           'provinces' => $province,
            'type_locations' => $type_location,
            'types' => $type,
            'day_types' => $day_type,
            'gos' => $go,
            'levels' => $level,
            'vehicles' => $vehicle,
            'LEAVEWORK_SENDs' => $LEAVEWORK_SEND,
            'leader_alls' =>$leader_all,
            'withdraws' =>$withdraw,
            'PERSONALLs' => $PERSONALL,
            'capacitys' => $capacity,
            'branchs' => $branch,
            'infoprovinces' => $infoprovince,
            'moneysets'=> $moneyset,
            'orgs'=> $org,
            'infoindex'=> $infoindex, 
            'infoindex_back'=> $infoindex_back,  
            'id'=> $id,
            'infoconcludepersons'=> $infoconcludeperson,
            'infocapacitys'=> $infocapacity,
            'infobranchs'=> $infobranch,
            'infoconcludemoneys'=>$infoconcludemoney,
            'books'=> $book,
            'infoindex_pro' => $infoindex_pro
        ]);
}
public function update(Request $request)    {  
    $DATE_GO= $request->DATE_GO;
        
    if($DATE_GO != ''){
       
        $date_bigen_c = Carbon::createFromFormat('d/m/Y', $DATE_GO)->format('Y-m-d');
        $date_arrary=explode("-",$date_bigen_c);  
        $y_sub = $date_arrary[0]; 
            
        if($y_sub >= 2500){
            $y = $y_sub-543;
        }else{
            $y = $y_sub;
        }
        $m = $date_arrary[1];
        $d = $date_arrary[2];  
        $DATE_GO= $y."-".$m."-".$d;    
        }else{
        $DATE_GO= null;
    }


    $DATE_BACK= $request->DATE_BACK;
    
    if($DATE_BACK != ''){
       
        $date_bigen_c = Carbon::createFromFormat('d/m/Y', $DATE_BACK)->format('Y-m-d');
        $date_arrary=explode("-",$date_bigen_c);  
        $y_sub = $date_arrary[0]; 
            
        if($y_sub >= 2500){
            $y = $y_sub-543;
        }else{
            $y = $y_sub;
        }
        $m = $date_arrary[1];
        $d = $date_arrary[2];  
        $DATE_BACK= $y."-".$m."-".$d;    
        }else{
        $DATE_BACK= null;
    }



    $DATE_TRAVEL_GO = $request->DATE_TRAVEL_GO;
    
    if($DATE_TRAVEL_GO != ''){
       
        $date_bigen_c = Carbon::createFromFormat('d/m/Y', $DATE_TRAVEL_GO)->format('Y-m-d');
        $date_arrary=explode("-",$date_bigen_c); 
        
        $y_sub = $date_arrary[0]; 
            
        if($y_sub >= 2500){
            $y = $y_sub-543;
        }else{
            $y = $y_sub;
        }

        $m = $date_arrary[1];
        $d = $date_arrary[2];  
        $DATE_TRAVEL_GO= $y."-".$m."-".$d;    
        }else{
        $DATE_TRAVEL_GO= null;
    }


    $DATE_TRAVEL_BACK = $request->DATE_TRAVEL_BACK;
    
    if($DATE_TRAVEL_BACK != ''){
       
        $date_bigen_c = Carbon::createFromFormat('d/m/Y', $DATE_TRAVEL_BACK)->format('Y-m-d');
        $date_arrary=explode("-",$date_bigen_c);  
        
        $y_sub = $date_arrary[0]; 
            
        if($y_sub >= 2500){
            $y = $y_sub-543;
        }else{
            $y = $y_sub;
        }

        $m = $date_arrary[1];
        $d = $date_arrary[2];  
        $DATE_TRAVEL_BACK= $y."-".$m."-".$d;    
        }else{
        $DATE_TRAVEL_BACK= null;
    } 


    $BOOKDATEREG = $request->BOOK_DATE_REG;
    
    if($BOOKDATEREG != ''){
       
        $date_bigen_c = Carbon::createFromFormat('d/m/Y', $BOOKDATEREG)->format('Y-m-d');
        $date_arrary=explode("-",$date_bigen_c);  
        
        $y_sub = $date_arrary[0]; 
            
        if($y_sub >= 2500){
            $y = $y_sub-543;
        }else{
            $y = $y_sub;
        }

        $m = $date_arrary[1];
        $d = $date_arrary[2];  
        $BOOK_DATE_REG= $y."-".$m."-".$d;    
        }else{
        $BOOK_DATE_REG= null;
    } 

  

    $id = $request->ID;

    $addrecord = Recordindex::find($id);
    $addrecord->RECORD_HEAD_USE = $request->RECORD_HEAD_USE;
    $addrecord->RECORD_LOCATION_ID = $request->RECORD_LOCATION_ID;
    $addrecord->PROVINCE_ID = $request->PROVINCE_ID;
    $addrecord->RECORD_LEVEL_ID = $request->RECORD_LEVEL_ID;
    $addrecord->RECORD_TYPE_ID = $request->RECORD_TYPE_ID;
    $addrecord->LOCATION_PROV_ID = $request->LOCATION_PROV_ID;
    $addrecord->RECORD_ORG_ID = $request->RECORD_ORG_ID;

    $addrecord->BOOK_ID = $request->BOOK_ID;
    $addrecord->BOOK_NAME = $request->BOOK_NAME;
    $addrecord->BOOK_NUM = $request->BOOK_NUM;
    $addrecord->BOOK_DATE_REG = $BOOK_DATE_REG;

    $addrecord->DATE_GO = $DATE_GO;
    $addrecord->DATE_BACK = $DATE_BACK; 

    $addrecord->DAY_TYPE_ID = $request->DAY_TYPE_ID;

    $addrecord->DATE_TRAVEL_GO = $DATE_TRAVEL_GO;
    $addrecord->DATE_TRAVEL_BACK = $DATE_TRAVEL_BACK; 

    $addrecord->RECORD_GO_ID = $request->RECORD_GO_ID; 
    $addrecord->RECORD_VEHICLE_ID = $request->RECORD_VEHICLE_ID; 
   
    $addrecord->RECORD_MONEY_ID = $request->RECORD_MONEY_ID; 
    $addrecord->RECORD_COMMENT = $request->RECORD_COMMENT;
    
    $addrecord->LEADER_HR_ID = $request->LEADER_HR_ID; 
    $addinforpersonleader=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
    ->where('hrd_person.ID','=',$request->LEADER_HR_ID)->first();
    $addrecord->LEADER_HR_NAME = $addinforpersonleader->HR_PREFIX_NAME.''.$addinforpersonleader->HR_FNAME.' '.$addinforpersonleader->HR_LNAME;
    $addrecord->LEADER_HR_POSITION = $addinforpersonleader->POSITION_IN_WORK;

    $addrecord->OFFER_WORK_HR_ID = $request->OFFER_WORK_HR_ID;
    $addinforpersonoffer=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
    ->where('hrd_person.ID','=',$request->OFFER_WORK_HR_ID)->first();
    $addrecord->OFFER_WORK_HR_NAME = $addinforpersonoffer->HR_PREFIX_NAME.''.$addinforpersonoffer->HR_FNAME.' '.$addinforpersonoffer->HR_LNAME;

//-----------------------------------------------------

    $addrecord->RECORD_USER_ID =  $request->PERSON_ID_CREATE;
    $addinforperson=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
    ->where('hrd_person.ID','=',$request->PERSON_ID_CREATE)->first();
    
    $addrecord->USER_POST_NAME = $addinforperson->HR_PREFIX_NAME.''.$addinforperson->HR_FNAME.' '.$addinforperson->HR_LNAME;
//-----------------------------------------------------

  
//--------------------------------------------------

    $addrecord->FROM_BAN_NUM = $request->FROM_BAN_NUM;
    $addrecord->FROM_TAMBON_ID = $request->FROM_TAMBON_ID; 
    $addrecord->FROM_AMPHUR_ID = $request->FROM_AMPHUR_ID; 
    $addrecord->FROM_PROVINCE_ID = $request->FROM_PROVINCE_ID; 

    $addrecord->BACK_BAN_NUM = $request->BACK_BAN_NUM;
    $addrecord->BACK_TAMBON_ID = $request->BACK_TAMBON_ID; 
    $addrecord->BACK_AMPHUR_ID = $request->BACK_AMPHUR_ID; 
    $addrecord->BACK_PROVINCE_ID = $request->BACK_PROVINCE_ID;

    $addrecord->BACK_TIME = $request->BACK_TIME; 
    $addrecord->FROM_TIME = $request->FROM_TIME;
    $addrecord->DISTANCE = $request->DISTANCE;
    $addrecord->CAR_REG = $request->CAR_REG;

    $addrecord->DR_PROVINCE_USE = $request->DR_PROVINCE_USE;

    $addrecord->save(); 

   
    $idrecorde = $id;  


    Recordindexperson::where('RECORD_ID', '=', $idrecorde )->delete();
    Recordindexcapacity::where('RECORD_ID', '=', $idrecorde )->delete();
    Recordindexbranch::where('RECORD_ID', '=', $idrecorde )->delete();
    Recordindexmoney::where('RECORD_ID', '=', $idrecorde )->delete();

    if($request->PERSON_ID != '' || $request->PERSON_ID !=null){

     $PERSON_ID = $request->PERSON_ID;
     $number =count($PERSON_ID);
     $count = 0;
     for($count = 0; $count < $number; $count++)
     {  
        $id_person = $PERSON_ID[$count];

        $inforpersonuser=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                                ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
                                ->where('hrd_person.ID','=',$id_person)->first();


        $add = new Recordindexperson();
        $add->RECORD_ID = $idrecorde;
        $add->HR_PERSON_ID = $PERSON_ID[$count];
        $add->HR_FULLNAME = $inforpersonuser->HR_PREFIX_NAME.''.$inforpersonuser->HR_FNAME.' '.$inforpersonuser->HR_LNAME;
        $add->HR_POSITION = $inforpersonuser->POSITION_IN_WORK;
        $add->HR_LAVEL = $inforpersonuser->HR_LEVEL_NAME;
        $add->save(); 

       
     }

    }

    if($request->RECORD_CAPACITY_ID != '' || $request->RECORD_CAPACITY_ID != null){

     $RECORD_CAPACITY_ID = $request->RECORD_CAPACITY_ID;
     $number_2 =count($RECORD_CAPACITY_ID);
     $count_2 = 0;
     for($count_2 = 0; $count_2 < $number_2; $count_2++)
     {  
      
        $add_2 = new Recordindexcapacity();
        $add_2->RECORD_ID = $idrecorde;
        $add_2->RECORD_CAPACITY_ID = $RECORD_CAPACITY_ID[$count_2];
        $add_2->save(); 

     }

    }

    if($request->RECORD_BRANCH_ID != '' || $request->RECORD_BRANCH_ID != null){

     $RECORD_BRANCH_ID = $request->RECORD_BRANCH_ID;
     $number_3 =count($RECORD_BRANCH_ID);
     $count_3 = 0;
     for($count_3 = 0; $count_3 < $number_3; $count_3++)
     {  
      
        $add_3 = new Recordindexbranch();
        $add_3->RECORD_ID = $idrecorde;
        $add_3->RECORD_BRANCH_ID = $RECORD_BRANCH_ID[$count_3];
        $add_3->save(); 

     }

    }
       

    if($request->MONEY_ID != '' || $request->MONEY_ID != null){

     $MONEY_ID = $request->MONEY_ID;
     $SUMDAY = $request->SUMDAY;
     $SUMMONEY = $request->SUMMONEY;

     $number_4 =count($MONEY_ID);
     $count_4 = 0;
     for($count_4 = 0; $count_4 < $number_4; $count_4++)
     {  
      
        $add_4 = new Recordindexmoney();
        $add_4->RECORD_ID = $idrecorde;
        $add_4->MONEY_ID = $MONEY_ID[$count_4];
        $add_4->SUMDAY = $SUMDAY[$count_4];
        $add_4->SUMMONEY = $SUMMONEY[$count_4];
        $add_4->save(); 

     }
    }



    
     return redirect()->route('perdev.inforuser',['iduser'=>  $request->PERSON_ID_CREATE]);

    }

    //------------------------ยกเลิก-------------------------------------

public function cancel(Request $request,$id,$iduser)
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
 
     $inforecord=  Recordindex::leftJoin('grecord_org_location','grecord_org_location.LOCATION_ID','=','grecord_index.RECORD_LOCATION_ID')
         ->leftJoin('grecord_level','grecord_level.ID','=','grecord_index.RECORD_LEVEL_ID')
         ->leftJoin('gleave_location','gleave_location.LOCATION_ID','=','grecord_index.LOCATION_PROV_ID')
         ->leftJoin('grecord_go','grecord_go.RECORD_GO_ID','=','grecord_index.RECORD_GO_ID')
         ->leftJoin('grecord_vehicle','grecord_vehicle.RECORD_VEHICLE_ID','=','grecord_index.RECORD_VEHICLE_ID')
         ->leftJoin('grecord_withdraw','grecord_withdraw.WITHDRAW_ID','=','grecord_index.RECORD_MONEY_ID')
         ->where('grecord_index.ID','=',$id)
         ->first();
         
         
 
     return view('person_develop.personinfodevcancel',[
         'inforpersonuser' => $inforpersonuser,
         'inforpersonuserid' => $inforpersonuserid, 
         'inforecord' => $inforecord,
         'inforecordid' => $id
     ]);
}

public function updatecancel(Request $request)
    {
    $id = $request->ID; 

      $updatecancel = Recordindex::find($id);
      $updatecancel->CANCEL_COMMENT = $request->CANCEL_COMMENT;
      $updatecancel->STATUS = 'CANCEL'; 
      $updatecancel->save();
      
          return redirect()->route('perdev.inforuser',['iduser'=>  $request->PERSON_ID]);

}

    //========================================หน้าตรวจสอบ==========================================

public function infover(Request $request,$iduser)
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

    $inforrecordindex =  Recordindex::select('grecord_index.ID','grecord_index.STATUS','STATUS_NAME','RECORD_TYPE_NAME','grecord_index.RECORD_TYPE_ID','USER_POST_NAME','RECORD_HEAD_USE','LOCATION_ORG_NAME'
    ,'RECORD_LEVEL_NAME','RECORD_ORGANIZER_NAME','gleave_location.LOCATION_NAME','DATE_GO','DATE_BACK','RECORD_COMMENT','RECORD_GO_NAME','RECORD_VEHICLE_NAME','WITHDRAW_NAME'
    ,'LEADER_HR_NAME','OFFER_WORK_HR_NAME','SAVE_BACK','RECORD_USER_ID','POSITION_IN_WORK','HR_DEPARTMENT_SUB_NAME')
->leftJoin('hrd_person','grecord_index.RECORD_USER_ID','=','hrd_person.ID')
->leftJoin('hrd_department_sub','hrd_department_sub.HR_DEPARTMENT_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_ID')
->leftJoin('grecord_status','grecord_index.STATUS','=','grecord_status.STATUS')
->leftJoin('grecord_type','grecord_index.RECORD_TYPE_ID','=','grecord_type.RECORD_TYPE_ID')
->leftJoin('grecord_org_location','grecord_org_location.LOCATION_ID','=','grecord_index.RECORD_LOCATION_ID')
->leftJoin('grecord_level','grecord_level.ID','=','grecord_index.RECORD_LEVEL_ID')
->leftJoin('gleave_location','gleave_location.LOCATION_ID','=','grecord_index.LOCATION_PROV_ID')
->leftJoin('grecord_go','grecord_go.RECORD_GO_ID','=','grecord_index.RECORD_GO_ID')
->leftJoin('grecord_vehicle','grecord_vehicle.RECORD_VEHICLE_ID','=','grecord_index.RECORD_VEHICLE_ID')
->leftJoin('grecord_withdraw','grecord_withdraw.WITHDRAW_ID','=','grecord_index.RECORD_MONEY_ID')
->where('grecord_index.STATUS','=','APPLY')
->orderBy('grecord_index.ID', 'desc')  
->get();

        $grecordstatus = DB::table('grecord_status')->get(); 

        
        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;
        }
        
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';
        $status = '1';
        $search = '';
        $year_id = $yearbudget;
       
    return view('person_develop.personinfodevver',[
        'inforpersonuser' => $inforpersonuser,
        'inforpersonuserid' => $inforpersonuserid,
        'inforrecordindexs'=> $inforrecordindex,
        'grecordstatuss' => $grecordstatus,
        'displaydate_bigen'=> $displaydate_bigen, 
        'displaydate_end'=> $displaydate_end,
        'status_check' => $status,
        'search' => $search,
        'budgets' =>  $budget,
        'year_id'=>$year_id       
        
    ]);
}


public function searchinfover(Request $request,$iduser)
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
        $status = $request->STATUS_CODE;
        $datebigin = $request->get('DATE_BIGIN');
        $dateend = $request->get('DATE_END'); 
        $yearbudget = $request->BUDGET_YEAR; 

        if($search==''){
            $search="";
        }    

                if( $datebigin != '' && $dateend != ''){

                 
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
            $inforrecordindex =  Recordindex::select('grecord_index.ID','grecord_index.STATUS','STATUS_NAME','RECORD_TYPE_NAME','grecord_index.RECORD_TYPE_ID','USER_POST_NAME','RECORD_HEAD_USE','LOCATION_ORG_NAME'
            ,'RECORD_LEVEL_NAME','RECORD_ORGANIZER_NAME','gleave_location.LOCATION_NAME','DATE_GO','DATE_BACK','RECORD_COMMENT','RECORD_GO_NAME','RECORD_VEHICLE_NAME','WITHDRAW_NAME'
            ,'LEADER_HR_NAME','OFFER_WORK_HR_NAME','SAVE_BACK','RECORD_USER_ID','POSITION_IN_WORK','HR_DEPARTMENT_SUB_NAME')
                ->leftJoin('hrd_person','grecord_index.RECORD_USER_ID','=','hrd_person.ID')
                ->leftJoin('hrd_department_sub','hrd_department_sub.HR_DEPARTMENT_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_ID')
                ->leftJoin('grecord_status','grecord_index.STATUS','=','grecord_status.STATUS')
                ->leftJoin('grecord_type','grecord_index.RECORD_TYPE_ID','=','grecord_type.RECORD_TYPE_ID')
                ->leftJoin('grecord_org_location','grecord_org_location.LOCATION_ID','=','grecord_index.RECORD_LOCATION_ID')
                ->leftJoin('grecord_level','grecord_level.ID','=','grecord_index.RECORD_LEVEL_ID')
                ->leftJoin('gleave_location','gleave_location.LOCATION_ID','=','grecord_index.LOCATION_PROV_ID')
                ->leftJoin('grecord_go','grecord_go.RECORD_GO_ID','=','grecord_index.RECORD_GO_ID')
                ->leftJoin('grecord_vehicle','grecord_vehicle.RECORD_VEHICLE_ID','=','grecord_index.RECORD_VEHICLE_ID')
                ->leftJoin('grecord_withdraw','grecord_withdraw.WITHDRAW_ID','=','grecord_index.RECORD_MONEY_ID')                                          
                        ->where(function($q) use ($search){
                            $q->where('grecord_index.ID','like','%'.$search.'%');
                            $q->orwhere('USER_POST_NAME','like','%'.$search.'%');  
                            $q->orwhere('RECORD_TYPE_NAME','like','%'.$search.'%');
                            $q->orwhere('RECORD_HEAD_USE','like','%'.$search.'%');    
                            $q->orwhere('HR_DEPARTMENT_SUB_NAME','like','%'.$search.'%');                                             
                        })
                        ->WhereBetween('DATE_GO',[$from,$to]) 
                        ->orderBy('grecord_index.ID', 'desc')    
                        ->get();
            }else{
               
                
                $inforrecordindex =   Recordindex::select('grecord_index.ID','grecord_index.STATUS','STATUS_NAME','RECORD_TYPE_NAME','grecord_index.RECORD_TYPE_ID','USER_POST_NAME','RECORD_HEAD_USE','LOCATION_ORG_NAME'
                ,'RECORD_LEVEL_NAME','RECORD_ORGANIZER_NAME','gleave_location.LOCATION_NAME','DATE_GO','DATE_BACK','RECORD_COMMENT','RECORD_GO_NAME','RECORD_VEHICLE_NAME','WITHDRAW_NAME'
                ,'LEADER_HR_NAME','OFFER_WORK_HR_NAME','SAVE_BACK','RECORD_USER_ID','POSITION_IN_WORK','HR_DEPARTMENT_SUB_NAME')
                        ->leftJoin('hrd_person','grecord_index.RECORD_USER_ID','=','hrd_person.ID')
                        ->leftJoin('hrd_department_sub','hrd_department_sub.HR_DEPARTMENT_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_ID')
                        ->leftJoin('grecord_status','grecord_index.STATUS','=','grecord_status.STATUS')
                        ->leftJoin('grecord_type','grecord_index.RECORD_TYPE_ID','=','grecord_type.RECORD_TYPE_ID')
                        ->leftJoin('grecord_org_location','grecord_org_location.LOCATION_ID','=','grecord_index.RECORD_LOCATION_ID')
                        ->leftJoin('grecord_level','grecord_level.ID','=','grecord_index.RECORD_LEVEL_ID')
                        ->leftJoin('gleave_location','gleave_location.LOCATION_ID','=','grecord_index.LOCATION_PROV_ID')
                        ->leftJoin('grecord_go','grecord_go.RECORD_GO_ID','=','grecord_index.RECORD_GO_ID')
                        ->leftJoin('grecord_vehicle','grecord_vehicle.RECORD_VEHICLE_ID','=','grecord_index.RECORD_VEHICLE_ID')
                        ->leftJoin('grecord_withdraw','grecord_withdraw.WITHDRAW_ID','=','grecord_index.RECORD_MONEY_ID')
                        ->where('ID_STATUS','=',$status)                                          
                        ->where(function($q) use ($search){
                            $q->where('grecord_index.ID','like','%'.$search.'%');
                            $q->orwhere('USER_POST_NAME','like','%'.$search.'%');  
                            $q->orwhere('RECORD_TYPE_NAME','like','%'.$search.'%');
                            $q->orwhere('RECORD_HEAD_USE','like','%'.$search.'%'); 
                            $q->orwhere('HR_DEPARTMENT_SUB_NAME','like','%'.$search.'%');                                                                                            
                        })
                        ->WhereBetween('DATE_GO',[$from,$to]) 
                        ->orderBy('grecord_index.ID', 'desc')    
                        ->get();
            }    
            
             }else{
                if($status == null){ 
                $inforrecordindex =   Recordindex::select('grecord_index.ID','grecord_index.STATUS','STATUS_NAME','RECORD_TYPE_NAME','grecord_index.RECORD_TYPE_ID','USER_POST_NAME','RECORD_HEAD_USE','LOCATION_ORG_NAME'
                ,'RECORD_LEVEL_NAME','RECORD_ORGANIZER_NAME','gleave_location.LOCATION_NAME','DATE_GO','DATE_BACK','RECORD_COMMENT','RECORD_GO_NAME','RECORD_VEHICLE_NAME','WITHDRAW_NAME'
                ,'LEADER_HR_NAME','OFFER_WORK_HR_NAME','SAVE_BACK','RECORD_USER_ID','POSITION_IN_WORK','HR_DEPARTMENT_SUB_NAME')
                        ->leftJoin('hrd_person','grecord_index.RECORD_USER_ID','=','hrd_person.ID')
                        ->leftJoin('hrd_department_sub','hrd_department_sub.HR_DEPARTMENT_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_ID')
                        ->leftJoin('grecord_status','grecord_index.STATUS','=','grecord_status.STATUS')
                        ->leftJoin('grecord_type','grecord_index.RECORD_TYPE_ID','=','grecord_type.RECORD_TYPE_ID')
                        ->leftJoin('grecord_org_location','grecord_org_location.LOCATION_ID','=','grecord_index.RECORD_LOCATION_ID')
                        ->leftJoin('grecord_level','grecord_level.ID','=','grecord_index.RECORD_LEVEL_ID')
                        ->leftJoin('gleave_location','gleave_location.LOCATION_ID','=','grecord_index.LOCATION_PROV_ID')
                        ->leftJoin('grecord_go','grecord_go.RECORD_GO_ID','=','grecord_index.RECORD_GO_ID')
                        ->leftJoin('grecord_vehicle','grecord_vehicle.RECORD_VEHICLE_ID','=','grecord_index.RECORD_VEHICLE_ID')
                        ->leftJoin('grecord_withdraw','grecord_withdraw.WITHDRAW_ID','=','grecord_index.RECORD_MONEY_ID')
                                ->where(function($q) use ($search){
                                    $q->where('grecord_index.ID','like','%'.$search.'%');
                                    $q->orwhere('USER_POST_NAME','like','%'.$search.'%');  
                                    $q->orwhere('RECORD_TYPE_NAME','like','%'.$search.'%');
                                    $q->orwhere('RECORD_HEAD_USE','like','%'.$search.'%');  
                                    $q->orwhere('HR_DEPARTMENT_SUB_NAME','like','%'.$search.'%');                                                                                           
                                })                                                   
                                ->orderBy('grecord_index.ID', 'desc')    
                                ->get();
                }else{
                    $inforrecordindex =   Recordindex::select('grecord_index.ID','grecord_index.STATUS','STATUS_NAME','RECORD_TYPE_NAME','grecord_index.RECORD_TYPE_ID','USER_POST_NAME','RECORD_HEAD_USE','LOCATION_ORG_NAME'
                    ,'RECORD_LEVEL_NAME','RECORD_ORGANIZER_NAME','gleave_location.LOCATION_NAME','DATE_GO','DATE_BACK','RECORD_COMMENT','RECORD_GO_NAME','RECORD_VEHICLE_NAME','WITHDRAW_NAME'
                    ,'LEADER_HR_NAME','OFFER_WORK_HR_NAME','SAVE_BACK','RECORD_USER_ID','POSITION_IN_WORK','HR_DEPARTMENT_SUB_NAME')
                        ->leftJoin('hrd_person','grecord_index.RECORD_USER_ID','=','hrd_person.ID')
                        ->leftJoin('hrd_department_sub','hrd_department_sub.HR_DEPARTMENT_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_ID')
                        ->leftJoin('grecord_status','grecord_index.STATUS','=','grecord_status.STATUS')
                        ->leftJoin('grecord_type','grecord_index.RECORD_TYPE_ID','=','grecord_type.RECORD_TYPE_ID')
                        ->leftJoin('grecord_org_location','grecord_org_location.LOCATION_ID','=','grecord_index.RECORD_LOCATION_ID')
                        ->leftJoin('grecord_level','grecord_level.ID','=','grecord_index.RECORD_LEVEL_ID')
                        ->leftJoin('gleave_location','gleave_location.LOCATION_ID','=','grecord_index.LOCATION_PROV_ID')
                        ->leftJoin('grecord_go','grecord_go.RECORD_GO_ID','=','grecord_index.RECORD_GO_ID')
                        ->leftJoin('grecord_vehicle','grecord_vehicle.RECORD_VEHICLE_ID','=','grecord_index.RECORD_VEHICLE_ID')
                        ->leftJoin('grecord_withdraw','grecord_withdraw.WITHDRAW_ID','=','grecord_index.RECORD_MONEY_ID')
                            ->where('ID_STATUS','=',$status)  
                            ->where(function($q) use ($search){
                                $q->where('grecord_index.ID','like','%'.$search.'%');
                                $q->orwhere('USER_POST_NAME','like','%'.$search.'%');  
                                $q->orwhere('RECORD_TYPE_NAME','like','%'.$search.'%');
                                $q->orwhere('RECORD_HEAD_USE','like','%'.$search.'%');  
                                $q->orwhere('HR_DEPARTMENT_SUB_NAME','like','%'.$search.'%');                                                                                           
                            })                                                   
                            ->orderBy('grecord_index.ID', 'desc')    
                            ->get();                       
                }
            }        


        $grecordstatus = DB::table('grecord_status')->get(); 
        $year_id = $yearbudget;

        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get(); 


            return view('person_develop.personinfodevver',[ 
                 'inforpersonuser' => $inforpersonuser, 
                 'inforpersonuserid' => $inforpersonuserid,            
                'inforrecordindexs' => $inforrecordindex,
                  'grecordstatuss' => $grecordstatus,
                  'displaydate_bigen'=> $displaydate_bigen, 
                  'displaydate_end'=> $displaydate_end,
                  'status_check' => $status,
                  'search' => $search,
                  'year_id'=>$year_id, 
                  'budgets' =>  $budget,           
          
                
            ]);
           
}


public function ver(Request $request,$id,$iduser)
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

    $inforecord=  Recordindex::leftJoin('grecord_org_location','grecord_org_location.LOCATION_ID','=','grecord_index.RECORD_LOCATION_ID')
        ->leftJoin('grecord_level','grecord_level.ID','=','grecord_index.RECORD_LEVEL_ID')
        ->leftJoin('gleave_location','gleave_location.LOCATION_ID','=','grecord_index.LOCATION_PROV_ID')
        ->leftJoin('grecord_go','grecord_go.RECORD_GO_ID','=','grecord_index.RECORD_GO_ID')
        ->leftJoin('grecord_vehicle','grecord_vehicle.RECORD_VEHICLE_ID','=','grecord_index.RECORD_VEHICLE_ID')
        ->leftJoin('grecord_withdraw','grecord_withdraw.WITHDRAW_ID','=','grecord_index.RECORD_MONEY_ID')
        ->where('grecord_index.ID','=',$id)
        ->first();
        
        

    return view('person_develop.personinfodevver_check',[
        'inforpersonuser' => $inforpersonuser,
        'inforpersonuserid' => $inforpersonuserid, 
        'inforecord' => $inforecord,
        'inforecordid' => $id
    ]);
}


public function updatever(Request $request)
    {  
            $id = $request->ID; 

            $check =  $request->SUBMIT; 

            if($check == 'approved'){
            $statuscode = 'RECEIVE';
            }else{
            $statuscode = 'EDIT';
            }
            $updatever = Recordindex::find($id);
            $updatever->VERIFY_COMMENT = $request->VERIFY_COMMENT;
            $updatever->STATUS = $statuscode; 

            $updatever->RECEIVE_BY_ID = $request->PERSON_ID; 
            $addinforperson=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
            ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
            ->where('hrd_person.ID','=',$request->PERSON_ID)->first();
            
            $updatever->RECEIVE_BY_NAME = $addinforperson->HR_PREFIX_NAME.''.$addinforperson->HR_FNAME.' '.$addinforperson->HR_LNAME;
            //-----------------------------------------------------
      
            $updatever->save();  
                return redirect()->route('perdev.inforver',['iduser'=>  $request->PERSON_ID]);

    }
//=================================================หน้าอนุมัติ==============================================

public function infoapp(Request $request,$iduser)
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

    $inforrecordindex = Recordindex::select('grecord_index.ID','grecord_index.STATUS','STATUS_NAME','RECORD_TYPE_NAME','grecord_index.RECORD_TYPE_ID','USER_POST_NAME','RECORD_HEAD_USE','LOCATION_ORG_NAME'
    ,'RECORD_LEVEL_NAME','RECORD_ORGANIZER_NAME','gleave_location.LOCATION_NAME','DATE_GO','DATE_BACK','RECORD_COMMENT','RECORD_GO_NAME','RECORD_VEHICLE_NAME','WITHDRAW_NAME'
    ,'LEADER_HR_NAME','OFFER_WORK_HR_NAME','SAVE_BACK','RECORD_USER_ID','POSITION_IN_WORK','HR_DEPARTMENT_SUB_NAME')
->leftJoin('hrd_person','grecord_index.RECORD_USER_ID','=','hrd_person.ID')
->leftJoin('hrd_department_sub','hrd_department_sub.HR_DEPARTMENT_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_ID')
->leftJoin('grecord_status','grecord_index.STATUS','=','grecord_status.STATUS')
->leftJoin('grecord_type','grecord_index.RECORD_TYPE_ID','=','grecord_type.RECORD_TYPE_ID')
->leftJoin('grecord_org_location','grecord_org_location.LOCATION_ID','=','grecord_index.RECORD_LOCATION_ID')
->leftJoin('grecord_level','grecord_level.ID','=','grecord_index.RECORD_LEVEL_ID')
->leftJoin('gleave_location','gleave_location.LOCATION_ID','=','grecord_index.LOCATION_PROV_ID')
->leftJoin('grecord_go','grecord_go.RECORD_GO_ID','=','grecord_index.RECORD_GO_ID')
->leftJoin('grecord_vehicle','grecord_vehicle.RECORD_VEHICLE_ID','=','grecord_index.RECORD_VEHICLE_ID')
->leftJoin('grecord_withdraw','grecord_withdraw.WITHDRAW_ID','=','grecord_index.RECORD_MONEY_ID')
                                    ->where('grecord_index.LEADER_HR_ID','=',$iduser)
                                    ->where('grecord_index.STATUS','=','RECEIVE')
                                    ->orderBy('grecord_index.ID', 'desc')  
                                    ->get();

        $grecordstatus = DB::table('grecord_status')->get(); 

        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;
        }
        
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';
        $status = '2';
        $search = '';
        $year_id = $yearbudget;

    return view('person_develop.personinfodevapp',[
        'inforpersonuser' => $inforpersonuser,
        'inforpersonuserid' => $inforpersonuserid,
        'inforrecordindexs'=> $inforrecordindex,
        'grecordstatuss' => $grecordstatus,
        'displaydate_bigen'=> $displaydate_bigen, 
        'displaydate_end'=> $displaydate_end,
        'status_check' => $status,
        'search' => $search,
        'budgets' =>  $budget,
        'year_id'=>$year_id         
    ]);
}

public function searchinfoapp(Request $request,$iduser)
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
       $status = $request->STATUS_CODE;
       $datebigin = $request->get('DATE_BIGIN');
       $dateend = $request->get('DATE_END');
       
       $yearbudget = $request->BUDGET_YEAR;
       if($search==''){
           $search="";
       }
    

               if( $datebigin != '' && $dateend != ''){

                        
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
           $inforrecordindex =  Recordindex::select('grecord_index.ID','grecord_index.STATUS','STATUS_NAME','RECORD_TYPE_NAME','grecord_index.RECORD_TYPE_ID','USER_POST_NAME','RECORD_HEAD_USE','LOCATION_ORG_NAME'
           ,'RECORD_LEVEL_NAME','RECORD_ORGANIZER_NAME','gleave_location.LOCATION_NAME','DATE_GO','DATE_BACK','RECORD_COMMENT','RECORD_GO_NAME','RECORD_VEHICLE_NAME','WITHDRAW_NAME'
           ,'LEADER_HR_NAME','OFFER_WORK_HR_NAME','SAVE_BACK','RECORD_USER_ID','POSITION_IN_WORK','HR_DEPARTMENT_SUB_NAME')
       ->leftJoin('hrd_person','grecord_index.RECORD_USER_ID','=','hrd_person.ID')
       ->leftJoin('hrd_department_sub','hrd_department_sub.HR_DEPARTMENT_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_ID')
       ->leftJoin('grecord_status','grecord_index.STATUS','=','grecord_status.STATUS')
       ->leftJoin('grecord_type','grecord_index.RECORD_TYPE_ID','=','grecord_type.RECORD_TYPE_ID')
       ->leftJoin('grecord_org_location','grecord_org_location.LOCATION_ID','=','grecord_index.RECORD_LOCATION_ID')
       ->leftJoin('grecord_level','grecord_level.ID','=','grecord_index.RECORD_LEVEL_ID')
       ->leftJoin('gleave_location','gleave_location.LOCATION_ID','=','grecord_index.LOCATION_PROV_ID')
       ->leftJoin('grecord_go','grecord_go.RECORD_GO_ID','=','grecord_index.RECORD_GO_ID')
       ->leftJoin('grecord_vehicle','grecord_vehicle.RECORD_VEHICLE_ID','=','grecord_index.RECORD_VEHICLE_ID')
       ->leftJoin('grecord_withdraw','grecord_withdraw.WITHDRAW_ID','=','grecord_index.RECORD_MONEY_ID')
                                           ->where(function($q) use ($search){
                                               $q->where('grecord_index.ID','like','%'.$search.'%');
                                               $q->orwhere('USER_POST_NAME','like','%'.$search.'%');  
                                               $q->orwhere('RECORD_TYPE_NAME','like','%'.$search.'%');
                                               $q->orwhere('RECORD_HEAD_USE','like','%'.$search.'%');   
                                               $q->orwhere('HR_DEPARTMENT_SUB_NAME','like','%'.$search.'%');                                               
                                           })
                                           ->WhereBetween('DATE_GO',[$from,$to]) 
                                           ->orderBy('grecord_index.ID', 'desc')    
                                           ->get();
           }else{
              

               
               $inforrecordindex =  Recordindex::select('grecord_index.ID','grecord_index.STATUS','STATUS_NAME','RECORD_TYPE_NAME','grecord_index.RECORD_TYPE_ID','USER_POST_NAME','RECORD_HEAD_USE','LOCATION_ORG_NAME'
               ,'RECORD_LEVEL_NAME','RECORD_ORGANIZER_NAME','gleave_location.LOCATION_NAME','DATE_GO','DATE_BACK','RECORD_COMMENT','RECORD_GO_NAME','RECORD_VEHICLE_NAME','WITHDRAW_NAME'
               ,'LEADER_HR_NAME','OFFER_WORK_HR_NAME','SAVE_BACK','RECORD_USER_ID','POSITION_IN_WORK','HR_DEPARTMENT_SUB_NAME')
           ->leftJoin('hrd_person','grecord_index.RECORD_USER_ID','=','hrd_person.ID')
           ->leftJoin('hrd_department_sub','hrd_department_sub.HR_DEPARTMENT_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_ID')
           ->leftJoin('grecord_status','grecord_index.STATUS','=','grecord_status.STATUS')
           ->leftJoin('grecord_type','grecord_index.RECORD_TYPE_ID','=','grecord_type.RECORD_TYPE_ID')
           ->leftJoin('grecord_org_location','grecord_org_location.LOCATION_ID','=','grecord_index.RECORD_LOCATION_ID')
           ->leftJoin('grecord_level','grecord_level.ID','=','grecord_index.RECORD_LEVEL_ID')
           ->leftJoin('gleave_location','gleave_location.LOCATION_ID','=','grecord_index.LOCATION_PROV_ID')
           ->leftJoin('grecord_go','grecord_go.RECORD_GO_ID','=','grecord_index.RECORD_GO_ID')
           ->leftJoin('grecord_vehicle','grecord_vehicle.RECORD_VEHICLE_ID','=','grecord_index.RECORD_VEHICLE_ID')
           ->leftJoin('grecord_withdraw','grecord_withdraw.WITHDRAW_ID','=','grecord_index.RECORD_MONEY_ID')
                                               ->where('ID_STATUS','=',$status)                                          
                                               ->where(function($q) use ($search){
                                                   $q->where('grecord_index.ID','like','%'.$search.'%');
                                                   $q->orwhere('USER_POST_NAME','like','%'.$search.'%');  
                                                   $q->orwhere('RECORD_TYPE_NAME','like','%'.$search.'%');
                                                   $q->orwhere('RECORD_HEAD_USE','like','%'.$search.'%');    
                                                   $q->orwhere('HR_DEPARTMENT_SUB_NAME','like','%'.$search.'%');                                              
                                               })
                                               ->WhereBetween('DATE_GO',[$from,$to]) 
                                               ->orderBy('grecord_index.ID', 'desc')    
                                               ->get();
           }    
           
            }else{
               if($status == null){ 
               $inforrecordindex =  Recordindex::select('grecord_index.ID','grecord_index.STATUS','STATUS_NAME','RECORD_TYPE_NAME','grecord_index.RECORD_TYPE_ID','USER_POST_NAME','RECORD_HEAD_USE','LOCATION_ORG_NAME'
               ,'RECORD_LEVEL_NAME','RECORD_ORGANIZER_NAME','gleave_location.LOCATION_NAME','DATE_GO','DATE_BACK','RECORD_COMMENT','RECORD_GO_NAME','RECORD_VEHICLE_NAME','WITHDRAW_NAME'
               ,'LEADER_HR_NAME','OFFER_WORK_HR_NAME','SAVE_BACK','RECORD_USER_ID','POSITION_IN_WORK','HR_DEPARTMENT_SUB_NAME')
           ->leftJoin('hrd_person','grecord_index.RECORD_USER_ID','=','hrd_person.ID')
           ->leftJoin('hrd_department_sub','hrd_department_sub.HR_DEPARTMENT_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_ID')
           ->leftJoin('grecord_status','grecord_index.STATUS','=','grecord_status.STATUS')
           ->leftJoin('grecord_type','grecord_index.RECORD_TYPE_ID','=','grecord_type.RECORD_TYPE_ID')
           ->leftJoin('grecord_org_location','grecord_org_location.LOCATION_ID','=','grecord_index.RECORD_LOCATION_ID')
           ->leftJoin('grecord_level','grecord_level.ID','=','grecord_index.RECORD_LEVEL_ID')
           ->leftJoin('gleave_location','gleave_location.LOCATION_ID','=','grecord_index.LOCATION_PROV_ID')
           ->leftJoin('grecord_go','grecord_go.RECORD_GO_ID','=','grecord_index.RECORD_GO_ID')
           ->leftJoin('grecord_vehicle','grecord_vehicle.RECORD_VEHICLE_ID','=','grecord_index.RECORD_VEHICLE_ID')
           ->leftJoin('grecord_withdraw','grecord_withdraw.WITHDRAW_ID','=','grecord_index.RECORD_MONEY_ID')
                                               ->where(function($q) use ($search){
                                                   $q->where('grecord_index.ID','like','%'.$search.'%');
                                                   $q->orwhere('USER_POST_NAME','like','%'.$search.'%');  
                                                   $q->orwhere('RECORD_TYPE_NAME','like','%'.$search.'%');
                                                   $q->orwhere('RECORD_HEAD_USE','like','%'.$search.'%');   
                                                   $q->orwhere('HR_DEPARTMENT_SUB_NAME','like','%'.$search.'%');                                               
                                               })                                                   
                                               ->orderBy('grecord_index.ID', 'desc')    
                                               ->get();
               }else{
                   $inforrecordindex =  Recordindex::select('grecord_index.ID','grecord_index.STATUS','STATUS_NAME','RECORD_TYPE_NAME','grecord_index.RECORD_TYPE_ID','USER_POST_NAME','RECORD_HEAD_USE','LOCATION_ORG_NAME'
                   ,'RECORD_LEVEL_NAME','RECORD_ORGANIZER_NAME','gleave_location.LOCATION_NAME','DATE_GO','DATE_BACK','RECORD_COMMENT','RECORD_GO_NAME','RECORD_VEHICLE_NAME','WITHDRAW_NAME'
                   ,'LEADER_HR_NAME','OFFER_WORK_HR_NAME','SAVE_BACK','RECORD_USER_ID','POSITION_IN_WORK','HR_DEPARTMENT_SUB_NAME')
               ->leftJoin('hrd_person','grecord_index.RECORD_USER_ID','=','hrd_person.ID')
               ->leftJoin('hrd_department_sub','hrd_department_sub.HR_DEPARTMENT_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_ID')
               ->leftJoin('grecord_status','grecord_index.STATUS','=','grecord_status.STATUS')
               ->leftJoin('grecord_type','grecord_index.RECORD_TYPE_ID','=','grecord_type.RECORD_TYPE_ID')
               ->leftJoin('grecord_org_location','grecord_org_location.LOCATION_ID','=','grecord_index.RECORD_LOCATION_ID')
               ->leftJoin('grecord_level','grecord_level.ID','=','grecord_index.RECORD_LEVEL_ID')
               ->leftJoin('gleave_location','gleave_location.LOCATION_ID','=','grecord_index.LOCATION_PROV_ID')
               ->leftJoin('grecord_go','grecord_go.RECORD_GO_ID','=','grecord_index.RECORD_GO_ID')
               ->leftJoin('grecord_vehicle','grecord_vehicle.RECORD_VEHICLE_ID','=','grecord_index.RECORD_VEHICLE_ID')
               ->leftJoin('grecord_withdraw','grecord_withdraw.WITHDRAW_ID','=','grecord_index.RECORD_MONEY_ID')
                                                   ->where('ID_STATUS','=',$status)  
                                                   ->where(function($q) use ($search){
                                                       $q->where('grecord_index.ID','like','%'.$search.'%');
                                                       $q->orwhere('USER_POST_NAME','like','%'.$search.'%');  
                                                       $q->orwhere('RECORD_TYPE_NAME','like','%'.$search.'%');
                                                       $q->orwhere('RECORD_HEAD_USE','like','%'.$search.'%');       
                                                       $q->orwhere('HR_DEPARTMENT_SUB_NAME','like','%'.$search.'%');                                                                                         
                                                   })                                                   
                                                   ->orderBy('grecord_index.ID', 'desc')    
                                                   ->get();                       
               }        
            }
             $grecordstatus = DB::table('grecord_status')->get();
             
             $year_id = $yearbudget;

             $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
 
   
           return view('person_develop.personinfodevapp',[ 
            'inforpersonuser' => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid,
            'inforrecordindexs'=> $inforrecordindex,
            'grecordstatuss' => $grecordstatus,
            'displaydate_bigen'=> $displaydate_bigen, 
            'displaydate_end'=> $displaydate_end,
            'status_check' => $status,
            'search' => $search,
            'budgets' =>  $budget,
            'year_id'=>$year_id     
              
           ]);
          
}
public function appove(Request $request,$id,$iduser)
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

    $inforecord=  Recordindex::leftJoin('grecord_org_location','grecord_org_location.LOCATION_ID','=','grecord_index.RECORD_LOCATION_ID')
        ->leftJoin('grecord_level','grecord_level.ID','=','grecord_index.RECORD_LEVEL_ID')
        ->leftJoin('gleave_location','gleave_location.LOCATION_ID','=','grecord_index.LOCATION_PROV_ID')
        ->leftJoin('grecord_go','grecord_go.RECORD_GO_ID','=','grecord_index.RECORD_GO_ID')
        ->leftJoin('grecord_vehicle','grecord_vehicle.RECORD_VEHICLE_ID','=','grecord_index.RECORD_VEHICLE_ID')
        ->leftJoin('grecord_withdraw','grecord_withdraw.WITHDRAW_ID','=','grecord_index.RECORD_MONEY_ID')
        ->where('grecord_index.ID','=',$id)
        ->first();


    return view('person_develop.personinfodevapp_check',[
        'inforpersonuser' => $inforpersonuser,
        'inforpersonuserid' => $inforpersonuserid, 
        'inforecord' => $inforecord,
        'inforecordid' => $id
    ]);
}

public function updateapp(Request $request)
    {
    //$email = Auth::user()->email;
    //return $request->all();
    $id = $request->ID; 

    $check =  $request->SUBMIT; 

    if($check == 'approved'){
      $statuscode = 'SUCCESS';
    }else{
      $statuscode = 'NOTALLOW';
    }

      $updateapp = Recordindex::find($id);
      $updateapp->APPROVE_COMMENT = $request->APPROVE_COMMENT;
      $updateapp->STATUS = $statuscode; 

    
    //-----------------------------------------------------

     // dd($id);
  
      $updateapp->save();
      
          //
          //return redirect()->action('OtherController@infouserother'); 
          return redirect()->route('perdev.inforapp',['iduser'=>  $request->PERSON_ID]);

}


public static function checkver($id_user)
{
     $count =  Permislist::where('PERSON_ID','=',$id_user)
                           ->where('PERMIS_ID','=','GRE001')
                           ->count();   
    
     return $count;
}

public static function checkapp($id_user)
{
     $count =  Permislist::where('PERSON_ID','=',$id_user)
                           ->where('PERMIS_ID','=','GRE002')
                           ->count();   
    
     return $count;
}


public static function countver($id_user)
{
     $count =  Recordindex::where('STATUS','=','APPLY')  
                                ->count();      
     return $count;
}

public static function countapp($id_user)
{
     $count =  Recordindex::where('LEADER_HR_ID','=',$id_user)
                                ->where('STATUS','=','RECEIVE')  
                                ->count();      
     return $count;
}

//================================รายงานสรุปหลังจากอบรม========
public function conclude(Request $request,$id,$iduser)
    {
        //$email = Auth::user()->email;
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

        $location =  DB::table('grecord_org_location')->get();
        $org = DB::table('grecord_org')->get();
        $province =  DB::table('hrd_province')->get();
        $type_location =  DB::table('gleave_location')->get();
        $type =  DB::table('grecord_type')->get();
        $day_type =  DB::table('gleave_day_type')->get();
        $go =  DB::table('grecord_go')->get();
        $level =  DB::table('grecord_level')->get();
        $vehicle =  DB::table('grecord_vehicle')->get();
        $capacity =  DB::table('grecord_capacity')->get();
        $branch =  DB::table('grecord_branch')->get();
        $moneyset =  DB::table('grecord_money_set')->get();   
        $infoprovince =  DB::table('hrd_province')->get();
        
        $department = $inforpersonuser -> HR_DEPARTMENT_SUB_ID; 
        $LEAVEWORK_SEND =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->where('HR_STATUS_ID','=',1)
        ->where('HR_DEPARTMENT_SUB_ID','=',$department)->get();

        $leader_all =  DB::table('gleave_leader')->get();
        $withdraw =  DB::table('grecord_withdraw')->get(); //ตารางสร้างขึ้นใหม่
     
        $PERSONALL =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->where('HR_STATUS_ID','=',1)
        ->get();
        
        $infoconclude=  DB::table('grecord_index')
                        ->leftJoin('grecord_type','grecord_type.RECORD_TYPE_ID','=','grecord_index.RECORD_TYPE_ID')
                        ->leftJoin('grecord_org_location','grecord_org_location.LOCATION_ID','=','grecord_index.RECORD_LOCATION_ID')
                        ->leftJoin('grecord_withdraw','grecord_withdraw.WITHDRAW_ID','=','grecord_index.RECORD_MONEY_ID')
                        ->where('grecord_index.ID','=',$id)
                        ->first();

        $summonney = DB::table('grecord_index_money')->where('RECORD_ID','=',$id)->sum('SUMMONEY');
            
        $infoconcludeperson=  DB::table('grecord_index_person')
        ->where('RECORD_ID','=',$id)
        ->get();

        $infoconcludemoney=  DB::table('grecord_index_money')
        ->where('RECORD_ID','=',$id)
        ->get();

        return view('person_develop.personinfoconclude',[
            'inforpersonuser' => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid,
            'locations' => $location,
            'provinces' => $province,
            'type_locations' => $type_location,
            'types' => $type,
            'day_types' => $day_type,
            'gos' => $go,
            'levels' => $level,
            'vehicles' => $vehicle,
            'LEAVEWORK_SENDs' => $LEAVEWORK_SEND,
            'leader_alls' =>$leader_all,
            'withdraws' =>$withdraw,
            'PERSONALLs' => $PERSONALL,
            'capacitys' => $capacity,
            'branchs' => $branch,
            'infoprovinces' => $infoprovince,
            'moneysets'=> $moneyset,
            'orgs'=> $org,
            'infoconclude'=> $infoconclude,
            'summonney'=> $summonney,
            'infoconcludepersons'=>$infoconcludeperson,
            'infoconcludemoneys'=>$infoconcludemoney
            
            
        ]);
}

public function saveconclude(Request $request)
    {
        $id = $request->RECORD_ID;
        $addrecordindex = Recordindex::find($id);
        $addrecordindex->SAVE_BACK = 'True';
        $addrecordindex->save(); 

        $addrecord = new Recordback();    
        $addrecord->RECORD_ID = $request->RECORD_ID;
        $addrecord->RECORD_NAME = $request->RECORD_NAME;
        $addrecord->OWN_ID = $request->OWN_ID;
        $addrecord->OWN_NAME = $request->OWN_NAME;
        $addrecord->OWN_POSITION = $request->OWN_POSITION;
        $addrecord->OWN_DEP = $request->OWN_DEP;
        $addrecord->RECORD_TYPE_NAME = $request->RECORD_TYPE_NAME;
        $addrecord->RECORD_ORG_NAME = $request->RECORD_ORG_NAME;
        $addrecord->LOCATION_NAME = $request->LOCATION_NAME;
        $addrecord->DATE_GO = $request->DATE_GO;
        $addrecord->DATE_BACK = $request->DATE_BACK;

        if($request->WITHDRAW_ID == 2 || $request->WITHDRAW_ID == 3){
            $addrecord->MONEY_HOS = $request->MONEYSUM;
        }else{
            $addrecord->MONEY_ETC = $request->MONEYSUM;    
        }

        $addrecord->LEADER_ID = $request->LEADER_ID;
        $addrecord->LEADER_NAME = $request->LEADER_NAME;
        $addrecord->DETAIL = $request->DETAIL;
        

        $addrecord->save(); 
        //return $request->all();

        $idrecorde = Recordback::max('ID'); 

         $PERSON_ID = $request->PERSON_ID;
         $number =count($PERSON_ID);
         $count = 0;
         for($count = 0; $count < $number; $count++)
         {  
            $id_person = $PERSON_ID[$count];

            $inforpersonuser=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                                    ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
                                    ->where('hrd_person.ID','=',$id_person)->first();


            $add = new Recordbackperson();
            $add->BACK_ID = $idrecorde;
            $add->PERSON_ID = $PERSON_ID[$count];
            $add->PERSON_FULLNAME = $inforpersonuser->HR_PREFIX_NAME.''.$inforpersonuser->HR_FNAME.' '.$inforpersonuser->HR_LNAME;
            $add->PERSON_POSITION = $inforpersonuser->POSITION_IN_WORK;
            
            $add->save(); 

           
         }

       if($request->OBJECTIVE_NAME <> '' || $request->OBJECTIVE_NAME <> null){
                $OBJECTIVE_NAME = $request->OBJECTIVE_NAME;
                $number_2 =count($OBJECTIVE_NAME);
                $count_2 = 0;
                for($count_2 = 0; $count_2 < $number_2; $count_2++)
                {  
                    $add_2 = new Recordbackobjective();
                    $add_2->BACK_ID = $idrecorde;
                    $add_2->OBJECTIVE_NAME = $OBJECTIVE_NAME[$count_2];
                    $add_2->save(); 
                }
        }


        if($request->IMPORTANT_NAME <> '' || $request->IMPORTANT_NAME <> null){
                $IMPORTANT_NAME = $request->IMPORTANT_NAME;
                $number_3 =count($IMPORTANT_NAME);
                $count_3 = 0;
                for($count_3 = 0; $count_3 < $number_3; $count_3++)
                {  
                
                    $add_3 = new Recordbackimportant();
                    $add_3->BACK_ID = $idrecorde;
                    $add_3->IMPORTANT_NAME = $IMPORTANT_NAME[$count_3];
                    $add_3->save(); 

                }
        }
           

        if($request->MONEY_TYPE_ID <> '' || $request->MONEY_TYPE_ID <> null){
                $MONEY_TYPE_ID = $request->MONEY_TYPE_ID;
                $MONEY = $request->MONEY;
                $DETAILMONEY = $request->DETAILMONEY;

                $number_4 =count($MONEY_TYPE_ID);
                $count_4 = 0;
                for($count_4 = 0; $count_4 < $number_4; $count_4++)
                {  
                
                    $add_4 = new Recordbackmoney();
                    $add_4->BACK_ID = $idrecorde;
                    $add_4->MONEY_TYPE_ID = $MONEY_TYPE_ID[$count_4];
                    $add_4->MONEY = $MONEY[$count_4];
                    $add_4->DETAIL = $DETAILMONEY[$count_4];
                    $add_4->save(); 

                }
            }

    if($request->KNOWLEDGE_NAME <> '' || $request->KNOWLEDGE_NAME <> null){      
         $KNOWLEDGE_NAME = $request->KNOWLEDGE_NAME;
         $number_5 =count($KNOWLEDGE_NAME);
         $count_5 = 0;
         for($count_5 = 0; $count_5 < $number_5; $count_5++)
         {  
          
            $add_5 = new Recordbackknow();
            $add_5->BACK_ID = $idrecorde;
            $add_5->KNOWLEDGE_NAME = $KNOWLEDGE_NAME[$count_5];
            $add_5->save(); 

         } 

    }
    if($request->BENEFIT_NAME <> '' || $request->BENEFIT_NAME <> null){    
         $BENEFIT_NAME = $request->BENEFIT_NAME;
         $BENEFIT_EX = $request->BENEFIT_EX;
         $number_6 =count($BENEFIT_NAME);
         $count_6 = 0;
         for($count_6 = 0; $count_6 < $number_6; $count_6++)
         {  
          
            $add_6 = new Recordbackbenefit();
            $add_6->BACK_ID = $idrecorde;
            $add_6->BENEFIT_NAME = $BENEFIT_NAME[$count_6];
            $add_6->BENEFIT_EX = $BENEFIT_EX[$count_6];
            $add_6->save(); 

         } 

        }
         $picid = $idrecorde;
         if($request->hasFile('pdfupload')){
            $newFileName = $picid.'.'.$request->pdfupload->extension();
              
            $request->pdfupload->storeAs('conclude',$newFileName,'public');
           

            $add_7 = new Recordbackfile();
            $add_7->BACK_ID = $idrecorde;
            $add_7->FILE_NAME = $newFileName; 
            $add_7->save(); 
        }

 
        
         return redirect()->route('perdev.inforuser',['iduser'=>  $request->PERSON_ID_CREATE]);

}
//----------------------------แก้ไขสรุปรายงาน--------------------------------------------------

public function editconclude(Request $request,$id,$iduser)
    {
        //$email = Auth::user()->email;
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

        $location =  DB::table('grecord_org_location')->get();
        $org = DB::table('grecord_org')->get();
        $province =  DB::table('hrd_province')->get();
        $type_location =  DB::table('gleave_location')->get();
        $type =  DB::table('grecord_type')->get();
        $day_type =  DB::table('gleave_day_type')->get();
        $go =  DB::table('grecord_go')->get();
        $level =  DB::table('grecord_level')->get();
        $vehicle =  DB::table('grecord_vehicle')->get();
        $capacity =  DB::table('grecord_capacity')->get();
        $branch =  DB::table('grecord_branch')->get();
        $moneyset =  DB::table('grecord_money_set')->get();   
        $infoprovince =  DB::table('hrd_province')->get();
        
        $department = $inforpersonuser -> HR_DEPARTMENT_SUB_ID; 
        $LEAVEWORK_SEND =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->where('HR_STATUS_ID','=',1)
        ->where('HR_DEPARTMENT_SUB_ID','=',$department)->get();

        $leader_all =  DB::table('gleave_leader')->get();
        $withdraw =  DB::table('grecord_withdraw')->get(); //ตารางสร้างขึ้นใหม่
     
        $PERSONALL =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->where('HR_STATUS_ID','=',1)
        ->get();
        
        $infoconclude=  DB::table('grecord_index')
                        ->leftJoin('grecord_type','grecord_type.RECORD_TYPE_ID','=','grecord_index.RECORD_TYPE_ID')
                        ->leftJoin('grecord_org_location','grecord_org_location.LOCATION_ID','=','grecord_index.RECORD_LOCATION_ID')
                        ->leftJoin('grecord_withdraw','grecord_withdraw.WITHDRAW_ID','=','grecord_index.RECORD_MONEY_ID')
                        ->where('grecord_index.ID','=',$id)
                        ->first();
    

        $idbackget=DB::table('grecord_back')->where('RECORD_ID','=',$id)->first();
        $idback = $idbackget->ID;
        //dd($idback);
        
       
            
        $infoconcludeperson=  DB::table('grecord_back_person')
        ->where('BACK_ID','=',$idback)
        ->get();

        $infoconcludeobj=  DB::table('grecord_back_objective')
        ->where('BACK_ID','=',$idback)
        ->get();

        $infoconcludeimp=  DB::table('grecord_back_important')
        ->where('BACK_ID','=',$idback)
        ->get();

        
        $summonney = DB::table('grecord_back_money')->where('BACK_ID','=',$idback)->sum('MONEY');
        $infoconcludemoney=  DB::table('grecord_back_money')
        ->where('BACK_ID','=',$idback)
        ->get();

        $infobackget=DB::table('grecord_back')->where('ID','=',$idback)->first();

        $infoconcludeknow=  DB::table('grecord_back_knowledge')
        ->where('BACK_ID','=',$idback)
        ->get();

        $infoconcludeben=  DB::table('grecord_back_benefit')
        ->where('BACK_ID','=',$idback)
        ->get();

    


        return view('person_develop.personinfoconclude_edit',[
            'inforpersonuser' => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid,
            'locations' => $location,
            'provinces' => $province,
            'type_locations' => $type_location,
            'types' => $type,
            'day_types' => $day_type,
            'gos' => $go,
            'levels' => $level,
            'vehicles' => $vehicle,
            'LEAVEWORK_SENDs' => $LEAVEWORK_SEND,
            'leader_alls' =>$leader_all,
            'withdraws' =>$withdraw,
            'PERSONALLs' => $PERSONALL,
            'capacitys' => $capacity,
            'branchs' => $branch,
            'infoprovinces' => $infoprovince,
            'moneysets'=> $moneyset,
            'orgs'=> $org,
            'infoconclude'=> $infoconclude,
            'summonney'=> $summonney,
            'infoconcludepersons'=>$infoconcludeperson,
            'infoconcludeobjs'=>$infoconcludeobj,
            'infoconcludeimps'=>$infoconcludeimp,
            'infobackget'=>$infobackget,
            'infoconcludeknows'=>$infoconcludeknow,
            'infoconcludebens'=>$infoconcludeben,
            'idback'=>$idback,

            'infoconcludemoneys'=>$infoconcludemoney
            
            
        ]);
}

    
public function updateconclude(Request $request)
    {
        
        $idrecorde = $request->ID_BACK; 
        $addrecord = Recordback::find($idrecorde);  
   
        if($request->WITHDRAW_ID == 2 || $request->WITHDRAW_ID == 3){
            $addrecord->MONEY_HOS = $request->MONEYSUM;
        }else{
            $addrecord->MONEY_ETC = $request->MONEYSUM;    
        }
        $addrecord->DETAIL = $request->DETAIL;
        $addrecord->save(); 
        //return $request->all();

        
         Recordbackperson::where('BACK_ID','=',$idrecorde)->delete();     
         $PERSON_ID = $request->PERSON_ID;
         $number =count($PERSON_ID);
         $count = 0;
         for($count = 0; $count < $number; $count++)
         {  
            $id_person = $PERSON_ID[$count];

            $inforpersonuser=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                                    ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
                                    ->where('hrd_person.ID','=',$id_person)->first();


            $add = new Recordbackperson();
            $add->BACK_ID = $idrecorde;
            $add->PERSON_ID = $PERSON_ID[$count];
            $add->PERSON_FULLNAME = $inforpersonuser->HR_PREFIX_NAME.''.$inforpersonuser->HR_FNAME.' '.$inforpersonuser->HR_LNAME;
            $add->PERSON_POSITION = $inforpersonuser->POSITION_IN_WORK;
            
            $add->save(); 

           
         }

         Recordbackobjective::where('BACK_ID','=',$idrecorde)->delete(); 

         if($request->OBJECTIVE_NAME <> '' || $request->OBJECTIVE_NAME <> null){
            $OBJECTIVE_NAME = $request->OBJECTIVE_NAME;
            $number_2 =count($OBJECTIVE_NAME);
            $count_2 = 0;
            for($count_2 = 0; $count_2 < $number_2; $count_2++)
            {  
            
                $add_2 = new Recordbackobjective();
                $add_2->BACK_ID = $idrecorde;
                $add_2->OBJECTIVE_NAME = $OBJECTIVE_NAME[$count_2];
                $add_2->save(); 

            }
         }

         Recordbackimportant::where('BACK_ID','=',$idrecorde)->delete(); 
         if($request->IMPORTANT_NAME <> '' || $request->IMPORTANT_NAME <> null){
            $IMPORTANT_NAME = $request->IMPORTANT_NAME;
            $number_3 =count($IMPORTANT_NAME);
            $count_3 = 0;
            for($count_3 = 0; $count_3 < $number_3; $count_3++)
            {  
            
                $add_3 = new Recordbackimportant();
                $add_3->BACK_ID = $idrecorde;
                $add_3->IMPORTANT_NAME = $IMPORTANT_NAME[$count_3];
                $add_3->save(); 

            }
         }   

         Recordbackmoney::where('BACK_ID','=',$idrecorde)->delete(); 
         if($request->MONEY_TYPE_ID <> '' || $request->MONEY_TYPE_ID <> null){
            $MONEY_TYPE_ID = $request->MONEY_TYPE_ID;
            $MONEY = $request->MONEY;
            $DETAILMONEY = $request->DETAILMONEY;

            $number_4 =count($MONEY_TYPE_ID);
            $count_4 = 0;
            for($count_4 = 0; $count_4 < $number_4; $count_4++)
            {  
            
                $add_4 = new Recordbackmoney();
                $add_4->BACK_ID = $idrecorde;
                $add_4->MONEY_TYPE_ID = $MONEY_TYPE_ID[$count_4];
                $add_4->MONEY = $MONEY[$count_4];
                $add_4->DETAIL = $DETAILMONEY[$count_4];
                $add_4->save(); 

            }
         }

         Recordbackknow::where('BACK_ID','=',$idrecorde)->delete();
         if($request->KNOWLEDGE_NAME <> '' || $request->KNOWLEDGE_NAME <> null){  
            $KNOWLEDGE_NAME = $request->KNOWLEDGE_NAME;
            $number_5 =count($KNOWLEDGE_NAME);
            $count_5 = 0;
            for($count_5 = 0; $count_5 < $number_5; $count_5++)
            {  
            
                $add_5 = new Recordbackknow();
                $add_5->BACK_ID = $idrecorde;
                $add_5->KNOWLEDGE_NAME = $KNOWLEDGE_NAME[$count_5];
                $add_5->save(); 

            } 
         }

         Recordbackbenefit::where('BACK_ID','=',$idrecorde)->delete(); 
         if($request->BENEFIT_NAME <> '' || $request->BENEFIT_NAME <> null){   
            $BENEFIT_NAME = $request->BENEFIT_NAME;
            $BENEFIT_EX = $request->BENEFIT_EX;
            $number_6 =count($BENEFIT_NAME);
            $count_6 = 0;
            for($count_6 = 0; $count_6 < $number_6; $count_6++)
            {  
            
                $add_6 = new Recordbackbenefit();
                $add_6->BACK_ID = $idrecorde;
                $add_6->BENEFIT_NAME = $BENEFIT_NAME[$count_6];
                $add_6->BENEFIT_EX = $BENEFIT_EX[$count_6];
                $add_6->save(); 

            } 

         }


         $picid = $idrecorde;
         if($request->hasFile('pdfupload')){
             
            $newFileName = $picid.'.'.$request->pdfupload->extension();
              
            $request->pdfupload->storeAs('conclude',$newFileName,'public');
           
            Recordbackfile::where('BACK_ID','=',$idrecorde)->delete();    
            $add_7 = new Recordbackfile();
            $add_7->BACK_ID = $idrecorde;
            $add_7->FILE_NAME = $newFileName; 
            $add_7->save(); 
        }

 
        
         return redirect()->route('perdev.inforuser',['iduser'=>  $request->PERSON_ID_CREATE]);

}

public function pdfout01()
{
    $pdf = PDF::loadView('person_develop.pdfout01');
    return @$pdf->stream();
}
public function pdfout02()
{
    $pdf = PDF::loadView('person_develop.pdfout02');
    return @$pdf->stream();
}
public function pdfout03()
{
    $pdf = PDF::loadView('person_develop.pdfout03');
    return @$pdf->stream();
}



public function persondevpdfgovernment_outside(Request $request,$id,$iduser)
{

    $infoorg = DB::table('info_org')
    ->leftjoin('hrd_person','info_org.ORG_LEADER_ID','=','hrd_person.ID')
    ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->where('ORG_ID','=',1)->first();

    $infopredev = DB::table('grecord_index')
    ->select('grecord_index.created_at','RECORD_HEAD_USE','LOCATION_ORG_NAME','hrd_province.PROVINCE_NAME','DISTANCE','DATE_GO','DATE_BACK','DATE_TRAVEL_GO','FROM_TIME','DATE_TRAVEL_BACK','BACK_TIME','RECORD_VEHICLE_ID','CAR_REG','OFFER_WORK_HR_NAME','USER_POST_NAME','POSITION_IN_WORK','HR_LEVEL_NAME','OFFER_WORK_HR_NAME','STATUS','DR_PROVINCE_USE')
    ->leftjoin('hrd_person','grecord_index.RECORD_USER_ID','=','hrd_person.ID')
    ->leftjoin('hrd_level','hrd_level.HR_LEVEL_ID','=','hrd_person.HR_LEVEL_ID')
    ->leftjoin('grecord_org','grecord_index.RECORD_ORG_ID','=','grecord_org.RECORD_ORG_ID')
    ->leftjoin('hrd_province','hrd_province.ID','=','grecord_index.PROVINCE_ID')
    ->leftJoin('grecord_org_location','grecord_org_location.LOCATION_ID','=','grecord_index.RECORD_LOCATION_ID')
    ->where('grecord_index.ID','=',$id)->first();

    
    $index_person = DB::table('grecord_index_person')->where('RECORD_ID','=',$id)->get();

    $check = DB::table('grecord_index_person')->where('RECORD_ID','=',$id)->count();
    $inforesive = DB::table('grecord_index')
    ->leftjoin('hrd_person','grecord_index.RECEIVE_BY_ID','=','hrd_person.ID')
    ->where('grecord_index.ID','=',$id)->first();

    $infooffer = DB::table('grecord_index')
    ->leftjoin('hrd_person','grecord_index.OFFER_WORK_HR_ID','=','hrd_person.ID')
    ->leftjoin('hrd_level','hrd_level.HR_LEVEL_ID','=','hrd_person.HR_LEVEL_ID')
    ->where('grecord_index.ID','=',$id)->first();

    $indexpersonwork = DB::table('grecord_index')
    ->leftjoin('hrd_person','grecord_index.OFFER_WORK_HR_ID','=','hrd_person.ID')
    ->where('grecord_index.ID','=',$id)->first();

    $hrddepartment = DB::table('hrd_department')->where('HR_DEPARTMENT_ID','=',1)->first();
  
        $html =  view('person_develop.persondevpdfgovernment_outside',[
            'id'=>$id,
            'hrddepartment'=>$hrddepartment,
            'infoorg'=>$infoorg,
            'infopredev'=>$infopredev,
            'indexpersonwork'=>$indexpersonwork,
            'inforesive'=>$inforesive,
            'infooffer'=>$infooffer,
            'check'=>$check,
            'index_persons'=>$index_person
        ]);
        return viewPdf($html);

    // $pdf = PDF::loadView('person_develop.persondevpdfgovernment_outside',[
        // 'id'=>$id,
        // 'infoorg'=>$infoorg,
        // 'infopredev'=>$infopredev,
        // 'indexpersonwork'=>$indexpersonwork,
        // 'inforesive'=>$inforesive,
        // 'infooffer'=>$infooffer,
        // 'check'=>$check,
        // 'index_persons'=>$index_person
    // ]);
    // return @$pdf->stream();
}


 




public function persondevaccept(Request $request,$id,$iduser)
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


        $inforrecordindex =  Recordindex::select('grecord_index.ID','grecord_index.STATUS','STATUS_NAME','RECORD_TYPE_NAME','grecord_index.RECORD_TYPE_ID','USER_POST_NAME','RECORD_HEAD_USE','LOCATION_ORG_NAME'
        ,'RECORD_LEVEL_NAME','RECORD_ORGANIZER_NAME','gleave_location.LOCATION_NAME','DATE_GO','DATE_BACK','RECORD_COMMENT','RECORD_GO_NAME','RECORD_VEHICLE_NAME','WITHDRAW_NAME'
        ,'LEADER_HR_NAME','OFFER_WORK_HR_NAME','SAVE_BACK','RECORD_EXPERT_RESULT','RECORD_EXPERT_REMARK')
                    ->leftJoin('grecord_status','grecord_index.STATUS','=','grecord_status.STATUS')
                    ->leftJoin('grecord_type','grecord_index.RECORD_TYPE_ID','=','grecord_type.RECORD_TYPE_ID')
                    ->leftJoin('grecord_index_person','grecord_index.ID','=','grecord_index_person.RECORD_ID')
                    ->leftJoin('grecord_org_location','grecord_org_location.LOCATION_ID','=','grecord_index.RECORD_LOCATION_ID')
                    ->leftJoin('grecord_level','grecord_level.ID','=','grecord_index.RECORD_LEVEL_ID')
                    ->leftJoin('gleave_location','gleave_location.LOCATION_ID','=','grecord_index.LOCATION_PROV_ID')
                    ->leftJoin('grecord_go','grecord_go.RECORD_GO_ID','=','grecord_index.RECORD_GO_ID')
                    ->leftJoin('grecord_vehicle','grecord_vehicle.RECORD_VEHICLE_ID','=','grecord_index.RECORD_VEHICLE_ID')
                    ->leftJoin('grecord_withdraw','grecord_withdraw.WITHDRAW_ID','=','grecord_index.RECORD_MONEY_ID')
                    ->where('grecord_index.ID','=',$id)
                    ->first();


        return view('person_develop.persondevaccept',[
            'inforpersonuser'=>$inforpersonuser, 
            'inforpersonuserid'=>$inforpersonuserid, 
            'inforrecordindex'=>$inforrecordindex, 
        ]); 
       
    }


    public function persondevaccept_update(Request $request)
    {
        $id =  $request->ID;
    
        $updateacc = Recordindex::find($id);
        $updateacc->RECORD_EXPERT_RESULT = $request->RECORD_EXPERT_RESULT;
        $updateacc->RECORD_EXPERT_REMARK = $request->RECORD_EXPERT_REMARK;
        $updateacc->save();
 
        
         return redirect()->route('perdev.inforuser',['iduser'=>  $request->iduser]);

    }


            public function persondevpdfallow($id,$iduser)
            {
                $infoorg = DB::table('info_org')->where('ORG_ID','=',1)
                ->leftJoin('hrd_person','hrd_person.ID','=','info_org.ORG_LEADER_ID')
                ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                ->first();

                $hrddepartment = DB::table('hrd_department')->where('HR_DEPARTMENT_ID','=',1)->first();

                $grecord_index = DB::table('grecord_index')
                ->leftJoin('hrd_person','hrd_person.ID','=','grecord_index.RECORD_USER_ID')
                ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
                ->leftJoin('grecord_org_location','grecord_index.RECORD_LOCATION_ID','=','grecord_org_location.LOCATION_ID')
                ->where('grecord_index.ID','=',$id)->first();

                $pdf = PDF::loadView('person_develop.persondevpdfallow',[
                    'infoorg' => $infoorg,
                    'hrddepartment' => $hrddepartment,
                    'grecord_index' => $grecord_index,
                ]);
                return @$pdf->stream();
            }

            public function persondevpdfaccept($id,$iduser)
            {
                $infoorg = DB::table('info_org')->where('ORG_ID','=',1)
                ->leftJoin('hrd_person','hrd_person.ID','=','info_org.ORG_LEADER_ID')
                ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                ->first();

                $grecord_index = DB::table('grecord_index')
                ->leftJoin('hrd_person','hrd_person.ID','=','grecord_index.RECORD_USER_ID')
                ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
                ->leftJoin('grecord_org_location','grecord_index.RECORD_LOCATION_ID','=','grecord_org_location.LOCATION_ID')
                ->where('grecord_index.ID','=',$id)->first();

                $grecord_book = DB::table('grecord_index')->where('grecord_index.ID','=',$id)->first();

                $infopredev = DB::table('grecord_index')
                ->leftjoin('hrd_person','grecord_index.RECORD_USER_ID','=','hrd_person.ID')
                ->leftjoin('hrd_level','hrd_level.HR_LEVEL_ID','=','hrd_person.HR_LEVEL_ID')
                ->leftjoin('grecord_org','grecord_index.RECORD_ORG_ID','=','grecord_org.RECORD_ORG_ID')
                ->where('grecord_index.ID','=',$id)->first();

                $pdf = PDF::loadView('person_develop.persondevpdfaccept',[
                    'infoorg' => $infoorg,
                    'grecord_index' => $grecord_index,
                    'grecord_book' => $grecord_book,
                    'infopredev' => $infopredev,
                ]);
                return @$pdf->stream();
            }


}

