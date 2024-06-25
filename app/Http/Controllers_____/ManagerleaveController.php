<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Person;
use App\Models\LeaveStatus;
use App\Models\Vehiclecarreserve;
use App\Models\Leave_register;
use App\Http\Controllers\Report\LeaveReportController;
use App\Http\Controllers\Web_meta_data_Controller;
use Session;

date_default_timezone_set("Asia/Bangkok");

class ManagerleaveController extends Controller
{
    public function dashboard()
        {
            $data['budgetyear'] = getBudgetYear();
            $data['budgetyear_dropdown'] = getBudgetYearAmount();
            if(!empty($_GET['budgetyear'])){
                $data['budgetyear'] = $_GET['budgetyear'];
            }
            $year = $data['budgetyear'];
            $year_ad = $year - 543;

            $leavereport = new LeaveReportController();
            $data['all_Leaveperson'] = $leavereport->countLeavePersonByyear_type($year_ad,'all');
            $data['sick_Leaveperson'] = $leavereport->countLeavePersonByyear_type($year_ad,1);
            $data['GiveBirth_Leaveperson'] = $leavereport->countLeavePersonByyear_type($year_ad,2);
            $data['ฺbusiness_Leaveperson'] = $leavereport->countLeavePersonByyear_type($year_ad,3);
            $data['rest_Leaveperson'] = $leavereport->countLeavePersonByyear_type($year_ad,4);
            $data['Ordain_Leaveperson'] = $leavereport->countLeavePersonByyear_type($year_ad,5);
            $data['Helpmywifegivebirth_Leaveperson'] = $leavereport->countLeavePersonByyear_type($year_ad,6);
            $data['Enlist_Leaveperson'] = $leavereport->countLeavePersonByyear_type($year_ad,7);
            $data['Student_Leaveperson'] = $leavereport->countLeavePersonByyear_type($year_ad,8);
            $data['Workabroad_Leaveperson'] = $leavereport->countLeavePersonByyear_type($year_ad,9);
            $data['Followthespouse_Leaveperson'] = $leavereport->countLeavePersonByyear_type($year_ad,10);
            $data['Careerrecovery_Leaveperson'] = $leavereport->countLeavePersonByyear_type($year_ad,11);
            $data['Resign_Leaveperson'] = $leavereport->countLeavePersonByyear_type($year_ad,12);
            $data['Legalsick_Leaveperson'] = $leavereport->countLeavePersonByyear_type($year_ad,13);
            
            $data['leaveperson'] = $leavereport->countLeavepersonByyear_M($year_ad);
            $data['sickLeaveperson'] = $leavereport->countLeavepersonByyear_type_M($year_ad,1); //ลาป่วย
            $data['businessLeaveperson'] = $leavereport->countLeavepersonByyear_type_M($year_ad,3); //ลากิจ
            $data['SummerLeaveperson'] = $leavereport->countLeavepersonByyear_type_M($year_ad,4); //ลาพักผ่อน
            $data['Leaveperson'] = $leavereport->groupcountLeavepersonAlltypeByyear_M($year_ad);
            return view('manager_leave.dashboard_leave',$data);
        }

        public function dashboard_leave_type($type_id,$year)
        {
            $data['budgetyear']          = getBudgetYear();
            $data['budgetyear_dropdown'] = getBudgetYearAmount();
            $data['leavetype_dropdown'] = DB::table('gleave_type')->get()->toArray();
            array_unshift($data['leavetype_dropdown'] , (object)array(
                'LEAVE_TYPE_ID' => 'all',
                'LEAVE_TYPE_NAME' => 'ทุกประเภท'
            ));
            $data['budgetyear'] = $year;
            $data['LEAVE_TYPE'] = $type_id;
            $year_ad = $year-543;
            $metadata = new Web_meta_data_Controller();
            $data['status_graph'] = $metadata->getValueByName('displaygraph_class');
            $leavereport = new LeaveReportController();
            $data['tableleave'] = $leavereport->getPersonLeaveBytype_year($type_id,$year_ad);
            $data['countleave_M'] = $leavereport->countPersonLeaveBytype_year_M($type_id,$year_ad);
            $data['countLeave'] = $leavereport->countLeavePersonByyear_type($year_ad,$type_id);

            return view('manager_leave.dashboard_leave_type',$data);
        }

        public function dashboardsearch(Request $request)
        {

            $year_id = $request->STATUS_CODE;
            $yearbudget = $year_id;
             
            $year = $yearbudget-543;


                $m1_1 = DB::table('gleave_register')->where('LEAVE_TYPE_CODE','=',1)->where('LEAVE_DATE_BEGIN','like',$year.'-01%')->count();
                $m2_1 = DB::table('gleave_register')->where('LEAVE_TYPE_CODE','=',2)->where('LEAVE_DATE_BEGIN','like',$year.'-02%')->count();
                $m3_1 = DB::table('gleave_register')->where('LEAVE_TYPE_CODE','=',3)->where('LEAVE_DATE_BEGIN','like',$year.'-03%')->count();
                $m4_1 = DB::table('gleave_register')->where('LEAVE_TYPE_CODE','=',4)->where('LEAVE_DATE_BEGIN','like',$year.'-04%')->count();
                $m5_1 = DB::table('gleave_register')->where('LEAVE_TYPE_CODE','=',5)->where('LEAVE_DATE_BEGIN','like',$year.'-05%')->count();
                $m6_1 = DB::table('gleave_register')->where('LEAVE_TYPE_CODE','=',6)->where('LEAVE_DATE_BEGIN','like',$year.'-06%')->count();
                $m7_1 = DB::table('gleave_register')->where('LEAVE_TYPE_CODE','=',7)->where('LEAVE_DATE_BEGIN','like',$year.'-07%')->count();
                $m8_1 = DB::table('gleave_register')->where('LEAVE_TYPE_CODE','=',8)->where('LEAVE_DATE_BEGIN','like',$year.'-08%')->count();
                $m9_1 = DB::table('gleave_register')->where('LEAVE_TYPE_CODE','=',9)->where('LEAVE_DATE_BEGIN','like',$year.'-09%')->count();
                $m10_1 = DB::table('gleave_register')->where('LEAVE_TYPE_CODE','=',10)->where('LEAVE_DATE_BEGIN','like',$year.'-10%')->count();
                $m11_1 = DB::table('gleave_register')->where('LEAVE_TYPE_CODE','=',11)->where('LEAVE_DATE_BEGIN','like',$year.'-11%')->count();
                $m12_1 = DB::table('gleave_register')->where('LEAVE_TYPE_CODE','=',12)->where('LEAVE_DATE_BEGIN','like',$year.'-12%')->count();

                $m1_P = DB::table('gleave_register')->where('LEAVE_STATUS_CODE','=','Allow')->where('LEAVE_TYPE_CODE','=',4)->where('LEAVE_YEAR_ID','=',$yearbudget)->where('LEAVE_DATE_BEGIN','like','%-01-%')->count();
                $m2_P = DB::table('gleave_register')->where('LEAVE_STATUS_CODE','=','Allow')->where('LEAVE_TYPE_CODE','=',4)->where('LEAVE_YEAR_ID','=',$yearbudget)->where('LEAVE_DATE_BEGIN','like','%-02-%')->count();
                $m3_P = DB::table('gleave_register')->where('LEAVE_STATUS_CODE','=','Allow')->where('LEAVE_TYPE_CODE','=',4)->where('LEAVE_YEAR_ID','=',$yearbudget)->where('LEAVE_DATE_BEGIN','like','%-03-%')->count();
                $m4_P = DB::table('gleave_register')->where('LEAVE_STATUS_CODE','=','Allow')->where('LEAVE_TYPE_CODE','=',4)->where('LEAVE_YEAR_ID','=',$yearbudget)->where('LEAVE_DATE_BEGIN','like','%-04-%')->count();
                $m5_P = DB::table('gleave_register')->where('LEAVE_STATUS_CODE','=','Allow')->where('LEAVE_TYPE_CODE','=',4)->where('LEAVE_YEAR_ID','=',$yearbudget)->where('LEAVE_DATE_BEGIN','like','%-05-%')->count();
                $m6_P = DB::table('gleave_register')->where('LEAVE_STATUS_CODE','=','Allow')->where('LEAVE_TYPE_CODE','=',4)->where('LEAVE_YEAR_ID','=',$yearbudget)->where('LEAVE_DATE_BEGIN','like','%-06-%')->count();
                $m7_P = DB::table('gleave_register')->where('LEAVE_STATUS_CODE','=','Allow')->where('LEAVE_TYPE_CODE','=',4)->where('LEAVE_YEAR_ID','=',$yearbudget)->where('LEAVE_DATE_BEGIN','like','%-07-%')->count();
                $m8_P = DB::table('gleave_register')->where('LEAVE_STATUS_CODE','=','Allow')->where('LEAVE_TYPE_CODE','=',4)->where('LEAVE_YEAR_ID','=',$yearbudget)->where('LEAVE_DATE_BEGIN','like','%-08-%')->count();
                $m9_P = DB::table('gleave_register')->where('LEAVE_STATUS_CODE','=','Allow')->where('LEAVE_TYPE_CODE','=',4)->where('LEAVE_YEAR_ID','=',$yearbudget)->where('LEAVE_DATE_BEGIN','like','%-09-%')->count();
                $m10_P = DB::table('gleave_register')->where('LEAVE_STATUS_CODE','=','Allow')->where('LEAVE_TYPE_CODE','=',4)->where('LEAVE_YEAR_ID','=',$yearbudget)->where('LEAVE_DATE_BEGIN','like','%-10-%')->count();
                $m11_P = DB::table('gleave_register')->where('LEAVE_STATUS_CODE','=','Allow')->where('LEAVE_TYPE_CODE','=',4)->where('LEAVE_YEAR_ID','=',$yearbudget)->where('LEAVE_DATE_BEGIN','like','%-11-%')->count();
                $m12_P = DB::table('gleave_register')->where('LEAVE_STATUS_CODE','=','Allow')->where('LEAVE_TYPE_CODE','=',4)->where('LEAVE_YEAR_ID','=',$yearbudget)->where('LEAVE_DATE_BEGIN','like','%-12-%')->count();


                $count1 = DB::table('gleave_register') 
                ->leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_NAME')
                ->where('LEAVE_YEAR_ID','=',$yearbudget)
                ->where('LEAVE_TYPE_CODE','=',1)                          
                ->count();
                $count2 = DB::table('gleave_register') 
                ->leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_NAME')
                ->where('LEAVE_YEAR_ID','=',$yearbudget)
                ->where('LEAVE_TYPE_CODE','=',2)                          
                ->count();
                $count3 = DB::table('gleave_register') 
                ->leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_NAME')
                ->where('LEAVE_YEAR_ID','=',$yearbudget)
                ->where('LEAVE_TYPE_CODE','=',3)                          
                ->count();
                $count4 = DB::table('gleave_register') 
                ->leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_NAME')
                ->where('LEAVE_YEAR_ID','=',$yearbudget)
                ->where('LEAVE_TYPE_CODE','=',4)                          
                ->count();
                $count5 = DB::table('gleave_register') 
                ->leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_NAME')
                ->where('LEAVE_YEAR_ID','=',$yearbudget)
                ->where('LEAVE_TYPE_CODE','=',5)                          
                ->count();
                $count6 = DB::table('gleave_register') 
                ->leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_NAME')
                ->where('LEAVE_YEAR_ID','=',$yearbudget)
                ->where('LEAVE_TYPE_CODE','=',6)                          
                ->count();
                $count7 = DB::table('gleave_register') 
                ->leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_NAME')
                ->where('LEAVE_YEAR_ID','=',$yearbudget)
                ->where('LEAVE_TYPE_CODE','=',7)                          
                ->count();

                $count8 = DB::table('gleave_register') 
                ->leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_NAME')
                ->where('LEAVE_YEAR_ID','=',$yearbudget)
                ->where('LEAVE_TYPE_CODE','=',8)                          
                ->count();
                
                $count9 = DB::table('gleave_register') 
                ->leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_NAME')
                ->where('LEAVE_YEAR_ID','=',$yearbudget)
                ->where('LEAVE_TYPE_CODE','=',9)                          
                ->count();
                $count10 = DB::table('gleave_register') 
                ->leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_NAME')
                ->where('LEAVE_YEAR_ID','=',$yearbudget)
                ->where('LEAVE_TYPE_CODE','=',10)                          
                ->count();
                $count11 = DB::table('gleave_register') 
                ->leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_NAME')
                ->where('LEAVE_YEAR_ID','=',$yearbudget)
                ->where('LEAVE_TYPE_CODE','=',11)                          
                ->count();
                $count12 = DB::table('gleave_register') 
                ->leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_NAME')
                ->where('LEAVE_YEAR_ID','=',$yearbudget)
                ->where('LEAVE_TYPE_CODE','=',12)                          
                ->count();


                $countall1 = DB::table('gleave_register') 
                ->leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_NAME')
                ->where('LEAVE_TYPE_CODE','=',1) 
                ->where('LEAVE_DATE_BEGIN','like',$year.'%')                           
                ->count();


                $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
                $year_id = $yearbudget;
               
            return view('manager_leave.dashboard_leave',[
           
                    'm1_1' => $m1_1,
                    'm2_1' => $m2_1,
                    'm3_1' => $m3_1,
                    'm4_1' => $m4_1,
                    'm5_1' => $m5_1,
                    'm6_1' => $m6_1,
                    'm7_1' => $m7_1,
                    'm8_1' => $m8_1,
                    'm9_1' => $m9_1,
                    'm10_1' => $m10_1,
                    'm11_1' => $m11_1,
                    'm12_1' => $m12_1,

                    'm1_P' => $m1_P,
                    'm2_P' => $m2_P,
                    'm3_P' => $m3_P,
                    'm4_P' => $m4_P,
                    'm5_P' => $m5_P,
                    'm6_P' => $m6_P,
                    'm7_P' => $m7_P,
                    'm8_P' => $m8_P,
                    'm9_P' => $m9_P,
                    'm10_P' => $m10_P,
                    'm11_P' => $m11_P,
                    'm12_P' => $m12_P,
          
                    'count1' => $count1,
                    'count2' => $count2,
                    'count3' => $count3,
                    'count4' => $count4,
                    'count5' => $count5,
                    'count6' => $count6,
                    'count7' => $count7,
                    'count8' => $count8,
                    'count9' => $count9,
                    'count10' => $count10,
                    'count11' => $count11,
                    'count12' => $count12,
                     'countall1' => $countall1,
                     'budgets' =>  $budget,
                     'year_id'=>$year_id 
                   
            ]);
        }

        public static function countleavemonth($yearbudget,$type,$i)

        {       
            if($i <10){
                $m = '0'.$i;
                $year  = $yearbudget - 543;
            }else{
                $m = $i;
                $year  = $yearbudget - 544;
            } 
    
            $count =  Leave_register::where('LEAVE_YEAR_ID','=',$yearbudget )
                                        ->where('LEAVE_DATE_BEGIN', 'like',$year.'-'.$m.'-%')
                                        ->where('LEAVE_STATUS_CODE','=','Allow')
                                        ->where('LEAVE_TYPE_CODE','=',$type ) 
                                        ->sum('WORK_DO');       
            return $count;
        }
    
    public static function sumcountleavemonth($yearbudget,$type)
        {        
            $count =  Leave_register::where('LEAVE_YEAR_ID','=',$yearbudget )
                                        ->where('LEAVE_STATUS_CODE','=','Allow')
                                        ->where('LEAVE_TYPE_CODE','=',$type ) 
                                        ->sum('WORK_DO');       
            return $count;
        }
    

public function infover(Request $request)
    {
        if(!empty($request->_token)){
            $search = $request->get('search');
            $status = $request->STATUS_CODE;
            $datebigin = datepickerTodate($request->get('DATE_BIGIN'));
            $dateend = datepickerTodate($request->get('DATE_END'));  
            $yearbudget = $request->BUDGET_YEAR;  
            session([
                'manager_leave.personleaveinfocheckver.search'=> $search,
                'manager_leave.personleaveinfocheckver.status'=> $status,
                'manager_leave.personleaveinfocheckver.datebigin'=> $datebigin,
                'manager_leave.personleaveinfocheckver.dateend'=> $dateend,
                'manager_leave.personleaveinfocheckver.yearbudget'=> $yearbudget
            ]);
        }elseif(!empty(session('manager_leave.personleaveinfocheckver'))){
            $search = session('manager_leave.personleaveinfocheckver.search');
            $status = session('manager_leave.personleaveinfocheckver.status');
            $datebigin = session('manager_leave.personleaveinfocheckver.datebigin');
            $dateend = session('manager_leave.personleaveinfocheckver.dateend');
            $yearbudget = session('manager_leave.personleaveinfocheckver.yearbudget');
        }else{
            $search = '';
            $status = 'VER';
            $datebigin = (getBudgetyear()-1-543).date('-10-01');
            $dateend   = (getBudgetyear()-543).date('-09-30');
            $yearbudget = getBudgetYear();
        }
        $datebigin_year = Carbon::createFromFormat('Y-m-d', $datebigin)->format('Y');
        if($datebigin_year >= 2500){
            $datebigin_month = Carbon::createFromFormat('Y-m-d', $datebigin)->format('-m-d');
            $datebigin = ($datebigin_year-543).$datebigin_month;
        }
        $dateend_year = Carbon::createFromFormat('Y-m-d', $dateend)->format('Y');
        if($dateend_year >= 2500){
            $dateend_month = Carbon::createFromFormat('Y-m-d', $dateend)->format('-m-d');
            $dateend = ($dateend_year-543).$dateend_month;
        }
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        
        $leave = new LeaveReportController();
        $data['inforleaves'] = $leave->getLeaveCheck($datebigin,$dateend,$search,$status);
        $data['infostatuss'] = LeaveStatus::orderBy('STATUS_RANK', 'ASC')->get();
        $data['budgets'] = $budget;
        $data['displaydate_bigen'] = $datebigin;
        $data['displaydate_end'] = $dateend;
        $data['status_check'] = $status;
        $data['search'] = $search;
        $data['year_id'] = $yearbudget;


        return view('manager_leave.personleaveinfocheckver',$data,[

        ]);
    }

    public function searchver(Request $request)
    {
        $search = $request->get('search');
        $status = $request->STATUS_CODE;
        $datebigin = $request->get('DATE_BIGIN');
        $dateend = $request->get('DATE_END');  
        $yearbudget = $request->BUDGET_YEAR;      

       
      
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

        if($date_bigen_checks != $dates || $date_end_checks != $dates){

         
            $from = date($displaydate_bigen);
            $to = date($displaydate_end);
      
            if($status == null){
                $inforleave=  Leave_register::select('gleave_register.ID','STATUS_CODE','STATUS_NAME','LEAVE_YEAR_ID','LEAVE_PERSON_FULLNAME','LEAVE_TYPE_NAME','LEAVE_BECAUSE','POSITION_IN_WORK','HR_DEPARTMENT_SUB_SUB_NAME','LEAVE_DATE_BEGIN','LEAVE_DATE_END','WORK_DO','LEAVE_TYPE_ID','LEAVEDAY_ACTIVE','LEAVE_PERSON_ID','LEAVE_DATETIME_REGIS','LEAVE_WORK_SEND','LOCATION_NAME','LEAVE_APP_H1','LEAVE_APP_H2')
                ->leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_ID')
                ->leftJoin('gleave_status','gleave_register.LEAVE_STATUS_CODE','=','gleave_status.STATUS_CODE')
                ->leftJoin('gleave_location','gleave_register.LOCATION_ID','=','gleave_location.LOCATION_ID')
                ->leftJoin('hrd_person','hrd_person.ID','=','gleave_register.LEAVE_PERSON_ID')
                ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
                ->where(function($q) use ($search){
                    $q->where('LEAVE_YEAR_ID','like','%'.$search.'%');
                    $q->orwhere('LEAVE_PERSON_FULLNAME','like','%'.$search.'%');  
                    $q->orwhere('LEAVE_TYPE_NAME','like','%'.$search.'%');
                    $q->orwhere('LEAVE_BECAUSE','like','%'.$search.'%');
                    $q->orwhere('POSITION_IN_WORK','like','%'.$search.'%');
                    $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');
                  
                })
                ->WhereBetween('LEAVE_DATE_BEGIN',[$from,$to]) 
                ->orderBy('gleave_register.ID', 'desc')    
                ->limit(1600) 
                ->get();
                
            }else{

            

                if($status == 'VER'){
                    $inforleave=  Leave_register::select('gleave_register.ID','STATUS_CODE','STATUS_NAME','LEAVE_YEAR_ID','LEAVE_PERSON_FULLNAME','LEAVE_TYPE_NAME','LEAVE_BECAUSE','POSITION_IN_WORK','HR_DEPARTMENT_SUB_SUB_NAME','LEAVE_DATE_BEGIN','LEAVE_DATE_END','WORK_DO','LEAVE_TYPE_ID','LEAVEDAY_ACTIVE','LEAVE_PERSON_ID','LEAVE_DATETIME_REGIS','LEAVE_WORK_SEND','LOCATION_NAME','LEAVE_APP_H1','LEAVE_APP_H2')
                    ->leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_ID')
                    ->leftJoin('gleave_status','gleave_register.LEAVE_STATUS_CODE','=','gleave_status.STATUS_CODE')
                    ->leftJoin('gleave_location','gleave_register.LOCATION_ID','=','gleave_location.LOCATION_ID')
                    ->leftJoin('hrd_person','hrd_person.ID','=','gleave_register.LEAVE_PERSON_ID')
                    ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
                    ->where(function($q){
                        $q->where('LEAVE_STATUS_CODE','=','Approve');
                        $q->orwhere('LEAVE_STATUS_CODE','=','Appcancel');
            
                    }) 
                    ->where(function($q) use ($search){
                        $q->where('LEAVE_YEAR_ID','like','%'.$search.'%');
                        $q->orwhere('LEAVE_PERSON_FULLNAME','like','%'.$search.'%');  
                        $q->orwhere('LEAVE_TYPE_NAME','like','%'.$search.'%');
                        $q->orwhere('LEAVE_BECAUSE','like','%'.$search.'%');
                        $q->orwhere('POSITION_IN_WORK','like','%'.$search.'%');
                        $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');
                      
                    })
                    ->WhereBetween('LEAVE_DATE_BEGIN',[$from,$to]) 
                    ->orderBy('gleave_register.ID', 'desc')    
                    ->limit(1600) 
                    ->get();

                 

                }else{
                    $inforleave=  Leave_register::select('gleave_register.ID','STATUS_CODE','STATUS_NAME','LEAVE_YEAR_ID','LEAVE_PERSON_FULLNAME','LEAVE_TYPE_NAME','LEAVE_BECAUSE','POSITION_IN_WORK','HR_DEPARTMENT_SUB_SUB_NAME','LEAVE_DATE_BEGIN','LEAVE_DATE_END','WORK_DO','LEAVE_TYPE_ID','LEAVEDAY_ACTIVE','LEAVE_PERSON_ID','LEAVE_DATETIME_REGIS','LEAVE_WORK_SEND','LOCATION_NAME','LEAVE_APP_H1','LEAVE_APP_H2')
                    ->leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_ID')
                    ->leftJoin('gleave_status','gleave_register.LEAVE_STATUS_CODE','=','gleave_status.STATUS_CODE')
                    ->leftJoin('gleave_location','gleave_register.LOCATION_ID','=','gleave_location.LOCATION_ID')
                    ->leftJoin('hrd_person','hrd_person.ID','=','gleave_register.LEAVE_PERSON_ID')
                    ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
                    ->where('LEAVE_STATUS_CODE','=',$status)
                    ->where(function($q) use ($search){
                        $q->where('LEAVE_YEAR_ID','like','%'.$search.'%');
                        $q->orwhere('LEAVE_PERSON_FULLNAME','like','%'.$search.'%');  
                        $q->orwhere('LEAVE_TYPE_NAME','like','%'.$search.'%');
                        $q->orwhere('LEAVE_BECAUSE','like','%'.$search.'%');
                        $q->orwhere('POSITION_IN_WORK','like','%'.$search.'%');
                        $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');
                      
                    })
                    ->WhereBetween('LEAVE_DATE_BEGIN',[$from,$to]) 
                    ->orderBy('gleave_register.ID', 'desc')    
                    ->limit(1600)   
                    ->get();

                }

              
        
            }    
                
                 }else{
                    if($status == null){        
                    $inforleave=  Leave_register::select('gleave_register.ID','STATUS_CODE','STATUS_NAME','LEAVE_YEAR_ID','LEAVE_PERSON_FULLNAME','LEAVE_TYPE_NAME','LEAVE_BECAUSE','POSITION_IN_WORK','HR_DEPARTMENT_SUB_SUB_NAME','LEAVE_DATE_BEGIN','LEAVE_DATE_END','WORK_DO','LEAVE_TYPE_ID','LEAVEDAY_ACTIVE','LEAVE_PERSON_ID','LEAVE_DATETIME_REGIS','LEAVE_WORK_SEND','LOCATION_NAME','LEAVE_APP_H1','LEAVE_APP_H2')
                    ->leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_ID')
                    ->leftJoin('gleave_status','gleave_register.LEAVE_STATUS_CODE','=','gleave_status.STATUS_CODE')
                    ->leftJoin('gleave_location','gleave_register.LOCATION_ID','=','gleave_location.LOCATION_ID')
                    ->leftJoin('hrd_person','hrd_person.ID','=','gleave_register.LEAVE_PERSON_ID')
                    ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
                    ->where(function($q) use ($search){
                        $q->where('LEAVE_YEAR_ID','like','%'.$search.'%');
                        $q->orwhere('LEAVE_PERSON_FULLNAME','like','%'.$search.'%');               
                        $q->orwhere('LEAVE_TYPE_NAME','like','%'.$search.'%');
                        $q->orwhere('LEAVE_BECAUSE','like','%'.$search.'%');
                        $q->orwhere('POSITION_IN_WORK','like','%'.$search.'%');
                        $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');
                    })
                    ->orderBy('gleave_register.ID', 'desc')    
                    ->limit(1600)   
                    ->get();
                    }else{

                        if($status == 'VER'){

                            $inforleave=  Leave_register::select('gleave_register.ID','STATUS_CODE','STATUS_NAME','LEAVE_YEAR_ID','LEAVE_PERSON_FULLNAME','LEAVE_TYPE_NAME','LEAVE_BECAUSE','POSITION_IN_WORK','HR_DEPARTMENT_SUB_SUB_NAME','LEAVE_DATE_BEGIN','LEAVE_DATE_END','WORK_DO','LEAVE_TYPE_ID','LEAVEDAY_ACTIVE','LEAVE_PERSON_ID','LEAVE_DATETIME_REGIS','LEAVE_WORK_SEND','LOCATION_NAME','LEAVE_APP_H1','LEAVE_APP_H2')
                            ->leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_ID')
                            ->leftJoin('gleave_status','gleave_register.LEAVE_STATUS_CODE','=','gleave_status.STATUS_CODE')
                            ->leftJoin('gleave_location','gleave_register.LOCATION_ID','=','gleave_location.LOCATION_ID')
                            ->leftJoin('hrd_person','hrd_person.ID','=','gleave_register.LEAVE_PERSON_ID')
                            ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
                            ->where(function($q){
                                $q->where('LEAVE_STATUS_CODE','=','Approve');
                                $q->orwhere('LEAVE_STATUS_CODE','=','Appcancel');
                    
                            }) 
                            ->where(function($q) use ($search){
                                $q->where('LEAVE_YEAR_ID','like','%'.$search.'%');
                                $q->orwhere('LEAVE_PERSON_FULLNAME','like','%'.$search.'%');               
                                $q->orwhere('LEAVE_TYPE_NAME','like','%'.$search.'%');
                                $q->orwhere('LEAVE_BECAUSE','like','%'.$search.'%');
                                $q->orwhere('POSITION_IN_WORK','like','%'.$search.'%');
                                $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');
                            })
                            ->orderBy('gleave_register.ID', 'desc')    
                            ->limit(1600)   
                            ->get();

                        }else{

                            $inforleave=  Leave_register::select('gleave_register.ID','STATUS_CODE','STATUS_NAME','LEAVE_YEAR_ID','LEAVE_PERSON_FULLNAME','LEAVE_TYPE_NAME','LEAVE_BECAUSE','POSITION_IN_WORK','HR_DEPARTMENT_SUB_SUB_NAME','LEAVE_DATE_BEGIN','LEAVE_DATE_END','WORK_DO','LEAVE_TYPE_ID','LEAVEDAY_ACTIVE','LEAVE_PERSON_ID','LEAVE_DATETIME_REGIS','LEAVE_WORK_SEND','LOCATION_NAME','LEAVE_APP_H1','LEAVE_APP_H2')
                            ->leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_ID')
                            ->leftJoin('gleave_status','gleave_register.LEAVE_STATUS_CODE','=','gleave_status.STATUS_CODE')
                            ->leftJoin('gleave_location','gleave_register.LOCATION_ID','=','gleave_location.LOCATION_ID')
                            ->leftJoin('hrd_person','hrd_person.ID','=','gleave_register.LEAVE_PERSON_ID')
                            ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
                            ->where('LEAVE_STATUS_CODE','=',$status)
                            ->where(function($q) use ($search){
                                $q->where('LEAVE_YEAR_ID','like','%'.$search.'%');
                                $q->orwhere('LEAVE_PERSON_FULLNAME','like','%'.$search.'%');               
                                $q->orwhere('LEAVE_TYPE_NAME','like','%'.$search.'%');
                                $q->orwhere('LEAVE_BECAUSE','like','%'.$search.'%');
                                $q->orwhere('POSITION_IN_WORK','like','%'.$search.'%');
                                $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');
                            })
                            ->orderBy('gleave_register.ID', 'desc') 
                            ->limit(1600)   
                            ->get();

                        }

                    }        
                 }

                 
               

                 $infostatus =  LeaveStatus::get(); 
                 
                 $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
                 $year_id = $yearbudget;

        
                return view('manager_leave.personleaveinfocheckver',[
                    'inforleaves' => $inforleave,
                    'infostatuss' => $infostatus,
                    'budgets' =>  $budget,
                    'displaydate_bigen'=> $displaydate_bigen,
                    'displaydate_end'=> $displaydate_end,
                    'status_check'=> $status,
                    'search'=> $search,
                    'year_id'=>$year_id,
                ]);
               
    }      
    
public function updatever(Request $request)
    {
        $id = $request->ID;     
        $check =  $request->SUBMIT;     
        if($check == 'approved'){
          $statuscode = 'Verify';
          $statusline = "ผ่านการตรวจสอบ";
        }else{
          $statuscode = 'Disverify';
          $statusline = "ไม่ผ่านการตรวจสอบ";
        }

        date_default_timezone_set("Asia/Bangkok");

          $updatever = Leave_register::find($id);
          $updatever->LEAVE_STATUS_CODE = $statuscode; 
          $updatever->USER_CONFIRM_CHECK_ID = $request->USER_CONFIRM_CHECK_ID; 

          $infopersonver = Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
          ->where('hrd_person.ID','=',$request->USER_CONFIRM_CHECK_ID)
          ->first();

          $updatever->USER_CONFIRM_CHECK = $infopersonver ->HR_PREFIX_NAME.''.$infopersonver ->HR_FNAME.' '.$infopersonver ->HR_LNAME; 
          $updatever->CONFIRM_CHECK_DATE = date('Y-m-d H:i:s');
          
          
          $updatever->save();


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

              $header = "ข้อมูลตรวจสอบการลา";
           
              $infoleve = Leave_register::where('ID','=',$id)->first();

              $datebegin = DateThailinecar($infoleve->LEAVE_DATE_BEGIN); 
              $backtime = DateThailinecar($infoleve->LEAVE_DATE_END);           
              
              $leave_type = DB::table('gleave_type')->where('LEAVE_TYPE_ID','=',$infoleve->LEAVE_TYPE_CODE)->first(); 
              $hrd_department = DB::table('hrd_department')->where('HR_DEPARTMENT_ID','=',$infoleve->LEAVE_DEPARTMENT_ID)->first(); 
              
              if($infoleve->WORK_SEND_ID  !=''){
                $LEAVEWORK_SEND =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                ->where('hrd_person.ID','=',$infoleve->WORK_SEND_ID)->first();
       
                $LEAVEWORKSEND_name  = $LEAVEWORK_SEND->HR_PREFIX_NAME.''.$LEAVEWORK_SEND->HR_FNAME.' '.$LEAVEWORK_SEND->HR_LNAME;
                }else{
                   $LEAVEWORKSEND_name='';
                }
  
             $message = $header.
                 "\n"."ประเภท : " . $leave_type->LEAVE_TYPE_NAME .
                 "\n"."ผู้ลา : " . $infoleve->LEAVE_PERSON_FULLNAME .
                 "\n"."หน่วยงาน : " . $hrd_department->HR_DEPARTMENT_NAME  .
                 "\n"."เหตุผล : " . $infoleve->LEAVE_BECAUSE .
                 "\n"."ตั้งแต่วันที่ : " . $datebegin .               
                 "\n"."ถึงวันที่ : " . $backtime .    
                 "\n"."จำนวน : " . $infoleve->WORK_DO ." วัน". 
                 "\n"."ผู้รับมอบ : " . $LEAVEWORKSEND_name .
                 "\n"."ผู้ตรวจสอบ : " . $infopersonver ->HR_PREFIX_NAME.''.$infopersonver ->HR_FNAME.' '.$infopersonver ->HR_LNAME .
                 "\n"."สถานะ : " .  $statusline;             
                
              
                    $org_h = DB::table('info_org')->where('ORG_ID','=','1')->first();
                     $name = DB::table('hrd_person')->where('ID','=',$org_h->ORG_LEADER_ID)->first();        
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
  
 
        return redirect()->route('leave.inforvercheck');
    
    }

public function cancel(Request $request,$id)
    {    
        $inforleave=  Leave_register::leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_ID')
        ->leftJoin('gleave_status','gleave_register.LEAVE_STATUS_CODE','=','gleave_status.STATUS_CODE')       
        ->where('gleave_register.ID','=',$id)
        ->first();
          
        return view('manager_leave/personleaveinfocheckcancel',[         
           
            'inforleave' => $inforleave,
            'inforecordid' => $id
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
        "\n"."เหตุผลยกเลิก : " . $leaveinfo->LEAVE_CANCEL_COMMENT .
        "\n"."สถานะ : ยกเลิกวันลา ";             
       
      

            $name = DB::table('hrd_person')->where('ID','=',$leaveinfo->LEAVE_PERSON_ID)->first();        
            $test =$name->HR_LINE;

            if($name == null){
                $test ='';
            }else{
                $test =$name->HR_LINE;
            }    

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

             
            //แจ้งเตือนผู้รับมอบงาน

            $name2 = DB::table('hrd_person')->where('ID','=',$leaveinfo->LEAVE_WORK_SEND_ID)->first();    
            if($name2 == null){
                $test2 ='';
            }else{
                $test2 =$name2->HR_LINE;
            }    
          
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


              //แจ้งเตือนกลุ่มหน่วยงาน

              $name = DB::table('hrd_department_sub_sub')->where('HR_DEPARTMENT_SUB_SUB_ID','=',$name->HR_DEPARTMENT_SUB_SUB_ID)->first();        
              $tokendepsubsub =$name->LINE_TOKEN;

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



                return redirect()->route('leave.inforvercheck');    
    }




    //---------------------------นับรวมวันหยุด

public function checkholiday(Request $request)
{
    if(!empty($request->_token)){
        $search = $request->get('search');
        session(['manager_leave.checkholiday.search'=> $search]);
    }elseif(!empty(session('manager_leave.checkholiday'))){
        $search = session('manager_leave.checkholiday.search');
    }else{
        $search = '';
    }

    $person = Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->leftJoin('hrd_sex','hrd_person.SEX','=','hrd_sex.SEX_ID')
    ->leftJoin('hrd_status','hrd_person.HR_STATUS_ID','=','hrd_status.HR_STATUS_ID')
    ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
    ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
    ->leftJoin('hrd_department','hrd_person.HR_DEPARTMENT_ID','=','hrd_department.HR_DEPARTMENT_ID')
    ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
    ->leftJoin('users','hrd_person.ID','=','users.PERSON_ID')
    ->where(function($q) use ($search){
        $q->where('HR_CID','like','%'.$search.'%');
        $q->orwhere('HR_PREFIX_NAME','like','%'.$search.'%');
        $q->orwhere('HR_FNAME','like','%'.$search.'%');
        $q->orwhere('HR_LNAME','like','%'.$search.'%');
        $q->orwhere('HR_STATUS_NAME','like','%'.$search.'%');
        $q->orwhere('POSITION_IN_WORK','like','%'.$search.'%');
        $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');
        $q->orwhere('HR_DEPARTMENT_SUB_NAME','like','%'.$search.'%');
        $q->orwhere('HR_DEPARTMENT_NAME','like','%'.$search.'%');

    })
    ->where('hrd_person.HR_STATUS_ID','=',1)
    ->orderBy('hrd_person.ID', 'desc')    
    ->get();

            return view('manager_leave.checkholiday',[
                'persons' => $person, 
                'search' => $search, 
            ]);
}

public function checkholidaysearch(Request $request)
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
    ->where(function($q) use ($search){
        $q->where('HR_CID','like','%'.$search.'%');
        $q->orwhere('HR_PREFIX_NAME','like','%'.$search.'%');
        $q->orwhere('HR_FNAME','like','%'.$search.'%');
        $q->orwhere('HR_LNAME','like','%'.$search.'%');
        $q->orwhere('HR_STATUS_NAME','like','%'.$search.'%');
        $q->orwhere('POSITION_IN_WORK','like','%'.$search.'%');
        $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');
        $q->orwhere('HR_DEPARTMENT_SUB_NAME','like','%'.$search.'%');
        $q->orwhere('HR_DEPARTMENT_NAME','like','%'.$search.'%');

    })
    ->where('hrd_person.HR_STATUS_ID','=',1)
    ->orderBy('hrd_person.ID', 'desc')    
    ->get();

            return view('manager_leave.checkholiday',[
                'persons' => $person, 
                'search' => $search, 
            ]);
        
}


function switchleave(Request $request)
{  
    
    $id = $request->idperson;
    $chang = Person::find($id);
    $chang->LEAVEDAY_ACTIVE = $request->onoff;
    $chang->save();
}

  
//---------------------------นับ

public function countleave(Request $request)
{
    if(!empty($request->_token)){
        $search = $request->get('search');
        $yearbudget = $request->BUDGET_YEAR;
        $datebigin = $request->get('DATE_BIGIN');
        $dateend = $request->get('DATE_END');
        session([
            'manager_leave.countleave.search' => $search,
            'manager_leave.countleave.yearbudget' => $yearbudget,
            'manager_leave.countleave.datebigin' => $datebigin,
            'manager_leave.countleave.dateend' => $dateend
        ]);
    }elseif(!empty(session('manager_leave.countleave'))){
        $search = session('manager_leave.countleave.search');
        $yearbudget = session('manager_leave.countleave.yearbudget');
        $datebigin = session('manager_leave.countleave.datebigin');
        $dateend = session('manager_leave.countleave.dateend');
    }else{
        $search = '';
        $yearbudget = getBudgetyear();;
        $datebigin = date('d/m/Y');
        $dateend = date('d/m/Y');
    }
    $date_bigen_c = Carbon::createFromFormat('d/m/Y', $datebigin)->format('Y-m-d');
    $date_arrary = explode("-",$date_bigen_c);
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
    $person = Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->leftJoin('hrd_sex','hrd_person.SEX','=','hrd_sex.SEX_ID')
    ->leftJoin('hrd_status','hrd_person.HR_STATUS_ID','=','hrd_status.HR_STATUS_ID')
    ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
    ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
    ->leftJoin('hrd_department','hrd_person.HR_DEPARTMENT_ID','=','hrd_department.HR_DEPARTMENT_ID')
    ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
    ->leftJoin('users','hrd_person.ID','=','users.PERSON_ID')
    ->where(function($q) use ($search){
        $q->where('HR_CID','like','%'.$search.'%');
        $q->orwhere('HR_PREFIX_NAME','like','%'.$search.'%');
        $q->orwhere('HR_FNAME','like','%'.$search.'%');
        $q->orwhere('HR_LNAME','like','%'.$search.'%');
        $q->orwhere('POSITION_IN_WORK','like','%'.$search.'%');
        $q->orwhere('HR_DEPARTMENT_SUB_NAME','like','%'.$search.'%');
    })
    ->where('hrd_person.HR_STATUS_ID','=',1)
    ->orderBy('hrd_person.HR_FNAME', 'asc') 
    ->get();
    $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
    return view('manager_leave.countleave',[
        'persons' => $person,
        'budgetyears' => $budget,
        'displaydate_bigen'=> $displaydate_bigen,
        'displaydate_end'=> $displaydate_end,
        'search'=> $search,
        'year_id'=>$yearbudget
    ]);
}



public function countleavesearch(Request $request)
{
    $search = $request->get('search');
    $yearbudget = $request->BUDGET_YEAR;
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
  

    

    $person = Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->leftJoin('hrd_sex','hrd_person.SEX','=','hrd_sex.SEX_ID')
    ->leftJoin('hrd_status','hrd_person.HR_STATUS_ID','=','hrd_status.HR_STATUS_ID')
    ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
    ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
    ->leftJoin('hrd_department','hrd_person.HR_DEPARTMENT_ID','=','hrd_department.HR_DEPARTMENT_ID')
    ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
    ->leftJoin('users','hrd_person.ID','=','users.PERSON_ID')
    ->where(function($q) use ($search){
        $q->where('HR_CID','like','%'.$search.'%');
        $q->orwhere('HR_PREFIX_NAME','like','%'.$search.'%');
        $q->orwhere('HR_FNAME','like','%'.$search.'%');
        $q->orwhere('HR_LNAME','like','%'.$search.'%');
        $q->orwhere('POSITION_IN_WORK','like','%'.$search.'%');
        $q->orwhere('HR_DEPARTMENT_SUB_NAME','like','%'.$search.'%');
  

    })
    ->where('hrd_person.HR_STATUS_ID','=',1)
    ->orderBy('hrd_person.HR_FNAME', 'asc') 
    ->get();

        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

            return view('manager_leave.countleave',[
            'persons' => $person, 
            'budgetyears' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'search'=> $search,
            'year_id'=>$yearbudget 


]);
}


public function excelleave(Request $request,$datebegin,$dateend,$year_id,$search)
{
 if($search == 'null'){
    $search='';
 }

    $person = Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->leftJoin('hrd_sex','hrd_person.SEX','=','hrd_sex.SEX_ID')
    ->leftJoin('hrd_status','hrd_person.HR_STATUS_ID','=','hrd_status.HR_STATUS_ID')
    ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
    ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
    ->leftJoin('hrd_department','hrd_person.HR_DEPARTMENT_ID','=','hrd_department.HR_DEPARTMENT_ID')
    ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
    ->leftJoin('users','hrd_person.ID','=','users.PERSON_ID')
    ->where('hrd_person.HR_STATUS_ID','=',1)
    ->where(function($q) use ($search){
        $q->where('HR_CID','like','%'.$search.'%');
        $q->orwhere('HR_PREFIX_NAME','like','%'.$search.'%');
        $q->orwhere('HR_FNAME','like','%'.$search.'%');
        $q->orwhere('HR_LNAME','like','%'.$search.'%');
        $q->orwhere('POSITION_IN_WORK','like','%'.$search.'%');
        $q->orwhere('HR_DEPARTMENT_SUB_NAME','like','%'.$search.'%');
  

    })
    ->orderBy('hrd_person.HR_FNAME', 'asc') 
    ->get();




    return view('manager_leave.excelleave',[
        'persons' => $person, 
        'displaydate_bigen' => $datebegin, 
        'displaydate_end' => $dateend,
        'year_id' =>$year_id
    ]);
}





public function excelcheck(Request $request,$datebegin,$dateend,$year_id,$search)
{
    
    if($search == 'null'){
        $search='';
     }

    $inforleave=  Leave_register::select('gleave_register.ID','STATUS_CODE','STATUS_NAME','LEAVE_YEAR_ID','LEAVE_PERSON_FULLNAME','LEAVE_TYPE_NAME','LEAVE_BECAUSE','POSITION_IN_WORK','HR_DEPARTMENT_SUB_SUB_NAME','LEAVE_DATE_BEGIN','LEAVE_DATE_END','WORK_DO','LEAVE_TYPE_ID','LEAVEDAY_ACTIVE','LEAVE_PERSON_ID')
    ->leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_ID')
    ->leftJoin('gleave_status','gleave_register.LEAVE_STATUS_CODE','=','gleave_status.STATUS_CODE')
    ->leftJoin('hrd_person','hrd_person.ID','=','gleave_register.LEAVE_PERSON_ID')
    ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
    ->where(function($q) use ($search){
        $q->where('LEAVE_YEAR_ID','like','%'.$search.'%');
        $q->orwhere('LEAVE_PERSON_FULLNAME','like','%'.$search.'%');  
        $q->orwhere('LEAVE_TYPE_NAME','like','%'.$search.'%');
        $q->orwhere('LEAVE_BECAUSE','like','%'.$search.'%');
      
    })
    ->WhereBetween('LEAVE_DATE_BEGIN',[$datebegin,$dateend]) 
    ->orderBy('gleave_register.ID', 'desc')    
    ->get();

    $infostatus =  LeaveStatus::get();

    return view('manager_leave.excelcheck',[

        'inforleaves' => $inforleave,
        'infostatuss'=>$infostatus,
        'displaydate_bigen'=> $datebegin,
        'displaydate_end'=> $dateend,
        
    ]);

  
}

//--------------------------------------------แก้ไข---------------------------------------------------------

public function edit(Request $request,$id)
    {
      

         $budgetyear =  DB::table('budget_year') ->where('ACTIVE','=',True)->get();
         $location =  DB::table('gleave_location')->get();
         $daytype =  DB::table('gleave_day_type')->get();
         $leader =  DB::table('gleave_leader')->get();

         $infoleave =  Leave_register::leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_ID')
         ->where('ID','=',$id)->first();

         $inforpersonuserid =  Person::where('ID','=',$infoleave->LEAVE_PERSON_ID)->first();


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
         ->where('hrd_person.ID','=',$infoleave->LEAVE_PERSON_ID)->first();



         $leader_all =  DB::table('hrd_department_sub')
         ->select('LEADER_HR_ID','HR_FNAME','HR_LNAME')
         ->leftJoin('hrd_person','hrd_person.ID','=','hrd_department_sub.LEADER_HR_ID')
         ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
         ->where('LEADER_HR_ID','!=','')
         ->distinct()->get();




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
    ->where('LEAVE_PERSON_ID','=',$infoleave->LEAVE_PERSON_ID )
    ->sum('WORK_DO');

    $datehaveyear = DB::table('gleave_over')
    ->where('PERSON_ID','=',$infoleave->LEAVE_PERSON_ID )
    ->where('OVER_YEAR_ID','=',$yearbudget )
    ->sum('DAY_LEAVE_OVER_BEFORE');

    $datebalance = $datehaveyear  - $dateuse;

         return view('manager_leave.personleaveinfocheckedit',[
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
            'datebalance' => $datebalance

         ]);
    }

    public function updateedit(Request $request)
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
                $datebalance = '';    
            }
          

            $leavedatebalance = Leave_register::find($id);
            $leavedatebalance->LEAVE_BALANCE_DATE = $datebalance;
            $leavedatebalance->save();

         }
            return redirect()->route('leave.inforvercheck');
    }





//-------------------------------function---------------------
    public static function countdayleavemonth($user_id,$yearbudget,$type,$from,$to)
    {
            $count =  Leave_register::where('LEAVE_PERSON_ID','=',$user_id)
            ->where('LEAVE_YEAR_ID','=',$yearbudget )
            ->where('LEAVE_STATUS_CODE','=','Allow')
            ->where('LEAVE_TYPE_CODE','=',$type )
            ->WhereBetween('LEAVE_DATE_BEGIN',[$from,$to])
            ->sum('WORK_DO');

        return $count;
    }

    public static function countamountdayleavemonth($user_id,$yearbudget,$type,$from,$to)
    {
            $count =  Leave_register::where('LEAVE_PERSON_ID','=',$user_id)
            ->where('LEAVE_YEAR_ID','=',$yearbudget )
            ->where('LEAVE_STATUS_CODE','=','Allow')
            ->where('LEAVE_TYPE_CODE','=',$type )
            ->WhereBetween('LEAVE_DATE_BEGIN',[$from,$to])
            ->count();

        return $count;
    }



    

public static function sumcountdayleavemonth($user_id,$yearbudget,$from,$to)
{
        $count =  Leave_register::where('LEAVE_PERSON_ID','=',$user_id)
        ->where('LEAVE_YEAR_ID','=',$yearbudget )
        ->where('LEAVE_STATUS_CODE','=','Allow')
        ->WhereBetween('LEAVE_DATE_BEGIN',[$from,$to])
        ->sum('WORK_DO');

    return $count;
}

public static function sumcountamountdayleavemonth($user_id,$yearbudget,$from,$to)
{
        $count =  Leave_register::where('LEAVE_PERSON_ID','=',$user_id)
        ->where('LEAVE_YEAR_ID','=',$yearbudget )
        ->where('LEAVE_STATUS_CODE','=','Allow')
        ->WhereBetween('LEAVE_DATE_BEGIN',[$from,$to])
        ->count();

    return $count;
}


public static function counttotalleave($user_id,$yearbudget,$from,$to)
{
    $dateuse = DB::table('gleave_register')
    ->where('LEAVE_YEAR_ID','=',$yearbudget )
    ->where('LEAVE_TYPE_CODE','=','04' )
    ->where(function($q){
        $q->where('LEAVE_STATUS_CODE','=','Approve'); 
        $q->orwhere('LEAVE_STATUS_CODE','=','Pending');  
        $q->orwhere('LEAVE_STATUS_CODE','=','Verify');
        $q->orwhere('LEAVE_STATUS_CODE','=','Allow');
      
    })
    ->where('LEAVE_PERSON_ID','=',$user_id )
    ->sum('WORK_DO');

    $datehaveyear = DB::table('gleave_over')
    ->where('PERSON_ID','=',$user_id )
    ->where('OVER_YEAR_ID','=',$yearbudget )
    ->sum('DAY_LEAVE_OVER_BEFORE');


    $datebalance = $datehaveyear  - $dateuse;
    return $datebalance;
}


    //==================================================
    public function leaveday(Request $request)
    {
        if(!empty($request->_token)){
            $yearselect = $request->BUDGET_YEAR;
            $monthselect = $request->BUDGET_MONTH;
            $search = $request->search;
            session([
                'manager_leave.leaveday.yearselect' => $yearselect,
                'manager_leave.leaveday.monthselect' => $monthselect,
                'manager_leave.leaveday.search' => $search
            ]);
        }elseif(!empty(session('manager_leave.leaveday'))){
            $yearselect = session('manager_leave.leaveday.yearselect');
            $monthselect = session('manager_leave.leaveday.monthselect');
            $search = session('manager_leave.leaveday.search');
        }else{
            $yearselect =getBudgetyear();
            $monthselect = date('m');
            $search = '';
        }

        $person = Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_sex','hrd_person.SEX','=','hrd_sex.SEX_ID')
        ->leftJoin('hrd_status','hrd_person.HR_STATUS_ID','=','hrd_status.HR_STATUS_ID')
        ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
        ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->leftJoin('hrd_department','hrd_person.HR_DEPARTMENT_ID','=','hrd_department.HR_DEPARTMENT_ID')
        ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
        ->leftJoin('users','hrd_person.ID','=','users.PERSON_ID')
        ->where('hrd_person.HR_STATUS_ID','=',1)
        ->where(function($q) use ($search){
            $q->where('HR_FNAME','like','%'.$search.'%');
            $q->orwhere('HR_LNAME','like','%'.$search.'%');  
            $q->orwhere('POSITION_IN_WORK','like','%'.$search.'%');
            $q->orwhere('HR_DEPARTMENT_SUB_NAME','like','%'.$search.'%');
        })
        ->orderBy('hrd_person.HR_FNAME', 'asc')    
        ->orderBy('hrd_person.ID', 'desc')
        ->get();
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $budgetyearnow = $yearselect;
        $month = $monthselect;
        return view('manager_leave.leaveday',[
            'persons' => $person,
            'budgetyears' => $budget,
            'month' => $month,
            'search' => $search,
            'budgetyearnow' => $budgetyearnow
        ]);
    }


    public function leavedaysearch(Request $request)
    {
        $yearselect = $request->BUDGET_YEAR;
        $monthselect = $request->BUDGET_MONTH;
        $search = $request->search;

        $person = Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_sex','hrd_person.SEX','=','hrd_sex.SEX_ID')
        ->leftJoin('hrd_status','hrd_person.HR_STATUS_ID','=','hrd_status.HR_STATUS_ID')
        ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
        ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->leftJoin('hrd_department','hrd_person.HR_DEPARTMENT_ID','=','hrd_department.HR_DEPARTMENT_ID')
        ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
        ->leftJoin('users','hrd_person.ID','=','users.PERSON_ID')
        ->where('hrd_person.HR_STATUS_ID','=',1)
        ->where(function($q) use ($search){
            $q->where('HR_FNAME','like','%'.$search.'%');
            $q->orwhere('HR_LNAME','like','%'.$search.'%');  
            $q->orwhere('POSITION_IN_WORK','like','%'.$search.'%');
            $q->orwhere('HR_DEPARTMENT_SUB_NAME','like','%'.$search.'%');
        })
        ->orderBy('hrd_person.HR_FNAME', 'asc')    
        ->orderBy('hrd_person.ID', 'desc')
        ->get();

        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $budgetyearnow = $yearselect;
        $month = $monthselect;
                return view('manager_leave.leaveday',[
                    'persons' => $person,
                    'budgetyears' => $budget,
                    'month' => $month,
                    'search' => $search,
                    'budgetyearnow' => $budgetyearnow
                ]);
    }


    public function excelleaveday(Request $request)
    {
        if(!empty($request->_token)){
            $yearselect = $request->BUDGET_YEAR;
            $monthselect = $request->BUDGET_MONTH;
            $search = $request->search;
            session([
                'manager_leave.leaveday.yearselect' => $yearselect,
                'manager_leave.leaveday.monthselect' => $monthselect,
                'manager_leave.leaveday.search' => $search
            ]);
        }elseif(!empty(session('manager_leave.leaveday'))){
            $yearselect = session('manager_leave.leaveday.yearselect');
            $monthselect = session('manager_leave.leaveday.monthselect');
            $search = session('manager_leave.leaveday.search');
        }else{
            $yearselect =getBudgetyear();
            $monthselect = date('m');
            $search = '';
        }

        $person = Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_sex','hrd_person.SEX','=','hrd_sex.SEX_ID')
        ->leftJoin('hrd_status','hrd_person.HR_STATUS_ID','=','hrd_status.HR_STATUS_ID')
        ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
        ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->leftJoin('hrd_department','hrd_person.HR_DEPARTMENT_ID','=','hrd_department.HR_DEPARTMENT_ID')
        ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
        ->leftJoin('users','hrd_person.ID','=','users.PERSON_ID')
        ->where('hrd_person.HR_STATUS_ID','=',1)
        ->where(function($q) use ($search){
            $q->where('HR_FNAME','like','%'.$search.'%');
            $q->orwhere('HR_LNAME','like','%'.$search.'%');  
            $q->orwhere('POSITION_IN_WORK','like','%'.$search.'%');
            $q->orwhere('HR_DEPARTMENT_SUB_NAME','like','%'.$search.'%');
        })
        ->orderBy('hrd_person.HR_FNAME', 'asc')    
        ->orderBy('hrd_person.ID', 'desc')
        ->get();
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $budgetyearnow = $yearselect;
        $month = $monthselect;
        return view('manager_leave.excelleaveday',[
            'persons' => $person,
            'budgetyears' => $budget,
            'month' => $month,
            'search' => $search,
            'budgetyearnow' => $budgetyearnow
        ]);
    }



    //======ฟังชันรายงานการลา
    public static function leavemonth($user_id,$year,$month,$type)
    {
            $yearuse = $year- 543;
            $leavemonth =  Leave_register::where('LEAVE_PERSON_ID','=',$user_id)
            ->where('LEAVE_STATUS_CODE','=','Allow')
            ->where('LEAVE_TYPE_CODE','=',$type )
            ->where('LEAVE_DATE_BEGIN','like',$yearuse.'-'.$month.'-%')
            ->get();
            
            // dd($leavemonth);
            $output = "";
            foreach ($leavemonth as $leavedetail) {
                 $bigin = date("d",strtotime($leavedetail->LEAVE_DATE_BEGIN));
                 $end = date("d",strtotime($leavedetail->LEAVE_DATE_END));
              
                $output.= $bigin.'-'.$end.'='.number_format($leavedetail->WORK_DO,1).",";
           
                }
               
     

        return $output;
    }

    public static function sumleavemonth($user_id,$year,$month)
    {
            $yearuse = $year- 543;
            $leavemonth =  Leave_register::where('LEAVE_PERSON_ID','=',$user_id)
            ->where('LEAVE_STATUS_CODE','=','Allow')
            ->where(function($q){
                $q->where('LEAVE_TYPE_CODE','=','01'); 
                $q->orwhere('LEAVE_TYPE_CODE','=','02');  
                $q->orwhere('LEAVE_TYPE_CODE','=','03');
                $q->orwhere('LEAVE_TYPE_CODE','=','04');
              
            })
            ->where('LEAVE_DATE_BEGIN','like',$yearuse.'-'.$month.'-%')
            ->sum('WORK_DO');
            
       



        return number_format($leavemonth,1);
    }
  
//-------------------แนบเอกสาร

public function   certificate(Request $request,$id)
{
    $inforleave=  Leave_register::where('ID','=',$id)
    ->first();

    $detailleave = Leave_register::where('ID','=',$id)->first();
    return view('manager_leave.personleaveinfocertificate',[
        'detailleave' => $detailleave,
        'inforleave' => $inforleave 
    ]);
    
}

  
public function certificate_save(Request $request)
{
   
                $idfile = $request->ID;

       

           if($request->hasFile('pdfupload')){
          

               $newFileName = 'certificate_'.$idfile.'.'.$request->pdfupload->extension();
               
               $request->pdfupload->storeAs('leavepdf',$newFileName,'public');
     
   
           }

     
          
         
           return redirect()->route('leave.inforvercheck');

    
}

}