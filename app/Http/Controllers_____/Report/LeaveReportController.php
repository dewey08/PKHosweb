<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Leave_register;

class LeaveReportController extends Controller
{
    public function countLeavepersonByyear_M($year_ad)
    {
        $arr = array();
        $arr[10] = DB::table('gleave_register')->where('LEAVE_STATUS_CODE','=','Allow')
        ->whereYear('LEAVE_DATE_BEGIN',$year_ad-1)->whereMonth('LEAVE_DATE_BEGIN','10')->count();
        $arr[11] = DB::table('gleave_register')->where('LEAVE_STATUS_CODE','=','Allow')
        ->whereYear('LEAVE_DATE_BEGIN',$year_ad-1)->whereMonth('LEAVE_DATE_BEGIN','11')->count();
        $arr[12] = DB::table('gleave_register')->where('LEAVE_STATUS_CODE','=','Allow')
        ->whereYear('LEAVE_DATE_BEGIN',$year_ad-1)->whereMonth('LEAVE_DATE_BEGIN','12')->count();
        $arr[1] = DB::table('gleave_register')->where('LEAVE_STATUS_CODE','=','Allow')
        ->whereYear('LEAVE_DATE_BEGIN',$year_ad)->whereMonth('LEAVE_DATE_BEGIN','01')->count();
        $arr[2] = DB::table('gleave_register')->where('LEAVE_STATUS_CODE','=','Allow')
        ->whereYear('LEAVE_DATE_BEGIN',$year_ad)->whereMonth('LEAVE_DATE_BEGIN','02')->count();
        $arr[3] = DB::table('gleave_register')->where('LEAVE_STATUS_CODE','=','Allow')
        ->whereYear('LEAVE_DATE_BEGIN',$year_ad)->whereMonth('LEAVE_DATE_BEGIN','03')->count();
        $arr[4] = DB::table('gleave_register')->where('LEAVE_STATUS_CODE','=','Allow')
        ->whereYear('LEAVE_DATE_BEGIN',$year_ad)->whereMonth('LEAVE_DATE_BEGIN','04')->count();
        $arr[5] = DB::table('gleave_register')->where('LEAVE_STATUS_CODE','=','Allow')
        ->whereYear('LEAVE_DATE_BEGIN',$year_ad)->whereMonth('LEAVE_DATE_BEGIN','05')->count();
        $arr[6] = DB::table('gleave_register')->where('LEAVE_STATUS_CODE','=','Allow')
        ->whereYear('LEAVE_DATE_BEGIN',$year_ad)->whereMonth('LEAVE_DATE_BEGIN','06')->count();
        $arr[7] = DB::table('gleave_register')->where('LEAVE_STATUS_CODE','=','Allow')
        ->whereYear('LEAVE_DATE_BEGIN',$year_ad)->whereMonth('LEAVE_DATE_BEGIN','07')->count();
        $arr[8] = DB::table('gleave_register')->where('LEAVE_STATUS_CODE','=','Allow')
        ->whereYear('LEAVE_DATE_BEGIN',$year_ad)->whereMonth('LEAVE_DATE_BEGIN','08')->count();
        $arr[9] = DB::table('gleave_register')->where('LEAVE_STATUS_CODE','=','Allow')
        ->whereYear('LEAVE_DATE_BEGIN',$year_ad)->whereMonth('LEAVE_DATE_BEGIN','09')->count();
        return $arr;
    }public function countLeavepersonByyear_type_M($year_ad,$type)
    {
        $arr = array();
        $arr[10] = DB::table('gleave_register')->where('LEAVE_STATUS_CODE','=','Allow')
        ->where('LEAVE_TYPE_CODE',$type)
        ->whereYear('LEAVE_DATE_BEGIN',$year_ad-1)->whereMonth('LEAVE_DATE_BEGIN','10')->count();
        $arr[11] = DB::table('gleave_register')->where('LEAVE_STATUS_CODE','=','Allow')
        ->where('LEAVE_TYPE_CODE',$type)
        ->whereYear('LEAVE_DATE_BEGIN',$year_ad-1)->whereMonth('LEAVE_DATE_BEGIN','11')->count();
        $arr[12] = DB::table('gleave_register')->where('LEAVE_STATUS_CODE','=','Allow')
        ->where('LEAVE_TYPE_CODE',$type)
        ->whereYear('LEAVE_DATE_BEGIN',$year_ad-1)->whereMonth('LEAVE_DATE_BEGIN','12')->count();
        $arr[1] = DB::table('gleave_register')->where('LEAVE_STATUS_CODE','=','Allow')
        ->where('LEAVE_TYPE_CODE',$type)
        ->whereYear('LEAVE_DATE_BEGIN',$year_ad)->whereMonth('LEAVE_DATE_BEGIN','01')->count();
        $arr[2] = DB::table('gleave_register')->where('LEAVE_STATUS_CODE','=','Allow')
        ->where('LEAVE_TYPE_CODE',$type)
        ->whereYear('LEAVE_DATE_BEGIN',$year_ad)->whereMonth('LEAVE_DATE_BEGIN','02')->count();
        $arr[3] = DB::table('gleave_register')->where('LEAVE_STATUS_CODE','=','Allow')
        ->where('LEAVE_TYPE_CODE',$type)
        ->whereYear('LEAVE_DATE_BEGIN',$year_ad)->whereMonth('LEAVE_DATE_BEGIN','03')->count();
        $arr[4] = DB::table('gleave_register')->where('LEAVE_STATUS_CODE','=','Allow')
        ->where('LEAVE_TYPE_CODE',$type)
        ->whereYear('LEAVE_DATE_BEGIN',$year_ad)->whereMonth('LEAVE_DATE_BEGIN','04')->count();
        $arr[5] = DB::table('gleave_register')->where('LEAVE_STATUS_CODE','=','Allow')
        ->where('LEAVE_TYPE_CODE',$type)
        ->whereYear('LEAVE_DATE_BEGIN',$year_ad)->whereMonth('LEAVE_DATE_BEGIN','05')->count();
        $arr[6] = DB::table('gleave_register')->where('LEAVE_STATUS_CODE','=','Allow')
        ->where('LEAVE_TYPE_CODE',$type)
        ->whereYear('LEAVE_DATE_BEGIN',$year_ad)->whereMonth('LEAVE_DATE_BEGIN','06')->count();
        $arr[7] = DB::table('gleave_register')->where('LEAVE_STATUS_CODE','=','Allow')
        ->where('LEAVE_TYPE_CODE',$type)
        ->whereYear('LEAVE_DATE_BEGIN',$year_ad)->whereMonth('LEAVE_DATE_BEGIN','07')->count();
        $arr[8] = DB::table('gleave_register')->where('LEAVE_STATUS_CODE','=','Allow')
        ->where('LEAVE_TYPE_CODE',$type)
        ->whereYear('LEAVE_DATE_BEGIN',$year_ad)->whereMonth('LEAVE_DATE_BEGIN','08')->count();
        $arr[9] = DB::table('gleave_register')->where('LEAVE_STATUS_CODE','=','Allow')
        ->where('LEAVE_TYPE_CODE',$type)
        ->whereYear('LEAVE_DATE_BEGIN',$year_ad)->whereMonth('LEAVE_DATE_BEGIN','09')->count();
        return $arr;
    }

    public function countPersonLeaveBytype_year_M($type_id,$year_ad)
    {
        $arr = array();
        $q = DB::table('gleave_register');
        if($type_id != 'all'){
            $q->where('LEAVE_TYPE_CODE',(int)$type_id);
        }
        $arr[10]  = $q->where('LEAVE_STATUS_CODE','=','Allow')
        ->whereYear('LEAVE_DATE_BEGIN',$year_ad-1)->whereMonth('LEAVE_DATE_BEGIN','10')->count();
        $q = DB::table('gleave_register');
        if($type_id != 'all'){
            $q->where('LEAVE_TYPE_CODE',(int)$type_id);
        }
        $arr[11]  = $q->where('LEAVE_STATUS_CODE','=','Allow')
        ->whereYear('LEAVE_DATE_BEGIN',$year_ad-1)->whereMonth('LEAVE_DATE_BEGIN','11')->count();
        $q = DB::table('gleave_register');
        if($type_id != 'all'){
            $q->where('LEAVE_TYPE_CODE',(int)$type_id);
        }
        $arr[12]  = $q->where('LEAVE_STATUS_CODE','=','Allow')
        ->whereYear('LEAVE_DATE_BEGIN',$year_ad-1)->whereMonth('LEAVE_DATE_BEGIN','12')->count();
        $q = DB::table('gleave_register');
        if($type_id != 'all'){
            $q->where('LEAVE_TYPE_CODE',(int)$type_id);
        }
        $arr[1]  = $q->where('LEAVE_STATUS_CODE','=','Allow')
        ->whereYear('LEAVE_DATE_BEGIN',$year_ad)->whereMonth('LEAVE_DATE_BEGIN','01')->count();
        $q = DB::table('gleave_register');
        if($type_id != 'all'){
            $q->where('LEAVE_TYPE_CODE',(int)$type_id);
        }
        $arr[2]  = $q->where('LEAVE_STATUS_CODE','=','Allow')
        ->whereYear('LEAVE_DATE_BEGIN',$year_ad)->whereMonth('LEAVE_DATE_BEGIN','02')->count();
        $q = DB::table('gleave_register');
        if($type_id != 'all'){
            $q->where('LEAVE_TYPE_CODE',(int)$type_id);
        }
        $arr[3]  = $q->where('LEAVE_STATUS_CODE','=','Allow')
        ->whereYear('LEAVE_DATE_BEGIN',$year_ad)->whereMonth('LEAVE_DATE_BEGIN','03')->count();
        $q = DB::table('gleave_register');
        if($type_id != 'all'){
            $q->where('LEAVE_TYPE_CODE',(int)$type_id);
        }
        $arr[4]  = $q->where('LEAVE_STATUS_CODE','=','Allow')
        ->whereYear('LEAVE_DATE_BEGIN',$year_ad)->whereMonth('LEAVE_DATE_BEGIN','04')->count();
        $q = DB::table('gleave_register');
        if($type_id != 'all'){
            $q->where('LEAVE_TYPE_CODE',(int)$type_id);
        }
        $arr[5]  = $q->where('LEAVE_STATUS_CODE','=','Allow')
        ->whereYear('LEAVE_DATE_BEGIN',$year_ad)->whereMonth('LEAVE_DATE_BEGIN','05')->count();
        $q = DB::table('gleave_register');
        if($type_id != 'all'){
            $q->where('LEAVE_TYPE_CODE',(int)$type_id);
        }
        $arr[6]  = $q->where('LEAVE_STATUS_CODE','=','Allow')
        ->whereYear('LEAVE_DATE_BEGIN',$year_ad)->whereMonth('LEAVE_DATE_BEGIN','06')->count();
        $q = DB::table('gleave_register');
        if($type_id != 'all'){
            $q->where('LEAVE_TYPE_CODE',(int)$type_id);
        }
        $arr[7]  = $q->where('LEAVE_STATUS_CODE','=','Allow')
        ->whereYear('LEAVE_DATE_BEGIN',$year_ad)->whereMonth('LEAVE_DATE_BEGIN','07')->count();
        $q = DB::table('gleave_register');
        if($type_id != 'all'){
            $q->where('LEAVE_TYPE_CODE',(int)$type_id);
        }
        $arr[8]  = $q->where('LEAVE_STATUS_CODE','=','Allow')
        ->whereYear('LEAVE_DATE_BEGIN',$year_ad)->whereMonth('LEAVE_DATE_BEGIN','08')->count();
        $q = DB::table('gleave_register');
        if($type_id != 'all'){
            $q->where('LEAVE_TYPE_CODE',(int)$type_id);
        }
        $arr[9]  = $q->where('LEAVE_STATUS_CODE','=','Allow')
        ->whereYear('LEAVE_DATE_BEGIN',$year_ad)->whereMonth('LEAVE_DATE_BEGIN','09')->count();
        return $arr;
    }
    
    
    public function getPersonLeaveBytype_year($type_id,$year_ad)
    {
         $q =DB::table('gleave_register')
        ->select(DB::raw('LEAVE_PERSON_ID,count(WORK_DO) as count,sum(WORK_DO) as work_do'));
        if($type_id != 'all'){
            $q->where('LEAVE_TYPE_CODE',(int)$type_id);
        }
        $reulstLeave =  $q ->where('gleave_register.LEAVE_STATUS_CODE','Allow')
        ->whereBetween('gleave_register.LEAVE_DATE_BEGIN',[($year_ad-1).'-10-01',$year_ad.'-09-30'])
        ->groupBy('LEAVE_PERSON_ID')
         ->orderBy('work_do','DESC')->get();

        $arr = array();
        foreach ($reulstLeave as $value) {
            $q = DB::table('hrd_person')->where('ID',$value->LEAVE_PERSON_ID)
            ->select('HR_PREFIX_NAME','HR_FNAME','HR_LNAME','SEX_NAME','HR_POSITION_NAME','HR_DEPARTMENT_SUB_SUB_NAME','HR_DEPARTMENT_SUB_NAME','HR_PERSON_TYPE_NAME')
            ->leftJoin('hrd_prefix', 'hrd_prefix.HR_PREFIX_ID', 'hrd_person.HR_PREFIX_ID')
            ->leftJoin('hrd_sex', 'hrd_sex.SEX_ID', 'hrd_person.SEX')
            ->leftJoin('hrd_position', 'hrd_position.HR_POSITION_ID', 'hrd_person.HR_POSITION_ID')
            ->leftJoin('hrd_department_sub_sub', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID', 'hrd_person.HR_DEPARTMENT_SUB_SUB_ID')
            ->leftJoin('hrd_department_sub', 'hrd_department_sub.HR_DEPARTMENT_SUB_ID', 'hrd_person.HR_DEPARTMENT_SUB_ID')
            ->leftJoin('hrd_person_type', 'hrd_person_type.HR_PERSON_TYPE_ID', 'hrd_person.HR_PERSON_TYPE_ID')
            ->first();
            $arr[$value->LEAVE_PERSON_ID] = [
              0 => $q->HR_PREFIX_NAME.$q->HR_FNAME.' '.$q->HR_LNAME ,    
              1 => $q->SEX_NAME ,    
              2 => $q->HR_POSITION_NAME ,    
              3 => $q->HR_DEPARTMENT_SUB_SUB_NAME ,    
              4 => $q->HR_DEPARTMENT_SUB_NAME ,    
              5 => $q->HR_PERSON_TYPE_NAME ,    
              6 => $value->count ,    
              7 => $value->work_do    
            ];
        }
        return $arr;
        // 'hrd_prefix.HR_PREFIX_NAME',
        // 'gleave_type.LEAVE_TYPE_NAME',
        // 'hrd_person.HR_FNAME',
        // 'hrd_person.HR_LNAME',
        // 'hrd_sex.SEX_NAME',
        // 'hrd_position.HR_POSITION_NAME',
        // 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_NAME',
        // 'hrd_department_sub.HR_DEPARTMENT_SUB_NAME',
        // 'hrd_person_type.HR_PERSON_TYPE_NAME'
    }
    
    public function countLeavePersonByyear_type($year_ad,$type)
    {
        $q = DB::table('gleave_register')
        ->whereBetween('LEAVE_DATE_BEGIN',[($year_ad-1).'-10-01',$year_ad.'-09-30']);
        if($type != 'all'){
            $q->where('LEAVE_TYPE_CODE',(int)$type);
        }
        return array('id'=>$type,'count'=> $q->where('LEAVE_STATUS_CODE','Allow')->count());
         
    }
    public function groupcountLeavepersonAlltypeByyear_M($year_ad)
    {
        $arr = array();
        $q1 = DB::table('gleave_type')->get();
        foreach ($q1 as $key => $row) {
            $typeid = $row->LEAVE_TYPE_ID;
            $arr[$typeid]['name'] = $row->LEAVE_TYPE_NAME;
            $arr[$typeid][10] = DB::table('gleave_register')->where('LEAVE_TYPE_CODE',$typeid)->where('LEAVE_STATUS_CODE','=','Allow')
            ->whereYear('LEAVE_DATE_BEGIN',$year_ad-1)->whereMonth('LEAVE_DATE_BEGIN','10')->count();
            $arr[$typeid][11] = DB::table('gleave_register')->where('LEAVE_TYPE_CODE',$typeid)->where('LEAVE_STATUS_CODE','=','Allow')
            ->whereYear('LEAVE_DATE_BEGIN',$year_ad-1)->whereMonth('LEAVE_DATE_BEGIN','11')->count();
            $arr[$typeid][12] = DB::table('gleave_register')->where('LEAVE_TYPE_CODE',$typeid)->where('LEAVE_STATUS_CODE','=','Allow')
            ->whereYear('LEAVE_DATE_BEGIN',$year_ad-1)->whereMonth('LEAVE_DATE_BEGIN','12')->count();
            $arr[$typeid][1] = DB::table('gleave_register')->where('LEAVE_TYPE_CODE',$typeid)->where('LEAVE_STATUS_CODE','=','Allow')
            ->whereYear('LEAVE_DATE_BEGIN',$year_ad)->whereMonth('LEAVE_DATE_BEGIN','01')->count();
            $arr[$typeid][2] = DB::table('gleave_register')->where('LEAVE_TYPE_CODE',$typeid)->where('LEAVE_STATUS_CODE','=','Allow')
            ->whereYear('LEAVE_DATE_BEGIN',$year_ad)->whereMonth('LEAVE_DATE_BEGIN','02')->count();
            $arr[$typeid][3] = DB::table('gleave_register')->where('LEAVE_TYPE_CODE',$typeid)->where('LEAVE_STATUS_CODE','=','Allow')
            ->whereYear('LEAVE_DATE_BEGIN',$year_ad)->whereMonth('LEAVE_DATE_BEGIN','03')->count();
            $arr[$typeid][4] = DB::table('gleave_register')->where('LEAVE_TYPE_CODE',$typeid)->where('LEAVE_STATUS_CODE','=','Allow')
            ->whereYear('LEAVE_DATE_BEGIN',$year_ad)->whereMonth('LEAVE_DATE_BEGIN','04')->count();
            $arr[$typeid][5] = DB::table('gleave_register')->where('LEAVE_TYPE_CODE',$typeid)->where('LEAVE_STATUS_CODE','=','Allow')
            ->whereYear('LEAVE_DATE_BEGIN',$year_ad)->whereMonth('LEAVE_DATE_BEGIN','05')->count();
            $arr[$typeid][6] = DB::table('gleave_register')->where('LEAVE_TYPE_CODE',$typeid)->where('LEAVE_STATUS_CODE','=','Allow')
            ->whereYear('LEAVE_DATE_BEGIN',$year_ad)->whereMonth('LEAVE_DATE_BEGIN','06')->count();
            $arr[$typeid][7] = DB::table('gleave_register')->where('LEAVE_TYPE_CODE',$typeid)->where('LEAVE_STATUS_CODE','=','Allow')
            ->whereYear('LEAVE_DATE_BEGIN',$year_ad)->whereMonth('LEAVE_DATE_BEGIN','07')->count();
            $arr[$typeid][8] = DB::table('gleave_register')->where('LEAVE_TYPE_CODE',$typeid)->where('LEAVE_STATUS_CODE','=','Allow')
            ->whereYear('LEAVE_DATE_BEGIN',$year_ad)->whereMonth('LEAVE_DATE_BEGIN','08')->count();
            $arr[$typeid][9] = DB::table('gleave_register')->where('LEAVE_TYPE_CODE',$typeid)->where('LEAVE_STATUS_CODE','=','Allow')
            ->whereYear('LEAVE_DATE_BEGIN',$year_ad)->whereMonth('LEAVE_DATE_BEGIN','09')->count();
            $arr[$typeid]['total'] = DB::table('gleave_register')->where('LEAVE_TYPE_CODE',$typeid)->where('LEAVE_STATUS_CODE','=','Allow')
            ->whereBetween('LEAVE_DATE_BEGIN',[($year_ad-1).'-10-01',$year_ad.'-09-30'])->count();
        }
        return $arr;
    }
    public function getLeaveCheck($date_start,$date_end,$search,$status,$limit = 1000)
    {
        $q_ = Leave_register::select('gleave_register.ID','STATUS_CODE','STATUS_NAME','LEAVE_YEAR_ID','LEAVE_PERSON_FULLNAME','LEAVE_TYPE_NAME','LEAVE_BECAUSE','POSITION_IN_WORK','HR_DEPARTMENT_SUB_SUB_NAME','LEAVE_DATE_BEGIN','LEAVE_DATE_END','WORK_DO','LEAVE_TYPE_ID','LEAVEDAY_ACTIVE','LEAVE_PERSON_ID','LEAVE_DATETIME_REGIS','LEAVE_WORK_SEND','LOCATION_NAME','LEAVE_SUM_ALL','LEAVE_SUM_HOLIDAY','LEAVE_SUM_SETSUN','LEAVE_COMMENT_BY','LEAVE_CONTACT_PHONE','LEAVE_CONTACT','LEAVE_APP_H1','LEAVE_APP_H2','LEAVE_APP_SEND','LEAVE_WORK_SEND_ID')
        ->leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_ID')
        ->leftJoin('gleave_status','gleave_register.LEAVE_STATUS_CODE','=','gleave_status.STATUS_CODE')
        ->leftJoin('gleave_location','gleave_register.LOCATION_ID','=','gleave_location.LOCATION_ID')
        ->leftJoin('hrd_person','hrd_person.ID','=','gleave_register.LEAVE_PERSON_ID')
        ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID');
        
        
        if($status == 'all'){
            #
        }else if($status == 'VER') {
            $q_->where(function($q){
                $q->where('LEAVE_STATUS_CODE','=','Approve');
                $q->orwhere('LEAVE_STATUS_CODE','=','ApproveGroup');
                });
        }else{
            $q_->where('LEAVE_STATUS_CODE','=',$status);
        }


        return $q_->where(function($q) use ($search){
        $q->where('LEAVE_YEAR_ID','like','%'.$search.'%');
        $q->orwhere('LEAVE_PERSON_FULLNAME','like','%'.$search.'%');
        $q->orwhere('LEAVE_TYPE_NAME','like','%'.$search.'%');
        $q->orwhere('LEAVE_BECAUSE','like','%'.$search.'%');
        $q->orwhere('POSITION_IN_WORK','like','%'.$search.'%');
        $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');
        })
        ->WhereBetween('LEAVE_DATE_BEGIN',[$date_start,$date_end])
        ->orderBy('gleave_register.ID', 'desc')
        ->limit($limit)
        ->get();
    }
}
