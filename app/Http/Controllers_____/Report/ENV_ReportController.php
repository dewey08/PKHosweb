<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ENV_ReportController extends Controller
{
    function count_electricial_check($year_ad){
        return DB::table('env_electrical')->whereBetween('ELECTRICAL_DATE',[($year_ad-1).'-10-01',$year_ad.'-09-30'])->count();
    }
    function count_plumbing_check($year_ad){
        return DB::table('env_plumbing')->whereBetween('PLUMBING_DATE',[($year_ad-1).'-10-01',$year_ad.'-09-30'])->count();
    }
    function count_oxigen_check($year_ad){
        return DB::table('env_oxigen')->whereBetween('OXIGEN_DATE',[($year_ad-1).'-10-01',$year_ad.'-09-30'])->count();
    }
    function count_trash_check($year_ad){
        return DB::table('env_trash')->whereBetween('TRASH_DATE',[($year_ad-1).'-10-01',$year_ad.'-09-30'])->count();
    }
    function count_parameter_check($year_ad){
        return DB::table('env_parameter')->whereBetween('PARAMETER_DATE',[($year_ad-1).'-10-01',$year_ad.'-09-30'])->count();
    }
    function sum_weighttrash_type($year_ad){
        $trash_set = DB::table('env_trash_sub')->select(DB::raw("sum(env_trash_sub.TRASH_SUB_QTY)"))
        ->groupBy('env_trash_sub.TRASH_SUB_IDID')
        ->get();
        return $trash_set;
    }
    public function count_parameter_check_have_day($year_ad)
    {
        return count(DB::table('env_parameter')
        ->select('PARAMETER_DATE')
        ->groupBy('PARAMETER_DATE')
        ->whereBetween('PARAMETER_DATE',[($year_ad-1).'-10-01',$year_ad.'-09-30'])->get()); 
    }
    public function count_trash_record($year_ad,$trash_name)
    {
        return DB::table('env_trash_sub')->leftJoin('env_trash','env_trash.TRASH_ID','env_trash_sub.TRASH_ID')
        ->where('TRASH_SUB_NAME',$trash_name)
        ->whereBetween('TRASH_DATE',[($year_ad-1).'-10-01',$year_ad.'-09-30'])->sum('env_trash_sub.TRASH_SUB_QTY'); 
    }
}
