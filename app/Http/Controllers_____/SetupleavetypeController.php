<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Leavetype;

class SetupleavetypeController extends Controller
{
    public function infoleavetype()
    {
       
        $infoleavetype = Leavetype::orderBy('LEAVE_TYPE_ID', 'asc')  
                                     ->get();

       //dd($infoeducation);
        return view('admin.setupleavetype',[
            'infoleavetypes' => $infoleavetype 
        ]);
    }
    public function create(Request $request)
    {
       //dd($infoeducation);
        return view('admin.setupleavetype_add');

    }

    public function save(Request $request)
    {

            $addleavetype = new Leavetype(); 
            $addleavetype->LEAVE_TYPE_ID = $request->LEAVE_TYPE_ID;
            $addleavetype->LEAVE_TYPE_NAME = $request->LEAVE_TYPE_NAME;
            $addleavetype->save();

            return redirect()->route('setup.indexleavetype'); 
    }

    public function edit(Request $request,$id)
    {
    //return $request->all();

   $id_in= $request->id;
 
   $infoleavetype = Leavetype::where('LEAVE_TYPE_ID','=',$id_in)
   ->first();


   return view('admin.setupleavetype_edit',[
    'infoleavetype' => $infoleavetype 
]);
    }

    public function update(Request $request)
    {
        $id = $request->LEAVE_TYPE_ID; 

        $updateleavetype = Leavetype::find($id);
        $updateleavetype->LEAVE_TYPE_NAME = $request->LEAVE_TYPE_NAME;
       
        $updateleavetype->save();
        
        
            return redirect()->route('setup.indexleavetype'); 
    }

    
    public function destroy($id) { 
                
        Leavetype::destroy($id);         
        //return redirect()->action('ChangenameController@infouserchangename');  
        return redirect()->route('setup.indexleavetype');   
    }



}
