<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Leaveover;
use App\Models\Person;
use Excel;

class SetupvacationController extends Controller
{
    public function infovacation()
    {
       

        $m_budget = date("m");
        //$m_budget = 10;
       // echo $m_budget; 
        if($m_budget>9){
          $yearbudget = date("Y")+544;
        }else{
          $yearbudget = date("Y")+543;
        }
        
        $budget = $yearbudget;
        $budgetyear =  DB::table('budget_year') ->where('ACTIVE','=',True)->get();

        $infovacation = Leaveover::select('gleave_over.ID','HR_PREFIX_NAME','HR_FNAME','HR_LNAME','HR_PERSON_TYPE_NAME','DAY_LEAVE_OVER_BEFORE','OLDS','DAY_LEAVE_OVER','OVER_YEAR_ID','DAY_LEAVE_COLLECT')
        ->leftJoin('hrd_person','gleave_over.PERSON_ID','=','hrd_person.ID')
        ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_person_type','hrd_person.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
        ->where('gleave_over.OVER_YEAR_ID','=',$budget) 
        ->orderBy('gleave_over.ID', 'asc')  
        ->get();

        $countperson = Leaveover::select('gleave_over.ID','HR_PREFIX_NAME','HR_FNAME','HR_LNAME','HR_PERSON_TYPE_NAME','DAY_LEAVE_OVER_BEFORE','OLDS','DAY_LEAVE_OVER','OVER_YEAR_ID')
        ->leftJoin('hrd_person','gleave_over.PERSON_ID','=','hrd_person.ID')
        ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_person_type','hrd_person.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
        ->where('gleave_over.OVER_YEAR_ID','=',$budget)   
        ->count();

        $maxbudget = Leaveover::max('OVER_YEAR_ID');
   
        $srech = 1;
       //dd($infoeducation);
        return view('admin.setupvacation',[
            'infoinfovacations' => $infovacation, 
            'budgetyears' => $budgetyear,
            'budget' => $budget,
            'max' => $maxbudget,
            'countperson' => $countperson,
            
            
        ]);
    }

    function search(Request $request)
    {
         
         $budget = $request->LEAVE_YEAR_ID;
         $search = $request->search;
        $budgetyear =  DB::table('budget_year') ->where('ACTIVE','=',True)->get();

        $infovacation = Leaveover::select('gleave_over.ID','HR_PREFIX_NAME','HR_FNAME','HR_LNAME','HR_PERSON_TYPE_NAME','DAY_LEAVE_OVER_BEFORE','OLDS','DAY_LEAVE_OVER','OVER_YEAR_ID','DAY_LEAVE_COLLECT')
        ->leftJoin('hrd_person','gleave_over.PERSON_ID','=','hrd_person.ID')
        ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_person_type','hrd_person.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
        ->where('gleave_over.OVER_YEAR_ID','=',$budget)
        ->where(function($q) use ($search){
            $q->where('gleave_over.PERSON_ID','like','%'.$search.'%');
            $q->orwhere('HR_PREFIX_NAME','like','%'.$search.'%');
            $q->orwhere('HR_FNAME','like','%'.$search.'%');
            $q->orwhere('HR_LNAME','like','%'.$search.'%');
            $q->orwhere('HR_PERSON_TYPE_NAME','like','%'.$search.'%');
            $q->orwhere('DAY_LEAVE_OVER_BEFORE','like','%'.$search.'%');
            $q->orwhere('OLDS','like','%'.$search.'%');
            $q->orwhere('DAY_LEAVE_OVER','like','%'.$search.'%');
        })
        ->orderBy('gleave_over.ID', 'asc')     
        ->get();


        $countperson = Leaveover::select('gleave_over.ID','HR_PREFIX_NAME','HR_FNAME','HR_LNAME','HR_PERSON_TYPE_NAME','DAY_LEAVE_OVER_BEFORE','OLDS','DAY_LEAVE_OVER','OVER_YEAR_ID','DAY_LEAVE_COLLECT')
        ->leftJoin('hrd_person','gleave_over.PERSON_ID','=','hrd_person.ID')
        ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_person_type','hrd_person.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
        ->where('gleave_over.OVER_YEAR_ID','=',$budget)
        ->where(function($q) use ($search){
            $q->where('gleave_over.PERSON_ID','like','%'.$search.'%');
            $q->orwhere('HR_PREFIX_NAME','like','%'.$search.'%');
            $q->orwhere('HR_FNAME','like','%'.$search.'%');
            $q->orwhere('HR_LNAME','like','%'.$search.'%');
            $q->orwhere('HR_PERSON_TYPE_NAME','like','%'.$search.'%');
            $q->orwhere('DAY_LEAVE_OVER_BEFORE','like','%'.$search.'%');
            $q->orwhere('OLDS','like','%'.$search.'%');
            $q->orwhere('DAY_LEAVE_OVER','like','%'.$search.'%');
        }) 
        ->count();


       
        
        $maxbudget = Leaveover::max('OVER_YEAR_ID');
       
        return view('admin.setupvacation',[
            'infoinfovacations' => $infovacation, 
            'budgetyears' => $budgetyear,
            'budget' => $budget,
            'max' => $maxbudget,
            'countperson' => $countperson,
            
        ]);
       
    }

    function selectbudget(Request $request)
    {
        $budget = $request->LEAVE_YEAR_ID;
        $budgetyear =  DB::table('budget_year') ->where('ACTIVE','=',True)->get();

        $infovacation = Leaveover::select('gleave_over.ID','HR_PREFIX_NAME','HR_FNAME','HR_LNAME','HR_PERSON_TYPE_NAME','DAY_LEAVE_OVER_BEFORE','OLDS','DAY_LEAVE_OVER','OVER_YEAR_ID','DAY_LEAVE_COLLECT')
        ->leftJoin('hrd_person','gleave_over.PERSON_ID','=','hrd_person.ID')
        ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_person_type','gleave_over.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
        ->orderBy('gleave_over.ID', 'asc')
        ->where('gleave_over.OVER_YEAR_ID','=',$budget)  
        ->get();
        
        $countperson = Leaveover::select('gleave_over.ID','HR_PREFIX_NAME','HR_FNAME','HR_LNAME','HR_PERSON_TYPE_NAME','DAY_LEAVE_OVER_BEFORE','OLDS','DAY_LEAVE_OVER','OVER_YEAR_ID')
        ->leftJoin('hrd_person','gleave_over.PERSON_ID','=','hrd_person.ID')
        ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_person_type','gleave_over.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
        ->orderBy('gleave_over.ID', 'asc')
        ->where('gleave_over.OVER_YEAR_ID','=',$budget)  
        ->count();

        $maxbudget = Leaveover::max('OVER_YEAR_ID');

        return view('admin.setupvacation',[
            'infoinfovacations' => $infovacation, 
            'budgetyears' => $budgetyear,
            'budget' => $budget,
            'max' => $maxbudget,
            'countperson' => $countperson,
        ]);
       
    }
    
    function calleaveday(Request $reques,$check)
    {
        
        //  $m_budget = date("m");
        //  $m_budget = 10;
        //  echo $m_budget; 
        //   if($m_budget>9){
        //    $yearbudget = date("Y")+544;
        //   }else{
        //    $yearbudget = date("Y")+543;
        //   }
          
        //   $budget = $request->LEAVE_YEAR_ID;

        //   dd($budget);
        // dd($check);
        // $yearbudget = '2564';

        $budget = $check; //ปีงบประมาณล่าสุด

        // dd($budget);

        $budgetyear =  DB::table('budget_year') ->where('ACTIVE','=',True)->get();

        $infovacation = Leaveover::select('gleave_over.ID','HR_PREFIX_NAME','HR_FNAME','HR_LNAME','HR_PERSON_TYPE_NAME','DAY_LEAVE_OVER_BEFORE','OLDS','DAY_LEAVE_OVER','OVER_YEAR_ID')
        ->leftJoin('hrd_person','gleave_over.PERSON_ID','=','hrd_person.ID')
        ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_person_type','gleave_over.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
        ->orderBy('gleave_over.ID', 'asc')
        ->where('gleave_over.OVER_YEAR_ID','=',$budget)  
        ->get();
        
        $maxbudget = Leaveover::max('OVER_YEAR_ID');

        

        //======================cal===========================
        $budgetold =  $budget-1;
        $infouserolds = Leaveover::leftJoin('hrd_person','gleave_over.PERSON_ID','=','hrd_person.ID')
        ->where('gleave_over.OVER_YEAR_ID','=',$budgetold)  
        ->get();


        foreach ($infouserolds as $infouserold){ 

            $then = strtotime($infouserold->HR_STARTWORK_DATE);
            $agework = (floor((time()-$then)/31556926));


            $datehaveyear = DB::table('gleave_over')
            ->where('PERSON_ID','=',$infouserold->PERSON_ID)
            ->where('OVER_YEAR_ID','=',$budgetold )
            ->sum('DAY_LEAVE_OVER_BEFORE');

            $dateuse = DB::table('gleave_register')
            ->where('LEAVE_YEAR_ID','=',$budgetold )
            ->where('LEAVE_TYPE_CODE','=','04' )
            ->where('LEAVE_PERSON_ID','=',$infouserold->PERSON_ID )
            ->where('LEAVE_STATUS_CODE','=','Allow')
            ->sum('WORK_DO');

            $datebalance = $datehaveyear  - $dateuse;


            
            $sumleave =  $datebalance + 10;

               if($infouserold->HR_PERSON_TYPE_ID==1 || $infouserold->HR_PERSON_TYPE_ID==2){
                   if($agework>=1 && $agework<10){
                        if($sumleave > 20){
                            $totalleave = 20;
                        }else{
                            $totalleave = $sumleave;
                        }
                   }else if($agework>=10){
                    if($sumleave > 30){
                        $totalleave = 30;
                    }else{
                        $totalleave = $sumleave;
                    }

                   }else{
                    $totalleave = 0;
                   }
               }else if($infouserold->HR_PERSON_TYPE_ID==3 || $infouserold->HR_PERSON_TYPE_ID==4){

                    if($sumleave > 15){
                            $totalleave = 15;
                        }else{
                            $totalleave = $sumleave;
                     }

               }else{
                    $totalleave = 10;
               }


               $addleave = new Leaveover(); 
               $addleave->PERSON_ID = $infouserold->PERSON_ID;
               $addleave->DAY_LEAVE_OVER = $infouserold->DAY_LEAVE_OVER;
               $addleave->OVER_YEAR_ID = $budget;
               $addleave->OLDS = $agework;
               $addleave->DAY_LEAVE_OVER_BEFORE = $totalleave;
               $addleave->HR_PERSON_TYPE_ID = $infouserold->HR_PERSON_TYPE_ID;
               $addleave->save();


        }


        return redirect()->route('setup.indexvacation');
       
    }



    public function create(Request $request)
    {
       $m_budget = date("m");
         //$m_budget = 10;
         // echo $m_budget; 
          if($m_budget>9){
            $yearbudget = date("Y")+544;
          }else{
            $yearbudget = date("Y")+543;
          }       
        //   dd( $yearbudget);
       $infoperson = Person::where('HR_STATUS_ID','=',1)->get();
        //    foreach ($infoperson as $person)
        //    {
        //     dd( $person->ID);
        //     $countcheck =  Leaveover::where('PERSON_ID','=',$person ->ID)->where('gleave_over.OVER_YEAR_ID','=',$yearbudget)->count(); 
        //    }
        //    dd( $person);
        //    dd( $infoperson->HR_STARTWORK_DATE);
       $budgetyear = DB::table('budget_year')->where('ACTIVE','=','True')->get();

        return view('admin.setupvacationl_add',[
            'budgetyears' => $budgetyear,
            'infopersons' => $infoperson
        ]);
    }
    function checkolds(Request $request)
    {
       
        $iduser = $request->PERSON_ID;
        $infostartdate=  Person::where('ID','=',$iduser)->first();

         $y = $infostartdate->HR_STARTWORK_DATE;
        //  dd($y);
        //  dd($yearbudget);
        $strYear = date("Y",strtotime($y));  
        // dd($date);
        $strYearnow = date("Y");
       
        $oldsyear = $strYearnow - $strYear;
        //  dd($oldsyear);
         echo $oldsyear;
        // echo $infostartdate->HR_STARTWORK_DATE;
        
    }


    function checkolds_input(Request $request)
    {
       
        $iduser = $request->PERSON_ID;
        $infostartdate=  Person::where('ID','=',$iduser)->first();

        $y = $infostartdate->HR_STARTWORK_DATE;
        $strYear = date("Y",strtotime($y));  
        $strYearnow = date("Y");
       
        $oldsyear = $strYearnow - $strYear;

         echo  '<input  name = "OLDS"  id="OLDS" class="form-control " style=" font-family: \'Kanit\', sans-serif;" value="'.$oldsyear.'">';
   
        
    }


    function caldate(Request $request)
    {
       
        $iduser = $request->PERSON_ID;
 
        $infouserold = DB::table('hrd_person')->where('ID','=',$iduser)->first();

        $then = strtotime($infouserold->HR_STARTWORK_DATE);
        $agework = (floor((time()-$then)/31556926));


        $datebalance = $request->DAY_LEAVE_COLLECT;


        
        $sumleave =  $datebalance + 10;

           if($infouserold->HR_PERSON_TYPE_ID==1 || $infouserold->HR_PERSON_TYPE_ID==2){
               if($agework>=1 && $agework<10){
                    if($sumleave > 20){
                        $totalleave = 20;
                    }else{
                        $totalleave = $sumleave;
                    }
               }else if($agework>=10){
                if($sumleave > 30){
                    $totalleave = 30;
                }else{
                    $totalleave = $sumleave;
                }

               }else{
                $totalleave = 0;
               }
           }else if($infouserold->HR_PERSON_TYPE_ID==3 || $infouserold->HR_PERSON_TYPE_ID==4){

                if($sumleave > 15){
                        $totalleave = 15;
                    }else{
                        $totalleave = $sumleave;
                 }

           }else{
                $totalleave = 10;
           }

         $DAY_LEAVE_OVER_BEFORE = number_format($totalleave,1);

    echo  ' <input  name = "DAY_LEAVE_OVER_BEFORE"  id="DAY_LEAVE_OVER_BEFORE" class="form-control input-lg" style=" font-family: \'Kanit\', sans-serif;" OnKeyPress="return chkmunny(this)" value="'.$DAY_LEAVE_OVER_BEFORE.'">';
   
        
    }


    public function save(Request $request)
    {
            $iduser = $request->PERSON_ID;
            // dd($iduser);
            $infostartdate=  Person::where('ID','=',$iduser)->first();
            $y = $infostartdate->HR_STARTWORK_DATE;
            $strYear = date("Y",strtotime($y));  
            $strYearnow = date("Y");          
            $oldsyear = $strYearnow - $strYear;

            $addvacation = new Leaveover(); 
          
            $addvacation->PERSON_ID = $iduser;
            $addvacation->DAY_LEAVE_OVER = $request->DAY_LEAVE_OVER;
            $addvacation->OVER_YEAR_ID = $request->OVER_YEAR_ID;
            $addvacation->OLDS = $oldsyear;
            $addvacation->DAY_LEAVE_OVER_BEFORE = $request->DAY_LEAVE_OVER_BEFORE;
            $addvacation->HR_PERSON_TYPE_ID = '1';
            $addvacation->DAY_LEAVE_COLLECT = $request->DAY_LEAVE_COLLECT;
            $addvacation->save();

            return redirect()->route('setup.indexvacation'); 
    }


    public function edit(Request $request,$id)
    {
        $infoperson = Person::where('HR_STATUS_ID','=',1)->get();

        $budgetyear = DB::table('budget_year')->where('ACTIVE','=','True')->get();

        $infoleaveover = Leaveover::where('ID','=',$id)->first();

      
 
         return view('admin.setupvacationl_edit',[
             'budgetyears' => $budgetyear,
             'infopersons' => $infoperson,
             'infoleaveover' => $infoleaveover,
 
         ]);
 
    }



    public function update(Request $request)
    {
        $id = $request->ID; 

            $updatevacation = Leaveover::find($id);
            $updatevacation->PERSON_ID = $request->PERSON_ID;
            $updatevacation->DAY_LEAVE_OVER = $request->DAY_LEAVE_OVER;
            $updatevacation->OVER_YEAR_ID = $request->OVER_YEAR_ID;
            $updatevacation->OLDS = $request->OLDS;
            $updatevacation->DAY_LEAVE_OVER_BEFORE = $request->DAY_LEAVE_OVER_BEFORE;
            $updatevacation->HR_PERSON_TYPE_ID = '1';
            $updatevacation->DAY_LEAVE_COLLECT = $request->DAY_LEAVE_COLLECT;

            $updatevacation->save();


            return redirect()->route('setup.indexvacation'); 
    }



  
    
    public function destroy($id) { 
                
        Leaveover::destroy($id);         
        //return redirect()->action('ChangenameController@infouserchangename');  
        return redirect()->route('setup.indexvacation');   
    }



    function excel(Request $request, $budget)
    {
      
        // $infovacation = Leaveover::leftJoin('hrd_person','gleave_over.PERSON_ID','=','hrd_person.ID')
        // ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        // ->leftJoin('hrd_person_type','gleave_over.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
        // ->orderBy('gleave_over.ID', 'asc')
        // ->where('gleave_over.OVER_YEAR_ID','=',$budget)  
        // ->get();
        // dd($budget);

        $m_budget = date("m");
        //$m_budget = 10;
       // echo $m_budget; 
        if($m_budget>9){
          $yearbudget = date("Y")+544;
        }else{
          $yearbudget = date("Y")+543;
        }
        
        // $budget = $yearbudget;
        // $budgetyear =  DB::table('budget_year') ->where('ACTIVE','=',True)->get();

        $infovacation = Leaveover::select('gleave_over.ID','HR_PREFIX_NAME','HR_FNAME','HR_LNAME','HR_PERSON_TYPE_NAME','DAY_LEAVE_OVER_BEFORE','OLDS','DAY_LEAVE_OVER','OVER_YEAR_ID')
        ->leftJoin('hrd_person','gleave_over.PERSON_ID','=','hrd_person.ID')
        ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_person_type','hrd_person.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
        ->where('gleave_over.OVER_YEAR_ID','=',$budget) 
        ->orderBy('gleave_over.ID', 'asc')  
        ->get();

        $countperson = Leaveover::select('gleave_over.ID','HR_PREFIX_NAME','HR_FNAME','HR_LNAME','HR_PERSON_TYPE_NAME','DAY_LEAVE_OVER_BEFORE','OLDS','DAY_LEAVE_OVER','OVER_YEAR_ID')
        ->leftJoin('hrd_person','gleave_over.PERSON_ID','=','hrd_person.ID')
        ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_person_type','hrd_person.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
        ->where('gleave_over.OVER_YEAR_ID','=',$budget)   
        ->count();

        $maxbudget = Leaveover::max('OVER_YEAR_ID');
   
        $srech = 1;
              
      

        return view('admin.setupvacation_excel',[
            'infoinfovacations' => $infovacation, 
            'budget' => $budget
          
        ]);
    }

    function pdf()
    {
       
        return view('admin.setupvacation_pdf');
    }

}