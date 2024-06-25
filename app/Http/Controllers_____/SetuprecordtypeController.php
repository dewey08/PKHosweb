<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Recordtype;

class SetuprecordtypeController extends Controller
{
    public function inforecordtype()
    {
       
        $infotype = Recordtype::orderBy('RECORD_TYPE_ID', 'asc')  
                                     ->get();
       //dd($infoeducation);
        return view('admin_develop.setuptype',[
            'infotypes' => $infotype 
        ]);
    }

    public function create(Request $request)
    {
       //dd($infoeducation);
        return view('admin_develop.setuptype_add');

    }

    public function save(Request $request)
    {

            $addtype = new Recordtype();           
            $addtype->RECORD_TYPE_NAME = $request->RECORD_TYPE_NAME;
            $addtype->save();


            return redirect()->route('setup.indextype'); 
    }

    public function edit(Request $request,$id)
    {
    //return $request->all();

   $id_in= $request->id;
   $infotype = Recordtype::where('RECORD_TYPE_ID','=',$id_in)
   ->first();


   return view('admin_develop.setuptype_edit',[
    'infotype' => $infotype 
]);
    }

    public function update(Request $request)
    {
        $id = $request->RECORD_TYPE_ID; 
        $updatetype = Recordtype::find($id);
        $updatetype->RECORD_TYPE_NAME = $request->RECORD_TYPE_NAME;  
        $updatetype->save();
        
        
            return redirect()->route('setup.indextype'); 
    }

    
    public function destroy($id) { 
                
        Recordtype::destroy($id);         
        //return redirect()->action('ChangenameController@infouserchangename');  
        return redirect()->route('setup.indextype');   
    }
}
