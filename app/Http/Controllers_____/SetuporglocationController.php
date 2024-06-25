<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Recordorglocation;

class SetuporglocationController extends Controller
{
    public function infoorglocation()
    {
       
        $infoorglocation = Recordorglocation::orderBy('LOCATION_ID', 'asc')  
                                     ->get();

       //dd($infoeducation);
        return view('admin_develop.setuporglocation',[
            'infoorglocations' => $infoorglocation 
        ]);
    }

    public function create(Request $request)
    {
       //dd($infoeducation);
        return view('admin_develop.setuporglocation_add');

    }

    public function save(Request $request)
    {

            $addorglocation = new Recordorglocation(); 
          
            $addorglocation->LOCATION_ORG_NAME = $request->LOCATION_NAME;
 
            $addorglocation->save();


            return redirect()->route('setup.indexorglocation'); 
    }

    public function edit(Request $request,$id)
    {
    //return $request->all();

   $id_in= $request->id;
 
   $infoorglocation = Recordorglocation::where('LOCATION_ID','=',$id_in)
   ->first();


   return view('admin_develop.setuporglocation_edit',[
    'infoorglocation' => $infoorglocation 
]);
    }

    public function update(Request $request)
    {
        $id = $request->LOCATION_ID; 

        $updateorglocation = Recordorglocation::find($id);
        $updateorglocation->LOCATION_ORG_NAME = $request->LOCATION_NAME;
       
        $updateorglocation->save();
        
        
            return redirect()->route('setup.indexorglocation'); 
    }

    
    public function destroy($id) { 
                
        Recordorglocation::destroy($id);         
        //return redirect()->action('ChangenameController@infouserchangename');  
        return redirect()->route('setup.indexorglocation');   
    }
}
