<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RiskReportController extends Controller
{
    public function countRiskRepByStatus($year,$status_arr = array()){
        $result = DB::table('risk_rep')
        ->whereBetween('RISKREP_DATESAVE',[($year-1).'-10-01',$year.'-09-30'])
        ->where(function ($q) use($status_arr)
        {
            foreach ($status_arr as $value) {
                $q->orWhere('RISKREP_STATUS',$value);
            }
        })->count();
        return $result;
    }
    public function countRiskRepByLevel($year,$level_arr = array()){
        $result = DB::table('risk_rep')
        ->whereBetween('RISKREP_DATESAVE',[($year-1).'-10-01',$year.'-09-30'])
        ->where(function ($q) use($level_arr)
        {
            foreach ($level_arr as $value) {
                $q->orWhere('RISKREP_LEVEL',$value);
            }
        })->count();
        return $result;
    }

    public function countRiskAccountDetailByStatus($year,$status_arr = array()){
        return DB::table('risk_account_detail')
        ->whereBetween('created_at',[($year-1).'-10-01',$year.'-09-30'])->count();
    }
    public function countPersonUseRiskReport($year){
        return count(DB::table('risk_rep')
        ->select('RISKREP_USEREFFECT')
        ->whereBetween('RISKREP_DATESAVE',[($year-1).'-10-01',$year.'-09-30'])
        ->groupBy('RISKREP_USEREFFECT')
        ->get());
    }
    public function countRiskRep_M($year,$status_arr = array()){
        $arr[10] = DB::table('risk_rep')
        ->where(function ($q) use($status_arr)
                    {
                        foreach ($status_arr as $value) {
                            $q->orWhere('RISKREP_STATUS',$value);
                        }
                    })->whereMonth('RISKREP_DATESAVE','10')->whereYear('RISKREP_DATESAVE',($year-1))->count();
        $arr[11] = DB::table('risk_rep')
                    ->where(function ($q) use($status_arr)
                    {
                        foreach ($status_arr as $value) {
                            $q->orWhere('RISKREP_STATUS',$value);
                        }
                    })->whereMonth('RISKREP_DATESAVE','11')->whereYear('RISKREP_DATESAVE',($year-1))->count();
        $arr[12] = DB::table('risk_rep')
                    ->where(function ($q) use($status_arr)
                    {
                        foreach ($status_arr as $value) {
                            $q->orWhere('RISKREP_STATUS',$value);
                        }
                    })->whereMonth('RISKREP_DATESAVE','12')->whereYear('RISKREP_DATESAVE',($year-1))->count();
        $arr[1] = DB::table('risk_rep')
                    ->where(function ($q) use($status_arr)
                    {
                        foreach ($status_arr as $value) {
                            $q->orWhere('RISKREP_STATUS',$value);
                        }
                    })->whereMonth('RISKREP_DATESAVE','01')->whereYear('RISKREP_DATESAVE',$year)->count();
        $arr[2] = DB::table('risk_rep')
                    ->where(function ($q) use($status_arr)
                    {
                        foreach ($status_arr as $value) {
                            $q->orWhere('RISKREP_STATUS',$value);
                        }
                    })->whereMonth('RISKREP_DATESAVE','02')->whereYear('RISKREP_DATESAVE',$year)->count();
        $arr[3] = DB::table('risk_rep')
                    ->where(function ($q) use($status_arr)
                    {
                        foreach ($status_arr as $value) {
                            $q->orWhere('RISKREP_STATUS',$value);
                        }
                    })->whereMonth('RISKREP_DATESAVE','03')->whereYear('RISKREP_DATESAVE',$year)->count();
        $arr[4] = DB::table('risk_rep')
                    ->where(function ($q) use($status_arr)
                    {
                        foreach ($status_arr as $value) {
                            $q->orWhere('RISKREP_STATUS',$value);
                        }
                    })->whereMonth('RISKREP_DATESAVE','04')->whereYear('RISKREP_DATESAVE',$year)->count();
        $arr[5] = DB::table('risk_rep')
                    ->where(function ($q) use($status_arr)
                    {
                        foreach ($status_arr as $value) {
                            $q->orWhere('RISKREP_STATUS',$value);
                        }
                    })->whereMonth('RISKREP_DATESAVE','05')->whereYear('RISKREP_DATESAVE',$year)->count();
        $arr[6] = DB::table('risk_rep')
                    ->where(function ($q) use($status_arr)
                    {
                        foreach ($status_arr as $value) {
                            $q->orWhere('RISKREP_STATUS',$value);
                        }
                    })->whereMonth('RISKREP_DATESAVE','06')->whereYear('RISKREP_DATESAVE',$year)->count();
        $arr[7] = DB::table('risk_rep')
                    ->where(function ($q) use($status_arr)
                    {
                        foreach ($status_arr as $value) {
                            $q->orWhere('RISKREP_STATUS',$value);
                        }
                    })->whereMonth('RISKREP_DATESAVE','07')->whereYear('RISKREP_DATESAVE',$year)->count();
        $arr[8] = DB::table('risk_rep')
                    ->where(function ($q) use($status_arr)
                    {
                        foreach ($status_arr as $value) {
                            $q->orWhere('RISKREP_STATUS',$value);
                        }
                    })->whereMonth('RISKREP_DATESAVE','08')->whereYear('RISKREP_DATESAVE',$year)->count();
        $arr[9] = DB::table('risk_rep')
                    ->where(function ($q) use($status_arr)
                    {
                        foreach ($status_arr as $value) {
                            $q->orWhere('RISKREP_STATUS',$value);
                        }
                    })->whereMonth('RISKREP_DATESAVE','09')->whereYear('RISKREP_DATESAVE',$year)->count();
        return $arr;
    }
    public function countLevelRisk($year){
        $list_leval = DB::table('risk_rep_level')->get();
        $level_in_list = DB::table('risk_rep')
        ->select(DB::raw('RISKREP_LEVEL , count(RISKREP_ID) as risk_level_amount'))
        ->whereBetween('RISKREP_DATESAVE',[($year-1).'-10-01',$year.'-09-30'])
        ->groupBy('RISKREP_LEVEL')
        ->get();
        // dd($list_leval);
        $result = array();
        foreach($list_leval as $rlist){
            $result[$rlist->RISK_REP_LEVEL_ID]['RISK_REP_LEVEL_ID']     = $rlist->RISK_REP_LEVEL_ID;
            $result[$rlist->RISK_REP_LEVEL_ID]['RISK_REP_LEVEL_CODE']   = $rlist->RISK_REP_LEVEL_CODE;
            $result[$rlist->RISK_REP_LEVEL_ID]['RISK_REP_LEVEL_NAME']   = $rlist->RISK_REP_LEVEL_NAME;
            $result[$rlist->RISK_REP_LEVEL_ID]['RISK_REP_LEVEL_DETAIL'] = $rlist->RISK_REP_LEVEL_DETAIL;
            $result[$rlist->RISK_REP_LEVEL_ID]['risk_level_amount']     = 0;
        }
        
        foreach($list_leval as $rlist){
            foreach($level_in_list as $key => $row){
                if($rlist->RISK_REP_LEVEL_NAME === $row->RISKREP_LEVEL){
                    $result[$rlist->RISK_REP_LEVEL_ID]['risk_level_amount']     = $row->risk_level_amount;
                    unset($level_in_list[$key]);
                    break;
                }
            }
        }
        return $result;
    }   
}
