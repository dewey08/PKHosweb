<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Person;
use App\Models\Booktype;
use App\Models\Booksecret;
use App\Models\Bookinstant;
use App\Models\Bookfileserver;
use App\Models\Booktypeout;
use App\Models\Bookorgin;
use App\Models\Bookorgoutlist;

use App\Models\Hrddepartment;
use App\Models\Hrddepartmentsub;



class SetupbookController extends Controller
{



     public function infobooktype()
    {
   
    $infobooktype = Booktype::orderBy('BOOK_TYPE_ID', 'asc')  
                                            ->get();                     
      
   //dd($inforoom);
    return view('admin_book.setupinfobooktype',[
        'infobooktypes' => $infobooktype
    ]);
    }   

    public function createbooktype(Request $request)
    {
  
        return view('admin_book.setupinfobooktype_add');

    }

    public function savebooktype(Request $request)
    {
        //return $request->all();

            $addbooktype = new Booktype(); 
            $addbooktype->BOOK_TYPE_NAME = $request->BOOK_TYPE_NAME;
         
            $addbooktype->save();


            return redirect()->route('setup.infobooktype'); 
    }

    public function editbooktype(Request $request,$id)
    {
       // return $request->all();
    
       $id_in= $id;
     
       $infobooktype = Booktype::where('BOOK_TYPE_ID','=',$id_in)
       ->first();


        //dd($inforbudget);
        return view('admin_book.setupinfobooktype_edit',[
        'infobooktype' => $infobooktype 
        ]);

    }



    public function updatebooktype(Request $request)
    {
        $id = $request->BOOK_TYPE_ID; 

        $updatebooktype = Booktype::find($id);
        $updatebooktype->BOOK_TYPE_NAME = $request->BOOK_TYPE_NAME;
    
           
           //dd($addbudgetyear);
 
        $updatebooktype->save();


        return redirect()->route('setup.infobooktype'); 

    }

    
    public function destroybooktype($id) { 

        Booktype::destroy($id);         
        //return redirect()->action('ChangenameController@infouserchangename');  
        return redirect()->route('setup.infobooktype');   
    }


    //=======================================ระดับความลับ===================


    
    public function infobooksecret()
    {
   
    $infobooksecret = Booksecret::orderBy('BOOK_SECRET_ID', 'asc')  
                                            ->get();                     
      
   //dd($inforoom);
    return view('admin_book.setupinfobooksecret',[
        'infobooksecrets' => $infobooksecret
    ]);
    }   

    public function createbooksecret(Request $request)
    {
  
        return view('admin_book.setupinfobooksecret_add');

    }

    public function savebooksecret(Request $request)
    {
        //return $request->all();

            $addbooksecret = new Booksecret(); 
            $addbooksecret->BOOK_SECRET_NAME = $request->BOOK_SECRET_NAME;
         
            $addbooksecret->save();


            return redirect()->route('setup.infobooksecret'); 
    }

    public function editbooksecret(Request $request,$id)
    {
       // return $request->all();
    
       $id_in= $id;
     
       $infobooksecret = Booksecret::where('BOOK_SECRET_ID','=',$id_in)
       ->first();


        //dd($inforbudget);
        return view('admin_book.setupinfobooksecret_edit',[
        'infobooksecret' => $infobooksecret
        ]);

    }



    public function updatebooksecret(Request $request)
    {
        $id = $request->BOOK_SECRET_ID; 

        $updatebooksecret = Booksecret::find($id);
        $updatebooksecret->BOOK_SECRET_NAME = $request->BOOK_SECRET_NAME;
    
           
           //dd($addbudgetyear);
 
        $updatebooksecret->save();


        return redirect()->route('setup.infobooksecret'); 

    }

    
    public function destroybooksecret($id) { 

        Booksecret::destroy($id);         
        //return redirect()->action('ChangenameController@infouserchangename');  
        return redirect()->route('setup.infobooksecret');   
    }


    
    //=======================================ความเร่งด่วน===================


    
    public function infobookinstant()
    {
   
    $infobookinstant = Bookinstant::orderBy('INSTANT_ID', 'asc')  
                                            ->get();                     
      
   //dd($inforoom);
    return view('admin_book.setupinfobookinstant',[
        'infobookinstants' => $infobookinstant
    ]);
    }   

    public function createbookinstant(Request $request)
    {
  
        return view('admin_book.setupinfobookinstant_add');

    }

    public function savebookinstant(Request $request)
    {
        //return $request->all();

            $addbookinstant = new Bookinstant(); 
            $addbookinstant->INSTANT_NAME = $request->INSTANT_NAME;
         
            $addbookinstant->save();


            return redirect()->route('setup.infobookinstant'); 
    }

    public function editbookinstant(Request $request,$id)
    {
       // return $request->all();
    
       $id_in= $id;
     
       $infobookinstant = Bookinstant::where('INSTANT_ID','=',$id_in)
       ->first();


        //dd($inforbudget);
        return view('admin_book.setupinfobookinstant_edit',[
        'infobookinstant' => $infobookinstant
        ]);

    }



    public function updatebookinstant(Request $request)
    {
        $id = $request->INSTANT_ID; 

        $updatebookinstant = Bookinstant::find($id);
        $updatebookinstant->INSTANT_NAME = $request->INSTANT_NAME;
    
           
           //dd($addbudgetyear);
 
        $updatebookinstant->save();


        return redirect()->route('setup.infobookinstant'); 

    }

    
    public function destroybookinstant($id) { 

        Bookinstant::destroy($id);         
        //return redirect()->action('ChangenameController@infouserchangename');  
        return redirect()->route('setup.infobookinstant');   
    }
     //==================================File server===================


    
     public function infobookfile()
     {
    
     $infobookfile = Bookfileserver::orderBy('SERVER_ID', 'asc')  
                                             ->get();                     
       
    //dd($inforoom);
     return view('admin_book.setupinfobookfileserver',[
         'infobookfiles' => $infobookfile
     ]);
     }   
 
     public function createbookfile(Request $request)
     {
   
         return view('admin_book.setupinfobookfileserver_add');
 
     }
 
     public function savebookfile(Request $request)
     {
         //return $request->all();
 
             $addbookfile = new Bookfileserver(); 
             $addbookfile->SERVER_ID = $request->SERVER_ID;
             $addbookfile->SERVER_NAME = $request->SERVER_NAME;
             $addbookfile->SERVER_PATH = $request->SERVER_PATH;

             $addbookfile->save();
 
 
             return redirect()->route('setup.infobookfile'); 
     }
 
     public function editbookfile(Request $request,$id)
     {
        // return $request->all();
     
        $id_in= $id;
      
        $infobookfile = Bookfileserver::where('File_SERVER_ID','=',$id_in)
        ->first();
 
 
         //dd($inforbudget);
         return view('admin_book.setupinfobookfileserver_edit',[
         'infobookfile' => $infobookfile
         ]);
 
     }
 
 
 
     public function updatebookfile(Request $request)
     {
         $id = $request->File_SERVER_ID; 
 
         $updatebookfile = Bookfileserver::find($id);
         $updatebookfile->SERVER_NAME = $request->SERVER_NAME;
         $updatebookfile->SERVER_PATH = $request->SERVER_PATH;
     
            
            //dd($addbudgetyear);
  
         $updatebookfile->save();
 
 
         return redirect()->route('setup.infobookfile'); 
 
     }
 
     
     public function destroybookfile($id) { 
 
        Bookfileserver::destroy($id);         
         //return redirect()->action('ChangenameController@infouserchangename');  
         return redirect()->route('setup.infobookfile');   
     }

        
    //==================================ประเภทออก===================


    
    public function infobooktypeout()
    {
   
    $infobooktypeout = Booktypeout::orderBy('BOOK_TYPE_OUT_ID', 'asc')  
                                            ->get();                     
      
   //dd($inforoom);
    return view('admin_book.setupinfobooktypeout',[
        'infobooktypeouts' => $infobooktypeout
    ]);
    }   

    public function createbooktypeout(Request $request)
    {
  
        return view('admin_book.setupinfobooktypeout_add');

    }

    public function savebooktypeout(Request $request)
    {
        //return $request->all();

            $addbooktypeout = new Booktypeout(); 
            $addbooktypeout->BOOK_TYPE_OUT_NAME = $request->BOOK_TYPE_OUT_NAME;
         
            $addbooktypeout->save();


            return redirect()->route('setup.infobooktypeout'); 
    }

    public function editbooktypeout(Request $request,$id)
    {
       // return $request->all();
    
       $id_in= $id;
     
       $infobooktypeout = Booktypeout::where('BOOK_TYPE_OUT_ID','=',$id_in)
       ->first();


        //dd($inforbudget);
        return view('admin_book.setupinfobooktypeout_edit',[
        'infobooktypeout' => $infobooktypeout
        ]);

    }



    public function updatebooktypeout(Request $request)
    {
        $id = $request->BOOK_TYPE_OUT_ID; 

        $updatebooktypeout = Booktypeout::find($id);
        $updatebooktypeout->BOOK_TYPE_OUT_NAME = $request->BOOK_TYPE_OUT_NAME;
    
           
           //dd($addbudgetyear);
 
        $updatebooktypeout->save();


        return redirect()->route('setup.infobooktypeout'); 

    }

    
    public function destroybooktypeout($id) { 

        Booktypeout::destroy($id);         
        //return redirect()->action('ChangenameController@infouserchangename');  
        return redirect()->route('setup.infobooktypeout');   
    }



      //==================================ธุรการกลุ่มงาน===================


    
      public function infobookdepartmentadmin()
      {
     
      $infobookdepartmentadmin= Hrddepartment::select('hrd_department.HR_DEPARTMENT_ID','hrd_department.HR_DEPARTMENT_NAME','hrd_department.BOOK_NUM','hrd_prefix.HR_PREFIX_NAME','hrd_person.HR_FNAME','hrd_person.HR_LNAME')
                                ->leftJoin('hrd_person','hrd_department.BOOK_HR_ID','=','hrd_person.ID')
                                ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID') 
                                ->orderBy('hrd_department.HR_DEPARTMENT_ID', 'asc') 
                                ->get();                     
        
     //dd($inforoom);
      return view('admin_book.setupinfobookdepartmentadmin',[
          'infobookdepartmentadmins' => $infobookdepartmentadmin
      ]);
      }   
  
      
  
      public function editbookdepartmentadmin(Request $request,$id)
      {
         // return $request->all();
      
         $id_in= $id;
       
         $infobookdepartmentadmin= Hrddepartment::where('HR_DEPARTMENT_ID','=',$id_in)
         ->first();
  
         $PERSONALL = DB::table('hrd_person')
         ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
         ->get();
  
          //dd($inforbudget);
          return view('admin_book.setupinfobookdepartmentadmin_edit',[
          'infobookdepartmentadmin' => $infobookdepartmentadmin,
          'PERSONALLs' => $PERSONALL
          ]);
  
      }
  
  
  
      public function updatebookdepartmentadmin(Request $request)
      {
          $id = $request->HR_DEPARTMENT_ID; 
  
          $updatebookdepartmentadmin = Hrddepartment::find($id);
          $updatebookdepartmentadmin->BOOK_NUM = $request->BOOK_NUM;
          $updatebookdepartmentadmin->BOOK_HR_ID = $request->BOOK_HR_ID;

          $updatebookdepartmentadmin->save();
  
  
          return redirect()->route('setup.infobookdepartmentadmin'); 
  
      }


       //==================================ธุรการฝ่าย===================


    
       public function infobookdepartmentadminsub()
       {
      
       $infobookdepartmentadminsub= Hrddepartmentsub::select('hrd_department.HR_DEPARTMENT_NAME','hrd_department_sub.HR_DEPARTMENT_SUB_ID','hrd_department_sub.HR_DEPARTMENT_SUB_NAME','hrd_department_sub.BOOK_NUM','hrd_prefix.HR_PREFIX_NAME','hrd_person.HR_FNAME','hrd_person.HR_LNAME')
                                 ->leftJoin('hrd_department','hrd_department_sub.HR_DEPARTMENT_ID','=','hrd_department.HR_DEPARTMENT_ID')
                                 ->leftJoin('hrd_person','hrd_department_sub.BOOK_HR_ID','=','hrd_person.ID')
                                 ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID') 
                                 ->orderBy('hrd_department_sub.HR_DEPARTMENT_SUB_ID', 'asc') 
                                 ->get();                     
         
      //dd($inforoom);
       return view('admin_book.setupinfobookdepartmentadminsub',[
           'infobookdepartmentadminsubs' => $infobookdepartmentadminsub
       ]);
       }   
   
       
   
       public function editbookdepartmentadminsub(Request $request,$id)
       {
          // return $request->all();
       
          $id_in= $id;
        
          $infobookdepartmentadminsub= Hrddepartmentsub::where('HR_DEPARTMENT_SUB_ID','=',$id_in)
          ->first();
   
          $PERSONALL = DB::table('hrd_person')
          ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
          ->get();
   
           //dd($inforbudget);
           return view('admin_book.setupinfobookdepartmentadminsub_edit',[
           'infobookdepartmentadminsub' => $infobookdepartmentadminsub,
           'PERSONALLs' => $PERSONALL
           ]);
   
       }
   
   
   
       public function updatebookdepartmentadminsub(Request $request)
       {
           $id = $request->HR_DEPARTMENT_SUB_ID; 
   
           $updatebookdepartmentadminsub = Hrddepartmentsub::find($id);
           $updatebookdepartmentadminsub->BOOK_NUM = $request->BOOK_NUM;
           $updatebookdepartmentadminsub->BOOK_HR_ID = $request->BOOK_HR_ID;
 
           $updatebookdepartmentadminsub->save();
   
   
           return redirect()->route('setup.infobookdepartmentadminsub'); 
   
       }
   
  


     //==================================หน่วยงานรับเข้า===================


    
     public function infobookorgin()
     {
    
     $infobookorgin = Bookorgin::orderBy('BOOK_ORG_ID', 'asc')  
                                             ->get();                     
       
    //dd($inforoom);
     return view('admin_book.setupinfobookorgin',[
         'infobookorgins' => $infobookorgin
     ]);
     }   
 
     public function createbookorgin(Request $request)
     {
   
         return view('admin_book.setupinfobookorgin_add');
 
     }
 
     public function savebookorgin(Request $request)
     {
         //return $request->all();
 
             $addbookorgin = new Bookorgin(); 
             $addbookorgin->BOOK_ORG_NAME = $request->BOOK_ORG_NAME;
             $addbookorgin->ACTIVE = 'False';

             $addbookorgin->save();
 
 
             return redirect()->route('setup.infobookorgin'); 
     }
 
     public function editbookorgin(Request $request,$id)
     {
        // return $request->all();
     
        $id_in= $id;
      
        $infobookorgin = Bookorgin::where('BOOK_ORG_ID','=',$id_in)
        ->first();
 
 
         //dd($inforbudget);
         return view('admin_book.setupinfobookorgin_edit',[
         'infobookorgin' => $infobookorgin
         ]);
 
     }
 
 
 
     public function updatebookorgin(Request $request)
     {
         $id = $request->BOOK_ORG_ID; 
 
         $updatebookorgin = Bookorgin::find($id);
         $updatebookorgin->BOOK_ORG_NAME = $request->BOOK_ORG_NAME;
     
            
            //dd($addbudgetyear);
  
         $updatebookorgin->save();
 
 
         return redirect()->route('setup.infobookorgin'); 
 
     }
 
     
     public function destroybookorgin($id) { 
 
        Bookorgin::destroy($id);         
         //return redirect()->action('ChangenameController@infouserchangename');  
         return redirect()->route('setup.infobookorgin');   
     }
 
     function switchactive(Request $request)
     {  
         //return $request->all(); 
         $id = $request->bookorgin;
         $bookorginactive = Bookorgin::find($id);
         $bookorginactive->ACTIVE = $request->onoff;
         $bookorginactive->save();
     }


     

     //==================================หน่วยงานหนังสือออก===================


    
     public function infobookorgout()
     {
    
     $infobookorgout = Bookorgoutlist::orderBy('BOOK_ORG_ID', 'asc')  
                                             ->get();                     
       
    //dd($inforoom);
     return view('admin_book.setupinfobookorgout',[
         'infobookorgouts' => $infobookorgout
     ]);
     }   
 
     public function createbookorgout(Request $request)
     {
   
         return view('admin_book.setupinfobookorgout_add');
 
     }
 
     public function savebookorgout(Request $request)
     {
         //return $request->all();
 
             $addbookorgout = new Bookorgoutlist(); 
             $addbookorgout->BOOK_ORG_NAME = $request->BOOK_ORG_NAME;
             $addbookorgout->ACTIVE = 'False';

             $addbookorgout->save();
 
 
             return redirect()->route('setup.infobookorgout'); 
     }
 
     public function editbookorgout(Request $request,$id)
     {
        // return $request->all();
     
        $id_in= $id;
      
        $infobookorgout = Bookorgoutlist::where('BOOK_ORG_ID','=',$id_in)
        ->first();
 
 
         //dd($inforbudget);
         return view('admin_book.setupinfobookorgout_edit',[
         'infobookorgout' => $infobookorgout
         ]);
 
     }
 
 
 
     public function updatebookorgout(Request $request)
     {
         $id = $request->BOOK_ORG_ID; 
 
         $updatebookorgout = Bookorgoutlist::find($id);
         $updatebookorgout->BOOK_ORG_NAME = $request->BOOK_ORG_NAME;
     
            
            //dd($addbudgetyear);
  
         $updatebookorgout->save();
 
 
         return redirect()->route('setup.infobookorgout'); 
 
     }
 
     
     public function destroybookorgout($id) { 
 
        Bookorgoutlist::destroy($id);         
         //return redirect()->action('ChangenameController@infouserchangename');  
         return redirect()->route('setup.infobookorgout');   
     }
 
     function switchactiveorgout(Request $request)
     {  
         //return $request->all(); 
         $id = $request->bookorgout;
         $bookorgoutactive = Bookorgoutlist::find($id);
         $bookorgoutactive->ACTIVE = $request->onoff;
         $bookorgoutactive->save();
     }
    
}
