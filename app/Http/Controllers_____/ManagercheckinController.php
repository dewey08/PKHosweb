<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Person;
use App\Models\Vehiclecarindex;
use App\Models\Vehiclecarreserve;
use App\Models\Checkin;



date_default_timezone_set("Asia/Bangkok");

class ManagercheckinController extends Controller
{
    public function dashboard()
        {

         
                $checkin=DB::table('checkin_index')
                ->select(DB::raw('count(*) as amount_count,HR_DEPARTMENT_SUB_SUB_NAME'),'HR_DEPARTMENT_SUB_SUB_NAME')
                ->leftJoin('hrd_department_sub_sub','checkin_index.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
                ->where('CHECKIN_TYPE_ID','=',1)
                ->where('CHEACKIN_DATE','like',date('Y').'%')
                ->groupBy('HR_DEPARTMENT_SUB_SUB_NAME')
                ->orderBy('amount_count', 'desc')    
                ->get();


                $checkout=DB::table('checkin_index')
                ->select(DB::raw('count(*) as amount_count,HR_DEPARTMENT_SUB_SUB_NAME'),'HR_DEPARTMENT_SUB_SUB_NAME')
                ->leftJoin('hrd_department_sub_sub','checkin_index.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
                ->where('CHECKIN_TYPE_ID','=',2)
                ->where('CHEACKIN_DATE','like',date('Y').'%')
                ->groupBy('HR_DEPARTMENT_SUB_SUB_NAME')
                ->orderBy('amount_count', 'desc')    
                ->get();

                $countin =DB::table('checkin_index')              
                ->leftJoin('hrd_department_sub_sub','checkin_index.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
                ->where('CHECKIN_TYPE_ID','=',1)
                ->where('CHEACKIN_DATE','like',date('Y').'%')               
                ->count();

                $countout =DB::table('checkin_index')              
                ->leftJoin('hrd_department_sub_sub','checkin_index.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
                ->where('CHECKIN_TYPE_ID','=',2)
                ->where('CHEACKIN_DATE','like',date('Y').'%')               
                ->count();

                $countsubin =DB::table('checkin_index')              
                ->leftJoin('hrd_department_sub_sub','checkin_index.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
                ->where('CHECKIN_TYPE_ID','=',1)
                ->where('CHEACKIN_DATE','like',date('Y').'%') 
                ->groupBy('HR_DEPARTMENT_SUB_SUB_NAME')              
                ->count();

                $countsubout =DB::table('checkin_index')              
                ->leftJoin('hrd_department_sub_sub','checkin_index.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
                ->where('CHECKIN_TYPE_ID','=',2)
                ->where('CHEACKIN_DATE','like',date('Y').'%') 
                ->groupBy('HR_DEPARTMENT_SUB_SUB_NAME')              
                ->count();

               return view('manager_checkin.dashboard_checkin',[
          
            'countsubin' => $countsubin,
                  'countsubout' => $countsubout,
                    'countin' => $countin,
                     'countout' => $countout,
                    'checkouts' => $checkout,
                    'checkins' => $checkin
                     ]);
        }



        public function inforpersoncheck_new(Request $request)
        {
            if(!empty($request->_token)){
                $search = $request->search;
                $status = $request->STATUS_CODE;
                $datebigin = datepickerTodate($request->DATE_BIGIN);
                $dateend = datepickerTodate($request->DATE_END);
                session([
                    'manager_checkin.inforpersoncheck_new.search'=> $search,
                    'manager_checkin.inforpersoncheck_new.status'=> $status,
                    'manager_checkin.inforpersoncheck_new.datebigin'=> $datebigin,
                    'manager_checkin.inforpersoncheck_new.dateend'=> $dateend
                    ]);
            }elseif(!empty(session('manager_checkin.inforpersoncheck_new'))){
                $search = session('manager_checkin.inforpersoncheck_new.search');
                $status = session('manager_checkin.inforpersoncheck_new.status');
                $datebigin = session('manager_checkin.inforpersoncheck_new.datebigin');
                $dateend = session('manager_checkin.inforpersoncheck_new.dateend');
            }else{
                $search = '';
                $status = '';
                $datebigin = date('Y-m-d');
                $dateend = date('Y-m-d');
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
            
            ////// ดึงข้อมูลผู้ลงเวลาทำงาน
            $query = Checkin::leftJoin('checkin_type','checkin_index.CHECKIN_TYPE_ID','=','checkin_type.CHECKIN_TYPE_ID')
                ->leftJoin('operate_job','checkin_index.OPERATE_JOB_ID','=','operate_job.OPERATE_JOB_ID')
                ->leftJoin('operate_type','operate_job.OPERATE_JOB_TYPE_ID','=','operate_type.OPERATE_TYPE_ID')
                ->leftJoin('hrd_person','checkin_index.CHECKIN_PERSON_ID','=','hrd_person.ID')
                ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                ->leftJoin('hrd_position','checkin_index.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
                ->leftJoin('hrd_department_sub_sub','operate_job.OPERATE_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID');
                if($status != ''){
                    $query->where('checkin_index.CHECKIN_TYPE_ID','=',$status);
                }
                $inforcheckin = $query->where(function($q) use ($search){
                    $q->where('checkin_index.CHECKIN_ID','like','%'.$search.'%');
                    $q->orwhere('CHECKIN_TYPE_NAME','like','%'.$search.'%');
                    $q->orwhere('OPERATE_JOB_NAME','like','%'.$search.'%');
                    $q->orwhere('OPERATE_TYPE_NAME','like','%'.$search.'%');
                    $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');
                    $q->orwhere('HR_FNAME','like','%'.$search.'%');
                    $q->orwhere('HR_LNAME','like','%'.$search.'%');
                    })
                    ->WhereBetween('CHEACKIN_DATE',[$datebigin,$dateend])
                    ->orderBy('checkin_index.CHECKIN_ID', 'desc')
                    ->get();
            ////// นับจำนวนผู้ลงเวลาทำงาน
            $inforcheckin_count = $query = Checkin::leftJoin('checkin_type','checkin_index.CHECKIN_TYPE_ID','=','checkin_type.CHECKIN_TYPE_ID')
            ->leftJoin('operate_job','checkin_index.OPERATE_JOB_ID','=','operate_job.OPERATE_JOB_ID')
            ->leftJoin('operate_type','operate_job.OPERATE_JOB_TYPE_ID','=','operate_type.OPERATE_TYPE_ID')
            ->leftJoin('hrd_person','checkin_index.CHECKIN_PERSON_ID','=','hrd_person.ID')
            ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
            ->leftJoin('hrd_position','checkin_index.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
            ->leftJoin('hrd_department_sub_sub','operate_job.OPERATE_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID');
            if($status != ''){
                $query->where('checkin_index.CHECKIN_TYPE_ID','=',$status);
            }
            $inforcheckin_count = $query->where(function($q) use ($search){
                $q->where('checkin_index.CHECKIN_ID','like','%'.$search.'%');
                $q->orwhere('CHECKIN_TYPE_NAME','like','%'.$search.'%');
                $q->orwhere('OPERATE_JOB_NAME','like','%'.$search.'%');
                $q->orwhere('OPERATE_TYPE_NAME','like','%'.$search.'%');
                $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');
                $q->orwhere('HR_FNAME','like','%'.$search.'%');
                $q->orwhere('HR_LNAME','like','%'.$search.'%');
                })
                ->WhereBetween('CHEACKIN_DATE',[$datebigin,$dateend])
                ->orderBy('checkin_index.CHECKIN_ID', 'desc')
                ->count();
            $checkintype = DB::table('checkin_type')->get();
            $depart = DB::table('hrd_department_sub_sub')->get();
            return view('manager_checkin.inforpersoncheck_new',[
            'departs' => $depart,
            'inforcheckins' => $inforcheckin,
            'checkintypes'=>$checkintype,
            'displaydate_bigen'=> $datebigin,
            'displaydate_end'=> $dateend,
            'inforcheckin_counts' => $inforcheckin_count ,
            'status_check' => $status,
            'search' => $search
            ]);
        }
    
        public static function timecheck($id)
        {
             $timecheck  =  Checkin::where('CHECKIN_ID','=',$id)->get();
    
            return $timecheck ;
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
    
            return view('manager_checkin.excel_checkin_new',[
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

        

        public function inforpersoncheck_new_edit(Request $request,$idref)
        {    

            $infotime = Checkin::where('CHECKIN_ID','=',$idref)
            ->leftjoin('hrd_person','hrd_person.ID','=','checkin_index.CHECKIN_PERSON_ID')
            ->first();

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
            ->where('hrd_person.ID','=',$infotime->CHECKIN_PERSON_ID )->first();
    
            $depart =$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID;
            $checkintype = DB::table('checkin_type')->get();
            
            $operatejob = DB::table('operate_job')    
            ->where('OPERATE_DEPARTMENT_SUB_SUB_ID','=',$depart)
            ->get();
    
            return view('manager_checkin.inforpersoncheck_new_edit',[
                'infotime'=>$infotime,
                'checkintypes' => $checkintype, 
                'operatejobs' => $operatejob,
              
            ]);
        }


        public function inforpersoncheck_new_update(Request $request)
        {       
            
            
            $request->validate([
                'CHEACKIN_DATE' => 'required',
                'CHEACKIN_TIME' => 'required',
                'CHECKIN_TYPE_ID' => 'required',
                'OPERATE_JOB_ID' => 'required',
             
            ]);
            
            
            $id = $request->idref;
  
                    $CHEACKIN_DATE = $request->CHEACKIN_DATE;
              
                $date_bigin = Carbon::createFromFormat('d/m/Y', $CHEACKIN_DATE)->format('Y-m-d');
                $date_arrary=explode("-",$date_bigin);
                $y_sub_st = $date_arrary[0];
            
                if($y_sub_st >= 2500){
                    $y = $y_sub_st-543;
                }else{
                    $y = $y_sub_st;
                }    
                $m = $date_arrary[1];
                $d = $date_arrary[2];  
                $CHEACKINDATE= $y."-".$m."-".$d;
    
                $update = Checkin::find($id);
                $update->CHEACKIN_DATE = $CHEACKINDATE;
                $update->CHEACKIN_TIME = $request->CHEACKIN_TIME;
                $update->CHECKIN_TYPE_ID = $request->CHECKIN_TYPE_ID;
                $update->OPERATE_JOB_ID = $request->OPERATE_JOB_ID;
                $update->CHECKIN_REMARK = $request->CHECKIN_REMARK;
                $update->save();

                return response()->json([
                    'status' => 1,
                    'url' => url('manager_checkin/inforpersoncheck_new')
                ]);
        }


        public function inforpersoncheck_new_destroy(Request $request,$idref)
        {
            Checkin::destroy($idref);
         
    
            return redirect()->route('mcheckin.inforpersoncheck_new');
        }


}