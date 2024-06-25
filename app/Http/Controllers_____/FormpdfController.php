<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
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
use App\Models\Assetcarerepair;
use App\Models\Risk_rep_time;
use App\Models\Risk_rep_location;
use App\Models\Risk_rep_group;
use App\Models\Risk_rep_groupsub;
use App\Models\Risk_rep_groupsubsub;
use App\Models\Risk_rep_detail;
use App\Models\Risk_rep_items;
use App\Models\Env_parameter_sub;
use App\Models\Informrepair_openform;
use App\Models\Warehouserequest;
use App\Models\Warehouse_function;
use App\Models\Infomrepair_functionnormal;
use App\Models\Infomrepair_functionmedical;
use App\Models\Infomrepair_functioncom;
use App\Models\Informcomrepair;
use PDF;
use Alert;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\Permislist;
use App\Models\Permis;
use App\Models\Persondev_function;

class FormpdfController extends Controller
{
 
public static function checkpur($id_user)
{
    $count =  Permislist::where('PERSON_ID','=',$id_user)
    ->where('PERMIS_ID','=','GSU004')
    ->count();    

 return $count;
}  
public static function checkpurmanage($id_user)
{
    $count =  Permislist::where('PERSON_ID','=',$id_user)
    ->where('PERMIS_ID','=','GSU001')
    ->count();    

 return $count;
}


//---------------------------ฟังชัน------------------------------
function pdfcongrat_10999(Request $request,$id)
{       
        $infocongrat = DB::table('donation_person_sub')
        ->leftjoin('donation_person','donation_person.DONATE_PERSON_ID','=','donation_person_sub.DONATE_PERSON_ID')
        ->leftjoin('donation_unit','donation_person_sub.PERSON_DONATE_SUB_UNIT_ID','=','donation_unit.DONATIONUNIT_ID')
        ->where('PERSON_DONATE_SUB_ID','=',$id)->first();
        
        $checksig = DB::table('gleave_function')->where('FUNCTION_ID','=',1)->where('ACTIVE','=','True')->count();

        $infoorg = DB::table('info_org')->where('ORG_ID','=','1')
        ->leftjoin('hrd_person','hrd_person.ID','=','info_org.ORG_LEADER_ID')
        ->first();

        $orgname =  DB::table('info_org')
            ->leftJoin('hrd_person','info_org.ORG_LEADER_ID','=','hrd_person.ID')
            ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
            ->first();

        $sigin = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$orgname->ORG_LEADER_ID)->first();

        if($sigin !== null){
            $sig =  $sigin->FILE_NAME;
        }else{ $sig = '';}

        $pdf = PDF::loadView('formpdf.pdfcongrat_10999',[
            'infocongrat' => $infocongrat,
            'infoorg' => $infoorg,
            'sig' => $sig,
            'checksig' => $checksig,
            'orgname' => $orgname,
        ]);
    
        $pdf->setPaper('a4','landscape');
    
        return @$pdf->stream();   
}

    //====================== ฝั่ง ผู้ดูแลงาน =============================//

function pdf3_10999(Request $request,$id)
{
                $orgname =  DB::table('info_org')
                ->leftJoin('hrd_person','info_org.ORG_LEADER_ID','=','hrd_person.ID')
                ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                ->first();

                
                $inforcar = DB::table('vehicle_car_reserve')
                ->leftJoin('vehicle_car_index','vehicle_car_reserve.CAR_SET_ID','=','vehicle_car_index.CAR_ID')
                ->leftJoin('grecord_org_location','vehicle_car_reserve.RESERVE_LOCATION_ID','=','grecord_org_location.LOCATION_ID')
                ->where('RESERVE_ID','=',$id)->first();
                
                
                $iduser = $inforcar->RESERVE_PERSON_ID;
                $inforperson=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
                ->where('hrd_person.ID','=',$iduser)->first();

                $idcon = $inforcar->LEADER_PERSON_ID;
                $infocon =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
                ->where('hrd_person.ID','=',$idcon)->first();

                $indexperson = DB::table('vehicle_car_index_person')
                ->leftJoin('hrd_person','hrd_person.ID','=','vehicle_car_index_person.HR_PERSON_ID')
                ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
                ->where('RESERVE_ID','=',$id)->get();

                $indexpersoncount = DB::table('vehicle_car_index_person')->where('RESERVE_ID','=',$id)->count();

                $checksig = DB::table('gleave_function')->where('FUNCTION_ID','=',1)->where('ACTIVE','=','True')->count();
                $orgname =  DB::table('info_org')
                ->leftJoin('hrd_person','info_org.ORG_LEADER_ID','=','hrd_person.ID')
                ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                ->first();

                $debsub =  DB::table('hrd_department_sub')
                ->leftJoin('hrd_person','hrd_department_sub.LEADER_HR_ID','=','hrd_person.ID')
                ->first();

                $siginper = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforcar->RESERVE_PERSON_ID)->first();

                $siginsub = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforcar->LEADER_PERSON_ID)->first();

                $sigin = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$orgname->ORG_LEADER_ID)->first();

                $sigincardriver = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforcar->CAR_DRIVER_SET_ID)->first();


                if($siginper !== null){
                    $sigper =  $siginper->FILE_NAME;
                }else{ $sigper = '';}

                if($siginsub !== null){
                    $sigsub =  $siginsub->FILE_NAME;
                }else{ $sigsub = '';}

                if($sigin !== null){
                    $sig =  $sigin->FILE_NAME;
                }else{ $sig = '';}

                if($sigincardriver !== null){
                    $sigdriver =  $sigincardriver->FILE_NAME;
                }else{ $sigdriver = '';}

                $func = DB::table('vehicle_car_function')->where('CAR_FUNCTION_STATUS','=','True')->first();

                $funcgleave = DB::table('gleave_function')->where('ACTIVE','=','True')->first();

                if ($func == null || $func == '') {
                    $f = 'ใบขออนุญาตใช้รถยนต์';
                } else {
                    $f = $func->CAR_FUNCTION_NAME;
                }

                $funccheck = DB::table('vehicle_car_functioncheck')->where('CAR_FUNCTIONCHECK_STATUS','=','True')->first();

                if ($funccheck == null || $funccheck == '') {
                $funch = 'Notopen';
                } else {
                    $funch = $funccheck->CAR_FUNCTIONCHECK_NAMEENG;
                }

                $infoper =  Person::get();

                $imgRepair = DB::table('informrepair_index')->get();
                

                $pdf = PDF::loadView('formpdf.pdf3_10999',[
                    'orgname' => $orgname,
                    'inforcar' => $inforcar,
                    'inforperson' => $inforperson,
                    'infocon' => $infocon,
                    'indexpersons' => $indexperson,
                    'indexpersoncount' => $indexpersoncount,
                    'sig' => $sig,
                    'sigper' => $sigper,
                    'sigsub' => $sigsub,
                    'checksig' => $checksig,
                    'sigdriver' => $sigdriver,
                    'func' => $func,
                    'f' => $f,
                    'funch' => $funch,
                    'infoper' => $infoper,
                    'funcgleave' => $funcgleave,
                    ]);
                    return @$pdf->stream();
}

function pdf3_11120(Request $request,$id)
{
                $orgname =  DB::table('info_org')
                ->leftJoin('hrd_person','info_org.ORG_LEADER_ID','=','hrd_person.ID')
                ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                ->first();

                
                $inforcar = DB::table('vehicle_car_reserve')
                ->leftJoin('vehicle_car_index','vehicle_car_reserve.CAR_SET_ID','=','vehicle_car_index.CAR_ID')
                ->leftJoin('grecord_org_location','vehicle_car_reserve.RESERVE_LOCATION_ID','=','grecord_org_location.LOCATION_ID')
                ->leftJoin('hrd_person','hrd_person.ID','=','vehicle_car_reserve.CAR_DRIVER_SET_ID')
                ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                ->where('RESERVE_ID','=',$id)->first();
                
                
                $iduser = $inforcar->RESERVE_PERSON_ID;
                $inforperson=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
                ->where('hrd_person.ID','=',$iduser)->first();

                $idcon = $inforcar->LEADER_PERSON_ID;
                $infocon =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
                ->where('hrd_person.ID','=',$idcon)->first();

                $indexperson = DB::table('vehicle_car_index_person')
                ->leftJoin('hrd_person','hrd_person.ID','=','vehicle_car_index_person.HR_PERSON_ID')
                ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
                ->where('RESERVE_ID','=',$id)->get();

                $indexpersoncount = DB::table('vehicle_car_index_person')->where('RESERVE_ID','=',$id)->count();

                $checksig = DB::table('gleave_function')->where('FUNCTION_ID','=',1)->where('ACTIVE','=','True')->count();

                $debsub =  DB::table('hrd_department_sub')
                ->leftJoin('hrd_person','hrd_department_sub.LEADER_HR_ID','=','hrd_person.ID')
                ->first();

                $siginper = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforcar->RESERVE_PERSON_ID)->first();

                $siginsub = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforcar->LEADER_PERSON_ID)->first();

                $sigin = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$orgname->ORG_LEADER_ID)->first();

                $sigincardriver = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforcar->CAR_DRIVER_SET_ID)->first();


                if($siginper !== null){
                    $sigper =  $siginper->FILE_NAME;
                }else{ $sigper = '';}

                if($siginsub !== null){
                    $sigsub =  $siginsub->FILE_NAME;
                }else{ $sigsub = '';}

                if($sigin !== null){
                    $sig =  $sigin->FILE_NAME;
                }else{ $sig = '';}

                if($sigincardriver !== null){
                    $sigdriver =  $sigincardriver->FILE_NAME;
                }else{ $sigdriver = '';}

                $func = DB::table('vehicle_car_function')->where('CAR_FUNCTION_STATUS','=','True')->first();

                $funcgleave = DB::table('gleave_function')->where('ACTIVE','=','True')->first();

                if ($func == null || $func == '') {
                    $f = 'ใบขออนุญาตใช้รถยนต์';
                } else {
                    $f = $func->CAR_FUNCTION_NAME;
                }

                $funccheck = DB::table('vehicle_car_functioncheck')->where('CAR_FUNCTIONCHECK_STATUS','=','True')->first();

                if ($funccheck == null || $funccheck == '') {
                $funch = 'Notopen';
                } else {
                    $funch = $funccheck->CAR_FUNCTIONCHECK_NAMEENG;
                }

              
                $infoper =  Person::get();

                $imgRepair = DB::table('informrepair_index')->get();

                $pdf = PDF::loadView('formpdf.pdf3_11120',[
                    'orgname' => $orgname,
                    'inforcar' => $inforcar,
                    'inforperson' => $inforperson,
                    'infocon' => $infocon,
                    'indexpersons' => $indexperson,
                    'indexpersoncount' => $indexpersoncount,
                    'sig' => $sig,
                    'sigper' => $sigper,
                    'sigsub' => $sigsub,
                    'checksig' => $checksig,
                    'sigdriver' => $sigdriver,
                    'func' => $func,
                    'f' => $f,
                    'funch' => $funch,
                    'infoper' => $infoper,
                    'funcgleave' => $funcgleave,
                    ]);
                    return @$pdf->stream();
}

function pdf3_12251(Request $request,$id)
{
                $orgname =  DB::table('info_org')
                ->leftJoin('hrd_person','info_org.ORG_LEADER_ID','=','hrd_person.ID')
                ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                ->first();

                
                $inforcar = DB::table('vehicle_car_reserve')
                ->leftJoin('vehicle_car_index','vehicle_car_reserve.CAR_SET_ID','=','vehicle_car_index.CAR_ID')
                ->leftJoin('grecord_org_location','vehicle_car_reserve.RESERVE_LOCATION_ID','=','grecord_org_location.LOCATION_ID')
                ->leftJoin('hrd_person','hrd_person.ID','=','vehicle_car_reserve.CAR_DRIVER_SET_ID')
                ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                ->where('RESERVE_ID','=',$id)->first();
                
                
                $iduser = $inforcar->RESERVE_PERSON_ID;
                $inforperson=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
                ->where('hrd_person.ID','=',$iduser)->first();

                $idcon = $inforcar->LEADER_PERSON_ID;
                $infocon =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
                ->where('hrd_person.ID','=',$idcon)->first();

                $indexperson = DB::table('vehicle_car_index_person')
                ->leftJoin('hrd_person','hrd_person.ID','=','vehicle_car_index_person.HR_PERSON_ID')
                ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
                ->where('RESERVE_ID','=',$id)->get();

                $indexpersoncount = DB::table('vehicle_car_index_person')->where('RESERVE_ID','=',$id)->count();

                $checksig = DB::table('gleave_function')->where('FUNCTION_ID','=',1)->where('ACTIVE','=','True')->count();

                $debsub =  DB::table('hrd_department_sub')
                ->leftJoin('hrd_person','hrd_department_sub.LEADER_HR_ID','=','hrd_person.ID')
                ->first();

                $siginper = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforcar->RESERVE_PERSON_ID)->first();

                $siginsub = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforcar->LEADER_PERSON_ID)->first();

                $sigin = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$orgname->ORG_LEADER_ID)->first();

                $sigincardriver = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforcar->CAR_DRIVER_SET_ID)->first();


                if($siginper !== null){
                    $sigper =  $siginper->FILE_NAME;
                }else{ $sigper = '';}

                if($siginsub !== null){
                    $sigsub =  $siginsub->FILE_NAME;
                }else{ $sigsub = '';}

                if($sigin !== null){
                    $sig =  $sigin->FILE_NAME;
                }else{ $sig = '';}

                if($sigincardriver !== null){
                    $sigdriver =  $sigincardriver->FILE_NAME;
                }else{ $sigdriver = '';}

                $func = DB::table('vehicle_car_function')->where('CAR_FUNCTION_STATUS','=','True')->first();

                $funcgleave = DB::table('gleave_function')->where('ACTIVE','=','True')->first();

                if ($func == null || $func == '') {
                    $f = 'ใบขออนุญาตใช้รถยนต์';
                } else {
                    $f = $func->CAR_FUNCTION_NAME;
                }

                $funccheck = DB::table('vehicle_car_functioncheck')->where('CAR_FUNCTIONCHECK_STATUS','=','True')->first();

                if ($funccheck == null || $funccheck == '') {
                $funch = 'Notopen';
                } else {
                    $funch = $funccheck->CAR_FUNCTIONCHECK_NAMEENG;
                }

                $infoper =  Person::get();
                $imgRepair = DB::table('informrepair_index')->get();  

                $pdf = PDF::loadView('formpdf.pdf3_12251',[
                    'orgname' => $orgname,
                    'inforcar' => $inforcar,
                    'inforperson' => $inforperson,
                    'infocon' => $infocon,
                    'indexpersons' => $indexperson,
                    'indexpersoncount' => $indexpersoncount,
                    'sig' => $sig,
                    'sigper' => $sigper,
                    'sigsub' => $sigsub,
                    'checksig' => $checksig,
                    'sigdriver' => $sigdriver,
                    'func' => $func,
                    'f' => $f,
                    'funch' => $funch,
                    'infoper' => $infoper,
                    'funcgleave' => $funcgleave,
                    ]);
                    return @$pdf->stream();
}
//====================== ฝั่ง User =============================//
function pdf3_general_10999(Request $request,$id) 
{
                $orgname =  DB::table('info_org')
                ->leftJoin('hrd_person','info_org.ORG_LEADER_ID','=','hrd_person.ID')
                ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                ->first();

                
                $inforcar = DB::table('vehicle_car_reserve')
                ->leftJoin('vehicle_car_index','vehicle_car_reserve.CAR_SET_ID','=','vehicle_car_index.CAR_ID')
                ->leftJoin('grecord_org_location','vehicle_car_reserve.RESERVE_LOCATION_ID','=','grecord_org_location.LOCATION_ID')
                ->where('RESERVE_ID','=',$id)->first();
                
                
                $iduser = $inforcar->RESERVE_PERSON_ID;
                $inforperson=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
                ->where('hrd_person.ID','=',$iduser)->first();

                $idcon = $inforcar->LEADER_PERSON_ID;
                $infocon =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
                ->where('hrd_person.ID','=',$idcon)->first();

                $indexperson = DB::table('vehicle_car_index_person')
                ->leftJoin('hrd_person','hrd_person.ID','=','vehicle_car_index_person.HR_PERSON_ID')
                ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
                ->where('RESERVE_ID','=',$id)->get();

                $indexpersoncount = DB::table('vehicle_car_index_person')->where('RESERVE_ID','=',$id)->count();

                $checksig = DB::table('gleave_function')->where('FUNCTION_ID','=',1)->where('ACTIVE','=','True')->count();
                $orgname =  DB::table('info_org')
                ->leftJoin('hrd_person','info_org.ORG_LEADER_ID','=','hrd_person.ID')
                ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                ->first();

                $debsub =  DB::table('hrd_department_sub')
                ->leftJoin('hrd_person','hrd_department_sub.LEADER_HR_ID','=','hrd_person.ID')
                ->first();

                $siginper = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforcar->RESERVE_PERSON_ID)->first();

                $siginsub = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforcar->LEADER_PERSON_ID)->first();

                $sigin = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$orgname->ORG_LEADER_ID)->first();

                $sigincardriver = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforcar->CAR_DRIVER_SET_ID)->first();


                if($siginper !== null){
                    $sigper =  $siginper->FILE_NAME;
                }else{ $sigper = '';}

                if($siginsub !== null){
                    $sigsub =  $siginsub->FILE_NAME;
                }else{ $sigsub = '';}

                if($sigin !== null){
                    $sig =  $sigin->FILE_NAME;
                }else{ $sig = '';}

                if($sigincardriver !== null){
                    $sigdriver =  $sigincardriver->FILE_NAME;
                }else{ $sigdriver = '';}

                $func = DB::table('vehicle_car_function')->where('CAR_FUNCTION_STATUS','=','True')->first();

                $funcgleave = DB::table('gleave_function')->where('ACTIVE','=','True')->first();

                if ($func == null || $func == '') {
                    $f = 'ใบขออนุญาตใช้รถยนต์';
                } else {
                    $f = $func->CAR_FUNCTION_NAME;
                }

                $funccheck = DB::table('vehicle_car_functioncheck')->where('CAR_FUNCTIONCHECK_STATUS','=','True')->first();

                if ($funccheck == null || $funccheck == '') {
                $funch = 'Notopen';
                } else {
                    $funch = $funccheck->CAR_FUNCTIONCHECK_NAMEENG;
                }

                $infoper =  Person::get();

                $pdf = PDF::loadView('formpdf.pdf3_general_10999',[
                    'orgname' => $orgname,
                    'inforcar' => $inforcar,
                    'inforperson' => $inforperson,
                    'infocon' => $infocon,
                    'indexpersons' => $indexperson,
                    'indexpersoncount' => $indexpersoncount,
                    'sig' => $sig,
                    'sigper' => $sigper,
                    'sigsub' => $sigsub,
                    'checksig' => $checksig,
                    'sigdriver' => $sigdriver,
                    'func' => $func,
                    'f' => $f,
                    'funch' => $funch,
                    'infoper' => $infoper,
                    'funcgleave' => $funcgleave,
                    ]);
                    return @$pdf->stream();
}

function personperdev_10999(Request $request,$id)
{

                $funcgleave = DB::table('gleave_function')->where('ACTIVE','=','True')->first(); 
                $funccheck = DB::table('vehicle_car_functioncheck')->where('CAR_FUNCTIONCHECK_STATUS','=','True')->first();

                if ($funccheck == null || $funccheck == '') {
                $funch = 'Notopen';
                } else {
                    $funch = $funccheck->CAR_FUNCTIONCHECK_NAMEENG;
                }

            $infoorg = DB::table('info_org')
            ->leftjoin('hrd_person','info_org.ORG_LEADER_ID','=','hrd_person.ID')
            ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
            ->where('ORG_ID','=',1)->first();
        
            $infopredev = DB::table('grecord_index')
            ->select('grecord_index.created_at','RECORD_HEAD_USE','LOCATION_ORG_NAME','hrd_province.PROVINCE_NAME','DISTANCE','DATE_GO','DATE_BACK','DATE_TRAVEL_GO','FROM_TIME','DATE_TRAVEL_BACK','BACK_TIME','RECORD_VEHICLE_ID','CAR_REG','OFFER_WORK_HR_NAME','USER_POST_NAME','POSITION_IN_WORK','HR_LEVEL_NAME','OFFER_WORK_HR_NAME','STATUS','DR_PROVINCE_USE')
            ->leftjoin('hrd_person','grecord_index.RECORD_USER_ID','=','hrd_person.ID')
            ->leftjoin('hrd_level','hrd_level.HR_LEVEL_ID','=','hrd_person.HR_LEVEL_ID')
            ->leftjoin('grecord_org','grecord_index.RECORD_ORG_ID','=','grecord_org.RECORD_ORG_ID')
            ->leftjoin('hrd_province','hrd_province.ID','=','grecord_index.PROVINCE_ID')
            ->leftJoin('grecord_org_location','grecord_org_location.LOCATION_ID','=','grecord_index.RECORD_LOCATION_ID')
            ->where('grecord_index.ID','=',$id)->first();
        
            
            $index_person = DB::table('grecord_index_person')->where('RECORD_ID','=',$id)->get();
            
            $check = DB::table('grecord_index_person')->where('RECORD_ID','=',$id)->count();
            $inforesive = DB::table('grecord_index')
            ->leftjoin('hrd_person','grecord_index.RECEIVE_BY_ID','=','hrd_person.ID')
            ->where('grecord_index.ID','=',$id)->first();
        
            $infooffer = DB::table('grecord_index')
            ->leftjoin('hrd_person','grecord_index.OFFER_WORK_HR_ID','=','hrd_person.ID')
            ->leftjoin('hrd_level','hrd_level.HR_LEVEL_ID','=','hrd_person.HR_LEVEL_ID')
            ->where('grecord_index.ID','=',$id)->first();
        
            $indexpersonwork = DB::table('grecord_index')
            ->leftjoin('hrd_person','grecord_index.OFFER_WORK_HR_ID','=','hrd_person.ID')
            ->where('grecord_index.ID','=',$id)->first();
        
            $hrddepartment = DB::table('hrd_department')->where('HR_DEPARTMENT_ID','=',1)->first();

                $pdf = PDF::loadView('formpdf.personperdev_10999',[
                    'funch' => $funch,
                    'funcgleave' => $funcgleave,
                'id'=>$id,
                'hrddepartment'=>$hrddepartment,
                'infoorg'=>$infoorg,
                'infopredev'=>$infopredev,
                'indexpersonwork'=>$indexpersonwork,
                'inforesive'=>$inforesive,
                'infooffer'=>$infooffer,
                'check'=>$check,
                'index_persons'=>$index_person
                    ]);
                    return @$pdf->stream();
}


//============ เปิดฟังก์ชันฟอร์มต่างฯ ======================//
public function formrepairnormal()
{   
    $openform = Informrepair_openform::orderBy('OPENFORM_ID', 'asc')->get();                                 
   
    return view('formpdf.formrepairnormal',[
        'openforms' => $openform
    ]);
}

function formrepairnormal_switchactive(Request $request)
{  
    $id = $request->idfunc;
    $active = Informrepair_openform::find($id);
    $active->OPENFORMCAR_STATUS = $request->onoff;
    $active->save();
}


public function pdfRepair($id){


    $info_org = DB::table('info_org')->where('ORG_ID', '=',1)->first();

    $informrepair_index = DB::table('informrepair_index')->where('informrepair_index.ID','=', $id)
    ->leftJoin('hrd_person','hrd_person.ID','=','informrepair_index.USER_REQUEST_ID')
    ->leftJoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_SUB_ID')
    ->leftjoin('asset_article','informrepair_index.ARTICLE_ID','=','asset_article.ARTICLE_ID')
    ->first();


    
    $headdep = DB::table('hrd_department_sub_sub')
    ->leftJoin('hrd_person','hrd_person.ID','=','hrd_department_sub_sub.LEADER_HR_ID')
    ->where('hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=',$informrepair_index->HR_DEPARTMENT_SUB_SUB_ID)->first();
    
    $infoservice = DB::table('informrepair_service')->where('REPAIR_INDEX_ID','=',$id)->get();

    // dd($informrepair_index);
    
    $pdf = PDF::loadView('formpdf.pdf-repair_10978',[
    'org_name' => $info_org->ORG_NAME,
    'informrepair_index' => $informrepair_index,
    'headdep' => $headdep,
    'infoservices' => $infoservice,
    ]);
        return @$pdf->stream();
}


public function pdfRepaircom($id){


    $info_org = DB::table('info_org')->where('ORG_ID', '=',1)->first();

    $informrepair_index = DB::table('informcom_repair')->where('informcom_repair.ID','=', $id)
    ->leftJoin('hrd_person','hrd_person.ID','=','informcom_repair.USER_REQUEST_ID')
    ->leftJoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_SUB_ID')
    ->leftjoin('asset_article','informcom_repair.ARTICLE_ID','=','asset_article.ARTICLE_ID')
    ->first();


    
    $headdep = DB::table('hrd_department_sub_sub')
    ->leftJoin('hrd_person','hrd_person.ID','=','hrd_department_sub_sub.LEADER_HR_ID')
    ->where('hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=',$informrepair_index->HR_DEPARTMENT_SUB_SUB_ID)->first();

    $infoservice = DB::table('informcom_service')->where('REPAIR_INDEX_ID','=',$id)->get();

    
    $pdf = PDF::loadView('formpdf.pdf-repaircom_10978',[
    'org_name' => $info_org->ORG_NAME,
    'informrepair_index' => $informrepair_index,
    'headdep' => $headdep,
    'infoservices' => $infoservice,
    ]);
        return @$pdf->stream();
}



public function pdfRepaircommedical($id){


    $info_org = DB::table('info_org')->where('ORG_ID', '=',1)->first();

    $informrepair_index = DB::table('asset_care_repair')->where('asset_care_repair.ID','=', $id)
    ->leftJoin('hrd_person','hrd_person.ID','=','asset_care_repair.USER_REQUEST_ID')
    ->leftJoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_SUB_ID')
    ->leftjoin('asset_article','asset_care_repair.ARTICLE_ID','=','asset_article.ARTICLE_ID')
    ->first();



    
    $headdep = DB::table('hrd_department_sub_sub')
    ->leftJoin('hrd_person','hrd_person.ID','=','hrd_department_sub_sub.LEADER_HR_ID')
    ->where('hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=',$informrepair_index->HR_DEPARTMENT_SUB_SUB_ID)->first();

    $infoservice = DB::table('asset_care_repair_service')->where('REPAIR_INDEX_ID','=',$id)->get();

    
    $pdf = PDF::loadView('formpdf.repairmedical_10978',[
    'org_name' => $info_org->ORG_NAME,
    'informrepair_index' => $informrepair_index,
    'headdep' => $headdep,
    'infoservices' => $infoservice,
    ]);
        return @$pdf->stream();
}

public function warehouse_function()
{
    $openform = Warehouse_function::get();
    return view('formpdf.warehouse_function',[
    'openforms' =>  $openform,   
    ]);
}
public function warehouse_function_add()
{   
    $openform = Warehouse_function::get();

    return view('formpdf.warehouse_function_add',[
        'openforms' =>  $openform,        
    ]);
}
public function warehouse_function_save(Request $request)
{  
    $add= new Warehouse_function();
    $add->WAREHOUSEFORM_CODE = $request->WAREHOUSEFORM_CODE;
    $add->WAREHOUSEFORM_NAME = $request->WAREHOUSEFORM_NAME;
    $add->save();

    return redirect()->route('form.warehouse_function');
}

public function warehouse_function_edit(Request $request,$id)
{
    $openform = Warehouse_function::where('WAREHOUSEFORM_ID','=',$id)->first();

    return view('formpdf.warehouse_function_edit',[
        'openforms' =>  $openform, 
    ]);
}
public function warehouse_function_update(Request $request)
{      
    $id = $request->WAREHOUSEFORM_ID;
    $updat = Warehouse_function::find($id);       
    $updat->WAREHOUSEFORM_CODE = $request->WAREHOUSEFORM_CODE;    
    $updat->WAREHOUSEFORM_NAME = $request->WAREHOUSEFORM_NAME;     
    $updat->save();

    return redirect()->route('form.warehouse_function');
}
public function warehouse_function_destroy($id)
{
    Warehouse_function::destroy($id);
    return redirect()->route('form.warehouse_function');
}

function openform_switchactive(Request $request)
{  
    $id = $request->idfunc;
    $active = Warehouse_function::find($id);
    $active->WAREHOUSEFORM_STATUS = $request->onoff;
    $active->save();
}


public function warehouse_11120(Request $request,$id,$iduser)
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
    $yearbudget = date("Y")+543;
    }

        $inforwarehouserequest = Warehouserequest::leftJoin('warehouse_request_status','warehouse_request_status.STATUS_CODE','=','warehouse_request.WAREHOUSE_STATUS')  
        ->leftJoin('supplies_inven','supplies_inven.INVEN_ID','=','warehouse_request.WAREHOUSE_INVEN_ID')
        ->leftJoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','warehouse_request.WAREHOUSE_DEP_SUB_SUB_ID')     
        ->where('WAREHOUSE_ID','=', $id)
        ->first();

    

        $warehouserequest = DB::table('warehouse_request_sub')
        ->leftJoin('supplies','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_DETAIL_ID','=','supplies.ID') 
        ->leftJoin('supplies_unit_ref','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_UNIT','=','supplies_unit_ref.ID') 
        ->where('WAREHOUSE_REQUEST_ID','=', $id) 
        ->get();

        $warehouserequest_sum = DB::table('warehouse_request_sub')
        ->leftJoin('supplies','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_DETAIL_ID','=','supplies.ID') 
        ->where('WAREHOUSE_REQUEST_ID','=', $id) 
        ->sum('WAREHOUSE_REQUEST_SUB_SUM_PRICE');


        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        $info_sendstatus = DB::table('warehouse_request_status')->get();
        $info_org = DB::table('info_org')->get();

        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';
        $status = '';
        $search = '';
        $year_id = $yearbudget;

    $pdf = PDF::loadView('formpdf.warehouse_11120',[
        'inforpersonuserid' => $inforpersonuserid,
        'inforpersonuser' => $inforpersonuser,
        'inforwarehouserequests' => $inforwarehouserequest,
        'warehouserequests' => $warehouserequest,
        'warehouserequest_sum' => $warehouserequest_sum,
        'info_sendstatuss' => $info_sendstatus,
        'budgets' =>  $budget,
        'displaydate_bigen'=> $displaydate_bigen,
        'displaydate_end'=> $displaydate_end,
        'status_check'=> $status,
        'search'=> $search,
        'year_id'=>$year_id, 
        'info_orgs'=>$info_org,
    ]);

    return @$pdf->stream();
}


public function warehouse_11379 (Request $request,$id,$iduser)
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
    $yearbudget = date("Y")+543;
    }

        $inforwarehouserequest = Warehouserequest::leftJoin('warehouse_request_status','warehouse_request_status.STATUS_CODE','=','warehouse_request.WAREHOUSE_STATUS')  
        ->leftJoin('supplies_inven','supplies_inven.INVEN_ID','=','warehouse_request.WAREHOUSE_INVEN_ID')
        ->leftJoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','warehouse_request.WAREHOUSE_DEP_SUB_SUB_ID')     
        ->where('WAREHOUSE_ID','=', $id)
        ->first();

        $warehouserequest = DB::table('warehouse_request_sub')
        ->leftJoin('supplies','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_DETAIL_ID','=','supplies.ID') 
        ->leftJoin('supplies_unit_ref','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_UNIT','=','supplies_unit_ref.ID') 
        ->where('WAREHOUSE_REQUEST_ID','=', $id) 
        ->get();

        $warehouserequest_sum = DB::table('warehouse_request_sub')
        ->leftJoin('supplies','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_DETAIL_ID','=','supplies.ID') 
        ->where('WAREHOUSE_REQUEST_ID','=', $id) 
        ->sum('WAREHOUSE_REQUEST_SUB_SUM_PRICE');


        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        $info_sendstatus = DB::table('warehouse_request_status')->get();
        $info_org = DB::table('info_org')->get();

        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';
        $status = '';
        $search = '';
        $year_id = $yearbudget;

    $pdf = PDF::loadView('formpdf.11379.infowithdrawindex_billpaypdf_11379',[
        'inforpersonuserid' => $inforpersonuserid,
        'inforpersonuser' => $inforpersonuser,
        'inforwarehouserequests' => $inforwarehouserequest,
        'warehouserequests' => $warehouserequest,
        'warehouserequest_sum' => $warehouserequest_sum,
        'info_sendstatuss' => $info_sendstatus,
        'budgets' =>  $budget,
        'displaydate_bigen'=> $displaydate_bigen,
        'displaydate_end'=> $displaydate_end,
        'status_check'=> $status,
        'search'=> $search,
        'year_id'=>$year_id, 
        'info_orgs'=>$info_org,
    ]);
    return @$pdf->stream();
}



public function warehouse_11485(Request $request,$id,$iduser)
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
    $yearbudget = date("Y")+543;
    }

        $inforwarehouserequest = Warehouserequest::leftJoin('warehouse_request_status','warehouse_request_status.STATUS_CODE','=','warehouse_request.WAREHOUSE_STATUS')  
        ->leftJoin('supplies_inven','supplies_inven.INVEN_ID','=','warehouse_request.WAREHOUSE_INVEN_ID')
        ->leftJoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','warehouse_request.WAREHOUSE_DEP_SUB_SUB_ID')     
        ->where('WAREHOUSE_ID','=', $id)
        ->first();

        $warehouserequest = DB::table('warehouse_request_sub')
        ->leftJoin('supplies','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_DETAIL_ID','=','supplies.ID') 
        ->leftJoin('supplies_unit_ref','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_UNIT','=','supplies_unit_ref.ID') 
        ->where('WAREHOUSE_REQUEST_ID','=', $id) 
        ->get();

        $warehouserequest_sum = DB::table('warehouse_request_sub')
        ->leftJoin('supplies','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_DETAIL_ID','=','supplies.ID') 
        ->where('WAREHOUSE_REQUEST_ID','=', $id) 
        ->sum('WAREHOUSE_REQUEST_SUB_SUM_PRICE');


        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        $info_sendstatus = DB::table('warehouse_request_status')->get();
        $info_org = DB::table('info_org')->get();

        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';
        $status = '';
        $search = '';
        $year_id = $yearbudget;

    $pdf = PDF::loadView('formpdf.11485.infowithdrawindex_billpaypdf_11485',[
        'inforpersonuserid' => $inforpersonuserid,
        'inforpersonuser' => $inforpersonuser,
        'inforwarehouserequests' => $inforwarehouserequest,
        'warehouserequests' => $warehouserequest,
        'warehouserequest_sum' => $warehouserequest_sum,
        'info_sendstatuss' => $info_sendstatus,
        'budgets' =>  $budget,
        'displaydate_bigen'=> $displaydate_bigen,
        'displaydate_end'=> $displaydate_end,
        'status_check'=> $status,
        'search'=> $search,
        'year_id'=>$year_id, 
        'info_orgs'=>$info_org,
    ]);
    return @$pdf->stream();
}



public function pdfrepair_11120(Request $request,$id)
{      

    $info_org = DB::table('info_org')
    ->leftJoin('hrd_person','hrd_person.ID','=','info_org.ORG_LEADER_ID')
    ->where('ORG_ID', '=',1)->first();

    $informrepair_index = DB::table('informrepair_index')->where('informrepair_index.ID','=', $id)          
        ->leftjoin('hrd_person','informrepair_index.USER_REQUEST_ID','=','hrd_person.ID')
        ->leftjoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_SUB_ID')
        ->leftjoin('asset_article','informrepair_index.ARTICLE_ID','=','asset_article.ARTICLE_ID')

        ->leftjoin('supplies_brand','supplies_brand.BRAND_ID','=','asset_article.BRAND_ID')
        ->leftjoin('supplies_model','supplies_model.MODEL_ID','=','asset_article.MODEL_ID')
        
        ->leftjoin('asset_building','informrepair_index.LOCATION_SEE_ID','=','asset_building.ID')
        ->leftjoin('supplies_location_level','informrepair_index.LOCATIONLEVEL_SEE_ID','=','supplies_location_level.LOCATION_LEVEL_ID')
        ->leftjoin('supplies_location_level_room','informrepair_index.LOCATIONLEVELROOM_SEE_ID','=','supplies_location_level_room.LEVEL_ROOM_ID')
        ->leftjoin('informcom_priority','informrepair_index.PRIORITY_ID','=','informcom_priority.PRIORITY_ID')
        ->first();
                
    $headdep = DB::table('hrd_department_sub_sub')
        ->leftJoin('hrd_person','hrd_person.ID','=','hrd_department_sub_sub.LEADER_HR_ID')
        ->where('hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=',$informrepair_index->HR_DEPARTMENT_SUB_SUB_ID)->first();

    $headbigdep = DB::table('hrd_department')
        ->leftJoin('hrd_person','hrd_person.ID','=','hrd_department.LEADER_HR_ID')
        ->where('hrd_department.HR_DEPARTMENT_ID','=',1)->first();
    
    $infoservice = DB::table('informrepair_service')->where('REPAIR_INDEX_ID','=',$id)->get();

    $pdf = PDF::loadView('formpdf/11120/pdfrepair_11120',[           
        'info_orgs' => $info_org,
        'informrepair_indexs' => $informrepair_index,
        'headdeps' => $headdep,
        'headbigdeps' => $headbigdep,
        'infoservices' => $infoservice,  
    ]); 
  
    $dom_pdf = $pdf->getDomPDF();
    $canvas = $dom_pdf ->get_canvas();
    $canvas->page_text(500, 5, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 9, array(10, 0, 0));  
                    //500 คือ กว้างจากซ้ายมาขวา //5 คือ margintop ตัวอักษร   // 11 คือ ขนาดตัวอักษร Page 1 of 2   // 10, 0, 0 คือสีอักษร
    return @$pdf->stream();
}
//=========== เปิดฟังก์ชันฟอร์มทั่วไป ======================//
public function function_repairenormal()
{   
    $openform = Infomrepair_functionnormal::orderBy('FUNCT_REPNORMAL_ID', 'asc')->get();                                 
    
    return view('formpdf.function_repairenormal',[
        'openforms' => $openform
    ]);
}
public function function_repairenormal_add()
{   
    $openform = Infomrepair_functionnormal::orderBy('FUNCT_REPNORMAL_ID', 'asc')->get();                                 
    
    return view('formpdf.function_repairenormal_add',[
        'openforms' => $openform
    ]);
}
public function function_repairenormal_save(Request $request)
{  
    $add= new Infomrepair_functionnormal();
    $add->FUNCT_REPNORMAL_CODE = $request->FUNCT_REPNORMAL_CODE;
    $add->FUNCT_REPNORMAL_NAME = $request->FUNCT_REPNORMAL_NAME;
    $add->save();
    // Toastr::success('บันทึกข้อมูลสำเร็จ');
    return redirect()->route('form.function_repairenormal');
}

public function function_repairenormal_edit(Request $request,$id)
{
    $openform = Infomrepair_functionnormal::where('FUNCT_REPNORMAL_ID','=',$id)->first();

    return view('formpdf.function_repairenormal_edit',[
        'openforms' =>  $openform, 
    ]);
}
public function function_repairenormal_update(Request $request)
{      
    $id = $request->FUNCT_REPNORMAL_ID;
    $updat = Infomrepair_functionnormal::find($id);       
    $updat->FUNCT_REPNORMAL_CODE = $request->FUNCT_REPNORMAL_CODE;    
    $updat->FUNCT_REPNORMAL_NAME = $request->FUNCT_REPNORMAL_NAME;     
    $updat->save();
    // Toastr::success('แก้ไขข้อมูลสำเร็จ');
    return redirect()->route('form.function_repairenormal');
}
public function function_repairenormal_destroy($id)
{
    Infomrepair_functionnormal::destroy($id);
    // Toastr::success('ลบข้อมูลสำเร็จ');
    return redirect()->route('form.function_repairenormal');
}

function function_repairenormal_switchactive(Request $request)
{  
    $id = $request->idfunc;
    $active = Infomrepair_functionnormal::find($id);
    $active->FUNCT_REPNORMAL_STATUS = $request->onoff;
    $active->save();
}
    
//=========== เปิดฟังก์ชันฟอร์มเครื่องมือแพทย์ ======================//

public function formrepairmedical()
{   
    $openform = Infomrepair_functionmedical::orderBy('FUNCT_REPMEDICAL_ID', 'asc')->get();                                 
    
    return view('formpdf/10743/formrepairmedical',[
        'openforms' => $openform
    ]);
}
public function formrepairmedical_save(Request $request)
{
    $validator = Validator::make($request->all(),[           
        'FUNCT_REPMEDICAL_CODE'   => 'required',
        'FUNCT_REPMEDICAL_NAME'   => 'required',                
    ]);
    $add = new Infomrepair_functionmedical();
    $add->FUNCT_REPMEDICAL_CODE = $request->input('FUNCT_REPMEDICAL_CODE');     
    $add->FUNCT_REPMEDICAL_NAME = $request->input('FUNCT_REPMEDICAL_NAME');         
    $add->save();
    //    return redirect()->route('form.formrepairmedical');
    return response()->json([
        'status'     => '200'
        ]);
}
public function formrepairmedical_edit(Request $request,$id)
{
        $data = Infomrepair_functionmedical::find($id);   
        return response()->json([
        'status'     => '200',
        'data'   =>  $data
        ]);
}
public function formrepairmedical_update(Request $request)
{
        $validator = Validator::make($request->all(),[           
            'FUNCT_REPMEDICAL_CODE'   => 'required',
            'FUNCT_REPMEDICAL_NAME'   => 'required',                
        ]);
        $id= $request->input('FUNCT_REPMEDICAL_ID');
        $update = Infomrepair_functionmedical::find($id);
        $update->FUNCT_REPMEDICAL_CODE = $request->input('FUNCT_REPMEDICAL_CODE');     
        $update->FUNCT_REPMEDICAL_NAME = $request->input('FUNCT_REPMEDICAL_NAME');         
        $update->save();       
        return response()->json([
            'status'     => '200'
            ]);
}
public function formrepairmedical_destroy(Request $request,$id)
{
    $data = Infomrepair_functionmedical::find($id);       
    $data->delete(); 
        return response()->json(['success' => 'Delete Success']);
}
function formrepairmedical_switchactive(Request $request)
{  
    $id = $request->idfunc;
    $active = Infomrepair_functionmedical::find($id);
    $active->FUNCT_REPMEDICAL_STATUS = $request->onoff;
    $active->save();
}
 
  
   

//=========== เปิดฟังก์ชันฟอร์มเครื่อง8 COm ======================//

public function repaircomfunction_10999()
{   
    $openform = Infomrepair_functioncom::orderBy('FUNCT_REPCOM_ID', 'asc')->get();                                 

    return view('formpdf/10999/repaircomfunction_10999',[
        'openforms' => $openform
    ]);
}
public function repaircomfunction_10999_save(Request $request)
{
    $validator = Validator::make($request->all(),[           
        'FUNCT_REPCOM_CODE'   => 'required',
        'FUNCT_REPCOM_NAME'   => 'required',                
    ]);
    $add = new Infomrepair_functioncom();
    $add->FUNCT_REPCOM_CODE = $request->input('FUNCT_REPCOM_CODE');     
    $add->FUNCT_REPCOM_NAME = $request->input('FUNCT_REPCOM_NAME');         
    $add->save();
    return response()->json([
        'status'     => '200'
        ]);
}
public function repaircomfunction_10999_edit(Request $request,$id)
{
    $data = Infomrepair_functioncom::find($id);   
    return response()->json([
        'status'     => '200',
        'data'   =>  $data
        ]);
}
public function repaircomfunction_10999_update(Request $request)
{
       $validator = Validator::make($request->all(),[           
           'FUNCT_REPCOM_CODE'   => 'required',
           'FUNCT_REPCOM_NAME'   => 'required',                
       ]);
       $id= $request->input('FUNCT_REPCOM_ID');
       $update = Infomrepair_functioncom::find($id);
       $update->FUNCT_REPCOM_CODE = $request->input('FUNCT_REPCOM_CODE');     
       $update->FUNCT_REPCOM_NAME = $request->input('FUNCT_REPCOM_NAME');         
       $update->save();       
       return response()->json([
           'status'     => '200'
           ]);
}
function repaircomfunction_10999_switchactive(Request $request)
{  
      $id = $request->idfunc;
      $active = Infomrepair_functioncom::find($id);
      $active->FUNCT_REPCOM_STATUS = $request->onoff;
      $active->save();
}
public function repaircomfunction_10999_destroy($id)
{
   
    $data = Infomrepair_functioncom::find($id);       
    $data->delete(); 
    return response()->json(['success' => 'Delete Success']);
}

public function repaircom_10999(Request $request,$id)
{      

    $info_org = DB::table('info_org')
    ->leftJoin('hrd_person','hrd_person.ID','=','info_org.ORG_LEADER_ID')
    ->where('ORG_ID', '=',1)->first();

    $infoasset = DB::table('asset_article')->get();

      $infolocation = DB::table('supplies_location')->get(); 

      $informcomrepair = Informcomrepair::where('informcom_repair.ID','=',$id)   
      ->leftjoin('informrepair_priority','informrepair_priority.PRIORITY_ID','=','informcom_repair.PRIORITY_ID')
      ->leftjoin('hrd_person','informcom_repair.USER_REQUEST_ID','=','hrd_person.ID')
      ->leftjoin('asset_article','asset_article.ARTICLE_ID','=','informcom_repair.ARTICLE_ID')
      ->leftjoin('supplies_brand','asset_article.BRAND_ID','=','supplies_brand.BRAND_ID')
      ->leftjoin('supplies_model','asset_article.MODEL_ID','=','supplies_model.MODEL_ID')
      ->leftjoin('supplies_location','asset_article.LOCATION_ID','=','supplies_location.LOCATION_ID')
      ->leftjoin('supplies_location_level','asset_article.LOCATION_LEVEL_ID','=','supplies_location_level.LOCATION_LEVEL_ID')
      ->leftjoin('supplies_location_level_room','asset_article.LEVEL_ROOM_ID','=','supplies_location_level_room.LEVEL_ROOM_ID')
      ->leftjoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_SUB_ID')
      ->first(); 

       $infoassetother = DB::table('informrepair_other')->get();       

       if($informcomrepair->LOCATION_SEE_ID != ''){
         $infolocationlevel= DB::table('supplies_location_level')->where('LOCATION_ID','=',$informcomrepair->LOCATION_SEE_ID)->get();
       }
       else{
         $infolocationlevel= '';      
       }          

       if($informcomrepair->LOCATIONLEVEL_SEE_ID != ''){
         $infolocationlevelroom= DB::table('supplies_location_level_room')->where('LOCATION_LEVEL_ID','=',$informcomrepair->LOCATIONLEVEL_SEE_ID)->get();
       }
       else{
         $infolocationlevelroom= '';      
       } 

       $informrepair_tech = DB::table('informcom_engineer')
       ->leftJoin('hrd_person','hrd_person.ID','=','informcom_engineer.PERSON_ID')
       ->where('ACTIVE','=',True)
       ->get();
                
    $headdep = DB::table('hrd_department_sub_sub')
        ->leftJoin('hrd_person','hrd_person.ID','=','hrd_department_sub_sub.LEADER_HR_ID')
        ->where('hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=',$informcomrepair->HR_DEPARTMENT_SUB_SUB_ID)->first();

    $headbigdep = DB::table('hrd_department')
        ->leftJoin('hrd_person','hrd_person.ID','=','hrd_department.LEADER_HR_ID')
        ->where('hrd_department.HR_DEPARTMENT_ID','=',1)->first();
  
    $infoservice = DB::table('informrepair_service')->where('REPAIR_INDEX_ID','=',$id)->get();

    $pdf = PDF::loadView('formpdf/10999/repaircom_10999',[           
        'info_orgs' => $info_org,
        'informcomrepair' => $informcomrepair,
        'headdeps' => $headdep,
        'headbigdeps' => $headbigdep,
        'infoservices' => $infoservice,  
    ]); 

    return @$pdf->stream();
}  

//********************* 10791 **************************//

public function repaircom_10791(Request $request,$id)
{    
    $info_org = DB::table('info_org')
    ->leftJoin('hrd_person','hrd_person.ID','=','info_org.ORG_LEADER_ID')
    ->where('ORG_ID', '=',1)->first();

    $infoasset = DB::table('asset_article')->get();

      $infolocation = DB::table('supplies_location')->get(); 

      $informcomrepair = Informcomrepair::where('informcom_repair.ID','=',$id)   
      ->leftjoin('informrepair_priority','informrepair_priority.PRIORITY_ID','=','informcom_repair.PRIORITY_ID')
      ->leftjoin('hrd_person','informcom_repair.USER_REQUEST_ID','=','hrd_person.ID')
      ->leftjoin('asset_article','asset_article.ARTICLE_ID','=','informcom_repair.ARTICLE_ID')
      ->leftjoin('supplies_brand','asset_article.BRAND_ID','=','supplies_brand.BRAND_ID')
      ->leftjoin('supplies_model','asset_article.MODEL_ID','=','supplies_model.MODEL_ID')
      ->leftjoin('supplies_location','asset_article.LOCATION_ID','=','supplies_location.LOCATION_ID')
      ->leftjoin('supplies_location_level','asset_article.LOCATION_LEVEL_ID','=','supplies_location_level.LOCATION_LEVEL_ID')
      ->leftjoin('supplies_location_level_room','asset_article.LEVEL_ROOM_ID','=','supplies_location_level_room.LEVEL_ROOM_ID')
      ->leftjoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_SUB_ID')
      ->first(); 

       $infoassetother = DB::table('informrepair_other')->get();       

       if($informcomrepair->LOCATION_SEE_ID != ''){
         $infolocationlevel= DB::table('supplies_location_level')->where('LOCATION_ID','=',$informcomrepair->LOCATION_SEE_ID)->get();
       }
       else{
         $infolocationlevel= '';      
       }          

       if($informcomrepair->LOCATIONLEVEL_SEE_ID != ''){
         $infolocationlevelroom= DB::table('supplies_location_level_room')->where('LOCATION_LEVEL_ID','=',$informcomrepair->LOCATIONLEVEL_SEE_ID)->get();
       }
       else{
         $infolocationlevelroom= '';      
       } 

       $informrepair_tech = DB::table('informcom_engineer')
       ->leftJoin('hrd_person','hrd_person.ID','=','informcom_engineer.PERSON_ID')
       ->where('ACTIVE','=',True)
       ->get();
                
    $headdep = DB::table('hrd_department_sub_sub')
        ->leftJoin('hrd_person','hrd_person.ID','=','hrd_department_sub_sub.LEADER_HR_ID')
        ->where('hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=',$informcomrepair->HR_DEPARTMENT_SUB_SUB_ID)->first();

    $headbigdep = DB::table('hrd_department')
        ->leftJoin('hrd_person','hrd_person.ID','=','hrd_department.LEADER_HR_ID')
        ->where('hrd_department.HR_DEPARTMENT_ID','=',1)->first();
  
    $infoservice = DB::table('informrepair_service')->where('REPAIR_INDEX_ID','=',$id)->get();

    $pdf = PDF::loadView('formpdf/10791/repaircom_10791',[           
        'info_orgs' => $info_org,
        'informcomrepair' => $informcomrepair,
        'headdeps' => $headdep,
        'headbigdeps' => $headbigdep,
        'infoservices' => $infoservice,  
    ]); 
   
    return @$pdf->stream();
} 

//======================= 10743 =============================================//

public function formrepairnormal_10743(Request $request,$id)
{      

    $info_org = DB::table('info_org')
    ->leftJoin('hrd_person','hrd_person.ID','=','info_org.ORG_LEADER_ID')
    ->where('ORG_ID', '=',1)->first();

    $informrepair_index = DB::table('informrepair_index')->where('informrepair_index.ID','=', $id)          
        ->leftjoin('hrd_person','informrepair_index.USER_REQUEST_ID','=','hrd_person.ID')
        ->leftjoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_SUB_ID')
        ->leftjoin('asset_article','informrepair_index.ARTICLE_ID','=','asset_article.ARTICLE_ID')

        ->leftjoin('supplies_brand','supplies_brand.BRAND_ID','=','asset_article.BRAND_ID')
        ->leftjoin('supplies_model','supplies_model.MODEL_ID','=','asset_article.MODEL_ID')
        
        ->leftjoin('asset_building','informrepair_index.LOCATION_SEE_ID','=','asset_building.ID')
        ->leftjoin('supplies_location_level','informrepair_index.LOCATIONLEVEL_SEE_ID','=','supplies_location_level.LOCATION_LEVEL_ID')
        ->leftjoin('supplies_location_level_room','informrepair_index.LOCATIONLEVELROOM_SEE_ID','=','supplies_location_level_room.LEVEL_ROOM_ID')
        ->leftjoin('informcom_priority','informrepair_index.PRIORITY_ID','=','informcom_priority.PRIORITY_ID')
        ->first();
                
    $headdep = DB::table('hrd_department_sub_sub')
        ->leftJoin('hrd_person','hrd_person.ID','=','hrd_department_sub_sub.LEADER_HR_ID')
        ->where('hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=',$informrepair_index->HR_DEPARTMENT_SUB_SUB_ID)->first();

    $headbigdep = DB::table('hrd_department')
        ->leftJoin('hrd_person','hrd_person.ID','=','hrd_department.LEADER_HR_ID')
        ->where('hrd_department.HR_DEPARTMENT_ID','=',1)->first();
    
    $infoservice = DB::table('informrepair_service')->where('REPAIR_INDEX_ID','=',$id)->get();

    $pdf = PDF::loadView('formpdf/10743/formrepairnormal_10743',[           
        'info_orgs' => $info_org,
        'informrepair_indexs' => $informrepair_index,
        'headdeps' => $headdep,
        'headbigdeps' => $headbigdep,
        'infoservices' => $infoservice,  
    ]); 
  
    return @$pdf->stream();
}

public function formrepairmedical_10743(Request $request,$id)
{      

    $info_org = DB::table('info_org')
    ->leftJoin('hrd_person','hrd_person.ID','=','info_org.ORG_LEADER_ID')
    ->where('ORG_ID', '=',1)->first();


    $infoasset = DB::table('asset_article')->where('TYPE_SUB_ID','=',31)->get();
    $infolocation = DB::table('supplies_location')->get();

    $informrepair_tech = DB::table('asset_care_enginer')
    ->leftJoin('hrd_person','hrd_person.ID','=','asset_care_enginer.PERSON_ID')
    ->get();
    
    $inforepairmedical = Assetcarerepair::where('asset_care_repair.ID', '=',$id)
        ->select(DB::raw('asset_care_repair.* , asset_article.* , hrd_department_sub_sub.*'))
        ->leftjoin('asset_article','asset_care_repair.ARTICLE_ID','asset_article.ARTICLE_ID')
        ->leftjoin('hrd_person','asset_care_repair.TECH_REPAIR_ID','hrd_person.ID')
        ->leftjoin('asset_building','asset_care_repair.LOCATION_SEE_ID','=','asset_building.ID')
        ->leftjoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','hrd_person.HR_DEPARTMENT_SUB_SUB_ID')
        ->first(); 

        $infoassetother = DB::table('informrepair_other')->get();

                
    $headdep = DB::table('hrd_department_sub_sub')
        ->leftJoin('hrd_person','hrd_person.ID','=','hrd_department_sub_sub.LEADER_HR_ID')
        ->where('hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=',$inforepairmedical->HR_DEPARTMENT_SUB_SUB_ID)->first();

    $headbigdep = DB::table('hrd_department')
        ->leftJoin('hrd_person','hrd_person.ID','=','hrd_department.LEADER_HR_ID')
        ->where('hrd_department.HR_DEPARTMENT_ID','=',1)->first();
    
    $infoservice = DB::table('informrepair_service')->where('REPAIR_INDEX_ID','=',$id)->get();

    $pdf = PDF::loadView('formpdf/10743/formrepairmedical_10743',[           
        'info_orgs' => $info_org,
        'inforepairmedical' => $inforepairmedical,
        'headdeps' => $headdep,
        'headbigdeps' => $headbigdep,
        'infoservices' => $infoservice,  
    ]); 
        
    
    return @$pdf->stream();
}

function carnornal_10743(Request $request,$id)
{
                $orgname =  DB::table('info_org')
                ->leftJoin('hrd_person','info_org.ORG_LEADER_ID','=','hrd_person.ID')
                ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                ->first();

                
                $inforcar = DB::table('vehicle_car_reserve')
                ->leftJoin('vehicle_car_index','vehicle_car_reserve.CAR_SET_ID','=','vehicle_car_index.CAR_ID')
                ->leftJoin('grecord_org_location','vehicle_car_reserve.RESERVE_LOCATION_ID','=','grecord_org_location.LOCATION_ID')
                ->leftJoin('hrd_person','hrd_person.ID','=','vehicle_car_reserve.CAR_DRIVER_SET_ID')
                ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
                ->where('RESERVE_ID','=',$id)->first();
                
                
                $iduser = $inforcar->RESERVE_PERSON_ID;
                $inforperson=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
                ->where('hrd_person.ID','=',$iduser)->first();

                $idcon = $inforcar->LEADER_PERSON_ID;
                $infocon =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
                ->where('hrd_person.ID','=',$idcon)->first();

                $indexperson = DB::table('vehicle_car_index_person')
                ->leftJoin('hrd_person','hrd_person.ID','=','vehicle_car_index_person.HR_PERSON_ID')
                ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
                ->where('RESERVE_ID','=',$id)->get();

                $indexpersoncount = DB::table('vehicle_car_index_person')->where('RESERVE_ID','=',$id)->count();

                $checksig = DB::table('gleave_function')->where('FUNCTION_ID','=',1)->where('ACTIVE','=','True')->count();

                $debsub =  DB::table('hrd_department_sub')
                ->leftJoin('hrd_person','hrd_department_sub.LEADER_HR_ID','=','hrd_person.ID')
                ->first();

                $siginper = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforcar->RESERVE_PERSON_ID)->first();

                $siginsub = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforcar->LEADER_PERSON_ID)->first();

                $sigin = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$orgname->ORG_LEADER_ID)->first();

                $sigincardriver = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforcar->CAR_DRIVER_SET_ID)->first();


                if($siginper !== null){
                    $sigper =  $siginper->FILE_NAME;
                }else{ $sigper = '';}

                if($siginsub !== null){
                    $sigsub =  $siginsub->FILE_NAME;
                }else{ $sigsub = '';}

                if($sigin !== null){
                    $sig =  $sigin->FILE_NAME;
                }else{ $sig = '';}

                if($sigincardriver !== null){
                    $sigdriver =  $sigincardriver->FILE_NAME;
                }else{ $sigdriver = '';}

                $func = DB::table('vehicle_car_function')->where('CAR_FUNCTION_STATUS','=','True')->first();

                $funcgleave = DB::table('gleave_function')->where('ACTIVE','=','True')->first();

                if ($func == null || $func == '') {
                    $f = 'ใบขออนุญาตใช้รถยนต์';
                } else {
                    $f = $func->CAR_FUNCTION_NAME;
                }

                $funccheck = DB::table('vehicle_car_functioncheck')->where('CAR_FUNCTIONCHECK_STATUS','=','True')->first();

                if ($funccheck == null || $funccheck == '') {
                $funch = 'Notopen';
                } else {
                    $funch = $funccheck->CAR_FUNCTIONCHECK_NAMEENG;
                }

                $infoper =  Person::get();

                $imgRepair = DB::table('informrepair_index')->get();
                

                $pdf = PDF::loadView('formpdf.10743.carnornal_10743',[
                    'orgname' => $orgname,
                    'inforcar' => $inforcar,
                    'inforperson' => $inforperson,
                    'infocon' => $infocon,
                    'indexpersons' => $indexperson,
                    'indexpersoncount' => $indexpersoncount,
                    'sig' => $sig,
                    'sigper' => $sigper,
                    'sigsub' => $sigsub,
                    'checksig' => $checksig,
                    'sigdriver' => $sigdriver,
                    'func' => $func,
                    'f' => $f,
                    'funch' => $funch,
                    'infoper' => $infoper,
                    'funcgleave' => $funcgleave,
                    ]);
                    return @$pdf->stream();
}

function carrefer_10743 (Request $request,$id)
{
                $orgname =  DB::table('info_org')
                ->leftJoin('hrd_person','info_org.ORG_LEADER_ID','=','hrd_person.ID')
                ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                ->first();
            
                $inforefer = DB::table('vehicle_car_refer')
                ->leftJoin('vehicle_car_index','vehicle_car_refer.CAR_ID','=','vehicle_car_index.CAR_ID')
                ->leftJoin('grecord_org_location','vehicle_car_refer.REFER_LOCATION_GO_ID','=','grecord_org_location.LOCATION_ID')
                ->leftJoin('hrd_person','hrd_person.ID','=','vehicle_car_refer.DRIVER_ID')
                ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
                ->where('vehicle_car_refer.ID','=',$id)->first();

                $iduser = $inforefer->USER_REQUEST_ID;

                $inforperson=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
                ->where('hrd_person.ID','=',$iduser)->first();
            
                $indexperson = DB::table('vehicle_car_index_person')
                ->leftJoin('hrd_person','hrd_person.ID','=','vehicle_car_index_person.HR_PERSON_ID')
                ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
                ->where('RESERVE_ID','=',$id)->get();
            
            
                $indexpersoncount = DB::table('vehicle_car_index_person')->where('RESERVE_ID','=',$id)->count();
        
            $checksig = DB::table('gleave_function')->where('FUNCTION_ID','=',1)->where('ACTIVE','=','True')->count();
            $orgname =  DB::table('info_org')
            ->leftJoin('hrd_person','info_org.ORG_LEADER_ID','=','hrd_person.ID')
            ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
            ->first();
            
            $debsub =  DB::table('hrd_department_sub')
            ->leftJoin('hrd_person','hrd_department_sub.LEADER_HR_ID','=','hrd_person.ID')
            ->first();
            
            
            $siginper = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforefer->USER_REQUEST_ID)->first();
            
            
            $sigin = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$orgname->ORG_LEADER_ID)->first();
            
            $sigincardriver = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforefer->DRIVER_ID)->first();
            
            
            if($siginper !== null){
                $sigper =  $siginper->FILE_NAME;
            }else{ $sigper = '';}
            
            if($sigin !== null){
                $sig =  $sigin->FILE_NAME;
            }else{ $sig = '';}
            
            if($sigincardriver !== null){
                $sigdriver =  $sigincardriver->FILE_NAME;
            }else{ $sigdriver = '';}
            
            $func = DB::table('vehicle_car_function')->where('CAR_FUNCTION_STATUS','=','True')->first();
            
            if ($func == null || $func == '') {
                $f = 'ใบขออนุญาตใช้รถยนต์';
            } else {
                $f = $func->CAR_FUNCTION_NAME;
            }
            
            $funccheck = DB::table('vehicle_car_functioncheck')->where('CAR_FUNCTIONCHECK_STATUS','=','True')->first();
            
            if ($funccheck == null || $funccheck == '') {
            $funch = 'Notopen';
            } else {
                $funch = $funccheck->CAR_FUNCTIONCHECK_NAMEENG;
            }
            
            $infoper =  Person::get();

            $funcgleave = DB::table('gleave_function')->where('ACTIVE','=','True')->first();
            
            $pdf = PDF::loadView('formpdf.10743.carrefer_10743',[
                'inforefer' => $inforefer,
                'orgname' => $orgname,
                'funcgleave' => $funcgleave,
                'inforperson' => $inforperson,
                'indexpersons' => $indexperson,
                'indexpersoncount' => $indexpersoncount,
                'sig' => $sig,
                'sigper' => $sigper,
                'checksig' => $checksig,
                'sigdriver' => $sigdriver,
                'func' => $func,
                'f' => $f,
                'funch' => $funch,
                'infoper' => $infoper,
                ]);
                return @$pdf->stream();
}

public function billpaypdf_10978(Request $request,$id,$iduser)
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
    $yearbudget = date("Y")+543;
    }

      $inforwarehouserequest = Warehouserequest::leftJoin('warehouse_request_status','warehouse_request_status.STATUS_CODE','=','warehouse_request.WAREHOUSE_STATUS')  
      ->leftJoin('supplies_inven','supplies_inven.INVEN_ID','=','warehouse_request.WAREHOUSE_INVEN_ID')
      ->leftJoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','warehouse_request.WAREHOUSE_DEP_SUB_SUB_ID')     
      ->where('WAREHOUSE_ID','=', $id)
      ->first();

   

      $warehouserequest = DB::table('warehouse_request_sub')
      ->leftJoin('supplies','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_DETAIL_ID','=','supplies.ID') 
      ->leftJoin('supplies_unit_ref','supplies.ID','=','supplies_unit_ref.SUP_ID') 
      ->where('supplies_unit_ref.SUP_TOTAL','=','1')
      ->where('WAREHOUSE_REQUEST_ID','=', $id) 
      ->orderBy('warehouse_request_sub.WAREHOUSE_REQUEST_SUB_ID', 'asc')
      ->get();

      $count = DB::table('warehouse_request_sub')
      ->leftJoin('supplies','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_DETAIL_ID','=','supplies.ID') 
      ->leftJoin('supplies_unit_ref','supplies.ID','=','supplies_unit_ref.SUP_ID') 
      ->where('supplies_unit_ref.SUP_TOTAL','=','1')
      ->where('WAREHOUSE_REQUEST_ID','=', $id) 
      ->orderBy('warehouse_request_sub.WAREHOUSE_REQUEST_SUB_ID', 'asc')
      ->count();

      $warehouserequest_sum = DB::table('warehouse_request_sub')
      ->leftJoin('supplies','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_DETAIL_ID','=','supplies.ID') 
      ->where('WAREHOUSE_REQUEST_ID','=', $id) 
      ->sum('WAREHOUSE_REQUEST_SUB_SUM_PRICE');

      $result = DB::table('warehouse_request_sub')
      ->leftJoin('supplies','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_DETAIL_ID','=','supplies.ID') 
      ->where('WAREHOUSE_REQUEST_ID','=', $id) 
      ->get(); 

      $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

      $info_sendstatus = DB::table('warehouse_request_status')->get();
      $info_org = DB::table('info_org')->get();

      $displaydate_bigen = ($yearbudget-544).'-10-01';
      $displaydate_end = ($yearbudget-543).'-09-30';
      $status = '';
      $search = '';
      $year_id = $yearbudget;

    $pdf = PDF::loadView('formpdf.10978.infowithdrawindex_billpaypdf_10978',[
        'inforpersonuserid' => $inforpersonuserid,
        'inforpersonuser' => $inforpersonuser,
        'inforwarehouserequests' => $inforwarehouserequest,
        'warehouserequests' => $warehouserequest,
        'warehouserequest_sum' => $warehouserequest_sum,
        'info_sendstatuss' => $info_sendstatus,
        'budgets' =>  $budget,
        'displaydate_bigen'=> $displaydate_bigen,
        'displaydate_end'=> $displaydate_end,
        'status_check'=> $status,
        'search'=> $search,
        'year_id'=>$year_id, 
        'info_orgs'=>$info_org,
        'count'=>$count,
        'result'=>$result,
    ]);

  $pdf->getDomPDF()->set_option("isPhpEnabled", true);
  $pdf->setPaper('a4', 'portrait');
  

    $dom_pdf = $pdf->getDomPDF();  
    $canvas = $dom_pdf ->get_canvas();
    $canvas->page_text(500, 5, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 9, array(10, 0, 0));  
                    //   500 คือ กว้างจากซ้ายมาขวา //5 คือ margintop ตัวอักษร   // 11 คือ ขนาดตัวอักษร Page 1 of 2   // 10, 0, 0 คือสีอักษร

    return @$pdf->stream();
}


//=========== เปิดฟังก์ชันฟอร์ม ขอไปราชการ ======================//

public function persondevfunction()
{   
    $openform = Persondev_function::orderBy('PERSONDEV_ID', 'asc')->get();                                 

    return view('formpdf/persondevfunction',[
        'openforms' => $openform
    ]);
}
public function persondevfunction_save(Request $request)
{
    $validator = Validator::make($request->all(),[           
        'PERSONDEV_CODE'   => 'required',
        'PERSONDEV_NAME'   => 'required',                
    ]);
    $add = new Persondev_function();
    $add->PERSONDEV_CODE = $request->input('PERSONDEV_CODE');     
    $add->PERSONDEV_NAME = $request->input('PERSONDEV_NAME');         
    $add->save();
    return response()->json([
        'status'     => '200'
        ]);
}
public function persondevfunction_edit(Request $request,$id)
{
    $data = Persondev_function::find($id);   
    return response()->json([
        'status'     => '200',
        'data'   =>  $data
        ]);
}
public function persondevfunction_update(Request $request)
{
       $validator = Validator::make($request->all(),[           
           'PERSONDEV_CODE'   => 'required',
           'PERSONDEV_NAME'   => 'required',                
       ]);
       $id= $request->input('PERSONDEV_ID');
       $update = Persondev_function::find($id);
       $update->PERSONDEV_CODE = $request->input('PERSONDEV_CODE');     
       $update->PERSONDEV_NAME = $request->input('PERSONDEV_NAME');         
       $update->save();       
       return response()->json([
           'status'     => '200'
           ]);
}
function persondevfunction_switchactive(Request $request)
{  
      $id = $request->idfunc;
      $active = Persondev_function::find($id);
      $active->PERSONDEV_STATUS = $request->onoff;
      $active->save();
}
public function persondevfunction_destroy($id)
{
   
    $data = Persondev_function::find($id);       
    $data->delete(); 
    return response()->json(['success' => 'Delete Success']);
}

//=========== ฟอร์ม ขอไปราชการ รพ.ภูเชียว ======================//
public function persondev_outside_10978(Request $request,$id,$iduser)
{

    $infoorg = DB::table('info_org')
        ->leftjoin('hrd_person','info_org.ORG_LEADER_ID','=','hrd_person.ID')
        ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->where('ORG_ID','=',1)->first();

    $infopredev = DB::table('grecord_index')
        ->select('grecord_index.created_at','RECORD_HEAD_USE','LOCATION_ORG_NAME','hrd_province.PROVINCE_NAME','DISTANCE','DATE_GO','DATE_BACK','DATE_TRAVEL_GO','FROM_TIME','DATE_TRAVEL_BACK','BACK_TIME','RECORD_VEHICLE_ID','CAR_REG','OFFER_WORK_HR_NAME','USER_POST_NAME','POSITION_IN_WORK','HR_LEVEL_NAME','OFFER_WORK_HR_NAME','STATUS','DR_PROVINCE_USE')
        ->leftjoin('hrd_person','grecord_index.RECORD_USER_ID','=','hrd_person.ID')
        ->leftjoin('hrd_level','hrd_level.HR_LEVEL_ID','=','hrd_person.HR_LEVEL_ID')
        ->leftjoin('grecord_org','grecord_index.RECORD_ORG_ID','=','grecord_org.RECORD_ORG_ID')
        ->leftjoin('hrd_province','hrd_province.ID','=','grecord_index.PROVINCE_ID')
        ->leftJoin('grecord_org_location','grecord_org_location.LOCATION_ID','=','grecord_index.RECORD_LOCATION_ID')
    ->where('grecord_index.ID','=',$id)->first();

    
    $index_person = DB::table('grecord_index_person')
    ->leftjoin('hrd_person','grecord_index_person.HR_PERSON_ID','=','hrd_person.ID')   
    ->leftjoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID') 
    ->where('RECORD_ID','=',$id)->get();

    $check = DB::table('grecord_index_person')->where('RECORD_ID','=',$id)->count();
    $inforesive = DB::table('grecord_index')
        ->leftjoin('hrd_person','grecord_index.RECEIVE_BY_ID','=','hrd_person.ID')
    ->where('grecord_index.ID','=',$id)->first();

    $infooffer = DB::table('grecord_index')
        ->leftjoin('hrd_person','grecord_index.OFFER_WORK_HR_ID','=','hrd_person.ID')
        ->leftjoin('hrd_level','hrd_level.HR_LEVEL_ID','=','hrd_person.HR_LEVEL_ID')
    ->where('grecord_index.ID','=',$id)->first();

    $indexpersonwork = DB::table('grecord_index')
        ->leftjoin('hrd_person','grecord_index.OFFER_WORK_HR_ID','=','hrd_person.ID')
    ->where('grecord_index.ID','=',$id)->first();

    $hrddepartment = DB::table('hrd_department')->where('HR_DEPARTMENT_ID','=',1)->first();
     
        $pdf = PDF::loadView('formpdf.10978.persondev_outside_10978',[           
            'id'=>$id,
            'hrddepartment'=>$hrddepartment,
            'infoorg'=>$infoorg,
            'infopredev'=>$infopredev,
            'indexpersonwork'=>$indexpersonwork,
            'inforesive'=>$inforesive,
            'infooffer'=>$infooffer,
            'check'=>$check,
            'index_persons'=>$index_person
        ]);            
        return @$pdf->stream();
  
}





}
