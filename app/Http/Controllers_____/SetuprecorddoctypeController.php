<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Recorddoctype;
use App\Models\Openformperdev;
// use Brian2694\Toastr\Facades\Toastr;

class SetuprecorddoctypeController extends Controller
{
    public function inforecorddoctype()
    {       
        $infodoctype = Recorddoctype::orderBy('RECODE_DOCTYPE_ID', 'asc')->get();
        return view('admin_develop.setupdoctype',[
            'infodoctypes' => $infodoctype 
        ]);
    }
    public function create(Request $request)
    {
        return view('admin_develop.setupdoctype_add');
    }

    public function save(Request $request)
    {
            $adddoctype = new Recorddoctype();           
            $adddoctype->RECODE_DOCTYPE_NAME = $request->RECODE_DOCTYPE_NAME; 
            $adddoctype->save();
            return redirect()->route('setup.indexdoctype'); 
    }

    public function edit(Request $request,$id)
    {
            $id_in= $request->id;            
            $infodoctype = Recorddoctype::where('RECODE_DOCTYPE_ID','=',$id_in)->first();
            return view('admin_develop.setupdoctype_edit',[
                'infodoctype' => $infodoctype 
            ]);
    }
    public function update(Request $request)
    {
        $id = $request->RECODE_DOCTYPE_ID; 
        $updatedoctype = Recorddoctype::find($id);
        $updatedoctype->RECODE_DOCTYPE_NAME = $request->RECODE_DOCTYPE_NAME;       
        $updatedoctype->save();   
            return redirect()->route('setup.indexdoctype'); 
    }
    
    public function destroy($id) { 
                
        Recorddoctype::destroy($id);  
        return redirect()->route('setup.indexdoctype');   
    }

 //=============================================//

 public function openform_perdev()
 {   
     $openform = DB::table('openformperdev')->get();
 
     return view('admin_develop.openform_perdev',[
         'openforms' =>  $openform,        
     ]);
 }
 public function openform_perdev_add()
 {   
     $openform = DB::table('openformperdev')->get();
 
     return view('admin_develop.openform_perdev_add',[
         'openforms' =>  $openform,        
     ]);
 }
 public function openform_perdev_save(Request $request)
 {  
     $add= new Openformperdev();
     $add->OPENFORMDEV_CODE = $request->OPENFORMDEV_CODE;
     $add->OPENFORMDEV_NAME = $request->OPENFORMDEV_NAME;
     $add->save();
    //  Toastr::success('บันทึกข้อมูลสำเร็จ');
     return redirect()->route('setup.openform_perdev');
 }

 public function openform_perdev_edit(Request $request,$id)
 {
     $openform = Openformperdev::where('OPENFORMDEV_ID','=',$id)->first();

     return view('admin_develop.openform_perdev_edit',[
         'openforms' =>  $openform, 
     ]);
 }
 public function openform_perdev_update(Request $request)
 {      
     $id = $request->OPENFORMDEV_ID;
     $updat = Openformperdev::find($id);       
     $updat->OPENFORMDEV_CODE = $request->OPENFORMDEV_CODE;    
     $updat->OPENFORMDEV_NAME = $request->OPENFORMDEV_NAME;     
     $updat->save();
    //  Toastr::success('แก้ไขข้อมูลสำเร็จ');
     return redirect()->route('setup.openform_perdev');
 }
 public function openform_perdev_destroy($id)
 {
    Openformperdev::destroy($id);
    //  Toastr::success('ลบข้อมูลสำเร็จ');
     return redirect()->route('setup.openform_perdev');
 }

 function openform_perdev_switchactive(Request $request)
 {  
     $id = $request->idfunc;
     $active = Openformperdev::find($id);
     $active->OPENFORMDEV_STATUS = $request->onoff;
     $active->save();
 }

 //=============================================//




}
