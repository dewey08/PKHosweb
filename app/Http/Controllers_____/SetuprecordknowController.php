<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Recordknow;

class SetuprecordknowController extends Controller
{
    public function inforecordknow()
    {
       
        $infoknow = Recordknow::orderBy('RECORD_KNOWLEDGE_ID', 'asc')  
                                     ->get();

       //dd($infoeducation);
        return view('admin_develop.setupknow',[
            'infoknows' => $infoknow 
        ]);
    }

    public function create(Request $request)
    {
       //dd($infoeducation);
        return view('admin_develop.setupknow_add');

    }

    public function save(Request $request)
    {

            $addknow = new Recordknow(); 
          
            $addknow->RECORD_KNOWLEDGE_NAME = $request->RECORD_KNOWLEDGE_NAME;
 
            $addknow->save();


            return redirect()->route('setup.indexknow'); 
    }

    public function edit(Request $request,$id)
    {
    //return $request->all();

   $id_in= $request->id;
 
   $infoknow = Recordknow::where('RECORD_KNOWLEDGE_ID','=',$id_in)
   ->first();


   return view('admin_develop.setupknow_edit',[
    'infoknow' => $infoknow 
]);
    }

    public function update(Request $request)
    {
        $id = $request->RECORD_KNOWLEDGE_ID; 

        $updateknow = Recordknow::find($id);
        $updateknow->RECORD_KNOWLEDGE_NAME = $request->RECORD_KNOWLEDGE_NAME;
       
        $updateknow->save();
        
        
            return redirect()->route('setup.indexknow'); 
    }

    
    public function destroy($id) { 
                
        Recordknow::destroy($id);         
        //return redirect()->action('ChangenameController@infouserchangename');  
        return redirect()->route('setup.indexknow');   
    }

}
