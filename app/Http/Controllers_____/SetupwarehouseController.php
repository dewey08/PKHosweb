<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Person;
use App\Models\Statuscheck;
use App\Models\Typereceive;
use App\Models\Disburse_cycle;
use App\Models\Disburse_status;
use App\Models\Sup_type;
use App\Models\Warehousefunctionlist;

class SetupwarehouseController extends Controller
{
  

    public function depsubsup()
    {
        $infosuppliesdepsubsup = DB::table('hrd_department_sub_sub')
        ->leftjoin('hrd_department_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
        ->get();                         
        
   //dd($inforoom);
    return view('admin_warehouse.warehousedepsubsup',[
        'infosuppliesdepsubsups' =>  $infosuppliesdepsubsup
    ]);
    }   


    public function statuscheck(Request $request)
    {
        $infostatuscheck = DB::table('warehouse_check_status')->get(); 
        
   //dd($inforoom);
    return view('admin_warehouse.warehousestatuscheck',[
        'infostatuschecks' =>  $infostatuscheck
    ]);
    }  
    public function statuscheck_add(Request $request)
    {
      
    return view('admin_warehouse.warehousestatuscheck_add');
    } 
    public function statuscheck_save(Request $request)
    {
        $add = new Statuscheck(); 
        $add->STATUS_CHECK_NAME = $request->STATUS_CHECK_NAME; 
        $add->save();

        return redirect()->route('setupwarehouse.statuscheck'); 
    } 

    public function statuscheck_edit(Request $request,$id)
    { 
       $id_in= $id;     
       $infostatuscheck = Statuscheck::where('ID_STATUS','=',$id_in)->first();

        return view('admin_warehouse.warehousestatuscheck_edit',[
        'infostatuschecks' => $infostatuscheck 
        ]);
    }
    public function statuscheck_update(Request $request)
    {
        $id = $request->ID_STATUS;
        $update = Statuscheck::find($id);
        $update->STATUS_CHECK_NAME = $request->STATUS_CHECK_NAME; 
        $update->save();
        return redirect()->route('setupwarehouse.statuscheck'); 
    }
    public function statuscheck_destroy($id) { 

        Statuscheck::destroy($id);                 
        return redirect()->route('setupwarehouse.statuscheck');   
    }
//=================================================================//
    public function typereceive()
    {
        $infotypereceive = DB::table('warehouse_check_type')->get();  

        return view('admin_warehouse.warehousetypereceive',[
        'infotypereceives' =>  $infotypereceive
    ]);
    }  
    public function typereceive_add()
    {      
      return view('admin_warehouse.warehousetypereceive_add');
    } 
    public function typereceive_save(Request $request)
    {
        $add = new Typereceive(); 
        $add->TYPE_CHECK_NAME = $request->TYPE_CHECK_NAME; 
        $add->save();

        return redirect()->route('setupwarehouse.typereceive'); 
    } 

    public function typereceive_edit(Request $request,$id)
    { 
       $id_in= $id;     
       $infotypereceive = Typereceive::where('ID_TYPE','=',$id_in)->first();

        return view('admin_warehouse.warehousetypereceive_edit',[
        'infotypereceives' => $infotypereceive 
        ]);
    }
    public function typereceive_update(Request $request)
    {
        $id = $request->ID_TYPE;
        $update = Typereceive::find($id);
        $update->TYPE_CHECK_NAME = $request->TYPE_CHECK_NAME; 
        $update->save();
        return redirect()->route('setupwarehouse.typereceive'); 
    }

    public function typereceive_destroy($id) { 

        Typereceive::destroy($id);                 
        return redirect()->route('setupwarehouse.typereceive');   
    }

//=======================================================//

    public function typecycle()
    {
        $infotypecycle = DB::table('warehouse_disburse_cycle')->get(); 
        
   //dd($inforoom);
    return view('admin_warehouse.warehousetypecycle',[
        'infotypecycles' =>  $infotypecycle
    ]);
    }  
    public function typecycle_add()
    {      
      return view('admin_warehouse.warehousetypecycle_add');
    } 
    public function typecycle_save(Request $request)
    {
        $add = new Disburse_cycle(); 
        $add->CYCLE_DISBURSE_NAME = $request->CYCLE_DISBURSE_NAME; 
        $add->save();

        return redirect()->route('setupwarehouse.typecycle'); 
    } 

    public function typecycle_edit(Request $request,$id)
    { 
       $id_in= $id;     
       $infotypecycle = Disburse_cycle::where('ID_CYCLE','=',$id_in)->first();

        return view('admin_warehouse.warehousetypecycle_edit',[
        'infotypecycles' => $infotypecycle 
        ]);
    }
    public function typecycle_update(Request $request)
    {
        $id = $request->ID_CYCLE;
        $update = Disburse_cycle::find($id);
        $update->CYCLE_DISBURSE_NAME = $request->CYCLE_DISBURSE_NAME; 
        $update->save();
        return redirect()->route('setupwarehouse.typecycle'); 
    }

    public function typecycle_destroy($id) { 

        Disburse_cycle::destroy($id);                 
        return redirect()->route('setupwarehouse.typecycle');   
    }

//=======================================================//
    public function statusdisburse()
    {
        $infostatusdisburse = DB::table('warehouse_disburse_status')->get(); 
        
   //dd($inforoom);
    return view('admin_warehouse.warehousestatusdisburse',[
        'infostatusdisburses' =>  $infostatusdisburse
    ]);
    }  
    public function statusdisburse_add()
    {      
      return view('admin_warehouse.warehousestatusdisburse_add');
    } 
    public function statusdisburse_save(Request $request)
    {
        $add = new Disburse_status(); 
        $add->STATUS_DISBURSE_NAME = $request->STATUS_DISBURSE_NAME; 
        $add->save();

        return redirect()->route('setupwarehouse.statusdisburse'); 
    } 

    public function statusdisburse_edit(Request $request,$id)
    { 
       $id_in= $id;     
       $infostatusdisburse = Disburse_status::where('ID_STATUS','=',$id_in)->first();

        return view('admin_warehouse.warehousestatusdisburse_edit',[
        'infostatusdisburses' => $infostatusdisburse 
        ]);
    }
    public function statusdisburse_update(Request $request)
    {
        $id = $request->ID_STATUS;
        $update = Disburse_status::find($id);
        $update->STATUS_DISBURSE_NAME = $request->STATUS_DISBURSE_NAME; 
        $update->save();
        return redirect()->route('setupwarehouse.statusdisburse'); 
    }

    public function statusdisburse_destroy($id) { 

        Disburse_status::destroy($id);                 
        return redirect()->route('setupwarehouse.statusdisburse');   
    }

//=======================================================//
    public function typedisburse()
    {
        $infotypedisburse = DB::table('warehouse_sup_type')->get(); 

    return view('admin_warehouse.warehousetypedisburse',[
        'infotypedisburses' =>  $infotypedisburse
    ]);
    }  
    public function typedisburse_add()
    {      
      return view('admin_warehouse.warehousetypedisburse_add');
    } 
    public function typedisburse_save(Request $request)
    {
        $add = new Sup_type(); 
        $add->SUP_TYPE_NAME = $request->SUP_TYPE_NAME; 
        $add->save();

        return redirect()->route('setupwarehouse.typedisburse'); 
    } 

    public function typedisburse_edit(Request $request,$id)
    { 
       $id_in= $id;     
       $infotypedisburse = Sup_type::where('ID_SUP_TYPE','=',$id_in)->first();

        return view('admin_warehouse.warehousetypedisburse_edit',[
        'infotypedisburses' => $infotypedisburse 
        ]);
    }
    public function typedisburse_update(Request $request)
    {
        $id = $request->ID_SUP_TYPE;
        $update = Sup_type::find($id);
        $update->SUP_TYPE_NAME = $request->SUP_TYPE_NAME; 
        $update->save();
        return redirect()->route('setupwarehouse.typedisburse'); 
    }

    public function typedisburse_destroy($id) { 

        Sup_type::destroy($id);                 
        return redirect()->route('setupwarehouse.typedisburse');   
    }


///-----------------------------------ฟังชั่นรายการขอเบิก------------------------------/////


            public function setupwarehouseeditlist()
            {

                $infowarehousefunctionlist = DB::table('warehouse_functionlist')->get();


                    return view('admin_warehouse.warehouseeditlist',[
                        'infowarehousefunctionlists' =>$infowarehousefunctionlist 
                    ]);

            }  


            function switchactive(Request $request)
            {  
                $id = $request->idfunc;

            

                $active = Warehousefunctionlist::find($id);
                $active->ACTIVE = $request->onoff;
                $active->save();
        }



}
