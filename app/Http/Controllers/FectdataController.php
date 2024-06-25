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
use App\Models\Risk_internalcontrol_subsub;
use App\Models\Riskrep;
use App\Models\Risk_setupincidence_level;
use App\Models\Risk_internalcontrol_subsub_detail;
use App\Models\Risk_notify_repeat_sub;
use App\Models\Risk_notify_accept_sub;
use App\Models\Risk_notify_repeat_sub_infer;
use App\Models\Risk_notify_repeat_sub_inferlist;
use App\Models\Risk_notify_repeat_sub_board;
use App\Models\Risk_notify_repeat_sub_board_out;
use App\Models\Risk_notify_repeat_sub_topic_infer;
use App\Models\Risk_internalcontrol_subsub_detail_sub;
use App\Models\Risk_internalcontrol_subsub_detail_make;
use App\Models\Risk_internalcontrol_subsub_detail_risk;
use App\Models\Risk_internalcontrol_pk5_depart;
use App\Models\Risk_internalcontrol_pk5_depart_sub;
use App\Models\Risk_internalcontrol_pk5_depart_subsub;
use App\Models\Risk_internalcontrol_pk5_depart_subsub_detail;
use App\Models\Risk_internalcontrol_pk5;
use App\Models\Risk_internalcontrol_pk5_sub;
use App\Models\Risk_internalcontrol_organi;
use App\Models\Risk_internalcontrol_organi_sub;
use App\Models\Risk_rep_time;
use App\Models\Risk_rep_location;
use App\Models\Risk_rep_group;
use App\Models\Risk_rep_groupsub;
use App\Models\Risk_rep_groupsubsub;
use App\Models\Risk_rep_detail;
use App\Models\Risk_rep_items;
use App\Models\Env_parameter_sub;
use App\Models\Env_parameter;
use PDF;
use Alert;

class FectdataController extends Controller
{
    //---------------------------ฟังชัน------------------------------
    function fectprogram(Request $request)
    {       
      $id = $request->get('select');
      $result=array();
      $query= DB::table('risk_rep_program_sub')
      ->where('RISK_REPPROGRAM_ID','=',$id)
      ->get();
      $output='<option value="">--กรุณาเลือก--</option>';      
      foreach ($query as $row){
            $output.= '<option value="'.$row->RISK_REPPROGRAMSUB_ID.'">'.$row->RISK_REPPROGRAMSUB_NAME.'</option>';
    }
    echo $output;        
    }

    function fectprogramsub(Request $request)
    {       
      $id = $request->get('select');
      $result=array();
      $query= DB::table('risk_rep_program_subsub')
      ->where('RISK_REPPROGRAMSUB_ID','=',$id)
      ->get();
      $output='<option value="">--กรุณาเลือก--</option>';      
      foreach ($query as $row){
            $output.= '<option value="'.$row->RISK_REPPROGRAMSUBSUB_ID.'">'.$row->RISK_REPPROGRAMSUBSUB_NAME.'</option>';
    }
    echo $output;        
    }

  function fectteam(Request $request)
  {
   
        $id = $request->get('select');
        $result=array();
        $query= DB::table('hrd_team_list')->where('TEAM_ID',$id)->get();

        $infopersons = DB::table('hrd_person')->where('HR_STATUS_ID','=',1)->get();

        $output='';
            
        foreach ($query as $row){

              $output.= '<tr height="40">
              <td>
                  <select name="HR_TEAM_ID[]" id="HR_TEAM_ID[]" class="form-control input-sm fo13" style="width: 100%">
                              <option value="" selected>--กรุณาเลือก--</option>';
                              foreach ($infopersons as $infoperson) { 
                            
                                  if($row->PERSON_ID == $infoperson->ID){
                                      $output.= '<option value="'.$infoperson ->ID.'" selected>'.$infoperson->HR_FNAME.' '.$infoperson->HR_LNAME.'</option>'; 
                                  }else{
                                      $output.= '<option value="'.$infoperson ->ID.'">'.$infoperson->HR_FNAME.' '.$infoperson->HR_LNAME.'</option>'; 
                                  }
                              }                        
                              $output.= '</select>

              </td>       
              <td style="text-align: center;"><a class="btn btn-hero-sm btn-hero-danger remove" style="color:#FFFFFF;"><i class="fa fa-trash-alt"></i></a></td>
          </tr>';          
          }
      echo $output;          
  }

  function fecttypelocation(Request $request)
  {   
        $id = $request->get('select');
        $result=array();
        $query= DB::table('risk_rep_location')
        ->where('SETUP_TYPELOCATION_ID','=',$id)
        ->get();
        $output='<option value="">--กรุณาเลือก--</option>';
        
        foreach ($query as $row){
              $output.= '<option value="'.$row->RISK_LOCATION_ID.'">'.$row->RISK_LOCATION_NAME.'</option>';
      }
      echo $output;        
  }

  function fectgroup(Request $request)
  {   
        $id = $request->get('select');
        $result=array();
        $query= DB::table('risk_rep_groupsub')
        ->where('RISK_GROUP_ID','=',$id)
        ->get();
        $output='<option value="">--กรุณาเลือก--</option>';
        
        foreach ($query as $row){
              $output.= '<option value="'.$row->RISK_GROUPSUB_ID.'">'.$row->RISK_GROUPSUB_NAME.'</option>';
      }
      echo $output;        
  }
  function fectgroupsub(Request $request)
  {   
        $id = $request->get('select');
        $result=array();
        $query= DB::table('risk_rep_groupsub_sub')
        ->where('RISK_GROUPSUB_ID','=',$id)
        ->get();
        $output='<option value="">--กรุณาเลือก--</option>';
        
        foreach ($query as $row){
              $output.= '<option value="'.$row->RISK_GROUPSUBSUB_ID.'">'.$row->RISK_GROUPSUBSUB_NAME.'</option>';
      }
      echo $output;        
  }
  function fectgroupsubsub(Request $request)
  {   
        $id = $request->get('select');
        $result=array();
        $query= DB::table('risk_rep_detail')
        ->where('RISK_GROUPSUBSUB_ID','=',$id)
        ->get();
        $output='<option value="">--กรุณาเลือก--</option>';
        
        foreach ($query as $row){
              $output.= '<option value="'.$row->RISK_REPDETAIL_ID.'">'.$row->RISK_REPDETAIL_NAME.'</option>';
      }
      echo $output;        
  }
  function fectitems(Request $request)
  {   
        $id = $request->get('select');
        $result=array();
        $query= DB::table('risk_rep_items_sub')
        ->where('RISK_REPITEMS_ID','=',$id)
        ->get();
        $output='<option value="">--กรุณาเลือก--</option>';
        
        foreach ($query as $row){
              $output.= '<option value="'.$row->RISK_REPITEMSSUB_ID.'">'.$row->RISK_REPITEMSSUB_NAME.'</option>';
      }
      echo $output;        
  }
  function fectriskdepsub(Request $request)
  {
     
    $id = $request->get('select');
    $result=array();

    if($id == '1'){
      $query= DB::table('hrd_department')->get();
    }elseif($id == '2'){
      $query= DB::table('hrd_department_sub')->get();
    }elseif($id == '3'){
      $query= DB::table('hrd_department_sub_sub')->get();
    }else{
        $query= DB::table('hrd_team')->get();
    }
  

    $output='<option value="">--กรุณาเลือก--</option>';
    
    foreach ($query as $row){

      if($id == '1'){           
            $output.= '<option value="'.$row->HR_DEPARTMENT_ID.'">'.$row->HR_DEPARTMENT_NAME.'</option>'; 
        }elseif($id == '2'){
            $output.= '<option value="'.$row->HR_DEPARTMENT_SUB_ID.'">'.$row->HR_DEPARTMENT_SUB_NAME.'</option>'; 
        }elseif($id == '3'){
            $output.= '<option value="'.$row->HR_DEPARTMENT_SUB_SUB_ID.'">'.$row->DEP_CODE.' : '.$row->HR_DEPARTMENT_SUB_SUB_NAME.'</option>'; 
        }else{
            $output.= '<option value="'.$row->HR_TEAM_NAME.'">'.$row->HR_TEAM_NAME.' : '.$row->HR_TEAM_DETAIL.'</option>';
        }
      }
  echo $output;      
  }
  function fectscope(Request $request)
  {       
    $id = $request->get('select');
    $result=array();
    $query= DB::table('risk_account_riskeffect')
    ->where('RISK_ACCOUNTSCOPE_ID','=',$id)
    ->get();
    $output='<option value="">--กรุณาเลือก--</option>';      
    foreach ($query as $row){
          $output.= '<option value="'.$row->RISK_ACCOUNTRISKEFFECT_ID.'">'.$row->RISK_ACCOUNTRISKEFFECT_CODE.'</option>';
  }
  echo $output;        
  }

  function fectriskeffect(Request $request)
  {       
    $id = $request->get('select');
    $result=array();
    $query= DB::table('risk_account_risk_level')
    ->where('RISK_ACCOUNTRISKEFFECT_ID','=',$id)
    ->get();
 
    $output='<option value="">--กรุณาเลือก--</option>';  
    foreach ($query as $row){
          $output.= '<option value="'.$row->RISK_ACCOUNTRISKLEVEL_ID.'">'.$row->RISK_ACCOUNTRISKLEVEL_CODE.' : '.$row->RISK_ACCOUNTRISKLEVEL_NAME.'</option>';
  }
  echo $output;        
  }


  public static function checkleader_sub($id_user)
  {
       $inforpersonuserid =  Person::where('ID','=',$id_user)->first();
       $iddepartment_sub = $inforpersonuserid -> HR_DEPARTMENT_SUB_SUB_ID;
    if( $iddepartment_sub == '' ||  $iddepartment_sub == null){
        $idleader = '';
       }else{
        $idleaderdepartment =  DB::table('hrd_department_sub_sub')->where('HR_DEPARTMENT_SUB_SUB_ID','=', $iddepartment_sub)->first();
        $idleader = $idleaderdepartment -> LEADER_HR_ID;
       }
       return $idleader;
  }

  public static function anaresult($id)
  {
      $idpara = Env_parameter::first();
      $anaresult =  Env_parameter_sub::where('LIST_PARAMETER_IDD','=',$id)
      ->where('PARAMETER_ID','=',$idpara->PARAMETER_ID)
      ->sum('ANALYSIS_RESULTS');                         
      return $anaresult;
  }

  public static function roomcount($id)
  {
   $ro = DB::table('guesthous_infomation_person')
      ->where('LEVEL_ROOM_ID','=',$id)
      ->count(); 
      
      if ($ro != 0) {
        # code...
      } else {
        # code...
      }
      
      return $ro;
  }
  
}
