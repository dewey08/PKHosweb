<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class AssetReportController extends Controller
{
    public function sum_and_count_building($year = 'all')
    {
        $q = DB::table('asset_building')->select(DB::raw('COUNT(*) as amount , sum(BUILD_NGUD_MONEY) as total_price'))->where('STATUS_ID', 1);
        if($year != 'all'){
            $q->whereBetween('BUILD_FINISH', [($year - 1) . '-10-01', $year . '-09-30']);
        }
        return $q->first();
    }

    public function sum_and_count_durable($year = 'all')
    {
        $q = DB::table('asset_article')->select(DB::raw('COUNT(*) as amount , sum(PRICE_PER_UNIT) as total_price'))->where('STATUS_ID', 1);
        if ($year != 'all') {
            $q->whereBetween('RECEIVE_DATE', [($year - 1) . '-10-01', $year . '-09-30']);
        }
        return $q->first();
    }

    public function sum_building_and_durable($year_now, $num_year = 5)
    {
        $arr  = array();
        $year = $year_now - $num_year + 1;
        for ($i = 0; $i < $num_year; $i++) {
            $arr[$i]['year']           = $year + 543;
            $arr[$i]['total_building'] = DB::table('asset_building')->where('STATUS_ID', 1)->whereBetween('BUILD_FINISH', [($year - 1) . '-10-01', $year . '-09-30'])->sum('BUILD_NGUD_MONEY');
            $arr[$i]['total_durable']  = DB::table('asset_article')->where('STATUS_ID', 1)->whereBetween('RECEIVE_DATE', [($year - 1) . '-10-01', $year . '-09-30'])->sum('PRICE_PER_UNIT');
            $year++;
        }
        return $arr;
    }

    public function sum_price_suppliesbudget_by_durable($year = 'all')
    {
        $supplies_budget = DB::table('supplies_budget')->where('ACTIVE',true)->get();
        $arr = array();
        foreach ($supplies_budget as $value) {
            $arr[$value->BUDGET_ID]['budget_id'] = $value->BUDGET_ID;
            $arr[$value->BUDGET_ID]['budget_name'] = $value->BUDGET_NAME;
            $q =  DB::table('asset_article')->where('STATUS_ID',1)->where('BUDGET_ID', $value->BUDGET_ID);
            if($year != 'all'){
                $q->whereBetween('RECEIVE_DATE', [($year - 1) . '-10-01', $year . '-09-30']);
            }
            $arr[$value->BUDGET_ID]['total_price'] = $q->sum('PRICE_PER_UNIT');
        }
        return $arr;
    }
    
    public function sum_durable_by_supplies_budget($year_now , $num_year = 5)
    {
        $arr  = array();
        $year = $year_now - $num_year + 1;
        $supplies_budget = DB::table('supplies_budget')->where('ACTIVE',true)->get();
        $arr['title'][0] = "ปีงบประมาณ";
        $i = 1 ;
        foreach($supplies_budget as $value){
                $arr['title'][$i++] = $value->BUDGET_NAME;
            }
        for ($i = 0; $i < $num_year; $i++) {
            $arr['content'][$i]['year']           = $year + 543;
            foreach($supplies_budget as $value){
                $arr['content'][$i][$value->BUDGET_ID] = DB::table('asset_article')->where('STATUS_ID', 1)->where('BUDGET_ID', $value->BUDGET_ID)->whereBetween('RECEIVE_DATE', [($year - 1) . '-10-01', $year . '-09-30'])->sum('PRICE_PER_UNIT');
            }
            $year++;
        }
        return $arr;
    }
    public function sum_building_by_supplies_budget($year_now , $num_year = 5)
    {
        $arr  = array();
        $year = $year_now - $num_year + 1;
        $supplies_budget = DB::table('supplies_budget')->where('ACTIVE',true)->get();
        $arr['title'][0] = "ปีงบประมาณ";
        $i = 1 ;
        foreach($supplies_budget as $value){
                $arr['title'][$i++] = $value->BUDGET_NAME;
            }
            for ($i = 0; $i < $num_year; $i++) {
            $arr['content'][$i]['year']           = $year + 543;
            foreach($supplies_budget as $value){
                $arr['content'][$i][$value->BUDGET_ID] = DB::table('asset_building')->where('STATUS_ID', 1)->where('BUDGET_ID', $value->BUDGET_ID)->whereBetween('BUILD_FINISH', [($year - 1) . '-10-01', $year . '-09-30'])->sum('BUILD_NGUD_MONEY');
            }
            $year++;
        }
        return $arr;
    }
    public function get_duration_by_budget_year($budget_id,$year = all)
    {
        $q = DB::table('asset_article');
        if ($budget_id != 'all') {
            $q->where('asset_article.BUDGET_ID',$budget_id);
        }
        if($year != 'all'){
            $q->whereBetween('asset_article.RECEIVE_DATE',[($year - 1) . '-10-01', $year . '-09-30']);
        }
         return $q->leftJoin('supplies_decline', 'supplies_decline.DECLINE_ID', '=', 'asset_article.DECLINE_ID')
        ->leftJoin('hrd_department_sub_sub', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID', '=', 'asset_article.DEP_ID')
        ->leftJoin('supplies_location', 'supplies_location.LOCATION_ID', '=', 'asset_article.LOCATION_ID')
        ->leftJoin('supplies_location_level', 'supplies_location_level.LOCATION_LEVEL_ID', '=', 'asset_article.LOCATION_LEVEL_ID')
        ->leftJoin('supplies_location_level_room', 'supplies_location_level_room.LEVEL_ROOM_ID', '=', 'asset_article.LEVEL_ROOM_ID')
        ->leftJoin('asset_status', 'asset_status.STATUS_ID', '=', 'asset_article.STATUS_ID')
        ->leftJoin('supplies_budget', 'supplies_budget.BUDGET_ID', '=', 'asset_article.BUDGET_ID')
        ->orderBy('ARTICLE_ID', 'desc')
        ->get();

    }
    
    public function sum_duration_by_budget_M($budget_id,$year = all)
    {

        $arr =array();
        $i = 10;
        for ($iq=0; $iq < 12 ; $iq++) { 
            if($i == 13){$i = 1;}
            $q = DB::table('asset_article');
            if ($budget_id != 'all') {
                $q->where('BUDGET_ID',$budget_id);
            }
            if($year != 'all'){
                $q->whereBetween('RECEIVE_DATE',[($year - 1) . '-10-01', $year . '-09-30']);
            }
            $arr[$i] = $q->whereMonth('RECEIVE_DATE',$i)->sum('PRICE_PER_UNIT');
            $i++;
        }
        return $arr;
    }

    public function sum_buiding_by_budget_M($budget_id,$year = all)
    {

        $arr =array();
        $i = 10;
        for ($iq=0; $iq < 12 ; $iq++) { 
            if($i == 13){$i = 1;}
            $q = DB::table('asset_building');
            if ($budget_id != 'all') {
                $q->where('BUDGET_ID',$budget_id);
            }
            if($year != 'all'){
                $q->whereBetween('BUILD_FINISH',[($year - 1) . '-10-01', $year . '-09-30']);
            }
            $arr[$i] = $q->whereMonth('BUILD_FINISH',$i)->sum('BUILD_NGUD_MONEY');
            $i++;
        }
        return $arr;
    }
    public function count_duration_by_budget_year($budget_id,$year)
    {
        $q = DB::table('asset_article')->select(DB::raw('COUNT(*) as amount , sum(asset_article.PRICE_PER_UNIT) as total_price'));
        if ($budget_id != 'all') {
            $q->where('asset_article.BUDGET_ID',$budget_id);
        }
        if($year != 'all'){
            $q->whereBetween('RECEIVE_DATE',[($year - 1) . '-10-01', $year . '-09-30']);
        }
        return $q->leftJoin('supplies_decline', 'supplies_decline.DECLINE_ID', '=', 'asset_article.DECLINE_ID')
        ->leftJoin('hrd_department_sub_sub', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID', '=', 'asset_article.DEP_ID')
        ->leftJoin('supplies_location', 'supplies_location.LOCATION_ID', '=', 'asset_article.LOCATION_ID')
        ->leftJoin('supplies_location_level', 'supplies_location_level.LOCATION_LEVEL_ID', '=', 'asset_article.LOCATION_LEVEL_ID')
        ->leftJoin('supplies_location_level_room', 'supplies_location_level_room.LEVEL_ROOM_ID', '=', 'asset_article.LEVEL_ROOM_ID')
        ->leftJoin('asset_status', 'asset_status.STATUS_ID', '=', 'asset_article.STATUS_ID')
        ->leftJoin('supplies_budget', 'supplies_budget.BUDGET_ID', '=', 'asset_article.BUDGET_ID')
        ->first();
    }
    
    public function get_buiding_by_budget_year($budget_id,$year)
    {
        $q = DB::table('asset_building');
        if ($budget_id != 'all') {
            $q->where('asset_building.BUDGET_ID',$budget_id);
        }        
        if($year != 'all'){
            $q->whereBetween('BUILD_FINISH',[($year - 1) . '-10-01', $year . '-09-30']);
        }
        return $q->leftJoin('supplies_budget', 'supplies_budget.BUDGET_ID', '=', 'asset_building.BUDGET_ID')
        ->orderBy('ID', 'desc')
        ->get();
    }
    public function count_buiding_by_budget_year($budget_id,$year)
    {
        $q = DB::table('asset_building')->select(DB::raw('COUNT(*) as amount , sum(asset_building.BUILD_NGUD_MONEY) as total_price'));
        if ($budget_id != 'all') {
            $q->where('asset_building.BUDGET_ID',$budget_id);
        }
        if($year != 'all'){
            $q->whereBetween('BUILD_FINISH',[($year - 1) . '-10-01', $year . '-09-30']);
        }
        return $q->leftJoin('supplies_budget', 'supplies_budget.BUDGET_ID', '=', 'asset_building.BUDGET_ID')->first();
    }

}
