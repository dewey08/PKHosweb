<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Person;
use App\Models\Incidence;
use Illuminate\Support\Facades\Session;
use App\Models\Risk_internalcontrol;
use App\Models\Risk_internalcontrol_sub;
use App\Models\Guesthousinfomation;
use App\Models\Guesthousinfomationperson;

use PDF;
use Alert;

class ReportguesthouseController extends Controller
{
  
  function report_guesthouse(Request $request)
  {   
 
    $report_gesth = DB::table('guesthous_infomation')
      ->get();

      foreach ($report_gesth as $reportgesth) {
        $id = $reportgesth->INFMATION_ID;
        $level = DB::table('supplies_location_level')->where('LOCATION_ID','=',$id)->first();

        $countcheckl  =  DB::table('guesthous_infomation_person')->where('LOCATION_LEVEL_ID','=',$id)->count();

          $checkroom = DB::table('guesthous_infomation_person')->where('INFMATION_ID','=',$reportgesth->INFMATION_ID)->where('INFMATION_PERSON_STATUS','=','1')->get();

      }


  $infomation = DB::table('guesthous_infomation')->first();

  $lo = DB::table('supplies_location')->where('LOCATION_ID','=',$infomation->LOCATION_ID)->first();


    return view('reportguesthouse.report_guesthouse',[
      'report_gesths' => $report_gesth,
      // 'countcheck' => $countcheck,
      'checkroom' => $checkroom,

    ]);    

  }

  public function report_guesthouse_excel()
  {
    $report_gesth = DB::table('guesthous_infomation')
    ->get();

      $orgname =  DB::table('info_org')
          ->leftJoin('hrd_person','info_org.ORG_LEADER_ID','=','hrd_person.ID')
          ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
          ->first();

      return view('reportguesthouse.report_guesthouse_excel',[
          'report_gesths' => $report_gesth,
          'orgname' => $orgname,
      ]);
  
  }

  public static function roomcount($idroom)
  {
   $ro = Guesthousinfomationperson::where('LEVEL_ROOM_ID','=',$idroom)
      ->count(); 
                  
      return $ro;
  }

  function report_guesthouse_person(Request $request)
  {     

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

    $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
    $year_id = $yearbudget;
    $year = $year_id - 543;

    $infostatus = DB::table('guesthous_petition_status')->get();

    $report_info = DB::table('guesthous_infomation')->first();

    $report_gesthper = DB::table('guesthous_infomation') 
        ->leftJoin('guesthous_infomation_person','guesthous_infomation.INFMATION_ID','=','guesthous_infomation_person.INFMATION_ID')    
        ->leftJoin('supplies_location_level_room','supplies_location_level_room.LEVEL_ROOM_ID','=','guesthous_infomation_person.LEVEL_ROOM_ID') 
        ->leftJoin('hrd_person','hrd_person.ID','=','guesthous_infomation_person.INFMATION_PERSON_HRID') 
        ->leftJoin('hrd_position','hrd_position.HR_POSITION_ID','=','hrd_person.HR_POSITION_ID') 
        ->leftJoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_SUB_ID') 
        ->orderBy('guesthous_infomation.created_at', 'desc')
        ->get();


    return view('reportguesthouse.report_guesthouse_person',[
      'report_gesthpers' => $report_gesthper,
      'displaydate_bigen'=> $displaydate_bigen, 
      'displaydate_end'=> $displaydate_end,
      'status_check'=> $status,
      'search'=> $search,
      'budgets' =>  $budget,
      'year_id'=>$year_id
    ]);    

  }

  public function report_guesthouse_person_excel()
  {
  
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

    $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
    $year_id = $yearbudget;
    $year = $year_id - 543;

    $infostatus = DB::table('guesthous_petition_status')->get();

    $report_info = DB::table('guesthous_infomation')->first();

    $report_gesthper = DB::table('guesthous_infomation') 
        ->leftJoin('guesthous_infomation_person','guesthous_infomation.INFMATION_ID','=','guesthous_infomation_person.INFMATION_ID')    
        ->leftJoin('supplies_location_level_room','supplies_location_level_room.LEVEL_ROOM_ID','=','guesthous_infomation_person.LEVEL_ROOM_ID') 
        ->leftJoin('hrd_person','hrd_person.ID','=','guesthous_infomation_person.INFMATION_PERSON_HRID') 
        ->leftJoin('hrd_position','hrd_position.HR_POSITION_ID','=','hrd_person.HR_POSITION_ID') 
        ->leftJoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_SUB_ID') 
        ->orderBy('guesthous_infomation.created_at', 'desc')
        ->get();

      $orgname =  DB::table('info_org')
          ->leftJoin('hrd_person','info_org.ORG_LEADER_ID','=','hrd_person.ID')
          ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
          ->first();

      return view('reportguesthouse.report_guesthouse_person_excel',[
        'report_gesthpers' => $report_gesthper,
        'displaydate_bigen'=> $displaydate_bigen, 
        'displaydate_end'=> $displaydate_end,
        'status_check'=> $status,
        'search'=> $search,
        'budgets' =>  $budget,
        'year_id'=>$year_id,
          'orgname' => $orgname,
      ]);
  
  }





  function report_guesthouse_person_search(Request $request)
  {     

        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;
        }      

        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';
      
        $datebigin = $request->get('DATE_BIGIN');
        $dateend = $request->get('DATE_END');
        $yearbudget = $request->BUDGET_YEAR;
        

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
        $display_date_bigen= $y."-".$m."-".$d;

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
        $display_date_end= $y_e."-".$m_e."-".$d_e;


        $from = date($display_date_bigen);
        $to = date($display_date_end); 

        $report_info = DB::table('guesthous_infomation')
        ->WhereBetween('guesthous_infomation.created_at',[$from.' 00:00:00',$to.' 23:59:00']) 
        ->first();

        $report_gesthper = DB::table('guesthous_infomation') 
            ->leftJoin('guesthous_infomation_person','guesthous_infomation.INFMATION_ID','=','guesthous_infomation_person.INFMATION_ID')    
            ->leftJoin('supplies_location_level_room','supplies_location_level_room.LEVEL_ROOM_ID','=','guesthous_infomation_person.LEVEL_ROOM_ID') 
            ->leftJoin('hrd_person','hrd_person.ID','=','guesthous_infomation_person.INFMATION_PERSON_HRID') 
            ->leftJoin('hrd_position','hrd_position.HR_POSITION_ID','=','hrd_person.HR_POSITION_ID') 
            ->leftJoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_SUB_ID')         
            ->WhereBetween('guesthous_infomation_person.INFMATION_PERSON_INDATE',[$from.' 00:00:00',$to.' 23:59:00']) 
            ->orderBy('guesthous_infomation.created_at', 'desc')
            ->get();

      $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $year_id = $yearbudget;
        $year = $year_id - 543;

        return view('reportguesthouse.report_guesthouse_person_search',[
          'report_gesthpers' => $report_gesthper,
          'displaydate_bigen'=> $displaydate_bigen, 
          'displaydate_end'=> $displaydate_end,
          'budgets' =>  $budget,
          'year_id'=>$year_id,
          'report_infos' => $report_info,
          'from' => $from,
          'to' => $to,
        ]);    

  }

  function report_guesthouse_person_pdf(Request $request)
  {
    
    $m_budget = date("m");
    if($m_budget>9){
    $yearbudget = date("Y")+544;
    }else{
    $yearbudget = date("Y")+543;
    }      

    $displaydate_bigen = ($yearbudget-544).'-10-01';
    $displaydate_end = ($yearbudget-543).'-09-30';
   
    $datebigin = $request->get('DATE_BIGIN');
    $dateend = $request->get('DATE_END');
  

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
    $display_date_bigen= $y."-".$m."-".$d;

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
    $display_date_end= $y_e."-".$m_e."-".$d_e;


    $from = date($display_date_bigen);
    $to = date($display_date_end); 

    $report_info = DB::table('guesthous_infomation')
    ->WhereBetween('guesthous_infomation.created_at',[$from.' 00:00:00',$to.' 23:59:00']) 
    ->first();

    $report_gesthper = DB::table('guesthous_infomation') 
        ->leftJoin('guesthous_infomation_person','guesthous_infomation.INFMATION_ID','=','guesthous_infomation_person.INFMATION_ID')    
        ->leftJoin('supplies_location_level_room','supplies_location_level_room.LEVEL_ROOM_ID','=','guesthous_infomation_person.LEVEL_ROOM_ID') 
        ->leftJoin('hrd_person','hrd_person.ID','=','guesthous_infomation_person.INFMATION_PERSON_HRID') 
        ->leftJoin('hrd_position','hrd_position.HR_POSITION_ID','=','hrd_person.HR_POSITION_ID') 
        ->leftJoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_SUB_ID')         
        ->WhereBetween('guesthous_infomation_person.INFMATION_PERSON_INDATE',[$from.' 00:00:00',$to.' 23:59:00']) 
        ->orderBy('guesthous_infomation.created_at', 'desc')
        ->get();

  $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
    $year_id = $yearbudget;
    $year = $year_id - 543;

    $orgname =  DB::table('info_org')
    ->leftJoin('hrd_person','info_org.ORG_LEADER_ID','=','hrd_person.ID')
    ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->first();
  
  $pdf = PDF::loadView('reportguesthouse.report_guesthouse_person_pdf',[
    'report_gesthpers' => $report_gesthper,
    'displaydate_bigen'=> $displaydate_bigen, 
    'displaydate_end'=> $displaydate_end,
    'budgets' =>  $budget,
    'year_id'=>$year_id,
    'report_infos' => $report_info,
    'orgname' => $orgname,
      ]);
      $pdf->setOptions([
          'mode' => 'utf-8',           
          'default_font_size' => 15,
          'defaultFont' => 'THSarabunNew',
          'margin-left','5'                       
          ]);
      $pdf->setPaper('a4', 'landscape');
      return @$pdf->stream();
  }


  public static function amountroom($id_location)
{
   $count = DB::table('supplies_location_level_room')
   ->leftJoin('supplies_location_level','supplies_location_level_room.LOCATION_LEVEL_ID','=','supplies_location_level.LOCATION_LEVEL_ID')
   ->leftJoin('guesthous_infomation','supplies_location_level.LOCATION_ID','=','guesthous_infomation.LOCATION_ID')
   ->where('guesthous_infomation.LOCATION_ID','=',$id_location)->count();

  return $count;
   
} 

public static function amountroomuser($id_infomatipn)
{

  $infos = DB::table('guesthous_infomation_person')
  ->select(DB::raw('count(*) as count, LEVEL_ROOM_ID'))
  ->where('INFMATION_PERSON_STATUS','=','1')
  ->where('INFMATION_ID','=',$id_infomatipn)
  ->groupBy('LEVEL_ROOM_ID')
  ->get();

   $number = 0;
   foreach ($infos as $info) {
    $number++;   
  }


  return $number;

   
} 

public static function amountperson($id_infomatipn)
{

  $count = DB::table('guesthous_infomation_person')
  ->where('INFMATION_PERSON_STATUS','=','1')
  ->where('INFMATION_ID','=',$id_infomatipn)->count();

  return $count;
} 






  
}
