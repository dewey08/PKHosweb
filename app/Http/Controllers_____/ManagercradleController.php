<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Person;
use App\Models\Cradle;



date_default_timezone_set("Asia/Bangkok");

class ManagercradleController extends Controller
{
    public function dashboard()
    {
    
        return view('manager_cradle.dashboard_cradle');
    }

    public function detail()
    {
    
        return view('manager_cradle.cradledetail');
    }
    public function infocradle(Request $request)
    {
        

        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;
        }

        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';
        $status = '';
        $search = '';
        $year_id = $yearbudget;

        $incra = DB::table('cradle_index')->get();
      
        return view('manager_cradle.infocradle',[
            'incras'=>$incra,
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id, 
        ]);
    }
    public function infocradle_add()
    {       
        return view('manager_cradle.infocradle_add');
    }
    public function infocradle_save(Request $request)
    {       
        $CRADLE_DATE = $request->CRADLE_DATE;

        if($CRADLE_DATE != ''){
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $CRADLE_DATE)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0]; 
            
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $CRADLEDATE= $y_st."-".$m_st."-".$d_st;
            }else{
            $CRADLEDATE= null;
        }

        $add = new Cradle(); 
        $add->CRADLE_HR_NAME = $request->CRADLE_HR_NAME;
        $add->CRADLE_DETAIL = $request->CRADLE_DETAIL;
        $add->CRADLE_DATE = $CRADLEDATE;
        $add->CRADLE_TIME_BEGIN = $request->CRADLE_TIME_BEGIN;
        $add->CRADLE_TIME_END = $request->CRADLE_TIME_END;
        $add->CRADLE_STATUS = $request->CRADLE_STATUS;
        $add->CRADLE_TOOL = $request->CRADLE_TOOL;
        $add->CRADLE_STATUS = 'NORMAL';
        $add->save();

        return redirect()->route('mcradle.infocradle'); 
    }


    public function infocradle_edit(Request $request,$idref)
    {
        $id_incra= $request->idref;
        $incra = DB::table('cradle_index')->where('CRADLE_ID','=',$id_incra)->first();

        return view('manager_cradle.infocradle_edit',[
            'incras'=>$incra
        ]);
    }

    public function infocradle_update(Request $request)
    {       
        $id = $request->CRADLE_ID; 
       
        $CRADLE_DATE = $request->CRADLE_DATE;

        if($CRADLE_DATE != ''){
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $CRADLE_DATE)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0]; 
            
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $CRADLEDATE= $y_st."-".$m_st."-".$d_st;
            }else{
            $CRADLEDATE= null;
        }

        $update = Cradle::find($id);
        $update->CRADLE_HR_NAME = $request->CRADLE_HR_NAME;
        $update->CRADLE_DETAIL = $request->CRADLE_DETAIL;
        $update->CRADLE_DATE = $CRADLEDATE;
        $update->CRADLE_TIME_BEGIN = $request->CRADLE_TIME_BEGIN;
        $update->CRADLE_TIME_END = $request->CRADLE_TIME_END;
        $update->CRADLE_STATUS = $request->CRADLE_STATUS;
        $update->CRADLE_TOOL = $request->CRADLE_TOOL;
        $update->CRADLE_STATUS = 'NORMAL';
        $update->save();

        return redirect()->route('mcradle.infocradle'); 
    }

    


}

