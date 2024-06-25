<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Leavefunction;
use App\Models\Leavepermislevel;

class SetupleaveController extends Controller
{
    public function infofunction()
    {

        $infoleavefunction = DB::table('gleave_function')->get();

        return view('admin.setupleavefunction',[
            'infoleavefunctions' =>$infoleavefunction 
        ]);
    }



    function switchactive(Request $request)
    {  
        //return $request->all(); 
        $id = $request->idfunc;
        $active = Leavefunction::find($id);
        $active->ACTIVE = $request->onoff;
        $active->save();
    }



    public function setupinfolevelgroup()
    { 

        $infopersonlv3 = DB::table('gleave_permis_level')
        ->leftjoin('hrd_department_sub_sub','DEP_SUB_SUB_ID','=','HR_DEPARTMENT_SUB_SUB_ID')
        ->get();

        $infodep_sub_sub = DB::table('hrd_department_sub_sub')->get();

        return view('admin.setupinfolevelgroup',[
            'infopersonlv3s'=> $infopersonlv3,
            'infodep_sub_subs'=> $infodep_sub_sub,
        ]
          
        );
    }


    public function setupinfolevelgroup_add()
    { 

         $infoperson = DB::table('hrd_person')->get();

        return view('admin.setupinfolevelgroup_add',[
            'infopersons'=> $infoperson
        ]
          
        );
    }


   

    public function setupinfolevelgroup_save (Request $request)
    {    
                $personid= $request->PERSON_ID;
            
            $addperson = new Leavepermislevel(); 
            $addperson->PERSON_ID = $request->PERSON_ID;

       
            $infopersonlv = DB::table('hrd_person')->where('ID','=',$personid)->first();

            $addperson->NAME_PERSON = $infopersonlv->HR_FNAME.' '.$infopersonlv->HR_LNAME;
            $addperson->DEP_SUB_SUB_ID = $infopersonlv->HR_DEPARTMENT_SUB_SUB_ID;
            $addperson->save();


            return redirect()->route('setup.infolevelgroup'); 
    }



    public function setupinfolevelgroupdep_save (Request $request)
    {    
            $iddep_info= $request->INFO_DEP_SUB_SUB;
            
       
            
            $infomatpersons = DB::table('hrd_person')->where('HR_DEPARTMENT_SUB_SUB_ID','=',$iddep_info)->get();
            
            foreach ($infomatpersons as $infomatperson){

                  $check = Leavepermislevel::where('PERSON_ID','=',$infomatperson->ID)->count();
             
                  if($check == 0){
                    $addperson = new Leavepermislevel(); 
                    $addperson->PERSON_ID = $infomatperson->ID;
                    $infopersonlv = DB::table('hrd_person')->where('ID','=',$infomatperson->ID)->first();
                    $addperson->NAME_PERSON = $infopersonlv->HR_FNAME.' '.$infopersonlv->HR_LNAME;
                    $addperson->DEP_SUB_SUB_ID = $infopersonlv->HR_DEPARTMENT_SUB_SUB_ID;
                    $addperson->save();

                  }

            }

            return redirect()->route('setup.infolevelgroup'); 
    }





    public function setupinfolevelgroup_edit(Request $request, $id)
    { 

        $infoperson = DB::table('hrd_person')->get();
        
        $infolv = DB::table('gleave_permis_level')->where('PERMIS_LEVEL_ID','=',$id)->first();
        $infopersonuse = $infolv->PERSON_ID;
        return view('admin.setupinfolevelgroup_edit',[
            'infopersons'=> $infoperson,
            'infopersonuse'=> $infopersonuse,
            'idref'=> $id,
        
        ]
          
        );
    }



    public function setupinfolevelgroup_update (Request $request)
    {    
                $personid= $request->PERSON_ID;
                $idref= $request->idref;
            
            $addperson = Leavepermislevel::find($idref); 
            $addperson->PERSON_ID = $request->PERSON_ID;

       
            $infopersonlv = DB::table('hrd_person')->where('ID','=',$personid)->first();

            $addperson->NAME_PERSON = $infopersonlv->HR_FNAME.' '.$infopersonlv->HR_LNAME;
            $addperson->DEP_SUB_SUB_ID = $infopersonlv->HR_DEPARTMENT_SUB_SUB_ID;
            $addperson->save();


            return redirect()->route('setup.infolevelgroup'); 
    }



    public function setupinfolevelgroup_destroy(Request $request,$id) { 
                
        Leavepermislevel::destroy($id);         
        
        return redirect()->route('setup.infolevelgroup');  
    }




}
