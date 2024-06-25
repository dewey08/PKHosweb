<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Person;
use App\Models\Env_list_check;
use App\Models\Env_electrical;
use App\Models\Env_electrical_sub;
use App\Models\Env_list_parameter;
use App\Models\Env_parameter;
use App\Models\Env_parameter_sub;
use App\Models\Env_trash;
use App\Models\Env_trash_sub;
use App\Models\Env_oxigen_set;
use App\Models\Env_oxigen;
use App\Models\Env_oxigen_sub;
use App\Models\Env_trash_set;
use App\Models\Envplumbing;
use App\Models\Envplumbinset;
use App\Imports\Hrdperson;
use App\Models\Envplumbing_sub;
use App\Http\Controllers\Report\ENV_ReportController;
use Session;

date_default_timezone_set("Asia/Bangkok");

class ManagerenvController extends Controller
{
    public function dashboard(Request $request)
    {
        $budgets = getBudgetyearAmount();
        $yearbudget = ($request->STATUS_CODE)?$request->STATUS_CODE:getBudgetyear();
        $year_ad = $yearbudget-543;
        $diff_startyearbudget_to_today = Carbon::parse(($year_ad-1).'-10-01')->diffInDays(Carbon::now());
        $diffdayInyear = ($diff_startyearbudget_to_today>365)?365:$diff_startyearbudget_to_today;
        $ele_daywork = $diffdayInyear * 1;

        $envreport = new ENV_ReportController();
        $ele_count_check = $envreport->count_electricial_check($year_ad);
        $ele_daywork = $diffdayInyear * 1; // * 1 จำนวนการทำงานต่อวัน
        $ele_perworkyear = ($ele_daywork)?$ele_count_check/$ele_daywork*100:0; 

        $plum_count_check = $envreport->count_plumbing_check($year_ad);
        $plum_daywork = $diffdayInyear * 1; // * 1 จำนวนการทำงานต่อวัน
        $plum_perworkyear = ($plum_daywork)?$plum_count_check/$plum_daywork*100:0; 
        
        $oxi_count_check = $envreport->count_oxigen_check($year_ad);
        $oxi_daywork = $diffdayInyear * 1; // * 1 จำนวนการทำงานต่อวัน
        $oxi_perworkyear = ($oxi_daywork)?$oxi_count_check/$oxi_daywork*100:0; 

        // $param_count_check = $envreport->count_parameter_check($year_ad);  //จำนวนครั้งที่เช็ค
        //ทำงาน 1 วัน กี่รอบก็ถือว่าทำงาน 1 ครั้ง / ช่วงวันของปีงบประมาณ 1 ตุลา - ปัจจุบัน
        $param_haveworkinday = $envreport->count_parameter_check_have_day($year_ad);
        $param_perworkyear = ($diffdayInyear)?$param_haveworkinday/$diffdayInyear*100:0; 

        $trash_gernaral = $envreport->count_trash_record($year_ad,'ขยะทั่วไป');
        $trash_recycle = $envreport->count_trash_record($year_ad,'ขยะรีไซเคิล');
        $trash_organic = $envreport->count_trash_record($year_ad,'ขยะอินทรีย์');
        $trash_hazardous = $envreport->count_trash_record($year_ad,'ขยะอันตราย');
        $trash_infected = $envreport->count_trash_record($year_ad,'ขยะติดเชื้อ');

        $trash_count_check = $envreport->count_trash_check($year_ad);
        $trash_sumweight_type = $envreport->sum_weighttrash_type($year_ad);
        
        return view('manager_env.dashboard_evn',compact('budgets','yearbudget','ele_count_check','ele_perworkyear','ele_count_check','ele_perworkyear'
        ,'plum_count_check','plum_perworkyear','oxi_count_check','oxi_perworkyear','param_haveworkinday','param_perworkyear','trash_gernaral','trash_recycle','trash_organic','trash_hazardous','trash_infected'));
    }
    public function dashboard_search(Request $request)
    {

        $budgets = getBudgetyearAmount();
        $yearbudget = ($request->STATUS_CODE)?$request->STATUS_CODE:getBudgetyear();
        $year_ad = $yearbudget-543;
        $diff_startyearbudget_to_today = Carbon::parse(($year_ad-1).'-10-01')->diffInDays(Carbon::now());
        $diffdayInyear = ($diff_startyearbudget_to_today>365)?365:$diff_startyearbudget_to_today;
        $ele_daywork = $diffdayInyear * 1;

        $envreport = new ENV_ReportController();
        $ele_count_check = $envreport->count_electricial_check($year_ad);
        $ele_daywork = $diffdayInyear * 1; // * 1 จำนวนการทำงานต่อวัน
        $ele_perworkyear = ($ele_daywork)?$ele_count_check/$ele_daywork*100:0; 

        $plum_count_check = $envreport->count_plumbing_check($year_ad);
        $plum_daywork = $diffdayInyear * 1; // * 1 จำนวนการทำงานต่อวัน
        $plum_perworkyear = ($plum_daywork)?$plum_count_check/$plum_daywork*100:0; 
        
        $oxi_count_check = $envreport->count_oxigen_check($year_ad);
        $oxi_daywork = $diffdayInyear * 1; // * 1 จำนวนการทำงานต่อวัน
        $oxi_perworkyear = ($oxi_daywork)?$oxi_count_check/$oxi_daywork*100:0; 

        // $param_count_check = $envreport->count_parameter_check($year_ad);  //จำนวนครั้งที่เช็ค
        //ทำงาน 1 วัน กี่รอบก็ถือว่าทำงาน 1 ครั้ง / ช่วงวันของปีงบประมาณ 1 ตุลา - ปัจจุบัน
        $param_haveworkinday = $envreport->count_parameter_check_have_day($year_ad);
        $param_perworkyear = ($diffdayInyear)?$param_haveworkinday/$diffdayInyear*100:0; 

        $trash_gernaral = $envreport->count_trash_record($year_ad,'ขยะทั่วไป');
        $trash_recycle = $envreport->count_trash_record($year_ad,'ขยะรีไซด์เคิล');
        $trash_organic = $envreport->count_trash_record($year_ad,'ขยะอินทรีย์');
        $trash_hazardous = $envreport->count_trash_record($year_ad,'ขยะอันตราย');
        $trash_infected = $envreport->count_trash_record($year_ad,'ขยะติดเชื้อ');

        $trash_count_check = $envreport->count_trash_check($year_ad);
        $trash_sumweight_type = $envreport->sum_weighttrash_type($year_ad);
        
        return view('manager_env.dashboard_evn',compact('budgets','yearbudget','ele_count_check','ele_perworkyear','ele_count_check','ele_perworkyear'
        ,'plum_count_check','plum_perworkyear','oxi_count_check','oxi_perworkyear','param_haveworkinday','param_perworkyear','trash_gernaral','trash_recycle','trash_organic','trash_hazardous','trash_infected'));
    }
  
    public function detail()
    {
    
        return view('manager_env.evndetail');
    }

//******************************ระบบไฟฟ้า********************************************* */

    public function electrical(Request $request)
    {    
        
        if($request->method() === 'POST'){
            $search = $request->get('search');
            $yearbudget = $request->BUDGET_YEAR;   
            $status_check = $request->SEND_STATUS;
            $datebigin = $request->get('DATE_BIGIN');
            $dateend = $request->get('DATE_END');
            session([
                'manager_env.electrical.search' => $search,
                'manager_env.electrical.yearbudget' => $yearbudget,
                'manager_env.electrical.status_check' => $status_check,
                'manager_env.electrical.datebigin' => $datebigin,
                'manager_env.electrical.dateend' => $dateend,
            ]);
        }else if(session::has('manager_env.electrical')){
            $search = session('manager_env.electrical.search');
            $yearbudget = session('manager_env.electrical.yearbudget');
            $status_check = session('manager_env.electrical.status_check');
            $datebigin = session('manager_env.electrical.datebigin');
            $dateend = session('manager_env.electrical.dateend');
        }else{
            $search = '';
            $yearbudget = getBudgetyear();
            $status_check = '';
            $datebigin = date('1/m/Y');
            $dateend = date('d/m/Y',strtotime(date('Y-m-1').' +1month -1day'));
        }
        $date_bigen_c = Carbon::createFromFormat('d/m/Y', $datebigin)->format('Y-m-d');
        $date_arrary=explode("-",$date_bigen_c);

        $y_sub_st = $date_arrary[0];

        if($y_sub_st >= 2500){
            $y = $y_sub_st-543;
        }else{
            $y = $y_sub_st;
        }

        $m = $date_arrary[1];
        $d = $date_arrary[2];
        $displaydate_bigen= $y."-".$m."-".$d;

        $date_end_c = Carbon::createFromFormat('d/m/Y', $dateend)->format('Y-m-d');
        $date_arrary_e=explode("-",$date_end_c);

        $y_sub_e = $date_arrary_e[0];

        if($y_sub_e >= 2500){
            $y_e = $y_sub_e-543;
        }else{
            $y_e = $y_sub_e;
        }
        $m_e = $date_arrary_e[1];
        $d_e = $date_arrary_e[2];
        $displaydate_end= $y_e."-".$m_e."-".$d_e;
        $date = date('Y-m-d');
                 
        $from = date($displaydate_bigen);
        $to = date($displaydate_end);        
         
        $electric = DB::table('env_electrical')->leftjoin('hrd_person','env_electrical.ELECTRICAL_USER','=','hrd_person.ID')               
            ->where(function($q) use ($search){
                $q->where('ELECTRICAL_COMMENT','like','%'.$search.'%');
                $q->orwhere('HR_FNAME','like','%'.$search.'%');
                $q->orwhere('HR_LNAME','like','%'.$search.'%');
            })
            ->WhereBetween('ELECTRICAL_DATE',[$from,$to])
            ->orderBy('ELECTRICAL_ID', 'desc')->get();
        
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
       
        $search = $search;
        $status_check = $status_check;

        $year_id = $yearbudget;
        return view('manager_env.electrical',[
              
            'displaydate_bigen' => $displaydate_bigen,  
            'displaydate_end' => $displaydate_end, 
            'search' => $search, 
            'budgets' =>  $budget,
            'year_id'=>$year_id,   
            'status_check' => $status_check,  
            'electrics'=>$electric, 
        ]);
    }
    public static function elecA($id)
    {
         $elecA =  Env_electrical_sub::where('ELECTRICAL_ID','=',$id)->where('ELECTRICAL_SUB_ID','=','2')->sum('ELECTRICAL_SUB_CHECK_STATUS');                         
         return $elecA;
    }
    public static function elecB($id)
    {
         $elecB =  Env_electrical_sub::where('ELECTRICAL_ID','=',$id)->where('ELECTRICAL_SUB_ID','=','3')->sum('ELECTRICAL_SUB_CHECK_STATUS');                         
         return $elecB;
    }
    public static function elecC($id)
    {
         $elecC =  Env_electrical_sub::where('ELECTRICAL_ID','=',$id)->where('ELECTRICAL_SUB_ID','=','4')->sum('ELECTRICAL_SUB_CHECK_STATUS');                         
         return $elecC;
    }
    public static function elecD($id)
    {
         $elecD =  Env_electrical_sub::where('ELECTRICAL_ID','=',$id)->where('ELECTRICAL_SUB_ID','=','5')->sum('ELECTRICAL_SUB_CHECK_STATUS');                         
         return $elecD;
    }
    public static function elecE($id)
    {
         $elecE =  Env_electrical_sub::where('ELECTRICAL_ID','=',$id)->where('ELECTRICAL_SUB_ID','=','6')->sum('ELECTRICAL_SUB_CHECK_STATUS');                         
         return $elecE;
    }
    public static function elecF($id)
    {
         $elecF =  Env_electrical_sub::where('ELECTRICAL_ID','=',$id)->where('ELECTRICAL_SUB_ID','=','7')->sum('ELECTRICAL_SUB_CHECK_STATUS');                         
         return $elecF;
    }
    public static function elecG($id)
    {
         $elecG =  Env_electrical_sub::where('ELECTRICAL_ID','=',$id)->where('ELECTRICAL_SUB_ID','=','8')->sum('ELECTRICAL_SUB_CHECK_STATUS');                         
         return $elecG;
    }
    public static function elecH($id)
    {
         $elecH =  Env_electrical_sub::where('ELECTRICAL_ID','=',$id)->where('ELECTRICAL_SUB_ID','=','9')->sum('ELECTRICAL_SUB_CHECK_STATUS');                         
         return $elecH;
    }
    public function electrical_search(Request $request)
    {
        $search = $request->get('search');
        $yearbudget = $request->BUDGET_YEAR;   
        $status_check = $request->SEND_STATUS;
        $datebigin = $request->get('DATE_BIGIN');
        $dateend = $request->get('DATE_END');

        if($search==''){
            $search="";
        }

        $date_bigen_c = Carbon::createFromFormat('d/m/Y', $datebigin)->format('Y-m-d');
        $date_arrary=explode("-",$date_bigen_c);

        $y_sub_st = $date_arrary[0];

        if($y_sub_st >= 2500){
            $y = $y_sub_st-543;
        }else{
            $y = $y_sub_st;
        }

        $m = $date_arrary[1];
        $d = $date_arrary[2];
        $displaydate_bigen= $y."-".$m."-".$d;

        $date_end_c = Carbon::createFromFormat('d/m/Y', $dateend)->format('Y-m-d');
        $date_arrary_e=explode("-",$date_end_c);

        $y_sub_e = $date_arrary_e[0];

        if($y_sub_e >= 2500){
            $y_e = $y_sub_e-543;
        }else{
            $y_e = $y_sub_e;
        }
        $m_e = $date_arrary_e[1];
        $d_e = $date_arrary_e[2];
        $displaydate_end= $y_e."-".$m_e."-".$d_e;
        $date = date('Y-m-d');
                 
        $from = date($displaydate_bigen);
        $to = date($displaydate_end);        
         
        $electric = DB::table('env_electrical')->leftjoin('hrd_person','env_electrical.ELECTRICAL_USER','=','hrd_person.ID')               
            ->where(function($q) use ($search){
                $q->where('ELECTRICAL_COMMENT','like','%'.$search.'%');
                $q->orwhere('HR_FNAME','like','%'.$search.'%');
                $q->orwhere('HR_LNAME','like','%'.$search.'%');
            })
            ->WhereBetween('ELECTRICAL_DATE',[$from,$to])
            ->orderBy('ELECTRICAL_ID', 'desc')->get();
        
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
       
        $search = $search;
        $status_check = $status_check;

        $year_id = $yearbudget;
        return view('manager_env.electrical',[
              
            'displaydate_bigen' => $displaydate_bigen,  
            'displaydate_end' => $displaydate_end, 
            'search' => $search, 
            'budgets' =>  $budget,
            'year_id'=>$year_id,   
            'status_check' => $status_check,  
            'electrics'=>$electric, 
        ]);
    }
    public function electrical_add()
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

        $list_check = DB::table('env_list_check')->get();
        $list_status = DB::table('env_list_status')->get();
        $infoper = DB::table('hrd_person')->get();

        $maxnum = Env_electrical::max('ELECTRICAL_NO');
        if($maxnum != '' ||  $maxnum != null){
         $refmax = Env_electrical::where('ELECTRICAL_NO','=',$maxnum)->first();

         if($refmax->ELECTRICAL_NO != '' ||  $refmax->ELECTRICAL_NO != null){
         $maxpo = substr($refmax->ELECTRICAL_NO, -2)+1;
         }else{
         $maxref = 1;
         }
         $refe = str_pad($maxpo, 5, "0", STR_PAD_LEFT);
         }else{
        $refe = '00001';
         }
         $billNo = 'ELECT'.'-'.$refe;

        return view('manager_env.electrical_add',[
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id, 
            'list_checks'=>$list_check,
            'list_statuss'=>$list_status,
            'infopers'=>$infoper,
            'billNos'=>$billNo,
        ]);
    }
    public function electrical_save(Request $request)
    {
        $dateelect = $request->get('ELECTRICAL_DATE');
      
        $date_bigen_c = Carbon::createFromFormat('d/m/Y', $dateelect)->format('Y-m-d');
        $date_arrary=explode("-",$date_bigen_c);
    
        $y_sub_st = $date_arrary[0];
    
        if($y_sub_st >= 2500){
            $y = $y_sub_st-543;
        }else{
            $y = $y_sub_st;
        }    
        $m = $date_arrary[1];
        $d = $date_arrary[2];  
        $displaydate_bigen= $y."-".$m."-".$d;            
    
        $date = date('Y-m-d');
        $date_bigen_checks = strtotime($displaydate_bigen);      
        $dates =  strtotime($date);
    
        $electricdate = date($displaydate_bigen);

       
        $add = new Env_electrical();
        $add->ELECTRICAL_DATE = $electricdate;
        $add->ELECTRICAL_TIME = $request->ELECTRICAL_TIME;
        $add->ELECTRICAL_USER = $request->ELECTRICAL_USER;
        $add->ELECTRICAL_COMMENT = $request->ELECTRICAL_COMMENT;
        $add->ELECTRICAL_NO = $request->ELECTRICAL_NO;

        $add->save(); 

        $id_elec =  Env_electrical::max('ELECTRICAL_ID');

        if($request->ELECTRICAL_SUB_CHECK_DETAIL != '' || $request->ELECTRICAL_SUB_CHECK_DETAIL != null){

        $ELECTRICAL_SUB_CHECK_DETAIL = $request->ELECTRICAL_SUB_CHECK_DETAIL;
        $ELECTRICAL_SUB_CHECK_STATUS = $request->ELECTRICAL_SUB_CHECK_STATUS;
                           
        $number =count($ELECTRICAL_SUB_CHECK_DETAIL);
        $count = 0;
        for($count = 0; $count< $number; $count++)
        { 
            $listcheck_id = DB::table('env_list_check')->where('LIST_CHECK_ID','=',$ELECTRICAL_SUB_CHECK_DETAIL[$count])->first();

        $add_sub = new Env_electrical_sub();
        $add_sub->ELECTRICAL_ID = $id_elec;      
        $add_sub->ELECTRICAL_SUB_CHECK_ID = $listcheck_id->LIST_CHECK_ID;  
        $add_sub->ELECTRICAL_SUB_CHECK_DETAIL = $listcheck_id->LIST_CHECK_DETAIL; 
        $add_sub->ELECTRICAL_SUB_CHECK_STATUS = $ELECTRICAL_SUB_CHECK_STATUS[$count];                       
        $add_sub->save(); 
        }
        } 

        return redirect()->route('menv.electrical');
    }
    public function electrical_edit(Request $request,$id)
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
        
        $electric = DB::table('env_electrical')->leftjoin('hrd_person','env_electrical.ELECTRICAL_USER','=','hrd_person.ID')
        ->where('ELECTRICAL_ID','=',$id)->first();

        $electric_sub = DB::table('env_electrical_sub')->where('ELECTRICAL_ID','=',$id)->get();

        $list_check = DB::table('env_list_check')->get();
        $list_status = DB::table('env_list_status')->get();
        $infoper = DB::table('hrd_person')->get();

        return view('manager_env.electrical_edit',[
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id, 
            'list_checks'=>$list_check,
            'list_statuss'=>$list_status,
            'infopers'=>$infoper,
            'electrics'=>$electric,
            'electric_subs'=>$electric_sub,
        ]);
    }
    public function electrical_update(Request $request)
    {
        $dateelect = $request->get('ELECTRICAL_DATE');
        
        $date_bigin = Carbon::createFromFormat('d/m/Y', $dateelect)->format('Y-m-d');
        $date_arrary=explode("-",$date_bigin);
        $y_sub_st = $date_arrary[0];
    
        if($y_sub_st >= 2500){
            $y = $y_sub_st-543;
        }else{
            $y = $y_sub_st;
        }    
        $m = $date_arrary[1];
        $d = $date_arrary[2];  
        $dateelect_s= $y."-".$m."-".$d;
       
        $id =  $request->ELECTRICAL_ID;

        $update = Env_electrical::find($id);
        $update->ELECTRICAL_DATE = $dateelect_s;
        $update->ELECTRICAL_TIME = $request->ELECTRICAL_TIME;
        $update->ELECTRICAL_USER = $request->ELECTRICAL_USER;
        $update->ELECTRICAL_COMMENT = $request->ELECTRICAL_COMMENT;
        $update->ELECTRICAL_NO = $request->ELECTRICAL_NO;
        $update->save();

        Env_electrical_sub::where('ELECTRICAL_ID','=',$id)->delete();

        if($request->ELECTRICAL_SUB_CHECK_DETAIL != '' || $request->ELECTRICAL_SUB_CHECK_DETAIL != null){

            $ELECTRICAL_SUB_CHECK_DETAIL = $request->ELECTRICAL_SUB_CHECK_DETAIL;
            $ELECTRICAL_SUB_CHECK_STATUS = $request->ELECTRICAL_SUB_CHECK_STATUS;
                               
            $number =count($ELECTRICAL_SUB_CHECK_DETAIL);
            $count = 0;
            for($count = 0; $count< $number; $count++)
            { 
                $listcheck_id = DB::table('env_list_check')->where('LIST_CHECK_ID','=',$ELECTRICAL_SUB_CHECK_DETAIL[$count])->first();
                               
                $add_sub = new Env_electrical_sub();
                $add_sub->ELECTRICAL_ID = $id;      
                $add_sub->ELECTRICAL_SUB_CHECK_ID = $listcheck_id->LIST_CHECK_ID;  
                $add_sub->ELECTRICAL_SUB_CHECK_DETAIL = $listcheck_id->LIST_CHECK_DETAIL; 
                $add_sub->ELECTRICAL_SUB_CHECK_STATUS = $ELECTRICAL_SUB_CHECK_STATUS[$count];                            
                $add_sub->save();     
               
            }
        }
        return redirect()->route('menv.electrical');
    }
    public function electrical_destroy(Request $request,$id)
    {            
        Env_electrical::destroy($id);
        Env_electrical_sub::where('ELECTRICAL_ID',$id)->delete();
        return redirect()->route('menv.electrical');
    }
//////////////////////////////////////////

    public function plumbing(Request $request)
    {
        if($request->method() === 'POST'){
            $search = $request->get('search');
            $yearbudget = $request->BUDGET_YEAR;   
            $status_check = $request->SEND_STATUS;
            $datebigin = $request->get('DATE_BIGIN');
            $dateend = $request->get('DATE_END');
            session([
                'manager_env.plumbing.search' => $search,
                'manager_env.plumbing.yearbudget' => $yearbudget,
                'manager_env.plumbing.status_check' => $status_check,
                'manager_env.plumbing.datebigin' => $datebigin,
                'manager_env.plumbing.dateend' => $dateend,
            ]);
        }else if(session::has('manager_env.plumbing')){
            $search = session('manager_env.plumbing.search');
            $yearbudget = session('manager_env.plumbing.yearbudget');
            $status_check = session('manager_env.plumbing.status_check');
            $datebigin = session('manager_env.plumbing.datebigin');
            $dateend = session('manager_env.plumbing.dateend');
        }else{
            $search = '';
            $yearbudget = getBudgetyear();
            $status_check = '';
            $datebigin = date('1/m/Y');
            $dateend = date('d/m/Y',strtotime(date('Y-m-1').' +1month -1day'));
        }
        $date_bigen_c = Carbon::createFromFormat('d/m/Y', $datebigin)->format('Y-m-d');
        $date_arrary=explode("-",$date_bigen_c);

        $y_sub_st = $date_arrary[0];

        if($y_sub_st >= 2500){
            $y = $y_sub_st-543;
        }else{
            $y = $y_sub_st;
        }

        $m = $date_arrary[1];
        $d = $date_arrary[2];
        $displaydate_bigen= $y."-".$m."-".$d;

        $date_end_c = Carbon::createFromFormat('d/m/Y', $dateend)->format('Y-m-d');
        $date_arrary_e=explode("-",$date_end_c);

        $y_sub_e = $date_arrary_e[0];

        if($y_sub_e >= 2500){
            $y_e = $y_sub_e-543;
        }else{
            $y_e = $y_sub_e;
        }
        $m_e = $date_arrary_e[1];
        $d_e = $date_arrary_e[2];
        $displaydate_end= $y_e."-".$m_e."-".$d_e;
        $date = date('Y-m-d');
                 
        $from = date($displaydate_bigen);
        $to = date($displaydate_end);        
         
        $pum = Envplumbing::leftjoin('hrd_person','hrd_person.ID','=','env_plumbing.PLUMBING_USER')
        ->where(function($q) use ($search){
                    $q->where('PLUMBING_USERCHECK_NAME','like','%'.$search.'%');
                    $q->orwhere('PLUMBING_BILL_NO','like','%'.$search.'%');
                    $q->orwhere('HR_FNAME','like','%'.$search.'%');
                    $q->orwhere('HR_LNAME','like','%'.$search.'%');
                    $q->orwhere('PLUMBING_YEAR','like','%'.$search.'%');
                })
                ->WhereBetween('PLUMBING_DATE',[$from,$to])
                ->orderBy('PLUMBING_ID', 'desc')->get();

        
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
       
        $search = $search;
        $status_check = $status_check;

        $year_id = $yearbudget;
        return view('manager_env.plumbing',[
              
            'displaydate_bigen' => $displaydate_bigen,  
            'displaydate_end' => $displaydate_end, 
            'search' => $search, 
            'budgets' =>  $budget,
            'year_id'=>$year_id,   
            'status_check' => $status_check,  
            'pum'=>$pum, 
        ]);
    }
    public function plumbing_add(Request $request)
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

        $list_check = DB::table('env_plumbing_set')
        ->leftJoin('env_plumbing_sub', 'env_plumbing_set.SETUP_PLUMBING_ID', '=', 'env_plumbing_sub.PLUMBING_SUB_ID')
        ->get();

        
        $list_status = DB::table('env_list_status')->get();
        $infoper = DB::table('hrd_person')->get();


        $maxnum = Envplumbing::max('PLUMBING_BILL_NO');
        if($maxnum != '' ||  $maxnum != null){
         $refmax = Envplumbing::where('PLUMBING_BILL_NO','=',$maxnum)->first();

         if($refmax->PLUMBING_BILL_NO != '' ||  $refmax->PLUMBING_BILL_NO != null){
         $maxpo = substr($refmax->PLUMBING_BILL_NO, -2)+1;
         }else{
         $maxref = 1;
         }
         $refe = str_pad($maxpo, 5, "0", STR_PAD_LEFT);
         }else{
        $refe = '00001';
         }
         $billNo = $year_id.'-'.$refe;

         $infoprovince =  DB::table('hrd_province')->get();
         $pum_condition =  DB::table('env_plumbing_condition')->get();
         $pum_group_ex =  DB::table('env_plumbing_groupex')->get();

        return view('manager_env.plumbing_add',[
            'billNos'=>$billNo,
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id, 
            'list_checks'=>$list_check,
            'list_statuss'=>$list_status,
            'infopers'=>$infoper,
            'infoprovinces' => $infoprovince,
            'pum_conditions' => $pum_condition,
            'pum_group_exs' => $pum_group_ex,
        ]);
    }

    public function plumbing_save(Request $request)
    {
        $date_pums = $request->get('PLUMBING_DATE');  //วันที่ออกใบรายงาน
        $date_recs = $request->get('PLUMBING_REC_DATE'); //วันที่รับ
        $date_analyzs = $request->get('PLUMBING_ANALYZE_DATE');  //วันที่วิเคราะห์
        
        $date_bigin = Carbon::createFromFormat('d/m/Y', $date_pums)->format('Y-m-d');
            $date_arrary=explode("-",$date_bigin);
            $y_sub_st = $date_arrary[0];
        
            if($y_sub_st >= 2500){
                $y = $y_sub_st-543;
            }else{
                $y = $y_sub_st;
            }    
            $m = $date_arrary[1];
            $d = $date_arrary[2];  
        $date_pum= $y."-".$m."-".$d;

         ////////////////////////////////////

        $date_re = Carbon::createFromFormat('d/m/Y', $date_recs)->format('Y-m-d');
            $date_arrary=explode("-",$date_re);
            $y_sub_st = $date_arrary[0];
        
            if($y_sub_st >= 2500){
                $y = $y_sub_st-543;
            }else{
                $y = $y_sub_st;
            }    
            $m = $date_arrary[1];
            $d = $date_arrary[2];  
        $date_rec= $y."-".$m."-".$d;

        ////////////////////////////////////

        $date_ana = Carbon::createFromFormat('d/m/Y', $date_analyzs)->format('Y-m-d');
            $date_arrary=explode("-",$date_ana);
            $y_sub_st = $date_arrary[0];
        
            if($y_sub_st >= 2500){
                $y = $y_sub_st-543;
            }else{
                $y = $y_sub_st;
            }    
            $m = $date_arrary[1];
            $d = $date_arrary[2];  
        $date_analyz= $y."-".$m."-".$d;

         ////////////////////////////////////

        $idu =$request->PLUMBING_USERCHECK_ID;
        $ucheck = DB::table('hrd_person')->where('ID','=',$idu)->first();

        $add = new Envplumbing();
        $add->PLUMBING_BILL_NO = $request->PLUMBING_BILL_NO;
        $add->PLUMBING_DATE = $date_pum;
        $add->PLUMBING_REC_DATE = $date_rec;
        $add->PLUMBING_ANALYZE_DATE = $date_analyz;
        $add->PLUMBING_TIME = $request->PLUMBING_TIME;
        $add->PLUMBING_USER = $request->PLUMBING_USER;

        $add->PLUMBING_REC_NO = $request->PLUMBING_REC_NO;
        $add->PLUMBING_EMBLEM = $request->PLUMBING_EMBLEM;
        $add->PLUMBING_NO_SEND = $request->PLUMBING_NO_SEND;
        $add->PLUMBING_GROUP_EX = $request->PLUMBING_GROUP_EX;
        $add->PLUMBING_CONDITION = $request->PLUMBING_CONDITION;
        $add->PLUMBING_ENVIRONMENT = $request->PLUMBING_ENVIRONMENT;
        $add->PLUMBING_DEPRAT_SUBSUB = $request->PLUMBING_DEPRAT_SUBSUB;
        $add->PLUMBING_LOCATION = $request->PLUMBING_LOCATION;
        $add->PLUMBING_CH = $request->PLUMBING_CH;
        $add->PLUMBING_AM = $request->PLUMBING_AM;
        $add->PLUMBING_USERCHECK_ID = $idu;
        $add->PLUMBING_YEAR = $request->PLUMBING_YEAR;
        $add->save(); 

        $id =  Envplumbing::max('PLUMBING_ID');

        if($request->PLUMBING_SUB_TESTLIST != '' || $request->PLUMBING_SUB_TESTLIST != null){

            $PLUMBING_SUB_TESTLIST = $request->PLUMBING_SUB_TESTLIST;
            $PLUMBING_SUB_TESTER = $request->PLUMBING_SUB_TESTER;
            $PLUMBING_SUB_UNIT = $request->PLUMBING_SUB_UNIT;
            $PLUMBING_SUB_TEST = $request->PLUMBING_SUB_TEST;
                            
            $number =count($PLUMBING_SUB_TESTLIST);
            $count = 0;
            for($count = 0; $count< $number; $count++)
            {                 
            $add_sub = new Envplumbing_sub();
            $add_sub->PLUMBING_ID = $id;      
            $add_sub->PLUMBING_SUB_TESTLIST = $PLUMBING_SUB_TESTLIST[$count];  
            $add_sub->PLUMBING_SUB_TESTER = $PLUMBING_SUB_TESTER[$count];  
            $add_sub->PLUMBING_SUB_UNIT = $PLUMBING_SUB_UNIT[$count];  
            $add_sub->PLUMBING_SUB_TEST = $PLUMBING_SUB_TEST[$count];                          
            $add_sub->save(); 
            }
        } 
        return redirect()->route('menv.plumbing');       
    }

    public function plumbing_edit(Request $request ,$id)
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

            
            $list_status = DB::table('env_list_status')->get();
            $infoper = DB::table('hrd_person')->get();


            $maxnum = Envplumbing::max('PLUMBING_BILL_NO');
            if($maxnum != '' ||  $maxnum != null){
            $refmax = Envplumbing::where('PLUMBING_BILL_NO','=',$maxnum)->first();

            if($refmax->PLUMBING_BILL_NO != '' ||  $refmax->PLUMBING_BILL_NO != null){
            $maxpo = substr($refmax->PLUMBING_BILL_NO, -2)+1;
            }else{
            $maxref = 1;
            }
            $refe = str_pad($maxpo, 5, "0", STR_PAD_LEFT);
            }else{
            $refe = '00001';
            }
            $billNo = 'PB'.'-'.$refe;

          

            $pum = Envplumbing::where('PLUMBING_ID','=',$id)->first();
            $list_check = DB::table('env_plumbing_sub')->where('PLUMBING_ID','=',$id)->get();

            $infoprovince =  DB::table('hrd_province')->get();
            $infoamphur =  DB::table('hrd_amphur')->get();
            $pum_condition =  DB::table('env_plumbing_condition')->get();
            $pum_group_ex =  DB::table('env_plumbing_groupex')->get();

        return view('manager_env.plumbing_edit',[
            'billNos'=>$billNo,
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id, 
            'list_checks'=>$list_check,
            'list_statuss'=>$list_status,
            'infopers'=>$infoper,
            'pum'=>$pum,
            'infoprovinces'=>$infoprovince,
            'infoamphurs'=>$infoamphur,
            'pum_conditions' => $pum_condition,
            'pum_group_exs' => $pum_group_ex,
        ]);
    }

    public function plumbing_update(Request $request)
    {
            $date_pums = $request->get('PLUMBING_DATE');  //วันที่ออกใบรายงาน
            $date_recs = $request->get('PLUMBING_REC_DATE'); //วันที่รับ
            $date_analyzs = $request->get('PLUMBING_ANALYZE_DATE');  //วันที่วิเคราะห์
            
            $date_bigin = Carbon::createFromFormat('d/m/Y', $date_pums)->format('Y-m-d');
                $date_arrary=explode("-",$date_bigin);
                $y_sub_st = $date_arrary[0];
            
                if($y_sub_st >= 2500){
                    $y = $y_sub_st-543;
                }else{
                    $y = $y_sub_st;
                }    
                $m = $date_arrary[1];
                $d = $date_arrary[2];  
            $date_pum= $y."-".$m."-".$d;
    
            //  ////////////////////////////////////
    
            $date_re = Carbon::createFromFormat('d/m/Y', $date_recs)->format('Y-m-d');
                $date_arrary=explode("-",$date_re);
                $y_sub_st = $date_arrary[0];
            
                if($y_sub_st >= 2500){
                    $y = $y_sub_st-543;
                }else{
                    $y = $y_sub_st;
                }    
                $m = $date_arrary[1];
                $d = $date_arrary[2];  
            $date_rec= $y."-".$m."-".$d;
    
            // ////////////////////////////////////
    
            $date_ana = Carbon::createFromFormat('d/m/Y', $date_analyzs)->format('Y-m-d');
                $date_arrary=explode("-",$date_ana);
                $y_sub_st = $date_arrary[0];
            
                if($y_sub_st >= 2500){
                    $y = $y_sub_st-543;
                }else{
                    $y = $y_sub_st;
                }    
                $m = $date_arrary[1];
                $d = $date_arrary[2];  
            $date_analyz= $y."-".$m."-".$d;
    
            //  ////////////////////////////////////
      

        $idup = $request->PLUMBING_ID;

        $idu =$request->PLUMBING_USERCHECK_ID;
        $ucheck = DB::table('hrd_person')->where('ID','=',$idu)->first();

        $update = Envplumbing::find($idup);
        $update->PLUMBING_BILL_NO = $request->PLUMBING_BILL_NO;
        $update->PLUMBING_DATE = $date_pum;
        $update->PLUMBING_REC_DATE = $date_rec;
        $update->PLUMBING_ANALYZE_DATE = $date_analyz;
        $update->PLUMBING_TIME = $request->PLUMBING_TIME;
        $update->PLUMBING_USER = $request->PLUMBING_USER;

        $update->PLUMBING_REC_NO = $request->PLUMBING_REC_NO;
        $update->PLUMBING_EMBLEM = $request->PLUMBING_EMBLEM;
        $update->PLUMBING_NO_SEND = $request->PLUMBING_NO_SEND;
        $update->PLUMBING_GROUP_EX = $request->PLUMBING_GROUP_EX;
        $update->PLUMBING_CONDITION = $request->PLUMBING_CONDITION;
        $update->PLUMBING_ENVIRONMENT = $request->PLUMBING_ENVIRONMENT;
        $update->PLUMBING_DEPRAT_SUBSUB = $request->PLUMBING_DEPRAT_SUBSUB;
        $update->PLUMBING_LOCATION = $request->PLUMBING_LOCATION;
        $update->PLUMBING_CH = $request->PLUMBING_CH;
        $update->PLUMBING_AM = $request->PLUMBING_AM;
        $update->PLUMBING_USERCHECK_ID = $idu;
        $update->PLUMBING_YEAR = $request->PLUMBING_YEAR;
        $update->save(); 

     
        Envplumbing_sub::where('PLUMBING_ID','=',$idup)->delete();

        if($request->PLUMBING_SUB_TESTLIST != '' || $request->PLUMBING_SUB_TESTLIST != null){

            $PLUMBING_SUB_TESTLIST = $request->PLUMBING_SUB_TESTLIST;
            $PLUMBING_SUB_TESTER = $request->PLUMBING_SUB_TESTER;
            $PLUMBING_SUB_UNIT = $request->PLUMBING_SUB_UNIT;
            $PLUMBING_SUB_TEST = $request->PLUMBING_SUB_TEST;
                            
            $number =count($PLUMBING_SUB_TESTLIST);
            $count = 0;
            for($count = 0; $count< $number; $count++)
            {                 
            $add_sub = new Envplumbing_sub();
            $add_sub->PLUMBING_ID = $idup;      
            $add_sub->PLUMBING_SUB_TESTLIST = $PLUMBING_SUB_TESTLIST[$count];  
            $add_sub->PLUMBING_SUB_TESTER = $PLUMBING_SUB_TESTER[$count];  
            $add_sub->PLUMBING_SUB_UNIT = $PLUMBING_SUB_UNIT[$count];  
            $add_sub->PLUMBING_SUB_TEST = $PLUMBING_SUB_TEST[$count];                        
            $add_sub->save(); 
            }
        } 
        return redirect()->route('menv.plumbing');       
    }


    public function plumbing_serch(Request $request)
    {
        $search = $request->get('search');
        $yearbudget = $request->BUDGET_YEAR;   
        $status_check = $request->SEND_STATUS;
        $datebigin = $request->get('DATE_BIGIN');
        $dateend = $request->get('DATE_END');

        if($search==''){
            $search="";
        }

        $date_bigen_c = Carbon::createFromFormat('d/m/Y', $datebigin)->format('Y-m-d');
        $date_arrary=explode("-",$date_bigen_c);

        $y_sub_st = $date_arrary[0];

        if($y_sub_st >= 2500){
            $y = $y_sub_st-543;
        }else{
            $y = $y_sub_st;
        }

        $m = $date_arrary[1];
        $d = $date_arrary[2];
        $displaydate_bigen= $y."-".$m."-".$d;

        $date_end_c = Carbon::createFromFormat('d/m/Y', $dateend)->format('Y-m-d');
        $date_arrary_e=explode("-",$date_end_c);

        $y_sub_e = $date_arrary_e[0];

        if($y_sub_e >= 2500){
            $y_e = $y_sub_e-543;
        }else{
            $y_e = $y_sub_e;
        }
        $m_e = $date_arrary_e[1];
        $d_e = $date_arrary_e[2];
        $displaydate_end= $y_e."-".$m_e."-".$d_e;
        $date = date('Y-m-d');
                 
        $from = date($displaydate_bigen);
        $to = date($displaydate_end);        
         
        $pum = Envplumbing::leftjoin('hrd_person','hrd_person.ID','=','env_plumbing.PLUMBING_USER')
        ->where(function($q) use ($search){
                    $q->where('PLUMBING_USERCHECK_NAME','like','%'.$search.'%');
                    $q->orwhere('PLUMBING_BILL_NO','like','%'.$search.'%');
                    $q->orwhere('HR_FNAME','like','%'.$search.'%');
                    $q->orwhere('HR_LNAME','like','%'.$search.'%');
                    $q->orwhere('PLUMBING_YEAR','like','%'.$search.'%');
                })
                ->WhereBetween('PLUMBING_DATE',[$from,$to])
                ->orderBy('PLUMBING_ID', 'desc')->get();

        
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
       
        $search = $search;
        $status_check = $status_check;

        $year_id = $yearbudget;
        return view('manager_env.plumbing',[
              
            'displaydate_bigen' => $displaydate_bigen,  
            'displaydate_end' => $displaydate_end, 
            'search' => $search, 
            'budgets' =>  $budget,
            'year_id'=>$year_id,   
            'status_check' => $status_check,  
            'pum'=>$pum, 
        ]);
    }

    public function plumbing_delete(Request $request,$id)
    {            
        Envplumbing::destroy($id);
        Envplumbing_sub::where('PLUMBING_ID',$id)->delete();
        return redirect()->route('menv.plumbing');
    }


//*************************************************************************** */
    
    public function oxigen(Request $request)
    {   
        if($request->method() === 'POST'){
            $search = $request->get('search');
            $yearbudget = $request->BUDGET_YEAR;   
            $status_check = $request->SEND_STATUS;
            $datebigin = $request->get('DATE_BIGIN');
            $dateend = $request->get('DATE_END');
            session([
                'manager_env.oxigen.search' => $search,
                'manager_env.oxigen.yearbudget' => $yearbudget,
                'manager_env.oxigen.status_check' => $status_check,
                'manager_env.oxigen.datebigin' => $datebigin,
                'manager_env.oxigen.dateend' => $dateend,
            ]);
        }else if(session::has('manager_env.oxigen')){
            $search = session('manager_env.oxigen.search');
            $yearbudget = session('manager_env.oxigen.yearbudget');
            $status_check = session('manager_env.oxigen.status_check');
            $datebigin = session('manager_env.oxigen.datebigin');
            $dateend = session('manager_env.oxigen.dateend');
        }else{
            $search = '';
            $yearbudget = getBudgetyear();
            $status_check = '';
            $datebigin = date('1/m/Y');
            $dateend = date('d/m/Y',strtotime(date('Y-m-1').' +1month -1day'));
        }
        
        $date_bigen_c = Carbon::createFromFormat('d/m/Y', $datebigin)->format('Y-m-d');
        $date_arrary=explode("-",$date_bigen_c);

        $y_sub_st = $date_arrary[0];

        if($y_sub_st >= 2500){
            $y = $y_sub_st-543;
        }else{
            $y = $y_sub_st;
        }

        $m = $date_arrary[1];
        $d = $date_arrary[2];
        $displaydate_bigen= $y."-".$m."-".$d;

        $date_end_c = Carbon::createFromFormat('d/m/Y', $dateend)->format('Y-m-d');
        $date_arrary_e=explode("-",$date_end_c);

        $y_sub_e = $date_arrary_e[0];

        if($y_sub_e >= 2500){
            $y_e = $y_sub_e-543;
        }else{
            $y_e = $y_sub_e;
        }
        $m_e = $date_arrary_e[1];
        $d_e = $date_arrary_e[2];
        $displaydate_end= $y_e."-".$m_e."-".$d_e;
        $date = date('Y-m-d');
                 
        $from = date($displaydate_bigen);
        $to = date($displaydate_end);        
         
        $oxi = DB::table('env_oxigen')->leftjoin('hrd_person','env_oxigen.OXIGEN_USER','=','hrd_person.ID')             
            ->where(function($q) use ($search){
                $q->where('OXIGEN_BILL_NO','like','%'.$search.'%');
                $q->orwhere('HR_FNAME','like','%'.$search.'%');
                $q->orwhere('HR_LNAME','like','%'.$search.'%');
            })
            ->WhereBetween('OXIGEN_DATE',[$from,$to])
            ->orderBy('OXIGEN_ID', 'desc')->get();
        
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
       
        $search = $search;
        $status_check = $status_check;

        $year_id = $yearbudget;
        return view('manager_env.oxigen',[
              
            'displaydate_bigen' => $displaydate_bigen,  
            'displaydate_end' => $displaydate_end, 
            'search' => $search, 
            'budgets' =>  $budget,
            'year_id'=>$year_id,   
            'status_check' => $status_check,  
            'oxis'=>$oxi,
        ]);
    }
    public function oxigen_search(Request $request)
    {
        $search = $request->get('search');
        $yearbudget = $request->BUDGET_YEAR;   
        $status_check = $request->SEND_STATUS;
        $datebigin = $request->get('DATE_BIGIN');
        $dateend = $request->get('DATE_END');

        if($search==''){
            $search="";
        }

        $date_bigen_c = Carbon::createFromFormat('d/m/Y', $datebigin)->format('Y-m-d');
        $date_arrary=explode("-",$date_bigen_c);

        $y_sub_st = $date_arrary[0];

        if($y_sub_st >= 2500){
            $y = $y_sub_st-543;
        }else{
            $y = $y_sub_st;
        }

        $m = $date_arrary[1];
        $d = $date_arrary[2];
        $displaydate_bigen= $y."-".$m."-".$d;

        $date_end_c = Carbon::createFromFormat('d/m/Y', $dateend)->format('Y-m-d');
        $date_arrary_e=explode("-",$date_end_c);

        $y_sub_e = $date_arrary_e[0];

        if($y_sub_e >= 2500){
            $y_e = $y_sub_e-543;
        }else{
            $y_e = $y_sub_e;
        }
        $m_e = $date_arrary_e[1];
        $d_e = $date_arrary_e[2];
        $displaydate_end= $y_e."-".$m_e."-".$d_e;
        $date = date('Y-m-d');
                 
        $from = date($displaydate_bigen);
        $to = date($displaydate_end);        
         
        $oxi = DB::table('env_oxigen')->leftjoin('hrd_person','env_oxigen.OXIGEN_USER','=','hrd_person.ID')             
            ->where(function($q) use ($search){
                $q->where('OXIGEN_BILL_NO','like','%'.$search.'%');
                $q->orwhere('HR_FNAME','like','%'.$search.'%');
                $q->orwhere('HR_LNAME','like','%'.$search.'%');
            })
            ->WhereBetween('OXIGEN_DATE',[$from,$to])
            ->orderBy('OXIGEN_ID', 'desc')->get();
        
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
       
        $search = $search;
        $status_check = $status_check;

        $year_id = $yearbudget;
        return view('manager_env.oxigen',[
              
            'displaydate_bigen' => $displaydate_bigen,  
            'displaydate_end' => $displaydate_end, 
            'search' => $search, 
            'budgets' =>  $budget,
            'year_id'=>$year_id,   
            'status_check' => $status_check,  
            'oxis'=>$oxi,
        ]);
    }
    public function oxigenexcel(Request $request)
    {     
        $oxi = DB::table('env_oxigen')->leftjoin('hrd_person','env_oxigen.OXIGEN_USER','=','hrd_person.ID')->get(); 
        $count = DB::table('env_oxigen')->count();

        return view('manager_env.oxigenexcel',[
            'oxi' => $oxi, 
            'count' => $count 
        ]);
   
    }
    public function oxigen_add()
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
        $infoper = DB::table('hrd_person')->get();
        $set_oxigen = DB::table('env_oxigen_set')->get();
        $oxigen_sub = DB::table('env_oxigen_sub')->get();

        $maxnum = Env_oxigen::max('OXIGEN_BILL_NO');
        if($maxnum != '' ||  $maxnum != null){
         $refmax = Env_oxigen::where('OXIGEN_BILL_NO','=',$maxnum)->first();

         if($refmax->OXIGEN_BILL_NO != '' ||  $refmax->OXIGEN_BILL_NO != null){
         $maxpo = substr($refmax->OXIGEN_BILL_NO, -2)+1;
         }else{
         $maxref = 1;
         }
         $refe = str_pad($maxpo, 5, "0", STR_PAD_LEFT);
         }else{
        $refe = '00001';
         }
         $billNo = 'OXI'.'-'.$refe;

        return view('manager_env.oxigen_add',[
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id,
            'infopers'=>$infoper,
            'set_oxigens'=>$set_oxigen,
            'oxigen_subs'=>$oxigen_sub,
            'billNos'=>$billNo,
        ]);
    }
    public function oxigen_save(Request $request)
    {
        $dateelect = $request->get('OXIGEN_DATE');
        
        $date_bigin = Carbon::createFromFormat('d/m/Y', $dateelect)->format('Y-m-d');
        $date_arrary=explode("-",$date_bigin);
        $y_sub_st = $date_arrary[0];
    
        if($y_sub_st >= 2500){
            $y = $y_sub_st-543;
        }else{
            $y = $y_sub_st;
        }    
        $m = $date_arrary[1];
        $d = $date_arrary[2];  
        $date_parameter= $y."-".$m."-".$d;

        $idu =$request->OXIGEN_CHECK;
        $ucheck = DB::table('hrd_person')->where('ID','=',$idu)->first();

        $add = new Env_oxigen();
        $add->OXIGEN_DATE = $date_parameter;
        $add->OXIGEN_BILL_NO = $request->OXIGEN_BILL_NO;
        $add->OXIGEN_TIME = $request->OXIGEN_TIME;
        $add->OXIGEN_CHECK = $idu;
        $add->OXIGEN_CHECK_NAME = $ucheck->HR_FNAME.'  '.$ucheck->HR_LNAME;
        $add->OXIGEN_USER = $request->OXIGEN_USER;
        $add->OXIGEN_YEAR = $request->OXIGEN_YEAR;
        $add->save(); 

        $id =  Env_oxigen::max('OXIGEN_ID');

        if($request->OXIGEN_SUB_SET_OXIGEN_NAME != '' || $request->OXIGEN_SUB_SET_OXIGEN_NAME != null){

            $OXIGEN_SUB_SET_OXIGEN_NAME = $request->OXIGEN_SUB_SET_OXIGEN_NAME;
            $OXIGEN_SUB_SET_OXIGEN_QTY = $request->OXIGEN_SUB_SET_OXIGEN_QTY;
            $OXIGEN_SUB_SET_OXIGEN_UNIT = $request->OXIGEN_SUB_SET_OXIGEN_UNIT;
                            
            $number =count($OXIGEN_SUB_SET_OXIGEN_NAME);
            $count = 0;
            for($count = 0; $count< $number; $count++)
            { 
                
            $add_sub = new Env_oxigen_sub();
            $add_sub->OXIGEN_ID = $id;      
            $add_sub->OXIGEN_SUB_SET_OXIGEN_NAME = $OXIGEN_SUB_SET_OXIGEN_NAME[$count];  
            $add_sub->OXIGEN_SUB_SET_OXIGEN_QTY = $OXIGEN_SUB_SET_OXIGEN_QTY[$count];  
            $add_sub->OXIGEN_SUB_SET_OXIGEN_UNIT = $OXIGEN_SUB_SET_OXIGEN_UNIT[$count];                          
            $add_sub->save(); 
            }
        } 
        return redirect()->route('menv.oxigen');
    }
    public function oxigen_edit(Request $request,$id)
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

        $oxi = DB::table('env_oxigen')->leftjoin('hrd_person','env_oxigen.OXIGEN_USER','=','hrd_person.ID')
        ->where('OXIGEN_ID','=',$id)->first();
        $infoper = DB::table('hrd_person')->get();
       
        $oxi_sub = DB::table('env_oxigen_sub')->where('OXIGEN_ID','=',$id)->get();
     
        $trash_suppli = DB::table('supplies_vendor')->get();
        $set_oxigen = DB::table('env_oxigen_set')->get();

        return view('manager_env.oxigen_edit',[
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id,
            'oxis'=>$oxi,
            'infopers'=>$infoper,
            'oxi_subs'=>$oxi_sub,           
            'set_oxigens'=>$set_oxigen,
        ]);
    }  
    public function oxigen_update(Request $request)
    {
        $dateelect = $request->get('OXIGEN_DATE');
        
        $date_bigin = Carbon::createFromFormat('d/m/Y', $dateelect)->format('Y-m-d');
        $date_arrary=explode("-",$date_bigin);
        $y_sub_st = $date_arrary[0];
    
        if($y_sub_st >= 2500){
            $y = $y_sub_st-543;
        }else{
            $y = $y_sub_st;
        }    
        $m = $date_arrary[1];
        $d = $date_arrary[2];  
        $dateelect_s= $y."-".$m."-".$d;
       
        $id =  $request->OXIGEN_ID;

        $update = Env_oxigen::find($id);
        $update->OXIGEN_DATE = $dateelect_s;
        $update->OXIGEN_BILL_NO = $request->OXIGEN_BILL_NO;
        $update->OXIGEN_TIME = $request->OXIGEN_TIME;
        $update->OXIGEN_CHECK = $request->OXIGEN_CHECK;
        $update->OXIGEN_USER = $request->OXIGEN_USER;
        $update->OXIGEN_YEAR = $request->OXIGEN_YEAR;
        $update->save();

        Env_oxigen_sub::where('OXIGEN_ID','=',$id)->delete();

        if($request->OXIGEN_SUB_SET_OXIGEN_NAME != '' || $request->OXIGEN_SUB_SET_OXIGEN_NAME != null){

            $OXIGEN_SUB_SET_OXIGEN_NAME = $request->OXIGEN_SUB_SET_OXIGEN_NAME;
            $OXIGEN_SUB_SET_OXIGEN_QTY = $request->OXIGEN_SUB_SET_OXIGEN_QTY;
            $OXIGEN_SUB_SET_OXIGEN_UNIT = $request->OXIGEN_SUB_SET_OXIGEN_UNIT;
                            
            $number =count($OXIGEN_SUB_SET_OXIGEN_NAME);
            $count = 0;
            for($count = 0; $count< $number; $count++)
            { 
                
            $add_sub = new Env_oxigen_sub();
            $add_sub->OXIGEN_ID = $id;      
            $add_sub->OXIGEN_SUB_SET_OXIGEN_NAME = $OXIGEN_SUB_SET_OXIGEN_NAME[$count];  
            $add_sub->OXIGEN_SUB_SET_OXIGEN_QTY = $OXIGEN_SUB_SET_OXIGEN_QTY[$count];  
            $add_sub->OXIGEN_SUB_SET_OXIGEN_UNIT = $OXIGEN_SUB_SET_OXIGEN_UNIT[$count];                          
            $add_sub->save(); 
            }
        } 
        return redirect()->route('menv.oxigen');
    }
    public function oxigen_destroy(Request $request,$id)
    {            
        Env_oxigen::destroy($id);
        Env_oxigen_sub::where('OXIGEN_ID',$id)->delete();
        return redirect()->route('menv.oxigen');
    }
    //******************************ระบบขยะติดเชื้อ********************************************* */   
    public function trash(Request $request)
    {    
        if($request->method() === 'POST'){
            $search = $request->get('search');
            $yearbudget = $request->BUDGET_YEAR;   
            $status_check = $request->SEND_STATUS;
            $datebigin = $request->get('DATE_BIGIN');
            $dateend = $request->get('DATE_END');
            session([
                'manager_env.trash.search' => $search,
                'manager_env.trash.yearbudget' => $yearbudget,
                'manager_env.trash.status_check' => $status_check,
                'manager_env.trash.datebigin' => $datebigin,
                'manager_env.trash.dateend' => $dateend,
            ]);
        }else if(session::has('manager_env.trash')){
            $search = session('manager_env.trash.search');
            $yearbudget = session('manager_env.trash.yearbudget');
            $status_check = session('manager_env.trash.status_check');
            $datebigin = session('manager_env.trash.datebigin');
            $dateend = session('manager_env.trash.dateend');
        }else{
            $search = '';
            $yearbudget = getBudgetyear();
            $status_check = '';
            $datebigin = date('1/m/Y');
            $dateend = date('d/m/Y',strtotime(date('Y-m-1').' +1month -1day'));
        }

        $date_bigen_c = Carbon::createFromFormat('d/m/Y', $datebigin)->format('Y-m-d');
        $date_arrary=explode("-",$date_bigen_c);

        $y_sub_st = $date_arrary[0];

        if($y_sub_st >= 2500){
            $y = $y_sub_st-543;
        }else{
            $y = $y_sub_st;
        }

        $m = $date_arrary[1];
        $d = $date_arrary[2];
        $displaydate_bigen= $y."-".$m."-".$d;

        $date_end_c = Carbon::createFromFormat('d/m/Y', $dateend)->format('Y-m-d');
        $date_arrary_e=explode("-",$date_end_c);

        $y_sub_e = $date_arrary_e[0];

        if($y_sub_e >= 2500){
            $y_e = $y_sub_e-543;
        }else{
            $y_e = $y_sub_e;
        }
        $m_e = $date_arrary_e[1];
        $d_e = $date_arrary_e[2];
        $displaydate_end= $y_e."-".$m_e."-".$d_e;
        $date = date('Y-m-d');
                 
        $from = date($displaydate_bigen);
        $to = date($displaydate_end);        
         
        $trash = DB::table('env_trash')->leftjoin('hrd_person','env_trash.TRASH_USER','=','hrd_person.ID')
            ->leftjoin('env_trash_type','env_trash.TRASH_USER','=','env_trash_type.TRASH_TYPE_ID')
            ->leftjoin('supplies_vendor','env_trash.TRASH_SUP','=','supplies_vendor.VENDOR_ID')            
            ->where(function($q) use ($search){
                $q->where('VENDOR_NAME','like','%'.$search.'%');
                $q->orwhere('TRASH_BILL_NO','like','%'.$search.'%');
                $q->orwhere('HR_FNAME','like','%'.$search.'%');
                $q->orwhere('HR_LNAME','like','%'.$search.'%');
            })
            ->WhereBetween('TRASH_DATE',[$from,$to])
            ->orderBy('TRASH_ID', 'desc')->get();
        
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $trash_type = DB::table('env_trash_type') ->get();

        $search = $search;
        $status_check = $status_check;

        $year_id = $yearbudget;
        return view('manager_env.trash',[
              
            'displaydate_bigen' => $displaydate_bigen,  
            'displaydate_end' => $displaydate_end, 
            'search' => $search, 
            'budgets' =>  $budget,
            'year_id'=>$year_id,   
            'status_check' => $status_check,  
            'trashs'=>$trash,
            'trash_types'=>$trash_type,
        ]);
    }

////////////////////////////////////////////////////////////////////////////

    public static function checktrahA($id)
    {
        $checktrahA =  Env_trash_sub::where('TRASH_ID','=',$id)->where('TRASH_SUB_IDID','=','1')->sum('TRASH_SUB_QTY');                         
        return $checktrahA;
    }
    public static function checktrahB($id)
    {
        $checktrahB =  Env_trash_sub::where('TRASH_ID','=',$id)->where('TRASH_SUB_IDID','=','2')->sum('TRASH_SUB_QTY');        
    return $checktrahB;
    }
    public static function checktrahD($id)
    {
        $checktrahD =  Env_trash_sub::where('TRASH_ID','=',$id)->where('TRASH_SUB_IDID','=','3')->sum('TRASH_SUB_QTY');        
    return $checktrahD;
    }
    public static function checktrahE($id)
    {
        $checktrahE =  Env_trash_sub::where('TRASH_ID','=',$id)->where('TRASH_SUB_IDID','=','4')->sum('TRASH_SUB_QTY');        
    return $checktrahE;
    }
    public static function checktrahF($id)
    {
        $checktrahF =  Env_trash_sub::where('TRASH_ID','=',$id)->where('TRASH_SUB_IDID','=','5')->sum('TRASH_SUB_QTY');        
    return $checktrahF;
    }

    public function trash_search(Request $request)
    {
        $search = $request->get('search');
        $yearbudget = $request->BUDGET_YEAR;   
        $status_check = $request->SEND_STATUS;
        $datebigin = $request->get('DATE_BIGIN');
        $dateend = $request->get('DATE_END');

        if($search==''){
            $search="";
        }

        $date_bigen_c = Carbon::createFromFormat('d/m/Y', $datebigin)->format('Y-m-d');
        $date_arrary=explode("-",$date_bigen_c);

        $y_sub_st = $date_arrary[0];

        if($y_sub_st >= 2500){
            $y = $y_sub_st-543;
        }else{
            $y = $y_sub_st;
        }

        $m = $date_arrary[1];
        $d = $date_arrary[2];
        $displaydate_bigen= $y."-".$m."-".$d;

        $date_end_c = Carbon::createFromFormat('d/m/Y', $dateend)->format('Y-m-d');
        $date_arrary_e=explode("-",$date_end_c);

        $y_sub_e = $date_arrary_e[0];

        if($y_sub_e >= 2500){
            $y_e = $y_sub_e-543;
        }else{
            $y_e = $y_sub_e;
        }
        $m_e = $date_arrary_e[1];
        $d_e = $date_arrary_e[2];
        $displaydate_end= $y_e."-".$m_e."-".$d_e;
        $date = date('Y-m-d');
                 
        $from = date($displaydate_bigen);
        $to = date($displaydate_end);        
         
        $trash = DB::table('env_trash')->leftjoin('hrd_person','env_trash.TRASH_USER','=','hrd_person.ID')
            ->leftjoin('env_trash_type','env_trash.TRASH_USER','=','env_trash_type.TRASH_TYPE_ID')
            ->leftjoin('supplies_vendor','env_trash.TRASH_SUP','=','supplies_vendor.VENDOR_ID')            
            ->where(function($q) use ($search){
                $q->where('VENDOR_NAME','like','%'.$search.'%');
                $q->orwhere('TRASH_BILL_NO','like','%'.$search.'%');
                $q->orwhere('HR_FNAME','like','%'.$search.'%');
                $q->orwhere('HR_LNAME','like','%'.$search.'%');
            })
            ->WhereBetween('TRASH_DATE',[$from,$to])
            ->orderBy('TRASH_ID', 'desc')->get();
        
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $trash_type = DB::table('env_trash_type') ->get();

        $search = $search;
        $status_check = $status_check;

        $year_id = $yearbudget;
        return view('manager_env.trash',[
              
            'displaydate_bigen' => $displaydate_bigen,  
            'displaydate_end' => $displaydate_end, 
            'search' => $search, 
            'budgets' =>  $budget,
            'year_id'=>$year_id,   
            'status_check' => $status_check,  
            'trashs'=>$trash,
            'trash_types'=>$trash_type,
        ]);
    }
    public function trash_add()
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

        $infoper = DB::table('hrd_person')->get();
        $trash = DB::table('env_trash')->get();
        $trash_type = DB::table('env_trash_type')->get();
        $trash_sup = DB::table('supplies_vendor')->get();
        $trash_set = DB::table('env_trash_set')->get();

        $maxnum = Env_trash::max('TRASH_BILL_NO');
        if($maxnum != '' ||  $maxnum != null){
         $refmax = Env_trash::where('TRASH_BILL_NO','=',$maxnum)->first();

         if($refmax->TRASH_BILL_NO != '' ||  $refmax->TRASH_BILL_NO != null){
         $maxpo = substr($refmax->TRASH_BILL_NO, -2)+1;
         }else{
         $maxref = 1;
         }
         $refe = str_pad($maxpo, 5, "0", STR_PAD_LEFT);
         }else{
        $refe = '00001';
         }
         $billNo = 'TRA'.'-'.$refe;

        return view('manager_env.trash_add',[
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id,
            'infopers'=>$infoper,
            'trashs'=>$trash,
            'trash_types'=>$trash_type,
            'trash_sups'=>$trash_sup,
            'trash_sets'=>$trash_set,
            'billNos'=>$billNo,
        ]);
    }
    public function trash_save(Request $request)
    {
        $dateelect = $request->get('TRASH_DATE');
        
        $date_bigin = Carbon::createFromFormat('d/m/Y', $dateelect)->format('Y-m-d');
        $date_arrary=explode("-",$date_bigin);
        $y_sub_st = $date_arrary[0];
    
        if($y_sub_st >= 2500){
            $y = $y_sub_st-543;
        }else{
            $y = $y_sub_st;
        }    
        $m = $date_arrary[1];
        $d = $date_arrary[2];  
        $date_parameter= $y."-".$m."-".$d;

        $add = new Env_trash();
        $add->TRASH_DATE = $date_parameter;
        $add->TRASH_BILL_NO = $request->TRASH_BILL_NO;
        $add->TRASH_TIME = $request->TRASH_TIME;
        $add->TRASH_SUP = $request->TRASH_SUP;
        $add->TRASH_USER = $request->TRASH_USER;
        $add->TRASH_YEAR = $request->TRASH_YEAR;
        $add->save(); 

        $id_para =  Env_trash::max('TRASH_ID');

        if($request->SET_TRASH_ID != '' || $request->SET_TRASH_ID != null){

        $SET_TRASH_ID = $request->SET_TRASH_ID;
        $TRASH_SUB_QTY = $request->TRASH_SUB_QTY;
        $TRASH_SUB_UNIT = $request->TRASH_SUB_UNIT;
                            
        $number =count($SET_TRASH_ID);
        $count = 0;
        for($count = 0; $count< $number; $count++)
        { 
            $idtrash = Env_trash_set::where('SET_TRASH_ID','=',$SET_TRASH_ID[$count])->first();

        $add_sub = new Env_trash_sub();
        $add_sub->TRASH_ID = $id_para;  

        $add_sub->TRASH_SUB_IDID = $idtrash->SET_TRASH_ID;  
        $add_sub->TRASH_SUB_NAME = $idtrash->SET_TRASH_NAME; 
        $add_sub->TRASH_SUB_QTY = $TRASH_SUB_QTY[$count];  
        $add_sub->TRASH_SUB_UNIT = $TRASH_SUB_UNIT[$count];                          
        $add_sub->save(); 
        }
        } 
        return redirect()->route('menv.trash');
    }
    public function trash_edit(Request $request,$id)
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

        $infoper = DB::table('hrd_person')->get();
        $trash = DB::table('env_trash')->where('TRASH_ID','=',$id)->first();
        $trash_sub = DB::table('env_trash_sub')->where('TRASH_ID','=',$id)->get();
        $trash_type = DB::table('env_trash_type')->get();
        $trash_suppli = DB::table('supplies_vendor')->get();
        $trash_set = DB::table('env_trash_set')->get();
        return view('manager_env.trash_edit',[
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id,
            'infopers'=>$infoper,
            'trashs'=>$trash,
            'trash_types'=>$trash_type,
            'trash_subs'=>$trash_sub,
            'trash_supplis'=>$trash_suppli,
            'trash_sets'=>$trash_set,
        ]);
    }
    public function trash_update(Request $request)
    {
        $dateelect = $request->get('TRASH_DATE');
        
        $date_bigin = Carbon::createFromFormat('d/m/Y', $dateelect)->format('Y-m-d');
        $date_arrary=explode("-",$date_bigin);
        $y_sub_st = $date_arrary[0];
    
        if($y_sub_st >= 2500){
            $y = $y_sub_st-543;
        }else{
            $y = $y_sub_st;
        }    
        $m = $date_arrary[1];
        $d = $date_arrary[2];  
        $dateelect_s= $y."-".$m."-".$d;
        
        $id =  $request->TRASH_ID;

        $update = Env_trash::find($id);
        $update->TRASH_DATE = $dateelect_s;
        $update->TRASH_BILL_NO = $request->TRASH_BILL_NO;
        $update->TRASH_TIME = $request->TRASH_TIME;
        $update->TRASH_SUP = $request->TRASH_SUP;
        $update->TRASH_USER = $request->TRASH_USER;
        $update->TRASH_YEAR = $request->TRASH_YEAR;
        $update->save();

        Env_trash_sub::where('TRASH_ID','=',$id)->delete();

        if($request->TRASH_SUB_IDID != '' || $request->TRASH_SUB_IDID != null){

            $TRASH_SUB_IDID = $request->TRASH_SUB_IDID;
            $TRASH_SUB_QTY = $request->TRASH_SUB_QTY;
            $TRASH_SUB_UNIT = $request->TRASH_SUB_UNIT;
                                
            $number =count($TRASH_SUB_IDID);
            $count = 0;
            for($count = 0; $count< $number; $count++)
            { 
                $idtrash = Env_trash_set::where('SET_TRASH_ID','=',$TRASH_SUB_IDID[$count])->first();
                
                $add_sub = new Env_trash_sub();
                $add_sub->TRASH_ID = $id;      
            
                $add_sub->TRASH_SUB_IDID = $idtrash->SET_TRASH_ID;  
                $add_sub->TRASH_SUB_NAME = $idtrash->SET_TRASH_NAME; 

                $add_sub->TRASH_SUB_QTY = $TRASH_SUB_QTY[$count];  
                $add_sub->TRASH_SUB_UNIT = $TRASH_SUB_UNIT[$count];                          
                $add_sub->save(); 
            }
        } 
        
        return redirect()->route('menv.trash');
    }
    public function trash_destroy(Request $request,$id)
    {            
        Env_trash::destroy($id);
        Env_trash_sub::where('TRASH_ID',$id)->delete();
        return redirect()->route('menv.trash');
    }
    //******************************ระบบบำบัดน้ำเสีย********************************************* */   
    public function watertreatment(Request $request)
    {    
        if($request->method() === 'POST'){
            $search = $request->get('search');
            $yearbudget = $request->BUDGET_YEAR;   
            $status_check = $request->SEND_STATUS;
            $datebigin = $request->get('DATE_BIGIN');
            $dateend = $request->get('DATE_END');
            session([
                'manager_env.watertreatment.search' => $search,
                'manager_env.watertreatment.yearbudget' => $yearbudget,
                'manager_env.watertreatment.status_check' => $status_check,
                'manager_env.watertreatment.datebigin' => $datebigin,
                'manager_env.watertreatment.dateend' => $dateend,
            ]);
        }else if(session::has('manager_env.watertreatment')){
            $search = session('manager_env.watertreatment.search');
            $yearbudget = session('manager_env.watertreatment.yearbudget');
            $status_check = session('manager_env.watertreatment.status_check');
            $datebigin = session('manager_env.watertreatment.datebigin');
            $dateend = session('manager_env.watertreatment.dateend');
        }else{
            $search = '';
            $yearbudget = getBudgetyear();
            $status_check = '';
            $datebigin = date('1/m/Y');
            $dateend = date('d/m/Y',strtotime(date('Y-m-1').' +1month -1day'));
        }

        $date_bigen_c = Carbon::createFromFormat('d/m/Y', $datebigin)->format('Y-m-d');
            $date_arrary=explode("-",$date_bigen_c);
            $y_sub_st = $date_arrary[0];
            if($y_sub_st >= 2500){
                $y = $y_sub_st-543;
            }else{
                $y = $y_sub_st;
            }
            $m = $date_arrary[1];
            $d = $date_arrary[2];
            $displaydate_bigen= $y."-".$m."-".$d;

            $date_end_c = Carbon::createFromFormat('d/m/Y', $dateend)->format('Y-m-d');
            $date_arrary_e=explode("-",$date_end_c);
            $y_sub_e = $date_arrary_e[0];
            if($y_sub_e >= 2500){
                $y_e = $y_sub_e-543;
            }else{
                $y_e = $y_sub_e;
            }
            $m_e = $date_arrary_e[1];
            $d_e = $date_arrary_e[2];
            $displaydate_end= $y_e."-".$m_e."-".$d_e;

        $date = date('Y-m-d');    

        $from = date($displaydate_bigen);
        $to = date($displaydate_end);        
         
        $parameter = DB::table('env_parameter')->leftjoin('hrd_person','env_parameter.PARAMETER_USER','=','hrd_person.ID')          
            ->where(function($q) use ($search){
                $q->where('PARAMETER_COMMENT','like','%'.$search.'%');
                $q->orwhere('HR_FNAME','like','%'.$search.'%');
                $q->orwhere('HR_LNAME','like','%'.$search.'%');
            })
            ->WhereBetween('PARAMETER_DATE',[$from,$to])
            ->orderBy('PARAMETER_ID', 'desc')->get();
        
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        
        $search = $search;
        $status_check = $status_check;

        $year_id = $yearbudget;

        $list = DB::table('env_list_parameter')
        ->limit(10)
        ->get();

        return view('manager_env.watertreatment',[
            'lists' =>  $list,
            'displaydate_bigen' => $displaydate_bigen,  
            'displaydate_end' => $displaydate_end, 
            'search' => $search, 
            'budgets' =>  $budget,
            'year_id'=>$year_id,   
            'status_check' => $status_check,  
            'parameters'=>$parameter,
           
        ]);
    }
    public function watertreatmentexcel(Request $request)
    {     
        if($request->method() === 'POST'){
            $search = $request->get('search');
            $yearbudget = $request->BUDGET_YEAR;   
            $status_check = $request->SEND_STATUS;
            $datebigin = $request->get('DATE_BIGIN');
            $dateend = $request->get('DATE_END');
            session([
                'manager_env.watertreatment.search' => $search,
                'manager_env.watertreatment.yearbudget' => $yearbudget,
                'manager_env.watertreatment.status_check' => $status_check,
                'manager_env.watertreatment.datebigin' => $datebigin,
                'manager_env.watertreatment.dateend' => $dateend,
            ]);
        }else if(session::has('manager_env.watertreatment')){
            $search = session('manager_env.watertreatment.search');
            $yearbudget = session('manager_env.watertreatment.yearbudget');
            $status_check = session('manager_env.watertreatment.status_check');
            $datebigin = session('manager_env.watertreatment.datebigin');
            $dateend = session('manager_env.watertreatment.dateend');
        }else{
            $search = '';
            $yearbudget = getBudgetyear();
            $status_check = '';
            $datebigin = date('1/m/Y');
            $dateend = date('d/m/Y',strtotime(date('Y-m-1').' +1month -1day'));
        }
        $date_bigen_c = Carbon::createFromFormat('d/m/Y', $datebigin)->format('Y-m-d');
        $date_arrary=explode("-",$date_bigen_c);
        $y_sub_st = $date_arrary[0];
        if($y_sub_st >= 2500){
            $y = $y_sub_st-543;
        }else{
            $y = $y_sub_st;
        }
        $m = $date_arrary[1];
        $d = $date_arrary[2];
        $displaydate_bigen= $y."-".$m."-".$d;

        $date_end_c = Carbon::createFromFormat('d/m/Y', $dateend)->format('Y-m-d');
        $date_arrary_e=explode("-",$date_end_c);
        $y_sub_e = $date_arrary_e[0];
        if($y_sub_e >= 2500){
            $y_e = $y_sub_e-543;
        }else{
            $y_e = $y_sub_e;
        }
        $m_e = $date_arrary_e[1];
        $d_e = $date_arrary_e[2];
        $displaydate_end= $y_e."-".$m_e."-".$d_e;

    $date = date('Y-m-d');    

    $from = date($displaydate_bigen);
    $to = date($displaydate_end); 

        $parameter = DB::table('env_parameter')
        ->leftjoin('hrd_person','env_parameter.PARAMETER_USER','=','hrd_person.ID')
        ->WhereBetween('PARAMETER_DATE',[$from,$to])
        ->orderBy('PARAMETER_ID', 'desc')
        ->get(); 
       
        $count = DB::table('env_parameter')->count();
     
        $list = DB::table('env_list_parameter')
        ->get();
      
        return view('manager_env.watertreatmentexcel',[
            'lists' =>  $list,
            'parameters' => $parameter, 
            'count' => $count 

        ]);
   
    }
    public function watertreatment_search(Request $request)
    {
        $search = $request->get('search');
        $yearbudget = $request->BUDGET_YEAR;   
        $status_check = $request->SEND_STATUS;
        $datebigin = $request->get('DATE_BIGIN');
        $dateend = $request->get('DATE_END');

        if($search==''){
            $search="";
        }

        $date_bigen_c = Carbon::createFromFormat('d/m/Y', $datebigin)->format('Y-m-d');
            $date_arrary=explode("-",$date_bigen_c);
            $y_sub_st = $date_arrary[0];
            if($y_sub_st >= 2500){
                $y = $y_sub_st-543;
            }else{
                $y = $y_sub_st;
            }
            $m = $date_arrary[1];
            $d = $date_arrary[2];
            $displaydate_bigen= $y."-".$m."-".$d;

            $date_end_c = Carbon::createFromFormat('d/m/Y', $dateend)->format('Y-m-d');
            $date_arrary_e=explode("-",$date_end_c);
            $y_sub_e = $date_arrary_e[0];
            if($y_sub_e >= 2500){
                $y_e = $y_sub_e-543;
            }else{
                $y_e = $y_sub_e;
            }
            $m_e = $date_arrary_e[1];
            $d_e = $date_arrary_e[2];
            $displaydate_end= $y_e."-".$m_e."-".$d_e;

        $date = date('Y-m-d');    

        $from = date($displaydate_bigen);
        $to = date($displaydate_end);        
         
        $parameter = DB::table('env_parameter')->leftjoin('hrd_person','env_parameter.PARAMETER_USER','=','hrd_person.ID')          
            ->where(function($q) use ($search){
                $q->where('PARAMETER_COMMENT','like','%'.$search.'%');
                $q->orwhere('HR_FNAME','like','%'.$search.'%');
                $q->orwhere('HR_LNAME','like','%'.$search.'%');
            })
            ->WhereBetween('PARAMETER_DATE',[$from,$to])
            ->orderBy('PARAMETER_ID', 'desc')->get();
        
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        
        $search = $search;
        $status_check = $status_check;

        $year_id = $yearbudget;

        $list = DB::table('env_list_parameter')
        ->limit(10)
        ->get();

        return view('manager_env.watertreatment',[
            'lists' =>  $list,
            'displaydate_bigen' => $displaydate_bigen,  
            'displaydate_end' => $displaydate_end, 
            'search' => $search, 
            'budgets' =>  $budget,
            'year_id'=>$year_id,   
            'status_check' => $status_check,  
            'parameters'=>$parameter,
           
        ]);
    }
    public function watertreatment_add()
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

        $infoper = DB::table('hrd_person')->get();
        $list_parameter = DB::table('env_list_parameter')->get();

        return view('manager_env.watertreatment_add',[
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id,
            'infopers'=>$infoper,
            'list_parameters'=>$list_parameter,
        ]);
    }
    public function watertreatment_save(Request $request)
    {
        $dateelect = $request->get('PARAMETER_DATE');
        $datelocation = $request->get('LOCATION_EXDATE');
        $dateexample = $request->get('GROUP_EXCAMPLEDATE');
        
        $date_bigin = Carbon::createFromFormat('d/m/Y', $dateelect)->format('Y-m-d');
        $date_arrary=explode("-",$date_bigin);
        $y_sub_st = $date_arrary[0];
    
        if($y_sub_st >= 2500){
            $y = $y_sub_st-543;
        }else{
            $y = $y_sub_st;
        }    
        $m = $date_arrary[1];
        $d = $date_arrary[2];  
        $date_parameter= $y."-".$m."-".$d;

        $date_bigin2 = Carbon::createFromFormat('d/m/Y', $datelocation)->format('Y-m-d');
        $date_arrary=explode("-",$date_bigin2);
        $y_sub_st = $date_arrary[0];
    
        if($y_sub_st >= 2500){
            $y = $y_sub_st-543;
        }else{
            $y = $y_sub_st;
        }    
        $m = $date_arrary[1];
        $d = $date_arrary[2];  
        $date_location= $y."-".$m."-".$d;

        $date_bigin3 = Carbon::createFromFormat('d/m/Y', $dateexample)->format('Y-m-d');
        $date_arrary=explode("-",$date_bigin3);
        $y_sub_st = $date_arrary[0];
    
        if($y_sub_st >= 2500){
            $y = $y_sub_st-543;
        }else{
            $y = $y_sub_st;
        }    
        $m = $date_arrary[1];
        $d = $date_arrary[2];  
        $date_example= $y."-".$m."-".$d;

        $add = new Env_parameter();
        $add->PARAMETER_DATE = $date_parameter;
        $add->LOCATION_EX = $request->LOCATION_EX;
        $add->GROUP_EXCAMPLE = $request->GROUP_EXCAMPLE;
        $add->LOCATION_EXDATE = $date_location;
        $add->GROUP_EXCAMPLEDATE = $date_example;
        $add->USER_EXCAMPLE = $request->USER_EXCAMPLE;
        $add->PARAMETER_COMMENT = $request->PARAMETER_COMMENT;
        $add->PARAMETER_USER = $request->PARAMETER_USER;
        $add->PARAMETER_YEAR = $request->PARAMETER_YEAR;
        $add->save(); 

        $id_para =  Env_parameter::max('PARAMETER_ID');

        if($request->LIST_PARAMETER_ID != '' || $request->LIST_PARAMETER_ID != null){

        $LIST_PARAMETER_ID = $request->LIST_PARAMETER_ID;
        $LIST_PARAMETER_UNIT = $request->LIST_PARAMETER_UNIT;
        $ANALYSIS_RESULTS = $request->ANALYSIS_RESULTS;
        $USEANALYSIS_RESULTS = $request->USEANALYSIS_RESULTS;
        $PARAMETER_QTY = $request->PARAMETER_QTY;                            
        $number =count($LIST_PARAMETER_ID);
        $count = 0;
        for($count = 0; $count< $number; $count++)
        { 
        $idlist = DB::table('env_list_parameter')->where('LIST_PARAMETER_ID','=',$LIST_PARAMETER_ID[$count])->first();
        $add_sub = new Env_parameter_sub();
        $add_sub->PARAMETER_ID = $id_para;    
        $add_sub->LIST_PARAMETER_IDD = $idlist->LIST_PARAMETER_ID;
        $add_sub->LIST_PARAMETER_DETAIL = $idlist->LIST_PARAMETER_DETAIL;  
        $add_sub->LIST_PARAMETER_UNIT = $LIST_PARAMETER_UNIT[$count];  
        $add_sub->ANALYSIS_RESULTS = $ANALYSIS_RESULTS[$count];
        $add_sub->USEANALYSIS_RESULTS = $USEANALYSIS_RESULTS[$count];
        $add_sub->PARAMETER_QTY = $PARAMETER_QTY[$count];                          
        $add_sub->save(); 
        }
        } 
        return redirect()->route('menv.watertreatment');
    }
    public function watertreatment_edit(Request $request,$id)
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

        $parameter = DB::table('env_parameter')->where('PARAMETER_ID','=',$id)->first();
        $infoper = DB::table('hrd_person')->get();
        $parameter_sub = DB::table('env_parameter_sub')
        ->leftJoin('env_list_parameter','env_list_parameter.LIST_PARAMETER_ID','=','env_parameter_sub.LIST_PARAMETER_IDD')
        ->where('PARAMETER_ID','=',$id)
        ->first();
      
        $list = DB::table('env_list_parameter')
        ->get();
        
        $listter = DB::table('env_list_parameter')       
        ->first();       

        $parametersub = DB::table('env_parameter_sub')
        ->first();
     
        return view('manager_env.watertreatment_edit',[
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id,
            'infopers'=>$infoper,
            'parameter_subs'=>$parameter_sub,
            'parametersubs'=>$parametersub,
            'parameters'=>$parameter,
            'lists'=>$list,
        ]);
    }  
    public function watertreatment_update(Request $request)
    {
        $dateelect = $request->get('PARAMETER_DATE');
        $datelocation = $request->get('LOCATION_EXDATE');
        $dateexample = $request->get('GROUP_EXCAMPLEDATE');
        
        $date_bigin = Carbon::createFromFormat('d/m/Y', $dateelect)->format('Y-m-d');
        $date_arrary=explode("-",$date_bigin);
        $y_sub_st = $date_arrary[0];
    
        if($y_sub_st >= 2500){
            $y = $y_sub_st-543;
        }else{
            $y = $y_sub_st;
        }    
        $m = $date_arrary[1];
        $d = $date_arrary[2];  
        $dateelect_s= $y."-".$m."-".$d;

        $date_bigin2 = Carbon::createFromFormat('d/m/Y', $datelocation)->format('Y-m-d');
        $date_arrary=explode("-",$date_bigin2);
        $y_sub_st = $date_arrary[0];
    
        if($y_sub_st >= 2500){
            $y = $y_sub_st-543;
        }else{
            $y = $y_sub_st;
        }    
        $m = $date_arrary[1];
        $d = $date_arrary[2];  
        $date_location= $y."-".$m."-".$d;

        $date_bigin3 = Carbon::createFromFormat('d/m/Y', $dateexample)->format('Y-m-d');
        $date_arrary=explode("-",$date_bigin3);
        $y_sub_st = $date_arrary[0];
    
        if($y_sub_st >= 2500){
            $y = $y_sub_st-543;
        }else{
            $y = $y_sub_st;
        }    
        $m = $date_arrary[1];
        $d = $date_arrary[2];  
        $date_example= $y."-".$m."-".$d;
        
        $id =  $request->PARAMETER_ID;

        $update = Env_parameter::find($id);
        $update->PARAMETER_DATE = $dateelect_s;
        $update->PARAMETER_YEAR = $request->PARAMETER_YEAR;
        $update->PARAMETER_USER = $request->PARAMETER_USER;

        $update->LOCATION_EX = $request->LOCATION_EX;
        $update->GROUP_EXCAMPLE = $request->GROUP_EXCAMPLE;
        $update->LOCATION_EXDATE = $date_location;
        $update->GROUP_EXCAMPLEDATE = $date_example;
        $update->USER_EXCAMPLE = $request->USER_EXCAMPLE;

        $update->PARAMETER_COMMENT = $request->PARAMETER_COMMENT;
        $update->save();

        Env_parameter_sub::where('PARAMETER_ID','=',$id)->delete();

        if($request->LIST_PARAMETER_ID != '' || $request->LIST_PARAMETER_ID != null){

            $LIST_PARAMETER_ID = $request->LIST_PARAMETER_ID;
            $LIST_PARAMETER_UNIT = $request->LIST_PARAMETER_UNIT;

            $ANALYSIS_RESULTS = $request->ANALYSIS_RESULTS;
            $LIST_USEANALYSIS_RESULTS = $request->LIST_USEANALYSIS_RESULTS;
      
                                
            $number =count($LIST_PARAMETER_ID);
            $count = 0;
            for($count = 0; $count< $number; $count++)
            {     

                $idlist = DB::table('env_list_parameter')->where('LIST_PARAMETER_ID','=',$LIST_PARAMETER_ID[$count])->first();

                $add_sub = new Env_parameter_sub();
                $add_sub->PARAMETER_ID = $id;    
                $add_sub->LIST_PARAMETER_IDD = $idlist->LIST_PARAMETER_ID;
                $add_sub->LIST_PARAMETER_DETAIL = $idlist->LIST_PARAMETER_DETAIL;  
                $add_sub->LIST_PARAMETER_UNIT = $LIST_PARAMETER_UNIT[$count];  
                $add_sub->ANALYSIS_RESULTS = $ANALYSIS_RESULTS[$count];
                $add_sub->USEANALYSIS_RESULTS = $LIST_USEANALYSIS_RESULTS[$count];
                $add_sub->save();                            
               
                
            }
        }
        return redirect()->route('menv.watertreatment');
    }
    public function watertreatment_destroy(Request $request,$id)
    {            
        Env_parameter::destroy($id);
        Env_parameter_sub::where('PARAMETER_ID',$id)->delete();
        return redirect()->route('menv.watertreatment');
    }           
   //========================= ตั้งค่า ====รายการตรวจเช็คออกซิเจนเหลว==============================// 
   public function set_oxigen()
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

       $set_oxigen = DB::table('env_oxigen_set')->get();

       return view('manager_env.set_oxigen_index',[
           'budgets' =>  $budget,
           'displaydate_bigen'=> $displaydate_bigen,
           'displaydate_end'=> $displaydate_end,
           'status_check'=> $status,
           'search'=> $search,
           'year_id'=>$year_id,
           'set_oxigens'=>$set_oxigen,
       ]);
   }
   public function set_oxigen_add()
   {
   
       return view('manager_env.set_oxigen_add');
   }
   public function set_oxigen_save(Request $request)
   {
       $add = new Env_oxigen_set();
       $add->SET_OXIGEN_NAME = $request->SET_OXIGEN_NAME;
       $add->SET_OXIGEN_UNIT = $request->SET_OXIGEN_UNIT;
       $add->save(); 

       return redirect()->route('set_env.set_oxigen');
       
   }
   public function set_oxigen_edit(Request $request,$id)
   {
       $set_oxigen = DB::table('env_oxigen_set')->where('SET_OXIGEN_ID','=',$id)->first();

       return view('manager_env.set_oxigen_edit',[
           'set_oxigens'=>$set_oxigen,
       ]);
   }
   public function set_oxigen_update(Request $request)
   {
       $id = $request->SET_OXIGEN_ID;
       $update = Env_oxigen_set::find($id);
       $update->SET_OXIGEN_NAME = $request->SET_OXIGEN_NAME;
       $update->SET_OXIGEN_UNIT = $request->SET_OXIGEN_UNIT;
       $update->save(); 
       return redirect()->route('set_env.set_oxigen');
   }
   public function set_oxigen_destroy(Request $request,$id)
   {            
    Env_oxigen_set::destroy($id);

       return redirect()->route('set_env.set_oxigen');
   }
 
//========================= ตั้งค่า ====ระบบไฟฟ้า==============================// 
    public function list_check()
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

        $list_check = Env_list_check::get();
        return view('manager_env.list_check',[
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id,
            'list_checks'=>$list_check,
        ]);
    }
    public function list_check_add()
    {
    
        return view('manager_env.list_check_add');
    }
    public function list_check_save(Request $request)
    {
        $add = new Env_list_check();
        $add->LIST_CHECK_DETAIL = $request->LIST_CHECK_DETAIL;
        $add->save(); 

        return redirect()->route('menv.list_check');
    }
    public function list_check_edit(Request $request,$id)
    {
        $list_check = DB::table('env_list_check')->where('LIST_CHECK_ID','=',$id)->first();

        return view('manager_env.list_check_edit',[
            'list_checks'=>$list_check,
        ]);
    }
    public function list_check_update(Request $request)
    {
        $id = $request->LIST_CHECK_ID;
        $update = Env_list_check::find($id);
        $update->LIST_CHECK_DETAIL = $request->LIST_CHECK_DETAIL;
        $update->save(); 
        return redirect()->route('menv.list_check');
    }
    public function list_check_destroy(Request $request,$id)
    {            
        Env_list_check::destroy($id);

        return redirect()->route('menv.list_check');
    }

//========================= ตั้งค่า ====ระบบบำบัดน้ำเสีย==============================// 
    public function list_parameter()
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

        $list_parameter = Env_list_parameter::get();
        return view('manager_env.list_parameter',[
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id,
            'list_parameters'=>$list_parameter,
        ]);
    }
    public function list_parameter_add()
    {
        return view('manager_env.list_parameter_add');
    }
    public function list_parameter_save(Request $request)
    {
        $add = new Env_list_parameter();
        $add->LIST_PARAMETER_DETAIL = $request->LIST_PARAMETER_DETAIL;
        $add->LIST_PARAMETER_UNIT = $request->LIST_PARAMETER_UNIT;
        $add->LIST_USEANALYSIS_RESULTS = $request->LIST_USEANALYSIS_RESULTS;
        $add->LIST_PARAMETER_NORMAL = $request->LIST_PARAMETER_NORMAL;
        $add->save(); 

        return redirect()->route('menv.list_parameter');
    }
    public function list_parameter_edit(Request $request,$id)
    {
        $list_parameter = DB::table('env_list_parameter')->where('LIST_PARAMETER_ID','=',$id)->first();

        return view('manager_env.list_parameter_edit',[
            'list_parameters'=>$list_parameter,
        ]);
    }
    public function list_parameter_update(Request $request)
    {
        $id = $request->LIST_PARAMETER_ID;
        $update = Env_list_parameter::find($id);
        $update->LIST_PARAMETER_DETAIL = $request->LIST_PARAMETER_DETAIL;
        $update->LIST_PARAMETER_UNIT = $request->LIST_PARAMETER_UNIT;
        $update->LIST_USEANALYSIS_RESULTS = $request->LIST_USEANALYSIS_RESULTS;
        $update->LIST_PARAMETER_NORMAL = $request->LIST_PARAMETER_NORMAL;
        $update->save(); 
        return redirect()->route('menv.list_parameter');
    }
    public function list_parameter_destroy(Request $request,$id)
    {            
        Env_list_parameter::destroy($id);

        return redirect()->route('menv.list_parameter');
    }
//========================= ตั้งค่า ====ระบบขยะติดเชื้อ==============================// 
    public function set_trash()
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

        $trash_set = Env_trash_set::get();
        return view('manager_env.set_trash',[
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id,
            'trash_sets'=>$trash_set,
        ]);
    }
    public function set_trash_add()
    {
        return view('manager_env.set_trash_add');
    }
    public function set_trash_save(Request $request)
    {
        $add = new Env_trash_set();
        $add->SET_TRASH_NAME = $request->SET_TRASH_NAME;
        $add->SET_TRASH_UNIT = $request->SET_TRASH_UNIT;
        $add->save(); 

        return redirect()->route('set_env.set_trash');
    }
    public function set_trash_edit(Request $request,$id)
    {
        $trash_set = Env_trash_set::where('SET_TRASH_ID','=',$id)->first();

        return view('manager_env.set_trash_edit',[
            'trash_sets'=>$trash_set,
        ]);
    }
    public function set_trash_update(Request $request)
    {
        $id = $request->SET_TRASH_ID;
        $update = Env_trash_set::find($id);
        $update->SET_TRASH_NAME = $request->SET_TRASH_NAME;
        $update->SET_TRASH_UNIT = $request->SET_TRASH_UNIT;
        $update->save(); 
        return redirect()->route('set_env.set_trash');
    }
    public function set_trash_destroy(Request $request,$id)
    {            
        Env_trash_set::destroy($id);

        return redirect()->route('set_env.set_trash');
    }



    public static function total_parameter($LIST_PARAMETER_ID,$PARAMETER_ID)
    {

        $item = DB::table('env_parameter_sub')
        ->where('LIST_PARAMETER_IDD','=',$LIST_PARAMETER_ID)
        ->where('PARAMETER_ID','=',$PARAMETER_ID)
        ->first();      
         
        if($item <> '' && $item <> null){
            $result = $item->ANALYSIS_RESULTS;
        }else{
            $result = '';
        }                                                                                                                             


        return $result;
    }



}

