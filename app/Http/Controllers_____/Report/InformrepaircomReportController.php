<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InformrepaircomReportController extends Controller

{
    public function countRepaircomBystatus($status , $year_ad)
    {
        $q = DB::table('informcom_repair');
        if($status != 'all'){
            $q->where('REPAIR_STATUS',$status);
        }
        return $q->whereBetween('DATE_TIME_REQUEST',[$year_ad-1 . '-10-01 00:00:00', $year_ad . '-09-30 23:59:59'])->count();
    }

    public function countRepaircomBybetween($start_date , $end_date)
    {
        return DB::table('informcom_repair')
        ->whereBetween('DATE_TIME_REQUEST',[$start_date. ' 00:00:00', $end_date. ' 23:59:59'])->count();
    }

    public function countRepaircomFancinessScore($year_ad)
    {
        $arr[1] = DB::table('informcom_repair')->where('FANCINESS_SCORE',1)->whereBetween('DATE_TIME_REQUEST',[$year_ad-1 . '-10-01 00:00:00', $year_ad . '-09-30 23:59:59'])->count();
        $arr[2] = DB::table('informcom_repair')->where('FANCINESS_SCORE',2)->whereBetween('DATE_TIME_REQUEST',[$year_ad-1 . '-10-01 00:00:00', $year_ad . '-09-30 23:59:59'])->count();
        $arr[3] = DB::table('informcom_repair')->where('FANCINESS_SCORE',3)->whereBetween('DATE_TIME_REQUEST',[$year_ad-1 . '-10-01 00:00:00', $year_ad . '-09-30 23:59:59'])->count();
        $arr[4] = DB::table('informcom_repair')->where('FANCINESS_SCORE',4)->whereBetween('DATE_TIME_REQUEST',[$year_ad-1 . '-10-01 00:00:00', $year_ad . '-09-30 23:59:59'])->count();
        $arr[5] = DB::table('informcom_repair')->where('FANCINESS_SCORE',5)->whereBetween('DATE_TIME_REQUEST',[$year_ad-1 . '-10-01 00:00:00', $year_ad . '-09-30 23:59:59'])->count();
        return $arr;
    }

    public function countRepaircom_M($year_ad)
    {
        $arr = array();
        $arr[10] =  DB::table('informcom_repair')->whereYear('DATE_TIME_REQUEST',$year_ad-1)->whereMonth('DATE_TIME_REQUEST','10')->count();
        $arr[11] =  DB::table('informcom_repair')->whereYear('DATE_TIME_REQUEST',$year_ad-1)->whereMonth('DATE_TIME_REQUEST','11')->count();
        $arr[12] =  DB::table('informcom_repair')->whereYear('DATE_TIME_REQUEST',$year_ad-1)->whereMonth('DATE_TIME_REQUEST','12')->count();
        $arr[1] =  DB::table('informcom_repair')->whereYear('DATE_TIME_REQUEST',$year_ad)->whereMonth('DATE_TIME_REQUEST','01')->count();
        $arr[2] =  DB::table('informcom_repair')->whereYear('DATE_TIME_REQUEST',$year_ad)->whereMonth('DATE_TIME_REQUEST','02')->count();
        $arr[3] =  DB::table('informcom_repair')->whereYear('DATE_TIME_REQUEST',$year_ad)->whereMonth('DATE_TIME_REQUEST','03')->count();
        $arr[4] =  DB::table('informcom_repair')->whereYear('DATE_TIME_REQUEST',$year_ad)->whereMonth('DATE_TIME_REQUEST','04')->count();
        $arr[5] =  DB::table('informcom_repair')->whereYear('DATE_TIME_REQUEST',$year_ad)->whereMonth('DATE_TIME_REQUEST','05')->count();
        $arr[6] =  DB::table('informcom_repair')->whereYear('DATE_TIME_REQUEST',$year_ad)->whereMonth('DATE_TIME_REQUEST','06')->count();
        $arr[7] =  DB::table('informcom_repair')->whereYear('DATE_TIME_REQUEST',$year_ad)->whereMonth('DATE_TIME_REQUEST','07')->count();
        $arr[8] =  DB::table('informcom_repair')->whereYear('DATE_TIME_REQUEST',$year_ad)->whereMonth('DATE_TIME_REQUEST','08')->count();
        $arr[9] =  DB::table('informcom_repair')->whereYear('DATE_TIME_REQUEST',$year_ad)->whereMonth('DATE_TIME_REQUEST','09')->count();
        return $arr;
    }
    public function countRepaircom_M_success($year_ad)
    {
        $arr = array();
        $arr[10] =  DB::table('informcom_repair')->where(function ($q)
        {
            $q->where('REPAIR_STATUS','SUCCESS')
            ->orwhere('REPAIR_STATUS','OUTSIDE');
        })->whereYear('DATE_TIME_REQUEST',$year_ad-1)->whereMonth('DATE_TIME_REQUEST','10')->count();
        $arr[11] =  DB::table('informcom_repair')->where(function ($q)
        {
            $q->where('REPAIR_STATUS','SUCCESS')
            ->orwhere('REPAIR_STATUS','OUTSIDE');
        })->whereYear('DATE_TIME_REQUEST',$year_ad-1)->whereMonth('DATE_TIME_REQUEST','11')->count();
        $arr[12] =  DB::table('informcom_repair')->where(function ($q)
        {
            $q->where('REPAIR_STATUS','SUCCESS')
            ->orwhere('REPAIR_STATUS','OUTSIDE');
        })->whereYear('DATE_TIME_REQUEST',$year_ad-1)->whereMonth('DATE_TIME_REQUEST','12')->count();
        $arr[1] =  DB::table('informcom_repair')->where(function ($q)
        {
            $q->where('REPAIR_STATUS','SUCCESS')
            ->orwhere('REPAIR_STATUS','OUTSIDE');
        })->whereYear('DATE_TIME_REQUEST',$year_ad)->whereMonth('DATE_TIME_REQUEST','01')->count();
        $arr[2] =  DB::table('informcom_repair')->where(function ($q)
        {
            $q->where('REPAIR_STATUS','SUCCESS')
            ->orwhere('REPAIR_STATUS','OUTSIDE');
        })->whereYear('DATE_TIME_REQUEST',$year_ad)->whereMonth('DATE_TIME_REQUEST','02')->count();
        $arr[3] =  DB::table('informcom_repair')->where(function ($q)
        {
            $q->where('REPAIR_STATUS','SUCCESS')
            ->orwhere('REPAIR_STATUS','OUTSIDE');
        })->whereYear('DATE_TIME_REQUEST',$year_ad)->whereMonth('DATE_TIME_REQUEST','03')->count();
        $arr[4] =  DB::table('informcom_repair')->where(function ($q)
        {
            $q->where('REPAIR_STATUS','SUCCESS')
            ->orwhere('REPAIR_STATUS','OUTSIDE');
        })->whereYear('DATE_TIME_REQUEST',$year_ad)->whereMonth('DATE_TIME_REQUEST','04')->count();
        $arr[5] =  DB::table('informcom_repair')->where(function ($q)
        {
            $q->where('REPAIR_STATUS','SUCCESS')
            ->orwhere('REPAIR_STATUS','OUTSIDE');
        })->whereYear('DATE_TIME_REQUEST',$year_ad)->whereMonth('DATE_TIME_REQUEST','05')->count();
        $arr[6] =  DB::table('informcom_repair')->where(function ($q)
        {
            $q->where('REPAIR_STATUS','SUCCESS')
            ->orwhere('REPAIR_STATUS','OUTSIDE');
        })->whereYear('DATE_TIME_REQUEST',$year_ad)->whereMonth('DATE_TIME_REQUEST','06')->count();
        $arr[7] =  DB::table('informcom_repair')->where(function ($q)
        {
            $q->where('REPAIR_STATUS','SUCCESS')
            ->orwhere('REPAIR_STATUS','OUTSIDE');
        })->whereYear('DATE_TIME_REQUEST',$year_ad)->whereMonth('DATE_TIME_REQUEST','07')->count();
        $arr[8] =  DB::table('informcom_repair')->where(function ($q)
        {
            $q->where('REPAIR_STATUS','SUCCESS')
            ->orwhere('REPAIR_STATUS','OUTSIDE');
        })->whereYear('DATE_TIME_REQUEST',$year_ad)->whereMonth('DATE_TIME_REQUEST','08')->count();
        $arr[9] =  DB::table('informcom_repair')->where(function ($q)
        {
            $q->where('REPAIR_STATUS','SUCCESS')
            ->orwhere('REPAIR_STATUS','OUTSIDE');
        })->whereYear('DATE_TIME_REQUEST',$year_ad)->whereMonth('DATE_TIME_REQUEST','09')->count();
        return $arr;
    }
    public function countWorkofperson($year_ad)
    {
        //นับรวมข้อมูลจากสองตาราง ตารางช่างหลัก กับตารางช่างผู้ช่วย
        //นับข้อมูลจาก table informcom_repair
        $result1 = DB::table('informcom_repair')->select(DB::raw("TECH_REPAIR_ID as person_id ,count(TECH_REPAIR_ID) as count"))
         ->where('REPAIR_STATUS','<>','REQUEST')
         ->whereBetween('DATE_TIME_REQUEST',[$year_ad-1 . '-10-01 00:00:00', $year_ad . '-09-30 23:59:59'])
         ->groupBy('TECH_REPAIR_ID')->get();
        //นับข้อมูลจาก table informcom_repair_engineer
        $result2 = DB::table('informcom_repair_engineer')->select(DB::raw("informcom_repair_engineer.HR_PERSON_ID as person_id ,count(informcom_repair_engineer.HR_PERSON_ID) as count"))
        ->leftJoin('informcom_repair','informcom_repair.ID','informcom_repair_engineer.REPAIR_INDEX_ID')
        ->where(function ($q)
        {        
            $q->where('informcom_repair_engineer.HR_PERSON_ID','<>','')
            ->orwhere('informcom_repair_engineer.HR_PERSON_ID','<>',Null);
        })
        ->whereBetween('informcom_repair.DATE_TIME_REQUEST',[$year_ad-1 . '-10-01 00:00:00', $year_ad . '-09-30 23:59:59'])
        ->groupBy('informcom_repair_engineer.HR_PERSON_ID')->get();
        $person_id_All = array();
        foreach ($result1 as $value) {
            $person_id_All[$value->person_id]['id'] = $value->person_id;
            $person_id_All[$value->person_id]['count'] = $value->count;
        }
        foreach ($result2 as $value) {
            $person_id_All[$value->person_id]['id'] = $value->person_id;
            $person_id_All[$value->person_id]['count'] = $value->count;
        }
        foreach($result1 as $row1){
            foreach($result2 as $row2){
                if($row1->person_id == $row2->person_id){
                    $person_id_All[$row1->person_id]['count'] = $row1->count + $row2->count;
                }
            }
        }
         return $person_id_All;
    }

    public function getNameTechByperson_id($person_id)
    {
        $query = DB::table('hrd_person')
        ->leftJoin('hrd_prefix','hrd_prefix.HR_PREFIX_ID','hrd_person.HR_PREFIX_ID')
        ->select('hrd_prefix.HR_PREFIX_NAME','hrd_person.HR_FNAME' , 'hrd_person.HR_LNAME')
        ->where('hrd_person.ID',$person_id)
        ->first();
        $name = '-';
        if(isset($query)){
            $name = $query->HR_PREFIX_NAME.$query->HR_FNAME.'  '.$query->HR_LNAME;
        }
        return $name;
    }
    public function getRepaircom_Bybudgetyear_status($year_ad , $status)
    {
        $q = DB::table('informcom_repair')->select('REPAIR_ID', 'REPAIR_STATUS', 'PRIORITY_ID', 'FANCINESS_SCORE',
        'DATE_TIME_REQUEST', 'REPAIR_NAME', 'SYMPTOM', 'USRE_REQUEST_NAME', 'HR_DEPARTMENT_SUB_SUB_NAME', 'BUILD_NAME',
        'TECH_REPAIR_NAME', 'BUILD_NAME', 'informcom_repair.ID')
        ->leftjoin('hrd_person', 'informcom_repair.USER_REQUEST_ID', '=', 'hrd_person.ID')
        ->leftjoin('hrd_department_sub_sub', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID', '=',
        'hrd_person.HR_DEPARTMENT_SUB_SUB_ID')
        ->leftjoin('asset_building', 'informcom_repair.LOCATION_SEE_ID', '=', 'asset_building.ID');
        if ($status != 'all') {
            $q->where('REPAIR_STATUS', '=', $status);
        }
        return $q->WhereBetween('informcom_repair.DATE_TIME_REQUEST', [($year_ad - 1) . '-10-1 00:00:00', $year_ad . '-09-30 23:59:59'])
        ->orderBy('PRIORITY_ID', 'desc')->get();
    }
    //plan
    public function countRepaircomplanBybetween($start_date , $end_date)
    {
        return DB::table('informcom_plan')
        ->whereBetween('REPAIR_PLAN_DATE',[$start_date, $end_date])->count();
    }
    public function countRepaircomplan_Result($year_ad)
    {
        $arr['result_null'] = DB::table('informcom_plan')->where('REPAIR_RESULT',Null)->whereBetween('REPAIR_PLAN_DATE',[$year_ad-1 . '-10-01 00:00:00', $year_ad . '-09-30 23:59:59'])->count();
        $arr['result_have'] = DB::table('informcom_plan')->where('REPAIR_RESULT','<>',Null)->whereBetween('REPAIR_PLAN_DATE',[$year_ad-1 . '-10-01 00:00:00', $year_ad . '-09-30 23:59:59'])->count();
        return $arr;
    }
    
    public function countRepairPlan_M($year_ad)
    {
        $arr = array();
        $arr[10] =  DB::table('informcom_plan')->whereYear('REPAIR_PLAN_DATE',$year_ad-1)->whereMonth('REPAIR_PLAN_DATE','10')->count();
        $arr[11] =  DB::table('informrepair_plan')->whereYear('REPAIR_PLAN_DATE',$year_ad-1)->whereMonth('REPAIR_PLAN_DATE','11')->count();
        $arr[12] =  DB::table('informrepair_plan')->whereYear('REPAIR_PLAN_DATE',$year_ad-1)->whereMonth('REPAIR_PLAN_DATE','12')->count();
        $arr[1] =  DB::table('informrepair_plan')->whereYear('REPAIR_PLAN_DATE',$year_ad)->whereMonth('REPAIR_PLAN_DATE','01')->count();
        $arr[2] =  DB::table('informrepair_plan')->whereYear('REPAIR_PLAN_DATE',$year_ad)->whereMonth('REPAIR_PLAN_DATE','02')->count();
        $arr[3] =  DB::table('informrepair_plan')->whereYear('REPAIR_PLAN_DATE',$year_ad)->whereMonth('REPAIR_PLAN_DATE','03')->count();
        $arr[4] =  DB::table('informrepair_plan')->whereYear('REPAIR_PLAN_DATE',$year_ad)->whereMonth('REPAIR_PLAN_DATE','04')->count();
        $arr[5] =  DB::table('informrepair_plan')->whereYear('REPAIR_PLAN_DATE',$year_ad)->whereMonth('REPAIR_PLAN_DATE','05')->count();
        $arr[6] =  DB::table('informrepair_plan')->whereYear('REPAIR_PLAN_DATE',$year_ad)->whereMonth('REPAIR_PLAN_DATE','06')->count();
        $arr[7] =  DB::table('informrepair_plan')->whereYear('REPAIR_PLAN_DATE',$year_ad)->whereMonth('REPAIR_PLAN_DATE','07')->count();
        $arr[8] =  DB::table('informrepair_plan')->whereYear('REPAIR_PLAN_DATE',$year_ad)->whereMonth('REPAIR_PLAN_DATE','08')->count();
        $arr[9] =  DB::table('informrepair_plan')->whereYear('REPAIR_PLAN_DATE',$year_ad)->whereMonth('REPAIR_PLAN_DATE','09')->count();
        return $arr;
    }
}
