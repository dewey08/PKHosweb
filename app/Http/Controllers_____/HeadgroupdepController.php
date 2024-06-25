<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Models\Person;
use App\Models\Recordorg;
use App\Models\Permislist;

use App\Models\Booksendcommandleader;
use App\Models\Booksendcommanddepart;
use App\Models\Booksendcommanddepartsub;
use App\Models\Booksendcommanddepartsubsub;
use App\Models\Booksendcommand;
use App\Models\Bookindexcommand;
use App\Models\Booksendcommandorg;




use App\Models\Leave_register;
use App\Models\LeaveStatus;

use App\Http\Controllers\Report\LeaveReportController;


use Session;

use App\Http\Controllers\Report\BookReportController;

date_default_timezone_set("Asia/Bangkok");

class HeadgroupdepController extends Controller
{
    public function dashboard()
    {
        $data['budgetyear'] = getBudgetYear();
            $data['budgetyear_dropdown'] = getBudgetYearAmount();
            if(!empty($_GET['budgetyear'])){
                $data['budgetyear'] = $_GET['budgetyear'];
            }
            $year = $data['budgetyear'];
            $year_ad = $year - 543;

            $leavereport = new LeaveReportController();
            $data['all_Leaveperson'] = $leavereport->countLeavePersonByyear_type($year_ad,'all');
            $data['sick_Leaveperson'] = $leavereport->countLeavePersonByyear_type($year_ad,1);
            $data['GiveBirth_Leaveperson'] = $leavereport->countLeavePersonByyear_type($year_ad,2);
            $data['ฺbusiness_Leaveperson'] = $leavereport->countLeavePersonByyear_type($year_ad,3);
            $data['rest_Leaveperson'] = $leavereport->countLeavePersonByyear_type($year_ad,4);
            $data['Ordain_Leaveperson'] = $leavereport->countLeavePersonByyear_type($year_ad,5);
            $data['Helpmywifegivebirth_Leaveperson'] = $leavereport->countLeavePersonByyear_type($year_ad,6);
            $data['Enlist_Leaveperson'] = $leavereport->countLeavePersonByyear_type($year_ad,7);
            $data['Student_Leaveperson'] = $leavereport->countLeavePersonByyear_type($year_ad,8);
            $data['Workabroad_Leaveperson'] = $leavereport->countLeavePersonByyear_type($year_ad,9);
            $data['Followthespouse_Leaveperson'] = $leavereport->countLeavePersonByyear_type($year_ad,10);
            $data['Careerrecovery_Leaveperson'] = $leavereport->countLeavePersonByyear_type($year_ad,11);
            $data['Resign_Leaveperson'] = $leavereport->countLeavePersonByyear_type($year_ad,12);
            $data['Legalsick_Leaveperson'] = $leavereport->countLeavePersonByyear_type($year_ad,13);
            
            $data['leaveperson'] = $leavereport->countLeavepersonByyear_M($year_ad);
            $data['sickLeaveperson'] = $leavereport->countLeavepersonByyear_type_M($year_ad,1); //ลาป่วย
            $data['businessLeaveperson'] = $leavereport->countLeavepersonByyear_type_M($year_ad,3); //ลากิจ
            $data['SummerLeaveperson'] = $leavereport->countLeavepersonByyear_type_M($year_ad,4); //ลาพักผ่อน
            $data['Leaveperson'] = $leavereport->groupcountLeavepersonAlltypeByyear_M($year_ad);

        return view('person_headgroupdep.dashboard_headgroupdep',$data);
    }


    




    public function headgroupdep_leave()
    {

        $iduser  = Auth::user()->PERSON_ID; 

        $inforpersonuserid =  Person::where('ID','=',$iduser)->first();

        $inforleave=  Leave_register::leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_ID')
        ->leftJoin('gleave_status','gleave_register.LEAVE_STATUS_CODE','=','gleave_status.STATUS_CODE')
        ->leftJoin('gleave_location','gleave_register.LOCATION_ID','=','gleave_location.LOCATION_ID')
        ->where('LEAVE_APP_H1','=','APP')
        ->where('LEADER_DEP_PERSON_ID','=',$iduser)
        ->where(function($q){
            $q->where('LEAVE_STATUS_CODE','=','Approve');

        })
       
        ->orderBy('gleave_register.ID', 'desc')
        ->get();


        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;
        }

        $infostatus =  LeaveStatus::get();
    

        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';
        $status = 'Approve';
        $search = '';
        $year_id = $yearbudget;




        return view('person_headgroupdep.headgroupdep_leave',[
            'inforpersonuserid' => $inforpersonuserid,
            'inforleaves' => $inforleave,
            'infostatuss'=>$infostatus,
            'displaydate_bigen'=> $displaydate_bigen, 
            'displaydate_end'=> $displaydate_end,
            'status_check' => $status,
            'search' => $search,    
            'budgets' =>  $budget,
            'year_id'=>$year_id 

        ]);
    }


    public function headgroupdep_leave_app(Request $request,$idref)
    {

        $iduser  = Auth::user()->PERSON_ID; 

        $inforpersonuserid =  Person::where('ID','=',$iduser)->first();
        
        $inforleave=  Leave_register::leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_ID')
        ->leftJoin('gleave_status','gleave_register.LEAVE_STATUS_CODE','=','gleave_status.STATUS_CODE')
        ->leftJoin('gleave_location','gleave_register.LOCATION_ID','=','gleave_location.LOCATION_ID')
        ->where('gleave_register.ID','=',$idref)
        ->first();


        return view('person_headgroupdep.headgroupdep_leave_app',[
            'inforpersonuserid' => $inforpersonuserid,
            'inforleave' => $inforleave,
        ]);
    }


    public function headgroupdep_leavesearch (Request $request)
    {
        $iduser  = Auth::user()->PERSON_ID; 

        $inforpersonuserid =  Person::where('ID','=',$iduser)->first();

        $search = $request->get('search');
        $status = $request->STATUS_CODE;
        $datebigin = $request->get('DATE_BIGIN');
        $dateend = $request->get('DATE_END');
        $yearbudget = $request->BUDGET_YEAR;

        if($search==''){
            $search="";
        }




        if( $datebigin != '' && $dateend != ''){

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
      
        $inforleave=  Leave_register::leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_ID')
        ->leftJoin('gleave_status','gleave_register.LEAVE_STATUS_CODE','=','gleave_status.STATUS_CODE')
        ->leftJoin('gleave_location','gleave_register.LOCATION_ID','=','gleave_location.LOCATION_ID')
        ->where('LEADER_PERSON_ID','=',$iduser)
        ->where(function($q) use ($search){
            $q->where('LEAVE_YEAR_ID','like','%'.$search.'%');
            $q->orwhere('LEAVE_PERSON_FULLNAME','like','%'.$search.'%');
            $q->orwhere('LEAVE_TYPE_NAME','like','%'.$search.'%');
            $q->orwhere('LEAVE_BECAUSE','like','%'.$search.'%');

        })
        ->WhereBetween('LEAVE_DATE_BEGIN',[$from,$to])
        ->orderBy('gleave_register.ID', 'desc')
        ->get();

    }else{

        if($status == 'APP'){

           
            $inforleave=  Leave_register::leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_ID')
            ->leftJoin('gleave_status','gleave_register.LEAVE_STATUS_CODE','=','gleave_status.STATUS_CODE')
            ->leftJoin('gleave_location','gleave_register.LOCATION_ID','=','gleave_location.LOCATION_ID')
            ->where('LEADER_PERSON_ID','=',$iduser)
            ->where(function($q){
                $q->where('LEAVE_STATUS_CODE','=','Pending');
                $q->orwhere('LEAVE_STATUS_CODE','=','Recancel');
    
            })
            ->where(function($q) use ($search){
                $q->where('LEAVE_YEAR_ID','like','%'.$search.'%');
                $q->orwhere('LEAVE_PERSON_FULLNAME','like','%'.$search.'%');
                $q->orwhere('LEAVE_TYPE_NAME','like','%'.$search.'%');
                $q->orwhere('LEAVE_BECAUSE','like','%'.$search.'%');
    
            })
            ->WhereBetween('LEAVE_DATE_BEGIN',[$from,$to])
            ->orderBy('gleave_register.ID', 'desc')
            ->get();

          

        }else{
    
        $inforleave=  Leave_register::leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_ID')
        ->leftJoin('gleave_status','gleave_register.LEAVE_STATUS_CODE','=','gleave_status.STATUS_CODE')
        ->leftJoin('gleave_location','gleave_register.LOCATION_ID','=','gleave_location.LOCATION_ID')
        ->where('LEADER_PERSON_ID','=',$iduser)
        ->where('LEAVE_STATUS_CODE','=',$status)
        ->where(function($q) use ($search){
            $q->where('LEAVE_YEAR_ID','like','%'.$search.'%');
            $q->orwhere('LEAVE_PERSON_FULLNAME','like','%'.$search.'%');
            $q->orwhere('LEAVE_TYPE_NAME','like','%'.$search.'%');
            $q->orwhere('LEAVE_BECAUSE','like','%'.$search.'%');

        })
        ->WhereBetween('LEAVE_DATE_BEGIN',[$from,$to])
        ->orderBy('gleave_register.ID', 'desc')
        ->get();

        }
    }




         }else{

        if($status == null){

            $inforleave=  Leave_register::leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_ID')
            ->leftJoin('gleave_status','gleave_register.LEAVE_STATUS_CODE','=','gleave_status.STATUS_CODE')
            ->leftJoin('gleave_location','gleave_register.LOCATION_ID','=','gleave_location.LOCATION_ID')
            ->where('LEADER_PERSON_ID','=',$iduser)
            ->where(function($q) use ($search){
                $q->where('LEAVE_YEAR_ID','like','%'.$search.'%');
                $q->orwhere('LEAVE_PERSON_FULLNAME','like','%'.$search.'%');
                $q->orwhere('LEAVE_TYPE_NAME','like','%'.$search.'%');
                $q->orwhere('LEAVE_BECAUSE','like','%'.$search.'%');
            })
            ->orderBy('gleave_register.ID', 'desc')
            ->get();
        }else{


            if($status == 'APP'){

                $inforleave=  Leave_register::leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_ID')
                ->leftJoin('gleave_status','gleave_register.LEAVE_STATUS_CODE','=','gleave_status.STATUS_CODE')
                ->leftJoin('gleave_location','gleave_register.LOCATION_ID','=','gleave_location.LOCATION_ID')
                ->where('LEADER_PERSON_ID','=',$iduser)
                ->where(function($q){
                    $q->where('LEAVE_STATUS_CODE','=','Pending');
                    $q->orwhere('LEAVE_STATUS_CODE','=','Recancel');
        
                })
                ->where(function($q) use ($search){
                    $q->where('LEAVE_YEAR_ID','like','%'.$search.'%');
                    $q->orwhere('LEAVE_PERSON_FULLNAME','like','%'.$search.'%');
                    $q->orwhere('LEAVE_TYPE_NAME','like','%'.$search.'%');
                    $q->orwhere('LEAVE_BECAUSE','like','%'.$search.'%');
                })
                ->orderBy('gleave_register.ID', 'desc')
                ->get();
    

            }else{
            $inforleave=  Leave_register::leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_ID')
            ->leftJoin('gleave_status','gleave_register.LEAVE_STATUS_CODE','=','gleave_status.STATUS_CODE')
            ->leftJoin('gleave_location','gleave_register.LOCATION_ID','=','gleave_location.LOCATION_ID')
            ->where('LEADER_PERSON_ID','=',$iduser)
            ->where('LEAVE_STATUS_CODE','=',$status)
            ->where(function($q) use ($search){
                $q->where('LEAVE_YEAR_ID','like','%'.$search.'%');
                $q->orwhere('LEAVE_PERSON_FULLNAME','like','%'.$search.'%');
                $q->orwhere('LEAVE_TYPE_NAME','like','%'.$search.'%');
                $q->orwhere('LEAVE_BECAUSE','like','%'.$search.'%');
            })
            ->orderBy('gleave_register.ID', 'desc')
            ->get();

             }

        }

        }



         $infostatus =  LeaveStatus::get();
         $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

         $year_id = $yearbudget;

        return view('person_headgroupdep.headgroupdep_leave',[
            'inforpersonuserid' => $inforpersonuserid,
            'inforleaves' => $inforleave,
            'infostatuss' => $infostatus,
            'displaydate_bigen'=> $displaydate_bigen, 
            'displaydate_end'=> $displaydate_end,
            'status_check' => $status,
            'search' => $search,
            'year_id'=>$year_id, 
            'budgets' =>  $budget,
        ]);

    }


    
//=====================================================

public function headgroupdep_calendarleave(Request $request)
{

    if(!empty($_GET['depid']) && !empty($_GET['depname']) ){
        $depid['id'] =  $_GET['depid'];
        $depname['name'] =  $_GET['depname'];
    }else{
      $depid['id'] =  'all';
      $depname['name'] =  'ทั้งหมด';
    }

    $iduser = Auth::user()->PERSON_ID;
    $inforpersonuserid =  Person::where('ID','=',$iduser)->first();
    $id = $inforpersonuserid->ID;


    $inforpersonuser=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->leftJoin('hrd_sex','hrd_person.SEX','=','hrd_sex.SEX_ID')
    ->leftJoin('hrd_status','hrd_person.HR_STATUS_ID','=','hrd_status.HR_STATUS_ID')
    ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
    ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
    ->leftJoin('hrd_department','hrd_person.HR_DEPARTMENT_ID','=','hrd_department.HR_DEPARTMENT_ID')
    ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
    ->leftJoin('hrd_bloodgroup','hrd_person.HR_BLOODGROUP_ID','=','hrd_bloodgroup.HR_BLOODGROUP_ID')
    ->leftJoin('hrd_marry_status','hrd_person.HR_MARRY_STATUS_ID','=','hrd_marry_status.HR_MARRY_STATUS_ID')
    ->leftJoin('hrd_religion','hrd_person.HR_RELIGION_ID','=','hrd_religion.HR_RELIGION_ID')
    ->leftJoin('hrd_nationality','hrd_person.HR_NATIONALITY_ID','=','hrd_nationality.HR_NATIONALITY_ID')
    ->leftJoin('hrd_citizenship','hrd_person.HR_CITIZENSHIP_ID','=','hrd_citizenship.HR_CITIZENSHIP_ID')
    ->leftJoin('hrd_tumbon','hrd_person.TUMBON_ID','=','hrd_tumbon.ID')
    ->leftJoin('hrd_amphur','hrd_person.AMPHUR_ID','=','hrd_amphur.ID')
    ->leftJoin('hrd_province','hrd_person.PROVINCE_ID','=','hrd_province.ID')
    ->leftJoin('hrd_kind','hrd_person.HR_KIND_ID','=','hrd_kind.HR_KIND_ID')
    ->leftJoin('hrd_kind_type','hrd_person.HR_KIND_TYPE_ID','=','hrd_kind_type.HR_KIND_TYPE_ID')
    ->leftJoin('hrd_person_type','hrd_person.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
    ->where('hrd_person.ID','=',$iduser)->first();


    $date01 = date('Y-m-d');
    $date02 = date('Y-m-d',time() + 86400);

    $infoleavetodate = DB::table('gleave_register')
    ->leftJoin('gleave_status','gleave_status.STATUS_CODE','=','gleave_register.LEAVE_STATUS_CODE')
    ->leftjoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_ID')
    ->where('LEAVE_DATE_BEGIN','=',$date01)->get();

    $infoleavetomorrow = DB::table('gleave_register')
    ->leftJoin('gleave_status','gleave_status.STATUS_CODE','=','gleave_register.LEAVE_STATUS_CODE')
    ->leftjoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_ID')
    ->where('LEAVE_DATE_BEGIN','=',$date02)->get();

    $data['depname'] = $depname;

    $depinfo = DB::table('hrd_department')->get();

    $inforleave =  Leave_register::where('LEAVE_STATUS_CODE','<>','Cancel');
    if($depid['id'] !== 'all'){
        $inforleave->where('LEAVE_DEPARTMENT_ID', $depid['id']);
    }
    $inforleave = $inforleave->orderBy('gleave_register.ID', 'desc') 
                ->get();


         $iduser  = Auth::user()->PERSON_ID; 

 
         $inforleavess =  Leave_register::leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_ID')
         ->leftJoin('gleave_status','gleave_register.LEAVE_STATUS_CODE','=','gleave_status.STATUS_CODE')
         ->leftJoin('gleave_location','gleave_register.LOCATION_ID','=','gleave_location.LOCATION_ID')
         ->where('LEAVE_APP_H1','=','APP')
         ->where('LEADER_DEP_PERSON_ID','=',$iduser)
         ->where(function($q){
             $q->where('LEAVE_STATUS_CODE','=','Approve');
 
         })
        
         ->orderBy('gleave_register.ID', 'desc')
         ->get();
         
         $m_budget = date("m");
         if($m_budget>9){
         $yearbudget = date("Y")+544;
         }else{
         $yearbudget = date("Y")+543;
         }
 
         $infostatus =  LeaveStatus::get();
     
 
         $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
         $displaydate_bigen = ($yearbudget-544).'-10-01';
         $displaydate_end = ($yearbudget-543).'-09-30';
         $status = 'Approve';
         $search = '';
         $year_id = $yearbudget;

        
    return view('person_headgroupdep.headgroupdep_calendarleave',$data,[
        'inforpersonuser' => $inforpersonuser,
        'inforpersonuserid' => $inforpersonuserid,
        'infopersonleaves' => $inforleave,
        'depinfos' => $depinfo,
        'infoleavetodates' => $infoleavetodate,
        'infoleavetomorrows' => $infoleavetomorrow,
        'iduser' => $iduser,
        'inforleaves' => $inforleave,
        'inforleavess' => $inforleavess,
        'status' => $status,


        
    ]);
}








public function headgroupdep_updateapp(Request $request)
{
    $id = $request->ID;
    $CHECK_TYPEAPP = $request->CHECK_TYPEAPP;

    $check =  $request->SUBMIT;

  if($CHECK_TYPEAPP == 'FORCANCEL'){

      if($check == 'approved'){
          $statuscode = 'Appcancel';
          $status_H2 = '';
          $detail ='';
        }else{
          $statuscode = 'Disappcancel';
          $status_H2 = '';
          $detail ='';
        }

  }else{

      if($check == 'approved'){
          $statuscode = 'ApproveGroup';
          $status_H2 = 'APP';
          $detail ='หน.กลุ่มเห็นชอบ';
        }else{
          $statuscode = 'DisapproveGroup';
          $status_H2 = 'NOTAPP';
          $detail = 'หน.กลุ่มไม่เห็นชอบ';
        }

  }
  
  date_default_timezone_set('Asia/Bangkok');


      $updateapp = Leave_register::find($id);
      $updateapp->ACCEPT_COMMENT = $request->COMMENT;
      $updateapp->LEAVE_STATUS_CODE = $statuscode;
      $updateapp->LEAVE_APP_H2 = $status_H2;
      $updateapp->LEAVE_POSITION_DATE = date('Y-m-d H:i:s');

      $updateapp->save();

      function DateThailinecar($strDate)
      {
        $strYear = date("Y",strtotime($strDate))+543;
        $strMonth= date("n",strtotime($strDate));
        $strDay= date("j",strtotime($strDate));

        $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
        $strMonthThai=$strMonthCut[$strMonth];
        return "$strDay $strMonthThai $strYear";
        }

      $header = "ข้อมูลการลา";
           
      $infoleave = Leave_register::where('ID','=',$id)->first();
      

      $leave_type = DB::table('gleave_type')->where('LEAVE_TYPE_ID','=',$infoleave->LEAVE_TYPE_CODE)->first(); 
      $hrd_department = DB::table('hrd_department')->where('HR_DEPARTMENT_ID','=',$infoleave->LEAVE_DEPARTMENT_ID)->first(); 
      
      $datebegin = DateThailinecar($infoleave->LEAVE_DATE_BEGIN); 
      $backtime = DateThailinecar($infoleave->LEAVE_DATE_END);


     $message = $header.
         "\n"."ประเภท : " . $leave_type->LEAVE_TYPE_NAME .
         "\n"."เหตุผล : " . $infoleave->LEAVE_BECAUSE .
         "\n"."ผู้ลา : " . $infoleave->LEAVE_PERSON_FULLNAME .
         "\n"."หน่วยงาน : " . $hrd_department->HR_DEPARTMENT_NAME  .
         "\n"."ผู้รับมอบ : " . $infoleave->LEAVE_WORK_SEND .
         "\n"."ตั้งแต่วันที่ : " . $datebegin .               
         "\n"."ถึงวันที่ : " . $backtime .    
         "\n"."จำนวน : " . $infoleave->WORK_DO ." วัน" .      
         "\n"."สถานะ :  ". $detail;  
         ///=====แจ้งกลุ่มผู้ตรวจสอบ

         $name2 = DB::table('line_token')->where('ID_LINE_TOKEN','=','8')->first();        
       

         if($name2 == null){
          $test2 ='';
        }else{
          $test2 =$name2->LINE_TOKEN;
        }

         if($test2 !== '' && $test2 !== null){
          $chOne2 = curl_init();
         curl_setopt( $chOne2, CURLOPT_URL, "https://notify-api.line.me/api/notify");
         curl_setopt( $chOne2, CURLOPT_SSL_VERIFYHOST, 0);
         curl_setopt( $chOne2, CURLOPT_SSL_VERIFYPEER, 0);
         curl_setopt( $chOne2, CURLOPT_POST, 1);
         curl_setopt( $chOne2, CURLOPT_POSTFIELDS, $message);
         curl_setopt( $chOne2, CURLOPT_POSTFIELDS, "message=$message");
         curl_setopt( $chOne2, CURLOPT_FOLLOWLOCATION, 1);
         $headers2 = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$test2.'', );
         curl_setopt($chOne2, CURLOPT_HTTPHEADER, $headers2);
         curl_setopt( $chOne2, CURLOPT_RETURNTRANSFER, 1);
         $result2 = curl_exec( $chOne2 );
         if(curl_error($chOne2)) { echo 'error:' . curl_error($chOne2); }
         else { $result_ = json_decode($result2, true);
         echo "status : ".$result_['status']; echo "message : ". $result_['message']; }
         curl_close( $chOne2 );
         }

      
      
          return redirect()->route('hgroupdep.headgroupdep_leave');

}


public static function countinfoleave()
{
    $iduser  = Auth::user()->PERSON_ID; 

     $count=  Leave_register::leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_ID')
     ->leftJoin('gleave_status','gleave_register.LEAVE_STATUS_CODE','=','gleave_status.STATUS_CODE')
     ->leftJoin('gleave_location','gleave_register.LOCATION_ID','=','gleave_location.LOCATION_ID')
     ->where('LEAVE_APP_H1','=','APP')
     ->where('LEADER_DEP_PERSON_ID','=',$iduser)
     ->where(function($q){
         $q->where('LEAVE_STATUS_CODE','=','Approve');

     })
    
     ->orderBy('gleave_register.ID', 'desc')
     ->count();

   return $count;
}



public function updateappgroupall(Request $request)
{


      $iduser  = Auth::user()->PERSON_ID; 
      $statuscode = 'ApproveGroup';
      $status_H2 = 'APP';
  
            
      $inforleavess =  Leave_register::leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_ID')
      ->leftJoin('gleave_status','gleave_register.LEAVE_STATUS_CODE','=','gleave_status.STATUS_CODE')
      ->leftJoin('gleave_location','gleave_register.LOCATION_ID','=','gleave_location.LOCATION_ID')
      ->where('LEAVE_APP_H1','=','APP')
      ->where('LEADER_DEP_PERSON_ID','=',$iduser)
      ->where(function($q){
          $q->where('LEAVE_STATUS_CODE','=','Approve');

      })
     
      ->orderBy('gleave_register.ID', 'desc')
      ->get();

      foreach ($inforleavess as $inforleaves) {

        $updateapp = Leave_register::find($inforleaves->ID);
        $updateapp->LEAVE_STATUS_CODE = $statuscode;
        $updateapp->LEAVE_APP_H2 = $status_H2;
        $updateapp->LEAVE_POSITION_DATE = date('Y-m-d H:i:s');
        $updateapp->save();
  
    }
      

        return redirect()->route('hgroupdep.headgroupdep_leave');

}

    

}

