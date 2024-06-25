<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Person;
use App\Models\Hrddepartment;
use App\Models\Hrddepartmentsub;
use App\Models\Hrddepartmentsubsub;
use App\Models\Level;
use App\Models\Hrdstatus;
use App\Models\Hrdkind;
use App\Models\Hrdkindtype;
use App\Models\Hrdpersontype;
use App\Models\Team;
use App\Models\Teamlist;
use App\Models\Teamposition;
class SetuppersonController extends Controller
{
    //===================================กลุ่มงาน==============================

    public function infodepartment()
    {
       
        $infodepartment = Hrddepartment::select('hrd_department.HR_DEPARTMENT_ID', 'HR_DEPARTMENT_NAME','BOOK_NUM','HR_PREFIX_NAME','HR_FNAME','HR_LNAME','ACTIVE')
        ->leftJoin('hrd_person','hrd_department.LEADER_HR_ID','=','hrd_person.ID')
        ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID') 
        ->orderBy('hrd_department.HR_DEPARTMENT_ID', 'asc')                           
        ->get();

       //dd($infoeducation);savepersondepartment
        return view('admin_person.setupdepartment',[
            'infodepartments' => $infodepartment 
        ]);
    }



    function switchactive_1(Request $request)
    {  
        //return $request->all(); 
        $id = $request->department;
        $departmentactive = Hrddepartment::find($id);
        $departmentactive->ACTIVE = $request->onoff;
        $departmentactive->save();
    }

    public function createdepartment(Request $request)
    {
       //dd($infoeducation);
       $infoperson = DB::table('hrd_person')
       ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
       ->orderBy('hrd_person.HR_FNAME', 'asc')  
       ->where('hrd_person.HR_STATUS_ID', '=',1) 
       ->get();

        return view('admin_person.setupdepartment_add',[
            'infopersons' =>$infoperson
        ]);

    }

    public function savedepartment(Request $request)
    {
        
            $adddepartment = new Hrddepartment(); 
            $adddepartment->HR_DEPARTMENT_NAME = $request->HR_DEPARTMENT_NAME;
            $adddepartment->BOOK_NUM = $request->BOOK_NUM;
            $adddepartment->LEADER_HR_ID = $request->LEADER_HR_ID;
            $adddepartment->ACTIVE = $request->ACTIVE;
           //dd($addbudgetyear);
 
            $adddepartment->save();


            return redirect()->route('setup.indexdepartment'); 
    }

    public function editdepartment(Request $request,$id)
    {
    //return $request->all();

   $id_in= $request->id;

   $infoperson = DB::table('hrd_person')
   ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
   ->orderBy('hrd_person.HR_FNAME', 'asc')  
   ->where('hrd_person.HR_STATUS_ID', '=',1) 
   ->get();
 
   $infodepartment= Hrddepartment::where('HR_DEPARTMENT_ID','=',$id_in)
   ->first();


   return view('admin_person.setupdepartment_edit',[
    'infodepartment' => $infodepartment,
    'infopersons' =>$infoperson 
]);
    }

    public function updatedepartment(Request $request)
    {
        $id = $request->HR_DEPARTMENT_ID; 

        $updatedepartment = Hrddepartment::find($id);
        $updatedepartment->HR_DEPARTMENT_NAME = $request->HR_DEPARTMENT_NAME;
        $updatedepartment->BOOK_NUM = $request->BOOK_NUM;
        $updatedepartment->LEADER_HR_ID = $request->LEADER_HR_ID;
       // $updatedepartment->ACTIVE = $request->ACTIVE;
       //dd($addbudgetyear);

        $updatedepartment->save();
        
        
            return redirect()->route('setup.indexdepartment'); 
    }

    
    public function destroydepartment($id) { 
                
        Hrddepartment::destroy($id);         
        //return redirect()->action('ChangenameController@infouserchangename');  
        return redirect()->route('setup.indexdepartment');   
    }


    //==================จัดการหัวหน้างาน

    public function infodepartment_H()
    {
       
        $infodepartment = Hrddepartment::select('hrd_department.HR_DEPARTMENT_ID', 'HR_DEPARTMENT_NAME','BOOK_NUM','HR_PREFIX_NAME','HR_FNAME','HR_LNAME','ACTIVE','LEADER_HR_ID')
        ->leftJoin('hrd_person','hrd_department.LEADER_HR_ID','=','hrd_person.ID')
        ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID') 
        ->orderBy('hrd_department.HR_DEPARTMENT_ID', 'asc')                           
        ->get();

        $infoperson = DB::table('hrd_person')
        ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->orderBy('hrd_person.HR_FNAME', 'asc')  
        ->where('hrd_person.HR_STATUS_ID', '=',1) 
        ->get();

       //dd($infoeducation);
        return view('admin_person.setupdepartment_h',[
            'infodepartments' => $infodepartment,
            'infopersons' => $infoperson,
             

        ]);
    }

    function updatedepartment_h(Request $request)
    {  
        //return $request->all(); 
        $id = $request->iddep;
        
        $updatedepartment_h = Hrddepartment::find($id);
        $updatedepartment_h->LEADER_HR_ID = $request->value;
        $updatedepartment_h->save();
    }

    //===================================ฝ่ายแผนก==============================

    public function infodepartmentsub()
    {
       
        $infodepartmentsub = Hrddepartmentsub::select('hrd_department_sub.HR_DEPARTMENT_SUB_ID', 'hrd_department_sub.HR_DEPARTMENT_SUB_NAME','HR_DEPARTMENT_NAME','hrd_department_sub.BOOK_NUM','HR_PREFIX_NAME','HR_FNAME','HR_LNAME','hrd_department_sub.ACTIVE')
        ->leftJoin('hrd_person','hrd_department_sub.LEADER_HR_ID','=','hrd_person.ID')
        ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_department','hrd_department_sub.HR_DEPARTMENT_ID','=','hrd_department.HR_DEPARTMENT_ID')  
        ->orderBy('hrd_department_sub.HR_DEPARTMENT_SUB_ID', 'asc')                           
        ->get();

       //dd($infoeducation);
        return view('admin_person.setupdepartmentsub',[
            'infodepartmentsubs' => $infodepartmentsub 
        ]);
    }



    function switchactive_2(Request $request)
    {  
        //return $request->all(); 
        $id = $request->departmentsub;
        $departmentsubactive = Hrddepartmentsub::find($id);
        $departmentsubactive->ACTIVE = $request->onoff;
        $departmentsubactive->save();
    }

    public function createdepartmentsub(Request $request)
    {
       //dd($infoeducation);
       $infoperson = DB::table('hrd_person')
       ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
       ->orderBy('hrd_person.HR_FNAME', 'asc')  
       ->where('hrd_person.HR_STATUS_ID', '=',1)
       ->get();

       $infodepartment = DB::table('hrd_department')->get();

        return view('admin_person.setupdepartmentsub_add',[
            'infopersons' =>$infoperson,
            'infodepartments' =>$infodepartment
        ]);

    }

    public function savedepartmentsub(Request $request)
    {
        
            $adddepartmentsub = new Hrddepartmentsub(); 
            $adddepartmentsub->HR_DEPARTMENT_SUB_NAME = $request->HR_DEPARTMENT_SUB_NAME;
            $adddepartmentsub->HR_DEPARTMENT_ID = $request->HR_DEPARTMENT_ID;
            $adddepartmentsub->LEADER_HR_ID = $request->LEADER_HR_ID;
            $adddepartmentsub->ACTIVE = $request->ACTIVE;
           //dd($addbudgetyear);
 
            $adddepartmentsub->save();


            return redirect()->route('setup.indexdepartmentsub'); 
    }

    public function editdepartmentsub(Request $request,$id)
    {
    //return $request->all();

   $id_in= $request->id;

   $infoperson = DB::table('hrd_person')
   ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
   ->orderBy('hrd_person.HR_FNAME', 'asc')  
   ->where('hrd_person.HR_STATUS_ID', '=',1)
   ->get();

   $infodepartment = DB::table('hrd_department')->get();
 
   $infodepartmentsub= Hrddepartmentsub::where('HR_DEPARTMENT_SUB_ID','=',$id_in)
   ->first();


   return view('admin_person.setupdepartmentsub_edit',[
    'infodepartmentsub' => $infodepartmentsub,
    'infopersons' =>$infoperson,
    'infodepartments' =>$infodepartment 
]);
    }

    public function updatedepartmentsub(Request $request)
    {
        $id = $request->HR_DEPARTMENT_SUB_ID; 

        $updatedepartmentsub = Hrddepartmentsub::find($id);
        $updatedepartmentsub->HR_DEPARTMENT_SUB_NAME = $request->HR_DEPARTMENT_SUB_NAME;
        $updatedepartmentsub->HR_DEPARTMENT_ID = $request->HR_DEPARTMENT_ID;
        $updatedepartmentsub->LEADER_HR_ID = $request->LEADER_HR_ID;
       // $updatedepartment->ACTIVE = $request->ACTIVE;
       //dd($addbudgetyear);

        $updatedepartmentsub->save();
        
        
            return redirect()->route('setup.indexdepartmentsub'); 
    }

    
    public function destroydepartmentsub($id) { 
                
        Hrddepartmentsub::destroy($id);         
        //return redirect()->action('ChangenameController@infouserchangename');  
        return redirect()->route('setup.indexdepartmentsub');   
    }


  

  //==================จัดการหัวหน้างาน

    public function infodepartmentsub_H()
    {
       
        $infodepartmentsub = Hrddepartmentsub::select('hrd_department_sub.HR_DEPARTMENT_SUB_ID', 'hrd_department_sub.HR_DEPARTMENT_SUB_NAME','HR_DEPARTMENT_NAME','hrd_department_sub.BOOK_NUM','HR_PREFIX_NAME','HR_FNAME','HR_LNAME','hrd_department_sub.ACTIVE','hrd_department_sub.LEADER_HR_ID')
        ->leftJoin('hrd_person','hrd_department_sub.LEADER_HR_ID','=','hrd_person.ID')
        ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_department','hrd_department_sub.HR_DEPARTMENT_ID','=','hrd_department.HR_DEPARTMENT_ID')  
        ->orderBy('hrd_department_sub.HR_DEPARTMENT_SUB_ID', 'asc')                           
        ->get();

        $infoperson = DB::table('hrd_person')
        ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->orderBy('hrd_person.HR_FNAME', 'asc')  
        ->where('hrd_person.HR_STATUS_ID', '=',1) 
        ->get();

       //dd($infoeducation);
        return view('admin_person.setupdepartmentsub_h',[
            'infodepartmentsubs' => $infodepartmentsub, 
            'infopersons' => $infoperson,
        ]);
    }

    function updatedepartsubment_h(Request $request)
    {  
        //return $request->all(); 
        $id = $request->iddep;
        
        $updatedepartment_h = Hrddepartmentsub::find($id);
        $updatedepartment_h->LEADER_HR_ID = $request->value;
        $updatedepartment_h->save();
    }


     //===================================หน่วยงาน==============================

     public function infodepartmentsubsub()
     {
        
         $infodepartmentsubsub = Hrddepartmentsubsub::select('hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_NAME','HR_DEPARTMENT_SUB_NAME','hrd_department_sub_sub.BOOK_NUM','HR_PREFIX_NAME','DEP_CODE','HR_FNAME','HR_LNAME','hrd_department_sub_sub.ACTIVE')
         ->leftJoin('hrd_person','hrd_department_sub_sub.LEADER_HR_ID','=','hrd_person.ID')
         ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
         ->leftJoin('hrd_department_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')  
         ->orderBy('hrd_department_sub_sub.HR_DEPARTMENT_SUB_ID', 'asc')                           
         ->get();
 
        //dd($infoeducation);
         return view('admin_person.setupdepartmentsubsub',[
             'infodepartmentsubsubs' => $infodepartmentsubsub 
         ]);
     }
 
 
 
     function switchactive_3(Request $request)
     {  
         //return $request->all(); 
         $id = $request->departmentsubsub;
         $departmentsubsubactive = Hrddepartmentsubsub::find($id);
         $departmentsubsubactive->ACTIVE = $request->onoff;
         $departmentsubsubactive->save();
     }
 
     public function createdepartmentsubsub(Request $request)
     {
        //dd($infoeducation);
        $infoperson = DB::table('hrd_person')
        ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->orderBy('hrd_person.HR_FNAME', 'asc')  
        ->where('hrd_person.HR_STATUS_ID', '=',1) 
        ->get();
 
        $infodepartmentsub = DB::table('hrd_department_sub')->get();
 
         return view('admin_person.setupdepartmentsubsub_add',[
             'infopersons' =>$infoperson,
             'infodepartmentsubs' =>$infodepartmentsub
         ]);
 
     }
 
     public function savedepartmentsubsub(Request $request)
     {
         
             $adddepartmentsubsub = new Hrddepartmentsubsub(); 
             $adddepartmentsubsub->HR_DEPARTMENT_SUB_SUB_NAME = $request->HR_DEPARTMENT_SUB_SUB_NAME;
             $adddepartmentsubsub->HR_DEPARTMENT_SUB_ID = $request->HR_DEPARTMENT_SUB_ID;
             $adddepartmentsubsub->LEADER_HR_ID = $request->LEADER_HR_ID;
             $adddepartmentsubsub->ACTIVE = $request->ACTIVE;
             $adddepartmentsubsub->DEP_CODE = $request->DEP_CODE;
             $adddepartmentsubsub->LINE_TOKEN = $request->LINE_TOKEN;
            //dd($addbudgetyear);
  
             $adddepartmentsubsub->save();
 
 
             return redirect()->route('setup.indexdepartmentsubsub'); 
     }
 
     public function editdepartmentsubsub(Request $request,$id)
     {
     //return $request->all();
 
    $id_in= $request->id;
 
    $infoperson = DB::table('hrd_person')
    ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->orderBy('hrd_person.HR_FNAME', 'asc')  
    ->where('hrd_person.HR_STATUS_ID', '=',1)
    ->get();
 
    $infodepartmentsub = DB::table('hrd_department_sub')->get();
  
    $infodepartmentsubsub= Hrddepartmentsubsub::where('HR_DEPARTMENT_SUB_SUB_ID','=',$id_in)
    ->first();
 
 
    return view('admin_person.setupdepartmentsubsub_edit',[
     'infodepartmentsubsub' => $infodepartmentsubsub,
     'infopersons' =>$infoperson,
     'infodepartmentsubs' =>$infodepartmentsub 
 ]);
     }
 
     public function updatedepartmentsubsub(Request $request)
     {
         $id = $request->HR_DEPARTMENT_SUB_SUB_ID; 
 
         $updatedepartmentsubsub = Hrddepartmentsubsub::find($id);
         $updatedepartmentsubsub->HR_DEPARTMENT_SUB_SUB_NAME = $request->HR_DEPARTMENT_SUB_SUB_NAME;
         $updatedepartmentsubsub->HR_DEPARTMENT_SUB_ID = $request->HR_DEPARTMENT_SUB_ID;
         $updatedepartmentsubsub->LEADER_HR_ID = $request->LEADER_HR_ID;
         $updatedepartmentsubsub->DEP_CODE = $request->DEP_CODE;
         $updatedepartmentsubsub->LINE_TOKEN = $request->LINE_TOKEN;
        //dd($addbudgetyear);
 
         $updatedepartmentsubsub->save();
         
         
             return redirect()->route('setup.indexdepartmentsubsub'); 
     }
 
     
     public function destroydepartmentsubsub($id) { 
                 
        Hrddepartmentsubsub::destroy($id);         
         //return redirect()->action('ChangenameController@infouserchangename');  
         return redirect()->route('setup.indexdepartmentsubsub');   
     }
 


     public function infodepartmentsubsub_H()
     {
        
         $infodepartmentsubsub = Hrddepartmentsubsub::select('hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_NAME','HR_DEPARTMENT_SUB_NAME','hrd_department_sub_sub.BOOK_NUM','HR_PREFIX_NAME','HR_FNAME','HR_LNAME','hrd_department_sub_sub.ACTIVE','hrd_department_sub_sub.LEADER_HR_ID')
         ->leftJoin('hrd_person','hrd_department_sub_sub.LEADER_HR_ID','=','hrd_person.ID')
         ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
         ->leftJoin('hrd_department_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')  
         ->orderBy('hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID', 'asc')                           
         ->get();

         $infoperson = DB::table('hrd_person')
         ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
         ->orderBy('hrd_person.HR_FNAME', 'asc')  
         ->where('hrd_person.HR_STATUS_ID', '=',1) 
         ->get();
 
        //dd($infoeducation);
         return view('admin_person.setupdepartmentsubsub_h',[
             'infodepartmentsubsubs' => $infodepartmentsubsub,
             'infopersons' => $infoperson,
         ]);
     }



     function selectupdatedepartsubsubment_h(Request $request)
     {  
         //return $request->all(); 

         $infopersons = DB::table('hrd_person')
         ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
         ->orderBy('hrd_person.HR_FNAME', 'asc')  
         ->where('hrd_person.HR_STATUS_ID', '=',1) 
         ->get();

         $id = $request->iddep;
         

                        $output ='
                        <input type="hidden" id="iddep" name="iddep" value="'.$id.'">
                        <select name="USER_ID" id="USER_ID" class="form-control input-lg" style=" font-family: \'Kanit\', sans-serif;" >
                        <option value="">--กรุณาเลือกหัวหน้าหน่วยงาน--</option>';

                        foreach($infopersons as $infoperson){
                            $output.='<option value="'.$infoperson ->ID.'">'.$infoperson->HR_FNAME.' '.$infoperson->HR_LNAME.'</option>';
                        }
                        
                        $output.='</select>';

                echo $output;
      
     }


     function updatedepartsubsubment_h(Request $request)
     {  
         //return $request->all(); 
         $id = $request->iddep;
        
         
         $updatedepartment_h = Hrddepartmentsubsub::find($id);
         $updatedepartment_h->LEADER_HR_ID = $request->USER_ID;
         $updatedepartment_h->save();


         return redirect()->route('setup.indexdepartmentsubsub_H');

     }
 




    //===================================ระดับ==============================
    public function infolevel()
    {
       
        $infolevel = Level::orderBy('HR_LEVEL_ID', 'asc')  
                                     ->get();

       //dd($infoeducation);
        return view('admin_person.setuplevel',[
            'infolevels' => $infolevel 
        ]);
    }
    public function createlevel(Request $request)
    {
       //dd($infoeducation);
        return view('admin_person.setuplevel_add');

    }

    public function savelevel(Request $request)
    {

            $addlevel = new Level(); 
            $addlevel->HR_LEVEL_NAME = $request->HR_LEVEL_NAME;
            $addlevel->save();

            return redirect()->route('setup.indexpersonlevel'); 
    }

    public function editlevel(Request $request,$id)
    {
    //return $request->all();

   $id_in= $request->id;
 
   $infolevel = Level::where('HR_LEVEL_ID','=',$id_in)
   ->first();


   return view('admin_person.setuplevel_edit',[
    'infolevel' => $infolevel 
]);
    }

    public function updatelevel(Request $request)
    {
        $id = $request->HR_LEVEL_ID; 

        $updatelevel = Level::find($id);
        $updatelevel->HR_LEVEL_NAME = $request->HR_LEVEL_NAME;
       
        $updatelevel->save();
        
        
            return redirect()->route('setup.indexpersonlevel'); 
    }

    
    public function destroylevel($id) { 
                
        Level::destroy($id);         
        //return redirect()->action('ChangenameController@infouserchangename');  
        return redirect()->route('setup.indexpersonlevel');   
    }


     //===================================สถานะปัจจุบัน==============================
     public function infostatus()
     {
        
         $infostatus = Hrdstatus::orderBy('HR_STATUS_ID', 'asc')  
                                      ->get();
 
        //dd($infoeducation);
         return view('admin_person.setupstatus',[
             'infostatuss' => $infostatus 
         ]);
     }
     public function createstatus(Request $request)
     {
        //dd($infoeducation);
         return view('admin_person.setupstatus_add');
 
     }
 
     public function savestatus(Request $request)
     {
 
             $addstatus = new Hrdstatus(); 
             $addstatus->HR_STATUS_NAME = $request->HR_STATUS_NAME;
             $addstatus->save();
 
             return redirect()->route('setup.indexpersonstatus'); 
     }
 
     public function editstatus(Request $request,$id)
     {
     //return $request->all();
 
    $id_in= $request->id;
  
    $infostatus = Hrdstatus::where('HR_STATUS_ID','=',$id_in)
    ->first();
 
 
    return view('admin_person.setupstatus_edit',[
     'infostatus' => $infostatus 
 ]);
     }
 
     public function updatestatus(Request $request)
     {
         $id = $request->HR_STATUS_ID; 
 
         $updatestatus = Hrdstatus::find($id);
         $updatestatus->HR_STATUS_NAME = $request->HR_STATUS_NAME;
        
         $updatestatus->save();
         
         
             return redirect()->route('setup.indexpersonstatus'); 
     }
 
     
     public function destroystatus($id) { 
                 
        Hrdstatus::destroy($id);         
         //return redirect()->action('ChangenameController@infouserchangename');  
         return redirect()->route('setup.indexpersonstatus');   
     }


      //===================================กลุ่มข้าราชการ==============================
      public function infokind()
      {
         
          $infokind = Hrdkind::orderBy('HR_KIND_ID', 'asc')  
                                       ->get();
  
         //dd($infoeducation);
          return view('admin_person.setupkind',[
              'infokinds' => $infokind 
          ]);
      }
      public function createkind(Request $request)
      {
         //dd($infoeducation);
          return view('admin_person.setupkind_add');
  
      }
  
      public function savekind(Request $request)
      {
  
              $addkind = new Hrdkind(); 
              $addkind->HR_KIND_NAME = $request->HR_KIND_NAME;
              $addkind->save();
  
              return redirect()->route('setup.indexpersonkind'); 
      }
  
      public function editkind(Request $request,$id)
      {
      //return $request->all();
  
     $id_in= $request->id;
   
     $infokind = Hrdkind::where('HR_KIND_ID','=',$id_in)
     ->first();
  
  
     return view('admin_person.setupkind_edit',[
      'infokind' => $infokind
  ]);
      }
  
      public function updatekind(Request $request)
      {
          $id = $request->HR_KIND_ID; 
  
          $updatekind = Hrdkind::find($id);
          $updatekind->HR_KIND_NAME = $request->HR_KIND_NAME;
         
          $updatekind->save();
          
          
              return redirect()->route('setup.indexpersonkind'); 
      }
  
      
      public function destroykind($id) { 
                  
        Hrdkind::destroy($id);         
          //return redirect()->action('ChangenameController@infouserchangename');  
          return redirect()->route('setup.indexpersonkind');   
      }
  

        //===================================ประเภทข้าราชการ==============================
        public function infokindtype()
        {
           
            $infokindtype = Hrdkindtype::leftJoin('hrd_kind','hrd_kind.HR_KIND_ID','=','hrd_kind_type.HR_KIND_ID')
                        ->orderBy('HR_KIND_TYPE_ID', 'asc')  
                        ->get();
    
           //dd($infoeducation);
            return view('admin_person.setupkindtype',[
                'infokindtypes' => $infokindtype 
            ]);
        }
        public function createkindtype(Request $request)
        {
           
           $infokindselect = Hrdkind::orderBy('HR_KIND_ID', 'asc')  
           ->get();
           //dd($infokind_select);

           return view('admin_person.setupkindtype_add',[
            'infokindselects' => $infokindselect 
        ]);
    
        }
    
        public function savekindtype(Request $request)
        {
    
                $addkindtype = new Hrdkindtype(); 
                $addkindtype->HR_KIND_ID = $request->HR_KIND_ID;
                $addkindtype->HR_KIND_TYPE_NAME = $request->HR_KIND_TYPE_NAME;
                $addkindtype->save();
    
                return redirect()->route('setup.indexpersonkindtype'); 
        }
    
        public function editkindtype(Request $request,$id)
        {
        //return $request->all();
    
       $id_in= $request->id;
     
       $infokindtype = Hrdkindtype::leftJoin('hrd_kind','hrd_kind.HR_KIND_ID','=','hrd_kind_type.HR_KIND_ID')
       ->where('HR_KIND_TYPE_ID','=',$id_in)
       ->first();
    
       $infokindselect = Hrdkind::orderBy('HR_KIND_ID', 'asc')  
           ->get();
    
       return view('admin_person.setupkindtype_edit',[
        'infokindtype' => $infokindtype,
        'infokindselects' => $infokindselect
        
    ]);
        }
    
        public function updatekindtype(Request $request)
        {
            $id = $request->HR_KIND_TYPE_ID; 
    
            $updatekindtype = Hrdkindtype::find($id);
            $updatekindtype->HR_KIND_ID = $request->HR_KIND_ID;
            $updatekindtype->HR_KIND_TYPE_NAME = $request->HR_KIND_TYPE_NAME;
           
            $updatekindtype->save();
            
            
                return redirect()->route('setup.indexpersonkindtype'); 
        }
    
        
        public function destroykindtype($id) { 
                    
            Hrdkindtype::destroy($id);         
            //return redirect()->action('ChangenameController@infouserchangename');  
            return redirect()->route('setup.indexpersonkindtype');   
        }


             //===================================กลุ่มบุคลากร==============================
      public function infopersontype()
      {
         
          $infopersontype = Hrdpersontype::orderBy('HR_PERSON_TYPE_ID', 'asc')  
                                       ->get();
  
         //dd($infoeducation);
          return view('admin_person.setuppersontype',[
              'infopersontypes' => $infopersontype 
          ]);
      }
      public function createpersontype(Request $request)
      {
         //dd($infoeducation);
          return view('admin_person.setuppersontype_add');
  
      }
  
      public function savepersontype(Request $request)
      {
  
              $addpersontype = new Hrdpersontype(); 
              $addpersontype->HR_PERSON_TYPE_NAME = $request->HR_PERSON_TYPE_NAME;
              $addpersontype->HR_LEAVE04_CMD = $request->HR_LEAVE04_CMD;
              $addpersontype->HR_LEAVE04_DAY = $request->HR_LEAVE04_DAY;
              $addpersontype->save();
  
              return redirect()->route('setup.indexpersontype'); 
      }
  
      public function editpersontype(Request $request,$id)
      {
      //return $request->all();
  
     $id_in= $request->id;
   
     $infopersontype = Hrdpersontype::where('HR_PERSON_TYPE_ID','=',$id_in)
     ->first();
  
  
     return view('admin_person.setuppersontype_edit',[
      'infopersontype' => $infopersontype
  ]);
      }
  
      public function updatepersontype(Request $request)
      {
          $id = $request->HR_PERSON_TYPE_ID; 
  
          $updatepersontype = Hrdpersontype::find($id);
          $updatepersontype->HR_PERSON_TYPE_NAME = $request->HR_PERSON_TYPE_NAME;
          $updatepersontype->HR_LEAVE04_CMD = $request->HR_LEAVE04_CMD;
          $updatepersontype->HR_LEAVE04_DAY = $request->HR_LEAVE04_DAY;
         
          $updatepersontype->save();
          
          
              return redirect()->route('setup.indexpersontype'); 
      }
  
      
      public function destroypersontype($id) { 
                  
        Hrdpersontype::destroy($id);         
          //return redirect()->action('ChangenameController@infouserchangename');  
          return redirect()->route('setup.indexpersontype');   
      }
  
    
   //===============================================ทีมนำองค์กร=========================================
   public function infoteam()
   {
      
       $infoteam = Team::orderBy('HR_TEAM_ID', 'asc')                           
       ->get();

      //dd($infoeducation);
       return view('admin_person.setupteam_index',[
           'infoteams' => $infoteam 
       ]);
   }

   public function createteam(Request $request)
   {
      //dd($infoeducation);
      $infoperson = DB::table('hrd_person')
      ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
      ->orderBy('hrd_person.HR_FNAME', 'asc')  
      ->where('hrd_person.HR_STATUS_ID', '=',1)
      ->get();

       return view('admin_person.setupteam_indexadd',[
           'infopersons' =>$infoperson
       ]);

   }

   public function saveteam(Request $request)
   {

           $addteam = new Team(); 
           $addteam->HR_TEAM_NAME = $request->HR_TEAM_NAME;
           $addteam->HR_TEAM_DETAIL = $request->HR_TEAM_DETAIL;
           $addteam->save();

           return redirect()->route('setup.infoteam'); 
   }
 
   public function editteam(Request $request,$id)
   {
      //dd($infoeducation);
      $infoperson = DB::table('hrd_person')
      ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
      ->orderBy('hrd_person.HR_FNAME', 'asc')  
      ->where('hrd_person.HR_STATUS_ID', '=',1) 
      ->get();

      $infoteam = DB::table('hrd_team')
      ->where('HR_TEAM_ID','=',$id)
      ->first();

       return view('admin_person.setupteam_indexedit',[
           'infopersons' =>$infoperson,
           'infoteam' => $infoteam 
       ]);

   }

   public function updateteam(Request $request)
   {
           $id = $request->HR_TEAM_ID; 

           $updateteam = Team::find($id);
           $updateteam->HR_TEAM_NAME = $request->HR_TEAM_NAME;
           $updateteam->HR_TEAM_DETAIL = $request->HR_TEAM_DETAIL;
           $updateteam->save();

           return redirect()->route('setup.infoteam'); 
   }

   public function destroyteam($id) { 
                
    Team::destroy($id);      
    Teamlist::where('TEAM_ID','=',$id)->delete();    
    //return redirect()->action('ChangenameController@infouserchangename');  
    return redirect()->route('setup.infoteam');   
}
 //-----------------------------------------------------------

 public function committee($id)
 {
 
     
     
     $inforperson =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
     ->leftJoin('hrd_sex','hrd_person.SEX','=','hrd_sex.SEX_ID')
     ->leftJoin('hrd_status','hrd_person.HR_STATUS_ID','=','hrd_status.HR_STATUS_ID')
     ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
     ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
     ->leftJoin('hrd_department','hrd_person.HR_DEPARTMENT_ID','=','hrd_department.HR_DEPARTMENT_ID')
     ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
     ->leftJoin('hrd_bloodgroup','hrd_person.HR_BLOODGROUP_ID','=','hrd_bloodgroup.HR_BLOODGROUP_ID')
     ->leftJoin('hrd_marry_status','hrd_person.HR_MARRY_STATUS_ID','=','hrd_marry_status.HR_MARRY_STATUS_ID')
     ->leftJoin('hrd_religion','hrd_person.HR_RELIGION_ID','=','hrd_religion.HR_RELIGION_ID')
     ->leftJoin('hrd_nationality','hrd_person.HR_NATIONALITY_ID','=','hrd_nationality.HR_NATIONALITY_ID')
     ->leftJoin('hrd_citizenship','hrd_person.HR_CITIZENSHIP_ID','=','hrd_citizenship.HR_CITIZENSHIP_ID')
     ->leftJoin('hrd_tumbon','hrd_person.TUMBON_ID','=','hrd_tumbon.ID')
     ->leftJoin('hrd_amphur','hrd_person.AMPHUR_ID','=','hrd_amphur.ID')
     ->leftJoin('hrd_province','hrd_person.PROVINCE_ID','=','hrd_province.ID')
     ->leftJoin('hrd_kind','hrd_person.HR_KIND_ID','=','hrd_kind.HR_KIND_ID')
     ->leftJoin('hrd_kind_type','hrd_person.HR_KIND_TYPE_ID','=','hrd_kind_type.HR_KIND_TYPE_ID')
     ->leftJoin('hrd_person_type','hrd_person.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
     ->orderBy('hrd_person.HR_FNAME', 'asc')  
     ->where('hrd_person.HR_STATUS_ID', '=',1) 
     ->get();

     $inforTeamposition = Teamposition::get();
   
     $infoTeamlist = Teamlist::leftJoin('hrd_team_position','hrd_team_position.TEAM_POSITION_ID','=','hrd_team_list.TEAM_POSITION_ID')
     ->where('hrd_team_list.TEAM_ID','=',$id)
     ->orderBy('hrd_team_list.ID', 'asc') 
     ->get();

     $teamid =  Team::where('HR_TEAM_ID','=',$id)->first();

    //dd($infoeducation);
     return view('admin_person.setupteam_committee',[
         'infoTeamlists' => $infoTeamlist,
         'inforpersons' =>$inforperson,
         'teamid' =>$teamid,
         'inforTeampositions' => $inforTeamposition 
     ]);
 }

  
 public function createcommittee(Request $request,$id)
 {
    //dd($infoeducation);
    $infoperson = DB::table('hrd_person')
    ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->orderBy('hrd_person.HR_FNAME', 'asc')  
    ->where('hrd_person.HR_STATUS_ID', '=',1)
    ->get();

    $inforTeamposition = Teamposition::get();

    $teamid =  Team::where('HR_TEAM_ID','=',$id)->first();

     return view('admin_person.setupteam_committeeadd',[
         'infopersons' =>$infoperson,
         'teamid' =>$teamid,
         'inforTeampositions' => $inforTeamposition 
     ]);

 }

 public function savecommittee(Request $request)
 {

         $addteamlist = new Teamlist(); 
         $addteamlist->PERSON_ID = $request->PERSON_ID;

         $person=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
         ->where('hrd_person.ID','=',$request->PERSON_ID)->first();

         $addteamlist->BOARD_NAME = $person->HR_PREFIX_NAME.''.$person->HR_FNAME.' '.$person->HR_LNAME;
         $addteamlist->BOARD_POSITION  = $person->POSITION_IN_WORK;

         $addteamlist->TEAM_POSITION_ETC  = $request->TEAM_POSITION_ETC;      
         $addteamlist->TEAM_ID = $request->TEAM_ID;
         $addteamlist->TEAM_POSITION_ID = $request->TEAM_POSITION_ID;
         $addteamlist->save();


         return redirect()->route('setup.committee',[
            'id' => $request->TEAM_ID   
        ]); 
 }


 public function editcommittee(Request $request,$id,$idteam)
 {
    //dd($infoeducation);
    $infoperson = DB::table('hrd_person')
    ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->orderBy('hrd_person.HR_FNAME', 'asc')  
    ->where('hrd_person.HR_STATUS_ID', '=',1)
    ->get();

    $inforTeamposition = Teamposition::get();

    $teamid =  Team::where('HR_TEAM_ID','=',$idteam)->first();

    $inforTeamlist = Teamlist::where('ID','=',$id)
                    ->first();

     return view('admin_person.setupteam_committeeedit',[
         'infopersons' =>$infoperson,
         'teamid' =>$teamid,
         'inforTeampositions' => $inforTeamposition,
         'inforTeamlist'=> $inforTeamlist
     ]);

 }

 public function updatecommittee(Request $request)
 {
          $id = $request->ID;
         $updateteamlist = Teamlist::find($id);
         $updateteamlist->PERSON_ID = $request->PERSON_ID;

         $person=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
         ->where('hrd_person.ID','=',$request->PERSON_ID)->first();

         $updateteamlist->BOARD_NAME = $person->HR_PREFIX_NAME.''.$person->HR_FNAME.' '.$person->HR_LNAME;
         $updateteamlist->BOARD_POSITION  = $person->POSITION_IN_WORK;
       
         $updateteamlist->TEAM_POSITION_ETC  = $request->TEAM_POSITION_ETC;
         $updateteamlist->TEAM_ID = $request->TEAM_ID;
         $updateteamlist->TEAM_POSITION_ID = $request->TEAM_POSITION_ID;
         $updateteamlist->save();


         return redirect()->route('setup.committee',[
            'id' => $request->TEAM_ID   
        ]); 
 }

 public function destroycommittee($id,$idteam) { 
                 
    Teamlist::destroy($id);
   
     //return redirect()->action('ChangenameController@infouserchangename');  
     return redirect()->route('setup.committee',[
        'id' => $idteam 
    ]);

 }

  //===============================================ทีมนำองค์กร=========================================
  public function teamposition()
  {
     
      $infoteamposition = Teamposition::orderBy('TEAM_POSITION_ID', 'asc')                           
      ->get();

     //dd($infoeducation);
      return view('admin_person.setupteamposition',[
          'infoteampositions' => $infoteamposition 
      ]);
  }

  public function createteamposition(Request $request)
  {
     //dd($infoeducation)

      return view('admin_person.setupteamposition_add');

  }

  public function saveteamposition(Request $request)
  {

          $addteamposition = new Teamposition(); 
          $addteamposition->TEAM_POSITION_NAME = $request->TEAM_POSITION_NAME;
          $addteamposition->save();

          return redirect()->route('setup.teamposition'); 
  }

  public function editteamposition(Request $request,$id)
  {
     //dd($infoeducation);

     $infoteamposition = Teamposition::where('TEAM_POSITION_ID','=',$id)
                        ->first();

      return view('admin_person.setupteamposition_edit',[
          'infoteamposition' =>$infoteamposition
          
      ]);

  }

  public function updateteamposition(Request $request)
  {
          $id = $request->TEAM_POSITION_ID; 

          $updateteamposition = Teamposition::find($id);
          $updateteamposition->TEAM_POSITION_NAME = $request->TEAM_POSITION_NAME;
          $updateteamposition->save();

          return redirect()->route('setup.teamposition'); 
  }

  public function destroyteamposition($id) { 
               
    Teamposition::destroy($id);         
 
   return redirect()->route('setup.teamposition');   
}

}
