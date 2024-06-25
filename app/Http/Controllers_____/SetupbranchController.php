<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Recordbranch;

class SetupbranchController extends Controller
{
    public function infobranch()
    {
       
        $infobranch = Recordbranch::orderBy('RECORD_BRANCH_ID', 'asc')  
                                     ->get();

       //dd($infoeducation);
        return view('admin_develop.setupbranch',[
            'infobranchs' => $infobranch 
        ]);
    }

    public function create(Request $request)
    {
       //dd($infoeducation);
        return view('admin_develop.setupbranch_add');

    }

    public function save(Request $request)
    {

            $addbranch = new Recordbranch(); 
          
            $addbranch->RECORD_BRANCH_NAME = $request->RECORD_BRANCH_NAME;
 
            $addbranch->save();


            return redirect()->route('setup.indexbranch'); 
    }

    public function edit(Request $request,$id)
    {
    //return $request->all();

   $id_in= $request->id;
 
   $infobranch = Recordbranch::where('RECORD_BRANCH_ID','=',$id_in)
   ->first();


   return view('admin_develop.setupbranch_edit',[
    'infobranch' => $infobranch 
]);
    }

    public function update(Request $request)
    {
        $id = $request->RECORD_BRANCH_ID; 

        $updatedaytype = Recordbranch::find($id);
        $updatedaytype->RECORD_BRANCH_NAME = $request->RECORD_BRANCH_NAME;
       
        $updatedaytype->save();
        
        
            return redirect()->route('setup.indexbranch'); 
    }

    
    public function destroy($id) { 
                
        Recordbranch::destroy($id);         
        //return redirect()->action('ChangenameController@infouserchangename');  
        return redirect()->route('setup.indexbranch');   
    }


}
