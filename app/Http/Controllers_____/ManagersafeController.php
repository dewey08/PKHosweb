<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Person;
use App\Models\Safeservice;
use App\Models\Official;
use App\Http\Controllers\Report\SafeReportController;



date_default_timezone_set("Asia/Bangkok");

class ManagersafeController extends Controller
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
        
        $safereport = new SafeReportController();
        $eventsafe = $safereport->getCountEventSafeByyear($year_ad);
        $typesafe = $safereport->getCountTypeSafeByyear($year_ad);
        $lacatoinsafe = $safereport->getCountLocationSafeByyear($year_ad);
        $data['safeall'] = $safereport->getCountAllSafeByyear_M($year_ad);

        $data['eventsafe'][] = array('เหตุการณ์','จำนวนเหตุการณ์');
        foreach ($eventsafe as $row){
            $data['eventsafe'][] = array($row['name'],$row['count']);
        }
        $data['typesafe'][] = array('ประเภทรายงาน','จำนวนประเภทรายงาน');
        foreach ($typesafe as $row){
            $data['typesafe'][] = array($row['name'],$row['count']);
        }
        $data['lacatoinsafe'][] = array('สถานที่เกิดเหตุ','จำนวนที่เกิดเหตุ');
        foreach ($lacatoinsafe as $row){
            $data['lacatoinsafe'][] = array($row['name'],$row['count']);
        }
        return view('manager_safe.dashboard_safe',$data);
    }
    public function dashboardsearch(Request $request)
    {
        $year_id = $request->STATUS_CODE;
    

        $displaydate_bigen = ($year_id-544).'-10-01';
        $displaydate_end = ($year_id-543).'-09-30';


        $event_1 = DB::table('safe_event')->where('SAFE_EVENT_ID','=',1)->count();
        $event_2 = DB::table('safe_event')->where('SAFE_EVENT_ID','=',2)->count();
        $event_3 = DB::table('safe_event')->where('SAFE_EVENT_ID','=',3)->count();
        $event_4 = DB::table('safe_event')->where('SAFE_EVENT_ID','=',4)->count();
        $event_5 = DB::table('safe_event')->where('SAFE_EVENT_ID','=',5)->count();
        $event_grap = DB::table('safe_service')
                      ->select(DB::raw('count(*) as event_count,SAFE_EVENT_NAME'),'SAFE_EVENT_NAME')
                      ->leftJoin('safe_event','safe_service.SAFE_EVENT_ID','=','safe_event.SAFE_EVENT_ID')
                      ->WhereBetween('SAFE_DATE',[$displaydate_bigen,$displaydate_end]) 
                      ->groupBy('SAFE_EVENT_NAME')
                      ->get();


        $type_1 = DB::table('safe_type')->where('SAFE_TYPE_ID','=',1)->count();
        $type_2 = DB::table('safe_type')->where('SAFE_TYPE_ID','=',2)->count();
        $type_3 = DB::table('safe_type')->where('SAFE_TYPE_ID','=',3)->count();
        $type_4 = DB::table('safe_type')->where('SAFE_TYPE_ID','=',4)->count();
        $type_5 = DB::table('safe_type')->where('SAFE_TYPE_ID','=',5)->count();
        $type_piechart = DB::table('safe_service')
                    ->select(DB::raw('count(*) as type_count,SAFE_TYPE_NAME'),'SAFE_TYPE_NAME')
                    ->leftJoin('safe_type','safe_service.SAFE_TYPE_ID','=','safe_type.SAFE_TYPE_ID')
                    ->WhereBetween('SAFE_DATE',[$displaydate_bigen,$displaydate_end]) 
                    ->groupBy('SAFE_TYPE_NAME')
                    ->get();


        $location_1 = DB::table('safe_location')->where('SAFE_LOCATION_ID','=',1)->count();
        $location_2 = DB::table('safe_location')->where('SAFE_LOCATION_ID','=',2)->count();
        $location_3 = DB::table('safe_location')->where('SAFE_LOCATION_ID','=',3)->count();
        $location_4 = DB::table('safe_location')->where('SAFE_LOCATION_ID','=',4)->count();
        $location_5 = DB::table('safe_location')->where('SAFE_LOCATION_ID','=',5)->count();
        $location_6 = DB::table('safe_location')->where('SAFE_LOCATION_ID','=',6)->count();
        $location_7 = DB::table('safe_location')->where('SAFE_LOCATION_ID','=',7)->count();
        $location_8 = DB::table('safe_location')->where('SAFE_LOCATION_ID','=',8)->count();
        $location_9 = DB::table('safe_location')->where('SAFE_LOCATION_ID','=',9)->count();

        $location_piechart = DB::table('safe_service')
                      ->select(DB::raw('count(*) as location_count,SAFE_LOCATION_NAME'),'SAFE_LOCATION_NAME')
                      ->leftJoin('safe_location','safe_service.SAFE_LOCATION_ID','=','safe_location.SAFE_LOCATION_ID')
                      ->WhereBetween('SAFE_DATE',[$displaydate_bigen,$displaydate_end]) 
                      ->groupBy('SAFE_LOCATION_NAME')
                      ->get();


        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
   
    
        return view('manager_safe.dashboard_safe',[
            'event1' => $event_1,
            'event2' => $event_2,
            'event3' => $event_3,
            'event4' => $event_4,
            'event5' => $event_5,
            'eventgrap' => $event_grap,
            'type1' => $type_1,
            'type2' => $type_2,
            'type3' => $type_3,
            'type4' => $type_4,
            'type5' => $type_5,
            'typepiechart' => $type_piechart,            
            'location1' => $location_1,
            'location2' => $location_2,
            'location3' => $location_3,
            'location4' => $location_4,
            'location5' => $location_5,
            'location6' => $location_6,
            'location7' => $location_7,
            'location8' => $location_8,
            'location9' => $location_9,
            'locationpiechart' => $location_piechart,
            'budgets' =>  $budget,
            'year_id'=>$year_id 

        ]);


    }
  
    public function infosafe(Request $request)
    { 
        if(!empty($request->_token)){
            $search = $request->get('search');
            $status = $request->SEND_STATUS;
            $datebigin = $request->get('DATE_BIGIN');
            $dateend = $request->get('DATE_END');
            $yearbudget = $request->BUDGET_YEAR;
            session([
                'manager_safe.infosafe.search' => $search,
                'manager_safe.infosafe.status' => $status,
                'manager_safe.infosafe.datebigin' => $datebigin,
                'manager_safe.infosafe.dateend' => $dateend,
                'manager_safe.infosafe.yearbudget' => $yearbudget
                ]);
        }elseif(!empty(session('manager_safe.infosafe'))){
            $search     = session('manager_safe.infosafe.search');
            $status     = session('manager_safe.infosafe.status');
            $datebigin  = session('manager_safe.infosafe.datebigin');
            $dateend    = session('manager_safe.infosafe.dateend');
            $yearbudget = session('manager_safe.infosafe.yearbudget');
        }else{
            $search     = '';
            $status     = '';
            $datebigin = date('1/m/Y');
            $dateend   = date('d/m/Y', strtotime(date('Y-m-1'). '+1month -1days'));
            $yearbudget = getBudgetyear();
        }

        $iduser = Auth::user()->PERSON_ID;       
        $personuser = DB::table('hrd_person') ->leftjoin('safe_service','hrd_person.ID','=','safe_service.RECORD_HR_ID')
        ->where('hrd_person.ID','=',$iduser)->first();

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
        $date_bigen_checks = strtotime($displaydate_bigen);
        $date_end_checks =  strtotime($displaydate_end);
        $dates =  strtotime($date);
            $from = date($displaydate_bigen);
            $to = date($displaydate_end);
            if($status == null){
                $safeservice = DB::table('safe_service')->leftJoin('safe_type','safe_service.SAFE_TYPE_ID','=','safe_type.SAFE_TYPE_ID')
                ->leftJoin('safe_event','safe_service.SAFE_EVENT_ID','=','safe_event.SAFE_EVENT_ID')
                ->leftJoin('safe_location','safe_service.SAFE_LOCATION_ID','=','safe_location.SAFE_LOCATION_ID')
                 ->leftJoin('hrd_person','safe_service.RECORD_HR_ID','=','hrd_person.ID') 
                ->where(function($q) use ($search){                   
                    $q->where('SAFE_LOCATION_NAME','like','%'.$search.'%');  
                    $q->orwhere('RECORD_HR_NAME','like','%'.$search.'%');
                    $q->orwhere('HR_FNAME','like','%'.$search.'%');
                    $q->orwhere('SAFE_ITEM','like','%'.$search.'%');
                    $q->orwhere('SAFE_DAMAGE','like','%'.$search.'%');
                    $q->orwhere('SAFE_COMMENT','like','%'.$search.'%');
                    $q->orwhere('SAFE_MODIFY','like','%'.$search.'%');
                    $q->orwhere('SAFE_EVENT_NAME','like','%'.$search.'%');
                })
                ->WhereBetween('SAFE_DATE',[$from,$to]) 
                ->orderby('SAFE_ID','desc')         
                ->get();               
        }else{            
            $safeservice = DB::table('safe_service')->leftJoin('safe_type','safe_service.SAFE_TYPE_ID','=','safe_type.SAFE_TYPE_ID')
            ->leftJoin('safe_event','safe_service.SAFE_EVENT_ID','=','safe_event.SAFE_EVENT_ID')
            ->leftJoin('safe_location','safe_service.SAFE_LOCATION_ID','=','safe_location.SAFE_LOCATION_ID')
            ->leftJoin('hrd_person','safe_service.RECORD_HR_ID','=','hrd_person.ID') 
            ->where('safe_service.SAFE_TYPE_ID','=',$status)
            ->where(function($q) use ($search){
                $q->where('SAFE_LOCATION_NAME','like','%'.$search.'%');  
                $q->orwhere('RECORD_HR_NAME','like','%'.$search.'%');
                $q->orwhere('HR_FNAME','like','%'.$search.'%');

                $q->orwhere('SAFE_ITEM','like','%'.$search.'%');
                $q->orwhere('SAFE_DAMAGE','like','%'.$search.'%');
                $q->orwhere('SAFE_COMMENT','like','%'.$search.'%');
                $q->orwhere('SAFE_MODIFY','like','%'.$search.'%');
                $q->orwhere('SAFE_EVENT_NAME','like','%'.$search.'%');
            })
            ->WhereBetween('SAFE_DATE',[$from,$to]) 
            ->orderby('SAFE_ID','desc')         
            ->get();
            }
            $typename =  DB::table('safe_type')->get();
            $safeevent =  DB::table('safe_event')->get();        
            $safelocation = DB::table('safe_location')->get();
            $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
            $year_id = $yearbudget;
        return view('manager_safe.infosafe',[
            'safe' => $safeservice,
            'typenameT' => $typename,
            'status_check' => $status,
            'search' => $search,
            'personuser' => $personuser,
            'safeevent' => $safeevent,
            'safelocation' => $safelocation,
            'displaydate_bigen'=> $displaydate_bigen, 
            'displaydate_end'=> $displaydate_end,
            'budgets' =>  $budget,
            'year_id'=>$year_id, 
       ]);
    }
 
    public function infosafesearch(Request $request)
    { 
        $search = $request->get('search');
        $status = $request->SEND_STATUS;
        $datebigin = $request->get('DATE_BIGIN');
        $dateend = $request->get('DATE_END');
        $yearbudget = $request->BUDGET_YEAR;

        $iduser = Auth::user()->PERSON_ID;       
        $personuser = DB::table('hrd_person') ->leftjoin('safe_service','hrd_person.ID','=','safe_service.RECORD_HR_ID')
        ->where('hrd_person.ID','=',$iduser)->first();

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
        $date_bigen_checks = strtotime($displaydate_bigen);
        $date_end_checks =  strtotime($displaydate_end);
        $dates =  strtotime($date);
            $from = date($displaydate_bigen);
            $to = date($displaydate_end);
            if($status == null){

                $safeservice = DB::table('safe_service')->leftJoin('safe_type','safe_service.SAFE_TYPE_ID','=','safe_type.SAFE_TYPE_ID')
                ->leftJoin('safe_event','safe_service.SAFE_EVENT_ID','=','safe_event.SAFE_EVENT_ID')
                ->leftJoin('safe_location','safe_service.SAFE_LOCATION_ID','=','safe_location.SAFE_LOCATION_ID')
                 ->leftJoin('hrd_person','safe_service.RECORD_HR_ID','=','hrd_person.ID') 
                ->where(function($q) use ($search){                   
                    $q->where('SAFE_LOCATION_NAME','like','%'.$search.'%');  
                    $q->orwhere('RECORD_HR_NAME','like','%'.$search.'%');
                    $q->orwhere('HR_FNAME','like','%'.$search.'%');

                    $q->orwhere('SAFE_ITEM','like','%'.$search.'%');
                    $q->orwhere('SAFE_DAMAGE','like','%'.$search.'%');
                    $q->orwhere('SAFE_COMMENT','like','%'.$search.'%');
                    $q->orwhere('SAFE_MODIFY','like','%'.$search.'%');
                    $q->orwhere('SAFE_EVENT_NAME','like','%'.$search.'%');

                })
                ->WhereBetween('SAFE_DATE',[$from,$to]) 
                ->orderby('SAFE_ID','desc')         
                ->get();               
               
             
                       
        }else{            
          
            $safeservice = DB::table('safe_service')->leftJoin('safe_type','safe_service.SAFE_TYPE_ID','=','safe_type.SAFE_TYPE_ID')
            ->leftJoin('safe_event','safe_service.SAFE_EVENT_ID','=','safe_event.SAFE_EVENT_ID')
            ->leftJoin('safe_location','safe_service.SAFE_LOCATION_ID','=','safe_location.SAFE_LOCATION_ID')
            ->leftJoin('hrd_person','safe_service.RECORD_HR_ID','=','hrd_person.ID') 
            ->where('safe_service.SAFE_TYPE_ID','=',$status)
            ->where(function($q) use ($search){
                $q->where('SAFE_LOCATION_NAME','like','%'.$search.'%');  
                $q->orwhere('RECORD_HR_NAME','like','%'.$search.'%');
                $q->orwhere('HR_FNAME','like','%'.$search.'%');

                $q->orwhere('SAFE_ITEM','like','%'.$search.'%');
                $q->orwhere('SAFE_DAMAGE','like','%'.$search.'%');
                $q->orwhere('SAFE_COMMENT','like','%'.$search.'%');
                $q->orwhere('SAFE_MODIFY','like','%'.$search.'%');
                $q->orwhere('SAFE_EVENT_NAME','like','%'.$search.'%');
            })
            ->WhereBetween('SAFE_DATE',[$from,$to]) 
            ->orderby('SAFE_ID','desc')         
            ->get();
            }
            $typename =  DB::table('safe_type')->get();
            $safeevent =  DB::table('safe_event')->get();        
            $safelocation = DB::table('safe_location')->get();
       
            $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
            $year_id = $yearbudget;
        return view('manager_safe.infosafe',[
            'safe' => $safeservice,
            'typenameT' => $typename,
            'status_check' => $status,
            'search' => $search,
            'personuser' => $personuser,
            'safeevent' => $safeevent,
            'safelocation' => $safelocation,
            'displaydate_bigen'=> $displaydate_bigen, 
            'displaydate_end'=> $displaydate_end,
            'budgets' =>  $budget,
            'year_id'=>$year_id, 
       ]);
      
    }

      /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request)
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

        // dd($request->SAFE_DATE);
        $checkstart= $request->SAFE_DATE;
        if($checkstart != ''){           
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $checkstart)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0];             
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $displaystartdate= $y_st."-".$m_st."-".$d_st;   
            }else{
            $displaystartdate= null;
        }            
             $addinfosafe = new Safeservice();   
             $addinfosafe->SAFE_DATE = $displaystartdate;           
             $addinfosafe->SAFE_TYPE_ID = $request->SAFE_TYPE_ID;
             $addinfosafe->SAFE_ITEM = $request->SAFE_ITEM;
             $addinfosafe->SAFE_TIME = $request->SAFE_TIME; 
             $addinfosafe->SAFE_DAMAGE = $request->SAFE_DAMAGE;
             $addinfosafe->SAFE_EVENT_ID = $request->SAFE_EVENT_ID;
             $addinfosafe->SAFE_COMMENT = $request->SAFE_COMMENT;
             $addinfosafe->SAFE_LOCATION_ID = $request->SAFE_LOCATION_ID;
             $addinfosafe->SAFE_MODIFY = $request->SAFE_MODIFY;
             $addinfosafe->RECORD_HR_ID = $request->RECORD_HR_ID; 
             $addinfosafe->RECORD_HR_NAME = $request->RECORD_HR_NAME;
             $addinfosafe->RECORD_HR_TEL = $request->RECORD_HR_TEL;       
             $addinfosafe->RECORD_DATE = $displaystartdate;               
             $addinfosafe->save();


             $header = "เหตุการณ์ รปภ.";
           
             $SAFE_ITEM = $request->SAFE_ITEM; 
 
              $date = DateThai($displaystartdate).' '.date("H:i",strtotime("$request->SAFE_TIME")); 
                         
             
              $location = $request->SAFE_LOCATION_ID;          
              $RECORD_HR_ID = $request->RECORD_HR_ID; 
              $SAFE_COMMENT = $request->SAFE_COMMENT;  
              $SAFE_EVENT_ID = $request->SAFE_EVENT_ID;  
              $SAFE_TIME = $request->SAFE_TIME; 
              $RECORD_HR_TEL = $request->RECORD_HR_TEL;  

              $infoperson = DB::table('hrd_person')->where('ID','=',$RECORD_HR_ID)->first();
             
              $infolocation = DB::table('safe_location')->where('SAFE_LOCATION_ID','=',$location)->first();
              
         
             $message = $header.
               
                 "\n"."หัวข้อการรายงาน : " . $SAFE_ITEM .
                 "\n"."วันที่พบ : " . $date .   
                 "\n"."สถานที่พบ : " .$infolocation->SAFE_LOCATION_NAME.               
                 "\n"."ผู้แจ้ง: " .$infoperson->HR_FNAME.' '.$infoperson->HR_LNAME.
                 "\n"."ติดต่อ: " .$RECORD_HR_TEL;
         
                     $name = DB::table('line_token')->where('ID_LINE_TOKEN','=',7)->first();        
                     $test =$name->LINE_TOKEN;
         
                     $chOne = curl_init();
                     curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
                     curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0);
                     curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0);
                     curl_setopt( $chOne, CURLOPT_POST, 1);
                     curl_setopt( $chOne, CURLOPT_POSTFIELDS, $message);
                     curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=$message");
                     curl_setopt( $chOne, CURLOPT_FOLLOWLOCATION, 1);
                     $headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$test.'', );
                     curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
                     curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1);
                     $result = curl_exec( $chOne );
                     if(curl_error($chOne)) { echo 'error:' . curl_error($chOne); }
                     else { $result_ = json_decode($result, true);
                     echo "status : ".$result_['status']; echo "message : ". $result_['message']; }
                     curl_close( $chOne );
 
             


        return redirect()->route('msafe.infosafe'); 

    

    }

    public function update(Request $request)
    {
        $checkstart= $request->SAFE_DATE;
        if($checkstart != ''){           
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $checkstart)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0];             
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $displaystartdate= $y_st."-".$m_st."-".$d_st;   
            }else{
            $displaystartdate= null;
        } 
                             
        $id = $request->SAFE_ID;
        $updatesafeservice = Safeservice::find($id);  
        
        $updatesafeservice->SAFE_DATE = $displaystartdate;
        $updatesafeservice->SAFE_TYPE_ID = $request->SAFE_TYPE_ID; 
        $updatesafeservice->SAFE_ITEM = $request->SAFE_ITEM;
        $updatesafeservice->SAFE_TIME = $request->SAFE_TIME; 
        $updatesafeservice->SAFE_DAMAGE = $request->SAFE_DAMAGE;
        $updatesafeservice->SAFE_EVENT_ID = $request->SAFE_EVENT_ID;
        $updatesafeservice->SAFE_COMMENT = $request->SAFE_COMMENT;        
        $updatesafeservice->SAFE_LOCATION_ID = $request->SAFE_LOCATION_ID;
        $updatesafeservice->SAFE_MODIFY = $request->SAFE_MODIFY;
        $updatesafeservice->RECORD_HR_NAME = $request->RECORD_HR_NAME;
        $updatesafeservice->RECORD_HR_TEL = $request->RECORD_HR_TEL;
        $updatesafeservice->RECORD_DATE = $displaystartdate;

        

        $updatesafeservice->save();
        return redirect()->route('msafe.infosafe'); 
    }

    public function destroyinfosafe($id) { 
        Safeservice::destroy($id); 
        return redirect()->route('msafe.infosafe');   
    }


      
    public function infocarperson(Request $request)
    { 

        if(!empty($request->_token)){
            $search = $request->get('search');
            session([
                'manager_safe.infocarperson.search' => $search   
                ]);
        }elseif(!empty(session('manager_safe.infocarperson'))){
            $search     = session('manager_safe.infocarperson.search');
        }else{
            $search     = '';
        }



        $infocar = Official::leftjoin('hrd_person','hrd_person.ID','=','hrd_tr_official_card.PERSON_ID')
        ->leftjoin('hrd_status','hrd_person.HR_STATUS_ID','=','hrd_status.HR_STATUS_ID')
        ->leftjoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->where(function($q) use ($search){
            $q->where('HR_LNAME','like','%'.$search.'%');  
            $q->orwhere('HR_FNAME','like','%'.$search.'%');
            $q->orwhere('POSITION_IN_WORK','like','%'.$search.'%');
            $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');
            $q->orwhere('HR_PHONE','like','%'.$search.'%');
            $q->orwhere('HR_STATUS_NAME','like','%'.$search.'%');
            $q->orwhere('COMMENT','like','%'.$search.'%');
            $q->orwhere('CARD_CODE','like','%'.$search.'%');
        })
        
        ->orderBy('hrd_tr_official_card.ID', 'desc')  
        ->get();

        return view('manager_safe.infocarperson',[
            'search' => $search,
            'infocars' => $infocar
        ]);
    }

}
