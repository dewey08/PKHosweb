<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Report\SuppliesReportController;
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

use App\Models\Account;
use App\Models\Accountsub;
use App\Models\Suppliessoldout;
use App\Models\Vehiclecarindex;


use App\Models\Suppliesvendor;
use App\Models\Supplies_MPV;
use App\Models\Plansuppliesyear;
use PDF;


use App\Models\Suppliesrequestsub;

date_default_timezone_set("Asia/Bangkok");

class ManagersuppliesController extends Controller
{
    public function dashboard()
    {
        $m_budget = date("m");
        if((int)$m_budget > 9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;
        }
        
        $year_ = array();
        for ($i = $yearbudget; $i >= $yearbudget - 9; $i--) {
            $year_[$i] = $i;
        }
        $data['year_'] = $year_;

        $data['yearbudget_select'] = $yearbudget;
        $year = $data['yearbudget_select']-543;
        if (isset($_GET['yearbudget_select'])) {
            $data['yearbudget_select'] = $_GET['yearbudget_select'];
        }
        $supreport = new SuppliesReportController();
        $data['suppliesreqAll'] =  $supreport->CountSupreqStatus($data['yearbudget_select'],['Allow','Approve','Cancel','Disallow','Disapprove','Disverify','Disverify','Pending','Verify']); ////ทั้งหมด
        $data['amount_Allow'] = $supreport->CountSupreqStatus($data['yearbudget_select'],['Allow']); //ผอ.อนุมัติ
        $data['amount_Approve'] = $supreport->CountSupreqStatus($data['yearbudget_select'],['Approve']); //เห็นชอบ
        $data['amount_Cancel'] = $supreport->CountSupreqStatus($data['yearbudget_select'],['Cancel']); //ยกเลิก
        $data['amount_Disallow'] = $supreport->CountSupreqStatus($data['yearbudget_select'],['Disallow']); //ไม่อนุมัติ
        $data['amount_Disapprove'] = $supreport->CountSupreqStatus($data['yearbudget_select'],['Disapprove']); //ไม่เห็นชอบ
        $data['amount_Disverify'] = $supreport->CountSupreqStatus($data['yearbudget_select'],['Disverify']); //ตรวจสอบไม่ผ่าน
        $data['amount_Pending'] = $supreport->CountSupreqStatus($data['yearbudget_select'],['Pending']); //รอเห็นชอบ
        $data['amount_Verify'] = $supreport->CountSupreqStatus($data['yearbudget_select'],['Verify']); //ตรวจสอบผ่าน
        $data['perreqstatus'] = array(
            'amount_Allow' => ($data['suppliesreqAll'] != 0)?number_format($data['amount_Allow']/$data['suppliesreqAll']*100,2):'N/A',
            'amount_Approve' => ($data['suppliesreqAll'] != 0)?number_format($data['amount_Approve']/$data['suppliesreqAll']*100,2):'N/A',
            'amount_Cancel' => ($data['suppliesreqAll'] != 0)?number_format($data['amount_Cancel']/$data['suppliesreqAll']*100,2):'N/A',
            'amount_Disallow' => ($data['suppliesreqAll'] != 0)?number_format($data['amount_Disallow']/$data['suppliesreqAll']*100,2):'N/A',
            'amount_Disapprove' => ($data['suppliesreqAll'] != 0)?number_format($data['amount_Disapprove']/$data['suppliesreqAll']*100,2):'N/A',
            'amount_Disverify' => ($data['suppliesreqAll'] != 0)?number_format($data['amount_Disverify']/$data['suppliesreqAll']*100,2):'N/A',
            'amount_Pending' => ($data['suppliesreqAll'] != 0)?number_format($data['amount_Pending']/$data['suppliesreqAll']*100,2):'N/A',
            'amount_Verify' => ($data['suppliesreqAll'] != 0)?number_format($data['amount_Verify']/$data['suppliesreqAll']*100,2):'N/A'
        );
        $data['budget_all'] = $supreport->CountSupconStatus($data['yearbudget_select'] ,[1,2,3,4,5,6,7,8]); //6 ยกเลิก
        $data['budget_regis'] = $supreport->CountSupconStatus($data['yearbudget_select'] ,[1]); //1 ลงทะเบียนคุม
        $data['budget_Offerprice'] = $supreport->CountSupconStatus($data['yearbudget_select'] ,[2]); //2 ใบเสนอราคา
        $data['budget_Makepurchase'] = $supreport->CountSupconStatus($data['yearbudget_select'] ,[3]); //3 ทำรายการขอซื้อ
        $data['budget_CreatePurchaseOrder'] = $supreport->CountSupconStatus($data['yearbudget_select'] ,[4]); //4 จัดทำใบสั่งซื้อ
        $data['budget_Check'] = $supreport->CountSupconStatus($data['yearbudget_select'] ,[5]); //5 ตรวจรับ
        $data['budget_Cancel'] = $supreport->CountSupconStatus($data['yearbudget_select'] ,[6]); //6 ยกเลิกรายการ
        $data['budget_Confirm'] = $supreport->CountSupconStatus($data['yearbudget_select'] ,[7]); //7 ยืนยันตรวจรับ
        $data['budget_Success'] = $supreport->CountSupconStatus($data['yearbudget_select'] ,[8]); //8 ส่งข้อมูลเรียบร้อย
        $data['perconstatus'] = array(
            'budget_regis' => ($data['budget_all'] != 0)?number_format($data['budget_regis']/$data['budget_all']*100,2):'N/A',
            'budget_Offerprice' => ($data['budget_all'] != 0)?number_format($data['budget_Offerprice']/$data['budget_all']*100,2):'N/A',
            'budget_Makepurchase' => ($data['budget_all'] != 0)?number_format($data['budget_Makepurchase']/$data['budget_all']*100,2):'N/A',
            'budget_CreatePurchaseOrder' => ($data['budget_all'] != 0)?number_format($data['budget_CreatePurchaseOrder']/$data['budget_all']*100,2):'N/A',
            'budget_Check' => ($data['budget_all'] != 0)?number_format($data['budget_Check']/$data['budget_all']*100,2):'N/A',
            'budget_Cancel' => ($data['budget_all'] != 0)?number_format($data['budget_Cancel']/$data['budget_all']*100,2):'N/A',
            'budget_Confirm' => ($data['budget_all'] != 0)?number_format($data['budget_Confirm']/$data['budget_all']*100,2):'N/A',
            'budget_Success' => ($data['budget_all'] != 0)?number_format($data['budget_Success']/$data['budget_all']*100,2):'N/A'
        );
        
        $data['amount_con_M'] = $supreport->CountSupcon_M($year); //ข้อมูลแยกรายเดือน
        $data['amount_conbudget_M'] = $supreport->CountSupcon_M_budget($year); //ข้อมูลแยกรายเดือน
        $data['budgetplanType1'] = $supreport->GetSupcon_budgetplan($year,1); //วัสดุ
        $data['budgetplanType2'] = $supreport->GetSupcon_budgetplan($year,2); //ครุภัณฑ์
        $data['budgetplanType3'] = $supreport->GetSupcon_budgetplan($year,3); //จ้างเหมา
        $data['budgetplanType4'] = $supreport->GetSupcon_budgetplan($year,4); //ที่ดิน
        $data['budgetplanType5'] = $supreport->GetSupcon_budgetplan($year,5); //สิ่งปลูกสร้าง
        $data['budgetplanType6'] = $supreport->GetSupcon_budgetplan($year,6); //อาหารสด
        return view('manager_supplies.dashboard',$data);
    }

    public function suppliesinfo(Request $request,$typedetail)
    {
        if($typedetail == 'parcel'){
            $detail = '1';
            if(!empty($request->_token)){
                $search = $request->get('search');
                $typekind = $request->SEND_TYPEKIND;
                $type = $request->SEND_TYPE;
                $typedetail = $request->typedetail;
                session([
                    'manager_supplies.suppliesinfo.parcel.search' => $search,
                    'manager_supplies.suppliesinfo.parcel.typekind' => $typekind,
                    'manager_supplies.suppliesinfo.parcel.type' => $type,
                    'manager_supplies.suppliesinfo.parcel.typedetail' => $typedetail,
                    ]);
            }elseif(!empty(session('manager_supplies.suppliesinfo.parcel'))){
                $search     = session('manager_supplies.suppliesinfo.parcel.search');
                $typekind     = session('manager_supplies.suppliesinfo.parcel.typekind');
                $type  = session('manager_supplies.suppliesinfo.parcel.type');
                $typedetail    = session('manager_supplies.suppliesinfo.parcel.typedetail');
            }else{
                $search     = '';
                $typekind     = '';
                $type  = '';
                $typedetail    = 'parcel';
            }
        }elseif($typedetail == 'article'){
            $detail = '2';  
            if(!empty($request->_token)){
                $search = $request->get('search');
                $typekind = $request->SEND_TYPEKIND;
                $type = $request->SEND_TYPE;
                $typedetail = $request->typedetail;
                session([
                    'manager_supplies.suppliesinfo.article.search' => $search,
                    'manager_supplies.suppliesinfo.article.typekind' => $typekind,
                    'manager_supplies.suppliesinfo.article.type' => $type,
                    'manager_supplies.suppliesinfo.article.typedetail' => $typedetail,
                    ]);
            }elseif(!empty(session('manager_supplies.suppliesinfo.article'))){
                $search     = session('manager_supplies.suppliesinfo.article.search');
                $typekind     = session('manager_supplies.suppliesinfo.article.typekind');
                $type  = session('manager_supplies.suppliesinfo.article.type');
                $typedetail    = session('manager_supplies.suppliesinfo.article.typedetail');
            }else{
                $search     = '';
                $typekind     = '';
                $type  = '';
                $typedetail    = 'article';
            }
        }elseif($typedetail == 'service'){
            $detail = '3';   
            if(!empty($request->_token)){
                $search = $request->get('search');
                $typekind = $request->SEND_TYPEKIND;
                $type = $request->SEND_TYPE;
                $typedetail = $request->typedetail;
                session([
                    'manager_supplies.suppliesinfo.service.search' => $search,
                    'manager_supplies.suppliesinfo.service.typekind' => $typekind,
                    'manager_supplies.suppliesinfo.service.type' => $type,
                    'manager_supplies.suppliesinfo.service.typedetail' => $typedetail,
                    ]);
            }elseif(!empty(session('manager_supplies.suppliesinfo.service'))){
                $search     = session('manager_supplies.suppliesinfo.service.search');
                $typekind     = session('manager_supplies.suppliesinfo.service.typekind');
                $type  = session('manager_supplies.suppliesinfo.service.type');
                $typedetail    = session('manager_supplies.suppliesinfo.service.typedetail');
            }else{
                $search     = '';
                $typekind     = '';
                $type  = '';
                $typedetail    = 'service';
            }
        }elseif($typedetail == 'building'){
            $detail = '5';            
            if(!empty($request->_token)){
                $search = $request->get('search');
                $typekind = $request->SEND_TYPEKIND;
                $type = $request->SEND_TYPE;
                $typedetail = $request->typedetail;
                session([
                    'manager_supplies.suppliesinfo.building.search' => $search,
                    'manager_supplies.suppliesinfo.building.typekind' => $typekind,
                    'manager_supplies.suppliesinfo.building.type' => $type,
                    'manager_supplies.suppliesinfo.building.typedetail' => $typedetail,
                    ]);
            }elseif(!empty(session('manager_supplies.suppliesinfo.building'))){
                $search     = session('manager_supplies.suppliesinfo.building.search');
                $typekind     = session('manager_supplies.suppliesinfo.building.typekind');
                $type  = session('manager_supplies.suppliesinfo.building.type');
                $typedetail    = session('manager_supplies.suppliesinfo.building.typedetail');
            }else{
                $search     = '';
                $typekind     = '';
                $type  = '';
                $typedetail    = 'building';
            }
        }else{
            return redirect()->back();
        }

        if($typekind == null || $typekind == ''){
            if($type == null || $type == ''){
                $infosupplies= Supplies::select('supplies.ID','supplies.ACTIVE','SUP_FSN_NUM','SUP_NAME','SUP_TYPE_KIND_NAME','SUP_TYPE_NAME','SUP_PROP','TPU_NUMBER','CONTINUE_PRICE_NAME')
                ->leftJoin('supplies_type','supplies.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
                ->leftJoin('supplies_continue','supplies.CONTINUE_PRICE_ID','=','supplies_continue.CONTINUE_PRICE_ID')
                ->leftJoin('supplies_type_kind','supplies.SUP_TYPE_KIND_ID','=','supplies_type_kind.SUP_TYPE_KIND_ID')
                                ->where('supplies_type_kind.SUP_TYPE_MASTER_ID','=',$detail)
                                ->where(function($q) use ($search){
                                    $q->where('SUP_FSN_NUM','like','%'.$search.'%');
                                    $q->orwhere('SUP_NAME','like','%'.$search.'%');  
                                    $q->orwhere('CONTINUE_PRICE_NAME','like','%'.$search.'%'); 
                                })
                                ->orderBy('ID', 'desc') 
                                ->paginate(12);
            }else{
                $infosupplies=  Supplies::select('supplies.ID','supplies.ACTIVE','SUP_FSN_NUM','SUP_NAME','SUP_TYPE_KIND_NAME','SUP_TYPE_NAME','SUP_PROP','TPU_NUMBER','CONTINUE_PRICE_NAME')
                ->leftJoin('supplies_type','supplies.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
                ->leftJoin('supplies_continue','supplies.CONTINUE_PRICE_ID','=','supplies_continue.CONTINUE_PRICE_ID')
                ->leftJoin('supplies_type_kind','supplies.SUP_TYPE_KIND_ID','=','supplies_type_kind.SUP_TYPE_KIND_ID')
                ->where('supplies.SUP_TYPE_ID','=',$type)
                ->where('supplies_type_kind.SUP_TYPE_MASTER_ID','=',$detail)
                ->where(function($q) use ($search){
                    $q->where('SUP_FSN_NUM','like','%'.$search.'%');
                    $q->orwhere('SUP_NAME','like','%'.$search.'%');
                    $q->orwhere('CONTINUE_PRICE_NAME','like','%'.$search.'%');   
                })
                ->orderBy('ID', 'desc') 
                ->paginate(12);
            }
         }else{
            if($type == null || $type == ''){
                $infosupplies=  Supplies::select('supplies.ID','supplies.ACTIVE','SUP_FSN_NUM','SUP_NAME','SUP_TYPE_KIND_NAME','SUP_TYPE_NAME','SUP_PROP','TPU_NUMBER','CONTINUE_PRICE_NAME')
                ->leftJoin('supplies_type','supplies.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
                ->leftJoin('supplies_continue','supplies.CONTINUE_PRICE_ID','=','supplies_continue.CONTINUE_PRICE_ID')
                ->leftJoin('supplies_type_kind','supplies.SUP_TYPE_KIND_ID','=','supplies_type_kind.SUP_TYPE_KIND_ID')
                                ->where('supplies.SUP_TYPE_KIND_ID','=',$typekind)
                                ->where('supplies_type_kind.SUP_TYPE_MASTER_ID','=',$detail)
                                
                                ->where(function($q) use ($search){
                                    $q->where('SUP_FSN_NUM','like','%'.$search.'%');
                                    $q->orwhere('SUP_NAME','like','%'.$search.'%'); 
                                    $q->orwhere('CONTINUE_PRICE_NAME','like','%'.$search.'%');  
                                })
                                ->orderBy('ID', 'desc') 
                                ->paginate(12);
            }else{
                $infosupplies=  Supplies::select('supplies.ID','supplies.ACTIVE','SUP_FSN_NUM','SUP_NAME','SUP_TYPE_KIND_NAME','SUP_TYPE_NAME','SUP_PROP','TPU_NUMBER','CONTINUE_PRICE_NAME')
                ->leftJoin('supplies_type','supplies.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
                ->leftJoin('supplies_continue','supplies.CONTINUE_PRICE_ID','=','supplies_continue.CONTINUE_PRICE_ID')
                ->leftJoin('supplies_type_kind','supplies.SUP_TYPE_KIND_ID','=','supplies_type_kind.SUP_TYPE_KIND_ID')
                ->where('supplies.SUP_TYPE_ID','=',$type)
                ->where('supplies.SUP_TYPE_KIND_ID','=',$typekind)
                ->where('supplies_type_kind.SUP_TYPE_MASTER_ID','=',$detail)
                
                ->where(function($q) use ($search){
                    $q->where('SUP_FSN_NUM','like','%'.$search.'%');
                    $q->orwhere('SUP_NAME','like','%'.$search.'%');  
                    $q->orwhere('CONTINUE_PRICE_NAME','like','%'.$search.'%'); 
                })
                ->orderBy('ID', 'desc') 
                ->paginate(12);
            }
        }
        $suppliestype = DB::table('supplies_type')->where('SUP_TYPE_MASTER_ID','=',$detail)->get();
        $suppliestypekind = DB::table('supplies_type_kind')->where('SUP_TYPE_MASTER_ID','=',$detail)->get();
        $typekind_check = $typekind;
        $type_check = $type;
        return view('manager_supplies.suppliesinfo',[
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

                $infosupplies= Supplies::select('supplies.ID','supplies.ACTIVE','SUP_FSN_NUM','SUP_NAME','SUP_TYPE_KIND_NAME','SUP_TYPE_NAME','SUP_PROP','TPU_NUMBER','CONTINUE_PRICE_NAME')
                ->leftJoin('supplies_type','supplies.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
                ->leftJoin('supplies_continue','supplies.CONTINUE_PRICE_ID','=','supplies_continue.CONTINUE_PRICE_ID')
                ->leftJoin('supplies_type_kind','supplies.SUP_TYPE_KIND_ID','=','supplies_type_kind.SUP_TYPE_KIND_ID')
                                ->where('supplies_type_kind.SUP_TYPE_MASTER_ID','=',$detail)
                                
                                ->where(function($q) use ($search){
                                    $q->where('SUP_FSN_NUM','like','%'.$search.'%');
                                    $q->orwhere('SUP_NAME','like','%'.$search.'%');  
                                    $q->orwhere('CONTINUE_PRICE_NAME','like','%'.$search.'%'); 
                                })
                                ->orderBy('ID', 'desc') 
                                ->paginate(12);

            }else{

                $infosupplies=  Supplies::select('supplies.ID','supplies.ACTIVE','SUP_FSN_NUM','SUP_NAME','SUP_TYPE_KIND_NAME','SUP_TYPE_NAME','SUP_PROP','TPU_NUMBER','CONTINUE_PRICE_NAME')
                ->leftJoin('supplies_type','supplies.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
                ->leftJoin('supplies_continue','supplies.CONTINUE_PRICE_ID','=','supplies_continue.CONTINUE_PRICE_ID')
                ->leftJoin('supplies_type_kind','supplies.SUP_TYPE_KIND_ID','=','supplies_type_kind.SUP_TYPE_KIND_ID')
                ->where('supplies.SUP_TYPE_ID','=',$type)
                ->where('supplies_type_kind.SUP_TYPE_MASTER_ID','=',$detail)
                
                ->where(function($q) use ($search){
                    $q->where('SUP_FSN_NUM','like','%'.$search.'%');
                    $q->orwhere('SUP_NAME','like','%'.$search.'%');
                    $q->orwhere('CONTINUE_PRICE_NAME','like','%'.$search.'%');   
                })
                ->orderBy('ID', 'desc') 
                ->paginate(12);
          
                

            }
    

         }else{

         
            
        
            if($type == null || $type == ''){

                $infosupplies=  Supplies::select('supplies.ID','supplies.ACTIVE','SUP_FSN_NUM','SUP_NAME','SUP_TYPE_KIND_NAME','SUP_TYPE_NAME','SUP_PROP','TPU_NUMBER','CONTINUE_PRICE_NAME')
                ->leftJoin('supplies_type','supplies.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
                ->leftJoin('supplies_continue','supplies.CONTINUE_PRICE_ID','=','supplies_continue.CONTINUE_PRICE_ID')
                ->leftJoin('supplies_type_kind','supplies.SUP_TYPE_KIND_ID','=','supplies_type_kind.SUP_TYPE_KIND_ID')
                                ->where('supplies.SUP_TYPE_KIND_ID','=',$typekind)
                                ->where('supplies_type_kind.SUP_TYPE_MASTER_ID','=',$detail)
                                
                                ->where(function($q) use ($search){
                                    $q->where('SUP_FSN_NUM','like','%'.$search.'%');
                                    $q->orwhere('SUP_NAME','like','%'.$search.'%'); 
                                    $q->orwhere('CONTINUE_PRICE_NAME','like','%'.$search.'%');  
                                })
                                ->orderBy('ID', 'desc') 
                                ->paginate(12);

            }else{

                $infosupplies=  Supplies::select('supplies.ID','supplies.ACTIVE','SUP_FSN_NUM','SUP_NAME','SUP_TYPE_KIND_NAME','SUP_TYPE_NAME','SUP_PROP','TPU_NUMBER','CONTINUE_PRICE_NAME')
                ->leftJoin('supplies_type','supplies.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
                ->leftJoin('supplies_continue','supplies.CONTINUE_PRICE_ID','=','supplies_continue.CONTINUE_PRICE_ID')
                ->leftJoin('supplies_type_kind','supplies.SUP_TYPE_KIND_ID','=','supplies_type_kind.SUP_TYPE_KIND_ID')
                ->where('supplies.SUP_TYPE_ID','=',$type)
                ->where('supplies.SUP_TYPE_KIND_ID','=',$typekind)
                ->where('supplies_type_kind.SUP_TYPE_MASTER_ID','=',$detail)
                
                ->where(function($q) use ($search){
                    $q->where('SUP_FSN_NUM','like','%'.$search.'%');
                    $q->orwhere('SUP_NAME','like','%'.$search.'%');  
                    $q->orwhere('CONTINUE_PRICE_NAME','like','%'.$search.'%'); 
                })
                ->orderBy('ID', 'desc') 
                ->paginate(12);
                
                

            }
        
        }


        $suppliestype = DB::table('supplies_type')->where('SUP_TYPE_MASTER_ID','=',$detail)->get();
        $suppliestypekind = DB::table('supplies_type_kind')->where('SUP_TYPE_MASTER_ID','=',$detail)->get();

       
        $typekind_check = $typekind;
        $type_check = $type;
       


        return view('manager_supplies.suppliesinfo',[
            'infosuppliess' => $infosupplies,
            'suppliestypes' => $suppliestype,
            'suppliestypekinds' => $suppliestypekind,
            'typekind_check' => $typekind_check,
            'type_check' => $type_check,
            'search' => $search,
            'typedetail' => $typedetail,
        ]);
    }




    function switchactivesup(Request $request)
    {  
        $id = $request->id;
        $active = Supplies::find($id);
        $active->ACTIVE = $request->onoff;
        $active->save();
    }


    function checkfsn(Request $request)
    {
       
      $idfsn= $request->get('select');
      $count= DB::table('supplies')
            ->where('SUP_FSN_NUM','=',$idfsn) 
            ->count();

            echo $count;
                  
    }
    
    public function createsuppliesinfo(Request $request,$typedetail)
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

        $suppliesprop = DB::table('supplies_prop')->get();

        $suppliesunit = DB::table('supplies_unit')->get();

        $suppliesvendor = DB::table('supplies_vendor')->get();

        return view('manager_supplies.suppliesinfo_add',[
            'suppliestypekinds' => $suppliestypekind,
            'suppliestypes' => $suppliestype,
            'suppliestypemasters' => $suppliestypemaster,
            'typedetail' => $typedetail,
            'suppliesprops' => $suppliesprop,
            'suppliesunits' => $suppliesunit,
            'suppliesvendor' => $suppliesvendor,
        ]);    
    }

   











    public function savesuppliesinfo(Request $request) 
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
        $addinfosup->TPU_NUMBER = $request->TPU_NUMBER;
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

    

        return redirect()->route('msupplies.suppliesinfo',[
            'typedetail' => $typedetail,
        ]);

      

    }
//=================================================

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

        $infosupplie = DB::table('supplies')
                       ->leftJoin('supplies_type','supplies_type.SUP_TYPE_ID','=','supplies.SUP_TYPE_ID')
                       ->where('ID','=',$id)->first();

        $suppliesprop = DB::table('supplies_prop')->get();

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

        $checkcodeinstore = DB::table('warehouse_store')->where('STORE_CODE','=',$infosupplie->SUP_FSN_NUM)->count();

        return view('manager_supplies.suppliesinfo_edit',[
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
            'checkcodeinstore' => $checkcodeinstore,
        ]);
    
    }

    public function updatesuppliesinfo(Request $request)
    {
        $typedetail = $request->typedetail;


        $id = $request->ID;

        $count= DB::table('supplies')
        ->where('supplies.SUP_FSN_NUM',$request->SUP_FSN_NUM) 
        ->count();

      

        $addinfosup = Supplies::find($id);
      
        $addinfosup->SUP_FSN_NUM = $request->SUP_FSN_NUM;
        $addinfosup->SUP_TYPE_KIND_ID = $request->SUP_TYPE_KIND_ID;
        $addinfosup->SUP_NAME = $request->SUP_NAME;
        $addinfosup->CONTINUE_PRICE_ID = $request->CONTINUE_PRICE_ID;
        $addinfosup->SUP_PROP = $request->SUP_PROP;
        $addinfosup->SUP_TYPE_ID = $request->SUP_TYPE_ID;
        $addinfosup->SUP_TYPE_MASTER_ID = $request->SUP_TYPE_MASTER_ID;
        $addinfosup->CONTENT = $request->CONTENT;
        $addinfosup->TPU_NUMBER = $request->TPU_NUMBER;
        $addinfosup->MIN = $request->MIN;
        $addinfosup->MAX = $request->MAX;

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

    

        $checkcodeinstore = DB::table('warehouse_store')->where('STORE_CODE','=',$request->SUP_FSN_NUM)->count();

        if($checkcodeinstore > 0){
            DB::table('warehouse_store')
            ->where('STORE_CODE',$request->SUP_FSN_NUM)
            ->update(['STORE_NAME' => $request->SUP_NAME]);
        }

        return redirect()->route('msupplies.suppliesinfo',[
            'typedetail' => $typedetail,
        ]);

    }


    //============================ลบสิ่งของ=====

    public function destroysuppliesinfo($typedetail,$id) { 
                
        Supplies::destroy($id); 
        Suppliesunitref::where('SUP_ID','=',$id)->delete(); 
   
        return redirect()->route('msupplies.suppliesinfo',[
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

//=====แก้ไขครุภัณฑ์

function editsuppliesinfoinasset(Request $request,$id,$asstid)
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

    //==============================================
    $infoassetarticle = DB::table('asset_article')->where('ARTICLE_ID','=',$asstid)->first();
   

    return view('manager_supplies.editsuppliesinfoinasset',[
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
        'infoassetarticle' => $infoassetarticle,
         
      
       
    ]);

}



public function updateinfosuppliesinfoinasset(Request $request)
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

 
    $ARTICLE_ID= $request->ARTICLE_ID;

    $addinfoarticle = Assetarticle::find($ARTICLE_ID);
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
  
    $addinfoarticle->SUP_FSN = $request->SUP_FSN;

    if($request->hasFile('picture')){
        
        $file = $request->file('picture');  
        $contents = $file->openFile()->fread($file->getSize());
        $addinfoarticle->IMG = $contents;   
      
    }

   

    $addinfoarticle->save();



    


    $id =   $ARTICLE_ID;

    Assetdepreciate::where('DEP_ASSET_ID','=',$id)->delete();
    $infoasset= Assetarticle::where('asset_article.ARTICLE_ID','=',$id)
    ->leftJoin('supplies_decline','supplies_decline.DECLINE_ID','=','asset_article.DECLINE_ID')
    ->leftJoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','asset_article.DEP_ID')
    ->leftJoin('supplies_location','supplies_location.LOCATION_ID','=','asset_article.LOCATION_ID')
    ->leftJoin('supplies_location_level','supplies_location_level.LOCATION_LEVEL_ID','=','asset_article.LOCATION_LEVEL_ID')
    ->leftJoin('supplies_location_level_room','supplies_location_level_room.LEVEL_ROOM_ID','=','asset_article.LEVEL_ROOM_ID')
    ->first();




    $depreciation= DB::table('supplies_decline')->where('supplies_decline.DECLINE_ID','=',$infoasset->DECLINE_ID)->first();


    $start = $month = strtotime($infoasset->RECEIVE_DATE. ' + 1 month');

    $yearend = date("Y",strtotime($infoasset->RECEIVE_DATE))+60;

    $dateend = $yearend.'-01-01';

    $end = strtotime($dateend);

//=========================

                                           //--------------------------------สูตรคำนวน-----------------------------------------------
                                                        $PICE = $infoasset->PRICE_PER_UNIT;
                                                        $per_year = $depreciation->DECLINE_PERSEN;
                                                        $Depreciation_mont =  ($PICE*($per_year/100))/12;

                                                        $checkdep  =  Assetdepreciate::where('DEP_ASSET_ID','=',$id)->count();
                                                        //-------------------------คำนวณเดือนแรก----------------------------



                                                        $fristYear= date("Y",strtotime($infoasset->RECEIVE_DATE))+543;
                                                        $fristMonth= date("m",strtotime($infoasset->RECEIVE_DATE));
                                                        $fristdate= date("d",strtotime($infoasset->RECEIVE_DATE));

                                                    
                                                        if($fristMonth == '04' || $fristMonth == '06' || $fristMonth == '09' || $fristMonth == '11'){
                                                            $d = 30;
                                                        }elseif($fristMonth == '02'){
                                                            if(($fristYear-543)%4 == 0){
                                                                $d = 29;
                                                            }else{
                                                                $d = 28;
                                                            }
                                                           
                                                        }else{
                                                            $d = 31;
                                                        }

                                                        $amountdate =  $d - $fristdate;
                                                        $Depdate = $Depreciation_mont/$d;

                                                    $fristDepreciation_mont = $amountdate * $Depdate;

                                                    $fristDepreciation = $PICE - $fristDepreciation_mont;



                                                                    //-------------เพิ่มข้อมูลในตาราง----------------------------
                                                    if($checkdep == 0 ){
                                                        $adddepreciate= new Assetdepreciate();
                                                        $adddepreciate->DEP_ASSET_ID = $id;
                                                        $adddepreciate->DEP_YEAR = $fristYear;
                                                        $adddepreciate->DEP_MONTH = number_format($fristMonth);
                                                        $adddepreciate->DEP_PRICE = $PICE;
                                                        $adddepreciate->DEP_FORWARD = 0;
                                                        $adddepreciate->DEP_DEPRECIATE = $fristDepreciation_mont;
                                                        $adddepreciate->DEP_CUMULATIVE = $fristDepreciation_mont;
                                                        $adddepreciate->DEP_VALUE = $fristDepreciation;
                                                        $adddepreciate->save();

                                                     }               //------------------------------------------


                                                        //----------------------------------------------------

                                                        $Depreciation_move = $fristDepreciation_mont;
                                                        $Depreciation = $Depreciation_mont + $Depreciation_move;

                                                                while($month < $end)
                                                    {


                                                        $year = date('Y', $month)+543;


                                                        $value_last = ($PICE -$Depreciation_move)-1 ; //-----ตัวตัดค่าเสื่อมตัวสุดท้าย

                                                        $value = $PICE - $Depreciation;

                                                        if($value <=0){
                                                            $Depreciation_mont = $value_last;
                                                            $Depreciation = $Depreciation_move+$Depreciation_mont;
                                                            $value = 1;

                                                        }



                                                        //-------------เพิ่มข้อมูลในตาราง----------------------------
                                                        if($checkdep == 0 ){
                                                            $adddepreciate = new Assetdepreciate();
                                                            $adddepreciate->DEP_ASSET_ID = $id;
                                                            $adddepreciate->DEP_YEAR = $year;
                                                            $adddepreciate->DEP_MONTH = number_format(date('m', $month));
                                                            $adddepreciate->DEP_PRICE = $PICE;
                                                            $adddepreciate->DEP_FORWARD = $Depreciation_move;
                                                            $adddepreciate->DEP_DEPRECIATE = $Depreciation_mont;
                                                            $adddepreciate->DEP_CUMULATIVE = $Depreciation;
                                                            $adddepreciate->DEP_VALUE = $value;
                                                            $adddepreciate->save();
                                                            }
                                                            //------------------------------------------

                                                        if($value ==1){
                                                        break;
                                                        }
                                                        $Depreciation = $Depreciation_mont + $Depreciation;

                                                        $Depreciation_move = $Depreciation - $Depreciation_mont;



                                                        $month = strtotime("+1 month", $month);



                                                    }


    return redirect()->route('msupplies.suppliesinfoinasset',[
        'id' => $request->ID,
    ]);
}

//=====ลบครุภัณฑ์

public function destroysuppliesinfoinasset($id,$asstid) { 
                
    Assetarticle::destroy($asstid); 


    return redirect()->route('msupplies.suppliesinfoinasset',[
        'id' => $id,
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
            if(!empty($request->_token)){
                $search = $request->get('search');
                $status = $request->SEND_STATUS;
                $datebigin = $request->get('DATE_BIGIN');
                $dateend = $request->get('DATE_END');
                $yearbudget = $request->YEAR_ID;
                session([
                    'manager_supplies.requestforbuy.search' => $search,
                    'manager_supplies.requestforbuy.status' => $status,
                    'manager_supplies.requestforbuy.datebigin' => $datebigin,
                    'manager_supplies.requestforbuy.dateend' => $dateend,
                    'manager_supplies.requestforbuy.yearbudget' => $yearbudget
                    ]);
            }elseif(!empty(session('manager_supplies.requestforbuy'))){
                $search     = session('manager_supplies.requestforbuy.search');
                $status     = session('manager_supplies.requestforbuy.status');
                $datebigin  = session('manager_supplies.requestforbuy.datebigin');
                $dateend    = session('manager_supplies.requestforbuy.dateend');
                $yearbudget = session('manager_supplies.requestforbuy.yearbudget');
            }else{
                $search     = '';
                $status     = '';
                $datebigin = date('1/m/Y');
                $dateend   = date('d/m/Y', strtotime(date('Y-m-1'). '+1month -1days'));
                $yearbudget = getBudgetyear();
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
                ->where(function($q) use ($search){
                     $q->where('REQUEST_FOR','like','%'.$search.'%');
                     $q->orwhere('REQUEST_BUY_COMMENT','like','%'.$search.'%');
                     $q->orwhere('SAVE_HR_DEP_SUB_NAME','like','%'.$search.'%');
                     $q->orwhere('REQUEST_ID','like','%'.$search.'%');
                     $q->orwhere('REQUEST_VANDOR_NAME','like','%'.$search.'%');
                     $q->orwhere('SAVE_HR_NAME','like','%'.$search.'%');
                })
                    ->WhereBetween('DATE_WANT',[$from,$to])
                ->orderBy('supplies_request.ID', 'desc')
                ->get();

                $sumbudget  = Suppliesrequest::leftJoin('supplies_request_status','supplies_request_status.STATUS_CODE','=','supplies_request.STATUS')
                ->where('BUDGET_YEAR','=', $yearbudget)
                ->where(function($q) use ($search){
                     $q->where('REQUEST_FOR','like','%'.$search.'%');
                     $q->orwhere('REQUEST_BUY_COMMENT','like','%'.$search.'%');
                     $q->orwhere('SAVE_HR_DEP_SUB_NAME','like','%'.$search.'%');
                     $q->orwhere('REQUEST_ID','like','%'.$search.'%');
                     $q->orwhere('REQUEST_VANDOR_NAME','like','%'.$search.'%');
                     $q->orwhere('SAVE_HR_NAME','like','%'.$search.'%');
                })
                    ->WhereBetween('DATE_WANT',[$from,$to])
                ->sum('BUDGET_SUM');

            }else{

                $inforequest = Suppliesrequest::leftJoin('supplies_request_status','supplies_request_status.STATUS_CODE','=','supplies_request.STATUS')
                ->where('STATUS_CODE','=',$status)
                ->where('BUDGET_YEAR','=', $yearbudget)
                ->where(function($q) use ($search){
                     $q->where('REQUEST_FOR','like','%'.$search.'%');
                     $q->orwhere('REQUEST_BUY_COMMENT','like','%'.$search.'%');
                     $q->orwhere('SAVE_HR_DEP_SUB_NAME','like','%'.$search.'%');
                     $q->orwhere('REQUEST_ID','like','%'.$search.'%');
                     $q->orwhere('REQUEST_VANDOR_NAME','like','%'.$search.'%');
                     $q->orwhere('SAVE_HR_NAME','like','%'.$search.'%');
                })
                    ->WhereBetween('DATE_WANT',[$from,$to])
                ->orderBy('supplies_request.ID', 'desc')
                ->get();


                $sumbudget  =Suppliesrequest::leftJoin('supplies_request_status','supplies_request_status.STATUS_CODE','=','supplies_request.STATUS')
                ->where('STATUS_CODE','=',$status)
                ->where('BUDGET_YEAR','=', $yearbudget)
                ->where(function($q) use ($search){
                     $q->where('REQUEST_FOR','like','%'.$search.'%');
                     $q->orwhere('REQUEST_BUY_COMMENT','like','%'.$search.'%');
                     $q->orwhere('SAVE_HR_DEP_SUB_NAME','like','%'.$search.'%');
                     $q->orwhere('REQUEST_ID','like','%'.$search.'%');
                     $q->orwhere('REQUEST_VANDOR_NAME','like','%'.$search.'%');
                     $q->orwhere('SAVE_HR_NAME','like','%'.$search.'%');
                })
                ->WhereBetween('DATE_WANT',[$from,$to])
                ->sum('BUDGET_SUM');

            }
        
        $info_sendstatus = DB::table('supplies_request_status')->get();

        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $year_id = $yearbudget;

        return view('manager_supplies.requestforbuy',[
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
       if($request->status){
            $search = session('requestforbuysearch.search');
            $status = session('requestforbuysearch.status_id');
            $yearbudget = session('requestforbuysearch.yearbudget');
            $datebigin = session('requestforbuysearch.datebigin');
            $dateend = session('requestforbuysearch.dateend');
       }else{
        $search = $request->get('search');
            $status = $request->SEND_STATUS;
            $yearbudget = $request->YEAR_ID;
            $datebigin = $request->get('DATE_BIGIN');
            $dateend = $request->get('DATE_END');
            session([
                'requestforbuysearch.status' => true,
                'requestforbuysearch.search' => $search,
                'requestforbuysearch.status_id' => $status,
                'requestforbuysearch.yearbudget' => $yearbudget,
                'requestforbuysearch.datebigin' => $datebigin,
                'requestforbuysearch.dateend' => $dateend
            ]);
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

        return view('manager_supplies.requestforbuy',[
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

    public function requestforbuy_excel(Request $request,$datebigin,$dateend,$status,$search)
    {
       
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

             
                $inforequest = Suppliesrequest::leftJoin('supplies_request_status','supplies_request_status.STATUS_CODE','=','supplies_request.STATUS')

    
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
     

        return view('manager_supplies.requestforbuy_excel',[
            'budgets' =>  $budget,
            'inforequests' => $inforequest,
            'info_sendstatuss' => $info_sendstatus,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'sumbudget'=>$sumbudget,

        ]);

    }
//============================== end =====================//


    public function createrequestforbuy(Request $request)
    {

    
        return view('manager_supplies.requestforbuy_add');
        
    }
    

       
public function updateinforequestver(Request $request)
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
      
  
          return redirect()->route('msupplies.requestforbuy');

}

//--------------------------รายละเอียดแก้ไข-----

public function requestforbuyedit(Request $request,$id)
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

          
        return view('manager_supplies.requestforbuyedit',[
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

    public function requestforbuyupdate(Request $request)
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
                   $SUPPLIES_REQUEST_SUB_REMARK = $request->SUPPLIES_REQUEST_SUB_REMARK;
   
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




            return redirect()->route('msupplies.requestforbuy');
    }




//--------------------------แจ้งยกเลิก-----


public function cancelrequestforbuy (Request $request,$id)
{
    
    $inforequest =  DB::table('supplies_request')
    ->where('ID','=',$id)->first();

    $inforequestsub =  DB::table('supplies_request_sub')
    ->where('SUPPLIES_REQUEST_ID','=',$id)->get();

    $infohr = DB::table('hrd_person')->where('ID','=',$inforequest->SAVE_HR_ID)->first();

    return view('manager_supplies.requestforbuycancel',[
        'inforequest' => $inforequest,
      'inforequestsubs' => $inforequestsub,
      'infohr' => $infohr
        
     
    ]);

}

public function cancelrequestforbuyupdate(Request $request)
{
    $id = $request->ID; 
    $iduser = $request->iduser;

    $updateapp = Suppliesrequest::find($id);
    $updateapp->STATUS = 'cancel'; 
    $updateapp->save();

   
      return redirect()->route('msupplies.requestforbuy');

}

    //==========================================จีดซื้อจัดจ้าง======

    public function purchase(Request $request)
    {      
            if(!empty($request->_token)){
                $search = $request->get('search');
                $status = $request->SEND_STATUS;
                $dateselect = $request->DATE_SELECT;
                $datebigin = $request->get('DATE_BIGIN');
                $dateend = $request->get('DATE_END');
                $yearbudget = $request->BUDGET_YEAR;
                session([
                    'manager_asset.assetinfobuilding.search' => $search,
                    'manager_asset.assetinfobuilding.status' => $status,
                'manager_asset.assetinfobuilding.dateselect' => $dateselect,
                'manager_asset.assetinfobuilding.datebigin' => $datebigin,
                    'manager_asset.assetinfobuilding.dateend' => $dateend,
                    'manager_asset.assetinfobuilding.yearbudget' => $yearbudget
                    ]);
            }elseif(!empty(session('manager_asset.assetinfobuilding'))){
                $search     = session('manager_asset.assetinfobuilding.search');
                $status     = session('manager_asset.assetinfobuilding.status');
                $dateselect  = session('manager_asset.assetinfobuilding.dateselect');
                $datebigin  = session('manager_asset.assetinfobuilding.datebigin');
                $dateend    = session('manager_asset.assetinfobuilding.dateend');
                $yearbudget = session('manager_asset.assetinfobuilding.yearbudget');
            }else{
                $search     = '';
                $status     = '';
                $dateselect  = 'd1';
                $datebigin = date('1/m/Y');
                $dateend   = date('d/m/Y', strtotime(date('Y-m-1'). '+1month -1days'));
                $yearbudget = getBudgetyear();
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
        $infosupcon = Suppliescon::select('supplies_con.ID','CON_YEAR_ID','CON_NUM','supplies_request.REQUEST_ID','REGIS_STATUS_NAME','DATE_REGIS','EGP_PLAN_NAME','SUP_TYPE_NAME','VENDOR_NAME','supplies_con.BUDGET_SUM','CHECK_DATE','supplies_status_regis.REGIS_STATUS_ID','supplies_buy.BUY_NAME','supplies_budget.BUDGET_NAME')
        ->leftJoin('supplies_status_regis','supplies_con.REGIS_STATUS_ID','=','supplies_status_regis.REGIS_STATUS_ID')
        ->leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
        ->leftJoin('supplies_request','supplies_con.REQUEST_ID','=','supplies_request.ID')
        ->leftJoin('supplies_buy','supplies_con.BUY_ID','=','supplies_buy.BUY_ID')
        ->leftJoin('supplies_budget','supplies_con.BUDGET_ID','=','supplies_budget.BUDGET_ID')
        ->where('supplies_con.CON_YEAR_ID','=',$yearbudget)
        ->where(function($q) use ($search){
            $q->where('EGP_PLAN_NAME','like','%'.$search.'%');
            $q->orwhere('VENDOR_NAME','like','%'.$search.'%');
            $q->orwhere('CON_NUM','like','%'.$search.'%'); 
            $q->orwhere('supplies_con.BUDGET_SUM','like','%'.$search.'%');  
            $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');    
            $q->orwhere('supplies_request.REQUEST_ID','like','%'.$search.'%'); 
            $q->orwhere('BUDGET_NAME','like','%'.$search.'%'); 
            $q->orwhere('BUY_NAME','like','%'.$search.'%'); 
        })
        ->WhereBetween($DATESELECT,[$from,$to]) 
        ->orderBy('supplies_con.ID', 'desc')->get();
        $budgetsum =  Suppliescon::select('supplies_con.ID','CON_YEAR_ID','CON_NUM','supplies_request.REQUEST_ID','REGIS_STATUS_NAME','DATE_REGIS','EGP_PLAN_NAME','SUP_TYPE_NAME','VENDOR_NAME','supplies_con.BUDGET_SUM','CHECK_DATE','supplies_status_regis.REGIS_STATUS_ID','supplies_buy.BUY_NAME','supplies_budget.BUDGET_NAME')
        ->leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
        ->leftJoin('supplies_request','supplies_con.REQUEST_ID','=','supplies_request.ID')
        ->leftJoin('supplies_buy','supplies_con.BUY_ID','=','supplies_buy.BUY_ID')
        ->leftJoin('supplies_budget','supplies_con.BUDGET_ID','=','supplies_budget.BUDGET_ID')
        ->where('supplies_con.CON_YEAR_ID','=',$yearbudget)
        ->where(function($q) use ($search){
            $q->where('EGP_PLAN_NAME','like','%'.$search.'%');
            $q->orwhere('VENDOR_NAME','like','%'.$search.'%');
            $q->orwhere('CON_NUM','like','%'.$search.'%'); 
            $q->orwhere('supplies_con.BUDGET_SUM','like','%'.$search.'%');  
            $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');  
            $q->orwhere('supplies_request.REQUEST_ID','like','%'.$search.'%');  
            $q->orwhere('BUDGET_NAME','like','%'.$search.'%'); 
            $q->orwhere('BUY_NAME','like','%'.$search.'%');  
        })
        ->WhereBetween($DATESELECT,[$from,$to])
        ->sum('supplies_con.BUDGET_SUM');
        $count =  Suppliescon::select('supplies_con.ID','CON_YEAR_ID','CON_NUM','supplies_request.REQUEST_ID','REGIS_STATUS_NAME','DATE_REGIS','EGP_PLAN_NAME','SUP_TYPE_NAME','VENDOR_NAME','supplies_con.BUDGET_SUM','CHECK_DATE','supplies_status_regis.REGIS_STATUS_ID','supplies_buy.BUY_NAME','supplies_budget.BUDGET_NAME')
        ->leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
        ->leftJoin('supplies_request','supplies_con.REQUEST_ID','=','supplies_request.ID')
        ->leftJoin('supplies_buy','supplies_con.BUY_ID','=','supplies_buy.BUY_ID')
        ->leftJoin('supplies_budget','supplies_con.BUDGET_ID','=','supplies_budget.BUDGET_ID')
        ->where('supplies_con.CON_YEAR_ID','=',$yearbudget)
        ->where(function($q) use ($search){
            $q->where('EGP_PLAN_NAME','like','%'.$search.'%');
            $q->orwhere('VENDOR_NAME','like','%'.$search.'%');
            $q->orwhere('CON_NUM','like','%'.$search.'%'); 
            $q->orwhere('supplies_con.BUDGET_SUM','like','%'.$search.'%');  
            $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');  
            $q->orwhere('supplies_request.REQUEST_ID','like','%'.$search.'%');  
            $q->orwhere('BUDGET_NAME','like','%'.$search.'%'); 
            $q->orwhere('BUY_NAME','like','%'.$search.'%'); 
        })
        ->WhereBetween($DATESELECT,[$from,$to])
        ->count();
    }else{
        $infosupcon = Suppliescon::select('supplies_con.ID','CON_YEAR_ID','CON_NUM','supplies_request.REQUEST_ID','REGIS_STATUS_NAME','DATE_REGIS','EGP_PLAN_NAME','SUP_TYPE_NAME','VENDOR_NAME','supplies_con.BUDGET_SUM','CHECK_DATE','supplies_status_regis.REGIS_STATUS_ID','supplies_buy.BUY_NAME','supplies_budget.BUDGET_NAME')
        ->leftJoin('supplies_status_regis','supplies_con.REGIS_STATUS_ID','=','supplies_status_regis.REGIS_STATUS_ID')
        ->where('supplies_con.REGIS_STATUS_ID','=',$status)
        ->leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
        ->leftJoin('supplies_request','supplies_con.REQUEST_ID','=','supplies_request.ID')
        ->leftJoin('supplies_buy','supplies_con.BUY_ID','=','supplies_buy.BUY_ID')
        ->leftJoin('supplies_budget','supplies_con.BUDGET_ID','=','supplies_budget.BUDGET_ID')
        ->where('supplies_con.CON_YEAR_ID','=',$yearbudget)
        ->where(function($q) use ($search){
            $q->where('EGP_PLAN_NAME','like','%'.$search.'%');
            $q->orwhere('VENDOR_NAME','like','%'.$search.'%');
            $q->orwhere('CON_NUM','like','%'.$search.'%'); 
            $q->orwhere('supplies_con.BUDGET_SUM','like','%'.$search.'%');  
            $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%'); 
            $q->orwhere('supplies_request.REQUEST_ID','like','%'.$search.'%'); 
            $q->orwhere('BUDGET_NAME','like','%'.$search.'%'); 
            $q->orwhere('BUY_NAME','like','%'.$search.'%');     
        })
        ->WhereBetween($DATESELECT,[$from,$to]) 
        ->orderBy('supplies_con.ID', 'desc')->get();
        $budgetsum =  Suppliescon::select('supplies_con.ID','CON_YEAR_ID','CON_NUM','supplies_request.REQUEST_ID','REGIS_STATUS_NAME','DATE_REGIS','EGP_PLAN_NAME','SUP_TYPE_NAME','VENDOR_NAME','supplies_con.BUDGET_SUM','CHECK_DATE','supplies_status_regis.REGIS_STATUS_ID','supplies_buy.BUY_NAME','supplies_budget.BUDGET_NAME')
        ->leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
        ->leftJoin('supplies_request','supplies_con.REQUEST_ID','=','supplies_request.ID')
        ->leftJoin('supplies_buy','supplies_con.BUY_ID','=','supplies_buy.BUY_ID')
        ->leftJoin('supplies_budget','supplies_con.BUDGET_ID','=','supplies_budget.BUDGET_ID')
        ->where('supplies_con.CON_YEAR_ID','=',$yearbudget)
        ->where('supplies_con.REGIS_STATUS_ID','=',$status)
        ->where(function($q) use ($search){
            $q->where('EGP_PLAN_NAME','like','%'.$search.'%');
            $q->orwhere('VENDOR_NAME','like','%'.$search.'%');
            $q->orwhere('CON_NUM','like','%'.$search.'%'); 
            $q->orwhere('supplies_con.BUDGET_SUM','like','%'.$search.'%');  
            $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%'); 
            $q->orwhere('supplies_request.REQUEST_ID','like','%'.$search.'%'); 
            $q->orwhere('BUDGET_NAME','like','%'.$search.'%'); 
            $q->orwhere('BUY_NAME','like','%'.$search.'%');      
        })
        ->WhereBetween($DATESELECT,[$from,$to])
        ->sum('supplies_con.BUDGET_SUM');

        $count =  Suppliescon::select('supplies_con.ID','CON_YEAR_ID','CON_NUM','supplies_request.REQUEST_ID','REGIS_STATUS_NAME','DATE_REGIS','EGP_PLAN_NAME','SUP_TYPE_NAME','VENDOR_NAME','supplies_con.BUDGET_SUM','CHECK_DATE','supplies_status_regis.REGIS_STATUS_ID','supplies_buy.BUY_NAME','supplies_budget.BUDGET_NAME')
        ->leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
        ->leftJoin('supplies_request','supplies_con.REQUEST_ID','=','supplies_request.ID')
        ->leftJoin('supplies_buy','supplies_con.BUY_ID','=','supplies_buy.BUY_ID')
        ->leftJoin('supplies_budget','supplies_con.BUDGET_ID','=','supplies_budget.BUDGET_ID')
        ->where('supplies_con.CON_YEAR_ID','=',$yearbudget)
        ->where('supplies_con.REGIS_STATUS_ID','=',$status)
        ->where(function($q) use ($search){
            $q->where('EGP_PLAN_NAME','like','%'.$search.'%');
            $q->orwhere('VENDOR_NAME','like','%'.$search.'%');
            $q->orwhere('CON_NUM','like','%'.$search.'%'); 
            $q->orwhere('supplies_con.BUDGET_SUM','like','%'.$search.'%');  
            $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');   
            $q->orwhere('supplies_request.REQUEST_ID','like','%'.$search.'%'); 
            $q->orwhere('BUDGET_NAME','like','%'.$search.'%'); 
            $q->orwhere('BUY_NAME','like','%'.$search.'%'); 
        })
        ->WhereBetween($DATESELECT,[$from,$to])
        ->count();
    }    
        $suppliesstatus = DB::table('supplies_status_regis')->get();
        $budgetyear = DB::table('budget_year')->get();
        return view('manager_supplies.purchase',[
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
            'dateselect' => $dateselect,
        ]); 
    }

    public function searchpurchase(Request $request)
    {
        if($request->Status){
            $search = session('searchpurchase.search');
            $status = session('searchpurchase.status');
            $dateselect = session('searchpurchase.dateselect');
            $datebigin = session('searchpurchase.datebigin');
            $dateend = session('searchpurchase.dateend');
            $yearbudget = session('searchpurchase.yearbudget');
        }else{
            $search = $request->get('search');
            $status = $request->SEND_STATUS;
            $dateselect = $request->DATE_SELECT;
            $datebigin = $request->get('DATE_BIGIN');
            $dateend = $request->get('DATE_END');
            $yearbudget = $request->BUDGET_YEAR;
            session([
                'searchpurchase.Status' => true,
                'searchpurchase.search' => $search,
                'searchpurchase.status' => $status,
                'searchpurchase.dateselect' => $dateselect,
                'searchpurchase.datebigin' => $datebigin,
                'searchpurchase.dateend' => $dateend,
                'searchpurchase.yearbudget' => $yearbudget
            ]);
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


        $infosupcon = Suppliescon::select('supplies_con.ID','CON_YEAR_ID','CON_NUM','supplies_request.REQUEST_ID','REGIS_STATUS_NAME','DATE_REGIS','EGP_PLAN_NAME','SUP_TYPE_NAME','VENDOR_NAME','supplies_con.BUDGET_SUM','CHECK_DATE','supplies_status_regis.REGIS_STATUS_ID','supplies_buy.BUY_NAME','supplies_budget.BUDGET_NAME')
        ->leftJoin('supplies_status_regis','supplies_con.REGIS_STATUS_ID','=','supplies_status_regis.REGIS_STATUS_ID')
        ->leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
        ->leftJoin('supplies_request','supplies_con.REQUEST_ID','=','supplies_request.ID')
        ->leftJoin('supplies_buy','supplies_con.BUY_ID','=','supplies_buy.BUY_ID')
        ->leftJoin('supplies_budget','supplies_con.BUDGET_ID','=','supplies_budget.BUDGET_ID')
        ->where('supplies_con.CON_YEAR_ID','=',$yearbudget)
        ->where(function($q) use ($search){
            $q->where('EGP_PLAN_NAME','like','%'.$search.'%');
            $q->orwhere('VENDOR_NAME','like','%'.$search.'%');
            $q->orwhere('CON_NUM','like','%'.$search.'%'); 
            $q->orwhere('supplies_con.BUDGET_SUM','like','%'.$search.'%');  
            $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');    
            $q->orwhere('supplies_request.REQUEST_ID','like','%'.$search.'%'); 
            $q->orwhere('BUDGET_NAME','like','%'.$search.'%'); 
            $q->orwhere('BUY_NAME','like','%'.$search.'%'); 
        })
        ->WhereBetween($DATESELECT,[$from,$to]) 
        ->orderBy('supplies_con.ID', 'desc')->get();

        
        $budgetsum =  Suppliescon::select('supplies_con.ID','CON_YEAR_ID','CON_NUM','supplies_request.REQUEST_ID','REGIS_STATUS_NAME','DATE_REGIS','EGP_PLAN_NAME','SUP_TYPE_NAME','VENDOR_NAME','supplies_con.BUDGET_SUM','CHECK_DATE','supplies_status_regis.REGIS_STATUS_ID','supplies_buy.BUY_NAME','supplies_budget.BUDGET_NAME')
        ->leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
        ->leftJoin('supplies_request','supplies_con.REQUEST_ID','=','supplies_request.ID')
        ->leftJoin('supplies_buy','supplies_con.BUY_ID','=','supplies_buy.BUY_ID')
        ->leftJoin('supplies_budget','supplies_con.BUDGET_ID','=','supplies_budget.BUDGET_ID')
        ->where('supplies_con.CON_YEAR_ID','=',$yearbudget)
        ->where(function($q) use ($search){
            $q->where('EGP_PLAN_NAME','like','%'.$search.'%');
            $q->orwhere('VENDOR_NAME','like','%'.$search.'%');
            $q->orwhere('CON_NUM','like','%'.$search.'%'); 
            $q->orwhere('supplies_con.BUDGET_SUM','like','%'.$search.'%');  
            $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');  
            $q->orwhere('supplies_request.REQUEST_ID','like','%'.$search.'%');  
            $q->orwhere('BUDGET_NAME','like','%'.$search.'%'); 
            $q->orwhere('BUY_NAME','like','%'.$search.'%');  
        })
        ->WhereBetween($DATESELECT,[$from,$to])
        ->sum('supplies_con.BUDGET_SUM');

        $count =  Suppliescon::select('supplies_con.ID','CON_YEAR_ID','CON_NUM','supplies_request.REQUEST_ID','REGIS_STATUS_NAME','DATE_REGIS','EGP_PLAN_NAME','SUP_TYPE_NAME','VENDOR_NAME','supplies_con.BUDGET_SUM','CHECK_DATE','supplies_status_regis.REGIS_STATUS_ID','supplies_buy.BUY_NAME','supplies_budget.BUDGET_NAME')
        ->leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
        ->leftJoin('supplies_request','supplies_con.REQUEST_ID','=','supplies_request.ID')
        ->leftJoin('supplies_buy','supplies_con.BUY_ID','=','supplies_buy.BUY_ID')
        ->leftJoin('supplies_budget','supplies_con.BUDGET_ID','=','supplies_budget.BUDGET_ID')
        ->where('supplies_con.CON_YEAR_ID','=',$yearbudget)
        ->where(function($q) use ($search){
            $q->where('EGP_PLAN_NAME','like','%'.$search.'%');
            $q->orwhere('VENDOR_NAME','like','%'.$search.'%');
            $q->orwhere('CON_NUM','like','%'.$search.'%'); 
            $q->orwhere('supplies_con.BUDGET_SUM','like','%'.$search.'%');  
            $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');  
            $q->orwhere('supplies_request.REQUEST_ID','like','%'.$search.'%');  
            $q->orwhere('BUDGET_NAME','like','%'.$search.'%'); 
            $q->orwhere('BUY_NAME','like','%'.$search.'%'); 
        })
        ->WhereBetween($DATESELECT,[$from,$to])
        ->count();



    }else{


        $infosupcon = Suppliescon::select('supplies_con.ID','CON_YEAR_ID','CON_NUM','supplies_request.REQUEST_ID','REGIS_STATUS_NAME','DATE_REGIS','EGP_PLAN_NAME','SUP_TYPE_NAME','VENDOR_NAME','supplies_con.BUDGET_SUM','CHECK_DATE','supplies_status_regis.REGIS_STATUS_ID','supplies_buy.BUY_NAME','supplies_budget.BUDGET_NAME')
        ->leftJoin('supplies_status_regis','supplies_con.REGIS_STATUS_ID','=','supplies_status_regis.REGIS_STATUS_ID')
        ->where('supplies_con.REGIS_STATUS_ID','=',$status)
        ->leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
        ->leftJoin('supplies_request','supplies_con.REQUEST_ID','=','supplies_request.ID')
        ->leftJoin('supplies_buy','supplies_con.BUY_ID','=','supplies_buy.BUY_ID')
        ->leftJoin('supplies_budget','supplies_con.BUDGET_ID','=','supplies_budget.BUDGET_ID')
        ->where('supplies_con.CON_YEAR_ID','=',$yearbudget)
        ->where(function($q) use ($search){
            $q->where('EGP_PLAN_NAME','like','%'.$search.'%');
            $q->orwhere('VENDOR_NAME','like','%'.$search.'%');
            $q->orwhere('CON_NUM','like','%'.$search.'%'); 
            $q->orwhere('supplies_con.BUDGET_SUM','like','%'.$search.'%');  
            $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%'); 
            $q->orwhere('supplies_request.REQUEST_ID','like','%'.$search.'%'); 
            $q->orwhere('BUDGET_NAME','like','%'.$search.'%'); 
            $q->orwhere('BUY_NAME','like','%'.$search.'%');     
        })
        ->WhereBetween($DATESELECT,[$from,$to]) 
        ->orderBy('supplies_con.ID', 'desc')->get();


        $budgetsum =  Suppliescon::select('supplies_con.ID','CON_YEAR_ID','CON_NUM','supplies_request.REQUEST_ID','REGIS_STATUS_NAME','DATE_REGIS','EGP_PLAN_NAME','SUP_TYPE_NAME','VENDOR_NAME','supplies_con.BUDGET_SUM','CHECK_DATE','supplies_status_regis.REGIS_STATUS_ID','supplies_buy.BUY_NAME','supplies_budget.BUDGET_NAME')
        ->leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
        ->leftJoin('supplies_request','supplies_con.REQUEST_ID','=','supplies_request.ID')
        ->leftJoin('supplies_buy','supplies_con.BUY_ID','=','supplies_buy.BUY_ID')
        ->leftJoin('supplies_budget','supplies_con.BUDGET_ID','=','supplies_budget.BUDGET_ID')
        ->where('supplies_con.CON_YEAR_ID','=',$yearbudget)
        ->where('supplies_con.REGIS_STATUS_ID','=',$status)
        ->where(function($q) use ($search){
            $q->where('EGP_PLAN_NAME','like','%'.$search.'%');
            $q->orwhere('VENDOR_NAME','like','%'.$search.'%');
            $q->orwhere('CON_NUM','like','%'.$search.'%'); 
            $q->orwhere('supplies_con.BUDGET_SUM','like','%'.$search.'%');  
            $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%'); 
            $q->orwhere('supplies_request.REQUEST_ID','like','%'.$search.'%'); 
            $q->orwhere('BUDGET_NAME','like','%'.$search.'%'); 
            $q->orwhere('BUY_NAME','like','%'.$search.'%');      
        })
        ->WhereBetween($DATESELECT,[$from,$to])
        ->sum('supplies_con.BUDGET_SUM');

        $count =  Suppliescon::select('supplies_con.ID','CON_YEAR_ID','CON_NUM','supplies_request.REQUEST_ID','REGIS_STATUS_NAME','DATE_REGIS','EGP_PLAN_NAME','SUP_TYPE_NAME','VENDOR_NAME','supplies_con.BUDGET_SUM','CHECK_DATE','supplies_status_regis.REGIS_STATUS_ID','supplies_buy.BUY_NAME','supplies_budget.BUDGET_NAME')
        ->leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
        ->leftJoin('supplies_request','supplies_con.REQUEST_ID','=','supplies_request.ID')
        ->leftJoin('supplies_buy','supplies_con.BUY_ID','=','supplies_buy.BUY_ID')
        ->leftJoin('supplies_budget','supplies_con.BUDGET_ID','=','supplies_budget.BUDGET_ID')
        ->where('supplies_con.CON_YEAR_ID','=',$yearbudget)
        ->where('supplies_con.REGIS_STATUS_ID','=',$status)
        ->where(function($q) use ($search){
            $q->where('EGP_PLAN_NAME','like','%'.$search.'%');
            $q->orwhere('VENDOR_NAME','like','%'.$search.'%');
            $q->orwhere('CON_NUM','like','%'.$search.'%'); 
            $q->orwhere('supplies_con.BUDGET_SUM','like','%'.$search.'%');  
            $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');   
            $q->orwhere('supplies_request.REQUEST_ID','like','%'.$search.'%'); 
            $q->orwhere('BUDGET_NAME','like','%'.$search.'%'); 
            $q->orwhere('BUY_NAME','like','%'.$search.'%'); 
        })
        ->WhereBetween($DATESELECT,[$from,$to])
        ->count();


    }    




    

        

        $suppliesstatus = DB::table('supplies_status_regis')->get();
          
        $budgetyear = DB::table('budget_year')->get();

        return view('manager_supplies.purchase',[
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
            'dateselect' => $dateselect,
           
        ]); 

      
    }

    public function purchase_excel(Request $request,$yearbudget,$datebigin,$dateend,$status,$search)
    {
       
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


        $infosupcon = Suppliescon::select('supplies_con.ID','CON_YEAR_ID','CON_NUM','supplies_request.REQUEST_ID','REGIS_STATUS_NAME','DATE_REGIS','EGP_PLAN_NAME','SUP_TYPE_NAME','VENDOR_NAME','supplies_con.BUDGET_SUM','CHECK_DATE','CON_DETAIL','supplies_status_regis.REGIS_STATUS_ID','BUY_NAME')
        ->leftJoin('supplies_status_regis','supplies_con.REGIS_STATUS_ID','=','supplies_status_regis.REGIS_STATUS_ID')
        ->leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
        ->leftJoin('supplies_request','supplies_con.REQUEST_ID','=','supplies_request.ID')
        ->leftJoin('supplies_buy','supplies_con.BUY_ID','=','supplies_buy.BUY_ID')
        ->where('supplies_con.CON_YEAR_ID','=',$yearbudget)
        ->where(function($q) use ($search){
            $q->where('EGP_PLAN_NAME','like','%'.$search.'%');
            $q->orwhere('VENDOR_NAME','like','%'.$search.'%');
            $q->orwhere('CON_NUM','like','%'.$search.'%'); 
            $q->orwhere('supplies_con.BUDGET_SUM','like','%'.$search.'%');  
            $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');    
            $q->orwhere('supplies_request.REQUEST_ID','like','%'.$search.'%'); 
        })
        ->WhereBetween('DATE_REGIS',[$from,$to]) 
        ->orderBy('supplies_con.DATE_REGIS', 'asc')->get();

        
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
        ->WhereBetween('DATE_REGIS',[$from,$to])
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
        ->WhereBetween('DATE_REGIS',[$from,$to])
        ->count();



    }else{


        $infosupcon = Suppliescon::select('supplies_con.ID','CON_YEAR_ID','CON_NUM','supplies_request.REQUEST_ID','REGIS_STATUS_NAME','DATE_REGIS','EGP_PLAN_NAME','SUP_TYPE_NAME','VENDOR_NAME','supplies_con.BUDGET_SUM','CHECK_DATE','CON_DETAIL','supplies_status_regis.REGIS_STATUS_ID','BUY_NAME')
        ->leftJoin('supplies_status_regis','supplies_con.REGIS_STATUS_ID','=','supplies_status_regis.REGIS_STATUS_ID')
        ->where('supplies_con.REGIS_STATUS_ID','=',$status)
        ->leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
        ->leftJoin('supplies_request','supplies_con.REQUEST_ID','=','supplies_request.ID')
        ->leftJoin('supplies_buy','supplies_con.BUY_ID','=','supplies_buy.BUY_ID')
        ->where('supplies_con.CON_YEAR_ID','=',$yearbudget)
        ->where(function($q) use ($search){
            $q->where('EGP_PLAN_NAME','like','%'.$search.'%');
            $q->orwhere('VENDOR_NAME','like','%'.$search.'%');
            $q->orwhere('CON_NUM','like','%'.$search.'%'); 
            $q->orwhere('supplies_con.BUDGET_SUM','like','%'.$search.'%');  
            $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%'); 
            $q->orwhere('supplies_request.REQUEST_ID','like','%'.$search.'%');     
        })
        ->WhereBetween('DATE_REGIS',[$from,$to]) 
        ->orderBy('supplies_con.DATE_REGIS', 'asc')->get();


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
        ->WhereBetween('DATE_REGIS',[$from,$to])
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
        ->WhereBetween('DATE_REGIS',[$from,$to])
        ->count();


    }    

        $suppliesstatus = DB::table('supplies_status_regis')->get();
          
        $budgetyear = DB::table('budget_year')->get();

        return view('manager_supplies.purchase_excel',[
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


    
    public function purchase_excel_5000(Request $request,$yearbudget,$datebigin,$dateend,$status,$search)
    {
       
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


        $infosupcon = Suppliescon::select('supplies_con.ID','CON_YEAR_ID','CON_NUM','supplies_request.REQUEST_ID','REGIS_STATUS_NAME','DATE_REGIS','EGP_PLAN_NAME','SUP_TYPE_NAME','VENDOR_NAME','supplies_con.BUDGET_SUM','CHECK_DATE','CON_DETAIL','supplies_status_regis.REGIS_STATUS_ID','BUY_NAME')
        ->leftJoin('supplies_status_regis','supplies_con.REGIS_STATUS_ID','=','supplies_status_regis.REGIS_STATUS_ID')
        ->leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
        ->leftJoin('supplies_request','supplies_con.REQUEST_ID','=','supplies_request.ID')
        ->leftJoin('supplies_buy','supplies_con.BUY_ID','=','supplies_buy.BUY_ID')
        ->where('supplies_con.CON_YEAR_ID','=',$yearbudget)
        ->where('supplies_con.BUDGET_SUM','<',5000)
        ->where(function($q) use ($search){
            $q->where('EGP_PLAN_NAME','like','%'.$search.'%');
            $q->orwhere('VENDOR_NAME','like','%'.$search.'%');
            $q->orwhere('CON_NUM','like','%'.$search.'%'); 
            $q->orwhere('supplies_con.BUDGET_SUM','like','%'.$search.'%');  
            $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');    
            $q->orwhere('supplies_request.REQUEST_ID','like','%'.$search.'%'); 
        })
        ->WhereBetween('DATE_REGIS',[$from,$to]) 
        ->orderBy('supplies_con.DATE_REGIS', 'asc')->get();

        
        $budgetsum =  Suppliescon::leftJoin('supplies_status_regis','supplies_con.REGIS_STATUS_ID','=','supplies_status_regis.REGIS_STATUS_ID')
        ->leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
        ->leftJoin('supplies_request','supplies_con.REQUEST_ID','=','supplies_request.ID')
        ->where('supplies_con.CON_YEAR_ID','=',$yearbudget)
        ->where('supplies_con.BUDGET_SUM','<',5000)
        ->where(function($q) use ($search){
            $q->where('EGP_PLAN_NAME','like','%'.$search.'%');
            $q->orwhere('VENDOR_NAME','like','%'.$search.'%');
            $q->orwhere('CON_NUM','like','%'.$search.'%'); 
            $q->orwhere('supplies_con.BUDGET_SUM','like','%'.$search.'%');  
            $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');  
            $q->orwhere('supplies_request.REQUEST_ID','like','%'.$search.'%');   
        })
        ->WhereBetween('DATE_REGIS',[$from,$to])
        ->sum('supplies_con.BUDGET_SUM');

        $count =  Suppliescon::leftJoin('supplies_status_regis','supplies_con.REGIS_STATUS_ID','=','supplies_status_regis.REGIS_STATUS_ID')
        ->leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
        ->leftJoin('supplies_request','supplies_con.REQUEST_ID','=','supplies_request.ID')
        ->where('supplies_con.CON_YEAR_ID','=',$yearbudget)
        ->where('supplies_con.BUDGET_SUM','<',5000)
        ->where(function($q) use ($search){
            $q->where('EGP_PLAN_NAME','like','%'.$search.'%');
            $q->orwhere('VENDOR_NAME','like','%'.$search.'%');
            $q->orwhere('CON_NUM','like','%'.$search.'%'); 
            $q->orwhere('supplies_con.BUDGET_SUM','like','%'.$search.'%');  
            $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');  
            $q->orwhere('supplies_request.REQUEST_ID','like','%'.$search.'%');  
        })
        ->WhereBetween('DATE_REGIS',[$from,$to])
        ->count();



    }else{


        $infosupcon = Suppliescon::select('supplies_con.ID','CON_YEAR_ID','CON_NUM','supplies_request.REQUEST_ID','REGIS_STATUS_NAME','DATE_REGIS','EGP_PLAN_NAME','SUP_TYPE_NAME','VENDOR_NAME','supplies_con.BUDGET_SUM','CHECK_DATE','CON_DETAIL','supplies_status_regis.REGIS_STATUS_ID','BUY_NAME')
        ->leftJoin('supplies_status_regis','supplies_con.REGIS_STATUS_ID','=','supplies_status_regis.REGIS_STATUS_ID')
        ->where('supplies_con.REGIS_STATUS_ID','=',$status)
        ->leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
        ->leftJoin('supplies_request','supplies_con.REQUEST_ID','=','supplies_request.ID')
        ->leftJoin('supplies_buy','supplies_con.BUY_ID','=','supplies_buy.BUY_ID')
        ->where('supplies_con.CON_YEAR_ID','=',$yearbudget)
        ->where('supplies_con.BUDGET_SUM','<',5000)
        ->where(function($q) use ($search){
            $q->where('EGP_PLAN_NAME','like','%'.$search.'%');
            $q->orwhere('VENDOR_NAME','like','%'.$search.'%');
            $q->orwhere('CON_NUM','like','%'.$search.'%'); 
            $q->orwhere('supplies_con.BUDGET_SUM','like','%'.$search.'%');  
            $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%'); 
            $q->orwhere('supplies_request.REQUEST_ID','like','%'.$search.'%');     
        })
        ->WhereBetween('DATE_REGIS',[$from,$to]) 
        ->orderBy('supplies_con.DATE_REGIS', 'asc')->get();


        $budgetsum =  Suppliescon::leftJoin('supplies_status_regis','supplies_con.REGIS_STATUS_ID','=','supplies_status_regis.REGIS_STATUS_ID')
        ->leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
        ->leftJoin('supplies_request','supplies_con.REQUEST_ID','=','supplies_request.ID')
        ->where('supplies_con.CON_YEAR_ID','=',$yearbudget)
        ->where('supplies_con.REGIS_STATUS_ID','=',$status)
        ->where('supplies_con.BUDGET_SUM','<',5000)
        ->where(function($q) use ($search){
            $q->where('EGP_PLAN_NAME','like','%'.$search.'%');
            $q->orwhere('VENDOR_NAME','like','%'.$search.'%');
            $q->orwhere('CON_NUM','like','%'.$search.'%'); 
            $q->orwhere('supplies_con.BUDGET_SUM','like','%'.$search.'%');  
            $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%'); 
            $q->orwhere('supplies_request.REQUEST_ID','like','%'.$search.'%');      
        })
        ->WhereBetween('DATE_REGIS',[$from,$to])
        ->sum('supplies_con.BUDGET_SUM');

        $count =  Suppliescon::leftJoin('supplies_status_regis','supplies_con.REGIS_STATUS_ID','=','supplies_status_regis.REGIS_STATUS_ID')
        ->leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
        ->leftJoin('supplies_request','supplies_con.REQUEST_ID','=','supplies_request.ID')
        ->where('supplies_con.CON_YEAR_ID','=',$yearbudget)
        ->where('supplies_con.REGIS_STATUS_ID','=',$status)
        ->where('supplies_con.BUDGET_SUM','<',5000)
        ->where(function($q) use ($search){
            $q->where('EGP_PLAN_NAME','like','%'.$search.'%');
            $q->orwhere('VENDOR_NAME','like','%'.$search.'%');
            $q->orwhere('CON_NUM','like','%'.$search.'%'); 
            $q->orwhere('supplies_con.BUDGET_SUM','like','%'.$search.'%');  
            $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');   
            $q->orwhere('supplies_request.REQUEST_ID','like','%'.$search.'%'); 
        })
        ->WhereBetween('DATE_REGIS',[$from,$to])
        ->count();


    }    

        $suppliesstatus = DB::table('supplies_status_regis')->get();
          
        $budgetyear = DB::table('budget_year')->get();

     

        return view('manager_supplies.purchase_excel_5000',[
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



    public function createpurchaseregister(Request $request,$id)
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
    
        $suppliesconboardlist = DB::table('supplies_con_board_list')->get();
        
        
        return view('manager_supplies.purchaseregister_add',[
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
        ]);
        
    }


    public function selectrequest(Request $request)
{
     
    function formate($strDate)
    {
      $strYear = date("Y",strtotime($strDate));
      $strMonth= date("m",strtotime($strDate));
      $strDay= date("d",strtotime($strDate));
    
      return $strDay."/".$strMonth."/".$strYear;
      }  
    


    $m_budget = date("m");

  if($m_budget>9){
    $yearbudget = date("Y")+544;
  }else{
    $yearbudget = date("Y")+543;
  }
 
    $detail = Suppliesrequest::where('ID','=',$request->id)->first();
 
    $pessonalls = Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')->get(); 
    $departmentsubsubs = DB::table('hrd_department_sub_sub')->get();

    $output=' <div class="row push">
    <div class="col-sm-2">
    <label>อ้างอิงทะเบียนขอซื้อ/จ้าง :</label>
    </div> 
    <div class="col-lg-4">
    <input type="hidden" name="REQUEST_ID" id="REQUEST_ID" class="form-control input-sm" style=" font-family: \'Kanit\', sans-serif;" value="'.$detail->ID.'">
    <input name="" id="" class="form-control input-sm" style=" font-family: \'Kanit\', sans-serif;" value="'.$detail->ID.'::'.$detail->REQUEST_FOR.'::'.$detail->REQUEST_BUY_COMMENT.'" readonly>
    </div>
    <div class="col-lg-1">
    <button type="button" class="btn btn-hero-sm btn-hero-info" data-toggle="modal" data-target=".addref" style="font-family: \'Kanit\', sans-serif; font-size: 10px;font-size: 1.0rem;font-weight:normal;" >เลือก</button>
    </div>  
    <div class="col-sm-1">
    <label>เลขที่หนังสือ :</label>
    </div> 
    <div class="col-lg-4">
    <input name="DEP_REQUEST_BOOK" id="DEP_REQUEST_BOOK" class="form-control input-sm" style=" font-family: \'Kanit\', sans-serif;" value="">
    </div>

</div>

    </div>

    <div class="row push">
    <div class="col-sm-2">
    <label>หน่วยงาน :</label>
    </div> 
    <div class="col-lg-5">
                    <select name="DEP_REQUEST_ID" id="DEP_REQUEST_ID" class="form-control input-sm " style=" font-family: \'Kanit\', sans-serif;" >
                                     <option value="" selected>--กรุณาเลือกหน่วยงาน--</option>';
                             

                                    foreach ($departmentsubsubs as $departmentsubsub){
                                        if($departmentsubsub -> HR_DEPARTMENT_SUB_SUB_ID == $detail->DEP_SUB_SUB_ID){
                                            $output.='<option value="'.$departmentsubsub -> HR_DEPARTMENT_SUB_SUB_ID.'" selected>'.$departmentsubsub -> HR_DEPARTMENT_SUB_SUB_NAME.'</option>';                
                                        }else{
                                            $output.='<option value="'.$departmentsubsub -> HR_DEPARTMENT_SUB_SUB_ID.'">'.$departmentsubsub -> HR_DEPARTMENT_SUB_SUB_NAME.'</option>';           
                                        } 
                                      
                                        }
                                     
    $output.='</select> 
    </div>

    <div class="col-sm-1">
        <label>ผู้ร้องขอ :</label>
    </div> 
    <div class="col-lg-4">        
    <select name="PERSON_REQUEST_ID" id="PERSON_REQUEST_ID" class="form-control input-sm " style=" font-family: \'Kanit\', sans-serif;" >
                                     <option value="" selected>--กรุณาเลือกผู้ร้องขอ-</option>';
                                     foreach ($pessonalls as $pessonall){ 
                                       
                                        if($pessonall -> ID == $detail->SAVE_HR_ID){
                                            $output.='<option value="'.$pessonall -> ID.'" selected>'.$pessonall -> HR_FNAME.' '.$pessonall -> HR_LNAME.'</option>';                
                                        }else{
                                            $output.='<option value="'.$pessonall -> ID.'">'.$pessonall -> HR_FNAME.' '.$pessonall -> HR_LNAME.'</option>';           
                                        } 
                                    
                                    }

    $output.='</select> 
    </div>

    </div>

    ';

     
    echo $output;

}

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
      
 
        
         return redirect()->route('msupplies.purchase');

    }

    public function savepurchaseregisteronly(Request $request)
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

        $addsuppliescon->REGIS_STATUS_ID = '1'; 
      
        $addsuppliescon->save(); 
             
         
         return redirect()->route('msupplies.purchase');
    }
       //-----------------------------แก้ไขทะเบียนคุม
       
       public function editpurchaseregister(Request $request,$id)
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
           
           return view('manager_supplies.purchaseregister_edit',[
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
    
           ]);
           
       }

       public function updatepurchaseregister(Request $request)
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
      
         
    
           
            return redirect()->route('msupplies.purchase');
   
           }


   

    //------------------------------ยกเลิก

    public function cancelpurchase(Request $request,$id)
    {
  

        $infosuppliecon = Suppliescon::leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
        ->where('ID','=',$id)->first();

     
    
        return view('manager_supplies.purchasecancel',[
            'connum' => $infosuppliecon->CON_NUM,
            'condetail' => $infosuppliecon->CON_DETAIL,
            'resonname' => $infosuppliecon->RESON_NAME,
            'personrequestname' => $infosuppliecon->PERSON_REQUEST_NAME,
            'regisbyname' => $infosuppliecon->REGIS_BY_NAME,
            'suptypename' => $infosuppliecon->SUP_TYPE_NAME,
            'conid' => $infosuppliecon->ID,

        ]);
        
    }

    
public function cancelpurchaseupdate(Request $request)
{
    $id = $request->CON_ID; 

    $updateapp = Suppliescon::find($id);
    $updateapp->REGIS_STATUS_ID = '6'; 
    $updateapp->save();

   

    return redirect()->route('msupplies.purchase'); 

}

//--------------------------------------------------- เพิ่มใบสเนอราคา

    //---------------------------------------------------


    public function createpurchaselist(Request $request,$idlistref)
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
    

        return view('manager_supplies.purchaselist_add',[
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


        $sumprice  =  $request->PRICESUM_send;

        $updateapp = Suppliescon::find($CONID);
        $updateapp->REGIS_STATUS_ID = '3'; 
        $updateapp->VENDOR_NAME=  $VENDOR;   
        $updateapp->BUDGET_SUM = $sumprice;
        $updateapp->TAX_TYPE = $request->TAX_TYPE;
        $updateapp->DISCOUNT = $request->DISC;
        $updateapp->save();
      
    
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
        $addsuppliesconlist->SUP_TOTAL = $infosupre->SUPPLIES_REQUEST_SUB_AMOUNT;
        $addsuppliesconlist->PRICE_PER_UNIT = $infosupre->SUPPLIES_REQUEST_SUB_PRICE;
        $addsuppliesconlist->PRICE_SUM = $infosupre->SUPPLIES_REQUEST_SUB_SUM_PRICE;
        $addsuppliesconlist->save(); 


        }


 
    return redirect()->route('msupplies.createpurchaselist',[ 'idlistref' =>$CONID->ID ]);
        
    }

    public function createpurchaseboard(Request $request)
    {
    
        return view('manager_supplies.purchaseboard_add');
        
    }

    //------------------------------------เพิ่มใบเสนอราคา-------------------------------
    public function createpurchasequotation(Request $request,$id)
    {
        $detailcon = Suppliescon::where('ID','=',$id)->first();

        $detailquotation= Suppliesconquotation::leftJoin('supplies_vendor','supplies_con_quotation.QUOTATION_VENDOR_ID','=','supplies_vendor.VENDOR_ID')
        ->where('QUOTATION_CON_NUM','=',$detailcon->CON_NUM)->orderBy('QUOTATION_WIN', 'desc')->get();
        
        return view('manager_supplies.purchasequotation_add',[
            'CON_NUM' => $detailcon->CON_NUM,
            'IDCON' => $id,
            'detailquotations' => $detailquotation,
        ]);
        
    }


    public function   createpurchasequotationsub(Request $request,$id)
    {
        $detailcon = Suppliescon::where('ID','=',$id)->first();

        $vendor =  DB::table('supplies_vendor')->where('ACTIVE','=','True')->get();
        $infosuppliecon = Suppliescon::leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
        ->where('ID','=',$id)->first();


        return view('manager_supplies.purchasequotation_addsub',[
            'CON_NUM' => $detailcon->CON_NUM,
            'IDCON' => $id,
            'requestid' => $infosuppliecon->REQUEST_ID,
            'vendors' => $vendor
        ]);
        
    }

    

    
function fetchvendor(Request $request)
{
   
  $id = $request->get('select');
  $detailvendor = DB::table('supplies_vendor')->where('VENDOR_ID','=',$id)->first();

  $detailinfo = DB::table('supplies_con')->where('supplies_con.ID','=',$id)->first();


 
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
        <input  name = "QUOTATION_VENDOR_PICE"  id="QUOTATION_VENDOR_PICE" class="form-control input-lg" style=" font-family: \'Kanit\', sans-serif;" OnKeyPress="return chkmunny(this)" value="'.$price.'" >
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
        $request->validate([
            'QUOTATION_NUMBER' => 'required',
            'QUOTATION_VENDOR_ID' => 'required',
            'QUOTATION_VENDOR_ADD' => 'required',
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
  

        
        return response()->json([
            'status' => 1,
            'url' => url('manager_supplies/purchasequotation_add/'.$request->ID)
        ]);
        
   
        
    }

    //-----------------แก้ไขใบเสนอราคา---

    public function   purchasequotationsubedit(Request $request,$id,$idref)
    {
        $detailcon = Suppliescon::where('ID','=',$id)->first();

        $vendor =  DB::table('supplies_vendor')->where('ACTIVE','=','True')->get();

        $detailquotation = Suppliesconquotation::where('QUOTATION_ID','=',$idref)->first();
   
        return view('manager_supplies.purchasequotation_editsub',[
            'CON_NUM' => $detailcon->CON_NUM,
            'IDCON' => $id,
            'IDREF' => $idref,
            'vendors' => $vendor,
            'detailquotation' => $detailquotation,
        ]);
        
    }


    

public function purchasequotationsubupdate(Request $request)
{
    $request->validate([
        'QUOTATION_NUMBER' => 'required',
        'QUOTATION_VENDOR_ID' => 'required',
        'QUOTATION_VENDOR_ADD' => 'required',
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

    return response()->json([
        'status' => 1,
        'url' => url('manager_supplies/purchasequotation_add/'.$request->ID)
    ]);

    
}


public function purchasequotationsubdelete($id,$idref) { 
                
    Suppliesconquotation::destroy($idref);         

    return redirect()->route('msupplies.createpurchasequotation',[
        'id' =>$id,
    ]);
}



    //--------------------------------------------------------------------------------



    public function createpurchaseorders(Request $request,$idlistref)
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
         

        return view('manager_supplies.purchaseorders_add',[
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

    $request->validate([
        'SEND_DATE' => 'required',
        'BUYER_USER_ID' => 'required',
        'ORDER_DATE' => 'required',
        'SIGN_DATE' => 'required',
             
    ]);


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

    
    return response()->json([
        'status' => 1,
        'url' => url('manager_supplies/purchase')
    ]);

}    



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

         

        return view('manager_supplies.purchascheck',[
            'infosuppliecon' => $infosuppliecon,
            'infosuppliesconlists' => $infosuppliesconlist, 
            'infovendor' => $infovendor, 
            'pessonalls' => $pessonall, 
            'sumprice' => $sumprice, 
            'maxnumberch' => $maxnumberch, 
        ]);
        
    }


    

public function savepurchascheck(Request $request)

{
    $request->validate([
        'CHECK_DATE' => 'required',
        'CHECK_TIME' => 'required',
        'CHECK_TYPE_ID' => 'required',
        'CHECK_USER_ID' => 'required',
             
    ]);

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

    
    return response()->json([
        'status' => 1,
        'url' => url('manager_supplies/purchase')
    ]);

}    

//======การตรวจรับ==========================

public function confirmpurchase($id)
{
 
    $updateapp = Suppliescon::find($id);
    $updateapp->REGIS_STATUS_ID = '7'; 
    $updateapp->save();

    return redirect()->route('msupplies.purchase'); 

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

    
//-------------------------------------------------
    public function setupfsnsub(Request $request,$groupcode)
    {
    
        $nameasuppliesgroup = DB::table('supplies_group')->where('GROUP_CODE','=',$groupcode)->first();

        $suppliesclass = DB::table('supplies_class')->where('GROUP_CODE','=',$groupcode)->get();


        $suppliestype = DB::table('supplies_types')->where('GROUP_CODE','=',$groupcode)->first();
      


        
        return view('manager_supplies.setupfsnsub',[
            'nameasuppliesgroup' => $nameasuppliesgroup,
            'suppliesclassS' => $suppliesclass,
            'suppliestype' => $suppliestype,
        ]);
        
    }

    public function savesetupfsnsub(Request $request)
    {
        $groupcode = $request->GROUP_CODE;

        $add = new Suppliesclass;
        $add->GROUP_CODE = $groupcode;
        $add->CLASS_CODE = $request->CLASS_CODE;
        $add->CLASS_NAME = $request->CLASS_NAME;
        $add->GROUP_CLASS_CODE = $request->GROUP_CLASS_CODE;
        $add->save();

        $nameasuppliesgroup = DB::table('supplies_group')->where('GROUP_CODE','=',$groupcode)->first();

        $suppliesclass = DB::table('supplies_class')->where('GROUP_CODE','=',$groupcode)->get();
             
        return view('manager_supplies.setupfsnsub',[
            'nameasuppliesgroup' => $nameasuppliesgroup,
            'suppliesclassS' => $suppliesclass
        ]);
        
    }



    
    public function updatesetupfsnsub(Request $request)
    { 
        $id = $request->ID;
        $groupcode = $request->GROUP_CODE;
       
        $update = Suppliesclass::find($id);
        $update->CLASS_CODE = $request->CLASS_CODE;
        $update->CLASS_NAME = $request->CLASS_NAME;
        $update->GROUP_CLASS_CODE = $request->GROUP_CLASS_CODE;
        $update->save();

        $nameasuppliesgroup = DB::table('supplies_group')->where('GROUP_CODE','=',$groupcode)->first();

        $suppliesclass = DB::table('supplies_class')->where('GROUP_CODE','=',$groupcode)->get();
        
        return view('manager_supplies.setupfsnsub',[
            'nameasuppliesgroup' => $nameasuppliesgroup,
            'suppliesclassS' => $suppliesclass
        ]);
    }

    public function setupfsnsub_destroy($id,$groupcode) { 

        Suppliesclass::destroy($id);         
       
        return redirect()->route('msupplies.setupfsnsub',[
            'groupcode' => $groupcode,           
        
        ]);
    }


    function switchactivefsnsub(Request $request)
    {  
        $id = $request->id;
        $active = Suppliesclass::find($id);
        $active->ACTIVE = $request->onoff;
        $active->save();
    }

    //===================================== setupfsnsubsub =========================================//


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

    public function setupfsnsubsub_save(Request $request)
    {
        $typecode = $request->TYPE_CODE;
        $groupclassclose = $request->GROUP_CLASS_CODE;
        $groupcode = $request->GROUP_CODE;
        $classcode = $request->CLASS_CODE; 
        $tyname = $request->TYPE_NAME;

        $add = new Suppliestypes;
        $add->TYPE_CODE = $typecode;
        $add->GROUP_CODE = $groupcode;        
        $add->CLASS_CODE = $classcode; 
        $add->GROUP_CLASS_CODE = $groupclassclose;
        $add->TYPE_NAME = $tyname;
        $add->save();

        $namesuppliesgroup= DB::table('supplies_group')->where('GROUP_CODE','=',$groupcode)->first();

        $namesuppliesclass = DB::table('supplies_class')->where('GROUP_CODE','=',$groupcode)->where('CLASS_CODE','=',$classcode)->first();

        $suppliestype = DB::table('supplies_types')->where('GROUP_CODE','=',$groupcode)->where('CLASS_CODE','=',$classcode)->get();
        
         
        return view('manager_supplies.setupfsnsubsub',[
            'namesuppliesgroup' => $namesuppliesgroup,
            'namesuppliesclass' => $namesuppliesclass,
            'suppliestypes' => $suppliestype,
        ]);   
        
    }

    public function setupfsnsubsub_update(Request $request)
    {  
        $id = $request->TYPE_ID;
        $typecode = $request->TYPE_CODE;       
        $groupclassclose = $request->GROUP_CLASS_CODE;
        $groupcode = $request->GROUP_CODE;
        $classcode = $request->CLASS_CODE; 
        $tyname = $request->TYPE_NAME;

        $update = Suppliestypes::find($id);  
        $update->TYPE_CODE = $typecode;
        $update->GROUP_CODE = $groupcode;        
        $update->CLASS_CODE = $classcode; 
        $update->GROUP_CLASS_CODE = $groupclassclose;
        $update->TYPE_NAME = $tyname;
        $update->save();

        $namesuppliesgroup= DB::table('supplies_group')->where('GROUP_CODE','=',$groupcode)->first();

        $namesuppliesclass = DB::table('supplies_class')->where('GROUP_CODE','=',$groupcode)->where('CLASS_CODE','=',$classcode)->first();

        $suppliestype = DB::table('supplies_types')->where('GROUP_CODE','=',$groupcode)->where('CLASS_CODE','=',$classcode)->get();
        
         
        return view('manager_supplies.setupfsnsubsub',[
            'namesuppliesgroup' => $namesuppliesgroup,
            'namesuppliesclass' => $namesuppliesclass,
            'suppliestypes' => $suppliestype,
        ]);   
        
    }

    public function setupfsnsubsub_destroy($id,$groupcode,$classcode)
     {                

        Suppliestypes::destroy($id);         
       
        return redirect()->route('msupplies.setupfsnsubsub',[
            'groupcode' => $groupcode,
            'classcode' => $classcode,           
        
        ]);
    }


    function switchactivefsnsubsub(Request $request)
    {  
        //return $request->all(); 
        $id = $request->id;
        $active = Suppliestypes::find($id);
        $active->ACTIVE = $request->onoff;
        $active->save();
    }

    //===================================== setupfsnsubsubfinish  =========================================//

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



    public function savesetupfsnsubsubfinish(Request $request)
    {
    
        $groupcode = $request->GROUP_CODE ;
        $classcode = $request->CLASS_CODE ;
        $typecode = $request->TYPE_ID ;


        
        $addSuppliesprop =  new Suppliesprop();
        $addSuppliesprop->TYPE_ID = $request->TYPE_ID;
        $addSuppliesprop->PROPOTIES_NAME = $request->PROPOTIES_NAME;
        $addSuppliesprop->PROPOTIES_CODE = $request->PROPOTIES_CODE;
        $addSuppliesprop->GROUP_CLASS_CODE = $request->GROUP_CLASS_CODE;
        $addSuppliesprop->TYPE_CODE = $request->TYPE_CODE;
        $addSuppliesprop->GROUP_CODE = $request->GROUP_CODE;
        $addSuppliesprop->NUM = $request->GROUP_CLASS_CODE.'-'.$request->TYPE_CODE.'-'.$request->PROPOTIES_CODE;
        $addSuppliesprop->save();





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


    public function updatesetupfsnsubsubfinish(Request $request)
    {
    
        $groupcode = $request->GROUP_CODE ;
        $classcode = $request->CLASS_CODE ;
        $typecode = $request->TYPE_ID ;
        $propotiesid = $request->PROPOTIES_ID ;


        
        $addSuppliesprop =  Suppliesprop::find($propotiesid);
        $addSuppliesprop->TYPE_ID = $request->TYPE_ID;
        $addSuppliesprop->PROPOTIES_NAME = $request->PROPOTIES_NAME;
        $addSuppliesprop->PROPOTIES_CODE = $request->PROPOTIES_CODE;
        $addSuppliesprop->GROUP_CLASS_CODE = $request->GROUP_CLASS_CODE;
        $addSuppliesprop->TYPE_CODE = $request->TYPE_CODE;
        $addSuppliesprop->GROUP_CODE = $request->GROUP_CODE;
        $addSuppliesprop->NUM = $request->GROUP_CLASS_CODE.'-'.$request->TYPE_CODE.'-'.$request->PROPOTIES_CODE;
        $addSuppliesprop->save();


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





    
public function destroysetupfsnsubsubfinish($groupcode,$classcode,$typecode,$propcode) { 
                
    Suppliesprop::destroy($propcode);         
    return redirect()->route('msupplies.setupfsnsubsubfinish',[
        'groupcode' => $groupcode,
        'classcode' => $classcode,
        'typecode' => $typecode
    
    ]);
}

    //======================================================

    function switchactivefsnsubsubfinish(Request $request)
    {  
        $id = $request->id;
        $active = Suppliesprop::find($id);
        $active->ACTIVE = $request->onoff;
        $active->save();
    }
    
//=================================ฟังชัน=====================

public function selectfsn(Request $request)
{

    $detail = DB::table('supplies_prop')->where('PROPOTIES_ID','=',$request->id)->first();

    $output='<div class="col-lg-5"><input name="SUP_FSN_NUM" id="SUP_FSN_NUM" class="form-control input-sm" style=" font-family: \'Kanit\', sans-serif;" value="'.$detail->NUM.'"></div><div class="col-lg-5">'.$detail->PROPOTIES_NAME.'</div>';
     
    echo $output;

}

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
    
   //-----------------------------
   
   public static function checkref($idref)
    {        
        $count =  Suppliescon::where('REQUEST_ID','=',$idref ) 
                                    ->count();      
        return $count;
    }

//=====ฟังชั่นคำนวณภาษี=====

function fetchtaxcal(Request $request)
{
   
  $id = $request->get('select');
  $pricesum = $request->get('pricesum');

  $disc = $request->get('disc');

  if($disc == '' ){
    $discountnum = 0;
  }else{
    $discountnum =  $disc;
  }

  $tex =$pricesum*(7/100);

  $resuletaxin = ($pricesum*100)/107;
  $texin =  $pricesum - $resuletaxin;
 if($id == 1){
    $output = '<div class="row push">
    <div class="col-sm-3">
    <label>มูลค่าสินค้า :</label>
    </div> 
    <div class="col-lg-7">
        '.number_format($resuletaxin,5).'
        </div> 
        <div class="col-sm-2">
        <label>บาท</label>
        </div>  
</div> 



<div class="row push">
    <div class="col-sm-3">
    <label>เปอร์เซ็นภาษี :</label>
    </div> 
    <div class="col-lg-9">
        7.00 %
    </div>  
</div> 

<div class="row push">
    <div class="col-sm-3">
    <label>เป็นเงิน :</label>
    </div> 
    <div class="col-lg-7">
    '.number_format($texin,5).'
    </div>
    <div class="col-sm-2">
    <label>บาท</label>
    </div>   
</div> 

<div class="row push">
    <div class="col-sm-3">
    <label>รวมราคาสุทธิ :</label>
    </div> 
    <div class="col-lg-7">
    '.number_format($pricesum-$discountnum,5).'
    </div>  
    <div class="col-sm-2">
    <label>บาท</label>
    </div> 
</div> ';  
                                                
               
 }else if($id == 2){

    $output = '<div class="row push">
    <div class="col-sm-3">
    <label>มูลค่าสินค้า :</label>
    </div> 
    <div class="col-lg-7">
    '.number_format($pricesum,5).'

    </div>  
    <div class="col-sm-2">
    <label>บาท</label>
    </div> 
</div> 



<div class="row push">
    <div class="col-sm-3">
    <label>เปอร์เซ็นภาษี :</label>
    </div> 
    <div class="col-lg-9">
        7.00 %
    </div>  
</div> 

<div class="row push">
    <div class="col-sm-3">
    <label>เป็นเงิน :</label>
    </div> 
    <div class="col-lg-7">
    '.number_format($tex,5).'
    </div>  
    <div class="col-sm-2">
    <label>บาท</label>
    </div> 
</div> 

<div class="row push">
    <div class="col-sm-3">
    <label>รวมราคาสุทธิ :</label>
    </div> 
    <div class="col-lg-7">
    '.number_format($pricesum + $tex - $discountnum ,5).'
    </div> 
    <div class="col-sm-2">
    <label>บาท</label>
    </div>  
</div> ';
     
 }else{
    $output = '<div class="row push">
    <div class="col-sm-3">
    <label>มูลค่าสินค้า :</label>
    </div> 
    <div class="col-lg-7">
    '.number_format($pricesum,5).'

    </div>  
    <div class="col-sm-2">
    <label>บาท</label>
    </div> 
</div> 



<div class="row push">
    <div class="col-sm-3">
    <label>เปอร์เซ็นภาษี :</label>
    </div> 
    <div class="col-lg-9">
       -
    </div>  
 
</div> 

<div class="row push">
    <div class="col-sm-3">
    <label>เป็นเงิน :</label>
    </div> 
    <div class="col-lg-7">
   -
    </div> 
    <div class="col-sm-2">
    <label>บาท</label>
    </div>  
</div> 

<div class="row push">
    <div class="col-sm-3">
    <label>รวมราคาสุทธิ :</label>
    </div> 
    <div class="col-lg-7">
    '.number_format($pricesum-$discountnum,5).'
    </div> 
    <div class="col-sm-2">
    <label>บาท</label>
    </div>  
</div> ';
 }

echo $output;
    
}    
//===============================ฟังชั่นพิมพ์


public function detailprint(Request $request)
{

  $id =  $request->id;

  $infosupcon = DB::table('supplies_con')
  ->leftJoin('supplies_buy','supplies_con.BUY_ID','=','supplies_buy.BUY_ID')
  ->where('ID','=',$id)->first();

$output=' 

<div class="row">
<div class="col-sm-2" align="left">
<label>เลขทะเบียนคุม</label>
</div>
<div class="col-sm-4" align="left">
'.$infosupcon->CON_NUM.'
</div>
<div class="col-sm-2" align="left">
<label>ปีงบประมาณ</label>
</div>
<div class="col-sm-4" align="left">
'.$infosupcon->CON_YEAR_ID.'
</div>

</div>

<div class="row">
<div class="col-sm-2" align="left">
<label>วิธีการจัดซื้อ</label>
</div>
<div class="col-sm-4" align="left">
'.$infosupcon->BUY_NAME.'
</div>
<div class="col-sm-2" align="left">
<label>งบประมาณ</label>
</div>
<div class="col-sm-4" align="left">
'.number_format($infosupcon->BUDGET_SUM,5).'
</div>
</div>
<div class="row">
<div class="col-sm-2" align="left">
<label>หน่วยงานที่ต้องการ</label>
</div>
<div class="col-sm-4" align="left">
'.$infosupcon->DEP_REQUEST_NAME.'
</div>
<div class="col-sm-2" align="left">
<label>เจ้าหน้าที่</label>
</div>
<div class="col-sm-4" align="left">
'.$infosupcon->PERSON_REQUEST_NAME.'
</div>
</div>

<div class="row">
<div class="col-sm-2" align="left">
<label>ลักษณะ</label>
</div>
<div class="col-sm-4" align="left">
'.$infosupcon->CON_DETAIL.'
</div>
<div class="col-sm-2" align="left">
<label>เหตุผล</label>
</div>
<div class="col-sm-4" align="left">
'.$infosupcon->RESON_NAME.'
</div>

</div>

<div class="row">
<div class="col-sm-2" align="left">
<label>บริษัท</label>
</div>
<div class="col-sm-10" align="left">
'.$infosupcon->VENDOR_NAME.'
</div>


</div>

<div class="row">
<br>
</div>



<div class="row">
<div class="col-sm-4" align="left">

<a class="dropdown-item"  href="'.url('manager_supplies/pdfdirecdetail/export_pdfdirecdetail/'.$infosupcon->ID).'"  style="font-family: \'Kanit\', sans-serif; font-size: 15px;font-weight:normal;" target="_blank">[1] ขออนุมัติแต่งตั้ง กก. กำหนดรายละเอียด</a>
</div>
<div class="col-sm-4" align="left">

<a class="dropdown-item"  href="'.url('manager_supplies/pdfresult/export_pdfresult/'.$infosupcon->ID).'"  style="font-family: \'Kanit\', sans-serif; font-size: 15px;font-weight:normal;" target="_blank">[6] รายงานผลการพิจารณาและขออนุมัติสั่งซื้อสั่งจ้าง</a>
</div>
<div class="col-sm-4" align="left">
<a class="dropdown-item"  href="'.url('manager_supplies/pdfinnocent/export_pdfinnocent/'.$infosupcon->ID).'"  style="font-family: \'Kanit\', sans-serif; font-size: 15px;font-weight:normal;" target="_blank">[11] แบบแสดงความบริสุทธิ์ใจ</a>
</div>

</div>

<div class="row">
<div class="col-sm-4" align="left">

<a class="dropdown-item"  href="'.url('manager_supplies/pdfdirecapp/export_pdfdirecapp/'.$infosupcon->ID).'"  style="font-family: \'Kanit\', sans-serif; font-size: 15px;font-weight:normal;" target="_blank">[2] ขอความเห็นชอบและรายงานผล</a>
</div>
<div class="col-sm-4" align="left">
<a class="dropdown-item"   href="'.url('manager_supplies/pdfwin/export_pdfwin/'.$infosupcon->ID).'"   style="font-family: \'Kanit\', sans-serif; font-size: 15px;font-weight:normal;" target="_blank">[7] ประกาศผู้ชนะการเสนอราคา</a>
</div>
<div class="col-sm-4" align="left">
<a class="dropdown-item"   href="'.url('manager_supplies/pdfaccount/export_pdfaccount/'.$infosupcon->ID).'"   style="font-family: \'Kanit\', sans-serif; font-size: 15px;font-weight:normal;" target="_blank">[12] ขออนุมัติจ่ายเงินบำรุง</a>
</div>

</div>

<div class="row">
<div class="col-sm-4" align="left">

<a class="dropdown-item"  href="'.url('manager_supplies/pdfheadstyle/export_pdfheadstyle/'.$infosupcon->ID).'"   style="font-family: \'Kanit\', sans-serif; font-size: 15px;font-weight:normal;" target="_blank">[3] ขออนุมัติจัดซื้อจัดจ้าง</a>
</div>
<div class="col-sm-4" align="left">
<a class="dropdown-item"  href="'.url('manager_supplies/pdfpuchase/export_pdfpuchase/'.$infosupcon->ID).'"  style="font-family: \'Kanit\', sans-serif; font-size: 15px;font-weight:normal;" target="_blank">[8] ใบสั่งซื้อ/สั่งจ้าง</a>
</div>
<div class="col-sm-4" align="left">

</div>

</div>

<div class="row">
<div class="col-sm-4" align="left">

<a class="dropdown-item"  href="'.url('manager_supplies/pdfstyle/export_pdfstyle/'.$infosupcon->ID).'"   style="font-family: \'Kanit\', sans-serif; font-size: 15px;font-weight:normal;" target="_blank">[4] รายการคุณลักษณะพัสดุ</a>
</div>
<div class="col-sm-4" align="left">
<a class="dropdown-item"  href="'.url('manager_supplies/pdfcheck/export_pdfcheck/'.$infosupcon->ID).'"   style="font-family: \'Kanit\', sans-serif; font-size: 15px;font-weight:normal;" target="_blank">[9] ใบตรวจรับการจัดซื้อ/จัดจ้าง</a>
</div>
<div class="col-sm-4" align="left">

</div>

</div>

<div class="row">
<div class="col-sm-4" align="left">
<a class="dropdown-item"  href="'.url('manager_supplies/pdfmemo/export_pdfmemo/'.$infosupcon->ID).'"   style="font-family: \'Kanit\', sans-serif; font-size: 15px;font-weight:normal;" target="_blank">[5] บันทึกข้อความรายงานการขอซื้อ</a>

</div>
<div class="col-sm-4" align="left">
<a class="dropdown-item"  href="'.url('manager_supplies/pdftestresult/export_pdftestresult/'.$infosupcon->ID).'"    style="font-family: \'Kanit\', sans-serif; font-size: 15px;font-weight:normal;" target="_blank">[10] รายงานผลการตรวจรับ</a>
</div>
<div class="col-sm-4" align="left">

</div>

</div>';





echo $output;



}

//===============================ฟังชั่นโคลน


public function detailfsn(Request $request)
{

  $id =  $request->id;

  $infoasset = DB::table('asset_article')
  ->select('supplies.ID','ARTICLE_NUM')
  ->leftjoin('supplies','supplies.SUP_FSN_NUM','=','asset_article.SUP_FSN')
  ->where('ARTICLE_ID','=',$id)->first();

  $output = '<input  type="text" name="FSN_NUMBER" class="form-control input-sm " style=" font-family: \'Kanit\', sans-serif;" value="'.$infoasset->ARTICLE_NUM.'" />
  <input type="hidden" type="text" name="ASSET_ID" value="'.$id.'" />
  <input type="hidden" type="text" name="ID_SUP" value="'.$infoasset->ID.'" />';



echo $output;



}




public function detailfsn_save(Request $request)
{
   

 
     $idasset = $request->ASSET_ID;
     $idsup  = $request->ID_SUP;

     $check = DB::table('asset_article')->where('ARTICLE_NUM','=',$request->FSN_NUMBER)->count();

     $infoasset = DB::table('asset_article')->where('ARTICLE_ID','=',$idasset)->first();

    $addinfoarticle = new Assetarticle(); 
    $addinfoarticle->ARTICLE_NUM = $request->FSN_NUMBER;
    $addinfoarticle->YEAR_ID = $infoasset->YEAR_ID;
    $addinfoarticle->ARTICLE_NAME = $infoasset->ARTICLE_NAME;
    $addinfoarticle->ARTICLE_PROP = $infoasset->ARTICLE_PROP;
    $addinfoarticle->UNIT_ID = $infoasset->UNIT_ID;
    $addinfoarticle->SERIAL_NO = $infoasset->SERIAL_NO;
    $addinfoarticle->BRAND_ID = $infoasset->BRAND_ID;
    $addinfoarticle->COLOR_ID = $infoasset->COLOR_ID;
    $addinfoarticle->MODEL_ID = $infoasset->MODEL_ID;
    $addinfoarticle->SIZE_ID = $infoasset->SIZE_ID;
    $addinfoarticle->PRICE_PER_UNIT = $infoasset->PRICE_PER_UNIT;
    $addinfoarticle->RECEIVE_DATE = $infoasset->RECEIVE_DATE;
    $addinfoarticle->METHOD_ID = $infoasset->METHOD_ID;
    $addinfoarticle->BUY_ID = $infoasset->BUY_ID;
    $addinfoarticle->BUDGET_ID = $infoasset->BUDGET_ID;
    $addinfoarticle->TYPE_ID = $infoasset->TYPE_ID;
    $addinfoarticle->DECLINE_ID = $infoasset->DECLINE_ID;
    $addinfoarticle->VENDOR_ID = $infoasset->VENDOR_ID;
    $addinfoarticle->DEP_ID = $infoasset->DEP_ID;
    $addinfoarticle->LOCATION_ID = $infoasset->LOCATION_ID;
    $addinfoarticle->LOCATION_LEVEL_ID = $infoasset->LOCATION_LEVEL_ID;
    $addinfoarticle->LEVEL_ROOM_ID = $infoasset->LEVEL_ROOM_ID;
    $addinfoarticle->PERSON_ID = $infoasset->PERSON_ID;
    $addinfoarticle->REMARK = $infoasset->REMARK;
    $addinfoarticle->STATUS_ID = $infoasset->STATUS_ID;
    $addinfoarticle->OLD_USE = $infoasset->OLD_USE;

    $addinfoarticle->EXPIRE_DATE = $infoasset->EXPIRE_DATE;

    $addinfoarticle->PM_TYPE_ID = $infoasset->PM_TYPE_ID;
    $addinfoarticle->CAL_TYPE_ID = $infoasset->CAL_TYPE_ID;
    $addinfoarticle->RISK_TYPE_ID = $infoasset->RISK_TYPE_ID;
  
    $addinfoarticle->OPENS = 'False';
    $addinfoarticle->SUP_FSN = $infoasset->SUP_FSN;

    $addinfoarticle->IMG = $infoasset->IMG;   
       
    if($check == 0){
        $addinfoarticle->save();
    }
    


    return redirect()->route('msupplies.suppliesinfoinasset',[
        'id' =>   $idsup ,
    ]);
}
//======================ฟังชั่น====================

function checksummoney(Request $request)
{

  $SUP_TOTAL = $request->get('SUP_TOTAL');
  $PRICE_PER_UNIT = $request->get('PRICE_PER_UNIT');

  $sum = $SUP_TOTAL*$PRICE_PER_UNIT;

  $output = '<input type="hidden" type="text" name="sum" value="'.$sum.'" /><div style="text-align: right; margin-right: 10px;font-size: 14px;">'.number_format($sum,5).'</div>';
  echo $output;

}


function checkunitref(Request $request)
{

  $SUP_ID = $request->get('SUP_ID');
  $SUP_UNIT_ID_H = $request->get('SUP_UNIT_ID_H');

  $infounits = DB::table('supplies_unit_ref')->where('SUP_ID','=',$SUP_ID)->get();

  $output = ' 
  <select name="SUP_UNIT_ID[]" id="SUP_UNIT_ID[]" class="form-control input-sm " style=" font-family: \'Kanit\', sans-serif;" >
   ';                                                           
  foreach ($infounits as $infounit) {
      if($infounit->ID == $SUP_UNIT_ID_H){
        $output.=' <option value="'.$infounit->ID.'" selected>'.$infounit->SUP_UNIT_NAME.'</option>';
      }else{
        $output.=' <option value="'.$infounit->ID.'">'.$infounit->SUP_UNIT_NAME.'</option>';
      }


    
    }      
                         
$output.='</select> ';
  echo $output;

}




//=======================================PDF FILE====================================

function suppliesinfoinassetbarcodepdf(Request $request,$id)
{


  $infosupplies= Supplies::where('ID','=',$id)
  ->first();

    $pdf = PDF::loadView('manager_supplies.suppliesinfoinassetbarcodepdf',[
      
        'infosupplies' => $infosupplies,              
    ]);
    return @$pdf->stream();

}






















//====ใบอนุมัติแต่งตั้งคณะกรรมการรายละเอียด
function pdfdirecdetail(Request $request,$idref)
{

    $infoorg = DB::table('info_org')->where('ORG_ID','=',1)
    ->leftJoin('hrd_person','hrd_person.ID','=','info_org.ORG_LEADER_ID')
    ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->first();

    $inforcon = DB::table('supplies_con')
    ->leftJoin('supplies_buy','supplies_con.BUY_ID','=','supplies_buy.BUY_ID')
    ->leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
    ->where('ID','=',$idref)->first();
    $inforconquotation = DB::table('supplies_con_quotation')->where('QUOTATION_CON_NUM','=',$inforcon->CON_NUM)
    ->leftJoin('supplies_vendor','supplies_vendor.VENDOR_ID','=','supplies_con_quotation.QUOTATION_VENDOR_ID')
    ->where('QUOTATION_WIN','=',1)->first();

    
    $hrddepartment = DB::table('hrd_department')->where('HR_DEPARTMENT_ID','=',1)->first();

    $boarddetail = DB::table('supplies_con_board_detail')
    ->leftJoin('supplies_position','supplies_position.POSITION_ID','=','supplies_con_board_detail.SUP_POSITION_DETAIL_ID')
    ->where('CON_ID','=',$idref)->orderBy('SUP_POSITION_DETAIL_ID', 'asc') ->get();

    if($inforcon->SUP_TYPE_ID == '23' && $inforcon->RESON_NAME <> ''){
        $infotypebuy = 'จ้าง'.$inforcon->RESON_NAME;
    }else{

        $infotypebuy = 'ซื้อ'.$inforcon->SUP_TYPE_NAME;
    }
    
 
    $pdf = PDF::loadView('manager_supplies.pdfdirecdetail',[
        'infoorg' => $infoorg,
        'inforcon' => $inforcon,
        'inforconquotation' => $inforconquotation,  
        'hrddepartment' => $hrddepartment,  
        'boarddetails' => $boarddetail,  
        'infotypebuy' => $infotypebuy,             
    ]);
    return @$pdf->stream();

}

//====ใบขอความเห็นรายงานผล
function pdfdirecapp(Request $request,$idref)
{

    $infoorg = DB::table('info_org')->where('ORG_ID','=',1)
    ->leftJoin('hrd_person','hrd_person.ID','=','info_org.ORG_LEADER_ID')
    ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->first();

    $inforcon = DB::table('supplies_con')
    ->leftJoin('supplies_buy','supplies_con.BUY_ID','=','supplies_buy.BUY_ID')
    ->leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
    ->where('ID','=',$idref)->first();
    $inforconquotation = DB::table('supplies_con_quotation')->where('QUOTATION_CON_NUM','=',$inforcon->CON_NUM)
    ->leftJoin('supplies_vendor','supplies_vendor.VENDOR_ID','=','supplies_con_quotation.QUOTATION_VENDOR_ID')
    ->where('QUOTATION_WIN','=',1)->first();

    
    $hrddepartment = DB::table('hrd_department')->where('HR_DEPARTMENT_ID','=',1)->first();


    $boarddetail = DB::table('supplies_con_board_detail')
    ->leftJoin('supplies_position','supplies_position.POSITION_ID','=','supplies_con_board_detail.SUP_POSITION_DETAIL_ID')
    ->where('CON_ID','=',$idref)->orderBy('SUP_POSITION_DETAIL_ID', 'asc') ->get();
 
    $pdf = PDF::loadView('manager_supplies.pdfdirecapp',[
        'infoorg' => $infoorg,
        'inforcon' => $inforcon,
        'inforconquotation' => $inforconquotation,  
        'hrddepartment' => $hrddepartment,
        'boarddetails' => $boarddetail,                 
    ]);
    return @$pdf->stream();

}





function pdftestresult(Request $request,$idref)
{

    $infoorg = DB::table('info_org')->where('ORG_ID','=',1)
    ->leftJoin('hrd_person','hrd_person.ID','=','info_org.ORG_LEADER_ID')
    ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->first();

    $inforcon = DB::table('supplies_con')
    ->leftJoin('supplies_buy','supplies_con.BUY_ID','=','supplies_buy.BUY_ID')
    ->leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
    ->where('ID','=',$idref)->first();
    $inforconquotation = DB::table('supplies_con_quotation')->where('QUOTATION_CON_NUM','=',$inforcon->CON_NUM)
    ->leftJoin('supplies_vendor','supplies_vendor.VENDOR_ID','=','supplies_con_quotation.QUOTATION_VENDOR_ID')
    ->where('QUOTATION_WIN','=',1)->first();

    
    $hrddepartment = DB::table('hrd_department')->where('HR_DEPARTMENT_ID','=',1)->first();


    $inforconquotation = DB::table('supplies_con_quotation')->where('QUOTATION_CON_NUM','=',$inforcon->CON_NUM)
    ->leftJoin('supplies_vendor','supplies_vendor.VENDOR_ID','=','supplies_con_quotation.QUOTATION_VENDOR_ID')
    ->where('QUOTATION_WIN','=',1)->first();

    if($inforcon->SUP_TYPE_ID == '23' && $inforcon->RESON_NAME <> ''){
        $infotypebuy = $inforcon->RESON_NAME;
    }else{

        $infotypebuy = $inforcon->SUP_TYPE_NAME;
    }
 
    $pdf = PDF::loadView('manager_supplies.pdftestresult',[
        'infoorg' => $infoorg,
        'inforcon' => $inforcon,
        'inforconquotation' => $inforconquotation,  
        'hrddepartment' => $hrddepartment,    
        'infotypebuy' => $infotypebuy,           
    ]);
    return @$pdf->stream();

}

function pdfwant(Request $request,$idref)
{

    $infoorg = DB::table('info_org')->where('ORG_ID','=',1)
    ->leftJoin('hrd_person','hrd_person.ID','=','info_org.ORG_LEADER_ID')
    ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->first();

    $inforsuprequest = DB::table('supplies_request')->where('ID','=',$idref)->first();

    $inforsuprequestsub = DB::table('supplies_request_sub')->where('SUPPLIES_REQUEST_ID','=',$idref)->get();
 
    $html =  view('manager_supplies.pdfwant',[
        'infoorg' => $infoorg,
        'inforsuprequest' => $inforsuprequest,
        'inforsuprequestsubs' => $inforsuprequestsub,
    ]);
    return viewPdf($html);

}


function pdfmemo(Request $request,$idref)
{


    $infoorg = DB::table('info_org')->where('ORG_ID','=',1)
    ->leftJoin('hrd_person','hrd_person.ID','=','info_org.ORG_LEADER_ID')
    ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->first();

    $inforcon = DB::table('supplies_con')
    ->leftJoin('supplies_buy','supplies_con.BUY_ID','=','supplies_buy.BUY_ID')
    ->leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
    ->leftJoin('supplies_budget','supplies_con.BUDGET_ID','=','supplies_budget.BUDGET_ID')
    ->leftJoin('supplies_aspect','supplies_con.ASPECT_ID','=','supplies_aspect.ASPECT_ID')
    ->leftJoin('supplies_request','supplies_con.REQUEST_ID','=','supplies_request.ID')
    ->leftJoin('hrd_person','supplies_con.COMMIT_HR_ID','=','hrd_person.ID')
    ->leftJoin('hrd_level','hrd_level.HR_LEVEL_ID','=','hrd_person.HR_LEVEL_ID')
    ->where('supplies_con.ID','=',$idref)->first();
    $inforconquotation = DB::table('supplies_con_quotation')->where('QUOTATION_CON_NUM','=',$inforcon->CON_NUM)
    ->leftJoin('supplies_vendor','supplies_vendor.VENDOR_ID','=','supplies_con_quotation.QUOTATION_VENDOR_ID')
    ->where('QUOTATION_WIN','=',1)->first();

    
    $hrddepartment = DB::table('hrd_department')->where('HR_DEPARTMENT_ID','=',1)->first();


    $board = DB::table('supplies_con_board')
    ->leftJoin('supplies_position','supplies_position.POSITION_ID','=','supplies_con_board.SUP_POSITION_ID')
    ->where('CON_ID','=',$idref)->orderBy('SUP_POSITION_ID', 'asc') ->get();
 
    if($inforcon->SUP_TYPE_ID == '23' && $inforcon->RESON_NAME <> ''){
        $infotypebuy = $inforcon->RESON_NAME;
    }else{

        $infotypebuy = $inforcon->SUP_TYPE_NAME;
    }


    $pdf = PDF::loadView('manager_supplies.pdfmemo',[
        'infoorg' => $infoorg,
        'inforcon' => $inforcon,
        'inforconquotation' => $inforconquotation,  
        'hrddepartment' => $hrddepartment,    
        'boards' => $board, 
        'infotypebuy' => $infotypebuy,            
    ]);
    return @$pdf->stream();

}

//------ใบตรวจรับการจัดซื้อจัดจ้าง

function pdfcheck(Request $request,$idref)
{
    $infoorg = DB::table('info_org')->where('ORG_ID','=',1)
    ->leftJoin('hrd_person','hrd_person.ID','=','info_org.ORG_LEADER_ID')
    ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->first();

    $inforcon = DB::table('supplies_con')
    ->leftJoin('supplies_buy','supplies_con.BUY_ID','=','supplies_buy.BUY_ID')
    ->leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
    ->where('ID','=',$idref)->first();
      
 
    $hrddepartment = DB::table('hrd_department')->where('HR_DEPARTMENT_ID','=',1)->first();

    $inforconquotation = DB::table('supplies_con_quotation')->where('QUOTATION_CON_NUM','=',$inforcon->CON_NUM)
    ->leftJoin('supplies_vendor','supplies_vendor.VENDOR_ID','=','supplies_con_quotation.QUOTATION_VENDOR_ID')
    ->where('QUOTATION_WIN','=',1)->first();

    $conboardhread = DB::table('supplies_con_board')
    ->where(function($q){
        $q->where('SUP_POSITION_ID','=','1')
           -> orwhere('SUP_POSITION_ID','=','6');  
    })
    ->where('CON_ID','=',$idref)->first();

   // dd($conboardhread);
    if($conboardhread == null){
        $conboardhread ='';
    }else{
        $conboardhread = $conboardhread; 
    }


    $conboard = DB::table('supplies_con_board')->where('SUP_POSITION_ID','<>',1 )->where('SUP_POSITION_ID','<>',6 )->limit(2)->where('CON_ID','=',$idref)->get();
 
 
    if($inforcon->SUP_TYPE_ID == '23' && $inforcon->RESON_NAME <> ''){
        $infotypebuy = $inforcon->RESON_NAME;
    }else{

        $infotypebuy = $inforcon->SUP_TYPE_NAME;
    }

    $pdf = PDF::loadView('manager_supplies.pdfcheck',[
        'infoorg'=>$infoorg,
        'inforcon'=>$inforcon,
        'hrddepartment'=>$hrddepartment,
        'inforconquotation'=>$inforconquotation,
        'conboardhread'=>$conboardhread,
        'conboards'=>$conboard,
        'infotypebuy'=>$infotypebuy,
    ]);
    return @$pdf->stream();

}

//------ประกาศผู้ชนะ
function pdfwin(Request $request,$idref)
{
    $infoorg = DB::table('info_org')->where('ORG_ID','=',1)
    ->leftJoin('hrd_person','hrd_person.ID','=','info_org.ORG_LEADER_ID')
    ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->first();

    $inforcon = DB::table('supplies_con')
    ->leftJoin('supplies_buy','supplies_con.BUY_ID','=','supplies_buy.BUY_ID')
    ->leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
    ->where('ID','=',$idref)->first();
    $inforconquotation = DB::table('supplies_con_quotation')->where('QUOTATION_CON_NUM','=',$inforcon->CON_NUM)
    ->leftJoin('supplies_vendor','supplies_vendor.VENDOR_ID','=','supplies_con_quotation.QUOTATION_VENDOR_ID')
    ->where('QUOTATION_WIN','=',1)->first();

    if($inforcon->SUP_TYPE_ID == '23' && $inforcon->RESON_NAME <> ''){
        $infotypebuy = $inforcon->RESON_NAME;
    }else{

        $infotypebuy = $inforcon->SUP_TYPE_NAME;
    }
     

    $pdf = PDF::loadView('manager_supplies.pdfwin',[
        'infoorg' => $infoorg,
        'inforcon' => $inforcon,
        'inforconquotation' => $inforconquotation,
        'infotypebuy' => $infotypebuy,
        
    ]);
    return @$pdf->stream();

}
//------แสดงความบริสุทธิใจ
function pdfinnocent(Request $request,$idref)
{

    $inforcon = DB::table('supplies_con')
    ->leftJoin('supplies_buy','supplies_con.BUY_ID','=','supplies_buy.BUY_ID')
    ->leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
    ->where('ID','=',$idref)->first();

    $conboardhread = DB::table('supplies_con_board')
    ->where(function($q){
        $q->where('SUP_POSITION_ID','=','1')
           -> orwhere('SUP_POSITION_ID','=','6');  
    })
    ->where('CON_ID','=',$idref)->first();


    if($conboardhread == null){
        $conboardhread ='';
    }else{
        $conboardhread = $conboardhread; 
    }


    $conboard = DB::table('supplies_con_board')->where('SUP_POSITION_ID','<>',1 )->where('SUP_POSITION_ID','<>',6 )->limit(2)->where('CON_ID','=',$idref)->get();
 
    $pdf = PDF::loadView('manager_supplies.pdfinnocent',[
        'inforcon'=>$inforcon,
        'conboardhread'=>$conboardhread,
        'conboards'=>$conboard,
    ]);
    return @$pdf->stream();

}

//------รายการคุณลักษณะพัสดุ
function pdfheadstyle(Request $request,$idref)
{

    $infoorg = DB::table('info_org')->where('ORG_ID','=',1)
    ->leftJoin('hrd_person','hrd_person.ID','=','info_org.ORG_LEADER_ID')
    ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->first();

    $inforcon = DB::table('supplies_con')
    ->leftJoin('supplies_buy','supplies_con.BUY_ID','=','supplies_buy.BUY_ID')
    ->leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
    ->where('ID','=',$idref)->first();

 
    $hrddepartment = DB::table('hrd_department')->where('HR_DEPARTMENT_ID','=',1)->first();

    $infocon = DB::table('supplies_con_list')
    ->select('supplies_con_list.SUP_NAME','supplies_con_list.SUP_TOTAL','supplies_unit_ref.SUP_UNIT_NAME','supplies_con_list.PRICE_PER_UNIT','supplies_con_list.PRICE_SUM')
    ->leftJoin('supplies_unit_ref','supplies_con_list.SUP_UNIT_ID','=','supplies_unit_ref.ID')
    ->where('CON_ID','=',$idref)->get();

    $position = DB::table('hrd_person')->where('ID','=',$inforcon->PERSON_REQUEST_ID)->first();

    if($inforcon->SUP_TYPE_ID == '23' && $inforcon->RESON_NAME <> ''){
        $infotypebuy = $inforcon->RESON_NAME;
    }else{

        $infotypebuy = $inforcon->SUP_TYPE_NAME.'  '.$inforcon->RESON_NAME;
    }
 
    $pdf = PDF::loadView('manager_supplies.pdfheadstyle',[
      'infoorg' => $infoorg,
      'inforcon'  => $inforcon,
      'position'  => $position,
      'hrddepartment'  => $hrddepartment, 
      'infocons'  => $infocon, 
      'infotypebuy'  => $infotypebuy,
    ]);
    return @$pdf->stream();

}

//------รายการคุณลักษณะพัสดุ
function pdfstyle(Request $request,$idref)
{

    $infoorg = DB::table('info_org')->where('ORG_ID','=',1)
    ->leftJoin('hrd_person','hrd_person.ID','=','info_org.ORG_LEADER_ID')
    ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->first();

    $inforcon = DB::table('supplies_con')
    ->leftJoin('supplies_buy','supplies_con.BUY_ID','=','supplies_buy.BUY_ID')
    ->leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
    ->where('ID','=',$idref)->first();

 
    $hrddepartment = DB::table('hrd_department')->where('HR_DEPARTMENT_ID','=',1)->first();

    $infocon = DB::table('supplies_con_list')
    ->select('supplies_con_list.SUP_NAME','supplies_con_list.SUP_TOTAL','supplies_unit_ref.SUP_UNIT_NAME','supplies_con_list.PRICE_PER_UNIT','supplies_con_list.PRICE_SUM')
    ->leftJoin('supplies_unit_ref','supplies_con_list.SUP_UNIT_ID','=','supplies_unit_ref.ID')
    ->where('CON_ID','=',$idref)->get();
 
    $pdf = PDF::loadView('manager_supplies.pdfstyle',[
      'infoorg' => $infoorg,
      'inforcon'  => $inforcon,
      'hrddepartment'  => $hrddepartment, 
      'infocons'  => $infocon, 
    ]);
    return @$pdf->stream();

}

//------รายงานผลการพิจารณา
function pdfresult(Request $request,$idref)
{
    $infoorg = DB::table('info_org')->where('ORG_ID','=',1)
    ->leftJoin('hrd_person','hrd_person.ID','=','info_org.ORG_LEADER_ID')
    ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->first();

    $inforcon = DB::table('supplies_con')
    ->leftJoin('supplies_buy','supplies_con.BUY_ID','=','supplies_buy.BUY_ID')
    ->leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
    ->leftJoin('supplies_request','supplies_con.REQUEST_ID','=','supplies_request.ID')
    ->leftJoin('hrd_person','supplies_con.COMMIT_HR_ID','=','hrd_person.ID')
    ->leftJoin('hrd_level','hrd_level.HR_LEVEL_ID','=','hrd_person.HR_LEVEL_ID')
    ->where('supplies_con.ID','=',$idref)->first();

 
    $hrddepartment = DB::table('hrd_department')->where('HR_DEPARTMENT_ID','=',1)->first();

    $infoconlist = DB::table('supplies_con_list')
    ->select('supplies_con_list.SUP_NAME','supplies_con_list.SUP_TOTAL','supplies_unit_ref.SUP_UNIT_NAME','supplies_con_list.PRICE_PER_UNIT','supplies_con_list.PRICE_SUM')
    ->leftJoin('supplies_unit_ref','supplies_con_list.SUP_UNIT_ID','=','supplies_unit_ref.ID')
    ->where('CON_ID','=',$idref)->get();

    $infosum = DB::table('supplies_con')->where('ID','=',$idref)->first();
     
  $id = $inforcon->TAX_TYPE;
  $pricesum = $infosum->BUDGET_SUM;
  $disc =  $inforcon->DISCOUNT;


  if($disc == '' ||  $disc == null){
    $discountnum = 0;
  }else{
    $discountnum =  $disc;
  }



  $tex =$pricesum*(7/100);

  $totalsum = number_format($pricesum,2);


  $resuletaxin = ($pricesum*100)/107;
  $texin =  $pricesum - $resuletaxin;
 
 if($id == 1){
    $totalsum_real = $resuletaxin;
    $texreal = number_format($texin,2);
    $total = number_format($pricesum-$discountnum,2); 
                                                
               
 }else if($id == 2){

    $totalsum_real = $pricesum;
    $texreal = number_format($tex,2);
    $total = number_format($pricesum + $tex - $discountnum ,2);
   
 }else{  

    $totalsum_real = $pricesum;
    $texreal = 0;
    $total = number_format($pricesum- $discountnum,2);
 }


 if($inforcon->SUP_TYPE_ID == '23' && $inforcon->RESON_NAME <> ''){
    $infotypebuy = $inforcon->RESON_NAME;
}else{

    $infotypebuy = $inforcon->SUP_TYPE_NAME;
}




    $pdf = PDF::loadView('manager_supplies.pdfresult',[
        'infoorg' => $infoorg,
        'inforcon' => $inforcon,
        'infoconlists' => $infoconlist,
        'hrddepartment' => $hrddepartment,
        'totalsum' =>$totalsum,
        'texreal' =>$texreal,
        'discountnum' =>$discountnum,
        'total' =>$total,
        'infotypebuy' =>$infotypebuy,
        'totalsum_real' =>$totalsum_real,
        ]);
    return @$pdf->stream();

}


//------รายการขออนุมัติบัญชี
function pdfaccount(Request $request,$idref)
{

    $infoorg = DB::table('info_org')->where('ORG_ID','=',1)
    ->leftJoin('hrd_person','hrd_person.ID','=','info_org.ORG_LEADER_ID')
    ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->first();

    $inforcon = DB::table('supplies_con')
    ->leftJoin('supplies_buy','supplies_con.BUY_ID','=','supplies_buy.BUY_ID')
    ->leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
    ->where('ID','=',$idref)->first();

 
    $hrddepartment = DB::table('hrd_department')->where('HR_DEPARTMENT_ID','=',1)->first();



    $inforconquotation = DB::table('supplies_con_quotation')->where('QUOTATION_CON_NUM','=',$inforcon->CON_NUM)
    ->leftJoin('supplies_vendor','supplies_vendor.VENDOR_ID','=','supplies_con_quotation.QUOTATION_VENDOR_ID')
    ->where('QUOTATION_WIN','=',1)->first();

    if($inforcon->SUP_TYPE_ID == '23' && $inforcon->RESON_NAME <> ''){
        $infotypebuy = $inforcon->RESON_NAME;
    }else{

        $infotypebuy = $inforcon->SUP_TYPE_NAME;
    }
 
    $pdf = PDF::loadView('manager_supplies.pdfaccount',[
        'infoorg' => $infoorg,
      'inforcon'  => $inforcon,
      'hrddepartment'  => $hrddepartment, 
      'inforconquotation'  => $inforconquotation,
      'infotypebuy'  => $infotypebuy,
    ]);
    return @$pdf->stream();

}

//------รายการขออนุมัติบัญชี
function pdfpuchase(Request $request,$idref)
{

    $infoorg = DB::table('info_org')->where('ORG_ID','=',1)
    ->leftJoin('hrd_person','hrd_person.ID','=','info_org.ORG_LEADER_ID')
    ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->first();

    $inforcon = DB::table('supplies_con')
    ->leftJoin('supplies_buy','supplies_con.BUY_ID','=','supplies_buy.BUY_ID')
    ->leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
    ->where('ID','=',$idref)->first();

 
    $hrddepartment = DB::table('hrd_department')->where('HR_DEPARTMENT_ID','=',1)->first();


    $inforconquotation = DB::table('supplies_con_quotation')->where('QUOTATION_CON_NUM','=',$inforcon->CON_NUM)
    ->leftJoin('supplies_vendor','supplies_vendor.VENDOR_ID','=','supplies_con_quotation.QUOTATION_VENDOR_ID')
    ->where('QUOTATION_WIN','=',1)->first();

    $infocon = DB::table('supplies_con_list')
    ->select('supplies_con_list.SUP_NAME','supplies_con_list.SUP_TOTAL','supplies_unit_ref.SUP_UNIT_NAME','supplies_con_list.PRICE_PER_UNIT','supplies_con_list.PRICE_SUM')
    ->leftJoin('supplies_unit_ref','supplies_con_list.SUP_UNIT_ID','=','supplies_unit_ref.ID')
    ->where('CON_ID','=',$idref)->get();


         
  $id = $inforcon->TAX_TYPE;
  $pricesum = $inforcon->BUDGET_SUM;
  $disc =  $inforcon->DISCOUNT;

  if($disc == '' ||  $disc == null){
    $discountnum = 0;
  }else{
    $discountnum =  $disc;
  }



  $tex =$pricesum*(7/100);

  $totalsum = number_format($pricesum,2);

  $resuletaxin = ($pricesum*100)/107;
  $texin =  $pricesum - $resuletaxin;


  
 
 if($id == 1){
    $totalsum_real = $resuletaxin;
    $texreal = number_format($texin,2);
    $total = number_format($pricesum-$discountnum,2);                                             
               
 }else if($id == 2){
    $totalsum_real = $pricesum;
    $texreal = number_format($tex,2);
    $total = number_format($pricesum + $tex - $discountnum ,2);
   
 }else{  
    $totalsum_real = $pricesum;
    $texreal = 0.00;
    $total = number_format($pricesum- $discountnum,2);
 }




 $DATE_WANT_COUNT = round(abs(strtotime($inforcon->SEND_DATE) - strtotime($inforcon->PO_DATE))/60/60/24)+1;
 
 if($inforcon->SUP_TYPE_ID == '23' && $inforcon->RESON_NAME <> ''){
    $infotypebuy = $inforcon->RESON_NAME;
}else{

    $infotypebuy = $inforcon->SUP_TYPE_NAME;
}


    $pdf = PDF::loadView('manager_supplies.pdfpuchase',[
        'infoorg' => $infoorg,
      'inforcon'  => $inforcon,
      'hrddepartment'  => $hrddepartment, 
      'inforconquotation'  => $inforconquotation,
      'infocons'  => $infocon,
      'totalsum' =>$totalsum,
      'texreal' =>$texreal,
      'discountnum' =>$discountnum,
      'total' =>$total,
      'DATE_WANT_COUNT' =>$DATE_WANT_COUNT,
      'infotypebuy' =>$infotypebuy,
      'totalsum_real' =>$totalsum_real,
    ]);
    return @$pdf->stream();

}

//------รายการคณะกรรมการ
function pdfboard(Request $request,$idref)
{


    $infoorg = DB::table('info_org')->where('ORG_ID','=',1)
    ->leftJoin('hrd_person','hrd_person.ID','=','info_org.ORG_LEADER_ID')
    ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->first();

    $inforcon = DB::table('supplies_con')
    ->leftJoin('supplies_buy','supplies_con.BUY_ID','=','supplies_buy.BUY_ID')
    ->leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
    ->where('ID','=',$idref)->first();

    $conboard = DB::table('supplies_con_board')
    ->leftJoin('supplies_position','supplies_position.POSITION_ID','=','supplies_con_board.SUP_POSITION_ID')
    ->where('CON_ID','=',$idref)->orderBy('SUP_POSITION_ID', 'asc') ->get();
 
    $pdf = PDF::loadView('manager_supplies.pdfboard',[
        'infoorg' => $infoorg,
      'inforcon'  => $inforcon,
      'conboards'  => $conboard, 
      
    ]);
    return @$pdf->stream();

}


//=====================================


public function sendifomation(Request $request,$id)
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
    
       
         //=====ส่งข้อมูลไปบัญชี=====

        

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



        return redirect()->route('msupplies.purchase');
}




   
function parcel(Request $request)
{
   
  $id = $request->get('select');

  if( $id < 10){
    $headnumber = '0'.$id;

 }else{
     $headnumber = $id;
 }

  $countcheck = DB::table('supplies')->where('SUP_FSN_NUM','like',$headnumber.'-%')->count();

  if($countcheck == 0){
      $lnumber = '00001';
  }else{
    
    $maxnumber = DB::table('supplies')->where('SUP_FSN_NUM','like',$headnumber.'-%')
    ->orderBy('SUP_FSN_NUM', 'desc')
    ->first();  
    $refmax = DB::table('supplies')->where('ID','=',$maxnumber->ID)->first();  


 
        $maxref = substr($refmax->SUP_FSN_NUM, -4)+1;
    

    $lnumber = str_pad($maxref, 5, "0", STR_PAD_LEFT);
  }


        $output = '
        <input name="SUP_FSN_NUM" id="SUP_FSN_NUM" class="form-control input-sm" style=" font-family: \'Kanit\', sans-serif;" value="'.$headnumber.'-'.$lnumber.'" readonly>
       ';


echo $output;
    
}
//=========================บันทึกขอซื้อ/ขอจ้าง=========

        public function usepurchase (Request $request,$id)
            {
                
                return view('manager_supplies.usepurchase'); 
            
            }


            public function persondevaccept_update(Request $request)
            {
            

            }


            public function usepurchasepdf01($id)
            {


                $pdf = PDF::loadView('manager_supplies.usepurchasepdf01');
                return @$pdf->stream();
            }

            public function usepurchasepdf02($id)
            {
     

                $pdf = PDF::loadView('manager_supplies.usepurchasepdf02');
                return @$pdf->stream();
            }





//=========================ขายออก=========
public static function refnumbersouldout()
    {   
            $m_budget = date("m");
            if($m_budget>9){
            $yearbudget = date("Y")+544;
            }else{
            $yearbudget = date("Y")+543;
            }
        $maxnumber = DB::table('supplies_soldout')->where('SOLDOUT_YEAR','=',$yearbudget)->max('SOLDOUT_ID');  

        if($maxnumber != '' ||  $maxnumber != null){
            
            $refmax = DB::table('supplies_soldout')->where('SOLDOUT_ID','=',$maxnumber)->first();  
            if($refmax->SOLDOUT_ID != '' ||  $refmax->SOLDOUT_ID != null){
                $maxref = substr($refmax->SOLDOUT_ID, -4)+1;
            }else{
                $maxref = 1;
            }
            $ref = str_pad($maxref, 4, "0", STR_PAD_LEFT);
        
        }else{
            $ref = '0001';
        }  
        $y = substr($yearbudget, -2);
        $refnumber ='SO'.$y.'-'.$ref;
        return $refnumber;
    }
public function infosoldout(Request $request){ 
                
    $soldout = Suppliessoldout::leftjoin('asset_article','asset_article.ARTICLE_ID','=','supplies_soldout.SOLDOUT_ARTICLE_ID')
    ->leftjoin('supplies_vendor','supplies_vendor.VENDOR_ID','=','supplies_soldout.SOLDOUT_WIN')
    ->get();

    return view('manager_supplies.infosoldout',[
        'soldout' => $soldout,
    ]);
}
public function infosoldout_add(Request $request){ 
                
    $budgetyear = DB::table('budget_year')->where('ACTIVE', '=', true)->get();

    $m_budget = date("m");
    if($m_budget>9){
      $yearbudget = date("Y")+544;
    }else{
      $yearbudget = date("Y")+543;
    }
    $article = DB::table('asset_article')->get();

    $suppliesvendor = DB::table('supplies_vendor')->get();

    return view('manager_supplies.infosoldout_add',[
        'budgetyears' => $budgetyear,
        'yearbudget' => $yearbudget,
        'article' => $article,
        'suppliesvendor'=>$suppliesvendor,
    ]);
}


public function infosoldout_save(Request $request) 
{
    $sd_date= $request->SOLDOUT_DATE;

    if($sd_date != ''){
        $STARTDAY = Carbon::createFromFormat('d/m/Y', $sd_date)->format('Y-m-d');
        $date_arrary_st=explode("-",$STARTDAY);  
        $y_sub_st = $date_arrary_st[0]; 
        
        if($y_sub_st >= 2500){
            $y_st = $y_sub_st-543;
        }else{
            $y_st = $y_sub_st;
        }
        $m_st = $date_arrary_st[1];
        $d_st = $date_arrary_st[2];  
        $sddate= $y_st."-".$m_st."-".$d_st;
        }else{
        $sddate= null;
    }

    $idarticle = $request->SOLDOUT_ARTICLE_ID;

    $add = new Suppliessoldout();
    $add->SOLDOUT_NO = $request->SOLDOUT_NO;
    $add->SOLDOUT_YEAR = $request->SOLDOUT_YEAR;
    $add->SOLDOUT_DATE = $sddate;

    $add->SOLDOUT_ARTICLE_ID = $idarticle;

    $add->SOLDOUT_DETAIL = $request->SOLDOUT_DETAIL;
    $add->SOLDOUT_WIN = $request->SOLDOUT_WIN;
    $add->SOLDOUT_PRICE = $request->SOLDOUT_PRICE;
    $add->SOLDOUT_COMMENT = $request->SOLDOUT_COMMENT;
    $add->SOLDOUT_STATUS = $request->SOLDOUT_STATUS;
    $add->save();

    $updatestatus = Vehiclecarindex::find($idarticle);
    $updatestatus->CAR_STATUS_ID = '3';
    $updatestatus->save();

    return redirect()->route('msupplies.infosoldout');     

}

public function infosoldout_edit(Request $request,$id){ 
                
    $budgetyear = DB::table('budget_year')->where('ACTIVE', '=', true)->get();

    $m_budget = date("m");
    if($m_budget>9){
      $yearbudget = date("Y")+544;
    }else{
      $yearbudget = date("Y")+543;
    }
    $article = DB::table('asset_article')->get();

    $suppliesvendor = DB::table('supplies_vendor')->get();

    $soldout = Suppliessoldout::leftjoin('asset_article','asset_article.ARTICLE_ID','=','supplies_soldout.SOLDOUT_ARTICLE_ID')
    ->leftjoin('supplies_vendor','supplies_vendor.VENDOR_ID','=','supplies_soldout.SOLDOUT_WIN')
    ->where('supplies_soldout.SOLDOUT_ID','=',$id)
    ->first();

    return view('manager_supplies.infosoldout_edit',[
        'budgetyears' => $budgetyear,
        'yearbudget' => $yearbudget,
        'article' => $article,
        'suppliesvendor'=>$suppliesvendor,
        'soldout'=>$soldout,
    ]);
}

public function infosoldout_update(Request $request) 
{
    $sd_date= $request->SOLDOUT_DATE;

    if($sd_date != ''){
        $STARTDAY = Carbon::createFromFormat('d/m/Y', $sd_date)->format('Y-m-d');
        $date_arrary_st=explode("-",$STARTDAY);  
        $y_sub_st = $date_arrary_st[0]; 
        
        if($y_sub_st >= 2500){
            $y_st = $y_sub_st-543;
        }else{
            $y_st = $y_sub_st;
        }
        $m_st = $date_arrary_st[1];
        $d_st = $date_arrary_st[2];  
        $sddate= $y_st."-".$m_st."-".$d_st;
        }else{
        $sddate= null;
    }

    $id = $request->SOLDOUT_ID;

    $idarticle = $request->SOLDOUT_ARTICLE_ID;

    $update = Suppliessoldout::find($id);
    $update->SOLDOUT_NO = $request->SOLDOUT_NO;
    $update->SOLDOUT_YEAR = $request->SOLDOUT_YEAR;
    $update->SOLDOUT_DATE = $sddate;
    
    $update->SOLDOUT_ARTICLE_ID = $idarticle;

    $update->SOLDOUT_DETAIL = $request->SOLDOUT_DETAIL;
    $update->SOLDOUT_WIN = $request->SOLDOUT_WIN;
    $update->SOLDOUT_PRICE = $request->SOLDOUT_PRICE;
    $update->SOLDOUT_COMMENT = $request->SOLDOUT_COMMENT;
    $update->SOLDOUT_STATUS = $request->SOLDOUT_STATUS;
    $update->save();

    $updatestatus = Vehiclecarindex::find($idarticle);
    $updatestatus->CAR_STATUS_ID = '3';
    $updatestatus->save();

    return redirect()->route('msupplies.infosoldout');     

}

public function infosoldout_delete(Request $request,$id) 
{
    Suppliessoldout::destroy($id);  

    return redirect()->route('msupplies.infosoldout');     

}

public function infosoldout_sub(){ 
                

    return view('manager_supplies.infosoldout_sub');
}


public static function unitname($idsup)
{
        $resule =  DB::table('supplies_unit_ref')
        ->where('SUP_ID','=',$idsup)
        ->where('SUP_TOTAL','=',1)
        ->first();
       
       

        if($resule !== null){
            $re = $resule->SUP_UNIT_NAME;
        }else{

            $re = '';
        }
         
    return $re;
}



public static function packingunitname($idsup)
{
        $resule =  DB::table('supplies_unit_ref')
        ->where('SUP_ID','=',$idsup)
        ->where('SUP_TOTAL','>',1)
        ->first();
       
       

        if($resule !== null){
            $re = $resule->SUP_UNIT_NAME;
        }else{

            $re = '';
        }
         
    return $re;
}





//------------------------------------------------------------

public function historybuy(Request $request)
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


        $infosup= DB::table('supplies')->where('ID','=',$request->id)->first();




        $infohisbuys= DB::table('supplies_con_list')
        ->leftJoin('supplies_con','supplies_con_list.CON_ID','=','supplies_con.ID')
        ->where('SUP_ID','=',$request->id)->get();

    //=========================

                        $output='

                        <div class="row push" style="font-family: \'Kanit\', sans-serif;">

                        <div class="col-sm-9">

                        <div class="row">
                            <div class="col-lg-2" align="right">
                            <label>รหัส :</label>
                            </div>
                            <div class="col-lg-4" align="left">
                            '.$infosup->SUP_FSN_NUM.'
                            </div>

                            <div class="col-lg-2" align="right">
                            <label>ชื่อพัสดุ :</label>
                            </div>
                            <div class="col-lg-4" align="left">
                            '.$infosup->SUP_NAME.'
                            </div>


                            </div>


                      
                        <br>
                        <div style="height:400px;overflow-y:scroll;">
                        <table>

                        <table class="table-bordered table-striped table-vcenter js-dataTable-simple" style="width: 100%;">
                        <thead style="background-color: #FFEBCD;">
                            <tr height="40">
                            <th  class="text-font" style="border-color:#F0FFFF;text-align: center;font-family: \'Kanit\', sans-serif; border: 1px solid black;" width="5%">ลำดับ</th>
                            <th  class="text-font" style="border-color:#F0FFFF;text-align: center;font-family: \'Kanit\', sans-serif; border: 1px solid black;" width="15%">วันที่ซื้อ</th>
                            <th  class="text-font" style="border-color:#F0FFFF;text-align: center;font-family: \'Kanit\', sans-serif; border: 1px solid black;"  >ผู้จำหน่าย</th>
                            <th  class="text-font" style="border-color:#F0FFFF;text-align: center;font-family: \'Kanit\', sans-serif; border: 1px solid black;"   width="10%">ราคาต่อหน่วย</th>
                            <th  class="text-font" style="border-color:#F0FFFF;text-align: center;font-family: \'Kanit\', sans-serif; border: 1px solid black;"   width="10%">จำนวน</th>

                            <th  class="text-font" style="border-color:#F0FFFF;text-align: center;font-family: \'Kanit\', sans-serif; border: 1px solid black;"   width="10%">ราคารวม</th>

                                    </tr>
                                    </thead>
                                    <tbody >';

                                     $number = 1;
                                              
                                    foreach ($infohisbuys as $infohisbuy) {
                                     
                                        
                                                            $output.='<tr>';
                                                            $output.='<td class="text-font " style="border: 1px solid black;" align="center">'.$number.'</td>
                                                            <td class="text-font text-pedding" style="border: 1px solid black;" align="left">'.DateThai($infohisbuy->DATE_REGIS).'</td>
                                                            <td class="text-font text-pedding" style="border: 1px solid black;" align="left">'.$infohisbuy->VENDOR_NAME.'</td>
                                                            <td class="text-font text-pedding" style="border: 1px solid black;" align="right">'.number_format($infohisbuy->PRICE_PER_UNIT,2).'</td>
                                                            <td class="text-font text-pedding" style="border: 1px solid black;" align="right">'.$infohisbuy->SUP_TOTAL.'</td>
                                                            <td class="text-font text-pedding" style="border: 1px solid black;" align="right">'.number_format($infohisbuy->PRICE_SUM,2).'</td>';
                                                            $output.='</tr>';

                                                            $number++;
                                    }
                                                         

                                                            $output.='</tbody ></table>

                                                                                    </div>
                                                                                    </div>

                                                                                    <div class="col-sm-3">

                                                                                    <div class="form-group">

                                                                                   
                                                                                      
                                                                                   
                                                                                    <img src="data:image/png;base64,'. chunk_split(base64_encode($infosup->IMG)) .'" id="image_upload_preview" alt="กรุณาเพิ่มรูปภาพ" height="200" width="200"/>
                                                                                    
                                                                                   
                                                                                    
                                                                                    
                                                                                    </div>

                                                                                    </div>
                                                                                    </div>
                                                                                    </div>
                                                                                    </div>';





                                                            echo $output;


}



//-------------------------ฟังชั่นเรียกรายละเอียด

function condition(Request $request)
    {
       
      $id = $request->get('select');
      $result=array();
      $query= DB::table('supplies_condision')->where('CONDISION_ID',$id)->first();
 
      

            $output = $query->CONDISION_RESION;


    echo $output;
        
    }

    function amountdate(Request $request)
    {
       
      $date_bigen = $request->get('date1');
      $date_end = $request->get('date2');
     
 
      if($date_bigen != ''){

        $date_bigen_c = Carbon::createFromFormat('d/m/Y', $date_bigen)->format('Y-m-d');
        $date_arrary=explode("-",$date_bigen_c);
  
        $y_sub = $date_arrary[0]; 
        
        if($y_sub >= 2500){
            $y = $y_sub-543;
        }else{
            $y = $y_sub;
        }
           
        $m = $date_arrary[1];
        $d = $date_arrary[2];  

        $displaydate_bigen= $y."-".$m."-".$d;
        }else{
        $displaydate_bigen= null;
        }

    if($date_end != ''){
        $date_end_c = Carbon::createFromFormat('d/m/Y', $date_end)->format('Y-m-d');
        $date_arrary_e=explode("-",$date_end_c);
        $y_sub = $date_arrary_e[0]; 
        
        if($y_sub >= 2500){
            $y_e = $y_sub-543;
        }else{
            $y_e = $y_sub;
        }
           
        $m_e = $date_arrary_e[1];
        $d_e = $date_arrary_e[2];  
        $displaydate_end= $y_e."-".$m_e."-".$d_e;
        }else{
        $displaydate_end= null;
        }

            $amountdate = round(abs(strtotime($displaydate_end) - strtotime($displaydate_bigen))/60/60/24)+1;

            $output =  '<input name="DATE_WANT_COUNT" id="" class="form-control input-sm" style=" font-family: \'Kanit\', sans-serif;" value="'.$amountdate.'">';

    echo $output;
        
    }


    
function theboard(Request $request)
{
   
  $id = $request->get('select');
  $result=array();
  $query= DB::table('supplies_con_board_list_person')->where('BOARD_GROUP_ID',$id)->get();

  $suppliespositions = DB::table('supplies_position')->get();
  $infopersons = DB::table('hrd_person')->where('HR_STATUS_ID','=',1)->get();

  $output='';
      
  foreach ($query as $row){

        $output.= '<tr height="40">
        <td>

            <select name="BOARD_HR_ID[]" id="BOARD_HR_ID[]" class="form-control input-sm " style=" font-family: \'Kanit\', sans-serif;" >
                        <option value="" selected>--กรุณาเลือก--</option>';
                        foreach ($infopersons as $infoperson) { 
                      
                             if($row->HR_ID == $infoperson->ID){
                                $output.= '<option value="'.$infoperson ->ID.'" selected>'.$infoperson->HR_FNAME.' '.$infoperson->HR_LNAME.'</option>'; 
                             }else{
                                $output.= '<option value="'.$infoperson ->ID.'">'.$infoperson->HR_FNAME.' '.$infoperson->HR_LNAME.'</option>'; 
                             }
                          
                       
                        
                        }
                        
                        $output.= '</select> 

        </td>
        <td>

            <select name="SUP_POSITION_ID[]" id="SUP_POSITION_ID[]" class="form-control input-sm " style=" font-family: \'Kanit\', sans-serif;" >
                            <option value="" selected>--กรุณาเลือก--</option>';

                            foreach ($suppliespositions as $suppliesposition)   

                            if($suppliesposition->POSITION_ID == $row->SUP_POSITION_ID){
                                $output.= '<option value="'. $suppliesposition ->POSITION_ID.'" selected>'.$suppliesposition->POSITION_NAME.'</option>'; 
                            }else{
                                $output.= '<option value="'. $suppliesposition ->POSITION_ID.'">'.$suppliesposition->POSITION_NAME.'</option>'; 
                            }
                      
                           
                     
                      
                
                        
                      $output.= '</select> 

            </td>
 
        <td style="text-align: center;"><a class="btn btn-danger remove" style="color:#FFFFFF;"><i class="fa fa-trash-alt"></i></a></td>
    </tr>';
    
    }
echo $output;

    
}


function calldatesend(Request $request)
{
    function formatedate($strDate)
    {
      $strYear = date("Y",strtotime($strDate));
      $strMonth= date("m",strtotime($strDate));
      $strDay= date("d",strtotime($strDate));
    
      return $strDay."/".$strMonth."/".$strYear;
      }  

    function expdate($startdate,$datenum){
        $startdatec=strtotime($startdate); 
        $tod=$datenum*86400; 
        $ndate=$startdatec+$tod;
        return $ndate;
    }

  $datecal = $request->get('datecal');
  $dataenow = date("Y-m-d H:i:s",time());
  $dr=expdate($dataenow,$datecal);
  $df=date("Y-m-d",$dr); 

        $output =  '<input name="SEND_DATE" id="SEND_DATE" class="form-control input-lg datepicker2 {{ $errors->has(\'SEND_DATE\') ? \'is-invalid\' : \'\' }}" data-date-format="mm/dd/yyyy"  style=" font-family: \'Kanit\', sans-serif;" value="'.formatedate($df).'"  readonly>';

echo $output;
    
}




//=====ฟังชั่นคำนวณภาษี_หน้าจ่ายของ=====

function fetchtaxcal_list(Request $request)
{
   
  $id = $request->get('select');
  $pricesum = $request->get('pricesum');

  $disc = $request->get('disc');

  if($disc == '' ){
    $discountnum = 0;
  }else{
    $discountnum =  $disc;
  }


  $tex =$pricesum*(7/100);

  $resuletaxin = ($pricesum*100)/107;
  $texin =  $pricesum - $resuletaxin;
 if($id == 1){
    $output = '<div class="row push">
    <div class="col-sm-3">
    <label>มูลค่าสินค้า :</label>
    </div> 
    <div class="col-lg-7">
        
        <input type="text" class="form-control input-sm" id="PRICESUM" name="PRICESUM" value="'.number_format($resuletaxin,5).'" readonly>
        </div> 
        <div class="col-sm-2">
        <label>บาท</label>
        </div>  
</div> 



<div class="row push">
    <div class="col-sm-3">
    <label>เปอร์เซ็นภาษี :</label>
    </div> 
    <div class="col-lg-9">
        7.00 %
    </div>  
</div> 

<div class="row push">
    <div class="col-sm-3">
    <label>เป็นเงิน :</label>
    </div> 
    <div class="col-lg-7">
    '.number_format($texin,5).'
    </div>
    <div class="col-sm-2">
    <label>บาท</label>
    </div>   
</div> 

<div class="row push">
    <div class="col-sm-3">
    <label>รวมราคาสุทธิ :</label>
    </div> 
    <div class="col-lg-7">
    '.number_format($pricesum-$discountnum,5).'
    <input type="hidden" class="form-control input-sm" id="PRICESUM_send" name="PRICESUM_send" value="'.number_format($pricesum-$discountnum,5,'.','').'">
    </div>  
    <div class="col-sm-2">
    <label>บาท</label>
    </div> 
</div> ';  
                                                
               
 }else if($id == 2){

    $output = '<div class="row push">
    <div class="col-sm-3">
    <label>มูลค่าสินค้า :</label>
    </div> 
    <div class="col-lg-7">
    <input type="text" class="form-control input-sm" id="PRICESUM" name="PRICESUM" value="'.number_format($pricesum,5).'" readonly>

    </div>  
    <div class="col-sm-2">
    <label>บาท</label>
    </div> 
</div> 



<div class="row push">
    <div class="col-sm-3">
    <label>เปอร์เซ็นภาษี :</label>
    </div> 
    <div class="col-lg-9">
        7.00 %
    </div>  
</div> 

<div class="row push">
    <div class="col-sm-3">
    <label>เป็นเงิน :</label>
    </div> 
    <div class="col-lg-7">
    '.number_format($tex,5).'
    </div>  
    <div class="col-sm-2">
    <label>บาท</label>
    </div> 
</div> 

<div class="row push">
    <div class="col-sm-3">
    <label>รวมราคาสุทธิ :</label>
    </div> 
    <div class="col-lg-7">
    '.number_format($pricesum + $tex - $discountnum ,5).'
    <input type="hidden" class="form-control input-sm" id="PRICESUM_send" name="PRICESUM_send" value="'.number_format($pricesum + $tex - $discountnum,5,'.','').'">
    </div> 
    <div class="col-sm-2">
    <label>บาท</label>
    </div>  
</div> ';
     
 }else{
    $output = '<div class="row push">
    <div class="col-sm-3">
    <label>มูลค่าสินค้า :</label>
    </div> 
    <div class="col-lg-7">
    <input type="text" class="form-control input-sm" id="PRICESUM" name="PRICESUM" value="'.number_format($pricesum,5).'" readonly>

    </div>  
    <div class="col-sm-2">
    <label>บาท</label>
    </div> 
</div> 



<div class="row push">
    <div class="col-sm-3">
    <label>เปอร์เซ็นภาษี :</label>
    </div> 
    <div class="col-lg-9">
       -
    </div>  
 
</div> 

<div class="row push">
    <div class="col-sm-3">
    <label>เป็นเงิน :</label>
    </div> 
    <div class="col-lg-7">
   -
    </div> 
    <div class="col-sm-2">
    <label>บาท</label>
    </div>  
</div> 

<div class="row push">
    <div class="col-sm-3">
    <label>รวมราคาสุทธิ :</label>
    </div> 
    <div class="col-lg-7">
    '.number_format($pricesum-$discountnum,5).'
    <input type="hidden" class="form-control input-sm" id="PRICESUM_send" name="PRICESUM_send" value="'.number_format($pricesum-$discountnum,5,'.','').'">
    </div> 
    <div class="col-sm-2">
    <label>บาท</label>
    </div>  
</div> ';
 }

echo $output;
    
}    


    



    //=====ฟังชั่น

    function selectvendor(Request $request)
    {
                $id = $request->get('idrefvendor');     

         
            $infovender  = DB::table('supplies_request')->where('ID','=', $id) ->first();

            $vendors =  DB::table('supplies_vendor')->where('ACTIVE','=','True')->get();
            $output='<option value="">--กรุณาเลือกบริษัท--</option>';
            
            foreach ($vendors as $vendor){
                   if($infovender->REQUEST_VANDOR_ID == $vendor->VENDOR_ID){
                    $output.= '<option value="'.$vendor->VENDOR_ID.'" selected>'.$vendor->VENDOR_NAME.'</option>';
                   }else{
                    $output.= '<option value="'.$vendor->VENDOR_ID.'">'.$vendor->VENDOR_NAME.'</option>';
                    }
                }

                 


    echo $output;        
    }

    //=====================================================================
    
function addbrand(Request $request)
{


 if($request->record_brand != null || $request->record_brand != ''){
    $count_check = DB::table('supplies_brand')->where('BRAND_NAME','=',$request->record_brand)->count();  
    if($count_check == 0){
        DB::table('supplies_brand')->insert(array(
            'BRAND_NAME' => $request->record_brand
        ));
    }
   
 }
    $query = DB::table('supplies_brand')->get();
    $output='<option value="">--กรุณาเลือกยี่ห้อ--</option>';   
    foreach ($query as $row){
          if($request->record_brand == $row->BRAND_NAME){
            $output.= '<option value="'.$row->BRAND_ID.'" selected>'.$row->BRAND_NAME.'</option>';
          }else{
            $output.= '<option value="'.$row->BRAND_ID.'">'.$row->BRAND_NAME.'</option>';
          }       
  }

    echo $output;   
}



function addmodel(Request $request)
    {
     
        if($request->record_model != null || $request->record_model != ''){
            $count_check = DB::table('supplies_model')->where('MODEL_NAME','=',$request->record_model)->count();  
            if($count_check == 0){
                DB::table('supplies_model')->insert(array(
                    'MODEL_NAME' => $request->record_model
                ));
            }
           
         }
            $query = DB::table('supplies_model')->get();
            $output='<option value="">--กรุณาเลือกยี่ห้อ--</option>';   
            foreach ($query as $row){
                  if($request->record_model == $row->MODEL_NAME){
                    $output.= '<option value="'.$row->MODEL_ID.'" selected>'.$row->MODEL_NAME.'</option>';
                  }else{
                    $output.= '<option value="'.$row->MODEL_ID.'">'.$row->MODEL_NAME.'</option>';
                  }       
          }
        
            echo $output; 
        
    }


    
function addcolor(Request $request)
{
 
    if($request->record_color != null || $request->record_color != ''){
        $count_check = DB::table('supplies_color')->where('COLOR_NAME','=',$request->record_color)->count();  
        if($count_check == 0){
            DB::table('supplies_color')->insert(array(
                'COLOR_NAME' => $request->record_color
            ));
        }
       
     }
        $query = DB::table('supplies_color')->get();
        $output='<option value="">--กรุณาเลือกยี่ห้อ--</option>';   
        foreach ($query as $row){
              if($request->record_color == $row->COLOR_NAME){
                $output.= '<option value="'.$row->COLOR_ID.'" selected>'.$row->COLOR_NAME.'</option>';
              }else{
                $output.= '<option value="'.$row->COLOR_ID.'">'.$row->COLOR_NAME.'</option>';
              }       
      }
    
        echo $output; 
    
}



function addsize(Request $request)
    {
     
        if($request->record_size!= null || $request->record_size != ''){
            $count_check = DB::table('supplies_size')->where('SIZE_NAME','=',$request->record_size)->count();  
            if($count_check == 0){
                DB::table('supplies_size')->insert(array(
                    'SIZE_NAME' => $request->record_size
                ));
            }
           
         }
            $query = DB::table('supplies_size')->get();
            $output='<option value="">--กรุณาเลือกยี่ห้อ--</option>';   
            foreach ($query as $row){
                  if($request->record_size == $row->SIZE_NAME){
                    $output.= '<option value="'.$row->SIZE_ID.'" selected>'.$row->SIZE_NAME.'</option>';
                  }else{
                    $output.= '<option value="'.$row->SIZE_ID.'">'.$row->SIZE_NAME.'</option>';
                  }       
          }
        
            echo $output; 
        
    }



    ///-----------------------------------------------------------------/////
public function infosuppliesvendor()
{
  $infosuppliesvendor= Suppliesvendor::orderBy('VENDOR_ID', 'desc')  
  ->get(); 
  return view('manager_supplies.suppliesinfovendor',[
          'infosuppliesvendorT' =>  $infosuppliesvendor
      ]);
}   

public function createsuppliesvendor(Request $request)
{    
    $infosuppliesvendor= Suppliesvendor::orderBy('VENDOR_ID', 'asc')  
    ->get(); 
    return view('manager_supplies.suppliesinfovendor_add',[
        'infosuppliesvendorT' =>  $infosuppliesvendor
    ]); 
}

public function savesuppliesvendor(Request $request)
{
  $addsuppliesvendor= new Suppliesvendor(); 
  $addsuppliesvendor->VENDOR_NAME = $request->VENDOR_NAME; 
  $addsuppliesvendor->VENDOR_EMAIL = $request->VENDOR_EMAIL;
  $addsuppliesvendor->VENDOR_ADDRESS = $request->VENDOR_ADDRESS;
  $addsuppliesvendor->VENDOR_PHONE = $request->VENDOR_PHONE;
  $addsuppliesvendor->VENDOR_POSTCODE = $request->VENDOR_POSTCODE;
  $addsuppliesvendor->VENDOR_NAME_SHOT = $request->VENDOR_NAME_SHOT;
  $addsuppliesvendor->VAT_NUM = $request->VAT_NUM;
  $addsuppliesvendor->VENDOR_NUM = $request->VENDOR_NUM;
  $addsuppliesvendor->ACTIVE = 'True';
  $addsuppliesvendor->VENDOR_CONTECT = $request->VENDOR_CONTECT;
  $addsuppliesvendor->VENDOR_TAX_NUM = $request->VENDOR_TAX_NUM;
  $addsuppliesvendor->VENDOR_FAX = $request->VENDOR_FAX;
  $addsuppliesvendor->VENDOR_BANK_NAME = $request->VENDOR_BANK_NAME;
  $addsuppliesvendor->VENDOR_BANK_NUM = $request->VENDOR_BANK_NUM;
  $addsuppliesvendor->VENDOR_BANK = $request->VENDOR_BANK;
  $addsuppliesvendor->VENDOR_BANK_TYPE = $request->VENDOR_BANK_TYPE;
  $addsuppliesvendor->VENDOR_ADDRESS_SEND= $request->VENDOR_ADDRESS_SEND;
  $addsuppliesvendor->VENDOR_POSTCODE_SEND= $request->VENDOR_POSTCODE_SEND;
  $addsuppliesvendor->VENDOR_BANK_CREDITOR= $request->VENDOR_BANK_CREDITOR;
  $addsuppliesvendor->VENDOR_BANK_DEBTOR= $request->VENDOR_BANK_DEBTOR;
  $addsuppliesvendor->VENDOR_BANK_BRANCH= $request->VENDOR_BANK_BRANCH;
  $addsuppliesvendor->VENDOR_SET_BUY= $request->VENDOR_SET_BUY;
  $addsuppliesvendor->VENDOR_SET_SELL= $request->VENDOR_SET_SELL;  
  $addsuppliesvendor->save(); 

  return redirect()->route('msupplies.infosuppliesvendor'); 
}

public function editsuppliesvendor(Request $request,$id)
{    
  $infosuppliesvendor= Suppliesvendor::where('VENDOR_ID','=',$id)
  ->first();
  return view('manager_supplies.suppliesinfovendor_edit',[
    'infosuppliesvendorT' => $infosuppliesvendor, 
    ]);
}

public function updatesuppliesvendor(Request $request)
{
    $id = $request->VENDOR_ID;  
    // dd($id);
    $updatesuppliesvendor= Suppliesvendor::find($id);
    $updatesuppliesvendor->VENDOR_NAME = $request->VENDOR_NAME;
    $updatesuppliesvendor->VENDOR_EMAIL = $request->VENDOR_EMAIL;
    $updatesuppliesvendor->VENDOR_ADDRESS = $request->VENDOR_ADDRESS;
    $updatesuppliesvendor->VENDOR_PHONE = $request->VENDOR_PHONE;
    $updatesuppliesvendor->VENDOR_POSTCODE = $request->VENDOR_POSTCODE;
    $updatesuppliesvendor->VENDOR_NAME_SHOT = $request->VENDOR_NAME_SHOT;
    $updatesuppliesvendor->VAT_NUM = $request->VAT_NUM;
    $updatesuppliesvendor->VENDOR_NUM = $request->VENDOR_NUM;
    $updatesuppliesvendor->VENDOR_CONTECT = $request->VENDOR_CONTECT;
    $updatesuppliesvendor->VENDOR_TAX_NUM = $request->VENDOR_TAX_NUM;
    $updatesuppliesvendor->VENDOR_FAX = $request->VENDOR_FAX;
    $updatesuppliesvendor->VENDOR_BANK_NAME = $request->VENDOR_BANK_NAME;
    $updatesuppliesvendor->VENDOR_BANK_NUM = $request->VENDOR_BANK_NUM;
    $updatesuppliesvendor->VENDOR_BANK = $request->VENDOR_BANK;
    $updatesuppliesvendor->VENDOR_BANK_TYPE = $request->VENDOR_BANK_TYPE;           
    $updatesuppliesvendor->save();  
    return redirect()->route('msupplies.infosuppliesvendor');
}

public function destroysuppliesvendor($id) { 

    Suppliesvendor::destroy($id);         
    //return redirect()->action('ChangenameController@infouserchangename');  
    return redirect()->route('msupplies.infosuppliesvendor');   
}

function switchactivevendor(Request $request)
{  
    //return $request->all(); 
    $id = $request->vendor;
    $budgetactive = Suppliesvendor::find($id);
    $budgetactive->ACTIVE = $request->onoff;
    $budgetactive->save();
}
///-----------------------------------------------------------------/////
    


// ตั้งค่ากำหนดมูลค่าแผนวัสดุ

 
public function material_year_plan_value(Request $request)
{


    $year_plan =  DB::table('plan_supplies_year')
   //  ->leftJoin('supplies_material_plan_value', 'plan_supplies_year.PLAN_SUPPLIES_YEAR_ID', '=', 'supplies_material_plan_value.PLAN_SUPPLIES_ID_YEAR')
       ->get();



    return view('manager_supplies.setupsupplies_year_material_plan_value', [
        'year_plan' => $year_plan,
    
     

       ]);
}


public function add_year_material_plan_value(Request $request)
{


    $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
    $budgetyear = DB::table('budget_year')->where('ACTIVE', '=', true)->get();
    $m_budget = date("m");
    if ($m_budget > 9) {
        $yearbudget = date("Y") + 544;
    } else {
        $yearbudget = date("Y") + 543;
    }

    
    return view('manager_supplies.add_year_setupsupplies_material_plan_value', [
   
        'budget' => $budget,
        'budgetyears' => $budgetyear,
        'yearbudget' => $yearbudget,
    ]);
}
public function save_year_material_plan_value(Request $request)
{
    $request->validate([
       'PLAN_SUPPLIES_YEAR'=>'unique:plan_supplies_year'
   ],
   [
       'PLAN_SUPPLIES_YEAR.unique'=>"มีชื่อแผนกนี้ในฐานข้อมูลเเล้ว"
   ]);

   $addplanyear = new Plansuppliesyear;    
   $addplanyear->PLAN_SUPPLIES_YEAR = $request->PLAN_SUPPLIES_YEAR;

   // $addplanyear->DATE_SAVE = date('Y-m-d');

   $addplanyear->save();
   return redirect()->route('msupplies.material_year_plan_value')->with('success_save', "บันทึกข้อมูลเรียบร้อย");


}








public function material_plan_value(Request $request, $id)
{
   $ids = Plansuppliesyear::where('PLAN_SUPPLIES_YEAR_ID', '=', $id)->first();

        $mp_e =  DB::table('supplies_material_plan_value')
       //  ->where('SUP_TYPE_MASTER_ID', '=', '1')
        ->leftJoin('supplies_type', 'supplies_material_plan_value.ID_SUP_TYPE', '=', 'supplies_type.SUP_TYPE_ID')
        ->leftJoin('plan_supplies_year', 'supplies_material_plan_value.PLAN_SUPPLIES_ID_YEAR', '=', 'plan_supplies_year.PLAN_SUPPLIES_YEAR_ID')

        ->where('PLAN_SUPPLIES_YEAR_ID', '=', $id)
        ->get();

    return view('manager_supplies.setupsupplies_material_plan_value', [
 
        'mp_e' => $mp_e,
        'ids' => $ids,
    ]);
}
public function add_material_plan_value(Request $request,$id)
{
   $ids = Plansuppliesyear::where('PLAN_SUPPLIES_YEAR_ID', '=', $id)->first();
   // dd($ids);
    $select_data =  DB::table('supplies_type')
    ->where('ACTIVE','=','True')
    ->get();
// dd($select_data);
    return view('manager_supplies.add_setupsupplies_material_plan_value', [
       'select_data' => $select_data,
       'ids' => $ids,
   ]);
}

public function save_material_plan_value(Request $request)
{
    
    $id =  $request->PLAN_SUPPLIES_ID_YEAR;
    $ids = Plansuppliesyear::where('PLAN_SUPPLIES_YEAR_ID', '=', $id)->first();
   $content =  $request->SUP_TYPE_ID;
   $select_data =  DB::table('supplies_type')
   ->get();
   // dd($id,$ids,$content);

   $check = DB::table('supplies_material_plan_value')
   ->where ('PLAN_SUPPLIES_ID_YEAR','=',$id)
   ->where('ID_SUP_TYPE','=',$content)
   ->first();


// dd($check);

   if(empty($check)){

       $addSupplies_MPV = new Supplies_MPV;
       $addSupplies_MPV->ID_SUP_TYPE = $request->SUP_TYPE_ID;
       $addSupplies_MPV->SUP_MATERIAL_VALUE = $request->SUP_MATERIAL_VALUE;
       $addSupplies_MPV->PLAN_SUPPLIES_ID_YEAR = $request->PLAN_SUPPLIES_ID_YEAR;


       $addSupplies_MPV->DATE_SAVE = date('Y-m-d');
   
       $addSupplies_MPV->save();
       // dd($addSupplies_MPV);
          return redirect()->route('msupplies.material_plan_value', [
           'id' => $ids,
       ])->with('success', "บันทึกข้อมูลเรียบร้อย");
       
   }else{
       // dd('asdasd');
       return  redirect()->route('msupplies.add_material_plan_value', [
 
           'select_data' => $select_data,
           'id' => $ids,
       ])->with('danger', "มีรายการนี้ในฐานข้อมูลเเล้ว");
       
   }

   //  return redirect()->route('msupplies.material_plan_value')->with('success_save', "บันทึกข้อมูลเรียบร้อย");
}




public function destroy_material_plan_value($ids,$id)
{

   // $ids = Plansuppliesyear::where('PLAN_SUPPLIES_YEAR_ID', '=', $id)->first();
   $ids = Plansuppliesyear::where('PLAN_SUPPLIES_YEAR_ID', '=', $ids)->first();

   Supplies_MPV::destroy($id);
   // dd($ids,$id);
   //  return redirect()->route('msupplies.matreial_plan_value')->with('success', "ลบข้อมูลเรียบร้อย");
   return redirect()->route('msupplies.material_plan_value', [
       'id' => $ids,
       // 'id' => $id,
   ])->with('success', "ลบข้อมูลเรียบร้อย");
}


function up_material_plan_value(Request $request)
{  
    //return $request->all(); 
    $id = $request->idreceipt;
    
    $up_material_plan_value = Supplies_MPV::find($id);
    $up_material_plan_value->SUP_MATERIAL_VALUE = $request->value;
    $up_material_plan_value->save();
}

public function excel_material_plan_value(Request $request)
{

        // $excel =  Supplies_MPV::where('HR_PAY_TYPE','=','salary')->get();

   
        $excel =  DB::table('supplies_material_plan_value')->where('SUP_TYPE_MASTER_ID', '=', '1')
        ->leftJoin('supplies_type', 'supplies_material_plan_value.ID_SUP_TYPE', '=', 'supplies_type.SUP_TYPE_ID')
        // ->where('SUP_TYPE_MASTER_ID', '=', '1')
        ->get();


    return view('manager_supplies.setupsupplies_excel_material_plan_value',[
        'excel' => $excel, 
       ]);
}


   


public static function  summaterialpurchasingplan($id)
{
   $sum1 =  DB::table('supplies_material_plan_value')->where('SUP_TYPE_MASTER_ID', '=', '1')
   ->leftJoin('supplies_type', 'supplies_material_plan_value.ID_SUP_TYPE', '=', 'supplies_type.SUP_TYPE_ID')
   ->where('PLAN_SUPPLIES_ID_YEAR', '=', $id)
   ->where('SUP_TYPE_MASTER_ID', '=', '1')
   ->sum('supplies_material_plan_value.SUP_MATERIAL_VALUE');

   //  dd($sum1);

    if ($sum1 == null) {

        $resultimage =  '0';

      
        
    } else {

      
       $resultimage =  $sum1;

    }


    return $resultimage;
}
public static function  sumprocurementplan($id)
{

   $sum1 =  DB::table('supplies_material_plan_value')
   ->leftJoin('supplies_type', 'supplies_material_plan_value.ID_SUP_TYPE', '=', 'supplies_type.SUP_TYPE_ID')
   ->where('PLAN_SUPPLIES_ID_YEAR', '=', $id)
   ->where('SUP_TYPE_MASTER_ID', '=', '2')
   ->sum('supplies_material_plan_value.SUP_MATERIAL_VALUE');

   //  dd($sum1);

    if ($sum1 == null) {

        $resultimage =  '0';

      
        
    } else {

      
       $resultimage =  $sum1;

    }


    return $resultimage;
}
public static function  sumcharteredplan($id)
{

   $sum1 =  DB::table('supplies_material_plan_value')
   ->leftJoin('supplies_type', 'supplies_material_plan_value.ID_SUP_TYPE', '=', 'supplies_type.SUP_TYPE_ID')
   ->where('PLAN_SUPPLIES_ID_YEAR', '=', $id)
   ->where('SUP_TYPE_MASTER_ID', '=', '3')
   ->sum('supplies_material_plan_value.SUP_MATERIAL_VALUE');

   //  dd($sum1);

    if ($sum1 == null) {

        $resultimage =  '0';

      
        
    } else {

      
       $resultimage =  $sum1;

    }


    return $resultimage;
}



// จบ


}