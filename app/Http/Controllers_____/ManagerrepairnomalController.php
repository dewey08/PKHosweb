<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Controllers\Report\InformrepairReportController;
use App\Models\Person;
use App\Models\Informrepairindex;
use App\Models\Informrepairindextech;
use App\Models\Informrepairservice;
use App\Models\Informrepairplan;
use App\Models\Informrepairplansub;
use App\Models\Informrepairsystemtype;

use App\Models\Assetcarelist;
use App\Models\Assetarticle;
use App\Models\Warehouserequest;
use App\Models\Warehouserequestsub;
use App\Models\Warehousetreasurypay;
use App\Models\Warehousetreasuryexportsub;
use App\Models\Infomrepair_functionnormal;


date_default_timezone_set("Asia/Bangkok");

class ManagerrepairnomalController extends Controller
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
        $repairReport = new InformrepairReportController();
        $data['repaire_AllStatus'] = $repairReport->getInforrepairByStatus('all',$year_ad); // ทั้งหมด
        $data['repaire_status_1'] = $repairReport->getInforrepairByStatus('REQUEST',$year_ad); // ร้องขอ
        $data['repaire_status_2'] = $repairReport->getInforrepairByStatus('RECEIVE',$year_ad); // รับงาน
        $data['repaire_status_3'] = $repairReport->getInforrepairByStatus('PENDING',$year_ad); // ดำเนินการซ่อม
        $data['repaire_status_4'] = $repairReport->getInforrepairByStatus('SUCCESS',$year_ad); // ซ่อมเสร็จแล้ว
        $data['repaire_status_5'] = $repairReport->getInforrepairByStatus('OUTSIDE',$year_ad); // ส่งซ่อมภายนอก
        $data['repaire_status_6'] = $repairReport->getInforrepairByStatus('DEAL',$year_ad); // จำหน่าย
        $data['repaire_status_7'] = $repairReport->getInforrepairByStatus('REPAIR_OUT',$year_ad); // แจ้งยกเลิก
        $data['repaire_status_8'] = $repairReport->getInforrepairByStatus('CANCEL',$year_ad); // ยกเลิก

        $EnddayOfMonth = date('Y-m-d',strtotime(date('Y-m-1') .'+1month -1day'));
        $data['repaire_today_request'] = $repairReport->countInforrepairByStatus_between('all',date('Y-m-d'),date('Y-m-d'));
        $data['repaire_tomonth_request'] = $repairReport->countInforrepairByStatus_between('all',date('Y-m-1'),$EnddayOfMonth);
        $data['repaire_toyear_request'] = $repairReport->countInforrepairByStatus_between('all',($year_ad-1).'-10-01',$year_ad.'-09-30');
        $data['repairePlan_today_request'] = $repairReport->countInforrepairPlanBybetween(date('Y-m-d'),date('Y-m-d'));
        $data['repairePlan_tomonth_request'] = $repairReport->countInforrepairPlanBybetween(date('Y-m-1'),$EnddayOfMonth);
        $data['repairePlan_toyear_request'] = $repairReport->countInforrepairPlanBybetween(($year_ad-1).'-10-01',$year_ad.'-09-30');
        $data['informrepair_M'] = $repairReport->countInformrepair_M_ByYear($year_ad);
        $data['informrepair_success_M'] = $repairReport->countInformrepair_success_M_ByYear($year_ad);
        $data['informrepairPlan_M'] = $repairReport->countInformrepairPlan_M_ByYear($year_ad);
        $data['informrepair_fanciness_score'] = $repairReport->countInformrepair_fanciness_score_ByYear($year_ad);
        $data['informrepair_result'] = $repairReport->countInformrepairPlan_Result_ByYear($year_ad);
        $workperson = $repairReport->countWorkofperson($year_ad);
        $w_person = array();
        foreach($workperson as $row){
            $w_person[$row['id']]['name'] = $repairReport->getNameTechByperson_id($row['id']);
            $w_person[$row['id']]['amount'] = $row['count'];
        }
        $data['workofperson'] = $w_person;
        return view('manager_repairnomal.dashboard_repairnomal',$data);
    }

    public function repairnomal_search()
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

        $repairReport = new InformrepairReportController();
        $data['repairnomals'] = $repairReport->getInformrepair_Bybudgetyear_status($year_ad , $data['repairstatus']);
        // dd($data['repairnomals']);
        return view('manager_repairnomal.repairnomal_search',$data);
    }
    public function deatailcalendar()
    {
        $inforepairnomal = DB::table('informrepair_plan')->get();
    
        return view('manager_repairnomal.carcalendar_repairnomal',[
            'inforepairnomals' => $inforepairnomal
        ]);
    }
    

    public function repairnomalinfo(Request $request)
    {
        if(!empty($request->_token)){
            $search     = $request->get('search');
            $status     = $request->SEND_STATUS;
            $datebigin  = $request->get('DATE_BIGIN');
            $dateend    = $request->get('DATE_END');
            $yearbudget = $request->BUDGET_YEAR;
            session([
                'manager_repairnomal.repairnomalinfo.search' => $search,
                'manager_repairnomal.repairnomalinfo.status' => $status,
                'manager_repairnomal.repairnomalinfo.datebigin' => $datebigin,
                'manager_repairnomal.repairnomalinfo.dateend' => $dateend,
                'manager_repairnomal.repairnomalinfo.yearbudget' => $yearbudget
                ]);
        }elseif(!empty(session('manager_repairnomal.repairnomalinfo'))){
            $search     = session('manager_repairnomal.repairnomalinfo.search');
            $status     = session('manager_repairnomal.repairnomalinfo.status');
            $datebigin  = session('manager_repairnomal.repairnomalinfo.datebigin');
            $dateend    = session('manager_repairnomal.repairnomalinfo.dateend');
            $yearbudget = session('manager_repairnomal.repairnomalinfo.yearbudget');
        }else{
            $search     = '';
            $status     = 'REQUEST';
            $datebigin = '01/10/'.(getBudgetyear()-1);
            $dateend   = '30/09/'.getBudgetyear();
            $yearbudget = getBudgetyear();
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
           $from = date($displaydate_bigen);
           $to = date($displaydate_end);   
            if($status == null){
                $inforepairnomal = Informrepairindex::select('asset_article.ARTICLE_NUM','REPAIR_ID','REPAIR_STATUS','PRIORITY_ID','FANCINESS_SCORE','DATE_TIME_REQUEST','REPAIR_NAME','SYMPTOM','USRE_REQUEST_NAME','HR_DEPARTMENT_SUB_SUB_NAME','BUILD_NAME','TECH_REPAIR_NAME','BUILD_NAME','informrepair_index.ID','informrepair_index.TECH_REPAIR_NAME')
                    ->leftjoin('hrd_person','informrepair_index.USER_REQUEST_ID','=','hrd_person.ID')
                ->leftjoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_SUB_ID')
                ->leftjoin('asset_building','informrepair_index.LOCATION_SEE_ID','=','asset_building.ID')
                ->leftjoin('asset_article','informrepair_index.ARTICLE_ID','=','asset_article.ARTICLE_ID')
                ->where(function($q) use ($search){
                    $q->where('REPAIR_ID','like','%'.$search.'%');
                    $q->orwhere('REPAIR_NAME','like','%'.$search.'%');
                    $q->orwhere('SYMPTOM','like','%'.$search.'%');
                    $q->orwhere('USRE_REQUEST_NAME','like','%'.$search.'%');
                    $q->orwhere('TECH_REPAIR_NAME','like','%'.$search.'%'); 
                    })
                    ->WhereBetween('DATE_TIME_REQUEST',[$from.' 00:00:00',$to.' 23:59:00']) 
                ->orderBy('REPAIR_ID', 'desc')->get(); 
            }else{
                $inforepairnomal = Informrepairindex::select('asset_article.ARTICLE_NUM','REPAIR_ID','REPAIR_STATUS','PRIORITY_ID','FANCINESS_SCORE','DATE_TIME_REQUEST','REPAIR_NAME','SYMPTOM','USRE_REQUEST_NAME','HR_DEPARTMENT_SUB_SUB_NAME','BUILD_NAME','TECH_REPAIR_NAME','BUILD_NAME','informrepair_index.ID','informrepair_index.TECH_REPAIR_NAME')
                    ->leftjoin('hrd_person','informrepair_index.USER_REQUEST_ID','=','hrd_person.ID')
                ->leftjoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_SUB_ID')
                ->leftjoin('asset_building','informrepair_index.LOCATION_SEE_ID','=','asset_building.ID')
                ->leftjoin('asset_article','informrepair_index.ARTICLE_ID','=','asset_article.ARTICLE_ID')
                ->where('REPAIR_STATUS','=',$status)
                ->where(function($q) use ($search){
                    $q->where('REPAIR_ID','like','%'.$search.'%');
                    $q->orwhere('REPAIR_NAME','like','%'.$search.'%');
                    $q->orwhere('SYMPTOM','like','%'.$search.'%');
                    $q->orwhere('USRE_REQUEST_NAME','like','%'.$search.'%');
                    $q->orwhere('TECH_REPAIR_NAME','like','%'.$search.'%'); 
                    })
                    ->WhereBetween('DATE_TIME_REQUEST',[$from.' 00:00:00',$to.' 23:59:00']) 
                ->orderBy('REPAIR_ID', 'desc')->get(); 
            }
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $year_id = $yearbudget;
        $infostatus = DB::table('informrepair_status')->get();

        $checkpdf = DB::table('infomrepair_function')->where('ACTIVE','=','True')->count();

        $checfunc = DB::table('informrepair_setupfunc')->where('ACTIVE','=','True')->count();
        $openform_function = Infomrepair_functionnormal::where('FUNCT_REPNORMAL_STATUS','=','True' )->first();

        if ($openform_function != '') {       
            $code = $openform_function->FUNCT_REPNORMAL_CODE;  
        } else {                      
            $code = '';
        }

        return view('manager_repairnomal.inforepairnomal',[
            'inforepairnomals' => $inforepairnomal,
            'infostatuss' => $infostatus, 
            'displaydate_bigen'=> $displaydate_bigen, 
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'budgets' =>  $budget,
            'year_id'=>$year_id, 
            'checkpdf'=>$checkpdf,
            'codes'=>$code,
            'checfunc'=>$checfunc,
        ]);
       
    }


    //-----------------------รีไดเรค---------------------------------------------

    public function repairnomalinfore(Request $request,$status)
    {
     
        $status = $status;
        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;
        }
    
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

                $inforepairnomal = Informrepairindex::where('REPAIR_STATUS','=',$status)->orderBy('PRIORITY_ID', 'desc')->get(); 

        $infostatus = DB::table('informrepair_status')->get();

        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';
        $status = '';
        $search = '';
        $year_id = $yearbudget;


        
        return view('manager_repairnomal.inforepairnomal',[
            'inforepairnomals' => $inforepairnomal,
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

    public function repairnomaledit(Request $request,$id)
    {

        
         $infoasset = DB::table('asset_article')->get();


         $infolocation = DB::table('supplies_location')->get();
      

         $informrepair_tech = DB::table('informrepair_tech')
         ->leftJoin('hrd_person','hrd_person.ID','=','informrepair_tech.PERSON_ID')
         ->get();


         $informrepairindex = Informrepairindex::where('ID','=',$id)->first();





          $infoassetother = DB::table('informrepair_other')->get();

          

          if($informrepairindex->LOCATION_SEE_ID != ''){
            $infolocationlevel= DB::table('supplies_location_level')->where('LOCATION_ID','=',$informrepairindex->LOCATION_SEE_ID)->get();
          }
          else{
            $infolocationlevel= '';      
          }   
          

          if($informrepairindex->LOCATIONLEVEL_SEE_ID != ''){
            $infolocationlevelroom= DB::table('supplies_location_level_room')->where('LOCATION_LEVEL_ID','=',$informrepairindex->LOCATIONLEVEL_SEE_ID)->get();
          }
          else{
            $infolocationlevelroom= '';      
          }   


          
          
        return view('manager_repairnomal.inforepairnomal_edit',[
            'infoassets' => $infoasset,
            'infolocations' => $infolocation,
            'infolocationlevels' => $infolocationlevel,
            'infolocationlevelrooms' => $infolocationlevelroom, 
            'informrepair_techs' => $informrepair_tech,
            'informrepairindex' => $informrepairindex,
            'infoassetothers' => $infoassetother,
        
            
        ]);
    }


    public function updateinforepairnomal(Request $request)
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
            $addinforepair = Informrepairindex::find($ID);
            $addinforepair->DATE_TIME_REQUEST = $datere;    
            $addinforepair->REPAIR_NAME = $request->REPAIR_NAME;
            $addinforepair->LOCATION_SEE_ID = $request->LOCATION_SEE_ID;
            $addinforepair->LOCATIONLEVEL_SEE_ID = $request->LOCATIONLEVEL_SEE_ID;
            $addinforepair->LOCATIONLEVELROOM_SEE_ID = $request->LOCATIONLEVELROOM_SEE_ID;

            $addinforepair->ARTICLE_ID = $request->ARTICLE_ID;
            $addinforepair->OTHER_NAME = $request->OTHER_NAME;

        
            
         if($request->hasFile('picture')){
            
            $file = $request->file('picture');  
            $contents = $file->openFile()->fread($file->getSize());
            $addinforepair->REPAIR_IMG = $contents;   

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
           $addinforepair->REPAIR_STATUS = 'REQUEST';

           $addinforepair->save();


            return redirect()->route('mrepairnomal.repairnomalinfo'); 

    }

    

//------------------------------------------------------------

    public function detailrepairnomal(Request $request)
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

               $inforepairnomal = Informrepairindex::where('informrepair_index.ID','=',$request->id)
            ->leftjoin('informrepair_priority','informrepair_priority.PRIORITY_ID','=','informrepair_index.PRIORITY_ID')
            ->leftjoin('hrd_person','informrepair_index.USER_REQUEST_ID','=','hrd_person.ID')
            ->leftjoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_SUB_ID')

            ->leftjoin('asset_article','informrepair_index.ARTICLE_ID','=','asset_article.ARTICLE_ID')
            ->leftjoin('asset_building','informrepair_index.LOCATION_SEE_ID','=','asset_building.ID')
            ->leftjoin('supplies_location_level','informrepair_index.LOCATIONLEVEL_SEE_ID','=','supplies_location_level.LOCATION_LEVEL_ID')
            ->leftjoin('supplies_location_level_room','informrepair_index.LOCATIONLEVELROOM_SEE_ID','=','supplies_location_level_room.LEVEL_ROOM_ID')

            ->first(); 
    
      //=========================
          
            if($inforepairnomal->TECH_RECEIVE_DATE == ''){
                $TECH_RECEIVE_DATE = '';     
            }else{
                $TECH_RECEIVE_DATE = DateThai($inforepairnomal->TECH_RECEIVE_DATE);
            }

            if($inforepairnomal->TECH_REPAIR_DATE == ''){
                $TECH_REPAIR_DATE = '';     
            }else{
                $TECH_REPAIR_DATE = DateThai($inforepairnomal->TECH_REPAIR_DATE);
            }

            if($inforepairnomal->TECH_SUCCESS_DATE == ''){
                $TECH_SUCCESS_DATE = '';     
            }else{
                $TECH_SUCCESS_DATE = DateThai($inforepairnomal->TECH_SUCCESS_DATE);
            }

            if($inforepairnomal->REPAIR_DATE == ''){
                $REPAIR_DATE = '';     
            }else{
                $REPAIR_DATE = DateThai($inforepairnomal->REPAIR_DATE);
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
          '.$inforepairnomal->REPAIR_ID.'
          </div> 
      </div>    
      <div class="row">
          <div class="col-lg-2" align="right">
          <label>วันที่แจ้ง :</label>
          </div> 
          <div class="col-lg-4" align="left">
          '.formateDatetime($inforepairnomal->DATE_TIME_REQUEST).'
          </div> 
          <div class="col-lg-2" align="right">
          <label>อาคาร :</label>
          </div> 
          <div class="col-lg-4" align="left">
          '.$inforepairnomal->BUILD_NAME.'
          </div> 
      </div>    
      
      <div class="row">
          <div class="col-lg-2" align="right">
          <label>ชั้น :</label>
          </div> 
          <div class="col-lg-4" align="left">
          '.$inforepairnomal->LOCATION_LEVEL_NAME.'
          </div> 
          <div class="col-lg-2" align="right">
          <label>ห้อง :</label>
          </div> 
          <div class="col-lg-4" align="left">
          '.$inforepairnomal->LEVEL_ROOM_NAME.'
          </div> 
     
      </div>    
    
      <div class="row">
      <div class="col-lg-2" align="right">
      <label>แจ้งซ่อม :</label>
      </div> 
      <div class="col-lg-8" align="left">
     '.$inforepairnomal->REPAIR_NAME.'
      </div> 
     </div>  
     
     <div class="row">
     <div class="col-lg-2" align="right">
     <label>รหัสครุภัณฑ์ :</label>
     </div> 
     <div class="col-lg-4" align="left">
     '.$inforepairnomal->ARTICLE_NUM.'
     </div> 
     <div class="col-lg-2" align="right">
     <label>ชื่อครุภัณฑ์ :</label>
     </div> 
     <div class="col-lg-4" align="left">
     '.$inforepairnomal->ARTICLE_NAME.'
     </div> 
    </div>  
    
    <div class="row">
    <div class="col-lg-2" align="right">
    <label>อาการ :</label>
    </div> 
    <div class="col-lg-10" align="left">
    '.$inforepairnomal->SYMPTOM.'
    </div> 
    
    </div>  
    
    <div class="row">
    <div class="col-lg-2" align="right">
    <label>ความเร่งด่วน :</label>
    </div> 
    <div class="col-lg-6" align="left">
    '.$inforepairnomal->PRIORITY_NAME.'
    </div> 
    
    </div>   
    
    <div class="row">
    <div class="col-lg-2" align="right">
    <label>ผู้แจ้งซ่อม :</label>
    </div> 
    <div class="col-lg-4" align="left">
    '.$inforepairnomal->USRE_REQUEST_NAME.'
    </div>
    <div class="col-lg-2" align="right">
    <label>ฝ่าย/แผนก  :</label>
    </div> 
    <div class="col-lg-4" align="left">
    '.$inforepairnomal->HR_DEPARTMENT_SUB_SUB_NAME.'
    </div>  
    </div>     
   
    
    
    
    
    </div>
    
    <div class="col-sm-3">
    
    <div class="form-group">
    
    <img src="data:image/png;base64,'. chunk_split(base64_encode($inforepairnomal->REPAIR_IMG)) .'" id="image_upload_preview" alt="กรุณาเพิ่มรูปภาพ" height="200" width="200"/>
    </div>
    
    </div>
    </div>
    </div>
    </div>';


    if($inforepairnomal->REPAIR_STATUS != 'REQUEST'){

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
    '.$inforepairnomal->TECH_RECEIVE_TIME.'
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
    '.$inforepairnomal->TECH_REPAIR_TIME.'
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
    '.$inforepairnomal->TECH_SUCCESS_TIME.'
    </div>  
    </div>

    <div class="row">
    <div class="col-lg-2" align="right">
    <label>หมายเหตุ :</label>
    </div> 
    <div class="col-lg-10" align="left">
    '.$inforepairnomal->TECH_RECEIVE_COMMENT.'
    </div>
    </div>

    <div class="row">
    <div class="col-lg-2" align="right">
    <label>ผู้รับเรื่อง :</label>
    </div> 
    <div class="col-lg-4" align="left">
    '.$inforepairnomal->TECH_RECEIVE_NAME.'
    </div>
    <div class="col-lg-2" align="right">
    <label>ช่างหลัก  :</label>
    </div> 
    <div class="col-lg-4" align="left">
    '.$inforepairnomal->TECH_REPAIR_NAME.'
    </div>  
    </div>

</div>

</div>';
    }
    
    
    if($inforepairnomal->REPAIR_STATUS!= 'REQUEST' && $inforepairnomal->REPAIR_STATUS!= 'RECEIVE'){

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
'.$inforepairnomal->REPAIR_COMMENT.'
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
'.$inforepairnomal->REPAIR_TIME.'
</div>  
</div>


<div class="row">
<div class="col-lg-2" align="right">
<label>รายละเอียด :</label>
</div> 
<div class="col-lg-10" align="left">
'.$inforepairnomal->REPAIR_COMMENT.'
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
'.$inforepairnomal->OUTSIDE_COMMENT.'
</div>
<div class="col-lg-2" align="right">
<label>อุปกรณ์ที่ติดไปด้วย :</label>
</div> 
<div class="col-lg-4" align="left">
'.$inforepairnomal->OUTSIDE_TOOL.'
</div>
</div>


<div class="row">
<div class="col-lg-2" align="right">
<label>ส่งซ่อมที่ร้าน :</label>
</div> 
<div class="col-lg-4" align="left">
'.$inforepairnomal->OUTSIDE_SHOP.'
</div>
<div class="col-lg-2" align="right">
<label>ผู้รับสิ่งของ :</label>
</div> 
<div class="col-lg-4" align="left">
'.$inforepairnomal->OUTSIDE_EMP.'
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
'.$inforepairnomal->GETBACK_PERSON.'
</div>
<div class="col-lg-2" align="right">
<label>วันที่รับกลับ :</label>
</div> 
<div class="col-lg-4" align="left">
'.DateThai($inforepairnomal->GETBACK_DATE).'
</div>
</div>

</div> 
</div>';
    }    
    echo $output;
    
    
    }

    //================================================รับเรื่อง============================================
    public function repairnomalreceived($id)
    {
        
        $iduser = Auth::user()->PERSON_ID; 

        $inforpersonuser=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->where('hrd_person.ID','=',$iduser)->first();


        $inforepairnomal = Informrepairindex::where('informrepair_index.ID','=',$id)
        ->select('informrepair_index.ID','REPAIR_ID','DATE_TIME_REQUEST','REPAIR_NAME','ARTICLE_NUM','ARTICLE_NAME','SYMPTOM','PRIORITY_NAME','USRE_REQUEST_NAME','HR_DEPARTMENT_SUB_SUB_NAME','BUILD_NAME','LOCATION_LEVEL_NAME','LEVEL_ROOM_NAME','REPAIR_IMG','OTHER_NAME')
        ->leftjoin('informrepair_priority','informrepair_priority.PRIORITY_ID','=','informrepair_index.PRIORITY_ID')
        ->leftjoin('hrd_person','informrepair_index.USER_REQUEST_ID','=','hrd_person.ID')
        ->leftjoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_SUB_ID')
        ->leftjoin('asset_article','asset_article.ARTICLE_ID','=','informrepair_index.ARTICLE_ID')
        ->leftjoin('asset_building','informrepair_index.LOCATION_SEE_ID','=','asset_building.ID')
        ->leftjoin('supplies_location_level','informrepair_index.LOCATIONLEVEL_SEE_ID','=','supplies_location_level.LOCATION_LEVEL_ID')
        ->leftjoin('supplies_location_level_room','informrepair_index.LOCATIONLEVELROOM_SEE_ID','=','supplies_location_level_room.LEVEL_ROOM_ID')
        ->first(); 


        $infotech = DB::table('informrepair_tech')
        ->leftJoin('hrd_person','hrd_person.ID','=','informrepair_tech.PERSON_ID')
        ->get();

        return view('manager_repairnomal.repairnomalreceived_add',[
                'inforepairnomal' => $inforepairnomal,
                'inforpersonuser' => $inforpersonuser,
                'infotechs'=> $infotech
        ]);
    
    }


     

    public function updateinfonomalreceived(Request $request)
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
 
             $addreceived = Informrepairindex::find($ID);

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
                  
                    $add = new Informrepairindextech();
                    $add->REPAIR_INDEX_ID = $ID;
                    $add->HR_PERSON_ID = $HR_PERSON_ID[$count];
                    $add->save(); 
                  
          
                 }
             }
 
 
             return response()->json([
                'status' => 1,
                'url' => route('mrepairnomal.repairnomalinfo')
            ]);



    }


    //-----------------------------------------แก้ไข--------------------


    public function repairnomalreceiveedit($id)
    {
        
        $iduser = Auth::user()->PERSON_ID; 

        $inforpersonuser=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->where('hrd_person.ID','=',$iduser)->first();


        $inforepairnomal = Informrepairindex::where('informrepair_index.ID','=',$id)
        ->select('informrepair_index.ID','REPAIR_ID','DATE_TIME_REQUEST','REPAIR_NAME','BUILD_NAME','LOCATION_LEVEL_NAME','LEVEL_ROOM_NAME','informrepair_index.ARTICLE_ID','ARTICLE_NUM','ARTICLE_NAME','SYMPTOM','PRIORITY_NAME','USRE_REQUEST_NAME','HR_DEPARTMENT_SUB_SUB_NAME','TECH_REPAIR_ID','TECH_RECEIVE_COMMENT','REPAIR_IMG','TECH_REPAIR_DATE','TECH_REPAIR_TIME','TECH_SUCCESS_DATE','TECH_SUCCESS_TIME')
        ->leftjoin('informrepair_priority','informrepair_priority.PRIORITY_ID','=','informrepair_index.PRIORITY_ID')
        ->leftjoin('hrd_person','informrepair_index.USER_REQUEST_ID','=','hrd_person.ID')
        ->leftjoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_SUB_ID')
        ->leftjoin('asset_building','informrepair_index.LOCATION_SEE_ID','=','asset_building.ID')
        ->leftjoin('supplies_location_level','informrepair_index.LOCATIONLEVEL_SEE_ID','=','supplies_location_level.LOCATION_LEVEL_ID')
        ->leftjoin('supplies_location_level_room','informrepair_index.LOCATIONLEVELROOM_SEE_ID','=','supplies_location_level_room.LEVEL_ROOM_ID')
        ->leftJoin('asset_article','asset_article.ARTICLE_ID','=','informrepair_index.ARTICLE_ID')
        ->first(); 

        $infotechrepair = Informrepairindextech::where('REPAIR_INDEX_ID','=',$id)->get();
  
        $counttechrepair = Informrepairindextech::where('REPAIR_INDEX_ID','=',$id)->count();

     

        $infotech = DB::table('informrepair_tech')
        ->leftJoin('hrd_person','hrd_person.ID','=','informrepair_tech.PERSON_ID')
        ->get();

        return view('manager_repairnomal.repairnomalreceived_edit',[
                'inforepairnomal' => $inforepairnomal,
                'inforpersonuser' => $inforpersonuser,
                'infotechrepairs' => $infotechrepair,
                'counttechrepair' => $counttechrepair,
                'infotechs'=> $infotech
        ]);
    
    }


    public function updateinforepairnomalreceive(Request $request)
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
 
             $addreceived = Informrepairindex::find($ID);

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

                
                Informrepairindextech::where('REPAIR_INDEX_ID','=',$ID)->delete(); 
 
                 $HR_PERSON_ID = $request->HR_PERSON_ID;
    
                 $number =count($HR_PERSON_ID);
                 $count = 0;
                 for($count = 0; $count< $number; $count++)
                 {  
                  
                    $add = new Informrepairindextech();
                    $add->REPAIR_INDEX_ID = $ID;
                    $add->HR_PERSON_ID = $HR_PERSON_ID[$count];
                    $add->save(); 
                  
          
                 }
             }
 
             return redirect()->route('mrepairnomal.repairnomalinfo'); 

    }





     //================================================ระหว่างซ่อม============================================

    
    public function repairnomalamong($id)
    {
         
        $iduser = Auth::user()->PERSON_ID; 
          
        $inforpersonuser=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->where('hrd_person.ID','=',$iduser)->first();

        $inforepairnomal = Informrepairindex::leftjoin('asset_building','informrepair_index.LOCATION_SEE_ID','=','asset_building.ID')
            ->leftjoin('supplies_location_level','informrepair_index.LOCATIONLEVEL_SEE_ID','=','supplies_location_level.LOCATION_LEVEL_ID')
            ->leftjoin('supplies_location_level_room','informrepair_index.LOCATIONLEVELROOM_SEE_ID','=','supplies_location_level_room.LEVEL_ROOM_ID')
            ->leftJoin('asset_article','asset_article.ARTICLE_ID','=','informrepair_index.ARTICLE_ID')
            ->where('informrepair_index.ID','=',$id)->first(); 


        return view('manager_repairnomal.repairnomalamong_add',[
                'detailid' => $id,
                'inforepairnomal' => $inforepairnomal,
                'inforpersonuser'=>$inforpersonuser

        ]);
    
    }


    public function updateinfonomalamong(Request $request)
    {

        $RE_DATE = $request->REPAIR_DATE;
     

        if($RE_DATE != ''){
         $STARTDAY = Carbon::createFromFormat('d/m/Y', $RE_DATE)->format('Y-m-d');
         $date_arrary_st=explode("-",$STARTDAY);  
         $y_sub_st = $date_arrary_st[0]; 
         
         if($y_sub_st >= 2500){
             $y_st = $y_sub_st-543;
         }else{
             $y_st = $y_sub_st;
         }
         $m_st = $date_arrary_st[1];
         $d_st = $date_arrary_st[2];  
         $RE_DATE= $y_st."-".$m_st."-".$d_st;
         }else{
         $RE_DATE= null;
     }
 
             $ID = $request->ID;
          
 
             $addamong= Informrepairindex::find($ID);
             $addamong->REPAIR_DATE = $RE_DATE;
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
            return redirect()->route('mrepairnomal.repairnomalinfo'); 
    }

    

   
//--------------------------------------------แก้ไข----------------------------------------------


public function repairnomalamongedit($id)
{
     
    $iduser = Auth::user()->PERSON_ID; 
      
    $inforpersonuser=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->where('hrd_person.ID','=',$iduser)->first();

    $inforepairnomal = Informrepairindex::leftjoin('asset_building','informrepair_index.LOCATION_SEE_ID','=','asset_building.ID')
    ->leftjoin('supplies_location_level','informrepair_index.LOCATIONLEVEL_SEE_ID','=','supplies_location_level.LOCATION_LEVEL_ID')
    ->leftjoin('supplies_location_level_room','informrepair_index.LOCATIONLEVELROOM_SEE_ID','=','supplies_location_level_room.LEVEL_ROOM_ID')
    ->leftJoin('asset_article','asset_article.ARTICLE_ID','=','informrepair_index.ARTICLE_ID')
    ->leftjoin('informrepair_priority','informrepair_priority.PRIORITY_ID','=','informrepair_index.PRIORITY_ID')
    ->leftjoin('hrd_person','informrepair_index.USER_REQUEST_ID','=','hrd_person.ID')
    ->leftjoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_SUB_ID')
    ->where('informrepair_index.ID','=',$id)->first(); 


    return view('manager_repairnomal.repairnomalamong_edit',[
            'inforepairnomal' => $inforepairnomal,
            'inforpersonuser'=>$inforpersonuser,
            'ID'=>$id

    ]);

}


public function updateinforepairnomalamong(Request $request)
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


         $addamong= Informrepairindex::find($ID);

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
            'url' => route('mrepairnomal.repairnomalinfo')
        ]);
}


    //================================================ซ่อมเสร็จ============================================
    
   
    public function repairnomalsuccess($id)
    {
        
        $id_user = Auth::user()->PERSON_ID; 

        $infoperson = DB::table('hrd_person')->where('ID','=',$id_user)->first();



        $inforepairnomal = Informrepairindex::where('informrepair_index.ID','=',$id)
        ->leftjoin('informrepair_priority','informrepair_priority.PRIORITY_ID','=','informrepair_index.PRIORITY_ID')
        ->leftjoin('hrd_person','informrepair_index.USER_REQUEST_ID','=','hrd_person.ID')
        ->leftjoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_SUB_ID')
        ->leftjoin('asset_article','asset_article.ARTICLE_ID','=','informrepair_index.ARTICLE_ID')
        ->leftjoin('asset_building','informrepair_index.LOCATION_SEE_ID','=','asset_building.ID')
        ->leftjoin('supplies_location_level','informrepair_index.LOCATIONLEVEL_SEE_ID','=','supplies_location_level.LOCATION_LEVEL_ID')
        ->leftjoin('supplies_location_level_room','informrepair_index.LOCATIONLEVELROOM_SEE_ID','=','supplies_location_level_room.LEVEL_ROOM_ID')
        ->first(); 

        $inforepairID = Informrepairindex::where('ID','=',$id)->first(); 

        $infoen = DB::table('informcom_engineer')->get();
        $servicetype = DB::table('informrepair_service_type')->get();
        
        $service = DB::table('informrepair_service')->where('REPAIR_INDEX_ID','=',$id)->get();
        $countservice = DB::table('informrepair_service')->where('REPAIR_INDEX_ID','=',$id)->count();

        

        return view('manager_repairnomal.repairnomalsuccess_add',[
                'inforepairnomal' => $inforepairnomal,
                'infoens'=> $infoen,
                'inforepairID'=> $inforepairID,
                'servicetypes'=> $servicetype,
                'services'=> $service,
                'countservice'=> $countservice,
                'infoperson'=> $infoperson,
           
        ]);
    
    }

    
    public function updateinfonomalsuccess(Request $request)
    {
 
             $ID = $request->ID;
             $REPAIR_ID = $request->REPAIR_ID;

             $REPAIR_STATUS = $request->REPAIR_STATUS;
 
             $addsuccess= Informrepairindex::find($ID);
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
                  
                    $add = new Informrepairservice();
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
                    $addsaveinfopay->TREASURT_PAY_COMMENT = 'เบิกจ่ายจากงานซ่อม';
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






            return redirect()->route('mrepairnomal.repairnomalinfo');  

    }

    //--------------------------------------------แก้ไข----------------------------------------------
    public function repairnomalsuccessedit($id)
    {
        

        $inforepairnomal = Informrepairindex::where('informrepair_index.ID','=',$id)
        ->leftjoin('informrepair_priority','informrepair_priority.PRIORITY_ID','=','informrepair_index.PRIORITY_ID')
        ->leftjoin('hrd_person','informrepair_index.USER_REQUEST_ID','=','hrd_person.ID')
        ->leftjoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_SUB_ID')
        ->first(); 

        $inforepairID = Informrepairindex::where('ID','=',$id)->first(); 

        $infoen = DB::table('informcom_engineer')->get();
        $servicetype = DB::table('informrepair_service_type')->get();

        $service = DB::table('informrepair_service')->where('REPAIR_INDEX_ID','=',$id)->get();

        $countservice = DB::table('informrepair_service')->where('REPAIR_INDEX_ID','=',$id)->count();


        $infopay = DB::table('warehouse_treasury_export_sub')
        ->leftjoin('warehouse_treasury_pay','warehouse_treasury_export_sub.TREASURT_PAY_ID','=','warehouse_treasury_pay.TREASURT_PAY_ID')
        ->leftjoin('supplies_unit_ref','warehouse_treasury_export_sub.TREASURY_EXPORT_SUB_UNIT','=','supplies_unit_ref.ID')  
        ->where('warehouse_treasury_pay.REPAIR_ID','=',$inforepairnomal->REPAIR_ID)->get();
        


        

        return view('manager_repairnomal.repairnomalsuccess_edit',[
                'inforepairnomal' => $inforepairnomal,
                'infoens'=> $infoen,
                'inforepairID'=> $inforepairID,
                'servicetypes'=> $servicetype,
                'services'=> $service,
                'countservice'=> $countservice,
                'infopays'=> $infopay,
        ]);
    
    }


    public function updateinforepairnomalsuccess(Request $request)
    {

 
             $ID = $request->ID;
             $REPAIR_ID = $request->REPAIR_ID;
             $GETBACK_ACTIVE = $request->GETBACK_ACTIVE;
             
 
             $addsuccess= Informrepairindex::find($ID);

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

                Informrepairservice::where('REPAIR_INDEX_ID','=',$ID)->delete(); 
 
                 $REPAIR_TYPE_ID = $request->REPAIR_TYPE_ID;
                 $REPAIR_SERVICE_NAME = $request->REPAIR_SERVICE_NAME;
                 $REPAIR_TOTAL = $request->REPAIR_TOTAL;
                 $REPAIR_PRICE_PER_UNIT = $request->REPAIR_PRICE_PER_UNIT;
              
     
                 $number =count($REPAIR_TYPE_ID);
                 $count = 0;
                 for($count = 0; $count< $number; $count++)
                 {  
                  
                    $add = new Informrepairservice();
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
            return redirect()->route('mrepairnomal.repairnomalinfo'); 
    }


      //============================================ยกเลิกราสยการ=================


      public function repairnomalinfocancel($id)
      {
  
        $inforepairnomaldetail = Informrepairindex::where('informrepair_index.ID','=',$id)
        ->leftjoin('informrepair_priority','informrepair_priority.PRIORITY_ID','=','informrepair_index.PRIORITY_ID')
        ->leftjoin('hrd_person','informrepair_index.USER_REQUEST_ID','=','hrd_person.ID')
        ->leftjoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_SUB_ID')
        ->leftjoin('asset_building','informrepair_index.LOCATION_SEE_ID','=','asset_building.ID')
        ->leftjoin('supplies_location_level','informrepair_index.LOCATIONLEVEL_SEE_ID','=','supplies_location_level.LOCATION_LEVEL_ID')
        ->leftjoin('supplies_location_level_room','informrepair_index.LOCATIONLEVELROOM_SEE_ID','=','supplies_location_level_room.LEVEL_ROOM_ID')
        ->first(); 
  
        $inforepairnomaldetailid = Informrepairindex::where('informrepair_index.ID','=',$id)->first();
       
      
  
          return view('manager_repairnomal.repairnomalcancel_check',[
            'inforepairnomaldetail' => $inforepairnomaldetail,
            'inforepairnomaldetailid' => $inforepairnomaldetailid,
       
          ]);
      
      }

      public function updaterepairnomalcancel(Request $request)
      {

   
               $ID = $request->ID;
   
               $addcancel= Informrepairindex::find($ID);
  
               $addcancel->REPAIR_STATUS = 'CANCEL';
               $addcancel->save();
   
   
  
  
              return redirect()->route('mrepairnomal.repairnomalinfo'); 
  
      }



       //============================================ลัดสถานนะดำเนินการสำเร็จ=================


       public function repairnomalsuccessnow($id)
       {
   
         $inforepairnomaldetail = Informrepairindex::where('informrepair_index.ID','=',$id)
         ->leftjoin('informrepair_priority','informrepair_priority.PRIORITY_ID','=','informrepair_index.PRIORITY_ID')
         ->leftjoin('hrd_person','informrepair_index.USER_REQUEST_ID','=','hrd_person.ID')
         ->leftjoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_SUB_ID')
         ->leftjoin('asset_building','informrepair_index.LOCATION_SEE_ID','=','asset_building.ID')
         ->leftjoin('supplies_location_level','informrepair_index.LOCATIONLEVEL_SEE_ID','=','supplies_location_level.LOCATION_LEVEL_ID')
         ->leftjoin('supplies_location_level_room','informrepair_index.LOCATIONLEVELROOM_SEE_ID','=','supplies_location_level_room.LEVEL_ROOM_ID')
         ->first(); 
   
         $inforepairnomaldetailid = Informrepairindex::where('informrepair_index.ID','=',$id)->first();
        
       
   
           return view('manager_repairnomal.repairnomalsuccessnow_check',[
             'inforepairnomaldetail' => $inforepairnomaldetail,
             'inforepairnomaldetailid' => $inforepairnomaldetailid,
        
           ]);
       
       }
 
       public function updaterepairnomalsuccessnow(Request $request)
       {
 
    
        $iduser = Auth::user()->PERSON_ID; 

        $inforpersonuser=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->where('hrd_person.ID','=',$iduser)->first();


                $ID = $request->ID;
                $addsuc = Informrepairindex::find($ID);
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
   
               return redirect()->route('mrepairnomal.repairnomalinfo'); 
   
       }


    //============================================ทะเบียนครุภัณฑ์=================


    public function repairnomalinfoasset()
    {

        $repairnomalinfoasset = DB::table('asset_article')
        
       ->get(); 
       

        $repairnomalinfoasset= Assetarticle::leftJoin('supplies_decline','supplies_decline.DECLINE_ID','=','asset_article.DECLINE_ID')
        ->leftJoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','asset_article.DEP_ID')
        ->leftJoin('supplies_location','supplies_location.LOCATION_ID','=','asset_article.LOCATION_ID')
        ->leftJoin('supplies_location_level','supplies_location_level.LOCATION_LEVEL_ID','=','asset_article.LOCATION_LEVEL_ID')
        ->leftJoin('supplies_location_level_room','supplies_location_level_room.LEVEL_ROOM_ID','=','asset_article.LEVEL_ROOM_ID')
        ->where('asset_article.DECLINE_ID','<>',17)
        ->where('asset_article.DECLINE_ID','<>',18)
        ->orderBy('ARTICLE_ID', 'desc')
        ->get();
        

        return view('manager_repairnomal.repairnomalinfoasset',[
            'repairnomalinfoassets' => $repairnomalinfoasset,
     
        ]);
    
    }

    public function detailrepairnomalasset(Request $request)
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
    
    
    
    

             $repairnomalinfoasset = DB::table('asset_article')
             ->leftJoin('supplies_location','supplies_location.LOCATION_ID','=','asset_article.LOCATION_ID')
             ->leftJoin('supplies_location_level','supplies_location_level.LOCATION_LEVEL_ID','=','asset_article.LOCATION_LEVEL_ID')
             ->leftJoin('supplies_location_level_room','supplies_location_level_room.LEVEL_ROOM_ID','=','asset_article.LEVEL_ROOM_ID')
             ->leftjoin('supplies_brand','asset_article.BRAND_ID','=','supplies_brand.BRAND_ID')
             ->leftjoin('asset_color','asset_article.COLOR_ID','=','asset_color.COLOR_ID')


             ->where('asset_article.ARTICLE_ID','=',$request->id)->first(); 
          
             

             
    
    $output='    
    
    <div class="row push" style="font-family: \'Kanit\', sans-serif;">
    
    <div class="col-sm-9">
    
      <div class="row">
          <div class="col-lg-2" align="right">
          <label>รหัส :</label>
          </div> 
          <div class="col-lg-4" align="left">
          '.$repairnomalinfoasset->ARTICLE_ID.'
          </div> 
          <div class="col-lg-2" align="right">
          <label>เลขครุภัณฑ์ :</label>
          </div> 
          <div class="col-lg-4" align="left">
          '.$repairnomalinfoasset->ARTICLE_NUM.'
          </div> 
      </div>    
      <div class="row">
          <div class="col-lg-2" align="right">
          <label>ครุภัณฑ์ :</label>
          </div> 
          <div class="col-lg-8" align="left">
          '.$repairnomalinfoasset->ARTICLE_NAME.'
          </div> 
       
      </div>    
      
      <div class="row">
      <div class="col-lg-2" align="right">
      <label>อาคาร :</label>
      </div> 
      <div class="col-lg-4" align="left">
      '.$repairnomalinfoasset->LOCATION_NAME.'
      </div>
          <div class="col-lg-1" align="right">
          <label>ชั้น :</label>
          </div> 
          <div class="col-lg-2" align="left">
          '.$repairnomalinfoasset->LOCATION_LEVEL_NAME.'
          </div> 
          <div class="col-lg-1" align="right">
          <label>ห้อง :</label>
          </div> 
          <div class="col-lg-2" align="left">
          '.$repairnomalinfoasset->LEVEL_ROOM_NAME.'
          </div> 
     
      </div>    
    
     
     <div class="row">
     <div class="col-lg-2" align="right">
     <label>โมเดล :</label>
     </div> 
     <div class="col-lg-4" align="left">
    '.$repairnomalinfoasset->MODEL_ID.'
     </div> 
     <div class="col-lg-2" align="right">
     <label>ขนาด :</label>
     </div> 
     <div class="col-lg-4" align="left">
     '.$repairnomalinfoasset->SIZE_ID.'
     </div> 
    </div>  


    <div class="row">
    <div class="col-lg-2" align="right">
    <label>ยี่ห้อ :</label>
    </div> 
    <div class="col-lg-4" align="left">
   '.$repairnomalinfoasset->BRAND_NAME.'
    </div> 
    <div class="col-lg-2" align="right">
    <label>สี :</label>
    </div> 
    <div class="col-lg-4" align="left">
    '.$repairnomalinfoasset->COLOR_NAME.'
    </div> 
   </div> 


   <div class="row">
   <div class="col-lg-2" align="right">
   <label>วันที่รับ :</label>
   </div> 
   <div class="col-lg-4" align="left">
  '.DateThai($repairnomalinfoasset->RECEIVE_DATE).'
   </div> 
   <div class="col-lg-2" align="right">
   <label>ราคา :</label>
   </div> 
   <div class="col-lg-4" align="left">
   '.$repairnomalinfoasset->PRICE_PER_UNIT.'
   </div> 
  </div> 
   
   
    
    <div class="row">
    <div class="col-lg-2" align="right">
    <label>รายละเอียด :</label>
    </div> 
    <div class="col-lg-10" align="left">
    '.$repairnomalinfoasset->ARTICLE_PROP.'
    </div> 
    
    </div>  
   
    
    </div>     
    
    
    

    <div class="col-sm-3">
    
    <div class="form-group">
    <img src="data:image/png;base64,'. chunk_split(base64_encode($repairnomalinfoasset->IMG)) .'" id="image_upload_preview" alt="กรุณาเพิ่มรูปภาพ" height="200" width="200"/>
   
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


             $repairnomalinfoasset = DB::table('asset_article')
             ->leftJoin('supplies_location','supplies_location.LOCATION_ID','=','asset_article.LOCATION_ID')
             ->leftJoin('supplies_location_level','supplies_location_level.LOCATION_LEVEL_ID','=','asset_article.LOCATION_LEVEL_ID')
             ->leftJoin('supplies_location_level_room','supplies_location_level_room.LEVEL_ROOM_ID','=','asset_article.LEVEL_ROOM_ID')
             ->leftjoin('supplies_brand','asset_article.BRAND_ID','=','supplies_brand.BRAND_ID')
             ->leftjoin('asset_color','asset_article.COLOR_ID','=','asset_color.COLOR_ID')
             ->leftjoin('supplies_model','asset_article.MODEL_ID','=','supplies_model.MODEL_ID')
             ->where('asset_article.ARTICLE_ID','=',$idasset)->first(); 


            $infohisrepair = Informrepairindex::where('informrepair_index.ARTICLE_ID','=',$repairnomalinfoasset->ARTICLE_ID)
            ->leftjoin('asset_article','asset_article.ARTICLE_ID','=','informrepair_index.ARTICLE_ID')
            ->orderBy('informrepair_index.ID', 'desc') 
            ->get();

            $detailplan = DB::table('asset_care_list')->where('ARTICLE_ID','=',$repairnomalinfoasset->ARTICLE_ID) ->orderBy('CARE_LIST_ID', 'desc') ->get();

            $planrepair = DB::table('informrepair_plan')->where('REPAIR_PLAN_ARTICLE_ID','=',$repairnomalinfoasset->ARTICLE_ID)->where('REPAIR_TYPE_CHECK','=','plan') ->orderBy('REPAIR_PLAN_ID', 'desc') ->get();

            $checkrepair = DB::table('informrepair_plan')->where('REPAIR_PLAN_ARTICLE_ID','=',$repairnomalinfoasset->ARTICLE_ID)->orderBy('REPAIR_PLAN_ID', 'desc') ->get();

            $leader = DB::table('gleave_leader')->get(); 
            
            return view('manager_repairnomal.repairnomalasset_repair',[
                'repairnomalinfoasset' => $repairnomalinfoasset,
                'infohisrepairs' => $infohisrepair,
                'detailplans' => $detailplan,
                'planrepairs' => $planrepair,
                'checkrepairs' => $checkrepair,
                'leaders' => $leader,
              
           
              ]);

        }
        public function repairnomalinfoassetsave_carelist(Request $request)
        {
     
                 $ARTICLE_ID = $request->PLAN_ARTICLE_ID;

                 $addcarelist= new Assetcarelist();
                 $addcarelist->ARTICLE_ID = $ARTICLE_ID;
                 $addcarelist->CARE_LIST_NAME = $request->CARE_LIST_NAME;
                 $addcarelist->save();
                 
                 return redirect()->route('mrepairnomal.repairinfoasset',['idasset'=> $ARTICLE_ID]); 
    
        }    
        
        
        public function repairinfoasset_edit(Request $request,$idasset,$id)
        {
            $repairnomalinfoasset = DB::table('asset_article')
            ->leftJoin('supplies_location','supplies_location.LOCATION_ID','=','asset_article.LOCATION_ID')
            ->leftJoin('supplies_location_level','supplies_location_level.LOCATION_LEVEL_ID','=','asset_article.LOCATION_LEVEL_ID')
            ->leftJoin('supplies_location_level_room','supplies_location_level_room.LEVEL_ROOM_ID','=','asset_article.LEVEL_ROOM_ID')
            ->leftjoin('supplies_brand','asset_article.BRAND_ID','=','supplies_brand.BRAND_ID')
            ->leftjoin('asset_color','asset_article.COLOR_ID','=','asset_color.COLOR_ID')
            ->leftjoin('supplies_model','asset_article.MODEL_ID','=','supplies_model.MODEL_ID')
            ->where('asset_article.ARTICLE_ID','=',$idasset)->first(); 

            $carelist = DB::table('asset_care_list')->where('ARTICLE_ID','=',$repairnomalinfoasset->ARTICLE_ID)->where('CARE_LIST_ID','=',$id)->first();

            return view('manager_repairnomal.repairnomalasset_repair');               
    
        }        

        public function repairnomalinfoassetupdate_carelist(Request $request)
        {
            $ARTICLE_ID = $request->PLAN_ARTICLE_ID;
            $LIST_ID = $request->CARE_LIST_ID;

            $update= Assetcarelist::find($LIST_ID);
            $update->ARTICLE_ID = $ARTICLE_ID;
            $update->CARE_LIST_NAME = $request->CARE_LIST_NAME;
            $update->save();            
            return redirect()->route('mrepairnomal.repairinfoasset',['idasset'=> $ARTICLE_ID]);     
        }


        public function repairnomalinfoassetdelete_carelist(Request $request,$idasset,$id)
        {
            $repairnomalinfoasset = DB::table('asset_article')
            ->leftJoin('supplies_location','supplies_location.LOCATION_ID','=','asset_article.LOCATION_ID')
            ->leftJoin('supplies_location_level','supplies_location_level.LOCATION_LEVEL_ID','=','asset_article.LOCATION_LEVEL_ID')
            ->leftJoin('supplies_location_level_room','supplies_location_level_room.LEVEL_ROOM_ID','=','asset_article.LEVEL_ROOM_ID')
            ->leftjoin('supplies_brand','asset_article.BRAND_ID','=','supplies_brand.BRAND_ID')
            ->leftjoin('asset_color','asset_article.COLOR_ID','=','asset_color.COLOR_ID')
            ->leftjoin('supplies_model','asset_article.MODEL_ID','=','supplies_model.MODEL_ID')
            ->where('asset_article.ARTICLE_ID','=',$idasset)->first(); 
           
            Assetcarelist::where('ARTICLE_ID','=',$repairnomalinfoasset->ARTICLE_ID)->where('CARE_LIST_ID','=',$id)->delete();  

            return redirect()->route('mrepairnomal.repairinfoasset',['idasset'=> $idasset]);     
        }


        public function savecheckrepairnomal(Request $request)
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
     
                 $addasset= new Informrepairplan();
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
     
                
                
                
                 $REPAIR_PLAN_ID = Informrepairplan::max('REPAIR_PLAN_ID');
             


                 if($request->REPAIR_PLAN_SUB_NAME != '' || $request->REPAIR_PLAN_SUB_NAME != null){
     
                     $REPAIR_PLAN_SUB_NAME = $request->REPAIR_PLAN_SUB_NAME;
                     $REPAIR_PLAN_SUB_REMARK = $request->REPAIR_PLAN_SUB_REMARK;
                     $REPAIR_PLAN_SUB_RESULT = $request->REPAIR_PLAN_SUB_RESULT;
                  
         
                     $number =count($REPAIR_PLAN_SUB_NAME);
                     $count = 0;
                     for($count = 0; $count< $number; $count++)
                     {  
                      
                        $add = new Informrepairplansub();
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
                     $upadtecheck = Informrepairplan::find($REPAIR_PLAN_ID); 
                     $upadtecheck->REPAIR_RESULT = 'ผิดปกติ';
                     $upadtecheck->save(); 
         
                 }else{
                    $upadtecheck = Informrepairplan::find($REPAIR_PLAN_ID); 
                    $upadtecheck->REPAIR_RESULT = 'ปกติ';
                    $upadtecheck->save(); 
                 }
    
    
    
                return redirect()->route('mrepairnomal.repairinfoasset',['idasset'=> $ARTICLE_ID]); 
    
        }




        public function checkrepairnomalall(Request $request)
        {
    
     
                 $ARTICLE_ID = $request->REPAIR_PLAN_ARTICLE_ID;
                 $REPAIR_ID = $request->REPAIR_PLAN_ARTICLE_NUM;
                 $REPAIR_PLAN_ID = $request->REPAIR_PLAN_ID;
                 
              
     
                 $addasset= Informrepairplan::find($REPAIR_PLAN_ID);
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
                    
                    Informrepairplansub::where('REPAIR_PLAN_ID','=',$REPAIR_PLAN_ID)->delete(); 

                     $REPAIR_PLAN_SUB_NAME = $request->REPAIR_PLAN_SUB_NAME;
                     $REPAIR_PLAN_SUB_REMARK = $request->REPAIR_PLAN_SUB_REMARK;
                     $REPAIR_PLAN_SUB_RESULT = $request->REPAIR_PLAN_SUB_RESULT;
                  
         
                     $number =count($REPAIR_PLAN_SUB_NAME);
                     $count = 0;
                     for($count = 0; $count< $number; $count++)
                     {           
                        $add = new Informrepairplansub();
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
                     $upadtecheck = Informrepairplan::find($REPAIR_PLAN_ID); 
                     $upadtecheck->REPAIR_RESULT = 'ผิดปกติ';
                     $upadtecheck->save(); 
         
                 }else{
                    $upadtecheck = Informrepairplan::find($REPAIR_PLAN_ID); 
                    $upadtecheck->REPAIR_RESULT = 'ปกติ';
                    $upadtecheck->save(); 
                 }
    
    
    
                return redirect()->route('mrepairnomal.repairinfoasset',['idasset'=> $ARTICLE_ID]); 
    
        }




      
        public function saveplanrepairnomal(Request $request)
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
     
                 $addasset= new Informrepairplan();
                 $addasset->REPAIR_PLAN_ARTICLE_ID = $ARTICLE_ID;
                 $addasset->REPAIR_PLAN_ARTICLE_NUM = $REPAIR_ID;
                 $addasset->REPAIR_PLAN_DATE = $REPAIR_PLAN_DATE;
                 $addasset->REPAIR_PLAN_BEGIN_TIME = $request->REPAIR_PLAN_BEGIN_TIME;
                 $addasset->REPAIR_PLAN_END_TIME = $request->REPAIR_PLAN_END_TIME;
                 $addasset->REPAIR_PLAN_REMARK = $request->REPAIR_PLAN_REMARK;
                
                 $addasset->save();
     
                 $REPAIR_PLAN_ID = Informrepairplan::max('REPAIR_PLAN_ID');
             
     
                 if($request->REPAIR_PLAN_SUB_NAME != '' || $request->REPAIR_PLAN_SUB_NAME != null){
     
                     $REPAIR_PLAN_SUB_NAME = $request->REPAIR_PLAN_SUB_NAME;
                     $REPAIR_PLAN_SUB_REMARK = $request->REPAIR_PLAN_SUB_REMARK;
                  
                  
         
                     $number =count($REPAIR_PLAN_SUB_NAME);
                     $count = 0;
                     for($count = 0; $count< $number; $count++)
                     {  
                      
                        $add = new Informrepairplansub();
                        $add->REPAIR_PLAN_ID = $REPAIR_PLAN_ID;
                    
                        $add->REPAIR_PLAN_SUB_NAME = $REPAIR_PLAN_SUB_NAME[$count];
                        $add->REPAIR_PLAN_SUB_REMARK = $REPAIR_PLAN_SUB_REMARK[$count];
                      
                        $add->save(); 
                      
              
                     }
                 }
     
     
    
    
    
                return redirect()->route('mrepairnomal.repairinfoasset',['idasset'=> $ARTICLE_ID]); 
    
        }


   //---------------------------ฟังชั่น------------------------------
   function checknomalrepair(Request $request)
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

   function pdf_normal(Request $request,$idref)
   {

    $infoorg = DB::table('info_org')->where('ORG_ID','=',1)
    ->first();

    $informrepairindex = Informrepairindex::where('informrepair_index.ID','=',$idref)
    ->leftJoin('asset_article','asset_article.ARTICLE_ID','=','informrepair_index.ARTICLE_ID')
    ->leftjoin('hrd_person','hrd_person.ID','=','informrepair_index.USER_REQUEST_ID')
    ->leftjoin('hrd_department_sub','hrd_department_sub.HR_DEPARTMENT_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_ID')
    ->leftjoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_SUB_ID')
    ->first();


        $imgRepair = DB::table('informrepair_index')->where('ID', '=', $idref)->first();
        
       $html = View('manager_repairnomal.pdf_normal',[
        'informrepairindex' => $informrepairindex, 
        'infoorg' => $infoorg, 
        'imgRepair' => $imgRepair


       ]);
       return viewpdf($html);
   

   }


             //-----------------------------ตั้งค่าระบบงานซ่อม


             public function setting_typesystem()
             {
                
                 $infosystemtype = Informrepairsystemtype::orderBy('INFORMRE_ST_ID', 'asc')  
                                                         ->get();
                                              
                
                 return view('manager_repairnomal.setupinformresystemtype',[
                     'infosystemtypes' => $infosystemtype
                 ]);
             }
             
             public function setting_typesystem_add(Request $request)
                 {
               
                     return view('manager_repairnomal.setupinformresystemtype_add');
             
                 }
             
                 public function setting_typesystem_save(Request $request)
                 {
                    
             
                         $addarticle = new Informrepairsystemtype(); 
                         $addarticle->INFORMRE_ST_NAME = $request->INFORMRE_ST_NAME;
                      
              
                         $addarticle->save();
             
             
                         return redirect()->route('mrepairnomal.setting_typesystem'); 
                 }
             
                 public function setting_typesystem_edit(Request $request,$id)
                 {
                   
                 
                    $id_in= $id;
                  
                    $infosystem = Informrepairsystemtype::where('INFORMRE_ST_ID','=',$id_in)
                    ->first();
             
             
             
                     return view('manager_repairnomal.setupinformresystemtype_edit',[
                     'infosystem' => $infosystem 
                     ]);
             
                 }
             
             
             
                 public function setting_typesystem_update(Request $request)
                 {
                     $id = $request->INFORMRE_ST_ID; 
             
                     $updatesystem = Informrepairsystemtype::find($id);
                     $updatesystem->INFORMRE_ST_NAME = $request->INFORMRE_ST_NAME;
                     $updatesystem->save();
             
             
                     return redirect()->route('mrepairnomal.setting_typesystem'); 
             
                 }
             
                 
                 public function setting_typesystem_delete($id) { 
             
                    Informrepairsystemtype::destroy($id);         
                     return redirect()->route('mrepairnomal.setting_typesystem');   
                 }
    


}
