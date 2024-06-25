<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Safeservice;
use App\Models\Safeevent;
use App\Models\Safelocation;
use Carbon\Carbon;
use App\Models\Safetype;


date_default_timezone_set("Asia/Bangkok");

class SetupsafeserviceController extends Controller
{  
    public function setupsafeservice()
    {       
        $safetype = DB::table('safe_type')->get();
        return view('admin_safe.setupsafeservice',[            
            'safeT' => $safetype
        ]);
    } 
    public function createsafeservice(Request $request)
    { 
        return view('admin_safe.setupsafeservice_add');
    }
    public function savesafeservice(Request $request)
    {
        //return $request->all();

            $addsafetype = new Safetype(); 
            $addsafetype->SAFE_TYPE_NAME = $request->SAFE_TYPE_NAME;
         
            $addsafetype->save();
            return redirect()->route('setup.setupsafeservice'); 
    }

    public function editsafeservice(Request $request,$id)
    { 
       $id_in= $id;     
       $safetype = Safetype::where('SAFE_TYPE_ID','=',$id_in)
       ->first();
        return view('admin_safe.setupsafeservice_edit',[
        'safeT' => $safetype 
        ]);
    }

    public function updatesafeservice(Request $request)
    {
        $id = $request->SAFE_TYPE_ID;
        $updatesafetype = Safetype::find($id);
        $updatesafetype->SAFE_TYPE_NAME = $request->SAFE_TYPE_NAME; 
        $updatesafetype->save();
        return redirect()->route('setup.setupsafeservice'); 
    }
    public function destroysafeservice($id) { 

        Safetype::destroy($id);                 
        return redirect()->route('setup.setupsafeservice');   
    }
    //////////// เหตุการณ์  ////////////////
    public function setupevent()
    {       
        $eventtype = DB::table('safe_event')->get();
        return view('admin_safe.setupevent',[            
            'eventT' => $eventtype
        ]);
    } 
    public function createevent(Request $request)
    { 
        return view('admin_safe.setupevent_add');
    }
    public function saveevent(Request $request)
    {
        //return $request->all();

            $addeventtype = new Safeevent(); 
            $addeventtype->SAFE_EVENT_NAME = $request->SAFE_EVENT_NAME;
         
            $addeventtype->save();
            return redirect()->route('setup.setupevent'); 
    }

    public function editevent(Request $request,$id)
    { 
       $id_in= $id;     
       $eventtype = Safeevent::where('SAFE_EVENT_ID','=',$id_in)
       ->first();
        return view('admin_safe.setupevent_edit',[
        'eventT' => $eventtype 
        ]);
    }

    public function updateevent(Request $request)
    {
        $id = $request->SAFE_EVENT_ID;
        $updateeventtype = Safeevent::find($id);
        $updateeventtype->SAFE_EVENT_NAME = $request->SAFE_EVENT_NAME; 
        $updateeventtype->save();
        return redirect()->route('setup.setupevent'); 
    }
    public function destroyevent($id) { 

        Safeevent::destroy($id);                 
        return redirect()->route('setup.setupevent');   
    }
    ///////////// สถานที่เกิดเหตุ
    public function setupsafelocation()
    {       
        $safelocation = DB::table('safe_location')->get();
        return view('admin_safe.setupsafelocation',[            
            'locationT' => $safelocation
        ]);
    } 
    public function createsafelocation(Request $request)
    { 
        return view('admin_safe.setupsafelocation_add');
    }
    public function savesafelocation(Request $request)
    {
        //return $request->all();

            $addsafelocation = new Safelocation(); 
            $addsafelocation->SAFE_LOCATION_NAME = $request->SAFE_LOCATION_NAME;
         
            $addsafelocation->save();
            return redirect()->route('setup.setupsafelocation'); 
    }

    public function editsafelocation(Request $request,$id)
    { 
       $id_in= $id;     
       $safelocation = Safelocation::where('SAFE_LOCATION_ID','=',$id_in)
       ->first();
        return view('admin_safe.setupsafelocation_edit',[
        'locationT' => $safelocation
        ]);
    }

    public function updatesafelocation(Request $request)
    {
        $id = $request->SAFE_LOCATION_ID;
        $updatesafelocation = Safelocation::find($id);
        $updatesafelocation->SAFE_LOCATION_NAME = $request->SAFE_LOCATION_NAME; 
        $updatesafelocation->save();
        return redirect()->route('setup.setupsafelocation'); 
    }
    public function destroysafelocation($id) { 

        Safelocation::destroy($id);                 
        return redirect()->route('setup.setupsafelocation');   
    }
}

