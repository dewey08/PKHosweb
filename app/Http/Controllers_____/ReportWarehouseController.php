<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
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
use App\Models\Warehousecheckreceive_sum;
use App\Models\Warehousereportmain;
use Session;
use Cookie;

date_default_timezone_set("Asia/Bangkok");

class ReportWarehouseController extends Controller
{
  
     //---คลังหลัก

    public function storehouse(Request $request)
    {
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

//********************************* */ ยอดยกมา คลังหลัก /* ***********************************************************//
public static function valueforwardstore($SUPTYPE)
{
    $date_b = date('Y-m-d', strtotime(date('Y-m-d')." -1 month"));
    
     $sumvaluereceive  =  DB::table('warehouse_store_receive_sub')
        // ->select('RECEIVE_SUB_VALUE')
        ->leftJoin('warehouse_store','warehouse_store_receive_sub.STORE_ID','=','warehouse_store.STORE_ID')
        // ->leftJoin('supplies','warehouse_store.STORE_SUP_ID','=','supplies.ID')
        ->leftJoin('warehouse_check_receive','warehouse_store_receive_sub.RECEIVE_ID','=','warehouse_check_receive.RECEIVE_ID')
        ->where('warehouse_store.STORE_SUPPLIES_TYPE','=',$SUPTYPE)
        ->where('warehouse_check_receive.RECEIVE_CHECK_DATE','<',$date_b)
        ->sum('RECEIVE_SUB_VALUE');

     $sumvalueexport  =  DB::table('warehouse_store_export_sub')
        // ->select('warehouse_store_export_sub.EXPORT_SUB_VALUE')
        ->leftJoin('warehouse_store_receive_sub','warehouse_store_receive_sub.RECEIVE_SUB_ID','=','warehouse_store_export_sub.RECEIVE_SUB_ID')
        ->leftJoin('warehouse_store','warehouse_store_receive_sub.STORE_ID','=','warehouse_store.STORE_ID')
        // ->leftJoin('supplies','warehouse_store.STORE_SUP_ID','=','supplies.ID')
        ->leftJoin('warehouse_request','warehouse_request.WAREHOUSE_REQUEST_CODE','=','warehouse_store_export_sub.WAREHOUSE_REQUEST_CODE')
        ->where('warehouse_store.STORE_SUPPLIES_TYPE','=',$SUPTYPE)
        ->where('warehouse_request.WAREHOUSE_PAYDAY','<',$date_b)
        ->sum('warehouse_store_export_sub.EXPORT_SUB_VALUE');
   
     $sumvalue =  $sumvaluereceive -   $sumvalueexport ;   
   
     return $sumvalue ;
}

//********************************* */ รวม 1  /* ***********************************************************//

public static function value_sum($SUPTYPE)
{
    $date_b = date('Y-m-d', strtotime(date('Y-m-d')." -1 month"));
     $sumvaluereceive1  =  DB::table('warehouse_treasury_receive_sub')
    //  ->select('TREASURY_RECEIVE_SUB_VALUE')
     ->leftJoin('warehouse_treasury','warehouse_treasury_receive_sub.TREASURY_ID','=','warehouse_treasury.TREASURY_ID')
    //  ->leftJoin('supplies','warehouse_treasury.TREASURY_CODE','=','supplies.SUP_FSN_NUM')
     ->where('SUPPLIES_TYPE','=',$SUPTYPE)
     ->where('warehouse_treasury_receive_sub.created_at','<',$date_b)
     ->sum('TREASURY_RECEIVE_SUB_VALUE');
   
     $sumvalueexport1  =  DB::table('warehouse_treasury_export_sub')
    //  ->select('warehouse_treasury_export_sub.TREASURY_EXPORT_SUB_VALUE')
     ->leftJoin('warehouse_treasury_receive_sub','warehouse_treasury_receive_sub.TREASURY_RECEIVE_SUB_ID','=','warehouse_treasury_export_sub.TREASURY_RECEIVE_SUB_ID')
     ->leftJoin('warehouse_treasury','warehouse_treasury_receive_sub.TREASURY_ID','=','warehouse_treasury.TREASURY_ID')
    //  ->leftJoin('supplies','warehouse_treasury.TREASURY_CODE','=','supplies.SUP_FSN_NUM')
     ->where('SUPPLIES_TYPE','=',$SUPTYPE)
    ->where('warehouse_treasury_export_sub.created_at','<',$date_b)
     ->sum('warehouse_treasury_export_sub.TREASURY_EXPORT_SUB_VALUE');
   
     $sumvalue1 =  $sumvaluereceive1 -  $sumvalueexport1; 

     $sumvaluereceive  =  DB::table('warehouse_store_receive_sub')
    //  ->select('RECEIVE_SUB_VALUE')
     ->leftJoin('warehouse_store','warehouse_store_receive_sub.STORE_ID','=','warehouse_store.STORE_ID')
    //  ->leftJoin('supplies','warehouse_store.STORE_SUP_ID','=','supplies.ID')
     ->leftJoin('warehouse_check_receive','warehouse_store_receive_sub.RECEIVE_ID','=','warehouse_check_receive.RECEIVE_ID')
     ->where('warehouse_store.STORE_SUPPLIES_TYPE','=',$SUPTYPE)
     ->where('warehouse_check_receive.RECEIVE_CHECK_DATE','<',$date_b)
     ->sum('RECEIVE_SUB_VALUE');

  $sumvalueexport = DB::table('warehouse_store_export_sub')
    //  ->select('warehouse_store_export_sub.EXPORT_SUB_VALUE')
     ->leftJoin('warehouse_store_receive_sub','warehouse_store_receive_sub.RECEIVE_SUB_ID','=','warehouse_store_export_sub.RECEIVE_SUB_ID')
     ->leftJoin('warehouse_store','warehouse_store_receive_sub.STORE_ID','=','warehouse_store.STORE_ID')
    //  ->leftJoin('supplies','warehouse_store.STORE_SUP_ID','=','supplies.ID')
     ->leftJoin('warehouse_request','warehouse_request.WAREHOUSE_REQUEST_CODE','=','warehouse_store_export_sub.WAREHOUSE_REQUEST_CODE')
     ->where('warehouse_store.STORE_SUPPLIES_TYPE','=',$SUPTYPE)
     ->where('warehouse_request.WAREHOUSE_PAYDAY','<',$date_b)
     ->sum('warehouse_store_export_sub.EXPORT_SUB_VALUE');

  $sumvalue = $sumvaluereceive - $sumvalueexport ; 

  $sumvaluereceivemount  =  DB::table('warehouse_store_receive_sub')
//   ->select('RECEIVE_SUB_VALUE')
  ->leftJoin('warehouse_store','warehouse_store_receive_sub.STORE_ID','=','warehouse_store.STORE_ID')
//   ->leftJoin('supplies','warehouse_store.STORE_SUP_ID','=','supplies.ID')
  ->leftJoin('warehouse_check_receive','warehouse_store_receive_sub.RECEIVE_ID','=','warehouse_check_receive.RECEIVE_ID')
  ->where('warehouse_store.STORE_SUPPLIES_TYPE','=',$SUPTYPE)
  ->where('warehouse_check_receive.RECEIVE_CHECK_DATE','>=',$date_b)  
  ->sum('RECEIVE_SUB_VALUE');

  $value_sum = $sumvalue1 + $sumvalue + $sumvaluereceivemount;
    
   
     return $value_sum ;
}
//********************************* */ ซื้อระหว่างเดือน /* ***********************************************************//

public static function valueforwardstoreinmonth($SUPTYPE)
{
    $date_b = date('Y-m-d', strtotime(date('Y-m-d')." -1 month"));
     $sumvaluereceive  =  DB::table('warehouse_store_receive_sub')
    //  ->select('RECEIVE_SUB_VALUE')
     ->leftJoin('warehouse_store','warehouse_store_receive_sub.STORE_ID','=','warehouse_store.STORE_ID')
    //  ->leftJoin('supplies','warehouse_store.STORE_SUP_ID','=','supplies.ID')
     ->leftJoin('warehouse_check_receive','warehouse_store_receive_sub.RECEIVE_ID','=','warehouse_check_receive.RECEIVE_ID')
     ->where('supplies.SUP_TYPE_ID','=',$SUPTYPE)
     ->where('warehouse_check_receive.RECEIVE_CHECK_DATE','>=',$date_b)  
     ->sum('RECEIVE_SUB_VALUE');


    //  $sumvaluereceive  = Warehousecheckreceive::select([
    //     'RECEIVE_CODE',SUP_TYPE_ID
    //     \DB::raw('RECEIVE_CHECK_DATE'),
    //     \DB::raw('COUNT(RECEIVE_CODE) as CODE'),
    //     \DB::raw('SUM(RECEIVE_VALUE) as total')
    // ])
    // ->leftJoin('warehouse_store_receive_sub','warehouse_store_receive_sub.RECEIVE_ID','=','warehouse_check_receive.RECEIVE_ID')
    // ->get();
   
     return $sumvaluereceive ;
}

public function reportstore_main(Request $request)
{
    // $month = date('Y-m-d', strtotime(date('Y-m-d')." -1 month"));
   
    if(!empty($request->_token)){
        $year_max = $request->get('YEAR_ID');
        $month    = $request->get('SEND_MONTH');      
        session([
            'manager_warehouse.reportstore_main.year_max' => $year_max,
            'manager_warehouse.reportstore_main.month' => $month,            
        ]);
    }elseif(!empty(session('manager_warehouse.reportstore_main'))){
        $year_max = session('manager_warehouse.reportstore_main.year_max');
        $month = session('manager_warehouse.reportstore_main.month');
    //   dd($month);  
    }else{
        $year_max = getBudgetyear();
        $month = date('m'); 
    }
    // dd($month);    
    $infosuptype = DB::table('supplies_type')->where('SUP_TYPE_MASTER_ID','=',1)->get();

    $countreport = DB::table('warehouse_reportmain')
    ->count();  

    $button_statust = DB::table('warehouse_reportmain_status')->WHERE('REPMAIN_STATUS_ACTIVE','=','TRUE')->first();
     
    if($button_statust == null){
        $buttonstatust = 'null';
    }else{
        $buttonstatust = $button_statust;
    }

    $inforeportss = DB::table('warehouse_reportmain')
    ->latest()
    ->first();
    // dd($inforeportss); 

    if ($countreport == null) {
        $inforeportmain = DB::table('warehouse_reportmain')   
            ->get();
    } else {
        $inforeportmain = DB::table('warehouse_reportmain')
            ->where('REPMAIN_MOUNT','=',$inforeportss->REPMAIN_MOUNT)  
            ->get();
    }
    
    

    $budget = DB::table('budget_year')
    ->where('ACTIVE','=','True')
    ->get();

    $inforeportmaindate = DB::table('warehouse_reportmain')->get(); 
    // dd($maxid);
    return view('manager_warehouse.reportstore_main',[
        'infosuptypes'          => $infosuptype,
        'countreports'          => $countreport, 
        'inforeportmains'       => $inforeportmain, 
        'year_max'              => $year_max,
        'm_budget'              => $month,
        'budgets'               => $budget,
        'buttonstatust'         => $buttonstatust,
    ]);
}
public function reportstore_main_insert(Request $request)
{    
 
    $validator = Validator::make($request->all(),[
        'YEAR_ID'        => 'required|max:191',
        'SEND_MONTH'     => 'required|max:191',   
        // 'image'     => 'required|image|mimes:jpeg,png,jpg|max:2048',  ****  รูปภาพ
    ]);
  
    if ($validator->fails()) {
        return response()->json([
            'status'  =>  400,
            'errors'  =>  $validator->messages()
        ]);
    } else {

        // $add_year = $request->input('YEAR_ID');
        // $add_mount = $request->input('SEND_MONTH');
        // $reportmain = DB::table('supplies_type')->where('SUP_TYPE_MASTER_ID','=',1)->count();

        $reportmain = DB::table('supplies_type')->where('SUP_TYPE_MASTER_ID','=',1)->get();
        foreach ($reportmain as $value) {
            $iditem = $value->SUP_TYPE_ID;
            $nameitem = $value->SUP_TYPE_NAME;  

            $add = new Warehousereportmain(); 
            $add->REPMAIN_LISTTYPE_ID = $iditem; 
            $add->REPMAIN_LISTTYPE_NAME = $nameitem;  
            $add->REPMAIN_YEAR = $request->input('YEAR_ID');
            $add->REPMAIN_MOUNT = $request->input('SEND_MONTH');
            // รูปภาพ   ****************************
            // if ($request->hasFile('image')) {
            //     $extension = $file->getClientOriginalExtension();
            //     $filename = time(). '.' .$extension;
            //     $add->image = $filename;
            // }
            $add->save();              
        }
            // อัปเดท สถานะปุ่ม  ***************
            $active = 'TRUE';
                DB::table('warehouse_reportmain_status')->where('REPMAIN_STATUS_NAME','=','TOTAL_MAIN')
                    ->update(['REPMAIN_STATUS_ACTIVE' => $active]);

            $activefalse = 'FALSE';
                DB::table('warehouse_reportmain_status')->where('REPMAIN_STATUS_NAME','=','LISTTYPE')
                    ->update(['REPMAIN_STATUS_ACTIVE' => $activefalse]);

        $year_max = $request->input('YEAR_ID');
        $month    = $request->input('SEND_MONTH');
        return response()->json([
            'status'         => 200 ,
            'year_max'       => $year_max,
            'm_budget'       => $month,
            'message'        => 'Process Success'
        ]);
    }
       

//    echo "Hiiiii";
    // $year_max = $request->get('YEAR_ID');
    // $month    = $request->get('SEND_MONTH');

    // $budget = DB::table('budget_year')
    // ->where('ACTIVE','=','True')
    // ->get();  

    // $reportmain = DB::table('supplies_type')->where('SUP_TYPE_MASTER_ID','=',1)->get();
    // foreach ($reportmain as $value) {
    //     $iditem = $value->SUP_TYPE_ID;
    //     $nameitem = $value->SUP_TYPE_NAME;  

    //     $add = new Warehousereportmain(); 
    //     $add->REPMAIN_LISTTYPE_ID = $iditem; 
    //     $add->REPMAIN_LISTTYPE_NAME = $nameitem;  
    //     $add->REPMAIN_YEAR = $year_max;
    //     $add->REPMAIN_MOUNT = $month;
    //     $add->save();  
    // }
                        // อัพเดท สถานะปุ่ม  ***************
                        // $active = 'TRUE';
                        //     DB::table('warehouse_reportmain_status')->where('REPMAIN_STATUS_NAME','=','TOTAL_MAIN')
                        //         ->update(['REPMAIN_STATUS_ACTIVE' => $active]);

                        // $activefalse = 'FALSE';
                        //     DB::table('warehouse_reportmain_status')->where('REPMAIN_STATUS_NAME','=','LISTTYPE')
                        //         ->update(['REPMAIN_STATUS_ACTIVE' => $activefalse]);
   
    // $inforeportmain = DB::table('warehouse_reportmain')->get();
    // return redirect()->route('report.reportstore_main',[
    //     'inforeportmains'       => $inforeportmain, 
    //     'budgets'               => $budget,
    //     'year_max'              => $year_max,
    //     'm_budget'              => $month,
    // ]); 
    
}

public function reportstore_main_totalmain(Request $request,$displaydate_bigen,$displaydate_end)
{
    $datebigin = $request->displaydate_bigen;
    dd($datebigin);
    $inforeportmain = DB::table('warehouse_reportmain')->get();
    foreach ($reportmain as $value) {
        $iditem = $value->SUP_TYPE_ID;
        $nameitem = $value->SUP_TYPE_NAME;  

        $add = new Warehousereportmain(); 
        $add->REPMAIN_LISTTYPE_ID = $iditem; 
        $add->REPMAIN_LISTTYPE_NAME = $nameitem;  
        $add->REPMAIN_STARTDATE = $displaydate_bigen;
        $add->REPMAIN_ENDDATE = $displaydate_end;
        $add->save();  
   
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

    }
    return views('report.reportstore_main');
}

public static function year()
{
 $count =  DB::table('warehouse_reportmain_status')
                    ->where('REPMAIN_STATUS_NAME','=','YEAR')
                    ->where('REPMAIN_STATUS_ACTIVE','=','TRUE')
                    ->count();   

 return $count;
}
public static function mount()
{
 $count =  DB::table('warehouse_reportmain_status')
                    ->where('REPMAIN_STATUS_NAME','=','MOUNT')
                    ->where('REPMAIN_STATUS_ACTIVE','=','TRUE')
                    ->count();   

 return $count;
}
public static function checktype()
{
 $count =  DB::table('warehouse_reportmain_status')
                    ->where('REPMAIN_STATUS_NAME','=','LISTTYPE')
                    ->where('REPMAIN_STATUS_ACTIVE','=','TRUE')
                    ->count();   

 return $count;
}
//////////////////////////////////////
public static function checktotalmain()
{
 $count =  DB::table('warehouse_reportmain_status')
                    ->where('REPMAIN_STATUS_NAME','=','TOTAL_MAIN')
                    ->where('REPMAIN_STATUS_ACTIVE','=','TRUE')
                    ->count();   

 return $count;
}
public static function checktotalsub()
{
 $count =  DB::table('warehouse_reportmain_status')
                    ->where('REPMAIN_STATUS_NAME','=','TOTAL_SUB')
                    ->where('REPMAIN_STATUS_ACTIVE','=','TRUE')
                    ->count();   

 return $count;
}
public static function checkbuymount()
{
 $count =  DB::table('warehouse_reportmain_status')
                    ->where('REPMAIN_STATUS_NAME','=','BUY_MOUNT')
                    ->where('REPMAIN_STATUS_ACTIVE','=','TRUE')
                    ->count();   

 return $count;
}
public static function checkpayrpst()
{
 $count =  DB::table('warehouse_reportmain_status')
                    ->where('REPMAIN_STATUS_NAME','=','PAY_RPST')
                    ->where('REPMAIN_STATUS_ACTIVE','=','TRUE')
                    ->count();   

 return $count;
}
public static function checkpayrpr()
{
 $count =  DB::table('warehouse_reportmain_status')
                    ->where('REPMAIN_STATUS_NAME','=','PAY_RPR')
                    ->where('REPMAIN_STATUS_ACTIVE','=','TRUE')
                    ->count();   

 return $count;
}
public static function checkpayrpr_sub()
{
 $count =  DB::table('warehouse_reportmain_status')
                    ->where('REPMAIN_STATUS_NAME','=','PAY_RPR_SUB')
                    ->where('REPMAIN_STATUS_ACTIVE','=','TRUE')
                    ->count();   

 return $count;
}





}

