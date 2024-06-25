<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Person;
use App\Models\Supplies;
use App\Models\Suppliesrequest;
use App\Models\Suppliesrequestsub;
use App\Models\Suppliescon;
use App\Models\Assetarticle;
use App\Models\Suppliesgroup;
use App\Models\Suppliesclass;
use App\Models\Suppliestypes;
use App\Models\Suppliesprop;
use App\Models\Warehousecheckreceive;
use App\Models\Suppliespurchase;
use App\Models\Suppliesconlist;
use App\Models\Suppliesconquotation;
use App\Models\Warehouserequest;
use App\Models\Permislist;
use App\Models\Suppliesconboard;
use App\Models\Suppliesconboarddetail;
use App\Models\Warehousecheckreceiveboard;
use App\Models\Warehousecheckreceivesub;
use App\Models\Suppliesunitref;
use App\Models\Medicaltypeitem;
use App\Models\Medicalgroup;
use App\Models\Medicalcategory;
use App\Models\Medicalsetup;
use App\Models\Warehousestorereceivesub; 
use App\Models\Warehouserequestsub;
use App\Models\Warehousetreasury;
use App\Models\Warehousestoreexportsub;
use App\Models\Warehousetreasuryreceivesub;
use App\Models\Warehousestore;
use App\Models\Medical_set_inventory;
use App\Models\Medical_set_category;
use App\Models\Suppliesinven;
use App\Models\Suppliestype;

use App\Http\Controllers\Report\MedicalReportController;
use App\Http\Controllers\ManagerwarehouseController;
use Session;
use Cookie;

date_default_timezone_set("Asia/Bangkok");

class ManagermedicalController extends Controller
{

    public function dashboard(Request $request)
    {
        $data['budgetyear_dropdown'] = getBudgetYearAmount();
        $data['budgetyear'] = (!empty($request->budgetyear))?$request->budgetyear:getBudgetYear();
        $year_ad               = $data['budgetyear'] - 543;
        $medicalreport = new MedicalReportController();
        $data['count1'] = $medicalreport->count_medical_request($year_ad,'all');
        $data['count2'] = $medicalreport->count_medical_request($year_ad,'Approve');
        $data['count3'] = $medicalreport->count_medical_request($year_ad,'Verify');
        $data['count4'] = $medicalreport->count_medical_request($year_ad,'Allow');
        $data['medical_receive_M'] = $medicalreport->sum_medical_receive($year_ad);
        $data['medical_export_M'] = $medicalreport->sum_medical_export($year_ad);
        return view('manager_medical.dashboard_medical',$data);
    }

    function dashboard_request_status(Request $reqest){
        if(!empty($reqest->status_request)){
            $budgetyear = $reqest->budgetyear; 
            $status = $reqest->status_request;
        }else{
            $budgetyear = getBudgetyear(); 
            $status = 'all';
        }
        $data['budgetyear_dropdown'] = getBudgetYearAmount();
        $year_ad = $budgetyear-543;
        $data['list_status'] = DB::table('warehouse_request_status')->get();
        $medicalreport = new MedicalReportController();
        $data['list_request'] = $medicalreport->get_request_medical($year_ad , $status);
        return view('manager_medical.dashboard_medical_request',$data,compact('status','budgetyear'));   
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


    
        
        
        return view('manager_medical.dashboard_medical',[
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


     //====================================รายงานคงคลังเพื่อขอซื้อ 
     public function reportInventory(Request $request)
     {
        if($request->method() === 'POST'){
            $typekind   = $request->SEND_TYPEKIND;
            $type       = $request->SEND_TYPE;
            $remaining  = $request->remaining;
            $search     = $request->search;
            $data_search = json_encode_u([
                'typekind' => $typekind,
                'type' => $type,
                'search' => $search,
                'remaining' => $remaining,
            ]);
            Cookie::queue('data_search', $data_search, 120,$request->server('REQUEST_URI'));
        }elseif(!empty(Cookie::get('data_search'))){
            $data_search    = json_decode(Cookie::get('data_search'));
            $typekind   = $data_search->typekind;
            $type       = $data_search->type;
            $remaining  = $data_search->remaining;
            $search     = $data_search->search;
        }else{
            $typekind   = '';
            $type       = '';
            $remaining  = '';
            $search     = '';
        }
        if($typekind == null || $typekind == ''){
            if($type == null || $type == ''){
                $infowarehousestore= DB::table('warehouse_store')
                ->leftJoin('supplies_unit_ref', 'warehouse_store.STORE_UNIT', '=', 'supplies_unit_ref.ID') 
                ->leftJoin('supplies', 'warehouse_store.STORE_CODE', '=', 'supplies.SUP_FSN_NUM')           
                ->leftJoin('supplies_type', 'supplies_type.SUP_TYPE_ID', '=', 'supplies.SUP_TYPE_ID') 
                ->leftJoin('supplies_vendor', 'supplies_vendor.VENDOR_ID', '=', 'supplies.SUP_MANU') 
                ->leftJoin('supplies_type_kind','supplies.SUP_TYPE_KIND_ID','=','supplies_type_kind.SUP_TYPE_KIND_ID')
                ->where(function($q) use ($search){
                    $q->where('SUP_FSN_NUM','like','%'.$search.'%');
                    $q->orwhere('SUP_CODE','like','%'.$search.'%');
                    $q->orwhere('SUP_NAME','like','%'.$search.'%');
                    $q->orwhere('VENDOR_NAME','like','%'.$search.'%');
                    $q->orwhere('MIN','like','%'.$search.'%');  
                    $q->orwhere('MAX','like','%'.$search.'%');
                    $q->orwhere('SUP_UNIT_NAME','like','%'.$search.'%');        
                })   
                ->orderBy('VENDOR_ID','desc')
                ->where('STORE_TYPE','=',2)
                ->get();
            }else{
                $infowarehousestore= DB::table('warehouse_store')
                ->leftJoin('supplies_unit_ref', 'warehouse_store.STORE_UNIT', '=', 'supplies_unit_ref.ID') 
                ->leftJoin('supplies', 'warehouse_store.STORE_CODE', '=', 'supplies.SUP_FSN_NUM')           
                ->leftJoin('supplies_type', 'supplies_type.SUP_TYPE_ID', '=', 'supplies.SUP_TYPE_ID') 
                ->leftJoin('supplies_vendor', 'supplies_vendor.VENDOR_ID', '=', 'supplies.SUP_MANU') 
                ->leftJoin('supplies_type_kind','supplies.SUP_TYPE_KIND_ID','=','supplies_type_kind.SUP_TYPE_KIND_ID')
                ->where('supplies.SUP_TYPE_ID','=',$type)
                ->where(function($q) use ($search){
                    $q->where('SUP_FSN_NUM','like','%'.$search.'%');
                    $q->orwhere('SUP_CODE','like','%'.$search.'%');
                    $q->orwhere('SUP_NAME','like','%'.$search.'%');
                    $q->orwhere('VENDOR_NAME','like','%'.$search.'%');
                    $q->orwhere('MIN','like','%'.$search.'%');  
                    $q->orwhere('MAX','like','%'.$search.'%');
                    $q->orwhere('SUP_UNIT_NAME','like','%'.$search.'%');        
                })   
                ->orderBy('VENDOR_ID','desc')
                ->where('STORE_TYPE','=',2)
                ->get();
            }
         }else{
            if($type == null || $type == ''){
                $infowarehousestore= DB::table('warehouse_store')
                ->leftJoin('supplies_unit_ref', 'warehouse_store.STORE_UNIT', '=', 'supplies_unit_ref.ID') 
                ->leftJoin('supplies', 'warehouse_store.STORE_CODE', '=', 'supplies.SUP_FSN_NUM')           
                ->leftJoin('supplies_type', 'supplies_type.SUP_TYPE_ID', '=', 'supplies.SUP_TYPE_ID') 
                ->leftJoin('supplies_vendor', 'supplies_vendor.VENDOR_ID', '=', 'supplies.SUP_MANU') 
                ->leftJoin('supplies_type_kind','supplies.SUP_TYPE_KIND_ID','=','supplies_type_kind.SUP_TYPE_KIND_ID')
                ->where('supplies.SUP_TYPE_KIND_ID','=',$typekind)
                ->where(function($q) use ($search){
                    $q->where('SUP_FSN_NUM','like','%'.$search.'%');
                    $q->orwhere('SUP_CODE','like','%'.$search.'%');
                    $q->orwhere('SUP_NAME','like','%'.$search.'%');
                    $q->orwhere('VENDOR_NAME','like','%'.$search.'%');
                    $q->orwhere('MIN','like','%'.$search.'%');  
                    $q->orwhere('MAX','like','%'.$search.'%');
                    $q->orwhere('SUP_UNIT_NAME','like','%'.$search.'%');        
                })   
                ->orderBy('VENDOR_ID','desc')
                ->where('STORE_TYPE','=',2)
                ->get();
            }else{
                $infowarehousestore= DB::table('warehouse_store')
                ->leftJoin('supplies_unit_ref', 'warehouse_store.STORE_UNIT', '=', 'supplies_unit_ref.ID') 
                ->leftJoin('supplies', 'warehouse_store.STORE_CODE', '=', 'supplies.SUP_FSN_NUM')           
                ->leftJoin('supplies_type', 'supplies_type.SUP_TYPE_ID', '=', 'supplies.SUP_TYPE_ID') 
                ->leftJoin('supplies_vendor', 'supplies_vendor.VENDOR_ID', '=', 'supplies.SUP_MANU') 
                ->leftJoin('supplies_type_kind','supplies.SUP_TYPE_KIND_ID','=','supplies_type_kind.SUP_TYPE_KIND_ID')
                ->where('supplies.SUP_TYPE_ID','=',$type)
                ->where('supplies.SUP_TYPE_KIND_ID','=',$typekind)
                ->where(function($q) use ($search){
                    $q->where('SUP_FSN_NUM','like','%'.$search.'%');
                    $q->orwhere('SUP_CODE','like','%'.$search.'%');
                    $q->orwhere('SUP_NAME','like','%'.$search.'%');
                    $q->orwhere('VENDOR_NAME','like','%'.$search.'%');
                    $q->orwhere('MIN','like','%'.$search.'%');  
                    $q->orwhere('MAX','like','%'.$search.'%');
                    $q->orwhere('SUP_UNIT_NAME','like','%'.$search.'%');        
                }) 
                ->orderBy('VENDOR_ID','desc')  
                ->where('STORE_TYPE','=',2)
                ->get();
            }
        }
        $suppliestype = DB::table('supplies_type')->where('SUP_TYPE_ID','=',61)
        ->orwhere('SUP_TYPE_ID','=',62)
        ->orwhere('SUP_TYPE_ID','=',22)
        ->orwhere('SUP_TYPE_ID','=',7)->get();
        $suppliestypekind = DB::table('supplies_type_kind')->where('SUP_TYPE_MASTER_ID','=',1)->get();
         return view('manager_medical.medical_reportInventory',[
           'infowarehousestores' => $infowarehousestore,
           'suppliestypes' => $suppliestype,
           'suppliestypekinds' => $suppliestypekind,
           'typekind_check' => $typekind,
           'type_check' => $type,
           'remaining' => $remaining,
           'search' => $search,
         ]);
 
     }

     public function reportInventorysave(Request $request){

       
      

        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;
        }

        $maxnumber = DB::table('supplies_request')->where('BUDGET_YEAR','=',$yearbudget)->max('ID');     
         if($maxnumber != '' ||  $maxnumber != null){        
             $refmax = DB::table('supplies_request')->where('ID','=',$maxnumber)->first();  
             if($refmax->REQUEST_ID != '' ||  $refmax->REQUEST_ID != null){
                 $maxref = substr($refmax->REQUEST_ID, -4)+1;
              }else{
                 $maxref = 1;
              }
             $ref = str_pad($maxref, 4, "0", STR_PAD_LEFT);        
         }else{
             $ref = '0001';
         }       
         $y = substr($yearbudget, -2); 
            $refnumber ='REQ-'.$y.''.$ref;

        $iduser = Auth::user()->PERSON_ID;
    
        $addinforequest = new Suppliesrequest();

   $addinforequest->REQUEST_ID = $refnumber;
   $addinforequest->DATE_WANT = date('Y-m-d H:i:s');
   $addinforequest->DATE_TIME_SAVE = date('Y-m-d H:i:s');


   $addinforequest->REQUEST_FOR_ID = '61';
   $name_type = DB::table('supplies_type')->where('SUP_TYPE_ID','=','61')->first();
   $addinforequest->REQUEST_FOR = $name_type->SUP_TYPE_NAME;

   $addinforequest->DEP_SUB_SUB_ID = '33';
   $addinforequest->DEP_SUB_SUB_PHONE = '';

   $addinforequest->SAVE_HR_ID =  $iduser;


     //----------------------------------
     $SAVEHR =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
     ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
     ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
     ->where('hrd_person.ID','=', $iduser)->first();

           $addinforequest->SAVE_HR_NAME = $SAVEHR->HR_PREFIX_NAME.''.$SAVEHR->HR_FNAME.' '.$SAVEHR->HR_LNAME;
           $addinforequest->SAVE_HR_POSITION = $SAVEHR->HR_POSITION_NAME;
           $addinforequest->SAVE_HR_DEP_SUB_NAME = $SAVEHR->HR_DEPARTMENT_SUB_NAME;

      //----------------------------------

           $addinforequest->AGREE_HR_ID = '26';

        //----------------------------------
        $AGREEHR =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
        ->where('hrd_person.ID','=','26')->first();

           $addinforequest->AGREE_HR_NAME = $AGREEHR->HR_PREFIX_NAME.''.$AGREEHR->HR_FNAME.' '.$AGREEHR->HR_LNAME;
           $addinforequest->AGREE_HR_POSITION = $AGREEHR->HR_POSITION_NAME;

         //----------------------------------

           $addinforequest->REQUEST_BUY_COMMENT = '';

           $addinforequest->HIRE_DETAIL = '';

           $addinforequest->STATUS = 'Pending';

           $addinforequest->BUDGET_YEAR = '2564';

           $addinforequest->save();



           $SUPPLIES_REQUEST_ID = Suppliesrequest::max('ID');

           $data = $request->dataset;
           foreach ($data as $key => $value){
        
           $supinfo = DB::table('supplies')
           ->leftjoin('supplies_vendor','supplies_vendor.VENDOR_ID','=','supplies.SUP_VENDOR_CODE')
           ->where('ID','=',$value['id'])->first();

           $resule =  DB::table('supplies_unit_ref')
           ->where('SUP_ID','=',$value['id'])
           ->where('SUP_TOTAL','=',1)
           ->first();
           
                    $model = new Suppliesrequestsub();
                    $model->SUPPLIES_REQUEST_ID = $SUPPLIES_REQUEST_ID;
                    $model->SUPPLIES_REQUEST_SUB_DETAIL = $supinfo->SUP_NAME;
                    $model->SUPPLIES_REQUEST_SUB_AMOUNT = $value['amount'];
                    $model->SUPPLIES_REQUEST_SUB_UNIT = $resule->SUP_UNIT_NAME ;
                    $model->SUPPLIES_REQUEST_SUB_PRICE = $value['unitpice'];
                    $model->SUPPLIES_REQUEST_SUB_SUM_PRICE = $value['amount'] * $value['unitpice'];
                    $model->SUPPLIES_REQUEST_SUBRE_ID = $value['id'] ;
                    $model->save();

                    $updatevender = Suppliesrequest::find($SUPPLIES_REQUEST_ID );
                    $updatevender->REQUEST_VANDOR_ID = $supinfo->SUP_VENDOR_CODE;
                    $updatevender->REQUEST_VANDOR_NAME = $supinfo->VENDOR_NAME;
                    $updatevender->save();

        }
   

   $BUDGET_SUM = Suppliesrequestsub::where('SUPPLIES_REQUEST_ID','=',$SUPPLIES_REQUEST_ID)->sum('SUPPLIES_REQUEST_SUB_SUM_PRICE');
   $updatesum = Suppliesrequest::find($SUPPLIES_REQUEST_ID );
   $updatesum->BUDGET_SUM = $BUDGET_SUM;
   $updatesum->save();

        return response()->json($data);
     }

     public function reportInventorysearch(Request $request)
     {
          
        
        $typekind=$request->SEND_TYPEKIND;
        $type =$request->SEND_TYPE;
        $search = $request->search;

        if($typekind == null || $typekind == ''){

            if($type == null || $type == ''){

                $infowarehousestore= DB::table('warehouse_store')
                ->leftJoin('supplies_unit_ref', 'warehouse_store.STORE_UNIT', '=', 'supplies_unit_ref.ID') 
                ->leftJoin('supplies', 'warehouse_store.STORE_CODE', '=', 'supplies.SUP_FSN_NUM')           
                ->leftJoin('supplies_type', 'supplies_type.SUP_TYPE_ID', '=', 'supplies.SUP_TYPE_ID') 
                ->leftJoin('supplies_vendor', 'supplies_vendor.VENDOR_ID', '=', 'supplies.SUP_MANU') 
                ->leftJoin('supplies_type_kind','supplies.SUP_TYPE_KIND_ID','=','supplies_type_kind.SUP_TYPE_KIND_ID')
                ->where(function($q) use ($search){
                    $q->where('SUP_FSN_NUM','like','%'.$search.'%');
                    $q->orwhere('SUP_CODE','like','%'.$search.'%');
                    $q->orwhere('SUP_NAME','like','%'.$search.'%');
                    $q->orwhere('VENDOR_NAME','like','%'.$search.'%');
                    $q->orwhere('MIN','like','%'.$search.'%');  
                    $q->orwhere('MAX','like','%'.$search.'%');
                    $q->orwhere('SUP_UNIT_NAME','like','%'.$search.'%');        
                })   
                ->orderBy('VENDOR_ID','desc')
                ->where('STORE_TYPE','=',2)
                ->get();


           

            

            }else{

                $infowarehousestore= DB::table('warehouse_store')
                ->leftJoin('supplies_unit_ref', 'warehouse_store.STORE_UNIT', '=', 'supplies_unit_ref.ID') 
                ->leftJoin('supplies', 'warehouse_store.STORE_CODE', '=', 'supplies.SUP_FSN_NUM')           
                ->leftJoin('supplies_type', 'supplies_type.SUP_TYPE_ID', '=', 'supplies.SUP_TYPE_ID') 
                ->leftJoin('supplies_vendor', 'supplies_vendor.VENDOR_ID', '=', 'supplies.SUP_MANU') 
                ->leftJoin('supplies_type_kind','supplies.SUP_TYPE_KIND_ID','=','supplies_type_kind.SUP_TYPE_KIND_ID')
                ->where('supplies.SUP_TYPE_ID','=',$type)
                ->where(function($q) use ($search){
                    $q->where('SUP_FSN_NUM','like','%'.$search.'%');
                    $q->orwhere('SUP_CODE','like','%'.$search.'%');
                    $q->orwhere('SUP_NAME','like','%'.$search.'%');
                    $q->orwhere('VENDOR_NAME','like','%'.$search.'%');
                    $q->orwhere('MIN','like','%'.$search.'%');  
                    $q->orwhere('MAX','like','%'.$search.'%');
                    $q->orwhere('SUP_UNIT_NAME','like','%'.$search.'%');        
                })   
                ->orderBy('VENDOR_ID','desc')
                ->where('STORE_TYPE','=',2)
                ->get();
          
                

            }
    

         }else{

         
            
        
            if($type == null || $type == ''){

                                
                $infowarehousestore= DB::table('warehouse_store')
                ->leftJoin('supplies_unit_ref', 'warehouse_store.STORE_UNIT', '=', 'supplies_unit_ref.ID') 
                ->leftJoin('supplies', 'warehouse_store.STORE_CODE', '=', 'supplies.SUP_FSN_NUM')           
                ->leftJoin('supplies_type', 'supplies_type.SUP_TYPE_ID', '=', 'supplies.SUP_TYPE_ID') 
                ->leftJoin('supplies_vendor', 'supplies_vendor.VENDOR_ID', '=', 'supplies.SUP_MANU') 
                ->leftJoin('supplies_type_kind','supplies.SUP_TYPE_KIND_ID','=','supplies_type_kind.SUP_TYPE_KIND_ID')
                ->where('supplies.SUP_TYPE_KIND_ID','=',$typekind)
                ->where(function($q) use ($search){
                    $q->where('SUP_FSN_NUM','like','%'.$search.'%');
                    $q->orwhere('SUP_CODE','like','%'.$search.'%');
                    $q->orwhere('SUP_NAME','like','%'.$search.'%');
                    $q->orwhere('VENDOR_NAME','like','%'.$search.'%');
                    $q->orwhere('MIN','like','%'.$search.'%');  
                    $q->orwhere('MAX','like','%'.$search.'%');
                    $q->orwhere('SUP_UNIT_NAME','like','%'.$search.'%');        
                })   
                ->orderBy('VENDOR_ID','desc')
                ->where('STORE_TYPE','=',2)
                ->get();
          

            }else{

                $infowarehousestore= DB::table('warehouse_store')
                ->leftJoin('supplies_unit_ref', 'warehouse_store.STORE_UNIT', '=', 'supplies_unit_ref.ID') 
                ->leftJoin('supplies', 'warehouse_store.STORE_CODE', '=', 'supplies.SUP_FSN_NUM')           
                ->leftJoin('supplies_type', 'supplies_type.SUP_TYPE_ID', '=', 'supplies.SUP_TYPE_ID') 
                ->leftJoin('supplies_vendor', 'supplies_vendor.VENDOR_ID', '=', 'supplies.SUP_MANU') 
                ->leftJoin('supplies_type_kind','supplies.SUP_TYPE_KIND_ID','=','supplies_type_kind.SUP_TYPE_KIND_ID')
                ->where('supplies.SUP_TYPE_ID','=',$type)
                ->where('supplies.SUP_TYPE_KIND_ID','=',$typekind)
                ->where(function($q) use ($search){
                    $q->where('SUP_FSN_NUM','like','%'.$search.'%');
                    $q->orwhere('SUP_CODE','like','%'.$search.'%');
                    $q->orwhere('SUP_NAME','like','%'.$search.'%');
                    $q->orwhere('VENDOR_NAME','like','%'.$search.'%');
                    $q->orwhere('MIN','like','%'.$search.'%');  
                    $q->orwhere('MAX','like','%'.$search.'%');
                    $q->orwhere('SUP_UNIT_NAME','like','%'.$search.'%');        
                }) 
                ->orderBy('VENDOR_ID','desc')  
                ->where('STORE_TYPE','=',2)
                ->get();
                

            }
        
        }


         
        $suppliestype = DB::table('supplies_type')->where('SUP_TYPE_ID','=',61)
        ->orwhere('SUP_TYPE_ID','=',62)
        ->orwhere('SUP_TYPE_ID','=',22)
        ->orwhere('SUP_TYPE_ID','=',7)->get();
        
        $suppliestypekind = DB::table('supplies_type_kind')->where('SUP_TYPE_MASTER_ID','=',1)->get();

         return view('manager_medical.medical_reportInventory',[
           'infowarehousestores' => $infowarehousestore,
           'suppliestypes' => $suppliestype,
           'suppliestypekinds' => $suppliestypekind,
           'typekind_check' => $typekind,
           'type_check' => $type,
           'search' => $search,
         ]);
 
     }
 
     //====================================================================================
 

    public function suppliesinfo(Request $request)
    {
        if($request->method() === 'POST'){
            $search     = $request->get('search');
            $typekind   = $request->SEND_TYPEKIND;
            $type       = $request->SEND_TYPE;
            $typedetail = $request->typedetail;
            $data_search = json_encode_u([
                'search' => $search,
                'typekind' => $typekind,
                'type' => $type,
                'typedetail' => $typedetail,
            ]);
            Cookie::queue('data_search', $data_search, 120,$request->server('REQUEST_URI'));
        }elseif(!empty(Cookie::get('data_search'))){
            $data_search    = json_decode(Cookie::get('data_search'));
            $search     = $data_search->search;
            $typekind   = $data_search->typekind;
            $type       = $data_search->type;
            $typedetail = $data_search->typedetail;
        }else{
            $search     = '';
            $typekind   = '';
            $type       = '';
            $typedetail = '';
        }
        $setcate = Medical_set_category::all();
        $infosupplies = Supplies::leftJoin('supplies_type','supplies.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
        ->leftJoin('supplies_type_kind','supplies.SUP_TYPE_KIND_ID','=','supplies_type_kind.SUP_TYPE_KIND_ID')
        ->leftJoin('medical_type_item','supplies.SUP_GENUS','=','medical_type_item.TYPE_ITEM_ID')
        ->leftJoin('supplies_vendor','supplies.SUP_BUY','=','supplies_vendor.VENDOR_ID');
        if($typekind != null ){
            $infosupplies = $infosupplies->where('supplies.SUP_TYPE_KIND_ID','=',$typekind);
        }
        if($type != null){
            $infosupplies = $infosupplies->where('supplies.SUP_TYPE_ID','=',$type);
        }else{
            $infosupplies = $infosupplies->where(function($q) use ($setcate){
                foreach($setcate as $Scate){
                    $q->orWhere('supplies.SUP_TYPE_ID',$Scate->SUP_TYPE_ID);
                }
            });
        }
        $infosupplies = $infosupplies->where(function($q) use ($search){
            $q->where('SUP_FSN_NUM','like','%'.$search.'%');
            $q->orwhere('SUP_CODE','like','%'.$search.'%');
            $q->orwhere('TPU_NUMBER','like','%'.$search.'%');
            $q->orwhere('SUP_NAME','like','%'.$search.'%');
            $q->orwhere('SUP_MASH','like','%'.$search.'%');
        })
        ->orderBy('ID', 'desc')
        ->get();

        $suppliestype = $setcate;
        $suppliestypekind = DB::table('supplies_type_kind')->where('SUP_TYPE_MASTER_ID','=',1)->get();
        $typekind_check = $typekind;
        $type_check = $type;
        return view('manager_medical.suppliesinfo',[
            'infosuppliess' => $infosupplies,
            'suppliestypes' => $suppliestype,
            'suppliestypekinds' => $suppliestypekind,
            'typekind_check' => $typekind_check,
            'type_check' => $type_check,
            'search' => $search,
            'typedetail' => $typedetail,
        ]);
    }

    public function suppliesinfosearch(Request $request)
    {
        $search = $request->get('search');
        $typekind = $request->SEND_TYPEKIND;
        $type = $request->SEND_TYPE;
        $typedetail = $request->typedetail;
      
        if($search==''){
            $search="";
        }

        if($typedetail == 'parcel'){
                $detail = '1';
        }elseif($typedetail == 'article'){
            $detail = '2';  
        }elseif($typedetail == 'service'){
            $detail = '3';   
        }else{
            $detail = '5';
        }


        if($typekind == null || $typekind == ''){

            if($type == null || $type == ''){


                $infosupplies= Supplies::leftJoin('supplies_type','supplies.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
                ->leftJoin('supplies_type_kind','supplies.SUP_TYPE_KIND_ID','=','supplies_type_kind.SUP_TYPE_KIND_ID')
                ->leftJoin('medical_type_item','supplies.SUP_GENUS','=','medical_type_item.TYPE_ITEM_ID')
                ->leftJoin('supplies_vendor','supplies.SUP_BUY','=','supplies_vendor.VENDOR_ID') 
                ->where(function($q) use ($search){
                    $q->where('SUP_FSN_NUM','like','%'.$search.'%');
                    $q->orwhere('SUP_CODE','like','%'.$search.'%');
                    $q->orwhere('TPU_NUMBER','like','%'.$search.'%');
                    $q->orwhere('SUP_NAME','like','%'.$search.'%');
                    $q->orwhere('SUP_MASH','like','%'.$search.'%');         
                })   
                ->orderBy('ID', 'desc') 
                ->get();

            

            }else{

                $infosupplies= Supplies::leftJoin('supplies_type','supplies.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
                ->leftJoin('supplies_type_kind','supplies.SUP_TYPE_KIND_ID','=','supplies_type_kind.SUP_TYPE_KIND_ID')
                ->leftJoin('medical_type_item','supplies.SUP_GENUS','=','medical_type_item.TYPE_ITEM_ID')
                ->leftJoin('supplies_vendor','supplies.SUP_BUY','=','supplies_vendor.VENDOR_ID')
                ->where('supplies.SUP_TYPE_ID','=',$type)
                ->where(function($q) use ($search){
                    $q->where('SUP_FSN_NUM','like','%'.$search.'%');
                    $q->orwhere('SUP_CODE','like','%'.$search.'%');
                    $q->orwhere('TPU_NUMBER','like','%'.$search.'%');
                    $q->orwhere('SUP_NAME','like','%'.$search.'%');
                    $q->orwhere('SUP_MASH','like','%'.$search.'%');   
                })
                ->orderBy('ID', 'desc') 
                ->get();
          
                

            }
    

         }else{

         
            
        
            if($type == null || $type == ''){

                $infosupplies= Supplies::leftJoin('supplies_type','supplies.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
                                ->leftJoin('supplies_type_kind','supplies.SUP_TYPE_KIND_ID','=','supplies_type_kind.SUP_TYPE_KIND_ID')
                                ->leftJoin('medical_type_item','supplies.SUP_GENUS','=','medical_type_item.TYPE_ITEM_ID')
                                ->leftJoin('supplies_vendor','supplies.SUP_BUY','=','supplies_vendor.VENDOR_ID')
                                ->where('supplies.SUP_TYPE_KIND_ID','=',$typekind)
                                ->where(function($q) use ($search){
                                    $q->where('SUP_FSN_NUM','like','%'.$search.'%');
                                    $q->orwhere('SUP_CODE','like','%'.$search.'%');
                                    $q->orwhere('TPU_NUMBER','like','%'.$search.'%');
                                    $q->orwhere('SUP_NAME','like','%'.$search.'%');  
                                    $q->orwhere('SUP_MASH','like','%'.$search.'%'); 
                                })
                                ->orderBy('ID', 'desc') 
                                ->get();

            }else{

                $infosupplies= Supplies::leftJoin('supplies_type','supplies.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
                ->leftJoin('supplies_type_kind','supplies.SUP_TYPE_KIND_ID','=','supplies_type_kind.SUP_TYPE_KIND_ID')
                ->leftJoin('medical_type_item','supplies.SUP_GENUS','=','medical_type_item.TYPE_ITEM_ID')
                ->leftJoin('supplies_vendor','supplies.SUP_BUY','=','supplies_vendor.VENDOR_ID')
                ->where('supplies.SUP_TYPE_ID','=',$type)
                ->where('supplies.SUP_TYPE_KIND_ID','=',$typekind)
                ->where(function($q) use ($search){
                    $q->where('SUP_FSN_NUM','like','%'.$search.'%');
                    $q->orwhere('SUP_CODE','like','%'.$search.'%');
                    $q->orwhere('TPU_NUMBER','like','%'.$search.'%');
                    $q->orwhere('SUP_NAME','like','%'.$search.'%');
                    $q->orwhere('SUP_MASH','like','%'.$search.'%');   
                })
            
                ->orderBy('ID', 'desc') 
                ->get();
                
                

            }
        
        }


        $suppliestype = DB::table('supplies_type')->where('SUP_TYPE_ID','=',61)
        ->orwhere('SUP_TYPE_ID','=',62)
        ->orwhere('SUP_TYPE_ID','=',22)
        ->orwhere('SUP_TYPE_ID','=',7)->get();
        $suppliestypekind = DB::table('supplies_type_kind')->where('SUP_TYPE_MASTER_ID','=',1)->get();

        $typekind_check = $typekind;
        $type_check = $type;
       


        return view('manager_medical.suppliesinfo',[
            'infosuppliess' => $infosupplies,
            'suppliestypes' => $suppliestype,
            'suppliestypekinds' => $suppliestypekind,
            'typekind_check' => $typekind_check,
            'type_check' => $type_check,
            'search' => $search,
            'typedetail' => $typedetail,
        ]);
    }
    
    public function createsuppliesinfo(Request $request)
    {

     
        $suppliestypekind = DB::table('supplies_type_kind')->where('SUP_TYPE_MASTER_ID','=',1)->get();
        $suppliestype = DB::table('supplies_type')->where('SUP_TYPE_MASTER_ID','=',1)->get();
        $suppliestypemaster = DB::table('supplies_type_master')->where('SUP_TYPE_MASTER_ID','=',1)->get();

        return view('manager_medical.suppliesinfo_add',[
            'suppliestypekinds' => $suppliestypekind,
            'suppliestypes' => $suppliestype,
            'suppliestypemasters' => $suppliestypemaster,
           
        ]);
    
    }

public function medical_add(Request $request)
{

 
   
    $suppliestypekind = DB::table('supplies_type_kind')->where('SUP_TYPE_MASTER_ID','=',1)->get();
    $suppliestype = DB::table('supplies_type')->where('SUP_TYPE_MASTER_ID','=',1)->get();
    $suppliestypemaster = DB::table('supplies_type_master')->where('SUP_TYPE_MASTER_ID','=',1)->get();

    $medicaltypeitem = DB::table('medical_type_item')->get();

    $medicalgroup = DB::table('medical_group')->get();
    $medicalcategory = DB::table('medical_category')->get();

    $suppliesvendor = DB::table('supplies_vendor')->where('ACTIVE','=','True')->get();


    $suppliesunit = DB::table('supplies_unit')->get();

    
    
     
    return view('manager_medical.medical_add',[
        'suppliestypekinds' => $suppliestypekind,
        'suppliestypes' => $suppliestype,
        'suppliestypemasters' => $suppliestypemaster,
        'medicaltypeitems' => $medicaltypeitem,
        'medicalgroups' => $medicalgroup,
        'medicalcategorys' => $medicalcategory,
        'suppliesvendors' => $suppliesvendor,
        'suppliesunits' => $suppliesunit,
    ]);

}


public function savemedicalinfo(Request $request) 
{
  
    $count= DB::table('supplies')
    ->where('supplies.SUP_FSN_NUM',$request->SUP_FSN_NUM) 
    ->count();

if($count == 0){
    $addinfosup = new Supplies(); 
  
    $addinfosup->SUP_FSN_NUM = $request->SUP_FSN_NUM;
    $addinfosup->SUP_CODE = $request->SUP_CODE;
    $addinfosup->TPU_NUMBER = $request->TPU_NUMBER;

    $addinfosup->SUP_TYPE_KIND_ID = $request->SUP_TYPE_KIND_ID;
    $addinfosup->SUP_NAME = $request->SUP_NAME;
    $addinfosup->SUP_GENUS = $request->SUP_GENUS;
    $addinfosup->SUP_MASH = $request->SUP_MASH;
    $addinfosup->SUP_SYNONYMS_01 = $request->SUP_SYNONYMS_01;
    $addinfosup->SUP_SYNONYMS_02 = $request->SUP_SYNONYMS_02;
    $addinfosup->SUP_PROP = $request->SUP_PROP;
    $addinfosup->SUP_TYPE_ID = $request->SUP_TYPE_ID;
    $addinfosup->SUP_TYPE_MASTER_ID = $request->SUP_TYPE_MASTER_ID;    
    $addinfosup->SUP_GROUP = $request->SUP_GROUP;
    $addinfosup->SUP_CAT = $request->SUP_CAT;
    $addinfosup->SUP_VENDOR_CODE = $request->SUP_VENDOR_CODE;
    $addinfosup->SUP_MANU = $request->SUP_MANU;
    $addinfosup->SUP_BUY = $request->SUP_BUY;

    $addinfosup->CONTENT = $request->CONTENT;
    $addinfosup->MIN = $request->MIN;
    $addinfosup->MAX = $request->MAX;
    $addinfosup->SUP_REMARK = $request->SUP_REMARK;
    $addinfosup->DIS_ACTIVE = $request->DIS_ACTIVE;
    $addinfosup->INNO_ACTIVE = $request->INNO_ACTIVE;
    $addinfosup->CONTINUE_PRICE_ID = $request->CONTINUE_PRICE_ID;

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
        if($SUPUNITNAME == null){
            $add->SUP_UNIT_NAME = '';
        }else{
            $add->SUP_UNIT_NAME = $SUPUNITNAME->SUP_UNIT_NAME;
        }
        

        $add->SUP_TOTAL = $request->SUP_TOTAL0; 
        $add->save(); 
    }

    if($request->SUP_UNIT_ID1 !== null ){   

        $add = new Suppliesunitref();
        $add->SUP_ID = $SUP_ID;
        $add->SUP_UNIT_ID = $request->SUP_UNIT_ID1;
        $SUPUNITNAME = DB::table('supplies_unit')->where('SUP_UNIT_ID','=',$request->SUP_UNIT_ID1)->first();
        if($SUPUNITNAME == null){
            $add->SUP_UNIT_NAME = '';
        }else{
            $add->SUP_UNIT_NAME = $SUPUNITNAME->SUP_UNIT_NAME;
        }
        $add->SUP_TOTAL = $request->SUP_TOTAL1; 
        $add->save(); 
    }



}

    $typedetail = $request->typedetail;



    return redirect()->route('mmedical.suppliesinfo');
}






public function medical_edit(Request $request,$id)
{

 
    $suppliestypekind = DB::table('supplies_type_kind')->where('SUP_TYPE_MASTER_ID','=',1)->get();
    $suppliestype = DB::table('supplies_type')->where('SUP_TYPE_MASTER_ID','=',1)->get();
    $suppliestypemaster = DB::table('supplies_type_master')->where('SUP_TYPE_MASTER_ID','=',1)->get();

    $medicaltypeitem = DB::table('medical_type_item')->get();

    $medicalgroup = DB::table('medical_group')->get();
    $medicalcategory = DB::table('medical_category')->get();

    $suppliesvendor = DB::table('supplies_vendor')->where('ACTIVE','=','True')->get();


    $infomedical = DB::table('supplies')->where('ID','=',$id)->first();
   
    $countSuppliesunitref = Suppliesunitref::where('SUP_ID','=',$id)->get();

    $infoSuppliesunitref = Suppliesunitref::where('SUP_ID','=',$id)->get();

    $suppliesunit = DB::table('supplies_unit')->get();
    
        //------unit

        $infounitref_1 = Suppliesunitref::where('SUP_ID','=',$id)->where('SUP_TOTAL','=',1)->first();

        if($infounitref_1 == null){
            $infounitref1 = 'null';
        }else{
            $infounitref1 = $infounitref_1;
        }
       
       
        $infounitref_2 = Suppliesunitref::where('SUP_ID','=',$id)->where('SUP_TOTAL','!=',1)->first();
    
        if($infounitref_2 == null){
            $infounitref2 = 'null';
        }else{
            $infounitref2 = $infounitref_2;
        }


    return view('manager_medical.medical_edit',[
        'suppliestypekinds' => $suppliestypekind,
        'suppliestypes' => $suppliestype,
        'suppliestypemasters' => $suppliestypemaster,
        'medicaltypeitems' => $medicaltypeitem,
        'medicalgroups' => $medicalgroup,
        'medicalcategorys' => $medicalcategory,
        'suppliesvendors' => $suppliesvendor,
        'infomedical' => $infomedical,
        'infoSuppliesunitrefs' => $infoSuppliesunitref,
        'countSuppliesunitref' => $countSuppliesunitref,
        'suppliesunits' => $suppliesunit,
        'infounitref1' => $infounitref1,
        'infounitref2' => $infounitref2,
       
    ]);

}

public function updatemedicalinfo(Request $request)
{
  
  

    $id = $request->ID;

    $addinfosup = Supplies::find($id);
    
    $addinfosup->SUP_FSN_NUM = $request->SUP_FSN_NUM;
    $addinfosup->SUP_CODE = $request->SUP_CODE;
    $addinfosup->TPU_NUMBER = $request->TPU_NUMBER;

    $addinfosup->SUP_TYPE_KIND_ID = $request->SUP_TYPE_KIND_ID;
    $addinfosup->SUP_NAME = $request->SUP_NAME;
    $addinfosup->SUP_GENUS = $request->SUP_GENUS;
    $addinfosup->SUP_MASH = $request->SUP_MASH;
    $addinfosup->SUP_SYNONYMS_01 = $request->SUP_SYNONYMS_01;
    $addinfosup->SUP_SYNONYMS_02 = $request->SUP_SYNONYMS_02;
    $addinfosup->SUP_PROP = $request->SUP_PROP;
    $addinfosup->SUP_TYPE_ID = $request->SUP_TYPE_ID;
    $addinfosup->SUP_TYPE_MASTER_ID = $request->SUP_TYPE_MASTER_ID;    
    $addinfosup->SUP_GROUP = $request->SUP_GROUP;
    $addinfosup->SUP_CAT = $request->SUP_CAT;
    $addinfosup->SUP_VENDOR_CODE = $request->SUP_VENDOR_CODE;
    $addinfosup->SUP_MANU = $request->SUP_MANU;
    $addinfosup->SUP_BUY = $request->SUP_BUY;

    $addinfosup->CONTENT = $request->CONTENT;
    $addinfosup->MIN = $request->MIN;
    $addinfosup->MAX = $request->MAX;
    $addinfosup->SUP_REMARK = $request->SUP_REMARK;
    $addinfosup->DIS_ACTIVE = $request->DIS_ACTIVE;
    $addinfosup->INNO_ACTIVE = $request->INNO_ACTIVE;
    $addinfosup->CONTINUE_PRICE_ID = $request->CONTINUE_PRICE_ID;

    if($request->hasFile('picture')){
        
        $file = $request->file('picture');  
        $contents = $file->openFile()->fread($file->getSize());
        $addinfosup->IMG = $contents;   
      
    }

    $addinfosup->save();


          
    $SUP_ID =  $id;
           
            if($request->checkid1!== 'null'){

                $idunit = $request->checkid1; 
                
                $add = Suppliesunitref::find($idunit);
                $add->SUP_ID = $SUP_ID;
                $add->SUP_UNIT_ID = $request->SUP_UNIT_ID0;
                $SUPUNITNAME = DB::table('supplies_unit')->where('SUP_UNIT_ID','=',$request->SUP_UNIT_ID0)->first();
                if($SUPUNITNAME == null){
                    $add->SUP_UNIT_NAME = '';
                }else{
                    $add->SUP_UNIT_NAME = $SUPUNITNAME->SUP_UNIT_NAME;
                }
                $add->SUP_TOTAL = $request->SUP_TOTAL0; 
                $add->save(); 

            }elseif($request->SUP_UNIT_ID0 !== null ){
                $add = new Suppliesunitref();
                $add->SUP_ID = $SUP_ID;
                $add->SUP_UNIT_ID = $request->SUP_UNIT_ID0;
                $SUPUNITNAME = DB::table('supplies_unit')->where('SUP_UNIT_ID','=',$request->SUP_UNIT_ID0)->first();
                if($SUPUNITNAME == null){
                    $add->SUP_UNIT_NAME = '';
                }else{
                    $add->SUP_UNIT_NAME = $SUPUNITNAME->SUP_UNIT_NAME;
                }
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
                if($SUPUNITNAME == null){
                    $add->SUP_UNIT_NAME = '';
                }else{
                    $add->SUP_UNIT_NAME = $SUPUNITNAME->SUP_UNIT_NAME;
                }
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
                if($SUPUNITNAME == null){
                    $add->SUP_UNIT_NAME = '';
                }else{
                    $add->SUP_UNIT_NAME = $SUPUNITNAME->SUP_UNIT_NAME;
                }
                $add->SUP_TOTAL = $request->SUP_TOTAL1; 
                $add->save(); 
            }
           
      

    $typedetail = $request->typedetail;



    return redirect()->route('mmedical.suppliesinfo');
}


//--------------------------แจ้งยกเลิก-----


public function medical_requestforbuy_cancel (Request $request,$id)
{
    
    $inforequest =  DB::table('supplies_request')
    ->where('ID','=',$id)->first();

    $inforequestsub =  DB::table('supplies_request_sub')
    ->where('SUPPLIES_REQUEST_ID','=',$id)->get();

    $infohr = DB::table('hrd_person')->where('ID','=',$inforequest->SAVE_HR_ID)->first();

    return view('manager_medical.medical_requestforbuy_cancel',[
        'inforequest' => $inforequest,
      'inforequestsubs' => $inforequestsub,
      'infohr' => $infohr
        
     
    ]);

}

public function medical_requestforbuy_update_cancel(Request $request)
{
    $id = $request->ID; 
    $iduser = $request->iduser;

    $updateapp = Suppliesrequest::find($id);
    $updateapp->STATUS = 'cancel'; 
    $updateapp->save();

   
      return redirect()->route('mmedical.requestforbuy');

}
 //-----------------------------
   
   public static function checkref($idref)
    {        
        $count =  Suppliescon::where('REQUEST_ID','=',$idref ) 
                                    ->count();      
        return $count;
    }


    function editsuppliesinfo(Request $request,$typedetail,$id)
    {

        if($typedetail == 'parcel'){
            $detail = '1';
        }elseif($typedetail == 'article'){
            $detail = '2';  
        }elseif($typedetail == 'service'){
            $detail = '3';   
        }else{
            $detail = '5';
        }

        $suppliestypekind = DB::table('supplies_type_kind')->where('SUP_TYPE_MASTER_ID','=',$detail)->get();
        $suppliestype = DB::table('supplies_type')->where('SUP_TYPE_MASTER_ID','=',$detail)->get();
        $suppliestypemaster = DB::table('supplies_type_master')->where('SUP_TYPE_MASTER_ID','=',$detail)->get();

        $infosupplie = DB::table('supplies')->where('ID','=',$id)->first();

        return view('manager_supplies.suppliesinfo_edit',[
            'suppliestypekinds' => $suppliestypekind,
            'suppliestypes' => $suppliestype,
            'suppliestypemasters' => $suppliestypemaster,
            'infosupplie' => $infosupplie,
            'typedetail' => $typedetail,
        ]);
    
    }

//=========================เพิ่มทรัพย์สินครุภัณท์

    function suppliesinfoinasset(Request $request,$id)
    {


        $infosupplie = DB::table('supplies')
        ->leftJoin('supplies_decline','supplies.DECLINE_ID','=','supplies_decline.DECLINE_ID')
        ->where('ID','=',$id)->first();

        $infosupplieinasset =  Assetarticle::leftJoin('supplies_decline','supplies_decline.DECLINE_ID','=','asset_article.DECLINE_ID')
        ->leftJoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','asset_article.DEP_ID')
        ->leftJoin('supplies_location','supplies_location.LOCATION_ID','=','asset_article.LOCATION_ID')
        ->leftJoin('supplies_location_level','supplies_location_level.LOCATION_LEVEL_ID','=','asset_article.LOCATION_LEVEL_ID')
        ->leftJoin('supplies_location_level_room','supplies_location_level_room.LEVEL_ROOM_ID','=','asset_article.LEVEL_ROOM_ID')
        ->where('SUP_FSN','=',$infosupplie->SUP_FSN_NUM )
        ->orderBy('ARTICLE_ID', 'desc') 
        ->get();

        return view('manager_supplies.suppliesinfoinasset',[
            'infosupplie' => $infosupplie,
            'infosupplieinassets' => $infosupplieinasset,
           
        ]);

    }


    function savesuppliesinfoinasset(Request $request,$id)
    {
        
        $infosupplie = DB::table('supplies')->where('ID','=',$id)->first();

        $infobudgetyear = DB::table('budget_year')->get();
       
        $infounit = DB::table('supplies_unit')->get();
        $inbrand = DB::table('supplies_brand')->get();
        $infocolor = DB::table('supplies_color')->get();
        $inmodel = DB::table('supplies_model')->get();
        $infosize = DB::table('supplies_size')->get();
        $infomethod = DB::table('supplies_method')->get();
        $infobuy = DB::table('supplies_buy')->get();
        $infobudget= DB::table('supplies_budget')->get();
        $infotype = DB::table('supplies_type')->get();
        $infodecline = DB::table('supplies_decline')->get();
        $infovendor= DB::table('supplies_vendor')->get();

        $infodep= DB::table('hrd_department_sub_sub')->get();
        $infolocation = DB::table('supplies_location')->get();
        $infolocationlevel = DB::table('supplies_location_level')->get();
        $infolocationlevelroom= DB::table('supplies_location_level_room')->get();

        $infoperson = DB::table('hrd_person')->get();
          
        $infostatus= DB::table('asset_status')->get();
        $infogroupcal = DB::table('asset_group_cal')->get();     
        $infogrouppm = DB::table('asset_group_pm')->get(); 
        $infogrouprisk = DB::table('asset_group_risk')->get();

        return view('manager_supplies.savesuppliesinfoinasset',[
            'infosupplie' => $infosupplie,
            'infobudgetyears' => $infobudgetyear,
            'infounits' => $infounit,
            'inbrands' => $inbrand,
            'infocolors' => $infocolor, 
            'inmodels' => $inmodel,
            'infosizes' => $infosize,   
            'infomethods' => $infomethod,
            'infobuys' => $infobuy,  
            'infobudgets' => $infobudget,
            'infotypes' => $infotype,   
            'infodeclines' => $infodecline,
            'infovendors' => $infovendor, 
            'infodeps' => $infodep,
            'infolocations' => $infolocation,   
            'infolocationlevels' => $infolocationlevel,
            'infolocationlevelrooms' => $infolocationlevelroom,  
            'infopersons' => $infoperson,  
            'infostatuss' => $infostatus,
            'infogroupcals' => $infogroupcal,
            'infogrouppms' => $infogrouppm,
            'infogrouprisks' => $infogrouprisk,
             
          
           
        ]);

    }

    

    public function saveinfosuppliesinfoinasset(Request $request)
    {
        $BUILD_CREATE= $request->RECEIVE_DATE;
        $BUILD_FINISH= $request->EXPIRE_DATE;
     

        if($BUILD_CREATE != ''){
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $BUILD_CREATE)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0]; 
            
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $RECEIVEDATE= $y_st."-".$m_st."-".$d_st;
            }else{
            $RECEIVEDATE= null;
        }


        if($BUILD_FINISH != ''){
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $BUILD_FINISH)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0]; 
            
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $EXPIRE_DATE= $y_st."-".$m_st."-".$d_st;
            }else{
            $EXPIRE_DATE= null;
        }

     


        $addinfoarticle = new Assetarticle(); 
        $addinfoarticle->ARTICLE_NUM = $request->ARTICLE_NUM;
        $addinfoarticle->YEAR_ID = $request->YEAR_ID;
        $addinfoarticle->ARTICLE_NAME = $request->ARTICLE_NAME;
        $addinfoarticle->ARTICLE_PROP = $request->ARTICLE_PROP;
        $addinfoarticle->UNIT_ID = $request->UNIT_ID;
        $addinfoarticle->SERIAL_NO = $request->SERIAL_NO;
        $addinfoarticle->BRAND_ID = $request->BRAND_ID;
        $addinfoarticle->COLOR_ID = $request->COLOR_ID;
        $addinfoarticle->MODEL_ID = $request->MODEL_ID;
        $addinfoarticle->SIZE_ID = $request->SIZE_ID;
        $addinfoarticle->PRICE_PER_UNIT = $request->PRICE_PER_UNIT;
        $addinfoarticle->RECEIVE_DATE = $RECEIVEDATE;
        $addinfoarticle->METHOD_ID = $request->METHOD_ID;
        $addinfoarticle->BUY_ID = $request->BUY_ID;
        $addinfoarticle->BUDGET_ID = $request->BUDGET_ID;
        $addinfoarticle->TYPE_ID = $request->TYPE_ID;
        $addinfoarticle->DECLINE_ID = $request->DECLINE_ID;
        $addinfoarticle->VENDOR_ID = $request->VENDOR_ID;
        $addinfoarticle->DEP_ID = $request->DEP_ID;
        $addinfoarticle->LOCATION_ID = $request->LOCATION_ID;
        $addinfoarticle->LOCATION_LEVEL_ID = $request->LOCATION_LEVEL_ID;
        $addinfoarticle->LEVEL_ROOM_ID = $request->LEVEL_ROOM_ID;
        $addinfoarticle->PERSON_ID = $request->PERSON_ID;
        $addinfoarticle->REMARK = $request->REMARK;
        $addinfoarticle->STATUS_ID = $request->STATUS_ID;
        $addinfoarticle->OLD_USE = $request->OLD_USE;

        $addinfoarticle->EXPIRE_DATE = $EXPIRE_DATE;

        $addinfoarticle->PM_TYPE_ID = $request->PM_TYPE_ID;
        $addinfoarticle->CAL_TYPE_ID = $request->CAL_TYPE_ID;
        $addinfoarticle->RISK_TYPE_ID = $request->RISK_TYPE_ID;
      
        $addinfoarticle->OPENS = 'False';
        $addinfoarticle->SUP_FSN = $request->SUP_FSN;

        if($request->hasFile('picture')){
            
            $file = $request->file('picture');  
            $contents = $file->openFile()->fread($file->getSize());
            $addinfoarticle->IMG = $contents;   
          
        }

       
    
        $addinfoarticle->save();
 

        return redirect()->route('msupplies.suppliesinfoinasset',[
            'id' => $request->ID,
        ]);
    }


//=======================================================

    function fetchsubtype(Request $request)
    {
                $id = $request->get('select');     

            $suppliestypekind = DB::table('supplies_type_kind')->where('SUP_TYPE_KIND_ID','=',$id)->first();

            $query= DB::table('supplies_type')->where('SUP_TYPE_MASTER_ID','=',$suppliestypekind->SUP_TYPE_MASTER_ID)
            ->get();
            $output='<option value="">--กรุณาเลือกหมวดพัสดุ--</option>';
            
            foreach ($query as $row){

                    $output.= '<option value="'.$row->SUP_TYPE_ID.'">'.$row->SUP_TYPE_NAME.'</option>';
            }

    echo $output;        
    }
    function checkfetchsubtype(Request $request)
    {
       
            $id = $request->get('select');
            
            if($id == 3 || $id == 5 ){
                $output = '  <div class="row">
                <div class="col-lg-3" >
                <label>ประเภทค่าเสื่อม :</label>
                </div> 
                <div class="col-lg-9" >
                <input name="" id="" class="form-control input-sm" style=" font-family: \'Kanit\', sans-serif;" >
                </div>
            </div>';
            }else{
                $output = "";
            }

            echo $output;
        
    }
    
    function fetchmedicine(Request $request)
    {
            
            $id = $request->get('select');
            
            if($id == 61 || $id == 62 ){
                $output = '   
                                                            
                            <div class="row push">
                                <div class="col-lg-2">
                                <label>ICODE :</label>
                                </div> 
                                <div class="col-lg-2">
                                <input name="" id="" class="form-control input-sm" style=" font-family: \'Kanit\', sans-serif;" >
                                </div> 
                                <div class="col-lg-2">
                                <label>รายการยา :</label>
                                </div> 
                                <div class="col-lg-6">
                                <input name="" id="" class="form-control input-sm" style=" font-family: \'Kanit\', sans-serif;" >
                                </div>
                            
                            </div>

                                                                
                            <div class="row push">
                                <div class="col-lg-2">
                                <label>STRENGTH :</label>
                                </div> 
                                <div class="col-lg-2">
                                <input name="" id="" class="form-control input-sm" style=" font-family: \'Kanit\', sans-serif;" >
                                </div> 
                                <div class="col-lg-2">
                                <label>ยูนิตย่อย :</label>
                                </div> 
                                <div class="col-lg-6">
                                <input name="" id="" class="form-control input-sm" style=" font-family: \'Kanit\', sans-serif;" >
                                </div>
                            
                            </div>
                            <div class="row push">
                                <div class="col-lg-2">
                                <label>DOSAGEFORM :</label>
                                </div> 
                                <div class="col-lg-7">
                                <input name="" id="" class="form-control input-sm" style=" font-family: \'Kanit\', sans-serif;" >
                                </div> 
                                <div class="col-lg-1">
                                <label>ราคา :</label>
                                </div> 
                                <div class="col-lg-2">
                                <input name="" id="" class="form-control input-sm" style=" font-family: \'Kanit\', sans-serif;" >
                                </div>
                            
                            </div>
                            <div class="row push">
                                <div class="col-lg-2">
                                <label>ราคากลาง :</label>
                                </div> 
                                <div class="col-lg-4">
                                <input name="" id="" class="form-control input-sm" style=" font-family: \'Kanit\', sans-serif;" >
                                </div> 
                                <div class="col-lg-2">
                                <label>ราคาอ้างอิง :</label>
                                </div> 
                                <div class="col-lg-4">
                                <input name="" id="" class="form-control input-sm" style=" font-family: \'Kanit\', sans-serif;" >
                                </div>
                            
                            </div>

                            <div class="row push">
                                <div class="col-lg-2">
                                <label>DID :</label>
                                </div> 
                                <div class="col-lg-3">
                                <input name="" id="" class="form-control input-sm" style=" font-family: \'Kanit\', sans-serif;" >
                                </div> 
                                <div class="col-lg-2">
                                <label>การใช้ต่อเดือน :</label>
                                </div> 
                                <div class="col-lg-2">
                                <input name="" id="" class="form-control input-sm" style=" font-family: \'Kanit\', sans-serif;" >
                                </div>
                                <div class="col-lg-1">
                                <label>มูลค่า :</label>
                                </div> 
                                <div class="col-lg-2">
                                <input name="" id="" class="form-control input-sm" style=" font-family: \'Kanit\', sans-serif;" >
                                </div>
                            
                            </div>

                            <div class="row push">
                                <div class="col-lg-2">
                                <label>TMT :</label>
                                </div> 
                                <div class="col-lg-3">
                                <input name="" id="" class="form-control input-sm" style=" font-family: \'Kanit\', sans-serif;" >
                                </div> 
                                <div class="col-lg-2">
                                <label>การใช้ต่อปี :</label>
                                </div> 
                                <div class="col-lg-2">
                                <input name="" id="" class="form-control input-sm" style=" font-family: \'Kanit\', sans-serif;" >
                                </div>
                            
                            
                            </div>

                            <div class="row push">
                                <div class="col-lg-2">
                                <label>กลุ่มยา :</label>
                                </div> 
                                <div class="col-lg-4">
                                <input name="" id="" class="form-control input-sm" style=" font-family: \'Kanit\', sans-serif;" >
                                </div> 
                                <div class="col-lg-2">
                                <label>ประเภทยา :</label>
                                </div> 
                                <div class="col-lg-4">
                                <input name="" id="" class="form-control input-sm" style=" font-family: \'Kanit\', sans-serif;" >
                                </div>
                            
                            
                            </div>

                            <div class="row push">
                                <div class="col-lg-2">
                                <label>ประเภทจัดซื้อ :</label>
                                </div> 
                                <div class="col-lg-4">
                                <input name="" id="" class="form-control input-sm" style=" font-family: \'Kanit\', sans-serif;" >
                                </div> 
                                <div class="col-lg-2">
                                <label>ED/NED :</label>
                                </div> 
                                <div class="col-lg-4">
                                <input name="" id="" class="form-control input-sm" style=" font-family: \'Kanit\', sans-serif;" >
                                </div>
                            
                            
                            </div>';
            }else{
                $output = '';
            }

            echo $output;
        
    }    
//---------------------2.10.2562--------------------------//

    public function datasuplies()
    {      
        $suppliestypekind = DB::table('supplies_type_kind')->get();
        $suppliestype = DB::table('supplies_type')->get();
        $typekind_check = '';
        $type_check = '';
        $search = '';
        return view('manager_supplies.datasuplies',[
            'suppliestypes' => $suppliestype,
            'suppliestypekinds' => $suppliestypekind,
            'typekind_check' => $typekind_check,
            'type_check' => $type_check,
            'search' => $search
        ]);

    }

    public function requestforbuy(Request $request)
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
                    $q->where('REQUEST_FOR_ID','=','61');
                    $q->orwhere('REQUEST_FOR_ID','=','62');
                    $q->orwhere('REQUEST_FOR_ID','=','22');
                    $q->orwhere('REQUEST_FOR_ID','=','7');
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
                    $q->where('REQUEST_FOR_ID','=','61');
                    $q->orwhere('REQUEST_FOR_ID','=','62');
                    $q->orwhere('REQUEST_FOR_ID','=','22');
                    $q->orwhere('REQUEST_FOR_ID','=','7');
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
                    $q->where('REQUEST_FOR_ID','=','61');
                    $q->orwhere('REQUEST_FOR_ID','=','62');
                    $q->orwhere('REQUEST_FOR_ID','=','22');
                    $q->orwhere('REQUEST_FOR_ID','=','7');
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
                    $q->where('REQUEST_FOR_ID','=','61');
                    $q->orwhere('REQUEST_FOR_ID','=','62');
                    $q->orwhere('REQUEST_FOR_ID','=','22');
                    $q->orwhere('REQUEST_FOR_ID','=','7');
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


        return view('manager_medical.requestforbuy',[
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

    public function requestforbuysearch(Request $request)
    {
       

        $search = $request->get('search');
        $status = $request->SEND_STATUS;
        $yearbudget = $request->YEAR_ID;
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

             
                $inforequest = Suppliesrequest::leftJoin('supplies_request_status','supplies_request_status.STATUS_CODE','=','supplies_request.STATUS')
                ->where('BUDGET_YEAR','=', $yearbudget)
                ->where(function($q){
                    $q->where('REQUEST_FOR_ID','=','61');
                    $q->orwhere('REQUEST_FOR_ID','=','62');
                    $q->orwhere('REQUEST_FOR_ID','=','22');
                    $q->orwhere('REQUEST_FOR_ID','=','7');
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
                    $q->where('REQUEST_FOR_ID','=','61');
                    $q->orwhere('REQUEST_FOR_ID','=','62');
                    $q->orwhere('REQUEST_FOR_ID','=','22');
                    $q->orwhere('REQUEST_FOR_ID','=','7');
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
                    $q->where('REQUEST_FOR_ID','=','61');
                    $q->orwhere('REQUEST_FOR_ID','=','62');
                    $q->orwhere('REQUEST_FOR_ID','=','22');
                    $q->orwhere('REQUEST_FOR_ID','=','7');
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
                    $q->where('REQUEST_FOR_ID','=','61');
                    $q->orwhere('REQUEST_FOR_ID','=','62');
                    $q->orwhere('REQUEST_FOR_ID','=','22');
                    $q->orwhere('REQUEST_FOR_ID','=','7');
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


        return view('manager_medical.requestforbuy',[
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
    public function medical_requestforbuy_add(Request $request)
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

        $suppliestypekind = DB::table('supplies_type_kind')->get();
        $suppliestype = DB::table('supplies_type')->get();
        $infoper = DB::table('hrd_person')->get();
        $infodepartment = DB::table('hrd_department_sub_sub')->get();

        $inforequest = Suppliesrequest::leftJoin('supplies_request_status','supplies_request_status.STATUS_CODE','=','supplies_request.STATUS')
        ->orderBy('supplies_request.ID', 'desc')      
        ->get();

        $typekind_check = '';
        $type_check = '';
        $search = '';

        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;
        }

        $budget = DB::table('budget_year')->where('ACTIVE','=','True')->orderBy('LEAVE_YEAR_ID', 'desc')->get();



        $suppliestype = DB::table('supplies_type')->where('ACTIVE','=','True')->get();

        $pessonall = Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')->orderBy('hrd_person.HR_FNAME', 'asc')->get();

        $departmentsubsub = DB::table('hrd_department_sub_sub')->where('ACTIVE','=','True')->get();

        $orgname = DB::table('info_org')->first();

        $personhead =  DB::table('hrd_department_sub_sub')->where('HR_DEPARTMENT_SUB_SUB_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)->first();

        $suppliesvendor = DB::table('supplies_vendor')->where('ACTIVE','=','True')->get();
    


        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;
        }

        
        $phone = DB::table('hrd_department_sub_sub')->where('HR_DEPARTMENT_SUB_SUB_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)->first();


        return view('manager_medical.medical_requestforbuy_add',[
            'budgets' => $budget,
            'inforpersonuser' => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid,
            'suppliestypes' => $suppliestype,
            'pessonalls' => $pessonall,
            'departmentsubsubs' => $departmentsubsub,
            'orgname' => $orgname->ORG_NAME,
            'suppliesvendors' => $suppliesvendor,
            'personhead' => $personhead,
            'phone' => $phone,
            'year_id' => $yearbudget
            
        ]); 
    }

    //=============================ฟังชันสิทธิ์เข้าถึง

public static function checkapp($id_user)
{
     $count =  Permislist::where('PERSON_ID','=',$id_user)
                           ->where('PERMIS_ID','=','GSU002')
                           ->count();

     return $count;
}

public static function checkallow($id_user)
{
     $count =  Permislist::where('PERSON_ID','=',$id_user)
                           ->where('PERMIS_ID','=','GSU003')
                           ->count();

     return $count;
}

public static function countapp($id_user)
{
    // $inforpersonuser=  Person::where('ID','=',$id_user)->first();

    // $count = Suppliesrequest::leftJoin('supplies_request_status','supplies_request_status.STATUS_CODE','=','supplies_request.STATUS')
    // ->where('DEP_SUB_SUB_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)
    // ->where('STATUS','=','Pending')
    // ->count();

    //  return $count;
}
public static function countallow($id_user)
{
    $inforpersonuser=  Person::where('ID','=',$id_user)->first();

    $count = Suppliesrequest::leftJoin('supplies_request_status','supplies_request_status.STATUS_CODE','=','supplies_request.STATUS')
    ->where('STATUS','=','Verify')
    ->count();
    
     return $count;
}


public function medical_requestforbuy_save(Request $request)
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



   $m_budget = date("m");
   if($m_budget>9){
   $yearbudget = date("Y")+544;
   }else{
   $yearbudget = date("Y")+543;
   }

//===============================สร้างเลขREQ

$maxnumber = DB::table('supplies_request')->where('BUDGET_YEAR','=',$yearbudget)->max('ID');     
if($maxnumber != '' ||  $maxnumber != null){        
    $refmax = DB::table('supplies_request')->where('ID','=',$maxnumber)->first();  
    if($refmax->REQUEST_ID != '' ||  $refmax->REQUEST_ID != null){
        $maxref = substr($refmax->REQUEST_ID, -4)+1;
     }else{
        $maxref = 1;
     }
    $ref = str_pad($maxref, 4, "0", STR_PAD_LEFT);        
}else{
    $ref = '0001';
}       
$y = substr($yearbudget, -2); 
   $refnumber ='REQ-'.$y.''.$ref;

   $addinforequest = new Suppliesrequest();
   $addinforequest->REQUEST_ID = $refnumber;
   $addinforequest->REQUEST_HEAD = $request->REQUEST_HEAD;
   $addinforequest->DATE_WANT = $DATEWANT;
   $addinforequest->DATE_TIME_SAVE = date('Y-m-d H:i:s');


   $addinforequest->REQUEST_FOR_ID = $request->REQUEST_FOR_ID;
   $name_type = DB::table('supplies_type')->where('SUP_TYPE_ID','=',$request->REQUEST_FOR_ID)->first();
   $addinforequest->REQUEST_FOR = $name_type->SUP_TYPE_NAME;

   $addinforequest->DEP_SUB_SUB_ID = $request->DEP_SUB_SUB_ID;
   $addinforequest->DEP_SUB_SUB_PHONE = $request->DEP_SUB_SUB_PHONE;

   $addinforequest->SAVE_HR_ID = $request->SAVE_HR_ID;


     //----------------------------------
     $SAVEHR =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
     ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
     ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
     ->where('hrd_person.ID','=',$request->SAVE_HR_ID)->first();

           $addinforequest->SAVE_HR_NAME = $SAVEHR->HR_PREFIX_NAME.''.$SAVEHR->HR_FNAME.' '.$SAVEHR->HR_LNAME;
           $addinforequest->SAVE_HR_POSITION = $SAVEHR->HR_POSITION_NAME;
           $addinforequest->SAVE_HR_DEP_SUB_NAME = $SAVEHR->HR_DEPARTMENT_SUB_NAME;

      //----------------------------------

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

           $addinforequest->STATUS = 'Pending';

           $addinforequest->BUDGET_YEAR = $request->YEAR_ID;

           $addinforequest->REQUEST_VANDOR_ID = $request->REQUEST_VANDOR_ID;

          if($request->REQUEST_VANDOR_ID <> ''){
           $infovendor = DB::table('supplies_vendor')->where('VENDOR_ID','=',$request->REQUEST_VANDOR_ID)->first();
           $addinforequest->REQUEST_VANDOR_NAME = $infovendor->VENDOR_NAME;
          }else{
         
           $addinforequest->REQUEST_VANDOR_NAME = '';
          }
          


           $addinforequest->REQUEST_REMARK = $request->REQUEST_REMARK;

           $addinforequest->save();



           $SUPPLIES_REQUEST_ID = Suppliesrequest::max('ID');

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



   return redirect()->route('mmedical.requestforbuy',[
       'iduser' => $request->SAVE_HR_ID,

   ]);
}


public function medical_requestforbuy_edit(Request $request,$id)
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

    return view('manager_medical.medical_requestforbuy_edit',[
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

public function medical_requestforbuy_update(Request $request)
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

    
            return redirect()->route('mmedical.requestforbuy');
}

    public function medical_purchaselist_add(Request $request,$idlistref)
    {
        
        
        $infosuppliecon = Suppliescon::leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
        ->where('ID','=',$idlistref)->first();

        $infosuppliecon = Suppliescon::leftJoin('supplies_request','supplies_con.REQUEST_ID','=','supplies_request.ID')
        ->leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
        ->where('supplies_con.ID','=',$idlistref)->first();

        $infosuppliecheck = Suppliescon::leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
        ->where('supplies_con.ID','=',$idlistref)->first();

        $infoasset = Supplies::where('SUP_TYPE_ID','=',$infosuppliecon->SUP_TYPE_ID)
        ->leftJoin('medical_type_item','supplies.SUP_GENUS','=','medical_type_item.TYPE_ITEM_ID')
        ->get();

        $sumprice = Suppliesconlist::where('supplies_con_list.CON_ID','=',$idlistref)
        ->sum('PRICE_SUM');


        $infosuppliescon =  DB::table('supplies_con_list')->where('CON_ID','=',$infosuppliecheck->ID)->get();

        $countcheck =  DB::table('supplies_con_list')->where('CON_ID','=',$infosuppliecheck->ID)->count();
    

    
        return view('manager_medical.medical_purchaselist_add',[
            'connum' => $infosuppliecon->CON_NUM,
            'condetail' => $infosuppliecon->CON_DETAIL,
            'resonname' => $infosuppliecon->RESON_NAME,
            'personrequestname' => $infosuppliecon->PERSON_REQUEST_NAME,
            'regisbyname' => $infosuppliecon->REGIS_BY_NAME,
            'suptypename' => $infosuppliecon->SUP_TYPE_NAME,
            'infoassets' => $infoasset,
            'infosuppliescons' => $infosuppliescon,
            'countcheck' => $countcheck,
            'conid' => $infosuppliecheck->ID,
            'requestid' => $infosuppliecon->REQUEST_ID,
            'infosuppliecon' => $infosuppliecon,
            'sumprice' => $sumprice,
        ]);

    }

    
    public function medical_savepurchaselist(Request $request)
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

               $sumpice = $PRICE_PER_UNIT[$count] * $SUP_TOTAL[$count];

               $addsuppliesconlist->SUP_NAME= $infosupname->SUP_NAME; 
               $addsuppliesconlist->SUP_TOTAL = $SUP_TOTAL[$count];
               $addsuppliesconlist->SUP_UNIT_ID = $SUP_UNIT_ID[$count];
               $addsuppliesconlist->PRICE_PER_UNIT = $PRICE_PER_UNIT[$count];
               $addsuppliesconlist->PRICE_SUM =$sumpice; 
               
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
        $updateapp->TAX_TYPE = $request->TAX_TYPE;
        $updateapp->DISCOUNT = $request->DISC;
        $updateapp->save();
      
    
        return redirect()->route('mmedical.purchase');
        
   
        
    }

    public function medical_purchaselist_edit(Request $request,$idlistref)
    {
        
        $infosuppliecon = Suppliescon::leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
        ->where('ID','=',$idlistref)->first();

        $infoasset = Supplies::where('SUP_TYPE_ID','=',$infosuppliecon->SUP_TYPE_ID)->get();


        $infosuppliescon =  DB::table('supplies_con_list')->where('CON_ID','=',$infosuppliecon->ID)->get();

        $countcheck =  DB::table('supplies_con_list')->where('CON_ID','=',$infosuppliecon->ID)->count();

        return view('manager_medical.medical_purchaselist_edit',[
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
        ]);

    }

    public function medical_purchasequotation_add(Request $request,$id)
    {
        $detailcon = Suppliescon::where('ID','=',$id)->first();

        $detailquotation= Suppliesconquotation::leftJoin('supplies_vendor','supplies_con_quotation.QUOTATION_VENDOR_ID','=','supplies_vendor.VENDOR_ID')
        ->where('QUOTATION_CON_NUM','=',$detailcon->CON_NUM)->orderBy('QUOTATION_WIN', 'desc')->get();

        return view('manager_medical.medical_purchasequotation_add',[
            'CON_NUM' => $detailcon->CON_NUM,
            'IDCON' => $id,
            'detailquotations' => $detailquotation,
        ]);
    }

    public function medical_purchasequotation_addsub(Request $request,$id)
    {
         $detailcon = Suppliescon::where('ID','=',$id)->first();

        $vendor =  DB::table('supplies_vendor')->where('ACTIVE','=','True')->get();
        $infosuppliecon = Suppliescon::leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
        ->where('ID','=',$id)->first();


        return view('manager_medical.medical_purchasequotation_addsub',[
            'CON_NUM' => $detailcon->CON_NUM,
            'IDCON' => $id,
            'requestid' => $infosuppliecon->REQUEST_ID,
            'vendors' => $vendor
        ]);
    }

    public function medical_savepurchasequotationsub(Request $request)
    {
        $request->validate([
            'QUOTATION_NUMBER' => 'required',
            'QUOTATION_VENDOR_ID' => 'required',
            'QUOTATION_VENDOR_TAXNUM' => 'required',
            'QUOTATION_VENDOR_PICE' => 'required',
        ]);
       
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
  
      
    
        return redirect()->route('mmedical.medical_purchasequotation_add',[
            'id' =>$request->ID,
        ]);
        
   
        
    }

    public function   medical_purchasequotation_editsub(Request $request,$id,$idref)
    {
        $detailcon = Suppliescon::where('ID','=',$id)->first();

        $vendor =  DB::table('supplies_vendor')->where('ACTIVE','=','True')->get();

        $detailquotation = Suppliesconquotation::where('QUOTATION_ID','=',$idref)->first();
   
        return view('manager_medical.medical_purchasequotation_editsub',[
            'CON_NUM' => $detailcon->CON_NUM,
            'IDCON' => $id,
            'IDREF' => $idref,
            'vendors' => $vendor,
            'detailquotation' => $detailquotation,
        ]);
        
    }


public function medical_purchasequotation_addsubupdate(Request $request)
{
    $request->validate([
        'QUOTATION_NUMBER' => 'required',
        'QUOTATION_VENDOR_ID' => 'required',
        'QUOTATION_VENDOR_TAXNUM' => 'required',
        'QUOTATION_VENDOR_PICE' => 'required',
    ]);

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

           return redirect()->route('mmedical.medical_purchasequotation_add',[
            'id' =>$request->ID,
        ]);
    

    
}


public function medical_purchasequotationsubdelete($id,$idref) { 
                
    Suppliesconquotation::destroy($idref);         
    return redirect()->route('mmedical.medical_purchasequotation_add',[
        'id' =>$id,
    ]);
}

    public function medical_purchascheck(Request $request,$idlistref)
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
        return view('manager_medical.medical_purchascheck',[
            'infosuppliecon' => $infosuppliecon,
            'infosuppliesconlists' => $infosuppliesconlist, 
            'infovendor' => $infovendor, 
            'pessonalls' => $pessonall, 
            'sumprice' => $sumprice, 
            'maxnumberch' => $maxnumberch,
        ]);
    }

    
    
    

public function medical_purchascheck_save(Request $request)
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
                        


       return redirect()->route('mmedical.purchase'); 

}    




//======การตรวจรับ==========================

public function medical_purchasequotation_confirm($id)
{
 
    $updateapp = Suppliescon::find($id);
    $updateapp->REGIS_STATUS_ID = '7'; 
    $updateapp->save();

    return redirect()->route('mmedical.purchase'); 

}



public function medical_send_infomation(Request $request,$id)
{
         //=====ส่งข้อมูลไปคลัง=====

         
     
        $infosupcon = DB::table('supplies_con')->where('ID','=',$id)->first();

         $RECEIVE_ID = Warehousecheckreceive::max('RECEIVE_ID'); 

         $RECEIVE_CODE = 'RE-'.str_pad($RECEIVE_ID+1,4,"0",STR_PAD_LEFT);

        $addinfocheck = new Warehousecheckreceive();
       
        $addinfocheck->RECEIVE_CODE = $RECEIVE_CODE;
        $addinfocheck->RECEIVE_ACCEPT_FROM =  $infosupcon->VENDOR_NAME ;
        $addinfocheck->RECEIVE_CHECK_DATE =  date('Y-m-d');
        $addinfocheck->RECEIVE_BUDGET_YEAR =  $infosupcon->CON_YEAR_ID  ;
        $addinfocheck->RECEIVE_PO= $infosupcon->PO_NUM  ;
        $addinfocheck->RECEIVE_VALUE =  $infosupcon->BUDGET_SUM  ;
        $addinfocheck->RECEIVE_CHECK_TYPE = '1';
        $addinfocheck->RECEIVE_CHECK_STATUS = '2';
        $addinfocheck->RECEIVE_STORE = '2';
        
        $addinfocheck->save();


        $RECEIVE_ID_SUB = Warehousecheckreceive::max('RECEIVE_ID'); 

        
        $infosupconlists = DB::table('supplies_con_list')->where('CON_ID','=',$id)->get();



        foreach ($infosupconlists as $infosupconlist) {

            $add = new Warehousecheckreceivesub();
            $add->RECEIVE_ID = $RECEIVE_ID_SUB;
            $add->RECEIVE_SUB_NAME = $infosupconlist->SUP_NAME;
            $add->RECEIVE_SUB_UNIT = $infosupconlist->SUP_UNIT_ID;
            $add->RECEIVE_SUB_AMOUNT = $infosupconlist->SUP_TOTAL;
            $add->RECEIVE_SUB_PICE_UNIT = $infosupconlist->PRICE_PER_UNIT;
            $add->RECEIVE_SUB_VALUE = $infosupconlist->PRICE_SUM;
            $add->RECEIVE_SUB_CODE = $infosupconlist->SUP_ID;
            $add->save();

            

            }


         $updateapp = Suppliescon::find($id);
         $updateapp->REGIS_STATUS_ID = '8'; 
         $updateapp->save();
    
       
         //=====ส่งข้อมูลไปบัญชี=====http://127.0.0.1/gtwbackoffice/manager_supplies/purchase (เมนูส่งข้อมูลไปคลัง)

        

    //$year = date('Y')+543;

        // $maxnumber = DB::table('account')->where('ACCOUNT_YEAR','=',$year)
        // ->where('ACCOUNT_TYPE','=','05')
        // ->max('ACCOUNT_ID');  
 

      // $refmax = DB::table('account')->where('ACCOUNT_ID','=',$maxnumber)->first();  
 
      // if($maxnumber != '' ||  $maxnumber != null){
      // if($refmax->ACCOUNT_ID != '' ||  $refmax->ACCOUNT_ID != null){
      //           $maxref = substr($refmax->ACCOUNT_NUMBER, -5)+1;
     //  }else{
     //            $maxref = 1;
     //  }
           
      // $ref = str_pad($maxref, 5, "0", STR_PAD_LEFT);
        
     //  }else{
      //       $ref = '00001';
      // }
      //   $ye = date('Y')+543;
      //   $y = substr($ye, -2);
 
 
      //   $ACCOUNT_NUMBER = 'บท'.$y.'/5'.$ref;
         
         
      //   $addinfo = new Account();
      //   $addinfo->ACCOUNT_TYPE = '05';
      //   $addinfo->ACCOUNT_YEAR =  $year;

         
      //   $addinfo->ACCOUNT_VENDOR = $infosupcon->VENDOR_NAME;
      //   $infoidven = DB::table('supplies_vendor')->where('VENDOR_NAME','=',$infosupcon->VENDOR_NAME)->first();
      //   $addinfo->ACCOUNT_VENDOR_ID =  $infoidven->VENDOR_ID;


      //   $addinfo->ACCOUNT_NUMBER = $ACCOUNT_NUMBER;
      //   $addinfo->ACCOUNT_OUT_DATE =  date('Y-m-d');
      //   $addinfo->ACCOUNT_TEXPICE = '1';
      //   $addinfo->ACCOUNT_STATUS = 'SAVE';
      //   $addinfo->ACCOUNT_INVOICE_NUM = $infosupcon->INVOICE_NUM;;
      //   $addinfo->save();

         

        // $ACCOUNTID  = Account::max('ACCOUNT_ID');


      //   $BUDGET_SUM = number_format($infosupcon->BUDGET_SUM,2,'.','');
     
       
      //   $infodebil = DB::table('account_chart')
      //   ->where('ACCOUNT_CHART_SUPTYPEID','=',$infosupcon->SUP_TYPE_ID)
       //  ->where('ACCOUNT_CHART_DC','=','debit')
       //  ->first();  
     
       //    $addaccsub = new Accountsub();
       //    $addaccsub->ACCOUNT_ID = $ACCOUNTID;
       //    $addaccsub->ACCOUNT_SUB_NUM = $infodebil->ACCOUNT_CHART_CODE;
       //    $addaccsub->ACCOUNT_SUB_DETAIL = $infodebil->ACCOUNT_CHART_NAME;
       //    $addaccsub->ACCOUNT_SUB_DEBIT = $BUDGET_SUM;
       //    $addaccsub->ACCOUNT_SUB_CREDIT = ''; 
      //     $addaccsub->save(); 

          
       //    $infocredit = DB::table('account_chart')
       //  ->where('ACCOUNT_CHART_SUPTYPEID','=',$infosupcon->SUP_TYPE_ID)
      //   ->where('ACCOUNT_CHART_DC','=','credit')
      //   ->first();  

       //    $addaccsub = new Accountsub();
       //    $addaccsub->ACCOUNT_ID = $ACCOUNTID;
       //    $addaccsub->ACCOUNT_SUB_NUM = $infocredit->ACCOUNT_CHART_CODE;
       //    $addaccsub->ACCOUNT_SUB_DETAIL = $infocredit->ACCOUNT_CHART_NAME;
       //    $addaccsub->ACCOUNT_SUB_DEBIT = '';
        //   $addaccsub->ACCOUNT_SUB_CREDIT = $BUDGET_SUM; 
       //    $addaccsub->save(); 


       return redirect()->route('mmedical.purchase'); 
}




    public function medical_inforequestverupdate(Request $request)
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
              return redirect()->route('mmedical.requestforbuy');
    
    }

    public function medical_purchase_register(Request $request,$id)
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

        if($maxnum !== null && $maxnum !== ''){
        $lnum = substr($maxnum->CON_NUM,-4); 
      
        $lastnum_num = (int)$lnum+1;
        
        $lastnum =  str_pad($lastnum_num,4,"0",STR_PAD_LEFT);
        }else{
            $lastnum =  '0001';
        }


        $maxnumberuse =  $hnum.'-'.$lastnum;


        if($id == 'null'){

            $REQUEST_ID = '';
            $REQUEST_NAME = '';
            $DEP_REQUEST_ID =  '';
            $PERSON_REQUEST_ID =  '';

            $SUP_TYPE_ID =  '';

        }else{
            $infosuppliesrequest = DB::table('supplies_request')->where('ID','=',$id)->first();

            $REQUEST_ID = $infosuppliesrequest->ID;
            $REQUEST_NAME =  $infosuppliesrequest->ID.'::'.$infosuppliesrequest->REQUEST_FOR.'::'.$infosuppliesrequest->REQUEST_BUY_COMMENT;
            $DEP_REQUEST_ID =  $infosuppliesrequest->DEP_SUB_SUB_ID;
            $PERSON_REQUEST_ID =  $infosuppliesrequest->SAVE_HR_ID;


            $SUP_TYPE_ID =  $infosuppliesrequest->REQUEST_FOR_ID;
        }

        $infoofficer = DB::table('hrd_person')->get();

        $medicalsetup = DB::table('medical_setup')->first();
        
    
        $suppliesconboardlist = DB::table('supplies_con_board_list')->get();
        return view('manager_medical.medical_purchase_register',[
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
            'suppliesconboardlists' => $suppliesconboardlist,
            'infoofficers' => $infoofficer,
            'medicalsetup' => $medicalsetup,
           
        ]);
        
    }
    public function medical_purchaseregister_save(Request $request)
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

        if($maxnum !== null && $maxnum !== ''){
        $lnum = substr($maxnum->CON_NUM,-4); 
      
        $lastnum_num = (int)$lnum+1;
        
        $lastnum =  str_pad($lastnum_num,4,"0",STR_PAD_LEFT);
        }else{
            $lastnum =  '0001';
        }


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

          if($PURCHASE_OFFICER == null ){
            $addsuppliescon->COMMIT_HR_NAME = '';
            $addsuppliescon->COMMIT_HR_POSITION =  '';
          }else{
            $addsuppliescon->COMMIT_HR_NAME = $PURCHASE_OFFICER->HR_PREFIX_NAME.''.$PURCHASE_OFFICER->HR_FNAME.' '.$PURCHASE_OFFICER->HR_LNAME;
            $addsuppliescon->COMMIT_HR_POSITION = $PURCHASE_OFFICER->POSITION_IN_WORK;
          }
  
         

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
      
 
        
         return redirect()->route('mmedical.purchase');

        }

    public function medical_purchaseregister_edit(Request $request,$id)
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
           
           

           $infoSuppliesconboard = Suppliesconboard::where('CON_ID','=',$id)->get();
           $countcheck =  Suppliesconboard::where('CON_ID','=',$id)->count();

           $infoSuppliesconboarddetail = Suppliesconboarddetail::where('CON_ID','=',$id)->get();
           $countcheckdetail =  Suppliesconboarddetail::where('CON_ID','=',$id)->count();

           $suppliesconboardlist = DB::table('supplies_con_board_list')->get();

           $infoofficer = DB::table('supplies_officer')->get();
           
        return view('manager_medical.medical_purchaseregister_edit',[
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
            'suppliesconboardlists' => $suppliesconboardlist,
            'infoofficers' => $infoofficer,
        ]);
        
    }


  public function medical_purchaseregister_update(Request $request)
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
  
          if($PURCHASE_OFFICER == null ){
            $addsuppliescon->COMMIT_HR_NAME = '';
            $addsuppliescon->COMMIT_HR_POSITION =  '';
          }else{
            $addsuppliescon->COMMIT_HR_NAME = $PURCHASE_OFFICER->HR_PREFIX_NAME.''.$PURCHASE_OFFICER->HR_FNAME.' '.$PURCHASE_OFFICER->HR_LNAME;
            $addsuppliescon->COMMIT_HR_POSITION = $PURCHASE_OFFICER->POSITION_IN_WORK;
          }
  
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
   
           
            return redirect()->route('mmedical.purchase');
   
           }




    public function medical_purchaseboard_add(Request $request)
    {
        $infoper = DB::table('hrd_person')->get();
        return view('manager_medical.medical_purchaseboard_add',[
            'infopers'=>$infoper
        ]);
        
    }
    
//------------------------------ยกเลิก

public function medical_purchasecancel(Request $request,$id)
{
    $infosuppliecon = Suppliescon::leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
    ->where('ID','=',$id)->first();

    return view('manager_medical.medical_purchasecancel',[
        'connum' => $infosuppliecon->CON_NUM,
        'condetail' => $infosuppliecon->CON_DETAIL,
        'resonname' => $infosuppliecon->RESON_NAME,
        'personrequestname' => $infosuppliecon->PERSON_REQUEST_NAME,
        'regisbyname' => $infosuppliecon->REGIS_BY_NAME,
        'suptypename' => $infosuppliecon->SUP_TYPE_NAME,
        'conid' => $infosuppliecon->ID,

    ]);
    
}


public function medical_purchasecancelupdate(Request $request)
{
        $id = $request->CON_ID; 

        $updateapp = Suppliescon::find($id);
        $updateapp->REGIS_STATUS_ID = '6'; 
        $updateapp->save();

        return redirect()->route('mmedical.purchase'); 

}


public function medical_purchaseorders_add(Request $request,$idlistref)
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
 
        $infoorg = DB::table('info_org')->first();

    return view('manager_medical.medical_purchaseorders_add',[
        'maxnumberpo' => $maxnumberpo,
        'infosuppliecon' => $infosuppliecon,
        'infosuppliesconlists' => $infosuppliesconlist,
        'sumprice' => $sumprice,  
        'pessonalls' => $pessonall, 
        'vendor' => $vendor, 
        'infoorg' => $infoorg, 
    ]);
    
}


public function medical_purchaseorders_save(Request $request)
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

                        


       return redirect()->route('mmedical.purchase'); 

} 
  //==========================================================================================//  

    public function createrequestforbuy(Request $request)
    {
    
        return view('manager_supplies.requestforbuy_add');
        
    }
    
    //==========================================จีดซื้อจัดจ้าง======

    public function purchase(Request $request)
    {    
        if($request->method() === 'POST'){
            $search = $request->get('search');
            $status = $request->SEND_STATUS;
            $yearbudget = $request->BUDGET_YEAR;
            $datebigin = $request->get('DATE_BIGIN');
            $dateend = $request->get('DATE_END');
            $dateselect = $request->DATE_SELECT;
            session([
                'manager_medical.purchase.search' => $search,
                'manager_medical.purchase.status' => $status,
                'manager_medical.purchase.yearbudget' => $yearbudget,
                'manager_medical.purchase.datebigin' => $datebigin,
                'manager_medical.purchase.dateend' => $dateend,
                'manager_medical.purchase.dateselect' => $dateselect,
            ]);
        }else if(Session::has('manager_medical.purchase')){
            $search = session('manager_medical.purchase.search');
            $status = session('manager_medical.purchase.status');
            $yearbudget = session('manager_medical.purchase.yearbudget');
            $datebigin = session('manager_medical.purchase.datebigin');
            $dateend = session('manager_medical.purchase.dateend');
            $dateselect = session('manager_medical.purchase.dateselect');
        }else{
            $search = '';
            $status = '';
            $yearbudget = getBudgetyear();
            $datebigin = date('1/m/Y');
            $dateend = date('d/m/Y',strtotime(date('Y-m-1').' +1month -1day'));
            $dateselect = getBudgetyear();
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

                    if($dateselect == 'd2'){
                        $DATESELECT = 'CHECK_DATE';
                    }else{
                        $DATESELECT = 'DATE_REGIS';
                    }
        if($status == null){
            $infosupcon = Suppliescon::select('supplies_con.ID','CON_YEAR_ID','CON_NUM','supplies_request.REQUEST_ID','REGIS_STATUS_NAME','DATE_REGIS','EGP_PLAN_NAME','SUP_TYPE_NAME','VENDOR_NAME','supplies_con.BUDGET_SUM','CHECK_DATE','supplies_status_regis.REGIS_STATUS_ID','supplies_con.SUP_TYPE_ID')
            ->leftJoin('supplies_status_regis','supplies_con.REGIS_STATUS_ID','=','supplies_status_regis.REGIS_STATUS_ID')
            ->leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
            ->leftJoin('supplies_request','supplies_con.REQUEST_ID','=','supplies_request.ID')
            ->where('supplies_con.CON_YEAR_ID','=',$yearbudget)

            ->where(function($q) use ($search){
                $q->where('EGP_PLAN_NAME','like','%'.$search.'%');
                $q->orwhere('VENDOR_NAME','like','%'.$search.'%');
                $q->orwhere('CON_NUM','like','%'.$search.'%'); 
                $q->orwhere('supplies_con.BUDGET_SUM','like','%'.$search.'%');  
                $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');    
                $q->orwhere('supplies_request.REQUEST_ID','like','%'.$search.'%'); 
            })
            ->WhereBetween($DATESELECT,[$from,$to]) 
            ->orderBy('supplies_con.ID', 'desc')->get();
            $budgetsum =  Suppliescon::leftJoin('supplies_status_regis','supplies_con.REGIS_STATUS_ID','=','supplies_status_regis.REGIS_STATUS_ID')
            ->leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
            ->leftJoin('supplies_request','supplies_con.REQUEST_ID','=','supplies_request.ID')
            ->where('supplies_con.CON_YEAR_ID','=',$yearbudget)

            ->where(function($q) use ($search){
                $q->where('EGP_PLAN_NAME','like','%'.$search.'%');
                $q->orwhere('VENDOR_NAME','like','%'.$search.'%');
                $q->orwhere('CON_NUM','like','%'.$search.'%'); 
                $q->orwhere('supplies_con.BUDGET_SUM','like','%'.$search.'%');  
                $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');  
                $q->orwhere('supplies_request.REQUEST_ID','like','%'.$search.'%');   
            })
            ->WhereBetween($DATESELECT,[$from,$to])
            ->sum('supplies_con.BUDGET_SUM');
            $count =  Suppliescon::leftJoin('supplies_status_regis','supplies_con.REGIS_STATUS_ID','=','supplies_status_regis.REGIS_STATUS_ID')
            ->leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
            ->leftJoin('supplies_request','supplies_con.REQUEST_ID','=','supplies_request.ID')
            ->where('supplies_con.CON_YEAR_ID','=',$yearbudget)
 
            ->where(function($q) use ($search){
                $q->where('EGP_PLAN_NAME','like','%'.$search.'%');
                $q->orwhere('VENDOR_NAME','like','%'.$search.'%');
                $q->orwhere('CON_NUM','like','%'.$search.'%'); 
                $q->orwhere('supplies_con.BUDGET_SUM','like','%'.$search.'%');  
                $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');  
                $q->orwhere('supplies_request.REQUEST_ID','like','%'.$search.'%');  
            })
            ->WhereBetween($DATESELECT,[$from,$to])
            ->count();
        }else{
            $infosupcon = Suppliescon::select('supplies_con.ID','CON_YEAR_ID','CON_NUM','supplies_request.REQUEST_ID','REGIS_STATUS_NAME','DATE_REGIS','EGP_PLAN_NAME','SUP_TYPE_NAME','VENDOR_NAME','supplies_con.BUDGET_SUM','CHECK_DATE','supplies_status_regis.REGIS_STATUS_ID','supplies_con.SUP_TYPE_ID')
            ->leftJoin('supplies_status_regis','supplies_con.REGIS_STATUS_ID','=','supplies_status_regis.REGIS_STATUS_ID')
            ->where('supplies_con.REGIS_STATUS_ID','=',$status)
            ->leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
            ->leftJoin('supplies_request','supplies_con.REQUEST_ID','=','supplies_request.ID')
            ->where('supplies_con.CON_YEAR_ID','=',$yearbudget)

            ->where(function($q) use ($search){
                $q->where('EGP_PLAN_NAME','like','%'.$search.'%');
                $q->orwhere('VENDOR_NAME','like','%'.$search.'%');
                $q->orwhere('CON_NUM','like','%'.$search.'%'); 
                $q->orwhere('supplies_con.BUDGET_SUM','like','%'.$search.'%');  
                $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%'); 
                $q->orwhere('supplies_request.REQUEST_ID','like','%'.$search.'%');     
            })
            ->WhereBetween($DATESELECT,[$from,$to]) 
            ->orderBy('supplies_con.ID', 'desc')->get();
            $budgetsum =  Suppliescon::leftJoin('supplies_status_regis','supplies_con.REGIS_STATUS_ID','=','supplies_status_regis.REGIS_STATUS_ID')
            ->leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
            ->leftJoin('supplies_request','supplies_con.REQUEST_ID','=','supplies_request.ID')
            ->where('supplies_con.CON_YEAR_ID','=',$yearbudget)
            ->where('supplies_con.REGIS_STATUS_ID','=',$status)
            ->where(function($q) use ($search){
                $q->where('EGP_PLAN_NAME','like','%'.$search.'%');
                $q->orwhere('VENDOR_NAME','like','%'.$search.'%');
                $q->orwhere('CON_NUM','like','%'.$search.'%'); 
                $q->orwhere('supplies_con.BUDGET_SUM','like','%'.$search.'%');  
                $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%'); 
                $q->orwhere('supplies_request.REQUEST_ID','like','%'.$search.'%');      
            })
            ->WhereBetween($DATESELECT,[$from,$to])
            ->sum('supplies_con.BUDGET_SUM');

            $count =  Suppliescon::leftJoin('supplies_status_regis','supplies_con.REGIS_STATUS_ID','=','supplies_status_regis.REGIS_STATUS_ID')
            ->leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
            ->leftJoin('supplies_request','supplies_con.REQUEST_ID','=','supplies_request.ID')
            ->where('supplies_con.CON_YEAR_ID','=',$yearbudget)
            ->where('supplies_con.REGIS_STATUS_ID','=',$status)
            ->where(function($q) use ($search){
                $q->where('EGP_PLAN_NAME','like','%'.$search.'%');
                $q->orwhere('VENDOR_NAME','like','%'.$search.'%');
                $q->orwhere('CON_NUM','like','%'.$search.'%'); 
                $q->orwhere('supplies_con.BUDGET_SUM','like','%'.$search.'%');  
                $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');   
                $q->orwhere('supplies_request.REQUEST_ID','like','%'.$search.'%'); 
            })
            ->WhereBetween($DATESELECT,[$from,$to])
            ->count();
        }    
            $suppliesstatus = DB::table('supplies_status_regis')->get();
            $budgetyear = DB::table('budget_year')->orderByDesc('LEAVE_YEAR_ID')->get();
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
            $suppliesconboardlist = DB::table('supplies_con_board_list')->get();
            $infoperson = DB::table('hrd_person')->where('HR_STATUS_ID','=',1)->get();
            $infosetup = DB::table('medical_setup')->where('SETUP_ID','=',1)->first();
            return view('manager_medical.purchase',[
                'infosetup' => $infosetup,
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
                'suppliesconboardlists' => $suppliesconboardlist,
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

    public function purchasesearch(Request $request)
    {

        $search = $request->get('search');
        $status = $request->SEND_STATUS;
        $dateselect = $request->DATE_SELECT;
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

                if($dateselect == 'd2'){
                    $DATESELECT = 'CHECK_DATE';
                }else{
                    $DATESELECT = 'DATE_REGIS';
                }
       
    if($status == null){


        $infosupcon = Suppliescon::select('supplies_con.ID','CON_YEAR_ID','CON_NUM','supplies_request.REQUEST_ID','REGIS_STATUS_NAME','DATE_REGIS','EGP_PLAN_NAME','SUP_TYPE_NAME','VENDOR_NAME','supplies_con.BUDGET_SUM','CHECK_DATE','supplies_status_regis.REGIS_STATUS_ID')
        ->leftJoin('supplies_status_regis','supplies_con.REGIS_STATUS_ID','=','supplies_status_regis.REGIS_STATUS_ID')
        ->leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
        ->leftJoin('supplies_request','supplies_con.REQUEST_ID','=','supplies_request.ID')
        ->where('supplies_con.CON_YEAR_ID','=',$yearbudget)
        ->where(function($q){
            $q->where('REQUEST_FOR_ID','=','61');
            $q->orwhere('REQUEST_FOR_ID','=','62');
            $q->orwhere('REQUEST_FOR_ID','=','22');
            $q->orwhere('REQUEST_FOR_ID','=','7');
       })
        ->where(function($q) use ($search){
            $q->where('EGP_PLAN_NAME','like','%'.$search.'%');
            $q->orwhere('VENDOR_NAME','like','%'.$search.'%');
            $q->orwhere('CON_NUM','like','%'.$search.'%'); 
            $q->orwhere('supplies_con.BUDGET_SUM','like','%'.$search.'%');  
            $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');    
            $q->orwhere('supplies_request.REQUEST_ID','like','%'.$search.'%'); 
        })
        ->WhereBetween($DATESELECT,[$from,$to]) 
        ->orderBy('supplies_con.ID', 'desc')->get();

        
        $budgetsum =  Suppliescon::leftJoin('supplies_status_regis','supplies_con.REGIS_STATUS_ID','=','supplies_status_regis.REGIS_STATUS_ID')
        ->leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
        ->leftJoin('supplies_request','supplies_con.REQUEST_ID','=','supplies_request.ID')
        ->where('supplies_con.CON_YEAR_ID','=',$yearbudget)
        ->where(function($q){
            $q->where('REQUEST_FOR_ID','=','61');
            $q->orwhere('REQUEST_FOR_ID','=','62');
            $q->orwhere('REQUEST_FOR_ID','=','22');
            $q->orwhere('REQUEST_FOR_ID','=','7');
       })
        ->where(function($q) use ($search){
            $q->where('EGP_PLAN_NAME','like','%'.$search.'%');
            $q->orwhere('VENDOR_NAME','like','%'.$search.'%');
            $q->orwhere('CON_NUM','like','%'.$search.'%'); 
            $q->orwhere('supplies_con.BUDGET_SUM','like','%'.$search.'%');  
            $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');  
            $q->orwhere('supplies_request.REQUEST_ID','like','%'.$search.'%');   
        })
        ->WhereBetween($DATESELECT,[$from,$to])
        ->sum('supplies_con.BUDGET_SUM');

        $count =  Suppliescon::leftJoin('supplies_status_regis','supplies_con.REGIS_STATUS_ID','=','supplies_status_regis.REGIS_STATUS_ID')
        ->leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
        ->leftJoin('supplies_request','supplies_con.REQUEST_ID','=','supplies_request.ID')
        ->where('supplies_con.CON_YEAR_ID','=',$yearbudget)
        ->where(function($q){
            $q->where('REQUEST_FOR_ID','=','61');
            $q->orwhere('REQUEST_FOR_ID','=','62');
            $q->orwhere('REQUEST_FOR_ID','=','22');
            $q->orwhere('REQUEST_FOR_ID','=','7');
       })
        ->where(function($q) use ($search){
            $q->where('EGP_PLAN_NAME','like','%'.$search.'%');
            $q->orwhere('VENDOR_NAME','like','%'.$search.'%');
            $q->orwhere('CON_NUM','like','%'.$search.'%'); 
            $q->orwhere('supplies_con.BUDGET_SUM','like','%'.$search.'%');  
            $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');  
            $q->orwhere('supplies_request.REQUEST_ID','like','%'.$search.'%');  
        })
        ->WhereBetween($DATESELECT,[$from,$to])
        ->count();



    }else{


        $infosupcon = Suppliescon::select('supplies_con.ID','CON_YEAR_ID','CON_NUM','supplies_request.REQUEST_ID','REGIS_STATUS_NAME','DATE_REGIS','EGP_PLAN_NAME','SUP_TYPE_NAME','VENDOR_NAME','supplies_con.BUDGET_SUM','CHECK_DATE','supplies_status_regis.REGIS_STATUS_ID')
        ->leftJoin('supplies_status_regis','supplies_con.REGIS_STATUS_ID','=','supplies_status_regis.REGIS_STATUS_ID')
        ->where('supplies_con.REGIS_STATUS_ID','=',$status)
        ->leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
        ->leftJoin('supplies_request','supplies_con.REQUEST_ID','=','supplies_request.ID')
        ->where('supplies_con.CON_YEAR_ID','=',$yearbudget)
        ->where(function($q){
            $q->where('REQUEST_FOR_ID','=','61');
            $q->orwhere('REQUEST_FOR_ID','=','62');
            $q->orwhere('REQUEST_FOR_ID','=','22');
            $q->orwhere('REQUEST_FOR_ID','=','7');
       })
        ->where(function($q) use ($search){
            $q->where('EGP_PLAN_NAME','like','%'.$search.'%');
            $q->orwhere('VENDOR_NAME','like','%'.$search.'%');
            $q->orwhere('CON_NUM','like','%'.$search.'%'); 
            $q->orwhere('supplies_con.BUDGET_SUM','like','%'.$search.'%');  
            $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%'); 
            $q->orwhere('supplies_request.REQUEST_ID','like','%'.$search.'%');     
        })
        ->WhereBetween($DATESELECT,[$from,$to]) 
        ->orderBy('supplies_con.ID', 'desc')->get();


        $budgetsum =  Suppliescon::leftJoin('supplies_status_regis','supplies_con.REGIS_STATUS_ID','=','supplies_status_regis.REGIS_STATUS_ID')
        ->leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
        ->leftJoin('supplies_request','supplies_con.REQUEST_ID','=','supplies_request.ID')
        ->where('supplies_con.CON_YEAR_ID','=',$yearbudget)
        ->where('supplies_con.REGIS_STATUS_ID','=',$status)
        ->where(function($q){
            $q->where('REQUEST_FOR_ID','=','61');
            $q->orwhere('REQUEST_FOR_ID','=','62');
            $q->orwhere('REQUEST_FOR_ID','=','22');
            $q->orwhere('REQUEST_FOR_ID','=','7');
       })
        ->where(function($q) use ($search){
            $q->where('EGP_PLAN_NAME','like','%'.$search.'%');
            $q->orwhere('VENDOR_NAME','like','%'.$search.'%');
            $q->orwhere('CON_NUM','like','%'.$search.'%'); 
            $q->orwhere('supplies_con.BUDGET_SUM','like','%'.$search.'%');  
            $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%'); 
            $q->orwhere('supplies_request.REQUEST_ID','like','%'.$search.'%');      
        })
        ->WhereBetween($DATESELECT,[$from,$to])
        ->sum('supplies_con.BUDGET_SUM');

        $count =  Suppliescon::leftJoin('supplies_status_regis','supplies_con.REGIS_STATUS_ID','=','supplies_status_regis.REGIS_STATUS_ID')
        ->leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
        ->leftJoin('supplies_request','supplies_con.REQUEST_ID','=','supplies_request.ID')
        ->where('supplies_con.CON_YEAR_ID','=',$yearbudget)
        ->where('supplies_con.REGIS_STATUS_ID','=',$status)
        ->where(function($q){
            $q->where('REQUEST_FOR_ID','=','61');
            $q->orwhere('REQUEST_FOR_ID','=','62');
            $q->orwhere('REQUEST_FOR_ID','=','22');
            $q->orwhere('REQUEST_FOR_ID','=','7');
       })
        ->where(function($q) use ($search){
            $q->where('EGP_PLAN_NAME','like','%'.$search.'%');
            $q->orwhere('VENDOR_NAME','like','%'.$search.'%');
            $q->orwhere('CON_NUM','like','%'.$search.'%'); 
            $q->orwhere('supplies_con.BUDGET_SUM','like','%'.$search.'%');  
            $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');   
            $q->orwhere('supplies_request.REQUEST_ID','like','%'.$search.'%'); 
        })
        ->WhereBetween($DATESELECT,[$from,$to])
        ->count();


    }    
        

        $suppliesstatus = DB::table('supplies_status_regis')->get();
        $budgetyear = DB::table('budget_year')->get();


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
        $suppliesconboardlist = DB::table('supplies_con_board_list')->get();
        $infoperson = DB::table('hrd_person')->where('HR_STATUS_ID','=',1)->get();

        $infosetup = DB::table('medical_setup')->where('SETUP_ID','=',1)->first();

        return view('manager_medical.purchase',[
            'infosetup' => $infosetup,
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
            'suppliesconboardlists' => $suppliesconboardlist,
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

    public function createpurchaseregister(Request $request)
    {
        $suppliestype = DB::table('supplies_type')->get();

        $pessonall = Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')->get();
    
        $departmentsubsub = DB::table('hrd_department_sub_sub')->get();

        $suppliescon = Suppliescon::get();
        
        return view('manager_supplies.purchaseregister_add',[
            'suppliestypes' => $suppliestype,
            'pessonalls' => $pessonall,
            'suppliescons' => $suppliescon,
            'departmentsubsubs' => $departmentsubsub,
        ]);
        
    }

     //==================================อัปเดทการตั้งค่าทะเบียน=======================================
       
    



     public function purchasesetup(Request $request)
     {

     $COMMAND_DATE= $request->SETUP_DATE_WANT_USE;
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
         $SETUP_DATEWANTUSE= $y_st."-".$m_st."-".$d_st;
         }else{
         $SETUP_DATEWANTUSE= null;
     }

 
      if($request->USE_INFO == 'use'){
            $USE_INFO = 'use';
      }else{
            $USE_INFO = '';
      }

     $suppliesconsetup = Medicalsetup::find(1);
     $suppliesconsetup->SETUP_BUY_ID = $request->SETUP_BUY_ID;
     $suppliesconsetup->SETUP_CONDISION_ID = $request->SETUP_CONDISION_ID;
     $suppliesconsetup->SETUP_CONDISION_RESION = $request->SETUP_CONDISION_RESION;
     $suppliesconsetup->SETUP_METHOD_ID = $request->SETUP_METHOD_ID;
     $suppliesconsetup->SETUP_CON_DETAIL = $request->SETUP_CON_DETAIL;
     $suppliesconsetup->SETUP_SUP_TYPE_ID = $request->SETUP_SUP_TYPE_ID;
     $suppliesconsetup->SETUP_ASPECT_ID = $request->SETUP_ASPECT_ID;
     $suppliesconsetup->SETUP_DATE_WANT_USE = $SETUP_DATEWANTUSE;
     $suppliesconsetup->SETUP_DATE_WANT_COUNT = $request->SETUP_DATE_WANT_COUNT;
     $suppliesconsetup->SETUP_RESON_NAME = $request->SETUP_RESON_NAME; 
     $suppliesconsetup->SETUP_MONEY_GROUP_ID = $request->SETUP_MONEY_GROUP_ID;
     $suppliesconsetup->SETUP_BUDGET_ID = $request->SETUP_BUDGET_ID;
     $suppliesconsetup->SETUP_PURCHASE_LEADER_ID = $request->SETUP_PURCHASE_LEADER_ID;
     $suppliesconsetup->SETUP_PURCHASE_OFFICER_ID = $request->SETUP_PURCHASE_OFFICER_ID;
     $suppliesconsetup->SETUP_PURCHASE_HEAD_ID = $request->SETUP_PURCHASE_HEAD_ID;
     $suppliesconsetup->SETUP_THEBOARD = $request->SETUP_THEBOARD;
     $suppliesconsetup->USE_INFO = $USE_INFO;
     $suppliesconsetup->save(); 


    return redirect()->route('mmedical.purchase');

    }

    

    //=========================================================================
    public function savepurchaseregister(Request $request)
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


        $addsuppliescon = new Suppliescon();    
        $addsuppliescon->CON_NUM = $request->CON_NUM;

        $addsuppliescon->DATE_REGIS = $DATEREGIS;

        $addsuppliescon->SUP_TYPE_ID = $request->SUP_TYPE_ID;
        $addsuppliescon->CON_PROJECT_NAME = $request->CON_PROJECT_NAME;
        $addsuppliescon->RESON_NAME = $request->RESON_NAME;
        $addsuppliescon->CON_DETAIL = $request->CON_DETAIL;

        
        $addsuppliescon->PERSON_REQUEST_ID = $request->PERSON_REQUEST_ID;  
        $inforpersonrequest=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
        ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->where('hrd_person.ID','=',$request->PERSON_REQUEST_ID)->first();

        $addsuppliescon->PERSON_REQUEST_NAME = $inforpersonrequest->HR_PREFIX_NAME.''.$inforpersonrequest->HR_FNAME.' '.$inforpersonrequest->HR_LNAME;
        $addsuppliescon->DEP_REQUEST_ID = $inforpersonrequest->HR_DEPARTMENT_SUB_SUB_ID;
        $addsuppliescon->DEP_REQUEST_NAME = $inforpersonrequest->HR_DEPARTMENT_SUB_SUB_NAME;

        $addsuppliescon->REGIS_BY_ID = $request->REGIS_BY_ID;  
        $inforpersonregis=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
        ->where('hrd_person.ID','=',$request->REGIS_BY_ID)->first();

        $addsuppliescon->REGIS_BY_NAME = $inforpersonregis->HR_PREFIX_NAME.''.$inforpersonregis->HR_FNAME.' '.$inforpersonregis->HR_LNAME;
        $addsuppliescon->REGIS_BY_POSITION = $inforpersonregis->POSITION_IN_WORK;

        $addsuppliescon->save(); 
        
         return redirect()->route('msupplies.purchase');

        }

    

    
    public function purchaselist_addrequest(Request $request,$idlistref)
    {
  

      $infore = DB::table('supplies_request')->where('REQUEST_ID','=',$idlistref)->first();

      $infosupres = DB::table('supplies_request_sub')->where('SUPPLIES_REQUEST_ID','=',$infore->ID)->get();
      
      $CONID = DB::table('supplies_con')->where('REQUEST_ID','=',$infore->ID)->first();
      
     

      foreach ($infosupres as $infosupre){ 
      
        $addsuppliesconlist = new Suppliesconlist();
        $addsuppliesconlist->CON_ID = $CONID->ID;
        $addsuppliesconlist->SUP_ID = $infosupre->SUPPLIES_REQUEST_SUBRE_ID;
        $infosupname = DB::table('supplies')->where('ID','=',$infosupre->SUPPLIES_REQUEST_SUBRE_ID)->first();
        $addsuppliesconlist->SUP_NAME= $infosupname->SUP_NAME; 

        $unitref = DB::table('supplies_unit_ref')->where('SUP_ID','=',$infosupre->SUPPLIES_REQUEST_SUBRE_ID)->where('SUP_UNIT_NAME','=',$infosupre->SUPPLIES_REQUEST_SUB_UNIT)->first();

        if($unitref <> null && $unitref <> ''){
            $addsuppliesconlist->SUP_UNIT_ID= $unitref->ID; 
        }else{
            $addsuppliesconlist->SUP_UNIT_ID= ''; 
        }
     
        $addsuppliesconlist->SUP_TOTAL = $infosupre->SUPPLIES_REQUEST_SUB_AMOUNT;
        $addsuppliesconlist->PRICE_PER_UNIT = $infosupre->SUPPLIES_REQUEST_SUB_PRICE;
        $addsuppliesconlist->PRICE_SUM = $infosupre->SUPPLIES_REQUEST_SUB_SUM_PRICE;
        $addsuppliesconlist->save(); 

        }
 
    return redirect()->route('mmedical.medical_purchaselist_add',[ 'idlistref' =>$CONID->ID ]);
        
    }

    public function createpurchaseboard(Request $request)
    {
        return view('manager_supplies.purchaseboard_add');   
    }

    public function createpurchasequotation(Request $request)
    {
        return view('manager_supplies.purchasequotation_add');   
    }


    //---------------------ตั้งค่า เลข FSN

    public function setupfsn(Request $request)
    {
        $suppliesgroup = DB::table('supplies_group')->get();
        return view('manager_supplies.setupfsn',[
            'suppliesgroups' => $suppliesgroup
        ]);
        
    }

    
    function switchactivefsn(Request $request)
    {  
        $id = $request->id;
        $active = Suppliesgroup::find($id);
        $active->ACTIVE = $request->onoff;
        $active->save();
    }

    

    public function setupfsnsub(Request $request,$groupcode)
    {
    
        $nameasuppliesgroup = DB::table('supplies_group')->where('GROUP_CODE','=',$groupcode)->first();
        $suppliesclass = DB::table('supplies_class')->where('GROUP_CODE','=',$groupcode)->get();
        
        return view('manager_supplies.setupfsnsub',[
            'nameasuppliesgroup' => $nameasuppliesgroup,
            'suppliesclassS' => $suppliesclass
        ]);
        
    }

    function switchactivefsnsub(Request $request)
    {  
        $id = $request->id;
        $active = Suppliesclass::find($id);
        $active->ACTIVE = $request->onoff;
        $active->save();
    }




    public function setupfsnsubsub(Request $request,$groupcode,$classcode)
    {        
        $namesuppliesgroup= DB::table('supplies_group')->where('GROUP_CODE','=',$groupcode)->first();
        $namesuppliesclass = DB::table('supplies_class')->where('GROUP_CODE','=',$groupcode)->where('CLASS_CODE','=',$classcode)->first();
        $suppliestype = DB::table('supplies_types')->where('GROUP_CODE','=',$groupcode)->where('CLASS_CODE','=',$classcode)->get();

        
        return view('manager_supplies.setupfsnsubsub',[
            'namesuppliesgroup' => $namesuppliesgroup,
            'namesuppliesclass' => $namesuppliesclass,
            'suppliestypes' => $suppliestype,
        ]);
        
    }

    function switchactivefsnsubsub(Request $request)
    {  
        $id = $request->id;
        $active = Suppliestypes::find($id);
        $active->ACTIVE = $request->onoff;
        $active->save();
    }


    public function setupfsnsubsubfinish(Request $request,$groupcode,$classcode,$typecode)
    {
    
            
        $namesuppliesgroup= DB::table('supplies_group')->where('GROUP_CODE','=',$groupcode)->first();
        $namesuppliesclass = DB::table('supplies_class')->where('GROUP_CODE','=',$groupcode)->where('CLASS_CODE','=',$classcode)->first();
        $namesuppliestype = DB::table('supplies_types')->where('GROUP_CODE','=',$groupcode)->where('CLASS_CODE','=',$classcode)->where('TYPE_ID','=',$typecode)->first();
        $suppliesprop = DB::table('supplies_prop')->where('TYPE_ID','=',$typecode)->get();

        
        return view('manager_supplies.setupfsnsubsubfinish',[
            'namesuppliesgroup' => $namesuppliesgroup,
            'namesuppliesclass' => $namesuppliesclass,
            'namesuppliestype' => $namesuppliestype,
            'suppliesprops' => $suppliesprop,
        ]);
        
    }

    

    function switchactivefsnsubsubfinish(Request $request)
    {  
        $id = $request->id;
        $active = Suppliesprop::find($id);
        $active->ACTIVE = $request->onoff;
        $active->save();
    }
    
//=================================ฟังชั่น=====================


function detailapp(Request $request)
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

  $detail = DB::table('supplies_request')->where('ID','=',$id)->first();

  $output ='
  <input type="hidden"  name="ID" value="'.$id.'"/>

  <div class="row">
       
  <div class="col-sm-2">
      <div class="form-group">
      <label >ลงวันที่ :</label>
      </div>                               
  </div> 
  <div class="col-sm-3">
      <div class="form-group" >
      <h1 style="font-family: \'Kanit\', sans-serif; font-size:10px;font-size: 1.0rem;font-weight:normal;color:#778899;">'.DateThai($detail -> DATE_WANT).'</h1>
      </div>                               
  </div>
  
  <div class="col-sm-2">
      <div class="form-group">
      <label >เพื่อจัดซื้อ/ซ่อมแซม  :</label>
      </div>                               
  </div>  
  <div class="col-sm-3">
      <div class="form-group">
      <h1 style="font-family: \'Kanit\', sans-serif; font-size:10px;font-size: 1.0rem;font-weight:normal;color:#778899;">'.$detail -> REQUEST_FOR.'</h1>
      </div>                               
  </div>  
 
  </div>

  <div class="row">
  
  <div class="col-sm-2">
      <div class="form-group">
      <label >เรียน :</label>
      </div>                               
  </div> 
  <div class="col-sm-3">
      <div class="form-group" >
      <h1 style="font-family: \'Kanit\', sans-serif; font-size:10px;font-size: 1.0rem;font-weight:normal;color:#778899;">'.$detail -> REQUEST_HEAD.'</h1>
      </div>                               
  </div>
  
  <div class="col-sm-2">
      <div class="form-group">
      <label >หน่วยงานที่ร้องขอ  :</label>
      </div>                               
  </div>  
  <div class="col-sm-3">
      <div class="form-group">
      <h1 style="font-family: \'Kanit\', sans-serif; font-size:10px;font-size: 1.0rem;font-weight:normal;color:#778899;" >'.$detail -> SAVE_HR_DEP_SUB_NAME.'</h1>
      </div>                               
  </div>  
 
  </div>
  
    ';
    $output.=' <table class="table-bordered table-striped table-vcenter js-dataTable-simple" style="width: 100%;">
    <thead style="background-color: #FFEBCD;">
        <tr height="40">                          
            <th  class="text-font" style="border-color:#F0FFFF;text-align: center;">รายละเอียด</th>
            <th  class="text-font" style="border-color:#F0FFFF;text-align: center;" width="15%">จำนวน</th>
            <th  class="text-font" style="border-color:#F0FFFF;text-align: center;" width="15%">หน่วย</th>
            <th  class="text-font" style="border-color:#F0FFFF;text-align: center;" width="15%">ราคาต่อหน่วย</th>
            <th  class="text-font" style="border-color:#F0FFFF;text-align: center;" width="15%">จำนวนเงิน</th>
        
        </tr >
    </thead>
    <tbody>     ';

    $detail_subs = DB::table('supplies_request_sub')->where('SUPPLIES_REQUEST_ID','=',$id)->get();
    foreach ($detail_subs as $detailsub){ 
    $output.='  <tr height="40">

    <td class="text-font text-pedding" >'.$detailsub->SUPPLIES_REQUEST_SUB_DETAIL.'</td>  
    <td class="text-font" align="center" >'.$detailsub->SUPPLIES_REQUEST_SUB_AMOUNT.'</td> 
    <td class="text-font" align="center" >'.$detailsub->SUPPLIES_REQUEST_SUB_UNIT.'</td>  
    <td class="text-font" align="center" >'.$detailsub->SUPPLIES_REQUEST_SUB_PRICE.'</td>                                                                       
    <td class="text-font" align="center" >'.$detailsub->SUPPLIES_REQUEST_SUB_AMOUNT * $detailsub->SUPPLIES_REQUEST_SUB_PRICE.'</td>                                         
    </tr>';
    }

$output.=' </tbody>
</table><br>';
 echo $output;   
}
    //=============19.5.63======================================//
 
public function detail(Request $request)
{
    if($request->method() === 'POST'){
        $search = $request->get('search');
        $status = $request->INVEN_STATUS;
        $yearbudget = $request->YEAR_ID;
        $datebigin = $request->get('DATE_BIGIN');
        $dateend = $request->get('DATE_END');
        $status_check = $request->SEND_STATUS;
        session([
            'manager_medical.detail.search' => $search,
            'manager_medical.detail.status' => $status,
            'manager_medical.detail.yearbudget' => $yearbudget,
            'manager_medical.detail.datebigin' => $datebigin,
            'manager_medical.detail.dateend' => $dateend,
            'manager_medical.detail.status_check' => $status_check,
        ]);
    }else if(session::has('manager_medical.detail')){
        $search = session('manager_medical.detail.search');
        $status = session('manager_medical.detail.status');
        $yearbudget = session('manager_medical.detail.yearbudget');
        $datebigin = session('manager_medical.detail.datebigin');
        $dateend = session('manager_medical.detail.dateend');
        $status_check = session('manager_medical.detail.status_check');
    }else{
        $search = '';
        $status = '';
        $yearbudget = getBudgetyear();
        $datebigin = date('1/m/Y');
        $dateend = date('d/m/Y',strtotime(date('Y-m-1').' +1month -1day'));
        $status_check = '';
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
        $setinven = Medical_set_inventory::all();
        $infocheckreceive = DB::table('warehouse_check_receive')
            ->leftJoin('warehouse_check_status','warehouse_check_receive.RECEIVE_CHECK_STATUS','=','warehouse_check_status.ID_STATUS')
            ->leftJoin('warehouse_check_type','warehouse_check_receive.RECEIVE_CHECK_TYPE','=','warehouse_check_type.ID_TYPE')
            ->leftJoin('supplies_inven','warehouse_check_receive.RECEIVE_STORE','=','supplies_inven.INVEN_ID')
            ->leftJoin('supplies_con','warehouse_check_receive.RECEIVE_PO','=','supplies_con.PO_NUM')
            ->leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID');
        if($status != null){
            $infocheckreceive = $infocheckreceive->where('RECEIVE_STORE','=',$status);
        }else{
            $infocheckreceive = $infocheckreceive->where(function($q) use ($setinven){
                foreach($setinven as $row){
                    $q->orWhere('RECEIVE_STORE',$row->INVEN_ID);
                }
            });
        }
        if($status_check != null){
            $infocheckreceive = $infocheckreceive->where('RECEIVE_CHECK_STATUS','=',$status_check);
        }
        $infocheckreceive = $infocheckreceive->where(function($q) use ($search){
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
            ->leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID');
        if($status != null){
            $sumbudget = $sumbudget->where('RECEIVE_STORE','=',$status);
        }
        if($status_check != null){
            $sumbudget = $sumbudget->where('RECEIVE_CHECK_STATUS','=',$status_check);
        }
        $sumbudget =$sumbudget->where(function($q) use ($search){
            $q->where('RECEIVE_ACCEPT_FROM','like','%'.$search.'%');
            $q->orwhere('RECEIVE_PERSON_NAME','like','%'.$search.'%');
            $q->orwhere('CON_NUM','like','%'.$search.'%');
            $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');
        })
        ->WhereBetween('warehouse_check_receive.created_at',[$from,$to])
        ->orderBy('RECEIVE_ID', 'desc')->sum('RECEIVE_VALUE');

        $infosuppliesinven = $setinven;
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $statussend = DB::table('warehouse_check_status')->get();
        $invenstatus_check = $status;  
        $year_id = $yearbudget;

    return view('manager_medical/medicaldetail',[
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


 
public function detail_edit(Request $request,$id)
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
    ->where('RECEIVE_ID','=',$id)->first();

    $infocheckreceivesub = DB::table('warehouse_check_receive_sub')
    ->leftJoin('warehouse_sup_type','warehouse_check_receive_sub.RECEIVE_SUB_TYPE','=','warehouse_sup_type.ID_SUP_TYPE')
    ->leftJoin('supplies_unit_ref','warehouse_check_receive_sub.RECEIVE_SUB_UNIT','=','supplies_unit_ref.ID')
    ->where('RECEIVE_ID','=',$id)->get();


    $count = DB::table('warehouse_check_receive_sub')->where('RECEIVE_ID','=',$id)->count();


    $infosupplies= Supplies::leftJoin('supplies_type','supplies.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
    ->leftJoin('supplies_type_kind','supplies.SUP_TYPE_KIND_ID','=','supplies_type_kind.SUP_TYPE_KIND_ID')
    ->where('supplies_type_kind.SUP_TYPE_MASTER_ID','=',1)
    ->orderBy('ID', 'desc') 
    ->get();

    $infocheckreceiveboard = DB::table('warehouse_check_receive_board')
    ->leftJoin('hrd_person','warehouse_check_receive_board.RECEIVE_BOARD_PERSON_ID','=','hrd_person.ID')
    ->where('RECEIVE_ID','=',$id)->get();


    $infosuppliesunitref = DB::table('supplies_unit_ref')->get();
    $infosuppliesvendor = DB::table('supplies_vendor')->get();


    return view('manager_medical.madicaldetail_edit',[
        'infopersons' => $infoperson,  
        'infosuptypes' => $infosuptype, 
        'infobudgetyears' => $infobudgetyear, 
        'infosuppliesinvens' => $infosuppliesinven, 
        'infocheckreceive' => $infocheckreceive, 
        'infocheckreceivesubs' => $infocheckreceivesub, 
        'infosuppliess' => $infosupplies, 
        'infocheckreceiveboards' => $infocheckreceiveboard, 
        'infosuppliesunitrefs' => $infosuppliesunitref, 
        'infosuppliesvendors' => $infosuppliesvendor, 
        'count' => $count,

    ]);
}
public function detail_update(Request $request)
{

        $CHECKDATE = $request->RECEIVE_CHECK_DATE;

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


       $addinfocheck->RECEIVE_CHECK_TIME = $request->RECEIVE_CHECK_TIME;

       $addinfocheck->RECEIVE_ACCEPT_FROM = $request->RECEIVE_ACCEPT_FROM;
       $addinfocheck->RECEIVE_BUDGET_YEAR = $request->RECEIVE_BUDGET_YEAR;
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


        

        return redirect()->route('mmedical.detail');
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
        return view('manager_medical/medicaldetail',[
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

    public function storehouse(Request $request)
    {
        if($request->method() === 'POST'){
            $typestore  = $request->RECEIVE_STORE;
            $search     = $request->search;
            session([
                'manager_medical.storehouse.typestore' => $typestore,
                'manager_medical.storehouse.search' => $search,
            ]);
        }else if(session::has('manager_medical.storehouse')){
            $typestore = session('manager_medical.storehouse.typestore');
            $search = session('manager_medical.storehouse.search');
        }else{
            $typestore = '';
            $search = '';
        }
        $setinven = Medical_set_inventory::all();
        $infowarehousestore= DB::table('warehouse_store')
        ->leftJoin('supplies_unit_ref', 'warehouse_store.STORE_UNIT', '=', 'supplies_unit_ref.ID')
        ->leftJoin('supplies', 'warehouse_store.STORE_CODE', '=', 'supplies.SUP_FSN_NUM')
        ->leftJoin('supplies_type', 'supplies_type.SUP_TYPE_ID', '=', 'supplies.SUP_TYPE_ID');
        if($typestore != null){
            $infowarehousestore = $infowarehousestore->where('warehouse_store.STORE_TYPE', '=', $typestore);
        }else{
            $infowarehousestore = $infowarehousestore->where(function($q) use ($setinven){
                foreach($setinven as $row){
                    $q->orWhere('warehouse_store.STORE_TYPE',$row->INVEN_ID);
                }
            });
        }
        $infowarehousestore = $infowarehousestore->where(function($q) use ($search){
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
        ->leftJoin('supplies_type', 'supplies_type.SUP_TYPE_ID', '=', 'supplies.SUP_TYPE_ID');
        if($typestore != null){
            $sumvalue1 = $sumvalue1->where('warehouse_store.STORE_TYPE', '=', $typestore);
        }else{
            $sumvalue1 = $sumvalue1->where(function($q) use ($setinven){
                foreach($setinven as $row){
                    $q->orWhere('warehouse_store.STORE_TYPE',$row->INVEN_ID);
                }
            });
        }
        $sumvalue1 = $sumvalue1->where(function($q) use ($search){
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
        ->leftJoin('supplies_type', 'supplies_type.SUP_TYPE_ID', '=', 'supplies.SUP_TYPE_ID');
        if($typestore != null){
            $sumvalue2 = $sumvalue2->where('warehouse_store.STORE_TYPE', '=', $typestore);
        }else{
            $sumvalue2 = $sumvalue2->where(function($q) use ($setinven){
                foreach($setinven as $row){
                    $q->orWhere('warehouse_store.STORE_TYPE',$row->INVEN_ID);
                }
            });
        }
        $sumvalue2 = $sumvalue2->where(function($q) use ($search){
            $q->where('STORE_CODE','like','%'.$search.'%');
            $q->orwhere('EXPORT_SUB_NAME','like','%'.$search.'%');
            $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');
            $q->orwhere('SUP_UNIT_NAME','like','%'.$search.'%');
        })
        ->sum('EXPORT_SUB_VALUE');
        $sumvalue = $sumvalue1 - $sumvalue2;
        $infosuppliesinven = $setinven;
        $checkreceive =  $typestore;
        return view('manager_medical.medicalstorehouse',[
            'infowarehousestores' => $infowarehousestore,
            'infosuppliesinvens'=> $infosuppliesinven,
            'sumvalue'=> $sumvalue,
            'checkreceive'=> $checkreceive,
            'search'=> $search,
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
    return view('manager_medical.medicalstorehouse',[
        'infowarehousestores' => $infowarehousestore,
        'infosuppliesinvens'=> $infosuppliesinven,
        'sumvalue'=> $sumvalue,
        'checkreceive'=> $checkreceive,
        'search'=> $search,
    ]);
}



public function medicalstorehouse_detail(Request $request,$id)
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
   

    return view('manager_medical.medicalstorehouse_detail',[
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
  
        

    return view('manager_medical.medicalstorehouse',[
         'storereceivesubs' => $storereceivesub,
         'storeexportsubs'=> $storeexportsub,
         'idstore' =>$id,
         'warehousestore' => $warehousestore,
         'displaydate_bigen'=> $displaydate_bigen,
         'displaydate_end'=> $displaydate_end,
    ]);
}


//==============================================================================//

public function treasury(Request $request)
    {
        if($request->method() === 'POST'){
            $typestore = $request->DEPART_STORE;
            $search = $request->search;
            session([
                'manager_medical.treasury.typestore' => $typestore,
                'manager_medical.treasury.search' => $search,
            ]);
        }else if(session::has('manager_medical.treasury')){
            $typestore = session('manager_medical.treasury.typestore');
            $search = session('manager_medical.treasury.search');
        }else{
            $typestore = '';
            $search = '';
        }
    
        if ($typestore == '') {
            $infowarehousetreasury= DB::table('warehouse_treasury')
                ->leftJoin('supplies_unit_ref','warehouse_treasury.TREASURY_UNIT','=','supplies_unit_ref.ID')
                ->leftJoin('supplies', 'warehouse_treasury.TREASURY_CODE', '=', 'supplies.SUP_FSN_NUM')           
                ->leftJoin('supplies_type', 'supplies_type.SUP_TYPE_ID', '=', 'supplies.SUP_TYPE_ID') 
                ->where(function($q){
                    $q->where('supplies.SUP_TYPE_ID','=','61');
                    $q->orwhere('supplies.SUP_TYPE_ID','=','62');
                    $q->orwhere('supplies.SUP_TYPE_ID','=','22');
                    $q->orwhere('supplies.SUP_TYPE_ID','=','7');
               })
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
                ->where(function($q){
                    $q->where('supplies.SUP_TYPE_ID','=','61');
                    $q->orwhere('supplies.SUP_TYPE_ID','=','62');
                    $q->orwhere('supplies.SUP_TYPE_ID','=','22');
                    $q->orwhere('supplies.SUP_TYPE_ID','=','7');
               })
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
                ->where(function($q){
                    $q->where('supplies.SUP_TYPE_ID','=','61');
                    $q->orwhere('supplies.SUP_TYPE_ID','=','62');
                    $q->orwhere('supplies.SUP_TYPE_ID','=','22');
                    $q->orwhere('supplies.SUP_TYPE_ID','=','7');
               })
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
            ->where(function($q){
                $q->where('supplies.SUP_TYPE_ID','=','61');
                $q->orwhere('supplies.SUP_TYPE_ID','=','62');
                $q->orwhere('supplies.SUP_TYPE_ID','=','22');
                $q->orwhere('supplies.SUP_TYPE_ID','=','7');
           })
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
            ->where(function($q){
                $q->where('supplies.SUP_TYPE_ID','=','61');
                $q->orwhere('supplies.SUP_TYPE_ID','=','62');
                $q->orwhere('supplies.SUP_TYPE_ID','=','22');
                $q->orwhere('supplies.SUP_TYPE_ID','=','7');
           })
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
            ->where(function($q){
                $q->where('supplies.SUP_TYPE_ID','=','61');
                $q->orwhere('supplies.SUP_TYPE_ID','=','62');
                $q->orwhere('supplies.SUP_TYPE_ID','=','22');
                $q->orwhere('supplies.SUP_TYPE_ID','=','7');
           })
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
        return view('manager_medical.medicaltreasury',[
            'infowarehousetreasurys' => $infowarehousetreasury,
            'infodeparts' =>  $infodepart,
            'sumvalue' =>  $sumvalue,
            'checkreceive' =>  $checkreceive,
            'search' =>  $search,
       ]);
    }



    public function treasury_search(Request $request)
    {
           
        $typestore = $request->DEPART_STORE;
        $search = $request->search;
    
        if ($typestore == '') {
            $infowarehousetreasury= DB::table('warehouse_treasury')
                ->leftJoin('supplies_unit_ref','warehouse_treasury.TREASURY_UNIT','=','supplies_unit_ref.ID')
                ->leftJoin('supplies', 'warehouse_treasury.TREASURY_CODE', '=', 'supplies.SUP_FSN_NUM')           
                ->leftJoin('supplies_type', 'supplies_type.SUP_TYPE_ID', '=', 'supplies.SUP_TYPE_ID') 
                ->where(function($q){
                    $q->where('supplies.SUP_TYPE_ID','=','61');
                    $q->orwhere('supplies.SUP_TYPE_ID','=','62');
                    $q->orwhere('supplies.SUP_TYPE_ID','=','22');
                    $q->orwhere('supplies.SUP_TYPE_ID','=','7');
               })
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
                ->where(function($q){
                    $q->where('supplies.SUP_TYPE_ID','=','61');
                    $q->orwhere('supplies.SUP_TYPE_ID','=','62');
                    $q->orwhere('supplies.SUP_TYPE_ID','=','22');
                    $q->orwhere('supplies.SUP_TYPE_ID','=','7');
               })
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
                ->where(function($q){
                    $q->where('supplies.SUP_TYPE_ID','=','61');
                    $q->orwhere('supplies.SUP_TYPE_ID','=','62');
                    $q->orwhere('supplies.SUP_TYPE_ID','=','22');
                    $q->orwhere('supplies.SUP_TYPE_ID','=','7');
               })
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
            ->where(function($q){
                $q->where('supplies.SUP_TYPE_ID','=','61');
                $q->orwhere('supplies.SUP_TYPE_ID','=','62');
                $q->orwhere('supplies.SUP_TYPE_ID','=','22');
                $q->orwhere('supplies.SUP_TYPE_ID','=','7');
           })
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
            ->where(function($q){
                $q->where('supplies.SUP_TYPE_ID','=','61');
                $q->orwhere('supplies.SUP_TYPE_ID','=','62');
                $q->orwhere('supplies.SUP_TYPE_ID','=','22');
                $q->orwhere('supplies.SUP_TYPE_ID','=','7');
           })
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
            ->where(function($q){
                $q->where('supplies.SUP_TYPE_ID','=','61');
                $q->orwhere('supplies.SUP_TYPE_ID','=','62');
                $q->orwhere('supplies.SUP_TYPE_ID','=','22');
                $q->orwhere('supplies.SUP_TYPE_ID','=','7');
           })
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
    
        
        return view('manager_medical.medicaltreasury',[
            'infowarehousetreasurys' => $infowarehousetreasury,
            'infodeparts' =>  $infodepart,
            'sumvalue' =>  $sumvalue,
            'checkreceive' =>  $checkreceive,
            'search' =>  $search,
       ]);
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

 //---เบิกจ่าย

 public function disburse(Request $request)
 {

    if($request->method() === 'POST'){
        $search = $request->get('search');
        $status = $request->INVEN_STATUS;
        $yearbudget = $request->YEAR_ID;
        $datebigin = $request->get('DATE_BIGIN');
        $dateend = $request->get('DATE_END');
        $status_check = $request->SEND_STATUS;
        session([
            'manager_medical.disburse.search' => $search,
            'manager_medical.disburse.status' => $status,
            'manager_medical.disburse.yearbudget' => $yearbudget,
            'manager_medical.disburse.datebigin' => $datebigin,
            'manager_medical.disburse.dateend' => $dateend,
            'manager_medical.disburse.status_check' => $status_check,
        ]);
    }else if(session::has('manager_medical.disburse')){
        $search = session('manager_medical.disburse.search');
        $status = session('manager_medical.disburse.status');
        $yearbudget = session('manager_medical.disburse.yearbudget');
        $datebigin = session('manager_medical.disburse.datebigin');
        $dateend = session('manager_medical.disburse.dateend');
        $status_check = session('manager_medical.disburse.status_check');
    }else{
        $search = '';
        $status = '';
        $yearbudget = getBudgetyear();
        $datebigin = date('1/m/Y');
        $dateend = date('d/m/Y',strtotime(date('Y-m-1').' +1month -1day'));
        $status_check = '';
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
    $setinven = Medical_set_inventory::all();
    $inforwarehouserequest =
    Warehouserequest::leftJoin('warehouse_request_status','warehouse_request_status.STATUS_CODE','=','warehouse_request.WAREHOUSE_STATUS')
    ->leftJoin('supplies_inven','supplies_inven.INVEN_ID','=','warehouse_request.WAREHOUSE_INVEN_ID')
    ->leftJoin('warehouse_smallhos','warehouse_request.WAREHOUSE_SMALLHOS','=','warehouse_smallhos.WAREHOUSE_SMALLHOS_ID')
    ->leftJoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','warehouse_request.WAREHOUSE_DEP_SUB_SUB_ID');
    if($status != null){
        $inforwarehouserequest = $inforwarehouserequest->where('INVEN_ID','=',$status);
    }else{
        $inforwarehouserequest = $inforwarehouserequest->where(function($q) use ($setinven){
            foreach($setinven as $row){
                $q->orWhere('INVEN_ID',$row->INVEN_ID);
            }
        });
    }
    if($status_check != null){
        $inforwarehouserequest = $inforwarehouserequest->where('WAREHOUSE_STATUS','=',$status_check);
    }
    $inforwarehouserequest = $inforwarehouserequest->where(function($q) use ($search){
        $q->where('WAREHOUSE_REQUEST_CODE','like','%'.$search.'%');
        $q->orwhere('WAREHOUSE_REQUEST_BUY_COMMENT','like','%'.$search.'%');
        $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');
        $q->orwhere('WAREHOUSE_SAVE_HR_NAME','like','%'.$search.'%');
    })
    ->WhereBetween('WAREHOUSE_DATE_WANT',[$from,$to])
    ->get();

    $infosuppliesinven = $setinven;
    $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
    $statussend = DB::table('warehouse_request_status')->get();
    $invenstatus_check = $status;  
    $year_id = $yearbudget;
     return view('manager_medical.medicaldisburse',[
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
         
     ]);
 }

 public function disbursesearch(Request $request)
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
    $search = $search;
    $status_check = $status_check;

    $year_id = $yearbudget;
 
     return view('manager_medical.medicaldisburse',[
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
         
     ]);
 }


  //=======================================

  public function warehousemedicalwithdraw_add(Request $request)
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
  
      return view('manager_medical.warehousemedicalwithdraw_add',[
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

        
public function warehousemedicalwithdraw_save(Request $request)
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

        return redirect()->route('mmedical.disburse');
}





public function infocheckadd()
{
    $infoperson = DB::table('hrd_person')
    ->orderBy('hrd_person.HR_FNAME', 'asc')  
    ->where('hrd_person.HR_STATUS_ID', '=',1)
    ->get();

    $infobudgetyear= DB::table('budget_year')->where('ACTIVE','=','True')->get();
    $infosuptype = DB::table('warehouse_sup_type')->get();


    $RECEIVE_ID = Warehousecheckreceive::max('RECEIVE_ID'); 
    $RECEIVE_CODE = 'RE-'.str_pad($RECEIVE_ID+1,4,"0",STR_PAD_LEFT);

    $infosuppliesinven= DB::table('supplies_inven')->orderby('INVEN_ID', 'asc')->get();

    $infosuptype = DB::table('warehouse_sup_type')->get();

    $infosupplies= Supplies::leftJoin('supplies_type','supplies.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
    ->leftJoin('supplies_type_kind','supplies.SUP_TYPE_KIND_ID','=','supplies_type_kind.SUP_TYPE_KIND_ID')
    ->where('supplies_type_kind.SUP_TYPE_MASTER_ID','=',1)
    ->orderBy('ID', 'desc') 
    ->get();

    $infosuppliesunitref = DB::table('supplies_unit_ref')->get();
    $infosuppliesvendor = DB::table('supplies_vendor')->get();

    return view('manager_medical.medicalinfocheck_add',[
        'infopersons' => $infoperson,  
            'infosuptypes' => $infosuptype, 
            'infobudgetyears' => $infobudgetyear, 
            'infosuppliesinvens' => $infosuppliesinven, 
            'infosuppliess' => $infosupplies, 
            'RECEIVECODE' => $RECEIVE_CODE, 
            'infosuppliesunitrefs' => $infosuppliesunitref, 
            'infosuppliesvendors' => $infosuppliesvendor,
    ]);
}




public function saveinfocheckadd(Request $request)
{
         $CHECKDATE = $request->RECEIVE_CHECK_DATE;

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

        $addinfocheck = new Warehousecheckreceive();
        $addinfocheck->RECEIVE_CODE = $request->RECEIVE_CODE;
        $addinfocheck->RECEIVE_NUMBER = $request->RECEIVE_NUMBER;
        $addinfocheck->RECEIVE_PERSON_ID = $request->RECEIVE_PERSON_ID;

        $PERSON =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
        ->where('hrd_person.ID','=',$request->RECEIVE_PERSON_ID)->first();
        $addinfocheck->RECEIVE_PERSON_NAME = $PERSON->HR_PREFIX_NAME.''.$PERSON->HR_FNAME.' '.$PERSON->HR_LNAME;    
       
        $addinfocheck->RECEIVE_STORE = $request->RECEIVE_STORE;
   
        $addinfocheck->RECEIVE_CHECK_DATE = $CHECKDATE;


        $addinfocheck->RECEIVE_CHECK_TIME = $request->RECEIVE_CHECK_TIME;

        $addinfocheck->RECEIVE_ACCEPT_FROM = $request->RECEIVE_ACCEPT_FROM;
        $addinfocheck->RECEIVE_BUDGET_YEAR = $request->RECEIVE_BUDGET_YEAR;
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

        return redirect()->route('mmedical.detail');
}



public function medicalinfocheckdetali_edit(Request $request,$id)
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
    ->where('RECEIVE_ID','=',$id)->first();

    $infocheckreceivesub = DB::table('warehouse_check_receive_sub')
    ->leftJoin('warehouse_sup_type','warehouse_check_receive_sub.RECEIVE_SUB_TYPE','=','warehouse_sup_type.ID_SUP_TYPE')
    ->leftJoin('supplies_unit_ref','warehouse_check_receive_sub.RECEIVE_SUB_UNIT','=','supplies_unit_ref.ID')
    ->where('RECEIVE_ID','=',$id)->get();


    $count = DB::table('warehouse_check_receive_sub')->where('RECEIVE_ID','=',$id)->count();


    $infosupplies= Supplies::leftJoin('supplies_type','supplies.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
    ->leftJoin('supplies_type_kind','supplies.SUP_TYPE_KIND_ID','=','supplies_type_kind.SUP_TYPE_KIND_ID')
    ->where('supplies_type_kind.SUP_TYPE_MASTER_ID','=',1)
    ->orderBy('ID', 'desc') 
    ->get();

    $infocheckreceiveboard = DB::table('warehouse_check_receive_board')
    ->leftJoin('hrd_person','warehouse_check_receive_board.RECEIVE_BOARD_PERSON_ID','=','hrd_person.ID')
    ->where('RECEIVE_ID','=',$id)->get();

    return view('manager_medical.medicalinfocheckdetali_edit',[
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
        return view('manager_medical.medicalstorehousesub',[
            'storereceivesubs' => $storereceivesub,
            'storeexportsubs' => $storeexportsub,
            'warehousestore' => $warehousestore,
            'idstore' =>$id,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
       ]);
    }




    public function storehousesub_search(Request $request)
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
      
            
    
        return view('manager_medical.medicalstorehousesub',[
            'storereceivesubs' => $storereceivesub,
            'storeexportsubs'=> $storeexportsub,
            'idstore' =>$id,
            'warehousestore' => $warehousestore,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
           
        ]);
    }


//==============================================================================================//


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



    
        return view('manager_medical.medicaltreasurysub',[
            'storereceivesubs' => $storereceivesub,
            'storeexportsubs' => $storeexportsub,
            'warehousetreasury' => $warehousetreasury,
            'idtreasury' => $id,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
       ]);
    }

    public function treasurysub_search(Request $request)
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
      
        return view('manager_medical.medicaltreasurysub',[
             'storereceivesubs' => $storereceivesub,
             'storeexportsubs'=> $storeexportsub,
             'idtreasury' => $id,
             'displaydate_bigen'=> $displaydate_bigen,
             'displaydate_end'=> $displaydate_end,
             'warehousetreasury' => $warehousetreasury,
        ]);
    }
    public function treasury_sub_detail(Request $request,$id)
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
  
        return view('manager_medical.treasury_sub_detail',[
            'storereceivesubs' => $storereceivesub,
            'storeexportsubs' => $storeexportsub,
            'warehousetreasury' => $warehousetreasury,
            'idtreasury' => $id,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
       ]);
    }
    //=================================================================================//


    public function infopayparcel(Request $request,$id)
    {    
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



        return view('manager_medical.medicalinfopayparcel',[
            'infowarehouserequest' => $infowarehouserequest,
            'infowarehouserequestsubs' => $infowarehouserequestsub,
            'infosuppliesunitrefs' => $infosuppliesunitref,
            'infosuppliess' => $infosupplies,
            'infosuppliesdepsubsups' => $infosuppliesdepsubsup,
            'warehousedisbursecycles' => $warehousedisbursecycle,
            'count' => $count
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
            $addinfowarehouserequest->WAREHOUSE_STATUS = 'Verify';
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

                   $add->WAREHOUSE_REQUEST_SUB_UNIT = $WAREHOUSE_REQUEST_SUB_UNIT[$count];
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


            return redirect()->route('mmedical.disburse');
    }


    
    //==================อนุมัติ=====

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

            //------------------------ตัดออกจากคลังหลัก-------


            $stor_id  =  DB::table('warehouse_store')->where('STORE_CODE','=',$RECEIVENAME->SUP_FSN_NUM)->first();
          
            $addstore = new Warehousestoreexportsub();
       
            $addstore->RECEIVE_SUB_ID = $checkwarehouserequestsub->RECEIVE_SUB_ID;
            $RECEIVESUBNAME2 = DB::table('supplies')->where('ID','=',$checkwarehouserequestsub->WAREHOUSE_REQUEST_SUB_DETAIL_ID)->first();
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

      return redirect()->route('mmedical.disburse');
}

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
   
    
        return view('manager_medical.medicalinfocheckdetali',[
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

    public function infochecksup(Request $request,$idref)
    {

        $infoperson = DB::table('hrd_person')
        ->orderBy('hrd_person.HR_FNAME', 'asc')  
        ->where('hrd_person.HR_STATUS_ID', '=',1)
        ->get();

        $infobudgetyear= DB::table('budget_year')->where('ACTIVE','=','True')->get();

        $infosuptype = DB::table('warehouse_sup_type')->get();
    

        $infosuppliesinven= DB::table('supplies_inven')->orderby('INVEN_ID', 'asc')->get();

        $infosuptype = DB::table('warehouse_sup_type')->get();

        $infocheckreceive = DB::table('warehouse_check_receive')->where('RECEIVE_ID','=',$idref)->first();

        $infocheckreceivesub = DB::table('warehouse_check_receive_sub')->where('RECEIVE_ID','=',$idref)->get();
        $count = DB::table('warehouse_check_receive_sub')->where('RECEIVE_ID','=',$idref)->count();


        $infosupplies= Supplies::leftJoin('supplies_type','supplies.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
        ->leftJoin('supplies_type_kind','supplies.SUP_TYPE_KIND_ID','=','supplies_type_kind.SUP_TYPE_KIND_ID')
        ->where('supplies_type_kind.SUP_TYPE_MASTER_ID','=',1)
        ->orderBy('ID', 'desc') 
        ->get();

        $infosuppliesunitref = DB::table('supplies_unit_ref')->get();

        $infosuppliesvendor = DB::table('supplies_vendor')->get();
    
        return view('manager_medical.medicalinfochecksup',[
            'infopersons' => $infoperson,  
            'infosuptypes' => $infosuptype, 
            'infobudgetyears' => $infobudgetyear, 
            'infosuppliesinvens' => $infosuppliesinven, 
            'infocheckreceive' => $infocheckreceive, 
            'infocheckreceivesubs' => $infocheckreceivesub, 
            'infosuppliess' => $infosupplies, 
            'infosuppliesunitrefs' => $infosuppliesunitref, 
            'infosuppliesvendors' => $infosuppliesvendor, 
            'count' => $count,

        ]);
    }

    

    public function updateinfochecksup(Request $request)
    {
          

             $CHECKDATE = $request->RECEIVE_CHECK_DATE;

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
            $addinfocheck->RECEIVE_CHECK_TIME = $request->RECEIVE_CHECK_TIME; 
            $addinfocheck->RECEIVE_ACCEPT_FROM = $request->RECEIVE_ACCEPT_FROM;
            $addinfocheck->RECEIVE_BUDGET_YEAR = $request->RECEIVE_BUDGET_YEAR;
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



            return redirect()->route('mmedical.detail');
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
   
    
        return view('manager_medical.medicalinfoconfirmdetail',[
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
        

        return redirect()->route('mmedical.detail');
}


 //--------------------------------

    public function reportvalue()
{

    $infosuptype = DB::table('supplies_type')->where('SUP_TYPE_MASTER_ID','=',1)->get();
   
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

    return view('manager_medical.medicalreportvalue',[
         'infosuptypes' =>$infosuptype,
         'displaydate_bigen'=> $displaydate_bigen,
         'displaydate_end'=> $displaydate_end,
         'budgets' =>  $budget,
         'year_id'=>$year_id,
    ]);
}
public function reportvaluestore()
{

    $infosuptype = DB::table('warehouse_store')
    ->leftJoin('supplies_unit_ref','warehouse_store.STORE_UNIT','=','supplies_unit_ref.ID')
    ->leftJoin('supplies','supplies.ID','=','warehouse_store.STORE_SUP_ID')
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

    return view('manager_medical.medicalreportvaluestore',[
         'infosuptypes' =>$infosuptype,
         'displaydate_bigen'=> $displaydate_bigen,
         'displaydate_end'=> $displaydate_end,
         'budgets' =>  $budget,
         'year_id'=>$year_id,
    ]);
}
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


    return view('manager_medical.medicalreportvaluetreasury',[
         'infosuptypes' =>$infosuptype,
         'displaydate_bigen'=> $displaydate_bigen,
         'displaydate_end'=> $displaydate_end,
         'budgets' =>  $budget,
         'year_id'=>$year_id,
    ]);
}



//===========================================

function addtypeitem(Request $request)
    {
     
     if($request->record_typeitem != null || $request->record_typeitem != ''){

        $count_check = Medicaltypeitem::where('TYPE_ITEM_NAME','=',$request->record_typeitem)->count();
       
        if($count_check == 0){

            $addrecord = new Medicaltypeitem(); 
            $addrecord->TYPE_ITEM_NAME = $request->record_typeitem;
            $addrecord->save(); 

        }
       

     }
        $query =  DB::table('medical_type_item')->get();
     
        $output='<option value="">--กรุณาเลือกรูปแบบ--</option>';
        
        foreach ($query as $row){
              if($request->record_typeitem == $row->TYPE_ITEM_NAME){
                $output.= '<option value="'.$row->TYPE_ITEM_ID.'" selected>'.$row->TYPE_ITEM_NAME.'</option>';
              }else{
                $output.= '<option value="'.$row->TYPE_ITEM_ID.'">'.$row->TYPE_ITEM_NAME.'</option>';
              }

              
      }


        echo $output;
        
    }


    
//===========================================

function addgroup(Request $request)
{
 
 if($request->record_groupname != null || $request->record_groupname != ''){

    $count_check = Medicalgroup::where('GROUP_NAME','=',$request->record_groupname)->count();
   
    if($count_check == 0){

        $addrecord = new Medicalgroup(); 
        $addrecord->GROUP_NAME = $request->record_groupname;
        $addrecord->save(); 

    }
   

 }
    $query =  DB::table('medical_group')->get();
 
    $output='<option value="">--กรุณาเลือกกลุ่มวัสดุ--</option>';
    
    foreach ($query as $row){
          if($request->record_groupname == $row->GROUP_NAME){
            $output.= '<option value="'.$row->GROUP_ID.'" selected>'.$row->GROUP_NAME.'</option>';
          }else{
            $output.= '<option value="'.$row->GROUP_ID.'">'.$row->GROUP_NAME.'</option>';
          }

          
  }

    echo $output;
    
}




//===========================================

function addcategory(Request $request)
    {
     
     if($request->record_catname != null || $request->record_catname != ''){

        $count_check = Medicalcategory::where('CAT_NAME','=',$request->record_catname)->count();
       
        if($count_check == 0){

            $addrecord = new Medicalcategory(); 
            $addrecord->CAT_NAME = $request->record_catname;
            $addrecord->CAT_SYM = $request->record_sym;
            $addrecord->save(); 

        }
       

     }
        $query =  DB::table('medical_category')->get();
     
        $output='<option value="">--กรุณาเลือกหมวดวัสดุ--</option>';
        
        foreach ($query as $row){
              if($request->record_catname == $row->CAT_NAME){
                $output.= '<option value="'.$row->CAT_ID.'" selected>'.$row->CAT_NAME.'</option>';
              }else{
                $output.= '<option value="'.$row->CAT_ID.'">'.$row->CAT_NAME.'</option>';
              }

              
      }

        echo $output;
        
    }


 //===================ฟังชั่นแสดงค่า

 public static function piceavg($idsup)
 {   
    
     $sumpice =  DB::table('warehouse_store_receive_sub')
     ->leftjoin('warehouse_store','warehouse_store_receive_sub.STORE_ID','=','warehouse_store.STORE_ID')
     ->where('STORE_SUP_ID','=',$idsup ) 
    ->sum('RECEIVE_SUB_VALUE');      
     $sumamount = DB::table('warehouse_store_receive_sub')
     ->leftjoin('warehouse_store','warehouse_store_receive_sub.STORE_ID','=','warehouse_store.STORE_ID')
     ->where('STORE_SUP_ID','=',$idsup ) 
    ->sum('RECEIVE_SUB_AMOUNT');      
    
    if($sumamount == 0){
        $AVG = 0;
    }else{
        $AVG = $sumpice/$sumamount;
    }
    

    return $AVG;
 }

 public static function picelast($idsup)
 {        
     $lastpice =  DB::table('warehouse_store_receive_sub')
     ->leftjoin('warehouse_store','warehouse_store_receive_sub.STORE_ID','=','warehouse_store.STORE_ID')
     ->where('STORE_SUP_ID','=',$idsup ) 
    ->max('RECEIVE_SUB_ID');   
    
    $last  =  DB::table('warehouse_store_receive_sub')
    ->where('RECEIVE_SUB_ID','=',$lastpice)
    ->first();

    if($last == null){
        $lastpicereal = '';
    }else{
        $lastpicereal = $last->RECEIVE_SUB_PICE_UNIT;
    }
  

    return $lastpicereal;
 }


 
 public static function lastupdate($idsup)
 {   
    
     $infolastup =  DB::table('supplies')
     ->where('ID','=',$idsup ) ->first();      
     $lastupdate =  $infolastup->updated_at;
    return $lastupdate;
 }

 public static function lastin($idsup)
 {   
    
     $infolastin =  DB::table('warehouse_store_receive_sub')
     ->select('warehouse_store_receive_sub.created_at')
     ->leftjoin('warehouse_store','warehouse_store.STORE_ID','=','warehouse_store_receive_sub.STORE_ID')
     ->where('STORE_SUP_ID','=',$idsup ) ->first();  
    if($infolastin == null){
        $lastin  = '0000-00-00';
    }else{
        $lastin  =  $infolastin->created_at;
    }
    
   
     return $lastin ;
 }

 public static function lastout($idsup)
 {   
    
     $infolastup =  DB::table('warehouse_store_export_sub')
     ->select('warehouse_store_export_sub.created_at')
     ->leftjoin('warehouse_store','warehouse_store.STORE_ID','=','warehouse_store_export_sub.STORE_ID')
     ->where('STORE_SUP_ID','=',$idsup ) ->first();    
     if($infolastup == null){
        $lastupdate =  '0000-00-00';
     }else{
        $lastupdate =  $infolastup->created_at;
     }  
    
    return $lastupdate;
 }

 public static function expdate($idsup)
 {   
    
     $infolastup =  DB::table('warehouse_store_receive_sub')
     ->leftjoin('warehouse_store','warehouse_store.STORE_ID','=','warehouse_store_receive_sub.STORE_ID')
     ->where('STORE_SUP_ID','=',$idsup ) ->first();   
     if($infolastup == null){
        $lastupdate =  '0000-00-00';
     }else{
        $lastupdate =  $infolastup->RECEIVE_SUB_EXP_DATE;
     }   
     
    return $lastupdate;
 }

 public static function amounttotal($idsup)
 {   
    $infowarehousestore =  DB::table('warehouse_store')->where('STORE_SUP_ID','=',$idsup )->first(); 
    
   
     if($infowarehousestore == null){
        $num1 = 0;
        $num2 = 0;
     }else{
        $num1 = ManagerwarehouseController::sumstorereceive($infowarehousestore->STORE_ID);
        $num2 = ManagerwarehouseController::sumstoreexport($infowarehousestore->STORE_ID);  
        
     }
   
     

    $amounttotal = $num1-  $num2;
    return $amounttotal;
 }

 public static function valuetotal($idsup)
 {   
    $infowarehousestore =  DB::table('warehouse_store')->where('STORE_SUP_ID','=',$idsup )->first(); 

    if($infowarehousestore == null){
        $valuetotal = 0;
    }else{
        $valuetotal = number_format(ManagerwarehouseController::sumvaluestore($infowarehousestore->STORE_ID),2);
    }
  
   
    return $valuetotal;
 }

 public static function valuemount($idsup,$mount)
 {   

    $year = date('Y');

    if($mount < 10){
        $m = '0'.$mount; 
    }else{
        $m = $mount;  
    }
   
    $valuemount =  DB::table('warehouse_store_export_sub')
    ->leftjoin('warehouse_store','warehouse_store.STORE_ID','=','warehouse_store_export_sub.STORE_ID')
    ->where('warehouse_store_export_sub.created_at','like',$year.'-'.$m.'-%')
    ->where('warehouse_store.STORE_SUP_ID','=',$idsup )
    ->sum('EXPORT_SUB_AMOUNT');      

   
    return $valuemount;
 }


 // ------------------------แปลงหน่วย

 public static function convertunit($idsup)
 {
     

    $resule =  DB::table('supplies_unit_ref')
    ->where('SUP_ID','=',$idsup)
    ->where('SUP_TOTAL','>',1)
    ->first();
   

    if($resule !== null){
        $re = $resule->SUP_TOTAL;
    }else{

        $re = 1;
    }
    
    return $re;
 }

 //----------------รายงาน

 public function medical_order(Request $request,$id)
    {

        $warehousestore= DB::table('warehouse_store')->where('STORE_ID','=',$id)->first();

        $infoorder = DB::table('supplies_con_list')
        ->select('CON_NUM','VENDOR_NAME','DATE_REGIS','CHECK_DATE','supplies_unit_ref.SUP_UNIT_NAME','supplies_con_list.SUP_TOTAL','PRICE_SUM','supplies_con_list.SUP_ID','PO_NUM')
        ->leftjoin('supplies_con','supplies_con_list.CON_ID','=','supplies_con.ID')
        ->leftjoin('supplies_unit_ref','supplies_con_list.SUP_ID','=','supplies_unit_ref.SUP_ID')
        ->where('supplies_unit_ref.SUP_TOTAL','=',1)
        ->where('supplies_con_list.SUP_ID','=',$warehousestore->STORE_SUP_ID)->get();
         
        return view('manager_medical.medical_reportorder',[
            'warehousestore' => $warehousestore,
            'infoorders' => $infoorder,
            'idstore' =>$id,
          
       ]);
    }

    public function medical_withdrawal(Request $request,$id)
    {

        $warehousestore= DB::table('warehouse_store')->where('STORE_ID','=',$id)->first();

        $infowithdrawal= DB::table('warehouse_store_export_sub')
        ->select('warehouse_store_export_sub.WAREHOUSE_REQUEST_CODE','CYCLE_DISBURSE_NAME','EXPORT_SUB_NAME','EXPORT_SUB_LOT','HR_DEPARTMENT_SUB_SUB_NAME','EXPORT_SUB_AMOUNT','SUP_UNIT_NAME','EXPORT_SUB_PICE_UNIT','EXPORT_SUB_EXP_DATE','HR_FNAME','HR_LNAME','WAREHOUSE_PAYDAY','EXPORT_SUB_ID','SUP_MASH','SUP_MASH','TYPE_ITEM_NAME')
        ->leftJoin('warehouse_disburse_cycle','warehouse_store_export_sub.WAREHOUSE_TYPE_CYCLE','=','warehouse_disburse_cycle.ID_CYCLE')
        ->leftJoin('hrd_department_sub_sub','warehouse_store_export_sub.EXPORT_SUB_TREASURY_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->leftJoin('supplies_unit_ref','warehouse_store_export_sub.EXPORT_SUB_UNIT','=','supplies_unit_ref.ID')
        ->leftJoin('warehouse_request','warehouse_request.WAREHOUSE_REQUEST_CODE','=','warehouse_store_export_sub.WAREHOUSE_REQUEST_CODE')
        ->leftJoin('hrd_person','warehouse_store_export_sub.EXPORT_SUB_USER_ID','=','hrd_person.ID')
        ->leftJoin('warehouse_store','warehouse_store.STORE_ID','=','warehouse_store_export_sub.STORE_ID')
        ->leftJoin('supplies','supplies.ID','=','warehouse_store.STORE_SUP_ID')
        ->leftJoin('medical_type_item','medical_type_item.TYPE_ITEM_ID','=','supplies.SUP_GENUS')
        ->where('warehouse_store_export_sub.STORE_ID','=',$id)->get();

        return view('manager_medical.medical_reportwithdrawal',[
            'warehousestore' => $warehousestore,
            'infowithdrawals' => $infowithdrawal,
            'idstore' =>$id,
          
       ]);
    }

    public function setting_inventory()
    {
        $inventory = Medical_set_inventory::all();
        return view('manager_medical.medical_setting_inventory_view',compact('inventory'));
    }

    public function setting_inventory_add(){
        $supplies_inven = Suppliesinven::where('ACTIVE',true)->get();
        return view('manager_medical.medical_setting_inventory_add',compact('supplies_inven'));
    }

    public function setting_inventory_save(Request $request){
        $req = json_decode($request->inventory);
        $resultsearch = Medical_set_inventory::where('INVEN_ID',$req->id)->first();
        if(empty($resultsearch)){
            $setinventory_save = new Medical_set_inventory();
            $setinventory_save->INVEN_ID = $req->id;
            $setinventory_save->SETINVEN_NAME = $req->name;
            $setinventory_save->save();
            Session::flash('scc','บันทึกข้อมูลสำเร็จ');
        }else{
            Session::flash('err','ไม่สามารถเพิ่มได้ ข้อมูลถูกเพิ่มแล้ว');
        }
        return redirect(route('mmedical.setting_inventory'));
    }

    public function setting_inventory_edit($id){
        $setinven = Medical_set_inventory::find($id);
        $supplies_inven = Suppliesinven::where('ACTIVE',true)->get();
        return view('manager_medical.medical_setting_inventory_edit',compact('supplies_inven','setinven'));
    }
    
    public function setting_inventory_update(Request $request){
        $req = json_decode($request->inventory);
        $resultsearch = Medical_set_inventory::where('INVEN_ID',$req->id)->first();
        if(empty($resultsearch)){
            $setinventory_save = Medical_set_inventory::find($request->SETINVEN_ID);
            $setinventory_save->INVEN_ID = $req->id;
            $setinventory_save->SETINVEN_NAME = $req->name;
            $setinventory_save->save();
            Session::flash('scc','แก้ไขข้อมูลสำเร็จ');
        }else{
            Session::flash('err','ไม่สามารถแก้ไขได้ ข้อมูลถูกเพิ่มแล้ว');
        }
        return redirect(route('mmedical.setting_inventory'));
    }
    
    public function setting_inventory_delete($id){
        Medical_set_inventory::destroy($id);
        Session::flash('scc','ลบข้อมูลสำเร็จ');
        return redirect(route('mmedical.setting_inventory'));
    }

    public function setting_category()
    {
        $category = Medical_set_category::all();
        return view('manager_medical.medical_setting_category_view',compact('category'));
    }

    public function setting_category_add(){
        $supplies_category = Suppliestype::where('ACTIVE',true)->get();
        return view('manager_medical.medical_setting_category_add',compact('supplies_category'));
    }

    public function setting_category_save(Request $request){
        $req = json_decode($request->category);
        $resultsearch = Medical_set_category::where('SUP_TYPE_ID',$req->id)->first();
        if(empty($resultsearch)){
            $setcategory_save = new Medical_set_category();
            $setcategory_save->SUP_TYPE_ID = $req->id;
            $setcategory_save->SETCATEGORY_NAME = $req->name;
            $setcategory_save->save();
            Session::flash('scc','บันทึกข้อมูลสำเร็จ');
        }else{
            Session::flash('err','ไม่สามารถเพิ่มได้ ข้อมูลถูกเพิ่มแล้ว');
        }
        return redirect(route('mmedical.setting_category'));
    }

    public function setting_category_edit($id){
        $setcate = Medical_set_category::find($id);
        $supplies_category = Suppliestype::where('ACTIVE',true)->get();
        return view('manager_medical.medical_setting_category_edit',compact('supplies_category','setcate'));
    }
    
    public function setting_category_update(Request $request){
        $req = json_decode($request->category);
        $resultsearch = Medical_set_category::where('SUP_TYPE_ID',$req->id)->first();
        if(empty($resultsearch)){
            $setcategory_save = Medical_set_category::find($request->SETCATEGORY_ID);
            $setcategory_save->INVEN_ID = $req->id;
            $setcategory_save->SETINVEN_NAME = $req->name;
            $setcategory_save->save();
            Session::flash('scc','แก้ไขข้อมูลสำเร็จ');
        }else{
            Session::flash('err','ไม่สามารถแก้ไขได้ ข้อมูลถูกเพิ่มแล้ว');
        }
        return redirect(route('mmedical.setting_category'));
    }
    
    public function setting_category_delete($id){
        Medical_set_category::destroy($id);
        Session::flash('scc','ลบข้อมูลสำเร็จ');
        return redirect(route('mmedical.setting_category'));
    }
}