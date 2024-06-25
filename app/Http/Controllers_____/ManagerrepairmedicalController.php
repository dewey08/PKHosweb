<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Person;
use App\Models\Informrepairindex;
use App\Models\Informrepairindextech;
use App\Models\Informrepairservice;

use App\Models\Assetcarerepair;
use App\Models\Assetcarerepairtech;
use App\Models\Assetcarerepairservice;
use App\Models\Assetcarerepairplan;
use App\Models\Assetcarerepairplansub;
use App\Models\Assetcarecalibration;
use App\Models\Assetcarecalibration_sub;
use App\Models\Asset_care_calibration_true;
use App\Models\Asset_care_calibration_true_sub;
use App\Models\Asset_care_calibration_list;
use App\Models\Assetcarelist;
use App\Models\Assetcaresystemtype;
use App\Models\Infomrepair_functionmedical;

use App\Http\Controllers\Report\InformrepairmedicalReportController;

date_default_timezone_set("Asia/Bangkok");

class ManagerrepairmedicalController extends Controller
{
    public function dashboard()
    {
        $data['budgetyear']          = getBudgetYear();
        $year_now                    = $data['budgetyear'] - 543; // ปี ค.ศ. ปัจจุบัน กำหนดก่อนมีการเลือกจาก dashboard
        $data['budgetyear_dropdown'] = getBudgetYearAmount();
        if (!empty($_GET['budgetyear'])) {
            $data['budgetyear'] = $_GET['budgetyear'];
        }
        $year                  = $data['budgetyear']; // ปี พ.ศ.
        $year_ad               = $year - 543; // ปี ค.ศ.   // แยกใช้ตามแต่ฟังก์ชั่น
        
        $repairmedicalReport = new InformrepairmedicalReportController();
        $data['countRepairmedical_all'] = $repairmedicalReport->countRepairmedicalBystatus('all',$year_ad);
        $data['countRepairmedical_request'] = $repairmedicalReport->countRepairmedicalBystatus('REQUEST',$year_ad);
        $data['countRepairmedical_receive'] = $repairmedicalReport->countRepairmedicalBystatus('RECEIVE',$year_ad);
        $data['countRepairmedical_pending'] = $repairmedicalReport->countRepairmedicalBystatus('PENDING',$year_ad);
        $data['countRepairmedical_success'] = $repairmedicalReport->countRepairmedicalBystatus('SUCCESS',$year_ad);
        $data['countRepairmedical_outside'] = $repairmedicalReport->countRepairmedicalBystatus('OUTSIDE',$year_ad);
        $data['countRepairmedical_deal'] = $repairmedicalReport->countRepairmedicalBystatus('DEAL',$year_ad);
        $data['countRepairmedical_repair_out'] = $repairmedicalReport->countRepairmedicalBystatus('REPAIR_OUT',$year_ad);
        $data['countRepairmedical_cancel'] = $repairmedicalReport->countRepairmedicalBystatus('CANCEL',$year_ad);
        $endmonth = date('Y-m-d',strtotime(date('Y-m-1'). ' +1month-1day'));
        $data['repairmedical_day'] = $repairmedicalReport->countRepairmedicalBybetween(date('Y-m-d'),date('Y-m-d'));
        $data['repairmedical_month'] = $repairmedicalReport->countRepairmedicalBybetween(date('Y-m-1'),$endmonth);
        $data['repairmedical_year'] = $repairmedicalReport->countRepairmedicalBybetween(date(($year_ad-1).'-10-1'),date($year_ad.'-09-30'));
        $data['repairmedicalPlan_day'] = $repairmedicalReport->countRepairmedicalplanBybetween(date('Y-m-d'),date('Y-m-d'));
        $data['repairmedicalPlan_month'] = $repairmedicalReport->countRepairmedicalplanBybetween(date('Y-m-1'),$endmonth);
        $data['repairmedicalPlan_year'] = $repairmedicalReport->countRepairmedicalplanBybetween(date(($year_ad-1).'-10-1'),date($year_ad.'-09-30'));
        $data['repairmedical_M'] =  $repairmedicalReport->countRepairmedical_M($year_ad);
        $data['repairmedical_M_success'] =  $repairmedicalReport->countRepairmedical_M_success($year_ad);
        $data['repairmedical_score'] =  $repairmedicalReport->countRepairmedicalFancinessScore($year_ad);
        $data['repairmedicalPlan_result'] =  $repairmedicalReport->countRepairmedicalplan_Result($year_ad);
        $workperson =  $repairmedicalReport->countWorkofperson($year_ad);
        $w_person = array();
        foreach($workperson as $row){
            $w_person[$row['id']]['name'] = $repairmedicalReport->getNameTechByperson_id($row['id']);
            $w_person[$row['id']]['amount'] = $row['count'];
        }
        $data['workofperson'] = $w_person;
        $data['countRepairPlan_M'] =  $repairmedicalReport->countRepairPlan_M($year_ad);
        return view('manager_repairmedical.dashboard_repairmedical',$data);
    }

    public function repairmedical_search()
    {
        $data['budgetyear']          = getBudgetYear();
        $year_now                    = $data['budgetyear'] - 543; // ปี ค.ศ. ปัจจุบัน กำหนดก่อนมีการเลือกจาก dashboard
        $data['budgetyear_dropdown'] = getBudgetYearAmount();
        if (!empty($_GET['budgetyear'])) {
            $data['budgetyear'] = $_GET['budgetyear'];
        }
        $year                  = $data['budgetyear']; // ปี พ.ศ.
        $year_ad               = $year - 543; // ปี ค.ศ.   // แยกใช้ตามแต่ฟังก์ชัน
        $unshift_status = (object) array(
            "STATUS_ID" => 'all',
            "STATUS_NAME"=> "all",
            "STATUS_NAME_TH"=> "ทั้งหมด",
            "updated_at"=> null,
            "created_at"=> null
        );
        $data['repairstatus_dropdown'] = DB::table('informrepair_status')->get()->toArray();
        array_unshift($data['repairstatus_dropdown'],$unshift_status);
        $data['repairstatus'] = 'all';
        if (!empty($_GET['repairstatus'])) {
            $data['repairstatus'] = $_GET['repairstatus'];
        }
        $repairmedical = new InformrepairmedicalReportController();
        $data['repairmedical'] = $repairmedical->getRepairmedical_Bybudgetyear_status($year_ad , $data['repairstatus']);
        return view('manager_repairmedical.repairmedical_search',$data);
    }

    public function dashboardsearch(Request $request)
    {
       
        $year_id = $request->STATUS_CODE;
        $year = $year_id - 543;
      
        $amount_1 = DB::table('asset_care_repair')->where('DATE_TIME_REQUEST','like',date('Y').'%')->count();
        $amount_2 = DB::table('asset_care_repair')->where('REPAIR_STATUS','=','REQUEST')->where('DATE_TIME_REQUEST','like',$year.'%')->count();
        $amount_3 = DB::table('asset_care_repair')->where('REPAIR_STATUS','=','PENDING')->where('DATE_TIME_REQUEST','like',$year.'%')->count();
        $amount_4 = DB::table('asset_care_repair')->where('REPAIR_STATUS','=','SUCCESS')->where('DATE_TIME_REQUEST','like',$year.'%')->count();
        $amount_5 = DB::table('asset_care_repair')->where('REPAIR_STATUS','=','CANCEL')->where('DATE_TIME_REQUEST','like',$year.'%')->count();
        $amount_6 = DB::table('asset_care_repair')->where('REPAIR_STATUS','=','OUTSIDE')->where('DATE_TIME_REQUEST','like',$year.'%')->count();
    
        $amount_7 = DB::table('asset_care_repair')->where('REPAIR_STATUS','=','RECEIVE')->where('DATE_TIME_REQUEST','like',$year.'%')->count();
        $amount_8 = DB::table('asset_care_repair')->where('REPAIR_STATUS','=','DEAL')->where('DATE_TIME_REQUEST','like',$year.'%')->count();

        $amount_repairdate = DB::table('informrepair_index')->where('REPAIR_STATUS','=','REQUEST')->where('DATE_TIME_REQUEST','like',date('Y-m-d').'%')->count();
        $amount_repair = DB::table('informrepair_index')->where('REPAIR_STATUS','=','REQUEST')->where('DATE_TIME_REQUEST','like',$year.'%')->count();

        $amount_checkdate = DB::table('asset_care_repair_plan')->where('REPAIR_RESULT','=',NULL)->where('REPAIR_PLAN_DATE','like',date('Y-m-d'))->count();
        $amount_check = DB::table('asset_care_repair_plan')->where('REPAIR_RESULT','=',NULL)->where('REPAIR_PLAN_DATE','like',$year.'%')->count();
    
        $m1 = DB::table('asset_care_repair')->where('DATE_TIME_REQUEST','like',$year.'-01%')->count();
        $m2 = DB::table('asset_care_repair')->where('DATE_TIME_REQUEST','like',$year.'-02%')->count();
        $m3 = DB::table('asset_care_repair')->where('DATE_TIME_REQUEST','like',$year.'-03%')->count();
        $m4 = DB::table('asset_care_repair')->where('DATE_TIME_REQUEST','like',$year.'-04%')->count();
        $m5 = DB::table('asset_care_repair')->where('DATE_TIME_REQUEST','like',$year.'-05%')->count();
        $m6 = DB::table('asset_care_repair')->where('DATE_TIME_REQUEST','like',$year.'-06%')->count();
        $m7 = DB::table('asset_care_repair')->where('DATE_TIME_REQUEST','like',$year.'-07%')->count();
        $m8 = DB::table('asset_care_repair')->where('DATE_TIME_REQUEST','like',$year.'-08%')->count();
        $m9 = DB::table('asset_care_repair')->where('DATE_TIME_REQUEST','like',$year.'-09%')->count();
        $m10 = DB::table('asset_care_repair')->where('DATE_TIME_REQUEST','like',$year.'-10%')->count();
        $m11 = DB::table('asset_care_repair')->where('DATE_TIME_REQUEST','like',$year.'-11%')->count();
        $m12 = DB::table('asset_care_repair')->where('DATE_TIME_REQUEST','like',$year.'-12%')->count();
         
        $REQUEST = DB::table('asset_care_repair')->where('REPAIR_STATUS','=','REQUEST')->where('DATE_TIME_REQUEST','like',$year.'%')->count();
        $RECEIVE = DB::table('asset_care_repair')->where('REPAIR_STATUS','=','RECEIVE')->where('DATE_TIME_REQUEST','like',$year.'%')->count();
        $PENDING = DB::table('asset_care_repair')->where('REPAIR_STATUS','=','PENDING')->where('DATE_TIME_REQUEST','like',$year.'%')->count();
        $SUCCESS = DB::table('asset_care_repair')->where('REPAIR_STATUS','=','SUCCESS')->where('DATE_TIME_REQUEST','like',$year.'%')->count();
        $OUTSIDE = DB::table('asset_care_repair')->where('REPAIR_STATUS','=','OUTSIDE')->where('DATE_TIME_REQUEST','like',$year.'%')->count();
        $DEAL = DB::table('asset_care_repair')->where('REPAIR_STATUS','=','DEAL')->where('DATE_TIME_REQUEST','like',$year.'%')->count();
        $CANCEL = DB::table('asset_care_repair')->where('REPAIR_STATUS','=','CANCEL')->where('DATE_TIME_REQUEST','like',$year.'%')->count();
     
        
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

       

        return view('manager_repairmedical.dashboard_repairmedical',[
            'amount1' => $amount_1,
            'amount2' => $amount_2,
            'amount3' => $amount_3,
            'amount4' => $amount_4,
            'amount5' => $amount_5,
            'amount6' => $amount_6,
            'amount7' => $amount_7,
            'amount8' => $amount_8,
            'amountrepairdate' => $amount_repairdate,
            'amountrepair' => $amount_repair,
            'amountcheckdate' => $amount_checkdate,
            'amountcheck' => $amount_check,
            'm1' => $m1,
            'm2' => $m2,
            'm3' => $m3,
            'm4' => $m4,
            'm5' => $m5,
            'm6' => $m6,
            'm7' => $m7,
            'm8' => $m8,
            'm9' => $m9,
            'm10' => $m10,
            'm11' => $m11,
            'm12' => $m12,
            'REQUEST' => $REQUEST,
            'RECEIVE' => $RECEIVE,
            'PENDING' => $PENDING,
            'SUCCESS' => $SUCCESS,
            'OUTSIDE' => $OUTSIDE,
            'DEAL' => $DEAL,
            'CANCEL' => $CANCEL,
            'budgets' =>  $budget,
            'year_id'=>$year_id


        ]);
    }


    public function deatailcalendar()
    {
        $inforepairmedical = DB::table('asset_care_repair_plan')->get();
    
        return view('manager_repairmedical.carcalendar_repairmedical',[
            'inforepairmedicals' => $inforepairmedical
        ]);
    }
    

    public function repairmedicalinfo(Request $request)
    {
        if(!empty($request->_token)){
            $search     = $request->get('search');
            $status     = $request->SEND_STATUS;
            $datebigin  = $request->get('DATE_BIGIN');
            $dateend    = $request->get('DATE_END');
            $yearbudget = $request->BUDGET_YEAR;
            session([
                'manager_repairmedical.repairmedicalinfo.search' => $search,
                'manager_repairmedical.repairmedicalinfo.status' => $status,
                'manager_repairmedical.repairmedicalinfo.datebigin' => $datebigin,
                'manager_repairmedical.repairmedicalinfo.dateend' => $dateend,
                'manager_repairmedical.repairmedicalinfo.yearbudget' => $yearbudget
                ]);
        }elseif(!empty(session('manager_repairmedical.repairmedicalinfo'))){
            $search     = session('manager_repairmedical.repairmedicalinfo.search');
            $status     = session('manager_repairmedical.repairmedicalinfo.status');
            $datebigin  = session('manager_repairmedical.repairmedicalinfo.datebigin');
            $dateend    = session('manager_repairmedical.repairmedicalinfo.dateend');
            $yearbudget = session('manager_repairmedical.repairmedicalinfo.yearbudget');
        }else{
            $search     = '';
            $status     = 'REQUEST';
            $datebigin = '01/10/'.(getBudgetyear()-1);
            $dateend   = '30/09/'.getBudgetyear();
            $yearbudget = getBudgetyear();
        }
        
        if($datebigin == '' || $dateend == ''){
            $displaydate_bigen = '';
            $displaydate_end = '';
        }else{    
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
        $date_bigen_checks = strtotime($displaydate_bigen);
        $date_end_checks =  strtotime($displaydate_end);
        $dates =  strtotime($date);
        }
            $from = date($displaydate_bigen);
            $to = date($displaydate_end);
            if($status == null){
                $inforepairmedical = Assetcarerepair::select('asset_article.ARTICLE_NUM','REPAIR_ID','REPAIR_STATUS','PRIORITY_ID','FANCINESS_SCORE','DATE_TIME_REQUEST','REPAIR_NAME','SYMPTOM','USRE_REQUEST_NAME','HR_DEPARTMENT_SUB_SUB_NAME','BUILD_NAME','TECH_REPAIR_NAME','BUILD_NAME','asset_care_repair.ID')
                    ->leftjoin('hrd_person','asset_care_repair.USER_REQUEST_ID','=','hrd_person.ID')
                    ->leftjoin('asset_article','asset_care_repair.ARTICLE_ID','=','asset_article.ARTICLE_ID')
                ->leftjoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_SUB_ID')
                ->leftjoin('asset_building','asset_care_repair.LOCATION_SEE_ID','=','asset_building.ID')
                ->where(function($q) use ($search){
                    $q->where('REPAIR_ID','like','%'.$search.'%');
                    $q->orwhere('REPAIR_NAME','like','%'.$search.'%');
                    $q->orwhere('SYMPTOM','like','%'.$search.'%');
                    $q->orwhere('USRE_REQUEST_NAME','like','%'.$search.'%');
                    })
                    ->WhereBetween('DATE_SAVE',[$from,$to]) 
                ->orderBy('PRIORITY_ID', 'desc')->get(); 
            }else{
                $inforepairmedical = Assetcarerepair::select('asset_article.ARTICLE_NUM','REPAIR_ID','REPAIR_STATUS','PRIORITY_ID','FANCINESS_SCORE','DATE_TIME_REQUEST','REPAIR_NAME','SYMPTOM','USRE_REQUEST_NAME','HR_DEPARTMENT_SUB_SUB_NAME','BUILD_NAME','TECH_REPAIR_NAME','BUILD_NAME','asset_care_repair.ID')
                    ->leftjoin('hrd_person','asset_care_repair.USER_REQUEST_ID','=','hrd_person.ID')
                    ->leftjoin('asset_article','asset_care_repair.ARTICLE_ID','=','asset_article.ARTICLE_ID')
                ->leftjoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_SUB_ID')
                ->leftjoin('asset_building','asset_care_repair.LOCATION_SEE_ID','=','asset_building.ID')
                ->where('REPAIR_STATUS','=',$status)
                ->where(function($q) use ($search){
                    $q->where('REPAIR_ID','like','%'.$search.'%');
                    $q->orwhere('REPAIR_NAME','like','%'.$search.'%');
                    $q->orwhere('SYMPTOM','like','%'.$search.'%');
                    $q->orwhere('USRE_REQUEST_NAME','like','%'.$search.'%');
                    })
                    ->WhereBetween('DATE_SAVE',[$from,$to]) 
                ->orderBy('PRIORITY_ID', 'desc')->get(); 
            }
       
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $year_id = $yearbudget;
        $infostatus = DB::table('informrepair_status')->get();
       
        $checkpdf = DB::table('infomrepair_function')->where('ACTIVE','=','True')->count();
         $checfunc = DB::table('asset_care_setupfunc')->where('ACTIVE','=','True')->count();
      
        $openform_function = Infomrepair_functionmedical::where('FUNCT_REPMEDICAL_STATUS','=','True' )->first();

        if ($openform_function != '') {       
            $code = $openform_function->FUNCT_REPMEDICAL_CODE;  
        } else {                      
            $code = '';
        }

        return view('manager_repairmedical.inforepairmedical',[
            'inforepairmedicals' => $inforepairmedical,
            'infostatuss' => $infostatus, 
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id,
            'checkpdf'=>$checkpdf,
            'codes'=>$code,
            'checfunc'=>$checfunc,
        ]);
    
    }

    
    public function repairmedicalinfosearch(Request $request)
    {

        $search = $request->get('search');
        $status = $request->SEND_STATUS;
        $datebigin = $request->get('DATE_BIGIN');
        $dateend = $request->get('DATE_END');
        $yearbudget = $request->BUDGET_YEAR;

        if($search==''){
            $search="";
        }


        if($datebigin == '' || $dateend == ''){
            $displaydate_bigen = '';
            $displaydate_end = '';
        }else{    

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
        $date_bigen_checks = strtotime($displaydate_bigen);
        $date_end_checks =  strtotime($displaydate_end);
        $dates =  strtotime($date);
           
        }
    

            $from = date($displaydate_bigen);
            $to = date($displaydate_end);

            
            if($status == null){


                $inforepairmedical = Assetcarerepair::select('asset_article.ARTICLE_NUM','REPAIR_ID','REPAIR_STATUS','PRIORITY_ID','FANCINESS_SCORE','DATE_TIME_REQUEST','REPAIR_NAME','SYMPTOM','USRE_REQUEST_NAME','HR_DEPARTMENT_SUB_SUB_NAME','BUILD_NAME','TECH_REPAIR_NAME','BUILD_NAME','asset_care_repair.ID')
                    ->leftjoin('hrd_person','asset_care_repair.USER_REQUEST_ID','=','hrd_person.ID')
                    ->leftjoin('asset_article','asset_care_repair.ARTICLE_ID','=','asset_article.ARTICLE_ID')
                ->leftjoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_SUB_ID')
                ->leftjoin('asset_building','asset_care_repair.LOCATION_SEE_ID','=','asset_building.ID')
                ->where(function($q) use ($search){
                    $q->where('REPAIR_ID','like','%'.$search.'%');
                    $q->orwhere('REPAIR_NAME','like','%'.$search.'%');
                    $q->orwhere('SYMPTOM','like','%'.$search.'%');
                    $q->orwhere('USRE_REQUEST_NAME','like','%'.$search.'%');
                    })
                    ->WhereBetween('DATE_SAVE',[$from,$to]) 
                ->orderBy('PRIORITY_ID', 'desc')->get(); 



            }else{


                $inforepairmedical = Assetcarerepair::select('asset_article.ARTICLE_NUM','REPAIR_ID','REPAIR_STATUS','PRIORITY_ID','FANCINESS_SCORE','DATE_TIME_REQUEST','REPAIR_NAME','SYMPTOM','USRE_REQUEST_NAME','HR_DEPARTMENT_SUB_SUB_NAME','BUILD_NAME','TECH_REPAIR_NAME','BUILD_NAME','asset_care_repair.ID')
                    ->leftjoin('hrd_person','asset_care_repair.USER_REQUEST_ID','=','hrd_person.ID')
                    ->leftjoin('asset_article','asset_care_repair.ARTICLE_ID','=','asset_article.ARTICLE_ID')
                ->leftjoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_SUB_ID')
                ->leftjoin('asset_building','asset_care_repair.LOCATION_SEE_ID','=','asset_building.ID')
                ->where('REPAIR_STATUS','=',$status)
                ->where(function($q) use ($search){
                    $q->where('REPAIR_ID','like','%'.$search.'%');
                    $q->orwhere('REPAIR_NAME','like','%'.$search.'%');
                    $q->orwhere('SYMPTOM','like','%'.$search.'%');
                    $q->orwhere('USRE_REQUEST_NAME','like','%'.$search.'%');
                    })
                    ->WhereBetween('DATE_SAVE',[$from,$to]) 
                ->orderBy('PRIORITY_ID', 'desc')->get(); 

            
            }
    

       
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $year_id = $yearbudget;
        
      

        $infostatus = DB::table('informrepair_status')->get();


        
        return view('manager_repairmedical.inforepairmedical',[
            'inforepairmedicals' => $inforepairmedical,
            'infostatuss' => $infostatus, 
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id,
     
        ]);


    }

    //-----------------------รีไดเรค---------------------------------------------

    public function repairmedicalinfore(Request $request,$status)
    {

      
        $status = $status;
    
        $inforepairmedical = Assetcarerepair::where('REPAIR_STATUS','=',$status)->orderBy('ID', 'desc')->get(); 

        $infostatus = DB::table('informrepair_status')->get();
       
     

        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;
        }
        
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';
        $status = 'RECEIVE';
        $search = ''; 
        $year_id = $yearbudget;
        
        return view('manager_repairmedical.inforepairmedical',[
            'inforepairmedicals' => $inforepairmedical,
            'infostatuss' => $infostatus, 
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id,

     
        ]);


    }

    //---------------------------------แก้ไขรายละเอียด----------------------------------

    public function repairmedicaledit(Request $request,$id)
    {
         $infoasset = DB::table('asset_article')->where('TYPE_SUB_ID','=',31)->get();
         $infolocation = DB::table('supplies_location')->get();

          $informrepair_tech = DB::table('asset_care_enginer')
        ->leftJoin('hrd_person','hrd_person.ID','=','asset_care_enginer.PERSON_ID')
        ->get();

         $inforepairmedical = Assetcarerepair::where('asset_care_repair.ID', '=',$id)
         ->select(DB::raw('asset_care_repair.* , asset_article.* , hrd_department_sub_sub.*'))
         ->leftjoin('asset_article','asset_care_repair.ARTICLE_ID','asset_article.ARTICLE_ID')
         ->leftjoin('hrd_person','asset_care_repair.TECH_REPAIR_ID','hrd_person.ID')
         ->leftjoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','hrd_person.HR_DEPARTMENT_SUB_SUB_ID')
         ->first(); 

          $infoassetother = DB::table('informrepair_other')->get();

          

          if($inforepairmedical->LOCATION_SEE_ID != ''){
            $infolocationlevel= DB::table('supplies_location_level')->where('LOCATION_ID','=',$inforepairmedical->LOCATION_SEE_ID)->get();
          }
          else{
            $infolocationlevel= '';      
          }   
          

          if($inforepairmedical->LOCATIONLEVEL_SEE_ID != ''){
            $infolocationlevelroom= DB::table('supplies_location_level_room')->where('LOCATION_LEVEL_ID','=',$inforepairmedical->LOCATIONLEVEL_SEE_ID)->get();
          }
          else{
            $infolocationlevelroom= '';      
          }   


          
          
        return view('manager_repairmedical.inforepairmedical_edit',[
            'infoassets' => $infoasset,
            'infolocations' => $infolocation,
            'infolocationlevels' => $infolocationlevel,
            'infolocationlevelrooms' => $infolocationlevelroom, 
            'informrepair_techs' => $informrepair_tech,
            'inforepairmedical' => $inforepairmedical,
            'infoassetothers' => $infoassetother,
        
            
        ]);
    }


    public function updateinforepairmedical(Request $request)
    {

       $DATE_1 = $request->DATE_REQUEST;


       if($DATE_1 != ''){
        $STARTDAY = Carbon::createFromFormat('d/m/Y', $DATE_1)->format('Y-m-d');
        $date_arrary_st=explode("-",$STARTDAY);  
        $y_sub_st = $date_arrary_st[0]; 
        
        if($y_sub_st >= 2500){
            $y_st = $y_sub_st-543;
        }else{
            $y_st = $y_sub_st;
        }
        $m_st = $date_arrary_st[1];
        $d_st = $date_arrary_st[2];  
        $DATE_1= $y_st."-".$m_st."-".$d_st;
        }else{
        $DATE_1= null;
     }
     
            $datere = $DATE_1." ".$request->TIME_REQUEST.":00";
      
            $ID = $request->ID;

            $addinforepair = Assetcarerepair::find($ID);
            $addinforepair->DATE_TIME_REQUEST = $datere; 
            $addinforepair->REPAIR_NAME = $request->REPAIR_NAME;
            $addinforepair->LOCATION_SEE_ID = $request->LOCATION_SEE_ID;
            $addinforepair->LOCATIONLEVEL_SEE_ID = $request->LOCATIONLEVEL_SEE_ID;
            $addinforepair->LOCATIONLEVELROOM_SEE_ID = $request->LOCATIONLEVELROOM_SEE_ID;


            if($request->ARTICLE_ID != ''){
                $addinforepair->ARTICLE_ID = $request->ARTICLE_ID;
                }
          
            $addinforepair->OTHER_NAME = $request->OTHER_NAME;

        
            
         if($request->hasFile('picture')){
            
            $file = $request->file('picture');  
            $contents = $file->openFile()->fread($file->getSize());
            $addinforepair->REPAIR_IMG = $contents;   

        }
       
         $addinforepair->TECH_REPAIR_ID = $request->TECH_REPAIR_ID;

            //----------------------------------
            $TECH_REPAIR_NAME =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
            ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
            ->where('hrd_person.ID','=',$request->TECH_REPAIR_ID)->first();
            $addinforepair->TECH_REPAIR_NAME   = $TECH_REPAIR_NAME->HR_PREFIX_NAME.''.$TECH_REPAIR_NAME->HR_FNAME.' '.$TECH_REPAIR_NAME->HR_LNAME;

            //----------------------------------

           $addinforepair->PRIORITY_ID = $request->PRIORITY_ID;
           $addinforepair->REPAIR_STATUS = 'REQUEST';
           $addinforepair->save();


            return redirect()->route('mrepairmedical.repairmedicalinfo'); 

    }

    

//------------------------------------------------------------

    public function detailrepairmedical(Request $request)
    {
        function DateThai($strDate)
        {
        $strYear = date("Y",strtotime($strDate))+543;
        $strMonth= date("n",strtotime($strDate));
        $strDay= date("j",strtotime($strDate));
    
        $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
        $strMonthThai=$strMonthCut[$strMonth];
        return "$strDay $strMonthThai $strYear";
        }
    
        function formateDatetime($strDate)
        {
          $strYear = date("Y",strtotime($strDate))+543;
          $strMonth= date("n",strtotime($strDate));
          $strDay= date("j",strtotime($strDate));
      
          $H= date("H",strtotime($strDate));
          $I= date("i",strtotime($strDate));
      
        $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
        $strMonthThai=$strMonthCut[$strMonth];
      
        return  "$strDay $strMonthThai $strYear $H:$I";
          }
    
               $inforepairmedical = Assetcarerepair::where('asset_care_repair.ID','=',$request->id)
            ->leftjoin('informrepair_priority','informrepair_priority.PRIORITY_ID','=','informrepair_index.PRIORITY_ID')
            ->leftjoin('hrd_person','informrepair_index.USER_REQUEST_ID','=','hrd_person.ID')
            ->leftjoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_SUB_ID')
            ->first(); 
    
      //=========================
          
            if($inforepairmedical->TECH_RECEIVE_DATE == ''){
                $TECH_RECEIVE_DATE = '';     
            }else{
                $TECH_RECEIVE_DATE = DateThai($inforepairmedical->TECH_RECEIVE_DATE);
            }

            if($inforepairmedical->TECH_REPAIR_DATE == ''){
                $TECH_REPAIR_DATE = '';     
            }else{
                $TECH_REPAIR_DATE = DateThai($inforepairmedical->TECH_REPAIR_DATE);
            }

            if($inforepairmedical->TECH_SUCCESS_DATE == ''){
                $TECH_SUCCESS_DATE = '';     
            }else{
                $TECH_SUCCESS_DATE = DateThai($inforepairmedical->TECH_SUCCESS_DATE);
            }

            if($inforepairmedical->REPAIR_DATE == ''){
                $REPAIR_DATE = '';     
            }else{
                $REPAIR_DATE = DateThai($inforepairmedical->REPAIR_DATE);
            }

 
      
        //=========================       
    
        $output='    
        
        <div class="row push" style="font-family: \'Kanit\', sans-serif;">
        
        <div class="col-sm-9">
        
      <div class="row">
          <div class="col-lg-2" align="right">
          <label>เลขที่ส่ง :</label>
          </div> 
          <div class="col-lg-8" align="left">
          '.$inforepairmedical->REPAIR_ID.'
          </div> 
      </div>    
      <div class="row">
          <div class="col-lg-2" align="right">
          <label>วันที่แจ้ง :</label>
          </div> 
          <div class="col-lg-4" align="left">
          '.formateDatetime($inforepairmedical->DATE_TIME_REQUEST).'
          </div> 
          <div class="col-lg-2" align="right">
          <label>อาคาร :</label>
          </div> 
          <div class="col-lg-4" align="left">
         
          </div> 
      </div>    
      
      <div class="row">
          <div class="col-lg-2" align="right">
          <label>ชั้น :</label>
          </div> 
          <div class="col-lg-4" align="left">
         
          </div> 
          <div class="col-lg-2" align="right">
          <label>ห้อง :</label>
          </div> 
          <div class="col-lg-4" align="left">
         
          </div> 
     
      </div>    
    
      <div class="row">
      <div class="col-lg-2" align="right">
      <label>แจ้งซ่อม :</label>
      </div> 
      <div class="col-lg-8" align="left">
     '.$inforepairmedical->REPAIR_NAME.'
      </div> 
     </div>  
     
     <div class="row">
     <div class="col-lg-2" align="right">
     <label>รหัสครุภัณฑ์ :</label>
     </div> 
     <div class="col-lg-4" align="left">
        '.$inforepairmedical->ARTICLE_ID.'
        </div> 
        <div class="col-lg-2" align="right">
        <label>ชื่อครุภัณฑ์ :</label>
        </div> 
        <div class="col-lg-4" align="left">
        
        </div> 
        </div>  
        
        <div class="row">
        <div class="col-lg-2" align="right">
        <label>อาการ :</label>
        </div> 
        <div class="col-lg-10" align="left">
        '.$inforepairmedical->SYMPTOM.'
        </div> 
        
        </div>  
    
        <div class="row">
        <div class="col-lg-2" align="right">
        <label>ความเร่งด่วน :</label>
        </div> 
        <div class="col-lg-6" align="left">
        '.$inforepairmedical->PRIORITY_NAME.'
        </div> 
        
        </div>   
        
        <div class="row">
        <div class="col-lg-2" align="right">
        <label>ผู้แจ้งซ่อม :</label>
        </div> 
        <div class="col-lg-4" align="left">
        '.$inforepairmedical->USRE_REQUEST_NAME.'
        </div>
        <div class="col-lg-2" align="right">
        <label>ฝ่าย/แผนก  :</label>
        </div> 
        <div class="col-lg-4" align="left">
        '.$inforepairmedical->HR_DEPARTMENT_SUB_SUB_NAME.'
        </div>  
        </div>     
    
    
    
    
    
        </div>
        
        <div class="col-sm-3">
        
        <div class="form-group">
        
        <img src="data:image/png;base64,'. chunk_split(base64_encode($inforepairmedical->REPAIR_IMG)) .'" id="image_upload_preview" alt="กรุณาเพิ่มรูปภาพ" height="200" width="200"/>
        </div>
        
        </div>
        </div>
        </div>
        </div>';


                if($inforepairmedical->REPAIR_STATUS != 'REQUEST'){

                $output.='<br>
                <div class="row">
                <div class="col-lg-2">
                <label>รายละเอียดรับงาน</label>
                </div> 
                </div> 

            <div class="row">
            <div class="col-sm-9"> 

                <div class="row">
                <div class="col-lg-2" align="right">
                <label>วันที่รับ :</label>
                </div> 
                <div class="col-lg-4" align="left">
                '.$TECH_RECEIVE_DATE.'
                </div>
                <div class="col-lg-2" align="right">
                <label>เวลา  :</label>
                </div> 
                <div class="col-lg-4" align="left">
                '.$inforepairmedical->TECH_RECEIVE_TIME.'
                </div>  
                </div>

                <div class="row">
                <div class="col-lg-2" align="right">
                <label>วันที่ซ่อม :</label>
                </div> 
                <div class="col-lg-4" align="left">
                '.$TECH_REPAIR_DATE.'
                </div>
                <div class="col-lg-2" align="right">
                <label>เวลา  :</label>
                </div> 
                <div class="col-lg-4" align="left">
                '.$inforepairmedical->TECH_REPAIR_TIME.'
                </div>  
                </div>

                <div class="row">
                <div class="col-lg-2" align="right">
                <label>ถึงวันที่ :</label>
                </div> 
                <div class="col-lg-4" align="left">
                '.$TECH_SUCCESS_DATE.'
                </div>
                <div class="col-lg-2" align="right">
                <label>เวลา  :</label>
                </div> 
                <div class="col-lg-4" align="left">
                '.$inforepairmedical->TECH_SUCCESS_TIME.'
                </div>  
                </div>

                <div class="row">
                <div class="col-lg-2" align="right">
                <label>หมายเหตุ :</label>
                </div> 
                <div class="col-lg-10" align="left">
                '.$inforepairmedical->TECH_RECEIVE_COMMENT.'
                </div>
                </div>

                <div class="row">
                <div class="col-lg-2" align="right">
                <label>ผู้รับเรื่อง :</label>
                </div> 
                <div class="col-lg-4" align="left">
                '.$inforepairmedical->TECH_RECEIVE_NAME.'
                </div>
                <div class="col-lg-2" align="right">
                <label>ช่างหลัก  :</label>
                </div> 
                <div class="col-lg-4" align="left">
                '.$inforepairmedical->TECH_REPAIR_NAME.'
                </div>  
                </div>

            </div>

            </div>';
                }
                
                
                if($inforepairmedical->REPAIR_STATUS!= 'REQUEST' && $inforepairmedical->REPAIR_STATUS!= 'RECEIVE'){

                    $output.='<br>
            <div class="row">
            <div class="col-lg-2">
            <label>รายละเอียดดำเนินการ</label>
            </div> 
            </div> 

            <div class="row">
            <div class="col-sm-9"> 


            <div class="row">
            <div class="col-lg-2" align="right">
            <label>รายละเอียด :</label>
            </div> 
            <div class="col-lg-10" align="left">
            '.$inforepairmedical->REPAIR_COMMENT.'
            </div>
            </div>

            <div class="row">
            <div class="col-lg-2" align="right">
            <label>วันที่ :</label>
            </div> 
            <div class="col-lg-4" align="left">
            '.$REPAIR_DATE.'
            </div>
            <div class="col-lg-2" align="right">
            <label>เวลา  :</label>
            </div> 
            <div class="col-lg-4" align="left">
            '.$inforepairmedical->REPAIR_TIME.'
            </div>  
            </div>


            <div class="row">
            <div class="col-lg-2" align="right">
            <label>รายละเอียด :</label>
            </div> 
            <div class="col-lg-10" align="left">
            '.$inforepairmedical->REPAIR_COMMENT.'
            </div>
            </div>

            <br>

            <div class="row">
            <div class="col-lg-3" align="right">
            <label>รายละเอียดส่งซ่อมภายนอก</label>
            </div> 

            </div>

            <div class="row">
            <div class="col-lg-2" align="right">
            <label>เหตุผลที่ส่งซ่อม :</label>
            </div> 
            <div class="col-lg-4" align="left">
            '.$inforepairmedical->OUTSIDE_COMMENT.'
            </div>
            <div class="col-lg-2" align="right">
            <label>อุปกรณ์ที่ติดไปด้วย :</label>
            </div> 
            <div class="col-lg-4" align="left">
            '.$inforepairmedical->OUTSIDE_TOOL.'
            </div>
            </div>


            <div class="row">
            <div class="col-lg-2" align="right">
            <label>ส่งซ่อมที่ร้าน :</label>
            </div> 
            <div class="col-lg-4" align="left">
            '.$inforepairmedical->OUTSIDE_SHOP.'
            </div>
            <div class="col-lg-2" align="right">
            <label>ผู้รับสิ่งของ :</label>
            </div> 
            <div class="col-lg-4" align="left">
            '.$inforepairmedical->OUTSIDE_EMP.'
            </div>
            </div>

            <br>

            <div class="row">
            <div class="col-lg-3" align="right">
            <label>รายละเอียดรับกลับ</label>
            </div> 

            </div>

            <div class="row">
            <div class="col-lg-2" align="right">
            <label>ผู้รับกลับ :</label>
            </div> 
            <div class="col-lg-4" align="left">
            '.$inforepairmedical->GETBACK_PERSON.'
            </div>
            <div class="col-lg-2" align="right">
            <label>วันที่รับกลับ :</label>
            </div> 
            <div class="col-lg-4" align="left">
            '.DateThai($inforepairmedical->GETBACK_DATE).'
            </div>
            </div>

            </div> 
            </div>';
                }    
                echo $output;
    
    
    }

    //================================================รับเรื่อง============================================
    public function repairmedicalreceived($id)
    {
        
        $iduser = Auth::user()->PERSON_ID; 

        $inforpersonuser=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->where('hrd_person.ID','=',$iduser)->first();

        $inforepairmedical = Assetcarerepair::where('asset_care_repair.ID','=',$id)
        ->select('asset_care_repair.ID','REPAIR_ID','DATE_TIME_REQUEST','REPAIR_NAME','asset_article.ARTICLE_NUM','ARTICLE_NAME','MED_IMG','asset_care_repair.ARTICLE_ID','BUILD_NAME','LOCATION_LEVEL_NAME','LEVEL_ROOM_NAME','SYMPTOM','informrepair_priority.PRIORITY_NAME','USRE_REQUEST_NAME','HR_DEPARTMENT_SUB_SUB_NAME')
        ->leftjoin('informrepair_priority','informrepair_priority.PRIORITY_ID','=','asset_care_repair.PRIORITY_ID')
        ->leftjoin('hrd_person','asset_care_repair.USER_REQUEST_ID','=','hrd_person.ID')
        ->leftjoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_SUB_ID')
        ->leftjoin('asset_building','asset_care_repair.LOCATION_SEE_ID','=','asset_building.ID')
        ->leftjoin('asset_article','asset_care_repair.ARTICLE_ID','=','asset_article.ARTICLE_ID')
        ->leftjoin('supplies_location_level','asset_care_repair.LOCATIONLEVEL_SEE_ID','=','supplies_location_level.LOCATION_LEVEL_ID')
        ->leftjoin('supplies_location_level_room','asset_care_repair.LOCATIONLEVELROOM_SEE_ID','=','supplies_location_level_room.LEVEL_ROOM_ID')
        ->first(); 


        $infotech = DB::table('asset_care_enginer')
        ->leftJoin('hrd_person','hrd_person.ID','=','asset_care_enginer.PERSON_ID')
        ->get();

        return view('manager_repairmedical.repairmedicalreceived_add',[
                'inforepairmedical' => $inforepairmedical,
                'inforpersonuser' => $inforpersonuser,
                'infotechs'=> $infotech
        ]);
    
    }


     

    public function updateinfomedicalreceived(Request $request)
    {

        $request->validate([
            'TECH_REPAIR_ID' => 'required',
           'TECH_REPAIR_DATE' => 'required',  
           'TECH_SUCCESS_DATE' => 'required',  
      ]);


        $TECH_RECEIVE_DATE = $request->TECH_RECEIVE_DATE;
        $TECH_REPAIR_DATE = $request->TECH_REPAIR_DATE;
        $TECH_SUCCESS_DATE = $request->TECH_SUCCESS_DATE;

        if($TECH_RECEIVE_DATE != ''){
         $STARTDAY = Carbon::createFromFormat('d/m/Y', $TECH_RECEIVE_DATE)->format('Y-m-d');
         $date_arrary_st=explode("-",$STARTDAY);  
         $y_sub_st = $date_arrary_st[0]; 
         
         if($y_sub_st >= 2500){
             $y_st = $y_sub_st-543;
         }else{
             $y_st = $y_sub_st;
         }
         $m_st = $date_arrary_st[1];
         $d_st = $date_arrary_st[2];  
         $TECH_RECEIVE_DATE= $y_st."-".$m_st."-".$d_st;
         }else{
         $TECH_RECEIVE_DATE= null;
     }
 
     if($TECH_REPAIR_DATE != ''){
         $STARTDAY = Carbon::createFromFormat('d/m/Y', $TECH_REPAIR_DATE)->format('Y-m-d');
         $date_arrary_st=explode("-",$STARTDAY);  
         $y_sub_st = $date_arrary_st[0]; 
         
         if($y_sub_st >= 2500){
             $y_st = $y_sub_st-543;
         }else{
             $y_st = $y_sub_st;
         }
         $m_st = $date_arrary_st[1];
         $d_st = $date_arrary_st[2];  
         $TECH_REPAIR_DATE= $y_st."-".$m_st."-".$d_st;
         }else{
         $TECH_REPAIR_DATE= null;
     }
       
 
     if($TECH_SUCCESS_DATE != ''){
         $STARTDAY = Carbon::createFromFormat('d/m/Y', $TECH_SUCCESS_DATE)->format('Y-m-d');
         $date_arrary_st=explode("-",$STARTDAY);  
         $y_sub_st = $date_arrary_st[0]; 
         
         if($y_sub_st >= 2500){
             $y_st = $y_sub_st-543;
         }else{
             $y_st = $y_sub_st;
         }
         $m_st = $date_arrary_st[1];
         $d_st = $date_arrary_st[2];  
         $TECH_SUCCESS_DATE= $y_st."-".$m_st."-".$d_st;
         }else{
         $TECH_SUCCESS_DATE= null;
     }


 
             $ID = $request->ID;

 
             $addreceived = Assetcarerepair::find($ID);

             $addreceived->TECH_RECEIVE_DATE = $TECH_RECEIVE_DATE;
             $addreceived->TECH_RECEIVE_TIME = $request->TECH_RECEIVE_TIME;

             $addreceived->TECH_RECEIVE_ID = $request->TECH_RECEIVE_ID;
             //----------------------------------
             $TECH_RECEIVE =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
             ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
             ->where('hrd_person.ID','=',$request->TECH_RECEIVE_ID)->first();
             $addreceived->TECH_RECEIVE_NAME    = $TECH_RECEIVE->HR_PREFIX_NAME.''.$TECH_RECEIVE->HR_FNAME.' '.$TECH_RECEIVE->HR_LNAME;


             //----------------------------------


             $addreceived->TECH_REPAIR_ID = $request->TECH_REPAIR_ID;
             //----------------------------------
             $TECH_REPAIR_NAME =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
             ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
             ->where('hrd_person.ID','=',$request->TECH_REPAIR_ID)->first();
             $addreceived->TECH_REPAIR_NAME   = $TECH_REPAIR_NAME->HR_PREFIX_NAME.''.$TECH_REPAIR_NAME->HR_FNAME.' '.$TECH_REPAIR_NAME->HR_LNAME;
 
             //----------------------------------
             $addreceived->TECH_RECEIVE_COMMENT = $request->TECH_RECEIVE_COMMENT;
             $addreceived->TECH_REPAIR_DATE = $TECH_REPAIR_DATE;
             $addreceived->TECH_REPAIR_TIME = $request->TECH_REPAIR_TIME;
             $addreceived->TECH_SUCCESS_DATE = $TECH_SUCCESS_DATE;
             $addreceived->TECH_SUCCESS_TIME = $request->TECH_SUCCESS_TIME;
             $addreceived->REPAIR_STATUS = 'RECEIVE';
             $addreceived->save();
 
 
 
             if($request->HR_PERSON_ID != '' || $request->HR_PERSON_ID != null){
 
                 $HR_PERSON_ID = $request->HR_PERSON_ID;
    
                 $number =count($HR_PERSON_ID);
                 $count = 0;
                 for($count = 0; $count< $number; $count++)
                 {  
               
                    $add = new Assetcarerepairtech();
                    $add->REPAIR_INDEX_ID = $ID;
                    $add->HR_PERSON_ID = $HR_PERSON_ID[$count];
                    $add->save(); 
                  
          
                 }
             }
 
 
             return response()->json([
                'status' => 1,
                'url' => route('mrepairmedical.repairmedicalinfo')
            ]);


    }


    //-----------------------------------------แก้ไข--------------------


    public function repairmedicalreceiveedit($id)
    {
        
        $iduser = Auth::user()->PERSON_ID; 
        $inforpersonuser=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->where('hrd_person.ID','=',$iduser)->first();

        $inforepairmedical = Assetcarerepair::where('asset_care_repair.ID','=',$id)
        ->select('asset_care_repair.ID','REPAIR_ID','TECH_REPAIR_ID','DATE_TIME_REQUEST','REPAIR_NAME','asset_article.ARTICLE_NUM','ARTICLE_NAME','MED_IMG','asset_care_repair.ARTICLE_ID','BUILD_NAME','LOCATION_LEVEL_NAME','LEVEL_ROOM_NAME','SYMPTOM','informrepair_priority.PRIORITY_NAME','USRE_REQUEST_NAME','HR_DEPARTMENT_SUB_SUB_NAME')
        ->leftjoin('informrepair_priority','informrepair_priority.PRIORITY_ID','=','asset_care_repair.PRIORITY_ID')
        ->leftjoin('hrd_person','asset_care_repair.USER_REQUEST_ID','=','hrd_person.ID')
        ->leftjoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_SUB_ID')
        ->leftjoin('asset_building','asset_care_repair.LOCATION_SEE_ID','=','asset_building.ID')
        ->leftjoin('asset_article','asset_care_repair.ARTICLE_ID','=','asset_article.ARTICLE_ID')
        ->leftjoin('supplies_location_level','asset_care_repair.LOCATIONLEVEL_SEE_ID','=','supplies_location_level.LOCATION_LEVEL_ID')
        ->leftjoin('supplies_location_level_room','asset_care_repair.LOCATIONLEVELROOM_SEE_ID','=','supplies_location_level_room.LEVEL_ROOM_ID')
        ->first(); 

        
        $infotechrepair = Assetcarerepairtech::where('REPAIR_INDEX_ID','=',$id)->get();
        $counttechrepair = Assetcarerepairtech::where('REPAIR_INDEX_ID','=',$id)->count();
        $infotech = DB::table('asset_care_enginer')
        ->leftJoin('hrd_person','hrd_person.ID','=','asset_care_enginer.PERSON_ID')
        ->get();

        return view('manager_repairmedical.repairmedicalreceived_edit',[
                'inforepairmedical' => $inforepairmedical,
                'inforpersonuser' => $inforpersonuser,
                'infotechrepairs' => $infotechrepair,
                'counttechrepair' => $counttechrepair,
                'infotechs'=> $infotech
        ]);
    
    }


    public function updateinforepairmedicalreceive(Request $request)
    {
        $TECH_RECEIVE_DATE = $request->TECH_RECEIVE_DATE;
        $TECH_REPAIR_DATE = $request->TECH_REPAIR_DATE;
        $TECH_SUCCESS_DATE = $request->TECH_SUCCESS_DATE;

        if($TECH_RECEIVE_DATE != ''){
         $STARTDAY = Carbon::createFromFormat('d/m/Y', $TECH_RECEIVE_DATE)->format('Y-m-d');
         $date_arrary_st=explode("-",$STARTDAY);  
         $y_sub_st = $date_arrary_st[0]; 
         
         if($y_sub_st >= 2500){
             $y_st = $y_sub_st-543;
         }else{
             $y_st = $y_sub_st;
         }
         $m_st = $date_arrary_st[1];
         $d_st = $date_arrary_st[2];  
         $TECH_RECEIVE_DATE= $y_st."-".$m_st."-".$d_st;
         }else{
         $TECH_RECEIVE_DATE= null;
     }
 
     if($TECH_REPAIR_DATE != ''){
         $STARTDAY = Carbon::createFromFormat('d/m/Y', $TECH_REPAIR_DATE)->format('Y-m-d');
         $date_arrary_st=explode("-",$STARTDAY);  
         $y_sub_st = $date_arrary_st[0]; 
         
         if($y_sub_st >= 2500){
             $y_st = $y_sub_st-543;
         }else{
             $y_st = $y_sub_st;
         }
         $m_st = $date_arrary_st[1];
         $d_st = $date_arrary_st[2];  
         $TECH_REPAIR_DATE= $y_st."-".$m_st."-".$d_st;
         }else{
         $TECH_REPAIR_DATE= null;
     }
       
 
     if($TECH_SUCCESS_DATE != ''){
         $STARTDAY = Carbon::createFromFormat('d/m/Y', $TECH_SUCCESS_DATE)->format('Y-m-d');
         $date_arrary_st=explode("-",$STARTDAY);  
         $y_sub_st = $date_arrary_st[0]; 
         
         if($y_sub_st >= 2500){
             $y_st = $y_sub_st-543;
         }else{
             $y_st = $y_sub_st;
         }
         $m_st = $date_arrary_st[1];
         $d_st = $date_arrary_st[2];  
         $TECH_SUCCESS_DATE= $y_st."-".$m_st."-".$d_st;
         }else{
         $TECH_SUCCESS_DATE= null;
     }
             $ID = $request->ID;
             $addcarerepair = Assetcarerepair::find($ID);
             $addcarerepair->TECH_RECEIVE_DATE = $TECH_RECEIVE_DATE;
             $addcarerepair->TECH_RECEIVE_TIME = $request->TECH_RECEIVE_TIME;
             $addcarerepair->TECH_RECEIVE_ID = $request->TECH_RECEIVE_ID;
             //----------------------------------
             $TECH_RECEIVE =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
             ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
             ->where('hrd_person.ID','=',$request->TECH_RECEIVE_ID)->first();
             $addcarerepair->TECH_RECEIVE_NAME    = $TECH_RECEIVE->HR_PREFIX_NAME.''.$TECH_RECEIVE->HR_FNAME.' '.$TECH_RECEIVE->HR_LNAME;


             //----------------------------------

             $addcarerepair->TECH_REPAIR_ID = $request->TECH_REPAIR_ID;
             //----------------------------------
             $TECH_REPAIR_NAME =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
             ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
             ->where('hrd_person.ID','=',$request->TECH_REPAIR_ID)->first();

             $addcarerepair->TECH_REPAIR_NAME   = $TECH_REPAIR_NAME->HR_PREFIX_NAME.''.$TECH_REPAIR_NAME->HR_FNAME.' '.$TECH_REPAIR_NAME->HR_LNAME;
             //----------------------------------
             $addcarerepair->TECH_RECEIVE_COMMENT = $request->TECH_RECEIVE_COMMENT;
             $addcarerepair->TECH_REPAIR_DATE = $TECH_REPAIR_DATE;
             $addcarerepair->TECH_REPAIR_TIME = $request->TECH_REPAIR_TIME;
             $addcarerepair->TECH_SUCCESS_DATE = $TECH_SUCCESS_DATE;
             $addcarerepair->TECH_SUCCESS_TIME = $request->TECH_SUCCESS_TIME;
             $addcarerepair->REPAIR_STATUS = 'RECEIVE';
             $addcarerepair->save();
 
 
 
             if($request->HR_PERSON_ID != '' || $request->HR_PERSON_ID != null){

                
                Assetcarerepairtech::where('REPAIR_INDEX_ID','=',$ID)->delete(); 
 
                 $HR_PERSON_ID = $request->HR_PERSON_ID;
    
                 $number =count($HR_PERSON_ID);
                 $count = 0;
                 for($count = 0; $count< $number; $count++)
                 {  
                 
                    $add = new Assetcarerepairtech();
                    $add->REPAIR_INDEX_ID = $ID;
                    $add->HR_PERSON_ID = $HR_PERSON_ID[$count];
                    $add->save(); 
                  
          
                 }
             }
             return redirect()->route('mrepairmedical.repairmedicalinfo'); 
    }
     //================================================ระหว่างซ่อม============================================
    public function repairmedicalamong($id)
    {
         
        $iduser = Auth::user()->PERSON_ID; 
          
        $inforpersonuser=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->where('hrd_person.ID','=',$iduser)->first();

        $inforepairmedical = Assetcarerepair::leftjoin('hrd_person','asset_care_repair.USER_REQUEST_ID','=','hrd_person.ID')
        ->leftjoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_SUB_ID')
        ->leftjoin('asset_building','asset_care_repair.LOCATION_SEE_ID','=','asset_building.ID')
        ->leftjoin('asset_article','asset_care_repair.ARTICLE_ID','=','asset_article.ARTICLE_ID')
        ->leftjoin('supplies_location_level','asset_care_repair.LOCATIONLEVEL_SEE_ID','=','supplies_location_level.LOCATION_LEVEL_ID')
        ->leftjoin('supplies_location_level_room','asset_care_repair.LOCATIONLEVELROOM_SEE_ID','=','supplies_location_level_room.LEVEL_ROOM_ID')
            ->where('asset_care_repair.ID','=',$id)->first(); 
        return view('manager_repairmedical.repairmedicalamong_add',[
                'inforepairmedical' => $inforepairmedical,
                'inforpersonuser'=>$inforpersonuser,
                'ID'=>$id
        ]);
    }

    public function updateinfomedicalamong(Request $request)
    {
        $REPAIR_DATE = $request->REPAIR_DATE;
        if($REPAIR_DATE != ''){
         $STARTDAY = Carbon::createFromFormat('d/m/Y', $REPAIR_DATE)->format('Y-m-d');
         $date_arrary_st=explode("-",$STARTDAY);  
         $y_sub_st = $date_arrary_st[0]; 
         
         if($y_sub_st >= 2500){
             $y_st = $y_sub_st-543;
         }else{
             $y_st = $y_sub_st;
         }
         $m_st = $date_arrary_st[1];
         $d_st = $date_arrary_st[2];  
         $REPAIR_DATE= $y_st."-".$m_st."-".$d_st;
         }else{
         $REPAIR_DATE= null;
     }
             $ID = $request->ID;
             $addamong= Assetcarerepair::find($ID);
             $addamong->REPAIR_DATE = $REPAIR_DATE;
             $addamong->REPAIR_TIME = $request->REPAIR_TIME;
             $addamong->REPAIR_COMMENT = $request->REPAIR_COMMENT;
             $addamong->OUTSIDE_ACTIVE = $request->OUTSIDE_ACTIVE;
             $addamong->OUTSIDE_COMMENT = $request->OUTSIDE_COMMENT;
             $addamong->OUTSIDE_TOOL = $request->OUTSIDE_TOOL;
             $addamong->OUTSIDE_SHOP = $request->OUTSIDE_SHOP;
             $addamong->OUTSIDE_EMP = $request->OUTSIDE_EMP;

             if($request->OUTSIDE_ACTIVE == 'true'){
                $addamong->PRIORITY_ID = $request->PRIORITY_ID;
                $REPAIR_STATUS = 'OUTSIDE';
             }else{
                $REPAIR_STATUS = 'PENDING';
             }
             $addamong->REPAIR_STATUS = $REPAIR_STATUS;
             $addamong->save();
            return redirect()->route('mrepairmedical.repairmedicalinfo'); 

    }
   
//--------------------------------------------แก้ไข----------------------------------------------

public function repairmedicalamongedit($id)
{
    $iduser = Auth::user()->PERSON_ID; 
    $inforpersonuser=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->where('hrd_person.ID','=',$iduser)->first();
    $inforepairmedical = Assetcarerepair::where('ID','=',$id)->first(); 
    return view('manager_repairmedical.repairmedicalamong_edit',[
            'inforepairmedical' => $inforepairmedical,
            'inforpersonuser'=>$inforpersonuser,
            'ID'=>$id
    ]);

}

public function updateinforepairmedicalamong(Request $request)
{
    $REPAIR_DATE = $request->REPAIR_DATE;
    if($REPAIR_DATE != ''){
     $STARTDAY = Carbon::createFromFormat('d/m/Y', $REPAIR_DATE)->format('Y-m-d');
     $date_arrary_st=explode("-",$STARTDAY);  
     $y_sub_st = $date_arrary_st[0]; 
     
     if($y_sub_st >= 2500){
         $y_st = $y_sub_st-543;
     }else{
         $y_st = $y_sub_st;
     }
     $m_st = $date_arrary_st[1];
     $d_st = $date_arrary_st[2];  
     $REPAIR_DATE= $y_st."-".$m_st."-".$d_st;
     }else{
     $REPAIR_DATE= null;
 }

         $ID = $request->ID;
         $addamong= Assetcarerepair::find($ID);
         $addamong->REPAIR_DATE = $REPAIR_DATE;
         $addamong->REPAIR_TIME = $request->REPAIR_TIME;
         $addamong->REPAIR_COMMENT = $request->REPAIR_COMMENT;
         $addamong->OUTSIDE_ACTIVE = $request->OUTSIDE_ACTIVE;
         $addamong->OUTSIDE_COMMENT = $request->OUTSIDE_COMMENT;
         $addamong->OUTSIDE_TOOL = $request->OUTSIDE_TOOL;
         $addamong->OUTSIDE_SHOP = $request->OUTSIDE_SHOP;
         $addamong->OUTSIDE_EMP = $request->OUTSIDE_EMP;


         if($request->OUTSIDE_ACTIVE == 'true'){
            $addamong->PRIORITY_ID = $request->PRIORITY_ID;
            $REPAIR_STATUS = 'OUTSIDE';
         }else{
            $REPAIR_STATUS = 'PENDING';
         }

         $addamong->REPAIR_STATUS = $REPAIR_STATUS;
         $addamong->save();
        return redirect()->route('mrepairmedical.repairmedicalinfo'); 
}

    //================================================ซ่อมเสร็จ============================================
   
    public function repairmedicalsuccess($id)
    {

        $inforepairmedical = Assetcarerepair::where('asset_care_repair.ID','=',$id)
        ->leftjoin('informrepair_priority','informrepair_priority.PRIORITY_ID','=','asset_care_repair.PRIORITY_ID')
        ->leftjoin('hrd_person','asset_care_repair.USER_REQUEST_ID','=','hrd_person.ID')
        ->leftjoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_SUB_ID')
        ->leftjoin('asset_building','asset_care_repair.LOCATION_SEE_ID','=','asset_building.ID')
        ->leftjoin('asset_article','asset_care_repair.ARTICLE_ID','=','asset_article.ARTICLE_ID')
        ->leftjoin('supplies_location_level','asset_care_repair.LOCATIONLEVEL_SEE_ID','=','supplies_location_level.LOCATION_LEVEL_ID')
        ->leftjoin('supplies_location_level_room','asset_care_repair.LOCATIONLEVELROOM_SEE_ID','=','supplies_location_level_room.LEVEL_ROOM_ID')


        ->first(); 

        $inforepairID = Assetcarerepair::where('ID','=',$id)->first(); 

        $infoen = DB::table('informcom_engineer')->get();
        $servicetype = DB::table('informrepair_service_type')->get();
        
        $service = DB::table('asset_care_repair_service')->where('REPAIR_INDEX_ID','=',$id)->get();
        $countservice = DB::table('asset_care_repair_service')->where('REPAIR_INDEX_ID','=',$id)->count();

        return view('manager_repairmedical.repairmedicalsuccess_add',[
                'inforepairmedical' => $inforepairmedical,
                'infoens'=> $infoen,
                'inforepairID'=> $inforepairID,
                'servicetypes'=> $servicetype,
                'services'=> $service,
                'countservice'=> $countservice,
        ]);
    
    }

    
    public function updateinfomedicalsuccess(Request $request)
    {

 
             $ID = $request->ID;
             $REPAIR_ID = $request->REPAIR_ID;

             $REPAIR_STATUS = $request->REPAIR_STATUS;
 
             $addsuccess= Assetcarerepair::find($ID);
             $addsuccess->REPAIR_SUCCESS_REMARK = $request->REPAIR_SUCCESS_REMARK;


           
             if( $REPAIR_STATUS == 'OUTSIDE'){
                  
                $GETBACK_DATE = $request->GETBACK_DATE;
 

                if($GETBACK_DATE != ''){
                 $GETBACK = Carbon::createFromFormat('d/m/Y', $GETBACK_DATE)->format('Y-m-d');
                 $date_arrary_st=explode("-",$GETBACK);  
                 $y_sub_st = $date_arrary_st[0]; 
                 
                 if($y_sub_st >= 2500){
                     $y_st = $y_sub_st-543;
                 }else{
                     $y_st = $y_sub_st;
                 }
                 $m_st = $date_arrary_st[1];
                 $d_st = $date_arrary_st[2];  
                 $GETBACK_DATE= $y_st."-".$m_st."-".$d_st;
                 }else{
                 $GETBACK_DATE= null;
             }



               if($request->DEAL_ACTIVE == 'deal' && $request->GETBACK_ACTIVE == 'getback'){

                    $addsuccess->DEAL_ACTIVE = $request->DEAL_ACTIVE;
                    $addsuccess->DEAL_COMMENT = $request->DEAL_COMMENT;
                    $addsuccess->GETBACK_ACTIVE = $request->GETBACK_ACTIVE;
                    $addsuccess->GETBACK_DATE = $GETBACK_DATE;
                    $addsuccess->GETBACK_PERSON = $request->GETBACK_PERSON;
                    $addsuccess->REPAIR_STATUS = 'DEAL';

               }else if($request->DEAL_ACTIVE == 'deal'){

                    $addsuccess->DEAL_ACTIVE = $request->DEAL_ACTIVE;
                    $addsuccess->DEAL_COMMENT = $request->DEAL_COMMENT;
                    $addsuccess->REPAIR_STATUS = 'DEAL';

                }else if($request->GETBACK_ACTIVE == 'getback'){

                    $addsuccess->GETBACK_ACTIVE = $request->GETBACK_ACTIVE;
                    $addsuccess->GETBACK_DATE = $GETBACK_DATE;
                    $addsuccess->GETBACK_PERSON = $request->GETBACK_PERSON;
                    $addsuccess->REPAIR_STATUS = 'SUCCESS';
                   
                }else{
                    $addsuccess->REPAIR_STATUS = 'OUTSIDE';
                   
                }
            
            }else{

                
                        if($request->DEAL_ACTIVE == 'deal'){
                            $addsuccess->DEAL_ACTIVE = $request->DEAL_ACTIVE;
                            $addsuccess->DEAL_COMMENT = $request->DEAL_COMMENT;
                            $addsuccess->REPAIR_STATUS = 'DEAL';
                        }else{
                            $addsuccess->REPAIR_STATUS = 'SUCCESS';
                        }



             }

            
             $addsuccess->save();
 
 
 
             if($request->REPAIR_TYPE_ID != '' || $request->REPAIR_TYPE_ID != null){
 
                 $REPAIR_TYPE_ID = $request->REPAIR_TYPE_ID;
                 $REPAIR_SERVICE_NAME = $request->REPAIR_SERVICE_NAME;
                 $REPAIR_TOTAL = $request->REPAIR_TOTAL;
                 $REPAIR_PRICE_PER_UNIT = $request->REPAIR_PRICE_PER_UNIT;
              
     
                 $number =count($REPAIR_TYPE_ID);
                 $count = 0;
                 for($count = 0; $count< $number; $count++)
                 {  
                    $add = new Assetcarerepairservice();
                    $add->REPAIR_INDEX_ID = $ID;
                    $add->REPAIR_ID = $REPAIR_ID;
                    $add->REPAIR_TYPE_ID = $REPAIR_TYPE_ID[$count];
                    $add->REPAIR_SERVICE_NAME = $REPAIR_SERVICE_NAME[$count];
                    $add->REPAIR_TOTAL = $REPAIR_TOTAL[$count];
                    $add->REPAIR_PRICE_PER_UNIT = $REPAIR_PRICE_PER_UNIT[$count];
                    $add->REPAIR_SUM_PRICE = $REPAIR_TOTAL[$count] * $REPAIR_PRICE_PER_UNIT[$count];
                    $add->save(); 
                  
          
                 }
             }
            return redirect()->route('mrepairmedical.repairmedicalinfo'); 
    }

    //--------------------------------------------แก้ไข----------------------------------------------
    public function repairmedicalsuccessedit($id)
    {
        $inforepairmedical = Assetcarerepair::where('asset_care_repair.ID','=',$id)
        ->select(DB::raw('asset_care_repair.* , informrepair_priority.* , hrd_department_sub_sub.* , asset_article.* , supplies_location_level.* , supplies_location_level_room.* , asset_building.BUILD_NAME'))
        ->leftjoin('informrepair_priority','informrepair_priority.PRIORITY_ID','=','asset_care_repair.PRIORITY_ID')
        ->leftjoin('hrd_person','asset_care_repair.USER_REQUEST_ID','=','hrd_person.ID')
        ->leftjoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_SUB_ID')
        ->leftjoin('asset_building','asset_care_repair.LOCATION_SEE_ID','=','asset_building.ID')
        ->leftjoin('asset_article','asset_care_repair.ARTICLE_ID','=','asset_article.ARTICLE_ID')
        ->leftjoin('supplies_location_level','asset_care_repair.LOCATIONLEVEL_SEE_ID','=','supplies_location_level.LOCATION_LEVEL_ID')
        ->leftjoin('supplies_location_level_room','asset_care_repair.LOCATIONLEVELROOM_SEE_ID','=','supplies_location_level_room.LEVEL_ROOM_ID')
        ->first(); 
        $inforepairID = Assetcarerepair::where('ID','=',$id)->first(); 
        $infoen = DB::table('informcom_engineer')->get();
        $servicetype = DB::table('informrepair_service_type')->get();

        $service = DB::table('asset_care_repair_service')->where('REPAIR_INDEX_ID','=',$id)->get();
        $countservice = DB::table('asset_care_repair_service')->where('REPAIR_INDEX_ID','=',$id)->count();

        return view('manager_repairmedical.repairmedicalsuccess_edit',[
                'inforepairmedical' => $inforepairmedical,
                'infoens'=> $infoen,
                'inforepairID'=> $inforepairID,
                'servicetypes'=> $servicetype,
                'services'=> $service,
                'countservice'=> $countservice,
        ]);
    
    }

    public function updateinforepairmedicalsuccess(Request $request)
    {
             $ID = $request->ID;
             $REPAIR_ID = $request->REPAIR_ID;
             $GETBACK_ACTIVE = $request->GETBACK_ACTIVE;
             $addsuccess= Assetcarerepair::find($ID);
             $addsuccess->REPAIR_SUCCESS_REMARK = $request->REPAIR_SUCCESS_REMARK;

             if( $GETBACK_ACTIVE == 'getback'){
                $GETBACK_DATE = $request->GETBACK_DATE;

                if($GETBACK_DATE != ''){
                 $GETBACK = Carbon::createFromFormat('d/m/Y', $GETBACK_DATE)->format('Y-m-d');
                 $date_arrary_st=explode("-",$GETBACK);  
                 $y_sub_st = $date_arrary_st[0]; 
                 
                 if($y_sub_st >= 2500){
                     $y_st = $y_sub_st-543;
                 }else{
                     $y_st = $y_sub_st;
                 }
                 $m_st = $date_arrary_st[1];
                 $d_st = $date_arrary_st[2];  
                 $GETBACK_DATE= $y_st."-".$m_st."-".$d_st;
                 }else{
                 $GETBACK_DATE= null;
             }

               if($request->DEAL_ACTIVE == 'deal' && $request->GETBACK_ACTIVE == 'getback'){

                    $addsuccess->DEAL_ACTIVE = $request->DEAL_ACTIVE;
                    $addsuccess->DEAL_COMMENT = $request->DEAL_COMMENT;
                    $addsuccess->GETBACK_ACTIVE = $request->GETBACK_ACTIVE;
                    $addsuccess->GETBACK_DATE = $GETBACK_DATE;
                    $addsuccess->GETBACK_PERSON = $request->GETBACK_PERSON;
                    $addsuccess->REPAIR_STATUS = 'DEAL';

               }else if($request->DEAL_ACTIVE == 'deal'){

                    $addsuccess->DEAL_ACTIVE = $request->DEAL_ACTIVE;
                    $addsuccess->DEAL_COMMENT = $request->DEAL_COMMENT;
                    $addsuccess->REPAIR_STATUS = 'DEAL';

                }else if($request->GETBACK_ACTIVE == 'getback'){

                    $addsuccess->GETBACK_ACTIVE = $request->GETBACK_ACTIVE;
                    $addsuccess->GETBACK_DATE = $GETBACK_DATE;
                    $addsuccess->GETBACK_PERSON = $request->GETBACK_PERSON;
                    $addsuccess->REPAIR_STATUS = 'SUCCESS';
                   
                }
            
            }else{

                
                        if($request->DEAL_ACTIVE == 'deal'){
                            $addsuccess->DEAL_ACTIVE = $request->DEAL_ACTIVE;
                            $addsuccess->DEAL_COMMENT = $request->DEAL_COMMENT;
                            $addsuccess->REPAIR_STATUS = 'DEAL';
                        }else{
                            $addsuccess->REPAIR_STATUS = 'SUCCESS';
                        }



             }

             $addsuccess->save();
             if($request->REPAIR_TYPE_ID != '' || $request->REPAIR_TYPE_ID != null){
                Assetcarerepairservice::where('REPAIR_INDEX_ID','=',$ID)->delete(); 
                 $REPAIR_TYPE_ID = $request->REPAIR_TYPE_ID;
                 $REPAIR_SERVICE_NAME = $request->REPAIR_SERVICE_NAME;
                 $REPAIR_TOTAL = $request->REPAIR_TOTAL;
                 $REPAIR_PRICE_PER_UNIT = $request->REPAIR_PRICE_PER_UNIT;
     
                 $number =count($REPAIR_TYPE_ID);
                 $count = 0;
                 for($count = 0; $count< $number; $count++)
                 {  
                    $add = new Assetcarerepairservice();
                    $add->REPAIR_INDEX_ID = $ID;
                    $add->REPAIR_ID = $REPAIR_ID;
                    $add->REPAIR_TYPE_ID = $REPAIR_TYPE_ID[$count];
                    $add->REPAIR_SERVICE_NAME = $REPAIR_SERVICE_NAME[$count];
                    $add->REPAIR_TOTAL = $REPAIR_TOTAL[$count];
                    $add->REPAIR_PRICE_PER_UNIT = $REPAIR_PRICE_PER_UNIT[$count];
                    $add->REPAIR_SUM_PRICE = $REPAIR_TOTAL[$count] * $REPAIR_PRICE_PER_UNIT[$count];
                    $add->save(); 
                 }
             }
            
            return redirect()->route('mrepairmedical.repairmedicalinfo'); 

    }


      //============================================ยกเลิกรายการ=================


      public function repairmedicalinfocancel($id)
      {
  
        $inforepairmedicaldetail = Assetcarerepair::where('asset_care_repair.ID','=',$id)
        ->leftjoin('informrepair_priority','informrepair_priority.PRIORITY_ID','=','asset_care_repair.PRIORITY_ID')
        ->leftjoin('hrd_person','asset_care_repair.USER_REQUEST_ID','=','hrd_person.ID')
        ->leftjoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_SUB_ID')
        ->leftjoin('asset_building','asset_care_repair.LOCATION_SEE_ID','=','asset_building.ID')
        ->leftjoin('asset_article','asset_care_repair.ARTICLE_ID','=','asset_article.ARTICLE_ID')
        ->leftjoin('supplies_location_level','asset_care_repair.LOCATIONLEVEL_SEE_ID','=','supplies_location_level.LOCATION_LEVEL_ID')
        ->leftjoin('supplies_location_level_room','asset_care_repair.LOCATIONLEVELROOM_SEE_ID','=','supplies_location_level_room.LEVEL_ROOM_ID')
        ->first(); 
  
        $inforepairmedicaldetailid = Assetcarerepair::where('asset_care_repair.ID','=',$id)
        
        ->first();
  
          return view('manager_repairmedical.repairmedicalcancel_check',[
            'inforepairmedicaldetail' => $inforepairmedicaldetail,
            'inforepairmedicaldetailid' => $inforepairmedicaldetailid,
       
          ]);
      
      }

      public function updaterepairmedicalcancel(Request $request)
      {

   
               $ID = $request->ID;
   
               $addcancel= Assetcarerepair::find($ID);
  
               $addcancel->REPAIR_STATUS = 'CANCEL';
               $addcancel->save();
   
              return redirect()->route('mrepairmedical.repairmedicalinfo'); 
  
      }


      
             //============================================ลัดสถานนะดำเนินการสำเร็จ=================


      public function repairmedicalsuccessnow($id)
      {
  
        $inforepairmedicaldetail = Assetcarerepair::where('asset_care_repair.ID','=',$id)
        ->leftjoin('informrepair_priority','informrepair_priority.PRIORITY_ID','=','asset_care_repair.PRIORITY_ID')
        ->leftjoin('hrd_person','asset_care_repair.USER_REQUEST_ID','=','hrd_person.ID')
        ->leftjoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_SUB_ID')
        ->leftjoin('asset_building','asset_care_repair.LOCATION_SEE_ID','=','asset_building.ID')
        ->leftjoin('asset_article','asset_care_repair.ARTICLE_ID','=','asset_article.ARTICLE_ID')
        ->leftjoin('supplies_location_level','asset_care_repair.LOCATIONLEVEL_SEE_ID','=','supplies_location_level.LOCATION_LEVEL_ID')
        ->leftjoin('supplies_location_level_room','asset_care_repair.LOCATIONLEVELROOM_SEE_ID','=','supplies_location_level_room.LEVEL_ROOM_ID')
        ->first(); 
  
        $inforepairmedicaldetailid = Assetcarerepair::where('asset_care_repair.ID','=',$id)
        
        ->first();
  
          return view('manager_repairmedical.repairmedicalsuccessnow_check',[
            'inforepairmedicaldetail' => $inforepairmedicaldetail,
            'inforepairmedicaldetailid' => $inforepairmedicaldetailid,
       
          ]);
      
      }

      public function repairmedicalsuccessnowupdate(Request $request)
      {

        $iduser = Auth::user()->PERSON_ID; 

        $inforpersonuser=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->where('hrd_person.ID','=',$iduser)->first();

   
               $ID = $request->ID;
   
               $addsuc= Assetcarerepair::find($ID);
  
               $addsuc->REPAIR_STATUS = 'SUCCESS';
               $addsuc->TECH_RECEIVE_ID = $iduser;
               $addsuc->TECH_RECEIVE_NAME = $inforpersonuser->HR_PREFIX_NAME.''.$inforpersonuser->HR_FNAME.' '.$inforpersonuser->HR_LNAME;
               $addsuc->TECH_RECEIVE_DATE = date('Y-m-d');
               $addsuc->TECH_RECEIVE_TIME = date('H:i:s');
               $addsuc->TECH_RECEIVE_COMMENT = 'รับงานแบบรัดขั้นตอนไปดำเนินการสำเร็จ';
               $addsuc->TECH_REPAIR_ID = $iduser;
               $addsuc->TECH_REPAIR_NAME =  $inforpersonuser->HR_PREFIX_NAME.''.$inforpersonuser->HR_FNAME.' '.$inforpersonuser->HR_LNAME;
               $addsuc->TECH_REPAIR_TIME = date('H:i:s');
               $addsuc->TECH_REPAIR_DATE = date('Y-m-d');
               $addsuc->TECH_SUCCESS_DATE = date('Y-m-d');
               $addsuc->TECH_SUCCESS_TIME = date('H:i:s');
               $addsuc->REPAIR_SUCCESS_REMARK = 'ดำเนินการสำเร็จ';
               $addsuc->save();
   
   
  
  
              return redirect()->route('mrepairmedical.repairmedicalinfo'); 
  
      }


    //============================================ทะเบียนครุภัณฑ์=================


    public function repairmedicalinfoasset()
    {

        $repairmedicalinfoasset =DB::table('asset_article')
        ->leftJoin('supplies_decline','supplies_decline.DECLINE_ID','=','asset_article.DECLINE_ID')
        ->leftJoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','asset_article.DEP_ID')
        ->leftJoin('supplies_location','supplies_location.LOCATION_ID','=','asset_article.LOCATION_ID')
        ->leftJoin('supplies_location_level','supplies_location_level.LOCATION_LEVEL_ID','=','asset_article.LOCATION_LEVEL_ID')
        ->leftJoin('supplies_location_level_room','supplies_location_level_room.LEVEL_ROOM_ID','=','asset_article.LEVEL_ROOM_ID')
        ->where('asset_article.DECLINE_ID','=',17)
        ->orderBy('ARTICLE_ID', 'desc')
        ->get();

        

        return view('manager_repairmedical.repairmedicalinfoasset',[
            'repairmedicalinfoassets' => $repairmedicalinfoasset,
     
        ]);
    
    }

    public function detailrepairmedicalasset(Request $request)
    {
        function DateThai($strDate)
        {
        $strYear = date("Y",strtotime($strDate))+543;
        $strMonth= date("n",strtotime($strDate));
        $strDay= date("j",strtotime($strDate));
    
        $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
        $strMonthThai=$strMonthCut[$strMonth];
        return "$strDay $strMonthThai $strYear";
        }
    
        function formateDatetime($strDate)
        {
          $strYear = date("Y",strtotime($strDate))+543;
          $strMonth= date("n",strtotime($strDate));
          $strDay= date("j",strtotime($strDate));
      
          $H= date("H",strtotime($strDate));
          $I= date("i",strtotime($strDate));
      
        $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
        $strMonthThai=$strMonthCut[$strMonth];
      
        return  "$strDay $strMonthThai $strYear $H:$I";
          }
    
    
    
    

             $repairmedicalinfoasset = DB::table('asset_article')
             ->leftjoin('supplies_brand','asset_article.BRAND_ID','=','supplies_brand.BRAND_ID')
             ->leftjoin('asset_color','asset_article.COLOR_ID','=','asset_color.COLOR_ID')
             ->leftJoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','asset_article.DEP_ID')
             ->leftJoin('supplies_location','supplies_location.LOCATION_ID','=','asset_article.LOCATION_ID')
             ->leftJoin('supplies_location_level','supplies_location_level.LOCATION_LEVEL_ID','=','asset_article.LOCATION_LEVEL_ID')
             ->leftJoin('supplies_location_level_room','supplies_location_level_room.LEVEL_ROOM_ID','=','asset_article.LEVEL_ROOM_ID')

             ->leftJoin('supplies_model','supplies_model.MODEL_ID','=','asset_article.MODEL_ID')
             ->leftJoin('supplies_size','supplies_size.SIZE_ID','=','asset_article.SIZE_ID')
             ->where('asset_article.ARTICLE_ID','=',$request->id)->first(); 
          
             

             
    
        $output='    
        
                <div class="row push" style="font-family: \'Kanit\', sans-serif;">
                
                        <div class="col-sm-9">
                        
                        <div class="row">
                            <div class="col-lg-2" align="right">
                            <label>รหัส :</label>
                            </div> 
                            <div class="col-lg-4" align="left">
                            '.$repairmedicalinfoasset->ARTICLE_ID.'
                            </div> 
                            <div class="col-lg-2" align="right">
                            <label>เลขครุภัณฑ์ :</label>
                            </div> 
                            <div class="col-lg-4" align="left">
                            '.$repairmedicalinfoasset->ARTICLE_NUM.'
                            </div> 
                        </div>    
                        <div class="row">
                            <div class="col-lg-2" align="right">
                            <label>ครุภัณฑ์ :</label>
                            </div> 
                            <div class="col-lg-8" align="left">
                            '.$repairmedicalinfoasset->ARTICLE_NAME.'
                            </div> 
                        
                        </div>    
                        
                        <div class="row">
                        <div class="col-lg-2" align="right">
                        <label>อาคาร :</label>
                        </div> 
                        <div class="col-lg-4" align="left">
                        '.$repairmedicalinfoasset->LOCATION_NAME.'
                        </div>
                            <div class="col-lg-1" align="right">
                            <label>ชั้น :</label>
                            </div> 
                            <div class="col-lg-2" align="left">
                            '.$repairmedicalinfoasset->LOCATION_LEVEL_NAME.'
                            </div> 
                            <div class="col-lg-1" align="right">
                            <label>ห้อง :</label>
                            </div> 
                            <div class="col-lg-2" align="left">
                            '.$repairmedicalinfoasset->LEVEL_ROOM_NAME.'
                            </div> 
                        
                        </div>    
                        
                        
                        <div class="row">
                        <div class="col-lg-2" align="right">
                        <label>โมเดล :</label>
                        </div> 
                        <div class="col-lg-4" align="left">
                        '.$repairmedicalinfoasset->MODEL_NAME.'
                        </div> 
                        <div class="col-lg-2" align="right">
                        <label>ขนาด :</label>
                        </div> 
                        <div class="col-lg-4" align="left">
                        '.$repairmedicalinfoasset->SIZE_NAME.'
                        </div> 
                        </div>  


                        <div class="row">
                        <div class="col-lg-2" align="right">
                        <label>ยี่ห้อ :</label>
                        </div> 
                        <div class="col-lg-4" align="left">
                    '.$repairmedicalinfoasset->BRAND_NAME.'
                        </div> 
                        <div class="col-lg-2" align="right">
                        <label>สี :</label>
                        </div> 
                        <div class="col-lg-4" align="left">
                        '.$repairmedicalinfoasset->COLOR_NAME.'
                        </div> 
                    </div> 


                    <div class="row">
                    <div class="col-lg-2" align="right">
                    <label>วันที่รับ :</label>
                    </div> 
                    <div class="col-lg-4" align="left">
                    '.DateThai($repairmedicalinfoasset->RECEIVE_DATE).'
                    </div> 
                    <div class="col-lg-2" align="right">
                    <label>ราคา :</label>
                    </div> 
                    <div class="col-lg-4" align="left">
                    '.$repairmedicalinfoasset->PRICE_PER_UNIT.'
                    </div> 
                    </div> 
                    
            
                
                    <div class="row">
                    <div class="col-lg-2" align="right">
                    <label>รายละเอียด :</label>
                    </div> 
                    <div class="col-lg-10" align="left">
                    '.$repairmedicalinfoasset->ARTICLE_PROP.'
                    </div> 
                    
                    </div>  
                
                    
                    </div>     
                    
                    
                    

                    <div class="col-sm-3">
                    
                    <div class="form-group">
                    <img src="data:image/png;base64,'. chunk_split(base64_encode($repairmedicalinfoasset->IMG)) .'" id="image_upload_preview" alt="กรุณาเพิ่มรูปภาพ" height="200" width="200"/>
                
                    </div>
                    
                    </div>
                </div>
                
        
        
        
        </div>
        
        
        </div>
        
        ';
        
        echo $output;
        
    
    }



    public function repairinfoasset(Request $request,$idasset)
    {


             $repairmedicalinfoasset = DB::table('asset_article')
             ->leftjoin('supplies_brand','asset_article.BRAND_ID','=','supplies_brand.BRAND_ID')
             ->leftJoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','asset_article.DEP_ID')
             ->leftJoin('supplies_location','supplies_location.LOCATION_ID','=','asset_article.LOCATION_ID')
             ->leftJoin('supplies_location_level','supplies_location_level.LOCATION_LEVEL_ID','=','asset_article.LOCATION_LEVEL_ID')
             ->leftJoin('supplies_location_level_room','supplies_location_level_room.LEVEL_ROOM_ID','=','asset_article.LEVEL_ROOM_ID')
             ->leftJoin('supplies_model','supplies_model.MODEL_ID','=','asset_article.MODEL_ID')
             ->leftJoin('supplies_size','supplies_size.SIZE_ID','=','asset_article.SIZE_ID')
             ->leftjoin('asset_color','asset_article.COLOR_ID','=','asset_color.COLOR_ID')
             ->where('asset_article.ARTICLE_ID','=',$idasset)->first(); 


            $infohisrepair = Assetcarerepair::where('asset_care_repair.ARTICLE_ID','=',$repairmedicalinfoasset->ARTICLE_ID)
            ->leftjoin('asset_article','asset_article.ARTICLE_ID','=','asset_care_repair.ARTICLE_ID')
            ->orderBy('asset_care_repair.ID', 'desc') 
            ->get();

            $detailplan = DB::table('asset_care_list')->where('ARTICLE_ID','=',$repairmedicalinfoasset->ARTICLE_ID) ->orderBy('CARE_LIST_ID', 'desc') ->get();
            $planrepair = DB::table('asset_care_repair_plan')->where('REPAIR_PLAN_ARTICLE_ID','=',$repairmedicalinfoasset->ARTICLE_ID)->where('REPAIR_TYPE_CHECK','=','plan') ->orderBy('REPAIR_PLAN_ID', 'desc') ->get();
            $checkrepair = DB::table('asset_care_repair_plan')->where('REPAIR_PLAN_ARTICLE_ID','=',$repairmedicalinfoasset->ARTICLE_ID)->orderBy('REPAIR_PLAN_ID', 'desc') ->get();
            $leader = DB::table('gleave_leader')->get(); 
            $calibration = DB::table('asset_care_calibration')->where('asset_care_calibration.ASSET_CALIBRATION_ARTICLE_ID','=',$repairmedicalinfoasset->ARTICLE_ID)->get();
            $calibrationsub = DB::table('asset_care_calibration_sub')->where('asset_care_calibration_sub.ASSET_CALIBRATION_ARTICLE_ID','=',$repairmedicalinfoasset->ARTICLE_ID)->get();
            $calibration_true = DB::table('asset_care_calibration_true')->where('asset_care_calibration_true.ASSET_CALIBRATIONTRUE_ARTICLE_ID','=',$repairmedicalinfoasset->ARTICLE_ID)->get();
            $calibration_truesub = DB::table('asset_care_calibration_true_sub')->where('asset_care_calibration_true_sub.ASSET_CALIBRATIONTRUESUB_ARTICLE_ID','=',$repairmedicalinfoasset->ARTICLE_ID)->get();
            $calibration_list = DB::table('asset_care_calibration_list')->where('asset_care_calibration_list.ASSET_CALIBRATIONTRUE_LIST_ARTICLE_ID','=',$repairmedicalinfoasset->ARTICLE_ID)->get();


            return view('manager_repairmedical.repairmedicalasset_repair',[
                'repairmedicalinfoasset' => $repairmedicalinfoasset,
                'infohisrepairs' => $infohisrepair,
                'detailplans' => $detailplan,
                'planrepairs' => $planrepair,
                'checkrepairs' => $checkrepair,
                'leaders' => $leader,
                'calibrations' => $calibration,
                'calibration_trues' => $calibration_true,
                'calibration_lists' => $calibration_list,
                'calibrationsubs' => $calibrationsub,
                'calibration_truesubs' => $calibration_truesub,
              ]);

    }

public function repairmedicalinfoasset_calibration_save(Request $request)
    {
            $ARTICLE_ID = $request->REPAIR_PLAN_ARTICLE_ID;
            $REPAIR_ID = $request->REPAIR_PLAN_ARTICLE_NUM;
            $REPAIR_PLAN_DATE = $request->ASSET_CALIBRATION_DATE; 

            if($REPAIR_PLAN_DATE != ''){
                $STARTDAY = Carbon::createFromFormat('d/m/Y', $REPAIR_PLAN_DATE)->format('Y-m-d');
                $date_arrary_st=explode("-",$STARTDAY);  
                $y_sub_st = $date_arrary_st[0]; 
                
                if($y_sub_st >= 2500){
                    $y_st = $y_sub_st-543;
                }else{
                    $y_st = $y_sub_st;
                }
                $m_st = $date_arrary_st[1];
                $d_st = $date_arrary_st[2];  
                $ASSET_CALIBRATIONDATE= $y_st."-".$m_st."-".$d_st;
                }else{
                $ASSET_CALIBRATIONDATE= null;
            }

            $addasset= new Assetcarecalibration();
            $addasset->ASSET_CALIBRATION_ARTICLE_ID = $ARTICLE_ID;
            $addasset->ASSET_CALIBRATION_ARTICLE_NUM = $REPAIR_ID;
            $addasset->ASSET_CALIBRATION_DATE = $ASSET_CALIBRATIONDATE;
            $addasset->ASSET_CALIBRATION_TIME = $request->ASSET_CALIBRATION_TIME;
            $addasset->ASSET_CALIBRATION_TYPE = $request->ASSET_CALIBRATION_TYPE;
            $addasset->save();

            $ASSET_CALIBRATION_ID = Assetcarecalibration::max('ASSET_CALIBRATION_ID');  

                 if($request->ASSET_CALIBRATION_SUB_LIST != '' || $request->ASSET_CALIBRATION_SUB_LIST != null){
     
                     $ASSET_CALIBRATION_SUB_LIST = $request->ASSET_CALIBRATION_SUB_LIST;
                     $ASSET_CALIBRATION_SUB_LISTTRUE = $request->ASSET_CALIBRATION_SUB_LISTTRUE;
                     $ASSET_CALIBRATION_SUB_COMMENT = $request->ASSET_CALIBRATION_SUB_COMMENT;
                  
         
                     $number =count($ASSET_CALIBRATION_SUB_LIST);
                     $count = 0;
                     for($count = 0; $count< $number; $count++)
                     {  
                        $namelist = Asset_care_calibration_list::where('ASSET_CALIBRATION_LIST_ID','=',$ASSET_CALIBRATION_SUB_LIST[$count])->first();

                        $add_sub = new Assetcarecalibration_sub();
                        $add_sub->ASSET_CALIBRATION_SID = $ASSET_CALIBRATION_ID;                    
                        $add_sub->ASSET_CALIBRATION_SUB_LIST = $ASSET_CALIBRATION_SUB_LIST[$count];
                        $add_sub->ASSET_CALIBRATION_SUB_LIST_NAME = $namelist->ASSET_CALIBRATION_LIST_NAME;
                        $add_sub->ASSET_CALIBRATION_SUB_LISTTRUE = $ASSET_CALIBRATION_SUB_LISTTRUE[$count];
                        $add_sub->ASSET_CALIBRATION_SUB_COMMENT = $ASSET_CALIBRATION_SUB_COMMENT[$count];
                        $add_sub->ASSET_CALIBRATION_ARTICLE_ID = $ARTICLE_ID; 
                        $add_sub->ASSET_CALIBRATION_ARTICLE_NUM = $REPAIR_ID;                       
                        $add_sub->save(); 
                      
              
                     }
                 }

    return redirect()->route('mrepairmedical.repairinfoasset',['idasset'=> $ARTICLE_ID]); 
    
}
public function repairmedicalinfoasset_calibration_update(Request $request)
    {
            $ARTICLE_ID = $request->REPAIR_PLAN_ARTICLE_ID;
            $REPAIR_ID = $request->REPAIR_PLAN_ARTICLE_NUM;
            $id = $request->ASSET_CALIBRATION_ID;
            $REPAIR_PLAN_DATE = $request->ASSET_CALIBRATION_DATE; 

            if($REPAIR_PLAN_DATE != ''){
                $STARTDAY = Carbon::createFromFormat('d/m/Y', $REPAIR_PLAN_DATE)->format('Y-m-d');
                $date_arrary_st=explode("-",$STARTDAY);  
                $y_sub_st = $date_arrary_st[0]; 
                
                if($y_sub_st >= 2500){
                    $y_st = $y_sub_st-543;
                }else{
                    $y_st = $y_sub_st;
                }
                $m_st = $date_arrary_st[1];
                $d_st = $date_arrary_st[2];  
                $ASSET_CALIBRATIONDATE= $y_st."-".$m_st."-".$d_st;
                }else{
                $ASSET_CALIBRATIONDATE= null;
            }

            $update= Assetcarecalibration::find($id);
            $update->ASSET_CALIBRATION_ARTICLE_ID = $ARTICLE_ID;
            $update->ASSET_CALIBRATION_ARTICLE_NUM = $REPAIR_ID;
            $update->ASSET_CALIBRATION_DATE = $ASSET_CALIBRATIONDATE;
            $update->ASSET_CALIBRATION_TIME = $request->ASSET_CALIBRATION_TIME;
            $update->ASSET_CALIBRATION_TYPE = $request->ASSET_CALIBRATION_TYPE;
            $update->ASSET_CALIBRATION = $request->ASSET_CALIBRATION;
            $update->ASSET_CALIBRATION_RESULTS = $request->ASSET_CALIBRATION_RESULTS;
            $update->ASSET_CALIBRATION_COMMENT = $request->ASSET_CALIBRATION_COMMENT;                      
            $update->save();

    return redirect()->route('mrepairmedical.repairinfoasset',['idasset'=> $ARTICLE_ID]); 
    
}
public function repairmedicalinfoasset_calibration_destroy(Request $request,$idass,$id)
    {
      
        Assetcarecalibration::destroy($id);
        return redirect()->route('mrepairmedical.repairinfoasset',['idasset'=> $idass]); 
    
    }

public function repairmedicalinfoasset_calibration_true_save(Request $request)
    {
            $ARTICLE_ID = $request->REPAIR_PLAN_ARTICLE_ID;
            $REPAIR_ID = $request->REPAIR_PLAN_ARTICLE_NUM;
            $REPAIR_PLAN_DATE = $request->ASSET_CALIBRATIONTRUE_DATE; 

            if($REPAIR_PLAN_DATE != ''){
                $STARTDAY = Carbon::createFromFormat('d/m/Y', $REPAIR_PLAN_DATE)->format('Y-m-d');
                $date_arrary_st=explode("-",$STARTDAY);  
                $y_sub_st = $date_arrary_st[0]; 
                
                if($y_sub_st >= 2500){
                    $y_st = $y_sub_st-543;
                }else{
                    $y_st = $y_sub_st;
                }
                $m_st = $date_arrary_st[1];
                $d_st = $date_arrary_st[2];  
                $ASSET_CALIBRATIONDATE= $y_st."-".$m_st."-".$d_st;
                }else{
                $ASSET_CALIBRATIONDATE= null;
            }

            $addasset= new Asset_care_calibration_true();
            $addasset->ASSET_CALIBRATIONTRUE_ARTICLE_ID = $ARTICLE_ID;
            $addasset->ASSET_CALIBRATIONTRUE_ARTICLE_NUM = $REPAIR_ID;
            $addasset->ASSET_CALIBRATIONTRUE_DATE = $ASSET_CALIBRATIONDATE;
            $addasset->ASSET_CALIBRATIONTRUE_TIME = $request->ASSET_CALIBRATIONTRUE_TIME;
            $addasset->ASSET_CALIBRATIONTRUE_COMMENT = $request->ASSET_CALIBRATIONTRUE_COMMENT;           
            $addasset->save();

            $ASSET_CALIBRATIONTRUE_ID = Asset_care_calibration_true::max('ASSET_CALIBRATIONTRUE_ID');  

            if($request->ASSET_CALIBRATIONTRUE_SUB_LIST != '' || $request->ASSET_CALIBRATIONTRUE_SUB_LIST != null){

               
                $ASSET_CALIBRATIONTRUE_SUB_LIST = $request->ASSET_CALIBRATIONTRUE_SUB_LIST;
               
    
                $number =count($ASSET_CALIBRATIONTRUE_SUB_LIST);
                $count = 0;
                for($count = 0; $count< $number; $count++)
                {  
                           
                    $namelist = Asset_care_calibration_list::where('ASSET_CALIBRATION_LIST_ID','=',$ASSET_CALIBRATIONTRUE_SUB_LIST[$count])->first();

                    $add_sub = new Asset_care_calibration_true_sub();
                    $add_sub->ASSET_CALIBRATIONTRUE_SID = $ASSET_CALIBRATIONTRUE_ID;  
                    $add_sub->ASSET_CALIBRATIONTRUE_SUB_LIST = $ASSET_CALIBRATIONTRUE_SUB_LIST[$count];
                    $add_sub->ASSET_CALIBRATIONTRUE_SUB_LIST_NAME = $namelist->ASSET_CALIBRATION_LIST_NAME;
                    $add_sub->ASSET_CALIBRATIONTRUESUB_ARTICLE_ID = $ARTICLE_ID; 
                    $add_sub->ASSET_CALIBRATIONTRUESUB_ARTICLE_NUM = $REPAIR_ID;                       
                    $add_sub->save(); 
                    
         
                }
            }

    return redirect()->route('mrepairmedical.repairinfoasset',['idasset'=> $ARTICLE_ID]); 
    
}
public function repairmedicalinfoasset_calibration_true_update(Request $request)
    {
            $ARTICLE_ID = $request->REPAIR_PLAN_ARTICLE_ID;
            $REPAIR_ID = $request->REPAIR_PLAN_ARTICLE_NUM;
            $id = $request->ASSET_CALIBRATIONTRUE_ID;

            $REPAIR_PLAN_DATE = $request->ASSET_CALIBRATIONTRUE_DATE; 

            if($REPAIR_PLAN_DATE != ''){
                $STARTDAY = Carbon::createFromFormat('d/m/Y', $REPAIR_PLAN_DATE)->format('Y-m-d');
                $date_arrary_st=explode("-",$STARTDAY);  
                $y_sub_st = $date_arrary_st[0]; 
                
                if($y_sub_st >= 2500){
                    $y_st = $y_sub_st-543;
                }else{
                    $y_st = $y_sub_st;
                }
                $m_st = $date_arrary_st[1];
                $d_st = $date_arrary_st[2];  
                $ASSET_CALIBRATIONDATE= $y_st."-".$m_st."-".$d_st;
                }else{
                $ASSET_CALIBRATIONDATE= null;
            }

            $update= Asset_care_calibration_true::find($id);
            $update->ASSET_CALIBRATIONTRUE_ARTICLE_ID = $ARTICLE_ID;
            $update->ASSET_CALIBRATIONTRUE_ARTICLE_NUM = $REPAIR_ID;
            $update->ASSET_CALIBRATIONTRUE_DATE = $ASSET_CALIBRATIONDATE;
            $update->ASSET_CALIBRATIONTRUE_TIME = $request->ASSET_CALIBRATIONTRUE_TIME;
            $update->ASSET_CALIBRATIONTRUE = $request->ASSET_CALIBRATIONTRUE;
            $update->ASSET_CALIBRATIONTRUE_COMMENT = $request->ASSET_CALIBRATIONTRUE_COMMENT;                      
            $update->save();

    return redirect()->route('mrepairmedical.repairinfoasset',['idasset'=> $ARTICLE_ID]); 
    
}
public function repairmedicalinfoasset_calibration_true_destroy(Request $request,$idass,$id)
    {
      
        Asset_care_calibration_true::destroy($id);
        return redirect()->route('mrepairmedical.repairinfoasset',['idasset'=> $idass]); 
    
    }



    public function repairmedicalinfoasset_planrepair_destroy(Request $request,$idasset,$id)
    {
       
        Assetcarerepairplan::where('REPAIR_PLAN_ID','=',$id)->delete();
        Assetcarerepairplansub::where('REPAIR_PLAN_ID','=',$id)->delete();
      
   
        return redirect()->route('mrepairmedical.repairinfoasset',['idasset'=> $idasset]); 
    
    }


























public function repairmedicalinfoasset_calibration_list_save(Request $request)
    {
            $ARTICLE_ID = $request->REPAIR_PLAN_ARTICLE_ID;
            $REPAIR_ID = $request->REPAIR_PLAN_ARTICLE_NUM;
          
            $addasset= new Asset_care_calibration_list();
            $addasset->ASSET_CALIBRATIONTRUE_LIST_ARTICLE_ID = $ARTICLE_ID;
            $addasset->ASSET_CALIBRATIONTRUE_LIST_ARTICLE_NUM = $REPAIR_ID;
            $addasset->ASSET_CALIBRATION_LIST_NAME = $request->ASSET_CALIBRATION_LIST_NAME;                     
            $addasset->save();

    return redirect()->route('mrepairmedical.repairinfoasset',['idasset'=> $ARTICLE_ID]); 
    
}

public function repairmedicalinfoasset_calibration_list_update(Request $request)
    {
            $ARTICLE_ID = $request->REPAIR_PLAN_ARTICLE_ID;
            $REPAIR_ID = $request->REPAIR_PLAN_ARTICLE_NUM;
            $id = $request->ASSET_CALIBRATION_LIST_ID;

            $update= Asset_care_calibration_list::find($id);
            $update->ASSET_CALIBRATIONTRUE_LIST_ARTICLE_ID = $ARTICLE_ID;
            $update->ASSET_CALIBRATIONTRUE_LIST_ARTICLE_NUM = $REPAIR_ID;
            $update->ASSET_CALIBRATION_LIST_NAME = $request->ASSET_CALIBRATION_LIST_NAME;                     
            $update->save();

    return redirect()->route('mrepairmedical.repairinfoasset',['idasset'=> $ARTICLE_ID]); 
    
}
public function repairmedicalinfoasset_calibration_list_destroy(Request $request,$idass,$id)
    {
      
        Asset_care_calibration_list::destroy($id);
        return redirect()->route('mrepairmedical.repairinfoasset',['idasset'=> $idass]); 
    
    }


        public function savecheckrepairmedical(Request $request)
        {
    
     
                 $ARTICLE_ID = $request->REPAIR_PLAN_ARTICLE_ID;
                 $REPAIR_ID = $request->REPAIR_PLAN_ARTICLE_NUM;
                 
               // dd($ARTICLE_ID);

                 $REPAIR_PLAN_DATE = $request->REPAIR_PLAN_DATE; 

                 if($REPAIR_PLAN_DATE != ''){
                     $STARTDAY = Carbon::createFromFormat('d/m/Y', $REPAIR_PLAN_DATE)->format('Y-m-d');
                     $date_arrary_st=explode("-",$STARTDAY);  
                     $y_sub_st = $date_arrary_st[0]; 
                     
                     if($y_sub_st >= 2500){
                         $y_st = $y_sub_st-543;
                     }else{
                         $y_st = $y_sub_st;
                     }
                     $m_st = $date_arrary_st[1];
                     $d_st = $date_arrary_st[2];  
                     $REPAIR_PLAN_DATE= $y_st."-".$m_st."-".$d_st;
                     }else{
                     $REPAIR_PLAN_DATE= null;
                 }
     
                 $addasset= new Assetcarerepairplan();
                 $addasset->REPAIR_PLAN_ARTICLE_ID = $ARTICLE_ID;
                 $addasset->REPAIR_PLAN_ARTICLE_NUM = $REPAIR_ID;
                 $addasset->REPAIR_PLAN_DATE = $REPAIR_PLAN_DATE;
                 $addasset->REPAIR_PLAN_BEGIN_TIME = $request->REPAIR_PLAN_BEGIN_TIME;
                 $addasset->REPAIR_PLAN_END_TIME = $request->REPAIR_PLAN_END_TIME;


                 $addasset->REPAIR_PESON_CHECK_ID = $request->REPAIR_PESON_CHECK_ID;

                 $CHECK_HR_NAME=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                 ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
                 ->where('hrd_person.ID','=',$request->REPAIR_PESON_CHECK_ID)->first();
                 $addasset->REPAIR_PESON_CHECK_NAME    = $CHECK_HR_NAME->HR_PREFIX_NAME.''.$CHECK_HR_NAME->HR_FNAME.' '.$CHECK_HR_NAME->HR_LNAME;
          
         
                 $addasset->REPAIR_LEADER_CHECK_ID = $request->REPAIR_LEADER_CHECK_ID;
                 $CHECK_LEADER =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                 ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
                 ->where('hrd_person.ID','=',$request->REPAIR_LEADER_CHECK_ID)->first();
                 $addasset->REPAIR_LEADER_CHECK_NAME    = $CHECK_LEADER->HR_PREFIX_NAME.''.$CHECK_LEADER->HR_FNAME.' '.$CHECK_LEADER->HR_LNAME;
                 
                 
                 
                 $addasset->REPAIR_PLAN_REMARK = $request->REPAIR_PLAN_REMARK;
             
                 $addasset->REPAIR_TYPE_CHECK  = 'notplan';
                  
                
                 $addasset->save();
     
                
                
                
                 $REPAIR_PLAN_ID = Assetcarerepairplan::max('REPAIR_PLAN_ID');
             


                 if($request->REPAIR_PLAN_SUB_NAME != '' || $request->REPAIR_PLAN_SUB_NAME != null){
     
                     $REPAIR_PLAN_SUB_NAME = $request->REPAIR_PLAN_SUB_NAME;
                     $REPAIR_PLAN_SUB_REMARK = $request->REPAIR_PLAN_SUB_REMARK;
                     $REPAIR_PLAN_SUB_RESULT = $request->REPAIR_PLAN_SUB_RESULT;
                  
         
                     $number =count($REPAIR_PLAN_SUB_NAME);
                     $count = 0;
                     for($count = 0; $count< $number; $count++)
                     {  
                       //echo $row3[$count_3]."<br>";
                      
                        $add = new Assetcarerepairplansub();
                        $add->REPAIR_PLAN_ID = $REPAIR_PLAN_ID;
                    
                        $add->REPAIR_PLAN_SUB_NAME = $REPAIR_PLAN_SUB_NAME[$count];
                        $add->REPAIR_PLAN_SUB_REMARK = $REPAIR_PLAN_SUB_REMARK[$count];
                        $add->REPAIR_PLAN_SUB_RESULT = $REPAIR_PLAN_SUB_RESULT[$count];
                      
                        $add->save(); 
                      
              
                     }
                 }
     
     

                 $check = DB::table('asset_care_repair_plan_sub')
                 ->where('REPAIR_PLAN_ID','=',$REPAIR_PLAN_ID)
                 ->where('REPAIR_PLAN_SUB_RESULT','=','ผิดปกติ')
                 ->count();
                 
                 if($check !=0){
                     $upadtecheck = Assetcarerepairplan::find($REPAIR_PLAN_ID); 
                     $upadtecheck->REPAIR_RESULT = 'ผิดปกติ';
                     $upadtecheck->save(); 
         
                 }else{
                    $upadtecheck = Assetcarerepairplan::find($REPAIR_PLAN_ID); 
                    $upadtecheck->REPAIR_RESULT = 'ปกติ';
                    $upadtecheck->save(); 
                 }
    
    
    
                return redirect()->route('mrepairmedical.repairinfoasset',['idasset'=> $ARTICLE_ID]); 
    
        }




        public function checkrepairmedicalall(Request $request)
        {
    
     
                 $ARTICLE_ID = $request->REPAIR_PLAN_ARTICLE_ID;
                 $REPAIR_ID = $request->REPAIR_PLAN_ARTICLE_NUM;
                 $REPAIR_PLAN_ID = $request->REPAIR_PLAN_ID;
                 
               // dd($ARTICLE_ID);

              
     
                 $addasset= Assetcarerepairplan::find($REPAIR_PLAN_ID);
                 $addasset->REPAIR_PLAN_ARTICLE_ID = $ARTICLE_ID;
                 $addasset->REPAIR_PLAN_ARTICLE_NUM = $REPAIR_ID;
           


                 $addasset->REPAIR_PESON_CHECK_ID = $request->REPAIR_PESON_CHECK_ID;

                 $CHECK_HR_NAME=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                 ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
                 ->where('hrd_person.ID','=',$request->REPAIR_PESON_CHECK_ID)->first();
                 $addasset->REPAIR_PESON_CHECK_NAME    = $CHECK_HR_NAME->HR_PREFIX_NAME.''.$CHECK_HR_NAME->HR_FNAME.' '.$CHECK_HR_NAME->HR_LNAME;
          
         
                 $addasset->REPAIR_LEADER_CHECK_ID = $request->REPAIR_LEADER_CHECK_ID;
                 $CHECK_LEADER =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                 ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
                 ->where('hrd_person.ID','=',$request->REPAIR_LEADER_CHECK_ID)->first();
                 $addasset->REPAIR_LEADER_CHECK_NAME    = $CHECK_LEADER->HR_PREFIX_NAME.''.$CHECK_LEADER->HR_FNAME.' '.$CHECK_LEADER->HR_LNAME;

                 $addasset->REPAIR_PLAN_REMARK = $request->REPAIR_PLAN_REMARK;

                 $addasset->save();
     
                
                

                 if($request->REPAIR_PLAN_SUB_NAME != '' || $request->REPAIR_PLAN_SUB_NAME != null){
                    
                    Assetcarerepairplansub::where('REPAIR_PLAN_ID','=',$REPAIR_PLAN_ID)->delete(); 

                     $REPAIR_PLAN_SUB_NAME = $request->REPAIR_PLAN_SUB_NAME;
                     $REPAIR_PLAN_SUB_REMARK = $request->REPAIR_PLAN_SUB_REMARK;
                     $REPAIR_PLAN_SUB_RESULT = $request->REPAIR_PLAN_SUB_RESULT;
                  
         
                     $number =count($REPAIR_PLAN_SUB_NAME);
                     $count = 0;
                     for($count = 0; $count< $number; $count++)
                     {  
                       //echo $row3[$count_3]."<br>";
                      
                        $add = new Assetcarerepairplansub();
                        $add->REPAIR_PLAN_ID = $REPAIR_PLAN_ID;
                    
                        $add->REPAIR_PLAN_SUB_NAME = $REPAIR_PLAN_SUB_NAME[$count];
                        $add->REPAIR_PLAN_SUB_REMARK = $REPAIR_PLAN_SUB_REMARK[$count];
                        $add->REPAIR_PLAN_SUB_RESULT = $REPAIR_PLAN_SUB_RESULT[$count];
                      
                        $add->save(); 
                      
              
                     }
                 }
     
     

                 $check = DB::table('asset_care_repair_plan_sub')
                 ->where('REPAIR_PLAN_ID','=',$REPAIR_PLAN_ID)
                 ->where('REPAIR_PLAN_SUB_RESULT','=','ผิดปกติ')
                 ->count();
                 
                 if($check !=0){
                     $upadtecheck = Assetcarerepairplan::find($REPAIR_PLAN_ID); 
                     $upadtecheck->REPAIR_RESULT = 'ผิดปกติ';
                     $upadtecheck->save(); 
         
                 }else{
                    $upadtecheck = Assetcarerepairplan::find($REPAIR_PLAN_ID); 
                    $upadtecheck->REPAIR_RESULT = 'ปกติ';
                    $upadtecheck->save(); 
                 }
    
    
    
                return redirect()->route('mrepairmedical.repairinfoasset',['idasset'=> $ARTICLE_ID]); 
    
        }




      
        public function saveplanrepairmedical(Request $request)
        {
    
     
                 $ARTICLE_ID = $request->REPAIR_PLAN_ARTICLE_ID;
                 $REPAIR_ID = $request->REPAIR_PLAN_ARTICLE_NUM;
                 
                 //dd($ID);

                 $REPAIR_PLAN_DATE = $request->REPAIR_PLAN_DATE; 

                 if($REPAIR_PLAN_DATE != ''){
                     $STARTDAY = Carbon::createFromFormat('d/m/Y', $REPAIR_PLAN_DATE)->format('Y-m-d');
                     $date_arrary_st=explode("-",$STARTDAY);  
                     $y_sub_st = $date_arrary_st[0]; 
                     
                     if($y_sub_st >= 2500){
                         $y_st = $y_sub_st-543;
                     }else{
                         $y_st = $y_sub_st;
                     }
                     $m_st = $date_arrary_st[1];
                     $d_st = $date_arrary_st[2];  
                     $REPAIR_PLAN_DATE= $y_st."-".$m_st."-".$d_st;
                     }else{
                     $REPAIR_PLAN_DATE= null;
                 }
     
                 $addasset= new Assetcarerepairplan();
                 $addasset->REPAIR_PLAN_ARTICLE_ID = $ARTICLE_ID;
                 $addasset->REPAIR_PLAN_ARTICLE_NUM = $REPAIR_ID;
                 $addasset->REPAIR_PLAN_DATE = $REPAIR_PLAN_DATE;
                 $addasset->REPAIR_PLAN_BEGIN_TIME = $request->REPAIR_PLAN_BEGIN_TIME;
                 $addasset->REPAIR_PLAN_END_TIME = $request->REPAIR_PLAN_END_TIME;
                 $addasset->REPAIR_PLAN_REMARK = $request->REPAIR_PLAN_REMARK;
                
                 $addasset->save();
     
                 $REPAIR_PLAN_ID = Assetcarerepairplan::max('REPAIR_PLAN_ID');
             
     
                 if($request->REPAIR_PLAN_SUB_NAME != '' || $request->REPAIR_PLAN_SUB_NAME != null){
     
                     $REPAIR_PLAN_SUB_NAME = $request->REPAIR_PLAN_SUB_NAME;
                     $REPAIR_PLAN_SUB_REMARK = $request->REPAIR_PLAN_SUB_REMARK;
                  
                  
         
                     $number =count($REPAIR_PLAN_SUB_NAME);
                     $count = 0;
                     for($count = 0; $count< $number; $count++)
                     {  
                       //echo $row3[$count_3]."<br>";
                      
                        $add = new Assetcarerepairplansub();
                        $add->REPAIR_PLAN_ID = $REPAIR_PLAN_ID;
                    
                        $add->REPAIR_PLAN_SUB_NAME = $REPAIR_PLAN_SUB_NAME[$count];
                        $add->REPAIR_PLAN_SUB_REMARK = $REPAIR_PLAN_SUB_REMARK[$count];
                      
                        $add->save(); 
                      
              
                     }
                 }
     
     
    
    
    
                return redirect()->route('mrepairmedical.repairinfoasset',['idasset'=> $ARTICLE_ID]); 
    
        }


   //---------------------------ฟังชั่น------------------------------
   function checkmedicalrepair(Request $request)
   {
      
     $repair = $request->get('repair');
   

     if($repair == 'notrepair'){
        $output ='   

        <div class="row push"> 
        <input type="hidden" class="form-control input-sm"  name="OUTSIDE_ACTIVE" id="OUTSIDE_ACTIVE" value="true">
        <div class="col-lg-2">
        <label>เหตุผลที่ส่งซ่อม :</label>
        </div> 
        <div class="col-lg-10">
        <textarea class="form-control input-sm" rows="2" name="OUTSIDE_COMMENT" id="OUTSIDE_COMMENT"></textarea>
        </div>  
        </div>

        <div class="row push"> 
        <div class="col-lg-2">
        <label>อุปกรณ์ที่ติดไปด้วย :</label>
        </div> 
        <div class="col-lg-10">
        <textarea class="form-control input-sm" rows="2" name="OUTSIDE_TOOL" id="OUTSIDE_TOOL"></textarea>
        </div>  
        </div>

        <div class="row push"> 
            <div class="col-lg-2">
            <label>ส่งซ่อมที่ร้าน :</label>
            </div> 
            <div class="col-lg-10">
            <input class="form-control input-sm"  name="OUTSIDE_SHOP" id="OUTSIDE_SHOP">
            </div>  
        </div>

            <div class="row push"> 
            <div class="col-lg-2">
            <label>ผู้รับสิ่งของ :</label>
            </div> 
            <div class="col-lg-10">
            <input class="form-control input-sm"  name="OUTSIDE_EMP" id="OUTSIDE_EMP">
            </div>  
            </div>
            
            <div class="row push">
            <div class="col-sm-2">
            <label>ความเร่งด่วน :</label>
            </div> 
            <div class="col-lg-10">
            <select name="PRIORITY_ID" id="PRIORITY_ID" class="form-control input-lg" style=" font-family: \'Kanit\', sans-serif;" >
                <option value="1">ปกติ</option>
                <option value="2">ด่วน</option>
                <option value="3">ด่วนมาก</option>
                <option value="4">ด่วนที่สุด</option>
                 </select> 
                   
            </div>';
     }else{
        $output = '
        <input type="hidden" class="form-control input-sm"  name="OUTSIDE_ACTIVE" id="OUTSIDE_ACTIVE" value="false">
        <input type="hidden" class="form-control input-sm"  name="OUTSIDE_COMMENT" id="OUTSIDE_COMMENT" value="">
        <input type="hidden" class="form-control input-sm"  name="OUTSIDE_TOOL" id="OUTSIDE_TOOL" value="">
        <input type="hidden" class="form-control input-sm"  name="OUTSIDE_SHOP" id="OUTSIDE_SHOP" value="">
        <input type="hidden" class="form-control input-sm"  name="OUTSIDE_EMP" id="OUTSIDE_EMP" value="">
        <input type="hidden" class="form-control input-sm"  name="PRIORITY_ID" id="PRIORITY_ID" value="">
        
        ';
     }
     

   echo $output;
       
   }


   function checksummoney(Request $request)
   {
      
     $REPAIR_TOTAL = $request->get('REPAIR_TOTAL');
     $REPAIR_PRICE_PER_UNIT = $request->get('REPAIR_PRICE_PER_UNIT');
   
     $output = $REPAIR_TOTAL*$REPAIR_PRICE_PER_UNIT;


     echo $output;
       
   }

   function pdf_medical(Request $request,$idref)
   {

    $inforepairmedical = Assetcarerepair::where('asset_care_repair.ID', '=',$idref)
    ->leftjoin('asset_article','asset_care_repair.ARTICLE_ID','=','asset_article.ARTICLE_ID')
    ->leftjoin('hrd_person','asset_care_repair.USER_REQUEST_ID','=','hrd_person.ID')
    ->leftjoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_SUB_ID')
    ->first(); 
    
  
   $html = View('manager_repairmedical.pdf_medical',[
      'inforepairmedical' => $inforepairmedical
   ]);
   return viewpdf($html);



   }
    
   public function repairmedicalassetsave_carelist(Request $request)
   {

            $ARTICLE_ID = $request->PLAN_ARTICLE_ID;

            $addcarelist= new Assetcarelist();
            $addcarelist->ARTICLE_ID = $ARTICLE_ID;
            $addcarelist->CARE_LIST_NAME = $request->CARE_LIST_NAME;
            $addcarelist->save();
            
            return redirect()->route('mrepairmedical.repairinfoasset',['idasset'=> $ARTICLE_ID]); 

   }   
   public function repairmedicalassetupdate_carelist(Request $request)
   {
       $ARTICLE_ID = $request->PLAN_ARTICLE_ID;
       $LIST_ID = $request->CARE_LIST_ID;

       $update= Assetcarelist::find($LIST_ID);
       $update->ARTICLE_ID = $ARTICLE_ID;
       $update->CARE_LIST_NAME = $request->CARE_LIST_NAME;
       $update->save();            
       return redirect()->route('mrepairmedical.repairinfoasset',['idasset'=> $ARTICLE_ID]);     
   }
   public function repairmedicalinfoasset_carelist_destroy(Request $request,$idasset,$id)
   {
       $repaircominfoasset = DB::table('asset_article')
       ->leftJoin('supplies_location','supplies_location.LOCATION_ID','=','asset_article.LOCATION_ID')
       ->leftJoin('supplies_location_level','supplies_location_level.LOCATION_LEVEL_ID','=','asset_article.LOCATION_LEVEL_ID')
       ->leftJoin('supplies_location_level_room','supplies_location_level_room.LEVEL_ROOM_ID','=','asset_article.LEVEL_ROOM_ID')
       ->leftjoin('supplies_brand','asset_article.BRAND_ID','=','supplies_brand.BRAND_ID')
       ->leftjoin('asset_color','asset_article.COLOR_ID','=','asset_color.COLOR_ID')
       ->leftjoin('supplies_model','asset_article.MODEL_ID','=','supplies_model.MODEL_ID')
       ->where('asset_article.ARTICLE_ID','=',$idasset)->first(); 
      
       Assetcarelist::where('ARTICLE_ID','=',$repaircominfoasset->ARTICLE_ID)->where('CARE_LIST_ID','=',$id)->delete();  

       return redirect()->route('mrepairmedical.repairinfoasset',['idasset'=> $idasset]);     
   }








             //-----------------------------ตั้งค่าระบบงานซ่อม


             public function setting_typesystem()
             {
                
                 $infosystemtype = Assetcaresystemtype::orderBy('INFORMMED_ST_ID', 'asc')  
                                                         ->get();
                                              
                
                 return view('manager_repairmedical.setupinformmedsystemtype',[
                     'infosystemtypes' => $infosystemtype
                 ]);
             }
             
             public function setting_typesystem_add(Request $request)
                 {
               
                     return view('manager_repairmedical.setupinformmedsystemtype_add');
             
                 }
             
                 public function setting_typesystem_save(Request $request)
                 {
                    
             
                         $addarticle = new Assetcaresystemtype(); 
                         $addarticle->INFORMMED_ST_NAME = $request->INFORMMED_ST_NAME;
                      
              
                         $addarticle->save();
             
             
                         return redirect()->route('mrepairmedical.setting_typesystem'); 
                 }
             
                 public function setting_typesystem_edit(Request $request,$id)
                 {
                   
                 
                    $id_in= $id;
                  
                    $infosystem = Assetcaresystemtype::where('INFORMMED_ST_ID','=',$id_in)
                    ->first();
             
             
             
                     return view('manager_repairmedical.setupinformmedsystemtype_edit',[
                     'infosystem' => $infosystem 
                     ]);
             
                 }
             
             
             
                 public function setting_typesystem_update(Request $request)
                 {
                     $id = $request->INFORMMED_ST_ID; 
             
                     $updatesystem = Assetcaresystemtype::find($id);
                     $updatesystem->INFORMMED_ST_NAME = $request->INFORMMED_ST_NAME;
                     $updatesystem->save();
             
             
                     return redirect()->route('mrepairmedical.setting_typesystem'); 
             
                 }
             
                 
                 public function setting_typesystem_delete($id) { 
             
                    Assetcaresystemtype::destroy($id);         
                     return redirect()->route('mrepairmedical.setting_typesystem');   
                 }
    


}
