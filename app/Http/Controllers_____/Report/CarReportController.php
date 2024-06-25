<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CarReportController extends Controller
{

    public function countCarReserveBystatus_year($status ,$year_ad)
    {
        return DB::table('vehicle_car_reserve')->where('STATUS',$status)
        ->whereBetween('RESERVE_BEGIN_DATE',[($year_ad - 1) . '-10-01', $year_ad . '-09-30'])
        ->count();
    }
    public function countCarReferBytype_year($type , $year_ad)
    {
        return DB::table('vehicle_car_refer')
        ->whereBetween('OUT_DATE',[($year_ad - 1) . '-10-01', $year_ad . '-09-30'])
        ->where('REFER_TYPE_ID',$type)
        ->count();
    }
    public function countCarReserveBystatus_year_M($status , $year_ad)
    {
        $arr = array();
        $arr[10] = DB::table('vehicle_car_reserve')->where('STATUS',$status)
        ->whereYear('RESERVE_BEGIN_DATE',$year_ad-1)->whereMonth('RESERVE_BEGIN_DATE','10')->count();
        $arr[11] = DB::table('vehicle_car_reserve')->where('STATUS',$status)
        ->whereYear('RESERVE_BEGIN_DATE',$year_ad-1)->whereMonth('RESERVE_BEGIN_DATE','11')->count();
        $arr[12] = DB::table('vehicle_car_reserve')->where('STATUS',$status)
        ->whereYear('RESERVE_BEGIN_DATE',$year_ad-1)->whereMonth('RESERVE_BEGIN_DATE','12')->count();
        $arr[1] = DB::table('vehicle_car_reserve')->where('STATUS',$status)
        ->whereYear('RESERVE_BEGIN_DATE',$year_ad)->whereMonth('RESERVE_BEGIN_DATE','01')->count();
        $arr[2] = DB::table('vehicle_car_reserve')->where('STATUS',$status)
        ->whereYear('RESERVE_BEGIN_DATE',$year_ad)->whereMonth('RESERVE_BEGIN_DATE','02')->count();
        $arr[3] = DB::table('vehicle_car_reserve')->where('STATUS',$status)
        ->whereYear('RESERVE_BEGIN_DATE',$year_ad)->whereMonth('RESERVE_BEGIN_DATE','03')->count();
        $arr[4] = DB::table('vehicle_car_reserve')->where('STATUS',$status)
        ->whereYear('RESERVE_BEGIN_DATE',$year_ad)->whereMonth('RESERVE_BEGIN_DATE','04')->count();
        $arr[5] = DB::table('vehicle_car_reserve')->where('STATUS',$status)
        ->whereYear('RESERVE_BEGIN_DATE',$year_ad)->whereMonth('RESERVE_BEGIN_DATE','05')->count();
        $arr[6] = DB::table('vehicle_car_reserve')->where('STATUS',$status)
        ->whereYear('RESERVE_BEGIN_DATE',$year_ad)->whereMonth('RESERVE_BEGIN_DATE','06')->count();
        $arr[7] = DB::table('vehicle_car_reserve')->where('STATUS',$status)
        ->whereYear('RESERVE_BEGIN_DATE',$year_ad)->whereMonth('RESERVE_BEGIN_DATE','07')->count();
        $arr[8] = DB::table('vehicle_car_reserve')->where('STATUS',$status)
        ->whereYear('RESERVE_BEGIN_DATE',$year_ad)->whereMonth('RESERVE_BEGIN_DATE','08')->count();
        $arr[9] = DB::table('vehicle_car_reserve')->where('STATUS',$status)
        ->whereYear('RESERVE_BEGIN_DATE',$year_ad)->whereMonth('RESERVE_BEGIN_DATE','09')->count();
        return $arr;
    }
    public function countCarReferBytype_year_M($type , $year_ad)
    {
        $arr = array();
        $arr[10] = DB::table('vehicle_car_refer')->where('REFER_TYPE_ID',$type)
        ->whereYear('OUT_DATE',$year_ad-1)->whereMonth('OUT_DATE','10')->count();
        $arr[11] = DB::table('vehicle_car_refer')->where('REFER_TYPE_ID',$type)
        ->whereYear('OUT_DATE',$year_ad-1)->whereMonth('OUT_DATE','11')->count();
        $arr[12] = DB::table('vehicle_car_refer')->where('REFER_TYPE_ID',$type)
        ->whereYear('OUT_DATE',$year_ad-1)->whereMonth('OUT_DATE','12')->count();
        $arr[1] = DB::table('vehicle_car_refer')->where('REFER_TYPE_ID',$type)
        ->whereYear('OUT_DATE',$year_ad)->whereMonth('OUT_DATE','01')->count();
        $arr[2] = DB::table('vehicle_car_refer')->where('REFER_TYPE_ID',$type)
        ->whereYear('OUT_DATE',$year_ad)->whereMonth('OUT_DATE','02')->count();
        $arr[3] = DB::table('vehicle_car_refer')->where('REFER_TYPE_ID',$type)
        ->whereYear('OUT_DATE',$year_ad)->whereMonth('OUT_DATE','03')->count();
        $arr[4] = DB::table('vehicle_car_refer')->where('REFER_TYPE_ID',$type)
        ->whereYear('OUT_DATE',$year_ad)->whereMonth('OUT_DATE','04')->count();
        $arr[5] = DB::table('vehicle_car_refer')->where('REFER_TYPE_ID',$type)
        ->whereYear('OUT_DATE',$year_ad)->whereMonth('OUT_DATE','05')->count();
        $arr[6] = DB::table('vehicle_car_refer')->where('REFER_TYPE_ID',$type)
        ->whereYear('OUT_DATE',$year_ad)->whereMonth('OUT_DATE','06')->count();
        $arr[7] = DB::table('vehicle_car_refer')->where('REFER_TYPE_ID',$type)
        ->whereYear('OUT_DATE',$year_ad)->whereMonth('OUT_DATE','07')->count();
        $arr[8] = DB::table('vehicle_car_refer')->where('REFER_TYPE_ID',$type)
        ->whereYear('OUT_DATE',$year_ad)->whereMonth('OUT_DATE','08')->count();
        $arr[9] = DB::table('vehicle_car_refer')->where('REFER_TYPE_ID',$type)
        ->whereYear('OUT_DATE',$year_ad)->whereMonth('OUT_DATE','09')->count();
        return $arr;
    }
    public function sumOilConsumptionBystatus_year_M($year_ad)
    {
        $arr = array();
        $arr[10] = DB::table('grecord_index_money')
        ->leftJoin('grecord_index','grecord_index_money.RECORD_ID','grecord_index.ID')
        ->where('grecord_index_money.MONEY_ID',1)
        ->whereYear('DATE_GO',$year_ad-1)->whereMonth('DATE_GO','10')
        ->sum('SUMMONEY');
        $arr[11] = DB::table('grecord_index_money')
        ->leftJoin('grecord_index','grecord_index_money.RECORD_ID','grecord_index.ID')
        ->where('grecord_index_money.MONEY_ID',1)
        ->whereYear('DATE_GO',$year_ad-1)->whereMonth('DATE_GO','11')
        ->sum('SUMMONEY');
        $arr[12] = DB::table('grecord_index_money')
        ->leftJoin('grecord_index','grecord_index_money.RECORD_ID','grecord_index.ID')
        ->where('grecord_index_money.MONEY_ID',1)
        ->whereYear('DATE_GO',$year_ad-1)->whereMonth('DATE_GO','12')
        ->sum('SUMMONEY');
        $arr[1] = DB::table('grecord_index_money')
        ->leftJoin('grecord_index','grecord_index_money.RECORD_ID','grecord_index.ID')
        ->where('grecord_index_money.MONEY_ID',1)
        ->whereYear('DATE_GO',$year_ad)->whereMonth('DATE_GO','01')
        ->sum('SUMMONEY');
        $arr[2] = DB::table('grecord_index_money')
        ->leftJoin('grecord_index','grecord_index_money.RECORD_ID','grecord_index.ID')
        ->where('grecord_index_money.MONEY_ID',1)
        ->whereYear('DATE_GO',$year_ad)->whereMonth('DATE_GO','02')
        ->sum('SUMMONEY');
        $arr[3] = DB::table('grecord_index_money')
        ->leftJoin('grecord_index','grecord_index_money.RECORD_ID','grecord_index.ID')
        ->where('grecord_index_money.MONEY_ID',1)
        ->whereYear('DATE_GO',$year_ad)->whereMonth('DATE_GO','03')
        ->sum('SUMMONEY');
        $arr[4] = DB::table('grecord_index_money')
        ->leftJoin('grecord_index','grecord_index_money.RECORD_ID','grecord_index.ID')
        ->where('grecord_index_money.MONEY_ID',1)
        ->whereYear('DATE_GO',$year_ad)->whereMonth('DATE_GO','04')
        ->sum('SUMMONEY');
        $arr[5] = DB::table('grecord_index_money')
        ->leftJoin('grecord_index','grecord_index_money.RECORD_ID','grecord_index.ID')
        ->where('grecord_index_money.MONEY_ID',1)
        ->whereYear('DATE_GO',$year_ad)->whereMonth('DATE_GO','05')
        ->sum('SUMMONEY');
        $arr[6] = DB::table('grecord_index_money')
        ->leftJoin('grecord_index','grecord_index_money.RECORD_ID','grecord_index.ID')
        ->where('grecord_index_money.MONEY_ID',1)
        ->whereYear('DATE_GO',$year_ad)->whereMonth('DATE_GO','06')
        ->sum('SUMMONEY');
        $arr[7] = DB::table('grecord_index_money')
        ->leftJoin('grecord_index','grecord_index_money.RECORD_ID','grecord_index.ID')
        ->where('grecord_index_money.MONEY_ID',1)
        ->whereYear('DATE_GO',$year_ad)->whereMonth('DATE_GO','07')
        ->sum('SUMMONEY');
        $arr[8] = DB::table('grecord_index_money')
        ->leftJoin('grecord_index','grecord_index_money.RECORD_ID','grecord_index.ID')
        ->where('grecord_index_money.MONEY_ID',1)
        ->whereYear('DATE_GO',$year_ad)->whereMonth('DATE_GO','08')
        ->sum('SUMMONEY');
        $arr[9] = DB::table('grecord_index_money')
        ->leftJoin('grecord_index','grecord_index_money.RECORD_ID','grecord_index.ID')
        ->where('grecord_index_money.MONEY_ID',1)
        ->whereYear('DATE_GO',$year_ad)->whereMonth('DATE_GO','09')
        ->sum('SUMMONEY');
        return $arr;
    }
    public function countReserveUseByyear($year_ad)
    {
        return DB::table('vehicle_car_reserve')->select(DB::raw('vehicle_car_index.CAR_REG,count(vehicle_car_index.CAR_REG) as count'))
        ->leftJoin('vehicle_car_index','vehicle_car_index.CAR_ID','vehicle_car_reserve.CAR_SET_ID')
        ->whereBetween('RESERVE_BEGIN_DATE',[($year_ad - 1) . '-10-01', $year_ad . '-09-30'])
        ->where('vehicle_car_reserve.CAR_SET_ID','!=','')
        ->groupBy('vehicle_car_index.CAR_REG')
        ->orderBy('count','DESC')
        ->get();
    }
    public function countWorkPersonDriverBystatus_year($status,$year_ad)
    {
       return DB::table('vehicle_car_reserve')
        ->select(DB::raw('CAR_DRIVER_SET_ID,count(CAR_DRIVER_SET_ID) as count'))
        ->where('STATUS',$status)
        ->whereBetween('RESERVE_BEGIN_DATE',[($year_ad - 1) . '-10-01', $year_ad . '-09-30'])
        ->groupBy('CAR_DRIVER_SET_ID')
        ->get();
    }
    
    public function getNameByperson_id($person_id)
    {
        $query = DB::table('hrd_person')
        ->leftJoin('hrd_prefix','hrd_prefix.HR_PREFIX_ID','hrd_person.HR_PREFIX_ID')
        ->select('hrd_prefix.HR_PREFIX_NAME','hrd_person.HR_FNAME' , 'hrd_person.HR_LNAME')
        ->where('hrd_person.ID',$person_id)
        ->first();
        $name = 'ไม่พบ:'.$person_id;
        if(isset($query)){
            $name = $query->HR_PREFIX_NAME.$query->HR_FNAME.'  '.$query->HR_LNAME;
        }
        return $name;
    }
    public function countWorkPersonDriverReferByyear($year_ad)
    {
        return DB::table('vehicle_car_refer')
         ->select(DB::raw('DRIVER_ID,count(DRIVER_ID) as count'))
         ->whereBetween('OUT_DATE',[($year_ad - 1) . '-10-01', $year_ad . '-09-30'])
         ->groupBy('DRIVER_ID')
         ->get();
    }
    public function countRequestcarReserveBydepartment_sub_sub($status,$year_ad,$limit)
    {
        return DB::table('vehicle_car_reserve')
        ->select(DB::raw('count(*) as count,HR_DEPARTMENT_SUB_SUB_NAME'))
        ->leftJoin('hrd_person','hrd_person.ID','=','vehicle_car_reserve.RESERVE_PERSON_ID')
        ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->where('STATUS',$status)
        ->limit($limit)
        ->whereBetween('RESERVE_BEGIN_DATE',[($year_ad - 1) . '-10-01', $year_ad . '-09-30'])
        ->groupBy('hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_NAME')
        ->orderBy('count', 'desc')  
        ->get();
    }
}
