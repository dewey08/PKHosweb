<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Person;
use App\Models\Leave_register;
use App\Models\Budgetyear;
use App\Models\LeaveLeader;
use App\Models\Permislist;
use App\Models\LeaveStatus;

use Illuminate\Support\Facades\Auth;

class LeaveController extends Controller
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

        
        $inforleave=  Leave_register::where('LEAVE_PERSON_ID','=',$iduser)
                        ->orderBy('gleave_register.ID', 'desc')
                        ->get();

                      

        return view('person_leave.personinfoleaveindex',[
            'inforpersonuser' => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid,
            'inforleaves' => $inforleave,
            
        ]);
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


        $inforleave=  Leave_register::leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_ID')
        ->leftJoin('gleave_status','gleave_register.LEAVE_STATUS_CODE','=','gleave_status.STATUS_CODE')
        ->leftJoin('gleave_location','gleave_register.LOCATION_ID','=','gleave_location.LOCATION_ID')
        ->where('LEAVE_PERSON_ID','=',$iduser)
        ->WhereBetween('LEAVE_DATE_BEGIN',[$from,$to])
        ->orderBy('gleave_register.ID', 'desc')
        ->get();

        $infostatus =  LeaveStatus::get();   

        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;
        }
        
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $status = '';
        $search = '';
        $year_id = $yearbudget;

        return view('person_leave.personinfoleaveinfo',[
            'inforpersonuser' => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid,
            'inforleaves' => $inforleave,
            'infostatuss' => $infostatus,
            'displaydate_bigen'=> $displaydate_bigen, 
            'displaydate_end'=> $displaydate_end,
            'status_check' => $status,
            'search' => $search,
            'budgets' =>  $budget,
            'year_id'=>$year_id 
        ]);
    }

    public function excel_personleaveinfo(Request $request,$iduser)
    {
        $search = $request->get('search');
        $status = $request->STATUS_CODE;
        $datebigin = $request->get('DATE_BIGIN');
        $dateend = $request->get('DATE_END');
        $yearbudget = $request->BUDGET_YEAR;

        if($search==''){
            $search="";
        }

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
                $inforleave=  Leave_register::leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_ID')
                ->leftJoin('gleave_status','gleave_register.LEAVE_STATUS_CODE','=','gleave_status.STATUS_CODE')
                ->leftJoin('gleave_location','gleave_register.LOCATION_ID','=','gleave_location.LOCATION_ID')
                ->where('LEAVE_PERSON_ID','=',$iduser)
                ->where(function($q) use ($search){
                            $q->where('LEAVE_YEAR_ID','like','%'.$search.'%');
                            $q->orwhere('LEAVE_TYPE_NAME','like','%'.$search.'%');
                            $q->orwhere('LEAVE_BECAUSE','like','%'.$search.'%');

                })
                ->WhereBetween('LEAVE_DATE_BEGIN',[$from,$to])
                ->orderBy('gleave_register.ID', 'desc')
                ->get();
            }else{
                $inforleave=  Leave_register::leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_ID')
                    ->leftJoin('gleave_status','gleave_register.LEAVE_STATUS_CODE','=','gleave_status.STATUS_CODE')
                    ->leftJoin('gleave_location','gleave_register.LOCATION_ID','=','gleave_location.LOCATION_ID')
                    ->where('LEAVE_PERSON_ID','=',$iduser)
                    ->where('LEAVE_STATUS_CODE','=',$status)
                    ->where(function($q) use ($search){
                                $q->where('LEAVE_YEAR_ID','like','%'.$search.'%');
                                $q->orwhere('LEAVE_TYPE_NAME','like','%'.$search.'%');
                                $q->orwhere('LEAVE_BECAUSE','like','%'.$search.'%');

                    })
                    ->WhereBetween('LEAVE_DATE_BEGIN',[$from,$to])
                    ->orderBy('gleave_register.ID', 'desc')
                    ->get();

            }

         }else{

            if($status == null){
                $inforleave=  Leave_register::leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_ID')
            ->leftJoin('gleave_status','gleave_register.LEAVE_STATUS_CODE','=','gleave_status.STATUS_CODE')
            ->leftJoin('gleave_location','gleave_register.LOCATION_ID','=','gleave_location.LOCATION_ID')
            ->where('LEAVE_PERSON_ID','=',$iduser)
            ->where(function($q) use ($search){
                $q->where('LEAVE_YEAR_ID','like','%'.$search.'%');
                $q->orwhere('LEAVE_TYPE_NAME','like','%'.$search.'%');
                $q->orwhere('LEAVE_BECAUSE','like','%'.$search.'%');
            })
            ->orderBy('gleave_register.ID', 'desc')
            ->get();

            }else{
                $inforleave=  Leave_register::leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_ID')
            ->leftJoin('gleave_status','gleave_register.LEAVE_STATUS_CODE','=','gleave_status.STATUS_CODE')
            ->leftJoin('gleave_location','gleave_register.LOCATION_ID','=','gleave_location.LOCATION_ID')
            ->where('LEAVE_PERSON_ID','=',$iduser)
            ->where('LEAVE_STATUS_CODE','=',$status)
            ->where(function($q) use ($search){
                $q->where('LEAVE_YEAR_ID','like','%'.$search.'%');
                $q->orwhere('LEAVE_TYPE_NAME','like','%'.$search.'%');
                $q->orwhere('LEAVE_BECAUSE','like','%'.$search.'%');
            })
            ->orderBy('gleave_register.ID', 'desc')
            ->get();

            }
        }

        $year_id = $yearbudget;

         $infostatus =  LeaveStatus::get();
         $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        return view('person_leave.excel_personleaveinfo',[
            'inforpersonuser' => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid,
            'inforleaves' => $inforleave,
            'infostatuss' => $infostatus,
            'status_check' => $status,
            'search' => $search,
            'year_id'=>$year_id, 
            'budgets' =>  $budget,
        ]);
    }

    public function search(Request $request,$iduser)
    {
        $search = $request->get('search');
        $status = $request->STATUS_CODE;
        $datebigin = $request->get('DATE_BIGIN');
        $dateend = $request->get('DATE_END');
        $yearbudget = $request->BUDGET_YEAR;

        if($search==''){
            $search="";
        }

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
                $inforleave=  Leave_register::leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_ID')
                ->leftJoin('gleave_status','gleave_register.LEAVE_STATUS_CODE','=','gleave_status.STATUS_CODE')
                ->leftJoin('gleave_location','gleave_register.LOCATION_ID','=','gleave_location.LOCATION_ID')
                ->where('LEAVE_PERSON_ID','=',$iduser)
                ->where(function($q) use ($search){
                            $q->where('LEAVE_YEAR_ID','like','%'.$search.'%');
                            $q->orwhere('LEAVE_TYPE_NAME','like','%'.$search.'%');
                            $q->orwhere('LEAVE_BECAUSE','like','%'.$search.'%');

                })
                ->WhereBetween('LEAVE_DATE_BEGIN',[$from,$to])
                ->orderBy('gleave_register.ID', 'desc')
                ->get();
            }else{
                $inforleave=  Leave_register::leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_ID')
                    ->leftJoin('gleave_status','gleave_register.LEAVE_STATUS_CODE','=','gleave_status.STATUS_CODE')
                    ->leftJoin('gleave_location','gleave_register.LOCATION_ID','=','gleave_location.LOCATION_ID')
                    ->where('LEAVE_PERSON_ID','=',$iduser)
                    ->where('LEAVE_STATUS_CODE','=',$status)
                    ->where(function($q) use ($search){
                                $q->where('LEAVE_YEAR_ID','like','%'.$search.'%');
                                $q->orwhere('LEAVE_TYPE_NAME','like','%'.$search.'%');
                                $q->orwhere('LEAVE_BECAUSE','like','%'.$search.'%');

                    })
                    ->WhereBetween('LEAVE_DATE_BEGIN',[$from,$to])
                    ->orderBy('gleave_register.ID', 'desc')
                    ->get();

            }

         }else{

            if($status == null){
                $inforleave=  Leave_register::leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_ID')
            ->leftJoin('gleave_status','gleave_register.LEAVE_STATUS_CODE','=','gleave_status.STATUS_CODE')
            ->leftJoin('gleave_location','gleave_register.LOCATION_ID','=','gleave_location.LOCATION_ID')
            ->where('LEAVE_PERSON_ID','=',$iduser)
            ->where(function($q) use ($search){
                $q->where('LEAVE_YEAR_ID','like','%'.$search.'%');
                $q->orwhere('LEAVE_TYPE_NAME','like','%'.$search.'%');
                $q->orwhere('LEAVE_BECAUSE','like','%'.$search.'%');
            })
            ->orderBy('gleave_register.ID', 'desc')
            ->get();

            }else{
                $inforleave=  Leave_register::leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_ID')
            ->leftJoin('gleave_status','gleave_register.LEAVE_STATUS_CODE','=','gleave_status.STATUS_CODE')
            ->leftJoin('gleave_location','gleave_register.LOCATION_ID','=','gleave_location.LOCATION_ID')
            ->where('LEAVE_PERSON_ID','=',$iduser)
            ->where('LEAVE_STATUS_CODE','=',$status)
            ->where(function($q) use ($search){
                $q->where('LEAVE_YEAR_ID','like','%'.$search.'%');
                $q->orwhere('LEAVE_TYPE_NAME','like','%'.$search.'%');
                $q->orwhere('LEAVE_BECAUSE','like','%'.$search.'%');
            })
            ->orderBy('gleave_register.ID', 'desc')
            ->get();

            }
        }

        $year_id = $yearbudget;

         $infostatus =  LeaveStatus::get();
         $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        return view('person_leave.personinfoleaveinfo',[
            'inforpersonuser' => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid,
            'inforleaves' => $inforleave,
            'infostatuss' => $infostatus,
            'displaydate_bigen'=> $displaydate_bigen, 
            'displaydate_end'=> $displaydate_end,
            'status_check' => $status,
            'search' => $search,
            'year_id'=>$year_id, 
            'budgets' =>  $budget,
        ]);



    }
//--------------------------------------------------------------

    public function infoapp(Request $request,$iduser)
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

        $inforleave=  Leave_register::select('ID','LEAVE_BECAUSE','WORK_DO','LEAVE_DATE_END','LEAVE_DATE_BEGIN','LEAVE_WORK_SEND','LEAVE_CONTACT_PHONE','LOCATION_NAME','LEAVE_TYPE_NAME','LEAVE_PERSON_FULLNAME','LEAVE_YEAR_ID','STATUS_NAME','STATUS_CODE','gleave_register.created_at','LEAVE_CONTACT','LEAVE_SUM_ALL','WORK_DO','LEAVE_SUM_HOLIDAY','LEAVE_SUM_SETSUN','LEAVE_COMMENT_BY','DAY_TYPE_ID','LEAVE_APP_H1','LEAVE_APP_H2','LEAVE_APP_SEND')
        ->leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_ID')
        ->leftJoin('gleave_status','gleave_register.LEAVE_STATUS_CODE','=','gleave_status.STATUS_CODE')
        ->leftJoin('gleave_location','gleave_register.LOCATION_ID','=','gleave_location.LOCATION_ID')
        ->where('LEADER_PERSON_ID','=',$iduser)
        ->where(function($q){
            $q->where('LEAVE_STATUS_CODE','=','Pending');

        })
       
        ->orderBy('gleave_register.ID', 'desc')
        ->get();

        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;
        }

        $infostatus =  LeaveStatus::get();
    

        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';
        $status = 'Pending';
        $search = '';
        $year_id = $yearbudget;

        return view('person_leave.personinfoleaveapp',[
            'inforpersonuser' => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid,
            'inforleaves' => $inforleave,
            'infostatuss'=>$infostatus,
            'displaydate_bigen'=> $displaydate_bigen, 
            'displaydate_end'=> $displaydate_end,
            'status_check' => $status,
            'search' => $search,    
            'budgets' =>  $budget,
            'year_id'=>$year_id 
        ]);
    }


    public function searchapp(Request $request,$iduser)
    {
        $search = $request->get('search');
        $status = $request->STATUS_CODE;
        $datebigin = $request->get('DATE_BIGIN');
        $dateend = $request->get('DATE_END');
        $yearbudget = $request->BUDGET_YEAR;

        if($search==''){
            $search="";
        }

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
      
        $inforleave=  Leave_register::select('ID','LEAVE_BECAUSE','WORK_DO','LEAVE_DATE_END','LEAVE_DATE_BEGIN','LEAVE_WORK_SEND','LEAVE_CONTACT_PHONE','LOCATION_NAME','LEAVE_TYPE_NAME','LEAVE_PERSON_FULLNAME','LEAVE_YEAR_ID','STATUS_NAME','STATUS_CODE','gleave_register.created_at','LEAVE_CONTACT','LEAVE_SUM_ALL','WORK_DO','LEAVE_SUM_HOLIDAY','LEAVE_SUM_SETSUN','LEAVE_COMMENT_BY','DAY_TYPE_ID','LEAVE_APP_H1','LEAVE_APP_H2')
        ->leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_ID')
        ->leftJoin('gleave_status','gleave_register.LEAVE_STATUS_CODE','=','gleave_status.STATUS_CODE')
        ->leftJoin('gleave_location','gleave_register.LOCATION_ID','=','gleave_location.LOCATION_ID')
        ->where('LEADER_PERSON_ID','=',$iduser)
        ->where(function($q) use ($search){
            $q->where('LEAVE_YEAR_ID','like','%'.$search.'%');
            $q->orwhere('LEAVE_PERSON_FULLNAME','like','%'.$search.'%');
            $q->orwhere('LEAVE_TYPE_NAME','like','%'.$search.'%');
            $q->orwhere('LEAVE_BECAUSE','like','%'.$search.'%');

        })
        ->WhereBetween('LEAVE_DATE_BEGIN',[$from,$to])
        ->orderBy('gleave_register.ID', 'desc')
        ->get();

    }else{

        if($status == 'APP'){

           
            $inforleave=  Leave_register::select('ID','LEAVE_BECAUSE','WORK_DO','LEAVE_DATE_END','LEAVE_DATE_BEGIN','LEAVE_WORK_SEND','LEAVE_CONTACT_PHONE','LOCATION_NAME','LEAVE_TYPE_NAME','LEAVE_PERSON_FULLNAME','LEAVE_YEAR_ID','STATUS_NAME','STATUS_CODE','gleave_register.created_at','LEAVE_CONTACT','LEAVE_SUM_ALL','WORK_DO','LEAVE_SUM_HOLIDAY','LEAVE_SUM_SETSUN','LEAVE_COMMENT_BY','DAY_TYPE_ID','LEAVE_APP_H1','LEAVE_APP_H2')
            ->leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_ID')
            ->leftJoin('gleave_status','gleave_register.LEAVE_STATUS_CODE','=','gleave_status.STATUS_CODE')
            ->leftJoin('gleave_location','gleave_register.LOCATION_ID','=','gleave_location.LOCATION_ID')
            ->where('LEADER_PERSON_ID','=',$iduser)
            ->where(function($q){
                $q->where('LEAVE_STATUS_CODE','=','Pending');
                $q->orwhere('LEAVE_STATUS_CODE','=','Recancel');
    
            })
            ->where(function($q) use ($search){
                $q->where('LEAVE_YEAR_ID','like','%'.$search.'%');
                $q->orwhere('LEAVE_PERSON_FULLNAME','like','%'.$search.'%');
                $q->orwhere('LEAVE_TYPE_NAME','like','%'.$search.'%');
                $q->orwhere('LEAVE_BECAUSE','like','%'.$search.'%');
    
            })
            ->WhereBetween('LEAVE_DATE_BEGIN',[$from,$to])
            ->orderBy('gleave_register.ID', 'desc')
            ->get();

          

        }else{
    
        $inforleave=  Leave_register::select('ID','LEAVE_BECAUSE','WORK_DO','LEAVE_DATE_END','LEAVE_DATE_BEGIN','LEAVE_WORK_SEND','LEAVE_CONTACT_PHONE','LOCATION_NAME','LEAVE_TYPE_NAME','LEAVE_PERSON_FULLNAME','LEAVE_YEAR_ID','STATUS_NAME','STATUS_CODE','gleave_register.created_at','LEAVE_CONTACT','LEAVE_SUM_ALL','WORK_DO','LEAVE_SUM_HOLIDAY','LEAVE_SUM_SETSUN','LEAVE_COMMENT_BY','DAY_TYPE_ID','LEAVE_APP_H1','LEAVE_APP_H2')
        ->leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_ID')
        ->leftJoin('gleave_status','gleave_register.LEAVE_STATUS_CODE','=','gleave_status.STATUS_CODE')
        ->leftJoin('gleave_location','gleave_register.LOCATION_ID','=','gleave_location.LOCATION_ID')
        ->where('LEADER_PERSON_ID','=',$iduser)
        ->where('LEAVE_STATUS_CODE','=',$status)
        ->where(function($q) use ($search){
            $q->where('LEAVE_YEAR_ID','like','%'.$search.'%');
            $q->orwhere('LEAVE_PERSON_FULLNAME','like','%'.$search.'%');
            $q->orwhere('LEAVE_TYPE_NAME','like','%'.$search.'%');
            $q->orwhere('LEAVE_BECAUSE','like','%'.$search.'%');

        })
        ->WhereBetween('LEAVE_DATE_BEGIN',[$from,$to])
        ->orderBy('gleave_register.ID', 'desc')
        ->get();

        }
    }

         }else{

        if($status == null){

            $inforleave=  Leave_register::select('ID','LEAVE_BECAUSE','WORK_DO','LEAVE_DATE_END','LEAVE_DATE_BEGIN','LEAVE_WORK_SEND','LEAVE_CONTACT_PHONE','LOCATION_NAME','LEAVE_TYPE_NAME','LEAVE_PERSON_FULLNAME','LEAVE_YEAR_ID','STATUS_NAME','STATUS_CODE','gleave_register.created_at','LEAVE_CONTACT','LEAVE_SUM_ALL','WORK_DO','LEAVE_SUM_HOLIDAY','LEAVE_SUM_SETSUN','LEAVE_COMMENT_BY','DAY_TYPE_ID','LEAVE_APP_H1','LEAVE_APP_H2')
            ->leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_ID')
            ->leftJoin('gleave_status','gleave_register.LEAVE_STATUS_CODE','=','gleave_status.STATUS_CODE')
            ->leftJoin('gleave_location','gleave_register.LOCATION_ID','=','gleave_location.LOCATION_ID')
            ->where('LEADER_PERSON_ID','=',$iduser)
            ->where(function($q) use ($search){
                $q->where('LEAVE_YEAR_ID','like','%'.$search.'%');
                $q->orwhere('LEAVE_PERSON_FULLNAME','like','%'.$search.'%');
                $q->orwhere('LEAVE_TYPE_NAME','like','%'.$search.'%');
                $q->orwhere('LEAVE_BECAUSE','like','%'.$search.'%');
            })
            ->orderBy('gleave_register.ID', 'desc')
            ->get();
        }else{


            if($status == 'APP'){

                $inforleave=  Leave_register::select('ID','LEAVE_BECAUSE','WORK_DO','LEAVE_DATE_END','LEAVE_DATE_BEGIN','LEAVE_WORK_SEND','LEAVE_CONTACT_PHONE','LOCATION_NAME','LEAVE_TYPE_NAME','LEAVE_PERSON_FULLNAME','LEAVE_YEAR_ID','STATUS_NAME','STATUS_CODE','gleave_register.created_at','LEAVE_CONTACT','LEAVE_SUM_ALL','WORK_DO','LEAVE_SUM_HOLIDAY','LEAVE_SUM_SETSUN','LEAVE_COMMENT_BY','DAY_TYPE_ID','LEAVE_APP_H1','LEAVE_APP_H2')
                ->leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_ID')
                ->leftJoin('gleave_status','gleave_register.LEAVE_STATUS_CODE','=','gleave_status.STATUS_CODE')
                ->leftJoin('gleave_location','gleave_register.LOCATION_ID','=','gleave_location.LOCATION_ID')
                ->where('LEADER_PERSON_ID','=',$iduser)
                ->where(function($q){
                    $q->where('LEAVE_STATUS_CODE','=','Pending');
                    $q->orwhere('LEAVE_STATUS_CODE','=','Recancel');
        
                })
                ->where(function($q) use ($search){
                    $q->where('LEAVE_YEAR_ID','like','%'.$search.'%');
                    $q->orwhere('LEAVE_PERSON_FULLNAME','like','%'.$search.'%');
                    $q->orwhere('LEAVE_TYPE_NAME','like','%'.$search.'%');
                    $q->orwhere('LEAVE_BECAUSE','like','%'.$search.'%');
                })
                ->orderBy('gleave_register.ID', 'desc')
                ->get();
    

            }else{
            $inforleave=  Leave_register::select('ID','LEAVE_BECAUSE','WORK_DO','LEAVE_DATE_END','LEAVE_DATE_BEGIN','LEAVE_WORK_SEND','LEAVE_CONTACT_PHONE','LOCATION_NAME','LEAVE_TYPE_NAME','LEAVE_PERSON_FULLNAME','LEAVE_YEAR_ID','STATUS_NAME','STATUS_CODE','gleave_register.created_at','LEAVE_CONTACT','LEAVE_SUM_ALL','WORK_DO','LEAVE_SUM_HOLIDAY','LEAVE_SUM_SETSUN','LEAVE_COMMENT_BY','DAY_TYPE_ID','LEAVE_APP_H1','LEAVE_APP_H2')
            ->leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_ID')
            ->leftJoin('gleave_status','gleave_register.LEAVE_STATUS_CODE','=','gleave_status.STATUS_CODE')
            ->leftJoin('gleave_location','gleave_register.LOCATION_ID','=','gleave_location.LOCATION_ID')
            ->where('LEADER_PERSON_ID','=',$iduser)
            ->where('LEAVE_STATUS_CODE','=',$status)
            ->where(function($q) use ($search){
                $q->where('LEAVE_YEAR_ID','like','%'.$search.'%');
                $q->orwhere('LEAVE_PERSON_FULLNAME','like','%'.$search.'%');
                $q->orwhere('LEAVE_TYPE_NAME','like','%'.$search.'%');
                $q->orwhere('LEAVE_BECAUSE','like','%'.$search.'%');
            })
            ->orderBy('gleave_register.ID', 'desc')
            ->get();

             }

        }

        }



         $infostatus =  LeaveStatus::get();
         $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

         $year_id = $yearbudget;

        return view('person_leave.personinfoleaveapp',[
            'inforpersonuser' => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid,
            'inforleaves' => $inforleave,
            'infostatuss' => $infostatus,
            'displaydate_bigen'=> $displaydate_bigen, 
            'displaydate_end'=> $displaydate_end,
            'status_check' => $status,
            'search' => $search,
            'year_id'=>$year_id, 
            'budgets' =>  $budget,
        ]);


    }




//----------------------------------------------------------------------


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


        
        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;
        }

        $checkdat_setup  = DB::table('gleave_over')->where('OVER_YEAR_ID','=', $yearbudget)->where('PERSON_ID','=',$iduser)->count();

        return view('person_leave.personinfoleavetype',[
            'inforpersonuser' => $inforpersonuser,
            'checkdat_setup' => $checkdat_setup,
            'inforpersonuserid' => $inforpersonuserid
        ]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createsick(Request $request,$leavetype,$iduser)
    {
         $inforpersonuserid =  Person::where('ID','=',$iduser)->first();
         $id = $inforpersonuserid->ID;

         $budgetyear =  DB::table('budget_year') ->where('ACTIVE','=',True)->get();
         $location =  DB::table('gleave_location')->get();
         $daytype =  DB::table('gleave_day_type')->get();

         $leader =  DB::table('gleave_leader_person')
                    ->leftJoin('gleave_leader','gleave_leader.LEADER_ID','=','gleave_leader_person.LEADER_ID')
                    ->where('PERSON_ID','=',$iduser)
                    ->get();

         $leader_all =  DB::table('hrd_department_sub')
         ->select('LEADER_HR_ID','HR_FNAME','HR_LNAME')
         ->leftJoin('hrd_person','hrd_person.ID','=','hrd_department_sub.LEADER_HR_ID')
         ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
         ->where('LEADER_HR_ID','!=','')->distinct()->get();

         $reason =  DB::table('gleave_reason')->get();
         $infonation =  DB::table('hrd_nationality')->get();

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

      
        
        $infofunction = DB::table('gleave_function')->where('FUNCTION_ID','=',2)->first();

        if($infofunction->ACTIVE == 'True'){
            $department = $inforpersonuser -> HR_DEPARTMENT_SUB_ID;

            $LEAVEWORK_SEND =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
            ->where('HR_STATUS_ID','=',1)
            ->where('HR_DEPARTMENT_SUB_ID','=',$department)
            ->orderBy('HR_FNAME', 'asc')
            ->get();

        }else{

            $LEAVEWORK_SEND =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
            ->where('HR_STATUS_ID','=',1)
            ->orderBy('HR_FNAME', 'asc')
            ->get();

        }


        //--------------------------------คำนวนวันลาพักผ่อน----------------------

  $m_budget = date("m");
  if($m_budget>9){
    $yearbudget = date("Y")+544;
  }else{
    $yearbudget = date("Y")+543;
  }



    $dateuse = DB::table('gleave_register')
    ->where('LEAVE_YEAR_ID','=',$yearbudget )
    ->where('LEAVE_TYPE_CODE','=','04' )
    ->where(function($q){
        $q->where('LEAVE_STATUS_CODE','=','Approve'); 
        $q->orwhere('LEAVE_STATUS_CODE','=','Pending');  
        $q->orwhere('LEAVE_STATUS_CODE','=','Verify');
        $q->orwhere('LEAVE_STATUS_CODE','=','Allow');
      
    })
    ->where('LEAVE_PERSON_ID','=',$iduser )
    ->sum('WORK_DO');

    $datehaveyear = DB::table('gleave_over')
    ->where('PERSON_ID','=',$iduser )
    ->where('OVER_YEAR_ID','=',$yearbudget )
    ->sum('DAY_LEAVE_OVER_BEFORE');


    $datebalance = $datehaveyear  - $dateuse;



         return view('person_leave.personinfoleavesick_add',[
             'inforpersonuser' => $inforpersonuser,
             'inforpersonuserid' => $inforpersonuserid,
             'budgetyears' => $budgetyear,
             'locations' => $location,
             'daytypes' => $daytype,
             'LEAVEWORK_SENDs' => $LEAVEWORK_SEND,
             'leaders' => $leader,
             'leader_alls' =>$leader_all,
             'leavetype' => $leavetype,
             'reasons'=>$reason,
             'infonations' => $infonation,
             'datebalance' => $datebalance

         ]);
    }



    function calldate(Request $request)
    {


        $LEAVE_TYPE_CODE = $request->get('LEAVE_TYPE_CODE');
        $LEAVE_PERSON_LAVEL_ID = $request->get('LEAVE_PERSON_LAVEL_ID');
        $LEAVE_YEAR_ID = $request->get('LEAVE_YEAR_ID');
      $date_bigen = $request->get('date_bigen');
      $date_end = $request->get('date_end');
      $DATE_OFF = $request->get('DATE_OFF');
      $DAYTYPE_ID = $request->get('DAY_TYPE_ID');
      

      $date_bigen_c = Carbon::createFromFormat('d/m/Y', $date_bigen)->format('Y-m-d');
      $date_arrary=explode("-",$date_bigen_c);
     

      if($date_arrary[0]>= 2500){
        $y = $date_arrary[0]-543;
    }else{
        $y = $date_arrary[0];
    }

      $m = $date_arrary[1];
      $d = $date_arrary[2];
      $displaydate_bigen= $y."-".$m."-".$d;

      $date_end_c = Carbon::createFromFormat('d/m/Y', $date_end)->format('Y-m-d');
      $date_arrary_e=explode("-",$date_end_c);
      if($date_arrary_e[0]>= 2500){
        $y_e = $date_arrary_e[0]-543;
    }else{
        $y_e = $date_arrary_e[0];
    }

      $m_e = $date_arrary_e[1];
      $d_e = $date_arrary_e[2];
      $displaydate_end= $y_e."-".$m_e."-".$d_e;

      $sumdate = round(abs(strtotime($displaydate_end) - strtotime($displaydate_bigen))/60/60/24)+1;

      date_default_timezone_set('Asia/Bangkok');

     $date = $displaydate_bigen;
     $end_date = $displaydate_end;




     $intHoliday=0;
     $intPublicHoliday=0;
     while (strtotime($date) <= strtotime($end_date)) {

        $count= DB::table('gleave_holiday')
              ->where('gleave_holiday.DATE_HOLIDAY',$date)
              ->count();

        $DayOfWeek = date("w", strtotime($date));
         if($DayOfWeek == 0 or $DayOfWeek ==6)  // 0 = Sunday, 6 = Saturday;
         {
             $intHoliday++;
         }elseif($count== 1)
         {
             $intPublicHoliday++;

         }

         $date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
     }


    

   $checkholiday =  Person::where('hrd_person.ID','=',$LEAVE_PERSON_LAVEL_ID)->first();

                        //----------------------------คำนวนวันทำการ
                        if($DATE_OFF == '' || $DATE_OFF== null){
                            $amountdateoff =  0;
                        }else{
                            $amountdateoff =  $DATE_OFF;
                        }


                        //----------------------------คำนวนวันทำการ
                        if($LEAVE_TYPE_CODE== '02' || $LEAVE_TYPE_CODE== '05' || $LEAVE_TYPE_CODE== '07' || $LEAVE_TYPE_CODE== '08' || $LEAVE_TYPE_CODE== '09' || $LEAVE_TYPE_CODE== '10'){
                            $datework = $sumdate;
                        }else{

                            if($checkholiday->LEAVEDAY_ACTIVE == 'True'){

                                if($DAYTYPE_ID == '02' || $DAYTYPE_ID == '03'|| $DAYTYPE_ID == '2' || $DAYTYPE_ID == '3'){
                                     
                                    $datework = ($sumdate- $amountdateoff )-0.5;
                                }else{
                                    $datework = $sumdate - $amountdateoff;
                                }
                            
                            }else{
                                if($DAYTYPE_ID == '02' || $DAYTYPE_ID == '03'|| $DAYTYPE_ID == '2' || $DAYTYPE_ID == '3'){
                                   
                                    $datework = ($sumdate - ($intHoliday + $intPublicHoliday)) - 0.5;
                                     
                                }else{
                                    $datework = $sumdate - ($intHoliday + $intPublicHoliday);
                                }
                            }

                        }
                        
   


    //--------------------------------คำนวนวันคงเหลือ----------------------

    $dateuse = DB::table('gleave_register')
    ->where('LEAVE_YEAR_ID','=',$LEAVE_YEAR_ID )
    ->where('LEAVE_TYPE_CODE','=','04' )
    ->where(function($q){
        $q->where('LEAVE_STATUS_CODE','=','Approve'); 
        $q->orwhere('LEAVE_STATUS_CODE','=','Pending');       
        $q->orwhere('LEAVE_STATUS_CODE','=','Verify');
        $q->orwhere('LEAVE_STATUS_CODE','=','Allow');   
    })
    ->where('LEAVE_PERSON_ID','=',$LEAVE_PERSON_LAVEL_ID )
    ->sum('WORK_DO');

    $datehaveyear = DB::table('gleave_over')
    ->where('PERSON_ID','=',$LEAVE_PERSON_LAVEL_ID )
    ->where('OVER_YEAR_ID','=',$LEAVE_YEAR_ID )
    ->sum('DAY_LEAVE_OVER_BEFORE');

    $datebalance = $datehaveyear  - $dateuse;

    //-------------------------------------------------------------------

    if($LEAVE_TYPE_CODE == '04' &&  $datework > $datebalance ){

        $output='<label style="color: #DC143C;">วันลาของท่านไม่เพียงพอ !!</lable>
        <input type="hidden" name ="checkcall_date" id="checkcall_date" value="false">';

    }else if(strtotime($displaydate_end) < strtotime($displaydate_bigen)){
        $output='<lable style="color: #DC143C;">กรุณาเลือกช่วงเวลาให้ถูกต้อง !!</lable>
        <input type="hidden" name ="checkcall_date" id="checkcall_date" value="false">';


     }else{


        $output='<div class="form-group">
                <label>จำนวนวัน
                '.$sumdate.' วัน</label>
                <input type="hidden" name ="HR_LNAME" id="HR_LNAME" class="form-control input-lg" value="'.$sumdate.'" >

                <label>,เป็นวันทำการ
                '.$datework.' วัน</label>
                <input type="hidden" name ="HR_LNAME" id="HR_LNAME" class="form-control input-lg" value="'.$datework.'" >
                </div>
                <div class="form-group">
                <label style="color: #DC143C;">วันหยุดเสาร์ - อาทิตย์
                '.$intHoliday.' วัน</label>
                <input type="hidden" name ="HR_LNAME" id="HR_LNAME" class="form-control input-lg" value="'.$intHoliday.'" >

                <label style="color: #DC143C;">,วันหยุดนักขัตฤกษ์
                '.$intPublicHoliday.' วัน</label>
                <input type="hidden" name ="HR_LNAME" id="HR_LNAME" class="form-control input-lg" value="'.$intPublicHoliday.'" >
                </div>
                <div class="form-group">
                <label style="color: #DC143C;">จำนวนวัน Off
                '.$amountdateoff.' วัน</label>
                <input type="hidden" name ="checkcall_date" id="checkcall_date" value="true">
                
                ';

     }

    echo $output;

    }

     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request)
    {       

       $type_leave = $request->LEAVE_TYPE_CODE;

       $WORK_SEND_ID = $request->LEAVE_WORK_SEND_ID;
       $LEADERPERSON_ID = $request->LEADER_PERSON_ID;
       $LEADERDEP_ID = $request->LEADER_DEP_PERSON_ID;
       $LEAVE_DATETIME_REGIS = date("Y-m-d H:i:s");

if($type_leave <> '12'){


       $date_bigen = $request->date_bigen;
       $date_end = $request->date_end;
       $DAYTYPE_ID= $request->DAY_TYPE_ID;
      


        if($date_bigen != ''){

            $date_bigen_c = Carbon::createFromFormat('d/m/Y', $date_bigen)->format('Y-m-d');
            $date_arrary=explode("-",$date_bigen_c);
           
            if($date_arrary[0]>= 2500){
                $y = $date_arrary[0]-543;
            }else{
                $y = $date_arrary[0];
            }
            $m = $date_arrary[1];
            $d = $date_arrary[2];
            $displaydate_bigen= $y."-".$m."-".$d;
            }else{
            $displaydate_bigen= null;
        }

        if($date_end != ''){
            $date_end_c = Carbon::createFromFormat('d/m/Y', $date_end)->format('Y-m-d');
            $date_arrary_e=explode("-",$date_end_c);
            
            if($date_arrary_e[0]>= 2500){
                $y_e = $date_arrary_e[0]-543;
            }else{
                $y_e = $date_arrary_e[0];
            }
            
            $m_e = $date_arrary_e[1];
            $d_e = $date_arrary_e[2];
            $displaydate_end= $y_e."-".$m_e."-".$d_e;
            }else{
            $displaydate_end= null;
            }


//=======เช็คบันทึกซ้ำ
            $checkloopsave = DB::table('gleave_register')
                            ->where('LEAVE_PERSON_ID','=',$request->LEAVE_PERSON_ID)
                            ->where('LEAVE_DATE_BEGIN','=',$displaydate_bigen)
                            ->where('LEAVE_DATE_END','=',$displaydate_end)
                            ->where('LEAVE_STATUS_CODE','<>','Cancel')
                            ->count();

                       

            if( strtotime($displaydate_end)== strtotime($displaydate_bigen) and ($DAYTYPE_ID == '02' || $DAYTYPE_ID == '03'|| $DAYTYPE_ID == '2' || $DAYTYPE_ID == '3')){
                $sumdate = 1;
            }else{
                $sumdate = round(abs(strtotime($displaydate_end) - strtotime($displaydate_bigen))/60/60/24)+1;
            }

            
            date_default_timezone_set('Asia/Bangkok');

     $date = $displaydate_bigen;
     $end_date = $displaydate_end;




     $intHoliday=0;
     $intPublicHoliday=0;
     while (strtotime($date) <= strtotime($end_date)) {

        $count= DB::table('gleave_holiday')
              ->where('gleave_holiday.DATE_HOLIDAY',$date)
              ->count();

        $DayOfWeek = date("w", strtotime($date));
         if($DayOfWeek == 0 or $DayOfWeek ==6)  // 0 = Sunday, 6 = Saturday;
         {
             $intHoliday++;
         }elseif($count== 1)
         {
             $intPublicHoliday++;

         }

         $date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
     }


     
    

     $checkholiday =  Person::where('hrd_person.ID','=',$request->LEAVE_PERSON_ID)->first();
//----------------------------คำนวนวันทำการ
                    if($request->DATE_OFF == '' || $request->DATE_OFF== null){
                        $amountdateoff =  0;
                    }else{
                        $amountdateoff =  $request->DATE_OFF;
                    }
        //----------------------------คำนวนวันทำการ
        if($type_leave== '02' || $type_leave== '05' || $type_leave== '07' || $type_leave== '08' || $type_leave== '09' || $type_leave== '10'){
            $datework = $sumdate;
        }else{

            if($checkholiday->LEAVEDAY_ACTIVE == 'True'){

                if($DAYTYPE_ID == '02' || $DAYTYPE_ID == '03'|| $DAYTYPE_ID == '2' || $DAYTYPE_ID == '3'){
                     
                    $datework = ($sumdate- $amountdateoff)-0.5;
                }else{
                    $datework = $sumdate - $amountdateoff;
                }
            
            }else{
                if($DAYTYPE_ID == '02' || $DAYTYPE_ID == '03'|| $DAYTYPE_ID == '2' || $DAYTYPE_ID == '3'){
                   
                    $datework = ($sumdate - ($intHoliday + $intPublicHoliday)) - 0.5;
                     
                }else{
                    $datework = $sumdate - ($intHoliday + $intPublicHoliday);
                }
            }

        }
        
       

}else{
    $checkloopsave = 0;
    $displaydate_bigen = '0000-00-00';
    $displaydate_end = '0000-00-00';
    $datework = '0';
}

 
         //--------------------------------------
         if($WORK_SEND_ID  !=''){
         $LEAVEWORK_SEND =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
         ->where('hrd_person.ID','=',$WORK_SEND_ID)->first();

         $LEAVEWORKSEND_name  = $LEAVEWORK_SEND->HR_PREFIX_NAME.''.$LEAVEWORK_SEND->HR_FNAME.' '.$LEAVEWORK_SEND->HR_LNAME;
         }else{
            $LEAVEWORKSEND_name='';
         }
         //--------------------------------------
          $LEADERPERSON =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
          ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
          ->where('hrd_person.ID','=',$LEADERPERSON_ID)->first();

          $LEADERPERSON_name  = $LEADERPERSON->HR_PREFIX_NAME.''.$LEADERPERSON->HR_FNAME.' '.$LEADERPERSON->HR_LNAME;
          $LEADERPERSON_POSITION  = $LEADERPERSON->HR_POSITION_NAME;
          $LEADERPERSON_POSITION_IN_WORK  = $LEADERPERSON->POSITION_IN_WORK;
          //--------------------------------------
          $LEADERDEP =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
          ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
          ->where('hrd_person.ID','=',$LEADERDEP_ID)->first();

         $LEADERDEP_name  = $LEADERDEP->HR_PREFIX_NAME.''.$LEADERDEP->HR_FNAME.' '.$LEADERDEP->HR_LNAME;
          $LEADERDEP_POSITION  = $LEADERDEP->HR_POSITION_NAME;

          //--------------------------------------

            $addleave = new Leave_register();
            $addleave->LEAVE_YEAR_ID = $request->LEAVE_YEAR_ID;
            if($type_leave != '12'){
            $addleave->LEAVE_DATE_BEGIN = $displaydate_bigen;
            $addleave->LEAVE_DATE_END =  $displaydate_end;
            $addleave->LEAVE_DATE_SUM = $sumdate;
            $addleave->DAY_TYPE_ID = $DAYTYPE_ID;
            }
            $addleave->LEAVE_CONTACT = $request->LEAVE_CONTACT;
            $addleave->LEAVE_DATETIME_REGIS = $LEAVE_DATETIME_REGIS;
            $addleave->LEAVE_TYPE_CODE = $request->LEAVE_TYPE_CODE;
            $addleave->LEAVE_PERSON_ID = $request->LEAVE_PERSON_ID;
            $addleave->LEAVE_PERSON_CODE = $request->LEAVE_PERSON_CODE;
            $addleave->LEAVE_PERSON_FULLNAME = $request->LEAVE_PERSON_FULLNAME;
            $addleave->LEAVE_POSITION_ID = $request->LEAVE_POSITION_ID;
            $addleave->LEAVE_DEPARTMENT_ID = $request->LEAVE_DEPARTMENT_ID;
            $addleave->LEAVE_TYPE_PERSON_ID = $request->LEAVE_TYPE_PERSON_ID;
            $addleave->LEAVE_STATUS_CODE = $request->LEAVE_STATUS_CODE;
            if($type_leave != '12'){
            $addleave->LEAVE_CONTACT_PHONE = $request->LEAVE_CONTACT_PHONE;
            $addleave->DATE_OFF =  $amountdateoff;
            }
            $addleave->LEAVE_WORK_SEND =  $LEAVEWORKSEND_name;
            $addleave->LEAVE_WORK_SEND_ID = $request->LEAVE_WORK_SEND_ID;

            $addleave->LEADER_PERSON_ID = $LEADERPERSON_ID;
            $addleave->LEADER_PERSON_NAME = $LEADERPERSON_name;
            $addleave->LEADER_PERSON_POSITION = $LEADERPERSON_POSITION;
            $addleave->LEADER_POSITION_IN_WORK = $LEADERPERSON_POSITION_IN_WORK;

            $addleave->LEAVE_PERSON_LAVEL_NAME = $request->LEAVE_PERSON_LAVEL_NAME;
            $addleave->LEAVE_PERSON_LAVEL_ID = $request->LEAVE_PERSON_LAVEL_ID;

            $addleave->LEADER_DEP_PERSON_ID = $LEADERDEP_ID;
            $addleave->LEADER_DEP_PERSON_NAME = $LEADERDEP_name;
            $addleave->LEADER_DEP_PERSON_POSITION = $LEADERDEP_POSITION;

            
            $addleave->LEAVE_COMMENT_BY = $request->LEAVE_COMMENT_BY;

            if($type_leave != '12'){
            $addleave->LOCATION_ID = $request->LOCATION_ID;
            
            $addleave->WORK_DO = $datework;
            $addleave->LEAVE_SUM_ALL = $sumdate;
            $addleave->LEAVE_SUM_HOLIDAY = $intHoliday;
            $addleave->LEAVE_SUM_SETSUN = $intPublicHoliday;
            }


            //-----------------------เพิ่มข้อมูลตาประเภทการลา-----------------------
            if($type_leave== '05'){

                $date= $request->ODEIN_DATE;

                if($date != ''){
                    $date_c = Carbon::createFromFormat('d/m/Y', $date)->format('Y-m-d');
                    $date_arrary_e=explode("-",$date_c);
                    if($date_arrary_e[0]>= 2500){
                        $y_e = $date_arrary_e[0]-543;
                    }else{
                        $y_e = $date_arrary_e[0];
                    }
                    $m_e = $date_arrary_e[1];
                    $d_e = $date_arrary_e[2];
                    $ODEIN_DATE= $y_e."-".$m_e."-".$d_e;
                    }else{
                    $ODEIN_DATE= null;
                    }

                $addleave->ODEIN_TEMPLE = $request->ODEIN_TEMPLE;
                $addleave->ODEIN_TEMPLE_ADD = $request->ODEIN_TEMPLE_ADD;
                $addleave->ODEIN_DATE = $ODEIN_DATE;
                $addleave->ODEN_TEMPLE_LIVE = $request->ODEN_TEMPLE_LIVE;
                $addleave->ODEN_TEMPLE_LIVE_ADD = $request->ODEN_TEMPLE_LIVE_ADD;
                $addleave->ODEN_TYPE = $request->ODEN_TYPE;
                $addleave->ODEN_EVER = $request->ODEN_EVER;

            }else if($type_leave== '06'){

                $date= $request->LEAVE_DATE_SPAWN;

                if($date != ''){
                    $date_c = Carbon::createFromFormat('d/m/Y', $date)->format('Y-m-d');
                    $date_arrary_e=explode("-",$date_c);
                    if($date_arrary_e[0]>= 2500){
                        $y_e = $date_arrary_e[0]-543;
                    }else{
                        $y_e = $date_arrary_e[0];
                    }
                    $m_e = $date_arrary_e[1];
                    $d_e = $date_arrary_e[2];
                    $LEAVE_DATE_SPAWN= $y_e."-".$m_e."-".$d_e;
                    }else{
                    $LEAVE_DATE_SPAWN= null;
                    }

                $addleave->LEAVE_WORD_BEGIN = $request->LEAVE_WORD_BEGIN;
                $addleave->LEAVE_MARRY_NAME = $request->LEAVE_MARRY_NAME;
                $addleave->LEAVE_DATE_SPAWN = $LEAVE_DATE_SPAWN;


            }else if($type_leave== '08'){

                $addleave->EDU_SUBJECT = $request->EDU_SUBJECT;
                $addleave->EDU_BRANCH = $request->EDU_BRANCH;
                $addleave->EDU_ACADEMY = $request->EDU_ACADEMY;
                $addleave->EDU_CONTRY_ID = $request->EDU_CONTRY_ID;
                $addleave->EDU_TON = $request->EDU_TON;
                $addleave->EDU_T_COURSE = $request->EDU_T_COURSE;
                $addleave->EDU_T_LOCATION = $request->EDU_T_LOCATION;
                $addleave->EDU_T_CONTRY_ID = $request->EDU_T_CONTRY_ID;
                $addleave->EDU_TYPE = $request->EDU_TYPE;



            }else if($type_leave== '10'){

                $addleave->FW_MARRY_SALARY = $request->FW_MARRY_SALARY;
                $addleave->FW_MARRY = $request->FW_MARRY;
                $addleave->FW_MARRY_POSITION = $request->FW_MARRY_POSITION;
                $addleave->FW_MARRY_LEVEL = $request->FW_MARRY_LEVEL;
                $addleave->FW_MARRY_UNDER = $request->FW_MARRY_UNDER;
                $addleave->FW_COUNTRY_ID = $request->FW_COUNTRY_ID;


            }else if($type_leave== '12'){


                $date1= $request->EXIT_IN_DATE;

                if($date1 != ''){
                    $date_c = Carbon::createFromFormat('d/m/Y', $date1)->format('Y-m-d');
                    $date_arrary_e=explode("-",$date_c);
                    if($date_arrary_e[0]>= 2500){
                        $y_e = $date_arrary_e[0]-543;
                    }else{
                        $y_e = $date_arrary_e[0];
                    }
                    $m_e = $date_arrary_e[1];
                    $d_e = $date_arrary_e[2];
                    $EXIT_IN_DATE= $y_e."-".$m_e."-".$d_e;
                    }else{
                    $EXIT_IN_DATE= null;
                    }


                $date2= $request->EXIT_PERSON_VCODE_DATE;

                if($date2 != ''){
                    $date_c = Carbon::createFromFormat('d/m/Y', $date2)->format('Y-m-d');
                    $date_arrary_e=explode("-",$date_c);
                    if($date_arrary_e[0]>= 2500){
                        $y_e = $date_arrary_e[0]-543;
                    }else{
                        $y_e = $date_arrary_e[0];
                    }
                    $m_e = $date_arrary_e[1];
                    $d_e = $date_arrary_e[2];
                    $EXIT_PERSON_VCODE_DATE= $y_e."-".$m_e."-".$d_e;
                    }else{
                    $EXIT_PERSON_VCODE_DATE= null;
                    }


                $date3= $request->EXIT_DATE_BEGIN;

                if($date3 != ''){
                    $date_c = Carbon::createFromFormat('d/m/Y', $date3)->format('Y-m-d');
                    $date_arrary_e=explode("-",$date_c);
                    if($date_arrary_e[0]>= 2500){
                        $y_e = $date_arrary_e[0]-543;
                    }else{
                        $y_e = $date_arrary_e[0];
                    }
                    $m_e = $date_arrary_e[1];
                    $d_e = $date_arrary_e[2];
                    $EXIT_DATE_BEGIN= $y_e."-".$m_e."-".$d_e;
                    }else{
                    $EXIT_DATE_BEGIN= null;
                    }


                $date4= $request->EXIT_DATE_FINISH;

                if($date4 != ''){
                    $date_c = Carbon::createFromFormat('d/m/Y', $date4)->format('Y-m-d');
                    $date_arrary_e=explode("-",$date_c);
                    if($date_arrary_e[0]>= 2500){
                        $y_e = $date_arrary_e[0]-543;
                    }else{
                        $y_e = $date_arrary_e[0];
                    }
                    $m_e = $date_arrary_e[1];
                    $d_e = $date_arrary_e[2];
                    $EXIT_DATE_FINISH= $y_e."-".$m_e."-".$d_e;
                    }else{
                    $EXIT_DATE_FINISH= null;
                    }

                $addleave->EXIT_POSITION_TYPE = $request->EXIT_POSITION_TYPE;
                $addleave->EXIT_IN_DATE = $EXIT_IN_DATE;
                $addleave->EXIT_PERSON_VCODE = $request->EXIT_PERSON_VCODE;
                $addleave->EXIT_PERSON_VCODE_DATE = $EXIT_PERSON_VCODE_DATE;
                $addleave->EXIT_GROUP = $request->EXIT_GROUP;
                $addleave->EXIT_POSITION = $request->EXIT_POSITION;
                $addleave->EXIT_WORK = $request->EXIT_WORK;
                $addleave->EXIT_DEP = $request->EXIT_DEP;
                $addleave->EXIT_SECTION = $request->EXIT_SECTION;
                $addleave->EXIT_SALARY = $request->EXIT_SALARY;
                $addleave->EXIT_DATE_BEGIN = $EXIT_DATE_BEGIN;
                $addleave->EXIT_DATE_FINISH =$EXIT_DATE_FINISH;
                $addleave->EXIT_BECAUSE = $request->EXIT_BECAUSE;



            }else{
               $addleave->LEAVE_BECAUSE = $request->LEAVE_BECAUSE;
            }



           if($checkloopsave == 0 && $request->LEAVE_YEAR_ID != '' && $request->LEAVE_YEAR_ID != null){

            $addleave->save();

           }


           $idmax = Leave_register::max('ID');

          

           $infoleave = Leave_register::where('ID','=',$idmax)->first();

           if($infoleave->LEAVE_TYPE_CODE == 4){
   
               $yearbudget = $infoleave->LEAVE_YEAR_ID;
               $id_user = $infoleave->LEAVE_PERSON_ID;
   
               $dateuse = DB::table('gleave_register')
               ->where('LEAVE_YEAR_ID','=',$yearbudget )
               ->where('LEAVE_TYPE_CODE','=','04' )
               ->where('LEAVE_PERSON_ID','=',$id_user )
               ->where(function($q){
                   $q->where('LEAVE_STATUS_CODE','=','Approve'); 
                   $q->orwhere('LEAVE_STATUS_CODE','=','Pending');  
                   $q->orwhere('LEAVE_STATUS_CODE','=','Verify');
                   $q->orwhere('LEAVE_STATUS_CODE','=','Allow');
                 
               })
               ->sum('WORK_DO');
           
               $datehaveyear = DB::table('gleave_over')
               ->where('PERSON_ID','=',$id_user )
               ->where('OVER_YEAR_ID','=',$yearbudget )
               ->sum('DAY_LEAVE_OVER_BEFORE');
           
               $datebalance = $datehaveyear  - $dateuse;
   
               $leavedatebalance = Leave_register::find($idmax);
               $leavedatebalance->LEAVE_BALANCE_DATE = $datebalance;
               $leavedatebalance->save();
   
            }
         


           
           function DateThailinecar($strDate)
           {
             $strYear = date("Y",strtotime($strDate))+543;
             $strMonth= date("n",strtotime($strDate));
             $strDay= date("j",strtotime($strDate));
     
             $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
             $strMonthThai=$strMonthCut[$strMonth];
             return "$strDay $strMonthThai $strYear";
             }


        //แจ้งเตือนผู้บังคับัญชา

           $header = "ข้อมูลการลา";

            $datebegin = DateThailinecar($displaydate_bigen); 
            $backtime = DateThailinecar($displaydate_end);             
          
            $leave_type = DB::table('gleave_type')->where('LEAVE_TYPE_ID','=',$type_leave)->first(); 
            $hrd_department = DB::table('hrd_department')->where('HR_DEPARTMENT_ID','=',$request->LEAVE_DEPARTMENT_ID)->first(); 

           $message = $header.
               "\n"."ประเภท : " . $leave_type->LEAVE_TYPE_NAME .
               "\n"."เหตุผล : " . $request->LEAVE_BECAUSE .
               "\n"."ผู้ลา : " . $request->LEAVE_PERSON_FULLNAME .
               "\n"."หน่วยงาน : " . $hrd_department->HR_DEPARTMENT_NAME  .
               "\n"."ผู้รับมอบ : " . $LEAVEWORKSEND_name .
               "\n"."ตั้งแต่วันที่ : " . $datebegin .               
               "\n"."ถึงวันที่ : " . $backtime .    
               "\n"."จำนวน : " . $datework ." วัน" ;             
              
             
       
                   $name = DB::table('hrd_person')->where('ID','=',$LEADERPERSON_ID)->first();        
                  if($name == null){
                    $test ='';
                  }else{
                    $test =$name->HR_LINE;
                  }
                   
                  if($test !== '' && $test !== null){  
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
                   }


                     
              //แจ้งเตือนผู้รับมอบงาน

              $name2 = DB::table('hrd_person')->where('ID','=',$request->LEAVE_WORK_SEND_ID)->first();        
             
              if($name2 == null){
                $test2 ='';
              }else{
                $test2 =$name2->HR_LINE;
              }

              if($test2 !== '' && $test2 !== null){ 
               $chOne2 = curl_init();
              curl_setopt( $chOne2, CURLOPT_URL, "https://notify-api.line.me/api/notify");
              curl_setopt( $chOne2, CURLOPT_SSL_VERIFYHOST, 0);
              curl_setopt( $chOne2, CURLOPT_SSL_VERIFYPEER, 0);
              curl_setopt( $chOne2, CURLOPT_POST, 1);
              curl_setopt( $chOne2, CURLOPT_POSTFIELDS, $message);
              curl_setopt( $chOne2, CURLOPT_POSTFIELDS, "message=$message");
              curl_setopt( $chOne2, CURLOPT_FOLLOWLOCATION, 1);
              $headers2 = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$test2.'', );
              curl_setopt($chOne2, CURLOPT_HTTPHEADER, $headers2);
              curl_setopt( $chOne2, CURLOPT_RETURNTRANSFER, 1);
              $result2 = curl_exec( $chOne2 );
              if(curl_error($chOne2)) { echo 'error:' . curl_error($chOne2); }
              else { $result_ = json_decode($result2, true);
              echo "status : ".$result_['status']; echo "message : ". $result_['message']; }
              curl_close( $chOne2 );
              }

                //แจ้งเตือนกลุ่มหน่วยงาน
                $name_person = DB::table('hrd_person')->where('ID','=',$request->LEAVE_PERSON_ID)->first();    
               
                $name_01= DB::table('hrd_department_sub_sub')->where('HR_DEPARTMENT_SUB_SUB_ID','=',$name_person->HR_DEPARTMENT_SUB_SUB_ID)->first();        
              
              
                if($name_01 == null){
                    $tokendepsubsub ='';
                  }else{
                    $tokendepsubsub =$name_01->LINE_TOKEN;
                  }
    
            if($tokendepsubsub !== '' && $tokendepsubsub !== null){ 
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
              }

           return redirect()->route('leave.inforuser',['iduser'=>  $request->LEAVE_PERSON_ID]);


    }

//--------------------------------------------แก้ไข---------------------------------------------------------

public function editsick(Request $request,$id,$iduser)
    {
         $inforpersonuserid =  Person::where('ID','=',$iduser)->first();


         $budgetyear =  DB::table('budget_year') ->where('ACTIVE','=',True)->get();
         $location =  DB::table('gleave_location')->get();
         $daytype =  DB::table('gleave_day_type')->get();
         $leader =  DB::table('gleave_leader')->get();


         $leader_all =  DB::table('hrd_department_sub')
         ->select('LEADER_HR_ID','HR_FNAME','HR_LNAME')
         ->leftJoin('hrd_person','hrd_person.ID','=','hrd_department_sub.LEADER_HR_ID')
         ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
         ->where('LEADER_HR_ID','!=','')
         ->distinct()->get();


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

         $infofunction = DB::table('gleave_function')->where('FUNCTION_ID','=',2)->first();

         if($infofunction->ACTIVE == 'True'){
             $department = $inforpersonuser -> HR_DEPARTMENT_SUB_ID;
 
             $LEAVEWORK_SEND =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
             ->where('HR_STATUS_ID','=',1)
             ->where('HR_DEPARTMENT_SUB_ID','=',$department)
             ->orderBy('HR_FNAME', 'asc')
             ->get();
 
         }else{
 
             $LEAVEWORK_SEND =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
             ->where('HR_STATUS_ID','=',1)
             ->orderBy('HR_FNAME', 'asc')
             ->get();
 
         }



        $infoleave =  Leave_register::leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_ID')
        ->where('ID','=',$id)->first();
        
        $numberleavetype = $infoleave->LEAVE_TYPE_CODE;


        if($numberleavetype == '1' || $numberleavetype == '01'){
            $leavetype = 'sick';
        }else if($numberleavetype == '2' || $numberleavetype == '02'){
            $leavetype = 'spawn';
        }else if($numberleavetype == '3' || $numberleavetype == '03'){
            $leavetype = 'work';
        }else if($numberleavetype == '4' || $numberleavetype == '04'){
            $leavetype = 'rest';
        }else if($numberleavetype == '5' || $numberleavetype == '05'){
            $leavetype = 'religion';
        }else if($numberleavetype == '6' || $numberleavetype == '06'){
            $leavetype = 'helpspawn';
        }else if($numberleavetype == '7' || $numberleavetype == '07'){
            $leavetype = 'military';
        }else if($numberleavetype == '8' || $numberleavetype == '08'){
            $leavetype = 'train';
        }else if($numberleavetype == '9' || $numberleavetype == '09'){
            $leavetype = 'abroad';
        }else if($numberleavetype == '10'){
            $leavetype = 'mate';
        }else if($numberleavetype == '11'){
            $leavetype = 'restore';
        }else if($numberleavetype == '12'){
            $leavetype = 'resign';
        }else if($numberleavetype == '13'){
            $leavetype = 'sicklow';
        }

        $reason =  DB::table('gleave_reason')->get();
        $infonation =  DB::table('hrd_nationality')->get();
              
          $yearbudget = $infoleave->LEAVE_YEAR_ID;

          $dateuse = DB::table('gleave_register')
          ->where('LEAVE_YEAR_ID','=',$yearbudget )
          ->where('LEAVE_TYPE_CODE','=','04' )
          ->where('LEAVE_PERSON_ID','=',$iduser )
          ->where(function($q){
              $q->where('LEAVE_STATUS_CODE','=','Approve'); 
              $q->orwhere('LEAVE_STATUS_CODE','=','Pending');  
              $q->orwhere('LEAVE_STATUS_CODE','=','Verify');
              $q->orwhere('LEAVE_STATUS_CODE','=','Allow');
            
          })
          ->sum('WORK_DO');
      


        $datehaveyear = DB::table('gleave_over')
        ->where('PERSON_ID','=',$iduser )
        ->where('OVER_YEAR_ID','=',$yearbudget )
        ->sum('DAY_LEAVE_OVER_BEFORE');
    
        
        if($datehaveyear !== 0 && $datehaveyear !== null && $datehaveyear !== ''){
            $datebalance = $datehaveyear  - $dateuse;
        }else{
            $datebalance = 0;    
        }




         return view('person_leave.personinfoleavesick_edit',[
             'inforpersonuser' => $inforpersonuser,
             'inforpersonuserid' => $inforpersonuserid,
             'budgetyears' => $budgetyear,
             'locations' => $location,
             'daytypes' => $daytype,
             'leavetype' => $leavetype,
             'LEAVEWORK_SENDs' => $LEAVEWORK_SEND,
             'leaders' => $leader,
             'reasons' => $reason,
             'infonations' => $infonation,
             'leader_alls' =>$leader_all,
             'infoleave'=> $infoleave,
             'datebalance' =>$datebalance,

         ]);
    }

    public function update(Request $request)
    {
        $id = $request->ID;
        $type_leave = $request->LEAVE_TYPE_CODE;
        $date_bigen = $request->date_bigen;
        $date_end = $request->date_end;
        $DAYTYPE_ID= $request->DAY_TYPE_ID;


    if($date_bigen != ''){

            $date_bigen_c = Carbon::createFromFormat('d/m/Y', $date_bigen)->format('Y-m-d');
            $date_arrary=explode("-",$date_bigen_c);
      
            $y_sub = $date_arrary[0]; 
            
            if($y_sub >= 2500){
                $y = $y_sub-543;
            }else{
                $y = $y_sub;
            }
               
            $m = $date_arrary[1];
            $d = $date_arrary[2];  

            $displaydate_bigen= $y."-".$m."-".$d;
            }else{
            $displaydate_bigen= null;
            }

            
       

        if($date_end != ''){
            $date_end_c = Carbon::createFromFormat('d/m/Y', $date_end)->format('Y-m-d');
            $date_arrary_e=explode("-",$date_end_c);
            $y_sub = $date_arrary_e[0]; 
            
            if($y_sub >= 2500){
                $y_e = $y_sub-543;
            }else{
                $y_e = $y_sub;
            }
               
            $m_e = $date_arrary_e[1];
            $d_e = $date_arrary_e[2];  
            $displaydate_end= $y_e."-".$m_e."-".$d_e;
            }else{
            $displaydate_end= null;
            }



            if( strtotime($displaydate_end)== strtotime($displaydate_bigen) and ($DAYTYPE_ID == '02' || $DAYTYPE_ID == '03'|| $DAYTYPE_ID == '2' || $DAYTYPE_ID == '3')){
                $sumdate = 1;
            }else{
                $sumdate = round(abs(strtotime($displaydate_end) - strtotime($displaydate_bigen))/60/60/24)+1;
            }


            date_default_timezone_set('Asia/Bangkok');

     $date = $displaydate_bigen;
     $end_date = $displaydate_end;




     $intHoliday=0;
     $intPublicHoliday=0;
     while (strtotime($date) <= strtotime($end_date)) {

        $count= DB::table('gleave_holiday')
              ->where('gleave_holiday.DATE_HOLIDAY',$date)
              ->count();

        $DayOfWeek = date("w", strtotime($date));
         if($DayOfWeek == 0 or $DayOfWeek ==6)  // 0 = Sunday, 6 = Saturday;
         {
             $intHoliday++;
         }elseif($count== 1)
         {
             $intPublicHoliday++;

         }

         $date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
     }


     
    

     $checkholiday =  Person::where('hrd_person.ID','=',$request->LEAVE_PERSON_ID)->first();
//----------------------------คำนวนวันทำการ
                    if($request->DATE_OFF == '' || $request->DATE_OFF== null){
                        $amountdateoff =  0;
                    }else{
                        $amountdateoff =  $request->DATE_OFF;
                    }
    
         //----------------------------คำนวนวันทำการ
         if($type_leave== '02' || $type_leave== '05' || $type_leave== '07' || $type_leave== '08' || $type_leave== '09' || $type_leave== '10'){
            $datework = $sumdate;
        }else{

            if($checkholiday->LEAVEDAY_ACTIVE == 'True'){

                if($DAYTYPE_ID == '02' || $DAYTYPE_ID == '03'|| $DAYTYPE_ID == '2' || $DAYTYPE_ID == '3'){
                     
                    $datework = ($sumdate- $amountdateoff )-0.5;
                }else{
                    $datework = $sumdate - $amountdateoff;
                }
            
            }else{
                if($DAYTYPE_ID == '02' || $DAYTYPE_ID == '03'|| $DAYTYPE_ID == '2' || $DAYTYPE_ID == '3'){
                   
                    $datework = ($sumdate - ($intHoliday + $intPublicHoliday)) - 0.5;
                     
                }else{
                    $datework = $sumdate - ($intHoliday + $intPublicHoliday);
                }
            }

        }
        

        $leavesickedit = Leave_register::find($id);

        $leavesickedit->LEAVE_YEAR_ID = $request->LEAVE_YEAR_ID;
        $leavesickedit->LOCATION_ID = $request->LOCATION_ID;
        $leavesickedit->LEAVE_BECAUSE = $request->LEAVE_BECAUSE;
        $leavesickedit->LEAVE_DATE_BEGIN = $displaydate_bigen;
        $leavesickedit->LEAVE_DATE_END = $displaydate_end;
        $leavesickedit->DAY_TYPE_ID = $request->DAY_TYPE_ID;
        $leavesickedit->LEAVE_CONTACT_PHONE = $request->LEAVE_CONTACT_PHONE;
        $leavesickedit->LEAVE_WORK_SEND_ID = $request->LEAVE_WORK_SEND_ID;
        $leavesickedit->LEAVE_CONTACT = $request->LEAVE_CONTACT;
        $leavesickedit->LEADER_PERSON_ID = $request->LEADER_PERSON_ID;
        $leavesickedit->LEADER_DEP_PERSON_ID = $request->LEADER_DEP_PERSON_ID;

      
        if($type_leave != '12'){
           
            $leavesickedit->DATE_OFF =  $amountdateoff;
            }

        $leavesickedit->LEAVE_COMMENT_BY = $request->LEAVE_COMMENT_BY;
        $leavesickedit->WORK_DO = $datework;

        $leavesickedit->save();


        $infoleave = Leave_register::where('ID','=',$id)->first();

        if($infoleave->LEAVE_TYPE_CODE == 4){

        
            $yearbudget = $infoleave->LEAVE_YEAR_ID;
            $id_user = $infoleave->LEAVE_PERSON_ID;

            $dateuse = DB::table('gleave_register')
            ->where('LEAVE_YEAR_ID','=',$yearbudget )
            ->where('LEAVE_TYPE_CODE','=','04' )
            ->where('LEAVE_PERSON_ID','=',$id_user )
            ->where(function($q){
                $q->where('LEAVE_STATUS_CODE','=','Approve'); 
                $q->orwhere('LEAVE_STATUS_CODE','=','Pending');  
                $q->orwhere('LEAVE_STATUS_CODE','=','Verify');
                $q->orwhere('LEAVE_STATUS_CODE','=','Allow');
              
            })
            ->sum('WORK_DO');
        
            $datehaveyear = DB::table('gleave_over')
            ->where('PERSON_ID','=',$id_user )
            ->where('OVER_YEAR_ID','=',$yearbudget )
            ->sum('DAY_LEAVE_OVER_BEFORE');
        

            if($datehaveyear !== 0 && $datehaveyear !== null && $datehaveyear !== ''){
                $datebalance = $datehaveyear  - $dateuse;
            }else{
                $datebalance = 0;    
            }
          

            $leavedatebalance = Leave_register::find($id);
            $leavedatebalance->LEAVE_BALANCE_DATE = $datebalance;
            $leavedatebalance->save();

         }

            return redirect()->route('leave.inforuser',['iduser'=>  $request->LEAVE_PERSON_ID]);
    }




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

        $inforleave=  Leave_register::leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_ID')
        ->leftJoin('gleave_status','gleave_register.LEAVE_STATUS_CODE','=','gleave_status.STATUS_CODE')
        ->leftJoin('gleave_location','gleave_register.LOCATION_ID','=','gleave_location.LOCATION_ID')
        ->where('gleave_register.ID','=',$id)
        ->first();

        return view('person_leave.personinfoleavecancel',[
            'inforpersonuser' => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid,
            'inforleave' => $inforleave
        ]);
    }


  public function updatecancel(Request $request)
  {


      $id = $request->ID;

      $statuscode =  $request->LEAVE_STATUS_CODE;

               
      $updateapp = Leave_register::find($id);
      $updateapp->LEAVE_CANCEL_COMMENT = $request->COMMENT;
      $updateapp->LEAVE_STATUS_CODE = $statuscode;
      $updateapp->save();


          //แจ้งเตือนผู้บังคับัญชา        
      function DateThailinecar($strDate)
      {
        $strYear = date("Y",strtotime($strDate))+543;
        $strMonth= date("n",strtotime($strDate));
        $strDay= date("j",strtotime($strDate));

        $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
        $strMonthThai=$strMonthCut[$strMonth];
        return "$strDay $strMonthThai $strYear";
        }

          $header = "ข้อมูลการลา";
           
          $infoleave = Leave_register::where('ID','=',$id)->first();
          

          $datebegin = DateThailinecar($infoleave->LEAVE_DATE_BEGIN); 
          $backtime = DateThailinecar($infoleave->LEAVE_DATE_END);           
            
          $leave_type = DB::table('gleave_type')->where('LEAVE_TYPE_ID','=',$infoleave->LEAVE_TYPE_CODE)->first(); 
          $hrd_department = DB::table('hrd_department')->where('HR_DEPARTMENT_ID','=',$infoleave->LEAVE_DEPARTMENT_ID)->first(); 
          
     
  


         $message = $header.
             "\n"."ประเภท : " . $leave_type->LEAVE_TYPE_NAME .
             "\n"."เหตุผล : " . $infoleave->LEAVE_BECAUSE .
             "\n"."ผู้ลา : " . $infoleave->LEAVE_PERSON_FULLNAME .
             "\n"."หน่วยงาน : " . $hrd_department->HR_DEPARTMENT_NAME  .
             "\n"."ผู้รับมอบ : " . $infoleave->LEAVE_WORK_SEND .
             "\n"."ตั้งแต่วันที่ : " . $datebegin .               
             "\n"."ถึงวันที่ : " . $backtime .    
             "\n"."จำนวน : " . $infoleave->WORK_DO ." วัน" .
             "\n"."เหตุผลยกเลิก : " . $infoleave->LEAVE_CANCEL_COMMENT .          
             "\n"."สถานะ :  แจ้งยกเลิก" ;  
           
     
                 $name = DB::table('hrd_person')->where('ID','=', $infoleave->LEADER_PERSON_ID)->first();        
                

                 if($name == null){
                    $test ='';
                  }else{
                    $test =$name->HR_LINE;
                  }

                 if($test !== '' && $test !== null){
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
                 }

                 ///=====แจ้งกลุ่มผู้ตรวจสอบ

              $name2 = DB::table('line_token')->where('ID_LINE_TOKEN','=','8')->first();        
            
              if($name2 == null){
                $test2 ='';
              }else{
                $test2 =$name2->LINE_TOKEN;
              }
              if($test2 !== '' && $test2 !== null){
               $chOne2 = curl_init();
              curl_setopt( $chOne2, CURLOPT_URL, "https://notify-api.line.me/api/notify");
              curl_setopt( $chOne2, CURLOPT_SSL_VERIFYHOST, 0);
              curl_setopt( $chOne2, CURLOPT_SSL_VERIFYPEER, 0);
              curl_setopt( $chOne2, CURLOPT_POST, 1);
              curl_setopt( $chOne2, CURLOPT_POSTFIELDS, $message);
              curl_setopt( $chOne2, CURLOPT_POSTFIELDS, "message=$message");
              curl_setopt( $chOne2, CURLOPT_FOLLOWLOCATION, 1);
              $headers2 = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$test2.'', );
              curl_setopt($chOne2, CURLOPT_HTTPHEADER, $headers2);
              curl_setopt( $chOne2, CURLOPT_RETURNTRANSFER, 1);
              $result2 = curl_exec( $chOne2 );
              if(curl_error($chOne2)) { echo 'error:' . curl_error($chOne2); }
              else { $result_ = json_decode($result2, true);
              echo "status : ".$result_['status']; echo "message : ". $result_['message']; }
              curl_close( $chOne2 );
              }

    
              return redirect()->route('leave.inforuser',['iduser'=>  $request->PERSON_ID]);
          
  }

  public function cancelver(Request $request,$id,$iduser)
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

        $inforleave=  Leave_register::leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_ID')
        ->leftJoin('gleave_status','gleave_register.LEAVE_STATUS_CODE','=','gleave_status.STATUS_CODE')
        ->leftJoin('gleave_location','gleave_register.LOCATION_ID','=','gleave_location.LOCATION_ID')
        ->where('gleave_register.ID','=',$id)
        ->first();

        return view('person_leave.personinfoleavecancelver',[
            'inforpersonuser' => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid,
            'inforleave' => $inforleave
        ]);
    }


  public function updatecancelver(Request $request)
  {
      $id = $request->ID;

      $statuscode =  $request->LEAVE_STATUS_CODE;


        $updateapp = Leave_register::find($id);
        $updateapp->LEAVE_CANCEL_COMMENT = $request->COMMENT;
        $updateapp->LEAVE_STATUS_CODE = $statuscode;
        $updateapp->save();

            return redirect()->route('leave.inforver',['iduser'=>  $request->PERSON_ID]);

  }


  //----------------------------------------------เห็นชอบ---------------------------------------------------

  public function app(Request $request,$id,$iduser)
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

      $inforleave=  Leave_register::leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_ID')
      ->leftJoin('gleave_status','gleave_register.LEAVE_STATUS_CODE','=','gleave_status.STATUS_CODE')
      ->leftJoin('gleave_location','gleave_register.LOCATION_ID','=','gleave_location.LOCATION_ID')
      ->where('gleave_register.ID','=',$id)
      ->first();

      return view('person_leave.personinfoleaveapproved',[
          'inforpersonuser' => $inforpersonuser,
          'inforpersonuserid' => $inforpersonuserid,
          'inforleave' => $inforleave
      ]);
  }


  public function updateapp(Request $request)
  {
      $id = $request->ID;
      $CHECK_TYPEAPP = $request->CHECK_TYPEAPP;

      $check =  $request->SUBMIT;

    if($CHECK_TYPEAPP == 'FORCANCEL'){

        if($check == 'approved'){
            $statuscode = 'Appcancel';
            $detail ='เห็นชอบยกเลิก';
            $status_H1 = 'APP';
          }else{
            $statuscode = 'Disappcancel';
            $detail ='ไม่เห็นชอบยกเลิก';
            $status_H1 = 'NOTAPP';
          }

    }else{

        if($check == 'approved'){
            $statuscode = 'Approve';
            $detail ='เห็นชอบ';
            $status_H1 = 'APP';
          }else{
            $statuscode = 'Disapprove';
            $detail ='ไม่เห็นชอบ';
            $status_H1 = 'NOTAPP';
          }

    }
    
    date_default_timezone_set('Asia/Bangkok');


        $updateapp = Leave_register::find($id);
        $updateapp->ACCEPT_COMMENT = $request->COMMENT;
        $updateapp->LEAVE_STATUS_CODE = $statuscode;
        $updateapp->LEAVE_APP_H1 = $status_H1;
        $updateapp->LEAVE_POSITION_DATE = date('Y-m-d H:i:s');
        $updateapp->save();


        function DateThailinecar($strDate)
        {
          $strYear = date("Y",strtotime($strDate))+543;
          $strMonth= date("n",strtotime($strDate));
          $strDay= date("j",strtotime($strDate));
  
          $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
          $strMonthThai=$strMonthCut[$strMonth];
          return "$strDay $strMonthThai $strYear";
          }

        $header = "ข้อมูลการลา";
           
        $infoleave = Leave_register::where('ID','=',$id)->first();
        

        $datebegin = DateThailinecar($infoleave->LEAVE_DATE_BEGIN); 
        $backtime = DateThailinecar($infoleave->LEAVE_DATE_END);           
          
        $leave_type = DB::table('gleave_type')->where('LEAVE_TYPE_ID','=',$infoleave->LEAVE_TYPE_CODE)->first(); 
        $hrd_department = DB::table('hrd_department')->where('HR_DEPARTMENT_ID','=',$infoleave->LEAVE_DEPARTMENT_ID)->first(); 
        
   

        $countperson = DB::table('gleave_permis_level')->where('PERSON_ID','=',$infoleave->LEAVE_PERSON_ID)->count();

        if($countperson > 0){
         $checkuaerlevel = '1';
        }else{
         $checkuaerlevel = '2';
        } 

        if( $checkuaerlevel == '2'){


       $message = $header.
           "\n"."ประเภท : " . $leave_type->LEAVE_TYPE_NAME .
           "\n"."เหตุผล : " . $infoleave->LEAVE_BECAUSE .
           "\n"."ผู้ลา : " . $infoleave->LEAVE_PERSON_FULLNAME .
           "\n"."หน่วยงาน : " . $hrd_department->HR_DEPARTMENT_NAME  .
           "\n"."ผู้รับมอบ : " . $infoleave->LEAVE_WORK_SEND .
           "\n"."ตั้งแต่วันที่ : " . $datebegin .               
           "\n"."ถึงวันที่ : " . $backtime .    
           "\n"."จำนวน : " . $infoleave->WORK_DO ." วัน" .      
           "\n"."สถานะ :  ". $detail;  
           ///=====แจ้งกลุ่มผู้ตรวจสอบ

           $name2 = DB::table('line_token')->where('ID_LINE_TOKEN','=','8')->first();        
         

           if($name2 == null){
            $test2 ='';
          }else{
            $test2 =$name2->LINE_TOKEN;
          }

           if($test2 !== '' && $test2 !== null){
            $chOne2 = curl_init();
           curl_setopt( $chOne2, CURLOPT_URL, "https://notify-api.line.me/api/notify");
           curl_setopt( $chOne2, CURLOPT_SSL_VERIFYHOST, 0);
           curl_setopt( $chOne2, CURLOPT_SSL_VERIFYPEER, 0);
           curl_setopt( $chOne2, CURLOPT_POST, 1);
           curl_setopt( $chOne2, CURLOPT_POSTFIELDS, $message);
           curl_setopt( $chOne2, CURLOPT_POSTFIELDS, "message=$message");
           curl_setopt( $chOne2, CURLOPT_FOLLOWLOCATION, 1);
           $headers2 = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$test2.'', );
           curl_setopt($chOne2, CURLOPT_HTTPHEADER, $headers2);
           curl_setopt( $chOne2, CURLOPT_RETURNTRANSFER, 1);
           $result2 = curl_exec( $chOne2 );
           if(curl_error($chOne2)) { echo 'error:' . curl_error($chOne2); }
           else { $result_ = json_decode($result2, true);
           echo "status : ".$result_['status']; echo "message : ". $result_['message']; }
           curl_close( $chOne2 );
           }

        }
            return redirect()->route('leave.inforapp',['iduser'=>  $request->PERSON_ID]);

  }
//====================================================verify======================


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

    $inforleave=  Leave_register::select('ID','LEAVE_BECAUSE','WORK_DO','LEAVE_DATE_END','LEAVE_DATE_BEGIN','LEAVE_WORK_SEND','LEAVE_CONTACT_PHONE','LOCATION_NAME','LEAVE_TYPE_NAME','LEAVE_PERSON_FULLNAME','LEAVE_YEAR_ID','STATUS_NAME','STATUS_CODE','gleave_register.created_at','LEAVE_CONTACT','LEAVE_SUM_ALL','WORK_DO','LEAVE_SUM_HOLIDAY','LEAVE_SUM_SETSUN','LEAVE_COMMENT_BY','LEAVE_APP_H1','LEAVE_APP_H2','LEAVE_PERSON_ID','LEAVE_APP_SEND')
    ->leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_ID')
    ->leftJoin('gleave_status','gleave_register.LEAVE_STATUS_CODE','=','gleave_status.STATUS_CODE')
    ->leftJoin('gleave_location','gleave_register.LOCATION_ID','=','gleave_location.LOCATION_ID')
    ->where(function($q){
        $q->where('LEAVE_STATUS_CODE','=','Approve');
      
    }) 
    ->orderBy('gleave_register.ID', 'desc')
    ->get();

    $infostatus =  LeaveStatus::get();

    $m_budget = date("m");
    if($m_budget>9){
    $yearbudget = date("Y")+544;
    }else{
    $yearbudget = date("Y")+543;
    }
    
    $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
     
        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';
        $status = 'Approve';
        $search = '';
        $year_id = $yearbudget;

    return view('person_leave.personinfoleavever',[
        'inforpersonuser' => $inforpersonuser,
        'inforpersonuserid' => $inforpersonuserid,
        'inforleaves' => $inforleave,
        'infostatuss'=>$infostatus,
        'displaydate_bigen'=> $displaydate_bigen, 
        'displaydate_end'=> $displaydate_end,
        'status_check' => $status,
        'search' => $search,
        'budgets' => $budget,
        'year_id'=>$year_id 
    ]);
}

public function searchver(Request $request,$iduser)
    {
        $search = $request->get('search');
        $status = $request->STATUS_CODE;
        $datebigin = $request->get('DATE_BIGIN');
        $dateend = $request->get('DATE_END');
        $yearbudget = $request->BUDGET_YEAR;


        if($search==''){
            $search="";
        }
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

        if( $datebigin != '' && $dateend != ''){

            $date_bigen_c = Carbon::createFromFormat('d/m/Y', $datebigin)->format('Y-m-d');
            $date_arrary=explode("-",$date_bigen_c);
            if($date_arrary[0] >= 2500){
                $y = $date_arrary[0]-543;
            }else{
                $y = $date_arrary[0];
            }
    
            $m = $date_arrary[1];
            $d = $date_arrary[2];  
            $displaydate_bigen= $y."-".$m."-".$d;
      
            $date_end_c = Carbon::createFromFormat('d/m/Y', $dateend)->format('Y-m-d');
            $date_arrary_e=explode("-",$date_end_c); 
    
            if($date_arrary_e[0]>= 2500){
                $y_e = $date_arrary_e[0]-543;
            }else{
                $y_e = $date_arrary_e[0];
            }
            $m_e = $date_arrary_e[1];
            $d_e = $date_arrary_e[2];  
            $displaydate_end= $y_e."-".$m_e."-".$d_e;

            $from = date($displaydate_bigen);
            $to = date($displaydate_end);

        if($status == null){
            $inforleave=  Leave_register::select('ID','LEAVE_BECAUSE','WORK_DO','LEAVE_DATE_END','LEAVE_DATE_BEGIN','LEAVE_WORK_SEND','LEAVE_CONTACT_PHONE','LOCATION_NAME','LEAVE_TYPE_NAME','LEAVE_PERSON_FULLNAME','LEAVE_YEAR_ID','STATUS_NAME','STATUS_CODE','gleave_register.created_at','LEAVE_CONTACT','LEAVE_SUM_ALL','WORK_DO','LEAVE_SUM_HOLIDAY','LEAVE_SUM_SETSUN','LEAVE_COMMENT_BY','LEAVE_APP_H1','LEAVE_APP_H2','LEAVE_PERSON_ID','LEAVE_APP_SEND')
                ->leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_ID')
            ->leftJoin('gleave_status','gleave_register.LEAVE_STATUS_CODE','=','gleave_status.STATUS_CODE')
            ->leftJoin('gleave_location','gleave_register.LOCATION_ID','=','gleave_location.LOCATION_ID')
            ->where(function($q) use ($search){
                $q->where('LEAVE_YEAR_ID','like','%'.$search.'%');
                $q->orwhere('LEAVE_PERSON_FULLNAME','like','%'.$search.'%');
                $q->orwhere('LEAVE_TYPE_NAME','like','%'.$search.'%');
                $q->orwhere('LEAVE_BECAUSE','like','%'.$search.'%');

            })
            ->WhereBetween('LEAVE_DATE_BEGIN',[$from,$to])
            ->orderBy('gleave_register.ID', 'desc')
            ->get();
        }else{
            
            
            if($status == 'VER'){
                $inforleave=  Leave_register::select('ID','LEAVE_BECAUSE','WORK_DO','LEAVE_DATE_END','LEAVE_DATE_BEGIN','LEAVE_WORK_SEND','LEAVE_CONTACT_PHONE','LOCATION_NAME','LEAVE_TYPE_NAME','LEAVE_PERSON_FULLNAME','LEAVE_YEAR_ID','STATUS_NAME','STATUS_CODE','gleave_register.created_at','LEAVE_CONTACT','LEAVE_SUM_ALL','WORK_DO','LEAVE_SUM_HOLIDAY','LEAVE_SUM_SETSUN','LEAVE_COMMENT_BY','LEAVE_APP_H1','LEAVE_APP_H2','LEAVE_PERSON_ID','LEAVE_APP_SEND')
                ->leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_ID')
                ->leftJoin('gleave_status','gleave_register.LEAVE_STATUS_CODE','=','gleave_status.STATUS_CODE')
                ->leftJoin('gleave_location','gleave_register.LOCATION_ID','=','gleave_location.LOCATION_ID')
                ->where(function($q){
                    $q->where('LEAVE_STATUS_CODE','=','Approve');
                    $q->orwhere('LEAVE_STATUS_CODE','=','Appcancel');
        
                }) 
                ->where(function($q) use ($search){
                    $q->where('LEAVE_YEAR_ID','like','%'.$search.'%');
                    $q->orwhere('LEAVE_PERSON_FULLNAME','like','%'.$search.'%');  
                    $q->orwhere('LEAVE_TYPE_NAME','like','%'.$search.'%');
                    $q->orwhere('LEAVE_BECAUSE','like','%'.$search.'%');
                  
                })
                ->WhereBetween('LEAVE_DATE_BEGIN',[$from,$to]) 
                ->orderBy('gleave_register.ID', 'desc')    
                ->get();

            }else{
                $inforleave=  Leave_register::select('ID','LEAVE_BECAUSE','WORK_DO','LEAVE_DATE_END','LEAVE_DATE_BEGIN','LEAVE_WORK_SEND','LEAVE_CONTACT_PHONE','LOCATION_NAME','LEAVE_TYPE_NAME','LEAVE_PERSON_FULLNAME','LEAVE_YEAR_ID','STATUS_NAME','STATUS_CODE','gleave_register.created_at','LEAVE_CONTACT','LEAVE_SUM_ALL','WORK_DO','LEAVE_SUM_HOLIDAY','LEAVE_SUM_SETSUN','LEAVE_COMMENT_BY','LEAVE_APP_H1','LEAVE_APP_H2','LEAVE_PERSON_ID','LEAVE_APP_SEND')
                ->leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_ID')
                ->leftJoin('gleave_status','gleave_register.LEAVE_STATUS_CODE','=','gleave_status.STATUS_CODE')
                ->leftJoin('gleave_location','gleave_register.LOCATION_ID','=','gleave_location.LOCATION_ID')
                ->where('LEAVE_STATUS_CODE','=',$status)
                ->where(function($q) use ($search){
                    $q->where('LEAVE_YEAR_ID','like','%'.$search.'%');
                    $q->orwhere('LEAVE_PERSON_FULLNAME','like','%'.$search.'%');  
                    $q->orwhere('LEAVE_TYPE_NAME','like','%'.$search.'%');
                    $q->orwhere('LEAVE_BECAUSE','like','%'.$search.'%');
                  
                })
                ->WhereBetween('LEAVE_DATE_BEGIN',[$from,$to]) 
                ->orderBy('gleave_register.ID', 'desc')    
                ->get();

            }

        }


        }else{
            if($status == null){
            $inforleave=  Leave_register::select('ID','LEAVE_BECAUSE','WORK_DO','LEAVE_DATE_END','LEAVE_DATE_BEGIN','LEAVE_WORK_SEND','LEAVE_CONTACT_PHONE','LOCATION_NAME','LEAVE_TYPE_NAME','LEAVE_PERSON_FULLNAME','LEAVE_YEAR_ID','STATUS_NAME','STATUS_CODE','gleave_register.created_at','LEAVE_CONTACT','LEAVE_SUM_ALL','WORK_DO','LEAVE_SUM_HOLIDAY','LEAVE_SUM_SETSUN','LEAVE_COMMENT_BY','LEAVE_APP_H1','LEAVE_APP_H2','LEAVE_PERSON_ID','LEAVE_APP_SEND')
            ->leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_ID')
            ->leftJoin('gleave_status','gleave_register.LEAVE_STATUS_CODE','=','gleave_status.STATUS_CODE')
            ->leftJoin('gleave_location','gleave_register.LOCATION_ID','=','gleave_location.LOCATION_ID')
            ->where(function($q) use ($search){
                $q->where('LEAVE_YEAR_ID','like','%'.$search.'%');
                $q->orwhere('LEAVE_PERSON_FULLNAME','like','%'.$search.'%');
                $q->orwhere('LEAVE_TYPE_NAME','like','%'.$search.'%');
                $q->orwhere('LEAVE_BECAUSE','like','%'.$search.'%');
            })
            ->orderBy('gleave_register.ID', 'desc')
            ->get();
            }else{

                if($status == 'VER'){

                    $inforleave=  Leave_register::select('ID','LEAVE_BECAUSE','WORK_DO','LEAVE_DATE_END','LEAVE_DATE_BEGIN','LEAVE_WORK_SEND','LEAVE_CONTACT_PHONE','LOCATION_NAME','LEAVE_TYPE_NAME','LEAVE_PERSON_FULLNAME','LEAVE_YEAR_ID','STATUS_NAME','STATUS_CODE','gleave_register.created_at','LEAVE_CONTACT','LEAVE_SUM_ALL','WORK_DO','LEAVE_SUM_HOLIDAY','LEAVE_SUM_SETSUN','LEAVE_COMMENT_BY','LEAVE_APP_H1','LEAVE_APP_H2','LEAVE_PERSON_ID','LEAVE_APP_SEND')
                    ->leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_ID')
                    ->leftJoin('gleave_status','gleave_register.LEAVE_STATUS_CODE','=','gleave_status.STATUS_CODE')
                    ->leftJoin('gleave_location','gleave_register.LOCATION_ID','=','gleave_location.LOCATION_ID')
                    ->where(function($q){
                        $q->where('LEAVE_STATUS_CODE','=','Approve');
                        $q->orwhere('LEAVE_STATUS_CODE','=','Appcancel');
            
                    }) 
                    ->where(function($q) use ($search){
                        $q->where('LEAVE_YEAR_ID','like','%'.$search.'%');
                        $q->orwhere('LEAVE_PERSON_FULLNAME','like','%'.$search.'%');               
                        $q->orwhere('LEAVE_TYPE_NAME','like','%'.$search.'%');
                        $q->orwhere('LEAVE_BECAUSE','like','%'.$search.'%');
                    })
                    ->orderBy('gleave_register.ID', 'desc')    
                    ->get();

                }else{

                    $inforleave=  Leave_register::select('ID','LEAVE_BECAUSE','WORK_DO','LEAVE_DATE_END','LEAVE_DATE_BEGIN','LEAVE_WORK_SEND','LEAVE_CONTACT_PHONE','LOCATION_NAME','LEAVE_TYPE_NAME','LEAVE_PERSON_FULLNAME','LEAVE_YEAR_ID','STATUS_NAME','STATUS_CODE','gleave_register.created_at','LEAVE_CONTACT','LEAVE_SUM_ALL','WORK_DO','LEAVE_SUM_HOLIDAY','LEAVE_SUM_SETSUN','LEAVE_COMMENT_BY','LEAVE_APP_H1','LEAVE_APP_H2','LEAVE_PERSON_ID','LEAVE_APP_SEND')
                    ->leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_ID')
                    ->leftJoin('gleave_status','gleave_register.LEAVE_STATUS_CODE','=','gleave_status.STATUS_CODE')
                    ->leftJoin('gleave_location','gleave_register.LOCATION_ID','=','gleave_location.LOCATION_ID')
                    ->where('LEAVE_STATUS_CODE','=',$status)
                    ->where(function($q) use ($search){
                        $q->where('LEAVE_YEAR_ID','like','%'.$search.'%');
                        $q->orwhere('LEAVE_PERSON_FULLNAME','like','%'.$search.'%');               
                        $q->orwhere('LEAVE_TYPE_NAME','like','%'.$search.'%');
                        $q->orwhere('LEAVE_BECAUSE','like','%'.$search.'%');
                    })
                    ->orderBy('gleave_register.ID', 'desc')    
                    ->get();

                }

            }

        }



         $infostatus =  LeaveStatus::get();
         $year_id = $yearbudget;
         $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();


        return view('person_leave.personinfoleavever',[
            'inforpersonuser' => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid,
            'inforleaves' => $inforleave,
            'infostatuss' => $infostatus,
            'displaydate_bigen'=> $displaydate_bigen, 
            'displaydate_end'=> $displaydate_end,
            'status_check' => $status,
            'search' => $search,
            'year_id'=>$year_id, 
            'budgets' =>  $budget
        ]);



    }




//----------------------------------------------ผ่านการตรวจสอบ---------------------------------------------------

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

    $inforleave=  Leave_register::leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_ID')
    ->leftJoin('gleave_status','gleave_register.LEAVE_STATUS_CODE','=','gleave_status.STATUS_CODE')
    ->leftJoin('gleave_location','gleave_register.LOCATION_ID','=','gleave_location.LOCATION_ID')
    ->where('gleave_register.ID','=',$id)
    ->first();

    return view('person_leave.personinfoleaveverify',[
        'inforpersonuser' => $inforpersonuser,
        'inforpersonuserid' => $inforpersonuserid,
        'inforleave' => $inforleave
    ]);
}


public function updatever(Request $request)
{
    $id = $request->ID;
    $check =  $request->SUBMIT;

    if($check == 'approved'){
      $statuscode = 'Verify';
    }else{
      $statuscode = 'Disverify';
    }

    date_default_timezone_set('Asia/Bangkok');

 

      $updatever = Leave_register::find($id);
      $updatever->LEAVE_STATUS_CODE = $statuscode;
      $updatever->USER_CONFIRM_CHECK = $request->USER_CONFIRM_CHECK;
      $updatever->USER_CONFIRM_CHECK_ID = $request->USER_CONFIRM_CHECK_ID;
      $updatever->CONFIRM_CHECK_DATE = date('Y-m-d H:i:s');
      $updatever->save();

          return redirect()->route('leave.inforver',['iduser'=>  $request->PERSON_ID]);

}
//--------------------------------------------------------------------------------------------------

public function infolastapp(Request $request,$iduser)
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

    $check = Permislist::where('PERSON_ID','=',$iduser)
            ->where('PERMIS_ID','=','GLE001')
            ->count();

    if($check !=0){
    $inforleave=  Leave_register::leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_ID')
    ->leftJoin('gleave_status','gleave_register.LEAVE_STATUS_CODE','=','gleave_status.STATUS_CODE')
    ->leftJoin('gleave_location','gleave_register.LOCATION_ID','=','gleave_location.LOCATION_ID')
    ->where('LEAVE_STATUS_CODE','=','Verify')
    ->orderBy('gleave_register.ID', 'desc')
    ->get();
    }else{

    $inforleave=  Leave_register::leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_ID')
    ->leftJoin('gleave_status','gleave_register.LEAVE_STATUS_CODE','=','gleave_status.STATUS_CODE')
    ->leftJoin('gleave_location','gleave_register.LOCATION_ID','=','gleave_location.LOCATION_ID')
    ->leftJoin('hrd_department','gleave_register.LEAVE_DEPARTMENT_ID','=','hrd_department.HR_DEPARTMENT_ID')
    ->where('LEAVE_STATUS_CODE','=','Verify')
    ->where('hrd_department.LEADER_HR_ID','=',$iduser)
    ->orderBy('gleave_register.ID', 'desc')
    ->get();

    }

    $infostatus =  LeaveStatus::get();



        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;
        }
        
     


        
                $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
                $displaydate_bigen = ($yearbudget-544).'-10-01';
                $displaydate_end = ($yearbudget-543).'-09-30';
                $status = 'Verify';
                $search = '';
                $year_id = $yearbudget;

    return view('person_leave.personinfoleavelastapp',[
        'inforpersonuser' => $inforpersonuser,
        'inforpersonuserid' => $inforpersonuserid,
        'inforleaves' => $inforleave,
        'infostatuss' => $infostatus,
        'displaydate_bigen'=> $displaydate_bigen, 
        'displaydate_end'=> $displaydate_end,
        'status_check' => $status,
        'search' => $search,
        'budgets' =>  $budget,
        'year_id'=>$year_id 

    ]);
}


public function searchlastapp(Request $request,$iduser)
    {
        $search = $request->get('search');
        $status = $request->STATUS_CODE;
        $datebigin = $request->get('DATE_BIGIN');
        $dateend = $request->get('DATE_END');
        $yearbudget = $request->BUDGET_YEAR;


        if($search==''){
            $search="";
        }

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


        $check = Permislist::where('PERSON_ID','=',$iduser)
            ->where('PERMIS_ID','=','GLE001')
            ->count();

        if( $datebigin != '' && $dateend != ''){

            $date_bigen_c = Carbon::createFromFormat('d/m/Y', $datebigin)->format('Y-m-d');
            $date_arrary=explode("-",$date_bigen_c);
            if($date_arrary[0] >= 2500){
                $y = $date_arrary[0]-543;
            }else{
                $y = $date_arrary[0];
            }
    
            $m = $date_arrary[1];
            $d = $date_arrary[2];  
            $displaydate_bigen= $y."-".$m."-".$d;
      
            $date_end_c = Carbon::createFromFormat('d/m/Y', $dateend)->format('Y-m-d');
            $date_arrary_e=explode("-",$date_end_c); 
    
            if($date_arrary_e[0]>= 2500){
                $y_e = $date_arrary_e[0]-543;
            }else{
                $y_e = $date_arrary_e[0];
            }
            $m_e = $date_arrary_e[1];
            $d_e = $date_arrary_e[2];  
            $displaydate_end= $y_e."-".$m_e."-".$d_e;

            $from = date($displaydate_bigen);
            $to = date($displaydate_end);


    if($status == null){

        if($check !=0){
        $inforleave=  Leave_register::leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_ID')
        ->leftJoin('gleave_status','gleave_register.LEAVE_STATUS_CODE','=','gleave_status.STATUS_CODE')
        ->leftJoin('gleave_location','gleave_register.LOCATION_ID','=','gleave_location.LOCATION_ID')
        ->where(function($q) use ($search){
            $q->where('LEAVE_YEAR_ID','like','%'.$search.'%');
            $q->orwhere('LEAVE_PERSON_FULLNAME','like','%'.$search.'%');
            $q->orwhere('LEAVE_TYPE_NAME','like','%'.$search.'%');
            $q->orwhere('LEAVE_BECAUSE','like','%'.$search.'%');

        })
        ->WhereBetween('LEAVE_DATE_BEGIN',[$from,$to])
        ->orderBy('gleave_register.ID', 'desc')
        ->get();
        }else{
            $inforleave=  Leave_register::leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_ID')
            ->leftJoin('gleave_status','gleave_register.LEAVE_STATUS_CODE','=','gleave_status.STATUS_CODE')
            ->leftJoin('gleave_location','gleave_register.LOCATION_ID','=','gleave_location.LOCATION_ID')
            ->where('LEADER_PERSON_ID','=',$iduser)
            ->where(function($q) use ($search){
                $q->where('LEAVE_YEAR_ID','like','%'.$search.'%');
                $q->orwhere('LEAVE_PERSON_FULLNAME','like','%'.$search.'%');
                $q->orwhere('LEAVE_TYPE_NAME','like','%'.$search.'%');
                $q->orwhere('LEAVE_BECAUSE','like','%'.$search.'%');
            })
            ->WhereBetween('LEAVE_DATE_BEGIN',[$from,$to])
            ->orderBy('gleave_register.ID', 'desc')
            ->get();
        }

    }else{

        if($check !=0){
            $inforleave=  Leave_register::leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_ID')
            ->leftJoin('gleave_status','gleave_register.LEAVE_STATUS_CODE','=','gleave_status.STATUS_CODE')
            ->leftJoin('gleave_location','gleave_register.LOCATION_ID','=','gleave_location.LOCATION_ID')
            ->where('LEAVE_STATUS_CODE','=',$status)
            ->where(function($q) use ($search){
                $q->where('LEAVE_YEAR_ID','like','%'.$search.'%');
                $q->orwhere('LEAVE_PERSON_FULLNAME','like','%'.$search.'%');
                $q->orwhere('LEAVE_TYPE_NAME','like','%'.$search.'%');
                $q->orwhere('LEAVE_BECAUSE','like','%'.$search.'%');

            })
            ->WhereBetween('LEAVE_DATE_BEGIN',[$from,$to])
            ->orderBy('gleave_register.ID', 'desc')
            ->get();
            }else{
                $inforleave=  Leave_register::leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_ID')
                ->leftJoin('gleave_status','gleave_register.LEAVE_STATUS_CODE','=','gleave_status.STATUS_CODE')
                ->leftJoin('gleave_location','gleave_register.LOCATION_ID','=','gleave_location.LOCATION_ID')
                ->where('LEAVE_STATUS_CODE','=',$status)
                ->where('LEADER_PERSON_ID','=',$iduser)
                ->where(function($q) use ($search){
                    $q->where('LEAVE_YEAR_ID','like','%'.$search.'%');
                    $q->orwhere('LEAVE_PERSON_FULLNAME','like','%'.$search.'%');
                    $q->orwhere('LEAVE_TYPE_NAME','like','%'.$search.'%');
                    $q->orwhere('LEAVE_BECAUSE','like','%'.$search.'%');
                })
                ->WhereBetween('LEAVE_DATE_BEGIN',[$from,$to])
                ->orderBy('gleave_register.ID', 'desc')
                ->get();
            }


    }

    }else{

    if($status == null){
        if($check !=0){
            $inforleave=  Leave_register::leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_ID')
            ->leftJoin('gleave_status','gleave_register.LEAVE_STATUS_CODE','=','gleave_status.STATUS_CODE')
            ->leftJoin('gleave_location','gleave_register.LOCATION_ID','=','gleave_location.LOCATION_ID')
            ->where(function($q) use ($search){
                $q->where('LEAVE_YEAR_ID','like','%'.$search.'%');
                $q->orwhere('LEAVE_PERSON_FULLNAME','like','%'.$search.'%');
                $q->orwhere('LEAVE_TYPE_NAME','like','%'.$search.'%');
                $q->orwhere('LEAVE_BECAUSE','like','%'.$search.'%');
            })
            ->orderBy('gleave_register.ID', 'desc')
            ->get();
        }else{
          
            $inforleave=  Leave_register::leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_ID')
            ->leftJoin('gleave_status','gleave_register.LEAVE_STATUS_CODE','=','gleave_status.STATUS_CODE')
            ->leftJoin('gleave_location','gleave_register.LOCATION_ID','=','gleave_location.LOCATION_ID')
            ->where('LEADER_PERSON_ID','=',$iduser)
            ->where(function($q) use ($search){
                $q->where('LEAVE_YEAR_ID','like','%'.$search.'%');
                $q->orwhere('LEAVE_PERSON_FULLNAME','like','%'.$search.'%');
                $q->orwhere('LEAVE_TYPE_NAME','like','%'.$search.'%');
                $q->orwhere('LEAVE_BECAUSE','like','%'.$search.'%');
            })
            ->orderBy('gleave_register.ID', 'desc')
            ->get();
        }
    }else{

        if($check !=0){
            $inforleave=  Leave_register::leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_ID')
            ->leftJoin('gleave_status','gleave_register.LEAVE_STATUS_CODE','=','gleave_status.STATUS_CODE')
            ->leftJoin('gleave_location','gleave_register.LOCATION_ID','=','gleave_location.LOCATION_ID')
            ->where('LEAVE_STATUS_CODE','=',$status)
            ->where(function($q) use ($search){
                $q->where('LEAVE_YEAR_ID','like','%'.$search.'%');
                $q->orwhere('LEAVE_PERSON_FULLNAME','like','%'.$search.'%');
                $q->orwhere('LEAVE_TYPE_NAME','like','%'.$search.'%');
                $q->orwhere('LEAVE_BECAUSE','like','%'.$search.'%');
            })
            ->orderBy('gleave_register.ID', 'desc')
            ->get();
        }else{

            $inforleave = Leave_register::leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_ID')
            ->leftJoin('gleave_status','gleave_register.LEAVE_STATUS_CODE','=','gleave_status.STATUS_CODE')
            ->leftJoin('gleave_location','gleave_register.LOCATION_ID','=','gleave_location.LOCATION_ID')
            ->wherer('LEAVE_STATUS_CODE','=',$status)
            ->where('LEADER_PERSON_ID','=',$iduser)
            ->where(function($q) use ($search){
                $q->where('LEAVE_YEAR_ID','like','%'.$search.'%');
                $q->orwhere('LEAVE_PERSON_FULLNAME','like','%'.$search.'%');
                $q->orwhere('LEAVE_TYPE_NAME','like','%'.$search.'%');
                $q->orwhere('LEAVE_BECAUSE','like','%'.$search.'%');
            })
            ->orderBy('gleave_register.ID','desc')
            ->get();

        }
    }

}



         $infostatus =  LeaveStatus::get();
         $year_id = $yearbudget;

         $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();



        return view('person_leave.personinfoleavelastapp',[
            'inforpersonuser' => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid,
            'inforleaves' => $inforleave,
            'infostatuss' => $infostatus,
            'displaydate_bigen'=> $displaydate_bigen, 
            'displaydate_end'=> $displaydate_end,
            'status_check' => $status,
            'search' => $search,    
            'year_id'=>$year_id, 
            'budgets' =>  $budget
        ]);

    }


//--------------------------------------------หน้าอนุมัติ---------------------------------------------------

public function lastapp(Request $request,$id,$iduser)
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

    $inforleave=  Leave_register::leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_ID')
    ->leftJoin('gleave_status','gleave_register.LEAVE_STATUS_CODE','=','gleave_status.STATUS_CODE')
    ->leftJoin('gleave_location','gleave_register.LOCATION_ID','=','gleave_location.LOCATION_ID')
    ->where('gleave_register.ID','=',$id)
    ->first();

    return view('person_leave.personinfoleavelastapproved',[
        'inforpersonuser' => $inforpersonuser,
        'inforpersonuserid' => $inforpersonuserid,
        'inforleave' => $inforleave
    ]);
}


public function updatelastapp(Request $request)
{
    $id = $request->ID;

    $check =  $request->SUBMIT;

    if($check == 'approved'){
      $statuscode = 'Allow';
      $textresult = 'ได้รับการอนุมัติ';
    }else{
      $statuscode = 'Disallow';
      $textresult = 'ไม่ผ่านการอนุมัติ';
    }


      $updatelastapp = Leave_register::find($id);
      $updatelastapp->TOP_LEADER_AC_CMD = $request->COMMENT;
      $updatelastapp->TOP_LEADER_AC_ID = $request->TOP_LEADER_AC_ID;
      $updatelastapp->TOP_LEADER_AC_NAME = $request->TOP_LEADER_AC_NAME;
      $updatelastapp->LEAVE_STATUS_CODE = $statuscode;
      $updatelastapp->save();
        
      function DateThailinecar($strDate)
      {
        $strYear = date("Y",strtotime($strDate))+543;
        $strMonth= date("n",strtotime($strDate));
        $strDay= date("j",strtotime($strDate));

        $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
        $strMonthThai=$strMonthCut[$strMonth];
        return "$strDay $strMonthThai $strYear";
        }


   //แจ้งเตือนผู้ลาเมื่อได้รับอนุมัติ
            
    $leaveinfo = DB::table('gleave_register')->where('ID','=',$id)->first(); 

 
      $header = "ข้อมูลการลา";
      
       $datebegin = DateThailinecar($leaveinfo->LEAVE_DATE_BEGIN); 
       $backtime = DateThailinecar($leaveinfo->LEAVE_DATE_END);           
            
       $infoLEAVE_TYPE_ID = $leaveinfo->LEAVE_TYPE_CODE;
       $infoLEAVE_DEPARTMENT_ID = $leaveinfo->LEAVE_DEPARTMENT_ID;
       $leave_type = DB::table('gleave_type')->where('LEAVE_TYPE_ID','=',$infoLEAVE_TYPE_ID)->first(); 
       $hrd_department = DB::table('hrd_department')->where('HR_DEPARTMENT_ID','=',$infoLEAVE_DEPARTMENT_ID)->first(); 
       

      $message = $header.
          "\n"."ประเภท : " . $leave_type->LEAVE_TYPE_NAME .
          "\n"."เหตุผล : " . $leaveinfo->LEAVE_BECAUSE .
          "\n"."ผู้ลา : " . $leaveinfo->LEAVE_PERSON_FULLNAME .
          "\n"."หน่วยงาน : " . $hrd_department->HR_DEPARTMENT_NAME  .
          "\n"."ผู้รับมอบ : " . $leaveinfo->LEAVE_WORK_SEND .
          "\n"."ตั้งแต่วันที่ : " . $datebegin .               
          "\n"."ถึงวันที่ : " . $backtime .    
          "\n"."จำนวน : " . $leaveinfo->WORK_DO ." วัน" .
          "\n"."ผลการอนุมัติ : " . $textresult ;             
  
              $name = DB::table('hrd_person')->where('ID','=',$leaveinfo->LEAVE_PERSON_ID)->first();           
              
              if($name == null){
                $test ='';
              }else{
                $test =$name->HR_LINE;
              }
              if($test !== '' && $test !== null){ 
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
              }
               
              //แจ้งเตือนผู้รับมอบงาน

              $name2 = DB::table('hrd_person')->where('ID','=',$leaveinfo->LEAVE_WORK_SEND_ID)->first();        
             
              
              if($name2 == null){
                $test2 ='';
              }else{
                $test2 =$name2->HR_LINE;
              }
              if($test2 !== '' && $test2 !== null){ 
               $chOne2 = curl_init();
              curl_setopt( $chOne2, CURLOPT_URL, "https://notify-api.line.me/api/notify");
              curl_setopt( $chOne2, CURLOPT_SSL_VERIFYHOST, 0);
              curl_setopt( $chOne2, CURLOPT_SSL_VERIFYPEER, 0);
              curl_setopt( $chOne2, CURLOPT_POST, 1);
              curl_setopt( $chOne2, CURLOPT_POSTFIELDS, $message);
              curl_setopt( $chOne2, CURLOPT_POSTFIELDS, "message=$message");
              curl_setopt( $chOne2, CURLOPT_FOLLOWLOCATION, 1);
              $headers2 = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$test2.'', );
              curl_setopt($chOne2, CURLOPT_HTTPHEADER, $headers2);
              curl_setopt( $chOne2, CURLOPT_RETURNTRANSFER, 1);
              $result2 = curl_exec( $chOne2 );
              if(curl_error($chOne2)) { echo 'error:' . curl_error($chOne2); }
              else { $result_ = json_decode($result2, true);
              echo "status : ".$result_['status']; echo "message : ". $result_['message']; }
              curl_close( $chOne2 );
              }  

                //แจ้งเตือนกลุ่มหน่วยงาน

                $name3 = DB::table('hrd_department_sub_sub')->where('HR_DEPARTMENT_SUB_SUB_ID','=',$name->HR_DEPARTMENT_SUB_SUB_ID)->first();        
              
                if($name == null){
                    $tokendepsubsub ='';
                  }else{
                    $tokendepsubsub =$name3->LINE_TOKEN;
                  }

                if($tokendepsubsub !== '' && $tokendepsubsub !== null){ 
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
              }

          return redirect()->route('leave.inforlastapp',['iduser'=>  $request->PERSON_ID]);

}



public function updatelastappall(Request $request,$iduser)
{

      $statuscode = 'Allow';
      $check = Permislist::where('PERSON_ID','=',$iduser)
      ->where('PERMIS_ID','=','GLE001')
      ->count();

      $infoleavealls =  Leave_register::where('LEAVE_STATUS_CODE','=','Verify')
      ->where('LEADER_PERSON_ID','=',$iduser)->get();



       if($check !=0){

      $updatelastapp = Leave_register::where('LEAVE_STATUS_CODE','=','Verify')
      ->update(['LEAVE_STATUS_CODE' => $statuscode]);

       }else{

        $updatelastapp = Leave_register::where('LEAVE_STATUS_CODE','=','Verify')
         ->where('LEADER_PERSON_ID','=',$iduser)
         ->update(['LEAVE_STATUS_CODE' => $statuscode]);


       }
   

       function DateThailinecar($strDate)
       {
         $strYear = date("Y",strtotime($strDate))+543;
         $strMonth= date("n",strtotime($strDate));
         $strDay= date("j",strtotime($strDate));
 
         $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
         $strMonthThai=$strMonthCut[$strMonth];
         return "$strDay $strMonthThai $strYear";
         }
 

       

       foreach ($infoleavealls as $infoleaveall){ 


          
    $leaveinfo = DB::table('gleave_register')->where('ID','=',$infoleaveall->ID)->first(); 

    
 
    $header = "ข้อมูลการลา";
    
     $datebegin = DateThailinecar($leaveinfo->LEAVE_DATE_BEGIN); 
     $backtime = DateThailinecar($leaveinfo->LEAVE_DATE_END);           
          
     $infoLEAVE_TYPE_ID = $leaveinfo->LEAVE_TYPE_CODE;
     $infoLEAVE_DEPARTMENT_ID = $leaveinfo->LEAVE_DEPARTMENT_ID;
     $leave_type = DB::table('gleave_type')->where('LEAVE_TYPE_ID','=',$infoLEAVE_TYPE_ID)->first(); 
     $hrd_department = DB::table('hrd_department')->where('HR_DEPARTMENT_ID','=',$infoLEAVE_DEPARTMENT_ID)->first(); 

    $message = $header.
        "\n"."ประเภท : " . $leave_type->LEAVE_TYPE_NAME .
        "\n"."เหตุผล : " . $leaveinfo->LEAVE_BECAUSE .
        "\n"."ผู้ลา : " . $leaveinfo->LEAVE_PERSON_FULLNAME .
        "\n"."หน่วยงาน : " . $hrd_department->HR_DEPARTMENT_NAME  .
        "\n"."ผู้รับมอบ : " . $leaveinfo->LEAVE_WORK_SEND .
        "\n"."ตั้งแต่วันที่ : " . $datebegin .               
        "\n"."ถึงวันที่ : " . $backtime .    
        "\n"."จำนวน : " . $leaveinfo->WORK_DO ." วัน" .
        "\n"."ผลการอนุมัติ : ได้รับการอนุมัติ";             
       
      

            $name = DB::table('hrd_person')->where('ID','=',$leaveinfo->LEAVE_PERSON_ID)->first();        
       
            if($name == null){
                $test ='';
              }else{
                $test =$name->HR_LINE;
              }

              if($test !== '' && $test !== null){ 
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
            }   
             
            //แจ้งเตือนผู้รับมอบงาน

            $name2 = DB::table('hrd_person')->where('ID','=',$leaveinfo->LEAVE_WORK_SEND_ID)->first();        
            if($name2 == null){
                $test2 ='';
              }else{
                $test2 =$name2->HR_LINE;
              }

              if($test2 !== '' && $test2 !== null){ 
             $chOne2 = curl_init();
            curl_setopt( $chOne2, CURLOPT_URL, "https://notify-api.line.me/api/notify");
            curl_setopt( $chOne2, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt( $chOne2, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt( $chOne2, CURLOPT_POST, 1);
            curl_setopt( $chOne2, CURLOPT_POSTFIELDS, $message);
            curl_setopt( $chOne2, CURLOPT_POSTFIELDS, "message=$message");
            curl_setopt( $chOne2, CURLOPT_FOLLOWLOCATION, 1);
            $headers2 = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$test2.'', );
            curl_setopt($chOne2, CURLOPT_HTTPHEADER, $headers2);
            curl_setopt( $chOne2, CURLOPT_RETURNTRANSFER, 1);
            $result2 = curl_exec( $chOne2 );
            if(curl_error($chOne2)) { echo 'error:' . curl_error($chOne2); }
            else { $result_ = json_decode($result2, true);
            echo "status : ".$result_['status']; echo "message : ". $result_['message']; }
            curl_close( $chOne2 );
            }   

              //แจ้งเตือนกลุ่มหน่วยงาน

              $name = DB::table('hrd_department_sub_sub')->where('HR_DEPARTMENT_SUB_SUB_ID','=',$name->HR_DEPARTMENT_SUB_SUB_ID)->first();        
            

              if($name == null){
                $tokendepsubsub ='';
              }else{
                $tokendepsubsub =$name->LINE_TOKEN;
              }
              if($tokendepsubsub !== '' && $tokendepsubsub !== null){ 
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
              }    

        }

          return redirect()->route('leave.inforlastapp',['iduser'=>  $iduser]);

}




   //=========================================functionccheck==================
  public static function checksex($id_user)
  {
       $inforpersonuserid =  Person::where('ID','=',$id_user)->first();
       $sex =$inforpersonuserid -> SEX;
     return $sex;
  }
  

public static function checkduration($id_user)
  {
       $inforpersonuserid =  Person::where('ID','=',$id_user)->first();
       $statwork_date =$inforpersonuserid -> HR_STARTWORK_DATE;

       date_default_timezone_set('Asia/Bangkok');

       $then = strtotime($statwork_date);
       return(floor((time()-$then)/60/60/24))+1;

  }



  function checkdatebegin(Request $request)
  {

    $date_bigin = $request->get('date_bigin');
    $LEAVE_YEAR_ID = $request->get('LEAVE_YEAR_ID');

    $date_bigen_c = Carbon::createFromFormat('d/m/Y', $date_bigin)->format('Y-m-d');
    $date_arrary=explode("-",$date_bigen_c);
   
    if($date_arrary[0]>= 2500){
        $y = $date_arrary[0]-543;
    }else{
        $y = $date_arrary[0];
    }
    $m = $date_arrary[1];
    $d = $date_arrary[2];
    $displaydate_bigin= $y."-".$m."-".$d;


    date_default_timezone_set('Asia/Bangkok');


   $datebutget=  Budgetyear::where('LEAVE_YEAR_ID','=',$LEAVE_YEAR_ID)->first();
   $budget_bigin =  $datebutget->DATE_BEGIN;
   $budget_end = $datebutget->DATE_END;

   if(strtotime($displaydate_bigin) >= strtotime($budget_bigin) && strtotime($displaydate_bigin) <= strtotime($budget_end) ){

    $output='<input type="hidden" name ="checkbigin_date" id="checkbigin_date" value="true">';
   }else{

    $output='*กรุณาเลือกช่วงเวลาให้ตรงกับปีงบประมาณ
    <input type="hidden" name ="checkbigin_date" id="checkbigin_date" value="false">';


}

  echo $output;

  }

  function checkdateend(Request $request)
  {

    $date_end = $request->get('date_end');
    $LEAVE_YEAR_ID = $request->get('LEAVE_YEAR_ID');

    $date_end_c = Carbon::createFromFormat('d/m/Y', $date_end)->format('Y-m-d');
    $date_arrary=explode("-",$date_end_c);
  
    if($date_arrary[0]>= 2500){
        $y = $date_arrary[0]-543;
    }else{
        $y = $date_arrary[0];
    }
    $m = $date_arrary[1];
   $d = $date_arrary[2];
    $displaydate_end= $y."-".$m."-".$d;


    date_default_timezone_set('Asia/Bangkok');


   $datebutget=  Budgetyear::where('LEAVE_YEAR_ID','=',$LEAVE_YEAR_ID)->first();
   $budget_bigin =  $datebutget->DATE_BEGIN;
   $budget_end = $datebutget->DATE_END;

   if(strtotime($displaydate_end) >= strtotime($budget_bigin) && strtotime($displaydate_end) <= strtotime($budget_end) ){

    $output='<input type="hidden" name ="checkend_date" id="checkend_date" value="true">';
   }else{

    $output='*กรุณาเลือกช่วงเวลาให้ตรงกับปีงบประมาณ
    <input type="hidden" name ="checkend_date" id="checkend_date" value="false">';
   }

  echo $output;

  }

  public static function checkleader($id_user)
  {
       $inforpersonuserid =  Person::where('ID','=',$id_user)->first();
       $iddepartment = $inforpersonuserid -> HR_DEPARTMENT_SUB_ID;



    if( $iddepartment == '' ||  $iddepartment == null){
        $idleader = '';
       }else{
        $idleaderdepartment =  DB::table('hrd_department_sub')->where('HR_DEPARTMENT_SUB_ID','=', $iddepartment)
        ->first();

        $idleader = $idleaderdepartment -> LEADER_HR_ID;
       }

       return $idleader;
  }

//--------------------------------------------check permis-------------------------------------

public static function checkapp($id_user)
{
     $count =  LeaveLeader::where('LEADER_ID','=',$id_user)->count();
    return $count;
}

public static function checkver($id_user)
{
     $count =  Permislist::where('PERSON_ID','=',$id_user)
                           ->where('PERMIS_ID','=','GLE003')
                           ->count();

     return $count;
}

public static function checkallow($id_user)
{
     $count_1 =  Permislist::where('PERSON_ID','=',$id_user)
                           ->where('PERMIS_ID','=','GLE001')
                           ->count();
     $count_2 =  Permislist::where('PERSON_ID','=',$id_user)
                           ->where('PERMIS_ID','=','GLE002')
                           ->count();
     $count = $count_1 + $count_2;
     return $count;
}
//-----count----------------------

public static function countapp($id_user)
{
     $count = Leave_register::where('LEADER_PERSON_ID','=',$id_user)
                    ->where(function($q){
                    $q->where('LEAVE_STATUS_CODE','=','Pending');

                })
                ->count();
     return $count;
}
public static function countver($id_user)
{
     $count =  Leave_register::where(function($q){
        $q->where('LEAVE_STATUS_CODE','=','Approve');
        $q->orwhere('LEAVE_STATUS_CODE','=','Appcancel');

    })
                                ->count();
     return $count;
}
public static function countallow($id_user)
{

            $check = Permislist::where('PERSON_ID','=',$id_user)
            ->where('PERMIS_ID','=','GLE001')
            ->count();

        if($check !=0){
            $count =  Leave_register::where('LEAVE_STATUS_CODE','=','Verify')
            ->count();
        
        }else{

            $count =  Leave_register::where('LEAVE_STATUS_CODE','=','Verify')
            ->leftJoin('hrd_department','gleave_register.LEAVE_DEPARTMENT_ID','=','hrd_department.HR_DEPARTMENT_ID')
            ->where('hrd_department.LEADER_HR_ID','=',$id_user)
            ->count();

        }


     return $count;
}

public static function balancerest($id_user,$yearbudget)
{
    //--------------------------------คำนวนวันคงเหลือ----------------------

    $dateuse = DB::table('gleave_register')
    ->where('LEAVE_YEAR_ID','=',$yearbudget )
    ->where('LEAVE_TYPE_CODE','=','04' )
    ->where('LEAVE_PERSON_ID','=',$id_user )
    ->where(function($q){
        $q->where('LEAVE_STATUS_CODE','=','Approve'); 
        $q->orwhere('LEAVE_STATUS_CODE','=','Pending');  
        $q->orwhere('LEAVE_STATUS_CODE','=','Verify');
        $q->orwhere('LEAVE_STATUS_CODE','=','Allow');
      
    })
    ->sum('WORK_DO');

    $datehaveyear = DB::table('gleave_over')
    ->where('PERSON_ID','=',$id_user )
    ->where('OVER_YEAR_ID','=',$yearbudget )
    ->sum('DAY_LEAVE_OVER_BEFORE');

    $datebalance = $datehaveyear  - $dateuse;

    //-------------------------------------------------------------------
     return $datebalance;
}

public static function countsick($id_user,$yearbudget)
    {
        $count =  Leave_register::where('LEAVE_PERSON_ID','=',$id_user)
                                    ->where('LEAVE_YEAR_ID','=',$yearbudget )
                                    ->where('LEAVE_STATUS_CODE','=','Allow')
                                    ->where('LEAVE_TYPE_CODE','=',1 )
                                    ->sum('WORK_DO');
        return $count;
    }

public static function countwork($id_user,$yearbudget)
    {
        $count =  Leave_register::where('LEAVE_PERSON_ID','=',$id_user)
                                    ->where('LEAVE_YEAR_ID','=',$yearbudget )
                                    ->where('LEAVE_STATUS_CODE','=','Allow')
                                    ->where('LEAVE_TYPE_CODE','=',3 )
                                    ->sum('WORK_DO');
        return $count;
    }


//------------------นับจำแนกเดือน-------------------------

public static function countleavemonth($user_id,$yearbudget,$type,$i)
    {

        if($i < 10){
            $count =  Leave_register::where('LEAVE_PERSON_ID','=',$user_id)
            ->where('LEAVE_YEAR_ID','=',$yearbudget )
            ->where('LEAVE_DATE_BEGIN','like','%-0'.$i.'-%')
            ->where('LEAVE_STATUS_CODE','=','Allow')
            ->where('LEAVE_TYPE_CODE','=',$type )
            ->sum('WORK_DO');

        }else{
            $count =  Leave_register::where('LEAVE_PERSON_ID','=',$user_id)
            ->where('LEAVE_YEAR_ID','=',$yearbudget )
            ->where('LEAVE_DATE_BEGIN','like','%-'.$i.'-%')
            ->where('LEAVE_STATUS_CODE','=','Allow')
            ->where('LEAVE_TYPE_CODE','=',$type )
            ->sum('WORK_DO');

        }


        return $count;
    }

public static function sumcountleavemonth($user_id,$yearbudget,$type)
    {
        $count =  Leave_register::where('LEAVE_PERSON_ID','=',$user_id)
                                    ->where('LEAVE_YEAR_ID','=',$yearbudget )
                                    ->where('LEAVE_STATUS_CODE','=','Allow')
                                    ->where('LEAVE_TYPE_CODE','=',$type )
                                    ->sum('WORK_DO');
        return $count;
    }


//-----------------------------------ตรวจสอบวันลาประจำเดือน-----------------------------------------------------------


public static function callleavemonth($id_user)
{
    $date =date("Y-m-d");
    $date_arrary=explode("-",$date);
    $y = $date_arrary[0];
    $m = $date_arrary[1];
    $datecheck= $y."-".$m;

     $sumdate =  Leave_register::where('LEAVE_DATE_BEGIN','like',$datecheck.'%')
                ->where('LEAVE_STATUS_CODE','=','Allow')
                ->where('LEAVE_PERSON_ID','=',$id_user)->sum('WORK_DO');




    return $sumdate;
}

//-------------------------------------checkallsubmit-----------------------------------

function checkall(Request $request)
{

  $leavecode = $request->get('leavecode');
  if($leavecode=='05'){

    $checkcall_date = $request->get('checkcall_date');


    $checkbigin_date = $request->get('checkbigin_date');
    $checkend_date = $request->get('checkend_date');

    $ODEIN_TEMPLE = $request->get('ODEIN_TEMPLE');
    $ODEIN_TEMPLE_ADD = $request->get('ODEIN_TEMPLE_ADD');
    $ODEIN_DATE = $request->get('ODEIN_DATE');
    $ODEN_TEMPLE_LIVE = $request->get('ODEN_TEMPLE_LIVE');
    $ODEN_TEMPLE_LIVE_ADD = $request->get('ODEN_TEMPLE_LIVE_ADD');

    $LEAVE_CONTACT_PHONE= $request->get('LEAVE_CONTACT_PHONE');
    $LEAVE_WORK_SEND_ID= $request->get('LEAVE_WORK_SEND_ID');
    $LEAVE_CONTACT= $request->get('LEAVE_CONTACT');

    $LEADER_PERSON_ID= $request->get('LEADER_PERSON_ID');
    $LEADER_DEP_PERSON_ID= $request->get('LEADER_DEP_PERSON_ID');


     if($checkcall_date == 'true' && $checkbigin_date == 'true' && $checkend_date == 'true'  && $LEAVE_CONTACT_PHONE != ''
     && $LEAVE_WORK_SEND_ID != '' && $LEAVE_CONTACT != '' && $ODEN_TEMPLE_LIVE_ADD != ''&& $ODEIN_TEMPLE != ''&& $ODEIN_TEMPLE_ADD != ''&& $ODEIN_DATE != ''&& $ODEN_TEMPLE_LIVE != ''&& $LEADER_PERSON_ID != ''&& $LEADER_DEP_PERSON_ID != ''){
      $output='<button type="submit"  class="btn btn-hero-sm btn-hero-info" style="font-family: \'Kanit\', sans-serif; font-size: 10px;font-size: 1.0rem;font-weight:normal;"><i class="fas fa-save mr-2"></i>บันทึกข้อมูล</button>';
     }else{
      $output='<button type="button"  class="btn btn-light  btn-lg" style="font-family: \'Kanit\', sans-serif; font-size: 10px;font-size: 1.0rem;font-weight:normal;color: #A9A9A9"><i class="fas fa-save mr-2"></i>บันทึกข้อมูล</button>';
     }


  }else if($leavecode=='06'){


  $checkcall_date = $request->get('checkcall_date');
  $checkbigin_date = $request->get('checkbigin_date');
  $checkend_date = $request->get('checkend_date');

  $LEAVE_CONTACT_PHONE= $request->get('LEAVE_CONTACT_PHONE');
  $LEAVE_WORK_SEND_ID= $request->get('LEAVE_WORK_SEND_ID');
  $LEAVE_CONTACT= $request->get('LEAVE_CONTACT');

  $LEAVE_WORD_BEGIN= $request->get('LEAVE_WORD_BEGIN');
  $LEAVE_MARRY_NAME= $request->get('LEAVE_MARRY_NAME');
  $LEAVE_DATE_SPAWN= $request->get('LEAVE_DATE_SPAWN');
  
  $LEADER_PERSON_ID= $request->get('LEADER_PERSON_ID');
  $LEADER_DEP_PERSON_ID= $request->get('LEADER_DEP_PERSON_ID');


   if($checkcall_date == 'true' && $checkbigin_date == 'true' && $checkend_date == 'true' && $LEAVE_CONTACT_PHONE != ''
   && $LEAVE_WORK_SEND_ID != '' && $LEAVE_CONTACT != ''  && $LEAVE_WORD_BEGIN != '' && $LEAVE_MARRY_NAME != '' && $LEAVE_DATE_SPAWN != '' && $LEADER_PERSON_ID != ''&& $LEADER_DEP_PERSON_ID != ''){
    $output='<button type="submit"  class="btn btn-hero-sm btn-hero-info" style="font-family: \'Kanit\', sans-serif; font-size: 10px;font-size: 1.0rem;font-weight:normal;"><i class="fas fa-save mr-2"></i>บันทึกข้อมูล</button>';
   }else{
    $output='<button type="button"  class="btn btn-light  btn-lg" style="font-family: \'Kanit\', sans-serif; font-size: 10px;font-size: 1.0rem;font-weight:normal;color: #A9A9A9"><i class="fas fa-save mr-2"></i>บันทึกข้อมูล</button>';
   }


  }else if($leavecode=='07'){
  $checkcall_date = $request->get('checkcall_date');
  $checkbigin_date = $request->get('checkbigin_date');
  $checkend_date = $request->get('checkend_date');

  $LEAVE_CONTACT_PHONE= $request->get('LEAVE_CONTACT_PHONE');
  $LEAVE_WORK_SEND_ID= $request->get('LEAVE_WORK_SEND_ID');
  $LEAVE_CONTACT= $request->get('LEAVE_CONTACT');

  $ARMY_BY= $request->get('ARMY_BY');
  $ARMY_NUM= $request->get('ARMY_NUM');
  $ARMY_DATE= $request->get('ARMY_DATE');
  $ARMY_VISIT= $request->get('ARMY_VISIT');
  $ARMY_VISIT_ADD= $request->get('ARMY_VISIT_ADD');

  $LEADER_PERSON_ID= $request->get('LEADER_PERSON_ID');
  $LEADER_DEP_PERSON_ID= $request->get('LEADER_DEP_PERSON_ID');


   if($checkcall_date == 'true' && $checkbigin_date == 'true' && $checkend_date == 'true' && $LEAVE_CONTACT_PHONE != ''
   && $LEAVE_WORK_SEND_ID != '' && $LEAVE_CONTACT != ''  && $ARMY_BY != '' && $ARMY_NUM != ''
   && $ARMY_DATE != '' && $ARMY_VISIT != '' && $ARMY_VISIT_ADD != '' && $LEADER_PERSON_ID != ''&& $LEADER_DEP_PERSON_ID != ''){
    $output='<button type="submit"  class="btn btn-hero-sm btn-hero-info" style="font-family: \'Kanit\', sans-serif; font-size: 10px;font-size: 1.0rem;font-weight:normal;"><i class="fas fa-save mr-2"></i>บันทึกข้อมูล</button>';
   }else{
    $output='<button type="button"  class="btn btn-light  btn-lg" style="font-family: \'Kanit\', sans-serif; font-size: 10px;font-size: 1.0rem;font-weight:normal;color: #A9A9A9"><i class="fas fa-save mr-2"></i>บันทึกข้อมูล</button>';
   }

}else if($leavecode=='08'){

    $checkcall_date = $request->get('checkcall_date');
    $checkbigin_date = $request->get('checkbigin_date');
    $checkend_date = $request->get('checkend_date');
    $LEAVE_CONTACT_PHONE= $request->get('LEAVE_CONTACT_PHONE');
    $LEAVE_WORK_SEND_ID= $request->get('LEAVE_WORK_SEND_ID');
    $LEAVE_CONTACT= $request->get('LEAVE_CONTACT');

    $EDU_SUBJECT = $request->get('EDU_SUBJECT');
    $EDU_BRANCH = $request->get('EDU_BRANCH');
    $EDU_ACADEMY = $request->get('EDU_ACADEMY');
    $EDU_TON= $request->get('EDU_TON');
    $EDU_T_COURSE= $request->get('EDU_T_COURSE');
    $EDU_T_LOCATION= $request->get('EDU_T_LOCATION');

    $LEADER_PERSON_ID= $request->get('LEADER_PERSON_ID');
    $LEADER_DEP_PERSON_ID= $request->get('LEADER_DEP_PERSON_ID');


     if($checkcall_date == 'true' && $LEAVE_CONTACT_PHONE != ''
     && $LEAVE_WORK_SEND_ID != '' && $LEAVE_CONTACT != '' && $EDU_SUBJECT != '' && $EDU_BRANCH != '' && $EDU_ACADEMY != ''
     && $EDU_TON != ''&& $EDU_T_COURSE != ''&& $EDU_T_LOCATION != '' && $LEADER_PERSON_ID != ''&& $LEADER_DEP_PERSON_ID != ''){
      $output='<button type="submit"  class="btn btn-hero-sm btn-hero-info" style="font-family: \'Kanit\', sans-serif; font-size: 10px;font-size: 1.0rem;font-weight:normal;"><i class="fas fa-save mr-2"></i>บันทึกข้อมูล</button>';
     }else{
      $output='<button type="button"  class="btn btn-light  btn-lg" style="font-family: \'Kanit\', sans-serif; font-size: 10px;font-size: 1.0rem;font-weight:normal;color: #A9A9A9"><i class="fas fa-save mr-2"></i>บันทึกข้อมูล</button>';
     }

  }else if($leavecode=='10'){

    $checkcall_date = $request->get('checkcall_date');
  $checkbigin_date = $request->get('checkbigin_date');
  $checkend_date = $request->get('checkend_date');

  $FW_MARRY_SALARY= $request->get('FW_MARRY_SALARY');
  $FW_MARRY= $request->get('FW_MARRY');
  $FW_MARRY_POSITION= $request->get('FW_MARRY_POSITION');
  $FW_MARRY_LEVEL= $request->get('FW_MARRY_LEVEL');
  $FW_MARRY_UNDER= $request->get('FW_MARRY_UNDER');



  $LEAVE_CONTACT_PHONE= $request->get('LEAVE_CONTACT_PHONE');
  $LEAVE_WORK_SEND_ID= $request->get('LEAVE_WORK_SEND_ID');
  $LEAVE_CONTACT= $request->get('LEAVE_CONTACT');

  $LEADER_PERSON_ID= $request->get('LEADER_PERSON_ID');
  $LEADER_DEP_PERSON_ID= $request->get('LEADER_DEP_PERSON_ID');


   if($checkcall_date == 'true' && $checkbigin_date == 'true' && $checkend_date == 'true' && $LEAVE_CONTACT_PHONE != ''
   && $LEAVE_WORK_SEND_ID != '' && $LEAVE_CONTACT != '' && $FW_MARRY_SALARY != ''&& $FW_MARRY != ''&& $FW_MARRY_POSITION != ''
   && $FW_MARRY_LEVEL != ''&& $FW_MARRY_UNDER != '' && $LEADER_PERSON_ID != ''&& $LEADER_DEP_PERSON_ID != ''){
    $output='<button type="submit"  class="btn btn-hero-sm btn-hero-info" style="font-family: \'Kanit\', sans-serif; font-size: 10px;font-size: 1.0rem;font-weight:normal;"><i class="fas fa-save mr-2"></i>บันทึกข้อมูล</button>';
   }else{
    $output='<button type="button"  class="btn btn-light  btn-lg" style="font-family: \'Kanit\', sans-serif; font-size: 10px;font-size: 1.0rem;font-weight:normal;color: #A9A9A9"><i class="fas fa-save mr-2"></i>บันทึกข้อมูล</button>';
   }

  }else if($leavecode=='12'){

    $EXIT_IN_DATE= $request->get('EXIT_IN_DATE');
    $EXIT_PERSON_VCODE= $request->get('EXIT_PERSON_VCODE');
    $EXIT_PERSON_VCODE_DATE= $request->get('EXIT_PERSON_VCODE_DATE');
    $EXIT_SALARY= $request->get('EXIT_SALARY');
    $EXIT_DATE_BEGIN= $request->get('EXIT_DATE_BEGIN');
    $EXIT_DATE_FINISH= $request->get('EXIT_DATE_FINISH');
    $EXIT_BECAUSE= $request->get('EXIT_BECAUSE');


  $LEAVE_WORK_SEND_ID= $request->get('LEAVE_WORK_SEND_ID');
  $LEAVE_CONTACT= $request->get('LEAVE_CONTACT');

  $LEADER_PERSON_ID= $request->get('LEADER_PERSON_ID');
  $LEADER_DEP_PERSON_ID= $request->get('LEADER_DEP_PERSON_ID');


   if( $LEAVE_WORK_SEND_ID != '' && $LEAVE_CONTACT != '' && $EXIT_IN_DATE != '' && $EXIT_PERSON_VCODE != ''
   && $EXIT_PERSON_VCODE_DATE != ''&& $EXIT_SALARY != ''&& $EXIT_DATE_BEGIN != ''&& $EXIT_DATE_FINISH != ''&& $EXIT_BECAUSE != '' && $LEADER_PERSON_ID != ''&& $LEADER_DEP_PERSON_ID != ''){
    $output='<button type="submit"  class="btn btn-hero-sm btn-hero-info" style="font-family: \'Kanit\', sans-serif; font-size: 10px;font-size: 1.0rem;font-weight:normal;"><i class="fas fa-save mr-2"></i>บันทึกข้อมูล</button>';
   }else{
    $output='<button type="button"  class="btn btn-light  btn-lg" style="font-family: \'Kanit\', sans-serif; font-size: 10px;font-size: 1.0rem;font-weight:normal;color: #A9A9A9"><i class="fas fa-save mr-2"></i>บันทึกข้อมูล</button>';
   }

  }else if($leavecode=='02'){
  
    $LEAVE_BECAUSE= $request->get('LEAVE_BECAUSE');
    $LEAVE_CONTACT_PHONE= $request->get('LEAVE_CONTACT_PHONE');
    $LEAVE_WORK_SEND_ID= $request->get('LEAVE_WORK_SEND_ID');
    $LEAVE_CONTACT= $request->get('LEAVE_CONTACT');
  
    $LEADER_PERSON_ID= $request->get('LEADER_PERSON_ID');
    $LEADER_DEP_PERSON_ID= $request->get('LEADER_DEP_PERSON_ID');
  
  
     if($LEAVE_BECAUSE != '' && $LEAVE_CONTACT_PHONE != ''
     && $LEAVE_WORK_SEND_ID != '' && $LEAVE_CONTACT != '' && $LEADER_PERSON_ID != ''&& $LEADER_DEP_PERSON_ID != ''){
      $output='<button type="submit"  class="btn btn-hero-sm btn-hero-info" style="font-family: \'Kanit\', sans-serif; font-size: 10px;font-size: 1.0rem;font-weight:normal;"><i class="fas fa-save mr-2"></i>บันทึกข้อมูล</button>';
     }else{
      $output='<button type="button"  class="btn btn-light  btn-lg" style="font-family: \'Kanit\', sans-serif; font-size: 10px;font-size: 1.0rem;font-weight:normal;color: #A9A9A9"><i class="fas fa-save mr-2"></i>บันทึกข้อมูล</button>';
     }
  
}else{

  $checkcall_date = $request->get('checkcall_date');
  $checkbigin_date = $request->get('checkbigin_date');
  $checkend_date = $request->get('checkend_date');
  $LEAVE_BECAUSE= $request->get('LEAVE_BECAUSE');
  $LEAVE_CONTACT_PHONE= $request->get('LEAVE_CONTACT_PHONE');
  $LEAVE_WORK_SEND_ID= $request->get('LEAVE_WORK_SEND_ID');
  $LEAVE_CONTACT= $request->get('LEAVE_CONTACT');

  $LEADER_PERSON_ID= $request->get('LEADER_PERSON_ID');
  $LEADER_DEP_PERSON_ID= $request->get('LEADER_DEP_PERSON_ID');


   if($checkcall_date == 'true' && $checkbigin_date == 'true' && $checkend_date == 'true' && $LEAVE_BECAUSE != '' && $LEAVE_CONTACT_PHONE != ''
   && $LEAVE_WORK_SEND_ID != '' && $LEAVE_CONTACT != '' && $LEADER_PERSON_ID != ''&& $LEADER_DEP_PERSON_ID != ''){
    $output='<button type="submit"  class="btn btn-hero-sm btn-hero-info" style="font-family: \'Kanit\', sans-serif; font-size: 10px;font-size: 1.0rem;font-weight:normal;"><i class="fas fa-save mr-2"></i>บันทึกข้อมูล</button>';
   }else{
    $output='<button type="button"  class="btn btn-light  btn-lg" style="font-family: \'Kanit\', sans-serif; font-size: 10px;font-size: 1.0rem;font-weight:normal;color: #A9A9A9"><i class="fas fa-save mr-2"></i>บันทึกข้อมูล</button>';
   }

}



echo $output;

}


function pdfsick(Request $request,$id)
{
    $orgname =  DB::table('info_org')
    ->leftJoin('hrd_person','info_org.ORG_LEADER_ID','=','hrd_person.ID')
    ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->first();



    $inforleave=  Leave_register::where('ID','=',$id)
    ->first();

    $iduser = $inforleave->LEAVE_PERSON_ID;
    $idyear = $inforleave->LEAVE_YEAR_ID;

    $inforperson=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
    ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
    ->where('hrd_person.ID','=',$iduser)->first();

    $idworksend = $inforleave->LEAVE_WORK_SEND_ID;
    $infoworksend =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
    ->where('hrd_person.ID','=',$idworksend)->first();

    $idcon = $inforleave->USER_CONFIRM_CHECK_ID;
    $infocon =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
    ->where('hrd_person.ID','=',$idcon)->first();

    $sumsickreal=  Leave_register::where('LEAVE_PERSON_ID','=',$iduser)
    ->where('LEAVE_YEAR_ID','=',$idyear)
    ->where('LEAVE_TYPE_CODE','=','01')
    ->where(function($q){
        $q->where('LEAVE_STATUS_CODE','=','Verify');
        $q->orwhere('LEAVE_STATUS_CODE','=','Allow');
        })
    ->sum('WORK_DO');

    $sumsick = $sumsickreal-$inforleave->WORK_DO;

    $sumwork =  Leave_register::where('LEAVE_PERSON_ID','=',$iduser)
    ->where('LEAVE_YEAR_ID','=',$idyear)
    ->where('LEAVE_TYPE_CODE','=','03')
    ->where('LEAVE_STATUS_CODE','=','Allow')
    ->sum('WORK_DO');


    $sumbirth=  Leave_register::where('LEAVE_PERSON_ID','=',$iduser)
    ->where('LEAVE_YEAR_ID','=',$idyear)
    ->where('LEAVE_TYPE_CODE','=','02')
    ->where('LEAVE_STATUS_CODE','=','Allow')
    ->sum('WORK_DO');


    $idmax = Leave_register::where('LEAVE_STATUS_CODE','=','Allow')
    ->where('LEAVE_TYPE_CODE','=','01')
    ->where('LEAVE_PERSON_ID','=',$iduser)
    ->orderBy('ID', 'desc')
    ->limit(2)
    ->get()
    ->min('ID');
    


    if($idmax == '' || $idmax == null || $idmax == $inforleave->ID){
        $lastsick= '';
    }else{
        $lastsick=  Leave_register::where('ID','=',$idmax)
        ->first();
    }


     
    $sigin1 = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforleave->LEAVE_PERSON_ID)->first();
    $sigin2 = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforleave->LEADER_PERSON_ID)->first();
    $sigin3 = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforleave->LEADER_DEP_PERSON_ID)->first();
    $sigin4 = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$orgname->ORG_LEADER_ID)->first();
    $sigin5 = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforleave->USER_CONFIRM_CHECK_ID)->first();
    $sigin6 = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforleave->LEAVE_PERSON_ID)->first();
    $sigin7 = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforleave->LEAVE_WORK_SEND_ID)->first();
 

    if($sigin1 !== null){
        $sig1 =  $sigin1->FILE_NAME;
    }else{ $sig1 = '';}
    if($sigin2 !== null){
        $sig2 =  $sigin2->FILE_NAME;
    }else{ $sig2 = '';}
    if($sigin3 !== null){
        $sig3 =  $sigin3->FILE_NAME;
    }else{ $sig3 = '';}
    if($sigin4 !== null){
        $sig4 =  $sigin4->FILE_NAME;
    }else{ $sig4 = '';}
    if($sigin5 !== null){
        $sig5 =  $sigin5->FILE_NAME;
    }else{ $sig5 = '';}
    if($sigin6 !== null){
        $sig6 =  $sigin6->FILE_NAME;
    }else{ $sig6 = '';}
    if($sigin7 !== null){
        $sig7 =  $sigin7->FILE_NAME;
    }else{ $sig7 = '';}
   

    $checksig = DB::table('gleave_function')->where('FUNCTION_ID','=',1)->where('ACTIVE','=','True')->count();
    //-----getlevel----------

    $lavel1 = DB::table('hrd_person')->leftJoin('hrd_level','hrd_level.HR_LEVEL_ID','=','hrd_person.HR_LEVEL_ID')
    ->where('ID','=',$inforleave->LEADER_PERSON_ID)->first();
    $lavel2 = DB::table('hrd_person')->leftJoin('hrd_level','hrd_level.HR_LEVEL_ID','=','hrd_person.HR_LEVEL_ID')
    ->where('ID','=',$inforleave->LEADER_DEP_PERSON_ID)->first();
  
    $lavel3 = DB::table('hrd_person')->leftJoin('hrd_level','hrd_level.HR_LEVEL_ID','=','hrd_person.HR_LEVEL_ID')
    ->where('ID','=',$inforleave->USER_CONFIRM_CHECK_ID)->first();
    $lavel4 = DB::table('hrd_person')->leftJoin('hrd_level','hrd_level.HR_LEVEL_ID','=','hrd_person.HR_LEVEL_ID')
    ->where('ID','=',$inforleave->LEAVE_PERSON_ID)->first();
    $lavel5 = DB::table('hrd_person')->leftJoin('hrd_level','hrd_level.HR_LEVEL_ID','=','hrd_person.HR_LEVEL_ID')
    ->where('ID','=',$inforleave->LEAVE_WORK_SEND_ID)->first();
 

    return view('person_leave.pdfsick',[
        'orgname' => $orgname,
        'inforleave' => $inforleave,
        'inforperson' => $inforperson,
        'infoworksend' => $infoworksend,
        'infocon' => $infocon,
        'sumsick' => $sumsick,
        'sumwork' => $sumwork,
        'sumbirth' => $sumbirth,
        'lastsick' => $lastsick,    
        'idyear' => $idyear,
        'sig1' => $sig1, 
        'sig2' => $sig2,      
        'sig3' => $sig3,   
        'sig4' => $sig4,   
        'sig5' => $sig5,   
        'sig6' => $sig6,   
        'sig7' => $sig7,
        'checksig' => $checksig,
        'lavel1' => $lavel1,
        'lavel2' => $lavel2,      
        'lavel3' => $lavel3,
        'lavel4' => $lavel4,
        'lavel5' => $lavel5,


    ]);
}



function pdfwork(Request $request,$id)
{
    $orgname =  DB::table('info_org')
    ->leftJoin('hrd_person','info_org.ORG_LEADER_ID','=','hrd_person.ID')
    ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->first();



    $inforleave=  Leave_register::where('ID','=',$id)
    ->first();

    $iduser = $inforleave->LEAVE_PERSON_ID;
    $idyear = $inforleave->LEAVE_YEAR_ID;

    $inforperson=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
    ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
    ->where('hrd_person.ID','=',$iduser)->first();

    $idworksend = $inforleave->LEAVE_WORK_SEND_ID;
    $infoworksend =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
    ->where('hrd_person.ID','=',$idworksend)->first();

    $idcon = $inforleave->USER_CONFIRM_CHECK_ID;
    $infocon =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
    ->where('hrd_person.ID','=',$idcon)->first();

    $sumsick=  Leave_register::where('LEAVE_PERSON_ID','=',$iduser)
    ->where('LEAVE_YEAR_ID','=',$idyear)
    ->where('LEAVE_TYPE_CODE','=','01')
    ->where('LEAVE_STATUS_CODE','=','Allow')
    ->sum('WORK_DO');

    $sumworkreal =  Leave_register::where('LEAVE_PERSON_ID','=',$iduser)
    ->where('LEAVE_YEAR_ID','=',$idyear)
    ->where('LEAVE_TYPE_CODE','=','03')
    ->where(function($q){
        $q->where('LEAVE_STATUS_CODE','=','Verify');
        $q->orwhere('LEAVE_STATUS_CODE','=','Allow');
        })
    ->sum('WORK_DO');
    $sumwork = $sumworkreal-$inforleave->WORK_DO;

    $sumbirth=  Leave_register::where('LEAVE_PERSON_ID','=',$iduser)
    ->where('LEAVE_YEAR_ID','=',$idyear)
    ->where('LEAVE_TYPE_CODE','=','02')
    ->where('LEAVE_STATUS_CODE','=','Allow')
    ->sum('WORK_DO');


    $idmax = Leave_register::where('LEAVE_STATUS_CODE','=','Allow')
    ->where('LEAVE_TYPE_CODE','=','03')
    ->where('LEAVE_PERSON_ID','=',$iduser)
    ->orderBy('ID', 'desc')
    ->limit(2)
    ->get()
    ->min('ID');
    

    if($idmax == '' || $idmax == null || $idmax == $inforleave->ID){
        $lastswork= '';
    }else{
        $lastswork=  Leave_register::where('ID','=',$idmax)
        ->first();
    }


    
     
    $sigin1 = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforleave->LEAVE_PERSON_ID)->first();
    $sigin2 = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforleave->LEADER_PERSON_ID)->first();
    $sigin3 = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforleave->LEADER_DEP_PERSON_ID)->first();
    $sigin4 = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$orgname->ORG_LEADER_ID)->first();
    $sigin5 = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforleave->USER_CONFIRM_CHECK_ID)->first();
    $sigin6 = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforleave->LEAVE_PERSON_ID)->first();
    $sigin7 = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforleave->LEAVE_WORK_SEND_ID)->first();
 

    if($sigin1 !== null){
        $sig1 =  $sigin1->FILE_NAME;
    }else{ $sig1 = '';}
    if($sigin2 !== null){
        $sig2 =  $sigin2->FILE_NAME;
    }else{ $sig2 = '';}
    if($sigin3 !== null){
        $sig3 =  $sigin3->FILE_NAME;
    }else{ $sig3 = '';}
    if($sigin4 !== null){
        $sig4 =  $sigin4->FILE_NAME;
    }else{ $sig4 = '';}
    if($sigin5 !== null){
        $sig5 =  $sigin5->FILE_NAME;
    }else{ $sig5 = '';}
    if($sigin6 !== null){
        $sig6 =  $sigin6->FILE_NAME;
    }else{ $sig6 = '';}
    if($sigin7 !== null){
        $sig7 =  $sigin7->FILE_NAME;
    }else{ $sig7 = '';}
   

    $checksig = DB::table('gleave_function')->where('FUNCTION_ID','=',1)->where('ACTIVE','=','True')->count();
      //-----getlevel----------

      $lavel1 = DB::table('hrd_person')->leftJoin('hrd_level','hrd_level.HR_LEVEL_ID','=','hrd_person.HR_LEVEL_ID')
      ->where('ID','=',$inforleave->LEADER_PERSON_ID)->first();
      $lavel2 = DB::table('hrd_person')->leftJoin('hrd_level','hrd_level.HR_LEVEL_ID','=','hrd_person.HR_LEVEL_ID')
      ->where('ID','=',$inforleave->LEADER_DEP_PERSON_ID)->first();
    
      $lavel3 = DB::table('hrd_person')->leftJoin('hrd_level','hrd_level.HR_LEVEL_ID','=','hrd_person.HR_LEVEL_ID')
      ->where('ID','=',$inforleave->USER_CONFIRM_CHECK_ID)->first();
      $lavel4 = DB::table('hrd_person')->leftJoin('hrd_level','hrd_level.HR_LEVEL_ID','=','hrd_person.HR_LEVEL_ID')
      ->where('ID','=',$inforleave->LEAVE_PERSON_ID)->first();
      $lavel5 = DB::table('hrd_person')->leftJoin('hrd_level','hrd_level.HR_LEVEL_ID','=','hrd_person.HR_LEVEL_ID')
      ->where('ID','=',$inforleave->LEAVE_WORK_SEND_ID)->first();
   


    return view('person_leave.pdfwork',[
        'orgname' => $orgname,
        'inforleave' => $inforleave,
        'inforperson' => $inforperson,
        'infoworksend' => $infoworksend,
        'infocon' => $infocon,
        'sumsick' => $sumsick,
        'sumwork' => $sumwork,
        'sumbirth' => $sumbirth,
        'lastswork' => $lastswork,
        'idyear' => $idyear,
        'sig1' => $sig1, 
        'sig2' => $sig2,      
        'sig3' => $sig3,   
        'sig4' => $sig4,   
        'sig5' => $sig5,   
        'sig6' => $sig6,   
        'sig7' => $sig7,
        'checksig' => $checksig, 
        'lavel1' => $lavel1,
        'lavel2' => $lavel2,      
        'lavel3' => $lavel3,
        'lavel4' => $lavel4,
        'lavel5' => $lavel5, 

    ]);
}



function pdfspawn(Request $request,$id)
{
    $orgname =  DB::table('info_org')
    ->leftJoin('hrd_person','info_org.ORG_LEADER_ID','=','hrd_person.ID')
    ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->first();


    $inforleave=  Leave_register::where('ID','=',$id)
    ->first();

    $iduser = $inforleave->LEAVE_PERSON_ID;
    $idyear = $inforleave->LEAVE_YEAR_ID;

    $inforperson=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
    ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
    ->where('hrd_person.ID','=',$iduser)->first();

    $idworksend = $inforleave->LEAVE_WORK_SEND_ID;
    $infoworksend =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
    ->where('hrd_person.ID','=',$idworksend)->first();

    $idcon = $inforleave->USER_CONFIRM_CHECK_ID;
    $infocon =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
    ->where('hrd_person.ID','=',$idcon)->first();

    $sumsick=  Leave_register::where('LEAVE_PERSON_ID','=',$iduser)
    ->where('LEAVE_YEAR_ID','=',$idyear)
    ->where('LEAVE_TYPE_CODE','=','01')
    ->where('LEAVE_STATUS_CODE','=','Allow')
    ->sum('WORK_DO');

    $sumwork =  Leave_register::where('LEAVE_PERSON_ID','=',$iduser)
    ->where('LEAVE_YEAR_ID','=',$idyear)
    ->where('LEAVE_TYPE_CODE','=','03')
    ->where('LEAVE_STATUS_CODE','=','Allow')
    ->sum('WORK_DO');


    $sumbirthreal=  Leave_register::where('LEAVE_PERSON_ID','=',$iduser)
    ->where('LEAVE_YEAR_ID','=',$idyear)
    ->where('LEAVE_TYPE_CODE','=','02')
    ->where(function($q){
        $q->where('LEAVE_STATUS_CODE','=','Verify');
        $q->orwhere('LEAVE_STATUS_CODE','=','Allow');
        })
    ->sum('WORK_DO');
     
    $sumbirth = $sumbirthreal-$inforleave->WORK_DO;
 
    $idmax = Leave_register::where('LEAVE_STATUS_CODE','=','Allow')
    ->where('LEAVE_TYPE_CODE','=','02')
    ->where('LEAVE_PERSON_ID','=',$iduser)
    ->orderBy('ID', 'desc')
    ->limit(2)
    ->get()
    ->min('ID');

    if($idmax == '' || $idmax == null || $idmax == $inforleave->ID){
        $lastspawn= '';
    }else{
        $lastspawn=  Leave_register::where('ID','=',$idmax)
        ->first();
    }


    $sigin1 = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforleave->LEAVE_PERSON_ID)->first();
    $sigin2 = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforleave->LEADER_PERSON_ID)->first();
    $sigin3 = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforleave->LEADER_DEP_PERSON_ID)->first();
    $sigin4 = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$orgname->ORG_LEADER_ID)->first();
    $sigin5 = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforleave->USER_CONFIRM_CHECK_ID)->first();
    $sigin6 = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforleave->LEAVE_PERSON_ID)->first();
    $sigin7 = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforleave->LEAVE_WORK_SEND_ID)->first();
 

    if($sigin1 !== null){
        $sig1 =  $sigin1->FILE_NAME;
    }else{ $sig1 = '';}
    if($sigin2 !== null){
        $sig2 =  $sigin2->FILE_NAME;
    }else{ $sig2 = '';}
    if($sigin3 !== null){
        $sig3 =  $sigin3->FILE_NAME;
    }else{ $sig3 = '';}
    if($sigin4 !== null){
        $sig4 =  $sigin4->FILE_NAME;
    }else{ $sig4 = '';}
    if($sigin5 !== null){
        $sig5 =  $sigin5->FILE_NAME;
    }else{ $sig5 = '';}
    if($sigin6 !== null){
        $sig6 =  $sigin6->FILE_NAME;
    }else{ $sig6 = '';}
    if($sigin7 !== null){
        $sig7 =  $sigin7->FILE_NAME;
    }else{ $sig7 = '';}
   

    $checksig = DB::table('gleave_function')->where('FUNCTION_ID','=',1)->where('ACTIVE','=','True')->count();

                //-----getlevel----------

                $lavel1 = DB::table('hrd_person')->leftJoin('hrd_level','hrd_level.HR_LEVEL_ID','=','hrd_person.HR_LEVEL_ID')
                ->where('ID','=',$inforleave->LEADER_PERSON_ID)->first();
                $lavel2 = DB::table('hrd_person')->leftJoin('hrd_level','hrd_level.HR_LEVEL_ID','=','hrd_person.HR_LEVEL_ID')
                ->where('ID','=',$inforleave->LEADER_DEP_PERSON_ID)->first();

                $lavel3 = DB::table('hrd_person')->leftJoin('hrd_level','hrd_level.HR_LEVEL_ID','=','hrd_person.HR_LEVEL_ID')
                ->where('ID','=',$inforleave->USER_CONFIRM_CHECK_ID)->first();
                $lavel4 = DB::table('hrd_person')->leftJoin('hrd_level','hrd_level.HR_LEVEL_ID','=','hrd_person.HR_LEVEL_ID')
                ->where('ID','=',$inforleave->LEAVE_PERSON_ID)->first();
                $lavel5 = DB::table('hrd_person')->leftJoin('hrd_level','hrd_level.HR_LEVEL_ID','=','hrd_person.HR_LEVEL_ID')
                ->where('ID','=',$inforleave->LEAVE_WORK_SEND_ID)->first();




    return view('person_leave.pdfspawn',[
        'orgname' => $orgname,
        'inforleave' => $inforleave,
        'inforperson' => $inforperson,
        'infoworksend' => $infoworksend,
        'infocon' => $infocon,
        'sumsick' => $sumsick,
        'sumwork' => $sumwork,
        'sumbirth' => $sumbirth,
        'lastspawn' => $lastspawn,
        'idyear' => $idyear,
        'sig1' => $sig1, 
        'sig2' => $sig2,      
        'sig3' => $sig3,   
        'sig4' => $sig4,   
        'sig5' => $sig5,   
        'sig6' => $sig6,   
        'sig7' => $sig7,
        'checksig' => $checksig,
        'lavel1' => $lavel1,
        'lavel2' => $lavel2,      
        'lavel3' => $lavel3,
        'lavel4' => $lavel4,
        'lavel5' => $lavel5,   

    ]);
}


function pdfrest(Request $request,$id)
{
    $orgname =  DB::table('info_org')
    ->leftJoin('hrd_person','info_org.ORG_LEADER_ID','=','hrd_person.ID')
    ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->first();



    $inforleave=  Leave_register::where('ID','=',$id)
    ->first();

    $iduser = $inforleave->LEAVE_PERSON_ID;
    $idyear = $inforleave->LEAVE_YEAR_ID;

    $inforperson=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
    ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
    ->where('hrd_person.ID','=',$iduser)->first();

    $idworksend = $inforleave->LEAVE_WORK_SEND_ID;
    $infoworksend =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
    ->where('hrd_person.ID','=',$idworksend)->first();

    $idcon = $inforleave->USER_CONFIRM_CHECK_ID;
    $infocon =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
    ->where('hrd_person.ID','=',$idcon)->first();


    
    $displaydate_bigen = ($idyear-544).'-10-01';
    $displaydate_end = ($idyear-543).'-09-30';

    $from = date($displaydate_bigen);
    $to = date($displaydate_end);

    $sumrest=  Leave_register::where('LEAVE_PERSON_ID','=',$iduser)
    ->where('LEAVE_TYPE_CODE','=','04')
    ->where('LEAVE_STATUS_CODE','=','Allow')
    ->WhereBetween('LEAVE_DATE_BEGIN',[$from,$to])
    ->sum('WORK_DO');


  

    $inforest=  Leave_register::where('ID','=',$id)
    ->first();


    $leaveday =  DB::table('gleave_over')->where('PERSON_ID','=',$iduser)->first();



    $sigin1 = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforleave->LEAVE_PERSON_ID)->first();
    $sigin2 = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforleave->LEADER_PERSON_ID)->first();
    $sigin3 = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforleave->LEADER_DEP_PERSON_ID)->first();
    $sigin4 = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$orgname->ORG_LEADER_ID)->first();
    $sigin5 = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforleave->USER_CONFIRM_CHECK_ID)->first();
    $sigin6 = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforleave->LEAVE_PERSON_ID)->first();
    $sigin7 = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforleave->LEAVE_WORK_SEND_ID)->first();
 

    if($sigin1 !== null){
        $sig1 =  $sigin1->FILE_NAME;
    }else{ $sig1 = '';}
    if($sigin2 !== null){
        $sig2 =  $sigin2->FILE_NAME;
    }else{ $sig2 = '';}
    if($sigin3 !== null){
        $sig3 =  $sigin3->FILE_NAME;
    }else{ $sig3 = '';}
    if($sigin4 !== null){
        $sig4 =  $sigin4->FILE_NAME;
    }else{ $sig4 = '';}
    if($sigin5 !== null){
        $sig5 =  $sigin5->FILE_NAME;
    }else{ $sig5 = '';}
    if($sigin6 !== null){
        $sig6 =  $sigin6->FILE_NAME;
    }else{ $sig6 = '';}
    if($sigin7 !== null){
        $sig7 =  $sigin7->FILE_NAME;
    }else{ $sig7 = '';}
   

    $checksig = DB::table('gleave_function')->where('FUNCTION_ID','=',1)->where('ACTIVE','=','True')->count();
    
    $lavel1 = DB::table('hrd_person')->leftJoin('hrd_level','hrd_level.HR_LEVEL_ID','=','hrd_person.HR_LEVEL_ID')
    ->where('ID','=',$inforleave->LEADER_PERSON_ID)->first();
    $lavel2 = DB::table('hrd_person')->leftJoin('hrd_level','hrd_level.HR_LEVEL_ID','=','hrd_person.HR_LEVEL_ID')
    ->where('ID','=',$inforleave->LEADER_DEP_PERSON_ID)->first();

    $lavel3 = DB::table('hrd_person')->leftJoin('hrd_level','hrd_level.HR_LEVEL_ID','=','hrd_person.HR_LEVEL_ID')
    ->where('ID','=',$inforleave->USER_CONFIRM_CHECK_ID)->first();
    $lavel4 = DB::table('hrd_person')->leftJoin('hrd_level','hrd_level.HR_LEVEL_ID','=','hrd_person.HR_LEVEL_ID')
    ->where('ID','=',$inforleave->LEAVE_PERSON_ID)->first();
    $lavel5 = DB::table('hrd_person')->leftJoin('hrd_level','hrd_level.HR_LEVEL_ID','=','hrd_person.HR_LEVEL_ID')
    ->where('ID','=',$inforleave->LEAVE_WORK_SEND_ID)->first();

    return view('person_leave.pdfrest',[
        'orgname' => $orgname,
        'inforleave' => $inforleave,
        'inforperson' => $inforperson,
        'infoworksend' => $infoworksend,
        'infocon' => $infocon,
        'sumrest' => $sumrest,
        'inforest' => $inforest,
        'leaveday' => $leaveday,
        'idyear' => $idyear,
        'sig1' => $sig1, 
        'sig2' => $sig2,      
        'sig3' => $sig3,   
        'sig4' => $sig4,   
        'sig5' => $sig5,   
        'sig6' => $sig6,   
        'sig7' => $sig7,
        'checksig' => $checksig,  
        'lavel1' => $lavel1,
        'lavel2' => $lavel2,      
        'lavel3' => $lavel3,
        'lavel4' => $lavel4,
        'lavel5' => $lavel5,   
        

    ]);
}

function pdfout(Request $request,$id)
    {
        $orgname =  DB::table('info_org')
        ->leftJoin('hrd_person','info_org.ORG_LEADER_ID','=','hrd_person.ID')
        ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->first();

        $inforleave=  Leave_register::where('ID','=',$id)
        ->first();

        $iduser = $inforleave->LEAVE_PERSON_ID;
        $idyear = $inforleave->LEAVE_YEAR_ID;
    
        $inforperson=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
        ->where('hrd_person.ID','=',$iduser)->first();

        return view('person_leave.pdfout',[
            'orgname' => $orgname,
            'inforleave' => $inforleave,
            'inforperson' => $inforperson,


        ]);
    }
function pdfordain(Request $request,$id)
    {

        $orgname =  DB::table('info_org')
        ->leftJoin('hrd_person','info_org.ORG_LEADER_ID','=','hrd_person.ID')
        ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->first();


        $inforleave=  Leave_register::where('ID','=',$id)
        ->first();

        $iduser = $inforleave->LEAVE_PERSON_ID;
        $idyear = $inforleave->LEAVE_YEAR_ID;
    
        $inforperson=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
        ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
        ->where('hrd_person.ID','=',$iduser)->first();
    
        $idworksend = $inforleave->LEAVE_WORK_SEND_ID;
        $infoworksend =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
        ->where('hrd_person.ID','=',$idworksend)->first();
    
        $idcon = $inforleave->USER_CONFIRM_CHECK_ID;
        $infocon =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
        ->where('hrd_person.ID','=',$idcon)->first();
    
        $sumrest=  Leave_register::where('LEAVE_PERSON_ID','=',$iduser)
        ->where('LEAVE_YEAR_ID','=',$idyear)
        ->where('LEAVE_TYPE_CODE','=','04')
        ->where('LEAVE_STATUS_CODE','=','Allow')
        ->sum('WORK_DO');
    
        $inforperson=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
        ->where('hrd_person.ID','=',$iduser)->first();

        $inforest=  Leave_register::where('ID','=',$id)
        ->first();
    
    
        $leaveday =  DB::table('gleave_over')->where('PERSON_ID','=',$iduser)->first();

        $sigin1 = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforleave->LEAVE_PERSON_ID)->first();
        $sigin2 = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforleave->LEADER_PERSON_ID)->first();
        $sigin3 = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforleave->LEADER_DEP_PERSON_ID)->first();
        $sigin4 = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$orgname->ORG_LEADER_ID)->first();
        $sigin5 = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforleave->USER_CONFIRM_CHECK_ID)->first();
        $sigin6 = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforleave->LEAVE_PERSON_ID)->first();
        $sigin7 = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforleave->LEAVE_WORK_SEND_ID)->first();
     
    
        if($sigin1 !== null){
            $sig1 =  $sigin1->FILE_NAME;
        }else{ $sig1 = '';}
        if($sigin2 !== null){
            $sig2 =  $sigin2->FILE_NAME;
        }else{ $sig2 = '';}
        if($sigin3 !== null){
            $sig3 =  $sigin3->FILE_NAME;
        }else{ $sig3 = '';}
        if($sigin4 !== null){
            $sig4 =  $sigin4->FILE_NAME;
        }else{ $sig4 = '';}
        if($sigin5 !== null){
            $sig5 =  $sigin5->FILE_NAME;
        }else{ $sig5 = '';}
        if($sigin6 !== null){
            $sig6 =  $sigin6->FILE_NAME;
        }else{ $sig6 = '';}
        if($sigin7 !== null){
            $sig7 =  $sigin7->FILE_NAME;
        }else{ $sig7 = '';}
       
    
        $checksig = DB::table('gleave_function')->where('FUNCTION_ID','=',1)->where('ACTIVE','=','True')->count();
    
          //-----getlevel----------
    
          $lavel1 = DB::table('hrd_person')->leftJoin('hrd_level','hrd_level.HR_LEVEL_ID','=','hrd_person.HR_LEVEL_ID')
          ->where('ID','=',$inforleave->LEADER_PERSON_ID)->first();
          $lavel2 = DB::table('hrd_person')->leftJoin('hrd_level','hrd_level.HR_LEVEL_ID','=','hrd_person.HR_LEVEL_ID')
          ->where('ID','=',$inforleave->LEADER_DEP_PERSON_ID)->first();
        
          $lavel3 = DB::table('hrd_person')->leftJoin('hrd_level','hrd_level.HR_LEVEL_ID','=','hrd_person.HR_LEVEL_ID')
          ->where('ID','=',$inforleave->USER_CONFIRM_CHECK_ID)->first();
          $lavel4 = DB::table('hrd_person')->leftJoin('hrd_level','hrd_level.HR_LEVEL_ID','=','hrd_person.HR_LEVEL_ID')
          ->where('ID','=',$inforleave->LEAVE_PERSON_ID)->first();
          $lavel5 = DB::table('hrd_person')->leftJoin('hrd_level','hrd_level.HR_LEVEL_ID','=','hrd_person.HR_LEVEL_ID')
          ->where('ID','=',$inforleave->LEAVE_WORK_SEND_ID)->first();

        return view('person_leave.pdfordain',[
            'orgname' => $orgname,
            'inforleave' => $inforleave,
            'inforperson' => $inforperson,
            'infoworksend' => $infoworksend,
            'infocon' => $infocon,
            'sumrest' => $sumrest,
            'inforest' => $inforest,
            'leaveday' => $leaveday,
            'idyear' => $idyear,
            'sig1' => $sig1, 
            'sig2' => $sig2,      
            'sig3' => $sig3,   
            'sig4' => $sig4,   
            'sig5' => $sig5,   
            'sig6' => $sig6,   
            'sig7' => $sig7,
            'checksig' => $checksig,  
            'lavel1' => $lavel1,
            'lavel2' => $lavel2,      
            'lavel3' => $lavel3,
            'lavel4' => $lavel4,
            'lavel5' => $lavel5, 
        ]);
    }


function pdfgive(Request $request,$id)
    {

        $orgname =  DB::table('info_org')
        ->leftJoin('hrd_person','info_org.ORG_LEADER_ID','=','hrd_person.ID')
        ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->first();


        $inforleave=  Leave_register::where('ID','=',$id)
        ->first();

        $iduser = $inforleave->LEAVE_PERSON_ID;
        $idyear = $inforleave->LEAVE_YEAR_ID;
    
        $inforperson=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
        ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
        ->where('hrd_person.ID','=',$iduser)->first();
    
        $idworksend = $inforleave->LEAVE_WORK_SEND_ID;
        $infoworksend =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
        ->where('hrd_person.ID','=',$idworksend)->first();
    
        $idcon = $inforleave->USER_CONFIRM_CHECK_ID;
        $infocon =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
        ->where('hrd_person.ID','=',$idcon)->first();
    
        $sumrest=  Leave_register::where('LEAVE_PERSON_ID','=',$iduser)
        ->where('LEAVE_YEAR_ID','=',$idyear)
        ->where('LEAVE_TYPE_CODE','=','04')
        ->where('LEAVE_STATUS_CODE','=','Allow')
        ->sum('WORK_DO');
    
        $inforperson=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
        ->where('hrd_person.ID','=',$iduser)->first();

        $inforest=  Leave_register::where('ID','=',$id)
        ->first();
    
    
        $leaveday =  DB::table('gleave_over')->where('PERSON_ID','=',$iduser)->first();

        $sigin1 = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforleave->LEAVE_PERSON_ID)->first();
        $sigin2 = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforleave->LEADER_PERSON_ID)->first();
        $sigin3 = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforleave->LEADER_DEP_PERSON_ID)->first();
        $sigin4 = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$orgname->ORG_LEADER_ID)->first();
        $sigin5 = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforleave->USER_CONFIRM_CHECK_ID)->first();
        $sigin6 = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforleave->LEAVE_PERSON_ID)->first();
        $sigin7 = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforleave->LEAVE_WORK_SEND_ID)->first();
     
    
        if($sigin1 !== null){
            $sig1 =  $sigin1->FILE_NAME;
        }else{ $sig1 = '';}
        if($sigin2 !== null){
            $sig2 =  $sigin2->FILE_NAME;
        }else{ $sig2 = '';}
        if($sigin3 !== null){
            $sig3 =  $sigin3->FILE_NAME;
        }else{ $sig3 = '';}
        if($sigin4 !== null){
            $sig4 =  $sigin4->FILE_NAME;
        }else{ $sig4 = '';}
        if($sigin5 !== null){
            $sig5 =  $sigin5->FILE_NAME;
        }else{ $sig5 = '';}
        if($sigin6 !== null){
            $sig6 =  $sigin6->FILE_NAME;
        }else{ $sig6 = '';}
        if($sigin7 !== null){
            $sig7 =  $sigin7->FILE_NAME;
        }else{ $sig7 = '';}
       
    
        $checksig = DB::table('gleave_function')->where('FUNCTION_ID','=',1)->where('ACTIVE','=','True')->count();
    
          //-----getlevel----------
    
          $lavel1 = DB::table('hrd_person')->leftJoin('hrd_level','hrd_level.HR_LEVEL_ID','=','hrd_person.HR_LEVEL_ID')
          ->where('ID','=',$inforleave->LEADER_PERSON_ID)->first();
          $lavel2 = DB::table('hrd_person')->leftJoin('hrd_level','hrd_level.HR_LEVEL_ID','=','hrd_person.HR_LEVEL_ID')
          ->where('ID','=',$inforleave->LEADER_DEP_PERSON_ID)->first();
        
          $lavel3 = DB::table('hrd_person')->leftJoin('hrd_level','hrd_level.HR_LEVEL_ID','=','hrd_person.HR_LEVEL_ID')
          ->where('ID','=',$inforleave->USER_CONFIRM_CHECK_ID)->first();
          $lavel4 = DB::table('hrd_person')->leftJoin('hrd_level','hrd_level.HR_LEVEL_ID','=','hrd_person.HR_LEVEL_ID')
          ->where('ID','=',$inforleave->LEAVE_PERSON_ID)->first();
          $lavel5 = DB::table('hrd_person')->leftJoin('hrd_level','hrd_level.HR_LEVEL_ID','=','hrd_person.HR_LEVEL_ID')
          ->where('ID','=',$inforleave->LEAVE_WORK_SEND_ID)->first();
    

        return view('person_leave.pdfgive',[
          
            'orgname' => $orgname,
            'inforleave' => $inforleave,
            'inforperson' => $inforperson,
            'infoworksend' => $infoworksend,
            'infocon' => $infocon,
            'sumrest' => $sumrest,
            'inforest' => $inforest,
            'leaveday' => $leaveday,
            'idyear' => $idyear,
            'sig1' => $sig1, 
            'sig2' => $sig2,      
            'sig3' => $sig3,   
            'sig4' => $sig4,   
            'sig5' => $sig5,   
            'sig6' => $sig6,   
            'sig7' => $sig7,
            'checksig' => $checksig,  
            'lavel1' => $lavel1,
            'lavel2' => $lavel2,      
            'lavel3' => $lavel3,
            'lavel4' => $lavel4,
            'lavel5' => $lavel5,   
        ]);
    }


function pdfcancelleave(Request $request,$id)
    {

        $orgname =  DB::table('info_org')
        ->leftJoin('hrd_person','info_org.ORG_LEADER_ID','=','hrd_person.ID')
        ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->first();


        $inforleave=  Leave_register::where('ID','=',$id)
        ->first();

        $iduser = $inforleave->LEAVE_PERSON_ID;
        $idyear = $inforleave->LEAVE_YEAR_ID;
    
        $inforperson=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
            ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
            ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
            ->where('hrd_person.ID','=',$iduser)->first();

        $sigin1 = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforleave->LEAVE_PERSON_ID)->first();
        $sigin2 = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforleave->LEADER_PERSON_ID)->first();
     
    
        if($sigin1 !== null){
            $sig1 =  $sigin1->FILE_NAME;
        }else{ $sig1 = '';}
        if($sigin2 !== null){
            $sig2 =  $sigin2->FILE_NAME;
        }else{ $sig2 = '';}
    
        $checksig = DB::table('gleave_function')->where('FUNCTION_ID','=',1)->where('ACTIVE','=','True')->count();


        $lavel1 = DB::table('hrd_person')->leftJoin('hrd_level','hrd_level.HR_LEVEL_ID','=','hrd_person.HR_LEVEL_ID')
        ->where('ID','=',$inforleave->LEADER_PERSON_ID)->first();

        return view('person_leave.pdfcancelleave',[
            'orgname' => $orgname,
            'inforleave' => $inforleave,
            'inforperson' => $inforperson,
            'checksig' => $checksig,
            'sig1' => $sig1,
            'sig2' => $sig2,
            'lavel1' => $lavel1,
        ]);
    }


function pdftrain(Request $request,$id)
    {

        $orgname =  DB::table('info_org')
        ->leftJoin('hrd_person','info_org.ORG_LEADER_ID','=','hrd_person.ID')
        ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->first();

        $inforleave=  Leave_register::where('ID','=',$id)
        ->first();

        $iduser = $inforleave->LEAVE_PERSON_ID;
        $idyear = $inforleave->LEAVE_YEAR_ID;
      
        $inforperson=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
        ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
        ->where('hrd_person.ID','=',$iduser)->first();
    
        $idworksend = $inforleave->LEAVE_WORK_SEND_ID;
        $infoworksend =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
        ->where('hrd_person.ID','=',$idworksend)->first();
    
        $idcon = $inforleave->USER_CONFIRM_CHECK_ID;
        $infocon =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
        ->where('hrd_person.ID','=',$idcon)->first();
    
        $sumrest=  Leave_register::where('LEAVE_PERSON_ID','=',$iduser)
        ->where('LEAVE_YEAR_ID','=',$idyear)
        ->where('LEAVE_TYPE_CODE','=','04')
        ->where('LEAVE_STATUS_CODE','=','Allow')
        ->sum('WORK_DO');
    
     

        $inforest=  Leave_register::where('ID','=',$id)
        ->first();
        
        $leaveday =  DB::table('gleave_over')->where('PERSON_ID','=',$iduser)->first();

        $sigin1 = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforleave->LEAVE_PERSON_ID)->first();
        $sigin2 = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforleave->LEADER_PERSON_ID)->first();
        $sigin3 = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforleave->LEADER_DEP_PERSON_ID)->first();
        $sigin4 = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$orgname->ORG_LEADER_ID)->first();
        $sigin5 = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforleave->USER_CONFIRM_CHECK_ID)->first();
        $sigin6 = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforleave->LEAVE_PERSON_ID)->first();
        $sigin7 = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforleave->LEAVE_WORK_SEND_ID)->first();
         
        if($sigin1 !== null){
            $sig1 =  $sigin1->FILE_NAME;
        }else{ $sig1 = '';}
        if($sigin2 !== null){
            $sig2 =  $sigin2->FILE_NAME;
        }else{ $sig2 = '';}
        if($sigin3 !== null){
            $sig3 =  $sigin3->FILE_NAME;
        }else{ $sig3 = '';}
        if($sigin4 !== null){
            $sig4 =  $sigin4->FILE_NAME;
        }else{ $sig4 = '';}
        if($sigin5 !== null){
            $sig5 =  $sigin5->FILE_NAME;
        }else{ $sig5 = '';}
        if($sigin6 !== null){
            $sig6 =  $sigin6->FILE_NAME;
        }else{ $sig6 = '';}
        if($sigin7 !== null){
            $sig7 =  $sigin7->FILE_NAME;
        }else{ $sig7 = '';}
           
        $checksig = DB::table('gleave_function')->where('FUNCTION_ID','=',1)->where('ACTIVE','=','True')->count();
    
          //-----getlevel----------
    
          $lavel1 = DB::table('hrd_person')->leftJoin('hrd_level','hrd_level.HR_LEVEL_ID','=','hrd_person.HR_LEVEL_ID')
          ->where('ID','=',$inforleave->LEADER_PERSON_ID)->first();
          $lavel2 = DB::table('hrd_person')->leftJoin('hrd_level','hrd_level.HR_LEVEL_ID','=','hrd_person.HR_LEVEL_ID')
          ->where('ID','=',$inforleave->LEADER_DEP_PERSON_ID)->first();
        
          $lavel3 = DB::table('hrd_person')->leftJoin('hrd_level','hrd_level.HR_LEVEL_ID','=','hrd_person.HR_LEVEL_ID')
          ->where('ID','=',$inforleave->USER_CONFIRM_CHECK_ID)->first();
          $lavel4 = DB::table('hrd_person')->leftJoin('hrd_level','hrd_level.HR_LEVEL_ID','=','hrd_person.HR_LEVEL_ID')
          ->where('ID','=',$inforleave->LEAVE_PERSON_ID)->first();
          $lavel5 = DB::table('hrd_person')->leftJoin('hrd_level','hrd_level.HR_LEVEL_ID','=','hrd_person.HR_LEVEL_ID')
          ->where('ID','=',$inforleave->LEAVE_WORK_SEND_ID)->first();
    

        return view('person_leave.pdftrain',[
            'orgname' => $orgname,
            'inforleave' => $inforleave,
            'inforperson' => $inforperson,
            'infoworksend' => $infoworksend,
            'infocon' => $infocon,
            'sumrest' => $sumrest,
            'inforest' => $inforest,
            'leaveday' => $leaveday,
            'idyear' => $idyear,
            'sig1' => $sig1, 
            'sig2' => $sig2,      
            'sig3' => $sig3,   
            'sig4' => $sig4,   
            'sig5' => $sig5,   
            'sig6' => $sig6,   
            'sig7' => $sig7,
            'checksig' => $checksig,  
            'lavel1' => $lavel1,
            'lavel2' => $lavel2,      
            'lavel3' => $lavel3,
            'lavel4' => $lavel4,
            'lavel5' => $lavel5, 
        ]);
    }


    function pdffollow(Request $request,$id)
    {

        $orgname =  DB::table('info_org')
        ->leftJoin('hrd_person','info_org.ORG_LEADER_ID','=','hrd_person.ID')
        ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->first();

        $inforleave=  Leave_register::where('ID','=',$id)
        ->first();

        $iduser = $inforleave->LEAVE_PERSON_ID;
        $idyear = $inforleave->LEAVE_YEAR_ID;
      
        $inforperson=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
        ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
        ->where('hrd_person.ID','=',$iduser)->first();
    
        $idworksend = $inforleave->LEAVE_WORK_SEND_ID;
        $infoworksend =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
        ->where('hrd_person.ID','=',$idworksend)->first();
    
        $idcon = $inforleave->USER_CONFIRM_CHECK_ID;
        $infocon =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
        ->where('hrd_person.ID','=',$idcon)->first();
    
        $sumrest=  Leave_register::where('LEAVE_PERSON_ID','=',$iduser)
        ->where('LEAVE_YEAR_ID','=',$idyear)
        ->where('LEAVE_TYPE_CODE','=','04')
        ->where('LEAVE_STATUS_CODE','=','Allow')
        ->sum('WORK_DO');
    
     

        $inforest=  Leave_register::where('ID','=',$id)
        ->first();
        
        $leaveday =  DB::table('gleave_over')->where('PERSON_ID','=',$iduser)->first();

        $sigin1 = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforleave->LEAVE_PERSON_ID)->first();
        $sigin2 = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforleave->LEADER_PERSON_ID)->first();
        $sigin3 = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforleave->LEADER_DEP_PERSON_ID)->first();
        $sigin4 = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$orgname->ORG_LEADER_ID)->first();
        $sigin5 = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforleave->USER_CONFIRM_CHECK_ID)->first();
        $sigin6 = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforleave->LEAVE_PERSON_ID)->first();
        $sigin7 = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforleave->LEAVE_WORK_SEND_ID)->first();
         
        if($sigin1 !== null){
            $sig1 =  $sigin1->FILE_NAME;
        }else{ $sig1 = '';}
        if($sigin2 !== null){
            $sig2 =  $sigin2->FILE_NAME;
        }else{ $sig2 = '';}
        if($sigin3 !== null){
            $sig3 =  $sigin3->FILE_NAME;
        }else{ $sig3 = '';}
        if($sigin4 !== null){
            $sig4 =  $sigin4->FILE_NAME;
        }else{ $sig4 = '';}
        if($sigin5 !== null){
            $sig5 =  $sigin5->FILE_NAME;
        }else{ $sig5 = '';}
        if($sigin6 !== null){
            $sig6 =  $sigin6->FILE_NAME;
        }else{ $sig6 = '';}
        if($sigin7 !== null){
            $sig7 =  $sigin7->FILE_NAME;
        }else{ $sig7 = '';}
           
        $checksig = DB::table('gleave_function')->where('FUNCTION_ID','=',1)->where('ACTIVE','=','True')->count();
    
          //-----getlevel----------
    
          $lavel1 = DB::table('hrd_person')->leftJoin('hrd_level','hrd_level.HR_LEVEL_ID','=','hrd_person.HR_LEVEL_ID')
          ->where('ID','=',$inforleave->LEADER_PERSON_ID)->first();
          $lavel2 = DB::table('hrd_person')->leftJoin('hrd_level','hrd_level.HR_LEVEL_ID','=','hrd_person.HR_LEVEL_ID')
          ->where('ID','=',$inforleave->LEADER_DEP_PERSON_ID)->first();
        
          $lavel3 = DB::table('hrd_person')->leftJoin('hrd_level','hrd_level.HR_LEVEL_ID','=','hrd_person.HR_LEVEL_ID')
          ->where('ID','=',$inforleave->USER_CONFIRM_CHECK_ID)->first();
          $lavel4 = DB::table('hrd_person')->leftJoin('hrd_level','hrd_level.HR_LEVEL_ID','=','hrd_person.HR_LEVEL_ID')
          ->where('ID','=',$inforleave->LEAVE_PERSON_ID)->first();
          $lavel5 = DB::table('hrd_person')->leftJoin('hrd_level','hrd_level.HR_LEVEL_ID','=','hrd_person.HR_LEVEL_ID')
          ->where('ID','=',$inforleave->LEAVE_WORK_SEND_ID)->first();
    

        return view('person_leave.pdffollow',[
            'orgname' => $orgname,
            'inforleave' => $inforleave,
            'inforperson' => $inforperson,
            'infoworksend' => $infoworksend,
            'infocon' => $infocon,
            'sumrest' => $sumrest,
            'inforest' => $inforest,
            'leaveday' => $leaveday,
            'idyear' => $idyear,
            'sig1' => $sig1, 
            'sig2' => $sig2,      
            'sig3' => $sig3,   
            'sig4' => $sig4,   
            'sig5' => $sig5,   
            'sig6' => $sig6,   
            'sig7' => $sig7,
            'checksig' => $checksig,  
            'lavel1' => $lavel1,
            'lavel2' => $lavel2,      
            'lavel3' => $lavel3,
            'lavel4' => $lavel4,
            'lavel5' => $lavel5, 
        ]);
    }



    function pdfsoldier(Request $request,$id)
    {
        
        $orgname =  DB::table('info_org')
        ->leftJoin('hrd_person','info_org.ORG_LEADER_ID','=','hrd_person.ID')
        ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->first();

        $inforleave=  Leave_register::where('ID','=',$id)
        ->first();

        $iduser = $inforleave->LEAVE_PERSON_ID;
        $idyear = $inforleave->LEAVE_YEAR_ID;
      
        $inforperson=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
        ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
        ->where('hrd_person.ID','=',$iduser)->first();
    
        $idworksend = $inforleave->LEAVE_WORK_SEND_ID;
        $infoworksend =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
        ->where('hrd_person.ID','=',$idworksend)->first();
    
        $idcon = $inforleave->USER_CONFIRM_CHECK_ID;
        $infocon =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
        ->where('hrd_person.ID','=',$idcon)->first();
    
        $sumrest=  Leave_register::where('LEAVE_PERSON_ID','=',$iduser)
        ->where('LEAVE_YEAR_ID','=',$idyear)
        ->where('LEAVE_TYPE_CODE','=','04')
        ->where('LEAVE_STATUS_CODE','=','Allow')
        ->sum('WORK_DO');
    
     

        $inforest=  Leave_register::where('ID','=',$id)
        ->first();
        
        $leaveday =  DB::table('gleave_over')->where('PERSON_ID','=',$iduser)->first();

        $sigin1 = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforleave->LEAVE_PERSON_ID)->first();
        $sigin2 = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforleave->LEADER_PERSON_ID)->first();
        $sigin3 = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforleave->LEADER_DEP_PERSON_ID)->first();
        $sigin4 = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$orgname->ORG_LEADER_ID)->first();
        $sigin5 = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforleave->USER_CONFIRM_CHECK_ID)->first();
        $sigin6 = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforleave->LEAVE_PERSON_ID)->first();
        $sigin7 = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforleave->LEAVE_WORK_SEND_ID)->first();
         
        if($sigin1 !== null){
            $sig1 =  $sigin1->FILE_NAME;
        }else{ $sig1 = '';}
        if($sigin2 !== null){
            $sig2 =  $sigin2->FILE_NAME;
        }else{ $sig2 = '';}
        if($sigin3 !== null){
            $sig3 =  $sigin3->FILE_NAME;
        }else{ $sig3 = '';}
        if($sigin4 !== null){
            $sig4 =  $sigin4->FILE_NAME;
        }else{ $sig4 = '';}
        if($sigin5 !== null){
            $sig5 =  $sigin5->FILE_NAME;
        }else{ $sig5 = '';}
        if($sigin6 !== null){
            $sig6 =  $sigin6->FILE_NAME;
        }else{ $sig6 = '';}
        if($sigin7 !== null){
            $sig7 =  $sigin7->FILE_NAME;
        }else{ $sig7 = '';}
           
        $checksig = DB::table('gleave_function')->where('FUNCTION_ID','=',1)->where('ACTIVE','=','True')->count();
    
          //-----getlevel----------
    
          $lavel1 = DB::table('hrd_person')->leftJoin('hrd_level','hrd_level.HR_LEVEL_ID','=','hrd_person.HR_LEVEL_ID')
          ->where('ID','=',$inforleave->LEADER_PERSON_ID)->first();
          $lavel2 = DB::table('hrd_person')->leftJoin('hrd_level','hrd_level.HR_LEVEL_ID','=','hrd_person.HR_LEVEL_ID')
          ->where('ID','=',$inforleave->LEADER_DEP_PERSON_ID)->first();
        
          $lavel3 = DB::table('hrd_person')->leftJoin('hrd_level','hrd_level.HR_LEVEL_ID','=','hrd_person.HR_LEVEL_ID')
          ->where('ID','=',$inforleave->USER_CONFIRM_CHECK_ID)->first();
          $lavel4 = DB::table('hrd_person')->leftJoin('hrd_level','hrd_level.HR_LEVEL_ID','=','hrd_person.HR_LEVEL_ID')
          ->where('ID','=',$inforleave->LEAVE_PERSON_ID)->first();
          $lavel5 = DB::table('hrd_person')->leftJoin('hrd_level','hrd_level.HR_LEVEL_ID','=','hrd_person.HR_LEVEL_ID')
          ->where('ID','=',$inforleave->LEAVE_WORK_SEND_ID)->first();

        return view('person_leave.pdfsoldier',[
            'orgname' => $orgname,
            'inforleave' => $inforleave,
            'inforperson' => $inforperson,
            'infoworksend' => $infoworksend,
            'infocon' => $infocon,
            'sumrest' => $sumrest,
            'inforest' => $inforest,
            'leaveday' => $leaveday,
            'idyear' => $idyear,
            'sig1' => $sig1, 
            'sig2' => $sig2,      
            'sig3' => $sig3,   
            'sig4' => $sig4,   
            'sig5' => $sig5,   
            'sig6' => $sig6,   
            'sig7' => $sig7,
            'checksig' => $checksig,  
            'lavel1' => $lavel1,
            'lavel2' => $lavel2,      
            'lavel3' => $lavel3,
            'lavel4' => $lavel4,
            'lavel5' => $lavel5, 
        ]);
    }
 

function pdfsicklow(Request $request,$id)
{
    $orgname =  DB::table('info_org')
    ->leftJoin('hrd_person','info_org.ORG_LEADER_ID','=','hrd_person.ID')
    ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->first();

    $inforleave=  Leave_register::where('ID','=',$id)
    ->first();

    $iduser = $inforleave->LEAVE_PERSON_ID;
    $idyear = $inforleave->LEAVE_YEAR_ID;

    $inforperson=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
    ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
    ->where('hrd_person.ID','=',$iduser)->first();

    $idworksend = $inforleave->LEAVE_WORK_SEND_ID;
    $infoworksend =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
    ->where('hrd_person.ID','=',$idworksend)->first();

    $idcon = $inforleave->USER_CONFIRM_CHECK_ID;
    $infocon =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
    ->where('hrd_person.ID','=',$idcon)->first();

    $sumsickrealnomal=  Leave_register::where('LEAVE_PERSON_ID','=',$iduser)
    ->where('LEAVE_YEAR_ID','=',$idyear)
    ->where('LEAVE_TYPE_CODE','=','01')
    ->where('LEAVE_STATUS_CODE','=','Allow')
    ->sum('WORK_DO');
    
    $sumsickreal=  Leave_register::where('LEAVE_PERSON_ID','=',$iduser)
    ->where('LEAVE_YEAR_ID','=',$idyear)
    ->where('LEAVE_TYPE_CODE','=','13')
    ->where('LEAVE_STATUS_CODE','=','Allow')
    ->sum('WORK_DO');

    $sumsick = ($sumsickrealnomal + $sumsickreal)-$inforleave->WORK_DO;

    $sumwork =  Leave_register::where('LEAVE_PERSON_ID','=',$iduser)
    ->where('LEAVE_YEAR_ID','=',$idyear)
    ->where('LEAVE_TYPE_CODE','=','03')
    ->where('LEAVE_STATUS_CODE','=','Allow')
    ->sum('WORK_DO');


    $sumbirth=  Leave_register::where('LEAVE_PERSON_ID','=',$iduser)
    ->where('LEAVE_YEAR_ID','=',$idyear)
    ->where('LEAVE_TYPE_CODE','=','02')
    ->where('LEAVE_STATUS_CODE','=','Allow')
    ->sum('WORK_DO');


    $idmax = Leave_register::where('LEAVE_STATUS_CODE','=','Allow')
    ->where('LEAVE_TYPE_CODE','=','01')
    ->where('LEAVE_PERSON_ID','=',$iduser)
    ->orderBy('ID', 'desc')
    ->limit(2)
    ->get()
    ->min('ID');
    


    if($idmax == '' || $idmax == null || $idmax == $inforleave->ID){
        $lastsick= '';
    }else{
        $lastsick=  Leave_register::where('ID','=',$idmax)
        ->first();
    }
     
    $sigin1 = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforleave->LEAVE_PERSON_ID)->first();
    $sigin2 = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforleave->LEADER_PERSON_ID)->first();
    $sigin3 = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforleave->LEADER_DEP_PERSON_ID)->first();
    $sigin4 = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$orgname->ORG_LEADER_ID)->first();
    $sigin5 = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforleave->USER_CONFIRM_CHECK_ID)->first();
    $sigin6 = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforleave->LEAVE_PERSON_ID)->first();
    $sigin7 = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforleave->LEAVE_WORK_SEND_ID)->first();
 

    if($sigin1 !== null){
        $sig1 =  $sigin1->FILE_NAME;
    }else{ $sig1 = '';}
    if($sigin2 !== null){
        $sig2 =  $sigin2->FILE_NAME;
    }else{ $sig2 = '';}
    if($sigin3 !== null){
        $sig3 =  $sigin3->FILE_NAME;
    }else{ $sig3 = '';}
    if($sigin4 !== null){
        $sig4 =  $sigin4->FILE_NAME;
    }else{ $sig4 = '';}
    if($sigin5 !== null){
        $sig5 =  $sigin5->FILE_NAME;
    }else{ $sig5 = '';}
    if($sigin6 !== null){
        $sig6 =  $sigin6->FILE_NAME;
    }else{ $sig6 = '';}
    if($sigin7 !== null){
        $sig7 =  $sigin7->FILE_NAME;
    }else{ $sig7 = '';}
   

    $checksig = DB::table('gleave_function')->where('FUNCTION_ID','=',1)->where('ACTIVE','=','True')->count();

    $lavel1 = DB::table('hrd_person')->leftJoin('hrd_level','hrd_level.HR_LEVEL_ID','=','hrd_person.HR_LEVEL_ID')
    ->where('ID','=',$inforleave->LEADER_PERSON_ID)->first();
    $lavel2 = DB::table('hrd_person')->leftJoin('hrd_level','hrd_level.HR_LEVEL_ID','=','hrd_person.HR_LEVEL_ID')
    ->where('ID','=',$inforleave->LEADER_DEP_PERSON_ID)->first();

    $lavel3 = DB::table('hrd_person')->leftJoin('hrd_level','hrd_level.HR_LEVEL_ID','=','hrd_person.HR_LEVEL_ID')
    ->where('ID','=',$inforleave->USER_CONFIRM_CHECK_ID)->first();
    $lavel4 = DB::table('hrd_person')->leftJoin('hrd_level','hrd_level.HR_LEVEL_ID','=','hrd_person.HR_LEVEL_ID')
    ->where('ID','=',$inforleave->LEAVE_PERSON_ID)->first();
    $lavel5 = DB::table('hrd_person')->leftJoin('hrd_level','hrd_level.HR_LEVEL_ID','=','hrd_person.HR_LEVEL_ID')
    ->where('ID','=',$inforleave->LEAVE_WORK_SEND_ID)->first();

    return view('person_leave.pdfsicklow',[
        'orgname' => $orgname,
        'inforleave' => $inforleave,
        'inforperson' => $inforperson,
        'infoworksend' => $infoworksend,
        'infocon' => $infocon,
        'sumsick' => $sumsick,
        'sumwork' => $sumwork,
        'sumbirth' => $sumbirth,
        'lastsick' => $lastsick,    
        'idyear' => $idyear,
        'sig1' => $sig1, 
        'sig2' => $sig2,      
        'sig3' => $sig3,   
        'sig4' => $sig4,   
        'sig5' => $sig5,   
        'sig6' => $sig6,   
        'sig7' => $sig7,
        'checksig' => $checksig,
        'lavel1' => $lavel1,
        'lavel2' => $lavel2,      
        'lavel3' => $lavel3,
        'lavel4' => $lavel4,
        'lavel5' => $lavel5,         

    ]);
}





//-------------------------------function---------------------
public static function countdayleavemonth($user_id,$yearbudget,$type,$from,$to)
{
            $count =  Leave_register::where('LEAVE_PERSON_ID','=',$user_id)
            ->where('LEAVE_YEAR_ID','=',$yearbudget )
            ->where('LEAVE_STATUS_CODE','=','Allow')
            ->where('LEAVE_TYPE_CODE','=',$type )
            ->sum('WORK_DO');

    return $count;
}

public static function countamountdayleavemonth($user_id,$yearbudget,$type,$from,$to)
{
    $count =  Leave_register::where('LEAVE_PERSON_ID','=',$user_id)
    ->where('LEAVE_YEAR_ID','=',$yearbudget )
    ->where('LEAVE_STATUS_CODE','=','Allow')
    ->where('LEAVE_TYPE_CODE','=',$type )
    ->count();

    return $count;
}



public static function sumcountdayleavemonth($user_id,$yearbudget,$from,$to)
{
    $count =  Leave_register::where('LEAVE_PERSON_ID','=',$user_id)
            ->where('LEAVE_YEAR_ID','=',$yearbudget )
            ->where('LEAVE_STATUS_CODE','=','Allow')
            ->sum('WORK_DO');

return $count;
}

public static function sumcountamountdayleavemonth($user_id,$yearbudget,$from,$to)
{
    $count =  Leave_register::where('LEAVE_PERSON_ID','=',$user_id)
    ->where('LEAVE_YEAR_ID','=',$yearbudget )
    ->where('LEAVE_STATUS_CODE','=','Allow')
    ->count();
return $count;
}

//=====================================================

public function infocalendar(Request $request,$iduser)
{

    if(!empty($_GET['depid']) && !empty($_GET['depname']) ){
        $depid['id'] =  $_GET['depid'];
        $depname['name'] =  $_GET['depname'];
    }else{
      $depid['id'] =  'all';
      $depname['name'] =  'ทั้งหมด';
    }

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

    $data['depname'] = $depname;

    $depinfo = DB::table('hrd_department')->get();

    $inforleave =  Leave_register::where('LEAVE_STATUS_CODE','<>','Cancel');
    if($depid['id'] !== 'all'){
        $inforleave->where('LEAVE_DEPARTMENT_ID', $depid['id']);
    }
    $inforleave = $inforleave->orderBy('gleave_register.ID', 'desc') 
                ->get();


    return view('person_leave.personleavecalendar',$data,[
        'inforpersonuser' => $inforpersonuser,
        'inforpersonuserid' => $inforpersonuserid,
        'infopersonleaves' => $inforleave,
        'depinfos' => $depinfo,
        'iduser' => $iduser,
        
    ]);
}


 
//--------------------------------------------------------------

public function leaveinfoaccept(Request $request,$iduser)
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

    $inforleave=  Leave_register::select('ID','LEAVE_BECAUSE','WORK_DO','LEAVE_DATE_END','LEAVE_DATE_BEGIN','LEAVE_WORK_SEND','LEAVE_CONTACT_PHONE','LOCATION_NAME','LEAVE_TYPE_NAME','LEAVE_PERSON_FULLNAME','LEAVE_YEAR_ID','STATUS_NAME','STATUS_CODE','gleave_register.created_at','LEAVE_CONTACT','LEAVE_SUM_ALL','WORK_DO','LEAVE_SUM_HOLIDAY','LEAVE_SUM_SETSUN','LEAVE_COMMENT_BY','DAY_TYPE_ID','LEAVE_APP_H1','LEAVE_APP_H2','LEAVE_APP_SEND')
    ->leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_ID')
    ->leftJoin('gleave_status','gleave_register.LEAVE_STATUS_CODE','=','gleave_status.STATUS_CODE')
    ->leftJoin('gleave_location','gleave_register.LOCATION_ID','=','gleave_location.LOCATION_ID')
    ->where('LEAVE_WORK_SEND_ID','=',$iduser)
    ->WhereBetween('LEAVE_DATE_BEGIN',[$displaydate_bigen,$displaydate_end])
    ->orderBy('gleave_register.ID', 'desc')
    ->get();



    $infostatus =  LeaveStatus::get();


    $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
 
    $status = '';
    $search = '';
    $year_id = $yearbudget;

    return view('person_leave.personleaveinfoaccept',[
        'inforpersonuser' => $inforpersonuser,
        'inforpersonuserid' => $inforpersonuserid,
        'inforleaves' => $inforleave,
        'infostatuss'=>$infostatus,
        'displaydate_bigen'=> $displaydate_bigen, 
        'displaydate_end'=> $displaydate_end,
        'status_check' => $status,
        'search' => $search,    
        'budgets' =>  $budget,
        'year_id'=>$year_id 
    ]);
}


public function leaveinfoacceptsearch(Request $request,$iduser)
{
    $search = $request->get('search');
    $status = $request->STATUS_CODE;
    $datebigin = $request->get('DATE_BIGIN');
    $dateend = $request->get('DATE_END');
    $yearbudget = $request->BUDGET_YEAR;

    if($search==''){
        $search="";
    }

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
  
    $inforleave=  Leave_register::select('ID','LEAVE_BECAUSE','WORK_DO','LEAVE_DATE_END','LEAVE_DATE_BEGIN','LEAVE_WORK_SEND','LEAVE_CONTACT_PHONE','LOCATION_NAME','LEAVE_TYPE_NAME','LEAVE_PERSON_FULLNAME','LEAVE_YEAR_ID','STATUS_NAME','STATUS_CODE','gleave_register.created_at','LEAVE_CONTACT','LEAVE_SUM_ALL','WORK_DO','LEAVE_SUM_HOLIDAY','LEAVE_SUM_SETSUN','LEAVE_COMMENT_BY','DAY_TYPE_ID','LEAVE_APP_H1','LEAVE_APP_H2','LEAVE_APP_SEND')
    ->leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_ID')
    ->leftJoin('gleave_status','gleave_register.LEAVE_STATUS_CODE','=','gleave_status.STATUS_CODE')
    ->leftJoin('gleave_location','gleave_register.LOCATION_ID','=','gleave_location.LOCATION_ID')
    ->where('LEAVE_WORK_SEND_ID','=',$iduser)
    ->where(function($q) use ($search){
        $q->where('LEAVE_YEAR_ID','like','%'.$search.'%');
        $q->orwhere('LEAVE_PERSON_FULLNAME','like','%'.$search.'%');
        $q->orwhere('LEAVE_TYPE_NAME','like','%'.$search.'%');
        $q->orwhere('LEAVE_BECAUSE','like','%'.$search.'%');

    })
    ->WhereBetween('LEAVE_DATE_BEGIN',[$from,$to])
    ->orderBy('gleave_register.ID', 'desc')
    ->get();

}else{

    if($status == 'APP'){

       
        $inforleave=  Leave_register::select('ID','LEAVE_BECAUSE','WORK_DO','LEAVE_DATE_END','LEAVE_DATE_BEGIN','LEAVE_WORK_SEND','LEAVE_CONTACT_PHONE','LOCATION_NAME','LEAVE_TYPE_NAME','LEAVE_PERSON_FULLNAME','LEAVE_YEAR_ID','STATUS_NAME','STATUS_CODE','gleave_register.created_at','LEAVE_CONTACT','LEAVE_SUM_ALL','WORK_DO','LEAVE_SUM_HOLIDAY','LEAVE_SUM_SETSUN','LEAVE_COMMENT_BY','DAY_TYPE_ID','LEAVE_APP_H1','LEAVE_APP_H2','LEAVE_APP_SEND')
        ->leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_ID')
        ->leftJoin('gleave_status','gleave_register.LEAVE_STATUS_CODE','=','gleave_status.STATUS_CODE')
        ->leftJoin('gleave_location','gleave_register.LOCATION_ID','=','gleave_location.LOCATION_ID')
        ->where('LEAVE_WORK_SEND_ID','=',$iduser)
        ->where(function($q){
            $q->where('LEAVE_STATUS_CODE','=','Pending');
            $q->orwhere('LEAVE_STATUS_CODE','=','Recancel');

        })
        ->where(function($q) use ($search){
            $q->where('LEAVE_YEAR_ID','like','%'.$search.'%');
            $q->orwhere('LEAVE_PERSON_FULLNAME','like','%'.$search.'%');
            $q->orwhere('LEAVE_TYPE_NAME','like','%'.$search.'%');
            $q->orwhere('LEAVE_BECAUSE','like','%'.$search.'%');

        })
        ->WhereBetween('LEAVE_DATE_BEGIN',[$from,$to])
        ->orderBy('gleave_register.ID', 'desc')
        ->get();

      

    }else{

    $inforleave=  Leave_register::select('ID','LEAVE_BECAUSE','WORK_DO','LEAVE_DATE_END','LEAVE_DATE_BEGIN','LEAVE_WORK_SEND','LEAVE_CONTACT_PHONE','LOCATION_NAME','LEAVE_TYPE_NAME','LEAVE_PERSON_FULLNAME','LEAVE_YEAR_ID','STATUS_NAME','STATUS_CODE','gleave_register.created_at','LEAVE_CONTACT','LEAVE_SUM_ALL','WORK_DO','LEAVE_SUM_HOLIDAY','LEAVE_SUM_SETSUN','LEAVE_COMMENT_BY','DAY_TYPE_ID','LEAVE_APP_H1','LEAVE_APP_H2','LEAVE_APP_SEND')
    ->leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_ID')
    ->leftJoin('gleave_status','gleave_register.LEAVE_STATUS_CODE','=','gleave_status.STATUS_CODE')
    ->leftJoin('gleave_location','gleave_register.LOCATION_ID','=','gleave_location.LOCATION_ID')
    ->where('LEAVE_WORK_SEND_ID','=',$iduser)
    ->where('LEAVE_STATUS_CODE','=',$status)
    ->where(function($q) use ($search){
        $q->where('LEAVE_YEAR_ID','like','%'.$search.'%');
        $q->orwhere('LEAVE_PERSON_FULLNAME','like','%'.$search.'%');
        $q->orwhere('LEAVE_TYPE_NAME','like','%'.$search.'%');
        $q->orwhere('LEAVE_BECAUSE','like','%'.$search.'%');

    })
    ->WhereBetween('LEAVE_DATE_BEGIN',[$from,$to])
    ->orderBy('gleave_register.ID', 'desc')
    ->get();

    }
}




     }else{

    if($status == null){

        $inforleave=  Leave_register::select('ID','LEAVE_BECAUSE','WORK_DO','LEAVE_DATE_END','LEAVE_DATE_BEGIN','LEAVE_WORK_SEND','LEAVE_CONTACT_PHONE','LOCATION_NAME','LEAVE_TYPE_NAME','LEAVE_PERSON_FULLNAME','LEAVE_YEAR_ID','STATUS_NAME','STATUS_CODE','gleave_register.created_at','LEAVE_CONTACT','LEAVE_SUM_ALL','WORK_DO','LEAVE_SUM_HOLIDAY','LEAVE_SUM_SETSUN','LEAVE_COMMENT_BY','DAY_TYPE_ID','LEAVE_APP_H1','LEAVE_APP_H2','LEAVE_APP_SEND')
        ->leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_ID')
        ->leftJoin('gleave_status','gleave_register.LEAVE_STATUS_CODE','=','gleave_status.STATUS_CODE')
        ->leftJoin('gleave_location','gleave_register.LOCATION_ID','=','gleave_location.LOCATION_ID')
        ->where('LEAVE_WORK_SEND_ID','=',$iduser)
        ->where(function($q) use ($search){
            $q->where('LEAVE_YEAR_ID','like','%'.$search.'%');
            $q->orwhere('LEAVE_PERSON_FULLNAME','like','%'.$search.'%');
            $q->orwhere('LEAVE_TYPE_NAME','like','%'.$search.'%');
            $q->orwhere('LEAVE_BECAUSE','like','%'.$search.'%');
        })
        ->orderBy('gleave_register.ID', 'desc')
        ->get();
    }else{


        if($status == 'APP'){

            $inforleave=  Leave_register::select('ID','LEAVE_BECAUSE','WORK_DO','LEAVE_DATE_END','LEAVE_DATE_BEGIN','LEAVE_WORK_SEND','LEAVE_CONTACT_PHONE','LOCATION_NAME','LEAVE_TYPE_NAME','LEAVE_PERSON_FULLNAME','LEAVE_YEAR_ID','STATUS_NAME','STATUS_CODE','gleave_register.created_at','LEAVE_CONTACT','LEAVE_SUM_ALL','WORK_DO','LEAVE_SUM_HOLIDAY','LEAVE_SUM_SETSUN','LEAVE_COMMENT_BY','DAY_TYPE_ID','LEAVE_APP_H1','LEAVE_APP_H2','LEAVE_APP_SEND')
            ->leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_ID')
            ->leftJoin('gleave_status','gleave_register.LEAVE_STATUS_CODE','=','gleave_status.STATUS_CODE')
            ->leftJoin('gleave_location','gleave_register.LOCATION_ID','=','gleave_location.LOCATION_ID')
            ->where('LEAVE_WORK_SEND_ID','=',$iduser)
            ->where(function($q){
                $q->where('LEAVE_STATUS_CODE','=','Pending');
                $q->orwhere('LEAVE_STATUS_CODE','=','Recancel');
    
            })
            ->where(function($q) use ($search){
                $q->where('LEAVE_YEAR_ID','like','%'.$search.'%');
                $q->orwhere('LEAVE_PERSON_FULLNAME','like','%'.$search.'%');
                $q->orwhere('LEAVE_TYPE_NAME','like','%'.$search.'%');
                $q->orwhere('LEAVE_BECAUSE','like','%'.$search.'%');
            })
            ->orderBy('gleave_register.ID', 'desc')
            ->get();


        }else{
        $inforleave=  Leave_register::select('ID','LEAVE_BECAUSE','WORK_DO','LEAVE_DATE_END','LEAVE_DATE_BEGIN','LEAVE_WORK_SEND','LEAVE_CONTACT_PHONE','LOCATION_NAME','LEAVE_TYPE_NAME','LEAVE_PERSON_FULLNAME','LEAVE_YEAR_ID','STATUS_NAME','STATUS_CODE','gleave_register.created_at','LEAVE_CONTACT','LEAVE_SUM_ALL','WORK_DO','LEAVE_SUM_HOLIDAY','LEAVE_SUM_SETSUN','LEAVE_COMMENT_BY','DAY_TYPE_ID','LEAVE_APP_H1','LEAVE_APP_H2','LEAVE_APP_SEND')
        ->leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_ID')
        ->leftJoin('gleave_status','gleave_register.LEAVE_STATUS_CODE','=','gleave_status.STATUS_CODE')
        ->leftJoin('gleave_location','gleave_register.LOCATION_ID','=','gleave_location.LOCATION_ID')
        ->where('LEAVE_WORK_SEND_ID','=',$iduser)
        ->where('LEAVE_STATUS_CODE','=',$status)
        ->where(function($q) use ($search){
            $q->where('LEAVE_YEAR_ID','like','%'.$search.'%');
            $q->orwhere('LEAVE_PERSON_FULLNAME','like','%'.$search.'%');
            $q->orwhere('LEAVE_TYPE_NAME','like','%'.$search.'%');
            $q->orwhere('LEAVE_BECAUSE','like','%'.$search.'%');
        })
        ->orderBy('gleave_register.ID', 'desc')
        ->get();

         }

    }

    }



     $infostatus =  LeaveStatus::get();
     $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

     $year_id = $yearbudget;

    return view('person_leave.personleaveinfoaccept',[
        'inforpersonuser' => $inforpersonuser,
        'inforpersonuserid' => $inforpersonuserid,
        'inforleaves' => $inforleave,
        'infostatuss' => $infostatus,
        'displaydate_bigen'=> $displaydate_bigen, 
        'displaydate_end'=> $displaydate_end,
        'status_check' => $status,
        'search' => $search,
        'year_id'=>$year_id, 
        'budgets' =>  $budget,
    ]);



}




public function updateappsend(Request $request)
{

    $id = $request->ID;
    $statuscode =  $request->SUBMIT;          
    $updateapp = Leave_register::find($id);
    $updateapp->LEAVE_APP_SEND = $statuscode;
    $updateapp->save();
  
    return redirect()->route('leave.leaveinfoaccept',['iduser'=>  $request->PERSON_ID]);
        
}



//-------------------แนบเอกสาร

public function   leavecertificate(Request $request,$id,$iduser)
{
    $inforleave=  Leave_register::where('ID','=',$id)
    ->first();

    $detailleave = Leave_register::where('ID','=',$id)->first();
    return view('person_leave.personinfoleavecertificate',[
        'detailleave' => $detailleave,
        'inforleave' => $inforleave 
    ]);
    
}

  
public function leavecertificate_save(Request $request)
{
   
                $idfile = $request->ID;

       

           if($request->hasFile('pdfupload')){
               $newFileName = 'certificate_'.$idfile.'.'.$request->pdfupload->extension();
                 
               $request->pdfupload->storeAs('leavepdf',$newFileName,'public');
     
   
           }

          
         
           return redirect()->route('leave.inforuser',['iduser'=>  $request->PERSON_ID]);

    
}



}