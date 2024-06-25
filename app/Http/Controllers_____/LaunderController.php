<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Person;
use App\Models\Hrddepartment;
use App\Models\Hrddepartmentsub;
use App\Models\Hrddepartmentsubsub;
use App\Models\Level;
use App\Models\Hrdstatus;
use App\Models\Hrdkind;
use App\Models\Hrdkindtype;
use App\Models\Hrdpersontype;
use App\Models\Team;
use App\Models\Teamlist;
use App\Models\Teamposition;
use App\Models\Launderwithdrow;
use App\Models\Launderwithdrowsub;

use App\Models\Launderpay;
use App\Models\Launderpaysub;
use Cookie;


class LaunderController extends Controller
{
  
    public function dashboard_launder(Request $req,$iduser)
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

        if($req->method() === "POST"){

            $year = $req->STATUS_CODE-543;     
            $year_start = $year.'01'.'01';
            $year_stop = $year.'12'.'31';
            $data_search = json_encode_u([
                'year' => $year,
            ]);
            Cookie::queue('data_search', $data_search, 120,$req->server('REQUEST_URI'));

            $getback = DB::table('launder_getback')->whereBetween('LAUNDER_GETBACK_DATE',[$year_start,$year_stop])->count();
            $check = DB::table('launder_check')->whereBetween('LAUNDER_CHECK_DATE',[$year_start,$year_stop])->count();
            $dis = DB::table('launder_dis')->whereBetween('LAUNDER_DIS_DATE',[$year_start,$year_stop])->count();
            $withdrow = DB::table('launder_withdrow')->whereBetween('LAUNDER_WITHDROW_DATE',[$year_start,$year_stop])->count();
            
            $i=0;
            for($i=0;$i<=40;$i++){
                $d_[$i] = DB::table('launder_getback')->where('LAUNDER_GETBACK_DEP','=', [$i])->whereBetween('LAUNDER_GETBACK_DATE',[$year_start,$year_stop])->count();
            }

            $j=0;
            for($j=0;$j<=40;$j++){
                $di_[$j] = DB::table('launder_dis')->where('LAUNDER_DIS_DEP','=',[$j])->whereBetween('LAUNDER_DIS_DATE',[$year_start,$year_stop])->count();
            }

            $x=0;
            for($x=0;$x<=40;$x++){
                $dw_[$x] = DB::table('launder_withdrow')->where('LAUNDER_WITHDROW_DEP_SUB_SUB_ID','=',[$x])->whereBetween('LAUNDER_WITHDROW_DATE',[$year_start,$year_stop])->count();
            }

            $year_y = date('Y');

            $getback_chart = DB::table('launder_getback')
                        ->select(DB::raw('count(*) as dep_count,LAUNDER_GETBACK_DEP'),'LAUNDER_GETBACK_DEP')  
                        ->leftjoin('hrd_department_sub_sub','launder_getback.LAUNDER_GETBACK_DEP','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')                 
                        ->where('LAUNDER_GETBACK_DATE','like',$year_y.'%')
                        ->groupBy('LAUNDER_GETBACK_DEP')
                        ->get();
    
            $o_1 = DB::table('launder_check')->where('LAUNDER_CHECK_FROM','=','1')->count();
            $o_2 = DB::table('launder_check')->where('LAUNDER_CHECK_FROM','=','2')->count();       
            $check_chart = DB::table('launder_check')
                        ->select(DB::raw('count(*) as checkdep_count,LAUNDER_CHECK_FROM'),'LAUNDER_CHECK_FROM') 
                        ->where('LAUNDER_CHECK_DATE','like',$year_y.'%')
                        ->groupBy('LAUNDER_CHECK_FROM')
                        ->get();
                

        }else{

            $getback = DB::table('launder_getback')->count(); // รับผ้า
            $check = DB::table('launder_check')->count();
            $dis = DB::table('launder_dis')->count();
            $withdrow = DB::table('launder_withdrow')->count();
    
            $i=0;
            for($i=0;$i<=40;$i++){
                $d_[$i] = DB::table('launder_getback')->where('LAUNDER_GETBACK_DEP','=', [$i])->count();
            }

            $j=0;
            for($j=0;$j<=40;$j++){
                $di_[$j] = DB::table('launder_dis')->where('LAUNDER_DIS_DEP','=',[$j])->count();
            }

            $x=0;
            for($x=0;$x<=40;$x++){
                $dw_[$x] = DB::table('launder_withdrow')->where('LAUNDER_WITHDROW_DEP_SUB_SUB_ID','=',[$x])->count();
            }

            $year_y = date('Y');
            $getback_chart = DB::table('launder_getback')
                        ->select(DB::raw('count(*) as dep_count,LAUNDER_GETBACK_DEP'),'LAUNDER_GETBACK_DEP')  
                        ->leftjoin('hrd_department_sub_sub','launder_getback.LAUNDER_GETBACK_DEP','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')                 
                        ->where('LAUNDER_GETBACK_DATE','like',$year_y.'%')
                        ->groupBy('LAUNDER_GETBACK_DEP')
                        ->get();
    
            $o_1 = DB::table('launder_check')->where('LAUNDER_CHECK_FROM','=','1')->count();
            $o_2 = DB::table('launder_check')->where('LAUNDER_CHECK_FROM','=','2')->count();       
            $check_chart = DB::table('launder_check')
                        ->select(DB::raw('count(*) as checkdep_count,LAUNDER_CHECK_FROM'),'LAUNDER_CHECK_FROM') 
                        ->where('LAUNDER_CHECK_DATE','like',$year_y.'%')
                        ->groupBy('LAUNDER_CHECK_FROM')
                        ->get();
        }
        
       
           
            $year = date('Y');
            $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

            $year_id = $req->STATUS_CODE;

           
        return view('general_launder.dashboard_launder',[
            'inforpersonuserid' => $inforpersonuserid,
            'inforpersonuser' => $inforpersonuser,
            'budgets' =>  $budget,
            'year_id'=>$year_id,

            'd_1' => $d_[1],'d_2' =>$d_[2], 'd_3' => $d_[3],'d_4' =>$d_[4], 'd_5' => $d_[5],'d_6' =>$d_[6], 'd_7' => $d_[7],'d_8' =>$d_[8], 'd_9' => $d_[9],'d_10' =>$d_[10],
            'd_11' => $d_[11],'d_12' =>$d_[12], 'd_13' => $d_[13],'d_14' =>$d_[14], 'd_15' => $d_[15],'d_16' =>$d_[16], 'd_17' => $d_[17],'d_18' =>$d_[18], 'd_19' => $d_[19],'d_20' =>$d_[20],
            'd_21' => $d_[21],'d_22' =>$d_[22], 'd_23' => $d_[23],'d_24' =>$d_[24], 'd_25' => $d_[25],'d_26' =>$d_[26], 'd_27' => $d_[27],'d_28' =>$d_[28], 'd_29' => $d_[29],'d_30' =>$d_[30],
            'd_31' => $d_[31],'d_32' =>$d_[32], 'd_33' => $d_[33],'d_34' =>$d_[34], 'd_35' => $d_[35],'d_36' =>$d_[36], 'd_37' => $d_[37],'d_38' =>$d_[38], 'd_39' => $d_[39],'d_40' =>$d_[40],


            'dw_1' => $dw_[1],'dw_2' =>$dw_[2], 'dw_3' => $dw_[3],'dw_4' =>$dw_[4], 'dw_5' => $dw_[5],'dw_6' =>$dw_[6], 'dw_7' => $dw_[7],'dw_8' =>$dw_[8], 'dw_9' => $dw_[9],'dw_10' =>$dw_[10],
            'dw_11' => $dw_[11],'dw_12' =>$dw_[12], 'dw_13' => $dw_[13],'dw_14' =>$dw_[14], 'dw_15' => $dw_[15],'dw_16' =>$dw_[16], 'dw_17' => $dw_[17],'dw_18' =>$dw_[18], 'dw_19' => $dw_[19],'dw_20' =>$dw_[20],
            'dw_21' => $dw_[21],'dw_22' =>$dw_[22], 'dw_23' => $dw_[23],'dw_24' =>$dw_[24], 'dw_25' => $dw_[25],'dw_26' =>$dw_[26], 'dw_27' => $dw_[27],'dw_28' =>$dw_[28], 'dw_29' => $dw_[29],'dw_30' =>$dw_[30],
            'dw_31' => $dw_[31],'dw_32' =>$dw_[32], 'dw_33' => $dw_[33],'dw_34' =>$dw_[34], 'dw_35' => $dw_[35],'dw_36' =>$dw_[36], 'dw_37' => $dw_[37],'dw_38' =>$dw_[38], 'dw_39' => $dw_[39],'dw_40' =>$dw_[40],

            'di_1' => $di_[1],'di_2' =>$di_[2], 'di_3' => $di_[3],'di_4' =>$di_[4], 'di_5' => $di_[5],'di_6' =>$di_[6], 'di_7' => $di_[7],'di_8' =>$di_[8], 'di_9' => $di_[9],'di_10' =>$di_[10],
            'di_11' => $di_[11],'di_12' =>$di_[12], 'di_13' => $di_[13],'di_14' =>$di_[14], 'di_15' => $di_[15],'di_16' =>$di_[16], 'di_17' => $di_[17],'di_18' =>$di_[18], 'di_19' => $di_[19],'di_20' =>$di_[20],
            'di_21' => $di_[21],'di_22' =>$di_[22], 'di_23' => $di_[23],'di_24' =>$di_[24], 'di_25' => $di_[25],'di_26' =>$di_[26], 'di_27' => $di_[27],'di_28' =>$di_[28], 'di_29' => $di_[29],'di_30' =>$di_[30],
            'di_31' => $di_[31],'di_32' =>$di_[32], 'di_33' => $di_[33],'di_34' =>$di_[34], 'di_35' => $di_[35],'di_36' =>$di_[36], 'di_37' => $di_[37],'di_38' =>$di_[38], 'di_39' => $di_[39],'di_40' =>$di_[40],


            'checkchart' =>  $check_chart,  'o_1' =>  $o_1,  'o_2' =>  $o_2,
            'getbacks' =>  $getback,
            'checks' =>  $check,
            'diss' =>  $dis,
            'withdrows' =>  $withdrow,
            'getbackchart' =>  $getback_chart,
            ]);

    }
    public function stockcard_launder(Request $request,$iduser)
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


        $search = '';

        
        $infotreasury= DB::table('launder_dis_sub')
        ->select('LAUNDER_TYPE_NAME', DB::raw('count(*) as total'),'HR_DEPARTMENT_SUB_SUB_NAME','LAUNDER_DIS_DEP','LAUNDER_DIS_SUB_TYPE')
        ->leftJoin('launder_dis','launder_dis_sub.LAUNDER_DIS_ID','=','launder_dis.LAUNDER_DIS_ID')
        ->leftJoin('launder_type','launder_dis_sub.LAUNDER_DIS_SUB_TYPE','=','launder_type.LAUNDER_TYPE_ID')
        ->leftJoin('hrd_department_sub_sub','launder_dis.LAUNDER_DIS_DEP','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->groupBy('LAUNDER_TYPE_NAME','HR_DEPARTMENT_SUB_SUB_NAME','LAUNDER_DIS_DEP','LAUNDER_DIS_SUB_TYPE')
        ->where('LAUNDER_DIS_DEP','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)
        ->orderBy('LAUNDER_DIS_DEP', 'asc')
        ->get();



        return view('general_launder.stockcard_launder',[
            'inforpersonuserid' => $inforpersonuserid,
            'inforpersonuser' => $inforpersonuser,
            'search' => $search,
            'infotreasurys'=>$infotreasury
        ]);

    }



    public function stockcard_laundersearch(Request $request,$iduser)
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


        $search = $request->get('search');
        
        
        $infotreasury= DB::table('launder_dis_sub')
        ->select('LAUNDER_TYPE_NAME', DB::raw('count(*) as total'),'HR_DEPARTMENT_SUB_SUB_NAME','LAUNDER_DIS_DEP','LAUNDER_DIS_SUB_TYPE')
        ->leftJoin('launder_dis','launder_dis_sub.LAUNDER_DIS_ID','=','launder_dis.LAUNDER_DIS_ID')
        ->leftJoin('launder_type','launder_dis_sub.LAUNDER_DIS_SUB_TYPE','=','launder_type.LAUNDER_TYPE_ID')
        ->leftJoin('hrd_department_sub_sub','launder_dis.LAUNDER_DIS_DEP','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->groupBy('LAUNDER_TYPE_NAME','HR_DEPARTMENT_SUB_SUB_NAME','LAUNDER_DIS_DEP','LAUNDER_DIS_SUB_TYPE')
        ->where('LAUNDER_DIS_DEP','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)
        ->where(function($q) use ($search){
            $q->where('LAUNDER_TYPE_NAME','like','%'.$search.'%');
            })
        ->orderBy('LAUNDER_DIS_DEP', 'asc')
        ->get();



        return view('general_launder.stockcard_launder',[
       
            'inforpersonuserid' => $inforpersonuserid,
            'inforpersonuser' => $inforpersonuser,
            'search' => $search,
            'infotreasurys'=>$infotreasury
        ]);

    }



    
    public function stockcard_launder_sub(Request $request,$idtype,$iddep,$iduser)
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

        $receivesub = DB::table('launder_dis_sub')
        ->leftJoin('launder_dis','launder_dis_sub.LAUNDER_DIS_ID','=','launder_dis.LAUNDER_DIS_ID')
        ->leftJoin('launder_type','launder_dis_sub.LAUNDER_DIS_SUB_TYPE','=','launder_type.LAUNDER_TYPE_ID')
        ->leftJoin('hrd_department_sub_sub','launder_dis.LAUNDER_DIS_DEP','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->where('LAUNDER_DIS_SUB_TYPE','=',$idtype)
        ->where('LAUNDER_DIS_DEP','=',$iddep)
        ->get();

       
        $paysub = DB::table('launder_pay_sub')
        ->leftJoin('launder_pay','launder_pay_sub.LAUNDER_PAY_ID','=','launder_pay.LAUNDER_PAY_ID')
        ->leftJoin('launder_type','launder_pay_sub.LAUNDER_PAY_SUB_TYPEID','=','launder_type.LAUNDER_TYPE_ID')
        ->leftJoin('hrd_department_sub_sub','launder_pay.LAUNDER_PAY_DEP','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->where('LAUNDER_PAY_SUB_TYPEID','=',$idtype)
        ->where('LAUNDER_PAY_DEP','=',$iddep)
        ->get();


        $nametype =  DB::table('launder_type')->where('LAUNDER_TYPE_ID','=',$idtype)->first();
    
        return view('general_launder.stockcard_launder_sub',[
            'inforpersonuserid' => $inforpersonuserid,
            'inforpersonuser' => $inforpersonuser,
            'receivesubs' =>  $receivesub,
            'nametype' =>  $nametype,
            'paysubs'=> $paysub
        ]);
    }


    public function withdraw_launder(Request $request,$iduser)
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
        $year_id = $yearbudget;

        $year = $year_id - 543;
            $STATUS_CODE = '';
                $search = '';
                $status = '';
        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';        
              

        $launderwithdrow = DB::table('launder_withdrow')
        ->leftJoin('hrd_person','launder_withdrow.LAUNDER_WITHDROW_HR_ID','=','hrd_person.ID')
        ->leftJoin('hrd_department_sub_sub','launder_withdrow.LAUNDER_WITHDROW_DEP_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->where('launder_withdrow.LAUNDER_WITHDROW_DEP_SUB_SUB_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)
        ->orderBy('LAUNDER_WITHDROW_DATE', 'desc')->get();


        $infostatus = DB::table('launder_dis_status')->get();

        return view('general_launder.withdraw_launder',[
            'budgets' =>  $budget,
            'year_id'=>$year_id ,
            'inforpersonuserid' => $inforpersonuserid,
            'inforpersonuser' => $inforpersonuser,
            'STATUS_CODE' => $STATUS_CODE,
            'search' => $search,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'launderwithdrows'=> $launderwithdrow,
            'infostatuss' => $infostatus,
            'status_check'=> $status,
        ]);

    }

    //**** search  *****/
    public function withdrowlaundersearch(Request $request,$iduser)
    {
        $search = $request->get('search');
        $status = $request->SEND_STATUS;
        $datebigin = $request->get('DATE_BIGIN');
        $dateend = $request->get('DATE_END');
        $yearbudget = $request->BUDGET_YEAR;

        if($search==''){
            $search="";
        }

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
                $launderwithdrow = DB::table('launder_withdrow')
                ->leftJoin('hrd_person','launder_withdrow.LAUNDER_WITHDROW_HR_ID','=','hrd_person.ID')
                ->leftJoin('hrd_department_sub_sub','launder_withdrow.LAUNDER_WITHDROW_DEP_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
                ->where(function($q) use ($search){
                    $q->where('LAUNDER_WITHDROW_CODE','like','%'.$search.'%');
                    $q->orwhere('LAUNDER_WITHDROW_COMMENT','like','%'.$search.'%');
                    $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');
                    $q->orwhere('HR_FNAME','like','%'.$search.'%');
                    $q->orwhere('HR_LNAME','like','%'.$search.'%');
                    })
                    ->WhereBetween('LAUNDER_WITHDROW_DATE',[$from.' 00:00:00',$to.' 23:59:00']) 
                ->orderBy('LAUNDER_WITHDROW_DATE', 'desc')->get();


            }else{


                $launderwithdrow = DB::table('launder_withdrow')
                ->leftJoin('hrd_person','launder_withdrow.LAUNDER_WITHDROW_HR_ID','=','hrd_person.ID')
                ->leftJoin('hrd_department_sub_sub','launder_withdrow.LAUNDER_WITHDROW_DEP_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
                ->where('LAUNDER_WITHDROW_STATUS','=',$status)
                ->where(function($q) use ($search){
                    $q->where('LAUNDER_WITHDROW_CODE','like','%'.$search.'%');
                    $q->orwhere('LAUNDER_WITHDROW_COMMENT','like','%'.$search.'%');
                    $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');
                    $q->orwhere('HR_FNAME','like','%'.$search.'%');
                    $q->orwhere('HR_LNAME','like','%'.$search.'%');
                    })
                ->WhereBetween('LAUNDER_WITHDROW_DATE',[$from.' 00:00:00',$to.' 23:59:00']) 
                ->orderBy('LAUNDER_WITHDROW_DATE', 'desc')->get();

            }
            
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $year_id = $yearbudget;
        $infostatus = DB::table('launder_dis_status')->get();

        return view('general_launder.withdraw_launder',[
            'budgets' =>  $budget,
            'year_id'=>$year_id ,
            'inforpersonuserid' => $inforpersonuserid,
            'inforpersonuser' => $inforpersonuser,
            'status_check'=> $status,
            'search'=> $search,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'launderwithdrows'=> $launderwithdrow,
            'infostatuss' => $infostatus,
        ]);

    }
    
    public function withdrowlaunder_add(Request $request,$iduser)
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

        $suppliestype = DB::table('supplies_type')->where('ACTIVE','=','True')->get();

        $pessonall = Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')->orderBy('hrd_person.HR_FNAME', 'asc')->get();
    
        $departmentsubsub = DB::table('hrd_department_sub_sub')->where('ACTIVE','=','True')->get();
    
        $orgname = DB::table('info_org')->first();
    
     
    
        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;
        }
    
        $infosupplies= DB::table('supplies')->leftJoin('supplies_type','supplies.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
        ->leftJoin('supplies_type_kind','supplies.SUP_TYPE_KIND_ID','=','supplies_type_kind.SUP_TYPE_KIND_ID')
        ->where('supplies_type_kind.SUP_TYPE_MASTER_ID','=',1)
        ->orderBy('ID', 'desc') 
        ->get();
    
        $infosuppliesunitref = DB::table('supplies_unit_ref')->get();
    
        $budget = DB::table('budget_year')->where('ACTIVE','=','True')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
    
        $infolaundertype = DB::table('launder_type')->get();



        $launderdepsub = DB::table('launder_dep_sub')
        ->leftjoin('launder_dep','launder_dep_sub.LAUNDER_DEP_ID','=','launder_dep.LAUNDER_DEP_ID')
        ->where('LAUNDER_DEP_CODE','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)->get();
    
        return view('general_launder.withdrowlaunder_add',[
            'budgets' => $budget,
            'inforpersonuser' => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid,
            'inforpersonuser' => $inforpersonuser,
            'suppliestypes' => $suppliestype,
            'pessonalls' => $pessonall,
            'infosuppliess' => $infosupplies, 
            'departmentsubsubs' => $departmentsubsub,
            'infosuppliesunitrefs' => $infosuppliesunitref, 
            'orgname' => $orgname->ORG_NAME,
            'year_id' => $yearbudget,
            'infolaundertypes' => $infolaundertype,
            'launderdepsubs' => $launderdepsub,
           
    
        ]);
    

    }


    

public function withdrowlaunder_save(Request $request)
{
   

    $LAUNDERCHECK_DATE = $request->LAUNDER_WITHDROW_DATE;

    $date_bigin = Carbon::createFromFormat('d/m/Y', $LAUNDERCHECK_DATE)->format('Y-m-d');
    $date_arrary=explode("-",$date_bigin);
    $y_sub_st = $date_arrary[0];

    if($y_sub_st >= 2500){
        $y = $y_sub_st-543;
    }else{
        $y = $y_sub_st;
    }

    $m = $date_arrary[1];
    $d = $date_arrary[2];  
    $LAUNDERWITHDROWDATE= $y."-".$m."-".$d;
       
    $addinfomation = new Launderwithdrow(); 
    $addinfomation->LAUNDER_WITHDROW_CODE = $request->LAUNDER_WITHDROW_CODE;
    $addinfomation->LAUNDER_WITHDROW_YEAR = $request->LAUNDER_WITHDROW_YEAR;
    $addinfomation->LAUNDER_WITHDROW_COMMENT = $request->LAUNDER_WITHDROW_COMMENT;
    $addinfomation->LAUNDER_WITHDROW_DATE = $LAUNDERWITHDROWDATE;
    $addinfomation->LAUNDER_WITHDROW_DEP_SUB_SUB_ID = $request->LAUNDER_WITHDROW_DEP_SUB_SUB_ID;
    $addinfomation->LAUNDER_WITHDROW_HR_ID = $request->LAUNDER_WITHDROW_HR_ID;
    $addinfomation->LAUNDER_WITHDROW_STATUS = 'Request';
    $addinfomation->LAUNDER_WITHDROW_TIME = $request->LAUNDER_WITHDROW_TIME;
    $addinfomation->save();



    $LAUNDERWITHDROW_ID  = Launderwithdrow::max('LAUNDER_WITHDROW_ID');
    
    if($request->LAUNDER_WITHDROW_SUB_TYPE[0] != '' || $request->LAUNDER_WITHDROW_SUB_TYPE[0] != null){
        
        $LAUNDER_WITHDROW_SUB_TYPE = $request->LAUNDER_WITHDROW_SUB_TYPE;

        $LAUNDER_WITHDROW_SUB_TOP = $request->LAUNDER_WITHDROW_SUB_TOP;
        $LAUNDER_WITHDROW_SUB_TREASURY = $request->LAUNDER_WITHDROW_SUB_TREASURY;
        $LAUNDER_WITHDROW_SUB_HAVE = $request->LAUNDER_WITHDROW_SUB_HAVE;
        $LAUNDER_WITHDROW_SUB_AMOUNT = $request->LAUNDER_WITHDROW_SUB_AMOUNT;


        $number =count($LAUNDER_WITHDROW_SUB_TYPE);
        $count = 0;
        for($count = 0; $count < $number; $count++)
        {  
      
           $add = new Launderwithdrowsub();
           $add->LAUNDER_WITHDROW_ID = $LAUNDERWITHDROW_ID;
           $add->LAUNDER_WITHDROW_SUB_TYPE = $LAUNDER_WITHDROW_SUB_TYPE[$count];
           $add->LAUNDER_WITHDROW_SUB_TOP = $LAUNDER_WITHDROW_SUB_TOP[$count];
           $add->LAUNDER_WITHDROW_SUB_TREASURY = $LAUNDER_WITHDROW_SUB_TREASURY[$count];
           $add->LAUNDER_WITHDROW_SUB_HAVE = $LAUNDER_WITHDROW_SUB_HAVE[$count];
           $add->LAUNDER_WITHDROW_SUB_AMOUNT = $LAUNDER_WITHDROW_SUB_AMOUNT[$count];
           $add->save(); 
                
        
        }
    }


    


    return redirect()->route('gen_launder.withdraw_launder',[
        'iduser' => $request->LAUNDER_WITHDROW_HR_ID
    ]);
}










    public function pay_launder(Request $request,$iduser)
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
        $year_id = $yearbudget;

        $year = $year_id - 543;
           
                $search = '';

        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';  
        
        
        $infopay = DB::table('launder_pay')->where('LAUNDER_PAY_DEP','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)->get();
              

        return view('general_launder.pay_launder',[
            'budgets' =>  $budget,
            'year_id'=>$year_id ,
            'inforpersonuserid' => $inforpersonuserid,
            'inforpersonuser' => $inforpersonuser,
            'search' => $search,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'infopays'=> $infopay,
        ]);

    }


    public function pay_laundersearch(Request $request,$iduser)
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

        $search = $request->get('search');
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

           $from = date($displaydate_bigen);
           $to = date($displaydate_end);   
        

            $infopay = DB::table('launder_pay')->where('LAUNDER_PAY_DEP','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)
            ->where(function($q) use ($search){
                $q->where('LAUNDER_PAY_CODE','like','%'.$search.'%');
                $q->orwhere('LAUNDER_PAY_COMMENT','like','%'.$search.'%');
                $q->orwhere('LAUNDER_PAY_SAVE_HR_NAME','like','%'.$search.'%');
                $q->orwhere('LAUNDER_PAY_TREASURT_NAME','like','%'.$search.'%');
                })
                ->WhereBetween('LAUNDER_PAY_DATE',[$from.' 00:00:00',$to.' 23:59:00']) 
            ->get();




        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $year_id = $yearbudget;

     
              

        return view('general_launder.pay_launder',[
            'budgets' =>  $budget,
            'year_id'=>$year_id ,
            'inforpersonuserid' => $inforpersonuserid,
            'inforpersonuser' => $inforpersonuser,
            'search' => $search,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'infopays'=> $infopay,
        ]);

    }


    public function pay_launder_add(Request $request,$iduser)
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

        $infotype = DB::table('launder_type')->get();


        return view('general_launder.pay_launder_add',[
            'inforpersonuserid' => $inforpersonuserid,
            'inforpersonuser' => $inforpersonuser,
            'infotypes'=>$infotype

        ]);

    }


                        
                    public function pay_launder_save(Request $request)
                    {
                    

                        $LAUNDERPAY_DATE = $request->LAUNDER_PAY_DATE;

                        $date_bigin = Carbon::createFromFormat('d/m/Y', $LAUNDERPAY_DATE)->format('Y-m-d');
                        $date_arrary=explode("-",$date_bigin);
                        $y_sub_st = $date_arrary[0];

                        if($y_sub_st >= 2500){
                            $y = $y_sub_st-543;
                        }else{
                            $y = $y_sub_st;
                        }

                        $m = $date_arrary[1];
                        $d = $date_arrary[2];  
                        $LAUNDERPAYDATE= $y."-".$m."-".$d;
                        
                        $addinfomation = new Launderpay(); 
                        $addinfomation->LAUNDER_PAY_CODE = $request->LAUNDER_PAY_CODE;
                        $addinfomation->LAUNDER_PAY_DATE = $LAUNDERPAYDATE;
                        $addinfomation->LAUNDER_PAY_COMMENT = $request->LAUNDER_PAY_COMMENT;
                        $addinfomation->LAUNDER_PAY_SAVE_HR_ID = $request->LAUNDER_PAY_SAVE_HR_ID;
                        $addinfomation->LAUNDER_PAY_SAVE_HR_NAME = $request->LAUNDER_PAY_SAVE_HR_NAME;
                        $addinfomation->LAUNDER_PAY_TREASURT_NAME = $request->LAUNDER_PAY_TREASURT_NAME;
                        $addinfomation->LAUNDER_PAY_DEP = $request->LAUNDER_PAY_DEP;
                        $addinfomation->save();



                        $LAUNDERPAY_ID  = Launderpay::max('LAUNDER_PAY_ID');
                        
                        if($request->LAUNDER_PAY_SUB_TYPEID[0] != '' || $request->LAUNDER_PAY_SUB_TYPEID[0] != null){
                            
                            $LAUNDER_PAY_SUB_TYPEID = $request->LAUNDER_PAY_SUB_TYPEID;
                            $LAUNDER_PAY_SUB_AMOUNT = $request->LAUNDER_PAY_SUB_AMOUNT;


                            $number =count($LAUNDER_PAY_SUB_TYPEID);
                            $count = 0;
                            for($count = 0; $count < $number; $count++)
                            {  
                        
                            $addpaysub = new Launderpaysub();
                            $addpaysub->LAUNDER_PAY_ID = $LAUNDERPAY_ID;
                            $addpaysub->LAUNDER_PAY_SUB_TYPEID = $LAUNDER_PAY_SUB_TYPEID[$count];
                            $addpaysub->LAUNDER_PAY_SUB_AMOUNT = $LAUNDER_PAY_SUB_AMOUNT[$count];
                            $addpaysub->save(); 
                            
                            
                            }
                        }


                        return redirect()->route('gen_launder.pay_launder',[
                            'iduser'=> $request->LAUNDER_PAY_SAVE_HR_ID
                        ]);
                    }



    

                    function detaillaunder(Request $request)
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

                                $detail = DB::table('launder_withdrow')
                                ->leftJoin('hrd_department_sub_sub','launder_withdrow.LAUNDER_WITHDROW_DEP_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
                                ->where('LAUNDER_WITHDROW_ID','=',$id)->first();

                                $detailperson = DB::table('hrd_person')->where('ID','=',$detail->LAUNDER_WITHDROW_HR_ID)->first();

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
                                    <h1 style="text-align: left;font-family: \'Kanit\', sans-serif; font-size:10px;font-size: 1.0rem;font-weight:normal;color:#778899;">'.DateThai($detail -> LAUNDER_WITHDROW_DATE).'</h1>
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="form-group">
                                    <label >เหตุผล  :</label>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                    <h1 style="text-align: left;font-family: \'Kanit\', sans-serif; font-size:10px;font-size: 1.0rem;font-weight:normal;color:#778899;">'.$detail -> LAUNDER_WITHDROW_COMMENT.'</h1>
                                    </div>
                                </div>

                                </div>

                                <div class="row">

                                <div class="col-sm-2">
                                    <div class="form-group">
                                    <label >ผู้ร้องขอ :</label>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group" >
                                    <h1 style="text-align: left;font-family: \'Kanit\', sans-serif; font-size:10px;font-size: 1.0rem;font-weight:normal;color:#778899;">'.$detailperson ->HR_FNAME.' '.$detailperson ->HR_LNAME.'</h1>
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="form-group">
                                    <label >หน่วยงานที่ร้องขอ  :</label>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                    <h1 style="text-align: left;font-family: \'Kanit\', sans-serif; font-size:10px;font-size: 1.0rem;font-weight:normal;color:#778899;" >'.$detail ->HR_DEPARTMENT_SUB_SUB_NAME.'</h1>
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
                                $output.=' 
                               
                                <table class="table-bordered table-striped table-vcenter js-dataTable-simple" style="width: 100%;">
                                <thead style="background-color: #FFEBCD;">
                                    <tr height="40">
                                    <th  class="text-font" style="border-color:#F0FFFF;text-align: center;" width="5%">ลำดับ</th>
                                        <th  class="text-font" style="border-color:#F0FFFF;text-align: center;">รายละเอียด</th>
                                        <th  class="text-font" style="border-color:#F0FFFF;text-align: center;" width="15%">จำนวนเบิก</th>
                                        <th  class="text-font" style="border-color:#F0FFFF;text-align: center;" width="15%">จำนวนจ่าย</th>
                                        <th  class="text-font" style="border-color:#F0FFFF;text-align: center;" width="15%">ส่วนต่าง</th>
                                    

                                    </tr >
                                </thead>
                                <tbody>     ';

                                $detail_subs = DB::table('launder_withdrow_sub')->where('LAUNDER_WITHDROW_ID','=',$id)
                                ->leftJoin('launder_type','launder_withdrow_sub.LAUNDER_WITHDROW_SUB_TYPE','=','launder_type.LAUNDER_TYPE_ID')
            
                                ->get();

                                $count = 1;

                               

                                foreach ($detail_subs as $detailsub){

                                    $infore =  $detailsub->LAUNDER_WITHDROW_SUB_AMOUNT;
                                    $infopay =  $detailsub->LAUNDER_WITHDROW_SUB_AMOUNTPAY;
                                    $total = $infore- $infopay;

                                $output.='  <tr height="20">
                                <td class="text-font" align="center" >'.$count.'</td>
                                <td class="text-font text-pedding" >'.$detailsub->LAUNDER_TYPE_NAME.'</td>
                                <td class="text-font" align="center" >'.$detailsub->LAUNDER_WITHDROW_SUB_AMOUNT.'</td>
                                <td class="text-font" align="center" >'.$detailsub->LAUNDER_WITHDROW_SUB_AMOUNTPAY.'</td>
                                <td class="text-font" align="center" >'.$total.'</td>
                                </tr>';

                                $count++;
                                }

                             

                                echo $output;


                    }



                        
  public static function refwithdrow()
  {
      $year = date('Y');

      $maxnumber = DB::table('launder_withdrow')->where('LAUNDER_WITHDROW_DATE','like',$year.'%')->max('LAUNDER_WITHDROW_ID');  

   

      if($maxnumber != '' ||  $maxnumber != null){
          
          $refmax = DB::table('launder_withdrow')->where('LAUNDER_WITHDROW_ID','=',$maxnumber)->first();  

          
          if($refmax->LAUNDER_WITHDROW_CODE != '' ||  $refmax->LAUNDER_WITHDROW_CODE != null){
             $maxref = substr($refmax->LAUNDER_WITHDROW_CODE, -4)+1;
          }else{
             $maxref = 1;
          }
          

          $ref = str_pad($maxref, 5, "0", STR_PAD_LEFT);
     
      }else{
          $ref = '000001';
      }

      $ye = date('Y')+543;
      $y = substr($ye, -2);

  $refnumber ='W'.$y.'-'.$ref;

   return $refnumber;
  }



      
  public static function refpay()
  {
      $year = date('Y');

      $maxnumber = DB::table('launder_pay')->where('LAUNDER_PAY_DATE','like',$year.'%')->max('LAUNDER_PAY_ID');  

   

      if($maxnumber != '' ||  $maxnumber != null){
          
          $refmax = DB::table('launder_pay')->where('LAUNDER_PAY_ID','=',$maxnumber)->first();  

          
          if($refmax->LAUNDER_PAY_CODE != '' ||  $refmax->LAUNDER_PAY_CODE != null){
             $maxref = substr($refmax->LAUNDER_PAY_CODE, -4)+1;
          }else{
             $maxref = 1;
          }
          

          $ref = str_pad($maxref, 5, "0", STR_PAD_LEFT);
     
      }else{
          $ref = '000001';
      }

      $ye = date('Y')+543;
      $y = substr($ye, -2);

  $refnumber ='PAY'.$y.'-'.$ref;

   return $refnumber;
  }





}