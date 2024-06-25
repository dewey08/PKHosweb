<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\LeaveDaytype;

class SetupdaytypeController extends Controller
{
    public function infodaytype()
    {
       
        $infodaytype = LeaveDaytype::orderBy('DAY_TYPE_ID', 'asc')  
                                     ->get();

       //dd($infoeducation);
        return view('admin.setupdaytype',[
            'infodaytypes' => $infodaytype 
        ]);
    }


    public function create(Request $request)
    {
       //dd($infoeducation);
        return view('admin.setupdaytype_add');

    }

    public function save(Request $request)
    {

            $adddaytype = new LeaveDaytype(); 
            $adddaytype->DAY_TYPE_ID = $request->DAY_TYPE_ID;
            $adddaytype->DAY_TYPE_NAME = $request->DAY_TYPE_NAME;
 
            $adddaytype->save();


            return redirect()->route('setup.indexdaytype'); 
    }






public function edit(Request $request,$id)
    {
    //return $request->all();

   $id_in= $request->id;
 
   $infodaytype = LeaveDaytype::where('DAY_TYPE_ID','=',$id_in)
   ->first();


   return view('admin.setupdaytype_edit',[
    'infodaytype' => $infodaytype 
]);
    }

    public function update(Request $request)
    {
        $id = $request->DAY_TYPE_ID; 

        $updatedaytype = LeaveDaytype::find($id);
        $updatedaytype->DAY_TYPE_NAME = $request->DAY_TYPE_NAME;
       
        $updatedaytype->save();
        
        
            return redirect()->route('setup.indexdaytype'); 
    }

    
    public function destroy($id) { 
                
        LeaveDaytype::destroy($id);         
        //return redirect()->action('ChangenameController@infouserchangename');  
        return redirect()->route('setup.indexdaytype');   
    }

}
