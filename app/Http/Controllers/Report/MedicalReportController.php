<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MedicalReportController extends Controller
{
    function count_medical_request($year_ad,$status = 'all'){
        $query = DB::table('warehouse_request')
        ->where('WAREHOUSE_INVEN_ID',2) ///id 2 คลังยาเวชภัณฆ์ ในการตั้งค่าปัจจุบัน (table supplies_inven)
        ->whereBetween('WAREHOUSE_DATE_WANT',[($year_ad-1).'-10-01',$year_ad.date('-09-30')]);
        if($status !== 'all'){ $query->where('WAREHOUSE_STATUS',$status); }
        return $query->count(); 
    }

    function sum_medical_receive($year_ad){
       $arr[10] = DB::table('warehouse_store_receive_sub')->where('RECEIVE_SUB_TYPE',2)->whereYear('created_at',($year_ad-1))
       ->whereMonth('created_at','10')
       ->sum('RECEIVE_SUB_VALUE');
       $arr[11] = DB::table('warehouse_store_receive_sub')->where('RECEIVE_SUB_TYPE',2)->whereYear('created_at',($year_ad-1))
       ->whereMonth('created_at','11')
       ->sum('RECEIVE_SUB_VALUE');
       $arr[12] = DB::table('warehouse_store_receive_sub')->where('RECEIVE_SUB_TYPE',2)->whereYear('created_at',($year_ad-1))
       ->whereMonth('created_at','12')
       ->sum('RECEIVE_SUB_VALUE');
       $arr[1] = DB::table('warehouse_store_receive_sub')->where('RECEIVE_SUB_TYPE',2)->whereYear('created_at',$year_ad)
       ->whereMonth('created_at','01')
       ->sum('RECEIVE_SUB_VALUE');
       $arr[2] = DB::table('warehouse_store_receive_sub')->where('RECEIVE_SUB_TYPE',2)->whereYear('created_at',$year_ad)
       ->whereMonth('created_at','02')
       ->sum('RECEIVE_SUB_VALUE');
       $arr[3] = DB::table('warehouse_store_receive_sub')->where('RECEIVE_SUB_TYPE',2)->whereYear('created_at',$year_ad)
       ->whereMonth('created_at','03')
       ->sum('RECEIVE_SUB_VALUE');
       $arr[4] = DB::table('warehouse_store_receive_sub')->where('RECEIVE_SUB_TYPE',2)->whereYear('created_at',$year_ad)
       ->whereMonth('created_at','04')
       ->sum('RECEIVE_SUB_VALUE');
       $arr[5] = DB::table('warehouse_store_receive_sub')->where('RECEIVE_SUB_TYPE',2)->whereYear('created_at',$year_ad)
       ->whereMonth('created_at','05')
       ->sum('RECEIVE_SUB_VALUE');
       $arr[6] = DB::table('warehouse_store_receive_sub')->where('RECEIVE_SUB_TYPE',2)->whereYear('created_at',$year_ad)
       ->whereMonth('created_at','06')
       ->sum('RECEIVE_SUB_VALUE');
       $arr[7] = DB::table('warehouse_store_receive_sub')->where('RECEIVE_SUB_TYPE',2)->whereYear('created_at',$year_ad)
       ->whereMonth('created_at','07')
       ->sum('RECEIVE_SUB_VALUE');
       $arr[8] = DB::table('warehouse_store_receive_sub')->where('RECEIVE_SUB_TYPE',2)->whereYear('created_at',$year_ad)
       ->whereMonth('created_at','08')
       ->sum('RECEIVE_SUB_VALUE');
       $arr[9] = DB::table('warehouse_store_receive_sub')->where('RECEIVE_SUB_TYPE',2)->whereYear('created_at',$year_ad)
       ->whereMonth('created_at','09')
       ->sum('RECEIVE_SUB_VALUE');
        return $arr;
    }

    public function sum_medical_export($year_ad)
    {
        $arr[10] = DB::table('warehouse_store_export_sub')->where('EXPORT_SUB_TYPE',2)->whereYear('created_at',($year_ad-1))
        ->whereMonth('created_at','10')
        ->sum('EXPORT_SUB_VALUE');
        $arr[11] = DB::table('warehouse_store_export_sub')->where('EXPORT_SUB_TYPE',2)->whereYear('created_at',($year_ad-1))
        ->whereMonth('created_at','11')
        ->sum('EXPORT_SUB_VALUE');
        $arr[12] = DB::table('warehouse_store_export_sub')->where('EXPORT_SUB_TYPE',2)->whereYear('created_at',($year_ad-1))
        ->whereMonth('created_at','12')
        ->sum('EXPORT_SUB_VALUE');
        $arr[1] = DB::table('warehouse_store_export_sub')->where('EXPORT_SUB_TYPE',2)->whereYear('created_at',$year_ad)
        ->whereMonth('created_at','01')
        ->sum('EXPORT_SUB_VALUE');
        $arr[2] = DB::table('warehouse_store_export_sub')->where('EXPORT_SUB_TYPE',2)->whereYear('created_at',$year_ad)
        ->whereMonth('created_at','02')
        ->sum('EXPORT_SUB_VALUE');
        $arr[3] = DB::table('warehouse_store_export_sub')->where('EXPORT_SUB_TYPE',2)->whereYear('created_at',$year_ad)
        ->whereMonth('created_at','03')
        ->sum('EXPORT_SUB_VALUE');
        $arr[4] = DB::table('warehouse_store_export_sub')->where('EXPORT_SUB_TYPE',2)->whereYear('created_at',$year_ad)
        ->whereMonth('created_at','04')
        ->sum('EXPORT_SUB_VALUE');
        $arr[5] = DB::table('warehouse_store_export_sub')->where('EXPORT_SUB_TYPE',2)->whereYear('created_at',$year_ad)
        ->whereMonth('created_at','05')
        ->sum('EXPORT_SUB_VALUE');
        $arr[6] = DB::table('warehouse_store_export_sub')->where('EXPORT_SUB_TYPE',2)->whereYear('created_at',$year_ad)
        ->whereMonth('created_at','06')
        ->sum('EXPORT_SUB_VALUE');
        $arr[7] = DB::table('warehouse_store_export_sub')->where('EXPORT_SUB_TYPE',2)->whereYear('created_at',$year_ad)
        ->whereMonth('created_at','07')
        ->sum('EXPORT_SUB_VALUE');
        $arr[8] = DB::table('warehouse_store_export_sub')->where('EXPORT_SUB_TYPE',2)->whereYear('created_at',$year_ad)
        ->whereMonth('created_at','08')
        ->sum('EXPORT_SUB_VALUE');
        $arr[9] = DB::table('warehouse_store_export_sub')->where('EXPORT_SUB_TYPE',2)->whereYear('created_at',$year_ad)
        ->whereMonth('created_at','09')
        ->sum('EXPORT_SUB_VALUE');
         return $arr;
    }

    function get_request_medical($year_ad,$status = 'all'){
        
        $q = DB::table('warehouse_request')->where('WAREHOUSE_INVEN_ID',2)
        ->whereBetween('WAREHOUSE_DATE_WANT',[($year_ad-1).'-10-01',$year_ad.'-09-30'])
        ->leftJoin('warehouse_request_status','warehouse_request_status.STATUS_CODE','warehouse_request.WAREHOUSE_STATUS');
        if($status != 'all'){
            $q->where('WAREHOUSE_STATUS',$status);
        }
        return $q->get();
    }
}
