<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Informcomtype;
use App\Models\Informcomengineer;
use App\Models\Informcompriority;
use App\Models\Informcomprogram;
use App\Models\Informcomcolor;
use App\Models\Informcomsupplierrepair;
use App\Models\Informcomhardware;
use App\Models\Informcomlocation;
use App\Models\Informcomsize;
use App\Models\Informservicelist;
use App\Models\Informcombrand;
use App\Models\Informcombuilding;
use App\Models\Informcomstatus;
use App\Models\Informrepairpriority;
use App\Models\Informcomrepairtype;
use App\Models\Assetpatools;
use App\Models\Assetpaardoctype;
use App\Models\Assetpaardocmedical;
use App\Models\Assetpadoccalibration;
use App\Models\Assetpadoccheck;
use App\Models\Assetpaardocleader;
use App\Models\Informrepairtech;
use App\Models\Informcomrepairlist;
use App\Models\Assetcareenginer;
use App\Models\Informrepairfunction;

use App\Models\Informrepairsetupfunc;
use App\Models\Informcomsetupfunc;
use App\Models\Assetcaresetupfunc;

class SetuprepairController extends Controller
{
public function infoinformcomtype()
    {
       $infoinformcomtype= DB::table('informcom_type')              
        ->orderby('COM_TYPE_ID', 'asc')         
        ->get();
      return view('admin_repair.informcomtype',[      
              'infoinformcomtypeT' =>  $infoinformcomtype  
          ]);
    }       
    public function createinformcomtype(Request $request)
    {             
        return view('admin_repair.informcomtype_add');
    }    
    public function saveinformcomtype(Request $request)
    {
      $addinformcomtype= new Informcomtype(); 
      $addinformcomtype->COM_TYPE_NAME = $request->COM_TYPE_NAME;          
      $addinformcomtype->save(); 
      return redirect()->route('setup.infoinformcomtype'); 
    }    
    public function editinformcomtype(Request $request,$id)
    {   
      $infoinformcomtype= Informcomtype::where('COM_TYPE_ID','=',$id)
      ->first();
      return view('admin_repair.informcomtype_edit',[
        'infoinformcomtypeT' => $infoinformcomtype      
        ]);
    }    
    public function updateinformcomtype(Request $request)
    {
        $id = $request->COM_TYPE_ID;  
        $updateinformcomtype= Informcomtype::find($id);
        $updateinformcomtype->COM_TYPE_NAME = $request->COM_TYPE_NAME;
        $updateinformcomtype->save();  
        return redirect()->route('setup.infoinformcomtype');
    }    
    public function destroyinformcomtype($id) { 
    
        Informcomtype::destroy($id);             
        return redirect()->route('setup.infoinformcomtype');   
}
//----------------------------------------------------------------------//
public function infoinformcomengineer()
  {
    $infoinformcomengineer= DB::table('informcom_engineer')              
      ->orderby('ID_ENGINEER', 'asc')         
      ->get();
    return view('admin_repair.informcomengineer',[      
            'infoinformcomengineerT' =>  $infoinformcomengineer  
        ]);
  }
  public function createinformcomengineer(Request $request)
  {       
    $infoperson = DB::table('hrd_person')
    ->leftjoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
      ->get();     
      return view('admin_repair.informcomengineer_add',[
          'infopersonT' => $infoperson
          // 'positionT' => $position
      ]);
  }
  public function saveinformcomengineer(Request $request)
  {
    $addinformcomengineer= new Informcomengineer(); 
    $addinformcomengineer->PERSON_ID = $request->PERSON_ID;
    $infoperson = DB::table('hrd_person')->leftjoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->where('ID','=',$request->PERSON_ID)->first();
    $addinformcomengineer->ENGINEER_NAME =  $infoperson->HR_FNAME." ".$infoperson->HR_LNAME;
  // $addinformcomengineer->ENGINEER_NAME =   $infoperson->HR_PERFIX_NAME."".$infoperson->HR_FNAME." ".$infoperson->HR_LNAME;
    $addinformcomengineer->POSITION = $infoperson->POSITION_IN_WORK;
    $addinformcomengineer->ACTIVE = $request->ACTIVE;
    $addinformcomengineer->save(); 

    return redirect()->route('setup.infoinformcomengineer'); 
  }
  public function editinformcomengineer(Request $request,$id)
  {   
    $infoper = DB::table('hrd_person')
    ->leftjoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
      ->get();
    
      $infoinformcomengineer= Informcomengineer::where('ID_ENGINEER','=',$id)
    ->first();

    return view('admin_repair.informcomengineer_edit',[
      'infoinformcomengineerT' => $infoinformcomengineer,
      'infoperT' => $infoper    
      ]);
  }
  public function updateinformcomengineer(Request $request)
  {
      $id = $request->ID_ENGINEER;  
      $updateinformcomengineer= Informcomengineer::find($id);
      $updateinformcomengineer->PERSON_ID = $request->PERSON_ID;
      $infoperson = DB::table('hrd_person')
    ->where('ID','=',$request->PERSON_ID)->first();
    
    $updateinformcomengineer->ENGINEER_NAME =  $infoperson->HR_FNAME." ".$infoperson->HR_LNAME;
    $updateinformcomengineer->POSITION = $infoperson->POSITION_IN_WORK;
      $updateinformcomengineer->ACTIVE = $request->ACTIVE;        
      $updateinformcomengineer->save();  
      return redirect()->route('setup.infoinformcomengineer');
  }
  public function destroyinformcomengineer($id) { 

      Informcomengineer::destroy($id);             
      return redirect()->route('setup.infoinformcomengineer');   
  }
  function switchactiveinformcomengineer(Request $request)
  {  
      //return $request->all(); 
      $id = $request->informcomengineer;
      $budgetactive = Informcomengineer::find($id);
      $budgetactive->ACTIVE = $request->onoff;
      $budgetactive->save();
}
//--------------------------------------------------------------------//

public function infoinformcompriority()
  {
    $infoinformcompriority= DB::table('informcom_priority')              
      ->orderby('PRIORITY_ID', 'asc')         
      ->get();
    return view('admin_repair.informcompriority',[      
            'infoinformcompriorityT' =>  $infoinformcompriority  
        ]);
  }       
  public function createinformcompriority(Request $request)
  {             
      return view('admin_repair.informcompriority_add');
  }    
  public function saveinformcompriority(Request $request)
  {
    $addinformcompriority= new Informcompriority(); 
    // $addinformcompriority->PRIORITY_ID = $request->PRIORITY_ID;
    $addinformcompriority->PRIORITY_NAME = $request->PRIORITY_NAME;          
    $addinformcompriority->save(); 
    return redirect()->route('setup.infoinformcompriority'); 
  }    
  public function editinformcompriority(Request $request,$id)
  {   
    $compriority= Informcompriority::where('PRIORITY_ID','=',$id)
    ->first();
    return view('admin_repair.informcompriority_edit',[
      'compriorityT' => $compriority      
      ]);
  }    
  public function updateinformcompriority(Request $request)
  {
      $id = $request->PRIORITY_ID;  
      $updateinformcompriority= Informcompriority::find($id);
      // $updateinformcompriority->PRIORITY_ID = $request->PRIORITY_ID;
      $updateinformcompriority->PRIORITY_NAME = $request->PRIORITY_NAME;
      $updateinformcompriority->save();  
      return redirect()->route('setup.infoinformcompriority');
  }    
  public function destroyinformcompriority($id) { 

      Informcompriority::destroy($id);             
      return redirect()->route('setup.infoinformcompriority');   
}
//--------------------------------------------------------------------//
public function infoinformcomprogram()
    {
       $infoinformcomprogram= DB::table('informcom_program')              
        ->orderby('PRO_ID', 'asc')         
        ->get();
      return view('admin_repair.informcomprogram',[      
              'infoinformcomprogramT' =>  $infoinformcomprogram  
          ]);
    }       
    public function createinformcomprogram(Request $request)
    {             
        return view('admin_repair.informcomprogram_add');
    }    
    public function saveinformcomprogram(Request $request)
    {
      $addinformcomprogram= new Informcomprogram(); 
      $addinformcomprogram->PRO_NAME = $request->PRO_NAME;  
      $addinformcomprogram->PRO_VER = $request->PRO_VER;         
      $addinformcomprogram->save(); 
      return redirect()->route('setup.infoinformcomprogram'); 
    }    
    public function editinformcomprogram(Request $request,$id)
    {   
      $comprogram = Informcomprogram::where('PRO_ID','=',$id)
      ->first();
      
      return view('admin_repair.informcomprogram_edit',[
        'comprogramT' => $comprogram      
        ]);
        // dd($infoinformcomprogram);
    }    
    
    public function updateinformcomprogram(Request $request)
    {
        $id = $request->PRO_ID;  
        $updateinformcomprogram= Informcomprogram::find($id);
        $updateinformcomprogram->PRO_NAME = $request->PRO_NAME;
        $updateinformcomprogram->PRO_VER = $request->PRO_VER;
        $updateinformcomprogram->save();  
        return redirect()->route('setup.infoinformcomprogram');
    }    
    public function destroyinformcomprogram($id) { 
    
        Informcomprogram::destroy($id);             
        return redirect()->route('setup.infoinformcomprogram');   
}
//---------------------------------------------------------------------------------------//

public function infoinformcomcolor()
    {
       $infoinformcomcolor= DB::table('informcom_color')              
        ->orderby('COLOR_ID', 'asc')         
        ->get();
      return view('admin_repair.informcomcolor',[      
              'infoinformcomcolorT' =>  $infoinformcomcolor  
          ]);
    }       
    public function createinformcomcolor(Request $request)
    {             
        return view('admin_repair.informcomcolor_add');
    }    
    public function saveinformcomcolor(Request $request)
    {
      $addinformcomcolor= new Informcomcolor(); 
      $addinformcomcolor->COLOR_NAME = $request->COLOR_NAME;          
      $addinformcomcolor->save(); 
      return redirect()->route('setup.infoinformcomcolor'); 
    }    
    public function editinformcomcolor(Request $request,$id)
    {   
      $infoinformcomcolor= Informcomcolor::where('COLOR_ID','=',$id)
      ->first();
      return view('admin_repair.informcomcolor_edit',[
        'infoinformcomcolorT' => $infoinformcomcolor      
        ]);
    }    
    public function updateinformcomcolor(Request $request)
    {
        $id = $request->COLOR_ID;  
        $updateinformcomcolor= Informcomcolor::find($id);
        $updateinformcomcolor->COLOR_NAME = $request->COLOR_NAME;
        $updateinformcomcolor->save();  
        return redirect()->route('setup.infoinformcomcolor');
    }    
    public function destroyinformcomcolor($id) { 
    
        Informcomcolor::destroy($id);             
        return redirect()->route('setup.infoinformcomcolor');   
}
//----------------------------------------------------------------//

    
public function infoinformcomsupplierrepair()
    {
       $informcomsupplierrepair= DB::table('informcom_supplier_repair')              
        ->orderby('SUPPLIER_ID', 'asc')         
        ->get();
      return view('admin_repair.informcomsupplierrepair',[      
              'informcomsupplierrepairT' =>  $informcomsupplierrepair  
          ]);
    }       
    public function createinformcomsupplierrepair(Request $request)
    {             
        return view('admin_repair.informcomsupplierrepair_add');
    }    
    public function saveinformcomsupplierrepair(Request $request)
    {
      $addrepair= new Informcomsupplierrepair(); 
      $addrepair->SUPPLIER_NAME = $request->SUPPLIER_NAME;
      $addrepair->ADDRESS = $request->ADDRESS;
      $addrepair->PHONE = $request->PHONE;
      $addrepair->FAX = $request->FAX;
      $addrepair->MOBILE = $request->MOBILE;
      $addrepair->CONTACT = $request->CONTACT;
      $addrepair->EMAIL = $request->EMAIL;
           
      $addrepair->save(); 
      return redirect()->route('setup.infoinformcomsupplierrepair'); 
    }    
    public function editinformcomsupplierrepair(Request $request,$id)
    {   
      $informcomsupplierrepair= Informcomsupplierrepair::where('SUPPLIER_ID','=',$id)
      ->first();
      return view('admin_repair.informcomsupplierrepair_edit',[
        'informcomsupplierrepairT' => $informcomsupplierrepair      
        ]);
    }    
    public function updateinformcomsupplierrepair(Request $request)
    {
        $id = $request->SUPPLIER_ID;  
        $updaterepair= Informcomsupplierrepair::find($id);
        $updaterepair->SUPPLIER_NAME = $request->SUPPLIER_NAME;
        $updaterepair->ADDRESS = $request->ADDRESS;
        $updaterepair->PHONE = $request->PHONE;
        $updaterepair->FAX = $request->FAX;
        $updaterepair->MOBILE = $request->MOBILE;
        $updaterepair->CONTACT = $request->CONTACT;
        $updaterepair->EMAIL = $request->EMAIL;
       
        $updaterepair->save();  
        return redirect()->route('setup.infoinformcomsupplierrepair');
    }    
    public function destroyinformcomsupplierrepair($id) { 
    
        Informcomsupplierrepair::destroy($id);             
        return redirect()->route('setup.infoinformcomsupplierrepair');   
}
//----------------------------------------------------------------//

    
public function infoinformcomhardware()
    {
       $infoinformcomhardware= DB::table('informcom_hardware')              
        ->orderby('HARDWARE_ID', 'asc')         
        ->get();
      return view('admin_repair.informcomhardware',[      
              'infoinformcomhardwareT' =>  $infoinformcomhardware  
          ]);
    }       
    public function createinformcomhardware(Request $request)
    {             
        return view('admin_repair.informcomhardware_add');
    }    
    public function saveinformcomhardware(Request $request)
    {
      $addinformcomhardware= new Informcomhardware(); 
      $addinformcomhardware->HARDWARE_NAME = $request->HARDWARE_NAME;          
      $addinformcomhardware->save(); 
      return redirect()->route('setup.infoinformcomhardware'); 
    }    
    public function editinformcomhardware(Request $request,$id)
    {   
      $informcomhardware= Informcomhardware::where('HARDWARE_ID','=',$id)
      ->first();
      return view('admin_repair.informcomhardware_edit',[
        'informcomhardwareT' => $informcomhardware      
        ]);
    }    
    public function updateinformcomhardware(Request $request)
    {
        $id = $request->HARDWARE_ID;  
        $updateinformcomhardware= Informcomhardware::find($id);
        $updateinformcomhardware->HARDWARE_NAME = $request->HARDWARE_NAME;
        $updateinformcomhardware->save();  
        return redirect()->route('setup.infoinformcomhardware');
    }    
    public function destroyinformcomhardware($id) { 
    
        Informcomhardware::destroy($id);             
        return redirect()->route('setup.infoinformcomhardware');   
}

//--------------------------------------------------------------------//
     
public function infoinformcomlocation()
    {
       $infoinformcomlocation= DB::table('informcom_location') 
       ->leftjoin ('informcom_building','informcom_location.BUILDING_ID','=','informcom_building.BUILDING_ID')            
        ->orderby('LOCATION_ID', 'asc')         
        ->get();
      return view('admin_repair.informcomlocation',[      
              'infoinformcomlocationT' =>  $infoinformcomlocation  
          ]);
    }       
    public function createinformcomlocation(Request $request)
    { 
      $building= DB::table('informcom_building') 
      ->get();            
        return view('admin_repair.informcomlocation_add',[
          'buildingT' =>  $building
        ]);
    }    
    public function saveinformcomlocation(Request $request)
    {
      $addlocation= new Informcomlocation(); 
      $addlocation->LOCATION_NAME = $request->LOCATION_NAME; 
      $addlocation->BUILDING_ID = $request->BUILDING_ID;
      $addlocation->CLASS = $request->CLASS;         
      $addlocation->save(); 
      return redirect()->route('setup.infoinformcomlocation'); 
    }    
    public function editinformcomlocation(Request $request,$id)
    {   
       $building = DB::table('informcom_building')->get();
      // ->leftjoin ('informcom_building','informcom_location.BUILDING_ID','=','informcom_building.BUILDING_ID')
     // ->where('LOCATION_ID','=',$id)
      $infoinformcomlocation= Informcomlocation::where('LOCATION_ID','=',$id)
      ->first();
      return view('admin_repair.informcomlocation_edit',[
        'infoinformcomlocationT' => $infoinformcomlocation,
        'buildingT' => $building 
            
        ]);
    }    
    public function updateinformcomlocation(Request $request)
    {
        $id = $request->LOCATION_ID;  
        $updatelocation= Informcomlocation::find($id);
        $updatelocation->LOCATION_NAME = $request->LOCATION_NAME;
        $updatelocation->BUILDING_ID = $request->BUILDING_ID;
        $updatelocation->CLASS = $request->CLASS;
        $updatelocation->save();  
        return redirect()->route('setup.infoinformcomlocation');
    }    
    public function destroyinformcomlocation($id) { 
    
        Informcomlocation::destroy($id);             
        return redirect()->route('setup.infoinformcomlocation');   
}

//---------------------------------------------------------------------///

public function infoinformcomsize()
    {
       $infoinformcomsize= DB::table('informcom_size')              
        ->orderby('SIZE_ID', 'asc')         
        ->get();
      return view('admin_repair.informcomsize',[      
              'infoinformcomsizeT' =>  $infoinformcomsize  
          ]);
    }       
    public function createinformcomsize(Request $request)
    {             
        return view('admin_repair.informcomsize_add');
    }    
    public function saveinformcomsize(Request $request)
    {
      $addinformcomsize= new Informcomsize(); 
      $addinformcomsize->SIZE_NAME = $request->SIZE_NAME; 
             
      $addinformcomsize->save(); 
      return redirect()->route('setup.infoinformcomsize'); 
    }    
    public function editinformcomsize(Request $request,$id)
    {   
      $infoinformcomsize= Informcomsize::where('SIZE_ID','=',$id)
      ->first();
      return view('admin_repair.informcomsize_edit',[
        'infoinformcomsizeT' => $infoinformcomsize      
        ]);
    }    
    public function updateinformcomsize(Request $request)
    {
        $id = $request->SIZE_ID;  
        $updateinformcomsize= Informcomsize::find($id);
        $updateinformcomsize->SIZE_NAME = $request->SIZE_NAME;
       
        $updateinformcomsize->save();  
        return redirect()->route('setup.infoinformcomsize');
    }    
    public function destroyinformcomsize($id) { 
    
        Informcomsize::destroy($id);             
        return redirect()->route('setup.infoinformcomsize');   
}
//---------------------------------------------------------------------///

public function infoservicelist()
      {
         $infoservicelist= DB::table('informcom_service_list')              
          ->orderby('SERVICE_LIST_ID', 'asc')         
          ->get();
        return view('admin_repair.informservicelist',[      
                'infoservicelistT' =>  $infoservicelist  
            ]);
      }       
      public function createservicelist(Request $request)
      {             
          return view('admin_repair.informservicelist_add');
      }    
      public function saveservicelist(Request $request)
      {
        $addservicelist= new Informservicelist(); 
        $addservicelist->SERVICE_LIST_NAME = $request->SERVICE_LIST_NAME; 
               
        $addservicelist->save(); 
        return redirect()->route('setup.infoservicelist'); 
      }    
      public function editservicelistt(Request $request,$id)
      {   
        $infoservicelist= Informservicelist::where('SERVICE_LIST_ID','=',$id)
        ->first();
        return view('admin_repair.informservicelist_edit',[
          'infoservicelistT' => $infoservicelist      
          ]);
      }    
      public function updateservicelist(Request $request)
      {
          $id = $request->SERVICE_LIST_ID;  
          $updateservicelist= Informservicelist::find($id);
          $updateservicelist->SERVICE_LIST_NAME = $request->SERVICE_LIST_NAME;
         
          $updateservicelist->save();  
          return redirect()->route('setup.infoservicelist');
      }    
      public function destroyservicelist($id) { 
      
        Informservicelist::destroy($id);             
          return redirect()->route('setup.infoservicelist');   
}
//---------------------------------------------------------------------///

public function infoinformcombrand()
       {
          $infoinformcombrand= DB::table('informcom_brand')              
           ->orderby('BRAND_ID', 'asc')         
           ->get();
         return view('admin_repair.informcombrand',[      
                 'infoinformcombrandT' =>  $infoinformcombrand  
             ]);
       }       
       public function createinformcombrand(Request $request)
       {             
           return view('admin_repair.informcombrand_add');
       }    
       public function saveinformcombrand(Request $request)
       {
         $addinformcombrand= new Informcombrand(); 
        
         $addinformcombrand->BRAND_NAME = $request->BRAND_NAME; 
                
         $addinformcombrand->save(); 
         return redirect()->route('setup.infoinformcombrand'); 
       }    
       public function editinformcombrand(Request $request,$id)
       {   
         $infoinformcombrand= Informcombrand::where('BRAND_ID','=',$id)
         ->first();
         return view('admin_repair.informcombrand_edit',[
           'infoinformcombrandT' => $infoinformcombrand      
           ]);
       }    
       public function updateinformcombrand(Request $request)
       {
           $id = $request->BRAND_ID;  
           $updateinformcombrand= Informcombrand::find($id);
         
           $updateinformcombrand->BRAND_NAME = $request->BRAND_NAME;
          
           $updateinformcombrand->save();  
           return redirect()->route('setup.infoinformcombrand');
       }    
       public function destroyinformcombrand($id) { 
       
        Informcombrand::destroy($id);             
           return redirect()->route('setup.infoinformcombrand');   
}

//----------------------------------------------------------//
public function infoinformcombuilding()
       {
          $infoinformcombuilding= DB::table('informcom_building')              
           ->orderby('BUILDING_ID', 'asc')         
           ->get();
         return view('admin_repair.informcombuilding',[      
                 'infoinformcombuildingT' =>  $infoinformcombuilding  
             ]);
       }       
       public function createinformcombuilding(Request $request)
       {             
           return view('admin_repair.informcombuilding_add');
       }    
       public function saveinformcombuilding(Request $request)
       {
         $addinformcombuilding= new Informcombuilding(); 
         $addinformcombuilding->BUILDING_NAME = $request->BUILDING_NAME; 
                
         $addinformcombuilding->save(); 
         return redirect()->route('setup.infoinformcombuilding'); 
       }    
       public function editinformcombuilding(Request $request,$id)
       {   
         $infoinformcombuilding= Informcombuilding::where('BUILDING_ID','=',$id)
         ->first();
         return view('admin_repair.informcombuilding_edit',[
           'infoinformcombuildingT' => $infoinformcombuilding      
           ]);
       }    
       public function updateinformcombuilding(Request $request)
       {
           $id = $request->BUILDING_ID;  
           $updateinformcombuilding= Informcombuilding::find($id);
           $updateinformcombuilding->BUILDING_NAME = $request->BUILDING_NAME;
          
           $updateinformcombuilding->save();  
           return redirect()->route('setup.infoinformcombuilding');
       }    
       public function destroyinformcombuilding($id) { 
       
        Informcombuilding::destroy($id);             
           return redirect()->route('setup.infoinformcombuilding');   
}
//-----------------------------------------------------------------------//

public function infoInformcomstatus()
  {
    $infoInformcomstatus= DB::table('informcom_status')              
      ->orderby('STATUS_ID', 'asc')         
      ->get();
    return view('admin_repair.informcomstatus',[      
            'infoInformcomstatusT' =>  $infoInformcomstatus  
        ]);
  }       
  public function createInformcomstatus(Request $request)
  {             
      return view('admin_repair.informcomstatus_add');
  }    
  public function saveInformcomstatus(Request $request)
  {
    $addinformcomstatus= new Informcomstatus(); 
    $addinformcomstatus->STATUS_NAME = $request->STATUS_NAME; 
          
    $addinformcomstatus->save(); 
    return redirect()->route('setup.infoInformcomstatus'); 
  }    
  public function editInformcomstatus(Request $request,$id)
  {   
    $infoInformcomstatus= Informcomstatus::where('STATUS_ID','=',$id)
    ->first();
    return view('admin_repair.informcomstatus_edit',[
      'infoInformcomstatusT' => $infoInformcomstatus      
      ]);
  }    
  public function updateInformcomstatus(Request $request)
  {
      $id = $request->STATUS_ID;  
      $updateinformcomstatus= Informcomstatus::find($id);
      $updateinformcomstatus->STATUS_NAME = $request->STATUS_NAME;
    
      $updateinformcomstatus->save();  
      return redirect()->route('setup.infoInformcomstatus');
  }    
  public function destroyInformcomstatus($id) { 

    Informcomstatus::destroy($id);             
      return redirect()->route('setup.infoInformcomstatus');   
}
//-----------------------------------------------------------------------//
public function inforepairpriority()
  {
    $inforepairpriority= DB::table('informrepair_priority')              
      ->orderby('PRIORITY_ID', 'asc')         
      ->get();
    return view('admin_repair.informrepairpriority',[      
            'inforepairpriorityT' =>  $inforepairpriority  
        ]);
  }       
  public function createrepairpriority(Request $request)
  {             
      return view('admin_repair.informrepairpriority_add');
  }    
  public function saverepairpriority(Request $request)
  {
    $addrepairpriority= new Informrepairpriority(); 

    $addrepairpriority->PRIORITY_NAME = $request->PRIORITY_NAME; 
          
    $addrepairpriority->save(); 
    return redirect()->route('setup.inforepairpriority'); 
  }    
  public function editrepairpriority(Request $request,$id)
  {   
    $informrepairpriority= Informrepairpriority::where('PRIORITY_ID','=',$id)
    ->first();
    return view('admin_repair.informrepairpriority_edit',[
      'informrepairpriorityT' => $informrepairpriority      
      ]);
  }    
  public function updaterepairpriority(Request $request)
  {
      $id = $request->PRIORITY_ID;  
      $updaterepairpriority= Informrepairpriority::find($id);
    
      $updaterepairpriority->PRIORITY_NAME = $request->PRIORITY_NAME;
    
      $updaterepairpriority->save();  
      return redirect()->route('setup.inforepairpriority');
  }    
  public function destroyrepairpriority($id) { 

    Informrepairpriority::destroy($id);             
      return redirect()->route('setup.inforepairpriority');   
  }
  //-----------------------------------------------------------------------//
  public function infoinformcomrepairtype()
  {
    $infoinformcomrepairtype= DB::table('informrepair_type')              
      ->orderby('COM_REPAIR_TYPE_ID', 'asc')         
      ->get();
    return view('admin_repair.informcomrepairtype',[      
            'infoinformcomrepairtypeT' =>  $infoinformcomrepairtype  
        ]);
  }       
  public function createinformcomrepairtype(Request $request)
  {             
      return view('admin_repair.informcomrepairtype_add');
  }    
  public function saveinformcomrepairtype(Request $request)
  {
    $addinformcomrepairtype= new Informcomrepairtype(); 
    $addinformcomrepairtype->COM_REPAIR_TYPE_NAME = $request->COM_REPAIR_TYPE_NAME; 
    $addinformcomrepairtype->COM_REPAIR_TYPE_DETAIL = $request->COM_REPAIR_TYPE_DETAIL;       
    $addinformcomrepairtype->save(); 
    return redirect()->route('setup.infoinformcomrepairtype'); 
  }    
  public function editinformcomrepairtype(Request $request,$id)
  {   
    $infoinformcomrepairtype= Informcomrepairtype::where('COM_REPAIR_TYPE_ID','=',$id)
    ->first();
    return view('admin_repair.informcomrepairtype_edit',[
      'infoinformcomrepairtypeT' => $infoinformcomrepairtype      
      ]);
  }    
  public function updateinformcomrepairtype(Request $request)
  {
      $id = $request->COM_REPAIR_TYPE_ID;  
      $updateinformcomrepairtype= Informcomrepairtype::find($id);
      $updateinformcomrepairtype->COM_REPAIR_TYPE_NAME = $request->COM_REPAIR_TYPE_NAME;
      $updateinformcomrepairtype->COM_REPAIR_TYPE_DETAIL = $request->COM_REPAIR_TYPE_DETAIL;
      $updateinformcomrepairtype->save();  
      return redirect()->route('setup.infoinformcomrepairtype');
  }    
  public function destroyinformcomrepairtype($id) { 

    Informcomrepairtype::destroy($id);             
      return redirect()->route('setup.infoinformcomrepairtype');   
}
//-----------------------------------------------------------------------//
public function infoassetpadoctool()
  {
    $infoassetpadoctool= DB::table('asset_pa_tools')
      ->leftjoin('informcom_brand','asset_pa_tools.BRAND_ID','=','informcom_brand.BRAND_ID')              
      ->orderby('TOOLS_ID', 'asc')         
      ->get();
    return view('admin_repair.assetpadoctool',[      
            'infoassetpadoctoolT' =>  $infoassetpadoctool  
        ]);
  }       
  public function createassetpadoctool(Request $request)
  {     
        $informcombrand  =  DB::table('informcom_brand')
        ->get();
      return view('admin_repair.assetpadoctool_add',[
        'informcombrandT' => $informcombrand 
      ]);
  }    
  public function saveassetpadoctool(Request $request)
  {
    $addassetpadoctool= new Assetpatools(); 
    $addassetpadoctool->TOOLS_NAME = $request->TOOLS_NAME; 
    $addassetpadoctool->BRAND_ID = $request->BRAND_ID;  
    $addassetpadoctool->MODEL = $request->MODEL;      
    $addassetpadoctool->save(); 
    return redirect()->route('setup.infoassetpadoctool'); 
  }    
  public function editassetpadoctool(Request $request,$id)
  { 
    $informcombrand  =  DB::table('informcom_brand')
    ->get();  
    $infoassetpadoctool= Assetpatools::where('TOOLS_ID','=',$id)
    ->first();
    return view('admin_repair.assetpadoctool_edit',[
      'infoassetpadoctoolT' => $infoassetpadoctool,
      'informcombrandT' => $informcombrand       
      ]);
  }    
  public function updateassetpadoctool(Request $request)
  {
      $id = $request->TOOLS_ID;  
      $updateassetpadoctool= Assetpatools::find($id);
      $updateassetpadoctool->TOOLS_NAME = $request->TOOLS_NAME;
      $updateassetpadoctool->BRAND_ID = $request->BRAND_ID;
      $updateassetpadoctool->MODEL = $request->MODEL;
      $updateassetpadoctool->save();  
      return redirect()->route('setup.infoassetpadoctool');
  }    
  public function destroyassetpadoctool($id) { 

    Assetpatools::destroy($id);             
      return redirect()->route('setup.infoassetpadoctool');   
  }
  //-----------------------------------------------------------------------//
  public function infoassetpaardoctype()
  {
    $infoassetpaardoctype= DB::table('asset_pa_type')              
      ->orderby('TEST_TYPE_ID', 'asc')         
      ->get();
    return view('admin_repair.assetpaardoctype',[      
            'infoassetpaardoctypeT' =>  $infoassetpaardoctype  
        ]);
  }       
  public function createassetpaardoctype(Request $request)
  {             
      return view('admin_repair.assetpaardoctype_add');
  }    
  public function saveassetpaardoctype(Request $request)
  {
    $addassetpaardoctype= new Assetpaardoctype(); 
    $addassetpaardoctype->TEST_TYPE_NAME = $request->TEST_TYPE_NAME; 
          
    $addassetpaardoctype->save(); 
    return redirect()->route('setup.infoassetpaardoctype'); 
  }    
  public function editassetpaardoctype(Request $request,$id)
  {   
    $infoassetpaardoctype= Assetpaardoctype::where('TEST_TYPE_ID','=',$id)
    ->first();
    return view('admin_repair.assetpaardoctype_edit',[
      'infoassetpaardoctypeT' => $infoassetpaardoctype      
      ]);
  }    
  public function updateassetpaardoctype(Request $request)
  {
      $id = $request->TEST_TYPE_ID;  
      $updateassetpaardoctype= Assetpaardoctype::find($id);  
      $updateassetpaardoctype->TEST_TYPE_NAME = $request->TEST_TYPE_NAME;
    
      $updateassetpaardoctype->save();  
      return redirect()->route('setup.infoassetpaardoctype');
  }    
  public function destroyassetpaardoctype($id) { 

    Assetpaardoctype::destroy($id);             
      return redirect()->route('setup.infoassetpaardoctype');   
}
//-----------------------------------------------------------------------//
public function infoassetpaardocmedical()
  {
    $infoassetpaardocmedical= DB::table('asset_pa_medical_mas')
      // ->leftjoin('informcom_brand','asset_pa_doctool.BRAND_ID','=','informcom_brand.BRAND_ID')              
      ->orderby('AR_TOOLS_ID', 'asc')         
      ->get();
    return view('admin_repair.assetpaardocmedical',[      
            'infoassetpaardocmedicalT' =>  $infoassetpaardocmedical  
        ]);
  }       
  public function createassetpaardocmedical(Request $request)
  {     
      
      return view('admin_repair.assetpaardocmedical_add');
      
  }    
  public function saveassetpaardocmedical(Request $request)
  {
    $addrdocmedical= new Assetpaardocmedical(); 
    $addrdocmedical->AR_TOOLS_NAME = $request->AR_TOOLS_NAME; 
    $addrdocmedical->RANGE_VALUE = $request->RANGE_VALUE;  
    $addrdocmedical->RANGE_ACCEPT = $request->RANGE_ACCEPT; 
    $addrdocmedical->UNIT_NAME = $request->UNIT_NAME;  

    $addrdocmedical->save(); 
    return redirect()->route('setup.infoassetpaardocmedical'); 
  }    
  public function editassetpaardocmedical(Request $request,$id)
  { 

    $infoassetpaardocmedical= Assetpaardocmedical::where('AR_TOOLS_ID','=',$id)
    ->first();
    return view('admin_repair.assetpaardocmedical_edit',[
      'infoassetpaardocmedicalT' => $infoassetpaardocmedical
          
      ]);
  }    
  public function updateassetpaardocmedical(Request $request)
  {
      $id = $request->AR_TOOLS_ID;  
      $updatrdocmedical= Assetpaardocmedical::find($id);
      $updatrdocmedical->AR_TOOLS_NAME = $request->AR_TOOLS_NAME;
      $updatrdocmedical->RANGE_VALUE = $request->RANGE_VALUE;
      $updatrdocmedical->RANGE_ACCEPT = $request->RANGE_ACCEPT;
      $updatrdocmedical->UNIT_NAME = $request->UNIT_NAME;
    
      $updatrdocmedical->save();  
      return redirect()->route('setup.infoassetpaardocmedical');
  }    
  public function destroyassetpaardocmedical($id) { 

    Assetpaardocmedical::destroy($id);             
      return redirect()->route('setup.infoassetpaardocmedical');   
}
//-----------------------------------------------------------------------//

public function infoassetpadoccalibration()
  {
    $infoassetpadoccalibration= DB::table('asset_pa_calibration')              
      ->orderby('CALIBRAT_ID', 'asc')         
      ->get();
    return view('admin_repair.assetpadoccalibration',[      
            'infoassetpadoccalibrationT' =>  $infoassetpadoccalibration  
        ]);
  }       
  public function createassetpadoccalibration(Request $request)
  {             
      return view('admin_repair.assetpadoccalibration_add');
  }    
  public function saveassetpadoccalibration(Request $request)
  {
    $adddoccalibration= new Assetpadoccalibration(); 
    $adddoccalibration->CALIBRAT_NAME = $request->CALIBRAT_NAME;
    $adddoccalibration->CALIBRAT_ADDR = $request->CALIBRAT_ADDR;
    $adddoccalibration->CONTACT_NAME = $request->CONTACT_NAME;
    $adddoccalibration->PHONE = $request->PHONE;
          
    $adddoccalibration->save(); 
    return redirect()->route('setup.infoassetpadoccalibration'); 
  }    
  public function editassetpadoccalibration(Request $request,$id)
  {   
    $infoassetpadoccalibration= Assetpadoccalibration::where('CALIBRAT_ID','=',$id)
    ->first();
    return view('admin_repair.assetpadoccalibration_edit',[
      'infoassetpadoccalibrationT' => $infoassetpadoccalibration      
      ]);
  }    
  public function updateassetpadoccalibration(Request $request)
  {
      $id = $request->CALIBRAT_ID;  
      $updatedoccalibration= Assetpadoccalibration::find($id);
      $updatedoccalibration->CALIBRAT_NAME = $request->CALIBRAT_NAME;
      $updatedoccalibration->CALIBRAT_ADDR = $request->CALIBRAT_ADDR;
      $updatedoccalibration->CONTACT_NAME = $request->CONTACT_NAME;
      $updatedoccalibration->PHONE = $request->PHONE;
      
      $updatedoccalibration->save();  
      return redirect()->route('setup.infoassetpadoccalibration');
  }    
  public function destroyassetpadoccalibration($id) { 

    Assetpadoccalibration::destroy($id);             
      return redirect()->route('setup.infoassetpadoccalibration');   
  }
  //----------------------------------------------------------------//

  public function infoassetpadoccheck()
  {
    $infoassetpadoccheck= DB::table('asset_pa_doccheck')              
      ->orderby('DOCCHECK_ID', 'asc')         
      ->get();
    return view('admin_repair.assetpadoccheck',[      
            'infoassetpadoccheckT' =>  $infoassetpadoccheck  
        ]);
  }       
  public function createassetpadoccheck(Request $request)
  {             
      return view('admin_repair.assetpadoccheck_add');
  }    
  public function saveassetpadoccheck(Request $request)
  {
    $addassetpadoccheck= new Assetpadoccheck();
    $addassetpadoccheck->DOCCHECK_NAME = $request->DOCCHECK_NAME;         
    $addassetpadoccheck->save(); 

    return redirect()->route('setup.infoassetpadoccheck'); 
  }    
  public function editassetpadoccheck(Request $request,$id)
  {   
    $doccheck= Assetpadoccheck::where('DOCCHECK_ID','=',$id)
    ->first();
    return view('admin_repair.assetpadoccheck_edit',[
      'doccheckT' => $doccheck      
      ]);
  }    
  public function updateassetpadoccheck(Request $request)
  {
      $id = $request->DOCCHECK_ID;  
      $updateassetpadoccheck= Assetpadoccheck::find($id);  
      $updateassetpadoccheck->DOCCHECK_NAME = $request->DOCCHECK_NAME;   
      $updateassetpadoccheck->save();  

      return redirect()->route('setup.infoassetpadoccheck');
  }    
  public function destroyassetpadoccheck($id) { 

    Assetpadoccheck::destroy($id);             
      return redirect()->route('setup.infoassetpadoccheck');   
}
//-----------------------------------------------------------------------//
public function infoassetpaardocleader()
  {
    
    $infoassetpaardocleader= DB::table('asset_pa_leader')
    ->leftjoin('hrd_person','asset_pa_leader.HR_ID','=','hrd_person.ID')
    //  ->leftjoin('hrd_person','asset_pa_ardoc_leader.HR_ID','=','hrd_person.ID')              
      ->orderby('DOCLEADER_ID', 'asc')         
      ->get();
    return view('admin_repair.assetpaardocleader',[      
            'infoassetpaardocleaderT' =>  $infoassetpaardocleader        
        ]);
  }
  public function createassetpaardocleader(Request $request)
  {       
      $personuser = DB::table('hrd_person')
      ->get();
      $position = DB::table('hrd_position')    
      ->get();      
      return view('admin_repair.assetpaardocleader_add',[
          'personuserT' => $personuser,
          'positionT' => $position
      ]);
  }
  public function saveassetpaardocleader(Request $request)
  {
    $addassetpaardocleader= new Assetpaardocleader(); 
    $addassetpaardocleader->HR_ID = $request->HR_ID;
    $addassetpaardocleader->HR_POSITION = $request->HR_POSITION;
    $addassetpaardocleader->save(); 
    return redirect()->route('setup.infoassetpaardocleader'); 
  }
  public function editassetpaardocleader(Request $request,$id)
  {   
      $personuser = DB::table('hrd_person')
      ->get();
      $position = DB::table('hrd_position')    
      ->get();
      $infoassetpaardocleader= Assetpaardocleader::where('DOCLEADER_ID','=',$id)
    ->first();

  //    $infoinformcomengineer= DB::table('hrd_person')
  //    ->leftjoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
  //    ->first();

    return view('admin_repair.assetpaardocleader_edit',[
      'infoassetpaardocleaderT' => $infoassetpaardocleader,
      'personuserT' => $personuser,
      'positionT' => $position      
      ]);
  }
  public function updateassetpaardocleader(Request $request)
  {
      $id = $request->DOCLEADER_ID;  
      $updateassetpaardocleader= Assetpaardocleader::find($id);
      $updateassetpaardocleader->HR_ID = $request->HR_ID;
      $updateassetpaardocleader->HR_POSITION = $request->HR_POSITION;
      $updateassetpaardocleader->save();  
      return redirect()->route('setup.infoassetpaardocleader');
  }
  public function destroyassetpaardocleader($id) { 

    Assetpaardocleader::destroy($id);             
      return redirect()->route('setup.infoassetpaardocleader');   
}

//--------------------------------------------------------------------//
public function infoinformrepairtech()
  {
    // $infoperson = DB::table('hrd_person')
    // ->get(); 
    $informrepairtech= DB::table('informrepair_tech')
    ->leftjoin('hrd_person','informrepair_tech.PERSON_ID','=','hrd_person.ID')             
      ->orderby('REPAIRTECH_ID', 'asc')         
      ->get();
    return view('admin_repair.informrepairtech',[      
            'informrepairtechT' =>  $informrepairtech  
        ]);
  }
  public function createinformrepairtech(Request $request)
  {       
    $infoperson = DB::table('hrd_person')
    ->get();   
      return view('admin_repair.informrepairtech_add',[
          'infopersonT' => $infoperson
      ]);
  }
  public function saveinformrepairtech(Request $request)
  {
    $addinformrepairtech= new Informrepairtech(); 
    $addinformrepairtech->PERSON_ID = $request->PERSON_ID;
    $infoperson = DB::table('hrd_person')->leftjoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->where('ID','=',$request->PERSON_ID)->first();
    
    $addinformrepairtech->TECH_POSITION = $infoperson->POSITION_IN_WORK;
    $addinformrepairtech->ACTIVE = $request->ACTIVE;
    $addinformrepairtech->save(); 

    return redirect()->route('setup.infoinformrepairtech'); 
  }
  public function editinformrepairtech(Request $request,$id)
  {   
    $infoper = DB::table('hrd_person')
    ->leftjoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
      ->get();
    
      $infoinformrepairtech= Informrepairtech::where('REPAIRTECH_ID','=',$id)
    ->first();

    return view('admin_repair.informrepairtech_edit',[
      'infoinformrepairtechT' => $infoinformrepairtech,
      'infoperT' => $infoper    
      ]);
  }
  public function updateinformrepairtech(Request $request)
  {
      $id = $request->REPAIRTECH_ID;  
      $updateinformrepairtech= Informrepairtech::find($id);
      // $updateassetparepairtech->PERSON_ID = $request->PERSON_ID;  
      $infoperson = DB::table('hrd_person')
    ->where('ID','=',$request->PERSON_ID)->first();
    $updateinformrepairtech->PERSON_ID = $infoperson->ID;
    $updateinformrepairtech->TECH_POSITION = $infoperson->POSITION_IN_WORK;
      $updateinformrepairtech->ACTIVE = $request->ACTIVE;        
      $updateinformrepairtech->save();  
      return redirect()->route('setup.infoinformrepairtech');
  }
  public function destroyinformrepairtech($id) { 

    Informrepairtech::destroy($id);             
      return redirect()->route('setup.infoinformrepairtech');   
  }
  function switchactiveinformrepairtech(Request $request)
  {  
      $id = $request->informrepairtech;
      $budgetactive = Informrepairtech::find($id);
      $budgetactive->ACTIVE = $request->onoff;
      $budgetactive->save();
}
//--------------------------------------------------------------------//
public function infoinformcomrepairlist()
  {
    $inforlist= DB::table('informcom_repair_list')           
      ->orderby('REPAIR_LIST_ID', 'asc')         
      ->get();
    return view('admin_repair.informcomrepairlist',[      
            'inforlistT' =>  $inforlist  
        ]);
  }
  public function createinformcomrepairlist(Request $request)
  {          
      return view('admin_repair.informcomrepairlist_add');
  }
  public function saveinformcomrepairlist(Request $request)
  {
    $addrepairlist= new Informcomrepairlist(); 
    $addrepairlist->REPAIR_LIST_NAME = $request->REPAIR_LIST_NAME;
    $addrepairlist->REPAIR_LIST_PRICE = $request->REPAIR_LIST_PRICE;
    $addrepairlist->save(); 
    return redirect()->route('setup.infoinformcomrepairlist'); 
  }
  public function editinformcomrepairlist(Request $request,$id)
  {   
      $repairlist= Informcomrepairlist::where('REPAIR_LIST_ID','=',$id)
      ->first();
    return view('admin_repair.informcomrepairlist_edit',[
      'repairlistT' => $repairlist,
        
      ]);
  }
  public function updateinformcomrepairlist(Request $request)
  {
      $id = $request->REPAIR_LIST_ID;  
      $updaterepairlist= Informcomrepairlist::find($id);      
      $updaterepairlist->REPAIR_LIST_NAME = $request->REPAIR_LIST_NAME;
      $updaterepairlist->REPAIR_LIST_PRICE = $request->REPAIR_LIST_PRICE;        
      $updaterepairlist->save();  
      return redirect()->route('setup.infoinformcomrepairlist');
  }
  public function destroyinformcomrepairlist($id) { 

    Informcomrepairlist::destroy($id);             
      return redirect()->route('setup.infoinformcomrepairlist');   
}
//--------------------------------------------------------------------//
public function infoassetcareenginer()
  {

    $assetcareenginer= DB::table('asset_care_enginer')
    ->leftjoin('hrd_person','asset_care_enginer.PERSON_ID','=','hrd_person.ID')             
      ->orderby('ENGINERCARE_ID', 'asc')         
      ->get();
    return view('admin_repair.assetcareenginer',[      
            'assetcareenginerT' =>  $assetcareenginer  
        ]);
  }
  public function createassetcareenginer(Request $request)
  {       
    $infoperson = DB::table('hrd_person')
    ->get();   
      return view('admin_repair.assetcareenginer_add',[
          'infopersonT' => $infoperson
      ]);
  }
  public function saveassetcareenginer(Request $request)
  {
    $addassetcareenginer= new Assetcareenginer(); 
    $addassetcareenginer->PERSON_ID = $request->PERSON_ID;
    $infoperson = DB::table('hrd_person')->leftjoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->where('ID','=',$request->PERSON_ID)->first();
    $addassetcareenginer->ENGINEER_NAME = $infoperson->HR_FNAME." ".$infoperson->HR_LNAME;
    $addassetcareenginer->POSITION = $infoperson->POSITION_IN_WORK;
    $addassetcareenginer->ACTIVE = $request->ACTIVE;
    $addassetcareenginer->save(); 

    return redirect()->route('setup.infoassetcareenginer'); 
  }
  public function editassetcareenginer(Request $request,$id)
  {   
    $infoper = DB::table('hrd_person')
    ->leftjoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
      ->get();
    
      $infoassetcareenginer= Assetcareenginer::where('ENGINERCARE_ID','=',$id)
    ->first();

    return view('admin_repair.assetcareenginer_edit',[
      'infoassetcareenginerT' => $infoassetcareenginer,
      'infoperT' => $infoper    
      ]);
  }
  public function updateassetcareenginer(Request $request)
  {
      $id = $request->ENGINERCARE_ID;  
      $updateassetcareenginer= Assetcareenginer::find($id); 
      $infoperson = DB::table('hrd_person')
    ->where('ID','=',$request->PERSON_ID)->first();
    $updateassetcareenginer->PERSON_ID = $infoperson->ID;
    $updateassetcareenginer->ENGINEER_NAME =$infoperson->HR_FNAME." ".$infoperson->HR_LNAME;
    $updateassetcareenginer->POSITION = $infoperson->POSITION_IN_WORK;
      $updateassetcareenginer->ACTIVE = $request->ACTIVE;        
      $updateassetcareenginer->save();  
      return redirect()->route('setup.infoassetcareenginer');
  }
  public function destroyassetcareenginer($id) { 

    Assetcareenginer::destroy($id);             
      return redirect()->route('setup.infoassetcareenginer');   
  }
  function switchactiveassetcareenginer(Request $request)
  {  
      $id = $request->assetcareenginer;
      $budgetactive = Assetcareenginer::find($id);
      $budgetactive->ACTIVE = $request->onoff;
      $budgetactive->save();
}


//================================================================

public function setupinforepairPDF()
{

    $inforepairfunction = DB::table('infomrepair_function')->get();

    return view('admin_repair.setuprepairfunction',[
        'inforepairfunctions' =>$inforepairfunction 
    ]);
}



function setupinforepairPDFswitch(Request $request)
{  
   
    $id = $request->idfunc;
    $active = Informrepairfunction::find($id);
    $active->ACTIVE = $request->onoff;
    $active->save();
}

//====ตั้งค่าการกำหนดฟังชันการ

public function setupfunction()
    {

       $infofunction = DB::table('informrepair_setupfunc')->get();
      return view('admin_repair.setupfunction',
     [
       'infofunctions' => $infofunction 
     ]);
    }  

    function switchactiverepair(Request $request)
    {  
     
        $id = $request->idfunc;
        $active = Informrepairsetupfunc::find($id);
        $active->ACTIVE = $request->onoff;
        $active->save();
    }
    



public function setupfunctioncom()
    {
      $infofunctioncom = DB::table('informcom_setupfunc')->get();
      return view('admin_repair.setupfunctioncom',[
          'infofunctioncoms'=> $infofunctioncom 
      ]);
    }  


    function switchactiverepaircom(Request $request)
    {  
     
        $id = $request->idfunc;
        $active = Informcomsetupfunc::find($id);
        $active->ACTIVE = $request->onoff;
        $active->save();
    }


public function setupfuntionmedical()
    {
      $infofunctioncare = DB::table('asset_care_setupfunc')->get();
      return view('admin_repair.setupfuntionmedical',[
        'infofunctioncares' => $infofunctioncare 
      ]);
    }  

    function switchactiverepairmedical(Request $request)
    {  
     
        $id = $request->idfunc;
        $active = Assetcaresetupfunc::find($id);
        $active->ACTIVE = $request->onoff;
        $active->save();
    }

}
