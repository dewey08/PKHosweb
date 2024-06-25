<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Person;
use App\Models\Cartype;
use App\Models\Carstatus;
use App\Models\Carstyle;
use App\Models\Carbrand;
use App\Models\Carmachinbrand;
use App\Models\Carpower;
use App\Models\Caraccessory;
use App\Models\Cardriver;
use App\Models\Carappointlocate;


class SetupcarController extends Controller
{



     public function infocartype()
    {
   
    $infocartype = Cartype::orderBy('CAR_TYPE_ID', 'asc')  
                                            ->get();                     
      
   //dd($inforoom);
    return view('admin_car.setupinfocartype',[
        'infocartypes' => $infocartype
    ]);
    }   

    public function createcartype(Request $request)
    {
  
        return view('admin_car.setupinfocartype_add');

    }

    public function savecartype(Request $request)
    {
        //return $request->all();

            $addcartype = new Cartype(); 
            $addcartype->CAR_TYPE_NAME = $request->CAR_TYPE_NAME;
         
            $addcartype->save();


            return redirect()->route('setup.infocartype'); 
    }

    public function editcartype(Request $request,$id)
    {
       // return $request->all();
    
       $id_in= $id;
     
       $infocartype = Cartype::where('CAR_TYPE_ID','=',$id_in)
       ->first();


        //dd($inforbudget);
        return view('admin_car.setupinfocartype_edit',[
        'infocartype' => $infocartype 
        ]);

    }



    public function updatecartype(Request $request)
    {
        $id = $request->CAR_TYPE_ID; 

        $updatecartype = Cartype::find($id);
        $updatecartype->CAR_TYPE_NAME = $request->CAR_TYPE_NAME;
    
           
           //dd($addbudgetyear);
 
        $updatecartype->save();


        return redirect()->route('setup.infocartype'); 

    }

    
    public function destroycartype($id) { 

        Cartype::destroy($id);         
        //return redirect()->action('ChangenameController@infouserchangename');  
        return redirect()->route('setup.infocartype');   
    }


    //===========================สถานะรถ==============================

    
    public function infocarstatus()
    {
   
    $infocarstatus = Carstatus::orderBy('CAR_STATUS_ID', 'asc')  
                                            ->get();                     
      
   //dd($inforoom);
    return view('admin_car.setupinfocarstatus',[
        'infocarstatuss' => $infocarstatus
    ]);
    }   

    public function createcarstatus(Request $request)
    {
  
        return view('admin_car.setupinfocarstatus_add');

    }

    public function savecarstatus(Request $request)
    {
        //return $request->all();

            $addcarstatus = new Carstatus(); 
            $addcarstatus->CAR_STATUS_NAME = $request->CAR_STATUS_NAME;
         
            $addcarstatus->save();


            return redirect()->route('setup.infocarstatus'); 
    }

    public function editcarstatus(Request $request,$id)
    {
       // return $request->all();
    
       $id_in= $id;
     
       $infocarstatus = Carstatus::where('CAR_STATUS_ID','=',$id_in)
       ->first();


        //dd($inforbudget);
        return view('admin_car.setupinfocarstatus_edit',[
        'infocarstatus' => $infocarstatus 
        ]);

    }



    public function updatecarstatus(Request $request)
    {
        $id = $request->CAR_STATUS_ID; 

        $updatecarstatus = Carstatus::find($id);
        $updatecarstatus->CAR_STATUS_NAME = $request->CAR_STATUS_NAME;
    
           
           //dd($addbudgetyear);
 
        $updatecarstatus->save();


        return redirect()->route('setup.infocarstatus'); 

    }

    
    public function destroycarstatus($id) { 

        Carstatus::destroy($id);         
        //return redirect()->action('ChangenameController@infouserchangename');  
        return redirect()->route('setup.infocarstatus');   
    }


    
    //===========================ลักษณะรถ==============================

    
    public function infocarstyle()
    {
   
    $infocarstyle = Carstyle::orderBy('CAR_STYLE_ID', 'asc')  
                                            ->get();                     
      
   //dd($inforoom);
    return view('admin_car.setupinfocarstyle',[
        'infocarstyles' => $infocarstyle
    ]);
    }   

    public function createcarstyle(Request $request)
    {
  
        return view('admin_car.setupinfocarstyle_add');

    }

    public function savecarstyle(Request $request)
    {
        //return $request->all();

            $addcarstyle = new Carstyle(); 
            $addcarstyle->CAR_STYLE_NAME = $request->CAR_STYLE_NAME;
         
            $addcarstyle->save();


            return redirect()->route('setup.infocarstyle'); 
    }

    public function editcarstyle(Request $request,$id)
    {
       // return $request->all();
    
       $id_in= $id;
     
       $infocarstyle = Carstyle::where('CAR_STYLE_ID','=',$id_in)
       ->first();


        //dd($inforbudget);
        return view('admin_car.setupinfocarstyle_edit',[
        'infocarstyle' => $infocarstyle 
        ]);

    }



    public function updatecarstyle(Request $request)
    {
        $id = $request->CAR_STYLE_ID; 

        $updatecarstyle = Carstyle::find($id);
        $updatecarstyle->CAR_STYLE_NAME = $request->CAR_STYLE_NAME;
    
           
           //dd($addbudgetyear);
 
        $updatecarstyle->save();


        return redirect()->route('setup.infocarstyle'); 

    }

    
    public function destroycarstyle($id) { 

        Carstyle::destroy($id);         
        //return redirect()->action('ChangenameController@infouserchangename');  
        return redirect()->route('setup.infocarstyle');   
    }


    
    //===========================ยี่ห้อรถ==============================

    
    public function infocarbrand()
    {
   
    $infocarbrand = Carbrand::orderBy('CAR_BRAND_ID', 'asc')  
                                            ->get();                     
      
   //dd($inforoom);
    return view('admin_car.setupinfocarbrand',[
        'infocarbrands' => $infocarbrand
    ]);
    }   

    public function createcarbrand(Request $request)
    {
  
        return view('admin_car.setupinfocarbrand_add');

    }

    public function savecarbrand(Request $request)
    {
        //return $request->all();

            $addcarbrand = new Carbrand(); 
            $addcarbrand->CAR_BRAND_NAME = $request->CAR_BRAND_NAME;
         
            $addcarbrand->save();


            return redirect()->route('setup.infocarbrand'); 
    }

    public function editcarbrand(Request $request,$id)
    {
       // return $request->all();
    
       $id_in= $id;
     
       $infocarbrand = Carbrand::where('CAR_BRAND_ID','=',$id_in)
       ->first();


        //dd($inforbudget);
        return view('admin_car.setupinfocarbrand_edit',[
        'infocarbrand' => $infocarbrand 
        ]);

    }



    public function updatecarbrand(Request $request)
    {
        $id = $request->CAR_BRAND_ID; 

        $updatecarbrand = Carbrand::find($id);
        $updatecarbrand->CAR_BRAND_NAME = $request->CAR_BRAND_NAME;
    
           
           //dd($addbudgetyear);
 
        $updatecarbrand->save();


        return redirect()->route('setup.infocarbrand'); 

    }

    
    public function destroycarbrand($id) { 

        Carbrand::destroy($id);         
        //return redirect()->action('ChangenameController@infouserchangename');  
        return redirect()->route('setup.infocarbrand');   
    }


    
    //===========================ยี่ห้อเครื่องยนต์==============================

    
    public function infocarmachinbrand()
    {
   
    $infocarmachinbrand = Carmachinbrand::orderBy('CAR_MACHIN_BRAND_ID', 'asc')  
                                            ->get();                     
      
   //dd($inforoom);
    return view('admin_car.setupinfocarmachinbrand',[
        'infocarmachinbrands' => $infocarmachinbrand
    ]);
    }   

    public function createcarmachinbrand(Request $request)
    {
  
        return view('admin_car.setupinfocarmachinbrand_add');

    }

    public function savecarmachinbrand(Request $request)
    {
        //return $request->all();

            $addcarmachinbrand = new Carmachinbrand(); 
            $addcarmachinbrand->CAR_MACHIN_BRAND_NAME = $request->CAR_MACHIN_BRAND_NAME;
         
            $addcarmachinbrand->save();


            return redirect()->route('setup.infocarmachinbrand'); 
    }

    public function editcarmachinbrand(Request $request,$id)
    {
       // return $request->all();
    
       $id_in= $id;
     
       $infocarmachinbrand = Carmachinbrand::where('CAR_MACHIN_BRAND_ID','=',$id_in)
       ->first();


        //dd($inforbudget);
        return view('admin_car.setupinfocarmachinbrand_edit',[
        'infocarmachinbrand' => $infocarmachinbrand 
        ]);

    }



    public function updatecarmachinbrand(Request $request)
    {
        $id = $request->CAR_MACHIN_BRAND_ID; 

        $updatecarbrand = Carmachinbrand::find($id);
        $updatecarbrand->CAR_MACHIN_BRAND_NAME = $request->CAR_MACHIN_BRAND_NAME;
    
           
           //dd($addbudgetyear);
 
        $updatecarbrand->save();


        return redirect()->route('setup.infocarmachinbrand'); 

    }

    
    public function destroycarmachinbrand($id) { 

        Carmachinbrand::destroy($id);         
        //return redirect()->action('ChangenameController@infouserchangename');  
        return redirect()->route('setup.infocarmachinbrand');   
    }


    //===========================เชื้อเพลิง==============================

    
    public function infocarpower()
    {
   
    $infocarpower = Carpower::orderBy('CAR_POWER_ID', 'asc')  
                                            ->get();                     
      
   //dd($infocarpower);
    return view('admin_car.setupinfocarpower',[
        'infocarpowers' => $infocarpower
    ]);
    }   

    public function createcarpower(Request $request)
    {
  
        return view('admin_car.setupinfocarpower_add');

    }

    public function savecarpower(Request $request)
    {
        //return $request->all();

            $addcarpower = new Carpower(); 
            $addcarpower->CAR_POWER_ID_NAME = $request->CAR_POWER_ID_NAME;
            $addcarpower->CAR_POWER_NAME = $request->CAR_POWER_NAME;
         
            $addcarpower->save();


            return redirect()->route('setup.infocarpower'); 
    }

    public function editcarpower(Request $request,$id)
    {
       // return $request->all();
    
       $id_in= $id;
     
       $infocarpower = Carpower::where('CAR_POWER_ID','=',$id_in)
       ->first();


        //dd($inforbudget);
        return view('admin_car.setupinfocarpower_edit',[
        'infocarpower' => $infocarpower 
        ]);

    }



    public function updatecarpower(Request $request)
    {
        $id = $request->CAR_POWER_ID; 

        $updatecarpower = Carpower::find($id);
        $updatecarpower->CAR_POWER_ID_NAME = $request->CAR_POWER_ID_NAME;
        $updatecarpower->CAR_POWER_NAME = $request->CAR_POWER_NAME;
    
           
           //dd($addbudgetyear);
 
        $updatecarpower->save();


        return redirect()->route('setup.infocarpower'); 

    }

    
    public function destroycarpower($id) { 

        Carpower::destroy($id);         
        //return redirect()->action('ChangenameController@infouserchangename');  
        return redirect()->route('setup.infocarpower');   
    }


        //===========================อุปกรณ์เสริมถายใน==============================

    
        public function infocaraccessory()
        {
       
        $infocaraccessory = Caraccessory::orderBy('ACCESSORY_ID', 'asc')  
                                                ->get();                     
          
       //dd($inforoom);
        return view('admin_car.setupinfocaraccessory',[
            'infocaraccessorys' => $infocaraccessory
        ]);
        }   
    
        public function createcaraccessory(Request $request)
        {
      
            return view('admin_car.setupinfocaraccessory_add');
    
        }
    
        public function savecaraccessory(Request $request)
        {
            //return $request->all();
    
                $addcaraccessory = new Caraccessory(); 
                $addcaraccessory->ACCESSORY_NAME = $request->ACCESSORY_NAME;
             
                $addcaraccessory->save();
    
    
                return redirect()->route('setup.infocaraccessory'); 
        }
    
        public function editcaraccessory(Request $request,$id)
        {
           // return $request->all();
        
           $id_in= $id;
         
           $infocaraccessory = Caraccessory::where('ACCESSORY_ID','=',$id_in)
           ->first();
    
    
            //dd($inforbudget);
            return view('admin_car.setupinfocaraccessory_edit',[
            'infocaraccessory' => $infocaraccessory 
            ]);
    
        }
    
    
    
        public function updatecaraccessory(Request $request)
        {
            $id = $request->ACCESSORY_ID; 
    
            $updatecaraccessory= Caraccessory::find($id);
            $updatecaraccessory->ACCESSORY_NAME = $request->ACCESSORY_NAME;
        
               
               //dd($addbudgetyear);
     
            $updatecaraccessory->save();
    
    
            return redirect()->route('setup.infocaraccessory'); 
    
        }
    
        
        public function destroycaraccessory($id) { 
    
            Caraccessory::destroy($id);         
            //return redirect()->action('ChangenameController@infouserchangename');  
            return redirect()->route('setup.infocaraccessory');   
        }





          //===========================พนักงานขับรถ==============================

    
          public function infocardriver()
          {
         
          $infocardriver = Cardriver::leftJoin('hrd_person','vehicle_car_driver.PERSON_ID','=','hrd_person.ID')
          ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
          ->orderBy('DRIVER_ID', 'asc')  
          ->get();                     
            
         //dd($inforoom);
          return view('admin_car.setupinfocardriver',[
              'infocardrivers' => $infocardriver
          ]);
          }   
      
          public function createcardriver(Request $request)
          {

            $PERSONALL = DB::table('hrd_person')
            ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
            ->get();
        
              return view('admin_car.setupinfocardriver_add',[
                'PERSONALLs' => $PERSONALL
              ]);
      
          }
      
          public function savecardriver(Request $request)
          {
              //return $request->all();
      
                  $addcardriver = new Cardriver(); 
                  $addcardriver->PERSON_ID = $request->PERSON_ID;

                  $DRIVER_POSITION = DB::table('hrd_person')
                  ->where('ID','=',$request->PERSON_ID)
                  ->first();

                  $addcardriver->DRIVER_POSITION = $DRIVER_POSITION->POSITION_IN_WORK;
                  $addcardriver->ACTIVE = 'False';
               
                  $addcardriver->save();
      
      
                  return redirect()->route('setup.infocardriver'); 
          }
      
          public function editcardriver(Request $request,$id)
          {
             // return $request->all();
          
             $id_in= $id;
           
             $infocardriver = Cardriver::where('DRIVER_ID','=',$id_in)
             ->first();

             $PERSONALL = DB::table('hrd_person')
             ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
             ->get();
      
      
              //dd($inforbudget);
              return view('admin_car.setupinfocardriver_edit',[
              'infocardriver' => $infocardriver,
              'PERSONALLs' => $PERSONALL 
              ]);
      
          }
      
      
      
          public function updatecardriver(Request $request)
          {
              $id = $request->DRIVER_ID; 
      
              $updatecardriver= Cardriver::find($id);
              $updatecardriver->PERSON_ID = $request->PERSON_ID;

              $DRIVER_POSITION = DB::table('hrd_person')
              ->where('ID','=',$request->PERSON_ID)
              ->first();

              $updatecardriver->DRIVER_POSITION = $DRIVER_POSITION->POSITION_IN_WORK;
          
                 
                 //dd($addbudgetyear);
       
              $updatecardriver->save();
      
      
              return redirect()->route('setup.infocardriver'); 
      
          }
      
          
          public function destroycardriver($id) { 
      
            Cardriver::destroy($id);         
              //return redirect()->action('ChangenameController@infouserchangename');  
              return redirect()->route('setup.infocardriver');   
          }
  
  


          function switchactive(Request $request)
          {  
              //return $request->all(); 
              $id = $request->driver;
              $bookorginactive = Cardriver::find($id);
              $bookorginactive->ACTIVE = $request->onoff;
              $bookorginactive->save();
          }


           //===========================สถานที่นัดหมาย==============================

    
        public function infoappointlocate()
        {
       
        $infoappointlocate = Carappointlocate::orderBy('APPOINT_LOCATE_ID', 'asc')  
                                                ->get();                     
          
       //dd($inforoom);
        return view('admin_car.setupinfoappointlocate',[
            'infoappointlocates' => $infoappointlocate
        ]);
        }   
    
        public function createappointlocate(Request $request)
        {
      
            return view('admin_car.setupinfoappointlocate_add');
    
        }
    
        public function saveappointlocate(Request $request)
        {
            //return $request->all();
    
                $addappointlocate= new Carappointlocate(); 
                $addappointlocate->APPOINT_LOCATE_NAME = $request->APPOINT_LOCATE_NAME;
             
                $addappointlocate->save();
    
    
                return redirect()->route('setup.infoappointlocate'); 
        }
    
        public function editappointlocate(Request $request,$id)
        {
           // return $request->all();
        
         
           $infoappointlocate = Carappointlocate::where('APPOINT_LOCATE_ID','=',$id)
           ->first();
    
    
            //dd($inforbudget);
            return view('admin_car.setupinfoappointlocate_edit',[
            'infoappointlocate' => $infoappointlocate 
            ]);
    
        }
    
    
    
        public function updateappointlocate(Request $request)
        {
            $id = $request->APPOINT_LOCATE_ID; 
    
            $updateappointlocate= Carappointlocate::find($id);
            $updateappointlocate->APPOINT_LOCATE_NAME = $request->APPOINT_LOCATE_NAME;
        
               
               //dd($addbudgetyear);
     
            $updateappointlocate->save();
    
    
            return redirect()->route('setup.infoappointlocate'); 
    
        }
    
        
        public function destroyappointlocate($id) { 
    
            Carappointlocate::destroy($id);         
            //return redirect()->action('ChangenameController@infouserchangename');  
            return redirect()->route('setup.infoappointlocate');   
        }





}
