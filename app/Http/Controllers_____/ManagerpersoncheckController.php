<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Person;
use Carbon\Carbon;
use App\Models\Checkin;
use App\Http\Controllers\Report\PersoncheckReportController;

date_default_timezone_set("Asia/Bangkok");

class ManagerpersoncheckController extends Controller
{
   
    public function dashboard()
    {
        $data['budgetyear'] = getBudgetYear();
        
        $yearbudget = $data['budgetyear'];
        $datenow = date('Y-m-d');

        $amount_1 = DB::table('checkin_index')->where('CHECKIN_TYPE_ID','=',1)->count();
        $amount_2 = DB::table('checkin_index')->where('CHECKIN_TYPE_ID','=',2)->count();
        $amount_11 = DB::table('checkin_index')->where('CHECKIN_TYPE_ID','=',1)->where('CHEACKIN_DATE','=',$datenow)->count();
        $amount_22 = DB::table('checkin_index')->where('CHECKIN_TYPE_ID','=',2)->where('CHEACKIN_DATE','=',$datenow)->count();
        $type_1 = DB::table('checkin_index')->where('CHECKIN_TYPE_ID','=',1)->count(); 
        $type_2 = DB::table('checkin_index')->where('CHECKIN_TYPE_ID','=',2)->count();     
        $type_11 = DB::table('checkin_index')->where('CHECKIN_TYPE_ID','=',1)->where('CHEACKIN_DATE','=',$datenow)->count();
        $type_22 = DB::table('checkin_index')->where('CHECKIN_TYPE_ID','=',2)->where('CHEACKIN_DATE','=',$datenow)->count();
        
        $leave_amount_1 = DB::table('gleave_register')->where('LEAVE_TYPE_CODE','=',1)->where('LEAVE_YEAR_ID','=',$yearbudget)->count();
        $leave_amount_2 = DB::table('gleave_register')->where('LEAVE_TYPE_CODE','=',3)->where('LEAVE_YEAR_ID','=',$yearbudget)->count();
        $leave_amount_3 = DB::table('gleave_register')->where('LEAVE_TYPE_CODE','=',4)->where('LEAVE_YEAR_ID','=',$yearbudget)->count();
        $leave_amount_4 = DB::table('gleave_register')->where('LEAVE_TYPE_CODE','=',6)->where('LEAVE_YEAR_ID','=',$yearbudget)->count();

        $personcheck = new PersoncheckReportController();
        $data['checkintable'] = $personcheck->getPersoncheckin(1,date('Y-m-d'),date('Y-m-d'));
        $data['checkouttable'] =$personcheck->getPersoncheckin(2,date('Y-m-d'),date('Y-m-d'));


        
        return view('manager_checkin.dashboard_check',$data,[
            'amount_1' => $amount_1,
            'amount_2' => $amount_2,
            'amount_11' => $amount_11,
            'amount_22' => $amount_22,
            'type_22' => $type_22,
            'type_11' => $type_11,
            'type_2' => $type_2,
            'type_1' => $type_1,
            'leave_amount_1' => $leave_amount_1,
            'leave_amount_2' => $leave_amount_2,
            'leave_amount_3' => $leave_amount_3,
            'leave_amount_4' => $leave_amount_4,    
        ]);
    }
    public function inforpersoncheck()
    {
        $person = Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                        ->leftJoin('hrd_sex','hrd_person.SEX','=','hrd_sex.SEX_ID')
                        ->leftJoin('hrd_status','hrd_person.HR_STATUS_ID','=','hrd_status.HR_STATUS_ID')
                        ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
                        ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
                        ->leftJoin('hrd_department','hrd_person.HR_DEPARTMENT_ID','=','hrd_department.HR_DEPARTMENT_ID')
                        ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
                        ->leftJoin('users','hrd_person.ID','=','users.PERSON_ID')
                        ->orderBy('hrd_person.ID', 'desc')
                        ->get();
   
        $count = Person::count();

        return view('manager_checkin.inforpersoncheckin',[
            'persons' => $person, 
            'count' => $count 
        ]);
    }


    public function inforpersoncheck_new(Request $request)
    {
   
        $inforcheckin = Checkin::leftJoin('checkin_type','checkin_index.CHECKIN_TYPE_ID','=','checkin_type.CHECKIN_TYPE_ID')
        ->leftJoin('operate_job','checkin_index.OPERATE_JOB_ID','=','operate_job.OPERATE_JOB_ID')
        ->leftJoin('operate_type','operate_job.OPERATE_JOB_TYPE_ID','=','operate_type.OPERATE_TYPE_ID')        
        ->leftJoin('hrd_person','checkin_index.CHECKIN_PERSON_ID','=','hrd_person.ID')
        ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_position','checkin_index.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
        ->leftJoin('hrd_department_sub_sub','operate_job.OPERATE_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->orderBy('CHECKIN_ID', 'desc') 
        // ->where('CHECKIN_PERSON_ID','=',$id) 
        ->get();

        $checkintype = DB::table('checkin_type')->get();

        $depart = DB::table('hrd_department_sub_sub')->get();

        
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

     return view('manager_checkin.inforpersoncheck_new',[
            'departs' => $depart,   
            'inforcheckins' => $inforcheckin,
            'checkintypes' => $checkintype,
            'displaydate_bigen'=> $displaydate_bigen, 
            'displaydate_end'=> $displaydate_end,
            'status_check' => $status,
            'search' => $search,
            'year_id'=>$year_id, 
            'budgets' =>  $budget,
        ]);
    }

    public function excel_checkin_new(Request $request)
    {
      
        $inforcheckin = Checkin::leftJoin('checkin_type','checkin_index.CHECKIN_TYPE_ID','=','checkin_type.CHECKIN_TYPE_ID')
        ->leftJoin('operate_job','checkin_index.OPERATE_JOB_ID','=','operate_job.OPERATE_JOB_ID')
        ->leftJoin('operate_type','operate_job.OPERATE_JOB_TYPE_ID','=','operate_type.OPERATE_TYPE_ID')        
        ->leftJoin('hrd_person','checkin_index.CHECKIN_PERSON_ID','=','hrd_person.ID')
        ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_position','checkin_index.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
        ->leftJoin('hrd_department_sub_sub','operate_job.OPERATE_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->orderBy('CHECKIN_ID', 'desc') 
        ->get();

        $checkintype = DB::table('checkin_type')->get();
        $depart = DB::table('hrd_department_sub_sub')->get();

         $count = Person::count();

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

        return view('person_checkin.excel_checkin',[
            'departs' => $depart,   
            'inforcheckins' => $inforcheckin,
            'checkintypes' => $checkintype,
            'displaydate_bigen'=> $displaydate_bigen, 
            'displaydate_end'=> $displaydate_end,
            'status_check' => $status,
            'search' => $search,
            'budgets' =>  $budget,
            'year_id'=>$year_id 
        ]);
    }

    public function search(Request $request)
    {
        $search = $request->get('search');

        $person = Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_sex','hrd_person.SEX','=','hrd_sex.SEX_ID')
        ->leftJoin('hrd_status','hrd_person.HR_STATUS_ID','=','hrd_status.HR_STATUS_ID')
        ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
        ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->leftJoin('hrd_department','hrd_person.HR_DEPARTMENT_ID','=','hrd_department.HR_DEPARTMENT_ID')
        ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
        ->leftJoin('users','hrd_person.ID','=','users.PERSON_ID')
        ->where('HR_CID','like','%'.$search.'%')
        ->orwhere('HR_PREFIX_NAME','like','%'.$search.'%')
        ->orwhere('HR_FNAME','like','%'.$search.'%')
        ->orwhere('HR_LNAME','like','%'.$search.'%')
        ->orwhere('NICKNAME','like','%'.$search.'%')
        ->orwhere('SEX_NAME','like','%'.$search.'%')
        ->orwhere('HR_STATUS_NAME','like','%'.$search.'%')
        ->orwhere('POSITION_IN_WORK','like','%'.$search.'%')
        ->orwhere('HR_LEVEL_NAME','like','%'.$search.'%')
        ->orwhere('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%')
        ->orwhere('HR_DEPARTMENT_SUB_NAME','like','%'.$search.'%')
        ->orwhere('HR_DEPARTMENT_NAME','like','%'.$search.'%')
        ->orderBy('hrd_person.ID', 'desc')    
        ->get();


        $count = Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_sex','hrd_person.SEX','=','hrd_sex.SEX_ID')
        ->leftJoin('hrd_status','hrd_person.HR_STATUS_ID','=','hrd_status.HR_STATUS_ID')
        ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
        ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->leftJoin('hrd_department','hrd_person.HR_DEPARTMENT_ID','=','hrd_department.HR_DEPARTMENT_ID')
        ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
        ->leftJoin('users','hrd_person.ID','=','users.PERSON_ID')
        ->where('HR_CID','like','%'.$search.'%')
        ->orwhere('HR_PREFIX_NAME','like','%'.$search.'%')
        ->orwhere('HR_FNAME','like','%'.$search.'%')
        ->orwhere('HR_LNAME','like','%'.$search.'%')
        ->orwhere('NICKNAME','like','%'.$search.'%')
        ->orwhere('SEX_NAME','like','%'.$search.'%')
        ->orwhere('HR_STATUS_NAME','like','%'.$search.'%')
        ->orwhere('POSITION_IN_WORK','like','%'.$search.'%')
        ->orwhere('HR_LEVEL_NAME','like','%'.$search.'%')
        ->orwhere('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%')
        ->orwhere('HR_DEPARTMENT_SUB_NAME','like','%'.$search.'%')
        ->orwhere('HR_DEPARTMENT_NAME','like','%'.$search.'%')    
        ->count();

        return view('manager_checkin.inforpersoncheckin',[
        'persons' => $person, 
        'count' => $count 
        ]);
            
    }



    public function infocheck(Request $request,$iduser)
    {
 

        $inforcheckin = Checkin::leftJoin('checkin_type','checkin_index.CHECKIN_TYPE_ID','=','checkin_type.CHECKIN_TYPE_ID')
        ->leftJoin('operate_job','checkin_index.OPERATE_JOB_ID','=','operate_job.OPERATE_JOB_ID')
        ->leftJoin('operate_type','operate_job.OPERATE_JOB_TYPE_ID','=','operate_type.OPERATE_TYPE_ID')        
        ->leftJoin('hrd_person','checkin_index.CHECKIN_PERSON_ID','=','hrd_person.ID')
        ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_position','checkin_index.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
        ->leftJoin('hrd_department_sub_sub','operate_job.OPERATE_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->orderBy('CHECKIN_ID', 'desc') 
        ->where('CHECKIN_PERSON_ID','=',$iduser) 
        ->get();

         $infouser = Person::where('ID','=',$iduser)->first();



        return view('manager_checkin.personinfocheckininfo',[ 
            'inforcheckins' => $inforcheckin,
            'infouser' => $infouser,
            
        ]);
    }


    



}
