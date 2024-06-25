<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Person;
use App\Models\Suppliesrequest;
use App\Models\Suppliesrequestsub;
use App\Models\Suppliescon;
use App\Models\Permislist;


date_default_timezone_set("Asia/Bangkok");

class SupliesController extends Controller
{

            public function dashboard(Request $request,$iduser)
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

                //=====================================================
                $m_budget = date("m");
                if($m_budget>9){
                $yearbudget = date("Y")+544;
                }else{
                $yearbudget = date("Y")+543;
                }


                $amount_1 = Suppliesrequest::where('STATUS','<>','cancel')->where('DEP_SUB_SUB_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)->where('BUDGET_YEAR','=',$yearbudget)->count();
                $amount_2 = Suppliesrequest::where('STATUS','=','Approve')->where('DEP_SUB_SUB_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)->where('BUDGET_YEAR','=',$yearbudget)->count();
                $amount_3 = Suppliesrequest::where('STATUS','=','Verify')->where('DEP_SUB_SUB_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)->where('BUDGET_YEAR','=',$yearbudget)->count();
                $amount_4 = Suppliesrequest::where('STATUS','=','Allow')->where('DEP_SUB_SUB_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)->where('BUDGET_YEAR','=',$yearbudget)->count();
                
                $amount_5 = Suppliesrequest::where('STATUS','=','Pending')->where('DEP_SUB_SUB_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)->where('BUDGET_YEAR','=',$yearbudget)->count();
                $amount_6 = Suppliesrequest::where('STATUS','=','Disapprove')->where('DEP_SUB_SUB_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)->where('BUDGET_YEAR','=',$yearbudget)->count();
                $amount_7 = Suppliesrequest::where('STATUS','=','Disverify')->where('DEP_SUB_SUB_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)->where('BUDGET_YEAR','=',$yearbudget)->count();
                $amount_8 = Suppliesrequest::where('STATUS','=','Disallow')->where('DEP_SUB_SUB_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)->where('BUDGET_YEAR','=',$yearbudget)->count();

                $budget_1 = Suppliescon::where('BUDGET_ID','=',1)->where('DEP_REQUEST_ID','=',$inforpersonuser->HR_DEPARTMENT_ID)->where('CON_YEAR_ID','=',$yearbudget)->count();  
                $budget_2 = Suppliescon::where('BUDGET_ID','=',2)->where('DEP_REQUEST_ID','=',$inforpersonuser->HR_DEPARTMENT_ID)->where('CON_YEAR_ID','=', $yearbudget)->count(); 
                $budget_3 = Suppliescon::where('BUDGET_ID','=',3)->where('DEP_REQUEST_ID','=',$inforpersonuser->HR_DEPARTMENT_ID)->where('CON_YEAR_ID','=', $yearbudget)->count(); 
                $budget_4 = Suppliescon::where('BUDGET_ID','=',4)->where('DEP_REQUEST_ID','=',$inforpersonuser->HR_DEPARTMENT_ID)->where('CON_YEAR_ID','=', $yearbudget)->count(); 
                $budget_5 = Suppliescon::where('BUDGET_ID','=',5)->where('DEP_REQUEST_ID','=',$inforpersonuser->HR_DEPARTMENT_ID)->where('CON_YEAR_ID','=', $yearbudget)->count(); 
                $budget_6 = Suppliescon::where('BUDGET_ID','=',6)->where('DEP_REQUEST_ID','=',$inforpersonuser->HR_DEPARTMENT_ID)->where('CON_YEAR_ID','=', $yearbudget)->count();  

                $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
                $year_id = $yearbudget;
                return view('general_suplies.dashboard_gensuplies',[ 
                    'budgets' =>  $budget,
                    'inforpersonuserid' => $inforpersonuserid,
                    'inforpersonuser' => $inforpersonuser,
                    'amount_1'=>$amount_1,
                    'amount_2'=>$amount_2,
                    'amount_3'=>$amount_3,
                    'amount_4'=>$amount_4,
                    'amount_5'=>$amount_5,
                    'amount_6'=>$amount_6,
                    'amount_7'=>$amount_7,
                    'amount_8'=>$amount_8,
                    'budget_1'=>$budget_1,
                    'budget_2'=>$budget_2,
                    'budget_3'=>$budget_3,
                    'budget_4'=>$budget_4,
                    'budget_5'=>$budget_5,
                    'budget_6'=>$budget_6,
                    'year_id'=>$year_id            
                ]);
            }



            public function dashboardsearch(Request $request,$iduser)
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

                //=====================================================
                $year_id = $request->STATUS_CODE;

                $yearbudget = $year_id;

                $amount_1 = Suppliesrequest::where('STATUS','<>','cancel')->where('DEP_SUB_SUB_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)->where('BUDGET_YEAR','=',$yearbudget)->count();
                $amount_2 = Suppliesrequest::where('STATUS','=','Approve')->where('DEP_SUB_SUB_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)->where('BUDGET_YEAR','=',$yearbudget)->count();
                $amount_3 = Suppliesrequest::where('STATUS','=','Verify')->where('DEP_SUB_SUB_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)->where('BUDGET_YEAR','=',$yearbudget)->count();
                $amount_4 = Suppliesrequest::where('STATUS','=','Allow')->where('DEP_SUB_SUB_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)->where('BUDGET_YEAR','=',$yearbudget)->count();

                $amount_5  = Suppliesrequest::where('STATUS','=','Pending')->where('DEP_SUB_SUB_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)->where('BUDGET_YEAR','=',$yearbudget)->count();
                $amount_6 = Suppliesrequest::where('STATUS','=','Disapprove')->where('DEP_SUB_SUB_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)->where('BUDGET_YEAR','=',$yearbudget)->count();
                $amount_7 = Suppliesrequest::where('STATUS','=','Disverify')->where('DEP_SUB_SUB_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)->where('BUDGET_YEAR','=',$yearbudget)->count();
                $amount_8 = Suppliesrequest::where('STATUS','=','Disallow')->where('DEP_SUB_SUB_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)->where('BUDGET_YEAR','=',$yearbudget)->count();

                
                $budget_1 = Suppliescon::where('BUDGET_ID','=',1)->where('DEP_REQUEST_ID','=',$inforpersonuser->HR_DEPARTMENT_ID)->where('CON_YEAR_ID','=',$yearbudget)->count();  
                $budget_2 = Suppliescon::where('BUDGET_ID','=',2)->where('DEP_REQUEST_ID','=',$inforpersonuser->HR_DEPARTMENT_ID)->where('CON_YEAR_ID','=', $yearbudget)->count(); 
                $budget_3 = Suppliescon::where('BUDGET_ID','=',3)->where('DEP_REQUEST_ID','=',$inforpersonuser->HR_DEPARTMENT_ID)->where('CON_YEAR_ID','=', $yearbudget)->count(); 
                $budget_4 = Suppliescon::where('BUDGET_ID','=',4)->where('DEP_REQUEST_ID','=',$inforpersonuser->HR_DEPARTMENT_ID)->where('CON_YEAR_ID','=', $yearbudget)->count(); 
                $budget_5 = Suppliescon::where('BUDGET_ID','=',5)->where('DEP_REQUEST_ID','=',$inforpersonuser->HR_DEPARTMENT_ID)->where('CON_YEAR_ID','=', $yearbudget)->count(); 
                $budget_6 = Suppliescon::where('BUDGET_ID','=',6)->where('DEP_REQUEST_ID','=',$inforpersonuser->HR_DEPARTMENT_ID)->where('CON_YEAR_ID','=', $yearbudget)->count();  

                $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
             
                return view('general_suplies.dashboard_gensuplies',[ 
                    'budgets' =>  $budget,
                    'inforpersonuserid' => $inforpersonuserid,
                    'inforpersonuser' => $inforpersonuser,
                    'amount_1'=>$amount_1,
                    'amount_2'=>$amount_2,
                    'amount_3'=>$amount_3,
                    'amount_4'=>$amount_4,
                    'amount_5'=>$amount_5,
                    'amount_6'=>$amount_6,
                    'amount_7'=>$amount_7,
                    'amount_8'=>$amount_8,
                    'budget_1'=>$budget_1,
                    'budget_2'=>$budget_2,
                    'budget_3'=>$budget_3,
                    'budget_4'=>$budget_4,
                    'budget_5'=>$budget_5,
                    'budget_6'=>$budget_6,
                    'year_id'=>$year_id            
                ]);
            }





    public function inforequest(Request $request,$iduser)
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


        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;
        }

        $inforequest = Suppliesrequest::leftJoin('supplies_request_status','supplies_request_status.STATUS_CODE','=','supplies_request.STATUS')
        ->where('DEP_SUB_SUB_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)
        ->where('BUDGET_YEAR','=', $yearbudget)
        ->orderBy('supplies_request.ID', 'desc')
        ->get();
       
        $sumbudget  = Suppliesrequest::where('DEP_SUB_SUB_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)
        ->where('BUDGET_YEAR','=', $yearbudget)
        ->sum('BUDGET_SUM');

        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        $info_sendstatus = DB::table('supplies_request_status')->get();

        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';
        $status = '';
        $search = '';
        $year_id =  $yearbudget;

        return view('general_suplies.inforequest',[
            'budgets' =>  $budget,
            'inforpersonuserid' => $inforpersonuserid,
            'inforpersonuser' => $inforpersonuser,
            'inforequests' => $inforequest,
            'info_sendstatuss' => $info_sendstatus,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id,  
            'sumbudget'=>$sumbudget 
        ]);

    }

//============================== Start inforequestsearch =====================//
    public function inforequestsearch(Request $request,$iduser)
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
        $yearbudget = $request->YEAR_ID;
        $datebigin = $request->get('DATE_BIGIN');
        $dateend = $request->get('DATE_END');

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
        $date = date('Y-m-d');
      
     
      
            $from = date($displaydate_bigen);
            $to = date($displaydate_end);

            if($status == null){

                $inforequest = Suppliesrequest::leftJoin('supplies_request_status','supplies_request_status.STATUS_CODE','=','supplies_request.STATUS')

                ->where('DEP_SUB_SUB_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)
                ->where('BUDGET_YEAR','=', $yearbudget)
                ->where(function($q) use ($search){
                     $q->where('REQUEST_FOR','like','%'.$search.'%');
                     $q->orwhere('REQUEST_BUY_COMMENT','like','%'.$search.'%');
                     $q->orwhere('SAVE_HR_DEP_SUB_NAME','like','%'.$search.'%');
                     $q->orwhere('REQUEST_ID','like','%'.$search.'%');
                     $q->orwhere('REQUEST_VANDOR_NAME','like','%'.$search.'%');
                })
                    ->WhereBetween('DATE_WANT',[$from,$to])
                ->orderBy('supplies_request.ID', 'desc')
                ->get();


                $sumbudget  = Suppliesrequest::leftJoin('supplies_request_status','supplies_request_status.STATUS_CODE','=','supplies_request.STATUS')
                ->where('DEP_SUB_SUB_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)
                ->where('BUDGET_YEAR','=', $yearbudget)
                ->where(function($q) use ($search){
                     $q->where('REQUEST_FOR','like','%'.$search.'%');
                     $q->orwhere('REQUEST_BUY_COMMENT','like','%'.$search.'%');
                     $q->orwhere('SAVE_HR_DEP_SUB_NAME','like','%'.$search.'%');
                     $q->orwhere('REQUEST_ID','like','%'.$search.'%');
                     $q->orwhere('REQUEST_VANDOR_NAME','like','%'.$search.'%');
                })
                    ->WhereBetween('DATE_WANT',[$from,$to])
                ->sum('BUDGET_SUM');

                

            }else{

                $inforequest = Suppliesrequest::leftJoin('supplies_request_status','supplies_request_status.STATUS_CODE','=','supplies_request.STATUS')
                ->where('DEP_SUB_SUB_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)
                ->where('STATUS_CODE','=',$status)
                ->where('BUDGET_YEAR','=', $yearbudget)
                ->where(function($q) use ($search){
                     $q->where('REQUEST_FOR','like','%'.$search.'%');
                     $q->orwhere('REQUEST_BUY_COMMENT','like','%'.$search.'%');
                     $q->orwhere('SAVE_HR_DEP_SUB_NAME','like','%'.$search.'%');
                     $q->orwhere('REQUEST_ID','like','%'.$search.'%');
                     $q->orwhere('REQUEST_VANDOR_NAME','like','%'.$search.'%');
                })
                    ->WhereBetween('DATE_WANT',[$from,$to])
                ->orderBy('supplies_request.ID', 'desc')
                ->get();


                $sumbudget  =Suppliesrequest::leftJoin('supplies_request_status','supplies_request_status.STATUS_CODE','=','supplies_request.STATUS')
                ->where('DEP_SUB_SUB_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)
                ->where('STATUS_CODE','=',$status)
                ->where('BUDGET_YEAR','=', $yearbudget)
                ->where(function($q) use ($search){
                     $q->where('REQUEST_FOR','like','%'.$search.'%');
                     $q->orwhere('REQUEST_BUY_COMMENT','like','%'.$search.'%');
                     $q->orwhere('SAVE_HR_DEP_SUB_NAME','like','%'.$search.'%');
                     $q->orwhere('REQUEST_ID','like','%'.$search.'%');
                     $q->orwhere('REQUEST_VANDOR_NAME','like','%'.$search.'%');
                })
                ->WhereBetween('DATE_WANT',[$from,$to])
                ->sum('BUDGET_SUM');

                

            }
       
        

        $info_sendstatus = DB::table('supplies_request_status')->get();
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $year_id = $yearbudget;
        return view('general_suplies.inforequest',[
            'budgets' =>  $budget,
            'inforpersonuserid' => $inforpersonuserid,
            'inforpersonuser' => $inforpersonuser,
            'inforequests' => $inforequest,
            // 'infoasset_res' => $infoasset_re,
             'info_sendstatuss' => $info_sendstatus,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id,
            'sumbudget'=>$sumbudget,
          

        ]);

    }
//============================== end =====================//

    public function inforequestadd(Request $request,$iduser)
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

        $suppliestype = DB::table('supplies_type')->where('ACTIVE','=','True')->get();

        $pessonall = Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')->orderBy('hrd_person.HR_FNAME', 'asc')->get();

        $departmentsubsub = DB::table('hrd_department_sub_sub')->where('ACTIVE','=','True')->get();

        $orgname = DB::table('info_org')->first();

        // $personhead =  DB::table('hrd_department_sub_sub')->where('HR_DEPARTMENT_SUB_SUB_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)->first();
        $personhead =  DB::table('hrd_department_sub_sub')->where('HR_DEPARTMENT_SUB_SUB_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)->first();

        $suppliesvendor = DB::table('supplies_vendor')->where('ACTIVE','=','True')->get();
    


        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;
        }

        $budget = DB::table('budget_year')->where('ACTIVE','=','True')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        
        $phone = DB::table('hrd_department_sub_sub')->where('HR_DEPARTMENT_SUB_SUB_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)->first();
    
        return view('general_suplies.inforequestadd',[
            'budgets' => $budget,
            'inforpersonuser' => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid,
            'suppliestypes' => $suppliestype,
            'pessonalls' => $pessonall,
            'departmentsubsubs' => $departmentsubsub,
            'orgname' => $orgname->ORG_NAME,
            'suppliesvendors' => $suppliesvendor,
            'personhead' => $personhead,
            'phone' => $phone,
            'year_id' => $yearbudget
        ]);

    }

    public function saveinforequest(Request $request)
    {

        // $request->validate([
        //     'REQUEST_FOR_ID' => 'required',
        //     'AGREE_HR_ID' => 'required',
        //     'REQUEST_BUY_COMMENT' => 'required',

        // ]);  

             $DATEWANT = $request->DATE_WANT;

             if($DATEWANT != ''){
                $DAY = Carbon::createFromFormat('d/m/Y', $DATEWANT)->format('Y-m-d');
                $date_arrary_st=explode("-",$DAY);
                $y_sub_st = $date_arrary_st[0];

                if($y_sub_st >= 2500){
                    $y_st = $y_sub_st-543;
                }else{
                    $y_st = $y_sub_st;
                }
                $m_st = $date_arrary_st[1];
                $d_st = $date_arrary_st[2];
                $DATEWANT= $y_st."-".$m_st."-".$d_st;
                }else{
                $DATEWANT= null;
            }



            $m_budget = date("m");
            if($m_budget>9){
            $yearbudget = date("Y")+544;
            }else{
            $yearbudget = date("Y")+543;
            }
    
      //===============================สร้างเลขREQ
    
         $maxnumber = DB::table('supplies_request')->where('BUDGET_YEAR','=',$yearbudget)->max('ID');     
         if($maxnumber != '' ||  $maxnumber != null){        
             $refmax = DB::table('supplies_request')->where('ID','=',$maxnumber)->first();  
             if($refmax->REQUEST_ID != '' ||  $refmax->REQUEST_ID != null){
                 $maxref = substr($refmax->REQUEST_ID, -4)+1;
              }else{
                 $maxref = 1;
              }
             $ref = str_pad($maxref, 4, "0", STR_PAD_LEFT);        
         }else{
             $ref = '0001';
         }       
         $y = substr($yearbudget, -2); 
            $refnumber ='REQ-'.$y.''.$ref;

            $addinforequest = new Suppliesrequest();
            $addinforequest->REQUEST_ID = $refnumber;
            $addinforequest->REQUEST_HEAD = $request->REQUEST_HEAD;
            $addinforequest->DATE_WANT = $DATEWANT;
            $addinforequest->DATE_TIME_SAVE = date('Y-m-d H:i:s');


            $addinforequest->REQUEST_FOR_ID = $request->REQUEST_FOR_ID;
            $name_type = DB::table('supplies_type')->where('SUP_TYPE_ID','=',$request->REQUEST_FOR_ID)->first();
            $addinforequest->REQUEST_FOR = $name_type->SUP_TYPE_NAME;

            $addinforequest->DEP_SUB_SUB_ID = $request->DEP_SUB_SUB_ID;
            $addinforequest->DEP_SUB_SUB_PHONE = $request->DEP_SUB_SUB_PHONE;

            $addinforequest->SAVE_HR_ID = $request->SAVE_HR_ID;


              //----------------------------------
              $SAVEHR =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
              ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
              ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
              ->where('hrd_person.ID','=',$request->SAVE_HR_ID)->first();

                    $addinforequest->SAVE_HR_NAME = $SAVEHR->HR_PREFIX_NAME.''.$SAVEHR->HR_FNAME.' '.$SAVEHR->HR_LNAME;
                    $addinforequest->SAVE_HR_POSITION = $SAVEHR->HR_POSITION_NAME;
                    $addinforequest->SAVE_HR_DEP_SUB_NAME = $SAVEHR->HR_DEPARTMENT_SUB_NAME;

               //----------------------------------

                    $addinforequest->AGREE_HR_ID = $request->AGREE_HR_ID;

                 //----------------------------------
                 $AGREEHR =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                 ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
                 ->where('hrd_person.ID','=',$request->AGREE_HR_ID)->first();

                    $addinforequest->AGREE_HR_NAME = $AGREEHR->HR_PREFIX_NAME.''.$AGREEHR->HR_FNAME.' '.$AGREEHR->HR_LNAME;
                    $addinforequest->AGREE_HR_POSITION = $AGREEHR->HR_POSITION_NAME;

                  //----------------------------------

                    $addinforequest->REQUEST_BUY_COMMENT = $request->REQUEST_BUY_COMMENT;

                    $addinforequest->HIRE_DETAIL = $request->HIRE_DETAIL;

                    $addinforequest->STATUS = 'Pending';

                    $addinforequest->BUDGET_YEAR = $request->YEAR_ID;

                    $addinforequest->REQUEST_VANDOR_ID = $request->REQUEST_VANDOR_ID;

                   if($request->REQUEST_VANDOR_ID <> ''){
                    $infovendor = DB::table('supplies_vendor')->where('VENDOR_ID','=',$request->REQUEST_VANDOR_ID)->first();
                    $addinforequest->REQUEST_VANDOR_NAME = $infovendor->VENDOR_NAME;
                   }else{
                  
                    $addinforequest->REQUEST_VANDOR_NAME = '';
                   }
                   


                    $addinforequest->REQUEST_REMARK = $request->REQUEST_REMARK;

                    $addinforequest->save();



                    $SUPPLIES_REQUEST_ID = Suppliesrequest::max('ID');

            if($request->SUPPLIES_REQUEST_SUBRE_ID != '' || $request->SUPPLIES_REQUEST_SUBRE_ID != null){

                $SUPPLIES_REQUEST_SUBRE_ID = $request->SUPPLIES_REQUEST_SUBRE_ID;
                
                $SUPPLIES_REQUEST_SUB_AMOUNT = $request->SUPPLIES_REQUEST_SUB_AMOUNT;
                $SUPPLIES_REQUEST_SUB_UNIT = $request->SUPPLIES_REQUEST_SUB_UNIT;
                $SUPPLIES_REQUEST_SUB_PRICE = $request->SUPPLIES_REQUEST_SUB_PRICE;
               

                $number =count($SUPPLIES_REQUEST_SUBRE_ID);
                $count = 0;
                for($count = 0; $count< $number; $count++)
                {
                  //echo $row3[$count_3]."<br>";

                   $add = new Suppliesrequestsub();
                   $add->SUPPLIES_REQUEST_ID = $SUPPLIES_REQUEST_ID;
                   $add->SUPPLIES_REQUEST_SUBRE_ID = $SUPPLIES_REQUEST_SUBRE_ID[$count];
                   $infosup = DB::table('supplies')->where('ID','=',$SUPPLIES_REQUEST_SUBRE_ID[$count])->first();
                   $add->SUPPLIES_REQUEST_SUB_DETAIL = $infosup->SUP_NAME;

                   $add->SUPPLIES_REQUEST_SUB_AMOUNT = $SUPPLIES_REQUEST_SUB_AMOUNT[$count];
                   $add->SUPPLIES_REQUEST_SUB_UNIT = $SUPPLIES_REQUEST_SUB_UNIT[$count];
                   $add->SUPPLIES_REQUEST_SUB_PRICE = $SUPPLIES_REQUEST_SUB_PRICE[$count];
    
                   $add->SUPPLIES_REQUEST_SUB_SUM_PRICE = $SUPPLIES_REQUEST_SUB_PRICE[$count] * $SUPPLIES_REQUEST_SUB_AMOUNT[$count];

                   $add->save();


                }
            }

            $BUDGET_SUM = Suppliesrequestsub::where('SUPPLIES_REQUEST_ID','=',$SUPPLIES_REQUEST_ID)->sum('SUPPLIES_REQUEST_SUB_SUM_PRICE');

            $updatesum = Suppliesrequest::find($SUPPLIES_REQUEST_ID );
            $updatesum->BUDGET_SUM = $BUDGET_SUM;
            $updatesum->save();


            return redirect()->route('suplies.inforequest',[
                'iduser' => $request->SAVE_HR_ID,

            ]);

            // return response()->json([
            //     'status' => 1,
            //     'url' => url('general_suplies/inforequest/'.$request->SAVE_HR_ID)
            // ]);
    }


  //====================================================approve======================

    public function inforequestapp(Request $request,$iduser)
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

        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;
        }
       
       
        $inforequest = Suppliesrequest::leftJoin('supplies_request_status','supplies_request_status.STATUS_CODE','=','supplies_request.STATUS')
        ->orderBy('supplies_request.ID', 'desc')
        ->where('BUDGET_YEAR','=', $yearbudget)
        ->where('AGREE_HR_ID','=',$iduser)
        ->where('STATUS','=','Pending')->get();
     
        $sumbudget  = Suppliesrequest::where('AGREE_HR_ID','=',$iduser)
        ->where('BUDGET_YEAR','=', $yearbudget)
        ->where('STATUS','=','Pending')
        ->sum('BUDGET_SUM');

        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        $info_sendstatus = DB::table('supplies_request_status')->get();

        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';
        $status = 'Pending';
        $search = '';
        $year_id = $yearbudget;

        return view('general_suplies.inforequestapp',[
            'budgets' =>  $budget,
            'inforpersonuserid' => $inforpersonuserid,
            'inforpersonuser' => $inforpersonuser,
            'inforequests' => $inforequest,
            'info_sendstatuss' => $info_sendstatus,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id, 
            'sumbudget'=>$sumbudget
        ]);

    }

//============================== Start inforequestappsearch =====================//
    public function inforequestappsearch(Request $request,$iduser)
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
            $yearbudget = $request->YEAR_ID;
            $datebigin = $request->get('DATE_BIGIN');
            $dateend = $request->get('DATE_END');

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
            $date = date('Y-m-d');
        

          

                $from = date($displaydate_bigen);
                $to = date($displaydate_end);

                if($status == null){

                    $inforequest = Suppliesrequest::leftJoin('supplies_request_status','supplies_request_status.STATUS_CODE','=','supplies_request.STATUS')
                    ->where('BUDGET_YEAR','=', $yearbudget)
                    ->where('AGREE_HR_ID','=',$iduser)
                    ->where(function($q) use ($search){
                        $q->where('REQUEST_FOR','like','%'.$search.'%');
                        $q->orwhere('BUDGET_SUM','like','%'.$search.'%');
                        $q->orwhere('SAVE_HR_DEP_SUB_NAME','like','%'.$search.'%');
                        $q->orwhere('REQUEST_ID','like','%'.$search.'%');
                        $q->orwhere('REQUEST_VANDOR_NAME','like','%'.$search.'%');
                        $q->orwhere('SAVE_HR_NAME','like','%'.$search.'%');
                    })
                        ->WhereBetween('DATE_WANT',[$from,$to])
                    ->orderBy('supplies_request.ID', 'desc')
                    ->get();

                    $sumbudget = Suppliesrequest::leftJoin('supplies_request_status','supplies_request_status.STATUS_CODE','=','supplies_request.STATUS')
                    ->where('BUDGET_YEAR','=', $yearbudget)
                    ->where('AGREE_HR_ID','=',$iduser)
                    ->where(function($q) use ($search){
                        $q->where('REQUEST_FOR','like','%'.$search.'%');
                        $q->orwhere('BUDGET_SUM','like','%'.$search.'%');
                        $q->orwhere('SAVE_HR_DEP_SUB_NAME','like','%'.$search.'%');
                        $q->orwhere('REQUEST_ID','like','%'.$search.'%');
                        $q->orwhere('REQUEST_VANDOR_NAME','like','%'.$search.'%');
                        $q->orwhere('SAVE_HR_NAME','like','%'.$search.'%');
                    })
                        ->WhereBetween('DATE_WANT',[$from,$to])
                    ->sum('BUDGET_SUM');


                }else{

                    $inforequest = Suppliesrequest::leftJoin('supplies_request_status','supplies_request_status.STATUS_CODE','=','supplies_request.STATUS')
                    ->where('BUDGET_YEAR','=', $yearbudget)
                    ->where('AGREE_HR_ID','=',$iduser)
                    ->where('STATUS_CODE','=',$status)
                    ->where(function($q) use ($search){
                        $q->where('REQUEST_FOR','like','%'.$search.'%');
                        $q->orwhere('BUDGET_SUM','like','%'.$search.'%');
                        $q->orwhere('SAVE_HR_DEP_SUB_NAME','like','%'.$search.'%');
                        $q->orwhere('REQUEST_ID','like','%'.$search.'%');
                        $q->orwhere('REQUEST_VANDOR_NAME','like','%'.$search.'%');
                        $q->orwhere('SAVE_HR_NAME','like','%'.$search.'%');
                    })
                        ->WhereBetween('DATE_WANT',[$from,$to])
                    ->orderBy('supplies_request.ID', 'desc')
                    ->get();

                    $sumbudget = Suppliesrequest::leftJoin('supplies_request_status','supplies_request_status.STATUS_CODE','=','supplies_request.STATUS')
                    ->where('BUDGET_YEAR','=', $yearbudget)
                    ->where('AGREE_HR_ID','=',$iduser)
                    ->where('STATUS_CODE','=',$status)
                    ->where(function($q) use ($search){
                        $q->where('REQUEST_FOR','like','%'.$search.'%');
                        $q->orwhere('BUDGET_SUM','like','%'.$search.'%');
                        $q->orwhere('SAVE_HR_DEP_SUB_NAME','like','%'.$search.'%');
                        $q->orwhere('REQUEST_ID','like','%'.$search.'%');
                        $q->orwhere('REQUEST_VANDOR_NAME','like','%'.$search.'%');
                        $q->orwhere('SAVE_HR_NAME','like','%'.$search.'%');
                    })
                        ->WhereBetween('DATE_WANT',[$from,$to])
                    ->sum('BUDGET_SUM');
                }
        

            $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
            $info_sendstatus = DB::table('supplies_request_status')->get();
            $year_id = $yearbudget;

            return view('general_suplies.inforequestapp',[
                'budgets' =>  $budget,
                'inforpersonuserid' => $inforpersonuserid,
                'inforpersonuser' => $inforpersonuser,
                'inforequests' => $inforequest,
                // 'infoasset_res' => $infoasset_re,
                'info_sendstatuss' => $info_sendstatus,
                'displaydate_bigen'=> $displaydate_bigen,
                'displaydate_end'=> $displaydate_end,
                'status_check'=> $status,
                'search'=> $search,
                'year_id'=>$year_id,
                'sumbudget' => $sumbudget 

            ]);

        }
//============================== end =====================//

    public function updateinforequestapp(Request $request)
    {
        //$email = Auth::user()->email;
        //return $request->all();
        $id = $request->ID;

        $check =  $request->SUBMIT;

        if($check == 'approved'){
          $statuscode = 'Approve';
        }else{
          $statuscode = 'Disapprove';
        }


          $updateapp = Suppliesrequest::find($id);
          $updateapp->AGREE_COMMENT = $request->AGREE_COMMENT;
          $updateapp->STATUS = $statuscode;

          $updateapp->AGREE_HR_ID = $request->AGREE_HR_ID;
           //----------------------------------
           $AGREEHR =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
           ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
           ->where('hrd_person.ID','=',$request->AGREE_HR_ID)->first();

            $updateapp->AGREE_HR_NAME = $AGREEHR->HR_PREFIX_NAME.''.$AGREEHR->HR_FNAME.' '.$AGREEHR->HR_LNAME;
            $updateapp->AGREE_HR_POSITION = $AGREEHR->HR_POSITION_NAME;


            //----------------------------------



          //dd($educationedit);

          $updateapp->save();

              //
              //return redirect()->action('OtherController@infouserother');
              return redirect()->route('suplies.inforequestadd',['iduser'=>  $request->AGREE_HR_ID]);

    }

  //====================================================verify======================
    public function inforequestver(Request $request,$iduser)
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

        $inforequest = Suppliesrequest::leftJoin('supplies_request_status','supplies_request_status.STATUS_CODE','=','supplies_request.STATUS')
        ->orderBy('supplies_request.ID', 'desc')
        ->where('STATUS','=','Approve')
        ->get();

        $info_sendstatus = DB::table('supplies_request_status')->get();
        $displaydate_bigen = '';
        $displaydate_end = '';
        $status = '';
        $search = '';

        return view('general_suplies.inforequestver',[
            'inforpersonuserid' => $inforpersonuserid,
            'inforpersonuser' => $inforpersonuser,
            'inforequests' => $inforequest,
            'info_sendstatuss' => $info_sendstatus,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search
        ]);

    }




public function updateinforequestver(Request $request)
{
    $id = $request->ID;
    $check =  $request->SUBMIT;

    if($check == 'approved'){
      $statuscode = 'Verify';
    }else{
      $statuscode = 'Disverify';
    }

      $updatever = Suppliesrequest::find($id);

      $updatever->STATUS = $statuscode;
      $updatever->USER_CONFIRM_CHECK_ID = $request->USER_CONFIRM_CHECK_ID;
      //----------------------------------
      $USERCONFIRM=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
      ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
      ->where('hrd_person.ID','=',$request->USER_CONFIRM_CHECK_ID)->first();

       $updatever->USER_CONFIRM_CHECK_NAME = $USERCONFIRM->HR_PREFIX_NAME.''.$USERCONFIRM->HR_FNAME.' '.$USERCONFIRM->HR_LNAME;
       $updatever->USER_CONFIRM_CHECK_POSITION = $USERCONFIRM->HR_POSITION_NAME;
       //----------------------------------
       $updatever->USER_CONFIRM_CHECK_DATE = date('Y-m-d H:i:s');

      $updatever->save();

          return redirect()->route('suplies.inforequestver',['iduser'=>  $request->USER_CONFIRM_CHECK_ID]);

}

//====================================================lastapp======================
public function inforequestlastapp(Request $request,$iduser)
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


    $inforequest = Suppliesrequest::leftJoin('supplies_request_status','supplies_request_status.STATUS_CODE','=','supplies_request.STATUS')
    ->orderBy('supplies_request.ID', 'desc')
    ->where('STATUS','=','Verify')
    ->get();

    $sumbudget  =Suppliesrequest::leftJoin('supplies_request_status','supplies_request_status.STATUS_CODE','=','supplies_request.STATUS')
    ->orderBy('supplies_request.ID', 'desc')
    ->where('STATUS','=','Verify')
    ->sum('BUDGET_SUM');

    $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

    $info_sendstatus = DB::table('supplies_request_status')->get();

    $displaydate_bigen = ($yearbudget-544).'-10-01';
    $displaydate_end = ($yearbudget-543).'-09-30';
        $status = 'Verify';
        $search = '';
        $year_id = $yearbudget;

    return view('general_suplies.inforequestlastapp',[
        'budgets' =>  $budget,
        'inforpersonuserid' => $inforpersonuserid,
        'inforpersonuser' => $inforpersonuser,
        'inforequests' => $inforequest,
        'info_sendstatuss' => $info_sendstatus,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id,
            'sumbudget' => $sumbudget  
    ]);

}

//============================== Start inforequestlastappsearch =====================//
public function inforequestlastappsearch(Request $request,$iduser)
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
    $yearbudget = $request->YEAR_ID;
    $datebigin = $request->get('DATE_BIGIN');
    $dateend = $request->get('DATE_END');

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
    $date = date('Y-m-d');


        $from = date($displaydate_bigen);
        $to = date($displaydate_end);

        if($status == null){
           

            $inforequest = Suppliesrequest::leftJoin('supplies_request_status','supplies_request_status.STATUS_CODE','=','supplies_request.STATUS')
 
            ->where('BUDGET_YEAR','=', $yearbudget)
            ->where(function($q) use ($search){
                $q->where('REQUEST_FOR','like','%'.$search.'%');
                $q->orwhere('BUDGET_SUM','like','%'.$search.'%');
                $q->orwhere('SAVE_HR_DEP_SUB_NAME','like','%'.$search.'%');
                $q->orwhere('REQUEST_ID','like','%'.$search.'%');
                $q->orwhere('REQUEST_VANDOR_NAME','like','%'.$search.'%');
                $q->orwhere('SAVE_HR_NAME','like','%'.$search.'%');
            })
                ->WhereBetween('DATE_WANT',[$from,$to])
            ->orderBy('supplies_request.ID', 'desc')
            ->get();

            $sumbudget = Suppliesrequest::leftJoin('supplies_request_status','supplies_request_status.STATUS_CODE','=','supplies_request.STATUS')
          
            ->where('BUDGET_YEAR','=', $yearbudget)
            ->where(function($q) use ($search){
                $q->where('REQUEST_FOR','like','%'.$search.'%');
                $q->orwhere('BUDGET_SUM','like','%'.$search.'%');
                $q->orwhere('SAVE_HR_DEP_SUB_NAME','like','%'.$search.'%');
                $q->orwhere('REQUEST_ID','like','%'.$search.'%');
                $q->orwhere('REQUEST_VANDOR_NAME','like','%'.$search.'%');
                $q->orwhere('SAVE_HR_NAME','like','%'.$search.'%');
            })
                ->WhereBetween('DATE_WANT',[$from,$to])
                ->sum('BUDGET_SUM');

           

        }else{

            $inforequest = Suppliesrequest::leftJoin('supplies_request_status','supplies_request_status.STATUS_CODE','=','supplies_request.STATUS')
            ->where('BUDGET_YEAR','=', $yearbudget)
            ->where('STATUS_CODE','=',$status)
            ->where(function($q) use ($search){
                $q->where('REQUEST_FOR','like','%'.$search.'%');
                $q->orwhere('BUDGET_SUM','like','%'.$search.'%');
                $q->orwhere('SAVE_HR_DEP_SUB_NAME','like','%'.$search.'%');
                $q->orwhere('REQUEST_ID','like','%'.$search.'%');
                $q->orwhere('REQUEST_VANDOR_NAME','like','%'.$search.'%');
                $q->orwhere('SAVE_HR_NAME','like','%'.$search.'%');
            })
                ->WhereBetween('DATE_WANT',[$from,$to])
            ->orderBy('supplies_request.ID', 'desc')
            ->get();

            $sumbudget = Suppliesrequest::leftJoin('supplies_request_status','supplies_request_status.STATUS_CODE','=','supplies_request.STATUS')
            ->where('BUDGET_YEAR','=', $yearbudget)
            ->where('STATUS_CODE','=',$status)
            ->where(function($q) use ($search){
                $q->where('REQUEST_FOR','like','%'.$search.'%');
                $q->orwhere('BUDGET_SUM','like','%'.$search.'%');
                $q->orwhere('SAVE_HR_DEP_SUB_NAME','like','%'.$search.'%');
                $q->orwhere('REQUEST_ID','like','%'.$search.'%');
                $q->orwhere('REQUEST_VANDOR_NAME','like','%'.$search.'%');
                $q->orwhere('SAVE_HR_NAME','like','%'.$search.'%');
            })
                ->WhereBetween('DATE_WANT',[$from,$to])
                ->sum('BUDGET_SUM');

                //dd($inforequest);
        }
  

        

    $info_sendstatus = DB::table('supplies_request_status')->get();
   
    $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
    $year_id = $yearbudget;

    return view('general_suplies.inforequestlastapp',[
        'budgets' =>  $budget,
        'inforpersonuserid' => $inforpersonuserid,
        'inforpersonuser' => $inforpersonuser,
        'inforequests' => $inforequest,
        'info_sendstatuss' => $info_sendstatus,
        'displaydate_bigen'=> $displaydate_bigen,
        'displaydate_end'=> $displaydate_end,
        'status_check'=> $status,
        'search'=> $search,
        'year_id'=>$year_id,
        'sumbudget' => $sumbudget   

    ]);

}
//============================== end =====================//



public function updateinforequestlastapp(Request $request)
{
    //$email = Auth::user()->email;
    //return $request->all();
    $id = $request->ID;

    $check =  $request->SUBMIT;

    if($check == 'approved'){
      $statuscode = 'Allow';
    }else{
      $statuscode = 'Disallow';
    }


      $updatelastapp = Suppliesrequest::find($id);
      $updatelastapp->STATUS = $statuscode;
      $updatelastapp->TOP_LEADER_AC_COMMENT = $request->TOP_LEADER_AC_COMMENT;
      $updatelastapp->TOP_LEADER_AC_ID = $request->TOP_LEADER_AC_ID;
      //----------------------------------
      $TOPLEADER=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
      ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
      ->where('hrd_person.ID','=',$request->TOP_LEADER_AC_ID)->first();

       $updatelastapp->TOP_LEADER_AC_NAME = $TOPLEADER->HR_PREFIX_NAME.''.$TOPLEADER->HR_FNAME.' '.$TOPLEADER->HR_LNAME;

       //----------------------------------
       $updatelastapp->TOP_LEADER_AC_DATE_TIME = date('Y-m-d H:i:s');


      //dd($educationedit);

      $updatelastapp->save();

          //
          //return redirect()->action('OtherController@infouserother');
          return redirect()->route('suplies.inforequestlastapp',['iduser'=>  $request->TOP_LEADER_AC_ID]);

}

//==================================ฟังชั่น=====================================================

function checksummoney(Request $request)
{

  $SUPPLIES_REQUEST_SUB_AMOUNT = $request->get('SUPPLIES_REQUEST_SUB_AMOUNT');
  $SUPPLIES_REQUEST_SUB_PRICE = $request->get('SUPPLIES_REQUEST_SUB_PRICE');

  $output = $SUPPLIES_REQUEST_SUB_AMOUNT*$SUPPLIES_REQUEST_SUB_PRICE;


  echo $output;

}

function fetchdetail(Request $request)
{

  $id = $request->get('select');

  if($id == 'จ้างเหมาอื่นๆ' ){
     $output = '

                 <div class="row push">
                     <div class="col-lg-2">
                     <label>รายละเอียดการจ้างเหมา :</label>
                     </div>
                     <div class="col-lg-10">
                     <input name="HIRE_DETAIL" id="HIRE_DETAIL" class="form-control input-sm" style=" font-family: \'Kanit\', sans-serif;" >
                     </div>


                 </div>
';
  }else{
     $output = '<input type="hidden" name="HIRE_DETAIL" id="HIRE_DETAIL" class="form-control input-sm" style=" font-family: \'Kanit\', sans-serif;" value="">';
  }

 echo $output;


}





function detailapp(Request $request)
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


  $id = $request->get('id');

  $detail = DB::table('supplies_request')->where('ID','=',$id)->first();

  $detailperson = DB::table('hrd_person')->where('ID','=',$detail->SAVE_HR_ID)->first();

  $output ='
  <div class="row push" style="font-family: \'Kanit\', sans-serif;">
  <input type="hidden"  name="ID" value="'.$id.'"/>
  <div class="col-sm-10">
  <div class="row">

  <div class="col-sm-2">
      <div class="form-group">
      <label >ลงวันที่ :</label>
      </div>
  </div>
  <div class="col-sm-3 text-left">
      <div class="form-group" >
      <h1 style="font-family: \'Kanit\', sans-serif; font-size:10px;font-size: 1.0rem;font-weight:normal;color:#778899;">'.DateThai($detail -> DATE_WANT).'</h1>
      </div>
  </div>

  <div class="col-sm-2">
      <div class="form-group">
      <label >เพื่อจัดซื้อ/ซ่อมแซม  :</label>
      </div>
  </div>
  <div class="col-sm-3 text-left">
      <div class="form-group">
      <h1 style="font-family: \'Kanit\', sans-serif; font-size:10px;font-size: 1.0rem;font-weight:normal;color:#778899;">'.$detail -> REQUEST_FOR.'</h1>
      </div>
  </div>

  </div>

  <div class="row">

  <div class="col-sm-2">
      <div class="form-group">
      <label >ผู้แจ้งขอซื้อ/ขอจ้าง :</label>
      </div>
  </div>
  <div class="col-sm-3 text-left">
      <div class="form-group" >
      <h1 style="font-family: \'Kanit\', sans-serif; font-size:10px;font-size: 1.0rem;font-weight:normal;color:#778899;">'.$detail -> SAVE_HR_NAME.'</h1>
      </div>
  </div>

  <div class="col-sm-2">
      <div class="form-group">
      <label >หน่วยงานที่ร้องขอ  :</label>
      </div>
  </div>
  <div class="col-sm-3 text-left">
      <div class="form-group">
      <h1 style="font-family: \'Kanit\', sans-serif; font-size:10px;font-size: 1.0rem;font-weight:normal;color:#778899;" >'.$detail -> SAVE_HR_DEP_SUB_NAME.'</h1>
      </div>
  </div>

  </div>


  <div class="row">

  <div class="col-sm-2">
      <div class="form-group">
      <label >เบอร์โทร :</label>
      </div>
  </div>
  <div class="col-sm-3 text-left">
      <div class="form-group" >
      <h1 style="font-family: \'Kanit\', sans-serif; font-size:10px;font-size: 1.0rem;font-weight:normal;color:#778899;">'.$detailperson -> HR_PHONE.'</h1>
      </div>
  </div>

  <div class="col-sm-2">
      <div class="form-group">
      <label >เบอร์โทรหน่วยงาน:</label>
      </div>
  </div>
  <div class="col-sm-3 text-left">
      <div class="form-group">
      <h1 style="font-family: \'Kanit\', sans-serif; font-size:10px;font-size: 1.0rem;font-weight:normal;color:#778899;" >'.$detail -> DEP_SUB_SUB_PHONE.'</h1>
      </div>
  </div>
  </div>

  <div class="row">

        <div class="col-sm-2">
            <div class="form-group">
            <label >บริษัทแนะนำ :</label>
            </div>
        </div>
        <div class="col-sm-3 text-left">
            <div class="form-group" >
            <h1 style="font-family: \'Kanit\', sans-serif; font-size:10px;font-size: 1.0rem;font-weight:normal;color:#778899;">'.$detail -> REQUEST_VANDOR_NAME.'</h1>
            </div>
        </div>

        <div class="col-sm-2">
            <div class="form-group">
            <label >หมายเหตุ :</label>
            </div>
        </div>
        <div class="col-sm-3 text-left">
            <div class="form-group">
            <h1 style="font-family: \'Kanit\', sans-serif; font-size:10px;font-size: 1.0rem;font-weight:normal;color:#778899;" >'.$detail -> REQUEST_REMARK.'</h1>
            </div>
        </div>


</div>
  

</div>
  

  <div class="col-sm-2">
        
  <div class="form-group">
  <img src="data:image/png;base64,'. chunk_split(base64_encode($detailperson->HR_IMAGE)) .'"  height="100px" width="100px"/>

  </div>

  </div>

</div>
';
$output.=' 
<div align="right">จำนวนเงินรวม '.number_format($detail -> BUDGET_SUM,2).'  บาท</div>
<table class="table-bordered table-striped table-vcenter js-dataTable-simple" style="width: 100%;">
<thead style="background-color: #FFEBCD;">
    <tr height="40">
    <th  class="text-font" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;" width="5%">ลำดับ</th>
        <th  class="text-font" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">รายละเอียด</th>
        <th  class="text-font" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;" width="15%">จำนวน</th>
        <th  class="text-font" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;" width="15%">หน่วย</th>
        <th  class="text-font" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;" width="15%">ราคาต่อหน่วย</th>
        <th  class="text-font" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;" width="15%">จำนวนเงิน</th>

    </tr >
</thead>
<tbody>     ';

$detail_subs = DB::table('supplies_request_sub')
->leftjoin('supplies','supplies_request_sub.SUPPLIES_REQUEST_SUBRE_ID','=','supplies.ID')
->leftjoin('medical_type_item','medical_type_item.TYPE_ITEM_ID','=','supplies.SUP_GENUS')
->where('SUPPLIES_REQUEST_ID','=',$id)->get();
$count = 1;
foreach ($detail_subs as $detailsub){
  $output.='  <tr height="20">
  <td class="text-font" align="center" style="border: 1px solid black;" >'.$count.'</td>
  <td class="text-font text-pedding" style="border: 1px solid black;" >'.$detailsub->SUPPLIES_REQUEST_SUB_DETAIL.'  '.$detailsub->TYPE_ITEM_NAME.'  '.$detailsub->SUP_MASH.'</td>
  <td class="text-font" align="right" style="border: 1px solid black;padding-right:10px;" >'.$detailsub->SUPPLIES_REQUEST_SUB_AMOUNT.'</td>
  <td class="text-font" align="center" style="border: 1px solid black;" >'.$detailsub->SUPPLIES_REQUEST_SUB_UNIT.'</td>
  <td class="text-font" align="right" style="border: 1px solid black;padding-right:10px;" >'.number_format($detailsub->SUPPLIES_REQUEST_SUB_PRICE,2).'</td>
  <td class="text-font" align="right" style="border: 1px solid black;padding-right:10px;" >'.number_format($detailsub->SUPPLIES_REQUEST_SUB_AMOUNT * $detailsub->SUPPLIES_REQUEST_SUB_PRICE,2).'</td>
</tr>';

$count++;
  }



$output.=' </tbody>
</table><br>
<label style="float:left;">ความเห็นผู้เห็นชอบ</label><br>
<B style="float:left;">'.$detail -> AGREE_COMMENT.'</B><br>
<B style="float:left;">ผู้เห็นชอบ  '.$detail -> AGREE_HR_NAME.'</B><br><br>   


';

 echo $output;


}



//========================================ขอเบิกวัสดุ

public function infowithdrawindex(Request $request,$iduser)
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



    return view('general_suplies.infowithdrawindex',[
        'inforpersonuserid' => $inforpersonuserid,
        'inforpersonuser' => $inforpersonuser,

    ]);

}


//========================================ยืมคืน

public function infolendindex(Request $request,$iduser)
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



    return view('general_suplies.infolendindex',[
        'inforpersonuserid' => $inforpersonuserid,
        'inforpersonuser' => $inforpersonuser,

    ]);

}


//========================================ขอเบิกครุภัณฑ์

public function infowithdrawarticleindex(Request $request,$iduser)
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



    return view('general_suplies.infowithdrawarticleindex',[
        'inforpersonuserid' => $inforpersonuserid,
        'inforpersonuser' => $inforpersonuser,

    ]);

}

public function detailrequestindex(Request $request,$id,$iduser)
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


   $inforequest =  DB::table('supplies_request')
   ->where('ID','=',$id)->first();

   $inforequestsub =  DB::table('supplies_request_sub')
   ->where('SUPPLIES_REQUEST_ID','=',$id)->get();

    $pessonall = Person::leftJoin('supplies_request','supplies_request.REPORT_HR_ID','=','hrd_person.ID')
    ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->orderBy('hrd_person.HR_FNAME', 'asc')
    ->get();

    $infohr = DB::table('hrd_person')->where('ID','=',$inforequest->SAVE_HR_ID)->first();

    return view('general_suplies.inforequestindexdetail',[
        'inforpersonuserid' => $inforpersonuserid,
        'inforpersonuser' => $inforpersonuser,
        'inforequest' => $inforequest,
      'inforequestsubs' => $inforequestsub,
        'pessonalls' => $pessonall,
        'infohr' => $infohr

    ]);
}

public function inforequestedit(Request $request,$id,$iduser)
{
    $inforpersonuserid =  Person::where('ID','=',$iduser)->first();
    // $id = $inforpersonuserid->ID;

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

    $inforequest =  DB::table('supplies_request')
    ->leftjoin('supplies_type','supplies_request.REQUEST_FOR_ID','=','supplies_type.SUP_TYPE_ID')
    ->where('ID','=',$id)->first();


    $inforequesttype =  DB::table('supplies_type')->get();



     $pessonall = Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')->orderBy('hrd_person.HR_FNAME', 'asc')->get();

     $inforequestsub =  DB::table('supplies_request_sub')
     ->where('SUPPLIES_REQUEST_ID','=',$id)->get();

     $countcheck =  DB::table('supplies_request_sub')
     ->where('SUPPLIES_REQUEST_ID','=',$id)->count();

     $suppliesvendor = DB::table('supplies_vendor')->where('ACTIVE','=','True')->get();

     $m_budget = date("m");
     if($m_budget>9){
     $yearbudget = date("Y")+544;
     }else{
     $yearbudget = date("Y")+543;
     }

     $budget = DB::table('budget_year')->where('ACTIVE','=','True')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

    return view('general_suplies.inforequestedit',[
        'inforpersonuserid' => $inforpersonuserid,
        'inforpersonuser' => $inforpersonuser,
        'inforequest' => $inforequest,
      'countcheck' => $countcheck,
      'inforequestsubs' => $inforequestsub,
      'suppliesvendors' => $suppliesvendor,
        'pessonalls' => $pessonall,
        'inforequesttypes' => $inforequesttype,
        'budgets' => $budget,
        'year_id' => $yearbudget
        ]);
}  




public function inforequestupdate(Request $request)
{

         $DATEWANT = $request->DATE_WANT;

         if($DATEWANT != ''){
            $DAY = Carbon::createFromFormat('d/m/Y', $DATEWANT)->format('Y-m-d');
            $date_arrary_st=explode("-",$DAY);
            $y_sub_st = $date_arrary_st[0];

            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];
            $DATEWANT= $y_st."-".$m_st."-".$d_st;
            }else{
            $DATEWANT= null;
        }

        $id = $request->ID;

        $addinforequest = Suppliesrequest::find($id);

        $addinforequest->REQUEST_HEAD = $request->REQUEST_HEAD;
        $addinforequest->DATE_WANT = $DATEWANT;
        $addinforequest->DATE_TIME_SAVE = date('Y-m-d H:i:s');


        $addinforequest->REQUEST_FOR_ID = $request->REQUEST_FOR_ID;
        $name_type = DB::table('supplies_type')->where('SUP_TYPE_ID','=',$request->REQUEST_FOR_ID)->first();
        $addinforequest->REQUEST_FOR = $name_type->SUP_TYPE_NAME;

        $addinforequest->DEP_SUB_SUB_ID = $request->DEP_SUB_SUB_ID;
        $addinforequest->DEP_SUB_SUB_PHONE = $request->DEP_SUB_SUB_PHONE;

        $addinforequest->SAVE_HR_ID = $request->SAVE_HR_ID;


          //----------------------------------
          $SAVEHR =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
          ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
          ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
          ->where('hrd_person.ID','=',$request->SAVE_HR_ID)->first();

                $addinforequest->SAVE_HR_NAME = $SAVEHR->HR_PREFIX_NAME.''.$SAVEHR->HR_FNAME.' '.$SAVEHR->HR_LNAME;
                $addinforequest->SAVE_HR_POSITION = $SAVEHR->HR_POSITION_NAME;
                $addinforequest->SAVE_HR_DEP_SUB_NAME = $SAVEHR->HR_DEPARTMENT_SUB_NAME;

           //----------------------------------

                $addinforequest->AGREE_HR_ID = $request->AGREE_HR_ID;

             //----------------------------------
             $AGREEHR =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
             ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
             ->where('hrd_person.ID','=',$request->AGREE_HR_ID)->first();

                $addinforequest->AGREE_HR_NAME = $AGREEHR->HR_PREFIX_NAME.''.$AGREEHR->HR_FNAME.' '.$AGREEHR->HR_LNAME;
                $addinforequest->AGREE_HR_POSITION = $AGREEHR->HR_POSITION_NAME;

              //----------------------------------

                $addinforequest->REQUEST_BUY_COMMENT = $request->REQUEST_BUY_COMMENT;

                $addinforequest->HIRE_DETAIL = $request->HIRE_DETAIL;


                $addinforequest->BUDGET_YEAR = $request->YEAR_ID;

                $addinforequest->REQUEST_VANDOR_ID = $request->REQUEST_VANDOR_ID;

                if($request->REQUEST_VANDOR_ID <> ''){
                    $infovendor = DB::table('supplies_vendor')->where('VENDOR_ID','=',$request->REQUEST_VANDOR_ID)->first();
                    $addinforequest->REQUEST_VANDOR_NAME = $infovendor->VENDOR_NAME;
                   }else{
                  
                    $addinforequest->REQUEST_VANDOR_NAME = '';
                   }

                $addinforequest->REQUEST_REMARK = $request->REQUEST_REMARK;

                $addinforequest->save();




                $SUPPLIES_REQUEST_ID = $id;
                Suppliesrequestsub::where('SUPPLIES_REQUEST_ID','=',$id)->delete(); 
                

                if($request->SUPPLIES_REQUEST_SUBRE_ID != '' || $request->SUPPLIES_REQUEST_SUBRE_ID != null){

                    $SUPPLIES_REQUEST_SUBRE_ID = $request->SUPPLIES_REQUEST_SUBRE_ID;
                    
                    $SUPPLIES_REQUEST_SUB_AMOUNT = $request->SUPPLIES_REQUEST_SUB_AMOUNT;
                    $SUPPLIES_REQUEST_SUB_UNIT = $request->SUPPLIES_REQUEST_SUB_UNIT;
                    $SUPPLIES_REQUEST_SUB_PRICE = $request->SUPPLIES_REQUEST_SUB_PRICE;
                
                    $number =count($SUPPLIES_REQUEST_SUBRE_ID);
                    $count = 0;
                    for($count = 0; $count< $number; $count++)
                    {
                      //echo $row3[$count_3]."<br>";
    
                       $add = new Suppliesrequestsub();
                       $add->SUPPLIES_REQUEST_ID = $SUPPLIES_REQUEST_ID;
                       $add->SUPPLIES_REQUEST_SUBRE_ID = $SUPPLIES_REQUEST_SUBRE_ID[$count];
                       $infosup = DB::table('supplies')->where('ID','=',$SUPPLIES_REQUEST_SUBRE_ID[$count])->first();
                       $add->SUPPLIES_REQUEST_SUB_DETAIL = $infosup->SUP_NAME;
    
                       $add->SUPPLIES_REQUEST_SUB_AMOUNT = $SUPPLIES_REQUEST_SUB_AMOUNT[$count];
                       $add->SUPPLIES_REQUEST_SUB_UNIT = $SUPPLIES_REQUEST_SUB_UNIT[$count];
                       $add->SUPPLIES_REQUEST_SUB_PRICE = $SUPPLIES_REQUEST_SUB_PRICE[$count];
            
                       $add->SUPPLIES_REQUEST_SUB_SUM_PRICE = $SUPPLIES_REQUEST_SUB_PRICE[$count] * $SUPPLIES_REQUEST_SUB_AMOUNT[$count];
    
                       $add->save();
    
    
                    }
                }
    

        $BUDGET_SUM = Suppliesrequestsub::where('SUPPLIES_REQUEST_ID','=',$SUPPLIES_REQUEST_ID)->sum('SUPPLIES_REQUEST_SUB_SUM_PRICE');

        $updatesum = Suppliesrequest::find($SUPPLIES_REQUEST_ID );
        $updatesum->BUDGET_SUM = $BUDGET_SUM;
        $updatesum->save();


        return redirect()->route('suplies.inforequest',[
            'iduser' => $request->SAVE_HR_ID,

        ]);
}


public function cancelrequestindex(Request $request,$id,$iduser)
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

    $inforequest =  DB::table('supplies_request')
    ->where('ID','=',$id)->first();

    $inforequestsub =  DB::table('supplies_request_sub')
    ->where('SUPPLIES_REQUEST_ID','=',$id)->get();

    $infohr = DB::table('hrd_person')->where('ID','=',$inforequest->SAVE_HR_ID)->first();

    return view('general_suplies.inforequestindexcancel',[
        'inforpersonuserid' => $inforpersonuserid,
        'inforpersonuser' => $inforpersonuser,
        'inforequest' => $inforequest,
      'inforequestsubs' => $inforequestsub,
      'infohr' => $infohr

        ]);
}

public function cancelrequestindexupdate(Request $request)
{
    $id = $request->ID;
    $iduser = $request->iduser;

    $updateapp = Suppliesrequest::find($id);
    $updateapp->STATUS = 'cancel';
    $updateapp->save();


    return redirect()->route('suplies.inforequest',['iduser'=>   $request->iduser]);

}

//=============================ฟังชันสิทธิ์เข้าถึง

public static function checkapp($id_user)
{
     $count =  Permislist::where('PERSON_ID','=',$id_user)
                           ->where('PERMIS_ID','=','GSU002')
                           ->count();

     return $count;
}

public static function checkallow($id_user)
{
     $count =  Permislist::where('PERSON_ID','=',$id_user)
                           ->where('PERMIS_ID','=','GSU003')
                           ->count();

     return $count;
}

public static function countapp($id_user)
{
    $inforpersonuser=  Person::where('ID','=',$id_user)->first();

    $count = Suppliesrequest::leftJoin('supplies_request_status','supplies_request_status.STATUS_CODE','=','supplies_request.STATUS')
    ->where('DEP_SUB_SUB_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)
    ->where('STATUS','=','Pending')
    ->count();

     return $count;
}
public static function countallow($id_user)
{
    $inforpersonuser=  Person::where('ID','=',$id_user)->first();

    $count = Suppliesrequest::leftJoin('supplies_request_status','supplies_request_status.STATUS_CODE','=','supplies_request.STATUS')
    ->where('STATUS','=','Verify')
    ->count();
    
     return $count;
}



//เลือกวัสดุจากข้อมูล
function selectsup(Request $request)
{
  
    $select = $request->get('select');



    $detail_subs = DB::table('supplies')->where('SUP_TYPE_ID','=',$select)->get();

    $output = '<select name="SUPPLIES_REQUEST_SUBRE_ID[]" id="SUPPLIES_REQUEST_SUBRE_ID[]" class="form-control input-sm js-example-basic-single" style=" font-family: \'Kanit\', sans-serif;" >
    <option value="">---กรุณาเลือกวัสดุ--</option>           
    ';
                  
                        foreach ($detail_subs as $detailsub){
                    
                            $output .='<option value="'.$detailsub->ID.'">'.$detailsub->SUP_FSN_NUM.' : '.$detailsub->SUP_NAME.'</option>';           
                        }      

                        $output .='</select>';
    
    echo $output;
}

//==============================================


//เลือกวัสดุจากข้อมูล
function supselect(Request $request)
{
  

    $idinven = $request->get('idinven');
    $count = $request->get('count');
    $detail_subs = DB::table('supplies')->where('SUP_TYPE_ID','=',$idinven)->get();

    $output ='
    <table class="table-bordered table-striped table-vcenter js-dataTable-simple" style="width: 100%;">
  
    <thead style="background-color: #FFEBCD;">
        <tr>
             <td style="text-align: center;border: 1px solid black;" width="15%">รหัส</td>
             <td style="text-align: center;border: 1px solid black;" width="15%">รหัสเดิม</td>
             <td style="text-align: center;border: 1px solid black;" width="15%">รหัสพัสดุ</td>
            <td style="text-align: center;border: 1px solid black;" >รายละเอียด</td>
            <td style="text-align: center;border: 1px solid black;" >ส่วนประกอบ</td>
            <td style="text-align: center;border: 1px solid black;" >หน่วย</td>
            <td style="text-align: center;border: 1px solid black;" width="10%">เลือก</td>
        </tr>
    </thead>
    <tbody id="myTable">';
  
    
    foreach ($detail_subs as $detail_sub){

        $resule =  DB::table('supplies_unit_ref')
        ->where('SUP_ID','=',$detail_sub->ID)
        ->where('SUP_TOTAL','=',1)
        ->first();

        if($resule !== null){
            $re = $resule->SUP_UNIT_NAME;
        }else{

            $re = '';
        }
  
      $output.='  <tr height="20">
      <td class="text-font text-pedding" style="border: 1px solid black;padding-left:10px;">'.$detail_sub->SUP_FSN_NUM.'</td>
      <td class="text-font text-pedding" style="border: 1px solid black;padding-left:10px;">'.$detail_sub->SUP_CODE.'</td>
      <td class="text-font text-pedding" style="border: 1px solid black;padding-left:10px;">'.$detail_sub->TPU_NUMBER.'</td>
      <td class="text-font text-pedding" style="border: 1px solid black;padding-left:10px;" align="left" >'.$detail_sub->SUP_NAME.'</td>
      <td class="text-font text-pedding" style="border: 1px solid black;padding-left:10px;" align="left" >'.$detail_sub->SUP_MASH.'</td>
      <td class="text-font text-pedding" style="border: 1px solid black;padding-left:10px;" align="left" >'.$re.'</td>
      <td class="text-font" style="border: 1px solid black;" align="center" ><button type="button" class="btn btn-info btn-lg"  style="font-family: \'Kanit\', sans-serif; font-size: 10px;font-weight:normal;"  onclick="selectsupreq('.$detail_sub->ID.','.$count.')">เลือก</button></td> 
    </tr>';
       }
  
  
     
  $output.='</tbody>
  </table>';
  
  
   echo $output;
}



function suptpu(Request $request)
{
  
    $idinven = $request->get('idinven');
    $count = $request->get('count');

    $infosup = DB::table('supplies')->where('ID','=',$idinven)->first();

    $output = $infosup->TPU_NUMBER;
    echo $output;
}


function supre(Request $request)
{
  
    $idinven = $request->get('idinven');
    $count = $request->get('count');

    $infosup = DB::table('supplies')
    ->leftjoin('medical_type_item','medical_type_item.TYPE_ITEM_ID','=','supplies.SUP_GENUS')
    ->where('ID','=',$idinven)->first();

    $output = $infosup->SUP_NAME.'  '.$infosup->TYPE_ITEM_NAME.'  '.$infosup->SUP_MASH.'
    <input type="hidden" name="SUPPLIES_REQUEST_SUBRE_ID[]" id="SUPPLIES_REQUEST_SUBRE_ID'.$count.'" class="form-control input-sm" value="'.$infosup->ID.'">';
    echo $output;
}

function supunitname(Request $request)
{
  
    $idinven = $request->get('idinven');
    $count = $request->get('count');

    $infosup = DB::table('supplies_unit_ref')->where('SUP_ID','=',$idinven)->first();
 
    if($infosup == '' || $infosup == null){
        $output = '<input type="text" name="SUPPLIES_REQUEST_SUB_UNIT[]" id="SUPPLIES_REQUEST_SUB_UNIT'.$count.'" class="form-control input-sm" >';
    }else{
  
         
        

  $infounits = DB::table('supplies_unit_ref')->where('SUP_ID','=',$idinven)->get();

  $output = ' 
  <select name="SUPPLIES_REQUEST_SUB_UNIT[]" id="SUPPLIES_REQUEST_SUB_UNIT'.$count.'" class="form-control input-sm " style=" font-family: \'Kanit\', sans-serif;" >
   ';                                                           
  foreach ($infounits as $infounit) {
        $output.=' <option value="'.$infounit->SUP_UNIT_NAME.'">'.$infounit->SUP_UNIT_NAME.'</option>';
    }      
                         
$output.='</select> ';

        
    }
   
    
    
    echo $output;
}

 //-------------------------------------ฟังชั่นรันเลขอ้างอิง--------------------
    
 public static function refnumberREQ()
 {
    
        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;
        }

  

     $maxnumber = DB::table('supplies_request')->where('BUDGET_YEAR','=',$yearbudget)->max('ID');  

  

     if($maxnumber != '' ||  $maxnumber != null){
         
         $refmax = DB::table('supplies_request')->where('ID','=',$maxnumber)->first();  


         if($refmax->REQUEST_ID != '' ||  $refmax->REQUEST_ID != null){
             $maxref = substr($refmax->REQUEST_ID, -4)+1;
          }else{
             $maxref = 1;
          }

         $ref = str_pad($maxref, 4, "0", STR_PAD_LEFT);
    
     }else{
         $ref = '0001';
     }

     
     $y = substr($yearbudget, -2);
    

  $refnumber ='REQ-'.$y.''.$ref;



  return $refnumber;
 }

}
