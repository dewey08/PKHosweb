<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Recordorg;

class SetuprecordorgController extends Controller
{
    public function infoorg()
    {
       
        $infoorg = Recordorg::orderBy('RECORD_ORG_ID', 'asc')  
                                     ->get();

       //dd($infoeducation);
        return view('admin_develop.setuporg',[
            'infoorgs' => $infoorg 
        ]);
    }

    public function create(Request $request)
    {
       //dd($infoeducation);
        return view('admin_develop.setuporg_add');

    }

    public function save(Request $request)
    {

            $addorg = new Recordorg(); 
          
            $addorg->RECORD_ORG_NAME = $request->RECORD_ORG_NAME;
 
            $addorg->save();


            return redirect()->route('setup.indexorg'); 
    }

    public function edit(Request $request,$id)
    {
    //return $request->all();

   $id_in= $request->id;
 
   $infoorg = Recordorg::where('RECORD_ORG_ID','=',$id_in)
   ->first();


   return view('admin_develop.setuporg_edit',[
    'infoorg' => $infoorg 
]);
    }

    public function update(Request $request)
    {
        $id = $request->RECORD_ORG_ID; 

        $updateorg = Recordorg::find($id);
        $updateorg->RECORD_ORG_NAME = $request->RECORD_ORG_NAME;
       
        $updateorg->save();
        
        
            return redirect()->route('setup.indexorg'); 
    }

    
    public function destroy($id) { 
                
        Recordorg::destroy($id);         
        //return redirect()->action('ChangenameController@infouserchangename');  
        return redirect()->route('setup.indexorg');   
    }

}
