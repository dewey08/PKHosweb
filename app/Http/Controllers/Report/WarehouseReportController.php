<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WarehouseReportController extends Controller
{
    public function count_warehouse_by_status($year_ad,$status = 'all')
    {
        $q = DB::table('warehouse_request')->whereBetween('WAREHOUSE_DATE_WANT',[($year_ad-1).'-10-01',$year_ad.'-09-30']);
        if($status != 'all'){
            $q->where('WAREHOUSE_STATUS',$status);
        }
        return $q->count();
    }
    public function get_warehouse_by_status($year_ad,$status = 'all')
    {
        $q = DB::table('warehouse_request')
        ->whereBetween('WAREHOUSE_DATE_WANT',[($year_ad-1).'-10-01',$year_ad.'-09-30'])
        ->leftJoin('warehouse_request_status','warehouse_request_status.STATUS_CODE','warehouse_request.WAREHOUSE_STATUS');
        if($status != 'all'){
            $q->where('WAREHOUSE_STATUS',$status);
        }
        return $q->get();
    }

    public function sum_warehouse_export($store_id)
    {
        return DB::table('warehouse_store_export_sub')->where('STORE_ID',$store_id)->sum('EXPORT_SUB_AMOUNT');
    }
    
    public function sum_warehouse_receive($store_id)
    {
        return DB::table('warehouse_store_receive_sub')->where('STORE_ID',$store_id)->sum('RECEIVE_SUB_AMOUNT');
    }
    
    public function count_warehouse_amount_low_hight()
    {
        $recieve = DB::table('warehouse_store')->get();
        $i = 0;
        $store_has_min = 0 ;
        $store_has_max = 0 ;
        foreach($recieve as $row){
            $amount_receive = $this->sum_warehouse_receive($row->STORE_ID);
            $amount_export = $this->sum_warehouse_export($row->STORE_ID);
           $result[$i] = DB::table('supplies')->select(DB::raw("supplies.SUP_FSN_NUM, supplies.SUP_NAME ,supplies.MIN,supplies.MAX , warehouse_store.STORE_TYPE_NAME , supplies_type.SUP_TYPE_NAME , supplies_unit.SUP_UNIT_NAME ,".((!$amount_receive)?0:$amount_receive)." as sum_recieve ,".((!$amount_export)?0:$amount_export)." as sum_export ,".($amount_receive - $amount_export)." as net_amount"))
        ->leftJoin('warehouse_store','warehouse_store.STORE_CODE','supplies.SUP_FSN_NUM')
        ->leftJoin('supplies_type','supplies_type.SUP_TYPE_ID','supplies.SUP_TYPE_ID')
        ->leftJoin('supplies_unit','supplies_unit.SUP_UNIT_ID','supplies.SUP_UNIT_ID')
        ->where('supplies.SUP_FSN_NUM', $row->STORE_CODE)->first();
            if(empty($result[$i])){
                unset($result[$i]);
            }
            else if($result[$i]->net_amount < $result[$i]->MIN){
                $store_has_min++;
            }else if($result[$i]->net_amount > $result[$i]->MAX){
                $store_has_max++;
            }
            $i++;
        }
        return array('low' => $store_has_min,'hight' => $store_has_max);
    }

    public function get_warehouse_store_low_hight($getlow = true){
        $recieve = DB::table('warehouse_store')->get();
        $i = 0;
        $low = array();
        $hight = array() ;
        foreach($recieve as $row){
            $amount_receive = $this->sum_warehouse_receive($row->STORE_ID);
            $amount_export = $this->sum_warehouse_export($row->STORE_ID);
           $result[$i] = DB::table('supplies')->select(DB::raw("supplies.SUP_FSN_NUM, supplies.SUP_NAME ,supplies.MIN,supplies.MAX , warehouse_store.STORE_TYPE_NAME , supplies_type.SUP_TYPE_NAME , supplies_unit.SUP_UNIT_NAME ,".((!$amount_receive)?0:$amount_receive)." as sum_recieve ,".((!$amount_export)?0:$amount_export)." as sum_export ,".($amount_receive - $amount_export)." as net_amount"))
        ->leftJoin('warehouse_store','warehouse_store.STORE_CODE','supplies.SUP_FSN_NUM')
        ->leftJoin('supplies_type','supplies_type.SUP_TYPE_ID','supplies.SUP_TYPE_ID')
        ->leftJoin('supplies_unit','supplies_unit.SUP_UNIT_ID','supplies.SUP_UNIT_ID')
        ->where('supplies.SUP_FSN_NUM', $row->STORE_CODE)->first();
            if(empty($result[$i])){
                unset($result[$i]);
            }
            else if($result[$i]->net_amount < $result[$i]->MIN){
                $low[] = $result[$i];
            }else if($result[$i]->net_amount > $result[$i]->MAX){
                $hight[] = $result[$i];
            }
            $i++;
        }
        if($getlow){
            return $low;
        }else{
            return $hight;
        }
    }

    public function sum_warehouse_receive_M($year_ad)
    {
        $arr[10] = DB::table('warehouse_request')->whereYear('WAREHOUSE_DATE_WANT',$year_ad-1)->whereMonth('WAREHOUSE_DATE_WANT','10')
        ->leftJoin('warehouse_request_sub','warehouse_request_sub.WAREHOUSE_REQUEST_ID','warehouse_request.WAREHOUSE_ID')->sum('WAREHOUSE_REQUEST_SUB_SUM_PRICE');
        $arr[11] = DB::table('warehouse_request')->whereYear('WAREHOUSE_DATE_WANT',$year_ad-1)->whereMonth('WAREHOUSE_DATE_WANT','11')
        ->leftJoin('warehouse_request_sub','warehouse_request_sub.WAREHOUSE_REQUEST_ID','warehouse_request.WAREHOUSE_ID')->sum('WAREHOUSE_REQUEST_SUB_SUM_PRICE');
        $arr[12] = DB::table('warehouse_request')->whereYear('WAREHOUSE_DATE_WANT',$year_ad-1)->whereMonth('WAREHOUSE_DATE_WANT','12')
        ->leftJoin('warehouse_request_sub','warehouse_request_sub.WAREHOUSE_REQUEST_ID','warehouse_request.WAREHOUSE_ID')->sum('WAREHOUSE_REQUEST_SUB_SUM_PRICE');
        $arr[1] = DB::table('warehouse_request')->whereYear('WAREHOUSE_DATE_WANT',$year_ad)->whereMonth('WAREHOUSE_DATE_WANT','01')
        ->leftJoin('warehouse_request_sub','warehouse_request_sub.WAREHOUSE_REQUEST_ID','warehouse_request.WAREHOUSE_ID')->sum('WAREHOUSE_REQUEST_SUB_SUM_PRICE');
        $arr[2] = DB::table('warehouse_request')->whereYear('WAREHOUSE_DATE_WANT',$year_ad)->whereMonth('WAREHOUSE_DATE_WANT','02')
        ->leftJoin('warehouse_request_sub','warehouse_request_sub.WAREHOUSE_REQUEST_ID','warehouse_request.WAREHOUSE_ID')->sum('WAREHOUSE_REQUEST_SUB_SUM_PRICE');
        $arr[3] = DB::table('warehouse_request')->whereYear('WAREHOUSE_DATE_WANT',$year_ad)->whereMonth('WAREHOUSE_DATE_WANT','03')
        ->leftJoin('warehouse_request_sub','warehouse_request_sub.WAREHOUSE_REQUEST_ID','warehouse_request.WAREHOUSE_ID')->sum('WAREHOUSE_REQUEST_SUB_SUM_PRICE');
        $arr[4] = DB::table('warehouse_request')->whereYear('WAREHOUSE_DATE_WANT',$year_ad)->whereMonth('WAREHOUSE_DATE_WANT','04')
        ->leftJoin('warehouse_request_sub','warehouse_request_sub.WAREHOUSE_REQUEST_ID','warehouse_request.WAREHOUSE_ID')->sum('WAREHOUSE_REQUEST_SUB_SUM_PRICE');
        $arr[5] = DB::table('warehouse_request')->whereYear('WAREHOUSE_DATE_WANT',$year_ad)->whereMonth('WAREHOUSE_DATE_WANT','05')
        ->leftJoin('warehouse_request_sub','warehouse_request_sub.WAREHOUSE_REQUEST_ID','warehouse_request.WAREHOUSE_ID')->sum('WAREHOUSE_REQUEST_SUB_SUM_PRICE');
        $arr[6] = DB::table('warehouse_request')->whereYear('WAREHOUSE_DATE_WANT',$year_ad)->whereMonth('WAREHOUSE_DATE_WANT','06')
        ->leftJoin('warehouse_request_sub','warehouse_request_sub.WAREHOUSE_REQUEST_ID','warehouse_request.WAREHOUSE_ID')->sum('WAREHOUSE_REQUEST_SUB_SUM_PRICE');
        $arr[7] = DB::table('warehouse_request')->whereYear('WAREHOUSE_DATE_WANT',$year_ad)->whereMonth('WAREHOUSE_DATE_WANT','07')
        ->leftJoin('warehouse_request_sub','warehouse_request_sub.WAREHOUSE_REQUEST_ID','warehouse_request.WAREHOUSE_ID')->sum('WAREHOUSE_REQUEST_SUB_SUM_PRICE');
        $arr[8] = DB::table('warehouse_request')->whereYear('WAREHOUSE_DATE_WANT',$year_ad)->whereMonth('WAREHOUSE_DATE_WANT','08')
        ->leftJoin('warehouse_request_sub','warehouse_request_sub.WAREHOUSE_REQUEST_ID','warehouse_request.WAREHOUSE_ID')->sum('WAREHOUSE_REQUEST_SUB_SUM_PRICE');
        $arr[9] = DB::table('warehouse_request')->whereYear('WAREHOUSE_DATE_WANT',$year_ad)->whereMonth('WAREHOUSE_DATE_WANT','09')
        ->leftJoin('warehouse_request_sub','warehouse_request_sub.WAREHOUSE_REQUEST_ID','warehouse_request.WAREHOUSE_ID')->sum('WAREHOUSE_REQUEST_SUB_SUM_PRICE');
        return $arr;
    }
    
    public function sum_warehouse_export_M($year_ad)
    {
        $arr[10] = DB::table('warehouse_request')->where('WAREHOUSE_STATUS','Allow')->whereYear('WAREHOUSE_PAYDAY',$year_ad-1)->whereMonth('WAREHOUSE_PAYDAY','10')
        ->leftJoin('warehouse_request_sub','warehouse_request_sub.WAREHOUSE_REQUEST_ID','warehouse_request.WAREHOUSE_ID')->sum('WAREHOUSE_REQUEST_SUB_SUM_PRICE');
        $arr[11] = DB::table('warehouse_request')->where('warehouse_status','Allow')->whereYear('WAREHOUSE_PAYDAY',$year_ad-1)->whereMonth('WAREHOUSE_PAYDAY','11')
        ->leftJoin('warehouse_request_sub','warehouse_request_sub.WAREHOUSE_REQUEST_ID','warehouse_request.WAREHOUSE_ID')->sum('WAREHOUSE_REQUEST_SUB_SUM_PRICE');
        $arr[12] = DB::table('warehouse_request')->where('warehouse_status','Allow')->whereYear('WAREHOUSE_PAYDAY',$year_ad-1)->whereMonth('WAREHOUSE_PAYDAY','12')
        ->leftJoin('warehouse_request_sub','warehouse_request_sub.WAREHOUSE_REQUEST_ID','warehouse_request.WAREHOUSE_ID')->sum('WAREHOUSE_REQUEST_SUB_SUM_PRICE');
        $arr[1] = DB::table('warehouse_request')->where('warehouse_status','Allow')->whereYear('WAREHOUSE_PAYDAY',$year_ad)->whereMonth('WAREHOUSE_PAYDAY','01')
        ->leftJoin('warehouse_request_sub','warehouse_request_sub.WAREHOUSE_REQUEST_ID','warehouse_request.WAREHOUSE_ID')->sum('WAREHOUSE_REQUEST_SUB_SUM_PRICE');
        $arr[2] = DB::table('warehouse_request')->where('warehouse_status','Allow')->whereYear('WAREHOUSE_PAYDAY',$year_ad)->whereMonth('WAREHOUSE_PAYDAY','02')
        ->leftJoin('warehouse_request_sub','warehouse_request_sub.WAREHOUSE_REQUEST_ID','warehouse_request.WAREHOUSE_ID')->sum('WAREHOUSE_REQUEST_SUB_SUM_PRICE');
        $arr[3] = DB::table('warehouse_request')->where('warehouse_status','Allow')->whereYear('WAREHOUSE_PAYDAY',$year_ad)->whereMonth('WAREHOUSE_PAYDAY','03')
        ->leftJoin('warehouse_request_sub','warehouse_request_sub.WAREHOUSE_REQUEST_ID','warehouse_request.WAREHOUSE_ID')->sum('WAREHOUSE_REQUEST_SUB_SUM_PRICE');
        $arr[4] = DB::table('warehouse_request')->where('warehouse_status','Allow')->whereYear('WAREHOUSE_PAYDAY',$year_ad)->whereMonth('WAREHOUSE_PAYDAY','04')
        ->leftJoin('warehouse_request_sub','warehouse_request_sub.WAREHOUSE_REQUEST_ID','warehouse_request.WAREHOUSE_ID')->sum('WAREHOUSE_REQUEST_SUB_SUM_PRICE');
        $arr[5] = DB::table('warehouse_request')->where('warehouse_status','Allow')->whereYear('WAREHOUSE_PAYDAY',$year_ad)->whereMonth('WAREHOUSE_PAYDAY','05')
        ->leftJoin('warehouse_request_sub','warehouse_request_sub.WAREHOUSE_REQUEST_ID','warehouse_request.WAREHOUSE_ID')->sum('WAREHOUSE_REQUEST_SUB_SUM_PRICE');
        $arr[6] = DB::table('warehouse_request')->where('warehouse_status','Allow')->whereYear('WAREHOUSE_PAYDAY',$year_ad)->whereMonth('WAREHOUSE_PAYDAY','06')
        ->leftJoin('warehouse_request_sub','warehouse_request_sub.WAREHOUSE_REQUEST_ID','warehouse_request.WAREHOUSE_ID')->sum('WAREHOUSE_REQUEST_SUB_SUM_PRICE');
        $arr[7] = DB::table('warehouse_request')->where('warehouse_status','Allow')->whereYear('WAREHOUSE_PAYDAY',$year_ad)->whereMonth('WAREHOUSE_PAYDAY','07')
        ->leftJoin('warehouse_request_sub','warehouse_request_sub.WAREHOUSE_REQUEST_ID','warehouse_request.WAREHOUSE_ID')->sum('WAREHOUSE_REQUEST_SUB_SUM_PRICE');
        $arr[8] = DB::table('warehouse_request')->where('warehouse_status','Allow')->whereYear('WAREHOUSE_PAYDAY',$year_ad)->whereMonth('WAREHOUSE_PAYDAY','08')
        ->leftJoin('warehouse_request_sub','warehouse_request_sub.WAREHOUSE_REQUEST_ID','warehouse_request.WAREHOUSE_ID')->sum('WAREHOUSE_REQUEST_SUB_SUM_PRICE');
        $arr[9] = DB::table('warehouse_request')->where('warehouse_status','Allow')->whereYear('WAREHOUSE_PAYDAY',$year_ad)->whereMonth('WAREHOUSE_PAYDAY','09')
        ->leftJoin('warehouse_request_sub','warehouse_request_sub.WAREHOUSE_REQUEST_ID','warehouse_request.WAREHOUSE_ID')->sum('WAREHOUSE_REQUEST_SUB_SUM_PRICE');
        return $arr;
    }
    
}
