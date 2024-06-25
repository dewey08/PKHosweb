<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\DB;
use App\Models\Person;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;
use App\Models\Supplies;
use App\Models\Warehouserequest;
use App\Models\Warehouserequestsub;
use App\Models\Warehousetreasurypaysmall;
use App\Models\Permisinvensmallhos;
use App\Models\Warehousetreasuryexportsmall;


use App\Models\Adduser;
use App\Models\Warehousesmallhos;
use Illuminate\Support\Facades\Hash;

class SmallhosController extends Controller
{

 
    public function dashboard(Request $request,$id)
            {

           
                $m_budget = date("m");
                if($m_budget>9){
                $yearbudget = date("Y")+544;
                }else{
                $yearbudget = date("Y")+543;
                }
                
                $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
                $year_id = $yearbudget;

                $year = $year_id - 543;

                $m1_1 = DB::table('warehouse_treasury_receive_sub')->where('created_at','like',$year.'-01%')->sum('TREASURY_RECEIVE_SUB_VALUE');
                $m2_1 = DB::table('warehouse_treasury_receive_sub')->where('created_at','like',$year.'-02%')->sum('TREASURY_RECEIVE_SUB_VALUE');
                $m3_1 = DB::table('warehouse_treasury_receive_sub')->where('created_at','like',$year.'-03%')->sum('TREASURY_RECEIVE_SUB_VALUE');
                $m4_1 = DB::table('warehouse_treasury_receive_sub')->where('created_at','like',$year.'-04%')->sum('TREASURY_RECEIVE_SUB_VALUE');
                $m5_1 = DB::table('warehouse_treasury_receive_sub')->where('created_at','like',$year.'-05%')->sum('TREASURY_RECEIVE_SUB_VALUE');
                $m6_1 = DB::table('warehouse_treasury_receive_sub')->where('created_at','like',$year.'-06%')->sum('TREASURY_RECEIVE_SUB_VALUE');
                $m7_1 = DB::table('warehouse_treasury_receive_sub')->where('created_at','like',$year.'-07%')->sum('TREASURY_RECEIVE_SUB_VALUE');
                $m8_1 = DB::table('warehouse_treasury_receive_sub')->where('created_at','like',$year.'-08%')->sum('TREASURY_RECEIVE_SUB_VALUE');
                $m9_1 = DB::table('warehouse_treasury_receive_sub')->where('created_at','like',$year.'-09%')->sum('TREASURY_RECEIVE_SUB_VALUE');
                $m10_1 = DB::table('warehouse_treasury_receive_sub')->where('created_at','like',$year.'-10%')->sum('TREASURY_RECEIVE_SUB_VALUE');
                $m11_1 = DB::table('warehouse_treasury_receive_sub')->where('created_at','like',$year.'-11%')->sum('TREASURY_RECEIVE_SUB_VALUE');
                $m12_1 = DB::table('warehouse_treasury_receive_sub')->where('created_at','like',$year.'-12%')->sum('TREASURY_RECEIVE_SUB_VALUE');

                $m1_2 = DB::table('warehouse_treasury_export_sub')->where('created_at','like',$year.'-01%')->sum('TREASURY_EXPORT_SUB_VALUE');
                $m2_2 = DB::table('warehouse_treasury_export_sub')->where('created_at','like',$year.'-02%')->sum('TREASURY_EXPORT_SUB_VALUE');
                $m3_2 = DB::table('warehouse_treasury_export_sub')->where('created_at','like',$year.'-03%')->sum('TREASURY_EXPORT_SUB_VALUE');
                $m4_2 = DB::table('warehouse_treasury_export_sub')->where('created_at','like',$year.'-04%')->sum('TREASURY_EXPORT_SUB_VALUE');
                $m5_2 = DB::table('warehouse_treasury_export_sub')->where('created_at','like',$year.'-05%')->sum('TREASURY_EXPORT_SUB_VALUE');
                $m6_2 = DB::table('warehouse_treasury_export_sub')->where('created_at','like',$year.'-06%')->sum('TREASURY_EXPORT_SUB_VALUE');
                $m7_2 = DB::table('warehouse_treasury_export_sub')->where('created_at','like',$year.'-07%')->sum('TREASURY_EXPORT_SUB_VALUE');
                $m8_2 = DB::table('warehouse_treasury_export_sub')->where('created_at','like',$year.'-08%')->sum('TREASURY_EXPORT_SUB_VALUE');
                $m9_2 = DB::table('warehouse_treasury_export_sub')->where('created_at','like',$year.'-09%')->sum('TREASURY_EXPORT_SUB_VALUE');
                $m10_2 = DB::table('warehouse_treasury_export_sub')->where('created_at','like',$year.'-10%')->sum('TREASURY_EXPORT_SUB_VALUE');
                $m11_2 = DB::table('warehouse_treasury_export_sub')->where('created_at','like',$year.'-11%')->sum('TREASURY_EXPORT_SUB_VALUE');
                $m12_2 = DB::table('warehouse_treasury_export_sub')->where('created_at','like',$year.'-12%')->sum('TREASURY_EXPORT_SUB_VALUE');




                return view('smallhos.dashboard_smallwarehouse',[
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
  



            //====================================================ขอเบิกวัสดุ =================================================

public function smallwithdrawindex(Request $request,$id)
{
   
   
    $m_budget = date("m");
    if($m_budget>9){
    $yearbudget = date("Y")+544;
    }else{
    $yearbudget = date("Y")+543;
    }

   
      $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

      $info_sendstatus = DB::table('warehouse_request_status')->get();

      $displaydate_bigen = ($yearbudget-544).'-10-01';
      $displaydate_end = ($yearbudget-543).'-09-30';
      $status = '';
      $search = '';
      $year_id = $yearbudget;

      $idsamllhos = Auth::user()->SMALL_ID;

      $inforwarehouserequest = Warehouserequest::leftJoin('warehouse_request_status','warehouse_request_status.STATUS_CODE','=','warehouse_request.WAREHOUSE_STATUS')  
      ->leftJoin('supplies_inven','supplies_inven.INVEN_ID','=','warehouse_request.WAREHOUSE_INVEN_ID')
      ->leftJoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','warehouse_request.WAREHOUSE_DEP_SUB_SUB_ID')
      ->leftJoin('warehouse_smallhos','warehouse_request.WAREHOUSE_SMALLHOS','=','warehouse_smallhos.WAREHOUSE_SMALLHOS_ID')
      ->where('WAREHOUSE_SMALLHOS','=',$idsamllhos)->get();

    


    return view('smallhos.smallwithdrawindex',[
        'info_sendstatuss' => $info_sendstatus,
        'budgets' =>  $budget,
        'displaydate_bigen'=> $displaydate_bigen,
        'displaydate_end'=> $displaydate_end,
        'status_check'=> $status,
        'search'=> $search,
        'year_id'=>$year_id, 
        'inforwarehouserequests' => $inforwarehouserequest
      

    ]);

}



public function smallwithdrawindexsearch(Request $request,$id)
{
   
    $search = $request->get('search');
    $status = $request->SEND_STATUS;
    $yearbudget = $request->YEAR_ID;
    $year = $yearbudget-543;
    $datebigin = $request->get('DATE_BIGIN');
    $dateend = $request->get('DATE_END');

    $idsamllhos = Auth::user()->SMALL_ID;

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
        $inforwarehouserequest = Warehouserequest::leftJoin('warehouse_request_status','warehouse_request_status.STATUS_CODE','=','warehouse_request.WAREHOUSE_STATUS')  
        ->leftJoin('supplies_inven','supplies_inven.INVEN_ID','=','warehouse_request.WAREHOUSE_INVEN_ID')
        ->leftJoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','warehouse_request.WAREHOUSE_DEP_SUB_SUB_ID')
        ->leftJoin('warehouse_smallhos','warehouse_request.WAREHOUSE_SMALLHOS','=','warehouse_smallhos.WAREHOUSE_SMALLHOS_ID')
        ->where('WAREHOUSE_SMALLHOS','=',$idsamllhos)
        ->where('WAREHOUSE_DATE_WANT','like',$year.'%')
        ->where(function($q) use ($search){
            $q->where('WAREHOUSE_REQUEST_CODE','like','%'.$search.'%');
            $q->orwhere('WAREHOUSE_REQUEST_BUY_COMMENT','like','%'.$search.'%');
            $q->orwhere('INVEN_NAME','like','%'.$search.'%');
            $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');
            $q->orwhere('WAREHOUSE_SAVE_HR_NAME','like','%'.$search.'%');
        })
        ->WhereBetween('WAREHOUSE_DATE_WANT',[$from,$to])
        ->orderBy('WAREHOUSE_ID', 'desc')
        ->get();

        }else{

            $inforwarehouserequest = Warehouserequest::leftJoin('warehouse_request_status','warehouse_request_status.STATUS_CODE','=','warehouse_request.WAREHOUSE_STATUS')  
            ->leftJoin('supplies_inven','supplies_inven.INVEN_ID','=','warehouse_request.WAREHOUSE_INVEN_ID')
            ->leftJoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','warehouse_request.WAREHOUSE_DEP_SUB_SUB_ID')
            ->leftJoin('warehouse_smallhos','warehouse_request.WAREHOUSE_SMALLHOS','=','warehouse_smallhos.WAREHOUSE_SMALLHOS_ID')
            ->where('WAREHOUSE_SMALLHOS','=',$idsamllhos)
            ->where('WAREHOUSE_STATUS','=', $status)
            ->where('WAREHOUSE_DATE_WANT','like',$year.'%')
            ->where(function($q) use ($search){
                $q->where('WAREHOUSE_REQUEST_CODE','like','%'.$search.'%');
                $q->orwhere('WAREHOUSE_REQUEST_BUY_COMMENT','like','%'.$search.'%');
                $q->orwhere('INVEN_NAME','like','%'.$search.'%');
                $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');
                $q->orwhere('WAREHOUSE_SAVE_HR_NAME','like','%'.$search.'%');
            })
            ->WhereBetween('WAREHOUSE_DATE_WANT',[$from,$to])
            ->orderBy('WAREHOUSE_ID', 'desc')
            ->get();

        }

   
      $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

      $info_sendstatus = DB::table('warehouse_request_status')->get();

      $year_id = $yearbudget;

     
    


    return view('smallhos.smallwithdrawindex',[
        'info_sendstatuss' => $info_sendstatus,
        'budgets' =>  $budget,
        'displaydate_bigen'=> $displaydate_bigen,
        'displaydate_end'=> $displaydate_end,
        'status_check'=> $status,
        'search'=> $search,
        'year_id'=>$year_id, 
        'inforwarehouserequests' => $inforwarehouserequest
      

    ]);

}




//====================================================รายการสิ่งของคงคลังในหน่วยงาน

public function smallstockcard(Request $request,$id)
{
  
    
     $idsmallhos = $id;

    $infowarehousetreasury= DB::table('warehouse_treasury_small')
    ->leftJoin('supplies_unit_ref','warehouse_treasury_small.TREASURY_SMALL_UNIT','=','supplies_unit_ref.ID')
    ->leftJoin('supplies','warehouse_treasury_small.TREASURY_SMALL_CODE','=','supplies.SUP_FSN_NUM')
    ->leftJoin('supplies_type','supplies.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
    ->where('TREASURY_SMALL_TYPE','=',$idsmallhos)    
    ->orderBy('TREASURY_SMALL_ID', 'desc') 
    ->get();

    $suppliestype = DB::table('supplies_type')->where('SUP_TYPE_MASTER_ID','=',1)->get();

    $balance1  =  DB::table('warehouse_treasury_receive_small')
    ->leftJoin('warehouse_treasury_small','warehouse_treasury_receive_small.TREASURY_ID','=','warehouse_treasury_small.TREASURY_SMALL_ID')
    ->where('TREASURY_SMALL_TYPE','=',$idsmallhos)
    ->sum('TREASURY_RECEIVE_SMALL_VALUE');

    
    $balance2  =  DB::table('warehouse_treasury_export_small')
    ->leftJoin('warehouse_treasury_small','warehouse_treasury_export_small.TREASURY_ID','=','warehouse_treasury_small.TREASURY_SMALL_ID')
    ->where('TREASURY_SMALL_TYPE','=',$idsmallhos)
    ->sum('TREASURY_EXPORT_SMALL_VALUE');

  
    $balance = $balance1 - $balance2;


    $STATUS_CODE = '';

 
    $m_budget = date("m");
    if($m_budget>9){
    $yearbudget = date("Y")+544;
    }else{
    $yearbudget = date("Y")+543;
    }

    
    $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
  
     $info_sendstatus = DB::table('warehouse_request_status')->get();

    $displaydate_bigen = ($yearbudget-544).'-10-01';
    $displaydate_end = ($yearbudget-543).'-09-30';
    $status = '';
    $search = '';
    $year_id = $yearbudget;


    

    return view('smallhos.smallstockcard',[
        'infowarehousetreasurys' => $infowarehousetreasury,
        'suppliestypes' => $suppliestype,
        'STATUS_CODE' => $STATUS_CODE,
        'search' => $search,
        'balance' => $balance,
        'budgets' =>  $budget,
        'displaydate_bigen'=> $displaydate_bigen,
        'displaydate_end'=> $displaydate_end,
        'search'=> $search,
        'year_id'=>$year_id, 
        'idsmallhos' => $idsmallhos,
    ]);
}


public function smallpayindex(Request $request,$id)
{
   
  
    $m_budget = date("m");
    if($m_budget>9){
    $yearbudget = date("Y")+544;
    }else{
    $yearbudget = date("Y")+543;
    }

    $inforwarehousetreasurysmallpay = Warehousetreasurypaysmall::leftJoin('warehouse_objectivepay','warehouse_treasury_pay_small.TREASURT_PAY_SMALL_REQUEST_OBJ','=','warehouse_objectivepay.OBJECTIVEPAY_ID')
    ->where('warehouse_treasury_pay_small.TREASURT_PAY_SMALL_REQUEST_SUB_SUB_ID','=', $id)
    ->orderBy('warehouse_treasury_pay_small.TREASURT_PAY_SMALL_ID', 'desc')
    ->get();

    $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

    $displaydate_bigen = ($yearbudget-544).'-10-01';
    $displaydate_end = ($yearbudget-543).'-09-30';

    $search = '';
    $year_id = $yearbudget;



    $detailobjectivepay = DB::table('warehouse_objectivepay')->get();

    $obj_check = '';



  

    return view('smallhos.smallpayindex',[
            'idhos'=>$id,
            'inforwarehousetreasurysmallpays' => $inforwarehousetreasurysmallpay,
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'search'=> $search,
            'year_id'=>$year_id, 
            'detailobjectivepays'=>$detailobjectivepay, 
            'obj_check'=>$obj_check, 

    ]);

}



public function smallpayindexsearch(Request $request,$id)
{
   
  
    $datebigin = $request->get('DATE_BIGIN');
    $dateend = $request->get('DATE_END');
    $obj_check = $request->SEND_OBJ;
    $search = $request->search;

    $year_id = $request->YEAR_ID;

 

    if($search=='' || $search==null){
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
  
   
    if($obj_check != null || $obj_check != '' ){

        $inforwarehousetreasurysmallpay = Warehousetreasurypaysmall::leftJoin('warehouse_objectivepay','warehouse_treasury_pay_small.TREASURT_PAY_SMALL_REQUEST_OBJ','=','warehouse_objectivepay.OBJECTIVEPAY_ID')
        ->where('warehouse_treasury_pay_small.TREASURT_PAY_SMALL_REQUEST_SUB_SUB_ID','=', $id)
        ->where('warehouse_treasury_pay_small.TREASURT_PAY_SMALL_REQUEST_OBJ','=', $obj_check)
        ->where(function($q) use ($search){
            $q->where('TREASURT_PAY_SMALL_ID','like','%'.$search.'%');
            $q->orwhere('TREASURT_PAY_SMALL_COMMENT','like','%'.$search.'%');
        })
        ->WhereBetween('TREASURT_PAY_SMALL_DATE',[$from,$to])
        ->orderBy('warehouse_treasury_pay_small.TREASURT_PAY_SMALL_ID', 'desc')
        ->get();

   

    }else{

        $inforwarehousetreasurysmallpay = Warehousetreasurypaysmall::leftJoin('warehouse_objectivepay','warehouse_treasury_pay_small.TREASURT_PAY_SMALL_REQUEST_OBJ','=','warehouse_objectivepay.OBJECTIVEPAY_ID')
        ->where('warehouse_treasury_pay_small.TREASURT_PAY_SMALL_REQUEST_SUB_SUB_ID','=', $id)
        ->where(function($q) use ($search){
            $q->where('TREASURT_PAY_SMALL_ID','like','%'.$search.'%');
            $q->orwhere('TREASURT_PAY_SMALL_COMMENT','like','%'.$search.'%');
        })
        ->WhereBetween('TREASURT_PAY_SMALL_DATE',[$from,$to])
        ->orderBy('warehouse_treasury_pay_small.TREASURT_PAY_SMALL_ID', 'desc')
        ->get();

    } 

 



    
    $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

    $detailobjectivepay = DB::table('warehouse_objectivepay')->get();



    return view('smallhos.smallpayindex',[
            'idhos'=>$id,
            'inforwarehousetreasurysmallpays' => $inforwarehousetreasurysmallpay,
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'search'=> $search,
            'year_id'=>$year_id, 
            'detailobjectivepays'=>$detailobjectivepay, 
            'obj_check'=>$obj_check, 

    ]);

}




public function smallwithdrawindex_add(Request $request)
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

    $infosupplies= Supplies::leftJoin('supplies_type','supplies.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
    ->leftJoin('supplies_type_kind','supplies.SUP_TYPE_KIND_ID','=','supplies_type_kind.SUP_TYPE_KIND_ID')
    ->where('supplies_type_kind.SUP_TYPE_MASTER_ID','=',1)
    ->orderBy('ID', 'desc') 
    ->get();

    $infosuppliesunitref = DB::table('supplies_unit_ref')->get();

    $budget = DB::table('budget_year')->where('ACTIVE','=','True')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

    $infostore = DB::table('supplies_inven')->where('ACTIVE','=','True')->get();

    $idsmallhos = Auth::user()->SMALL_ID; 
    $smallhos = DB::table('warehouse_smallhos')->where('WAREHOUSE_SMALLHOS_ID','=',$idsmallhos)->first();


    $smallpermissinven = DB::table('gsy_permis_invensmallhos')->where('INVEN_SMALLHOS_IDSMALL','=',$idsmallhos)->get();
    

    return view('smallhos.smallwithdrawindex_add',[
        'budgets' => $budget,
        'suppliestypes' => $suppliestype,
        'pessonalls' => $pessonall,
        'infosuppliess' => $infosupplies, 
        'departmentsubsubs' => $departmentsubsub,
        'infosuppliesunitrefs' => $infosuppliesunitref, 
        'orgname' => $orgname->ORG_NAME,
        'year_id' => $yearbudget,
        'infostores' => $infostore,
        'smallhos' => $smallhos,
        'smallpermissinvens' => $smallpermissinven,
    ]);

}



public function smallsaveinforequestwithdrawindex(Request $request)
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

 
  

        $smallid = Auth::user()->SMALL_ID;

        
        $addinforequest = new Warehouserequest();
        $addinforequest->WAREHOUSE_REQUEST_CODE = $refnumber;
        $addinforequest->WAREHOUSE_BUDGET_YEAR = $request->WAREHOUSE_BUDGET_YEAR;
        $addinforequest->WAREHOUSE_DATE_WANT = $DATEWANT;
        $addinforequest->WAREHOUSE_DATE_TIME_SAVE = date('Y-m-d H:i:s');
        $addinforequest->WAREHOUSE_REQUEST_BUY_COMMENT = $request->WAREHOUSE_REQUEST_BUY_COMMENT;
        $addinforequest->WAREHOUSE_SAVE_HR_ID = $request->WAREHOUSE_SAVE_HR_ID;
        $addinforequest->WAREHOUSE_INVEN_ID = $request->WAREHOUSE_INVEN_ID;
        $addinforequest->WAREHOUSE_STATUS = 'Approve';
        $addinforequest->WAREHOUSE_SAVE_HR_NAME = $request->WAREHOUSE_SAVE_HR_NAME;
        $addinforequest->WAREHOUSE_ACCEPT_SAVE_HR_NAME = $request->WAREHOUSE_ACCEPT_SAVE_HR_NAME;
        $addinforequest->WAREHOUSE_SMALLHOS = $smallid;
        $addinforequest->save();

        $WAREHOUSE_REQUEST_ID = Warehouserequest::max('WAREHOUSE_ID');

     

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
        


        return redirect()->route('smallhos.smallwithdrawindex',[
            'id' => $smallid,

        ]);
}



public function smallwithdrawindex_edit(Request $request,$id,$idref)
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

    $infosupplies= Supplies::leftJoin('supplies_type','supplies.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
    ->leftJoin('supplies_type_kind','supplies.SUP_TYPE_KIND_ID','=','supplies_type_kind.SUP_TYPE_KIND_ID')
    ->where('supplies_type_kind.SUP_TYPE_MASTER_ID','=',1)
    ->orderBy('ID', 'desc') 
    ->get();

    $infosuppliesunitref = DB::table('supplies_unit_ref')->get();

    $budget = DB::table('budget_year')->where('ACTIVE','=','True')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

    $infostore = DB::table('supplies_inven')->where('ACTIVE','=','True')->get();

    $idsmallhos = Auth::user()->SMALL_ID; 
    $smallhos = DB::table('warehouse_smallhos')->where('WAREHOUSE_SMALLHOS_ID','=',$idsmallhos)->first();


    $warehouserequest = DB::table('warehouse_request')->where('WAREHOUSE_ID','=',$idref)->first();
    $warehouserequestsub = DB::table('warehouse_request_sub')
    ->leftJoin('supplies','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_DETAIL_ID','=','supplies.ID')
    ->leftJoin('supplies_unit_ref','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_UNIT','=','supplies_unit_ref.ID')
    ->where('WAREHOUSE_REQUEST_ID','=',$idref)->get();
    

    return view('smallhos.smallwithdrawindex_edit',[
        'budgets' => $budget,
        'suppliestypes' => $suppliestype,
        'pessonalls' => $pessonall,
        'infosuppliess' => $infosupplies, 
        'departmentsubsubs' => $departmentsubsub,
        'infosuppliesunitrefs' => $infosuppliesunitref, 
        'orgname' => $orgname->ORG_NAME,
        'year_id' => $yearbudget,
        'infostores' => $infostore,
        'warehouserequest' => $warehouserequest,
        'warehouserequestsubs' => $warehouserequestsub,
        'smallhos' => $smallhos,
    ]);

}




public function smallupdateinforequestwithdrawindex(Request $request)
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


        $smallid = Auth::user()->SMALL_ID;

        $idref = $request->ID_REF;
        // dd($idref);
        $updateinforequest = Warehouserequest::find($idref);
        $updateinforequest->WAREHOUSE_BUDGET_YEAR = $request->WAREHOUSE_BUDGET_YEAR;
        $updateinforequest->WAREHOUSE_DATE_WANT = $DATEWANT;
        $updateinforequest->WAREHOUSE_DATE_TIME_SAVE = date('Y-m-d H:i:s');
        $updateinforequest->WAREHOUSE_REQUEST_BUY_COMMENT = $request->WAREHOUSE_REQUEST_BUY_COMMENT;
        $updateinforequest->WAREHOUSE_SAVE_HR_ID = $request->WAREHOUSE_SAVE_HR_ID;
        $updateinforequest->WAREHOUSE_INVEN_ID = $request->WAREHOUSE_INVEN_ID;
        $updateinforequest->WAREHOUSE_SAVE_HR_NAME = $request->WAREHOUSE_SAVE_HR_NAME;
        $updateinforequest->WAREHOUSE_ACCEPT_SAVE_HR_NAME = $request->WAREHOUSE_ACCEPT_SAVE_HR_NAME;
        $updateinforequest->WAREHOUSE_SMALLHOS = $smallid;
        $updateinforequest->save();

        $inforequertwarehouse = Warehouserequest::where('WAREHOUSE_ID','=',$idref);

        Warehouserequestsub::where('WAREHOUSE_REQUEST_ID', '=', $idref)->delete();


        $WAREHOUSE_REQUEST_SUB_DETAIL_ID = $request->WAREHOUSE_REQUEST_SUB_DETAIL_ID;
        $WAREHOUSE_REQUEST_SUB_AMOUNT = $request->WAREHOUSE_REQUEST_SUB_AMOUNT;
        $WAREHOUSE_REQUEST_SUB_UNIT = $request->WAREHOUSE_REQUEST_SUB_UNIT;

        $number =count($WAREHOUSE_REQUEST_SUB_DETAIL_ID);
        $count = 0;
        for($count = 0; $count< $number; $count++)
            {
               $add = new Warehouserequestsub();
               $add->WAREHOUSE_REQUEST_ID = $idref;
               $add->WAREHOUSE_REQUEST_SUB_DETAIL_ID = $WAREHOUSE_REQUEST_SUB_DETAIL_ID[$count];
               $add->WAREHOUSE_REQUEST_SUB_AMOUNT = $WAREHOUSE_REQUEST_SUB_AMOUNT[$count];
               $add->WAREHOUSE_REQUEST_SUB_UNIT = $WAREHOUSE_REQUEST_SUB_UNIT[$count];
               $add->save();
            }
        


        return redirect()->route('smallhos.smallwithdrawindex',[
            'id' => $smallid,

        ]);
}



//-----------------------------------------------จบหน้าการเบิกของจากคลัง


public function smallpayindex_add(Request $request,$idsmall)
    {

        $infoobj = DB::table('warehouse_objectivepay')->get();
    
        $infoperson = DB::table('hrd_person')
        ->orderBy('hrd_person.HR_FNAME', 'asc')  
        ->get();

        $check = 0 ;

        $infohos = DB::table('warehouse_smallhos')->where('WAREHOUSE_SMALLHOS_ID','=',$idsmall)->first();

        return view('smallhos.smallpayindex_add',[
            'idsmall' => $idsmall,
            'infohos' => $infohos,
            'infoobjs' => $infoobj,
            'check' => $check,
            'infopersons' => $infoperson
        
        ]);

    }




    //===========================================

    function detailsmallhos(Request $request)
    {
    $id = $request->get('id');

    $detail = DB::table('warehouse_request')
    ->leftjoin('warehouse_smallhos','warehouse_smallhos.WAREHOUSE_SMALLHOS_ID','=','warehouse_request.WAREHOUSE_SMALLHOS')
    ->where('WAREHOUSE_ID','=',$id)->first();

    $detailperson = DB::table('hrd_person')->where('ID','=',$detail->WAREHOUSE_SAVE_HR_ID)->first();

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
        <h1 style="text-align: left;font-family: \'Kanit\', sans-serif; font-size:10px;font-size: 1.0rem;font-weight:normal;color:#778899;">'.DateThai($detail -> WAREHOUSE_DATE_WANT).'</h1>
        </div>
    </div>

    <div class="col-sm-2">
        <div class="form-group">
        <label >เพื่อจัดซื้อ/ซ่อมแซม  :</label>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
        <h1 style="text-align: left;font-family: \'Kanit\', sans-serif; font-size:10px;font-size: 1.0rem;font-weight:normal;color:#778899;">'.$detail -> WAREHOUSE_REQUEST_FOR.'</h1>
        </div>
    </div>

    </div>

    <div class="row">

    <div class="col-sm-2">
        <div class="form-group">
        <label >ผู้แจ้งขอซื้อ/ขอจ้าง :</label>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group" >
        <h1 style="text-align: left;font-family: \'Kanit\', sans-serif; font-size:10px;font-size: 1.0rem;font-weight:normal;color:#778899;">'.$detail -> WAREHOUSE_SAVE_HR_NAME.'</h1>
        </div>
    </div>

    <div class="col-sm-2">
        <div class="form-group">
        <label >หน่วยงานที่ร้องขอ  :</label>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
        <h1 style="text-align: left;font-family: \'Kanit\', sans-serif; font-size:10px;font-size: 1.0rem;font-weight:normal;color:#778899;" >'.$detail -> WAREHOUSE_SMALLHOS_NAME.'</h1>
        </div>
    </div>

    </div>


   


        </div>
        </div>

        <div class="col-sm-2">
                
        <div class="form-group">


        </div>

        </div>

        </div>
        ';

        $detail_subs_sum = DB::table('warehouse_request_sub')->where('WAREHOUSE_REQUEST_ID','=',$id)->sum('WAREHOUSE_REQUEST_SUB_SUM_PRICE');

        $output.=' 
        <div align="right">จำนวนเงินรวม '.number_format($detail_subs_sum,2).'  บาท</div>
        <table class="table-bordered table-striped table-vcenter js-dataTable-simple" style="width: 100%;">
        <thead style="background-color: #FFEBCD;">
            <tr height="40">
            <th  class="text-font" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;" width="5%">ลำดับ</th>
                <th  class="text-font" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">รายละเอียด</th>
                <th  class="text-font" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;" width="15%">จำนวนเบิก</th>
                <th  class="text-font" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;" width="15%">จำนวนจ่าย</th>
                <th  class="text-font" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;" width="15%">หน่วย</th>
            

            </tr >
        </thead>
        <tbody>     ';

            $detail_subs = DB::table('warehouse_request_sub')->where('WAREHOUSE_REQUEST_ID','=',$id)
            ->leftJoin('supplies','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_DETAIL_ID','=','supplies.ID')
            ->leftJoin('supplies_unit_ref','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_UNIT','=','supplies_unit_ref.ID')
            ->get();

            $count = 1;
            foreach ($detail_subs as $detailsub){
            $output.='  <tr height="20">
            <td class="text-font" align="center" style="border: 1px solid black;" >'.$count.'</td>
            <td class="text-font text-pedding" style="border: 1px solid black;" >'.$detailsub->SUP_NAME.'</td>
            <td class="text-font" align="center" style="border: 1px solid black;" >'.$detailsub->WAREHOUSE_REQUEST_SUB_AMOUNT.'</td>
            <td class="text-font" align="center" style="border: 1px solid black;" >'.$detailsub->WAREHOUSE_REQUEST_SUB_AMOUNT_PAY.'</td>
            <td class="text-font" align="center" style="border: 1px solid black;" >'.$detailsub->SUP_UNIT_NAME.'</td>
            
            </tr>';

            $count++;
            }



            $output.=' </tbody></table><br> ';

            echo $output;


    }




    


//-------------------------------คลังย่อย รพสต-----

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




public static function sumvaluetreasuryexportsmall($id)
{
   
     $balance2  =  DB::table('warehouse_treasury_export_small')->where('TREASURY_ID','=',$id)->sum('TREASURY_EXPORT_SMALL_VALUE');

   

   return $balance2 ;
}



public static function sumvaluetreasuryallsmall($iddep)
{
     $balance1  =  DB::table('warehouse_treasury_receive_small')
     ->leftJoin('warehouse_treasury_small','warehouse_treasury_receive_sub.TREASURY_ID','=','warehouse_treasury_small.TREASURY_SMALL_ID')
     ->where('TREASURY_TYPE','=',$iddep)
     ->sum('TREASURY_RECEIVE_SMALL_VALUE');


     $balance2  =  DB::table('warehouse_treasury_export_small')
     ->leftJoin('warehouse_treasury_small','warehouse_treasury_export_small.TREASURY_ID','=','warehouse_treasury_small.TREASURY_SMALL_ID')
     ->where('TREASURY_TYPE','=',$iddep)
     ->sum('TREASURY_EXPORT_SMALL_VALUE');

     $balance = $balance1 - $balance2;

   return $balance ;
}

//----------------
public static function sumtreasuryexportsubsmall($id)
{
   $total  =  DB::table('warehouse_treasury_export_small')->where('TREASURY_EXPORT_SMALL_ID','=',$id)->sum('TREASURY_EXPORT_SMALL_AMOUNT');
 return $total ;
}
//--------------------




public function smallinfostockcardsub(Request $request,$id,$idhos)
{

    $storereceivesub= DB::table('warehouse_treasury_receive_small')
    ->leftJoin('warehouse_request_sub','warehouse_treasury_receive_small.WAREHOUSE_REQUEST_SMALL_ID','=','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_ID')
    ->leftJoin('warehouse_request','warehouse_request_sub.WAREHOUSE_REQUEST_ID','=','warehouse_request.WAREHOUSE_ID')
    ->leftJoin('warehouse_disburse_cycle','warehouse_request.WAREHOUSE_TYPE_CYCLE','=','warehouse_disburse_cycle.ID_CYCLE')
    ->leftJoin('warehouse_smallhos','warehouse_request.WAREHOUSE_SMALLHOS','=','warehouse_smallhos.WAREHOUSE_SMALLHOS_ID')
    ->leftJoin('supplies_unit_ref','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_UNIT','=','supplies_unit_ref.ID')
    ->where('TREASURY_ID','=',$id)
    ->orderBy ('TREASURY_RECEIVE_SMALL_ID','asc')
    ->get();
    
    // dd($storereceivesub);

    $storeexportsub= DB::table('warehouse_treasury_export_small')
    ->leftJoin('warehouse_treasury_pay_small','warehouse_treasury_pay_small.TREASURT_PAY_SMALL_ID','=','warehouse_treasury_export_small.TREASURT_PAY_SMALL_ID')      
    ->leftJoin('supplies_unit_ref','warehouse_treasury_export_small.TREASURY_EXPORT_SMALL_UNIT','=','supplies_unit_ref.ID')
    ->where('TREASURY_ID','=',$id)
    ->orderBy ('TREASURY_EXPORT_SMALL_ID','desc')
    ->get();

    $warehousetreasury= DB::table('warehouse_treasury_small')->where('TREASURY_SMALL_ID','=',$id)->first();
   
    $m_budget = date("m");
    if($m_budget>9){
    $yearbudget = date("Y")+544;
    }else{
    $yearbudget = date("Y")+543;
    }

    $displaydate_bigen = ($yearbudget-544).'-10-01';
    $displaydate_end = ($yearbudget-543).'-09-30';

    //=================================
    $balance1  =  DB::table('warehouse_treasury_receive_small')->where('TREASURY_ID','=',$id)->sum('TREASURY_RECEIVE_SMALL_VALUE');
    $balance2  =  DB::table('warehouse_treasury_export_small')->where('TREASURY_ID','=',$id)->sum('TREASURY_EXPORT_SMALL_VALUE');

    $balance = $balance1 - $balance2;



    return view('smallhos.smallstockcardsub_genwarehouse',[
        'idsmallhos' => $idhos,
        'storereceivesubs' => $storereceivesub,
        'storeexportsubs' => $storeexportsub,
        'warehousetreasury' => $warehousetreasury,
        'displaydate_bigen'=> $displaydate_bigen,
        'displaydate_end'=> $displaydate_end,
        'balance2'=> $balance2,
        'balance'=> $balance,
        'idtreasury' => $id
    ]);
}




//=======================================================ฟังชั่น===============

function detailsupsmall (Request $request)
{


            $iddep = $request->get('iddep');

            $count = $request->get('count');

            $detailwarehousestorereceivesubs = DB::table('warehouse_treasury_receive_small')
            ->leftJoin('warehouse_treasury_small','warehouse_treasury_receive_small.TREASURY_ID','=','warehouse_treasury_small.TREASURY_SMALL_ID')
            ->where('warehouse_treasury_small.TREASURY_SMALL_TYPE','=',$iddep)->get();


            $output ='
            <table class="table-bordered table-striped table-vcenter js-dataTable-simple" style="width: 100%;">
            <thead style="background-color: #FFEBCD;">
            <tr>
                <td style="text-align: center;" width="30%">รายละเอียด</td>
                <td style="text-align: center;">ล็อต</th>
                <td style="text-align: center;" >จำนวนคงเหลือ</td>
                <td style="text-align: center;" >ราคาต่อหน่วย</td>
                <td style="text-align: center;" >วันหมดอายุ</td>
                <td style="text-align: center;" >หน่วยงาน</td>
                <td style="text-align: center;" width="5%">เลือก</td>
            </tr>
            </thead>
            <tbody id="myTable">';

                    
                    foreach ($detailwarehousestorereceivesubs as $detailwarehousestorereceivesub){

                        $lotreceive =  DB::table('warehouse_treasury_receive_small')->where('TREASURY_RECEIVE_SMALL_ID','=',$detailwarehousestorereceivesub->TREASURY_RECEIVE_SMALL_ID)->first();
                    
                        $sumlotexport = DB::table('warehouse_treasury_export_small')->where('TREASURY_RECEIVE_SMALL_ID','=',$detailwarehousestorereceivesub->TREASURY_RECEIVE_SMALL_ID)->sum('TREASURY_EXPORT_SMALL_AMOUNT');

                    
                        $amountlot = $lotreceive->TREASURY_RECEIVE_SMALL_AMOUNT;
                        $amountexport = $sumlotexport; 

                        $total = $amountlot - $amountexport; 

                        if($total != 0){
                        $output.='  <tr height="20">
                        <td class="text-font text-pedding" >'.$detailwarehousestorereceivesub->TREASURY_RECEIVE_SMALL_NAME.'</td>
                        <td class="text-font" align="center" >'.$detailwarehousestorereceivesub->TREASURY_RECEIVE_SMALL_LOT.'</td>
                        <td class="text-font" style="padding-right:10px;" align="right" >'.$total.'</td>
                        <td class="text-font text-pedding" align="center" >'.$detailwarehousestorereceivesub->TREASURY_RECEIVE_SMALL_PICE_UNIT.'</td>
                        <td class="text-font text-pedding" align="center" >'.DateThai($detailwarehousestorereceivesub->TREASURY_RECEIVE_SMALL_EXP_DATE).'</td>
                        <td class="text-font text-pedding" align="center" >'.$detailwarehousestorereceivesub->TREASURY_SMALL_TYPE_NAME.'</td>
                        <td class="text-font text-pedding" align="center" ><button type="button" class="btn btn-hero-sm btn-hero-info"  style="font-family: \'Kanit\', sans-serif; font-size: 10px;font-weight:normal;"  onclick="selectsup('.$detailwarehousestorereceivesub->TREASURY_RECEIVE_SMALL_ID.','.$count.')">เลือก</button></td> 
                    </tr>';
                        }


                    }
                        $output.='</tbody>
                        </table>';


                        echo $output;


}

////===========================ตั้งค่า รพสต.======================

public function infosetupsmallhos()
{   
    $infomationsmallhos = DB::table('warehouse_smallhos')->orderby('WAREHOUSE_SMALLHOS_ID', 'asc')->get();

  return view('smallhos.setupinfosmallhos',[      
          'infomationsmallhoss' =>  $infomationsmallhos             
      ]);
}


public function createsetupsmallhos(Request $request)
{           
    return view('smallhos.setupinfosmallhos_add');
}

public function savesetupsmallhos(Request $request)
{
  $addsmallhos= new Warehousesmallhos(); 
  $addsmallhos->WAREHOUSE_SMALLHOS_CODE = $request->WAREHOUSE_SMALLHOS_CODE;
  $addsmallhos->WAREHOUSE_SMALLHOS_NAME = $request->WAREHOUSE_SMALLHOS_NAME;
  $addsmallhos->save();
  

  $idsmall = Warehousesmallhos::max('WAREHOUSE_SMALLHOS_ID');
  $password                = "123456";
  $adduser                 = new Adduser();
  $adduser->name           = $request->WAREHOUSE_SMALLHOS_NAME;
  $adduser->email          = $request->WAREHOUSE_SMALLHOS_CODE.'@smallhos.com';
  $adduser->password       = Hash::make($password);
  $adduser->remember_token = $request->_token;
  $adduser->status         = 'SMALL';
  $adduser->username       = $request->WAREHOUSE_SMALLHOS_CODE;
  $adduser->SMALL_ID      = $idsmall;
  $adduser->save();


  return redirect()->route('setsmallhos.infosetupsmallhos'); 
}

public function editsetupsmallhos(Request $request,$id)
{    
    $infosmallhos = DB::table('warehouse_smallhos')->where('WAREHOUSE_SMALLHOS_ID','=',$id)->first();

  return view('smallhos.setupinfosmallhos_edit',[
    'infosmallhos' => $infosmallhos,
    ]);
}


public function updatesetupsmallhos(Request $request)
{
    $idref = $request->WAREHOUSE_SMALLHOS_ID;  


    $updatesmallhos= Warehousesmallhos::find($idref);
    $updatesmallhos->WAREHOUSE_SMALLHOS_CODE = $request->WAREHOUSE_SMALLHOS_CODE;
    $updatesmallhos->WAREHOUSE_SMALLHOS_NAME = $request->WAREHOUSE_SMALLHOS_NAME;
    $updatesmallhos->save();
    
 
   
    $selectiduse =  Adduser::where('SMALL_ID','=',$idref)->first();

    $updateuser                 = Adduser::find($selectiduse->id);
    $updateuser->name           = $request->WAREHOUSE_SMALLHOS_NAME;
    $updateuser->email          = $request->WAREHOUSE_SMALLHOS_CODE.'@smallhos.com';
    $updateuser->username       = $request->WAREHOUSE_SMALLHOS_CODE;
    $updateuser->save();

    

    return redirect()->route('setsmallhos.infosetupsmallhos');
}



public function infosmallinvenpermis ($idref)
{
    $infosmall = DB::table('warehouse_smallhos')->where('WAREHOUSE_SMALLHOS_ID','=',$idref)->first();
    $infoinven = DB::table('supplies_inven')->where('ACTIVE','=','True')->get();

    $infopermissinven = DB::table('gsy_permis_invensmallhos')->where('INVEN_SMALLHOS_IDSMALL','=',$idref)->get();

    return view('smallhos.setupinfosmallhos_permiss',[
        'infoinvens' => $infoinven,
        'infosmall' => $infosmall,
        'infopermissinvens' => $infopermissinven,
       
    ]);
}


public function saveinvenpermis(Request $request)
{
  
   $smallid = $request->INVEN_SMALLHOS_IDSMALL;
   $idinven = $request->INVEN_SMALLHOS_IDINVEN;

    $infosmallhos = DB::table('warehouse_smallhos')->where('WAREHOUSE_SMALLHOS_ID','=',$smallid)->first();
    $infoinven = DB::table('supplies_inven')->where('INVEN_ID','=',$idinven)->first();

        $addinvenpermiss = new Permisinvensmallhos(); 
        $addinvenpermiss->INVEN_SMALLHOS_IDSMALL = $smallid; 
        $addinvenpermiss->INVEN_SMALLHOS_NAMESMALL =  $infosmallhos->WAREHOUSE_SMALLHOS_NAME;
        $addinvenpermiss->INVEN_SMALLHOS_IDINVEN = $idinven; 
        $addinvenpermiss->INVEN_SMALLHOS_NAMEINVEN =  $infoinven->INVEN_NAME;
        $addinvenpermiss->save();


        return redirect()->route('setsmallhos.infosmallinvenpermis',[
            'idref' => $smallid 
        ]);

}

public function destroyinvenpermis($id,$smallid) { 

    Permisinvensmallhos::destroy($id);         
    return redirect()->route('setsmallhos.infosmallinvenpermis',[
        'idref' => $smallid 
    ]);
}


//--------------------------------------ฟังชั่นการเรื่องรายการ lot รพสต. -------------------------

                function selectsup(Request $request)
                {

                    $idsup = $request->get('idsup');
             
                    $inforeceive_sub = DB::table('warehouse_treasury_receive_small')
                    ->leftJoin('warehouse_treasury_small','warehouse_treasury_receive_small.TREASURY_ID','=','warehouse_treasury_small.TREASURY_SMALL_ID')  
                    ->where('warehouse_treasury_receive_small.TREASURY_RECEIVE_SMALL_ID','=',$idsup)->first();

    //   dd($inforeceive_sub->TREASURY_RECEIVE_SMALL_NAME);

                    $output = $inforeceive_sub->TREASURY_RECEIVE_SMALL_NAME.' 
                    <input  type="hidden"  name="TREASURY_RECEIVE_ID[]" id="TREASURY_RECEIVE_ID" class="form-control input-sm" value="'.$inforeceive_sub->TREASURY_RECEIVE_ID.'">
                    <input  type="hidden"  name="TREASURY_EXPORT_SMALL_NAME[]" id="TREASURY_EXPORT_SMALL_NAME" class="form-control input-sm" value="'.$inforeceive_sub->TREASURY_RECEIVE_SMALL_NAME.'"> 
                    <input  type="hidden"  name="TREASURY_ID[]" id="TREASURY_ID" class="form-control input-sm" value="'.$inforeceive_sub->TREASURY_ID.'">
                    <input  type="hidden"  name="TREASURY_RECEIVE_SMALL_ID[]" id="TREASURY_RECEIVE_SMALL_ID" class="form-control input-sm" value="'.$inforeceive_sub->TREASURY_RECEIVE_SMALL_ID.'">';
                    
                    echo $output;
                }


                function selectsuplot(Request $request)
                {
                    
                    $idsup = $request->get('idsup');

                    $inforeceive_sub = DB::table('warehouse_treasury_receive_small')->where('TREASURY_RECEIVE_SMALL_ID','=',$idsup)->first();

                    $output = $inforeceive_sub->TREASURY_RECEIVE_SMALL_LOT.'<input  type="hidden" name="TREASURY_EXPORT_SMALL_LOT[]" id="TREASURY_EXPORT_SMALL_LOT" class="form-control input-sm" value="'.$inforeceive_sub->TREASURY_RECEIVE_SMALL_LOT.'">';
                    echo $output;
                }

                function selectsuptotal(Request $request)
                {

                    $idsup = $request->get('idsup');
                    $count = $request->get('count');

                    $inforeceive_sub = DB::table('warehouse_treasury_receive_small')->where('TREASURY_RECEIVE_SMALL_ID','=',$idsup)->first();

                    $lotreceive =  DB::table('warehouse_treasury_receive_small')->where('TREASURY_RECEIVE_SMALL_ID','=',$inforeceive_sub->TREASURY_RECEIVE_SMALL_ID)->first();

                    $sumlotexport = DB::table('warehouse_treasury_export_small')->where('TREASURY_RECEIVE_SMALL_ID','=',$inforeceive_sub->TREASURY_RECEIVE_SMALL_ID)->sum('TREASURY_EXPORT_SMALL_AMOUNT');


                    $amountlot = $lotreceive->TREASURY_RECEIVE_SMALL_AMOUNT;
                    $amountexport = $sumlotexport; 

                    $total = $amountlot - $amountexport; 

                    $output =  $total.'<input type="hidden" name="TREASURY_EXPORT_SMALL_VALUE[]" id="TREASURY_EXPORT_SMALL_VALUE'.$count.'" class="form-control input-sm" value="'.$total.'">';
                    echo $output;
                }


                function selectsupunit(Request $request)
                {

                    $idsup = $request->get('idsup');

                    $inforeceive_sub = DB::table('warehouse_treasury_receive_small')
                    ->leftJoin('supplies_unit_ref','warehouse_treasury_receive_small.TREASURY_RECEIVE_SMALL_UNIT','=','supplies_unit_ref.ID')
                    ->where('TREASURY_RECEIVE_SMALL_ID','=',$idsup)->first();

                    $output = $inforeceive_sub->SUP_UNIT_NAME.'<input type="hidden" name="TREASURY_EXPORT_SMALL_UNIT[]" id="TREASURY_EXPORT_SMALL_UNIT" class="form-control input-sm" value="'.$inforeceive_sub->TREASURY_RECEIVE_SMALL_UNIT.'">';
                    echo $output;
                }

                function selectsuppiceunit(Request $request)
                {

                    $idsup = $request->get('idsup');
                    $count = $request->get('count');

                    $inforeceive_sub = DB::table('warehouse_treasury_receive_small')->where('TREASURY_RECEIVE_SMALL_ID','=',$idsup)->first();

                    $output = number_format($inforeceive_sub->TREASURY_RECEIVE_SMALL_PICE_UNIT,5).'<input type="hidden" name="TREASURY_EXPORT_SMALL_PICE_UNIT[]" id="RECEIVE_SMALL_PICE_UNIT'.$count.'" class="form-control input-sm" value="'.$inforeceive_sub->TREASURY_RECEIVE_SMALL_PICE_UNIT.'">';
                    echo $output;
                }

                function selectsupdatget(Request $request)
                {



                    $idsup = $request->get('idsup');

                    $inforeceive_sub = DB::table('warehouse_treasury_receive_small')->where('TREASURY_RECEIVE_SMALL_ID','=',$idsup)->first();

                    $output = DateThai($inforeceive_sub->TREASURY_RECEIVE_SMALL_GEN_DATE).'<input type="hidden" name="TREASURY_EXPORT_SMALL_GEN_DATE[]" id="WAREHOUSE_REQUEST_SMALL_GEN_DATE" class="form-control input-sm" value="'.$inforeceive_sub->TREASURY_RECEIVE_SMALL_GEN_DATE.'">';
                    echo $output;
                }

                function selectsupdatexp(Request $request)
                {
                    $idsup = $request->get('idsup');

                    $inforeceive_sub = DB::table('warehouse_treasury_receive_small')->where('TREASURY_RECEIVE_SMALL_ID','=',$idsup)->first();

                    $output = DateThai($inforeceive_sub->TREASURY_RECEIVE_SMALL_EXP_DATE).'<input type="hidden" name="TREASURY_EXPORT_SMALL_EXP_DATE[]" id="WAREHOUSE_REQUEST_SMALL_EXP_DATE" class="form-control input-sm" value="'.$inforeceive_sub->TREASURY_RECEIVE_SMALL_EXP_DATE.'">';
                    echo $output;
                }

//-----------------------------------------------------------------------

                public function saveinfopaysmall(Request $request)
                {
                    $TREASURT_PAY_SMALL_DATE = $request->TREASURT_PAY_SMALL_DATE;
            
                    // dd($TREASURT_PAY_DATE);
            
            
                    if($TREASURT_PAY_SMALL_DATE != ''){
                        $DAY = Carbon::createFromFormat('d/m/Y',$TREASURT_PAY_SMALL_DATE)->format('Y-m-d');
                        $date_arrary_st=explode("-",$DAY);
                        $y_sub_st = $date_arrary_st[0];
            
                        if($y_sub_st >= 2500){
                            $y_st = $y_sub_st-543;
                        }else{
                            $y_st = $y_sub_st;
                        }
                        $m_st = $date_arrary_st[1];
                        $d_st = $date_arrary_st[2];
                        $TREASURTPAYDATE= $y_st."-".$m_st."-".$d_st;
                        }else{
                        $TREASURTPAYDATE= null;
                    }
            
                    $codepay_max = Warehousetreasurypaysmall::max('TREASURT_PAY_SMALL_ID');
            
                    if($codepay_max == null){
                     $codepay = 0;
                    }else{
                     $codepay = $codepay_max;
                    }
            
                   
            
                    $TREASURT_PAY_CODE = $codepay+1;
                
                    $infocheck =  Warehousetreasurypaysmall::where('TREASURT_PAY_SMALL_ID','=',$codepay)->first();
    

                        $addsaveinfopaysmall = new Warehousetreasurypaysmall();
                        $addsaveinfopaysmall->TREASURT_PAY_SMALL_DATE = $TREASURTPAYDATE;
                        $addsaveinfopaysmall->TREASURT_PAY_SMALL_COMMENT = $request->TREASURT_PAY_SMALL_COMMENT;
                        $addsaveinfopaysmall->TREASURT_PAY_SMALL_REQUEST_OBJ = $request->TREASURT_PAY_SMALL_REQUEST_OBJ;
                        $addsaveinfopaysmall->TREASURT_PAY_SMALL_NAME = $request->TREASURT_PAY_SMALL_NAME;
                        $addsaveinfopaysmall->TREASURT_PAY_SMALL_REQUEST_SUB_SUB_ID = $request->TREASURT_PAY_SMALL_REQUEST_SUB_SUB_ID;
                        $addsaveinfopaysmall->save();

                        $TREASURT_PAY_SMALL_ID = Warehousetreasurypaysmall::max('TREASURT_PAY_SMALL_ID');                    

                        if($request->TREASURY_RECEIVE_ID != '' || $request->TREASURY_RECEIVE_ID != null){
            
                            $TREASURY_RECEIVE_ID = $request->TREASURY_RECEIVE_ID;
                            $TREASURY_EXPORT_SMALL_NAME = $request->TREASURY_EXPORT_SMALL_NAME;
                            $TREASURY_ID = $request->TREASURY_ID;
                            $TREASURY_RECEIVE_SMALL_ID = $request->TREASURY_RECEIVE_SMALL_ID;
                            $TREASURY_EXPORT_SMALL_LOT = $request->TREASURY_EXPORT_SMALL_LOT;
                               
                            $TREASURY_EXPORT_SMALL_VALUE = $request->TREASURY_EXPORT_SMALL_VALUE;
                            $TREASURY_EXPORT_SMALL_UNIT = $request->TREASURY_EXPORT_SMALL_UNIT;
                            $TREASURY_EXPORT_SMALL_PICE_UNIT = $request->TREASURY_EXPORT_SMALL_PICE_UNIT;
                            
                            $TREASURY_EXPORT_SMALL_GEN_DATE = $request->TREASURY_EXPORT_SMALL_GEN_DATE;
                            $TREASURY_EXPORT_SMALL_EXP_DATE = $request->TREASURY_EXPORT_SMALL_EXP_DATE;
 
                            $TREASURY_EXPORT_SMALL_AMOUNT = $request->TREASURY_EXPORT_SMALL_AMOUNT;
                            
                        
            
                            $number =count($TREASURY_RECEIVE_ID);
                            $count = 0;
                            for($count = 0; $count< $number; $count++)
                            {
                            
                
                            if($TREASURY_EXPORT_SMALL_GEN_DATE[$count] != ''){
                                $DAY =$TREASURY_EXPORT_SMALL_GEN_DATE[$count];
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
            
                            // dd($GENDATE);
            
                            if($TREASURY_EXPORT_SMALL_EXP_DATE[$count] != ''){
                                $DAY = $TREASURY_EXPORT_SMALL_EXP_DATE[$count];
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
            
                      
                                $add = new Warehousetreasuryexportsmall();
                                $add->TREASURY_EXPORT_ID = $TREASURT_PAY_SMALL_ID;
                                $add->TREASURY_RECEIVE_ID = $TREASURY_RECEIVE_ID[$count];
                                $add->TREASURY_EXPORT_SMALL_NAME = $TREASURY_EXPORT_SMALL_NAME[$count];
                                $add->TREASURY_ID = $TREASURY_ID[$count];
                                $add->TREASURY_RECEIVE_SMALL_ID = $TREASURY_RECEIVE_SMALL_ID[$count];
                            
                                $add->TREASURY_EXPORT_SMALL_VALUE = $TREASURY_EXPORT_SMALL_VALUE[$count];
                
                        
                                $add->TREASURY_EXPORT_SMALL_UNIT = $TREASURY_EXPORT_SMALL_UNIT[$count];
                                $add->TREASURY_EXPORT_SMALL_PICE_UNIT = $TREASURY_EXPORT_SMALL_PICE_UNIT[$count];
                            
                                $add->TREASURY_EXPORT_SMALL_GEN_DATE = $GENDATE;
                                $add->TREASURY_EXPORT_SMALL_EXP_DATE = $EXPDATE;
                            
                                $add->TREASURY_RECEIVE_SMALL_ID = $TREASURY_RECEIVE_SMALL_ID[$count];
                                $add->TREASURY_EXPORT_SMALL_AMOUNT = $TREASURY_EXPORT_SMALL_AMOUNT[$count];
            
                        //---------------ตรวจสอบจำนวนของที่เหลือ
                            $inforecheckre = DB::table('warehouse_treasury_receive_small')->where('TREASURY_ID','=',$TREASURY_ID[$count])->where('TREASURY_RECEIVE_ID','=',$TREASURY_RECEIVE_ID[$count])->sum('TREASURY_RECEIVE_SMALL_AMOUNT');
                            $inforecheckex = DB::table('warehouse_treasury_export_small')->where('TREASURY_ID','=',$TREASURY_ID[$count])->where('TREASURY_RECEIVE_ID','=',$TREASURY_RECEIVE_ID[$count])->sum('TREASURY_EXPORT_SMALL_AMOUNT');
            
                            $totalsumpay = $inforecheckex  + $TREASURY_EXPORT_SMALL_AMOUNT[$count];
                         
                            if( $inforecheckre >= $totalsumpay){
                            $add->save();
                            }
            
                            }
                        }
                
            
            
                        return redirect()->route('smallhos.smallpayindex',['id' => $request->TREASURT_PAY_SMALL_REQUEST_SUB_SUB_ID]);
                }
            


   
                function detailpaysmall(Request $request)
                {
            
            
                $id = $request->get('id');
            
            
                $output='<table class="table-bordered table-striped table-vcenter js-dataTable-simple" style="width: 100%;">
                    <thead style="background-color: #FFEBCD;">
                        <tr height="40">
                        <th  class="text-font" style="border-color:#F0FFFF;text-align: center;" width="5%">ลำดับ</th>
                            <th  class="text-font" style="border-color:#F0FFFF;text-align: center;">รายละเอียด</th>
                            <th  class="text-font" style="border-color:#F0FFFF;text-align: center;" width="15%">จำนวนจ่าย</th>
                            <th  class="text-font" style="border-color:#F0FFFF;text-align: center;" width="15%">มูลค่า</th>
                            <th  class="text-font" style="border-color:#F0FFFF;text-align: center;" width="15%">หน่วย</th>
                        
            
                        </tr >
                    </thead>
                    <tbody>     ';
            
                        $detail_subs = DB::table('warehouse_treasury_export_small')->where('TREASURY_EXPORT_ID','=',$id)
                        ->leftJoin('supplies_unit_ref','warehouse_treasury_export_small.TREASURY_EXPORT_SMALL_UNIT','=','supplies_unit_ref.ID')
                        ->get();
            
                        $count = 1;
                        foreach ($detail_subs as $detailsub){
                        $output.='  <tr height="20">
                        <td class="text-font" align="center" >'.$count.'</td>
                        <td class="text-font text-pedding" >'.$detailsub->TREASURY_EXPORT_SMALL_NAME.'</td>
                        <td class="text-font" align="center" >'.$detailsub->TREASURY_EXPORT_SMALL_AMOUNT.'</td>
                        <td class="text-font" align="right" >'.number_format($detailsub->TREASURY_EXPORT_SMALL_VALUE,2).' &nbsp;</td>
                        <td class="text-font" align="center" >'.$detailsub->SUP_UNIT_NAME.'</td>
                        
                        </tr>';
            
                        $count++;
                        }

                        $output.=' </tbody>
                        </table><br>';
            
                        echo $output;
            
                }



                

    public function changpasswordsmall()
    {
        $iduser = Auth::user()->SMALL_ID;

        return view('smallhos.setuppassword_small',[
            'iduser' => $iduser
        ]);
    }

    public function updatechangpasswordsmall(Request $request)
    {
        $id = Auth::user()->id;
        $idsmall = Auth::user()->SMALL_ID;

        $changpassword = $request->NEWPASSWORD;

        $updatechangpass= Adduser::where('id', '=',  $id)->first();
        $updatechangpass->password = Hash::make($changpassword);
        $updatechangpass->save();
 
        return redirect()->route('small.dashboard');

    }
   





}


