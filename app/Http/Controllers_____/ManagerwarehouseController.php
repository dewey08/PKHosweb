<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Person;
use App\Models\Supplies;
use App\Models\Warehousestore;
use App\Models\Warehousecheckreceive;
use App\Models\Warehousecheckreceiveboard;
use App\Models\Warehousecheckreceivesub;
use App\Models\Warehousestorereceivesub;
use App\Models\Warehouserequest;
use App\Models\Warehouserequestsub;
use App\Models\Warehousetreasury;
use App\Models\Warehousestoreexportsub;
use App\Models\Warehousetreasuryreceivesub;
use App\Models\Warehouse_function;
use App\Models\Warehouseobjectivepay;

use App\Models\Warehousetreasurysmall;
use App\Models\Warehousetreasuryexportsmall;
use App\Models\Warehousetreasuryreceivesmall;

use App\Models\Warehousetreasuryquota;

use Session;

date_default_timezone_set("Asia/Bangkok");

class ManagerwarehouseController extends Controller
{
    public function dashboard(Request $request)
    {
        if(!empty($request->budgetyear)){
            $data['budgetyear'] = $request->budgetyear;
        }else{
            $data['budgetyear'] = getBudgetYear();
        }
        $data['budgetyear_dropdown'] = getBudgetYearAmount();
        $year_ad               = $data['budgetyear'] - 543; // ปี ค.ศ.
        $ware_report = new Report\WarehouseReportController();
        $data['count1'] = $ware_report->count_warehouse_by_status($year_ad,'all');
        $data['count2'] = $ware_report->count_warehouse_by_status($year_ad,'Approve');
        $data['count3'] = $ware_report->count_warehouse_by_status($year_ad,'Verify');
        $data['count4'] = $ware_report->count_warehouse_by_status($year_ad,'Allow');
        $data['warehousr_receive_M'] = $ware_report->sum_warehouse_receive_M($year_ad);
        $data['warehousr_export_M'] = $ware_report->sum_warehouse_export_M($year_ad);
        return view('manager_warehouse.dashboard_warehouse',$data);
    }

    public function ajax_sum_waherehouse_store_receive_export(){
        $report = new Report\WarehouseReportController();
        $result = $report->count_warehouse_amount_low_hight();
        return json_encode_u($result);
    }

    public function dashboard_Request(Request $request){
        if($request->method() === 'POST'){
            $data['budgetyear'] = $request->budgetyear;
            $data['status_req'] = $request->status_req;
        }elseif($request->method() === 'GET' && !empty($request->budgetyear) && !empty($request->status_req)){
            $data['budgetyear'] = $request->budgetyear;
            $data['status_req'] = $request->status_req;
        }else{
            $data['budgetyear'] = getBudgetyear();
            $data['status_req'] = 'all';
        }
        $data['budgetyear_dropdown'] = getBudgetYearAmount();
        $year_ad               = $data['budgetyear'] - 543; // ปี ค.ศ.
        $ware_report = new Report\WarehouseReportController();
        $data['table_request'] = $ware_report->get_warehouse_by_status($year_ad,$data['status_req']);
        $data['status_request'] = DB::table('warehouse_request_status')->get();
        return view('manager_warehouse.dashboard_request_warehouse',$data);
    } 

    public function dashboard_min(Request $request){

        $ware_report = new Report\WarehouseReportController();
        $data['table_maxmin'] = $ware_report->get_warehouse_store_low_hight(true);
        return view('manager_warehouse.dashboard_min_warehouse',$data);
    }

    public function dashboard_max(Request $request){

        $ware_report = new Report\WarehouseReportController();
        $data['table_maxmin'] = $ware_report->get_warehouse_store_low_hight(false);
        return view('manager_warehouse.dashboard_max_warehouse',$data);
    }

    public function dashboardsearch(Request $request)
    {
        $year_id = $request->STATUS_CODE;
        $yearbudget = $year_id;
        $count1 = Warehouserequest::count();
        $count2 = Warehouserequest::where('WAREHOUSE_STATUS','=','Approve')->count();
        $count3 = Warehouserequest::where('WAREHOUSE_STATUS','=','Verify')->count();
        $count4 = Warehouserequest::where('WAREHOUSE_STATUS','=','Allow')->count();

     
        
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $year_id = $yearbudget;

        $year = $year_id - 543;

        $m1_1 = DB::table('warehouse_store_receive_sub')->where('created_at','like',$year.'-01%')->sum('RECEIVE_SUB_VALUE');
        $m2_1 = DB::table('warehouse_store_receive_sub')->where('created_at','like',$year.'-02%')->sum('RECEIVE_SUB_VALUE');
        $m3_1 = DB::table('warehouse_store_receive_sub')->where('created_at','like',$year.'-03%')->sum('RECEIVE_SUB_VALUE');
        $m4_1 = DB::table('warehouse_store_receive_sub')->where('created_at','like',$year.'-04%')->sum('RECEIVE_SUB_VALUE');
        $m5_1 = DB::table('warehouse_store_receive_sub')->where('created_at','like',$year.'-05%')->sum('RECEIVE_SUB_VALUE');
        $m6_1 = DB::table('warehouse_store_receive_sub')->where('created_at','like',$year.'-06%')->sum('RECEIVE_SUB_VALUE');
        $m7_1 = DB::table('warehouse_store_receive_sub')->where('created_at','like',$year.'-07%')->sum('RECEIVE_SUB_VALUE');
        $m8_1 = DB::table('warehouse_store_receive_sub')->where('created_at','like',$year.'-08%')->sum('RECEIVE_SUB_VALUE');
        $m9_1 = DB::table('warehouse_store_receive_sub')->where('created_at','like',$year.'-09%')->sum('RECEIVE_SUB_VALUE');
        $m10_1 = DB::table('warehouse_store_receive_sub')->where('created_at','like',$year.'-10%')->sum('RECEIVE_SUB_VALUE');
        $m11_1 = DB::table('warehouse_store_receive_sub')->where('created_at','like',$year.'-11%')->sum('RECEIVE_SUB_VALUE');
        $m12_1 = DB::table('warehouse_store_receive_sub')->where('created_at','like',$year.'-12%')->sum('RECEIVE_SUB_VALUE');

        $m1_2 = DB::table('warehouse_store_export_sub')->where('created_at','like',$year.'-01%')->sum('EXPORT_SUB_VALUE');
        $m2_2 = DB::table('warehouse_store_export_sub')->where('created_at','like',$year.'-02%')->sum('EXPORT_SUB_VALUE');
        $m3_2 = DB::table('warehouse_store_export_sub')->where('created_at','like',$year.'-03%')->sum('EXPORT_SUB_VALUE');
        $m4_2 = DB::table('warehouse_store_export_sub')->where('created_at','like',$year.'-04%')->sum('EXPORT_SUB_VALUE');
        $m5_2 = DB::table('warehouse_store_export_sub')->where('created_at','like',$year.'-05%')->sum('EXPORT_SUB_VALUE');
        $m6_2 = DB::table('warehouse_store_export_sub')->where('created_at','like',$year.'-06%')->sum('EXPORT_SUB_VALUE');
        $m7_2 = DB::table('warehouse_store_export_sub')->where('created_at','like',$year.'-07%')->sum('EXPORT_SUB_VALUE');
        $m8_2 = DB::table('warehouse_store_export_sub')->where('created_at','like',$year.'-08%')->sum('EXPORT_SUB_VALUE');
        $m9_2 = DB::table('warehouse_store_export_sub')->where('created_at','like',$year.'-09%')->sum('EXPORT_SUB_VALUE');
        $m10_2 = DB::table('warehouse_store_export_sub')->where('created_at','like',$year.'-10%')->sum('EXPORT_SUB_VALUE');
        $m11_2 = DB::table('warehouse_store_export_sub')->where('created_at','like',$year.'-11%')->sum('EXPORT_SUB_VALUE');
        $m12_2 = DB::table('warehouse_store_export_sub')->where('created_at','like',$year.'-12%')->sum('EXPORT_SUB_VALUE');

        return view('manager_warehouse.dashboard_warehouse',[
            'count1' => $count1,
            'count2' => $count2,
            'count3' => $count3,
            'count4' => $count4,
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
            'year_id'=>$year_id  
        ]);
    }

   
    public function detail(Request $request)
    {
        if($request->method() === 'POST'){
            $search = $request->get('search');
            $status = $request->INVEN_STATUS;
            $yearbudget = $request->YEAR_ID;
            $status_check = $request->SEND_STATUS;
            $datebigin = $request->get('DATE_BIGIN');
            $dateend = $request->get('DATE_END');
            $search_bugetyear = $request->search_bugetyear;
            session([
                'manager_warehouse.detail.search' => $search,
                'manager_warehouse.detail.status' => $status,
                'manager_warehouse.detail.yearbudget' => $yearbudget,
                'manager_warehouse.detail.status_check' => $status_check,
                'manager_warehouse.detail.datebigin' => $datebigin,
                'manager_warehouse.detail.dateend' => $dateend,
                'manager_warehouse.detail.search_bugetyear' => $search_bugetyear
            ]);
        }elseif(Session::has('manager_warehouse.detail')){
            $search = session('manager_warehouse.detail.search');
            $status = session('manager_warehouse.detail.status');
            $yearbudget = session('manager_warehouse.detail.yearbudget');
            $status_check = session('manager_warehouse.detail.status_check');
            $datebigin = session('manager_warehouse.detail.datebigin');
            $dateend = session('manager_warehouse.detail.dateend');
            $search_bugetyear = session('manager_warehouse.detail.search_bugetyear');
        }else{
            $search = '';
            $status = '';
            $yearbudget = getBudgetyear();
            $status_check = '';
            $datebigin = date('1/m/Y');
            $dateend   = date('d/m/Y', strtotime(date('Y-m-1'). '+1month -1days'));
            $search_bugetyear = null;
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
        $displaydate_bigen= $y."-".$m."-".$d." 00:00:00";

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
        $displaydate_end= $y_e."-".$m_e."-".$d_e." 23:59:59";
        $date = date('Y-m-d');
      
        $from = date($displaydate_bigen);
        $to = date($displaydate_end);

        // เขียนเงื่อนไขแบบใหม่
        $infocheckreceive = DB::table('warehouse_check_receive')
        ->leftJoin('warehouse_check_status','warehouse_check_receive.RECEIVE_CHECK_STATUS','=','warehouse_check_status.ID_STATUS')
        ->leftJoin('warehouse_check_type','warehouse_check_receive.RECEIVE_CHECK_TYPE','=','warehouse_check_type.ID_TYPE')
        ->leftJoin('supplies_inven','warehouse_check_receive.RECEIVE_STORE','=','supplies_inven.INVEN_ID')
        ->leftJoin('supplies_con','warehouse_check_receive.RECEIVE_PO','=','supplies_con.PO_NUM')
        ->leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID');
        if($status_check != ''){
            $infocheckreceive = $infocheckreceive->where('RECEIVE_CHECK_STATUS','=',$status_check);
        }
        if($status != ''){
            $infocheckreceive = $infocheckreceive->where('RECEIVE_STORE','=',$status);
        }
        if($search_bugetyear == true){
            $infocheckreceive = $infocheckreceive->where('warehouse_check_receive.RECEIVE_BUDGET_YEAR',$yearbudget);
        }else{
            $infocheckreceive = $infocheckreceive->WhereBetween('warehouse_check_receive.RECEIVE_CHECK_DATE',[$from,$to]);
        }
        $infocheckreceive = $infocheckreceive->where(function($q) use ($search){
            $q->where('RECEIVE_ACCEPT_FROM','like','%'.$search.'%');
            $q->orwhere('RECEIVE_PERSON_NAME','like','%'.$search.'%');
            $q->orwhere('CON_NUM','like','%'.$search.'%');
            $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');
        })
        ->orderBy('RECEIVE_ID', 'desc')->get();
        $sumbudget = DB::table('warehouse_check_receive')
        ->leftJoin('warehouse_check_status','warehouse_check_receive.RECEIVE_CHECK_STATUS','=','warehouse_check_status.ID_STATUS')
        ->leftJoin('warehouse_check_type','warehouse_check_receive.RECEIVE_CHECK_TYPE','=','warehouse_check_type.ID_TYPE')
        ->leftJoin('supplies_inven','warehouse_check_receive.RECEIVE_STORE','=','supplies_inven.INVEN_ID')
        ->leftJoin('supplies_con','warehouse_check_receive.RECEIVE_PO','=','supplies_con.PO_NUM')
        ->leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID');
        if($status_check != ''){
            $sumbudget = $sumbudget->where('RECEIVE_CHECK_STATUS','=',$status_check);
        }
        if($status != ''){
            $sumbudget = $sumbudget->where('RECEIVE_STORE','=',$status);
        }
        if($search_bugetyear == true){
            $sumbudget = $sumbudget->where('warehouse_check_receive.RECEIVE_BUDGET_YEAR',$yearbudget);
        }else{
            $sumbudget = $sumbudget->WhereBetween('warehouse_check_receive.RECEIVE_CHECK_DATE',[$from,$to]);
        }
        $sumbudget = $sumbudget->where(function($q) use ($search){
            $q->where('RECEIVE_ACCEPT_FROM','like','%'.$search.'%');
            $q->orwhere('RECEIVE_PERSON_NAME','like','%'.$search.'%');
            $q->orwhere('CON_NUM','like','%'.$search.'%');
            $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');
        })
        ->orderBy('RECEIVE_ID', 'desc')->sum('RECEIVE_VALUE');

        

        $infosuppliesinven = DB::table('supplies_inven')
        ->where('ACTIVE','=','True')
        ->orderBy('INVEN_NAME', 'asc')
        ->get();



        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $statussend = DB::table('warehouse_check_status')->orderBy('STATUS_NUMBER')->get();
        $invenstatus_check = $status;  
        $search = $search;
        $status_check = $status_check;
        $year_id = $yearbudget;
        return view('manager_warehouse.warehousedetail',[
            'infocheckreceives' => $infocheckreceive, 
            'infosuppliesinvens' => $infosuppliesinven, 
            'invenstatus_check' => $invenstatus_check,   
            'displaydate_bigen' => $displaydate_bigen,  
            'displaydate_end' => $displaydate_end, 
            'search' => $search, 
            'budgets' =>  $budget,
            'year_id'=>$year_id,
            'sumbudget' => $sumbudget,  
            'statussends' => $statussend,  
            'status_check' => $status_check,  

        ]);
    }


    public static function supdetailname($idsup)
    {
         $sup  =  DB::table('supplies_type')->where('SUP_TYPE_ID','=',$idsup)->first();
         
         if($sup <> null && $sup <> ''){
            $sup_name = $sup->SUP_TYPE_NAME;
         }else{
            $sup_name ='-';
         }
         
         
         
         return $sup_name ;
    }
    
    public function detail_excel(Request $request,$yearbudget,$datebigin,$dateend,$status_check,$status,$search)
    {
        

        if($status_check=='null'){
            $status_check="";
        }

        if($status=='null'){
            $status="";
        }

        if($search=='null'){
            $search="";
        }

       
        $displaydate_bigen = $datebigin;
        $displaydate_end = $dateend;

        $from =$displaydate_bigen;
        $to = $displaydate_end ;

      
            if($status == null){


                if($status_check == null){
      
                $infocheckreceive = DB::table('warehouse_check_receive')
                ->leftJoin('warehouse_check_status','warehouse_check_receive.RECEIVE_CHECK_STATUS','=','warehouse_check_status.ID_STATUS')
                ->leftJoin('warehouse_check_type','warehouse_check_receive.RECEIVE_CHECK_TYPE','=','warehouse_check_type.ID_TYPE')
                ->leftJoin('supplies_inven','warehouse_check_receive.RECEIVE_STORE','=','supplies_inven.INVEN_ID')
                ->leftJoin('supplies_con','warehouse_check_receive.RECEIVE_PO','=','supplies_con.PO_NUM')
                ->leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
                ->where(function($q) use ($search){
                    $q->where('RECEIVE_ACCEPT_FROM','like','%'.$search.'%');
                    $q->orwhere('RECEIVE_PERSON_NAME','like','%'.$search.'%');
                    $q->orwhere('CON_NUM','like','%'.$search.'%');
                    $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');
               })
                ->WhereBetween('warehouse_check_receive.created_at',[$from,$to])
                ->orderBy('RECEIVE_ID', 'desc')->get();
      

                $sumbudget = DB::table('warehouse_check_receive')
                ->leftJoin('warehouse_check_status','warehouse_check_receive.RECEIVE_CHECK_STATUS','=','warehouse_check_status.ID_STATUS')
                ->leftJoin('warehouse_check_type','warehouse_check_receive.RECEIVE_CHECK_TYPE','=','warehouse_check_type.ID_TYPE')
                ->leftJoin('supplies_inven','warehouse_check_receive.RECEIVE_STORE','=','supplies_inven.INVEN_ID')
                ->leftJoin('supplies_con','warehouse_check_receive.RECEIVE_PO','=','supplies_con.PO_NUM')
                ->leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
                ->where(function($q) use ($search){
                    $q->where('RECEIVE_ACCEPT_FROM','like','%'.$search.'%');
                    $q->orwhere('RECEIVE_PERSON_NAME','like','%'.$search.'%');
                    $q->orwhere('CON_NUM','like','%'.$search.'%');
                    $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');
               })
                ->WhereBetween('warehouse_check_receive.created_at',[$from,$to])
                ->orderBy('RECEIVE_ID', 'desc')->sum('RECEIVE_VALUE');
                
                }else{

                    $infocheckreceive = DB::table('warehouse_check_receive')
                    ->leftJoin('warehouse_check_status','warehouse_check_receive.RECEIVE_CHECK_STATUS','=','warehouse_check_status.ID_STATUS')
                    ->leftJoin('warehouse_check_type','warehouse_check_receive.RECEIVE_CHECK_TYPE','=','warehouse_check_type.ID_TYPE')
                    ->leftJoin('supplies_inven','warehouse_check_receive.RECEIVE_STORE','=','supplies_inven.INVEN_ID')
                    ->leftJoin('supplies_con','warehouse_check_receive.RECEIVE_PO','=','supplies_con.PO_NUM')
                    ->leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
                    ->where('RECEIVE_CHECK_STATUS','=',$status_check)
                    ->where(function($q) use ($search){
                        $q->where('RECEIVE_ACCEPT_FROM','like','%'.$search.'%');
                        $q->orwhere('RECEIVE_PERSON_NAME','like','%'.$search.'%');
                        $q->orwhere('CON_NUM','like','%'.$search.'%');
                        $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');
                   })
                    ->WhereBetween('warehouse_check_receive.created_at',[$from,$to])
                    ->orderBy('RECEIVE_ID', 'desc')->get();
          
    
                    $sumbudget = DB::table('warehouse_check_receive')
                    ->leftJoin('warehouse_check_status','warehouse_check_receive.RECEIVE_CHECK_STATUS','=','warehouse_check_status.ID_STATUS')
                    ->leftJoin('warehouse_check_type','warehouse_check_receive.RECEIVE_CHECK_TYPE','=','warehouse_check_type.ID_TYPE')
                    ->leftJoin('supplies_inven','warehouse_check_receive.RECEIVE_STORE','=','supplies_inven.INVEN_ID')
                    ->leftJoin('supplies_con','warehouse_check_receive.RECEIVE_PO','=','supplies_con.PO_NUM')
                    ->leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
                    ->where('RECEIVE_CHECK_STATUS','=',$status_check)
                    ->where(function($q) use ($search){
                        $q->where('RECEIVE_ACCEPT_FROM','like','%'.$search.'%');
                        $q->orwhere('RECEIVE_PERSON_NAME','like','%'.$search.'%');
                        $q->orwhere('CON_NUM','like','%'.$search.'%');
                        $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');
                   })
                    ->WhereBetween('warehouse_check_receive.created_at',[$from,$to])
                    ->orderBy('RECEIVE_ID', 'desc')->sum('RECEIVE_VALUE');




                }

            }else{
                if($status_check == null){

                $infocheckreceive = DB::table('warehouse_check_receive')
                ->leftJoin('warehouse_check_status','warehouse_check_receive.RECEIVE_CHECK_STATUS','=','warehouse_check_status.ID_STATUS')
                ->leftJoin('warehouse_check_type','warehouse_check_receive.RECEIVE_CHECK_TYPE','=','warehouse_check_type.ID_TYPE')
                ->leftJoin('supplies_inven','warehouse_check_receive.RECEIVE_STORE','=','supplies_inven.INVEN_ID')
                ->leftJoin('supplies_con','warehouse_check_receive.RECEIVE_PO','=','supplies_con.PO_NUM')
                ->leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
                ->where('RECEIVE_STORE','=',$status)
                ->where(function($q) use ($search){
                    $q->where('RECEIVE_ACCEPT_FROM','like','%'.$search.'%');
                    $q->orwhere('RECEIVE_PERSON_NAME','like','%'.$search.'%');
                    $q->orwhere('CON_NUM','like','%'.$search.'%');
                    $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');
               })
                ->WhereBetween('warehouse_check_receive.created_at',[$from,$to])
                ->orderBy('RECEIVE_ID', 'desc')->get();


                $sumbudget = DB::table('warehouse_check_receive')
                ->leftJoin('warehouse_check_status','warehouse_check_receive.RECEIVE_CHECK_STATUS','=','warehouse_check_status.ID_STATUS')
                ->leftJoin('warehouse_check_type','warehouse_check_receive.RECEIVE_CHECK_TYPE','=','warehouse_check_type.ID_TYPE')
                ->leftJoin('supplies_inven','warehouse_check_receive.RECEIVE_STORE','=','supplies_inven.INVEN_ID')
                ->leftJoin('supplies_con','warehouse_check_receive.RECEIVE_PO','=','supplies_con.PO_NUM')
                ->leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
                ->where('RECEIVE_STORE','=',$status)
                ->where(function($q) use ($search){
                    $q->where('RECEIVE_ACCEPT_FROM','like','%'.$search.'%');
                    $q->orwhere('RECEIVE_PERSON_NAME','like','%'.$search.'%');
                    $q->orwhere('CON_NUM','like','%'.$search.'%');
                    $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');
               })
                ->WhereBetween('warehouse_check_receive.created_at',[$from,$to])
                ->orderBy('RECEIVE_ID', 'desc')->sum('RECEIVE_VALUE');
            }else{

                $infocheckreceive = DB::table('warehouse_check_receive')
                ->leftJoin('warehouse_check_status','warehouse_check_receive.RECEIVE_CHECK_STATUS','=','warehouse_check_status.ID_STATUS')
                ->leftJoin('warehouse_check_type','warehouse_check_receive.RECEIVE_CHECK_TYPE','=','warehouse_check_type.ID_TYPE')
                ->leftJoin('supplies_inven','warehouse_check_receive.RECEIVE_STORE','=','supplies_inven.INVEN_ID')
                ->leftJoin('supplies_con','warehouse_check_receive.RECEIVE_PO','=','supplies_con.PO_NUM')
                ->leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
                ->where('RECEIVE_STORE','=',$status)
                ->where('RECEIVE_CHECK_STATUS','=',$status_check)
                ->where(function($q) use ($search){
                    $q->where('RECEIVE_ACCEPT_FROM','like','%'.$search.'%');
                    $q->orwhere('RECEIVE_PERSON_NAME','like','%'.$search.'%');
                    $q->orwhere('CON_NUM','like','%'.$search.'%');
                    $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');
               })
                ->WhereBetween('warehouse_check_receive.created_at',[$from,$to])
                ->orderBy('RECEIVE_ID', 'desc')->get();


                $sumbudget = DB::table('warehouse_check_receive')
                ->leftJoin('warehouse_check_status','warehouse_check_receive.RECEIVE_CHECK_STATUS','=','warehouse_check_status.ID_STATUS')
                ->leftJoin('warehouse_check_type','warehouse_check_receive.RECEIVE_CHECK_TYPE','=','warehouse_check_type.ID_TYPE')
                ->leftJoin('supplies_inven','warehouse_check_receive.RECEIVE_STORE','=','supplies_inven.INVEN_ID')
                ->leftJoin('supplies_con','warehouse_check_receive.RECEIVE_PO','=','supplies_con.PO_NUM')
                ->leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
                ->where('RECEIVE_STORE','=',$status)
                ->where('RECEIVE_CHECK_STATUS','=',$status_check)
                ->where(function($q) use ($search){
                    $q->where('RECEIVE_ACCEPT_FROM','like','%'.$search.'%');
                    $q->orwhere('RECEIVE_PERSON_NAME','like','%'.$search.'%');
                    $q->orwhere('CON_NUM','like','%'.$search.'%');
                    $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');
               })
                ->WhereBetween('warehouse_check_receive.created_at',[$from,$to])
                ->orderBy('RECEIVE_ID', 'desc')->sum('RECEIVE_VALUE');

            }



            }

        $infosuppliesinven = DB::table('supplies_inven')
        ->where('ACTIVE','=','True')
        ->orderBy('INVEN_NAME', 'asc')
        ->get();

        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $statussend = DB::table('warehouse_check_status')->get();

        $invenstatus_check = $status;  
        $search = $search;
        $status_check = $status_check;

        $year_id = $yearbudget;
    
        return view('manager_warehouse.warehousedetail_excel',[
            'infocheckreceives' => $infocheckreceive, 
            'infosuppliesinvens' => $infosuppliesinven, 
            'invenstatus_check' => $invenstatus_check,   
            'displaydate_bigen' => $displaydate_bigen,  
            'displaydate_end' => $displaydate_end, 
            'search' => $search,
            'year_id'=>$year_id,  
            'budgets' =>  $budget,
            'sumbudget' => $sumbudget,  
            'statussends' => $statussend,  
            'status_check' => $status_check,  
     

        ]);
    }
    
    public function detail_edit(Request $request,$id)
 {
     $iduser = Auth::user()->PERSON_ID;

     $infoperson = DB::table('hrd_person')
     ->orderBy('hrd_person.HR_FNAME', 'asc')  
     ->where('hrd_person.HR_STATUS_ID', '=',1)
     ->get();

     $infobudgetyear= DB::table('budget_year')->where('ACTIVE','=','True')->get();

     $infosuptype = DB::table('warehouse_sup_type')->get();
 

    $infosuppliesinven = DB::table('supplies_inven_permiss')
    ->leftjoin('supplies_inven','supplies_inven_permiss.INVENPERMIS_INVEN_ID','=','supplies_inven.INVEN_ID')
    ->where('INVENPERMIS_PERSON_ID','=',$iduser)
    ->where('ACTIVE','=','True')
    ->get();
  
     $infosuptype = DB::table('warehouse_sup_type')->get();

     $infocheckreceive = DB::table('warehouse_check_receive')
     ->leftJoin('supplies_inven','warehouse_check_receive.RECEIVE_STORE','=','supplies_inven.INVEN_ID')
     ->where('RECEIVE_ID','=',$id)->first();

     $infocheckreceivesub = DB::table('warehouse_check_receive_sub')
     ->leftJoin('warehouse_sup_type','warehouse_check_receive_sub.RECEIVE_SUB_TYPE','=','warehouse_sup_type.ID_SUP_TYPE')
     ->leftJoin('supplies_unit_ref','warehouse_check_receive_sub.RECEIVE_SUB_UNIT','=','supplies_unit_ref.ID')
     ->where('RECEIVE_ID','=',$id)->get();


     $count = DB::table('warehouse_check_receive_sub')->where('RECEIVE_ID','=',$id)->count();


     $infosupplies= Supplies::leftJoin('supplies_type','supplies.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
     ->leftJoin('supplies_type_kind','supplies.SUP_TYPE_KIND_ID','=','supplies_type_kind.SUP_TYPE_KIND_ID')
     ->where('supplies_type_kind.SUP_TYPE_MASTER_ID','=',1)
     ->where('supplies.ACTIVE','=','True')
     ->orderBy('ID', 'desc') 
     ->get();

     $infocheckreceiveboard = DB::table('warehouse_check_receive_board')
     ->leftJoin('hrd_person','warehouse_check_receive_board.RECEIVE_BOARD_PERSON_ID','=','hrd_person.ID')
     ->where('RECEIVE_ID','=',$id)->get();


     $infosuppliesunitref = DB::table('supplies_unit_ref')->get();

     $infosuppliesvendor = DB::table('supplies_vendor')->get();

     $suppliestype = DB::table('supplies_type')->where('ACTIVE','=','True')->get();
 
     return view('manager_warehouse.warehousedetail_edit',[
         'infopersons' => $infoperson,  
         'infosuptypes' => $infosuptype, 
         'infobudgetyears' => $infobudgetyear, 
         'infosuppliesinvens' => $infosuppliesinven, 
         'infocheckreceive' => $infocheckreceive, 
         'infocheckreceivesubs' => $infocheckreceivesub, 
         'infosuppliess' => $infosupplies, 
         'infocheckreceiveboards' => $infocheckreceiveboard, 
         'suppliestypes' => $suppliestype, 
         'infosuppliesunitrefs' => $infosuppliesunitref, 
         'infosuppliesvendors' => $infosuppliesvendor, 
         'count' => $count,

     ]);
 }
 public function detail_update(Request $request)
{



         $CHECKDATE = $request->RECEIVE_CHECK_DATE;
         $CHECKDATESTOR = $request->RECEIVE_CHECKSTOR_DATE;

         if($CHECKDATE != ''){
            $DAY = Carbon::createFromFormat('d/m/Y', $CHECKDATE)->format('Y-m-d');
            $date_arrary_st=explode("-",$DAY);
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

        if($CHECKDATESTOR != ''){
            $DAY = Carbon::createFromFormat('d/m/Y', $CHECKDATESTOR)->format('Y-m-d');
            $date_arrary_st=explode("-",$DAY);
            $y_sub_st = $date_arrary_st[0];

            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];
            $CHECKDATESTOR= $y_st."-".$m_st."-".$d_st;
            }else{
            $CHECKDATESTOR= null;
        }




        $re_id = $request->RECEIVE_ID;

        $addinfocheck = Warehousecheckreceive::find($re_id);
        $addinfocheck->RECEIVE_CODE = $request->RECEIVE_CODE;
        $addinfocheck->RECEIVE_NUMBER = $request->RECEIVE_NUMBER;
        $addinfocheck->RECEIVE_PERSON_ID = $request->RECEIVE_PERSON_ID;

        $PERSON =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
        ->where('hrd_person.ID','=',$request->RECEIVE_PERSON_ID)->first();
        $addinfocheck->RECEIVE_PERSON_NAME = $PERSON->HR_PREFIX_NAME.''.$PERSON->HR_FNAME.' '.$PERSON->HR_LNAME;    
       
        $addinfocheck->RECEIVE_STORE = $request->RECEIVE_STORE;
   
        $addinfocheck->RECEIVE_CHECK_DATE = $CHECKDATE;
        $addinfocheck->RECEIVE_CHECKSTOR_DATE = $CHECKDATESTOR;
        
        $addinfocheck->RECEIVE_CHECK_TIME = $request->RECEIVE_CHECK_TIME;

        $addinfocheck->RECEIVE_ACCEPT_FROM = $request->RECEIVE_ACCEPT_FROM;
        $addinfocheck->RECEIVE_BUDGET_YEAR = $request->RECEIVE_BUDGET_YEAR;
        $addinfocheck->RECEIVE_SUP_TYPE = $request->RECEIVE_SUP_TYPE;
        $addinfocheck->RECEIVE_PO = $request->RECEIVE_PO;
        $addinfocheck->RECEIVE_CHECK_STATUS = '3';
        
        $addinfocheck->save();




        $RECEIVE_ID = $re_id; 

        Warehousecheckreceivesub::where('RECEIVE_ID','=',$re_id)->delete(); 

        if($request->RECEIVE_SUB_CODE != '' || $request->RECEIVE_SUB_CODE != null){

            $RECEIVE_SUB_CODE = $request->RECEIVE_SUB_CODE;
            $RECEIVE_SUB_TYPE = $request->RECEIVE_SUB_TYPE;
            $RECEIVE_SUB_UNIT = $request->SUP_UNIT_ID;
            $RECEIVE_SUB_AMOUNT = $request->RECEIVE_SUB_AMOUNT;
            $RECEIVE_SUB_PICE_UNIT = $request->RECEIVE_SUB_PICE_UNIT;
           
            $RECEIVE_SUB_LOT = $request->RECEIVE_SUB_LOT;
           
            $RECEIVE_SUB_GEN_DATE = $request->RECEIVE_SUB_GEN_DATE;
            $RECEIVE_SUB_EXP_DATE = $request->RECEIVE_SUB_EXP_DATE;
        

            $number =count($RECEIVE_SUB_CODE);
            $count = 0;
            for($count = 0; $count< $number; $count++)
            {

 
              if($RECEIVE_SUB_GEN_DATE[$count] != ''){
                 $DAY = Carbon::createFromFormat('d/m/Y',$RECEIVE_SUB_GEN_DATE[$count])->format('Y-m-d');
                 $date_arrary_st=explode("-",$DAY);
                 $y_sub_st = $date_arrary_st[0];
 
                 if($y_sub_st >= 2500){
                     $y_st = $y_sub_st-543;
                 }else{
                     $y_st = $y_sub_st;
                 }
                 $m_st = $date_arrary_st[1];
                 $d_st = $date_arrary_st[2];
                 $GENDATE= $y_st."-".$m_st."-".$d_st;
                 }else{
                 $GENDATE= null;
             }

             if($RECEIVE_SUB_EXP_DATE[$count] != ''){
                $DAY = Carbon::createFromFormat('d/m/Y', $RECEIVE_SUB_EXP_DATE[$count])->format('Y-m-d');
                $date_arrary_st=explode("-",$DAY);
                $y_sub_st = $date_arrary_st[0];

                if($y_sub_st >= 2500){
                    $y_st = $y_sub_st-543;
                }else{
                    $y_st = $y_sub_st;
                }
                $m_st = $date_arrary_st[1];
                $d_st = $date_arrary_st[2];
                $EXPDATE= $y_st."-".$m_st."-".$d_st;
                }else{
                $EXPDATE= null;
            }

               $add = new Warehousecheckreceivesub();
               $add->RECEIVE_ID = $RECEIVE_ID;
               $add->RECEIVE_SUB_CODE = $RECEIVE_SUB_CODE[$count];

               $RECEIVESUBNAME = DB::table('supplies')->where('ID','=',$RECEIVE_SUB_CODE[$count])->first();
               $add->RECEIVE_SUB_NAME = $RECEIVESUBNAME->SUP_NAME;


               $add->RECEIVE_SUB_TYPE = $RECEIVE_SUB_TYPE[$count];
               $add->RECEIVE_SUB_UNIT = $RECEIVE_SUB_UNIT[$count];
               $add->RECEIVE_SUB_AMOUNT = $RECEIVE_SUB_AMOUNT[$count];
               $add->RECEIVE_SUB_PICE_UNIT = $RECEIVE_SUB_PICE_UNIT[$count];
               $add->RECEIVE_SUB_VALUE =$RECEIVE_SUB_AMOUNT[$count] * $RECEIVE_SUB_PICE_UNIT[$count];
               $add->RECEIVE_SUB_LOT = $RECEIVE_SUB_LOT[$count];

               $add->RECEIVE_SUB_GEN_DATE = $GENDATE;
               $add->RECEIVE_SUB_EXP_DATE = $EXPDATE;

         

               $add->save();
            }
            }

            if($request->RECEIVE_BOARD_PERSON_ID != '' || $request->RECEIVE_BOARD_PERSON_ID != null){

                $RECEIVE_BOARD_PERSON_ID = $request->RECEIVE_BOARD_PERSON_ID;
                $RECEIVE_BOARD_POSITION_ID = $request->RECEIVE_BOARD_POSITION_ID;
          
                $number =count($RECEIVE_BOARD_PERSON_ID);
                $count = 0;
                for($count = 0; $count< $number; $count++)
                {

                   $add = new Warehousecheckreceiveboard();
                   $add->RECEIVE_ID = $RECEIVE_ID;
                   $add->RECEIVE_BOARD_PERSON_ID = $RECEIVE_BOARD_PERSON_ID[$count];
                   $add->RECEIVE_BOARD_POSITION_ID = $RECEIVE_BOARD_POSITION_ID[$count];
                   $add->save();


                }
            }
            $RECEIVEVALUE = DB::table('warehouse_check_receive_sub')->where('RECEIVE_ID','=',$RECEIVE_ID)->sum('RECEIVE_SUB_VALUE');
            $addinfovalue= Warehousecheckreceive::find($RECEIVE_ID);
            $addinfovalue->RECEIVE_VALUE =  $RECEIVEVALUE ;
            $addinfovalue->save();


         

         return redirect()->route('mwarehouse.detail');
 }
  /////================================================



    public function detailsearch(Request $request)
    {
        $search = $request->get('search');
        $status = $request->INVEN_STATUS;
        $yearbudget = $request->YEAR_ID;
        $status_check = $request->SEND_STATUS;
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
        $date = date('Y-m-d');
      
     
      
            $from = date($displaydate_bigen);
            $to = date($displaydate_end);



            if($status == null){


                if($status_check == null){
      
                $infocheckreceive = DB::table('warehouse_check_receive')
                ->leftJoin('warehouse_check_status','warehouse_check_receive.RECEIVE_CHECK_STATUS','=','warehouse_check_status.ID_STATUS')
                ->leftJoin('warehouse_check_type','warehouse_check_receive.RECEIVE_CHECK_TYPE','=','warehouse_check_type.ID_TYPE')
                ->leftJoin('supplies_inven','warehouse_check_receive.RECEIVE_STORE','=','supplies_inven.INVEN_ID')
                ->leftJoin('supplies_con','warehouse_check_receive.RECEIVE_PO','=','supplies_con.PO_NUM')
                ->leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
                ->where(function($q) use ($search){
                    $q->where('RECEIVE_ACCEPT_FROM','like','%'.$search.'%');
                    $q->orwhere('RECEIVE_PERSON_NAME','like','%'.$search.'%');
                    $q->orwhere('CON_NUM','like','%'.$search.'%');
                    $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');
               })
                ->WhereBetween('warehouse_check_receive.created_at',[$from,$to])
                ->orderBy('RECEIVE_ID', 'desc')->get();
      

                $sumbudget = DB::table('warehouse_check_receive')
                ->leftJoin('warehouse_check_status','warehouse_check_receive.RECEIVE_CHECK_STATUS','=','warehouse_check_status.ID_STATUS')
                ->leftJoin('warehouse_check_type','warehouse_check_receive.RECEIVE_CHECK_TYPE','=','warehouse_check_type.ID_TYPE')
                ->leftJoin('supplies_inven','warehouse_check_receive.RECEIVE_STORE','=','supplies_inven.INVEN_ID')
                ->leftJoin('supplies_con','warehouse_check_receive.RECEIVE_PO','=','supplies_con.PO_NUM')
                ->leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
                ->where(function($q) use ($search){
                    $q->where('RECEIVE_ACCEPT_FROM','like','%'.$search.'%');
                    $q->orwhere('RECEIVE_PERSON_NAME','like','%'.$search.'%');
                    $q->orwhere('CON_NUM','like','%'.$search.'%');
                    $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');
               })
                ->WhereBetween('warehouse_check_receive.created_at',[$from,$to])
                ->orderBy('RECEIVE_ID', 'desc')->sum('RECEIVE_VALUE');
                
                }else{

                    $infocheckreceive = DB::table('warehouse_check_receive')
                    ->leftJoin('warehouse_check_status','warehouse_check_receive.RECEIVE_CHECK_STATUS','=','warehouse_check_status.ID_STATUS')
                    ->leftJoin('warehouse_check_type','warehouse_check_receive.RECEIVE_CHECK_TYPE','=','warehouse_check_type.ID_TYPE')
                    ->leftJoin('supplies_inven','warehouse_check_receive.RECEIVE_STORE','=','supplies_inven.INVEN_ID')
                    ->leftJoin('supplies_con','warehouse_check_receive.RECEIVE_PO','=','supplies_con.PO_NUM')
                    ->leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
                    ->where('RECEIVE_CHECK_STATUS','=',$status_check)
                    ->where(function($q) use ($search){
                        $q->where('RECEIVE_ACCEPT_FROM','like','%'.$search.'%');
                        $q->orwhere('RECEIVE_PERSON_NAME','like','%'.$search.'%');
                        $q->orwhere('CON_NUM','like','%'.$search.'%');
                        $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');
                   })
                    ->WhereBetween('warehouse_check_receive.created_at',[$from,$to])
                    ->orderBy('RECEIVE_ID', 'desc')->get();
          
    
                    $sumbudget = DB::table('warehouse_check_receive')
                    ->leftJoin('warehouse_check_status','warehouse_check_receive.RECEIVE_CHECK_STATUS','=','warehouse_check_status.ID_STATUS')
                    ->leftJoin('warehouse_check_type','warehouse_check_receive.RECEIVE_CHECK_TYPE','=','warehouse_check_type.ID_TYPE')
                    ->leftJoin('supplies_inven','warehouse_check_receive.RECEIVE_STORE','=','supplies_inven.INVEN_ID')
                    ->leftJoin('supplies_con','warehouse_check_receive.RECEIVE_PO','=','supplies_con.PO_NUM')
                    ->leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
                    ->where('RECEIVE_CHECK_STATUS','=',$status_check)
                    ->where(function($q) use ($search){
                        $q->where('RECEIVE_ACCEPT_FROM','like','%'.$search.'%');
                        $q->orwhere('RECEIVE_PERSON_NAME','like','%'.$search.'%');
                        $q->orwhere('CON_NUM','like','%'.$search.'%');
                        $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');
                   })
                    ->WhereBetween('warehouse_check_receive.created_at',[$from,$to])
                    ->orderBy('RECEIVE_ID', 'desc')->sum('RECEIVE_VALUE');




                }

            }else{
                if($status_check == null){

                $infocheckreceive = DB::table('warehouse_check_receive')
                ->leftJoin('warehouse_check_status','warehouse_check_receive.RECEIVE_CHECK_STATUS','=','warehouse_check_status.ID_STATUS')
                ->leftJoin('warehouse_check_type','warehouse_check_receive.RECEIVE_CHECK_TYPE','=','warehouse_check_type.ID_TYPE')
                ->leftJoin('supplies_inven','warehouse_check_receive.RECEIVE_STORE','=','supplies_inven.INVEN_ID')
                ->leftJoin('supplies_con','warehouse_check_receive.RECEIVE_PO','=','supplies_con.PO_NUM')
                ->leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
                ->where('RECEIVE_STORE','=',$status)
                ->where(function($q) use ($search){
                    $q->where('RECEIVE_ACCEPT_FROM','like','%'.$search.'%');
                    $q->orwhere('RECEIVE_PERSON_NAME','like','%'.$search.'%');
                    $q->orwhere('CON_NUM','like','%'.$search.'%');
                    $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');
               })
                ->WhereBetween('warehouse_check_receive.created_at',[$from,$to])
                ->orderBy('RECEIVE_ID', 'desc')->get();


                $sumbudget = DB::table('warehouse_check_receive')
                ->leftJoin('warehouse_check_status','warehouse_check_receive.RECEIVE_CHECK_STATUS','=','warehouse_check_status.ID_STATUS')
                ->leftJoin('warehouse_check_type','warehouse_check_receive.RECEIVE_CHECK_TYPE','=','warehouse_check_type.ID_TYPE')
                ->leftJoin('supplies_inven','warehouse_check_receive.RECEIVE_STORE','=','supplies_inven.INVEN_ID')
                ->leftJoin('supplies_con','warehouse_check_receive.RECEIVE_PO','=','supplies_con.PO_NUM')
                ->leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
                ->where('RECEIVE_STORE','=',$status)
                ->where(function($q) use ($search){
                    $q->where('RECEIVE_ACCEPT_FROM','like','%'.$search.'%');
                    $q->orwhere('RECEIVE_PERSON_NAME','like','%'.$search.'%');
                    $q->orwhere('CON_NUM','like','%'.$search.'%');
                    $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');
               })
                ->WhereBetween('warehouse_check_receive.created_at',[$from,$to])
                ->orderBy('RECEIVE_ID', 'desc')->sum('RECEIVE_VALUE');
            }else{

                $infocheckreceive = DB::table('warehouse_check_receive')
                ->leftJoin('warehouse_check_status','warehouse_check_receive.RECEIVE_CHECK_STATUS','=','warehouse_check_status.ID_STATUS')
                ->leftJoin('warehouse_check_type','warehouse_check_receive.RECEIVE_CHECK_TYPE','=','warehouse_check_type.ID_TYPE')
                ->leftJoin('supplies_inven','warehouse_check_receive.RECEIVE_STORE','=','supplies_inven.INVEN_ID')
                ->leftJoin('supplies_con','warehouse_check_receive.RECEIVE_PO','=','supplies_con.PO_NUM')
                ->leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
                ->where('RECEIVE_STORE','=',$status)
                ->where('RECEIVE_CHECK_STATUS','=',$status_check)
                ->where(function($q) use ($search){
                    $q->where('RECEIVE_ACCEPT_FROM','like','%'.$search.'%');
                    $q->orwhere('RECEIVE_PERSON_NAME','like','%'.$search.'%');
                    $q->orwhere('CON_NUM','like','%'.$search.'%');
                    $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');
               })
                ->WhereBetween('warehouse_check_receive.created_at',[$from,$to])
                ->orderBy('RECEIVE_ID', 'desc')->get();


                $sumbudget = DB::table('warehouse_check_receive')
                ->leftJoin('warehouse_check_status','warehouse_check_receive.RECEIVE_CHECK_STATUS','=','warehouse_check_status.ID_STATUS')
                ->leftJoin('warehouse_check_type','warehouse_check_receive.RECEIVE_CHECK_TYPE','=','warehouse_check_type.ID_TYPE')
                ->leftJoin('supplies_inven','warehouse_check_receive.RECEIVE_STORE','=','supplies_inven.INVEN_ID')
                ->leftJoin('supplies_con','warehouse_check_receive.RECEIVE_PO','=','supplies_con.PO_NUM')
                ->leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
                ->where('RECEIVE_STORE','=',$status)
                ->where('RECEIVE_CHECK_STATUS','=',$status_check)
                ->where(function($q) use ($search){
                    $q->where('RECEIVE_ACCEPT_FROM','like','%'.$search.'%');
                    $q->orwhere('RECEIVE_PERSON_NAME','like','%'.$search.'%');
                    $q->orwhere('CON_NUM','like','%'.$search.'%');
                    $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');
               })
                ->WhereBetween('warehouse_check_receive.created_at',[$from,$to])
                ->orderBy('RECEIVE_ID', 'desc')->sum('RECEIVE_VALUE');

            }



            }

        $infosuppliesinven = DB::table('supplies_inven')
        ->where('ACTIVE','=','True')
        ->orderBy('INVEN_NAME', 'asc')
        ->get();

        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $statussend = DB::table('warehouse_check_status')->get();

        $invenstatus_check = $status;  
        $search = $search;
        $status_check = $status_check;

        $year_id = $yearbudget;
        return view('manager_warehouse.warehousedetail',[
            'infocheckreceives' => $infocheckreceive, 
            'infosuppliesinvens' => $infosuppliesinven, 
            'invenstatus_check' => $invenstatus_check,   
            'displaydate_bigen' => $displaydate_bigen,  
            'displaydate_end' => $displaydate_end, 
            'search' => $search, 
            'budgets' =>  $budget,
            'year_id'=>$year_id,
            'sumbudget' => $sumbudget,  
            'statussends' => $statussend,  
            'status_check' => $status_check,  

        ]);
    }


    
    public function infocheckadd()
    {

        $iduser = Auth::user()->PERSON_ID;

        $infoperson = DB::table('hrd_person')
        ->orderBy('hrd_person.HR_FNAME', 'asc')  
        ->where('hrd_person.HR_STATUS_ID', '=',1)
        ->get();

        $infobudgetyear= DB::table('budget_year')->where('ACTIVE','=','True')->get();

        $infosuptype = DB::table('warehouse_sup_type')->get();
    
      

        $RECEIVE_ID = Warehousecheckreceive::max('RECEIVE_ID'); 
        $RECEIVE_CODE = 'RE-'.str_pad($RECEIVE_ID+1,4,"0",STR_PAD_LEFT);
        
        $infosuppliesinven = DB::table('supplies_inven_permiss')
        ->leftjoin('supplies_inven','supplies_inven_permiss.INVENPERMIS_INVEN_ID','=','supplies_inven.INVEN_ID')
        ->where('INVENPERMIS_PERSON_ID','=',$iduser)
        ->where('ACTIVE','=','True')
        ->get();


        $infosuptype = DB::table('warehouse_sup_type')->get();

        $infosupplies= Supplies::leftJoin('supplies_type','supplies.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
        ->leftJoin('supplies_type_kind','supplies.SUP_TYPE_KIND_ID','=','supplies_type_kind.SUP_TYPE_KIND_ID')
        ->where('supplies_type_kind.SUP_TYPE_MASTER_ID','=',1)
        ->where('supplies.ACTIVE','=','True')
        ->orderBy('ID', 'desc') 
        ->get();

        $infosuppliesunitref = DB::table('supplies_unit_ref')->get();

        $infosuppliesvendor = DB::table('supplies_vendor')->get();

        $suppliestype = DB::table('supplies_type')->where('ACTIVE','=','True')->get();

        return view('manager_warehouse.warehouseinfocheck_add',[
            'infopersons' => $infoperson,  
            'infosuptypes' => $infosuptype, 
            'infobudgetyears' => $infobudgetyear, 
            'infosuppliesinvens' => $infosuppliesinven, 
            'infosuppliess' => $infosupplies, 
            'RECEIVECODE' => $RECEIVE_CODE, 
            'infosuppliesunitrefs' => $infosuppliesunitref, 
            'infosuppliesvendors' => $infosuppliesvendor,
            'suppliestypes' => $suppliestype,

        ]);
    }


    
    public function saveinfocheckadd(Request $request)
    {
          

             $CHECKDATE = $request->RECEIVE_CHECK_DATE;
             $CHECKDATESTOR = $request->RECEIVE_CHECK_DATE;
   

             if($CHECKDATE != ''){
                $DAY = Carbon::createFromFormat('d/m/Y', $CHECKDATE)->format('Y-m-d');
                $date_arrary_st=explode("-",$DAY);
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

            if($CHECKDATESTOR != ''){
                $DAY = Carbon::createFromFormat('d/m/Y', $CHECKDATESTOR)->format('Y-m-d');
                $date_arrary_st=explode("-",$DAY);
                $y_sub_st = $date_arrary_st[0];

                if($y_sub_st >= 2500){
                    $y_st = $y_sub_st-543;
                }else{
                    $y_st = $y_sub_st;
                }
                $m_st = $date_arrary_st[1];
                $d_st = $date_arrary_st[2];
                $CHECKDATESTOR= $y_st."-".$m_st."-".$d_st;
                }else{
                $CHECKDATESTOR= null;
            }


            $RECEIVE_ID = Warehousecheckreceive::max('RECEIVE_ID'); 
            $RECEIVE_CODE = 'RE-'.str_pad($RECEIVE_ID+1,4,"0",STR_PAD_LEFT);
       
            $addinfocheck = new Warehousecheckreceive();
            $addinfocheck->RECEIVE_CODE = $RECEIVE_CODE;
            $addinfocheck->RECEIVE_NUMBER = $request->RECEIVE_NUMBER;
            $addinfocheck->RECEIVE_PERSON_ID = $request->RECEIVE_PERSON_ID;

            $PERSON =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
            ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
            ->where('hrd_person.ID','=',$request->RECEIVE_PERSON_ID)->first();
            $addinfocheck->RECEIVE_PERSON_NAME = $PERSON->HR_PREFIX_NAME.''.$PERSON->HR_FNAME.' '.$PERSON->HR_LNAME;    
           
            $addinfocheck->RECEIVE_STORE = $request->RECEIVE_STORE;
       
            $addinfocheck->RECEIVE_CHECK_DATE = $CHECKDATE;
            $addinfocheck->RECEIVE_CHECKSTOR_DATE = $CHECKDATESTOR;

            $addinfocheck->RECEIVE_CHECK_TIME = $request->RECEIVE_CHECK_TIME;
 
            $addinfocheck->RECEIVE_ACCEPT_FROM = $request->RECEIVE_ACCEPT_FROM;
            $addinfocheck->RECEIVE_BUDGET_YEAR = $request->RECEIVE_BUDGET_YEAR;
            $addinfocheck->RECEIVE_SUP_TYPE = $request->RECEIVE_SUP_TYPE;
            $addinfocheck->RECEIVE_PO = $request->RECEIVE_PO;
            $addinfocheck->RECEIVE_CHECK_TYPE = '2';
            $addinfocheck->RECEIVE_CHECK_STATUS = '3';
            
            $addinfocheck->save();




            $RECEIVE_ID = Warehousecheckreceive::max('RECEIVE_ID'); 

            if($request->RECEIVE_SUB_CODE != '' || $request->RECEIVE_SUB_CODE != null){

                $RECEIVE_SUB_CODE = $request->RECEIVE_SUB_CODE;
                $RECEIVE_SUB_TYPE = $request->RECEIVE_SUB_TYPE;
                $RECEIVE_SUB_UNIT = $request->SUP_UNIT_ID;
                $RECEIVE_SUB_AMOUNT = $request->RECEIVE_SUB_AMOUNT;
                $RECEIVE_SUB_PICE_UNIT = $request->RECEIVE_SUB_PICE_UNIT;
               
                $RECEIVE_SUB_LOT = $request->RECEIVE_SUB_LOT;
               
                $RECEIVE_SUB_GEN_DATE = $request->RECEIVE_SUB_GEN_DATE;
                $RECEIVE_SUB_EXP_DATE = $request->RECEIVE_SUB_EXP_DATE;
            

                $number =count($RECEIVE_SUB_CODE);
                $count = 0;
                for($count = 0; $count< $number; $count++)
                {
     
                  if($RECEIVE_SUB_GEN_DATE[$count] != ''){
                     $DAY = Carbon::createFromFormat('d/m/Y',$RECEIVE_SUB_GEN_DATE[$count])->format('Y-m-d');
                     $date_arrary_st=explode("-",$DAY);
                     $y_sub_st = $date_arrary_st[0];
     
                     if($y_sub_st >= 2500){
                         $y_st = $y_sub_st-543;
                     }else{
                         $y_st = $y_sub_st;
                     }
                     $m_st = $date_arrary_st[1];
                     $d_st = $date_arrary_st[2];
                     $GENDATE= $y_st."-".$m_st."-".$d_st;
                     }else{
                     $GENDATE= null;
                 }


                 if($RECEIVE_SUB_EXP_DATE[$count] != ''){
                    $DAY = Carbon::createFromFormat('d/m/Y', $RECEIVE_SUB_EXP_DATE[$count])->format('Y-m-d');
                    $date_arrary_st=explode("-",$DAY);
                    $y_sub_st = $date_arrary_st[0];
    
                    if($y_sub_st >= 2500){
                        $y_st = $y_sub_st-543;
                    }else{
                        $y_st = $y_sub_st;
                    }
                    $m_st = $date_arrary_st[1];
                    $d_st = $date_arrary_st[2];
                    $EXPDATE= $y_st."-".$m_st."-".$d_st;
                    }else{
                    $EXPDATE= null;
                }

                   $add = new Warehousecheckreceivesub();
                   $add->RECEIVE_ID = $RECEIVE_ID;
                   $add->RECEIVE_SUB_CODE = $RECEIVE_SUB_CODE[$count];

                   $RECEIVESUBNAME = DB::table('supplies')->where('ID','=',$RECEIVE_SUB_CODE[$count])->first();
                   $add->RECEIVE_SUB_NAME = $RECEIVESUBNAME->SUP_NAME;


                   $add->RECEIVE_SUB_TYPE = $RECEIVE_SUB_TYPE[$count];
                   $add->RECEIVE_SUB_UNIT = $RECEIVE_SUB_UNIT[$count];
                   $add->RECEIVE_SUB_AMOUNT = $RECEIVE_SUB_AMOUNT[$count];
                   $add->RECEIVE_SUB_PICE_UNIT = $RECEIVE_SUB_PICE_UNIT[$count];
                   $add->RECEIVE_SUB_VALUE =$RECEIVE_SUB_AMOUNT[$count] * $RECEIVE_SUB_PICE_UNIT[$count];
                   $add->RECEIVE_SUB_LOT = $RECEIVE_SUB_LOT[$count];

                   $add->RECEIVE_SUB_GEN_DATE = $GENDATE;
                   $add->RECEIVE_SUB_EXP_DATE = $EXPDATE;
   
             

                   $add->save();
                }
                }

                if($request->RECEIVE_BOARD_PERSON_ID != '' || $request->RECEIVE_BOARD_PERSON_ID != null){

                    $RECEIVE_BOARD_PERSON_ID = $request->RECEIVE_BOARD_PERSON_ID;
                    $RECEIVE_BOARD_POSITION_ID = $request->RECEIVE_BOARD_POSITION_ID;
              
                    $number =count($RECEIVE_BOARD_PERSON_ID);
                    $count = 0;
                    for($count = 0; $count< $number; $count++)
                    {
    
                       $add = new Warehousecheckreceiveboard();
                       $add->RECEIVE_ID = $RECEIVE_ID;
                       $add->RECEIVE_BOARD_PERSON_ID = $RECEIVE_BOARD_PERSON_ID[$count];
                       $add->RECEIVE_BOARD_POSITION_ID = $RECEIVE_BOARD_POSITION_ID[$count];
                   
    
                       $add->save();
    
    
                    }
                }
    
                $RECEIVEVALUE = DB::table('warehouse_check_receive_sub')->where('RECEIVE_ID','=',$RECEIVE_ID)->sum('RECEIVE_SUB_VALUE');
    
                $addinfovalue= Warehousecheckreceive::find($RECEIVE_ID);
                $addinfovalue->RECEIVE_VALUE =  $RECEIVEVALUE ;
                $addinfovalue->save();


             


            return redirect()->route('mwarehouse.detail');
    }







    public function infochecksup(Request $request,$idref)
    {
        $iduser = Auth::user()->PERSON_ID;
        $infoperson = DB::table('hrd_person')
        ->orderBy('hrd_person.HR_FNAME', 'asc')  
        ->where('hrd_person.HR_STATUS_ID', '=',1)
        ->get();

        $infobudgetyear= DB::table('budget_year')->where('ACTIVE','=','True')->get();

        $infosuptype = DB::table('warehouse_sup_type')->get();

        $infosuppliesinven = DB::table('supplies_inven_permiss')
        ->leftjoin('supplies_inven','supplies_inven_permiss.INVENPERMIS_INVEN_ID','=','supplies_inven.INVEN_ID')
        ->where('INVENPERMIS_PERSON_ID','=',$iduser)
        ->where('ACTIVE','=','True')
        ->get();


        $infosuptype = DB::table('warehouse_sup_type')->get();

        $infocheckreceive = DB::table('warehouse_check_receive')->where('RECEIVE_ID','=',$idref)->first();

        $infocheckreceivesub = DB::table('warehouse_check_receive_sub')->where('RECEIVE_ID','=',$idref)->get();
        $count = DB::table('warehouse_check_receive_sub')->where('RECEIVE_ID','=',$idref)->count();


        $infosupplies= Supplies::leftJoin('supplies_type','supplies.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
        ->leftJoin('supplies_type_kind','supplies.SUP_TYPE_KIND_ID','=','supplies_type_kind.SUP_TYPE_KIND_ID')
        ->where('supplies_type_kind.SUP_TYPE_MASTER_ID','=',1)
        ->where('supplies.ACTIVE','=','True')
        ->orderBy('ID', 'desc') 
        ->get();

        $infosuppliesunitref = DB::table('supplies_unit_ref')->get();

        $infosuppliesvendor = DB::table('supplies_vendor')->get();

        $suppliestype = DB::table('supplies_type')->where('ACTIVE','=','True')->get();
    
        return view('manager_warehouse.warehouseinfochecksup',[
            'infopersons' => $infoperson,  
            'infosuptypes' => $infosuptype, 
            'infobudgetyears' => $infobudgetyear, 
            'infosuppliesinvens' => $infosuppliesinven, 
            'infocheckreceive' => $infocheckreceive, 
            'infocheckreceivesubs' => $infocheckreceivesub, 
            'infosuppliess' => $infosupplies, 
            'infosuppliesunitrefs' => $infosuppliesunitref, 
            'infosuppliesvendors' => $infosuppliesvendor, 
            'suppliestypes' => $suppliestype, 
            'count' => $count,

        ]);
    }




    public function updateinfochecksup(Request $request)
    {
          

             $CHECKDATE = $request->RECEIVE_CHECK_DATE;
             $CHECKDATESTOR = $request->RECEIVE_CHECKSTOR_DATE;

             if($CHECKDATE != ''){
                $DAY = Carbon::createFromFormat('d/m/Y', $CHECKDATE)->format('Y-m-d');
                $date_arrary_st=explode("-",$DAY);
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


            
        if($CHECKDATESTOR != ''){
            $DAY = Carbon::createFromFormat('d/m/Y', $CHECKDATESTOR)->format('Y-m-d');
            $date_arrary_st=explode("-",$DAY);
            $y_sub_st = $date_arrary_st[0];

            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];
            $CHECKDATESTOR= $y_st."-".$m_st."-".$d_st;
            }else{
            $CHECKDATESTOR= null;
        }

            $RECEIVE_ID = $request->RECEIVE_ID;

            $addinfocheck = Warehousecheckreceive::find($RECEIVE_ID);
            $addinfocheck->RECEIVE_CODE = $request->RECEIVE_CODE;
            $addinfocheck->RECEIVE_NUMBER = $request->RECEIVE_NUMBER;
            $addinfocheck->RECEIVE_PERSON_ID = $request->RECEIVE_PERSON_ID;

            $PERSON =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
            ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
            ->where('hrd_person.ID','=',$request->RECEIVE_PERSON_ID)->first();
            $addinfocheck->RECEIVE_PERSON_NAME = $PERSON->HR_PREFIX_NAME.''.$PERSON->HR_FNAME.' '.$PERSON->HR_LNAME;    
           
            $addinfocheck->RECEIVE_STORE = $request->RECEIVE_STORE;
       
            $addinfocheck->RECEIVE_CHECK_DATE = $CHECKDATE;
            $addinfocheck->RECEIVE_CHECKSTOR_DATE = $CHECKDATESTOR;

            $addinfocheck->RECEIVE_CHECK_TIME = $request->RECEIVE_CHECK_TIME;
 
            $addinfocheck->RECEIVE_ACCEPT_FROM = $request->RECEIVE_ACCEPT_FROM;
            $addinfocheck->RECEIVE_BUDGET_YEAR = $request->RECEIVE_BUDGET_YEAR;
            $addinfocheck->RECEIVE_SUP_TYPE = $request->RECEIVE_SUP_TYPE;
            $addinfocheck->RECEIVE_PO = $request->RECEIVE_PO;
            $addinfocheck->RECEIVE_CHECK_STATUS = '3';
            
            $addinfocheck->save();

           Warehousecheckreceivesub::where('RECEIVE_ID','=',$RECEIVE_ID)->delete(); 
           if($request->RECEIVE_SUB_CODE != '' || $request->RECEIVE_SUB_CODE != null){

            $RECEIVE_SUB_CODE = $request->RECEIVE_SUB_CODE;
            $RECEIVE_SUB_TYPE = $request->RECEIVE_SUB_TYPE;
            $RECEIVE_SUB_UNIT = $request->RECEIVE_SUB_UNIT;
            $RECEIVE_SUB_AMOUNT = $request->RECEIVE_SUB_AMOUNT;
            $RECEIVE_SUB_PICE_UNIT = $request->RECEIVE_SUB_PICE_UNIT;
           
            $RECEIVE_SUB_LOT = $request->RECEIVE_SUB_LOT;
           
            $RECEIVE_SUB_GEN_DATE = $request->RECEIVE_SUB_GEN_DATE;
            $RECEIVE_SUB_EXP_DATE = $request->RECEIVE_SUB_EXP_DATE;
        

            $number =count($RECEIVE_SUB_CODE);
            $count = 0;
            for($count = 0; $count< $number; $count++)
            {
 
              if($RECEIVE_SUB_GEN_DATE[$count] != ''){
                 $DAY = Carbon::createFromFormat('d/m/Y',$RECEIVE_SUB_GEN_DATE[$count])->format('Y-m-d');
                 $date_arrary_st=explode("-",$DAY);
                 $y_sub_st = $date_arrary_st[0];
 
                 if($y_sub_st >= 2500){
                     $y_st = $y_sub_st-543;
                 }else{
                     $y_st = $y_sub_st;
                 }
                 $m_st = $date_arrary_st[1];
                 $d_st = $date_arrary_st[2];
                 $GENDATE= $y_st."-".$m_st."-".$d_st;
                 }else{
                 $GENDATE= null;
             }

             if($RECEIVE_SUB_EXP_DATE[$count] != ''){
                $DAY = Carbon::createFromFormat('d/m/Y', $RECEIVE_SUB_EXP_DATE[$count])->format('Y-m-d');
                $date_arrary_st=explode("-",$DAY);
                $y_sub_st = $date_arrary_st[0];

                if($y_sub_st >= 2500){
                    $y_st = $y_sub_st-543;
                }else{
                    $y_st = $y_sub_st;
                }
                $m_st = $date_arrary_st[1];
                $d_st = $date_arrary_st[2];
                $EXPDATE= $y_st."-".$m_st."-".$d_st;
                }else{
                $EXPDATE= null;
            }

               $add = new Warehousecheckreceivesub();
               $add->RECEIVE_ID = $RECEIVE_ID;
               $add->RECEIVE_SUB_CODE = $RECEIVE_SUB_CODE[$count];

               $RECEIVESUBNAME = DB::table('supplies')->where('ID','=',$RECEIVE_SUB_CODE[$count])->first();
               $add->RECEIVE_SUB_NAME = $RECEIVESUBNAME->SUP_NAME;


               $add->RECEIVE_SUB_TYPE = $RECEIVE_SUB_TYPE[$count];
               $add->RECEIVE_SUB_UNIT = $RECEIVE_SUB_UNIT[$count];
               $add->RECEIVE_SUB_AMOUNT = $RECEIVE_SUB_AMOUNT[$count];
               $add->RECEIVE_SUB_PICE_UNIT = $RECEIVE_SUB_PICE_UNIT[$count];
               $add->RECEIVE_SUB_VALUE =$RECEIVE_SUB_AMOUNT[$count] * $RECEIVE_SUB_PICE_UNIT[$count];
               $add->RECEIVE_SUB_LOT = $RECEIVE_SUB_LOT[$count];

               $add->RECEIVE_SUB_GEN_DATE = $GENDATE;
               $add->RECEIVE_SUB_EXP_DATE = $EXPDATE;

         

               $add->save();
            }
            }

            if($request->RECEIVE_BOARD_PERSON_ID != '' || $request->RECEIVE_BOARD_PERSON_ID != null){

                $RECEIVE_BOARD_PERSON_ID = $request->RECEIVE_BOARD_PERSON_ID;
                $RECEIVE_BOARD_POSITION_ID = $request->RECEIVE_BOARD_POSITION_ID;
          
                $number =count($RECEIVE_BOARD_PERSON_ID);
                $count = 0;
                for($count = 0; $count< $number; $count++)
                {

                   $add = new Warehousecheckreceiveboard();
                   $add->RECEIVE_ID = $RECEIVE_ID;
                   $add->RECEIVE_BOARD_PERSON_ID = $RECEIVE_BOARD_PERSON_ID[$count];
                   $add->RECEIVE_BOARD_POSITION_ID = $RECEIVE_BOARD_POSITION_ID[$count];
               

                   $add->save();


                }
            }


            $RECEIVEVALUE = DB::table('warehouse_check_receive_sub')->where('RECEIVE_ID','=',$RECEIVE_ID)->sum('RECEIVE_SUB_VALUE');

            $addinfovalue= Warehousecheckreceive::find($RECEIVE_ID);
            $addinfovalue->RECEIVE_VALUE =  $RECEIVEVALUE ;
            $addinfovalue->save();



            return redirect()->route('mwarehouse.detail');
    }



    public function updatewarehouseinfoconfirmdetail(Request $request)
    {  

        $RECEIVE_ID = $request->RECEIVE_ID;

        $addinfocheck = Warehousecheckreceive::find($RECEIVE_ID);
        $addinfocheck->RECEIVE_CHECK_STATUS = '1';
        $addinfocheck->save();

        $checkreceive = Warehousecheckreceive::where('RECEIVE_ID','=',$RECEIVE_ID)->first();
        $infowarehousecheckreceivesub  =  DB::table('warehouse_check_receive_sub')->where('RECEIVE_ID','=',$RECEIVE_ID)->get();

        foreach ($infowarehousecheckreceivesub as $checkreceivesub) {
      
            $RECEIVENAME = DB::table('supplies')->where('ID','=',$checkreceivesub->RECEIVE_SUB_CODE)->first();

            $countcheck  =  DB::table('warehouse_store')->where('STORE_CODE','=',$RECEIVENAME->SUP_FSN_NUM)->count();

            if($countcheck == 0 ){


                $addWarehousestore = new Warehousestore();
            
                $addWarehousestore->STORE_CODE =  $RECEIVENAME->SUP_FSN_NUM;    
                $addWarehousestore->STORE_NAME = $RECEIVENAME->SUP_NAME;
                $addWarehousestore->STORE_TYPE = $checkreceive->RECEIVE_STORE;
                $STORETYPENAME = DB::table('supplies_inven')->where('INVEN_ID','=',$checkreceive->RECEIVE_STORE)->first();
                $addWarehousestore->STORE_TYPE_NAME = $STORETYPENAME->INVEN_NAME;

                $addWarehousestore->STORE_UNIT = $checkreceivesub->RECEIVE_SUB_UNIT;

                $addWarehousestore->STORE_SUP_ID =  $RECEIVENAME->ID;    

                $addWarehousestore->save();

            }


        $stor_id  =  DB::table('warehouse_store')->where('STORE_CODE','=',$RECEIVENAME->SUP_FSN_NUM)->first();

        $addstore = new Warehousestorereceivesub();
        $addstore->RECEIVE_ID = $RECEIVE_ID;
  

        $RECEIVESUBNAME2 = DB::table('supplies')->where('ID','=',$checkreceivesub->RECEIVE_SUB_CODE)->first();
        $addstore->RECEIVE_SUB_NAME = $RECEIVESUBNAME2->SUP_NAME;

        $addstore->RECEIVE_SUB_TYPE = $checkreceivesub->RECEIVE_SUB_TYPE;
        $addstore->RECEIVE_SUB_UNIT = $checkreceivesub->RECEIVE_SUB_UNIT;
        $addstore->RECEIVE_SUB_AMOUNT = $checkreceivesub->RECEIVE_SUB_AMOUNT;
        $addstore->RECEIVE_SUB_PICE_UNIT = $checkreceivesub->RECEIVE_SUB_PICE_UNIT;
        $addstore->RECEIVE_SUB_VALUE =$checkreceivesub->RECEIVE_SUB_AMOUNT*$checkreceivesub->RECEIVE_SUB_PICE_UNIT;
        $addstore->RECEIVE_SUB_LOT = $checkreceivesub->RECEIVE_SUB_LOT;
        $addstore->RECEIVE_SUB_GEN_DATE = $checkreceivesub->RECEIVE_SUB_GEN_DATE;
        $addstore->RECEIVE_SUB_EXP_DATE = $checkreceivesub->RECEIVE_SUB_EXP_DATE;

        $addstore->STORE_ID = $stor_id->STORE_ID ;
        $addstore->save();


            }
        

        return redirect()->route('mwarehouse.detail');
}


 //--------------------------------

 

 public function infocheckdetali(Request $request,$idref)
 {

     $infoperson = DB::table('hrd_person')
     ->orderBy('hrd_person.HR_FNAME', 'asc')  
     ->where('hrd_person.HR_STATUS_ID', '=',1)
     ->get();

     $infobudgetyear= DB::table('budget_year')->where('ACTIVE','=','True')->get();

     $infosuptype = DB::table('warehouse_sup_type')->get();
 

     $infosuppliesinven= DB::table('supplies_inven')->orderby('INVEN_ID', 'asc')->get();

     $infosuptype = DB::table('warehouse_sup_type')->get();

     $infocheckreceive = DB::table('warehouse_check_receive')
     ->leftJoin('supplies_inven','warehouse_check_receive.RECEIVE_STORE','=','supplies_inven.INVEN_ID')
     ->where('RECEIVE_ID','=',$idref)->first();

     $infocheckreceivesub = DB::table('warehouse_check_receive_sub')
     ->leftJoin('warehouse_sup_type','warehouse_check_receive_sub.RECEIVE_SUB_TYPE','=','warehouse_sup_type.ID_SUP_TYPE')
     ->leftJoin('supplies_unit_ref','warehouse_check_receive_sub.RECEIVE_SUB_UNIT','=','supplies_unit_ref.ID')
     ->where('RECEIVE_ID','=',$idref)->get();


     $count = DB::table('warehouse_check_receive_sub')->where('RECEIVE_ID','=',$idref)->count();


     $infosupplies= Supplies::leftJoin('supplies_type','supplies.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
     ->leftJoin('supplies_type_kind','supplies.SUP_TYPE_KIND_ID','=','supplies_type_kind.SUP_TYPE_KIND_ID')
     ->where('supplies_type_kind.SUP_TYPE_MASTER_ID','=',1)
     ->orderBy('ID', 'desc') 
     ->get();

     $infocheckreceiveboard = DB::table('warehouse_check_receive_board')
     ->leftJoin('hrd_person','warehouse_check_receive_board.RECEIVE_BOARD_PERSON_ID','=','hrd_person.ID')
     ->where('RECEIVE_ID','=',$idref)->get();

 
     return view('manager_warehouse.warehouseinfocheckdetail',[
         'infopersons' => $infoperson,  
         'infosuptypes' => $infosuptype, 
         'infobudgetyears' => $infobudgetyear, 
         'infosuppliesinvens' => $infosuppliesinven, 
         'infocheckreceive' => $infocheckreceive, 
         'infocheckreceivesubs' => $infocheckreceivesub, 
         'infosuppliess' => $infosupplies, 
         'infocheckreceiveboards' => $infocheckreceiveboard, 
         'count' => $count,

     ]);
 }


 
 public function infoconfirmdetali(Request $request,$idref)
 {

     $infoperson = DB::table('hrd_person')
     ->orderBy('hrd_person.HR_FNAME', 'asc')  
     ->where('hrd_person.HR_STATUS_ID', '=',1)
     ->get();

     $infobudgetyear= DB::table('budget_year')->where('ACTIVE','=','True')->get();

     $infosuptype = DB::table('warehouse_sup_type')->get();
 

     $infosuppliesinven= DB::table('supplies_inven')->orderby('INVEN_ID', 'asc')->get();

     $infosuptype = DB::table('warehouse_sup_type')->get();

     $infocheckreceive = DB::table('warehouse_check_receive')
     ->leftJoin('supplies_inven','warehouse_check_receive.RECEIVE_STORE','=','supplies_inven.INVEN_ID')
     ->where('RECEIVE_ID','=',$idref)->first();

     $infocheckreceivesub = DB::table('warehouse_check_receive_sub')
     ->leftJoin('warehouse_sup_type','warehouse_check_receive_sub.RECEIVE_SUB_TYPE','=','warehouse_sup_type.ID_SUP_TYPE')
     ->leftJoin('supplies_unit_ref','warehouse_check_receive_sub.RECEIVE_SUB_UNIT','=','supplies_unit_ref.ID')
     ->where('RECEIVE_ID','=',$idref)->get();


     $count = DB::table('warehouse_check_receive_sub')->where('RECEIVE_ID','=',$idref)->count();


     $infosupplies= Supplies::leftJoin('supplies_type','supplies.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
     ->leftJoin('supplies_type_kind','supplies.SUP_TYPE_KIND_ID','=','supplies_type_kind.SUP_TYPE_KIND_ID')
     ->where('supplies_type_kind.SUP_TYPE_MASTER_ID','=',1)
     ->orderBy('ID', 'desc') 
     ->get();

     $infocheckreceiveboard = DB::table('warehouse_check_receive_board')
     ->leftJoin('hrd_person','warehouse_check_receive_board.RECEIVE_BOARD_PERSON_ID','=','hrd_person.ID')
     ->where('RECEIVE_ID','=',$idref)->get();

 
     return view('manager_warehouse.warehouseinfoconfirmdetail',[
         'infopersons' => $infoperson,  
         'infosuptypes' => $infosuptype, 
         'infobudgetyears' => $infobudgetyear, 
         'infosuppliesinvens' => $infosuppliesinven, 
         'infocheckreceive' => $infocheckreceive, 
         'infocheckreceivesubs' => $infocheckreceivesub, 
         'infosuppliess' => $infosupplies, 
         'infocheckreceiveboards' => $infocheckreceiveboard, 
         'count' => $count,

     ]);
 }




 //-------------------------------------
    

    //---คลังหลัก

    public function storehouse(Request $request)
    {
        $iduser = Auth::user()->PERSON_ID;

        if($request->method() === 'POST'){
            $typestore = $request->RECEIVE_STORE;
            $search = $request->search;
            session([
                'manager_warehouse.storehouse.typestore' => $typestore,
                'manager_warehouse.storehouse.search' => $search,
            ]);
        }elseif(Session::has('manager_warehouse.storehouse')){
            $typestore = session('manager_warehouse.storehouse.typestore');
            $search = session('manager_warehouse.storehouse.search');
        }else{
            $typestore = '';
            $search = '';
        }

      
     
    
        if ($typestore == '') {

            $infoinvenfirst = DB::table('supplies_inven_permiss')
            ->leftjoin('supplies_inven','supplies_inven_permiss.INVENPERMIS_INVEN_ID','=','supplies_inven.INVEN_ID')
            ->where('INVENPERMIS_PERSON_ID','=',$iduser)
            ->where('ACTIVE','=','True')
            ->first();

            if($infoinvenfirst == null){
                $typestorefirst = '';
            }else{
                $typestorefirst = $infoinvenfirst->INVENPERMIS_INVEN_ID;
            }
             
       
            $infowarehousestore= DB::table('warehouse_store')
                ->leftJoin('supplies_unit_ref', 'warehouse_store.STORE_UNIT', '=', 'supplies_unit_ref.ID') 
                ->leftJoin('supplies', 'warehouse_store.STORE_CODE', '=', 'supplies.SUP_FSN_NUM')           
                ->leftJoin('supplies_type', 'supplies_type.SUP_TYPE_ID', '=', 'supplies.SUP_TYPE_ID')
                ->where('warehouse_store.STORE_TYPE', '=', $typestorefirst)
                ->where(function($q) use ($search){
                    $q->where('STORE_CODE','like','%'.$search.'%');
                    $q->orwhere('STORE_NAME','like','%'.$search.'%');
                    $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');
                    $q->orwhere('SUP_UNIT_NAME','like','%'.$search.'%');
                })                     
                ->orderBy('STORE_ID', 'desc')
                ->get();
                $sumvalue1 = DB::table('warehouse_store_receive_sub')
                ->leftJoin('warehouse_store', 'warehouse_store.STORE_ID', '=', 'warehouse_store_receive_sub.STORE_ID')           
                ->leftJoin('supplies', 'warehouse_store.STORE_CODE', '=', 'supplies.SUP_FSN_NUM')    
                ->leftJoin('supplies_unit_ref', 'warehouse_store.STORE_UNIT', '=', 'supplies_unit_ref.ID') 
                ->leftJoin('supplies_type', 'supplies_type.SUP_TYPE_ID', '=', 'supplies.SUP_TYPE_ID')
                ->where('warehouse_store.STORE_TYPE', '=', $typestorefirst)
                ->where(function($q) use ($search){
                    $q->where('STORE_CODE','like','%'.$search.'%');
                    $q->orwhere('RECEIVE_SUB_NAME','like','%'.$search.'%');
                    $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');
                    $q->orwhere('SUP_UNIT_NAME','like','%'.$search.'%');
                })                     
                ->sum('RECEIVE_SUB_VALUE');
                $sumvalue2 = DB::table('warehouse_store_export_sub')
                ->leftJoin('warehouse_store', 'warehouse_store.STORE_ID', '=', 'warehouse_store_export_sub.STORE_ID')           
                ->leftJoin('supplies', 'warehouse_store.STORE_CODE', '=', 'supplies.SUP_FSN_NUM')    
                ->leftJoin('supplies_unit_ref', 'warehouse_store.STORE_UNIT', '=', 'supplies_unit_ref.ID') 
                ->leftJoin('supplies_type', 'supplies_type.SUP_TYPE_ID', '=', 'supplies.SUP_TYPE_ID')
                ->where('warehouse_store.STORE_TYPE', '=', $typestorefirst)
                ->where(function($q) use ($search){
                    $q->where('STORE_CODE','like','%'.$search.'%');
                    $q->orwhere('EXPORT_SUB_NAME','like','%'.$search.'%');
                    $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');
                    $q->orwhere('SUP_UNIT_NAME','like','%'.$search.'%');
                })   
                ->sum('EXPORT_SUB_VALUE');
                $sumvalue =  $sumvalue1 - $sumvalue2;

        }else{    
            $infowarehousestore= DB::table('warehouse_store')
            ->leftJoin('supplies_unit_ref', 'warehouse_store.STORE_UNIT', '=', 'supplies_unit_ref.ID') 
            ->leftJoin('supplies', 'warehouse_store.STORE_CODE', '=', 'supplies.SUP_FSN_NUM')           
            ->leftJoin('supplies_type', 'supplies_type.SUP_TYPE_ID', '=', 'supplies.SUP_TYPE_ID')                     
            ->where('warehouse_store.STORE_TYPE', '=', $typestore)
            ->where(function($q) use ($search){
                $q->where('STORE_CODE','like','%'.$search.'%');
                $q->orwhere('STORE_NAME','like','%'.$search.'%');
                $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');
                $q->orwhere('SUP_UNIT_NAME','like','%'.$search.'%');
            })  
            ->orderBy('STORE_ID', 'desc')
            ->get();
            $sumvalue1 = DB::table('warehouse_store_receive_sub')
            ->leftJoin('warehouse_store', 'warehouse_store_receive_sub.STORE_ID', '=', 'warehouse_store.STORE_ID')
            ->leftJoin('supplies', 'warehouse_store.STORE_CODE', '=', 'supplies.SUP_FSN_NUM')    
            ->leftJoin('supplies_unit_ref', 'warehouse_store.STORE_UNIT', '=', 'supplies_unit_ref.ID') 
            ->leftJoin('supplies_type', 'supplies_type.SUP_TYPE_ID', '=', 'supplies.SUP_TYPE_ID')
            ->where('warehouse_store.STORE_TYPE', '=', $typestore)
            ->where(function($q) use ($search){
                $q->where('STORE_CODE','like','%'.$search.'%');
                $q->orwhere('RECEIVE_SUB_NAME','like','%'.$search.'%');
                $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');
                $q->orwhere('SUP_UNIT_NAME','like','%'.$search.'%');
            }) 
            ->sum('RECEIVE_SUB_VALUE');
            $sumvalue2 = DB::table('warehouse_store_export_sub')
            ->leftJoin('warehouse_store', 'warehouse_store.STORE_ID', '=', 'warehouse_store_export_sub.STORE_ID')           
            ->leftJoin('supplies', 'warehouse_store.STORE_CODE', '=', 'supplies.SUP_FSN_NUM')    
            ->leftJoin('supplies_unit_ref', 'warehouse_store.STORE_UNIT', '=', 'supplies_unit_ref.ID') 
            ->leftJoin('supplies_type', 'supplies_type.SUP_TYPE_ID', '=', 'supplies.SUP_TYPE_ID')
            ->where('warehouse_store.STORE_TYPE', '=', $typestore)
            ->where(function($q) use ($search){
                $q->where('STORE_CODE','like','%'.$search.'%');
                $q->orwhere('EXPORT_SUB_NAME','like','%'.$search.'%');
                $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');
                $q->orwhere('SUP_UNIT_NAME','like','%'.$search.'%');
            }) 
            ->sum('EXPORT_SUB_VALUE');
            $sumvalue =  $sumvalue1 - $sumvalue2;
        }      
       
        $infosuppliesinven = DB::table('supplies_inven_permiss')
        ->leftjoin('supplies_inven','supplies_inven_permiss.INVENPERMIS_INVEN_ID','=','supplies_inven.INVEN_ID')
        ->where('INVENPERMIS_PERSON_ID','=',$iduser)
        ->where('ACTIVE','=','True')
        ->get();


        $checkreceive =  $typestore;
        return view('manager_warehouse.warehousestorehouse',[
             'infowarehousestores' => $infowarehousestore,
             'infosuppliesinvens'=> $infosuppliesinven,
             'sumvalue'=> $sumvalue,
             'checkreceive'=> $checkreceive,
             'search'=> $search,
        ]);
    }

    public function storehouse_excel(Request $request)
    {


        $iduser = Auth::user()->PERSON_ID;

        if($request->method() === 'POST'){
            $typestore = $request->RECEIVE_STORE;
            $search = $request->search;
            session([
                'manager_warehouse.storehouse.typestore' => $typestore,
                'manager_warehouse.storehouse.search' => $search,
            ]);
        }elseif(Session::has('manager_warehouse.storehouse')){
            $typestore = session('manager_warehouse.storehouse.typestore');
            $search = session('manager_warehouse.storehouse.search');
        }else{
            $typestore = '';
            $search = '';
        }


        $infowarehousestore= DB::table('warehouse_store')
        ->leftJoin('supplies_unit_ref', 'warehouse_store.STORE_UNIT', '=', 'supplies_unit_ref.ID') 
        ->leftJoin('supplies', 'warehouse_store.STORE_CODE', '=', 'supplies.SUP_FSN_NUM')           
        ->leftJoin('supplies_type', 'supplies_type.SUP_TYPE_ID', '=', 'supplies.SUP_TYPE_ID')                     
        ->where('warehouse_store.STORE_TYPE', '=', $typestore)
        ->where(function($q) use ($search){
            $q->where('STORE_CODE','like','%'.$search.'%');
            $q->orwhere('STORE_NAME','like','%'.$search.'%');
            $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');
            $q->orwhere('SUP_UNIT_NAME','like','%'.$search.'%');
        })  
        ->orderBy('STORE_ID', 'desc')
        ->get();
        $sumvalue1 = DB::table('warehouse_store_receive_sub')
        ->leftJoin('warehouse_store', 'warehouse_store_receive_sub.STORE_ID', '=', 'warehouse_store.STORE_ID')
        ->leftJoin('supplies', 'warehouse_store.STORE_CODE', '=', 'supplies.SUP_FSN_NUM')    
        ->leftJoin('supplies_unit_ref', 'warehouse_store.STORE_UNIT', '=', 'supplies_unit_ref.ID') 
        ->leftJoin('supplies_type', 'supplies_type.SUP_TYPE_ID', '=', 'supplies.SUP_TYPE_ID')
        ->where('warehouse_store.STORE_TYPE', '=', $typestore)
        ->where(function($q) use ($search){
            $q->where('STORE_CODE','like','%'.$search.'%');
            $q->orwhere('RECEIVE_SUB_NAME','like','%'.$search.'%');
            $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');
            $q->orwhere('SUP_UNIT_NAME','like','%'.$search.'%');
        }) 
        ->sum('RECEIVE_SUB_VALUE');
        $sumvalue2 = DB::table('warehouse_store_export_sub')
        ->leftJoin('warehouse_store', 'warehouse_store.STORE_ID', '=', 'warehouse_store_export_sub.STORE_ID')           
        ->leftJoin('supplies', 'warehouse_store.STORE_CODE', '=', 'supplies.SUP_FSN_NUM')    
        ->leftJoin('supplies_unit_ref', 'warehouse_store.STORE_UNIT', '=', 'supplies_unit_ref.ID') 
        ->leftJoin('supplies_type', 'supplies_type.SUP_TYPE_ID', '=', 'supplies.SUP_TYPE_ID')
        ->where('warehouse_store.STORE_TYPE', '=', $typestore)
        ->where(function($q) use ($search){
            $q->where('STORE_CODE','like','%'.$search.'%');
            $q->orwhere('EXPORT_SUB_NAME','like','%'.$search.'%');
            $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');
            $q->orwhere('SUP_UNIT_NAME','like','%'.$search.'%');
        }) 
        ->sum('EXPORT_SUB_VALUE');
        $sumvalue =  $sumvalue1 - $sumvalue2;
    
        $infosuppliesinven= DB::table('supplies_inven')->orderby('INVEN_ID', 'asc')->get();


        $sumvalue =  $sumvalue1 - $sumvalue2;


        $checkreceive = '';
        $search ='';

        return view('manager_warehouse.warehousestorehouse_excel',[
             'infowarehousestores' => $infowarehousestore,
             'infosuppliesinvens'=> $infosuppliesinven,
             'sumvalue'=> $sumvalue,
             'checkreceive'=> $checkreceive,
             'search'=> $search,
        ]);
    }

    public function storehouse_detail(Request $request,$id)
    {


        $storereceivesub= DB::table('warehouse_store_receive_sub')
        ->select('warehouse_store_receive_sub.created_at','SUP_TYPE_NAME','RECEIVE_SUB_NAME','RECEIVE_SUB_LOT','RECEIVE_SUB_AMOUNT','RECEIVE_SUB_ID','RECEIVE_SUB_PICE_UNIT','RECEIVE_SUB_EXP_DATE','RECEIVE_ACCEPT_FROM','RECEIVE_PERSON_NAME','SUP_UNIT_NAME','RECEIVE_SUB_GEN_DATE','warehouse_check_receive.RECEIVE_CHECK_DATE')
        ->leftJoin('warehouse_store','warehouse_store.STORE_ID','=','warehouse_store_receive_sub.STORE_ID')
        ->leftJoin('warehouse_sup_type','warehouse_sup_type.ID_SUP_TYPE','=','warehouse_store_receive_sub.RECEIVE_SUB_TYPE')
        ->leftJoin('warehouse_check_receive','warehouse_check_receive.RECEIVE_ID','=','warehouse_store_receive_sub.RECEIVE_ID')
        ->leftJoin('supplies_unit_ref','warehouse_store.STORE_UNIT','=','supplies_unit_ref.ID')
        ->where('warehouse_store_receive_sub.STORE_ID','=',$id)->get();
   

        $storeexportsub= DB::table('warehouse_store_export_sub')
        ->select('warehouse_store_export_sub.WAREHOUSE_REQUEST_CODE','CYCLE_DISBURSE_NAME','EXPORT_SUB_NAME','EXPORT_SUB_LOT','HR_DEPARTMENT_SUB_SUB_NAME','EXPORT_SUB_AMOUNT','SUP_UNIT_NAME','EXPORT_SUB_PICE_UNIT','EXPORT_SUB_EXP_DATE','HR_FNAME','HR_LNAME','WAREHOUSE_PAYDAY')
        ->leftJoin('warehouse_disburse_cycle','warehouse_store_export_sub.WAREHOUSE_TYPE_CYCLE','=','warehouse_disburse_cycle.ID_CYCLE')
        ->leftJoin('hrd_department_sub_sub','warehouse_store_export_sub.EXPORT_SUB_TREASURY_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->leftJoin('supplies_unit_ref','warehouse_store_export_sub.EXPORT_SUB_UNIT','=','supplies_unit_ref.ID')
        ->leftJoin('warehouse_request','warehouse_request.WAREHOUSE_REQUEST_CODE','=','warehouse_store_export_sub.WAREHOUSE_REQUEST_CODE')
        ->leftJoin('hrd_person','warehouse_store_export_sub.EXPORT_SUB_USER_ID','=','hrd_person.ID')
        ->where('STORE_ID','=',$id)->get();
        

        $warehousestore= DB::table('warehouse_store')->where('STORE_ID','=',$id)->first();

        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;
        }

        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';
        $status = '';
       

        return view('manager_warehouse.storehouse_detail',[
            'storereceivesubs' => $storereceivesub,
            'storeexportsubs' => $storeexportsub,
            'warehousestore' => $warehousestore,
            'idstore' =>$id,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
          
       ]);
    }
    public function storehouse_detail_excel(Request $request,$id)
    {
       
       
        $storereceivesub= DB::table('warehouse_store_receive_sub')
        ->select('warehouse_store_receive_sub.created_at','SUP_TYPE_NAME','RECEIVE_SUB_NAME','RECEIVE_SUB_LOT','RECEIVE_SUB_AMOUNT','RECEIVE_SUB_ID','RECEIVE_SUB_PICE_UNIT','RECEIVE_SUB_EXP_DATE','RECEIVE_ACCEPT_FROM','RECEIVE_PERSON_NAME','SUP_UNIT_NAME','RECEIVE_SUB_GEN_DATE','warehouse_check_receive.RECEIVE_CHECK_DATE')
        ->leftJoin('warehouse_store','warehouse_store.STORE_ID','=','warehouse_store_receive_sub.STORE_ID')
        ->leftJoin('warehouse_sup_type','warehouse_sup_type.ID_SUP_TYPE','=','warehouse_store_receive_sub.RECEIVE_SUB_TYPE')
        ->leftJoin('warehouse_check_receive','warehouse_check_receive.RECEIVE_ID','=','warehouse_store_receive_sub.RECEIVE_ID')
        ->leftJoin('supplies_unit_ref','warehouse_store.STORE_UNIT','=','supplies_unit_ref.ID')
        ->where('warehouse_store_receive_sub.STORE_ID','=',$id)->get();
   

        $storeexportsub= DB::table('warehouse_store_export_sub')
        ->select('warehouse_store_export_sub.WAREHOUSE_REQUEST_CODE','CYCLE_DISBURSE_NAME','EXPORT_SUB_NAME','EXPORT_SUB_LOT','HR_DEPARTMENT_SUB_SUB_NAME','EXPORT_SUB_AMOUNT','SUP_UNIT_NAME','EXPORT_SUB_PICE_UNIT','EXPORT_SUB_EXP_DATE','HR_FNAME','HR_LNAME','WAREHOUSE_PAYDAY')
        ->leftJoin('warehouse_disburse_cycle','warehouse_store_export_sub.WAREHOUSE_TYPE_CYCLE','=','warehouse_disburse_cycle.ID_CYCLE')
        ->leftJoin('hrd_department_sub_sub','warehouse_store_export_sub.EXPORT_SUB_TREASURY_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->leftJoin('supplies_unit_ref','warehouse_store_export_sub.EXPORT_SUB_UNIT','=','supplies_unit_ref.ID')
        ->leftJoin('warehouse_request','warehouse_request.WAREHOUSE_REQUEST_CODE','=','warehouse_store_export_sub.WAREHOUSE_REQUEST_CODE')
        ->leftJoin('hrd_person','warehouse_store_export_sub.EXPORT_SUB_USER_ID','=','hrd_person.ID')
        ->where('STORE_ID','=',$id)->get();

        $storereceivesub_head= DB::table('warehouse_store')      
        ->leftJoin('supplies_unit_ref','warehouse_store.STORE_UNIT','=','supplies_unit_ref.ID')
        ->where('warehouse_store.STORE_ID','=',$id)->first();

        $warehousestore= DB::table('warehouse_store')->where('STORE_ID','=',$id)->first();

        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;
        }

        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';
        $status = '';
       

        return view('manager_warehouse.storehouse_detail_excel',[
            'storereceivesubs' => $storereceivesub,
            'storeexportsubs' => $storeexportsub,
            'warehousestore' => $warehousestore,
            'idstore' =>$id,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'storereceivesub_head' => $storereceivesub_head,
       ]);
    }
    public function storehousesearch(Request $request)
    {
    
        $typestore = $request->RECEIVE_STORE;
        $search = $request->search;
    
        if ($typestore == '') {
            $infowarehousestore= DB::table('warehouse_store')
                ->leftJoin('supplies_unit_ref', 'warehouse_store.STORE_UNIT', '=', 'supplies_unit_ref.ID') 
                ->leftJoin('supplies', 'warehouse_store.STORE_CODE', '=', 'supplies.SUP_FSN_NUM')           
                ->leftJoin('supplies_type', 'supplies_type.SUP_TYPE_ID', '=', 'supplies.SUP_TYPE_ID')
                ->where(function($q) use ($search){
                    $q->where('STORE_CODE','like','%'.$search.'%');
                    $q->orwhere('STORE_NAME','like','%'.$search.'%');
                    $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');
                    $q->orwhere('SUP_UNIT_NAME','like','%'.$search.'%');
                })                     
                ->orderBy('STORE_ID', 'desc')
                ->get();

       

                $sumvalue1 = DB::table('warehouse_store_receive_sub')
                ->leftJoin('warehouse_store', 'warehouse_store.STORE_ID', '=', 'warehouse_store_receive_sub.STORE_ID')           
                ->leftJoin('supplies', 'warehouse_store.STORE_CODE', '=', 'supplies.SUP_FSN_NUM')    
                ->leftJoin('supplies_unit_ref', 'warehouse_store.STORE_UNIT', '=', 'supplies_unit_ref.ID') 
                ->leftJoin('supplies_type', 'supplies_type.SUP_TYPE_ID', '=', 'supplies.SUP_TYPE_ID')
                ->where(function($q) use ($search){
                    $q->where('STORE_CODE','like','%'.$search.'%');
                    $q->orwhere('RECEIVE_SUB_NAME','like','%'.$search.'%');
                    $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');
                    $q->orwhere('SUP_UNIT_NAME','like','%'.$search.'%');
                })                     
                ->sum('RECEIVE_SUB_VALUE');

                $sumvalue2 = DB::table('warehouse_store_export_sub')
                ->leftJoin('warehouse_store', 'warehouse_store.STORE_ID', '=', 'warehouse_store_export_sub.STORE_ID')           
                ->leftJoin('supplies', 'warehouse_store.STORE_CODE', '=', 'supplies.SUP_FSN_NUM')    
                ->leftJoin('supplies_unit_ref', 'warehouse_store.STORE_UNIT', '=', 'supplies_unit_ref.ID') 
                ->leftJoin('supplies_type', 'supplies_type.SUP_TYPE_ID', '=', 'supplies.SUP_TYPE_ID')
                ->where(function($q) use ($search){
                    $q->where('STORE_CODE','like','%'.$search.'%');
                    $q->orwhere('EXPORT_SUB_NAME','like','%'.$search.'%');
                    $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');
                    $q->orwhere('SUP_UNIT_NAME','like','%'.$search.'%');
                })   
                ->sum('EXPORT_SUB_VALUE');
        
                $sumvalue =  $sumvalue1 - $sumvalue2;

        }else{    
            $infowarehousestore= DB::table('warehouse_store')
            ->leftJoin('supplies_unit_ref', 'warehouse_store.STORE_UNIT', '=', 'supplies_unit_ref.ID') 
            ->leftJoin('supplies', 'warehouse_store.STORE_CODE', '=', 'supplies.SUP_FSN_NUM')           
            ->leftJoin('supplies_type', 'supplies_type.SUP_TYPE_ID', '=', 'supplies.SUP_TYPE_ID')                     
            ->where('warehouse_store.STORE_TYPE', '=', $typestore)
            ->where(function($q) use ($search){
                $q->where('STORE_CODE','like','%'.$search.'%');
                $q->orwhere('STORE_NAME','like','%'.$search.'%');
                $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');
                $q->orwhere('SUP_UNIT_NAME','like','%'.$search.'%');
            })  
            ->orderBy('STORE_ID', 'desc')
            ->get();

            $sumvalue1 = DB::table('warehouse_store_receive_sub')
            ->leftJoin('warehouse_store', 'warehouse_store_receive_sub.STORE_ID', '=', 'warehouse_store.STORE_ID')
            ->leftJoin('supplies', 'warehouse_store.STORE_CODE', '=', 'supplies.SUP_FSN_NUM')    
            ->leftJoin('supplies_unit_ref', 'warehouse_store.STORE_UNIT', '=', 'supplies_unit_ref.ID') 
            ->leftJoin('supplies_type', 'supplies_type.SUP_TYPE_ID', '=', 'supplies.SUP_TYPE_ID')
            ->where('warehouse_store.STORE_TYPE', '=', $typestore)
            ->where(function($q) use ($search){
                $q->where('STORE_CODE','like','%'.$search.'%');
                $q->orwhere('RECEIVE_SUB_NAME','like','%'.$search.'%');
                $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');
                $q->orwhere('SUP_UNIT_NAME','like','%'.$search.'%');
            }) 
            ->sum('RECEIVE_SUB_VALUE');

            $sumvalue2 = DB::table('warehouse_store_export_sub')
            ->leftJoin('warehouse_store', 'warehouse_store.STORE_ID', '=', 'warehouse_store_export_sub.STORE_ID')           
            ->leftJoin('supplies', 'warehouse_store.STORE_CODE', '=', 'supplies.SUP_FSN_NUM')    
            ->leftJoin('supplies_unit_ref', 'warehouse_store.STORE_UNIT', '=', 'supplies_unit_ref.ID') 
            ->leftJoin('supplies_type', 'supplies_type.SUP_TYPE_ID', '=', 'supplies.SUP_TYPE_ID')
            ->where('warehouse_store.STORE_TYPE', '=', $typestore)
            ->where(function($q) use ($search){
                $q->where('STORE_CODE','like','%'.$search.'%');
                $q->orwhere('EXPORT_SUB_NAME','like','%'.$search.'%');
                $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');
                $q->orwhere('SUP_UNIT_NAME','like','%'.$search.'%');
            }) 
            ->sum('EXPORT_SUB_VALUE');
    
            $sumvalue =  $sumvalue1 - $sumvalue2;

           
    
        }      
        $infosuppliesinven= DB::table('supplies_inven')->orderby('INVEN_ID', 'asc')->get();
    

        $checkreceive =  $typestore;
    
     

        return view('manager_warehouse.warehousestorehouse',[
             'infowarehousestores' => $infowarehousestore,
             'infosuppliesinvens'=> $infosuppliesinven,
             'sumvalue'=> $sumvalue,
             'checkreceive'=> $checkreceive,
             'search'=> $search,
        ]);
    }

    
    public function storehousesub(Request $request,$id)
    {

        $storereceivesub= DB::table('warehouse_store_receive_sub')
        ->select('warehouse_store_receive_sub.created_at','SUP_TYPE_NAME','RECEIVE_SUB_NAME','RECEIVE_SUB_LOT','RECEIVE_SUB_AMOUNT','RECEIVE_SUB_ID','RECEIVE_SUB_PICE_UNIT','RECEIVE_SUB_EXP_DATE','RECEIVE_ACCEPT_FROM','RECEIVE_PERSON_NAME','SUP_UNIT_NAME','RECEIVE_SUB_GEN_DATE','warehouse_check_receive.RECEIVE_CHECK_DATE')
        ->leftJoin('warehouse_store','warehouse_store.STORE_ID','=','warehouse_store_receive_sub.STORE_ID')
        ->leftJoin('warehouse_sup_type','warehouse_sup_type.ID_SUP_TYPE','=','warehouse_store_receive_sub.RECEIVE_SUB_TYPE')
        ->leftJoin('warehouse_check_receive','warehouse_check_receive.RECEIVE_ID','=','warehouse_store_receive_sub.RECEIVE_ID')
        ->leftJoin('supplies_unit_ref','warehouse_store.STORE_UNIT','=','supplies_unit_ref.ID')
        ->where('warehouse_store_receive_sub.STORE_ID','=',$id)->get();
   

        $storeexportsub= DB::table('warehouse_store_export_sub')
        ->select('warehouse_store_export_sub.WAREHOUSE_REQUEST_CODE','CYCLE_DISBURSE_NAME','EXPORT_SUB_NAME','EXPORT_SUB_LOT','HR_DEPARTMENT_SUB_SUB_NAME','EXPORT_SUB_AMOUNT','SUP_UNIT_NAME','EXPORT_SUB_PICE_UNIT','EXPORT_SUB_EXP_DATE','HR_FNAME','HR_LNAME','WAREHOUSE_PAYDAY','EXPORT_SUB_ID')
        ->leftJoin('warehouse_disburse_cycle','warehouse_store_export_sub.WAREHOUSE_TYPE_CYCLE','=','warehouse_disburse_cycle.ID_CYCLE')
        ->leftJoin('hrd_department_sub_sub','warehouse_store_export_sub.EXPORT_SUB_TREASURY_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->leftJoin('supplies_unit_ref','warehouse_store_export_sub.EXPORT_SUB_UNIT','=','supplies_unit_ref.ID')
        ->leftJoin('warehouse_request','warehouse_request.WAREHOUSE_REQUEST_CODE','=','warehouse_store_export_sub.WAREHOUSE_REQUEST_CODE')
        ->leftJoin('hrd_person','warehouse_store_export_sub.EXPORT_SUB_USER_ID','=','hrd_person.ID')
        ->where('STORE_ID','=',$id)->get();

        $warehousestore= DB::table('warehouse_store')->where('STORE_ID','=',$id)->first();

        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;
        }

        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';
        $status = '';
       

        return view('manager_warehouse.warehousestorehouse_sub',[
            'storereceivesubs' => $storereceivesub,
            'storeexportsubs' => $storeexportsub,
            'warehousestore' => $warehousestore,
            'idstore' =>$id,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
       ]);
    }

    public function storehousesubsearch(Request $request)
    {      
        $id = $request->STORE_ID;
        $warehousestore= DB::table('warehouse_store')->where('STORE_ID','=',$id)->first();

        $datebigin = $request->get('DATE_BIGIN');
        $dateend = $request->get('DATE_END');

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

            $storereceivesub= DB::table('warehouse_store_receive_sub')
            ->leftJoin('warehouse_store','warehouse_store.STORE_ID','=','warehouse_store_receive_sub.STORE_ID')
            ->leftJoin('warehouse_sup_type','warehouse_sup_type.ID_SUP_TYPE','=','warehouse_store_receive_sub.RECEIVE_SUB_TYPE')
            ->leftJoin('warehouse_check_receive','warehouse_check_receive.RECEIVE_ID','=','warehouse_store_receive_sub.RECEIVE_ID')
            ->leftJoin('supplies_unit_ref','warehouse_store.STORE_UNIT','=','supplies_unit_ref.ID')
            ->WhereBetween('RECEIVE_SUB_GEN_DATE',[$from,$to])
            ->where('warehouse_store_receive_sub.STORE_ID','=',$id)->get();
       
    
            $storeexportsub= DB::table('warehouse_store_export_sub')
            ->leftJoin('warehouse_disburse_cycle','warehouse_store_export_sub.WAREHOUSE_TYPE_CYCLE','=','warehouse_disburse_cycle.ID_CYCLE')
            ->leftJoin('hrd_department_sub_sub','warehouse_store_export_sub.EXPORT_SUB_TREASURY_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
            ->leftJoin('supplies_unit_ref','warehouse_store_export_sub.EXPORT_SUB_UNIT','=','supplies_unit_ref.ID')
            ->leftJoin('hrd_person','warehouse_store_export_sub.EXPORT_SUB_USER_ID','=','hrd_person.ID')
            ->WhereBetween('EXPORT_SUB_GEN_DATE',[$from,$to])
            ->where('warehouse_store_export_sub.STORE_ID','=',$id)->get();
      
            
    
        return view('manager_warehouse.warehousestorehouse_sub',[
             'storereceivesubs' => $storereceivesub,
             'storeexportsubs'=> $storeexportsub,
             'idstore' =>$id,
             'warehousestore' => $warehousestore,
             'displaydate_bigen'=> $displaydate_bigen,
             'displaydate_end'=> $displaydate_end,
        ]);
    }
    


    //==========================  คลังย่อย ===================================//

    public function treasury(Request $request)
    {
        if($request->method() === 'POST'){
            $typestore = $request->DEPART_STORE;
            $search = $request->search;
            session([
                'manager_warehouse.treasury.typestore' => $typestore,
                'manager_warehouse.treasury.search' => $search
            ]);
        }elseif(Session::has('manager_warehouse.treasury')){
            $typestore = session('manager_warehouse.treasury.typestore');
            $search = session('manager_warehouse.treasury.typestore');
        }else{
            $typestore = '';
            $search = '';
        }
    
        if ($typestore == '') {
            $infowarehousetreasury= DB::table('warehouse_treasury')
                ->leftJoin('supplies_unit_ref','warehouse_treasury.TREASURY_UNIT','=','supplies_unit_ref.ID')
                ->leftJoin('supplies', 'warehouse_treasury.TREASURY_CODE', '=', 'supplies.SUP_FSN_NUM')           
                ->leftJoin('supplies_type', 'supplies_type.SUP_TYPE_ID', '=', 'supplies.SUP_TYPE_ID') 
                ->where(function($q) use ($search){
                    $q->where('TREASURY_CODE','like','%'.$search.'%');
                    $q->orwhere('TREASURY_NAME','like','%'.$search.'%');
                    $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');
                    $q->orwhere('TREASURY_TYPE_NAME','like','%'.$search.'%');
                    $q->orwhere('SUP_UNIT_NAME','like','%'.$search.'%');     
               })
                ->orderBy('TREASURY_ID', 'desc') 
                ->get();
                $sumvalue1 = DB::table('warehouse_treasury_receive_sub')
                ->leftJoin('warehouse_treasury', 'warehouse_treasury.TREASURY_ID', '=', 'warehouse_treasury_receive_sub.TREASURY_ID')          
                ->leftJoin('supplies_unit_ref','warehouse_treasury.TREASURY_UNIT','=','supplies_unit_ref.ID')
                ->leftJoin('supplies', 'warehouse_treasury.TREASURY_CODE', '=', 'supplies.SUP_FSN_NUM')           
                ->leftJoin('supplies_type', 'supplies_type.SUP_TYPE_ID', '=', 'supplies.SUP_TYPE_ID') 
                ->where(function($q) use ($search){
                    $q->where('TREASURY_CODE','like','%'.$search.'%');
                    $q->orwhere('TREASURY_NAME','like','%'.$search.'%');
                    $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');
                    $q->orwhere('TREASURY_TYPE_NAME','like','%'.$search.'%');
                    $q->orwhere('SUP_UNIT_NAME','like','%'.$search.'%');     
               })
                ->sum('TREASURY_RECEIVE_SUB_VALUE');
                $sumvalue2 = DB::table('warehouse_treasury_export_sub')
                ->leftJoin('warehouse_treasury', 'warehouse_treasury.TREASURY_ID', '=', 'warehouse_treasury_export_sub.TREASURY_ID')           
                ->leftJoin('supplies_unit_ref','warehouse_treasury.TREASURY_UNIT','=','supplies_unit_ref.ID')
                ->leftJoin('supplies', 'warehouse_treasury.TREASURY_CODE', '=', 'supplies.SUP_FSN_NUM')           
                ->leftJoin('supplies_type', 'supplies_type.SUP_TYPE_ID', '=', 'supplies.SUP_TYPE_ID') 
                ->where(function($q) use ($search){
                    $q->where('TREASURY_CODE','like','%'.$search.'%');
                    $q->orwhere('TREASURY_NAME','like','%'.$search.'%');
                    $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');
                    $q->orwhere('TREASURY_TYPE_NAME','like','%'.$search.'%');
                    $q->orwhere('SUP_UNIT_NAME','like','%'.$search.'%');     
               })
                ->sum('TREASURY_EXPORT_SUB_VALUE');
                $sumvalue =  $sumvalue1 - $sumvalue2;
        }else{    
            $infowarehousetreasury= DB::table('warehouse_treasury')
            ->leftJoin('supplies_unit_ref','warehouse_treasury.TREASURY_UNIT','=','supplies_unit_ref.ID')
            ->leftJoin('supplies', 'warehouse_treasury.TREASURY_CODE', '=', 'supplies.SUP_FSN_NUM')           
            ->leftJoin('supplies_type', 'supplies_type.SUP_TYPE_ID', '=', 'supplies.SUP_TYPE_ID') 
            ->where('warehouse_treasury.TREASURY_TYPE', '=', $typestore)
            ->where(function($q) use ($search){
                $q->where('TREASURY_CODE','like','%'.$search.'%');
                $q->orwhere('TREASURY_NAME','like','%'.$search.'%');
                $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');
                $q->orwhere('TREASURY_TYPE_NAME','like','%'.$search.'%');
                $q->orwhere('SUP_UNIT_NAME','like','%'.$search.'%');     
           })
            ->orderBy('TREASURY_ID', 'desc') 
            ->get();
            $sumvalue1 = DB::table('warehouse_treasury_receive_sub')
            ->leftJoin('warehouse_treasury', 'warehouse_treasury.TREASURY_ID', '=', 'warehouse_treasury_receive_sub.TREASURY_ID')          
            ->leftJoin('supplies_unit_ref','warehouse_treasury.TREASURY_UNIT','=','supplies_unit_ref.ID')
            ->leftJoin('supplies', 'warehouse_treasury.TREASURY_CODE', '=', 'supplies.SUP_FSN_NUM')           
            ->leftJoin('supplies_type', 'supplies_type.SUP_TYPE_ID', '=', 'supplies.SUP_TYPE_ID') 
            ->where('warehouse_treasury.TREASURY_TYPE', '=', $typestore)
            ->where(function($q) use ($search){
                $q->where('TREASURY_CODE','like','%'.$search.'%');
                $q->orwhere('TREASURY_NAME','like','%'.$search.'%');
                $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');
                $q->orwhere('TREASURY_TYPE_NAME','like','%'.$search.'%');
                $q->orwhere('SUP_UNIT_NAME','like','%'.$search.'%');     
           })
            ->sum('TREASURY_RECEIVE_SUB_VALUE');
            $sumvalue2 = DB::table('warehouse_treasury_export_sub')
            ->leftJoin('warehouse_treasury', 'warehouse_treasury.TREASURY_ID', '=', 'warehouse_treasury_export_sub.TREASURY_ID')           
            ->leftJoin('supplies_unit_ref','warehouse_treasury.TREASURY_UNIT','=','supplies_unit_ref.ID')
            ->leftJoin('supplies', 'warehouse_treasury.TREASURY_CODE', '=', 'supplies.SUP_FSN_NUM')           
            ->leftJoin('supplies_type', 'supplies_type.SUP_TYPE_ID', '=', 'supplies.SUP_TYPE_ID') 
            ->where('warehouse_treasury.TREASURY_TYPE', '=', $typestore)
            ->where(function($q) use ($search){
                $q->where('TREASURY_CODE','like','%'.$search.'%');
                $q->orwhere('TREASURY_NAME','like','%'.$search.'%');
                $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');
                $q->orwhere('TREASURY_TYPE_NAME','like','%'.$search.'%');
                $q->orwhere('SUP_UNIT_NAME','like','%'.$search.'%');     
           })
            ->sum('TREASURY_EXPORT_SUB_VALUE');
            $sumvalue =  $sumvalue1 - $sumvalue2;
        }  
        $infodepart = DB::table('hrd_department_sub_sub')->get();
        $checkreceive = $typestore;
        return view('manager_warehouse.warehousetreasury',[
            'infowarehousetreasurys' => $infowarehousetreasury,
            'infodeparts' =>  $infodepart,
            'sumvalue' =>  $sumvalue,
            'checkreceive' =>  $checkreceive,
            'search' =>  $search,
       ]);
    }

    public function treasury_small(Request $request)
    {
        $small_id = null;
        if ($request->has('small_id')) {
            $small_id = $request->input('small_id');
        }
        
        if(!empty($small_id)){
            $stock_cards = DB::table('warehouse_treasury_small')
            ->leftJoin('supplies_unit_ref','warehouse_treasury_small.TREASURY_SMALL_UNIT','=','supplies_unit_ref.ID')
            ->leftJoin('supplies','warehouse_treasury_small.TREASURY_SMALL_CODE','=','supplies.SUP_FSN_NUM')
            ->leftJoin('supplies_type','supplies.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
            ->where('TREASURY_SMALL_TYPE', '=', $small_id)    
            ->orderBy('TREASURY_SMALL_ID', 'desc') 
            ->get();

            $balance1  =  DB::table('warehouse_treasury_receive_small')
                ->leftJoin('warehouse_treasury_small', 'warehouse_treasury_receive_small.TREASURY_ID', '=', 'warehouse_treasury_small.TREASURY_SMALL_ID')
                ->where('warehouse_treasury_small.TREASURY_SMALL_TYPE', '=', $small_id)  
                ->sum('TREASURY_RECEIVE_SMALL_VALUE');
            $balance2  =  DB::table('warehouse_treasury_export_small')
                ->leftJoin('warehouse_treasury_small', 'warehouse_treasury_export_small.TREASURY_ID', '=', 'warehouse_treasury_small.TREASURY_SMALL_ID')
                ->where('warehouse_treasury_small.TREASURY_SMALL_TYPE', '=', $small_id)  
                ->sum('TREASURY_EXPORT_SMALL_VALUE');
        }else{
            $stock_cards = DB::table('warehouse_treasury_small')
            ->leftJoin('supplies_unit_ref','warehouse_treasury_small.TREASURY_SMALL_UNIT','=','supplies_unit_ref.ID')
            ->leftJoin('supplies','warehouse_treasury_small.TREASURY_SMALL_CODE','=','supplies.SUP_FSN_NUM')
            ->leftJoin('supplies_type','supplies.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')  
            ->orderBy('TREASURY_SMALL_ID', 'desc') 
            ->get();

            $balance1  =  DB::table('warehouse_treasury_receive_small')->sum('TREASURY_RECEIVE_SMALL_VALUE');
            $balance2  =  DB::table('warehouse_treasury_export_small')->sum('TREASURY_EXPORT_SMALL_VALUE');
        }
        

        $small_hospital  =  DB::table('warehouse_smallhos')->get([
            'WAREHOUSE_SMALLHOS_ID AS id',
            'WAREHOUSE_SMALLHOS_NAME AS name',
        ]);

        
        $total_amount = $balance1 - $balance2;

        return view('manager_warehouse.warehousetreasury_small',[
            "stock_cards" => $stock_cards,
            "total_amount" => $total_amount,
            "small_hospital" => $small_hospital,
       ]);
    }
    
    public function treasury_small_detail(Request $request)
    {

        $small_id = $request->small_id;

       $storereceivesub= DB::table('warehouse_treasury_receive_small')
    ->leftJoin('warehouse_request_sub','warehouse_treasury_receive_small.WAREHOUSE_REQUEST_SMALL_ID','=','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_ID')
    ->leftJoin('warehouse_request','warehouse_request_sub.WAREHOUSE_REQUEST_ID','=','warehouse_request.WAREHOUSE_ID')
    ->leftJoin('warehouse_disburse_cycle','warehouse_request.WAREHOUSE_TYPE_CYCLE','=','warehouse_disburse_cycle.ID_CYCLE')
    ->leftJoin('warehouse_smallhos','warehouse_request.WAREHOUSE_SMALLHOS','=','warehouse_smallhos.WAREHOUSE_SMALLHOS_ID')
    ->leftJoin('supplies_unit_ref','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_UNIT','=','supplies_unit_ref.ID')
    ->where('TREASURY_ID','=',$small_id)
    ->orderBy ('TREASURY_RECEIVE_SMALL_ID','asc')
    ->get();
    
    // dd($storereceivesub);

    $storeexportsub= DB::table('warehouse_treasury_export_small')
    ->leftJoin('warehouse_treasury_pay_small','warehouse_treasury_pay_small.TREASURT_PAY_SMALL_ID','=','warehouse_treasury_export_small.TREASURT_PAY_SMALL_ID')      
    ->leftJoin('supplies_unit_ref','warehouse_treasury_export_small.TREASURY_EXPORT_SMALL_UNIT','=','supplies_unit_ref.ID')
    ->where('TREASURY_ID','=',$small_id)
    ->orderBy ('TREASURY_EXPORT_SMALL_ID','desc')
    ->get();

    $warehousetreasury= DB::table('warehouse_treasury_small')->where('TREASURY_SMALL_ID','=',$small_id)->first();
   
    $m_budget = date("m");
    if($m_budget>9){
    $yearbudget = date("Y")+544;
    }else{
    $yearbudget = date("Y")+543;
    }

    $displaydate_bigen = ($yearbudget-544).'-10-01';
    $displaydate_end = ($yearbudget-543).'-09-30';

    //=================================
    $balance1  =  DB::table('warehouse_treasury_receive_small')->where('TREASURY_ID','=',$small_id)->sum('TREASURY_RECEIVE_SMALL_VALUE');
    $balance2  =  DB::table('warehouse_treasury_export_small')->where('TREASURY_ID','=',$small_id)->sum('TREASURY_EXPORT_SMALL_VALUE');

    $balance = $balance1 - $balance2;



    return view('manager_warehouse.warehousetreasury_small_detail',[
        'storereceivesubs' => $storereceivesub,
        'storeexportsubs' => $storeexportsub,
        'warehousetreasury' => $warehousetreasury,
        'displaydate_bigen'=> $displaydate_bigen,
        'displaydate_end'=> $displaydate_end,
        'balance2'=> $balance2,
        'balance'=> $balance,
        'idtreasury' => $small_id
    ]);
    }


    public function treasury_excel(Request $request,$typestore,$search)
    {

 

        if($typestore == 'null'){$typestore = '';}if($search == 'null'){$search = '';}

      
        if ($typestore == '') {
            $infowarehousetreasury= DB::table('warehouse_treasury')
                ->leftJoin('supplies_unit_ref','warehouse_treasury.TREASURY_UNIT','=','supplies_unit_ref.ID')
                ->leftJoin('supplies', 'warehouse_treasury.TREASURY_CODE', '=', 'supplies.SUP_FSN_NUM')           
                ->leftJoin('supplies_type', 'supplies_type.SUP_TYPE_ID', '=', 'supplies.SUP_TYPE_ID') 
                ->where(function($q) use ($search){
                    $q->where('TREASURY_CODE','like','%'.$search.'%');
                    $q->orwhere('TREASURY_NAME','like','%'.$search.'%');
                    $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');
                    $q->orwhere('TREASURY_TYPE_NAME','like','%'.$search.'%');
                    $q->orwhere('SUP_UNIT_NAME','like','%'.$search.'%');     
               })
                ->orderBy('TREASURY_ID', 'desc') 
                ->get();
                $sumvalue1 = DB::table('warehouse_treasury_receive_sub')
                ->leftJoin('warehouse_treasury', 'warehouse_treasury.TREASURY_ID', '=', 'warehouse_treasury_receive_sub.TREASURY_ID')          
                ->leftJoin('supplies_unit_ref','warehouse_treasury.TREASURY_UNIT','=','supplies_unit_ref.ID')
                ->leftJoin('supplies', 'warehouse_treasury.TREASURY_CODE', '=', 'supplies.SUP_FSN_NUM')           
                ->leftJoin('supplies_type', 'supplies_type.SUP_TYPE_ID', '=', 'supplies.SUP_TYPE_ID') 
                ->where(function($q) use ($search){
                    $q->where('TREASURY_CODE','like','%'.$search.'%');
                    $q->orwhere('TREASURY_NAME','like','%'.$search.'%');
                    $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');
                    $q->orwhere('TREASURY_TYPE_NAME','like','%'.$search.'%');
                    $q->orwhere('SUP_UNIT_NAME','like','%'.$search.'%');     
               })
                ->sum('TREASURY_RECEIVE_SUB_VALUE');
                $sumvalue2 = DB::table('warehouse_treasury_export_sub')
                ->leftJoin('warehouse_treasury', 'warehouse_treasury.TREASURY_ID', '=', 'warehouse_treasury_export_sub.TREASURY_ID')           
                ->leftJoin('supplies_unit_ref','warehouse_treasury.TREASURY_UNIT','=','supplies_unit_ref.ID')
                ->leftJoin('supplies', 'warehouse_treasury.TREASURY_CODE', '=', 'supplies.SUP_FSN_NUM')           
                ->leftJoin('supplies_type', 'supplies_type.SUP_TYPE_ID', '=', 'supplies.SUP_TYPE_ID') 
                ->where(function($q) use ($search){
                    $q->where('TREASURY_CODE','like','%'.$search.'%');
                    $q->orwhere('TREASURY_NAME','like','%'.$search.'%');
                    $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');
                    $q->orwhere('TREASURY_TYPE_NAME','like','%'.$search.'%');
                    $q->orwhere('SUP_UNIT_NAME','like','%'.$search.'%');     
               })
                ->sum('TREASURY_EXPORT_SUB_VALUE');
                $sumvalue =  $sumvalue1 - $sumvalue2;
        }else{    
            $infowarehousetreasury= DB::table('warehouse_treasury')
            ->leftJoin('supplies_unit_ref','warehouse_treasury.TREASURY_UNIT','=','supplies_unit_ref.ID')
            ->leftJoin('supplies', 'warehouse_treasury.TREASURY_CODE', '=', 'supplies.SUP_FSN_NUM')           
            ->leftJoin('supplies_type', 'supplies_type.SUP_TYPE_ID', '=', 'supplies.SUP_TYPE_ID') 
            ->where('warehouse_treasury.TREASURY_TYPE', '=', $typestore)
            ->where(function($q) use ($search){
                $q->where('TREASURY_CODE','like','%'.$search.'%');
                $q->orwhere('TREASURY_NAME','like','%'.$search.'%');
                $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');
                $q->orwhere('TREASURY_TYPE_NAME','like','%'.$search.'%');
                $q->orwhere('SUP_UNIT_NAME','like','%'.$search.'%');     
           })
            ->orderBy('TREASURY_ID', 'desc') 
            ->get();
            $sumvalue1 = DB::table('warehouse_treasury_receive_sub')
            ->leftJoin('warehouse_treasury', 'warehouse_treasury.TREASURY_ID', '=', 'warehouse_treasury_receive_sub.TREASURY_ID')          
            ->leftJoin('supplies_unit_ref','warehouse_treasury.TREASURY_UNIT','=','supplies_unit_ref.ID')
            ->leftJoin('supplies', 'warehouse_treasury.TREASURY_CODE', '=', 'supplies.SUP_FSN_NUM')           
            ->leftJoin('supplies_type', 'supplies_type.SUP_TYPE_ID', '=', 'supplies.SUP_TYPE_ID') 
            ->where('warehouse_treasury.TREASURY_TYPE', '=', $typestore)
            ->where(function($q) use ($search){
                $q->where('TREASURY_CODE','like','%'.$search.'%');
                $q->orwhere('TREASURY_NAME','like','%'.$search.'%');
                $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');
                $q->orwhere('TREASURY_TYPE_NAME','like','%'.$search.'%');
                $q->orwhere('SUP_UNIT_NAME','like','%'.$search.'%');     
           })
            ->sum('TREASURY_RECEIVE_SUB_VALUE');
            $sumvalue2 = DB::table('warehouse_treasury_export_sub')
            ->leftJoin('warehouse_treasury', 'warehouse_treasury.TREASURY_ID', '=', 'warehouse_treasury_export_sub.TREASURY_ID')           
            ->leftJoin('supplies_unit_ref','warehouse_treasury.TREASURY_UNIT','=','supplies_unit_ref.ID')
            ->leftJoin('supplies', 'warehouse_treasury.TREASURY_CODE', '=', 'supplies.SUP_FSN_NUM')           
            ->leftJoin('supplies_type', 'supplies_type.SUP_TYPE_ID', '=', 'supplies.SUP_TYPE_ID') 
            ->where('warehouse_treasury.TREASURY_TYPE', '=', $typestore)
            ->where(function($q) use ($search){
                $q->where('TREASURY_CODE','like','%'.$search.'%');
                $q->orwhere('TREASURY_NAME','like','%'.$search.'%');
                $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');
                $q->orwhere('TREASURY_TYPE_NAME','like','%'.$search.'%');
                $q->orwhere('SUP_UNIT_NAME','like','%'.$search.'%');     
           })
            ->sum('TREASURY_EXPORT_SUB_VALUE');
            $sumvalue =  $sumvalue1 - $sumvalue2;
        }  
        $infodepart = DB::table('hrd_department_sub_sub')->get();

        $checkreceive =  $typestore;
      

        return view('manager_warehouse.warehousetreasury_excel',[
            'infowarehousetreasurys' => $infowarehousetreasury,
            'infodeparts' =>  $infodepart,
            'sumvalue' =>  $sumvalue,
            'checkreceive' =>  $checkreceive,
            'search' =>  $search,
       ]);
    }

    public function treasury_detail(Request $request,$id)
    {

        $storereceivesub= DB::table('warehouse_treasury_receive_sub')
        ->leftJoin('warehouse_request_sub','warehouse_treasury_receive_sub.WAREHOUSE_REQUEST_SUB_ID','=','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_ID')
        ->leftJoin('warehouse_request','warehouse_request_sub.WAREHOUSE_REQUEST_ID','=','warehouse_request.WAREHOUSE_ID')
        ->leftJoin('warehouse_disburse_cycle','warehouse_request.WAREHOUSE_TYPE_CYCLE','=','warehouse_disburse_cycle.ID_CYCLE')
        ->leftJoin('hrd_department_sub_sub','warehouse_request.WAREHOUSE_DEP_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->leftJoin('supplies_unit_ref','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_UNIT','=','supplies_unit_ref.ID')
        ->where('TREASURY_ID','=',$id)->get();
        


        $storeexportsub= DB::table('warehouse_treasury_export_sub')->where('TREASURY_ID','=',$id)->get();

        $warehousetreasury= DB::table('warehouse_treasury')->where('TREASURY_ID','=',$id)->first();

        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;
        }

        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';
        $status = '';
    
        $infodepart = DB::table('hrd_department_sub_sub')->get();

        return view('manager_warehouse.treasury_detail',[
            'storereceivesubs' => $storereceivesub,
            'storeexportsubs' => $storeexportsub,
            'warehousetreasury' => $warehousetreasury,
            'idtreasury' => $id,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
       ]);
    }

    public function treasurysearch(Request $request)
    {
           
        $typestore = $request->DEPART_STORE;
        $search = $request->search;
    
        if ($typestore == '') {
            $infowarehousetreasury= DB::table('warehouse_treasury')
                ->leftJoin('supplies_unit_ref','warehouse_treasury.TREASURY_UNIT','=','supplies_unit_ref.ID')
                ->leftJoin('supplies', 'warehouse_treasury.TREASURY_CODE', '=', 'supplies.SUP_FSN_NUM')           
                ->leftJoin('supplies_type', 'supplies_type.SUP_TYPE_ID', '=', 'supplies.SUP_TYPE_ID') 
                ->where(function($q) use ($search){
                    $q->where('TREASURY_CODE','like','%'.$search.'%');
                    $q->orwhere('TREASURY_NAME','like','%'.$search.'%');
                    $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');
                    $q->orwhere('TREASURY_TYPE_NAME','like','%'.$search.'%');
                    $q->orwhere('SUP_UNIT_NAME','like','%'.$search.'%');     
               })
                ->orderBy('TREASURY_ID', 'desc') 
                ->get();

                $sumvalue1 = DB::table('warehouse_treasury_receive_sub')
                ->leftJoin('warehouse_treasury', 'warehouse_treasury.TREASURY_ID', '=', 'warehouse_treasury_receive_sub.TREASURY_ID')          
                ->leftJoin('supplies_unit_ref','warehouse_treasury.TREASURY_UNIT','=','supplies_unit_ref.ID')
                ->leftJoin('supplies', 'warehouse_treasury.TREASURY_CODE', '=', 'supplies.SUP_FSN_NUM')           
                ->leftJoin('supplies_type', 'supplies_type.SUP_TYPE_ID', '=', 'supplies.SUP_TYPE_ID') 
                ->where(function($q) use ($search){
                    $q->where('TREASURY_CODE','like','%'.$search.'%');
                    $q->orwhere('TREASURY_NAME','like','%'.$search.'%');
                    $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');
                    $q->orwhere('TREASURY_TYPE_NAME','like','%'.$search.'%');
                    $q->orwhere('SUP_UNIT_NAME','like','%'.$search.'%');     
               })
                ->sum('TREASURY_RECEIVE_SUB_VALUE');
                
                $sumvalue2 = DB::table('warehouse_treasury_export_sub')
                ->leftJoin('warehouse_treasury', 'warehouse_treasury.TREASURY_ID', '=', 'warehouse_treasury_export_sub.TREASURY_ID')           
                ->leftJoin('supplies_unit_ref','warehouse_treasury.TREASURY_UNIT','=','supplies_unit_ref.ID')
                ->leftJoin('supplies', 'warehouse_treasury.TREASURY_CODE', '=', 'supplies.SUP_FSN_NUM')           
                ->leftJoin('supplies_type', 'supplies_type.SUP_TYPE_ID', '=', 'supplies.SUP_TYPE_ID') 
                ->where(function($q) use ($search){
                    $q->where('TREASURY_CODE','like','%'.$search.'%');
                    $q->orwhere('TREASURY_NAME','like','%'.$search.'%');
                    $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');
                    $q->orwhere('TREASURY_TYPE_NAME','like','%'.$search.'%');
                    $q->orwhere('SUP_UNIT_NAME','like','%'.$search.'%');     
               })
                ->sum('TREASURY_EXPORT_SUB_VALUE');
        
                $sumvalue =  $sumvalue1 - $sumvalue2;
        
               
        }else{    
          
            $infowarehousetreasury= DB::table('warehouse_treasury')
            ->leftJoin('supplies_unit_ref','warehouse_treasury.TREASURY_UNIT','=','supplies_unit_ref.ID')
            ->leftJoin('supplies', 'warehouse_treasury.TREASURY_CODE', '=', 'supplies.SUP_FSN_NUM')           
            ->leftJoin('supplies_type', 'supplies_type.SUP_TYPE_ID', '=', 'supplies.SUP_TYPE_ID') 
            ->where('warehouse_treasury.TREASURY_TYPE', '=', $typestore)
            ->where(function($q) use ($search){
                $q->where('TREASURY_CODE','like','%'.$search.'%');
                $q->orwhere('TREASURY_NAME','like','%'.$search.'%');
                $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');
                $q->orwhere('TREASURY_TYPE_NAME','like','%'.$search.'%');
                $q->orwhere('SUP_UNIT_NAME','like','%'.$search.'%');     
           })
            ->orderBy('TREASURY_ID', 'desc') 
            ->get();

            $sumvalue1 = DB::table('warehouse_treasury_receive_sub')
            ->leftJoin('warehouse_treasury', 'warehouse_treasury.TREASURY_ID', '=', 'warehouse_treasury_receive_sub.TREASURY_ID')          
            ->leftJoin('supplies_unit_ref','warehouse_treasury.TREASURY_UNIT','=','supplies_unit_ref.ID')
            ->leftJoin('supplies', 'warehouse_treasury.TREASURY_CODE', '=', 'supplies.SUP_FSN_NUM')           
            ->leftJoin('supplies_type', 'supplies_type.SUP_TYPE_ID', '=', 'supplies.SUP_TYPE_ID') 
            ->where('warehouse_treasury.TREASURY_TYPE', '=', $typestore)
            ->where(function($q) use ($search){
                $q->where('TREASURY_CODE','like','%'.$search.'%');
                $q->orwhere('TREASURY_NAME','like','%'.$search.'%');
                $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');
                $q->orwhere('TREASURY_TYPE_NAME','like','%'.$search.'%');
                $q->orwhere('SUP_UNIT_NAME','like','%'.$search.'%');     
           })
            ->sum('TREASURY_RECEIVE_SUB_VALUE');
            
            $sumvalue2 = DB::table('warehouse_treasury_export_sub')
            ->leftJoin('warehouse_treasury', 'warehouse_treasury.TREASURY_ID', '=', 'warehouse_treasury_export_sub.TREASURY_ID')           
            ->leftJoin('supplies_unit_ref','warehouse_treasury.TREASURY_UNIT','=','supplies_unit_ref.ID')
            ->leftJoin('supplies', 'warehouse_treasury.TREASURY_CODE', '=', 'supplies.SUP_FSN_NUM')           
            ->leftJoin('supplies_type', 'supplies_type.SUP_TYPE_ID', '=', 'supplies.SUP_TYPE_ID') 
            ->where('warehouse_treasury.TREASURY_TYPE', '=', $typestore)
            ->where(function($q) use ($search){
                $q->where('TREASURY_CODE','like','%'.$search.'%');
                $q->orwhere('TREASURY_NAME','like','%'.$search.'%');
                $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');
                $q->orwhere('TREASURY_TYPE_NAME','like','%'.$search.'%');
                $q->orwhere('SUP_UNIT_NAME','like','%'.$search.'%');     
           })
            ->sum('TREASURY_EXPORT_SUB_VALUE');
    
            $sumvalue =  $sumvalue1 - $sumvalue2;
    
        }  

        $infodepart = DB::table('hrd_department_sub_sub')->get();

        $checkreceive = $typestore;
    
        return view('manager_warehouse.warehousetreasury',[
            'infowarehousetreasurys' => $infowarehousetreasury,
            'infodeparts' =>  $infodepart,
            'sumvalue' =>  $sumvalue,
            'checkreceive' =>  $checkreceive,
            'search' =>  $search,
       ]);
    }

    
    public function treasury_sub(Request $request,$id)
    {

        
        $storereceivesub= DB::table('warehouse_treasury_receive_sub')
        ->leftJoin('warehouse_request_sub','warehouse_treasury_receive_sub.WAREHOUSE_REQUEST_SUB_ID','=','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_ID')
        ->leftJoin('warehouse_request','warehouse_request_sub.WAREHOUSE_REQUEST_ID','=','warehouse_request.WAREHOUSE_ID')
        ->leftJoin('warehouse_disburse_cycle','warehouse_request.WAREHOUSE_TYPE_CYCLE','=','warehouse_disburse_cycle.ID_CYCLE')
        ->leftJoin('hrd_department_sub_sub','warehouse_request.WAREHOUSE_DEP_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->leftJoin('supplies_unit_ref','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_UNIT','=','supplies_unit_ref.ID')
        ->where('TREASURY_ID','=',$id)->get();
        


        $storeexportsub= DB::table('warehouse_treasury_export_sub')->where('TREASURY_ID','=',$id)->get();

        $warehousetreasury= DB::table('warehouse_treasury')->where('TREASURY_ID','=',$id)->first();

        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;
        }

        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';
        $status = '';
    
        return view('manager_warehouse.warehousetreasury_sub',[
            'storereceivesubs' => $storereceivesub,
            'storeexportsubs' => $storeexportsub,
            'warehousetreasury' => $warehousetreasury,
            'idtreasury' => $id,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
       ]);
    }
    
    public function treasurysubsearch(Request $request)
    {      
        $id = $request->TREASURY_ID;

        $datebigin = $request->get('DATE_BIGIN');
        $dateend = $request->get('DATE_END');

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


            $storereceivesub= DB::table('warehouse_treasury_receive_sub')
            ->leftJoin('warehouse_request_sub','warehouse_treasury_receive_sub.WAREHOUSE_REQUEST_SUB_ID','=','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_ID')
            ->leftJoin('warehouse_request','warehouse_request_sub.WAREHOUSE_REQUEST_ID','=','warehouse_request.WAREHOUSE_ID')
            ->leftJoin('warehouse_disburse_cycle','warehouse_request.WAREHOUSE_TYPE_CYCLE','=','warehouse_disburse_cycle.ID_CYCLE')
            ->leftJoin('hrd_department_sub_sub','warehouse_request.WAREHOUSE_DEP_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
            ->leftJoin('supplies_unit_ref','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_UNIT','=','supplies_unit_ref.ID')
            ->WhereBetween('TREASURY_RECEIVE_SUB_GEN_DATE',[$from,$to])
            ->where('TREASURY_ID','=',$id)->get();
            
    
    
            $storeexportsub= DB::table('warehouse_treasury_export_sub')
            ->WhereBetween('TREASURY_EXPORT_SUB_GEN_DATE',[$from,$to])
            ->where('TREASURY_ID','=',$id)->get();
    
            $warehousetreasury= DB::table('warehouse_treasury')->where('TREASURY_ID','=',$id)->first();
      
            
    
        return view('manager_warehouse.warehousetreasury_sub',[
             'storereceivesubs' => $storereceivesub,
             'storeexportsubs'=> $storeexportsub,
             'idtreasury' => $id,
             'displaydate_bigen'=> $displaydate_bigen,
             'displaydate_end'=> $displaydate_end,
             'warehousetreasury' => $warehousetreasury,
        ]);
    }

    //-===================================== เบิกจ่าย รพ. ==========================================//
    public function disburse(Request $request)
    {
        if($request->method() === 'POST'){
            $search = $request->get('search');
            $status = $request->get('INVEN_STATUS');
            $yearbudget = $request->get('YEAR_ID');
            $status_check = $request->get('SEND_STATUS');
            $datebigin = $request->get('DATE_BIGIN');
            $dateend = $request->get('DATE_END');
            session([
                'manager_warehouse.disburse.search' => $search,
                'manager_warehouse.disburse.status' => $status,
                'manager_warehouse.disburse.yearbudget' => $yearbudget,
                'manager_warehouse.disburse.status_check' => $status_check,
                'manager_warehouse.disburse.datebigin' => $datebigin,
                'manager_warehouse.disburse.dateend' => $dateend
            ]);
        }elseif(Session::has('manager_warehouse.disburse')){
            $search = session('manager_warehouse.disburse.search');
            $status = session('manager_warehouse.disburse.status');
            $yearbudget = session('manager_warehouse.disburse.yearbudget');
            $status_check = session('manager_warehouse.disburse.status_check');
            $datebigin = session('manager_warehouse.disburse.datebigin');
            $dateend = session('manager_warehouse.disburse.dateend');
        }else{
            $search = '';
            $status = '';
            $yearbudget = getBudgetyear();
            $status_check = '';
            $datebigin = date('01/m/Y');
            $dateend   = date('d/m/Y', strtotime(date('Y-m-1'). '+1month -1days'));
        }

        $date_arrary=explode("/",$datebigin);
        $y_sub_st = $date_arrary[2];
        if($y_sub_st >= 2500){
            $y = $y_sub_st-543;
        }else{
            $y = $y_sub_st;
        }
        $m = $date_arrary[1];
        $d = $date_arrary[0];
        $displaydate_bigen= $y."-".$m."-".$d." 00:00:00";
        $date_arrary_e=explode("/",$dateend);
        $y_sub_e = $date_arrary_e[2];
        if($y_sub_e >= 2500){
            $y_e = $y_sub_e-543;
        }else{
            $y_e = $y_sub_e;
        }
        $m_e = $date_arrary_e[1];
        $d_e = $date_arrary_e[0];
        $displaydate_end= $y_e."-".$m_e."-".$d_e." 23:59:59";

            $from = date($displaydate_bigen);
            $to = date($displaydate_end);

            $iduser = Auth::user()->PERSON_ID;

            if($status == null){
                 
                  $infoinvetfirst = DB::table('supplies_inven_permiss')
                  ->leftjoin('supplies_inven','supplies_inven_permiss.INVENPERMIS_INVEN_ID','=','supplies_inven.INVEN_ID')
                  ->where('INVENPERMIS_PERSON_ID','=',$iduser)
                  ->where('ACTIVE','=','True')
                  ->first();

                  if($infoinvetfirst == null){
                    $statusfirst = '';
                  }else{
                    $statusfirst =  $infoinvetfirst->INVENPERMIS_INVEN_ID;
                  }

                if($status_check == null){
                    $inforwarehouserequest = Warehouserequest::leftJoin('warehouse_request_status','warehouse_request_status.STATUS_CODE','=','warehouse_request.WAREHOUSE_STATUS')
                    ->leftJoin('supplies_inven','supplies_inven.INVEN_ID','=','warehouse_request.WAREHOUSE_INVEN_ID')
                    ->leftJoin('warehouse_smallhos','warehouse_request.WAREHOUSE_SMALLHOS','=','warehouse_smallhos.WAREHOUSE_SMALLHOS_ID')
                    ->leftJoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','warehouse_request.WAREHOUSE_DEP_SUB_SUB_ID')
                    ->where('INVEN_ID','=',$statusfirst)
                    ->where('WAREHOUSE_SMALLHOS','=',null)
                    ->where(function($q) use ($search){
                        $q->where('WAREHOUSE_REQUEST_CODE','like','%'.$search.'%');
                        $q->orwhere('WAREHOUSE_REQUEST_BUY_COMMENT','like','%'.$search.'%');
                        $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');
                        $q->orwhere('WAREHOUSE_SAVE_HR_NAME','like','%'.$search.'%');
                   })
                    ->WhereBetween('WAREHOUSE_DATE_WANT',[$from,$to])
                    ->get();
                }else{
                    $inforwarehouserequest = Warehouserequest::leftJoin('warehouse_request_status','warehouse_request_status.STATUS_CODE','=','warehouse_request.WAREHOUSE_STATUS')
                    ->leftJoin('supplies_inven','supplies_inven.INVEN_ID','=','warehouse_request.WAREHOUSE_INVEN_ID')
                    ->leftJoin('warehouse_smallhos','warehouse_request.WAREHOUSE_SMALLHOS','=','warehouse_smallhos.WAREHOUSE_SMALLHOS_ID')
                    ->leftJoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','warehouse_request.WAREHOUSE_DEP_SUB_SUB_ID')
                    ->where('WAREHOUSE_STATUS','=',$status_check)
                    ->where('INVEN_ID','=',$statusfirst)
                    ->where('WAREHOUSE_SMALLHOS','=',null)
                    ->where(function($q) use ($search){
                        $q->where('WAREHOUSE_REQUEST_CODE','like','%'.$search.'%');
                        $q->orwhere('WAREHOUSE_REQUEST_BUY_COMMENT','like','%'.$search.'%');
                        $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');
                        $q->orwhere('WAREHOUSE_SAVE_HR_NAME','like','%'.$search.'%');
                   })
                    ->WhereBetween('WAREHOUSE_DATE_WANT',[$from,$to])
                    ->get();
                }
            }else{
                if($status_check == null){
                    $inforwarehouserequest = Warehouserequest::leftJoin('warehouse_request_status','warehouse_request_status.STATUS_CODE','=','warehouse_request.WAREHOUSE_STATUS')
                    ->leftJoin('supplies_inven','supplies_inven.INVEN_ID','=','warehouse_request.WAREHOUSE_INVEN_ID')
                    ->leftJoin('warehouse_smallhos','warehouse_request.WAREHOUSE_SMALLHOS','=','warehouse_smallhos.WAREHOUSE_SMALLHOS_ID')
                    ->leftJoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','warehouse_request.WAREHOUSE_DEP_SUB_SUB_ID')
                    ->where('INVEN_ID','=',$status)
                    ->where('WAREHOUSE_SMALLHOS','=',null)
                    ->where(function($q) use ($search){
                        $q->where('WAREHOUSE_REQUEST_CODE','like','%'.$search.'%');
                        $q->orwhere('WAREHOUSE_REQUEST_BUY_COMMENT','like','%'.$search.'%');
                        $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');
                        $q->orwhere('WAREHOUSE_SAVE_HR_NAME','like','%'.$search.'%');
                   })
                    ->WhereBetween('WAREHOUSE_DATE_WANT',[$from,$to])
                    ->get();
            }else{
                $inforwarehouserequest = Warehouserequest::leftJoin('warehouse_request_status','warehouse_request_status.STATUS_CODE','=','warehouse_request.WAREHOUSE_STATUS')
                ->leftJoin('supplies_inven','supplies_inven.INVEN_ID','=','warehouse_request.WAREHOUSE_INVEN_ID')
                ->leftJoin('warehouse_smallhos','warehouse_request.WAREHOUSE_SMALLHOS','=','warehouse_smallhos.WAREHOUSE_SMALLHOS_ID')
                ->leftJoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','warehouse_request.WAREHOUSE_DEP_SUB_SUB_ID')
                ->where('INVEN_ID','=',$status)
                ->where('WAREHOUSE_STATUS','=',$status_check)
                ->where('WAREHOUSE_SMALLHOS','=',null)
                ->where(function($q) use ($search){
                    $q->where('WAREHOUSE_REQUEST_CODE','like','%'.$search.'%');
                    $q->orwhere('WAREHOUSE_REQUEST_BUY_COMMENT','like','%'.$search.'%');
                    $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');
                    $q->orwhere('WAREHOUSE_SAVE_HR_NAME','like','%'.$search.'%');
               })
                ->WhereBetween('WAREHOUSE_DATE_WANT',[$from,$to])
                ->get();
            }
        }

        $infosuppliesinven = DB::table('supplies_inven_permiss')
        ->leftjoin('supplies_inven','supplies_inven_permiss.INVENPERMIS_INVEN_ID','=','supplies_inven.INVEN_ID')
        ->where('INVENPERMIS_PERSON_ID','=',$iduser)
        ->where('ACTIVE','=','True')
        ->get();

        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $statussend = DB::table('warehouse_request_status')->get();
        $invenstatus_check = $status;  
        $status_check = $status_check;
        $year_id = $yearbudget;


        $openform_function = Warehouse_function::where('WAREHOUSEFORM_STATUS','=','True' )->first();
        if ($openform_function != '') {       
            $code = $openform_function->WAREHOUSEFORM_CODE;  
        } else {                      
            $code = '';
        }
    
        return view('manager_warehouse.warehousedisburse',[
            'inforwarehouserequests' => $inforwarehouserequest, 
            'infosuppliesinvens' => $infosuppliesinven, 
            'invenstatus_check' => $invenstatus_check,   
            'displaydate_bigen' => $displaydate_bigen,  
            'displaydate_end' => $displaydate_end, 
            'search' => $search,
            'year_id'=>$year_id,  
            'budgets' =>  $budget, 
            'statussends' => $statussend,  
            'status_check' => $status_check,  
            'codes'=>$code,
        ]);
    }


    public function disbursesearch(Request $request)
    {


        $search = $request->get('search');
        $status = $request->get('INVEN_STATUS');
        $yearbudget = $request->get('YEAR_ID');
        $status_check = $request->get('SEND_STATUS');
        $datebigin = $request->get('DATE_BIGIN');
        $dateend = $request->get('DATE_END');
       
    if (!preg_match("/[0-9]{2}\/[0-9]{2}\/[0-9]{4}/",$datebigin)){
        $date_bigen_c = $datebigin;
      }else{
        $date_bigen_c = Carbon::createFromFormat('d/m/Y', $datebigin)->format('Y-m-d');
      }
       
      if (!preg_match("/[0-9]{2}\/[0-9]{2}\/[0-9]{4}/",$datebigin)){
        $date_end_c = $dateend;
      }else{
        $date_end_c = Carbon::createFromFormat('d/m/Y', $dateend)->format('Y-m-d');
      }


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


                if($status_check == null){
      
                    $inforwarehouserequest = Warehouserequest::leftJoin('warehouse_request_status','warehouse_request_status.STATUS_CODE','=','warehouse_request.WAREHOUSE_STATUS')
                    ->leftJoin('supplies_inven','supplies_inven.INVEN_ID','=','warehouse_request.WAREHOUSE_INVEN_ID')
                    ->leftJoin('warehouse_smallhos','warehouse_request.WAREHOUSE_SMALLHOS','=','warehouse_smallhos.WAREHOUSE_SMALLHOS_ID')
                    ->leftJoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','warehouse_request.WAREHOUSE_DEP_SUB_SUB_ID')
                    ->where(function($q) use ($search){
                        $q->where('WAREHOUSE_REQUEST_CODE','like','%'.$search.'%');
                        $q->orwhere('WAREHOUSE_REQUEST_BUY_COMMENT','like','%'.$search.'%');
                        $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');
                        $q->orwhere('WAREHOUSE_SAVE_HR_NAME','like','%'.$search.'%');
                   })
                    ->WhereBetween('WAREHOUSE_DATE_WANT',[$from,$to])
                    ->get();
                
                }else{

                    $inforwarehouserequest = Warehouserequest::leftJoin('warehouse_request_status','warehouse_request_status.STATUS_CODE','=','warehouse_request.WAREHOUSE_STATUS')
                    ->leftJoin('supplies_inven','supplies_inven.INVEN_ID','=','warehouse_request.WAREHOUSE_INVEN_ID')
                    ->leftJoin('warehouse_smallhos','warehouse_request.WAREHOUSE_SMALLHOS','=','warehouse_smallhos.WAREHOUSE_SMALLHOS_ID')
                    ->leftJoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','warehouse_request.WAREHOUSE_DEP_SUB_SUB_ID')
                    ->where('WAREHOUSE_STATUS','=',$status_check)
                    ->where(function($q) use ($search){
                        $q->where('WAREHOUSE_REQUEST_CODE','like','%'.$search.'%');
                        $q->orwhere('WAREHOUSE_REQUEST_BUY_COMMENT','like','%'.$search.'%');
                        $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');
                        $q->orwhere('WAREHOUSE_SAVE_HR_NAME','like','%'.$search.'%');
                   })
                    ->WhereBetween('WAREHOUSE_DATE_WANT',[$from,$to])
                    ->get();
                }

            }else{
                
                if($status_check == null){

                    $inforwarehouserequest = Warehouserequest::leftJoin('warehouse_request_status','warehouse_request_status.STATUS_CODE','=','warehouse_request.WAREHOUSE_STATUS')
                    ->leftJoin('supplies_inven','supplies_inven.INVEN_ID','=','warehouse_request.WAREHOUSE_INVEN_ID')
                    ->leftJoin('warehouse_smallhos','warehouse_request.WAREHOUSE_SMALLHOS','=','warehouse_smallhos.WAREHOUSE_SMALLHOS_ID')
                    ->leftJoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','warehouse_request.WAREHOUSE_DEP_SUB_SUB_ID')
                    ->where('INVEN_ID','=',$status)
                    ->where(function($q) use ($search){
                        $q->where('WAREHOUSE_REQUEST_CODE','like','%'.$search.'%');
                        $q->orwhere('WAREHOUSE_REQUEST_BUY_COMMENT','like','%'.$search.'%');
                        $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');
                        $q->orwhere('WAREHOUSE_SAVE_HR_NAME','like','%'.$search.'%');
                   })
                    ->WhereBetween('WAREHOUSE_DATE_WANT',[$from,$to])
                    ->get();
                   


  
            }else{


                $inforwarehouserequest = Warehouserequest::leftJoin('warehouse_request_status','warehouse_request_status.STATUS_CODE','=','warehouse_request.WAREHOUSE_STATUS')
                ->leftJoin('supplies_inven','supplies_inven.INVEN_ID','=','warehouse_request.WAREHOUSE_INVEN_ID')
                ->leftJoin('warehouse_smallhos','warehouse_request.WAREHOUSE_SMALLHOS','=','warehouse_smallhos.WAREHOUSE_SMALLHOS_ID')
                ->leftJoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','warehouse_request.WAREHOUSE_DEP_SUB_SUB_ID')
                ->where('INVEN_ID','=',$status)
                ->where('WAREHOUSE_STATUS','=',$status_check)
                ->where(function($q) use ($search){
                    $q->where('WAREHOUSE_REQUEST_CODE','like','%'.$search.'%');
                    $q->orwhere('WAREHOUSE_REQUEST_BUY_COMMENT','like','%'.$search.'%');
                    $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');
                    $q->orwhere('WAREHOUSE_SAVE_HR_NAME','like','%'.$search.'%');
               })
                ->WhereBetween('WAREHOUSE_DATE_WANT',[$from,$to])
                ->get();
        
        

            }


        }

     
        $infosuppliesinven = DB::table('supplies_inven')
        ->where('ACTIVE','=','True')
        ->orderBy('INVEN_NAME', 'asc')
        ->get();

        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $statussend = DB::table('warehouse_request_status')->get();

        $invenstatus_check = $status;  
     
        $status_check = $status_check;

        $year_id = $yearbudget;

        $openform_function = Warehouse_function::where('WAREHOUSEFORM_STATUS','=','True' )->first();
        if ($openform_function != '') {       
            $code = $openform_function->WAREHOUSEFORM_CODE;  
        } else {                      
            $code = '';
        }

    
        return view('manager_warehouse.warehousedisburse',[
            'inforwarehouserequests' => $inforwarehouserequest, 
            'infosuppliesinvens' => $infosuppliesinven, 
            'invenstatus_check' => $invenstatus_check,   
            'displaydate_bigen' => $displaydate_bigen,  
            'displaydate_end' => $displaydate_end, 
            'search' => $search,
            'year_id'=>$year_id,  
            'budgets' =>  $budget, 
            'statussends' => $statussend,  
            'status_check' => $status_check,  
            'codes'=>$code,
        ]);
    }




    public function disburse_excel(Request $request,$displaydate_bigen,$displaydate_end,$status_check,$invenstatus_check,$search)
    {
 
        if($status_check == 'null'){$status_check = '';}if($invenstatus_check == 'null'){$invenstatus_check = '';}if($search == 'null'){$search = '';}
            $status = $invenstatus_check;
      
            $from = date($displaydate_bigen);
            $to = date($displaydate_end);

        

            if($status == ''){


                if($status_check == ''){
      
                    $inforwarehouserequest = Warehouserequest::leftJoin('warehouse_request_status','warehouse_request_status.STATUS_CODE','=','warehouse_request.WAREHOUSE_STATUS')
                    ->leftJoin('supplies_inven','supplies_inven.INVEN_ID','=','warehouse_request.WAREHOUSE_INVEN_ID')
                    ->leftJoin('warehouse_smallhos','warehouse_request.WAREHOUSE_SMALLHOS','=','warehouse_smallhos.WAREHOUSE_SMALLHOS_ID')
                    ->leftJoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','warehouse_request.WAREHOUSE_DEP_SUB_SUB_ID')
                    ->where(function($q) use ($search){
                        $q->where('WAREHOUSE_REQUEST_CODE','like','%'.$search.'%');
                        $q->orwhere('WAREHOUSE_REQUEST_BUY_COMMENT','like','%'.$search.'%');
                        $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');
                        $q->orwhere('WAREHOUSE_SAVE_HR_NAME','like','%'.$search.'%');
                   })
                    ->WhereBetween('WAREHOUSE_DATE_WANT',[$from,$to])
                    ->get();
                
                }else{

                    $inforwarehouserequest = Warehouserequest::leftJoin('warehouse_request_status','warehouse_request_status.STATUS_CODE','=','warehouse_request.WAREHOUSE_STATUS')
                    ->leftJoin('supplies_inven','supplies_inven.INVEN_ID','=','warehouse_request.WAREHOUSE_INVEN_ID')
                    ->leftJoin('warehouse_smallhos','warehouse_request.WAREHOUSE_SMALLHOS','=','warehouse_smallhos.WAREHOUSE_SMALLHOS_ID')
                    ->leftJoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','warehouse_request.WAREHOUSE_DEP_SUB_SUB_ID')
                    ->where('WAREHOUSE_STATUS','=',$status_check)
                    ->where(function($q) use ($search){
                        $q->where('WAREHOUSE_REQUEST_CODE','like','%'.$search.'%');
                        $q->orwhere('WAREHOUSE_REQUEST_BUY_COMMENT','like','%'.$search.'%');
                        $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');
                        $q->orwhere('WAREHOUSE_SAVE_HR_NAME','like','%'.$search.'%');
                   })
                    ->WhereBetween('WAREHOUSE_DATE_WANT',[$from,$to])
                    ->get();
                }

            }else{
                
                if($status_check == ''){

                    $inforwarehouserequest = Warehouserequest::leftJoin('warehouse_request_status','warehouse_request_status.STATUS_CODE','=','warehouse_request.WAREHOUSE_STATUS')
                    ->leftJoin('supplies_inven','supplies_inven.INVEN_ID','=','warehouse_request.WAREHOUSE_INVEN_ID')
                    ->leftJoin('warehouse_smallhos','warehouse_request.WAREHOUSE_SMALLHOS','=','warehouse_smallhos.WAREHOUSE_SMALLHOS_ID')
                    ->leftJoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','warehouse_request.WAREHOUSE_DEP_SUB_SUB_ID')
                    ->where('INVEN_ID','=',$status)
                    ->where(function($q) use ($search){
                        $q->where('WAREHOUSE_REQUEST_CODE','like','%'.$search.'%');
                        $q->orwhere('WAREHOUSE_REQUEST_BUY_COMMENT','like','%'.$search.'%');
                        $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');
                        $q->orwhere('WAREHOUSE_SAVE_HR_NAME','like','%'.$search.'%');
                   })
                    ->WhereBetween('WAREHOUSE_DATE_WANT',[$from,$to])
                    ->get();
                   


  
            }else{


                $inforwarehouserequest = Warehouserequest::leftJoin('warehouse_request_status','warehouse_request_status.STATUS_CODE','=','warehouse_request.WAREHOUSE_STATUS')
                ->leftJoin('supplies_inven','supplies_inven.INVEN_ID','=','warehouse_request.WAREHOUSE_INVEN_ID')
                ->leftJoin('warehouse_smallhos','warehouse_request.WAREHOUSE_SMALLHOS','=','warehouse_smallhos.WAREHOUSE_SMALLHOS_ID')
                ->leftJoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','warehouse_request.WAREHOUSE_DEP_SUB_SUB_ID')
                ->where('INVEN_ID','=',$status)
                ->where('WAREHOUSE_STATUS','=',$status_check)
                ->where(function($q) use ($search){
                    $q->where('WAREHOUSE_REQUEST_CODE','like','%'.$search.'%');
                    $q->orwhere('WAREHOUSE_REQUEST_BUY_COMMENT','like','%'.$search.'%');
                    $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');
                    $q->orwhere('WAREHOUSE_SAVE_HR_NAME','like','%'.$search.'%');
               })
                ->WhereBetween('WAREHOUSE_DATE_WANT',[$from,$to])
                ->get();
        
        

            }


        }
       
     
        $infosuppliesinven = DB::table('supplies_inven')
        ->where('ACTIVE','=','True')
        ->orderBy('INVEN_NAME', 'asc')
        ->get();

        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $statussend = DB::table('warehouse_request_status')->get();

        $invenstatus_check = $status;  
        $search = $search;
        $status_check = $status_check;

 
        return view('manager_warehouse.warehousedisburse_excel',[
            'inforwarehouserequests' => $inforwarehouserequest, 
            'infosuppliesinvens' => $infosuppliesinven, 
            'invenstatus_check' => $invenstatus_check,   
            'displaydate_bigen' => $displaydate_bigen,  
            'displaydate_end' => $displaydate_end, 
            'search' => $search,

            'budgets' =>  $budget, 
            'statussends' => $statussend,  
            'status_check' => $status_check,  
            
        ]);
    }




    public function infopayparcel(Request $request,$id)
    {
        
        $YEAR_ID =  $request->YEAR_ID;
        $DATE_BIGIN =  $request->DATE_BIGIN;
        $DATE_END =  $request->DATE_END;
        $SEND_STATUS =  $request->SEND_STATUS;
        $INVEN_STATUS =  $request->INVEN_STATUS;
        $search =  $request->search;

        $infowarehouserequest = DB::table('warehouse_request')->where('WAREHOUSE_ID','=',$id)->first();

        $infowarehouserequestsub = DB::table('warehouse_request_sub')
        ->leftJoin('supplies','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_DETAIL_ID','=','supplies.ID')
        ->leftJoin('supplies_unit_ref','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_UNIT','=','supplies_unit_ref.ID')
        ->where('WAREHOUSE_REQUEST_ID','=',$id)->get();
        
        
        $count = DB::table('warehouse_request_sub')->where('WAREHOUSE_REQUEST_ID','=',$id)->count();

        $infosupplies= Supplies::leftJoin('supplies_type','supplies.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
        ->leftJoin('supplies_type_kind','supplies.SUP_TYPE_KIND_ID','=','supplies_type_kind.SUP_TYPE_KIND_ID')
        ->where('supplies_type_kind.SUP_TYPE_MASTER_ID','=',1)
        ->orderBy('ID', 'desc') 
        ->get();

        $infosuppliesunitref = DB::table('supplies_unit_ref')->get();


        $infosuppliesdepsubsup = DB::table('hrd_department_sub_sub')
        ->leftjoin('hrd_department_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
        ->get();   
        
        
        $warehousedisbursecycle = DB::table('warehouse_disburse_cycle')->get();   

        $checkeditlist = DB::table('warehouse_functionlist')
        ->where('WAREHOUSE_FUNCTION_ID','=','1')
        ->where('ACTIVE','=','True')->count();


        return view('manager_warehouse.warehousedisburse_parcel',[
            'infowarehouserequest' => $infowarehouserequest,
            'infowarehouserequestsubs' => $infowarehouserequestsub,
            'infosuppliesunitrefs' => $infosuppliesunitref,
            'infosuppliess' => $infosupplies,
            'infosuppliesdepsubsups' => $infosuppliesdepsubsup,
            'warehousedisbursecycles' => $warehousedisbursecycle,
            'count' => $count,
            'YEAR_ID' => $YEAR_ID,
            'DATE_BIGIN' => $DATE_BIGIN,
            'DATE_END' => $DATE_END,
            'SEND_STATUS' => $SEND_STATUS,
            'INVEN_STATUS' => $INVEN_STATUS,
            'search' => $search,
            'checkeditlist' => $checkeditlist,
           
            
        ]);
    }


    

    public function updateinfopayparcel(Request $request)
    {
            
      
             $WAREPAYDAY =  $request->WAREHOUSE_PAYDAY;

            if($WAREPAYDAY != ''){
                $PAYDAY = Carbon::createFromFormat('d/m/Y', $WAREPAYDAY)->format('Y-m-d');
                $date_arrary_st=explode("-",$PAYDAY);  
                $y_sub_st = $date_arrary_st[0]; 
                
                if($y_sub_st >= 2500){
                    $y_st = $y_sub_st-543;
                }else{
                    $y_st = $y_sub_st;
                }
                $m_st = $date_arrary_st[1];
                $d_st = $date_arrary_st[2];  
                $WAREHOUSEPAYDAY= $y_st."-".$m_st."-".$d_st;
                }else{
                $WAREHOUSEPAYDAY= null;
            }

            $WAREHOUSE_ID = $request->WAREHOUSE_ID;

            $SUBMIT = $request->SUBMIT;
         

          if($SUBMIT == 'not_approved'){
            $statusapp = 'Disverify';
          }else{
            $statusapp = 'Verify';
          }


            $addinfowarehouserequest = Warehouserequest::find($WAREHOUSE_ID);
            $addinfowarehouserequest->WAREHOUSE_STORE_ID = $request->WAREHOUSE_STORE_ID;
            $addinfowarehouserequest->WAREHOUSE_TYPE_CYCLE = $request->WAREHOUSE_TYPE_CYCLE;

            $addinfowarehouserequest->WAREHOUSE_PAYDAY = $WAREHOUSEPAYDAY;

            $addinfowarehouserequest->WAREHOUSE_USER_CONFIRM_CHECK_ID = $request->WAREHOUSE_USER_CONFIRM_CHECK_ID;

            $PERSON =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
            ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
            ->where('hrd_person.ID','=',$request->WAREHOUSE_USER_CONFIRM_CHECK_ID)->first();
            $addinfowarehouserequest->WAREHOUSE_USER_CONFIRM_CHECK_NAME = $PERSON->HR_PREFIX_NAME.''.$PERSON->HR_FNAME.' '.$PERSON->HR_LNAME;    
           
       
       
            $addinfowarehouserequest->WAREHOUSE_USER_CONFIRM_CHECK_DATE = date('Y-m-d H:i:s');

            $addinfowarehouserequest->WAREHOUSE_STATUS = $statusapp;
            
            $addinfowarehouserequest->save();



            Warehouserequestsub::where('WAREHOUSE_REQUEST_ID','=',$WAREHOUSE_ID)->delete(); 

            if($request->WAREHOUSE_REQUEST_SUB_DETAIL_ID != '' || $request->WAREHOUSE_REQUEST_SUB_DETAIL_ID != null){

                $WAREHOUSE_REQUEST_SUB_DETAIL_ID = $request->WAREHOUSE_REQUEST_SUB_DETAIL_ID;
                $WAREHOUSE_REQUEST_SUB_UNIT = $request->WAREHOUSE_REQUEST_SUB_UNIT;
                $WAREHOUSE_REQUEST_SUB_AMOUNT = $request->WAREHOUSE_REQUEST_SUB_AMOUNT;
                $WAREHOUSE_REQUEST_SUB_PRICE = $request->WAREHOUSE_REQUEST_SUB_PRICE;
                $WAREHOUSE_REQUEST_SUB_LOT = $request->WAREHOUSE_REQUEST_SUB_LOT;
                
               
                $WAREHOUSE_REQUEST_SUB_GEN_DATE = $request->WAREHOUSE_REQUEST_SUB_GEN_DATE;
                $WAREHOUSE_REQUEST_SUB_EXP_DATE = $request->WAREHOUSE_REQUEST_SUB_EXP_DATE;
                $WAREHOUSE_REQUEST_SUB_AMOUNT_PAY = $request->WAREHOUSE_REQUEST_SUB_AMOUNT_PAY;
                $RECEIVE_SUB_ID = $request->RECEIVE_SUB_ID;
                
                $number =count($WAREHOUSE_REQUEST_SUB_DETAIL_ID);
                $count = 0;
                for($count = 0; $count< $number; $count++)
                {
                      
                  if($WAREHOUSE_REQUEST_SUB_GEN_DATE[$count] != ''){
                     $DAY =$WAREHOUSE_REQUEST_SUB_GEN_DATE[$count];
                     $date_arrary_st=explode("-",$DAY);
                     $y_sub_st = $date_arrary_st[0];
     
                     if($y_sub_st >= 2500){
                         $y_st = $y_sub_st-543;
                     }else{
                         $y_st = $y_sub_st;
                     }
                     $m_st = $date_arrary_st[1];
                     $d_st = $date_arrary_st[2];
                     $GENDATE= $y_st."-".$m_st."-".$d_st;
                     }else{
                     $GENDATE= null;
                 }


                 if($WAREHOUSE_REQUEST_SUB_EXP_DATE[$count] != ''){
                    $DAY = $WAREHOUSE_REQUEST_SUB_EXP_DATE[$count];
                    $date_arrary_st=explode("-",$DAY);
                    $y_sub_st = $date_arrary_st[0];
    
                    if($y_sub_st >= 2500){
                        $y_st = $y_sub_st-543;
                    }else{
                        $y_st = $y_sub_st;
                    }
                    $m_st = $date_arrary_st[1];
                    $d_st = $date_arrary_st[2];
                    $EXPDATE= $y_st."-".$m_st."-".$d_st;
                    }else{
                    $EXPDATE= null;
                }

                    $add = new Warehouserequestsub();
                    $add->WAREHOUSE_REQUEST_ID = $WAREHOUSE_ID;
                 
                   $add->WAREHOUSE_REQUEST_SUB_DETAIL_ID = $WAREHOUSE_REQUEST_SUB_DETAIL_ID[$count];

                   $add->WAREHOUSE_REQUEST_SUB_UNIT = isset($WAREHOUSE_REQUEST_SUB_UNIT[$count]) ? $WAREHOUSE_REQUEST_SUB_UNIT[$count] : null;
                   $add->WAREHOUSE_REQUEST_SUB_AMOUNT = $WAREHOUSE_REQUEST_SUB_AMOUNT[$count];
                   $add->WAREHOUSE_REQUEST_SUB_PRICE = $WAREHOUSE_REQUEST_SUB_PRICE[$count];
                   $add->WAREHOUSE_REQUEST_SUB_SUM_PRICE = $WAREHOUSE_REQUEST_SUB_AMOUNT_PAY[$count] *$WAREHOUSE_REQUEST_SUB_PRICE[$count];
                   $add->WAREHOUSE_REQUEST_SUB_LOT = $WAREHOUSE_REQUEST_SUB_LOT[$count];
                   $add->WAREHOUSE_REQUEST_SUB_GEN_DATE = $GENDATE;
                   $add->WAREHOUSE_REQUEST_SUB_EXP_DATE = $EXPDATE;
                   $add->WAREHOUSE_REQUEST_SUB_AMOUNT_PAY = $WAREHOUSE_REQUEST_SUB_AMOUNT_PAY[$count];

                   $add->RECEIVE_SUB_ID = $RECEIVE_SUB_ID[$count];
                   $add->save();


                }
            }

       
            //========================================================================

            $search =  $request->search;
            $year_id =  $request->YEAR_ID;
            $status_check = $request->SEND_STATUS;
            $displaydate_bigen = $request->DATE_BIGIN;
            $displaydate_end = $request->DATE_END;
            $invenstatus_check = $request->INVEN_STATUS;

            $openform_function = Warehouse_function::where('WAREHOUSEFORM_STATUS','=','True' )->first();
            if ($openform_function != '') {       
                $code = $openform_function->WAREHOUSEFORM_CODE;  
            } else {                      
                $code = '';
            }
      

            return redirect()->route('mwarehouse.disbursesearch',[
                'YEAR_ID' => $year_id,
                'DATE_BIGIN' => $displaydate_bigen,
                'DATE_END' => $displaydate_end,
                'SEND_STATUS' => $status_check,
                'INVEN_STATUS' => $invenstatus_check,
                'codes'=>$code,
                'search' => $search ]);

        
        
   

    
    }



    //==================อนุมัติ=====


    public function warehouserequestlastapp(Request $request,$id)
    {
        
        $inforwarehouserequest = DB::table('warehouse_request')->where('WAREHOUSE_ID','=',$id)->first();

       
        return view('manager_warehouse.warehouserequestlastapp',[
            'inforwarehouserequest' => $inforwarehouserequest,  
            
        ]);
    }

public function updatewarehouserequestlastapp(Request $request)
{
  
    $id = $request->WAREHOUSE_ID;

    $check =  $request->SUBMIT;

    if($check == 'approved'){
      $statuscode = 'Allow';
    }else{
      $statuscode = 'Disallow';
    }


      $updatelastapp = Warehouserequest::find($id);
      $updatelastapp->WAREHOUSE_STATUS = $statuscode;
      $updatelastapp->WAREHOUSE_TOP_LEADER_AC_COMMENT = $request->WAREHOUSE_TOP_LEADER_AC_COMMENT;
      $updatelastapp->WAREHOUSE_TOP_LEADER_AC_ID = $request->WAREHOUSE_TOP_LEADER_AC_ID;

     
      //----------------------------------
      $TOPLEADER=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
      ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
      ->where('hrd_person.ID','=',$request->WAREHOUSE_TOP_LEADER_AC_ID)->first();

       $updatelastapp->WAREHOUSE_TOP_LEADER_AC_NAME = $TOPLEADER->HR_PREFIX_NAME.''.$TOPLEADER->HR_FNAME.' '.$TOPLEADER->HR_LNAME;
       //----------------------------------
       $updatelastapp->WAREHOUSE_TOP_LEADER_AC_DATE_TIME = date('Y-m-d H:i:s');



      $updatelastapp->save();



      if($statuscode = 'Allow'){

        $infowarehouserequest = Warehouserequest::where('WAREHOUSE_ID','=',$id)->first();
        $infowarehouserequestsub = Warehouserequestsub::where('WAREHOUSE_REQUEST_ID','=',$id)->get();


 
 
        foreach ($infowarehouserequestsub as $checkwarehouserequestsub) {
      
            $RECEIVENAME = DB::table('supplies')->where('ID','=',$checkwarehouserequestsub->WAREHOUSE_REQUEST_SUB_DETAIL_ID)->first();
            $countcheck  =  DB::table('warehouse_treasury')->where('TREASURY_CODE','=',$RECEIVENAME->SUP_FSN_NUM)->where('TREASURY_TYPE','=',$infowarehouserequest->WAREHOUSE_DEP_SUB_SUB_ID)->count();

            if($countcheck == 0 ){


                $addWarehousetreasury = new Warehousetreasury();
            
                $addWarehousetreasury->TREASURY_CODE =  $RECEIVENAME->SUP_FSN_NUM;    
                $addWarehousetreasury->TREASURY_NAME = $RECEIVENAME->SUP_NAME;
                $addWarehousetreasury->TREASURY_TYPE = $infowarehouserequest->WAREHOUSE_DEP_SUB_SUB_ID;
                $STORETYPENAME = DB::table('hrd_department_sub_sub')->where('HR_DEPARTMENT_SUB_SUB_ID','=',$infowarehouserequest->WAREHOUSE_DEP_SUB_SUB_ID)->first();
                $addWarehousetreasury->TREASURY_TYPE_NAME = $STORETYPENAME->HR_DEPARTMENT_SUB_SUB_NAME;

                $addWarehousetreasury->TREASURY_UNIT = $checkwarehouserequestsub->WAREHOUSE_REQUEST_SUB_UNIT;
                $addWarehousetreasury->TREASURY_SUP_ID = $RECEIVENAME->SUP_NAME;

                $addWarehousetreasury->save();

            }

    

            $RECEIVESUBNAME2 = DB::table('supplies')->where('ID','=',$checkwarehouserequestsub->WAREHOUSE_REQUEST_SUB_DETAIL_ID)->first();
            $checkdatacut = DB::table('warehouse_store_export_sub')
            ->where('RECEIVE_SUB_ID','=',$checkwarehouserequestsub->RECEIVE_SUB_ID)
            ->where('WAREHOUSE_REQUEST_CODE','=',$infowarehouserequest->WAREHOUSE_REQUEST_CODE)
            ->where('EXPORT_SUB_NAME','=',$RECEIVESUBNAME2->SUP_NAME)
            ->where('EXPORT_SUB_LOT','=',$checkwarehouserequestsub->WAREHOUSE_REQUEST_SUB_LOT)
            ->count();
         
         

            if($checkdatacut == 0 ){
         
            //------------------------ตัดออกจากคลังหลัก-------


            $stor_id  =  DB::table('warehouse_store')->where('STORE_CODE','=',$RECEIVENAME->SUP_FSN_NUM)->first();

            $addstore = new Warehousestoreexportsub();
       
            $addstore->RECEIVE_SUB_ID = $checkwarehouserequestsub->RECEIVE_SUB_ID;
           
            $addstore->EXPORT_SUB_NAME = $RECEIVESUBNAME2->SUP_NAME;
    
      
            $addstore->EXPORT_SUB_UNIT = $checkwarehouserequestsub->WAREHOUSE_REQUEST_SUB_UNIT;
            $addstore->EXPORT_SUB_AMOUNT = $checkwarehouserequestsub->WAREHOUSE_REQUEST_SUB_AMOUNT_PAY;
            $addstore->EXPORT_SUB_PICE_UNIT = $checkwarehouserequestsub->WAREHOUSE_REQUEST_SUB_PRICE;
            $addstore->EXPORT_SUB_VALUE =$checkwarehouserequestsub->WAREHOUSE_REQUEST_SUB_AMOUNT_PAY*$checkwarehouserequestsub->WAREHOUSE_REQUEST_SUB_PRICE;
            $addstore->EXPORT_SUB_LOT = $checkwarehouserequestsub->WAREHOUSE_REQUEST_SUB_LOT;
            $addstore->EXPORT_SUB_GEN_DATE = $checkwarehouserequestsub->WAREHOUSE_REQUEST_SUB_GEN_DATE;
            $addstore->EXPORT_SUB_EXP_DATE = $checkwarehouserequestsub->WAREHOUSE_REQUEST_SUB_EXP_DATE;

            $addstore->EXPORT_SUB_TREASURY_ID =  $infowarehouserequest->WAREHOUSE_DEP_SUB_SUB_ID;
            $addstore->EXPORT_SUB_USER_ID =  $infowarehouserequest->WAREHOUSE_SAVE_HR_ID;
            
    
            $addstore->STORE_ID = $stor_id->STORE_ID ;

            $addstore->WAREHOUSE_REQUEST_CODE = $infowarehouserequest->WAREHOUSE_REQUEST_CODE;
            $addstore->WAREHOUSE_TYPE_CYCLE = $infowarehouserequest->WAREHOUSE_TYPE_CYCLE;
            $addstore->save();


    
            

            //------------------------รับเข้าคลังย่อย-------
            $treasury_id  =  DB::table('warehouse_treasury')->where('TREASURY_CODE','=',$RECEIVENAME->SUP_FSN_NUM)->where('TREASURY_TYPE','=',$infowarehouserequest->WAREHOUSE_DEP_SUB_SUB_ID)->first();

            $addwarehousetreasury = new Warehousetreasuryreceivesub();
          
            $addwarehousetreasury->TREASURY_RECEIVE_ID = $infowarehouserequest->WAREHOUSE_ID;
    
            $RECEIVESUBNAME3 = DB::table('supplies')->where('ID','=',$checkwarehouserequestsub->WAREHOUSE_REQUEST_SUB_DETAIL_ID)->first();
            $addwarehousetreasury->TREASURY_RECEIVE_SUB_NAME = $RECEIVESUBNAME3->SUP_NAME;
    
  
            $addwarehousetreasury->TREASURY_RECEIVE_SUB_UNIT = $checkwarehouserequestsub->WAREHOUSE_REQUEST_SUB_UNIT;
            $addwarehousetreasury->TREASURY_RECEIVE_SUB_AMOUNT = $checkwarehouserequestsub->WAREHOUSE_REQUEST_SUB_AMOUNT_PAY;
            $addwarehousetreasury->TREASURY_RECEIVE_SUB_PICE_UNIT = $checkwarehouserequestsub->WAREHOUSE_REQUEST_SUB_PRICE;
            $addwarehousetreasury->TREASURY_RECEIVE_SUB_VALUE =$checkwarehouserequestsub->WAREHOUSE_REQUEST_SUB_AMOUNT_PAY*$checkwarehouserequestsub->WAREHOUSE_REQUEST_SUB_PRICE;
            $addwarehousetreasury->TREASURY_RECEIVE_SUB_LOT = $checkwarehouserequestsub->WAREHOUSE_REQUEST_SUB_LOT;
            $addwarehousetreasury->TREASURY_RECEIVE_SUB_GEN_DATE = $checkwarehouserequestsub->WAREHOUSE_REQUEST_SUB_GEN_DATE;
            $addwarehousetreasury->TREASURY_RECEIVE_SUB_EXP_DATE = $checkwarehouserequestsub->WAREHOUSE_REQUEST_SUB_EXP_DATE;
            $addwarehousetreasury->WAREHOUSE_REQUEST_SUB_ID = $checkwarehouserequestsub->WAREHOUSE_REQUEST_SUB_ID;

        
    
            $addwarehousetreasury->TREASURY_ID = $treasury_id->TREASURY_ID ;
            $addwarehousetreasury->save();


        }



      }
    }

      return redirect()->route('mwarehouse.disburse');
}

    
function detailsup(Request $request)
{
  

  $id = $request->get('id');
  $idsup = $request->get('idsup');
  $count = $request->get('count');
  $store_id = $request->get('store_id');



  if($idsup == '' || $idsup == null){

    if($store_id !== '' && $store_id !== null){
        $detailwarehousestorereceivesubs = DB::table('warehouse_store_receive_sub')
        ->leftJoin('warehouse_store','warehouse_store_receive_sub.STORE_ID','=','warehouse_store.STORE_ID')
        ->where('warehouse_store.STORE_TYPE','=',$store_id)
        ->get();

    }else{
        $detailwarehousestorereceivesubs = DB::table('warehouse_store_receive_sub')
        ->leftJoin('warehouse_store','warehouse_store_receive_sub.STORE_ID','=','warehouse_store.STORE_ID')
        ->get();

    }
  
  
  }else{
    $detailwarehousestorereceivesubs = DB::table('warehouse_store_receive_sub')
    ->leftJoin('warehouse_store','warehouse_store_receive_sub.STORE_ID','=','warehouse_store.STORE_ID')
    ->where('warehouse_store.STORE_SUP_ID','=',$idsup)->get();
  
  }



  $output ='
  <table class="table-bordered table-striped table-vcenter js-dataTable-simple" style="width: 100%;">
  <thead style="background-color: #FFEBCD;">
      <tr>
            <td style="text-align: center;" width="10%">รหัสวัสดุ</td>
          <td style="text-align: center;" width="30%">รายละเอียด</td>
          <td style="text-align: center;">ล็อต</th>
          <td style="text-align: center;">วันหมดอายุ</th>
          <td style="text-align: center;" >จำนวนคงเหลือ</td>
          <td style="text-align: center;" >จำนวนจัดสรร</td>
          <td style="text-align: center;" >คงเหลือจริง</td>
          <td style="text-align: center;" >ราคาต่อหน่วย</td>
          <td style="text-align: center;" width="5%">เลือก</td>
      </tr>
  </thead>
  <tbody id="myTable">';
  foreach ($detailwarehousestorereceivesubs as $detailwarehousestorereceivesub){
    
    $lotreceive =  DB::table('warehouse_store_receive_sub')->where('RECEIVE_SUB_ID','=',$detailwarehousestorereceivesub->RECEIVE_SUB_ID)->first();
   
    $sumlotexport = DB::table('warehouse_store_export_sub')->where('RECEIVE_SUB_ID','=',$detailwarehousestorereceivesub->RECEIVE_SUB_ID)->sum('EXPORT_SUB_AMOUNT');

  
    $amountlot = $lotreceive->RECEIVE_SUB_AMOUNT;
    $amountexport = $sumlotexport; 

    $total = $amountlot - $amountexport; 

    if($detailwarehousestorereceivesub->RECEIVE_SUB_EXP_DATE <> null && $detailwarehousestorereceivesub->RECEIVE_SUB_EXP_DATE <> '0000-00-00'){
        $expdate = DateThai($detailwarehousestorereceivesub->RECEIVE_SUB_EXP_DATE);
    }else{
        $expdate = '';
    }

     if($total != 0){


        $sumlotrequest_sub = DB::table('warehouse_request_sub')
        ->leftjoin('warehouse_request','warehouse_request.WAREHOUSE_ID','=','warehouse_request_sub.WAREHOUSE_REQUEST_ID')
        ->where('warehouse_request.WAREHOUSE_STATUS','=','Verify')
        ->where('RECEIVE_SUB_ID','=',$detailwarehousestorereceivesub->RECEIVE_SUB_ID)
        ->sum('WAREHOUSE_REQUEST_SUB_AMOUNT_PAY');

    
        $realtotal = $total-$sumlotrequest_sub;
    $output.='  <tr height="20">
    <td class="text-font text-pedding" >'.$detailwarehousestorereceivesub->STORE_CODE.'</td>
    <td class="text-font text-pedding" >'.$detailwarehousestorereceivesub->RECEIVE_SUB_NAME.'</td>
    <td class="text-font" align="center" >'.$detailwarehousestorereceivesub->RECEIVE_SUB_LOT.'</td>   
    <td class="text-font" align="center" >'.$expdate.'</td>
    <td class="text-font" align="center" >'.$total.'</td>
    <td class="text-font" align="center" >'.$sumlotrequest_sub.'</td>
    <td class="text-font" align="center" >'.$realtotal.'</td>
    <td class="text-font" align="center" >'.$detailwarehousestorereceivesub->RECEIVE_SUB_PICE_UNIT.'</td>
    <td class="text-font" align="center" ><button type="button" class="btn btn-hero-sm btn-hero-info"  style="font-family: \'Kanit\', sans-serif; font-size: 10px;font-weight:normal;"  onclick="selectsup('.$detailwarehousestorereceivesub->RECEIVE_SUB_ID.','.$count.')">เลือก</button></td> 
  </tr>';

}

   }
$output.='</tbody>
</table>';


 echo $output;


}

//========================รายงานมูลค่า=======
  
public function reportvalue()
{

    $infosuptype = DB::table('supplies_type')->where('SUP_TYPE_MASTER_ID','=',1)->get();
   
    $m_budget = date("m");
    if($m_budget>9){
    $yearbudget = date("Y")+544;
    }else{
    $yearbudget = date("Y")+543;
    }

    $year = date("Y");
    $month = date("m");

    $displaydate_bigen = $year.'-'.$month.'-01';
    $displaydate_end = $year.'-'.$month.'-31';
    $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
    $year_id = $year+543;

    return view('manager_warehouse.warehousreportvalue',[
         'infosuptypes' =>$infosuptype,
         'displaydate_bigen'=> $displaydate_bigen,
         'displaydate_end'=> $displaydate_end,
         'budgets' =>  $budget,
         'year_id'=>$year_id,
    ]);
}





public function reportvaluesearch(Request $request)
{

    $infosuptype = DB::table('supplies_type')->where('SUP_TYPE_MASTER_ID','=',1)->get();
   
    $yearbudget = $request->YEAR_ID;
    $datebigin = $request->get('DATE_BIGIN');
    $dateend = $request->get('DATE_END');

 
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

    $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
    $year_id = $yearbudget;

    return view('manager_warehouse.warehousreportvalue',[
         'infosuptypes' =>$infosuptype,
         'displaydate_bigen'=> $displaydate_bigen,
         'displaydate_end'=> $displaydate_end,
         'budgets' =>  $budget,
         'year_id'=>$year_id,
    ]);
}



public function reportvalueexcel(Request $request,$yearbudget,$displaydate_bigen,$displaydate_end)
{

    $infosuptype = DB::table('supplies_type')->where('SUP_TYPE_MASTER_ID','=',1)->get();
   

    $year_id = $yearbudget;

    return view('manager_warehouse.warehousreportvalue_excel',[
         'infosuptypes' =>$infosuptype,
         'displaydate_bigen'=> $displaydate_bigen,
         'displaydate_end'=> $displaydate_end,
         'year_id'=>$year_id,
    ]);
}


public static function valueforwardstore($SUPTYPE,$date_b,$date_e)
{

     $sumvaluereceive  =  DB::table('warehouse_store_receive_sub')
     ->select('RECEIVE_SUB_VALUE')
     ->leftJoin('warehouse_store','warehouse_store_receive_sub.STORE_ID','=','warehouse_store.STORE_ID')
     ->leftJoin('supplies','warehouse_store.STORE_SUP_ID','=','supplies.ID')
     ->leftJoin('warehouse_check_receive','warehouse_store_receive_sub.RECEIVE_ID','=','warehouse_check_receive.RECEIVE_ID')
     ->where('supplies.SUP_TYPE_ID','=',$SUPTYPE)
     ->where('warehouse_check_receive.RECEIVE_CHECK_DATE','<',$date_b)
     ->sum('RECEIVE_SUB_VALUE');

   

     $sumvalueexport  =  DB::table('warehouse_store_export_sub')
     ->select('warehouse_store_export_sub.EXPORT_SUB_VALUE')
     ->leftJoin('warehouse_store_receive_sub','warehouse_store_receive_sub.RECEIVE_SUB_ID','=','warehouse_store_export_sub.RECEIVE_SUB_ID')
     ->leftJoin('warehouse_store','warehouse_store_receive_sub.STORE_ID','=','warehouse_store.STORE_ID')
     ->leftJoin('supplies','warehouse_store.STORE_SUP_ID','=','supplies.ID')
     ->leftJoin('warehouse_request','warehouse_request.WAREHOUSE_REQUEST_CODE','=','warehouse_store_export_sub.WAREHOUSE_REQUEST_CODE')
     ->where('supplies.SUP_TYPE_ID','=',$SUPTYPE)
    ->where('warehouse_request.WAREHOUSE_PAYDAY','<',$date_b)
     ->sum('warehouse_store_export_sub.EXPORT_SUB_VALUE');
   
     $sumvalue =  $sumvaluereceive -   $sumvalueexport ;
   
   
     return $sumvalue ;
}



public static function valueforwardtreasury($SUPTYPE,$date_b,$date_e)
{

     $sumvaluereceive  =  DB::table('warehouse_treasury_receive_sub')
     ->select('TREASURY_RECEIVE_SUB_VALUE')
     ->leftJoin('warehouse_treasury','warehouse_treasury_receive_sub.TREASURY_ID','=','warehouse_treasury.TREASURY_ID')
     ->leftJoin('supplies','warehouse_treasury.TREASURY_CODE','=','supplies.SUP_FSN_NUM')
     ->where('supplies.SUP_TYPE_ID','=',$SUPTYPE)
     ->where('warehouse_treasury_receive_sub.created_at','<',$date_b)
     ->sum('TREASURY_RECEIVE_SUB_VALUE');

   
     $sumvalueexport  =  DB::table('warehouse_treasury_export_sub')
     ->select('warehouse_treasury_export_sub.TREASURY_EXPORT_SUB_VALUE')
     ->leftJoin('warehouse_treasury_receive_sub','warehouse_treasury_receive_sub.TREASURY_RECEIVE_SUB_ID','=','warehouse_treasury_export_sub.TREASURY_RECEIVE_SUB_ID')
     ->leftJoin('warehouse_treasury','warehouse_treasury_receive_sub.TREASURY_ID','=','warehouse_treasury.TREASURY_ID')
     ->leftJoin('supplies','warehouse_treasury.TREASURY_CODE','=','supplies.SUP_FSN_NUM')
     ->leftJoin('warehouse_treasury_pay','warehouse_treasury_export_sub.TREASURT_PAY_ID','=','warehouse_treasury_pay.TREASURT_PAY_ID')  
     ->where('supplies.SUP_TYPE_ID','=',$SUPTYPE)
    ->where('warehouse_treasury_pay.TREASURT_PAY_DATE','<',$date_b)
     ->sum('warehouse_treasury_export_sub.TREASURY_EXPORT_SUB_VALUE');
   
     $sumvalue =  $sumvaluereceive -   $sumvalueexport ;

   
   
     return $sumvalue ;
}

public static function valueforwardstoreinmonth($SUPTYPE,$date_b,$date_e)
{

     $sumvaluereceive  =  DB::table('warehouse_store_receive_sub')
     ->select('RECEIVE_SUB_VALUE')
     ->leftJoin('warehouse_store','warehouse_store_receive_sub.STORE_ID','=','warehouse_store.STORE_ID')
     ->leftJoin('supplies','warehouse_store.STORE_SUP_ID','=','supplies.ID')
     ->leftJoin('warehouse_check_receive','warehouse_store_receive_sub.RECEIVE_ID','=','warehouse_check_receive.RECEIVE_ID')
     ->where('supplies.SUP_TYPE_ID','=',$SUPTYPE)
     ->where('warehouse_check_receive.RECEIVE_CHECK_DATE','>=',$date_b)
     ->where('warehouse_check_receive.RECEIVE_CHECK_DATE','<=',$date_e)
     ->sum('RECEIVE_SUB_VALUE');


   
     return $sumvaluereceive ;
}



public static function valueforwardtreasuryinmonth($SUPTYPE,$date_b,$date_e)
{

     $sumvaluereceive  =  DB::table('warehouse_treasury_receive_sub')
     ->select('TREASURY_RECEIVE_SUB_VALUE')
     ->leftJoin('warehouse_treasury','warehouse_treasury_receive_sub.TREASURY_ID','=','warehouse_treasury.TREASURY_ID')
     ->leftJoin('supplies','warehouse_treasury.TREASURY_CODE','=','supplies.SUP_FSN_NUM')
     ->where('supplies.SUP_TYPE_ID','=',$SUPTYPE)
     ->where('warehouse_treasury_receive_sub.created_at','>=',$date_b)
     ->where('warehouse_treasury_receive_sub.created_at','<=',$date_e)
     ->sum('TREASURY_RECEIVE_SUB_VALUE');
   
   
     return $sumvaluereceive ;
}


public static function valueforuserstore($SUPTYPE,$date_b,$date_e)
{

    $sumvalueexport  =  DB::table('warehouse_store_export_sub')
    ->select('warehouse_store_export_sub.EXPORT_SUB_VALUE') 
    ->leftJoin('warehouse_store_receive_sub','warehouse_store_receive_sub.RECEIVE_SUB_ID','=','warehouse_store_export_sub.RECEIVE_SUB_ID')
     ->leftJoin('warehouse_store','warehouse_store_receive_sub.STORE_ID','=','warehouse_store.STORE_ID')
     ->leftJoin('supplies','warehouse_store.STORE_CODE','=','supplies.SUP_FSN_NUM')
     ->leftJoin('warehouse_request','warehouse_request.WAREHOUSE_REQUEST_CODE','=','warehouse_store_export_sub.WAREHOUSE_REQUEST_CODE')
     ->where('supplies.SUP_TYPE_ID','=',$SUPTYPE)
    ->where('warehouse_request.WAREHOUSE_PAYDAY','>=',$date_b)
    ->where('warehouse_request.WAREHOUSE_PAYDAY','<=',$date_e)
     ->sum('warehouse_store_export_sub.EXPORT_SUB_VALUE');

     return $sumvalueexport ;

}

public static function valueforuser($SUPTYPE,$date_b,$date_e)
{

    $sumvalueexport  =  DB::table('warehouse_treasury_export_sub')
    ->select('warehouse_treasury_export_sub.TREASURY_EXPORT_SUB_VALUE') 
    ->leftJoin('warehouse_treasury_receive_sub','warehouse_treasury_receive_sub.TREASURY_RECEIVE_SUB_ID','=','warehouse_treasury_export_sub.TREASURY_RECEIVE_SUB_ID')
     ->leftJoin('warehouse_treasury','warehouse_treasury_receive_sub.TREASURY_ID','=','warehouse_treasury.TREASURY_ID')
     ->leftJoin('supplies','warehouse_treasury.TREASURY_CODE','=','supplies.SUP_FSN_NUM')
     ->leftJoin('warehouse_treasury_pay','warehouse_treasury_export_sub.TREASURT_PAY_ID','=','warehouse_treasury_pay.TREASURT_PAY_ID')  
     ->where('supplies.SUP_TYPE_ID','=',$SUPTYPE)
    ->where('warehouse_treasury_pay.TREASURT_PAY_DATE','>=',$date_b)
    ->where('warehouse_treasury_pay.TREASURT_PAY_DATE','<=',$date_e)
     ->sum('warehouse_treasury_export_sub.TREASURY_EXPORT_SUB_VALUE');

     return $sumvalueexport ;

}
//====รวม





public static function sumvalueforwardstore($date_b,$date_e)
{

     $sumvaluereceive  =  DB::table('warehouse_store_receive_sub')
     ->select('RECEIVE_SUB_VALUE')
     ->leftJoin('warehouse_store','warehouse_store_receive_sub.STORE_ID','=','warehouse_store.STORE_ID')
     ->leftJoin('supplies','warehouse_store.STORE_SUP_ID','=','supplies.ID')
     ->leftJoin('warehouse_check_receive','warehouse_store_receive_sub.RECEIVE_ID','=','warehouse_check_receive.RECEIVE_ID')
     ->where('warehouse_check_receive.RECEIVE_CHECK_DATE','<',$date_b)
     ->sum('RECEIVE_SUB_VALUE');

   

     $sumvalueexport  =  DB::table('warehouse_store_export_sub')
     ->select('warehouse_store_export_sub.EXPORT_SUB_VALUE')
     ->leftJoin('warehouse_store_receive_sub','warehouse_store_receive_sub.RECEIVE_SUB_ID','=','warehouse_store_export_sub.RECEIVE_SUB_ID')
     ->leftJoin('warehouse_store','warehouse_store_receive_sub.STORE_ID','=','warehouse_store.STORE_ID')
     ->leftJoin('supplies','warehouse_store.STORE_SUP_ID','=','supplies.ID')
     ->leftJoin('warehouse_request','warehouse_request.WAREHOUSE_REQUEST_CODE','=','warehouse_store_export_sub.WAREHOUSE_REQUEST_CODE')
    ->where('warehouse_request.WAREHOUSE_PAYDAY','<',$date_b)
     ->sum('warehouse_store_export_sub.EXPORT_SUB_VALUE');
   
     $sumvalue =  $sumvaluereceive -   $sumvalueexport ;
   
   
     return $sumvalue ;
}





public static function sumvalueforwardtreasury($date_b,$date_e)
{

     $sumvaluereceive  =  DB::table('warehouse_treasury_receive_sub')
     ->select('TREASURY_RECEIVE_SUB_VALUE')
     ->leftJoin('warehouse_treasury','warehouse_treasury_receive_sub.TREASURY_ID','=','warehouse_treasury.TREASURY_ID')
     ->leftJoin('supplies','warehouse_treasury.TREASURY_CODE','=','supplies.SUP_FSN_NUM')
     ->where('warehouse_treasury_receive_sub.created_at','<',$date_b)
     ->sum('TREASURY_RECEIVE_SUB_VALUE');

   
     $sumvalueexport  =  DB::table('warehouse_treasury_export_sub')
     ->select('warehouse_treasury_export_sub.TREASURY_EXPORT_SUB_VALUE')
     ->leftJoin('warehouse_treasury_receive_sub','warehouse_treasury_receive_sub.TREASURY_RECEIVE_SUB_ID','=','warehouse_treasury_export_sub.TREASURY_RECEIVE_SUB_ID')
     ->leftJoin('warehouse_treasury','warehouse_treasury_receive_sub.TREASURY_ID','=','warehouse_treasury.TREASURY_ID')
     ->leftJoin('supplies','warehouse_treasury.TREASURY_CODE','=','supplies.SUP_FSN_NUM')
     ->leftJoin('warehouse_treasury_pay','warehouse_treasury_export_sub.TREASURT_PAY_ID','=','warehouse_treasury_pay.TREASURT_PAY_ID')  
    ->where('warehouse_treasury_pay.TREASURT_PAY_DATE','<',$date_b)
     ->sum('warehouse_treasury_export_sub.TREASURY_EXPORT_SUB_VALUE');
   
     $sumvalue =  $sumvaluereceive -   $sumvalueexport ;

   
     return $sumvalue;
}

public static function sumvalueforwardstoreinmonth($date_b,$date_e)
{

     $sumvaluereceive  =  DB::table('warehouse_store_receive_sub')
     ->select('RECEIVE_SUB_VALUE')
     ->leftJoin('warehouse_store','warehouse_store_receive_sub.STORE_ID','=','warehouse_store.STORE_ID')
     ->leftJoin('supplies','warehouse_store.STORE_SUP_ID','=','supplies.ID')
     ->leftJoin('warehouse_check_receive','warehouse_store_receive_sub.RECEIVE_ID','=','warehouse_check_receive.RECEIVE_ID')
     ->where('warehouse_check_receive.RECEIVE_CHECK_DATE','>=',$date_b)
     ->where('warehouse_check_receive.RECEIVE_CHECK_DATE','<=',$date_e)
     ->sum('RECEIVE_SUB_VALUE');


   
     return $sumvaluereceive ;
}



public static function sumvalueforwardtreasuryinmonth($date_b,$date_e)
{

     $sumvaluereceive  =  DB::table('warehouse_treasury_receive_sub')
     ->select('TREASURY_RECEIVE_SUB_VALUE')
     ->leftJoin('warehouse_treasury','warehouse_treasury_receive_sub.TREASURY_ID','=','warehouse_treasury.TREASURY_ID')
     ->leftJoin('supplies','warehouse_treasury.TREASURY_CODE','=','supplies.SUP_FSN_NUM')
     ->where('warehouse_treasury_receive_sub.created_at','>=',$date_b)
     ->where('warehouse_treasury_receive_sub.created_at','<=',$date_e)
     ->sum('TREASURY_RECEIVE_SUB_VALUE');
   
   
     return $sumvaluereceive ;
}


public static function sumvalueforuserstore($date_b,$date_e)
{

    $sumvalueexport  =  DB::table('warehouse_store_export_sub')
    ->select('warehouse_store_export_sub.EXPORT_SUB_VALUE')
     ->leftJoin('warehouse_store_receive_sub','warehouse_store_receive_sub.RECEIVE_SUB_ID','=','warehouse_store_export_sub.RECEIVE_SUB_ID')
     ->leftJoin('warehouse_store','warehouse_store_receive_sub.STORE_ID','=','warehouse_store.STORE_ID')
     ->leftJoin('supplies','warehouse_store.STORE_CODE','=','supplies.SUP_FSN_NUM')
     ->leftJoin('warehouse_request','warehouse_request.WAREHOUSE_REQUEST_CODE','=','warehouse_store_export_sub.WAREHOUSE_REQUEST_CODE')
    ->where('warehouse_request.WAREHOUSE_PAYDAY','>=',$date_b)
    ->where('warehouse_request.WAREHOUSE_PAYDAY','<=',$date_e)
     ->sum('warehouse_store_export_sub.EXPORT_SUB_VALUE');

     return $sumvalueexport ;

}

public static function sumvalueforuser($date_b,$date_e)
{

    $sumvalueexport  =  DB::table('warehouse_treasury_export_sub')
    ->select('warehouse_treasury_export_sub.TREASURY_EXPORT_SUB_VALUE')
     ->leftJoin('warehouse_treasury_receive_sub','warehouse_treasury_receive_sub.TREASURY_RECEIVE_SUB_ID','=','warehouse_treasury_export_sub.TREASURY_RECEIVE_SUB_ID')
     ->leftJoin('warehouse_treasury','warehouse_treasury_receive_sub.TREASURY_ID','=','warehouse_treasury.TREASURY_ID')
     ->leftJoin('supplies','warehouse_treasury.TREASURY_CODE','=','supplies.SUP_FSN_NUM')
     ->leftJoin('warehouse_treasury_pay','warehouse_treasury_export_sub.TREASURT_PAY_ID','=','warehouse_treasury_pay.TREASURT_PAY_ID')  
    ->where('warehouse_treasury_pay.TREASURT_PAY_DATE','>=',$date_b)
    ->where('warehouse_treasury_pay.TREASURT_PAY_DATE','<=',$date_e)
     ->sum('warehouse_treasury_export_sub.TREASURY_EXPORT_SUB_VALUE');

     return $sumvalueexport ;

}



//========================รายงานมูลค่าคลังหลัก=======
  
public function reportvaluestore()
{
    $year_id    = getBudgetyear();
    $year_ad    = $year_id-543;
    $type_check = '';
    $displaydate_bigen  = date('Y-m').'-01';
    $displaydate_end    =  date('Y-m').'-31';
    //ข้อมูลรายการทั้งหมด
    $infotype = DB::table('supplies_type')->get(); //ประเภทการดึงข้อมูล
    $budget     = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

    $infosuptype = DB::table('warehouse_store')
                    ->select('STORE_ID','STORE_TYPE_NAME','STORE_CODE','STORE_NAME','SUP_TYPE_NAME','SUP_UNIT_NAME')
                    ->leftJoin('supplies_unit_ref','warehouse_store.STORE_UNIT','=','supplies_unit_ref.ID')
                    ->leftJoin('supplies','supplies.ID','=','warehouse_store.STORE_SUP_ID')
                    ->leftJoin('supplies_type','supplies_type.SUP_TYPE_ID','=','supplies.SUP_TYPE_ID')
                    ->get();

    $receive_quote_before   = DB::table('warehouse_store_receive_sub')
                            ->leftJoin('warehouse_check_receive','warehouse_check_receive.RECEIVE_ID','warehouse_store_receive_sub.RECEIVE_ID')
                            ->select(DB::raw('STORE_ID, sum(RECEIVE_SUB_AMOUNT) as sum_amount , sum(RECEIVE_SUB_VALUE) as sum_value'))
                            ->where('RECEIVE_CHECK_DATE','<',$displaydate_bigen)->groupBy('STORE_ID')->get(); //จำนวน และมูลค่าก่อนเวลาเริ่มค้นหา 
    $export_quote_before    = DB::table('warehouse_store_export_sub')
                            ->leftJoin('warehouse_request','warehouse_request.WAREHOUSE_REQUEST_CODE','warehouse_store_export_sub.WAREHOUSE_REQUEST_CODE')
                            ->select(DB::raw('STORE_ID, sum(EXPORT_SUB_AMOUNT) as sum_amount , sum(EXPORT_SUB_VALUE) as sum_value'))
                            ->where('WAREHOUSE_PAYDAY','<',$displaydate_bigen)->groupBy('STORE_ID')->get(); //จำนวน และมูลค่า จ่ายออกก่อนเวลาเริ่มค้นหา
    $receive_new            = DB::table('warehouse_store_receive_sub')
                            ->leftJoin('warehouse_check_receive','warehouse_check_receive.RECEIVE_ID','warehouse_store_receive_sub.RECEIVE_ID')
                            ->select(DB::raw('STORE_ID, sum(RECEIVE_SUB_AMOUNT) as sum_amount , sum(RECEIVE_SUB_VALUE) as sum_value'))
                            ->whereBetween('RECEIVE_CHECK_DATE',[$displaydate_bigen,$displaydate_end])->groupBy('STORE_ID')->get(); //จำนวน และมูลค่าก่อนเวลาเริ่มค้นหา
    $export_new             = DB::table('warehouse_store_export_sub')
                            ->leftJoin('warehouse_request','warehouse_request.WAREHOUSE_REQUEST_CODE','warehouse_store_export_sub.WAREHOUSE_REQUEST_CODE')
                            ->select(DB::raw('STORE_ID, sum(EXPORT_SUB_AMOUNT) as sum_amount , sum(EXPORT_SUB_VALUE) as sum_value'))
                            ->whereBetween('WAREHOUSE_PAYDAY',[$displaydate_bigen,$displaydate_end])->groupBy('STORE_ID')->get(); //จำนวน และมูลค่าก่อนเวลาเริ่มค้นหา
    $receive_all            = DB::table('warehouse_store_receive_sub')
                            ->leftJoin('warehouse_check_receive','warehouse_check_receive.RECEIVE_ID','warehouse_store_receive_sub.RECEIVE_ID')
                            ->select(DB::raw('STORE_ID, sum(RECEIVE_SUB_AMOUNT) as sum_amount , sum(RECEIVE_SUB_VALUE) as sum_value'))
                            ->where('RECEIVE_CHECK_DATE','<=',date('Y-m-d'))
                            ->groupBy('STORE_ID')->get();
    $export_all            = DB::table('warehouse_store_export_sub')
                            ->leftJoin('warehouse_request','warehouse_request.WAREHOUSE_REQUEST_CODE','warehouse_store_export_sub.WAREHOUSE_REQUEST_CODE')
                            ->select(DB::raw('STORE_ID, sum(EXPORT_SUB_AMOUNT) as sum_amount , sum(EXPORT_SUB_VALUE) as sum_value'))
                            ->where('WAREHOUSE_PAYDAY','<=',date('Y-m-d'))
                            ->groupBy('STORE_ID')->get(); //จำนวน และมูลค่าก่อนเวลาเริ่มค้นหา
    // dd($receive_all,$export_all);

    $conclude_store = array();
    foreach($infosuptype as $info){
        $conclude_store[$info->STORE_ID]['STORE_ID'] = $info->STORE_ID;
        $conclude_store[$info->STORE_ID]['STORE_TYPE_NAME'] = $info->STORE_TYPE_NAME;
        $conclude_store[$info->STORE_ID]['STORE_CODE'] = $info->STORE_CODE;
        $conclude_store[$info->STORE_ID]['STORE_NAME'] = $info->STORE_NAME;
        $conclude_store[$info->STORE_ID]['SUP_TYPE_NAME'] = $info->SUP_TYPE_NAME;
        $conclude_store[$info->STORE_ID]['SUP_UNIT_NAME'] = $info->SUP_UNIT_NAME;
        $conclude_store[$info->STORE_ID]['receive_before_amount'] = 0;
        $conclude_store[$info->STORE_ID]['receive_before_value'] = 0;
        $conclude_store[$info->STORE_ID]['export_before_amount'] = 0;
        $conclude_store[$info->STORE_ID]['export_before_value'] = 0;
        $conclude_store[$info->STORE_ID]['before_amount'] = 0;
        $conclude_store[$info->STORE_ID]['before_value'] = 0;
        $conclude_store[$info->STORE_ID]['receive_amount'] = 0;
        $conclude_store[$info->STORE_ID]['receive_value'] = 0;
        $conclude_store[$info->STORE_ID]['export_amount'] = 0;
        $conclude_store[$info->STORE_ID]['export_value'] = 0;
        $conclude_store[$info->STORE_ID]['all_receive_amount'] = 0;
        $conclude_store[$info->STORE_ID]['all_receive_value'] = 0;
        $conclude_store[$info->STORE_ID]['all_export_amount'] = 0;
        $conclude_store[$info->STORE_ID]['all_export_value'] = 0;
    }

    foreach($infosuptype as $info){
        foreach($receive_quote_before as $key_be => $before){
            if($info->STORE_ID === (int)$before->STORE_ID){
                $conclude_store[$info->STORE_ID]['receive_before_amount'] = $before->sum_amount;
                $conclude_store[$info->STORE_ID]['receive_before_value'] = $before->sum_value;
                unset($receive_quote_before[$key_be]);
                break;
            }
        }
    }

    foreach($infosuptype as $info){
        foreach($export_quote_before as $key_be => $before_ex){
            if($info->STORE_ID === (int)$before_ex->STORE_ID){
                $conclude_store[$info->STORE_ID]['export_before_amount'] = $before_ex->sum_amount;
                $conclude_store[$info->STORE_ID]['export_before_value'] = $before_ex->sum_value;
                unset($export_quote_before[$key_be]);
                break;
            }
        }
    }
    
    foreach($infosuptype as $info){
        foreach($receive_new as $key_be => $recive){
            if($info->STORE_ID === (int)$recive->STORE_ID){
                $conclude_store[$info->STORE_ID]['receive_amount'] = $recive->sum_amount;
                $conclude_store[$info->STORE_ID]['receive_value'] = $recive->sum_value;
                unset($receive_new[$key_be]);
                break;
            }
        }
    }
    
    foreach($infosuptype as $info){
        foreach($export_new as $key_be => $export){
            if($info->STORE_ID === (int)$export->STORE_ID){
                $conclude_store[$info->STORE_ID]['export_amount'] = $export->sum_amount;
                $conclude_store[$info->STORE_ID]['export_value'] = $export->sum_value;
                unset($export_new[$key_be]);
                break;
            }
        }
    }

    foreach($infosuptype as $info){
        foreach($receive_all as $key_be => $recive_a){
            if($info->STORE_ID === (int)$recive_a->STORE_ID){
                $conclude_store[$info->STORE_ID]['all_receive_amount'] = $recive_a->sum_amount;
                $conclude_store[$info->STORE_ID]['all_receive_value'] = $recive_a->sum_value;
                unset($receive_all[$key_be]);
                break;
            }
        }
    }

    foreach($infosuptype as $info){
        foreach($export_all as $key_be => $export_a){
            if($info->STORE_ID === (int)$export_a->STORE_ID){
                $conclude_store[$info->STORE_ID]['all_export_amount'] = $export_a->sum_amount;
                $conclude_store[$info->STORE_ID]['all_export_value'] = $export_a->sum_value;
                unset($export_all[$key_be]);
                break;
            }
        }
    }

    return view('manager_warehouse.warehousreportvaluestore',[
         'displaydate_bigen'=> $displaydate_bigen,
         'displaydate_end'=> $displaydate_end,
         'budgets' =>  $budget,
         'year_id'=>$year_id,
         'infotypes'=>$infotype,
         'type_check'=>$type_check,
         'conclude_store' =>$conclude_store
    ]);
}



public function reportvaluestoresearch(Request $request)
{
    if($request->method() === "POST"){
        $year_id    = $request->YEAR_ID;
        $datebigin  = $request->get('DATE_BIGIN');
        $dateend    = $request->get('DATE_END');
        $type_check = $request->get('TYPE_CODE');
        session([
            'manager_warehouse.reportvaluestore.year_id' => $year_id,
            'manager_warehouse.reportvaluestore.datebigin' => $datebigin,
            'manager_warehouse.reportvaluestore.dateend' => $dateend,
            'manager_warehouse.reportvaluestore.type_check' => $type_check,
        ]);
    }else if(session::has('manager_warehouse.reportvaluestore')){
        $year_id    = session('manager_warehouse.reportvaluestore.year_id');
        $datebigin  = session('manager_warehouse.reportvaluestore.datebigin');
        $dateend    = session('manager_warehouse.reportvaluestore.dateend');
        $type_check = session('manager_warehouse.reportvaluestore.type_check');
    }else{
        $year_id    = getBudgetyear();
        $datebigin  = $request->get('DATE_BIGIN');
        $dateend    = $request->get('DATE_END');
        $type_check = '';
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
    
    //ข้อมูลรายการทั้งหมด
    $infotype = DB::table('supplies_type')->get(); //ประเภทการดึงข้อมูล
    $budget     = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

    $infosuptype = DB::table('warehouse_store')
                    ->select('STORE_ID','STORE_TYPE_NAME','STORE_CODE','STORE_NAME','SUP_TYPE_NAME','SUP_UNIT_NAME')
                    ->leftJoin('supplies_unit_ref','warehouse_store.STORE_UNIT','=','supplies_unit_ref.ID')
                    ->leftJoin('supplies','supplies.ID','=','warehouse_store.STORE_SUP_ID')
                    ->leftJoin('supplies_type','supplies_type.SUP_TYPE_ID','=','supplies.SUP_TYPE_ID')
                    ->get();

    $receive_quote_before   = DB::table('warehouse_store_receive_sub')
                            ->leftJoin('warehouse_check_receive','warehouse_check_receive.RECEIVE_ID','warehouse_store_receive_sub.RECEIVE_ID')
                            ->select(DB::raw('STORE_ID, sum(RECEIVE_SUB_AMOUNT) as sum_amount , sum(RECEIVE_SUB_VALUE) as sum_value'))
                            ->where('RECEIVE_CHECK_DATE','<',$displaydate_bigen)->groupBy('STORE_ID')->get(); //จำนวน และมูลค่าก่อนเวลาเริ่มค้นหา 

    $export_quote_before    = DB::table('warehouse_store_export_sub')
                            ->leftJoin('warehouse_request','warehouse_request.WAREHOUSE_REQUEST_CODE','warehouse_store_export_sub.WAREHOUSE_REQUEST_CODE')
                            ->select(DB::raw('STORE_ID, sum(EXPORT_SUB_AMOUNT) as sum_amount , sum(EXPORT_SUB_VALUE) as sum_value'))
                            ->where('WAREHOUSE_PAYDAY','<',$displaydate_bigen)->groupBy('STORE_ID')->get(); //จำนวน และมูลค่า จ่ายออกก่อนเวลาเริ่มค้นหา

    $receive_new            = DB::table('warehouse_store_receive_sub')
                            ->leftJoin('warehouse_check_receive','warehouse_check_receive.RECEIVE_ID','warehouse_store_receive_sub.RECEIVE_ID')
                            ->select(DB::raw('STORE_ID, sum(RECEIVE_SUB_AMOUNT) as sum_amount , sum(RECEIVE_SUB_VALUE) as sum_value'))
                            ->whereBetween('RECEIVE_CHECK_DATE',[$displaydate_bigen,$displaydate_end])->groupBy('STORE_ID')->get(); //จำนวน และมูลค่าก่อนเวลาเริ่มค้นหา

    $export_new             = DB::table('warehouse_store_export_sub')
                            ->leftJoin('warehouse_request','warehouse_request.WAREHOUSE_REQUEST_CODE','warehouse_store_export_sub.WAREHOUSE_REQUEST_CODE')
                            ->select(DB::raw('STORE_ID, sum(EXPORT_SUB_AMOUNT) as sum_amount , sum(EXPORT_SUB_VALUE) as sum_value'))
                            ->whereBetween('WAREHOUSE_PAYDAY',[$displaydate_bigen,$displaydate_end])->groupBy('STORE_ID')->get(); //จำนวน และมูลค่าก่อนเวลาเริ่มค้นหา

                            
    $receive_all            = DB::table('warehouse_store_receive_sub')
                            ->leftJoin('warehouse_check_receive','warehouse_check_receive.RECEIVE_ID','warehouse_store_receive_sub.RECEIVE_ID')
                            ->select(DB::raw('STORE_ID, sum(RECEIVE_SUB_AMOUNT) as sum_amount , sum(RECEIVE_SUB_VALUE) as sum_value'))
                            ->where('RECEIVE_CHECK_DATE','<=',date('Y-m-d'))
                            ->groupBy('STORE_ID')->get();

    $export_all            = DB::table('warehouse_store_export_sub')
                            ->leftJoin('warehouse_request','warehouse_request.WAREHOUSE_REQUEST_CODE','warehouse_store_export_sub.WAREHOUSE_REQUEST_CODE')
                            ->select(DB::raw('STORE_ID, sum(EXPORT_SUB_AMOUNT) as sum_amount , sum(EXPORT_SUB_VALUE) as sum_value'))
                            ->where('WAREHOUSE_PAYDAY','<=',date('Y-m-d'))
                            ->groupBy('STORE_ID')->get(); //จำนวน และมูลค่าก่อนเวลาเริ่มค้นหา
 

    $conclude_store = array();
    foreach($infosuptype as $info){
        $conclude_store[$info->STORE_ID]['STORE_ID'] = $info->STORE_ID;
        $conclude_store[$info->STORE_ID]['STORE_TYPE_NAME'] = $info->STORE_TYPE_NAME;
        $conclude_store[$info->STORE_ID]['STORE_CODE'] = $info->STORE_CODE;
        $conclude_store[$info->STORE_ID]['STORE_NAME'] = $info->STORE_NAME;
        $conclude_store[$info->STORE_ID]['SUP_TYPE_NAME'] = $info->SUP_TYPE_NAME;
        $conclude_store[$info->STORE_ID]['SUP_UNIT_NAME'] = $info->SUP_UNIT_NAME;
        $conclude_store[$info->STORE_ID]['receive_before_amount'] = 0;
        $conclude_store[$info->STORE_ID]['receive_before_value'] = 0;
        $conclude_store[$info->STORE_ID]['export_before_amount'] = 0;
        $conclude_store[$info->STORE_ID]['export_before_value'] = 0;
        $conclude_store[$info->STORE_ID]['before_amount'] = 0;
        $conclude_store[$info->STORE_ID]['before_value'] = 0;
        $conclude_store[$info->STORE_ID]['receive_amount'] = 0;
        $conclude_store[$info->STORE_ID]['receive_value'] = 0;
        $conclude_store[$info->STORE_ID]['export_amount'] = 0;
        $conclude_store[$info->STORE_ID]['export_value'] = 0;
        $conclude_store[$info->STORE_ID]['all_receive_amount'] = 0;
        $conclude_store[$info->STORE_ID]['all_receive_value'] = 0;
        $conclude_store[$info->STORE_ID]['all_export_amount'] = 0;
        $conclude_store[$info->STORE_ID]['all_export_value'] = 0;
    }

    foreach($infosuptype as $info){
        foreach($receive_quote_before as $key_be => $before){
            if($info->STORE_ID === (int)$before->STORE_ID){
                $conclude_store[$info->STORE_ID]['receive_before_amount'] = $before->sum_amount;
                $conclude_store[$info->STORE_ID]['receive_before_value'] = $before->sum_value;
                unset($receive_quote_before[$key_be]);
                break;
            }
        }
    }

    foreach($infosuptype as $info){
        foreach($export_quote_before as $key_be => $before_ex){
            if($info->STORE_ID === (int)$before_ex->STORE_ID){
                $conclude_store[$info->STORE_ID]['export_before_amount'] = $before_ex->sum_amount;
                $conclude_store[$info->STORE_ID]['export_before_value'] = $before_ex->sum_value;
                unset($export_quote_before[$key_be]);
                break;
            }
        }
    }
    
    foreach($infosuptype as $info){
        foreach($receive_new as $key_be => $recive){
            if($info->STORE_ID === (int)$recive->STORE_ID){
                $conclude_store[$info->STORE_ID]['receive_amount'] = $recive->sum_amount;
                $conclude_store[$info->STORE_ID]['receive_value'] = $recive->sum_value;
                unset($receive_new[$key_be]);
                break;
            }
        }
    }
    
    foreach($infosuptype as $info){
        foreach($export_new as $key_be => $export){
            if($info->STORE_ID === (int)$export->STORE_ID){
                $conclude_store[$info->STORE_ID]['export_amount'] = $export->sum_amount;
                $conclude_store[$info->STORE_ID]['export_value'] = $export->sum_value;
                unset($export_new[$key_be]);
                break;
            }
        }
    }

    foreach($infosuptype as $info){
        foreach($receive_all as $key_be => $recive_a){
            if($info->STORE_ID === (int)$recive_a->STORE_ID){
                $conclude_store[$info->STORE_ID]['all_receive_amount'] = $recive_a->sum_amount;
                $conclude_store[$info->STORE_ID]['all_receive_value'] = $recive_a->sum_value;
                unset($receive_all[$key_be]);
                break;
            }
        }
    }

    foreach($infosuptype as $info){
        foreach($export_all as $key_be => $export_a){
            if($info->STORE_ID === (int)$export_a->STORE_ID){
                $conclude_store[$info->STORE_ID]['all_export_amount'] = $export_a->sum_amount;
                $conclude_store[$info->STORE_ID]['all_export_value'] = $export_a->sum_value;
                unset($export_all[$key_be]);
                break;
            }
        }
    }

    if(!empty($type_check)){
        foreach($conclude_store as $key => $row){
            if($row['SUP_TYPE_NAME'] !== $type_check){
                unset($conclude_store[$key]); 
            }
        }
    }

    return view('manager_warehouse.warehousreportvaluestore',[
         'displaydate_bigen'=> $displaydate_bigen,
         'displaydate_end'=> $displaydate_end,
         'budgets' =>  $budget,
         'year_id'=>$year_id,
         'infotypes'=>$infotype,
         'type_check'=>$type_check,
         'conclude_store' =>$conclude_store
    ]);
}





public function reportvaluestoreexcel(Request $request,$yearbudget,$displaydate_bigen,$displaydate_end,$typecheck)
{

   
    $year_id    = $yearbudget;
    $typecheck = $typecheck;
    $displaydate_bigen  = $displaydate_bigen;
    $displaydate_end    =  $displaydate_end;
  

        if($typecheck == 'null'){
            $type_check = '';
        }else{
            $type_check = $typecheck;
        }
      
    
     
        

    $infotype = DB::table('supplies_type')->get(); //ประเภทการดึงข้อมูล
    $budget     = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

    $infosuptype = DB::table('warehouse_store')
                    ->select('STORE_ID','STORE_TYPE_NAME','STORE_CODE','STORE_NAME','SUP_TYPE_NAME','SUP_UNIT_NAME')
                    ->leftJoin('supplies_unit_ref','warehouse_store.STORE_UNIT','=','supplies_unit_ref.ID')
                    ->leftJoin('supplies','supplies.ID','=','warehouse_store.STORE_SUP_ID')
                    ->leftJoin('supplies_type','supplies_type.SUP_TYPE_ID','=','supplies.SUP_TYPE_ID')
                    ->get();

    $receive_quote_before   = DB::table('warehouse_store_receive_sub')
                            ->leftJoin('warehouse_check_receive','warehouse_check_receive.RECEIVE_ID','warehouse_store_receive_sub.RECEIVE_ID')
                            ->select(DB::raw('STORE_ID, sum(RECEIVE_SUB_AMOUNT) as sum_amount , sum(RECEIVE_SUB_VALUE) as sum_value'))
                            ->where('RECEIVE_CHECK_DATE','<',$displaydate_bigen)->groupBy('STORE_ID')->get(); //จำนวน และมูลค่าก่อนเวลาเริ่มค้นหา 
    $export_quote_before    = DB::table('warehouse_store_export_sub')
                            ->leftJoin('warehouse_request','warehouse_request.WAREHOUSE_REQUEST_CODE','warehouse_store_export_sub.WAREHOUSE_REQUEST_CODE')
                            ->select(DB::raw('STORE_ID, sum(EXPORT_SUB_AMOUNT) as sum_amount , sum(EXPORT_SUB_VALUE) as sum_value'))
                            ->where('WAREHOUSE_PAYDAY','<',$displaydate_bigen)->groupBy('STORE_ID')->get(); //จำนวน และมูลค่า จ่ายออกก่อนเวลาเริ่มค้นหา
    $receive_new            = DB::table('warehouse_store_receive_sub')
                            ->leftJoin('warehouse_check_receive','warehouse_check_receive.RECEIVE_ID','warehouse_store_receive_sub.RECEIVE_ID')
                            ->select(DB::raw('STORE_ID, sum(RECEIVE_SUB_AMOUNT) as sum_amount , sum(RECEIVE_SUB_VALUE) as sum_value'))
                            ->whereBetween('RECEIVE_CHECK_DATE',[$displaydate_bigen,$displaydate_end])->groupBy('STORE_ID')->get(); //จำนวน และมูลค่าก่อนเวลาเริ่มค้นหา
    $export_new             = DB::table('warehouse_store_export_sub')
                            ->leftJoin('warehouse_request','warehouse_request.WAREHOUSE_REQUEST_CODE','warehouse_store_export_sub.WAREHOUSE_REQUEST_CODE')
                            ->select(DB::raw('STORE_ID, sum(EXPORT_SUB_AMOUNT) as sum_amount , sum(EXPORT_SUB_VALUE) as sum_value'))
                            ->whereBetween('WAREHOUSE_PAYDAY',[$displaydate_bigen,$displaydate_end])->groupBy('STORE_ID')->get(); //จำนวน และมูลค่าก่อนเวลาเริ่มค้นหา
    $receive_all            = DB::table('warehouse_store_receive_sub')
                            ->leftJoin('warehouse_check_receive','warehouse_check_receive.RECEIVE_ID','warehouse_store_receive_sub.RECEIVE_ID')
                            ->select(DB::raw('STORE_ID, sum(RECEIVE_SUB_AMOUNT) as sum_amount , sum(RECEIVE_SUB_VALUE) as sum_value'))
                            ->where('RECEIVE_CHECK_DATE','<=',date('Y-m-d'))
                            ->groupBy('STORE_ID')->get();
    $export_all            = DB::table('warehouse_store_export_sub')
                            ->leftJoin('warehouse_request','warehouse_request.WAREHOUSE_REQUEST_CODE','warehouse_store_export_sub.WAREHOUSE_REQUEST_CODE')
                            ->select(DB::raw('STORE_ID, sum(EXPORT_SUB_AMOUNT) as sum_amount , sum(EXPORT_SUB_VALUE) as sum_value'))
                            ->where('WAREHOUSE_PAYDAY','<=',date('Y-m-d'))
                            ->groupBy('STORE_ID')->get(); //จำนวน และมูลค่าก่อนเวลาเริ่มค้นหา
    

    $conclude_store = array();
    foreach($infosuptype as $info){
        $conclude_store[$info->STORE_ID]['STORE_ID'] = $info->STORE_ID;
        $conclude_store[$info->STORE_ID]['STORE_TYPE_NAME'] = $info->STORE_TYPE_NAME;
        $conclude_store[$info->STORE_ID]['STORE_CODE'] = $info->STORE_CODE;
        $conclude_store[$info->STORE_ID]['STORE_NAME'] = $info->STORE_NAME;
        $conclude_store[$info->STORE_ID]['SUP_TYPE_NAME'] = $info->SUP_TYPE_NAME;
        $conclude_store[$info->STORE_ID]['SUP_UNIT_NAME'] = $info->SUP_UNIT_NAME;
        $conclude_store[$info->STORE_ID]['receive_before_amount'] = 0;
        $conclude_store[$info->STORE_ID]['receive_before_value'] = 0;
        $conclude_store[$info->STORE_ID]['export_before_amount'] = 0;
        $conclude_store[$info->STORE_ID]['export_before_value'] = 0;
        $conclude_store[$info->STORE_ID]['before_amount'] = 0;
        $conclude_store[$info->STORE_ID]['before_value'] = 0;
        $conclude_store[$info->STORE_ID]['receive_amount'] = 0;
        $conclude_store[$info->STORE_ID]['receive_value'] = 0;
        $conclude_store[$info->STORE_ID]['export_amount'] = 0;
        $conclude_store[$info->STORE_ID]['export_value'] = 0;
        $conclude_store[$info->STORE_ID]['all_receive_amount'] = 0;
        $conclude_store[$info->STORE_ID]['all_receive_value'] = 0;
        $conclude_store[$info->STORE_ID]['all_export_amount'] = 0;
        $conclude_store[$info->STORE_ID]['all_export_value'] = 0;
    }

    foreach($infosuptype as $info){
        foreach($receive_quote_before as $key_be => $before){
            if($info->STORE_ID === (int)$before->STORE_ID){
                $conclude_store[$info->STORE_ID]['receive_before_amount'] = $before->sum_amount;
                $conclude_store[$info->STORE_ID]['receive_before_value'] = $before->sum_value;
                unset($receive_quote_before[$key_be]);
                break;
            }
        }
    }

    foreach($infosuptype as $info){
        foreach($export_quote_before as $key_be => $before_ex){
            if($info->STORE_ID === (int)$before_ex->STORE_ID){
                $conclude_store[$info->STORE_ID]['export_before_amount'] = $before_ex->sum_amount;
                $conclude_store[$info->STORE_ID]['export_before_value'] = $before_ex->sum_value;
                unset($export_quote_before[$key_be]);
                break;
            }
        }
    }
    
    foreach($infosuptype as $info){
        foreach($receive_new as $key_be => $recive){
            if($info->STORE_ID === (int)$recive->STORE_ID){
                $conclude_store[$info->STORE_ID]['receive_amount'] = $recive->sum_amount;
                $conclude_store[$info->STORE_ID]['receive_value'] = $recive->sum_value;
                unset($receive_new[$key_be]);
                break;
            }
        }
    }
    
    foreach($infosuptype as $info){
        foreach($export_new as $key_be => $export){
            if($info->STORE_ID === (int)$export->STORE_ID){
                $conclude_store[$info->STORE_ID]['export_amount'] = $export->sum_amount;
                $conclude_store[$info->STORE_ID]['export_value'] = $export->sum_value;
                unset($export_new[$key_be]);
                break;
            }
        }
    }

    foreach($infosuptype as $info){
        foreach($receive_all as $key_be => $recive_a){
            if($info->STORE_ID === (int)$recive_a->STORE_ID){
                $conclude_store[$info->STORE_ID]['all_receive_amount'] = $recive_a->sum_amount;
                $conclude_store[$info->STORE_ID]['all_receive_value'] = $recive_a->sum_value;
                unset($receive_all[$key_be]);
                break;
            }
        }
    }

    foreach($infosuptype as $info){
        foreach($export_all as $key_be => $export_a){
            if($info->STORE_ID === (int)$export_a->STORE_ID){
                $conclude_store[$info->STORE_ID]['all_export_amount'] = $export_a->sum_amount;
                $conclude_store[$info->STORE_ID]['all_export_value'] = $export_a->sum_value;
                unset($export_all[$key_be]);
                break;
            }
        }
    }

    if(!empty($type_check)){
        foreach($conclude_store as $key => $row){
            if($row['SUP_TYPE_NAME'] !== $type_check){
                unset($conclude_store[$key]); 
            }
        }
    }

    return view('manager_warehouse.warehousreportvaluestore_excel',[
         'displaydate_bigen'=> $displaydate_bigen,
         'displaydate_end'=> $displaydate_end,
         'budgets' =>  $budget,
         'year_id'=>$year_id,
         'infotypes'=>$infotype,
         'type_check'=>$type_check,
         'conclude_store' =>$conclude_store
    ]);
}

//---จำนวนยกมา
public static function valueamountforwardstore($STORE_ID,$date_b,$date_e)
{

    $sumvaluereceive  =  DB::table('warehouse_store_receive_sub')
     ->select('RECEIVE_SUB_AMOUNT')
    ->leftJoin('warehouse_store','warehouse_store_receive_sub.STORE_ID','=','warehouse_store.STORE_ID')
     ->leftJoin('warehouse_check_receive','warehouse_store_receive_sub.RECEIVE_ID','=','warehouse_check_receive.RECEIVE_ID')
     ->where('warehouse_store_receive_sub.STORE_ID','=',$STORE_ID)
     ->where('warehouse_check_receive.RECEIVE_CHECK_DATE','<',$date_b)
     ->sum('RECEIVE_SUB_AMOUNT');

     $sumvalueexport  =  DB::table('warehouse_store_export_sub')
     ->select('warehouse_store_export_sub.EXPORT_SUB_AMOUNT')
     ->leftJoin('warehouse_store_receive_sub','warehouse_store_receive_sub.RECEIVE_SUB_ID','=','warehouse_store_export_sub.RECEIVE_SUB_ID')
     ->leftJoin('warehouse_store','warehouse_store_receive_sub.STORE_ID','=','warehouse_store.STORE_ID')
     ->leftJoin('warehouse_request','warehouse_request.WAREHOUSE_REQUEST_CODE','=','warehouse_store_export_sub.WAREHOUSE_REQUEST_CODE')
     ->where('warehouse_store_export_sub.STORE_ID','=',$STORE_ID)
     ->where('warehouse_request.WAREHOUSE_PAYDAY','<',$date_b)
     ->sum('warehouse_store_export_sub.EXPORT_SUB_AMOUNT');
   
     $value =  $sumvaluereceive -   $sumvalueexport ;
   
   
     return $value ;
}
//---มูลค่ายกมา
public static function valuesubforwardstore($STORE_ID,$date_b,$date_e)
{

    $sumvaluereceive  =  DB::table('warehouse_store_receive_sub')
    ->select('RECEIVE_SUB_VALUE') 
    ->leftJoin('warehouse_store','warehouse_store_receive_sub.STORE_ID','=','warehouse_store.STORE_ID')
     ->leftJoin('warehouse_check_receive','warehouse_store_receive_sub.RECEIVE_ID','=','warehouse_check_receive.RECEIVE_ID')
     ->where('warehouse_store_receive_sub.STORE_ID','=',$STORE_ID)
     ->where('warehouse_check_receive.RECEIVE_CHECK_DATE','<',$date_b)
     ->sum('RECEIVE_SUB_VALUE');

   
     $sumvalueexport  =  DB::table('warehouse_store_export_sub')
     ->select('warehouse_store_export_sub.EXPORT_SUB_VALUE') 
     ->leftJoin('warehouse_store_receive_sub','warehouse_store_receive_sub.RECEIVE_SUB_ID','=','warehouse_store_export_sub.RECEIVE_SUB_ID')
     ->leftJoin('warehouse_store','warehouse_store_receive_sub.STORE_ID','=','warehouse_store.STORE_ID')
     ->leftJoin('warehouse_request','warehouse_request.WAREHOUSE_REQUEST_CODE','=','warehouse_store_export_sub.WAREHOUSE_REQUEST_CODE')
     ->where('warehouse_store_export_sub.STORE_ID','=',$STORE_ID)
     ->where('warehouse_request.WAREHOUSE_PAYDAY','<',$date_b)
     ->sum('warehouse_store_export_sub.EXPORT_SUB_VALUE');
   
     $value =  $sumvaluereceive -   $sumvalueexport ;
   
   
     return $value ;
}


//---จำนวนระหว่างเดือน
public static function valueamountforwardstoreinmonth($STORE_ID,$date_b,$date_e)
{

    $sumvaluereceive  =  DB::table('warehouse_store_receive_sub')
    ->select('RECEIVE_SUB_AMOUNT') 
    ->leftJoin('warehouse_store','warehouse_store_receive_sub.STORE_ID','=','warehouse_store.STORE_ID')
     ->leftJoin('warehouse_check_receive','warehouse_store_receive_sub.RECEIVE_ID','=','warehouse_check_receive.RECEIVE_ID')
     ->where('warehouse_store_receive_sub.STORE_ID','=',$STORE_ID)
     ->where('warehouse_check_receive.RECEIVE_CHECK_DATE','>=',$date_b)
     ->where('warehouse_check_receive.RECEIVE_CHECK_DATE','<=',$date_e)
     ->sum('RECEIVE_SUB_AMOUNT');


   
   
     return $sumvaluereceive ;
}
//---มูลค่าระหว่างเดือน
public static function valuesubforwardstoreinmonth($STORE_ID,$date_b,$date_e)
{

    $sumvaluereceive  =  DB::table('warehouse_store_receive_sub')
    ->select('RECEIVE_SUB_VALUE') 
    ->leftJoin('warehouse_store','warehouse_store_receive_sub.STORE_ID','=','warehouse_store.STORE_ID')
     ->leftJoin('warehouse_check_receive','warehouse_store_receive_sub.RECEIVE_ID','=','warehouse_check_receive.RECEIVE_ID')
     ->where('warehouse_store_receive_sub.STORE_ID','=',$STORE_ID)
     ->where('warehouse_check_receive.RECEIVE_CHECK_DATE','>=',$date_b)
     ->where('warehouse_check_receive.RECEIVE_CHECK_DATE','<=',$date_e)
     ->sum('RECEIVE_SUB_VALUE');

   

   
     return $sumvaluereceive ;
}

//---จำนวนจ่ายระหว่างเดือน
public static function valueamountpaystoreinmonth($STORE_ID,$date_b,$date_e)
{

    $sumvalueexport  =  DB::table('warehouse_store_export_sub')
    ->select('warehouse_store_export_sub.EXPORT_SUB_AMOUNT')  
    ->leftJoin('warehouse_store_receive_sub','warehouse_store_receive_sub.RECEIVE_SUB_ID','=','warehouse_store_export_sub.RECEIVE_SUB_ID')
     ->leftJoin('warehouse_store','warehouse_store_receive_sub.STORE_ID','=','warehouse_store.STORE_ID')
     ->leftJoin('warehouse_request','warehouse_request.WAREHOUSE_REQUEST_CODE','=','warehouse_store_export_sub.WAREHOUSE_REQUEST_CODE')
     ->where('warehouse_store_export_sub.STORE_ID','=',$STORE_ID)
     ->where('warehouse_request.WAREHOUSE_PAYDAY','>=',$date_b)
     ->where('warehouse_request.WAREHOUSE_PAYDAY','<=',$date_e)
     ->sum('warehouse_store_export_sub.EXPORT_SUB_AMOUNT');


   
   
     return $sumvalueexport ;
}
//---มูลค่าจ่ายระหว่างเดือน
public static function valuesubpaystoreinmonth($STORE_ID,$date_b,$date_e)
{

    $sumvalueexport  =  DB::table('warehouse_store_export_sub')
    ->select('warehouse_store_export_sub.EXPORT_SUB_VALUE') 
    ->leftJoin('warehouse_store_receive_sub','warehouse_store_receive_sub.RECEIVE_SUB_ID','=','warehouse_store_export_sub.RECEIVE_SUB_ID')
    ->leftJoin('warehouse_store','warehouse_store_receive_sub.STORE_ID','=','warehouse_store.STORE_ID')
    ->leftJoin('warehouse_request','warehouse_request.WAREHOUSE_REQUEST_CODE','=','warehouse_store_export_sub.WAREHOUSE_REQUEST_CODE')
    ->where('warehouse_store_export_sub.STORE_ID','=',$STORE_ID)
    ->where('warehouse_request.WAREHOUSE_PAYDAY','>=',$date_b)
    ->where('warehouse_request.WAREHOUSE_PAYDAY','<=',$date_e)
    ->sum('warehouse_store_export_sub.EXPORT_SUB_VALUE');

   

   
     return $sumvalueexport ;
}
//============รวมคลังหลัก


//---จำนวนยกมา
public static function sumvalueamountforwardstore($dat,$type_check)
{
   
  
    $date_b = substr($dat,0,-11);
    $date_e = substr($dat,11);

    if($type_check <> ''){
    $sumvaluereceive  =  DB::table('warehouse_store_receive_sub')
    ->select('RECEIVE_SUB_AMOUNT') 
    ->leftJoin('warehouse_store','warehouse_store_receive_sub.STORE_ID','=','warehouse_store.STORE_ID')
     ->leftJoin('warehouse_check_receive','warehouse_store_receive_sub.RECEIVE_ID','=','warehouse_check_receive.RECEIVE_ID')
     ->leftJoin('supplies','supplies.ID','=','warehouse_store.STORE_SUP_ID')
     ->leftJoin('supplies_type','supplies_type.SUP_TYPE_ID','=','supplies.SUP_TYPE_ID')
     ->where('supplies.SUP_TYPE_ID','=',$type_check)
     ->where('warehouse_check_receive.RECEIVE_CHECK_DATE','<',$date_b)
     ->sum('RECEIVE_SUB_AMOUNT');

     $sumvalueexport  =  DB::table('warehouse_store_export_sub')
     ->select('warehouse_store_export_sub.EXPORT_SUB_AMOUNT') 
     ->leftJoin('warehouse_store_receive_sub','warehouse_store_receive_sub.RECEIVE_SUB_ID','=','warehouse_store_export_sub.RECEIVE_SUB_ID')
     ->leftJoin('warehouse_store','warehouse_store_receive_sub.STORE_ID','=','warehouse_store.STORE_ID')  
     ->leftJoin('supplies','supplies.ID','=','warehouse_store.STORE_SUP_ID')
     ->leftJoin('supplies_type','supplies_type.SUP_TYPE_ID','=','supplies.SUP_TYPE_ID')
     ->leftJoin('warehouse_request','warehouse_request.WAREHOUSE_REQUEST_CODE','=','warehouse_store_export_sub.WAREHOUSE_REQUEST_CODE')
     ->where('supplies.SUP_TYPE_ID','=',$type_check)
     ->where('warehouse_request.WAREHOUSE_PAYDAY','<',$date_b)
     ->sum('warehouse_store_export_sub.EXPORT_SUB_AMOUNT');

    }else{
        $sumvaluereceive  =  DB::table('warehouse_store_receive_sub')
        ->select('RECEIVE_SUB_AMOUNT')
        ->leftJoin('warehouse_store','warehouse_store_receive_sub.STORE_ID','=','warehouse_store.STORE_ID')
        ->leftJoin('warehouse_check_receive','warehouse_store_receive_sub.RECEIVE_ID','=','warehouse_check_receive.RECEIVE_ID')
        ->where('warehouse_check_receive.RECEIVE_CHECK_DATE','<',$date_b)
        ->sum('RECEIVE_SUB_AMOUNT');
   
        $sumvalueexport  =  DB::table('warehouse_store_export_sub')
        ->select('warehouse_store_export_sub.EXPORT_SUB_AMOUNT')
        ->leftJoin('warehouse_store_receive_sub','warehouse_store_receive_sub.RECEIVE_SUB_ID','=','warehouse_store_export_sub.RECEIVE_SUB_ID')
        ->leftJoin('warehouse_store','warehouse_store_receive_sub.STORE_ID','=','warehouse_store.STORE_ID')  
        ->leftJoin('warehouse_request','warehouse_request.WAREHOUSE_REQUEST_CODE','=','warehouse_store_export_sub.WAREHOUSE_REQUEST_CODE')
        ->where('warehouse_request.WAREHOUSE_PAYDAY','<',$date_b)
        ->sum('warehouse_store_export_sub.EXPORT_SUB_AMOUNT');

    }
   
     $value =  $sumvaluereceive -   $sumvalueexport ;
   
   
     return $value ;
}
//---มูลค่ายกมา
public static function sumvaluesubforwardstore($dat,$type_check)
{
    $date_b = substr($dat,0,-11);
    $date_e = substr($dat,11);
    if($type_check <> ''){

        $sumvaluereceive  =  DB::table('warehouse_store_receive_sub')
        ->select('RECEIVE_SUB_VALUE')
        ->leftJoin('warehouse_store','warehouse_store_receive_sub.STORE_ID','=','warehouse_store.STORE_ID')
        ->leftJoin('warehouse_check_receive','warehouse_store_receive_sub.RECEIVE_ID','=','warehouse_check_receive.RECEIVE_ID')
        ->leftJoin('supplies','supplies.ID','=','warehouse_store.STORE_SUP_ID')
        ->leftJoin('supplies_type','supplies_type.SUP_TYPE_ID','=','supplies.SUP_TYPE_ID')
        ->where('supplies.SUP_TYPE_ID','=',$type_check)
        ->where('warehouse_check_receive.RECEIVE_CHECK_DATE','<',$date_b)
        ->sum('RECEIVE_SUB_VALUE');

    
        $sumvalueexport  =  DB::table('warehouse_store_export_sub')
        ->select('warehouse_store_export_sub.EXPORT_SUB_VALUE')
        ->leftJoin('warehouse_store_receive_sub','warehouse_store_receive_sub.RECEIVE_SUB_ID','=','warehouse_store_export_sub.RECEIVE_SUB_ID')
        ->leftJoin('warehouse_store','warehouse_store_receive_sub.STORE_ID','=','warehouse_store.STORE_ID')
        ->leftJoin('supplies','supplies.ID','=','warehouse_store.STORE_SUP_ID')
        ->leftJoin('supplies_type','supplies_type.SUP_TYPE_ID','=','supplies.SUP_TYPE_ID')
        ->leftJoin('warehouse_request','warehouse_request.WAREHOUSE_REQUEST_CODE','=','warehouse_store_export_sub.WAREHOUSE_REQUEST_CODE')
        ->where('warehouse_request.WAREHOUSE_PAYDAY','<',$date_b)
        ->where('supplies.SUP_TYPE_ID','=',$type_check)
        ->sum('warehouse_store_export_sub.EXPORT_SUB_VALUE');
    }else{

        $sumvaluereceive  =  DB::table('warehouse_store_receive_sub')
        ->select('RECEIVE_SUB_VALUE')
        ->leftJoin('warehouse_store','warehouse_store_receive_sub.STORE_ID','=','warehouse_store.STORE_ID')
        ->leftJoin('warehouse_check_receive','warehouse_store_receive_sub.RECEIVE_ID','=','warehouse_check_receive.RECEIVE_ID')
        ->where('warehouse_check_receive.RECEIVE_CHECK_DATE','<',$date_b)
        ->sum('RECEIVE_SUB_VALUE');
   
      
        $sumvalueexport  =  DB::table('warehouse_store_export_sub')
        ->select('warehouse_store_export_sub.EXPORT_SUB_VALUE')
        ->leftJoin('warehouse_store_receive_sub','warehouse_store_receive_sub.RECEIVE_SUB_ID','=','warehouse_store_export_sub.RECEIVE_SUB_ID')
        ->leftJoin('warehouse_store','warehouse_store_receive_sub.STORE_ID','=','warehouse_store.STORE_ID')
        ->leftJoin('warehouse_request','warehouse_request.WAREHOUSE_REQUEST_CODE','=','warehouse_store_export_sub.WAREHOUSE_REQUEST_CODE')
        ->where('warehouse_request.WAREHOUSE_PAYDAY','<',$date_b)
        ->sum('warehouse_store_export_sub.EXPORT_SUB_VALUE');


    }


     $value =  $sumvaluereceive -   $sumvalueexport ;
   
   
     return $value ;
}


//---จำนวนระหว่างเดือน
public static function sumvalueamountforwardstoreinmonth($dat,$type_check)
{

    $date_b = substr($dat,0,-11);
     $date_e = substr($dat,11);
    if($type_check <> ''){
    $sumvaluereceive  =  DB::table('warehouse_store_receive_sub')
    ->select('RECEIVE_SUB_AMOUNT') 
    ->leftJoin('warehouse_store','warehouse_store_receive_sub.STORE_ID','=','warehouse_store.STORE_ID')
     ->leftJoin('warehouse_check_receive','warehouse_store_receive_sub.RECEIVE_ID','=','warehouse_check_receive.RECEIVE_ID')
     ->leftJoin('supplies','supplies.ID','=','warehouse_store.STORE_SUP_ID')
     ->leftJoin('supplies_type','supplies_type.SUP_TYPE_ID','=','supplies.SUP_TYPE_ID')
     ->where('supplies.SUP_TYPE_ID','=',$type_check)
     ->where('warehouse_check_receive.RECEIVE_CHECK_DATE','>=',$date_b)
     ->where('warehouse_check_receive.RECEIVE_CHECK_DATE','<=',$date_e)
     ->sum('RECEIVE_SUB_AMOUNT');
    }else{

     $sumvaluereceive  =  DB::table('warehouse_store_receive_sub')
     ->select('RECEIVE_SUB_AMOUNT') 
     ->leftJoin('warehouse_store','warehouse_store_receive_sub.STORE_ID','=','warehouse_store.STORE_ID')
     ->leftJoin('warehouse_check_receive','warehouse_store_receive_sub.RECEIVE_ID','=','warehouse_check_receive.RECEIVE_ID')
     ->where('warehouse_check_receive.RECEIVE_CHECK_DATE','>=',$date_b)
     ->where('warehouse_check_receive.RECEIVE_CHECK_DATE','<=',$date_e)
     ->sum('RECEIVE_SUB_AMOUNT');
    }


   
   
     return $sumvaluereceive ;
}
//---มูลค่าระหว่างเดือน
public static function sumvaluesubforwardstoreinmonth($dat,$type_check)
{

     $date_b = substr($dat,0,-11);
     $date_e = substr($dat,11);
    if($type_check <> ''){
    $sumvaluereceive  =  DB::table('warehouse_store_receive_sub')
    ->select('RECEIVE_SUB_VALUE') 
    ->leftJoin('warehouse_store','warehouse_store_receive_sub.STORE_ID','=','warehouse_store.STORE_ID')
     ->leftJoin('warehouse_check_receive','warehouse_store_receive_sub.RECEIVE_ID','=','warehouse_check_receive.RECEIVE_ID')
     ->leftJoin('supplies','supplies.ID','=','warehouse_store.STORE_SUP_ID')
     ->leftJoin('supplies_type','supplies_type.SUP_TYPE_ID','=','supplies.SUP_TYPE_ID')
     ->where('supplies.SUP_TYPE_ID','=',$type_check)
     ->where('warehouse_check_receive.RECEIVE_CHECK_DATE','>=',$date_b)
     ->where('warehouse_check_receive.RECEIVE_CHECK_DATE','<=',$date_e)
     ->sum('RECEIVE_SUB_VALUE');
    }else{
        $sumvaluereceive  =  DB::table('warehouse_store_receive_sub')
        ->select('RECEIVE_SUB_VALUE') 
        ->leftJoin('warehouse_store','warehouse_store_receive_sub.STORE_ID','=','warehouse_store.STORE_ID')
        ->leftJoin('warehouse_check_receive','warehouse_store_receive_sub.RECEIVE_ID','=','warehouse_check_receive.RECEIVE_ID')
        ->where('warehouse_check_receive.RECEIVE_CHECK_DATE','>=',$date_b)
        ->where('warehouse_check_receive.RECEIVE_CHECK_DATE','<=',$date_e)
        ->sum('RECEIVE_SUB_VALUE');

    }
   

   
     return $sumvaluereceive ;
}

//---จำนวนจ่ายระหว่างเดือน
public static function sumvalueamountpaystoreinmonth($dat,$type_check)
{


    $date_b = substr($dat,0,-11);
    $date_e = substr($dat,11);
    if($type_check <> ''){
    $sumvalueexport  =  DB::table('warehouse_store_export_sub')
     ->leftJoin('warehouse_store_receive_sub','warehouse_store_receive_sub.RECEIVE_SUB_ID','=','warehouse_store_export_sub.RECEIVE_SUB_ID')
     ->leftJoin('warehouse_store','warehouse_store_receive_sub.STORE_ID','=','warehouse_store.STORE_ID')
     ->leftJoin('supplies','supplies.ID','=','warehouse_store.STORE_SUP_ID')
     ->leftJoin('supplies_type','supplies_type.SUP_TYPE_ID','=','supplies.SUP_TYPE_ID')
     ->leftJoin('warehouse_request','warehouse_request.WAREHOUSE_REQUEST_CODE','=','warehouse_store_export_sub.WAREHOUSE_REQUEST_CODE')
     ->where('supplies.SUP_TYPE_ID','=',$type_check)
     ->where('warehouse_request.WAREHOUSE_PAYDAY','>=',$date_b)
     ->where('warehouse_request.WAREHOUSE_PAYDAY','<=',$date_e)
     ->sum('warehouse_store_export_sub.EXPORT_SUB_AMOUNT');

    }else{
     $sumvalueexport  =  DB::table('warehouse_store_export_sub')
     ->leftJoin('warehouse_store_receive_sub','warehouse_store_receive_sub.RECEIVE_SUB_ID','=','warehouse_store_export_sub.RECEIVE_SUB_ID')
     ->leftJoin('warehouse_store','warehouse_store_receive_sub.STORE_ID','=','warehouse_store.STORE_ID')
     ->leftJoin('warehouse_request','warehouse_request.WAREHOUSE_REQUEST_CODE','=','warehouse_store_export_sub.WAREHOUSE_REQUEST_CODE')
     ->where('warehouse_request.WAREHOUSE_PAYDAY','>=',$date_b)
     ->where('warehouse_request.WAREHOUSE_PAYDAY','<=',$date_e)
     ->sum('warehouse_store_export_sub.EXPORT_SUB_AMOUNT');
    }
   
   
     return $sumvalueexport ;
}
//---มูลค่าจ่ายระหว่างเดือน
public static function sumvaluesubpaystoreinmonth($dat,$type_check)
{
   


    $date_b = substr($dat,0,-11);
    $date_e = substr($dat,11);
  if($type_check <> ''){
    $sumvalueexport  =  DB::table('warehouse_store_export_sub')
    ->leftJoin('warehouse_store_receive_sub','warehouse_store_receive_sub.RECEIVE_SUB_ID','=','warehouse_store_export_sub.RECEIVE_SUB_ID')
    ->leftJoin('warehouse_store','warehouse_store_receive_sub.STORE_ID','=','warehouse_store.STORE_ID')
    ->leftJoin('supplies','supplies.ID','=','warehouse_store.STORE_SUP_ID')
    ->leftJoin('supplies_type','supplies_type.SUP_TYPE_ID','=','supplies.SUP_TYPE_ID')
    ->leftJoin('warehouse_request','warehouse_request.WAREHOUSE_REQUEST_CODE','=','warehouse_store_export_sub.WAREHOUSE_REQUEST_CODE')
    ->where('supplies.SUP_TYPE_ID','=',$type_check)
    ->where('warehouse_request.WAREHOUSE_PAYDAY','>=',$date_b)
    ->where('warehouse_request.WAREHOUSE_PAYDAY','<=',$date_e)
    ->sum('warehouse_store_export_sub.EXPORT_SUB_VALUE');
  }else{

    $sumvalueexport  =  DB::table('warehouse_store_export_sub')
    ->leftJoin('warehouse_store_receive_sub','warehouse_store_receive_sub.RECEIVE_SUB_ID','=','warehouse_store_export_sub.RECEIVE_SUB_ID')
    ->leftJoin('warehouse_store','warehouse_store_receive_sub.STORE_ID','=','warehouse_store.STORE_ID')
    ->leftJoin('warehouse_request','warehouse_request.WAREHOUSE_REQUEST_CODE','=','warehouse_store_export_sub.WAREHOUSE_REQUEST_CODE')
    ->where('warehouse_request.WAREHOUSE_PAYDAY','>=',$date_b)
    ->where('warehouse_request.WAREHOUSE_PAYDAY','<=',$date_e)
    ->sum('warehouse_store_export_sub.EXPORT_SUB_VALUE');
  }
   

   
     return $sumvalueexport ;
}


//========================รายงานมูลค่าคลังย่อย=======

 
public function reportvaluetreasury()
{

    $infosuptype = DB::table('warehouse_treasury')
    ->leftJoin('supplies_unit_ref','warehouse_treasury.TREASURY_UNIT','=','supplies_unit_ref.ID')
    ->leftJoin('supplies','supplies.SUP_FSN_NUM','=','warehouse_treasury.TREASURY_CODE')
    ->leftJoin('supplies_type','supplies_type.SUP_TYPE_ID','=','supplies.SUP_TYPE_ID')
    ->get();
   
    $m_budget = date("m");
    if($m_budget>9){
    $yearbudget = date("Y")+544;
    }else{
    $yearbudget = date("Y")+543;
    }

    $displaydate_bigen = ($yearbudget-544).'-10-01';
    $displaydate_end = ($yearbudget-543).'-09-30';
    $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
    $year_id = $yearbudget;

    $infotype = DB::table('supplies_type')->get();
    $type_check ='';

    return view('manager_warehouse.warehousreportvaluetreasury',[
         'infosuptypes' =>$infosuptype,
         'displaydate_bigen'=> $displaydate_bigen,
         'displaydate_end'=> $displaydate_end,
         'budgets' =>  $budget,
         'infotypes' =>  $infotype,
         'year_id'=>$year_id,
         'type_check'=>$type_check,
    ]);
}


  


public function reportvaluetreasurysearch(Request $request)
{

    $yearbudget = $request->YEAR_ID;
    $datebigin = $request->get('DATE_BIGIN');
    $dateend = $request->get('DATE_END');
    $TYPE_CODE = $request->get('TYPE_CODE');

 
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

    $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
    $year_id = $yearbudget;

    $infotype = DB::table('supplies_type')->get();

    $type_check = $TYPE_CODE;

    if($type_check == '' || $type_check == null){
        $infosuptype = DB::table('warehouse_treasury')
        ->leftJoin('supplies_unit_ref','warehouse_treasury.TREASURY_UNIT','=','supplies_unit_ref.ID')
        ->leftJoin('supplies','supplies.SUP_FSN_NUM','=','warehouse_treasury.TREASURY_CODE')
        ->leftJoin('supplies_type','supplies_type.SUP_TYPE_ID','=','supplies.SUP_TYPE_ID')
        ->get();

    }else{

        $infosuptype = DB::table('warehouse_treasury')
        ->leftJoin('supplies_unit_ref','warehouse_treasury.TREASURY_UNIT','=','supplies_unit_ref.ID')
        ->leftJoin('supplies','supplies.SUP_FSN_NUM','=','warehouse_treasury.TREASURY_CODE')
        ->leftJoin('supplies_type','supplies_type.SUP_TYPE_ID','=','supplies.SUP_TYPE_ID')
        ->where('supplies.SUP_TYPE_ID','=',$type_check)
        ->get();

    }

  

    return view('manager_warehouse.warehousreportvaluetreasury',[
         'infosuptypes' =>$infosuptype,
         'displaydate_bigen'=> $displaydate_bigen,
         'displaydate_end'=> $displaydate_end,
         'budgets' =>  $budget,
         'infotypes' =>  $infotype,
         'type_check' =>  $type_check,
         'year_id'=>$year_id,
    ]);
}





public function reportvaluetreasutyexcel(Request $request,$yearbudget,$displaydate_bigen,$displaydate_end)
{

    $infosuptype = DB::table('warehouse_treasury')
    ->leftJoin('supplies_unit_ref','warehouse_treasury.TREASURY_UNIT','=','supplies_unit_ref.ID')
    ->leftJoin('supplies','supplies.SUP_FSN_NUM','=','warehouse_treasury.TREASURY_CODE')
    ->leftJoin('supplies_type','supplies_type.SUP_TYPE_ID','=','supplies.SUP_TYPE_ID')
    ->get();

   

    $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
    $year_id = $yearbudget;

    return view('manager_warehouse.warehousreportvaluetreasury_excel',[
         'infosuptypes' =>$infosuptype,
         'displaydate_bigen'=> $displaydate_bigen,
         'displaydate_end'=> $displaydate_end,
         'budgets' =>  $budget,
         'year_id'=>$year_id,
    ]);
}
  


//---จำนวนยกมา
public static function valueamountforwardtreasury($TREASURY_ID,$date_b,$date_e)
{

    $sumvaluereceive  =  DB::table('warehouse_treasury_receive_sub')
    ->leftJoin('warehouse_treasury','warehouse_treasury_receive_sub.TREASURY_ID','=','warehouse_treasury.TREASURY_ID')
    ->leftJoin('supplies','warehouse_treasury.TREASURY_CODE','=','supplies.SUP_FSN_NUM')
    ->where('warehouse_treasury_receive_sub.TREASURY_ID','=',$TREASURY_ID)
    ->where('warehouse_treasury_receive_sub.created_at','<=',$date_b)
    ->sum('TREASURY_RECEIVE_SUB_AMOUNT');

  
    $sumvalueexport  =  DB::table('warehouse_treasury_export_sub')
    ->leftJoin('warehouse_treasury_receive_sub','warehouse_treasury_receive_sub.TREASURY_RECEIVE_SUB_ID','=','warehouse_treasury_export_sub.TREASURY_RECEIVE_SUB_ID')
    ->leftJoin('warehouse_treasury','warehouse_treasury_receive_sub.TREASURY_ID','=','warehouse_treasury.TREASURY_ID')
    ->leftJoin('supplies','warehouse_treasury.TREASURY_CODE','=','supplies.SUP_FSN_NUM')
    ->leftJoin('warehouse_treasury_pay','warehouse_treasury_export_sub.TREASURT_PAY_ID','=','warehouse_treasury_pay.TREASURT_PAY_ID')  
    ->where('warehouse_treasury_receive_sub.TREASURY_ID','=',$TREASURY_ID)
   ->where('warehouse_treasury_pay.TREASURT_PAY_DATE','<=',$date_b)
    ->sum('warehouse_treasury_export_sub.TREASURY_EXPORT_SUB_AMOUNT');
  
    $sumvalue =  $sumvaluereceive -   $sumvalueexport ;

  
  
    return $sumvalue ;
   
     
}
//---มูลค่ายกมา
public static function valuesubforwardtreasury($TREASURY_ID,$date_b,$date_e)
{

    $sumvaluereceive  =  DB::table('warehouse_treasury_receive_sub')

    ->where('warehouse_treasury_receive_sub.TREASURY_ID','=',$TREASURY_ID)
    ->where('warehouse_treasury_receive_sub.created_at','<=',$date_b)
    ->sum('TREASURY_RECEIVE_SUB_VALUE');

  
    $sumvalueexport  =  DB::table('warehouse_treasury_export_sub')
    ->leftJoin('warehouse_treasury_receive_sub','warehouse_treasury_receive_sub.TREASURY_RECEIVE_SUB_ID','=','warehouse_treasury_export_sub.TREASURY_RECEIVE_SUB_ID')
    ->leftJoin('warehouse_treasury_pay','warehouse_treasury_export_sub.TREASURT_PAY_ID','=','warehouse_treasury_pay.TREASURT_PAY_ID')  
    ->where('warehouse_treasury_export_sub.TREASURY_ID','=',$TREASURY_ID)
   ->where('warehouse_treasury_pay.TREASURT_PAY_DATE','<=',$date_b)
    ->sum('warehouse_treasury_export_sub.TREASURY_EXPORT_SUB_VALUE');
  
    $sumvalue =  $sumvaluereceive -   $sumvalueexport ;

  
  
    return $sumvalue ;
}


//---จำนวนระหว่างเดือน
public static function valueamountforwardtreasuryinmonth($TREASURY_ID,$date_b,$date_e)
{

    $sumvaluereceive  =  DB::table('warehouse_treasury_receive_sub')
    ->leftJoin('warehouse_treasury','warehouse_treasury_receive_sub.TREASURY_ID','=','warehouse_treasury.TREASURY_ID')
    ->leftJoin('supplies','warehouse_treasury.TREASURY_CODE','=','supplies.SUP_FSN_NUM')
    ->where('warehouse_treasury_receive_sub.TREASURY_ID','=',$TREASURY_ID)
    ->where('warehouse_treasury_receive_sub.created_at','>=',$date_b)
    ->where('warehouse_treasury_receive_sub.created_at','<=',$date_e)
    ->sum('TREASURY_RECEIVE_SUB_AMOUNT');


   
   
     return $sumvaluereceive ;
}
//---มูลค่าระหว่างเดือน
public static function valuesubforwardtreasuryinmonth($TREASURY_ID,$date_b,$date_e)
{

    $sumvaluereceive  =  DB::table('warehouse_treasury_receive_sub')
    ->leftJoin('warehouse_treasury','warehouse_treasury_receive_sub.TREASURY_ID','=','warehouse_treasury.TREASURY_ID')
    ->leftJoin('supplies','warehouse_treasury.TREASURY_CODE','=','supplies.SUP_FSN_NUM')
    ->where('warehouse_treasury_receive_sub.TREASURY_ID','=',$TREASURY_ID)
    ->where('warehouse_treasury_receive_sub.created_at','>=',$date_b)
    ->where('warehouse_treasury_receive_sub.created_at','<=',$date_e)
    ->sum('TREASURY_RECEIVE_SUB_VALUE');
   

   
     return $sumvaluereceive ;
}

//---จำนวนจ่ายระหว่างเดือน
public static function valueamountpaytreasuryinmonth($TREASURY_ID,$date_b,$date_e)
{

    $sumvalueexport  =  DB::table('warehouse_treasury_export_sub')
     ->leftJoin('warehouse_treasury_receive_sub','warehouse_treasury_receive_sub.TREASURY_RECEIVE_SUB_ID','=','warehouse_treasury_export_sub.TREASURY_RECEIVE_SUB_ID')
     ->leftJoin('warehouse_treasury','warehouse_treasury_receive_sub.TREASURY_ID','=','warehouse_treasury.TREASURY_ID')
     ->leftJoin('warehouse_treasury_pay','warehouse_treasury_export_sub.TREASURT_PAY_ID','=','warehouse_treasury_pay.TREASURT_PAY_ID') 
     ->where('warehouse_treasury_receive_sub.TREASURY_ID','=',$TREASURY_ID)
    ->where('warehouse_treasury_pay.TREASURT_PAY_DATE','>=',$date_b)
    ->where('warehouse_treasury_pay.TREASURT_PAY_DATE','<=',$date_e)
     ->sum('warehouse_treasury_export_sub.TREASURY_EXPORT_SUB_AMOUNT');


   
   
     return $sumvalueexport ;
}
//---มูลค่าจ่ายระหว่างเดือน
public static function valuesubpaytreasuryinmonth($TREASURY_ID,$date_b,$date_e)
{

    $sumvalueexport  =  DB::table('warehouse_treasury_export_sub')
    ->leftJoin('warehouse_treasury_receive_sub','warehouse_treasury_receive_sub.TREASURY_RECEIVE_SUB_ID','=','warehouse_treasury_export_sub.TREASURY_RECEIVE_SUB_ID')
    ->leftJoin('warehouse_treasury','warehouse_treasury_receive_sub.TREASURY_ID','=','warehouse_treasury.TREASURY_ID')
    ->leftJoin('warehouse_treasury_pay','warehouse_treasury_export_sub.TREASURT_PAY_ID','=','warehouse_treasury_pay.TREASURT_PAY_ID')  
    ->where('warehouse_treasury_receive_sub.TREASURY_ID','=',$TREASURY_ID)
   ->where('warehouse_treasury_pay.TREASURT_PAY_DATE','>=',$date_b)
   ->where('warehouse_treasury_pay.TREASURT_PAY_DATE','<=',$date_e)
    ->sum('warehouse_treasury_export_sub.TREASURY_EXPORT_SUB_VALUE');

   

   
     return $sumvalueexport ;
}

//===--รวมคลังย่อย


//---จำนวนยกมา
public static function sumvalueamountforwardtreasury($date_b,$date_e)
{

    $sumvaluereceive  =  DB::table('warehouse_treasury_receive_sub')
    ->leftJoin('warehouse_treasury','warehouse_treasury_receive_sub.TREASURY_ID','=','warehouse_treasury.TREASURY_ID')
    ->leftJoin('supplies','warehouse_treasury.TREASURY_CODE','=','supplies.SUP_FSN_NUM')
  
    ->where('warehouse_treasury_receive_sub.created_at','<=',$date_b)
    ->sum('TREASURY_RECEIVE_SUB_AMOUNT');

  
    $sumvalueexport  =  DB::table('warehouse_treasury_export_sub')
    ->leftJoin('warehouse_treasury_receive_sub','warehouse_treasury_receive_sub.TREASURY_RECEIVE_SUB_ID','=','warehouse_treasury_export_sub.TREASURY_RECEIVE_SUB_ID')
    ->leftJoin('warehouse_treasury','warehouse_treasury_receive_sub.TREASURY_ID','=','warehouse_treasury.TREASURY_ID')
    ->leftJoin('supplies','warehouse_treasury.TREASURY_CODE','=','supplies.SUP_FSN_NUM')
    ->leftJoin('warehouse_treasury_pay','warehouse_treasury_export_sub.TREASURT_PAY_ID','=','warehouse_treasury_pay.TREASURT_PAY_ID')  
   ->where('warehouse_treasury_pay.TREASURT_PAY_DATE','<=',$date_b)
    ->sum('warehouse_treasury_export_sub.TREASURY_EXPORT_SUB_AMOUNT');
  
    $sumvalue =  $sumvaluereceive -   $sumvalueexport ;

  
  
    return $sumvalue ;
   
     
}
//---มูลค่ายกมา
public static function sumvaluesubforwardtreasury($date_b,$date_e)
{

    $sumvaluereceive  =  DB::table('warehouse_treasury_receive_sub')

 
    ->where('warehouse_treasury_receive_sub.created_at','<=',$date_b)
    ->sum('TREASURY_RECEIVE_SUB_VALUE');

  
    $sumvalueexport  =  DB::table('warehouse_treasury_export_sub')
    ->leftJoin('warehouse_treasury_receive_sub','warehouse_treasury_receive_sub.TREASURY_RECEIVE_SUB_ID','=','warehouse_treasury_export_sub.TREASURY_RECEIVE_SUB_ID')
    ->leftJoin('warehouse_treasury_pay','warehouse_treasury_export_sub.TREASURT_PAY_ID','=','warehouse_treasury_pay.TREASURT_PAY_ID') 
   ->where('warehouse_treasury_pay.TREASURT_PAY_DATE','<=',$date_b)
    ->sum('warehouse_treasury_export_sub.TREASURY_EXPORT_SUB_VALUE');
  
    $sumvalue =  $sumvaluereceive -   $sumvalueexport ;

  
  
    return $sumvalue ;
}


//---จำนวนระหว่างเดือน
public static function sumvalueamountforwardtreasuryinmonth($date_b,$date_e)
{

    $sumvaluereceive  =  DB::table('warehouse_treasury_receive_sub')
    ->leftJoin('warehouse_treasury','warehouse_treasury_receive_sub.TREASURY_ID','=','warehouse_treasury.TREASURY_ID')
    ->leftJoin('supplies','warehouse_treasury.TREASURY_CODE','=','supplies.SUP_FSN_NUM')

    ->where('warehouse_treasury_receive_sub.created_at','>=',$date_b)
    ->where('warehouse_treasury_receive_sub.created_at','<=',$date_e)
    ->sum('TREASURY_RECEIVE_SUB_AMOUNT');


   
   
     return $sumvaluereceive ;
}
//---มูลค่าระหว่างเดือน
public static function sumvaluesubforwardtreasuryinmonth($date_b,$date_e)
{

    $sumvaluereceive  =  DB::table('warehouse_treasury_receive_sub')
    ->leftJoin('warehouse_treasury','warehouse_treasury_receive_sub.TREASURY_ID','=','warehouse_treasury.TREASURY_ID')
    ->leftJoin('supplies','warehouse_treasury.TREASURY_CODE','=','supplies.SUP_FSN_NUM')

    ->where('warehouse_treasury_receive_sub.created_at','>=',$date_b)
    ->where('warehouse_treasury_receive_sub.created_at','<=',$date_e)
    ->sum('TREASURY_RECEIVE_SUB_VALUE');
   

   
     return $sumvaluereceive ;
}

//---จำนวนจ่ายระหว่างเดือน
public static function sumvalueamountpaytreasuryinmonth($date_b,$date_e)
{

    $sumvalueexport  =  DB::table('warehouse_treasury_export_sub')
     ->leftJoin('warehouse_treasury_receive_sub','warehouse_treasury_receive_sub.TREASURY_RECEIVE_SUB_ID','=','warehouse_treasury_export_sub.TREASURY_RECEIVE_SUB_ID')
     ->leftJoin('warehouse_treasury','warehouse_treasury_receive_sub.TREASURY_ID','=','warehouse_treasury.TREASURY_ID')
     ->leftJoin('warehouse_treasury_pay','warehouse_treasury_export_sub.TREASURT_PAY_ID','=','warehouse_treasury_pay.TREASURT_PAY_ID')  
    ->where('warehouse_treasury_pay.TREASURT_PAY_DATE','>=',$date_b)
    ->where('warehouse_treasury_pay.TREASURT_PAY_DATE','<=',$date_e)
     ->sum('warehouse_treasury_export_sub.TREASURY_EXPORT_SUB_AMOUNT');


   
   
     return $sumvalueexport ;
}
//---มูลค่าจ่ายระหว่างเดือน
public static function sumvaluesubpaytreasuryinmonth($date_b,$date_e)
{

    $sumvalueexport  =  DB::table('warehouse_treasury_export_sub')
    ->leftJoin('warehouse_treasury_receive_sub','warehouse_treasury_receive_sub.TREASURY_RECEIVE_SUB_ID','=','warehouse_treasury_export_sub.TREASURY_RECEIVE_SUB_ID')
    ->leftJoin('warehouse_treasury','warehouse_treasury_receive_sub.TREASURY_ID','=','warehouse_treasury.TREASURY_ID')
    ->leftJoin('warehouse_treasury_pay','warehouse_treasury_export_sub.TREASURT_PAY_ID','=','warehouse_treasury_pay.TREASURT_PAY_ID')  
    ->where('warehouse_treasury_pay.TREASURT_PAY_DATE','>=',$date_b)
    ->where('warehouse_treasury_pay.TREASURT_PAY_DATE','<=',$date_e)
    ->sum('warehouse_treasury_export_sub.TREASURY_EXPORT_SUB_VALUE');

   

   
     return $sumvalueexport ;
}

 
//----------------------------------------------------------


        function selectsup(Request $request)
        {
          
            $idsup = $request->get('idsup');

            $inforeceive_sub = DB::table('warehouse_store_receive_sub')
            ->leftJoin('warehouse_store','warehouse_store_receive_sub.STORE_ID','=','warehouse_store.STORE_ID')  
            ->where('warehouse_store_receive_sub.RECEIVE_SUB_ID','=',$idsup)->first();

            $output = $inforeceive_sub->RECEIVE_SUB_NAME.' 
            <input  type="hidden"  name="RECEIVE_SUB_ID[]" id="RECEIVE_SUB_ID" class="form-control input-sm" value="'.$inforeceive_sub->RECEIVE_SUB_ID.'">
            <input  type="hidden"  name="WAREHOUSE_REQUEST_SUB_DETAIL_ID[]" id="WAREHOUSE_REQUEST_SUB_DETAIL_ID" class="form-control input-sm" value="'.$inforeceive_sub->STORE_SUP_ID.'">';
            echo $output;
        }


        function selectsuplot(Request $request)
        {
            
            $idsup = $request->get('idsup');

            $inforeceive_sub = DB::table('warehouse_store_receive_sub')->where('RECEIVE_SUB_ID','=',$idsup)->first();

            $output = $inforeceive_sub->RECEIVE_SUB_LOT.'<input  type="hidden" name="WAREHOUSE_REQUEST_SUB_LOT[]" id="WAREHOUSE_REQUEST_SUB_LOT" class="form-control input-sm" value="'.$inforeceive_sub->RECEIVE_SUB_LOT.'">';
            echo $output;
        }

        function selectsuptotal(Request $request)
        {
            
            $idsup = $request->get('idsup');
            $count = $request->get('count');

            $inforeceive_sub = DB::table('warehouse_store_receive_sub')->where('RECEIVE_SUB_ID','=',$idsup)->first();

            $lotreceive =  DB::table('warehouse_store_receive_sub')->where('RECEIVE_SUB_ID','=',$inforeceive_sub->RECEIVE_SUB_ID)->first();
   
            $sumlotexport = DB::table('warehouse_store_export_sub')->where('RECEIVE_SUB_ID','=',$inforeceive_sub->RECEIVE_SUB_ID)->sum('EXPORT_SUB_AMOUNT');
            $sumlotrequest_sub = DB::table('warehouse_request_sub')
            ->leftjoin('warehouse_request','warehouse_request.WAREHOUSE_ID','=','warehouse_request_sub.WAREHOUSE_REQUEST_ID')
            ->where('warehouse_request.WAREHOUSE_STATUS','=','Verify')
            ->where('RECEIVE_SUB_ID','=',$inforeceive_sub->RECEIVE_SUB_ID)
            ->sum('WAREHOUSE_REQUEST_SUB_AMOUNT_PAY');
          
            $amountlot = $lotreceive->RECEIVE_SUB_AMOUNT;
            $amountexport = $sumlotexport+ $sumlotrequest_sub; 
        
            $total = $amountlot - $amountexport; 

          
        
            $output =  $total.'<input type="hidden" name="EXPORT_SUB_VALUE[]" id="EXPORT_SUB_VALUE'.$count.'" class="form-control input-sm" value="'.$total.'">';
            echo $output;
        }


        public static function selectsuptotal_edit($idsup,$count)
        {
            
            if($idsup == '' || $idsup == null){
                $total = '';
            }else{
                $inforeceive_sub = DB::table('warehouse_store_receive_sub')->where('RECEIVE_SUB_ID','=',$idsup)->first();

                $lotreceive =  DB::table('warehouse_store_receive_sub')->where('RECEIVE_SUB_ID','=',$inforeceive_sub->RECEIVE_SUB_ID)->first();
       
                $sumlotexport = DB::table('warehouse_store_export_sub')->where('RECEIVE_SUB_ID','=',$inforeceive_sub->RECEIVE_SUB_ID)->sum('EXPORT_SUB_AMOUNT');
            
              
                $amountlot = $lotreceive->RECEIVE_SUB_AMOUNT;
                $amountexport = $sumlotexport; 
            
                $total = $amountlot - $amountexport; 
            }
       

          
        
        
            return $total;
        }



        function selectsupunit(Request $request)
        {
            
            $idsup = $request->get('idsup');

            $inforeceive_sub = DB::table('warehouse_store_receive_sub')
            ->leftJoin('supplies_unit_ref','warehouse_store_receive_sub.RECEIVE_SUB_UNIT','=','supplies_unit_ref.ID')
            ->where('RECEIVE_SUB_ID','=',$idsup)->first();

            $output = $inforeceive_sub->SUP_UNIT_NAME.'<input type="hidden" name="WAREHOUSE_REQUEST_SUB_UNIT[]" id="WAREHOUSE_REQUEST_SUB_UNIT" class="form-control input-sm" value="'.$inforeceive_sub->RECEIVE_SUB_UNIT.'">';
            echo $output;
        }

        function selectsuppiceunit(Request $request)
        {
            
            $idsup = $request->get('idsup');
            $count = $request->get('count');

            $inforeceive_sub = DB::table('warehouse_store_receive_sub')->where('RECEIVE_SUB_ID','=',$idsup)->first();

            $output = number_format($inforeceive_sub->RECEIVE_SUB_PICE_UNIT,5).'<input type="hidden" name="WAREHOUSE_REQUEST_SUB_PRICE[]" id="RECEIVE_SUB_PICE_UNIT'.$count.'" class="form-control input-sm" value="'.$inforeceive_sub->RECEIVE_SUB_PICE_UNIT.'">';
            echo $output;
        }

        function selectsupdatget(Request $request)
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
            $idsup = $request->get('idsup');

            $inforeceive_sub = DB::table('warehouse_store_receive_sub')->where('RECEIVE_SUB_ID','=',$idsup)->first();

            if($inforeceive_sub->RECEIVE_SUB_GEN_DATE == null || $inforeceive_sub->RECEIVE_SUB_GEN_DATE == ''){
                $output = '<input type="hidden" name="WAREHOUSE_REQUEST_SUB_GEN_DATE[]" id="WAREHOUSE_REQUEST_SUB_GEN_DATE" class="form-control input-sm" value="">';
            }else{
                $output = DateThai($inforeceive_sub->RECEIVE_SUB_GEN_DATE).'<input type="hidden" name="WAREHOUSE_REQUEST_SUB_GEN_DATE[]" id="WAREHOUSE_REQUEST_SUB_GEN_DATE" class="form-control input-sm" value="'.$inforeceive_sub->RECEIVE_SUB_GEN_DATE.'">';
            }
            
           
            
            
            echo $output;
        }

        function selectsupdatexp(Request $request)
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
            $idsup = $request->get('idsup');

            $inforeceive_sub = DB::table('warehouse_store_receive_sub')->where('RECEIVE_SUB_ID','=',$idsup)->first();

            if($inforeceive_sub->RECEIVE_SUB_EXP_DATE == null || $inforeceive_sub->RECEIVE_SUB_EXP_DATE == ''){
                $output = '<input type="hidden" name="WAREHOUSE_REQUEST_SUB_EXP_DATE[]" id="WAREHOUSE_REQUEST_SUB_EXP_DATE" class="form-control input-sm" value=" ">';
            }else{
                $output = DateThai($inforeceive_sub->RECEIVE_SUB_EXP_DATE).'<input type="hidden" name="WAREHOUSE_REQUEST_SUB_EXP_DATE[]" id="WAREHOUSE_REQUEST_SUB_EXP_DATE" class="form-control input-sm" value="'.$inforeceive_sub->RECEIVE_SUB_EXP_DATE.'">';   
            }

          
            echo $output;
        }

    
    

    

    public static function sumstorereceive($id)
    {
         $total  =  DB::table('warehouse_store_receive_sub')->where('STORE_ID','=',$id)->sum('RECEIVE_SUB_AMOUNT');
    
       return $total ;
    }


    


    public static function sumstoreexport($id)
    {
         $total  =  DB::table('warehouse_store_export_sub')->where('STORE_ID','=',$id)->sum('EXPORT_SUB_AMOUNT');
    
       return $total ;
    }



    
    public static function sumvaluestore($id)
    {
         $balance1  =  DB::table('warehouse_store_receive_sub')->where('STORE_ID','=',$id)->sum('RECEIVE_SUB_VALUE');
         $balance2  =  DB::table('warehouse_store_export_sub')->where('STORE_ID','=',$id)->sum('EXPORT_SUB_VALUE');
    
         $balance = $balance1 - $balance2;

       return $balance ;
    }
    
    public static function sumstoreexportlot($idlot)
    {
         $total  =  DB::table('warehouse_store_export_sub')->where('RECEIVE_SUB_ID','=',$idlot)->sum('EXPORT_SUB_AMOUNT');
    
       return $total ;
    }
    

    //-------------------------------treasury-----

    public static function sumtreasuryreceive($id)
    {
         $total  =  DB::table('warehouse_treasury_receive_sub')->where('TREASURY_ID','=',$id)->sum('TREASURY_RECEIVE_SUB_AMOUNT');
    
       return $total ;
    }

    public static function sumtreasuryexport($id)
    {
         $total  =  DB::table('warehouse_treasury_export_sub')->where('TREASURY_ID','=',$id)->sum('TREASURY_EXPORT_SUB_AMOUNT');
    
       return $total ;
    }

    public static function sumvaluetreasury($id)
    {
         $balance1  =  DB::table('warehouse_treasury_receive_sub')->where('TREASURY_ID','=',$id)->sum('TREASURY_RECEIVE_SUB_VALUE');
         $balance2  =  DB::table('warehouse_treasury_export_sub')->where('TREASURY_ID','=',$id)->sum('TREASURY_EXPORT_SUB_VALUE');
    
         $balance = $balance1 - $balance2;

       return $balance ;
    }

    public static function sumtreasuryexportsubsmall($id)
    {
        $total  =  DB::table('warehouse_treasury_export_small')->where('TREASURY_EXPORT_SMALL_ID','=',$id)->sum('TREASURY_EXPORT_SMALL_AMOUNT');
      return $total ;
     }

    public static function sumtreasuryreceivesmall($id)
    {
         $total  =  DB::table('warehouse_treasury_receive_small')->where('TREASURY_ID','=',$id)->sum('TREASURY_RECEIVE_SMALL_AMOUNT');
    
       return $total ;
    }
    
    public static function sumtreasuryexportsmall($id)
    {
         $total  =  DB::table('warehouse_treasury_export_small')->where('TREASURY_ID','=',$id)->sum('TREASURY_EXPORT_SMALL_AMOUNT');
    
       return $total ;
    }
    
    public static function sumvaluetreasurysmall($id)
    {
         $balance1  =  DB::table('warehouse_treasury_receive_small')->where('TREASURY_ID','=',$id)->sum('TREASURY_RECEIVE_SMALL_VALUE');
         $balance2  =  DB::table('warehouse_treasury_export_small')->where('TREASURY_ID','=',$id)->sum('TREASURY_EXPORT_SMALL_VALUE');
    
         $balance = $balance1 - $balance2;
    
       return $balance ;
    }  

    public static function sumvaluetreasuryexport($id)
    {
       
         $balance2  =  DB::table('warehouse_treasury_export_sub')->where('TREASURY_ID','=',$id)->sum('TREASURY_EXPORT_SUB_VALUE');
    
       

       return $balance2 ;
    }



    public static function sumvaluetreasuryall($iddep)
    {
         $balance1  =  DB::table('warehouse_treasury_receive_sub')
         ->leftJoin('warehouse_treasury','warehouse_treasury_receive_sub.TREASURY_ID','=','warehouse_treasury.TREASURY_ID')
         ->where('TREASURY_TYPE','=',$iddep)
         ->sum('TREASURY_RECEIVE_SUB_VALUE');


         $balance2  =  DB::table('warehouse_treasury_export_sub')
         ->leftJoin('warehouse_treasury','warehouse_treasury_export_sub.TREASURY_ID','=','warehouse_treasury.TREASURY_ID')
         ->where('TREASURY_TYPE','=',$iddep)
         ->sum('TREASURY_EXPORT_SUB_VALUE');
    
         $balance = $balance1 - $balance2;

       return $balance ;
    }

  //----------------
  public static function sumtreasuryexportsub($id)
  {
       $total  =  DB::table('warehouse_treasury_export_sub')->where('TREASURY_RECEIVE_SUB_ID','=',$id)->sum('TREASURY_EXPORT_SUB_AMOUNT');
  
     return $total ;
  }


  //--------------------

  

  function chectunitpiceupdate(Request $request)
  {
   

    $infoexports = DB::table('warehouse_store_export_sub_copy1')->get();

    foreach ($infoexports as $infoexport){ 

        if($infoexport->EXPORT_SUB_LOT <> ''){

            $info01 =  DB::table('warehouse_store_receive_sub_copy1')
                    ->where('RECEIVE_SUB_LOT','=',$infoexport->EXPORT_SUB_LOT)
                    ->where('STORE_ID','=',$infoexport->STORE_ID)
                    ->first();

                    $re_id = $infoexport->EXPORT_SUB_ID;
                    $addinfocheck = Warehousestoreexportsub::find($re_id);
                    $addinfocheck->EXPORT_SUB_PICE_UNIT = $info01->RECEIVE_SUB_PICE_UNIT;
                    $addinfocheck->EXPORT_SUB_VALUE = $info01->RECEIVE_SUB_PICE_UNIT * $infoexport->EXPORT_SUB_AMOUNT;
                    $addinfocheck->save();
            
                    echo $infoexport->EXPORT_SUB_NAME.'เรียบร้อย 1 <br>';
        }else{

            $info01 =  DB::table('warehouse_store_receive_sub_copy1')
            ->where('STORE_ID','=',$infoexport->STORE_ID)
            ->first();

            $re_id = $infoexport->EXPORT_SUB_ID;
            $addinfocheck = Warehousestoreexportsub::find($re_id);
            $addinfocheck->EXPORT_SUB_PICE_UNIT = $info01->RECEIVE_SUB_PICE_UNIT;
            $addinfocheck->EXPORT_SUB_VALUE = $info01->RECEIVE_SUB_PICE_UNIT * $infoexport->EXPORT_SUB_AMOUNT;
            $addinfocheck->save();
            echo $infoexport->EXPORT_SUB_NAME.'เรียบร้อย 2 <br>';
        }
       
        }



  }




  
  //รายงานไตรมาส
  

  public function reportquarter(request $request)
  {




    if($request->method() === 'POST'){
        $RECEIVE_STORE = $request->RECEIVE_STORE;
        $TYPE_CODE = $request->TYPE_CODE;
        session([
            'manager_warehouse.warehousreportquarter.RECEIVESTORE' => $RECEIVE_STORE,
            'manager_warehouse.warehousreportquarter.TYPECODE' => $TYPE_CODE,
        ]);

    }elseif(Session::has('manager_warehouse.warehousreportquarter')){
        $RECEIVE_STORE = session('manager_warehouse.warehousreportquarter.RECEIVESTORE');
        $TYPE_CODE = session('manager_warehouse.warehousreportquarter.TYPECODE');
    }else{
        $RECEIVE_STORE = '';
        $TYPE_CODE = '';
    }

        $infotype = DB::table('supplies_type')->get();
        
        $infosuppliesinven = DB::table('supplies_inven')
      ->where('ACTIVE','=','True')
      ->orderBy('INVEN_NAME', 'asc')
      ->get();
        
      //=================ยอดยกมาตั้งต้น
      $fromfirst = date('2021-07-01');
      $tofirst = date('2021-09-30');
      $infotrialltotalrecivefirst = DB::table('warehouse_check_receive_sub')
      ->leftjoin('warehouse_check_receive','warehouse_check_receive.RECEIVE_ID','=','warehouse_check_receive_sub.RECEIVE_ID')
      ->leftjoin('supplies','supplies.ID','warehouse_check_receive_sub.RECEIVE_SUB_CODE');
      if(!empty($RECEIVE_STORE)){
        $infotrialltotalrecivefirst = $infotrialltotalrecivefirst->where('warehouse_check_receive.RECEIVE_STORE',$RECEIVE_STORE);
      }
      if(!empty($TYPE_CODE)){
        $infotrialltotalrecivefirst = $infotrialltotalrecivefirst->where('supplies.SUP_TYPE_ID',$TYPE_CODE);
      }
      $infotrialltotalrecivefirst = $infotrialltotalrecivefirst->where('supplies.ID','<>','637')
      ->where('supplies.ID','<>','577')
      ->where('warehouse_check_receive.RECEIVE_CHECK_STATUS','=','1')
      ->whereBetween('warehouse_check_receive.RECEIVE_CHECK_DATE', [$fromfirst, $tofirst])
      ->sum('warehouse_check_receive_sub.RECEIVE_SUB_VALUE');
        

      
      $infotricountytotalfirst = DB::table('warehouse_check_receive_sub')
      ->leftjoin('warehouse_check_receive','warehouse_check_receive.RECEIVE_ID','=','warehouse_check_receive_sub.RECEIVE_ID')
      ->leftjoin('supplies','supplies.ID','warehouse_check_receive_sub.RECEIVE_SUB_CODE');
      if(!empty($RECEIVE_STORE)){
        $infotricountytotalfirst = $infotricountytotalfirst->where('warehouse_check_receive.RECEIVE_STORE',$RECEIVE_STORE);
      }
      if(!empty($TYPE_CODE)){
        $infotricountytotalfirst = $infotricountytotalfirst->where('supplies.SUP_TYPE_ID',$TYPE_CODE);
      }
      $infotricountytotalfirst = $infotricountytotalfirst->where('supplies.ID','<>','637')
      ->where('supplies.ID','<>','577')
      ->where('supplies.CONTINUE_PRICE_ID','=','2')
      ->where('warehouse_check_receive.RECEIVE_CHECK_STATUS','=','1')
      ->where('warehouse_check_receive_sub.RECEIVE_SUB_TYPE','<>','3')
      ->whereBetween('warehouse_check_receive.RECEIVE_CHECK_DATE', [$fromfirst, $tofirst])
      ->sum('warehouse_check_receive_sub.RECEIVE_SUB_VALUE');


      $infotriprovincetotalfirst = DB::table('warehouse_check_receive_sub')
      ->leftjoin('warehouse_check_receive','warehouse_check_receive.RECEIVE_ID','=','warehouse_check_receive_sub.RECEIVE_ID')
      ->leftjoin('supplies','supplies.ID','warehouse_check_receive_sub.RECEIVE_SUB_CODE');  
      if(!empty($RECEIVE_STORE)){
        $infotriprovincetotalfirst = $infotriprovincetotalfirst->where('warehouse_check_receive.RECEIVE_STORE',$RECEIVE_STORE);
      }
      if(!empty($TYPE_CODE)){
        $infotriprovincetotalfirst = $infotriprovincetotalfirst->where('supplies.SUP_TYPE_ID',$TYPE_CODE);
      }
      $infotriprovincetotalfirst = $infotriprovincetotalfirst->where('supplies.ID','<>','637')
      ->where('supplies.ID','<>','577')
      ->where('supplies.CONTINUE_PRICE_ID','=','1')
      ->where('warehouse_check_receive.RECEIVE_CHECK_STATUS','=','1')
      ->where('warehouse_check_receive_sub.RECEIVE_SUB_TYPE','<>','3')
      ->whereBetween('warehouse_check_receive.RECEIVE_CHECK_DATE', [$fromfirst, $tofirst])
      ->sum('warehouse_check_receive_sub.RECEIVE_SUB_VALUE');

      $infotriselftotalfirst = DB::table('warehouse_check_receive_sub')
      ->leftjoin('warehouse_check_receive','warehouse_check_receive.RECEIVE_ID','=','warehouse_check_receive_sub.RECEIVE_ID')
      ->leftjoin('supplies','supplies.ID','warehouse_check_receive_sub.RECEIVE_SUB_CODE');  
      if(!empty($RECEIVE_STORE)){
        $infotriselftotalfirst = $infotriselftotalfirst->where('warehouse_check_receive.RECEIVE_STORE',$RECEIVE_STORE);
      }
      if(!empty($TYPE_CODE)){
        $infotriselftotalfirst = $infotriselftotalfirst->where('supplies.SUP_TYPE_ID',$TYPE_CODE);
      }
      $infotriselftotalfirst = $infotriselftotalfirst->where('supplies.ID','<>','637')
      ->where('supplies.ID','<>','577')
      ->where('supplies.CONTINUE_PRICE_ID','=','3')
      ->where('warehouse_check_receive.RECEIVE_CHECK_STATUS','=','1')
      ->where('warehouse_check_receive_sub.RECEIVE_SUB_TYPE','<>','3')
      ->whereBetween('warehouse_check_receive.RECEIVE_CHECK_DATE', [$fromfirst, $tofirst])
      ->sum('warehouse_check_receive_sub.RECEIVE_SUB_VALUE');


      $infonotremarktotalfirst = DB::table('warehouse_check_receive_sub')
      ->leftjoin('warehouse_check_receive','warehouse_check_receive.RECEIVE_ID','=','warehouse_check_receive_sub.RECEIVE_ID')
      ->leftjoin('supplies','supplies.ID','warehouse_check_receive_sub.RECEIVE_SUB_CODE');
      if(!empty($RECEIVE_STORE)){
        $infonotremarktotalfirst = $infonotremarktotalfirst->where('warehouse_check_receive.RECEIVE_STORE',$RECEIVE_STORE);
      }
      if(!empty($TYPE_CODE)){
        $infonotremarktotalfirst = $infonotremarktotalfirst->where('supplies.SUP_TYPE_ID',$TYPE_CODE);
      }
      $infonotremarktotalfirst = $infonotremarktotalfirst->where('supplies.ID','<>','637')
      ->where('supplies.ID','<>','577')
      ->where('supplies.CONTINUE_PRICE_ID','=',null)
      ->where('warehouse_check_receive.RECEIVE_CHECK_STATUS','=','1')
      ->where('warehouse_check_receive_sub.RECEIVE_SUB_TYPE','<>','3')
      ->whereBetween('warehouse_check_receive.RECEIVE_CHECK_DATE', [$fromfirst, $tofirst])
      ->sum('warehouse_check_receive_sub.RECEIVE_SUB_VALUE');

      $infotribonustotalfirst = DB::table('warehouse_check_receive_sub')
      ->leftjoin('warehouse_check_receive','warehouse_check_receive.RECEIVE_ID','=','warehouse_check_receive_sub.RECEIVE_ID')
      ->leftjoin('supplies','supplies.ID','warehouse_check_receive_sub.RECEIVE_SUB_CODE');
      if(!empty($RECEIVE_STORE)){
        $infotribonustotalfirst = $infotribonustotalfirst->where('warehouse_check_receive.RECEIVE_STORE',$RECEIVE_STORE);
      }
      if(!empty($TYPE_CODE)){
        $infotribonustotalfirst = $infotribonustotalfirst->where('supplies.SUP_TYPE_ID',$TYPE_CODE);
      }
      $infotribonustotalfirst = $infotribonustotalfirst->where('supplies.ID','<>','637')
      ->where('supplies.ID','<>','577')
      ->where('warehouse_check_receive.RECEIVE_CHECK_STATUS','=','1')
      ->where('warehouse_check_receive_sub.RECEIVE_SUB_TYPE','=','3')
      ->whereBetween('warehouse_check_receive.RECEIVE_CHECK_DATE', [$fromfirst, $tofirst])
      ->sum('warehouse_check_receive_sub.RECEIVE_SUB_VALUE');

      //==================================ไตรมาส 1
      $from = date('2021-10-01');
      $to = date('2021-12-31');
      $infotriall_1_count = DB::table('warehouse_check_receive_sub')
      ->select('supplies.ID', DB::raw('count(*) as total'))
      ->leftjoin('warehouse_check_receive','warehouse_check_receive.RECEIVE_ID','=','warehouse_check_receive_sub.RECEIVE_ID')
      ->leftjoin('supplies','supplies.ID','warehouse_check_receive_sub.RECEIVE_SUB_CODE');
      if(!empty($RECEIVE_STORE)){
        $infotriall_1_count = $infotriall_1_count->where('warehouse_check_receive.RECEIVE_STORE',$RECEIVE_STORE);
      }
      if(!empty($TYPE_CODE)){
        $infotriall_1_count = $infotriall_1_count->where('supplies.SUP_TYPE_ID',$TYPE_CODE);
      }
      $infotriall_1_count = $infotriall_1_count->where('supplies.ID','<>','637')
      ->where('supplies.ID','<>','577')
      ->where('warehouse_check_receive.RECEIVE_CHECK_STATUS','=','1')
      ->whereBetween('warehouse_check_receive.RECEIVE_CHECK_DATE', [$from, $to])
      ->groupBy('supplies.ID')
      ->get();
      $infotriall_1 = count($infotriall_1_count);
  

      $infotrialltotal_1 = DB::table('warehouse_check_receive_sub')
      ->leftjoin('warehouse_check_receive','warehouse_check_receive.RECEIVE_ID','=','warehouse_check_receive_sub.RECEIVE_ID')
      ->leftjoin('supplies','supplies.ID','warehouse_check_receive_sub.RECEIVE_SUB_CODE');
      if(!empty($RECEIVE_STORE)){
        $infotrialltotal_1 = $infotrialltotal_1->where('warehouse_check_receive.RECEIVE_STORE',$RECEIVE_STORE);
      }
      if(!empty($TYPE_CODE)){
        $infotrialltotal_1 = $infotrialltotal_1->where('supplies.SUP_TYPE_ID',$TYPE_CODE);
      }
      $infotrialltotal_1 = $infotrialltotal_1->where('supplies.ID','<>','637')
      ->where('supplies.ID','<>','577')
      ->where('warehouse_check_receive.RECEIVE_CHECK_STATUS','=','1')
      ->whereBetween('warehouse_check_receive.RECEIVE_CHECK_DATE', [$from, $to])
      ->sum('warehouse_check_receive_sub.RECEIVE_SUB_VALUE');

     //==================มูลค่าการจ่าย

     $infotrialltotalpay_1 = DB::table('warehouse_store_export_sub')
     ->leftjoin('warehouse_request','warehouse_request.WAREHOUSE_REQUEST_CODE','=','warehouse_store_export_sub.WAREHOUSE_REQUEST_CODE')
     ->leftjoin('warehouse_store','warehouse_store.STORE_ID','warehouse_store_export_sub.STORE_ID')
     ->leftjoin('supplies','supplies.ID','warehouse_store.STORE_SUP_ID');
     if(!empty($RECEIVE_STORE)){
        $infotrialltotalpay_1 = $infotrialltotalpay_1->where('warehouse_store.STORE_TYPE',$RECEIVE_STORE);
      }
      if(!empty($TYPE_CODE)){
        $infotrialltotalpay_1 = $infotrialltotalpay_1->where('supplies.SUP_TYPE_ID',$TYPE_CODE);
      }
      $infotrialltotalpay_1 = $infotrialltotalpay_1->where('warehouse_store.STORE_SUP_ID','<>','637')
     ->where('warehouse_store.STORE_SUP_ID','<>','577')
     ->whereBetween('warehouse_request.WAREHOUSE_PAYDAY', [$from, $to])
     ->sum('warehouse_store_export_sub.EXPORT_SUB_VALUE');

     

 
      $infotricounty_1_count = DB::table('warehouse_check_receive_sub')
      ->select('supplies.ID', DB::raw('count(*) as total'))
      ->leftjoin('warehouse_check_receive','warehouse_check_receive.RECEIVE_ID','=','warehouse_check_receive_sub.RECEIVE_ID')
      ->leftjoin('supplies','supplies.ID','warehouse_check_receive_sub.RECEIVE_SUB_CODE');
      if(!empty($RECEIVE_STORE)){
        $infotricounty_1_count = $infotricounty_1_count->where('warehouse_check_receive.RECEIVE_STORE',$RECEIVE_STORE);
      }
      if(!empty($TYPE_CODE)){
        $infotricounty_1_count = $infotricounty_1_count->where('supplies.SUP_TYPE_ID',$TYPE_CODE);
      }
      $infotricounty_1_count = $infotricounty_1_count->where('supplies.ID','<>','637')
      ->where('supplies.ID','<>','577')
      ->where('supplies.CONTINUE_PRICE_ID','=','2')
      ->where('warehouse_check_receive.RECEIVE_CHECK_STATUS','=','1')
      ->where('warehouse_check_receive_sub.RECEIVE_SUB_TYPE','<>','3')
      ->whereBetween('warehouse_check_receive.RECEIVE_CHECK_DATE', [$from, $to])
      ->groupBy('supplies.ID')
      ->get();
      $infotricounty_1 = count($infotricounty_1_count);

      $infotricountytotal_1 = DB::table('warehouse_check_receive_sub')
      ->leftjoin('warehouse_check_receive','warehouse_check_receive.RECEIVE_ID','=','warehouse_check_receive_sub.RECEIVE_ID')
      ->leftjoin('supplies','supplies.ID','warehouse_check_receive_sub.RECEIVE_SUB_CODE');
      if(!empty($RECEIVE_STORE)){
        $infotricountytotal_1 = $infotricountytotal_1->where('warehouse_check_receive.RECEIVE_STORE',$RECEIVE_STORE);
      }
      if(!empty($TYPE_CODE)){
        $infotricountytotal_1 = $infotricountytotal_1->where('supplies.SUP_TYPE_ID',$TYPE_CODE);
      }
      $infotricountytotal_1 = $infotricountytotal_1->where('supplies.ID','<>','637')
      ->where('supplies.ID','<>','577')
      ->where('supplies.CONTINUE_PRICE_ID','=','2')
      ->where('warehouse_check_receive.RECEIVE_CHECK_STATUS','=','1')
      ->where('warehouse_check_receive_sub.RECEIVE_SUB_TYPE','<>','3')
      ->whereBetween('warehouse_check_receive.RECEIVE_CHECK_DATE', [$from, $to])
      ->sum('warehouse_check_receive_sub.RECEIVE_SUB_VALUE');


             //==================มูลค่าการจ่าย


     $infotricountytotalpay_1 =  DB::table('warehouse_store_export_sub')
     ->leftjoin('warehouse_request','warehouse_request.WAREHOUSE_REQUEST_CODE','=','warehouse_store_export_sub.WAREHOUSE_REQUEST_CODE')
     ->leftjoin('warehouse_store','warehouse_store.STORE_ID','warehouse_store_export_sub.STORE_ID')
     ->leftjoin('supplies','supplies.ID','warehouse_store.STORE_SUP_ID');   
 if(!empty($RECEIVE_STORE)){
    $infotricountytotalpay_1 = $infotricountytotalpay_1->where('warehouse_store.STORE_TYPE',$RECEIVE_STORE);
  }
  if(!empty($TYPE_CODE)){
    $infotricountytotalpay_1 = $infotricountytotalpay_1->where('supplies.SUP_TYPE_ID',$TYPE_CODE);
  }
    $infotricountytotalpay_1 = $infotricountytotalpay_1->where('warehouse_store.STORE_SUP_ID','<>','637')
     ->where('warehouse_store.STORE_SUP_ID','<>','577')
     ->where('supplies.CONTINUE_PRICE_ID','=','2')
     ->whereBetween('warehouse_request.WAREHOUSE_PAYDAY', [$from, $to])
     ->sum('warehouse_store_export_sub.EXPORT_SUB_VALUE');

      $infotriprovince_1_count = DB::table('warehouse_check_receive_sub')
      ->select('supplies.ID', DB::raw('count(*) as total'))
      ->leftjoin('warehouse_check_receive','warehouse_check_receive.RECEIVE_ID','=','warehouse_check_receive_sub.RECEIVE_ID')
      ->leftjoin('supplies','supplies.ID','warehouse_check_receive_sub.RECEIVE_SUB_CODE');
      if(!empty($RECEIVE_STORE)){
        $infotriprovince_1_count = $infotriprovince_1_count->where('warehouse_check_receive.RECEIVE_STORE',$RECEIVE_STORE);
      }
      if(!empty($TYPE_CODE)){
        $infotriprovince_1_count = $infotriprovince_1_count->where('supplies.SUP_TYPE_ID',$TYPE_CODE);
      }
      $infotriprovince_1_count = $infotriprovince_1_count->where('supplies.ID','<>','637')
      ->where('supplies.ID','<>','577')
      ->where('supplies.CONTINUE_PRICE_ID','=','1')
      ->where('warehouse_check_receive.RECEIVE_CHECK_STATUS','=','1')
      ->where('warehouse_check_receive_sub.RECEIVE_SUB_TYPE','<>','3')
      ->whereBetween('warehouse_check_receive.RECEIVE_CHECK_DATE', [$from, $to])
      ->groupBy('supplies.ID')
      ->get();
      $infotriprovince_1 = count($infotriprovince_1_count);
      
      $infotriprovincetotal_1 = DB::table('warehouse_check_receive_sub')
      ->leftjoin('warehouse_check_receive','warehouse_check_receive.RECEIVE_ID','=','warehouse_check_receive_sub.RECEIVE_ID')
      ->leftjoin('supplies','supplies.ID','warehouse_check_receive_sub.RECEIVE_SUB_CODE');
      if(!empty($RECEIVE_STORE)){
        $infotriprovincetotal_1 = $infotriprovincetotal_1->where('warehouse_check_receive.RECEIVE_STORE',$RECEIVE_STORE);
      }
      if(!empty($TYPE_CODE)){
        $infotriprovincetotal_1 = $infotriprovincetotal_1->where('supplies.SUP_TYPE_ID',$TYPE_CODE);
      }
      $infotriprovincetotal_1 = $infotriprovincetotal_1->where('supplies.ID','<>','637')
      ->where('supplies.ID','<>','577')
      ->where('supplies.CONTINUE_PRICE_ID','=','1')
      ->where('warehouse_check_receive.RECEIVE_CHECK_STATUS','=','1')
      ->where('warehouse_check_receive_sub.RECEIVE_SUB_TYPE','<>','3')
      ->whereBetween('warehouse_check_receive.RECEIVE_CHECK_DATE', [$from, $to])
      ->sum('warehouse_check_receive_sub.RECEIVE_SUB_VALUE');

      //==================มูลค่าการจ่าย


     
     $infotriprovincetotalpay_1 =  DB::table('warehouse_store_export_sub')
     ->leftjoin('warehouse_request','warehouse_request.WAREHOUSE_REQUEST_CODE','=','warehouse_store_export_sub.WAREHOUSE_REQUEST_CODE')
     ->leftjoin('warehouse_store','warehouse_store.STORE_ID','warehouse_store_export_sub.STORE_ID')
     ->leftjoin('supplies','supplies.ID','warehouse_store.STORE_SUP_ID');
     
        if(!empty($RECEIVE_STORE)){
            $infotriprovincetotalpay_1 = $infotriprovincetotalpay_1->where('warehouse_store.STORE_TYPE',$RECEIVE_STORE);
        }
        if(!empty($TYPE_CODE)){
            $infotriprovincetotalpay_1 = $infotriprovincetotalpay_1->where('supplies.SUP_TYPE_ID',$TYPE_CODE);
        }
    $infotriprovincetotalpay_1 = $infotriprovincetotalpay_1->where('warehouse_store.STORE_SUP_ID','<>','637')
     ->where('warehouse_store.STORE_SUP_ID','<>','577')
     ->where('supplies.CONTINUE_PRICE_ID','=','1')
     ->whereBetween('warehouse_request.WAREHOUSE_PAYDAY', [$from, $to])
     ->sum('warehouse_store_export_sub.EXPORT_SUB_VALUE');



      $infotriself_1_count = DB::table('warehouse_check_receive_sub')
      ->select('supplies.ID', DB::raw('count(*) as total'))
      ->leftjoin('warehouse_check_receive','warehouse_check_receive.RECEIVE_ID','=','warehouse_check_receive_sub.RECEIVE_ID')
      ->leftjoin('supplies','supplies.ID','warehouse_check_receive_sub.RECEIVE_SUB_CODE');
      if(!empty($RECEIVE_STORE)){
        $infotriself_1_count = $infotriself_1_count->where('warehouse_check_receive.RECEIVE_STORE',$RECEIVE_STORE);
      }
      if(!empty($TYPE_CODE)){
        $infotriself_1_count = $infotriself_1_count->where('supplies.SUP_TYPE_ID',$TYPE_CODE);
      }
      $infotriself_1_count = $infotriself_1_count->where('supplies.ID','<>','637')
      ->where('supplies.ID','<>','577')
      ->where('supplies.CONTINUE_PRICE_ID','=','3')
      ->where('warehouse_check_receive.RECEIVE_CHECK_STATUS','=','1')
      ->where('warehouse_check_receive_sub.RECEIVE_SUB_TYPE','<>','3')
      ->whereBetween('warehouse_check_receive.RECEIVE_CHECK_DATE', [$from, $to])
      ->groupBy('supplies.ID')
      ->get();
      $infotriself_1 = count($infotriself_1_count);

      $infotriselftotal_1 = DB::table('warehouse_check_receive_sub')
      ->leftjoin('warehouse_check_receive','warehouse_check_receive.RECEIVE_ID','=','warehouse_check_receive_sub.RECEIVE_ID')
      ->leftjoin('supplies','supplies.ID','warehouse_check_receive_sub.RECEIVE_SUB_CODE');
      if(!empty($RECEIVE_STORE)){
        $infotriselftotal_1 = $infotriselftotal_1->where('warehouse_check_receive.RECEIVE_STORE',$RECEIVE_STORE);
      }
      if(!empty($TYPE_CODE)){
        $infotriselftotal_1 = $infotriselftotal_1->where('supplies.SUP_TYPE_ID',$TYPE_CODE);
      }
      $infotriselftotal_1 = $infotriselftotal_1->where('supplies.ID','<>','637')
      ->where('supplies.ID','<>','577')
      ->where('supplies.CONTINUE_PRICE_ID','=','3')
      ->where('warehouse_check_receive.RECEIVE_CHECK_STATUS','=','1')
      ->where('warehouse_check_receive_sub.RECEIVE_SUB_TYPE','<>','3')
      ->whereBetween('warehouse_check_receive.RECEIVE_CHECK_DATE', [$from, $to])
      ->sum('warehouse_check_receive_sub.RECEIVE_SUB_VALUE');

              //==================มูลค่าการจ่าย


          
     $infotriselftotalpay_1 =  DB::table('warehouse_store_export_sub')
     ->leftjoin('warehouse_request','warehouse_request.WAREHOUSE_REQUEST_CODE','=','warehouse_store_export_sub.WAREHOUSE_REQUEST_CODE')
     ->leftjoin('warehouse_store','warehouse_store.STORE_ID','warehouse_store_export_sub.STORE_ID')
     ->leftjoin('supplies','supplies.ID','warehouse_store.STORE_SUP_ID');
     if(!empty($RECEIVE_STORE)){
        $infotriselftotalpay_1 = $infotriselftotalpay_1->where('warehouse_store.STORE_TYPE',$RECEIVE_STORE);
      }
      if(!empty($TYPE_CODE)){
        $infotriselftotalpay_1 = $infotriselftotalpay_1->where('supplies.SUP_TYPE_ID',$TYPE_CODE);
      }
      $infotriselftotalpay_1 = $infotriselftotalpay_1->where('warehouse_store.STORE_SUP_ID','<>','637')
     ->where('warehouse_store.STORE_SUP_ID','<>','577')
     ->where('supplies.CONTINUE_PRICE_ID','=','3')
     ->whereBetween('warehouse_request.WAREHOUSE_PAYDAY', [$from, $to])
     ->sum('warehouse_store_export_sub.EXPORT_SUB_VALUE');



      $infonotremark_1_count = DB::table('warehouse_check_receive_sub')
      ->select('supplies.ID', DB::raw('count(*) as total'))
      ->leftjoin('warehouse_check_receive','warehouse_check_receive.RECEIVE_ID','=','warehouse_check_receive_sub.RECEIVE_ID')
      ->leftjoin('supplies','supplies.ID','warehouse_check_receive_sub.RECEIVE_SUB_CODE');
      if(!empty($RECEIVE_STORE)){
        $infonotremark_1_count = $infonotremark_1_count->where('warehouse_check_receive.RECEIVE_STORE',$RECEIVE_STORE);
      }
      if(!empty($TYPE_CODE)){
        $infonotremark_1_count = $infonotremark_1_count->where('supplies.SUP_TYPE_ID',$TYPE_CODE);
      }
      $infonotremark_1_count = $infonotremark_1_count->where('supplies.ID','<>','637')
      ->where('supplies.ID','<>','577')
      ->where('supplies.CONTINUE_PRICE_ID','=',null)
      ->where('warehouse_check_receive.RECEIVE_CHECK_STATUS','=','1')
      ->where('warehouse_check_receive_sub.RECEIVE_SUB_TYPE','<>','3')
      ->whereBetween('warehouse_check_receive.RECEIVE_CHECK_DATE', [$from, $to])
      ->groupBy('supplies.ID')
      ->get();
      $infonotremark_1 = count($infonotremark_1_count);
      
    

      $infonotremarktotal_1 = DB::table('warehouse_check_receive_sub')
      ->leftjoin('warehouse_check_receive','warehouse_check_receive.RECEIVE_ID','=','warehouse_check_receive_sub.RECEIVE_ID')
      ->leftjoin('supplies','supplies.ID','warehouse_check_receive_sub.RECEIVE_SUB_CODE');
      if(!empty($RECEIVE_STORE)){
        $infonotremarktotal_1 = $infonotremarktotal_1->where('warehouse_check_receive.RECEIVE_STORE',$RECEIVE_STORE);
      }
      if(!empty($TYPE_CODE)){
        $infonotremarktotal_1 = $infonotremarktotal_1->where('supplies.SUP_TYPE_ID',$TYPE_CODE);
      }
      $infonotremarktotal_1 = $infonotremarktotal_1->where('supplies.ID','<>','637')
      ->where('supplies.ID','<>','577')
      ->where('supplies.CONTINUE_PRICE_ID','=',null)
      ->where('warehouse_check_receive.RECEIVE_CHECK_STATUS','=','1')
      ->where('warehouse_check_receive_sub.RECEIVE_SUB_TYPE','<>','3')
      ->whereBetween('warehouse_check_receive.RECEIVE_CHECK_DATE', [$from, $to])
      ->sum('warehouse_check_receive_sub.RECEIVE_SUB_VALUE');

                      //==================มูลค่าการจ่าย

     $infonotremarktotalpay_1 = DB::table('warehouse_store_export_sub')
     ->leftjoin('warehouse_request','warehouse_request.WAREHOUSE_REQUEST_CODE','=','warehouse_store_export_sub.WAREHOUSE_REQUEST_CODE')
     ->leftjoin('warehouse_store','warehouse_store.STORE_ID','warehouse_store_export_sub.STORE_ID')
     ->leftjoin('supplies','supplies.ID','warehouse_store.STORE_SUP_ID');
     if(!empty($RECEIVE_STORE)){
        $infonotremarktotalpay_1 = $infonotremarktotalpay_1->where('warehouse_store.STORE_TYPE',$RECEIVE_STORE);
      }
      if(!empty($TYPE_CODE)){
        $infonotremarktotalpay_1 = $infonotremarktotalpay_1->where('supplies.SUP_TYPE_ID',$TYPE_CODE);
      }
      $infonotremarktotalpay_1 = $infonotremarktotalpay_1->where('warehouse_store.STORE_SUP_ID','<>','637')
     ->where('warehouse_store.STORE_SUP_ID','<>','577')
     ->where('supplies.CONTINUE_PRICE_ID','=',null)
     ->whereBetween('warehouse_request.WAREHOUSE_PAYDAY', [$from, $to])
     ->sum('warehouse_store_export_sub.EXPORT_SUB_VALUE');
  

      $infotribonus_1_count = DB::table('warehouse_check_receive_sub')
      ->select('supplies.ID', DB::raw('count(*) as total'))
      ->leftjoin('warehouse_check_receive','warehouse_check_receive.RECEIVE_ID','=','warehouse_check_receive_sub.RECEIVE_ID')
      ->leftjoin('supplies','supplies.ID','warehouse_check_receive_sub.RECEIVE_SUB_CODE');
      if(!empty($RECEIVE_STORE)){
        $infotribonus_1_count = $infotribonus_1_count->where('warehouse_check_receive.RECEIVE_STORE',$RECEIVE_STORE);
      }
      if(!empty($TYPE_CODE)){
        $infotribonus_1_count = $infotribonus_1_count->where('supplies.SUP_TYPE_ID',$TYPE_CODE);
      }
      $infotribonus_1_count = $infotribonus_1_count->where('supplies.ID','<>','637')
      ->where('supplies.ID','<>','577')
      ->where('warehouse_check_receive.RECEIVE_CHECK_STATUS','=','1')
      ->where('warehouse_check_receive_sub.RECEIVE_SUB_TYPE','=','3')
      ->whereBetween('warehouse_check_receive.RECEIVE_CHECK_DATE', [$from, $to])
      ->groupBy('supplies.ID')
      ->get();
      $infotribonus_1 = count($infotribonus_1_count);

     

      $infotribonustotal_1 = DB::table('warehouse_check_receive_sub')
      ->leftjoin('warehouse_check_receive','warehouse_check_receive.RECEIVE_ID','=','warehouse_check_receive_sub.RECEIVE_ID')
      ->leftjoin('supplies','supplies.ID','warehouse_check_receive_sub.RECEIVE_SUB_CODE');
      if(!empty($RECEIVE_STORE)){
        $infotribonustotal_1 = $infotribonustotal_1->where('warehouse_check_receive.RECEIVE_STORE',$RECEIVE_STORE);
      }
      if(!empty($TYPE_CODE)){
        $infotribonustotal_1 = $infotribonustotal_1->where('supplies.SUP_TYPE_ID',$TYPE_CODE);
      }
      $infotribonustotal_1 = $infotribonustotal_1->where('supplies.ID','<>','637')
      ->where('supplies.ID','<>','577')
      ->where('warehouse_check_receive.RECEIVE_CHECK_STATUS','=','1')
      ->where('warehouse_check_receive_sub.RECEIVE_SUB_TYPE','=','3')
      ->whereBetween('warehouse_check_receive.RECEIVE_CHECK_DATE', [$from, $to])
      ->sum('warehouse_check_receive_sub.RECEIVE_SUB_VALUE');


          //==================มูลค่าการจ่าย

     $infotribonustotalpay_1 = DB::table('warehouse_check_receive_sub')
     ->leftjoin('warehouse_check_receive','warehouse_check_receive.RECEIVE_ID','=','warehouse_check_receive_sub.RECEIVE_ID')
     ->leftjoin('supplies','supplies.ID','warehouse_check_receive_sub.RECEIVE_SUB_CODE')
     ->leftjoin('warehouse_store_export_sub','supplies.ID','warehouse_store_export_sub.RECEIVE_SUB_ID');
     if(!empty($RECEIVE_STORE)){
        $infotribonustotalpay_1 = $infotribonustotalpay_1->where('warehouse_check_receive.RECEIVE_STORE',$RECEIVE_STORE);
      }
      if(!empty($TYPE_CODE)){
        $infotribonustotalpay_1 = $infotribonustotalpay_1->where('supplies.SUP_TYPE_ID',$TYPE_CODE);
      }
      $infotribonustotalpay_1 = $infotribonustotalpay_1->where('supplies.ID','<>','637')
     ->where('supplies.ID','<>','577')
     ->where('warehouse_check_receive.RECEIVE_CHECK_STATUS','=','1')
     ->where('warehouse_check_receive_sub.RECEIVE_SUB_TYPE','=','3')
     ->whereBetween('warehouse_store_export_sub.created_at', [$from, $to])
     ->sum('EXPORT_SUB_VALUE');



     
                      //==================มูลค่าการจ่ายรพสต.

                      $infohcenter_1_count = DB::table('warehouse_check_receive_sub')
                      ->select('supplies.ID', DB::raw('count(*) as total'))
                      ->leftjoin('warehouse_check_receive','warehouse_check_receive.RECEIVE_ID','=','warehouse_check_receive_sub.RECEIVE_ID')
                      ->leftjoin('supplies','supplies.ID','warehouse_check_receive_sub.RECEIVE_SUB_CODE')
                      ->leftjoin('warehouse_store_export_sub','supplies.ID','warehouse_store_export_sub.RECEIVE_SUB_ID')
                      ->leftjoin('warehouse_request','warehouse_request.WAREHOUSE_REQUEST_CODE','warehouse_store_export_sub.WAREHOUSE_REQUEST_CODE');
                      if(!empty($RECEIVE_STORE)){
                        $infohcenter_1_count = $infohcenter_1_count->where('warehouse_check_receive.RECEIVE_STORE',$RECEIVE_STORE);
                      }
                      if(!empty($TYPE_CODE)){
                        $infohcenter_1_count = $infohcenter_1_count->where('supplies.SUP_TYPE_ID',$TYPE_CODE);
                      }
                      $infohcenter_1_count = $infohcenter_1_count->where('supplies.ID','<>','637')
                      ->where('supplies.ID','<>','577')
                       ->where('warehouse_request.WAREHOUSE_SMALLHOS','!=',null)
                      ->whereBetween('warehouse_store_export_sub.created_at', [$from, $to])
                      ->groupBy('supplies.ID')
                      ->get();
                      $infohcenter_1 = count($infohcenter_1_count);

                      $infohcentertotalpay_1 = DB::table('warehouse_check_receive_sub')
                      ->leftjoin('warehouse_check_receive','warehouse_check_receive.RECEIVE_ID','=','warehouse_check_receive_sub.RECEIVE_ID')
                      ->leftjoin('supplies','supplies.ID','warehouse_check_receive_sub.RECEIVE_SUB_CODE')
                      ->leftjoin('warehouse_store_export_sub','supplies.ID','warehouse_store_export_sub.RECEIVE_SUB_ID')
                      ->leftjoin('warehouse_request','warehouse_request.WAREHOUSE_REQUEST_CODE','warehouse_store_export_sub.WAREHOUSE_REQUEST_CODE');
                      if(!empty($RECEIVE_STORE)){
                        $infohcentertotalpay_1 = $infohcentertotalpay_1->where('warehouse_check_receive.RECEIVE_STORE',$RECEIVE_STORE);
                      }
                      if(!empty($TYPE_CODE)){
                        $infohcentertotalpay_1 = $infohcentertotalpay_1->where('supplies.SUP_TYPE_ID',$TYPE_CODE);
                      }
                      $infohcentertotalpay_1 = $infohcentertotalpay_1->where('warehouse_check_receive.RECEIVE_STORE','=','3')
                      ->where('supplies.SUP_TYPE_ID','=','7')
                      ->where('supplies.ID','<>','637')
                      ->where('supplies.ID','<>','577')
                       ->where('warehouse_request.WAREHOUSE_SMALLHOS','!=',null)
                      ->whereBetween('warehouse_store_export_sub.created_at', [$from, $to])
                      ->sum('EXPORT_SUB_VALUE');


                  
      
        //==================================ไตรมาส 2
        $from2 = date('2022-01-01');
        $to2 = date('2022-03-31');
        $infotriall_2_count = DB::table('warehouse_check_receive_sub')
        ->select('supplies.ID', DB::raw('count(*) as total'))
        ->leftjoin('warehouse_check_receive','warehouse_check_receive.RECEIVE_ID','=','warehouse_check_receive_sub.RECEIVE_ID')
        ->leftjoin('supplies','supplies.ID','warehouse_check_receive_sub.RECEIVE_SUB_CODE');
        if(!empty($RECEIVE_STORE)){
            $infotriall_2_count = $infotriall_2_count->where('warehouse_check_receive.RECEIVE_STORE',$RECEIVE_STORE);
          }
          if(!empty($TYPE_CODE)){
            $infotriall_2_count = $infotriall_2_count->where('supplies.SUP_TYPE_ID',$TYPE_CODE);
          }
          $infotriall_2_count = $infotriall_2_count->where('supplies.ID','<>','637')
        ->where('supplies.ID','<>','577')
        ->where('warehouse_check_receive.RECEIVE_CHECK_STATUS','=','1')
        ->whereBetween('warehouse_check_receive.RECEIVE_CHECK_DATE', [$from2, $to2])
        ->groupBy('supplies.ID')
        ->get();
        $infotriall_2 = count($infotriall_2_count);
    
  
        $infotrialltotal_2 = DB::table('warehouse_check_receive_sub')
        ->leftjoin('warehouse_check_receive','warehouse_check_receive.RECEIVE_ID','=','warehouse_check_receive_sub.RECEIVE_ID')
        ->leftjoin('supplies','supplies.ID','warehouse_check_receive_sub.RECEIVE_SUB_CODE');
        if(!empty($RECEIVE_STORE)){
            $infotrialltotal_2 = $infotrialltotal_2->where('warehouse_check_receive.RECEIVE_STORE',$RECEIVE_STORE);
          }
          if(!empty($TYPE_CODE)){
            $infotrialltotal_2 = $infotrialltotal_2->where('supplies.SUP_TYPE_ID',$TYPE_CODE);
          }
          $infotrialltotal_2 = $infotrialltotal_2->where('supplies.ID','<>','637')
        ->where('supplies.ID','<>','577')
        ->where('warehouse_check_receive.RECEIVE_CHECK_STATUS','=','1')
        ->whereBetween('warehouse_check_receive.RECEIVE_CHECK_DATE', [$from2, $to2])
        ->sum('warehouse_check_receive_sub.RECEIVE_SUB_VALUE');
  
       //==================มูลค่าการจ่าย
  

       $infotrialltotalpay_2 = DB::table('warehouse_store_export_sub')
       ->leftjoin('warehouse_request','warehouse_request.WAREHOUSE_REQUEST_CODE','=','warehouse_store_export_sub.WAREHOUSE_REQUEST_CODE')
       ->leftjoin('warehouse_store','warehouse_store.STORE_ID','warehouse_store_export_sub.STORE_ID')
       ->leftjoin('supplies','supplies.ID','warehouse_store.STORE_SUP_ID');
       if(!empty($RECEIVE_STORE)){
        $infotrialltotalpay_2 = $infotrialltotalpay_2->where('warehouse_store.STORE_TYPE',$RECEIVE_STORE);
      }
      if(!empty($TYPE_CODE)){
        $infotrialltotalpay_2 = $infotrialltotalpay_2->where('supplies.SUP_TYPE_ID',$TYPE_CODE);
      }
      $infotrialltotalpay_2 = $infotrialltotalpay_2->where('warehouse_store.STORE_SUP_ID','<>','637')
       ->where('warehouse_store.STORE_SUP_ID','<>','577')
       ->whereBetween('warehouse_request.WAREHOUSE_PAYDAY', [$from2, $to2])
       ->sum('warehouse_store_export_sub.EXPORT_SUB_VALUE');
  
  
  
  
        
        $infotricounty_2_count = DB::table('warehouse_check_receive_sub')
        ->select('supplies.ID', DB::raw('count(*) as total'))
        ->leftjoin('warehouse_check_receive','warehouse_check_receive.RECEIVE_ID','=','warehouse_check_receive_sub.RECEIVE_ID')
        ->leftjoin('supplies','supplies.ID','warehouse_check_receive_sub.RECEIVE_SUB_CODE');
        if(!empty($RECEIVE_STORE)){
            $infotricounty_2_count = $infotricounty_2_count->where('warehouse_check_receive.RECEIVE_STORE',$RECEIVE_STORE);
          }
          if(!empty($TYPE_CODE)){
            $infotricounty_2_count = $infotricounty_2_count->where('supplies.SUP_TYPE_ID',$TYPE_CODE);
          }
          $infotricounty_2_count = $infotricounty_2_count->where('supplies.ID','<>','637')
        ->where('supplies.ID','<>','577')
        ->where('supplies.CONTINUE_PRICE_ID','=','2')
        ->where('warehouse_check_receive.RECEIVE_CHECK_STATUS','=','1')
        ->where('warehouse_check_receive_sub.RECEIVE_SUB_TYPE','<>','3')
        ->whereBetween('warehouse_check_receive.RECEIVE_CHECK_DATE', [$from2, $to2])
        ->groupBy('supplies.ID')
        ->get();
        $infotricounty_2 = count($infotricounty_2_count);
  
        $infotricountytotal_2 = DB::table('warehouse_check_receive_sub')
        ->leftjoin('warehouse_check_receive','warehouse_check_receive.RECEIVE_ID','=','warehouse_check_receive_sub.RECEIVE_ID')
        ->leftjoin('supplies','supplies.ID','warehouse_check_receive_sub.RECEIVE_SUB_CODE');
        if(!empty($RECEIVE_STORE)){
            $infotricountytotal_2 = $infotricountytotal_2->where('warehouse_check_receive.RECEIVE_STORE',$RECEIVE_STORE);
          }
          if(!empty($TYPE_CODE)){
            $infotricountytotal_2 = $infotricountytotal_2->where('supplies.SUP_TYPE_ID',$TYPE_CODE);
          }
          $infotricountytotal_2 = $infotricountytotal_2->where('supplies.ID','<>','637')
        ->where('supplies.ID','<>','577')
        ->where('supplies.CONTINUE_PRICE_ID','=','2')
        ->where('warehouse_check_receive.RECEIVE_CHECK_STATUS','=','1')
        ->where('warehouse_check_receive_sub.RECEIVE_SUB_TYPE','<>','3')
        ->whereBetween('warehouse_check_receive.RECEIVE_CHECK_DATE', [$from2, $to2])
        ->sum('warehouse_check_receive_sub.RECEIVE_SUB_VALUE');
  
  
               //==================มูลค่าการจ่าย
  

       $infotricountytotalpay_2 =  DB::table('warehouse_store_export_sub')
     ->leftjoin('warehouse_request','warehouse_request.WAREHOUSE_REQUEST_CODE','=','warehouse_store_export_sub.WAREHOUSE_REQUEST_CODE')
     ->leftjoin('warehouse_store','warehouse_store.STORE_ID','warehouse_store_export_sub.STORE_ID')
     ->leftjoin('supplies','supplies.ID','warehouse_store.STORE_SUP_ID');
     if(!empty($RECEIVE_STORE)){
        $infotricountytotalpay_2 = $infotricountytotalpay_2->where('warehouse_store.STORE_TYPE',$RECEIVE_STORE);
      }
      if(!empty($TYPE_CODE)){
        $infotricountytotalpay_2 = $infotricountytotalpay_2->where('supplies.SUP_TYPE_ID',$TYPE_CODE);
      }
      $infotricountytotalpay_2 = $infotricountytotalpay_2->where('warehouse_store.STORE_SUP_ID','<>','637')
     ->where('warehouse_store.STORE_SUP_ID','<>','577')
     ->where('supplies.CONTINUE_PRICE_ID','=','2')
     ->whereBetween('warehouse_request.WAREHOUSE_PAYDAY', [$from2, $to2])
     ->sum('warehouse_store_export_sub.EXPORT_SUB_VALUE');
  
  
        $infotriprovince_2_count = DB::table('warehouse_check_receive_sub')
        ->select('supplies.ID', DB::raw('count(*) as total'))
        ->leftjoin('warehouse_check_receive','warehouse_check_receive.RECEIVE_ID','=','warehouse_check_receive_sub.RECEIVE_ID')
        ->leftjoin('supplies','supplies.ID','warehouse_check_receive_sub.RECEIVE_SUB_CODE');
        if(!empty($RECEIVE_STORE)){
            $infotriprovince_2_count = $infotriprovince_2_count->where('warehouse_check_receive.RECEIVE_STORE',$RECEIVE_STORE);
          }
          if(!empty($TYPE_CODE)){
            $infotriprovince_2_count = $infotriprovince_2_count->where('supplies.SUP_TYPE_ID',$TYPE_CODE);
          }
          $infotriprovince_2_count = $infotriprovince_2_count->where('supplies.ID','<>','637')
        ->where('supplies.ID','<>','577')
        ->where('supplies.CONTINUE_PRICE_ID','=','1')
        ->where('warehouse_check_receive.RECEIVE_CHECK_STATUS','=','1')
        ->where('warehouse_check_receive_sub.RECEIVE_SUB_TYPE','<>','3')
        ->whereBetween('warehouse_check_receive.RECEIVE_CHECK_DATE', [$from2, $to2])
        ->groupBy('supplies.ID')
        ->get();
        $infotriprovince_2 = count($infotriprovince_2_count);
        
        $infotriprovincetotal_2 = DB::table('warehouse_check_receive_sub')
        ->leftjoin('warehouse_check_receive','warehouse_check_receive.RECEIVE_ID','=','warehouse_check_receive_sub.RECEIVE_ID')
        ->leftjoin('supplies','supplies.ID','warehouse_check_receive_sub.RECEIVE_SUB_CODE');
        if(!empty($RECEIVE_STORE)){
            $infotriprovincetotal_2 = $infotriprovincetotal_2->where('warehouse_check_receive.RECEIVE_STORE',$RECEIVE_STORE);
          }
          if(!empty($TYPE_CODE)){
            $infotriprovincetotal_2 = $infotriprovincetotal_2->where('supplies.SUP_TYPE_ID',$TYPE_CODE);
          }
          $infotriprovincetotal_2 = $infotriprovincetotal_2->where('supplies.ID','<>','637')
        ->where('supplies.ID','<>','577')
        ->where('supplies.CONTINUE_PRICE_ID','=','1')
        ->where('warehouse_check_receive.RECEIVE_CHECK_STATUS','=','1')
        ->where('warehouse_check_receive_sub.RECEIVE_SUB_TYPE','<>','3')
        ->whereBetween('warehouse_check_receive.RECEIVE_CHECK_DATE', [$from2, $to2])
        ->sum('warehouse_check_receive_sub.RECEIVE_SUB_VALUE');
  
        //==================มูลค่าการจ่าย
  
       $infotriprovincetotalpay_2 =  DB::table('warehouse_store_export_sub')
       ->leftjoin('warehouse_request','warehouse_request.WAREHOUSE_REQUEST_CODE','=','warehouse_store_export_sub.WAREHOUSE_REQUEST_CODE')
       ->leftjoin('warehouse_store','warehouse_store.STORE_ID','warehouse_store_export_sub.STORE_ID')
       ->leftjoin('supplies','supplies.ID','warehouse_store.STORE_SUP_ID');
       if(!empty($RECEIVE_STORE)){
        $infotriprovincetotalpay_2 = $infotriprovincetotalpay_2->where('warehouse_store.STORE_TYPE',$RECEIVE_STORE);
      }
      if(!empty($TYPE_CODE)){
        $infotriprovincetotalpay_2 = $infotriprovincetotalpay_2->where('supplies.SUP_TYPE_ID',$TYPE_CODE);
      }
      $infotriprovincetotalpay_2 = $infotriprovincetotalpay_2->where('warehouse_store.STORE_SUP_ID','<>','637')
       ->where('warehouse_store.STORE_SUP_ID','<>','577')
       ->where('supplies.CONTINUE_PRICE_ID','=','1')
       ->whereBetween('warehouse_request.WAREHOUSE_PAYDAY', [$from2, $to2])
       ->sum('warehouse_store_export_sub.EXPORT_SUB_VALUE');
  
  
  
        $infotriself_2_count = DB::table('warehouse_check_receive_sub')
        ->select('supplies.ID', DB::raw('count(*) as total'))
        ->leftjoin('warehouse_check_receive','warehouse_check_receive.RECEIVE_ID','=','warehouse_check_receive_sub.RECEIVE_ID')
        ->leftjoin('supplies','supplies.ID','warehouse_check_receive_sub.RECEIVE_SUB_CODE');
        if(!empty($RECEIVE_STORE)){
            $infotriself_2_count = $infotriself_2_count->where('warehouse_check_receive.RECEIVE_STORE',$RECEIVE_STORE);
          }
          if(!empty($TYPE_CODE)){
            $infotriself_2_count = $infotriself_2_count->where('supplies.SUP_TYPE_ID',$TYPE_CODE);
          }
          $infotriself_2_count = $infotriself_2_count->where('supplies.ID','<>','637')
        ->where('supplies.ID','<>','577')
        ->where('supplies.CONTINUE_PRICE_ID','=','3')
        ->where('warehouse_check_receive.RECEIVE_CHECK_STATUS','=','1')
        ->where('warehouse_check_receive_sub.RECEIVE_SUB_TYPE','<>','3')
        ->whereBetween('warehouse_check_receive.RECEIVE_CHECK_DATE', [$from2, $to2])
        ->groupBy('supplies.ID')
        ->get();
        $infotriself_2 = count($infotriself_2_count);
  
        $infotriselftotal_2 = DB::table('warehouse_check_receive_sub')
        ->leftjoin('warehouse_check_receive','warehouse_check_receive.RECEIVE_ID','=','warehouse_check_receive_sub.RECEIVE_ID')
        ->leftjoin('supplies','supplies.ID','warehouse_check_receive_sub.RECEIVE_SUB_CODE');
        if(!empty($RECEIVE_STORE)){
            $infotriselftotal_2 = $infotriselftotal_2->where('warehouse_check_receive.RECEIVE_STORE',$RECEIVE_STORE);
          }
          if(!empty($TYPE_CODE)){
            $infotriselftotal_2 = $infotriselftotal_2->where('supplies.SUP_TYPE_ID',$TYPE_CODE);
          }
          $infotriselftotal_2 = $infotriselftotal_2->where('supplies.ID','<>','637')
        ->where('supplies.ID','<>','577')
        ->where('supplies.CONTINUE_PRICE_ID','=','3')
        ->where('warehouse_check_receive.RECEIVE_CHECK_STATUS','=','1')
        ->where('warehouse_check_receive_sub.RECEIVE_SUB_TYPE','<>','3')
        ->whereBetween('warehouse_check_receive.RECEIVE_CHECK_DATE', [$from2, $to2])
        ->sum('warehouse_check_receive_sub.RECEIVE_SUB_VALUE');
  
                //==================มูลค่าการจ่าย
  

       $infotriselftotalpay_2 =  DB::table('warehouse_store_export_sub')
       ->leftjoin('warehouse_request','warehouse_request.WAREHOUSE_REQUEST_CODE','=','warehouse_store_export_sub.WAREHOUSE_REQUEST_CODE')
       ->leftjoin('warehouse_store','warehouse_store.STORE_ID','warehouse_store_export_sub.STORE_ID')
       ->leftjoin('supplies','supplies.ID','warehouse_store.STORE_SUP_ID');
       if(!empty($RECEIVE_STORE)){
        $infotriselftotalpay_2 = $infotriselftotalpay_2->where('warehouse_store.STORE_TYPE',$RECEIVE_STORE);
      }
      if(!empty($TYPE_CODE)){
        $infotriselftotalpay_2 = $infotriselftotalpay_2->where('supplies.SUP_TYPE_ID',$TYPE_CODE);
      }
      $infotriselftotalpay_2 = $infotriselftotalpay_2->where('warehouse_store.STORE_SUP_ID','<>','637')
       ->where('warehouse_store.STORE_SUP_ID','<>','577')
       ->where('supplies.CONTINUE_PRICE_ID','=','3')
       ->whereBetween('warehouse_request.WAREHOUSE_PAYDAY', [$from2, $to2])
       ->sum('warehouse_store_export_sub.EXPORT_SUB_VALUE');
  
  
  
        $infonotremark_2_count = DB::table('warehouse_check_receive_sub')
        ->select('supplies.ID', DB::raw('count(*) as total'))
        ->leftjoin('warehouse_check_receive','warehouse_check_receive.RECEIVE_ID','=','warehouse_check_receive_sub.RECEIVE_ID')
        ->leftjoin('supplies','supplies.ID','warehouse_check_receive_sub.RECEIVE_SUB_CODE');
        if(!empty($RECEIVE_STORE)){
            $infonotremark_2_count = $infonotremark_2_count->where('warehouse_check_receive.RECEIVE_STORE',$RECEIVE_STORE);
          }
          if(!empty($TYPE_CODE)){
            $infonotremark_2_count = $infonotremark_2_count->where('supplies.SUP_TYPE_ID',$TYPE_CODE);
          }
          $infonotremark_2_count = $infonotremark_2_count->where('supplies.ID','<>','637')
        ->where('supplies.ID','<>','577')
        ->where('supplies.CONTINUE_PRICE_ID','=',null)
        ->where('warehouse_check_receive.RECEIVE_CHECK_STATUS','=','1')
        ->where('warehouse_check_receive_sub.RECEIVE_SUB_TYPE','<>','3')
        ->whereBetween('warehouse_check_receive.RECEIVE_CHECK_DATE', [$from2, $to2])
        ->groupBy('supplies.ID')
        ->get();
        $infonotremark_2 = count($infonotremark_2_count);
        
      
  
        $infonotremarktotal_2 = DB::table('warehouse_check_receive_sub')
        ->leftjoin('warehouse_check_receive','warehouse_check_receive.RECEIVE_ID','=','warehouse_check_receive_sub.RECEIVE_ID')
        ->leftjoin('supplies','supplies.ID','warehouse_check_receive_sub.RECEIVE_SUB_CODE');
        if(!empty($RECEIVE_STORE)){
            $infonotremarktotal_2 = $infonotremarktotal_2->where('warehouse_check_receive.RECEIVE_STORE',$RECEIVE_STORE);
          }
          if(!empty($TYPE_CODE)){
            $infonotremarktotal_2 = $infonotremarktotal_2->where('supplies.SUP_TYPE_ID',$TYPE_CODE);
          }
          $infonotremarktotal_2 = $infonotremarktotal_2->where('supplies.ID','<>','637')
        ->where('supplies.ID','<>','577')
        ->where('supplies.CONTINUE_PRICE_ID','=',null)
        ->where('warehouse_check_receive.RECEIVE_CHECK_STATUS','=','1')
        ->where('warehouse_check_receive_sub.RECEIVE_SUB_TYPE','<>','3')
        ->whereBetween('warehouse_check_receive.RECEIVE_CHECK_DATE', [$from2, $to2])
        ->sum('warehouse_check_receive_sub.RECEIVE_SUB_VALUE');
  
                        //==================มูลค่าการจ่าย
  

       $infonotremarktotalpay_2 = DB::table('warehouse_store_export_sub')
       ->leftjoin('warehouse_request','warehouse_request.WAREHOUSE_REQUEST_CODE','=','warehouse_store_export_sub.WAREHOUSE_REQUEST_CODE')
       ->leftjoin('warehouse_store','warehouse_store.STORE_ID','warehouse_store_export_sub.STORE_ID')
       ->leftjoin('supplies','supplies.ID','warehouse_store.STORE_SUP_ID');
       if(!empty($RECEIVE_STORE)){
        $infonotremarktotalpay_2 = $infonotremarktotalpay_2->where('warehouse_store.STORE_TYPE',$RECEIVE_STORE);
      }
      if(!empty($TYPE_CODE)){
        $infonotremarktotalpay_2 = $infonotremarktotalpay_2->where('supplies.SUP_TYPE_ID',$TYPE_CODE);
      }
      $infonotremarktotalpay_2 = $infonotremarktotalpay_2->where('warehouse_store.STORE_SUP_ID','<>','637')
       ->where('warehouse_store.STORE_SUP_ID','<>','577')
       ->where('supplies.CONTINUE_PRICE_ID','=',null)
       ->whereBetween('warehouse_request.WAREHOUSE_PAYDAY', [$from2, $to2])
       ->sum('warehouse_store_export_sub.EXPORT_SUB_VALUE');
     
      
  
        $infotribonus_2_count = DB::table('warehouse_check_receive_sub')
        ->select('supplies.ID', DB::raw('count(*) as total'))
        ->leftjoin('warehouse_check_receive','warehouse_check_receive.RECEIVE_ID','=','warehouse_check_receive_sub.RECEIVE_ID')
        ->leftjoin('supplies','supplies.ID','warehouse_check_receive_sub.RECEIVE_SUB_CODE');
        if(!empty($RECEIVE_STORE)){
            $infotribonus_2_count = $infotribonus_2_count->where('warehouse_check_receive.RECEIVE_STORE',$RECEIVE_STORE);
          }
          if(!empty($TYPE_CODE)){
            $infotribonus_2_count = $infotribonus_2_count->where('supplies.SUP_TYPE_ID',$TYPE_CODE);
          }
          $infotribonus_2_count = $infotribonus_2_count->where('supplies.ID','<>','637')
        ->where('supplies.ID','<>','577')
        ->where('warehouse_check_receive.RECEIVE_CHECK_STATUS','=','1')
        ->where('warehouse_check_receive_sub.RECEIVE_SUB_TYPE','=','3')
        ->whereBetween('warehouse_check_receive.RECEIVE_CHECK_DATE', [$from2, $to2])
        ->groupBy('supplies.ID')
        ->get();
        $infotribonus_2 = count($infotribonus_2_count);
  
       
  
        $infotribonustotal_2 = DB::table('warehouse_check_receive_sub')
        ->leftjoin('warehouse_check_receive','warehouse_check_receive.RECEIVE_ID','=','warehouse_check_receive_sub.RECEIVE_ID')
        ->leftjoin('supplies','supplies.ID','warehouse_check_receive_sub.RECEIVE_SUB_CODE');
        if(!empty($RECEIVE_STORE)){
            $infotribonustotal_2 = $infotribonustotal_2->where('warehouse_check_receive.RECEIVE_STORE',$RECEIVE_STORE);
          }
          if(!empty($TYPE_CODE)){
            $infotribonustotal_2 = $infotribonustotal_2->where('supplies.SUP_TYPE_ID',$TYPE_CODE);
          }
          $infotribonustotal_2 = $infotribonustotal_2->where('supplies.ID','<>','637')
        ->where('supplies.ID','<>','577')
        ->where('warehouse_check_receive.RECEIVE_CHECK_STATUS','=','1')
        ->where('warehouse_check_receive_sub.RECEIVE_SUB_TYPE','=','3')
        ->whereBetween('warehouse_check_receive.RECEIVE_CHECK_DATE', [$from2, $to2])
        ->sum('warehouse_check_receive_sub.RECEIVE_SUB_VALUE');
  
  
            //==================มูลค่าการจ่าย
  
       $infotribonustotalpay_2 = DB::table('warehouse_check_receive_sub')
       ->leftjoin('warehouse_check_receive','warehouse_check_receive.RECEIVE_ID','=','warehouse_check_receive_sub.RECEIVE_ID')
       ->leftjoin('supplies','supplies.ID','warehouse_check_receive_sub.RECEIVE_SUB_CODE')
       ->leftjoin('warehouse_store_export_sub','supplies.ID','warehouse_store_export_sub.RECEIVE_SUB_ID');
       if(!empty($RECEIVE_STORE)){
        $infotribonustotalpay_2 = $infotribonustotalpay_2->where('warehouse_check_receive.RECEIVE_STORE',$RECEIVE_STORE);
      }
      if(!empty($TYPE_CODE)){
        $infotribonustotalpay_2 = $infotribonustotalpay_2->where('supplies.SUP_TYPE_ID',$TYPE_CODE);
      }
      $infotribonustotalpay_2 = $infotribonustotalpay_2->where('supplies.ID','<>','637')
       ->where('supplies.ID','<>','577')
       ->where('warehouse_check_receive.RECEIVE_CHECK_STATUS','=','1')
       ->where('warehouse_check_receive_sub.RECEIVE_SUB_TYPE','=','3')
       ->whereBetween('warehouse_store_export_sub.created_at', [$from2, $to2])
       ->sum('EXPORT_SUB_VALUE');
  
  
  
       
                        //==================มูลค่าการจ่ายรพสต.
  
                        $infohcenter_2_count = DB::table('warehouse_check_receive_sub')
                        ->select('supplies.ID', DB::raw('count(*) as total'))
                        ->leftjoin('warehouse_check_receive','warehouse_check_receive.RECEIVE_ID','=','warehouse_check_receive_sub.RECEIVE_ID')
                        ->leftjoin('supplies','supplies.ID','warehouse_check_receive_sub.RECEIVE_SUB_CODE')
                        ->leftjoin('warehouse_store_export_sub','supplies.ID','warehouse_store_export_sub.RECEIVE_SUB_ID')
                        ->leftjoin('warehouse_request','warehouse_request.WAREHOUSE_REQUEST_CODE','warehouse_store_export_sub.WAREHOUSE_REQUEST_CODE');
                        if(!empty($RECEIVE_STORE)){
                            $infohcenter_2_count = $infohcenter_2_count->where('warehouse_check_receive.RECEIVE_STORE',$RECEIVE_STORE);
                          }
                          if(!empty($TYPE_CODE)){
                            $infohcenter_2_count = $infohcenter_2_count->where('supplies.SUP_TYPE_ID',$TYPE_CODE);
                          }
                          $infohcenter_2_count = $infohcenter_2_count->where('supplies.ID','<>','637')
                        ->where('supplies.ID','<>','577')
                         ->where('warehouse_request.WAREHOUSE_SMALLHOS','!=',null)
                        ->whereBetween('warehouse_store_export_sub.created_at', [$from2, $to2])
                        ->groupBy('supplies.ID')
                        ->get();
                        $infohcenter_2 = count($infohcenter_2_count);
  
                        $infohcentertotalpay_2 = DB::table('warehouse_check_receive_sub')
                        ->leftjoin('warehouse_check_receive','warehouse_check_receive.RECEIVE_ID','=','warehouse_check_receive_sub.RECEIVE_ID')
                        ->leftjoin('supplies','supplies.ID','warehouse_check_receive_sub.RECEIVE_SUB_CODE')
                        ->leftjoin('warehouse_store_export_sub','supplies.ID','warehouse_store_export_sub.RECEIVE_SUB_ID')
                        ->leftjoin('warehouse_request','warehouse_request.WAREHOUSE_REQUEST_CODE','warehouse_store_export_sub.WAREHOUSE_REQUEST_CODE');
                        if(!empty($RECEIVE_STORE)){
                            $infohcentertotalpay_2 = $infohcentertotalpay_2->where('warehouse_check_receive.RECEIVE_STORE',$RECEIVE_STORE);
                          }
                          if(!empty($TYPE_CODE)){
                            $infohcentertotalpay_2 = $infohcentertotalpay_2->where('supplies.SUP_TYPE_ID',$TYPE_CODE);
                          }
                            $infohcentertotalpay_2 = $infohcentertotalpay_2->where('warehouse_check_receive.RECEIVE_STORE','=','3')
                        ->where('supplies.SUP_TYPE_ID','=','7')
                        ->where('supplies.ID','<>','637')
                        ->where('supplies.ID','<>','577')
                         ->where('warehouse_request.WAREHOUSE_SMALLHOS','!=',null)
                        ->whereBetween('warehouse_store_export_sub.created_at', [$from2, $to2])
                        ->sum('EXPORT_SUB_VALUE');

          //==================================ไตรมาส 3
      $from3 = date('2022-04-01');
      $to3 = date('2022-06-31');
      $infotriall_3_count = DB::table('warehouse_check_receive_sub')
      ->select('supplies.ID', DB::raw('count(*) as total'))
      ->leftjoin('warehouse_check_receive','warehouse_check_receive.RECEIVE_ID','=','warehouse_check_receive_sub.RECEIVE_ID')
      ->leftjoin('supplies','supplies.ID','warehouse_check_receive_sub.RECEIVE_SUB_CODE'); 
      if(!empty($RECEIVE_STORE)){
        $infotriall_3_count = $infotriall_3_count->where('warehouse_check_receive.RECEIVE_STORE',$RECEIVE_STORE);
      }
      if(!empty($TYPE_CODE)){
        $infotriall_3_count = $infotriall_3_count->where('supplies.SUP_TYPE_ID',$TYPE_CODE);
      }
      $infotriall_3_count = $infotriall_3_count->where('supplies.ID','<>','637')
      ->where('supplies.ID','<>','577')
      ->where('warehouse_check_receive.RECEIVE_CHECK_STATUS','=','1')
      ->whereBetween('warehouse_check_receive.RECEIVE_CHECK_DATE', [$from3, $to3])
      ->groupBy('supplies.ID')
      ->get();
      $infotriall_3 = count($infotriall_3_count);
  

      $infotrialltotal_3 = DB::table('warehouse_check_receive_sub')
      ->leftjoin('warehouse_check_receive','warehouse_check_receive.RECEIVE_ID','=','warehouse_check_receive_sub.RECEIVE_ID')
      ->leftjoin('supplies','supplies.ID','warehouse_check_receive_sub.RECEIVE_SUB_CODE');
      if(!empty($RECEIVE_STORE)){
        $infotrialltotal_3 = $infotrialltotal_3->where('warehouse_check_receive.RECEIVE_STORE',$RECEIVE_STORE);
      }
      if(!empty($TYPE_CODE)){
        $infotrialltotal_3 = $infotrialltotal_3->where('supplies.SUP_TYPE_ID',$TYPE_CODE);
      }
      $infotrialltotal_3 = $infotrialltotal_3->where('supplies.ID','<>','637')
      ->where('supplies.ID','<>','577')
      ->where('warehouse_check_receive.RECEIVE_CHECK_STATUS','=','1')
      ->whereBetween('warehouse_check_receive.RECEIVE_CHECK_DATE', [$from3, $to3])
      ->sum('warehouse_check_receive_sub.RECEIVE_SUB_VALUE');

     //==================มูลค่าการจ่าย



     $infotrialltotalpay_3 = DB::table('warehouse_store_export_sub')
     ->leftjoin('warehouse_request','warehouse_request.WAREHOUSE_REQUEST_CODE','=','warehouse_store_export_sub.WAREHOUSE_REQUEST_CODE')
     ->leftjoin('warehouse_store','warehouse_store.STORE_ID','warehouse_store_export_sub.STORE_ID')
     ->leftjoin('supplies','supplies.ID','warehouse_store.STORE_SUP_ID');
     if(!empty($RECEIVE_STORE)){
        $infotrialltotalpay_3 = $infotrialltotalpay_3->where('warehouse_store.STORE_TYPE',$RECEIVE_STORE);
      }
      if(!empty($TYPE_CODE)){
        $infotrialltotalpay_3 = $infotrialltotalpay_3->where('supplies.SUP_TYPE_ID',$TYPE_CODE);
      }
      $infotrialltotalpay_3 = $infotrialltotalpay_3->where('warehouse_store.STORE_SUP_ID','<>','637')
     ->where('warehouse_store.STORE_SUP_ID','<>','577')
     ->whereBetween('warehouse_request.WAREHOUSE_PAYDAY', [$from3, $to3])
     ->sum('warehouse_store_export_sub.EXPORT_SUB_VALUE');




      
      $infotricounty_3_count = DB::table('warehouse_check_receive_sub')
      ->select('supplies.ID', DB::raw('count(*) as total'))
      ->leftjoin('warehouse_check_receive','warehouse_check_receive.RECEIVE_ID','=','warehouse_check_receive_sub.RECEIVE_ID')
      ->leftjoin('supplies','supplies.ID','warehouse_check_receive_sub.RECEIVE_SUB_CODE');
      if(!empty($RECEIVE_STORE)){
        $infotricounty_3_count = $infotricounty_3_count->where('warehouse_check_receive.RECEIVE_STORE',$RECEIVE_STORE);
      }
      if(!empty($TYPE_CODE)){
        $infotricounty_3_count = $infotricounty_3_count->where('supplies.SUP_TYPE_ID',$TYPE_CODE);
      }
      $infotricounty_3_count = $infotricounty_3_count->where('supplies.ID','<>','637')
      ->where('supplies.ID','<>','577')
      ->where('supplies.CONTINUE_PRICE_ID','=','2')
      ->where('warehouse_check_receive.RECEIVE_CHECK_STATUS','=','1')
      ->where('warehouse_check_receive_sub.RECEIVE_SUB_TYPE','<>','3')
      ->whereBetween('warehouse_check_receive.RECEIVE_CHECK_DATE', [$from3, $to3])
      ->groupBy('supplies.ID')
      ->get();
      $infotricounty_3 = count($infotricounty_3_count);

      $infotricountytotal_3 = DB::table('warehouse_check_receive_sub')
      ->leftjoin('warehouse_check_receive','warehouse_check_receive.RECEIVE_ID','=','warehouse_check_receive_sub.RECEIVE_ID')
      ->leftjoin('supplies','supplies.ID','warehouse_check_receive_sub.RECEIVE_SUB_CODE');
      if(!empty($RECEIVE_STORE)){
        $infotricountytotal_3 = $infotricountytotal_3->where('warehouse_check_receive.RECEIVE_STORE',$RECEIVE_STORE);
      }
      if(!empty($TYPE_CODE)){
        $infotricountytotal_3 = $infotricountytotal_3->where('supplies.SUP_TYPE_ID',$TYPE_CODE);
      }
      $infotricountytotal_3 = $infotricountytotal_3->where('supplies.ID','<>','637')
      ->where('supplies.ID','<>','577')
      ->where('supplies.CONTINUE_PRICE_ID','=','2')
      ->where('warehouse_check_receive.RECEIVE_CHECK_STATUS','=','1')
      ->where('warehouse_check_receive_sub.RECEIVE_SUB_TYPE','<>','3')
      ->whereBetween('warehouse_check_receive.RECEIVE_CHECK_DATE', [$from3, $to3])
      ->sum('warehouse_check_receive_sub.RECEIVE_SUB_VALUE');


             //==================มูลค่าการจ่าย

     $infotricountytotalpay_3 =  DB::table('warehouse_store_export_sub')
     ->leftjoin('warehouse_request','warehouse_request.WAREHOUSE_REQUEST_CODE','=','warehouse_store_export_sub.WAREHOUSE_REQUEST_CODE')
     ->leftjoin('warehouse_store','warehouse_store.STORE_ID','warehouse_store_export_sub.STORE_ID')
     ->leftjoin('supplies','supplies.ID','warehouse_store.STORE_SUP_ID');
     if(!empty($RECEIVE_STORE)){
        $infotricountytotalpay_3 = $infotricountytotalpay_3->where('warehouse_store.STORE_TYPE',$RECEIVE_STORE);
      }
      if(!empty($TYPE_CODE)){
        $infotricountytotalpay_3 = $infotricountytotalpay_3->where('supplies.SUP_TYPE_ID',$TYPE_CODE);
      }
      $infotricountytotalpay_3 = $infotricountytotalpay_3->where('warehouse_store.STORE_SUP_ID','<>','637')
     ->where('warehouse_store.STORE_SUP_ID','<>','577')
     ->where('supplies.CONTINUE_PRICE_ID','=','2')
     ->whereBetween('warehouse_request.WAREHOUSE_PAYDAY', [$from3, $to3])
     ->sum('warehouse_store_export_sub.EXPORT_SUB_VALUE');


      $infotriprovince_3_count = DB::table('warehouse_check_receive_sub')
      ->select('supplies.ID', DB::raw('count(*) as total'))
      ->leftjoin('warehouse_check_receive','warehouse_check_receive.RECEIVE_ID','=','warehouse_check_receive_sub.RECEIVE_ID')
      ->leftjoin('supplies','supplies.ID','warehouse_check_receive_sub.RECEIVE_SUB_CODE');
      if(!empty($RECEIVE_STORE)){
        $infotriprovince_3_count = $infotriprovince_3_count->where('warehouse_check_receive.RECEIVE_STORE',$RECEIVE_STORE);
      }
      if(!empty($TYPE_CODE)){
        $infotriprovince_3_count = $infotriprovince_3_count->where('supplies.SUP_TYPE_ID',$TYPE_CODE);
      }
      $infotriprovince_3_count = $infotriprovince_3_count->where('supplies.ID','<>','637')
      ->where('supplies.ID','<>','577')
      ->where('supplies.CONTINUE_PRICE_ID','=','1')
      ->where('warehouse_check_receive.RECEIVE_CHECK_STATUS','=','1')
      ->where('warehouse_check_receive_sub.RECEIVE_SUB_TYPE','<>','3')
      ->whereBetween('warehouse_check_receive.RECEIVE_CHECK_DATE', [$from3, $to3])
      ->groupBy('supplies.ID')
      ->get();
      $infotriprovince_3 = count($infotriprovince_3_count);
      
      $infotriprovincetotal_3 = DB::table('warehouse_check_receive_sub')
      ->leftjoin('warehouse_check_receive','warehouse_check_receive.RECEIVE_ID','=','warehouse_check_receive_sub.RECEIVE_ID')
      ->leftjoin('supplies','supplies.ID','warehouse_check_receive_sub.RECEIVE_SUB_CODE');
      if(!empty($RECEIVE_STORE)){
        $infotriprovincetotal_3 = $infotriprovincetotal_3->where('warehouse_check_receive.RECEIVE_STORE',$RECEIVE_STORE);
      }
      if(!empty($TYPE_CODE)){
        $infotriprovincetotal_3 = $infotriprovincetotal_3->where('supplies.SUP_TYPE_ID',$TYPE_CODE);
      }
      $infotriprovincetotal_3 = $infotriprovincetotal_3->where('supplies.ID','<>','637')
      ->where('supplies.ID','<>','577')
      ->where('supplies.CONTINUE_PRICE_ID','=','1')
      ->where('warehouse_check_receive.RECEIVE_CHECK_STATUS','=','1')
      ->where('warehouse_check_receive_sub.RECEIVE_SUB_TYPE','<>','3')
      ->whereBetween('warehouse_check_receive.RECEIVE_CHECK_DATE', [$from3, $to3])
      ->sum('warehouse_check_receive_sub.RECEIVE_SUB_VALUE');

      //==================มูลค่าการจ่าย


     $infotriprovincetotalpay_3 =  DB::table('warehouse_store_export_sub')
     ->leftjoin('warehouse_request','warehouse_request.WAREHOUSE_REQUEST_CODE','=','warehouse_store_export_sub.WAREHOUSE_REQUEST_CODE')
     ->leftjoin('warehouse_store','warehouse_store.STORE_ID','warehouse_store_export_sub.STORE_ID')
     ->leftjoin('supplies','supplies.ID','warehouse_store.STORE_SUP_ID');
     if(!empty($RECEIVE_STORE)){
        $infotriprovincetotalpay_3 = $infotriprovincetotalpay_3->where('warehouse_store.STORE_TYPE',$RECEIVE_STORE);
      }
      if(!empty($TYPE_CODE)){
        $infotriprovincetotalpay_3 = $infotriprovincetotalpay_3->where('supplies.SUP_TYPE_ID',$TYPE_CODE);
      }
        $infotriprovincetotalpay_3 = $infotriprovincetotalpay_3->where('warehouse_store.STORE_SUP_ID','<>','637')
     ->where('warehouse_store.STORE_SUP_ID','<>','577')
     ->where('supplies.CONTINUE_PRICE_ID','=','1')
     ->whereBetween('warehouse_request.WAREHOUSE_PAYDAY', [$from3, $to3])
     ->sum('warehouse_store_export_sub.EXPORT_SUB_VALUE');



      $infotriself_3_count = DB::table('warehouse_check_receive_sub')
      ->select('supplies.ID', DB::raw('count(*) as total'))
      ->leftjoin('warehouse_check_receive','warehouse_check_receive.RECEIVE_ID','=','warehouse_check_receive_sub.RECEIVE_ID')
      ->leftjoin('supplies','supplies.ID','warehouse_check_receive_sub.RECEIVE_SUB_CODE');
      if(!empty($RECEIVE_STORE)){
        $infotriself_3_count = $infotriself_3_count->where('warehouse_check_receive.RECEIVE_STORE',$RECEIVE_STORE);
      }
      if(!empty($TYPE_CODE)){
        $infotriself_3_count = $infotriself_3_count->where('supplies.SUP_TYPE_ID',$TYPE_CODE);
      }
      $infotriself_3_count = $infotriself_3_count->where('supplies.ID','<>','637')
      ->where('supplies.ID','<>','577')
      ->where('supplies.CONTINUE_PRICE_ID','=','3')
      ->where('warehouse_check_receive.RECEIVE_CHECK_STATUS','=','1')
      ->where('warehouse_check_receive_sub.RECEIVE_SUB_TYPE','<>','3')
      ->whereBetween('warehouse_check_receive.RECEIVE_CHECK_DATE', [$from3, $to3])
      ->groupBy('supplies.ID')
      ->get();
      $infotriself_3 = count($infotriself_3_count);

      $infotriselftotal_3 = DB::table('warehouse_check_receive_sub')
      ->leftjoin('warehouse_check_receive','warehouse_check_receive.RECEIVE_ID','=','warehouse_check_receive_sub.RECEIVE_ID')
      ->leftjoin('supplies','supplies.ID','warehouse_check_receive_sub.RECEIVE_SUB_CODE');
      if(!empty($RECEIVE_STORE)){
        $infotriselftotal_3 = $infotriselftotal_3->where('warehouse_check_receive.RECEIVE_STORE',$RECEIVE_STORE);
      }
      if(!empty($TYPE_CODE)){
        $infotriselftotal_3 = $infotriselftotal_3->where('supplies.SUP_TYPE_ID',$TYPE_CODE);
      }
      $infotriselftotal_3 = $infotriselftotal_3->where('supplies.ID','<>','637')
      ->where('supplies.ID','<>','577')
      ->where('supplies.CONTINUE_PRICE_ID','=','3')
      ->where('warehouse_check_receive.RECEIVE_CHECK_STATUS','=','1')
      ->where('warehouse_check_receive_sub.RECEIVE_SUB_TYPE','<>','3')
      ->whereBetween('warehouse_check_receive.RECEIVE_CHECK_DATE', [$from3, $to3])
      ->sum('warehouse_check_receive_sub.RECEIVE_SUB_VALUE');

              //==================มูลค่าการจ่าย

 

     $infotriselftotalpay_3 =  DB::table('warehouse_store_export_sub')
     ->leftjoin('warehouse_request','warehouse_request.WAREHOUSE_REQUEST_CODE','=','warehouse_store_export_sub.WAREHOUSE_REQUEST_CODE')
     ->leftjoin('warehouse_store','warehouse_store.STORE_ID','warehouse_store_export_sub.STORE_ID')
     ->leftjoin('supplies','supplies.ID','warehouse_store.STORE_SUP_ID');
     if(!empty($RECEIVE_STORE)){
        $infotriselftotalpay_3 = $infotriselftotalpay_3->where('warehouse_store.STORE_TYPE',$RECEIVE_STORE);
      }
      if(!empty($TYPE_CODE)){
        $infotriselftotalpay_3 = $infotriselftotalpay_3->where('supplies.SUP_TYPE_ID',$TYPE_CODE);
      }
      $infotriselftotalpay_3 = $infotriselftotalpay_3->where('warehouse_store.STORE_SUP_ID','<>','637')
     ->where('warehouse_store.STORE_SUP_ID','<>','577')
     ->where('supplies.CONTINUE_PRICE_ID','=','3')
     ->whereBetween('warehouse_request.WAREHOUSE_PAYDAY', [$from3, $to3])
     ->sum('warehouse_store_export_sub.EXPORT_SUB_VALUE');



      $infonotremark_3_count = DB::table('warehouse_check_receive_sub')
      ->select('supplies.ID', DB::raw('count(*) as total'))
      ->leftjoin('warehouse_check_receive','warehouse_check_receive.RECEIVE_ID','=','warehouse_check_receive_sub.RECEIVE_ID')
      ->leftjoin('supplies','supplies.ID','warehouse_check_receive_sub.RECEIVE_SUB_CODE');
      if(!empty($RECEIVE_STORE)){
        $infonotremark_3_count = $infonotremark_3_count->where('warehouse_check_receive.RECEIVE_STORE',$RECEIVE_STORE);
      }
      if(!empty($TYPE_CODE)){
        $infonotremark_3_count = $infonotremark_3_count->where('supplies.SUP_TYPE_ID',$TYPE_CODE);
      }
      $infonotremark_3_count = $infonotremark_3_count->where('supplies.ID','<>','637')
      ->where('supplies.ID','<>','577')
      ->where('supplies.CONTINUE_PRICE_ID','=',null)
      ->where('warehouse_check_receive.RECEIVE_CHECK_STATUS','=','1')
      ->where('warehouse_check_receive_sub.RECEIVE_SUB_TYPE','<>','3')
      ->whereBetween('warehouse_check_receive.RECEIVE_CHECK_DATE', [$from3, $to3])
      ->groupBy('supplies.ID')
      ->get();
      $infonotremark_3 = count($infonotremark_3_count);
      
    

      $infonotremarktotal_3 = DB::table('warehouse_check_receive_sub')
      ->leftjoin('warehouse_check_receive','warehouse_check_receive.RECEIVE_ID','=','warehouse_check_receive_sub.RECEIVE_ID')
      ->leftjoin('supplies','supplies.ID','warehouse_check_receive_sub.RECEIVE_SUB_CODE');
      if(!empty($RECEIVE_STORE)){
        $infonotremarktotal_3 = $infonotremarktotal_3->where('warehouse_check_receive.RECEIVE_STORE',$RECEIVE_STORE);
      }
      if(!empty($TYPE_CODE)){
        $infonotremarktotal_3 = $infonotremarktotal_3->where('supplies.SUP_TYPE_ID',$TYPE_CODE);
      }
      $infonotremarktotal_3 = $infonotremarktotal_3->where('supplies.ID','<>','637')
      ->where('supplies.ID','<>','577')
      ->where('supplies.CONTINUE_PRICE_ID','=',null)
      ->where('warehouse_check_receive.RECEIVE_CHECK_STATUS','=','1')
      ->where('warehouse_check_receive_sub.RECEIVE_SUB_TYPE','<>','3')
      ->whereBetween('warehouse_check_receive.RECEIVE_CHECK_DATE', [$from3, $to3])
      ->sum('warehouse_check_receive_sub.RECEIVE_SUB_VALUE');

                      //==================มูลค่าการจ่าย


     $infonotremarktotalpay_3 = DB::table('warehouse_store_export_sub')
     ->leftjoin('warehouse_request','warehouse_request.WAREHOUSE_REQUEST_CODE','=','warehouse_store_export_sub.WAREHOUSE_REQUEST_CODE')
     ->leftjoin('warehouse_store','warehouse_store.STORE_ID','warehouse_store_export_sub.STORE_ID')
     ->leftjoin('supplies','supplies.ID','warehouse_store.STORE_SUP_ID');
     if(!empty($RECEIVE_STORE)){
        $infonotremarktotalpay_3 = $infonotremarktotalpay_3->where('warehouse_store.STORE_TYPE',$RECEIVE_STORE);
      }
      if(!empty($TYPE_CODE)){
        $infonotremarktotalpay_3 = $infonotremarktotalpay_3->where('supplies.SUP_TYPE_ID',$TYPE_CODE);
      }
      $infonotremarktotalpay_3 = $infonotremarktotalpay_3->where('warehouse_store.STORE_SUP_ID','<>','637')
     ->where('warehouse_store.STORE_SUP_ID','<>','577')
     ->where('supplies.CONTINUE_PRICE_ID','=',null)
     ->whereBetween('warehouse_request.WAREHOUSE_PAYDAY', [$from3, $to3])
     ->sum('warehouse_store_export_sub.EXPORT_SUB_VALUE');
   
    

      $infotribonus_3_count = DB::table('warehouse_check_receive_sub')
      ->select('supplies.ID', DB::raw('count(*) as total'))
      ->leftjoin('warehouse_check_receive','warehouse_check_receive.RECEIVE_ID','=','warehouse_check_receive_sub.RECEIVE_ID')
      ->leftjoin('supplies','supplies.ID','warehouse_check_receive_sub.RECEIVE_SUB_CODE');
      if(!empty($RECEIVE_STORE)){
        $infotribonus_3_count = $infotribonus_3_count->where('warehouse_check_receive.RECEIVE_STORE',$RECEIVE_STORE);
      }
      if(!empty($TYPE_CODE)){
        $infotribonus_3_count = $infotribonus_3_count->where('supplies.SUP_TYPE_ID',$TYPE_CODE);
      }
      $infotribonus_3_count = $infotribonus_3_count->where('supplies.ID','<>','637')
      ->where('supplies.ID','<>','577')
      ->where('warehouse_check_receive.RECEIVE_CHECK_STATUS','=','1')
      ->where('warehouse_check_receive_sub.RECEIVE_SUB_TYPE','=','3')
      ->whereBetween('warehouse_check_receive.RECEIVE_CHECK_DATE', [$from3, $to3])
      ->groupBy('supplies.ID')
      ->get();
      $infotribonus_3 = count($infotribonus_3_count);

     

      $infotribonustotal_3 = DB::table('warehouse_check_receive_sub')
      ->leftjoin('warehouse_check_receive','warehouse_check_receive.RECEIVE_ID','=','warehouse_check_receive_sub.RECEIVE_ID')
      ->leftjoin('supplies','supplies.ID','warehouse_check_receive_sub.RECEIVE_SUB_CODE');
      if(!empty($RECEIVE_STORE)){
        $infotribonustotal_3 = $infotribonustotal_3->where('warehouse_check_receive.RECEIVE_STORE',$RECEIVE_STORE);
      }
      if(!empty($TYPE_CODE)){
        $infotribonustotal_3 = $infotribonustotal_3->where('supplies.SUP_TYPE_ID',$TYPE_CODE);
      }
      $infotribonustotal_3 = $infotribonustotal_3->where('supplies.ID','<>','637')
      ->where('supplies.ID','<>','577')
      ->where('warehouse_check_receive.RECEIVE_CHECK_STATUS','=','1')
      ->where('warehouse_check_receive_sub.RECEIVE_SUB_TYPE','=','3')
      ->whereBetween('warehouse_check_receive.RECEIVE_CHECK_DATE', [$from3, $to3])
      ->sum('warehouse_check_receive_sub.RECEIVE_SUB_VALUE');


          //==================มูลค่าการจ่าย

     $infotribonustotalpay_3 = DB::table('warehouse_check_receive_sub')
     ->leftjoin('warehouse_check_receive','warehouse_check_receive.RECEIVE_ID','=','warehouse_check_receive_sub.RECEIVE_ID')
     ->leftjoin('supplies','supplies.ID','warehouse_check_receive_sub.RECEIVE_SUB_CODE')
     ->leftjoin('warehouse_store_export_sub','supplies.ID','warehouse_store_export_sub.RECEIVE_SUB_ID');
     if(!empty($RECEIVE_STORE)){
        $infotribonustotalpay_3 = $infotribonustotalpay_3->where('warehouse_check_receive.RECEIVE_STORE',$RECEIVE_STORE);
      }
      if(!empty($TYPE_CODE)){
        $infotribonustotalpay_3 = $infotribonustotalpay_3->where('supplies.SUP_TYPE_ID',$TYPE_CODE);
      }
      $infotribonustotalpay_3 = $infotribonustotalpay_3->where('supplies.ID','<>','637')
     ->where('supplies.ID','<>','577')
     ->where('warehouse_check_receive.RECEIVE_CHECK_STATUS','=','1')
     ->where('warehouse_check_receive_sub.RECEIVE_SUB_TYPE','=','3')
     ->whereBetween('warehouse_store_export_sub.created_at', [$from3, $to3])
     ->sum('EXPORT_SUB_VALUE');



     
                      //==================มูลค่าการจ่ายรพสต.

                      $infohcenter_3_count = DB::table('warehouse_check_receive_sub')
                      ->select('supplies.ID', DB::raw('count(*) as total'))
                      ->leftjoin('warehouse_check_receive','warehouse_check_receive.RECEIVE_ID','=','warehouse_check_receive_sub.RECEIVE_ID')
                      ->leftjoin('supplies','supplies.ID','warehouse_check_receive_sub.RECEIVE_SUB_CODE')
                      ->leftjoin('warehouse_store_export_sub','supplies.ID','warehouse_store_export_sub.RECEIVE_SUB_ID')
                      ->leftjoin('warehouse_request','warehouse_request.WAREHOUSE_REQUEST_CODE','warehouse_store_export_sub.WAREHOUSE_REQUEST_CODE');
                      if(!empty($RECEIVE_STORE)){
                        $infohcenter_3_count = $infohcenter_3_count->where('warehouse_check_receive.RECEIVE_STORE',$RECEIVE_STORE);
                      }
                      if(!empty($TYPE_CODE)){
                        $infohcenter_3_count = $infohcenter_3_count->where('supplies.SUP_TYPE_ID',$TYPE_CODE);
                      }
                      $infohcenter_3_count = $infohcenter_3_count->where('supplies.ID','<>','637')
                      ->where('supplies.ID','<>','577')
                       ->where('warehouse_request.WAREHOUSE_SMALLHOS','!=',null)
                      ->whereBetween('warehouse_store_export_sub.created_at', [$from3, $to3])
                      ->groupBy('supplies.ID')
                      ->get();
                      $infohcenter_3 = count($infohcenter_3_count);

                      $infohcentertotalpay_3 = DB::table('warehouse_check_receive_sub')
                      ->leftjoin('warehouse_check_receive','warehouse_check_receive.RECEIVE_ID','=','warehouse_check_receive_sub.RECEIVE_ID')
                      ->leftjoin('supplies','supplies.ID','warehouse_check_receive_sub.RECEIVE_SUB_CODE')
                      ->leftjoin('warehouse_store_export_sub','supplies.ID','warehouse_store_export_sub.RECEIVE_SUB_ID')
                      ->leftjoin('warehouse_request','warehouse_request.WAREHOUSE_REQUEST_CODE','warehouse_store_export_sub.WAREHOUSE_REQUEST_CODE');
                      if(!empty($RECEIVE_STORE)){
                        $infohcentertotalpay_3 = $infohcentertotalpay_3->where('warehouse_check_receive.RECEIVE_STORE',$RECEIVE_STORE);
                      }
                      if(!empty($TYPE_CODE)){
                        $infohcentertotalpay_3 = $infohcentertotalpay_3->where('supplies.SUP_TYPE_ID',$TYPE_CODE);
                      }
                      $infohcentertotalpay_3 = $infohcentertotalpay_3->where('warehouse_check_receive.RECEIVE_STORE','=','3')
                      ->where('supplies.SUP_TYPE_ID','=','7')
                      ->where('supplies.ID','<>','637')
                      ->where('supplies.ID','<>','577')
                       ->where('warehouse_request.WAREHOUSE_SMALLHOS','!=',null)
                      ->whereBetween('warehouse_store_export_sub.created_at', [$from3, $to3])
                      ->sum('EXPORT_SUB_VALUE');

        //==================================ไตรมาส 4
        $from4 = date('2022-07-01');
        $to4 = date('2022-09-30');
        $infotriall_4_count = DB::table('warehouse_check_receive_sub')
        ->select('supplies.ID', DB::raw('count(*) as total'))
        ->leftjoin('warehouse_check_receive','warehouse_check_receive.RECEIVE_ID','=','warehouse_check_receive_sub.RECEIVE_ID')
        ->leftjoin('supplies','supplies.ID','warehouse_check_receive_sub.RECEIVE_SUB_CODE');
        if(!empty($RECEIVE_STORE)){
            $infotriall_4_count = $infotriall_4_count->where('warehouse_check_receive.RECEIVE_STORE',$RECEIVE_STORE);
          }
          if(!empty($TYPE_CODE)){
            $infotriall_4_count = $infotriall_4_count->where('supplies.SUP_TYPE_ID',$TYPE_CODE);
          }
          $infotriall_4_count = $infotriall_4_count->where('supplies.ID','<>','637')
        ->where('supplies.ID','<>','577')
        ->where('warehouse_check_receive.RECEIVE_CHECK_STATUS','=','1')
        ->whereBetween('warehouse_check_receive.RECEIVE_CHECK_DATE', [$from4, $to4])
        ->groupBy('supplies.ID')
        ->get();
        $infotriall_4 = count($infotriall_4_count);
    
  
        $infotrialltotal_4 = DB::table('warehouse_check_receive_sub')
        ->leftjoin('warehouse_check_receive','warehouse_check_receive.RECEIVE_ID','=','warehouse_check_receive_sub.RECEIVE_ID')
        ->leftjoin('supplies','supplies.ID','warehouse_check_receive_sub.RECEIVE_SUB_CODE'); 
        if(!empty($RECEIVE_STORE)){
            $infotrialltotal_4 = $infotrialltotal_4->where('warehouse_check_receive.RECEIVE_STORE',$RECEIVE_STORE);
          }
          if(!empty($TYPE_CODE)){
            $infotrialltotal_4 = $infotrialltotal_4->where('supplies.SUP_TYPE_ID',$TYPE_CODE);
          }
          $infotrialltotal_4 = $infotrialltotal_4->where('supplies.ID','<>','637')
        ->where('supplies.ID','<>','577')
        ->where('warehouse_check_receive.RECEIVE_CHECK_STATUS','=','1')
        ->whereBetween('warehouse_check_receive.RECEIVE_CHECK_DATE', [$from4, $to4])
        ->sum('warehouse_check_receive_sub.RECEIVE_SUB_VALUE');
  
       //==================มูลค่าการจ่าย
  
       $infotrialltotalpay_4 = DB::table('warehouse_store_export_sub')
       ->leftjoin('warehouse_request','warehouse_request.WAREHOUSE_REQUEST_CODE','=','warehouse_store_export_sub.WAREHOUSE_REQUEST_CODE')
       ->leftjoin('warehouse_store','warehouse_store.STORE_ID','warehouse_store_export_sub.STORE_ID')
       ->leftjoin('supplies','supplies.ID','warehouse_store.STORE_SUP_ID');
       if(!empty($RECEIVE_STORE)){
        $infotrialltotalpay_4 = $infotrialltotalpay_4->where('warehouse_store.STORE_TYPE',$RECEIVE_STORE);
      }
      if(!empty($TYPE_CODE)){
        $infotrialltotalpay_4 = $infotrialltotalpay_4->where('supplies.SUP_TYPE_ID',$TYPE_CODE);
      }
      $infotrialltotalpay_4 = $infotrialltotalpay_4->where('warehouse_store.STORE_SUP_ID','<>','637')
       ->where('warehouse_store.STORE_SUP_ID','<>','577')
       ->whereBetween('warehouse_request.WAREHOUSE_PAYDAY', [$from4, $to4])
       ->sum('warehouse_store_export_sub.EXPORT_SUB_VALUE');
  
  
  
  
        
        $infotricounty_4_count = DB::table('warehouse_check_receive_sub')
        ->select('supplies.ID', DB::raw('count(*) as total'))
        ->leftjoin('warehouse_check_receive','warehouse_check_receive.RECEIVE_ID','=','warehouse_check_receive_sub.RECEIVE_ID')
        ->leftjoin('supplies','supplies.ID','warehouse_check_receive_sub.RECEIVE_SUB_CODE');   
        if(!empty($RECEIVE_STORE)){
            $infotricounty_4_count = $infotricounty_4_count->where('warehouse_check_receive.RECEIVE_STORE',$RECEIVE_STORE);
          }
          if(!empty($TYPE_CODE)){
            $infotricounty_4_count = $infotricounty_4_count->where('supplies.SUP_TYPE_ID',$TYPE_CODE);
          }
          $infotricounty_4_count = $infotricounty_4_count->where('supplies.ID','<>','637')
        ->where('supplies.ID','<>','577')
        ->where('supplies.CONTINUE_PRICE_ID','=','2')
        ->where('warehouse_check_receive.RECEIVE_CHECK_STATUS','=','1')
        ->where('warehouse_check_receive_sub.RECEIVE_SUB_TYPE','<>','3')
        ->whereBetween('warehouse_check_receive.RECEIVE_CHECK_DATE', [$from4, $to4])
        ->groupBy('supplies.ID')
        ->get();
        $infotricounty_4 = count($infotricounty_4_count);
  
        $infotricountytotal_4 = DB::table('warehouse_check_receive_sub')
        ->leftjoin('warehouse_check_receive','warehouse_check_receive.RECEIVE_ID','=','warehouse_check_receive_sub.RECEIVE_ID')
        ->leftjoin('supplies','supplies.ID','warehouse_check_receive_sub.RECEIVE_SUB_CODE');
        if(!empty($RECEIVE_STORE)){
            $infotricountytotal_4 = $infotricountytotal_4->where('warehouse_check_receive.RECEIVE_STORE',$RECEIVE_STORE);
          }
          if(!empty($TYPE_CODE)){
            $infotricountytotal_4 = $infotricountytotal_4->where('supplies.SUP_TYPE_ID',$TYPE_CODE);
          }
          $infotricountytotal_4 = $infotricountytotal_4->where('supplies.ID','<>','637')
        ->where('supplies.ID','<>','577')
        ->where('supplies.CONTINUE_PRICE_ID','=','2')
        ->where('warehouse_check_receive.RECEIVE_CHECK_STATUS','=','1')
        ->where('warehouse_check_receive_sub.RECEIVE_SUB_TYPE','<>','3')
        ->whereBetween('warehouse_check_receive.RECEIVE_CHECK_DATE', [$from4, $to4])
        ->sum('warehouse_check_receive_sub.RECEIVE_SUB_VALUE');
  
  
               //==================มูลค่าการจ่าย
  
       $infotricountytotalpay_4 =  DB::table('warehouse_store_export_sub')
     ->leftjoin('warehouse_request','warehouse_request.WAREHOUSE_REQUEST_CODE','=','warehouse_store_export_sub.WAREHOUSE_REQUEST_CODE')
     ->leftjoin('warehouse_store','warehouse_store.STORE_ID','warehouse_store_export_sub.STORE_ID')
     ->leftjoin('supplies','supplies.ID','warehouse_store.STORE_SUP_ID');
     if(!empty($RECEIVE_STORE)){
        $infotricountytotalpay_4 = $infotricountytotalpay_4->where('warehouse_store.STORE_TYPE',$RECEIVE_STORE);
      }
      if(!empty($TYPE_CODE)){
        $infotricountytotalpay_4 = $infotricountytotalpay_4->where('supplies.SUP_TYPE_ID',$TYPE_CODE);
      }
      $infotricountytotalpay_4 = $infotricountytotalpay_4->where('warehouse_store.STORE_SUP_ID','<>','637')
     ->where('warehouse_store.STORE_SUP_ID','<>','577')
     ->where('supplies.CONTINUE_PRICE_ID','=','2')
     ->whereBetween('warehouse_request.WAREHOUSE_PAYDAY', [$from4, $to4])
     ->sum('warehouse_store_export_sub.EXPORT_SUB_VALUE');
  
  
        $infotriprovince_4_count = DB::table('warehouse_check_receive_sub')
        ->select('supplies.ID', DB::raw('count(*) as total'))
        ->leftjoin('warehouse_check_receive','warehouse_check_receive.RECEIVE_ID','=','warehouse_check_receive_sub.RECEIVE_ID')
        ->leftjoin('supplies','supplies.ID','warehouse_check_receive_sub.RECEIVE_SUB_CODE');
        if(!empty($RECEIVE_STORE)){
            $infotriprovince_4_count = $infotriprovince_4_count->where('warehouse_check_receive.RECEIVE_STORE',$RECEIVE_STORE);
          }
          if(!empty($TYPE_CODE)){
            $infotriprovince_4_count = $infotriprovince_4_count->where('supplies.SUP_TYPE_ID',$TYPE_CODE);
          }
          $infotriprovince_4_count = $infotriprovince_4_count->where('supplies.ID','<>','637')
        ->where('supplies.ID','<>','577')
        ->where('supplies.CONTINUE_PRICE_ID','=','1')
        ->where('warehouse_check_receive.RECEIVE_CHECK_STATUS','=','1')
        ->where('warehouse_check_receive_sub.RECEIVE_SUB_TYPE','<>','3')
        ->whereBetween('warehouse_check_receive.RECEIVE_CHECK_DATE', [$from4, $to4])
        ->groupBy('supplies.ID')
        ->get();
        $infotriprovince_4 = count($infotriprovince_4_count);
        
        $infotriprovincetotal_4 = DB::table('warehouse_check_receive_sub')
        ->leftjoin('warehouse_check_receive','warehouse_check_receive.RECEIVE_ID','=','warehouse_check_receive_sub.RECEIVE_ID')
        ->leftjoin('supplies','supplies.ID','warehouse_check_receive_sub.RECEIVE_SUB_CODE');
        if(!empty($RECEIVE_STORE)){
            $infotriprovincetotal_4 = $infotriprovincetotal_4->where('warehouse_check_receive.RECEIVE_STORE',$RECEIVE_STORE);
          }
          if(!empty($TYPE_CODE)){
            $infotriprovincetotal_4 = $infotriprovincetotal_4->where('supplies.SUP_TYPE_ID',$TYPE_CODE);
          }
          $infotriprovincetotal_4 = $infotriprovincetotal_4->where('supplies.ID','<>','637')
        ->where('supplies.ID','<>','577')
        ->where('supplies.CONTINUE_PRICE_ID','=','1')
        ->where('warehouse_check_receive.RECEIVE_CHECK_STATUS','=','1')
        ->where('warehouse_check_receive_sub.RECEIVE_SUB_TYPE','<>','3')
        ->whereBetween('warehouse_check_receive.RECEIVE_CHECK_DATE', [$from4, $to4])
        ->sum('warehouse_check_receive_sub.RECEIVE_SUB_VALUE');
  
        //==================มูลค่าการจ่าย
  

       $infotriprovincetotalpay_4 =  DB::table('warehouse_store_export_sub')
     ->leftjoin('warehouse_request','warehouse_request.WAREHOUSE_REQUEST_CODE','=','warehouse_store_export_sub.WAREHOUSE_REQUEST_CODE')
     ->leftjoin('warehouse_store','warehouse_store.STORE_ID','warehouse_store_export_sub.STORE_ID')
     ->leftjoin('supplies','supplies.ID','warehouse_store.STORE_SUP_ID');
     
     if(!empty($RECEIVE_STORE)){
        $infotriprovincetotalpay_4 = $infotriprovincetotalpay_4->where('warehouse_store.STORE_TYPE',$RECEIVE_STORE);
      }
      if(!empty($TYPE_CODE)){
        $infotriprovincetotalpay_4 = $infotriprovincetotalpay_4->where('supplies.SUP_TYPE_ID',$TYPE_CODE);
      }
      $infotriprovincetotalpay_4 = $infotriprovincetotalpay_4->where('warehouse_store.STORE_SUP_ID','<>','637')
     ->where('warehouse_store.STORE_SUP_ID','<>','577')
     ->where('supplies.CONTINUE_PRICE_ID','=','1')
     ->whereBetween('warehouse_request.WAREHOUSE_PAYDAY', [$from4, $to4])
     ->sum('warehouse_store_export_sub.EXPORT_SUB_VALUE');
  
  
  
        $infotriself_4_count = DB::table('warehouse_check_receive_sub')
        ->select('supplies.ID', DB::raw('count(*) as total'))
        ->leftjoin('warehouse_check_receive','warehouse_check_receive.RECEIVE_ID','=','warehouse_check_receive_sub.RECEIVE_ID')
        ->leftjoin('supplies','supplies.ID','warehouse_check_receive_sub.RECEIVE_SUB_CODE');
        if(!empty($RECEIVE_STORE)){
            $infotriself_4_count = $infotriself_4_count->where('warehouse_check_receive.RECEIVE_STORE',$RECEIVE_STORE);
          }
          if(!empty($TYPE_CODE)){
            $infotriself_4_count = $infotriself_4_count->where('supplies.SUP_TYPE_ID',$TYPE_CODE);
          }
          $infotriself_4_count = $infotriself_4_count->where('supplies.ID','<>','637')
        ->where('supplies.ID','<>','577')
        ->where('supplies.CONTINUE_PRICE_ID','=','3')
        ->where('warehouse_check_receive.RECEIVE_CHECK_STATUS','=','1')
        ->where('warehouse_check_receive_sub.RECEIVE_SUB_TYPE','<>','3')
        ->whereBetween('warehouse_check_receive.RECEIVE_CHECK_DATE', [$from4, $to4])
        ->groupBy('supplies.ID')
        ->get();
        $infotriself_4 = count($infotriself_4_count);
  
        $infotriselftotal_4 = DB::table('warehouse_check_receive_sub')
        ->leftjoin('warehouse_check_receive','warehouse_check_receive.RECEIVE_ID','=','warehouse_check_receive_sub.RECEIVE_ID')
        ->leftjoin('supplies','supplies.ID','warehouse_check_receive_sub.RECEIVE_SUB_CODE');
        if(!empty($RECEIVE_STORE)){
            $infotriselftotal_4 = $infotriselftotal_4->where('warehouse_check_receive.RECEIVE_STORE',$RECEIVE_STORE);
          }
          if(!empty($TYPE_CODE)){
            $infotriselftotal_4 = $infotriselftotal_4->where('supplies.SUP_TYPE_ID',$TYPE_CODE);
          }
          $infotriselftotal_4 = $infotriselftotal_4->where('supplies.ID','<>','637')
        ->where('supplies.ID','<>','577')
        ->where('supplies.CONTINUE_PRICE_ID','=','3')
        ->where('warehouse_check_receive.RECEIVE_CHECK_STATUS','=','1')
        ->where('warehouse_check_receive_sub.RECEIVE_SUB_TYPE','<>','3')
        ->whereBetween('warehouse_check_receive.RECEIVE_CHECK_DATE', [$from4, $to4])
        ->sum('warehouse_check_receive_sub.RECEIVE_SUB_VALUE');
  
                //==================มูลค่าการจ่าย

       $infotriselftotalpay_4 =  DB::table('warehouse_store_export_sub')
       ->leftjoin('warehouse_request','warehouse_request.WAREHOUSE_REQUEST_CODE','=','warehouse_store_export_sub.WAREHOUSE_REQUEST_CODE')
       ->leftjoin('warehouse_store','warehouse_store.STORE_ID','warehouse_store_export_sub.STORE_ID')
       ->leftjoin('supplies','supplies.ID','warehouse_store.STORE_SUP_ID');
       if(!empty($RECEIVE_STORE)){
        $infotriselftotalpay_4 = $infotriselftotalpay_4->where('warehouse_store.STORE_TYPE',$RECEIVE_STORE);
      }
      if(!empty($TYPE_CODE)){
        $infotriselftotalpay_4 = $infotriselftotalpay_4->where('supplies.SUP_TYPE_ID',$TYPE_CODE);
      }
      $infotriselftotalpay_4 = $infotriselftotalpay_4->where('warehouse_store.STORE_SUP_ID','<>','637')
       ->where('warehouse_store.STORE_SUP_ID','<>','577')
       ->where('supplies.CONTINUE_PRICE_ID','=','3')
       ->whereBetween('warehouse_request.WAREHOUSE_PAYDAY', [$from4, $to4])
       ->sum('warehouse_store_export_sub.EXPORT_SUB_VALUE');
  
  
  
        $infonotremark_4_count = DB::table('warehouse_check_receive_sub')
        ->select('supplies.ID', DB::raw('count(*) as total'))
        ->leftjoin('warehouse_check_receive','warehouse_check_receive.RECEIVE_ID','=','warehouse_check_receive_sub.RECEIVE_ID')
        ->leftjoin('supplies','supplies.ID','warehouse_check_receive_sub.RECEIVE_SUB_CODE');
        if(!empty($RECEIVE_STORE)){
            $infonotremark_4_count = $infonotremark_4_count->where('warehouse_check_receive.RECEIVE_STORE',$RECEIVE_STORE);
          }
          if(!empty($TYPE_CODE)){
            $infonotremark_4_count = $infonotremark_4_count->where('supplies.SUP_TYPE_ID',$TYPE_CODE);
          }
          $infonotremark_4_count = $infonotremark_4_count->where('supplies.ID','<>','637')
        ->where('supplies.ID','<>','577')
        ->where('supplies.CONTINUE_PRICE_ID','=',null)
        ->where('warehouse_check_receive.RECEIVE_CHECK_STATUS','=','1')
        ->where('warehouse_check_receive_sub.RECEIVE_SUB_TYPE','<>','3')
        ->whereBetween('warehouse_check_receive.RECEIVE_CHECK_DATE', [$from4, $to4])
        ->groupBy('supplies.ID')
        ->get();
        $infonotremark_4 = count($infonotremark_4_count);
        
      
  
        $infonotremarktotal_4 = DB::table('warehouse_check_receive_sub')
        ->leftjoin('warehouse_check_receive','warehouse_check_receive.RECEIVE_ID','=','warehouse_check_receive_sub.RECEIVE_ID')
        ->leftjoin('supplies','supplies.ID','warehouse_check_receive_sub.RECEIVE_SUB_CODE');
        if(!empty($RECEIVE_STORE)){
            $infonotremarktotal_4 = $infonotremarktotal_4->where('warehouse_check_receive.RECEIVE_STORE',$RECEIVE_STORE);
          }
          if(!empty($TYPE_CODE)){
            $infonotremarktotal_4 = $infonotremarktotal_4->where('supplies.SUP_TYPE_ID',$TYPE_CODE);
          }
          $infonotremarktotal_4 = $infonotremarktotal_4->where('supplies.ID','<>','637')
        ->where('supplies.ID','<>','577')
        ->where('supplies.CONTINUE_PRICE_ID','=',null)
        ->where('warehouse_check_receive.RECEIVE_CHECK_STATUS','=','1')
        ->where('warehouse_check_receive_sub.RECEIVE_SUB_TYPE','<>','3')
        ->whereBetween('warehouse_check_receive.RECEIVE_CHECK_DATE', [$from4, $to4])
        ->sum('warehouse_check_receive_sub.RECEIVE_SUB_VALUE');
  
                        //==================มูลค่าการจ่าย
  

       $infonotremarktotalpay_4 = DB::table('warehouse_store_export_sub')
       ->leftjoin('warehouse_request','warehouse_request.WAREHOUSE_REQUEST_CODE','=','warehouse_store_export_sub.WAREHOUSE_REQUEST_CODE')
       ->leftjoin('warehouse_store','warehouse_store.STORE_ID','warehouse_store_export_sub.STORE_ID')
       ->leftjoin('supplies','supplies.ID','warehouse_store.STORE_SUP_ID');
       if(!empty($RECEIVE_STORE)){
        $infonotremarktotalpay_4 = $infonotremarktotalpay_4->where('warehouse_store.STORE_TYPE',$RECEIVE_STORE);
      }
      if(!empty($TYPE_CODE)){
        $infonotremarktotalpay_4 = $infonotremarktotalpay_4->where('supplies.SUP_TYPE_ID',$TYPE_CODE);
      }
      $infonotremarktotalpay_4 = $infonotremarktotalpay_4->where('warehouse_store.STORE_SUP_ID','<>','637')
       ->where('warehouse_store.STORE_SUP_ID','<>','577')
       ->where('supplies.CONTINUE_PRICE_ID','=',null)
       ->whereBetween('warehouse_request.WAREHOUSE_PAYDAY', [$from4, $to4])
       ->sum('warehouse_store_export_sub.EXPORT_SUB_VALUE');
    
     
      
  
        $infotribonus_4_count = DB::table('warehouse_check_receive_sub')
        ->select('supplies.ID', DB::raw('count(*) as total'))
        ->leftjoin('warehouse_check_receive','warehouse_check_receive.RECEIVE_ID','=','warehouse_check_receive_sub.RECEIVE_ID')
        ->leftjoin('supplies','supplies.ID','warehouse_check_receive_sub.RECEIVE_SUB_CODE');
        if(!empty($RECEIVE_STORE)){
            $infotribonus_4_count = $infotribonus_4_count->where('warehouse_check_receive.RECEIVE_STORE',$RECEIVE_STORE);
          }
          if(!empty($TYPE_CODE)){
            $infotribonus_4_count = $infotribonus_4_count->where('supplies.SUP_TYPE_ID',$TYPE_CODE);
          }
          $infotribonus_4_count = $infotribonus_4_count->where('supplies.ID','<>','637')
        ->where('supplies.ID','<>','577')
        ->where('warehouse_check_receive.RECEIVE_CHECK_STATUS','=','1')
        ->where('warehouse_check_receive_sub.RECEIVE_SUB_TYPE','=','3')
        ->whereBetween('warehouse_check_receive.RECEIVE_CHECK_DATE', [$from4, $to4])
        ->groupBy('supplies.ID')
        ->get();
        $infotribonus_4 = count($infotribonus_4_count);
  
       
  
        $infotribonustotal_4 = DB::table('warehouse_check_receive_sub')
        ->leftjoin('warehouse_check_receive','warehouse_check_receive.RECEIVE_ID','=','warehouse_check_receive_sub.RECEIVE_ID')
        ->leftjoin('supplies','supplies.ID','warehouse_check_receive_sub.RECEIVE_SUB_CODE');
        if(!empty($RECEIVE_STORE)){
            $infotribonustotal_4 = $infotribonustotal_4->where('warehouse_check_receive.RECEIVE_STORE',$RECEIVE_STORE);
          }
          if(!empty($TYPE_CODE)){
            $infotribonustotal_4 = $infotribonustotal_4->where('supplies.SUP_TYPE_ID',$TYPE_CODE);
          }
          $infotribonustotal_4 = $infotribonustotal_4->where('supplies.ID','<>','637')
        ->where('supplies.ID','<>','577')
        ->where('warehouse_check_receive.RECEIVE_CHECK_STATUS','=','1')
        ->where('warehouse_check_receive_sub.RECEIVE_SUB_TYPE','=','3')
        ->whereBetween('warehouse_check_receive.RECEIVE_CHECK_DATE', [$from4, $to4])
        ->sum('warehouse_check_receive_sub.RECEIVE_SUB_VALUE');
  
  
            //==================มูลค่าการจ่าย
  
       $infotribonustotalpay_4 = DB::table('warehouse_check_receive_sub')
       ->leftjoin('warehouse_check_receive','warehouse_check_receive.RECEIVE_ID','=','warehouse_check_receive_sub.RECEIVE_ID')
       ->leftjoin('supplies','supplies.ID','warehouse_check_receive_sub.RECEIVE_SUB_CODE')
       ->leftjoin('warehouse_store_export_sub','supplies.ID','warehouse_store_export_sub.RECEIVE_SUB_ID');
       if(!empty($RECEIVE_STORE)){
        $infotribonustotalpay_4 = $infotribonustotalpay_4->where('warehouse_check_receive.RECEIVE_STORE',$RECEIVE_STORE);
      }
      if(!empty($TYPE_CODE)){
        $infotribonustotalpay_4 = $infotribonustotalpay_4->where('supplies.SUP_TYPE_ID',$TYPE_CODE);
      }
      $infotribonustotalpay_4 = $infotribonustotalpay_4->where('supplies.ID','<>','637')
       ->where('supplies.ID','<>','577')
       ->where('warehouse_check_receive.RECEIVE_CHECK_STATUS','=','1')
       ->where('warehouse_check_receive_sub.RECEIVE_SUB_TYPE','=','3')
       ->whereBetween('warehouse_store_export_sub.created_at', [$from4, $to4])
       ->sum('EXPORT_SUB_VALUE');
  
  
  
       
                        //==================มูลค่าการจ่ายรพสต.
  
                        $infohcenter_4_count = DB::table('warehouse_check_receive_sub')
                        ->select('supplies.ID', DB::raw('count(*) as total'))
                        ->leftjoin('warehouse_check_receive','warehouse_check_receive.RECEIVE_ID','=','warehouse_check_receive_sub.RECEIVE_ID')
                        ->leftjoin('supplies','supplies.ID','warehouse_check_receive_sub.RECEIVE_SUB_CODE')
                        ->leftjoin('warehouse_store_export_sub','supplies.ID','warehouse_store_export_sub.RECEIVE_SUB_ID')
                        ->leftjoin('warehouse_request','warehouse_request.WAREHOUSE_REQUEST_CODE','warehouse_store_export_sub.WAREHOUSE_REQUEST_CODE');
                        if(!empty($RECEIVE_STORE)){
                            $infohcenter_4_count = $infohcenter_4_count->where('warehouse_check_receive.RECEIVE_STORE',$RECEIVE_STORE);
                          }
                          if(!empty($TYPE_CODE)){
                            $infohcenter_4_count = $infohcenter_4_count->where('supplies.SUP_TYPE_ID',$TYPE_CODE);
                          }
                          $infohcenter_4_count = $infohcenter_4_count->where('supplies.ID','<>','637')
                        ->where('supplies.ID','<>','577')
                         ->where('warehouse_request.WAREHOUSE_SMALLHOS','!=',null)
                        ->whereBetween('warehouse_store_export_sub.created_at', [$from4, $to4])
                        ->groupBy('supplies.ID')
                        ->get();
                        $infohcenter_4 = count($infohcenter_4_count);
  
                        $infohcentertotalpay_4 = DB::table('warehouse_check_receive_sub')
                        ->leftjoin('warehouse_check_receive','warehouse_check_receive.RECEIVE_ID','=','warehouse_check_receive_sub.RECEIVE_ID')
                        ->leftjoin('supplies','supplies.ID','warehouse_check_receive_sub.RECEIVE_SUB_CODE')
                        ->leftjoin('warehouse_store_export_sub','supplies.ID','warehouse_store_export_sub.RECEIVE_SUB_ID')
                        ->leftjoin('warehouse_request','warehouse_request.WAREHOUSE_REQUEST_CODE','warehouse_store_export_sub.WAREHOUSE_REQUEST_CODE');
                        if(!empty($RECEIVE_STORE)){
                            $infohcentertotalpay_4 = $infohcentertotalpay_4->where('warehouse_check_receive.RECEIVE_STORE',$RECEIVE_STORE);
                          }
                          if(!empty($TYPE_CODE)){
                            $infohcentertotalpay_4 = $infohcentertotalpay_4->where('supplies.SUP_TYPE_ID',$TYPE_CODE);
                          }
                          $infohcentertotalpay_4 = $infohcentertotalpay_4->where('warehouse_check_receive.RECEIVE_STORE','=','3')
                        ->where('supplies.SUP_TYPE_ID','=','7')
                        ->where('supplies.ID','<>','637')
                        ->where('supplies.ID','<>','577')
                         ->where('warehouse_request.WAREHOUSE_SMALLHOS','!=',null)
                        ->whereBetween('warehouse_store_export_sub.created_at', [$from4, $to4])
                        ->sum('EXPORT_SUB_VALUE');

      return view('manager_warehouse.warehousreportquarter',[
          'infotrialltotalrecivefirst' =>  $infotrialltotalrecivefirst,
          'infotricountytotalfirst' => $infotricountytotalfirst,
          'infotriprovincetotalfirst' => $infotriprovincetotalfirst,
          'infotriselftotalfirst' => $infotriselftotalfirst,
          'infonotremarktotalfirst' => $infonotremarktotalfirst,
          'infotribonustotalfirst' => $infotribonustotalfirst,
          'infotriall_1' => $infotriall_1, 
          'infotrialltotal_1' => $infotrialltotal_1,
          'infotricounty_1' => $infotricounty_1,
          'infotricountytotal_1' => $infotricountytotal_1,
          'infotriprovince_1' => $infotriprovince_1,
          'infotriprovincetotal_1' => $infotriprovincetotal_1,
          'infotriself_1' => $infotriself_1,
          'infotriselftotal_1' => $infotriselftotal_1,
          'infonotremark_1' => $infonotremark_1,
          'infonotremarktotal_1' => $infonotremarktotal_1,
          'infotribonus_1' => $infotribonus_1,
          'infotribonustotal_1' => $infotribonustotal_1, 
          'infotrialltotalpay_1' => $infotrialltotalpay_1, 
          'infotricountytotalpay_1' => $infotricountytotalpay_1,  
          'infotriprovincetotalpay_1' => $infotriprovincetotalpay_1,  
          'infotriselftotalpay_1' => $infotriselftotalpay_1,  
          'infonotremarktotalpay_1' => $infonotremarktotalpay_1,  
          'infotribonustotalpay_1' => $infotribonustotalpay_1,  

          'infohcenter_1' => $infohcenter_1,  
          'infohcentertotalpay_1' => $infohcentertotalpay_1,

          'infotriall_2' => $infotriall_2, 
          'infotrialltotal_2' => $infotrialltotal_2,
          'infotricounty_2' => $infotricounty_2,
          'infotricountytotal_2' => $infotricountytotal_2,
          'infotriprovince_2' => $infotriprovince_2,
          'infotriprovincetotal_2' => $infotriprovincetotal_2,
          'infotriself_2' => $infotriself_2,
          'infotriselftotal_2' => $infotriselftotal_2,
          'infonotremark_2' => $infonotremark_2,
          'infonotremarktotal_2' => $infonotremarktotal_2,
          'infotribonus_2' => $infotribonus_2,
          'infotribonustotal_2' => $infotribonustotal_2, 
          'infotrialltotalpay_2' => $infotrialltotalpay_2, 
          'infotricountytotalpay_2' => $infotricountytotalpay_2,  
          'infotriprovincetotalpay_2' => $infotriprovincetotalpay_2,  
          'infotriselftotalpay_2' => $infotriselftotalpay_2,  
          'infonotremarktotalpay_2' => $infonotremarktotalpay_2,  
          'infotribonustotalpay_2' => $infotribonustotalpay_2,  

          'infohcenter_2' => $infohcenter_2,  
          'infohcentertotalpay_2' => $infohcentertotalpay_2,


          'infotriall_3' => $infotriall_3, 
          'infotrialltotal_3' => $infotrialltotal_3,
          'infotricounty_3' => $infotricounty_3,
          'infotricountytotal_3' => $infotricountytotal_3,
          'infotriprovince_3' => $infotriprovince_3,
          'infotriprovincetotal_3' => $infotriprovincetotal_3,
          'infotriself_3' => $infotriself_3,
          'infotriselftotal_3' => $infotriselftotal_3,
          'infonotremark_3' => $infonotremark_3,
          'infonotremarktotal_3' => $infonotremarktotal_3,
          'infotribonus_3' => $infotribonus_3,
          'infotribonustotal_3' => $infotribonustotal_3, 
          'infotrialltotalpay_3' => $infotrialltotalpay_3, 
          'infotricountytotalpay_3' => $infotricountytotalpay_3,  
          'infotriprovincetotalpay_3' => $infotriprovincetotalpay_3,  
          'infotriselftotalpay_3' => $infotriselftotalpay_3,  
          'infonotremarktotalpay_3' => $infonotremarktotalpay_3,  
          'infotribonustotalpay_3' => $infotribonustotalpay_3,  

          'infohcenter_3' => $infohcenter_3,  
          'infohcentertotalpay_3' => $infohcentertotalpay_3,


          'infotriall_4' => $infotriall_4, 
          'infotrialltotal_4' => $infotrialltotal_2,
          'infotricounty_4' => $infotricounty_2,
          'infotricountytotal_4' => $infotricountytotal_2,
          'infotriprovince_4' => $infotriprovince_2,
          'infotriprovincetotal_4' => $infotriprovincetotal_2,
          'infotriself_4' => $infotriself_2,
          'infotriselftotal_4' => $infotriselftotal_2,
          'infonotremark_4' => $infonotremark_2,
          'infonotremarktotal_4' => $infonotremarktotal_2,
          'infotribonus_4' => $infotribonus_2,
          'infotribonustotal_4' => $infotribonustotal_2, 
          'infotrialltotalpay_4' => $infotrialltotalpay_2, 
          'infotricountytotalpay_4' => $infotricountytotalpay_2,  
          'infotriprovincetotalpay_4' => $infotriprovincetotalpay_2,  
          'infotriselftotalpay_4' => $infotriselftotalpay_2,  
          'infonotremarktotalpay_4' => $infonotremarktotalpay_2,  
          'infotribonustotalpay_4' => $infotribonustotalpay_2,  

          'infohcenter_4' => $infohcenter_4,  
          'infohcentertotalpay_4' => $infohcentertotalpay_4,

           'infotypes' => $infotype,
           'infosuppliesinvens'=>$infosuppliesinven,
           'type_check'=> $TYPE_CODE,
           'checkreceive'=>$RECEIVE_STORE

      ]);
  }
 
  //==========================================รายงานแผนการจัดซื้อวัสดุ

  

public function reportplan(Request $request)
{

 
    return view('manager_warehouse.warehousreportplan');
}


public function reportrandom(Request $request)
{
 
    return view('manager_warehouse.warehousreportrandom');
}


public function reportexp(Request $request)
{

    $todate = date('Y-m-d');

    $storereceivesub= DB::table('warehouse_store_receive_sub')
    ->select('warehouse_store_receive_sub.created_at','SUP_TYPE_NAME','RECEIVE_SUB_NAME','RECEIVE_SUB_LOT','RECEIVE_SUB_AMOUNT','RECEIVE_SUB_ID','RECEIVE_SUB_PICE_UNIT','RECEIVE_SUB_EXP_DATE','RECEIVE_ACCEPT_FROM','RECEIVE_PERSON_NAME','SUP_UNIT_NAME','RECEIVE_SUB_GEN_DATE','warehouse_check_receive.RECEIVE_CHECK_DATE')
    ->leftJoin('warehouse_store','warehouse_store.STORE_ID','=','warehouse_store_receive_sub.STORE_ID')
    ->leftJoin('warehouse_sup_type','warehouse_sup_type.ID_SUP_TYPE','=','warehouse_store_receive_sub.RECEIVE_SUB_TYPE')
    ->leftJoin('warehouse_check_receive','warehouse_check_receive.RECEIVE_ID','=','warehouse_store_receive_sub.RECEIVE_ID')
    ->leftJoin('supplies_unit_ref','warehouse_store.STORE_UNIT','=','supplies_unit_ref.ID')
    ->where('RECEIVE_SUB_EXP_DATE','<',$todate)
    ->get();

 
    return view('manager_warehouse.warehousreportexp',[
        'storereceivesubs' => $storereceivesub,
      
   ]);
}




  //-----------------------------ตั้งค่าข้อมูลวัตถุประสงค์


  public function objectivepay()
  {
    
      $infoobjectivepay = Warehouseobjectivepay::orderBy('OBJECTIVEPAY_ID', 'asc')  
                                              ->get();                       
     
      return view('manager_warehouse.setupobjectivepay',[
          'infoobjectivepays' => $infoobjectivepay
      ]);
  }
  
  public function objectivepay_add(Request $request)
      {
    
          return view('manager_warehouse.setupobjectivepay_add');
  
      }
  
      public function objectivepay_save(Request $request)
      {
         
  
              $add= new Warehouseobjectivepay(); 
              $add->OBJECTIVEPAY_NAME = $request->OBJECTIVEPAY_NAME;
           
   
              $add->save();
  
  
              return redirect()->route('mwarehouse.objectivepay'); 
      }
  
      public function objectivepay_edit(Request $request,$id)
      {
        
      
         $id_in= $id;
       
         $infoobj= Warehouseobjectivepay::where('OBJECTIVEPAY_ID','=',$id_in)
         ->first();
  
  
  
          return view('manager_warehouse.setupobjectivepay_edit',[
          'infoobj' => $infoobj 
          ]);
  
      }
  
  
  
      public function objectivepay_update(Request $request)
      {
          $id = $request->OBJECTIVEPAY_ID; 
  
          $update= Warehouseobjectivepay::find($id);
          $update->OBJECTIVEPAY_NAME = $request->OBJECTIVEPAY_NAME;
          $update->save();
  
  
          return redirect()->route('mwarehouse.objectivepay'); 
  
      }
  
      
      public function objectivepay_delete($id) { 
  
        Warehouseobjectivepay::destroy($id);         
          return redirect()->route('mwarehouse.objectivepay');   
      }

      //=======================================

      public function warehousewithdraw_add(Request $request)
      {
          $iduser = Auth::user()->PERSON_ID;
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
      
          //dd($orgname->ORG_NAME);
      
          $m_budget = date("m");
          if($m_budget>9){
          $yearbudget = date("Y")+544;
          }else{
          $yearbudget = date("Y")+543;
          }
      
          $infosupplies= Supplies::leftJoin('supplies_type','supplies.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
          ->leftJoin('supplies_type_kind','supplies.SUP_TYPE_KIND_ID','=','supplies_type_kind.SUP_TYPE_KIND_ID')
          ->where('supplies_type_kind.SUP_TYPE_MASTER_ID','=',1)
          ->orderBy('ID', 'desc') 
          ->get();
      
          $infosuppliesunitref = DB::table('supplies_unit_ref')->get();
      
          $budget = DB::table('budget_year')->where('ACTIVE','=','True')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
      
          $infostore = DB::table('supplies_inven')->where('ACTIVE','=','True')->get();
      
          $smallhos = DB::table('warehouse_smallhos')->get();
      
          $headdepartmentsubsub = DB::table('hrd_department_sub_sub')->where('HR_DEPARTMENT_SUB_SUB_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)->first();
      
          $leader =  DB::table('gleave_leader_person')
          ->leftJoin('gleave_leader','gleave_leader.LEADER_ID','=','gleave_leader_person.LEADER_ID')
          ->where('PERSON_ID','=',$iduser)
          ->get();
      
          return view('manager_warehouse.warehousewithdraw_add',[
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
              'infostores' => $infostore,
              'smallhoss' => $smallhos,
              'headdepartmentsubsub' => $headdepartmentsubsub,
              'leaders'=>$leader,
      
          ]);
      
      }
      


      
public function warehousewithdraw_save(Request $request)
{

         $DATEWANT = $request->WAREHOUSE_DATE_WANT;

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

        //=========================


      $m_budget = date("m");
      if($m_budget>9){
      $yearbudget = date("Y")+544;
      }else{
      $yearbudget = date("Y")+543;
      }

   
   $maxnumber = DB::table('warehouse_request')->where('WAREHOUSE_BUDGET_YEAR','=',$yearbudget)->max('WAREHOUSE_ID');  

   if($maxnumber != '' ||  $maxnumber != null){
       
       $refmax = DB::table('warehouse_request')->where('WAREHOUSE_ID','=',$maxnumber)->first();  

     

       if($refmax->WAREHOUSE_REQUEST_CODE != '' ||  $refmax->WAREHOUSE_REQUEST_CODE != null){
           $maxref = substr($refmax->WAREHOUSE_REQUEST_CODE, -4)+1;
        }else{
           $maxref = 1;
        }

       $ref = str_pad($maxref, 4, "0", STR_PAD_LEFT);
  
   }else{
       
       $ref = '0001';
   }


   $y = substr($yearbudget, -2);
  

$refnumber ='RE-'.$y.''.$ref;

//==========================


    $maxnumbercheck = DB::table('warehouse_request')->max('WAREHOUSE_ID');  
    $infocheck =  Warehouserequest::where('WAREHOUSE_ID','=',$maxnumbercheck)->first();

 
    if($infocheck == null || $infocheck == ''){

        
        $addinforequest = new Warehouserequest();

        $addinforequest->WAREHOUSE_REQUEST_CODE = $refnumber;
        $addinforequest->WAREHOUSE_DATE_WANT = $DATEWANT;
        $addinforequest->WAREHOUSE_DATE_TIME_SAVE = date('Y-m-d H:i:s');

        $addinforequest->WAREHOUSE_DEP_SUB_SUB_ID = $request->WAREHOUSE_DEP_SUB_SUB_ID;
    
        $addinforequest->WAREHOUSE_SAVE_HR_ID = $request->WAREHOUSE_SAVE_HR_ID;

          //----------------------------------
          $SAVEHR =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
          ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
          ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
          ->where('hrd_person.ID','=',$request->WAREHOUSE_SAVE_HR_ID)->first();

                $addinforequest->WAREHOUSE_SAVE_HR_NAME = $SAVEHR->HR_PREFIX_NAME.''.$SAVEHR->HR_FNAME.' '.$SAVEHR->HR_LNAME;
                $addinforequest->WAREHOUSE_SAVE_HR_POSITION = $SAVEHR->HR_POSITION_NAME;
                $addinforequest->WAREHOUSE_SAVE_HR_DEP_SUB_NAME = $SAVEHR->HR_DEPARTMENT_SUB_NAME;

           //----------------------------------

                $addinforequest->WAREHOUSE_AGREE_HR_ID = $request->WAREHOUSE_AGREE_HR_ID;

             //----------------------------------
             $AGREEHR =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
             ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
             ->where('hrd_person.ID','=',$request->WAREHOUSE_AGREE_HR_ID)->first();

                $addinforequest->WAREHOUSE_AGREE_HR_NAME = $AGREEHR->HR_PREFIX_NAME.''.$AGREEHR->HR_FNAME.' '.$AGREEHR->HR_LNAME;
                $addinforequest->WAREHOUSE_AGREE_HR_POSITION = $AGREEHR->HR_POSITION_NAME;

              //----------------------------------

                $addinforequest->WAREHOUSE_REQUEST_BUY_COMMENT = $request->WAREHOUSE_REQUEST_BUY_COMMENT;

                $addinforequest->WAREHOUSE_INVEN_ID = $request->WAREHOUSE_INVEN_ID;

                $addinforequest->WAREHOUSE_STATUS = 'Approve';

                $addinforequest->WAREHOUSE_BUDGET_YEAR = $request->WAREHOUSE_BUDGET_YEAR;

                $addinforequest->WAREHOUSE_SMALLHOS = $request->WAREHOUSE_SMALLHOS;
     
                $addinforequest->save();

                $WAREHOUSE_REQUEST_ID = Warehouserequest::max('WAREHOUSE_ID');

        if($request->WAREHOUSE_REQUEST_SUB_AMOUNT != '' || $request->WAREHOUSE_REQUEST_SUB_AMOUNT != null){

            $WAREHOUSE_REQUEST_SUB_DETAIL_ID = $request->WAREHOUSE_REQUEST_SUB_DETAIL_ID;
            $WAREHOUSE_REQUEST_SUB_AMOUNT = $request->WAREHOUSE_REQUEST_SUB_AMOUNT;
            $WAREHOUSE_REQUEST_SUB_UNIT = $request->WAREHOUSE_REQUEST_SUB_UNIT;

            $number =count($WAREHOUSE_REQUEST_SUB_DETAIL_ID);
            $count = 0;
            for($count = 0; $count< $number; $count++)
            {
               $add = new Warehouserequestsub();
               $add->WAREHOUSE_REQUEST_ID = $WAREHOUSE_REQUEST_ID;
               $add->WAREHOUSE_REQUEST_SUB_DETAIL_ID = $WAREHOUSE_REQUEST_SUB_DETAIL_ID[$count];
               $add->WAREHOUSE_REQUEST_SUB_AMOUNT = $WAREHOUSE_REQUEST_SUB_AMOUNT[$count];
               $add->WAREHOUSE_REQUEST_SUB_UNIT = $WAREHOUSE_REQUEST_SUB_UNIT[$count];
               $add->save();
            }
        }

    }else{
  


        $addinforequest = new Warehouserequest();

        $addinforequest->WAREHOUSE_REQUEST_CODE = $refnumber;
        $addinforequest->WAREHOUSE_DATE_WANT = $DATEWANT;
        $addinforequest->WAREHOUSE_DATE_TIME_SAVE = date('Y-m-d H:i:s');

        $addinforequest->WAREHOUSE_DEP_SUB_SUB_ID = $request->WAREHOUSE_DEP_SUB_SUB_ID;
    
        $addinforequest->WAREHOUSE_SAVE_HR_ID = $request->WAREHOUSE_SAVE_HR_ID;

          //----------------------------------
          $SAVEHR =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
          ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
          ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
          ->where('hrd_person.ID','=',$request->WAREHOUSE_SAVE_HR_ID)->first();

                $addinforequest->WAREHOUSE_SAVE_HR_NAME = $SAVEHR->HR_PREFIX_NAME.''.$SAVEHR->HR_FNAME.' '.$SAVEHR->HR_LNAME;
                $addinforequest->WAREHOUSE_SAVE_HR_POSITION = $SAVEHR->HR_POSITION_NAME;
                $addinforequest->WAREHOUSE_SAVE_HR_DEP_SUB_NAME = $SAVEHR->HR_DEPARTMENT_SUB_NAME;

           //----------------------------------

                $addinforequest->WAREHOUSE_AGREE_HR_ID = $request->WAREHOUSE_AGREE_HR_ID;

             //----------------------------------
             $AGREEHR =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
             ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
             ->where('hrd_person.ID','=',$request->WAREHOUSE_AGREE_HR_ID)->first();

                $addinforequest->WAREHOUSE_AGREE_HR_NAME = $AGREEHR->HR_PREFIX_NAME.''.$AGREEHR->HR_FNAME.' '.$AGREEHR->HR_LNAME;
                $addinforequest->WAREHOUSE_AGREE_HR_POSITION = $AGREEHR->HR_POSITION_NAME;

              //----------------------------------

                $addinforequest->WAREHOUSE_REQUEST_BUY_COMMENT = $request->WAREHOUSE_REQUEST_BUY_COMMENT;

                $addinforequest->WAREHOUSE_INVEN_ID = $request->WAREHOUSE_INVEN_ID;

                $addinforequest->WAREHOUSE_STATUS = 'Approve';

                $addinforequest->WAREHOUSE_BUDGET_YEAR = $request->WAREHOUSE_BUDGET_YEAR;

                $addinforequest->WAREHOUSE_SMALLHOS = $request->WAREHOUSE_SMALLHOS;
     
                $addinforequest->save();

                $WAREHOUSE_REQUEST_ID = Warehouserequest::max('WAREHOUSE_ID');

        if($request->WAREHOUSE_REQUEST_SUB_AMOUNT != '' || $request->WAREHOUSE_REQUEST_SUB_AMOUNT != null){

            $WAREHOUSE_REQUEST_SUB_DETAIL_ID = $request->WAREHOUSE_REQUEST_SUB_DETAIL_ID;
            $WAREHOUSE_REQUEST_SUB_AMOUNT = $request->WAREHOUSE_REQUEST_SUB_AMOUNT;
            $WAREHOUSE_REQUEST_SUB_UNIT = $request->WAREHOUSE_REQUEST_SUB_UNIT;

            $number =count($WAREHOUSE_REQUEST_SUB_DETAIL_ID);
            $count = 0;
            for($count = 0; $count< $number; $count++)
            {
               $add = new Warehouserequestsub();
               $add->WAREHOUSE_REQUEST_ID = $WAREHOUSE_REQUEST_ID;
               $add->WAREHOUSE_REQUEST_SUB_DETAIL_ID = $WAREHOUSE_REQUEST_SUB_DETAIL_ID[$count];
               $add->WAREHOUSE_REQUEST_SUB_AMOUNT = $WAREHOUSE_REQUEST_SUB_AMOUNT[$count];
               $add->WAREHOUSE_REQUEST_SUB_UNIT = $WAREHOUSE_REQUEST_SUB_UNIT[$count];
               $add->save();
            }
        }
        
        



}

        return redirect()->route('mwarehouse.disburse');
}




  //-===================================== เบิกจ่าย รพสต. ==========================================//
  public function disbursesmall(Request $request)
  {
      if($request->method() === 'POST'){
          $search = $request->get('search');
          $status = $request->get('INVEN_STATUS');
          $yearbudget = $request->get('YEAR_ID');
          $status_check = $request->get('SEND_STATUS');
          $datebigin = $request->get('DATE_BIGIN');
          $dateend = $request->get('DATE_END');
          session([
              'manager_warehouse.disburse.search' => $search,
              'manager_warehouse.disburse.status' => $status,
              'manager_warehouse.disburse.yearbudget' => $yearbudget,
              'manager_warehouse.disburse.status_check' => $status_check,
              'manager_warehouse.disburse.datebigin' => $datebigin,
              'manager_warehouse.disburse.dateend' => $dateend
          ]);
      }elseif(Session::has('manager_warehouse.disburse')){
          $search = session('manager_warehouse.disburse.search');
          $status = session('manager_warehouse.disburse.status');
          $yearbudget = session('manager_warehouse.disburse.yearbudget');
          $status_check = session('manager_warehouse.disburse.status_check');
          $datebigin = session('manager_warehouse.disburse.datebigin');
          $dateend = session('manager_warehouse.disburse.dateend');
      }else{
          $search = '';
          $status = '';
          $yearbudget = getBudgetyear();
          $status_check = '';
          $datebigin = date('01/m/Y');
          $dateend   = date('d/m/Y', strtotime(date('Y-m-1'). '+1month -1days'));
      }


      $date_arrary=explode("/",$datebigin);
      $y_sub_st = $date_arrary[2];
      if($y_sub_st >= 2500){
          $y = $y_sub_st-543;
      }else{
          $y = $y_sub_st;
      }
      $m = $date_arrary[1];
      $d = $date_arrary[0];
      $displaydate_bigen= $y."-".$m."-".$d." 00:00:00";
      $date_arrary_e=explode("/",$dateend);
      $y_sub_e = $date_arrary_e[2];
      if($y_sub_e >= 2500){
          $y_e = $y_sub_e-543;
      }else{
          $y_e = $y_sub_e;
      }
      $m_e = $date_arrary_e[1];
      $d_e = $date_arrary_e[0];
      $displaydate_end= $y_e."-".$m_e."-".$d_e." 23:59:59";

          $from = date($displaydate_bigen);
          $to = date($displaydate_end);

          $iduser = Auth::user()->PERSON_ID;

          if($status == null){
               
                $infoinvetfirst = DB::table('supplies_inven_permiss')
                ->leftjoin('supplies_inven','supplies_inven_permiss.INVENPERMIS_INVEN_ID','=','supplies_inven.INVEN_ID')
                ->where('INVENPERMIS_PERSON_ID','=',$iduser)
                ->where('ACTIVE','=','True')
                ->first();

                if($infoinvetfirst == null){
                  $statusfirst = '';
                }else{
                  $statusfirst =  $infoinvetfirst->INVENPERMIS_INVEN_ID;
                }

              if($status_check == null){
                  $inforwarehouserequest = Warehouserequest::leftJoin('warehouse_request_status','warehouse_request_status.STATUS_CODE','=','warehouse_request.WAREHOUSE_STATUS')
                  ->leftJoin('supplies_inven','supplies_inven.INVEN_ID','=','warehouse_request.WAREHOUSE_INVEN_ID')
                  ->leftJoin('warehouse_smallhos','warehouse_request.WAREHOUSE_SMALLHOS','=','warehouse_smallhos.WAREHOUSE_SMALLHOS_ID')
                  ->leftJoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','warehouse_request.WAREHOUSE_DEP_SUB_SUB_ID')
                  ->where('INVEN_ID','=',$statusfirst)
                  ->where('WAREHOUSE_SMALLHOS','<>','')
                  ->where(function($q) use ($search){
                      $q->where('WAREHOUSE_REQUEST_CODE','like','%'.$search.'%');
                      $q->orwhere('WAREHOUSE_REQUEST_BUY_COMMENT','like','%'.$search.'%');
                      $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');
                      $q->orwhere('WAREHOUSE_SAVE_HR_NAME','like','%'.$search.'%');
                 })
                  ->WhereBetween('WAREHOUSE_DATE_WANT',[$from,$to])
                  ->get();
              }else{
                  $inforwarehouserequest = Warehouserequest::leftJoin('warehouse_request_status','warehouse_request_status.STATUS_CODE','=','warehouse_request.WAREHOUSE_STATUS')
                  ->leftJoin('supplies_inven','supplies_inven.INVEN_ID','=','warehouse_request.WAREHOUSE_INVEN_ID')
                  ->leftJoin('warehouse_smallhos','warehouse_request.WAREHOUSE_SMALLHOS','=','warehouse_smallhos.WAREHOUSE_SMALLHOS_ID')
                  ->leftJoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','warehouse_request.WAREHOUSE_DEP_SUB_SUB_ID')
                  ->where('WAREHOUSE_STATUS','=',$status_check)
                  ->where('INVEN_ID','=',$statusfirst)
                  ->where('WAREHOUSE_SMALLHOS','<>','')
                  ->where(function($q) use ($search){
                      $q->where('WAREHOUSE_REQUEST_CODE','like','%'.$search.'%');
                      $q->orwhere('WAREHOUSE_REQUEST_BUY_COMMENT','like','%'.$search.'%');
                      $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');
                      $q->orwhere('WAREHOUSE_SAVE_HR_NAME','like','%'.$search.'%');
                 })
                  ->WhereBetween('WAREHOUSE_DATE_WANT',[$from,$to])
                  ->get();
              }
          }else{
              if($status_check == null){
                  $inforwarehouserequest = Warehouserequest::leftJoin('warehouse_request_status','warehouse_request_status.STATUS_CODE','=','warehouse_request.WAREHOUSE_STATUS')
                  ->leftJoin('supplies_inven','supplies_inven.INVEN_ID','=','warehouse_request.WAREHOUSE_INVEN_ID')
                  ->leftJoin('warehouse_smallhos','warehouse_request.WAREHOUSE_SMALLHOS','=','warehouse_smallhos.WAREHOUSE_SMALLHOS_ID')
                  ->leftJoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','warehouse_request.WAREHOUSE_DEP_SUB_SUB_ID')
                  ->where('INVEN_ID','=',$status)
                  ->where('WAREHOUSE_SMALLHOS','<>','')
                  ->where(function($q) use ($search){
                      $q->where('WAREHOUSE_REQUEST_CODE','like','%'.$search.'%');
                      $q->orwhere('WAREHOUSE_REQUEST_BUY_COMMENT','like','%'.$search.'%');
                      $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');
                      $q->orwhere('WAREHOUSE_SAVE_HR_NAME','like','%'.$search.'%');
                 })
                  ->WhereBetween('WAREHOUSE_DATE_WANT',[$from,$to])
                  ->get();
          }else{
              $inforwarehouserequest = Warehouserequest::leftJoin('warehouse_request_status','warehouse_request_status.STATUS_CODE','=','warehouse_request.WAREHOUSE_STATUS')
              ->leftJoin('supplies_inven','supplies_inven.INVEN_ID','=','warehouse_request.WAREHOUSE_INVEN_ID')
              ->leftJoin('warehouse_smallhos','warehouse_request.WAREHOUSE_SMALLHOS','=','warehouse_smallhos.WAREHOUSE_SMALLHOS_ID')
              ->leftJoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','warehouse_request.WAREHOUSE_DEP_SUB_SUB_ID')
              ->where('INVEN_ID','=',$status)
              ->where('WAREHOUSE_STATUS','=',$status_check)
              ->where('WAREHOUSE_SMALLHOS','<>','')
              ->where(function($q) use ($search){
                  $q->where('WAREHOUSE_REQUEST_CODE','like','%'.$search.'%');
                  $q->orwhere('WAREHOUSE_REQUEST_BUY_COMMENT','like','%'.$search.'%');
                  $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');
                  $q->orwhere('WAREHOUSE_SAVE_HR_NAME','like','%'.$search.'%');
             })
              ->WhereBetween('WAREHOUSE_DATE_WANT',[$from,$to])
              ->get();
          }
      }
   
   

      $infosuppliesinven = DB::table('supplies_inven_permiss')
      ->leftjoin('supplies_inven','supplies_inven_permiss.INVENPERMIS_INVEN_ID','=','supplies_inven.INVEN_ID')
      ->where('INVENPERMIS_PERSON_ID','=',$iduser)
      ->where('ACTIVE','=','True')
      ->get();

      $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
      $statussend = DB::table('warehouse_request_status')->get();
      $invenstatus_check = $status;  
      $status_check = $status_check;
      $year_id = $yearbudget;


      $openform_function = Warehouse_function::where('WAREHOUSEFORM_STATUS','=','True' )->first();
      if ($openform_function != '') {       
          $code = $openform_function->WAREHOUSEFORM_CODE;  
      } else {                      
          $code = '';
      }
  
      return view('manager_warehouse.warehousedisburse_small',[
          'inforwarehouserequests' => $inforwarehouserequest, 
          'infosuppliesinvens' => $infosuppliesinven, 
          'invenstatus_check' => $invenstatus_check,   
          'displaydate_bigen' => $displaydate_bigen,  
          'displaydate_end' => $displaydate_end, 
          'search' => $search,
          'year_id'=>$year_id,  
          'budgets' =>  $budget, 
          'statussends' => $statussend,  
          'status_check' => $status_check,  
          'codes'=>$code,
      ]);
  }



   
  

  public function infopayparcel_small(Request $request,$id)
  {
      
      $YEAR_ID =  $request->YEAR_ID;
      $DATE_BIGIN =  $request->DATE_BIGIN;
      $DATE_END =  $request->DATE_END;
      $SEND_STATUS =  $request->SEND_STATUS;
      $INVEN_STATUS =  $request->INVEN_STATUS;
      $search =  $request->search;

      $infowarehouserequest = DB::table('warehouse_request')
      ->leftJoin('warehouse_smallhos','warehouse_smallhos.WAREHOUSE_SMALLHOS_ID','=','warehouse_request.WAREHOUSE_SMALLHOS')
      ->where('WAREHOUSE_ID','=',$id)->first();

      $infowarehouserequestsub = DB::table('warehouse_request_sub')
      ->leftJoin('supplies','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_DETAIL_ID','=','supplies.ID')
      ->leftJoin('supplies_unit_ref','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_UNIT','=','supplies_unit_ref.ID')
      ->where('WAREHOUSE_REQUEST_ID','=',$id)->get();
      
      
      $count = DB::table('warehouse_request_sub')->where('WAREHOUSE_REQUEST_ID','=',$id)->count();

      $infosupplies= Supplies::leftJoin('supplies_type','supplies.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
      ->leftJoin('supplies_type_kind','supplies.SUP_TYPE_KIND_ID','=','supplies_type_kind.SUP_TYPE_KIND_ID')
      ->where('supplies_type_kind.SUP_TYPE_MASTER_ID','=',1)
      ->orderBy('ID', 'desc') 
      ->get();

      $infosuppliesunitref = DB::table('supplies_unit_ref')->get();


      $infosuppliesdepsubsup = DB::table('hrd_department_sub_sub')
      ->leftjoin('hrd_department_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
      ->get();   
      
      
      $warehousedisbursecycle = DB::table('warehouse_disburse_cycle')->get();   


      return view('manager_warehouse.warehousedisburse_parcelsmall',[
          'infowarehouserequest' => $infowarehouserequest,
          'infowarehouserequestsubs' => $infowarehouserequestsub,
          'infosuppliesunitrefs' => $infosuppliesunitref,
          'infosuppliess' => $infosupplies,
          'infosuppliesdepsubsups' => $infosuppliesdepsubsup,
          'warehousedisbursecycles' => $warehousedisbursecycle,
          'count' => $count,
          'YEAR_ID' => $YEAR_ID,
          'DATE_BIGIN' => $DATE_BIGIN,
          'DATE_END' => $DATE_END,
          'SEND_STATUS' => $SEND_STATUS,
          'INVEN_STATUS' => $INVEN_STATUS,
          'search' => $search,
         
          
      ]);
  }


  

  public function updateinfopayparcel_small(Request $request)
  {
          
    
           $WAREPAYDAY =  $request->WAREHOUSE_PAYDAY;

          if($WAREPAYDAY != ''){
              $PAYDAY = Carbon::createFromFormat('d/m/Y', $WAREPAYDAY)->format('Y-m-d');
              $date_arrary_st=explode("-",$PAYDAY);  
              $y_sub_st = $date_arrary_st[0]; 
              
              if($y_sub_st >= 2500){
                  $y_st = $y_sub_st-543;
              }else{
                  $y_st = $y_sub_st;
              }
              $m_st = $date_arrary_st[1];
              $d_st = $date_arrary_st[2];  
              $WAREHOUSEPAYDAY= $y_st."-".$m_st."-".$d_st;
              }else{
              $WAREHOUSEPAYDAY= null;
          }

          $WAREHOUSE_ID = $request->WAREHOUSE_ID;

          $SUBMIT = $request->SUBMIT;
       

        if($SUBMIT == 'not_approved'){
          $statusapp = 'Disverify';
        }else{
          $statusapp = 'Verify';
        }


          $addinfowarehouserequest = Warehouserequest::find($WAREHOUSE_ID);
          $addinfowarehouserequest->WAREHOUSE_TYPE_CYCLE = $request->WAREHOUSE_TYPE_CYCLE;
          $addinfowarehouserequest->WAREHOUSE_PAYDAY = $WAREHOUSEPAYDAY;
          $addinfowarehouserequest->WAREHOUSE_USER_CONFIRM_CHECK_ID = $request->WAREHOUSE_USER_CONFIRM_CHECK_ID;

          $PERSON =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
          ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
          ->where('hrd_person.ID','=',$request->WAREHOUSE_USER_CONFIRM_CHECK_ID)->first();
          $addinfowarehouserequest->WAREHOUSE_USER_CONFIRM_CHECK_NAME = $PERSON->HR_PREFIX_NAME.''.$PERSON->HR_FNAME.' '.$PERSON->HR_LNAME;    
         
          $addinfowarehouserequest->WAREHOUSE_USER_CONFIRM_CHECK_DATE = date('Y-m-d H:i:s');
          $addinfowarehouserequest->WAREHOUSE_STATUS = $statusapp;     
          $addinfowarehouserequest->save();



          Warehouserequestsub::where('WAREHOUSE_REQUEST_ID','=',$WAREHOUSE_ID)->delete(); 

          if($request->WAREHOUSE_REQUEST_SUB_DETAIL_ID != '' || $request->WAREHOUSE_REQUEST_SUB_DETAIL_ID != null){

              $WAREHOUSE_REQUEST_SUB_DETAIL_ID = $request->WAREHOUSE_REQUEST_SUB_DETAIL_ID;
              $WAREHOUSE_REQUEST_SUB_UNIT = $request->WAREHOUSE_REQUEST_SUB_UNIT;
              $WAREHOUSE_REQUEST_SUB_AMOUNT = $request->WAREHOUSE_REQUEST_SUB_AMOUNT;
              $WAREHOUSE_REQUEST_SUB_PRICE = $request->WAREHOUSE_REQUEST_SUB_PRICE;
              $WAREHOUSE_REQUEST_SUB_LOT = $request->WAREHOUSE_REQUEST_SUB_LOT;
              
             
              $WAREHOUSE_REQUEST_SUB_GEN_DATE = $request->WAREHOUSE_REQUEST_SUB_GEN_DATE;
              $WAREHOUSE_REQUEST_SUB_EXP_DATE = $request->WAREHOUSE_REQUEST_SUB_EXP_DATE;
              $WAREHOUSE_REQUEST_SUB_AMOUNT_PAY = $request->WAREHOUSE_REQUEST_SUB_AMOUNT_PAY;
              $RECEIVE_SUB_ID = $request->RECEIVE_SUB_ID;
              
              $number =count($WAREHOUSE_REQUEST_SUB_DETAIL_ID);
              $count = 0;
              for($count = 0; $count< $number; $count++)
              {
   
                if($WAREHOUSE_REQUEST_SUB_GEN_DATE[$count] != ''){
                   $DAY =$WAREHOUSE_REQUEST_SUB_GEN_DATE[$count];
                   $date_arrary_st=explode("-",$DAY);
                   $y_sub_st = $date_arrary_st[0];
   
                   if($y_sub_st >= 2500){
                       $y_st = $y_sub_st-543;
                   }else{
                       $y_st = $y_sub_st;
                   }
                   $m_st = $date_arrary_st[1];
                   $d_st = $date_arrary_st[2];
                   $GENDATE= $y_st."-".$m_st."-".$d_st;
                   }else{
                   $GENDATE= null;
               }

               if($WAREHOUSE_REQUEST_SUB_EXP_DATE[$count] != ''){
                  $DAY = $WAREHOUSE_REQUEST_SUB_EXP_DATE[$count];
                  $date_arrary_st=explode("-",$DAY);
                  $y_sub_st = $date_arrary_st[0];
  
                  if($y_sub_st >= 2500){
                      $y_st = $y_sub_st-543;
                  }else{
                      $y_st = $y_sub_st;
                  }
                  $m_st = $date_arrary_st[1];
                  $d_st = $date_arrary_st[2];
                  $EXPDATE= $y_st."-".$m_st."-".$d_st;
                  }else{
                  $EXPDATE= null;
              }

                  $add = new Warehouserequestsub();
                  $add->WAREHOUSE_REQUEST_ID = $WAREHOUSE_ID;
               
                 $add->WAREHOUSE_REQUEST_SUB_DETAIL_ID = $WAREHOUSE_REQUEST_SUB_DETAIL_ID[$count];

                 $add->WAREHOUSE_REQUEST_SUB_UNIT = isset($WAREHOUSE_REQUEST_SUB_UNIT[$count]) ? $WAREHOUSE_REQUEST_SUB_UNIT[$count] : null;
                 $add->WAREHOUSE_REQUEST_SUB_AMOUNT = $WAREHOUSE_REQUEST_SUB_AMOUNT[$count];
                 $add->WAREHOUSE_REQUEST_SUB_PRICE = $WAREHOUSE_REQUEST_SUB_PRICE[$count];
                 $add->WAREHOUSE_REQUEST_SUB_SUM_PRICE = $WAREHOUSE_REQUEST_SUB_AMOUNT_PAY[$count] *$WAREHOUSE_REQUEST_SUB_PRICE[$count];
                 $add->WAREHOUSE_REQUEST_SUB_LOT = $WAREHOUSE_REQUEST_SUB_LOT[$count];
                 $add->WAREHOUSE_REQUEST_SUB_GEN_DATE = $GENDATE;
                 $add->WAREHOUSE_REQUEST_SUB_EXP_DATE = $EXPDATE;
                 $add->WAREHOUSE_REQUEST_SUB_AMOUNT_PAY = $WAREHOUSE_REQUEST_SUB_AMOUNT_PAY[$count];

                 $add->RECEIVE_SUB_ID = $RECEIVE_SUB_ID[$count];
                 $add->save();


              }
          }

     
          //========================================================================

          $search =  $request->search;
          $year_id =  $request->YEAR_ID;
          $status_check = $request->SEND_STATUS;
          $displaydate_bigen = $request->DATE_BIGIN;
          $displaydate_end = $request->DATE_END;
          $invenstatus_check = $request->INVEN_STATUS;

          $openform_function = Warehouse_function::where('WAREHOUSEFORM_STATUS','=','True' )->first();

          if ($openform_function != '') {       
              $code = $openform_function->WAREHOUSEFORM_CODE;  
          } else {                      
              $code = '';
          }
    

          return redirect()->route('mwarehouse.disbursesmall',[
              'YEAR_ID' => $year_id,
              'DATE_BIGIN' => $displaydate_bigen,
              'DATE_END' => $displaydate_end,
              'SEND_STATUS' => $status_check,
              'INVEN_STATUS' => $invenstatus_check,
              'codes'=>$code,
              'search' => $search ]);
  }




  
    //==================อนุมัติ=====


    public function warehouserequestlastapp_small(Request $request,$id)
    {
        
        $inforwarehouserequest = DB::table('warehouse_request')->where('WAREHOUSE_ID','=',$id)->first();

        return view('manager_warehouse.warehouserequestlastapp_small',[
            'inforwarehouserequest' => $inforwarehouserequest,  
            
        ]);
    }

public function updatewarehouserequestlastapp_small(Request $request)
{
  
    $id = $request->WAREHOUSE_ID;
    $check =  $request->SUBMIT;

    if($check == 'approved'){
      $statuscode = 'Allow';
    }else{
      $statuscode = 'Disallow';
    }


      $updatelastapp = Warehouserequest::find($id);
      $updatelastapp->WAREHOUSE_STATUS = $statuscode;
      $updatelastapp->WAREHOUSE_TOP_LEADER_AC_COMMENT = $request->WAREHOUSE_TOP_LEADER_AC_COMMENT;
      $updatelastapp->WAREHOUSE_TOP_LEADER_AC_ID = $request->WAREHOUSE_TOP_LEADER_AC_ID;

     
      //----------------------------------
      $TOPLEADER=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
      ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
      ->where('hrd_person.ID','=',$request->WAREHOUSE_TOP_LEADER_AC_ID)->first();

       $updatelastapp->WAREHOUSE_TOP_LEADER_AC_NAME = $TOPLEADER->HR_PREFIX_NAME.''.$TOPLEADER->HR_FNAME.' '.$TOPLEADER->HR_LNAME;
       //----------------------------------
       $updatelastapp->WAREHOUSE_TOP_LEADER_AC_DATE_TIME = date('Y-m-d H:i:s');



      $updatelastapp->save();



      if($statuscode = 'Allow'){

        $infowarehouserequest = Warehouserequest::where('WAREHOUSE_ID','=',$id)->first();
        $infowarehouserequestsub = Warehouserequestsub::where('WAREHOUSE_REQUEST_ID','=',$id)->get();


 
 
        foreach ($infowarehouserequestsub as $checkwarehouserequestsub) {

     
      
            $RECEIVENAME = DB::table('supplies')->where('ID','=',$checkwarehouserequestsub->WAREHOUSE_REQUEST_SUB_DETAIL_ID)->first();
            $countcheck  =  DB::table('warehouse_treasury_small')->where('TREASURY_SMALL_CODE','=',$RECEIVENAME->SUP_FSN_NUM)->where('TREASURY_SMALL_TYPE','=',$infowarehouserequest->WAREHOUSE_SMALLHOS)->count();

            if($countcheck == 0 ){


                $addWarehousetreasury = new Warehousetreasurysmall();
            
                $addWarehousetreasury->TREASURY_SMALL_CODE =  $RECEIVENAME->SUP_FSN_NUM;    
                $addWarehousetreasury->TREASURY_SMALL_NAME = $RECEIVENAME->SUP_NAME;
                $addWarehousetreasury->TREASURY_SMALL_TYPE = $infowarehouserequest->WAREHOUSE_SMALLHOS;
                $STORETYPENAME = DB::table('warehouse_smallhos')->where('WAREHOUSE_SMALLHOS_ID','=',$infowarehouserequest->WAREHOUSE_SMALLHOS)->first();
                $addWarehousetreasury->TREASURY_SMALL_TYPE_NAME = $STORETYPENAME->WAREHOUSE_SMALLHOS_NAME;

                $addWarehousetreasury->TREASURY_SMALL_UNIT = $checkwarehouserequestsub->WAREHOUSE_REQUEST_SUB_UNIT;
                $addWarehousetreasury->TREASURY_SMALL_SUP_ID = $RECEIVENAME->ID;

                $addWarehousetreasury->save();

            }

    

            $RECEIVESUBNAME2 = DB::table('supplies')->where('ID','=',$checkwarehouserequestsub->WAREHOUSE_REQUEST_SUB_DETAIL_ID)->first();
            $checkdatacut = DB::table('warehouse_store_export_sub')
            ->where('RECEIVE_SUB_ID','=',$checkwarehouserequestsub->RECEIVE_SUB_ID)
            ->where('WAREHOUSE_REQUEST_CODE','=',$infowarehouserequest->WAREHOUSE_REQUEST_CODE)
            ->where('EXPORT_SUB_NAME','=',$RECEIVESUBNAME2->SUP_NAME)
            ->where('EXPORT_SUB_LOT','=',$checkwarehouserequestsub->WAREHOUSE_REQUEST_SUB_LOT)
            ->count();
         
         

            if($checkdatacut == 0 ){
         
            //------------------------ตัดออกจากคลังหลัก-------


            $stor_id  =  DB::table('warehouse_store')->where('STORE_CODE','=',$RECEIVENAME->SUP_FSN_NUM)->first();

            $addstore = new Warehousestoreexportsub();
       
            $addstore->RECEIVE_SUB_ID = $checkwarehouserequestsub->RECEIVE_SUB_ID;
           
            $addstore->EXPORT_SUB_NAME = $RECEIVESUBNAME2->SUP_NAME;
    
      
            $addstore->EXPORT_SUB_UNIT = $checkwarehouserequestsub->WAREHOUSE_REQUEST_SUB_UNIT;
            $addstore->EXPORT_SUB_AMOUNT = $checkwarehouserequestsub->WAREHOUSE_REQUEST_SUB_AMOUNT_PAY;
            $addstore->EXPORT_SUB_PICE_UNIT = $checkwarehouserequestsub->WAREHOUSE_REQUEST_SUB_PRICE;
            $addstore->EXPORT_SUB_VALUE =$checkwarehouserequestsub->WAREHOUSE_REQUEST_SUB_AMOUNT_PAY*$checkwarehouserequestsub->WAREHOUSE_REQUEST_SUB_PRICE;
            $addstore->EXPORT_SUB_LOT = $checkwarehouserequestsub->WAREHOUSE_REQUEST_SUB_LOT;
            $addstore->EXPORT_SUB_GEN_DATE = $checkwarehouserequestsub->WAREHOUSE_REQUEST_SUB_GEN_DATE;
            $addstore->EXPORT_SUB_EXP_DATE = $checkwarehouserequestsub->WAREHOUSE_REQUEST_SUB_EXP_DATE;

            $addstore->EXPORT_SUB_TREASURY_ID =  $infowarehouserequest->WAREHOUSE_SMALLHOS;
            $addstore->EXPORT_SUB_USER_ID =  $infowarehouserequest->WAREHOUSE_SAVE_HR_ID;
            
    
            $addstore->STORE_ID = $stor_id->STORE_ID ;

            $addstore->WAREHOUSE_REQUEST_CODE = $infowarehouserequest->WAREHOUSE_REQUEST_CODE;
            $addstore->WAREHOUSE_TYPE_CYCLE = $infowarehouserequest->WAREHOUSE_TYPE_CYCLE;
            $addstore->save();


    
            

            //------------------------รับเข้าคลัง รพสต.-------
            $treasury_id  =  DB::table('warehouse_treasury_small')->where('TREASURY_SMALL_CODE','=',$RECEIVENAME->SUP_FSN_NUM)->where('TREASURY_SMALL_TYPE','=',$infowarehouserequest->WAREHOUSE_SMALLHOS)->first();

            $addwarehousetreasury = new Warehousetreasuryreceivesmall();
          
            $addwarehousetreasury->TREASURY_RECEIVE_ID = $infowarehouserequest->WAREHOUSE_ID;
    
            $RECEIVESUBNAME3 = DB::table('supplies')->where('ID','=',$checkwarehouserequestsub->WAREHOUSE_REQUEST_SUB_DETAIL_ID)->first();
            $addwarehousetreasury->TREASURY_RECEIVE_SMALL_NAME = $RECEIVESUBNAME3->SUP_NAME;
    
  
            $addwarehousetreasury->TREASURY_RECEIVE_SMALL_UNIT = $checkwarehouserequestsub->WAREHOUSE_REQUEST_SUB_UNIT;
            $addwarehousetreasury->TREASURY_RECEIVE_SMALL_AMOUNT = $checkwarehouserequestsub->WAREHOUSE_REQUEST_SUB_AMOUNT_PAY;
            $addwarehousetreasury->TREASURY_RECEIVE_SMALL_PICE_UNIT = $checkwarehouserequestsub->WAREHOUSE_REQUEST_SUB_PRICE;
            $addwarehousetreasury->TREASURY_RECEIVE_SMALL_VALUE =$checkwarehouserequestsub->WAREHOUSE_REQUEST_SUB_AMOUNT_PAY*$checkwarehouserequestsub->WAREHOUSE_REQUEST_SUB_PRICE;
            $addwarehousetreasury->TREASURY_RECEIVE_SMALL_LOT = $checkwarehouserequestsub->WAREHOUSE_REQUEST_SUB_LOT;
            $addwarehousetreasury->TREASURY_RECEIVE_SMALL_GEN_DATE = $checkwarehouserequestsub->WAREHOUSE_REQUEST_SUB_GEN_DATE;
            $addwarehousetreasury->TREASURY_RECEIVE_SMALL_EXP_DATE = $checkwarehouserequestsub->WAREHOUSE_REQUEST_SUB_EXP_DATE;
            $addwarehousetreasury->WAREHOUSE_REQUEST_SMALL_ID = $checkwarehouserequestsub->WAREHOUSE_REQUEST_SUB_ID;

    
            $addwarehousetreasury->TREASURY_ID = $treasury_id->TREASURY_SMALL_ID ;
            $addwarehousetreasury->save();


        }



      }
    }

      return redirect()->route('mwarehouse.disbursesmall');
}





public function reportcheckmin(Request $request)
{
    $iduser = Auth::user()->PERSON_ID;



        $infowarehousestore= DB::table('warehouse_store')
        ->leftJoin('supplies_unit_ref', 'warehouse_store.STORE_UNIT', '=', 'supplies_unit_ref.ID') 
        ->leftJoin('supplies', 'warehouse_store.STORE_CODE', '=', 'supplies.SUP_FSN_NUM')           
        ->leftJoin('supplies_type', 'supplies_type.SUP_TYPE_ID', '=', 'supplies.SUP_TYPE_ID')                     
        ->orderBy('STORE_ID', 'desc')
        ->get();
          

    return view('manager_warehouse.warehousereportcheckmin',[
         'infowarehousestores' => $infowarehousestore,
    ]);
}

public static function checkmin($code)
{
     $totalmin  =  DB::table('supplies')->where('SUP_FSN_NUM','=',$code)->first();

     if($totalmin->MIN == null || $totalmin->MIN == ''){
        $resulttotalmin =  0;
     }else{
        $resulttotalmin =  $totalmin->MIN;
     }
   
     return $resulttotalmin;
}



  //-----------------------------โควต้าหน่วยงาน


  public function warehousesetquotadep()
  {
    
      $infodepsub = DB::table('hrd_department_sub_sub')->where('ACTIVE','=','True')->get();                       
     
      return view('manager_warehouse.warehousesetquotadep',[
          'infodepsubs' => $infodepsub
      ]);
  }



  public function warehousesetquotadep_setquota(Request $request,$idref)
  {

      $infoasset =  Supplies::where('ACTIVE','=',True)->get();

      $infotreasuryquota =  DB::table('warehouse_treasury_quota')->where('WAREHOUSE_TREASARY_QUOTA_DEP_ID','=',$idref)->get();
      $countcheck =  DB::table('warehouse_treasury_quota')->where('WAREHOUSE_TREASARY_QUOTA_DEP_ID','=',$idref)->count();

      $detaildep = DB::table('hrd_department_sub_sub')->where('HR_DEPARTMENT_SUB_SUB_ID','=',$idref)->first();
  
      return view('manager_warehouse.warehousesetquotadep_setquota',[
          'infoassets' => $infoasset,
          'infotreasuryquotas' => $infotreasuryquota,
          'countcheck' => $countcheck,
          'detaildep' => $detaildep,
      ]);
      
  }


  public function savewarehousesetquotadep_setquota(Request $request)
  {

      $DEPID = $request->DEPID;

      Warehousetreasuryquota::where('WAREHOUSE_TREASARY_QUOTA_DEP_ID','=',$DEPID)->delete(); 

      if($request->WAREHOUSE_TREASARY_QUOTA_SUP_ID[0] != '' || $request->WAREHOUSE_TREASARY_QUOTA_SUP_ID[0] != null){
          
          $WAREHOUSE_TREASARY_QUOTA_SUP_ID = $request->WAREHOUSE_TREASARY_QUOTA_SUP_ID;
          $WAREHOUSE_TREASARY_QUOTA_AMOUNT = $request->WAREHOUSE_TREASARY_QUOTA_AMOUNT;
          $WAREHOUSE_TREASARY_QUOTA_MIN = $request->WAREHOUSE_TREASARY_QUOTA_MIN;
          $WAREHOUSE_TREASARY_QUOTA_MAX = $request->WAREHOUSE_TREASARY_QUOTA_MAX;

          $number =count($WAREHOUSE_TREASARY_QUOTA_SUP_ID);
          $count = 0;
          for($count = 0; $count < $number; $count++)
          {  
        
             $addlist = new Warehousetreasuryquota();
             $addlist->WAREHOUSE_TREASARY_QUOTA_DEP_ID = $DEPID; 
             $addlist->WAREHOUSE_TREASARY_QUOTA_SUP_ID = $WAREHOUSE_TREASARY_QUOTA_SUP_ID[$count];
             $addlist->WAREHOUSE_TREASARY_QUOTA_AMOUNT = $WAREHOUSE_TREASARY_QUOTA_AMOUNT[$count];
             $addlist->WAREHOUSE_TREASARY_QUOTA_MIN = $WAREHOUSE_TREASARY_QUOTA_MIN[$count];
             $addlist->WAREHOUSE_TREASARY_QUOTA_MAX = $WAREHOUSE_TREASARY_QUOTA_MAX[$count];
             
             $infosup = DB::table('supplies')->where('ID','=',$WAREHOUSE_TREASARY_QUOTA_SUP_ID[$count])->first();

             $addlist->WAREHOUSE_TREASARY_QUOTA_SUP_CODE = $infosup->SUP_FSN_NUM;
             $addlist->save(); 
           
             
          }
      }

  
      return redirect()->route('mwarehouse.warehousesetquotadep_setquota',[
                                'idref' => $DEPID
      ]);
      
 
      
  }


}

