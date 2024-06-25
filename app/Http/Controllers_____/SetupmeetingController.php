<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Person;
use App\Models\Meetingroomindex;
use App\Models\Meetingroomfood;
use App\Models\Meetingroomfoodtype;
use App\Models\Meetingroomarticle;
use App\Models\Meetingroomtime;
use App\Models\Meetingroomequipment;

class SetupmeetingController extends Controller
{
    public function inforoom()
    {
       
        $inforoom = Meetingroomindex::leftJoin('hrd_person','meetingroom_index.ROOM_PERSON_ID','=','hrd_person.ID')
            ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
            ->orderBy('ROOM_ID', 'asc')  
                                     ->get();
                                     
          
       //dd($inforoom);
        return view('admin_meeting.setupinforoom',[
            'inforooms' => $inforoom
        ]);
    }


    function switchactive(Request $request)
    {  
        //return $request->all(); 
        $id = $request->room;
        $budgetactive = Meetingroomindex::find($id);
        $budgetactive->ROOM_STATUS_ID = $request->onoff;
        $budgetactive->save();
    }

    public function create(Request $request)
    {
       //dd($infoeducation);
               
       $inforperson=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
       ->get();

        return view('admin_meeting.setupinforoom_add',[
            'inforpersons' => $inforperson
        ]);

    }

    public function save(Request $request)
    {
        //return $request->all();

            $addroom = new Meetingroomindex(); 
            $addroom->ROOM_NAME = $request->ROOM_NAME;
            $addroom->CONTAIN = $request->CONTAIN;
            $addroom->ROOM_PERSON_ID = $request->ROOM_PERSON_ID;
            $addroom->ROOM_STATUS_ID = $request->ROOM_STATUS_ID;
            $addroom->ROOM_LOCATION = $request->ROOM_LOCATION;
            $addroom->ROOM_DETAIL = $request->ROOM_DETAIL;
            $addroom->GET_BEFORE = $request->GET_BEFORE;
            $addroom->ROOM_COLOR = $request->ROOM_COLOR;
           //dd($addbudgetyear);

           if($request->hasFile('picture1')){
            //$newFileName = $picid.'.'.$request->picture->extension();
            
            $file = $request->file('picture1');  
            $contents = $file->openFile()->fread($file->getSize());
            $addroom->IMG1 = $contents;   
            //$request->picture->storeAs('images',$newFileName,'public');
            //$inforpersonedit->HR_IMAGE_NAME = $newFileName; 
        }

        if($request->hasFile('picture2')){
            //$newFileName = $picid.'.'.$request->picture->extension();
            
            $file = $request->file('picture2');  
            $contents = $file->openFile()->fread($file->getSize());
            $addroom->IMG2 = $contents;   
            //$request->picture->storeAs('images',$newFileName,'public');
            //$inforpersonedit->HR_IMAGE_NAME = $newFileName; 
        }
 
            $addroom->save();


            return redirect()->route('setup.indexroom'); 
    }


    public function edit(Request $request,$id)
    {
       // return $request->all();
    
       $id_in= $id;
     
       $inforoom = Meetingroomindex::where('ROOM_ID','=',$id_in)
       ->first();

       $inforperson=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
       ->get();


        //dd($inforbudget);
        return view('admin_meeting.setupinforoom_edit',[
        'inforpersons' => $inforperson,
        'inforoom' => $inforoom 
        ]);

    }



    public function update(Request $request)
    {
        $id = $request->ROOM_ID; 

        $updateroom = Meetingroomindex::find($id);
        $updateroom->ROOM_NAME = $request->ROOM_NAME;
        $updateroom->CONTAIN = $request->CONTAIN;
        $updateroom->ROOM_PERSON_ID = $request->ROOM_PERSON_ID;
        $updateroom->ROOM_LOCATION = $request->ROOM_LOCATION;
        $updateroom->ROOM_DETAIL = $request->ROOM_DETAIL;
        $updateroom->GET_BEFORE = $request->GET_BEFORE;
        $updateroom->ROOM_COLOR = $request->ROOM_COLOR;
       //dd($addbudgetyear);

       if($request->hasFile('picture1')){
        //$newFileName = $picid.'.'.$request->picture->extension();
        
        $file = $request->file('picture1');  
        $contents = $file->openFile()->fread($file->getSize());
        $updateroom->IMG1 = $contents;   
        //$request->picture->storeAs('images',$newFileName,'public');
        //$inforpersonedit->HR_IMAGE_NAME = $newFileName; 
    }

    if($request->hasFile('picture2')){
        //$newFileName = $picid.'.'.$request->picture->extension();
        
        $file = $request->file('picture2');  
        $contents = $file->openFile()->fread($file->getSize());
        $updateroom->IMG2 = $contents;   
        //$request->picture->storeAs('images',$newFileName,'public');
        //$inforpersonedit->HR_IMAGE_NAME = $newFileName; 
    }

        $updateroom->save();


        return redirect()->route('setup.indexroom'); 

    }

    
    public function destroy($id) { 

    Meetingroomindex::destroy($id);         
        //return redirect()->action('ChangenameController@infouserchangename');  
        return redirect()->route('setup.indexroom');   
    }
//===========================อุปกรณ์ที่ถูกใช้ในห้อง=======================
public function infoequ(Request $request,$id)
{
   
        $inforoomequ = Meetingroomequipment::leftJoin('meetingroom_article','meetingroom_article.ARTICLE_ID','=','meetingroom_equipment.ROOM_ARTICLE_ID')
        ->where('ROOM_ID','=',$id)
        ->orderBy('ID', 'asc')  
        ->get();

        $inforoom = Meetingroomindex::where('ROOM_ID','=',$id)
        ->first();

        $infoarticle = Meetingroomarticle::orderBy('ARTICLE_ID', 'asc')  
        ->get();
                                 
      
   //dd($inforoom);
    return view('admin_meeting.setupinforoomequ',[
        'inforoomequs' => $inforoomequ,
        'inforoom' => $inforoom,
        'infoarticles' => $infoarticle
    ]);
}

public function saveequ(Request $request)
    {
        //return $request->all();

            $addroomequ = new Meetingroomequipment(); 
            $addroomequ->ROOM_ARTICLE_ID = $request->ARTICLE_ID;
            $addroomequ->ROOM_ID = $request->ROOM_ID;
            $addroomequ->AMOUNT = $request->AMOUNT;
           
            $addroomequ->save();

            return redirect()->route('setup.indexequ',[
                'id' => $request->ROOM_ID  
                ]); 
    }

    public function updateequ(Request $request)
    {
        $id = $request->ID; 

        $updateroomequ = Meetingroomequipment::find($id);
        $updateroomequ->ROOM_ARTICLE_ID = $request->ARTICLE_ID;
        $updateroomequ->ROOM_ID = $request->ROOM_ID;
        $updateroomequ->AMOUNT = $request->AMOUNT;
       
        $updateroomequ->save();


        return redirect()->route('setup.indexequ',[
            'id' => $request->ROOM_ID  
            ]); 

    }

    public function destroyequ(Request $request,$idroom,$id) { 
     
        Meetingroomequipment::destroy($id);         
         //return redirect()->action('ChangenameController@infouserchangename');  
         return redirect()->route('setup.indexequ',[
            'id' => $idroom  
            ]);   
     }



//=======================================เมนูอาหาร==================================================
public function inforoomfood()
{
   
    $inforoomfood = Meetingroomfood::leftJoin('meetingroom_food_type','meetingroom_food.FOOD_TYPE_ID','=','meetingroom_food_type.FOOD_TYPE_ID')
                                    ->orderBy('FOOD_ID', 'asc')  
                                    ->get();
                                 
      
   //dd($inforoom);
    return view('admin_meeting.setupinforoomfood',[
        'inforoomfoods' => $inforoomfood
    ]);
}

public function createfood(Request $request)
    {
       //dd($infoeducation);
               
       $inforfoodtype=  Meetingroomfoodtype::get();

        return view('admin_meeting.setupinforoomfood_add',[
            'inforfoodtypes' => $inforfoodtype
        ]);

    }

    public function savefood(Request $request)
    {
        //return $request->all();

            $addfood = new Meetingroomfood(); 
            $addfood->FOOD_NAME = $request->FOOD_NAME;
            $addfood->FOOD_PRICE = $request->FOOD_PRICE;
            $addfood->FOOD_UNIT = $request->FOOD_UNIT;
            $addfood->FOOD_TYPE_ID = $request->FOOD_TYPE_ID;
           
           //dd($addbudgetyear);
 
            $addfood->save();


            return redirect()->route('setup.indexroomfood'); 
    }

    public function editfood(Request $request,$id)
    {
       // return $request->all();
    
       $id_in= $id;
     
       $infofood = Meetingroomfood::where('FOOD_ID','=',$id_in)
       ->first();

       $inforfoodtype=  Meetingroomfoodtype::get();


        //dd($inforbudget);
        return view('admin_meeting.setupinforoomfood_edit',[
        'inforfoodtypes' => $inforfoodtype,
        'infofood' => $infofood 
        ]);

    }



    public function updatefood(Request $request)
    {
        $id = $request->FOOD_ID; 

        $updatefood = Meetingroomfood::find($id);
        $updatefood->FOOD_NAME = $request->FOOD_NAME;
        $updatefood->FOOD_PRICE = $request->FOOD_PRICE;
        $updatefood->FOOD_UNIT = $request->FOOD_UNIT;
        $updatefood->FOOD_TYPE_ID = $request->FOOD_TYPE_ID;
           
           //dd($addbudgetyear);
 
        $updatefood->save();


        return redirect()->route('setup.indexroomfood'); 

    }

    
    public function destroyfood($id) { 

        Meetingroomfood::destroy($id);         
        //return redirect()->action('ChangenameController@infouserchangename');  
        return redirect()->route('setup.indexroomfood');   
    }

    //=======================================ประเภทอาหาร==================================================

    public function inforoomfoodtype()
{
   
    $inforoomfoodtype = Meetingroomfoodtype::orderBy('FOOD_TYPE_ID', 'asc')  
                                            ->get();
                                 
      
   //dd($inforoom);
    return view('admin_meeting.setupinforoomfoodtype',[
        'inforoomfoodtypes' => $inforoomfoodtype
    ]);
}

public function createfoodtype(Request $request)
    {
  
        return view('admin_meeting.setupinforoomfoodtype_add');

    }

    public function savefoodtype(Request $request)
    {
        //return $request->all();

            $addfoodtype = new Meetingroomfoodtype(); 
            $addfoodtype->FOOD_TYPE_NAME = $request->FOOD_TYPE_NAME;
         
 
            $addfoodtype->save();


            return redirect()->route('setup.indexroomfoodtype'); 
    }

    public function editfoodtype(Request $request,$id)
    {
       // return $request->all();
    
       $id_in= $id;
     
       $infofoodtype = Meetingroomfoodtype::where('FOOD_TYPE_ID','=',$id_in)
       ->first();


        //dd($inforbudget);
        return view('admin_meeting.setupinforoomfoodtype_edit',[
        'infofoodtype' => $infofoodtype 
        ]);

    }



    public function updatefoodtype(Request $request)
    {
        $id = $request->FOOD_TYPE_ID; 

        $updatefoodtype = Meetingroomfoodtype::find($id);
        $updatefoodtype->FOOD_TYPE_NAME = $request->FOOD_TYPE_NAME;
    
           
           //dd($addbudgetyear);
 
        $updatefoodtype->save();


        return redirect()->route('setup.indexroomfoodtype'); 

    }

    
    public function destroyfoodtype($id) { 

        Meetingroomfoodtype::destroy($id);         
        //return redirect()->action('ChangenameController@infouserchangename');  
        return redirect()->route('setup.indexroomfoodtype');   
    }

     //=======================================อุปกรณ์โสด==================================================

     public function inforoomarticle()
     {
        
         $inforoomarticle = Meetingroomarticle::orderBy('ARTICLE_ID', 'asc')  
                                                 ->get();
                                      
           
        //dd($inforoom);
         return view('admin_meeting.setupinforoomarticle',[
             'inforoomarticles' => $inforoomarticle
         ]);
     }
     
     public function createarticle(Request $request)
         {
       
             return view('admin_meeting.setupinforoomarticle_add');
     
         }
     
         public function savearticle(Request $request)
         {
             //return $request->all();
     
                 $addarticle = new Meetingroomarticle(); 
                 $addarticle->ARTICLE_NAME = $request->ARTICLE_NAME;
              
      
                 $addarticle->save();
     
     
                 return redirect()->route('setup.indexroomarticle'); 
         }
     
         public function editarticle(Request $request,$id)
         {
            // return $request->all();
         
            $id_in= $id;
          
            $infoarticle = Meetingroomarticle::where('ARTICLE_ID','=',$id_in)
            ->first();
     
     
             //dd($inforbudget);
             return view('admin_meeting.setupinforoomarticle_edit',[
             'infoarticle' => $infoarticle 
             ]);
     
         }
     
     
     
         public function updatearticle(Request $request)
         {
             $id = $request->ARTICLE_ID; 
     
             $updatearticle = Meetingroomarticle::find($id);
             $updatearticle->ARTICLE_NAME = $request->ARTICLE_NAME;

                //dd($addbudgetyear);
      
             $updatearticle->save();
     
     
             return redirect()->route('setup.indexroomarticle'); 
     
         }
     
         
         public function destroyarticle($id) { 
     
            Meetingroomarticle::destroy($id);         
             //return redirect()->action('ChangenameController@infouserchangename');  
             return redirect()->route('setup.indexroomarticle');   
         }

          //========================================ช่วงเวลา==================================================

     public function inforoomtime()
     {
        
         $inforoomtime = Meetingroomtime::orderBy('TIME_SC_ID', 'asc')  
                                                 ->get();
                                      
           
        //dd($inforoom);
         return view('admin_meeting.setupinforoomtime',[
             'inforoomtimes' => $inforoomtime
         ]);
     }
     
     public function createtime(Request $request)
         {
       
             return view('admin_meeting.setupinforoomtime_add');
     
         }
     
         public function savetime(Request $request)
         {
             //return $request->all();
     
                 $addtime = new Meetingroomtime(); 
                 $addtime->TIME_SC_BEGIN = $request->TIME_SC_BEGIN;
                 $addtime->TIME_SC_END = $request->TIME_SC_END;
                 $addtime->TIME_SC_NAME = $request->TIME_SC_NAME;
              
      
                 $addtime->save();
     
     
                 return redirect()->route('setup.indexroomtime'); 
         }
     
         public function edittime(Request $request,$id)
         {
            // return $request->all();
         
            $id_in= $id;
          
            $infotime = Meetingroomtime::where('TIME_SC_ID','=',$id_in)
            ->first();
     
     
             //dd($inforbudget);
             return view('admin_meeting.setupinforoomtime_edit',[
             'infotime' => $infotime 
             ]);
     
         }
     
     
     
         public function updatetime(Request $request)
         {
             $id = $request->TIME_SC_ID; 
     
             $updatetime = Meetingroomtime::find($id);
             $updatetime->TIME_SC_BEGIN = $request->TIME_SC_BEGIN;
             $updatetime->TIME_SC_END = $request->TIME_SC_END;
             $updatetime->TIME_SC_NAME = $request->TIME_SC_NAME;

                //dd($addbudgetyear);
      
             $updatetime->save();
     
     
             return redirect()->route('setup.indexroomtime'); 
     
         }
     
         
         public function destroytime($id) { 
     
            Meetingroomtime::destroy($id);         
             //return redirect()->action('ChangenameController@infouserchangename');  
             return redirect()->route('setup.indexroomtime');   
         }

}
