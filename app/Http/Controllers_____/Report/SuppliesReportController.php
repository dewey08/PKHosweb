<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


use App\Models\Suppliescon;

class SuppliesReportController extends Controller
{
    public function CountSupreqStatus($yearbudget , $status = array())
    {
        $count = 0;
        foreach ($status as $status) {
            $count += DB::table('supplies_request')->where('STATUS',$status)->where('BUDGET_YEAR','=',$yearbudget)->count();
        }
        return $count;
    }

    public function CountSupconStatus($yearbudget , $status = array(''))
    {
        $count = 0;
        foreach ($status as $stat) {
            $count += DB::table('supplies_con')->where('REGIS_STATUS_ID',$stat)->where('CON_YEAR_ID','=',$yearbudget)->count();
        }
        return $count;
    }

    public function CountSupcon_M($year)
    {
        //year รับปี ค.ศ.
            $arr[1] = DB::table('supplies_con')->whereMonth('CHECK_DATE','01')->whereYear('CHECK_DATE',$year)->count();
            $arr[2] = DB::table('supplies_con')->whereMonth('CHECK_DATE','02')->whereYear('CHECK_DATE',$year)->count();
            $arr[3] = DB::table('supplies_con')->whereMonth('CHECK_DATE','03')->whereYear('CHECK_DATE',$year)->count();
            $arr[4] = DB::table('supplies_con')->whereMonth('CHECK_DATE','04')->whereYear('CHECK_DATE',$year)->count();
            $arr[5] = DB::table('supplies_con')->whereMonth('CHECK_DATE','05')->whereYear('CHECK_DATE',$year)->count();
            $arr[6] = DB::table('supplies_con')->whereMonth('CHECK_DATE','06')->whereYear('CHECK_DATE',$year)->count();
            $arr[7] = DB::table('supplies_con')->whereMonth('CHECK_DATE','07')->whereYear('CHECK_DATE',$year)->count();
            $arr[8] = DB::table('supplies_con')->whereMonth('CHECK_DATE','08')->whereYear('CHECK_DATE',$year)->count();
            $arr[9] = DB::table('supplies_con')->whereMonth('CHECK_DATE','09')->whereYear('CHECK_DATE',$year)->count();
            $arr[10] = DB::table('supplies_con')->whereMonth('CHECK_DATE','10')->whereYear('CHECK_DATE',$year-1)->count();
            $arr[11] = DB::table('supplies_con')->whereMonth('CHECK_DATE','11')->whereYear('CHECK_DATE',$year-1)->count();
            $arr[12] = DB::table('supplies_con')->whereMonth('CHECK_DATE','12')->whereYear('CHECK_DATE',$year-1)->count();
        return $arr;
    }
    
    public function CountSupcon_M_budget($year)
    {
        //year รับปี ค.ศ.
            $arr[1] = DB::table('supplies_con')->whereMonth('CHECK_DATE','01')->whereYear('CHECK_DATE',$year)->sum('BUDGET_SUM');
            $arr[2] = DB::table('supplies_con')->whereMonth('CHECK_DATE','02')->whereYear('CHECK_DATE',$year)->sum('BUDGET_SUM');
            $arr[3] = DB::table('supplies_con')->whereMonth('CHECK_DATE','03')->whereYear('CHECK_DATE',$year)->sum('BUDGET_SUM');
            $arr[4] = DB::table('supplies_con')->whereMonth('CHECK_DATE','04')->whereYear('CHECK_DATE',$year)->sum('BUDGET_SUM');
            $arr[5] = DB::table('supplies_con')->whereMonth('CHECK_DATE','05')->whereYear('CHECK_DATE',$year)->sum('BUDGET_SUM');
            $arr[6] = DB::table('supplies_con')->whereMonth('CHECK_DATE','06')->whereYear('CHECK_DATE',$year)->sum('BUDGET_SUM');
            $arr[7] = DB::table('supplies_con')->whereMonth('CHECK_DATE','07')->whereYear('CHECK_DATE',$year)->sum('BUDGET_SUM');
            $arr[8] = DB::table('supplies_con')->whereMonth('CHECK_DATE','08')->whereYear('CHECK_DATE',$year)->sum('BUDGET_SUM');
            $arr[9] = DB::table('supplies_con')->whereMonth('CHECK_DATE','09')->whereYear('CHECK_DATE',$year)->sum('BUDGET_SUM');
            $arr[10] = DB::table('supplies_con')->whereMonth('CHECK_DATE','10')->whereYear('CHECK_DATE',$year-1)->sum('BUDGET_SUM');
            $arr[11] = DB::table('supplies_con')->whereMonth('CHECK_DATE','11')->whereYear('CHECK_DATE',$year-1)->sum('BUDGET_SUM');
            $arr[12] = DB::table('supplies_con')->whereMonth('CHECK_DATE','12')->whereYear('CHECK_DATE',$year-1)->sum('BUDGET_SUM');
        return $arr; 
    }

    public function GetSupcon_Performance($year , $typemaster , $type)
    {
        return DB::table('supplies_con')
            ->Join('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
            ->Join('supplies_request','supplies_con.REQUEST_ID','=','supplies_request.ID')
            ->where('supplies_con.REGIS_STATUS_ID','<>',6)
            ->where('supplies_con.SUP_TYPE_ID',$type)
            ->where('supplies_request.REQUEST_PLAN_TYPE_ID', 1)
            ->where('supplies_type.SUP_TYPE_MASTER_ID',$typemaster)
            ->whereBetween('supplies_con.DATE_REGIS', [($year-1).'-10-01' , $year.'-09-30'])
            ->sum('supplies_con.BUDGET_SUM');
    }
    
    public function GetSupcon_Purchasingplan($year,$typemaster,$type)
    {
        return DB::table('supplies_con')
            ->Join('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
            ->Join('supplies_request','supplies_con.REQUEST_ID','=','supplies_request.ID')
            ->where('supplies_con.REGIS_STATUS_ID','<>',6)
            ->where('supplies_con.SUP_TYPE_ID',$type)
            ->where('supplies_request.REQUEST_PLAN_TYPE_ID', 1)
            ->where('supplies_type.SUP_TYPE_MASTER_ID',$typemaster)
            ->whereBetween('supplies_con.DATE_REGIS', [($year-1).'-10-01' , $year.'-09-30'])
            ->sum('supplies_request.BUDGET_SUM');
    }

    public function GetSupcon_budgetplan($year,$typemaster)
    {
        $type = DB::table('supplies_type')->where('SUP_TYPE_MASTER_ID',$typemaster)->get();
        $arr = array();
        foreach ($type as  $value) {
            $performance = $this->GetSupcon_Performance($year,$typemaster,$value->SUP_TYPE_ID);
            $purchas = $this->GetSupcon_Purchasingplan($year,$typemaster,$value->SUP_TYPE_ID);
            if($purchas != 0){
                $supreq_budgetplanper = number_format($performance/$purchas*100,2) . " %";
            }else{
                $supreq_budgetplanper = "N/A";
            }
            $arr[$value->SUP_TYPE_ID]['suptype_name'] = $value->SUP_TYPE_NAME;
            $arr[$value->SUP_TYPE_ID]['suptype_type_id'] = $value->SUP_TYPE_ID;
            $arr[$value->SUP_TYPE_ID]['supreq_purchas'] = $purchas;
            $arr[$value->SUP_TYPE_ID]['supcon_performance'] = $performance;
            $arr[$value->SUP_TYPE_ID]['supreq_budgetplanper'] = $supreq_budgetplanper;
        }
        return $arr;
    }



    public static function valuepicesup($id_sup,$year)
    {  
        $valuesup =  DB::table('supplies_material_plan_value')
        ->leftjoin('plan_supplies_year','plan_supplies_year.PLAN_SUPPLIES_YEAR_ID','=','supplies_material_plan_value.PLAN_SUPPLIES_ID_YEAR')
        ->where('ID_SUP_TYPE','=',$id_sup)
        ->where('PLAN_SUPPLIES_YEAR','=',$year)
        ->first();   
        if( $valuesup == null){
            $namevalue = 0;
        }else{
            $namevalue = $valuesup->SUP_MATERIAL_VALUE;
        }
     return $namevalue;
    }


    
    public static function valuepicesupuse($id_sup,$year)
    {  
           $budgetf = $year-544;
           $budget = $year-543;
           
        $from =  $budgetf.'-10-01';
        $to = $budget.'-09-30';
        $budgetsum =  Suppliescon::leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
        ->leftJoin('supplies_request','supplies_con.REQUEST_ID','=','supplies_request.ID')
        ->leftJoin('supplies_buy','supplies_con.BUY_ID','=','supplies_buy.BUY_ID')
        ->leftJoin('supplies_budget','supplies_con.BUDGET_ID','=','supplies_budget.BUDGET_ID')
        ->where('supplies_con.SUP_TYPE_ID','=',$id_sup)
        ->where('supplies_con.REGIS_STATUS_ID','!=',6)
        ->WhereBetween('supplies_con.DATE_REGIS',[$from,$to])
        ->sum('supplies_con.BUDGET_SUM');



        if( $budgetsum == null){
            $namevalueuse = 0;
        }else{
            $namevalueuse = $budgetsum;
        }
     return $namevalueuse;
    }





}
