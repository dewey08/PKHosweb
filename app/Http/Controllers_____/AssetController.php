<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Person;
use App\Models\Suppliesrequest;
use App\Models\Suppliesrequestsub;
use App\Models\Assetarticle;
use App\Models\Assetborrow;
use App\Models\Assetbuilding;
use App\Models\Assetrequest;
use App\Models\Assetrequestsub;

use App\Models\Assetrequestlend;
use App\Models\Assetrequestlendsub;
use PDF;

date_default_timezone_set("Asia/Bangkok");

class AssetController extends Controller
{

    public function dashboard(Request $request,$iduser)
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

        $budget = DB::table('asset_article')
        ->select('YEAR_ID', DB::raw('count(*) as total'))
        ->groupBy('YEAR_ID')
        ->orderBy('YEAR_ID', 'desc')
        ->get();
        foreach($budget as $key => $bud){
            if($bud->YEAR_ID === null){
                unset($budget[$key]);
            }
        }
        $costasset = Assetarticle::where('STATUS_ID','=',1)->where('DEP_ID','=',$inforpersonuser->HR_DEPARTMENT_ID)->sum('PRICE_PER_UNIT');
        $countasset = Assetarticle::where('STATUS_ID','=',1)->where('DEP_ID','=',$inforpersonuser->HR_DEPARTMENT_ID)->count();

        $costbuilding = Assetbuilding::where('STATUS_ID','=',1)->sum('BUILD_NGUD_MONEY');
        $countbuilding = Assetbuilding::where('STATUS_ID','=',1)->count();
//=====================================================
        $m_budget = date("m");
        if($m_budget>9){
          $yearbudget = date("Y")+544;
        }else{
          $yearbudget = date("Y")+543;
        }

        $y1 = $yearbudget;
        $y2 = $yearbudget-1;
        $y3 = $yearbudget-2;
        $y4 = $yearbudget-3;
        $y5 = $yearbudget-4;

        $Value1 = Assetarticle::where('YEAR_ID','=',$y1)->where('DEP_ID','=',$inforpersonuser->HR_DEPARTMENT_ID)->sum('PRICE_PER_UNIT');
        $Value2 = Assetarticle::where('YEAR_ID','=',$y2)->where('DEP_ID','=',$inforpersonuser->HR_DEPARTMENT_ID)->sum('PRICE_PER_UNIT');
        $Value3 = Assetarticle::where('YEAR_ID','=',$y3)->where('DEP_ID','=',$inforpersonuser->HR_DEPARTMENT_ID)->sum('PRICE_PER_UNIT');
        $Value4 = Assetarticle::where('YEAR_ID','=',$y4)->where('DEP_ID','=',$inforpersonuser->HR_DEPARTMENT_ID)->sum('PRICE_PER_UNIT');
        $Value5 = Assetarticle::where('YEAR_ID','=',$y5)->where('DEP_ID','=',$inforpersonuser->HR_DEPARTMENT_ID)->sum('PRICE_PER_UNIT');

        $budget1 = Assetarticle::where('STATUS_ID','=',1)->where('DEP_ID','=',$inforpersonuser->HR_DEPARTMENT_ID)->where('BUDGET_ID','=',1)->sum('PRICE_PER_UNIT');
        $budget2 = Assetarticle::where('STATUS_ID','=',1)->where('DEP_ID','=',$inforpersonuser->HR_DEPARTMENT_ID)->where('BUDGET_ID','=',2)->sum('PRICE_PER_UNIT');
        $budget3 = Assetarticle::where('STATUS_ID','=',1)->where('DEP_ID','=',$inforpersonuser->HR_DEPARTMENT_ID)->where('BUDGET_ID','=',3)->sum('PRICE_PER_UNIT');
        $budget4 = Assetarticle::where('STATUS_ID','=',1)->where('DEP_ID','=',$inforpersonuser->HR_DEPARTMENT_ID)->where('BUDGET_ID','=',4)->sum('PRICE_PER_UNIT');
        $budget5 = Assetarticle::where('STATUS_ID','=',1)->where('DEP_ID','=',$inforpersonuser->HR_DEPARTMENT_ID)->where('BUDGET_ID','=',5)->sum('PRICE_PER_UNIT');
        $budget6 = Assetarticle::where('STATUS_ID','=',1)->where('DEP_ID','=',$inforpersonuser->HR_DEPARTMENT_ID)->where('BUDGET_ID','=',6)->sum('PRICE_PER_UNIT');

        $year_id = '';
        return view('general_asset.dashboard_genasset',[
            'inforpersonuserid' => $inforpersonuserid,
            'inforpersonuser' => $inforpersonuser, 
            'budgets' =>  $budget,
            'costasset' =>  $costasset,
            'costbuilding' =>  $costbuilding,
            'y1' =>  $y1,
            'y2' =>  $y2,
            'y3' =>  $y3,
            'y4' =>  $y4,
            'y5' =>  $y5,
            'Value1' =>  $Value1,
            'Value2' =>  $Value2,
            'Value3' =>  $Value3,
            'Value4' =>  $Value4,
            'Value5' =>  $Value5,
            'budget1' =>  $budget1,
            'budget2' =>  $budget2,
            'budget3' =>  $budget3,
            'budget4' =>  $budget4,
            'budget5' =>  $budget5,
            'budget6' =>  $budget6,
            'countasset' =>  $countasset,
            'countbuilding' =>  $countbuilding,
            'year_id' =>  $year_id,
        ]);
    }


    public function dashboardsearch(Request $request,$iduser)
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

        $budget = DB::table('asset_article')
        ->select('YEAR_ID', DB::raw('count(*) as total'))
        ->groupBy('YEAR_ID')
        ->orderBy('YEAR_ID', 'desc')
        ->get();
        foreach($budget as $key => $bud){
            if($bud->YEAR_ID === null){
                unset($budget[$key]);
            }
        }

        $costasset = Assetarticle::where('STATUS_ID','=',1)->where('DEP_ID','=',$inforpersonuser->HR_DEPARTMENT_ID)->sum('PRICE_PER_UNIT');
        $countasset = Assetarticle::where('STATUS_ID','=',1)->where('DEP_ID','=',$inforpersonuser->HR_DEPARTMENT_ID)->count();

        $costbuilding = Assetbuilding::where('STATUS_ID','=',1)->sum('BUILD_NGUD_MONEY');
        $countbuilding = Assetbuilding::where('STATUS_ID','=',1)->count();
//=====================================================
        $yearbudget = $request->YEAR_ID;

         
        $y1 = $yearbudget;
        $y2 = $yearbudget-1;
        $y3 = $yearbudget-2;
        $y4 = $yearbudget-3;
        $y5 = $yearbudget-4;

        $Value1 = Assetarticle::where('YEAR_ID','=',$y1)->where('DEP_ID','=',$inforpersonuser->HR_DEPARTMENT_ID)->sum('PRICE_PER_UNIT');
        $Value2 = Assetarticle::where('YEAR_ID','=',$y2)->where('DEP_ID','=',$inforpersonuser->HR_DEPARTMENT_ID)->sum('PRICE_PER_UNIT');
        $Value3 = Assetarticle::where('YEAR_ID','=',$y3)->where('DEP_ID','=',$inforpersonuser->HR_DEPARTMENT_ID)->sum('PRICE_PER_UNIT');
        $Value4 = Assetarticle::where('YEAR_ID','=',$y4)->where('DEP_ID','=',$inforpersonuser->HR_DEPARTMENT_ID)->sum('PRICE_PER_UNIT');
        $Value5 = Assetarticle::where('YEAR_ID','=',$y5)->where('DEP_ID','=',$inforpersonuser->HR_DEPARTMENT_ID)->sum('PRICE_PER_UNIT');

        $budget1 = Assetarticle::where('STATUS_ID','=',1)->where('DEP_ID','=',$inforpersonuser->HR_DEPARTMENT_ID)->where('BUDGET_ID','=',1)->sum('PRICE_PER_UNIT');
        $budget2 = Assetarticle::where('STATUS_ID','=',1)->where('DEP_ID','=',$inforpersonuser->HR_DEPARTMENT_ID)->where('BUDGET_ID','=',2)->sum('PRICE_PER_UNIT');
        $budget3 = Assetarticle::where('STATUS_ID','=',1)->where('DEP_ID','=',$inforpersonuser->HR_DEPARTMENT_ID)->where('BUDGET_ID','=',3)->sum('PRICE_PER_UNIT');
        $budget4 = Assetarticle::where('STATUS_ID','=',1)->where('DEP_ID','=',$inforpersonuser->HR_DEPARTMENT_ID)->where('BUDGET_ID','=',4)->sum('PRICE_PER_UNIT');
        $budget5 = Assetarticle::where('STATUS_ID','=',1)->where('DEP_ID','=',$inforpersonuser->HR_DEPARTMENT_ID)->where('BUDGET_ID','=',5)->sum('PRICE_PER_UNIT');
        $budget6 = Assetarticle::where('STATUS_ID','=',1)->where('DEP_ID','=',$inforpersonuser->HR_DEPARTMENT_ID)->where('BUDGET_ID','=',6)->sum('PRICE_PER_UNIT');

        $year_id = $yearbudget;

        return view('general_asset.dashboard_genasset',[
            'inforpersonuserid' => $inforpersonuserid,
            'inforpersonuser' => $inforpersonuser, 
            'budgets' =>  $budget,
            'costasset' =>  $costasset,
            'costbuilding' =>  $costbuilding,
            'y1' =>  $y1,
            'y2' =>  $y2,
            'y3' =>  $y3,
            'y4' =>  $y4,
            'y5' =>  $y5,
            'Value1' =>  $Value1,
            'Value2' =>  $Value2,
            'Value3' =>  $Value3,
            'Value4' =>  $Value4,
            'Value5' =>  $Value5,
            'budget1' =>  $budget1,
            'budget2' =>  $budget2,
            'budget3' =>  $budget3,
            'budget4' =>  $budget4,
            'budget5' =>  $budget5,
            'budget6' =>  $budget6,
            'countasset' =>  $countasset,
            'countbuilding' =>  $countbuilding,
            'year_id' =>  $year_id,
        ]);
    }


 

   
    public function infoindex(Request $request,$iduser)
{
    //$email = Auth::user()->email;
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

    $infoasset= Assetarticle::leftJoin('supplies_decline','supplies_decline.DECLINE_ID','=','asset_article.DECLINE_ID')
    ->leftJoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','asset_article.DEP_ID')
    ->leftJoin('supplies_location','supplies_location.LOCATION_ID','=','asset_article.LOCATION_ID')
    ->leftJoin('supplies_location_level','supplies_location_level.LOCATION_LEVEL_ID','=','asset_article.LOCATION_LEVEL_ID')
    ->leftJoin('supplies_location_level_room','supplies_location_level_room.LEVEL_ROOM_ID','=','asset_article.LEVEL_ROOM_ID')
    ->where('OPENS','=','True')
    ->where('DEP_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)
    ->orderBy('ARTICLE_ID', 'desc')
    ->get();


    $infoasset_re= Assetarticle::leftJoin('supplies_decline','supplies_decline.DECLINE_ID','=','asset_article.DECLINE_ID')
    ->leftJoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','asset_article.DEP_ID')
    ->leftJoin('supplies_location','supplies_location.LOCATION_ID','=','asset_article.LOCATION_ID')
    ->leftJoin('supplies_location_level','supplies_location_level.LOCATION_LEVEL_ID','=','asset_article.LOCATION_LEVEL_ID')
    ->leftJoin('supplies_location_level_room','supplies_location_level_room.LEVEL_ROOM_ID','=','asset_article.LEVEL_ROOM_ID')
    ->where('OPENS','=','True')
    ->where('DEP_SUB_SUB_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)
    ->orderBy('ARTICLE_ID', 'desc')
    ->get();

    $info_sendstatus = DB::table('asset_status')->get();
    
  

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

    return view('general_asset.infoindex',[
        'inforpersonuserid' => $inforpersonuserid,
        'inforpersonuser' => $inforpersonuser, 
        'infoassets' => $infoasset,
        'infoasset_res' => $infoasset_re,
        'info_sendstatuss' => $info_sendstatus,
        'displaydate_bigen'=> $displaydate_bigen, 
        'displaydate_end'=> $displaydate_end,
        'status_check'=> $status,
        'search'=> $search,
        'budgets' =>  $budget,
        'year_id'=>$year_id
     
    ]);
    }


    public function infoindexsearch(Request $request,$iduser)
    {
        //$email = Auth::user()->email;
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


                $infoasset= Assetarticle::leftJoin('supplies_decline','supplies_decline.DECLINE_ID','=','asset_article.DECLINE_ID')
                ->leftJoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','asset_article.DEP_ID')
                ->leftJoin('supplies_location','supplies_location.LOCATION_ID','=','asset_article.LOCATION_ID')
                ->leftJoin('supplies_location_level','supplies_location_level.LOCATION_LEVEL_ID','=','asset_article.LOCATION_LEVEL_ID')
                ->leftJoin('supplies_location_level_room','supplies_location_level_room.LEVEL_ROOM_ID','=','asset_article.LEVEL_ROOM_ID')
                ->where('OPENS','=','True')
                ->where('DEP_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)
                ->where(function($q) use ($search){
                    $q->where('ARTICLE_NUM','like','%'.$search.'%');
                    $q->orwhere('DECLINE_NAME','like','%'.$search.'%');  
                    $q->orwhere('ARTICLE_NAME','like','%'.$search.'%');
                    $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');

                })
                ->WhereBetween('RECEIVE_DATE',[$from,$to]) 
                ->orderBy('ARTICLE_ID', 'desc')
                ->get();

              


            }else{

                $infoasset= Assetarticle::leftJoin('supplies_decline','supplies_decline.DECLINE_ID','=','asset_article.DECLINE_ID')
                ->leftJoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','asset_article.DEP_ID')
                ->leftJoin('supplies_location','supplies_location.LOCATION_ID','=','asset_article.LOCATION_ID')
                ->leftJoin('supplies_location_level','supplies_location_level.LOCATION_LEVEL_ID','=','asset_article.LOCATION_LEVEL_ID')
                ->leftJoin('supplies_location_level_room','supplies_location_level_room.LEVEL_ROOM_ID','=','asset_article.LEVEL_ROOM_ID')
                ->where('OPENS','=','True')
                ->where('DEP_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)
                ->where('STATUS_ID','=',$status)
                ->where(function($q) use ($search){
                    $q->where('ARTICLE_NUM','like','%'.$search.'%');
                    $q->orwhere('DECLINE_NAME','like','%'.$search.'%');  
                    $q->orwhere('ARTICLE_NAME','like','%'.$search.'%');
                    $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');

                })
                ->WhereBetween('RECEIVE_DATE',[$from,$to]) 
                ->orderBy('ARTICLE_ID', 'desc')
                ->get();



            }
    

       


        $info_sendstatus = DB::table('asset_status')->get();

        
    $infoasset_re= Assetarticle::leftJoin('supplies_decline','supplies_decline.DECLINE_ID','=','asset_article.DECLINE_ID')
    ->leftJoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','asset_article.DEP_ID')
    ->leftJoin('supplies_location','supplies_location.LOCATION_ID','=','asset_article.LOCATION_ID')
    ->leftJoin('supplies_location_level','supplies_location_level.LOCATION_LEVEL_ID','=','asset_article.LOCATION_LEVEL_ID')
    ->leftJoin('supplies_location_level_room','supplies_location_level_room.LEVEL_ROOM_ID','=','asset_article.LEVEL_ROOM_ID')
    ->where('OPENS','=','True')
    ->where('DEP_SUB_SUB_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)
    ->orderBy('ARTICLE_ID', 'desc')
    ->get();

    $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
    $year_id = $yearbudget;

        return view('general_asset.infoindex',[
            'inforpersonuserid' => $inforpersonuserid,
            'inforpersonuser' => $inforpersonuser, 
            'infoassets' => $infoasset,
            'infoasset_res' => $infoasset_re,
            'info_sendstatuss' => $info_sendstatus,
           'budgets' =>  $budget,
        'displaydate_bigen'=> $displaydate_bigen,
        'displaydate_end'=> $displaydate_end,
        'status_check'=> $status,
        'search'=> $search,
        'year_id'=>$year_id, 
         
        ]);
        
    }



    
public function inforeceive($iduser,$id) { 
                

    $updateopen = Assetarticle::find($id);
    $updateopen->STATUS_ID = '1'; 
    $updateopen->DEP_SUB_SUB_ID = null;
    $updateopen->DEP_SUB_SUB_NAME = '';
    $updateopen->save();

    return redirect()->route('asset.inforindex',[
        'iduser' => $iduser
    ]);     
}



public function infoasset($iduser,$id) { 
                
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

    $infoasset = Assetarticle::leftJoin('supplies_unit','asset_article.UNIT_ID','=','supplies_unit.SUP_UNIT_ID')
    ->leftJoin('supplies_brand','asset_article.BRAND_ID','=','supplies_brand.BRAND_ID')
    ->leftJoin('supplies_color','asset_article.COLOR_ID','=','supplies_color.COLOR_ID')
    ->leftJoin('supplies_model','asset_article.MODEL_ID','=','supplies_model.MODEL_ID')
    ->leftJoin('supplies_size','asset_article.SIZE_ID','=','supplies_size.SIZE_ID')
    ->leftJoin('supplies_method','asset_article.METHOD_ID','=','supplies_method.METHOD_ID')
    ->leftJoin('supplies_buy','asset_article.BUY_ID','=','supplies_buy.BUY_ID')
    ->leftJoin('supplies_budget','asset_article.BUDGET_ID','=','supplies_budget.BUDGET_ID')
    ->leftJoin('supplies_type','asset_article.TYPE_ID','=','supplies_type.SUP_TYPE_ID')
    ->leftJoin('supplies_decline','asset_article.DECLINE_ID','=','supplies_decline.DECLINE_ID')
    ->leftJoin('supplies_vendor','asset_article.VENDOR_ID','=','supplies_vendor.VENDOR_ID')
    ->leftJoin('hrd_department_sub','asset_article.VENDOR_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
    ->leftJoin('supplies_location','asset_article.LOCATION_ID','=','supplies_location.LOCATION_ID')
    ->leftJoin('supplies_location_level','asset_article.LOCATION_LEVEL_ID','=','supplies_location_level.LOCATION_LEVEL_ID')
    ->leftJoin('supplies_location_level_room','asset_article.LEVEL_ROOM_ID','=','supplies_location_level_room.LEVEL_ROOM_ID')
    ->leftJoin('hrd_person','asset_article.PERSON_ID','=','hrd_person.ID')
    ->leftJoin('asset_status','asset_article.STATUS_ID','=','asset_status.STATUS_ID')
    ->leftJoin('asset_group_cal','asset_article.CAL_TYPE_ID','=','asset_group_cal.CAL_TYPE_ID')
    ->leftJoin('asset_group_pm','asset_article.PM_TYPE_ID','=','asset_group_pm.PM_TYPE_ID')
    ->leftJoin('asset_group_risk','asset_article.RISK_TYPE_ID','=','asset_group_risk.RISK_TYPE_ID')
    ->where('ARTICLE_ID','=',$id)->first();


     
      
        return view('general_asset.assetinfo',[
            'inforpersonuserid' => $inforpersonuserid,
            'inforpersonuser' => $inforpersonuser, 
             'infoasset' => $infoasset,   
  
        ]);
}

    //========================================เบิกทรัพสินย์

public function infodisburseindex(Request $request,$iduser)
{
    //$email = Auth::user()->email;
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


    $inforequest = DB::table('asset_request')->where('DEP_SUB_SUB_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID) ->orderBy('ID', 'desc')->get();


    $info_sendstatus = DB::table('asset_status_app')->get();
    


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

    
    return view('general_asset.infodisburseindex',[
        'inforpersonuserid' => $inforpersonuserid,
        'inforpersonuser' => $inforpersonuser, 
        'inforequests' => $inforequest,
        'info_sendstatuss' => $info_sendstatus,
        'displaydate_bigen'=> $displaydate_bigen, 
        'displaydate_end'=> $displaydate_end,
        'status_check'=> $status,
        'search'=> $search,
        'budgets' =>  $budget,
        'year_id'=>$year_id
     
    ]);

}



public function infodisburseindexsearch(Request $request,$iduser)
{
    //$email = Auth::user()->email;
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



            $inforequest = DB::table('asset_request')
            ->where('DEP_SUB_SUB_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID) 
            ->where(function($q) use ($search){
                $q->where('BILL_NUMBER','like','%'.$search.'%');
                $q->orwhere('REQUEST_FOR','like','%'.$search.'%');  
                $q->orwhere('DEP_SUB_SUB_NAME','like','%'.$search.'%');
                $q->orwhere('SAVE_HR_NAME','like','%'.$search.'%');

            })
            ->WhereBetween('DATE_WANT',[$from,$to]) 
            ->orderBy('ID', 'desc')
            ->get();

          


        }else{



            $inforequest = DB::table('asset_request')
            ->where('DEP_SUB_SUB_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID) 
            ->where('STATUS','=',$status)
            ->where(function($q) use ($search){
                $q->where('BILL_NUMBER','like','%'.$search.'%');
                $q->orwhere('REQUEST_FOR','like','%'.$search.'%');  
                $q->orwhere('DEP_SUB_SUB_NAME','like','%'.$search.'%');
                $q->orwhere('SAVE_HR_NAME','like','%'.$search.'%');

            })
            ->WhereBetween('DATE_WANT',[$from,$to]) 
            ->orderBy('ID', 'desc')
            ->get();



        }


   

    $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
    $year_id = $yearbudget;

    $info_sendstatus = DB::table('asset_status_app')->get();


    return view('general_asset.infodisburseindex',[
        'inforpersonuserid' => $inforpersonuserid,
        'inforpersonuser' => $inforpersonuser, 
        'inforequests' => $inforequest,
        'info_sendstatuss' => $info_sendstatus,
        'budgets' =>  $budget,
        'displaydate_bigen'=> $displaydate_bigen,
        'displaydate_end'=> $displaydate_end,
        'status_check'=> $status,
        'search'=> $search,
        'year_id'=>$year_id, 
     
    ]);
    
}





public function infodisburseadd(Request $request,$iduser)
{
    //$email = Auth::user()->email;
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


    
    $inforequestasset = DB::table('asset_article')->where('DEP_ID','=',  $inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)->where('OPENS','=','False')->get();

    $budgetyear = DB::table('budget_year')->where('ACTIVE','=','True')->get();

    return view('general_asset.infodisburseadd',[
        'inforpersonuserid' => $inforpersonuserid,
        'inforpersonuser' => $inforpersonuser, 
        'inforequestassets' => $inforequestasset, 
        'budgetyears' => $budgetyear, 
        
        
     
    ]);

}


public function infodisbursesave(Request $request)
{

                    $DATE_WANT = $request->DATE_WANT;
                    $DATE_OPEN = $request->DATE_OPEN;

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

                if($DATE_OPEN != ''){
                    $STARTDAY = Carbon::createFromFormat('d/m/Y', $DATE_OPEN)->format('Y-m-d');
                    $date_arrary_st=explode("-",$STARTDAY);  
                    $y_sub_st = $date_arrary_st[0]; 
                    
                    if($y_sub_st >= 2500){
                        $y_st = $y_sub_st-543;
                    }else{
                        $y_st = $y_sub_st;
                    }
                    $m_st = $date_arrary_st[1];
                    $d_st = $date_arrary_st[2];  
                    $DATEOPEN= $y_st."-".$m_st."-".$d_st;
                    }else{
                    $DATEOPEN= null;
                }
                

                $addassetrequest = new Assetrequest(); 
                $addassetrequest->SAVE_HR_ID = $request->SAVE_HR_ID;
                $addassetrequest->SAVE_HR_NAME = $request->SAVE_HR_NAME;
                $addassetrequest->DEP_SUB_SUB_ID = $request->DEP_SUB_SUB_ID;
                $addassetrequest->DEP_SUB_SUB_NAME = $request->DEP_SUB_SUB_NAME;
                $addassetrequest->YEAR_ID = $request->YEAR_ID;
                $addassetrequest->BILL_NUMBER = $request->BILL_NUMBER;
                $addassetrequest->REQUEST_FOR = $request->REQUEST_FOR;
                

                $addassetrequest->DATE_WANT = $DATEWANT;
                $addassetrequest->DATE_OPEN = $DATEOPEN;

                $addassetrequest->STATUS = 'REQUEST';

                $addassetrequest->DATE_TIME_SAVE = date('Y-m-d H:i:s');
                $addassetrequest->save();


                $ASSET_REQUEST_ID = Assetrequest::max('ID');


                if($request->ASSET_REQUEST_SUB_ARTICLE_ID[0] != '' || $request->ASSET_REQUEST_SUB_ARTICLE_ID[0] != null){
                    $ASSET_REQUEST_SUB_ARTICLE_ID = $request->ASSET_REQUEST_SUB_ARTICLE_ID;
                    $number =count($ASSET_REQUEST_SUB_ARTICLE_ID);
                    $count = 0;
                    for($count = 0; $count < $number; $count++)
                    {  
                      //echo $row3[$count_3]."<br>";
                     
                       $add = new Assetrequestsub();
                       $add->ASSET_REQUEST_ID = $ASSET_REQUEST_ID;
                       $add->ASSET_REQUEST_SUB_ARTICLE_ID = $ASSET_REQUEST_SUB_ARTICLE_ID[$count];

                       $infoasset = DB::table('asset_article')->where('ARTICLE_ID','=', $ASSET_REQUEST_SUB_ARTICLE_ID[$count])->first();      

                       $add->ASSET_REQUEST_SUB_NUMBER = $infoasset->ARTICLE_NUM;
                       $add->ASSET_REQUEST_SUB_DETAIL = $infoasset->ARTICLE_NAME;
                       $add->ASSET_REQUEST_SUB_UNIT = $infoasset->UNIT_ID;
                       $add->ASSET_REQUEST_SUB_PRICE = $infoasset->PRICE_PER_UNIT;
    
                       $add->save(); 
                     
             
                    }
                }



       return redirect()->route('asset.infodisburseindex',[
        'iduser' => $request->SAVE_HR_ID]); 

}    





public function infodisburseedit(Request $request,$iduser,$id)
{
    //$email = Auth::user()->email;
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


    
    $inforequestasset = DB::table('asset_article')->where('DEP_ID','=',  $inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)->get();

    $budgetyear = DB::table('budget_year')->where('ACTIVE','=','True')->get();

    $infoassetrequest = Assetrequest::where('ID','=',$id)->first();
    $infoassetrequestsub = Assetrequestsub::where('ASSET_REQUEST_ID','=',$id)->get();
    $countchack = Assetrequestsub::where('ASSET_REQUEST_ID','=',$id)->count();

    return view('general_asset.infodisburseedit',[
        'inforpersonuserid' => $inforpersonuserid,
        'inforpersonuser' => $inforpersonuser, 
        'inforequestassets' => $inforequestasset, 
        'budgetyears' => $budgetyear,
        'infoassetrequest' => $infoassetrequest, 
        'infoassetrequestsubs' => $infoassetrequestsub,  
        'countchack' => $countchack,  
        
        
     
    ]);

}


public function infodisburseupdate(Request $request)
{
                    $id = $request->ID;
                    $DATE_WANT = $request->DATE_WANT;
                    $DATE_OPEN = $request->DATE_OPEN;

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

                if($DATE_OPEN != ''){
                    $STARTDAY = Carbon::createFromFormat('d/m/Y', $DATE_OPEN)->format('Y-m-d');
                    $date_arrary_st=explode("-",$STARTDAY);  
                    $y_sub_st = $date_arrary_st[0]; 
                    
                    if($y_sub_st >= 2500){
                        $y_st = $y_sub_st-543;
                    }else{
                        $y_st = $y_sub_st;
                    }
                    $m_st = $date_arrary_st[1];
                    $d_st = $date_arrary_st[2];  
                    $DATEOPEN= $y_st."-".$m_st."-".$d_st;
                    }else{
                    $DATEOPEN= null;
                }
                

                $addassetrequest = Assetrequest::find($id);
                $addassetrequest->SAVE_HR_ID = $request->SAVE_HR_ID;
                $addassetrequest->SAVE_HR_NAME = $request->SAVE_HR_NAME;
                $addassetrequest->DEP_SUB_SUB_ID = $request->DEP_SUB_SUB_ID;
                $addassetrequest->DEP_SUB_SUB_NAME = $request->DEP_SUB_SUB_NAME;
                $addassetrequest->YEAR_ID = $request->YEAR_ID;
                $addassetrequest->BILL_NUMBER = $request->BILL_NUMBER;
                $addassetrequest->REQUEST_FOR = $request->REQUEST_FOR;
                

                $addassetrequest->DATE_WANT = $DATEWANT;
                $addassetrequest->DATE_OPEN = $DATEOPEN;

               

                $addassetrequest->DATE_TIME_SAVE = date('Y-m-d H:i:s');
                $addassetrequest->save();


                $ASSET_REQUEST_ID = $id;

                Assetrequestsub::where('ASSET_REQUEST_ID','=',$id)->delete(); 
                if($request->ASSET_REQUEST_SUB_ARTICLE_ID[0] != '' || $request->ASSET_REQUEST_SUB_ARTICLE_ID[0] != null){
                    $ASSET_REQUEST_SUB_ARTICLE_ID = $request->ASSET_REQUEST_SUB_ARTICLE_ID;
                    $number =count($ASSET_REQUEST_SUB_ARTICLE_ID);
                    $count = 0;
                    for($count = 0; $count < $number; $count++)
                    {  
                      //echo $row3[$count_3]."<br>";
                     
                       $add = new Assetrequestsub();
                       $add->ASSET_REQUEST_ID = $ASSET_REQUEST_ID;
                       $add->ASSET_REQUEST_SUB_ARTICLE_ID = $ASSET_REQUEST_SUB_ARTICLE_ID[$count];

                       $infoasset = DB::table('asset_article')->where('ARTICLE_ID','=', $ASSET_REQUEST_SUB_ARTICLE_ID[$count])->first();      

                       $add->ASSET_REQUEST_SUB_NUMBER = $infoasset->ARTICLE_NUM;
                       $add->ASSET_REQUEST_SUB_DETAIL = $infoasset->ARTICLE_NAME;
                       $add->ASSET_REQUEST_SUB_UNIT = $infoasset->UNIT_ID;
                       $add->ASSET_REQUEST_SUB_PRICE = $infoasset->PRICE_PER_UNIT;
    
                       $add->save(); 
                     
             
                    }
                }



       return redirect()->route('asset.infodisburseindex',[
        'iduser' => $request->SAVE_HR_ID]); 

}    



public function detaildisburseindex(Request $request,$iduser,$id)
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

    $infoassetrequest = Assetrequest::where('ID','=',$id)->first();
    $infoassetrequestsub = Assetrequestsub::where('ASSET_REQUEST_ID','=',$id)->get();

    return view('general_asset.infodisbursedetail',[
        'inforpersonuserid' => $inforpersonuserid,
        'inforpersonuser' => $inforpersonuser, 
        'infoassetrequest' => $infoassetrequest, 
        'infoassetrequestsubs' => $infoassetrequestsub, 
     
    ]);

}




public function canceldisburseindex(Request $request,$iduser,$id)
{
    //$email = Auth::user()->email;
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

    $infoassetrequest = Assetrequest::where('ID','=',$id)->first();
    $infoassetrequestsub = Assetrequestsub::where('ASSET_REQUEST_ID','=',$id)->get();

    return view('general_asset.infodisbursecancel',[
        'inforpersonuserid' => $inforpersonuserid,
        'inforpersonuser' => $inforpersonuser, 
        'infoassetrequest' => $infoassetrequest, 
        'infoassetrequestsubs' => $infoassetrequestsub, 
    
        
        
     
    ]);

}


public function canceldisburseindexupdate(Request $request)
{
    $id = $request->ID; 
    $iduser = $request->iduser;

    $updateapp = Assetrequest::find($id);
    $updateapp->STATUS = 'CANCEL'; 
    $updateapp->save();

   
      return redirect()->route('asset.infodisburseindex',[
        'iduser' => $iduser,
      
    ]);

}




//========================================ทะเบียนการขอยืม

public function infolendindex(Request $request,$iduser)
{
    //$email = Auth::user()->email;
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


    $inforequest = DB::table('asset_request_lend')->where('DEP_SUB_SUB_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID) ->orderBy('ID', 'desc')->get();

    
    $info_sendstatus = DB::table('asset_status_app')->get();

    $dep_sub_sub = DB::table('hrd_department_sub_sub')->get();
    
   

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

    return view('general_asset.infolendindex',[
        'inforpersonuserid' => $inforpersonuserid,
        'inforpersonuser' => $inforpersonuser, 
        'inforequests' => $inforequest,
        'info_sendstatuss' => $info_sendstatus,
        'dep_sub_subs' => $dep_sub_sub,
        'displaydate_bigen'=> $displaydate_bigen, 
        'displaydate_end'=> $displaydate_end,
        'status_check'=> $status,
        'search'=> $search,
        'budgets' =>  $budget,
        'year_id'=>$year_id
     
    ]);

}




public function infolendindexsearch(Request $request,$iduser)
{
    //$email = Auth::user()->email;
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



            $inforequest = DB::table('asset_request_lend')
            ->where('DEP_SUB_SUB_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID) 
            ->where(function($q) use ($search){
                $q->orwhere('REQUEST_FOR','like','%'.$search.'%');  
                $q->orwhere('GIVE_DEP_SUB_SUB_NAME','like','%'.$search.'%');
                $q->orwhere('SAVE_HR_NAME','like','%'.$search.'%');

            })
            ->WhereBetween('DATE_WANT',[$from,$to]) 
            ->orderBy('ID', 'desc')
            ->get();


        }else{



            $inforequest = DB::table('asset_request_lend')
            ->where('DEP_SUB_SUB_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID) 
            ->where('STATUS','=',$status)
            ->where(function($q) use ($search){
                $q->orwhere('REQUEST_FOR','like','%'.$search.'%');  
                $q->orwhere('GIVE_DEP_SUB_SUB_NAME','like','%'.$search.'%');
                $q->orwhere('SAVE_HR_NAME','like','%'.$search.'%');

            })
            ->WhereBetween('DATE_WANT',[$from,$to]) 
            ->orderBy('ID', 'desc')
            ->get();



        }


    


    $info_sendstatus = DB::table('asset_status_app')->get();
    
    $dep_sub_sub = DB::table('hrd_department_sub_sub')->get();

    $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
    $year_id = $yearbudget;

    return view('general_asset.infolendindex',[
        'inforpersonuserid' => $inforpersonuserid,
        'inforpersonuser' => $inforpersonuser, 
        'inforequests' => $inforequest,
        'info_sendstatuss' => $info_sendstatus,
        'dep_sub_subs' => $dep_sub_sub,
        'budgets' =>  $budget,
        'displaydate_bigen'=> $displaydate_bigen,
        'displaydate_end'=> $displaydate_end,
        'status_check'=> $status,
        'search'=> $search,
        'year_id'=>$year_id, 
     
    ]);
    
}

public function infolendindexsenddep (Request $request,$iduser)
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


    
    $inforequestasset = DB::table('asset_article')->where('DEP_ID','=',  $request->HR_DEPARTMENT_SUB_SUB_ID)->where('OPENS','=','True')->where('STATUS_ID','=',1)->get();

    $dep_sub_sub = DB::table('hrd_department_sub_sub')->where('HR_DEPARTMENT_SUB_SUB_ID','=',$request->HR_DEPARTMENT_SUB_SUB_ID)->first();

    return view('general_asset.infolendadd',[
        'inforpersonuserid' => $inforpersonuserid,
        'inforpersonuser' => $inforpersonuser, 
        'inforequestassets' => $inforequestasset, 
        'dep_sub_sub' => $dep_sub_sub,  
        
     
    ]);

}




public function infolendsenddepsave(Request $request)
{

                    $DATE_WANT = $request->DATE_WANT;
                    $DATE_LEND = $request->DATE_LEND;

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

                if($DATE_LEND != ''){
                    $STARTDAY = Carbon::createFromFormat('d/m/Y', $DATE_LEND)->format('Y-m-d');
                    $date_arrary_st=explode("-",$STARTDAY);  
                    $y_sub_st = $date_arrary_st[0]; 
                    
                    if($y_sub_st >= 2500){
                        $y_st = $y_sub_st-543;
                    }else{
                        $y_st = $y_sub_st;
                    }
                    $m_st = $date_arrary_st[1];
                    $d_st = $date_arrary_st[2];  
                    $DATELEND= $y_st."-".$m_st."-".$d_st;
                    }else{
                    $DATELEND= null;
                }
                

                $addassetrequest = new Assetrequestlend(); 
                $addassetrequest->SAVE_HR_ID = $request->SAVE_HR_ID;
                $addassetrequest->SAVE_HR_NAME = $request->SAVE_HR_NAME;

                $addassetrequest->DEP_SUB_SUB_ID = $request->DEP_SUB_SUB_ID;
                $addassetrequest->DEP_SUB_SUB_NAME = $request->DEP_SUB_SUB_NAME;

                $addassetrequest->GIVE_DEP_SUB_SUB_ID = $request->GIVE_DEP_SUB_SUB_ID;
                $addassetrequest->GIVE_DEP_SUB_SUB_NAME = $request->GIVE_DEP_SUB_SUB_NAME;
            
                $addassetrequest->REQUEST_FOR = $request->REQUEST_FOR;
                

                $addassetrequest->DATE_WANT = $DATEWANT;
                $addassetrequest->DATE_LEND = $DATELEND;

                $addassetrequest->STATUS = 'REQUEST';

                $addassetrequest->DATE_TIME_SAVE = date('Y-m-d H:i:s');
                $addassetrequest->save();


                $ASSET_REQUEST_LEND_ID = Assetrequestlend::max('ID');


                if($request->ASSET_REQUEST_LEND_SUB_ARTICLE_ID[0] != '' || $request->ASSET_REQUEST_LEND_SUB_ARTICLE_ID[0] != null){
                    $ASSET_REQUEST_LEND_SUB_ARTICLE_ID = $request->ASSET_REQUEST_LEND_SUB_ARTICLE_ID;
                    $number =count($ASSET_REQUEST_LEND_SUB_ARTICLE_ID);
                    $count = 0;
                    for($count = 0; $count < $number; $count++)
                    {  
                     
                       $add = new Assetrequestlendsub();
                       $add->ASSET_REQUEST_LEND_ID = $ASSET_REQUEST_LEND_ID;
                       $add->ASSET_REQUEST_LEND_SUB_ARTICLE_ID = $ASSET_REQUEST_LEND_SUB_ARTICLE_ID[$count];

                       $infoasset = DB::table('asset_article')->where('ARTICLE_ID','=', $ASSET_REQUEST_LEND_SUB_ARTICLE_ID[$count])->first();      

                       $add->ASSET_REQUEST_LEND_SUB_NUMBER = $infoasset->ARTICLE_NUM;
                       $add->ASSET_REQUEST_LEND_SUB_DETAIL = $infoasset->ARTICLE_NAME;
                       $add->ASSET_REQUEST_LEND_SUB_UNIT = $infoasset->UNIT_ID;
                       $add->ASSET_REQUEST_LEND_SUB_PRICE = $infoasset->PRICE_PER_UNIT;
    
                       $add->save(); 
                     
             
                    }
                }



       return redirect()->route('asset.infolendindex',[
        'iduser' => $request->SAVE_HR_ID]); 

}    


//----------------------------------------------รายละเอียด---


public function detaillendindex (Request $request,$iduser,$id)
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


    $infoassetrequestlend = Assetrequestlend::where('ID','=',$id)->first();
    $infoassetrequestlendsub = Assetrequestlendsub::where('ASSET_REQUEST_LEND_ID','=',$id)->get();

    return view('general_asset.infolenddetail',[
        'inforpersonuserid' => $inforpersonuserid,
        'inforpersonuser' => $inforpersonuser, 
        'infoassetrequestlend' => $infoassetrequestlend, 
        'infoassetrequestlendsubs' => $infoassetrequestlendsub,  
     
    ]);

}
//--------------------------แก้ไข-----

public function infolendedit (Request $request,$iduser,$id)
{
    //$email = Auth::user()->email;
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

    $infoassetrequestlend = Assetrequestlend::where('ID','=',$id)->first();
    $infoassetrequestlendsub = Assetrequestlendsub::where('ASSET_REQUEST_LEND_ID','=',$id)->get();
    $countcheck =  Assetrequestlendsub::where('ASSET_REQUEST_LEND_ID','=',$id)->count();

    $inforequestasset = DB::table('asset_article')->where('DEP_ID','=',  $infoassetrequestlend->GIVE_DEP_SUB_SUB_ID)->get();

    $dep_sub_sub = DB::table('hrd_department_sub_sub')->where('HR_DEPARTMENT_SUB_SUB_ID','=',$infoassetrequestlend->GIVE_DEP_SUB_SUB_ID)->first();

    return view('general_asset.infolendedit',[
        'inforpersonuserid' => $inforpersonuserid,
        'inforpersonuser' => $inforpersonuser, 
        'inforequestassets' => $inforequestasset, 
        'dep_sub_sub' => $dep_sub_sub,
        'infoassetrequestlend' => $infoassetrequestlend, 
        'infoassetrequestlendsubs' => $infoassetrequestlendsub, 
        'countcheck' => $countcheck,      
        
     
    ]);

}


public function infolendupdate(Request $request)
{
                    $id = $request->ID;
                    $DATE_WANT = $request->DATE_WANT;
                    $DATE_LEND = $request->DATE_LEND;

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

                if($DATE_LEND != ''){
                    $STARTDAY = Carbon::createFromFormat('d/m/Y', $DATE_LEND)->format('Y-m-d');
                    $date_arrary_st=explode("-",$STARTDAY);  
                    $y_sub_st = $date_arrary_st[0]; 
                    
                    if($y_sub_st >= 2500){
                        $y_st = $y_sub_st-543;
                    }else{
                        $y_st = $y_sub_st;
                    }
                    $m_st = $date_arrary_st[1];
                    $d_st = $date_arrary_st[2];  
                    $DATELEND= $y_st."-".$m_st."-".$d_st;
                    }else{
                    $DATELEND= null;
                }
                

                $addassetrequest =  Assetrequestlend::find($id);
                $addassetrequest->SAVE_HR_ID = $request->SAVE_HR_ID;
                $addassetrequest->SAVE_HR_NAME = $request->SAVE_HR_NAME;

                $addassetrequest->DEP_SUB_SUB_ID = $request->DEP_SUB_SUB_ID;
                $addassetrequest->DEP_SUB_SUB_NAME = $request->DEP_SUB_SUB_NAME;

             
            
                $addassetrequest->REQUEST_FOR = $request->REQUEST_FOR;
                

                $addassetrequest->DATE_WANT = $DATEWANT;
                $addassetrequest->DATE_LEND = $DATELEND;


                $addassetrequest->DATE_TIME_SAVE = date('Y-m-d H:i:s');
                $addassetrequest->save();


                $ASSET_REQUEST_LEND_ID = $id;

                Assetrequestlendsub::where('ASSET_REQUEST_LEND_ID','=',$id)->delete(); 
                    
                if($request->ASSET_REQUEST_LEND_SUB_ARTICLE_ID[0] != '' || $request->ASSET_REQUEST_LEND_SUB_ARTICLE_ID[0] != null){
                    $ASSET_REQUEST_LEND_SUB_ARTICLE_ID = $request->ASSET_REQUEST_LEND_SUB_ARTICLE_ID;
                    $number =count($ASSET_REQUEST_LEND_SUB_ARTICLE_ID);
                    $count = 0;
                    for($count = 0; $count < $number; $count++)
                    {  
                     
                       $add = new Assetrequestlendsub();
                       $add->ASSET_REQUEST_LEND_ID = $ASSET_REQUEST_LEND_ID;
                       $add->ASSET_REQUEST_LEND_SUB_ARTICLE_ID = $ASSET_REQUEST_LEND_SUB_ARTICLE_ID[$count];

                       $infoasset = DB::table('asset_article')->where('ARTICLE_ID','=', $ASSET_REQUEST_LEND_SUB_ARTICLE_ID[$count])->first();      

                       $add->ASSET_REQUEST_LEND_SUB_NUMBER = $infoasset->ARTICLE_NUM;
                       $add->ASSET_REQUEST_LEND_SUB_DETAIL = $infoasset->ARTICLE_NAME;
                       $add->ASSET_REQUEST_LEND_SUB_UNIT = $infoasset->UNIT_ID;
                       $add->ASSET_REQUEST_LEND_SUB_PRICE = $infoasset->PRICE_PER_UNIT;
    
                       $add->save(); 
                     
             
                    }
                }



       return redirect()->route('asset.infolendindex',[
        'iduser' => $request->SAVE_HR_ID]); 

}    

//--------------------------แจ้งยกเลิก-----


public function cancelinfolendindex (Request $request,$iduser,$id)
{
    //$email = Auth::user()->email;
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


    

    $infoassetrequestlend = Assetrequestlend::where('ID','=',$id)->first();
    $infoassetrequestlendsub = Assetrequestlendsub::where('ASSET_REQUEST_LEND_SUB_ID','=',$id)->get();

    return view('general_asset.infolendcancel',[
        'inforpersonuserid' => $inforpersonuserid,
        'inforpersonuser' => $inforpersonuser, 
        'infoassetrequestlend' => $infoassetrequestlend, 
        'infoassetrequestlendsubs' => $infoassetrequestlendsub,  
        
     
    ]);

}

public function cancelinfolendupdate(Request $request)
{
    $id = $request->ID; 
    $iduser = $request->iduser;

    $updateapp = Assetrequestlend::find($id);
    $updateapp->STATUS = 'CANCEL'; 
    $updateapp->save();

   
      return redirect()->route('asset.infolendindex',[
        'iduser' => $iduser,
      
    ]);

}

//========================================ทะเบียนการถูกยืม

public function infogiveindex(Request $request,$iduser)
{
    //$email = Auth::user()->email;
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


    $inforequest = DB::table('asset_request_lend')->where('GIVE_DEP_SUB_SUB_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID) ->orderBy('ID', 'desc')->get();

    $info_sendstatus = DB::table('asset_status_app')->get();
    
  

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

    return view('general_asset.infogiveindex',[
        'inforpersonuserid' => $inforpersonuserid,
        'inforpersonuser' => $inforpersonuser, 
        'inforequests' => $inforequest,
        'info_sendstatuss' => $info_sendstatus,
        'displaydate_bigen'=> $displaydate_bigen, 
        'displaydate_end'=> $displaydate_end,
        'status_check'=> $status,
        'search'=> $search,
        'budgets' =>  $budget,
        'year_id'=>$year_id       
     
    ]);

}





public function infogiveindexsearch(Request $request,$iduser)
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



            $inforequest = DB::table('asset_request_lend')
            ->where('GIVE_DEP_SUB_SUB_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID) 
            ->where(function($q) use ($search){
                $q->orwhere('REQUEST_FOR','like','%'.$search.'%');  
                $q->orwhere('DEP_SUB_SUB_NAME','like','%'.$search.'%');
                $q->orwhere('SAVE_HR_NAME','like','%'.$search.'%');

            })
            ->WhereBetween('DATE_WANT',[$from,$to]) 
            ->orderBy('ID', 'desc')
            ->get();


        }else{



            $inforequest = DB::table('asset_request_lend')
            ->where('GIVE_DEP_SUB_SUB_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID) 
            ->where('STATUS','=',$status)
            ->where(function($q) use ($search){
                $q->orwhere('REQUEST_FOR','like','%'.$search.'%');  
                $q->orwhere('DEP_SUB_SUB_NAME','like','%'.$search.'%');
                $q->orwhere('SAVE_HR_NAME','like','%'.$search.'%');

            })
            ->WhereBetween('DATE_WANT',[$from,$to]) 
            ->orderBy('ID', 'desc')
            ->get();



        }



    $info_sendstatus = DB::table('asset_status_app')->get();

    $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
    $year_id = $yearbudget;

    return view('general_asset.infogiveindex',[
        'inforpersonuserid' => $inforpersonuserid,
        'inforpersonuser' => $inforpersonuser, 
        'inforequests' => $inforequest,
        'info_sendstatuss' => $info_sendstatus,
        'budgets' =>  $budget,
        'displaydate_bigen'=> $displaydate_bigen,
        'displaydate_end'=> $displaydate_end,
        'status_check'=> $status,
        'search'=> $search,
        'year_id'=>$year_id, 
        
     
    ]);
    
}


//-------------------------อนุมัติ
public function infogiveapp(Request $request,$iduser,$id)
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


    $inforequest = DB::table('asset_request_lend')->where('ID','=',$id)->first();
    $imgperson = DB::table('hrd_person')->where('ID','=',$inforequest->SAVE_HR_ID)->first();


    $infoassetrequest = DB::table('asset_request_lend_sub')->where('ASSET_REQUEST_LEND_ID','=',$inforequest->ID)->get();
  
    
  

    return view('general_asset.infogiveapp',[
        'inforpersonuserid' => $inforpersonuserid,
        'inforpersonuser' => $inforpersonuser, 
        'id' => $id,
        'inforequest' => $inforequest,
        'imgperson' => $imgperson,
        'infoassetrequests' => $infoassetrequest,

         
    ]);

}


public function updategiveapp(Request $request)
{

$id = $request->ID; 
$iduser = $request->iduser;

$check =  $request->SUBMIT; 



if($check == 'approved'){
    $updateapp = Assetrequestlend::find($id);
    $updateapp->STATUS = 'APPROVE'; 
    $updateapp->save();

  
    $inforequesta = DB::table('asset_request_lend')->where('ID','=',$id)->first();
    $infoassetrequest = DB::table('asset_request_lend_sub')->where('ASSET_REQUEST_LEND_ID','=',$id)->get();

  

    foreach($infoassetrequest as $request){


        $idarticle = $request->ASSET_REQUEST_LEND_SUB_ARTICLE_ID;

        $updateopen = Assetarticle::find($idarticle);
        $updateopen->STATUS_ID = '4'; 
        $updateopen->DEP_SUB_SUB_ID = $inforequesta->DEP_SUB_SUB_ID;
        $updateopen->DEP_SUB_SUB_NAME =  $inforequesta->DEP_SUB_SUB_NAME;
        $updateopen->save();


       
    }



}else{
    $updateapp = Assetrequestlend::find($id);
    $updateapp->STATUS = 'NOTAPPROVE'; 
    $updateapp->save();

    $infoassetrequest = DB::table('asset_request_lend_sub')->where('ASSET_REQUEST_LEND_SUB_ID','=',$id)->get();

    foreach($infoassetrequest as $request){


        $idarticle = $request->ASSET_REQUEST_LEND_SUB_ARTICLE_ID;

        $updateopen = Assetarticle::find($idarticle);
        $updateopen->STATUS_ID = '1'; 
        $updateopen->DEP_SUB_SUB_ID = null;
        $updateopen->DEP_SUB_SUB_NAME = '';
        $updateopen->save();

    }
}

       

      return redirect()->route('asset.infogiveindex',[
        'iduser' => $iduser,
      
    ]);

}
 

public function giveappdestroy($iduser,$id,$idlist) { 
                
    Assetrequestlendsub::destroy($idlist);         
    return redirect()->route('asset.infogiveapp',[
        'iduser' => $iduser,
        'id'=>  $id
    
    
    ]);     
}



//=======================================PDF FILE====================================


function pdfdisburse(Request $request,$id)
{


      $inforequest = DB::table('asset_request')->where('ID','=',$id)->first();
      $infoassetrequestsub = Assetrequestsub::leftjoin('supplies_unit_ref','asset_request_sub.ASSET_REQUEST_SUB_UNIT','=','supplies_unit_ref.ID')
      ->where('ASSET_REQUEST_ID','=',$id)    
      ->get();
 
    $pdf = PDF::loadView('general_asset.pdfdisburse',[
        'inforequest' => $inforequest, 
        'infoassetrequestsubs' => $infoassetrequestsub 
    ]);
    return @$pdf->stream();

}

//========================ฟังชันตรวจสอบหน่วย


function checkunitname(Request $request)
{
    
    $ARTICLE_ID = $request->ARTICLE_ID;
    $inforpice=  DB::table('asset_article')
    ->leftjoin('supplies_unit','asset_article.UNIT_ID','=','supplies_unit.SUP_UNIT_ID')
    ->where('ARTICLE_ID','=',$ARTICLE_ID)->first();

    echo $inforpice->SUP_UNIT_NAME;
}

function checkpice(Request $request)
{
    $ARTICLE_ID = $request->ARTICLE_ID;
    $inforunitname=  DB::table('asset_article')->where('ARTICLE_ID','=',$ARTICLE_ID)->first();
    echo number_format($inforunitname->PRICE_PER_UNIT,2);
    
}


}