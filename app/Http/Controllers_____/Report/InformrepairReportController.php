<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InformrepairReportController extends Controller
{

    public function getInforrepairByStatus($status = 'all' , $year_ad = 'all')
    {
        $q = DB::table('informrepair_index');
        if($status != 'all'){
            $q->where('REPAIR_STATUS',$status);
        }
        if($year_ad != 'all'){
            $q->whereBetween('DATE_TIME_REQUEST',[($year_ad - 1) . '-10-01 00:00:00', $year_ad . '-09-30 23:59:59']);
        }
        return $q->count();
    }
    
    public function countInforrepairByStatus_between($status ,$start_date , $end_date)
    {
        $q = DB::table('informrepair_index');
        if($status != 'all'){
            $q->where('REPAIR_STATUS',$status);
        }
        $q->whereBetween('DATE_TIME_REQUEST',[$start_date . ' 00:00:00', $end_date . ' 23:59:59']);
        return $q->count();
    }
    
    public function countInformrepair_M_ByYear($year_ad)
    {
        $arr = array();
        $arr[10] =  DB::table('informrepair_index')->whereYear('DATE_TIME_REQUEST',$year_ad-1)->whereMonth('DATE_TIME_REQUEST','10')->count();
        $arr[11] =  DB::table('informrepair_index')->whereYear('DATE_TIME_REQUEST',$year_ad-1)->whereMonth('DATE_TIME_REQUEST','11')->count();
        $arr[12] =  DB::table('informrepair_index')->whereYear('DATE_TIME_REQUEST',$year_ad-1)->whereMonth('DATE_TIME_REQUEST','12')->count();
        $arr[1] =  DB::table('informrepair_index')->whereYear('DATE_TIME_REQUEST',$year_ad)->whereMonth('DATE_TIME_REQUEST','01')->count();
        $arr[2] =  DB::table('informrepair_index')->whereYear('DATE_TIME_REQUEST',$year_ad)->whereMonth('DATE_TIME_REQUEST','02')->count();
        $arr[3] =  DB::table('informrepair_index')->whereYear('DATE_TIME_REQUEST',$year_ad)->whereMonth('DATE_TIME_REQUEST','03')->count();
        $arr[4] =  DB::table('informrepair_index')->whereYear('DATE_TIME_REQUEST',$year_ad)->whereMonth('DATE_TIME_REQUEST','04')->count();
        $arr[5] =  DB::table('informrepair_index')->whereYear('DATE_TIME_REQUEST',$year_ad)->whereMonth('DATE_TIME_REQUEST','05')->count();
        $arr[6] =  DB::table('informrepair_index')->whereYear('DATE_TIME_REQUEST',$year_ad)->whereMonth('DATE_TIME_REQUEST','06')->count();
        $arr[7] =  DB::table('informrepair_index')->whereYear('DATE_TIME_REQUEST',$year_ad)->whereMonth('DATE_TIME_REQUEST','07')->count();
        $arr[8] =  DB::table('informrepair_index')->whereYear('DATE_TIME_REQUEST',$year_ad)->whereMonth('DATE_TIME_REQUEST','08')->count();
        $arr[9] =  DB::table('informrepair_index')->whereYear('DATE_TIME_REQUEST',$year_ad)->whereMonth('DATE_TIME_REQUEST','09')->count();
        return $arr;
    }

    public function countInformrepair_success_M_ByYear($year_ad)
    {
        $arr = array();
        $arr[10] =  DB::table('informrepair_index')->where(function ($q)
        {
            $q->where('REPAIR_STATUS','SUCCESS')
            ->orwhere('REPAIR_STATUS','OUTSIDE');
        })->whereYear('DATE_TIME_REQUEST',$year_ad-1)->whereMonth('DATE_TIME_REQUEST','10')->count();
        $arr[11] =  DB::table('informrepair_index')->where(function ($q)
        {
            $q->where('REPAIR_STATUS','SUCCESS')
            ->orwhere('REPAIR_STATUS','OUTSIDE');
        })->whereYear('DATE_TIME_REQUEST',$year_ad-1)->whereMonth('DATE_TIME_REQUEST','11')->count();
        $arr[12] =  DB::table('informrepair_index')->where(function ($q)
        {
            $q->where('REPAIR_STATUS','SUCCESS')
            ->orwhere('REPAIR_STATUS','OUTSIDE');
        })->whereYear('DATE_TIME_REQUEST',$year_ad-1)->whereMonth('DATE_TIME_REQUEST','12')->count();
        $arr[1] =  DB::table('informrepair_index')->where(function ($q)
        {
            $q->where('REPAIR_STATUS','SUCCESS')
            ->orwhere('REPAIR_STATUS','OUTSIDE');
        })->whereYear('DATE_TIME_REQUEST',$year_ad)->whereMonth('DATE_TIME_REQUEST','01')->count();
        $arr[2] =  DB::table('informrepair_index')->where(function ($q)
        {
            $q->where('REPAIR_STATUS','SUCCESS')
            ->orwhere('REPAIR_STATUS','OUTSIDE');
        })->whereYear('DATE_TIME_REQUEST',$year_ad)->whereMonth('DATE_TIME_REQUEST','02')->count();
        $arr[3] =  DB::table('informrepair_index')->where(function ($q)
        {
            $q->where('REPAIR_STATUS','SUCCESS')
            ->orwhere('REPAIR_STATUS','OUTSIDE');
        })->whereYear('DATE_TIME_REQUEST',$year_ad)->whereMonth('DATE_TIME_REQUEST','03')->count();
        $arr[4] =  DB::table('informrepair_index')->where(function ($q)
        {
            $q->where('REPAIR_STATUS','SUCCESS')
            ->orwhere('REPAIR_STATUS','OUTSIDE');
        })->whereYear('DATE_TIME_REQUEST',$year_ad)->whereMonth('DATE_TIME_REQUEST','04')->count();
        $arr[5] =  DB::table('informrepair_index')->where(function ($q)
        {
            $q->where('REPAIR_STATUS','SUCCESS')
            ->orwhere('REPAIR_STATUS','OUTSIDE');
        })->whereYear('DATE_TIME_REQUEST',$year_ad)->whereMonth('DATE_TIME_REQUEST','05')->count();
        $arr[6] =  DB::table('informrepair_index')->where(function ($q)
        {
            $q->where('REPAIR_STATUS','SUCCESS')
            ->orwhere('REPAIR_STATUS','OUTSIDE');
        })->whereYear('DATE_TIME_REQUEST',$year_ad)->whereMonth('DATE_TIME_REQUEST','06')->count();
        $arr[7] =  DB::table('informrepair_index')->where(function ($q)
        {
            $q->where('REPAIR_STATUS','SUCCESS')
            ->orwhere('REPAIR_STATUS','OUTSIDE');
        })->whereYear('DATE_TIME_REQUEST',$year_ad)->whereMonth('DATE_TIME_REQUEST','07')->count();
        $arr[8] =  DB::table('informrepair_index')->where(function ($q)
        {
            $q->where('REPAIR_STATUS','SUCCESS')
            ->orwhere('REPAIR_STATUS','OUTSIDE');
        })->whereYear('DATE_TIME_REQUEST',$year_ad)->whereMonth('DATE_TIME_REQUEST','08')->count();
        $arr[9] =  DB::table('informrepair_index')->where(function ($q)
        {
            $q->where('REPAIR_STATUS','SUCCESS')
            ->orwhere('REPAIR_STATUS','OUTSIDE');
        })->whereYear('DATE_TIME_REQUEST',$year_ad)->whereMonth('DATE_TIME_REQUEST','09')->count();
        return $arr;
    }
    public function countInformrepair_fanciness_score_ByYear($year_ad)
    {
        $arr[1] = DB::table('informrepair_index')->where('FANCINESS_SCORE',1)->whereBetween('DATE_TIME_REQUEST',[$year_ad-1 . '-10-01 00:00:00', $year_ad . '-09-30 23:59:59'])->count();
        $arr[2] = DB::table('informrepair_index')->where('FANCINESS_SCORE',2)->whereBetween('DATE_TIME_REQUEST',[$year_ad-1 . '-10-01 00:00:00', $year_ad . '-09-30 23:59:59'])->count();
        $arr[3] = DB::table('informrepair_index')->where('FANCINESS_SCORE',3)->whereBetween('DATE_TIME_REQUEST',[$year_ad-1 . '-10-01 00:00:00', $year_ad . '-09-30 23:59:59'])->count();
        $arr[4] = DB::table('informrepair_index')->where('FANCINESS_SCORE',4)->whereBetween('DATE_TIME_REQUEST',[$year_ad-1 . '-10-01 00:00:00', $year_ad . '-09-30 23:59:59'])->count();
        $arr[5] = DB::table('informrepair_index')->where('FANCINESS_SCORE',5)->whereBetween('DATE_TIME_REQUEST',[$year_ad-1 . '-10-01 00:00:00', $year_ad . '-09-30 23:59:59'])->count();
        return $arr;
    }

    public function getInformrepair_Bybudgetyear_status($year_ad , $status = 'all')
    {
        $q = DB::table('informrepair_index')->select('REPAIR_ID', 'REPAIR_STATUS', 'PRIORITY_ID', 'FANCINESS_SCORE',
            'DATE_TIME_REQUEST', 'REPAIR_NAME', 'SYMPTOM', 'USRE_REQUEST_NAME', 'HR_DEPARTMENT_SUB_SUB_NAME', 'BUILD_NAME',
            'TECH_REPAIR_NAME', 'BUILD_NAME', 'informrepair_index.ID')
            ->leftjoin('hrd_person', 'informrepair_index.USER_REQUEST_ID', '=', 'hrd_person.ID')
            ->leftjoin('hrd_department_sub_sub', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID', '=',
            'hrd_person.HR_DEPARTMENT_SUB_SUB_ID')
            ->leftjoin('asset_building', 'informrepair_index.LOCATION_SEE_ID', '=', 'asset_building.ID');
        if ($status != 'all') {
            $q->where('REPAIR_STATUS', '=', $status);
        }
        return $q->WhereBetween('informrepair_index.DATE_TIME_REQUEST', [($year_ad - 1) . '-10-1 00:00:00', $year_ad . '-09-30 23:59:59'])
            ->orderBy('PRIORITY_ID', 'desc')->get();
    }

    public function countWorkofperson($year_ad)
    {
        //นับข้อมูลจาก table infor....._index
         $result1 = DB::table('informrepair_index')->select(DB::raw("TECH_REPAIR_ID as person_id ,count(TECH_REPAIR_ID) as count"))
         ->where('REPAIR_STATUS','<>','REQUEST')
         ->whereBetween('DATE_TIME_REQUEST',[$year_ad-1 . '-10-01 00:00:00', $year_ad . '-09-30 23:59:59'])
         ->groupBy('TECH_REPAIR_ID')->get();
        //นับข้อมูลจาก table infor....._index_tech
        $result2 = DB::table('informrepair_index_tech')->select(DB::raw("informrepair_index_tech.HR_PERSON_ID as person_id ,count(informrepair_index_tech.HR_PERSON_ID) as count"))
        ->leftJoin('informrepair_index','informrepair_index.ID','informrepair_index_tech.REPAIR_INDEX_ID')
        ->where(function ($q)
        {        
            $q->where('informrepair_index_tech.HR_PERSON_ID','<>','')
            ->orwhere('informrepair_index_tech.HR_PERSON_ID','<>',Null);
        })
        ->whereBetween('informrepair_index.DATE_TIME_REQUEST',[$year_ad-1 . '-10-01 00:00:00', $year_ad . '-09-30 23:59:59'])
        ->groupBy('informrepair_index_tech.HR_PERSON_ID')->get();
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
         return$person_id_All;
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
    // แผนซ่อมบำรุง
    public function countInforrepairPlanBybetween($start_date , $end_date)
    {
        return DB::table('informrepair_plan')
        // ->where('REPAIR_RESULT',Null) // ตรวจสอบจาก ข้อมูลที่ยังไม่มีการสรุปผลลัพธ์
        ->whereBetween('REPAIR_PLAN_DATE',[$start_date, $end_date])->count();
    }
    public function countInformrepairPlan_M_ByYear($year_ad)
    {
        $arr = array();
        $arr[10] =  DB::table('informrepair_plan')->whereYear('REPAIR_PLAN_DATE',$year_ad-1)->whereMonth('REPAIR_PLAN_DATE','10')->count();
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
    public function countInformrepairPlan_Result_ByYear($year_ad)
    {
        $arr['result_null'] = DB::table('informrepair_plan')->where('REPAIR_RESULT',Null)->whereBetween('REPAIR_PLAN_DATE',[$year_ad-1 . '-10-01 00:00:00', $year_ad . '-09-30 23:59:59'])->count();
        $arr['result_have'] = DB::table('informrepair_plan')->where('REPAIR_RESULT','<>',Null)->whereBetween('REPAIR_PLAN_DATE',[$year_ad-1 . '-10-01 00:00:00', $year_ad . '-09-30 23:59:59'])->count();
        return $arr;
    }
}
