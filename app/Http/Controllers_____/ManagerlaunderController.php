<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Person;

use App\Models\Laundertype;
use App\Models\Launderdep;

use App\Models\Laundergetback;

use App\Models\Laundercheck;
use App\Models\Launderchecksub;

use App\Models\Launderdis;
use App\Models\Launderdissub;

use App\Models\Launderwithdrow;
use App\Models\Launderwithdrowsub;
use App\Models\Launderdepsub;

use App\Models\Launderpay;
use App\Models\Launderpaysub;
use Cookie;
date_default_timezone_set("Asia/Bangkok");

class ManagerlaunderController extends Controller
{
    public function dashboard()
    {
        $getback = DB::table('launder_getback')->count();
        $check = DB::table('launder_check')->count();
        $dis = DB::table('launder_dis')->count();
        $withdrow = DB::table('launder_withdrow')->count();

        $year_y = date('Y');
        $d_1 = DB::table('launder_getback')->where('LAUNDER_GETBACK_DEP','=','1')->count();
        $d_2 = DB::table('launder_getback')->where('LAUNDER_GETBACK_DEP','=','2')->count();
        $d_3 = DB::table('launder_getback')->where('LAUNDER_GETBACK_DEP','=','3')->count();
        $d_4 = DB::table('launder_getback')->where('LAUNDER_GETBACK_DEP','=','4')->count();
        $d_5 = DB::table('launder_getback')->where('LAUNDER_GETBACK_DEP','=','5')->count();
        $d_6 = DB::table('launder_getback')->where('LAUNDER_GETBACK_DEP','=','6')->count();
        $d_7 = DB::table('launder_getback')->where('LAUNDER_GETBACK_DEP','=','7')->count();
        $d_8 = DB::table('launder_getback')->where('LAUNDER_GETBACK_DEP','=','8')->count();
        $d_9 = DB::table('launder_getback')->where('LAUNDER_GETBACK_DEP','=','9')->count();
        $d_10 = DB::table('launder_getback')->where('LAUNDER_GETBACK_DEP','=','10')->count();
        $d_11 = DB::table('launder_getback')->where('LAUNDER_GETBACK_DEP','=','11')->count();
        $d_12 = DB::table('launder_getback')->where('LAUNDER_GETBACK_DEP','=','12')->count();
        $d_13 = DB::table('launder_getback')->where('LAUNDER_GETBACK_DEP','=','13')->count();
        $d_14 = DB::table('launder_getback')->where('LAUNDER_GETBACK_DEP','=','14')->count();
        $d_15 = DB::table('launder_getback')->where('LAUNDER_GETBACK_DEP','=','15')->count();
        $d_16 = DB::table('launder_getback')->where('LAUNDER_GETBACK_DEP','=','16')->count();
        $d_17 = DB::table('launder_getback')->where('LAUNDER_GETBACK_DEP','=','17')->count();
        $d_18 = DB::table('launder_getback')->where('LAUNDER_GETBACK_DEP','=','18')->count();
        $d_19 = DB::table('launder_getback')->where('LAUNDER_GETBACK_DEP','=','19')->count();
        $d_20 = DB::table('launder_getback')->where('LAUNDER_GETBACK_DEP','=','20')->count();
        $d_21 = DB::table('launder_getback')->where('LAUNDER_GETBACK_DEP','=','21')->count();
        $d_22 = DB::table('launder_getback')->where('LAUNDER_GETBACK_DEP','=','22')->count();
        $d_23 = DB::table('launder_getback')->where('LAUNDER_GETBACK_DEP','=','23')->count();
        $d_24 = DB::table('launder_getback')->where('LAUNDER_GETBACK_DEP','=','24')->count();
        $d_25 = DB::table('launder_getback')->where('LAUNDER_GETBACK_DEP','=','25')->count();
        $d_26 = DB::table('launder_getback')->where('LAUNDER_GETBACK_DEP','=','26')->count();
        $d_27 = DB::table('launder_getback')->where('LAUNDER_GETBACK_DEP','=','27')->count();
        $d_28 = DB::table('launder_getback')->where('LAUNDER_GETBACK_DEP','=','28')->count();
        $d_29 = DB::table('launder_getback')->where('LAUNDER_GETBACK_DEP','=','29')->count();
        $d_30 = DB::table('launder_getback')->where('LAUNDER_GETBACK_DEP','=','30')->count();  
        $d_31 = DB::table('launder_getback')->where('LAUNDER_GETBACK_DEP','=','31')->count(); 
        $d_32 = DB::table('launder_getback')->where('LAUNDER_GETBACK_DEP','=','32')->count(); 
        $d_33 = DB::table('launder_getback')->where('LAUNDER_GETBACK_DEP','=','33')->count(); 
        $d_34 = DB::table('launder_getback')->where('LAUNDER_GETBACK_DEP','=','34')->count(); 
        $d_35 = DB::table('launder_getback')->where('LAUNDER_GETBACK_DEP','=','35')->count(); 
        $d_36 = DB::table('launder_getback')->where('LAUNDER_GETBACK_DEP','=','36')->count(); 
        $d_37 = DB::table('launder_getback')->where('LAUNDER_GETBACK_DEP','=','37')->count(); 
        $d_38 = DB::table('launder_getback')->where('LAUNDER_GETBACK_DEP','=','38')->count(); 
        $d_39 = DB::table('launder_getback')->where('LAUNDER_GETBACK_DEP','=','39')->count();      
        $d_40 = DB::table('launder_getback')->where('LAUNDER_GETBACK_DEP','=','40')->count(); 
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

            $di_1 = DB::table('launder_dis')->where('LAUNDER_DIS_DEP','=','1')->count();
            $di_2 = DB::table('launder_dis')->where('LAUNDER_DIS_DEP','=','2')->count();
            $di_3 = DB::table('launder_dis')->where('LAUNDER_DIS_DEP','=','3')->count();
            $di_4 = DB::table('launder_dis')->where('LAUNDER_DIS_DEP','=','4')->count();
            $di_5 = DB::table('launder_dis')->where('LAUNDER_DIS_DEP','=','5')->count();
            $di_6 = DB::table('launder_dis')->where('LAUNDER_DIS_DEP','=','6')->count();
            $di_7 = DB::table('launder_dis')->where('LAUNDER_DIS_DEP','=','7')->count();
            $di_8 = DB::table('launder_dis')->where('LAUNDER_DIS_DEP','=','8')->count();
            $di_9 = DB::table('launder_dis')->where('LAUNDER_DIS_DEP','=','9')->count();
            $di_10 = DB::table('launder_dis')->where('LAUNDER_DIS_DEP','=','10')->count();
            $di_11 = DB::table('launder_dis')->where('LAUNDER_DIS_DEP','=','11')->count();
            $di_12 = DB::table('launder_dis')->where('LAUNDER_DIS_DEP','=','12')->count();
            $di_13 = DB::table('launder_dis')->where('LAUNDER_DIS_DEP','=','13')->count();
            $di_14 = DB::table('launder_dis')->where('LAUNDER_DIS_DEP','=','14')->count();
            $di_15 = DB::table('launder_dis')->where('LAUNDER_DIS_DEP','=','15')->count();
            $di_16 = DB::table('launder_dis')->where('LAUNDER_DIS_DEP','=','16')->count();
            $di_17 = DB::table('launder_dis')->where('LAUNDER_DIS_DEP','=','17')->count();
            $di_18 = DB::table('launder_dis')->where('LAUNDER_DIS_DEP','=','18')->count();
            $di_19 = DB::table('launder_dis')->where('LAUNDER_DIS_DEP','=','19')->count();
            $di_20 = DB::table('launder_dis')->where('LAUNDER_DIS_DEP','=','20')->count();
            $di_21 = DB::table('launder_dis')->where('LAUNDER_DIS_DEP','=','21')->count();
            $di_22 = DB::table('launder_dis')->where('LAUNDER_DIS_DEP','=','22')->count();
            $di_23 = DB::table('launder_dis')->where('LAUNDER_DIS_DEP','=','23')->count();
            $di_24 = DB::table('launder_dis')->where('LAUNDER_DIS_DEP','=','24')->count();
            $di_25 = DB::table('launder_dis')->where('LAUNDER_DIS_DEP','=','25')->count();
            $di_26 = DB::table('launder_dis')->where('LAUNDER_DIS_DEP','=','26')->count();
            $di_27 = DB::table('launder_dis')->where('LAUNDER_DIS_DEP','=','27')->count();
            $di_28 = DB::table('launder_dis')->where('LAUNDER_DIS_DEP','=','28')->count();
            $di_29 = DB::table('launder_dis')->where('LAUNDER_DIS_DEP','=','29')->count();
            $di_30 = DB::table('launder_dis')->where('LAUNDER_DIS_DEP','=','30')->count();  
            $di_31 = DB::table('launder_dis')->where('LAUNDER_DIS_DEP','=','31')->count(); 
            $di_32 = DB::table('launder_dis')->where('LAUNDER_DIS_DEP','=','32')->count(); 
            $di_33 = DB::table('launder_dis')->where('LAUNDER_DIS_DEP','=','33')->count(); 
            $di_34 = DB::table('launder_dis')->where('LAUNDER_DIS_DEP','=','34')->count(); 
            $di_35 = DB::table('launder_dis')->where('LAUNDER_DIS_DEP','=','35')->count(); 
            $di_36 = DB::table('launder_dis')->where('LAUNDER_DIS_DEP','=','36')->count(); 
            $di_37 = DB::table('launder_dis')->where('LAUNDER_DIS_DEP','=','37')->count(); 
            $di_38 = DB::table('launder_dis')->where('LAUNDER_DIS_DEP','=','38')->count(); 
            $di_39 = DB::table('launder_dis')->where('LAUNDER_DIS_DEP','=','39')->count();      
            $di_40 = DB::table('launder_dis')->where('LAUNDER_DIS_DEP','=','40')->count(); 

            $dw_1 = DB::table('launder_withdrow')->where('LAUNDER_WITHDROW_DEP_SUB_SUB_ID','=','1')->count();
            $dw_2 = DB::table('launder_withdrow')->where('LAUNDER_WITHDROW_DEP_SUB_SUB_ID','=','2')->count();
            $dw_3 = DB::table('launder_withdrow')->where('LAUNDER_WITHDROW_DEP_SUB_SUB_ID','=','3')->count();
            $dw_4 = DB::table('launder_withdrow')->where('LAUNDER_WITHDROW_DEP_SUB_SUB_ID','=','4')->count();
            $dw_5 = DB::table('launder_withdrow')->where('LAUNDER_WITHDROW_DEP_SUB_SUB_ID','=','5')->count();
            $dw_6 = DB::table('launder_withdrow')->where('LAUNDER_WITHDROW_DEP_SUB_SUB_ID','=','6')->count();
            $dw_7 = DB::table('launder_withdrow')->where('LAUNDER_WITHDROW_DEP_SUB_SUB_ID','=','7')->count();
            $dw_8 = DB::table('launder_withdrow')->where('LAUNDER_WITHDROW_DEP_SUB_SUB_ID','=','8')->count();
            $dw_9 = DB::table('launder_withdrow')->where('LAUNDER_WITHDROW_DEP_SUB_SUB_ID','=','9')->count();
            $dw_10 = DB::table('launder_withdrow')->where('LAUNDER_WITHDROW_DEP_SUB_SUB_ID','=','10')->count();
            $dw_11 = DB::table('launder_withdrow')->where('LAUNDER_WITHDROW_DEP_SUB_SUB_ID','=','11')->count();
            $dw_12 = DB::table('launder_withdrow')->where('LAUNDER_WITHDROW_DEP_SUB_SUB_ID','=','12')->count();
            $dw_13 = DB::table('launder_withdrow')->where('LAUNDER_WITHDROW_DEP_SUB_SUB_ID','=','13')->count();
            $dw_14 = DB::table('launder_withdrow')->where('LAUNDER_WITHDROW_DEP_SUB_SUB_ID','=','14')->count();
            $dw_15 = DB::table('launder_withdrow')->where('LAUNDER_WITHDROW_DEP_SUB_SUB_ID','=','15')->count();
            $dw_16 = DB::table('launder_withdrow')->where('LAUNDER_WITHDROW_DEP_SUB_SUB_ID','=','16')->count();
            $dw_17 = DB::table('launder_withdrow')->where('LAUNDER_WITHDROW_DEP_SUB_SUB_ID','=','17')->count();
            $dw_18 = DB::table('launder_withdrow')->where('LAUNDER_WITHDROW_DEP_SUB_SUB_ID','=','18')->count();
            $dw_19 = DB::table('launder_withdrow')->where('LAUNDER_WITHDROW_DEP_SUB_SUB_ID','=','19')->count();
            $dw_20 = DB::table('launder_withdrow')->where('LAUNDER_WITHDROW_DEP_SUB_SUB_ID','=','20')->count();
            $dw_21 = DB::table('launder_withdrow')->where('LAUNDER_WITHDROW_DEP_SUB_SUB_ID','=','21')->count();
            $dw_22 = DB::table('launder_withdrow')->where('LAUNDER_WITHDROW_DEP_SUB_SUB_ID','=','22')->count();
            $dw_23 = DB::table('launder_withdrow')->where('LAUNDER_WITHDROW_DEP_SUB_SUB_ID','=','23')->count();
            $dw_24 = DB::table('launder_withdrow')->where('LAUNDER_WITHDROW_DEP_SUB_SUB_ID','=','24')->count();
            $dw_25 = DB::table('launder_withdrow')->where('LAUNDER_WITHDROW_DEP_SUB_SUB_ID','=','25')->count();
            $dw_26 = DB::table('launder_withdrow')->where('LAUNDER_WITHDROW_DEP_SUB_SUB_ID','=','26')->count();
            $dw_27 = DB::table('launder_withdrow')->where('LAUNDER_WITHDROW_DEP_SUB_SUB_ID','=','27')->count();
            $dw_28 = DB::table('launder_withdrow')->where('LAUNDER_WITHDROW_DEP_SUB_SUB_ID','=','28')->count();
            $dw_29 = DB::table('launder_withdrow')->where('LAUNDER_WITHDROW_DEP_SUB_SUB_ID','=','29')->count();
            $dw_30 = DB::table('launder_withdrow')->where('LAUNDER_WITHDROW_DEP_SUB_SUB_ID','=','30')->count();  
            $dw_31 = DB::table('launder_withdrow')->where('LAUNDER_WITHDROW_DEP_SUB_SUB_ID','=','31')->count(); 
            $dw_32 = DB::table('launder_withdrow')->where('LAUNDER_WITHDROW_DEP_SUB_SUB_ID','=','32')->count(); 
            $dw_33 = DB::table('launder_withdrow')->where('LAUNDER_WITHDROW_DEP_SUB_SUB_ID','=','33')->count(); 
            $dw_34 = DB::table('launder_withdrow')->where('LAUNDER_WITHDROW_DEP_SUB_SUB_ID','=','34')->count(); 
            $dw_35 = DB::table('launder_withdrow')->where('LAUNDER_WITHDROW_DEP_SUB_SUB_ID','=','35')->count(); 
            $dw_36 = DB::table('launder_withdrow')->where('LAUNDER_WITHDROW_DEP_SUB_SUB_ID','=','36')->count(); 
            $dw_37 = DB::table('launder_withdrow')->where('LAUNDER_WITHDROW_DEP_SUB_SUB_ID','=','37')->count(); 
            $dw_38 = DB::table('launder_withdrow')->where('LAUNDER_WITHDROW_DEP_SUB_SUB_ID','=','38')->count(); 
            $dw_39 = DB::table('launder_withdrow')->where('LAUNDER_WITHDROW_DEP_SUB_SUB_ID','=','39')->count();      
            $dw_40 = DB::table('launder_withdrow')->where('LAUNDER_WITHDROW_DEP_SUB_SUB_ID','=','40')->count(); 
           
            $year = date('Y');
            $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

            $year_id = $year+543;

        return view('manager_launder.dashboard_launder',[
            'budgets' =>  $budget,
            'year_id'=>$year_id,
            'd_1' => $d_1,'d_2' =>$d_2, 'd_3' => $d_3,'d_4' =>$d_4, 'd_5' => $d_5,'d_6' =>$d_6, 'd_7' => $d_7,'d_8' =>$d_8, 'd_9' => $d_9,'d_10' =>$d_10,
            'd_11' => $d_11,'d_12' =>$d_12, 'd_13' => $d_13,'d_14' =>$d_14, 'd_15' => $d_15,'d_16' =>$d_16, 'd_17' => $d_17,'d_18' =>$d_18, 'd_19' => $d_19,'d_20' =>$d_20,
            'd_21' => $d_21,'d_22' =>$d_22, 'd_23' => $d_23,'d_24' =>$d_24, 'd_25' => $d_25,'d_26' =>$d_26, 'd_27' => $d_27,'d_28' =>$d_28, 'd_29' => $d_29,'d_30' =>$d_30,
            'd_31' => $d_31,'d_32' =>$d_32, 'd_33' => $d_33,'d_34' =>$d_34, 'd_35' => $d_35,'d_36' =>$d_36, 'd_37' => $d_37,'d_38' =>$d_38, 'd_39' => $d_39,'d_40' =>$d_40,

            'dw_1' => $dw_1,'dw_2' =>$dw_2, 'dw_3' => $dw_3,'dw_4' =>$dw_4, 'dw_5' => $dw_5,'dw_6' =>$dw_6, 'dw_7' => $dw_7,'dw_8' =>$dw_8, 'dw_9' => $dw_9,'dw_10' =>$dw_10,
            'dw_11' => $dw_11,'dw_12' =>$dw_12, 'dw_13' => $dw_13,'dw_14' =>$dw_14, 'dw_15' => $dw_15,'dw_16' =>$dw_16, 'dw_17' => $dw_17,'dw_18' =>$dw_18, 'dw_19' => $dw_19,'dw_20' =>$dw_20,
            'dw_21' => $dw_21,'dw_22' =>$dw_22, 'dw_23' => $dw_23,'dw_24' =>$dw_24, 'dw_25' => $dw_25,'dw_26' =>$dw_26, 'dw_27' => $dw_27,'dw_28' =>$dw_28, 'dw_29' => $dw_29,'dw_30' =>$dw_30,
            'dw_31' => $dw_31,'dw_32' =>$dw_32, 'dw_33' => $dw_33,'dw_34' =>$dw_34, 'dw_35' => $dw_35,'dw_36' =>$dw_36, 'dw_37' => $dw_37,'dw_38' =>$dw_38, 'dw_39' => $dw_39,'dw_40' =>$dw_40,

            'di_1' => $di_1,'di_2' =>$di_2, 'di_3' => $di_3,'di_4' =>$di_4, 'di_5' => $di_5,'di_6' =>$di_6, 'di_7' => $di_7,'di_8' =>$di_8, 'di_9' => $di_9,'di_10' =>$di_10,
            'di_11' => $di_11,'di_12' =>$di_12, 'di_13' => $di_13,'di_14' =>$di_14, 'di_15' => $di_15,'di_16' =>$di_16, 'di_17' => $di_17,'di_18' =>$di_18, 'di_19' => $di_19,'di_20' =>$d_20,
            'di_21' => $di_21,'di_22' =>$di_22, 'di_23' => $di_23,'di_24' =>$di_24, 'di_25' => $di_25,'di_26' =>$di_26, 'di_27' => $di_27,'di_28' =>$di_28, 'di_29' => $di_29,'di_30' =>$d_30,
            'di_31' => $di_31,'di_32' =>$di_32, 'di_33' => $di_33,'di_34' =>$di_34, 'di_35' => $di_35,'di_36' =>$di_36, 'di_37' => $di_37,'di_38' =>$di_38, 'di_39' => $di_39,'di_40' =>$d_40,

            'checkchart' =>  $check_chart,  'o_1' =>  $o_1,  'o_2' =>  $o_2,
            'getbacks' =>  $getback,
            'checks' =>  $check,
            'diss' =>  $dis,
            'withdrows' =>  $withdrow,
            'getbackchart' =>  $getback_chart,
            ]);
    }

    public function detail()
    {
        return view('manager_launder.launderdetail');
    }
    public function launder_stickersmall()
    {
    
        return view('manager_launder.launder_stickersmall');
    }
    public function launder_stickerlarge()
    {
    
        return view('manager_launder.launder_stickerlarge');
    }
    public function launder_stickersmall2()
    {
    
        return view('manager_launder.launder_stickersmall2');
    }
    public function launder_stickerlarge2()
    {
    
        return view('manager_launder.launder_stickerlarge2');
    }
    public function launder_stickerset1()
    {
    
        return view('manager_launder.launder_stickerset1');
    }
    public function launder_stickerset2()
    {
    
        return view('manager_launder.launder_stickerset2');
    }
    public function launder_stickernight()
    {
    
        return view('manager_launder.launder_stickernight');
    }
    public function launder_pay()
    {
    
        return view('manager_launder.launder_pay');
    }
    public function launder_recieve()
    {
    
        return view('manager_launder.launder_recieve');
    }
    public function launder_dispose()
    {
    
        return view('manager_launder.launder_dispose');
    }
    public function launder_static()
    {
    
        return view('manager_launder.launder_static');
    }


    public function launder_checkstock(Request $request)
    {
        if($request->method() === 'POST'){
            $search = $request->get('search');
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

        $infotype = DB::table('launder_type')
        ->where(function($q) use ($search){
            $q->where('LAUNDER_TYPE_NAME','like','%'.$search.'%');
            })
        ->get();
    
        return view('manager_launder.launder_checkstock',[
            'infotypes' => $infotype,
            'search'=> $search,
        ]);
    }


    public function launder_checkstocksearch(Request $request)
    {
        $search = $request->get('search');

        if($search==''){
            $search="";
        }

        $infotype = DB::table('launder_type')
        ->where(function($q) use ($search){
            $q->where('LAUNDER_TYPE_NAME','like','%'.$search.'%');
            })
        ->get();
    
        return view('manager_launder.launder_checkstock',[
            'infotypes' => $infotype,
            'search'=> $search,
        ]);
    }


    public function launder_checkstock_sub(Request $request,$idref)
    {

        $infotype = DB::table('launder_type')->where('LAUNDER_TYPE_ID','=',$idref)->first();

        $storereceivesub = DB::table('launder_check_sub')
        ->leftjoin('launder_check','launder_check.LAUNDER_CHECK_ID','=','launder_check_sub.LAUNDER_CHECK_ID')
        ->leftJoin('hrd_department_sub_sub','launder_check.LAUNDER_CHECK_DEP','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->where('LAUNDER_CHECK_SUB_TYPE','=',$idref)->get();
       
       
        $storeexportsub = DB::table('launder_dis_sub')
        ->leftjoin('launder_dis','launder_dis.LAUNDER_DIS_ID','=','launder_dis_sub.LAUNDER_DIS_ID')
        ->leftJoin('hrd_department_sub_sub','launder_dis.LAUNDER_DIS_DEP','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->where('LAUNDER_DIS_SUB_TYPE','=',$idref)->get();
    

        return view('manager_launder.launder_checkstock_sub',[
            'infotype' => $infotype,
            'storereceivesubs' => $storereceivesub,
            'storeexportsubs' => $storeexportsub,
        ]);
    }

    //----------------------------ตรวจสอบคลังย่อย


    public function launder_checktreasury(Request $request)
    {
        if($request->method() === 'POST'){
            $depid = $request->SEND_DEP;
            $search = $request->get('search');
            $data_search = json_encode_u([
                'depid' => $depid,
                'search' => $search,
            ]);
            Cookie::queue('data_search', $data_search, 120,$request->server('REQUEST_URI'));
        }elseif(!empty(Cookie::get('data_search'))){
            $data_search    = json_decode(Cookie::get('data_search'));
            $depid     = $data_search->depid;
            $search     = $data_search->search;
        }else{
            $depid     = '';
            $search     = '';
        }
  
        if($depid == null){
            $infotreasury= DB::table('launder_dis_sub')
            ->select('LAUNDER_TYPE_NAME', DB::raw('count(*) as total'),'HR_DEPARTMENT_SUB_SUB_NAME','LAUNDER_DIS_DEP','LAUNDER_DIS_SUB_TYPE')
            ->leftJoin('launder_dis','launder_dis_sub.LAUNDER_DIS_ID','=','launder_dis.LAUNDER_DIS_ID')
            ->leftJoin('launder_type','launder_dis_sub.LAUNDER_DIS_SUB_TYPE','=','launder_type.LAUNDER_TYPE_ID')
            ->leftJoin('hrd_department_sub_sub','launder_dis.LAUNDER_DIS_DEP','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')  
            ->where(function($q) use ($search){
                $q->where('LAUNDER_TYPE_NAME','like','%'.$search.'%');
                })
            ->groupBy('LAUNDER_TYPE_NAME','HR_DEPARTMENT_SUB_SUB_NAME','LAUNDER_DIS_DEP','LAUNDER_DIS_SUB_TYPE')
            ->orderBy('LAUNDER_DIS_DEP', 'asc')
            ->get();
        }else{
            $infotreasury= DB::table('launder_dis_sub')
            ->select('LAUNDER_TYPE_NAME', DB::raw('count(*) as total'),'HR_DEPARTMENT_SUB_SUB_NAME','LAUNDER_DIS_DEP','LAUNDER_DIS_SUB_TYPE')
            ->leftJoin('launder_dis','launder_dis_sub.LAUNDER_DIS_ID','=','launder_dis.LAUNDER_DIS_ID')
            ->leftJoin('launder_type','launder_dis_sub.LAUNDER_DIS_SUB_TYPE','=','launder_type.LAUNDER_TYPE_ID')
            ->leftJoin('hrd_department_sub_sub','launder_dis.LAUNDER_DIS_DEP','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')  
            ->where('launder_dis.LAUNDER_DIS_DEP','=',$depid)
            ->where(function($q) use ($search){
                $q->where('LAUNDER_TYPE_NAME','like','%'.$search.'%');
                })
            ->groupBy('LAUNDER_TYPE_NAME','HR_DEPARTMENT_SUB_SUB_NAME','LAUNDER_DIS_DEP','LAUNDER_DIS_SUB_TYPE')
            ->orderBy('LAUNDER_DIS_DEP', 'asc')
            ->get();
        }
        $infodep = DB::table('launder_dep')->get();
        return view('manager_launder.launder_checktreasury',[
            'infotreasurys'=>$infotreasury,
            'infodeps'=>$infodep,
            'depid_check'=> $depid,
            'search'=> $search,
        ]);
    }

    public function launder_checktreasurysearch(Request $request)
    {

        $depid = $request->SEND_DEP;
        $search = $request->get('search');
        if($search==''){
            $search="";
        }
        
        if($depid == null){


        $infotreasury= DB::table('launder_dis_sub')
        ->select('LAUNDER_TYPE_NAME', DB::raw('count(*) as total'),'HR_DEPARTMENT_SUB_SUB_NAME','LAUNDER_DIS_DEP','LAUNDER_DIS_SUB_TYPE')
        ->leftJoin('launder_dis','launder_dis_sub.LAUNDER_DIS_ID','=','launder_dis.LAUNDER_DIS_ID')
        ->leftJoin('launder_type','launder_dis_sub.LAUNDER_DIS_SUB_TYPE','=','launder_type.LAUNDER_TYPE_ID')
        ->leftJoin('hrd_department_sub_sub','launder_dis.LAUNDER_DIS_DEP','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')  
        ->where(function($q) use ($search){
            $q->where('LAUNDER_TYPE_NAME','like','%'.$search.'%');
          
            })
        ->groupBy('LAUNDER_TYPE_NAME','HR_DEPARTMENT_SUB_SUB_NAME','LAUNDER_DIS_DEP','LAUNDER_DIS_SUB_TYPE')
        ->orderBy('LAUNDER_DIS_DEP', 'asc')
        ->get();


        }else{

            $infotreasury= DB::table('launder_dis_sub')
            ->select('LAUNDER_TYPE_NAME', DB::raw('count(*) as total'),'HR_DEPARTMENT_SUB_SUB_NAME','LAUNDER_DIS_DEP','LAUNDER_DIS_SUB_TYPE')
            ->leftJoin('launder_dis','launder_dis_sub.LAUNDER_DIS_ID','=','launder_dis.LAUNDER_DIS_ID')
            ->leftJoin('launder_type','launder_dis_sub.LAUNDER_DIS_SUB_TYPE','=','launder_type.LAUNDER_TYPE_ID')
            ->leftJoin('hrd_department_sub_sub','launder_dis.LAUNDER_DIS_DEP','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')  
            ->where('launder_dis.LAUNDER_DIS_DEP','=',$depid)
            ->where(function($q) use ($search){
                $q->where('LAUNDER_TYPE_NAME','like','%'.$search.'%');
               
                })
            ->groupBy('LAUNDER_TYPE_NAME','HR_DEPARTMENT_SUB_SUB_NAME','LAUNDER_DIS_DEP','LAUNDER_DIS_SUB_TYPE')
            ->orderBy('LAUNDER_DIS_DEP', 'asc')
            ->get();
    


        }
        
        $infodep = DB::table('launder_dep')->get();
    
        return view('manager_launder.launder_checktreasury',[
            'infotreasurys'=>$infotreasury,
            'infodeps'=>$infodep,
            'depid_check'=> $depid,
            'search'=> $search,
        ]);
    }



    public function launder_checktreasury_sub(Request $request,$idtype,$iddep)
    {

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
    
        return view('manager_launder.launder_checktreasury_sub',[
            'receivesubs' =>  $receivesub,
            'nametype' =>  $nametype,
            'paysubs'=> $paysub
        ]);
    }




    public function launder_checkday()
    {
    
        return view('manager_launder.launder_checkday');
    }
    public function launder_stickercreate()
    {
    
        return view('manager_launder.launder_stickercreate');
    }
    public function launder_stickerselect()
    {
    
        return view('manager_launder.launder_stickerselect');
    }
    public function launder_stickercreate2()
    {
    
        return view('manager_launder.launder_stickercreate2');
    }
    public function launder_stickerselect2()
    {
    
        return view('manager_launder.launder_stickerselect2');
    }

//------------------------------------------------------------------------

public function launder_getre()
{

    return view('manager_launder.launder_getre');
}

public function launder_getre_dep(Request $request,$type)
{

    $infodepused = DB::table('launder_dep')->get();

    return view('manager_launder.launder_getre_dep',[
        'type' => $type,
        'infodepuseds' => $infodepused
    ]);
}


//-----------รับผ้า
public function launder_getback(Request $request)
{
    if($request->method() === 'POST'){
        $search = $request->get('search');
        $datebigin = $request->get('DATE_BIGIN');
        $dateend = $request->get('DATE_END');
        $yearbudget = $request->BUDGET_YEAR;
        $data_search = json_encode_u([
            'search' => $search,
            'yearbudget' => $yearbudget,
            'datebigin' => $datebigin,
            'dateend' => $dateend,
        ]);
        Cookie::queue('data_search', $data_search, 120,$request->server('REQUEST_URI'));
    }elseif(!empty(Cookie::get('data_search'))){
        $data_search    = json_decode(Cookie::get('data_search'));
        $search     = $data_search->search;
        $yearbudget     = $data_search->yearbudget;
        $datebigin     = $data_search->datebigin;
        $dateend     = $data_search->dateend;
    }else{
        $search     = '';
        $yearbudget = getBudgetYear();
        $datebigin  = date('01/10/'.($yearbudget-1));
        $dateend    = date('30/09/'.$yearbudget);
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
    $infogetback = DB::table('launder_getback')
    ->leftJoin('hrd_department_sub_sub','launder_getback.LAUNDER_GETBACK_DEP','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
    ->where(function($q) use ($search){
        $q->where('LAUNDER_GETBACK_CODE','like','%'.$search.'%');
        $q->orwhere('LAUNDER_GETBACK_TIME','like','%'.$search.'%');
        $q->orwhere('LAUNDER_GETBACK_STAIN','like','%'.$search.'%');
        $q->orwhere('LAUNDER_GETBACK_INFECTIOUS','like','%'.$search.'%');
        $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');
        $q->orwhere('LAUNDER_GETBACK_HR_NAME','like','%'.$search.'%');
    })
    ->WhereBetween('LAUNDER_GETBACK_DATE',[$from.' 00:00:00',$to.' 23:59:00']) 
    ->get();
    $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
    $year_id = $yearbudget;
    return view('manager_launder.launder_getback',[
        'infogetbacks' => $infogetback,
        'displaydate_bigen'=> $displaydate_bigen, 
        'displaydate_end'=> $displaydate_end,
        'search'=> $search,
        'budgets' =>  $budget,
        'year_id'=>$year_id
    ]);
}

public function launder_getbacksearch(Request $request)
{

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
    
    

    $infogetback = DB::table('launder_getback')
    ->leftJoin('hrd_department_sub_sub','launder_getback.LAUNDER_GETBACK_DEP','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
    ->where(function($q) use ($search){
        $q->where('LAUNDER_GETBACK_CODE','like','%'.$search.'%');
        $q->orwhere('LAUNDER_GETBACK_TIME','like','%'.$search.'%');
        $q->orwhere('LAUNDER_GETBACK_STAIN','like','%'.$search.'%');
        $q->orwhere('LAUNDER_GETBACK_INFECTIOUS','like','%'.$search.'%');
        $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');
        $q->orwhere('LAUNDER_GETBACK_HR_NAME','like','%'.$search.'%');
        })
        ->WhereBetween('LAUNDER_GETBACK_DATE',[$from.' 00:00:00',$to.' 23:59:00']) 
    ->get();


    $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
    $year_id = $yearbudget;

    return view('manager_launder.launder_getback',[
        'infogetbacks' => $infogetback,
        'displaydate_bigen'=> $displaydate_bigen, 
        'displaydate_end'=> $displaydate_end,
        'search'=> $search,
        'budgets' =>  $budget,
        'year_id'=>$year_id
    ]);
}

public function laundergetback_add(Request $request,$type,$iddep)
{
    $id_user = Auth::user()->PERSON_ID;  
    $infoperson = DB::table('hrd_person')->where('ID','=', $id_user)->first();

    if($iddep == 'null'){
        $infodep = '';
    }else{
        $infodep = DB::table('hrd_department_sub_sub')->where('HR_DEPARTMENT_SUB_SUB_ID','=',$iddep)->first();
    }
  

    $infodepselect = DB::table('launder_dep')->get();

   

    return view('manager_launder.laundergetback_add',[
            'infodep' => $infodep,
            'infoperson' => $infoperson,
            'infodepselects' => $infodepselect,

    ]);
}

public function laundergetback_update(Request $request)
{
   


    $LAUNDERGETBACK_DATE = $request->LAUNDER_GETBACK_DATE;

    $date_bigin = Carbon::createFromFormat('d/m/Y', $LAUNDERGETBACK_DATE)->format('Y-m-d');
    $date_arrary=explode("-",$date_bigin);
    $y_sub_st = $date_arrary[0];

    if($y_sub_st >= 2500){
        $y = $y_sub_st-543;
    }else{
        $y = $y_sub_st;
    }

    $m = $date_arrary[1];
    $d = $date_arrary[2];  
    $LAUNDER_GETBACK_DATE= $y."-".$m."-".$d;
       
    $addinfomation = new Laundergetback(); 
    $addinfomation->LAUNDER_GETBACK_CODE = $request->LAUNDER_GETBACK_CODE;
    $addinfomation->LAUNDER_GETBACK_DATE = $LAUNDER_GETBACK_DATE;
    $addinfomation->LAUNDER_GETBACK_TIME = $request->LAUNDER_GETBACK_TIME;
    $addinfomation->LAUNDER_GETBACK_DEP = $request->LAUNDER_GETBACK_DEP;
    $addinfomation->LAUNDER_GETBACK_STAIN = $request->LAUNDER_GETBACK_STAIN;
    $addinfomation->LAUNDER_GETBACK_INFECTIOUS = $request->LAUNDER_GETBACK_INFECTIOUS;
    $addinfomation->LAUNDER_GETBACK_HR_ID = $request->LAUNDER_GETBACK_HR_ID;
    $addinfomation->LAUNDER_GETBACK_HR_NAME = $request->LAUNDER_GETBACK_HR_NAME;
    $addinfomation->LAUNDER_GETBACK_ROUND = $request->LAUNDER_GETBACK_ROUND;
    $addinfomation->save();


    return redirect()->route('launder.launder_getre_dep',['type' => 'receive']);
}



public function laundergetback_edit(Request $request,$type,$iddep,$idref_l)
{
    $id_user = Auth::user()->PERSON_ID;  
    $infoperson = DB::table('hrd_person')->where('ID','=', $id_user)->first();

    if($iddep == 'null'){
        $infodep = '';
    }else{
        $infodep = DB::table('hrd_department_sub_sub')->where('HR_DEPARTMENT_SUB_SUB_ID','=',$iddep)->first();
    }
  

    $infodepselect = DB::table('launder_dep')->get();

   $infol = DB::table('launder_getback')->where('LAUNDER_GETBACK_ID','=',$idref_l)->first();

    return view('manager_launder.laundergetback_edit',[
            'infodep' => $infodep,
            'infoperson' => $infoperson,
            'infodepselects' => $infodepselect,
            'idref_l' => $idref_l,
            'infol' => $infol,

    ]);
}

public function laundergetback_update_edit(Request $request)
{
    $LAUNDERGETBACK_DATE = $request->LAUNDER_GETBACK_DATE;

    $date_bigin = Carbon::createFromFormat('d/m/Y', $LAUNDERGETBACK_DATE)->format('Y-m-d');
    $date_arrary=explode("-",$date_bigin);
    $y_sub_st = $date_arrary[0];

    if($y_sub_st >= 2500){
        $y = $y_sub_st-543;
    }else{
        $y = $y_sub_st;
    }

    $m = $date_arrary[1];
    $d = $date_arrary[2];  
    $LAUNDER_GETBACK_DATE= $y."-".$m."-".$d;
       
    $idref_l = $request->idref_l;

    $addinfomation = Laundergetback::find($idref_l); 
    $addinfomation->LAUNDER_GETBACK_CODE = $request->LAUNDER_GETBACK_CODE;
    $addinfomation->LAUNDER_GETBACK_DATE = $LAUNDER_GETBACK_DATE;
    $addinfomation->LAUNDER_GETBACK_TIME = $request->LAUNDER_GETBACK_TIME;
    $addinfomation->LAUNDER_GETBACK_DEP = $request->LAUNDER_GETBACK_DEP;
    $addinfomation->LAUNDER_GETBACK_STAIN = $request->LAUNDER_GETBACK_STAIN;
    $addinfomation->LAUNDER_GETBACK_INFECTIOUS = $request->LAUNDER_GETBACK_INFECTIOUS;
    $addinfomation->LAUNDER_GETBACK_HR_ID = $request->LAUNDER_GETBACK_HR_ID;
    $addinfomation->LAUNDER_GETBACK_HR_NAME = $request->LAUNDER_GETBACK_HR_NAME;
    $addinfomation->LAUNDER_GETBACK_ROUND = $request->LAUNDER_GETBACK_ROUND;
    $addinfomation->save();


    return redirect()->route('launder.launder_getback');
}


//----------------------ตรวจสอบผ้า

public function launder_check(Request $request)
{
    if($request->method() === 'POST'){
        $search = $request->get('search');
        $datebigin = $request->get('DATE_BIGIN');
        $dateend = $request->get('DATE_END');
        $yearbudget = $request->BUDGET_YEAR;
        $data_search = json_encode_u([
            'search' => $search,
            'yearbudget' => $yearbudget,
            'datebigin' => $datebigin,
            'dateend' => $dateend,
        ]);
        Cookie::queue('data_search', $data_search, 120,$request->server('REQUEST_URI'));
    }elseif(!empty(Cookie::get('data_search'))){
        $data_search    = json_decode(Cookie::get('data_search'));
        $search     = $data_search->search;
        $yearbudget     = $data_search->yearbudget;
        $datebigin     = $data_search->datebigin;
        $dateend     = $data_search->dateend;
    }else{
        $search     = '';
        $yearbudget = getBudgetYear();
        $datebigin  = date('d/m/Y');
        $dateend    = date('d/m/Y');
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
    $infocheck = DB::table('launder_check')
    ->leftJoin('hrd_department_sub_sub','launder_check.LAUNDER_CHECK_DEP','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
    ->where(function($q) use ($search){
        $q->where('LAUNDER_CHECK_TIME','like','%'.$search.'%');
        $q->orwhere('LAUNDER_CHECK_CODE','like','%'.$search.'%');
        $q->orwhere('LAUNDER_CHECK_ACCEPT','like','%'.$search.'%');
        $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');
        $q->orwhere('LAUNDER_CHECK_HR_NAME','like','%'.$search.'%');
        })
        ->WhereBetween('LAUNDER_CHECK_DATE',[$from.' 00:00:00',$to.' 23:59:00']) 
    ->get();
    $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
    $year_id = $yearbudget;
    return view('manager_launder.launder_check',[
        'infochecks' => $infocheck,
        'displaydate_bigen'=> $displaydate_bigen, 
        'displaydate_end'=> $displaydate_end,
        'search'=> $search,
        'budgets' =>  $budget,
        'year_id'=>$year_id
    ]);
}

public function launder_checksearch(Request $request)
{
     
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

    $infocheck = DB::table('launder_check')
    ->leftJoin('hrd_department_sub_sub','launder_check.LAUNDER_CHECK_DEP','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
    ->where(function($q) use ($search){
        $q->where('LAUNDER_CHECK_TIME','like','%'.$search.'%');
        $q->orwhere('LAUNDER_CHECK_CODE','like','%'.$search.'%');
        $q->orwhere('LAUNDER_CHECK_ACCEPT','like','%'.$search.'%');
        $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');
        $q->orwhere('LAUNDER_CHECK_HR_NAME','like','%'.$search.'%');
        })
        ->WhereBetween('LAUNDER_CHECK_DATE',[$from.' 00:00:00',$to.' 23:59:00']) 
    
    ->get();

    $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
    $year_id = $yearbudget;


    return view('manager_launder.launder_check',[
        'infochecks' => $infocheck,
        'displaydate_bigen'=> $displaydate_bigen, 
        'displaydate_end'=> $displaydate_end,
        'search'=> $search,
        'budgets' =>  $budget,
        'year_id'=>$year_id
    ]);
}



public function laundercheck_add(Request $request,$type,$iddep)
{
    $id_user = Auth::user()->PERSON_ID;  
    $infoperson = DB::table('hrd_person')->where('ID','=', $id_user)->first();
  
    $infotype= DB::table('launder_type')->get();

 
    if($iddep == 'null'){
        $infodep = '';
    }else{
        $infodep = DB::table('hrd_department_sub_sub')->where('HR_DEPARTMENT_SUB_SUB_ID','=',$iddep)->first();

    }
  

    $infodepselect = DB::table('launder_dep')->get();


    return view('manager_launder.laundercheck_add',[
            'infodep' => $infodep,
            'infoperson' => $infoperson,
            'infotypes' => $infotype,
            'infodepselects' => $infodepselect,
            
    ]);
}


public function launder_check_edit(Request $request,$idref)
{
    $id_user = Auth::user()->PERSON_ID;  
    $infoperson = DB::table('hrd_person')->where('ID','=', $id_user)->first();
 
     $infocheck = DB::table('launder_check')->where('LAUNDER_CHECK_ID','=',$idref)->first();
     $infodep = DB::table('hrd_department_sub_sub')->where('HR_DEPARTMENT_SUB_SUB_ID','=',$infocheck->LAUNDER_CHECK_DEP)->first();

    
     $infochecksub = DB::table('launder_check_sub')->where('LAUNDER_CHECK_ID','=',$infocheck->LAUNDER_CHECK_ID)->get();
    
     $infotype= DB::table('launder_type')->get();

    return view('manager_launder.launder_check_edit',[
            'infodep' => $infodep,
            'infoperson' => $infoperson,
            'infotypes' => $infotype,
            'infocheck' => $infocheck,
            'infochecksubs' => $infochecksub,
    ]);
}




public function laundercheck_update(Request $request)
{
   

    $LAUNDERCHECK_DATE = $request->LAUNDER_CHECK_DATE;

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
    $LAUNDER_CHECK_DATE= $y."-".$m."-".$d;
       
    $addinfomation = new Laundercheck(); 
    $addinfomation->LAUNDER_CHECK_CODE = $request->LAUNDER_CHECK_CODE;
    $addinfomation->LAUNDER_CHECK_DATE = $LAUNDER_CHECK_DATE;
    $addinfomation->LAUNDER_CHECK_TIME = $request->LAUNDER_CHECK_TIME;
    $addinfomation->LAUNDER_CHECK_DEP = $request->LAUNDER_CHECK_DEP;
    $addinfomation->LAUNDER_CHECK_HR_ID = $request->LAUNDER_CHECK_HR_ID;
    $addinfomation->LAUNDER_CHECK_HR_NAME = $request->LAUNDER_CHECK_HR_NAME;
    $addinfomation->LAUNDER_CHECK_ACCEPT = $request->LAUNDER_CHECK_ACCEPT;
    $addinfomation->LAUNDER_CHECK_FROM = $request->LAUNDER_CHECK_FROM;

    
    $addinfomation->save();



    $LAUNDER_CHECK_ID  = Laundercheck::max('LAUNDER_CHECK_ID');
    
    if($request->LAUNDER_CHECK_SUB_TYPE[0] != '' || $request->LAUNDER_CHECK_SUB_TYPE[0] != null){
        
        $LAUNDER_CHECK_SUB_TYPE = $request->LAUNDER_CHECK_SUB_TYPE;
        $LAUNDER_CHECK_SUB_AMOUNT = $request->LAUNDER_CHECK_SUB_AMOUNT;


        $number =count($LAUNDER_CHECK_SUB_TYPE);
        $count = 0;
        for($count = 0; $count < $number; $count++)
        {  
      
           $addSuppliesconboard = new Launderchecksub();
           $addSuppliesconboard->LAUNDER_CHECK_ID = $LAUNDER_CHECK_ID;
           $addSuppliesconboard->LAUNDER_CHECK_SUB_TYPE = $LAUNDER_CHECK_SUB_TYPE[$count];
           $addSuppliesconboard->LAUNDER_CHECK_SUB_AMOUNT = $LAUNDER_CHECK_SUB_AMOUNT[$count];
           $addSuppliesconboard->save(); 
         
           
        }
    }




    return redirect()->route('launder.launder_getre_dep',['type' => 'check']);
}

public function laundercheck_updateedit(Request $request)
{
   

    $LAUNDERCHECK_DATE = $request->LAUNDER_CHECK_DATE;

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
    $LAUNDER_CHECK_DATE= $y."-".$m."-".$d;
       
    $idref = $request->LAUNDER_CHECK_ID;
    $addinfomation = Laundercheck::find($idref); 
    $addinfomation->LAUNDER_CHECK_CODE = $request->LAUNDER_CHECK_CODE;
    $addinfomation->LAUNDER_CHECK_DATE = $LAUNDER_CHECK_DATE;
    $addinfomation->LAUNDER_CHECK_TIME = $request->LAUNDER_CHECK_TIME;
    $addinfomation->LAUNDER_CHECK_DEP = $request->LAUNDER_CHECK_DEP;
    $addinfomation->LAUNDER_CHECK_HR_ID = $request->LAUNDER_CHECK_HR_ID;
    $addinfomation->LAUNDER_CHECK_HR_NAME = $request->LAUNDER_CHECK_HR_NAME;
    $addinfomation->LAUNDER_CHECK_ACCEPT = $request->LAUNDER_CHECK_ACCEPT;
    $addinfomation->LAUNDER_CHECK_FROM = $request->LAUNDER_CHECK_FROM;

    
    $addinfomation->save();



    $LAUNDER_CHECK_ID  = $idref;
    Launderchecksub::where('LAUNDER_CHECK_ID','=',$LAUNDER_CHECK_ID)->delete();
    
    if($request->LAUNDER_CHECK_SUB_TYPE[0] != '' || $request->LAUNDER_CHECK_SUB_TYPE[0] != null){
        
        $LAUNDER_CHECK_SUB_TYPE = $request->LAUNDER_CHECK_SUB_TYPE;
        $LAUNDER_CHECK_SUB_AMOUNT = $request->LAUNDER_CHECK_SUB_AMOUNT;


        $number =count($LAUNDER_CHECK_SUB_TYPE);
        $count = 0;
        for($count = 0; $count < $number; $count++)
        {  
           $addSuppliesconboard = new Launderchecksub();
           $addSuppliesconboard->LAUNDER_CHECK_ID = $LAUNDER_CHECK_ID;
           $addSuppliesconboard->LAUNDER_CHECK_SUB_TYPE = $LAUNDER_CHECK_SUB_TYPE[$count];
           $addSuppliesconboard->LAUNDER_CHECK_SUB_AMOUNT = $LAUNDER_CHECK_SUB_AMOUNT[$count];
           $addSuppliesconboard->save(); 
         
           
        }
    }




    return redirect()->route('launder.launder_check');
}

//-------------------------ส่งผ้า

public function launder_disburse(Request $request)
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
        $launderwithdrow = DB::table('launder_withdrow')
            ->leftJoin('hrd_person','launder_withdrow.LAUNDER_WITHDROW_HR_ID','=','hrd_person.ID')
            ->leftJoin('hrd_department_sub_sub','launder_withdrow.LAUNDER_WITHDROW_DEP_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
            ->where(function($q) use ($search){
                $q->where('LAUNDER_WITHDROW_CODE','like','%'.$search.'%');
                $q->orwhere('LAUNDER_WITHDROW_TIME','like','%'.$search.'%');
                $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');
                $q->orwhere('HR_FNAME','like','%'.$search.'%');
                $q->orwhere('HR_LNAME','like','%'.$search.'%');
                $q->orwhere('LAUNDER_WITHDROW_PAY_HD_NAME','like','%'.$search.'%');
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
                $q->orwhere('LAUNDER_WITHDROW_TIME','like','%'.$search.'%');
                $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');
                $q->orwhere('HR_FNAME','like','%'.$search.'%');
                $q->orwhere('HR_LNAME','like','%'.$search.'%');
                $q->orwhere('LAUNDER_WITHDROW_PAY_HD_NAME','like','%'.$search.'%');
                })
                ->WhereBetween('LAUNDER_WITHDROW_DATE',[$from.' 00:00:00',$to.' 23:59:00']) 
            ->orderBy('LAUNDER_WITHDROW_DATE', 'desc')->get();
    }
    $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
    $year_id = $yearbudget;
    $infostatus = DB::table('launder_dis_status')->get();
    return view('manager_launder.launder_disburse',[
        'launderwithdrows'=>  $launderwithdrow,
        'infostatuss' => $infostatus,
        'displaydate_bigen'=> $displaydate_bigen, 
        'displaydate_end'=> $displaydate_end,
        'status_check'=> $status,
        'search'=> $search,
        'budgets' =>  $budget,
        'year_id'=>$year_id 
    ]);
}



public function launder_disbursesearch(Request $request)
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

           $from = date($displaydate_bigen);
           $to = date($displaydate_end);   


            if($status == null){
                $launderwithdrow = DB::table('launder_withdrow')
                ->leftJoin('hrd_person','launder_withdrow.LAUNDER_WITHDROW_HR_ID','=','hrd_person.ID')
                ->leftJoin('hrd_department_sub_sub','launder_withdrow.LAUNDER_WITHDROW_DEP_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
                ->where(function($q) use ($search){
                    $q->where('LAUNDER_WITHDROW_CODE','like','%'.$search.'%');
                    $q->orwhere('LAUNDER_WITHDROW_TIME','like','%'.$search.'%');
                    $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');
                    $q->orwhere('HR_FNAME','like','%'.$search.'%');
                    $q->orwhere('HR_LNAME','like','%'.$search.'%');
                    $q->orwhere('LAUNDER_WITHDROW_PAY_HD_NAME','like','%'.$search.'%');
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
                    $q->orwhere('LAUNDER_WITHDROW_TIME','like','%'.$search.'%');
                    $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');
                    $q->orwhere('HR_FNAME','like','%'.$search.'%');
                    $q->orwhere('HR_LNAME','like','%'.$search.'%');
                    $q->orwhere('LAUNDER_WITHDROW_PAY_HD_NAME','like','%'.$search.'%');
                    })
                    ->WhereBetween('LAUNDER_WITHDROW_DATE',[$from.' 00:00:00',$to.' 23:59:00']) 
                ->orderBy('LAUNDER_WITHDROW_DATE', 'desc')->get();




            }

            
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $year_id = $yearbudget;

        $infostatus = DB::table('launder_dis_status')->get();

    return view('manager_launder.launder_disburse',[
        'launderwithdrows'=>  $launderwithdrow,
        'infostatuss' => $infostatus,
        'displaydate_bigen'=> $displaydate_bigen, 
        'displaydate_end'=> $displaydate_end,
        'status_check'=> $status,
        'search'=> $search,
        'budgets' =>  $budget,
        'year_id'=>$year_id 
    ]);
}



public function launder_send(Request $request)
{
    if($request->method() === 'POST'){ 
        $search     = $request->get('search');
        $datebigin  = $request->get('DATE_BIGIN');
        $dateend    = $request->get('DATE_END');
        $yearbudget = $request->BUDGET_YEAR;
        $data_search = json_encode_u([
            'search' => $search,
            'yearbudget' => $yearbudget,
            'datebigin' => $datebigin,
            'dateend' => $dateend,
        ]);
        Cookie::queue('data_search', $data_search, 120,$request->server('REQUEST_URI'));
    }elseif(!empty(Cookie::get('data_search'))){
        $data_search    = json_decode(Cookie::get('data_search'));
        $search     = $data_search->search;
        $yearbudget     = $data_search->yearbudget;
        $datebigin     = $data_search->datebigin;
        $dateend     = $data_search->dateend;
    }else{
        $search     = '';
        $yearbudget = getBudgetYear();
        $datebigin  = date('d/m/Y');
        $dateend    = date('d/m/Y');
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
    $infodis = DB::table('launder_dis')
    ->leftJoin('hrd_department_sub_sub','launder_dis.LAUNDER_DIS_DEP','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
    ->where(function($q) use ($search){
        $q->where('LAUNDER_DIS_TIME','like','%'.$search.'%');
        $q->orwhere('LAUNDER_DIS_CODE','like','%'.$search.'%');
        $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');
        $q->orwhere('LAUNDER_DIS_HR_NAME','like','%'.$search.'%');
        })
        ->WhereBetween('LAUNDER_DIS_DATE',[$from.' 00:00:00',$to.' 23:59:00']) 
    ->get();
    $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
    $year_id = $yearbudget;

    return view('manager_launder.launder_send',[
       'infodiss' => $infodis,
       'displaydate_bigen'=> $displaydate_bigen, 
       'displaydate_end'=> $displaydate_end,
       'search'=> $search,
       'budgets' =>  $budget,
       'year_id'=>$year_id
    ]);
}


public function launder_sendsearch(Request $request)
{

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

       

    $infodis = DB::table('launder_dis')
    ->leftJoin('hrd_department_sub_sub','launder_dis.LAUNDER_DIS_DEP','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
    ->where(function($q) use ($search){
        $q->where('LAUNDER_DIS_TIME','like','%'.$search.'%');
        $q->orwhere('LAUNDER_DIS_CODE','like','%'.$search.'%');
        $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');
        $q->orwhere('LAUNDER_DIS_HR_NAME','like','%'.$search.'%');
        })
        ->WhereBetween('LAUNDER_DIS_DATE',[$from.' 00:00:00',$to.' 23:59:00']) 
    ->get();

    $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
    $year_id = $yearbudget;

    return view('manager_launder.launder_send',[
       'infodiss' => $infodis,
       'displaydate_bigen'=> $displaydate_bigen, 
       'displaydate_end'=> $displaydate_end,
       'search'=> $search,
       'budgets' =>  $budget,
       'year_id'=>$year_id
    ]);
}



public function launder_send_edit(Request $request,$idref)
{
    $id_user = Auth::user()->PERSON_ID;  
    $infoperson = DB::table('hrd_person')->where('ID','=', $id_user)->first();
 
     $infocheck = DB::table('launder_dis')->where('LAUNDER_DIS_ID','=',$idref)->first();
     $infodep = DB::table('hrd_department_sub_sub')->where('HR_DEPARTMENT_SUB_SUB_ID','=',$infocheck->LAUNDER_DIS_DEP)->first();

    
     $infochecksub = DB::table('launder_dis_sub')->where('LAUNDER_DIS_ID','=',$infocheck->LAUNDER_DIS_ID)->get();
    
     $infotype= DB::table('launder_type')->get();
     $inforef= DB::table('launder_withdrow')
     ->leftjoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','launder_withdrow.LAUNDER_WITHDROW_DEP_SUB_SUB_ID')
     ->get();


    return view('manager_launder.launder_send_edit',[
            'infodep' => $infodep,
            'infoperson' => $infoperson,
            'infotypes' => $infotype,
            'infocheck' => $infocheck,
            'infochecksubs' => $infochecksub,
            'inforefs' => $inforef
    ]);
}


public function launderdisburse_add(Request $request,$type,$iddep)
{
    $id_user = Auth::user()->PERSON_ID;  
    $infoperson = DB::table('hrd_person')->where('ID','=', $id_user)->first();
   

    $infotype= DB::table('launder_type')->get();


    


    if($iddep == 'null'){
        $infodep = '';
        $inforef= DB::table('launder_withdrow')
        ->leftjoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','launder_withdrow.LAUNDER_WITHDROW_DEP_SUB_SUB_ID')
        ->where('LAUNDER_WITHDROW_STATUS','=','Request')
        ->get();

    }else{
        $inforef= DB::table('launder_withdrow')
        ->leftjoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','launder_withdrow.LAUNDER_WITHDROW_DEP_SUB_SUB_ID')
        ->where('LAUNDER_WITHDROW_DEP_SUB_SUB_ID','=',$iddep)
        ->where('LAUNDER_WITHDROW_STATUS','=','Request')
        ->get();
        $infodep = DB::table('hrd_department_sub_sub')->where('HR_DEPARTMENT_SUB_SUB_ID','=',$iddep)->first();
    }
  

    $infodepselect = DB::table('launder_dep')->get();




    return view('manager_launder.launderdisburse_add',[
            'infodep' => $infodep,
            'infoperson' => $infoperson,
            'infotypes' => $infotype,
            'infodepselects' => $infodepselect,
            'inforefs' => $inforef
           
    ]);
}

public function launderdisburse_update(Request $request)
{
   
    $LAUNDERDIS_DATE = $request->LAUNDER_DIS_DATE;

    $date_bigin = Carbon::createFromFormat('d/m/Y', $LAUNDERDIS_DATE)->format('Y-m-d');
    $date_arrary=explode("-",$date_bigin);
    $y_sub_st = $date_arrary[0];

    if($y_sub_st >= 2500){
        $y = $y_sub_st-543;
    }else{
        $y = $y_sub_st;
    }

    $m = $date_arrary[1];
    $d = $date_arrary[2];  
    $LAUNDER_DIS_DATE= $y."-".$m."-".$d;
       
    $addinfomation = new Launderdis(); 
    $addinfomation->LAUNDER_DIS_CODE = $request->LAUNDER_DIS_CODE;
    $addinfomation->LAUNDER_DIS_DATE = $LAUNDER_DIS_DATE;
    $addinfomation->LAUNDER_DIS_TIME = $request->LAUNDER_DIS_TIME;
    $addinfomation->LAUNDER_DIS_DEP = $request->LAUNDER_DIS_DEP;
    $addinfomation->LAUNDER_DIS_HR_ID = $request->LAUNDER_DIS_HR_ID;
    $addinfomation->LAUNDER_DIS_HR_NAME = $request->LAUNDER_DIS_HR_NAME;
    $addinfomation->LAUNDER_DIS_REF = $request->LAUNDER_CHECK_REF;
    $addinfomation->save();



    $LAUNDER_DIS_ID  = Launderdis::max('LAUNDER_DIS_ID');
    
    if($request->LAUNDER_DIS_SUB_TYPE[0] != '' || $request->LAUNDER_DIS_SUB_TYPE[0] != null){
        
        $LAUNDER_DIS_SUB_TYPE = $request->LAUNDER_DIS_SUB_TYPE;
        $LAUNDER_DIS_SUB_AMOUNT = $request->LAUNDER_DIS_SUB_AMOUNT;


        $number =count($LAUNDER_DIS_SUB_TYPE);
        $count = 0;
        for($count = 0; $count < $number; $count++)
        {  
           $addSuppliesconboard = new Launderdissub();
           $addSuppliesconboard->LAUNDER_DIS_ID = $LAUNDER_DIS_ID;
           $addSuppliesconboard->LAUNDER_DIS_SUB_TYPE = $LAUNDER_DIS_SUB_TYPE[$count];
           $addSuppliesconboard->LAUNDER_DIS_SUB_AMOUNT = $LAUNDER_DIS_SUB_AMOUNT[$count];
           $addSuppliesconboard->save(); 
           
        }
    }


    //----------------------อัปเดจข้อมูลการเบิกจ่าย------


     
    $LAUNDERDIS_DATE = $request->LAUNDER_DIS_DATE;

    $date_bigin = Carbon::createFromFormat('d/m/Y', $LAUNDERDIS_DATE)->format('Y-m-d');
    $date_arrary=explode("-",$date_bigin);
    $y_sub_st = $date_arrary[0];

    if($y_sub_st >= 2500){
        $y = $y_sub_st-543;
    }else{
        $y = $y_sub_st;
    }

    $m = $date_arrary[1];
    $d = $date_arrary[2];  
    $LAUNDERDISDATE= $y."-".$m."-".$d;



    $LAUNDERWITHDROW_ID  = $request->LAUNDER_CHECK_REF;
       
    $addinfomation =  Launderwithdrow::find($LAUNDERWITHDROW_ID); 
    $addinfomation->LAUNDER_WITHDROW_STATUS = 'Success';
    $addinfomation->LAUNDER_WITHDROW_PAY_DATE = $LAUNDERDISDATE;
    $addinfomation->LAUNDER_WITHDROW_PAY_TIME = $request->LAUNDER_DIS_TIME;
    $addinfomation->LAUNDER_WITHDROW_PAY_HD_ID = $request->LAUNDER_DIS_HR_ID;
    $addinfomation->LAUNDER_WITHDROW_PAY_HD_NAME = $request->LAUNDER_DIS_HR_NAME;
  
    $addinfomation->save();
    
    
    Launderwithdrowsub::where('LAUNDER_WITHDROW_ID','=',$LAUNDERWITHDROW_ID)->delete();
  
    
    if($request->LAUNDER_DIS_SUB_TYPE[0] != '' || $request->LAUNDER_DIS_SUB_TYPE[0] != null){
        
        $LAUNDER_DIS_SUB_TYPE = $request->LAUNDER_DIS_SUB_TYPE;
        $LAUNDER_DIS_SUB_AMOUNTRE = $request->LAUNDER_DIS_SUB_AMOUNTRE;
        $LAUNDER_DIS_SUB_AMOUNT = $request->LAUNDER_DIS_SUB_AMOUNT;

        $number =count($LAUNDER_DIS_SUB_TYPE);
        $count = 0;
        for($count = 0; $count < $number; $count++)
        {  
           $add = new Launderwithdrowsub();
           $add->LAUNDER_WITHDROW_ID = $LAUNDERWITHDROW_ID;
           $add->LAUNDER_WITHDROW_SUB_TYPE = $LAUNDER_DIS_SUB_TYPE[$count];
           $add->LAUNDER_WITHDROW_SUB_AMOUNT = $LAUNDER_DIS_SUB_AMOUNTRE[$count];
           $add->LAUNDER_WITHDROW_SUB_AMOUNTPAY = $LAUNDER_DIS_SUB_AMOUNT[$count];
           $add->save(); 
         
           
        }
    }



    //----------------------------------------ตัดสต็อกจากคลังย่อย


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
  
    
    $addinfomation = new Launderpay(); 
    $addinfomation->LAUNDER_PAY_CODE = $refnumber;
    $addinfomation->LAUNDER_PAY_DATE = date('Y-m-d');
    $addinfomation->LAUNDER_PAY_COMMENT = 'ตัดจ่ายจากเจ้าหน้าที่';
    $addinfomation->LAUNDER_PAY_SAVE_HR_ID = $request->LAUNDER_DIS_HR_ID;
    $addinfomation->LAUNDER_PAY_SAVE_HR_NAME = $request->LAUNDER_DIS_HR_NAME;

    $addinfomation->LAUNDER_PAY_DEP = $request->LAUNDER_DIS_DEP;
    $INFODEP = DB::table('hrd_department_sub_sub')->where('HR_DEPARTMENT_SUB_SUB_ID','=',$request->LAUNDER_DIS_DEP)->first();

    $addinfomation->LAUNDER_PAY_TREASURT_NAME = $INFODEP->HR_DEPARTMENT_SUB_SUB_NAME;

    $addinfomation->save();



    $LAUNDERPAY_ID  = Launderpay::max('LAUNDER_PAY_ID');
    
    if($request->LAUNDER_DIS_SUB_TYPE[0] != '' || $request->LAUNDER_DIS_SUB_TYPE[0] != null){
        
        $LAUNDER_DIS_SUB_TYPE = $request->LAUNDER_DIS_SUB_TYPE;
        $LAUNDER_DIS_SUB_AMOUNTRE = $request->LAUNDER_DIS_SUB_AMOUNTRE;


        $number =count($LAUNDER_DIS_SUB_TYPE);
        $count = 0;
        for($count = 0; $count < $number; $count++)
        {  
    
        $addpaysub = new Launderpaysub();
        $addpaysub->LAUNDER_PAY_ID = $LAUNDERPAY_ID;
        $addpaysub->LAUNDER_PAY_SUB_TYPEID = $LAUNDER_DIS_SUB_TYPE[$count];
        $addpaysub->LAUNDER_PAY_SUB_AMOUNT = $LAUNDER_DIS_SUB_AMOUNTRE[$count];
        $addpaysub->save(); 
        
        
        }
    }




    return redirect()->route('launder.launder_getre_dep',['type' => 'send']);
}


public function launderdisburse_updateedit(Request $request)
{
   
    $LAUNDERDIS_DATE = $request->LAUNDER_DIS_DATE;

    $date_bigin = Carbon::createFromFormat('d/m/Y', $LAUNDERDIS_DATE)->format('Y-m-d');
    $date_arrary=explode("-",$date_bigin);
    $y_sub_st = $date_arrary[0];

    if($y_sub_st >= 2500){
        $y = $y_sub_st-543;
    }else{
        $y = $y_sub_st;
    }

    $m = $date_arrary[1];
    $d = $date_arrary[2];  
    $LAUNDER_DIS_DATE= $y."-".$m."-".$d;
       
    $numref = $request->LAUNDER_DIS_ID;
    $addinfomation = Launderdis::find($numref); 
    $addinfomation->LAUNDER_DIS_CODE = $request->LAUNDER_DIS_CODE;
    $addinfomation->LAUNDER_DIS_DATE = $LAUNDER_DIS_DATE;
    $addinfomation->LAUNDER_DIS_TIME = $request->LAUNDER_DIS_TIME;
    $addinfomation->LAUNDER_DIS_DEP = $request->LAUNDER_DIS_DEP;
    $addinfomation->LAUNDER_DIS_HR_ID = $request->LAUNDER_DIS_HR_ID;
    $addinfomation->LAUNDER_DIS_HR_NAME = $request->LAUNDER_DIS_HR_NAME;
    $addinfomation->LAUNDER_DIS_REF = $request->LAUNDER_CHECK_REF;
    $addinfomation->save();



    $LAUNDER_DIS_ID  = $numref;
    Launderdissub::where('LAUNDER_DIS_ID','=',$LAUNDER_DIS_ID)->delete();
    
    if($request->LAUNDER_DIS_SUB_TYPE[0] != '' || $request->LAUNDER_DIS_SUB_TYPE[0] != null){
        
        $LAUNDER_DIS_SUB_TYPE = $request->LAUNDER_DIS_SUB_TYPE;
        $LAUNDER_DIS_SUB_AMOUNT = $request->LAUNDER_DIS_SUB_AMOUNT;


        $number =count($LAUNDER_DIS_SUB_TYPE);
        $count = 0;
        for($count = 0; $count < $number; $count++)
        {  
      
           $addSuppliesconboard = new Launderdissub();
           $addSuppliesconboard->LAUNDER_DIS_ID = $LAUNDER_DIS_ID;
           $addSuppliesconboard->LAUNDER_DIS_SUB_TYPE = $LAUNDER_DIS_SUB_TYPE[$count];
           $addSuppliesconboard->LAUNDER_DIS_SUB_AMOUNT = $LAUNDER_DIS_SUB_AMOUNT[$count];
           $addSuppliesconboard->save(); 
         
           
        }
    }







    return redirect()->route('launder.launder_send');
}


//=====================ตั้งค่าเสื้อผ้า==========================


public function launder_clothingtype()
{    
    $infotype = Laundertype::get();

    return view('manager_launder.launder_clothingtype',[
        'infotypes' =>$infotype
    ]);

}

public function launder_clothingtype_add()
{    

    return view('manager_launder.launder_clothingtype_add');

}


public function launder_clothingtype_save(Request $request)
{    

    $add = new Laundertype();
    $add->LAUNDER_TYPE_NAME = $request->LAUNDER_TYPE_NAME;
    $add->save(); 

    return redirect()->route('launder.launder_clothingtype');

}

public function launder_clothingtype_edit(Request $request,$idref)
{    
     $infotyperef= Laundertype::where('LAUNDER_TYPE_ID','=',$idref)->first();
    return view('manager_launder.launder_clothingtype_edit',[
        'infotyperef'=>$infotyperef
    ]);
}

public function launder_clothingtype_update(Request $request)
{    
    $id =  $request->LAUNDER_TYPE_ID;
    $update =  Laundertype::find($id);
    $update->LAUNDER_TYPE_NAME = $request->LAUNDER_TYPE_NAME;
    $update->save(); 
    return redirect()->route('launder.launder_clothingtype');
}






function launder_clothingtype_destroy($idref) { 
                
    Laundertype::destroy($idref);         
    return redirect()->route('launder.launder_clothingtype');
  
}



//================================ตั้งค่าหน่วยงาน


public function launder_dep()
{    
    $infolaunderdep = DB::table('launder_dep')->get();

    return view('manager_launder.launder_checkdep',[
        'infolaunderdeps' =>$infolaunderdep
    ]);

}


public function launder_dep_add()
{    
    $infodepsubsub = DB::table('hrd_department_sub_sub')->get();

    return view('manager_launder.launder_checkdep_add',[
        'infodepsubsubs' => $infodepsubsub 
    ]);

}

public function launder_dep_save(Request $request)
{    

    $add = new Launderdep();
    $add->LAUNDER_DEP_CODE = $request->LAUNDER_DEP_CODE;

    $infodep = DB::table('hrd_department_sub_sub')->where('HR_DEPARTMENT_SUB_SUB_ID','=',$request->LAUNDER_DEP_CODE)->first();

    $add->LAUNDER_DEP_NAMECODE = $infodep->DEP_CODE;
    $add->LAUNDER_DEP_NAME = $infodep->HR_DEPARTMENT_SUB_SUB_NAME;
    $add->save(); 

    return redirect()->route('launder.launder_dep');

}



public function launder_dep_edit(Request $request,$idref)
{    
    $infodepsubsub = DB::table('hrd_department_sub_sub')->get();

    $infoma = DB::table('launder_dep')->where('LAUNDER_DEP_ID','=',$idref)->first();
   
    $ID_REF = $infoma->LAUNDER_DEP_ID;

    return view('manager_launder.launder_checkdep_edit',[
        'infodepsubsubs' => $infodepsubsub, 
        'infoma' => $infoma, 
        'ID_REF' => $ID_REF, 
    ]);

}

public function launder_dep_update(Request $request)
{    

    $idrefnum =  $request->ID_REF;


    $add = Launderdep::find($idrefnum);
    $add->LAUNDER_DEP_CODE = $request->LAUNDER_DEP_CODE;

    $infodep = DB::table('hrd_department_sub_sub')->where('HR_DEPARTMENT_SUB_SUB_ID','=',$request->LAUNDER_DEP_CODE)->first();

    $add->LAUNDER_DEP_NAMECODE = $infodep->DEP_CODE;
    $add->LAUNDER_DEP_NAME = $infodep->HR_DEPARTMENT_SUB_SUB_NAME;
    $add->save(); 

    return redirect()->route('launder.launder_dep');

}


public function launder_dep_clothingtype (Request $request,$idref)
{    
     $inforef= DB::table('launder_dep')->where('LAUNDER_DEP_ID','=',$idref)->first();

     $launderdepsub = DB::table('launder_dep_sub')->where('LAUNDER_DEP_ID','=',$idref)->get();

     $infotype = DB::table('launder_type')->get();
     return view('manager_launder.launder_dep_clothingtype',[
        'inforef'=>$inforef,
        'launderdepsubs'=>$launderdepsub,
        'infotypes'=>$infotype,
    ]);
}




public function launder_dep_clothingtype_update(Request $request)
{

    $DEPID = $request->DEPID;

    Launderdepsub::where('LAUNDER_DEP_ID','=',$DEPID)->delete(); 

    if($request->LAUNDER_DEP_SUB_TYPE[0] != '' || $request->LAUNDER_DEP_SUB_TYPE[0] != null){
        
        $LAUNDER_DEP_SUB_TYPE = $request->LAUNDER_DEP_SUB_TYPE;
        $LAUNDER_DEP_SUB_MIN = $request->LAUNDER_DEP_SUB_MIN;
  

        $number =count($LAUNDER_DEP_SUB_TYPE);
        $count = 0;
        for($count = 0; $count < $number; $count++)
        {  
      
           $adds= new Launderdepsub();
           $adds->LAUNDER_DEP_ID = $DEPID;
           $adds->LAUNDER_DEP_SUB_TYPE = $LAUNDER_DEP_SUB_TYPE[$count];
           $infodepname = DB::table('launder_type')->where('LAUNDER_TYPE_ID','=',$LAUNDER_DEP_SUB_TYPE[$count])->first();
           $adds->LAUNDER_DEP_SUB_DETAIL= $infodepname->LAUNDER_TYPE_NAME; 
           $adds->LAUNDER_DEP_SUB_MIN = $LAUNDER_DEP_SUB_MIN[$count];      
           $adds->save(); 
         
           
        }
    }

  

    return redirect()->route('launder.launder_dep');
    

    
}


function launder_dep_destroy($idref) { 
                
    Launderdep::destroy($idref);         
    return redirect()->route('launder.launder_dep');
  
}



function launder_list(Request $request)
{
    $LAUNDERCHECKREF = $request->LAUNDER_CHECK_REF;
    $infos=  DB::table('launder_withdrow_sub')
    ->where('LAUNDER_WITHDROW_ID','=', $LAUNDERCHECKREF)->get();

    $infotypes = DB::table('launder_type')->get();


    $count = 0;
    foreach ( $infos as  $info){ 

        $sumre = DB::table('launder_check_sub')->where('LAUNDER_CHECK_SUB_TYPE','=',$info->LAUNDER_WITHDROW_SUB_TYPE)->sum('LAUNDER_CHECK_SUB_AMOUNT');

        $sumpay =DB::table('launder_dis_sub')->where('LAUNDER_DIS_SUB_TYPE','=',$info->LAUNDER_WITHDROW_SUB_TYPE)->sum('LAUNDER_DIS_SUB_AMOUNT');

            echo '<tr><td style="border: 1px solid black;">'; 
            echo '<select name="LAUNDER_DIS_SUB_TYPE[]" id="LAUNDER_DIS_SUB_TYPE[]" class="form-control input-sm " style=" font-family: \'Kanit\', sans-serif;" >'; 
            echo '<option value="" >--กรุณาเลือก--</option>';
            
            foreach ($infotypes as $infotype){ 
                if($info->LAUNDER_WITHDROW_SUB_TYPE == $infotype->LAUNDER_TYPE_ID){                                                    
                    echo  '<option value="'.$infotype->LAUNDER_TYPE_ID.'" selected>'.$infotype->LAUNDER_TYPE_NAME.'</option>';
                        }else{
                    echo  '<option value="'.$infotype->LAUNDER_TYPE_ID.'" >'.$infotype->LAUNDER_TYPE_NAME.'</option>';
                        }
            }              
            
            echo '</select>'; 
            echo '</td>'; 
            echo '<td style="border: 1px solid black;"> '; 
            echo '<input  name="LAUNDER_DIS_SUB_WAREHOUSE[]" id="LAUNDER_DIS_SUB_WAREHOUSE[]" class="form-control input-sm" style=" font-family: \'Kanit\', sans-serif;" value="'.number_format($sumre-$sumpay,'2','.','').'" readonly>'; 
            echo '</td> '; 
            echo '<td style="border: 1px solid black;"> '; 
            echo '<input  name="LAUNDER_DIS_SUB_AMOUNTRE[]" id="LAUNDER_DIS_SUB_AMOUNTRE[]" class="form-control input-sm" style=" font-family: \'Kanit\', sans-serif;" value="'.$info->LAUNDER_WITHDROW_SUB_AMOUNT.'" >'; 
            echo '</td> '; 
            echo '<td style="border: 1px solid black;">'; 
            echo '<input  name="LAUNDER_DIS_SUB_AMOUNT[]" id="LAUNDER_DIS_SUB_AMOUNT[]" class="form-control input-sm" style=" font-family: \'Kanit\', sans-serif;" value="'.$info->LAUNDER_WITHDROW_SUB_AMOUNT.'" >'; 
            echo '</td>';       
            echo '<td style="text-align: center;border: 1px solid black;"><a class="btn btn-danger fa fa-trash-alt remove" style="color:#FFFFFF;"></a></td>'; 
            echo '</tr>'; 


        $count++;
        }

    

     
    
}


public static function sumtreasuryreceive($idtype,$iddep)
{
     $total  =  DB::table('launder_dis_sub')
     ->leftjoin('launder_dis','launder_dis.LAUNDER_DIS_ID','=','launder_dis_sub.LAUNDER_DIS_ID')
     ->where('LAUNDER_DIS_DEP','=',$iddep)
     ->where('LAUNDER_DIS_SUB_TYPE','=',$idtype)
     ->sum('LAUNDER_DIS_SUB_AMOUNT');

   return $total ;
}

public static function sumtreasurypay($idtype,$iddep)
{
     $total  =  DB::table('launder_pay_sub')
     ->leftjoin('launder_pay','launder_pay.LAUNDER_PAY_ID','=','launder_pay_sub.LAUNDER_PAY_ID')
     ->where('LAUNDER_PAY_DEP','=',$iddep)
     ->where('LAUNDER_PAY_SUB_TYPEID','=',$idtype)
     ->sum('LAUNDER_PAY_SUB_AMOUNT');

   return $total ;
}



  //-------------------------------------ฟังชันรันเลข--------------------
    
  public static function refgetback()
  {
      $year = date('Y');

      $maxnumber = DB::table('launder_getback')->where('LAUNDER_GETBACK_DATE','like',$year.'%')->max('LAUNDER_GETBACK_ID');  

   

      if($maxnumber != '' ||  $maxnumber != null){
          
          $refmax = DB::table('launder_getback')->where('LAUNDER_GETBACK_ID','=',$maxnumber)->first();  

          
          if($refmax->LAUNDER_GETBACK_CODE != '' ||  $refmax->LAUNDER_GETBACK_CODE != null){
             $maxref = substr($refmax->LAUNDER_GETBACK_CODE, -4)+1;
          }else{
             $maxref = 1;
          }
          

          $ref = str_pad($maxref, 5, "0", STR_PAD_LEFT);
     
      }else{
          $ref = '000001';
      }

      $ye = date('Y')+543;
      $y = substr($ye, -2);

  $refnumber ='GB'.$y.'-'.$ref;

   return $refnumber;
  }


    
  public static function refcheck()
  {
      $year = date('Y');

      $maxnumber = DB::table('launder_check')->where('LAUNDER_CHECK_DATE','like',$year.'%')->max('LAUNDER_CHECK_ID');  

   

      if($maxnumber != '' ||  $maxnumber != null){
          
          $refmax = DB::table('launder_check')->where('LAUNDER_CHECK_ID','=',$maxnumber)->first();  

          
          if($refmax->LAUNDER_CHECK_CODE != '' ||  $refmax->LAUNDER_CHECK_CODE != null){
             $maxref = substr($refmax->LAUNDER_CHECK_CODE, -4)+1;
          }else{
             $maxref = 1;
          }
          

          $ref = str_pad($maxref, 5, "0", STR_PAD_LEFT);
     
      }else{
          $ref = '000001';
      }

      $ye = date('Y')+543;
      $y = substr($ye, -2);

  $refnumber ='CH'.$y.'-'.$ref;

   return $refnumber;
  }


  
    
  public static function refsend()
  {
      $year = date('Y');

      $maxnumber = DB::table('launder_dis')->where('LAUNDER_DIS_DATE','like',$year.'%')->max('LAUNDER_DIS_ID');  

   

      if($maxnumber != '' ||  $maxnumber != null){
          
          $refmax = DB::table('launder_dis')->where('LAUNDER_DIS_ID','=',$maxnumber)->first();  

          
          if($refmax->LAUNDER_DIS_CODE != '' ||  $refmax->LAUNDER_DIS_CODE != null){
             $maxref = substr($refmax->LAUNDER_DIS_CODE, -4)+1;
          }else{
             $maxref = 1;
          }
          

          $ref = str_pad($maxref, 5, "0", STR_PAD_LEFT);
     
      }else{
          $ref = '000001';
      }

      $ye = date('Y')+543;
      $y = substr($ye, -2);

  $refnumber ='SE'.$y.'-'.$ref;

   return $refnumber;
  }


  //=========================================

  public static function amount1($iddep)
{
     $total  =  DB::table('launder_getback')
     ->where('LAUNDER_GETBACK_DEP','=',$iddep)
     ->where('LAUNDER_GETBACK_DATE','=',date('Y-m-d'))
     ->count();

   return $total ;
}

public static function weight1($iddep)
{
     $total  =  DB::table('launder_getback')
     ->where('LAUNDER_GETBACK_DEP','=',$iddep)
     ->where('LAUNDER_GETBACK_DATE','=',date('Y-m-d'))
     ->sum('LAUNDER_GETBACK_STAIN');

   return $total ;
}


public static function weight2($iddep)
{
     $total  =  DB::table('launder_getback')
     ->where('LAUNDER_GETBACK_DEP','=',$iddep)
     ->where('LAUNDER_GETBACK_DATE','=',date('Y-m-d'))
     ->sum('LAUNDER_GETBACK_INFECTIOUS');


   return $total ;
}

public static function amount2($iddep)
{
    $total  =  DB::table('launder_check')
    ->where('LAUNDER_CHECK_DEP','=',$iddep)
    ->where('LAUNDER_CHECK_DATE','=',date('Y-m-d'))
     ->count();

   return $total ;
}

public static function amountsub1($iddep)
{
    $total  =  DB::table('launder_check_sub')
    ->leftjoin('launder_check','launder_check.LAUNDER_CHECK_ID','=','launder_check_sub.LAUNDER_CHECK_ID')
    ->where('LAUNDER_CHECK_DEP','=',$iddep)
    ->where('LAUNDER_CHECK_DATE','=',date('Y-m-d'))
     ->sum('LAUNDER_CHECK_SUB_AMOUNT');

   return $total ;
} 

public static function amount3($iddep)
{
    $total  =  DB::table('launder_dis')
    ->where('LAUNDER_DIS_DEP','=',$iddep)
    ->where('LAUNDER_DIS_DATE','=',date('Y-m-d'))
    ->count();

  return $total ;
}

public static function amountsub2($iddep)
{
    $total  =  DB::table('launder_dis_sub')
    ->leftjoin('launder_dis','launder_dis_sub.LAUNDER_DIS_ID','=','launder_dis.LAUNDER_DIS_ID')
    ->where('LAUNDER_DIS_DEP','=',$iddep)
    ->where('LAUNDER_DIS_DATE','=',date('Y-m-d'))
     ->sum('LAUNDER_DIS_SUB_AMOUNT');

  return $total ;
}


public function selectrefnumber(Request $request)
{
 
  

    $inforefs= DB::table('launder_withdrow')
    ->leftjoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','launder_withdrow.LAUNDER_WITHDROW_DEP_SUB_SUB_ID')
    ->where('LAUNDER_WITHDROW_STATUS','=','Request')
    ->get();

    $infomationref_number = Db::table('launder_withdrow')->where('LAUNDER_WITHDROW_ID','=',$request->ref_id)->first();

    $output='<select name="LAUNDER_CHECK_REF" id="LAUNDER_CHECK_REF" class="form-control input-sm " style=" font-family: \'Kanit\', sans-serif;" >
    <option value="" >--กรุณาเลือก--</option>';
    foreach ($inforefs as $inforef){
        if($inforef->LAUNDER_WITHDROW_ID == $infomationref_number->LAUNDER_WITHDROW_ID){
            $output.= '<option value="'.$inforef->LAUNDER_WITHDROW_ID.'" selected>'.$inforef->LAUNDER_WITHDROW_CODE.'</option>';
        }else{
            $output.= '<option value="'.$inforef->LAUNDER_WITHDROW_ID.'" >'.$inforef->LAUNDER_WITHDROW_CODE.'</option>';
        }

    }
     
    $output.='</select>';

     
    echo $output;

}

public function selectrefdep(Request $request)
{


    $infomationref_number = Db::table('launder_withdrow')->where('LAUNDER_WITHDROW_ID','=',$request->ref_id)->first();

    $infodepselects = DB::table('launder_dep')->get();
 
    $output='<select name="LAUNDER_DIS_DEP" id="LAUNDER_DIS_DEP" class="form-control input-lg budget" style=" font-family: \'Kanit\', sans-serif;font-size: 13px;font-weight:normal;">
    <option value="">เลือก</option>';
  
        foreach ($infodepselects as $infodepselect){
            if($infomationref_number->LAUNDER_WITHDROW_DEP_SUB_SUB_ID == $infodepselect->LAUNDER_DEP_CODE){
                $output.= '<option value="'.$infodepselect->LAUNDER_DEP_CODE.'" selected>'.$infodepselect->LAUNDER_DEP_NAMECODE.'</option>';
            }else{
                $output.= '<option value="'.$infodepselect->LAUNDER_DEP_CODE.'" >'.$infodepselect->LAUNDER_DEP_NAMECODE.'</option>';
            }

        }

        $output.='</select>';

     
    echo $output;

}
//========

public function launder_withdraw(Request $request)
{

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

    $infoperson = DB::table('hrd_person')->get();

    return view('manager_launder.launder_withdraw',[
        'budgets' => $budget,
        'suppliestypes' => $suppliestype,
        'pessonalls' => $pessonall,
        'infosuppliess' => $infosupplies, 
        'departmentsubsubs' => $departmentsubsub,
        'infosuppliesunitrefs' => $infosuppliesunitref, 
        'orgname' => $orgname->ORG_NAME,
        'year_id' => $yearbudget,
        'infolaundertypes' => $infolaundertype,
        'infopersons' => $infoperson,

    ]);

}

 

public function launder_withdraw_launder_save(Request $request)
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


    


    return redirect()->route('launder.launder_disburse');
}






}

