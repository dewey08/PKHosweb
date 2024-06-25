<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Person;
use App\Models\Supplies;
use App\Models\Suppliesrequest;
use App\Models\Suppliescon;
use App\Models\Assetarticle;
use App\Models\Suppliesgroup;
use App\Models\Suppliesclass;
use App\Models\Suppliestypes;
use App\Models\Suppliesprop;
use App\Models\Suppliesunitref;
use App\Models\Suppliesconlist;
use App\Models\Suppliespurchase;
use App\Models\Suppliesconboard;
use App\Models\Suppliesconquotation;
use App\Models\Suppliesconboarddetail;

use App\Models\Warehousecheckreceive;
use App\Models\Warehousecheckreceiveboard;
use App\Models\Warehousecheckreceivesub;

use App\Models\Assetdepreciate;

use PDF;

use App\Models\Suppliesrequestsub;
use App\Models\Foodboard;

use App\Models\Foodmenu;
use App\Models\Foodmenustaple;
use App\Models\Foodmenudetail;

use App\Models\Foodbill;
use App\Models\Foodbillmenu;
use App\Models\Foodbillmenusup;
use App\Models\Foodbillday;
use App\Models\Foodbillstaple;

use App\Models\Foodtype;
use App\Models\Foodunit;
use App\Models\Foodunitsub;

use App\Models\Foodindexmenu;
use App\Models\Foodindexstaple;
use App\Models\Foodindexboard;
use App\Models\Foodfresh;
use Session;
use Cookie;

date_default_timezone_set("Asia/Bangkok");

class ManagerfoodController extends Controller
{
    public function dashboard_food()
    {
        $year = date('Y');
        $amount_1 = DB::table('food_bill_day')
        ->leftjoin('food_index_staple','food_index_staple.FOOD_BILL_DAY_ID','=','food_bill_day.FOOD_BILL_DAY_ID')
        ->leftjoin('food_menu_staple','food_menu_staple.FOOD_MENU_STAPLE_ID','=','food_index_staple.FOOD_INDEX_STAPLE_SUPID')
        ->where('FOOD_MENU_STAPLE_TYPE','=','1')
        ->where('food_bill_day.FOOD_BILL_DAY_DATE','like',$year.'%')
        ->sum('FOOD_INDEX_STAPLE_PICE');
        $amount_2 = DB::table('food_bill_day')
        ->leftjoin('food_index_staple','food_index_staple.FOOD_BILL_DAY_ID','=','food_bill_day.FOOD_BILL_DAY_ID')
        ->leftjoin('food_menu_staple','food_menu_staple.FOOD_MENU_STAPLE_ID','=','food_index_staple.FOOD_INDEX_STAPLE_SUPID')
        ->where('FOOD_MENU_STAPLE_TYPE','=','2')
        ->where('food_bill_day.FOOD_BILL_DAY_DATE','like',$year.'%')
        ->sum('FOOD_INDEX_STAPLE_PICE');
        $m1_1 = DB::table('food_bill_day')->leftjoin('food_index_staple','food_index_staple.FOOD_BILL_DAY_ID','=','food_bill_day.FOOD_BILL_DAY_ID')->where('FOOD_BILL_DAY_DATE','like',$year.'-01%')->sum('FOOD_INDEX_STAPLE_PICE');
        $m2_1 = DB::table('food_bill_day')->leftjoin('food_index_staple','food_index_staple.FOOD_BILL_DAY_ID','=','food_bill_day.FOOD_BILL_DAY_ID')->where('FOOD_BILL_DAY_DATE','like',$year.'-02%')->sum('FOOD_INDEX_STAPLE_PICE');
        $m3_1 = DB::table('food_bill_day')->leftjoin('food_index_staple','food_index_staple.FOOD_BILL_DAY_ID','=','food_bill_day.FOOD_BILL_DAY_ID')->where('FOOD_BILL_DAY_DATE','like',$year.'-03%')->sum('FOOD_INDEX_STAPLE_PICE');
        $m4_1 = DB::table('food_bill_day')->leftjoin('food_index_staple','food_index_staple.FOOD_BILL_DAY_ID','=','food_bill_day.FOOD_BILL_DAY_ID')->where('FOOD_BILL_DAY_DATE','like',$year.'-04%')->sum('FOOD_INDEX_STAPLE_PICE');
        $m5_1 = DB::table('food_bill_day')->leftjoin('food_index_staple','food_index_staple.FOOD_BILL_DAY_ID','=','food_bill_day.FOOD_BILL_DAY_ID')->where('FOOD_BILL_DAY_DATE','like',$year.'-05%')->sum('FOOD_INDEX_STAPLE_PICE');
        $m6_1 = DB::table('food_bill_day')->leftjoin('food_index_staple','food_index_staple.FOOD_BILL_DAY_ID','=','food_bill_day.FOOD_BILL_DAY_ID')->where('FOOD_BILL_DAY_DATE','like',$year.'-06%')->sum('FOOD_INDEX_STAPLE_PICE');
        $m7_1 = DB::table('food_bill_day')->leftjoin('food_index_staple','food_index_staple.FOOD_BILL_DAY_ID','=','food_bill_day.FOOD_BILL_DAY_ID')->where('FOOD_BILL_DAY_DATE','like',$year.'-07%')->sum('FOOD_INDEX_STAPLE_PICE');
        $m8_1 = DB::table('food_bill_day')->leftjoin('food_index_staple','food_index_staple.FOOD_BILL_DAY_ID','=','food_bill_day.FOOD_BILL_DAY_ID')->where('FOOD_BILL_DAY_DATE','like',$year.'-08%')->sum('FOOD_INDEX_STAPLE_PICE');
        $m9_1 = DB::table('food_bill_day')->leftjoin('food_index_staple','food_index_staple.FOOD_BILL_DAY_ID','=','food_bill_day.FOOD_BILL_DAY_ID')->where('FOOD_BILL_DAY_DATE','like',$year.'-09%')->sum('FOOD_INDEX_STAPLE_PICE');
        $m10_1 = DB::table('food_bill_day')->leftjoin('food_index_staple','food_index_staple.FOOD_BILL_DAY_ID','=','food_bill_day.FOOD_BILL_DAY_ID')->where('FOOD_BILL_DAY_DATE','like',$year.'-10%')->sum('FOOD_INDEX_STAPLE_PICE');
        $m11_1 = DB::table('food_bill_day')->leftjoin('food_index_staple','food_index_staple.FOOD_BILL_DAY_ID','=','food_bill_day.FOOD_BILL_DAY_ID')->where('FOOD_BILL_DAY_DATE','like',$year.'-11%')->sum('FOOD_INDEX_STAPLE_PICE');
        $m12_1 = DB::table('food_bill_day')->leftjoin('food_index_staple','food_index_staple.FOOD_BILL_DAY_ID','=','food_bill_day.FOOD_BILL_DAY_ID')->where('FOOD_BILL_DAY_DATE','like',$year.'-12%')->sum('FOOD_INDEX_STAPLE_PICE');
        $m1_11 = DB::table('food_bill_day')->leftjoin('food_index_staple','food_index_staple.FOOD_BILL_DAY_ID','=','food_bill_day.FOOD_BILL_DAY_ID')->leftjoin('food_menu_staple','food_menu_staple.FOOD_MENU_STAPLE_ID','=','food_index_staple.FOOD_INDEX_STAPLE_SUPID')->where('FOOD_MENU_STAPLE_TYPE','=','1')->where('FOOD_BILL_DAY_DATE','like',$year.'-01%')->sum('FOOD_INDEX_STAPLE_PICE');
        $m2_11 = DB::table('food_bill_day')->leftjoin('food_index_staple','food_index_staple.FOOD_BILL_DAY_ID','=','food_bill_day.FOOD_BILL_DAY_ID')->leftjoin('food_menu_staple','food_menu_staple.FOOD_MENU_STAPLE_ID','=','food_index_staple.FOOD_INDEX_STAPLE_SUPID')->where('FOOD_MENU_STAPLE_TYPE','=','1')->where('FOOD_BILL_DAY_DATE','like',$year.'-02%')->sum('FOOD_INDEX_STAPLE_PICE');
        $m3_11 = DB::table('food_bill_day')->leftjoin('food_index_staple','food_index_staple.FOOD_BILL_DAY_ID','=','food_bill_day.FOOD_BILL_DAY_ID')->leftjoin('food_menu_staple','food_menu_staple.FOOD_MENU_STAPLE_ID','=','food_index_staple.FOOD_INDEX_STAPLE_SUPID')->where('FOOD_MENU_STAPLE_TYPE','=','1')->where('FOOD_BILL_DAY_DATE','like',$year.'-03%')->sum('FOOD_INDEX_STAPLE_PICE');
        $m4_11 = DB::table('food_bill_day')->leftjoin('food_index_staple','food_index_staple.FOOD_BILL_DAY_ID','=','food_bill_day.FOOD_BILL_DAY_ID')->leftjoin('food_menu_staple','food_menu_staple.FOOD_MENU_STAPLE_ID','=','food_index_staple.FOOD_INDEX_STAPLE_SUPID')->where('FOOD_MENU_STAPLE_TYPE','=','1')->where('FOOD_BILL_DAY_DATE','like',$year.'-04%')->sum('FOOD_INDEX_STAPLE_PICE');
        $m5_11 = DB::table('food_bill_day')->leftjoin('food_index_staple','food_index_staple.FOOD_BILL_DAY_ID','=','food_bill_day.FOOD_BILL_DAY_ID')->leftjoin('food_menu_staple','food_menu_staple.FOOD_MENU_STAPLE_ID','=','food_index_staple.FOOD_INDEX_STAPLE_SUPID')->where('FOOD_MENU_STAPLE_TYPE','=','1')->where('FOOD_BILL_DAY_DATE','like',$year.'-05%')->sum('FOOD_INDEX_STAPLE_PICE');
        $m6_11 = DB::table('food_bill_day')->leftjoin('food_index_staple','food_index_staple.FOOD_BILL_DAY_ID','=','food_bill_day.FOOD_BILL_DAY_ID')->leftjoin('food_menu_staple','food_menu_staple.FOOD_MENU_STAPLE_ID','=','food_index_staple.FOOD_INDEX_STAPLE_SUPID')->where('FOOD_MENU_STAPLE_TYPE','=','1')->where('FOOD_BILL_DAY_DATE','like',$year.'-06%')->sum('FOOD_INDEX_STAPLE_PICE');
        $m7_11 = DB::table('food_bill_day')->leftjoin('food_index_staple','food_index_staple.FOOD_BILL_DAY_ID','=','food_bill_day.FOOD_BILL_DAY_ID')->leftjoin('food_menu_staple','food_menu_staple.FOOD_MENU_STAPLE_ID','=','food_index_staple.FOOD_INDEX_STAPLE_SUPID')->where('FOOD_MENU_STAPLE_TYPE','=','1')->where('FOOD_BILL_DAY_DATE','like',$year.'-07%')->sum('FOOD_INDEX_STAPLE_PICE');
        $m8_11 = DB::table('food_bill_day')->leftjoin('food_index_staple','food_index_staple.FOOD_BILL_DAY_ID','=','food_bill_day.FOOD_BILL_DAY_ID')->leftjoin('food_menu_staple','food_menu_staple.FOOD_MENU_STAPLE_ID','=','food_index_staple.FOOD_INDEX_STAPLE_SUPID')->where('FOOD_MENU_STAPLE_TYPE','=','1')->where('FOOD_BILL_DAY_DATE','like',$year.'-08%')->sum('FOOD_INDEX_STAPLE_PICE');
        $m9_11 = DB::table('food_bill_day')->leftjoin('food_index_staple','food_index_staple.FOOD_BILL_DAY_ID','=','food_bill_day.FOOD_BILL_DAY_ID')->leftjoin('food_menu_staple','food_menu_staple.FOOD_MENU_STAPLE_ID','=','food_index_staple.FOOD_INDEX_STAPLE_SUPID')->where('FOOD_MENU_STAPLE_TYPE','=','1')->where('FOOD_BILL_DAY_DATE','like',$year.'-09%')->sum('FOOD_INDEX_STAPLE_PICE');
        $m10_11 = DB::table('food_bill_day')->leftjoin('food_index_staple','food_index_staple.FOOD_BILL_DAY_ID','=','food_bill_day.FOOD_BILL_DAY_ID')->leftjoin('food_menu_staple','food_menu_staple.FOOD_MENU_STAPLE_ID','=','food_index_staple.FOOD_INDEX_STAPLE_SUPID')->where('FOOD_MENU_STAPLE_TYPE','=','1')->where('FOOD_BILL_DAY_DATE','like',$year.'-10%')->sum('FOOD_INDEX_STAPLE_PICE');
        $m11_11 = DB::table('food_bill_day')->leftjoin('food_index_staple','food_index_staple.FOOD_BILL_DAY_ID','=','food_bill_day.FOOD_BILL_DAY_ID')->leftjoin('food_menu_staple','food_menu_staple.FOOD_MENU_STAPLE_ID','=','food_index_staple.FOOD_INDEX_STAPLE_SUPID')->where('FOOD_MENU_STAPLE_TYPE','=','1')->where('FOOD_BILL_DAY_DATE','like',$year.'-11%')->sum('FOOD_INDEX_STAPLE_PICE');
        $m12_11 = DB::table('food_bill_day')->leftjoin('food_index_staple','food_index_staple.FOOD_BILL_DAY_ID','=','food_bill_day.FOOD_BILL_DAY_ID')->leftjoin('food_menu_staple','food_menu_staple.FOOD_MENU_STAPLE_ID','=','food_index_staple.FOOD_INDEX_STAPLE_SUPID')->where('FOOD_MENU_STAPLE_TYPE','=','1')->where('FOOD_BILL_DAY_DATE','like',$year.'-12%')->sum('FOOD_INDEX_STAPLE_PICE');


        
        $m1_12 = DB::table('food_bill_day')->leftjoin('food_index_staple','food_index_staple.FOOD_BILL_DAY_ID','=','food_bill_day.FOOD_BILL_DAY_ID')->leftjoin('food_menu_staple','food_menu_staple.FOOD_MENU_STAPLE_ID','=','food_index_staple.FOOD_INDEX_STAPLE_SUPID')->where('FOOD_MENU_STAPLE_TYPE','=','2')->where('FOOD_BILL_DAY_DATE','like',$year.'-01%')->sum('FOOD_INDEX_STAPLE_PICE');
        $m2_12 = DB::table('food_bill_day')->leftjoin('food_index_staple','food_index_staple.FOOD_BILL_DAY_ID','=','food_bill_day.FOOD_BILL_DAY_ID')->leftjoin('food_menu_staple','food_menu_staple.FOOD_MENU_STAPLE_ID','=','food_index_staple.FOOD_INDEX_STAPLE_SUPID')->where('FOOD_MENU_STAPLE_TYPE','=','2')->where('FOOD_BILL_DAY_DATE','like',$year.'-02%')->sum('FOOD_INDEX_STAPLE_PICE');
        $m3_12 = DB::table('food_bill_day')->leftjoin('food_index_staple','food_index_staple.FOOD_BILL_DAY_ID','=','food_bill_day.FOOD_BILL_DAY_ID')->leftjoin('food_menu_staple','food_menu_staple.FOOD_MENU_STAPLE_ID','=','food_index_staple.FOOD_INDEX_STAPLE_SUPID')->where('FOOD_MENU_STAPLE_TYPE','=','2')->where('FOOD_BILL_DAY_DATE','like',$year.'-03%')->sum('FOOD_INDEX_STAPLE_PICE');
        $m4_12 = DB::table('food_bill_day')->leftjoin('food_index_staple','food_index_staple.FOOD_BILL_DAY_ID','=','food_bill_day.FOOD_BILL_DAY_ID')->leftjoin('food_menu_staple','food_menu_staple.FOOD_MENU_STAPLE_ID','=','food_index_staple.FOOD_INDEX_STAPLE_SUPID')->where('FOOD_MENU_STAPLE_TYPE','=','2')->where('FOOD_BILL_DAY_DATE','like',$year.'-04%')->sum('FOOD_INDEX_STAPLE_PICE');
        $m5_12 = DB::table('food_bill_day')->leftjoin('food_index_staple','food_index_staple.FOOD_BILL_DAY_ID','=','food_bill_day.FOOD_BILL_DAY_ID')->leftjoin('food_menu_staple','food_menu_staple.FOOD_MENU_STAPLE_ID','=','food_index_staple.FOOD_INDEX_STAPLE_SUPID')->where('FOOD_MENU_STAPLE_TYPE','=','2')->where('FOOD_BILL_DAY_DATE','like',$year.'-05%')->sum('FOOD_INDEX_STAPLE_PICE');
        $m6_12 = DB::table('food_bill_day')->leftjoin('food_index_staple','food_index_staple.FOOD_BILL_DAY_ID','=','food_bill_day.FOOD_BILL_DAY_ID')->leftjoin('food_menu_staple','food_menu_staple.FOOD_MENU_STAPLE_ID','=','food_index_staple.FOOD_INDEX_STAPLE_SUPID')->where('FOOD_MENU_STAPLE_TYPE','=','2')->where('FOOD_BILL_DAY_DATE','like',$year.'-06%')->sum('FOOD_INDEX_STAPLE_PICE');
        $m7_12 = DB::table('food_bill_day')->leftjoin('food_index_staple','food_index_staple.FOOD_BILL_DAY_ID','=','food_bill_day.FOOD_BILL_DAY_ID')->leftjoin('food_menu_staple','food_menu_staple.FOOD_MENU_STAPLE_ID','=','food_index_staple.FOOD_INDEX_STAPLE_SUPID')->where('FOOD_MENU_STAPLE_TYPE','=','2')->where('FOOD_BILL_DAY_DATE','like',$year.'-07%')->sum('FOOD_INDEX_STAPLE_PICE');
        $m8_12 = DB::table('food_bill_day')->leftjoin('food_index_staple','food_index_staple.FOOD_BILL_DAY_ID','=','food_bill_day.FOOD_BILL_DAY_ID')->leftjoin('food_menu_staple','food_menu_staple.FOOD_MENU_STAPLE_ID','=','food_index_staple.FOOD_INDEX_STAPLE_SUPID')->where('FOOD_MENU_STAPLE_TYPE','=','2')->where('FOOD_BILL_DAY_DATE','like',$year.'-08%')->sum('FOOD_INDEX_STAPLE_PICE');
        $m9_12 = DB::table('food_bill_day')->leftjoin('food_index_staple','food_index_staple.FOOD_BILL_DAY_ID','=','food_bill_day.FOOD_BILL_DAY_ID')->leftjoin('food_menu_staple','food_menu_staple.FOOD_MENU_STAPLE_ID','=','food_index_staple.FOOD_INDEX_STAPLE_SUPID')->where('FOOD_MENU_STAPLE_TYPE','=','2')->where('FOOD_BILL_DAY_DATE','like',$year.'-09%')->sum('FOOD_INDEX_STAPLE_PICE');
        $m10_12 = DB::table('food_bill_day')->leftjoin('food_index_staple','food_index_staple.FOOD_BILL_DAY_ID','=','food_bill_day.FOOD_BILL_DAY_ID')->leftjoin('food_menu_staple','food_menu_staple.FOOD_MENU_STAPLE_ID','=','food_index_staple.FOOD_INDEX_STAPLE_SUPID')->where('FOOD_MENU_STAPLE_TYPE','=','2')->where('FOOD_BILL_DAY_DATE','like',$year.'-10%')->sum('FOOD_INDEX_STAPLE_PICE');
        $m11_12 = DB::table('food_bill_day')->leftjoin('food_index_staple','food_index_staple.FOOD_BILL_DAY_ID','=','food_bill_day.FOOD_BILL_DAY_ID')->leftjoin('food_menu_staple','food_menu_staple.FOOD_MENU_STAPLE_ID','=','food_index_staple.FOOD_INDEX_STAPLE_SUPID')->where('FOOD_MENU_STAPLE_TYPE','=','2')->where('FOOD_BILL_DAY_DATE','like',$year.'-11%')->sum('FOOD_INDEX_STAPLE_PICE');
        $m12_12 = DB::table('food_bill_day')->leftjoin('food_index_staple','food_index_staple.FOOD_BILL_DAY_ID','=','food_bill_day.FOOD_BILL_DAY_ID')->leftjoin('food_menu_staple','food_menu_staple.FOOD_MENU_STAPLE_ID','=','food_index_staple.FOOD_INDEX_STAPLE_SUPID')->where('FOOD_MENU_STAPLE_TYPE','=','2')->where('FOOD_BILL_DAY_DATE','like',$year.'-12%')->sum('FOOD_INDEX_STAPLE_PICE');



        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        $year_id = $year+543;
    
        return view('manager_food.dashboard_food',[
            'amount_1' => $amount_1,
            'amount_2' => $amount_2,
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
            'm1_11' => $m1_11,
            'm2_11' => $m2_11,
            'm3_11' => $m3_11,
            'm4_11' => $m4_11,
            'm5_11' => $m5_11,
            'm6_11' => $m6_11,
            'm7_11' => $m7_11,
            'm8_11' => $m8_11,
            'm9_11' => $m9_11,
            'm10_11' => $m10_11,
            'm11_11' => $m11_11,
            'm12_11' => $m12_11,
            'm1_12' => $m1_12,
            'm2_12' => $m2_12,
            'm3_12' => $m3_12,
            'm4_12' => $m4_12,
            'm5_12' => $m5_12,
            'm6_12' => $m6_12,
            'm7_12' => $m7_12,
            'm8_12' => $m8_12,
            'm9_12' => $m9_12,
            'm10_12' => $m10_12,
            'm11_12' => $m11_12,
            'm12_12' => $m12_12,
            'budgets' =>  $budget,
            'year_id'=>$year_id 
            ]);
    }


    public function dashboard_foodsearch(Request $request)
    {

        $year_id = $request->STATUS_CODE;
        $year = $year_id -543;

        $amount_1 = DB::table('food_bill_day')
        ->leftjoin('food_index_staple','food_index_staple.FOOD_BILL_DAY_ID','=','food_bill_day.FOOD_BILL_DAY_ID')
        ->leftjoin('food_menu_staple','food_menu_staple.FOOD_MENU_STAPLE_ID','=','food_index_staple.FOOD_INDEX_STAPLE_SUPID')
        ->where('FOOD_MENU_STAPLE_TYPE','=','1')
        ->where('food_bill_day.FOOD_BILL_DAY_DATE','like',$year.'%')
        ->sum('FOOD_INDEX_STAPLE_PICE');
      

        $amount_2 = DB::table('food_bill_day')
        ->leftjoin('food_index_staple','food_index_staple.FOOD_BILL_DAY_ID','=','food_bill_day.FOOD_BILL_DAY_ID')
        ->leftjoin('food_menu_staple','food_menu_staple.FOOD_MENU_STAPLE_ID','=','food_index_staple.FOOD_INDEX_STAPLE_SUPID')
        ->where('FOOD_MENU_STAPLE_TYPE','=','2')
        ->where('food_bill_day.FOOD_BILL_DAY_DATE','like',$year.'%')
        ->sum('FOOD_INDEX_STAPLE_PICE');
        
    

        $m1_1 = DB::table('food_bill_day')->leftjoin('food_index_staple','food_index_staple.FOOD_BILL_DAY_ID','=','food_bill_day.FOOD_BILL_DAY_ID')->where('FOOD_BILL_DAY_DATE','like',$year.'-01%')->sum('FOOD_INDEX_STAPLE_PICE');
        $m2_1 = DB::table('food_bill_day')->leftjoin('food_index_staple','food_index_staple.FOOD_BILL_DAY_ID','=','food_bill_day.FOOD_BILL_DAY_ID')->where('FOOD_BILL_DAY_DATE','like',$year.'-02%')->sum('FOOD_INDEX_STAPLE_PICE');
        $m3_1 = DB::table('food_bill_day')->leftjoin('food_index_staple','food_index_staple.FOOD_BILL_DAY_ID','=','food_bill_day.FOOD_BILL_DAY_ID')->where('FOOD_BILL_DAY_DATE','like',$year.'-03%')->sum('FOOD_INDEX_STAPLE_PICE');
        $m4_1 = DB::table('food_bill_day')->leftjoin('food_index_staple','food_index_staple.FOOD_BILL_DAY_ID','=','food_bill_day.FOOD_BILL_DAY_ID')->where('FOOD_BILL_DAY_DATE','like',$year.'-04%')->sum('FOOD_INDEX_STAPLE_PICE');
        $m5_1 = DB::table('food_bill_day')->leftjoin('food_index_staple','food_index_staple.FOOD_BILL_DAY_ID','=','food_bill_day.FOOD_BILL_DAY_ID')->where('FOOD_BILL_DAY_DATE','like',$year.'-05%')->sum('FOOD_INDEX_STAPLE_PICE');
        $m6_1 = DB::table('food_bill_day')->leftjoin('food_index_staple','food_index_staple.FOOD_BILL_DAY_ID','=','food_bill_day.FOOD_BILL_DAY_ID')->where('FOOD_BILL_DAY_DATE','like',$year.'-06%')->sum('FOOD_INDEX_STAPLE_PICE');
        $m7_1 = DB::table('food_bill_day')->leftjoin('food_index_staple','food_index_staple.FOOD_BILL_DAY_ID','=','food_bill_day.FOOD_BILL_DAY_ID')->where('FOOD_BILL_DAY_DATE','like',$year.'-07%')->sum('FOOD_INDEX_STAPLE_PICE');
        $m8_1 = DB::table('food_bill_day')->leftjoin('food_index_staple','food_index_staple.FOOD_BILL_DAY_ID','=','food_bill_day.FOOD_BILL_DAY_ID')->where('FOOD_BILL_DAY_DATE','like',$year.'-08%')->sum('FOOD_INDEX_STAPLE_PICE');
        $m9_1 = DB::table('food_bill_day')->leftjoin('food_index_staple','food_index_staple.FOOD_BILL_DAY_ID','=','food_bill_day.FOOD_BILL_DAY_ID')->where('FOOD_BILL_DAY_DATE','like',$year.'-09%')->sum('FOOD_INDEX_STAPLE_PICE');
        $m10_1 = DB::table('food_bill_day')->leftjoin('food_index_staple','food_index_staple.FOOD_BILL_DAY_ID','=','food_bill_day.FOOD_BILL_DAY_ID')->where('FOOD_BILL_DAY_DATE','like',$year.'-10%')->sum('FOOD_INDEX_STAPLE_PICE');
        $m11_1 = DB::table('food_bill_day')->leftjoin('food_index_staple','food_index_staple.FOOD_BILL_DAY_ID','=','food_bill_day.FOOD_BILL_DAY_ID')->where('FOOD_BILL_DAY_DATE','like',$year.'-11%')->sum('FOOD_INDEX_STAPLE_PICE');
        $m12_1 = DB::table('food_bill_day')->leftjoin('food_index_staple','food_index_staple.FOOD_BILL_DAY_ID','=','food_bill_day.FOOD_BILL_DAY_ID')->where('FOOD_BILL_DAY_DATE','like',$year.'-12%')->sum('FOOD_INDEX_STAPLE_PICE');


          
        $m1_11 = DB::table('food_bill_day')->leftjoin('food_index_staple','food_index_staple.FOOD_BILL_DAY_ID','=','food_bill_day.FOOD_BILL_DAY_ID')->leftjoin('food_menu_staple','food_menu_staple.FOOD_MENU_STAPLE_ID','=','food_index_staple.FOOD_INDEX_STAPLE_SUPID')->where('FOOD_MENU_STAPLE_TYPE','=','1')->where('FOOD_BILL_DAY_DATE','like',$year.'-01%')->sum('FOOD_INDEX_STAPLE_PICE');
        $m2_11 = DB::table('food_bill_day')->leftjoin('food_index_staple','food_index_staple.FOOD_BILL_DAY_ID','=','food_bill_day.FOOD_BILL_DAY_ID')->leftjoin('food_menu_staple','food_menu_staple.FOOD_MENU_STAPLE_ID','=','food_index_staple.FOOD_INDEX_STAPLE_SUPID')->where('FOOD_MENU_STAPLE_TYPE','=','1')->where('FOOD_BILL_DAY_DATE','like',$year.'-02%')->sum('FOOD_INDEX_STAPLE_PICE');
        $m3_11 = DB::table('food_bill_day')->leftjoin('food_index_staple','food_index_staple.FOOD_BILL_DAY_ID','=','food_bill_day.FOOD_BILL_DAY_ID')->leftjoin('food_menu_staple','food_menu_staple.FOOD_MENU_STAPLE_ID','=','food_index_staple.FOOD_INDEX_STAPLE_SUPID')->where('FOOD_MENU_STAPLE_TYPE','=','1')->where('FOOD_BILL_DAY_DATE','like',$year.'-03%')->sum('FOOD_INDEX_STAPLE_PICE');
        $m4_11 = DB::table('food_bill_day')->leftjoin('food_index_staple','food_index_staple.FOOD_BILL_DAY_ID','=','food_bill_day.FOOD_BILL_DAY_ID')->leftjoin('food_menu_staple','food_menu_staple.FOOD_MENU_STAPLE_ID','=','food_index_staple.FOOD_INDEX_STAPLE_SUPID')->where('FOOD_MENU_STAPLE_TYPE','=','1')->where('FOOD_BILL_DAY_DATE','like',$year.'-04%')->sum('FOOD_INDEX_STAPLE_PICE');
        $m5_11 = DB::table('food_bill_day')->leftjoin('food_index_staple','food_index_staple.FOOD_BILL_DAY_ID','=','food_bill_day.FOOD_BILL_DAY_ID')->leftjoin('food_menu_staple','food_menu_staple.FOOD_MENU_STAPLE_ID','=','food_index_staple.FOOD_INDEX_STAPLE_SUPID')->where('FOOD_MENU_STAPLE_TYPE','=','1')->where('FOOD_BILL_DAY_DATE','like',$year.'-05%')->sum('FOOD_INDEX_STAPLE_PICE');
        $m6_11 = DB::table('food_bill_day')->leftjoin('food_index_staple','food_index_staple.FOOD_BILL_DAY_ID','=','food_bill_day.FOOD_BILL_DAY_ID')->leftjoin('food_menu_staple','food_menu_staple.FOOD_MENU_STAPLE_ID','=','food_index_staple.FOOD_INDEX_STAPLE_SUPID')->where('FOOD_MENU_STAPLE_TYPE','=','1')->where('FOOD_BILL_DAY_DATE','like',$year.'-06%')->sum('FOOD_INDEX_STAPLE_PICE');
        $m7_11 = DB::table('food_bill_day')->leftjoin('food_index_staple','food_index_staple.FOOD_BILL_DAY_ID','=','food_bill_day.FOOD_BILL_DAY_ID')->leftjoin('food_menu_staple','food_menu_staple.FOOD_MENU_STAPLE_ID','=','food_index_staple.FOOD_INDEX_STAPLE_SUPID')->where('FOOD_MENU_STAPLE_TYPE','=','1')->where('FOOD_BILL_DAY_DATE','like',$year.'-07%')->sum('FOOD_INDEX_STAPLE_PICE');
        $m8_11 = DB::table('food_bill_day')->leftjoin('food_index_staple','food_index_staple.FOOD_BILL_DAY_ID','=','food_bill_day.FOOD_BILL_DAY_ID')->leftjoin('food_menu_staple','food_menu_staple.FOOD_MENU_STAPLE_ID','=','food_index_staple.FOOD_INDEX_STAPLE_SUPID')->where('FOOD_MENU_STAPLE_TYPE','=','1')->where('FOOD_BILL_DAY_DATE','like',$year.'-08%')->sum('FOOD_INDEX_STAPLE_PICE');
        $m9_11 = DB::table('food_bill_day')->leftjoin('food_index_staple','food_index_staple.FOOD_BILL_DAY_ID','=','food_bill_day.FOOD_BILL_DAY_ID')->leftjoin('food_menu_staple','food_menu_staple.FOOD_MENU_STAPLE_ID','=','food_index_staple.FOOD_INDEX_STAPLE_SUPID')->where('FOOD_MENU_STAPLE_TYPE','=','1')->where('FOOD_BILL_DAY_DATE','like',$year.'-09%')->sum('FOOD_INDEX_STAPLE_PICE');
        $m10_11 = DB::table('food_bill_day')->leftjoin('food_index_staple','food_index_staple.FOOD_BILL_DAY_ID','=','food_bill_day.FOOD_BILL_DAY_ID')->leftjoin('food_menu_staple','food_menu_staple.FOOD_MENU_STAPLE_ID','=','food_index_staple.FOOD_INDEX_STAPLE_SUPID')->where('FOOD_MENU_STAPLE_TYPE','=','1')->where('FOOD_BILL_DAY_DATE','like',$year.'-10%')->sum('FOOD_INDEX_STAPLE_PICE');
        $m11_11 = DB::table('food_bill_day')->leftjoin('food_index_staple','food_index_staple.FOOD_BILL_DAY_ID','=','food_bill_day.FOOD_BILL_DAY_ID')->leftjoin('food_menu_staple','food_menu_staple.FOOD_MENU_STAPLE_ID','=','food_index_staple.FOOD_INDEX_STAPLE_SUPID')->where('FOOD_MENU_STAPLE_TYPE','=','1')->where('FOOD_BILL_DAY_DATE','like',$year.'-11%')->sum('FOOD_INDEX_STAPLE_PICE');
        $m12_11 = DB::table('food_bill_day')->leftjoin('food_index_staple','food_index_staple.FOOD_BILL_DAY_ID','=','food_bill_day.FOOD_BILL_DAY_ID')->leftjoin('food_menu_staple','food_menu_staple.FOOD_MENU_STAPLE_ID','=','food_index_staple.FOOD_INDEX_STAPLE_SUPID')->where('FOOD_MENU_STAPLE_TYPE','=','1')->where('FOOD_BILL_DAY_DATE','like',$year.'-12%')->sum('FOOD_INDEX_STAPLE_PICE');


        
        $m1_12 = DB::table('food_bill_day')->leftjoin('food_index_staple','food_index_staple.FOOD_BILL_DAY_ID','=','food_bill_day.FOOD_BILL_DAY_ID')->leftjoin('food_menu_staple','food_menu_staple.FOOD_MENU_STAPLE_ID','=','food_index_staple.FOOD_INDEX_STAPLE_SUPID')->where('FOOD_MENU_STAPLE_TYPE','=','2')->where('FOOD_BILL_DAY_DATE','like',$year.'-01%')->sum('FOOD_INDEX_STAPLE_PICE');
        $m2_12 = DB::table('food_bill_day')->leftjoin('food_index_staple','food_index_staple.FOOD_BILL_DAY_ID','=','food_bill_day.FOOD_BILL_DAY_ID')->leftjoin('food_menu_staple','food_menu_staple.FOOD_MENU_STAPLE_ID','=','food_index_staple.FOOD_INDEX_STAPLE_SUPID')->where('FOOD_MENU_STAPLE_TYPE','=','2')->where('FOOD_BILL_DAY_DATE','like',$year.'-02%')->sum('FOOD_INDEX_STAPLE_PICE');
        $m3_12 = DB::table('food_bill_day')->leftjoin('food_index_staple','food_index_staple.FOOD_BILL_DAY_ID','=','food_bill_day.FOOD_BILL_DAY_ID')->leftjoin('food_menu_staple','food_menu_staple.FOOD_MENU_STAPLE_ID','=','food_index_staple.FOOD_INDEX_STAPLE_SUPID')->where('FOOD_MENU_STAPLE_TYPE','=','2')->where('FOOD_BILL_DAY_DATE','like',$year.'-03%')->sum('FOOD_INDEX_STAPLE_PICE');
        $m4_12 = DB::table('food_bill_day')->leftjoin('food_index_staple','food_index_staple.FOOD_BILL_DAY_ID','=','food_bill_day.FOOD_BILL_DAY_ID')->leftjoin('food_menu_staple','food_menu_staple.FOOD_MENU_STAPLE_ID','=','food_index_staple.FOOD_INDEX_STAPLE_SUPID')->where('FOOD_MENU_STAPLE_TYPE','=','2')->where('FOOD_BILL_DAY_DATE','like',$year.'-04%')->sum('FOOD_INDEX_STAPLE_PICE');
        $m5_12 = DB::table('food_bill_day')->leftjoin('food_index_staple','food_index_staple.FOOD_BILL_DAY_ID','=','food_bill_day.FOOD_BILL_DAY_ID')->leftjoin('food_menu_staple','food_menu_staple.FOOD_MENU_STAPLE_ID','=','food_index_staple.FOOD_INDEX_STAPLE_SUPID')->where('FOOD_MENU_STAPLE_TYPE','=','2')->where('FOOD_BILL_DAY_DATE','like',$year.'-05%')->sum('FOOD_INDEX_STAPLE_PICE');
        $m6_12 = DB::table('food_bill_day')->leftjoin('food_index_staple','food_index_staple.FOOD_BILL_DAY_ID','=','food_bill_day.FOOD_BILL_DAY_ID')->leftjoin('food_menu_staple','food_menu_staple.FOOD_MENU_STAPLE_ID','=','food_index_staple.FOOD_INDEX_STAPLE_SUPID')->where('FOOD_MENU_STAPLE_TYPE','=','2')->where('FOOD_BILL_DAY_DATE','like',$year.'-06%')->sum('FOOD_INDEX_STAPLE_PICE');
        $m7_12 = DB::table('food_bill_day')->leftjoin('food_index_staple','food_index_staple.FOOD_BILL_DAY_ID','=','food_bill_day.FOOD_BILL_DAY_ID')->leftjoin('food_menu_staple','food_menu_staple.FOOD_MENU_STAPLE_ID','=','food_index_staple.FOOD_INDEX_STAPLE_SUPID')->where('FOOD_MENU_STAPLE_TYPE','=','2')->where('FOOD_BILL_DAY_DATE','like',$year.'-07%')->sum('FOOD_INDEX_STAPLE_PICE');
        $m8_12 = DB::table('food_bill_day')->leftjoin('food_index_staple','food_index_staple.FOOD_BILL_DAY_ID','=','food_bill_day.FOOD_BILL_DAY_ID')->leftjoin('food_menu_staple','food_menu_staple.FOOD_MENU_STAPLE_ID','=','food_index_staple.FOOD_INDEX_STAPLE_SUPID')->where('FOOD_MENU_STAPLE_TYPE','=','2')->where('FOOD_BILL_DAY_DATE','like',$year.'-08%')->sum('FOOD_INDEX_STAPLE_PICE');
        $m9_12 = DB::table('food_bill_day')->leftjoin('food_index_staple','food_index_staple.FOOD_BILL_DAY_ID','=','food_bill_day.FOOD_BILL_DAY_ID')->leftjoin('food_menu_staple','food_menu_staple.FOOD_MENU_STAPLE_ID','=','food_index_staple.FOOD_INDEX_STAPLE_SUPID')->where('FOOD_MENU_STAPLE_TYPE','=','2')->where('FOOD_BILL_DAY_DATE','like',$year.'-09%')->sum('FOOD_INDEX_STAPLE_PICE');
        $m10_12 = DB::table('food_bill_day')->leftjoin('food_index_staple','food_index_staple.FOOD_BILL_DAY_ID','=','food_bill_day.FOOD_BILL_DAY_ID')->leftjoin('food_menu_staple','food_menu_staple.FOOD_MENU_STAPLE_ID','=','food_index_staple.FOOD_INDEX_STAPLE_SUPID')->where('FOOD_MENU_STAPLE_TYPE','=','2')->where('FOOD_BILL_DAY_DATE','like',$year.'-10%')->sum('FOOD_INDEX_STAPLE_PICE');
        $m11_12 = DB::table('food_bill_day')->leftjoin('food_index_staple','food_index_staple.FOOD_BILL_DAY_ID','=','food_bill_day.FOOD_BILL_DAY_ID')->leftjoin('food_menu_staple','food_menu_staple.FOOD_MENU_STAPLE_ID','=','food_index_staple.FOOD_INDEX_STAPLE_SUPID')->where('FOOD_MENU_STAPLE_TYPE','=','2')->where('FOOD_BILL_DAY_DATE','like',$year.'-11%')->sum('FOOD_INDEX_STAPLE_PICE');
        $m12_12 = DB::table('food_bill_day')->leftjoin('food_index_staple','food_index_staple.FOOD_BILL_DAY_ID','=','food_bill_day.FOOD_BILL_DAY_ID')->leftjoin('food_menu_staple','food_menu_staple.FOOD_MENU_STAPLE_ID','=','food_index_staple.FOOD_INDEX_STAPLE_SUPID')->where('FOOD_MENU_STAPLE_TYPE','=','2')->where('FOOD_BILL_DAY_DATE','like',$year.'-12%')->sum('FOOD_INDEX_STAPLE_PICE');



        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        $year_id = $year+543;
    
        return view('manager_food.dashboard_food',[
            'amount_1' => $amount_1,
            'amount_2' => $amount_2,
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
            'm1_11' => $m1_11,
            'm2_11' => $m2_11,
            'm3_11' => $m3_11,
            'm4_11' => $m4_11,
            'm5_11' => $m5_11,
            'm6_11' => $m6_11,
            'm7_11' => $m7_11,
            'm8_11' => $m8_11,
            'm9_11' => $m9_11,
            'm10_11' => $m10_11,
            'm11_11' => $m11_11,
            'm12_11' => $m12_11,
            'm1_12' => $m1_12,
            'm2_12' => $m2_12,
            'm3_12' => $m3_12,
            'm4_12' => $m4_12,
            'm5_12' => $m5_12,
            'm6_12' => $m6_12,
            'm7_12' => $m7_12,
            'm8_12' => $m8_12,
            'm9_12' => $m9_12,
            'm10_12' => $m10_12,
            'm11_12' => $m11_12,
            'm12_12' => $m12_12,
            'budgets' =>  $budget,
            'year_id'=>$year_id 
            ]);
    }



    public function infofoodmenu(Request $request)
    {
        if($request->method() === 'POST'){
            $search     = $request->search;
            $data_search = json_encode_u([
                'search' => $search,
            ]);
            Cookie::queue('data_search', $data_search, 120,$request->server('REQUEST_URI'));
        }elseif(!empty(Cookie::get('data_search'))){
            $data_search    = json_decode(Cookie::get('data_search'));
            $search     = $data_search->search;
        }else{
            $search     = '';
        }
        $infofoodmenu = DB::table('food_menu')
        ->leftjoin('food_type','food_type.FOOD_TYPE_ID','=','food_menu.FOOD_MENU_TYPE')
        ->where(function($q) use ($search){
            $q->where('FOOD_MENU_NAME','like','%'.$search.'%');
            $q->orwhere('FOOD_MENU_REMARK','like','%'.$search.'%');
       })
        ->get();

        return view('manager_food.infofoodmenu',[
            'search'=> $search,
            'infofoodmenus'=>$infofoodmenu, 
        ]);
    }

    public function infofoodmenusearch(Request $request)
    {
    
        $search = $request->search;

        $infofoodmenu = DB::table('food_menu')
        ->leftjoin('food_type','food_type.FOOD_TYPE_ID','=','food_menu.FOOD_MENU_TYPE')
        ->where(function($q) use ($search){
            $q->where('FOOD_MENU_NAME','like','%'.$search.'%');
            $q->orwhere('FOOD_MENU_REMARK','like','%'.$search.'%');
       })
        ->get();

    return view('manager_food.infofoodmenu',[
            'search'=> $search,
            'infofoodmenus'=>$infofoodmenu, 
        ]);
    }



    public function infofoodmenu_add()
    {       
        
    $infosup = DB::table('supplies')->where('SUP_TYPE_ID','=','18')->get();

    $infotype = DB::table('food_type')->get();
    $infounit = DB::table('food_unit')->get();

        return view('manager_food.infofoodmenu_add',[
            'infosups'=>$infosup,
            'infotypes'=>$infotype,
            'infounits'=>$infounit
        ]);
    }


    public function infofoodmenu_save(Request $request)
    {       
        
        $addinfomenu = new Foodmenu(); 
        $addinfomenu->FOOD_MENU_NAME = $request->FOOD_MENU_NAME;
        $addinfomenu->FOOD_MENU_SAVE_DATE = $request->FOOD_MENU_SAVE_DATE;
        $addinfomenu->FOOD_MENU_REMARK = $request->FOOD_MENU_REMARK;
        $addinfomenu->FOOD_MENU_TYPE = $request->FOOD_MENU_TYPE;
        if($request->hasFile('FOOD_IMG')){           
            $file = $request->file('FOOD_IMG');  
            $contents = $file->openFile()->fread($file->getSize());
            $addinfomenu->FOOD_IMG = $contents;               
        }
        $addinfomenu->save();
    
    
        $Foodmenuid = Foodmenu::max('FOOD_MENU_ID');
    
        if($request->FOOD_MENU_STAPLE_ID[0] != '' || $request->FOOD_MENU_STAPLE_ID[0] != null){
            $FOOD_MENU_STAPLE_ID = $request->FOOD_MENU_STAPLE_ID;
            $FOOD_MENU_STAPLE_AMOUNT = $request->FOOD_MENU_STAPLE_AMOUNT;
            $FOOD_MENU_UNIT_ID = $request->FOOD_MENU_UNIT_ID;
            $FOOD_MENU_STAPLE_TYPE = $request->FOOD_MENU_STAPLE_TYPE;
            $number =count($FOOD_MENU_STAPLE_ID);
            $count = 0;
            for($count = 0; $count < $number; $count++)
            {  
            
               $add = new Foodmenustaple();
               $add->FOOD_MENU_ID = $Foodmenuid;
               $add->FOOD_MENU_STAPLE_ID = $FOOD_MENU_STAPLE_ID[$count];
               $add->FOOD_MENU_STAPLE_AMOUNT = $FOOD_MENU_STAPLE_AMOUNT[$count];
               $add->FOOD_MENU_UNIT_ID = $FOOD_MENU_UNIT_ID[$count];
               $add->FOOD_MENU_STAPLE_TYPE = $request->FOOD_MENU_STAPLE_TYPE[$count];
               $add->save(); 

            }
        }


        if($request->FOOD_MENU_DETAIL[0] != '' || $request->FOOD_MENU_DETAIL[0] != null){
            $FOOD_MENU_DETAIL = $request->FOOD_MENU_DETAIL;
       
            $number =count($FOOD_MENU_DETAIL);
            $count = 0;
            for($count = 0; $count < $number; $count++)
            {  
          
               $add = new Foodmenudetail();
               $add->FOOD_MENU_ID = $Foodmenuid;
               $add->FOOD_MENU_DETAIL = $FOOD_MENU_DETAIL[$count];
               $add->save(); 

            }
        }


    
        
        return redirect()->route('mfood.infofoodmenu');
       
    }


    public function infofoodmenu_edit(Request $request,$idref)
    {

        $infosup = DB::table('supplies')->where('SUP_TYPE_ID','=','18')->get();
        $infotype = DB::table('food_type')->get();
        $infounit = DB::table('food_unit')->get();


        $foodmenu = DB::table('food_menu')->where('FOOD_MENU_ID','=',$idref)->first();
        $foodmenudetail = DB::table('food_menu_detail')->where('FOOD_MENU_ID','=',$idref)->get();
        $foodmenustaple = DB::table('food_menu_staple')->where('FOOD_MENU_ID','=',$idref)->get();
              
        return view('manager_food.infofoodmenu_edit',[
            'infosups'=>$infosup,
            'foodmenu'=>$foodmenu,
            'foodmenudetails'=>$foodmenudetail,
            'foodmenustaples'=>$foodmenustaple,
            'infotypes'=>$infotype,
            'infounits'=>$infounit
        ]);
    }

    
    public function infofoodmenu_update(Request $request)
    {       
        $id = $request->ID;

        $addinfomenu = Foodmenu::find($id); 
        $addinfomenu->FOOD_MENU_NAME = $request->FOOD_MENU_NAME;
        $addinfomenu->FOOD_MENU_SAVE_DATE = $request->FOOD_MENU_SAVE_DATE;
        $addinfomenu->FOOD_MENU_REMARK = $request->FOOD_MENU_REMARK;
        $addinfomenu->FOOD_MENU_TYPE = $request->FOOD_MENU_TYPE;
        if($request->hasFile('FOOD_IMG')){           
            $file = $request->file('FOOD_IMG');  
            $contents = $file->openFile()->fread($file->getSize());
            $addinfomenu->FOOD_IMG = $contents;               
        }
        $addinfomenu->save();
    
    
        $Foodmenuid = $id ;

        Foodmenustaple::where('FOOD_MENU_ID','=',$id)->delete(); 
        Foodmenudetail::where('FOOD_MENU_ID','=',$id)->delete(); 

    
        if($request->FOOD_MENU_STAPLE_ID != '' || $request->FOOD_MENU_STAPLE_ID != null){
            $FOOD_MENU_STAPLE_ID = $request->FOOD_MENU_STAPLE_ID;
            $FOOD_MENU_STAPLE_AMOUNT = $request->FOOD_MENU_STAPLE_AMOUNT;
            $FOOD_MENU_UNIT_ID = $request->FOOD_MENU_UNIT_ID;
            $FOOD_MENU_STAPLE_TYPE = $request->FOOD_MENU_STAPLE_TYPE;
            $number =count($FOOD_MENU_STAPLE_ID);
            $count = 0;
            for($count = 0; $count < $number; $count++)
            {  
            
               $add = new Foodmenustaple();
               $add->FOOD_MENU_ID = $Foodmenuid;
               $add->FOOD_MENU_STAPLE_ID = $FOOD_MENU_STAPLE_ID[$count];
               $add->FOOD_MENU_STAPLE_AMOUNT = $FOOD_MENU_STAPLE_AMOUNT[$count];
               $add->FOOD_MENU_UNIT_ID = $FOOD_MENU_UNIT_ID[$count];
               $add->FOOD_MENU_STAPLE_TYPE = $FOOD_MENU_STAPLE_TYPE[$count];;
        
               $add->save(); 

            }
        }


        if($request->FOOD_MENU_DETAIL != '' || $request->FOOD_MENU_DETAIL != null){
            $FOOD_MENU_DETAIL = $request->FOOD_MENU_DETAIL;
       
            $number =count($FOOD_MENU_DETAIL);
            $count = 0;
            for($count = 0; $count < $number; $count++)
            {  
          
               $add = new Foodmenudetail();
               $add->FOOD_MENU_ID = $Foodmenuid;
               $add->FOOD_MENU_DETAIL = $FOOD_MENU_DETAIL[$count];
               $add->save(); 

            }
        }

        
        return redirect()->route('mfood.infofoodmenu');
       
    }

//======================================================//
public function infofood(Request $request)
{
    if($request->method() === 'POST'){
        $search     = $request->get('search');
        $data_search = json_encode_u([
            'search' => $search,
        ]);
        Cookie::queue('data_search', $data_search, 120,$request->server('REQUEST_URI'));
    }elseif(!empty(Cookie::get('data_search'))){
        $data_search    = json_decode(Cookie::get('data_search'));
        $search     = $data_search->search;
    }else{
        $search     = '';
    }
    
    $infosup= Supplies::select('supplies.ID','supplies.ACTIVE','SUP_FSN_NUM','SUP_NAME','SUP_TYPE_KIND_NAME','SUP_TYPE_NAME','SUP_PROP','TPU_NUMBER','CONTINUE_PRICE_NAME')
    ->leftJoin('supplies_type','supplies.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
    ->leftJoin('supplies_continue','supplies.CONTINUE_PRICE_ID','=','supplies_continue.CONTINUE_PRICE_ID')
    ->leftJoin('supplies_type_kind','supplies.SUP_TYPE_KIND_ID','=','supplies_type_kind.SUP_TYPE_KIND_ID')
    ->where('supplies.SUP_TYPE_ID','=','18')
    ->where(function($q) use ($search){
        $q->where('SUP_FSN_NUM','like','%'.$search.'%');
        $q->orwhere('SUP_NAME','like','%'.$search.'%');
        $q->orwhere('SUP_PROP','like','%'.$search.'%');
        })
    ->orderBy('supplies.ID', 'desc') 
    ->get();
    return view('manager_food.infofood',[
        'search'=> $search,
        'infosups'=>$infosup, 
    ]);
}

public function infofoodsearch(Request $request)
{


    $search = $request->get('search');
  

    if($search==''){
        $search="";
    }

  

    $infosup= Supplies::select('supplies.ID','supplies.ACTIVE','SUP_FSN_NUM','SUP_NAME','SUP_TYPE_KIND_NAME','SUP_TYPE_NAME','SUP_PROP','TPU_NUMBER','CONTINUE_PRICE_NAME')
    ->leftJoin('supplies_type','supplies.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
    ->leftJoin('supplies_continue','supplies.CONTINUE_PRICE_ID','=','supplies_continue.CONTINUE_PRICE_ID')
    ->leftJoin('supplies_type_kind','supplies.SUP_TYPE_KIND_ID','=','supplies_type_kind.SUP_TYPE_KIND_ID')
    ->where('supplies.SUP_TYPE_ID','=','18')
    ->where(function($q) use ($search){
        $q->where('SUP_FSN_NUM','like','%'.$search.'%');
        $q->orwhere('SUP_NAME','like','%'.$search.'%');
        $q->orwhere('SUP_PROP','like','%'.$search.'%');
        })
    ->orderBy('supplies.ID', 'desc') 
    ->get();




return view('manager_food.infofood',[
        'search'=> $search,
        'infosups'=>$infosup, 
    ]);
}


public function infofood_add()
{ 
    
    
  $countcheck = DB::table('supplies')->where('SUP_FSN_NUM','like','18-%')->count();

  if($countcheck == 0){
      $lnumber = '00001';
  }else{
    
    $maxnumber = DB::table('supplies')->where('SUP_FSN_NUM','like','18-%')->max('ID');  
    $refmax = DB::table('supplies')->where('ID','=',$maxnumber)->first();  


 
        $maxref = substr($refmax->SUP_FSN_NUM, -4)+1;
    

    $lnumber = str_pad($maxref, 5, "0", STR_PAD_LEFT);
  }


        $number = '18-'.$lnumber;


        

        $typedetail = 'parcel';
        $detail = '1';

        $suppliestypekind = DB::table('supplies_type_kind')->where('SUP_TYPE_MASTER_ID','=',$detail)->get();
        $suppliestype = DB::table('supplies_type')->where('SUP_TYPE_MASTER_ID','=',$detail)->get();
        $suppliestypemaster = DB::table('supplies_type_master')->where('SUP_TYPE_MASTER_ID','=',$detail)->get();


        $suppliesprop = DB::table('supplies_prop')->get();

        $suppliesunit = DB::table('supplies_unit')->get();;


    return view('manager_food.infofood_add',[
        'number' =>  $number,
        'suppliestypekinds' => $suppliestypekind,
        'suppliestypes' => $suppliestype,
        'suppliestypemasters' => $suppliestypemaster,
        'typedetail' => $typedetail,
        'suppliesprops' => $suppliesprop,
        'suppliesunits' => $suppliesunit,
    ]);
}

public function infofood_save(Request $request) 
{

    $typedetail = $request->typedetail;
      
    $count= DB::table('supplies')
    ->where('supplies.SUP_FSN_NUM',$request->SUP_FSN_NUM) 
    ->count();

 if($count == 0){
 
    $addinfosup = new Supplies(); 
    $addinfosup->SUP_FSN_NUM = $request->SUP_FSN_NUM;
    $addinfosup->SUP_TYPE_KIND_ID = $request->SUP_TYPE_KIND_ID;
    $addinfosup->SUP_NAME = $request->SUP_NAME;
    $addinfosup->CONTINUE_PRICE_ID = $request->CONTINUE_PRICE_ID;
    $addinfosup->SUP_PROP = $request->SUP_PROP;
    $addinfosup->SUP_TYPE_ID = $request->SUP_TYPE_ID;
    $addinfosup->SUP_TYPE_MASTER_ID = $request->SUP_TYPE_MASTER_ID;
    $addinfosup->CONTENT = $request->CONTENT;
    $addinfosup->TPU_NUMBER = $request->EGP_NUMBER;
    $addinfosup->MIN = $request->MIN;
    $addinfosup->MAX = $request->MAX;

    if($request->hasFile('picture')){
        
        $file = $request->file('picture');  
        $contents = $file->openFile()->fread($file->getSize());
        $addinfosup->IMG = $contents;   
      
    }

    $addinfosup->save();


   
    $SUP_ID = Supplies::max('ID');


    if($request->SUP_UNIT_ID0 !== null ){
        $add = new Suppliesunitref();
        $add->SUP_ID = $SUP_ID;
        $add->SUP_UNIT_ID = $request->SUP_UNIT_ID0;
        $SUPUNITNAME = DB::table('supplies_unit')->where('SUP_UNIT_ID','=',$request->SUP_UNIT_ID0)->first();
        $add->SUP_UNIT_NAME = $SUPUNITNAME->SUP_UNIT_NAME;
        $add->SUP_TOTAL = $request->SUP_TOTAL0; 
        $add->save(); 
    }

    if($request->SUP_UNIT_ID1 !== null ){   

        $add = new Suppliesunitref();
        $add->SUP_ID = $SUP_ID;
        $add->SUP_UNIT_ID = $request->SUP_UNIT_ID1;
        $SUPUNITNAME = DB::table('supplies_unit')->where('SUP_UNIT_ID','=',$request->SUP_UNIT_ID1)->first();
        $add->SUP_UNIT_NAME = $SUPUNITNAME->SUP_UNIT_NAME;
        $add->SUP_TOTAL = $request->SUP_TOTAL1; 
        $add->save(); 
    }

}

    $typedetail = $request->typedetail;

    return redirect()->route('mfood.infofood');
}


public function infofood_edit(Request $request,$idref)
{
         $typedetail = 'parcel';
         $detail = '1';


    $suppliestypekind = DB::table('supplies_type_kind')->where('SUP_TYPE_MASTER_ID','=',$detail)->get();
    $suppliestype = DB::table('supplies_type')->where('SUP_TYPE_MASTER_ID','=',$detail)->get();
    $suppliestypemaster = DB::table('supplies_type_master')->where('SUP_TYPE_MASTER_ID','=',$detail)->get();

    $infosupplie = DB::table('supplies')->where('ID','=',$idref)->first();

    $suppliesprop = DB::table('supplies_prop')->get();

    $countSuppliesunitref = Suppliesunitref::where('SUP_ID','=',$idref)->get();

    $infoSuppliesunitref = Suppliesunitref::where('SUP_ID','=',$idref)->get();

    $suppliesunit = DB::table('supplies_unit')->get();

    //------unit

    $infounitref_1 = Suppliesunitref::where('SUP_ID','=',$idref)->where('SUP_TOTAL','=',1)->first();

    if($infounitref_1 == null){
        $infounitref1 = 'null';
    }else{
        $infounitref1 = $infounitref_1;
    }
   
   
    $infounitref_2 = Suppliesunitref::where('SUP_ID','=',$idref)->where('SUP_TOTAL','!=',1)->first();

    if($infounitref_2 == null){
        $infounitref2 = 'null';
    }else{
        $infounitref2 = $infounitref_2;
    }

    $infosupdetail = DB::table('supplies')->where('ID','=',$idref)->first();  

    $suppliesunitref = DB::table('supplies_unit_ref')->where('SUP_ID','=',$idref)->get();  
    

    return view('manager_food.infofood_edit',[
        'infosupdetail'=>$infosupdetail,
        'suppliesunitrefs'=>$suppliesunitref,
        'suppliestypekinds' => $suppliestypekind,
        'suppliestypes' => $suppliestype,
        'suppliestypemasters' => $suppliestypemaster,
        'infosupplie' => $infosupplie,
        'typedetail' => $typedetail,
        'suppliesprops' => $suppliesprop,
        'infoSuppliesunitrefs' => $infoSuppliesunitref,
        'countSuppliesunitref' => $countSuppliesunitref,
        'suppliesunits' => $suppliesunit,
        'infounitref1' => $infounitref1,
        'infounitref2' => $infounitref2,
    ]);
}

public function infofood_update(Request $request) 
{
 
    $id = $request->ID;

    $addinfosup = Supplies::find($id);     
    $addinfosup->SUP_FSN_NUM = $request->SUP_FSN_NUM;
    $addinfosup->SUP_TYPE_KIND_ID = $request->SUP_TYPE_KIND_ID;
    $addinfosup->SUP_NAME = $request->SUP_NAME;
    $addinfosup->CONTINUE_PRICE_ID = $request->CONTINUE_PRICE_ID;
    $addinfosup->SUP_PROP = $request->SUP_PROP;
    $addinfosup->SUP_TYPE_ID = $request->SUP_TYPE_ID;
    $addinfosup->SUP_TYPE_MASTER_ID = $request->SUP_TYPE_MASTER_ID;
    $addinfosup->CONTENT = $request->CONTENT;
    $addinfosup->TPU_NUMBER = $request->EGP_NUMBER;
    $addinfosup->MIN = $request->MIN;
    $addinfosup->MAX = $request->MAX;
    $addinfosup->save();


           
    $SUP_ID =  $id;
               
    if($request->checkid1!== 'null'){

        $idunit = $request->checkid1; 
        
        $add = Suppliesunitref::find($idunit);
        $add->SUP_ID = $SUP_ID;
        $add->SUP_UNIT_ID = $request->SUP_UNIT_ID0;
        $SUPUNITNAME = DB::table('supplies_unit')->where('SUP_UNIT_ID','=',$request->SUP_UNIT_ID0)->first();
        $add->SUP_UNIT_NAME = $SUPUNITNAME->SUP_UNIT_NAME;
        $add->SUP_TOTAL = $request->SUP_TOTAL0; 
        $add->save(); 

    }elseif($request->SUP_UNIT_ID0 !== null ){
        $add = new Suppliesunitref();
        $add->SUP_ID = $SUP_ID;
        $add->SUP_UNIT_ID = $request->SUP_UNIT_ID0;
        $SUPUNITNAME = DB::table('supplies_unit')->where('SUP_UNIT_ID','=',$request->SUP_UNIT_ID0)->first();
        $add->SUP_UNIT_NAME = $SUPUNITNAME->SUP_UNIT_NAME;
        $add->SUP_TOTAL = $request->SUP_TOTAL0; 
        $add->save(); 
    }

 
    if($request->checkid2 !== 'null'){
        $idunit = $request->checkid2; 

   
        if($request->SUP_UNIT_ID1 !== '' && $request->SUP_UNIT_ID1 !== null){
       
        $add = Suppliesunitref::find($idunit);
        $add->SUP_ID = $SUP_ID;
        $add->SUP_UNIT_ID = $request->SUP_UNIT_ID1;
        $SUPUNITNAME = DB::table('supplies_unit')->where('SUP_UNIT_ID','=',$request->SUP_UNIT_ID1)->first();
        $add->SUP_UNIT_NAME = $SUPUNITNAME->SUP_UNIT_NAME;
        $add->SUP_TOTAL = $request->SUP_TOTAL1;       
        $add->save(); 
        }else{

            $add = Suppliesunitref::find($idunit);
            $add->SUP_ID = $SUP_ID;
            $add->SUP_UNIT_ID = '';
            $add->SUP_UNIT_NAME = '';
            $add->SUP_TOTAL = 0;       
            $add->save();

        }

    }elseif($request->SUP_UNIT_ID1 !== null ){

    

        $add = new Suppliesunitref();
        $add->SUP_ID = $SUP_ID;
        $add->SUP_UNIT_ID = $request->SUP_UNIT_ID1;
        $SUPUNITNAME = DB::table('supplies_unit')->where('SUP_UNIT_ID','=',$request->SUP_UNIT_ID1)->first();
        $add->SUP_UNIT_NAME = $SUPUNITNAME->SUP_UNIT_NAME;
        $add->SUP_TOTAL = $request->SUP_TOTAL1; 
        $add->save(); 
    }

$typedetail = $request->typedetail;





    return redirect()->route('mfood.infofood');
}


public function infofoodbill(Request $request)
{
    if($request->method() === 'POST'){
        $search = $request->get('search');
        $datebigin = $request->get('DATE_BIGIN');
        $dateend = $request->get('DATE_END');
        $data_search = json_encode_u([
            'search' => $search,
            'datebigin' => $datebigin,
            'dateend' => $dateend,
        ]);
        Cookie::queue('data_search', $data_search, 120,$request->server('REQUEST_URI'));
    }elseif(!empty(Cookie::get('data_search'))){
        $data_search    = json_decode(Cookie::get('data_search'));
        $search     = $data_search->search;
        $datebigin     = $data_search->datebigin;
        $dateend     = $data_search->dateend;
    }else{
        $search     = '';
        $datebigin  = date('1/m/Y');
        $dateend    = date('d/m/Y',strtotime(date('Y-m-1').' +1month -1day'));
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
    $infofoodbill = DB::table('food_bill_day')
    ->leftjoin('supplies_vendor','food_bill_day.FOOD_BILL_DAY_VENDOR','=','supplies_vendor.VENDOR_ID')
    ->where(function($q) use ($search){
        $q->where('FOOD_BILL_DAY_NUMBER','like','%'.$search.'%');
        $q->orwhere('CON_NUM','like','%'.$search.'%');
        $q->orwhere('FOOD_BILL_DAY_NAME','like','%'.$search.'%');
        })
    ->WhereBetween('FOOD_BILL_DAY_DATE',[$from.' 00:00:00',$to.' 23:59:00']) 
    ->orderBy('FOOD_BILL_DAY_DATE', 'desc')
    ->get();

    $infofoodbillsum = DB::table('food_bill_day')
    ->leftjoin('supplies_vendor','food_bill_day.FOOD_BILL_DAY_VENDOR','=','supplies_vendor.VENDOR_ID')
    ->where(function($q) use ($search){
        $q->where('FOOD_BILL_DAY_NUMBER','like','%'.$search.'%');
        $q->orwhere('CON_NUM','like','%'.$search.'%');
        $q->orwhere('FOOD_BILL_DAY_NAME','like','%'.$search.'%');
        })
    ->WhereBetween('FOOD_BILL_DAY_DATE',[$from.' 00:00:00',$to.' 23:59:00']) 
    ->orderBy('FOOD_BILL_DAY_DATE', 'desc')
    ->sum('FOOD_BILL_DAY_TOTAL');
    return  view('manager_food.infofoodbill',[
        'displaydate_bigen'=> $displaydate_bigen,
        'displaydate_end'=> $displaydate_end,
        'search'=> $search,  
        'infofoodbills'=>$infofoodbill, 
        'infofoodbillsum'=>$infofoodbillsum, 
    ]);
}




public function infofoodbillsearch(Request $request)
{
    $search = $request->get('search');
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

       $from = date($displaydate_bigen);
       $to = date($displaydate_end);   



    $infofoodbill = DB::table('food_bill_day')
    ->leftjoin('supplies_vendor','food_bill_day.FOOD_BILL_DAY_VENDOR','=','supplies_vendor.VENDOR_ID')
    ->where(function($q) use ($search){
        $q->where('FOOD_BILL_DAY_NUMBER','like','%'.$search.'%');
        $q->orwhere('CON_NUM','like','%'.$search.'%');
        $q->orwhere('FOOD_BILL_DAY_NAME','like','%'.$search.'%');
        })
    ->WhereBetween('FOOD_BILL_DAY_DATE',[$from.' 00:00:00',$to.' 23:59:00']) 
    ->orderBy('FOOD_BILL_DAY_DATE', 'desc')
    ->get();

    $infofoodbillsum = DB::table('food_bill_day')
    ->leftjoin('supplies_vendor','food_bill_day.FOOD_BILL_DAY_VENDOR','=','supplies_vendor.VENDOR_ID')
    ->where(function($q) use ($search){
        $q->where('FOOD_BILL_DAY_NUMBER','like','%'.$search.'%');
        $q->orwhere('CON_NUM','like','%'.$search.'%');
        $q->orwhere('FOOD_BILL_DAY_NAME','like','%'.$search.'%');
        })
    ->WhereBetween('FOOD_BILL_DAY_DATE',[$from.' 00:00:00',$to.' 23:59:00']) 
    ->orderBy('FOOD_BILL_DAY_DATE', 'desc')
    ->sum('FOOD_BILL_DAY_TOTAL');


    return  view('manager_food.infofoodbill',[
        'displaydate_bigen'=> $displaydate_bigen,
        'displaydate_end'=> $displaydate_end,
        'search'=> $search,  
        'infofoodbills'=>$infofoodbill, 
        'infofoodbillsum'=>$infofoodbillsum, 
    ]);

}

public function infofoodbill_add(Request $request,$id)
{   

    $infodetail = DB::table('food_bill_menu_sup')
    ->select('supplies.SUP_NAME', DB::raw('SUM(FOOD_BILL_MENU_SUP_AMOUNT) as total_sum'))
    ->leftjoin('supplies','food_bill_menu_sup.FOOD_MENU_STAPLE_ID','=','supplies.ID')
    ->where('SUP_TYPE_MASTER_ID','=','6')
    ->where('FOOD_BILL_ID','=','')
    ->groupBy('supplies.SUP_NAME')
    ->get();

    $infomenutype1 = DB::table('food_bill_menu')
    ->where('FOOD_BILL_ID','=','')
    ->where('FOOD_BILL_MENU_TYPE','=','1')
    ->get();

    $infomenutype2 = DB::table('food_bill_menu')
    ->where('FOOD_BILL_ID','=','')
    ->where('FOOD_BILL_MENU_TYPE','=','2')
    ->get();


    $infomenutype3 = DB::table('food_bill_menu')
    ->where('FOOD_BILL_ID','=','')
    ->where('FOOD_BILL_MENU_TYPE','=','3')
    ->get();

    $check = DB::table('food_bill_menu_sup')
    ->where('FOOD_BILL_ID','=','')
    ->count();

  



    $inforef = DB::table('food_bill_day')->where('FOOD_BILL_DAY_ID','=',$id)->first();


    $infofood = DB::table('food_menu')->get();    
    return view('manager_food.infofoodbill_add',[
        'infofoods'=>$infofood, 
        'infodetails'=> $infodetail, 
        'check'=> $check, 
        'inforef'=> $inforef, 
        'infomenutype1s'=>$infomenutype1, 
        'infomenutype2s'=> $infomenutype2,
        'infomenutype3s'=> $infomenutype3,
 
    ]);
}


public function infofoodbill_process(Request $request)
{  
    
   $SUBMIT = $request->SUBMIT;
   $FOODBILL_DAY_ID = $request->FOOD_BILL_DAY_ID;

   if( $SUBMIT == 'send'){

    $infobillday = DB::table('food_bill_day')
    ->leftjoin('supplies_vendor','food_bill_day.FOOD_BILL_DAY_VENDOR','=','supplies_vendor.VENDOR_ID')
    ->where('FOOD_BILL_DAY_ID','=',$FOODBILL_DAY_ID)->first();

    $infosup = DB::table('supplies')->where('SUP_TYPE_MASTER_ID','=','6')->get();
    
    $infofood = DB::table('food_menu')->get();  
    
    $infoperson = DB::table('hrd_person')->where('HR_STATUS_ID','=',1)->get();
    
    $foodboard = DB::table('food_board')->get();
    
    $infounit = DB::table('food_unit')->get();
    

    $infodetail = DB::table('food_bill_menu_sup')
    ->select('FOOD_MENU_STAPLE_ID', DB::raw('SUM(FOOD_BILL_MENU_SUP_AMOUNT) as total_sum'))
    ->leftjoin('supplies','food_bill_menu_sup.FOOD_MENU_STAPLE_ID','=','supplies.ID')
    ->where('SUP_TYPE_MASTER_ID','=','6')
    ->where('FOOD_BILL_ID','=',$FOODBILL_DAY_ID)
    ->groupBy('FOOD_MENU_STAPLE_ID')
    ->get();

    $infomenutype1 = DB::table('food_bill_menu')
    ->where('FOOD_BILL_ID','=',$FOODBILL_DAY_ID)
    ->where('FOOD_BILL_MENU_TYPE','=','1')
    ->get();

    $infomenutype2 = DB::table('food_bill_menu')
    ->where('FOOD_BILL_ID','=',$FOODBILL_DAY_ID)
    ->where('FOOD_BILL_MENU_TYPE','=','2')
    ->get();


    $infomenutype3 = DB::table('food_bill_menu')
    ->where('FOOD_BILL_ID','=',$FOODBILL_DAY_ID)
    ->where('FOOD_BILL_MENU_TYPE','=','3')
    ->get();

    $check = DB::table('food_bill_menu_sup')
    ->where('FOOD_BILL_ID','=',$FOODBILL_DAY_ID)
    ->count();
    $checkedit = 0;
    
        return view('manager_food.infofoodbillstaple_add',[
            'infobillday'=>$infobillday,
            'infosups'=>$infosup,
            'infofoods'=>$infofood,
            'infopersons'=>$infoperson,
            'foodboards'=>$foodboard,
            'infounits'=>$infounit,
            'check'=>$check,
            'checkedit'=>$checkedit,
            'infodetails'=>$infodetail,
            'infomenutype1s'=>$infomenutype1,
            'infomenutype2s'=>$infomenutype2,
            'infomenutype3s'=>$infomenutype3
             
        ]);

   }else{
    Foodbillmenu::truncate();
    Foodbillmenusup::truncate();
 
    $FOOD_BILL_ID = $request->FOOD_BILL_DAY_ID;
    

    if($request->FOOD_BILL_MENU1 != '' || $request->FOOD_BILL_MENU1 !=null){

        $FOOD_BILL_MENU1 = $request->FOOD_BILL_MENU1;
        $FOOD_BILL_MENU_AMOUNT1 = $request->FOOD_BILL_MENU_AMOUNT1;
        $number =count($FOOD_BILL_MENU1);
        $count = 0;
        for($count = 0; $count < $number; $count++)
        {  
    
        $add = new Foodbillmenu();
        $add->FOOD_BILL_ID = $FOOD_BILL_ID;
        $add->FOOD_BILL_MENU = $FOOD_BILL_MENU1[$count];
        $add->FOOD_BILL_MENU_AMOUNT = $FOOD_BILL_MENU_AMOUNT1[$count];
        $add->FOOD_BILL_MENU_TYPE = '1';
        $add->save(); 

        
        }

    }

    
    if($request->FOOD_BILL_MENU2 != '' || $request->FOOD_BILL_MENU2 !=null){

        $FOOD_BILL_MENU2 = $request->FOOD_BILL_MENU2;
        $FOOD_BILL_MENU_AMOUNT2 = $request->FOOD_BILL_MENU_AMOUNT2;
        $number =count($FOOD_BILL_MENU2);
        $count = 0;
        for($count = 0; $count < $number; $count++)
        {  
    
        $add = new Foodbillmenu();
        $add->FOOD_BILL_ID = $FOOD_BILL_ID;
        $add->FOOD_BILL_MENU = $FOOD_BILL_MENU2[$count];
        $add->FOOD_BILL_MENU_AMOUNT = $FOOD_BILL_MENU_AMOUNT2[$count];
        $add->FOOD_BILL_MENU_TYPE = '2';
        $add->save(); 

        
        }

    }

    
    if($request->FOOD_BILL_MENU3 != '' || $request->FOOD_BILL_MENU3 !=null){

        $FOOD_BILL_MENU3 = $request->FOOD_BILL_MENU3;
        $FOOD_BILL_MENU_AMOUNT3 = $request->FOOD_BILL_MENU_AMOUNT3;
        $number =count($FOOD_BILL_MENU3);
        $count = 0;
        for($count = 0; $count < $number; $count++)
        {  
    
        $add = new Foodbillmenu();
        $add->FOOD_BILL_ID = $FOOD_BILL_ID;
        $add->FOOD_BILL_MENU = $FOOD_BILL_MENU3[$count];
        $add->FOOD_BILL_MENU_AMOUNT = $FOOD_BILL_MENU_AMOUNT3[$count];
        $add->FOOD_BILL_MENU_TYPE = '3';
        $add->save(); 

        
        }

    }

    //======ประมวลผลจำนวนวัตถุดิบ

    
   
    $infomenus = DB::table('food_bill_menu')->where('FOOD_BILL_ID','=',$FOOD_BILL_ID )->get();

    foreach ($infomenus as $infomenu) {
       
        $infomenusubs = DB::table('food_menu_staple')->where('FOOD_MENU_ID','=',$infomenu->FOOD_BILL_MENU )->get();

        foreach ($infomenusubs as $infomenusub) {
       
            $add = new Foodbillmenusup();
            $add->FOOD_BILL_ID = $infomenu->FOOD_BILL_ID;
            $add->FOOD_BILL_MENU_TYPE = $infomenu->FOOD_BILL_MENU_TYPE;
            $add->FOOD_MENU_STAPLE_ID = $infomenusub->FOOD_MENU_STAPLE_ID;
            $add->FOOD_BILL_MENU_SUP_AMOUNT = $infomenusub->FOOD_MENU_STAPLE_AMOUNT*$infomenu->FOOD_BILL_MENU_AMOUNT;
            $add->save(); 
       
       
        }
    
    }
 

    $infodetail = DB::table('food_bill_menu_sup')
    ->select('supplies.SUP_NAME', DB::raw('SUM(FOOD_BILL_MENU_SUP_AMOUNT) as total_sum'))
    ->leftjoin('supplies','food_bill_menu_sup.FOOD_MENU_STAPLE_ID','=','supplies.ID')
    ->where('SUP_TYPE_MASTER_ID','=','6')
    ->where('FOOD_BILL_ID','=',$FOOD_BILL_ID)
    ->groupBy('supplies.SUP_NAME')
    ->get();

    $infomenutype1 = DB::table('food_bill_menu')
    ->where('FOOD_BILL_ID','=',$FOOD_BILL_ID)
    ->where('FOOD_BILL_MENU_TYPE','=','1')
    ->get();

    $infomenutype2 = DB::table('food_bill_menu')
    ->where('FOOD_BILL_ID','=',$FOOD_BILL_ID)
    ->where('FOOD_BILL_MENU_TYPE','=','2')
    ->get();


    $infomenutype3 = DB::table('food_bill_menu')
    ->where('FOOD_BILL_ID','=',$FOOD_BILL_ID)
    ->where('FOOD_BILL_MENU_TYPE','=','3')
    ->get();

    $check = DB::table('food_bill_menu_sup')
    ->where('FOOD_BILL_ID','=',$FOOD_BILL_ID)
    ->count();

    $inforef = DB::table('food_bill_day')->where('FOOD_BILL_DAY_ID','=',$request->FOOD_BILL_DAY_ID)->first();

    $infofood = DB::table('food_menu')->get();    
    return view('manager_food.infofoodbill_add',[
    'infofoods'=>$infofood, 
    'infodetails'=>$infodetail,
    'check'=>$check,  
    'inforef'=> $inforef,
    'infomenutype1s'=>$infomenutype1, 
    'infomenutype2s'=>$infomenutype2,
    'infomenutype3s'=>$infomenutype3 
   ]);

    }



}

public function infofoodbill_edit(Request $request)
{
    $incra = DB::table('cradle_index')->get();  

    return view('manager_food.infofoodbill_edit',[
        'incras'=>$incra
    ]);
}

//=============================จัดการวัตถุดิบ
public function infofoodbillstaple_add (Request $request,$id)
{       
    
$infobillday = DB::table('food_bill_day')
->leftjoin('supplies_vendor','food_bill_day.FOOD_BILL_DAY_VENDOR','=','supplies_vendor.VENDOR_ID')
->where('FOOD_BILL_DAY_ID','=',$id)->first();


$infosup = DB::table('supplies')->where('SUP_TYPE_MASTER_ID','=','6')->get();

$infofood = DB::table('food_menu')->get();  

$infoperson = DB::table('hrd_person')->where('HR_STATUS_ID','=',1)->get();

$foodboard = DB::table('food_board')->get();

$infounit = DB::table('food_unit')->get();


//ข้อมูลเพื่อแก้ไข


$infodetailedit = DB::table('food_index_staple')
->where('FOOD_BILL_DAY_ID','=',$id)
->get(); 

$infomenutypeedit1 = DB::table('food_index_menu')
->where('FOOD_INDEX_MENU_TYPE','=','1')
->where('FOOD_BILL_DAY_ID','=',$id)
->get();

$infomenutypeedit2 = DB::table('food_index_menu')
->where('FOOD_INDEX_MENU_TYPE','=','2')
->where('FOOD_BILL_DAY_ID','=',$id)
->get();


$infomenutypeedit3 = DB::table('food_index_menu')
->where('FOOD_INDEX_MENU_TYPE','=','3')
->where('FOOD_BILL_DAY_ID','=',$id)
->get();

$checkedit =  DB::table('food_index_staple')
->where('FOOD_BILL_DAY_ID','=',$id)
->count();


$foodboardedit = DB::table('food_index_board')
->where('FOOD_BILL_DAY_ID','=',$id)->get();

$check = 0;
$infodetail = null;
$infomenutype1 = null;
$infomenutype2 = null;
$infomenutype3 = null;
    return view('manager_food.infofoodbillstaple_add ',[
        'infobillday'=>$infobillday,
        'infosups'=>$infosup,
        'infofoods'=>$infofood,
        'infopersons'=>$infoperson,
        'foodboards'=>$foodboard,
        'infounits'=>$infounit,
        'check'=>$check,
        'infodetail'=>$infodetail,
        'infomenutype1s'=>$infomenutype1,
        'infomenutype2s'=>$infomenutype2,
        'infomenutype3s'=>$infomenutype3,
        'infodetailedits'=> $infodetailedit,
        'infomenutypeedit1s'=> $infomenutypeedit1,
        'infomenutypeedit2s'=> $infomenutypeedit2,
        'infomenutypeedit3s'=> $infomenutypeedit3,
        'checkedit'=> $checkedit,
        'foodboardedits'=> $foodboardedit
    ]);
}

public function infofoodbillstaple_save(Request $request)
{ 
    

    $FOOD_BILL_DAY_ID= $request->FOOD_BILL_DAY_ID;
    $ROUNDING= $request->ROUNDING;
    
    if($ROUNDING == 'on'){
          $inforounding = 'on';
    }else{
         $inforounding = 'off';
    }

    $add = Foodbillday::find($FOOD_BILL_DAY_ID);
    $add->FOOD_BILL_DAY_ROUNDING =  $inforounding; 
    $add->save(); 



    Foodindexstaple::where('FOOD_BILL_DAY_ID','=',$FOOD_BILL_DAY_ID)->delete(); 
    Foodindexmenu::where('FOOD_BILL_DAY_ID','=',$FOOD_BILL_DAY_ID)->delete(); 
    Foodindexboard::where('FOOD_BILL_DAY_ID','=',$FOOD_BILL_DAY_ID)->delete(); 

    if($request->FOOD_INDEX_STAPLE_SUPID != '' || $request->FOOD_INDEX_STAPLE_SUPID !=null){

        $FOOD_INDEX_STAPLE_SUPID = $request->FOOD_INDEX_STAPLE_SUPID;
        $FOOD_INDEX_STAPLE_TOTAL = $request->FOOD_INDEX_STAPLE_TOTAL;
        $FOOD_INDEX_STAPLE_UNIT = $request->FOOD_INDEX_STAPLE_UNIT;
        $FOOD_INDEX_STAPLE_PERUNIT = $request->FOOD_INDEX_STAPLE_PERUNIT;
        $FOOD_INDEX_STAPLE_PICE = $request->FOOD_INDEX_STAPLE_PICE;
        $FOOD_INDEX_STAPLE_BUY_TOTAL = $request->FOOD_INDEX_STAPLE_BUY_TOTAL;
        $FOOD_INDEX_STAPLE_BUY_UNIT = $request->FOOD_INDEX_STAPLE_BUY_UNIT;
        $number =count($FOOD_INDEX_STAPLE_SUPID);
        $count = 0;
        for($count = 0; $count < $number; $count++)
        {  
    
        $add = new Foodindexstaple();
        $add->FOOD_BILL_DAY_ID = $FOOD_BILL_DAY_ID;
        $add->FOOD_INDEX_STAPLE_SUPID = $FOOD_INDEX_STAPLE_SUPID[$count];
        $add->FOOD_INDEX_STAPLE_TOTAL = $FOOD_INDEX_STAPLE_TOTAL[$count];
        $add->FOOD_INDEX_STAPLE_UNIT = $FOOD_INDEX_STAPLE_UNIT[$count];
        $add->FOOD_INDEX_STAPLE_PERUNIT = $FOOD_INDEX_STAPLE_PERUNIT[$count];
        $add->FOOD_INDEX_STAPLE_PICE = $FOOD_INDEX_STAPLE_PICE[$count];
        $add->FOOD_INDEX_STAPLE_BUY_TOTAL = $FOOD_INDEX_STAPLE_BUY_TOTAL[$count];
        $add->FOOD_INDEX_STAPLE_BUY_UNIT = $FOOD_INDEX_STAPLE_BUY_UNIT[$count];
        $add->save(); 

        
        }

    }


    if($request->FOOD_INDEX_MENU != '' || $request->FOOD_INDEX_MENU !=null){

        $FOOD_INDEX_MENU = $request->FOOD_INDEX_MENU;
        $FOOD_INDEX_MENU_TYPE = $request->FOOD_INDEX_MENU_TYPE;

        $number =count($FOOD_INDEX_MENU);
        $count = 0;
        for($count = 0; $count < $number; $count++)
        {  
    
        $add = new Foodindexmenu();
        $add->FOOD_BILL_DAY_ID = $FOOD_BILL_DAY_ID;
        $add->FOOD_INDEX_MENU = $FOOD_INDEX_MENU[$count];
        $add->FOOD_INDEX_MENU_TYPE = $FOOD_INDEX_MENU_TYPE[$count];
        $add->save(); 
        }

    }


    if($request->FOOD_INDEX_BOARD_PERSON != '' || $request->FOOD_INDEX_BOARD_PERSON !=null){

        $FOOD_INDEX_BOARD_PERSON = $request->FOOD_INDEX_BOARD_PERSON;
        $FOOD_INDEX_BOARD_POSITION = $request->FOOD_INDEX_BOARD_POSITION;

        $number =count($FOOD_INDEX_BOARD_PERSON);
        $count = 0;
        for($count = 0; $count < $number; $count++)
        {  
    
        $add = new Foodindexboard();
        $add->FOOD_BILL_DAY_ID = $FOOD_BILL_DAY_ID;
        $add->FOOD_INDEX_BOARD_PERSON = $FOOD_INDEX_BOARD_PERSON[$count];
        $add->FOOD_INDEX_BOARD_POSITION = $FOOD_INDEX_BOARD_POSITION[$count];
        $add->save(); 

        
        }

    }


     //==============update มูลค่า
      
        $sum = DB::table('food_index_staple')->where('FOOD_BILL_DAY_ID','=',$FOOD_BILL_DAY_ID)->sum('FOOD_INDEX_STAPLE_PICE');

        if($inforounding == 'on'){
            $sumtotal = number_format($sum,0,".","");
        }else{
            $sumtotal = number_format($sum,5,".",""); 
        }

        $add = Foodbillday::find($FOOD_BILL_DAY_ID);
        $add->FOOD_BILL_DAY_TOTAL = $sumtotal;
        $add->save(); 



    return redirect()->route('mfood.infofoodbill');

}




//======================================================

public function infofoodbillday_add()
{    

    $m_budget = date("m");
    if($m_budget>9){
        $year = date("Y")+544;
      }else{
        $year = date("Y")+543;
      }


    $maxnum = Foodbillday::where('FOOD_BILL_DAY_YEAR','=',$year)->orderBy('FOOD_BILL_DAY_ID', 'desc')->first();
    $hnum = substr($year,2); 


 
    if($maxnum !== '' && $maxnum !== null){
        $lnum = substr($maxnum->FOOD_BILL_DAY_NUMBER,-4); 
        $lastnum_num = (int)$lnum+1;
        $lastnum =  str_pad($lastnum_num,4,"0",STR_PAD_LEFT);
    }else{
        $lastnum = '0001';
    }
   




    $maxnumberuse =  'F'.$hnum.'-'.$lastnum;

    //==========================================================
    
    $suppliesrequest = Suppliescon::where('CON_YEAR_ID','=',$year)
    ->where('supplies_con.SUP_TYPE_ID','=','18')
    ->orderBy('ID', 'desc')->get();

    //==========================================================

    $infovendor = DB::table('supplies_vendor')->get();

    return view('manager_food.infofoodbillday_add',[
        'maxnumberuse' => $maxnumberuse, 
        'suppliesrequests' => $suppliesrequest, 
        'infovendors' => $infovendor, 
    ]);

}


public function infofoodbillday_save(Request $request)
{    

    $FOOD_BILL_DAYDATE= $request->FOOD_BILL_DAY_DATE;
    

    if($FOOD_BILL_DAYDATE != ''){
        $STARTDAY = Carbon::createFromFormat('d/m/Y', $FOOD_BILL_DAYDATE)->format('Y-m-d');
        $date_arrary_st=explode("-",$STARTDAY);  
        $y_sub_st = $date_arrary_st[0]; 
        
        if($y_sub_st >= 2500){
            $y_st = $y_sub_st-543;
        }else{
            $y_st = $y_sub_st;
        }
        $m_st = $date_arrary_st[1];
        $d_st = $date_arrary_st[2];  
        $FOODBILLDAYDATE= $y_st."-".$m_st."-".$d_st;
        }else{
        $FOODBILLDAYDATE= null;
    }


    $m_budget = date("m");
    if($m_budget>9){
        $year = date("Y")+544;
      }else{
        $year = date("Y")+543;
      }

    $add = new Foodbillday();
    $add->FOOD_BILL_DAY_NUMBER = $request->FOOD_BILL_DAY_NUMBER;
    $add->CON_NUM = $request->CON_NUM;
    $add->FOOD_BILL_DAY_DATE = $FOODBILLDAYDATE;
    $add->FOOD_BILL_DAY_NAME = $request->FOOD_BILL_DAY_NAME;
    $add->FOOD_BILL_DAY_VENDOR = $request->FOOD_BILL_DAY_VENDOR;
    $add->FOOD_BILL_DAY_YEAR =  $year;
    $add->save(); 
  
         return redirect()->route('mfood.infofoodbill');


}




public function infofoodbillday_edit(Request $request,$id)
{   
    $m_budget = date("m");
    if($m_budget>9){
        $year = date("Y")+544;
      }else{
        $year = date("Y")+543;
      }
     
    $suppliesrequest = Suppliescon::where('CON_YEAR_ID','=',$year)
    ->where('supplies_con.SUP_TYPE_ID','=','18')
    ->orderBy('ID', 'desc')->get();

    $infovendor = DB::table('supplies_vendor')->get();
    
    $infobillday = DB::table('food_bill_day')->where('FOOD_BILL_DAY_ID','=',$id)->first();
    return view('manager_food.infofoodbillday_edit',[
        'infobillday' => $infobillday,
        'suppliesrequests' => $suppliesrequest,
        'infovendors' => $infovendor,

    ]);

}


public function infofoodbillday_update(Request $request)
{    

    $FOOD_BILL_DAYDATE= $request->FOOD_BILL_DAY_DATE;
    

    if($FOOD_BILL_DAYDATE != ''){
        $STARTDAY = Carbon::createFromFormat('d/m/Y', $FOOD_BILL_DAYDATE)->format('Y-m-d');
        $date_arrary_st=explode("-",$STARTDAY);  
        $y_sub_st = $date_arrary_st[0]; 
        
        if($y_sub_st >= 2500){
            $y_st = $y_sub_st-543;
        }else{
            $y_st = $y_sub_st;
        }
        $m_st = $date_arrary_st[1];
        $d_st = $date_arrary_st[2];  
        $FOODBILLDAYDATE= $y_st."-".$m_st."-".$d_st;
        }else{
        $FOODBILLDAYDATE= null;
    }

    

    $id = $request->FOOD_BILL_DAY_ID;

    $add =  Foodbillday::find($id);
    $add->FOOD_BILL_DAY_NUMBER = $request->FOOD_BILL_DAY_NUMBER;
    $add->CON_NUM = $request->CON_NUM;
    $add->FOOD_BILL_DAY_DATE = $FOODBILLDAYDATE;
    $add->FOOD_BILL_DAY_NAME = $request->FOOD_BILL_DAY_NAME;
    $add->FOOD_BILL_DAY_VENDOR = $request->FOOD_BILL_DAY_VENDOR;
    $add->save(); 
  
         return redirect()->route('mfood.infofoodbill');


}


public function infofoodbilltotal(Request $request)
{       
    if($request->method() === 'POST'){
        $search = $request->get('search');
        $status = $request->SEND_STATUS;
        $datebigin = $request->get('DATE_BIGIN');
        $dateend = $request->get('DATE_END');
        $yearbudget = $request->BUDGET_YEAR;
        $data_search = json_encode_u([
            'search' => $search,
            'yearbudget' => $yearbudget,
            'datebigin' => $datebigin,
            'dateend' => $dateend,
            'status' => $status,
        ]);
        Cookie::queue('data_search', $data_search, 120,$request->server('REQUEST_URI'));
    }elseif(!empty(Cookie::get('data_search'))){
        $data_search    = json_decode(Cookie::get('data_search'));
        $search     = $data_search->search;
        $yearbudget     = $data_search->yearbudget;
        $datebigin     = $data_search->datebigin;
        $dateend     = $data_search->dateend;
        $status     = $data_search->status;
    }else{
        $search     = '';
        $yearbudget = getBudgetYear();
        $datebigin  = date('01/10/'.($yearbudget-1));
        $dateend    = date('30/09/'.$yearbudget);
        $status       = '';
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
        $infosupcon = Suppliescon::select('supplies_con.ID','supplies_status_regis.REGIS_STATUS_ID','CON_YEAR_ID','CON_NUM','supplies_request.REQUEST_ID','REGIS_STATUS_NAME','DATE_REGIS','EGP_PLAN_NAME','SUP_TYPE_NAME','VENDOR_NAME','supplies_con.BUDGET_SUM','supplies_budget.BUDGET_NAME','BUY_NAME','CHECK_DATE')
        ->leftJoin('supplies_status_regis','supplies_con.REGIS_STATUS_ID','=','supplies_status_regis.REGIS_STATUS_ID')
        ->leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
        ->leftJoin('supplies_request','supplies_con.REQUEST_ID','=','supplies_request.ID')
        ->leftJoin('supplies_buy','supplies_con.BUY_ID','=','supplies_buy.BUY_ID')
        ->leftJoin('supplies_budget','supplies_con.BUDGET_ID','=','supplies_budget.BUDGET_ID')
        ->where('supplies_con.CON_YEAR_ID','=',$yearbudget)
        ->where('supplies_con.SUP_TYPE_ID','=','18')
        ->where(function($q) use ($search){
            $q->where('EGP_PLAN_NAME','like','%'.$search.'%');
            $q->orwhere('VENDOR_NAME','like','%'.$search.'%');
            $q->orwhere('CON_NUM','like','%'.$search.'%'); 
            $q->orwhere('supplies_con.BUDGET_SUM','like','%'.$search.'%');  
            $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');    
        })
        ->WhereBetween('DATE_REGIS',[$from,$to]) 
        ->orderBy('ID', 'desc')->get();
        $budgetsum =  Suppliescon::select('supplies_con.ID','supplies_status_regis.REGIS_STATUS_ID','CON_YEAR_ID','CON_NUM','supplies_request.REQUEST_ID','REGIS_STATUS_NAME','DATE_REGIS','EGP_PLAN_NAME','SUP_TYPE_NAME','VENDOR_NAME','supplies_con.BUDGET_SUM','supplies_budget.BUDGET_NAME','BUY_NAME','CHECK_DATE')
        ->leftJoin('supplies_status_regis','supplies_con.REGIS_STATUS_ID','=','supplies_status_regis.REGIS_STATUS_ID')
        ->leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
        ->leftJoin('supplies_request','supplies_con.REQUEST_ID','=','supplies_request.ID')
        ->leftJoin('supplies_buy','supplies_con.BUY_ID','=','supplies_buy.BUY_ID')
        ->leftJoin('supplies_budget','supplies_con.BUDGET_ID','=','supplies_budget.BUDGET_ID')
        ->where('supplies_con.CON_YEAR_ID','=',$yearbudget)
        ->where('supplies_con.SUP_TYPE_ID','=','18')
        ->where(function($q) use ($search){
            $q->where('EGP_PLAN_NAME','like','%'.$search.'%');
            $q->orwhere('VENDOR_NAME','like','%'.$search.'%');
            $q->orwhere('CON_NUM','like','%'.$search.'%'); 
            $q->orwhere('supplies_con.BUDGET_SUM','like','%'.$search.'%');  
            $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');    
        })
        ->WhereBetween('DATE_REGIS',[$from,$to])
        ->sum('supplies_con.BUDGET_SUM');
        $count =  Suppliescon::select('supplies_con.ID','supplies_status_regis.REGIS_STATUS_ID','CON_YEAR_ID','CON_NUM','supplies_request.REQUEST_ID','REGIS_STATUS_NAME','DATE_REGIS','EGP_PLAN_NAME','SUP_TYPE_NAME','VENDOR_NAME','supplies_con.BUDGET_SUM','supplies_budget.BUDGET_NAME','BUY_NAME','CHECK_DATE')
        ->leftJoin('supplies_status_regis','supplies_con.REGIS_STATUS_ID','=','supplies_status_regis.REGIS_STATUS_ID')
        ->leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
        ->leftJoin('supplies_request','supplies_con.REQUEST_ID','=','supplies_request.ID')
        ->leftJoin('supplies_buy','supplies_con.BUY_ID','=','supplies_buy.BUY_ID')
        ->leftJoin('supplies_budget','supplies_con.BUDGET_ID','=','supplies_budget.BUDGET_ID')
        ->where('supplies_con.CON_YEAR_ID','=',$yearbudget)
        ->where('supplies_con.SUP_TYPE_ID','=','18')
        ->where(function($q) use ($search){
            $q->where('EGP_PLAN_NAME','like','%'.$search.'%');
            $q->orwhere('VENDOR_NAME','like','%'.$search.'%');
            $q->orwhere('CON_NUM','like','%'.$search.'%'); 
            $q->orwhere('supplies_con.BUDGET_SUM','like','%'.$search.'%');  
            $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');   
        })
        ->WhereBetween('DATE_REGIS',[$from,$to])
        ->count();
    }else{
        $infosupcon = Suppliescon::select('supplies_con.ID','supplies_status_regis.REGIS_STATUS_ID','CON_YEAR_ID','CON_NUM','supplies_request.REQUEST_ID','REGIS_STATUS_NAME','DATE_REGIS','EGP_PLAN_NAME','SUP_TYPE_NAME','VENDOR_NAME','supplies_con.BUDGET_SUM','supplies_budget.BUDGET_NAME','BUY_NAME','CHECK_DATE')
        ->leftJoin('supplies_status_regis','supplies_con.REGIS_STATUS_ID','=','supplies_status_regis.REGIS_STATUS_ID')
        ->leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
        ->leftJoin('supplies_request','supplies_con.REQUEST_ID','=','supplies_request.ID')
        ->leftJoin('supplies_buy','supplies_con.BUY_ID','=','supplies_buy.BUY_ID')
        ->leftJoin('supplies_budget','supplies_con.BUDGET_ID','=','supplies_budget.BUDGET_ID')
        ->where('supplies_con.REGIS_STATUS_ID','=',$status)
        ->where('supplies_con.CON_YEAR_ID','=',$yearbudget)
        ->where('supplies_con.SUP_TYPE_ID','=','18')
        ->where(function($q) use ($search){
            $q->where('EGP_PLAN_NAME','like','%'.$search.'%');
            $q->orwhere('VENDOR_NAME','like','%'.$search.'%');
            $q->orwhere('CON_NUM','like','%'.$search.'%'); 
            $q->orwhere('supplies_con.BUDGET_SUM','like','%'.$search.'%');  
            $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');     
        })
        ->WhereBetween('DATE_REGIS',[$from,$to]) 
        ->orderBy('ID', 'desc')->get();
        $budgetsum =  Suppliescon::select('supplies_con.ID','supplies_status_regis.REGIS_STATUS_ID','CON_YEAR_ID','CON_NUM','supplies_request.REQUEST_ID','REGIS_STATUS_NAME','DATE_REGIS','EGP_PLAN_NAME','SUP_TYPE_NAME','VENDOR_NAME','supplies_con.BUDGET_SUM','supplies_budget.BUDGET_NAME','BUY_NAME','CHECK_DATE')
        ->leftJoin('supplies_status_regis','supplies_con.REGIS_STATUS_ID','=','supplies_status_regis.REGIS_STATUS_ID')
        ->leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
        ->leftJoin('supplies_request','supplies_con.REQUEST_ID','=','supplies_request.ID')
        ->leftJoin('supplies_buy','supplies_con.BUY_ID','=','supplies_buy.BUY_ID')
        ->leftJoin('supplies_budget','supplies_con.BUDGET_ID','=','supplies_budget.BUDGET_ID')
        ->where('supplies_con.CON_YEAR_ID','=',$yearbudget)
        ->where('supplies_con.REGIS_STATUS_ID','=',$status)
        ->where('supplies_con.SUP_TYPE_ID','=','18')
        ->where(function($q) use ($search){
            $q->where('EGP_PLAN_NAME','like','%'.$search.'%');
            $q->orwhere('VENDOR_NAME','like','%'.$search.'%');
            $q->orwhere('CON_NUM','like','%'.$search.'%'); 
            $q->orwhere('supplies_con.BUDGET_SUM','like','%'.$search.'%');  
            $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');      
        })
        ->WhereBetween('DATE_REGIS',[$from,$to])
        ->sum('supplies_con.BUDGET_SUM');;
        $count =  Suppliescon::select('supplies_con.ID','supplies_status_regis.REGIS_STATUS_ID','CON_YEAR_ID','CON_NUM','supplies_request.REQUEST_ID','REGIS_STATUS_NAME','DATE_REGIS','EGP_PLAN_NAME','SUP_TYPE_NAME','VENDOR_NAME','supplies_con.BUDGET_SUM','supplies_budget.BUDGET_NAME','BUY_NAME','CHECK_DATE')
        ->leftJoin('supplies_status_regis','supplies_con.REGIS_STATUS_ID','=','supplies_status_regis.REGIS_STATUS_ID')
        ->leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
        ->leftJoin('supplies_request','supplies_con.REQUEST_ID','=','supplies_request.ID')
        ->leftJoin('supplies_buy','supplies_con.BUY_ID','=','supplies_buy.BUY_ID')
        ->leftJoin('supplies_budget','supplies_con.BUDGET_ID','=','supplies_budget.BUDGET_ID')
        ->where('supplies_con.CON_YEAR_ID','=',$yearbudget)
        ->where('supplies_con.REGIS_STATUS_ID','=',$status)
        ->where('supplies_con.SUP_TYPE_ID','=','18')
        ->where(function($q) use ($search){
            $q->where('EGP_PLAN_NAME','like','%'.$search.'%');
            $q->orwhere('VENDOR_NAME','like','%'.$search.'%');
            $q->orwhere('CON_NUM','like','%'.$search.'%'); 
            $q->orwhere('supplies_con.BUDGET_SUM','like','%'.$search.'%');  
            $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');    
        })
        ->WhereBetween('DATE_REGIS',[$from,$to])
        ->count();
    }    
    $suppliesstatus = DB::table('supplies_status_regis')->get();
    $budgetyear = DB::table('budget_year')->orderByDesc('LEAVE_YEAR_ID')->get();
    return view('manager_food.infofoodbilltotal',[
        'infosupcons' => $infosupcon,
        'status_check' => $status,
        'search' => $search,
        'suppliesstatuss' => $suppliesstatus,
        'displaydate_bigen' => $displaydate_bigen,
        'displaydate_end' => $displaydate_end,
        'budgetyears' => $budgetyear,
        'year_id' => $yearbudget,
        'budgetsum' => $budgetsum,
        'count' => $count,
       
    ]);  
}




public function searchinfofoodbilltotal(Request $request)
{



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


    $infosupcon = Suppliescon::select('supplies_con.ID','supplies_status_regis.REGIS_STATUS_ID','CON_YEAR_ID','CON_NUM','supplies_request.REQUEST_ID','REGIS_STATUS_NAME','DATE_REGIS','EGP_PLAN_NAME','SUP_TYPE_NAME','VENDOR_NAME','supplies_con.BUDGET_SUM','supplies_budget.BUDGET_NAME','BUY_NAME','CHECK_DATE')
    ->leftJoin('supplies_status_regis','supplies_con.REGIS_STATUS_ID','=','supplies_status_regis.REGIS_STATUS_ID')
    ->leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
    ->leftJoin('supplies_request','supplies_con.REQUEST_ID','=','supplies_request.ID')
    ->leftJoin('supplies_buy','supplies_con.BUY_ID','=','supplies_buy.BUY_ID')
    ->leftJoin('supplies_budget','supplies_con.BUDGET_ID','=','supplies_budget.BUDGET_ID')
    ->where('supplies_con.CON_YEAR_ID','=',$yearbudget)
    ->where('supplies_con.SUP_TYPE_ID','=','18')
    ->where(function($q) use ($search){
        $q->where('EGP_PLAN_NAME','like','%'.$search.'%');
        $q->orwhere('VENDOR_NAME','like','%'.$search.'%');
        $q->orwhere('CON_NUM','like','%'.$search.'%'); 
        $q->orwhere('supplies_con.BUDGET_SUM','like','%'.$search.'%');  
        $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');    
    })
    ->WhereBetween('DATE_REGIS',[$from,$to]) 
    ->orderBy('ID', 'desc')->get();

    
    $budgetsum =  Suppliescon::select('supplies_con.ID','supplies_status_regis.REGIS_STATUS_ID','CON_YEAR_ID','CON_NUM','supplies_request.REQUEST_ID','REGIS_STATUS_NAME','DATE_REGIS','EGP_PLAN_NAME','SUP_TYPE_NAME','VENDOR_NAME','supplies_con.BUDGET_SUM','supplies_budget.BUDGET_NAME','BUY_NAME','CHECK_DATE')
    ->leftJoin('supplies_status_regis','supplies_con.REGIS_STATUS_ID','=','supplies_status_regis.REGIS_STATUS_ID')
    ->leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
    ->leftJoin('supplies_request','supplies_con.REQUEST_ID','=','supplies_request.ID')
    ->leftJoin('supplies_buy','supplies_con.BUY_ID','=','supplies_buy.BUY_ID')
    ->leftJoin('supplies_budget','supplies_con.BUDGET_ID','=','supplies_budget.BUDGET_ID')
    ->where('supplies_con.CON_YEAR_ID','=',$yearbudget)
    ->where('supplies_con.SUP_TYPE_ID','=','18')
    ->where(function($q) use ($search){
        $q->where('EGP_PLAN_NAME','like','%'.$search.'%');
        $q->orwhere('VENDOR_NAME','like','%'.$search.'%');
        $q->orwhere('CON_NUM','like','%'.$search.'%'); 
        $q->orwhere('supplies_con.BUDGET_SUM','like','%'.$search.'%');  
        $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');    
    })
    ->WhereBetween('DATE_REGIS',[$from,$to])
    ->sum('supplies_con.BUDGET_SUM');;

    $count =  Suppliescon::select('supplies_con.ID','supplies_status_regis.REGIS_STATUS_ID','CON_YEAR_ID','CON_NUM','supplies_request.REQUEST_ID','REGIS_STATUS_NAME','DATE_REGIS','EGP_PLAN_NAME','SUP_TYPE_NAME','VENDOR_NAME','supplies_con.BUDGET_SUM','supplies_budget.BUDGET_NAME','BUY_NAME','CHECK_DATE')
    ->leftJoin('supplies_status_regis','supplies_con.REGIS_STATUS_ID','=','supplies_status_regis.REGIS_STATUS_ID')
    ->leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
    ->leftJoin('supplies_request','supplies_con.REQUEST_ID','=','supplies_request.ID')
    ->leftJoin('supplies_buy','supplies_con.BUY_ID','=','supplies_buy.BUY_ID')
    ->leftJoin('supplies_budget','supplies_con.BUDGET_ID','=','supplies_budget.BUDGET_ID')
    ->where('supplies_con.CON_YEAR_ID','=',$yearbudget)
    ->where('supplies_con.SUP_TYPE_ID','=','18')
    ->where(function($q) use ($search){
        $q->where('EGP_PLAN_NAME','like','%'.$search.'%');
        $q->orwhere('VENDOR_NAME','like','%'.$search.'%');
        $q->orwhere('CON_NUM','like','%'.$search.'%'); 
        $q->orwhere('supplies_con.BUDGET_SUM','like','%'.$search.'%');  
        $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');   
    })
    ->WhereBetween('DATE_REGIS',[$from,$to])
    ->count();



}else{


    $infosupcon = Suppliescon::select('supplies_con.ID','supplies_status_regis.REGIS_STATUS_ID','CON_YEAR_ID','CON_NUM','supplies_request.REQUEST_ID','REGIS_STATUS_NAME','DATE_REGIS','EGP_PLAN_NAME','SUP_TYPE_NAME','VENDOR_NAME','supplies_con.BUDGET_SUM','supplies_budget.BUDGET_NAME','BUY_NAME','CHECK_DATE')
    ->leftJoin('supplies_status_regis','supplies_con.REGIS_STATUS_ID','=','supplies_status_regis.REGIS_STATUS_ID')
    ->leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
    ->leftJoin('supplies_request','supplies_con.REQUEST_ID','=','supplies_request.ID')
    ->leftJoin('supplies_buy','supplies_con.BUY_ID','=','supplies_buy.BUY_ID')
    ->leftJoin('supplies_budget','supplies_con.BUDGET_ID','=','supplies_budget.BUDGET_ID')
    ->where('supplies_con.REGIS_STATUS_ID','=',$status)
    ->where('supplies_con.CON_YEAR_ID','=',$yearbudget)
    ->where('supplies_con.SUP_TYPE_ID','=','18')
    ->where(function($q) use ($search){
        $q->where('EGP_PLAN_NAME','like','%'.$search.'%');
        $q->orwhere('VENDOR_NAME','like','%'.$search.'%');
        $q->orwhere('CON_NUM','like','%'.$search.'%'); 
        $q->orwhere('supplies_con.BUDGET_SUM','like','%'.$search.'%');  
        $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');     
    })
    ->WhereBetween('DATE_REGIS',[$from,$to]) 
    ->orderBy('ID', 'desc')->get();


    $budgetsum =  Suppliescon::select('supplies_con.ID','supplies_status_regis.REGIS_STATUS_ID','CON_YEAR_ID','CON_NUM','supplies_request.REQUEST_ID','REGIS_STATUS_NAME','DATE_REGIS','EGP_PLAN_NAME','SUP_TYPE_NAME','VENDOR_NAME','supplies_con.BUDGET_SUM','supplies_budget.BUDGET_NAME','BUY_NAME','CHECK_DATE')
    ->leftJoin('supplies_status_regis','supplies_con.REGIS_STATUS_ID','=','supplies_status_regis.REGIS_STATUS_ID')
    ->leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
    ->leftJoin('supplies_request','supplies_con.REQUEST_ID','=','supplies_request.ID')
    ->leftJoin('supplies_buy','supplies_con.BUY_ID','=','supplies_buy.BUY_ID')
    ->leftJoin('supplies_budget','supplies_con.BUDGET_ID','=','supplies_budget.BUDGET_ID')
    ->where('supplies_con.CON_YEAR_ID','=',$yearbudget)
    ->where('supplies_con.REGIS_STATUS_ID','=',$status)
    ->where('supplies_con.SUP_TYPE_ID','=','18')
    ->where(function($q) use ($search){
        $q->where('EGP_PLAN_NAME','like','%'.$search.'%');
        $q->orwhere('VENDOR_NAME','like','%'.$search.'%');
        $q->orwhere('CON_NUM','like','%'.$search.'%'); 
        $q->orwhere('supplies_con.BUDGET_SUM','like','%'.$search.'%');  
        $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');      
    })
    ->WhereBetween('DATE_REGIS',[$from,$to])
    ->sum('supplies_con.BUDGET_SUM');;

    $count =  Suppliescon::select('supplies_con.ID','supplies_status_regis.REGIS_STATUS_ID','CON_YEAR_ID','CON_NUM','supplies_request.REQUEST_ID','REGIS_STATUS_NAME','DATE_REGIS','EGP_PLAN_NAME','SUP_TYPE_NAME','VENDOR_NAME','supplies_con.BUDGET_SUM','supplies_budget.BUDGET_NAME','BUY_NAME','CHECK_DATE')
    ->leftJoin('supplies_status_regis','supplies_con.REGIS_STATUS_ID','=','supplies_status_regis.REGIS_STATUS_ID')
    ->leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
    ->leftJoin('supplies_request','supplies_con.REQUEST_ID','=','supplies_request.ID')
    ->leftJoin('supplies_buy','supplies_con.BUY_ID','=','supplies_buy.BUY_ID')
    ->leftJoin('supplies_budget','supplies_con.BUDGET_ID','=','supplies_budget.BUDGET_ID')
    ->where('supplies_con.CON_YEAR_ID','=',$yearbudget)
    ->where('supplies_con.REGIS_STATUS_ID','=',$status)
    ->where('supplies_con.SUP_TYPE_ID','=','18')
    ->where(function($q) use ($search){
        $q->where('EGP_PLAN_NAME','like','%'.$search.'%');
        $q->orwhere('VENDOR_NAME','like','%'.$search.'%');
        $q->orwhere('CON_NUM','like','%'.$search.'%'); 
        $q->orwhere('supplies_con.BUDGET_SUM','like','%'.$search.'%');  
        $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');    
    })
    ->WhereBetween('DATE_REGIS',[$from,$to])
    ->count();


}    




    $suppliesstatus = DB::table('supplies_status_regis')->get();
      
    $budgetyear = DB::table('budget_year')->get();

 
    return view('manager_food.infofoodbilltotal',[
        'infosupcons' => $infosupcon,
        'status_check' => $status,
        'search' => $search,
        'suppliesstatuss' => $suppliesstatus,
        'displaydate_bigen' => $displaydate_bigen,
        'displaydate_end' => $displaydate_end,
        'budgetyears' => $budgetyear,
        'year_id' => $yearbudget,
        'budgetsum' => $budgetsum,
        'count' => $count,
       
    ]); 


  
}


public function infofoodbilltotal_add()
{  
  

    $suppliestype = DB::table('supplies_type')->get();
    $pessonall = Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')->get();
    $departmentsubsub = DB::table('hrd_department_sub_sub')->get();
    $suppliesrequest = DB::table('supplies_request')->orderBy('supplies_request.ID', 'desc')->get();
    $suppliesbuy = DB::table('supplies_buy')->where('ACTIVE','=',True)->get();
    $suppliescondision = DB::table('supplies_condision')->get();
    $suppliesmethod = DB::table('supplies_method')->get();
    $suppliesaspect = DB::table('supplies_aspect')->get();
    $suppliesbudget = DB::table('supplies_budget')->get();  
    $suppliesmoneygroup = DB::table('supplies_money_group')->get();

    $infoperson = DB::table('hrd_person')
    ->where('HR_STATUS_ID','=',1)
    ->get();

    $infosuppliespurchase = Suppliespurchase::where('PURCHASE_ID','=',1)->first();

    $suppliesposition = DB::table('supplies_position')->get();

    $m_budget = date("m");
    if($m_budget>9){
        $year = date("Y")+544;
      }else{
        $year = date("Y")+543;
      }
    $maxnum = Suppliescon::where('CON_YEAR_ID','=',$year)->orderBy('ID', 'desc')->first();
    $hnum = substr($year,2); 
    $lnum = substr($maxnum->CON_NUM,-4); 
  
    $lastnum_num = (int)$lnum+1;
    
    $lastnum =  str_pad($lastnum_num,4,"0",STR_PAD_LEFT);

    $maxnumberuse =  $hnum.'-'.$lastnum;

        $REQUEST_ID = '';
        $REQUEST_NAME = '';
        $DEP_REQUEST_ID =  '';
        $PERSON_REQUEST_ID =  '';
        $SUP_TYPE_ID =  '';

    return view('manager_food.infofoodbilltotal_add',[
            'suppliestypes' => $suppliestype,
            'pessonalls' => $pessonall,
            'suppliesrequests' => $suppliesrequest,
            'departmentsubsubs' => $departmentsubsub,
            'suppliesbuys' => $suppliesbuy,
            'suppliescondisions' => $suppliescondision,
            'suppliesmethods' => $suppliesmethod,
            'suppliesaspects' => $suppliesaspect,
            'suppliesbudgets' => $suppliesbudget,
            'suppliesmoneygroups' => $suppliesmoneygroup,
            'infopersons' => $infoperson,
            'infosuppliespurchase' => $infosuppliespurchase,
            'suppliespositions' => $suppliesposition,
            'maxnumberuse' => $maxnumberuse,
            'REQUEST_ID' => $REQUEST_ID,
            'REQUEST_NAME' => $REQUEST_NAME,
            'DEP_REQUEST_ID' => $DEP_REQUEST_ID,
            'PERSON_REQUEST_ID' => $PERSON_REQUEST_ID,
            'SUP_TYPE_ID' => $SUP_TYPE_ID,
        ]);
}





public function saveinfofoodbilltotal(Request $request)
{

    $DATE_REGIS= $request->DATE_REGIS;
  
    

    if($DATE_REGIS != ''){
        $STARTDAY = Carbon::createFromFormat('d/m/Y', $DATE_REGIS)->format('Y-m-d');
        $date_arrary_st=explode("-",$STARTDAY);  
        $y_sub_st = $date_arrary_st[0]; 
        
        if($y_sub_st >= 2500){
            $y_st = $y_sub_st-543;
        }else{
            $y_st = $y_sub_st;
        }
        $m_st = $date_arrary_st[1];
        $d_st = $date_arrary_st[2];  
        $DATEREGIS= $y_st."-".$m_st."-".$d_st;
        }else{
        $DATEREGIS= null;
    }

    $ORG_CMD_DATE= $request->ORG_CMD_DATE;
    if($ORG_CMD_DATE != ''){
        $STARTDAY = Carbon::createFromFormat('d/m/Y', $ORG_CMD_DATE)->format('Y-m-d');
        $date_arrary_st=explode("-",$STARTDAY);  
        $y_sub_st = $date_arrary_st[0]; 
        
        if($y_sub_st >= 2500){
            $y_st = $y_sub_st-543;
        }else{
            $y_st = $y_sub_st;
        }
        $m_st = $date_arrary_st[1];
        $d_st = $date_arrary_st[2];  
        $ORGCMDDATE= $y_st."-".$m_st."-".$d_st;
        }else{
        $ORGCMDDATE= null;
    }



    $DATE_WANT_USE= $request->DATE_WANT_USE;
    if($DATE_WANT_USE != ''){
        $STARTDAY = Carbon::createFromFormat('d/m/Y', $DATE_WANT_USE)->format('Y-m-d');
        $date_arrary_st=explode("-",$STARTDAY);  
        $y_sub_st = $date_arrary_st[0]; 
        
        if($y_sub_st >= 2500){
            $y_st = $y_sub_st-543;
        }else{
            $y_st = $y_sub_st;
        }
        $m_st = $date_arrary_st[1];
        $d_st = $date_arrary_st[2];  
        $DATEWANTUSE= $y_st."-".$m_st."-".$d_st;
        }else{
        $DATEWANTUSE= null;
    }


    $COMMAND_DATE= $request->COMMAND_DATE;
    if($COMMAND_DATE != ''){
        $STARTDAY = Carbon::createFromFormat('d/m/Y', $COMMAND_DATE)->format('Y-m-d');
        $date_arrary_st=explode("-",$STARTDAY);  
        $y_sub_st = $date_arrary_st[0]; 
        
        if($y_sub_st >= 2500){
            $y_st = $y_sub_st-543;
        }else{
            $y_st = $y_sub_st;
        }
        $m_st = $date_arrary_st[1];
        $d_st = $date_arrary_st[2];  
        $COMMANDDATE= $y_st."-".$m_st."-".$d_st;
        }else{
        $COMMANDDATE= null;
    }


    $m_budget = date("m");
    if($m_budget>9){
        $year = date("Y")+544;
      }else{
        $year = date("Y")+543;
      }
    $maxnum = Suppliescon::where('CON_YEAR_ID','=',$year)->orderBy('ID', 'desc')->first();
    $hnum = substr($year,2); 
    $lnum = substr($maxnum->CON_NUM,-4); 
  
    $lastnum_num = (int)$lnum+1;
    
    $lastnum =  str_pad($lastnum_num,4,"0",STR_PAD_LEFT);

    $maxnumberuse =  $hnum.'-'.$lastnum;


    $addsuppliescon = new Suppliescon();
    $addsuppliescon->REQUEST_ID = $request->REQUEST_ID;
    $addsuppliescon->CON_YEAR_ID = $request->CON_YEAR_ID;
    $addsuppliescon->DEP_REQUEST_BOOK_NUM = $request->DEP_REQUEST_BOOK;
    $addsuppliescon->DEP_REQUEST_ID = $request->DEP_REQUEST_ID;



    $addsuppliescon->PERSON_REQUEST_ID = $request->PERSON_REQUEST_ID;  
    $inforpersonrequest=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
    ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
    ->where('hrd_person.ID','=',$request->PERSON_REQUEST_ID)->first();

    $addsuppliescon->PERSON_REQUEST_NAME = $inforpersonrequest->HR_PREFIX_NAME.''.$inforpersonrequest->HR_FNAME.' '.$inforpersonrequest->HR_LNAME;
    $addsuppliescon->DEP_REQUEST_NAME = $inforpersonrequest->HR_DEPARTMENT_SUB_SUB_NAME;

    $addsuppliescon->CON_NUM = $maxnumberuse;

    $addsuppliescon->DATE_REGIS = $DATEREGIS;

    $addsuppliescon->REGIS_BY_ID = $request->REGIS_BY_ID;  
    $inforpersonregis=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
    ->where('hrd_person.ID','=',$request->REGIS_BY_ID)->first();

    $addsuppliescon->REGIS_BY_NAME = $inforpersonregis->HR_PREFIX_NAME.''.$inforpersonregis->HR_FNAME.' '.$inforpersonregis->HR_LNAME;
    $addsuppliescon->REGIS_BY_POSITION = $inforpersonregis->POSITION_IN_WORK;


    //----------------------------------------------------------------------------
    $addsuppliescon->ORG_ADD = $request->ORG_ADD;
    $addsuppliescon->ORG_PROVINCE = $request->ORG_PROVINCE;
    $addsuppliescon->ORG_CMD_PROVINCE = $request->ORG_CMD_PROVINCE;
    $addsuppliescon->ORG_CMD_DATE = $ORGCMDDATE;
    $addsuppliescon->ORG_PROVINCE_LEADER = $request->ORG_PROVINCE_LEADER;

    //----------------------------------------------------------------------------
    $addsuppliescon->BUY_ID = $request->BUY_ID;
    $addsuppliescon->CONDISION_ID = $request->CONDISION_ID;
    $addsuppliescon->CON_REASON = $request->CONDISION_RESION;
    $addsuppliescon->METHOD_ID = $request->METHOD_ID;
    $addsuppliescon->SUP_TYPE_ID = $request->SUP_TYPE_ID;
    $addsuppliescon->CON_DETAIL = $request->CON_DETAIL; 
    $addsuppliescon->ASPECT_ID = $request->ASPECT_ID; 
    $addsuppliescon->DATE_WANT_USE = $DATEWANTUSE; 
    $addsuppliescon->DATE_WANT_COUNT = $request->DATE_WANT_COUNT; 
    $addsuppliescon->RESON_NAME = $request->RESON_NAME; 
    $addsuppliescon->MONEY_GROUP_ID = $request->MONEY_GROUP_ID; 
    $addsuppliescon->BUDGET_ID = $request->BUDGET_ID; 
    //----------------------------------------------------------------------------
    $addsuppliescon->EGP_CODE = $request->EGP_CODE;
    $addsuppliescon->EGP_PLAN_NAME = $request->EGP_PLAN_NAME;

    //----------------------------------------------------------------------------
    $addsuppliescon->COMMAND_DETAIL = $request->COMMAND_DETAIL;
    $addsuppliescon->COMMAND_NUMBER = $request->COMMAND_NUMBER;
    $addsuppliescon->COMMAND_DATE = $COMMANDDATE;

      //----------------------------------------------------------------------------
      $addsuppliescon->APPROVE_LEADER_ID = $request->PURCHASE_LEADER_ID;
      $PURCHASE_LEADER=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
      ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
      ->where('hrd_person.ID','=',$request->PURCHASE_LEADER_ID)->first();

      $addsuppliescon->APPROVE_LEADER_NAME = $PURCHASE_LEADER->HR_PREFIX_NAME.''.$PURCHASE_LEADER->HR_FNAME.' '.$PURCHASE_LEADER->HR_LNAME;
      $addsuppliescon->APPROVE_LEADER_POSITION = $PURCHASE_LEADER->POSITION_IN_WORK;

      $addsuppliescon->COMMIT_HR_ID = $request->PURCHASE_OFFICER_ID;
      $PURCHASE_OFFICER=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
      ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
      ->where('hrd_person.ID','=',$request->PURCHASE_OFFICER_ID)->first();

      $addsuppliescon->COMMIT_HR_NAME = $PURCHASE_OFFICER->HR_PREFIX_NAME.''.$PURCHASE_OFFICER->HR_FNAME.' '.$PURCHASE_OFFICER->HR_LNAME;
      $addsuppliescon->COMMIT_HR_POSITION = $PURCHASE_OFFICER->POSITION_IN_WORK;

      $addsuppliescon->COMMIT_HR_LEADER_ID = $request->PURCHASE_HEAD_ID;
      $PURCHASE_HEAD=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
      ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
      ->where('hrd_person.ID','=',$request->PURCHASE_HEAD_ID)->first();

      $addsuppliescon->COMMIT_HR_LEADER_NAME = $PURCHASE_HEAD->HR_PREFIX_NAME.''.$PURCHASE_HEAD->HR_FNAME.' '.$PURCHASE_HEAD->HR_LNAME;
      $addsuppliescon->COMMIT_HR_LEADER_POSITION = $PURCHASE_HEAD->POSITION_IN_WORK;


      $addsuppliescon->REGIS_STATUS_ID = '1'; 
  
    $addsuppliescon->save(); 


//----------------------บันทึกคณะกรรมการ

    $CONID = Suppliescon::max('ID');
   
    if($request->BOARD_HR_ID[0] != '' || $request->BOARD_HR_ID[0] != null){
        
        $BOARD_HR_ID = $request->BOARD_HR_ID;
        $SUP_POSITION_ID = $request->SUP_POSITION_ID;


        $number =count($BOARD_HR_ID);
        $count = 0;
        for($count = 0; $count < $number; $count++)
        {  
      
           $addSuppliesconboard = new Suppliesconboard();
           $addSuppliesconboard->CON_ID = $CONID;
           $addSuppliesconboard->BOARD_HR_ID = $BOARD_HR_ID[$count];
          
           $infoboardname =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
           ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
           ->where('hrd_person.ID','=',$BOARD_HR_ID[$count])->first();

            $addSuppliesconboard->BOARD_HR_NAME = $infoboardname->HR_PREFIX_NAME.''.$infoboardname->HR_FNAME.' '.$infoboardname->HR_LNAME;
            $addSuppliesconboard->BOARD_HR_POSITION = $infoboardname->POSITION_IN_WORK;

           $addSuppliesconboard->SUP_POSITION_ID = $SUP_POSITION_ID[$count];
           $addSuppliesconboard->save(); 
         
           
        }
    }



    //----------------------บันทึกคณะกรรมการกำหนดรายละเอียด

   
    if($request->BOARD_DETAIL_HR_ID[0] != '' || $request->BOARD_DETAIL_HR_ID[0] != null){
        
        $BOARD_DETAIL_HR_ID = $request->BOARD_DETAIL_HR_ID;
        $SUP_POSITION_DETAIL_ID = $request->SUP_POSITION_DETAIL_ID;


        $number =count($BOARD_DETAIL_HR_ID);
        $count = 0;
        for($count = 0; $count < $number; $count++)
        {  
      
           $addSuppliesconboarddetail = new Suppliesconboarddetail();
           $addSuppliesconboarddetail->CON_ID = $CONID;
           $addSuppliesconboarddetail->BOARD_DETAIL_HR_ID = $BOARD_DETAIL_HR_ID[$count];
          
           $infoboardname =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
           ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
           ->where('hrd_person.ID','=',$BOARD_DETAIL_HR_ID[$count])->first();

            $addSuppliesconboarddetail->BOARD_DETAIL_HR_NAME = $infoboardname->HR_PREFIX_NAME.''.$infoboardname->HR_FNAME.' '.$infoboardname->HR_LNAME;
            $addSuppliesconboarddetail->BOARD_DETAIL_HR_POSITION = $infoboardname->POSITION_IN_WORK;

           $addSuppliesconboarddetail->SUP_POSITION_DETAIL_ID = $SUP_POSITION_DETAIL_ID[$count];
           $addSuppliesconboarddetail->save(); 
         
           
        }
    }
  

    
     return redirect()->route('mfood.infofoodbilltotal');

    }


public function infofoodboard()
{  
    $infoperson =  Person::where('HR_STATUS_ID','=','1')
    ->orderBy('hrd_person.HR_FNAME', 'asc')
    ->get();
    
    $countcheck = Foodboard::count();

    $infofoodboard = Foodboard::get();
    return view('manager_food.infofoodboard',[
        'infopersons'=>$infoperson, 
        'countcheck'=>$countcheck, 
        'infofoodboards'=>$infofoodboard, 
    ]);
}

public function infofoodboardupdate(Request $request)
{ 
    
    Foodboard::truncate();

   if($request->FOOD_BOARD_PERSON_ID != '' || $request->FOOD_BOARD_PERSON_ID !=null){

            $FOOD_BOARD_PERSON_ID = $request->FOOD_BOARD_PERSON_ID;
            $FOOD_BOARD_POSITION_ID = $request->FOOD_BOARD_POSITION_ID;
            $number =count($FOOD_BOARD_PERSON_ID);
            $count = 0;
            for($count = 0; $count < $number; $count++)
            {  
        
            $add = new Foodboard();
            $add->FOOD_BOARD_PERSON_ID = $FOOD_BOARD_PERSON_ID[$count];
            $add->FOOD_BOARD_POSITION_ID = $FOOD_BOARD_POSITION_ID[$count];
            $add->save(); 

            
            }

   }
    
    return redirect()->route('mfood.infofoodboard');
  
}

//=======================ตั้งค่าโภชนา====

public function infofoodtype()
{    
    $infofoodtype = Foodtype::get();

    return view('manager_food.infofoodtype',[
        'infofoodtypes' =>$infofoodtype
    ]);

}

public function infofoodtype_add()
{    

    return view('manager_food.infofoodtype_add');

}


public function infofoodtype_save(Request $request)
{    

    $add = new Foodtype();
    $add->FOOD_TYPE_NAME = $request->FOOD_TYPE_NAME;
    $add->save(); 

    return redirect()->route('mfood.infofoodtype');

}

public function infofoodtype_edit(Request $request,$idref)
{    

     $infofoodtyperef= Foodtype::where('FOOD_TYPE_ID','=',$idref)->first();

    return view('manager_food.infofoodtype_edit',[
        'infofoodtyperef'=>$infofoodtyperef
    ]);

}

public function infofoodtype_update(Request $request)
{    

    $id =  $request->FOOD_TYPE_ID;

    $update =  Foodtype::find($id);
    $update->FOOD_TYPE_NAME = $request->FOOD_TYPE_NAME;
    $update->save(); 
    return redirect()->route('mfood.infofoodtype');

}

function destroyinfofoodtype_update($idref) { 
                
    Foodtype::destroy($idref);         
    return redirect()->route('mfood.infofoodtype');
  
}



public function infofoodunit()
{    
    $infofoodunit = Foodunit::get();

    return view('manager_food.infofoodunit',[
        'infofoodunits' =>$infofoodunit
    ]);

}

public function infofoodunit_add()
{   
    
    $infounit = DB::table('food_unit')->get();

    return view('manager_food.infofoodunit_add',[
        'infounits'=> $infounit
    ]);

}


public function infofoodunit_save(Request $request)
{    

    $add = new Foodunit();
    $add->FOOD_UNIT_NAME = $request->FOOD_UNIT_NAME;
    $add->save(); 


    $FOODUNITID = Foodunit::max('FOOD_UNIT_ID');
   
    if($request->FOOD_UNIT_SUB_AMOUNT[0] != '' || $request->FOOD_UNIT_SUB_AMOUNT[0] != null){
        
        $FOOD_UNIT_SUB_AMOUNT = $request->FOOD_UNIT_SUB_AMOUNT;
        $FOOD_UNIT_SUB_NUMBER = $request->FOOD_UNIT_SUB_NUMBER;


        $number =count($FOOD_UNIT_SUB_AMOUNT);
        $count = 0;
        for($count = 0; $count < $number; $count++)
        {  
           $add = new Foodunitsub();
           $add->FOOD_UNIT_ID = $FOODUNITID;
           $add->FOOD_UNIT_SUB_AMOUNT = $FOOD_UNIT_SUB_AMOUNT[$count];
           $add->FOOD_UNIT_SUB_NUMBER = $FOOD_UNIT_SUB_NUMBER[$count];
           $add->save();    
        }
    }


    return redirect()->route('mfood.infofoodunit');

}

public function infofoodunit_edit(Request $request,$idref)
{  
    $infounit = DB::table('food_unit')->get();  

    $infofodsub = Foodunitsub::where('FOOD_UNIT_ID','=',$idref)->get();

     $infofoodunitref= Foodunit::where('FOOD_UNIT_ID','=',$idref)->first();

    return view('manager_food.infofoodunit_edit',[
        'infofoodunitref'=>$infofoodunitref,
        'infounits'=> $infounit,
        'infofodsubs'=> $infofodsub
    ]);

}

public function infofoodunit_update(Request $request)
{    

    $id =  $request->FOOD_UNIT_ID;

    $update =  Foodunit::find($id);
    $update->FOOD_UNIT_NAME = $request->FOOD_UNIT_NAME;
    $update->save(); 


    Foodunitsub::where('FOOD_UNIT_ID','=',$id)->delete();
    $FOODUNITID = $id;
   
    if($request->FOOD_UNIT_SUB_AMOUNT[0] != '' || $request->FOOD_UNIT_SUB_AMOUNT[0] != null){
        
        $FOOD_UNIT_SUB_AMOUNT = $request->FOOD_UNIT_SUB_AMOUNT;
        $FOOD_UNIT_SUB_NUMBER = $request->FOOD_UNIT_SUB_NUMBER;


        $number =count($FOOD_UNIT_SUB_AMOUNT);
        $count = 0;
        for($count = 0; $count < $number; $count++)
        {  
      
           $add = new Foodunitsub();
           $add->FOOD_UNIT_ID = $FOODUNITID;
           $add->FOOD_UNIT_SUB_AMOUNT = $FOOD_UNIT_SUB_AMOUNT[$count];
           $add->FOOD_UNIT_SUB_NUMBER = $FOOD_UNIT_SUB_NUMBER[$count];
           $add->save(); 
           
        }
    }



    return redirect()->route('mfood.infofoodunit');

}

function destroyinfofoodunit_update($idref) { 
                
    Foodunit::destroy($idref);         
    return redirect()->route('mfood.infofoodunit');
  
}


//========================================================================




public function export_pdfrequest()
{       
    $pdf = PDF::loadView('manager_food.export_pdfrequest');
    return @$pdf->stream();
}


public function export_pdfpay(Request $request,$idref)
{    

   $foodindexstaple =  DB::table('food_index_staple')
   ->leftJoin('supplies','supplies.ID','=','food_index_staple.FOOD_INDEX_STAPLE_SUPID')
   ->leftJoin('food_unit','food_unit.FOOD_UNIT_ID','=','food_index_staple.FOOD_INDEX_STAPLE_BUY_UNIT')
   ->where('FOOD_BILL_DAY_ID','=',$idref)
   ->get();


   $foodindexmenu1 = DB::table('food_index_menu')
   ->leftJoin('food_menu','food_menu.FOOD_MENU_ID','=','food_index_menu.FOOD_INDEX_MENU')
   ->where('FOOD_INDEX_MENU_TYPE','=','1')->where('FOOD_BILL_DAY_ID','=',$idref)->get();

   $foodindexmenu2 = DB::table('food_index_menu')
   ->leftJoin('food_menu','food_menu.FOOD_MENU_ID','=','food_index_menu.FOOD_INDEX_MENU')
   ->where('FOOD_INDEX_MENU_TYPE','=','2')->where('FOOD_BILL_DAY_ID','=',$idref)->get();

   $foodindexmenu3 = DB::table('food_index_menu')
   ->leftJoin('food_menu','food_menu.FOOD_MENU_ID','=','food_index_menu.FOOD_INDEX_MENU')
   ->where('FOOD_INDEX_MENU_TYPE','=','3')->where('FOOD_BILL_DAY_ID','=',$idref)->get();

   $orgname = DB::table('info_org')
   ->leftJoin('hrd_person','hrd_person.ID','=','info_org.ORG_LEADER_ID')
   ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
   ->where('ORG_ID','=','1')
   ->first();

   $foodbillday = DB::table('food_bill_day')->where('FOOD_BILL_DAY_ID','=',$idref)->first();
   
   $sumtotal01 =  DB::table('food_index_staple')
   ->where('FOOD_BILL_DAY_ID','=',$idref)
   ->sum('FOOD_INDEX_STAPLE_PICE');

 

   if($foodbillday->FOOD_BILL_DAY_ROUNDING == 'on'){
    $sumtotal = number_format($sumtotal01,0,".","");
    }else{
    $sumtotal = number_format($sumtotal01,5,".",""); 
    }

    $pdf = PDF::loadView('manager_food.export_pdfpay',[
        'foodindexstaples' => $foodindexstaple,
        'foodbillday' => $foodbillday,
        'foodindexmenu1s' => $foodindexmenu1,
        'foodindexmenu2s' => $foodindexmenu2,
        'foodindexmenu3s' => $foodindexmenu3,
        'orgname' => $orgname,
        'sumtotal' => $sumtotal,
    ]);
    return @$pdf->stream();
}

public function export_pdffrontpage($idref)
{
     $pdf = PDF::loadView('manager_food.export_pdffrontpage');
     return @$pdf->stream();
}

public function export_pdf_temporary_delivery($idref)
{
     $pdf = PDF::loadView('manager_food.export_pdf_temporary_delivery');
     return @$pdf->stream();
}

//=================================================================================//
public function infofoodbilltotal_edit(Request $request,$id)
{  
    
           $suppliestype = DB::table('supplies_type')->get();
           $pessonall = Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')->get();   
           $departmentsubsub = DB::table('hrd_department_sub_sub')->get(); 
           $suppliesrequest = DB::table('supplies_request')->orderBy('ID', 'desc')->get();
   
    
           $suppliesbuy = DB::table('supplies_buy')->where('ACTIVE','=',True)->get();
           $suppliescondision = DB::table('supplies_condision')->get();
           $suppliesmethod = DB::table('supplies_method')->get();
           $suppliesaspect = DB::table('supplies_aspect')->get();
           $suppliesbudget = DB::table('supplies_budget')->get();
           $suppliesmoneygroup = DB::table('supplies_money_group')->get();
   
          
           $infoperson = DB::table('hrd_person')
           ->where('HR_STATUS_ID','=',1)
           ->get();
           $suppliesposition = DB::table('supplies_position')->get();
             
   
           $infouppliesco = Suppliescon::where('ID','=',$id)->first();
          
           $detail = Suppliesrequest::where('ID','=',$infouppliesco->REQUEST_ID)->first();
           
           if($detail == null){
                $inforvalue =  '';
    
           }else{

                $dereid =  $detail->ID;
                $derefor =   $detail->REQUEST_FOR;
                $derecom =  $detail->REQUEST_BUY_COMMENT;
                $inforvalue =  $dereid.'::'.$derefor.'::'.$derecom;

           }
        
           
          
           

           $infoSuppliesconboard = Suppliesconboard::where('CON_ID','=',$id)->get();
           $countcheck =  Suppliesconboard::where('CON_ID','=',$id)->count();

           $infoSuppliesconboarddetail = Suppliesconboarddetail::where('CON_ID','=',$id)->get();
           $countcheckdetail =  Suppliesconboarddetail::where('CON_ID','=',$id)->count();
    


    return view('manager_food.infofoodbilltotal_edit',[
        'suppliestypes' => $suppliestype,
        'pessonalls' => $pessonall,
        'suppliesrequests' => $suppliesrequest,
        'departmentsubsubs' => $departmentsubsub,
        'suppliesbuys' => $suppliesbuy,
        'suppliescondisions' => $suppliescondision,
        'suppliesmethods' => $suppliesmethod,
        'suppliesaspects' => $suppliesaspect,
        'suppliesbudgets' => $suppliesbudget,
        'suppliesmoneygroups' => $suppliesmoneygroup,
        'infopersons' => $infoperson,
        'infouppliesco' => $infouppliesco,
        'suppliespositions' => $suppliesposition,
        'detail' => $detail,
        'infoSuppliesconboards' => $infoSuppliesconboard,
        'countcheck' => $countcheck,
        'infoSuppliesconboarddetails' => $infoSuppliesconboarddetail,
        'countcheckdetail' => $countcheckdetail,
        'inforvalue' => $inforvalue,

    ]);

}


public function infofoodbilltotal_update(Request $request)
{

    $DATE_REGIS= $request->DATE_REGIS;
  
    

    if($DATE_REGIS != ''){
        $STARTDAY = Carbon::createFromFormat('d/m/Y', $DATE_REGIS)->format('Y-m-d');
        $date_arrary_st=explode("-",$STARTDAY);  
        $y_sub_st = $date_arrary_st[0]; 
        
        if($y_sub_st >= 2500){
            $y_st = $y_sub_st-543;
        }else{
            $y_st = $y_sub_st;
        }
        $m_st = $date_arrary_st[1];
        $d_st = $date_arrary_st[2];  
        $DATEREGIS= $y_st."-".$m_st."-".$d_st;
        }else{
        $DATEREGIS= null;
    }

    $ORG_CMD_DATE= $request->ORG_CMD_DATE;
    if($ORG_CMD_DATE != ''){
        $STARTDAY = Carbon::createFromFormat('d/m/Y', $ORG_CMD_DATE)->format('Y-m-d');
        $date_arrary_st=explode("-",$STARTDAY);  
        $y_sub_st = $date_arrary_st[0]; 
        
        if($y_sub_st >= 2500){
            $y_st = $y_sub_st-543;
        }else{
            $y_st = $y_sub_st;
        }
        $m_st = $date_arrary_st[1];
        $d_st = $date_arrary_st[2];  
        $ORGCMDDATE= $y_st."-".$m_st."-".$d_st;
        }else{
        $ORGCMDDATE= null;
    }



    $DATE_WANT_USE= $request->DATE_WANT_USE;
    if($DATE_WANT_USE != ''){
        $STARTDAY = Carbon::createFromFormat('d/m/Y', $DATE_WANT_USE)->format('Y-m-d');
        $date_arrary_st=explode("-",$STARTDAY);  
        $y_sub_st = $date_arrary_st[0]; 
        
        if($y_sub_st >= 2500){
            $y_st = $y_sub_st-543;
        }else{
            $y_st = $y_sub_st;
        }
        $m_st = $date_arrary_st[1];
        $d_st = $date_arrary_st[2];  
        $DATEWANTUSE= $y_st."-".$m_st."-".$d_st;
        }else{
        $DATEWANTUSE= null;
    }


    $COMMAND_DATE= $request->COMMAND_DATE;
    if($COMMAND_DATE != ''){
        $STARTDAY = Carbon::createFromFormat('d/m/Y', $COMMAND_DATE)->format('Y-m-d');
        $date_arrary_st=explode("-",$STARTDAY);  
        $y_sub_st = $date_arrary_st[0]; 
        
        if($y_sub_st >= 2500){
            $y_st = $y_sub_st-543;
        }else{
            $y_st = $y_sub_st;
        }
        $m_st = $date_arrary_st[1];
        $d_st = $date_arrary_st[2];  
        $COMMANDDATE= $y_st."-".$m_st."-".$d_st;
        }else{
        $COMMANDDATE= null;
    }

    $id =  $request->ID;

    $addsuppliescon = Suppliescon::find($id);
    $addsuppliescon->REQUEST_ID = $request->REQUEST_ID;
    $addsuppliescon->DEP_REQUEST_BOOK_NUM = $request->DEP_REQUEST_BOOK;
    $addsuppliescon->DEP_REQUEST_ID = $request->DEP_REQUEST_ID;
 



    $addsuppliescon->PERSON_REQUEST_ID = $request->PERSON_REQUEST_ID;  
    $inforpersonrequest=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
    ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
    ->where('hrd_person.ID','=',$request->PERSON_REQUEST_ID)->first();

    $addsuppliescon->PERSON_REQUEST_NAME = $inforpersonrequest->HR_PREFIX_NAME.''.$inforpersonrequest->HR_FNAME.' '.$inforpersonrequest->HR_LNAME;
    $addsuppliescon->DEP_REQUEST_NAME = $inforpersonrequest->HR_DEPARTMENT_SUB_SUB_NAME;

  

    $addsuppliescon->DATE_REGIS = $DATEREGIS;

    $addsuppliescon->REGIS_BY_ID = $request->REGIS_BY_ID;  
    $inforpersonregis=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
    ->where('hrd_person.ID','=',$request->REGIS_BY_ID)->first();

    $addsuppliescon->REGIS_BY_NAME = $inforpersonregis->HR_PREFIX_NAME.''.$inforpersonregis->HR_FNAME.' '.$inforpersonregis->HR_LNAME;
    $addsuppliescon->REGIS_BY_POSITION = $inforpersonregis->POSITION_IN_WORK;


    //----------------------------------------------------------------------------
    $addsuppliescon->ORG_ADD = $request->ORG_ADD;
    $addsuppliescon->ORG_PROVINCE = $request->ORG_PROVINCE;
    $addsuppliescon->ORG_CMD_PROVINCE = $request->ORG_CMD_PROVINCE;
    $addsuppliescon->ORG_CMD_DATE = $ORGCMDDATE;
    $addsuppliescon->ORG_PROVINCE_LEADER = $request->ORG_PROVINCE_LEADER;

    //----------------------------------------------------------------------------
    $addsuppliescon->BUY_ID = $request->BUY_ID;
    $addsuppliescon->CONDISION_ID = $request->CONDISION_ID;
    $addsuppliescon->CON_REASON = $request->CONDISION_RESION;
    $addsuppliescon->METHOD_ID = $request->METHOD_ID;
    $addsuppliescon->SUP_TYPE_ID = $request->SUP_TYPE_ID;
    $addsuppliescon->CON_DETAIL = $request->CON_DETAIL; 
    $addsuppliescon->ASPECT_ID = $request->ASPECT_ID; 
    $addsuppliescon->DATE_WANT_USE = $DATEWANTUSE; 
    $addsuppliescon->DATE_WANT_COUNT = $request->DATE_WANT_COUNT; 
    $addsuppliescon->RESON_NAME = $request->RESON_NAME; 
    $addsuppliescon->MONEY_GROUP_ID = $request->MONEY_GROUP_ID; 
    $addsuppliescon->BUDGET_ID = $request->BUDGET_ID; 
    //----------------------------------------------------------------------------
    $addsuppliescon->EGP_CODE = $request->EGP_CODE;
    $addsuppliescon->EGP_PLAN_NAME = $request->EGP_PLAN_NAME;

    //----------------------------------------------------------------------------
    $addsuppliescon->COMMAND_DETAIL = $request->COMMAND_DETAIL;
    $addsuppliescon->COMMAND_NUMBER = $request->COMMAND_NUMBER;
    $addsuppliescon->COMMAND_DATE = $COMMANDDATE;

      //----------------------------------------------------------------------------
      $addsuppliescon->APPROVE_LEADER_ID = $request->PURCHASE_LEADER_ID;
      $PURCHASE_LEADER=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
      ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
      ->where('hrd_person.ID','=',$request->PURCHASE_LEADER_ID)->first();

      $addsuppliescon->APPROVE_LEADER_NAME = $PURCHASE_LEADER->HR_PREFIX_NAME.''.$PURCHASE_LEADER->HR_FNAME.' '.$PURCHASE_LEADER->HR_LNAME;
      $addsuppliescon->APPROVE_LEADER_POSITION = $PURCHASE_LEADER->POSITION_IN_WORK;

      $addsuppliescon->COMMIT_HR_ID = $request->PURCHASE_OFFICER_ID;
      $PURCHASE_OFFICER=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
      ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
      ->where('hrd_person.ID','=',$request->PURCHASE_OFFICER_ID)->first();

      $addsuppliescon->COMMIT_HR_NAME = $PURCHASE_OFFICER->HR_PREFIX_NAME.''.$PURCHASE_OFFICER->HR_FNAME.' '.$PURCHASE_OFFICER->HR_LNAME;
      $addsuppliescon->COMMIT_HR_POSITION = $PURCHASE_OFFICER->POSITION_IN_WORK;

      $addsuppliescon->COMMIT_HR_LEADER_ID = $request->PURCHASE_HEAD_ID;
      $PURCHASE_HEAD=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
      ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
      ->where('hrd_person.ID','=',$request->PURCHASE_HEAD_ID)->first();

      $addsuppliescon->COMMIT_HR_LEADER_NAME = $PURCHASE_HEAD->HR_PREFIX_NAME.''.$PURCHASE_HEAD->HR_FNAME.' '.$PURCHASE_HEAD->HR_LNAME;
      $addsuppliescon->COMMIT_HR_LEADER_POSITION = $PURCHASE_HEAD->POSITION_IN_WORK;



  
    $addsuppliescon->save(); 


//----------------------บันทึกคณะกรรมการ

    $CONID = $id;
    Suppliesconboard::where('CON_ID','=',$id)->delete(); 
   
    if($request->BOARD_HR_ID[0] != '' || $request->BOARD_HR_ID[0] != null){
        
        $BOARD_HR_ID = $request->BOARD_HR_ID;
        $SUP_POSITION_ID = $request->SUP_POSITION_ID;


        $number =count($BOARD_HR_ID);
        $count = 0;
        for($count = 0; $count < $number; $count++)
        {  
      
           $addSuppliesconboard = new Suppliesconboard();
           $addSuppliesconboard->CON_ID = $CONID;
           $addSuppliesconboard->BOARD_HR_ID = $BOARD_HR_ID[$count];
          
           $infoboardname =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
           ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
           ->where('hrd_person.ID','=',$BOARD_HR_ID[$count])->first();

            $addSuppliesconboard->BOARD_HR_NAME = $infoboardname->HR_PREFIX_NAME.''.$infoboardname->HR_FNAME.' '.$infoboardname->HR_LNAME;
            $addSuppliesconboard->BOARD_HR_POSITION = $infoboardname->POSITION_IN_WORK;

           $addSuppliesconboard->SUP_POSITION_ID = $SUP_POSITION_ID[$count];
           $addSuppliesconboard->save(); 
         
           
        }
    }


      //----------------------บันทึกคณะกรรมการกำหนดรายละเอียด
      Suppliesconboarddetail::where('CON_ID','=',$id)->delete(); 

 if($request->BOARD_DETAIL_HR_ID[0] != '' || $request->BOARD_DETAIL_HR_ID[0] != null){
     
     $BOARD_DETAIL_HR_ID = $request->BOARD_DETAIL_HR_ID;
     $SUP_POSITION_DETAIL_ID = $request->SUP_POSITION_DETAIL_ID;


     $number =count($BOARD_DETAIL_HR_ID);
     $count = 0;
     for($count = 0; $count < $number; $count++)
     {  
   
        $addSuppliesconboarddetail = new Suppliesconboarddetail();
        $addSuppliesconboarddetail->CON_ID = $CONID;
        $addSuppliesconboarddetail->BOARD_DETAIL_HR_ID = $BOARD_DETAIL_HR_ID[$count];
       
        $infoboardname =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
        ->where('hrd_person.ID','=',$BOARD_DETAIL_HR_ID[$count])->first();

         $addSuppliesconboarddetail->BOARD_DETAIL_HR_NAME = $infoboardname->HR_PREFIX_NAME.''.$infoboardname->HR_FNAME.' '.$infoboardname->HR_LNAME;
         $addSuppliesconboarddetail->BOARD_DETAIL_HR_POSITION = $infoboardname->POSITION_IN_WORK;

        $addSuppliesconboarddetail->SUP_POSITION_DETAIL_ID = $SUP_POSITION_DETAIL_ID[$count];
        $addSuppliesconboarddetail->save(); 
      
        
     }
 }

     return redirect()->route('mfood.infofoodbilltotal');

    }








public function infofoodbilltotal_cancel(Request $request,$id)
{   

    $infosuppliecon = Suppliescon::leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
    ->where('ID','=',$id)->first();

 
    return view('manager_food.infofoodbilltotal_cancel',[
        'connum' => $infosuppliecon->CON_NUM,
        'condetail' => $infosuppliecon->CON_DETAIL,
        'resonname' => $infosuppliecon->RESON_NAME,
        'personrequestname' => $infosuppliecon->PERSON_REQUEST_NAME,
        'regisbyname' => $infosuppliecon->REGIS_BY_NAME,
        'suptypename' => $infosuppliecon->SUP_TYPE_NAME,
        'conid' => $infosuppliecon->ID,

    ]);

}

    
public function infofoodbilltotal_cancelupdate(Request $request)
{
    $id = $request->CON_ID; 

    $updateapp = Suppliescon::find($id);
    $updateapp->REGIS_STATUS_ID = '6'; 
    $updateapp->save();

    return redirect()->route('mfood.infofoodbilltotal'); 

}

//==============================เพิ่มใบเสนอราคา

public function infofoodbilltotal_quotation_add(Request $request,$id)
{   
    $detailcon = Suppliescon::where('ID','=',$id)->first();

    $detailquotation= Suppliesconquotation::leftJoin('supplies_vendor','supplies_con_quotation.QUOTATION_VENDOR_ID','=','supplies_vendor.VENDOR_ID')
    ->where('QUOTATION_CON_NUM','=',$detailcon->CON_NUM)->orderBy('QUOTATION_WIN', 'desc')->get();
    

    return view('manager_food.infofoodbilltotal_quotation_add',[
        'CON_NUM' => $detailcon->CON_NUM,
        'IDCON' => $id,
        'detailquotations' => $detailquotation,
    ]);

}


public function   createpurchasequotationsub(Request $request,$id)
{
    $detailcon = Suppliescon::where('ID','=',$id)->first();

    $vendor =  DB::table('supplies_vendor')->where('ACTIVE','=','True')->get();

    return view('manager_food.purchasequotation_addsub',[
        'CON_NUM' => $detailcon->CON_NUM,
        'IDCON' => $id,
        'vendors' => $vendor
    ]);
    
}




function fetchvendor(Request $request)
{

    $id = $request->get('select');
    $select_id = $request->get('select_id');

    $detailvendor = DB::table('supplies_vendor')->where('VENDOR_ID','=',$id)->first();

    $detailinfo = DB::table('supplies_con')->where('supplies_con.ID','=',$select_id)->first();
 
    $infomon = DB::table('supplies_request')->where('ID','=',$detailinfo->REQUEST_ID)->first();
  
    
    if($infomon == null){
      $price = '';
    }else{
        $price = $infomon->BUDGET_SUM;
    }
  
      $output = ' <div class="row">
      <div class="col">
      <p style="text-align: left">ที่อยู่</p>
      </div>
      <div class="col-md-9">
          <input  name = "QUOTATION_VENDOR_ADD"  id="QUOTATION_VENDOR_ADD" class="form-control input-lg" style=" font-family: \'Kanit\', sans-serif;" value="'.$detailvendor->VENDOR_ADDRESS.'">
      </div>
      </div>
      <div class="row">
      <div class="col">
      <p style="text-align: left">เลขภาษี</p>  
      </div>
      <div class="col-md-9">
          <input  name = "QUOTATION_VENDOR_TAXNUM"  id="QUOTATION_VENDOR_TAXNUM" class="form-control input-lg" style=" font-family: \'Kanit\', sans-serif;" value="'.$detailvendor->VENDOR_TAX_NUM.'" >
      </div>
      </div>
  
      <div class="row">
      <div class="col">
      <p style="text-align: left">ยอดนำเสนอ</p>
      </div>
      <div class="col-md-7">
          <input  name = "QUOTATION_VENDOR_PICE"  id="QUOTATION_VENDOR_PICE" class="form-control input-lg" style=" font-family: \'Kanit\', sans-serif;" OnKeyPress="return chkmunny(this)" value="'. $price.'" >
      </div>
      <div class="col-md-2">
      <p style="text-align: left">บาท</p>
      </div>
      </div>
  ';
   
  
  echo $output;

}    




public function savepurchasequotationsub(Request $request)
{
   
    $id = DB::table('supplies_con')->where('CON_NUM','=',$request->QUOTATION_CON_NUM)->first();
    $updateapp = Suppliescon::find($id->ID);
    $updateapp->REGIS_STATUS_ID = '2'; 
    $updateapp->save();
      
           $addsuppliesconlist = new Suppliesconquotation();
           $addsuppliesconlist->QUOTATION_CON_NUM= $request->QUOTATION_CON_NUM; 
           $addsuppliesconlist->QUOTATION_NUMBER = $request->QUOTATION_NUMBER;
           $addsuppliesconlist->QUOTATION_VENDOR_ID = $request->QUOTATION_VENDOR_ID;
           $addsuppliesconlist->QUOTATION_VENDOR_ADD = $request->QUOTATION_VENDOR_ADD;
           $addsuppliesconlist->QUOTATION_VENDOR_TAXNUM = $request->QUOTATION_VENDOR_TAXNUM;
           $addsuppliesconlist->QUOTATION_VENDOR_PICE = $request->QUOTATION_VENDOR_PICE;
           $addsuppliesconlist->QUOTATION_WIN = $request->QUOTATION_WIN;
           

           $maxid = Suppliesconquotation::max('QUOTATION_ID');
           $idfile = $maxid+1;
           if($request->hasFile('pdfupload')){
               $newFileName = 'quotation_'.$idfile.'.'.$request->pdfupload->extension();
                 
               $request->pdfupload->storeAs('suppdf',$newFileName,'public');
   
           
               $addsuppliesconlist->QUOTATION_VENDOR_FILE_NAME = $newFileName;        
   
           }

          
           $addsuppliesconlist->save(); 

  

    return redirect()->route('mfood.infofoodbilltotal_quotation_add',[
        'id' =>$request->ID,
    ]);
    

    
}

//-----------------แก้ไขใบเสนอราคา---

public function   purchasequotationsubedit(Request $request,$id,$idref)
{
    $detailcon = Suppliescon::where('ID','=',$id)->first();

    $vendor =  DB::table('supplies_vendor')->where('ACTIVE','=','True')->get();

    $detailquotation = Suppliesconquotation::where('QUOTATION_ID','=',$idref)->first();

    return view('manager_food.purchasequotation_editsub',[
        'CON_NUM' => $detailcon->CON_NUM,
        'IDCON' => $id,
        'IDREF' => $idref,
        'vendors' => $vendor,
        'detailquotation' => $detailquotation,
    ]);
    
}




public function purchasequotationsubupdate(Request $request)
{

$id = DB::table('supplies_con')->where('CON_NUM','=',$request->QUOTATION_CON_NUM)->first();
$updateapp = Suppliescon::find($id->ID);
$updateapp->REGIS_STATUS_ID = '2'; 
$updateapp->save();
  
$idref = $request->IDREF;
       $addsuppliesconlist = Suppliesconquotation::find($idref);
       $addsuppliesconlist->QUOTATION_CON_NUM= $request->QUOTATION_CON_NUM; 
       $addsuppliesconlist->QUOTATION_NUMBER = $request->QUOTATION_NUMBER;
       $addsuppliesconlist->QUOTATION_VENDOR_ID = $request->QUOTATION_VENDOR_ID;
       $addsuppliesconlist->QUOTATION_VENDOR_ADD = $request->QUOTATION_VENDOR_ADD;
       $addsuppliesconlist->QUOTATION_VENDOR_TAXNUM = $request->QUOTATION_VENDOR_TAXNUM;
       $addsuppliesconlist->QUOTATION_VENDOR_PICE = $request->QUOTATION_VENDOR_PICE;
       $addsuppliesconlist->QUOTATION_WIN = $request->QUOTATION_WIN;
       

       $idfile = $idref;
       if($request->hasFile('pdfupload')){
           $newFileName = 'quotation_'.$idfile.'.'.$request->pdfupload->extension();         
           $request->pdfupload->storeAs('suppdf',$newFileName,'public');
           $addsuppliesconlist->QUOTATION_VENDOR_FILE_NAME = $newFileName;        
       }

       $addsuppliesconlist->save(); 

return redirect()->route('mfood.infofoodbilltotal_quotation_add',[
    'id' =>$request->ID,
]);



}


public function purchasequotationsubdelete($id,$idref) { 
            
Suppliesconquotation::destroy($idref);         
 
return redirect()->route('mfood.infofoodbilltotal_quotation_add',[
    'id' =>$id,
]);
}



//------------------------------------------------------------------------

public function infofoodbilltotal_list(Request $request)
{   

    return view('manager_food.infofoodbilltotal_list');

}



public function infofoodbilltotal_orders(Request $request,$idlistref)
{

    $infosuppliecon = Suppliescon::leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
    ->where('ID','=',$idlistref)->first();

    $infosuppliesconlist = Suppliesconlist::leftJoin('supplies_unit_ref','supplies_con_list.SUP_UNIT_ID','=','supplies_unit_ref.ID')
    ->select('supplies_con_list.SUP_NAME','supplies_con_list.SUP_TOTAL','supplies_unit_ref.SUP_UNIT_NAME','supplies_con_list.PRICE_PER_UNIT')
    ->where('supplies_con_list.CON_ID','=',$idlistref)
    ->get();

    $sumprice = Suppliesconlist::where('supplies_con_list.CON_ID','=',$idlistref)
    ->sum('PRICE_SUM');

    $pessonall = Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')->get();
   
    $infovendor = DB::table('supplies_con_quotation')
    ->leftJoin('supplies_vendor','supplies_con_quotation.QUOTATION_VENDOR_ID','=','supplies_vendor.VENDOR_ID')
    ->where('QUOTATION_CON_NUM','=',$infosuppliecon->CON_NUM)->where('QUOTATION_WIN','=',1)->first();
     

    if($infovendor == null){
        $vendor ='';
    }else{
        $vendor =$infovendor;
    }
 
    $m_budget = date("m");
    if($m_budget>9){
        $year = date("Y")+544;
      }else{
        $year = date("Y")+543;
      }

    $maxnum = Suppliescon::where('CON_YEAR_ID','=',$year)->orderBy('PO_NUM', 'desc')->first();
    $hnum = substr($year,2); 


    if($maxnum !== null && $maxnum !== ''){
        $lnum = substr($maxnum->PO_NUM,-5); 
      
        $lastnum_num = (int)$lnum+1;
        
        $lastnum =  str_pad($lastnum_num,5,"0",STR_PAD_LEFT);
        }else{
            $lastnum =  '00001';
        }

    $maxnumberpo =  'PO'.$hnum.''.$lastnum;
 
     

    return view('manager_food.infofoodbilltotal_orders',[
        'maxnumberpo' => $maxnumberpo,
        'infosuppliecon' => $infosuppliecon,
        'infosuppliesconlists' => $infosuppliesconlist,
        'sumprice' => $sumprice,  
        'pessonalls' => $pessonall, 
        'vendor' => $vendor, 
    ]);
    
}




public function savepurchaseorders(Request $request)
{
                $id = $request->ID;

                $SEND_DATE = $request->SEND_DATE;
                $PO_DATE = $request->PO_DATE;
                $ORDER_DATE = $request->ORDER_DATE;
                $SIGN_DATE = $request->SIGN_DATE;

                if($SEND_DATE != ''){
                $STARTDAY = Carbon::createFromFormat('d/m/Y', $SEND_DATE)->format('Y-m-d');
                $date_arrary_st=explode("-",$STARTDAY);  
                $y_sub_st = $date_arrary_st[0]; 
                
                if($y_sub_st >= 2500){
                    $y_st = $y_sub_st-543;
                }else{
                    $y_st = $y_sub_st;
                }
                $m_st = $date_arrary_st[1];
                $d_st = $date_arrary_st[2];  
                $SENDDATE= $y_st."-".$m_st."-".$d_st;
                }else{
                $SENDDATE= null;
            }

            if($PO_DATE != ''){
                $STARTDAY = Carbon::createFromFormat('d/m/Y', $PO_DATE)->format('Y-m-d');
                $date_arrary_st=explode("-",$STARTDAY);  
                $y_sub_st = $date_arrary_st[0]; 
                
                if($y_sub_st >= 2500){
                    $y_st = $y_sub_st-543;
                }else{
                    $y_st = $y_sub_st;
                }
                $m_st = $date_arrary_st[1];
                $d_st = $date_arrary_st[2];  
                $PODATE= $y_st."-".$m_st."-".$d_st;
                }else{
                $PODATE= null;
            }

            if($ORDER_DATE != ''){
                $STARTDAY = Carbon::createFromFormat('d/m/Y', $ORDER_DATE)->format('Y-m-d');
                $date_arrary_st=explode("-",$STARTDAY);  
                $y_sub_st = $date_arrary_st[0]; 
                
                if($y_sub_st >= 2500){
                    $y_st = $y_sub_st-543;
                }else{
                    $y_st = $y_sub_st;
                }
                $m_st = $date_arrary_st[1];
                $d_st = $date_arrary_st[2];  
                $ORDERDATE= $y_st."-".$m_st."-".$d_st;
                }else{
                $ORDERDATE= null;
            }

            if($SIGN_DATE != ''){
                $STARTDAY = Carbon::createFromFormat('d/m/Y', $SIGN_DATE)->format('Y-m-d');
                $date_arrary_st=explode("-",$STARTDAY);  
                $y_sub_st = $date_arrary_st[0]; 
                
                if($y_sub_st >= 2500){
                    $y_st = $y_sub_st-543;
                }else{
                    $y_st = $y_sub_st;
                }
                $m_st = $date_arrary_st[1];
                $d_st = $date_arrary_st[2];  
                $SIGNDATE= $y_st."-".$m_st."-".$d_st;
                }else{
                $SIGNDATE= null;
            }
            

            $m_budget = date("m");
            if($m_budget>9){
                $year = date("Y")+544;
              }else{
                $year = date("Y")+543;
              }
        
            $maxnum = Suppliescon::where('CON_YEAR_ID','=',$year)->orderBy('PO_NUM', 'desc')->first();
            $hnum = substr($year,2); 
        
        
            if($maxnum !== null && $maxnum !== ''){
                $lnum = substr($maxnum->PO_NUM,-5); 
              
                $lastnum_num = (int)$lnum+1;
                
                $lastnum =  str_pad($lastnum_num,5,"0",STR_PAD_LEFT);
                }else{
                    $lastnum =  '00001';
                }
                $maxnumberpo =  'PO'.$hnum.''.$lastnum;

                $checkinfo = Suppliescon::where('ID','=',$id)->where('PO_NUM','=',$request->PO_NUM)->count();

            $addpurchaseorders =  Suppliescon::find($id);

            if($checkinfo == 0){
                $addpurchaseorders->PO_NUM = $maxnumberpo;
            }else{
                $addpurchaseorders->PO_NUM = $request->PO_NUM;
            }

            $addpurchaseorders->INSURANCE_YEAR = $request->INSURANCE_YEAR;
            $addpurchaseorders->INSURANCE_MONT = $request->INSURANCE_MONT;

            $addpurchaseorders->RECIPIENT_NAME = $request->RECIPIENT_NAME;
            $addpurchaseorders->RECIPIENT_POSITION = $request->RECIPIENT_POSITION;
            $addpurchaseorders->BUYER_USER_ID = $request->BUYER_USER_ID;

            $addpurchaseorders->SEND_DATE = $SENDDATE;
            $addpurchaseorders->PO_DATE = $PODATE;
            $addpurchaseorders->ORDER_DATE = $ORDERDATE;
            $addpurchaseorders->SIGN_DATE = $SIGNDATE;
            $addpurchaseorders->TAX_TYPE = $request->TAX_TYPE;
            $addpurchaseorders->DISCOUNT = $request->DISC;
            $addpurchaseorders->REGIS_STATUS_ID = '4';  

            $addpurchaseorders->save();

                    


   return redirect()->route('mfood.infofoodbilltotal'); 

}    


//=======================================

public function purchascheck(Request $request,$idlistref)
{

    $infosuppliecon = Suppliescon::leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
    ->where('ID','=',$idlistref)->first();

    $infosuppliesconlist = Suppliesconlist::leftJoin('supplies_unit_ref','supplies_con_list.SUP_UNIT_ID','=','supplies_unit_ref.ID')
    ->select('supplies_con_list.SUP_NAME','supplies_con_list.SUP_TOTAL','supplies_unit_ref.SUP_UNIT_NAME','supplies_con_list.PRICE_PER_UNIT','supplies_con_list.ID','supplies_con_list.CON_REMARK')
    ->where('supplies_con_list.CON_ID','=',$idlistref)
    ->get();

    $pessonall = Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')->get();

    $infovendor = DB::table('supplies_con_quotation')
    ->leftJoin('supplies_vendor','supplies_con_quotation.QUOTATION_VENDOR_ID','=','supplies_vendor.VENDOR_ID')
    ->where('QUOTATION_CON_NUM','=',$infosuppliecon->CON_NUM)->where('QUOTATION_WIN','=',1)->first();
     

        if($infovendor == null){
            $vendor ='';
        }else{
            $vendor =$infovendor;
        }
     
        $sumprice = Suppliesconlist::where('supplies_con_list.CON_ID','=',$idlistref)
        ->sum('PRICE_SUM');

        $m_budget = date("m");
        if($m_budget>9){
            $year = date("Y")+544;
          }else{
            $year = date("Y")+543;
          }

        $maxnum = Suppliescon::where('CON_YEAR_ID','=',$year)->orderBy('CH_NUM', 'desc')->first();
  
       if($maxnum->CH_NUM == '' || $maxnum->CH_NUM == null){
        $lastnum_num = 1;
       }else{
           
        $lnum = substr($maxnum->CH_NUM,-5); 
        $lastnum_num = (int)$lnum+1;
       } 
 
        
        $lastnum =  str_pad($lastnum_num,5,"0",STR_PAD_LEFT);

        $maxnumberch =  'CH-'.$lastnum;

     

    return view('manager_food.purchascheck',[
        'infosuppliecon' => $infosuppliecon,
        'infosuppliesconlists' => $infosuppliesconlist, 
        'infovendor' => $infovendor, 
        'pessonalls' => $pessonall, 
        'sumprice' => $sumprice, 
        'maxnumberch' => $maxnumberch, 
    ]);
    
}

  //---------------------------------------------------


  public function createpurchaselist(Request $request,$idlistref)
  {


      $infosuppliecon = Suppliescon::leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
      ->where('ID','=',$idlistref)->first();

      $infoasset = Supplies::where('SUP_TYPE_ID','=',$infosuppliecon->SUP_TYPE_ID)->get();


      $infosuppliescon =  DB::table('supplies_con_list')->where('CON_ID','=',$infosuppliecon->ID)->get();

      $countcheck =  DB::table('supplies_con_list')->where('CON_ID','=',$infosuppliecon->ID)->count();

      $infofresh=  DB::table('food_fresh')->where('FOOD_FRESH_ID','=','1')->first();

      $sumref =  DB::table('food_bill_day')->where('CON_NUM','=',$infosuppliecon->CON_NUM)->sum('FOOD_BILL_DAY_TOTAL');
  
    
      return view('manager_food.purchaselist_add',[
          'connum' => $infosuppliecon->CON_NUM,
          'condetail' => $infosuppliecon->CON_DETAIL,
          'resonname' => $infosuppliecon->RESON_NAME,
          'personrequestname' => $infosuppliecon->PERSON_REQUEST_NAME,
          'regisbyname' => $infosuppliecon->REGIS_BY_NAME,
          'suptypename' => $infosuppliecon->SUP_TYPE_NAME,
          'infoassets' => $infoasset,
          'infosuppliescons' => $infosuppliescon,
          'countcheck' => $countcheck,
          'conid' => $infosuppliecon->ID,
          'infofresh' => $infofresh,
          'sumref' => $sumref,

      ]);
      
  }

  public function savepurchaselist(Request $request)
  {

      $CONID = $request->CON_ID;

    
    
      Suppliesconlist::where('CON_ID','=',$CONID)->delete(); 

      if($request->SUP_ID[0] != '' || $request->SUP_ID[0] != null){
          
          $SUP_ID = $request->SUP_ID;
          $SUP_TOTAL = $request->SUP_TOTAL;
          $SUP_UNIT_ID = $request->SUP_UNIT_ID;
          $PRICE_PER_UNIT = $request->PRICE_PER_UNIT;

          $number =count($SUP_ID);
          $count = 0;
          for($count = 0; $count < $number; $count++)
          {  
        
             $addsuppliesconlist = new Suppliesconlist();
             $addsuppliesconlist->CON_ID = $CONID;
             $addsuppliesconlist->SUP_ID = $SUP_ID[$count];

             $infosupname = DB::table('supplies')->where('ID','=',$SUP_ID[$count])->first();

             $addsuppliesconlist->SUP_NAME= $infosupname->SUP_NAME; 
             $addsuppliesconlist->SUP_TOTAL = $SUP_TOTAL[$count];
             $addsuppliesconlist->SUP_UNIT_ID = $SUP_UNIT_ID[$count];
             $addsuppliesconlist->PRICE_PER_UNIT = $PRICE_PER_UNIT[$count];
             $addsuppliesconlist->PRICE_SUM = $PRICE_PER_UNIT[$count] * $SUP_TOTAL[$count];

             
             
             $addsuppliesconlist->save(); 
           
             
          }
      }


  

      $infosuppliecon = Suppliescon::where('ID','=',$CONID)->first();

      $infovendor = DB::table('supplies_con_quotation')
      ->leftJoin('supplies_vendor','supplies_con_quotation.QUOTATION_VENDOR_ID','=','supplies_vendor.VENDOR_ID')
      ->where('QUOTATION_CON_NUM','=',$infosuppliecon->CON_NUM)->where('QUOTATION_WIN','=',1)->first();
    
      if($infovendor == '' || $infovendor == null){
          $VENDOR = '';
      }else{
          $VENDOR =$infovendor->VENDOR_NAME;
      }

      $sumprice = Suppliesconlist::where('supplies_con_list.CON_ID','=',$CONID)
      ->sum('PRICE_SUM');

      $updateapp = Suppliescon::find($CONID);
      $updateapp->REGIS_STATUS_ID = '3'; 
      $updateapp->VENDOR_NAME=  $VENDOR; 
      
      $updateapp->BUDGET_SUM = $sumprice;
      $updateapp->save();
    
  
      return redirect()->route('mfood.infofoodbilltotal');
      
 
      
  }




public function savepurchascheck(Request $request)
{
                $id = $request->ID;

                $CHECK_DATE = $request->CHECK_DATE;
         
                if($CHECK_DATE != ''){
                $STARTDAY = Carbon::createFromFormat('d/m/Y', $CHECK_DATE)->format('Y-m-d');
                $date_arrary_st=explode("-",$STARTDAY);  
                $y_sub_st = $date_arrary_st[0]; 
                
                if($y_sub_st >= 2500){
                    $y_st = $y_sub_st-543;
                }else{
                    $y_st = $y_sub_st;
                }
                $m_st = $date_arrary_st[1];
                $d_st = $date_arrary_st[2];  
                $CHECKDATE= $y_st."-".$m_st."-".$d_st;
                }else{
                $CHECKDATE= null;
            }

  
       
            $addpurchasecheck =  Suppliescon::find($id);
            $addpurchasecheck->CH_NUM = $request->CH_NUM;
            $addpurchasecheck->INVOICE_NUM = $request->INVOICE_NUM;
            $addpurchasecheck->CHECK_DATE = $CHECKDATE;
            $addpurchasecheck->CHECK_TIME = $request->CHECK_TIME;
            $addpurchasecheck->CHECK_TYPE_ID = $request->CHECK_TYPE_ID;
            $addpurchasecheck->CHECK_USER_ID = $request->CHECK_USER_ID;
            $addpurchasecheck->CHECK_FINE = $request->CHECK_FINE;
             
            if($request->CHECK_TYPE_ID == 1){
                $addpurchasecheck->REGIS_STATUS_ID = '5'; 
            }else{
                $addpurchasecheck->REGIS_STATUS_ID = '4';  
            }
              

            $addpurchasecheck->save();

            if($request->ID_CHECK[0] != '' || $request->ID_CHECK[0] != null){
        
                $ID_CHECK = $request->ID_CHECK;
                $CON_REMARK = $request->CON_REMARK;
       
    
                $number =count($ID_CHECK);
                $count = 0;
                for($count = 0; $count < $number; $count++)
                {  
                   $id = $ID_CHECK[$count];
                   $addsuppliesconlist = Suppliesconlist::find($id);
                   $addsuppliesconlist->CON_REMARK = $CON_REMARK[$count];
                   $addsuppliesconlist->save(); 
                   
                }
            }
                    

   return redirect()->route('mfood.infofoodbilltotal'); 

}    


//======การตรวจรับ==========================

public function confirmpurchase($id)
{
 
    $updateapp = Suppliescon::find($id);
    $updateapp->REGIS_STATUS_ID = '7'; 
    $updateapp->save();

    return redirect()->route('mfood.infofoodbilltotal'); 

}


//==================================

public function selectrequestfood(Request $request)
{
    $detail = Suppliescon::where('ID','=',$request->id)->first();
    $output='<input name="CON_NUM" id="CON_NUM" class="form-control input-sm" style=" font-family: \'Kanit\', sans-serif;" value="'.$detail->CON_NUM.'">';

    echo $output;

}


public function selectdetalivendor(Request $request)
{
    $detail = Suppliescon::where('ID','=',$request->id)->first();

    $query =  DB::table('supplies_vendor')->get();
 
    $output='<option value="">--กรุณาเลือก--</option>';
    
    foreach ($query as $row){
          if($row->VENDOR_NAME == $detail->VENDOR_NAME){
            $output.= '<option value="'.$row->VENDOR_ID.'" selected>'.$row->VENDOR_NAME.'</option>';
          }else{
            $output.= '<option value="'.$row->VENDOR_ID.'">'.$row->VENDOR_NAME.'</option>';
          }
        }
          
    echo $output;

}


function conversion(Request $request)
{
    $STAPLE_TOTAL = $request->STAPLE_TOTAL;
    $STAPLE_UNIT = $request->STAPLE_UNIT;
    $STAPLE_BUY_UNIT = $request->STAPLE_BUY_UNIT;
    $IDREF = $request->IDREF;
   
      $infounit = DB::table('food_unit_sub')
      ->where('FOOD_UNIT_ID','=',$STAPLE_BUY_UNIT)
      ->where('FOOD_UNIT_SUB_NUMBER','=',$STAPLE_UNIT)
      ->first();


      $conver = $STAPLE_TOTAL/$infounit->FOOD_UNIT_SUB_AMOUNT;
   
    echo  '<input name="FOOD_INDEX_STAPLE_BUY_TOTAL[]" id="FOOD_INDEX_STAPLE_BUY_TOTAL'.$IDREF.'" class="form-control input-sm" style=" font-family: \'Kanit\', sans-serif;" value="'.$conver.'" >';
    
}



function calvalue(Request $request)
{
    $STAPLEBUYTOTAL = $request->STAPLEBUYTOTAL;
    $STAPLEPERUNIT = $request->STAPLEPERUNIT;
    $IDREF = $request->IDREF;
   

      $total = $STAPLEBUYTOTAL* $STAPLEPERUNIT;
   
    echo  '<input name="FOOD_INDEX_STAPLE_PICE[]" id="FOOD_INDEX_STAPLE_PICE'.$IDREF.'" class="form-control input-sm" style=" font-family: \'Kanit\', sans-serif;" value="'.$total.'" >';
    
}


    function infofoodfresh(Request $request)
    {
        $infosup = DB::table('supplies')->where('SUP_TYPE_ID','=','18')->get();
        $infofresh_q = DB::table('food_fresh')->where('FOOD_FRESH_ID','=','1')->first();

        if($infofresh_q !== '' && $infofresh_q !== null){
            $infofresh = $infofresh_q->FOOD_FRESH ; 
        }else{
            $infofresh = '';
        }
        return view('manager_food.infofoodfresh',[
            'infosups'=>$infosup,
            'infofresh'=>$infofresh,
        ]);
        
    }

    function infofoodfresh_update(Request $request)
    {

        $id = $request->FOOD_FRESH;

        $infofresh_q = DB::table('food_fresh')->where('FOOD_FRESH_ID','=','1')->first();

        if ($infofresh_q == '' || $infofresh_q == null) {

            $add = new Foodfresh();
            $add->FOOD_FRESH = $id ;
            $SUP_UNIT_ID = DB::table('supplies_unit_ref')->where('SUP_ID','=',$request->FOOD_FRESH)->first();
            $add->SUP_UNIT_ID = $SUP_UNIT_ID->ID;    
            $add->save();

        }else{

            $add = Foodfresh::find(1);
            $add->FOOD_FRESH = $id ;
            $SUP_UNIT_ID = DB::table('supplies_unit_ref')->where('SUP_ID','=',$request->FOOD_FRESH)->first();
            $add->SUP_UNIT_ID = $SUP_UNIT_ID->ID;    
            $add->save();

        }

        return redirect()->route('mfood.infofoodfresh');
        
    }


    
            public static function check_infobill($id)
            {
                $billday =  DB::table('food_bill_day')->where('FOOD_BILL_DAY_ID','=',$id)->first();
                
                
                $countcheck =  DB::table('supplies_con')->where('CON_NUM','=',$billday->CON_NUM)->where('REGIS_STATUS_ID','=','5')->count();

                return $countcheck;
            }


            public function infofoodrequert(Request $request)
                {    
                    
                    if($request->method() === 'POST'){
                        $search = $request->get('search');
                        $status = $request->SEND_STATUS;
                        $yearbudget = $request->YEAR_ID;
                        $datebigin = $request->get('DATE_BIGIN');
                        $dateend = $request->get('DATE_END');
                        session([
                            'manager_medical.requestforbuy.search' => $search,
                            'manager_medical.requestforbuy.status' => $status,
                            'manager_medical.requestforbuy.yearbudget' => $yearbudget,
                            'manager_medical.requestforbuy.datebigin' => $datebigin,
                            'manager_medical.requestforbuy.dateend' => $dateend,
                        ]);
                    }else if(session::has('manager_medical.requestforbuy')){
                        $search = session('manager_medical.requestforbuy.search');
                        $status = session('manager_medical.requestforbuy.status');
                        $yearbudget = session('manager_medical.requestforbuy.yearbudget');
                        $datebigin = session('manager_medical.requestforbuy.datebigin');
                        $dateend = session('manager_medical.requestforbuy.dateend');
                    }else{
                        $search = '';
                        $status = '';
                        $yearbudget = getBudgetyear();
                        $datebigin = date('1/m/Y');
                        $dateend = date('d/m/Y',strtotime(date('Y-m-1').' +1month -1day'));
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
                            ->where(function($q){
                                $q->where('REQUEST_FOR_ID','=','18');
                 
                           })
                            ->where(function($q) use ($search){
                                 $q->where('REQUEST_FOR','like','%'.$search.'%');
                                 $q->orwhere('REQUEST_BUY_COMMENT','like','%'.$search.'%');
                                 $q->orwhere('SAVE_HR_DEP_SUB_NAME','like','%'.$search.'%');
                                 $q->orwhere('REQUEST_ID','like','%'.$search.'%');
                                 $q->orwhere('REQUEST_VANDOR_NAME','like','%'.$search.'%');
                                 $q->orwhere('SAVE_HR_NAME','like','%'.$search.'%');
                            })
                                ->WhereBetween('DATE_TIME_SAVE',[$from,$to])
                            ->orderBy('supplies_request.ID', 'desc')
                            ->get();
            
                            $sumbudget  = Suppliesrequest::leftJoin('supplies_request_status','supplies_request_status.STATUS_CODE','=','supplies_request.STATUS')
                            ->where('BUDGET_YEAR','=', $yearbudget)
                            ->where(function($q){
                                $q->where('REQUEST_FOR_ID','=','18');
                  
                           })
                            ->where(function($q) use ($search){
                                 $q->where('REQUEST_FOR','like','%'.$search.'%');
                                 $q->orwhere('REQUEST_BUY_COMMENT','like','%'.$search.'%');
                                 $q->orwhere('SAVE_HR_DEP_SUB_NAME','like','%'.$search.'%');
                                 $q->orwhere('REQUEST_ID','like','%'.$search.'%');
                                 $q->orwhere('REQUEST_VANDOR_NAME','like','%'.$search.'%');
                                 $q->orwhere('SAVE_HR_NAME','like','%'.$search.'%');
                            })
                                ->WhereBetween('DATE_TIME_SAVE',[$from,$to])
                            ->sum('BUDGET_SUM');
            
                        }else{
            
                            $inforequest = Suppliesrequest::leftJoin('supplies_request_status','supplies_request_status.STATUS_CODE','=','supplies_request.STATUS')
                            ->where('STATUS_CODE','=',$status)
                            ->where('BUDGET_YEAR','=', $yearbudget)
                            ->where(function($q){
                                $q->where('REQUEST_FOR_ID','=','18');
                             
                           })
                            ->where(function($q) use ($search){
                                 $q->where('REQUEST_FOR','like','%'.$search.'%');
                                 $q->orwhere('REQUEST_BUY_COMMENT','like','%'.$search.'%');
                                 $q->orwhere('SAVE_HR_DEP_SUB_NAME','like','%'.$search.'%');
                                 $q->orwhere('REQUEST_ID','like','%'.$search.'%');
                                 $q->orwhere('REQUEST_VANDOR_NAME','like','%'.$search.'%');
                                 $q->orwhere('SAVE_HR_NAME','like','%'.$search.'%');
                            })
                                ->WhereBetween('DATE_TIME_SAVE',[$from,$to])
                            ->orderBy('supplies_request.ID', 'desc')
                            ->get();
            
            
                            $sumbudget  =Suppliesrequest::leftJoin('supplies_request_status','supplies_request_status.STATUS_CODE','=','supplies_request.STATUS')
                            ->where('STATUS_CODE','=',$status)
                            ->where('BUDGET_YEAR','=', $yearbudget)
                            ->where(function($q){
                                $q->where('REQUEST_FOR_ID','=','18');
                
                           })
                            ->where(function($q) use ($search){
                                 $q->where('REQUEST_FOR','like','%'.$search.'%');
                                 $q->orwhere('REQUEST_BUY_COMMENT','like','%'.$search.'%');
                                 $q->orwhere('SAVE_HR_DEP_SUB_NAME','like','%'.$search.'%');
                                 $q->orwhere('REQUEST_ID','like','%'.$search.'%');
                                 $q->orwhere('REQUEST_VANDOR_NAME','like','%'.$search.'%');
                                 $q->orwhere('SAVE_HR_NAME','like','%'.$search.'%');
                            })
                            ->WhereBetween('DATE_TIME_SAVE',[$from,$to])
                            ->sum('BUDGET_SUM');
            
                        }
                    
                    $info_sendstatus = DB::table('supplies_request_status')->get();
            
                    $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
                    $year_id = $yearbudget;
                     return view('manager_food.requestforbuy',[
                        'budgets' =>  $budget,
                        'inforequests' => $inforequest,
                        'info_sendstatuss' => $info_sendstatus,
                        'displaydate_bigen'=> $displaydate_bigen,
                        'displaydate_end'=> $displaydate_end,
                        'status_check'=> $status,
                        'search'=> $search,
                        'year_id'=>$year_id,
                        'sumbudget'=>$sumbudget,
            
                    ]);
      
                }

                

    public function mfood_inforequestverupdate(Request $request)
    {

        $id = $request->ID; 
    
        $check =  $request->SUBMIT; 
    
        if($check == 'approved'){
          $statuscode = 'Verify';
        }else{
          $statuscode = 'Disverify';
        }
    
          $updatever = Suppliesrequest::find($id);
    
          $updatever->STATUS = $statuscode;  
          $updatever->USER_CONFIRM_CHECK_ID = $request->USER_CONFIRM_CHECK_ID;
          //----------------------------------
          $USERCONFIRM=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
          ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
          ->where('hrd_person.ID','=',$request->USER_CONFIRM_CHECK_ID)->first();
    
           $updatever->USER_CONFIRM_CHECK_NAME = $USERCONFIRM->HR_PREFIX_NAME.''.$USERCONFIRM->HR_FNAME.' '.$USERCONFIRM->HR_LNAME;
           $updatever->USER_CONFIRM_CHECK_POSITION = $USERCONFIRM->HR_POSITION_NAME;
           //----------------------------------
           $updatever->USER_CONFIRM_CHECK_DATE = date('Y-m-d H:i:s');
           
        
           $updatever->REQUEST_BUY_TYPE_ID = $request->REQUEST_BUY_TYPE_ID; 
           $updatever->REQUEST_PLAN_TYPE_ID = $request->REQUEST_PLAN_TYPE_ID;
      
          $updatever->save();
          
       
              return redirect()->route('mfood.infofoodrequert');
    
    }


    //--------------------------แจ้งยกเลิก-----


public function food_requestforbuy_cancel (Request $request,$id)
{
    
    $inforequest =  DB::table('supplies_request')
    ->where('ID','=',$id)->first();

    $inforequestsub =  DB::table('supplies_request_sub')
    ->where('SUPPLIES_REQUEST_ID','=',$id)->get();

    $infohr = DB::table('hrd_person')->where('ID','=',$inforequest->SAVE_HR_ID)->first();

    return view('manager_food.food_requestforbuy_cancel',[
        'inforequest' => $inforequest,
      'inforequestsubs' => $inforequestsub,
      'infohr' => $infohr
        
     
    ]);

}

public function food_requestforbuy_update_cancel(Request $request)
{
    $id = $request->ID; 
    $iduser = $request->iduser;

    $updateapp = Suppliesrequest::find($id);
    $updateapp->STATUS = 'cancel'; 
    $updateapp->save();

   
      return redirect()->route('mfood.infofoodrequert');

}



public function food_requestforbuy_edit(Request $request,$id)
{      
  

       
    $inforequest =  DB::table('supplies_request')
    ->leftjoin('supplies_type','supplies_request.REQUEST_FOR_ID','=','supplies_type.SUP_TYPE_ID')
    ->where('ID','=',$id)->first();

    $iduser = $inforequest->SAVE_HR_ID;
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


    $inforequesttype =  DB::table('supplies_type')->get();



     $pessonall = Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')->orderBy('hrd_person.HR_FNAME', 'asc')->get();

     $inforequestsub =  DB::table('supplies_request_sub')
     ->where('SUPPLIES_REQUEST_ID','=',$id)->get();

     $countcheck =  DB::table('supplies_request_sub')
     ->where('SUPPLIES_REQUEST_ID','=',$id)->count();

     $suppliesvendor = DB::table('supplies_vendor')->where('ACTIVE','=','True')->get();

     $m_budget = date("m");
     if($m_budget>9){
     $yearbudget = date("Y")+544;
     }else{
     $yearbudget = date("Y")+543;
     }

     $budget = DB::table('budget_year')->where('ACTIVE','=','True')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

    return view('manager_food.food_requestforbuy_edit',[
        'inforpersonuser' => $inforpersonuser,
        'inforequest' => $inforequest,
        'countcheck' => $countcheck,
        'inforequestsubs' => $inforequestsub,
        'suppliesvendors' => $suppliesvendor,
          'pessonalls' => $pessonall,
          'inforequesttypes' => $inforequesttype,
          'budgets' => $budget,
          'year_id' => $yearbudget
    ]); 
}

public function food_requestforbuy_update(Request $request)
{

    $DATEWANT = $request->DATE_WANT;

    if($DATEWANT != ''){
       $DAY = Carbon::createFromFormat('d/m/Y', $DATEWANT)->format('Y-m-d');
       $date_arrary_st=explode("-",$DAY);
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

   $id = $request->ID;

   $addinforequest = Suppliesrequest::find($id);

   $addinforequest->REQUEST_HEAD = $request->REQUEST_HEAD;
   $addinforequest->DATE_WANT = $DATEWANT;
   $addinforequest->DATE_TIME_SAVE = date('Y-m-d H:i:s');


   $addinforequest->REQUEST_FOR_ID = $request->REQUEST_FOR_ID;
   $name_type = DB::table('supplies_type')->where('SUP_TYPE_ID','=',$request->REQUEST_FOR_ID)->first();
   $addinforequest->REQUEST_FOR = $name_type->SUP_TYPE_NAME;

   $addinforequest->DEP_SUB_SUB_ID = $request->DEP_SUB_SUB_ID;
   $addinforequest->DEP_SUB_SUB_PHONE = $request->DEP_SUB_SUB_PHONE;



           $addinforequest->AGREE_HR_ID = $request->AGREE_HR_ID;

        //----------------------------------
        $AGREEHR =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
        ->where('hrd_person.ID','=',$request->AGREE_HR_ID)->first();

           $addinforequest->AGREE_HR_NAME = $AGREEHR->HR_PREFIX_NAME.''.$AGREEHR->HR_FNAME.' '.$AGREEHR->HR_LNAME;
           $addinforequest->AGREE_HR_POSITION = $AGREEHR->HR_POSITION_NAME;

         //----------------------------------

           $addinforequest->REQUEST_BUY_COMMENT = $request->REQUEST_BUY_COMMENT;

           $addinforequest->HIRE_DETAIL = $request->HIRE_DETAIL;


           $addinforequest->BUDGET_YEAR = $request->YEAR_ID;

           $addinforequest->REQUEST_VANDOR_ID = $request->REQUEST_VANDOR_ID;

           $infovendor = DB::table('supplies_vendor')->where('VENDOR_ID','=',$request->REQUEST_VANDOR_ID)->first();
           $addinforequest->REQUEST_VANDOR_NAME = $infovendor->VENDOR_NAME;

           $addinforequest->REQUEST_REMARK = $request->REQUEST_REMARK;

           $addinforequest->save();




           $SUPPLIES_REQUEST_ID = $id;
           Suppliesrequestsub::where('SUPPLIES_REQUEST_ID','=',$id)->delete(); 
           

           if($request->SUPPLIES_REQUEST_SUBRE_ID != '' || $request->SUPPLIES_REQUEST_SUBRE_ID != null){

               $SUPPLIES_REQUEST_SUBRE_ID = $request->SUPPLIES_REQUEST_SUBRE_ID;
               
               $SUPPLIES_REQUEST_SUB_AMOUNT = $request->SUPPLIES_REQUEST_SUB_AMOUNT;
               $SUPPLIES_REQUEST_SUB_UNIT = $request->SUPPLIES_REQUEST_SUB_UNIT;
               $SUPPLIES_REQUEST_SUB_PRICE = $request->SUPPLIES_REQUEST_SUB_PRICE;
             

               $number =count($SUPPLIES_REQUEST_SUBRE_ID);
               $count = 0;
               for($count = 0; $count< $number; $count++)
               {

                  $add = new Suppliesrequestsub();
                  $add->SUPPLIES_REQUEST_ID = $SUPPLIES_REQUEST_ID;
                  $add->SUPPLIES_REQUEST_SUBRE_ID = $SUPPLIES_REQUEST_SUBRE_ID[$count];
                  $infosup = DB::table('supplies')->where('ID','=',$SUPPLIES_REQUEST_SUBRE_ID[$count])->first();
                  $add->SUPPLIES_REQUEST_SUB_DETAIL = $infosup->SUP_NAME;

                  $add->SUPPLIES_REQUEST_SUB_AMOUNT = $SUPPLIES_REQUEST_SUB_AMOUNT[$count];
                  $add->SUPPLIES_REQUEST_SUB_UNIT = $SUPPLIES_REQUEST_SUB_UNIT[$count];
                  $add->SUPPLIES_REQUEST_SUB_PRICE = $SUPPLIES_REQUEST_SUB_PRICE[$count];
                  $add->SUPPLIES_REQUEST_SUB_SUM_PRICE = $SUPPLIES_REQUEST_SUB_PRICE[$count] * $SUPPLIES_REQUEST_SUB_AMOUNT[$count];

                  $add->save();


               }
           }


   $BUDGET_SUM = Suppliesrequestsub::where('SUPPLIES_REQUEST_ID','=',$SUPPLIES_REQUEST_ID)->sum('SUPPLIES_REQUEST_SUB_SUM_PRICE');

   $updatesum = Suppliesrequest::find($SUPPLIES_REQUEST_ID );
   $updatesum->BUDGET_SUM = $BUDGET_SUM;
   $updatesum->save();

    
            return redirect()->route('mfood.infofoodrequert');
}




}