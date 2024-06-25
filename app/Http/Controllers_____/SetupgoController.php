<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Recordgo;

class SetupgoController extends Controller
{
    public function infogo()
    {
       
        $infogo = Recordgo::orderBy('RECORD_GO_ID', 'asc')  
                                     ->get();

       //dd($infoeducation);
        return view('admin_develop.setupgo',[
            'infogos' => $infogo 
        ]);
    }

    public function create(Request $request)
    {
       //dd($infoeducation);
        return view('admin_develop.setupgo_add');

    }


    
    public function save(Request $request)
    {

            $addgo = new Recordgo(); 
          
            $addgo->RECORD_GO_NAME = $request->RECORD_GO_NAME;
 
            $addgo->save();


            return redirect()->route('setup.indexgo'); 
    }

    public function edit(Request $request,$id)
    {
    //return $request->all();

   $id_in= $request->id;
 
   $infogo = Recordgo::where('RECORD_GO_ID','=',$id_in)
   ->first();


   return view('admin_develop.setupgo_edit',[
    'infogo' => $infogo 
]);
    }

    public function update(Request $request)
    {
        $id = $request->RECORD_GO_ID; 

        $updatego = Recordgo::find($id);
        $updatego->RECORD_GO_NAME = $request->RECORD_GO_NAME;
       
        $updatego->save();
        
        
            return redirect()->route('setup.indexgo'); 
    }

    
    public function destroy($id) { 
                
        Recordgo::destroy($id);         
        //return redirect()->action('ChangenameController@infouserchangename');  
        return redirect()->route('setup.indexgo');   
    }




}
