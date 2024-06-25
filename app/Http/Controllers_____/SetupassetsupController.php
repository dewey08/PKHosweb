<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Person;
use App\Models\Suppliestypekind;
use App\Models\Suppliesunit;
use App\Models\Suppliestypelist;
use App\Models\Suppliesbudget; 
use App\Models\Suppliesbrand; 
use App\Models\Suppliesordertype; 
use App\Models\Suppliespriceref; 
use App\Models\Suppliesposition; 
use App\Models\Suppliesstatusregis; 
use App\Models\Suppliesmethod; 
use App\Models\Suppliesdecline;
use App\Models\Suppliesconpremise; 
use App\Models\Suppliestrimart; 
use App\Models\Suppliescontypelist;
use App\Models\Suppliesexpiretype;
use App\Models\Suppliesbuy;
use App\Models\Suppliessendmoneyitem;
use App\Models\Suppliestypemaster;
use App\Models\Suppliesvendor;
use App\Models\Suppliestype;
use App\Models\Suppliestypesub;
use App\Models\Suppliesinven;
use App\Models\Suppliesconboardlist;
use App\Models\Suppliesconboardlistperson;
use App\Models\Supplieslocation;
use App\Models\Supplieslocationlevel;
use App\Models\Supplieslocationlevelroom;
use App\Models\Assettypevalue;
use App\Models\Suppliespurchase;
use App\Models\Suppliesmodel;
use App\Models\Suppliesofficer;
use App\Models\Suppliesinvenpermiss;


class SetupassetsupController extends Controller
{

    public function infosuppliespurchase()
    {
     
        $infoperson = DB::table('hrd_person')
        ->where('HR_STATUS_ID','=',1)
        ->get();

        $infosuppliespurchase = Suppliespurchase::where('PURCHASE_ID','=',1)->first();  

    return view('admin_asset_supplies.suppliespurchase',[
       'infopersons' => $infoperson,
       'infosuppliespurchase' => $infosuppliespurchase,
    ]);
    }   

    public function updatesuppliespurchase(Request $request)
    {

        $updatesup = Suppliespurchase::find(1);
        $updatesup->PURCHASE_LEADER_ID = $request->PURCHASE_LEADER_ID;
        $updatesup->PURCHASE_OFFICER_ID = $request->PURCHASE_OFFICER_ID;
        $updatesup->PURCHASE_HEAD_ID = $request->PURCHASE_HEAD_ID;
        $updatesup->PURCHASE_GOV = $request->PURCHASE_GOV;
        $updatesup->PURCHASE_SUBROGATE = $request->PURCHASE_SUBROGATE;
        $updatesup->PURCHASE_CMD_PROVINCE = $request->PURCHASE_CMD_PROVINCE;
        $updatesup->PURCHASE_NOTIFY = $request->PURCHASE_NOTIFY;
        $updatesup->save();

        return redirect()->route('setup.infosuppliespurchase'); 

    }



     public function infosuppliestypekind()
    {
   
    $infosuppliestypekind = Suppliestypekind::leftJoin('supplies_type_master','supplies_type_kind.SUP_TYPE_MASTER_ID','=','supplies_type_master.SUP_TYPE_MASTER_ID')
    ->orderBy('SUP_TYPE_KIND_ID', 'asc')  
    ->get();                     
      
   //dd($inforoom);
    return view('admin_asset_supplies.suppliestypekind',[
        'infosuppliestypekinds' => $infosuppliestypekind
    ]);
    }   

    public function createsuppliestypekind(Request $request)
    {
        $typemaster = DB::table('supplies_type_master')->get();
  
        return view('admin_asset_supplies.suppliestypekind_add',[
            'typemasters' => $typemaster
        ]);

    }

    public function savesuppliestypekind(Request $request)
    {
        //return $request->all();

            $addsuptypekind = new Suppliestypekind(); 
            $addsuptypekind->SUP_TYPE_KIND_NAME = $request->SUP_TYPE_KIND_NAME;
            $addsuptypekind->SUP_TYPE_KIND_DETAIL = $request->SUP_TYPE_KIND_DETAIL;
            $addsuptypekind->SUP_TYPE_MASTER_ID = $request->SUP_TYPE_MASTER_ID;
            $addsuptypekind->save();

            return redirect()->route('setup.infosuppliestypekind'); 
    }

    public function editsuppliestypekind(Request $request,$id)
    {
       // return $request->all();
    
       $id_in= $id;
       $typemaster = DB::table('supplies_type_master')->get();
     
       $infotypekind = Suppliestypekind::where('SUP_TYPE_KIND_ID','=',$id_in)
       ->first();


        //dd($inforbudget);
        return view('admin_asset_supplies.suppliestypekind_edit',[
        'infotypekind' => $infotypekind, 
        'typemasters' => $typemaster
        ]);

    }



    public function updatesuppliestypekind(Request $request)
    {
        $id = $request->SUP_TYPE_KIND_ID; 

        $updatesuptypekind = Suppliestypekind::find($id);
        $updatesuptypekind->SUP_TYPE_KIND_NAME = $request->SUP_TYPE_KIND_NAME;
        $updatesuptypekind->SUP_TYPE_KIND_DETAIL = $request->SUP_TYPE_KIND_DETAIL;
        $updatesuptypekind->SUP_TYPE_MASTER_ID = $request->SUP_TYPE_MASTER_ID;
        $updatesuptypekind->save();

        return redirect()->route('setup.infosuppliestypekind'); 

    }

    
    public function destroysuppliestypekind($id) { 

        Suppliestypekind::destroy($id);         
        //return redirect()->action('ChangenameController@infouserchangename');  
        return redirect()->route('setup.infosuppliestypekind');   
    }


    //---------------------------------------------------------------------------------------------------

    public function infosuppliesunit()
    {
        $infosuppliesunit = Suppliesunit::orderBy('SUP_UNIT_ID', 'asc')  
        ->get();                         
        
   //dd($inforoom);
    return view('admin_asset_supplies.suppliesunit',[
        'infosuppliesunits' =>  $infosuppliesunit
    ]);
    }   

    public function createsuppliesunit(Request $request)
    {
      
        return view('admin_asset_supplies.suppliesunit_add');

    }

    public function savesuppliesunit(Request $request)
    {
        //return $request->all();

            $addsuppliesunit = new Suppliesunit(); 
            $addsuppliesunit->SUP_UNIT_NAME = $request->SUP_UNIT_NAME;
            $addsuppliesunit->ACTIVE = 'True';
          
            $addsuppliesunit->save();

            return redirect()->route('setup.infosuppliesunit'); 
    }

    public function editsuppliesunit(Request $request,$id)
    {
       // return $request->all();
    
     
       $infosuppliesunit = Suppliesunit::where('SUP_UNIT_ID','=',$id)
       ->first();


        //dd($inforbudget);
        return view('admin_asset_supplies.suppliesunit_edit',[
        'infosuppliesunit' => $infosuppliesunit, 
        ]);

    }



    public function updatesuppliesunit(Request $request)
    {
        $id = $request->SUP_UNIT_ID; 

        $updatesuppliesunit = Suppliesunit::find($id);
        $updatesuppliesunit->SUP_UNIT_NAME = $request->SUP_UNIT_NAME;
        $updatesuppliesunit->save();

        return redirect()->route('setup.infosuppliesunit'); 

    }

    
    public function destroysuppliesunit($id) { 

        Suppliesunit::destroy($id);         
        //return redirect()->action('ChangenameController@infouserchangename');  
        return redirect()->route('setup.infosuppliesunit');   
    }

    function switchactiveunit(Request $request)
    {  
        //return $request->all(); 
        $id = $request->unit;
        $unitinactive = Suppliesunit::find($id);
        $unitinactive->ACTIVE = $request->onoff;
        $unitinactive->save();
    }

    //---------------------------------------------------------------------------------------------

    

    public function infosuppliesdepsubsup()
    {
        $infosuppliesdepsubsup = DB::table('hrd_department_sub_sub')
        ->leftjoin('hrd_department_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
        ->get();                         
        
   //dd($inforoom);
    return view('admin_asset_supplies.suppliesdepsubsup',[
        'infosuppliesdepsubsups' =>  $infosuppliesdepsubsup
    ]);
    }   



      //---------------------------------------------------------------------------------------------------

      public function infosuppliestypelist()
      {
          $infosuppliestypelist = Suppliestypelist::orderBy('LIST_TYPE_ID', 'asc')  
          ->get();                         
          
     //dd($inforoom);
      return view('admin_asset_supplies.suppliestypelist',[
          'infosuppliestypelists' =>  $infosuppliestypelist
      ]);
      }   
  
      public function createsuppliestypelist(Request $request)
      {
        
          return view('admin_asset_supplies.suppliestypelist_add');
  
      }
  
      public function savesuppliestypelist(Request $request)
      {
          //return $request->all();
  
              $addsuppliestypelist = new Suppliestypelist(); 
              $addsuppliestypelist->LIST_TYPE_NAME = $request->LIST_TYPE_NAME;
            
              $addsuppliestypelist->save();
  
              return redirect()->route('setup.infosuppliestypelist'); 
      }
  
      public function editsuppliestypelist(Request $request,$id)
      {
         // return $request->all();
      
       
         $infosuppliestypelist = Suppliestypelist::where('LIST_TYPE_ID','=',$id)
         ->first();
  
  
          //dd($inforbudget);
          return view('admin_asset_supplies.suppliestypelist_edit',[
          'infosuppliestypelist' => $infosuppliestypelist, 
          ]);
  
      }
  
  
  
      public function updatesuppliestypelist(Request $request)
      {
          $id = $request->LIST_TYPE_ID; 
  
          $updatesuppliestypelist = Suppliestypelist::find($id);
          $updatesuppliestypelist->LIST_TYPE_NAME = $request->LIST_TYPE_NAME;
            
          $updatesuppliestypelist->save();

  
          return redirect()->route('setup.infosuppliestypelist'); 
  
      }
  
      
      public function destroysuppliestypelist($id) { 
  
        Suppliestypelist::destroy($id);         
          //return redirect()->action('ChangenameController@infouserchangename');  
          return redirect()->route('setup.infosuppliestypelist');   
      }

       //---------------------------------------------------------------------------------------------------

       public function infosuppliestypebudget()
       {
           $infosuppliestypebudget = Suppliesbudget::orderBy('BUDGET_ID', 'asc')  
           ->get();                         
           
      //dd($inforoom);
       return view('admin_asset_supplies.suppliestypebudget',[
           'infosuppliestypebudgets' =>  $infosuppliestypebudget
       ]);
       }   
   
       public function createsuppliestypebudget(Request $request)
       {
         
           return view('admin_asset_supplies.suppliestypebudget_add');
   
       }
   
       public function savesuppliestypebudget(Request $request)
       {
           //return $request->all();
   
               $addsuppliestypebudget = new Suppliesbudget(); 
               $addsuppliestypebudget->BUDGET_NAME = $request->BUDGET_NAME;
               $addsuppliestypebudget->BUDGET_NUM = $request->BUDGET_NUM;
               $addsuppliestypebudget->ACTIVE = 'True';
               $addsuppliestypebudget->save();
   
               return redirect()->route('setup.infosuppliestypebudget'); 
       }
   
       public function editsuppliestypebudget(Request $request,$id)
       {
          // return $request->all();
       
        
          $infosuppliestypebudget = Suppliesbudget::where('BUDGET_ID','=',$id)
          ->first();
   
   
           //dd($inforbudget);
           return view('admin_asset_supplies.suppliestypebudget_edit',[
           'infosuppliestypebudget' => $infosuppliestypebudget, 
           ]);
   
       }
   
   
   
       public function updatesuppliestypebudget(Request $request)
       {
           $id = $request->BUDGET_ID; 
   
           $updatesuppliestypebudget = Suppliesbudget::find($id);
           $updatesuppliestypebudget->BUDGET_NAME = $request->BUDGET_NAME;
           $updatesuppliestypebudget->BUDGET_NUM = $request->BUDGET_NUM;  
           $updatesuppliestypebudget->save();
 
   
           return redirect()->route('setup.infosuppliestypebudget'); 
   
       }
   
       
       public function destroysuppliestypebudget($id) { 
   
        Suppliesbudget::destroy($id);         
           //return redirect()->action('ChangenameController@infouserchangename');  
           return redirect()->route('setup.infosuppliestypebudget');   
       }


       function switchactivebudget(Request $request)
       {  
           //return $request->all(); 
           $id = $request->typebudget;
           $typebudgetinactive = Suppliesbudget::find($id);
           $typebudgetinactive->ACTIVE = $request->onoff;
           $typebudgetinactive->save();
       }

//------------------------------------------------------------------------------------------------------------------

public function infosuppliesbrand()
{
    $infosuppliesbrand = Suppliesbrand::orderBy('BRAND_ID', 'asc')  
    ->get();                         
    
//dd($inforoom);
return view('admin_asset_supplies.suppliesbrand',[
    'infosuppliesbrands' =>  $infosuppliesbrand
]);
}   

public function createsuppliesbrand(Request $request)
{
  
    return view('admin_asset_supplies.suppliesbrand_add');

}

public function savesuppliesbrand(Request $request)
{
    //return $request->all();

        $addsuppliesbrand = new Suppliesbrand(); 
        $addsuppliesbrand->BRAND_NAME = $request->BRAND_NAME;
      
        $addsuppliesbrand->save();

        return redirect()->route('setup.infosuppliesbrand'); 
}

public function editsuppliesbrand(Request $request,$id)
{
   // return $request->all();

 
   $infosuppliesbrand = Suppliesbrand::where('BRAND_ID','=',$id)
   ->first();


    //dd($inforbudget);
    return view('admin_asset_supplies.suppliesbrand_edit',[
    'infosuppliesbrand' => $infosuppliesbrand, 
    ]);

}



public function updatesuppliesbrand(Request $request)
{
    $id = $request->BRAND_ID; 

    $updatesuppliesbrand = Suppliesbrand::find($id);
    $updatesuppliesbrand->BRAND_NAME = $request->BRAND_NAME;
      
    $updatesuppliesbrand->save();


    return redirect()->route('setup.infosuppliesbrand'); 

}


public function destroysuppliesbrand($id) { 

    Suppliesbrand::destroy($id);         
    //return redirect()->action('ChangenameController@infouserchangename');  
    return redirect()->route('setup.infosuppliesbrand');   
}

 //---------------------------------ตั้งค่ารุ่น------------------------------------------------------------------

public function infosuppliesmodel()
{
    $infosuppliesmodel = Suppliesmodel::orderBy('MODEL_ID', 'asc')  
    ->get();                         
    
//dd($inforoom);
return view('admin_asset_supplies.suppliesmodel',[
    'infosuppliesmodels' =>  $infosuppliesmodel
]);
}   

public function createsuppliesmodel(Request $request)
{
  
    return view('admin_asset_supplies.suppliesmodel_add');

}

public function savesuppliesmodel(Request $request)
{
    //return $request->all();

        $addsuppliesmodel = new Suppliesmodel(); 
        $addsuppliesmodel->MODEL_NAME = $request->MODEL_NAME;
      
        $addsuppliesmodel->save();

        return redirect()->route('setup.infosuppliesmodel'); 
}

public function editsuppliesmodel(Request $request,$id)
{
   // return $request->all();

 
   $infosuppliesmodel = Suppliesmodel::where('MODEL_ID','=',$id)
   ->first();


    //dd($inforbudget);
    return view('admin_asset_supplies.suppliesmodel_edit',[
    'infosuppliesmodel' => $infosuppliesmodel, 
    ]);

}



public function updatesuppliesmodel(Request $request)
{
    $id = $request->MODEL_ID; 

    $updatesuppliesmodel = Suppliesmodel::find($id);
    $updatesuppliesmodel->MODEL_NAME = $request->MODEL_NAME;
      
    $updatesuppliesmodel->save();


    return redirect()->route('setup.infosuppliesmodel'); 

}


public function destroysuppliesmodel($id) { 

    Suppliesmodel::destroy($id);         
    //return redirect()->action('ChangenameController@infouserchangename');  
    return redirect()->route('setup.infosuppliesmodel');   
}

 //-----------------------------------------------------

 public function infosuppliesordertype()
 {
     $infosuppliesordertype = Suppliesordertype::orderBy('SUPPLIES_ORDER_TYPE_ID', 'asc')  
     ->get();                         
     
//dd($inforoom);
 return view('admin_asset_supplies.suppliesordertype',[
     'infosuppliesordertypes' =>  $infosuppliesordertype
 ]);
 }   

 public function createsuppliesordertype(Request $request)
 {
   
     return view('admin_asset_supplies.suppliesordertype_add');

 }

 public function savesuppliesordertype(Request $request)
 {
     //return $request->all();

         $addsuppliesordertype = new Suppliesordertype(); 
         $addsuppliesordertype->SUPPLIES_ORDER_TYPE_NAME = $request->SUPPLIES_ORDER_TYPE_NAME;
       
         $addsuppliesordertype->save();

         return redirect()->route('setup.infosuppliesordertype'); 
 }

 public function editsuppliesordertype(Request $request,$id)
 {
    // return $request->all();
 
  
    $infosuppliesordertype = Suppliesordertype::where('SUPPLIES_ORDER_TYPE_ID','=',$id)
    ->first();


     //dd($inforbudget);
     return view('admin_asset_supplies.suppliesordertype_edit',[
     'infosuppliesordertype' => $infosuppliesordertype, 
     ]);

 }



 public function updatesuppliesordertype(Request $request)
 {
     $id = $request->SUPPLIES_ORDER_TYPE_ID; 

     $updatesuppliesordertype= Suppliesordertype::find($id);
     $updatesuppliesordertype->SUPPLIES_ORDER_TYPE_NAME = $request->SUPPLIES_ORDER_TYPE_NAME;
       
     $updatesuppliesordertype->save();


     return redirect()->route('setup.infosuppliesordertype'); 

 }

 
 public function destroysuppliesordertype($id) { 

    Suppliesordertype::destroy($id);         
     //return redirect()->action('ChangenameController@infouserchangename');  
     return redirect()->route('setup.infosuppliesordertype');   
 }

 //---------------------------------------------------------------------------------------------------

 public function infosuppliespriceref()
 {
     $infosuppliespriceref = Suppliespriceref::orderBy('PRICE_REF_ID', 'asc')  
     ->get();                         
     
//dd($inforoom);
 return view('admin_asset_supplies.suppliespriceref',[
     'infosuppliespricerefs' =>  $infosuppliespriceref
 ]);
 }   

 public function createsuppliespriceref(Request $request)
 {
   
     return view('admin_asset_supplies.suppliespriceref_add');

 }

 public function savesuppliespriceref(Request $request)
 {
     //return $request->all();

         $addsuppliespriceref = new Suppliespriceref(); 
         $addsuppliespriceref->PRICE_REF_NAME = $request->PRICE_REF_NAME;
       
         $addsuppliespriceref->save();

         return redirect()->route('setup.infosuppliespriceref'); 
 }

 public function editsuppliespriceref(Request $request,$id)
 {
    // return $request->all();
 
  
    $infosuppliespriceref = Suppliespriceref::where('PRICE_REF_ID','=',$id)
    ->first();


     //dd($inforbudget);
     return view('admin_asset_supplies.suppliespriceref_edit',[
     'infosuppliespriceref' => $infosuppliespriceref, 
     ]);

 }



 public function updatesuppliespriceref(Request $request)
 {
     $id = $request->PRICE_REF_ID; 

     $updatesuppliespriceref= Suppliespriceref::find($id);
     $updatesuppliespriceref->PRICE_REF_NAME = $request->PRICE_REF_NAME;
       
     $updatesuppliespriceref->save();


     return redirect()->route('setup.infosuppliespriceref'); 

 }

 
 public function destroysuppliespriceref($id) { 

    Suppliespriceref::destroy($id);         
     //return redirect()->action('ChangenameController@infouserchangename');  
     return redirect()->route('setup.infosuppliespriceref');   
 }

  //---------------------------------------------------------------------------------------------------

  public function infosuppliesposition()
  {
      $infosuppliesposition = Suppliesposition::orderBy('POSITION_ID', 'asc')  
      ->get();                         
      
 //dd($inforoom);
  return view('admin_asset_supplies.suppliesposition',[
      'infosuppliespositions' =>  $infosuppliesposition
  ]);
  }   
 
  public function createsuppliesposition(Request $request)
  {
    
      return view('admin_asset_supplies.suppliesposition_add');
 
  }
 
  public function savesuppliesposition(Request $request)
  {
      //return $request->all();
 
          $addsuppliesposition = new Suppliesposition(); 
          $addsuppliesposition->POSITION_NAME = $request->POSITION_NAME;
        
          $addsuppliesposition->save();
 
          return redirect()->route('setup.infosuppliesposition'); 
  }
 
  public function editsuppliesposition(Request $request,$id)
  {
     // return $request->all();
  
   
     $infosuppliespriceref = Suppliesposition::where('POSITION_ID','=',$id)
     ->first();
 
 
      //dd($inforbudget);
      return view('admin_asset_supplies.suppliesposition_edit',[
      'infosuppliespriceref' => $infosuppliespriceref, 
      ]);
 
  }
 
 
 
  public function updatesuppliesposition(Request $request)
  {
      $id = $request->POSITION_ID; 
 
      $updatesuppliesposition= Suppliesposition::find($id);
      $updatesuppliesposition->POSITION_NAME = $request->POSITION_NAME;
        
      $updatesuppliesposition->save();
 
 
      return redirect()->route('setup.infosuppliesposition'); 
 
  }
 
  
  public function destroysuppliesposition($id) { 
 
    Suppliesposition::destroy($id);         
      //return redirect()->action('ChangenameController@infouserchangename');  
      return redirect()->route('setup.infosuppliesposition');   
  }

  
  //---------------------------------------------------------------------------------------------------

  public function infosuppliesstatusregis()
  {
      $infosuppliesstatusregis= Suppliesstatusregis::orderBy('REGIS_STATUS_ID', 'asc')  
      ->get();                         
      
 //dd($inforoom);
  return view('admin_asset_supplies.suppliesstatusregis',[
      'infosuppliesstatusregiss' =>  $infosuppliesstatusregis
  ]);
  }   
 
  public function createsuppliesstatusregis(Request $request)
  {
    
      return view('admin_asset_supplies.suppliesstatusregis_add');
 
  }
 
  public function savesuppliesstatusregis(Request $request)
  {
      //return $request->all();
 
          $addsuppliesstatusregis= new Suppliesstatusregis(); 
          $addsuppliesstatusregis->REGIS_STATUS_NAME = $request->REGIS_STATUS_NAME;
        
          $addsuppliesstatusregis->save();
 
          return redirect()->route('setup.infosuppliesstatusregis'); 
  }
 
  public function editsuppliesstatusregis(Request $request,$id)
  {
     // return $request->all();
  
   
     $infosuppliesstatusregis= Suppliesstatusregis::where('REGIS_STATUS_ID','=',$id)
     ->first();
 
 
      //dd($inforbudget);
      return view('admin_asset_supplies.suppliesstatusregis_edit',[
      'infosuppliesstatusregis' => $infosuppliesstatusregis, 
      ]);
 
  }
 
 
 
  public function updatesuppliesstatusregis(Request $request)
  {
      $id = $request->REGIS_STATUS_ID; 
 
      $updatesuppliesstatusregis= Suppliesstatusregis::find($id);
      $updatesuppliesstatusregis->REGIS_STATUS_NAME = $request->REGIS_STATUS_NAME;
        
      $updatesuppliesstatusregis->save();
 
 
      return redirect()->route('setup.infosuppliesstatusregis'); 
 
  }
 
  
  public function destroysuppliesstatusregis($id) { 
 
    Suppliesstatusregis::destroy($id);         
      //return redirect()->action('ChangenameController@infouserchangename');  
      return redirect()->route('setup.infosuppliesstatusregis');   
  }

  //---------------------------------------------------------------------------------------------------

  public function infosuppliesmethod()
  {
      $infosuppliesmethod= Suppliesmethod::orderBy('METHOD_ID', 'asc')  
      ->get();                         
      
 //dd($inforoom);
  return view('admin_asset_supplies.suppliesmethod',[
      'infosuppliesmethods' =>  $infosuppliesmethod
  ]);
  }   
 
  public function createsuppliesmethod(Request $request)
  {
    
      return view('admin_asset_supplies.suppliesmethod_add');
 
  }
 
  public function savesuppliesmethod(Request $request)
  {
      //return $request->all();
 
          $addsuppliesmethod= new Suppliesmethod(); 
          $addsuppliesmethod->METHOD_NAME = $request->METHOD_NAME;
        
          $addsuppliesmethod->save();
 
          return redirect()->route('setup.infosuppliesmethod'); 
  }
 
  public function editsuppliesmethod(Request $request,$id)
  {
     // return $request->all();
  
   
     $infosuppliesmethod= Suppliesmethod::where('METHOD_ID','=',$id)
     ->first();
 
 
      //dd($inforbudget);
      return view('admin_asset_supplies.suppliesmethod_edit',[
      'infosuppliesmethod' => $infosuppliesmethod, 
      ]);
 
  }
 
 
 
  public function updatesuppliesmethod(Request $request)
  {
      $id = $request->METHOD_ID; 
 
      $updatesuppliesmethod= Suppliesmethod::find($id);
      $updatesuppliesmethod->METHOD_NAME = $request->METHOD_NAME;
        
      $updatesuppliesmethod->save();
 
 
      return redirect()->route('setup.infosuppliesmethod'); 
 
  }
 
  
  public function destroysuppliesmethod($id) { 
 
    Suppliesmethod::destroy($id);         
      //return redirect()->action('ChangenameController@infouserchangename');  
      return redirect()->route('setup.infosuppliesmethod');   
  }

    //---------------------------------------------------------------------------------------------------

    public function infosuppliesdecline()
    {
        $infosuppliesdecline= Suppliesdecline::orderBy('DECLINE_ID', 'asc')  
        ->get();                         
        
   //dd($inforoom);
    return view('admin_asset_supplies.suppliesdecline',[
        'infosuppliesdeclines' =>  $infosuppliesdecline
    ]);
    }   
   
    public function createsuppliesdecline(Request $request)
    {
      
        return view('admin_asset_supplies.suppliesdecline_add');
   
    }
   
    public function savesuppliesdecline(Request $request)
    {
        //return $request->all();
   
            $addsuppliesdecline= new Suppliesdecline(); 
            $addsuppliesdecline->DECLINE_NAME = $request->DECLINE_NAME;
            $addsuppliesdecline->OLD_YEAR = $request->OLD_YEAR;
            $addsuppliesdecline->DECLINE_PERSEN = $request->DECLINE_PERSEN;
            $addsuppliesdecline->CODE_REF = $request->CODE_REF;
            $addsuppliesdecline->save();
   
            return redirect()->route('setup.infosuppliesdecline'); 
    }
   
    public function editsuppliesdecline(Request $request,$id)
    {
       // return $request->all();
    
     
       $infosuppliesdecline= Suppliesdecline::where('DECLINE_ID','=',$id)
       ->first();
   
   
        //dd($inforbudget);
        return view('admin_asset_supplies.suppliesdecline_edit',[
        'infosuppliesdecline' => $infosuppliesdecline, 
        ]);
   
    }
   
   
   
    public function updatesuppliesdecline(Request $request)
    {
        $id = $request->DECLINE_ID; 
   
        $updatesuppliesdecline= Suppliesdecline::find($id);
        $updatesuppliesdecline->DECLINE_NAME = $request->DECLINE_NAME;
        $updatesuppliesdecline->OLD_YEAR = $request->OLD_YEAR;
        $updatesuppliesdecline->DECLINE_PERSEN = $request->DECLINE_PERSEN;
        $updatesuppliesdecline->CODE_REF = $request->CODE_REF;
          
        $updatesuppliesdecline->save();
   
   
        return redirect()->route('setup.infosuppliesdecline'); 
   
    }
   
    
    public function destroysuppliesdecline($id) { 
   
        Suppliesdecline::destroy($id);         
        //return redirect()->action('ChangenameController@infouserchangename');  
        return redirect()->route('setup.infosuppliesdecline');   
    }


      //---------------------------------------------------------------------------------------------------

      public function infosuppliestrimart()
      {
          $infosuppliestrimart= Suppliestrimart::orderBy('TRIMART_ID', 'asc')  
          ->get();                         
          
     //dd($inforoom);
      return view('admin_asset_supplies.suppliestrimart',[
          'infosuppliestrimarts' =>  $infosuppliestrimart
      ]);
      }   
     
      public function createsuppliestrimart(Request $request)
      {

         $month= DB::table('supplies_month')->orderBy('MONTH_ID', 'asc')  
          ->get(); 

          return view('admin_asset_supplies.suppliestrimart_add',[
              'months' => $month

          ]);
     
      }
     
      public function savesuppliestrimart(Request $request)
      {
          //return $request->all();
     
              $addsuppliestrimart= new Suppliestrimart(); 
              $addsuppliestrimart->TRIMART_NAME = $request->TRIMART_NAME;
              $addsuppliestrimart->MONTH_BEGIN = $request->MONTH_BEGIN;
              $addsuppliestrimart->MONTH_END = $request->MONTH_END;
              $addsuppliestrimart->save();
     
              return redirect()->route('setup.infosuppliestrimart'); 
      }
     
      public function editsuppliestrimart(Request $request,$id)
      {
         // return $request->all();
      
         $month= DB::table('supplies_month')->orderBy('MONTH_ID', 'asc')  
         ->get(); 

         $infosuppliestrimart= Suppliestrimart::where('TRIMART_ID','=',$id)
         ->first();
     
     
          //dd($inforbudget);
          return view('admin_asset_supplies.suppliestrimart_edit',[
          'infosuppliestrimart' => $infosuppliestrimart, 
          'months' => $month
          ]);
     
      }
     
     
     
      public function updatesuppliestrimart(Request $request)
      {
          $id = $request->TRIMART_ID; 
     
          $updatesuppliestrimart= Suppliestrimart::find($id);
          $updatesuppliestrimart->TRIMART_NAME = $request->TRIMART_NAME;
          $updatesuppliestrimart->MONTH_BEGIN = $request->MONTH_BEGIN;
          $updatesuppliestrimart->MONTH_END = $request->MONTH_END;
   
          $updatesuppliestrimart->save();
     
     
          return redirect()->route('setup.infosuppliestrimart'); 
     
      }
     
      
      public function destroysuppliestrimart($id) { 
     
        Suppliestrimart::destroy($id);         
          //return redirect()->action('ChangenameController@infouserchangename');  
          return redirect()->route('setup.infosuppliestrimart');   
      }


      function switchactivetrimart(Request $request)
    {  
        //return $request->all(); 
        $id = $request->trimart;
        $trimartactive = Suppliestrimart::find($id);
        $trimartactive->ACTIVE = $request->onoff;
        $trimartactive->save();
    }


          //---------------------------------------------------------------------------------------------------

          public function infosuppliesbuy()
          {
              $infosuppliesbuy= Suppliesbuy::orderBy('BUY_ID', 'asc')  
              ->get();                         
              
         //dd($inforoom);
          return view('admin_asset_supplies.suppliesbuy',[
              'infosuppliesbuys' =>  $infosuppliesbuy
          ]);
          }   
         
          public function createsuppliesbuy(Request $request)
          {
    
              return view('admin_asset_supplies.suppliesbuy_add');
         
          }
         
          public function savesuppliesbuy(Request $request)
          {
              //return $request->all();
         
                  $addsuppliesbuy= new Suppliesbuy(); 
                  $addsuppliesbuy->BUY_NAME = $request->BUY_NAME;
                  $addsuppliesbuy->BUY_COMMENT = $request->BUY_COMMENT;
                  $addsuppliesbuy->PRICE_MIN = $request->PRICE_MIN;
                  $addsuppliesbuy->PRICE_MAX = $request->PRICE_MAX;
                  $addsuppliesbuy->MAKE_BY = $request->MAKE_BY;
                  $addsuppliesbuy->save();
         
                  return redirect()->route('setup.infosuppliesbuy'); 
          }
         
          public function editsuppliesbuy(Request $request,$id)
          {
             // return $request->all();
          
     
             $infosuppliesbuy= Suppliesbuy::where('BUY_ID','=',$id)
             ->first();
         
         
              //dd($inforbudget);
              return view('admin_asset_supplies.suppliesbuy_edit',[
              'infosuppliesbuy' => $infosuppliesbuy, 
              ]);
         
          }
         
         
         
          public function updatesuppliesbuy(Request $request)
          {
              $id = $request->BUY_ID; 
         
              $updatesuppliesbuy= Suppliesbuy::find($id);
              $updatesuppliesbuy->BUY_NAME = $request->BUY_NAME;
              $updatesuppliesbuy->BUY_COMMENT = $request->BUY_COMMENT;
              $updatesuppliesbuy->PRICE_MIN = $request->PRICE_MIN;
              $updatesuppliesbuy->PRICE_MAX = $request->PRICE_MAX;
              $updatesuppliesbuy->MAKE_BY = $request->MAKE_BY;
       
              $updatesuppliesbuy->save();
         
         
              return redirect()->route('setup.infosuppliesbuy'); 
         
          }
         
          
          public function destroysuppliesbuy($id) { 
         
            Suppliesbuy::destroy($id);         
              //return redirect()->action('ChangenameController@infouserchangename');  
              return redirect()->route('setup.infosuppliesbuy');   
          }
    
    
          function switchactivebuy(Request $request)
        {  
            //return $request->all(); 
            $id = $request->buy;
            $buyactive = Suppliesbuy::find($id);
            $buyactive->ACTIVE = $request->onoff;
            $buyactive->save();
        }






            //---------------------------------------------------------------------------------------------------

            public function infosuppliestypemaster()
            {
                $infosuppliestypemaster= Suppliestypemaster::orderBy('SUP_TYPE_MASTER_ID', 'asc')  
                ->get();                         
                
           //dd($inforoom);
            return view('admin_asset_supplies.suppliestypemaster',[
                'infosuppliestypemasters' =>  $infosuppliestypemaster
            ]);
            }   
           
            public function createsuppliestypemaster(Request $request)
            {
      
                return view('admin_asset_supplies.suppliestypemaster_add');
           
            }
           
            public function savesuppliestypemaster(Request $request)
            {
                //return $request->all();
           
                    $addsuppliestypemaster= new Suppliestypemaster(); 
                    $addsuppliestypemaster->SUP_TYPE_MASTER_NAME = $request->SUP_TYPE_MASTER_NAME;
                    $addsuppliestypemaster->DETAIL = $request->DETAIL;
                   
                    $addsuppliestypemaster->save();
           
                    return redirect()->route('setup.infosuppliestypemaster'); 
            }
           
            public function editsuppliestypemaster(Request $request,$id)
            {
               // return $request->all();
            
       
               $infosuppliestypemaster= Suppliestypemaster::where('SUP_TYPE_MASTER_ID','=',$id)
               ->first();
           
           
                //dd($inforbudget);
                return view('admin_asset_supplies.suppliestypemaster_edit',[
                'infosuppliestypemaster' => $infosuppliestypemaster, 
                ]);
           
            }
           
           
           
            public function updatesuppliestypemaster(Request $request)
            {
                $id = $request->SUP_TYPE_MASTER_ID; 
           
                $updatesuppliestypemaster= Suppliestypemaster::find($id);
                $updatesuppliestypemaster->SUP_TYPE_MASTER_NAME = $request->SUP_TYPE_MASTER_NAME;
                $updatesuppliestypemaster->DETAIL = $request->DETAIL;
        
         
                $updatesuppliestypemaster->save();
           
           
                return redirect()->route('setup.infosuppliestypemaster'); 
           
            }
           
            
            public function destroysuppliestypemaster($id) { 
           
              Suppliestypemaster::destroy($id);         
                //return redirect()->action('ChangenameController@infouserchangename');  
                return redirect()->route('setup.infosuppliestypemaster');   
            }
      


             //-------------------------------steplevel-------------------------------------------
      
    public function infosuppliestype()
    {
        $infosuppliestype = Suppliestype::orderBy('SUP_TYPE_ID', 'asc')  
        ->get();                         
        
   //dd($inforoom);
    return view('admin_asset_supplies.suppliestype',[
        'infosuppliestypes' =>  $infosuppliestype
    ]);
    }   
   
    public function createsuppliestype(Request $request)
    {
        $typemaster = DB::table('supplies_type_master')->get();

        return view('admin_asset_supplies.suppliestype_add',[
            'typemasters' => $typemaster, 
        ]);
   
    }
   
    public function savesuppliestype(Request $request)
    {
        //return $request->all();
   
            $addsuppliestype= new Suppliestype(); 
            $addsuppliestype->SUP_TYPE_NAME = $request->SUP_TYPE_NAME;
            $addsuppliestype->SUP_TYPE_MASTER_ID = $request->SUP_TYPE_MASTER_ID;
           
            $addsuppliestype->save();
   
            return redirect()->route('setup.infosuppliestype'); 
    }
   
    public function editsuppliestype(Request $request,$id)
    {
       // return $request->all();
    

       $infosuppliestype= Suppliestype::where('SUP_TYPE_ID','=',$id)
       ->first();

       $typemaster = DB::table('supplies_type_master')->get();
   
   
        //dd($inforbudget);
        return view('admin_asset_supplies.suppliestype_edit',[
        'infosuppliestype' => $infosuppliestype, 
        'typemasters' => $typemaster, 
        ]);
   
    }
   
   
   
    public function updatesuppliestype(Request $request)
    {
        $id = $request->SUP_TYPE_ID; 
   
        $updatesuppliestype= Suppliestype::find($id);
        $updatesuppliestype->SUP_TYPE_NAME = $request->SUP_TYPE_NAME;
        $updatesuppliestype->SUP_TYPE_MASTER_ID = $request->SUP_TYPE_MASTER_ID;
 
        $updatesuppliestype->save();
   
   
        return redirect()->route('setup.infosuppliestype'); 
   
    }
   
    
    public function destroysuppliestype($id) { 
   
        Suppliestype::destroy($id);         
        //return redirect()->action('ChangenameController@infouserchangename');  
        return redirect()->route('setup.infosuppliestype');   
    }

    
    function switchactivetype(Request $request)
    {  
        //return $request->all(); 
        $id = $request->type;
        $typeactive = Suppliestype::find($id);
        $typeactive->ACTIVE = $request->onoff;
        $typeactive->save();
    }

   //--------------typesub
   public function infosuppliestypesub($idtype)
   {
       $infosuppliestypesub = Suppliestypesub::leftjoin('supplies_type_kind','supplies_type_sub.SUP_TYPE_KIND_ID','=','supplies_type_kind.SUP_TYPE_KIND_ID')
       ->where('SUP_TYPE_ID','=',$idtype)
       ->orderBy('SUP_TYPE_SUP_ID', 'asc')  
       ->get();   
       

       $infosuppliestypename= Suppliestype::where('SUP_TYPE_ID','=',$idtype)
       ->first();
       
  //dd($inforoom);
   return view('admin_asset_supplies.suppliestypesub',[
       'infosuppliestypesubs' =>  $infosuppliestypesub,
       'infosuppliestypename' =>  $infosuppliestypename
   ]);
   }   
  
   public function createsuppliestypesub(Request $request,$idtype)
   {
       $typekind = DB::table('supplies_type_kind')->get();

       return view('admin_asset_supplies.suppliestypesub_add',[
           'typekinds' => $typekind, 
           'idtype' => $idtype, 
       ]);
  
   }
  
   public function savesuppliestypesub(Request $request)
   {
           $idtype = $request->SUP_TYPE_ID;

           //dd($idtype);
  
           $addsuppliestypesub= new Suppliestypesub(); 
           $addsuppliestypesub->SUP_TYPE_SUP_NAME = $request->SUP_TYPE_SUP_NAME;
           $addsuppliestypesub->SUP_TYPE_ID = $idtype;
           $addsuppliestypesub->SUP_TYPE_KIND_ID = $request->SUP_TYPE_KIND_ID;
           $addsuppliestypesub->SUP_TYPE_SUP_CODE = $request->SUP_TYPE_SUP_CODE;
           
           $addsuppliestypesub->save();
  
           return redirect()->route('setup.infosuppliestypesub',[
               'idtype' => $idtype
           ]); 
   }
  
   public function editsuppliestypesub(Request $request,$id,$idtype)
   {
      // return $request->all();
   

      $infosuppliestypesub= Suppliestypesub::where('SUP_TYPE_SUP_ID','=',$id)
      ->first();

      $typekind = DB::table('supplies_type_kind')->get();
  
  
       //dd($inforbudget);
       return view('admin_asset_supplies.suppliestypesub_edit',[
       'infosuppliestypesub' => $infosuppliestypesub, 
       'typekinds' => $typekind,
       'idtype' => $idtype 
       ]);
  
   }
  
  
  
   public function updatesuppliestypesub(Request $request)
   {
       $id = $request->SUP_TYPE_SUP_ID; 
       $idtype = $request->SUP_TYPE_ID;

       $updatesuppliestypesub= Suppliestypesub::find($id);
       $updatesuppliestypesub->SUP_TYPE_SUP_NAME = $request->SUP_TYPE_SUP_NAME;
       $updatesuppliestypesub->SUP_TYPE_ID = $idtype;
       $updatesuppliestypesub->SUP_TYPE_KIND_ID = $request->SUP_TYPE_KIND_ID;
       $updatesuppliestypesub->SUP_TYPE_SUP_CODE = $request->SUP_TYPE_SUP_CODE;
           
       $updatesuppliestypesub->save();
  
  
       return redirect()->route('setup.infosuppliestypesub',[
           'idtype' => $idtype
       ]); 
  
   }
  
   
   public function destroysuppliestypesub($id,$idtype) { 
  
       Suppliestypesub::destroy($id);         
       //return redirect()->action('ChangenameController@infouserchangename');  
       return redirect()->route('setup.infosuppliestypesub',[
           'idtype' => $idtype
       ]); 
   }

   
   function switchactivetypesub(Request $request)
   {  
       //return $request->all(); 
       $id = $request->typesub;
       $typesubactive = Suppliestypesub::find($id);
       $typesubactive->ACTIVE = $request->onoff;
       $typesubactive->save();
   }
  
   //=====กลุ่มกรรมการ=====

   public function infosuppliesboardlist()
   {
       $infosuppliesboardlist = Suppliesconboardlist::orderBy('BOARD_GROUP_ID', 'asc')  
       ->get();                         
       
  //dd($inforoom);
   return view('admin_asset_supplies.suppliesboardlist',[
       'infosuppliesboardlists' =>  $infosuppliesboardlist
   ]);
   }   
  
   public function createsuppliesboardlist(Request $request)
   {

       return view('admin_asset_supplies.suppliesboardlist_add');
  
   }
  
   public function savesuppliesboardlist(Request $request)
   {
       //return $request->all();
  
           $addsuppliesboardlist= new Suppliesconboardlist(); 
           $addsuppliesboardlist->BOARD_GROUP_NAME = $request->BOARD_GROUP_NAME;
          
           $addsuppliesboardlist->save();
  
           return redirect()->route('setup.infosuppliesboardlist'); 
   }
  
   public function editsuppliesboardlist(Request $request,$id)
   {
      // return $request->all();
   

      $infosuppliesboardlist= Suppliesconboardlist::where('BOARD_GROUP_ID','=',$id)
      ->first();

  
  
       //dd($inforbudget);
       return view('admin_asset_supplies.suppliesboardlist_edit',[
       'infosuppliesboardlist' => $infosuppliesboardlist, 
       ]);
  
   }
  
  
  
   public function updatesuppliesboardlist(Request $request)
   {
       $id = $request->BOARD_GROUP_ID; 
  
       $updatesuppliesboardlist= Suppliesconboardlist::find($id);
       $updatesuppliesboardlist->BOARD_GROUP_NAME = $request->BOARD_GROUP_NAME;

       $updatesuppliesboardlist->save();
  
  
       return redirect()->route('setup.infosuppliesboardlist'); 
  
   }
  
   
   public function destroysuppliesboardlist($id) { 
  
    Suppliesconboardlist::destroy($id);         
       //return redirect()->action('ChangenameController@infouserchangename');  
       return redirect()->route('setup.infosuppliesboardlist');   
   }


      //--------------boardlistperson
      public function infosuppliesboardlistperson($idlist)
      {
          $infosuppliesboardlistperson = Suppliesconboardlistperson::leftjoin('supplies_position','supplies_con_board_list_person.SUP_POSITION_ID','=','supplies_position.POSITION_ID')
          ->where('BOARD_GROUP_ID','=',$idlist)
          ->orderBy('ID', 'asc')  
          ->get();   
          
   
          $infosuppboardlistname= Suppliesconboardlist::where('BOARD_GROUP_ID','=',$idlist)
          ->first();
          
     //dd($inforoom);
      return view('admin_asset_supplies.suppliesboardlistperson',[
          'infosuppliesboardlistpersons' =>  $infosuppliesboardlistperson,
          'infosuppboardlistname' =>  $infosuppboardlistname
      ]);
      }   
     
      public function createsuppliesboardlistperson(Request $request,$idlist)
      {
          $person = DB::table('hrd_person')->where('HR_STATUS_ID','=',1)->get();

          $subposition = DB::table('supplies_position')->get();
   
          return view('admin_asset_supplies.suppliesboardlistperson_add',[
              'persons' => $person, 
              'subpositions' => $subposition, 
              'idlist' => $idlist, 
          ]);
     
      }
     
      public function savesuppliesboardlistperson(Request $request)
      {
              $idlist = $request->BOARD_GROUP_ID;
   
              //dd($idtype);
     
              $addsuppliesboardlistperson= new Suppliesconboardlistperson(); 
              $addsuppliesboardlistperson->BOARD_GROUP_ID = $idlist;

              $addsuppliesboardlistperson->HR_ID = $request->HR_ID;

              $infomationperson = DB::table('hrd_person')
              ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
              ->where('ID','=',$request->HR_ID)->first(); 
              $addsuppliesboardlistperson->HR_NAME = $infomationperson->HR_PREFIX_NAME.''. $infomationperson->HR_FNAME.' '. $infomationperson->HR_LNAME;
              $addsuppliesboardlistperson->HR_POSITION =$infomationperson->POSITION_IN_WORK;

              $addsuppliesboardlistperson->SUP_POSITION_ID = $request->SUP_POSITION_ID;
             
              
              $addsuppliesboardlistperson->save();
     
              return redirect()->route('setup.infosuppliesboardlistperson',[
                  'idlist' => $idlist
              ]); 
      }
     
      public function editsuppliesboardlistperson(Request $request,$id,$idlist)
      {
         // return $request->all();
      
   
         $infosuppliesboardlistperson= Suppliesconboardlistperson::where('ID','=',$id)
         ->first();
   
         $person = DB::table('hrd_person')->where('HR_STATUS_ID','=',1)->get();

         $subposition = DB::table('supplies_position')->get();
     
     
          //dd($inforbudget);
          return view('admin_asset_supplies.suppliesboardlistperson_edit',[
          'infosuppliesboardlistperson' => $infosuppliesboardlistperson, 
          'persons' => $person,
          'subpositions' => $subposition,
          'idlist' => $idlist 
          ]);
     
      }
     
     
     
      public function updatesuppliesboardlistperson(Request $request)
      {
          $id = $request->ID; 
          $idlist = $request->BOARD_GROUP_ID;

           
          $updatesupplieslistperson= Suppliesconboardlistperson::find($id);
          $updatesupplieslistperson->BOARD_GROUP_ID = $idlist;

          $updatesupplieslistperson->HR_ID = $request->HR_ID;

          $infomationperson = DB::table('hrd_person')
          ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
          ->where('ID','=',$request->HR_ID)->first(); 
          $updatesupplieslistperson->HR_NAME = $infomationperson->HR_PREFIX_NAME.''. $infomationperson->HR_FNAME.' '. $infomationperson->HR_LNAME;
          $updatesupplieslistperson->HR_POSITION =$infomationperson->POSITION_IN_WORK;

          $updatesupplieslistperson->SUP_POSITION_ID = $request->SUP_POSITION_ID;
         
          
          $updatesupplieslistperson->save();
     
     
          return redirect()->route('setup.infosuppliesboardlistperson',[
              'idlist' => $idlist
          ]); 
     
      }
     
      
      public function destroysuppliesboardlistperson($id,$idlist) { 
     
        Suppliesconboardlistperson::destroy($id);         
          //return redirect()->action('ChangenameController@infouserchangename');  
          return redirect()->route('setup.infosuppliesboardlistperson',[
              'idlist' => $idlist
          ]); 
      }

     //=====ตึกอาคารและที่ตั้ง=====


     
   public function infosupplieslocation()
   {
       $infosupplieslocation = Supplieslocation::leftJoin('hrd_person','hrd_person.ID','=','supplies_location.PERSON_CONTACT_ID')
       ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
       ->orderBy('LOCATION_ID', 'asc')  
       ->get();                         
       
  //dd($inforoom);
   return view('admin_asset_supplies.supplieslocation ',[
       'infosupplieslocations' =>  $infosupplieslocation
   ]);
   }   
  
   public function createsupplieslocation(Request $request)
   {
       $person = DB::table('hrd_person')->where('HR_STATUS_ID','=',1)->get();

       return view('admin_asset_supplies.supplieslocation_add',[
                'persons' => $person,
       ]);
  
   }
  
   public function savesupplieslocation(Request $request)
   {
       //return $request->all();
  
           $addsupplieslocation= new Supplieslocation(); 
           $addsupplieslocation->LOCATION_NAME = $request->LOCATION_NAME;
           $addsupplieslocation->LOCATION_PHONE = $request->LOCATION_PHONE;
           $addsupplieslocation->PERSON_CONTACT_ID = $request->PERSON_CONTACT_ID;
          
           $addsupplieslocation->save();
  
           return redirect()->route('setup.infosupplieslocation'); 
   }
  
   public function editsupplieslocation(Request $request,$id)
   {
      // return $request->all();
      $person = DB::table('hrd_person')->where('HR_STATUS_ID','=',1)->get();

      $infosupplieslocation= Supplieslocation::where('LOCATION_ID','=',$id)
      ->first();

  
  
       //dd($inforbudget);
       return view('admin_asset_supplies.supplieslocation_edit',[
       'infosupplieslocation' => $infosupplieslocation, 
       'persons' => $person,

       ]);
  
   }
  
  
  
   public function updatesupplieslocation(Request $request)
   {
       $id = $request->LOCATION_ID; 
  
       $updatesupplieslocation= Supplieslocation::find($id);
       $updatesupplieslocation->LOCATION_NAME = $request->LOCATION_NAME;
       $updatesupplieslocation->LOCATION_PHONE = $request->LOCATION_PHONE;
       $updatesupplieslocation->PERSON_CONTACT_ID = $request->PERSON_CONTACT_ID;

       $updatesupplieslocation->save();
  
  
       return redirect()->route('setup.infosupplieslocation'); 
  
   }
  
   
   public function destroysupplieslocation($id) { 
  
    Supplieslocation::destroy($id);         
       //return redirect()->action('ChangenameController@infouserchangename');  
       return redirect()->route('setup.infosupplieslocation');   
   }

      //--------------ตั้งค่าชั้น locationlevel
      public function infosupplieslocationlevel($idlocation)
      {
          $infosupplieslocationlevel= Supplieslocationlevel::where('LOCATION_ID','=',$idlocation)
          ->orderBy('LOCATION_LEVEL_ID', 'asc')  
          ->get();   
       


            $infosupplocationlevelname= Supplieslocation::where('LOCATION_ID','=',$idlocation)
            ->first();

 
          
     //dd($inforoom);
      return view('admin_asset_supplies.supplieslocationlevel',[
          'infosupplieslocationlevels' =>  $infosupplieslocationlevel,
          'infosupplocationlevelname' =>  $infosupplocationlevelname
      ]);
      }   
     
      public function createsupplieslocationlevel(Request $request,$idlocation)
      {
        
   
          return view('admin_asset_supplies.supplieslocationlevel_add',[
       
              'idlocation' => $idlocation, 
          ]);
     
      }
     
      public function savesupplieslocationlevel(Request $request)
      {
              $idlocation = $request->LOCATION_ID;
   
              //dd($idtype);
     
              $addsupplieslocationlevel= new Supplieslocationlevel(); 
              $addsupplieslocationlevel->LOCATION_ID = $idlocation;
              $addsupplieslocationlevel->LOCATION_LEVEL_NAME = $request->LOCATION_LEVEL_NAME;
              $addsupplieslocationlevel->save();
     
              return redirect()->route('setup.infosupplieslocationlevel',[
                  'idlocation' => $idlocation
              ]); 
      }
     
      public function editsupplieslocationlevel(Request $request,$id,$idlocation)
      {
  
         $infosupplieslocationlevel= Supplieslocationlevel::where('LOCATION_LEVEL_ID','=',$id)
         ->first();
     

          return view('admin_asset_supplies.supplieslocationlevel_edit',[
            'infosupplieslocationlevel' => $infosupplieslocationlevel,
            'idlocation' => $idlocation, 
          ]);
     
      }
     
     
     
      public function updatesupplieslocationlevel(Request $request)
      {
          $id = $request->LOCATION_LEVEL_ID; 
          $idlocation = $request->LOCATION_ID;

           
          $updatesupplieslocationlevel= Supplieslocationlevel::find($id);
          $updatesupplieslocationlevel->LOCATION_ID = $idlocation;
          $updatesupplieslocationlevel->LOCATION_LEVEL_NAME = $request->LOCATION_LEVEL_NAME;
          
          $updatesupplieslocationlevel->save();
     
     
          return redirect()->route('setup.infosupplieslocationlevel',[
              'idlocation' => $idlocation
          ]); 
     
      }
     
      
      public function destroysupplieslocationlevel($id,$idlocation) { 
     
        Supplieslocationlevel::destroy($id);         
          //return redirect()->action('ChangenameController@infouserchangename');  
          return redirect()->route('setup.infosupplieslocationlevel',[
            'idlocation' => $idlocation
          ]); 
      }

         //--------------ตั้งค่าชั้น locationlevelroom
         public function infosupplieslocationlevelroom($idlocation,$idlocationlevel)
         {
             $infosupplieslocationlevelroom= Supplieslocationlevelroom::where('LOCATION_LEVEL_ID','=',$idlocationlevel)
             ->orderBy('LEVEL_ROOM_ID', 'asc')  
             ->get();   
   
               $infosupplocationlevelname= Supplieslocationlevel::where('LOCATION_LEVEL_ID','=',$idlocationlevel)
               ->first();

               $infosupplocationname= Supplieslocation::where('LOCATION_ID','=',$idlocation)
               ->first();
   
    
             
        //dd($inforoom);
         return view('admin_asset_supplies.supplieslocationlevelroom',[
             'infosupplieslocationlevelrooms' =>  $infosupplieslocationlevelroom,
             'infosupplocationlevelname' =>  $infosupplocationlevelname,
             'infosupplocationname' =>  $infosupplocationname,
         ]);
         }   
        
         public function createsupplieslocationlevelroom(Request $request,$idlocation,$idlocationlevel)
         {
           
      
             return view('admin_asset_supplies.supplieslocationlevelroom_add',[
                 'idlocation' => $idlocation, 
                 'idlocationlevel' => $idlocationlevel, 
             ]);
        
         }
        
         public function savesupplieslocationlevelroom(Request $request)
         {
                 $idlocation = $request->LOCATION_ID;
                 $idlocationlevel = $request->LOCATION_LEVEL_ID;
      
                 //dd($idtype);
        
                 $addsupplieslocationlevelroom= new Supplieslocationlevelroom(); 
                 $addsupplieslocationlevelroom->LOCATION_LEVEL_ID = $idlocationlevel;
                 $addsupplieslocationlevelroom->LEVEL_ROOM_NAME = $request->LEVEL_ROOM_NAME;
                 $addsupplieslocationlevelroom->save();
        
                 return redirect()->route('setup.infosupplieslocationlevelroom',[
                     'idlocation' => $idlocation,
                     'idlocationlevel' => $idlocationlevel
                 ]); 
         }
        
         public function editsupplieslocationlevelroom(Request $request,$id,$idlocation,$idlocationlevel)
         {
     
            $infosupplieslocationlevelroom= Supplieslocationlevelroom::where('LEVEL_ROOM_ID','=',$id)
            ->first();
        
   
             return view('admin_asset_supplies.supplieslocationlevelroom_edit',[
               'infosupplieslocationlevelroom' => $infosupplieslocationlevelroom,
               'idlocation' => $idlocation,
                'idlocationlevel' => $idlocationlevel
             ]);
        
         }
        
        
        
         public function updatesupplieslocationlevelroom(Request $request)
         {
             $id = $request->LEVEL_ROOM_ID; 
             $idlocation = $request->LOCATION_ID;
             $idlocationlevel = $request->LOCATION_LEVEL_ID;
   
              
             $updatesupplieslocationlevelroom= Supplieslocationlevelroom::find($id);
             $updatesupplieslocationlevelroom->LOCATION_LEVEL_ID = $idlocationlevel;
             $updatesupplieslocationlevelroom->LEVEL_ROOM_NAME = $request->LEVEL_ROOM_NAME;
             
             $updatesupplieslocationlevelroom->save();
        
        
             return redirect()->route('setup.infosupplieslocationlevelroom',[
                'idlocation' => $idlocation,
               'idlocationlevel' => $idlocationlevel,
             ]); 
        
         }
        
         
         public function destroysupplieslocationlevelroom($id,$idlocation,$idlocationlevel) { 
        
           Supplieslocationlevelroom::destroy($id);         
             //return redirect()->action('ChangenameController@infouserchangename');  
             return redirect()->route('setup.infosupplieslocationlevelroom',[
               'idlocation' => $idlocation,
               'idlocationlevel' => $idlocationlevel,
             ]); 
         }


  //=======================================================D===========================================================

  public function infosuppliesconpremise()
  {
    $infosuppliesconpremise= Suppliesconpremise::orderBy('PERMISE_ID', 'asc')  
    ->get(); 
    return view('admin_asset_supplies.suppliesconpremise',[
            'infosuppliesconpremiseT' =>  $infosuppliesconpremise
        ]);
  }   
 
  public function createsuppliesconpremise(Request $request)
  {    
      return view('admin_asset_supplies.suppliesconpremise_add'); 
  }
 
  public function savesuppliesconpremise(Request $request)
  {
    $addsuppliesconpremise= new Suppliesconpremise(); 
    $addsuppliesconpremise->PERMISE_NAME = $request->PERMISE_NAME;        
    $addsuppliesconpremise->save(); 
    return redirect()->route('setup.infosuppliesconpremise'); 
  }
 
  public function editsuppliesconpremise(Request $request,$id)
  {    
    $infosuppliesconpremise= Suppliesconpremise::where('PERMISE_ID','=',$id)
    ->first();
    return view('admin_asset_supplies.suppliesconpremise_edit',[
      'infosuppliesconpremiseT' => $infosuppliesconpremise, 
      ]);
  }
 
  public function updatesuppliesconpremise(Request $request)
  {
      $id = $request->PERMISE_ID;  
      $updatesuppliesconpremise= Suppliesconpremise::find($id);
      $updatesuppliesconpremise->PERMISE_NAME = $request->PERMISE_NAME;        
      $updatesuppliesconpremise->save();  
      return redirect()->route('setup.infosuppliesconpremise');
  }
  
  public function destroysuppliesconpremise($id) { 
 
    Suppliesconpremise::destroy($id);         
      //return redirect()->action('ChangenameController@infouserchangename');  
      return redirect()->route('setup.infosuppliesconpremise');   
  }

  ///----------------------------------------------------------------------////

public function infosuppliescontypelist()
{
  $infosuppliescontypelist= Suppliescontypelist::orderBy('LIST_TYPE_ID', 'asc')  
  ->get(); 
  return view('admin_asset_supplies.suppliescontypelist',[
          'infosuppliescontypelistT' =>  $infosuppliescontypelist
      ]);
}   

public function createsuppliescontypelist(Request $request)
{    
    return view('admin_asset_supplies.suppliescontypelist_add'); 
}

public function savesuppliescontypelist(Request $request)
{
  $addsuppliescontypelist= new Suppliescontypelist(); 
  $addsuppliescontypelist->LIST_TYPE_NAME = $request->LIST_TYPE_NAME;        
  $addsuppliescontypelist->save(); 
  return redirect()->route('setup.infosuppliescontypelist'); 
}

public function editsuppliescontypelist(Request $request,$id)
{    
  $infosuppliescontypelist= Suppliescontypelist::where('LIST_TYPE_ID','=',$id)
  ->first();
  return view('admin_asset_supplies.suppliescontypelist_edit',[
    'infosuppliescontypelistT' => $infosuppliescontypelist, 
    ]);
}

public function updatesuppliescontypelist(Request $request)
{
    $id = $request->LIST_TYPE_ID;  
    $updatesuppliescontypelist= Suppliescontypelist::find($id);
    $updatesuppliescontypelist->LIST_TYPE_NAME = $request->LIST_TYPE_NAME;        
    $updatesuppliescontypelist->save();  
    return redirect()->route('setup.infosuppliescontypelist');
}

public function destroysuppliescontypelist($id) { 

  Suppliescontypelist::destroy($id);         
    //return redirect()->action('ChangenameController@infouserchangename');  
    return redirect()->route('setup.infosuppliescontypelist');   
}
///-----------------------------------------------------------------/////
///-----------------------------------------------------------------/////
public function infosuppliesexpiretype()
{
  $infosuppliesexpiretype= Suppliesexpiretype::orderBy('EXPIRE_TYPE_ID', 'asc')  
  ->get(); 
  return view('admin_asset_supplies.suppliesexpiretype',[
          'infosuppliesexpiretypeT' =>  $infosuppliesexpiretype
      ]);
}   

public function createsuppliesexpiretype(Request $request)
{    
    return view('admin_asset_supplies.suppliesexpiretype_add'); 
}

public function savesuppliesexpiretype(Request $request)
{
  $addsuppliescontypelist= new Suppliesexpiretype(); 
  $addsuppliescontypelist->EXPIRE_TYPE_NAME = $request->EXPIRE_TYPE_NAME; 
  $addsuppliescontypelist->EXPIRE_TYPE_DETAIL = $request->EXPIRE_TYPE_DETAIL;        
  $addsuppliescontypelist->save(); 
  return redirect()->route('setup.infosuppliesexpiretype'); 
}

public function editsuppliesexpiretype(Request $request,$id)
{    
  $infosuppliesexpiretype= Suppliesexpiretype::where('EXPIRE_TYPE_ID','=',$id)
  ->first();
  return view('admin_asset_supplies.suppliesexpiretype_edit',[
    'infosuppliesexpiretypeT' => $infosuppliesexpiretype, 
    ]);
}

public function updatesuppliesexpiretype(Request $request)
{
    $id = $request->EXPIRE_TYPE_ID;  
    $updatesuppliesexpiretype= Suppliesexpiretype::find($id);
    $updatesuppliesexpiretype->EXPIRE_TYPE_NAME = $request->EXPIRE_TYPE_NAME; 
    $updatesuppliesexpiretype->EXPIRE_TYPE_DETAIL = $request->EXPIRE_TYPE_DETAIL;        
    $updatesuppliesexpiretype->save();  
    return redirect()->route('setup.infosuppliesexpiretype');
}


public function destroysuppliesexpiretype($id) { 

    Suppliesexpiretype::destroy($id);         
    //return redirect()->action('ChangenameController@infouserchangename');  
    return redirect()->route('setup.infosuppliesexpiretype');   
}
///-----------------------------------------------------------------/////

public function infosuppliessendmoneyitem()
{
  $infosuppliessendmoneyitem= Suppliessendmoneyitem::orderBy('MONEY_SEND_ITEM_ID', 'asc')  
  ->get(); 
  return view('admin_asset_supplies.suppliessendmoneyitem',[
          'infosuppliessendmoneyitemT' =>  $infosuppliessendmoneyitem
      ]);
}   

public function createsuppliessendmoneyitem(Request $request)
{    
    return view('admin_asset_supplies.suppliessendmoneyitem_add'); 
}

public function savesuppliessendmoneyitem(Request $request)
{
  $addsuppliessendmoneyitem= new Suppliessendmoneyitem(); 
  $addsuppliessendmoneyitem->MONEY_SEND_ITEM_NAME = $request->MONEY_SEND_ITEM_NAME; 
        
  $addsuppliessendmoneyitem->save(); 
  return redirect()->route('setup.infosuppliessendmoneyitem'); 
}

public function editsuppliessendmoneyitem(Request $request,$id)
{    
  $infosuppliessendmoneyitem= Suppliessendmoneyitem::where('MONEY_SEND_ITEM_ID','=',$id)
  ->first();
  return view('admin_asset_supplies.suppliessendmoneyitem_edit',[
    'infosuppliessendmoneyitemT' => $infosuppliessendmoneyitem, 
    ]);
}

public function updatesuppliessendmoneyitem(Request $request)
{
    $id = $request->MONEY_SEND_ITEM_ID;  
    // dd($id);
    $updatesuppliessendmoneyitem= Suppliessendmoneyitem::find($id);
    $updatesuppliessendmoneyitem->MONEY_SEND_ITEM_NAME = $request->MONEY_SEND_ITEM_NAME;           
    $updatesuppliessendmoneyitem->save();  
    return redirect()->route('setup.infosuppliessendmoneyitem');
}

public function destroysuppliessendmoneyitem($id) { 

    Suppliessendmoneyitem::destroy($id);         
    //return redirect()->action('ChangenameController@infouserchangename');  
    return redirect()->route('setup.infosuppliessendmoneyitem');   
}
///-----------------------------------------------------------------/////
public function infosuppliesvendor()
{
  $infosuppliesvendor= Suppliesvendor::orderBy('VENDOR_ID', 'asc')  
  ->get(); 
  return view('admin_asset_supplies.suppliesvendor',[
          'infosuppliesvendorT' =>  $infosuppliesvendor
      ]);
}   

public function createsuppliesvendor(Request $request)
{    
    $infosuppliesvendor= Suppliesvendor::orderBy('VENDOR_ID', 'asc')  
    ->get(); 
    return view('admin_asset_supplies.suppliesvendor_add',[
        'infosuppliesvendorT' =>  $infosuppliesvendor
    ]); 
}

public function savesuppliesvendor(Request $request)
{
  $addsuppliesvendor= new Suppliesvendor(); 
  $addsuppliesvendor->VENDOR_NAME = $request->VENDOR_NAME; 
  $addsuppliesvendor->VENDOR_EMAIL = $request->VENDOR_EMAIL;
  $addsuppliesvendor->VENDOR_ADDRESS = $request->VENDOR_ADDRESS;
  $addsuppliesvendor->VENDOR_PHONE = $request->VENDOR_PHONE;
  $addsuppliesvendor->VENDOR_POSTCODE = $request->VENDOR_POSTCODE;
  $addsuppliesvendor->VENDOR_NAME_SHOT = $request->VENDOR_NAME_SHOT;
  $addsuppliesvendor->VAT_NUM = $request->VAT_NUM;
  $addsuppliesvendor->VENDOR_NUM = $request->VENDOR_NUM;
  $addsuppliesvendor->ACTIVE = 'True';
  $addsuppliesvendor->VENDOR_CONTECT = $request->VENDOR_CONTECT;
  $addsuppliesvendor->VENDOR_TAX_NUM = $request->VENDOR_TAX_NUM;
  $addsuppliesvendor->VENDOR_FAX = $request->VENDOR_FAX;
  $addsuppliesvendor->VENDOR_BANK_NAME = $request->VENDOR_BANK_NAME;
  $addsuppliesvendor->VENDOR_BANK_NUM = $request->VENDOR_BANK_NUM;
  $addsuppliesvendor->VENDOR_BANK = $request->VENDOR_BANK;
  $addsuppliesvendor->VENDOR_BANK_TYPE = $request->VENDOR_BANK_TYPE;
  $addsuppliesvendor->VENDOR_ADDRESS_SEND= $request->VENDOR_ADDRESS_SEND;
  $addsuppliesvendor->VENDOR_POSTCODE_SEND= $request->VENDOR_POSTCODE_SEND;
  $addsuppliesvendor->VENDOR_BANK_CREDITOR= $request->VENDOR_BANK_CREDITOR;
  $addsuppliesvendor->VENDOR_BANK_DEBTOR= $request->VENDOR_BANK_DEBTOR;
  $addsuppliesvendor->VENDOR_BANK_BRANCH= $request->VENDOR_BANK_BRANCH;
  $addsuppliesvendor->VENDOR_SET_BUY= $request->VENDOR_SET_BUY;
  $addsuppliesvendor->VENDOR_SET_SELL= $request->VENDOR_SET_SELL;  
  $addsuppliesvendor->save(); 

  return redirect()->route('setup.infosuppliesvendor'); 
}

public function editsuppliesvendor(Request $request,$id)
{    
  $infosuppliesvendor= Suppliesvendor::where('VENDOR_ID','=',$id)
  ->first();
  return view('admin_asset_supplies.suppliesvendor_edit',[
    'infosuppliesvendorT' => $infosuppliesvendor, 
    ]);
}

public function updatesuppliesvendor(Request $request)
{
    $id = $request->VENDOR_ID;  
    // dd($id);
    $updatesuppliesvendor= Suppliesvendor::find($id);
    $updatesuppliesvendor->VENDOR_NAME = $request->VENDOR_NAME;
    $updatesuppliesvendor->VENDOR_EMAIL = $request->VENDOR_EMAIL;
    $updatesuppliesvendor->VENDOR_ADDRESS = $request->VENDOR_ADDRESS;
    $updatesuppliesvendor->VENDOR_PHONE = $request->VENDOR_PHONE;
    $updatesuppliesvendor->VENDOR_POSTCODE = $request->VENDOR_POSTCODE;
    $updatesuppliesvendor->VENDOR_NAME_SHOT = $request->VENDOR_NAME_SHOT;
    $updatesuppliesvendor->VAT_NUM = $request->VAT_NUM;
    $updatesuppliesvendor->VENDOR_NUM = $request->VENDOR_NUM;
    $updatesuppliesvendor->VENDOR_CONTECT = $request->VENDOR_CONTECT;
    $updatesuppliesvendor->VENDOR_TAX_NUM = $request->VENDOR_TAX_NUM;
    $updatesuppliesvendor->VENDOR_FAX = $request->VENDOR_FAX;
    $updatesuppliesvendor->VENDOR_BANK_NAME = $request->VENDOR_BANK_NAME;
    $updatesuppliesvendor->VENDOR_BANK_NUM = $request->VENDOR_BANK_NUM;
    $updatesuppliesvendor->VENDOR_BANK = $request->VENDOR_BANK;
    $updatesuppliesvendor->VENDOR_BANK_TYPE = $request->VENDOR_BANK_TYPE;           
    $updatesuppliesvendor->save();  
    return redirect()->route('setup.infosuppliesvendor');
}

public function destroysuppliesvendor($id) { 

    Suppliesvendor::destroy($id);         
    //return redirect()->action('ChangenameController@infouserchangename');  
    return redirect()->route('setup.infosuppliesvendor');   
}

function switchactivevendor(Request $request)
{  
    //return $request->all(); 
    $id = $request->vendor;
    $budgetactive = Suppliesvendor::find($id);
    $budgetactive->ACTIVE = $request->onoff;
    $budgetactive->save();
}
///-----------------------------------------------------------------/////


public function infosuppliesinven()
{
   
    
    $infosuppliesinven= DB::table('supplies_inven')             
    ->leftJoin('supplies_location','supplies_inven.INVEN_LOCATION_ID','=','supplies_location.LOCATION_ID')
    ->leftJoin('hrd_person','supplies_inven.INVEN_HR_ID','=','hrd_person.ID') 
    ->orderby('INVEN_ID', 'asc')         
    ->get();

  return view('admin_warehouse.warehouseinven',[      
          'infosuppliesinvenT' =>  $infosuppliesinven         
          
          
      ]);
}   

public function createsuppliesinven(Request $request)
{   
          
    $personuser = DB::table('hrd_person')
    ->get();
    $position = DB::table('hrd_position')    
    ->get();
    $location =  DB::table('supplies_location')   
    ->get();

    return view('admin_warehouse.warehouseinven_add',[
        'locationT' => $location,
        'personuserT' => $personuser,
        'positionT' => $position
    ]);

}

public function savesuppliesinven(Request $request)
{
  $addsuppliesinven= new Suppliesinven(); 
  $addsuppliesinven->INVEN_NAME = $request->INVEN_NAME;
  $addsuppliesinven->INVEN_NAME_SHORT = $request->INVEN_NAME_SHORT;
  $addsuppliesinven->INVEN_HR_ID = $request->INVEN_HR_ID;
  $addsuppliesinven->INVEN_LOCATION_ID = $request->INVEN_LOCATION_ID;
  $addsuppliesinven->INVEN_ORDER_HR_ID = $request->INVEN_ORDER_HR_ID;
  $addsuppliesinven->INVEN_WRITE_HR_ID = $request->INVEN_WRITE_HR_ID;
  $addsuppliesinven->INVEN_BUY_HR_ID = $request->INVEN_BUY_HR_ID;
  $addsuppliesinven->INVEN_BUY_POSITION = $request->INVEN_BUY_POSITION;
  $addsuppliesinven->ACTIVE = 'True';
  $addsuppliesinven->save(); 

  return redirect()->route('setup.infosuppliesinven'); 
}

public function editsuppliesinven(Request $request,$id)
{    
    $personuser = DB::table('hrd_person')
    ->get();
    $position = DB::table('hrd_position')    
    ->get();
    $location =  DB::table('supplies_location')   
    ->get();

  $infosuppliesinven= Suppliesinven::where('INVEN_ID','=',$id)
  ->first();

  return view('admin_warehouse.warehouseinven_edit',[
    'infosuppliesinvenT' => $infosuppliesinven,
    'locationT' => $location,
        'personuserT' => $personuser,
        'positions' => $position 
    ]);
}

public function updatesuppliesinven(Request $request)
{
    $id = $request->INVEN_ID;  
    // dd($id);
    $updatesuppliesinven= Suppliesinven::find($id);
    $updatesuppliesinven->INVEN_NAME = $request->INVEN_NAME;
    $updatesuppliesinven->INVEN_NAME_SHORT = $request->INVEN_NAME_SHORT;
    $updatesuppliesinven->INVEN_HR_ID = $request->INVEN_HR_ID;
    $updatesuppliesinven->INVEN_LOCATION_ID = $request->INVEN_LOCATION_ID;
    $updatesuppliesinven->INVEN_ORDER_HR_ID = $request->INVEN_ORDER_HR_ID;
    $updatesuppliesinven->INVEN_WRITE_HR_ID = $request->INVEN_WRITE_HR_ID;
    $updatesuppliesinven->INVEN_BUY_HR_ID = $request->INVEN_BUY_HR_ID;
    $updatesuppliesinven->INVEN_BUY_POSITION = $request->INVEN_BUY_POSITION;
    $updatesuppliesinven->ACTIVE = $request->ACTIVE;
              
    $updatesuppliesinven->save();  
    return redirect()->route('setup.infosuppliesinven');
}

public function destroysuppliesinven($id) { 

    Suppliesinven::destroy($id);             
    return redirect()->route('setup.infosuppliesinven');   
}

function switchactiveinven(Request $request)
{  
    //return $request->all(); 
    $id = $request->inven;
    $budgetactive = Suppliesinven::find($id);
    $budgetactive->ACTIVE = $request->onoff;
    $budgetactive->save();
}


  //-----------------------------------------

  public function infosuppliesinvenpermis($idref)
  {
      $infoinven =  DB::table('supplies_inven')->where('INVEN_ID','=',$idref)->first();  
      $inforperson =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')->get();


      $infopersonpermis = DB::table('supplies_inven_permiss')
      ->leftjoin('hrd_person','hrd_person.ID','=','supplies_inven_permiss.INVENPERMIS_PERSON_ID')
      ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
     ->where('supplies_inven_permiss.INVENPERMIS_INVEN_ID','=',$idref)
     ->get();
  
      return view('admin_warehouse.warehouseinven_permiss',[
          'infoinven' => $infoinven,
          'inforpersons' =>$inforperson,
          'infopersonpermiss' =>$infopersonpermis,
         
      ]);
  }

  public function savepersonpermis(Request $request)
  {
    
     $pesonid = $request->HR_ID;
     $idinven = $request->INVEN_ID;


  

          $addinvenpermiss = new Suppliesinvenpermiss(); 
          $addinvenpermiss->INVENPERMIS_PERSON_ID = $pesonid; 
          $addinvenpermiss->INVENPERMIS_INVEN_ID =  $idinven;
          $addinvenpermiss->save();


          return redirect()->route('setup.infosuppliesinvenpermis',[
              'idref' => $idinven 
          ]);

  }
  
  public function destroypersonpermis($id,$idinven ) { 

    Suppliesinvenpermiss::destroy($id);         
    return redirect()->route('setup.infosuppliesinvenpermis',[
        'idref' => $idinven 
    ]);
}





//-----------------------------------------------------

public function infoassettypevalue()
{
   $infoassettypevalue= DB::table('asset_type_value')              
    ->orderby('TYPE_VALUE_ID', 'asc')         
    ->get();
  return view('admin_asset_supplies.assettypevalue',[      
          'infoassettypevalueT' =>  $infoassettypevalue  
      ]);
}   

public function createassettypevalue(Request $request)
{             
    return view('admin_asset_supplies.assettypevalue_add');
}

public function saveassettypevalue(Request $request)
{
  $addassettypevalue= new Assettypevalue(); 
  $addassettypevalue->TYPE_VALUE_NAME = $request->TYPE_VALUE_NAME;
  $addassettypevalue->TYPE_VALUE_DETAIL = $request->TYPE_VALUE_DETAIL;
  
  $addassettypevalue->save(); 
  return redirect()->route('setup.infoassettypevalue'); 
}

public function editassettypevalue(Request $request,$id)
{   
  $infoassettypevalue= Assettypevalue::where('TYPE_VALUE_ID','=',$id)
  ->first();
  return view('admin_asset_supplies.assettypevalue_edit',[
    'infoassettypevalueT' => $infoassettypevalue      
    ]);
}

public function updateassettypevalue(Request $request)
{
    $id = $request->TYPE_VALUE_ID;  
    $updateassettypevalue= Assettypevalue::find($id);
    $updateassettypevalue->TYPE_VALUE_NAME = $request->TYPE_VALUE_NAME;
    $updateassettypevalue->TYPE_VALUE_DETAIL = $request->TYPE_VALUE_DETAIL;
              
    $updateassettypevalue->save();  
    return redirect()->route('setup.infoassettypevalue');
}

public function destroyassettypevalue($id) { 

    Assettypevalue::destroy($id);             
    return redirect()->route('setup.infoassettypevalue');   
}
///-----------------------------------------------------------------/////


public function infoofficer()
{
   $infoofficer= DB::table('supplies_officer')              
    ->orderby('SUP_OFFICER_ID', 'asc')         
    ->get();
  return view('admin_asset_supplies.suppliesofficer',[      
          'infoofficers' =>  $infoofficer  
      ]);
}  

public function createofficer(Request $request)
{             
    $infoperson = Person::where('hrd_person.HR_STATUS_ID', '<>', 5)
        ->where('hrd_person.HR_STATUS_ID', '<>', 6)
        ->where('hrd_person.HR_STATUS_ID', '<>', 7)
        ->where('hrd_person.HR_STATUS_ID', '<>', 8)->get();


    return view('admin_asset_supplies.suppliesofficer_add',[
        'infopersons' => $infoperson
    ]);
}

public function saveofficer(Request $request)
{
  $addofficer= new Suppliesofficer(); 
  $addofficer->SUP_OFFICER_PERSON_ID = $request->SUP_OFFICER_PERSON_ID;

  if($request->SUP_OFFICER_PERSON_ID  !=''){
    $WORK_SEND =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->where('hrd_person.ID','=',$request->SUP_OFFICER_PERSON_ID)->first();

    $SUP_OFFICER_PERSON_NAME  = $WORK_SEND->HR_PREFIX_NAME.''.$WORK_SEND->HR_FNAME.' '.$WORK_SEND->HR_LNAME;
    }else{
       $SUP_OFFICER_PERSON_NAME='';
    }

  $addofficer->SUP_OFFICER_PERSON_NAME = $SUP_OFFICER_PERSON_NAME;
  
  $addofficer->save(); 
  return redirect()->route('setup.infoofficer'); 
}

public function editofficer(Request $request,$id)
{   

    $infoperson = Person::where('hrd_person.HR_STATUS_ID', '<>', 5)
    ->where('hrd_person.HR_STATUS_ID', '<>', 6)
    ->where('hrd_person.HR_STATUS_ID', '<>', 7)
    ->where('hrd_person.HR_STATUS_ID', '<>', 8)->get();


  $infoofficer= Suppliesofficer::where('SUP_OFFICER_ID','=',$id)
  ->first();
  return view('admin_asset_supplies.suppliesofficer_edit',[
    'infopersons' => $infoperson,  
    'infoofficer' => $infoofficer,     
    ]);
}

public function updateofficer(Request $request)
{
    $id = $request->SUP_OFFICER_ID;  
    $updateassettypevalue= Suppliesofficer::find($id);
    $updateassettypevalue->SUP_OFFICER_PERSON_ID = $request->SUP_OFFICER_PERSON_ID;

    if($request->SUP_OFFICER_PERSON_ID  !=''){
        $WORK_SEND =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->where('hrd_person.ID','=',$request->SUP_OFFICER_PERSON_ID)->first();
    
        $SUP_OFFICER_PERSON_NAME  = $WORK_SEND->HR_PREFIX_NAME.''.$WORK_SEND->HR_FNAME.' '.$WORK_SEND->HR_LNAME;
        }else{
           $SUP_OFFICER_PERSON_NAME='';
        }

        
    $updateassettypevalue->SUP_OFFICER_PERSON_NAME = $SUP_OFFICER_PERSON_NAME;
              
    $updateassettypevalue->save();  
    return redirect()->route('setup.infoofficer');
}

public function destroyofficer($id) { 

    Suppliesofficer::destroy($id);             
    return redirect()->route('setup.infoofficer');   
}



function checktax(Request $request)
{
   
  $vendortaxnum= $request->get('vendortaxnum');
  $count= DB::table('supplies_vendor')
        ->where('supplies_vendor.VENDOR_TAX_NUM','=',$vendortaxnum) 
        ->count();
  

    $numlength = strlen((string)$vendortaxnum);

        if($count >= 1){
            $output='*มีเลขภาษีดังกล่าวในระบบแล้ว';
            echo $output;
        }else if($numlength < 13){
            $output='*กรุณาระบุเลขประจำตัวผู้เสียภาษีให้ครบถ้วน';
            echo $output;
        }      
            
}

function submitbutton(Request $request)
{
   
  $vendortaxnum= $request->get('vendortaxnum');
  $count= DB::table('supplies_vendor')
        ->where('supplies_vendor.VENDOR_TAX_NUM','=',$vendortaxnum) 
        ->count();
  

    $numlength = strlen((string)$vendortaxnum);

        if($count >= 1){
            echo  "<div align=\"right\">
            <button type=\"button\"  class=\"btn btn-hero-sm btn-hero-secondary\" ><i class=\"fas fa-save mr-2\"></i>บันทึกข้อมูล</button>
            <a href=".url('admin_asset_supplies/setupsuppliesvendor')." class=\"btn btn-hero-sm btn-hero-danger\" onclick=\"return confirm('ต้องการที่จะยกเลิกการเพิ่มข้อมูล ?')\" ><i class=\"fas fa-window-close mr-2\"></i>ยกเลิก</a> 
            </div>";
            
            
         
        }else if($numlength < 13){
            echo  "<div align=\"right\">
            <button type=\"button\"  class=\"btn btn-hero-sm btn-hero-secondary\" ><i class=\"fas fa-save mr-2\"></i>บันทึกข้อมูล</button>
            <a href=".url('admin_asset_supplies/setupsuppliesvendor')." class=\"btn btn-hero-sm btn-hero-danger\" onclick=\"return confirm('ต้องการที่จะยกเลิกการเพิ่มข้อมูล ?')\" ><i class=\"fas fa-window-close mr-2\"></i>ยกเลิก</a> 
            </div>";
            
       
        }else{

        echo "<div align=\"right\">
            <button type=\"submit\"  class=\"btn btn-hero-sm btn-hero-info\" ><i class=\"fas fa-save mr-2\"></i>บันทึกข้อมูล</button>
            <a href=".url('admin_asset_supplies/setupsuppliesvendor')." class=\"btn btn-hero-sm btn-hero-danger\" onclick=\"return confirm('ต้องการที่จะยกเลิกการเพิ่มข้อมูล ?')\" ><i class=\"fas fa-window-close mr-2\"></i>ยกเลิก</a> 
            </div>";
        
        }      
            
}



}
