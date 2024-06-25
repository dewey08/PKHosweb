<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\DB;
use App\Models\Person;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Infoworkcorcomsetup;
use App\Models\Infoworkfunctionsetup;
use App\Models\Infowork_job_person;
use App\Models\Infowork_job_person_list;
use App\Models\Healthscreen;
use App\Models\Infowork_job_person_status;
use App\Models\Infowork_job_person_permission_list;
use Cookie;
use PDF;


class AbilityController extends Controller
{



    public function infoability(Request $request,$iduser)
    {
        $id_user = Auth::user()->id;
        $select_user = DB::table('users')->where('id', $id_user)->first();

        $email = Auth::user()->email;
        $inforpersonid =  Person::where('ID','=',$iduser)->first();
            
        $inforperson =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
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
      

       $infocapa = DB::table('infowork_capacity')->where('CAPACITY_PERSON_ID','=',$iduser)->get();

        return view('person_work.personinfoworkability',[
            'inforperson' => $inforperson,
            'inforpersonid' => $inforpersonid,
            'infocapas' => $infocapa,
            
        ]);
    }

    public function detail(Request $request,$iduser,$idref)
    {
        $email = Auth::user()->email;
        $inforpersonid =  Person::where('ID','=',$iduser)->first();
            
        $inforperson =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
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


       $infocapacity = DB::table('infowork_capacity')->where('CAPACITY_ID','=',$idref)->first();
       $infouser = DB::table('hrd_person')->where('ID','=',$iduser)->first();
     
      
        return view('person_work.personinfoworkabilitydetail',[
            'inforperson' => $inforperson,
            'inforpersonid' => $inforpersonid,
            'infocapacity'=>$infocapacity,  
            'infouser'=>$infouser, 
            
        ]);
    }




    public function screen(Request $request,$idref,$iduser)
    {
        $email = Auth::user()->email;
        $inforpersonid =  Person::where('ID','=',$iduser)->first();
            
        $inforperson =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
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

        $inforef = DB::table('health_screen')->where('HEALTH_SCREEN_ID','=',$idref)->first();
      
        $infolab =  DB::table('health_screen_confirm')->where('HEALTH_SCREEN_ID','=',$idref)->get();
        $sumamount =  DB::table('health_screen_confirm')->where('HEALTH_SCREEN_ID','=',$idref)->SUM('HEALTH_SCREEN_CON_SUMPICE');

        $inforbody = DB::table('health_body')->where('HEALTH_SCREEN_ID','=',$idref)->first();

        $check = DB::table('health_body')->where('HEALTH_SCREEN_ID','=',$idref)->count();

        return view('person_work.personinfoworkscreen',[
            'inforperson' => $inforperson,
            'inforpersonid' => $inforpersonid,
            'idref' =>  $idref,
            'inforef' =>  $inforef,
            'infolabs' =>  $infolab,
            'sumamount' =>  $sumamount,
            'inforbody' =>  $inforbody,
            'check' =>  $check,
           
            
        ]);
    }


    public function screen_sub_save(Request $request)
    {
        $id = $request->idref;

        $addinfo =  Healthscreen::find($id); 
        $addinfo->HEALTH_SCREEN_HEIGHT = $request->HEALTH_SCREEN_HEIGHT;
        $addinfo->HEALTH_SCREEN_WEIGHT = $request->HEALTH_SCREEN_WEIGHT;
        $addinfo->HEALTH_SCREEN_BODY =  $request->HEALTH_SCREEN_BODY;
        
        $addinfo->HEALTH_SCREEN_FM_DIA =  $request->HEALTH_SCREEN_FM_DIA;
        $addinfo->HEALTH_SCREEN_FM_BLOOD =  $request->HEALTH_SCREEN_FM_BLOOD;
        $addinfo->HEALTH_SCREEN_FM_GOUT =  $request->HEALTH_SCREEN_FM_GOUT;
        $addinfo->HEALTH_SCREEN_FM_KIDNEY =  $request->HEALTH_SCREEN_FM_KIDNEY;
        $addinfo->HEALTH_SCREEN_FM_HEART =  $request->HEALTH_SCREEN_FM_HEART;
        $addinfo->HEALTH_SCREEN_FM_BRAIN =  $request->HEALTH_SCREEN_FM_BRAIN;
        $addinfo->HEALTH_SCREEN_FM_EMPHY =  $request->HEALTH_SCREEN_FM_EMPHY;
        $addinfo->HEALTH_SCREEN_FM_UNKNOW =  $request->HEALTH_SCREEN_FM_UNKNOW;
        $addinfo->HEALTH_SCREEN_FM_OTHER =  $request->HEALTH_SCREEN_FM_OTHER;

        $addinfo->HEALTH_SCREEN_BS_DIA =  $request->HEALTH_SCREEN_BS_DIA;
        $addinfo->HEALTH_SCREEN_BS_BLOOD =  $request->HEALTH_SCREEN_BS_BLOOD;
        $addinfo->HEALTH_SCREEN_BS_GOUT =  $request->HEALTH_SCREEN_BS_GOUT;
        $addinfo->HEALTH_SCREEN_BS_KIDNEY =  $request->HEALTH_SCREEN_BS_KIDNEY;
        $addinfo->HEALTH_SCREEN_BS_HEART =  $request->HEALTH_SCREEN_BS_HEART;
        $addinfo->HEALTH_SCREEN_BS_BRAIN =  $request->HEALTH_SCREEN_BS_BRAIN;
        $addinfo->HEALTH_SCREEN_BS_EMPHY =  $request->HEALTH_SCREEN_BS_EMPHY;
        $addinfo->HEALTH_SCREEN_BS_UNKNOW =  $request->HEALTH_SCREEN_BS_UNKNOW;
        $addinfo->HEALTH_SCREEN_BS_OTHER =  $request->HEALTH_SCREEN_BS_OTHER;

        $addinfo->HEALTH_SCREEN_H_1 =  $request->HEALTH_SCREEN_H_1;
        $addinfo->HEALTH_SCREEN_H_2 =  $request->HEALTH_SCREEN_H_2;
        $addinfo->HEALTH_SCREEN_H_3 =  $request->HEALTH_SCREEN_H_3;
        $addinfo->HEALTH_SCREEN_H_4=  $request->HEALTH_SCREEN_H_4;
        $addinfo->HEALTH_SCREEN_H_5 =  $request->HEALTH_SCREEN_H_5;
        $addinfo->HEALTH_SCREEN_H_6 =  $request->HEALTH_SCREEN_H_6;
        $addinfo->HEALTH_SCREEN_H_7 =  $request->HEALTH_SCREEN_H_7;
        $addinfo->HEALTH_SCREEN_H_8 =  $request->HEALTH_SCREEN_H_8;
        $addinfo->HEALTH_SCREEN_H_9 =  $request->HEALTH_SCREEN_H_9;
        $addinfo->HEALTH_SCREEN_H_10 =  $request->HEALTH_SCREEN_H_10;
        $addinfo->HEALTH_SCREEN_H_11 =  $request->HEALTH_SCREEN_H_11;
        $addinfo->HEALTH_SCREEN_H_12 =  $request->HEALTH_SCREEN_H_12;
        $addinfo->HEALTH_SCREEN_H_13 =  $request->HEALTH_SCREEN_H_13;
        $addinfo->HEALTH_SCREEN_H_14 =  $request->HEALTH_SCREEN_H_14;
        $addinfo->HEALTH_SCREEN_H_15 =  $request->HEALTH_SCREEN_H_15;
        $addinfo->HEALTH_SCREEN_H_16 =  $request->HEALTH_SCREEN_H_16;
        $addinfo->HEALTH_SCREEN_H_17 =  $request->HEALTH_SCREEN_H_17;
        $addinfo->HEALTH_SCREEN_H_18 =  $request->HEALTH_SCREEN_H_18;
        $addinfo->HEALTH_SCREEN_H_19 =  $request->HEALTH_SCREEN_H_19;
        $addinfo->HEALTH_SCREEN_H_20 =  $request->HEALTH_SCREEN_H_20;
        $addinfo->HEALTH_SCREEN_H_21 =  $request->HEALTH_SCREEN_H_21;
        $addinfo->HEALTH_SCREEN_H_22 =  $request->HEALTH_SCREEN_H_22;
        $addinfo->HEALTH_SCREEN_H_23 =  $request->HEALTH_SCREEN_H_23;
        $addinfo->HEALTH_SCREEN_H_24 =  $request->HEALTH_SCREEN_H_24;
        $addinfo->HEALTH_SCREEN_H_25 =  $request->HEALTH_SCREEN_H_25;
        $addinfo->HEALTH_SCREEN_H_26 =  $request->HEALTH_SCREEN_H_26;
        $addinfo->HEALTH_SCREEN_H_27 =  $request->HEALTH_SCREEN_H_27;
        $addinfo->HEALTH_SCREEN_H_28 =  $request->HEALTH_SCREEN_H_28;
        $addinfo->HEALTH_SCREEN_H_29 =  $request->HEALTH_SCREEN_H_29;
        $addinfo->HEALTH_SCREEN_H_29_COMMENT =  $request->HEALTH_SCREEN_H_29_COMMENT;
        $addinfo->HEALTH_SCREEN_H_30 =  $request->HEALTH_SCREEN_H_30;
        $addinfo->HEALTH_SCREEN_H_30_COMMENT =  $request->HEALTH_SCREEN_H_30_COMMENT;
        $addinfo->HEALTH_SCREEN_H_31 =  $request->HEALTH_SCREEN_H_31;
        $addinfo->HEALTH_SCREEN_H_31_COMMENT =  $request->HEALTH_SCREEN_H_31_COMMENT;
        $addinfo->HEALTH_SCREEN_H_HAVE =  $request->HEALTH_SCREEN_H_HAVE;


        $addinfo->HEALTH_SCREEN_SMOK =  $request->HEALTH_SCREEN_SMOK;
        $addinfo->HEALTH_SCREEN_SMOK_AMOUNT =  $request->HEALTH_SCREEN_SMOK_AMOUNT;
        $addinfo->HEALTH_SCREEN_SMOK_TYPE =  $request->HEALTH_SCREEN_SMOK_TYPE;
        $addinfo->HEALTH_SCREEN_SMOK_TIME =  $request->HEALTH_SCREEN_SMOK_TIME;


        $addinfo->HEALTH_SCREEN_DRINK =  $request->HEALTH_SCREEN_DRINK;
        $addinfo->HEALTH_SCREEN_DRINK_AMOUNT =  $request->HEALTH_SCREEN_DRINK_AMOUNT;
      

        $addinfo->HEALTH_SCREEN_EXERCISE=  $request->HEALTH_SCREEN_EXERCISE;

        $addinfo->HEALTH_SCREEN_FOOD_1 =  $request->HEALTH_SCREEN_FOOD_1;
        $addinfo->HEALTH_SCREEN_FOOD_2 =  $request->HEALTH_SCREEN_FOOD_2;
        $addinfo->HEALTH_SCREEN_FOOD_3 =  $request->HEALTH_SCREEN_FOOD_3;
        $addinfo->HEALTH_SCREEN_FOOD_4 =  $request->HEALTH_SCREEN_FOOD_4;
        $addinfo->HEALTH_SCREEN_FOOD_5 =  $request->HEALTH_SCREEN_FOOD_5;

        $addinfo->HEALTH_SCREEN_DRIVE =  $request->HEALTH_SCREEN_DRIVE;
        $addinfo->HEALTH_SCREEN_SEX =  $request->HEALTH_SCREEN_SEX;

        $addinfo->HEALTH_SCREEN_AGE =  $request->HEALTH_SCREEN_AGE;
       

        $addinfo->save();
     

        return redirect()->route('health.checkup',['iduser'=>  $request->HEALTH_SCREEN_PERSON_ID]);
    }



    public function checkup(Request $request,$iduser)
    {
        $email = Auth::user()->email;
        $inforpersonid =  Person::where('ID','=',$iduser)->first();
            
        $inforperson =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
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


        $budgetyear =  DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

         $infoscreen = DB::table('health_screen')->where('HEALTH_SCREEN_PERSON_ID','=',$iduser)
         ->orderBy('HEALTH_SCREEN_ID', 'desc')->get();

        return view('person_work.personinfoworkcheckup',[
            'inforperson' => $inforperson,
            'inforpersonid' => $inforpersonid,
            'budgetyears' => $budgetyear,
            'infoscreens' => $infoscreen,

            
        ]);
    }




    public function screen_add(Request $request,$iduser)
    {
       
        $inforpersonid =  Person::where('ID','=',$iduser)->first();
            
        $inforperson =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
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

      

        return view('person_work.personinfoworkscreen_add',[
            'inforperson' => $inforperson,
            'inforpersonid' => $inforpersonid,
           
            
        ]);
    }


    public function screen_save(Request $request)
    {

        $DATE_WANT = $request->HEALTH_SCREEN_DATE;

        if($DATE_WANT != ''){
        $STARTDAY = Carbon::createFromFormat('d/m/Y', $DATE_WANT)->format('Y-m-d');
        $date_arrary_st=explode("-",$STARTDAY);  
        $y_sub_st = $date_arrary_st[0]; 
        
        if($y_sub_st >= 2500){
            $y_st = $y_sub_st-543;
        }else{
            $y_st = $y_sub_st;
        }
        $m_st = $date_arrary_st[1];
        $d_st = $date_arrary_st[2];  
        $DATEWANT= $y_st."-".$m_st."-".$d_st;
        }else{
        $DATEWANT= null;
    }



        $addinfo = new Healthscreen(); 
        $addinfo->HEALTH_SCREEN_YEAR = $request->HEALTH_SCREEN_YEAR;
        $addinfo->HEALTH_SCREEN_PERSON_ID = $request->HEALTH_SCREEN_PERSON_ID;
        $addinfo->HEALTH_SCREEN_HEIGHT = $request->HEALTH_SCREEN_HEIGHT;
        $addinfo->HEALTH_SCREEN_WEIGHT = $request->HEALTH_SCREEN_WEIGHT;
        $addinfo->HEALTH_SCREEN_BODY =  $request->HEALTH_SCREEN_BODY;
        
        $addinfo->HEALTH_SCREEN_FM_DIA =  $request->HEALTH_SCREEN_FM_DIA;
        $addinfo->HEALTH_SCREEN_FM_BLOOD =  $request->HEALTH_SCREEN_FM_BLOOD;
        $addinfo->HEALTH_SCREEN_FM_GOUT =  $request->HEALTH_SCREEN_FM_GOUT;
        $addinfo->HEALTH_SCREEN_FM_KIDNEY =  $request->HEALTH_SCREEN_FM_KIDNEY;
        $addinfo->HEALTH_SCREEN_FM_HEART =  $request->HEALTH_SCREEN_FM_HEART;
        $addinfo->HEALTH_SCREEN_FM_BRAIN =  $request->HEALTH_SCREEN_FM_BRAIN;
        $addinfo->HEALTH_SCREEN_FM_EMPHY =  $request->HEALTH_SCREEN_FM_EMPHY;
        $addinfo->HEALTH_SCREEN_FM_UNKNOW =  $request->HEALTH_SCREEN_FM_UNKNOW;
        $addinfo->HEALTH_SCREEN_FM_OTHER =  $request->HEALTH_SCREEN_FM_OTHER;

        $addinfo->HEALTH_SCREEN_BS_DIA =  $request->HEALTH_SCREEN_BS_DIA;
        $addinfo->HEALTH_SCREEN_BS_BLOOD =  $request->HEALTH_SCREEN_BS_BLOOD;
        $addinfo->HEALTH_SCREEN_BS_GOUT =  $request->HEALTH_SCREEN_BS_GOUT;
        $addinfo->HEALTH_SCREEN_BS_KIDNEY =  $request->HEALTH_SCREEN_BS_KIDNEY;
        $addinfo->HEALTH_SCREEN_BS_HEART =  $request->HEALTH_SCREEN_BS_HEART;
        $addinfo->HEALTH_SCREEN_BS_BRAIN =  $request->HEALTH_SCREEN_BS_BRAIN;
        $addinfo->HEALTH_SCREEN_BS_EMPHY =  $request->HEALTH_SCREEN_BS_EMPHY;
        $addinfo->HEALTH_SCREEN_BS_UNKNOW =  $request->HEALTH_SCREEN_BS_UNKNOW;
        $addinfo->HEALTH_SCREEN_BS_OTHER =  $request->HEALTH_SCREEN_BS_OTHER;

        $addinfo->HEALTH_SCREEN_H_1 =  $request->HEALTH_SCREEN_H_1;
        $addinfo->HEALTH_SCREEN_H_2 =  $request->HEALTH_SCREEN_H_2;
        $addinfo->HEALTH_SCREEN_H_3 =  $request->HEALTH_SCREEN_H_3;
        $addinfo->HEALTH_SCREEN_H_4=  $request->HEALTH_SCREEN_H_4;
        $addinfo->HEALTH_SCREEN_H_5 =  $request->HEALTH_SCREEN_H_5;
        $addinfo->HEALTH_SCREEN_H_6 =  $request->HEALTH_SCREEN_H_6;
        $addinfo->HEALTH_SCREEN_H_7 =  $request->HEALTH_SCREEN_H_7;
        $addinfo->HEALTH_SCREEN_H_8 =  $request->HEALTH_SCREEN_H_8;
        $addinfo->HEALTH_SCREEN_H_9 =  $request->HEALTH_SCREEN_H_9;
        $addinfo->HEALTH_SCREEN_H_10 =  $request->HEALTH_SCREEN_H_10;
        $addinfo->HEALTH_SCREEN_H_11 =  $request->HEALTH_SCREEN_H_11;
        $addinfo->HEALTH_SCREEN_H_12 =  $request->HEALTH_SCREEN_H_12;
        $addinfo->HEALTH_SCREEN_H_13 =  $request->HEALTH_SCREEN_H_13;
        $addinfo->HEALTH_SCREEN_H_14 =  $request->HEALTH_SCREEN_H_14;
        $addinfo->HEALTH_SCREEN_H_15 =  $request->HEALTH_SCREEN_H_15;
        $addinfo->HEALTH_SCREEN_H_16 =  $request->HEALTH_SCREEN_H_16;
        $addinfo->HEALTH_SCREEN_H_17 =  $request->HEALTH_SCREEN_H_17;
        $addinfo->HEALTH_SCREEN_H_18 =  $request->HEALTH_SCREEN_H_18;
        $addinfo->HEALTH_SCREEN_H_19 =  $request->HEALTH_SCREEN_H_19;
        $addinfo->HEALTH_SCREEN_H_20 =  $request->HEALTH_SCREEN_H_20;
        $addinfo->HEALTH_SCREEN_H_21 =  $request->HEALTH_SCREEN_H_21;
        $addinfo->HEALTH_SCREEN_H_22 =  $request->HEALTH_SCREEN_H_22;
        $addinfo->HEALTH_SCREEN_H_23 =  $request->HEALTH_SCREEN_H_23;
        $addinfo->HEALTH_SCREEN_H_24 =  $request->HEALTH_SCREEN_H_24;
        $addinfo->HEALTH_SCREEN_H_25 =  $request->HEALTH_SCREEN_H_25;
        $addinfo->HEALTH_SCREEN_H_26 =  $request->HEALTH_SCREEN_H_26;
        $addinfo->HEALTH_SCREEN_H_27 =  $request->HEALTH_SCREEN_H_27;
        $addinfo->HEALTH_SCREEN_H_28 =  $request->HEALTH_SCREEN_H_28;
        $addinfo->HEALTH_SCREEN_H_29 =  $request->HEALTH_SCREEN_H_29;
        $addinfo->HEALTH_SCREEN_H_29_COMMENT =  $request->HEALTH_SCREEN_H_29_COMMENT;
        $addinfo->HEALTH_SCREEN_H_30 =  $request->HEALTH_SCREEN_H_30;
        $addinfo->HEALTH_SCREEN_H_30_COMMENT =  $request->HEALTH_SCREEN_H_30_COMMENT;
        $addinfo->HEALTH_SCREEN_H_31 =  $request->HEALTH_SCREEN_H_31;
        $addinfo->HEALTH_SCREEN_H_31_COMMENT =  $request->HEALTH_SCREEN_H_31_COMMENT;
        $addinfo->HEALTH_SCREEN_H_HAVE =  $request->HEALTH_SCREEN_H_HAVE;


        $addinfo->HEALTH_SCREEN_SMOK =  $request->HEALTH_SCREEN_SMOK;
        $addinfo->HEALTH_SCREEN_SMOK_AMOUNT =  $request->HEALTH_SCREEN_SMOK_AMOUNT;
        $addinfo->HEALTH_SCREEN_SMOK_TYPE =  $request->HEALTH_SCREEN_SMOK_TYPE;
        $addinfo->HEALTH_SCREEN_SMOK_TIME =  $request->HEALTH_SCREEN_SMOK_TIME;


        $addinfo->HEALTH_SCREEN_DRINK =  $request->HEALTH_SCREEN_DRINK;
        $addinfo->HEALTH_SCREEN_DRINK_AMOUNT =  $request->HEALTH_SCREEN_DRINK_AMOUNT;
      

        $addinfo->HEALTH_SCREEN_EXERCISE=  $request->HEALTH_SCREEN_EXERCISE;
     

        $addinfo->HEALTH_SCREEN_FOOD_1 =  $request->HEALTH_SCREEN_FOOD_1;
        $addinfo->HEALTH_SCREEN_FOOD_2 =  $request->HEALTH_SCREEN_FOOD_2;
        $addinfo->HEALTH_SCREEN_FOOD_3 =  $request->HEALTH_SCREEN_FOOD_3;
        $addinfo->HEALTH_SCREEN_FOOD_4 =  $request->HEALTH_SCREEN_FOOD_4;
        $addinfo->HEALTH_SCREEN_FOOD_5 =  $request->HEALTH_SCREEN_FOOD_5;

        $addinfo->HEALTH_SCREEN_DRIVE =  $request->HEALTH_SCREEN_DRIVE;
        $addinfo->HEALTH_SCREEN_SEX =  $request->HEALTH_SCREEN_SEX;

        $addinfo->HEALTH_SCREEN_DATE =  $DATEWANT;
        $addinfo->HEALTH_SCREEN_AGE =  $request->HEALTH_SCREEN_AGE;
        $addinfo->HEALTH_SCREEN_STATUS =  'SCREEN';

        $addinfo->save();
     

        return redirect()->route('health.checkup',['iduser'=>  $request->HEALTH_SCREEN_PERSON_ID]);
    
           

    }

    //============================================================================================================


    public function jobdescription(Request $request,$iduser)
    {
        if($request->method() === "POST"){
            $budgetyear = $request->budgetyear;
            $search = $request->search;
            $data_search = json_encode_u([
                'budgetyear' => $budgetyear,
                'search' => $search,
            ]);
            Cookie::queue('data_search',$data_search,120,$request->server('REQUEST_URI'));
        }elseif(!empty(Cookie::get('data_search'))){
            $data = json_decode(Cookie::get('data_search'));
            $budgetyear = $data->budgetyear;
            $search     = $data->search;
        }else{
            $budgetyear = getBudgetYear();
            $search     = '';
        }

        $drop_budgetyear = getBudgetYearAmount();
        $person_id = Auth::user()->PERSON_ID;
        $query = Infowork_job_person::select('infowork_job_person.*','infowork_job_descriptions.*'
        ,'p.HR_FNAME as p_fname' , 'p.HR_LNAME as p_lname'
        , 'p_c.HR_FNAME as p_c_fname' , 'p_c.HR_LNAME as p_c_lname'
        , 'p_a1.HR_FNAME as p_a1_fname' , 'p_a1.HR_LNAME as p_a1_lname'
        , 'p_a2.HR_FNAME as p_a2_fname' , 'p_a2.HR_LNAME as p_a2_lname')
        ->leftJoin('infowork_job_descriptions','infowork_job_descriptions.IWJOB_D_ID','infowork_job_person.IWJOB_D_ID')
        ->leftJoin('hrd_person as p','p.ID','infowork_job_person.PERSON_ID')
        ->leftJoin('hrd_person as p_c','p_c.ID','infowork_job_person.IWJP_CREATED_ID')
        ->leftJoin('hrd_person as p_a1','p_a1.ID','infowork_job_person.IWJP_ASSESSOR_ID_1')
        ->leftJoin('hrd_person as p_a2','p_a2.ID','infowork_job_person.IWJP_ASSESSOR_ID_2')
        ->where(function ($q) use ($search){
            $q->where('infowork_job_person.IWJOB_EXPECTED_RESULT','like','%'.$search.'%');
            $q->orWhere('infowork_job_descriptions.IWJD_NAME','like','%'.$search.'%');
        });
        if($budgetyear !== 'all'){
            $query = $query->where('infowork_job_person.IWJP_BUDGETYEAR',$budgetyear);
        }
        if($person_id !== 'all'){
            $query = $query->where('PERSON_ID',$person_id);
        }
        $infowork_person = $query->get();

        return view('person_work.personinfoworkjobdescription',compact(
            'infowork_person',
            'drop_budgetyear',
            'budgetyear',
            'person_id',
            'search'
        ));
      
      return view('person_work.personinfoworkjobdescription',[
            'inforpersonuser' => $inforperson,
            'inforpersonuserid' => $inforpersonid,
            'infojobdiss' => $infojobdis
            
        ]);
    }

    public function jobdescription_update_be_informed(Request $request,$iduser)
    {
        return Infowork_job_person::where('IWJOB_PERSON_ID',$request->id_job_person)->update([
            'IWJOB_BE_INFORMED' => 1,
            'IWJOB_BE_INFORMED_DATE' => date('Y-m-d')
        ]);
    }
    public function jobdescription_data_estimate_6($id_jobperson)
    {
        return view('person_work.personinfoworkjobdescription_data_estimate_6');
    }
    public function jobdescription_estimate(Request $request,$person_id){
        $permission_estimate_kpi = DB::table('infowork_job_person_permission')->where('IWJOB_PERMIS_PERSON_ID',Auth::user()->PERSON_ID)->first();
        if(empty($permission_estimate_kpi)){
            Session::flash('err','ไม่มีสิทธิ์ในการประเมิน');
            return redirect(route('person.infowork.jobdescriptions',Auth::user()->PERSON_ID));
        }
        if($request->method() === "POST"){
            $budgetyear = $request->budgetyear;
            $data_search = json_encode_u([
                'budgetyear' => $budgetyear,
            ]);
            Cookie::queue('data_search',$data_search,120,$request->server('REQUEST_URI'));
        }elseif(!empty(Cookie::get('data_search'))){
            $data = json_decode(Cookie::get('data_search'));
            $budgetyear = $data->budgetyear;
        }else{
            $budgetyear = getBudgetYear();
        }
        $drop_budgetyear = getBudgetYearAmount();

        $person = infowork_job_person_permission_list::rightJoin('hrd_person','hrd_person.ID','infowork_job_person_permission_list.IWJOB_PERMIS_LIST_PERSON_ID')
        ->where('infowork_job_person_permission_list.IWJOB_PERMIS_ID',$permission_estimate_kpi->IWJOB_PERMIS_ID)
        ->orWhere('hrd_person.ID',Auth::user()->PERSON_ID)
        ->get();
        $jobperson = Infowork_job_person::where('IWJP_BUDGETYEAR',$budgetyear)->get();
        foreach ($person as $key => $value) {
            $person[$key]->IS_KPI = 0;
        }
        foreach ($person as $key_person => $value_person) {
            foreach ($jobperson as $key_jobperson => $value_jobperson) {
                if($value_person->ID == $value_jobperson->PERSON_ID){
                    $person[$key]->IS_KPI = 1;
                }
            }
        }
        return view('person_work.personinfoworkjobdescription_estimate')->with([
            'drop_budgetyear'   => $drop_budgetyear,
            'budgetyear'        => $budgetyear ,
            'person'            => $person 
        ]);
    }

    public function personwork_estimate_kpi_person($budgetyear,$person_estimate_id,$iduser){
        $job = Infowork_job_person::getJobPersonByYearPersonJob($budgetyear,'all',Auth::user()->PERSON_ID);
        $assessor1 = 0;
        $assessor2 = 0;
        foreach($job as $row){
            if(empty($row->IWJP_ASSESSOR_ID_1)){
                $assessor1 = 1;
            }
            if(empty($row->IWJP_ASSESSOR_ID_2)){
                $assessor2 = 1;
            }
        }
        return view('person_work.personwork_estimate_kpi_person',compact(
            'budgetyear',
            'job',
            'person_estimate_id',
            'assessor1',
            'assessor2'
        ));
    }

    public function personwork_estimate_kpi_person_update(Request $request){
        foreach ($request->id_kpi as $key => $IWJOB_PERSON_LIST_ID) {
            $person_kpi_list = Infowork_job_person_list::leftJoin('infowork_job_person','infowork_job_person.IWJOB_PERSON_ID','infowork_job_person_list.IWJOB_PERSON_ID')
                                ->where('IWJOB_PERSON_LIST_ID',$IWJOB_PERSON_LIST_ID)->first();
            if(empty($person_kpi_list)){
                continue;
            }
            $person_kpi_list->IWJPL_NUMBER_1 = $request->number1[$key];
            $person_kpi_list->IWJPL_NUMBER_2 = $request->number2[$key];
            $person_kpi_list->IWJPL_NUMBER_3 = $request->number3[$key];
            $person_kpi_list->IWJPL_NUMBER_4 = empty($request->number4[$key])?0:$request->number4[$key];
            $person_kpi_list->IWJPL_NUMBER_5 = empty($request->number5[$key])?0:$request->number5[$key];
            $score = 0;
            while (true) {
                    if(empty($request->number1[$key])){
                        break;
                    }else{
                        $score = 1;
                    }
                    if(empty($request->number2[$key])){
                        break;
                    }else{
                        $score = 2;
                    }
                    if(empty($request->number3[$key])){
                        break;
                    }else{
                        $score = 3;
                    }
                    if(empty($request->number4[$key])){
                        break;
                    }else{
                        $score = 4;
                    }
                    if(empty($request->number5[$key])){
                        break;
                    }else{
                        $score = 5;
                    }
                    break;
            }
            $person_kpi_list->IWJPL_SCORE_A        = $score;
            $person_kpi_list->IWJPL_WEIGHT_B       = $request->weight[$key];
            $person_kpi_list->IWJPL_MULTIPLY_AB    = $score * $request->weight[$key];
            $person_kpi_list->IWJPL_TARGET         = $request->target[$key];
            $person_kpi_list->save();
                                // คำนวณคะแนนที่ได้ และคะแนนดิบที่ได้รับ
                                $before    =   [$request->performance_10[$key], 
                                                $request->performance_11[$key],
                                                $request->performance_12[$key],
                                                $request->performance_1[$key],
                                                $request->performance_2[$key],
                                                $request->performance_3[$key]];
                                $after      =   [$request->performance_4[$key],
                                                $request->performance_5[$key],
                                                $request->performance_6[$key],
                                                $request->performance_7[$key],
                                                $request->performance_8[$key],
                                                $request->performance_9[$key]];
                                $_12month   =  [$request->performance_10[$key], 
                                                $request->performance_11[$key],
                                                $request->performance_12[$key],
                                                $request->performance_1[$key],
                                                $request->performance_2[$key],
                                                $request->performance_3[$key],
                                                $request->performance_4[$key],
                                                $request->performance_5[$key],
                                                $request->performance_6[$key],
                                                $request->performance_7[$key],
                                                $request->performance_8[$key],
                                                $request->performance_9[$key]];
                                if($person_kpi_list->IWJPL_TYPE_CALCULATE == "calc_avg"){
                                    $result_before  = array_sum($before)/count($before);
                                    $result_after   = array_sum($after)/count($after);
                                    $result_12month = array_sum($_12month)/count($_12month);
                                }else if($person_kpi_list->IWJPL_TYPE_CALCULATE == "calc_max"){
                                    $result_before  = max($before);
                                    $result_after   = max($after);
                                    $result_12month = max($_12month);
                                }else if($person_kpi_list->IWJPL_TYPE_CALCULATE == "calc_last"){
                                    $result_before  = $before[count($before)-1];
                                    $result_after   = $after[count($after)-1];
                                    $result_12month = $_12month[count($_12month)-1];
                                }else if($person_kpi_list->IWJPL_TYPE_CALCULATE == "calc_sum"){
                                    $result_before  = array_sum($before);
                                    $result_after   = array_sum($after);
                                    $result_12month = array_sum($_12month);
                                }else{
                                    $result_before  = array_sum($before)/count($before);
                                    $result_after   = array_sum($after)/count($after);
                                    $result_12month = array_sum($_12month)/count($_12month);
                                }

                                // คำนวณคะแนน
                                $number1 = $person_kpi_list->IWJPL_NUMBER_1;
                                $number2 = $person_kpi_list->IWJPL_NUMBER_2;
                                $number3 = $person_kpi_list->IWJPL_NUMBER_3;
                                $number4 = $person_kpi_list->IWJPL_NUMBER_4;
                                $number5 = $person_kpi_list->IWJPL_NUMBER_5;
                                if($number1 < $number2){
                                    // คำนวณ 6 เดือนแรก
                                    if($result_before <= $number1){
                                        $score_before = 1 ;
                                    }elseif($result_before < $number2){
                                        $score_before = 1 + (($result_before-$number1)/($number2 - $number1));
                                    }elseif($result_before < $number3){
                                        $score_before = 2 + (($result_before-$number2)/($number3 - $number2));
                                    }elseif($result_before < $number4){
                                        $score_before = 3 + (($result_before-$number3)/($number4 - $number3));
                                    }elseif($result_before < $number5){
                                        $score_before = 4 + (($result_before-$number4)/($number5 - $number4));
                                    }elseif($result_before >= $number5){
                                        $score_before = 5;
                                    }
                                    // คำนวณ 6 เดือนหลัง
                                    if($result_after <= $number1){
                                        $score_after = 1 ;
                                    }elseif($result_after < $number2){
                                        $score_after = 1 + (($result_after-$number1)/($number2 - $number1));
                                    }elseif($result_after < $number3){
                                        $score_after = 2 + (($result_after-$number2)/($number3 - $number2));
                                    }elseif($result_after < $number4){
                                        $score_after = 3 + (($result_after-$number3)/($number4 - $number3));
                                    }elseif($result_after < $number5){
                                        $score_after = 4 + (($result_after-$number4)/($number5 - $number4));
                                    }elseif($result_after >= $number5){
                                        $score_after = 5;
                                    }
                                    // คำนวณ 12 เดือน
                                    if($result_12month <= $number1){
                                        $score_12month = 1 ;
                                    }elseif($result_12month < $number2){
                                        $score_12month = 1 + (($result_12month-$number1)/($number2 - $number1));
                                    }elseif($result_12month < $number3){
                                        $score_12month = 2 + (($result_12month-$number2)/($number3 - $number2));
                                    }elseif($result_12month < $number4){
                                        $score_12month = 3 + (($result_12month-$number3)/($number4 - $number3));
                                    }elseif($result_12month < $number5){
                                        $score_12month = 4 + (($result_12month-$number4)/($number5 - $number4));
                                    }elseif($result_12month >= $number5){
                                        $score_12month = 5;
                                    }
                                }else{
                                    // คำนวณ 6 เดือนแรก
                                    if($result_before >= $number1){
                                        $score_before = 1 ;
                                    }elseif($result_before > $number2){
                                        $score_before = 1 + (($number1-$result_before)/($number1 - $number2));
                                    }elseif($result_before > $number3){
                                        $score_before = 2 + (($number2-$result_before)/($number2 - $number3));
                                    }elseif($result_before > $number4){
                                        $score_before = 3 + (($number3-$result_before)/($number3 - $number4));
                                    }elseif($result_before > $number5){
                                        $score_before = 4 + (($number4-$result_before)/($number4 - $number5));
                                    }elseif($result_before <= $number5){
                                        $score_before = 5;
                                    }
                                    // คำนวณ 6 เดือนหลัง
                                    if($result_after >= $number1){
                                        $score_after = 1 ;
                                    }elseif($result_after > $number2){
                                        $score_after = 1 + (($number1-$result_after)/($number1 - $number2));
                                    }elseif($result_after > $number3){
                                        $score_after = 2 + (($number2-$result_after)/($number2 - $number3));
                                    }elseif($result_after > $number4){
                                        $score_after = 3 + (($number3-$result_after)/($number3 - $number4));
                                    }elseif($result_after > $number5){
                                        $score_after = 4 + (($number4-$result_after)/($number4 - $number5));
                                    }elseif($result_after <= $number5){
                                        $score_after = 5;
                                    }
                                    // คำนวณ 12 เดือน
                                    if($result_12month >= $number1){
                                        $score_12month = 1 ;
                                    }elseif($result_12month > $number2){
                                        $score_12month = 1 + (($result_12month-$number1)/($number2 - $number1));
                                    }elseif($result_12month > $number3){
                                        $score_12month = 2 + (($result_12month-$number2)/($number3 - $number2));
                                    }elseif($result_12month > $number4){
                                        $score_12month = 3 + (($result_12month-$number3)/($number4 - $number3));
                                    }elseif($result_12month > $number5){
                                        $score_12month = 4 + (($result_12month-$number4)/($number5 - $number4));
                                    }elseif($result_12month <= $number5){
                                        $score_12month = 5;
                                    }
                                }
            $person_kpi_list->IWJPL_PERFORMANCE_10 = $request->performance_10[$key];
            $person_kpi_list->IWJPL_PERFORMANCE_11 = $request->performance_11[$key];
            $person_kpi_list->IWJPL_PERFORMANCE_12 = $request->performance_12[$key];
            $person_kpi_list->IWJPL_PERFORMANCE_1 = $request->performance_1[$key];
            $person_kpi_list->IWJPL_PERFORMANCE_2 = $request->performance_2[$key];
            $person_kpi_list->IWJPL_PERFORMANCE_3 = $request->performance_3[$key];
            $person_kpi_list->IWJPL_PERFORMANCE_4 = $request->performance_4[$key];
            $person_kpi_list->IWJPL_PERFORMANCE_5 = $request->performance_5[$key];
            $person_kpi_list->IWJPL_PERFORMANCE_6 = $request->performance_6[$key];
            $person_kpi_list->IWJPL_PERFORMANCE_7 = $request->performance_7[$key];
            $person_kpi_list->IWJPL_PERFORMANCE_8 = $request->performance_8[$key];
            $person_kpi_list->IWJPL_PERFORMANCE_9 = $request->performance_9[$key];
            $person_kpi_list->IWJPL_PERFORMANCE_AVG_10_TO_3 = $result_before;
            $person_kpi_list->IWJPL_PERFORMANCE_AVG_4_TO_9  = $result_after;
            $person_kpi_list->IWJPL_PERFORMANCE_AVG         = $result_12month;
            $person_kpi_list->IWJPL_SCORE_RESULT_10_TO_3    = $score_before;
            $person_kpi_list->IWJPL_SCORE_RESULT_4_TO_9     = $score_after;
            $person_kpi_list->IWJPL_SCORE_RESULT_ALL        = $score_12month;
            $person_kpi_list->save();
            if($request->check_assessor == 1){
                $person_kpi_head = Infowork_job_person::find($person_kpi_list->IWJOB_PERSON_ID);
                if(empty($person_kpi_head->IWJP_ASSESSOR_ID_1)){
                    $person_kpi_head->IWJP_ASSESSOR_ID_1        = Auth::user()->PERSON_ID;
                    $person_kpi_head->IWJOB_PERSON_STATUS_ID    = 2;
                }
                $person_kpi_head->save();
            }else if($request->check_assessor == 2){
                $person_kpi_head = Infowork_job_person::find($person_kpi_list->IWJOB_PERSON_ID);
                if(empty($person_kpi_head->IWJP_ASSESSOR_ID_2)){
                    $person_kpi_head->IWJP_ASSESSOR_ID_2        = Auth::user()->PERSON_ID;
                    $person_kpi_head->IWJOB_PERSON_STATUS_ID    = 3;
                }
                $person_kpi_head->save();
            }
        }
        return redirect(route('person.infowork.jobdes_estimate',Auth::user()->PERSON_ID));
    }
    
    public function corecompetency_detail(Request $request,$iduser)
    {
        $email = Auth::user()->email;
        $inforpersonid = Person::where('ID','=',$iduser)->first();
            
        $inforperson =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
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

       $infoworkcorcom = DB::table('infowork_cor_com')->get();  
       $corecompetency = DB::table('infowork_cor_result')->where('COR_RESULT_PERSON_ID','=',$iduser)->get();

        return view('person_work.personinfoworkcorecompetency_detail',[
            'inforpersonuser' => $inforperson,
            'inforpersonuserid' => $inforpersonid,
            'infoworkcorcoms'=> $infoworkcorcom,
            'corecompetencys'=> $corecompetency
            
        ]);
    }


    public function personworkcorecompetency_detail_sub(Request $request,$idref,$idhr)
    {
       $infoworkcorcom = DB::table('infowork_cor_com')->get();
       $infoperson = DB::table('hrd_person')
                    ->leftJoin('hrd_prefix','hrd_prefix.HR_PREFIX_ID','=','hrd_person.HR_PREFIX_ID')
                    ->where('ID','=',$idhr)->first();
       $infocorresult = DB::table('infowork_cor_result')
                    ->leftJoin('hrd_person','hrd_person.ID','infowork_cor_result.COR_RESULT_PERSON_ID')
                    ->where('COR_RESULT_ID','=',$idref)->first(); 
        return view('person_work.personworkcorecompetency_detail_sub',[
            'infoworkcorcoms'=> $infoworkcorcom,
            'inforpersonuser'=> $infoperson,
            'infocorresult'=>$infocorresult
            
        ]);
    }

    


    public function corecompetency(Request $request,$iduser)
    {
        $email = Auth::user()->email;
        $inforpersonid = Person::where('ID','=',$iduser)->first();
            
        $inforperson =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
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

       $infoworkcorcom = DB::table('infowork_cor_com')->get();
      

        return view('person_work.personinfoworkcorecompetency',[
            'inforpersonuser' => $inforperson,
            'inforpersonuserid' => $inforpersonid,
            'infoworkcorcoms'=> $infoworkcorcom
        ]);
    }

    public function funtionalcompetency_detail(Request $request,$iduser)
    {
        $email = Auth::user()->email;
        $inforpersonid =  Person::where('ID','=',$iduser)->first();
            
        $inforperson =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
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

       $infoworkfuntion = DB::table('infowork_funtion')->get();

       $infoperson = DB::table('hrd_person')->where('ID','=',$iduser)->first();

       $corecompetency = DB::table('infowork_fun_result')->where('FUN_RESULT_PERSON_ID','=',$iduser)->get();
       


        return view('person_work.personinfoworkfuntionalcompetency_detail',[
            'inforpersonuser' => $inforperson,
            'inforpersonuserid' => $inforpersonid,
            'infoworkfuntions'=> $infoworkfuntion,
            'infoperson'=> $infoperson,
            'corecompetencys'=> $corecompetency
            
        ]);
    }


    
    public function personworkfuntionalcompetency_detail_sub(Request $request,$idref,$idhr)
    {
        $infoworkfuntion = DB::table('infowork_funtion')->get();
        $infoperson = DB::table('hrd_person')->where('ID','=',$idhr)->first();
        $infocorresult = DB::table('infowork_fun_result')->where('FUN_RESULT_ID','=',$idref)->first(); 
 
        return view('person_work.personworkfuntionalcompetency_detail_sub',[
            'infoworkfuntions'=> $infoworkfuntion,
            'infoperson'=> $infoperson,
            'infocorresult'=>$infocorresult
            
        ]);
    }

    

    public function funtionalcompetency(Request $request,$iduser)
    {
        $email = Auth::user()->email;
        $inforpersonid =  Person::where('ID','=',$iduser)->first();
            
        $inforperson =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
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

       $infoworkfuntion = DB::table('infowork_funtion')->get();

        return view('person_work.personinfoworkfuntionalcompetency',[
            'inforpersonuser' => $inforperson,
            'inforpersonuserid' => $inforpersonid,
            'infoworkfuntions'=> $infoworkfuntion
            
        ]);
    }

    ///////////////////////////// KPI //////////////////////////////////////
    public function personworkkpi(Request $request,$iduser){
        if($request->method() == "POST"){
            $budgetyear = getBudgetYear();
            $data_search = json_encode_u([
                'budgetyear' => $budgetyear,
            ]);
            Cookie::queue('data_search',$data_search,120,$request->server('REQUEST_URI'));
        }elseif(!empty(Cookie::get('data_search'))){
            $data = json_decode(Cookie::get('data_search'));
            $budgetyear = $data->budgetyear;
        }else{
            $budgetyear = getBudgetYear();
        }
        $job = Infowork_job_person::getJobPersonByYearPersonJob($budgetyear,'all',Auth::user()->PERSON_ID);
        return view('person_work.personinfowork_kpi',compact(
            'budgetyear',
            'job'
        ));
    }

    public function personworkkpi_user_update_kpi(Request $request,$iduser){
        foreach ($request->id_kpi as $key => $IWJOB_PERSON_LIST_ID) {
            $person_kpi_list = Infowork_job_person_list::leftJoin('infowork_job_person','infowork_job_person.IWJOB_PERSON_ID','infowork_job_person_list.IWJOB_PERSON_ID')
                                ->where('IWJOB_PERSON_LIST_ID',$IWJOB_PERSON_LIST_ID)->first();
            if(empty($person_kpi_list)){
                continue;
            }

                                // คำนวณคะแนนที่ได้ และคะแนนดิบที่ได้รับ
                                $before    =   [$request->performance_10[$key], 
                                                $request->performance_11[$key],
                                                $request->performance_12[$key],
                                                $request->performance_1[$key],
                                                $request->performance_2[$key],
                                                $request->performance_3[$key]];
                                $after      =   [$request->performance_4[$key],
                                                $request->performance_5[$key],
                                                $request->performance_6[$key],
                                                $request->performance_7[$key],
                                                $request->performance_8[$key],
                                                $request->performance_9[$key]];
                                $_12month   =  [$request->performance_10[$key], 
                                                $request->performance_11[$key],
                                                $request->performance_12[$key],
                                                $request->performance_1[$key],
                                                $request->performance_2[$key],
                                                $request->performance_3[$key],
                                                $request->performance_4[$key],
                                                $request->performance_5[$key],
                                                $request->performance_6[$key],
                                                $request->performance_7[$key],
                                                $request->performance_8[$key],
                                                $request->performance_9[$key]];
                                if($person_kpi_list->IWJPL_TYPE_CALCULATE == "calc_avg"){
                                    $result_before  = array_sum($before)/count($before);
                                    $result_after   = array_sum($after)/count($after);
                                    $result_12month = array_sum($_12month)/count($_12month);
                                }else if($person_kpi_list->IWJPL_TYPE_CALCULATE == "calc_max"){
                                    $result_before  = max($before);
                                    $result_after   = max($after);
                                    $result_12month = max($_12month);
                                }else if($person_kpi_list->IWJPL_TYPE_CALCULATE == "calc_last"){
                                    $result_before  = $before[count($before)-1];
                                    $result_after   = $after[count($after)-1];
                                    $result_12month = $_12month[count($_12month)-1];
                                }else if($person_kpi_list->IWJPL_TYPE_CALCULATE == "calc_sum"){
                                    $result_before  = array_sum($before);
                                    $result_after   = array_sum($after);
                                    $result_12month = array_sum($_12month);
                                }else{
                                    $result_before  = array_sum($before)/count($before);
                                    $result_after   = array_sum($after)/count($after);
                                    $result_12month = array_sum($_12month)/count($_12month);
                                }

                                // คำนวณคะแนน
                                $number1 = $person_kpi_list->IWJPL_NUMBER_1;
                                $number2 = $person_kpi_list->IWJPL_NUMBER_2;
                                $number3 = $person_kpi_list->IWJPL_NUMBER_3;
                                $number4 = $person_kpi_list->IWJPL_NUMBER_4;
                                $number5 = $person_kpi_list->IWJPL_NUMBER_5;
                                if($number1 < $number2){
                                    // คำนวณ 6 เดือนแรก
                                    if($result_before <= $number1){
                                        $score_before = 1 ;
                                    }elseif($result_before < $number2){
                                        $score_before = 1 + (($result_before-$number1)/($number2 - $number1));
                                    }elseif($result_before < $number3){
                                        $score_before = 2 + (($result_before-$number2)/($number3 - $number2));
                                    }elseif($result_before < $number4){
                                        $score_before = 3 + (($result_before-$number3)/($number4 - $number3));
                                    }elseif($result_before < $number5){
                                        $score_before = 4 + (($result_before-$number4)/($number5 - $number4));
                                    }elseif($result_before >= $number5){
                                        $score_before = 5;
                                    }
                                    // คำนวณ 6 เดือนหลัง
                                    if($result_after <= $number1){
                                        $score_after = 1 ;
                                    }elseif($result_after < $number2){
                                        $score_after = 1 + (($result_after-$number1)/($number2 - $number1));
                                    }elseif($result_after < $number3){
                                        $score_after = 2 + (($result_after-$number2)/($number3 - $number2));
                                    }elseif($result_after < $number4){
                                        $score_after = 3 + (($result_after-$number3)/($number4 - $number3));
                                    }elseif($result_after < $number5){
                                        $score_after = 4 + (($result_after-$number4)/($number5 - $number4));
                                    }elseif($result_after >= $number5){
                                        $score_after = 5;
                                    }
                                    // คำนวณ 12 เดือน
                                    if($result_12month <= $number1){
                                        $score_12month = 1 ;
                                    }elseif($result_12month < $number2){
                                        $score_12month = 1 + (($result_12month-$number1)/($number2 - $number1));
                                    }elseif($result_12month < $number3){
                                        $score_12month = 2 + (($result_12month-$number2)/($number3 - $number2));
                                    }elseif($result_12month < $number4){
                                        $score_12month = 3 + (($result_12month-$number3)/($number4 - $number3));
                                    }elseif($result_12month < $number5){
                                        $score_12month = 4 + (($result_12month-$number4)/($number5 - $number4));
                                    }elseif($result_12month >= $number5){
                                        $score_12month = 5;
                                    }
                                }else{
                                    // คำนวณ 6 เดือนแรก
                                    if($result_before >= $number1){
                                        $score_before = 1 ;
                                    }elseif($result_before > $number2){
                                        $score_before = 1 + (($number1-$result_before)/($number1 - $number2));
                                    }elseif($result_before > $number3){
                                        $score_before = 2 + (($number2-$result_before)/($number2 - $number3));
                                    }elseif($result_before > $number4){
                                        $score_before = 3 + (($number3-$result_before)/($number3 - $number4));
                                    }elseif($result_before > $number5){
                                        $score_before = 4 + (($number4-$result_before)/($number4 - $number5));
                                    }elseif($result_before <= $number5){
                                        $score_before = 5;
                                    }
                                    // คำนวณ 6 เดือนหลัง
                                    if($result_after >= $number1){
                                        $score_after = 1 ;
                                    }elseif($result_after > $number2){
                                        $score_after = 1 + (($number1-$result_after)/($number1 - $number2));
                                    }elseif($result_after > $number3){
                                        $score_after = 2 + (($number2-$result_after)/($number2 - $number3));
                                    }elseif($result_after > $number4){
                                        $score_after = 3 + (($number3-$result_after)/($number3 - $number4));
                                    }elseif($result_after > $number5){
                                        $score_after = 4 + (($number4-$result_after)/($number4 - $number5));
                                    }elseif($result_after <= $number5){
                                        $score_after = 5;
                                    }
                                    // คำนวณ 12 เดือน
                                    if($result_12month >= $number1){
                                        $score_12month = 1 ;
                                    }elseif($result_12month > $number2){
                                        $score_12month = 1 + (($result_12month-$number1)/($number2 - $number1));
                                    }elseif($result_12month > $number3){
                                        $score_12month = 2 + (($result_12month-$number2)/($number3 - $number2));
                                    }elseif($result_12month > $number4){
                                        $score_12month = 3 + (($result_12month-$number3)/($number4 - $number3));
                                    }elseif($result_12month > $number5){
                                        $score_12month = 4 + (($result_12month-$number4)/($number5 - $number4));
                                    }elseif($result_12month <= $number5){
                                        $score_12month = 5;
                                    }
                                }

            if(empty($person_kpi_list->IWJP_ASSESSOR_ID_1)){       
                $person_kpi_list->IWJPL_PERFORMANCE_10 = $request->performance_10[$key];
                $person_kpi_list->IWJPL_PERFORMANCE_11 = $request->performance_11[$key];
                $person_kpi_list->IWJPL_PERFORMANCE_12 = $request->performance_12[$key];
                $person_kpi_list->IWJPL_PERFORMANCE_1 = $request->performance_1[$key];
                $person_kpi_list->IWJPL_PERFORMANCE_2 = $request->performance_2[$key];
                $person_kpi_list->IWJPL_PERFORMANCE_3 = $request->performance_3[$key];
                $person_kpi_list->IWJPL_PERFORMANCE_4 = $request->performance_4[$key];
                $person_kpi_list->IWJPL_PERFORMANCE_5 = $request->performance_5[$key];
                $person_kpi_list->IWJPL_PERFORMANCE_6 = $request->performance_6[$key];
                $person_kpi_list->IWJPL_PERFORMANCE_7 = $request->performance_7[$key];
                $person_kpi_list->IWJPL_PERFORMANCE_8 = $request->performance_8[$key];
                $person_kpi_list->IWJPL_PERFORMANCE_9 = $request->performance_9[$key];
                $person_kpi_list->IWJPL_PERFORMANCE_9 = $request->performance_9[$key];
                $person_kpi_list->IWJPL_PERFORMANCE_AVG_10_TO_3 = $result_before;
                $person_kpi_list->IWJPL_PERFORMANCE_AVG_4_TO_9  = $result_after;
                $person_kpi_list->IWJPL_PERFORMANCE_AVG         = $result_12month;
                $person_kpi_list->IWJPL_SCORE_RESULT_10_TO_3    = $score_before;
                $person_kpi_list->IWJPL_SCORE_RESULT_4_TO_9     = $score_after;
                $person_kpi_list->IWJPL_SCORE_RESULT_ALL        = $score_12month;
                $person_kpi_list->save();
            }else if(!empty($person_kpi_list->IWJP_ASSESSOR_ID_1) && empty($person_kpi_list->IWJP_ASSESSOR_ID_2)){
                $person_kpi_list->IWJPL_PERFORMANCE_4 = $request->performance_4[$key];
                $person_kpi_list->IWJPL_PERFORMANCE_5 = $request->performance_5[$key];
                $person_kpi_list->IWJPL_PERFORMANCE_6 = $request->performance_6[$key];
                $person_kpi_list->IWJPL_PERFORMANCE_7 = $request->performance_7[$key];
                $person_kpi_list->IWJPL_PERFORMANCE_8 = $request->performance_8[$key];
                $person_kpi_list->IWJPL_PERFORMANCE_9 = $request->performance_9[$key];
                $person_kpi_list->IWJPL_PERFORMANCE_AVG_10_TO_3 = $result_before;
                $person_kpi_list->IWJPL_PERFORMANCE_AVG_4_TO_9  = $result_after;
                $person_kpi_list->IWJPL_PERFORMANCE_AVG         = $result_12month;
                $person_kpi_list->IWJPL_SCORE_RESULT_10_TO_3    = $score_before;
                $person_kpi_list->IWJPL_SCORE_RESULT_4_TO_9     = $score_after;
                $person_kpi_list->IWJPL_SCORE_RESULT_ALL        = $score_12month;
                $person_kpi_list->save();
            }
        }
        return redirect(route('pwork.kpi',Auth::user()->PERSON_ID));
    }
    public static function getKpi($jobperson_id){
        $result = Infowork_job_person_list::where('IWJOB_PERSON_ID',$jobperson_id)
                    ->select('infowork_kpi.IWKPI_NAME','infowork_job_person_list.*')
                    ->leftJoin('infowork_kpi','infowork_kpi.IWKPI_ID','infowork_job_person_list.IWKPI_ID')
                    ->get();
        return $result;
    }

    public function kpis(Request $request,$iduser)
    {
        $email = Auth::user()->email;
        $inforpersonid =  Person::where('ID','=',$iduser)->first();
            
        $inforperson =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
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

       
       $infokpiorg = DB::table('plan_kpi')->get();

       $infokpiperson = DB::table('infowork_kpis')->get();
      
      

        return view('person_work.personinfoworkkpis',[
            'inforpersonuser' => $inforperson,
            'inforpersonuserid' => $inforpersonid,
            'infokpiorgs'=> $infokpiorg,
            'infokpipersons'=> $infokpiperson,
            
        ]);
    }
    
    public function personworkkpis_detail(Request $request,$iduser)
    {
        $email = Auth::user()->email;
        $inforpersonid =  Person::where('ID','=',$iduser)->first();
            
        $inforperson =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
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

       //dd($infoeducation);
       
       $infokpiorg = DB::table('plan_kpi')->get();

       $infokpiperson = DB::table('infowork_kpis')->get();
      
      

        return view('person_work.personinfoworkkpis_detail',[
            'inforpersonuser' => $inforperson,
            'inforpersonuserid' => $inforpersonid,
            'infokpiorgs'=> $infokpiorg,
            'infokpipersons'=> $infokpiperson,
            
        ]);
    }
    ///////////////////////////// END KPI //////////////////////////////////////
    
    // ========================= ตั้งค่าระดับการประเมิน =========================
    public function personworkcorecompetency_setup(Request $request,$iduser)
    {
        $inforpersonid =  Person::where('ID','=',$iduser)->first();
        $inforperson =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
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

     
        $infocom = DB::table('infowork_cor_com')->get();

        $budgetyear = DB::table('budget_year')->get();

        return view('person_work.personworkcorecompetency_setup',[
            'inforpersonuser' => $inforperson,
            'inforpersonuserid' => $inforpersonid,
            'budgetyears' => $budgetyear,
            'infocoms' => $infocom,
            
        ]);
    }

    public function personworkcorecompetency_setupupdate(Request $request)
    {
            $COR_COM_SET_PERSON_ID = $request->COR_COM_SET_PERSON_ID;
            $COR_COM_SET_YEAR = $request->COR_COM_SET_YEAR;
            $COR_COM_SET_LEVEL_ID = $request->COR_COM_SET_LEVEL_ID;
            $COR_COM_SET_LEVEL_SUB_MAX = $request->COR_COM_SET_LEVEL_SUB_MAX;

            $number =count($COR_COM_SET_LEVEL_ID);
            $count = 0;
            for($count = 0; $count < $number; $count++)
            {  
               $addsup = new Infoworkcorcomsetup();
               $addsup->COR_COM_SET_PERSON_ID = $COR_COM_SET_PERSON_ID;
               $addsup->COR_COM_SET_YEAR = $COR_COM_SET_YEAR;
               $addsup->COR_COM_SET_LEVEL_ID = $COR_COM_SET_LEVEL_ID[$count];
               $addsup->COR_COM_SET_LEVEL_SUB_MAX = $COR_COM_SET_LEVEL_SUB_MAX[$count];
               $addsup->save(); 
            }
        return redirect(url('person_work/personworkcorecompetency_detail/'.Auth()->user()->PERSON_ID));
    }

    public function personworkfuntionalcompetency_setup(Request $request,$iduser)
    {
        $inforpersonid =  Person::where('ID','=',$iduser)->first();
        $inforperson =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
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
      $infofun = DB::table('infowork_funtion')->get();
        return view('person_work.personworkfuntionalcompetency_setup',[
            'inforpersonuser' => $inforperson,
            'inforpersonuserid' => $inforpersonid,
            'infofuns' => $infofun,
            
        ]);
    }

    public function carcalendarhealth(Request $request,$iduser)
    {
        $inforpersonid =  Person::where('ID','=',$iduser)->first();
        $inforperson =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
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

        $daycheck = Healthscreen::leftJoin('hrd_person','hrd_person.ID','=','health_screen.HEALTH_SCREEN_PERSON_ID')
        ->get();
        return view('person_work.carcalendarhealth',[
            'inforperson' => $inforperson,
            'inforpersonid' => $inforpersonid,
            'daychecks' => $daycheck,
        ]);
    }
    
    public function personworkfuntionalcompetency_setupupdate(Request $request)
    {
        $FUNTION_SET_PERSON_ID = $request->FUNTION_SET_PERSON_ID;
        $FUNTION_SET_YEAR = $request->FUNTION_SET_YEAR;
        $FUNTION_SET_LEVEL_ID = $request->FUNTION_SET_LEVEL_ID;
        $FUNTION_SET_LEVEL_SUB_MAX = $request->FUNTION_SET_LEVEL_SUB_MAX;
        $number =count($FUNTION_SET_LEVEL_ID);
        $count = 0;
        for($count = 0; $count < $number; $count++) { 
            $addsup=new Infoworkfunctionsetup(); 
            $addsup->FUNTION_SET_PERSON_ID = $FUNTION_SET_PERSON_ID;
            $addsup->FUNTION_SET_YEAR = $FUNTION_SET_YEAR;
            $addsup->FUNTION_SET_LEVEL_ID = $FUNTION_SET_LEVEL_ID[$count];
            $addsup->FUNTION_SET_LEVEL_SUB_MAX = $FUNTION_SET_LEVEL_SUB_MAX[$count];
            $addsup->save();
        }
        return redirect(url('person_work/personworkfuntionalcompetency_setup/'.$FUNTION_SET_PERSON_ID));
    }

    public function healthpdf($idref)
    {     
        $infomation = DB::table('health_screen')->where('HEALTH_SCREEN_ID','=',$idref)->first();
        $inforperson =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
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
        ->where('hrd_person.ID','=',$infomation->HEALTH_SCREEN_PERSON_ID)->first();

        $org = DB::table('info_org')->where('ORG_ID','=','1')->first();

        $infolab =  DB::table('health_screen_confirm')->where('HEALTH_SCREEN_ID','=',$idref)->get();
        $sumamount =  DB::table('health_screen_confirm')->where('HEALTH_SCREEN_ID','=',$idref)->SUM('HEALTH_SCREEN_CON_SUMPICE');

        $pdf = PDF::loadView('person_work.healthpdf',[
            'infomation' =>   $infomation,
            'inforperson' =>   $inforperson,
            'org' =>   $org,
            'sumamount' =>   $sumamount,
            'infolabs' =>   $infolab, 
        ]);

      return @$pdf->stream();
    }
    public static function checkfamily($id)
    {
        $check = DB::table('health_screen')->where('HEALTH_SCREEN_ID','=',$id)
                ->where(function ($q){
                    $q->where('HEALTH_SCREEN_FM_DIA','on');
                    $q->orWhere('HEALTH_SCREEN_FM_BLOOD','on');
                    $q->orWhere('HEALTH_SCREEN_FM_GOUT','on');
                    $q->orWhere('HEALTH_SCREEN_FM_KIDNEY','on');
                    $q->orWhere('HEALTH_SCREEN_FM_HEART','on');
                    $q->orWhere('HEALTH_SCREEN_FM_BRAIN','on');
                    $q->orWhere('HEALTH_SCREEN_FM_EMPHY','on');
                    $q->orWhere('HEALTH_SCREEN_FM_UNKNOW','on');
                    $q->orWhere('HEALTH_SCREEN_FM_OTHER','on');
                    $q->orWhere('HEALTH_SCREEN_BS_DIA','on');
                    $q->orWhere('HEALTH_SCREEN_BS_BLOOD','on');
                    $q->orWhere('HEALTH_SCREEN_BS_GOUT','on');
                    $q->orWhere('HEALTH_SCREEN_BS_KIDNEY','on');
                    $q->orWhere('HEALTH_SCREEN_BS_HEART','on');
                    $q->orWhere('HEALTH_SCREEN_BS_BRAIN','on');
                    $q->orWhere('HEALTH_SCREEN_BS_EMPHY','on');
                    $q->orWhere('HEALTH_SCREEN_BS_UNKNOW','on');
                    $q->orWhere('HEALTH_SCREEN_BS_OTHER','on');
                })->count();
      
    if($check != 0){
        $echo =  'เสี่ยง';
    }else{
        $echo =  'ไม่เสี่ยง';
    }    
        return $echo;
    }

    public static function checkillness($id)
    {
        $check = DB::table('health_screen')->where('HEALTH_SCREEN_ID','=',$id)
                ->where(function ($q){
                    $q->where('HEALTH_SCREEN_H_1','have');
                    $q->orWhere('HEALTH_SCREEN_H_2','have');
                    $q->orWhere('HEALTH_SCREEN_H_3','have');
                    $q->orWhere('HEALTH_SCREEN_H_4','have');
                    $q->orWhere('HEALTH_SCREEN_H_5','have');
                    $q->orWhere('HEALTH_SCREEN_H_6','have');
                    $q->orWhere('HEALTH_SCREEN_H_7','have');
                    $q->orWhere('HEALTH_SCREEN_H_8','have');
                    $q->orWhere('HEALTH_SCREEN_H_9','have');
                    $q->orWhere('HEALTH_SCREEN_H_10','have');
                    $q->orWhere('HEALTH_SCREEN_H_11','have');
                    $q->orWhere('HEALTH_SCREEN_H_12','have');
                    $q->orWhere('HEALTH_SCREEN_H_13','have');
                    $q->orWhere('HEALTH_SCREEN_H_14','have');
                    $q->orWhere('HEALTH_SCREEN_H_15','have');
                    $q->orWhere('HEALTH_SCREEN_H_16','have');
                    $q->orWhere('HEALTH_SCREEN_H_17','have');
                    $q->orWhere('HEALTH_SCREEN_H_18','have');
                    $q->orWhere('HEALTH_SCREEN_H_19','have');
                    $q->orWhere('HEALTH_SCREEN_H_20','have');
                    $q->orWhere('HEALTH_SCREEN_H_21','have');
                    $q->orWhere('HEALTH_SCREEN_H_22','have');
                    $q->orWhere('HEALTH_SCREEN_H_23','have');
                    $q->orWhere('HEALTH_SCREEN_H_24','have');
                    $q->orWhere('HEALTH_SCREEN_H_25','have');
                    $q->orWhere('HEALTH_SCREEN_H_26','have');
                    $q->orWhere('HEALTH_SCREEN_H_27','have');
                    $q->orWhere('HEALTH_SCREEN_H_28','have');
                    $q->orWhere('HEALTH_SCREEN_H_29','have');
                    $q->orWhere('HEALTH_SCREEN_H_30','have');
                    $q->orWhere('HEALTH_SCREEN_H_31','have');
                })->count();
      
        if($check != 0){
            $echo =  'เสี่ยง';
        }else{
            $echo =  'ไม่เสี่ยง';
        }    
        return $echo;
    }
    public static function checksmok($id)
    {
      
        $check = DB::table('health_screen')->select('HEALTH_SCREEN_SMOK')->where('HEALTH_SCREEN_ID','=',$id)->first();
        $echo = 'ไม่ระบุ';
        if($check->HEALTH_SCREEN_SMOK === 'smok'){
            $echo = 'สูบ';
        }else if($check->HEALTH_SCREEN_SMOK === 'usesmok'){
            $echo =  'เคยสูบ';
        }else if($check->HEALTH_SCREEN_SMOK === 'onsmok'){
            $echo =  'ไม่สูบ';
        }
        return $echo;

    }  

    public static function checkdrink($id)
    {
        $check = DB::table('health_screen')->select('HEALTH_SCREEN_DRINK')->where('HEALTH_SCREEN_ID','=',$id)->first();
        $echo = 'ไม่ระบุ';
        if($check->HEALTH_SCREEN_DRINK === 'drink'){
            $echo = 'ดื่ม';
        }else if($check->HEALTH_SCREEN_DRINK === 'nodrink'){
            $echo =  'ไม่ดื่ม';
        }else if($check->HEALTH_SCREEN_DRINK === 'usedrink'){
            $echo =  'เคยดื่ม';
        }
        return $echo;
    } 

    public static function checkex($id)
    {
      
        $check = DB::table('health_screen')->where('HEALTH_SCREEN_ID','=',$id)
                ->where(function ($q){
                    $q->where('HEALTH_SCREEN_EXERCISE','=','3');
                    $q->orWhere('HEALTH_SCREEN_EXERCISE','=','4');
                })->count();
      
        if($check != 0){
            $echo =  'เสี่ยง';
        }else{
            $echo =  'ไม่เสี่ยง';
        }    
        return $echo;
    } 

    public static function checklike($id)
    {
       
        $check = DB::table('health_screen')->where('HEALTH_SCREEN_ID','=',$id)
        ->where(function ($q){
            $q->where('HEALTH_SCREEN_FOOD_1','=','on');
            $q->orWhere('HEALTH_SCREEN_FOOD_2','=','on');
            $q->orWhere('HEALTH_SCREEN_FOOD_3','=','on');
            $q->orWhere('HEALTH_SCREEN_FOOD_4','=','on');
        })->count();
       
        if($check != 0){
            $echo =  'เสี่ยง';
        }else{
            $echo =  'ไม่เสี่ยง';
        }    
        return $echo;
    } 

    public static function checkcar($id)
    {
      
        $check = DB::table('health_screen')->where('HEALTH_SCREEN_ID','=',$id)
        ->where(function ($q){
            $q->where('HEALTH_SCREEN_DRIVE','=','3');
            $q->orWhere('HEALTH_SCREEN_DRIVE','=','4');
        })->count();
    
        if($check != 0){
            $echo =  'เสี่ยง';
        }else{
            $echo =  'ไม่เสี่ยง';
        }    
            return $echo;

    } 

    public static function checksex($id)
    {
      
        $check = DB::table('health_screen')->where('HEALTH_SCREEN_ID','=',$id)
        ->where(function ($q){
            $q->where('HEALTH_SCREEN_SEX','=','4');
            $q->orWhere('HEALTH_SCREEN_SEX','=','5');
        })->count();

        if($check != 0){
            $echo =  'ไม่เสี่ยง';
        }else{
            $echo =  'เสี่ยง';
        }    
            return $echo;

    } 


    public static function checkbmi($id)
    {
        $bmi = DB::table('health_screen')->where('HEALTH_SCREEN_ID','=',$id)->first();

        $HEALTH_SCREEN_HEIGHT = $bmi->HEALTH_SCREEN_HEIGHT;
        $HEALTH_SCREEN_WEIGHT = $bmi->HEALTH_SCREEN_WEIGHT;
    
        if($HEALTH_SCREEN_HEIGHT !== '' && $HEALTH_SCREEN_HEIGHT !== null && $HEALTH_SCREEN_WEIGHT  !== '' && $HEALTH_SCREEN_WEIGHT !== null){
        $output = $HEALTH_SCREEN_WEIGHT/(($HEALTH_SCREEN_HEIGHT/100)*($HEALTH_SCREEN_HEIGHT/100));
        $resualbmi = number_format($output,2);
        }else{
            $resualbmi ='';
        }

        if($resualbmi < 18.50){
            $result =  'นน. ต่ำกว่าเกณฑ์';
        }else if($resualbmi >= 18.50 && $resualbmi <= 22.99){
            $result =  'สมส่วน';
        }else if($resualbmi > 22.99 && $resualbmi <= 24.99){
            $result =  'น้ำหนักเกิน';
        }else if($resualbmi > 24.99 && $resualbmi <= 29.99){
            $result =  'โรคอ้วน';
        }else if($resualbmi > 29.99){
            $result =  'โรคอ้วนอันตราย';
        }else{
            $result = '';
        }
        

        

            return $result;

    }  



    function checkdateyear(Request $request)
    {
    $IDUSER = $request->get('IDUSER');
    $DATE_WANT = $request->get('HEALTH_SCREEN_DATE');
    $HEALTH_SCREEN_YEAR = $request->get('HEALTH_SCREEN_YEAR');

    if($DATE_WANT != ''){
        $STARTDAY = Carbon::createFromFormat('d/m/Y', $DATE_WANT)->format('Y-m-d');
        $date_arrary_st=explode("-",$STARTDAY);  
        $y_sub_st = $date_arrary_st[0]; 
        
        if($y_sub_st >= 2500){
            $y_st = $y_sub_st-543;
        }else{
            $y_st = $y_sub_st;
        }
        $m_st = $date_arrary_st[1];
        $d_st = $date_arrary_st[2];  
        $DATEWANT= $y_st."-".$m_st."-".$d_st;
        }else{
        $DATEWANT= '';
    }


    $checkyear = DB::table('health_screen')->where('HEALTH_SCREEN_DATE','=',$DATEWANT)->where('HEALTH_SCREEN_PERSON_ID','=',$IDUSER)->count();



            if($checkyear > 0){
                $result = '<p style="color:red;font-size: 19px;">ท่านได้ทำการบึนทึกการคัดกรองในวันดังกล่าวแล้ว !! </p>';
        
            }else{
                $result = '';

            }

            
    
    echo $result;

    }


    //คำนวณดัชนีมวลกาย


    function calbmi(Request $request)
    {

    $HEALTH_SCREEN_HEIGHT = $request->get('HEALTH_SCREEN_HEIGHT');
    $HEALTH_SCREEN_WEIGHT = $request->get('HEALTH_SCREEN_WEIGHT');

    $output = $HEALTH_SCREEN_WEIGHT/(($HEALTH_SCREEN_HEIGHT/100)*($HEALTH_SCREEN_HEIGHT/100));
    $bmi = number_format($output,2);

    
    $result = $bmi.'<input type="hidden" name = "HEALTH_SCREEN_BODY"  id="HEALTH_SCREEN_BODY" value= "'.$bmi.'"class="form-control input-sm" style=" font-family: \'Kanit\', sans-serif;" >';

    
    echo $result;

    }



    function bodysize(Request $request)
    {

        $resualbmi = $request->get('HEALTH_SCREEN_BODY');
        


        if($resualbmi < 18.50){
            $result =  '<p >นน. ต่ำกว่าเกณฑ์</p>';
        }else if($resualbmi >= 18.50 && $resualbmi <= 22.99){
            $result =  '<p style="color:#228B22">สมส่วน</p>';
        }else if($resualbmi > 22.99 && $resualbmi <= 24.99){
            $result =  '<p style="color:#FFD700">น้ำหนักเกิน</p>';
        }else if($resualbmi > 24.99 && $resualbmi <= 29.99){
            $result =  '<p style="color:#FF8C00">โรคอ้วน</p>';
        }else if($resualbmi > 29.99){
            $result =  '<p style="color:#FF4500">โรคอ้วนอันตราย</p>';
        }else{
            $result = '';
        }
        

        
        echo $result;

    }


}


