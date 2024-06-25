<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Recordlevel;

class SetuprecordlevelController extends Controller
{
    public function inforecordlevel()
    {
       
        $infolevel = Recordlevel::orderBy('ID', 'asc')  
                                     ->get();

       //dd($infoeducation);
        return view('admin_develop.setuplevel',[
            'infolevels' => $infolevel 
        ]);
    }

    public function create(Request $request)
    {
       //dd($infoeducation);
        return view('admin_develop.setuplevel_add');

    }

    public function save(Request $request)
    {

            $addlevel = new Recordlevel(); 
          
            $addlevel->RECORD_LEVEL_NAME = $request->RECORD_LEVEL_NAME;
 
            $addlevel->save();


            return redirect()->route('setup.indexlevel'); 
    }

    public function edit(Request $request,$id)
    {
    //return $request->all();

   $id_in= $request->id;
 
   $infolevel = Recordlevel::where('ID','=',$id_in)
   ->first();


   return view('admin_develop.setuplevel_edit',[
    'infolevel' => $infolevel 
]);
    }

    public function update(Request $request)
    {
        $id = $request->ID; 

        $updatelevel = Recordlevel::find($id);
        $updatelevel->RECORD_LEVEL_NAME = $request->RECORD_LEVEL_NAME;
       
        $updatelevel->save();
        
        
            return redirect()->route('setup.indexlevel'); 
    }

    
    public function destroy($id) { 
                
        Recordlevel::destroy($id);         
        //return redirect()->action('ChangenameController@infouserchangename');  
        return redirect()->route('setup.indexlevel');   
    }
}
