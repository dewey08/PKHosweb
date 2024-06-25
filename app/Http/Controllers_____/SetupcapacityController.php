<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Recordcapacity;

class SetupcapacityController extends Controller
{
    public function infocapacity()
    {
       
        $infocapacity = Recordcapacity::orderBy('RECORD_CAPACITY_ID', 'asc')  
                                     ->get();
       //dd($infoeducation);
        return view('admin_develop.setupcapacity',[
            'infocapacitys' => $infocapacity 
        ]);
    }

    public function create(Request $request)
    {
       //dd($infoeducation);
        return view('admin_develop.setupcapacity_add');

    }

    public function save(Request $request)
    {

            $addcapacity = new Recordcapacity(); 
          
            $addcapacity->RECORD_CAPACITY_NAME = $request->RECORD_CAPACITY_NAME;
 
            $addcapacity->save();


            return redirect()->route('setup.indexcapacity'); 
    }

    public function edit(Request $request,$id)
    {
    //return $request->all();

   $id_in= $request->id;
 
   $infocapacity = Recordcapacity::where('RECORD_CAPACITY_ID','=',$id_in)
   ->first();


   return view('admin_develop.setupcapacity_edit',[
    'infocapacity' => $infocapacity 
]);
    }

    public function update(Request $request)
    {
        $id = $request->RECORD_CAPACITY_ID; 

        $updatecapacity = Recordcapacity::find($id);
        $updatecapacity->RECORD_CAPACITY_NAME = $request->RECORD_CAPACITY_NAME;
       
        $updatecapacity->save();
        
        
            return redirect()->route('setup.indexcapacity'); 
    }

    
    public function destroy($id) { 
                
        Recordcapacity::destroy($id);         
        //return redirect()->action('ChangenameController@infouserchangename');  
        return redirect()->route('setup.indexcapacity');   
    }



}
