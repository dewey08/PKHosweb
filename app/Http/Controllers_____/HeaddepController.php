<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Bookindex;
use App\Models\Bookindexout;
use App\Models\Bookindexsendleader;
use App\Models\Booksend;
use App\Models\Booksendsub;
use App\Models\Booksendsubsub;
use App\Models\Booksendperson;
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

//------------หนังสือส่ง--------------------------
use App\Models\Booksendinsideleader;
use App\Models\Booksendinsidedepart;
use App\Models\Booksendinsidedepartsub;
use App\Models\Booksendinsidedepartsubsub;
use App\Models\Booksendinside;
use App\Models\Bookindexinside;
use App\Models\Booksendinsideorg;
//------------------------------------------

use App\Models\Booksendannounceleader;
use App\Models\Booksendannouncedepart;
use App\Models\Booksendannouncedepartsub;
use App\Models\Booksendannouncedepartsubsub;
use App\Models\Booksendannounce;
use App\Models\Bookindexannounce;


use App\Models\Leave_register;
use App\Models\LeaveStatus;
use App\Models\Recordindex;
use App\Models\Vehiclecarreserve;

use App\Models\Suppliesrequest;

use App\Models\Meetingroomindex;
use App\Models\Meetingroomservice;

//-------------------------------------
use App\Models\Infoworkcorresult;
use App\Models\Infoworkcorresultsub;

use App\Models\Infoworkfunresult;
use App\Models\Infoworkfunresultsub;
use App\Models\Warehouserequest;
use App\Http\Controllers\Report\LeaveReportController;
use App\Http\Controllers\Web_meta_data_Controller;
use Session;

use App\Http\Controllers\Report\BookReportController;

date_default_timezone_set("Asia/Bangkok");

class HeaddepController extends Controller
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

        return view('person_headdep.dashboard_headdep',$data);
    }


    public function headdep_book()
    {
        $iduser  = Auth::user()->PERSON_ID; 
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
            
        $inforbook = Booksendperson::leftJoin('gbook_index','gbook_index.BOOK_ID','=','gbook_send_person.BOOK_ID')
            ->where('BOOK_USE','=','true')
            ->where('READ_STATUS','=','False')
            ->where('gbook_send_person.HR_PERSON_ID','=',$iduser )
            ->orderBy('ID', 'desc') 
            ->get();
          
            $infobookstatus1 = DB::table('gbook_status')
            ->where('BOOK_STATUS_ID','=','1')
            ->first();
            $infobookstatus2 = DB::table('gbook_status')
            ->where('BOOK_STATUS_ID','=','2')
            ->first();
            $infobookstatus3 = DB::table('gbook_status')
            ->where('BOOK_STATUS_ID','=','3')
            ->first();

            $infobook_sendstatus = DB::table('gbook_status')
            ->get();

            $yearbudget = date("Y")+543;
            

            $displaydate_bigen = ($yearbudget-543).'-01-01';
            $displaydate_end = ($yearbudget-543).'-12-31';
            $status = '';
            $search = '';
            $year_id = $yearbudget;

           
            
            $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
            

        return view('person_headdep.headdep_book',[
            'inforpersonuser' => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid, 
            'infobookstatus1'=> $infobookstatus1, 
            'infobookstatus2'=> $infobookstatus2,
            'infobookstatus3'=> $infobookstatus3,
            'inforbooks' =>$inforbook,
            'infobook_sendstatuss'=>   $infobook_sendstatus,
            'displaydate_bigen'=> $displaydate_bigen, 
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'budgets' =>  $budget,
            'year_id'=>$year_id 
            
        ]);


    }

    public function headdep_booksearch(Request $request)
    {
        $iduser  = Auth::user()->PERSON_ID; 
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



        $search = $request->get('search');
        $status = $request->SEND_STATUS;
        $datebigin = $request->get('DATE_BIGIN');
        $dateend = $request->get('DATE_END');
        $yearbudget = $request->BUDGET_YEAR;

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


                $inforbook = Booksendperson::leftJoin('gbook_index','gbook_index.BOOK_ID','=','gbook_send_person.BOOK_ID')
                ->leftJoin('grecord_org','gbook_index.BOOK_ORG_ID','=','grecord_org.RECORD_ORG_ID')
                ->leftJoin('hrd_person','gbook_index.PERSON_SAVE_ID','=','hrd_person.ID')
                ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                ->leftJoin('gbook_index_send_leader','gbook_index.BOOK_ID','=','gbook_index_send_leader.BOOK_LD_ID')
                ->where('BOOK_USE','=','true')
                ->where('gbook_send_person.HR_PERSON_ID','=',$iduser )
                ->where(function($q) use ($search){
                    $q->where('BOOK_NUM_IN','like','%'.$search.'%');
                    $q->orwhere('BOOK_NUMBER','like','%'.$search.'%');
                    $q->orwhere('BOOK_NAME','like','%'.$search.'%');
                    $q->orwhere('BOOK_DETAIL','like','%'.$search.'%');
                    })
                 ->WhereBetween('DATE_SAVE',[$from,$to]) 
                 ->orderBy('gbook_send_person.ID', 'desc') 
                 ->get();


            }else{

                $inforbook = Booksendperson::leftJoin('gbook_index','gbook_index.BOOK_ID','=','gbook_send_person.BOOK_ID')
                ->leftJoin('grecord_org','gbook_index.BOOK_ORG_ID','=','grecord_org.RECORD_ORG_ID')
                ->leftJoin('hrd_person','gbook_index.PERSON_SAVE_ID','=','hrd_person.ID')
                ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                ->leftJoin('gbook_index_send_leader','gbook_index.BOOK_ID','=','gbook_index_send_leader.BOOK_LD_ID')
                ->where('BOOK_USE','=','true')
                ->where('gbook_send_person.HR_PERSON_ID','=',$iduser )
                ->where('SEND_STATUS','=',$status)
                ->where(function($q) use ($search){
                    $q->where('BOOK_NUM_IN','like','%'.$search.'%');
                    $q->orwhere('BOOK_NUMBER','like','%'.$search.'%');
                    $q->orwhere('BOOK_NAME','like','%'.$search.'%');
                    $q->orwhere('BOOK_DETAIL','like','%'.$search.'%');
                    })
                 ->WhereBetween('DATE_SAVE',[$from,$to]) 
                 ->orderBy('gbook_send_person.ID', 'desc') 
                 ->get();


            }
    

      

                
      

        $infobooksend = DB::table('hrd_person')
        ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->where('hrd_person.ID','=',$iduser)
        ->first();

        $infobookstatus1 = DB::table('gbook_status')
        ->where('BOOK_STATUS_ID','=','1')
        ->first();
        $infobookstatus2 = DB::table('gbook_status')
        ->where('BOOK_STATUS_ID','=','2')
        ->first();
        $infobookstatus3 = DB::table('gbook_status')
        ->where('BOOK_STATUS_ID','=','3')
        ->first();
      
        $infobook_sendstatus = DB::table('gbook_status')
        ->get();
  
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
    $year_id = $yearbudget;

        return view('person_headdep.headdep_book',[
            'inforpersonuser' => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid, 
            'infobookstatus1'=> $infobookstatus1, 
            'infobookstatus2'=> $infobookstatus2,
            'infobookstatus3'=> $infobookstatus3,
            'inforbooks' =>$inforbook,
            'infobook_sendstatuss'=>   $infobook_sendstatus,
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id, 
                
        ]);


    }



    
     //---------------จัดการหนังสือ

     public function infobookreceiptcontrol(Request $request,$id)
     {
        $iduser  = Auth::user()->PERSON_ID; 

       $infobooksend = DB::table('hrd_person')
       ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
       ->where('hrd_person.ID','=',$iduser)
       ->first();

        $idbook = $id;
 
         $infobookreceiptview = Bookindex::leftJoin('grecord_org','gbook_index.BOOK_ORG_ID','=','grecord_org.RECORD_ORG_ID')
         ->leftJoin('hrd_person','gbook_index.PERSON_SAVE_ID','=','hrd_person.ID')
         ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
         ->leftJoin('gbook_index_send_leader','gbook_index.BOOK_ID','=','gbook_index_send_leader.BOOK_LD_ID')
         ->leftJoin('gbook_instant','gbook_index.BOOK_URGENT_ID','=','gbook_instant.INSTANT_ID')
         ->where('gbook_index.BOOK_ID','=',$idbook)
         ->first();
         
         $bookdepartment = DB::table('hrd_department')->get();
         $bookdepartmentsub  = DB::table('hrd_department_sub')->get();
         $bookdepartmentsubsub  = DB::table('hrd_department_sub_sub')->get();


         //-----------ความเห็น-----------------
         $checksendleader = DB::table('gbook_index_send_leader')
         ->where('BOOK_LD_ID','=',$idbook)
         ->count(); 

         if($checksendleader !== 0 ){
           $sendleaderquery  = DB::table('gbook_index_send_leader')
           ->where('BOOK_LD_ID','=',$idbook)
           ->first();
           
           $sendleader = $sendleaderquery->TOP_LEADER_AC_CMD;


           $sendleaderdetailid = $sendleaderquery->SEND_LD_BY_HR_ID;
           $sendleaderdetail = $sendleaderquery->SEND_LD_DETAIL;
           $sendleaderhrname = $sendleaderquery->SEND_LD_BY_HR_NAME;
           $sendleaderdetailid2 = $sendleaderquery->SEND_LD_BY_HR_ID_2;
           $sendleaderdetail2 = $sendleaderquery->SEND_LD_DETAIL_2;
           $sendleaderhrname2 = $sendleaderquery->SEND_LD_BY_HR_NAME_2;


         }else{
           $sendleader = '';
           
           $sendleaderdetailid = '';
           $sendleaderdetail = '';
           $sendleaderhrname = '';
           $sendleaderdetailid2 = '';
           $sendleaderdetail2 = '';
           $sendleaderhrname2 = '';
         }
          //----------------------------

          $booksend = DB::table('gbook_send')->where('BOOK_ID','=',$idbook)->get();
          $booksendsub = DB::table('gbook_send_sub')->where('BOOK_ID','=',$idbook)->get();
          $booksendsubsub = DB::table('gbook_send_sub_sub')->where('BOOK_ID','=',$idbook)->get();
      
             //--------------------------------------------
             $infordepartment  =  DB::table('hrd_department')->get();

             $inforsenddepartments =  DB::table('gbook_send')
             ->where('BOOK_ID','=',$idbook)
             ->get(); 
  
             $checksendinfordepartment = DB::table('gbook_send')
             ->where('BOOK_ID','=',$idbook)
             ->count(); 
  
              //--------------------------------------------

                //--------------------------------------------
             $infordepartmentsub  =  DB::table('hrd_department_sub')->get();

             $inforsenddepartmentsubs =  DB::table('gbook_send_sub')
             ->where('BOOK_ID','=',$idbook)
             ->get(); 
  
             $checksendinfordepartmentsub = DB::table('gbook_send_sub')
             ->where('BOOK_ID','=',$idbook)
             ->count(); 
  
              //--------------------------------------------

                             //--------------------------------------------
             $infordepartmentsubsub  =  DB::table('hrd_department_sub_sub')->get();

             $inforsenddepartmentsubsubs =  DB::table('gbook_send_sub_sub')
             ->where('BOOK_ID','=',$idbook)
             ->get(); 
  
             $checksendinfordepartmentsubsub = DB::table('gbook_send_sub_sub')
             ->where('BOOK_ID','=',$idbook)
             ->count(); 
  
              //--------------------------------------------
          //--------------------------------------------
          $inforposition  =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')->get();

          $infosendbooks =  DB::table('gbook_send_person')
          ->where('BOOK_ID','=',$idbook)
          ->where('SEND_TYPE','=','4')
          ->get(); 

          $checksendbookper = DB::table('gbook_send_person')
          ->where('BOOK_ID','=',$idbook)
          ->where('SEND_TYPE','=','4')
         ->count(); 

           //--------------------------------------------

         return view('person_headdep.headdep_book_control',[
             'infobookreceiptview' =>$infobookreceiptview,
             'idbook' => $idbook,
             'infobooksend' => $infobooksend,
             'bookdepartments'=>$bookdepartment, 
             'bookdepartmentsubs'=>$bookdepartmentsub,
             'bookdepartmentsubsubs'=>$bookdepartmentsubsub,
             'sendleader' => $sendleader,
             'sendleaderdetail' => $sendleaderdetail,
             'sendleaderhrname' => $sendleaderhrname,
             'sendleaderdetail2' => $sendleaderdetail2,
             'sendleaderhrname2' => $sendleaderhrname2,
             'booksends' => $booksend,
             'booksendsubs' => $booksendsub,
             'booksendsubsubs' => $booksendsubsub,
             'checksendleader'=>$checksendleader,
             'iduser' => $iduser,
             'sendleaderdetailid' => $sendleaderdetailid,
             'sendleaderdetailid2' => $sendleaderdetailid2,
             'inforpositions' => $inforposition,
             'checksendbookper' => $checksendbookper,
             'infosendbooks' => $infosendbooks,
             'infordepartments' => $infordepartment,
             'checksendinfordepartment' => $checksendinfordepartment,
             'inforsenddepartments' => $inforsenddepartments,
             'infordepartmentsubs' => $infordepartmentsub,
             'checksendinfordepartmentsub' => $checksendinfordepartmentsub,
             'inforsenddepartmentsubs' => $inforsenddepartmentsubs,
             'infordepartmentsubsubs' => $infordepartmentsubsub,
             'checksendinfordepartmentsubsub' => $checksendinfordepartmentsubsub,
             'inforsenddepartmentsubsubs' => $inforsenddepartmentsubsubs
      
            ]);
     }


     public function sendreceipt(Request $request)
     {
      
         $bookid = $request->BOOK_ID;
         $SEND_BY_ID = $request->SEND_BY_ID;
         $SEND_BY_NAME = $request->SEND_BY_NAME;
 
         Booksend::where('BOOK_ID','=',$bookid)->delete(); 
         Booksendsub::where('BOOK_ID','=',$bookid)->delete();
         Booksendsubsub::where('BOOK_ID','=',$bookid)->delete();  
 
     if($request->row3 != '' || $request->row3 != null){
         $row3 = $request->row3;
         $number_3 =count($row3);
         $count_3 = 0;
         for($count_3 = 0; $count_3 < $number_3; $count_3++)
         {  
          
            $add_3 = new Booksend();
            $add_3->BOOK_ID = $bookid;
            $add_3->HR_DEPARTMENT_ID = $row3[$count_3];
            $add_3->save(); 
          
            $inforpersonusers =  Person::where('HR_DEPARTMENT_ID','=',$row3[$count_3])->get(); 
 
            foreach($inforpersonusers as $inforpersonuser){
                   
             $check3 = DB::table('gbook_send_person')
             ->where('BOOK_ID','=',$bookid)
             ->where('HR_PERSON_ID','=',$inforpersonuser->ID)
             ->count(); 
 
             if($check3== 0){
                     $add_person3 = new Booksendperson();
                     $add_person3->BOOK_ID = $bookid;
                     $add_person3->HR_PERSON_ID = $inforpersonuser->ID;
                     $add_person3->READ_STATUS = 'False';
                     $add_person3->SEND_BY_ID = $SEND_BY_ID;
                     $add_person3->SEND_BY_NAME = $SEND_BY_NAME;
                     $add_person3->SEND_DATE_TIME = date('Y-m-d H:i:s');
                     $add_person3->SEND_TYPE = '1';
                     $add_person3->save();
             }
            }
  
 
         }
     }
 
     if($request->row4 != '' || $request->row4 != null){
 
         $row4 = $request->row4;
         $number_4 =count($row4);
         $count_4 = 0;
         for($count_4 = 0; $count_4 < $number_4; $count_4++)
         {  
 
        
            $add_4 = new Booksendsub();
            $add_4->BOOK_ID = $bookid;
            $add_4->HR_DEPARTMENT_SUB_ID = $row4[$count_4];
            $add_4->save(); 
 
            //------เช็คตัวซ้ำก่อน------
 
            $inforpersonusers_4 =  Person::where('HR_DEPARTMENT_SUB_ID','=',$row4[$count_4])->get(); 
 
            foreach($inforpersonusers_4 as $inforpersonuser_4){
                    
                  $check4 = DB::table('gbook_send_person')
                  ->where('BOOK_ID','=',$bookid)
                  ->where('HR_PERSON_ID','=',$inforpersonuser_4->ID)
                  ->count(); 
                   
                 
                 if($check4== 0){
                     $add_person4 = new Booksendperson();
                     $add_person4->BOOK_ID = $bookid;
                     $add_person4->HR_PERSON_ID = $inforpersonuser_4->ID;
                     $add_person4->READ_STATUS = 'False';
                     $add_person4->SEND_BY_ID = $SEND_BY_ID;
                     $add_person4->SEND_BY_NAME = $SEND_BY_NAME;
                     $add_person4->SEND_DATE_TIME = date('Y-m-d H:i:s');
                     $add_person4->SEND_TYPE = '2';
                    $add_person4->save();
                 }
            }
 
         }
     }
 
     if($request->row5 != '' || $request->row5 != null){
         $row5 = $request->row5;
         $number_5 =count($row5);
         $count_5 = 0;
         for($count_5 = 0; $count_5 < $number_5; $count_5++)
         {  
         
            $add_5 = new Booksendsubsub();
            $add_5->BOOK_ID = $bookid;
            $add_5->HR_DEPARTMENT_SUB_SUB_ID = $row5[$count_5];
            $add_5->save(); 
 
             //------เช็คตัวซ้ำก่อน------
 
             $inforpersonusers_5 =  Person::where('HR_DEPARTMENT_SUB_SUB_ID','=',$row5[$count_5])->get(); 
 
             foreach($inforpersonusers_5 as $inforpersonuser_5){
                     
                   $check5 = DB::table('gbook_send_person')
                   ->where('BOOK_ID','=',$bookid)
                   ->where('HR_PERSON_ID','=',$inforpersonuser_5->ID)
                   ->count(); 
                    
                  
                  if($check5== 0){
                      $add_person5 = new Booksendperson();
                      $add_person5->BOOK_ID = $bookid;
                      $add_person5->HR_PERSON_ID = $inforpersonuser_5->ID;
                      $add_person5->READ_STATUS = 'False';
                      $add_person5->SEND_BY_ID = $SEND_BY_ID;
                      $add_person5->SEND_BY_NAME = $SEND_BY_NAME;
                      $add_person5->SEND_DATE_TIME = date('Y-m-d H:i:s');
                      $add_person5->SEND_TYPE = '3';
                     $add_person5->save();
                  }
             }
 
             
 
         }
     }
     
     if($request->MEMBER_ID != '' || $request->MEMBER_ID != null){
 
     $MEMBER_ID = $request->MEMBER_ID;
     $number =count($MEMBER_ID);
     $count = 0;
     for($count = 0; $count < $number; $count++)
     {  
 
         $check6 = DB::table('gbook_send_person')
         ->where('BOOK_ID','=',$bookid)
         ->where('HR_PERSON_ID','=',$MEMBER_ID[$count])
         ->count(); 
          
        
        if($check6== 0){
 
         $add_person6 = new Booksendperson();
         $add_person6->BOOK_ID = $bookid;
         $add_person6->HR_PERSON_ID = $MEMBER_ID[$count];
         $add_person6->READ_STATUS = 'False';
         $add_person6->SEND_BY_ID = $SEND_BY_ID;
         $add_person6->SEND_BY_NAME = $SEND_BY_NAME;
         $add_person6->SEND_DATE_TIME = date('Y-m-d H:i:s');
         $add_person6->SEND_TYPE = '4';
         $add_person6->save();
 
        }
 
 
     }
 
    }
 
         return redirect()->route('hdep.headdep_book');
     }


    public function headdep_leave()
    {

        $iduser  = Auth::user()->PERSON_ID; 

        $inforpersonuserid =  Person::where('ID','=',$iduser)->first();

        $inforleave=  Leave_register::leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_ID')
        ->leftJoin('gleave_status','gleave_register.LEAVE_STATUS_CODE','=','gleave_status.STATUS_CODE')
        ->leftJoin('gleave_location','gleave_register.LOCATION_ID','=','gleave_location.LOCATION_ID')
        ->where('LEADER_PERSON_ID','=',$iduser)
        ->where(function($q){
            $q->where('LEAVE_STATUS_CODE','=','Pending');

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
        $status = 'Pending';
        $search = '';
        $year_id = $yearbudget;




        return view('person_headdep.headdep_leave',[
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


    

    public function headdep_leave_app(Request $request,$idref)
    {

        $iduser  = Auth::user()->PERSON_ID; 

        $inforpersonuserid =  Person::where('ID','=',$iduser)->first();

        $inforleave=  Leave_register::leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_ID')
        ->leftJoin('gleave_status','gleave_register.LEAVE_STATUS_CODE','=','gleave_status.STATUS_CODE')
        ->leftJoin('gleave_location','gleave_register.LOCATION_ID','=','gleave_location.LOCATION_ID')
        ->where('gleave_register.ID','=',$idref)  
        ->first();


        return view('person_headdep.headdep_leave_app',[
            'inforpersonuserid' => $inforpersonuserid,
            'inforleave' => $inforleave,
        ]);
    }



    public function headdep_leavesearch(Request $request)
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

        return view('person_headdep.headdep_leave',[
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


    

  public function headdep_updateapp(Request $request)
  {
      $id = $request->ID;
      $CHECK_TYPEAPP = $request->CHECK_TYPEAPP;

      $check =  $request->SUBMIT;
    if($CHECK_TYPEAPP == 'FORCANCEL'){

        if($check == 'approved'){
            $statuscode = 'Appcancel';
            $detail ='เห็นชอบยกเลิก';
            $status_H1 = 'APP';
          }else{
            $statuscode = 'Disappcancel';
            $detail ='ไม่เห็นชอบยกเลิก';
            $status_H1 = 'NOTAPP';
          }

    }else{

        if($check == 'approved'){
            $statuscode = 'Approve';
            $detail ='เห็นชอบ';
            $status_H1 = 'APP';
          }else{
            $statuscode = 'Disapprove';
            $detail ='ไม่เห็นชอบ';
            $status_H1 = 'NOTAPP';
          }

    }
    
    date_default_timezone_set('Asia/Bangkok');


        $updateapp = Leave_register::find($id);
        $updateapp->ACCEPT_COMMENT = $request->COMMENT;
        $updateapp->LEAVE_STATUS_CODE = $statuscode;
        $updateapp->LEAVE_APP_H1 = $status_H1;
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


          $countperson = DB::table('gleave_permis_level')->where('PERSON_ID','=',$infoleave->LEAVE_PERSON_ID)->count();

        if($countperson > 0){
         $checkuaerlevel = '1';
        }else{
         $checkuaerlevel = '2';
        } 

        if( $checkuaerlevel == '2'){


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

        }

        
            return redirect()->route('hdep.headdep_leave');

  }


  
  public function headdep_leave_report()
  {


    $m_budget = date("m");
    if($m_budget>9){
    $yearbudget = date("Y")+544;
    }else{
    $yearbudget = date("Y")+543;
    }  



    $iduser  = Auth::user()->PERSON_ID; 
       
    $person = DB::table('gleave_leader_person')
    ->leftjoin('hrd_person','hrd_person.ID','=','gleave_leader_person.PERSON_ID')
    ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->leftjoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
    ->leftjoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')  
    ->where('LEADER_ID','=',$iduser)
    ->where('hrd_person.HR_STATUS_ID','=',1)
    ->orderBy('hrd_person.HR_FNAME', 'asc') 
    ->get();


        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
      
        $displaydate_bigen = date('Y-m-d');
        $displaydate_end = date('Y-m-d');
        $search = '';
        $year_id =  $yearbudget;



      return view('person_headdep.headdep_leave_report',[
        'persons' => $person, 
        'budgetyears' =>  $budget,
        'displaydate_bigen'=> $displaydate_bigen,
        'displaydate_end'=> $displaydate_end,
        'search'=> $search,
        'year_id'=>$year_id 
      ]);
  }


  public function headdep_leave_reportsearch(Request $request)
  {

    $iduser  = Auth::user()->PERSON_ID; 

    $search = $request->get('search');
    $yearbudget = $request->BUDGET_YEAR;
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
  

    

    $person =  DB::table('gleave_leader_person')
    ->leftjoin('hrd_person','hrd_person.ID','=','gleave_leader_person.PERSON_ID')
    ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->leftjoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
    ->leftjoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
    ->where(function($q) use ($search){
        $q->where('HR_CID','like','%'.$search.'%');
        $q->orwhere('HR_PREFIX_NAME','like','%'.$search.'%');
        $q->orwhere('HR_FNAME','like','%'.$search.'%');
        $q->orwhere('HR_LNAME','like','%'.$search.'%');
        $q->orwhere('POSITION_IN_WORK','like','%'.$search.'%');
        $q->orwhere('HR_DEPARTMENT_SUB_NAME','like','%'.$search.'%');
  

    })
    ->where('LEADER_ID','=',$iduser)
    ->where('hrd_person.HR_STATUS_ID','=',1)
    ->orderBy('hrd_person.HR_FNAME', 'asc') 
    ->get();

        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $year_id =  $yearbudget;

       
      return view('person_headdep.headdep_leave_report',[
        'persons' => $person, 
        'budgetyears' =>  $budget,
        'displaydate_bigen'=> $displaydate_bigen,
        'displaydate_end'=> $displaydate_end,
        'search'=> $search,
        'year_id'=>$year_id 
      ]);
  

  }




    public function headdep_persondev()
    {
        $iduser  = Auth::user()->PERSON_ID; 

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

    
        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;
        }

        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        $inforrecordindex =  Recordindex::select('grecord_index.ID','grecord_index.STATUS','STATUS_NAME','RECORD_TYPE_NAME','grecord_index.RECORD_TYPE_ID','USER_POST_NAME','RECORD_HEAD_USE','LOCATION_ORG_NAME'
        ,'RECORD_LEVEL_NAME','RECORD_ORGANIZER_NAME','gleave_location.LOCATION_NAME','DATE_GO','DATE_BACK','RECORD_COMMENT','RECORD_GO_NAME','RECORD_VEHICLE_NAME','WITHDRAW_NAME'
        ,'LEADER_HR_NAME','OFFER_WORK_HR_NAME','SAVE_BACK','RECORD_USER_ID','POSITION_IN_WORK','HR_DEPARTMENT_SUB_NAME')
        ->leftJoin('hrd_person','grecord_index.RECORD_USER_ID','=','hrd_person.ID')
        ->leftJoin('hrd_department_sub','hrd_department_sub.HR_DEPARTMENT_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_ID')
        ->leftJoin('grecord_status','grecord_index.STATUS','=','grecord_status.STATUS')
        ->leftJoin('grecord_type','grecord_index.RECORD_TYPE_ID','=','grecord_type.RECORD_TYPE_ID')
        ->leftJoin('grecord_org_location','grecord_org_location.LOCATION_ID','=','grecord_index.RECORD_LOCATION_ID')
        ->leftJoin('grecord_level','grecord_level.ID','=','grecord_index.RECORD_LEVEL_ID')
        ->leftJoin('gleave_location','gleave_location.LOCATION_ID','=','grecord_index.LOCATION_PROV_ID')
        ->leftJoin('grecord_go','grecord_go.RECORD_GO_ID','=','grecord_index.RECORD_GO_ID')
        ->leftJoin('grecord_vehicle','grecord_vehicle.RECORD_VEHICLE_ID','=','grecord_index.RECORD_VEHICLE_ID')
        ->leftJoin('grecord_withdraw','grecord_withdraw.WITHDRAW_ID','=','grecord_index.RECORD_MONEY_ID')
        ->where('grecord_index.STATUS','=','APPLY')
        ->orderBy('grecord_index.ID', 'desc')  
        ->get();

        $grecordstatus = DB::table('grecord_status')->get();

        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';
        $status = '1';
        $search = '';
        $year_id = $yearbudget;
       
        return view('person_headdep.headdep_persondev',[
            'budgets' =>  $budget,   
            'inforpersonuserid' => $inforpersonuserid,
            'inforpersonuser' => $inforpersonuser,
            'inforrecordindexs' => $inforrecordindex,
            'grecordstatuss' => $grecordstatus,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id, 
        ]);
    }


    

    public function headdep_persondev_app(Request $request,$idref)
    {
        $iduser  = Auth::user()->PERSON_ID;
        $inforpersonuserid =  Person::where('ID','=',$iduser)->first();

        $inforrecordindex =  Recordindex::select('grecord_index.ID','grecord_index.STATUS','STATUS_NAME','RECORD_TYPE_NAME','grecord_index.RECORD_TYPE_ID','USER_POST_NAME','RECORD_HEAD_USE','LOCATION_ORG_NAME'
        ,'RECORD_LEVEL_NAME','RECORD_ORGANIZER_NAME','gleave_location.LOCATION_NAME','DATE_GO','DATE_BACK','RECORD_COMMENT','RECORD_GO_NAME','RECORD_VEHICLE_NAME','WITHDRAW_NAME'
        ,'LEADER_HR_NAME','OFFER_WORK_HR_NAME','SAVE_BACK','RECORD_USER_ID','POSITION_IN_WORK','HR_DEPARTMENT_SUB_NAME')
        ->leftJoin('hrd_person','grecord_index.RECORD_USER_ID','=','hrd_person.ID')
        ->leftJoin('hrd_department_sub','hrd_department_sub.HR_DEPARTMENT_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_ID')
        ->leftJoin('grecord_status','grecord_index.STATUS','=','grecord_status.STATUS')
        ->leftJoin('grecord_type','grecord_index.RECORD_TYPE_ID','=','grecord_type.RECORD_TYPE_ID')
        ->leftJoin('grecord_org_location','grecord_org_location.LOCATION_ID','=','grecord_index.RECORD_LOCATION_ID')
        ->leftJoin('grecord_level','grecord_level.ID','=','grecord_index.RECORD_LEVEL_ID')
        ->leftJoin('gleave_location','gleave_location.LOCATION_ID','=','grecord_index.LOCATION_PROV_ID')
        ->leftJoin('grecord_go','grecord_go.RECORD_GO_ID','=','grecord_index.RECORD_GO_ID')
        ->leftJoin('grecord_vehicle','grecord_vehicle.RECORD_VEHICLE_ID','=','grecord_index.RECORD_VEHICLE_ID')
        ->leftJoin('grecord_withdraw','grecord_withdraw.WITHDRAW_ID','=','grecord_index.RECORD_MONEY_ID')
        ->where('grecord_index.ID','=',$idref)
        ->first();

     
       
        return view('person_headdep.headdep_persondev_app',[
            'inforpersonuserid' => $inforpersonuserid,
            'inforrecordindex' => $inforrecordindex,
         
           
        ]);
    }




    public function headdep_persondev_search(Request $request)
{      
    $iduser  = Auth::user()->PERSON_ID; 

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
            $inforrecordindex =  Recordindex::select('grecord_index.ID','grecord_index.STATUS','STATUS_NAME','RECORD_TYPE_NAME','grecord_index.RECORD_TYPE_ID','USER_POST_NAME','RECORD_HEAD_USE','LOCATION_ORG_NAME'
            ,'RECORD_LEVEL_NAME','RECORD_ORGANIZER_NAME','gleave_location.LOCATION_NAME','DATE_GO','DATE_BACK','RECORD_COMMENT','RECORD_GO_NAME','RECORD_VEHICLE_NAME','WITHDRAW_NAME'
            ,'LEADER_HR_NAME','OFFER_WORK_HR_NAME','SAVE_BACK','RECORD_USER_ID','POSITION_IN_WORK','LOCATION_ORG_NAME')
                ->leftJoin('hrd_person','grecord_index.RECORD_USER_ID','=','hrd_person.ID')
                ->leftJoin('hrd_department_sub','hrd_department_sub.HR_DEPARTMENT_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_ID')
                ->leftJoin('grecord_status','grecord_index.STATUS','=','grecord_status.STATUS')
                ->leftJoin('grecord_type','grecord_index.RECORD_TYPE_ID','=','grecord_type.RECORD_TYPE_ID')
                ->leftJoin('grecord_org_location','grecord_org_location.LOCATION_ID','=','grecord_index.RECORD_LOCATION_ID')
                ->leftJoin('grecord_level','grecord_level.ID','=','grecord_index.RECORD_LEVEL_ID')
                ->leftJoin('gleave_location','gleave_location.LOCATION_ID','=','grecord_index.LOCATION_PROV_ID')
                ->leftJoin('grecord_go','grecord_go.RECORD_GO_ID','=','grecord_index.RECORD_GO_ID')
                ->leftJoin('grecord_vehicle','grecord_vehicle.RECORD_VEHICLE_ID','=','grecord_index.RECORD_VEHICLE_ID')
                ->leftJoin('grecord_withdraw','grecord_withdraw.WITHDRAW_ID','=','grecord_index.RECORD_MONEY_ID')
                        ->where(function($q) use ($search){
                            $q->where('grecord_index.ID','like','%'.$search.'%');
                            $q->orwhere('USER_POST_NAME','like','%'.$search.'%');  
                            $q->orwhere('RECORD_TYPE_NAME','like','%'.$search.'%');
                            $q->orwhere('RECORD_HEAD_USE','like','%'.$search.'%');    
                            $q->orwhere('LOCATION_ORG_NAME','like','%'.$search.'%');                                             
                        })
                        ->WhereBetween('DATE_GO',[$from,$to]) 
                        ->orderBy('grecord_index.ID', 'desc')    
                        ->get();
            }else{
               
                
                $inforrecordindex =   Recordindex::select('grecord_index.ID','grecord_index.STATUS','STATUS_NAME','RECORD_TYPE_NAME','grecord_index.RECORD_TYPE_ID','USER_POST_NAME','RECORD_HEAD_USE','LOCATION_ORG_NAME'
                ,'RECORD_LEVEL_NAME','RECORD_ORGANIZER_NAME','gleave_location.LOCATION_NAME','DATE_GO','DATE_BACK','RECORD_COMMENT','RECORD_GO_NAME','RECORD_VEHICLE_NAME','WITHDRAW_NAME'
                ,'LEADER_HR_NAME','OFFER_WORK_HR_NAME','SAVE_BACK','RECORD_USER_ID','POSITION_IN_WORK','LOCATION_ORG_NAME')
                        ->leftJoin('hrd_person','grecord_index.RECORD_USER_ID','=','hrd_person.ID')
                        ->leftJoin('hrd_department_sub','hrd_department_sub.HR_DEPARTMENT_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_ID')
                        ->leftJoin('grecord_status','grecord_index.STATUS','=','grecord_status.STATUS')
                        ->leftJoin('grecord_type','grecord_index.RECORD_TYPE_ID','=','grecord_type.RECORD_TYPE_ID')
                        ->leftJoin('grecord_org_location','grecord_org_location.LOCATION_ID','=','grecord_index.RECORD_LOCATION_ID')
                        ->leftJoin('grecord_level','grecord_level.ID','=','grecord_index.RECORD_LEVEL_ID')
                        ->leftJoin('gleave_location','gleave_location.LOCATION_ID','=','grecord_index.LOCATION_PROV_ID')
                        ->leftJoin('grecord_go','grecord_go.RECORD_GO_ID','=','grecord_index.RECORD_GO_ID')
                        ->leftJoin('grecord_vehicle','grecord_vehicle.RECORD_VEHICLE_ID','=','grecord_index.RECORD_VEHICLE_ID')
                        ->leftJoin('grecord_withdraw','grecord_withdraw.WITHDRAW_ID','=','grecord_index.RECORD_MONEY_ID')
                        ->where('ID_STATUS','=',$status)                                          
                        ->where(function($q) use ($search){
                            $q->where('grecord_index.ID','like','%'.$search.'%');
                            $q->orwhere('USER_POST_NAME','like','%'.$search.'%');  
                            $q->orwhere('RECORD_TYPE_NAME','like','%'.$search.'%');
                            $q->orwhere('RECORD_HEAD_USE','like','%'.$search.'%'); 
                            $q->orwhere('LOCATION_ORG_NAME','like','%'.$search.'%');                                                                                            
                        })
                        ->WhereBetween('DATE_GO',[$from,$to]) 
                        ->orderBy('grecord_index.ID', 'desc')    
                        ->get();
            }    
            
             }else{
                if($status == null){ 
                $inforrecordindex =   Recordindex::select('grecord_index.ID','grecord_index.STATUS','STATUS_NAME','RECORD_TYPE_NAME','grecord_index.RECORD_TYPE_ID','USER_POST_NAME','RECORD_HEAD_USE','LOCATION_ORG_NAME'
                ,'RECORD_LEVEL_NAME','RECORD_ORGANIZER_NAME','gleave_location.LOCATION_NAME','DATE_GO','DATE_BACK','RECORD_COMMENT','RECORD_GO_NAME','RECORD_VEHICLE_NAME','WITHDRAW_NAME'
                ,'LEADER_HR_NAME','OFFER_WORK_HR_NAME','SAVE_BACK','RECORD_USER_ID','POSITION_IN_WORK','LOCATION_ORG_NAME')
                        ->leftJoin('hrd_person','grecord_index.RECORD_USER_ID','=','hrd_person.ID')
                        ->leftJoin('hrd_department_sub','hrd_department_sub.HR_DEPARTMENT_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_ID')
                        ->leftJoin('grecord_status','grecord_index.STATUS','=','grecord_status.STATUS')
                        ->leftJoin('grecord_type','grecord_index.RECORD_TYPE_ID','=','grecord_type.RECORD_TYPE_ID')
                        ->leftJoin('grecord_org_location','grecord_org_location.LOCATION_ID','=','grecord_index.RECORD_LOCATION_ID')
                        ->leftJoin('grecord_level','grecord_level.ID','=','grecord_index.RECORD_LEVEL_ID')
                        ->leftJoin('gleave_location','gleave_location.LOCATION_ID','=','grecord_index.LOCATION_PROV_ID')
                        ->leftJoin('grecord_go','grecord_go.RECORD_GO_ID','=','grecord_index.RECORD_GO_ID')
                        ->leftJoin('grecord_vehicle','grecord_vehicle.RECORD_VEHICLE_ID','=','grecord_index.RECORD_VEHICLE_ID')
                        ->leftJoin('grecord_withdraw','grecord_withdraw.WITHDRAW_ID','=','grecord_index.RECORD_MONEY_ID')
                                ->where(function($q) use ($search){
                                    $q->where('grecord_index.ID','like','%'.$search.'%');
                                    $q->orwhere('USER_POST_NAME','like','%'.$search.'%');  
                                    $q->orwhere('RECORD_TYPE_NAME','like','%'.$search.'%');
                                    $q->orwhere('RECORD_HEAD_USE','like','%'.$search.'%');  
                                    $q->orwhere('LOCATION_ORG_NAME','like','%'.$search.'%');                                                                                           
                                })                                                   
                                ->orderBy('grecord_index.ID', 'desc')    
                                ->get();
                }else{
                    $inforrecordindex =   Recordindex::select('grecord_index.ID','grecord_index.STATUS','STATUS_NAME','RECORD_TYPE_NAME','grecord_index.RECORD_TYPE_ID','USER_POST_NAME','RECORD_HEAD_USE','LOCATION_ORG_NAME'
                    ,'RECORD_LEVEL_NAME','RECORD_ORGANIZER_NAME','gleave_location.LOCATION_NAME','DATE_GO','DATE_BACK','RECORD_COMMENT','RECORD_GO_NAME','RECORD_VEHICLE_NAME','WITHDRAW_NAME'
                    ,'LEADER_HR_NAME','OFFER_WORK_HR_NAME','SAVE_BACK','RECORD_USER_ID','POSITION_IN_WORK','LOCATION_ORG_NAME')
                        ->leftJoin('hrd_person','grecord_index.RECORD_USER_ID','=','hrd_person.ID')
                        ->leftJoin('hrd_department_sub','hrd_department_sub.HR_DEPARTMENT_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_ID')
                        ->leftJoin('grecord_status','grecord_index.STATUS','=','grecord_status.STATUS')
                        ->leftJoin('grecord_type','grecord_index.RECORD_TYPE_ID','=','grecord_type.RECORD_TYPE_ID')
                        ->leftJoin('grecord_org_location','grecord_org_location.LOCATION_ID','=','grecord_index.RECORD_LOCATION_ID')
                        ->leftJoin('grecord_level','grecord_level.ID','=','grecord_index.RECORD_LEVEL_ID')
                        ->leftJoin('gleave_location','gleave_location.LOCATION_ID','=','grecord_index.LOCATION_PROV_ID')
                        ->leftJoin('grecord_go','grecord_go.RECORD_GO_ID','=','grecord_index.RECORD_GO_ID')
                        ->leftJoin('grecord_vehicle','grecord_vehicle.RECORD_VEHICLE_ID','=','grecord_index.RECORD_VEHICLE_ID')
                        ->leftJoin('grecord_withdraw','grecord_withdraw.WITHDRAW_ID','=','grecord_index.RECORD_MONEY_ID')
                            ->where('ID_STATUS','=',$status)  
                            ->where(function($q) use ($search){
                                $q->where('grecord_index.ID','like','%'.$search.'%');
                                $q->orwhere('USER_POST_NAME','like','%'.$search.'%');  
                                $q->orwhere('RECORD_TYPE_NAME','like','%'.$search.'%');
                                $q->orwhere('RECORD_HEAD_USE','like','%'.$search.'%');  
                                $q->orwhere('LOCATION_ORG_NAME','like','%'.$search.'%');                                                                                           
                            })                                                   
                            ->orderBy('grecord_index.ID', 'desc')    
                            ->get();                       
                }
            }        

        $grecordstatus = DB::table('grecord_status')->get(); 
        $year_id = $yearbudget;

        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get(); 

            return view('person_headdep/headdep_persondev',[ 
                 'inforpersonuser' => $inforpersonuser, 
                 'inforpersonuserid' => $inforpersonuserid,            
                'inforrecordindexs' => $inforrecordindex,
                  'grecordstatuss' => $grecordstatus,
                  'displaydate_bigen'=> $displaydate_bigen, 
                  'displaydate_end'=> $displaydate_end,
                  'status_check' => $status,
                  'search' => $search,
                  'year_id'=>$year_id, 
                  'budgets' =>  $budget,  
            ]);
           
}



    public function headdep_persondev_update(Request $request)
    {  
            $id = $request->ID; 

            $check =  $request->SUBMIT; 

            if($check == 'approved'){
            $statuscode = 'RECEIVE';
            }else{
            $statuscode = 'EDIT';
            }
            $updatever = Recordindex::find($id);
            $updatever->VERIFY_COMMENT = $request->VERIFY_COMMENT;
            $updatever->STATUS = $statuscode; 

            $updatever->RECEIVE_BY_ID = $request->PERSON_ID; 
            $addinforperson=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
            ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
            ->where('hrd_person.ID','=',$request->PERSON_ID)->first();
            
            $updatever->RECEIVE_BY_NAME = $addinforperson->HR_PREFIX_NAME.''.$addinforperson->HR_FNAME.' '.$addinforperson->HR_LNAME;
            //-----------------------------------------------------
     
            $updatever->save();  
                return redirect()->route('hdep.headdep_persondev');

    }




    public function headdep_supplier()
    {

        $iduser  = Auth::user()->PERSON_ID; 

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

    
        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;
        }
       
       
        $inforequest = Suppliesrequest::leftJoin('supplies_request_status','supplies_request_status.STATUS_CODE','=','supplies_request.STATUS')
        ->where('BUDGET_YEAR','=', $yearbudget)
        ->where('DEP_SUB_SUB_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)
        ->where('STATUS','=','Pending')
        ->orderBy('supplies_request.ID', 'desc')
        ->get();
     
        $sumbudget  = Suppliesrequest::where('DEP_SUB_SUB_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)
        ->where('BUDGET_YEAR','=', $yearbudget)
        ->where('DEP_SUB_SUB_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)
        ->where('STATUS','=','Pending')
        ->sum('BUDGET_SUM');

        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        $info_sendstatus = DB::table('supplies_request_status')->get();

        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';
        $status = 'Pending';
        $search = '';
        $year_id = $yearbudget;

        return view('person_headdep.headdep_supplier',[
            'budgets' =>  $budget,   
            'inforpersonuserid' => $inforpersonuserid,
            'inforpersonuser' => $inforpersonuser,
            'inforequests' => $inforequest,
            'info_sendstatuss' => $info_sendstatus,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id, 
            'sumbudget'=>$sumbudget
        ]);
    }


    public function headdep_supplier_app(Request $request,$idref)
    {

        $iduser  = Auth::user()->PERSON_ID; 

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

 
       
        $inforequest = Suppliesrequest::leftJoin('supplies_request_status','supplies_request_status.STATUS_CODE','=','supplies_request.STATUS')
        ->where('supplies_request.ID','=',$idref)
        ->where('STATUS','=','Pending')
        ->first();
     
    

        return view('person_headdep.headdep_supplier_app',[  
            'inforpersonuserid' => $inforpersonuserid,
            'inforpersonuser' => $inforpersonuser,
            'inforequest' => $inforequest,
           
        ]);
    }


    //==========================================================================//

    public function headdep_warehouse()
    {

        $iduser  = Auth::user()->PERSON_ID; 

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
            ->leftJoin('hrd_kind','hrd_person.HR_KIND_ID','=','hrd_kind.HR_KIND_ID')
            ->leftJoin('hrd_kind_type','hrd_person.HR_KIND_TYPE_ID','=','hrd_kind_type.HR_KIND_TYPE_ID')
            ->leftJoin('hrd_person_type','hrd_person.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
        ->where('hrd_person.ID','=',$iduser)->first();

          $leader =  DB::table('gleave_leader_person')
        ->leftJoin('gleave_leader','gleave_leader.LEADER_ID','=','gleave_leader_person.LEADER_ID')
        ->where('PERSON_ID','=',$iduser)
        ->first();
    
        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;
        }
            
        $inforwarehouserequest = Warehouserequest::leftJoin('warehouse_request_status','warehouse_request_status.STATUS_CODE','=','warehouse_request.WAREHOUSE_STATUS')  
        ->leftJoin('supplies_inven','supplies_inven.INVEN_ID','=','warehouse_request.WAREHOUSE_INVEN_ID')
        ->leftJoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','warehouse_request.WAREHOUSE_DEP_SUB_SUB_ID')
        ->where('WAREHOUSE_AGREE_HR_ID','=', $inforpersonuser->ID)
        ->where('WAREHOUSE_STATUS','=','Pending')
        ->orderBy('WAREHOUSE_ID', 'desc')
        ->get();     
        
      
  
        $sumbudget  = Warehouserequest::where('WAREHOUSE_DEP_SUB_SUB_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)
        ->where('WAREHOUSE_STATUS','=','Pending')
        ->sum('WAREHOUSE_BUDGET_SUM');

        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        $info_sendstatus = DB::table('supplies_request_status')->get();

        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';
        $status = 'Pending';
        $search = '';
        $year_id = $yearbudget;

        return view('person_headdep.headdep_warehouse',[
            'budgets' =>  $budget,   
            'inforpersonuserid' => $inforpersonuserid,
            'inforpersonuser' => $inforpersonuser,
            'inforwarehouserequests' => $inforwarehouserequest,
            'info_sendstatuss' => $info_sendstatus,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id, 
            'sumbudget'=>$sumbudget
        ]);
    }



    
    public function headdep_warehouse_app(Request $request,$idref)
    {

        $iduser  = Auth::user()->PERSON_ID; 

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
            ->leftJoin('hrd_kind','hrd_person.HR_KIND_ID','=','hrd_kind.HR_KIND_ID')
            ->leftJoin('hrd_kind_type','hrd_person.HR_KIND_TYPE_ID','=','hrd_kind_type.HR_KIND_TYPE_ID')
            ->leftJoin('hrd_person_type','hrd_person.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
        ->where('hrd_person.ID','=',$iduser)->first();

      
      

        $inforwarehouserequest = Warehouserequest::leftJoin('warehouse_request_status','warehouse_request_status.STATUS_CODE','=','warehouse_request.WAREHOUSE_STATUS')  
        ->leftJoin('supplies_inven','supplies_inven.INVEN_ID','=','warehouse_request.WAREHOUSE_INVEN_ID')
        ->leftJoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','warehouse_request.WAREHOUSE_DEP_SUB_SUB_ID')
        ->where('WAREHOUSE_ID','=',$idref)
        ->first();     
        
  

        return view('person_headdep.headdep_warehouse_app',[  
            'inforpersonuserid' => $inforpersonuserid,
            'inforpersonuser' => $inforpersonuser,
            'inforwarehouserequest' => $inforwarehouserequest,
           
        ]);
    }

     
    function headdep_warehousedetail(Request $request)
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
      
        $id = $request->get('id');

        $detail = DB::table('warehouse_request')->where('WAREHOUSE_ID','=',$id)->first();
    
        $detailperson = DB::table('hrd_person')->where('ID','=',$detail->WAREHOUSE_SAVE_HR_ID)->first();
    
        $output ='
        <div class="row push" style="font-family: \'Kanit\', sans-serif;">
        <input type="hidden"  name="ID" value="'.$id.'"/>
        <div class="col-sm-10">
        <div class="row">
    
        <div class="col-sm-2">
            <div class="form-group">
            <label >ลงวันที่ :</label>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group" >
            <h1 style="text-align: left;font-family: \'Kanit\', sans-serif; font-size:10px;font-size: 1.0rem;font-weight:normal;color:#778899;">'.DateThai($detail -> WAREHOUSE_DATE_WANT).'</h1>
            </div>
        </div>
    
        <div class="col-sm-2">
            <div class="form-group">
            <label >เหตุผลที่ขอเบิก  :</label>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
            <h1 style="text-align: left;font-family: \'Kanit\', sans-serif; font-size:10px;font-size: 1.0rem;font-weight:normal;color:#778899;">'.$detail -> WAREHOUSE_REQUEST_BUY_COMMENT.'</h1>
            </div>
        </div>
    
        </div>
    
        <div class="row">
    
        <div class="col-sm-2">
            <div class="form-group">
            <label >ผู้แจ้งขอเบิก:</label>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group" >
            <h1 style="text-align: left;font-family: \'Kanit\', sans-serif; font-size:10px;font-size: 1.0rem;font-weight:normal;color:#778899;">'.$detail -> WAREHOUSE_SAVE_HR_NAME.'</h1>
            </div>
        </div>
    
        <div class="col-sm-2">
            <div class="form-group">
            <label >หน่วยงานที่ร้องขอ  :</label>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
            <h1 style="text-align: left;font-family: \'Kanit\', sans-serif; font-size:10px;font-size: 1.0rem;font-weight:normal;color:#778899;" >'.$detail -> WAREHOUSE_SAVE_HR_DEP_SUB_NAME.'</h1>
            </div>
        </div>
    
        </div>
    
    
        <div class="row">
    
        <div class="col-sm-2">
            <div class="form-group">
            <label >เบอร์โทร :</label>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group" >
            <h1 style="text-align: left;font-family: \'Kanit\', sans-serif; font-size:10px;font-size: 1.0rem;font-weight:normal;color:#778899;">'.$detailperson -> HR_PHONE.'</h1>
            </div>
        </div>
    
        <div class="col-sm-2">
            <div class="form-group">
            <label >เบอร์โทรหน่วยงาน:</label>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
            <h1 style="text-align: left;font-family: \'Kanit\', sans-serif; font-size:10px;font-size: 1.0rem;font-weight:normal;color:#778899;" >'.$detail -> WAREHOUSE_DEP_SUB_SUB_PHONE.'</h1>
            </div>
        </div>
    
    
            </div>
            </div>
    
            <div class="col-sm-2">
                    
            <div class="form-group">
            <img src="data:image/png;base64,'. chunk_split(base64_encode($detailperson->HR_IMAGE)) .'"  height="100px" width="100px"/>
    
            </div>
    
            </div>
    
            </div>
            ';
    
            $detail_subs_sum = DB::table('warehouse_request_sub')->where('WAREHOUSE_REQUEST_ID','=',$id)->sum('WAREHOUSE_REQUEST_SUB_SUM_PRICE');
    
            $output.=' 
          
            <table class="table-bordered table-striped table-vcenter js-dataTable-simple" style="width: 100%;">
            <thead style="background-color: #FFEBCD;">
                <tr height="40">
                <th  class="text-font" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;" width="5%">ลำดับ</th>
                    <th  class="text-font" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">รายละเอียด</th>
                    <th  class="text-font" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;" width="15%">จำนวนเบิก</th>
                    <th  class="text-font" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;" width="15%">หน่วย</th>
                
    
                </tr >
            </thead>
            <tbody>     ';
    
                $detail_subs = DB::table('warehouse_request_sub')->where('WAREHOUSE_REQUEST_ID','=',$id)
                ->leftJoin('supplies','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_DETAIL_ID','=','supplies.ID')
                ->leftJoin('supplies_unit_ref','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_UNIT','=','supplies_unit_ref.ID')
                ->get();
    
                $count = 1;
                foreach ($detail_subs as $detailsub){
                $output.='  <tr height="20">
                <td class="text-font" align="center" style="border: 1px solid black;" >'.$count.'</td>
                <td class="text-font text-pedding" style="border: 1px solid black;" >'.$detailsub->SUP_NAME.'</td>
                <td class="text-font" align="center" style="border: 1px solid black;" >'.$detailsub->WAREHOUSE_REQUEST_SUB_AMOUNT.'</td>
                <td class="text-font" align="center" style="border: 1px solid black;" >'.$detailsub->SUP_UNIT_NAME.'</td>
                
                </tr>';
    
                $count++;
                }
    
    
    
                $output.=' </tbody>
                </table><br>
                <label style="float:left;">ความเห็นผู้เห็นชอบ</label><br>
                <B style="float:left;">'.$detail -> WAREHOUSE_AGREE_COMMENT.'</B><br>
                <B style="float:left;">ผู้เห็นชอบ  '.$detail -> WAREHOUSE_AGREE_HR_NAME.'</B><br><br>  
    
                ';
    
                echo $output;
    


    }

    public function headdep_warehouseupdate(Request $request)
    {
        $id = $request->ID;
    
        $check =  $request->SUBMIT;
    
        if($check == 'approved'){
          $statuscode = 'Approve';
        }else{
          $statuscode = 'Disapprove';
        }
        
            $update = Warehouserequest::find($id);
            $update->WAREHOUSE_REQUEST_COMMENT = $request->WAREHOUSE_REQUEST_COMMENT;
            $update->WAREHOUSE_STATUS = $statuscode;    
            $update->WAREHOUSE_AGREE_HR_ID = $request->WAREHOUSE_AGREE_HR_ID;

            $AGREEHR =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
            ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
            ->where('hrd_person.ID','=',$request->WAREHOUSE_AGREE_HR_ID)->first();
        
            $update->WAREHOUSE_AGREE_HR_NAME = $AGREEHR->HR_PREFIX_NAME.''.$AGREEHR->HR_FNAME.' '.$AGREEHR->HR_LNAME;
            $update->WAREHOUSE_AGREE_HR_POSITION = $AGREEHR->HR_POSITION_NAME;    
            $update->save();
  
            return redirect()->route('hdep.headdep_warehouse');    
    }
    
    public function headdep_warehousesearch(Request $request)
    {
        $iduser  = Auth::user()->PERSON_ID; 

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

        $search = $request->get('search');
        $status = $request->SEND_STATUS;
        $yearbudget = $request->YEAR_ID;
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

            if($status == null){

                $inforwarehouserequest = Warehouserequest::leftJoin('warehouse_request_status','warehouse_request_status.STATUS_CODE','=','warehouse_request.WAREHOUSE_STATUS')  
                ->leftJoin('supplies_inven','supplies_inven.INVEN_ID','=','warehouse_request.WAREHOUSE_INVEN_ID')
                ->leftJoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','warehouse_request.WAREHOUSE_DEP_SUB_SUB_ID')
                ->where('WAREHOUSE_DEP_SUB_SUB_ID','=', $inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)
                ->where('WAREHOUSE_BUDGET_YEAR','=', $yearbudget)
                ->where(function($q) use ($search){
                    $q->where('INVEN_NAME','like','%'.$search.'%');
                    $q->orwhere('WAREHOUSE_REQUEST_BUY_COMMENT','like','%'.$search.'%');
                    $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');
                })
                ->WhereBetween('WAREHOUSE_DATE_TIME_SAVE',[$from,$to])
                ->orderBy('WAREHOUSE_ID', 'desc')
                ->get();           
          
                $sumbudget  = Warehouserequest::leftJoin('warehouse_request_status','warehouse_request_status.STATUS_CODE','=','warehouse_request.WAREHOUSE_STATUS')  
                ->leftJoin('supplies_inven','supplies_inven.INVEN_ID','=','warehouse_request.WAREHOUSE_INVEN_ID')
                ->leftJoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','warehouse_request.WAREHOUSE_DEP_SUB_SUB_ID')
                ->where('WAREHOUSE_DEP_SUB_SUB_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)
                ->where('WAREHOUSE_BUDGET_YEAR','=', $yearbudget)
                ->where(function($q) use ($search){
                    $q->where('INVEN_NAME','like','%'.$search.'%');
                    $q->orwhere('WAREHOUSE_REQUEST_BUY_COMMENT','like','%'.$search.'%');
                    $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');
                })
                ->WhereBetween('WAREHOUSE_DATE_TIME_SAVE',[$from,$to])
                ->sum('WAREHOUSE_BUDGET_SUM');


            }else{
        

                $inforwarehouserequest = Warehouserequest::leftJoin('warehouse_request_status','warehouse_request_status.STATUS_CODE','=','warehouse_request.WAREHOUSE_STATUS')  
                ->leftJoin('supplies_inven','supplies_inven.INVEN_ID','=','warehouse_request.WAREHOUSE_INVEN_ID')
                ->leftJoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','warehouse_request.WAREHOUSE_DEP_SUB_SUB_ID')
                ->where('WAREHOUSE_DEP_SUB_SUB_ID','=', $inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)
                ->where('WAREHOUSE_BUDGET_YEAR','=', $yearbudget)
                ->where('STATUS_CODE','=',$status)
                ->where(function($q) use ($search){
                    $q->where('INVEN_NAME','like','%'.$search.'%');
                    $q->orwhere('WAREHOUSE_REQUEST_BUY_COMMENT','like','%'.$search.'%');
                    $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');
                })
                ->WhereBetween('WAREHOUSE_DATE_TIME_SAVE',[$from,$to])
                ->orderBy('WAREHOUSE_ID', 'desc')
                ->get();   
                
                $sumbudget  = Warehouserequest::leftJoin('warehouse_request_status','warehouse_request_status.STATUS_CODE','=','warehouse_request.WAREHOUSE_STATUS')  
                ->leftJoin('supplies_inven','supplies_inven.INVEN_ID','=','warehouse_request.WAREHOUSE_INVEN_ID')
                ->leftJoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','warehouse_request.WAREHOUSE_DEP_SUB_SUB_ID')
                ->where('WAREHOUSE_DEP_SUB_SUB_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)
                ->where('WAREHOUSE_BUDGET_YEAR','=', $yearbudget)
                ->where('STATUS_CODE','=',$status)
                ->where(function($q) use ($search){
                    $q->where('INVEN_NAME','like','%'.$search.'%');
                    $q->orwhere('WAREHOUSE_REQUEST_BUY_COMMENT','like','%'.$search.'%');
                    $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');
                })
                ->WhereBetween('WAREHOUSE_DATE_TIME_SAVE',[$from,$to])
                ->sum('WAREHOUSE_BUDGET_SUM');


            }
    

        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $info_sendstatus = DB::table('supplies_request_status')->get();
        $year_id = $yearbudget;

        return view('person_headdep/headdep_warehouse',[
            'budgets' =>  $budget,
            'inforpersonuserid' => $inforpersonuserid,
            'inforpersonuser' => $inforpersonuser,
            'inforwarehouserequests' => $inforwarehouserequest,
            'info_sendstatuss' => $info_sendstatus,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id,
            'sumbudget' => $sumbudget 

        ]);

    }



























//============================== Start inforequestappsearch =====================//
    public function headdep_suppliersearch(Request $request)
    {
        $iduser  = Auth::user()->PERSON_ID; 

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

        $search = $request->get('search');
        $status = $request->SEND_STATUS;
        $yearbudget = $request->YEAR_ID;
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

            if($status == null){

                $inforequest = Suppliesrequest::leftJoin('supplies_request_status','supplies_request_status.STATUS_CODE','=','supplies_request.STATUS')
                ->where('BUDGET_YEAR','=', $yearbudget)
                ->where('DEP_SUB_SUB_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)
                ->where(function($q) use ($search){
                    $q->where('REQUEST_FOR','like','%'.$search.'%');
                    $q->orwhere('BUDGET_SUM','like','%'.$search.'%');
                    $q->orwhere('SAVE_HR_DEP_SUB_NAME','like','%'.$search.'%');
                })
                    ->WhereBetween('DATE_TIME_SAVE',[$from,$to])
                ->orderBy('supplies_request.ID', 'desc')
                ->get();

                $sumbudget = Suppliesrequest::leftJoin('supplies_request_status','supplies_request_status.STATUS_CODE','=','supplies_request.STATUS')
                ->where('BUDGET_YEAR','=', $yearbudget)
                ->where('DEP_SUB_SUB_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)
                ->where(function($q) use ($search){
                    $q->where('REQUEST_FOR','like','%'.$search.'%');
                    $q->orwhere('BUDGET_SUM','like','%'.$search.'%');
                    $q->orwhere('SAVE_HR_DEP_SUB_NAME','like','%'.$search.'%');
                })
                    ->WhereBetween('DATE_TIME_SAVE',[$from,$to])
                ->sum('BUDGET_SUM');


            }else{

                $inforequest = Suppliesrequest::leftJoin('supplies_request_status','supplies_request_status.STATUS_CODE','=','supplies_request.STATUS')
                ->where('BUDGET_YEAR','=', $yearbudget)
                ->where('DEP_SUB_SUB_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)
                ->where('STATUS_CODE','=',$status)
                ->where(function($q) use ($search){
                    $q->where('REQUEST_FOR','like','%'.$search.'%');
                    $q->orwhere('BUDGET_SUM','like','%'.$search.'%');
                    $q->orwhere('SAVE_HR_DEP_SUB_NAME','like','%'.$search.'%');
                })
                    ->WhereBetween('DATE_TIME_SAVE',[$from,$to])
                ->orderBy('supplies_request.ID', 'desc')
                ->get();

                $sumbudget = Suppliesrequest::leftJoin('supplies_request_status','supplies_request_status.STATUS_CODE','=','supplies_request.STATUS')
                ->where('BUDGET_YEAR','=', $yearbudget)
                ->where('DEP_SUB_SUB_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)
                ->where('STATUS_CODE','=',$status)
                ->where(function($q) use ($search){
                    $q->where('REQUEST_FOR','like','%'.$search.'%');
                    $q->orwhere('BUDGET_SUM','like','%'.$search.'%');
                    $q->orwhere('SAVE_HR_DEP_SUB_NAME','like','%'.$search.'%');
                })
                    ->WhereBetween('DATE_TIME_SAVE',[$from,$to])
                ->sum('BUDGET_SUM');
            }
    

        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $info_sendstatus = DB::table('supplies_request_status')->get();
        $year_id = $yearbudget;

        return view('person_headdep.headdep_supplier',[
            'budgets' =>  $budget,
            'inforpersonuserid' => $inforpersonuserid,
            'inforpersonuser' => $inforpersonuser,
            'inforequests' => $inforequest,
            'info_sendstatuss' => $info_sendstatus,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id,
            'sumbudget' => $sumbudget 

        ]);

    }
//============================== end =====================//

public function headdep_updateinforequestapp(Request $request)
{
    //$email = Auth::user()->email;
    //return $request->all();
    $id = $request->ID;

    $check =  $request->SUBMIT;

    if($check == 'approved'){
      $statuscode = 'Approve';
    }else{
      $statuscode = 'Disapprove';
    }


      $updateapp = Suppliesrequest::find($id);
      $updateapp->AGREE_COMMENT = $request->AGREE_COMMENT;
      $updateapp->STATUS = $statuscode;

      $updateapp->AGREE_HR_ID = $request->AGREE_HR_ID;
       //----------------------------------
       $AGREEHR =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
       ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
       ->where('hrd_person.ID','=',$request->AGREE_HR_ID)->first();

        $updateapp->AGREE_HR_NAME = $AGREEHR->HR_PREFIX_NAME.''.$AGREEHR->HR_FNAME.' '.$AGREEHR->HR_LNAME;
        $updateapp->AGREE_HR_POSITION = $AGREEHR->HR_POSITION_NAME;


        //----------------------------------
      //dd($educationedit);

      $updateapp->save();

          //
          //return redirect()->action('OtherController@infouserother');
          return redirect()->route('hdep.headdep_supplier');

}






    public function setscore()
    {
        $iduser  = Auth::user()->PERSON_ID; 
       
        $infopersonapprov = DB::table('gleave_leader_person')
        ->leftjoin('hrd_person','hrd_person.ID','=','gleave_leader_person.PERSON_ID')
        ->leftjoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
        ->leftjoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->where('LEADER_ID','=',$iduser)->get();

        return view('person_headdep.headdep_setscore',[
            'infopersonapprovs' => $infopersonapprov
        ]);
    }


    public function headdep_kpis()
    {
        $infokpiorg = DB::table('plan_kpi')->get();

        $infokpiperson = DB::table('infowork_kpis')->get();
       
        return view('person_headdep.headdep_kpis',[
            'infokpiorgs'=> $infokpiorg,
            'infokpipersons'=> $infokpiperson,
        ]);
    }


    public function headdep_kpis_detail()
    {
        
        return view('person_headdep.headdep_kpis_detail');
    }


    

//----------------------------------------------------------------------

    public function headdep_funtionalcompetency($idhr)
    {

        $infoworkcorcom = DB::table('infowork_cor_com')->get();
        
        $infoperson = DB::table('hrd_person')->where('ID','=',$idhr)->first();

        $corecompetency = DB::table('infowork_fun_result')->where('FUN_RESULT_PERSON_ID','=',$idhr)->get();

        return view('person_headdep.headdep_funtionalcompetency',[
            'infoworkcorcoms'=> $infoworkcorcom,
            'infoperson'=> $infoperson,
            'corecompetencys'=> $corecompetency
        ]);

    }

    public function headdep_funtionalcompetency_add(Request $request,$idhr)
    {
        $infoworkfuntion  = DB::table('infowork_funtion')->get();
      
   
        $infoperson = DB::table('hrd_person')->where('ID','=',$idhr)->first();
 
         return view('person_headdep.headdep_funtionalcompetency_add',[
             'infoworkfuntions'=> $infoworkfuntion,
             'infoperson'=> $infoperson
             
         ]);
    }


    

    public function headdep_funtionalcompetency_save(Request $request)
    {

        $idhr = $request->IDHR;
      
        $add = new Infoworkfunresult(); 
        $add->FUN_RESULT_PERSON_ID = $request->FUN_RESULT_PERSON_ID;
        $add->FUN_RESULT_HEAD_ID = $request->FUN_RESULT_HEAD_ID;
        $add->FUN_RESULT_YEAR = $request->FUN_RESULT_YEAR;
        $add->FUN_RESULT_NO = $request->FUN_RESULT_NO;
        $add->save();

        $FUN_RESULT_ID = Infoworkfunresult::max('FUN_RESULT_ID');

      
            
            $SCORE_ID = $request->SCORE_ID;
            $COMMENT = $request->COMMENT;
            $FUN_COM_ID = $request->FUN_COM_ID;
            $FUN_COM_NUMBER = $request->FUN_COM_NUMBER;
            $FUN_COM_LEVEL_ID = $request->FUN_COM_LEVEL_ID;
            $TYPE_SCORE_ID = $request->TYPE_SCORE_ID;

            $number =count($SCORE_ID);
            $count = 0;
            for($count = 0; $count < $number; $count++)
            {  
          
               $addsup = new Infoworkfunresultsub();
               $addsup->FUN_RESULT_ID = $FUN_RESULT_ID;
               $addsup->SCORE_ID = $SCORE_ID[$count];
               $addsup->COMMENT = $COMMENT[$count];
               $addsup->FUN_COM_ID = $FUN_COM_ID[$count];
               $addsup->FUN_COM_LEVEL_ID = $FUN_COM_LEVEL_ID[$count];
               $addsup->FUN_COM_NUMBER = $FUN_COM_NUMBER[$count];
               $addsup->TYPE_SCORE_ID = $TYPE_SCORE_ID[$count];
               $addsup->save(); 

            }
        

       return redirect()->route('hdep.headdep_funtionalcompetency',[
          'idhr'=>$idhr
       ]);
    }



    
    public function headdep_funtionalcompetency_detail(Request $request,$idhr,$idref)
    {


       $infoworkfuntion = DB::table('infowork_funtion')->get();
      
   
       $infoperson = DB::table('hrd_person')->where('ID','=',$idhr)->first();

       $infocorresult = DB::table('infowork_fun_result')->where('FUN_RESULT_ID','=',$idref)->first(); 


        return view('person_headdep.headdep_funtionalcompetency_detail',[
            'infoworkfuntions'=> $infoworkfuntion,
            'infoperson'=> $infoperson,
            'infocorresult'=>$infocorresult
            
        ]);
    }



//------------------------------------------------------------------------------

    public function headdep_corecompetency($idhr)
    {

        $infoworkcorcom = DB::table('infowork_cor_com')->get();
        
        $infoperson = DB::table('hrd_person')->where('ID','=',$idhr)->first();

        $corecompetency = DB::table('infowork_cor_result')->where('COR_RESULT_PERSON_ID','=',$idhr)->get();

        return view('person_headdep.headdep_corecompetency',[
            'infoworkcorcoms'=> $infoworkcorcom,
            'infoperson'=> $infoperson,
            'corecompetencys'=> $corecompetency
        ]);
    }

    

    public function headdep_corecompetency_add(Request $request,$idhr)
    {


       $infoworkcorcom = DB::table('infowork_cor_com')->get();
      
   
       $infoperson = DB::table('hrd_person')->where('ID','=',$idhr)->first();

        return view('person_headdep.headdep_corecompetency_add',[
            'infoworkcorcoms'=> $infoworkcorcom,
            'infoperson'=> $infoperson
            
        ]);
    }


    public function headdep_corecompetency_save(Request $request)
    {

        $idhr = $request->IDHR;
      
        $add = new Infoworkcorresult(); 
        $add->COR_RESULT_PERSON_ID = $request->COR_RESULT_PERSON_ID;
        $add->COR_RESULT_HEAD_ID = $request->COR_RESULT_HEAD_ID;
        $add->COR_RESULT_YEAR = $request->COR_RESULT_YEAR;
        $add->COR_RESULT_NO = $request->COR_RESULT_NO;
        $add->save();

        $COR_RESULT_ID = Infoworkcorresult::max('COR_RESULT_ID');

      
            
            $SCORE_ID = $request->SCORE_ID;
            $COMMENT = $request->COMMENT;
            $COR_COM_ID = $request->COR_COM_ID;
            $COR_COM_NUMBER = $request->COR_COM_NUMBER;
            $COR_COM_LEVEL_ID = $request->COR_COM_LEVEL_ID;
            $TYPE_SCORE_ID = $request->TYPE_SCORE_ID;

            $number =count($SCORE_ID);
            $count = 0;
            for($count = 0; $count < $number; $count++)
            {  
          
               $addsup = new Infoworkcorresultsub();
               $addsup->COR_RESULT_ID = $COR_RESULT_ID;
               $addsup->SCORE_ID = $SCORE_ID[$count];
               $addsup->COMMENT = $COMMENT[$count];
               $addsup->COR_COM_ID = $COR_COM_ID[$count];
               $addsup->COR_COM_LEVEL_ID = $COR_COM_LEVEL_ID[$count];
               $addsup->COR_COM_NUMBER = $COR_COM_NUMBER[$count];
               $addsup->TYPE_SCORE_ID = $TYPE_SCORE_ID[$count];
               $addsup->save(); 

            }
        

       return redirect()->route('hdep.headdep_corecompetency',[
          'idhr'=>$idhr
       ]);
    }



    
    public function headdep_corecompetency_detail(Request $request,$idhr,$idref)
    {


       $infoworkcorcom = DB::table('infowork_cor_com')->get();
      
   
       $infoperson = DB::table('hrd_person')->where('ID','=',$idhr)->first();

       $infocorresult = DB::table('infowork_cor_result')->where('COR_RESULT_ID','=',$idref)->first(); 


        return view('person_headdep.headdep_corecompetency_detail',[
            'infoworkcorcoms'=> $infoworkcorcom,
            'infoperson'=> $infoperson,
            'infocorresult'=>$infocorresult
            
        ]);
    }
    //--------------------------------------------------------

    public function headdepplan_project()
    {
        $infoproject = DB::table('plan_project')->orderBy('PRO_ID', 'asc')->get();
        return view('person_headdep.headdepplan_project',[
            'infoprojects' => $infoproject
        ]);
    }
 
    public function headdepplan_humandev()
    {
        $infohumandev = DB::table('plan_humandev')->orderBy('HUM_ID', 'asc')->get();
        return view('person_headdep.headdepplan_humandev',[
            'infohumandevs' => $infohumandev
        ]);
    }
    public function headdepplan_durable()
    {

        $infodurable = DB::table('plan_durable')->orderBy('DUR_ID', 'asc')->get();

        return view('person_headdep.headdepplan_durable',[
            'infodurables' => $infodurable
            ]);
    }
 

    

    public function project_add(Request $request)
    {      


        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;
        }
        
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $year_id = $yearbudget;


        $infoplantype =  DB::table('plan_type')->get();

        $infobudgettype =  DB::table('supplies_budget')->get();

        $infotream =  DB::table('hrd_team')->get();

        $infotreamperson =  DB::table('hrd_team_list')->get();

        $infostrategic =  DB::table('plan_strategic')->where('ACTIVE','=','TRUE')->get();

        return view('person_headdep.headdepplan_project_add',[
            'budgets' =>  $budget,
            'year_id'=>$year_id,
            'infoplantypes'=>$infoplantype,
            'infobudgettypes'=>$infobudgettype,
            'infotreams'=>$infotream,
            'infotreampersons'=>$infotreamperson,
            'infostrategics'=>$infostrategic,

        ]);
    }


    
    public function humandev_add(Request $request)
    {      

        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;
        }
        
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $year_id = $yearbudget;



        $infobudgettype =  DB::table('supplies_budget')->get();

        $infotream =  DB::table('hrd_team')->get();

        $infotreamperson =  DB::table('hrd_team_list')->get();

        $infostrategic =  DB::table('plan_strategic')->where('ACTIVE','=','TRUE')->get();


        return view('person_headdep.headdepplan_humandev_add',[
            'budgets' =>  $budget,
            'year_id'=>$year_id,
            
            'infobudgettypes'=>$infobudgettype,
            'infotreams'=>$infotream,
            'infotreampersons'=>$infotreamperson,
            'infostrategics'=>$infostrategic,


        ]);
    }

    public function durable_add(Request $request)
    {      

        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;
        }
        
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $year_id = $yearbudget;



        $infobudgettype =  DB::table('supplies_budget')->get();

        $infotream =  DB::table('hrd_team')->get();

        $infotreamperson =  DB::table('hrd_team_list')->get();
        $infostrategic =  DB::table('plan_strategic')->where('ACTIVE','=','TRUE')->get();



        return view('person_headdep.headdepplan_durable_add',[
            'budgets' =>  $budget,
            'year_id'=>$year_id,
            
            'infobudgettypes'=>$infobudgettype,
            'infotreams'=>$infotream,
            'infotreampersons'=>$infotreamperson,
            'infostrategics'=>$infostrategic


        ]);
    }



    public static function countinfobook()
    {
        $iduser  = Auth::user()->PERSON_ID; 
         $count =  Booksendperson::leftJoin('gbook_index','gbook_index.BOOK_ID','=','gbook_send_person.BOOK_ID')
         ->where('BOOK_USE','=','true')
         ->where('READ_STATUS','=','False')
         ->where('gbook_send_person.HR_PERSON_ID','=',$iduser )
         ->orderBy('ID', 'desc') 
         ->count();
   
       return $count;
    }

    public static function countinfoleave()
    {
        $iduser  = Auth::user()->PERSON_ID; 
         $count = Leave_register::leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_ID')
         ->leftJoin('gleave_status','gleave_register.LEAVE_STATUS_CODE','=','gleave_status.STATUS_CODE')
         ->leftJoin('gleave_location','gleave_register.LOCATION_ID','=','gleave_location.LOCATION_ID')
         ->where('LEADER_PERSON_ID','=',$iduser)
         ->where(function($q){
             $q->where('LEAVE_STATUS_CODE','=','Pending');
          
         })
        
         ->orderBy('gleave_register.ID', 'desc')
         ->count();
   
       return $count;
    }

    public static function countinfodep()
    {
         $count = Recordindex::select('grecord_index.ID','grecord_index.STATUS','STATUS_NAME','RECORD_TYPE_NAME','grecord_index.RECORD_TYPE_ID','USER_POST_NAME','RECORD_HEAD_USE','LOCATION_ORG_NAME'
         ,'RECORD_LEVEL_NAME','RECORD_ORGANIZER_NAME','gleave_location.LOCATION_NAME','DATE_GO','DATE_BACK','RECORD_COMMENT','RECORD_GO_NAME','RECORD_VEHICLE_NAME','WITHDRAW_NAME'
         ,'LEADER_HR_NAME','OFFER_WORK_HR_NAME','SAVE_BACK','RECORD_USER_ID','POSITION_IN_WORK','HR_DEPARTMENT_SUB_NAME')
         ->leftJoin('hrd_person','grecord_index.RECORD_USER_ID','=','hrd_person.ID')
         ->leftJoin('hrd_department_sub','hrd_department_sub.HR_DEPARTMENT_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_ID')
         ->leftJoin('grecord_status','grecord_index.STATUS','=','grecord_status.STATUS')
         ->leftJoin('grecord_type','grecord_index.RECORD_TYPE_ID','=','grecord_type.RECORD_TYPE_ID')
         ->leftJoin('grecord_org_location','grecord_org_location.LOCATION_ID','=','grecord_index.RECORD_LOCATION_ID')
         ->leftJoin('grecord_level','grecord_level.ID','=','grecord_index.RECORD_LEVEL_ID')
         ->leftJoin('gleave_location','gleave_location.LOCATION_ID','=','grecord_index.LOCATION_PROV_ID')
         ->leftJoin('grecord_go','grecord_go.RECORD_GO_ID','=','grecord_index.RECORD_GO_ID')
         ->leftJoin('grecord_vehicle','grecord_vehicle.RECORD_VEHICLE_ID','=','grecord_index.RECORD_VEHICLE_ID')
         ->leftJoin('grecord_withdraw','grecord_withdraw.WITHDRAW_ID','=','grecord_index.RECORD_MONEY_ID')
         ->where('grecord_index.STATUS','=','APPLY')
         ->orderBy('grecord_index.ID', 'desc')  
         ->count();
 
   
       return $count;
    }

    public static function countinfosup()
    {
        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;
        }

        $iduser  = Auth::user()->PERSON_ID; 


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
      
         $count = Suppliesrequest::leftJoin('supplies_request_status','supplies_request_status.STATUS_CODE','=','supplies_request.STATUS')
         ->where('BUDGET_YEAR','=', $yearbudget)
         ->where('DEP_SUB_SUB_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)
         ->where('STATUS','=','Pending')
         ->orderBy('supplies_request.ID', 'desc')
         ->count();
   
       return $count;
    }

    public static function countinfostore()
    {
        $iduser  = Auth::user()->PERSON_ID; 
         $count =  Warehouserequest::leftJoin('warehouse_request_status','warehouse_request_status.STATUS_CODE','=','warehouse_request.WAREHOUSE_STATUS')  
         ->leftJoin('supplies_inven','supplies_inven.INVEN_ID','=','warehouse_request.WAREHOUSE_INVEN_ID')
         ->leftJoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','warehouse_request.WAREHOUSE_DEP_SUB_SUB_ID')
         ->where('WAREHOUSE_AGREE_HR_ID','=', $iduser)
         ->where('WAREHOUSE_STATUS','=','Pending')
         ->orderBy('WAREHOUSE_ID', 'desc')
         ->count();     
   
       return $count;
    }

   
       //===================================================================

    
public function headdep_leave_calendar(Request $request)
{

    if(!empty($_GET['depid']) && !empty($_GET['depname']) ){
        $depid['id'] =  $_GET['depid'];
        $depname['name'] =  $_GET['depname'];
    }else{
      $depid['id'] =  'all';
      $depname['name'] =  'ทั้งหมด';
    }

    // dd($depid['id'] );

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

    
    // $inforleave=  Leave_register::orderBy('gleave_register.ID', 'desc')
    // ->get();

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


    $inforleavess =  Leave_register::leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_ID')
    ->leftJoin('gleave_status','gleave_register.LEAVE_STATUS_CODE','=','gleave_status.STATUS_CODE')
    ->leftJoin('gleave_location','gleave_register.LOCATION_ID','=','gleave_location.LOCATION_ID')
    ->where('LEADER_PERSON_ID','=',$iduser)
    ->where('LEAVE_STATUS_CODE','=','Pending')
    ->orderBy('gleave_register.ID', 'desc')
    ->get();            


        //  dd($inforleave);

        
    return view('person_headdep.headdep_leave_calendar',$data,[
        'inforpersonuser' => $inforpersonuser,
        'inforpersonuserid' => $inforpersonuserid,
        'infopersonleaves' => $inforleave,
        'depinfos' => $depinfo,
        'infoleavetodates' => $infoleavetodate,
        'infoleavetomorrows' => $infoleavetomorrow,
        'iduser' => $iduser,
        'inforleavess' => $inforleavess,
        
    ]);
}




public function headdep_saverpresent(Request $request)
{

    $bookid = $request->BOOK_ID;

    $checksendleader = DB::table('gbook_index_send_leader')
    ->where('BOOK_LD_ID','=',$bookid)
    ->count(); 
 
   

    $date = date('Y-m-d');
    $datetime = date('Y-m-d H:i:s');
    
    $info_org = DB::table('info_org')->first();


    if($checksendleader !== 0 ){

        $sendid = DB::table('gbook_index_send_leader')
        ->where('BOOK_LD_ID','=',$bookid)
        ->first(); 

        if($request->SEND_LD_DETAIL_2 == '' ){

            $SEND_LD_BY_HR_NAME_2 = '';
            $SEND_LD_DETAIL_2 = '';
            $SEND_LD_BY_HR_ID_2 = null;

        }else{
            $SEND_LD_BY_HR_NAME_2 = $request->SEND_LD_BY_HR_NAME_2 ;
            $SEND_LD_DETAIL_2 = $request->SEND_LD_DETAIL_2;
            $SEND_LD_BY_HR_ID_2 =$request->SEND_LD_BY_HR_ID_2;
        }



        $addpresent = Bookindexsendleader::find($sendid->SEND_LD_ID);
        $addpresent->BOOK_LD_ID = $request->BOOK_ID;
        $addpresent->SEND_LD_HR_ID = $info_org->ORG_LEADER_ID;
        $addpresent->SEND_LD_HR_NAME = $info_org->ORG_LEADER;
        $addpresent->SEND_LD_BY_HR_ID = $request->SEND_LD_BY_HR_ID;
        $addpresent->SEND_LD_BY_HR_NAME = $request->SEND_LD_BY_HR_NAME;
        $addpresent->SEND_LD_DETAIL = $request->SEND_LD_DETAIL;
        $addpresent->SEND_LD_BY_HR_ID_2 = $SEND_LD_BY_HR_ID_2;
        $addpresent->SEND_LD_BY_HR_NAME_2  = $SEND_LD_BY_HR_NAME_2;
        $addpresent->SEND_LD_DETAIL_2  = $SEND_LD_DETAIL_2;

        $addpresent->SEND_LD_DATE = $date;
        $addpresent->SEND_LD_DATE_TIME = $datetime;
        $addpresent->SEND_LD_STATUS = 'SEND';
        $addpresent->save();


    }else{
    $addpresent = new Bookindexsendleader(); 
    $addpresent->BOOK_LD_ID = $request->BOOK_ID;
    $addpresent->SEND_LD_HR_ID = $info_org->ORG_LEADER_ID;
    $addpresent->SEND_LD_HR_NAME = $info_org->ORG_LEADER;
    $addpresent->SEND_LD_BY_HR_ID = $request->SEND_LD_BY_HR_ID;
    $addpresent->SEND_LD_BY_HR_NAME = $request->SEND_LD_BY_HR_NAME;
    $addpresent->SEND_LD_DETAIL = $request->SEND_LD_DETAIL;
    $addpresent->SEND_LD_BY_HR_ID_2 = $request->SEND_LD_BY_HR_ID_2 ;
    $addpresent->SEND_LD_BY_HR_NAME_2  = $request->SEND_LD_BY_HR_NAME_2 ;
    $addpresent->SEND_LD_DETAIL_2  = $request->SEND_LD_DETAIL_2 ;

    $addpresent->SEND_LD_DATE = $date;
    $addpresent->SEND_LD_DATE_TIME = $datetime;
    $addpresent->SEND_LD_STATUS = 'SEND';
    $addpresent->save();

 
    }


    return redirect()->route('hdep.infobookreceiptcontrol',[
        'id' => $bookid
    ]);



}




}

