<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Person;
use App\Models\Informcomrepair;
use App\Models\Informcomrepairengineer;

use App\Models\Informrepairindex;
use App\Models\Informrepairindextech;
use App\Models\Informcomservice;

use App\Models\Informcomplan;
use App\Models\Informcomplansub;
use App\Models\Assetcarelist;
use App\Models\Assetarticle;
use App\Models\Warehouserequest;
use App\Models\Warehouserequestsub;
use App\Models\Warehousetreasurypay;
use App\Models\Warehousetreasuryexportsub;

use App\Models\Informcomsystemtype;
use App\Models\Infomrepair_functioncom;

use Session;
use App\Http\Controllers\Report\InformrepaircomReportController;

date_default_timezone_set("Asia/Bangkok");

class ManagerrepaircomController extends Controller
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
        $year_ad               = $year - 543; // ปี ค.ศ.   // แยกใช้ตามแต่ฟังก์ชัน

        $repairCom = new InformrepaircomReportController();
        $data['repairstatus_all'] = $repairCom->countRepaircomBystatus('all',$year_ad);
        $data['repairstatus_request'] = $repairCom->countRepaircomBystatus('REQUEST',$year_ad);
        $data['repairstatus_receive'] = $repairCom->countRepaircomBystatus('RECEIVE',$year_ad);
        $data['repairstatus_pending'] = $repairCom->countRepaircomBystatus('PENDING',$year_ad);
        $data['repairstatus_success'] = $repairCom->countRepaircomBystatus('SUCCESS',$year_ad);
        $data['repairstatus_outside'] = $repairCom->countRepaircomBystatus('OUTSIDE',$year_ad);
        $data['repairstatus_deal'] = $repairCom->countRepaircomBystatus('DEAL',$year_ad);
        $data['repairstatus_repair_out'] = $repairCom->countRepaircomBystatus('REPAIR_OUT',$year_ad);
        $data['repairstatus_cancel'] = $repairCom->countRepaircomBystatus('CANCEL',$year_ad);

        $data['reapaircom_day'] = $repairCom->countRepaircomBybetween(date('Y-m-d'),date('Y-m-d'));
        $data['reapaircom_month'] = $repairCom->countRepaircomBybetween(date('Y-m-1'),date('Y-m-d',strtotime(date('Y-m-1') .' +1month-1day')));
        $data['reapaircom_year'] = $repairCom->countRepaircomBybetween(date(($year_ad-1).'-09-1'),date($year_ad.'-m-d'));
        $data['reapaircomPlan_day'] = $repairCom->countRepaircomplanBybetween(date('Y-m-d'),date('Y-m-d'));
        $data['reapaircomPlan_month'] = $repairCom->countRepaircomplanBybetween(date('Y-m-1'),date('Y-m-d',strtotime(date('Y-m-1') .' +1month-1day')));
        $data['reapaircomPlan_year'] = $repairCom->countRepaircomplanBybetween(date(($year_ad-1).'-09-1'),date($year_ad.'-m-d'));
        $data['repaircom_M'] =  $repairCom->countRepaircom_M($year_ad);
        $data['repaircom_M_success'] =  $repairCom->countRepaircom_M_success($year_ad);
        $data['repaircom_score'] =  $repairCom->countRepaircomFancinessScore($year_ad);
        $data['repaircomPlan_result'] =  $repairCom->countRepaircomplan_Result($year_ad);
        $workperson =  $repairCom->countWorkofperson($year_ad);
        $w_person = array();
        foreach($workperson as $row){
            $w_person[$row['id']]['name'] = $repairCom->getNameTechByperson_id($row['id']);
            $w_person[$row['id']]['amount'] = $row['count'];
        }
        $data['workofperson'] = $w_person;
        $data['countRepairPlan_M'] =  $repairCom->countRepairPlan_M($year_ad);
        
        return view('manager_repaircom.dashboard_repaircom',$data);
    }
    public function repaircom_search()
    {
        $data['budgetyear']          = getBudgetYear();
        $year_now                    = $data['budgetyear'] - 543; // ปี ค.ศ. ปัจจุบัน กำหนดก่อนมีการเลือกจาก dashboard
        $data['budgetyear_dropdown'] = getBudgetYearAmount();
        if (!empty($_GET['budgetyear'])) {
            $data['budgetyear'] = $_GET['budgetyear'];
        }
        $year                  = $data['budgetyear']; // ปี พ.ศ.
        $year_ad               = $year - 543; // ปี ค.ศ.   // แยกใช้ตามแต่ฟังก์ชั่น
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
        $repairCom = new InformrepaircomReportController();
        $data['repaircom'] = $repairCom->getRepaircom_Bybudgetyear_status($year_ad , $data['repairstatus']);
        return view('manager_repaircom.repaircom_search',$data);
        
    }
    
    public function dashboardsearch(Request $request)
    {

        $year_id = $request->STATUS_CODE;
        $year = $year_id - 543;

        $amount_1 = DB::table('informcom_repair')->where('DATE_TIME_REQUEST','like',$year.'%')->count();
        $amount_2 = DB::table('informcom_repair')->where('REPAIR_STATUS','=','REQUEST')->where('DATE_TIME_REQUEST','like',$year.'%')->count();
        $amount_3 = DB::table('informcom_repair')->where('REPAIR_STATUS','=','PENDING')->where('DATE_TIME_REQUEST','like',$year.'%')->count();
        $amount_4 = DB::table('informcom_repair')->where('REPAIR_STATUS','=','SUCCESS')->where('DATE_TIME_REQUEST','like',$year.'%')->count();
        $amount_5 = DB::table('informcom_repair')->where('REPAIR_STATUS','=','CANCEL')->where('DATE_TIME_REQUEST','like',$year.'%')->count();
        $amount_6 = DB::table('informcom_repair')->where('REPAIR_STATUS','=','OUTSIDE')->where('DATE_TIME_REQUEST','like',$year.'%')->count();
        $amount_7 = DB::table('informcom_repair')->where('REPAIR_STATUS','=','RECEIVE')->where('DATE_TIME_REQUEST','like',date('Y').'%')->count();
        $amount_8 = DB::table('informcom_repair')->where('REPAIR_STATUS','=','DEAL')->where('DATE_TIME_REQUEST','like',date('Y').'%')->count();


        $amount_repairdate = DB::table('informcom_repair')->where('REPAIR_STATUS','=','REQUEST')->where('DATE_TIME_REQUEST','like',date('Y-m-d').'%')->count();
        $amount_repair = DB::table('informcom_repair')->where('REPAIR_STATUS','=','REQUEST')->where('DATE_TIME_REQUEST','like',$year.'%')->count();

        $amount_checkdate = DB::table('informcom_plan')->where('REPAIR_RESULT','=',NULL)->where('REPAIR_PLAN_DATE','like',date('Y-m-d'))->count();
        $amount_check = DB::table('informcom_plan')->where('REPAIR_RESULT','=',NULL)->where('REPAIR_PLAN_DATE','like',$year.'%')->count();
    
        $m1 = DB::table('informcom_repair')->where('DATE_TIME_REQUEST','like',$year.'-01%')->count();
        $m2 = DB::table('informcom_repair')->where('DATE_TIME_REQUEST','like',$year.'-02%')->count();
        $m3 = DB::table('informcom_repair')->where('DATE_TIME_REQUEST','like',$year.'-03%')->count();
        $m4 = DB::table('informcom_repair')->where('DATE_TIME_REQUEST','like',$year.'-04%')->count();
        $m5 = DB::table('informcom_repair')->where('DATE_TIME_REQUEST','like',$year.'-05%')->count();
        $m6 = DB::table('informcom_repair')->where('DATE_TIME_REQUEST','like',$year.'-06%')->count();
        $m7 = DB::table('informcom_repair')->where('DATE_TIME_REQUEST','like',$year.'-07%')->count();
        $m8 = DB::table('informcom_repair')->where('DATE_TIME_REQUEST','like',$year.'-08%')->count();
        $m9 = DB::table('informcom_repair')->where('DATE_TIME_REQUEST','like',$year.'-09%')->count();
        $m10 = DB::table('informcom_repair')->where('DATE_TIME_REQUEST','like',$year.'-10%')->count();
        $m11 = DB::table('informcom_repair')->where('DATE_TIME_REQUEST','like',$year.'-11%')->count();
        $m12 = DB::table('informcom_repair')->where('DATE_TIME_REQUEST','like',$year.'-12%')->count();
         
        $REQUEST = DB::table('informcom_repair')->where('REPAIR_STATUS','=','REQUEST')->where('DATE_TIME_REQUEST','like',$year.'%')->count();
        $RECEIVE = DB::table('informcom_repair')->where('REPAIR_STATUS','=','RECEIVE')->where('DATE_TIME_REQUEST','like',$year.'%')->count();
        $PENDING = DB::table('informcom_repair')->where('REPAIR_STATUS','=','PENDING')->where('DATE_TIME_REQUEST','like',$year.'%')->count();
        $SUCCESS = DB::table('informcom_repair')->where('REPAIR_STATUS','=','SUCCESS')->where('DATE_TIME_REQUEST','like',$year.'%')->count();
        $OUTSIDE = DB::table('informcom_repair')->where('REPAIR_STATUS','=','OUTSIDE')->where('DATE_TIME_REQUEST','like',$year.'%')->count();
        $DEAL = DB::table('informcom_repair')->where('REPAIR_STATUS','=','DEAL')->where('DATE_TIME_REQUEST','like',$year.'%')->count();
        $CANCEL = DB::table('informcom_repair')->where('REPAIR_STATUS','=','CANCEL')->where('DATE_TIME_REQUEST','like',$year.'%')->count();
     
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

    
        return view('manager_repaircom.dashboard_repaircom',[
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
        $inforepaircom = DB::table('informcom_plan')->get();
    
        return view('manager_repaircom.carcalendar_repaircom',[
            'inforepaircoms' => $inforepaircom
        ]);
    }

    public function repaircominfo(Request $request)
    {
      if(!empty($request->_token)){
            $search = $request->get('search');
            $status = $request->SEND_STATUS;
            $datebigin = $request->get('DATE_BIGIN');
            $dateend = $request->get('DATE_END');
            $yearbudget = $request->BUDGET_YEAR;
        session([
            'manager_repaircom.repaircominfo.search' => $search,
            'manager_repaircom.repaircominfo.status' => $status,
            'manager_repaircom.repaircominfo.datebigin' => $datebigin,
            'manager_repaircom.repaircominfo.dateend' => $dateend,
            'manager_repaircom.repaircominfo.yearbudget' => $yearbudget
            ]);
    }elseif(!empty(session('manager_repaircom.repaircominfo'))){
        $search     = session('manager_repaircom.repaircominfo.search');
        $status     = session('manager_repaircom.repaircominfo.status');
        $datebigin  = session('manager_repaircom.repaircominfo.datebigin');
        $dateend    = session('manager_repaircom.repaircominfo.dateend');
        $yearbudget = session('manager_repaircom.repaircominfo.yearbudget');
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
              $inforepaircom = Informcomrepair::select('REPAIR_ID','REPAIR_STATUS','PRIORITY_ID','FANCINESS_SCORE','DATE_TIME_REQUEST','REPAIR_NAME','SYMPTOM','USRE_REQUEST_NAME','HR_DEPARTMENT_SUB_SUB_NAME','BUILD_NAME','TECH_REPAIR_NAME','BUILD_NAME','informcom_repair.ID')
                ->leftjoin('hrd_person','informcom_repair.USER_REQUEST_ID','=','hrd_person.ID')
              ->leftjoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_SUB_ID')
              ->leftjoin('asset_building','informcom_repair.LOCATION_SEE_ID','=','asset_building.ID')
                ->where(function($q) use ($search){
                  $q->where('REPAIR_ID','like','%'.$search.'%');
                  $q->orwhere('REPAIR_NAME','like','%'.$search.'%');
                  $q->orwhere('SYMPTOM','like','%'.$search.'%');
                  $q->orwhere('USRE_REQUEST_NAME','like','%'.$search.'%');
                  })
                  ->WhereBetween('DATE_SAVE',[$from,$to]) 
              ->orderBy('DATE_TIME_REQUEST', 'desc')->get(); 
          }else{
              $inforepaircom = Informcomrepair::select('REPAIR_ID','REPAIR_STATUS','PRIORITY_ID','FANCINESS_SCORE','DATE_TIME_REQUEST','REPAIR_NAME','SYMPTOM','USRE_REQUEST_NAME','HR_DEPARTMENT_SUB_SUB_NAME','BUILD_NAME','TECH_REPAIR_NAME','BUILD_NAME','informcom_repair.ID')
                ->leftjoin('hrd_person','informcom_repair.USER_REQUEST_ID','=','hrd_person.ID')
              ->leftjoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_SUB_ID')
              ->leftjoin('asset_building','informcom_repair.LOCATION_SEE_ID','=','asset_building.ID')
                ->where('REPAIR_STATUS','=',$status)
              ->where(function($q) use ($search){
                  $q->where('REPAIR_ID','like','%'.$search.'%');
                  $q->orwhere('REPAIR_NAME','like','%'.$search.'%');
                  $q->orwhere('SYMPTOM','like','%'.$search.'%');
                  $q->orwhere('USRE_REQUEST_NAME','like','%'.$search.'%');
                  })
                  ->WhereBetween('DATE_SAVE',[$from,$to]) 
              ->orderBy('DATE_TIME_REQUEST', 'desc')->get(); 
          }
      $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
    $year_id = $yearbudget;
      $infostatus = DB::table('informrepair_status')->get();

      $checkpdf = DB::table('infomrepair_function')->where('ACTIVE','=','True')->count();
      $checfunc = DB::table('informcom_setupfunc')->where('ACTIVE','=','True')->count();
     
    $openform_function = Infomrepair_functioncom::where('FUNCT_REPCOM_STATUS','=','True' )->first();

    if ($openform_function != '') {       
        $code = $openform_function->FUNCT_REPCOM_CODE;  
    } else {                      
        $code = '';
    }

  return view('manager_repaircom.repaircominfo',[
    'inforepaircoms' => $inforepaircom,
    'infostatuss' => $infostatus,
    'budgets' =>  $budget,
    'displaydate_bigen'=> $displaydate_bigen,
    'displaydate_end'=> $displaydate_end,
    'status_check'=> $status,
    'search'=> $search,
    'checkpdf'=>$checkpdf, 
    'year_id'=>$year_id, 
    'codes'=>$code,
    'checfunc'=>$checfunc,
      ]);
    }
    
  public function repaircominfosearch(Request $request)
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


              $inforepaircom = Informcomrepair::select('REPAIR_ID','REPAIR_STATUS','PRIORITY_ID','FANCINESS_SCORE','DATE_TIME_REQUEST','REPAIR_NAME','SYMPTOM','USRE_REQUEST_NAME','HR_DEPARTMENT_SUB_SUB_NAME','BUILD_NAME','TECH_REPAIR_NAME','BUILD_NAME','informcom_repair.ID')
                ->leftjoin('hrd_person','informcom_repair.USER_REQUEST_ID','=','hrd_person.ID')
              ->leftjoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_SUB_ID')
              ->leftjoin('asset_building','informcom_repair.LOCATION_SEE_ID','=','asset_building.ID')
                ->where(function($q) use ($search){
                  $q->where('REPAIR_ID','like','%'.$search.'%');
                  $q->orwhere('REPAIR_NAME','like','%'.$search.'%');
                  $q->orwhere('SYMPTOM','like','%'.$search.'%');
                  $q->orwhere('USRE_REQUEST_NAME','like','%'.$search.'%');
                  })
                  ->WhereBetween('DATE_SAVE',[$from,$to]) 
              ->orderBy('DATE_TIME_REQUEST', 'desc')->get(); 



          }else{


              $inforepaircom = Informcomrepair::select('REPAIR_ID','REPAIR_STATUS','PRIORITY_ID','FANCINESS_SCORE','DATE_TIME_REQUEST','REPAIR_NAME','SYMPTOM','USRE_REQUEST_NAME','HR_DEPARTMENT_SUB_SUB_NAME','BUILD_NAME','TECH_REPAIR_NAME','BUILD_NAME','informcom_repair.ID')
                ->leftjoin('hrd_person','informcom_repair.USER_REQUEST_ID','=','hrd_person.ID')
              ->leftjoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_SUB_ID')
              ->leftjoin('asset_building','informcom_repair.LOCATION_SEE_ID','=','asset_building.ID')
                ->where('REPAIR_STATUS','=',$status)
              ->where(function($q) use ($search){
                  $q->where('REPAIR_ID','like','%'.$search.'%');
                  $q->orwhere('REPAIR_NAME','like','%'.$search.'%');
                  $q->orwhere('SYMPTOM','like','%'.$search.'%');
                  $q->orwhere('USRE_REQUEST_NAME','like','%'.$search.'%');
                  })
                  ->WhereBetween('DATE_SAVE',[$from,$to]) 
              ->orderBy('DATE_TIME_REQUEST', 'desc')->get(); 

          
          }
  

      
     
      $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
    $year_id = $yearbudget;
    

      $infostatus = DB::table('informrepair_status')->get();


     
      return view('manager_repaircom.repaircominfo',[
        'inforepaircoms' => $inforepaircom,
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

  public function repaircominfore(Request $request,$status)
  {

    
      $status = $status;
  

              $inforepaircom = Informcomrepair::where('REPAIR_STATUS','=',$status)->orderBy('PRIORITY_ID', 'desc')->get(); 

      $infostatus = DB::table('informrepair_status')->get();

      $m_budget = date("m");
      if($m_budget>9){
      $yearbudget = date("Y")+544;
      }else{
      $yearbudget = date("Y")+543;
      }

      $displaydate_bigen = ($yearbudget-544).'-10-01';
      $displaydate_end = ($yearbudget-543).'-09-30';
      $search = ''; 

 

      $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
      $year_id = $yearbudget;
      
      return view('manager_repaircom.repaircominfo',[
          'inforepaircoms' => $inforepaircom,
          'infostatuss' => $infostatus, 
          'displaydate_bigen'=> $displaydate_bigen, 
          'displaydate_end'=> $displaydate_end,
          'status_check'=> $status,
          'search'=> $search,
          'budgets'=> $budget, 
          'year_id'=> $year_id 
   
      ]);


  }

 //---------------------------------แก้ไขรายละเอียด----------------------------------

 public function repaircomedit(Request $request,$id)
 {     
      $infoasset = DB::table('asset_article')->get();

      $infolocation = DB::table('supplies_location')->get(); 

      $informcomrepair = Informcomrepair::where('informcom_repair.ID','=',$id)   
      ->leftjoin('informrepair_priority','informrepair_priority.PRIORITY_ID','=','informcom_repair.PRIORITY_ID')
      ->leftjoin('hrd_person','informcom_repair.USER_REQUEST_ID','=','hrd_person.ID')
      ->leftjoin('asset_article','asset_article.ARTICLE_ID','=','informcom_repair.ARTICLE_ID')
      ->leftjoin('supplies_location','asset_article.LOCATION_ID','=','supplies_location.LOCATION_ID')
      ->leftjoin('supplies_location_level','asset_article.LOCATION_LEVEL_ID','=','supplies_location_level.LOCATION_LEVEL_ID')
      ->leftjoin('supplies_location_level_room','asset_article.LEVEL_ROOM_ID','=','supplies_location_level_room.LEVEL_ROOM_ID')
      ->leftjoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_SUB_ID')
      ->first(); 

       $infoassetother = DB::table('informrepair_other')->get();       

       if($informcomrepair->LOCATION_SEE_ID != ''){
         $infolocationlevel= DB::table('supplies_location_level')->where('LOCATION_ID','=',$informcomrepair->LOCATION_SEE_ID)->get();
       }
       else{
         $infolocationlevel= '';      
       }          

       if($informcomrepair->LOCATIONLEVEL_SEE_ID != ''){
         $infolocationlevelroom= DB::table('supplies_location_level_room')->where('LOCATION_LEVEL_ID','=',$informcomrepair->LOCATIONLEVEL_SEE_ID)->get();
       }
       else{
         $infolocationlevelroom= '';      
       } 

       $informrepair_tech = DB::table('informcom_engineer')
       ->leftJoin('hrd_person','hrd_person.ID','=','informcom_engineer.PERSON_ID')
       ->where('ACTIVE','=',True)
       ->get();



     return view('manager_repaircom.inforepaircomedit',[
         'infoassets' => $infoasset,
         'infolocations' => $infolocation,
         'infolocationlevels' => $infolocationlevel,
         'infolocationlevelrooms' => $infolocationlevelroom, 
         'informrepair_techs' => $informrepair_tech,
         'informcomrepair' => $informcomrepair,
         'infoassetothers' => $infoassetother ,
         'idlist' => $id,  
     ]);
 }

 
 public function updateinforepaircom(Request $request)
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

         $m = date('m');
         if($m > 9 && $m < 12 ){
             $YEAR_ID = date('Y')+544;
         }else{
             $YEAR_ID = date('Y')+543;
         }
          
   
         $ID = $request->ID;

         $addinforepair = Informcomrepair::find($ID);
     

         $addinforepair->YEAR_ID =  $YEAR_ID;
         $addinforepair->DATE_TIME_REQUEST = $datere;
         $addinforepair->DATE_SAVE = $DATE_1;
        //----------------------------------

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
         $addinforepair->COM_IMG = $contents;   
     }
    
     $addinforepair->SYMPTOM = $request->SYMPTOM;
     $addinforepair->TECH_REPAIR_ID = $request->TECH_REPAIR_ID;

         //----------------------------------
         $TECH_REPAIR_NAME =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
         ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
         ->where('hrd_person.ID','=',$request->TECH_REPAIR_ID)->first();
         $addinforepair->TECH_REPAIR_NAME   = $TECH_REPAIR_NAME->HR_PREFIX_NAME.''.$TECH_REPAIR_NAME->HR_FNAME.' '.$TECH_REPAIR_NAME->HR_LNAME;

         //----------------------------------

     $addinforepair->PRIORITY_ID = $request->PRIORITY_ID;


        $addinforepair->save();

         return redirect()->route('mrepaircom.repaircominfo'); 

 }




    
public function detailrepaircom(Request $request)
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
               $inforepaircom = Informcomrepair::where('informcom_repair.ID','=',$request->id)
               ->leftjoin('informrepair_priority','informrepair_priority.PRIORITY_ID','=','informcom_repair.PRIORITY_ID')
               ->leftjoin('hrd_person','informcom_repair.USER_REQUEST_ID','=','hrd_person.ID')
               ->leftjoin('asset_article','asset_article.ARTICLE_ID','=','informcom_repair.ARTICLE_ID')
               ->leftjoin('supplies_location','asset_article.LOCATION_ID','=','supplies_location.LOCATION_ID')
               ->leftjoin('supplies_location_level','asset_article.LOCATION_LEVEL_ID','=','supplies_location_level.LOCATION_LEVEL_ID')
               ->leftjoin('supplies_location_level_room','asset_article.LEVEL_ROOM_ID','=','supplies_location_level_room.LEVEL_ROOM_ID')
               ->leftjoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_SUB_ID')
               ->first(); 
       
         //=========================
             
               if($inforepaircom->TECH_RECEIVE_DATE == ''){
                   $TECH_RECEIVE_DATE = '';     
               }else{
                   $TECH_RECEIVE_DATE = DateThai($inforepaircom->TECH_RECEIVE_DATE);
               }
   
               if($inforepaircom->TECH_REPAIR_DATE == ''){
                   $TECH_REPAIR_DATE = '';     
               }else{
                   $TECH_REPAIR_DATE = DateThai($inforepaircom->TECH_REPAIR_DATE);
               }
   
               if($inforepaircom->TECH_SUCCESS_DATE == ''){
                   $TECH_SUCCESS_DATE = '';     
               }else{
                   $TECH_SUCCESS_DATE = DateThai($inforepaircom->TECH_SUCCESS_DATE);
               }
   
               if($inforepaircom->REPAIR_DATE == ''){
                   $REPAIR_DATE = '';     
               }else{
                   $REPAIR_DATE = DateThai($inforepaircom->REPAIR_DATE);
               }
   
        
        
        
        
        
        
        
               $output='    
    
               <div class="row push" style="font-family: \'Kanit\', sans-serif;">
               
               <div class="col-sm-9">
               
                 <div class="row">
                     <div class="col-lg-2" align="right">
                     <label>เลขที่ส่ง :</label>
                     </div> 
                     <div class="col-lg-8" align="left">
                     '.$inforepaircom->REPAIR_ID.'
                     </div> 
                 </div>    
                 <div class="row">
                     <div class="col-lg-2" align="right">
                     <label>วันที่แจ้ง :</label>
                     </div> 
                     <div class="col-lg-4" align="left">
                     '.formateDatetime($inforepaircom->DATE_TIME_REQUEST).'
                     </div> 
                     <div class="col-lg-2" align="right">
                     <label>อาคาร :</label>
                     </div> 
                     <div class="col-lg-4" align="left">
                     '.$inforepaircom->LOCATION_NAME.'
                     </div> 
                 </div>    
                 
                 <div class="row">
                     <div class="col-lg-2" align="right">
                     <label>ชั้น :</label>
                     </div> 
                     <div class="col-lg-4" align="left">
                     '.$inforepaircom->LOCATION_LEVEL_NAME.'
                     </div> 
                     <div class="col-lg-2" align="right">
                     <label>ห้อง :</label>
                     </div> 
                     <div class="col-lg-4" align="left">
                     '.$inforepaircom->LEVEL_ROOM_NAME.'
                     </div> 
                
                 </div>    
               
                 <div class="row">
                 <div class="col-lg-2" align="right">
                 <label>แจ้งซ่อม :</label>
                 </div> 
                 <div class="col-lg-8" align="left">
                '.$inforepaircom->REPAIR_NAME.'
                 </div> 
                </div>  
                
                <div class="row">
                <div class="col-lg-2" align="right">
                <label>รหัสครุภัณฑ์ :</label>
                </div> 
                <div class="col-lg-4" align="left">
               '.$inforepaircom->ARTICLE_NUM.'
                </div> 
                <div class="col-lg-2" align="right">
                <label>ชื่อครุภัณฑ์ :</label>
                </div> 
                <div class="col-lg-4" align="left">
                '.$inforepaircom->ARTICLE_NAME.'
                </div> 
               </div>  
               
               <div class="row">
               <div class="col-lg-2" align="right">
               <label>อาการ :</label>
               </div> 
               <div class="col-lg-10" align="left">
               '.$inforepaircom->SYMPTOM.'
               </div> 
               
               </div>  
               
               <div class="row">
               <div class="col-lg-2" align="right">
               <label>ความเร่งด่วน :</label>
               </div> 
               <div class="col-lg-6" align="left">
               '.$inforepaircom->PRIORITY_NAME.'
               </div> 
               
               </div>   
               
               <div class="row">
               <div class="col-lg-2" align="right">
               <label>ผู้แจ้งซ่อม :</label>
               </div> 
               <div class="col-lg-4" align="left">
               '.$inforepaircom->USRE_REQUEST_NAME.'
               </div>
               <div class="col-lg-2" align="right">
               <label>ฝ่าย/แผนก  :</label>
               </div> 
               <div class="col-lg-4" align="left">
               '.$inforepaircom->HR_DEPARTMENT_SUB_SUB_NAME.'
               </div>  
               </div>     
              
               
               
               
               
               </div>
               
               <div class="col-sm-3">
               
               <div class="form-group">
               
               <img src="data:image/png;base64,'. chunk_split(base64_encode($inforepaircom->COM_IMG)) .'" id="image_upload_preview" alt="กรุณาเพิ่มรูปภาพ" height="200" width="200"/>
               </div>
               
               </div>
               </div>
               </div>
               </div>';
           
           
               if($inforepaircom->REPAIR_STATUS != 'REQUEST'){
           
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
               '.$inforepaircom->TECH_RECEIVE_TIME.'
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
               '.$inforepaircom->TECH_REPAIR_TIME.'
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
               '.$inforepaircom->TECH_SUCCESS_TIME.'
               </div>  
               </div>
           
               <div class="row">
               <div class="col-lg-2" align="right">
               <label>หมายเหตุ :</label>
               </div> 
               <div class="col-lg-10" align="left">
               '.$inforepaircom->TECH_RECEIVE_COMMENT.'
               </div>
               </div>
           
               <div class="row">
               <div class="col-lg-2" align="right">
               <label>ผู้รับเรื่อง :</label>
               </div> 
               <div class="col-lg-4" align="left">
               '.$inforepaircom->TECH_RECEIVE_NAME.'
               </div>
               <div class="col-lg-2" align="right">
               <label>ช่างหลัก  :</label>
               </div> 
               <div class="col-lg-4" align="left">
               '.$inforepaircom->TECH_REPAIR_NAME.'
               </div>  
               </div>
           
           </div>
           
           </div>';
               }
               
               
               if($inforepaircom->REPAIR_STATUS!= 'REQUEST' && $inforepaircom->REPAIR_STATUS!= 'RECEIVE'){
           
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
           '.$inforepaircom->REPAIR_COMMENT.'
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
           '.$inforepaircom->REPAIR_TIME.'
           </div>  
           </div>
           
           
           <div class="row">
           <div class="col-lg-2" align="right">
           <label>รายละเอียด :</label>
           </div> 
           <div class="col-lg-10" align="left">
           '.$inforepaircom->REPAIR_COMMENT.'
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
           '.$inforepaircom->OUTSIDE_COMMENT.'
           </div>
           <div class="col-lg-2" align="right">
           <label>อุปกรณ์ที่ติดไปด้วย :</label>
           </div> 
           <div class="col-lg-4" align="left">
           '.$inforepaircom->OUTSIDE_TOOL.'
           </div>
           </div>
           
           
           <div class="row">
           <div class="col-lg-2" align="right">
           <label>ส่งซ่อมที่ร้าน :</label>
           </div> 
           <div class="col-lg-4" align="left">
           '.$inforepaircom->OUTSIDE_SHOP.'
           </div>
           <div class="col-lg-2" align="right">
           <label>ผู้รับสิ่งของ :</label>
           </div> 
           <div class="col-lg-4" align="left">
           '.$inforepaircom->OUTSIDE_EMP.'
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
           '.$inforepaircom->GETBACK_PERSON.'
           </div>
           <div class="col-lg-2" align="right">
           <label>วันที่รับกลับ :</label>
           </div> 
           <div class="col-lg-4" align="left">
           '.DateThai($inforepaircom->GETBACK_DATE).'
           </div>
           </div>
           
           </div> 
           </div>';
               }    
               echo $output;
               
               
               }
           



//================================================รับเรื่อง============================================
public function repaircomreceived($id)
{
    $iduser = Auth::user()->PERSON_ID; 

        $inforpersonuser=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->where('hrd_person.ID','=',$iduser)->first();

        $inforepaircom = Informcomrepair::where('informcom_repair.ID','=',$id)
        ->select('informcom_repair.ID','COM_IMG','asset_article.ARTICLE_NUM','asset_article.ARTICLE_NAME','BUILD_NAME','LOCATION_LEVEL_NAME','LEVEL_ROOM_NAME','REPAIR_ID','DATE_TIME_REQUEST','REPAIR_NAME','informcom_repair.ARTICLE_ID','SYMPTOM','PRIORITY_NAME','USRE_REQUEST_NAME','HR_DEPARTMENT_SUB_SUB_NAME')
        ->leftjoin('informrepair_priority','informrepair_priority.PRIORITY_ID','=','informcom_repair.PRIORITY_ID')
        ->leftjoin('hrd_person','informcom_repair.USER_REQUEST_ID','=','hrd_person.ID')
        ->leftjoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_SUB_ID')

        ->leftjoin('asset_article','asset_article.ARTICLE_ID','=','informcom_repair.ARTICLE_ID')
        ->leftjoin('asset_building','informcom_repair.LOCATION_SEE_ID','=','asset_building.ID')
        ->leftjoin('supplies_location_level','informcom_repair.LOCATIONLEVEL_SEE_ID','=','supplies_location_level.LOCATION_LEVEL_ID')
        ->leftjoin('supplies_location_level_room','informcom_repair.LOCATIONLEVELROOM_SEE_ID','=','supplies_location_level_room.LEVEL_ROOM_ID')
        ->first(); 
        


        $engineer = DB::table('informcom_engineer')
        ->leftJoin('hrd_person','hrd_person.ID','=','informcom_engineer.PERSON_ID')
        ->where('ACTIVE','=',True)
        ->get();

      
        $repairtype= DB::table('informrepair_type')->get(); 


        return view('manager_repaircom.repaircomreceived',[
                'inforepaircom' => $inforepaircom,
                'inforpersonuser' => $inforpersonuser,
                'repairtypes' => $repairtype,
                'engineers' => $engineer
        ]);  
}



public function updateinfocomreceived(Request $request)
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

         $addreceived = Informcomrepair::find($ID);
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
              
                $add = new Informcomrepairengineer();
                $add->REPAIR_INDEX_ID = $ID;
                $add->HR_PERSON_ID = $HR_PERSON_ID[$count];
                $add->save(); 
              
      
             }
         }


         return response()->json([
            'status' => 1,
            'url' => route('mrepaircom.repaircominfo')
        ]);

}





//-----------------------------------------แก้ไขรับเรื่อง--------------------


public function repaircomreceiveedit($id)
{
    
    $iduser = Auth::user()->PERSON_ID; 

    $inforpersonuser=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->where('hrd_person.ID','=',$iduser)->first();


        $inforepaircom = Informcomrepair::where('informcom_repair.ID','=',$id)
        ->select('informcom_repair.ID','COM_IMG','asset_article.ARTICLE_NUM','asset_article.ARTICLE_NAME','BUILD_NAME','LOCATION_LEVEL_NAME','LEVEL_ROOM_NAME','REPAIR_ID','DATE_TIME_REQUEST','REPAIR_NAME','informcom_repair.ARTICLE_ID','SYMPTOM','PRIORITY_NAME','USRE_REQUEST_NAME','HR_DEPARTMENT_SUB_SUB_NAME')
        ->leftjoin('informrepair_priority','informrepair_priority.PRIORITY_ID','=','informcom_repair.PRIORITY_ID')
        ->leftjoin('hrd_person','informcom_repair.USER_REQUEST_ID','=','hrd_person.ID')
        ->leftjoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_SUB_ID')
        ->leftjoin('asset_article','asset_article.ARTICLE_ID','=','informcom_repair.ARTICLE_ID')
        ->leftjoin('asset_building','informcom_repair.LOCATION_SEE_ID','=','asset_building.ID')
        ->leftjoin('supplies_location_level','informcom_repair.LOCATIONLEVEL_SEE_ID','=','supplies_location_level.LOCATION_LEVEL_ID')
        ->leftjoin('supplies_location_level_room','informcom_repair.LOCATIONLEVELROOM_SEE_ID','=','supplies_location_level_room.LEVEL_ROOM_ID')
        ->first(); 
      

    $infotechrepair = Informcomrepairengineer::where('REPAIR_INDEX_ID','=',$id)->get();

    $counttechrepair = Informcomrepairengineer::where('REPAIR_INDEX_ID','=',$id)->count();

    $engineer = DB::table('informcom_engineer')
    ->leftJoin('hrd_person','hrd_person.ID','=','informcom_engineer.PERSON_ID')
    ->where('ACTIVE','=',True)
    ->get();


    return view('manager_repaircom.repaircomreceived_edit',[
            'inforepaircom' => $inforepaircom,
            'inforpersonuser' => $inforpersonuser,
            'infotechrepairs' => $infotechrepair,
            'counttechrepair' => $counttechrepair,
            'engineers'=> $engineer
    ]);

}


public function updateinforepaircomreceive(Request $request)
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
 
             $addreceived = Informcomrepair::find($ID);

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

                
                Informcomrepairengineer::where('REPAIR_INDEX_ID','=',$ID)->delete(); 
 
                 $HR_PERSON_ID = $request->HR_PERSON_ID;
    
                 $number =count($HR_PERSON_ID);
                 $count = 0;
                 for($count = 0; $count< $number; $count++)
                 {  
                  
                    $add = new Informcomrepairengineer();
                    $add->REPAIR_INDEX_ID = $ID;
                    $add->HR_PERSON_ID = $HR_PERSON_ID[$count];
                    $add->save(); 
                  
          
                 }
             }
             return redirect()->route('mrepaircom.repaircominfo'); 
    }


 //================================================ระหว่างซ่อม============================================   

public function repaircomamong($id)
{
     
    $iduser = Auth::user()->PERSON_ID; 
      
    $inforpersonuser=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->where('hrd_person.ID','=',$iduser)->first();

    $inforepaircom = Informcomrepair::where('informcom_repair.ID','=',$id)
    ->select('informcom_repair.ID','COM_IMG','asset_article.ARTICLE_NUM','asset_article.ARTICLE_NAME','BUILD_NAME','LOCATION_LEVEL_NAME','LEVEL_ROOM_NAME','REPAIR_ID','DATE_TIME_REQUEST','REPAIR_NAME','informcom_repair.ARTICLE_ID','SYMPTOM','PRIORITY_NAME','USRE_REQUEST_NAME','HR_DEPARTMENT_SUB_SUB_NAME')
    ->leftjoin('informrepair_priority','informrepair_priority.PRIORITY_ID','=','informcom_repair.PRIORITY_ID')
    ->leftjoin('hrd_person','informcom_repair.USER_REQUEST_ID','=','hrd_person.ID')
    ->leftjoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_SUB_ID')
    ->leftjoin('asset_article','asset_article.ARTICLE_ID','=','informcom_repair.ARTICLE_ID')
    ->leftjoin('asset_building','informcom_repair.LOCATION_SEE_ID','=','asset_building.ID')
    ->leftjoin('supplies_location_level','informcom_repair.LOCATIONLEVEL_SEE_ID','=','supplies_location_level.LOCATION_LEVEL_ID')
    ->leftjoin('supplies_location_level_room','informcom_repair.LOCATIONLEVELROOM_SEE_ID','=','supplies_location_level_room.LEVEL_ROOM_ID')
    ->first(); 



    return view('manager_repaircom.repaircomamong',[
             'inforepaircom' => $inforepaircom,
            'inforpersonuser'=>$inforpersonuser

    ]);

}


public function updateinfocomamong(Request $request)
{
    $request->validate([
        'REPAIR_COMMENT' => 'required',
    ]);
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
         $addamong= Informcomrepair::find($ID);
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

        return response()->json([
            'status' => 1,
            'url' => route('mrepaircom.repaircominfo')
        ]);
}


//--------------------------------------------แก้ไข------------


public function repaircomamongedit($id)
{     
    $iduser = Auth::user()->PERSON_ID; 
      
    $inforpersonuser=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->where('hrd_person.ID','=',$iduser)->first();

    // $inforepaircom = Informcomrepair::where('ID','=',$id)->first(); 
    $inforepaircom = Informcomrepair::where('informcom_repair.ID','=',$id)
    ->select('informcom_repair.ID','COM_IMG','asset_article.ARTICLE_NUM','asset_article.ARTICLE_NAME','BUILD_NAME','LOCATION_LEVEL_NAME','LEVEL_ROOM_NAME','REPAIR_ID','DATE_TIME_REQUEST','REPAIR_NAME','informcom_repair.ARTICLE_ID','SYMPTOM','PRIORITY_NAME','USRE_REQUEST_NAME','HR_DEPARTMENT_SUB_SUB_NAME')
    ->leftjoin('informrepair_priority','informrepair_priority.PRIORITY_ID','=','informcom_repair.PRIORITY_ID')
    ->leftjoin('hrd_person','informcom_repair.USER_REQUEST_ID','=','hrd_person.ID')
    ->leftjoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_SUB_ID')
    ->leftjoin('asset_article','asset_article.ARTICLE_ID','=','informcom_repair.ARTICLE_ID')
    ->leftjoin('asset_building','informcom_repair.LOCATION_SEE_ID','=','asset_building.ID')
    ->leftjoin('supplies_location_level','informcom_repair.LOCATIONLEVEL_SEE_ID','=','supplies_location_level.LOCATION_LEVEL_ID')
    ->leftjoin('supplies_location_level_room','informcom_repair.LOCATIONLEVELROOM_SEE_ID','=','supplies_location_level_room.LEVEL_ROOM_ID')
    ->first(); 





    return view('manager_repaircom.repaircomamong_edit',[
            'inforepaircom' => $inforepaircom,
            'inforpersonuser'=>$inforpersonuser
    ]);
}


public function updateinforepaircomamong(Request $request)
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

         $addamong= Informcomrepair::find($ID);
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

        return redirect()->route('mrepaircom.repaircominfo'); 
}


  //================================================ซ่อมเสร็จ============================================
    
   
  public function repaircomsuccess($id)
  {
      
    $id_user = Auth::user()->PERSON_ID; 

    $infoperson = DB::table('hrd_person')->where('ID','=',$id_user)->first();

    $inforepaircom = Informcomrepair::where('informcom_repair.ID','=',$id)
    ->select('informcom_repair.ID','COM_IMG','asset_article.ARTICLE_NUM','asset_article.ARTICLE_NAME','BUILD_NAME','LOCATION_LEVEL_NAME','LEVEL_ROOM_NAME','REPAIR_ID','DATE_TIME_REQUEST','REPAIR_NAME','informcom_repair.ARTICLE_ID','SYMPTOM','PRIORITY_NAME','USRE_REQUEST_NAME','HR_DEPARTMENT_SUB_SUB_NAME')
    ->leftjoin('informrepair_priority','informrepair_priority.PRIORITY_ID','=','informcom_repair.PRIORITY_ID')
    ->leftjoin('hrd_person','informcom_repair.USER_REQUEST_ID','=','hrd_person.ID')
    ->leftjoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_SUB_ID')
    ->leftjoin('asset_article','asset_article.ARTICLE_ID','=','informcom_repair.ARTICLE_ID')
    ->leftjoin('asset_building','informcom_repair.LOCATION_SEE_ID','=','asset_building.ID')
    ->leftjoin('supplies_location_level','informcom_repair.LOCATIONLEVEL_SEE_ID','=','supplies_location_level.LOCATION_LEVEL_ID')
    ->leftjoin('supplies_location_level_room','informcom_repair.LOCATIONLEVELROOM_SEE_ID','=','supplies_location_level_room.LEVEL_ROOM_ID')
    ->first();

    $inforepairID = Informcomrepair::where('ID','=',$id)->first(); 

    $infoen = DB::table('informcom_engineer')->get();
    $servicetype = DB::table('informrepair_service_type')->get();
    
    $service = DB::table('informcom_service')->where('REPAIR_INDEX_ID','=',$id)->get();
    $countservice = DB::table('informrepair_service')->where('REPAIR_INDEX_ID','=',$id)->count();


      return view('manager_repaircom.repaircomsuccess',[
        'inforepaircom' => $inforepaircom,
        'infoens'=> $infoen,
        'inforepairID'=> $inforepairID,
        'servicetypes'=> $servicetype,
        'services'=> $service,
        'countservice'=> $countservice,
        'infoperson'=> $infoperson,
      ]);
  
  }


  public function updateinfocomsuccess(Request $request)
  {


           $ID = $request->ID;
           $REPAIR_ID = $request->REPAIR_ID;

           $REPAIR_STATUS = $request->REPAIR_STATUS;
           
           //dd($ID);

           $addsuccess= Informcomrepair::find($ID);
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
                
                  $add = new Informcomservice();
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



           $check_pay = $request->check_pay;

           if($check_pay == '2'){

               if($request->TREASURY_RECEIVE_ID != '' || $request->TREASURY_RECEIVE_ID != null){

                   $iduser = Auth::user()->PERSON_ID; 

                   $infomation = DB::table('hrd_person')->where('hrd_person.ID','=',$iduser)->first();

                   $TREASURTPAYDATE= date('Y-m-d');
                   $codepay = Warehousetreasurypay::max('TREASURT_PAY_ID');
                   $TREASURT_PAY_CODE = $codepay+1;
                   
           
                   $addsaveinfopay = new Warehousetreasurypay();
                   $addsaveinfopay->TREASURT_PAY_CODE = $TREASURT_PAY_CODE;
                   $addsaveinfopay->REPAIR_ID = $REPAIR_ID;
                   $addsaveinfopay->TREASURT_PAY_DATE = $TREASURTPAYDATE;
                   $addsaveinfopay->TREASURT_PAY_COMMENT = 'เบิกจ่ายจากงานซ่อมคอมพิวเตอร์';
                   $addsaveinfopay->TREASURT_PAY_SAVE_HR_ID = $infomation->ID;
                   $addsaveinfopay->TREASURT_PAY_SAVE_HR_NAME = $infomation->HR_FNAME.' '.$infomation->HR_LNAME;
                   $addsaveinfopay->TREASURT_PAY_REQUEST_HR_ID = $infomation->ID;
       
                   $PERSON_SAVE = Person::where('hrd_person.ID','=', $infomation->ID)->first();
                   $addsaveinfopay->TREASURT_PAY_REQUEST_SUB_SUB_ID = $PERSON_SAVE->HR_DEPARTMENT_SUB_SUB_ID;
       
                   $PERSON =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                   ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
                   ->where('hrd_person.ID','=', $infomation->ID)->first();
                   $addsaveinfopay->TREASURT_PAY_REQUEST_HR_NAME = $PERSON->HR_FNAME.' '.$PERSON->HR_LNAME;   
               
           
                   $addsaveinfopay->TREASURT_PAY_NAME = $PERSON->HR_FNAME.' '.$PERSON->HR_LNAME;   
               
       
                   $addsaveinfopay->save();
       
                   $TREASURT_PAY_ID = Warehousetreasurypay::max('TREASURT_PAY_ID');
               
       
                  
       
                       $TREASURY_RECEIVE_ID = $request->TREASURY_RECEIVE_ID;
                       $TREASURY_EXPORT_SUB_NAME = $request->TREASURY_EXPORT_SUB_NAME;
                       $TREASURY_EXPORT_SUB_LOT = $request->TREASURY_EXPORT_SUB_LOT;
                       $TREASURY_EXPORT_SUB_UNIT = $request->TREASURY_EXPORT_SUB_UNIT;
                       $TREASURY_EXPORT_SUB_PICE_UNIT = $request->TREASURY_EXPORT_SUB_PICE_UNIT;
                       
                   
                       $TREASURY_EXPORT_SUB_GEN_DATE = $request->TREASURY_EXPORT_SUB_GEN_DATE;
                       $TREASURY_EXPORT_SUB_EXP_DATE = $request->TREASURY_EXPORT_SUB_EXP_DATE;
                       $TREASURY_EXPORT_SUB_AMOUNT = $request->TREASURY_EXPORT_SUB_AMOUNT;
                       
                       $TREASURY_RECEIVE_SUB_ID = $request->TREASURY_RECEIVE_SUB_ID;
                       $TREASURY_ID = $request->TREASURY_ID;
                       
                   
       
                       $number =count($TREASURY_RECEIVE_ID);
                       $count = 0;
                       for($count = 0; $count< $number; $count++)
                       {
    
                       if($TREASURY_EXPORT_SUB_GEN_DATE[$count] != ''){
                           $DAY =$TREASURY_EXPORT_SUB_GEN_DATE[$count];
                           $date_arrary_st=explode("-",$DAY);
                           $y_sub_st = $date_arrary_st[0];
           
                           if($y_sub_st >= 2500){
                               $y_st = $y_sub_st-543;
                           }else{
                               $y_st = $y_sub_st;
                           }
                           $m_st = $date_arrary_st[1];
                           $d_st = $date_arrary_st[2];
                           $GENDATE= $y_st."-".$m_st."-".$d_st;
                           }else{
                           $GENDATE= null;
                       }
       
       
                       if($TREASURY_EXPORT_SUB_EXP_DATE[$count] != ''){
                           $DAY = $TREASURY_EXPORT_SUB_EXP_DATE[$count];
                           $date_arrary_st=explode("-",$DAY);
                           $y_sub_st = $date_arrary_st[0];
       
                           if($y_sub_st >= 2500){
                               $y_st = $y_sub_st-543;
                           }else{
                               $y_st = $y_sub_st;
                           }
                           $m_st = $date_arrary_st[1];
                           $d_st = $date_arrary_st[2];
                           $EXPDATE= $y_st."-".$m_st."-".$d_st;
                           }else{
                           $EXPDATE= null;
                       }
       
                 
                           $add = new Warehousetreasuryexportsub();
                           $add->TREASURT_PAY_ID = $TREASURT_PAY_ID;
                           $add->TREASURT_PAY_ID = $TREASURT_PAY_ID;

                           $add->TREASURY_RECEIVE_ID = $TREASURY_RECEIVE_ID[$count];
       
                           $add->TREASURY_EXPORT_SUB_NAME = $TREASURY_EXPORT_SUB_NAME[$count];
                           $add->TREASURY_EXPORT_SUB_LOT = $TREASURY_EXPORT_SUB_LOT[$count];
                           $add->TREASURY_EXPORT_SUB_UNIT = $TREASURY_EXPORT_SUB_UNIT[$count];
       
                           $add->TREASURY_EXPORT_SUB_AMOUNT = $TREASURY_EXPORT_SUB_AMOUNT[$count];
                           $add->TREASURY_EXPORT_SUB_VALUE = $TREASURY_EXPORT_SUB_AMOUNT[$count] * $TREASURY_EXPORT_SUB_PICE_UNIT[$count];
                           $add->TREASURY_EXPORT_SUB_PICE_UNIT = $TREASURY_EXPORT_SUB_PICE_UNIT[$count];
       
                           $add->TREASURY_EXPORT_SUB_GEN_DATE = $GENDATE;
                           $add->TREASURY_EXPORT_SUB_EXP_DATE = $EXPDATE;
                   
                           $add->TREASURY_RECEIVE_SUB_ID = $TREASURY_RECEIVE_SUB_ID[$count];
                           $add->TREASURY_ID = $TREASURY_ID[$count];
       
       
                   //---------------ตรวจสอบจำนวนของที่เหลือ
                       $inforecheckre = DB::table('warehouse_treasury_receive_sub')->where('TREASURY_ID','=',$TREASURY_ID[$count])->where('TREASURY_RECEIVE_ID','=',$TREASURY_RECEIVE_ID[$count])->sum('TREASURY_RECEIVE_SUB_AMOUNT');
                       $inforecheckex = DB::table('warehouse_treasury_export_sub')->where('TREASURY_ID','=',$TREASURY_ID[$count])->where('TREASURY_RECEIVE_ID','=',$TREASURY_RECEIVE_ID[$count])->sum('TREASURY_EXPORT_SUB_AMOUNT');
       
                       $totalsumpay = $inforecheckex  + $TREASURY_EXPORT_SUB_AMOUNT[$count];
                    
                       if( $inforecheckre >= $totalsumpay){
                       $add->save();
                       }
       
                       }

                       
                   }
           


           }

          return redirect()->route('mrepaircom.repaircominfo'); 
  }



  //-----------------------แก้ไข----------------------------------

  public function repaircomsuccessedit($id)
  {
      

    $inforepaircom = Informcomrepair::where('informcom_repair.ID','=',$id)
    ->select('informcom_repair.ID','COM_IMG','asset_article.ARTICLE_NUM','asset_article.ARTICLE_NAME','BUILD_NAME','LOCATION_LEVEL_NAME','LEVEL_ROOM_NAME','REPAIR_ID','DATE_TIME_REQUEST','REPAIR_NAME','informcom_repair.ARTICLE_ID','SYMPTOM','PRIORITY_NAME','USRE_REQUEST_NAME','HR_DEPARTMENT_SUB_SUB_NAME','TECH_RECEIVE_DATE'
    ,'TECH_RECEIVE_TIME','TECH_REPAIR_DATE','TECH_REPAIR_DATE','TECH_REPAIR_TIME','TECH_SUCCESS_DATE','TECH_SUCCESS_DATE','TECH_SUCCESS_TIME','TECH_RECEIVE_COMMENT','TECH_RECEIVE_NAME','TECH_REPAIR_NAME','REPAIR_COMMENT','REPAIR_DATE','REPAIR_TIME','OUTSIDE_COMMENT','OUTSIDE_TOOL','OUTSIDE_SHOP','OUTSIDE_EMP')
    ->leftjoin('informrepair_priority','informrepair_priority.PRIORITY_ID','=','informcom_repair.PRIORITY_ID')
    ->leftjoin('hrd_person','informcom_repair.USER_REQUEST_ID','=','hrd_person.ID')
    ->leftjoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_SUB_ID')
    ->leftjoin('asset_article','asset_article.ARTICLE_ID','=','informcom_repair.ARTICLE_ID')
    ->leftjoin('asset_building','informcom_repair.LOCATION_SEE_ID','=','asset_building.ID')
    ->leftjoin('supplies_location_level','informcom_repair.LOCATIONLEVEL_SEE_ID','=','supplies_location_level.LOCATION_LEVEL_ID')
    ->leftjoin('supplies_location_level_room','informcom_repair.LOCATIONLEVELROOM_SEE_ID','=','supplies_location_level_room.LEVEL_ROOM_ID')
    ->first();

      $inforepairID = Informcomrepair::where('ID','=',$id)->first(); 

      $infoen = DB::table('informcom_engineer')->get();
      $servicetype = DB::table('informrepair_service_type')->get();

      $service = DB::table('informcom_service')->where('REPAIR_INDEX_ID','=',$id)->get();

      $countservice = DB::table('informcom_service')->where('REPAIR_INDEX_ID','=',$id)->count();

      $infopay = DB::table('warehouse_treasury_export_sub')
      ->leftjoin('warehouse_treasury_pay','warehouse_treasury_export_sub.TREASURT_PAY_ID','=','warehouse_treasury_pay.TREASURT_PAY_ID')
      ->leftjoin('supplies_unit_ref','warehouse_treasury_export_sub.TREASURY_EXPORT_SUB_UNIT','=','supplies_unit_ref.ID')  
      ->where('warehouse_treasury_pay.REPAIR_ID','=',$inforepaircom->REPAIR_ID)->get();
      

      return view('manager_repaircom.repaircomsuccess_edit',[
              'inforepaircom' => $inforepaircom,
              'infoens'=> $infoen,
              'inforepairID'=> $inforepairID,
              'servicetypes'=> $servicetype,
              'services'=> $service,
              'countservice'=> $countservice,
              'infopays'=> $infopay,
      ]);
  
  }


  public function updateinforepaircomsuccess(Request $request)
  {


           $ID = $request->ID;
           $REPAIR_ID = $request->REPAIR_ID;
           $GETBACK_ACTIVE = $request->GETBACK_ACTIVE;

           $addsuccess= Informcomrepair::find($ID);

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

            Informcomservice::where('REPAIR_INDEX_ID','=',$ID)->delete(); 

               $REPAIR_TYPE_ID = $request->REPAIR_TYPE_ID;
               $REPAIR_SERVICE_NAME = $request->REPAIR_SERVICE_NAME;
               $REPAIR_TOTAL = $request->REPAIR_TOTAL;
               $REPAIR_PRICE_PER_UNIT = $request->REPAIR_PRICE_PER_UNIT;
            
   
               $number =count($REPAIR_TYPE_ID);
               $count = 0;
               for($count = 0; $count< $number; $count++)
               {  
                  $add = new Informcomservice();
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
          return redirect()->route('mrepaircom.repaircominfo'); 
  }

    //============================================ยกเลิกรายการ=================


    public function repaircominfocancel($id)
    {

      $inforepaircomdetail = Informcomrepair::where('informcom_repair.ID','=',$id)
      ->select('informcom_repair.ID','COM_IMG','asset_article.ARTICLE_NUM','asset_article.ARTICLE_NAME','BUILD_NAME','LOCATION_LEVEL_NAME','LEVEL_ROOM_NAME','REPAIR_ID','DATE_TIME_REQUEST','REPAIR_NAME','informcom_repair.ARTICLE_ID','SYMPTOM','PRIORITY_NAME','USRE_REQUEST_NAME','HR_DEPARTMENT_SUB_SUB_NAME')
      ->leftjoin('informrepair_priority','informrepair_priority.PRIORITY_ID','=','informcom_repair.PRIORITY_ID')
      ->leftjoin('hrd_person','informcom_repair.USER_REQUEST_ID','=','hrd_person.ID')
      ->leftjoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_SUB_ID')
      ->leftjoin('asset_article','asset_article.ARTICLE_ID','=','informcom_repair.ARTICLE_ID')
      ->leftjoin('asset_building','informcom_repair.LOCATION_SEE_ID','=','asset_building.ID')
      ->leftjoin('supplies_location_level','informcom_repair.LOCATIONLEVEL_SEE_ID','=','supplies_location_level.LOCATION_LEVEL_ID')
      ->leftjoin('supplies_location_level_room','informcom_repair.LOCATIONLEVELROOM_SEE_ID','=','supplies_location_level_room.LEVEL_ROOM_ID')
      ->first();

      $inforepaircomdetailid = Informcomrepair::where('informcom_repair.ID','=',$id)->first();

        return view('manager_repaircom.repaircomcancel_check',[
          'inforepaircomdetail' => $inforepaircomdetail,
          'inforepaircomdetailid' => $inforepaircomdetailid,
     
        ]);
    
    }

    public function updaterepaircomcancel(Request $request)
    {

 
             $ID = $request->ID;
 
             $addcancel= Informcomrepair::find($ID);

             $addcancel->REPAIR_STATUS = 'CANCEL';
             $addcancel->save();
 
 


            return redirect()->route('mrepaircom.repaircominfo'); 

    }


       //============================================ลัดสถานนะดำเนินการสำเร็จ=================


     public function repaircomsuccessnow($id)
     {
 
       $inforepaircomdetail = Informcomrepair::where('informcom_repair.ID','=',$id)
       ->select('informcom_repair.ID','COM_IMG','asset_article.ARTICLE_NUM','asset_article.ARTICLE_NAME','BUILD_NAME','LOCATION_LEVEL_NAME','LEVEL_ROOM_NAME','REPAIR_ID','DATE_TIME_REQUEST','REPAIR_NAME','informcom_repair.ARTICLE_ID','SYMPTOM','PRIORITY_NAME','USRE_REQUEST_NAME','HR_DEPARTMENT_SUB_SUB_NAME')
       ->leftjoin('informrepair_priority','informrepair_priority.PRIORITY_ID','=','informcom_repair.PRIORITY_ID')
       ->leftjoin('hrd_person','informcom_repair.USER_REQUEST_ID','=','hrd_person.ID')
       ->leftjoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_SUB_ID')
       ->leftjoin('asset_article','asset_article.ARTICLE_ID','=','informcom_repair.ARTICLE_ID')
       ->leftjoin('asset_building','informcom_repair.LOCATION_SEE_ID','=','asset_building.ID')
       ->leftjoin('supplies_location_level','informcom_repair.LOCATIONLEVEL_SEE_ID','=','supplies_location_level.LOCATION_LEVEL_ID')
       ->leftjoin('supplies_location_level_room','informcom_repair.LOCATIONLEVELROOM_SEE_ID','=','supplies_location_level_room.LEVEL_ROOM_ID')
       ->first();
 
       $inforepaircomdetailid = Informcomrepair::where('informcom_repair.ID','=',$id)->first();
 
         return view('manager_repaircom.repaircomsuccessnow_check',[
           'inforepaircomdetail' => $inforepaircomdetail,
           'inforepaircomdetailid' => $inforepaircomdetailid,
      
         ]);
     
     }
 
     public function repaircomsuccessnowupdate(Request $request)
     {
 
        $iduser = Auth::user()->PERSON_ID; 

        $inforpersonuser=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->where('hrd_person.ID','=',$iduser)->first();

  
              $ID = $request->ID;
 
  
              $addsuc= Informcomrepair::find($ID);
 
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
 
 
             return redirect()->route('mrepaircom.repaircominfo'); 
 
     }




   //---------------------------ฟังชั่น------------------------------
   function checkcomrepair(Request $request)
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


//============================================ทะเบียนครุภัณฑ์=================


   public function repaircominfoasset()
    {
        $repairnomalinfoasset =   DB::table('asset_article')
        ->leftJoin('supplies_decline','supplies_decline.DECLINE_ID','=','asset_article.DECLINE_ID')
        ->leftJoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','asset_article.DEP_ID')
        ->leftJoin('supplies_location','supplies_location.LOCATION_ID','=','asset_article.LOCATION_ID')
        ->leftJoin('supplies_location_level','supplies_location_level.LOCATION_LEVEL_ID','=','asset_article.LOCATION_LEVEL_ID')
        ->leftJoin('supplies_location_level_room','supplies_location_level_room.LEVEL_ROOM_ID','=','asset_article.LEVEL_ROOM_ID')
        ->where('asset_article.DECLINE_ID','=',18)
        ->orderBy('ARTICLE_ID', 'desc')
        ->get();
           

        return view('manager_repaircom.repaircominfoasset',[
            'repairnomalinfoassets' => $repairnomalinfoasset,
    
        ]);

    }

    public function detailrepaircomasset(Request $request)
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
    
    
    
    

             $repaircominfoasset = DB::table('asset_article')
             ->leftjoin('supplies_location','asset_article.LOCATION_ID','=','supplies_location.LOCATION_ID')
             ->leftjoin('supplies_brand','asset_article.BRAND_ID','=','supplies_brand.BRAND_ID')
             ->leftjoin('asset_color','asset_article.COLOR_ID','=','asset_color.COLOR_ID')
             ->leftjoin('supplies_location_level','asset_article.LOCATION_LEVEL_ID','=','supplies_location_level.LOCATION_LEVEL_ID')
             ->leftjoin('supplies_location_level_room','asset_article.LEVEL_ROOM_ID','=','supplies_location_level_room.LEVEL_ROOM_ID')
             ->where('asset_article.ARTICLE_ID','=',$request->id)->first(); 
          
             

             
    
    $output='    
    
    <div class="row push" style="font-family: \'Kanit\', sans-serif;">
    
    <div class="col-sm-9">
    
      <div class="row">
          <div class="col-lg-2" align="right">
          <label>รหัส :</label>
          </div> 
          <div class="col-lg-4" align="left">
          '.$repaircominfoasset->ARTICLE_ID.'
          </div> 
          <div class="col-lg-2" align="right">
          <label>เลขครุภัณฑ์ :</label>
          </div> 
          <div class="col-lg-4" align="left">
          '.$repaircominfoasset->ARTICLE_NUM.'
          </div> 
      </div>    
      <div class="row">
          <div class="col-lg-2" align="right">
          <label>ครุภัณฑ์ :</label>
          </div> 
          <div class="col-lg-8" align="left">
          '.$repaircominfoasset->ARTICLE_NAME.'
          </div> 
       
      </div>    
      
      <div class="row">
      <div class="col-lg-2" align="right">
      <label>อาคาร :</label>
      </div> 
      <div class="col-lg-4" align="left">
      '.$repaircominfoasset->LOCATION_NAME.'
      </div>
          <div class="col-lg-1" align="right">
          <label>ชั้น :</label>
          </div> 
          <div class="col-lg-2" align="left">
          '.$repaircominfoasset->LOCATION_LEVEL_NAME.'
          </div> 
          <div class="col-lg-1" align="right">
          <label>ห้อง :</label>
          </div> 
          <div class="col-lg-2" align="left">
          '.$repaircominfoasset->LEVEL_ROOM_NAME.'
          </div> 
     
      </div>    
    
     
     <div class="row">
     <div class="col-lg-2" align="right">
     <label>โมเดล :</label>
     </div> 
     <div class="col-lg-4" align="left">
    '.$repaircominfoasset->MODEL_ID.'
     </div> 
     <div class="col-lg-2" align="right">
     <label>ขนาด :</label>
     </div> 
     <div class="col-lg-4" align="left">
     '.$repaircominfoasset->SIZE_ID.'
     </div> 
    </div>  


    <div class="row">
    <div class="col-lg-2" align="right">
    <label>ยี่ห้อ :</label>
    </div> 
    <div class="col-lg-4" align="left">
   '.$repaircominfoasset->BRAND_NAME.'
    </div> 
    <div class="col-lg-2" align="right">
    <label>สี :</label>
    </div> 
    <div class="col-lg-4" align="left">
    '.$repaircominfoasset->COLOR_NAME.'
    </div> 
   </div> 


   <div class="row">
   <div class="col-lg-2" align="right">
   <label>วันที่รับ :</label>
   </div> 
   <div class="col-lg-4" align="left">
  '.DateThai($repaircominfoasset->RECEIVE_DATE).'
   </div> 
   <div class="col-lg-2" align="right">
   <label>ราคา :</label>
   </div> 
   <div class="col-lg-4" align="left">
   '.$repaircominfoasset->PRICE_PER_UNIT.'
   </div> 
  </div> 
   
   
    
    <div class="row">
    <div class="col-lg-2" align="right">
    <label>รายละเอียด :</label>
    </div> 
    <div class="col-lg-10" align="left">
    '.$repaircominfoasset->ARTICLE_PROP.'
    </div> 
    
    </div>  
   

    </div>     
    
    
    

    <div class="col-sm-3">
    
    <div class="form-group">
    
    <img src="data:image/png;base64,'. chunk_split(base64_encode($repaircominfoasset->IMG)) .'" id="image_upload_preview" alt="กรุณาเพิ่มรูปภาพ" height="200" width="200"/>
   
    </div>
    
    </div>
    </div>
    
    
    
    
    </div>
    
    
    </div>
    
    ';
    
    echo $output;
    
    
    }



    public function repairinfocomasset(Request $request,$idasset)
    {


             $repaircominfoasset = DB::table('asset_article')->where('asset_article.ARTICLE_ID','=',$idasset)
             ->leftjoin('supplies_location','asset_article.LOCATION_ID','=','supplies_location.LOCATION_ID')
             ->leftjoin('supplies_brand','asset_article.BRAND_ID','=','supplies_brand.BRAND_ID')
             ->leftjoin('asset_color','asset_article.COLOR_ID','=','asset_color.COLOR_ID')
             ->leftjoin('supplies_location_level','asset_article.LOCATION_LEVEL_ID','=','supplies_location_level.LOCATION_LEVEL_ID')
             ->leftjoin('supplies_location_level_room','asset_article.LEVEL_ROOM_ID','=','supplies_location_level_room.LEVEL_ROOM_ID')
             ->first(); 


            $infohisrepair = Informcomrepair::where('informcom_repair.ARTICLE_ID','=',$repaircominfoasset->ARTICLE_ID)
            ->leftjoin('asset_article','asset_article.ARTICLE_ID','=','informcom_repair.ARTICLE_ID')
            ->orderBy('informcom_repair.ID', 'desc') 
            ->get();

            $detailplan = DB::table('asset_care_list')->where('ARTICLE_ID','=',$repaircominfoasset->ARTICLE_ID) ->orderBy('CARE_LIST_ID', 'desc') ->get();

            $planrepair_first = DB::table('informcom_plan')->where('REPAIR_PLAN_ARTICLE_ID','=',$repaircominfoasset->ARTICLE_ID)->where('REPAIR_TYPE_CHECK','=','plan')->first();

            $planrepair = DB::table('informcom_plan')->where('REPAIR_PLAN_ARTICLE_ID','=',$repaircominfoasset->ARTICLE_ID)->where('REPAIR_TYPE_CHECK','=','plan') ->orderBy('REPAIR_PLAN_ID', 'desc') ->get();

            
            $planrepairmain = DB::table('informcom_plan')->where('REPAIR_PLAN_ARTICLE_ID','=',$repaircominfoasset->ARTICLE_ID)->first();
            
           
            if($planrepairmain == '' || $planrepairmain == null){
                $planrepair_sub = DB::table('informcom_plan_sub')->where('informcom_plan_sub.REPAIR_PLAN_ID','=','')->get();
                $REPAIR_PLAN_ID = '';

                $REPAIR_PLAN_DATE = '';
                $REPAIR_PLAN_BEGIN_TIME = '';
                $REPAIR_PLAN_END_TIME = '';
                $REPAIR_PLAN_REMARK = '';

            }else{
                $planrepair_sub = DB::table('informcom_plan_sub')->where('informcom_plan_sub.REPAIR_PLAN_ID','=',$planrepairmain->REPAIR_PLAN_ID)->get();
                $REPAIR_PLAN_ID = $planrepair_first->REPAIR_PLAN_ID;

                $REPAIR_PLAN_DATE = $planrepair_first->REPAIR_PLAN_DATE;
                $REPAIR_PLAN_BEGIN_TIME = $planrepair_first->REPAIR_PLAN_BEGIN_TIME;
                $REPAIR_PLAN_END_TIME = $planrepair_first->REPAIR_PLAN_END_TIME;
                $REPAIR_PLAN_REMARK = $planrepair_first->REPAIR_PLAN_REMARK;

            }

         
            $planrepair_get = DB::table('informcom_plan_sub')->get();

            $checkrepair = DB::table('informcom_plan')->where('REPAIR_PLAN_ARTICLE_ID','=',$repaircominfoasset->ARTICLE_ID)->orderBy('REPAIR_PLAN_ID', 'desc') ->get();

            $leader = DB::table('gleave_leader')->get(); 

            $object = '';
            
            return view('manager_repaircom.repaircomasset_repair',[
                'repaircominfoasset' => $repaircominfoasset,
                'infohisrepairs' => $infohisrepair,
                'detailplans' => $detailplan,
                'planrepairs' => $planrepair,
                'planrepair_subs' => $planrepair_sub,
                'planrepair_gets' => $planrepair_get,
                'checkrepairs' => $checkrepair,
                'leaders' => $leader,
                'REPAIR_PLAN_ID' => $REPAIR_PLAN_ID,
                'REPAIR_PLAN_DATE' => $REPAIR_PLAN_DATE,
                'REPAIR_PLAN_BEGIN_TIME' => $REPAIR_PLAN_BEGIN_TIME,
                'REPAIR_PLAN_END_TIME' => $REPAIR_PLAN_END_TIME,
                'REPAIR_PLAN_REMARK' => $REPAIR_PLAN_REMARK, 
                'objects' =>$object            
           
              ]);

        }

        public function savecheckrepaircom(Request $request)
        {
    
     
                 $ARTICLE_ID = $request->REPAIR_PLAN_ARTICLE_ID;
                 $REPAIR_ID = $request->REPAIR_PLAN_ARTICLE_NUM;

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
     
                 $addasset= new Informcomplan();
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
     
                
                
                
                 $REPAIR_PLAN_ID = Informcomplan::max('REPAIR_PLAN_ID');
             


                 if($request->REPAIR_PLAN_SUB_NAME != '' || $request->REPAIR_PLAN_SUB_NAME != null){
     
                     $REPAIR_PLAN_SUB_NAME = $request->REPAIR_PLAN_SUB_NAME;
                     $REPAIR_PLAN_SUB_REMARK = $request->REPAIR_PLAN_SUB_REMARK;
                     $REPAIR_PLAN_SUB_RESULT = $request->REPAIR_PLAN_SUB_RESULT;
                  
         
                     $number =count($REPAIR_PLAN_SUB_NAME);
                     $count = 0;
                     for($count = 0; $count< $number; $count++)
                     {  
                      
                        $add = new Informcomplansub();
                        $add->REPAIR_PLAN_ID = $REPAIR_PLAN_ID;
                        $add->REPAIR_PLAN_SUB_NAME = $REPAIR_PLAN_SUB_NAME[$count];
                        $add->REPAIR_PLAN_SUB_REMARK = $REPAIR_PLAN_SUB_REMARK[$count];
                        $add->REPAIR_PLAN_SUB_RESULT = $REPAIR_PLAN_SUB_RESULT[$count];                      
                        $add->save();  
                     }
                 }
                 $check = DB::table('informrepair_plan_sub')
                 ->where('REPAIR_PLAN_ID','=',$REPAIR_PLAN_ID)
                 ->where('REPAIR_PLAN_SUB_RESULT','=','ผิดปกติ')
                 ->count();
                 
                 if($check !=0){
                     $upadtecheck = Informcomplan::find($REPAIR_PLAN_ID); 
                     $upadtecheck->REPAIR_RESULT = 'ผิดปกติ';
                     $upadtecheck->save(); 
         
                 }else{
                    $upadtecheck = Informcomplan::find($REPAIR_PLAN_ID); 
                    $upadtecheck->REPAIR_RESULT = 'ปกติ';
                    $upadtecheck->save(); 
                 }      
                return redirect()->route('mrepaircom.repairinfocomasset',['idasset'=> $ARTICLE_ID]); 
    
        }

        public function repaircominfoassetsave_carelist(Request $request)
        {
     
                 $ARTICLE_ID = $request->PLAN_ARTICLE_ID;

                 $addcarelist= new Assetcarelist();
                 $addcarelist->ARTICLE_ID = $ARTICLE_ID;
                 $addcarelist->CARE_LIST_NAME = $request->CARE_LIST_NAME;
                 $addcarelist->save();
                 Session::flash('tab.asset.repair','tab4');
                 return redirect()->route('mrepaircom.repairinfocomasset',['idasset'=> $ARTICLE_ID]); 
    
        }   
        
        public function repaircominfoassetupdate_carelist(Request $request)
        {
            $ARTICLE_ID = $request->PLAN_ARTICLE_ID;
            $LIST_ID = $request->CARE_LIST_ID;
            $object = $request->object;

            $update= Assetcarelist::find($LIST_ID);
            $update->ARTICLE_ID = $ARTICLE_ID;
            $update->CARE_LIST_NAME = $request->CARE_LIST_NAME;
            $update->save();            
  
            return redirect()->route('mrepaircom.repairinfocomasset',['idasset'=> $ARTICLE_ID]);    
        }

        public function repaircominfoassetdelete_carelist(Request $request,$idasset,$id)
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

            return redirect()->route('mrepaircom.repairinfocomasset',['idasset'=> $idasset]);     
        }

        public function repaircomdelete_planrepair(Request $request,$idasset,$id)
        {
            $repaircominfoasset = DB::table('asset_article')
            ->leftJoin('supplies_location','supplies_location.LOCATION_ID','=','asset_article.LOCATION_ID')
            ->leftJoin('supplies_location_level','supplies_location_level.LOCATION_LEVEL_ID','=','asset_article.LOCATION_LEVEL_ID')
            ->leftJoin('supplies_location_level_room','supplies_location_level_room.LEVEL_ROOM_ID','=','asset_article.LEVEL_ROOM_ID')
            ->leftjoin('supplies_brand','asset_article.BRAND_ID','=','supplies_brand.BRAND_ID')
            ->leftjoin('asset_color','asset_article.COLOR_ID','=','asset_color.COLOR_ID')
            ->leftjoin('supplies_model','asset_article.MODEL_ID','=','supplies_model.MODEL_ID')
            ->where('asset_article.ARTICLE_ID','=',$idasset)->first(); 
 
            Informcomplan::where('REPAIR_PLAN_ARTICLE_ID','=',$repaircominfoasset->ARTICLE_ID)->where('REPAIR_PLAN_ID','=',$id)->delete();
            Informcomplansub::where('REPAIR_PLAN_ID','=',$id)->delete();

            return redirect()->route('mrepaircom.repairinfocomasset',['idasset'=> $idasset]);     
        }

   
        public function checkrepaircomall(Request $request)
        {
    
     
                 $ARTICLE_ID = $request->REPAIR_PLAN_ARTICLE_ID;
                 $REPAIR_ID = $request->REPAIR_PLAN_ARTICLE_NUM;
                 $REPAIR_PLAN_ID = $request->REPAIR_PLAN_ID;

     
                 $addasset= Informcomplan::find($REPAIR_PLAN_ID);
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
                    
                    Informcomplansub::where('REPAIR_PLAN_ID','=',$REPAIR_PLAN_ID)->delete(); 

                     $REPAIR_PLAN_SUB_NAME = $request->REPAIR_PLAN_SUB_NAME;
                     $REPAIR_PLAN_SUB_REMARK = $request->REPAIR_PLAN_SUB_REMARK;
                     $REPAIR_PLAN_SUB_RESULT = $request->REPAIR_PLAN_SUB_RESULT;
                  
         
                     $number =count($REPAIR_PLAN_SUB_NAME);
                     $count = 0;
                     for($count = 0; $count< $number; $count++)
                     {  
                      
                        $add = new Informcomplansub();
                        $add->REPAIR_PLAN_ID = $REPAIR_PLAN_ID;
                    
                        $add->REPAIR_PLAN_SUB_NAME = $REPAIR_PLAN_SUB_NAME[$count];
                        $add->REPAIR_PLAN_SUB_REMARK = $REPAIR_PLAN_SUB_REMARK[$count];
                        $add->REPAIR_PLAN_SUB_RESULT = $REPAIR_PLAN_SUB_RESULT[$count];
                      
                        $add->save(); 
                      
              
                     }
                 }
     
     

                 $check = DB::table('informrepair_plan_sub')
                 ->where('REPAIR_PLAN_ID','=',$REPAIR_PLAN_ID)
                 ->where('REPAIR_PLAN_SUB_RESULT','=','ผิดปกติ')
                 ->count();
                 
                 if($check !=0){
                     $upadtecheck = Informcomplan::find($REPAIR_PLAN_ID); 
                     $upadtecheck->REPAIR_RESULT = 'ผิดปกติ';
                     $upadtecheck->save(); 
         
                 }else{
                    $upadtecheck = Informcomplan::find($REPAIR_PLAN_ID); 
                    $upadtecheck->REPAIR_RESULT = 'ปกติ';
                    $upadtecheck->save(); 
                 }
    
    
    
                return redirect()->route('mrepaircom.repairinfocomasset',['idasset'=> $ARTICLE_ID]); 
    
        }


    

      
        public function saveplanrepaircom(Request $request)
        {
                 $ARTICLE_ID = $request->REPAIR_PLAN_ARTICLE_ID;
                 $REPAIR_ID = $request->REPAIR_PLAN_ARTICLE_NUM;

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
     
                 $addasset= new Informcomplan();
                 $addasset->REPAIR_PLAN_ARTICLE_ID = $ARTICLE_ID;
                 $addasset->REPAIR_PLAN_ARTICLE_NUM = $REPAIR_ID;
                 $addasset->REPAIR_PLAN_DATE = $REPAIR_PLAN_DATE;
                 $addasset->REPAIR_PLAN_BEGIN_TIME = $request->REPAIR_PLAN_BEGIN_TIME;
                 $addasset->REPAIR_PLAN_END_TIME = $request->REPAIR_PLAN_END_TIME;
                 $addasset->REPAIR_PLAN_REMARK = $request->REPAIR_PLAN_REMARK;
                
                 $addasset->save();
     
                 $REPAIR_PLAN_ID = Informcomplan::max('REPAIR_PLAN_ID');
             
     
                 if($request->REPAIR_PLAN_SUB_NAME != '' || $request->REPAIR_PLAN_SUB_NAME != null){
     
                     $REPAIR_PLAN_SUB_NAME = $request->REPAIR_PLAN_SUB_NAME;
                     $REPAIR_PLAN_SUB_REMARK = $request->REPAIR_PLAN_SUB_REMARK;
                  
                  
         
                     $number =count($REPAIR_PLAN_SUB_NAME);
                     $count = 0;
                     for($count = 0; $count< $number; $count++)
                     {  
                      
                        $add = new Informcomplansub();
                        $add->REPAIR_PLAN_ID = $REPAIR_PLAN_ID;
                    
                        $add->REPAIR_PLAN_SUB_NAME = $REPAIR_PLAN_SUB_NAME[$count];
                        $add->REPAIR_PLAN_SUB_REMARK = $REPAIR_PLAN_SUB_REMARK[$count];
                      
                        $add->save(); 
                      
              
                     }
                 }
     
    
                Session::flash('tab.asset.repair','tab3');
                return redirect()->route('mrepaircom.repairinfocomasset',['idasset'=> $ARTICLE_ID]); 
    
        }

        function pdf_com(Request $request,$idref)
        {    
            
            $informcomrepair = Informcomrepair::where('informcom_repair.ID','=',$idref)   
            ->leftjoin('hrd_person','informcom_repair.USER_REQUEST_ID','=','hrd_person.ID')
            ->leftJoin('asset_article','asset_article.ARTICLE_ID','=','informcom_repair.ARTICLE_ID')
            ->leftjoin('hrd_department_sub','hrd_department_sub.HR_DEPARTMENT_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_ID')
            ->leftjoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_SUB_ID')
            ->first(); 

            $informrepairindex = Informcomrepair::where('informcom_repair.ID','=',$idref)->first();   

                $html = View('manager_repaircom.pdf_com',[
                    'informcomrepair' => $informcomrepair,
                    'informrepairindex' => $informrepairindex
                ]);
            
                return viewpdf($html);

                }


                //-----------------------------ตั้งค่าระบบงานซ่อม


                public function setting_typesystem()
                {
                   
                    $infosystemtype = Informcomsystemtype::orderBy('INFORMCOM_ST_ID', 'asc')  
                                                            ->get();
                                                 
                   
                    return view('manager_repaircom.setupinformcomsystemtype',[
                        'infosystemtypes' => $infosystemtype
                    ]);
                }
                
                public function setting_typesystem_add(Request $request)
                    {
                  
                        return view('manager_repaircom.setupinformcomsystemtype_add');
                
                    }
                
                    public function setting_typesystem_save(Request $request)
                    {
                       
                
                            $addarticle = new Informcomsystemtype(); 
                            $addarticle->INFORMCOM_ST_NAME = $request->INFORMCOM_ST_NAME;
                         
                 
                            $addarticle->save();
                
                
                            return redirect()->route('mrepaircom.setting_typesystem'); 
                    }
                
                    public function setting_typesystem_edit(Request $request,$id)
                    {
                      
                    
                       $id_in= $id;
                     
                       $infosystem = Informcomsystemtype::where('INFORMCOM_ST_ID','=',$id_in)
                       ->first();
                
                
                
                        return view('manager_repaircom.setupinformcomsystemtype_edit',[
                        'infosystem' => $infosystem 
                        ]);
                
                    }
                
                
                
                    public function setting_typesystem_update(Request $request)
                    {
                        $id = $request->INFORMCOM_ST_ID; 
                
                        $updatesystem = Informcomsystemtype::find($id);
                        $updatesystem->INFORMCOM_ST_NAME = $request->INFORMCOM_ST_NAME;
                        $updatesystem->save();
                
                
                        return redirect()->route('mrepaircom.setting_typesystem'); 
                
                    }
                
                    
                    public function setting_typesystem_delete($id) { 
                
                        Informcomsystemtype::destroy($id);         
                        return redirect()->route('mrepaircom.setting_typesystem');   
                    }
           

}
