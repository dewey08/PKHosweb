<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Person;

use App\Models\Salaryborrow;
use App\Models\Salarycertificate;
use App\Models\Salaryslip;
use App\Models\Salaryborrowsub;

use App\Models\Salaryallreceive;
use App\Models\Salaryallpay;
use App\Models\Salaryall;

date_default_timezone_set("Asia/Bangkok");

class CompensationController extends Controller
{
    public function dashboard(Request $request,$iduser)
    {
        if($request->method() === "POST"){
            $yearbudget = $request->STATUS_CODE;
        }else{
            $yearbudget = getBudgetYear();
        }
        $inforperson =  Person::where('ID','=',$iduser)->first();
        $inforpersonuser =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
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


        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        $count1 = Salaryallreceive::leftJoin('salary_all','salary_all_receive.SALARYALL_ID','=','salary_all.SALARYALL_ID')
        ->where('SALARYALL_RECEIVE_YEAR','=',$yearbudget)
        ->where('salary_all.SALARYALL_PERSON_ID','=',$iduser)->sum('SALARYALL_RECEIVE_AMOUNT');
        $count2 = Salaryallpay::leftJoin('salary_all','salary_all_pay.SALARYALL_ID','=','salary_all.SALARYALL_ID')
        ->where('SALARYALL_PAY_YEAR','=',$yearbudget)
        ->where('salary_all.SALARYALL_PERSON_ID','=',$iduser)
        ->sum('SALARYALL_PAY_AMOUNT');
        $count3 = Salaryall::where('SALARYALL_YEAR_ID','=',$yearbudget)->where('salary_all.SALARYALL_PERSON_ID','=',$iduser)->sum('SALARYALL_TOTAL');

        $m1_1 = DB::table('salary_all_receive')->leftJoin('salary_all','salary_all_receive.SALARYALL_ID','=','salary_all.SALARYALL_ID')->where('salary_all.SALARYALL_PERSON_ID','=',$iduser)->where('SALARYALL_RECEIVE_YEAR','=',$yearbudget)->where('SALARYALL_RECEIVE_MONTH','=',1)->sum('SALARYALL_RECEIVE_AMOUNT');
        $m2_1 = DB::table('salary_all_receive')->leftJoin('salary_all','salary_all_receive.SALARYALL_ID','=','salary_all.SALARYALL_ID')->where('salary_all.SALARYALL_PERSON_ID','=',$iduser)->where('SALARYALL_RECEIVE_YEAR','=',$yearbudget)->where('SALARYALL_RECEIVE_MONTH','=',2)->sum('SALARYALL_RECEIVE_AMOUNT');
        $m3_1 = DB::table('salary_all_receive')->leftJoin('salary_all','salary_all_receive.SALARYALL_ID','=','salary_all.SALARYALL_ID')->where('salary_all.SALARYALL_PERSON_ID','=',$iduser)->where('SALARYALL_RECEIVE_YEAR','=',$yearbudget)->where('SALARYALL_RECEIVE_MONTH','=',3)->sum('SALARYALL_RECEIVE_AMOUNT');
        $m4_1 = DB::table('salary_all_receive')->leftJoin('salary_all','salary_all_receive.SALARYALL_ID','=','salary_all.SALARYALL_ID')->where('salary_all.SALARYALL_PERSON_ID','=',$iduser)->where('SALARYALL_RECEIVE_YEAR','=',$yearbudget)->where('SALARYALL_RECEIVE_MONTH','=',4)->sum('SALARYALL_RECEIVE_AMOUNT');
        $m5_1 = DB::table('salary_all_receive')->leftJoin('salary_all','salary_all_receive.SALARYALL_ID','=','salary_all.SALARYALL_ID')->where('salary_all.SALARYALL_PERSON_ID','=',$iduser)->where('SALARYALL_RECEIVE_YEAR','=',$yearbudget)->where('SALARYALL_RECEIVE_MONTH','=',5)->sum('SALARYALL_RECEIVE_AMOUNT');
        $m6_1 = DB::table('salary_all_receive')->leftJoin('salary_all','salary_all_receive.SALARYALL_ID','=','salary_all.SALARYALL_ID')->where('salary_all.SALARYALL_PERSON_ID','=',$iduser)->where('SALARYALL_RECEIVE_YEAR','=',$yearbudget)->where('SALARYALL_RECEIVE_MONTH','=',6)->sum('SALARYALL_RECEIVE_AMOUNT');
        $m7_1 = DB::table('salary_all_receive')->leftJoin('salary_all','salary_all_receive.SALARYALL_ID','=','salary_all.SALARYALL_ID')->where('salary_all.SALARYALL_PERSON_ID','=',$iduser)->where('SALARYALL_RECEIVE_YEAR','=',$yearbudget)->where('SALARYALL_RECEIVE_MONTH','=',7)->sum('SALARYALL_RECEIVE_AMOUNT');
        $m8_1 = DB::table('salary_all_receive')->leftJoin('salary_all','salary_all_receive.SALARYALL_ID','=','salary_all.SALARYALL_ID')->where('salary_all.SALARYALL_PERSON_ID','=',$iduser)->where('SALARYALL_RECEIVE_YEAR','=',$yearbudget)->where('SALARYALL_RECEIVE_MONTH','=',8)->sum('SALARYALL_RECEIVE_AMOUNT');
        $m9_1 = DB::table('salary_all_receive')->leftJoin('salary_all','salary_all_receive.SALARYALL_ID','=','salary_all.SALARYALL_ID')->where('salary_all.SALARYALL_PERSON_ID','=',$iduser)->where('SALARYALL_RECEIVE_YEAR','=',$yearbudget)->where('SALARYALL_RECEIVE_MONTH','=',9)->sum('SALARYALL_RECEIVE_AMOUNT');
        $m10_1 = DB::table('salary_all_receive')->leftJoin('salary_all','salary_all_receive.SALARYALL_ID','=','salary_all.SALARYALL_ID')->where('salary_all.SALARYALL_PERSON_ID','=',$iduser)->where('SALARYALL_RECEIVE_YEAR','=',$yearbudget)->where('SALARYALL_RECEIVE_MONTH','=',10)->sum('SALARYALL_RECEIVE_AMOUNT');
        $m11_1 = DB::table('salary_all_receive')->leftJoin('salary_all','salary_all_receive.SALARYALL_ID','=','salary_all.SALARYALL_ID')->where('salary_all.SALARYALL_PERSON_ID','=',$iduser)->where('SALARYALL_RECEIVE_YEAR','=',$yearbudget)->where('SALARYALL_RECEIVE_MONTH','=',11)->sum('SALARYALL_RECEIVE_AMOUNT');
        $m12_1 = DB::table('salary_all_receive')->leftJoin('salary_all','salary_all_receive.SALARYALL_ID','=','salary_all.SALARYALL_ID')->where('salary_all.SALARYALL_PERSON_ID','=',$iduser)->where('SALARYALL_RECEIVE_YEAR','=',$yearbudget)->where('SALARYALL_RECEIVE_MONTH','=',12)->sum('SALARYALL_RECEIVE_AMOUNT');

        $m1_2 = DB::table('salary_all_pay')->leftJoin('salary_all','salary_all_pay.SALARYALL_ID','=','salary_all.SALARYALL_ID')->where('salary_all.SALARYALL_PERSON_ID','=',$iduser)->where('SALARYALL_PAY_YEAR','=',$yearbudget)->where('SALARYALL_PAY_MONTH','=',1)->sum('SALARYALL_PAY_AMOUNT');
        $m2_2 = DB::table('salary_all_pay')->leftJoin('salary_all','salary_all_pay.SALARYALL_ID','=','salary_all.SALARYALL_ID')->where('salary_all.SALARYALL_PERSON_ID','=',$iduser)->where('SALARYALL_PAY_YEAR','=',$yearbudget)->where('SALARYALL_PAY_YEAR','=',2)->sum('SALARYALL_PAY_AMOUNT');
        $m3_2 = DB::table('salary_all_pay')->leftJoin('salary_all','salary_all_pay.SALARYALL_ID','=','salary_all.SALARYALL_ID')->where('salary_all.SALARYALL_PERSON_ID','=',$iduser)->where('SALARYALL_PAY_YEAR','=',$yearbudget)->where('SALARYALL_PAY_MONTH','=',3)->sum('SALARYALL_PAY_AMOUNT');
        $m4_2 = DB::table('salary_all_pay')->leftJoin('salary_all','salary_all_pay.SALARYALL_ID','=','salary_all.SALARYALL_ID')->where('salary_all.SALARYALL_PERSON_ID','=',$iduser)->where('SALARYALL_PAY_YEAR','=',$yearbudget)->where('SALARYALL_PAY_MONTH','=',4)->sum('SALARYALL_PAY_AMOUNT');
        $m5_2 = DB::table('salary_all_pay')->leftJoin('salary_all','salary_all_pay.SALARYALL_ID','=','salary_all.SALARYALL_ID')->where('salary_all.SALARYALL_PERSON_ID','=',$iduser)->where('SALARYALL_PAY_YEAR','=',$yearbudget)->where('SALARYALL_PAY_MONTH','=',5)->sum('SALARYALL_PAY_AMOUNT');
        $m6_2 = DB::table('salary_all_pay')->leftJoin('salary_all','salary_all_pay.SALARYALL_ID','=','salary_all.SALARYALL_ID')->where('salary_all.SALARYALL_PERSON_ID','=',$iduser)->where('SALARYALL_PAY_YEAR','=',$yearbudget)->where('SALARYALL_PAY_MONTH','=',6)->sum('SALARYALL_PAY_AMOUNT');
        $m7_2 = DB::table('salary_all_pay')->leftJoin('salary_all','salary_all_pay.SALARYALL_ID','=','salary_all.SALARYALL_ID')->where('salary_all.SALARYALL_PERSON_ID','=',$iduser)->where('SALARYALL_PAY_YEAR','=',$yearbudget)->where('SALARYALL_PAY_MONTH','=',7)->sum('SALARYALL_PAY_AMOUNT');
        $m8_2 = DB::table('salary_all_pay')->leftJoin('salary_all','salary_all_pay.SALARYALL_ID','=','salary_all.SALARYALL_ID')->where('salary_all.SALARYALL_PERSON_ID','=',$iduser)->where('SALARYALL_PAY_YEAR','=',$yearbudget)->where('SALARYALL_PAY_MONTH','=',8)->sum('SALARYALL_PAY_AMOUNT');
        $m9_2 = DB::table('salary_all_pay')->leftJoin('salary_all','salary_all_pay.SALARYALL_ID','=','salary_all.SALARYALL_ID')->where('salary_all.SALARYALL_PERSON_ID','=',$iduser)->where('SALARYALL_PAY_YEAR','=',$yearbudget)->where('SALARYALL_PAY_MONTH','=',9)->sum('SALARYALL_PAY_AMOUNT');
        $m10_2 = DB::table('salary_all_pay')->leftJoin('salary_all','salary_all_pay.SALARYALL_ID','=','salary_all.SALARYALL_ID')->where('salary_all.SALARYALL_PERSON_ID','=',$iduser)->where('SALARYALL_PAY_YEAR','=',$yearbudget)->where('SALARYALL_PAY_MONTH','=',10)->sum('SALARYALL_PAY_AMOUNT');
        $m11_2 = DB::table('salary_all_pay')->leftJoin('salary_all','salary_all_pay.SALARYALL_ID','=','salary_all.SALARYALL_ID')->where('salary_all.SALARYALL_PERSON_ID','=',$iduser)->where('SALARYALL_PAY_YEAR','=',$yearbudget)->where('SALARYALL_PAY_MONTH','=',11)->sum('SALARYALL_PAY_AMOUNT');
        $m12_2 = DB::table('salary_all_pay')->leftJoin('salary_all','salary_all_pay.SALARYALL_ID','=','salary_all.SALARYALL_ID')->where('salary_all.SALARYALL_PERSON_ID','=',$iduser)->where('SALARYALL_PAY_YEAR','=',$yearbudget)->where('SALARYALL_PAY_MONTH','=',12)->sum('SALARYALL_PAY_AMOUNT');

        return view('person_compensation.dashboard',[
            'inforperson' => $inforperson,
            'inforpersonuser' => $inforpersonuser,
            'count1' => $count1,
            'count2' => $count2,
            'count3' => $count3,
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
            'm1_2' => $m1_2,
            'm2_2' => $m2_2,
            'm3_2' => $m3_2,
            'm4_2' => $m4_2,
            'm5_2' => $m5_2,
            'm6_2' => $m6_2,
            'm7_2' => $m7_2,
            'm8_2' => $m8_2,
            'm9_2' => $m9_2,
            'm10_2' => $m10_2,
            'm11_2' => $m11_2,
            'm12_2' => $m12_2,
            'budgets' =>  $budget,
            'yearbudget' => $yearbudget             
        ]);
    }



    public function cominfosalary(Request $request,$iduser)
    {

        $inforperson =  Person::where('ID','=',$iduser)->first();


        
        $inforpersonuser =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
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
        $year = date("Y")+544;
        }else{
        $year = date("Y")+543;
        }

   

        $infosalary = DB::table('salary_all_head')
        ->leftjoin('salary_all','salary_all.SALARYALL_HEAD_ID','=','salary_all_head.SALARYALL_HEAD_ID')
        ->where('SALARYALL_YEAR_ID','=',$year)
        ->where('SALARYALL_PERSON_ID','=',$iduser)
        ->orderBy('SALARYALL_MONTH_ID', 'asc')
        ->get();

        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        $checkyear = $year;
    
        return view('person_compensation.cominfosalary',[
            'inforperson' => $inforperson,
            'inforpersonuser' => $inforpersonuser,
            'infosalarys' => $infosalary,
            'budgets' => $budget,
            'checkyear' => $checkyear,
            
        ]);
    }

    
    public function cominfosalary_search(Request $request,$iduser)
    {

        $inforperson =  Person::where('ID','=',$iduser)->first();


        
        $inforpersonuser =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
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

        $year = $request->BUDGET_YEAR;

        $infosalary = DB::table('salary_all_head')
        ->leftjoin('salary_all','salary_all.SALARYALL_HEAD_ID','=','salary_all_head.SALARYALL_HEAD_ID')
        ->where('SALARYALL_YEAR_ID','=',$year)
        ->where('SALARYALL_PERSON_ID','=',$iduser)
        ->orderBy('SALARYALL_MONTH_ID', 'asc')
        ->get();

        
      $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
  
      $checkyear = $year;

    
        return view('person_compensation.cominfosalary',[
            'inforperson' => $inforperson,
            'inforpersonuser' => $inforpersonuser,
            'infosalarys' => $infosalary,
            'budgets' => $budget,
            'checkyear' => $checkyear,
            
        ]);
    }



    public function certificate(Request $request,$iduser)
    {

        $inforperson =  Person::where('ID','=',$iduser)->first();


        
        $inforpersonuser =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
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

        $inforSalarycertificate =  Salarycertificate::where('CER_HR_PERSON_ID','=',$iduser)->orderBy('CER_ID', 'DESC')->get();

        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;
        }

        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        $info_sendstatus = DB::table('salary_status')->get();

        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';
        $status = '';
        $search = '';
        $year_id = $yearbudget;

        return view('person_compensation.certificate',[
            'inforperson' => $inforperson,
            'inforpersonuser' => $inforpersonuser,
            'inforSalarycertificates' => $inforSalarycertificate,
            'info_sendstatuss' => $info_sendstatus,
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id, 
        ]);
    }



    public function searchcertificate(Request $request)
    {


        $iduser = $request->userid;
        $inforperson =  Person::where('ID','=',$iduser)->first();


        
        $inforpersonuser =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
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
    
    
            if($date_bigen_checks != $dates || $date_end_checks != $dates){
    
                $from = date($displaydate_bigen);
                $to = date($displaydate_end);
       
    if($status == null){


        $inforSalarycertificate =  Salarycertificate::where('CER_HR_PERSON_ID','=',$iduser)
            ->where('CER_YEAR','=',$yearbudget)
            ->where(function($q) use ($search){
                $q->where('CER_NUMBER','like','%'.$search.'%');
                $q->orwhere('CER_HR_DEP_SUB_SUB_NAME','like','%'.$search.'%');
                $q->orwhere('CER_COMMENT','like','%'.$search.'%');    
                $q->orwhere('CER_HR_PERSON_NAME','like','%'.$search.'%');    
            }) 
            ->WhereBetween('CER_DATE',[$from,$to])          
            ->orderBy('CER_ID', 'DESC')->get();

    }else{


        $inforSalarycertificate =  Salarycertificate::where('CER_HR_PERSON_ID','=',$iduser)
            ->where('CER_YEAR','=',$yearbudget)
            ->where('CER_STATUS','=',$status)
            ->where(function($q) use ($search){
            $q->where('CER_NUMBER','like','%'.$search.'%');
            $q->orwhere('CER_HR_DEP_SUB_SUB_NAME','like','%'.$search.'%');
            $q->orwhere('CER_COMMENT','like','%'.$search.'%');    
            $q->orwhere('CER_HR_PERSON_NAME','like','%'.$search.'%');    
        }) 
        ->WhereBetween('CER_DATE',[$from,$to])          
        ->orderBy('CER_ID', 'DESC')->get();

    }    

         }else{

        if($status == null){


            $inforSalarycertificate =  Salarycertificate::where('CER_HR_PERSON_ID','=',$iduser)
                ->where('CER_YEAR','=',$yearbudget)
                ->where(function($q) use ($search){
                $q->where('CER_NUMBER','like','%'.$search.'%');
                $q->orwhere('CER_HR_DEP_SUB_SUB_NAME','like','%'.$search.'%');
                $q->orwhere('CER_COMMENT','like','%'.$search.'%');    
                $q->orwhere('CER_HR_PERSON_NAME','like','%'.$search.'%');    
            })    
            ->orderBy('CER_ID', 'DESC')->get();

        }else{


            $inforSalarycertificate =  Salarycertificate::where('CER_HR_PERSON_ID','=',$iduser)
                ->where('CER_YEAR','=',$yearbudget)
                ->where('CER_STATUS','=',$status)
                ->where(function($q) use ($search){
                $q->where('CER_NUMBER','like','%'.$search.'%');
                $q->orwhere('CER_HR_DEP_SUB_SUB_NAME','like','%'.$search.'%');
                $q->orwhere('CER_COMMENT','like','%'.$search.'%');    
                $q->orwhere('CER_HR_PERSON_NAME','like','%'.$search.'%');    
            })    
            ->orderBy('CER_ID', 'DESC')->get();

        }

    }
       
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $info_sendstatus = DB::table('salary_status')->get();
        $year_id = $yearbudget;

        return view('person_compensation.certificate',[
            'inforperson' => $inforperson,
            'inforpersonuser' => $inforpersonuser,
            'inforSalarycertificates' => $inforSalarycertificate,
            'info_sendstatuss' => $info_sendstatus,
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id, 
        ]);
    }
   
    public function certificate_cancel(Request $request)
    {
      $id = $request->ID;
      $iduser = $request->iduser;
  
        $updatecertificate_cancel = Salarycertificate::find($id);
        $updatecertificate_cancel->CER_STATUS = 'CANCEL';
        $updatecertificate_cancel->save();
  
        return redirect()->route('compensation.certificate',[
            'iduser' => $iduser
        ]);
  
    }
    public function salaryslip_cancel(Request $request)
    {
      $id = $request->ID;
      $iduser = $request->iduser;
  
        $updatesalaryslip_cancel = Salaryslip::find($id);
        $updatesalaryslip_cancel->SLIP_STATUS = 'CANCEL';
        $updatesalaryslip_cancel->save();
  
        return redirect()->route('compensation.salaryslip',[
            'iduser' => $iduser
        ]);
  
    }
    public function borrow_cancel(Request $request)
    {
      $id = $request->ID;
      $iduser = $request->iduser;
  
        $updateborrow_cancel = Salaryborrow::find($id);
        $updateborrow_cancel->BORROW_STATUS = 'CANCEL';
        $updateborrow_cancel->save();
  
        return redirect()->route('compensation.borrow',[
            'iduser' => $iduser
        ]);
  
    }




    public function salaryslip(Request $request,$iduser)
    {

        $inforperson =  Person::where('ID','=',$iduser)->first();


        
        $inforpersonuser =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
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

    
        $inforSalaryslip =  Salaryslip::where('SLIP_HR_PERSON_ID','=',$iduser)->orderBy('SLIP_ID', 'DESC')->get();

        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;
        }

        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        $info_sendstatus = DB::table('salary_status')->get();

        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';
        $status = '';
        $search = '';
        $year_id = $yearbudget;

        return view('person_compensation.salaryslip',[
            'inforperson' => $inforperson,
            'inforpersonuser' => $inforpersonuser,
            'inforSalaryslips' => $inforSalaryslip,
            'info_sendstatuss' => $info_sendstatus,
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id, 
        ]);
    }



   
    public function searchsalaryslip(Request $request)
    {


        $iduser = $request->userid;
        $inforperson =  Person::where('ID','=',$iduser)->first();


        
        $inforpersonuser =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
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
    
    
            if($date_bigen_checks != $dates || $date_end_checks != $dates){
    
    
                $from = date($displaydate_bigen);
                $to = date($displaydate_end);
       
    if($status == null){

        $inforSalaryslip =  Salaryslip::where('SLIP_HR_PERSON_ID','=',$iduser)
        ->where('SLIP_YEAR','=',$yearbudget)
        ->where(function($q) use ($search){
            $q->where('SLIP_NUMBER','like','%'.$search.'%');
            $q->orwhere('SLIP_HR_DEP_SUB_SUB_NAME','like','%'.$search.'%');
            $q->orwhere('SLIP_COMMENT','like','%'.$search.'%');    
            $q->orwhere('SLIP_HR_PERSON_NAME','like','%'.$search.'%');    
        }) 
        ->WhereBetween('SLIP_DATE',[$from,$to])      
        ->orderBy('SLIP_ID', 'DESC')->get();


    }else{


        $inforSalaryslip =  Salaryslip::where('SLIP_HR_PERSON_ID','=',$iduser)
            ->where('SLIP_YEAR','=',$yearbudget)
            ->where('SLIP_STATUS','=',$status)
            ->where(function($q) use ($search){
            $q->where('SLIP_NUMBER','like','%'.$search.'%');
            $q->orwhere('SLIP_HR_DEP_SUB_SUB_NAME','like','%'.$search.'%');
            $q->orwhere('SLIP_COMMENT','like','%'.$search.'%');    
            $q->orwhere('SLIP_HR_PERSON_NAME','like','%'.$search.'%');    
        }) 
        ->WhereBetween('SLIP_DATE',[$from,$to])      
        ->orderBy('SLIP_ID', 'DESC')->get();


    }    



         }else{

        if($status == null){

            $inforSalaryslip =  Salaryslip::where('SLIP_HR_PERSON_ID','=',$iduser)
                ->where('SLIP_YEAR','=',$yearbudget)
                ->where(function($q) use ($search){
                $q->where('SLIP_NUMBER','like','%'.$search.'%');
                $q->orwhere('SLIP_HR_DEP_SUB_SUB_NAME','like','%'.$search.'%');
                $q->orwhere('SLIP_COMMENT','like','%'.$search.'%');    
                $q->orwhere('SLIP_HR_PERSON_NAME','like','%'.$search.'%');    
            }) 
            ->orderBy('SLIP_ID', 'DESC')->get();
    




        }else{

            $inforSalaryslip =  Salaryslip::where('SLIP_HR_PERSON_ID','=',$iduser)
                ->where('SLIP_YEAR','=',$yearbudget)
                ->where('SLIP_STATUS','=',$status)
                ->where(function($q) use ($search){
                $q->where('SLIP_NUMBER','like','%'.$search.'%');
                $q->orwhere('SLIP_HR_DEP_SUB_SUB_NAME','like','%'.$search.'%');
                $q->orwhere('SLIP_COMMENT','like','%'.$search.'%');    
                $q->orwhere('SLIP_HR_PERSON_NAME','like','%'.$search.'%');    
            })     
            ->orderBy('SLIP_ID', 'DESC')->get();
    

        

        }

    }
       
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $info_sendstatus = DB::table('salary_status')->get();
        $year_id = $yearbudget;

        return view('person_compensation.salaryslip',[
            'inforperson' => $inforperson,
            'inforpersonuser' => $inforpersonuser,
            'inforSalaryslips' => $inforSalaryslip,
            'info_sendstatuss' => $info_sendstatus,
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id, 
        ]);
    }




    public function borrow(Request $request,$iduser)
    {

        $inforperson =  Person::where('ID','=',$iduser)->first();
        
        $inforpersonuser =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
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

        $inforSalaryborrow =  Salaryborrow::where('BORROW_HR_PERSON_ID','=',$iduser)->orderBy('BORROW_ID', 'DESC')->get();

            $m_budget = date("m");
            if($m_budget>9){
            $yearbudget = date("Y")+544;
            }else{
            $yearbudget = date("Y")+543;
            }
    
            $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
    
            $info_sendstatus = DB::table('salary_borrow_status')->get();
    
            $displaydate_bigen = ($yearbudget-544).'-10-01';
            $displaydate_end = ($yearbudget-543).'-09-30';
            $status = '';
            $search = '';
        $year_id = $yearbudget;
    
        return view('person_compensation.borrow',[
            'inforperson' => $inforperson,
            'inforpersonuser' => $inforpersonuser,
            'inforSalaryborrows' => $inforSalaryborrow,
            'info_sendstatuss' => $info_sendstatus,
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id, 
        ]);
    }


    
   
    public function searchborrow(Request $request)
    {


        $iduser = $request->userid;
        $inforperson =  Person::where('ID','=',$iduser)->first();


        
        $inforpersonuser =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
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
    
    
            if($date_bigen_checks != $dates || $date_end_checks != $dates){
    
                $from = date($displaydate_bigen);
                $to = date($displaydate_end);
       
    if($status == null){


        $inforSalaryborrow =  Salaryborrow::where('BORROW_HR_PERSON_ID','=',$iduser)
        ->where('BORROW_YEAR','=',$yearbudget)
        ->where(function($q) use ($search){
            $q->where('BORROW_NUMBER','like','%'.$search.'%');
            $q->orwhere('BORROW_COMMENT','like','%'.$search.'%');
            $q->orwhere('BORROW_HR_DEP_SUB_SUB_NAME','like','%'.$search.'%');    
            $q->orwhere('BORROW_HR_PERSON_NAME','like','%'.$search.'%');    
        }) 
        ->WhereBetween('BORROW_DATE',[$from,$to])      
        ->orderBy('BORROW_ID', 'DESC')->get();


    }else{


        
        $inforSalaryborrow =  Salaryborrow::where('BORROW_HR_PERSON_ID','=',$iduser)
        ->where('BORROW_YEAR','=',$yearbudget)
        ->where('BORROW_STATUS','=',$status)
        ->where(function($q) use ($search){
            $q->where('BORROW_NUMBER','like','%'.$search.'%');
            $q->orwhere('BORROW_COMMENT','like','%'.$search.'%');
            $q->orwhere('BORROW_HR_DEP_SUB_SUB_NAME','like','%'.$search.'%');    
            $q->orwhere('BORROW_HR_PERSON_NAME','like','%'.$search.'%');    
        }) 
        ->WhereBetween('BORROW_DATE',[$from,$to])      
        ->orderBy('BORROW_ID', 'DESC')->get();


     

    }    




         }else{

        if($status == null){


               
        $inforSalaryborrow =  Salaryborrow::where('BORROW_HR_PERSON_ID','=',$iduser)
        ->where('BORROW_YEAR','=',$yearbudget)
        ->where(function($q) use ($search){
            $q->where('BORROW_NUMBER','like','%'.$search.'%');
            $q->orwhere('BORROW_COMMENT','like','%'.$search.'%');
            $q->orwhere('BORROW_HR_DEP_SUB_SUB_NAME','like','%'.$search.'%');    
            $q->orwhere('BORROW_HR_PERSON_NAME','like','%'.$search.'%');    
        })  
        ->orderBy('BORROW_ID', 'DESC')->get();


        }else{

               
        $inforSalaryborrow =  Salaryborrow::where('BORROW_HR_PERSON_ID','=',$iduser)
        ->where('BORROW_YEAR','=',$yearbudget)
        ->where('BORROW_STATUS','=',$status)
        ->where(function($q) use ($search){
            $q->where('BORROW_NUMBER','like','%'.$search.'%');
            $q->orwhere('BORROW_COMMENT','like','%'.$search.'%');
            $q->orwhere('BORROW_HR_DEP_SUB_SUB_NAME','like','%'.$search.'%');    
            $q->orwhere('BORROW_HR_PERSON_NAME','like','%'.$search.'%');    
        })      
        ->orderBy('BORROW_ID', 'DESC')->get();


        }

    }
       
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $info_sendstatus = DB::table('salary_borrow_status')->get();
        $year_id = $yearbudget;

        return view('person_compensation.borrow',[
            'inforperson' => $inforperson,
            'inforpersonuser' => $inforpersonuser,
            'inforSalaryborrows' => $inforSalaryborrow,
            'info_sendstatuss' => $info_sendstatus,
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id, 
        ]);
    }

   
   
    
     //------------------------ฟังชันรายละเอียดเงินเดือน---

     public function salarydetail(Request $request) { 

        $salaryallid = $request->id;

        $salary_all =  DB::table('salary_all')->where('SALARYALL_ID','=',$salaryallid)->first();
        $totalreceive =  DB::table('salary_all_receive')->where('SALARYALL_ID','=',$salaryallid)->sum('SALARYALL_RECEIVE_AMOUNT');                                     
        $totalpay =  DB::table('salary_all_pay')->where('SALARYALL_ID','=',$salaryallid)->sum('SALARYALL_PAY_AMOUNT');     


        if($salary_all->SALARYALL_TYPE == 'salary'){
            $typename = 'เงินเดือน';
        }else{
            $typename = 'ค่าตอบแทน';
        }
        $receivepersons =  DB::table('salary_all_receive')->where('SALARYALL_ID','=',$salaryallid)->get();                                     
        $paypersons =  DB::table('salary_all_pay')->where('SALARYALL_ID','=',$salaryallid)->get();     

        
  function MonthThai($strmonth)
  {
    $strMonth= $strmonth;
  
  
    $strMonthCut = Array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
    $strMonthThai=$strMonthCut[$strMonth];
    return "$strMonthThai";
    }

    if($salary_all->SALARYALL_MONTH_ID > 9){
        $infoyear = $salary_all->SALARYALL_YEAR_ID -1;
    }else{
        $infoyear =$salary_all->SALARYALL_YEAR_ID;
    }

        $output='    
        <div id="detailsalary" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl">
    <div class="modal-content">
    <div class="modal-header">
     
    <div class="row">
    
   
    <div><h4  style="font-family: \'Kanit\', sans-serif;">&nbsp;&nbsp;&nbsp;&nbsp;รายละเอียดรายรับ - รายจ่าย '.$salary_all->SALARYALL_PERSON_NAME.' วันที่ '.$salary_all->SALARYALL_DAY_ID.' '.MonthThai($salary_all->SALARYALL_MONTH_ID).' '.$infoyear.' ปีงบประมาณ '.$salary_all->SALARYALL_YEAR_ID.' ประเภท '.$typename.'</h4> </div>
     
    </div>
      </div>
        <div class="modal-body" >
     
        <div class="row">
        <div class="col-sm-6">    
                       รายรับ
                              <table class="table-bordered table-striped table-vcenter" style="width: 100%;font-size: 13px;" >
                                <thead style="background-color: #FFEBCD;">
                                <tr height="20">
                                <th  class="text-font" style="border-color:#F0FFFF;text-align: center;" width="5%">ลำดับ</th>
                                    <th  class="text-font" style="border-color:#F0FFFF;text-align: center;">รายละเอียด</th>
                                    <th  class="text-font" style="border-color:#F0FFFF;text-align: center;" width="15%">จำนวน</th>
                          
                              
                            
                                </tr >
                            </thead>';


                            $munber1 = 0;
                            foreach ($receivepersons as $receiveperson) {

                                if($receiveperson->SALARYALL_RECEIVE_AMOUNT !== '' && $receiveperson->SALARYALL_RECEIVE_AMOUNT !== null){
                                $munber1++;   
                                $output.=' <tr>
                                <td class="text-font  text-pedding" style="text-align: center;">'.$munber1.'</td>
                                <td class="text-font text-pedding" >'.$receiveperson->SALARYALL_RECEIVE_LISTNAME.'</td>
                                <td class="text-font text-pedding"  style="text-align: right;">'.number_format($receiveperson->SALARYALL_RECEIVE_AMOUNT,2).'</td>
                            </tr>';
                                }
                            }     

                            $output.='<tbody>     
                            
                       
                            </tbody>   
                            </table> 
       </div>                       
       <div class="col-sm-6">               
                     
                              &nbsp;&nbsp;รายจ่าย
                              <table class="table-bordered table-striped table-vcenter " style="width: 100%;font-size: 13px;" >
                              <thead style="background-color: #FFEBCD;">
                              <tr height="20">
                              <th  class="text-font" style="border-color:#F0FFFF;text-align: center;" width="5%">ลำดับ</th>
                                  <th  class="text-font" style="border-color:#F0FFFF;text-align: center;">รายละเอียด</th>
                                  <th  class="text-font" style="border-color:#F0FFFF;text-align: center;" width="15%">จำนวน</th>
                        
                      
                              </tr >
                          </thead>
                          <tbody>';  
                          $munber2 = 0;
                          foreach ($paypersons as $payperson) {
                              
                              if($payperson->SALARYALL_PAY_AMOUNT !== '' && $payperson->SALARYALL_PAY_AMOUNT !== null){  
                                $munber2++; 
                                $output.=' <tr>
                              <td class="text-font  text-pedding" style="text-align: center;">'.$munber2.'</td>
                              <td class="text-font text-pedding" >'.$payperson->SALARYALL_PAY_LISTNAME.'</td>
                              <td class="text-font text-pedding"  style="text-align: right;">'.number_format($payperson->SALARYALL_PAY_AMOUNT,2).'</td>
                          </tr>';
                          
                              }
                          }
                          
                            $output.='</tbody>   
                        </table>
        </div>  
        </div>
        <br> 

        <table class="table-bordered table-striped table-vcenter " style="width: 100%;font-size: 13px;" >
        <thead style="background-color: #F0F8FF;">
        <tr height="20">
            <th  class="text-font" style="border-color:#F0FFFF;text-align: center;">รวมรับ</th>
            <th  class="text-font" style="border-color:#F0FFFF;text-align: center;">รวมรับ</th>
            <th  class="text-font" style="border-color:#F0FFFF;text-align: center;">คงเหลือ</th>
  

        </tr >
    </thead>
    <tbody>  
          <tr>
              <td class="text-font text-pedding"  style="text-align: right;">'.number_format($totalreceive,2).'</td>
              <td class="text-font text-pedding"  style="text-align: right;">'.number_format($totalpay,2).'</td>
              <td class="text-font text-pedding"  style="text-align: right;">'.number_format($salary_all->SALARYALL_TOTAL,2).'</td>
          </tr>
      
    
    </tbody>   
  </table>

        <br>
<div class="modal-footer">

  <button type="button" class="btn btn-secondary" data-dismiss="modal"  style="font-family: \'Kanit\', sans-serif;">ปิดหน้าต่าง</button>
</div>
</div>
</div>
</div>
                
        ';
    
        echo $output;
}

public function certificate_add(Request $request,$iduser){

    $inforperson =  Person::where('ID','=',$iduser)->first();  

    $inforpersonuser =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
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

    $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
    $m_budget = date("m");
                if($m_budget>9){
                $yearbudget = date("Y")+544;
                }else{
                $yearbudget = date("Y")+543;
                }

  

                $year = date('Y');

                $maxnumber = DB::table('salary_certificate')->where('CER_YEAR','=',$yearbudget)->max('CER_ID');  
        
             
        
                if($maxnumber != '' ||  $maxnumber != null){
                    
                    $refmax = DB::table('salary_certificate')->where('CER_ID','=',$maxnumber)->first();  
        
        
                    if($refmax->CER_NUMBER != '' ||  $refmax->CER_NUMBER != null){
                        $maxref = substr($refmax->CER_NUMBER, -4)+1;
                     }else{
                        $maxref = 1;
                     }
        
                    $ref = str_pad($maxref, 5, "0", STR_PAD_LEFT);
               
                }else{
                    $ref = '000001';
                }
        
                $ye = date('Y')+543;
                $y = substr($ye, -2);
        
             $refnumber = 'CER'.$y.'-'.$ref;
        
     

    return view('person_compensation.certificate_add',[
        'budgets' =>  $budget,
        'inforperson' => $inforperson,
        'inforpersonuser' => $inforpersonuser, 
        'year_id'=>$yearbudget, 
        'refnumber'=>$refnumber,      
    ]);
}


public function infocertificate_save(Request $request)
{
    $CER_DATE= $request->CER_DATE;
  
    if($CER_DATE != ''){
        $STARTDAY = Carbon::createFromFormat('d/m/Y', $CER_DATE)->format('Y-m-d');
        $date_arrary_st=explode("-",$STARTDAY);
        $y_sub_st = $date_arrary_st[0];

        if($y_sub_st >= 2500){
            $y_st = $y_sub_st-543;
        }else{
            $y_st = $y_sub_st;
        }
        $m_st = $date_arrary_st[1];
        $d_st = $date_arrary_st[2];
        $CERDATE= $y_st."-".$m_st."-".$d_st;
        }else{
        $CERDATE= null;
    }

    $CER_HR_STARTWORK_DATE= $request->CER_HR_STARTWORK_DATE;
  
    if($CER_HR_STARTWORK_DATE != ''){
        $STARTDAY = Carbon::createFromFormat('d/m/Y', $CER_HR_STARTWORK_DATE)->format('Y-m-d');
        $date_arrary_st=explode("-",$STARTDAY);
        $y_sub_st = $date_arrary_st[0];

        if($y_sub_st >= 2500){
            $y_st = $y_sub_st-543;
        }else{
            $y_st = $y_sub_st;
        }
        $m_st = $date_arrary_st[1];
        $d_st = $date_arrary_st[2];
        $CERHRSTARTWORK_DATE= $y_st."-".$m_st."-".$d_st;
        }else{
        $CERHRSTARTWORK_DATE= null;
    }


    $addcertificate= new Salarycertificate(); 
    $addcertificate->CER_NUMBER = $request->CER_NUMBER;
    $addcertificate->CER_DATE = $CERDATE;
    $addcertificate->CER_YEAR = $request->CER_YEAR;
    $addcertificate->CER_HR_PERSON_ID = $request->CER_HR_PERSON_ID;
    $addcertificate->CER_HR_PERSON_NAME = $request->CER_HR_PERSON_NAME;
    $addcertificate->CER_HR_DEP_SUB_SUB_NAME = $request->CER_HR_DEP_SUB_SUB_NAME;
    $addcertificate->CER_COMMENT = $request->CER_COMMENT;

    $addcertificate->CER_MY_HR_PERSON_ID = $request->CER_HR_PERSON_ID;
    $addcertificate->CER_MY_HR_PERSON_NAME = $request->CER_HR_PERSON_NAME;
    $addcertificate->CER_POSITION_IN_WORK = $request->CER_POSITION_IN_WORK;
    $addcertificate->CER_BORROW_MONEY = $request->CER_BORROW_MONEY;
    $addcertificate->CER_HR_STARTWORK_DATE = $CERHRSTARTWORK_DATE;
    $addcertificate->CER_HR_LEVEL_NAME = $request->CER_HR_LEVEL_NAME;

    $addcertificate->CER_HR_SALARY = $request->CER_HR_SALARY;
    $addcertificate->CER_MONEY_POSITION = $request->CER_MONEY_POSITION;
    $addcertificate->CER_STATUS = 'REQUEST';

    $addcertificate->save();


    return redirect()->route('compensation.certificate',['iduser'=>$request->CER_HR_PERSON_ID]);
}

public function certificate_edit(Request $request,$id,$iduser){
    $inforperson =  Person::where('ID','=',$iduser)->first();  


    $inforpersonuser =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
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

    $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
    $m_budget = date("m");
                if($m_budget>9){
                $yearbudget = date("Y")+544;
                }else{
                $yearbudget = date("Y")+543;
                }
    $inforSalarycertificate =  Salarycertificate::where('CER_ID','=',$id)->first();

    return view('person_compensation.certificate_edit',[
        'budgets' =>  $budget,
        'inforperson' => $inforperson,
        'inforpersonuser' => $inforpersonuser, 
        'inforSalarycertificate' => $inforSalarycertificate, 
        'year_id'=>$yearbudget       
    ]);
}

public function certificate_update(Request $request)    {  
    $CER_DATE= $request->CER_DATE;
  
    if($CER_DATE != ''){
        $STARTDAY = Carbon::createFromFormat('d/m/Y', $CER_DATE)->format('Y-m-d');
        $date_arrary_st=explode("-",$STARTDAY);
        $y_sub_st = $date_arrary_st[0];

        if($y_sub_st >= 2500){
            $y_st = $y_sub_st-543;
        }else{
            $y_st = $y_sub_st;
        }
        $m_st = $date_arrary_st[1];
        $d_st = $date_arrary_st[2];
        $CERDATE= $y_st."-".$m_st."-".$d_st;
        }else{
        $CERDATE= null;
    }

    $CER_HR_STARTWORK_DATE= $request->CER_HR_STARTWORK_DATE;
  
    if($CER_HR_STARTWORK_DATE != ''){
        $STARTDAY = Carbon::createFromFormat('d/m/Y', $CER_HR_STARTWORK_DATE)->format('Y-m-d');
        $date_arrary_st=explode("-",$STARTDAY);
        $y_sub_st = $date_arrary_st[0];

        if($y_sub_st >= 2500){
            $y_st = $y_sub_st-543;
        }else{
            $y_st = $y_sub_st;
        }
        $m_st = $date_arrary_st[1];
        $d_st = $date_arrary_st[2];
        $CERHRSTARTWORK_DATE= $y_st."-".$m_st."-".$d_st;
        }else{
        $CERHRSTARTWORK_DATE= null;
    }

    $id = $request->CER_ID;

    $update = Salarycertificate::find($id);
    $update->CER_NUMBER = $request->CER_NUMBER;
    $update->CER_DATE = $CERDATE;
    $update->CER_YEAR = $request->CER_YEAR;
    $update->CER_HR_PERSON_ID = $request->CER_HR_PERSON_ID;
    $update->CER_HR_PERSON_NAME = $request->CER_HR_PERSON_NAME;
    $update->CER_HR_DEP_SUB_SUB_NAME = $request->CER_HR_DEP_SUB_SUB_NAME;
    $update->CER_COMMENT = $request->CER_COMMENT;

    $update->CER_MY_HR_PERSON_ID = $request->CER_HR_PERSON_ID;
    $update->CER_MY_HR_PERSON_NAME = $request->CER_HR_PERSON_NAME;
    $update->CER_POSITION_IN_WORK = $request->CER_POSITION_IN_WORK;
    $update->CER_BORROW_MONEY = $request->CER_BORROW_MONEY;
    $update->CER_HR_STARTWORK_DATE = $CERHRSTARTWORK_DATE;
    $update->CER_HR_LEVEL_NAME = $request->CER_HR_LEVEL_NAME;

    $update->CER_HR_SALARY = $request->CER_HR_SALARY;
    $update->CER_MONEY_POSITION = $request->CER_MONEY_POSITION;
    $update->save(); 

    $id_user = $request->CER_HR_PERSON_ID;

    return redirect()->route('compensation.certificate',[
        'iduser'=> $id_user
    ]);

}



public function salaryslip_add(Request $request,$iduser){

    $inforperson =  Person::where('ID','=',$iduser)->first();        
    $inforpersonuser =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
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

    $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
    $m_budget = date("m");
                if($m_budget>9){
                $yearbudget = date("Y")+544;
                }else{
                $yearbudget = date("Y")+543;
                }


                $year = date('Y');

                $maxnumber = DB::table('salary_slip')->where('SLIP_YEAR','=',$yearbudget)->max('SLIP_ID');  
        
             
        
                if($maxnumber != '' ||  $maxnumber != null){
                    
                    $refmax = DB::table('salary_slip')->where('SLIP_ID','=',$maxnumber)->first();  
        
        
                    if($refmax->SLIP_NUMBER != '' ||  $refmax->SLIP_NUMBER != null){
                        $maxref = substr($refmax->SLIP_NUMBER, -4)+1;
                     }else{
                        $maxref = 1;
                     }
        
                    $ref = str_pad($maxref, 5, "0", STR_PAD_LEFT);
               
                }else{
                    $ref = '000001';
                }
        
                $ye = date('Y')+543;
                $y = substr($ye, -2);
        
             $refnumber = 'SLI'.$y.'-'.$ref;


    return view('person_compensation.salaryslip_add',[
        'budgets' =>  $budget,
        'inforperson' => $inforperson,
        'inforpersonuser' => $inforpersonuser,   
        'year_id'=>$yearbudget,
        'refnumber'=>$refnumber           
    ]);
}

public function infosalaryslip_save(Request $request)
{
    $SLIP_DATE= $request->SLIP_DATE;
  
    if($SLIP_DATE != ''){
        $STARTDAY = Carbon::createFromFormat('d/m/Y', $SLIP_DATE)->format('Y-m-d');
        $date_arrary_st=explode("-",$STARTDAY);
        $y_sub_st = $date_arrary_st[0];

        if($y_sub_st >= 2500){
            $y_st = $y_sub_st-543;
        }else{
            $y_st = $y_sub_st;
        }
        $m_st = $date_arrary_st[1];
        $d_st = $date_arrary_st[2];
        $SLIPDATE= $y_st."-".$m_st."-".$d_st;
        }else{
        $SLIPDATE= null;
    }


    $add_slip = new Salaryslip(); 
    $add_slip->SLIP_NUMBER = $request->SLIP_NUMBER;
    $add_slip->SLIP_DATE = $SLIPDATE;
    $add_slip->SLIP_MONTH = $request->SLIP_MONTH;
    $add_slip->SLIP_YEAR = $request->SLIP_YEAR;
    $add_slip->SLIP_HR_PERSON_ID = $request->SLIP_HR_PERSON_ID;
    $add_slip->SLIP_HR_PERSON_NAME = $request->SLIP_HR_PERSON_NAME;
    $add_slip->SLIP_HR_DEP_SUB_SUB_NAME = $request->SLIP_HR_DEP_SUB_SUB_NAME;
    $add_slip->SLIP_COMMENT = $request->SLIP_COMMENT;

    $add_slip->SLIP_MY_HR_PERSON_ID = $request->SLIP_MY_HR_PERSON_ID;
    $add_slip->SLIP_MY_HR_PERSON_NAME = $request->SLIP_MY_HR_PERSON_NAME;
    $add_slip->SLIP_MOUNT = $request->SLIP_MOUNT;
    $add_slip->SLIP_POSITION_IN_WORK = $request->SLIP_POSITION_IN_WORK;
    $add_slip->SLIP_HR_LEVEL_NAME = $request->SLIP_HR_LEVEL_NAME;
  
    $add_slip->SLIP_TEL = $request->SLIP_TEL;
    $add_slip->SLIP_STATUS = 'REQUEST';
     
    $add_slip->save();


    return redirect()->route('compensation.salaryslip',['iduser'=>$request->SLIP_HR_PERSON_ID]);
}

public function salaryslip_edit(Request $request,$id,$iduser){
    $inforperson =  Person::where('ID','=',$iduser)->first();  


    $inforpersonuser =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
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

    $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
    $m_budget = date("m");
                if($m_budget>9){
                $yearbudget = date("Y")+544;
                }else{
                $yearbudget = date("Y")+543;
                }
    
    $inforSalaryslip =  Salaryslip::where('SLIP_ID','=',$id)->first();

    return view('person_compensation.salaryslip_edit',[
        'budgets' =>  $budget,
        'inforperson' => $inforperson,
        'inforpersonuser' => $inforpersonuser, 
        'inforSalaryslip' => $inforSalaryslip, 
        'year_id'=>$yearbudget       
    ]);
}

public function salaryslip_update(Request $request)    {  

    $SLIP_DATE= $request->SLIP_DATE;
  
    if($SLIP_DATE != ''){
        $STARTDAY = Carbon::createFromFormat('d/m/Y', $SLIP_DATE)->format('Y-m-d');
        $date_arrary_st=explode("-",$STARTDAY);
        $y_sub_st = $date_arrary_st[0];

        if($y_sub_st >= 2500){
            $y_st = $y_sub_st-543;
        }else{
            $y_st = $y_sub_st;
        }
        $m_st = $date_arrary_st[1];
        $d_st = $date_arrary_st[2];
        $SLIPDATE= $y_st."-".$m_st."-".$d_st;
        }else{
        $SLIPDATE= null;
    }

    $SLIP_START_DATE= $request->SLIP_START_DATE;
  
    if($SLIP_START_DATE != ''){
        $STARTDAY = Carbon::createFromFormat('d/m/Y', $SLIP_START_DATE)->format('Y-m-d');
        $date_arrary_st=explode("-",$STARTDAY);
        $y_sub_st = $date_arrary_st[0];

        if($y_sub_st >= 2500){
            $y_st = $y_sub_st-543;
        }else{
            $y_st = $y_sub_st;
        }
        $m_st = $date_arrary_st[1];
        $d_st = $date_arrary_st[2];
        $SLIPSTARTDATE= $y_st."-".$m_st."-".$d_st;
        }else{
        $SLIPSTARTDATE= null;
    }
    
    $SLIP_END_DATE= $request->SLIP_END_DATE;
  
    if($SLIP_END_DATE != ''){
        $STARTDAY = Carbon::createFromFormat('d/m/Y', $SLIP_END_DATE)->format('Y-m-d');
        $date_arrary_st=explode("-",$STARTDAY);
        $y_sub_st = $date_arrary_st[0];

        if($y_sub_st >= 2500){
            $y_st = $y_sub_st-543;
        }else{
            $y_st = $y_sub_st;
        }
        $m_st = $date_arrary_st[1];
        $d_st = $date_arrary_st[2];
        $SLIPENDDATE= $y_st."-".$m_st."-".$d_st;
        }else{
        $SLIPENDDATE= null;
    }

    $id = $request->SLIP_ID;

    $update = Salaryslip::find($id);
    $update->SLIP_NUMBER = $request->SLIP_NUMBER;
    $update->SLIP_DATE = $SLIPDATE;
    $update->SLIP_YEAR = $request->SLIP_YEAR;
    $update->SLIP_MY_HR_PERSON_NAME = $request->SLIP_MY_HR_PERSON_NAME;
    $update->SLIP_POSITION_IN_WORK = $request->SLIP_POSITION_IN_WORK;
    $update->SLIP_HR_LEVEL_NAME = $request->SLIP_HR_LEVEL_NAME;
    $update->SLIP_MOUNT = $request->SLIP_MOUNT;
    $update->SLIP_START_DATE = $SLIPSTARTDATE;
    $update->SLIP_END_DATE = $SLIPENDDATE;
    $update->SLIP_TEL = $request->SLIP_TEL;
    $update->SLIP_COMMENT = $request->SLIP_COMMENT;
    $update->SLIP_HR_DEP_SUB_SUB_NAME = $request->SLIP_HR_DEP_SUB_SUB_NAME;


    $update->save(); 

    $id_user = $request->SLIP_HR_PERSON_ID;

    return redirect()->route('compensation.salaryslip',[
        'iduser'=> $id_user
    ]);

}


public function borrow_add(Request $request,$iduser){

    $inforperson =  Person::where('ID','=',$iduser)->first();        
    $inforpersonuser =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
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

    $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
    $m_budget = date("m");
                if($m_budget>9){
                $yearbudget = date("Y")+544;
                }else{
                $yearbudget = date("Y")+543;
                }

    $grecord_money = DB::table('grecord_money_set')->get();   
    
    $infoorg = DB::table('info_org')->where('ORG_ID','=',1)->first();  

    $ORG_NAME = $infoorg->ORG_NAME;

    $year = date('Y');

    $maxnumber = DB::table('salary_borrow')->where('BORROW_YEAR','=',$yearbudget)->max('BORROW_ID');  

 

    if($maxnumber != '' ||  $maxnumber != null){
        
        $refmax = DB::table('salary_borrow')->where('BORROW_ID','=',$maxnumber)->first();  


        if($refmax->BORROW_NUMBER != '' ||  $refmax->BORROW_NUMBER != null){
            $maxref = substr($refmax->BORROW_NUMBER, -4)+1;
         }else{
            $maxref = 1;
         }

        $ref = str_pad($maxref, 5, "0", STR_PAD_LEFT);
   
    }else{
        $ref = '000001';
    }

    $ye = date('Y')+543;
    $y = substr($ye, -2);
    //$m = date('m');
    // = date('d');

 $refnumber = 'BOR'.$y.'-'.$ref;


 $year = date('Y')+543;

 $book =  DB::table('gbook_index')
 ->select('BOOK_NAME','BOOK_NUMBER','BOOK_DATE','BOOK_ID')
 ->where('BOOK_YEAR_ID','=',$year)
 ->orderBy('gbook_index.BOOK_ID', 'desc') 
 ->get();

    return view('person_compensation.borrow_add',[
        'budgets' =>  $budget,
        'inforperson' => $inforperson,
        'inforpersonuser' => $inforpersonuser,
        'year_id'=>$yearbudget,
        'grecord_moneys'=>$grecord_money,
        'refnumber'=>$refnumber,   
        'books'=>$book,  
        'ORG_NAME' => $ORG_NAME            
    ]);
}  
public function borrow_edit(Request $request,$id,$iduser){
  
    $inforperson =  Person::where('ID','=',$iduser)->first(); 

    $inforpersonuser =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
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

    $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
    $m_budget = date("m");
                if($m_budget>9){
                $yearbudget = date("Y")+544;
                }else{
                $yearbudget = date("Y")+543;
                }
    $grecord_money = DB::table('grecord_money_set')->get(); 

    $inforSalaryborrow =  Salaryborrow::where('BORROW_ID','=',$id)->first();
    
     $infomation_nomal = Salaryborrowsub::where('BORROW_SUB_GROUP','=','NORMAL')->where('BORROW_ID','=',$id)->get();
     $check_nomal = Salaryborrowsub::where('BORROW_SUB_GROUP','=','NORMAL')->where('BORROW_ID','=',$id)->count();

     $infomation_other = Salaryborrowsub::where('BORROW_SUB_GROUP','=','OTHER')->where('BORROW_ID','=',$id)->get();
     $check_other = Salaryborrowsub::where('BORROW_SUB_GROUP','=','OTHER')->where('BORROW_ID','=',$id)->count(); 
       
     
 $year = date('Y')+543;

 $book =  DB::table('gbook_index')
 ->select('BOOK_NAME','BOOK_NUMBER','BOOK_DATE','BOOK_ID')
 ->where('BOOK_YEAR_ID','=',$year)
 ->orderBy('gbook_index.BOOK_ID', 'desc') 
 ->get();


    return view('person_compensation.borrow_edit',[
        'budgets' =>  $budget,
        'inforperson' => $inforperson,
        'inforpersonuser' => $inforpersonuser, 
        'inforSalaryborrow' => $inforSalaryborrow, 
        'infomation_nomals' => $infomation_nomal, 
        'infomation_others' => $infomation_other, 
        'check_nomal' => $check_nomal,
        'check_other' => $check_other,
        'year_id'=>$yearbudget ,
        'books'=>$book ,
        'grecord_moneys'=>$grecord_money          
    ]);
}



public function infoborrow_save(Request $request)
{
    $BORROW_DATE= $request->BORROW_DATE;
    $BORROWSTART_DATE= $request->BORROW_START_DATE;
    $BORROWEND_DATE= $request->BORROW_END_DATE;
  
  
    if($BORROW_DATE != ''){
        $STARTDAY = Carbon::createFromFormat('d/m/Y', $BORROW_DATE)->format('Y-m-d');
        $date_arrary_st=explode("-",$STARTDAY);
        $y_sub_st = $date_arrary_st[0];

        if($y_sub_st >= 2500){
            $y_st = $y_sub_st-543;
        }else{
            $y_st = $y_sub_st;
        }
        $m_st = $date_arrary_st[1];
        $d_st = $date_arrary_st[2];
        $BORROWDATE= $y_st."-".$m_st."-".$d_st;
        }else{
        $BORROWDATE= null;
    }

    if($BORROWSTART_DATE != ''){
        $STARTDAY = Carbon::createFromFormat('d/m/Y', $BORROWSTART_DATE)->format('Y-m-d');
        $date_arrary_st=explode("-",$STARTDAY);
        $y_sub_st = $date_arrary_st[0];

        if($y_sub_st >= 2500){
            $y_st = $y_sub_st-543;
        }else{
            $y_st = $y_sub_st;
        }
        $m_st = $date_arrary_st[1];
        $d_st = $date_arrary_st[2];
        $BORROWSTARTDATE= $y_st."-".$m_st."-".$d_st;
        }else{
        $BORROWSTARTDATE= null;
    }

    if($BORROWEND_DATE != ''){
        $STARTDAY = Carbon::createFromFormat('d/m/Y', $BORROWEND_DATE)->format('Y-m-d');
        $date_arrary_st=explode("-",$STARTDAY);
        $y_sub_st = $date_arrary_st[0];

        if($y_sub_st >= 2500){
            $y_st = $y_sub_st-543;
        }else{
            $y_st = $y_sub_st;
        }
        $m_st = $date_arrary_st[1];
        $d_st = $date_arrary_st[2];
        $BORROWENDDATE= $y_st."-".$m_st."-".$d_st;
        }else{
        $BORROWENDDATE= null;
    }


    
    $addborrow= new Salaryborrow(); 
    $addborrow->BORROW_NUMBER = $request->BORROW_NUMBER;
    $addborrow->BORROW_DATE = $BORROWDATE;
    $addborrow->BORROW_YEAR = $request->BORROW_YEAR;
    $addborrow->BORROW_HR_PERSON_ID = $request->BORROW_HR_PERSON_ID;
    $addborrow->BORROW_HR_PERSON_NAME = $request->BORROW_HR_PERSON_NAME;
    $addborrow->BORROW_HR_DEP_SUB_SUB_NAME = $request->BORROW_HR_DEP_SUB_SUB_NAME;
    $addborrow->BORROW_COMMENT = $request->BORROW_COMMENT;

    $addborrow->BORROW_TYPE_MONEY = $request->BORROW_TYPE_MONEY;
    $addborrow->BORROW_LOCATION = $request->BORROW_LOCATION;
    $addborrow->BORROW_TIME = $request->BORROW_TIME;
    $addborrow->BORROW_MY_HR_PERSON_NAME = $request->BORROW_MY_HR_PERSON_NAME;
    $addborrow->BORROW_POSITION_IN_WORK = $request->BORROW_POSITION_IN_WORK;
    $addborrow->BORROW_GOVERNMENT_BOOK = $request->BORROW_GOVERNMENT_BOOK;
    $addborrow->BORROW_GOVERNMENT_GO = $request->BORROW_GOVERNMENT_GO;
    $addborrow->BORROW_START_DATE = $BORROWSTARTDATE;
    $addborrow->BORROW_END_DATE = $BORROWENDDATE;
    $addborrow->BORROW_DATE_AMOUNT = $request->BORROW_DATE_AMOUNT;
    $addborrow->BORROW_AFFILIATION = $request->BORROW_AFFILIATION;
    $addborrow->BORROW_FUND = $request->BORROW_FUND;
    $addborrow->BORROW_PROVINCE = $request->BORROW_PROVINCE;
    $addborrow->BORROW_STATUS = 'REQUEST';
    $addborrow->save();



    $idborrow = Salaryborrow::max('BORROW_ID'); 
    
    

    $BORROW_SUB_TYPE = $request->BORROW_SUB_TYPE;
    $BORROW_SUB_PICE = $request->BORROW_SUB_PICE;  

    $number =count($BORROW_SUB_TYPE);
    $count = 0;
    for($count = 0; $count < $number; $count++)
    {       
       $moneyname = DB::table('grecord_money_set')->where('MONEY_ID','=',$BORROW_SUB_TYPE[$count])->first();    
      
       
       
       $add_borrowsub = new Salaryborrowsub();
       $add_borrowsub->BORROW_ID = $idborrow;


       $add_borrowsub->BORROW_SUB_TYPE = $BORROW_SUB_TYPE[$count];
       $add_borrowsub->BORROW_SUB_NAME = $moneyname->MONEY_NAME;      
       $add_borrowsub->BORROW_SUB_GROUP = "NORMAL";
       $add_borrowsub->BORROW_SUB_PICE = $BORROW_SUB_PICE[$count];
       $add_borrowsub->save(); 

    }
    //===========================Tap 2=== ตารางที่ 2 =================================//

    $idborrow = Salaryborrow::max('BORROW_ID');  //==== นับ ID ต่อจากตัวที่มากที่สุด =====//

    $BORROW_SUB_TYPE2 = $request->BORROW_SUB_TYPE2;
    $BORROW_SUB_PICE2 = $request->BORROW_SUB_PICE2;  

    $number_2 =count($BORROW_SUB_TYPE2);
    $count_2 = 0;
    for($count_2 = 0; $count_2 < $number_2; $count_2++)
    {       
   
       $add_borrowsub = new Salaryborrowsub();
       $add_borrowsub->BORROW_ID = $idborrow;
       $add_borrowsub->BORROW_SUB_NAME = $BORROW_SUB_TYPE2[$count_2];    
       $add_borrowsub->BORROW_SUB_GROUP = "OTHER";
       $add_borrowsub->BORROW_SUB_PICE = $BORROW_SUB_PICE2[$count_2];
       $add_borrowsub->save(); 

    }
//=======================================================================//

    return redirect()->route('compensation.borrow',['iduser'=>$request->BORROW_HR_PERSON_ID]);
}


public function borrow_update(Request $request)
{
    $BORROW_DATE= $request->BORROW_DATE;
    $BORROWSTART_DATE= $request->BORROW_START_DATE;
    $BORROWEND_DATE= $request->BORROW_END_DATE;
  
  
    if($BORROW_DATE != ''){
        $STARTDAY = Carbon::createFromFormat('d/m/Y', $BORROW_DATE)->format('Y-m-d');
        $date_arrary_st=explode("-",$STARTDAY);
        $y_sub_st = $date_arrary_st[0];

        if($y_sub_st >= 2500){
            $y_st = $y_sub_st-543;
        }else{
            $y_st = $y_sub_st;
        }
        $m_st = $date_arrary_st[1];
        $d_st = $date_arrary_st[2];
        $BORROWDATE= $y_st."-".$m_st."-".$d_st;
        }else{
        $BORROWDATE= null;
    }

    if($BORROWSTART_DATE != ''){
        $STARTDAY = Carbon::createFromFormat('d/m/Y', $BORROWSTART_DATE)->format('Y-m-d');
        $date_arrary_st=explode("-",$STARTDAY);
        $y_sub_st = $date_arrary_st[0];

        if($y_sub_st >= 2500){
            $y_st = $y_sub_st-543;
        }else{
            $y_st = $y_sub_st;
        }
        $m_st = $date_arrary_st[1];
        $d_st = $date_arrary_st[2];
        $BORROWSTARTDATE= $y_st."-".$m_st."-".$d_st;
        }else{
        $BORROWSTARTDATE= null;
    }

    if($BORROWEND_DATE != ''){
        $STARTDAY = Carbon::createFromFormat('d/m/Y', $BORROWEND_DATE)->format('Y-m-d');
        $date_arrary_st=explode("-",$STARTDAY);
        $y_sub_st = $date_arrary_st[0];

        if($y_sub_st >= 2500){
            $y_st = $y_sub_st-543;
        }else{
            $y_st = $y_sub_st;
        }
        $m_st = $date_arrary_st[1];
        $d_st = $date_arrary_st[2];
        $BORROWENDDATE= $y_st."-".$m_st."-".$d_st;
        }else{
        $BORROWENDDATE= null;
    }

    $idref = $request->BORROWID;
    
    $updateborrow=  Salaryborrow::find($idref); 
    $updateborrow->BORROW_NUMBER = $request->BORROW_NUMBER;
    $updateborrow->BORROW_DATE = $BORROWDATE;
    $updateborrow->BORROW_YEAR = $request->BORROW_YEAR;
    $updateborrow->BORROW_HR_PERSON_ID = $request->BORROW_HR_PERSON_ID;
    $updateborrow->BORROW_HR_PERSON_NAME = $request->BORROW_HR_PERSON_NAME;
    $updateborrow->BORROW_HR_DEP_SUB_SUB_NAME = $request->BORROW_HR_DEP_SUB_SUB_NAME;
    $updateborrow->BORROW_COMMENT = $request->BORROW_COMMENT;

    $updateborrow->BORROW_TYPE_MONEY = $request->BORROW_TYPE_MONEY;
    $updateborrow->BORROW_LOCATION = $request->BORROW_LOCATION;
    $updateborrow->BORROW_TIME = $request->BORROW_TIME;
    $updateborrow->BORROW_MY_HR_PERSON_NAME = $request->BORROW_MY_HR_PERSON_NAME;
    $updateborrow->BORROW_POSITION_IN_WORK = $request->BORROW_POSITION_IN_WORK;
    $updateborrow->BORROW_GOVERNMENT_BOOK = $request->BORROW_GOVERNMENT_BOOK;
    $updateborrow->BORROW_GOVERNMENT_GO = $request->BORROW_GOVERNMENT_GO;
    $updateborrow->BORROW_START_DATE = $BORROWSTARTDATE;
    $updateborrow->BORROW_END_DATE = $BORROWENDDATE;
    $updateborrow->BORROW_DATE_AMOUNT = $request->BORROW_DATE_AMOUNT;
    $updateborrow->BORROW_AFFILIATION = $request->BORROW_AFFILIATION;
    $updateborrow->BORROW_FUND = $request->BORROW_FUND;
    $updateborrow->BORROW_PROVINCE = $request->BORROW_PROVINCE;
    $updateborrow->save();



    $idborrow = $idref; 
    

    Salaryborrowsub::where('BORROW_ID','=',$idborrow)->delete(); 

    $BORROW_SUB_TYPE = $request->BORROW_SUB_TYPE;
    $BORROW_SUB_PICE = $request->BORROW_SUB_PICE;  

    $number =count($BORROW_SUB_TYPE);
    $count = 0;
    for($count = 0; $count < $number; $count++)
    {       
       $moneyname = DB::table('grecord_money_set')->where('MONEY_ID','=',$BORROW_SUB_TYPE[$count])->first();    
      
       
       
       $add_borrowsub = new Salaryborrowsub();
       $add_borrowsub->BORROW_ID = $idborrow;


       $add_borrowsub->BORROW_SUB_TYPE = $BORROW_SUB_TYPE[$count];
       $add_borrowsub->BORROW_SUB_NAME = $moneyname->MONEY_NAME;      
       $add_borrowsub->BORROW_SUB_GROUP = "NORMAL";
       $add_borrowsub->BORROW_SUB_PICE = $BORROW_SUB_PICE[$count];
       $add_borrowsub->save(); 

    }
    //===========================Tap 2=== ตารางที่ 2 =================================//

   

    $BORROW_SUB_TYPE2 = $request->BORROW_SUB_TYPE2;
    $BORROW_SUB_PICE2 = $request->BORROW_SUB_PICE2;  

    $number_2 =count($BORROW_SUB_TYPE2);
    $count_2 = 0;
    for($count_2 = 0; $count_2 < $number_2; $count_2++)
    {       
   
       $add_borrowsub = new Salaryborrowsub();
       $add_borrowsub->BORROW_ID = $idborrow;
       $add_borrowsub->BORROW_SUB_NAME = $BORROW_SUB_TYPE2[$count_2];    
       $add_borrowsub->BORROW_SUB_GROUP = "OTHER";
       $add_borrowsub->BORROW_SUB_PICE = $BORROW_SUB_PICE2[$count_2];
       $add_borrowsub->save(); 

    }
    //=======================================================================//

    return redirect()->route('compensation.borrow',['iduser'=>$request->BORROW_HR_PERSON_ID]);
}








public function borrowapp(Request $request,$iduser)
{
    $inforperson =  Person::where('ID','=',$iduser)->first();
    
    $inforpersonuser =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
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

    $inforSalaryborrow =  Salaryborrow::orderBy('BORROW_ID', 'DESC')->get();

    $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
    $m_budget = date("m");
                if($m_budget>9){
                $yearbudget = date("Y")+544;
                }else{
                $yearbudget = date("Y")+543;
                }

    return view('person_compensation.borrowapp',[
        'inforperson' => $inforperson,
        'inforpersonuser' => $inforpersonuser,
        'inforSalaryborrows' => $inforSalaryborrow,
        'budgets' => $budget,
        'year_id'=>$yearbudget,
    ]);
}

public function borrowlastapp(Request $request,$iduser)
{
    $inforperson =  Person::where('ID','=',$iduser)->first();
    
    $inforpersonuser =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
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

    $inforSalaryborrow =  Salaryborrow::orderBy('BORROW_ID', 'DESC')->get();

    $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
    $m_budget = date("m");
                if($m_budget>9){
                $yearbudget = date("Y")+544;
                }else{
                $yearbudget = date("Y")+543;
                }

    return view('person_compensation.borrowlastapp',[
        'inforperson' => $inforperson,
        'inforpersonuser' => $inforpersonuser,
        'inforSalaryborrows' => $inforSalaryborrow,
        'budgets' => $budget,
        'year_id'=>$yearbudget,
    ]);
}



public function borrow_send(Request $request,$id,$iduser){
  

    $date = date("Y/m/d");

    $update = Salaryborrow::find($id);
    $update->BORROW_STATUS = 'SENDMON';
    $update->BORROW_BACK_DATE = $date;
    $update->save(); 
   
    
    return redirect()->route('compensation.borrow',[
        'iduser' =>  $iduser
    ]);
}


public function selectbooknum_check(Request $request)
{
 
    $detail = DB::table('gbook_index')->where('BOOK_ID','=',$request->book_id)->first();

    $output='<input name="BORROW_GOVERNMENT_BOOK" id="BORROW_GOVERNMENT_BOOK" class="form-control input-lg" style=" font-family: \'Kanit\', sans-serif;"  value="'.$detail->BOOK_NUMBER.'" readonly>';

     
    echo $output;

}


}

