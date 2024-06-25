<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SafeReportController extends Controller
{
    public function getCountEventSafeByyear($year_ad)
    {
        $q1 = DB::table('safe_event')->get();
        $arr = array();
        foreach($q1 as $row){
            $id = $row->SAFE_EVENT_ID;
            $arr[$id]['id'] = $id;
            $arr[$id]['name'] = $row->SAFE_EVENT_NAME;
            $arr[$id]['count'] = DB::table('safe_service')->where('SAFE_EVENT_ID',$id)->whereBetween('SAFE_DATE',[($year_ad-1).'-10-01',$year_ad.'-09-30'])->count();
        }
        return $arr; 
    }
    public function getCountTypeSafeByyear($year_ad)
    {
        $q1 = DB::table('safe_type')->get();
        $arr = array();
        foreach($q1 as $row){
            $id =  $row->SAFE_TYPE_ID;
            $arr[$id]['id'] = $id;
            $arr[$id]['name'] = $row->SAFE_TYPE_NAME;
            $arr[$id]['count'] = DB::table('safe_service')->where('SAFE_TYPE_ID',$id)->whereBetween('SAFE_DATE',[($year_ad-1).'-10-01',$year_ad.'-09-30'])->count();
        }
        return $arr;
    }
    public function getCountLocationSafeByyear($year_ad)
    {
        $q1 = DB::table('safe_location')->get();
        $arr = array();
        foreach($q1 as $row){
            $id =  $row->SAFE_LOCATION_ID;
            $arr[$id]['id'] = $id;
            $arr[$id]['name'] = $row->SAFE_LOCATION_NAME;
            $arr[$id]['count'] = DB::table('safe_service')->where('SAFE_TYPE_ID',$id)->whereBetween('SAFE_DATE',[($year_ad-1).'-10-01',$year_ad.'-09-30'])->count();
        }
        return $arr;
    }
    public function getCountAllSafeByyear_M($year_ad)
    {
        $arr = array();
        $arr[10] = DB::table('safe_service')->whereYear('SAFE_DATE',$year_ad-1)->whereMonth('SAFE_DATE','10')->count();
        $arr[11] = DB::table('safe_service')->whereYear('SAFE_DATE',$year_ad-1)->whereMonth('SAFE_DATE','11')->count();
        $arr[12] = DB::table('safe_service')->whereYear('SAFE_DATE',$year_ad-1)->whereMonth('SAFE_DATE','12')->count();
        $arr[1] = DB::table('safe_service')->whereYear('SAFE_DATE',$year_ad)->whereMonth('SAFE_DATE','01')->count();
        $arr[2] = DB::table('safe_service')->whereYear('SAFE_DATE',$year_ad)->whereMonth('SAFE_DATE','02')->count();
        $arr[3] = DB::table('safe_service')->whereYear('SAFE_DATE',$year_ad)->whereMonth('SAFE_DATE','03')->count();
        $arr[4] = DB::table('safe_service')->whereYear('SAFE_DATE',$year_ad)->whereMonth('SAFE_DATE','04')->count();
        $arr[5] = DB::table('safe_service')->whereYear('SAFE_DATE',$year_ad)->whereMonth('SAFE_DATE','05')->count();
        $arr[6] = DB::table('safe_service')->whereYear('SAFE_DATE',$year_ad)->whereMonth('SAFE_DATE','06')->count();
        $arr[7] = DB::table('safe_service')->whereYear('SAFE_DATE',$year_ad)->whereMonth('SAFE_DATE','07')->count();
        $arr[8] = DB::table('safe_service')->whereYear('SAFE_DATE',$year_ad)->whereMonth('SAFE_DATE','08')->count();
        $arr[9] = DB::table('safe_service')->whereYear('SAFE_DATE',$year_ad)->whereMonth('SAFE_DATE','09')->count();
        return $arr;
    }
}
