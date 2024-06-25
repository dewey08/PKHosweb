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

use App\Models\Salaryborrow;
use Session;

date_default_timezone_set("Asia/Bangkok");

class HeadorgController extends Controller
{
    public function dashboard()
    {


        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;
        }



        $year = date('Y');
      

        $amount_1 = DB::table('hrd_person')->where('HR_STATUS_ID','=',1)->count();
        $amount_2 = DB::table('hrd_person')->where('HR_STATUS_ID','=',2)->count();
        $amount_3 = DB::table('hrd_person')->where('HR_STATUS_ID','=',3)->count();
        $amount_4 = DB::table('hrd_person')->where('HR_STATUS_ID','=',4)->count();

        $leave_amount_1 = DB::table('gleave_register')->where('LEAVE_TYPE_CODE','=',1)->where('LEAVE_YEAR_ID','=',$yearbudget)->count();
        $leave_amount_2 = DB::table('gleave_register')->where('LEAVE_TYPE_CODE','=',3)->where('LEAVE_YEAR_ID','=',$yearbudget)->count();
        $leave_amount_3 = DB::table('gleave_register')->where('LEAVE_TYPE_CODE','=',4)->where('LEAVE_YEAR_ID','=',$yearbudget)->count();
        $leave_amount_4 = DB::table('gleave_register')->where('LEAVE_TYPE_CODE','=',6)->where('LEAVE_YEAR_ID','=',$yearbudget)->count();

        $perdev_amount_1 = DB::table('grecord_index')->where('RECORD_TYPE_ID','=',1)->where('DATE_GO','like',$year.'%')->count();
        $perdev_amount_2 = DB::table('grecord_index')->where('RECORD_TYPE_ID','=',2)->where('DATE_GO','like',$year.'%')->count();
        $perdev_amount_3 = DB::table('grecord_index')->where('RECORD_TYPE_ID','=',3)->where('DATE_GO','like',$year.'%')->count();
        $perdev_amount_4 = DB::table('grecord_index')->where('RECORD_TYPE_ID','=',4)->where('DATE_GO','like',$year.'%')->count();
        $perdev_amount_5 = DB::table('grecord_index')->where('RECORD_TYPE_ID','=',5)->where('DATE_GO','like',$year.'%')->count();
        $perdev_amount_6 = DB::table('grecord_index')->where('RECORD_TYPE_ID','=',6)->where('DATE_GO','like',$year.'%')->count();

        $man  = DB::table('hrd_person')
        ->where('SEX','=','M')
        ->where('HR_STATUS_ID','<>',5)
        ->where('HR_STATUS_ID','<>',6)
        ->where('HR_STATUS_ID','<>',7)
        ->where('HR_STATUS_ID','<>',8)
        ->count();

        $women  = DB::table('hrd_person')
        ->where('SEX','=','F')
        ->where('HR_STATUS_ID','<>',5)
        ->where('HR_STATUS_ID','<>',6)
        ->where('HR_STATUS_ID','<>',7)
        ->where('HR_STATUS_ID','<>',8)
        ->count();
       

        $groupwork = DB::table('hrd_person')
                      ->select(DB::raw('count(*) as person_count,HR_DEPARTMENT_NAME'),'HR_DEPARTMENT_NAME')
                      ->leftJoin('hrd_department','hrd_person.HR_DEPARTMENT_ID','=','hrd_department.HR_DEPARTMENT_ID')
                      ->groupBy('HR_DEPARTMENT_NAME')
                      ->get();

        $groupperson = DB::table('hrd_person')
                      ->select(DB::raw('count(*) as person_count,HR_PERSON_TYPE_NAME'),'HR_PERSON_TYPE_NAME')
                      ->leftJoin('hrd_person_type','hrd_person.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
                      ->groupBy('HR_PERSON_TYPE_NAME')
                      ->get();


                      date_default_timezone_set("Asia/Bangkok");
                      $date_now = date('Y-m-d'); 

    



          $position=DB::table('hrd_person')
          ->select(DB::raw('count(*) as amount_count,POSITION_IN_WORK'),'POSITION_IN_WORK')
          ->where('HR_STATUS_ID','<>',5)
          ->where('HR_STATUS_ID','<>',6)
          ->where('HR_STATUS_ID','<>',7)
          ->where('HR_STATUS_ID','<>',8)
          ->groupBy('POSITION_IN_WORK')
          ->orderBy('amount_count', 'desc')    
          ->get();


          $unit=DB::table('hrd_person')
          ->select(DB::raw('count(*) as amount_count,HR_DEPARTMENT_SUB_SUB_NAME'),'HR_DEPARTMENT_SUB_SUB_NAME')
          ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
          ->where('HR_STATUS_ID','<>',5)
          ->where('HR_STATUS_ID','<>',6)
          ->where('HR_STATUS_ID','<>',7)
          ->where('HR_STATUS_ID','<>',8)
          ->groupBy('HR_DEPARTMENT_SUB_SUB_NAME')
          ->orderBy('amount_count', 'desc')    
          ->get();




          $m1_1 = DB::table('gleave_register')->where('LEAVE_TYPE_CODE','=',1)->where('LEAVE_DATE_BEGIN','like',date('Y').'-01%')->count();
          $m2_1 = DB::table('gleave_register')->where('LEAVE_TYPE_CODE','=',2)->where('LEAVE_DATE_BEGIN','like',date('Y').'-02%')->count();
          $m3_1 = DB::table('gleave_register')->where('LEAVE_TYPE_CODE','=',3)->where('LEAVE_DATE_BEGIN','like',date('Y').'-03%')->count();
          $m4_1 = DB::table('gleave_register')->where('LEAVE_TYPE_CODE','=',4)->where('LEAVE_DATE_BEGIN','like',date('Y').'-04%')->count();
          $m5_1 = DB::table('gleave_register')->where('LEAVE_TYPE_CODE','=',5)->where('LEAVE_DATE_BEGIN','like',date('Y').'-05%')->count();
          $m6_1 = DB::table('gleave_register')->where('LEAVE_TYPE_CODE','=',6)->where('LEAVE_DATE_BEGIN','like',date('Y').'-06%')->count();
          $m7_1 = DB::table('gleave_register')->where('LEAVE_TYPE_CODE','=',7)->where('LEAVE_DATE_BEGIN','like',date('Y').'-07%')->count();
          $m8_1 = DB::table('gleave_register')->where('LEAVE_TYPE_CODE','=',8)->where('LEAVE_DATE_BEGIN','like',date('Y').'-08%')->count();
          $m9_1 = DB::table('gleave_register')->where('LEAVE_TYPE_CODE','=',9)->where('LEAVE_DATE_BEGIN','like',date('Y').'-09%')->count();
          $m10_1 = DB::table('gleave_register')->where('LEAVE_TYPE_CODE','=',10)->where('LEAVE_DATE_BEGIN','like',date('Y').'-10%')->count();
          $m11_1 = DB::table('gleave_register')->where('LEAVE_TYPE_CODE','=',11)->where('LEAVE_DATE_BEGIN','like',date('Y').'-11%')->count();
          $m12_1 = DB::table('gleave_register')->where('LEAVE_TYPE_CODE','=',12)->where('LEAVE_DATE_BEGIN','like',date('Y').'-12%')->count();

          $count1 = DB::table('gleave_register') 
          ->leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_NAME')
          ->where('LEAVE_YEAR_ID','=',$yearbudget)
          ->where('LEAVE_TYPE_CODE','=',1)                          
          ->count();
          $count2 = DB::table('gleave_register') 
          ->leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_NAME')
          ->where('LEAVE_YEAR_ID','=',$yearbudget)
          ->where('LEAVE_TYPE_CODE','=',2)                          
          ->count();
          $count3 = DB::table('gleave_register') 
          ->leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_NAME')
          ->where('LEAVE_YEAR_ID','=',$yearbudget)
          ->where('LEAVE_TYPE_CODE','=',3)                          
          ->count();
          $count4 = DB::table('gleave_register') 
          ->leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_NAME')
          ->where('LEAVE_YEAR_ID','=',$yearbudget)
          ->where('LEAVE_TYPE_CODE','=',4)                          
          ->count();
          $count5 = DB::table('gleave_register') 
          ->leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_NAME')
          ->where('LEAVE_YEAR_ID','=',$yearbudget)
          ->where('LEAVE_TYPE_CODE','=',5)                          
          ->count();
          $count6 = DB::table('gleave_register') 
          ->leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_NAME')
          ->where('LEAVE_YEAR_ID','=',$yearbudget)
          ->where('LEAVE_TYPE_CODE','=',6)                          
          ->count();
          $count7 = DB::table('gleave_register') 
          ->leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_NAME')
          ->where('LEAVE_YEAR_ID','=',$yearbudget)
          ->where('LEAVE_TYPE_CODE','=',7)                          
          ->count();

          $count8 = DB::table('gleave_register') 
          ->leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_NAME')
          ->where('LEAVE_YEAR_ID','=',$yearbudget)
          ->where('LEAVE_TYPE_CODE','=',8)                          
          ->count();
          
          $count9 = DB::table('gleave_register') 
          ->leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_NAME')
          ->where('LEAVE_YEAR_ID','=',$yearbudget)
          ->where('LEAVE_TYPE_CODE','=',9)                          
          ->count();
          $count10 = DB::table('gleave_register') 
          ->leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_NAME')
          ->where('LEAVE_YEAR_ID','=',$yearbudget)
          ->where('LEAVE_TYPE_CODE','=',10)                          
          ->count();
          $count11 = DB::table('gleave_register') 
          ->leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_NAME')
          ->where('LEAVE_YEAR_ID','=',$yearbudget)
          ->where('LEAVE_TYPE_CODE','=',11)                          
          ->count();
          $count12 = DB::table('gleave_register') 
          ->leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_NAME')
          ->where('LEAVE_YEAR_ID','=',$yearbudget)
          ->where('LEAVE_TYPE_CODE','=',12)                          
          ->count();


          $countall1 = DB::table('gleave_register') 
          ->leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_NAME')
          ->where('LEAVE_TYPE_CODE','=',1) 
          ->where('LEAVE_DATE_BEGIN','like',date('Y').'%')                           
          ->count();

  
          $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
          $year_id = $yearbudget;
    
        return view('person_headorg.dashboard_headorg',[
            'm1_1' => $m1_1,
            'm2_1' => $m2_1,
            'm3_1' => $m3_1,
            'm4_1' => $m4_1,
            'm5_1' => $m5_1,
            'm6_1' => $m6_1,
            'm7_1' => $m7_1,
            'm8_1' => $m8_1,
            'm9_1' => $m9_1,
            'm10_1' => $m10_1,
            'm11_1' => $m11_1,
            'm12_1' => $m12_1,
  
            'count1' => $count1,
            'count2' => $count2,
            'count3' => $count3,
            'count4' => $count4,
            'count5' => $count5,
            'count6' => $count6,
            'count7' => $count7,
            'count8' => $count8,
            'count9' => $count9,
            'count10' => $count10,
            'count11' => $count11,
            'count12' => $count12,
             'countall1' => $countall1,
            'amount_1' => $amount_1,
            'amount_2' => $amount_2,
            'amount_3' => $amount_3,
            'amount_4' => $amount_4,
            'leave_amount_1' => $leave_amount_1,
            'leave_amount_2' => $leave_amount_2,
            'leave_amount_3' => $leave_amount_3,
            'leave_amount_4' => $leave_amount_4,     
            'perdev_amount_1' => $perdev_amount_1,
            'perdev_amount_2' => $perdev_amount_2,
            'perdev_amount_3' => $perdev_amount_3,
            'perdev_amount_4' => $perdev_amount_4,
            'perdev_amount_5' => $perdev_amount_5,
            'perdev_amount_6' => $perdev_amount_6,
            'groupworks' => $groupwork,
            'grouppersons' => $groupperson,
            'man' => $man,
            'women' => $women,
            'positions' => $position,
            'units' => $unit,
            'budgets' =>  $budget,
            'year_id'=>$year_id 
        ]);
    }

  
//===============================หนังสือ==============================

public function infobook()
{
    $iduser  = Auth::user()->PERSON_ID; 
    $date = date('Y-m-d');

    //----------------------หนังสือรับ

    $infobookreceipt = Bookindex::leftJoin('grecord_org','gbook_index.BOOK_ORG_ID','=','grecord_org.RECORD_ORG_ID')
    ->leftJoin('hrd_person','gbook_index.PERSON_SAVE_ID','=','hrd_person.ID')
    ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->leftJoin('gbook_index_send_leader','gbook_index.BOOK_ID','=','gbook_index_send_leader.BOOK_LD_ID')
    ->where('SEND_STATUS','=',4)
    ->where('BOOK_USE','=','true')
    ->orderBy('gbook_index.BOOK_ID', 'desc') 
    ->get();

    $infobooksend = DB::table('hrd_person')
    ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->where('hrd_person.ID','=',$iduser)
    ->first();

    //----------------------หนังสือส่ง

    $inforbookinside = Booksendinside::leftJoin('gbook_index_inside','gbook_index_inside.BOOK_ID','=','gbook_send_inside.BOOK_ID')
    ->where('gbook_send_inside.HR_PERSON_ID','=',$iduser )
    ->where('SEND_STATUS','=',4)
    ->where('BOOK_USE','=','true')
    ->orderBy('gbook_send_inside.BOOK_ID', 'desc') 
    ->get();


    //----------------------------------

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
    $status = '4';
    $search = '';
    $year_id = $yearbudget;

    $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

    return view('person_headorg.headorg_book',[
        'infobookreceipts' =>$infobookreceipt,
        'inforbookinsides' =>$inforbookinside,
        'infobookstatus1'=> $infobookstatus1, 
        'infobookstatus2'=> $infobookstatus2,
        'infobookstatus3'=> $infobookstatus3,
        'infobooksend'=>   $infobooksend,
        'infobook_sendstatuss'=>   $infobook_sendstatus,
        'displaydate_bigen'=> $displaydate_bigen, 
        'displaydate_end'=> $displaydate_end,
        'status_check'=> $status,
        'search'=> $search,
        'year_id'=>$year_id,
        'budgets' =>  $budget,
       ]);
}



public function infobooksearch(Request $request)
{

    $iduser  = Auth::user()->PERSON_ID; 
    $date = date('Y-m-d');

    $search = $request->get('search');
    $status = $request->SEND_STATUS;
    $datebigin = $request->get('DATE_BIGIN');
    $dateend = $request->get('DATE_END');
    $yearbudget = $request->YEAR_ID;

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
    $displaydate_bigen= $y."-".$m."-".$d." 00:00:00";

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
    $displaydate_end= $y_e."-".$m_e."-".$d_e." 23:59:59";



    $date = date('Y-m-d');
    $date_bigen_checks = strtotime($displaydate_bigen);
    $date_end_checks =  strtotime($displaydate_end);
    $dates =  strtotime($date);


        $from = date($displaydate_bigen);
        $to = date($displaydate_end);

       

        if($status == null){
            $infobookreceipt=  Bookindex::leftJoin('grecord_org','gbook_index.BOOK_ORG_ID','=','grecord_org.RECORD_ORG_ID')
            ->leftJoin('hrd_person','gbook_index.PERSON_SAVE_ID','=','hrd_person.ID')
            ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
            ->leftJoin('gbook_index_send_leader','gbook_index.BOOK_ID','=','gbook_index_send_leader.BOOK_LD_ID')
            ->where('BOOK_USE','=','true')
            ->where(function($q) use ($search){
                        $q->where('BOOK_NUM_IN','like','%'.$search.'%');
                        $q->orwhere('BOOK_NUMBER','like','%'.$search.'%');
                        $q->orwhere('BOOK_NAME','like','%'.$search.'%');
  
            })
            ->WhereBetween('DATE_SAVE',[$from,$to]) 
            ->orderBy('gbook_index.DATE_SAVE', 'desc')    
            ->get();
        }else{
            $infobookreceipt=  Bookindex::leftJoin('grecord_org','gbook_index.BOOK_ORG_ID','=','grecord_org.RECORD_ORG_ID')
            ->leftJoin('hrd_person','gbook_index.PERSON_SAVE_ID','=','hrd_person.ID')
            ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
            ->leftJoin('gbook_index_send_leader','gbook_index.BOOK_ID','=','gbook_index_send_leader.BOOK_LD_ID')
            ->where('BOOK_USE','=','true')
                ->where('SEND_STATUS','=',$status)
                ->where(function($q) use ($search){
                    $q->where('BOOK_NUM_IN','like','%'.$search.'%');
                    $q->orwhere('BOOK_NUMBER','like','%'.$search.'%');
                    $q->orwhere('BOOK_NAME','like','%'.$search.'%');
                })
                ->WhereBetween('DATE_SAVE',[$from,$to]) 
                ->orderBy('gbook_index.DATE_SAVE', 'desc')    
                ->get();

        }


    
    

    //---------------------------หนังสือส่ง

  

        $from = date($displaydate_bigen);
        $to = date($displaydate_end);

        if($status == null){

            $inforbookinside = Booksendinside::leftJoin('gbook_index_inside','gbook_index_inside.BOOK_ID','=','gbook_send_inside.BOOK_ID')
            ->leftJoin('grecord_org','gbook_index_inside.BOOK_ORG_ID','=','grecord_org.RECORD_ORG_ID')
            ->leftJoin('hrd_person','gbook_index_inside.PERSON_SAVE_ID','=','hrd_person.ID')
            ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
            ->leftJoin('gbook_send_inside_leader','gbook_index_inside.BOOK_ID','=','gbook_send_inside_leader.BOOK_LD_ID')
            ->where('gbook_send_inside.HR_PERSON_ID','=',$iduser )
            ->where('BOOK_USE','=','true')
            ->where(function($q) use ($search){
                        $q->where('BOOK_NUM_IN','like','%'.$search.'%');
                        $q->orwhere('BOOK_NUMBER','like','%'.$search.'%');
                        $q->orwhere('BOOK_NAME','like','%'.$search.'%');
  
            })
            ->WhereBetween('DATE_SAVE',[$from,$to]) 
            ->orderBy('gbook_send_inside.BOOK_ID', 'desc') 
            ->get();
      
            
         
        }else{

            $inforbookinside = Booksendinside::leftJoin('gbook_index_inside','gbook_index_inside.BOOK_ID','=','gbook_send_inside.BOOK_ID')
            ->leftJoin('grecord_org','gbook_index_inside.BOOK_ORG_ID','=','grecord_org.RECORD_ORG_ID')
            ->leftJoin('hrd_person','gbook_index_inside.PERSON_SAVE_ID','=','hrd_person.ID')
            ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
            ->leftJoin('gbook_send_inside_leader','gbook_index_inside.BOOK_ID','=','gbook_send_inside_leader.BOOK_LD_ID')
            ->where('gbook_send_inside.HR_PERSON_ID','=',$iduser )
            ->where('BOOK_USE','=','true')
            ->where('SEND_STATUS','=',$status)
            ->where(function($q) use ($search){
                        $q->where('BOOK_NUM_IN','like','%'.$search.'%');
                        $q->orwhere('BOOK_NUMBER','like','%'.$search.'%');
                        $q->orwhere('BOOK_NAME','like','%'.$search.'%');
  
            })
            ->WhereBetween('DATE_SAVE',[$from,$to]) 
            ->orderBy('gbook_send_inside.BOOK_ID', 'desc') 
            ->get();

        }



    //--------------------

    
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


    $iduser  = Auth::user()->PERSON_ID; 
    $infobooksend = DB::table('hrd_person')
    ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->where('hrd_person.ID','=',$iduser)
    ->first();

  
    $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
    
    $year_id = $yearbudget;

    return view('person_headorg.headorg_book',[
        'infobookreceipts' =>$infobookreceipt,
        'inforbookinsides' =>$inforbookinside,
        'infobookstatus1'=> $infobookstatus1, 
        'infobookstatus2'=> $infobookstatus2,
        'infobookstatus3'=> $infobookstatus3,
        'infobooksend'=>   $infobooksend,
        'infobook_sendstatuss'=> $infobook_sendstatus,
        'displaydate_bigen'=> $displaydate_bigen, 
        'displaydate_end'=> $displaydate_end,
        'status_check'=> $status,
        'search'=> $search,
        'year_id'=>$year_id,
        'budgets' =>  $budget,
        
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
             $infordepartmentsub  =  DB::table('hrd_department_sub')->get();

             $inforsenddepartmentsubs =  DB::table('gbook_send_sub')
             ->where('BOOK_ID','=',$idbook)
             ->get(); 
  
             $checksendinfordepartmentsub = DB::table('gbook_send_sub')
             ->where('BOOK_ID','=',$idbook)
             ->count(); 

            //--------------------------------------------
             $infordepartmentsubsub  =  DB::table('hrd_department_sub_sub')->get();

             $inforsenddepartmentsubsubs =  DB::table('gbook_send_sub_sub')
             ->where('BOOK_ID','=',$idbook)
             ->get(); 
  
             $checksendinfordepartmentsubsub = DB::table('gbook_send_sub_sub')
             ->where('BOOK_ID','=',$idbook)
             ->count(); 
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

         return view('person_headorg.infobookreceipt_control',[
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
 
         return redirect()->route('horg.infobook');
     }


     public function saveretire(Request $request)
     {
      
         $date = date('Y-m-d');
         $datetime = date('Y-m-d H:i:s');
         
         $info_org = DB::table('info_org')->first();
         $bookid = $request->BOOK_ID;
         
     
                      
          if($request->SEND_LD_ID == null){
            $addretire = new Bookindexsendleader();    
            $addretire->BOOK_LD_ID = $bookid;
            $addretire->TOP_LEADER_AC_ID = $info_org->ORG_LEADER_ID;
            $addretire->TOP_LEADER_AC_NAME = $info_org->ORG_LEADER;
            $addretire->TOP_LEADER_AC_CMD = $request->TOP_LEADER_AC_CMD;
            $addretire->TOP_LEADER_AC_DATE = $date;
            $addretire->TOP_LEADER_AC_DATE_TIME = $datetime;
            $addretire->SEND_LD_STATUS = 'YES';
            $addretire->save();

          }else{
            $addretire = Bookindexsendleader::find($request->SEND_LD_ID);
            $addretire->TOP_LEADER_AC_ID = $info_org->ORG_LEADER_ID;
            $addretire->TOP_LEADER_AC_NAME = $info_org->ORG_LEADER;
            $addretire->TOP_LEADER_AC_CMD = $request->TOP_LEADER_AC_CMD;
            $addretire->TOP_LEADER_AC_DATE = $date;
            $addretire->TOP_LEADER_AC_DATE_TIME = $datetime;
            $addretire->SEND_LD_STATUS =   'YES';
            $addretire->save();

          }            

  
 
         $addpresentupstatus = Bookindex::find($request->BOOK_ID);
         $addpresentupstatus->SEND_STATUS = '3';
         $addpresentupstatus->save();
         
 
 
         return redirect()->route('horg.infobookreceiptcontrol',[
             'id' => $bookid
         ]);
     }

     public function infobookentinsidecontrol(Request $request,$id)
     {
        $iduser  = Auth::user()->PERSON_ID; 
         
       $infobooksend = DB::table('hrd_person')
       ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
       ->where('hrd_person.ID','=',$iduser)
       ->first();


        $idbook = $id;
           

        $infobookreceiptview = Bookindexinside::leftJoin('grecord_org','gbook_index_inside.BOOK_ORG_ID','=','grecord_org.RECORD_ORG_ID')
        ->leftJoin('hrd_person','gbook_index_inside.PERSON_SAVE_ID','=','hrd_person.ID')
        ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('gbook_send_inside_leader','gbook_index_inside.BOOK_ID','=','gbook_send_inside_leader.BOOK_LD_ID')
        ->leftJoin('gbook_instant','gbook_index_inside.BOOK_URGENT_ID','=','gbook_instant.INSTANT_ID')
        ->where('gbook_index_inside.BOOK_ID','=',$idbook)
        ->first();


         
         $bookdepartment = DB::table('hrd_department')->get();
         $bookdepartmentsub  = DB::table('hrd_department_sub')->get();
         $bookdepartmentsubsub  = DB::table('hrd_department_sub_sub')->get();


         //-----------ความเห็น-----------------
         $checksendleader = DB::table('gbook_send_inside_leader')
         ->where('BOOK_LD_ID','=',$idbook)
         ->count(); 

         if($checksendleader !== 0 ){
           $sendleaderquery  = DB::table('gbook_send_inside_leader')
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

          $booksend = DB::table('gbook_send_inside_depart')->where('BOOK_ID','=',$idbook)->get();
          $booksendsub = DB::table('gbook_send_inside_sub')->where('BOOK_ID','=',$idbook)->get();
          $booksendsubsub = DB::table('gbook_send_inside_sub_sub')->where('BOOK_ID','=',$idbook)->get();
      
             //--------------------------------------------
             $infordepartment  =  DB::table('hrd_department')->get();

             $inforsenddepartments =  DB::table('gbook_send_inside_depart')
             ->where('BOOK_ID','=',$idbook)
             ->get(); 
  
             $checksendinfordepartment = DB::table('gbook_send_inside_depart')
             ->where('BOOK_ID','=',$idbook)
             ->count(); 
  
              //--------------------------------------------

                //--------------------------------------------
             $infordepartmentsub  =  DB::table('hrd_department_sub')->get();

             $inforsenddepartmentsubs =  DB::table('gbook_send_inside_sub')
             ->where('BOOK_ID','=',$idbook)
             ->get(); 
  
             $checksendinfordepartmentsub = DB::table('gbook_send_inside_sub')
             ->where('BOOK_ID','=',$idbook)
             ->count(); 

            //--------------------------------------------
             $infordepartmentsubsub  =  DB::table('hrd_department_sub_sub')->get();

             $inforsenddepartmentsubsubs =  DB::table('gbook_send_inside_sub_sub')
             ->where('BOOK_ID','=',$idbook)
             ->get(); 
  
             $checksendinfordepartmentsubsub = DB::table('gbook_send_inside_sub_sub')
             ->where('BOOK_ID','=',$idbook)
             ->count(); 
          //--------------------------------------------
          $inforposition  =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')->get();

          $infosendbooks =  DB::table('gbook_send_inside')
          ->where('BOOK_ID','=',$idbook)
          ->where('SEND_TYPE','=','4')
          ->get(); 

          $checksendbookper = DB::table('gbook_send_inside')
          ->where('BOOK_ID','=',$idbook)
          ->where('SEND_TYPE','=','4')
         ->count(); 

           //--------------------------------------------

           
          $infororg  =  Recordorg::get();

          $infosendbookorg =  DB::table('gbook_send_inside_org')
          ->where('BOOK_ID','=',$idbook)
          ->get(); 

          $checksendbookorg = DB::table('gbook_send_inside_org')
          ->where('BOOK_ID','=',$idbook)
         ->count(); 

          //--------------------------------------------

         return view('person_headorg.infobookinside_control',[
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
             'inforsenddepartmentsubsubs' => $inforsenddepartmentsubsubs,
             'infororgs' => $infororg,
             'checksendbookorg' => $checksendbookorg,
             'infosendbookorgs' => $infosendbookorg,
      
            ]);
     }



     public function sendinside(Request $request)
     {
         $iduser = $request->ID_USER;
         $bookid = $request->BOOK_ID;
         $SEND_BY_ID = $request->SEND_BY_ID;
         $SEND_BY_NAME = $request->SEND_BY_NAME;
  
         Booksendinsidedepart::where('BOOK_ID','=',$bookid)->delete(); 
         Booksendinsidedepartsub::where('BOOK_ID','=',$bookid)->delete();
         Booksendinsidedepartsubsub::where('BOOK_ID','=',$bookid)->delete();  
         Booksendinsideorg::where('BOOK_ID','=',$bookid)->delete();  

     if($request->row3 != '' || $request->row3 != null){
         $row3 = $request->row3;
         $number_3 =count($row3);
         $count_3 = 0;
         for($count_3 = 0; $count_3 < $number_3; $count_3++)
         {  
          
            $add_3 = new Booksendinsidedepart();
            $add_3->BOOK_ID = $bookid;
            $add_3->HR_DEPARTMENT_ID = $row3[$count_3];
            $add_3->save(); 
          
            $inforpersonusers =  Person::where('HR_DEPARTMENT_ID','=',$row3[$count_3])->get(); 
  
            foreach($inforpersonusers as $inforpersonuser){

                $check3 = DB::table('gbook_send_inside')
                ->where('BOOK_ID','=',$bookid)
                ->where('HR_PERSON_ID','=',$inforpersonuser->ID)
                ->count(); 
    
                if($check3== 0){
             
                     $add_person3 = new Booksendinside();
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
            $add_4 = new Booksendinsidedepartsub();
            $add_4->BOOK_ID = $bookid;
            $add_4->HR_DEPARTMENT_SUB_ID = $row4[$count_4];
            $add_4->save(); 
  
            //------เช็คตัวซ้ำก่อน------
  
            $inforpersonusers_4 =  Person::where('HR_DEPARTMENT_SUB_ID','=',$row4[$count_4])->get(); 
  
            foreach($inforpersonusers_4 as $inforpersonuser_4){
                    
                  $check4 = DB::table('gbook_send_inside')
                  ->where('BOOK_ID','=',$bookid)
                  ->where('HR_PERSON_ID','=',$inforpersonuser_4->ID)
                  ->count(); 
                   
                 
                 if($check4== 0){
                     $add_person4 = new Booksendinside();
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
            $add_5 = new Booksendinsidedepartsubsub();
            $add_5->BOOK_ID = $bookid;
            $add_5->HR_DEPARTMENT_SUB_SUB_ID = $row5[$count_5];
            $add_5->save(); 
  
             //------เช็คตัวซ้ำก่อน------
  
             $inforpersonusers_5 =  Person::where('HR_DEPARTMENT_SUB_SUB_ID','=',$row5[$count_5])->get(); 
  
             foreach($inforpersonusers_5 as $inforpersonuser_5){
                     
                   $check5 = DB::table('gbook_send_inside')
                   ->where('BOOK_ID','=',$bookid)
                   ->where('HR_PERSON_ID','=',$inforpersonuser_5->ID)
                   ->count(); 
                    
                  
                  if($check5== 0){
                      $add_person5 = new Booksendinside();
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
  
         $check6 = DB::table('gbook_send_inside')
         ->where('BOOK_ID','=',$bookid)
         ->where('HR_PERSON_ID','=',$MEMBER_ID[$count])
         ->count(); 
          
        
        if($check6== 0){
  
         $add_person6 = new Booksendinside();
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

     if($request->ORG_ID != '' || $request->ORG_ID != null){
  
        $ORG_ID = $request->ORG_ID;
        $number_7 =count($ORG_ID);
        $count_7 = 0;
        for($count_7 = 0; $count_7 < $number_7; $count_7++)
        {  
     
     
            $add_org = new Booksendinsideorg();
            $add_org->BOOK_ID = $bookid;
            $add_org->ORG_ID = $ORG_ID[$count_7];
            $add_org->save();
     
           }
     
     
        }
  
   
  
         return redirect()->route('horg.infobook');
     }
  

     public function saveretireinside(Request $request)
     {
        
         $date = date('Y-m-d');
         $datetime = date('Y-m-d H:i:s');
         
         $info_org = DB::table('info_org')->first();
         $bookid = $request->BOOK_ID;
         
   
                      
         $addretire = Booksendinsideleader::find($request->SEND_LD_ID);
         $addretire->TOP_LEADER_AC_ID = $info_org->ORG_LEADER_ID;
         $addretire->TOP_LEADER_AC_NAME = $info_org->ORG_LEADER;
         $addretire->TOP_LEADER_AC_CMD = $request->TOP_LEADER_AC_CMD;
         $addretire->TOP_LEADER_AC_DATE = $date;
         $addretire->TOP_LEADER_AC_DATE_TIME = $datetime;
         $addretire->SEND_LD_STATUS = 'ํYES';
         $addretire->save();
 
         $addpresentupstatus = Bookindexinside::find($request->BOOK_ID);
         $addpresentupstatus->SEND_STATUS = '3';
         $addpresentupstatus->save();
         
 
         $iduser = $request->ID_USER;
         return redirect()->route('horg.infobookentinsidecontrol',[
             'id' => $bookid,
         ]);
     }



//========================หน้าอนุมัติลา

public function infoleave(Request $request)
{
  
    $inforleave=  Leave_register::select('gleave_register.ID','STATUS_CODE','STATUS_NAME','LEAVE_YEAR_ID','LEAVE_PERSON_FULLNAME','POSITION_IN_WORK','HR_DEPARTMENT_SUB_SUB_NAME','LEAVE_TYPE_NAME','LEAVE_BECAUSE','LEAVE_DATE_BEGIN','LEAVE_DATE_END','WORK_DO','LEAVE_WORK_SEND','USER_CONFIRM_CHECK','LEAVE_YEAR_ID','LEAVE_PERSON_FULLNAME','LEAVE_BECAUSE','LOCATION_NAME','LEAVE_WORK_SEND','DAY_TYPE_ID','LEAVE_DATE_BEGIN','LEAVE_DATE_END','LEAVE_CONTACT_PHONE','LEAVE_CONTACT','LEAVE_SUM_ALL','LEAVE_SUM_SETSUN','LEAVE_SUM_HOLIDAY','LEAVE_APP_H1','LEAVE_APP_H2')
    ->leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_ID')
    ->leftJoin('hrd_person','gleave_register.LEAVE_PERSON_ID','=','hrd_person.ID')
    ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
    ->leftJoin('gleave_status','gleave_register.LEAVE_STATUS_CODE','=','gleave_status.STATUS_CODE')
    ->leftJoin('gleave_location','gleave_register.LOCATION_ID','=','gleave_location.LOCATION_ID')
    ->where('LEAVE_STATUS_CODE','=','Verify')
    ->orderBy('gleave_register.ID', 'desc')
    ->get();
    

    $infostatus =  LeaveStatus::get();

    $m_budget = date("m");
    if($m_budget>9){
    $yearbudget = date("Y")+544;
    }else{
    $yearbudget = date("Y")+543;
    }


        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';
        $status = 'Verify';
        $search = '';
        $year_id = $yearbudget;

        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

    return view('person_headorg.headorg_leave',[
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






public function headorg_leave_app(Request $request,$idref)
{
  
    $inforleave_refapp=  Leave_register::select('gleave_register.ID','STATUS_CODE','STATUS_NAME','LEAVE_YEAR_ID','LEAVE_PERSON_FULLNAME','POSITION_IN_WORK','HR_DEPARTMENT_SUB_SUB_NAME','LEAVE_TYPE_NAME','LEAVE_BECAUSE','LEAVE_DATE_BEGIN','LEAVE_DATE_END','WORK_DO','LEAVE_WORK_SEND','USER_CONFIRM_CHECK','LEAVE_YEAR_ID','LEAVE_PERSON_FULLNAME','LEAVE_BECAUSE','LOCATION_NAME','LEAVE_WORK_SEND','DAY_TYPE_ID','LEAVE_DATE_BEGIN','LEAVE_DATE_END','LEAVE_CONTACT_PHONE','LEAVE_CONTACT','LEAVE_SUM_ALL','LEAVE_SUM_SETSUN','LEAVE_SUM_HOLIDAY','LEAVE_APP_H1','LEAVE_APP_H2')
    ->leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_ID')
    ->leftJoin('hrd_person','gleave_register.LEAVE_PERSON_ID','=','hrd_person.ID')
    ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
    ->leftJoin('gleave_status','gleave_register.LEAVE_STATUS_CODE','=','gleave_status.STATUS_CODE')
    ->leftJoin('gleave_location','gleave_register.LOCATION_ID','=','gleave_location.LOCATION_ID')
    ->where('gleave_register.ID','=',$idref)
    ->first();
    

    

    return view('person_headorg.headorg_leave_app',[
        'inforleave' => $inforleave_refapp,

    ]);
}




public function searchinfoleave(Request $request)
    {
        $search = $request->get('search');
        $status = $request->STATUS_CODE;
        $datebigin = $request->get('DATE_BIGIN');
        $dateend = $request->get('DATE_END');
        $yearbudget = $request->YEAR_ID;

        $iduser  = Auth::user()->PERSON_ID; 

        if($search==''){
            $search="";
        }

        $check = Permislist::where('PERSON_ID','=',$iduser)
            ->where('PERMIS_ID','=','HORG')
            ->count();

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
            $displaydate_bigen= $y."-".$m."-".$d." 00:00:00";
      
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
            $displaydate_end= $y_e."-".$m_e."-".$d_e." 23:59:59";

            $from = date($displaydate_bigen);
            $to = date($displaydate_end);


    if($status == null){

        if($check !=0){
        $inforleave=  Leave_register::select('gleave_register.ID','STATUS_CODE','STATUS_NAME','LEAVE_YEAR_ID','LEAVE_PERSON_FULLNAME','POSITION_IN_WORK','HR_DEPARTMENT_SUB_SUB_NAME','LEAVE_TYPE_NAME','LEAVE_BECAUSE','LEAVE_DATE_BEGIN','LEAVE_DATE_END','WORK_DO','LEAVE_WORK_SEND','USER_CONFIRM_CHECK','LEAVE_YEAR_ID','LEAVE_PERSON_FULLNAME','LEAVE_BECAUSE','LOCATION_NAME','LEAVE_WORK_SEND','DAY_TYPE_ID','LEAVE_DATE_BEGIN','LEAVE_DATE_END','LEAVE_CONTACT_PHONE','LEAVE_CONTACT','LEAVE_SUM_ALL','LEAVE_SUM_SETSUN','LEAVE_SUM_HOLIDAY','LEAVE_APP_H1','LEAVE_APP_H2')
        ->leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_ID')
        ->leftJoin('hrd_person','gleave_register.LEAVE_PERSON_ID','=','hrd_person.ID')
        ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->leftJoin('gleave_status','gleave_register.LEAVE_STATUS_CODE','=','gleave_status.STATUS_CODE')
        ->leftJoin('gleave_location','gleave_register.LOCATION_ID','=','gleave_location.LOCATION_ID')
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
            $inforleave=  Leave_register::select('gleave_register.ID','STATUS_CODE','STATUS_NAME','LEAVE_YEAR_ID','LEAVE_PERSON_FULLNAME','POSITION_IN_WORK','HR_DEPARTMENT_SUB_SUB_NAME','LEAVE_TYPE_NAME','LEAVE_BECAUSE','LEAVE_DATE_BEGIN','LEAVE_DATE_END','WORK_DO','LEAVE_WORK_SEND','USER_CONFIRM_CHECK','LEAVE_YEAR_ID','LEAVE_PERSON_FULLNAME','LEAVE_BECAUSE','LOCATION_NAME','LEAVE_WORK_SEND','DAY_TYPE_ID','LEAVE_DATE_BEGIN','LEAVE_DATE_END','LEAVE_CONTACT_PHONE','LEAVE_CONTACT','LEAVE_SUM_ALL','LEAVE_SUM_SETSUN','LEAVE_SUM_HOLIDAY','LEAVE_APP_H1','LEAVE_APP_H2')
            ->leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_ID')
            ->leftJoin('hrd_person','gleave_register.LEAVE_PERSON_ID','=','hrd_person.ID')
            ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
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
        }

    }else{

        if($check !=0){
            $inforleave=  Leave_register::select('gleave_register.ID','STATUS_CODE','STATUS_NAME','LEAVE_YEAR_ID','LEAVE_PERSON_FULLNAME','POSITION_IN_WORK','HR_DEPARTMENT_SUB_SUB_NAME','LEAVE_TYPE_NAME','LEAVE_BECAUSE','LEAVE_DATE_BEGIN','LEAVE_DATE_END','WORK_DO','LEAVE_WORK_SEND','USER_CONFIRM_CHECK','LEAVE_YEAR_ID','LEAVE_PERSON_FULLNAME','LEAVE_BECAUSE','LOCATION_NAME','LEAVE_WORK_SEND','DAY_TYPE_ID','LEAVE_DATE_BEGIN','LEAVE_DATE_END','LEAVE_CONTACT_PHONE','LEAVE_CONTACT','LEAVE_SUM_ALL','LEAVE_SUM_SETSUN','LEAVE_SUM_HOLIDAY','LEAVE_APP_H1','LEAVE_APP_H2')
            ->leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_ID')
            ->leftJoin('hrd_person','gleave_register.LEAVE_PERSON_ID','=','hrd_person.ID')
            ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
            ->leftJoin('gleave_status','gleave_register.LEAVE_STATUS_CODE','=','gleave_status.STATUS_CODE')
            ->leftJoin('gleave_location','gleave_register.LOCATION_ID','=','gleave_location.LOCATION_ID')
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
            }else{
                $inforleave=  Leave_register::select('gleave_register.ID','STATUS_CODE','STATUS_NAME','LEAVE_YEAR_ID','LEAVE_PERSON_FULLNAME','POSITION_IN_WORK','HR_DEPARTMENT_SUB_SUB_NAME','LEAVE_TYPE_NAME','LEAVE_BECAUSE','LEAVE_DATE_BEGIN','LEAVE_DATE_END','WORK_DO','LEAVE_WORK_SEND','USER_CONFIRM_CHECK','LEAVE_YEAR_ID','LEAVE_PERSON_FULLNAME','LEAVE_BECAUSE','LOCATION_NAME','LEAVE_WORK_SEND','DAY_TYPE_ID','LEAVE_DATE_BEGIN','LEAVE_DATE_END','LEAVE_CONTACT_PHONE','LEAVE_CONTACT','LEAVE_SUM_ALL','LEAVE_SUM_SETSUN','LEAVE_SUM_HOLIDAY','LEAVE_APP_H1','LEAVE_APP_H2')
                ->leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_ID')
                ->leftJoin('hrd_person','gleave_register.LEAVE_PERSON_ID','=','hrd_person.ID')
                ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
                ->leftJoin('gleave_status','gleave_register.LEAVE_STATUS_CODE','=','gleave_status.STATUS_CODE')
                ->leftJoin('gleave_location','gleave_register.LOCATION_ID','=','gleave_location.LOCATION_ID')
                ->where('LEAVE_STATUS_CODE','=',$status)
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
            }


    }

    }else{

    if($status == null){
        if($check !=0){
            $inforleave=  Leave_register::select('gleave_register.ID','STATUS_CODE','STATUS_NAME','LEAVE_YEAR_ID','LEAVE_PERSON_FULLNAME','POSITION_IN_WORK','HR_DEPARTMENT_SUB_SUB_NAME','LEAVE_TYPE_NAME','LEAVE_BECAUSE','LEAVE_DATE_BEGIN','LEAVE_DATE_END','WORK_DO','LEAVE_WORK_SEND','USER_CONFIRM_CHECK','LEAVE_YEAR_ID','LEAVE_PERSON_FULLNAME','LEAVE_BECAUSE','LOCATION_NAME','LEAVE_WORK_SEND','DAY_TYPE_ID','LEAVE_DATE_BEGIN','LEAVE_DATE_END','LEAVE_CONTACT_PHONE','LEAVE_CONTACT','LEAVE_SUM_ALL','LEAVE_SUM_SETSUN','LEAVE_SUM_HOLIDAY','LEAVE_APP_H1','LEAVE_APP_H2')
            ->leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_ID')
            ->leftJoin('hrd_person','gleave_register.LEAVE_PERSON_ID','=','hrd_person.ID')
            ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
            ->leftJoin('gleave_status','gleave_register.LEAVE_STATUS_CODE','=','gleave_status.STATUS_CODE')
            ->leftJoin('gleave_location','gleave_register.LOCATION_ID','=','gleave_location.LOCATION_ID')
            ->where(function($q) use ($search){
                $q->where('LEAVE_YEAR_ID','like','%'.$search.'%');
                $q->orwhere('LEAVE_PERSON_FULLNAME','like','%'.$search.'%');
                $q->orwhere('LEAVE_TYPE_NAME','like','%'.$search.'%');
                $q->orwhere('LEAVE_BECAUSE','like','%'.$search.'%');
            })
            ->orderBy('gleave_register.ID', 'desc')
            ->get();
        }else{
           
            $inforleave=  Leave_register::select('gleave_register.ID','STATUS_CODE','STATUS_NAME','LEAVE_YEAR_ID','LEAVE_PERSON_FULLNAME','POSITION_IN_WORK','HR_DEPARTMENT_SUB_SUB_NAME','LEAVE_TYPE_NAME','LEAVE_BECAUSE','LEAVE_DATE_BEGIN','LEAVE_DATE_END','WORK_DO','LEAVE_WORK_SEND','USER_CONFIRM_CHECK','LEAVE_YEAR_ID','LEAVE_PERSON_FULLNAME','LEAVE_BECAUSE','LOCATION_NAME','LEAVE_WORK_SEND','DAY_TYPE_ID','LEAVE_DATE_BEGIN','LEAVE_DATE_END','LEAVE_CONTACT_PHONE','LEAVE_CONTACT','LEAVE_SUM_ALL','LEAVE_SUM_SETSUN','LEAVE_SUM_HOLIDAY','LEAVE_APP_H1','LEAVE_APP_H2')
            ->leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_ID')
            ->leftJoin('hrd_person','gleave_register.LEAVE_PERSON_ID','=','hrd_person.ID')
            ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
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
        }
    }else{

        if($check !=0){
            $inforleave=  Leave_register::select('gleave_register.ID','STATUS_CODE','STATUS_NAME','LEAVE_YEAR_ID','LEAVE_PERSON_FULLNAME','POSITION_IN_WORK','HR_DEPARTMENT_SUB_SUB_NAME','LEAVE_TYPE_NAME','LEAVE_BECAUSE','LEAVE_DATE_BEGIN','LEAVE_DATE_END','WORK_DO','LEAVE_WORK_SEND','USER_CONFIRM_CHECK','LEAVE_YEAR_ID','LEAVE_PERSON_FULLNAME','LEAVE_BECAUSE','LOCATION_NAME','LEAVE_WORK_SEND','DAY_TYPE_ID','LEAVE_DATE_BEGIN','LEAVE_DATE_END','LEAVE_CONTACT_PHONE','LEAVE_CONTACT','LEAVE_SUM_ALL','LEAVE_SUM_SETSUN','LEAVE_SUM_HOLIDAY','LEAVE_APP_H1','LEAVE_APP_H2')
            ->leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_ID')
            ->leftJoin('hrd_person','gleave_register.LEAVE_PERSON_ID','=','hrd_person.ID')
            ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
            ->leftJoin('gleave_status','gleave_register.LEAVE_STATUS_CODE','=','gleave_status.STATUS_CODE')
            ->leftJoin('gleave_location','gleave_register.LOCATION_ID','=','gleave_location.LOCATION_ID')
            ->where('LEAVE_STATUS_CODE','=',$status)
            ->where(function($q) use ($search){
                $q->where('LEAVE_YEAR_ID','like','%'.$search.'%');
                $q->orwhere('LEAVE_PERSON_FULLNAME','like','%'.$search.'%');
                $q->orwhere('LEAVE_TYPE_NAME','like','%'.$search.'%');
                $q->orwhere('LEAVE_BECAUSE','like','%'.$search.'%');
            })
            ->orderBy('gleave_register.ID', 'desc')
            ->get();
        }else{

            $inforleave = Leave_register::select('gleave_register.ID','STATUS_CODE','STATUS_NAME','LEAVE_YEAR_ID','LEAVE_PERSON_FULLNAME','POSITION_IN_WORK','HR_DEPARTMENT_SUB_SUB_NAME','LEAVE_TYPE_NAME','LEAVE_BECAUSE','LEAVE_DATE_BEGIN','LEAVE_DATE_END','WORK_DO','LEAVE_WORK_SEND','USER_CONFIRM_CHECK','LEAVE_YEAR_ID','LEAVE_PERSON_FULLNAME','LEAVE_BECAUSE','LOCATION_NAME','LEAVE_WORK_SEND','DAY_TYPE_ID','LEAVE_DATE_BEGIN','LEAVE_DATE_END','LEAVE_CONTACT_PHONE','LEAVE_CONTACT','LEAVE_SUM_ALL','LEAVE_SUM_SETSUN','LEAVE_SUM_HOLIDAY','LEAVE_APP_H1','LEAVE_APP_H2')
             ->leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_ID')
            ->leftJoin('hrd_person','gleave_register.LEAVE_PERSON_ID','=','hrd_person.ID')
            ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
            ->leftJoin('gleave_status','gleave_register.LEAVE_STATUS_CODE','=','gleave_status.STATUS_CODE')
            ->leftJoin('gleave_location','gleave_register.LOCATION_ID','=','gleave_location.LOCATION_ID')
            ->wherer('LEAVE_STATUS_CODE','=',$status)
            ->where('LEADER_PERSON_ID','=',$iduser)
            ->where(function($q) use ($search){
                $q->where('LEAVE_YEAR_ID','like','%'.$search.'%');
                $q->orwhere('LEAVE_PERSON_FULLNAME','like','%'.$search.'%');
                $q->orwhere('LEAVE_TYPE_NAME','like','%'.$search.'%');
                $q->orwhere('LEAVE_BECAUSE','like','%'.$search.'%');
            })
            ->orderBy('gleave_register.ID','desc')
            ->get();

        }
    }

}

         $infostatus =  LeaveStatus::get();
         $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
         $year_id = $yearbudget;


         return view('person_headorg.headorg_leave',[
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



    
public function updatelastapp(Request $request)
{
    $id = $request->ID;
    $check =  $request->SUBMIT;
    

    if($check == 'approved'){
      $statuscode = 'Allow';
      $textresult = 'ได้รับการอนุมัติ';
    }else{
      $statuscode = 'Disallow';
      $textresult = 'ไม่ผ่านการอนุมัติ';
    }


      $updatelastapp = Leave_register::find($id);
      $updatelastapp->TOP_LEADER_AC_CMD = $request->COMMENT;
      $updatelastapp->TOP_LEADER_AC_ID = $request->TOP_LEADER_AC_ID;

      $infoperson = Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
      ->where('hrd_person.ID','=',$request->TOP_LEADER_AC_ID)->first();
      $updatelastapp->TOP_LEADER_AC_NAME =  $infoperson->HR_PREFIX_NAME.' '.$infoperson->HR_FNAME.' '.$infoperson->HR_LNAME;
      $updatelastapp->LEAVE_STATUS_CODE = $statuscode;
      $updatelastapp->save();




          
      function DateThailinecar($strDate)
      {
        $strYear = date("Y",strtotime($strDate))+543;
        $strMonth= date("n",strtotime($strDate));
        $strDay= date("j",strtotime($strDate));

        $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
        $strMonthThai=$strMonthCut[$strMonth];
        return "$strDay $strMonthThai $strYear";
        }


   //แจ้งเตือนผู้ลาเมื่อได้รับอนุมัติ
            
    $leaveinfo = DB::table('gleave_register')->where('ID','=',$id)->first(); 

 
      $header = "ข้อมูลการลา";
      
       $datebegin = DateThailinecar($leaveinfo->LEAVE_DATE_BEGIN); 
       $backtime = DateThailinecar($leaveinfo->LEAVE_DATE_END);           
            
       $infoLEAVE_TYPE_ID = $leaveinfo->LEAVE_TYPE_CODE;
       $infoLEAVE_DEPARTMENT_ID = $leaveinfo->LEAVE_DEPARTMENT_ID;
       $leave_type = DB::table('gleave_type')->where('LEAVE_TYPE_ID','=',$infoLEAVE_TYPE_ID)->first(); 
       $hrd_department = DB::table('hrd_department')->where('HR_DEPARTMENT_ID','=',$infoLEAVE_DEPARTMENT_ID)->first(); 
       
  
      $message = $header.
          "\n"."ประเภท : " . $leave_type->LEAVE_TYPE_NAME .
          "\n"."เหตุผล : " . $leaveinfo->LEAVE_BECAUSE .
          "\n"."ผู้ลา : " . $leaveinfo->LEAVE_PERSON_FULLNAME .
          "\n"."หน่วยงาน : " . $hrd_department->HR_DEPARTMENT_NAME  .
          "\n"."ผู้รับมอบ : " . $leaveinfo->LEAVE_WORK_SEND .
          "\n"."ตั้งแต่วันที่ : " . $datebegin .               
          "\n"."ถึงวันที่ : " . $backtime .    
          "\n"."จำนวน : " . $leaveinfo->WORK_DO ." วัน" .
          "\n"."ผลการอนุมัติ : " . $textresult ;             
         
        
            
              $name = DB::table('hrd_person')->where('ID','=',$leaveinfo->LEAVE_PERSON_ID)->first();  
              if($name <> null && $name <> ''){      
              $test =$name->HR_LINE;
  
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

               
              //แจ้งเตือนผู้รับมอบงาน

              $name2 = DB::table('hrd_person')->where('ID','=',$leaveinfo->LEAVE_WORK_SEND_ID)->first();        
              $test2 =$name2->HR_LINE;
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


                //แจ้งเตือนกลุ่มหน่วยงาน

                $name = DB::table('hrd_department_sub_sub')->where('HR_DEPARTMENT_SUB_SUB_ID','=',$name->HR_DEPARTMENT_SUB_SUB_ID)->first();        
                $tokendepsubsub =$name->LINE_TOKEN;

                $chOne3 = curl_init();
              curl_setopt( $chOne3, CURLOPT_URL, "https://notify-api.line.me/api/notify");
              curl_setopt( $chOne3, CURLOPT_SSL_VERIFYHOST, 0);
              curl_setopt( $chOne3, CURLOPT_SSL_VERIFYPEER, 0);
              curl_setopt( $chOne3, CURLOPT_POST, 1);
              curl_setopt( $chOne3, CURLOPT_POSTFIELDS, $message);
              curl_setopt( $chOne3, CURLOPT_POSTFIELDS, "message=$message");
              curl_setopt( $chOne3, CURLOPT_FOLLOWLOCATION, 1);
              $headers3 = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$tokendepsubsub.'', );
              curl_setopt($chOne3, CURLOPT_HTTPHEADER, $headers3);
              curl_setopt( $chOne3, CURLOPT_RETURNTRANSFER, 1);
              $result3 = curl_exec( $chOne3 );
              if(curl_error($chOne3)) { echo 'error:' . curl_error($chOne3); }
              else { $result_ = json_decode($result3, true);
              echo "status : ".$result_['status']; echo "message : ". $result_['message']; }
              curl_close( $chOne3 );

              }

          return redirect()->route('horg.infoleave');

}



public function updatelastappall(Request $request)
{


    $iduser  = Auth::user()->PERSON_ID; 

      $statuscode = 'Allow';

      $check = Permislist::where('PERSON_ID','=',$iduser)
      ->where('PERMIS_ID','=','HORG')
      ->count();
      $infoleavealls =  Leave_register::where('LEAVE_STATUS_CODE','=','Verify')->get();

      $infoperson = Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                ->where('hrd_person.ID','=',$iduser)->first();
                
                $name =  $infoperson->HR_PREFIX_NAME.' '.$infoperson->HR_FNAME.' '.$infoperson->HR_LNAME;

                if($check !=0){

                $updatelastapp = Leave_register::where('LEAVE_STATUS_CODE','=','Verify')
                ->update(['LEAVE_STATUS_CODE' => $statuscode],['TOP_LEADER_AC_ID' => $iduser],['TOP_LEADER_AC_NAME' => $name]);

                }else{

                    $updatelastapp = Leave_register::where('LEAVE_STATUS_CODE','=','Verify')
                    ->where('LEADER_PERSON_ID','=',$iduser)
                    ->update(['LEAVE_STATUS_CODE' => $statuscode],['TOP_LEADER_AC_ID' => $iduser],['TOP_LEADER_AC_NAME' => $name]);


                }
            

                    function DateThailinecar($strDate)
                    {
                        $strYear = date("Y",strtotime($strDate))+543;
                        $strMonth= date("n",strtotime($strDate));
                        $strDay= date("j",strtotime($strDate));
                
                        $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
                        $strMonthThai=$strMonthCut[$strMonth];
                        return "$strDay $strMonthThai $strYear";
                        }
                

       

                            foreach ($infoleavealls as $infoleaveall){ 


                                
                            $leaveinfo = DB::table('gleave_register')->where('ID','=',$infoleaveall->ID)->first(); 

                            
                        
                            $header = "ข้อมูลการลา";
                            
                            $datebegin = DateThailinecar($leaveinfo->LEAVE_DATE_BEGIN); 
                            $backtime = DateThailinecar($leaveinfo->LEAVE_DATE_END);           
                                
                            $infoLEAVE_TYPE_ID = $leaveinfo->LEAVE_TYPE_CODE;
                            $infoLEAVE_DEPARTMENT_ID = $leaveinfo->LEAVE_DEPARTMENT_ID;
                            $leave_type = DB::table('gleave_type')->where('LEAVE_TYPE_ID','=',$infoLEAVE_TYPE_ID)->first(); 
                            $hrd_department = DB::table('hrd_department')->where('HR_DEPARTMENT_ID','=',$infoLEAVE_DEPARTMENT_ID)->first(); 
                            




                        $message = $header.
                            "\n"."ประเภท : " . $leave_type->LEAVE_TYPE_NAME .
                            "\n"."เหตุผล : " . $leaveinfo->LEAVE_BECAUSE .
                            "\n"."ผู้ลา : " . $leaveinfo->LEAVE_PERSON_FULLNAME .
                            "\n"."หน่วยงาน : " . $hrd_department->HR_DEPARTMENT_NAME  .
                            "\n"."ผู้รับมอบ : " . $leaveinfo->LEAVE_WORK_SEND .
                            "\n"."ตั้งแต่วันที่ : " . $datebegin .               
                            "\n"."ถึงวันที่ : " . $backtime .    
                            "\n"."จำนวน : " . $leaveinfo->WORK_DO ." วัน" .
                            "\n"."ผลการอนุมัติ : ได้รับการอนุมัติ";             
                        
                        

                                $name = DB::table('hrd_person')->where('ID','=',$leaveinfo->LEAVE_PERSON_ID)->first();        
                                $test =$name->HR_LINE;

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

                                
                                //แจ้งเตือนผู้รับมอบงาน

                                $name2 = DB::table('hrd_person')->where('ID','=',$leaveinfo->LEAVE_WORK_SEND_ID)->first();        
                                $test2 =$name2->HR_LINE;
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


                                //แจ้งเตือนกลุ่มหน่วยงาน

                                $name = DB::table('hrd_department_sub_sub')->where('HR_DEPARTMENT_SUB_SUB_ID','=',$name->HR_DEPARTMENT_SUB_SUB_ID)->first();        
                                $tokendepsubsub =$name->LINE_TOKEN;

                                $chOne3 = curl_init();
                                curl_setopt( $chOne3, CURLOPT_URL, "https://notify-api.line.me/api/notify");
                                curl_setopt( $chOne3, CURLOPT_SSL_VERIFYHOST, 0);
                                curl_setopt( $chOne3, CURLOPT_SSL_VERIFYPEER, 0);
                                curl_setopt( $chOne3, CURLOPT_POST, 1);
                                curl_setopt( $chOne3, CURLOPT_POSTFIELDS, $message);
                                curl_setopt( $chOne3, CURLOPT_POSTFIELDS, "message=$message");
                                curl_setopt( $chOne3, CURLOPT_FOLLOWLOCATION, 1);
                                $headers3 = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$tokendepsubsub.'', );
                                curl_setopt($chOne3, CURLOPT_HTTPHEADER, $headers3);
                                curl_setopt( $chOne3, CURLOPT_RETURNTRANSFER, 1);
                                $result3 = curl_exec( $chOne3 );
                                if(curl_error($chOne3)) { echo 'error:' . curl_error($chOne3); }
                                else { $result_ = json_decode($result3, true);
                                echo "status : ".$result_['status']; echo "message : ". $result_['message']; }
                                curl_close( $chOne3 );
                        

                            }

          return redirect()->route('horg.infoleave');

}

    //=====================อบรมดูงาน===============================================

public function infodevapp(Request $request)
    {
        
    $inforrecordindex =  Recordindex::select('grecord_index.ID as ID','grecord_index.STATUS','STATUS_NAME','RECORD_TYPE_NAME','USER_POST_NAME','RECORD_HEAD_USE','LOCATION_ORG_NAME','RECORD_LEVEL_NAME','RECORD_ORGANIZER_NAME','gleave_location.LOCATION_NAME','DATE_GO','DATE_BACK','RECORD_COMMENT','RECORD_GO_NAME','RECORD_VEHICLE_NAME','WITHDRAW_NAME','LEADER_HR_NAME','OFFER_WORK_HR_NAME','BOOK_NUM','SUMMONEY')
                                    ->leftJoin('grecord_status','grecord_index.STATUS','=','grecord_status.STATUS')
                                    ->leftJoin('grecord_type','grecord_index.RECORD_TYPE_ID','=','grecord_type.RECORD_TYPE_ID')
                                    ->leftJoin('grecord_org_location','grecord_org_location.LOCATION_ID','=','grecord_index.RECORD_LOCATION_ID')
                                    ->leftJoin('grecord_level','grecord_level.ID','=','grecord_index.RECORD_LEVEL_ID')
                                    ->leftJoin('gleave_location','gleave_location.LOCATION_ID','=','grecord_index.LOCATION_PROV_ID')
                                    ->leftJoin('grecord_go','grecord_go.RECORD_GO_ID','=','grecord_index.RECORD_GO_ID')
                                    ->leftJoin('grecord_vehicle','grecord_vehicle.RECORD_VEHICLE_ID','=','grecord_index.RECORD_VEHICLE_ID')
                                    ->leftJoin('grecord_withdraw','grecord_withdraw.WITHDRAW_ID','=','grecord_index.RECORD_MONEY_ID')
                                    ->leftJoin('grecord_index_money','grecord_index_money.RECORD_ID','=','grecord_index.ID')
                                    ->where('grecord_index.STATUS','=','RECEIVE')
                                    ->orderBy('grecord_index.ID', 'desc')  
                                    ->get();

        $grecordstatus = DB::table('grecord_status')->get(); 

        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;
        }

        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';
        $status = '2';
        $search = '';

        $year_id = $yearbudget;

        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

    return view('person_headorg.headorg_persondev',[
        'inforrecordindexs'=> $inforrecordindex,
        'grecordstatuss' => $grecordstatus,  
        'displaydate_bigen'=> $displaydate_bigen, 
        'displaydate_end'=> $displaydate_end,
        'status_check' => $status,
        'search' => $search,
        'year_id'=>$year_id,
        'budgets' =>  $budget,
        
    ]);
}



public function infodevapp_app(Request $request,$idref)
    {
        
    $inforrecordindex =  Recordindex::select('grecord_index.ID as ID','grecord_index.STATUS','STATUS_NAME','RECORD_TYPE_NAME','USER_POST_NAME','RECORD_HEAD_USE','LOCATION_ORG_NAME','RECORD_LEVEL_NAME','RECORD_ORGANIZER_NAME','gleave_location.LOCATION_NAME','DATE_GO','DATE_BACK','RECORD_COMMENT','RECORD_GO_NAME','RECORD_VEHICLE_NAME','WITHDRAW_NAME','LEADER_HR_NAME','OFFER_WORK_HR_NAME','BOOK_NUM','SUMMONEY')
                                    ->leftJoin('grecord_status','grecord_index.STATUS','=','grecord_status.STATUS')
                                    ->leftJoin('grecord_type','grecord_index.RECORD_TYPE_ID','=','grecord_type.RECORD_TYPE_ID')
                                    ->leftJoin('grecord_org_location','grecord_org_location.LOCATION_ID','=','grecord_index.RECORD_LOCATION_ID')
                                    ->leftJoin('grecord_level','grecord_level.ID','=','grecord_index.RECORD_LEVEL_ID')
                                    ->leftJoin('gleave_location','gleave_location.LOCATION_ID','=','grecord_index.LOCATION_PROV_ID')
                                    ->leftJoin('grecord_go','grecord_go.RECORD_GO_ID','=','grecord_index.RECORD_GO_ID')
                                    ->leftJoin('grecord_vehicle','grecord_vehicle.RECORD_VEHICLE_ID','=','grecord_index.RECORD_VEHICLE_ID')
                                    ->leftJoin('grecord_withdraw','grecord_withdraw.WITHDRAW_ID','=','grecord_index.RECORD_MONEY_ID')
                                    ->leftJoin('grecord_index_money','grecord_index_money.RECORD_ID','=','grecord_index.ID')
                                    ->where('grecord_index.ID','=',$idref)
                                    ->first();

    
    return view('person_headorg.headorg_persondev_app',[
        'inforrecordindex'=> $inforrecordindex,
        
    ]);
}



public function searchinfoapp(Request $request)
{
 

   $search = $request->get('search');
       $status = $request->STATUS_CODE;
       $datebigin = $request->get('DATE_BIGIN');
       $dateend = $request->get('DATE_END');  
       $yearbudget = $request->YEAR_ID;

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
        $displaydate_bigen= $y."-".$m."-".$d." 00:00:00";
  
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
        $displaydate_end= $y_e."-".$m_e."-".$d_e." 23:59:59";

        $from = date($displaydate_bigen);
        $to = date($displaydate_end);         
                        
                  

        if($status == null){
           $inforrecordindex =  Recordindex::select('grecord_index.ID as ID','grecord_index.STATUS','STATUS_NAME','RECORD_TYPE_NAME','USER_POST_NAME','RECORD_HEAD_USE','LOCATION_ORG_NAME','RECORD_LEVEL_NAME','RECORD_ORGANIZER_NAME','gleave_location.LOCATION_NAME','DATE_GO','DATE_BACK','RECORD_COMMENT','RECORD_GO_NAME','RECORD_VEHICLE_NAME','WITHDRAW_NAME','LEADER_HR_NAME','OFFER_WORK_HR_NAME','BOOK_NUM','SUMMONEY')
                                           ->leftJoin('grecord_status','grecord_index.STATUS','=','grecord_status.STATUS')
                                           ->leftJoin('grecord_type','grecord_index.RECORD_TYPE_ID','=','grecord_type.RECORD_TYPE_ID')
                                           ->leftJoin('grecord_org_location','grecord_org_location.LOCATION_ID','=','grecord_index.RECORD_LOCATION_ID')
                                           ->leftJoin('grecord_level','grecord_level.ID','=','grecord_index.RECORD_LEVEL_ID')
                                           ->leftJoin('gleave_location','gleave_location.LOCATION_ID','=','grecord_index.LOCATION_PROV_ID')
                                           ->leftJoin('grecord_go','grecord_go.RECORD_GO_ID','=','grecord_index.RECORD_GO_ID')
                                           ->leftJoin('grecord_vehicle','grecord_vehicle.RECORD_VEHICLE_ID','=','grecord_index.RECORD_VEHICLE_ID')
                                           ->leftJoin('grecord_withdraw','grecord_withdraw.WITHDRAW_ID','=','grecord_index.RECORD_MONEY_ID')  
                                           ->leftJoin('grecord_index_money','grecord_index_money.RECORD_ID','=','grecord_index.ID')                                          
                                           ->where(function($q) use ($search){
                                            $q->where('grecord_index.ID','like','%'.$search.'%');
                                            $q->orwhere('USER_POST_NAME','like','%'.$search.'%');  
                                            $q->orwhere('RECORD_TYPE_NAME','like','%'.$search.'%');
                                            $q->orwhere('RECORD_HEAD_USE','like','%'.$search.'%'); 
                                            $q->orwhere('LOCATION_ORG_NAME','like','%'.$search.'%'); 
                                            $q->orwhere('RECORD_VEHICLE_NAME','like','%'.$search.'%');  
                                            $q->orwhere('WITHDRAW_NAME','like','%'.$search.'%');   
                                            $q->orwhere('SUMMONEY','like','%'.$search.'%'); 
                                        })      
                                           ->WhereBetween('DATE_GO',[$from,$to]) 
                                           ->orderBy('grecord_index.ID', 'desc')    
                                           ->get();
           }else{
              

               
               $inforrecordindex =  Recordindex::select('grecord_index.ID as ID','grecord_index.STATUS','STATUS_NAME','RECORD_TYPE_NAME','USER_POST_NAME','RECORD_HEAD_USE','LOCATION_ORG_NAME','RECORD_LEVEL_NAME','RECORD_ORGANIZER_NAME','gleave_location.LOCATION_NAME','DATE_GO','DATE_BACK','RECORD_COMMENT','RECORD_GO_NAME','RECORD_VEHICLE_NAME','WITHDRAW_NAME','LEADER_HR_NAME','OFFER_WORK_HR_NAME','BOOK_NUM','SUMMONEY')
                                               ->leftJoin('grecord_status','grecord_index.STATUS','=','grecord_status.STATUS')
                                               ->leftJoin('grecord_type','grecord_index.RECORD_TYPE_ID','=','grecord_type.RECORD_TYPE_ID')
                                               ->leftJoin('grecord_org_location','grecord_org_location.LOCATION_ID','=','grecord_index.RECORD_LOCATION_ID')
                                               ->leftJoin('grecord_level','grecord_level.ID','=','grecord_index.RECORD_LEVEL_ID')
                                               ->leftJoin('gleave_location','gleave_location.LOCATION_ID','=','grecord_index.LOCATION_PROV_ID')
                                               ->leftJoin('grecord_go','grecord_go.RECORD_GO_ID','=','grecord_index.RECORD_GO_ID')
                                               ->leftJoin('grecord_vehicle','grecord_vehicle.RECORD_VEHICLE_ID','=','grecord_index.RECORD_VEHICLE_ID')
                                               ->leftJoin('grecord_withdraw','grecord_withdraw.WITHDRAW_ID','=','grecord_index.RECORD_MONEY_ID') 
                                               ->leftJoin('grecord_index_money','grecord_index_money.RECORD_ID','=','grecord_index.ID')
                                               ->where('ID_STATUS','=',$status)                                          
                                               ->where(function($q) use ($search){
                                                $q->where('grecord_index.ID','like','%'.$search.'%');
                                                $q->orwhere('USER_POST_NAME','like','%'.$search.'%');  
                                                $q->orwhere('RECORD_TYPE_NAME','like','%'.$search.'%');
                                                $q->orwhere('RECORD_HEAD_USE','like','%'.$search.'%'); 
                                                $q->orwhere('LOCATION_ORG_NAME','like','%'.$search.'%'); 
                                                $q->orwhere('RECORD_VEHICLE_NAME','like','%'.$search.'%');  
                                                $q->orwhere('WITHDRAW_NAME','like','%'.$search.'%');   
                                                $q->orwhere('SUMMONEY','like','%'.$search.'%');                                                       
                                               })
                                               ->WhereBetween('DATE_GO',[$from,$to]) 
                                               ->orderBy('grecord_index.ID', 'desc')    
                                               ->get();
           }    
           
            }else{
               if($status == null){ 
               $inforrecordindex =  Recordindex::select('grecord_index.ID as ID','grecord_index.STATUS','STATUS_NAME','RECORD_TYPE_NAME','USER_POST_NAME','RECORD_HEAD_USE','LOCATION_ORG_NAME','RECORD_LEVEL_NAME','RECORD_ORGANIZER_NAME','gleave_location.LOCATION_NAME','DATE_GO','DATE_BACK','RECORD_COMMENT','RECORD_GO_NAME','RECORD_VEHICLE_NAME','WITHDRAW_NAME','LEADER_HR_NAME','OFFER_WORK_HR_NAME','BOOK_NUM','SUMMONEY')
                                               ->leftJoin('grecord_status','grecord_index.STATUS','=','grecord_status.STATUS')
                                               ->leftJoin('grecord_type','grecord_index.RECORD_TYPE_ID','=','grecord_type.RECORD_TYPE_ID')
                                               ->leftJoin('grecord_org_location','grecord_org_location.LOCATION_ID','=','grecord_index.RECORD_LOCATION_ID')
                                               ->leftJoin('grecord_level','grecord_level.ID','=','grecord_index.RECORD_LEVEL_ID')
                                               ->leftJoin('gleave_location','gleave_location.LOCATION_ID','=','grecord_index.LOCATION_PROV_ID')
                                               ->leftJoin('grecord_go','grecord_go.RECORD_GO_ID','=','grecord_index.RECORD_GO_ID')
                                               ->leftJoin('grecord_vehicle','grecord_vehicle.RECORD_VEHICLE_ID','=','grecord_index.RECORD_VEHICLE_ID')
                                               ->leftJoin('grecord_withdraw','grecord_withdraw.WITHDRAW_ID','=','grecord_index.RECORD_MONEY_ID')                                                                                           
                                               ->leftJoin('grecord_index_money','grecord_index_money.RECORD_ID','=','grecord_index.ID')
                                               ->where(function($q) use ($search){
                                                $q->where('grecord_index.ID','like','%'.$search.'%');
                                                $q->orwhere('USER_POST_NAME','like','%'.$search.'%');  
                                                $q->orwhere('RECORD_TYPE_NAME','like','%'.$search.'%');
                                                $q->orwhere('RECORD_HEAD_USE','like','%'.$search.'%'); 
                                                $q->orwhere('LOCATION_ORG_NAME','like','%'.$search.'%'); 
                                                $q->orwhere('RECORD_VEHICLE_NAME','like','%'.$search.'%');  
                                                $q->orwhere('WITHDRAW_NAME','like','%'.$search.'%');   
                                                $q->orwhere('SUMMONEY','like','%'.$search.'%');         
                                               })                                                   
                                               ->orderBy('grecord_index.ID', 'desc')    
                                               ->get();
               }else{
                   $inforrecordindex =  Recordindex::select('grecord_index.ID as ID','grecord_index.STATUS','STATUS_NAME','RECORD_TYPE_NAME','USER_POST_NAME','RECORD_HEAD_USE','LOCATION_ORG_NAME','RECORD_LEVEL_NAME','RECORD_ORGANIZER_NAME','gleave_location.LOCATION_NAME','DATE_GO','DATE_BACK','RECORD_COMMENT','RECORD_GO_NAME','RECORD_VEHICLE_NAME','WITHDRAW_NAME','LEADER_HR_NAME','OFFER_WORK_HR_NAME','BOOK_NUM','SUMMONEY')
                                                   ->leftJoin('grecord_status','grecord_index.STATUS','=','grecord_status.STATUS')
                                                   ->leftJoin('grecord_type','grecord_index.RECORD_TYPE_ID','=','grecord_type.RECORD_TYPE_ID')
                                                   ->leftJoin('grecord_org_location','grecord_org_location.LOCATION_ID','=','grecord_index.RECORD_LOCATION_ID')
                                                   ->leftJoin('grecord_level','grecord_level.ID','=','grecord_index.RECORD_LEVEL_ID')
                                                   ->leftJoin('gleave_location','gleave_location.LOCATION_ID','=','grecord_index.LOCATION_PROV_ID')
                                                   ->leftJoin('grecord_go','grecord_go.RECORD_GO_ID','=','grecord_index.RECORD_GO_ID')
                                                   ->leftJoin('grecord_vehicle','grecord_vehicle.RECORD_VEHICLE_ID','=','grecord_index.RECORD_VEHICLE_ID')
                                                   ->leftJoin('grecord_withdraw','grecord_withdraw.WITHDRAW_ID','=','grecord_index.RECORD_MONEY_ID')                                                                                           
                                                   ->leftJoin('grecord_index_money','grecord_index_money.RECORD_ID','=','grecord_index.ID')
                                                   ->where('ID_STATUS','=',$status)  
                                                   ->where(function($q) use ($search){
                                                       $q->where('grecord_index.ID','like','%'.$search.'%');
                                                       $q->orwhere('USER_POST_NAME','like','%'.$search.'%');  
                                                       $q->orwhere('RECORD_TYPE_NAME','like','%'.$search.'%');
                                                       $q->orwhere('RECORD_HEAD_USE','like','%'.$search.'%'); 
                                                       $q->orwhere('LOCATION_ORG_NAME','like','%'.$search.'%'); 
                                                       $q->orwhere('RECORD_VEHICLE_NAME','like','%'.$search.'%');  
                                                       $q->orwhere('WITHDRAW_NAME','like','%'.$search.'%');   
                                                       $q->orwhere('SUMMONEY','like','%'.$search.'%');                                              
                                                   })                                                   
                                                   ->orderBy('grecord_index.ID', 'desc')    
                                                   ->get();                       
               }        
            }
             $grecordstatus = DB::table('grecord_status')->get();    
             
             $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
    
             $year_id = $yearbudget;
   
           return view('person_headorg.headorg_persondev',[           
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
    

public function updateinfodevapp(Request $request)
    {
 
    $id = $request->ID; 

    $check =  $request->SUBMIT; 

    if($check == 'approved'){
      $statuscode = 'SUCCESS';
    }else{
      $statuscode = 'NOTALLOW';
    }

      $updateapp = Recordindex::find($id);
      $updateapp->APPROVE_COMMENT = $request->APPROVE_COMMENT;
      $updateapp->STATUS = $statuscode; 
      $updateapp->save();

      return redirect()->route('horg.infodevapp');

}

public function updateinfodevappall(Request $request)
    {
   
        $infodevalls =  Recordindex::where('grecord_index.STATUS','=','RECEIVE')
        ->get();

      foreach ($infodevalls as $infodevall){ 
        $updateapp = Recordindex::find($infodevall->ID);
        $updateapp->APPROVE_COMMENT = 'อนุมัติ';
        $updateapp->STATUS = 'SUCCESS'; 
        $updateapp->save();
      }
          return redirect()->route('horg.infodevapp');

}


//===================================================อนุมัติรถยนต์


public function infocar()
{

    $infocarnomal =Vehiclecarreserve::leftJoin('grecord_org_location','vehicle_car_reserve.RESERVE_LOCATION_ID','=','grecord_org_location.LOCATION_ID')
    ->leftJoin('vehicle_car_index','vehicle_car_reserve.CAR_SET_ID','=','vehicle_car_index.CAR_ID')
    ->leftJoin('hrd_person','vehicle_car_reserve.RESERVE_PERSON_ID','=','hrd_person.ID')
    ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->where('STATUS','=','SUCCESS')
    ->orderBy('RESERVE_ID', 'desc') 
    ->get();

    $infocar_sendstatus = DB::table('vehicle_car_request_status')->get();

    $m_budget = date("m");
    if($m_budget>9){
    $yearbudget = date("Y")+544;
    }else{
    $yearbudget = date("Y")+543;
    }

    $displaydate_bigen = ($yearbudget-544).'-10-01';
    $displaydate_end = ($yearbudget-543).'-09-30';
    $status = '';
    $search = '';

    $year_id = $yearbudget;

    $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();



    return view('person_headorg.headorg_car',[
        'infocarnomals' => $infocarnomal,
        'infocar_sendstatuss' => $infocar_sendstatus,
        'displaydate_bigen'=> $displaydate_bigen, 
        'displaydate_end'=> $displaydate_end,
        'status_check'=> $status,
        'search'=> $search,
        'year_id'=>$year_id,
        'budgets' =>  $budget,
        
        ]);

}




public function infocar_app(Request $request,$idref)
{

    $infocarnomal =Vehiclecarreserve::leftJoin('grecord_org_location','vehicle_car_reserve.RESERVE_LOCATION_ID','=','grecord_org_location.LOCATION_ID')
    ->leftJoin('vehicle_car_index','vehicle_car_reserve.CAR_SET_ID','=','vehicle_car_index.CAR_ID')
    ->leftJoin('hrd_person','vehicle_car_reserve.RESERVE_PERSON_ID','=','hrd_person.ID')
    ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->where('STATUS','=','SUCCESS')
    ->where('RESERVE_ID','=',$idref)
    ->first();

   

    return view('person_headorg.headorg_car_app',[
        'infocarnomal' => $infocarnomal,
        
        ]);

}




public function infocarnomalsearch(Request $request)
{
    
    $search = $request->get('search');
    $status = $request->SEND_STATUS;
    $datebigin = $request->get('DATE_BIGIN');
    $dateend = $request->get('DATE_END');
    $yearbudget = $request->YEAR_ID;

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
    $displaydate_bigen= $y."-".$m."-".$d." 00:00:00";

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
    $displaydate_end= $y_e."-".$m_e."-".$d_e." 23:59:59";



    $date = date('Y-m-d');
    $date_bigen_checks = strtotime($displaydate_bigen);
    $date_end_checks =  strtotime($displaydate_end);
    $dates =  strtotime($date);


        $from = date($displaydate_bigen);
        $to = date($displaydate_end);

        if($status == null){

            $infocar = Vehiclecarreserve::leftJoin('grecord_org_location','vehicle_car_reserve.RESERVE_LOCATION_ID','=','grecord_org_location.LOCATION_ID')
            ->leftJoin('vehicle_car_index','vehicle_car_reserve.CAR_SET_ID','=','vehicle_car_index.CAR_ID')
            ->leftJoin('hrd_person','vehicle_car_reserve.RESERVE_PERSON_ID','=','hrd_person.ID')
            ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
            ->where(function($q) use ($search){
                $q->where('CAR_REG','like','%'.$search.'%');
                $q->orwhere('LOCATION_ORG_NAME','like','%'.$search.'%');  
                $q->orwhere('RESERVE_NAME','like','%'.$search.'%');
                $q->orwhere('RESERVE_PERSON_NAME','like','%'.$search.'%');

            })
            ->WhereBetween('RESERVE_BEGIN_DATE',[$from,$to]) 
            ->orderBy('RESERVE_ID', 'desc') 
            ->get();


        }else{

            $infocar = Vehiclecarreserve::leftJoin('grecord_org_location','vehicle_car_reserve.RESERVE_LOCATION_ID','=','grecord_org_location.LOCATION_ID')
            ->leftJoin('vehicle_car_index','vehicle_car_reserve.CAR_SET_ID','=','vehicle_car_index.CAR_ID')
            ->leftJoin('hrd_person','vehicle_car_reserve.RESERVE_PERSON_ID','=','hrd_person.ID')
            ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
            ->where('STATUS','=',$status)
            ->where(function($q) use ($search){
                $q->where('CAR_REG','like','%'.$search.'%');
                $q->orwhere('LOCATION_ORG_NAME','like','%'.$search.'%');  
                $q->orwhere('RESERVE_NAME','like','%'.$search.'%');
                $q->orwhere('RESERVE_PERSON_NAME','like','%'.$search.'%');

            })
            ->WhereBetween('RESERVE_BEGIN_DATE',[$from,$to]) 
            ->orderBy('RESERVE_ID', 'desc') 
            ->get();


        }


   

    $infocar_sendstatus = DB::table('vehicle_car_request_status')->get();

    $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
    
    $year_id = $yearbudget;
    

    return view('person_headorg.headorg_car',[
        'infocarnomals' => $infocar,
        'infocar_sendstatuss' => $infocar_sendstatus,
        'displaydate_bigen'=> $displaydate_bigen, 
        'displaydate_end'=> $displaydate_end,
        'status_check'=> $status,
        'search'=> $search,
        'year_id'=>$year_id,
        'budgets' =>  $budget,
        
        
        ]);
}


public function updateinfocarnomalapp(Request $request)
    {
 
    $id = $request->RESERVE_ID; 

    $check =  $request->SUBMIT; 

    if($check == 'approved'){
      $statuscode = 'LASTAPP';
      $textresult = 'ผอ.อนุมัติ';
    }else{
      $statuscode = 'NOTLASTAPP';
      $textresult = 'ผอ.ไม่อนุมัติ';
    }

      $updateapp = Vehiclecarreserve::find($id);
      $updateapp->STATUS = $statuscode; 
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
        function formatetime($strtime)
        {
            $H = substr($strtime,0,5);
            return $H;
            }
            
      $header = "จัดสรรรถยนต์";
             
            

      $infocarnimal = Vehiclecarreserve::leftJoin('grecord_org_location','vehicle_car_reserve.RESERVE_LOCATION_ID','=','grecord_org_location.LOCATION_ID')
      ->leftJoin('vehicle_car_index','vehicle_car_reserve.CAR_SET_ID','=','vehicle_car_index.CAR_ID')
      ->leftJoin('hrd_person','vehicle_car_reserve.RESERVE_PERSON_ID','=','hrd_person.ID')
      ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
      ->leftJoin('vehicle_car_appoint_locate','vehicle_car_appoint_locate.APPOINT_LOCATE_ID','=','vehicle_car_reserve.APPOINT_LOCATE_ID')
      ->where('RESERVE_ID','=',$id)
      ->first();


      $datebegin = DateThailinecar($infocarnimal->RESERVE_BEGIN_DATE); 

      $timebegin = formatetime($infocarnimal->RESERVE_BEGIN_TIME);

      $CAR_DRIVER =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
      ->where('hrd_person.ID','=',$infocarnimal->CAR_DRIVER_SET_ID)->first();

      $appointtime =  formatetime($infocarnimal->APPOINT_TIME);

 

     if($infocarnimal->CAR_DRIVER_SET_ID == ''){
        $driver = '';   
        $phone ='';
         }else{
        $driver = $CAR_DRIVER->HR_PREFIX_NAME.''.$CAR_DRIVER->HR_FNAME.' '.$CAR_DRIVER->HR_LNAME;
        $phone = $CAR_DRIVER->HR_PHONE;    
         }   

     $message = $header.
         "\n"."ขอใช้รถ : " . $infocarnimal->RESERVE_NAME .
         "\n"."สถานที่ไป : " . $infocarnimal->LOCATION_ORG_NAME .
         "\n"."ผู้ขอ : " .$infocarnimal->HR_PREFIX_NAME.''.$infocarnimal->HR_FNAME.' '.$infocarnimal->HR_LNAME.
         "\n"."วันที่ : " . $datebegin  .
         "\n"."เวลา : " . $timebegin .
         "\n"."ยานพาหนะ : " . $infocarnimal->CAR_REG .  
         "\n"."พขร. : " .$driver.   
         "\n"."สถานที่นัดหมาย : " .$infocarnimal->APPOINT_LOCATE_NAME.  
         "\n"."โทร : " .$phone.    
         "\n"."ผลการอนุมัติ : " . $textresult ;    
         
   
        
       
 
             $name = DB::table('hrd_person')->where('ID','=',$infocarnimal->RESERVE_PERSON_ID)->first();        
             if($name == null){
                $test = '';
             }else{
                $test =$name->HR_LINE;
             }
             
           
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


      
          return redirect()->route('horg.infocar');

}

public function updateinfocarnomalappall(Request $request)
    {
   

        $infocaralls =  Vehiclecarreserve::where('STATUS','=','SUCCESS')
        ->get();

      foreach ($infocaralls as $infocarall){ 
        $updateapp = Vehiclecarreserve::find($infocarall->RESERVE_ID);
        $updateapp->STATUS = 'LASTAPP'; 
        $updateapp->save();
      }
          return redirect()->route('horg.infocar');

}



//===========================งานพัสดุ====

public function supplier(Request $request)
{
    
    $m_budget = date("m");
    if($m_budget>9){
    $yearbudget = date("Y")+544;
    }else{
    $yearbudget = date("Y")+543;
    }


    $inforequest = Suppliesrequest::leftJoin('supplies_request_status','supplies_request_status.STATUS_CODE','=','supplies_request.STATUS')
    ->orderBy('supplies_request.ID', 'desc')
    ->where('STATUS','=','Verify')
    ->get();

    $sumbudget  =Suppliesrequest::leftJoin('supplies_request_status','supplies_request_status.STATUS_CODE','=','supplies_request.STATUS')
    ->orderBy('supplies_request.ID', 'desc')
    ->where('STATUS','=','Verify')
    ->sum('BUDGET_SUM');

    $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

    $info_sendstatus = DB::table('supplies_request_status')->get();

    $displaydate_bigen = ($yearbudget-544).'-10-01';
    $displaydate_end = ($yearbudget-543).'-09-30';
        $status = 'Verify';
        $search = '';
        $year_id = $yearbudget;

    return view('person_headorg.headorg_supplier',[
        'budgets' =>  $budget,
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


public function supplier_app(Request $request,$idref)
{
    
    $inforequest = Suppliesrequest::leftJoin('supplies_request_status','supplies_request_status.STATUS_CODE','=','supplies_request.STATUS')
    ->where('STATUS','=','Verify')
    ->where('supplies_request.ID','=',$idref)
    ->first();

    return view('person_headorg.headorg_supplier_app',[
        'inforequest' => $inforequest,
      
    ]);

}


public function inforequestlastappsearch(Request $request)
{
 

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
            ->where(function($q) use ($search){
                $q->where('REQUEST_FOR','like','%'.$search.'%');
                $q->orwhere('BUDGET_SUM','like','%'.$search.'%');
                $q->orwhere('SAVE_HR_DEP_SUB_NAME','like','%'.$search.'%');
                $q->orwhere('REQUEST_ID','like','%'.$search.'%');
            })
                ->WhereBetween('DATE_TIME_SAVE',[$from,$to])
            ->orderBy('supplies_request.ID', 'desc')
            ->get();

            $sumbudget = Suppliesrequest::leftJoin('supplies_request_status','supplies_request_status.STATUS_CODE','=','supplies_request.STATUS')
          
            ->where('BUDGET_YEAR','=', $yearbudget)
            ->where(function($q) use ($search){
                $q->where('REQUEST_FOR','like','%'.$search.'%');
                $q->orwhere('BUDGET_SUM','like','%'.$search.'%');
                $q->orwhere('SAVE_HR_DEP_SUB_NAME','like','%'.$search.'%');
                $q->orwhere('REQUEST_ID','like','%'.$search.'%');
            })
                ->WhereBetween('DATE_TIME_SAVE',[$from,$to])
                ->sum('BUDGET_SUM');

           

        }else{

            $inforequest = Suppliesrequest::leftJoin('supplies_request_status','supplies_request_status.STATUS_CODE','=','supplies_request.STATUS')
            ->where('BUDGET_YEAR','=', $yearbudget)
            ->where('STATUS_CODE','=',$status)
            ->where(function($q) use ($search){
                $q->where('REQUEST_FOR','like','%'.$search.'%');
                $q->orwhere('BUDGET_SUM','like','%'.$search.'%');
                $q->orwhere('SAVE_HR_DEP_SUB_NAME','like','%'.$search.'%');
                $q->orwhere('REQUEST_ID','like','%'.$search.'%');
            })
                ->WhereBetween('DATE_TIME_SAVE',[$from,$to])
            ->orderBy('supplies_request.ID', 'desc')
            ->get();

            $sumbudget = Suppliesrequest::leftJoin('supplies_request_status','supplies_request_status.STATUS_CODE','=','supplies_request.STATUS')
            ->where('BUDGET_YEAR','=', $yearbudget)
            ->where('STATUS_CODE','=',$status)
            ->where(function($q) use ($search){
                $q->where('REQUEST_FOR','like','%'.$search.'%');
                $q->orwhere('BUDGET_SUM','like','%'.$search.'%');
                $q->orwhere('SAVE_HR_DEP_SUB_NAME','like','%'.$search.'%');
                $q->orwhere('REQUEST_ID','like','%'.$search.'%');
            })
                ->WhereBetween('DATE_TIME_SAVE',[$from,$to])
                ->sum('BUDGET_SUM');

        }
  

        

    $info_sendstatus = DB::table('supplies_request_status')->get();
   
    $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
    $year_id = $yearbudget;

    return view('person_headorg.headorg_supplier',[
        'budgets' =>  $budget,
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


public function updateinforequestlastapp(Request $request)
{
 
    $id = $request->ID;

    $check =  $request->SUBMIT;

    if($check == 'approved'){
      $statuscode = 'Allow';
    }else{
      $statuscode = 'Disallow';
    }



      $updatelastapp = Suppliesrequest::find($id);
      $updatelastapp->STATUS = $statuscode;
      $updatelastapp->TOP_LEADER_AC_COMMENT = $request->TOP_LEADER_AC_COMMENT;
      $updatelastapp->TOP_LEADER_AC_ID = $request->TOP_LEADER_AC_ID;
      //----------------------------------
      $TOPLEADER=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
      ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
      ->where('hrd_person.ID','=',$request->TOP_LEADER_AC_ID)->first();

       $updatelastapp->TOP_LEADER_AC_NAME = $TOPLEADER->HR_PREFIX_NAME.''.$TOPLEADER->HR_FNAME.' '.$TOPLEADER->HR_LNAME;

       //----------------------------------
       $updatelastapp->TOP_LEADER_AC_DATE_TIME = date('Y-m-d H:i:s');

       $updatelastapp->save();

       return redirect()->route('horg.supplier');

}



//============================================
public function meet(Request $request)
{
    
    $m_budget = date("m");
    if($m_budget>9){
    $yearbudget = date("Y")+544;
    }else{
    $yearbudget = date("Y")+543;
    }

    $inforoomindex =  Meetingroomservice::leftJoin('meetingroom_index','meetingroom_index.ROOM_ID','=','meetingroom_service.ROOM_ID')
    ->leftJoin('meetingroom_service_status','meetingroom_service_status.STATUS_CODE','=','meetingroom_service.STATUS')
    ->leftJoin('meetingroom_objective','meetingroom_objective.OBJECTIVE_ID','=','meetingroom_service.SERVICE_FOR')
    ->Where('STATUS','=','SUCCESS') 
    ->orderBy('meetingroom_service.ID', 'desc')  
    ->get();
  

    $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

    $info_sendstatus = DB::table('meetingroom_service_status')->get();

        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';
        $status = 'SUCCESS';
        $search = '';
        $year_id = $yearbudget;

    return view('person_headorg.headorg_meet',[
        'budgets' =>  $budget,
        'inforoomindexs'=>  $inforoomindex,
        'info_sendstatuss' => $info_sendstatus,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id,
         
    ]);

}


public function meet_app(Request $request,$idref)
{


    $inforoomindex =  Meetingroomservice::leftJoin('meetingroom_index','meetingroom_index.ROOM_ID','=','meetingroom_service.ROOM_ID')
    ->leftJoin('meetingroom_service_status','meetingroom_service_status.STATUS_CODE','=','meetingroom_service.STATUS')
    ->leftJoin('meetingroom_objective','meetingroom_objective.OBJECTIVE_ID','=','meetingroom_service.SERVICE_FOR')
    ->Where('STATUS','=','SUCCESS') 
    ->where('meetingroom_service.ID','=',$idref)
    ->first();
  

    return view('person_headorg.headorg_meet_app',[
        'inforoomindex'=>  $inforoomindex,
    ]);

}



public function informeetsearch(Request $request)
{
 

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
    $displaydate_bigen= $y."-".$m."-".$d." 00:00:00";

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
    $displaydate_end= $y_e."-".$m_e."-".$d_e." 23:59:59";
    $date = date('Y-m-d');


        $from = date($displaydate_bigen);
        $to = date($displaydate_end);

        if($status == null){
           

            $inforoomindex =  Meetingroomservice::leftJoin('meetingroom_index','meetingroom_index.ROOM_ID','=','meetingroom_service.ROOM_ID')
            ->leftJoin('meetingroom_service_status','meetingroom_service_status.STATUS_CODE','=','meetingroom_service.STATUS')
            ->leftJoin('meetingroom_objective','meetingroom_objective.OBJECTIVE_ID','=','meetingroom_service.SERVICE_FOR')
            ->where(function($q) use ($search){
                $q->where('ROOM_NAME','like','%'.$search.'%');
                $q->orwhere('SERVICE_STORY','like','%'.$search.'%');
                $q->orwhere('PERSON_REQUEST_NAME','like','%'.$search.'%');
            })
                ->WhereBetween('DATE_BEGIN',[$from,$to])
            ->orderBy('meetingroom_service.ID', 'desc')  
            ->get();
           

        }else{

          

            $inforoomindex =  Meetingroomservice::leftJoin('meetingroom_index','meetingroom_index.ROOM_ID','=','meetingroom_service.ROOM_ID')
            ->leftJoin('meetingroom_service_status','meetingroom_service_status.STATUS_CODE','=','meetingroom_service.STATUS')
            ->leftJoin('meetingroom_objective','meetingroom_objective.OBJECTIVE_ID','=','meetingroom_service.SERVICE_FOR')
            ->where('meetingroom_service.STATUS','=',$status)
            ->where(function($q) use ($search){
                $q->where('ROOM_NAME','like','%'.$search.'%');
                $q->orwhere('SERVICE_STORY','like','%'.$search.'%');
                $q->orwhere('PERSON_REQUEST_NAME','like','%'.$search.'%');
            })
                ->WhereBetween('DATE_BEGIN',[$from,$to])
            ->orderBy('meetingroom_service.ID', 'desc')  
            ->get();
        }
  

        

    $info_sendstatus = DB::table('meetingroom_service_status')->get();
   
    $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
    $year_id = $yearbudget;

    return view('person_headorg.headorg_meet',[
        'budgets' =>  $budget,
        'inforoomindexs'=>  $inforoomindex,
        'info_sendstatuss' => $info_sendstatus,
        'displaydate_bigen'=> $displaydate_bigen,
        'displaydate_end'=> $displaydate_end,
        'status_check'=> $status,
        'search'=> $search,
        'year_id'=>$year_id,

    ]);

}

public function updateinfomeetnomalapp(Request $request)
    {
 
    $id = $request->ID; 

    $check =  $request->SUBMIT; 

    if($check == 'approved'){
      $statuscode = 'LASTAPP';
      $statustext = 'ผอ.อนุมัติ';
    }else{
      $statuscode = 'NOTLASTAPP';
      $statustext = 'ผอ.ไม่อนุมัติ';
    }

      $updateapp = Meetingroomservice::find($id);
      $updateapp->STATUS = $statuscode; 
      $updateapp->save();



   
      $infodetail = DB::table('meetingroom_service')->where('ID','=',$id)->first();

      
      $inforoom = DB::table('meetingroom_index')->where('ROOM_ID','=',$infodetail->ROOM_ID)->first();

      $header = "ระบบจองห้องประชุม";
      $servicestory = $infodetail->SERVICE_STORY;
      $roomname = $inforoom->ROOM_NAME;
      $person = $infodetail->PERSON_REQUEST_NAME;
      $groupfocus = $infodetail->GROUP_FOCUS;
      $totalpeopel = $infodetail->TOTAL_PEOPLE.' คน';
      $datebegin = DateThai($infodetail->DATE_BEGIN).' '.date("H:i",strtotime("$infodetail->TIME_BEGIN"));
      $dateend = DateThai($infodetail->DATE_END).' '.date("H:i",strtotime("$infodetail->TIME_END"));
  
  
      $products =DB::table('meetingroom_article_list')
      ->leftjoin('meetingroom_article','meetingroom_article.ARTICLE_ID','=','meetingroom_article_list.ARTICLE_ID')
      ->where('SERVICE_ID','=', $id)->get();
  
      $foods =DB::table('meetingroom_food_list')
      ->leftjoin('meetingroom_food','meetingroom_food.FOOD_ID','=','meetingroom_food_list.FOOD_ID')
      ->where('SERVICE_ID','=', $id)->get();
  
      $message = $header.
          "\n"."เรื่อง : " . $servicestory .
          "\n"."ห้อง : " . $roomname .
          "\n"."ผู้จอง : " . $person .
          "\n"."ผู้เข้าประชุม : " . $groupfocus .
          "\n"."จำนวน : " . $totalpeopel .
          "\n"."วันที่จอง : " . $datebegin .
          "\n"."ถึงวันที่ : " . $dateend .
          "\n"."สถานะ : " . $statustext .
          "\n"."อุปกรณ์ : "; 
          foreach ($products as $product){ 
          $message.="\n"." - " . $product->ARTICLE_NAME ." จำนวน ".$product->TOTAL;
              }
          $message.="\n"."อาหาร : "; 
          foreach ($foods as $food){ 
          $message.="\n"." - " . $food->FOOD_NAME ." จำนวน ".$food->TOTAL." ".$food->FOOD_UNIT;
          }
          
          
         
  
              $name = DB::table('line_token')->where('ID_LINE_TOKEN','=',1)->first();
  
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
  
  
              $name = DB::table('hrd_person')->where('ID', '=', $infodetail->PERSON_REQUEST_ID)->first();
              $test_preson = $name->HR_LINE;

              $chOne_p = curl_init();
              curl_setopt($chOne_p, CURLOPT_URL, "https://notify-api.line.me/api/notify");
              curl_setopt($chOne_p, CURLOPT_SSL_VERIFYHOST, 0);
              curl_setopt($chOne_p, CURLOPT_SSL_VERIFYPEER, 0);
              curl_setopt($chOne_p, CURLOPT_POST, 1);
              curl_setopt($chOne_p, CURLOPT_POSTFIELDS, $message);
              curl_setopt($chOne_p, CURLOPT_POSTFIELDS, "message=$message");
              curl_setopt($chOne_p, CURLOPT_FOLLOWLOCATION, 1);
              $headers = array('Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer ' . $test_preson . '');
              curl_setopt($chOne_p, CURLOPT_HTTPHEADER, $headers);
              curl_setopt($chOne_p, CURLOPT_RETURNTRANSFER, 1);
              $result = curl_exec($chOne_p);
              if (curl_error($chOne_p)) {echo 'error:' . curl_error($chOne_p);} else { $result_ = json_decode($result, true);
                  echo "status : " . $result_['status'];
                  echo "message : " . $result_['message'];}
              curl_close($chOne_p);
          
          
      
          return redirect()->route('horg.meet');

}

public function updateinfomeetnomalappall(Request $request)
    {
   

        $infomeetalls =  Meetingroomservice::where('STATUS','=','SUCCESS')
        ->get();

      foreach ($infomeetalls as $infomeetall){ 
        $updateapp = Meetingroomservice::find($infomeetall->ID);
        $updateapp->STATUS = 'LASTAPP'; 
        $updateapp->save();
      }
          return redirect()->route('horg.meet');

}

    //-------------------อนุมัติยืมคืน


    public function borrow(Request $request)
{


        if(!empty($request->_token)){
            $search = $request->get('search');
            $status = $request->SEND_STATUS;
            $datebigin = $request->get('DATE_BIGIN');
            $dateend = $request->get('DATE_END');
            $yearbudget = $request->BUDGET_YEAR;
            session([
                'person_headorg.headorg_borrow.search' => $search,
                'person_headorg.headorg_borrow.status' => $status,
                'person_headorg.headorg_borrow.datebigin' => $datebigin,
                'person_headorg.headorg_borrow.dateend' => $dateend,
                'person_headorg.headorg_borrow.yearbudget' => $yearbudget,
            ]);

        }elseif(!empty(session('person_headorg.headorg_borrow'))){
            $search = session('person_headorg.headorg_borrow.search');
            $status = session('person_headorg.headorg_borrow.status');
            $datebigin = session('person_headorg.headorg_borrow.datebigin');
            $dateend = session('person_headorg.headorg_borrow.dateend');
            $yearbudget = session('person_headorg.headorg_borrow.yearbudget');
        }else{
            $search = '';
            $status = '';
            $datebigin = date('1/m/Y');
            $dateend   = date('d/m/Y', strtotime(date('Y-m-1'). '+1month -1days'));
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
        $displaydate_bigen= $y."-".$m."-".$d." 00:00:00";

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
        $displaydate_end= $y_e."-".$m_e."-".$d_e." 23:59:59";

        $date_bigen_checks = strtotime($displaydate_bigen);
        $date_end_checks =  strtotime($displaydate_end);

            $from = date($displaydate_bigen);
            $to = date($displaydate_end);
       
            if($status == null){                
                        $inforSalaryborrow =  Salaryborrow::where(function($q) use ($search){
                                $q->where('BORROW_NUMBER','like','%'.$search.'%');
                                $q->orwhere('BORROW_COMMENT','like','%'.$search.'%');  
                                $q->orwhere('BORROW_HR_PERSON_NAME','like','%'.$search.'%');
                                $q->orwhere('BORROW_HR_DEP_SUB_SUB_NAME','like','%'.$search.'%');    
                            })
                            ->WhereBetween('BORROW_DATE',[$from,$to]) 
                            ->orderBy('BORROW_ID', 'desc') 
                            ->get(); 
                    }else{    
                        $inforSalaryborrow =  Salaryborrow::where('BORROW_STATUS','=',$status)
                            ->where(function($q) use ($search){
                                $q->where('BORROW_NUMBER','like','%'.$search.'%');
                                $q->orwhere('BORROW_COMMENT','like','%'.$search.'%');  
                                $q->orwhere('BORROW_HR_PERSON_NAME','like','%'.$search.'%');
                                $q->orwhere('BORROW_HR_DEP_SUB_SUB_NAME','like','%'.$search.'%');    
                            })
                            ->WhereBetween('BORROW_DATE',[$from,$to]) 
                            ->orderBy('BORROW_ID', 'desc') 
                            ->get();                
            }

            $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
            $year_id = $yearbudget;

            $sastatus = DB::table('salary_borrow_status')->get();

            return view('person_headorg.headorg_borrow',[
                'inforSalaryborrows' => $inforSalaryborrow, 
                'budgets' =>  $budget,
                'displaydate_bigen'=> $displaydate_bigen,
                'displaydate_end'=> $displaydate_end,
                'status_check'=> $status,
                'sastatus'=> $sastatus,
                'search'=> $search,
                'year_id'=>$year_id,
            ]);

}



public function borrow_lastapp(Request $request)
{
  $id = $request->ID;

  $check =  $request->SUBMIT;

  if($check == 'approved'){
    $statuscode = 'SUCCESS';

  }else{
    $statuscode = 'NOTSUCCESS'; 
  }

    $updatelastapp = Salaryborrow::find($id);
    $updatelastapp->BORROW_STATUS = $statuscode;
    $updatelastapp->save();

    return redirect()->route('horg.borrow');

}

 public static function countbook()
 {
      $count = Bookindex::leftJoin('grecord_org','gbook_index.BOOK_ORG_ID','=','grecord_org.RECORD_ORG_ID')
    ->leftJoin('hrd_person','gbook_index.PERSON_SAVE_ID','=','hrd_person.ID')
    ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->leftJoin('gbook_index_send_leader','gbook_index.BOOK_ID','=','gbook_index_send_leader.BOOK_LD_ID')
    ->where('SEND_STATUS','=',4)
    ->where('BOOK_USE','=','true')
    ->orderBy('gbook_index.BOOK_ID', 'desc') 
    ->count();

    return $count;
 }


 public static function countleave()
 {
    $count=  Leave_register::select('gleave_register.ID','STATUS_CODE','STATUS_NAME','LEAVE_YEAR_ID','LEAVE_PERSON_FULLNAME','POSITION_IN_WORK','HR_DEPARTMENT_SUB_SUB_NAME','LEAVE_TYPE_NAME','LEAVE_BECAUSE','LEAVE_DATE_BEGIN','LEAVE_DATE_END','WORK_DO','LEAVE_WORK_SEND','USER_CONFIRM_CHECK','LEAVE_YEAR_ID','LEAVE_PERSON_FULLNAME','LEAVE_BECAUSE','LOCATION_NAME','LEAVE_WORK_SEND','DAY_TYPE_ID','LEAVE_DATE_BEGIN','LEAVE_DATE_END','LEAVE_CONTACT_PHONE','LEAVE_CONTACT','LEAVE_SUM_ALL','LEAVE_SUM_SETSUN','LEAVE_SUM_HOLIDAY')
    ->leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_ID')
    ->leftJoin('hrd_person','gleave_register.LEAVE_PERSON_ID','=','hrd_person.ID')
    ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
    ->leftJoin('gleave_status','gleave_register.LEAVE_STATUS_CODE','=','gleave_status.STATUS_CODE')
    ->leftJoin('gleave_location','gleave_register.LOCATION_ID','=','gleave_location.LOCATION_ID')
    ->where('LEAVE_STATUS_CODE','=','Verify')
    ->orderBy('gleave_register.ID', 'desc')
    ->count();

    return $count;
 }


 public static function countdevapp()
 {
     
    $count =  Recordindex::select('grecord_index.ID as ID','grecord_index.STATUS','STATUS_NAME','RECORD_TYPE_NAME','USER_POST_NAME','RECORD_HEAD_USE','LOCATION_ORG_NAME','RECORD_LEVEL_NAME','RECORD_ORGANIZER_NAME','gleave_location.LOCATION_NAME','DATE_GO','DATE_BACK','RECORD_COMMENT','RECORD_GO_NAME','RECORD_VEHICLE_NAME','WITHDRAW_NAME','LEADER_HR_NAME','OFFER_WORK_HR_NAME','BOOK_NUM','SUMMONEY')
    ->leftJoin('grecord_status','grecord_index.STATUS','=','grecord_status.STATUS')
    ->leftJoin('grecord_type','grecord_index.RECORD_TYPE_ID','=','grecord_type.RECORD_TYPE_ID')
    ->leftJoin('grecord_org_location','grecord_org_location.LOCATION_ID','=','grecord_index.RECORD_LOCATION_ID')
    ->leftJoin('grecord_level','grecord_level.ID','=','grecord_index.RECORD_LEVEL_ID')
    ->leftJoin('gleave_location','gleave_location.LOCATION_ID','=','grecord_index.LOCATION_PROV_ID')
    ->leftJoin('grecord_go','grecord_go.RECORD_GO_ID','=','grecord_index.RECORD_GO_ID')
    ->leftJoin('grecord_vehicle','grecord_vehicle.RECORD_VEHICLE_ID','=','grecord_index.RECORD_VEHICLE_ID')
    ->leftJoin('grecord_withdraw','grecord_withdraw.WITHDRAW_ID','=','grecord_index.RECORD_MONEY_ID')
    ->leftJoin('grecord_index_money','grecord_index_money.RECORD_ID','=','grecord_index.ID')
    ->where('grecord_index.STATUS','=','RECEIVE')
    ->orderBy('grecord_index.ID', 'desc')  
    ->count();

    return $count;
 }


 public static function countcar()
 {
    $count =Vehiclecarreserve::leftJoin('grecord_org_location','vehicle_car_reserve.RESERVE_LOCATION_ID','=','grecord_org_location.LOCATION_ID')
    ->leftJoin('vehicle_car_index','vehicle_car_reserve.CAR_SET_ID','=','vehicle_car_index.CAR_ID')
    ->leftJoin('hrd_person','vehicle_car_reserve.RESERVE_PERSON_ID','=','hrd_person.ID')
    ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->where('STATUS','=','SUCCESS')
    ->orderBy('RESERVE_ID', 'desc') 
    ->count();

    return $count;
 }

 public static function countsupplier()
 {
    $count = Suppliesrequest::leftJoin('supplies_request_status','supplies_request_status.STATUS_CODE','=','supplies_request.STATUS')
    ->orderBy('supplies_request.ID', 'desc')
    ->where('STATUS','=','Verify')
    ->count();

    return $count;
 }


 public static function countmeet()
 {
    $count =  Meetingroomservice::leftJoin('meetingroom_index','meetingroom_index.ROOM_ID','=','meetingroom_service.ROOM_ID')
    ->leftJoin('meetingroom_service_status','meetingroom_service_status.STATUS_CODE','=','meetingroom_service.STATUS')
    ->leftJoin('meetingroom_objective','meetingroom_objective.OBJECTIVE_ID','=','meetingroom_service.SERVICE_FOR')
    ->Where('STATUS','=','SUCCESS') 
    ->orderBy('meetingroom_service.ID', 'desc')  
    ->count();

    return $count;
 }
 

 public static function countborrow()
 {
    $count =  Salaryborrow::orderBy('BORROW_ID', 'desc') 
    ->count(); 

    return $count;
 }
 

 public function infoleavecalender(){


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
    $inforleave = $inforleave->orderBy('gleave_register.ID', 'desc')->get();

    $inforleavess =  Leave_register::select('gleave_register.ID','STATUS_CODE','STATUS_NAME','LEAVE_YEAR_ID','LEAVE_PERSON_FULLNAME','POSITION_IN_WORK','HR_DEPARTMENT_SUB_SUB_NAME','LEAVE_TYPE_NAME','LEAVE_BECAUSE','LEAVE_DATE_BEGIN','LEAVE_DATE_END','WORK_DO','LEAVE_WORK_SEND','USER_CONFIRM_CHECK','LEAVE_YEAR_ID','LEAVE_PERSON_FULLNAME','LEAVE_BECAUSE','LOCATION_NAME','LEAVE_WORK_SEND','DAY_TYPE_ID','LEAVE_DATE_BEGIN','LEAVE_DATE_END','LEAVE_CONTACT_PHONE','LEAVE_CONTACT','LEAVE_SUM_ALL','LEAVE_SUM_SETSUN','LEAVE_SUM_HOLIDAY','LEAVE_APP_H1','LEAVE_APP_H2')
    ->leftJoin('gleave_type','gleave_register.LEAVE_TYPE_CODE','=','gleave_type.LEAVE_TYPE_ID')
    ->leftJoin('hrd_person','gleave_register.LEAVE_PERSON_ID','=','hrd_person.ID')
    ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
    ->leftJoin('gleave_status','gleave_register.LEAVE_STATUS_CODE','=','gleave_status.STATUS_CODE')
    ->leftJoin('gleave_location','gleave_register.LOCATION_ID','=','gleave_location.LOCATION_ID')
    ->where('LEAVE_STATUS_CODE','=','Verify')
    ->orderBy('gleave_register.ID', 'desc')
    ->get();

    
    
    return view('person_headorg.headorg_leave_calender', $data,[
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
    
 


}

