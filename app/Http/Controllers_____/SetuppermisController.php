<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Person;
use App\Models\Permislist;
use App\Models\Permis;
use App\Models\Permismenu;


class SetuppermisController extends Controller
{
    public function infopermis()
    {        
        $inforperson =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_sex','hrd_person.SEX','=','hrd_sex.SEX_ID')
        ->leftJoin('hrd_status','hrd_person.HR_STATUS_ID','=','hrd_status.HR_STATUS_ID')
        ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
        ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->leftJoin('hrd_department','hrd_person.HR_DEPARTMENT_ID','=','hrd_department.HR_DEPARTMENT_ID')
        ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
        // ->leftJoin('hrd_bloodgroup','hrd_person.HR_BLOODGROUP_ID','=','hrd_bloodgroup.HR_BLOODGROUP_ID')
        // ->leftJoin('hrd_marry_status','hrd_person.HR_MARRY_STATUS_ID','=','hrd_marry_status.HR_MARRY_STATUS_ID')
        // ->leftJoin('hrd_religion','hrd_person.HR_RELIGION_ID','=','hrd_religion.HR_RELIGION_ID')
        // ->leftJoin('hrd_nationality','hrd_person.HR_NATIONALITY_ID','=','hrd_nationality.HR_NATIONALITY_ID')
        // ->leftJoin('hrd_citizenship','hrd_person.HR_CITIZENSHIP_ID','=','hrd_citizenship.HR_CITIZENSHIP_ID')
        // ->leftJoin('hrd_tumbon','hrd_person.TUMBON_ID','=','hrd_tumbon.ID')
        // ->leftJoin('hrd_amphur','hrd_person.AMPHUR_ID','=','hrd_amphur.ID')
        // ->leftJoin('hrd_province','hrd_person.PROVINCE_ID','=','hrd_province.ID')
        // ->leftJoin('hrd_kind','hrd_person.HR_KIND_ID','=','hrd_kind.HR_KIND_ID')
        // ->leftJoin('hrd_kind_type','hrd_person.HR_KIND_TYPE_ID','=','hrd_kind_type.HR_KIND_TYPE_ID')
        // ->leftJoin('hrd_person_type','hrd_person.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
        // ->leftJoin('gsy_permis_list','hrd_person.ID','=','gsy_permis_list.PERSON_ID')
        // ->orderBy('hrd_person.HR_FNAME', 'asc')  
        ->where('hrd_person.HR_STATUS_ID', '=',1)
        ->get();
       
        $infopermis = Permislist::leftJoin('hrd_person','gsy_permis_list.PERSON_ID','=','hrd_person.ID')
                ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                ->select('HR_PREFIX_NAME','HR_FNAME','HR_LNAME','POSITION_IN_WORK','PERSON_ID', DB::raw('count(*) as total'))
                ->orderBy('PERSON_ID', 'asc') 
                ->groupBy('HR_PREFIX_NAME','HR_FNAME','HR_LNAME','PERSON_ID','POSITION_IN_WORK')
                ->get();


        // $infopermisonly = Permislist::where('PERSON_ID', '=',1)
        //         ->get();

        $inforpermisselect = Permis::get();


       //dd($infoeducation);
        return view('admin.setuppermis',[
            'infopermiss' => $infopermis,
            'inforpersons' =>$inforperson,
            'inforpermisselects' => $inforpermisselect 
        ]);
    }
    public function setupinfopermis_addsearch(Request $request)
    {   
        $iduser = $request->USE_ID;     
        // dd($iduser);
   
        $info =  Person::first();
        $perid = Permislist::where('PERSON_ID', '=',$info->ID)->get();
    
        $infopermis = Permislist::where('gsy_permis_list.PERSON_ID', '=',$iduser)->get();

        $infopermisperson = DB::table('gsy_permis')->where('PERMIS_ID','like','GHR%')->get();

        $infopermisperson_gre = DB::table('gsy_permis')->where('PERMIS_ID','like','GRE%')->get();
        $infopermisperson_gts = DB::table('gsy_permis')->where('PERMIS_ID','like','GTS%')->get();
        $infopermisperson_gle = DB::table('gsy_permis')->where('PERMIS_ID','like','GLE%')->get();
        $infopermisperson_gmb = DB::table('gsy_permis')->where('PERMIS_ID','like','GMB%')->get();
        $infopermisperson_gme = DB::table('gsy_permis')->where('PERMIS_ID','like','GME%')->get();
        $infopermisperson_gca = DB::table('gsy_permis')->where('PERMIS_ID','like','GCA%')->get();
        $infopermisperson_gas = DB::table('gsy_permis')->where('PERMIS_ID','like','GAS%')->get();
        $infopermisperson_gsu = DB::table('gsy_permis')->where('PERMIS_ID','like','GSU%')->get();
        $infopermisperson_grp = DB::table('gsy_permis')->where('PERMIS_ID','like','GRP%')->get();
        $infopermisperson_grc = DB::table('gsy_permis')->where('PERMIS_ID','like','GRC%')->get();
        $infopermisperson_grm = DB::table('gsy_permis')->where('PERMIS_ID','like','GRM%')->get();
        $infopermisperson_gsa = DB::table('gsy_permis')->where('PERMIS_ID','like','GSA%')->get();
        $infopermisperson_gmw = DB::table('gsy_permis')->where('PERMIS_ID','like','GMW%')->get();
        $infopermisperson_gmm = DB::table('gsy_permis')->where('PERMIS_ID','like','GMM%')->get();
        $infopermisperson_gmp = DB::table('gsy_permis')->where('PERMIS_ID','like','GMP%')->where('PERMIS_ID','<>','GMP002')->get();
        $infopermisperson_gmc = DB::table('gsy_permis')->where('PERMIS_ID','like','GMC%')->where('PERMIS_ID','<>','GMC001')->get();
        $infopermisperson_heal = DB::table('gsy_permis')->where('PERMIS_ID','like','HEAL%')->get();
        $infopermisperson_gmr = DB::table('gsy_permis')->where('PERMIS_ID','like','GMR%')->get();
        $infopermisperson_gmp002 = DB::table('gsy_permis')->where('PERMIS_ID','like','GMP002%')->get();
        $infopermisperson_gml = DB::table('gsy_permis')->where('PERMIS_ID','like','GML%')->get();
        $infopermisperson_gmg = DB::table('gsy_permis')->where('PERMIS_ID','like','GMG%')->get();
        $infopermisperson_gmn = DB::table('gsy_permis')->where('PERMIS_ID','like','GMN%')->get();
        $infopermisperson_gmf = DB::table('gsy_permis')->where('PERMIS_ID','like','GMF%')->get();
        $infopermisperson_gmc002 = DB::table('gsy_permis')->where('PERMIS_ID','like','GMC%')->where('PERMIS_ID','<>','GMC002')->get();
        $infopermisperson_horg = DB::table('gsy_permis')->where('PERMIS_ID','like','HORG%')->get();
        $infopermisperson_happy = DB::table('gsy_permis')->where('PERMIS_ID','like','HAPPY%')->get();
        $infopermisperson_opa = DB::table('gsy_permis')->where('PERMIS_ID','like','opa%')->get();
        
        $infopermislist = Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')->where('ID', '=',$iduser)
        ->first();

        return view('admin.setupinfopermis_addsearch',compact(
            'infopermis','infopermislist','infopermisperson','infopermisperson_gre','infopermisperson_gts','infopermisperson_gle','infopermisperson_gmb','infopermisperson_gme',
            'infopermisperson_gca','infopermisperson_gas','infopermisperson_gsu','infopermisperson_grp','infopermisperson_grc','infopermisperson_grm','infopermisperson_gsa',
            'infopermisperson_gmw','infopermisperson_gmm','infopermisperson_gmp','infopermisperson_gmc','infopermisperson_heal','infopermisperson_gmr','infopermisperson_gmp002',
            'infopermisperson_gml','infopermisperson_gmg','infopermisperson_gmn','infopermisperson_gmf','infopermisperson_gmc002','infopermisperson_horg','infopermisperson_happy',
            'infopermisperson_opa'
        ));
      
    }


    public function setupinfopermis_add()
    {        
        $inforperson =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
            ->leftJoin('hrd_sex','hrd_person.SEX','=','hrd_sex.SEX_ID')
            ->leftJoin('hrd_status','hrd_person.HR_STATUS_ID','=','hrd_status.HR_STATUS_ID')
            ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
            ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
            ->leftJoin('hrd_department','hrd_person.HR_DEPARTMENT_ID','=','hrd_department.HR_DEPARTMENT_ID')
            ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
            // ->leftJoin('hrd_bloodgroup','hrd_person.HR_BLOODGROUP_ID','=','hrd_bloodgroup.HR_BLOODGROUP_ID')
            // ->leftJoin('hrd_marry_status','hrd_person.HR_MARRY_STATUS_ID','=','hrd_marry_status.HR_MARRY_STATUS_ID')
            // ->leftJoin('hrd_religion','hrd_person.HR_RELIGION_ID','=','hrd_religion.HR_RELIGION_ID')
            // ->leftJoin('hrd_nationality','hrd_person.HR_NATIONALITY_ID','=','hrd_nationality.HR_NATIONALITY_ID')
            // ->leftJoin('hrd_citizenship','hrd_person.HR_CITIZENSHIP_ID','=','hrd_citizenship.HR_CITIZENSHIP_ID')
            // ->leftJoin('hrd_tumbon','hrd_person.TUMBON_ID','=','hrd_tumbon.ID')
            // ->leftJoin('hrd_amphur','hrd_person.AMPHUR_ID','=','hrd_amphur.ID')
            // ->leftJoin('hrd_province','hrd_person.PROVINCE_ID','=','hrd_province.ID')
            // ->leftJoin('hrd_kind','hrd_person.HR_KIND_ID','=','hrd_kind.HR_KIND_ID')
            // ->leftJoin('hrd_kind_type','hrd_person.HR_KIND_TYPE_ID','=','hrd_kind_type.HR_KIND_TYPE_ID')
            // ->leftJoin('hrd_person_type','hrd_person.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
            ->leftJoin('gsy_permis_list','hrd_person.ID','=','gsy_permis_list.PERSON_ID')
            // ->orderBy('hrd_person.HR_FNAME', 'asc')  
            ->where('hrd_person.HR_STATUS_ID', '=',1)
        ->get();
        $info =  Person::first();
        $perid = Permislist::where('PERSON_ID', '=',$info->ID)->get();
       
        $infopermis = Permislist::leftJoin('hrd_person','gsy_permis_list.PERSON_ID','=','hrd_person.ID')
            ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
            ->select('HR_PREFIX_NAME','HR_FNAME','HR_LNAME','POSITION_IN_WORK','PERSON_ID', DB::raw('count(*) as total'))
            ->orderBy('PERSON_ID', 'asc') 
            ->groupBy('HR_PREFIX_NAME','HR_FNAME','HR_LNAME','PERSON_ID','POSITION_IN_WORK')
        ->get();

        $inforpermisselect = Permis::get();

        return view('admin.setupinfopermis_add',[
            'infopermiss' => $infopermis,
            'inforpersons' =>$inforperson,
            'inforpermisselects' => $inforpermisselect ,
            'perid' => $perid,
        ]);
    }
    public function save(Request $request)
    { 
       $userid = $request->USER_ID;
       $id =  Person::where('hrd_person.ID','=',$userid)->first();
       
    Permislist::where('PERSON_ID','=',$id->ID)->delete();

       $permis = DB::table('gsy_permis')->get();
     
       foreach ($permis as $items) {

        $nameitem = $items->PERMIS_ID;
  
        $valuepermis = $request->$nameitem;
  
       if ($valuepermis == 'on') {
        $addusepermis = new Permislist(); 
        $addusepermis->PERSON_ID = $id->ID; 
        $addusepermis->PERMIS_ID = $nameitem;  
        $addusepermis->save();      
    }

   }


    //    $GHR001 = $request->GHR001; 
    //    if ($GHR001 == 'on') {
    //     $addusepermis = new Permislist(); 
    //     $addusepermis->PERSON_ID = $id->ID; 
    //     $addusepermis->PERMIS_ID = 'GHR001';  
    //     $addusepermis->save();      
    // }
    //    $GRE001 = $request->GRE001; 

    //    if ($GRE001 == 'on') {
    //     $addusepermis = new Permislist(); 
    //     $addusepermis->PERSON_ID = $id->ID; 
    //     $addusepermis->PERMIS_ID = 'GRE001';  
    //     $addusepermis->save();      
    // }
    //    $GRE002 = $request->GRE002;

    
     
        return redirect()->route('setup.indexpermis');

    }
    public function destroy($id) { 
                
    Permislist::where('PERSON_ID','=',$id)->delete();
        
            
        //return redirect()->action('ChangenameController@infouserchangename');  
        return redirect()->route('setup.indexpermis');  
    }

     //-----------------------------------------

     public function permis(Request $request,$id)
     {   
        //  $iduser = $request->USE_ID;     
         // dd($iduser);
    
     
         $infopermis = Permislist::where('gsy_permis_list.PERSON_ID', '=',$id)->get();
 
         $infopermisperson = DB::table('gsy_permis')->where('PERMIS_ID','like','GHR%')->get();
 
         $infopermisperson_gre = DB::table('gsy_permis')->where('PERMIS_ID','like','GRE%')->get();
         $infopermisperson_gts = DB::table('gsy_permis')->where('PERMIS_ID','like','GTS%')->get();
         $infopermisperson_gle = DB::table('gsy_permis')->where('PERMIS_ID','like','GLE%')->get();
         $infopermisperson_gmb = DB::table('gsy_permis')->where('PERMIS_ID','like','GMB%')->get();
         $infopermisperson_gme = DB::table('gsy_permis')->where('PERMIS_ID','like','GME%')->get();
         $infopermisperson_gca = DB::table('gsy_permis')->where('PERMIS_ID','like','GCA%')->get();
         $infopermisperson_gas = DB::table('gsy_permis')->where('PERMIS_ID','like','GAS%')->get();
         $infopermisperson_gsu = DB::table('gsy_permis')->where('PERMIS_ID','like','GSU%')->get();
         $infopermisperson_grp = DB::table('gsy_permis')->where('PERMIS_ID','like','GRP%')->get();
         $infopermisperson_grc = DB::table('gsy_permis')->where('PERMIS_ID','like','GRC%')->get();
         $infopermisperson_grm = DB::table('gsy_permis')->where('PERMIS_ID','like','GRM%')->get();
         $infopermisperson_gsa = DB::table('gsy_permis')->where('PERMIS_ID','like','GSA%')->get();
         $infopermisperson_gmw = DB::table('gsy_permis')->where('PERMIS_ID','like','GMW%')->get();
         $infopermisperson_gmm = DB::table('gsy_permis')->where('PERMIS_ID','like','GMM%')->get();
         $infopermisperson_gmp = DB::table('gsy_permis')->where('PERMIS_ID','like','GMP%')->where('PERMIS_ID','<>','GMP002')->get();
         $infopermisperson_gmc = DB::table('gsy_permis')->where('PERMIS_ID','like','GMC%')->where('PERMIS_ID','<>','GMC001')->get();
         $infopermisperson_heal = DB::table('gsy_permis')->where('PERMIS_ID','like','HEAL%')->get();
         $infopermisperson_gmr = DB::table('gsy_permis')->where('PERMIS_ID','like','GMR%')->get();
         $infopermisperson_gmp002 = DB::table('gsy_permis')->where('PERMIS_ID','like','GMP002%')->get();
         $infopermisperson_gml = DB::table('gsy_permis')->where('PERMIS_ID','like','GML%')->get();
         $infopermisperson_gmg = DB::table('gsy_permis')->where('PERMIS_ID','like','GMG%')->get();
         $infopermisperson_gmn = DB::table('gsy_permis')->where('PERMIS_ID','like','GMN%')->get();
         $infopermisperson_gmf = DB::table('gsy_permis')->where('PERMIS_ID','like','GMF%')->get();
         $infopermisperson_gmc002 = DB::table('gsy_permis')->where('PERMIS_ID','like','GMC%')->where('PERMIS_ID','<>','GMC002')->get();
         $infopermisperson_horg = DB::table('gsy_permis')->where('PERMIS_ID','like','HORG%')->get();
         $infopermisperson_happy = DB::table('gsy_permis')->where('PERMIS_ID','like','HAPPY%')->get();
         $infopermisperson_opa = DB::table('gsy_permis')->where('PERMIS_ID','like','opa%')->get();

         $infopermislist = Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')->where('ID', '=',$id)
         ->first();
         
 
         return view('admin.setuppermis_permis',compact(
             'infopermis','infopermislist','infopermisperson','infopermisperson_gre','infopermisperson_gts','infopermisperson_gle','infopermisperson_gmb','infopermisperson_gme',
             'infopermisperson_gca','infopermisperson_gas','infopermisperson_gsu','infopermisperson_grp','infopermisperson_grc','infopermisperson_grm','infopermisperson_gsa',
             'infopermisperson_gmw','infopermisperson_gmm','infopermisperson_gmp','infopermisperson_gmc','infopermisperson_heal','infopermisperson_gmr','infopermisperson_gmp002',
             'infopermisperson_gml','infopermisperson_gmg','infopermisperson_gmn','infopermisperson_gmf','infopermisperson_gmc002','infopermisperson_horg','infopermisperson_happy',
             'infopermisperson_opa'
            ));
       
     }
    //  public function permis($id)
    //  {
     
    //      $useid =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    //                    ->where('hrd_person.ID','=',$id)->first();
         
    //      $inforperson =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    //      ->leftJoin('hrd_sex','hrd_person.SEX','=','hrd_sex.SEX_ID')
    //      ->leftJoin('hrd_status','hrd_person.HR_STATUS_ID','=','hrd_status.HR_STATUS_ID')
    //      ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
    //      ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
    //      ->leftJoin('hrd_department','hrd_person.HR_DEPARTMENT_ID','=','hrd_department.HR_DEPARTMENT_ID')
    //      ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
     
    //      ->where('hrd_person.HR_STATUS_ID', '=',1)
    //      ->get();

    //      $inforpermisselect = Permis::get();
        
    //      $infoapprovpermis = Permislist::leftJoin('gsy_permis','gsy_permis.PERMIS_ID','=','gsy_permis_list.PERMIS_ID')
    //      ->where('gsy_permis_list.PERSON_ID','=',$useid->ID)
    //     //  ->orderBy('gsy_permis_list.PERMIS_ID', 'asc') 
    //      ->get();

    //      $approvpermis = Permislist::where('PERSON_ID','=',$useid->ID)->first();

    //      $getpermiss = Person::leftJoin('gsy_permis_list','gsy_permis_list.PERSON_ID','=','hrd_person.ID')->where('hrd_person.ID','=', $useid->ID)->first();
      
    //      return view('admin.setuppermis_permis',[
    //          'infoapprovpermiss' => $infoapprovpermis,
    //          'approvpermiss' => $approvpermis,
    //          'inforpersons' =>$inforperson,
    //          'useid' =>$useid,
    //          'inforpermisselects' => $inforpermisselect ,
    //          'getpermiss' =>$getpermiss,
    //      ]);
    //  }

     public function savepermis(Request $request)
     {
        // return $request->all();
        //$id = $request->USE_ID;
       
 
       // $userid =  Person::where('hrd_person.HR_CID','=',$id)->first();
     
 
             $addusepermis = new Permislist(); 
             $addusepermis->PERSON_ID =  $request->USE_ID;
             $addusepermis->PERMIS_ID =  $request->PERMIS_ID; 
             $addusepermis->save();
 
            //dd($addusepermis);
             //return redirect()->action('ChangenameController@infouserchangename'); 
             return redirect()->route('setup.permis',[
                'id' => $request->USE_ID 
            ]);

 
     }
     public function destroypermis($id,$useid) { 
                 
        Permislist::destroy($id);
         
             
         //return redirect()->action('ChangenameController@infouserchangename');  
         return redirect()->route('setup.permis',[
            'id' => $useid 
        ]);

     }
 

     //-------เปิดปิดเมนู-----


     public function setupinfomenu()
     {
         $informenu = Permismenu::get();
         return view('admin.setupinfomenu',[
             'informenus' => $informenu 
         ]);
     }


     function switchinfomenu(Request $request)
     {  
         //return $request->all(); 
         $id = $request->idref;
         $active = Permismenu::find($id);
         $active->ACTIVE = $request->onoff;
         $active->save();
     }


     public static function check1()
     {
      $result =  Permismenu::where('PERMIS_MENU_ID','=','1')->first();   
     
      return $result->ACTIVE;
     }

     public static function check2()
     {
      $result =  Permismenu::where('PERMIS_MENU_ID','=','2')->first();   
     
      return $result->ACTIVE;
     }

     public static function check3()
     {
      $result =  Permismenu::where('PERMIS_MENU_ID','=','3')->first();   
     
      return $result->ACTIVE;
     }

     public static function check4()
     {
      $result =  Permismenu::where('PERMIS_MENU_ID','=','4')->first();   
     
      return $result->ACTIVE;
     }


     public static function check5()
     {
      $result =  Permismenu::where('PERMIS_MENU_ID','=','5')->first();   
     
      return $result->ACTIVE;
     }

     public static function check6()
     {
      $result =  Permismenu::where('PERMIS_MENU_ID','=','6')->first();   
     
      return $result->ACTIVE;
     }

     public static function check7()
     {
      $result =  Permismenu::where('PERMIS_MENU_ID','=','7')->first();   
     
      return $result->ACTIVE;
     }

     public static function check8()
     {
      $result =  Permismenu::where('PERMIS_MENU_ID','=','8')->first();   
     
      return $result->ACTIVE;
     }

     public static function check9()
     {
      $result =  Permismenu::where('PERMIS_MENU_ID','=','9')->first();   
     
      return $result->ACTIVE;
     }

     public static function check10()
     {
      $result =  Permismenu::where('PERMIS_MENU_ID','=','10')->first();   
     
      return $result->ACTIVE;
     }

     public static function check11()
     {
      $result =  Permismenu::where('PERMIS_MENU_ID','=','11')->first();   
     
      return $result->ACTIVE;
     }
     public static function check12()
     {
      $result =  Permismenu::where('PERMIS_MENU_ID','=','12')->first();   
     
      return $result->ACTIVE;
     }

     public static function check13()
     {
      $result =  Permismenu::where('PERMIS_MENU_ID','=','13')->first();   
     
      return $result->ACTIVE;
     }

     public static function check14()
     {
      $result =  Permismenu::where('PERMIS_MENU_ID','=','14')->first();   
     
      return $result->ACTIVE;
     }

     public static function check15()
     {
      $result =  Permismenu::where('PERMIS_MENU_ID','=','15')->first();   
     
      return $result->ACTIVE;
     }


     public static function check16()
     {
      $result =  Permismenu::where('PERMIS_MENU_ID','=','16')->first();   
     
      return $result->ACTIVE;
     }

     public static function check17()
     {
      $result =  Permismenu::where('PERMIS_MENU_ID','=','17')->first();   
     
      return $result->ACTIVE;
     }

     public static function check18()
     {
      $result =  Permismenu::where('PERMIS_MENU_ID','=','18')->first();   
     
      return $result->ACTIVE;
     }

     public static function check19()
     {
      $result =  Permismenu::where('PERMIS_MENU_ID','=','19')->first();   
     
      return $result->ACTIVE;
     }

     public static function check20()
     {
      $result =  Permismenu::where('PERMIS_MENU_ID','=','20')->first();   
     
      return $result->ACTIVE;
     }



}
