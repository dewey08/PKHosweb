<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Person;
use App\Models\CheckinType;


class SetupcheckinController extends Controller
{



     public function infocheckintype()
    {
   
    $infocheckintype = Checkintype::orderBy('CHECKIN_TYPE_ID', 'asc')  
                                            ->get();                     
      
   //dd($inforoom);
    return view('admin_checkin.setupinfocheckintype',[
        'infocheckintypes' => $infocheckintype
    ]);
    }   

    public function createcheckintype(Request $request)
    {
  
        return view('admin_checkin.setupinfocheckintype_add');

    }

    public function savecheckintype(Request $request)
    {
        //return $request->all();

            $addcheckintype = new Checkintype(); 
            $addcheckintype->CHECKIN_TYPE_NAME = $request->CHECKIN_TYPE_NAME;
         
            $addcheckintype->save();


            return redirect()->route('setup.indexcheckintype'); 
    }

    public function editcheckintype(Request $request,$id)
    {
       // return $request->all();
    
       $id_in= $id;
     
       $infocheckintype = Checkintype::where('CHECKIN_TYPE_ID','=',$id_in)
       ->first();


        //dd($inforbudget);
        return view('admin_checkin.setupinfocheckintype_edit',[
        'infocheckintype' => $infocheckintype 
        ]);

    }



    public function updatecheckintype(Request $request)
    {
        $id = $request->CHECKIN_TYPE_ID; 

        $updatecheckintype = Checkintype::find($id);
        $updatecheckintype->CHECKIN_TYPE_NAME = $request->CHECKIN_TYPE_NAME;
    
           
           //dd($addbudgetyear);
 
        $updatecheckintype->save();


        return redirect()->route('setup.indexcheckintype'); 

    }

    
    public function destroycheckintype($id) { 

        Checkintype::destroy($id);         
        //return redirect()->action('ChangenameController@infouserchangename');  
        return redirect()->route('setup.indexcheckintype');   
    }

    
}
