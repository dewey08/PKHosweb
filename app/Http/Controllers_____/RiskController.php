<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Person;
use App\Models\Riskrep;
use App\Models\Risk_notify_repeat_sub;
use App\Models\Risk_notify_accept_sub;
use App\Models\Risk_notify_repeat_sub_infer;
use App\Models\Risk_notify_repeat_sub_inferlist;
use App\Models\Risk_notify_repeat_sub_board;
use App\Models\Risk_notify_repeat_sub_board_out;
use App\Models\Risk_notify_repeat_sub_topic_infer;
use App\Models\Risk_setupincidence_level;
use App\Models\Risk_internalcontrol;
use App\Models\Risk_internalcontrol_sub;
use App\Models\Risk_internalcontrol_subsub;
use App\Models\Risk_internalcontrol_subsub_detail_sub;
use App\Models\Risk_account;
use App\Models\Risk_account_type;
use App\Models\Risk_internalcontrol_analyze;
use App\Models\Risk_account_detail;
use App\Models\Risk_account_detail_level;
use App\Models\Risk_notify_report5;
use App\Models\Risk_notify_report5_sub;
use App\Models\Risk_notify_report4;

use App\Models\Risk_rep_time;
use App\Models\Risk_rep_location;
use App\Models\Risk_rep_group;
use App\Models\Risk_rep_groupsub;
use App\Models\Risk_rep_groupsubsub;
use App\Models\Risk_rep_detail;
use App\Models\Risk_rep_items;
use App\Models\Risk_rep_program;
use App\Models\Risk_rep_program_sub;
use App\Models\Risk_rep_program_subsub;
use App\Models\Risk_rep_typereason;
use App\Models\Risk_rep_typereason_sys;
use App\Models\Risk_rep_level;
use App\Models\Team;
use App\Models\Risk_rep_items_sub;
use App\Models\Risk_rep_usereffect;
use App\Models\Risk_rep_teamlist;
use App\Models\Risk_rep_department;
use App\Models\Risk_rep_department_sub;
use App\Models\Risk_rep_department_subsub;
use App\Models\Risk_rep_infoperson;
use App\Models\Riskrecheck;

use App\Models\Permislist;


date_default_timezone_set('Asia/Bangkok');
class RiskController extends Controller
{
  
    public function dashboard_risk(Request $request,$iduser)
    {
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

        $year = date('Y');
        $year_id = $year+543;

        $level_A = DB::table('risk_rep')->where('RISKREP_LEVEL','=','A')->count();
        $level_B = DB::table('risk_rep')->where('RISKREP_LEVEL','=','B')->count();  
        $level_C = DB::table('risk_rep')->where('RISKREP_LEVEL','=','C')->count(); 
        $level_D = DB::table('risk_rep')->where('RISKREP_LEVEL','=','D')->count(); 
        $level_E = DB::table('risk_rep')->where('RISKREP_LEVEL','=','E')->count(); 
        $level_F = DB::table('risk_rep')->where('RISKREP_LEVEL','=','F')->count(); 
        $level_G = DB::table('risk_rep')->where('RISKREP_LEVEL','=','G')->count(); 
        $level_H = DB::table('risk_rep')->where('RISKREP_LEVEL','=','H')->count(); 
        $level_I = DB::table('risk_rep')->where('RISKREP_LEVEL','=','I')->count();     
        $levelAI_piechart = DB::table('risk_rep')
                    ->select(DB::raw('count(*) as level_count,RISKREP_LEVEL'),'RISKREP_LEVEL')                   
                    ->where('RISKREP_DATESAVE','like',$year.'%')
                    ->groupBy('RISKREP_LEVEL')
                    ->get();

       
        $lev_C = DB::table('risk_rep')->where('RISKREP_LEVEL','=','C')->count(); 
        $lev_D = DB::table('risk_rep')->where('RISKREP_LEVEL','=','D')->count(); 
        $lev_E = DB::table('risk_rep')->where('RISKREP_LEVEL','=','E')->count();  
        $lev_H = DB::table('risk_rep')->where('RISKREP_LEVEL','=','H')->count(); 
          
        $levAI_piechart = DB::table('risk_rep')
                    ->select(DB::raw('count(*) as lev_count,RISKREP_LEVEL'),'RISKREP_LEVEL')                   
                    ->where('RISKREP_DATESAVE','like',$year.'%')
                    ->groupBy('RISKREP_LEVEL')
                    ->get();          
            
        $levels_1 = DB::table('risk_rep')->where('RISKREP_LEVEL','=',1)->count(); 
        $levels_2 = DB::table('risk_rep')->where('RISKREP_LEVEL','=',2)->count(); 

        $lec_A = DB::table('risk_rep')->where('RISKREP_LEVEL','=','A')->count(); 
        $lec_B = DB::table('risk_rep')->where('RISKREP_LEVEL','=','B')->count(); 
        $lec_C = DB::table('risk_rep')->where('RISKREP_LEVEL','=','C')->count();  
        $lec_D = DB::table('risk_rep')->where('RISKREP_LEVEL','=','D')->count(); 
        $lec_E = DB::table('risk_rep')->where('RISKREP_LEVEL','=','E')->count(); 

        $SEX_1 = DB::table('risk_rep')->where('RISKREP_SEX','=','M')->count();
        $SEX_2 = DB::table('risk_rep')->where('RISKREP_SEX','=','F')->count();       
        $sex_piechart = DB::table('risk_rep')
                    ->select(DB::raw('count(*) as sex_count,RISKREP_SEX'),'RISKREP_SEX')                   
                    ->where('RISKREP_DATESAVE','like',$year.'%')
                    ->groupBy('RISKREP_SEX')
                    ->get();
                       
        $AGE_1 = DB::table('risk_rep')->WhereBetween('RISKREP_AGE',[1,15])->count();
        $AGE_2 = DB::table('risk_rep')->WhereBetween('RISKREP_AGE',[16,35])->count();   
        $AGE_3 = DB::table('risk_rep')->WhereBetween('RISKREP_AGE',[36,55])->count();  
        $AGE_4 = DB::table('risk_rep')->WhereBetween('RISKREP_AGE',[56,75])->count();   
        $AGE_5 = DB::table('risk_rep')->WhereBetween('RISKREP_AGE',[76,120])->count();     
        $age_piechart = DB::table('risk_rep')
                    ->select(DB::raw('count(*) as age_count,RISKREP_AGE'),'RISKREP_AGE')                   
                    ->where('RISKREP_DATESAVE','like',$year.'%')
                    ->groupBy('RISKREP_AGE')
                    ->get();           

        return view('general_risk.dashboard_risk',[
            'inforpersonuserid' => $inforpersonuserid,
            'inforpersonuser' => $inforpersonuser,
            'level_A' => $level_A, 'level_B' => $level_B, 'level_C' => $level_C, 'level_D' => $level_D, 'level_E' => $level_E, 'level_F' => $level_F, 'level_G' => $level_G,'level_H' => $level_H,'level_I' => $level_I,
            'levelAI_piecharts' => $levelAI_piechart,
            'lev_C' => $lev_C, 'lev_D' => $lev_D, 'lev_E' => $lev_E,'lev_H' => $lev_H,
            'levAI_piecharts' => $levAI_piechart,
            'year_id'=>$year_id ,
            'levels_1' => $levels_1, 'levels_2' => $levels_2,
            'lec_A' => $lec_A, 'lec_B' => $lec_B, 'lec_C' => $lec_C,'lec_D' => $lec_D,'lec_E' => $lec_E,
            'SEX_1' => $SEX_1,
            'SEX_2' => $SEX_2,
            'sexpiechart' => $sex_piechart,
            'AGE_1' => $AGE_1,
            'AGE_2' => $AGE_2,
            'AGE_3' => $AGE_3,
            'AGE_4' => $AGE_4,
            'AGE_5' => $AGE_5,
            'agepiechart' => $age_piechart,
            
            ]);
    }
//===========================================================================//
    function selectbudget(Request $request)
    {    
        function formate($strDate)
        {
        $strYear = date("Y",strtotime($strDate));
        $strMonth= date("m",strtotime($strDate));
        $strDay= date("d",strtotime($strDate));


        return $strDay."/".$strMonth."/".$strYear;
        }
        $yearbudget = $request->get('select');

        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';
        

        $output = ' <div class="row">
        <div class="col-sm-3 text-right" style="font-family:\'Kanit\',sans-serif;">
        <label>วันที่</label>
        </div>
        <div class="col-md-4">   
            <input  name = "DATE_BIGIN"  id="DATE_BIGIN"  class="form-control input-lg datepicker" data-date-format="mm/dd/yyyy"  value="'.formate($displaydate_bigen).'" readonly>     
        </div>
        <div class="col-sm-1">
            <label>ถึง</label>
        </div>
        <div class="col-md-4">
            <input name = "DATE_END"  id="DATE_END"  class="form-control input-lg datepicker" data-date-format="mm/dd/yyyy"  value="'.formate($displaydate_end).'" readonly>
        </div>
        </div>';

        echo $output;

    }
    public function risk_notify(Request $request,$iduser)
    {
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

        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';
        $status = '';
        $search = '';
        $year_id = $yearbudget;  

        $rigrep = Riskrep::leftjoin('risk_setincidence_setting','risk_rep.RISKREP_TITLE','=','risk_setincidence_setting.INCIDENCE_SETTING_ID')
        ->leftjoin('risk_status','risk_rep.RISKREP_STATUS','=','risk_status.RISK_STATUS_NAME')
        ->leftJoin('risk_rep_level','risk_rep.RISKREP_LEVEL','=','risk_rep_level.RISK_REP_LEVEL_ID')
        ->leftjoin('risk_setupincidence_location','risk_rep.RISKREP_SEARCHLOCATE','=','risk_setupincidence_location.INCIDENCE_LOCATION_ID')
        ->leftjoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','risk_rep.RISKREP_DEPARTMENT_SUB')
        ->leftjoin('risk_setupincidence_tpyelocation','risk_setupincidence_tpyelocation.SETUP_TYPELOCATION_ID','=','risk_rep.RISKREP_TYPE')
        ->leftjoin('risk_setupincidence_grouplocation','risk_setupincidence_grouplocation.SETUP_GROUPLOCATION_ID','=','risk_rep.RISKREP_LOCAL')
        ->leftjoin('risk_setupincidence_sub','risk_setupincidence_sub.INCIDENCE_SUB_ID','=','risk_rep.RISKREP_SUBTITLE')
        ->leftjoin('hrd_sex','hrd_sex.SEX_ID','=','risk_rep.RISKREP_SEX')
        ->where('RISKREP_USEREFFECT','=',$inforpersonuserid->ID)
        ->orderBy('RISKREP_ID','DESC')
        ->get();
        $location = DB::table('risk_setupincidence_location')->get();
        $setting = DB::table('risk_setincidence_setting')->get();

        $status = DB::table('risk_status')->get();
        $repeat = DB::table('risk_notify_repeat_sub')->where('STATUS_REPEAT','=','REPEAT')->count();
        $accept = DB::table('risk_notify_accept_sub')->where('STATUS_ACCEPT','=','ACCEPT')->count();

        return view('general_risk.risk_notify',[
            'inforpersonuserid' => $inforpersonuserid,
            'inforpersonuser' => $inforpersonuser,
            'rigreps'=>$rigrep,
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id,
            'repeat'=>$repeat,
            'accept'=>$accept,
            'statuss'=>$status,
        ]);
    }

    
public function risk_notify_search(Request $request,$iduser)
{ 
    $search = $request->get('search');
    $status = $request->STATUS_CODE;
    $datebigin = $request->get('DATE_BIGIN');
    $dateend = $request->get('DATE_END');
    $yearbudget = $request->BUDGET_YEAR; 
    
   

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

    if($status !== null){
        $rigrep = Riskrep::leftjoin('risk_setincidence_setting','risk_rep.RISKREP_TITLE','=','risk_setincidence_setting.INCIDENCE_SETTING_ID')
        ->leftjoin('risk_status','risk_rep.RISKREP_STATUS','=','risk_status.RISK_STATUS_NAME')
        ->leftJoin('risk_rep_level','risk_rep.RISKREP_LEVEL','=','risk_rep_level.RISK_REP_LEVEL_ID')
        ->leftjoin('risk_setupincidence_location','risk_rep.RISKREP_SEARCHLOCATE','=','risk_setupincidence_location.INCIDENCE_LOCATION_ID')
        ->leftjoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','risk_rep.RISKREP_DEPARTMENT_SUB')
        ->leftjoin('risk_setupincidence_tpyelocation','risk_setupincidence_tpyelocation.SETUP_TYPELOCATION_ID','=','risk_rep.RISKREP_TYPE')
        ->leftjoin('risk_setupincidence_grouplocation','risk_setupincidence_grouplocation.SETUP_GROUPLOCATION_ID','=','risk_rep.RISKREP_LOCAL')
        ->leftjoin('risk_setupincidence_sub','risk_setupincidence_sub.INCIDENCE_SUB_ID','=','risk_rep.RISKREP_SUBTITLE')
        ->leftjoin('hrd_sex','hrd_sex.SEX_ID','=','risk_rep.RISKREP_SEX')
        ->where('RISKREP_USEREFFECT','=',$inforpersonuserid->ID)
        ->where('risk_rep.RISKREP_STATUS','=',$status)
        ->where(function($q) use ($search){
            $q->where('RISK_REP_LEVEL_NAME','like','%'.$search.'%');
            $q->orwhere('RISKREP_BASICMANAGE','like','%'.$search.'%');
            $q->orwhere('RISKREP_DETAILRISK','like','%'.$search.'%'); 
            $q->orwhere('RISK_STATUS_NAME_TH','like','%'.$search.'%');   
            $q->orwhere('INCIDENCE_LOCATION_NAME','like','%'.$search.'%');  
            $q->orwhere('RISKREP_NO','like','%'.$search.'%');  
        })
        ->WhereBetween('RISKREP_DATESAVE',[$from,$to]) 
        ->orderBy('RISKREP_ID','DESC')
        ->get();
         

    }else{
        $rigrep = Riskrep::leftjoin('risk_setincidence_setting','risk_rep.RISKREP_TITLE','=','risk_setincidence_setting.INCIDENCE_SETTING_ID')
        ->leftjoin('risk_status','risk_rep.RISKREP_STATUS','=','risk_status.RISK_STATUS_NAME')
        ->leftJoin('risk_rep_level','risk_rep.RISKREP_LEVEL','=','risk_rep_level.RISK_REP_LEVEL_ID')
        ->leftjoin('risk_setupincidence_location','risk_rep.RISKREP_SEARCHLOCATE','=','risk_setupincidence_location.INCIDENCE_LOCATION_ID')
        ->leftjoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','risk_rep.RISKREP_DEPARTMENT_SUB')
        ->leftjoin('risk_setupincidence_tpyelocation','risk_setupincidence_tpyelocation.SETUP_TYPELOCATION_ID','=','risk_rep.RISKREP_TYPE')
        ->leftjoin('risk_setupincidence_grouplocation','risk_setupincidence_grouplocation.SETUP_GROUPLOCATION_ID','=','risk_rep.RISKREP_LOCAL')
        ->leftjoin('risk_setupincidence_sub','risk_setupincidence_sub.INCIDENCE_SUB_ID','=','risk_rep.RISKREP_SUBTITLE')
        ->leftjoin('hrd_sex','hrd_sex.SEX_ID','=','risk_rep.RISKREP_SEX')
        ->where('RISKREP_USEREFFECT','=',$inforpersonuserid->ID)
        ->where(function($q) use ($search){
            $q->where('RISK_REP_LEVEL_NAME','like','%'.$search.'%');
            $q->orwhere('RISKREP_BASICMANAGE','like','%'.$search.'%');
            $q->orwhere('RISKREP_DETAILRISK','like','%'.$search.'%'); 
            $q->orwhere('RISK_STATUS_NAME_TH','like','%'.$search.'%');   
            $q->orwhere('INCIDENCE_LOCATION_NAME','like','%'.$search.'%');   
            $q->orwhere('RISKREP_NO','like','%'.$search.'%');  
        })
        ->WhereBetween('RISKREP_DATESAVE',[$from,$to]) 
        ->orderBy('RISKREP_ID','DESC')
        ->get();
         

    }

  
       
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';
      
        $year_id = $yearbudget;
               
        $status_info = DB::table('risk_status')->get();
        $repeat = DB::table('risk_notify_repeat_sub')->where('STATUS_REPEAT','=','REPEAT')->count();
        $accept = DB::table('risk_notify_accept_sub')->where('STATUS_ACCEPT','=','ACCEPT')->count();

 

    return view('general_risk.risk_notify',[   
        'inforpersonuserid' => $inforpersonuserid,
        'inforpersonuser' => $inforpersonuser,        
        'rigreps'=>$rigrep,
        'status_check'=> $status,
        'search'=> $search,
        'displaydate_bigen'=> $displaydate_bigen,
        'displaydate_end'=> $displaydate_end,  
        'budgets' =>  $budget,
        'year_id'=>$year_id,  
        'repeat'=>$repeat,
        'accept'=>$accept,
        'statuss'=>$status_info,
        
    ]);
}


     
    public static function checkrisknotify($id_user)
    {
        $count =   $inforleave =  Riskrep::where('LEADER_PERSON_ID','=',$id_user)
                    ->where(function($q){
                    $q->where('RISKREP_STATUS','=','REPORT');
                    $q->orwhere('RISKREP_STATUS','=','CHECK');
                })
            ->count();
        return $count;
    }
    public static function countrisknotify($id_user)
    {
        $count =  Riskrep::where(function($q){
                $q->where('RISKREP_STATUS','=','REPORT');
                // $q->orwhere('LEAVE_STATUS_CODE','=','Appcancel');
                })
                ->count();
        return $count;
    }

    public static function checkrepeat_sub($id_rep)
        {
            $count =  Risk_notify_repeat_sub::where('RISKREP_ID','=',$id_rep)->count();
            return $count;
        }
    public static function checkaccept_sub($id_rep)
    {
        $count =  Risk_notify_accept_sub::where('RISKREP_ID','=',$id_rep)->count();
        return $count;
    }

 //---------------------------------------------------------
 public static function refnumberRiskuser()
 {   
         $m_budget = date("m");
         if($m_budget>9){
         $yearbudget = date("Y")+544;
         }else{
         $yearbudget = date("Y")+543;
         }
     $maxnumber = DB::table('risk_internalcontrol')->where('INTERNALCONTROL_YEAR','=',$yearbudget)->max('INTERNALCONTROL_ID');  

     if($maxnumber != '' ||  $maxnumber != null){
         
         $refmax = DB::table('risk_internalcontrol')->where('INTERNALCONTROL_ID','=',$maxnumber)->first();  
         if($refmax->INTERNALCONTROL_ID != '' ||  $refmax->INTERNALCONTROL_ID != null){
             $maxref = substr($refmax->INTERNALCONTROL_ID, -4)+1;
         }else{
             $maxref = 1;
         }
         $ref = str_pad($maxref, 4, "0", STR_PAD_LEFT);
     
     }else{
         $ref = '0001';
     }  
     $y = substr($yearbudget, -2);
     $refnumberRiskuser ='RU'.$y.'-'.$ref;
     return $refnumberRiskuser;
 }
    public function risk_notify_internalcontrol(Request $request,$iduser)
    {    
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

        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';
        $search = '';
        $year_id = $yearbudget;  

        $status = DB::table('risk_status')->get();
        $leader = DB::table('gleave_leader_person')->first();   

        $internalcontrol = Risk_internalcontrol::leftjoin('hrd_department_sub_sub','risk_internalcontrol.INTERNALCONTROL_DEP_SUBSUB','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->leftjoin('hrd_person','risk_internalcontrol.INTERNALCONTROL_USERID','=','hrd_person.ID')
        ->leftjoin('risk_status','risk_internalcontrol.INTERNALCONTROL_STATUS','=','risk_status.RISK_STATUS_NAME')
        ->where('risk_internalcontrol.INTERNALCONTROL_DEP_SUBSUB','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)
        ->get();

        return view('general_risk/risk_notify_internalcontrol',[  
            'inforpersonuserid' => $inforpersonuserid,
            'inforpersonuser' => $inforpersonuser,       
            'internalcontrols'=>$internalcontrol,
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id,
            'statuss'=>$status,
        ]);
    }


    public function risk_notify_internalcontrol_search(Request $request,$iduser)
    {    
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

      
        $search  = $request->search;
        $year_id = $request->BUDGET_YEAR;

        
    $displaydate_bigen= $request->DATE_BIGIN;
    

    if($displaydate_bigen != ''){
        $STARTDAY = Carbon::createFromFormat('d/m/Y', $displaydate_bigen)->format('Y-m-d');
        $date_arrary_st=explode("-",$STARTDAY);  
        $y_sub_st = $date_arrary_st[0]; 
        
        if($y_sub_st >= 2500){
            $y_st = $y_sub_st-543;
        }else{
            $y_st = $y_sub_st;
        }
        $m_st = $date_arrary_st[1];
        $d_st = $date_arrary_st[2];  
        $displaydatebigen= $y_st."-".$m_st."-".$d_st;
        }else{
        $displaydatebigen= '';
    }


    
    $displaydate_end= $request->DATE_END;


    if($displaydate_end != ''){
        $STARTDAY = Carbon::createFromFormat('d/m/Y', $displaydate_end)->format('Y-m-d');
        $date_arrary_st=explode("-",$STARTDAY);  
        $y_sub_st = $date_arrary_st[0]; 
        
        if($y_sub_st >= 2500){
            $y_st = $y_sub_st-543;
        }else{
            $y_st = $y_sub_st;
        }
        $m_st = $date_arrary_st[1];
        $d_st = $date_arrary_st[2];  
        $displaydateend= $y_st."-".$m_st."-".$d_st;
        }else{
        $displaydateend= null;
    }


    $from = date($displaydatebigen);
    $to = date($displaydateend);


        $status = DB::table('risk_status')->get();
        $leader = DB::table('gleave_leader_person')->first();   

        $internalcontrol = Risk_internalcontrol::leftjoin('hrd_department_sub_sub','risk_internalcontrol.INTERNALCONTROL_DEP_SUBSUB','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->leftjoin('hrd_person','risk_internalcontrol.INTERNALCONTROL_USERID','=','hrd_person.ID')
        ->leftjoin('risk_status','risk_internalcontrol.INTERNALCONTROL_STATUS','=','risk_status.RISK_STATUS_NAME')
        ->where('risk_internalcontrol.INTERNALCONTROL_DEP_SUBSUB','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)
        ->where(function($q) use ($search){
            $q->where('INTERNALCONTROL_NO','like','%'.$search.'%');
            $q->orwhere('INTERNALCONTROL_DEP_SUBSUB_NAME','like','%'.$search.'%');
            $q->orwhere('INTERNALCONTROL_LEADER_NAME','like','%'.$search.'%'); 
            $q->orwhere('INTERNALCONTROL_MISSION','like','%'.$search.'%');  
             
        })
        ->WhereBetween('INTERNALCONTROL_DATE',[$from,$to]) 

        ->get();



        return view('general_risk/risk_notify_internalcontrol',[  
            'inforpersonuserid' => $inforpersonuserid,
            'inforpersonuser' => $inforpersonuser,       
            'internalcontrols'=>$internalcontrol,
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydatebigen,
            'displaydate_end'=> $displaydateend,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id,
            'statuss'=>$status,
        ]);
    }
   
    public function risk_notify_internalcontrol_detail(Request $request,$idref,$iduser)
    {    
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


        $infoper = DB::table('hrd_person')->get();
        $departsub = DB::table('hrd_department_sub_sub')->where('HR_DEPARTMENT_SUB_SUB_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)->get();
     
        $leader =  DB::table('gleave_leader_person')
        ->leftJoin('gleave_leader','gleave_leader.LEADER_ID','=','gleave_leader_person.LEADER_ID')
        ->where('PERSON_ID','=',$iduser)
        ->get();

        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;        }

        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';
        $status = '';
        $search = '';
        $year_id = $yearbudget;

        $internalcontrol = Risk_internalcontrol::where('INTERNALCONTROL_ID','=',$idref)->first();
        $internalcontrol_sub = Risk_internalcontrol_sub::where('INTERNALCONTROL_ID','=',$idref)->get();
        $internalcontrol_subsub = Risk_internalcontrol_subsub::where('INTERNALCONTROL_ID','=',$idref)->get();

        $departmentsub = DB::table('hrd_department_sub')->where('ACTIVE','=','True')->get();

        $infodepartmentsub = DB::table('hrd_department_sub')
        ->leftjoin('hrd_person','hrd_department_sub.LEADER_HR_ID','=','hrd_person.ID')
        ->where('ACTIVE','=','True')->get();

        return view('general_risk.risk_notify_internalcontrol_detail',[
            'inforpersonuserid' => $inforpersonuserid,
            'inforpersonuser' => $inforpersonuser, 
            'departsubs'=>$departsub,
            'leaders'=>$leader,
            'internalcontrol'=>$internalcontrol,
            'internalcontrol_subs'=>$internalcontrol_sub,
            'internalcontrol_subsubs'=>$internalcontrol_subsub,
            'infodepartmentsubs' =>$infodepartmentsub,
            'departmentsubs'=>$departmentsub,
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id,
        ]);
    }
    public function risk_notify_internalcontrol_add(Request $request,$iduser)
    {    
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


        $infoper = DB::table('hrd_person')->get();
        $departsub = DB::table('hrd_department_sub_sub')->where('HR_DEPARTMENT_SUB_SUB_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)->get();
     
        $leader =  DB::table('gleave_leader_person')
        ->leftJoin('gleave_leader','gleave_leader.LEADER_ID','=','gleave_leader_person.LEADER_ID')
        ->where('PERSON_ID','=',$iduser)
        ->get();

        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;   
         }

        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';
        $search = '';
        $year_id = $yearbudget;  

        $status = DB::table('risk_status')->get();
        // $leader = DB::table('gleave_leader_person')->first();  


        $internalcontrol = Risk_internalcontrol::leftjoin('hrd_department_sub','risk_internalcontrol.INTERNALCONTROL_GROUP_NAME','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
        ->leftjoin('hrd_person','risk_internalcontrol.INTERNALCONTROL_HEAD_WORK','=','hrd_person.ID')
        ->get();

        $departsub = DB::table('hrd_department_sub_sub')->where('HR_DEPARTMENT_SUB_SUB_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)->get();

        return view('general_risk/risk_notify_internalcontrol_add',[  
            'inforpersonuserid' => $inforpersonuserid,
            'inforpersonuser' => $inforpersonuser,       
            'internalcontrols'=>$internalcontrol,
            'departsubs'=>$departsub,
            'leaders'=>$leader,
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id,
            'statuss'=>$status,
           
        ]);
    }
    public function risk_notify_internalcontrol_save(Request $request)
    {  

        $iduser = $request->USER_ID;
        $inforpersonuserid =  Person::where('ID','=',$iduser)->first();       
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

            $internalcontroldate = $request->INTERNALCONTROL_DATE;

            if($internalcontroldate != ''){
                $STARTDAY = Carbon::createFromFormat('d/m/Y', $internalcontroldate)->format('Y-m-d');
                $date_arrary_st=explode("-",$STARTDAY);  
                $y_sub_st = $date_arrary_st[0]; 
                
                if($y_sub_st >= 2500){
                    $y_st = $y_sub_st-543;
                }else{
                    $y_st = $y_sub_st;
                }
                $m_st = $date_arrary_st[1];
                $d_st = $date_arrary_st[2];  
                $icontrol_date= $y_st."-".$m_st."-".$d_st;
                }else{
                $icontrol_date= null;
            }

            // $datebigin = $request->get('DATE_BIGIN');           

            // $date_bigen_c = Carbon::createFromFormat('d/m/Y', $datebigin)->format('Y-m-d');
            // $date_arrary=explode("-",$date_bigen_c);
            //         $y_sub_st = $date_arrary[0];        
            // if($y_sub_st >= 2500){
            //     $y = $y_sub_st-543;
            // }else{
            //     $y = $y_sub_st;
            // }        
            // $m = $date_arrary[1];
            // $d = $date_arrary[2];  
            // $displaydate_bigen= $y."-".$m."-".$d;
        

            // $dateend = $request->get('DATE_END');
            // $date_end_c = Carbon::createFromFormat('d/m/Y', $dateend)->format('Y-m-d');
            // $date_arrary_e=explode("-",$date_end_c);         
            // $y_sub_e = $date_arrary_e[0];        
            // if($y_sub_e >= 2500){
            //     $y_e = $y_sub_e-543;
            // }else{
            //     $y_e = $y_sub_e;
            // }        
            // $m_e = $date_arrary_e[1];
            // $d_e = $date_arrary_e[2];  
            // $displaydate_end= $y_e."-".$m_e."-".$d_e;        
            $date = date('Y-m-d');
            // $date_bigen_checks = strtotime($displaydate_bigen);
            // $date_end_checks =  strtotime($displaydate_end);

            $dates =  strtotime($date);
        
            // $from = date($displaydate_bigen);
            // $to = date($displaydate_end);
            
                $add= new Risk_internalcontrol();
                $add->INTERNALCONTROL_NO = $request->INTERNALCONTROL_NO;
                $sub = $request->INTERNALCONTROL_DEP_SUBSUB;                

                $iddepsubsub = DB::table('hrd_department_sub_sub')->where('HR_DEPARTMENT_SUB_SUB_ID','=',$sub) ->first(); 

                $add->INTERNALCONTROL_DEP_SUBSUB = $iddepsubsub->HR_DEPARTMENT_SUB_SUB_ID;
                $add->INTERNALCONTROL_DEP_SUBSUB_NAME = $iddepsubsub->HR_DEPARTMENT_SUB_SUB_NAME;

                $iduserget = DB::table('hrd_person')->where('ID','=',$iduser) ->first(); 

                $add->INTERNALCONTROL_USERID = $iduserget->ID;
                $add->INTERNALCONTROL_USERNAME = $iduserget->HR_FNAME. '  ' .$iduserget->HR_LNAME;

                $leader = $request->LEADER_ID;
                $idlead = DB::table('hrd_person')->where('ID','=',$leader) ->first(); 

                $add->INTERNALCONTROL_LEADER_ID = $idlead->ID;
                $add->INTERNALCONTROL_LEADER_NAME = $idlead->HR_FNAME. '  ' .$idlead->HR_LNAME;

                $add->INTERNALCONTROL_HEAD_WORK = $request->INTERNALCONTROL_HEAD_WORK;
                $add->INTERNALCONTROL_DATE = $icontrol_date;
                $add->INTERNALCONTROL_YEAR = $request->BUDGET_YEAR;
        
                $add->INTERNALCONTROL_POSITION = $request->INTERNALCONTROL_POSITION;
                $add->INTERNALCONTROL_MISSION = $request->INTERNALCONTROL_MISSION;
                $add->INTERNALCONTROL_LINK = $request->INTERNALCONTROL_LINK;
                $add->INTERNALCONTROL_STATUS = 'REPORT';
                
                $add->save();

            $id_control =  Risk_internalcontrol::max('INTERNALCONTROL_ID');

            if($request->INTERNALCONTROL_OBJECTIVE != '' || $request->INTERNALCONTROL_OBJECTIVE != null){
    
            $INTERNALCONTROL_OBJECTIVE = $request->INTERNALCONTROL_OBJECTIVE;
                               
            $number =count($INTERNALCONTROL_OBJECTIVE);
            $count = 0;
            for($count = 0; $count< $number; $count++)
            { 

            $add_sub = new Risk_internalcontrol_sub();
            $add_sub->INTERNALCONTROL_ID = $id_control;      
            $add_sub->INTERNALCONTROL_OBJECTIVE = $INTERNALCONTROL_OBJECTIVE[$count];                               
            $add_sub->save(); 
            }
        }   
        
        if($request->INTERNALCONTROL_SUBSUB_NAME != '' || $request->INTERNALCONTROL_SUBSUB_NAME != null){
    
            $INTERNALCONTROL_SUBSUB_NAME = $request->INTERNALCONTROL_SUBSUB_NAME;
                                
            $number =count($INTERNALCONTROL_SUBSUB_NAME);
            $count = 0;
            for($count = 0; $count< $number; $count++)
            { 

            $add_subsub = new Risk_internalcontrol_subsub();
            $add_subsub->INTERNALCONTROL_ID = $id_control; 
            $add_subsub->INTERNALCONTROL_SUBSUB_NAME = $INTERNALCONTROL_SUBSUB_NAME[$count];                               
            $add_subsub->save(); 
            }
        } 

        if($request->INTERNALCONTROL_SUBSUB_NAME != '' || $request->INTERNALCONTROL_SUBSUB_NAME != null){
    
            $INTERNALCONTROL_SUBSUB_NAME = $request->INTERNALCONTROL_SUBSUB_NAME;
                                
            $number =count($INTERNALCONTROL_SUBSUB_NAME);
            $count = 0;
            for($count = 0; $count< $number; $count++)
            { 

            $add_subsub_detail_sub = new Risk_internalcontrol_subsub_detail_sub();
            $add_subsub_detail_sub->INTERNALCONTROL_ID = $id_control; 
            $add_subsub_detail_sub->INTERNALCONTROL_SUBSUB_DETAIL_SUB_NAME = $INTERNALCONTROL_SUBSUB_NAME[$count];                               
            $add_subsub_detail_sub->save(); 
            }
        }  

        return redirect()->route('gen_risk.risk_notify_internalcontrol',[
            'iduser'=> $iduser 
            ]);
    }

    public function risk_notify_internalcontrol_edit(Request $request,$idref,$iduser)
    {    
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


        $infoper = DB::table('hrd_person')->get();
        $departsub = DB::table('hrd_department_sub_sub')->where('HR_DEPARTMENT_SUB_SUB_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)->get();
     
        $leader =  DB::table('gleave_leader_person')
        ->leftJoin('gleave_leader','gleave_leader.LEADER_ID','=','gleave_leader_person.LEADER_ID')
        ->where('PERSON_ID','=',$iduser)
        ->get();

        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;        }

        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';
        $status = '';
        $search = '';
        $year_id = $yearbudget;

        $internalcontrol = Risk_internalcontrol::where('INTERNALCONTROL_ID','=',$idref)->first();
        $internalcontrol_sub = Risk_internalcontrol_sub::where('INTERNALCONTROL_ID','=',$idref)->get();
        $internalcontrol_subsub = Risk_internalcontrol_subsub::where('INTERNALCONTROL_ID','=',$idref)->get();

        $departmentsub = DB::table('hrd_department_sub')->where('ACTIVE','=','True')->get();

        $infodepartmentsub = DB::table('hrd_department_sub')
        ->leftjoin('hrd_person','hrd_department_sub.LEADER_HR_ID','=','hrd_person.ID')
        ->where('ACTIVE','=','True')->get();

        return view('general_risk.risk_notify_internalcontrol_edit',[
            'inforpersonuserid' => $inforpersonuserid,
            'inforpersonuser' => $inforpersonuser, 
            'departsubs'=>$departsub,
            'leaders'=>$leader,
            'internalcontrol'=>$internalcontrol,
            'internalcontrol_subs'=>$internalcontrol_sub,
            'internalcontrol_subsubs'=>$internalcontrol_subsub,
            'infodepartmentsubs' =>$infodepartmentsub,
            'departmentsubs'=>$departmentsub,
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id,
        ]);
    }
    public function risk_notify_internalcontrol_update(Request $request)
    {    
        $iduser = $request->USER_ID;
        $inforpersonuserid =  Person::where('ID','=',$iduser)->first();       
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

        $checkdigget= $request->INTERNALCONTROL_DATE;
        if($checkdigget != ''){           
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $checkdigget)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0];             
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $icontrol_date= $y_st."-".$m_st."-".$d_st;   
            }else{
            $icontrol_date= null;
        }

        // $datebigin = $request->get('DATE_BIGIN');
        //     $dateend = $request->get('DATE_END');

        //     $date_bigen_c = Carbon::createFromFormat('d/m/Y', $datebigin)->format('Y-m-d');
        //     $date_arrary=explode("-",$date_bigen_c);
        
        //     $y_sub_st = $date_arrary[0];
        
        //     if($y_sub_st >= 2500){
        //         $y = $y_sub_st-543;
        //     }else{
        //         $y = $y_sub_st;
        //     }
        
        //     $m = $date_arrary[1];
        //     $d = $date_arrary[2];  
        //     $displaydate_bigen= $y."-".$m."-".$d;
        
        //     $date_end_c = Carbon::createFromFormat('d/m/Y', $dateend)->format('Y-m-d');
        //     $date_arrary_e=explode("-",$date_end_c); 
        
        //     $y_sub_e = $date_arrary_e[0];
        
        //     if($y_sub_e >= 2500){
        //         $y_e = $y_sub_e-543;
        //     }else{
        //         $y_e = $y_sub_e;
        //     }
        
        //     $m_e = $date_arrary_e[1];
        //     $d_e = $date_arrary_e[2];  
        //     $displaydate_end= $y_e."-".$m_e."-".$d_e;
        
            $date = date('Y-m-d');
        //     $date_bigen_checks = strtotime($displaydate_bigen);
        //     $date_end_checks =  strtotime($displaydate_end);
            $dates =  strtotime($date);
        
        //     $from = date($displaydate_bigen);
        //     $to = date($displaydate_end);

            $id = $request->INTERNALCONTROL_ID;
            $update = Risk_internalcontrol::find($id);            
            $update->INTERNALCONTROL_DATE = $icontrol_date; 
            $update->INTERNALCONTROL_GROUP_NAME = $request->INTERNALCONTROL_GROUP_NAME; 
            $update->INTERNALCONTROL_HEAD_WORK = $request->INTERNALCONTROL_HEAD_WORK; 
            $update->INTERNALCONTROL_YEAR = $request->BUDGET_YEAR;
            $update->INTERNALCONTROL_POSITION = $request->INTERNALCONTROL_POSITION; 
            $update->INTERNALCONTROL_MISSION = $request->INTERNALCONTROL_MISSION; 

            $update->INTERNALCONTROL_NO = $request->INTERNALCONTROL_NO;

            $sub = $request->INTERNALCONTROL_DEP_SUBSUB;                

             $iddepsubsub = DB::table('hrd_department_sub_sub')->where('HR_DEPARTMENT_SUB_SUB_ID','=',$sub) ->first(); 

            $update->INTERNALCONTROL_DEP_SUBSUB = $iddepsubsub->HR_DEPARTMENT_SUB_SUB_ID;
            $update->INTERNALCONTROL_DEP_SUBSUB_NAME = $iddepsubsub->HR_DEPARTMENT_SUB_SUB_NAME;

            $iduserget = DB::table('hrd_person')->where('ID','=',$iduser) ->first(); 

            $update->INTERNALCONTROL_USERID = $iduserget->ID;
            $update->INTERNALCONTROL_USERNAME = $iduserget->HR_FNAME. '  ' .$iduserget->HR_LNAME;

            $leader = $request->LEADER_ID;
            $idlead = DB::table('hrd_person')->where('ID','=',$leader) ->first(); 

            $update->INTERNALCONTROL_LEADER_ID = $idlead->ID;
            $update->INTERNALCONTROL_LEADER_NAME = $idlead->HR_FNAME. '  ' .$idlead->HR_LNAME;
            $update->INTERNALCONTROL_LINK = $request->INTERNALCONTROL_LINK;
          
            $update->save();
              
            

            $INTERNALCONTROL_ID = $id;
            Risk_internalcontrol_sub::where('INTERNALCONTROL_ID','=',$id)->delete(); 
           
            if($request->INTERNALCONTROL_OBJECTIVE[0] != '' || $request->INTERNALCONTROL_OBJECTIVE[0] != null){
            
                $INTERNALCONTROL_OBJECTIVE = $request->INTERNALCONTROL_OBJECTIVE;                           
    
                $number =count($INTERNALCONTROL_OBJECTIVE);
                $count = 0;
                for($count = 0; $count < $number; $count++)
                {                
                   $addsup = new Risk_internalcontrol_sub();
                   $addsup->INTERNALCONTROL_ID = $INTERNALCONTROL_ID;
                   $addsup->INTERNALCONTROL_OBJECTIVE = $INTERNALCONTROL_OBJECTIVE[$count];                  
                   $addsup->save();                 
                   
                }
            }
            Risk_internalcontrol_subsub::where('INTERNALCONTROL_ID','=',$id)->delete(); 
           
            if($request->INTERNALCONTROL_SUBSUB_NAME[0] != '' || $request->INTERNALCONTROL_SUBSUB_NAME[0] != null){
            
                $INTERNALCONTROL_SUBSUB_NAME = $request->INTERNALCONTROL_SUBSUB_NAME;                           
    
                $number =count($INTERNALCONTROL_SUBSUB_NAME);
                $count = 0;
                for($count = 0; $count < $number; $count++)
                {                
                   $addsupsub = new Risk_internalcontrol_subsub();
                   $addsupsub->INTERNALCONTROL_ID = $INTERNALCONTROL_ID;
                   $addsupsub->INTERNALCONTROL_SUBSUB_NAME = $INTERNALCONTROL_SUBSUB_NAME[$count];                  
                   $addsupsub->save();                
                   
                }
            }
            // return redirect()->action('RiskController@risk_notify_internalcontrol');
            return redirect()->route('gen_risk.risk_notify_internalcontrol',[
                'iduser'=> $iduser 
                ]);
    }


//**************************************************** */


 public function risk_notify_analysis_save(Request $request)
    {  

        $iduser = $request->USER_ID;
        $inforpersonuserid =  Person::where('ID','=',$iduser)->first();       
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


        $INTERNALCONTROLID = $request->INTERNALCONTROL_ID;


                $add= new Risk_internalcontrol_analyze();
                $add->INTERNALCONTROL_ID = $INTERNALCONTROLID;
                $add->ANALYZE_STEP = $request->ANALYZE_STEP;   
                $add->ANALYZE_REDUCE = $request->ANALYZE_REDUCE; 
                $add->ANALYZE_ACTIVITY = $request->ANALYZE_ACTIVITY; 
                $add->ANALYZE_RESULTS = $request->ANALYZE_RESULTS;         
                $add->ANALYZE_RISK = $request->ANALYZE_RISK; 
                $add->save();


        return redirect()->route('gen_risk.risk_notify_analysis',[
            'idref'=> $INTERNALCONTROLID,
            'iduser'=> $iduser
            ]);
    }


    public function risk_notify_analysis_update(Request $request)
    {  

        $iduser = $request->USER_ID;
        $inforpersonuserid =  Person::where('ID','=',$iduser)->first();       
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


        $INTERNALCONTROLID = $request->INTERNALCONTROL_ID;

        $idref = $request->ANALYZE_ID;

                $add=  Risk_internalcontrol_analyze::find($idref);
                $add->INTERNALCONTROL_ID = $INTERNALCONTROLID;
                $add->ANALYZE_STEP = $request->ANALYZE_STEP;   
                $add->ANALYZE_REDUCE = $request->ANALYZE_REDUCE; 
                $add->ANALYZE_ACTIVITY = $request->ANALYZE_ACTIVITY; 
                $add->ANALYZE_RESULTS = $request->ANALYZE_RESULTS;         
                $add->ANALYZE_RISK = $request->ANALYZE_RISK; 
                $add->save();


        return redirect()->route('gen_risk.risk_notify_analysis',[
            'idref'=> $INTERNALCONTROLID,
            'iduser'=> $iduser
            ]);
    }


    
 public function risk_notify_analysis_destroy(Request $request,$idref,$iduser)
 {
    $idrefinfo = DB::table('risk_internalcontrol_analyze')->where('ANALYZE_ID','=',$idref)->first();
    $INTERNALCONTROLID = $idrefinfo->INTERNALCONTROL_ID;

    Risk_internalcontrol_analyze::destroy($idref);

     return redirect()->route('gen_risk.risk_notify_analysis',[
        'idref'=> $INTERNALCONTROLID,
        'iduser'=> $iduser
        ]);
 }


/////************************************************ *//////
public static function refnumRiskacc()
{   
        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;
        }
    $maxnumber = DB::table('risk_account')->where('RISK_ACCOUNT_YEAR','=',$yearbudget)->max('RISK_ACCOUNT_ID');  

    if($maxnumber != '' ||  $maxnumber != null){
        
        $refmax = DB::table('risk_account')->where('RISK_ACCOUNT_ID','=',$maxnumber)->first();  
        if($refmax->RISK_ACCOUNT_ID != '' ||  $refmax->RISK_ACCOUNT_ID != null){
            $maxref = substr($refmax->RISK_ACCOUNT_ID, -4)+1;
        }else{
            $maxref = 1;
        }
        $ref = str_pad($maxref, 4, "0", STR_PAD_LEFT);
    
    }else{
        $ref = '0001';
    }  
    $y = substr($yearbudget, -2);
    $refnumRiskacc ='RA'.$y.'-'.$ref;
    return $refnumRiskacc;
}
    public function risk_notify_account(Request $request,$iduser)
    {    
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
        $yearbudget = date("Y")+543;        }

        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';
        $status = '';
        $search = '';
        $year_id = $yearbudget; 
        
        $status = DB::table('risk_status')->get();
        $leader = DB::table('gleave_leader_person')->first();  

        // $internalcontrol = Risk_internalcontrol::leftjoin('hrd_department_sub','risk_internalcontrol.INTERNALCONTROL_GROUP_NAME','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
        // ->leftjoin('hrd_person','risk_internalcontrol.INTERNALCONTROL_HEAD_WORK','=','hrd_person.ID')
        // ->get();

        // $riskacc = Risk_account::leftjoin('hrd_department_sub','risk_account.RISK_ACCOUNT_DEBSUBSUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
        // ->leftjoin('risk_account_type','risk_account.RISK_ACCOUNT_RISK','=','risk_account_type.RISK_ACCOUNTTYPE_ID')
        // ->leftjoin('hrd_person','risk_account.RISK_ACCOUNT_USERID','=','hrd_person.ID')
        // ->leftjoin('risk_status','risk_account.RISK_ACCOUNT_STATUS','=','risk_status.RISK_STATUS_NAME')
        // ->OrderBy('RISK_ACCOUNT_ID','DESC')
        // ->get();

        return view('general_risk.risk_notify_account',[       
        
            'inforpersonuserid' => $inforpersonuserid,
            'inforpersonuser' => $inforpersonuser,       
    
            'leaders'=>$leader,
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id,
            'statuss'=>$status,
        ]);
    }
   
    public function risk_notify_account_add(Request $request,$iduser)
    {    
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
        $yearbudget = date("Y")+543;        }

        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';
        $status = '';
        $search = '';
        $year_id = $yearbudget; 
        
        $status = DB::table('risk_status')->get();
        // $leader = DB::table('gleave_leader_person')->first(); 
        
        $infoper = DB::table('hrd_person')->get();
        $departsub = DB::table('hrd_department_sub_sub')->where('HR_DEPARTMENT_SUB_SUB_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)->get();
     
        $leader =  DB::table('gleave_leader_person')
        ->leftJoin('gleave_leader','gleave_leader.LEADER_ID','=','gleave_leader_person.LEADER_ID')
        ->where('PERSON_ID','=',$iduser)
        ->get(); 

       $risk_account_type = DB::table('risk_account_type')->get();
       $scope = DB::table('risk_account_scope')->get();
       $riskef = DB::table('risk_account_riskeffect')->get();
       $risklevel = DB::table('risk_account_risk_level')->get();

        return view('general_risk.risk_notify_account_add',[        
            'risk_account_types' => $risk_account_type,
            'inforpersonuserid' => $inforpersonuserid,
            'inforpersonuser' => $inforpersonuser,  
            'departsubs'=>$departsub,
            'leaders'=>$leader,
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id,
            'statuss'=>$status,
            'scopes'=>$scope,
            'riskefs'=>$riskef,
            'risklevels'=>$risklevel,
        ]);
    }
    public function risk_notify_account_save(Request $request)
    {  
        $iduser = $request->USER_ID;
        $inforpersonuserid =  Person::where('ID','=',$iduser)->first();       
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

            $datesave = $request->RISK_ACCOUNT_DATESAVE;

            if($datesave != ''){
                $STARTDAY = Carbon::createFromFormat('d/m/Y', $datesave)->format('Y-m-d');
                $date_arrary_st=explode("-",$STARTDAY);  
                $y_sub_st = $date_arrary_st[0]; 
                
                if($y_sub_st >= 2500){
                    $y_st = $y_sub_st-543;
                }else{
                    $y_st = $y_sub_st;
                }
                $m_st = $date_arrary_st[1];
                $d_st = $date_arrary_st[2];  
                $savedate= $y_st."-".$m_st."-".$d_st;
                }else{
                $savedate= null;
            }          
            
            $add= new Risk_account();
                $add->RISK_ACCOUNT_NO = $request->RISK_ACCOUNT_NO;
                $add->RISK_ACCOUNT_YEAR = $request->RISK_ACCOUNT_YEAR;
                $add->RISK_ACCOUNT_DATESAVE = $savedate;

                $sub = $request->RISK_ACCOUNT_DEBSUBSUB_ID;                

                $iddepsubsub = DB::table('hrd_department_sub_sub')->where('HR_DEPARTMENT_SUB_SUB_ID','=',$sub) ->first(); 

                $add->RISK_ACCOUNT_DEBSUBSUB_ID = $iddepsubsub->HR_DEPARTMENT_SUB_SUB_ID;
                $add->RISK_ACCOUNT_DEBSUBSUB_NAME = $iddepsubsub->HR_DEPARTMENT_SUB_SUB_NAME;

                $iduserget = DB::table('hrd_person')->where('ID','=',$iduser) ->first(); 

                $add->RISK_ACCOUNT_USERID = $iduserget->ID;
                $add->RISK_ACCOUNT_USERNAME = $iduserget->HR_FNAME. '  ' .$iduserget->HR_LNAME;

                $leader = $request->RISK_ACCOUNT_LEADERID;
                $idlead = DB::table('hrd_person')->where('ID','=',$leader) ->first(); 

                $add->RISK_ACCOUNT_LEADERID = $idlead->ID;
                $add->RISK_ACCOUNT_LEADERNAME = $idlead->HR_FNAME. '  ' .$idlead->HR_LNAME;

                $add->RISK_ACCOUNT_RISK = $request->RISK_ACCOUNT_RISK;

                $idsco = $request->RISK_ACCOUNT_SCOPE;
                $idscope = DB::table('risk_account_scope')->where('RISK_ACCOUNTSCOPE_ID','=',$idsco) ->first(); 
                $add->RISK_ACCOUNT_SCOPE_ID = $idscope->RISK_ACCOUNTSCOPE_ID;
                $add->RISK_ACCOUNT_SCOPE = $idscope->RISK_ACCOUNTSCOPE_CODE;

                $idef = $request->RISK_ACCOUNT_RISK_EFFECT;
                $ideffect = DB::table('risk_account_riskeffect')->where('RISK_ACCOUNTRISKEFFECT_ID','=',$idef) ->first(); 
                $add->RISK_ACCOUNT_RISK_EFFECT_ID = $ideffect->RISK_ACCOUNTRISKEFFECT_ID;
                $add->RISK_ACCOUNT_RISK_EFFECT = $ideffect->RISK_ACCOUNTRISKEFFECT_CODE;

                $idlev = $request->RISK_ACCOUNT_RISK_LEVEL;
                $idlevel = DB::table('risk_account_risk_level')->where('RISK_ACCOUNTRISKLEVEL_ID','=',$idlev) ->first(); 
                $add->RISK_ACCOUNT_RISK_LEVEL_ID = $idlevel->RISK_ACCOUNTRISKLEVEL_ID; 
                $add->RISK_ACCOUNT_RISK_LEVEL = $idlevel->RISK_ACCOUNTRISKLEVEL_CODE. ' ' .$idlevel->RISK_ACCOUNTRISKLEVEL_NAME;   
                $add->RISK_ACCOUNT_RISK_DETAIL = $request->RISK_ACCOUNT_RISK_DETAIL; 
                $add->RISK_ACCOUNT_STATUS = 'REPORT';           
                
            $add->save();          

            return redirect()->route('gen_risk.risk_notify_account',[
                'iduser'=> $iduser 
                ]);       
    }

    public function risk_notify_account_edit(Request $request,$idref,$iduser)
    {    
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
        $yearbudget = date("Y")+543;        }

        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';
        $status = '';
        $search = '';
        $year_id = $yearbudget; 
        
        $status = DB::table('risk_status')->get();
        // $leader = DB::table('gleave_leader_person')->first(); 
        
        $infoper = DB::table('hrd_person')->get();
        $departsub = DB::table('hrd_department_sub_sub')->where('HR_DEPARTMENT_SUB_SUB_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)->get();
     
        $leader =  DB::table('gleave_leader_person')
        ->leftJoin('gleave_leader','gleave_leader.LEADER_ID','=','gleave_leader_person.LEADER_ID')
        ->where('PERSON_ID','=',$iduser)
        ->get(); 

       $risk_account_type = DB::table('risk_account_type')->get();
       $scope = DB::table('risk_account_scope')->get();
       $riskef = DB::table('risk_account_riskeffect')->get();
       $risklevel = DB::table('risk_account_risk_level')->get();

       $riskacc = Risk_account::leftjoin('hrd_department_sub','risk_account.RISK_ACCOUNT_DEBSUBSUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
       ->leftjoin('risk_account_type','risk_account.RISK_ACCOUNT_RISK','=','risk_account_type.RISK_ACCOUNTTYPE_ID')
       ->leftjoin('hrd_person','risk_account.RISK_ACCOUNT_USERID','=','hrd_person.ID')
       ->where('RISK_ACCOUNT_ID','=',$idref)
       ->first();

        return view('general_risk.risk_notify_account_edit',[        
            'risk_account_types' => $risk_account_type,
            'inforpersonuserid' => $inforpersonuserid,
            'inforpersonuser' => $inforpersonuser,  
            'departsubs'=>$departsub,
            'leaders'=>$leader,
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id,
            'statuss'=>$status,
            'riskaccs'=>$riskacc,
            'scopes'=>$scope,
            'riskefs'=>$riskef,
            'risklevels'=>$risklevel,
        ]);
    }
    public function risk_notify_account_detail(Request $request,$iduser)
    {    
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

    //     $m_budget = date("m");
    //     if($m_budget>9){
    //     $yearbudget = date("Y")+544;
    //     }else{
    //     $yearbudget = date("Y")+543;        }

    //     $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

    //     $displaydate_bigen = ($yearbudget-544).'-10-01';
    //     $displaydate_end = ($yearbudget-543).'-09-30';
    //     $status = '';
    //     $search = '';
    //     $year_id = $yearbudget; 
        
    //     $status = DB::table('risk_status')->get();
    //     // $leader = DB::table('gleave_leader_person')->first(); 
        
    //     $infoper = DB::table('hrd_person')->get();
    //     $departsub = DB::table('hrd_department_sub_sub')->where('HR_DEPARTMENT_SUB_SUB_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)->get();
     
    //     $leader =  DB::table('gleave_leader_person')
    //     ->leftJoin('gleave_leader','gleave_leader.LEADER_ID','=','gleave_leader_person.LEADER_ID')
    //     ->where('PERSON_ID','=',$iduser)
    //     ->get(); 

    //    $risk_account_type = DB::table('risk_account_type')->get();
    //    $scope = DB::table('risk_account_scope')->get();
    //    $riskef = DB::table('risk_account_riskeffect')->get();
    //    $risklevel = DB::table('risk_account_risk_level')->get();

    //    $riskacc = Risk_account::leftjoin('hrd_department_sub','risk_account.RISK_ACCOUNT_DEBSUBSUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
    //    ->leftjoin('risk_account_type','risk_account.RISK_ACCOUNT_RISK','=','risk_account_type.RISK_ACCOUNTTYPE_ID')
    //    ->leftjoin('hrd_person','risk_account.RISK_ACCOUNT_USERID','=','hrd_person.ID')
    //    ->where('RISK_ACCOUNT_ID','=',$idref)
    //    ->first();

      
         $infomation = DB::table('risk_account_detail')
         ->leftjoin('risk_type','risk_type.RISK_TYPE_ID','=','risk_account_detail.RISK_TYPE_ID')
         ->leftjoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','risk_account_detail.RISK_ACC_AGENCY')
         ->where('RISK_ACC_AGENCY','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)
         ->get();

         $infomationrist = DB::table('risk_internalcontrol_analyze')->get();
         $inforisktype = DB::table('risk_type')->get();    
         $infodepartment = DB::table('hrd_department_sub_sub')->get();   
         

        return view('general_risk.risk_notify_account_detail',[        
            'inforpersonuserid' => $inforpersonuserid,
            'inforpersonuser' => $inforpersonuser,  
            'infomations' => $infomation,  
            'infomationrists' => $infomationrist,  
            'inforisktypes' => $inforisktype,
            'infodepartments' => $infodepartment,
       
        ]);
    }
    public function risk_notify_account_update(Request $request)
    {  
        $iduser = $request->USER_ID;
        $inforpersonuserid =  Person::where('ID','=',$iduser)->first();       
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

            $datesave = $request->RISK_ACCOUNT_DATESAVE;

            if($datesave != ''){
                $STARTDAY = Carbon::createFromFormat('d/m/Y', $datesave)->format('Y-m-d');
                $date_arrary_st=explode("-",$STARTDAY);  
                $y_sub_st = $date_arrary_st[0]; 
                
                if($y_sub_st >= 2500){
                    $y_st = $y_sub_st-543;
                }else{
                    $y_st = $y_sub_st;
                }
                $m_st = $date_arrary_st[1];
                $d_st = $date_arrary_st[2];  
                $savedate= $y_st."-".$m_st."-".$d_st;
                }else{
                $savedate= null;
            }  
            
            $idref = $request->RISK_ACCOUNT_ID;
            
            $update= Risk_account::find($idref);
                $update->RISK_ACCOUNT_NO = $request->RISK_ACCOUNT_NO;
                $update->RISK_ACCOUNT_YEAR = $request->RISK_ACCOUNT_YEAR;
                $update->RISK_ACCOUNT_DATESAVE = $savedate;

                $sub = $request->RISK_ACCOUNT_DEBSUBSUB_ID;                

                $iddepsubsub = DB::table('hrd_department_sub_sub')->where('HR_DEPARTMENT_SUB_SUB_ID','=',$sub) ->first(); 

                $update->RISK_ACCOUNT_DEBSUBSUB_ID = $iddepsubsub->HR_DEPARTMENT_SUB_SUB_ID;
                $update->RISK_ACCOUNT_DEBSUBSUB_NAME = $iddepsubsub->HR_DEPARTMENT_SUB_SUB_NAME;

                $iduserget = DB::table('hrd_person')->where('ID','=',$iduser) ->first(); 

                $update->RISK_ACCOUNT_USERID = $iduserget->ID;
                $update->RISK_ACCOUNT_USERNAME = $iduserget->HR_FNAME. '  ' .$iduserget->HR_LNAME;

                $leader = $request->RISK_ACCOUNT_LEADERID;
                $idlead = DB::table('hrd_person')->where('ID','=',$leader) ->first(); 

                $update->RISK_ACCOUNT_LEADERID = $idlead->ID;
                $update->RISK_ACCOUNT_LEADERNAME = $idlead->HR_FNAME. '  ' .$idlead->HR_LNAME;

                $update->RISK_ACCOUNT_RISK = $request->RISK_ACCOUNT_RISK;

                $idsco = $request->RISK_ACCOUNT_SCOPE;
                $idscope = DB::table('risk_account_scope')->where('RISK_ACCOUNTSCOPE_ID','=',$idsco) ->first(); 
                $update->RISK_ACCOUNT_SCOPE_ID = $idscope->RISK_ACCOUNTSCOPE_ID;
                $update->RISK_ACCOUNT_SCOPE = $idscope->RISK_ACCOUNTSCOPE_CODE;

                $idef = $request->RISK_ACCOUNT_RISK_EFFECT;
                $ideffect = DB::table('risk_account_riskeffect')->where('RISK_ACCOUNTRISKEFFECT_ID','=',$idef) ->first(); 
                $update->RISK_ACCOUNT_RISK_EFFECT_ID = $ideffect->RISK_ACCOUNTRISKEFFECT_ID;
                $update->RISK_ACCOUNT_RISK_EFFECT = $ideffect->RISK_ACCOUNTRISKEFFECT_CODE;
              
                $idlev = $request->RISK_ACCOUNT_RISK_LEVEL;
                $idlevel = DB::table('risk_account_risk_level')->where('RISK_ACCOUNTRISKLEVEL_ID','=',$idlev) ->first(); 
                $update->RISK_ACCOUNT_RISK_LEVEL_ID = $idlevel->RISK_ACCOUNTRISKLEVEL_ID; 
                $update->RISK_ACCOUNT_RISK_LEVEL = $idlevel->RISK_ACCOUNTRISKLEVEL_CODE. ' ' .$idlevel->RISK_ACCOUNTRISKLEVEL_NAME;   
                $update->RISK_ACCOUNT_RISK_DETAIL = $request->RISK_ACCOUNT_RISK_DETAIL;   
                $update->RISK_ACCOUNT_STATUS = 'REPORT';         
                
            $update->save();          

            return redirect()->route('gen_risk.risk_notify_account',[
                'iduser'=> $iduser 
                ]);       
    }
    public function risk_notify_account_cancel(Request $request,$idref,$iduser)
    {    
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
        $yearbudget = date("Y")+543;        }

        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';
        $status = '';
        $search = '';
        $year_id = $yearbudget; 
        
        $status = DB::table('risk_status')->get();
        // $leader = DB::table('gleave_leader_person')->first(); 
        
        $infoper = DB::table('hrd_person')->get();
        $departsub = DB::table('hrd_department_sub_sub')->where('HR_DEPARTMENT_SUB_SUB_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)->get();
     
        $leader =  DB::table('gleave_leader_person')
        ->leftJoin('gleave_leader','gleave_leader.LEADER_ID','=','gleave_leader_person.LEADER_ID')
        ->where('PERSON_ID','=',$iduser)
        ->get(); 

       $risk_account_type = DB::table('risk_account_type')->get();
       $scope = DB::table('risk_account_scope')->get();
       $riskef = DB::table('risk_account_riskeffect')->get();
       $risklevel = DB::table('risk_account_risk_level')->get();

       $riskacc = Risk_account::leftjoin('hrd_department_sub','risk_account.RISK_ACCOUNT_DEBSUBSUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
       ->leftjoin('risk_account_type','risk_account.RISK_ACCOUNT_RISK','=','risk_account_type.RISK_ACCOUNTTYPE_ID')
       ->leftjoin('hrd_person','risk_account.RISK_ACCOUNT_USERID','=','hrd_person.ID')
       ->where('RISK_ACCOUNT_ID','=',$idref)
       ->first();

        return view('general_risk.risk_notify_account_cancel',[        
            'risk_account_types' => $risk_account_type,
            'inforpersonuserid' => $inforpersonuserid,
            'inforpersonuser' => $inforpersonuser,  
            'departsubs'=>$departsub,
            'leaders'=>$leader,
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id,
            'statuss'=>$status,
            'riskaccs'=>$riskacc,
            'scopes'=>$scope,
            'riskefs'=>$riskef,
            'risklevels'=>$risklevel,
        ]);
    }
    public function risk_notify_account_updatecancel(Request $request)
    {  
        $iduser = $request->USER_ID;
        $inforpersonuserid =  Person::where('ID','=',$iduser)->first();       
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
            
            $idref = $request->RISK_ACCOUNT_ID;
            
            $update= Risk_account::find($idref);             
            $update->RISK_ACCOUNT_STATUS = 'CANCELED';  
            $update->save();          

            return redirect()->route('gen_risk.risk_notify_account',[
                'iduser'=> $iduser 
                ]);       
    }

/////************************************************ *//////

    public function risk_notify_reportsub(Request $request,$iduser)
    {    
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
        $yearbudget = date("Y")+543;        }

        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';
        $status = '';
        $search = '';
        $year_id = $yearbudget; 
    
       $riskacc = Risk_account::leftjoin('hrd_department_sub','risk_account.RISK_ACCOUNT_DEBSUBSUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
       ->leftjoin('risk_account_type','risk_account.RISK_ACCOUNT_RISK','=','risk_account_type.RISK_ACCOUNTTYPE_ID')
       ->leftjoin('hrd_person','risk_account.RISK_ACCOUNT_USERID','=','hrd_person.ID')
       ->get();

        return view('general_risk.risk_notify_reportsub',[ 
            'inforpersonuserid' => $inforpersonuserid,
            'inforpersonuser' => $inforpersonuser,  
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id,
            'statuss'=>$status,          
        ]);
    }



public function risk_notify_add(Request $request,$iduser)
    {
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


        $infoper = DB::table('hrd_person')->get();
        $departsub = DB::table('hrd_department_sub_sub')->where('HR_DEPARTMENT_SUB_SUB_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)->get();
        $riskcategory = DB::table('risk_setincidence_category')->get();
        $location = DB::table('risk_setupincidence_location')->get();
        $level = DB::table('risk_setupincidence_level')->get();
        $setting = DB::table('risk_setincidence_setting')->get();
        $incidentsub = DB::table('risk_setupincidence_sub')->get();
        $typelocation = DB::table('risk_setupincidence_tpyelocation')->get();
        $sex = DB::table('hrd_sex')->get();
        $grouplocation = DB::table('risk_setup_origindepart')->get();

        $worktime = DB::table('risk_workingtime')->get();
        $effect = DB::table('risk_setupincidence_usereffect')->get();

        $leader =  DB::table('gleave_leader_person')
        ->leftJoin('gleave_leader','gleave_leader.LEADER_ID','=','gleave_leader_person.LEADER_ID')
        ->where('PERSON_ID','=',$iduser)
        ->get();
 
         $check = DB::table('risk_function')->where('RISK_FUNCTION_ID','=','1')->first();



       
            $origin = DB::table('risk_setupincidence_origin')->get(); 
            $typelocationf = DB::table('risk_setupincidence_tpyelocation')->first();
            $grouplocation = DB::table('risk_rep_location')->where('SETUP_TYPELOCATION_ID','=',$typelocationf->SETUP_TYPELOCATION_ID)->get();

            $worktime = DB::table('risk_rep_time')->get();
            $typelocation = DB::table('risk_setupincidence_tpyelocation')->get();
            $infoper = DB::table('hrd_person')->get();
            $uefect = DB::table('risk_setupincidence_usereffect')->get();
            // $departsub = DB::table('hrd_department_sub_sub')->get();
            $riskcategory = DB::table('risk_setincidence_category')->get();
            $location = DB::table('risk_setupincidence_location')->get();
            $level = DB::table('risk_rep_level')->get();
            $setting = DB::table('risk_setincidence_setting')->get(); 
            $incidentsub = DB::table('risk_setupincidence_sub')->get();
            $riskitem = Risk_rep_items::get();
            $sex = DB::table('hrd_sex')->get();
            $effect = DB::table('risk_setupincidence_usereffect')->get();
            $departmentsub  =  DB::table('hrd_department')->get();
            $riskprogram  = DB::table('risk_rep_program')->get();
            $riskprogramsub  = DB::table('risk_rep_program_sub')->get();
            $riskprogramsubsub  = DB::table('risk_rep_program_subsub')->get();
            $risktypereason  = DB::table('risk_rep_typereason')->get();
            $risktypereasonsys  = DB::table('risk_rep_typereason_sys')->get();
            $item = DB::table('risk_rep_items')->get();
            $itemsub = DB::table('risk_rep_items_sub')->get();
            $infoteam = Team::orderBy('HR_TEAM_ID', 'asc')->get();  

         

            $infordepartmentsub  =  DB::table('hrd_department_sub')->get();           

                //-----------------   หน่วยงาน --------------------------
              $infordepartmentsubsub  =  DB::table('hrd_department_sub_sub')->get();

              $inforiskacc = DB::table('risk_account_detail')->get();

              $infolocation = DB::table('supplies_location')->get();
              $infolocationlevel = DB::table('supplies_location_level')->get();
              $infolocationlevelroom = DB::table('supplies_location_level_room')->get();


        return view('general_risk.risk_notify_add',[
            'inforpersonuserid' => $inforpersonuserid,
            'inforpersonuser' => $inforpersonuser,
            'effects' => $effect,
            'departsubs'=>$departsub,
            'riskcategorys'=>$riskcategory,
            'locations'=>$location,
            'levels'=>$level,
            'settings'=>$setting,
            'incidentsubs'=>$incidentsub,
            'typelocations'=>$typelocation,
            'sexs'=>$sex,
            'infopers'=>$infoper,
            'grouplocations'=>$grouplocation,
            'worktimes'=>$worktime,
            'leaders'=>$leader,
            'check'=>$check,
            'inforiskaccs'=>$inforiskacc,
            'riskcategorys'=>$riskcategory,
            'locations'=>$location,
            'levels'=>$level,
            'settings'=>$setting,
            'incidentsubs'=>$incidentsub,
            'origins'=>$origin,
            'sexs'=>$sex,
            'infopers'=>$infoper,
            'grouplocations'=>$grouplocation,
            'worktimes'=>$worktime,
            'typelocations'=>$typelocation,
            'departmentsubs'=>$departmentsub,
            'infordepartmentsubs'=>$infordepartmentsub,
            'infordepartmentsubsubs'=>$infordepartmentsubsub,
            'riskprograms'=>$riskprogram,
            'riskprogramsubs'=>$riskprogramsub,
            'riskprogramsubsubs'=>$riskprogramsubsub,
            'risktypereasons'=>$risktypereason,
            'risktypereasonsyss'=>$risktypereasonsys,
            'uefects'=>$uefect,
            'infoteams'=>$infoteam,
            'items'=>$item,
            'riskitems'=>$riskitem,
            'itemsubs'=>$itemsub,
            'infolocations' => $infolocation,
            'infolocationlevels' => $infolocationlevel,
            'infolocationlevelrooms' => $infolocationlevelroom, 

            ]);
    }
    //-------------------------------------ฟังชันรันเลขอ้างอิง--------------------
    
public static function refnumberRisk()
    {   
            $m_budget = date("m");
            if($m_budget>9){
            $yearbudget = date("Y")+544;
            }else{
            $yearbudget = date("Y")+543;
            }
        $maxnumber = DB::table('risk_rep')->where('BUDGET_YEAR','=',$yearbudget)->max('RISKREP_ID');  

        if($maxnumber != '' ||  $maxnumber != null){
            
            $refmax = DB::table('risk_rep')->where('RISKREP_ID','=',$maxnumber)->first();  
            if($refmax->RISKREP_ID != '' ||  $refmax->RISKREP_ID != null){
                $maxref = substr($refmax->RISKREP_ID, -4)+1;
            }else{
                $maxref = 1;
            }
            $ref = str_pad($maxref, 4, "0", STR_PAD_LEFT);
        
        }else{
            $ref = '0001';
        }  
        $y = substr($yearbudget, -2);
        $refnumber ='R'.$y.'-'.$ref;
        return $refnumber;
    }
 
    public function risk_notify_save(Request $request)
    {    
        $iduser = $request->USER_ID;
        // dd($iduser);
        $inforpersonuserid =  Person::where('ID','=',$iduser)->first();
        // dd($inforpersonuserid);
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

        //    dd($inforpersonuser);

        $savedate= $request->RISKREP_DATESAVE;
        if($savedate != ''){           
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $savedate)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0];             
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $save_date= $y_st."-".$m_st."-".$d_st;   
            }else{
            $save_date= null;
        }

        $repstart= $request->RISKREP_STARTDATE;
        if($repstart != ''){           
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $repstart)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0];             
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $start_date= $y_st."-".$m_st."-".$d_st;   
            }else{
            $start_date= null;
        }

        $checkdigget= $request->RISKREP_DIGDATE;
        if($checkdigget != ''){           
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $checkdigget)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0];             
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $dig_date= $y_st."-".$m_st."-".$d_st;   
            }else{
            $dig_date= null;
        }

        $id = $request->RISKREP_LEVEL;
        $id_level = Risk_setupincidence_level::where('INCIDENCE_LEVEL_ID','=',$id)->first();

        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;
        }

        //===============สร้างเลขR isk ==================//

        $maxnumber = DB::table('risk_rep')->where('BUDGET_YEAR','=',$yearbudget)->max('RISKREP_ID');     
        if($maxnumber != '' ||  $maxnumber != null){        
            $refmax = DB::table('risk_rep')->where('RISKREP_ID','=',$maxnumber)->first();  
            if($refmax->RISKREP_ID != '' ||  $refmax->RISKREP_ID != null){
                $maxref = substr($refmax->RISKREP_ID, -4)+1;
            }else{
                $maxref = 1;
            }
            $ref = str_pad($maxref, 4, "0", STR_PAD_LEFT);        
                }else{
                    $ref = '0001';
                }       
                $y = substr($yearbudget, -2); 
        $refnumber ='Risk-'.$y.''.$ref;

        $idleader = $request->LEADER_PERSON_ID;
        $inforpersonleader =  Person::where('ID','=',$idleader)->first();

        $check = DB::table('risk_function')->where('RISK_FUNCTION_ID','=','1')->first();


        $add = new Riskrep();
        $add->RISKREP_NO =  $request->RISKREP_NO;
        $add->RISKREP_DATESAVE =  $save_date;
        $add->RISKREP_SEARCHLOCATE =  $request->RISKREP_SEARCHLOCATE;
        $add->RISKREP_DEPARTMENT_SUB = $request->RISKREP_DEPARTMENT_SUB;  
        $add->RISKREP_TYPE =  $request->RISKREP_TYPE;
        $add->RISKREP_LOCAL =  $request->RISKREP_LOCAL;
        $add->RISKREP_TITLE =  $request->RISKREP_TITLE; 
        $add->RISKREP_DETAILRISK =  $request->RISKREP_DETAILRISK; 
        $add->RISKREP_BASICMANAGE =  $request->RISKREP_BASICMANAGE;
        $add->RISKREP_STATUS = 'REPORT'; 
        $add->BUDGET_YEAR = $yearbudget;

        $add->RISKREP_USEREFFECT =  $inforpersonuserid->ID;
        $add->RISKREP_USEREFFECT_FULLNAME =  $inforpersonuserid->HR_FNAME. '  ' .$inforpersonuserid->HR_LNAME;

        $add->LEADER_PERSON_ID =  $inforpersonleader->ID;
        $add->LEADER_PERSON_NAME =  $inforpersonleader->HR_FNAME. '  ' .$inforpersonleader->HR_LNAME;


        $add->RISKREP_LOCATION_ID =  $request->RISKREP_LOCATION_ID; 
        $add->RISKREP_LOCATION_LEVEL =  $request->RISKREP_LOCATION_LEVEL; 
        $add->RISKREP_LOCATION_LEVEL_ROOM =  $request->RISKREP_LOCATION_LEVEL_ROOM;
        $add->RISKREP_LOCATION_OTHER =  $request->RISKREP_LOCATION_OTHER;


        $maxid = Riskrep::max('RISKREP_ID');
        $idfile = $maxid+1;
        if($request->hasFile('RISKREP_DOCFILE')){
            $newFileName = 'riskrep_'.$idfile.'.'.$request->RISKREP_DOCFILE->extension();
              
            $request->RISKREP_DOCFILE->storeAs('riskrep',$newFileName,'public');

            // $addreceipt->BOOK_HAVE_FILE = 'True';
            $add->RISKREP_DOCFILE = $newFileName;
        }        
      
        if($request->hasFile('RISK_REP_IMG')){
            $file = $request->file('RISK_REP_IMG');
            $contents = $file->openFile()->fread($file->getSize());
            $add->RISK_REP_IMG = $contents;
        }



        if($check->ACTIVE  == 'True'){

            $repstart= $request->RISKREP_STARTDATE;
            if($repstart != ''){           
                $STARTDAY = Carbon::createFromFormat('d/m/Y', $repstart)->format('Y-m-d');
                $date_arrary_st=explode("-",$STARTDAY);  
                $y_sub_st = $date_arrary_st[0];             
                if($y_sub_st >= 2500){
                    $y_st = $y_sub_st-543;
                }else{
                    $y_st = $y_sub_st;
                }
                $m_st = $date_arrary_st[1];
                $d_st = $date_arrary_st[2];  
                $start_date= $y_st."-".$m_st."-".$d_st;   
                }else{
                $start_date= null;
            }
            $checkdigget= $request->RISKREP_DIGDATE;
            if($checkdigget != ''){           
                $STARTDAY = Carbon::createFromFormat('d/m/Y', $checkdigget)->format('Y-m-d');
                $date_arrary_st=explode("-",$STARTDAY);  
                $y_sub_st = $date_arrary_st[0];             
                if($y_sub_st >= 2500){
                    $y_st = $y_sub_st-543;
                }else{
                    $y_st = $y_sub_st;
                }
                $m_st = $date_arrary_st[1];
                $d_st = $date_arrary_st[2];  
                $dig_date= $y_st."-".$m_st."-".$d_st;   
                }else{
                $dig_date= null;
            }

            $add->RISKREP_STARTDATE =  $start_date; 
            $add->RISKREP_DIGDATE =  $dig_date; 
            $add->RISKREP_LOCAL =  $request->RISKREP_LOCAL;
            $add->RISK_REPPROGRAM_ID =  $request->RISK_REPPROGRAM_ID; 
            $add->RISK_REPPROGRAMSUB_ID =  $request->RISK_REPPROGRAMSUB_ID; 
            $add->RISK_REPPROGRAMSUBSUB_ID =  $request->RISK_REPPROGRAMSUBSUB_ID;   
            $add->RISK_REPTYPERESON_ID =  $request->RISK_REPTYPERESON_ID;    
            $add->RISK_REPTYPERESONSYS_ID =  $request->RISK_REPTYPERESONSYS_ID;  
            $add->RISKREP_FATE =  $request->RISKREP_FATE; 
            $add->RISKREP_TIME =  $request->RISKREP_TIME; 
            $add->RISKREP_LEVEL =  $request->RISKREP_LEVEL; 
            $add->RISK_REP_FEEDBACK =  $request->RISK_REP_FEEDBACK;
            $add->RISK_REP_EFFECT =  $request->RISK_REP_EFFECT;
            $add->RISKREP_SEX =  $request->RISKREP_SEX; 
            $add->RISKREP_AGE =  $request->RISKREP_AGE;
            $add->RISKREP_ACC_ID =  $request->RISKREP_ACC_ID; 

        }


        
        $add->save(); 

        function DateThailinerisk($strDate)
        {
          $strYear = date("Y",strtotime($strDate))+543;
          $strMonth= date("n",strtotime($strDate));
          $strDay= date("j",strtotime($strDate));
  
          $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
          $strMonthThai=$strMonthCut[$strMonth];
          return "$strDay $strMonthThai $strYear";
          }

        $header = "รายงานความเสี่ยง";
        $LRISKREP_DATESAVE = DateThailinerisk($save_date);  // วันที่
        $LRISKREP_DEPARTMENT_SUB = $request->RISKREP_DEPARTMENT_SUB; // หน่วยงาน
        $LSEARCHLOCATE = $request->RISKREP_SEARCHLOCATE; //แหล่งที่มา  
        $LRISKREP_TYPE = $request->RISKREP_TYPE; //สถานที่ 
        $LRISKREP_DETAILRISK = $request->RISKREP_DETAILRISK; //รายละเอียด 
        $LRISKREP_BASICMANAGE = $request->RISKREP_BASICMANAGE; //การจัดการเบื้องต้น 
        $LRISKREP_STATUS = 'REPORT'; //สถานะ รายงาน 

        if($request->RISKREP_ID != ''){
           $RISKREP_ID = $request->RISKREP_ID;
           }        
                    
           $departmentsubsub = DB::table('hrd_department_sub_sub')->where('HR_DEPARTMENT_SUB_SUB_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)->first();   
           $HR_DEPARTMENT_SUB_SUB_NAME = $departmentsubsub->HR_DEPARTMENT_SUB_SUB_NAME;

           $searlocate = DB::table('risk_setupincidence_location')->where('INCIDENCE_LOCATION_ID','=',$request->RISKREP_SEARCHLOCATE)->first();
           $slocate = $searlocate->INCIDENCE_LOCATION_NAME;

           $reptype = DB::table('risk_setupincidence_tpyelocation')->where('SETUP_TYPELOCATION_ID','=',$request->RISKREP_TYPE)->first();
           $riskreptype = $reptype->SETUP_TYPELOCATION_NAME;

        $message = $header.
            "\n"."วันที่ : " . $LRISKREP_DATESAVE .
            "\n"."หน่วยงาน : " . $HR_DEPARTMENT_SUB_SUB_NAME .
            "\n"."แหล่งที่มา : " . $slocate .
            "\n"."สถานที่ : " . $riskreptype .
            "\n"."รายละเอียด : " . $LRISKREP_DETAILRISK .
            "\n"."การจัดการเบื้องต้น : " . $LRISKREP_BASICMANAGE .  
            "\n"."สถานะ : " . $LRISKREP_STATUS ;
                        
                    $name = DB::table('line_token')->where('ID_LINE_TOKEN','=',10)->first();        
                    $sending =$name->LINE_TOKEN;
        
                    $chOne = curl_init();
                    curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
                    curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0);
                    curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0);
                    curl_setopt( $chOne, CURLOPT_POST, 1);
                    curl_setopt( $chOne, CURLOPT_POSTFIELDS, $message);
                    curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=$message");
                    curl_setopt( $chOne, CURLOPT_FOLLOWLOCATION, 1);
                    $headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$sending.'', );
                    curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1);
                    $result = curl_exec( $chOne );
                    if(curl_error($chOne)) { echo 'error:' . curl_error($chOne); }
                    else { $result_ = json_decode($result, true);
                    echo "status : ".$result_['status']; echo "message : ". $result_['message']; }
                    curl_close( $chOne );




           //แจ้งเตือนกลุ่มหน่วยงาน
        //    $name_re = DB::table('hrd_person')->where('ID','=',$request->USER_REQUEST_ID)->first();  
           $name_request = DB::table('hrd_department_sub_sub')->where('HR_DEPARTMENT_SUB_SUB_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)->first();        
           $subsending =$name_request->LINE_TOKEN;

           $chOne3 = curl_init();
            curl_setopt( $chOne3, CURLOPT_URL, "https://notify-api.line.me/api/notify");
            curl_setopt( $chOne3, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt( $chOne3, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt( $chOne3, CURLOPT_POST, 1);
            curl_setopt( $chOne3, CURLOPT_POSTFIELDS, $message);
            curl_setopt( $chOne3, CURLOPT_POSTFIELDS, "message=$message");
            curl_setopt( $chOne3, CURLOPT_FOLLOWLOCATION, 1);
            $headers3 = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$subsending.'', );
            curl_setopt($chOne3, CURLOPT_HTTPHEADER, $headers3);
            curl_setopt( $chOne3, CURLOPT_RETURNTRANSFER, 1);
            $result3 = curl_exec( $chOne3 );
            if(curl_error($chOne3)) { echo 'error:' . curl_error($chOne3); }
            else { $result_ = json_decode($result3, true);
            echo "status : ".$result_['status']; echo "message : ". $result_['message']; }
            curl_close( $chOne3 );
       
        return redirect()->route('gen_risk.risk_notify',[
        'iduser'=> $iduser 
        ]);
    }
    public function risk_notify_detail(Request $request,$id,$iduser)
    {
        $inforpersonuserid =  Person::where('ID','=',$iduser)->first();

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
        $yearbudget = date("Y")+543;        }

        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';
        $status = '';
        $search = '';
        $year_id = $yearbudget;

        $rigrep = Riskrep::leftjoin('risk_status','risk_status.RISK_STATUS_NAME','=','risk_rep.RISKREP_STATUS')
        ->leftjoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','risk_rep.RISKREP_DEPARTMENT_SUB')
        ->leftjoin('risk_setupincidence_tpyelocation','risk_setupincidence_tpyelocation.SETUP_TYPELOCATION_ID','=','risk_rep.RISKREP_TYPE')
        ->leftjoin('risk_setupincidence_grouplocation','risk_setupincidence_grouplocation.SETUP_GROUPLOCATION_ID','=','risk_rep.RISKREP_LOCAL')
        ->leftjoin('risk_setincidence_setting','risk_setincidence_setting.INCIDENCE_SETTING_ID','=','risk_rep.RISKREP_TITLE')
        ->leftjoin('risk_setupincidence_sub','risk_setupincidence_sub.INCIDENCE_SUB_ID','=','risk_rep.RISKREP_SUBTITLE')
        ->leftjoin('hrd_sex','hrd_sex.SEX_ID','=','risk_rep.RISKREP_SEX')
        ->leftjoin('risk_setupincidence_location','risk_setupincidence_location.INCIDENCE_LOCATION_ID','=','risk_rep.RISKREP_SEARCHLOCATE')
        ->where('risk_rep.RISKREP_ID','=',$id)->first();



        $notify_repeat = Risk_notify_repeat_sub::leftjoin('hrd_person','risk_notify_repeat_sub.NOTIFY_REPEAT_USER_SAVE','=','hrd_person.ID')  
            ->leftjoin('risk_rep','risk_notify_repeat_sub.RISKREP_ID','=','risk_rep.RISKREP_ID')
            ->leftjoin('risk_setincidence_setting','risk_rep.RISKREP_TITLE','=','risk_setincidence_setting.INCIDENCE_SETTING_ID')
            ->leftjoin('risk_setupincidence_grouplocation','risk_rep.RISKREP_LOCAL','=','risk_setupincidence_grouplocation.SETUP_GROUPLOCATION_ID')
            ->leftjoin('risk_status','risk_rep.RISKREP_STATUS','=','risk_status.RISK_STATUS_NAME')
            ->leftjoin('risk_notify_accept_sub','risk_notify_repeat_sub.RISKREP_ID','=','risk_notify_accept_sub.RISKREP_ID')  
        ->where('risk_notify_repeat_sub.RISKREP_ID','=',$id)->get();

        return view('general_risk.risk_notify_detail',[
            'inforpersonuserid' => $inforpersonuserid,
            'inforpersonuser' => $inforpersonuser,
            'rigreps'=>$rigrep,
            'notify_repeats'=>$notify_repeat,
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id,
            ]);
    }
    public function risk_notify_edit(Request $request,$id,$iduser)
    {
        $inforpersonuserid =  Person::where('ID','=',$iduser)->first();
        // $id = $inforpersonuserid->ID;

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

        $rigrep = Riskrep::leftjoin('risk_status','risk_status.RISK_STATUS_NAME','=','risk_rep.RISKREP_STATUS')
        ->leftjoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','risk_rep.RISKREP_DEPARTMENT_SUB')
        ->leftjoin('risk_setupincidence_tpyelocation','risk_setupincidence_tpyelocation.SETUP_TYPELOCATION_ID','=','risk_rep.RISKREP_TYPE')
        ->leftjoin('risk_setupincidence_grouplocation','risk_setupincidence_grouplocation.SETUP_GROUPLOCATION_ID','=','risk_rep.RISKREP_LOCAL')
        ->leftjoin('risk_setincidence_setting','risk_setincidence_setting.INCIDENCE_SETTING_ID','=','risk_rep.RISKREP_TITLE')
        ->leftjoin('risk_setupincidence_sub','risk_setupincidence_sub.INCIDENCE_SUB_ID','=','risk_rep.RISKREP_SUBTITLE')
        ->leftjoin('hrd_sex','hrd_sex.SEX_ID','=','risk_rep.RISKREP_SEX')
        ->leftjoin('risk_setupincidence_location','risk_setupincidence_location.INCIDENCE_LOCATION_ID','=','risk_rep.RISKREP_SEARCHLOCATE')
        ->where('risk_rep.RISKREP_ID','=',$id)->first();

            $infoper = DB::table('hrd_person')->get();
            // $departsub = DB::table('hrd_department_sub_sub')->get();
            $departsub = DB::table('hrd_department_sub_sub')->where('HR_DEPARTMENT_SUB_SUB_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)->get();
            $riskcategory = DB::table('risk_setincidence_category')->get();
            $location = DB::table('risk_setupincidence_location')->get();
            $level = DB::table('risk_setupincidence_level')->get();
            $setting = DB::table('risk_setincidence_setting')->get();
            $incidentsub = DB::table('risk_setupincidence_sub')->get();
            $typelocation = DB::table('risk_setupincidence_tpyelocation')->get();
            $sex = DB::table('hrd_sex')->get();
            $grouplocation = DB::table('risk_setup_origindepart')->get();
            $worktime = DB::table('risk_workingtime')->get();
            $effect = DB::table('risk_setupincidence_usereffect')->get();

            $leader =  DB::table('gleave_leader_person')
            ->leftJoin('gleave_leader','gleave_leader.LEADER_ID','=','gleave_leader_person.LEADER_ID')
            ->where('PERSON_ID','=',$iduser)
            ->get();


            $check = DB::table('risk_function')->where('RISK_FUNCTION_ID','=','1')->first();
            
            $origin = DB::table('risk_setupincidence_origin')->get(); 
            $typelocationf = DB::table('risk_setupincidence_tpyelocation')->first();
            $grouplocation = DB::table('risk_rep_location')->where('SETUP_TYPELOCATION_ID','=',$typelocationf->SETUP_TYPELOCATION_ID)->get();

            $worktime = DB::table('risk_rep_time')->get();
            $typelocation = DB::table('risk_setupincidence_tpyelocation')->get();
            $infoper = DB::table('hrd_person')->get();
            $uefect = DB::table('risk_setupincidence_usereffect')->get();
            // $departsub = DB::table('hrd_department_sub_sub')->get();
            $riskcategory = DB::table('risk_setincidence_category')->get();
            $location = DB::table('risk_setupincidence_location')->get();
            $level2 = DB::table('risk_rep_level')->get();
            $setting = DB::table('risk_setincidence_setting')->get(); 
            $incidentsub = DB::table('risk_setupincidence_sub')->get();
            $riskitem = Risk_rep_items::get();
            $sex = DB::table('hrd_sex')->get();
            $effect = DB::table('risk_setupincidence_usereffect')->get();
            $departmentsub  =  DB::table('hrd_department')->get();
            $riskprogram  = DB::table('risk_rep_program')->get();
            $riskprogramsub  = DB::table('risk_rep_program_sub')->get();
            $riskprogramsubsub  = DB::table('risk_rep_program_subsub')->get();
            $risktypereason  = DB::table('risk_rep_typereason')->get();
            $risktypereasonsys  = DB::table('risk_rep_typereason_sys')->get();
            $item = DB::table('risk_rep_items')->get();
            $itemsub = DB::table('risk_rep_items_sub')->get();
            $infoteam = Team::orderBy('HR_TEAM_ID', 'asc')->get();  

         
            $infordepartmentsub  =  DB::table('hrd_department_sub')->get();           
                //-----------------   หน่วยงาน --------------------------
            $infordepartmentsubsub  =  DB::table('hrd_department_sub_sub')->get();
            $inforiskacc = DB::table('risk_account_detail')->get();


              $infolocation = DB::table('supplies_location')->get();
              $infolocationlevel = DB::table('supplies_location_level')->get();
              $infolocationlevelroom = DB::table('supplies_location_level_room')->get();


        return view('general_risk.risk_notify_edit',[
            'inforpersonuserid' => $inforpersonuserid,
            'inforpersonuser' => $inforpersonuser,
            'departsubs'=>$departsub,
            'rigreps'=>$rigrep,
            'effects'=>$effect,
            'riskcategorys'=>$riskcategory,
            'locations'=>$location,
            'levels'=>$level,
            'settings'=>$setting,
            'incidentsubs'=>$incidentsub,
            'typelocations'=>$typelocation,
            'sexs'=>$sex,
            'infopers'=>$infoper,
            'grouplocations'=>$grouplocation,
            'worktimes'=>$worktime,
            'leaders'=>$leader,
            'check'=>$check,
            'inforiskaccs'=>$inforiskacc,
            'riskcategorys'=>$riskcategory,
            'locations'=>$location,
            'level2s'=>$level2,
            'settings'=>$setting,
            'incidentsubs'=>$incidentsub,
            'origins'=>$origin,
            'sexs'=>$sex,
            'infopers'=>$infoper,
            'grouplocations'=>$grouplocation,
            'worktimes'=>$worktime,
            'typelocations'=>$typelocation,
            'departmentsubs'=>$departmentsub,
            'infordepartmentsubs'=>$infordepartmentsub,
            'infordepartmentsubsubs'=>$infordepartmentsubsub,
            'riskprograms'=>$riskprogram,
            'riskprogramsubs'=>$riskprogramsub,
            'riskprogramsubsubs'=>$riskprogramsubsub,
            'risktypereasons'=>$risktypereason,
            'risktypereasonsyss'=>$risktypereasonsys,
            'uefects'=>$uefect,
            'infoteams'=>$infoteam,
            'items'=>$item,
            'riskitems'=>$riskitem,
            'itemsubs'=>$itemsub,
            'infolocations' => $infolocation,
            'infolocationlevels' => $infolocationlevel,
            'infolocationlevelrooms' => $infolocationlevelroom, 
            ]);
    }
 
    public function risk_notify_update(Request $request)
    {    
        $iduser = $request->USER_ID;
        $inforpersonuserid =  Person::where('ID','=',$iduser)->first();

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

        $savedate= $request->RISKREP_DATESAVE;
        if($savedate != ''){           
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $savedate)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0];             
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $save_date= $y_st."-".$m_st."-".$d_st;   
            }else{
            $save_date= null;
        }
        $repstart= $request->RISKREP_STARTDATE;
        if($repstart != ''){           
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $repstart)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0];             
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $start_date= $y_st."-".$m_st."-".$d_st;   
            }else{
            $start_date= null;
        }
        $checkdigget= $request->RISKREP_DIGDATE;
        if($checkdigget != ''){           
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $checkdigget)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0];             
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $dig_date= $y_st."-".$m_st."-".$d_st;   
            }else{
            $dig_date= null;
        }
    
        $id = $request->RISKREP_ID;
        $idl = $request->RISKREP_LEVEL;
        $id_level = Risk_setupincidence_level::where('INCIDENCE_LEVEL_ID','=',$idl)->first();

       $usere_id = $request->RISKREP_USEREFFECT;
        $id_usereffect =DB::table('hrd_person')->where('ID','=',$usere_id)->first();


        $idleader = $request->LEADER_PERSON_ID;
        $inforpersonleader =  Person::where('ID','=',$idleader)->first();
      
        $check = DB::table('risk_function')->where('RISK_FUNCTION_ID','=','1')->first();
        
        $update =Riskrep::find($id);    
        // $update->RISKREP_NO =  $request->RISKREP_NO;        
        // $update->RISKREP_DATESAVE =  $save_date;
        // $update->RISKREP_SEARCHLOCATE =  $request->RISKREP_SEARCHLOCATE;
        // $update->RISKREP_DEPARTMENT_SUB = $request->RISKREP_DEPARTMENT_SUB; 
        // $update->RISKREP_TYPE =  $request->RISKREP_TYPE;
        // $update->RISKREP_LOCAL =  $request->RISKREP_LOCAL;
        // $update->RISKREP_TITLE =  $request->RISKREP_TITLE; 
        // $update->RISKREP_DETAILRISK =  $request->RISKREP_DETAILRISK; 
        // $update->RISKREP_BASICMANAGE =  $request->RISKREP_BASICMANAGE;
        // $update->RISKREP_USEREFFECT =  $id_usereffect->ID; 
        // $update->RISKREP_USEREFFECT_FULLNAME =  $id_usereffect->HR_FNAME.' '.$id_usereffect->HR_LNAME; 
        // $update->RISKREP_SEX =  $request->RISKREP_SEX; 
        // $update->RISKREP_AGE =  $request->RISKREP_AGE; 
        // $update->RISKREP_STARTDATE =  $start_date; 
        // $update->RISKREP_DIGDATE =  $dig_date; 
        // $update->RISKREP_FATE =  $request->RISKREP_FATE; 
        // $update->RISKREP_TIME =  $request->RISKREP_TIME;         
        // $update->save(); 

        $update->RISKREP_NO =  $request->RISKREP_NO;
        $update->RISKREP_DATESAVE =  $save_date;
        $update->RISKREP_SEARCHLOCATE =  $request->RISKREP_SEARCHLOCATE;
        $update->RISKREP_DEPARTMENT_SUB = $request->RISKREP_DEPARTMENT_SUB;  
        $update->RISKREP_TYPE =  $request->RISKREP_TYPE;
        $update->RISKREP_LOCAL =  $request->RISKREP_LOCAL;
        $update->RISKREP_TITLE =  $request->RISKREP_TITLE; 
        $update->RISKREP_DETAILRISK =  $request->RISKREP_DETAILRISK; 
        $update->RISKREP_BASICMANAGE =  $request->RISKREP_BASICMANAGE;


        $update->RISKREP_LOCATION_ID =  $request->RISKREP_LOCATION_ID; 
        $update->RISKREP_LOCATION_LEVEL =  $request->RISKREP_LOCATION_LEVEL; 
        $update->RISKREP_LOCATION_LEVEL_ROOM =  $request->RISKREP_LOCATION_LEVEL_ROOM;
        $update->RISKREP_LOCATION_OTHER =  $request->RISKREP_LOCATION_OTHER;
        // $update->RISKREP_STATUS = 'REPORT'; 
        // $update->BUDGET_YEAR = $yearbudget; 
        $update->RISKREP_USEREFFECT =  $inforpersonuserid->ID;
        $update->RISKREP_USEREFFECT_FULLNAME =  $inforpersonuserid->HR_FNAME. '  ' .$inforpersonuserid->HR_LNAME;

        $update->LEADER_PERSON_ID =  $inforpersonleader->ID;
        $update->LEADER_PERSON_NAME =  $inforpersonleader->HR_FNAME. '  ' .$inforpersonleader->HR_LNAME;

       
        $idfile = $request->RISKREP_ID;
        if($request->hasFile('RISKREP_DOCFILE')){
            $newFileName = 'riskrep_'.$idfile.'.'.$request->RISKREP_DOCFILE->extension();              
            $request->RISKREP_DOCFILE->storeAs('riskrep',$newFileName,'public');
            $update->RISKREP_DOCFILE = $newFileName;
        }        
      
        if($request->hasFile('RISK_REP_IMG')){
            $file = $request->file('RISK_REP_IMG');
            $contents = $file->openFile()->fread($file->getSize());
            $update->RISK_REP_IMG = $contents;
        }

        

        if($check->ACTIVE  == 'True'){

            $repstart= $request->RISKREP_STARTDATE;
            if($repstart != ''){           
                $STARTDAY = Carbon::createFromFormat('d/m/Y', $repstart)->format('Y-m-d');
                $date_arrary_st=explode("-",$STARTDAY);  
                $y_sub_st = $date_arrary_st[0];             
                if($y_sub_st >= 2500){
                    $y_st = $y_sub_st-543;
                }else{
                    $y_st = $y_sub_st;
                }
                $m_st = $date_arrary_st[1];
                $d_st = $date_arrary_st[2];  
                $start_date= $y_st."-".$m_st."-".$d_st;   
                }else{
                $start_date= null;
            }
            $checkdigget= $request->RISKREP_DIGDATE;
            if($checkdigget != ''){           
                $STARTDAY = Carbon::createFromFormat('d/m/Y', $checkdigget)->format('Y-m-d');
                $date_arrary_st=explode("-",$STARTDAY);  
                $y_sub_st = $date_arrary_st[0];             
                if($y_sub_st >= 2500){
                    $y_st = $y_sub_st-543;
                }else{
                    $y_st = $y_sub_st;
                }
                $m_st = $date_arrary_st[1];
                $d_st = $date_arrary_st[2];  
                $dig_date= $y_st."-".$m_st."-".$d_st;   
                }else{
                $dig_date= null;
            }

            $update->RISKREP_STARTDATE =  $start_date; 
            $update->RISKREP_DIGDATE =  $dig_date; 
            $update->RISKREP_LOCAL =  $request->RISKREP_LOCAL;
            $update->RISK_REPPROGRAM_ID =  $request->RISK_REPPROGRAM_ID; 
            $update->RISK_REPPROGRAMSUB_ID =  $request->RISK_REPPROGRAMSUB_ID; 
            $update->RISK_REPPROGRAMSUBSUB_ID =  $request->RISK_REPPROGRAMSUBSUB_ID;   
            $update->RISK_REPTYPERESON_ID =  $request->RISK_REPTYPERESON_ID;    
            $update->RISK_REPTYPERESONSYS_ID =  $request->RISK_REPTYPERESONSYS_ID;  
            $update->RISKREP_FATE =  $request->RISKREP_FATE; 
            $update->RISKREP_TIME =  $request->RISKREP_TIME; 
            $update->RISKREP_LEVEL =  $request->RISKREP_LEVEL; 
            $update->RISK_REP_FEEDBACK =  $request->RISK_REP_FEEDBACK;
            $update->RISK_REP_EFFECT =  $request->RISK_REP_EFFECT;
            $update->RISKREP_SEX =  $request->RISKREP_SEX; 
            $update->RISKREP_AGE =  $request->RISKREP_AGE;
            $update->RISKREP_ACC_ID =  $request->RISKREP_ACC_ID; 


            

        }

        
        $update->save();
       
        return redirect()->route('gen_risk.risk_notify',[
            'iduser'=> $iduser 
            ]);
    }

    public function risk_notify_cancel(Request $request,$id,$iduser)
    {
        $inforpersonuserid =  Person::where('ID','=',$iduser)->first();

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

        $rigrep = DB::table('risk_rep')->where('RISKREP_ID','=',$id)
            ->leftJoin('risk_setupincidence_level','risk_rep.RISKREP_LEVEL','=','risk_setupincidence_level.INCIDENCE_LEVEL_NAME')
            ->leftJoin('risk_setupincidence_location','risk_rep.RISKREP_SEARCHLOCATE','=','risk_setupincidence_location.INCIDENCE_LOCATION_ID')
            ->leftJoin('risk_setup_origindepart','risk_rep.RISKREP_LOCAL','=','risk_setup_origindepart.ORIGIN_DEPART_ID')
            ->leftJoin('hrd_department_sub_sub','risk_rep.RISKREP_DEPARTMENT_SUB','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
            ->leftJoin('risk_setupincidence_tpyelocation','risk_rep.RISKREP_TYPE','=','risk_setupincidence_tpyelocation.SETUP_TYPELOCATION_ID')
            ->leftJoin('risk_setincidence_setting','risk_rep.RISKREP_TITLE','=','risk_setincidence_setting.INCIDENCE_SETTING_ID')
            ->leftJoin('hrd_person','risk_rep.RISKREP_USEREFFECT','=','hrd_person.ID')
            ->leftJoin('hrd_sex','risk_rep.RISKREP_SEX','=','hrd_sex.SEX_ID')
            ->leftJoin('risk_workingtime','risk_rep.RISKREP_FATE','=','risk_workingtime.WORKING_TIME_ID')
        ->first();


        $infoper = DB::table('hrd_person')->get();
        $departsub = DB::table('hrd_department_sub_sub')->get();
        $riskcategory = DB::table('risk_setincidence_category')->get();
        $location = DB::table('risk_setupincidence_location')->get();
        $level = DB::table('risk_setupincidence_level')->get();

        $setting = DB::table('risk_setincidence_setting')->get();
        $incidentsub = DB::table('risk_setupincidence_sub')->get();
        $typelocation = DB::table('risk_setupincidence_tpyelocation')->get();
        $sex = DB::table('hrd_sex')->get();
        $grouplocation = DB::table('risk_setup_origindepart')->get();
        $worktime = DB::table('risk_workingtime')->get();
        $effect = DB::table('risk_setupincidence_usereffect')->get();

 
        return view('general_risk.risk_notify_cancel',[
            'inforpersonuserid' => $inforpersonuserid,
            'inforpersonuser' => $inforpersonuser,
            'departsubs'=>$departsub,
            'rigreps'=>$rigrep,
            'effects'=>$effect,
            'riskcategorys'=>$riskcategory,
            'locations'=>$location,
            'levels'=>$level,
            'settings'=>$setting,
            'incidentsubs'=>$incidentsub,
            'typelocations'=>$typelocation,
            'sexs'=>$sex,
            'infopers'=>$infoper,
            'grouplocations'=>$grouplocation,
            'worktimes'=>$worktime,
            ]);
    }
    public function risk_notify_updatecancel (Request $request)
    {
        $iduser = $request->USER_ID;
        $inforpersonuserid =  Person::where('ID','=',$iduser)->first();

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

        $id = $request->RISKREP_ID;   
        $update =Riskrep::find($id);
        $update->RISKREP_STATUS = 'CANCELED'; 
        $update->save(); 
       
        return redirect()->route('gen_risk.risk_notify',[
            'iduser'=> $iduser 
            ]);
    }

    public function risk_notify_recheck($idrisk , $iduser)
    {
        $inforecheck = DB::table('risk_recheck')
        ->leftJoin('hrd_person','hrd_person.ID','=','risk_recheck.RISK_RECHECK_PERSON')
        ->where('RISK_RECHECK_RISKID','=',$idrisk)->get();
        $inforpersonuser =  Person::where('ID',Auth()->user()->PERSON_ID)->first();
        $iduser          =  Auth()->user()->PERSON_ID;
        return view('general_risk.risk_notify_recheck',[
            'riskid' => $idrisk,
            'inforechecks'=> $inforecheck,
            'inforpersonuser' => $inforpersonuser,
            'iduser' => $iduser
         ]);
    }

    public function risk_notify_recheck_save(Request $request){
        $RECHECK_DATE= $request->RISK_RECHECK_DATE;
        if($RECHECK_DATE != ''){
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $RECHECK_DATE)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0]; 
            
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $RECHECKDATE= $y_st."-".$m_st."-".$d_st;
            }else{
            $RECHECKDATE= null;
        }
        $addrecheck = new Riskrecheck(); 
        $addrecheck->RISK_RECHECK_DATE_SAVE  = date('Y-m-d');
        $addrecheck->RISK_RECHECK_DATE = $RECHECKDATE;
        $addrecheck->RISK_RECHECK_RISKID = $request->RISK_RECHECK_RISKID;
        $addrecheck->RISK_RECHECK_HEAD = $request->RISK_RECHECK_HEAD;
        $addrecheck->RISK_RECHECK_DETAIL = $request->RISK_RECHECK_DETAIL;
        $addrecheck->RISK_RECHECK_TOTAL = $request->RISK_RECHECK_TOTAL;
        $addrecheck->RISK_RECHECK_PERSON = $request->RISK_RECHECK_PERSON;
        $maxid = Riskrecheck::max('RISK_RECHECK_ID');
        $idfile = $maxid+1;
        if($request->hasFile('pdfupload')){
            $newFileName = 'recheck_'.$idfile.'.'.$request->pdfupload->extension();
            $request->pdfupload->storeAs('riskpdf',$newFileName,'public');
            $addrecheck->RISK_RECHECK_FILE = 'True';
            $addrecheck->RISK_RECHECKE_NAME = $newFileName;
        }else{
            $addrecheck->RISK_RECHECK_FILE = '';
            $addrecheck->RISK_RECHECKE_NAME = '';
        }
        if($request->hasFile('fileupload')){
            $newFileName = 'recheck2_'.$idfile.'.'.$request->fileupload->extension();
            $request->fileupload->storeAs('riskpdf',$newFileName,'public');
            $addrecheck->RISK_RECHECK_FILE_2 = 'True';
            $addrecheck->RISK_RECHECK_NAME_2 = $newFileName;
            $addrecheck->RISK_RECHECK_NAME_OLD =  $request->file('fileupload')->getClientOriginalName();
        }else{
            $addrecheck->RISK_RECHECK_FILE_2 = '';
            $addrecheck->RISK_RECHECK_NAME_2 = '';
            $addrecheck->RISK_RECHECK_NAME_OLD =  '';
        }
        $addrecheck->save();
        return redirect(route('gen_risk.risk_notify_recheck',[$request->RISK_RECHECK_RISKID,$request->iduser]));
    }

    public function risk_notify_recheck_edit($idrisk_recheck,$iduser){
        $inforpersonuser =  Person::where('ID',Auth()->user()->PERSON_ID)->first();
        $iduser          =  Auth()->user()->PERSON_ID;
        $person          = Person::getPersonWork();
        $riskrecheck = Riskrecheck::where('RISK_RECHECK_ID',$idrisk_recheck)->first();
        return view('general_risk.risk_notify_recheck_edit',compact(
            'iduser',
            'inforpersonuser',
            'person',
            'riskrecheck'
        ));
    }

    public function risk_notify_recheck_update(Request $request){
        $RECHECK_DATE= $request->RISK_RECHECK_DATE;
        if($RECHECK_DATE != ''){
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $RECHECK_DATE)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0]; 
            
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $RECHECKDATE= $y_st."-".$m_st."-".$d_st;
            }else{
            $RECHECKDATE= null;
        }
        $addrecheck = Riskrecheck::find($request->RISK_RECHECK_ID); 
        $addrecheck->RISK_RECHECK_DATE = $RECHECKDATE;
        $addrecheck->RISK_RECHECK_RISKID = $request->RISK_RECHECK_RISKID;
        $addrecheck->RISK_RECHECK_HEAD = $request->RISK_RECHECK_HEAD;
        $addrecheck->RISK_RECHECK_DETAIL = $request->RISK_RECHECK_DETAIL;
        $addrecheck->RISK_RECHECK_TOTAL = $request->RISK_RECHECK_TOTAL;
        $addrecheck->RISK_RECHECK_PERSON = $request->RISK_RECHECK_PERSON;
        $maxid = Riskrecheck::max('RISK_RECHECK_ID');
        $idfile = $maxid+1;
        if($request->hasFile('pdfupload')){
            $newFileName = 'recheck_'.$idfile.'.'.$request->pdfupload->extension();
            $request->pdfupload->storeAs('riskpdf',$newFileName,'public');
            $addrecheck->RISK_RECHECK_FILE = 'True';
            $addrecheck->RISK_RECHECKE_NAME = $newFileName;
        }
        if($request->hasFile('fileupload')){
            $newFileName = 'recheck2_'.$idfile.'.'.$request->fileupload->extension();
            $request->fileupload->storeAs('riskpdf',$newFileName,'public');
            $addrecheck->RISK_RECHECK_FILE_2 = 'True';
            $addrecheck->RISK_RECHECK_NAME_2 = $newFileName;
            $addrecheck->RISK_RECHECK_NAME_OLD =  $request->file('fileupload')->getClientOriginalName();
        }
        $addrecheck->save();
        return redirect(route('gen_risk.risk_notify_recheck',[$request->RISK_RECHECK_RISKID,$request->iduser]));
    }

    public function risk_notify_recheck_add($idrisk,$iduser){
        $inforpersonuser =  Person::where('ID',Auth()->user()->PERSON_ID)->first();
        $iduser          =  Auth()->user()->PERSON_ID;
        $person          = Person::getPersonWork();
        $infodetailrisk = DB::table('risk_rep')->where('RISKREP_ID','=',$idrisk)->first();
        return view('general_risk.risk_notify_recheck_add',compact(
            'idrisk',
            'iduser',
            'inforpersonuser',
            'infodetailrisk',
            'person'
        ));
    }

    public function risk_notify_checkinfo(Request $request,$iduser)
    {
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

        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';
        // $status = '';
        $search = '';
        $year_id = $yearbudget;  

        $leader = DB::table('gleave_leader_person')->first();

        $rigrep = Riskrep::leftjoin('risk_setincidence_setting','risk_rep.RISKREP_TITLE','=','risk_setincidence_setting.INCIDENCE_SETTING_ID')
        ->leftjoin('risk_status','risk_rep.RISKREP_STATUS','=','risk_status.RISK_STATUS_NAME')
        ->leftJoin('risk_rep_level','risk_rep.RISKREP_LEVEL','=','risk_rep_level.RISK_REP_LEVEL_ID')
        ->leftjoin('risk_setupincidence_location','risk_rep.RISKREP_SEARCHLOCATE','=','risk_setupincidence_location.INCIDENCE_LOCATION_ID')
        ->leftjoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','risk_rep.RISKREP_DEPARTMENT_SUB')
        ->leftjoin('risk_setupincidence_tpyelocation','risk_setupincidence_tpyelocation.SETUP_TYPELOCATION_ID','=','risk_rep.RISKREP_TYPE')
        ->leftjoin('risk_setupincidence_grouplocation','risk_setupincidence_grouplocation.SETUP_GROUPLOCATION_ID','=','risk_rep.RISKREP_LOCAL')
        ->leftjoin('risk_setupincidence_sub','risk_setupincidence_sub.INCIDENCE_SUB_ID','=','risk_rep.RISKREP_SUBTITLE')
        ->leftjoin('hrd_sex','hrd_sex.SEX_ID','=','risk_rep.RISKREP_SEX')
        ->where('risk_rep.LEADER_PERSON_ID','=',$iduser)
        ->orderBy('RISKREP_ID','DESC')
        ->get();


        $location = DB::table('risk_setupincidence_location')->get();
        $setting = DB::table('risk_setincidence_setting')->get();

        $status = DB::table('risk_status')->get();
        $repeat = DB::table('risk_notify_repeat_sub')->where('STATUS_REPEAT','=','REPEAT')->count();
        $accept = DB::table('risk_notify_accept_sub')->where('STATUS_ACCEPT','=','ACCEPT')->count();

        return view('general_risk.risk_notify_checkinfo',[
            'inforpersonuserid' => $inforpersonuserid,
            'inforpersonuser' => $inforpersonuser,
            'rigreps'=>$rigrep,
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id,
            'repeat'=>$repeat,
            'accept'=>$accept,
            'statuss'=>$status,
        ]);
    }
    
    public function risk_notify_checkinfo_search(Request $request,$iduser)
    {
        $search = $request->get('search');
        $status = $request->STATUS_CODE;
        $datebigin = $request->get('DATE_BIGIN');
        $dateend = $request->get('DATE_END');
        $yearbudget = $request->BUDGET_YEAR; 
        
       
    
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
    
        if($status !== null){
            $rigrep = Riskrep::leftjoin('risk_setincidence_setting','risk_rep.RISKREP_TITLE','=','risk_setincidence_setting.INCIDENCE_SETTING_ID')
            ->leftjoin('risk_status','risk_rep.RISKREP_STATUS','=','risk_status.RISK_STATUS_NAME')
            ->leftJoin('risk_rep_level','risk_rep.RISKREP_LEVEL','=','risk_rep_level.RISK_REP_LEVEL_ID')
            ->leftjoin('risk_setupincidence_location','risk_rep.RISKREP_SEARCHLOCATE','=','risk_setupincidence_location.INCIDENCE_LOCATION_ID')
            ->leftjoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','risk_rep.RISKREP_DEPARTMENT_SUB')
            ->leftjoin('risk_setupincidence_tpyelocation','risk_setupincidence_tpyelocation.SETUP_TYPELOCATION_ID','=','risk_rep.RISKREP_TYPE')
            ->leftjoin('risk_setupincidence_grouplocation','risk_setupincidence_grouplocation.SETUP_GROUPLOCATION_ID','=','risk_rep.RISKREP_LOCAL')
            ->leftjoin('risk_setupincidence_sub','risk_setupincidence_sub.INCIDENCE_SUB_ID','=','risk_rep.RISKREP_SUBTITLE')
            ->leftjoin('hrd_sex','hrd_sex.SEX_ID','=','risk_rep.RISKREP_SEX')
            ->where('risk_rep.LEADER_PERSON_ID','=',$iduser)
            ->where('risk_rep.RISKREP_STATUS','=',$status)
            ->where(function($q) use ($search){
                $q->where('RISK_REP_LEVEL_NAME','like','%'.$search.'%');
                $q->orwhere('RISKREP_BASICMANAGE','like','%'.$search.'%');
                $q->orwhere('RISKREP_DETAILRISK','like','%'.$search.'%'); 
                $q->orwhere('RISK_STATUS_NAME_TH','like','%'.$search.'%');   
                $q->orwhere('INCIDENCE_LOCATION_NAME','like','%'.$search.'%');   
                $q->orwhere('RISKREP_NO','like','%'.$search.'%');   
            })
            ->WhereBetween('RISKREP_DATESAVE',[$from,$to]) 
            ->orderBy('RISKREP_ID','DESC')
            ->get();
             
    
        }else{
            $rigrep = Riskrep::leftjoin('risk_setincidence_setting','risk_rep.RISKREP_TITLE','=','risk_setincidence_setting.INCIDENCE_SETTING_ID')
            ->leftjoin('risk_status','risk_rep.RISKREP_STATUS','=','risk_status.RISK_STATUS_NAME')
            ->leftJoin('risk_rep_level','risk_rep.RISKREP_LEVEL','=','risk_rep_level.RISK_REP_LEVEL_ID')
            ->leftjoin('risk_setupincidence_location','risk_rep.RISKREP_SEARCHLOCATE','=','risk_setupincidence_location.INCIDENCE_LOCATION_ID')
            ->leftjoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','risk_rep.RISKREP_DEPARTMENT_SUB')
            ->leftjoin('risk_setupincidence_tpyelocation','risk_setupincidence_tpyelocation.SETUP_TYPELOCATION_ID','=','risk_rep.RISKREP_TYPE')
            ->leftjoin('risk_setupincidence_grouplocation','risk_setupincidence_grouplocation.SETUP_GROUPLOCATION_ID','=','risk_rep.RISKREP_LOCAL')
            ->leftjoin('risk_setupincidence_sub','risk_setupincidence_sub.INCIDENCE_SUB_ID','=','risk_rep.RISKREP_SUBTITLE')
            ->leftjoin('hrd_sex','hrd_sex.SEX_ID','=','risk_rep.RISKREP_SEX')
            ->where('risk_rep.LEADER_PERSON_ID','=',$iduser)
            ->where(function($q) use ($search){
                $q->where('RISK_REP_LEVEL_NAME','like','%'.$search.'%');
                $q->orwhere('RISKREP_BASICMANAGE','like','%'.$search.'%');
                $q->orwhere('RISKREP_DETAILRISK','like','%'.$search.'%'); 
                $q->orwhere('RISK_STATUS_NAME_TH','like','%'.$search.'%');   
                $q->orwhere('INCIDENCE_LOCATION_NAME','like','%'.$search.'%');   
                $q->orwhere('RISKREP_NO','like','%'.$search.'%');   
            })
            ->WhereBetween('RISKREP_DATESAVE',[$from,$to]) 
            ->orderBy('RISKREP_ID','DESC')
            ->get();
             
    
        }
    
      
           
            $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
    
            $displaydate_bigen = ($yearbudget-544).'-10-01';
            $displaydate_end = ($yearbudget-543).'-09-30';
          
            $year_id = $yearbudget;
                   
            $status_info = DB::table('risk_status')->get();
            $repeat = DB::table('risk_notify_repeat_sub')->where('STATUS_REPEAT','=','REPEAT')->count();
            $accept = DB::table('risk_notify_accept_sub')->where('STATUS_ACCEPT','=','ACCEPT')->count();
    
        $location = DB::table('risk_setupincidence_location')->get();
        $setting = DB::table('risk_setincidence_setting')->get();

    

        return view('general_risk.risk_notify_checkinfo',[
            'inforpersonuserid' => $inforpersonuserid,
            'inforpersonuser' => $inforpersonuser,
            'rigreps'=>$rigrep,
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id,
            'repeat'=>$repeat,
            'accept'=>$accept,
            'statuss'=>$status_info,
        ]);
    }

    public function risk_notify_checkinfo_recheck($idrisk , $iduser){
        $inforecheck = DB::table('risk_recheck')
        ->leftJoin('hrd_person','hrd_person.ID','=','risk_recheck.RISK_RECHECK_PERSON')
        ->where('RISK_RECHECK_RISKID','=',$idrisk)->get();
        $inforpersonuser =  Person::where('ID',Auth()->user()->PERSON_ID)->first();
        $iduser          =  Auth()->user()->PERSON_ID;

        return view('general_risk.risk_notify_checkinfo_recheck',[
            'riskid' => $idrisk,
            'inforechecks'=> $inforecheck,
            'inforpersonuser' => $inforpersonuser,
            'iduser' => $iduser
         ]);
    }

    public function risk_notify_checkinfo_recheck_edit($idrisk_recheck,$iduser){
        $inforpersonuser =  Person::where('ID',Auth()->user()->PERSON_ID)->first();
        $iduser          =  Auth()->user()->PERSON_ID;
        $person          = Person::getPersonWork();
        $riskrecheck = Riskrecheck::where('RISK_RECHECK_ID',$idrisk_recheck)->first();
        return view('general_risk.risk_notify_checkinfo_recheck_edit',compact(
            'iduser',
            'inforpersonuser',
            'person',
            'riskrecheck'
        ));
    }

    public function risk_notify_checkinfo_recheck_update(Request $request){
        $RECHECK_DATE= $request->RISK_RECHECK_DATE;
        if($RECHECK_DATE != ''){
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $RECHECK_DATE)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0]; 
            
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $RECHECKDATE= $y_st."-".$m_st."-".$d_st;
            }else{
            $RECHECKDATE= null;
        }
        $addrecheck = Riskrecheck::find($request->RISK_RECHECK_ID); 
        $addrecheck->RISK_RECHECK_DATE = $RECHECKDATE;
        $addrecheck->RISK_RECHECK_RISKID = $request->RISK_RECHECK_RISKID;
        $addrecheck->RISK_RECHECK_HEAD = $request->RISK_RECHECK_HEAD;
        $addrecheck->RISK_RECHECK_DETAIL = $request->RISK_RECHECK_DETAIL;
        $addrecheck->RISK_RECHECK_TOTAL = $request->RISK_RECHECK_TOTAL;
        $addrecheck->RISK_RECHECK_PERSON = $request->RISK_RECHECK_PERSON;
        $maxid = Riskrecheck::max('RISK_RECHECK_ID');
        $idfile = $maxid+1;
        if($request->hasFile('pdfupload')){
            $newFileName = 'recheck_'.$idfile.'.'.$request->pdfupload->extension();
            $request->pdfupload->storeAs('riskpdf',$newFileName,'public');
            $addrecheck->RISK_RECHECK_FILE = 'True';
            $addrecheck->RISK_RECHECKE_NAME = $newFileName;
        }
        if($request->hasFile('fileupload')){
            $newFileName = 'recheck2_'.$idfile.'.'.$request->fileupload->extension();
            $request->fileupload->storeAs('riskpdf',$newFileName,'public');
            $addrecheck->RISK_RECHECK_FILE_2 = 'True';
            $addrecheck->RISK_RECHECK_NAME_2 = $newFileName;
            $addrecheck->RISK_RECHECK_NAME_OLD =  $request->file('fileupload')->getClientOriginalName();
        }
        $addrecheck->save();
        return redirect(route('gen_risk.risk_notify_checkinfo_recheck',[$request->RISK_RECHECK_RISKID,$request->iduser]));
    }

    public function risk_notify_checkinfo_recheck_add($idrisk,$iduser){
        $inforpersonuser =  Person::where('ID',Auth()->user()->PERSON_ID)->first();
        $iduser          =  Auth()->user()->PERSON_ID;
        $person          = Person::getPersonWork();
        $infodetailrisk = DB::table('risk_rep')->where('RISKREP_ID','=',$idrisk)->first();
        return view('general_risk.risk_notify_checkinfo_recheck_add',compact(
            'idrisk',
            'iduser',
            'inforpersonuser',
            'infodetailrisk',
            'person'
        ));
    }

    public function risk_notify_checkinfo_recheck_save(Request $request){
        $RECHECK_DATE= $request->RISK_RECHECK_DATE;
        if($RECHECK_DATE != ''){
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $RECHECK_DATE)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0]; 
            
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $RECHECKDATE= $y_st."-".$m_st."-".$d_st;
            }else{
            $RECHECKDATE= null;
        }
        $addrecheck = new Riskrecheck(); 
        $addrecheck->RISK_RECHECK_DATE_SAVE  = date('Y-m-d');
        $addrecheck->RISK_RECHECK_DATE = $RECHECKDATE;
        $addrecheck->RISK_RECHECK_RISKID = $request->RISK_RECHECK_RISKID;
        $addrecheck->RISK_RECHECK_HEAD = $request->RISK_RECHECK_HEAD;
        $addrecheck->RISK_RECHECK_DETAIL = $request->RISK_RECHECK_DETAIL;
        $addrecheck->RISK_RECHECK_TOTAL = $request->RISK_RECHECK_TOTAL;
        $addrecheck->RISK_RECHECK_PERSON = $request->RISK_RECHECK_PERSON;
        $maxid = Riskrecheck::max('RISK_RECHECK_ID');
        $idfile = $maxid+1;
        if($request->hasFile('pdfupload')){
            $newFileName = 'recheck_'.$idfile.'.'.$request->pdfupload->extension();
            $request->pdfupload->storeAs('riskpdf',$newFileName,'public');
            $addrecheck->RISK_RECHECK_FILE = 'True';
            $addrecheck->RISK_RECHECKE_NAME = $newFileName;
        }else{
            $addrecheck->RISK_RECHECK_FILE = '';
            $addrecheck->RISK_RECHECKE_NAME = '';
        }
        if($request->hasFile('fileupload')){
            $newFileName = 'recheck2_'.$idfile.'.'.$request->fileupload->extension();
            $request->fileupload->storeAs('riskpdf',$newFileName,'public');
            $addrecheck->RISK_RECHECK_FILE_2 = 'True';
            $addrecheck->RISK_RECHECK_NAME_2 = $newFileName;
            $addrecheck->RISK_RECHECK_NAME_OLD =  $request->file('fileupload')->getClientOriginalName();
        }else{
            $addrecheck->RISK_RECHECK_FILE_2 = '';
            $addrecheck->RISK_RECHECK_NAME_2 = '';
            $addrecheck->RISK_RECHECK_NAME_OLD =  '';
        }
        $addrecheck->save();
        return redirect(route('gen_risk.risk_notify_checkinfo_recheck',[$request->RISK_RECHECK_RISKID,$request->iduser]));
    }



    public function risk_notify_check(Request $request,$id,$iduser)
    {
        $inforpersonuserid =  Person::where('ID','=',$iduser)->first();
        // $id = $inforpersonuserid->ID;

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

            $rigrep = DB::table('risk_rep')->where('RISKREP_ID','=',$id)->first();
            $infoper = DB::table('hrd_person')->get();
            // $departsub = DB::table('hrd_department_sub_sub')->get();
            $departsub = DB::table('hrd_department_sub_sub')->where('HR_DEPARTMENT_SUB_SUB_ID','=',$rigrep->RISKREP_DEPARTMENT_SUB)->get();
            // $departsub = DB::table('hrd_department_sub_sub')->where('HR_DEPARTMENT_SUB_SUB_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)->get();
            $riskcategory = DB::table('risk_setincidence_category')->get();
            $location = DB::table('risk_setupincidence_location')->get();
            $level = DB::table('risk_rep_level')->get();
            $setting = DB::table('risk_setincidence_setting')->get();
            $incidentsub = DB::table('risk_setupincidence_sub')->get();
            $typelocation = DB::table('risk_setupincidence_tpyelocation')->get();
            $sex = DB::table('hrd_sex')->get();
            $worktime = DB::table('risk_rep_time')->get();
            $effect = DB::table('risk_setupincidence_usereffect')->get();
            $uefect = DB::table('risk_setupincidence_usereffect')->get();

            $typelocationf = DB::table('risk_setupincidence_tpyelocation')->first();
            $grouplocation = DB::table('risk_rep_location')->where('SETUP_TYPELOCATION_ID','=',$typelocationf->SETUP_TYPELOCATION_ID)->get();

            $riskprogram  = DB::table('risk_rep_program')->get();
            $riskprogramsub  = DB::table('risk_rep_program_sub')->get();
            $riskprogramsubsub  = DB::table('risk_rep_program_subsub')->get();
            $risktypereason  = DB::table('risk_rep_typereason')->get();
            $risktypereasonsys  = DB::table('risk_rep_typereason_sys')->get();
            $item = DB::table('risk_rep_items')->get();
            $itemsub = DB::table('risk_rep_items_sub')->get();
            // $riskitem = Risk_rep_items::get();
            // $infoteam = Team::orderBy('HR_TEAM_ID', 'asc')->get();

            $leader =  DB::table('gleave_leader_person')
            ->leftJoin('gleave_leader','gleave_leader.LEADER_ID','=','gleave_leader_person.LEADER_ID')
            ->where('PERSON_ID','=',$iduser)
            ->get();


            $inforiskacc = DB::table('risk_account_detail')->get();

            $locationuse = DB::table('risk_setupincidence_origin')->get();

            $ueffect = DB::table('risk_rep_usereffect')->where('RISKREP_ID','=',$id)->get(); 
            $teamlist = Risk_rep_teamlist::where('RISKREP_ID','=',$id)->get(); 
            $rep_dep = Risk_rep_department::where('RISKREP_ID','=',$id)->get();
            $rep_dep_sub = Risk_rep_department_sub::where('RISKREP_ID','=',$id)->get();
            $rep_dep_subsub = Risk_rep_department_subsub::where('RISKREP_ID','=',$id)->get();
            $rep_infoper = Risk_rep_infoperson::where('RISKREP_ID','=',$id)->get();

            $department  =  DB::table('hrd_department')->get();
            $team =  DB::table('hrd_team')->get(); 
            $riskrepdep = DB::table('risk_rep_typedep')->get(); 
           


                //--------------------------  ฝ่าย/แผนก ------------------
                $infordepartmentsub  =  DB::table('hrd_department_sub')->get();  
                //-----------------   หน่วยงาน --------------------------
                $infordepartmentsubsub  =  DB::table('hrd_department_sub_sub')->get();
                $perinfo = DB::table('hrd_person')->where('ID','=',$iduser)->first();
      
                $inforecheck = DB::table('risk_recheck')
                ->leftJoin('hrd_person','hrd_person.ID','=','risk_recheck.RISK_RECHECK_PERSON')
                ->where('RISK_RECHECK_RISKID','=',$id)->get();
            

                $infolocation = DB::table('supplies_location')->get();
                $infolocationlevel = DB::table('supplies_location_level')->get();
                $infolocationlevelroom = DB::table('supplies_location_level_room')->get();
     
            
        return view('general_risk.risk_notify_check',[
            'inforiskaccs' => $inforiskacc,
            'inforechecks' => $inforecheck,
            'inforpersonuserid' => $inforpersonuserid,
            'inforpersonuser' => $inforpersonuser,
            'departsubs'=>$departsub,
            'rigreps'=>$rigrep,
            'effects'=>$effect,
            'riskcategorys'=>$riskcategory,
            'locations'=>$location,
            'levels'=>$level,
            'settings'=>$setting,
            'incidentsubs'=>$incidentsub,
            'typelocations'=>$typelocation,
            'sexs'=>$sex,
            'infopers'=>$infoper,
            'grouplocations'=>$grouplocation,
            'worktimes'=>$worktime,
            'leaders'=>$leader,
            'riskprograms'=>$riskprogram,
            'riskprogramsubs'=>$riskprogramsub,
            'riskprogramsubsubs'=>$riskprogramsubsub,
            'risktypereasons'=>$risktypereason,
            'risktypereasonsyss'=>$risktypereasonsys,
            'items'=>$item,
            'itemsubs'=>$itemsub,
            'uefects'=>$uefect,
            'locationuses'=>$locationuse,
            'ueffects'=>$ueffect,
            'teams'=>$team,
            'teamlists'=>$teamlist,
            'rep_deps'=>$rep_dep,
            'rep_dep_subs'=>$rep_dep_sub,
            'rep_dep_subsubs'=>$rep_dep_subsub,
            'rep_infopers'=>$rep_infoper,
            'infordepartmentsubs'=>$infordepartmentsub,
            'infordepartmentsubsubs'=>$infordepartmentsubsub,
            'departments'=>$department,
            'perinfo'=>$perinfo,
            'riskrepdeps'=>$riskrepdep,
            'infolocations' => $infolocation,
            'infolocationlevels' => $infolocationlevel,
            'infolocationlevelrooms' => $infolocationlevelroom, 

            ]);
    }
    public function risk_notify_check_update (Request $request)
    {
        $iduser = $request->USER_ID;
        $inforpersonuserid =  Person::where('ID','=',$iduser)->first();

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

        $savedate= $request->RISKREP_DATESAVE;
        if($savedate != ''){           
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $savedate)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0];             
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $save_date= $y_st."-".$m_st."-".$d_st;   
            }else{
            $save_date= null;
        }
        $repstart= $request->RISKREP_STARTDATE;
        if($repstart != ''){           
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $repstart)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0];             
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $start_date= $y_st."-".$m_st."-".$d_st;   
            }else{
            $start_date= null;
        }
        $checkdigget= $request->RISKREP_DIGDATE;
        if($checkdigget != ''){           
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $checkdigget)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0];             
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $dig_date= $y_st."-".$m_st."-".$d_st;   
            }else{
            $dig_date= null;
        }
          
        //UPDATE
        $id = $request->RISKREP_ID;
        $update =Riskrep::find($id);    
        $update->RISKREP_NO =  $request->RISKREP_NO;        
        $update->RISKREP_DATESAVE =  $save_date;
        $update->RISKREP_SEARCHLOCATE =  $request->RISKREP_SEARCHLOCATE;
        $update->RISKREP_DEPARTMENT_SUB = $request->RISKREP_DEPARTMENT_SUB;
        $update->RISKREP_TYPE =  $request->RISKREP_TYPE;   
        $update->RISKREP_USEREFFECT =  $request->RISKREP_USEREFFECT;      
        $update->RISKREP_DETAILRISK =  $request->RISKREP_DETAILRISK; 
        $update->RISKREP_BASICMANAGE =  $request->RISKREP_BASICMANAGE;

    // ความเห็นหัวหน้าหน่วยงาน     
        $update->RISKREP_STARTDATE =  $start_date; 
        $update->RISKREP_DIGDATE =  $dig_date; 
        $update->RISKREP_LOCAL =  $request->RISKREP_LOCAL;
        $update->RISK_REPPROGRAM_ID =  $request->RISK_REPPROGRAM_ID; 
        $update->RISK_REPPROGRAMSUB_ID =  $request->RISK_REPPROGRAMSUB_ID; 
        $update->RISK_REPPROGRAMSUBSUB_ID =  $request->RISK_REPPROGRAMSUBSUB_ID;   
        $update->RISK_REPTYPERESON_ID =  $request->RISK_REPTYPERESON_ID;    
        $update->RISK_REPTYPERESONSYS_ID =  $request->RISK_REPTYPERESONSYS_ID;  
        $update->RISKREP_FATE =  $request->RISKREP_FATE; 
        $update->RISKREP_TIME =  $request->RISKREP_TIME; 
        $update->RISKREP_LEVEL =  $request->RISKREP_LEVEL; 
        $update->RISK_REP_FEEDBACK =  $request->RISK_REP_FEEDBACK;
        $update->RISK_REP_EFFECT =  $request->RISK_REP_EFFECT;
        $update->RISKREP_SEX =  $request->RISKREP_SEX; 
        $update->RISKREP_AGE =  $request->RISKREP_AGE;  
        $update->RISKREP_ACC_ID =  $request->RISKREP_ACC_ID;
        $update->RISKREP_LOCALUSE =  $request->RISKREP_LOCALUSE;  


        $update->RISKREP_LOCATION_ID =  $request->RISKREP_LOCATION_ID; 
        $update->RISKREP_LOCATION_LEVEL =  $request->RISKREP_LOCATION_LEVEL; 
        $update->RISKREP_LOCATION_LEVEL_ROOM =  $request->RISKREP_LOCATION_LEVEL_ROOM;
        $update->RISKREP_LOCATION_OTHER =  $request->RISKREP_LOCATION_OTHER;
 
        $update->RISKREP_STATUS = 'CHECK'; 
        $update->save(); 


          //ผู้ได้รับผลกระทบ
          Risk_rep_usereffect::where('RISKREP_ID','=',$id)->delete(); 

          if($request->RISK_REPEFFECT_FULLNAME != '' || $request->RISK_REPEFFECT_FULLNAME != null){
              
          $RISK_REPEFFECT_FULLNAME = $request->RISK_REPEFFECT_FULLNAME;
          $RISK_REPEFFECT_AGE = $request->RISK_REPEFFECT_AGE;
          $RISK_REPEFFECT_SEX = $request->RISK_REPEFFECT_SEX;
          $RISK_REPEFFECT_HN = $request->RISK_REPEFFECT_HN;
          $RISK_REPEFFECT_DATEIN = $request->RISK_REPEFFECT_DATEIN;         
          $RISK_REPEFFECT_AN = $request->RISK_REPEFFECT_AN; 
          $RISK_REPEFFECT_DATEADMIN = $request->RISK_REPEFFECT_DATEADMIN;             
                              
          $number =count($RISK_REPEFFECT_FULLNAME);
          $count = 0;           
          for($count = 0; $count< $number; $count++)
          {           
              if($RISK_REPEFFECT_DATEIN[$count] != ''){
                  $DAY = Carbon::createFromFormat('d/m/Y',$RISK_REPEFFECT_DATEIN[$count])->format('Y-m-d');
                  $date_arrary_st=explode("-",$DAY);
                  $y_sub_st = $date_arrary_st[0];

                  if($y_sub_st >= 2500){
                      $y_st = $y_sub_st-543;
                  }else{
                      $y_st = $y_sub_st;
                  }
                  $m_st = $date_arrary_st[1];
                  $d_st = $date_arrary_st[2];
                  $DATEIN= $y_st."-".$m_st."-".$d_st;
                  }else{
                  $DATEIN= null;
              } 
              if($RISK_REPEFFECT_DATEADMIN[$count] != ''){
                  $DAY = Carbon::createFromFormat('d/m/Y',$RISK_REPEFFECT_DATEADMIN[$count])->format('Y-m-d');
                  $date_arrary_st=explode("-",$DAY);
                  $y_sub_st = $date_arrary_st[0];

                  if($y_sub_st >= 2500){
                      $y_st = $y_sub_st-543;
                  }else{
                      $y_st = $y_sub_st;
                  }
                  $m_st = $date_arrary_st[1];
                  $d_st = $date_arrary_st[2];
                  $DATADMIT= $y_st."-".$m_st."-".$d_st;
                  }else{
                  $DATADMIT= null;
              } 
          $add_sub = new Risk_rep_usereffect();
          $add_sub->RISKREP_ID = $id;  
          $add_sub->RISK_REPEFFECT_FULLNAME = $RISK_REPEFFECT_FULLNAME[$count];     
          $add_sub->RISK_REPEFFECT_AGE = $RISK_REPEFFECT_AGE[$count]; 
          $add_sub->RISK_REPEFFECT_SEX = $RISK_REPEFFECT_SEX[$count]; 
          $add_sub->RISK_REPEFFECT_HN = $RISK_REPEFFECT_HN[$count];   
          $add_sub->RISK_REPEFFECT_DATEIN = $DATEIN; 
          $add_sub->RISK_REPEFFECT_AN = $RISK_REPEFFECT_AN[$count]; 
          $add_sub->RISK_REPEFFECT_DATEADMIN = $DATADMIT;                         
          $add_sub->save(); 
          }
      }  
  //ทีมนำ
      Risk_rep_teamlist::where('RISKREP_ID','=',$id)->delete();
          if($request->RISK_REP_TEAMLIST_NAME != '' || $request->RISK_REP_TEAMLIST_NAME != null){                
          $RISK_REP_TEAMLIST_NAME = $request->RISK_REP_TEAMLIST_NAME;                       
                              
          $number =count($RISK_REP_TEAMLIST_NAME);
          $count = 0;           
          for($count = 0; $count< $number; $count++)
          {     
              $idteam = DB::table('hrd_team')->where('HR_TEAM_ID','=',$RISK_REP_TEAMLIST_NAME[$count])->first(); 
              $add_sub = new Risk_rep_teamlist();
              $add_sub->RISKREP_ID = $id;  
              $add_sub->RISK_REP_TEAMLIST_CODE = $idteam->HR_TEAM_NAME; 
              $add_sub->RISK_REP_TEAMLIST_NAME = $idteam->HR_TEAM_DETAIL;  
              $add_sub->save(); 
          }
      }  
  //กลุ่มงาน
      Risk_rep_department::where('RISKREP_ID','=',$id)->delete(); 
          if($request->RISK_REP_DEPARTMENT_ID != '' || $request->RISK_REP_DEPARTMENT_ID != null){                
          $RISK_REP_DEPARTMENT_ID = $request->RISK_REP_DEPARTMENT_ID;                       
                          
          $number =count($RISK_REP_DEPARTMENT_ID);
          $count = 0;           
          for($count = 0; $count< $number; $count++)
          {     
              $iddep = DB::table('hrd_department')->where('HR_DEPARTMENT_ID','=',$RISK_REP_DEPARTMENT_ID[$count])->first(); 
              $add_sub = new Risk_rep_department();
              $add_sub->RISKREP_ID = $id; 
              $add_sub->HR_DEPARTMENT_ID = $iddep->HR_DEPARTMENT_ID;  
              $add_sub->RISK_REP_DEPARTMENT_NAME = $iddep->HR_DEPARTMENT_NAME;  
              $add_sub->save(); 
          }
      }
  //แผนก/ฝ่าย
          Risk_rep_department_sub::where('RISKREP_ID','=',$id)->delete(); 
                  if($request->RISK_REP_DEPARTMENT_SUBID != '' || $request->RISK_REP_DEPARTMENT_SUBID != null){                
                  $RISK_REP_DEPARTMENT_SUBID = $request->RISK_REP_DEPARTMENT_SUBID;                       
                                  
                  $number =count($RISK_REP_DEPARTMENT_SUBID);
                  $count = 0;           
                  for($count = 0; $count< $number; $count++)
                  {     
                      $iddepsub = DB::table('hrd_department_sub')->where('HR_DEPARTMENT_SUB_ID','=',$RISK_REP_DEPARTMENT_SUBID[$count])->first(); 
                      $add_sub = new Risk_rep_department_sub();
                      $add_sub->RISKREP_ID = $id;  
                      $add_sub->HR_DEPARTMENT_SUB_ID = $iddepsub->HR_DEPARTMENT_SUB_ID; 
                      $add_sub->RISK_REP_DEPARTMENT_SUBNAME = $iddepsub->HR_DEPARTMENT_SUB_NAME;  
                      $add_sub->save(); 
                  }              
          }   
  //หน่วยงาน
      Risk_rep_department_subsub::where('RISKREP_ID','=',$id)->delete(); 
          if($request->RISK_REP_DEPARTMENT_SUBSUBID != '' || $request->RISK_REP_DEPARTMENT_SUBSUBID != null){                
          $RISK_REP_DEPARTMENT_SUBSUBID = $request->RISK_REP_DEPARTMENT_SUBSUBID;                       
                          
          $number =count($RISK_REP_DEPARTMENT_SUBSUBID);
          $count = 0;           
          for($count = 0; $count< $number; $count++)
          {     
              $iddepsubsub = DB::table('hrd_department_sub_sub')->where('HR_DEPARTMENT_SUB_SUB_ID','=',$RISK_REP_DEPARTMENT_SUBSUBID[$count])->first(); 
              $add_sub = new Risk_rep_department_subsub();
              $add_sub->RISKREP_ID = $id; 
              $add_sub->HR_DEPARTMENT_SUB_SUB_ID = $iddepsubsub->HR_DEPARTMENT_SUB_SUB_ID;  
              $add_sub->RISK_REP_DEPARTMENT_SUBSUBNAME = $iddepsubsub->HR_DEPARTMENT_SUB_SUB_NAME;  
              $add_sub->save(); 
          }
      }
  //บุคคล
      Risk_rep_infoperson::where('RISKREP_ID','=',$id)->delete(); 
          if($request->RISK_REP_PERSON_NAME != '' || $request->RISK_REP_PERSON_NAME != null){                
              $RISK_REP_PERSON_NAME = $request->RISK_REP_PERSON_NAME;                       
                              
              $number =count($RISK_REP_PERSON_NAME);
              $count = 0;           
              for($count = 0; $count< $number; $count++)
              {     
                  // $iddepsubsub = DB::table('hrd_department_sub_sub')->where('HR_DEPARTMENT_SUB_SUB_ID','=',$RISK_REP_DEPARTMENT_SUBSUBID[$count])->first(); 
                  $add_sub = new Risk_rep_infoperson();
                  $add_sub->RISKREP_ID = $id; 
                  // $add_sub->HR_DEPARTMENT_SUB_SUB_ID = $iddepsubsub->HR_DEPARTMENT_SUB_SUB_ID;  
                  $add_sub->RISK_REP_PERSON_NAME = $request->RISK_REP_PERSON_NAME[$count];  
                  $add_sub->save(); 
              }
      }



       
        return redirect()->route('gen_risk.risk_notify_checkinfo',[
            'iduser'=> $iduser 
            ]);
    }
    //======================== repeat ===============================================//

    public function risk_notify_repeat_u(Request $request,$id,$iduser)
    {
        $inforpersonuserid =  Person::where('ID','=',$iduser)->first();
        // $id = $inforpersonuserid->ID;
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
        $yearbudget = date("Y")+543;        }

        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';
        $status = '';
        $search = '';
        $year_id = $yearbudget;

        // $rigrep = Riskrep::leftjoin('risk_setincidence_setting','risk_rep.RISKREP_TITLE','=','risk_setincidence_setting.INCIDENCE_SETTING_ID')
        // ->get();
        $rigrep = Riskrep::where('RISKREP_ID','=',$id)->first();
        $notify_repeat = Risk_notify_repeat_sub::leftjoin('hrd_person','risk_notify_repeat_sub.NOTIFY_REPEAT_USER_SAVE','=','hrd_person.ID')  
            ->leftjoin('risk_rep','risk_notify_repeat_sub.RISKREP_ID','=','risk_rep.RISKREP_ID')
            ->leftjoin('risk_setincidence_setting','risk_rep.RISKREP_TITLE','=','risk_setincidence_setting.INCIDENCE_SETTING_ID')
            ->leftjoin('risk_setupincidence_grouplocation','risk_rep.RISKREP_LOCAL','=','risk_setupincidence_grouplocation.SETUP_GROUPLOCATION_ID')
            ->where('risk_notify_repeat_sub.RISKREP_ID','=',$id)->get();

        return view('general_risk.risk_notify_repeat_u',[
            'inforpersonuserid' => $inforpersonuserid,
            'inforpersonuser' => $inforpersonuser,
            'rigreps'=>$rigrep,
            'notify_repeats'=>$notify_repeat,
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id,
            ]);
    }
    public function risk_notify_repeat_sub_u(Request $request,$id,$iduser)
    {
        $inforpersonuserid =  Person::where('ID','=',$iduser)->first();
        // $id = $inforpersonuserid->ID;

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

        $rigrep = Riskrep::leftjoin('risk_setincidence_setting','risk_rep.RISKREP_TITLE','=','risk_setincidence_setting.INCIDENCE_SETTING_ID')
        ->leftjoin('risk_setupincidence_grouplocation','risk_rep.RISKREP_LOCAL','=','risk_setupincidence_grouplocation.SETUP_GROUPLOCATION_ID')
        ->where('RISKREP_ID','=',$id)->first();

       $notify_repeat = Risk_notify_repeat_sub::where('RISKREP_ID','=',$id)->get();       
      
       $infoper = DB::table('hrd_person')->get();

        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;        }

        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';
        $status = '';
        $search = '';
        $year_id = $yearbudget;

        // $rigrep = Riskrep::leftjoin('risk_setincidence_setting','risk_rep.RISKREP_TITLE','=','risk_setincidence_setting.INCIDENCE_SETTING_ID')
        // ->get();

        return view('general_risk.risk_notify_repeat_sub_u',[
            'inforpersonuserid' => $inforpersonuserid,
            'inforpersonuser' => $inforpersonuser,
             'infopers'=>$infoper,
            'rigreps'=>$rigrep,
            'notify_repeats'=> $notify_repeat,
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id,
            ]);
    }
    public function risk_notify_repeat_sub_u_save(Request $request)
    {
        $id_rig = $request->RISKREP_ID;
        $iduser = $request->PERSON;
       
        $inforpersonuserid =  Person::where('ID','=',$iduser)->first();

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

        $date_repeat = $request->get('NOTIFY_REPEAT_DATE');      
        $date_bigen_c = Carbon::createFromFormat('d/m/Y', $date_repeat)->format('Y-m-d');
        $date_arrary=explode("-",$date_bigen_c);
    
        $y_sub_st = $date_arrary[0];
    
        if($y_sub_st >= 2500){
            $y = $y_sub_st-543;
        }else{
            $y = $y_sub_st;
        }    
        $m = $date_arrary[1];
        $d = $date_arrary[2];  
        $displaydate_repeat= $y."-".$m."-".$d;   
           
        $date = date('Y-m-d');
        $date_bigen_checks = strtotime($displaydate_repeat);       
        $dates =  strtotime($date);    
        $date_rep = date($displaydate_repeat);

        $update = Riskrep::find($id_rig);
        $update->RISKREP_STATUS = 'REPEAT';
        $update->STATUS_REPEAT = 'REPEAT';
        $update->save();


        $request->validate([              
            $date_rep => 'date_format:m/d/Y' 
        ]);



        $add = new Risk_notify_repeat_sub();  
            $add->NOTIFY_REPEAT_NO = $request->NOTIFY_REPEAT_NO;
            $add->NOTIFY_REPEAT_DATE = $date_rep;
            $add->NOTIFY_REPEAT_DETAIL = $request->NOTIFY_REPEAT_DETAIL;
            $add->NOTIFY_REPEAT_USER_SAVE = $iduser;
            $add->RISKREP_ID = $id_rig;
            $add->STATUS_REPEAT = 'REPEAT';
        $add->save();

        $id_repeat_sub =  Risk_notify_repeat_sub::max('NOTIFY_REPEAT_ID');

        if($request->INFER_REPEAT_DETAIL != '' || $request->INFER_REPEAT_DETAIL != null){
            $INFER_REPEAT_DETAIL = $request->INFER_REPEAT_DETAIL;           

            $number =count($INFER_REPEAT_DETAIL);
            $count = 0;
            for($count = 0; $count< $number; $count++)
            {            
                $add_infer_repeat = new Risk_notify_repeat_sub_infer();
                $add_infer_repeat->NOTIFY_REPEAT_ID = $id_repeat_sub;
                $add_infer_repeat->INFER_REPEAT_DETAIL = $INFER_REPEAT_DETAIL[$count];
                $add_infer_repeat->save();
            }
        }


        if($request->LIST_INFER_DETAIL != '' || $request->LIST_INFER_DETAIL != null){
            $LIST_INFER_DETAIL = $request->LIST_INFER_DETAIL;           

            $number =count($LIST_INFER_DETAIL);
            $count = 0;
            for($count = 0; $count< $number; $count++)
            {            
                $add_infer_list = new Risk_notify_repeat_sub_inferlist();
                $add_infer_list->NOTIFY_REPEAT_ID = $id_repeat_sub;
                $add_infer_list->LIST_INFER_DETAIL = $LIST_INFER_DETAIL[$count];
                $add_infer_list->save();
            }
        }

      
        
        if($request->BOARD_ID != '' || $request->BOARD_ID != null){
            $BOARD_ID = $request->BOARD_ID;           

            // dd($BOARD_ID); 

            $number =count($BOARD_ID);
            $count = 0;
            for($count = 0; $count< $number; $count++)
            {   

                $user_info = DB::table('hrd_person')->where('ID','=',$BOARD_ID[$count])->first();

              
                $add_board = new Risk_notify_repeat_sub_board();
                $add_board->NOTIFY_REPEAT_ID = $id_repeat_sub;
                $add_board->BOARD_PER_ID = $BOARD_ID[$count];
                $add_board->BOARD_FNAME = $user_info->HR_FNAME;
                $add_board->BOARD_LNAME = $user_info->HR_LNAME;
                $add_board->save();
            }
        }

       
        
        if($request->BOARD_OUT_FNAME != '' || $request->BOARD_OUT_FNAME != null){
            $BOARD_OUT_FNAME = $request->BOARD_OUT_FNAME;    
            $BOARD_OUT_LNAME = $request->BOARD_OUT_LNAME;        

            $number =count($BOARD_OUT_FNAME);
            $count = 0;
            for($count = 0; $count< $number; $count++)
            {     
                // $id_user = Person::where('ID','=',)->first();    
                $add_board_out = new Risk_notify_repeat_sub_board_out();
                $add_board_out->NOTIFY_REPEAT_ID = $id_repeat_sub;
                $add_board_out->BOARD_OUT_FNAME = $BOARD_OUT_FNAME[$count];
                $add_board_out->BOARD_OUT_LNAME = $BOARD_OUT_LNAME[$count];
                $add_board_out->save();
            }
        }


        if($request->TOPIC_REPEAT_HEAD != '' || $request->TOPIC_REPEAT_HEAD != null){
            $TOPIC_REPEAT_HEAD = $request->TOPIC_REPEAT_HEAD;   
            $TOPIC_REPEAT_DETAIL = $request->TOPIC_REPEAT_DETAIL;  
          
            $number =count($TOPIC_REPEAT_HEAD);
            $count = 0;
            for($count = 0; $count< $number; $count++)
            {         
                $add_topic = new Risk_notify_repeat_sub_topic_infer();
                $add_topic->NOTIFY_REPEAT_ID = $id_repeat_sub;
                $add_topic->TOPIC_REPEAT_HEAD = $TOPIC_REPEAT_HEAD[$count];   
                $add_topic->TOPIC_REPEAT_DETAIL = $TOPIC_REPEAT_DETAIL[$count];             
                $add_topic->save();
            }
        }

      
      

        return redirect()->route('gen_risk.risk_notify_detail',[
            'id'=> $id_rig ,
            'iduser'=> $iduser 
        ]);
    }
    public function risk_notify_repeat_sub_u_edit(Request $request,$id,$iduser,$idrig)
    {
        $inforpersonuserid =  Person::where('ID','=',$iduser)->first();
        // $id = $inforpersonuserid->ID;

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
        $yearbudget = date("Y")+543;        }

        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';
        $status = '';
        $search = '';
        $year_id = $yearbudget;

        $rigrep = Riskrep::leftjoin('risk_setincidence_setting','risk_rep.RISKREP_TITLE','=','risk_setincidence_setting.INCIDENCE_SETTING_ID')
        ->leftjoin('risk_setupincidence_grouplocation','risk_rep.RISKREP_LOCAL','=','risk_setupincidence_grouplocation.SETUP_GROUPLOCATION_ID')
        ->where('RISKREP_ID','=',$idrig)->first();

       $notify_repeat = Risk_notify_repeat_sub::where('NOTIFY_REPEAT_ID','=',$id)->first();
        
       $infer_repeat = DB::table('risk_notify_repeat_sub_infer')->where('NOTIFY_REPEAT_ID','=',$id)->get();
       $infer_list_repeat = DB::table('risk_notify_repeat_sub_inferlist')->where('NOTIFY_REPEAT_ID','=',$id)->get();
       $board_repeat = DB::table('risk_notify_repeat_sub_board')->where('NOTIFY_REPEAT_ID','=',$id)->get();
       $board_out_repeat = DB::table('risk_notify_repeat_sub_board_out')->where('NOTIFY_REPEAT_ID','=',$id)->get();
       $topic_repeat = DB::table('risk_notify_repeat_sub_topic_infer')->where('NOTIFY_REPEAT_ID','=',$id)->get();

       $infoper = DB::table('hrd_person')->get();
        
        return view('general_risk.risk_notify_repeat_sub_u_edit',[
            'inforpersonuserid' => $inforpersonuserid,
            'inforpersonuser' => $inforpersonuser,
            'infopers'=>$infoper,
            'rigreps'=>$rigrep,

            'notify_repeats'=> $notify_repeat,
            'infer_repeats'=> $infer_repeat,
            'infer_list_repeats'=> $infer_list_repeat,
            'board_repeats'=> $board_repeat,
            'board_out_repeats'=> $board_out_repeat,
            'topic_repeats'=> $topic_repeat,

            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id,
            ]);
    }
    public function risk_notify_repeat_sub_u_update(Request $request)
    {
        
        $id_rig = $request->RISKREP_ID;       
        $iduser = $request->PERSON;

        
        $inforpersonuserid =  Person::where('ID','=',$iduser)->first();
        // $id = $inforpersonuserid->ID;

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
     
        $date_repeat = $request->get('NOTIFY_REPEAT_DATE');      
        $date_bigen_c = Carbon::createFromFormat('d/m/Y', $date_repeat)->format('Y-m-d');
        $date_arrary=explode("-",$date_bigen_c);
    
        $y_sub_st = $date_arrary[0];
    
        if($y_sub_st >= 2500){
            $y = $y_sub_st-543;
        }else{
            $y = $y_sub_st;
        }    
        $m = $date_arrary[1];
        $d = $date_arrary[2];  
        $displaydate_repeat= $y."-".$m."-".$d;   
           
        $date = date('Y-m-d');
        $date_bigen_checks = strtotime($displaydate_repeat);       
        $dates =  strtotime($date);    
        $date_rep = date($displaydate_repeat);
     
        $id_repeat_sub = $request->NOTIFY_REPEAT_ID;

        $update = Risk_notify_repeat_sub::find($id_repeat_sub);  
        $update->NOTIFY_REPEAT_NO = $request->NOTIFY_REPEAT_NO;
        $update->NOTIFY_REPEAT_DATE = $date_rep;       
        $update->NOTIFY_REPEAT_DETAIL = $request->NOTIFY_REPEAT_DETAIL;
        $update->NOTIFY_REPEAT_USER_SAVE =$iduser;
        $update->RISKREP_ID = $id_rig;
        $update->save();

        
        Risk_notify_repeat_sub_infer::where('NOTIFY_REPEAT_ID','=',$id_repeat_sub)->delete();

        if($request->INFER_REPEAT_DETAIL != '' || $request->INFER_REPEAT_DETAIL != null){
            $INFER_REPEAT_DETAIL = $request->INFER_REPEAT_DETAIL;           

            $number =count($INFER_REPEAT_DETAIL);
            $count = 0;
            for($count = 0; $count< $number; $count++)
            {            
                $up_infer_repeat = new Risk_notify_repeat_sub_infer();
                $up_infer_repeat->NOTIFY_REPEAT_ID = $id_repeat_sub;
                $up_infer_repeat->INFER_REPEAT_DETAIL = $INFER_REPEAT_DETAIL[$count];
                $up_infer_repeat->save();
            }
        }

        Risk_notify_repeat_sub_inferlist::where('NOTIFY_REPEAT_ID','=',$id_repeat_sub)->delete();

        if($request->LIST_INFER_DETAIL != '' || $request->LIST_INFER_DETAIL != null){
            $LIST_INFER_DETAIL = $request->LIST_INFER_DETAIL;           

            $number =count($LIST_INFER_DETAIL);
            $count = 0;
            for($count = 0; $count< $number; $count++)
            {            
                $up_infer_list = new Risk_notify_repeat_sub_inferlist();
                $up_infer_list->NOTIFY_REPEAT_ID = $id_repeat_sub;
                $up_infer_list->LIST_INFER_DETAIL = $LIST_INFER_DETAIL[$count];
                $up_infer_list->save();
            }
        }

        Risk_notify_repeat_sub_board::where('NOTIFY_REPEAT_ID','=',$id_repeat_sub)->delete();
        
        if($request->BOARD_ID != '' || $request->BOARD_ID != null){
            $BOARD_ID = $request->BOARD_ID;           

            $number =count($BOARD_ID);
            $count = 0;
            for($count = 0; $count< $number; $count++)
            {            
                $user_info = DB::table('hrd_person')->where('ID','=',$BOARD_ID[$count])->first();

                $up_board = new Risk_notify_repeat_sub_board();
                $up_board->NOTIFY_REPEAT_ID = $id_repeat_sub;
                $up_board->BOARD_PER_ID = $BOARD_ID[$count];
                $up_board->BOARD_FNAME = $user_info->HR_FNAME;
                $up_board->BOARD_LNAME = $user_info->HR_LNAME;
                $up_board->save();
            }
        }

        Risk_notify_repeat_sub_board_out::where('NOTIFY_REPEAT_ID','=',$id_repeat_sub)->delete();
        
        if($request->BOARD_OUT_FNAME != '' || $request->BOARD_OUT_FNAME != null){
            $BOARD_OUT_FNAME = $request->BOARD_OUT_FNAME;    
            $BOARD_OUT_LNAME = $request->BOARD_OUT_LNAME;        

            $number =count($BOARD_OUT_FNAME);
            $count = 0;
            for($count = 0; $count< $number; $count++)
            {         
                $up_board_out = new Risk_notify_repeat_sub_board_out();
                $up_board_out->NOTIFY_REPEAT_ID = $id_repeat_sub;
                $up_board_out->BOARD_OUT_FNAME = $BOARD_OUT_FNAME[$count];
                $up_board_out->BOARD_OUT_LNAME = $BOARD_OUT_LNAME[$count];
                $up_board_out->save();
            }
        }

        Risk_notify_repeat_sub_topic_infer::where('NOTIFY_REPEAT_ID','=',$id_repeat_sub)->delete();

        if($request->TOPIC_REPEAT_HEAD != '' || $request->TOPIC_REPEAT_HEAD != null){
            $TOPIC_REPEAT_HEAD = $request->TOPIC_REPEAT_HEAD;   
            $TOPIC_REPEAT_DETAIL = $request->TOPIC_REPEAT_DETAIL;  
          
            $number =count($TOPIC_REPEAT_HEAD);
            $count = 0;
            for($count = 0; $count< $number; $count++)
            {         
                $up_topic = new Risk_notify_repeat_sub_topic_infer();
                $up_topic->NOTIFY_REPEAT_ID = $id_repeat_sub;
                $up_topic->TOPIC_REPEAT_HEAD = $TOPIC_REPEAT_HEAD[$count];   
                $up_topic->TOPIC_REPEAT_DETAIL = $TOPIC_REPEAT_DETAIL[$count];             
                $up_topic->save();
            }
        }
       
        return redirect()->route('gen_risk.risk_notify_detail',[
            'id'=> $id_rig ,
            'iduser'=> $iduser 
        ]);
    }

 public function risk_notify_repeat_sub_u_destroy(Request $request,$id,$iduser,$idrig)
    {
        Risk_notify_repeat_sub::destroy($id);
        Risk_notify_repeat_sub_infer::where('NOTIFY_REPEAT_ID',$id)->delete();
        Risk_notify_repeat_sub_inferlist::where('NOTIFY_REPEAT_ID',$id)->delete();
        Risk_notify_repeat_sub_board::where('NOTIFY_REPEAT_ID',$id)->delete();
        Risk_notify_repeat_sub_board_out::where('NOTIFY_REPEAT_ID',$id)->delete();
        Risk_notify_repeat_sub_topic_infer::where('NOTIFY_REPEAT_ID',$id)->delete();

        $update = Riskrep::find($idrig);
        $update->RISKREP_STATUS = 'CONFIRM';
        // $update->STATUS_REPEAT = 'REPEAT';
        $update->save();

        return redirect()->route('gen_risk.risk_notify_detail',[
            'id'=> $idrig,
            'iduser'=> $iduser 
         ]);
    }


//===========================================================================//
    public function risk_notify_accept_u(Request $request,$id,$iduser)
    {
        $inforpersonuserid =  Person::where('ID','=',$iduser)->first();
      
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
        $yearbudget = date("Y")+543;        }

        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';
        $status = '';
        $search = '';
        $year_id = $yearbudget;

      
        $rigrep = Riskrep::leftjoin('risk_setincidence_setting','risk_rep.RISKREP_TITLE','=','risk_setincidence_setting.INCIDENCE_SETTING_ID')
        ->leftjoin('risk_setupincidence_grouplocation','risk_rep.RISKREP_LOCAL','=','risk_setupincidence_grouplocation.SETUP_GROUPLOCATION_ID')
        ->where('RISKREP_ID','=',$id)->first();

       $notify_accept = Risk_notify_accept_sub::leftjoin('hrd_person','risk_notify_accept_sub.NOTIFY_ACCEPT_USER_SAVE','=','hrd_person.ID')
        ->where('RISKREP_ID','=',$id)->get();

       $infoper = DB::table('hrd_person')->get();

        return view('general_risk.risk_notify_accept_u',[
            'inforpersonuserid' => $inforpersonuserid,
            'inforpersonuser' => $inforpersonuser,
            'rigreps'=>$rigrep,
            'notify_accepts'=> $notify_accept,
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id,
            ]);
    }
    public function risk_notify_accept_sub_u(Request $request,$id,$iduser)
    {
        $inforpersonuserid =  Person::where('ID','=',$iduser)->first();
        // $id = $inforpersonuserid->ID;

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
        $yearbudget = date("Y")+543;        }

        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';
        $status = '';
        $search = '';
        $year_id = $yearbudget;

        $rigrep = Riskrep::leftjoin('risk_setincidence_setting','risk_rep.RISKREP_TITLE','=','risk_setincidence_setting.INCIDENCE_SETTING_ID')
        ->leftjoin('risk_setupincidence_grouplocation','risk_rep.RISKREP_LOCAL','=','risk_setupincidence_grouplocation.SETUP_GROUPLOCATION_ID')
        ->where('RISKREP_ID','=',$id)->first();

       $notify_accept = risk_notify_accept_sub::where('NOTIFY_ACCEPT_ID','=',$id)->get(); 
       $infoper = DB::table('hrd_person')->get(); 

        return view('general_risk.risk_notify_accept_sub_u',[
            'inforpersonuserid' => $inforpersonuserid,
            'inforpersonuser' => $inforpersonuser,
            'rigreps'=>$rigrep,
            'infopers'=>$infoper,
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id,
            ]);
    }

    public function risk_notify_accept_sub_u_save(Request $request)
    {
       
        $id_rig = $request->RISKREP_ID;
        $iduser = $request->PERSON;
       
        $update = Riskrep::find($id_rig);
        $update->RISKREP_STATUS = 'SUCCESS';
        $update->save();

        $inforpersonuserid =  Person::where('ID','=',$iduser)->first();
        // $id = $inforpersonuserid->ID;

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
        $date_repeat = $request->get('NOTIFY_ACCEPT_DATE');      
        $date_bigen_c = Carbon::createFromFormat('d/m/Y', $date_repeat)->format('Y-m-d');
        $date_arrary=explode("-",$date_bigen_c);
    
        $y_sub_st = $date_arrary[0];
    
        if($y_sub_st >= 2500){
            $y = $y_sub_st-543;
        }else{
            $y = $y_sub_st;
        }
    
        $m = $date_arrary[1];
        $d = $date_arrary[2];  
        $displaydate_repeat= $y."-".$m."-".$d;   
           
        $date = date('Y-m-d');
        $date_bigen_checks = strtotime($displaydate_repeat);
       
        $dates =  strtotime($date);    
        $date_rep = date($displaydate_repeat);        

        $add = new Risk_notify_accept_sub();  
        $add->NOTIFY_ACCEPT_NO = $request->NOTIFY_ACCEPT_NO;
        $add->NOTIFY_ACCEPT_DATE = $date_rep;
        $add->NOTIFY_ACCEPT_ABOUT = $request->NOTIFY_ACCEPT_ABOUT;
        $add->NOTIFY_ACCEPT_DETAIL = $request->NOTIFY_ACCEPT_DETAIL;
        $add->NOTIFY_ACCEPT_USER_SAVE =$request->NOTIFY_ACCEPT_USER_SAVE;
        $add->RISKREP_ID = $id_rig;
        $add->STATUS_ACCEPT = 'ACCEPT';
        $add->save();
       
        return redirect()->route('gen_risk.risk_notify_accept_u',[
            'id'=> $id_rig ,
            'iduser'=> $iduser 
        ]);
    }

    public function risk_notify_accept_sub_u_edit(Request $request,$id,$iduser,$idrig)
    {
        $inforpersonuserid =  Person::where('ID','=',$iduser)->first();

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

         $rigrep = Riskrep::leftjoin('risk_setincidence_setting','risk_rep.RISKREP_TITLE','=','risk_setincidence_setting.INCIDENCE_SETTING_ID')
         ->leftjoin('risk_setupincidence_grouplocation','risk_rep.RISKREP_LOCAL','=','risk_setupincidence_grouplocation.SETUP_GROUPLOCATION_ID')
         ->where('RISKREP_ID','=',$idrig)->first();

        $notify_accept = Risk_notify_accept_sub::where('NOTIFY_ACCEPT_ID','=',$id)->first();

        $infoper = DB::table('hrd_person')->get();


        return view('general_risk.risk_notify_accept_sub_u_edit',[
            'infopers'=>$infoper,
            'rigreps'=>$rigrep,
            'notify_accepts'=> $notify_accept,
            'inforpersonuserid' => $inforpersonuserid,
            'inforpersonuser' => $inforpersonuser,
        ]);
    }

    public function risk_notify_accept_sub_u_update(Request $request)
    {
       
        $id_rig = $request->RISKREP_ID;             
        $iduser = $request->PERSON;

        $update = Riskrep::find($id_rig);
        $update->RISKREP_STATUS = 'SUCCESS';
        $update->save();

        $inforpersonuserid =  Person::where('ID','=',$iduser)->first();
        // $id = $inforpersonuserid->ID;

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
     
        $id_repeat_sub = $request->NOTIFY_ACCEPT_ID;

        $date_repeat = $request->get('NOTIFY_ACCEPT_DATE');      
        $date_bigen_c = Carbon::createFromFormat('d/m/Y', $date_repeat)->format('Y-m-d');
        $date_arrary=explode("-",$date_bigen_c);
    
        $y_sub_st = $date_arrary[0];
    
        if($y_sub_st >= 2500){
            $y = $y_sub_st-543;
        }else{
            $y = $y_sub_st;
        }    
        $m = $date_arrary[1];
        $d = $date_arrary[2];  
        $displaydate_repeat= $y."-".$m."-".$d;
               
        $date = date('Y-m-d');
        $date_bigen_checks = strtotime($displaydate_repeat);
       
        $dates =  strtotime($date);
    
        $date_rep = date($displaydate_repeat);           
     
        $update = Risk_notify_accept_sub::find($id_repeat_sub);  
        $update->NOTIFY_ACCEPT_NO = $request->NOTIFY_ACCEPT_NO;
        $update->NOTIFY_ACCEPT_DATE = $date_rep;
        $update->NOTIFY_ACCEPT_ABOUT = $request->NOTIFY_ACCEPT_ABOUT;
        $update->NOTIFY_ACCEPT_DETAIL = $request->NOTIFY_ACCEPT_DETAIL;
        $update->NOTIFY_ACCEPT_USER_SAVE =$request->NOTIFY_ACCEPT_USER_SAVE;
        $update->RISKREP_ID = $id_rig;
        $update->save();
       
        return redirect()->route('gen_risk.risk_notify_accept_u',[
            'id'=> $id_rig ,
            'iduser'=> $iduser 
        ]);
    }

    public function risk_notify_accept_sub_u_destroy(Request $request,$id,$iduser,$idrig)
    {
        Risk_notify_accept_sub::destroy($id);  

        return redirect()->route('gen_risk.risk_notify_accept_u',[
            'id'=> $idrig,
            'iduser'=> $iduser 
         ]);

    }


//===========================================================================//

    public function risk_refteam(Request $request,$iduser)
    {
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
        $yearbudget = date("Y")+543;        }

        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';
        $status = '';
        $search = '';
        $year_id = $yearbudget;

        $rigrep = Riskrep::leftjoin('risk_setincidence_setting','risk_rep.RISKREP_TITLE','=','risk_setincidence_setting.INCIDENCE_SETTING_ID')
        ->orderBy('RISKREP_ID','DESC')
        ->get();

        $status = DB::table('risk_status')->get();
        $repeat = DB::table('risk_notify_repeat_sub')->where('STATUS_REPEAT','=','REPEAT')->count();
        $accept = DB::table('risk_notify_accept_sub')->where('STATUS_ACCEPT','=','ACCEPT')->count();

        return view('general_risk.risk_refteam',[
            'inforpersonuserid' => $inforpersonuserid,
            'inforpersonuser' => $inforpersonuser,
            'rigreps'=>$rigrep,
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id,
            'repeat'=>$repeat,
            'accept'=>$accept,
            'statuss'=>$status,
            ]);

    }
    public function risk_refteam_search(Request $request,$iduser)
    { 
        $search = $request->get('search');
        $status = $request->SEND_STATUS;
        $datebigin = $request->get('DATE_BIGIN');
        $dateend = $request->get('DATE_END');
        
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
           
            $rigrep = DB::table('risk_rep')
                  ->leftjoin('risk_setincidence_setting','risk_rep.RISKREP_TITLE','=','risk_setincidence_setting.INCIDENCE_SETTING_ID')
                  ->where(function($q) use ($search){
                $q->where('INCIDENCE_SETTING_NAME','like','%'.$search.'%');
                $q->orwhere('RISKREP_DETAILRISK','like','%'.$search.'%');
                                
            })
            ->WhereBetween('RISKREP_DATESAVE',[$from,$to]) 
            ->orderBy('RISKREP_ID', 'desc')->get();    
           
           
            $m_budget = date("m");
            if($m_budget>9){
            $yearbudget = date("Y")+544;
            }else{
            $yearbudget = date("Y")+543;        }
    
            $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
    
            $displaydate_bigen = ($yearbudget-544).'-10-01';
            $displaydate_end = ($yearbudget-543).'-09-30';
          
            $year_id = $yearbudget;
                   
            $status = DB::table('risk_status')->get();
            $repeat = DB::table('risk_notify_repeat_sub')->where('STATUS_REPEAT','=','REPEAT')->count();
            $accept = DB::table('risk_notify_accept_sub')->where('STATUS_ACCEPT','=','ACCEPT')->count();

        return view('general_risk.risk_refteam',[   
            'inforpersonuserid' => $inforpersonuserid,
            'inforpersonuser' => $inforpersonuser,        
            'rigreps'=>$rigrep,
            'status_check'=> $status,
            'search'=> $search,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,  
            'budgets' =>  $budget,
            'year_id'=>$year_id,  
            'repeat'=>$repeat,
            'accept'=>$accept,
            'statuss'=>$status,
        ]);
    }

    //===========================================================================================================//

    public function risk_refdep(Request $request,$iduser)
    {
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
        $yearbudget = date("Y")+543;        }

        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';
        $status = '';
        $search = '';
        $year_id = $yearbudget;

        $rigrep = Riskrep::leftjoin('risk_setincidence_setting','risk_rep.RISKREP_TITLE','=','risk_setincidence_setting.INCIDENCE_SETTING_ID')
        ->orderBy('RISKREP_ID','DESC')
        ->get();

        $status = DB::table('risk_status')->get();
        $repeat = DB::table('risk_notify_repeat_sub')->where('STATUS_REPEAT','=','REPEAT')->count();
        $accept = DB::table('risk_notify_accept_sub')->where('STATUS_ACCEPT','=','ACCEPT')->count();

        return view('general_risk.risk_refdep',[
            'inforpersonuserid' => $inforpersonuserid,
            'inforpersonuser' => $inforpersonuser,
            'rigreps'=>$rigrep,
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id,
            'repeat'=>$repeat,
            'accept'=>$accept,
            'statuss'=>$status,
            ]);
    }
    public function risk_refdep_search(Request $request,$iduser)
    { 
        $search = $request->get('search');
        $status = $request->SEND_STATUS;
        $datebigin = $request->get('DATE_BIGIN');
        $dateend = $request->get('DATE_END');
        
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
           
            $rigrep = DB::table('risk_rep')
                  ->leftjoin('risk_setincidence_setting','risk_rep.RISKREP_TITLE','=','risk_setincidence_setting.INCIDENCE_SETTING_ID')
                  ->where(function($q) use ($search){
                $q->where('INCIDENCE_SETTING_NAME','like','%'.$search.'%');
                $q->orwhere('RISKREP_DETAILRISK','like','%'.$search.'%');
                                
            })
            ->WhereBetween('RISKREP_DATESAVE',[$from,$to]) 
            ->orderBy('RISKREP_ID', 'desc')->get();    
           
           
            $m_budget = date("m");
            if($m_budget>9){
            $yearbudget = date("Y")+544;
            }else{
            $yearbudget = date("Y")+543;        }
    
            $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
    
            $displaydate_bigen = ($yearbudget-544).'-10-01';
            $displaydate_end = ($yearbudget-543).'-09-30';
          
            $year_id = $yearbudget;
                   
            $status = DB::table('risk_status')->get();
            $repeat = DB::table('risk_notify_repeat_sub')->where('STATUS_REPEAT','=','REPEAT')->count();
            $accept = DB::table('risk_notify_accept_sub')->where('STATUS_ACCEPT','=','ACCEPT')->count();

        return view('general_risk.risk_refdep',[   
            'inforpersonuserid' => $inforpersonuserid,
            'inforpersonuser' => $inforpersonuser,        
            'rigreps'=>$rigrep,
            'status_check'=> $status,
            'search'=> $search,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,  
            'budgets' =>  $budget,
            'year_id'=>$year_id,  
            'repeat'=>$repeat,
            'accept'=>$accept,
            'statuss'=>$status,
        ]);
    }
    //=====================================================================================//

    public function risk_refdepsub(Request $request,$iduser)
    {
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
        $yearbudget = date("Y")+543;        }

        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';
        $status = '';
        $search = '';
        $year_id = $yearbudget;

        $rigrep = Riskrep::leftjoin('risk_setincidence_setting','risk_rep.RISKREP_TITLE','=','risk_setincidence_setting.INCIDENCE_SETTING_ID')
        ->get();
        return view('general_risk.risk_refdepsub',[
            'inforpersonuserid' => $inforpersonuserid,
            'inforpersonuser' => $inforpersonuser,
            'rigreps'=>$rigrep,
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id,
            ]);

    }
    public function risk_refdepsub_search(Request $request,$iduser)
    { 
        $search = $request->get('search');
        $status = $request->SEND_STATUS;
        $datebigin = $request->get('DATE_BIGIN');
        $dateend = $request->get('DATE_END');
        
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
           
            $rigrep = DB::table('risk_rep')
                  ->leftjoin('risk_setincidence_setting','risk_rep.RISKREP_TITLE','=','risk_setincidence_setting.INCIDENCE_SETTING_ID')
                  ->where(function($q) use ($search){
                $q->where('INCIDENCE_SETTING_NAME','like','%'.$search.'%');
                $q->orwhere('RISKREP_DETAILRISK','like','%'.$search.'%');
                                
            })
            ->WhereBetween('RISKREP_DATESAVE',[$from,$to]) 
            ->orderBy('RISKREP_ID', 'desc')->get();    
           
           
            $m_budget = date("m");
            if($m_budget>9){
            $yearbudget = date("Y")+544;
            }else{
            $yearbudget = date("Y")+543;        }
    
            $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
    
            $displaydate_bigen = ($yearbudget-544).'-10-01';
            $displaydate_end = ($yearbudget-543).'-09-30';
          
            $year_id = $yearbudget;
                   
            $status = DB::table('risk_status')->get();
            $repeat = DB::table('risk_notify_repeat_sub')->where('STATUS_REPEAT','=','REPEAT')->count();
            $accept = DB::table('risk_notify_accept_sub')->where('STATUS_ACCEPT','=','ACCEPT')->count();

        return view('general_risk.risk_refdepsub',[   
            'inforpersonuserid' => $inforpersonuserid,
            'inforpersonuser' => $inforpersonuser,        
            'rigreps'=>$rigrep,
            'status_check'=> $status,
            'search'=> $search,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,  
            'budgets' =>  $budget,
            'year_id'=>$year_id,  
            'repeat'=>$repeat,
            'accept'=>$accept,
            'statuss'=>$status,
        ]);
    }
    //=====================================================================================//

    public function risk_refdepsubsub(Request $request,$iduser)
    {
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
        $yearbudget = date("Y")+543;        }

        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';
        $status = '';
        $search = '';
        $year_id = $yearbudget;

        $rigrep = Riskrep::leftjoin('risk_setincidence_setting','risk_rep.RISKREP_TITLE','=','risk_setincidence_setting.INCIDENCE_SETTING_ID')
        ->get();
 
        return view('general_risk.risk_refdepsubsub',[
            'inforpersonuserid' => $inforpersonuserid,
            'inforpersonuser' => $inforpersonuser,
            'rigreps'=>$rigrep,
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id,
            ]);

    }
    public function risk_refdepsubsub_search(Request $request,$iduser)
    { 
        $search = $request->get('search');
        $status = $request->SEND_STATUS;
        $datebigin = $request->get('DATE_BIGIN');
        $dateend = $request->get('DATE_END');
        
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
           
            $rigrep = DB::table('risk_rep')
                  ->leftjoin('risk_setincidence_setting','risk_rep.RISKREP_TITLE','=','risk_setincidence_setting.INCIDENCE_SETTING_ID')
                  ->where(function($q) use ($search){
                $q->where('INCIDENCE_SETTING_NAME','like','%'.$search.'%');
                $q->orwhere('RISKREP_DETAILRISK','like','%'.$search.'%');
                                
            })
            ->WhereBetween('RISKREP_DATESAVE',[$from,$to]) 
            ->orderBy('RISKREP_ID', 'desc')->get();    
           
           
            $m_budget = date("m");
            if($m_budget>9){
            $yearbudget = date("Y")+544;
            }else{
            $yearbudget = date("Y")+543;        }
    
            $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
    
            $displaydate_bigen = ($yearbudget-544).'-10-01';
            $displaydate_end = ($yearbudget-543).'-09-30';
          
            $year_id = $yearbudget;
                   
            $status = DB::table('risk_status')->get();
            $repeat = DB::table('risk_notify_repeat_sub')->where('STATUS_REPEAT','=','REPEAT')->count();
            $accept = DB::table('risk_notify_accept_sub')->where('STATUS_ACCEPT','=','ACCEPT')->count();

        return view('general_risk.risk_refdepsubsub',[   
            'inforpersonuserid' => $inforpersonuserid,
            'inforpersonuser' => $inforpersonuser,        
            'rigreps'=>$rigrep,
            'status_check'=> $status,
            'search'=> $search,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,  
            'budgets' =>  $budget,
            'year_id'=>$year_id,  
            'repeat'=>$repeat,
            'accept'=>$accept,
            'statuss'=>$status,
        ]);
    }
    //=====================================================================================//
    public function risk_refperson(Request $request,$iduser)
    {
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
        $yearbudget = date("Y")+543;        }

        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';
        $status = '';
        $search = '';
        $year_id = $yearbudget;

        $rigrep = Riskrep::leftjoin('risk_setincidence_setting','risk_rep.RISKREP_TITLE','=','risk_setincidence_setting.INCIDENCE_SETTING_ID')
        ->get();
 
        return view('general_risk.risk_refperson',[
            'inforpersonuserid' => $inforpersonuserid,
            'inforpersonuser' => $inforpersonuser,
            'rigreps'=>$rigrep,
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id,
           
            ]);
    }
   
    public function risk_refperson_search(Request $request,$iduser)
    { 
        $search = $request->get('search');
        $status = $request->SEND_STATUS;
        $datebigin = $request->get('DATE_BIGIN');
        $dateend = $request->get('DATE_END');
        
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
           
            $rigrep = DB::table('risk_rep')
                  ->leftjoin('risk_setincidence_setting','risk_rep.RISKREP_TITLE','=','risk_setincidence_setting.INCIDENCE_SETTING_ID')
                  ->where(function($q) use ($search){
                $q->where('INCIDENCE_SETTING_NAME','like','%'.$search.'%');
                $q->orwhere('RISKREP_DETAILRISK','like','%'.$search.'%');
                                
            })
            ->WhereBetween('RISKREP_DATESAVE',[$from,$to]) 
            ->orderBy('RISKREP_ID', 'desc')->get();    
           
           
            $m_budget = date("m");
            if($m_budget>9){
            $yearbudget = date("Y")+544;
            }else{
            $yearbudget = date("Y")+543;        }
    
            $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
    
            $displaydate_bigen = ($yearbudget-544).'-10-01';
            $displaydate_end = ($yearbudget-543).'-09-30';
          
            $year_id = $yearbudget;
                   
            $status = DB::table('risk_status')->get();
            $repeat = DB::table('risk_notify_repeat_sub')->where('STATUS_REPEAT','=','REPEAT')->count();
            $accept = DB::table('risk_notify_accept_sub')->where('STATUS_ACCEPT','=','ACCEPT')->count();

        return view('general_risk.risk_refperson',[   
            'inforpersonuserid' => $inforpersonuserid,
            'inforpersonuser' => $inforpersonuser,        
            'rigreps'=>$rigrep,
            'status_check'=> $status,
            'search'=> $search,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,  
            'budgets' =>  $budget,
            'year_id'=>$year_id,  
            'repeat'=>$repeat,
            'accept'=>$accept,
            'statuss'=>$status,
        ]);
    }
 //=====================================================================================//

 
 public function risk_notify_yearly(Request $request,$iduser)
 {
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


     return view('general_risk.risk_notify_yearly',[
         'inforpersonuserid' => $inforpersonuserid,
         'inforpersonuser' => $inforpersonuser,
    
         ]);

 }

 

 public function risk_notify_analysis(Request $request,$idref,$iduser)
 {
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


     $infomationcon = DB::table('risk_internalcontrol')->where('INTERNALCONTROL_ID','=',$idref)->first();

     $infomationcon_step = DB::table('risk_internalcontrol_subsub')->where('INTERNALCONTROL_ID','=',$idref)->get();

     $infoanalyze = DB::table('risk_internalcontrol_analyze')->where('INTERNALCONTROL_ID','=',$idref)->get();


     return view('general_risk.risk_notify_analysis',[
         'inforpersonuserid' => $inforpersonuserid,
         'inforpersonuser' => $inforpersonuser,
         'infoanalyzes' => $infoanalyze,
         'infomationcon' => $infomationcon,
         'infomationcon_steps' => $infomationcon_step,
         'idref' => $idref,
    
         ]);

 }



 public function risk_notify_report5(Request $request,$iduser)
 {    
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

 


     $infobudget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

     $infodep = DB::table('hrd_department_sub_sub')->get();
     $infoperson = DB::table('hrd_person')->get();

     $infomationreport5 = DB::table('risk_notify_report5')
     ->select('RISK_NOTIFY_RE5_PERSON','RISK_NOTIFY_RE5_DEP','RISK_NOTIFY_RE5_ID','RISK_NOTIFY_RE5_YEAR','RISK_NOTIFY_RE5_ROUND','RISK_NOTIFY_RE5_BEGINDATE','RISK_NOTIFY_RE5_ENDDATE','HR_DEPARTMENT_SUB_SUB_NAME','HR_FNAME','HR_LNAME','risk_notify_report5.created_at')
     ->leftJoin('hrd_person','hrd_person.ID','=','risk_notify_report5.RISK_NOTIFY_RE5_PERSON')
     ->leftJoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','risk_notify_report5.RISK_NOTIFY_RE5_DEP')
     ->where('RISK_NOTIFY_RE5_DEP','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)
     ->get();

     return view('general_risk.risk_notify_report5',[  
         'inforpersonuserid' => $inforpersonuserid,
         'inforpersonuser' => $inforpersonuser,  
         'infobudgets' => $infobudget,  
         'infodeps' => $infodep,   
         'infopersons' => $infoperson,
         'infomationreport5s' => $infomationreport5,         
        
     ]);
 }


 

 public function risk_notify_report5_edit(Request $request,$idref,$iduser)
 {    
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

 

     return view('general_risk.risk_notify_report5_edit',[  
         'inforpersonuserid' => $inforpersonuserid,
         'inforpersonuser' => $inforpersonuser,       
        
     ]);
 }


 

 public function risk_notify_report5_sub(Request $request,$idref,$iduser)
 {    
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


     $infomationreport5sub = DB::table('risk_notify_report5_sub')
     ->leftJoin('hrd_department_sub_sub','risk_notify_report5_sub.RISK_NOTIFY_RE5_SUB_DEP','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
     ->where('RISK_NOTIFY_RE5_ID','=',$idref)->get();

     $infodep = DB::table('hrd_department_sub_sub')->get();

     $infomationrist = DB::table('risk_internalcontrol_analyze')->get();

     

     return view('general_risk.risk_notify_report5_sub',[  
         'inforpersonuserid' => $inforpersonuserid,
         'inforpersonuser' => $inforpersonuser,  
         'idref' => $idref,   
         'infodeps' => $infodep, 
         'infomationrists' => $infomationrist,   
         'infomationreport5subs' => $infomationreport5sub,    
        
     ]);
 }


 public function risk_notify_account_level(Request $request,$idref,$iduser)
 {    
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


        $infomationlevel = DB::table('risk_account_detail_level')
        ->leftJoin('risk_account_detail_leveltype','risk_account_detail_level.RISK_ACCDE_LE_RATE','=','risk_account_detail_leveltype.RISK_LEVELTYPE_ID')
        ->where('RISK_ACC_ID','=',$idref)->get();
 
        $infoleveltype = DB::table('risk_account_detail_leveltype')->get();


        $inforiskimgmatrix = DB::table('risk_img_matrix')->where('RISK_IMG_ID','=','1')->first();

     return view('general_risk.risk_notify_account_level',[  
         'inforpersonuserid' => $inforpersonuserid,
         'inforpersonuser' => $inforpersonuser,     
         'infomationlevels' => $infomationlevel,  
         'infoleveltypes' => $infoleveltype, 
         'inforiskimgmatrix' => $inforiskimgmatrix, 
         'idref' => $idref,  
        
     ]);
 }

 



 public function risk_account_detail_level_save(Request $request)
    {  

        $iduser = $request->USER_ID;
        $inforpersonuserid =  Person::where('ID','=',$iduser)->first();       
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


        $RISKACCID = $request->RISK_ACC_ID;


                $add= new risk_account_detail_level();
                $add->RISK_ACC_ID = $RISKACCID;
                $add->RISK_ACCDE_LE_YEAR = $request->RISK_ACCDE_LE_YEAR;   
                $add->RISK_ACCDE_LE_RATE = $request->RISK_ACCDE_LE_RATE; 
                $add->RISK_ACCDE_LE_CHANCE = $request->RISK_ACCDE_LE_CHANCE; 
                $add->RISK_ACCDE_LE_EFFECT = $request->RISK_ACCDE_LE_EFFECT;         
                $add->RISK_ACCDE_LE_SCORE = $request->RISK_ACCDE_LE_SCORE; 
                $add->RISK_ACCDE_LE_ACCEPTABLE = $request->RISK_ACCDE_LE_ACCEPTABLE; 
                $add->save();


        return redirect()->route('gen_risk.risk_notify_account_level',[
            'idref'=> $RISKACCID,
            'iduser'=> $iduser
            ]);
    }


    public function risk_account_detail_level_update(Request $request)
    {  

        $iduser = $request->USER_ID;
        $inforpersonuserid =  Person::where('ID','=',$iduser)->first();       
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


        $RISKACCID = $request->RISK_ACC_ID;

        $idref = $request->RISK_ACCDE_LE_ID;

                $add=  risk_account_detail_level::find($idref);
                $add->RISK_ACC_ID = $RISKACCID;
                $add->RISK_ACCDE_LE_YEAR = $request->RISK_ACCDE_LE_YEAR;   
                $add->RISK_ACCDE_LE_RATE = $request->RISK_ACCDE_LE_RATE; 
                $add->RISK_ACCDE_LE_CHANCE = $request->RISK_ACCDE_LE_CHANCE; 
                $add->RISK_ACCDE_LE_EFFECT = $request->RISK_ACCDE_LE_EFFECT;         
                $add->RISK_ACCDE_LE_SCORE = $request->RISK_ACCDE_LE_SCORE; 
                $add->RISK_ACCDE_LE_ACCEPTABLE = $request->RISK_ACCDE_LE_ACCEPTABLE; 
                $add->save();


                return redirect()->route('gen_risk.risk_notify_account_level',[
                    'idref'=> $RISKACCID,
                    'iduser'=> $iduser
                    ]);
    }


    
 public function risk_account_detail_level_destroy(Request $request,$idref,$iduser)
 {
    $idrefinfo = DB::table('risk_account_detail')->where('ANALYZE_ID','=',$idref)->first();
    $INTERNALCONTROLID = $idrefinfo->INTERNALCONTROL_ID;

    risk_account_detail_level::destroy($idref);

     return redirect()->route('gen_risk.risk_notify_analysis',[
        'idref'=> $INTERNALCONTROLID,
        'iduser'=> $iduser
        ]);
 }


 

 public function risk_notify_report5_sub_excel(Request $request,$idref,$iduser)
 {    
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


     $infomationreport5sub = DB::table('risk_notify_report5_sub')
     ->leftJoin('hrd_department_sub_sub','risk_notify_report5_sub.RISK_NOTIFY_RE5_SUB_DEP','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
     ->where('RISK_NOTIFY_RE5_ID','=',$idref)->get();

     $infodep = DB::table('hrd_department_sub_sub')->get();

     $infomationrist = DB::table('risk_internalcontrol_analyze')->get();

        

     return view('general_risk.risk_notify_report5_sub_excel',[  
         'inforpersonuserid' => $inforpersonuserid,
         'inforpersonuser' => $inforpersonuser,  
         'idref' => $idref,   
         'infodeps' => $infodep, 
         'infomationrists' => $infomationrist,   
         'infomationreport5subs' => $infomationreport5sub,    
        
     ]);
 }


 
//**************************************************** */


public function risk_account_detail_save(Request $request)
{  

    $iduser = $request->USER_ID;
    $inforpersonuserid =  Person::where('ID','=',$iduser)->first();       
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



            $add= new Risk_account_detail();
            $add->RISK_CODE  = $request->RISK_CODE;  
            $add->RISK_TYPE_ID  = $request->RISK_TYPE_ID;  
            $add->RISK_ACC_FACTOR  = $request->RISK_ACC_FACTOR;  

            $add->RISK_ACC_ISSUE = $request->RISK_ACC_ISSUE;   
            $add->RISK_ACC_MISSION = $request->RISK_ACC_MISSION; 
            $add->RISK_ACC_OBJ = $request->RISK_ACC_OBJ;  
            $add->RISK_ACC_CONTROLS = $request->RISK_ACC_CONTROLS; 
            $add->RISK_ACC_AGENCY = $request->RISK_ACC_AGENCY;
            $add->save();




    return redirect()->route('gen_risk.risk_notify_account_detail',[
        'iduser'=> $iduser
        ]);
}


public function risk_account_detail_update(Request $request)
{  

    $iduser = $request->USER_ID;
    $inforpersonuserid =  Person::where('ID','=',$iduser)->first();       
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



    $idref = $request->RISK_ACC_ID;

  
            $add=  Risk_account_detail::find($idref);
            $add->RISK_TYPE_ID  = $request->RISK_TYPE_ID;  
            $add->RISK_ACC_FACTOR  = $request->RISK_ACC_FACTOR;  
            $add->RISK_ACC_ISSUE = $request->RISK_ACC_ISSUE;   
            $add->RISK_ACC_MISSION = $request->RISK_ACC_MISSION; 
            $add->RISK_ACC_OBJ = $request->RISK_ACC_OBJ;  
            $add->RISK_ACC_CONTROLS = $request->RISK_ACC_CONTROLS; 
            $add->RISK_ACC_AGENCY = $request->RISK_ACC_AGENCY;
            $add->save();


            return redirect()->route('gen_risk.risk_notify_account_detail',[
                'iduser'=> $iduser
                ]);
}





public function risk_notify_report5_save(Request $request)
{  

    $iduser = $request->USER_ID;
    $inforpersonuserid =  Person::where('ID','=',$iduser)->first();       
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



          $datebigin = $request->RISK_NOTIFY_RE5_BEGINDATE;         

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
        

            $dateend = $request->RISK_NOTIFY_RE5_ENDDATE;  
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




            $add= new Risk_notify_report5();
            $add->RISK_NOTIFY_RE5_YEAR = $request->RISK_NOTIFY_RE5_YEAR;
            $add->RISK_NOTIFY_RE5_ROUND = $request->RISK_NOTIFY_RE5_ROUND;   
            $add->RISK_NOTIFY_RE5_BEGINDATE = $displaydate_bigen; 
            $add->RISK_NOTIFY_RE5_ENDDATE =  $displaydate_end; 
            $add->RISK_NOTIFY_RE5_DEP = $request->RISK_NOTIFY_RE5_DEP;         
            $add->RISK_NOTIFY_RE5_PERSON = $request->RISK_NOTIFY_RE5_PERSON; 
            $add->save();


    return redirect()->route('gen_risk.risk_notify_report5',[
        'iduser'=> $iduser
        ]);
}


public function risk_notify_report5_update(Request $request)
{  

    $iduser = $request->USER_ID;
    $inforpersonuserid =  Person::where('ID','=',$iduser)->first();       
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


    $datebigin = $request->RISK_NOTIFY_RE5_BEGINDATE;         

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


    $dateend = $request->RISK_NOTIFY_RE5_ENDDATE;  
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


    $idref = $request->RISK_NOTIFY_RE5_ID;


            $update=  Risk_notify_report5::find($idref);
            $update->RISK_NOTIFY_RE5_YEAR = $request->RISK_NOTIFY_RE5_YEAR;
            $update->RISK_NOTIFY_RE5_ROUND = $request->RISK_NOTIFY_RE5_ROUND;   
            $update->RISK_NOTIFY_RE5_BEGINDATE = $displaydate_bigen; 
            $update->RISK_NOTIFY_RE5_ENDDATE =  $displaydate_end; 
            $update->RISK_NOTIFY_RE5_DEP = $request->RISK_NOTIFY_RE5_DEP;         
            $update->RISK_NOTIFY_RE5_PERSON = $request->RISK_NOTIFY_RE5_PERSON; 
            $update->save();


    return redirect()->route('gen_risk.risk_notify_report5',[
        'iduser'=> $iduser
        ]);
}

    public function risk_notify_report5_sub_save(Request $request)
    {  
        $iduser = $request->USER_ID;
        $inforpersonuserid =  Person::where('ID','=',$iduser)->first();       
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


                $add= new Risk_notify_report5_sub();
                $add->RISK_NOTIFY_RE5_ID = $request->RISK_NOTIFY_RE5_ID;
                $add->RISK_NOTIFY_RE5_SUB_RISK = $request->RISK_NOTIFY_RE5_SUB_RISK;   
                $add->RISK_NOTIFY_RE5_SUB_CONTROL = $request->RISK_NOTIFY_RE5_SUB_CONTROL; 
                $add->RISK_NOTIFY_RE5_SUB_RATE =  $request->RISK_NOTIFY_RE5_SUB_RATE; 
                $add->RISK_NOTIFY_RE5_SUB_HAVE = $request->RISK_NOTIFY_RE5_SUB_HAVE;         
                $add->RISK_NOTIFY_RE5_SUB_IMPROVE = $request->RISK_NOTIFY_RE5_SUB_IMPROVE; 
                $add->RISK_NOTIFY_RE5_SUB_DEP =  $request->RISK_NOTIFY_RE5_SUB_DEP; 
                $add->RISK_NOTIFY_RE5_SUB_TIME =  $request->RISK_NOTIFY_RE5_SUB_TIME; 
                $add->RISK_NOTIFY_RE5_SUB_STATUS =  $request->RISK_NOTIFY_RE5_SUB_STATUS; 
                $add->RISK_NOTIFY_RE5_SUB_TAG =  $request->RISK_NOTIFY_RE5_SUB_TAG; 
                $add->save();

                $idref = $request->RISK_NOTIFY_RE5_ID;

        return redirect()->route('gen_risk.risk_notify_report5_sub',[
            'iduser'=> $iduser,
            'idref'=> $idref,
            ]);
    }

    public function risk_notify_report5_sub_update(Request $request)
    {  

        $iduser = $request->USER_ID;
        $inforpersonuserid =  Person::where('ID','=',$iduser)->first();       
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

            $idupdate = $request->RISK_NOTIFY_RE5_SUB_ID;


                $update= Risk_notify_report5_sub::find($idupdate);
                $update->RISK_NOTIFY_RE5_ID = $request->RISK_NOTIFY_RE5_ID;
                $update->RISK_NOTIFY_RE5_SUB_RISK = $request->RISK_NOTIFY_RE5_SUB_RISK;   
                $update->RISK_NOTIFY_RE5_SUB_CONTROL = $request->RISK_NOTIFY_RE5_SUB_CONTROL; 
                $update->RISK_NOTIFY_RE5_SUB_RATE =  $request->RISK_NOTIFY_RE5_SUB_RATE; 
                $update->RISK_NOTIFY_RE5_SUB_HAVE = $request->RISK_NOTIFY_RE5_SUB_HAVE;         
                $update->RISK_NOTIFY_RE5_SUB_IMPROVE = $request->RISK_NOTIFY_RE5_SUB_IMPROVE; 
                $update->RISK_NOTIFY_RE5_SUB_DEP =  $request->RISK_NOTIFY_RE5_SUB_DEP; 
                $update->RISK_NOTIFY_RE5_SUB_TIME =  $request->RISK_NOTIFY_RE5_SUB_TIME; 
                $update->RISK_NOTIFY_RE5_SUB_STATUS =  $request->RISK_NOTIFY_RE5_SUB_STATUS; 
                $update->RISK_NOTIFY_RE5_SUB_TAG =  $request->RISK_NOTIFY_RE5_SUB_TAG; 
                $update->save();

                $idref = $request->RISK_NOTIFY_RE5_ID;

        return redirect()->route('gen_risk.risk_notify_report5_sub',[
            'iduser'=> $iduser,
            'idref'=> $idref,
            ]);
    }

    public function risk_notify_report4(Request $request,$iduser)
    {    
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


            $infomationre4 = DB::table('risk_notify_report4')
            ->leftJoin('hrd_person','hrd_person.ID','=','risk_notify_report4.RISK_NOTIFY_RE4_PERSON')
            ->leftJoin('hrd_department_sub_sub','risk_notify_report4.RISK_NOTIFY_RE4_DEP','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
            ->where('RISK_NOTIFY_RE4_DEP','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)
            ->get();

        return view('general_risk.risk_notify_report4',[  
            'inforpersonuserid' => $inforpersonuserid,
            'inforpersonuser' => $inforpersonuser,  
            'infomationre4s' => $infomationre4, 
        
        
        ]);
    }

    public function risk_notify_report4_add(Request $request,$iduser)
    {    
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

        

                $infomationdep =  DB::table('hrd_department_sub_sub')->get();
                $infomationperson =  DB::table('hrd_person')->get();
            


        return view('general_risk.risk_notify_report4_add',[  
            'inforpersonuserid' => $inforpersonuserid,
            'inforpersonuser' => $inforpersonuser,  
            'infomationdeps' => $infomationdep,
            'infomationpersons' => $infomationperson,     
        
        ]);
    }

    public function risk_notify_report4_edit(Request $request,$idref,$iduser)
    {    
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


        $infomationdep =  DB::table('hrd_department_sub_sub')->get();
        $infomationperson =  DB::table('hrd_person')->get();
    
    
        $infore4 = DB::table('risk_notify_report4')->where('RISK_NOTIFY_RE4_ID','=',$idref)->first();
        return view('general_risk.risk_notify_report4_edit',[  
            'inforpersonuserid' => $inforpersonuserid,
            'inforpersonuser' => $inforpersonuser,
            'infomationdeps' => $infomationdep,
            'infomationpersons' => $infomationperson,  
            'idref' => $idref,
            'infore4' => $infore4,       
        
        ]);
    }

    public function risk_notify_report4_save(Request $request)
    {  

        $iduser = $request->USER_ID;
        $inforpersonuserid =  Person::where('ID','=',$iduser)->first();       
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



        
        $datebigin = $request->RISK_NOTIFY_RE4_BEGINDATE;         

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


        $dateend = $request->RISK_NOTIFY_RE4_ENDDATE;  
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



                $add= new Risk_notify_report4();
                $add->RISK_NOTIFY_RE4_YEAR = $request->RISK_NOTIFY_RE4_YEAR;
                $add->RISK_NOTIFY_RE4_BEGINDATE = $displaydate_bigen;   
                $add->RISK_NOTIFY_RE4_ENDDATE = $displaydate_end; 
                $add->RISK_NOTIFY_RE4_DEP =  $request->RISK_NOTIFY_RE4_DEP; 
                $add->RISK_NOTIFY_RE4_PERSON = $request->RISK_NOTIFY_RE4_PERSON;         
                $add->RISK_NOTIFY_RE4_ENV = $request->RISK_NOTIFY_RE4_ENV; 
                $add->RISK_NOTIFY_RE4_RESULTENV =  $request->RISK_NOTIFY_RE4_RESULTENV; 
                $add->RISK_NOTIFY_RE4_RATE =  $request->RISK_NOTIFY_RE4_RATE; 
                $add->RISK_NOTIFY_RE4_RESULTRATE =  $request->RISK_NOTIFY_RE4_RESULTRATE; 
                $add->RISK_NOTIFY_RE4_ACT =  $request->RISK_NOTIFY_RE4_ACT; 
                $add->RISK_NOTIFY_RE4_RESULTACT =  $request->RISK_NOTIFY_RE4_RESULTACT; 
                $add->RISK_NOTIFY_RE4_IT =  $request->RISK_NOTIFY_RE4_IT; 
                $add->RISK_NOTIFY_RE4_RESULTIT =  $request->RISK_NOTIFY_RE4_RESULTIT; 
                $add->RISK_NOTIFY_RE4_TAG =  $request->RISK_NOTIFY_RE4_TAG; 
                $add->RISK_NOTIFY_RE4_RESULTTAG =  $request->RISK_NOTIFY_RE4_RESULTTAG; 
                $add->save();

            

                return redirect()->route('gen_risk.risk_notify_report4',[
                    'iduser'=> $iduser,
                    ]);
    }

    public function risk_notify_report4_update(Request $request)
    {  

        $iduser = $request->USER_ID;
        $inforpersonuserid =  Person::where('ID','=',$iduser)->first();       
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

            
        
        $datebigin = $request->RISK_NOTIFY_RE4_BEGINDATE;         

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


        $dateend = $request->RISK_NOTIFY_RE4_ENDDATE;  
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


    
        $idref =  $request->idref;

                $add=  Risk_notify_report4::find($idref);
                $add->RISK_NOTIFY_RE4_YEAR = $request->RISK_NOTIFY_RE4_YEAR;
                $add->RISK_NOTIFY_RE4_BEGINDATE = $displaydate_bigen;   
                $add->RISK_NOTIFY_RE4_ENDDATE = $displaydate_end; 
                $add->RISK_NOTIFY_RE4_DEP =  $request->RISK_NOTIFY_RE4_DEP; 
                $add->RISK_NOTIFY_RE4_PERSON = $request->RISK_NOTIFY_RE4_PERSON;         
                $add->RISK_NOTIFY_RE4_ENV = $request->RISK_NOTIFY_RE4_ENV; 
                $add->RISK_NOTIFY_RE4_RESULTENV =  $request->RISK_NOTIFY_RE4_RESULTENV; 
                $add->RISK_NOTIFY_RE4_RATE =  $request->RISK_NOTIFY_RE4_RATE; 
                $add->RISK_NOTIFY_RE4_RESULTRATE =  $request->RISK_NOTIFY_RE4_RESULTRATE; 
                $add->RISK_NOTIFY_RE4_ACT =  $request->RISK_NOTIFY_RE4_ACT; 
                $add->RISK_NOTIFY_RE4_RESULTACT =  $request->RISK_NOTIFY_RE4_RESULTACT; 
                $add->RISK_NOTIFY_RE4_IT =  $request->RISK_NOTIFY_RE4_IT; 
                $add->RISK_NOTIFY_RE4_RESULTIT =  $request->RISK_NOTIFY_RE4_RESULTIT; 
                $add->RISK_NOTIFY_RE4_TAG =  $request->RISK_NOTIFY_RE4_TAG; 
                $add->RISK_NOTIFY_RE4_RESULTTAG =  $request->RISK_NOTIFY_RE4_RESULTTAG; 
                $add->save();

            

        return redirect()->route('gen_risk.risk_notify_report4',[
            'iduser'=> $iduser,
            ]);
    }

    //ความเสี่ยงที่เกี่ยวงข้อง
    public function risk_notify_deal(Request $request,$iduser)
    {
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

        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';
        $status = '';
        $search = '';
        $year_id = $yearbudget;  

        $rigrep = Riskrep::select('RISKREP_STATUS','RISKREP_LEVEL','RISK_STATUS_NAME_TH','RISK_REP_LEVEL_NAME','RISKREP_DATESAVE','INCIDENCE_LOCATION_NAME','RISKREP_DETAILRISK','RISKREP_BASICMANAGE','risk_rep.RISKREP_ID','RISKREP_NO')
        ->leftjoin('risk_setincidence_setting','risk_rep.RISKREP_TITLE','=','risk_setincidence_setting.INCIDENCE_SETTING_ID')
        ->leftjoin('risk_status','risk_rep.RISKREP_STATUS','=','risk_status.RISK_STATUS_NAME')
        ->leftJoin('risk_rep_level','risk_rep.RISKREP_LEVEL','=','risk_rep_level.RISK_REP_LEVEL_ID')
        ->leftjoin('risk_setupincidence_location','risk_rep.RISKREP_SEARCHLOCATE','=','risk_setupincidence_location.INCIDENCE_LOCATION_ID')
        ->leftjoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','risk_rep.RISKREP_DEPARTMENT_SUB')
        ->leftjoin('risk_setupincidence_tpyelocation','risk_setupincidence_tpyelocation.SETUP_TYPELOCATION_ID','=','risk_rep.RISKREP_TYPE')
        ->leftjoin('risk_setupincidence_grouplocation','risk_setupincidence_grouplocation.SETUP_GROUPLOCATION_ID','=','risk_rep.RISKREP_LOCAL')
        ->leftjoin('risk_setupincidence_sub','risk_setupincidence_sub.INCIDENCE_SUB_ID','=','risk_rep.RISKREP_SUBTITLE')
        ->leftjoin('hrd_sex','hrd_sex.SEX_ID','=','risk_rep.RISKREP_SEX')
        ->leftjoin('risk_rep_department','risk_rep.RISKREP_ID','=','risk_rep_department.RISKREP_ID')
        ->leftjoin('risk_rep_department_sub','risk_rep.RISKREP_ID','=','risk_rep_department_sub.RISKREP_ID')
        ->leftjoin('risk_rep_department_subsub','risk_rep.RISKREP_ID','=','risk_rep_department_subsub.RISKREP_ID')
        ->leftjoin('risk_rep_infoperson','risk_rep.RISKREP_ID','=','risk_rep_infoperson.RISKREP_ID')   
        ->where('risk_rep_infoperson.RISK_REP_PERSON_ID', '=',$iduser)
        ->orwhere('risk_rep_department_subsub.HR_DEPARTMENT_SUB_SUB_ID', '=', $inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)
        ->orwhere('risk_rep_department_sub.HR_DEPARTMENT_SUB_ID', '=',$inforpersonuser->HR_DEPARTMENT_SUB_ID)
        ->orwhere('risk_rep_department.HR_DEPARTMENT_ID', '=',$inforpersonuser->HR_DEPARTMENT_ID)
        ->orderBy('risk_rep.RISKREP_ID','DESC')
        ->get();
        $location = DB::table('risk_setupincidence_location')->get();
        $setting = DB::table('risk_setincidence_setting')->get();

        $status = DB::table('risk_status')->get();
        $repeat = DB::table('risk_notify_repeat_sub')->where('STATUS_REPEAT','=','REPEAT')->count();
        $accept = DB::table('risk_notify_accept_sub')->where('STATUS_ACCEPT','=','ACCEPT')->count();

        return view('general_risk.risk_notify_deal',[
            'inforpersonuserid' => $inforpersonuserid,
            'inforpersonuser' => $inforpersonuser,
            'rigreps'=>$rigrep,
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id,
            'repeat'=>$repeat,
            'accept'=>$accept,
            'statuss'=>$status,
        ]);
    }
    
    public function risk_notify_deal_search(Request $request,$iduser)
    {
        $search = $request->get('search');
        $status = $request->STATUS_CODE;
        $datebigin = $request->get('DATE_BIGIN');
        $dateend = $request->get('DATE_END');
        $yearbudget = $request->BUDGET_YEAR; 


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

    
        // $array_use = ["$iduser","$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID","$inforpersonuser->HR_DEPARTMENT_SUB_ID","$inforpersonuser->HR_DEPARTMENT_ID"];

        if($status !== null){
            $rigrep = Riskrep::select('RISKREP_STATUS','RISKREP_LEVEL','RISK_STATUS_NAME_TH','RISK_REP_LEVEL_NAME','RISKREP_DATESAVE','INCIDENCE_LOCATION_NAME','RISKREP_DETAILRISK','RISKREP_BASICMANAGE','risk_rep.RISKREP_ID','RISKREP_NO')
            ->leftjoin('risk_setincidence_setting','risk_rep.RISKREP_TITLE','=','risk_setincidence_setting.INCIDENCE_SETTING_ID')
            ->leftjoin('risk_status','risk_rep.RISKREP_STATUS','=','risk_status.RISK_STATUS_NAME')
            ->leftJoin('risk_rep_level','risk_rep.RISKREP_LEVEL','=','risk_rep_level.RISK_REP_LEVEL_ID')
            ->leftjoin('risk_setupincidence_location','risk_rep.RISKREP_SEARCHLOCATE','=','risk_setupincidence_location.INCIDENCE_LOCATION_ID')
            ->leftjoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','risk_rep.RISKREP_DEPARTMENT_SUB')
            ->leftjoin('risk_setupincidence_tpyelocation','risk_setupincidence_tpyelocation.SETUP_TYPELOCATION_ID','=','risk_rep.RISKREP_TYPE')
            ->leftjoin('risk_setupincidence_grouplocation','risk_setupincidence_grouplocation.SETUP_GROUPLOCATION_ID','=','risk_rep.RISKREP_LOCAL')
            ->leftjoin('risk_setupincidence_sub','risk_setupincidence_sub.INCIDENCE_SUB_ID','=','risk_rep.RISKREP_SUBTITLE')
            ->leftjoin('hrd_sex','hrd_sex.SEX_ID','=','risk_rep.RISKREP_SEX')
            ->leftjoin('risk_rep_department','risk_rep.RISKREP_ID','=','risk_rep_department.RISKREP_ID')
            ->leftjoin('risk_rep_department_sub','risk_rep.RISKREP_ID','=','risk_rep_department_sub.RISKREP_ID')
            ->leftjoin('risk_rep_department_subsub','risk_rep.RISKREP_ID','=','risk_rep_department_subsub.RISKREP_ID')
            ->leftjoin('risk_rep_infoperson','risk_rep.RISKREP_ID','=','risk_rep_infoperson.RISKREP_ID')
            ->where('risk_rep.RISKREP_STATUS','=',$status)
            ->where('risk_rep_infoperson.RISK_REP_PERSON_ID', '=',$iduser)
            ->orwhere('risk_rep_department_subsub.HR_DEPARTMENT_SUB_SUB_ID', '=', $inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)
            ->orwhere('risk_rep_department_sub.HR_DEPARTMENT_SUB_ID', '=',$inforpersonuser->HR_DEPARTMENT_SUB_ID)
            ->orwhere('risk_rep_department.HR_DEPARTMENT_ID', '=',$inforpersonuser->HR_DEPARTMENT_ID)
            ->where(function($q) use ($search){
                $q->where('RISK_REP_LEVEL_NAME','like','%'.$search.'%');
                $q->orwhere('RISKREP_BASICMANAGE','like','%'.$search.'%');
                $q->orwhere('RISKREP_DETAILRISK','like','%'.$search.'%'); 
                $q->orwhere('RISK_STATUS_NAME_TH','like','%'.$search.'%');   
                $q->orwhere('INCIDENCE_LOCATION_NAME','like','%'.$search.'%');   
                $q->orwhere('RISKREP_NO','like','%'.$search.'%');   
                
            })
            ->WhereBetween('RISKREP_DATESAVE',[$from,$to]) 
            ->orderBy('risk_rep.RISKREP_ID','DESC')
            ->get();


        }else{

            $rigrep = Riskrep::select('RISKREP_STATUS','RISKREP_LEVEL','RISK_STATUS_NAME_TH','RISK_REP_LEVEL_NAME','RISKREP_DATESAVE','INCIDENCE_LOCATION_NAME','RISKREP_DETAILRISK','RISKREP_BASICMANAGE','risk_rep.RISKREP_ID','RISKREP_NO')
            ->leftjoin('risk_setincidence_setting','risk_rep.RISKREP_TITLE','=','risk_setincidence_setting.INCIDENCE_SETTING_ID')
            ->leftjoin('risk_status','risk_rep.RISKREP_STATUS','=','risk_status.RISK_STATUS_NAME')
            ->leftJoin('risk_rep_level','risk_rep.RISKREP_LEVEL','=','risk_rep_level.RISK_REP_LEVEL_ID')
            ->leftjoin('risk_setupincidence_location','risk_rep.RISKREP_SEARCHLOCATE','=','risk_setupincidence_location.INCIDENCE_LOCATION_ID')
            ->leftjoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','risk_rep.RISKREP_DEPARTMENT_SUB')
            ->leftjoin('risk_setupincidence_tpyelocation','risk_setupincidence_tpyelocation.SETUP_TYPELOCATION_ID','=','risk_rep.RISKREP_TYPE')
            ->leftjoin('risk_setupincidence_grouplocation','risk_setupincidence_grouplocation.SETUP_GROUPLOCATION_ID','=','risk_rep.RISKREP_LOCAL')
            ->leftjoin('risk_setupincidence_sub','risk_setupincidence_sub.INCIDENCE_SUB_ID','=','risk_rep.RISKREP_SUBTITLE')
            ->leftjoin('hrd_sex','hrd_sex.SEX_ID','=','risk_rep.RISKREP_SEX')
            ->leftjoin('risk_rep_department','risk_rep.RISKREP_ID','=','risk_rep_department.RISKREP_ID')
            ->leftjoin('risk_rep_department_sub','risk_rep.RISKREP_ID','=','risk_rep_department_sub.RISKREP_ID')
            ->leftjoin('risk_rep_department_subsub','risk_rep.RISKREP_ID','=','risk_rep_department_subsub.RISKREP_ID')
            ->leftjoin('risk_rep_infoperson','risk_rep.RISKREP_ID','=','risk_rep_infoperson.RISKREP_ID')
            ->where('risk_rep_infoperson.RISK_REP_PERSON_ID', '=',$iduser)
            ->orwhere('risk_rep_department_subsub.HR_DEPARTMENT_SUB_SUB_ID', '=', $inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)
            ->orwhere('risk_rep_department_sub.HR_DEPARTMENT_SUB_ID', '=',$inforpersonuser->HR_DEPARTMENT_SUB_ID)
            ->orwhere('risk_rep_department.HR_DEPARTMENT_ID', '=',$inforpersonuser->HR_DEPARTMENT_ID)
            ->where(function($q) use ($search){
                $q->where('RISK_REP_LEVEL_NAME','like','%'.$search.'%');
                $q->orwhere('RISKREP_BASICMANAGE','like','%'.$search.'%');
                $q->orwhere('RISKREP_DETAILRISK','like','%'.$search.'%'); 
                $q->orwhere('RISK_STATUS_NAME_TH','like','%'.$search.'%');   
                $q->orwhere('INCIDENCE_LOCATION_NAME','like','%'.$search.'%');   
                $q->orwhere('RISKREP_NO','like','%'.$search.'%');   
            })
            ->WhereBetween('RISKREP_DATESAVE',[$from,$to]) 
            ->orderBy('risk_rep.RISKREP_ID','DESC')
            ->get();
        }

        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
    
        $year_id = $yearbudget;

        $location = DB::table('risk_setupincidence_location')->get();
        $setting = DB::table('risk_setincidence_setting')->get();
            
        $status_info = DB::table('risk_status')->get();
        $repeat = DB::table('risk_notify_repeat_sub')->where('STATUS_REPEAT','=','REPEAT')->count();
        $accept = DB::table('risk_notify_accept_sub')->where('STATUS_ACCEPT','=','ACCEPT')->count();
        return view('general_risk.risk_notify_deal',[
            'inforpersonuserid' => $inforpersonuserid,
            'inforpersonuser' => $inforpersonuser,
            'rigreps'=>$rigrep,
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id,
            'repeat'=>$repeat,
            'accept'=>$accept,
            'statuss'=>$status_info,
        ]);
    }

    public function risk_notify_deal_detail(Request $request,$id,$iduser)
    {
        $inforpersonuserid =  Person::where('ID','=',$iduser)->first();
        // $id = $inforpersonuserid->ID;

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

            $rigrep = DB::table('risk_rep')->where('RISKREP_ID','=',$id)->first();
            $infoper = DB::table('hrd_person')->get();
            // $departsub = DB::table('hrd_department_sub_sub')->get();
            $departsub = DB::table('hrd_department_sub_sub')->where('HR_DEPARTMENT_SUB_SUB_ID','=',$rigrep->RISKREP_DEPARTMENT_SUB)->get();
            // $departsub = DB::table('hrd_department_sub_sub')->where('HR_DEPARTMENT_SUB_SUB_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)->get();
            $riskcategory = DB::table('risk_setincidence_category')->get();
            $location = DB::table('risk_setupincidence_location')->get();
            $level = DB::table('risk_rep_level')->get();
            $setting = DB::table('risk_setincidence_setting')->get();
            $incidentsub = DB::table('risk_setupincidence_sub')->get();
            $typelocation = DB::table('risk_setupincidence_tpyelocation')->get();
            $sex = DB::table('hrd_sex')->get();
            $worktime = DB::table('risk_rep_time')->get();
            $effect = DB::table('risk_setupincidence_usereffect')->get();
            $uefect = DB::table('risk_setupincidence_usereffect')->get();

            $typelocationf = DB::table('risk_setupincidence_tpyelocation')->first();
            $grouplocation = DB::table('risk_rep_location')->where('SETUP_TYPELOCATION_ID','=',$typelocationf->SETUP_TYPELOCATION_ID)->get();

            $riskprogram  = DB::table('risk_rep_program')->get();
            $riskprogramsub  = DB::table('risk_rep_program_sub')->get();
            $riskprogramsubsub  = DB::table('risk_rep_program_subsub')->get();
            $risktypereason  = DB::table('risk_rep_typereason')->get();
            $risktypereasonsys  = DB::table('risk_rep_typereason_sys')->get();
            $item = DB::table('risk_rep_items')->get();
            $itemsub = DB::table('risk_rep_items_sub')->get();
            // $riskitem = Risk_rep_items::get();
            // $infoteam = Team::orderBy('HR_TEAM_ID', 'asc')->get();

            $leader =  DB::table('gleave_leader_person')
            ->leftJoin('gleave_leader','gleave_leader.LEADER_ID','=','gleave_leader_person.LEADER_ID')
            ->where('PERSON_ID','=',$iduser)
            ->get();

            $locationuse = DB::table('risk_setupincidence_origin')->get();

            $infolocation = DB::table('supplies_location')->get();
            $infolocationlevel = DB::table('supplies_location_level')->get();
            $infolocationlevelroom = DB::table('supplies_location_level_room')->get();


            
        return view('general_risk.risk_notify_deal_detail',[
            'inforpersonuserid' => $inforpersonuserid,
            'inforpersonuser' => $inforpersonuser,
            'departsubs'=>$departsub,
            'rigreps'=>$rigrep,
            'effects'=>$effect,
            'riskcategorys'=>$riskcategory,
            'locations'=>$location,
            'levels'=>$level,
            'settings'=>$setting,
            'incidentsubs'=>$incidentsub,
            'typelocations'=>$typelocation,
            'sexs'=>$sex,
            'infopers'=>$infoper,
            'grouplocations'=>$grouplocation,
            'worktimes'=>$worktime,
            'leaders'=>$leader,
            'riskprograms'=>$riskprogram,
            'riskprogramsubs'=>$riskprogramsub,
            'riskprogramsubsubs'=>$riskprogramsubsub,
            'risktypereasons'=>$risktypereason,
            'risktypereasonsyss'=>$risktypereasonsys,
            'items'=>$item,
            // 'riskitems'=>$riskitem,
            'itemsubs'=>$itemsub,
            'uefects'=>$uefect,
            'locationuses'=>$locationuse,
                        
            'infolocations' => $infolocation,
            'infolocationlevels' => $infolocationlevel,
            'infolocationlevelrooms' => $infolocationlevelroom, 
            ]);
    }

    public function risk_notify_deal_recheck($idrisk , $iduser){
        $inforecheck = DB::table('risk_recheck')
        ->leftJoin('hrd_person','hrd_person.ID','=','risk_recheck.RISK_RECHECK_PERSON')
        ->where('RISK_RECHECK_RISKID','=',$idrisk)->get();
        $inforpersonuser =  Person::where('ID',Auth()->user()->PERSON_ID)->first();
        $iduser          =  Auth()->user()->PERSON_ID;

        return view('general_risk.risk_notify_deal_recheck',[
            'riskid' => $idrisk,
            'inforechecks'=> $inforecheck,
            'inforpersonuser' => $inforpersonuser,
            'iduser' => $iduser
         ]);
    }

    public function risk_notify_deal_recheck_add($idrisk,$iduser){
        $inforpersonuser =  Person::where('ID',Auth()->user()->PERSON_ID)->first();
        $iduser          =  Auth()->user()->PERSON_ID;
        $person          = Person::getPersonWork();

        $infodetailrisk = DB::table('risk_rep')->where('RISKREP_ID','=',$idrisk)->first();
        return view('general_risk.risk_notify_deal_recheck_add',compact(
            'idrisk',
            'iduser',
            'inforpersonuser',
            'infodetailrisk',
            'person'
        ));
    }

    public function risk_notify_deal_recheck_save(Request $request){
        $RECHECK_DATE= $request->RISK_RECHECK_DATE;
        if($RECHECK_DATE != ''){
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $RECHECK_DATE)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0]; 
            
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $RECHECKDATE= $y_st."-".$m_st."-".$d_st;
            }else{
            $RECHECKDATE= null;
        }
        $addrecheck = new Riskrecheck(); 
        $addrecheck->RISK_RECHECK_DATE_SAVE  = date('Y-m-d');
        $addrecheck->RISK_RECHECK_DATE = $RECHECKDATE;
        $addrecheck->RISK_RECHECK_RISKID = $request->RISK_RECHECK_RISKID;
        $addrecheck->RISK_RECHECK_HEAD = $request->RISK_RECHECK_HEAD;
        $addrecheck->RISK_RECHECK_DETAIL = $request->RISK_RECHECK_DETAIL;
        $addrecheck->RISK_RECHECK_TOTAL = $request->RISK_RECHECK_TOTAL;
        $addrecheck->RISK_RECHECK_PERSON = $request->RISK_RECHECK_PERSON;
        $maxid = Riskrecheck::max('RISK_RECHECK_ID');
        $idfile = $maxid+1;
        if($request->hasFile('pdfupload')){
            $newFileName = 'recheck_'.$idfile.'.'.$request->pdfupload->extension();
            $request->pdfupload->storeAs('riskpdf',$newFileName,'public');
            $addrecheck->RISK_RECHECK_FILE = 'True';
            $addrecheck->RISK_RECHECKE_NAME = $newFileName;
        }else{
            $addrecheck->RISK_RECHECK_FILE = '';
            $addrecheck->RISK_RECHECKE_NAME = '';
        }
        if($request->hasFile('fileupload')){
            $newFileName = 'recheck2_'.$idfile.'.'.$request->fileupload->extension();
            $request->fileupload->storeAs('riskpdf',$newFileName,'public');
            $addrecheck->RISK_RECHECK_FILE_2 = 'True';
            $addrecheck->RISK_RECHECK_NAME_2 = $newFileName;
            $addrecheck->RISK_RECHECK_NAME_OLD =  $request->file('fileupload')->getClientOriginalName();
        }else{
            $addrecheck->RISK_RECHECK_FILE_2 = '';
            $addrecheck->RISK_RECHECK_NAME_2 = '';
            $addrecheck->RISK_RECHECK_NAME_OLD =  '';
        }
        $addrecheck->save();
        return redirect(route('gen_risk.risk_notify_deal_recheck',[$request->RISK_RECHECK_RISKID,$request->iduser]));
    }

    public function risk_notify_deal_recheck_edit($idrisk_recheck,$iduser){
        $inforpersonuser =  Person::where('ID',Auth()->user()->PERSON_ID)->first();
        $iduser          =  Auth()->user()->PERSON_ID;
        $person          = Person::getPersonWork();
        $riskrecheck = Riskrecheck::where('RISK_RECHECK_ID',$idrisk_recheck)->first();
        return view('general_risk.risk_notify_deal_recheck_edit',compact(
            'iduser',
            'inforpersonuser',
            'person',
            'riskrecheck'
        ));
    }

    public function risk_notify_deal_recheck_update(Request $request){
        $RECHECK_DATE= $request->RISK_RECHECK_DATE;
        if($RECHECK_DATE != ''){
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $RECHECK_DATE)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0]; 
            
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $RECHECKDATE= $y_st."-".$m_st."-".$d_st;
            }else{
            $RECHECKDATE= null;
        }
        $addrecheck = Riskrecheck::find($request->RISK_RECHECK_ID); 
        $addrecheck->RISK_RECHECK_DATE = $RECHECKDATE;
        $addrecheck->RISK_RECHECK_RISKID = $request->RISK_RECHECK_RISKID;
        $addrecheck->RISK_RECHECK_HEAD = $request->RISK_RECHECK_HEAD;
        $addrecheck->RISK_RECHECK_DETAIL = $request->RISK_RECHECK_DETAIL;
        $addrecheck->RISK_RECHECK_TOTAL = $request->RISK_RECHECK_TOTAL;
        $addrecheck->RISK_RECHECK_PERSON = $request->RISK_RECHECK_PERSON;
        $maxid = Riskrecheck::max('RISK_RECHECK_ID');
        $idfile = $maxid+1;
        if($request->hasFile('pdfupload')){
            $newFileName = 'recheck_'.$idfile.'.'.$request->pdfupload->extension();
            $request->pdfupload->storeAs('riskpdf',$newFileName,'public');
            $addrecheck->RISK_RECHECK_FILE = 'True';
            $addrecheck->RISK_RECHECKE_NAME = $newFileName;
        }
        if($request->hasFile('fileupload')){
            $newFileName = 'recheck2_'.$idfile.'.'.$request->fileupload->extension();
            $request->fileupload->storeAs('riskpdf',$newFileName,'public');
            $addrecheck->RISK_RECHECK_FILE_2 = 'True';
            $addrecheck->RISK_RECHECK_NAME_2 = $newFileName;
            $addrecheck->RISK_RECHECK_NAME_OLD =  $request->file('fileupload')->getClientOriginalName();
        }
        $addrecheck->save();
        return redirect(route('gen_risk.risk_notify_deal_recheck',[$request->RISK_RECHECK_RISKID,$request->iduser]));
    }
    //จบความเสี่ยงที่เกี่ยวงข้อง

    //รายละเอียดอุบัติการณ์
    public function risk_notify_account_incidence(Request $request,$idref,$iduser)
    {    
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


        $inforisk = DB::table('risk_account_detail')->where('RISK_ACC_ID','=',$idref)->first();

            $infoincidence = Riskrep::leftjoin('risk_setincidence_setting','risk_rep.RISKREP_TITLE','=','risk_setincidence_setting.INCIDENCE_SETTING_ID')
            ->leftjoin('risk_status','risk_rep.RISKREP_STATUS','=','risk_status.RISK_STATUS_NAME')
            ->leftJoin('risk_rep_level','risk_rep.RISKREP_LEVEL','=','risk_rep_level.RISK_REP_LEVEL_ID')
            ->leftjoin('risk_setupincidence_location','risk_rep.RISKREP_SEARCHLOCATE','=','risk_setupincidence_location.INCIDENCE_LOCATION_ID')
            ->leftjoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','risk_rep.RISKREP_DEPARTMENT_SUB')
            ->leftjoin('risk_setupincidence_tpyelocation','risk_setupincidence_tpyelocation.SETUP_TYPELOCATION_ID','=','risk_rep.RISKREP_TYPE')
            ->leftjoin('risk_setupincidence_grouplocation','risk_setupincidence_grouplocation.SETUP_GROUPLOCATION_ID','=','risk_rep.RISKREP_LOCAL')
            ->leftjoin('risk_setupincidence_sub','risk_setupincidence_sub.INCIDENCE_SUB_ID','=','risk_rep.RISKREP_SUBTITLE')
            ->leftjoin('hrd_sex','hrd_sex.SEX_ID','=','risk_rep.RISKREP_SEX')
            ->where('risk_rep.RISKREP_ACC_ID','=',$idref)
            ->orderBy('RISKREP_ID','DESC')
            ->get();
    

        return view('general_risk.risk_notify_account_incidence',[  
            'inforpersonuserid' => $inforpersonuserid,
            'inforpersonuser' => $inforpersonuser,     
            'infoincidences' => $infoincidence,   
            'inforisk' => $inforisk,   
            'idref' => $idref,  
            
        ]);
    }

    //=====================================================ฟังชั่นบัญชีความเสี่ยง
    public static function refnumber_risk()
    {
        $year = date('Y');
        $maxnumber = DB::table('risk_account_detail')->max('RISK_ACC_ID');  
        if($maxnumber != '' ||  $maxnumber != null){
            $refmax = DB::table('risk_account_detail')->where('RISK_ACC_ID','=',$maxnumber)->first();  
            if($refmax->RISK_CODE != '' ||  $refmax->RISK_CODE != null){
            $maxref = substr($refmax->RISK_CODE, -4)+1;
            }else{
            $maxref = 1;
            }
            $ref = str_pad($maxref, 5, "0", STR_PAD_LEFT);
    
        }else{
            $ref = '00001';
        }

        $ye = date('Y')+543;
        $y = substr($ye, -2);
        $refnumber ='R'.$y.'-'.$ref;
        return $refnumber;
    }

    public static function RISK_ACCDE_LE_CHANCE($idref)
    {
    
        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;  
        }

        $infomation = DB::table('risk_account_detail_level')->where('RISK_ACCDE_LE_YEAR','=',$yearbudget)->where('RISK_ACC_ID','=',$idref)->first();
        if( $infomation  == null){
            $output = '';
        }else{
            $output =  $infomation->RISK_ACCDE_LE_CHANCE;
        }
        
        return  $output;
    }

    public static function RISK_ACCDE_LE_EFFECT($idref)
    {
    
        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;  
        }

        $infomation = DB::table('risk_account_detail_level')->where('RISK_ACCDE_LE_YEAR','=',$yearbudget)->where('RISK_ACC_ID','=',$idref)->first();
        if( $infomation  == null){
            $output = '';
        }else{
            $output =  $infomation->RISK_ACCDE_LE_EFFECT;
        }
        
        
        return $output;
    }

    public static function RISK_ACCDE_LE_SCORE($idref)
    {
    
        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;  
        }

        $infomation = DB::table('risk_account_detail_level')->where('RISK_ACCDE_LE_YEAR','=',$yearbudget)->where('RISK_ACC_ID','=',$idref)->first();
        
        if( $infomation  == null){
            $output = '';
        }else{
            $output =  $infomation->RISK_ACCDE_LE_SCORE;
        }
        
        return $output;
    }

    public static function RISK_ACCDE_LE_RATE($idref)
    {
    
        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;  
        }

        $infomation = DB::table('risk_account_detail_level')
        ->leftjoin('risk_account_detail_leveltype','risk_account_detail_leveltype.RISK_LEVELTYPE_ID','=','risk_account_detail_level.RISK_ACCDE_LE_RATE')
        ->where('RISK_ACCDE_LE_YEAR','=',$yearbudget)->where('RISK_ACC_ID','=',$idref)->first();
        
            
        if( $infomation  == null){
            $output = '';
        }else{
            $output =  $infomation->RISK_LEVELTYPE_NAME;
        }
        
        return $output;
    }

    public static function RISK_ACCDE_LE_RATE_COLOR($idref)
    {
    
        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;  
        }

        $infomation = DB::table('risk_account_detail_level')
        ->leftjoin('risk_account_detail_leveltype','risk_account_detail_leveltype.RISK_LEVELTYPE_ID','=','risk_account_detail_level.RISK_ACCDE_LE_RATE')
        ->where('RISK_ACCDE_LE_YEAR','=',$yearbudget)->where('RISK_ACC_ID','=',$idref)->first();
        
            
        if( $infomation  == null){
            $output = '';
        }else{
            $output =  $infomation->RISK_LEVELTYPE_COLOR;
        }
        
        return $output;
    }


    public static function checkpermischeckinfo($id_user)
    {
        $count =  Permislist::where('PERSON_ID','=',$id_user)
                    ->where('PERMIS_ID','=','GMR002')
                    ->count();   
        return $count;
    }

}