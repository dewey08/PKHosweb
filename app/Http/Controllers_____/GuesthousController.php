<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\DB;
use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use App\Models\Guesthouspetition;
use App\Models\Guesthousproblem;
use App\Models\Guesthousinfomation;


class GuesthousController extends Controller
{
    public function guesthouse_info(Request $request,$iduser)
    {
        $email = Auth::user()->email;
        $inforpersonid =  $iduser;
            
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

       $ckeckleave = DB::table('guesthous_infomation_person')->where('INFMATION_PERSON_HRID','=',$iduser)->where('INFMATION_PERSON_STATUS','=','1')->count();


       if($ckeckleave !== 0){

        $indinfo = DB::table('guesthous_infomation_person')->where('INFMATION_PERSON_HRID','=',$iduser)->where('INFMATION_PERSON_STATUS','=','1')->first();

        $id = $indinfo->INFMATION_ID;

        $infoguesthouse = DB::table('guesthous_infomation')
        ->leftJoin('supplies_location','supplies_location.LOCATION_ID','=','guesthous_infomation.LOCATION_ID')
        ->leftJoin('hrd_person','hrd_person.ID','=','guesthous_infomation.INFMATION_HR_ID')
        ->where('INFMATION_ID','=',$id)->first();


        if($infoguesthouse == null){
            $infoguesthousevalue = 0;
        }else{
            $infoguesthousevalue = $infoguesthouse->INFMATION_TYPE;
        }
   

        if($infoguesthousevalue  == '1'){


            
        $detailstay =  DB::table('guesthous_infomation')
        ->leftjoin('guesthous_infomation_person','guesthous_infomation.INFMATION_ID','=','guesthous_infomation_person.INFMATION_ID')
        ->leftJoin('supplies_location','supplies_location.LOCATION_ID','=','guesthous_infomation.LOCATION_ID')
        ->leftJoin('supplies_location_level','supplies_location_level.LOCATION_LEVEL_ID','=','guesthous_infomation_person.LOCATION_LEVEL_ID')
        ->leftJoin('supplies_location_level_room','supplies_location_level_room.LEVEL_ROOM_ID','=','guesthous_infomation_person.LEVEL_ROOM_ID')
        ->where('guesthous_infomation.INFMATION_ID','=', $id)
        ->where('guesthous_infomation_person.LOCATION_LEVEL_ID','=',$indinfo->LOCATION_LEVEL_ID)
        ->where('guesthous_infomation_person.LEVEL_ROOM_ID','=',$indinfo->LEVEL_ROOM_ID)
        ->where('guesthous_infomation_person.INFMATION_PERSON_STATUS','=','1')
        ->first();


            $infoguesthousperson  = DB::table('guesthous_infomation_person')
            ->leftJoin('hrd_person','hrd_person.ID','=','guesthous_infomation_person.INFMATION_PERSON_HRID')
            ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
            ->where('INFMATION_PERSON_STATUS','=','1')
            ->where('INFMATION_ID','=',$id)
            ->where('LOCATION_LEVEL_ID','=',$indinfo->LOCATION_LEVEL_ID)
            ->where('LEVEL_ROOM_ID','=',$indinfo->LEVEL_ROOM_ID)
            ->get();

            $infoguesthousoutsider  = DB::table('guesthous_infomation_outsider')
            ->leftJoin('hrd_person','hrd_person.ID','=','guesthous_infomation_outsider.INFMATION_OUTSIDER_RELATIONADD')
            ->where('INFMATION_ID','=',$id)
            ->where('LOCATION_LEVEL_ID','=',$indinfo->LOCATION_LEVEL_ID)
            ->where('LEVEL_ROOM_ID','=',$indinfo->LEVEL_ROOM_ID)
            ->get();

            $infoguesthousasset  = DB::table('guesthous_infomation_asset')->where('INFMATION_ID','=',$id)
            ->where('LOCATION_LEVEL_ID','=',$indinfo->LOCATION_LEVEL_ID)
            ->where('LEVEL_ROOM_ID','=',$indinfo->LEVEL_ROOM_ID)
            ->get();
            $infoguesthousrepair  = DB::table('guesthous_infomation_repair')->where('INFMATION_ID','=',$id)
            ->where('LOCATION_LEVEL_ID','=',$indinfo->LOCATION_LEVEL_ID)
            ->where('LEVEL_ROOM_ID','=',$indinfo->LEVEL_ROOM_ID)
            ->get();

        }else{

         
            $detailstaycheck =  DB::table('guesthous_infomation')
            ->leftjoin('guesthous_infomation_person','guesthous_infomation.INFMATION_ID','=','guesthous_infomation_person.INFMATION_ID')
            ->leftJoin('supplies_location','supplies_location.LOCATION_ID','=','guesthous_infomation.LOCATION_ID')
            ->leftJoin('supplies_location_level','supplies_location_level.LOCATION_LEVEL_ID','=','guesthous_infomation_person.LOCATION_LEVEL_ID')
            ->leftJoin('supplies_location_level_room','supplies_location_level_room.LEVEL_ROOM_ID','=','guesthous_infomation_person.LEVEL_ROOM_ID')
            ->where('guesthous_infomation.INFMATION_ID','=', $id)
            ->where('guesthous_infomation_person.INFMATION_PERSON_STATUS','=','1')
            ->first();

            if( $detailstaycheck == null){
                $detailstay =  DB::table('guesthous_infomation')
                ->leftjoin('guesthous_infomation_person','guesthous_infomation.INFMATION_ID','=','guesthous_infomation_person.INFMATION_ID')
                ->leftJoin('supplies_location','supplies_location.LOCATION_ID','=','guesthous_infomation.LOCATION_ID')
                ->leftJoin('supplies_location_level','supplies_location_level.LOCATION_LEVEL_ID','=','guesthous_infomation_person.LOCATION_LEVEL_ID')
                ->leftJoin('supplies_location_level_room','supplies_location_level_room.LEVEL_ROOM_ID','=','guesthous_infomation_person.LEVEL_ROOM_ID')
                ->where('guesthous_infomation_person.INFMATION_PERSON_STATUS','=','1')
                ->first();

            }else{

                $detailstay = $detailstaycheck;
            }

         
            $infoguesthousperson  = DB::table('guesthous_infomation_person')
            ->leftJoin('hrd_person','hrd_person.ID','=','guesthous_infomation_person.INFMATION_PERSON_HRID')
            ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
            ->where('INFMATION_PERSON_STATUS','=','1')
            ->where('INFMATION_ID','=',$id)->get();

            $infoguesthousoutsider  = DB::table('guesthous_infomation_outsider')
            ->leftJoin('hrd_person','hrd_person.ID','=','guesthous_infomation_outsider.INFMATION_OUTSIDER_RELATIONADD')
            ->where('INFMATION_ID','=',$id)->get();

            $infoguesthousasset  = DB::table('guesthous_infomation_asset')->where('INFMATION_ID','=',$id)->get();
            $infoguesthousrepair  = DB::table('guesthous_infomation_repair')->where('INFMATION_ID','=',$id)->get();


        }

                     




       }else{
        $detailstay = '';
        $infoguesthouse = '';
      
        $infoguesthousperson = '';
        $infoguesthousoutsider = '';
        $infoguesthousasset = '';
        $infoguesthousrepair = '';

       }
    
       $infoinfomation = Guesthousinfomation::orderBy('INFMATION_TYPE', 'asc')->get();

        return view('person_guesthouse.guesthouse_info',[
            'inforpersonuser' => $inforperson,
            'inforpersonid' => $inforpersonid,
            'ckeckleave'=>  $ckeckleave,
            'infoinfomations'=>  $infoinfomation,
            'detailstay'=>  $detailstay,
            'infoguesthouse' => $infoguesthouse,
            'infoguesthouspersons' => $infoguesthousperson,
            'infoguesthousoutsiders' => $infoguesthousoutsider,
            'infoguesthousassets' => $infoguesthousasset,
            'infoguesthousrepairs' => $infoguesthousrepair,
    
            
        ]);
    }

    public function guesthouse_infohome(Request $request,$id,$iduser)
    {
        $email = Auth::user()->email;
        $inforpersonid =  $iduser;
            
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

    
       $infoguesthouse = DB::table('guesthous_infomation')
       ->leftJoin('supplies_location','supplies_location.LOCATION_ID','=','guesthous_infomation.LOCATION_ID')
       ->leftJoin('hrd_person','hrd_person.ID','=','guesthous_infomation.INFMATION_HR_ID')
       ->where('INFMATION_ID','=',$id)->first();

        return view('person_guesthouse.guesthouse_infohome',[
            'inforpersonuser' => $inforperson,
            'inforpersonid' => $inforpersonid,
            'infoguesthouse' => $infoguesthouse 
            
        ]);
    }



    public function guesthouse_infohotel(Request $request,$id,$iduser)
    {
        $email = Auth::user()->email;
        $inforpersonid =  $iduser;
            
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

     
        $infoguesthouse = DB::table('guesthous_infomation')
        ->leftJoin('supplies_location','supplies_location.LOCATION_ID','=','guesthous_infomation.LOCATION_ID')
        ->leftJoin('hrd_person','hrd_person.ID','=','guesthous_infomation.INFMATION_HR_ID')
        ->where('INFMATION_ID','=',$id)->first();


        $infoguesthouse_level = DB::table('supplies_location_level')->where('LOCATION_ID','=',$infoguesthouse->LOCATION_ID)->get();


        return view('person_guesthouse.guesthouse_infohotel',[
            'inforpersonuser' => $inforperson,
            'inforpersonid' => $inforpersonid,
            'infoguesthouse' => $infoguesthouse,
            'infoguesthouse_levels' => $infoguesthouse_level,
            
        ]);
    }



    public function guesthouse_petition(Request $request,$iduser)
    {
        $email = Auth::user()->email;
        $inforpersonid =  $iduser;
            
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
    
       $infopetition = DB::table('guesthous_petition')
       ->select('guesthous_petition.created_at','PETITION_STATUS','PETITION_TYPE','HR_FNAME','HR_LNAME','PETITION_HR_TEL','LOCATION_NAME','LOCATION_LEVEL_NAME','LEVEL_ROOM_NAME','PETITION_ID','INFMATION_HR_NAME','INFMATION_NAME')
       ->leftJoin('supplies_location','supplies_location.LOCATION_ID','=','guesthous_petition.LOCATION_ID')
       ->leftJoin('supplies_location_level','supplies_location_level.LOCATION_LEVEL_ID','=','guesthous_petition.LOCATION_LEVEL_ID')
       ->leftJoin('supplies_location_level_room','supplies_location_level_room.LEVEL_ROOM_ID','=','guesthous_petition.LEVEL_ROOM_ID')
       ->leftJoin('hrd_person','guesthous_petition.PETITION_HR_ID','=','hrd_person.ID')
       ->leftJoin('guesthous_infomation','guesthous_petition.LOCATION_ID','=','guesthous_infomation.LOCATION_ID')
       ->where('PETITION_HR_ID','=',$iduser)
       ->orderBy('guesthous_petition.created_at', 'DESC')
       ->get();
    
       
     
       $ckeckleave = DB::table('guesthous_infomation_person')->where('INFMATION_PERSON_HRID','=',$iduser)->where('INFMATION_PERSON_STATUS','=','1')->count();

       
   
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


 
        return view('person_guesthouse.guesthouse_petition',[
            'inforpersonuser' => $inforperson,
            'inforpersonid' => $inforpersonid,
            'infopetitions' => $infopetition,
            'ckeckleave' => $ckeckleave,
            'infostatuss' => $infostatus,
            'displaydate_bigen'=> $displaydate_bigen, 
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'budgets' =>  $budget,
            'year_id'=>$year_id
            
        ]);
    }


    public function guesthouse_petitionsearch(Request $request,$iduser)
    {
        $email = Auth::user()->email;
        $inforpersonid =  $iduser;
            
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
    
       
     
       $ckeckleave = DB::table('guesthous_infomation_person')->where('INFMATION_PERSON_HRID','=',$iduser)->where('INFMATION_PERSON_STATUS','=','1')->count();

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

          $from = date($displaydate_bigen);
          $to = date($displaydate_end);   
       
       
       
       
       if($status == null){

   
           $infopetition = DB::table('guesthous_petition')
           ->select('guesthous_petition.created_at','PETITION_STATUS','PETITION_TYPE','HR_FNAME','HR_LNAME','PETITION_HR_TEL','LOCATION_NAME','LOCATION_LEVEL_NAME','LEVEL_ROOM_NAME','PETITION_ID','INFMATION_HR_NAME','INFMATION_NAME')
           ->leftJoin('supplies_location','supplies_location.LOCATION_ID','=','guesthous_petition.LOCATION_ID')
           ->leftJoin('supplies_location_level','supplies_location_level.LOCATION_LEVEL_ID','=','guesthous_petition.LOCATION_LEVEL_ID')
           ->leftJoin('supplies_location_level_room','supplies_location_level_room.LEVEL_ROOM_ID','=','guesthous_petition.LEVEL_ROOM_ID')
           ->leftJoin('hrd_person','guesthous_petition.PETITION_HR_ID','=','hrd_person.ID')
           ->leftJoin('guesthous_infomation','guesthous_petition.LOCATION_ID','=','guesthous_infomation.LOCATION_ID')
           ->where(function($q) use ($search){
               $q->where('HR_FNAME','like','%'.$search.'%');
               $q->orwhere('HR_LNAME','like','%'.$search.'%');
               $q->orwhere('PETITION_HR_TEL','like','%'.$search.'%');
               $q->orwhere('LOCATION_NAME','like','%'.$search.'%');
               $q->orwhere('LOCATION_LEVEL_NAME','like','%'.$search.'%');
               $q->orwhere('LEVEL_ROOM_NAME','like','%'.$search.'%');
               })
               ->WhereBetween('guesthous_petition.created_at',[$from.' 00:00:00',$to.' 23:59:00']) 
           ->orderBy('guesthous_petition.created_at', 'DESC')
           ->get();



       }else{


           $infopetition = DB::table('guesthous_petition')
           ->select('guesthous_petition.created_at','PETITION_STATUS','PETITION_TYPE','HR_FNAME','HR_LNAME','PETITION_HR_TEL','LOCATION_NAME','LOCATION_LEVEL_NAME','LEVEL_ROOM_NAME','PETITION_ID','INFMATION_HR_NAME','INFMATION_NAME')
           ->leftJoin('supplies_location','supplies_location.LOCATION_ID','=','guesthous_petition.LOCATION_ID')
           ->leftJoin('supplies_location_level','supplies_location_level.LOCATION_LEVEL_ID','=','guesthous_petition.LOCATION_LEVEL_ID')
           ->leftJoin('supplies_location_level_room','supplies_location_level_room.LEVEL_ROOM_ID','=','guesthous_petition.LEVEL_ROOM_ID')
           ->leftJoin('hrd_person','guesthous_petition.PETITION_HR_ID','=','hrd_person.ID')
           ->leftJoin('guesthous_infomation','guesthous_petition.LOCATION_ID','=','guesthous_infomation.LOCATION_ID')
           ->where('PETITION_STATUS','=',$status)
           ->where(function($q) use ($search){
               $q->where('HR_FNAME','like','%'.$search.'%');
               $q->orwhere('HR_LNAME','like','%'.$search.'%');
               $q->orwhere('PETITION_HR_TEL','like','%'.$search.'%');
               $q->orwhere('LOCATION_NAME','like','%'.$search.'%');
               $q->orwhere('LOCATION_LEVEL_NAME','like','%'.$search.'%');
               $q->orwhere('LEVEL_ROOM_NAME','like','%'.$search.'%');
               })
               ->WhereBetween('guesthous_petition.created_at',[$from.' 00:00:00',$to.' 23:59:00']) 
           ->orderBy('guesthous_petition.created_at', 'DESC')
           ->get();

       

       }
       
       
    


       $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
       $year_id = $yearbudget;

       $infostatus = DB::table('guesthous_petition_status')->get();


        return view('person_guesthouse.guesthouse_petition',[
            'inforpersonuser' => $inforperson,
            'inforpersonid' => $inforpersonid,
            'infopetitions' => $infopetition,
            'ckeckleave' => $ckeckleave,
            'infostatuss' => $infostatus,
            'displaydate_bigen'=> $displaydate_bigen, 
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'budgets' =>  $budget,
            'year_id'=>$year_id
            
        ]);
    }





    public function guesthouse_petition_add(Request $request,$iduser)
    {
        $email = Auth::user()->email;
        $inforpersonid =  $iduser;
            
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


        $infolocation = DB::table('supplies_location')->get();
        $infolocationlevel = DB::table('supplies_location_level')->get();
        $infolocationlevelroom= DB::table('supplies_location_level_room')->get();

    
        return view('person_guesthouse.guesthouse_petition_add',[
            'inforpersonuser' => $inforperson,
            'inforpersonid' => $inforpersonid,
            'infolocations' => $infolocation,
            'infolocationlevels' => $infolocationlevel,
            'infolocationlevelrooms' => $infolocationlevelroom,

        ]);
    }




    public function guesthouse_petition_save(Request $request)
    {

        $iduser = $request->USER_ID;
     
        $addpetition = new Guesthouspetition(); 
        $addpetition->PETITION_HR_ID = $iduser;
        $addpetition->PETITION_HR_TEL = $request->PETITION_HR_TEL;
        $addpetition->PETITION_TYPE = $request->PETITION_TYPE;
        $addpetition->PETITION_ADD = $request->PETITION_ADD;  
        $addpetition->PETITION_REMARK = $request->PETITION_REMARK;
        $addpetition->PETITION_STATUS = 'REQUEST';    
        $addpetition->save();

        return redirect()->route('guest.guesthouse_petition',[
            'iduser' => $iduser
            ]);    
    }


    public function guesthouse_petition_edit(Request $request,$idref,$iduser)
    {
        $email = Auth::user()->email;
        $inforpersonid =  $iduser;

     
            
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


        $infolocation = DB::table('supplies_location')->get();
        $infolocationlevel = DB::table('supplies_location_level')->get();
        $infolocationlevelroom= DB::table('supplies_location_level_room')->get();

        $infopetition = DB::table('guesthous_petition')->where('PETITION_ID','=',$idref)->first();
    
        return view('person_guesthouse.guesthouse_petition_edit',[
            'inforpersonuser' => $inforperson,
            'inforpersonid' => $inforpersonid,
            'infolocations' => $infolocation,
            'infolocationlevels' => $infolocationlevel,
            'infolocationlevelrooms' => $infolocationlevelroom,
            'infopetition' => $infopetition,


        ]);
    }




    public function guesthouse_petition_update(Request $request)
    {

        $iduser = $request->USER_ID;
        $id = $request->PETITION_ID;
        $addpetition = Guesthouspetition::find($id);
        $addpetition->PETITION_HR_ID = $iduser;
        $addpetition->PETITION_HR_TEL = $request->PETITION_HR_TEL;
        $addpetition->PETITION_TYPE = $request->PETITION_TYPE;
        $addpetition->PETITION_ADD = $request->PETITION_ADD;  
        $addpetition->PETITION_REMARK = $request->PETITION_REMARK;  
        $addpetition->save();

        return redirect()->route('guest.guesthouse_petition',[
            'iduser' => $iduser
            ]);    
    }





    //=========================================================



    public function guesthouse_dashboard(Request $request,$iduser)
    {
        $email = Auth::user()->email;
        $inforpersonid =  $iduser;
            
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
    

        return view('person_guesthouse.guesthouse_dashboard',[
            'inforpersonuser' => $inforperson,
            'inforpersonid' => $inforpersonid
            
        ]);
    }


    public function guesthouse_problem(Request $request,$iduser)
    {
        $email = Auth::user()->email;
        $inforpersonid =  $iduser;
            
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

      
       $infoproblem = DB::table('guesthous_problem')
       ->select('PROBLEM_ID','guesthous_problem.created_at','PROBLEM_TYPE','HR_FNAME','HR_LNAME','PROBLEM_HR_TEL','LOCATION_NAME','LOCATION_LEVEL_NAME','LEVEL_ROOM_NAME','PROBLEM_NAME','PROBLEM_STATUS','INFMATION_HR_NAME','INFMATION_NAME','PROBLEM_IMG')
       ->leftJoin('supplies_location','supplies_location.LOCATION_ID','=','guesthous_problem.LOCATION_ID')
       ->leftJoin('supplies_location_level','supplies_location_level.LOCATION_LEVEL_ID','=','guesthous_problem.LOCATION_LEVEL_ID')
       ->leftJoin('supplies_location_level_room','supplies_location_level_room.LEVEL_ROOM_ID','=','guesthous_problem.LEVEL_ROOM_ID')
       ->leftJoin('hrd_person','guesthous_problem.PROBLEM_HR_ID','=','hrd_person.ID')
       ->leftJoin('guesthous_infomation','guesthous_problem.LOCATION_ID','=','guesthous_infomation.LOCATION_ID')
       ->where('PROBLEM_HR_ID','=',$iduser)
       ->orderBy('guesthous_problem.created_at', 'DESC')
       ->get();

  
       $ckeckleave = DB::table('guesthous_infomation_person')->where('INFMATION_PERSON_HRID','=',$iduser)->where('INFMATION_PERSON_STATUS','=','1')->count();



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

       $infostatus = DB::table('guesthous_problem_status')->get();


        return view('person_guesthouse.guesthouse_problem',[
            'inforpersonuser' => $inforperson,
            'inforpersonid' => $inforpersonid,
            'infoproblems' => $infoproblem,
            'ckeckleave' => $ckeckleave,
            'infostatuss' => $infostatus,
            'displaydate_bigen'=> $displaydate_bigen, 
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'budgets' =>  $budget,
            'year_id'=>$year_id
            
        ]);
    }





    
    public function guesthouse_problemsearch(Request $request,$iduser)
    {
        $email = Auth::user()->email;
        $inforpersonid =  $iduser;
            
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



       $ckeckleave = DB::table('guesthous_infomation_person')->where('INFMATION_PERSON_HRID','=',$iduser)->where('INFMATION_PERSON_STATUS','=','1')->count();

      
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

          $from = date($displaydate_bigen);
          $to = date($displaydate_end);   
       
       
       
       
       if($status == null){

           $infoproblem = DB::table('guesthous_problem')
           ->select('PROBLEM_ID','guesthous_problem.created_at','PROBLEM_TYPE','HR_FNAME','HR_LNAME','PROBLEM_HR_TEL','LOCATION_NAME','LOCATION_LEVEL_NAME','LEVEL_ROOM_NAME','PROBLEM_NAME','PROBLEM_STATUS','INFMATION_HR_NAME','INFMATION_NAME','PROBLEM_IMG')
           ->leftJoin('supplies_location','supplies_location.LOCATION_ID','=','guesthous_problem.LOCATION_ID')
           ->leftJoin('supplies_location_level','supplies_location_level.LOCATION_LEVEL_ID','=','guesthous_problem.LOCATION_LEVEL_ID')
           ->leftJoin('supplies_location_level_room','supplies_location_level_room.LEVEL_ROOM_ID','=','guesthous_problem.LEVEL_ROOM_ID')
           ->leftJoin('hrd_person','guesthous_problem.PROBLEM_HR_ID','=','hrd_person.ID')
           ->leftJoin('guesthous_infomation','guesthous_problem.LOCATION_ID','=','guesthous_infomation.LOCATION_ID')
           ->where(function($q) use ($search){
               $q->where('HR_FNAME','like','%'.$search.'%');
               $q->orwhere('HR_LNAME','like','%'.$search.'%');
               $q->orwhere('PROBLEM_HR_TEL','like','%'.$search.'%');
               $q->orwhere('LOCATION_NAME','like','%'.$search.'%');
               $q->orwhere('LOCATION_LEVEL_NAME','like','%'.$search.'%');
               $q->orwhere('LEVEL_ROOM_NAME','like','%'.$search.'%');
               $q->orwhere('PROBLEM_NAME','like','%'.$search.'%');
               })
               ->WhereBetween('guesthous_problem.created_at',[$from.' 00:00:00',$to.' 23:59:00']) 
           ->orderBy('guesthous_problem.created_at', 'DESC')
           ->get();


       }else{


           $infoproblem = DB::table('guesthous_problem')
           ->select('PROBLEM_ID','guesthous_problem.created_at','PROBLEM_TYPE','HR_FNAME','HR_LNAME','PROBLEM_HR_TEL','LOCATION_NAME','LOCATION_LEVEL_NAME','LEVEL_ROOM_NAME','PROBLEM_NAME','PROBLEM_STATUS','INFMATION_HR_NAME','INFMATION_NAME','PROBLEM_IMG')
           ->leftJoin('supplies_location','supplies_location.LOCATION_ID','=','guesthous_problem.LOCATION_ID')
           ->leftJoin('supplies_location_level','supplies_location_level.LOCATION_LEVEL_ID','=','guesthous_problem.LOCATION_LEVEL_ID')
           ->leftJoin('supplies_location_level_room','supplies_location_level_room.LEVEL_ROOM_ID','=','guesthous_problem.LEVEL_ROOM_ID')
           ->leftJoin('hrd_person','guesthous_problem.PROBLEM_HR_ID','=','hrd_person.ID')
           ->leftJoin('guesthous_infomation','guesthous_problem.LOCATION_ID','=','guesthous_infomation.LOCATION_ID')
           ->where('PROBLEM_STATUS','=',$status)
           ->where(function($q) use ($search){
               $q->where('HR_FNAME','like','%'.$search.'%');
               $q->orwhere('HR_LNAME','like','%'.$search.'%');
               $q->orwhere('PROBLEM_HR_TEL','like','%'.$search.'%');
               $q->orwhere('LOCATION_NAME','like','%'.$search.'%');
               $q->orwhere('LOCATION_LEVEL_NAME','like','%'.$search.'%');
               $q->orwhere('LEVEL_ROOM_NAME','like','%'.$search.'%');
               $q->orwhere('PROBLEM_NAME','like','%'.$search.'%');
               })
               ->WhereBetween('guesthous_problem.created_at',[$from.' 00:00:00',$to.' 23:59:00']) 
           ->orderBy('guesthous_problem.created_at', 'DESC')
           ->get();



       }
       
       
    
       $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
       $year_id = $yearbudget;

       $infostatus = DB::table('guesthous_problem_status')->get();


        return view('person_guesthouse.guesthouse_problem',[
            'inforpersonuser' => $inforperson,
            'inforpersonid' => $inforpersonid,
            'infoproblems' => $infoproblem,
            'ckeckleave' => $ckeckleave,
            'infostatuss' => $infostatus,
            'displaydate_bigen'=> $displaydate_bigen, 
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'budgets' =>  $budget,
            'year_id'=>$year_id
            
        ]);
    }



    public function guesthouse_problem_add(Request $request,$iduser)
    {
        $email = Auth::user()->email;
        $inforpersonid =  $iduser;
            
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

        $infolocation = DB::table('guesthous_infomation')->get();
        $infolocationlevel = DB::table('supplies_location_level')->get();
        $infolocationlevelroom= DB::table('supplies_location_level_room')->get();
        $infotype = DB::table('guesthous_problem_type')->get();

        $infopetition = DB::table('guesthous_petition')
        ->select('guesthous_petition.created_at','PETITION_STATUS','PETITION_TYPE','HR_FNAME','HR_LNAME','PETITION_HR_TEL','LOCATION_NAME','LOCATION_LEVEL_NAME','LEVEL_ROOM_NAME','PETITION_ID','INFMATION_HR_NAME','INFMATION_NAME')
        ->leftJoin('supplies_location','supplies_location.LOCATION_ID','=','guesthous_petition.LOCATION_ID')
        ->leftJoin('supplies_location_level','supplies_location_level.LOCATION_LEVEL_ID','=','guesthous_petition.LOCATION_LEVEL_ID')
        ->leftJoin('supplies_location_level_room','supplies_location_level_room.LEVEL_ROOM_ID','=','guesthous_petition.LEVEL_ROOM_ID')
        ->leftJoin('hrd_person','guesthous_petition.PETITION_HR_ID','=','hrd_person.ID')
        ->leftJoin('guesthous_infomation','guesthous_petition.LOCATION_ID','=','guesthous_infomation.LOCATION_ID')
        ->orderBy('guesthous_petition.created_at', 'DESC')
        ->where('guesthous_petition.PETITION_HR_ID','=',$iduser)->first();

        if($infopetition == null){
            $LOCATION_NAME = '';
            $LOCATION_LEVEL_NAME = '';
            $LEVEL_ROOM_NAME = '';
            $PETITION_HR_TEL = '';
        }else{
           $LOCATION_NAME = $infopetition->LOCATION_NAME;
           $LOCATION_LEVEL_NAME =$infopetition->LOCATION_LEVEL_NAME;
           $LEVEL_ROOM_NAME =$infopetition->LEVEL_ROOM_NAME; 
           $PETITION_HR_TEL =$infopetition->PETITION_HR_TEL;

         }

        
    
        return view('person_guesthouse.guesthouse_problem_add',[
            'inforpersonuser' => $inforperson,
            'inforpersonid' => $inforpersonid,
            'infolocations' => $infolocation,
            'infolocationlevels' => $infolocationlevel,
            'infolocationlevelrooms' => $infolocationlevelroom,
            'infotypes'=>$infotype,
            'infopetitions'=>$infopetition,
            'LOCATION_NAME'=>$LOCATION_NAME,
            'LOCATION_LEVEL_NAME'=>$LOCATION_LEVEL_NAME,
            'LEVEL_ROOM_NAME'=>$LEVEL_ROOM_NAME,
            'PETITION_HR_TEL'=>$PETITION_HR_TEL,
        ]);
    }



    public function guesthouse_problem_save(Request $request)
    {

        $iduser = $request->USER_ID;
        $id_location = $request->LOCATION_ID;

        $addproblem = new Guesthousproblem(); 
        $addproblem->PROBLEM_NAME = $request->PROBLEM_NAME;
        $addproblem->LOCATION_ID = $id_location;
        $addproblem->LOCATION_LEVEL_ID = $request->LOCATION_LEVEL_ID;
        $addproblem->LEVEL_ROOM_ID = $request->LEVEL_ROOM_ID;

       
        $id_u = DB::table('hrd_person')->where('ID','=',$iduser)->first();

        $addproblem->PROBLEM_HR_ID =  $id_u->ID;
        $addproblem->PROBLEM_HR_NAME =  $id_u->HR_FNAME.''.$id_u->HR_LNAME;

        $addproblem->PROBLEM_HR_TEL = $request->PROBLEM_HR_TEL;
        $addproblem->PROBLEM_TYPE = $request->PROBLEM_TYPE;
        $addproblem->PROBLEM_PICE = $request->PROBLEM_PICE;
        $addproblem->PROBLEM_STATUS = 'REQUEST';  
        
        if($request->hasFile('picture')){            
            $file = $request->file('picture');  
            $contents = $file->openFile()->fread($file->getSize());
            $addproblem->PROBLEM_IMG = $contents;             
        }
        $addproblem->save();



        function DateThailinecar($strDate)
        {
          $strYear = date("Y",strtotime($strDate))+543;
          $strMonth= date("n",strtotime($strDate));
          $strDay= date("j",strtotime($strDate));
  
          $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
          $strMonthThai=$strMonthCut[$strMonth];
          return "$strDay $strMonthThai $strYear";
          }

        $header = "แจ้งปัญหาบ้านพัก";
       
        $idmax = DB::table('guesthous_problem')->MAX('PROBLEM_ID');

        $infoproblem = DB::table('guesthous_problem')
        ->select('PROBLEM_ID','guesthous_problem.created_at','PROBLEM_TYPE','HR_FNAME','HR_LNAME','PROBLEM_HR_TEL','LOCATION_NAME','LOCATION_LEVEL_NAME','LEVEL_ROOM_NAME','PROBLEM_NAME','PROBLEM_STATUS','INFMATION_HR_NAME','INFMATION_NAME','PROBLEM_IMG','PROBLEM_TYPE_NAME')
        ->leftJoin('supplies_location','supplies_location.LOCATION_ID','=','guesthous_problem.LOCATION_ID')
        ->leftJoin('supplies_location_level','supplies_location_level.LOCATION_LEVEL_ID','=','guesthous_problem.LOCATION_LEVEL_ID')
        ->leftJoin('supplies_location_level_room','supplies_location_level_room.LEVEL_ROOM_ID','=','guesthous_problem.LEVEL_ROOM_ID')
        ->leftJoin('hrd_person','guesthous_problem.PROBLEM_HR_ID','=','hrd_person.ID')
        ->leftJoin('guesthous_infomation','guesthous_problem.LOCATION_ID','=','guesthous_infomation.LOCATION_ID')
        ->leftJoin('guesthous_problem_type','guesthous_problem.PROBLEM_TYPE','=','guesthous_problem_type.PROBLEM_TYPE_ID')
        ->where('PROBLEM_ID','=',$idmax)
        ->first();

       $message = $header.
           "\n"."วันที่ : " . DateThailinecar(date('Y-m-d')) .          
           "\n"."ปัญหาที่พบ : " . $request->PROBLEM_NAME .
           "\n"."อาคาร : " . $infoproblem->LOCATION_NAME .
           "\n"."ชั้น : " . $infoproblem->LOCATION_LEVEL_NAME .
           "\n"."ห้อง : " . $infoproblem->LEVEL_ROOM_NAME .
           "\n"."ปัญหาประเภท : " . $infoproblem->PROBLEM_TYPE_NAME .
           "\n"."ผู้แจ้ง : " . $id_u->HR_FNAME.''.$id_u->HR_LNAME .               
           "\n"."โทร : " . $request->PROBLEM_HR_TEL;
      

           ///=====แจ้งกลุ่มผู้ตรวจสอบ

           $name2 = DB::table('line_token')->where('ID_LINE_TOKEN','=','9')->first();        
           $test2 =$name2->LINE_TOKEN;
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

   


        return redirect()->route('guest.guesthouse_problem',[
            'iduser' => $iduser
            ]);    
    }


    public function guesthouse_problem_edit(Request $request,$idref,$iduser)
    {
        $email = Auth::user()->email;
        $inforpersonid =  $iduser;
            
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

        $infoproblem = DB::table('guesthous_problem')->where('PROBLEM_ID','=',$idref)->first();

        $infolocation = DB::table('guesthous_infomation')->get();
        $infolocationlevel = DB::table('supplies_location_level')->get();
        $infolocationlevelroom= DB::table('supplies_location_level_room')->get();
        $infotype = DB::table('guesthous_problem_type')->get();
 
        return view('person_guesthouse.guesthouse_problem_edit',[
            'inforpersonuser' => $inforperson,
            'inforpersonid' => $inforpersonid,
            'infolocations' => $infolocation,
            'infolocationlevels' => $infolocationlevel,
            'infolocationlevelrooms' => $infolocationlevelroom,
            'infoproblem' => $infoproblem,
            'infotypes' => $infotype,
        ]);

    }

    public function guesthouse_problem_update(Request $request)
    {

        $iduser = $request->USER_ID;
        $id = $request->ID_REF;

        $addproblem = Guesthousproblem::find($id);
        $addproblem->PROBLEM_NAME = $request->PROBLEM_NAME;
        $addproblem->LOCATION_ID = $request->LOCATION_ID;
        $addproblem->LOCATION_LEVEL_ID = $request->LOCATION_LEVEL_ID;
        $addproblem->LEVEL_ROOM_ID = $request->LEVEL_ROOM_ID;
        $addproblem->PROBLEM_HR_ID = $iduser;
        $addproblem->PROBLEM_HR_TEL = $request->PROBLEM_HR_TEL;
        $addproblem->PROBLEM_TYPE = $request->PROBLEM_TYPE;
        $addproblem->PROBLEM_PICE = $request->PROBLEM_PICE;  
        if($request->hasFile('picture')){            
            $file = $request->file('picture');  
            $contents = $file->openFile()->fread($file->getSize());
            $addproblem->PROBLEM_IMG = $contents;             
        }

        $addproblem->save();



        return redirect()->route('guest.guesthouse_problem',[
            'iduser' => $iduser
            ]);    
    }

    public function guesthouse_problem_cancel(Request $request,$idref,$iduser)
    {
        $email = Auth::user()->email;
        $inforpersonid =  $iduser;
            
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

        $infoproblem = DB::table('guesthous_problem')->where('PROBLEM_ID','=',$idref)->first();

        $infolocation = DB::table('guesthous_infomation')->get();
        $infolocationlevel = DB::table('supplies_location_level')->get();
        $infolocationlevelroom= DB::table('supplies_location_level_room')->get();
        $infotype = DB::table('guesthous_problem_type')->get();
 
        return view('person_guesthouse.guesthouse_problem_cancel',[
            'inforpersonuser' => $inforperson,
            'inforpersonid' => $inforpersonid,
            'infolocations' => $infolocation,
            'infolocationlevels' => $infolocationlevel,
            'infolocationlevelrooms' => $infolocationlevelroom,
            'infoproblem' => $infoproblem,
            'infotypes' => $infotype,
        ]);

    }

    public function guesthouse_problem_updatecancel(Request $request)
    {

        $iduser = $request->USER_ID;
        $id = $request->ID_REF;

        $addproblem = Guesthousproblem::find($id);
        $addproblem->PROBLEM_STATUS = $request->PROBLEM_STATUS;
      
        $addproblem->save();



        return redirect()->route('guest.guesthouse_problem',[
            'iduser' => $iduser
            ]);    
    }

}
