<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Controllers\Line;
use App\Models\Person;
use App\Models\Salaryreceive;
use App\Models\Salaryreceiveperson;

use App\Models\Salarypay;
use App\Models\Salarypayperson;


use App\Models\Salaryborrow;
use App\Models\Salarycertificate;
use App\Models\Salarycertificatesub;
use App\Models\Salaryslip;

use App\Models\Salaryallhead;
use App\Models\Salaryall;
use App\Models\Salaryallreceive;
use App\Models\Salaryallpay;
use App\Models\Salarystaff;

use App\Models\Supplies;
use App\Models\Suppliesrequest;
use App\Models\Suppliescon;
use App\Models\Assetarticle;
use App\Models\Suppliesgroup;
use App\Models\Suppliesclass;
use App\Models\Suppliestypes;
use App\Models\Suppliesprop;
use App\Models\Suppliesunitref;
use App\Models\Suppliesconlist;
use App\Models\Suppliespurchase;
use App\Models\Suppliesconboard;
use App\Models\Suppliesconquotation;
use App\Models\Suppliesconboarddetail;
use App\Models\Otindexsub;
use App\Models\Otindex;

use App\Models\Account;
use App\Models\Accountsub;

use App\Models\Accounttheme;
use App\Models\Accountsubtheme;

use App\Models\Accountcheck;
use App\Models\Accountchecksub;

use App\Models\Accountbill;
use App\Models\Accountbillsub;

use App\Models\Accountboard;

use App\Models\Accountgroup;
use App\Models\Accountgroupsub1;
use App\Models\Accountgroupsub2;
use App\Models\Accountgroupsub3;
use App\Models\Accountgroupsub4;
use Cookie;
use PDF;
date_default_timezone_set("Asia/Bangkok");

class ManagercompensationController extends Controller
{
    public function dashboard()
    {
        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;
        }
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $year_id = $yearbudget;
        $count1 = Salaryallreceive::where('SALARYALL_RECEIVE_YEAR','=',$yearbudget)->sum('SALARYALL_RECEIVE_AMOUNT');
        $count2 = Salaryallpay::where('SALARYALL_PAY_YEAR','=',$yearbudget)->sum('SALARYALL_PAY_AMOUNT');
        $count3 = Salaryall::where('SALARYALL_YEAR_ID','=',$yearbudget)->sum('SALARYALL_TOTAL');
        $m1_1 = DB::table('salary_all_receive')->where('SALARYALL_RECEIVE_YEAR','=',$yearbudget)->where('SALARYALL_RECEIVE_MONTH','=',1)->sum('SALARYALL_RECEIVE_AMOUNT');
        $m2_1 = DB::table('salary_all_receive')->where('SALARYALL_RECEIVE_YEAR','=',$yearbudget)->where('SALARYALL_RECEIVE_MONTH','=',2)->sum('SALARYALL_RECEIVE_AMOUNT');
        $m3_1 = DB::table('salary_all_receive')->where('SALARYALL_RECEIVE_YEAR','=',$yearbudget)->where('SALARYALL_RECEIVE_MONTH','=',3)->sum('SALARYALL_RECEIVE_AMOUNT');
        $m4_1 = DB::table('salary_all_receive')->where('SALARYALL_RECEIVE_YEAR','=',$yearbudget)->where('SALARYALL_RECEIVE_MONTH','=',4)->sum('SALARYALL_RECEIVE_AMOUNT');
        $m5_1 = DB::table('salary_all_receive')->where('SALARYALL_RECEIVE_YEAR','=',$yearbudget)->where('SALARYALL_RECEIVE_MONTH','=',5)->sum('SALARYALL_RECEIVE_AMOUNT');
        $m6_1 = DB::table('salary_all_receive')->where('SALARYALL_RECEIVE_YEAR','=',$yearbudget)->where('SALARYALL_RECEIVE_MONTH','=',6)->sum('SALARYALL_RECEIVE_AMOUNT');
        $m7_1 = DB::table('salary_all_receive')->where('SALARYALL_RECEIVE_YEAR','=',$yearbudget)->where('SALARYALL_RECEIVE_MONTH','=',7)->sum('SALARYALL_RECEIVE_AMOUNT');
        $m8_1 = DB::table('salary_all_receive')->where('SALARYALL_RECEIVE_YEAR','=',$yearbudget)->where('SALARYALL_RECEIVE_MONTH','=',8)->sum('SALARYALL_RECEIVE_AMOUNT');
        $m9_1 = DB::table('salary_all_receive')->where('SALARYALL_RECEIVE_YEAR','=',$yearbudget)->where('SALARYALL_RECEIVE_MONTH','=',9)->sum('SALARYALL_RECEIVE_AMOUNT');
        $m10_1 = DB::table('salary_all_receive')->where('SALARYALL_RECEIVE_YEAR','=',$yearbudget)->where('SALARYALL_RECEIVE_MONTH','=',10)->sum('SALARYALL_RECEIVE_AMOUNT');
        $m11_1 = DB::table('salary_all_receive')->where('SALARYALL_RECEIVE_YEAR','=',$yearbudget)->where('SALARYALL_RECEIVE_MONTH','=',11)->sum('SALARYALL_RECEIVE_AMOUNT');
        $m12_1 = DB::table('salary_all_receive')->where('SALARYALL_RECEIVE_YEAR','=',$yearbudget)->where('SALARYALL_RECEIVE_MONTH','=',12)->sum('SALARYALL_RECEIVE_AMOUNT');

        $m1_2 = DB::table('salary_all_pay')->where('SALARYALL_PAY_YEAR','=',$yearbudget)->where('SALARYALL_PAY_MONTH','=',1)->sum('SALARYALL_PAY_AMOUNT');
        $m2_2 = DB::table('salary_all_pay')->where('SALARYALL_PAY_YEAR','=',$yearbudget)->where('SALARYALL_PAY_YEAR','=',2)->sum('SALARYALL_PAY_AMOUNT');
        $m3_2 = DB::table('salary_all_pay')->where('SALARYALL_PAY_YEAR','=',$yearbudget)->where('SALARYALL_PAY_MONTH','=',3)->sum('SALARYALL_PAY_AMOUNT');
        $m4_2 = DB::table('salary_all_pay')->where('SALARYALL_PAY_YEAR','=',$yearbudget)->where('SALARYALL_PAY_MONTH','=',4)->sum('SALARYALL_PAY_AMOUNT');
        $m5_2 = DB::table('salary_all_pay')->where('SALARYALL_PAY_YEAR','=',$yearbudget)->where('SALARYALL_PAY_MONTH','=',5)->sum('SALARYALL_PAY_AMOUNT');
        $m6_2 = DB::table('salary_all_pay')->where('SALARYALL_PAY_YEAR','=',$yearbudget)->where('SALARYALL_PAY_MONTH','=',6)->sum('SALARYALL_PAY_AMOUNT');
        $m7_2 = DB::table('salary_all_pay')->where('SALARYALL_PAY_YEAR','=',$yearbudget)->where('SALARYALL_PAY_MONTH','=',7)->sum('SALARYALL_PAY_AMOUNT');
        $m8_2 = DB::table('salary_all_pay')->where('SALARYALL_PAY_YEAR','=',$yearbudget)->where('SALARYALL_PAY_MONTH','=',8)->sum('SALARYALL_PAY_AMOUNT');
        $m9_2 = DB::table('salary_all_pay')->where('SALARYALL_PAY_YEAR','=',$yearbudget)->where('SALARYALL_PAY_MONTH','=',9)->sum('SALARYALL_PAY_AMOUNT');
        $m10_2 = DB::table('salary_all_pay')->where('SALARYALL_PAY_YEAR','=',$yearbudget)->where('SALARYALL_PAY_MONTH','=',10)->sum('SALARYALL_PAY_AMOUNT');
        $m11_2 = DB::table('salary_all_pay')->where('SALARYALL_PAY_YEAR','=',$yearbudget)->where('SALARYALL_PAY_MONTH','=',11)->sum('SALARYALL_PAY_AMOUNT');
        $m12_2 = DB::table('salary_all_pay')->where('SALARYALL_PAY_YEAR','=',$yearbudget)->where('SALARYALL_PAY_MONTH','=',12)->sum('SALARYALL_PAY_AMOUNT');


    
        return view('manager_compensation.dashboard_compensation',[
            'count1' => $count1,
            'count2' => $count2,
            'count3' => $count3,
            'm1_1' => $m1_1,
            'm2_1' => $m2_1,
            'm3_1' => $m3_1,
            'm4_1' => $m4_1,
            'm5_1' => $m5_1,
            'm6_1' => $m6_1,
            'm7_1' => $m7_1,
            'm8_1' => $m8_1,
            'm9_1' => $m9_1,
            'm10_1' => $m10_1,
            'm11_1' => $m11_1,
            'm12_1' => $m12_1,
            'm1_2' => $m1_2,
            'm2_2' => $m2_2,
            'm3_2' => $m3_2,
            'm4_2' => $m4_2,
            'm5_2' => $m5_2,
            'm6_2' => $m6_2,
            'm7_2' => $m7_2,
            'm8_2' => $m8_2,
            'm9_2' => $m9_2,
            'm10_2' => $m10_2,
            'm11_2' => $m11_2,
            'm12_2' => $m12_2,
            'budgets' =>  $budget,
            'year_id'=>$year_id  
        ]);
    }

    //-------------------

    public function infolistreceipt(Request $request,$type)
    {
    
        if($type == 'salary'){
            $info_receipt = Salaryreceive::where('HR_RECEIVE_TYPE','=','salary')->get();
            $countlist = Salaryreceive::where('HR_RECEIVE_TYPE','=','salary')->count();  
            
          


        }else{
            $info_receipt = Salaryreceive::where('HR_RECEIVE_TYPE','=','compen')->get();
            $countlist =  Salaryreceive::where('HR_RECEIVE_TYPE','=','compen')->count();
            
        
        }
        

  
        return view('manager_compensation.infolistreceipt',[
            'info_receipts' => $info_receipt, 
            'type' => $type,
            'countlist' => $countlist,
           
            ]);
    }

    public function infolistreceipt_excel(Request $request,$type)
    {
    
        if($type == 'salary'){
            $info_receipt = Salaryreceive::where('HR_RECEIVE_TYPE','=','salary')->get();
        }else{
            $info_receipt = Salaryreceive::where('HR_RECEIVE_TYPE','=','compen')->get();
        }
        

        return view('manager_compensation.infolistreceipt_excel',[
            'info_receipts' => $info_receipt, 
            'type' => $type
            ]);
    }



    public function infolistreceipt_save(Request $request)
    {
        

        $add = new Salaryreceive(); 
        $add->HR_RECEIVE_NAME = $request->HR_RECEIVE_NAME;
        $add->HR_RECEIVE_TYPE = $request->HR_RECEIVE_TYPE;
        $add->save();

        return redirect()->route('mcompensation.infolistreceipt',[
            'type' => $request->HR_RECEIVE_TYPE
        ]);
    }

    public function infolistreceipt_update(Request $request)
    {
        

        $update = Salaryreceive::find($request->ID);  
        $update->HR_RECEIVE_NAME = $request->HR_RECEIVE_NAME;
        $update->HR_RECEIVE_TYPE = $request->HR_RECEIVE_TYPE;
        $update->save();

        return redirect()->route('mcompensation.infolistreceipt',[
            'type' => $request->HR_RECEIVE_TYPE
        ]);
    }



    public function infolistreceipt_destroy($id,$type) { 
                
        Salaryreceive::destroy($id);         
        return redirect()->route('mcompensation.infolistreceipt',[
            'type' => $type
        ]);   
    }


   //-----
   public function infolistreceipt_infoperson(Request $request,$idlist)
   {
        $infolist = Salaryreceive::where('ID','=',$idlist)->first();           
         $infoperson =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                        ->orderBy('hrd_person.HR_FNAME', 'asc')    
                        ->get();

        $infolistperson = Salaryreceiveperson::select('salary_receive_person.ID','HR_PREFIX_NAME','salary_receive_person.SALARY_RECEIVE_ID','salary_receive_person.AMOUNT','hrd_person.HR_FNAME', 'hrd_person.HR_LNAME','hrd_person.POSITION_IN_WORK', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_NAME', 'hrd_status.HR_STATUS_NAME','HR_PERSON_TYPE_NAME','BOOK_BANK_OT_NUMBER','BOOK_BANK_NUMBER')
                        ->leftJoin('hrd_person','salary_receive_person.HR_PERSON_ID','=','hrd_person.ID')
                        ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                        ->leftJoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_SUB_ID')
                        ->leftJoin('hrd_status','hrd_person.HR_STATUS_ID','=','hrd_status.HR_STATUS_ID')
                        ->leftJoin('hrd_person_type','hrd_person.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
                        ->orderBy('salary_receive_person.ID', 'desc') 
                        ->where('SALARY_RECEIVE_ID','=',$idlist)   
                        ->get();  

        $count_list = Salaryreceiveperson::where('SALARY_RECEIVE_ID','=',$idlist)   
                        ->count(); 

        $sum_list = Salaryreceiveperson::where('SALARY_RECEIVE_ID','=',$idlist)   
                    ->sum('AMOUNT'); 

        $search = '';

       return view('manager_compensation.infolistreceipt_infoperson',[
           'infolist' => $infolist,
           'infopersons' => $infoperson,
           'infolistpersons' => $infolistperson,
           'count_list' => $count_list,
           'sum_list' => $sum_list,
           'search' =>   $search,
           ]);
   }


   public function infolistreceipt_infopersonsearch(Request $request,$idlist)
   {

    $search = $request->get('search'); 

    if($search==''){
        $search="";
    }

       $infolist = Salaryreceive::where('ID','=',$idlist)->first();

        $infoperson =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->orderBy('hrd_person.HR_FNAME', 'asc')    
        ->get();

        $infolistperson = Salaryreceiveperson::select('salary_receive_person.ID','HR_PREFIX_NAME','salary_receive_person.SALARY_RECEIVE_ID','salary_receive_person.AMOUNT','hrd_person.HR_FNAME', 'hrd_person.HR_LNAME','hrd_person.POSITION_IN_WORK', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_NAME', 'hrd_status.HR_STATUS_NAME','HR_PERSON_TYPE_NAME','BOOK_BANK_OT_NUMBER','BOOK_BANK_NUMBER')
                        ->leftJoin('hrd_person','salary_receive_person.HR_PERSON_ID','=','hrd_person.ID')
                        ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                        ->leftJoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_SUB_ID')
                        ->leftJoin('hrd_status','hrd_person.HR_STATUS_ID','=','hrd_status.HR_STATUS_ID')
                        ->leftJoin('hrd_person_type','hrd_person.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
                     
                        ->where('SALARY_RECEIVE_ID','=',$idlist)   
                        ->where(function($q) use ($search){
                            $q->where('HR_FNAME','like','%'.$search.'%');
                            $q->orwhere('HR_LNAME','like','%'.$search.'%');  
                            $q->orwhere('POSITION_IN_WORK','like','%'.$search.'%');
                            $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');
                            $q->orwhere('HR_PERSON_TYPE_NAME','like','%'.$search.'%');
              
                        })
                        ->orderBy('salary_receive_person.ID', 'desc')
                        ->get();  

        $count_list = Salaryreceiveperson::select('salary_receive_person.ID','salary_receive_person.SALARY_RECEIVE_ID','salary_receive_person.AMOUNT','hrd_person.HR_FNAME', 'hrd_person.HR_LNAME','hrd_person.POSITION_IN_WORK', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_NAME', 'hrd_status.HR_STATUS_NAME','HR_PERSON_TYPE_NAME')
        ->leftJoin('hrd_person','salary_receive_person.HR_PERSON_ID','=','hrd_person.ID')
        ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_SUB_ID')
        ->leftJoin('hrd_status','hrd_person.HR_STATUS_ID','=','hrd_status.HR_STATUS_ID')
        ->leftJoin('hrd_person_type','hrd_person.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
     
        ->where('SALARY_RECEIVE_ID','=',$idlist)   
        ->where(function($q) use ($search){
            $q->where('HR_FNAME','like','%'.$search.'%');
            $q->orwhere('HR_LNAME','like','%'.$search.'%');  
            $q->orwhere('POSITION_IN_WORK','like','%'.$search.'%');
            $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');
            $q->orwhere('HR_PERSON_TYPE_NAME','like','%'.$search.'%');

        }) 
        ->count();  

        $sum_list = Salaryreceiveperson::select('salary_receive_person.ID','salary_receive_person.SALARY_RECEIVE_ID','salary_receive_person.AMOUNT','hrd_person.HR_FNAME', 'hrd_person.HR_LNAME','hrd_person.POSITION_IN_WORK', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_NAME', 'hrd_status.HR_STATUS_NAME','HR_PERSON_TYPE_NAME')
        ->leftJoin('hrd_person','salary_receive_person.HR_PERSON_ID','=','hrd_person.ID')
        ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_SUB_ID')
        ->leftJoin('hrd_status','hrd_person.HR_STATUS_ID','=','hrd_status.HR_STATUS_ID')
        ->leftJoin('hrd_person_type','hrd_person.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
        ->where('SALARY_RECEIVE_ID','=',$idlist)   
        ->where(function($q) use ($search){
            $q->where('HR_FNAME','like','%'.$search.'%');
            $q->orwhere('HR_LNAME','like','%'.$search.'%');  
            $q->orwhere('POSITION_IN_WORK','like','%'.$search.'%');
            $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');
            $q->orwhere('HR_PERSON_TYPE_NAME','like','%'.$search.'%');

        })
        ->orderBy('hrd_person.HR_FNAME', 'asc') 
        ->sum('AMOUNT'); 

       

       return view('manager_compensation.infolistreceipt_infoperson',[
           'infolist' => $infolist,
           'infopersons' => $infoperson,
           'infolistpersons' => $infolistperson,
           'count_list' => $count_list,
           'sum_list' => $sum_list,
           'search' =>   $search,
           ]);
   }




   public function infolistreceipt_infopersonexcel(Request $request,$idlist)
   {
       $infolist = Salaryreceive::where('ID','=',$idlist)->first();
       $infoperson =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                        ->orderBy('hrd_person.HR_FNAME', 'asc')    
                        ->get();

        $infolistperson = Salaryreceiveperson::select('salary_receive_person.ID','HR_PREFIX_NAME','salary_receive_person.SALARY_RECEIVE_ID','salary_receive_person.AMOUNT','hrd_person.HR_FNAME', 'hrd_person.HR_LNAME','hrd_person.POSITION_IN_WORK', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_NAME', 'hrd_status.HR_STATUS_NAME','HR_PERSON_TYPE_NAME')
                        ->leftJoin('hrd_person','salary_receive_person.HR_PERSON_ID','=','hrd_person.ID')
                        ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                        ->leftJoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_SUB_ID')
                        ->leftJoin('hrd_status','hrd_person.HR_STATUS_ID','=','hrd_status.HR_STATUS_ID')
                        ->leftJoin('hrd_person_type','hrd_person.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
                        ->orderBy('hrd_person.HR_FNAME', 'asc') 
                        ->where('SALARY_RECEIVE_ID','=',$idlist)   
                        ->get();  

        $count_list = Salaryreceiveperson::where('SALARY_RECEIVE_ID','=',$idlist)   
                        ->count(); 

        $sum_list = Salaryreceiveperson::where('SALARY_RECEIVE_ID','=',$idlist)   
                    ->sum('AMOUNT'); 

       return view('manager_compensation.infolistreceipt_infopersonexcel',[
           'infolist' => $infolist,
           'infopersons' => $infoperson,
           'infolistpersons' => $infolistperson,
           'count_list' => $count_list,
           'sum_list' => $sum_list
           ]);
   }



   

   public function infolistreceipt_infopersonsave(Request $request)
   {
       
        
       $add = new Salaryreceiveperson(); 
       $add->HR_PERSON_ID = $request->HR_PERSON_ID;
       $add->SALARY_RECEIVE_ID = $request->SALARY_RECEIVE_ID;
       $add->AMOUNT = $request->AMOUNT;
       $add->save();
       
    
       return redirect()->route('mcompensation.infolistreceipt_infoperson',[
       'idlist' => $request->SALARY_RECEIVE_ID]);
   }


   function updateamountreceipt(Request $request)
   {  
       $id = $request->idreceipt;
       
       $updateamountreceipt = Salaryreceiveperson::find($id);
       $updateamountreceipt->AMOUNT = $request->value;
       $updateamountreceipt->save();
   }


        public function infolistreceipt_infopersondestroy($id,$idlist) { 
                        
            Salaryreceiveperson::destroy($id);         
        
            return redirect()->route('mcompensation.infolistreceipt_infoperson',[
                'idlist' => $idlist]);
        }

            function summoneyreceipt(Request $request)
            {  
                $idlist = $request->idlist;
                $sum_list = Salaryreceiveperson::where('SALARY_RECEIVE_ID','=',$idlist)    
                ->sum('AMOUNT');     
                echo number_format($sum_list,2);
            }
 //==========================เพิ่มรายการค่าตอบแทน

 
 public function infolistreceipt_infootsave(Request $request)
 {
     
    $OT_YEAR = $request->OT_YEAR;
    $MONTH_OT = $request->MONTH_OT;
    $SALARY_RECEIVE_ID = $request->SALARY_RECEIVE_ID;

    $OT_TYPE = $SALARY_RECEIVE_ID -2;

    $infoloops = DB::table('ot_index_sub')
    ->select(DB::raw('count(*) as count,SUM(OT_SUM) as total_sum,OT_PERSON_ID'))
    ->leftjoin('ot_index','ot_index.OT_INDEX_ID','=','ot_index_sub.OT_INDEX_ID')
    ->where('ot_index.OT_TYPE','=',$OT_TYPE)
    ->where('ot_index.OT_MONTH','=',$MONTH_OT)
    ->where('ot_index.OT_YEAR','=',$OT_YEAR)
    ->groupBy('OT_PERSON_ID')->get();
   
      
    foreach ($infoloops as $infoloop) {

        $add = new Salaryreceiveperson(); 
        $add->HR_PERSON_ID = $infoloop->OT_PERSON_ID;
        $add->SALARY_RECEIVE_ID = $SALARY_RECEIVE_ID;
        $add->AMOUNT = $infoloop->total_sum;
        $add->save();
        
      
        }
    

  
     return redirect()->route('mcompensation.infolistreceipt_infoperson',[
     'idlist' => $SALARY_RECEIVE_ID]);
 }


             //=================================เพิ่มรายการรับทั้งหมด

  public function infolistreceipt_infopersonsaveall(Request $request,$receivid)
  {
      
    Salaryreceiveperson::where('SALARY_RECEIVE_ID', '=', $receivid)->delete();

    $infopersons =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->orderBy('hrd_person.HR_FNAME', 'asc')    
    ->get();

    foreach ($infopersons as $infoperson) {

    


                if($receivid == '1'){

                    $AMOUNT = DB::table('hrd_person')->where('ID','=',$infoperson->ID)->first();

                $add = new Salaryreceiveperson(); 
                $add->HR_PERSON_ID = $infoperson->ID;
                $add->SALARY_RECEIVE_ID = $receivid;
                $add->AMOUNT = $AMOUNT->HR_SALARY;
                $add->save();


                }else{
                
                    $add = new Salaryreceiveperson(); 
                    $add->HR_PERSON_ID = $infoperson->ID;
                    $add->SALARY_RECEIVE_ID = $receivid;
                    $add->save();


                }

    }

    return redirect()->route('mcompensation.infolistreceipt_infoperson',[
    'idlist' => $receivid]);

    }


  //========================================ลบรายการรับทั้งหมด
  
  public function infolistreceipt_infopersondeleteall(Request $request,$receivid)
  {

    Salaryreceiveperson::where('SALARY_RECEIVE_ID', '=', $receivid)->delete();
      return redirect()->route('mcompensation.infolistreceipt_infoperson',[
        'idlist' => $receivid]);
    
  }

//========================================เพิ่มค่าทั้งหมด


public function infolistreceipt_infovalueall(Request $request)
{
   $allvalue = $request->allvalue;
   $idlist = $request->idlist;

   Salaryreceiveperson::where('SALARY_RECEIVE_ID', '=', $idlist)->update(['AMOUNT' => $allvalue]);

    return redirect()->route('mcompensation.infolistreceipt_infoperson',[
      'idlist' => $idlist]);
  
}



  //=====================================รายการจ่าย========
    public function infolistpay(Request $request,$type)
    {

        if($type == 'salary'){
            $info_pay =  Salarypay::where('HR_PAY_TYPE','=','salary')->orderBy('ID', 'asc')->get();
            $countlist =  Salarypay::where('HR_PAY_TYPE','=','salary')->count();

        }else{
            $info_pay =  Salarypay::where('HR_PAY_TYPE','=','compen')->orderBy('ID', 'asc')->get();
            $countlist =  Salarypay::where('HR_PAY_TYPE','=','compen')->count();
           
        }
        
    
        return view('manager_compensation.infolistpay',[
            'info_pays' => $info_pay, 
            'type' => $type,
            'countlist' => $countlist,
            ]);
    }

    public function infolistpay_excel(Request $request,$type)
    {

        if($type == 'salary'){
            $info_pay =  Salarypay::where('HR_PAY_TYPE','=','salary')->get();

        }else{
            $info_pay =  Salarypay::where('HR_PAY_TYPE','=','compen')->get();
           
        }
        
    
        return view('manager_compensation.infolistpay_excel',[
            'info_pays' => $info_pay, 
            'type' => $type ]);
    }



    public function infolistpay_save(Request $request)
    {
        
        
        $add = new Salarypay(); 
        $add->HR_PAY_NAME = $request->HR_PAY_NAME;
        $add->HR_PAY_TYPE = $request->HR_PAY_TYPE;
        $add->HR_PAY_CAL = 'notuse';
        $add->save();


        return redirect()->route('mcompensation.infolistpay',[
            'type' => $request->HR_PAY_TYPE
        ]);
    }

    public function infolistpay_update(Request $request)
    {
        

        $update = Salarypay::find($request->ID);  
        $update->HR_PAY_NAME = $request->HR_PAY_NAME;
        $update->HR_PAY_TYPE = $request->HR_PAY_TYPE;
        $update->HR_PAY_CAL = $request->HR_PAY_CAL;
        $update->save();

       

        return redirect()->route('mcompensation.infolistpay',[
            'type' => $request->HR_PAY_TYPE
        ]);
    }



    public function infolistpay_destroy($id,$type) { 
                
        Salarypay::destroy($id);          
        return redirect()->route('mcompensation.infolistpay',[
            'type' => $type
        ]);   
    }

    //---
    public function infolistpay_infoperson(Request $request,$idlist)
    {
        $infolist = Salarypay::where('ID','=',$idlist)->first();
        $infoperson =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->orderBy('hrd_person.HR_FNAME', 'asc')    
        ->get();

        $infolistperson = Salarypayperson::select('salary_pay_person.ID','HR_PREFIX_NAME','salary_pay_person.SALARY_PAY_ID','salary_pay_person.AMOUNT','hrd_person.HR_FNAME', 'hrd_person.HR_LNAME','hrd_person.POSITION_IN_WORK', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_NAME','hrd_status.HR_STATUS_NAME','HR_PERSON_TYPE_NAME','HR_SALARY','BOOK_BANK_OT_NUMBER','BOOK_BANK_NUMBER')
        ->leftJoin('hrd_person','salary_pay_person.HR_PERSON_ID','=','hrd_person.ID')
        ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_status','hrd_person.HR_STATUS_ID','=','hrd_status.HR_STATUS_ID')
        ->leftJoin('hrd_person_type','hrd_person.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
        ->leftJoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_SUB_ID')
        ->orderBy('salary_pay_person.ID', 'desc')
        ->where('SALARY_PAY_ID','=',$idlist)   
        ->get();               

        $count_list = Salarypayperson::where('SALARY_PAY_ID','=',$idlist)   
        ->count();    
        
        $sum_list = Salarypayperson::where('SALARY_PAY_ID','=',$idlist)   
        ->sum('AMOUNT');    
        
        $search = '';

        return view('manager_compensation.infolistpay_infoperson',[
            'infolist' => $infolist,
            'infopersons' => $infoperson,
            'infolistpersons' => $infolistperson,
            'count_list' => $count_list,
            'sum_list' => $sum_list,
            'search' => $search
             ]);
    }

    public function infolistpay_infopersonsearch(Request $request,$idlist)
    {

        $search = $request->get('search'); 

        if($search==''){
            $search="";
        }


        $infolist = Salarypay::where('ID','=',$idlist)->first();
        $infoperson =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->orderBy('hrd_person.HR_FNAME', 'asc')    
        ->get();

        $infolistperson = Salarypayperson::select('salary_pay_person.ID','HR_PREFIX_NAME','salary_pay_person.SALARY_PAY_ID','salary_pay_person.AMOUNT','hrd_person.HR_FNAME', 'hrd_person.HR_LNAME','hrd_person.POSITION_IN_WORK', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_NAME','hrd_status.HR_STATUS_NAME','HR_PERSON_TYPE_NAME','HR_SALARY','BOOK_BANK_OT_NUMBER','BOOK_BANK_NUMBER')
        ->leftJoin('hrd_person','salary_pay_person.HR_PERSON_ID','=','hrd_person.ID')
        ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_status','hrd_person.HR_STATUS_ID','=','hrd_status.HR_STATUS_ID')
        ->leftJoin('hrd_person_type','hrd_person.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
        ->leftJoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_SUB_ID')
        ->orderBy('salary_pay_person.ID', 'desc')
        ->where('SALARY_PAY_ID','=',$idlist)  
        ->where(function($q) use ($search){
            $q->where('HR_FNAME','like','%'.$search.'%');
            $q->orwhere('HR_LNAME','like','%'.$search.'%');  
            $q->orwhere('POSITION_IN_WORK','like','%'.$search.'%');
            $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');
            $q->orwhere('HR_PERSON_TYPE_NAME','like','%'.$search.'%');

        }) 
        ->get();               

        $count_list = Salarypayperson::select('salary_pay_person.ID','salary_pay_person.SALARY_PAY_ID','salary_pay_person.AMOUNT','hrd_person.HR_FNAME', 'hrd_person.HR_LNAME','hrd_person.POSITION_IN_WORK', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_NAME','hrd_status.HR_STATUS_NAME','HR_PERSON_TYPE_NAME','HR_SALARY')
        ->leftJoin('hrd_person','salary_pay_person.HR_PERSON_ID','=','hrd_person.ID')
        ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_status','hrd_person.HR_STATUS_ID','=','hrd_status.HR_STATUS_ID')
        ->leftJoin('hrd_person_type','hrd_person.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
        ->leftJoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_SUB_ID')
        ->orderBy('hrd_person.HR_FNAME', 'asc') 
        ->where('SALARY_PAY_ID','=',$idlist)  
        ->where(function($q) use ($search){
            $q->where('HR_FNAME','like','%'.$search.'%');
            $q->orwhere('HR_LNAME','like','%'.$search.'%');  
            $q->orwhere('POSITION_IN_WORK','like','%'.$search.'%');
            $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');
            $q->orwhere('HR_PERSON_TYPE_NAME','like','%'.$search.'%');

        }) 
        ->count();    
        
        $sum_list = Salarypayperson::select('salary_pay_person.ID','salary_pay_person.SALARY_PAY_ID','salary_pay_person.AMOUNT','hrd_person.HR_FNAME', 'hrd_person.HR_LNAME','hrd_person.POSITION_IN_WORK', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_NAME','hrd_status.HR_STATUS_NAME','HR_PERSON_TYPE_NAME','HR_SALARY')
        ->leftJoin('hrd_person','salary_pay_person.HR_PERSON_ID','=','hrd_person.ID')
        ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_status','hrd_person.HR_STATUS_ID','=','hrd_status.HR_STATUS_ID')
        ->leftJoin('hrd_person_type','hrd_person.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
        ->leftJoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_SUB_ID')
        ->orderBy('hrd_person.HR_FNAME', 'asc') 
        ->where('SALARY_PAY_ID','=',$idlist)  
        ->where(function($q) use ($search){
            $q->where('HR_FNAME','like','%'.$search.'%');
            $q->orwhere('HR_LNAME','like','%'.$search.'%');  
            $q->orwhere('POSITION_IN_WORK','like','%'.$search.'%');
            $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');
            $q->orwhere('HR_PERSON_TYPE_NAME','like','%'.$search.'%');

        }) 
        ->sum('AMOUNT');               

        return view('manager_compensation.infolistpay_infoperson',[
            'infolist' => $infolist,
            'infopersons' => $infoperson,
            'infolistpersons' => $infolistperson,
            'count_list' => $count_list,
            'sum_list' => $sum_list,
            'search' => $search
             ]);
    }



    public function infolistpay_infopersonexcel(Request $request,$idlist)
    {
        $infolist = Salarypay::where('ID','=',$idlist)->first();
        $infoperson =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                        ->orderBy('hrd_person.HR_FNAME', 'asc')    
                        ->get();

        $infolistperson = Salarypayperson::select('salary_pay_person.ID','HR_PREFIX_NAME','salary_pay_person.SALARY_PAY_ID','salary_pay_person.AMOUNT','hrd_person.HR_FNAME', 'hrd_person.HR_LNAME','hrd_person.POSITION_IN_WORK', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_NAME','hrd_status.HR_STATUS_NAME','HR_PERSON_TYPE_NAME','HR_SALARY')
        ->leftJoin('hrd_person','salary_pay_person.HR_PERSON_ID','=','hrd_person.ID')
        ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_status','hrd_person.HR_STATUS_ID','=','hrd_status.HR_STATUS_ID')
        ->leftJoin('hrd_person_type','hrd_person.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
        ->leftJoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_SUB_ID')
        ->orderBy('salary_pay_person.ID', 'desc')
        ->where('SALARY_PAY_ID','=',$idlist)   
        ->get();               

        $count_list = Salarypayperson::where('SALARY_PAY_ID','=',$idlist)   
        ->count();    
        
        $sum_list = Salarypayperson::where('SALARY_PAY_ID','=',$idlist)   
        ->sum('AMOUNT');               

        return view('manager_compensation.infolistpay_infopersonexcel',[
            'infolist' => $infolist,
            'infopersons' => $infoperson,
            'infolistpersons' => $infolistperson,
            'count_list' => $count_list,
            'sum_list' => $sum_list
             ]);
    }

    public function infolistpay_infopersonsave(Request $request)
    {
        
 
        $add = new Salarypayperson(); 
        $add->HR_PERSON_ID = $request->HR_PERSON_ID;
        $add->SALARY_PAY_ID = $request->SALARY_PAY_ID;
        $add->AMOUNT = $request->AMOUNT;
        $add->save();
 
 
        return redirect()->route('mcompensation.infolistpay_infoperson',[
        'idlist' => $request->SALARY_PAY_ID]);
    }

    function updateamountpay(Request $request)
    {  
        $id = $request->idpay;
        
        $updateamountpay = Salarypayperson::find($id);
        $updateamountpay->AMOUNT = $request->value;
        $updateamountpay->save();
    }

    function summoneypay(Request $request)
    {  
        $idlist = $request->idlist;
        $sum_list = Salarypayperson::where('SALARY_PAY_ID','=',$idlist)   
        ->sum('AMOUNT');     
        echo number_format($sum_list,2);
    }
 

    public function infolistpay_infopersondestroy($id,$idlist) {   
        Salarypayperson::destroy($id);         
      
        return redirect()->route('mcompensation.infolistpay_infoperson',[
            'idlist' => $idlist]);
    }



        //=================================เพิ่มรายการจ่ายทั้งหมด

  public function infolistpay_infopersonsaveall(Request $request,$receivid)
  {
      
    Salarypayperson::where('SALARY_PAY_ID', '=', $receivid)->delete();

    $infopersons =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->orderBy('hrd_person.HR_FNAME', 'asc')    
    ->get();

    foreach ($infopersons as $infoperson) {

        $add = new Salarypayperson(); 
        $add->HR_PERSON_ID = $infoperson->ID;
        $add->SALARY_PAY_ID = $receivid;
        $add->save();

    }

    return redirect()->route('mcompensation.infolistpay_infoperson',[
    'idlist' => $receivid]);

    }


  //========================================ลบรายการจ่ายทั้งหมด
  
  public function infolistpay_infopersondeleteall(Request $request,$receivid)
  {
      

    Salarypayperson::where('SALARY_PAY_ID', '=', $receivid)->delete();

      return redirect()->route('mcompensation.infolistpay_infoperson',[
        'idlist' => $receivid]);
    
  }
//========================================เพิ่มค่าทั้งหมด


public function infolistpay_infovalueall(Request $request)
{
   $allvalue = $request->allvalue;
   $idlist = $request->idlist;

    Salarypayperson::where('SALARY_PAY_ID', '=', $idlist)->update(['AMOUNT' => $allvalue]);

    return redirect()->route('mcompensation.infolistpay_infoperson',[
      'idlist' => $idlist]);
  
}


public function infolistpay_infovaluecal(Request $request)
{
   $persen = $request->persen;
   $idlist = $request->idlist;

   
   $list = Salarypayperson::leftjoin('hrd_person','hrd_person.ID','=','salary_pay_person.HR_PERSON_ID')
   ->where('SALARY_PAY_ID', '=', $idlist)
   ->get();



    foreach ($list as $info) {

        $salary =  $info->HR_SALARY;

        $totalvalue = $salary * ($persen/100);

    
        Salarypayperson::where('HR_PERSON_ID', '=', $info->HR_PERSON_ID)->update(['AMOUNT' => $totalvalue]);
        
        }

    return redirect()->route('mcompensation.infolistpay_infoperson',[
      'idlist' => $idlist]);
  
}


    //-------------ประมาวลผลเงินเดือน

    public function callcompensation()
    {
        $d_budget = date('d');
        $m_budget = date('m');
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        $month = $m_budget;
        }else{
        $yearbudget = date("Y")+543;
        $month = substr($m_budget,1);
        }

        
             
        $infoperson =  Salaryall::leftJoin('hrd_person','salary_all.SALARYALL_PERSON_ID','=','hrd_person.ID')
            ->where('SALARYALL_YEAR_ID','=',$yearbudget)
            ->where('SALARYALL_MONTH_ID','=',$month)
            ->orderBy('SALARYALL_PERSON_NAME', 'asc') 
            ->get();

        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $countinfo = Salaryall::where('SALARYALL_YEAR_ID','=',$yearbudget)->where('SALARYALL_MONTH_ID','=',$month)->count();
        $typesub ='';
        $typecode ='';

        return view('manager_compensation.callcompensation',[
            'budgets' =>  $budget,
            'year_id'=>$yearbudget, 
            'm_budget' =>$m_budget,
            'd_budget' =>$d_budget,
            'typesub' =>$typesub,
            'typecode' =>$typecode,
            'countinfo' =>$countinfo,
            'infopersons' => $infoperson ]); 
    }

    //============ประมวลผล=======

    public function callcompensationprocess(Request $request)
    {
       //-----------------บันทึกตัวประมวลเงินเดือน--------------
           $YEAR_ID = $request->YEAR_ID;
           $MONTH_ID = $request->MONTH_ID;
           $DAY_ID = $request->DAY_ID;
           
           $typecode = $request->TYPE_CODE;

           $typesub  =  $request->SUBMIT;

           $countinfo = Salaryall::where('SALARYALL_YEAR_ID','=',$YEAR_ID)->where('SALARYALL_MONTH_ID','=',$MONTH_ID)->count();

          if($typesub  == 'pocess'){
  
                    $infoperson =  Person::leftJoin('hrd_department_sub','hrd_department_sub.HR_DEPARTMENT_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_ID')
                    ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                    ->leftJoin('hrd_person_type','hrd_person.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
                    ->orderBy('HR_FNAME', 'asc') 
                    ->get();

          }elseif($typesub  == 'savepocess'){



            $addhead = new Salaryallhead(); 
            $addhead->SALARYALL_HEAD_YEAR_ID = $YEAR_ID;
            $addhead->SALARYALL_HEAD_MONTH_ID = $MONTH_ID;
            $addhead->SALARYALL_HEAD_DAY_ID = $DAY_ID;
            $addhead->SALARYALL_HEAD_TYPE = $request->TYPE_CODE;
            $infoperson = DB::table('hrd_person')->where('ID','=',$request->SALARYALL_HEAD_HR_SAVE)->first();
            $addhead->SALARYALL_HEAD_HR_SAVE = $infoperson->HR_FNAME.' '.$infoperson->HR_LNAME;
            $addhead->save();

            $SALARYALL_HEAD_ID = Salaryallhead::max('SALARYALL_HEAD_ID');  


         $infopersons =  Person::leftJoin('hrd_department_sub','hrd_department_sub.HR_DEPARTMENT_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_ID')
         ->get();

         foreach ($infopersons as $infoperson) {

            $user_id = $infoperson->ID;
            $salaryperson = Person::where('ID','=',$user_id)->first();
            $amountreceive = Salaryreceiveperson::leftjoin('salary_receive','salary_receive.ID','=','salary_receive_person.SALARY_RECEIVE_ID')
            ->where('salary_receive.ACTIVE','=','TRUE')
            ->where('HR_PERSON_ID','=',$user_id)
            ->where('HR_RECEIVE_TYPE','=',$typecode)
            ->sum('AMOUNT');


           
            $totalreceive = $amountreceive;

            $amountpay =   Salarypayperson::leftjoin('salary_pay','salary_pay.ID','=','salary_pay_person.SALARY_PAY_ID')
            ->where('salary_pay.ACTIVE','=','TRUE')
            ->where('HR_PERSON_ID','=',$user_id)
            ->where('HR_PAY_TYPE','=',$typecode)
            ->sum('AMOUNT');

            $total =   $totalreceive - $amountpay;


            $add = new Salaryall(); 
            $add->SALARYALL_HEAD_ID = $SALARYALL_HEAD_ID;
            $add->SALARYALL_YEAR_ID = $YEAR_ID;
            $add->SALARYALL_MONTH_ID = $MONTH_ID;
            $add->SALARYALL_DAY_ID = $DAY_ID;
            $add->SALARYALL_TYPE = $typecode;

            $add->SALARYALL_PERSON_ID = $infoperson->ID;
            $add->SALARYALL_PERSON_NAME = $infoperson->HR_FNAME.' '.$infoperson->HR_LNAME;
            $add->SALARYALL_SUB_NAME = $infoperson->HR_DEPARTMENT_SUB_NAME;
            $add->SALARYALL_BOOK_NUM = $infoperson->BOOK_BANK_NUMBER;

            $add->SALARYALL_TOTAL = $total;
            if($total !== 0){
                $add->save();
            }
           

            $MAX_ID = Salaryall::max('SALARYALL_ID');  

        //----------------
        $receivepersons = Salaryreceiveperson::leftJoin('salary_receive','salary_receive.ID','=','salary_receive_person.SALARY_RECEIVE_ID')
        ->where('salary_receive.ACTIVE','=','TRUE')
        ->where('HR_RECEIVE_TYPE','=',$typecode)
        ->where('HR_PERSON_ID','=',$user_id)->get();

        foreach ($receivepersons as $receiveperson) {

        $receive = new Salaryallreceive(); 
        $receive->SALARYALL_ID = $MAX_ID;
        $receive->SALARYALL_RECEIVE_YEAR = $YEAR_ID;
        $receive->SALARYALL_RECEIVE_MONTH = $MONTH_ID;
        $receive->SALARYALL_RECEIVE_DAY = $DAY_ID;
        $receive->SALARYALL_RECEIVE_TYPE = $typecode;
        $receive->SALARYALL_RECEIVE_LISTNAME = $receiveperson->HR_RECEIVE_NAME;
        $receive->SALARYALL_RECEIVE_AMOUNT = $receiveperson->AMOUNT;
        $receive->save();
        }


         //----------------
         $paypersons = Salarypayperson::leftJoin('salary_pay','salary_pay.ID','=','salary_pay_person.SALARY_PAY_ID')
         ->where('salary_pay.ACTIVE','=','TRUE')
         ->where('HR_PAY_TYPE','=',$typecode)
         ->where('HR_PERSON_ID','=',$user_id)->get();

         foreach ($paypersons as $payperson) {
         $pay = new Salaryallpay(); 
         $pay->SALARYALL_ID = $MAX_ID;
         $pay->SALARYALL_PAY_YEAR = $YEAR_ID;
         $pay->SALARYALL_PAY_MONTH = $MONTH_ID;
         $pay->SALARYALL_PAY_DAY = $DAY_ID;
         $pay->SALARYALL_PAY_TYPE = $typecode;
         $pay->SALARYALL_PAY_LISTNAME = $payperson->HR_PAY_NAME;
         $pay->SALARYALL_PAY_AMOUNT = $payperson->AMOUNT;
         $pay->save();
         }

    
        }
        //-------------------------------
     
        $infoperson =  Salaryall::leftJoin('hrd_person','salary_all.SALARYALL_PERSON_ID','=','hrd_person.ID')
        ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->where('SALARYALL_YEAR_ID','=',$YEAR_ID)
        ->where('SALARYALL_MONTH_ID','=',$MONTH_ID)
        ->orderBy('SALARYALL_PERSON_NAME', 'asc') 
        ->get();

    }else{
        
        $infoperson =  Salaryall::leftJoin('hrd_person','salary_all.SALARYALL_PERSON_ID','=','hrd_person.ID')
        ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
           ->where('SALARYALL_YEAR_ID','=',$YEAR_ID)
            ->where('SALARYALL_MONTH_ID','=',$MONTH_ID)
            ->orderBy('SALARYALL_PERSON_NAME', 'asc') 
            ->get();
    
       
    }

        $m_budget = $MONTH_ID;
        $yearbudget =  $YEAR_ID;
        $d_budget =  $DAY_ID;
    
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        if($typesub  == 'savepocess'){

            
            return redirect()->route('mcompensation.infodetailcompensation'); 

        }else{

            return view('manager_compensation.callcompensation',[
                'budgets' =>  $budget,
                'year_id'=>$yearbudget, 
                'm_budget' =>$m_budget, 
                'd_budget' =>$d_budget,
                'infopersons' => $infoperson,
                'typesub' =>$typesub,
                'typecode' =>$typecode,
                'countinfo' =>$countinfo,
                'countinfo'=>$countinfo]);
        }


}
        
    
     


    //=========================================







    public function infocompensation()
    {
        $infoperson =  Person::get();
        return view('manager_compensation.infocompensation',[
            'infopersons' => $infoperson ]);
    }

    //==================ฟังชันทดสอบการทำงาน
    //---------------------------------จำนวนรายได้สุทธิ
    public static function call_all($user_id,$type_code)
{
        $salaryperson = Person::where('ID','=',$user_id)->first();

        $amountreceive = Salaryreceiveperson::leftjoin('salary_receive','salary_receive.ID','=','salary_receive_person.SALARY_RECEIVE_ID')
                        ->where('salary_receive.ACTIVE','=','TRUE')
                        ->where('HR_PERSON_ID','=',$user_id)
                        ->where('HR_RECEIVE_TYPE','=',$type_code)
                        ->sum('AMOUNT');
   
       
        $totalreceive =   $amountreceive;

        $amountpay =   Salarypayperson::leftjoin('salary_pay','salary_pay.ID','=','salary_pay_person.SALARY_PAY_ID')
                        ->where('salary_pay.ACTIVE','=','TRUE')    
                        ->where('HR_PERSON_ID','=',$user_id)
                        ->where('HR_PAY_TYPE','=',$type_code)
                        ->sum('AMOUNT');

       

        $total =   $totalreceive - $amountpay;

        return $total;
}


  


public static function call_receive($user_id,$type_code)
{
        $salaryperson = Person::where('ID','=',$user_id)->first();

        $amountreceive = Salaryreceiveperson::leftjoin('salary_receive','salary_receive.ID','=','salary_receive_person.SALARY_RECEIVE_ID')
                        ->where('salary_receive.ACTIVE','=','TRUE')
                        ->where('HR_PERSON_ID','=',$user_id)
                        ->where('HR_RECEIVE_TYPE','=',$type_code)
                        ->sum('AMOUNT');
   


        return $amountreceive;
}

public static function call_receive_type($salary_head,$user_id,$type_name,$year,$month,$day)
{

     $amountrecive = Salaryallreceive::select('salary_all_receive.SALARYALL_RECEIVE_AMOUNT')
     ->leftjoin('salary_all','salary_all_receive.SALARYALL_ID','=','salary_all.SALARYALL_ID')
     ->where('salary_all.SALARYALL_TYPE','=',$salary_head)
     ->where('salary_all.SALARYALL_PERSON_ID','=',$user_id)
     ->where('salary_all_receive.SALARYALL_RECEIVE_LISTNAME','=',$type_name)
     ->where('salary_all.SALARYALL_YEAR_ID','=',$year)
     ->where('salary_all.SALARYALL_MONTH_ID','=',$month)
     ->where('salary_all.SALARYALL_DAY_ID','=',$day)
     ->first();
     
     if($amountrecive  == null || $amountrecive->SALARYALL_RECEIVE_AMOUNT  == '' ){
        $ountput = 0;
     }else{
        $ountput = $amountrecive->SALARYALL_RECEIVE_AMOUNT;
     }

    return $ountput;
}


public static function call_receive_type_sumperson($salary_head,$type_name,$year,$month,$day)
{

     $amountrecive = Salaryallreceive::select('salary_all_receive.SALARYALL_RECEIVE_AMOUNT')
     ->leftjoin('salary_all','salary_all_receive.SALARYALL_ID','=','salary_all.SALARYALL_ID')
     ->where('salary_all.SALARYALL_TYPE','=',$salary_head)
     ->where('salary_all_receive.SALARYALL_RECEIVE_LISTNAME','=',$type_name)
     ->where('salary_all.SALARYALL_YEAR_ID','=',$year)
     ->where('salary_all.SALARYALL_MONTH_ID','=',$month)
     ->where('salary_all.SALARYALL_DAY_ID','=',$day)
     ->sum('SALARYALL_RECEIVE_AMOUNT');
     
     if($amountrecive  == null ){
        $ountput = 0;
     }else{
        $ountput = $amountrecive;
     }

    return $ountput;
}

public static function call_receive_type_sum($salary_head,$user_id,$year,$month,$day)
{
     $amountrecivesum = Salaryallreceive::select('salary_all_receive.SALARYALL_RECEIVE_AMOUNT')
     ->leftjoin('salary_all','salary_all_receive.SALARYALL_ID','=','salary_all.SALARYALL_ID')
     ->where('salary_all.SALARYALL_TYPE','=',$salary_head)
     ->where('salary_all.SALARYALL_PERSON_ID','=',$user_id)
     ->where('salary_all.SALARYALL_YEAR_ID','=',$year)
     ->where('salary_all.SALARYALL_MONTH_ID','=',$month)
     ->where('salary_all.SALARYALL_DAY_ID','=',$day)
     ->sum('SALARYALL_RECEIVE_AMOUNT');
     
  

    return $amountrecivesum;
}

public static function call_receive_type_sumallperson($salary_head,$year,$month,$day)
{
     $amountrecivesum = Salaryallreceive::select('salary_all_receive.SALARYALL_RECEIVE_AMOUNT')
     ->leftjoin('salary_all','salary_all_receive.SALARYALL_ID','=','salary_all.SALARYALL_ID')
     ->where('salary_all.SALARYALL_TYPE','=',$salary_head)
     ->where('salary_all.SALARYALL_YEAR_ID','=',$year)
     ->where('salary_all.SALARYALL_MONTH_ID','=',$month)
     ->where('salary_all.SALARYALL_DAY_ID','=',$day)
     ->sum('SALARYALL_RECEIVE_AMOUNT');
     
  

    return $amountrecivesum;
}


public static function call_pay_type($salary_head,$user_id,$type_name,$year,$month,$day)
{
     $amountpay = Salaryallpay::select('salary_all_pay.SALARYALL_PAY_AMOUNT')
     ->leftjoin('salary_all','salary_all_pay.SALARYALL_ID','=','salary_all.SALARYALL_ID')
     ->where('salary_all.SALARYALL_TYPE','=',$salary_head)
     ->where('salary_all.SALARYALL_PERSON_ID','=',$user_id)
     ->where('salary_all_pay.SALARYALL_PAY_LISTNAME','=',$type_name)
     ->where('salary_all.SALARYALL_YEAR_ID','=',$year)
     ->where('salary_all.SALARYALL_MONTH_ID','=',$month)
     ->where('salary_all.SALARYALL_DAY_ID','=',$day)
     ->first();
     
     if($amountpay  == null || $amountpay->SALARYALL_PAY_AMOUNT  == '' ){
        $ountput = 0;
     }else{
        $ountput = $amountpay->SALARYALL_PAY_AMOUNT;
     }
    return $ountput;
}


public static function call_pay_type_sumperson($salary_head,$type_name,$year,$month,$day)
{
 
   

     $amountpaysum = Salaryallpay::select('salary_all_pay.SALARYALL_PAY_AMOUNT')
     ->leftjoin('salary_all','salary_all_pay.SALARYALL_ID','=','salary_all.SALARYALL_ID')
     ->where('salary_all.SALARYALL_TYPE','=',$salary_head)
     ->where('salary_all_pay.SALARYALL_PAY_LISTNAME','=',$type_name)
     ->where('salary_all.SALARYALL_YEAR_ID','=',$year)
     ->where('salary_all.SALARYALL_MONTH_ID','=',$month)
     ->where('salary_all.SALARYALL_DAY_ID','=',$day)
     ->sum('SALARYALL_PAY_AMOUNT');
     
     if($amountpaysum  == null ){
        $ountput = 0;
     }else{
        $ountput = $amountpaysum;
     }

    return $ountput;
}

public static function call_pay_type_sum($salary_head,$user_id,$year,$month,$day)
{
 
     $amountpaysum = Salaryallpay::select('salary_all_pay.SALARYALL_PAY_AMOUNT')
     ->leftjoin('salary_all','salary_all_pay.SALARYALL_ID','=','salary_all.SALARYALL_ID')
     ->where('salary_all.SALARYALL_TYPE','=',$salary_head)
     ->where('salary_all.SALARYALL_PERSON_ID','=',$user_id)
     ->where('salary_all.SALARYALL_YEAR_ID','=',$year)
     ->where('salary_all.SALARYALL_MONTH_ID','=',$month)
     ->where('salary_all.SALARYALL_DAY_ID','=',$day)
     ->sum('SALARYALL_PAY_AMOUNT');
     
  

    return $amountpaysum;
}


public static function call_pay_type_sumallperson($salary_head,$year,$month,$day)
{
 
     $amountpaysum = Salaryallpay::select('salary_all_pay.SALARYALL_PAY_AMOUNT')
     ->leftjoin('salary_all','salary_all_pay.SALARYALL_ID','=','salary_all.SALARYALL_ID')
     ->where('salary_all.SALARYALL_TYPE','=',$salary_head)
     ->where('salary_all.SALARYALL_YEAR_ID','=',$year)
     ->where('salary_all.SALARYALL_MONTH_ID','=',$month)
     ->where('salary_all.SALARYALL_DAY_ID','=',$day)
     ->sum('SALARYALL_PAY_AMOUNT');
     
  

    return $amountpaysum;
}



public static function call_pay($user_id,$type_code)
{
        $salaryperson = Person::where('ID','=',$user_id)->first();

        $amountpay =   Salarypayperson::leftjoin('salary_pay','salary_pay.ID','=','salary_pay_person.SALARY_PAY_ID')
                        ->where('salary_pay.ACTIVE','=','TRUE')
                        ->where('HR_PERSON_ID','=',$user_id)
                        ->where('HR_PAY_TYPE','=',$type_code)
                        ->sum('AMOUNT');


        return $amountpay;
}




public static function call_sum($type_code)
{

    $amountreceive = Salaryreceiveperson::leftjoin('salary_receive','salary_receive.ID','=','salary_receive_person.SALARY_RECEIVE_ID')
                    ->where('salary_receive.ACTIVE','=','TRUE')
                    ->where('HR_RECEIVE_TYPE','=',$type_code)
                    ->sum('AMOUNT');
   
    $totalreceive =   $amountreceive;

    $amountpay =   Salarypayperson::leftjoin('salary_pay','salary_pay.ID','=','salary_pay_person.SALARY_PAY_ID')
                    ->where('salary_pay.ACTIVE','=','TRUE')
                    ->where('HR_PAY_TYPE','=',$type_code)
                    ->sum('AMOUNT');

    $total =   $totalreceive - $amountpay;

    return $total;
}

//-------------------------------------คำนวณจำแนกตามประเภทบุคคล
public static function calltp_receive_type($salary_head,$persontype_id,$type_name,$year,$month,$day)
{

     $amountrecivecalltp = Salaryallreceive::select('salary_all_receive.SALARYALL_RECEIVE_AMOUNT')
     ->leftjoin('salary_all','salary_all_receive.SALARYALL_ID','=','salary_all.SALARYALL_ID')
     ->leftjoin('hrd_person','salary_all.SALARYALL_PERSON_ID','=','hrd_person.ID')
     ->where('hrd_person.HR_PERSON_TYPE_ID','=',$persontype_id)
     ->where('salary_all.SALARYALL_TYPE','=',$salary_head)
     ->where('salary_all_receive.SALARYALL_RECEIVE_LISTNAME','=',$type_name)
     ->where('salary_all.SALARYALL_YEAR_ID','=',$year)
     ->where('salary_all.SALARYALL_MONTH_ID','=',$month)
     ->where('salary_all.SALARYALL_DAY_ID','=',$day)
     ->sum('SALARYALL_RECEIVE_AMOUNT');
     
     if($amountrecivecalltp   == null){
        $ountput = 0;
     }else{
        $ountput =  $amountrecivecalltp;
     }

    return $ountput;
}

public static function calltp_receive_type_sum($salary_head,$persontype_id,$year,$month,$day)
{

     $amountrecivecalltp = Salaryallreceive::select('salary_all_receive.SALARYALL_RECEIVE_AMOUNT')
     ->leftjoin('salary_all','salary_all_receive.SALARYALL_ID','=','salary_all.SALARYALL_ID')
     ->leftjoin('hrd_person','salary_all.SALARYALL_PERSON_ID','=','hrd_person.ID')
     ->where('hrd_person.HR_PERSON_TYPE_ID','=',$persontype_id)
     ->where('salary_all.SALARYALL_TYPE','=',$salary_head)
     ->where('salary_all.SALARYALL_YEAR_ID','=',$year)
     ->where('salary_all.SALARYALL_MONTH_ID','=',$month)
     ->where('salary_all.SALARYALL_DAY_ID','=',$day)
     ->sum('SALARYALL_RECEIVE_AMOUNT');
     
     if($amountrecivecalltp   == null){
        $ountput = 0;
     }else{
        $ountput =  $amountrecivecalltp;
     }

    return $ountput;
}



public static function calltp_pay_type($salary_head,$persontype_id,$type_name,$year,$month,$day)
{
     $amountpayalltp = Salaryallpay::select('salary_all_pay.SALARYALL_PAY_AMOUNT')
     ->leftjoin('salary_all','salary_all_pay.SALARYALL_ID','=','salary_all.SALARYALL_ID')
     ->leftjoin('hrd_person','salary_all.SALARYALL_PERSON_ID','=','hrd_person.ID')
     ->where('hrd_person.HR_PERSON_TYPE_ID','=',$persontype_id)
     ->where('salary_all.SALARYALL_TYPE','=',$salary_head)
     ->where('salary_all_pay.SALARYALL_PAY_LISTNAME','=',$type_name)
     ->where('salary_all.SALARYALL_YEAR_ID','=',$year)
     ->where('salary_all.SALARYALL_MONTH_ID','=',$month)
     ->where('salary_all.SALARYALL_DAY_ID','=',$day)
     ->sum('SALARYALL_PAY_AMOUNT');
     
     if($amountpayalltp  == null ){
        $ountput = 0;
     }else{
        $ountput = $amountpayalltp;
     }
    return $ountput;
}


public static function calltp_pay_type_sum($salary_head,$persontype_id,$year,$month,$day)
{
     $amountpayalltp = Salaryallpay::select('salary_all_pay.SALARYALL_PAY_AMOUNT')
     ->leftjoin('salary_all','salary_all_pay.SALARYALL_ID','=','salary_all.SALARYALL_ID')
     ->leftjoin('hrd_person','salary_all.SALARYALL_PERSON_ID','=','hrd_person.ID')
     ->where('hrd_person.HR_PERSON_TYPE_ID','=',$persontype_id)
     ->where('salary_all.SALARYALL_TYPE','=',$salary_head)
     ->where('salary_all.SALARYALL_YEAR_ID','=',$year)
     ->where('salary_all.SALARYALL_MONTH_ID','=',$month)
     ->where('salary_all.SALARYALL_DAY_ID','=',$day)
     ->sum('SALARYALL_PAY_AMOUNT');


     
     if($amountpayalltp  == null ){
        $ountput = 0;
     }else{
        $ountput = $amountpayalltp;
     }
    return $ountput;
}



 //---------------------------------จำนวนรายได้สุทธิ
 public static function callock_all($user_id,$type_code,$year,$month,$day)
 {
  
 
         $amountreceive = DB::table('salary_all_receive')
         ->leftjoin('salary_all','salary_all.SALARYALL_ID','=','salary_all_receive.SALARYALL_ID')
         ->where('salary_all_receive.SALARYALL_RECEIVE_TYPE','=',$type_code)
         ->where('SALARYALL_PERSON_ID','=',$user_id)
         ->where('salary_all_receive.SALARYALL_RECEIVE_DAY','=',$day)
         ->where('salary_all_receive.SALARYALL_RECEIVE_MONTH','=',$month)
         ->where('salary_all_receive.SALARYALL_RECEIVE_YEAR','=',$year)
         ->sum('SALARYALL_RECEIVE_AMOUNT');               
         
    
        
         $totalreceive =   $amountreceive;
 
         $amountpay =  DB::table('salary_all_pay')
         ->leftjoin('salary_all','salary_all.SALARYALL_ID','=','salary_all_pay.SALARYALL_ID')
         ->where('salary_all_pay.SALARYALL_PAY_TYPE','=',$type_code)
         ->where('SALARYALL_PERSON_ID','=',$user_id)
         ->where('salary_all_pay.SALARYALL_PAY_DAY','=',$day)
         ->where('salary_all_pay.SALARYALL_PAY_MONTH','=',$month)
         ->where('salary_all_pay.SALARYALL_PAY_YEAR','=',$year)
         ->sum('SALARYALL_PAY_AMOUNT');   
        
 
         $total =   $totalreceive - $amountpay;
 
         return $total;
 }
 
 
 public static function callock_receive($user_id,$type_code,$year,$month,$day)
 {
        
 
         $amountreceive =DB::table('salary_all_receive')
         ->leftjoin('salary_all','salary_all.SALARYALL_ID','=','salary_all_receive.SALARYALL_ID')
         ->where('salary_all_receive.SALARYALL_RECEIVE_TYPE','=',$type_code)
         ->where('SALARYALL_PERSON_ID','=',$user_id)
         ->where('salary_all_receive.SALARYALL_RECEIVE_DAY','=',$day)
         ->where('salary_all_receive.SALARYALL_RECEIVE_MONTH','=',$month)
         ->where('salary_all_receive.SALARYALL_RECEIVE_YEAR','=',$year)
         ->sum('SALARYALL_RECEIVE_AMOUNT');               
    
 
 
         return $amountreceive;
 }
 
 
 
 public static function callock_pay($user_id,$type_code,$year,$month,$day)
 {
        
 
 
         $amountpay =   DB::table('salary_all_pay')
         ->leftjoin('salary_all','salary_all.SALARYALL_ID','=','salary_all_pay.SALARYALL_ID')
         ->where('salary_all_pay.SALARYALL_PAY_TYPE','=',$type_code)
         ->where('SALARYALL_PERSON_ID','=',$user_id)
         ->where('salary_all_pay.SALARYALL_PAY_DAY','=',$day)
         ->where('salary_all_pay.SALARYALL_PAY_MONTH','=',$month)
         ->where('salary_all_pay.SALARYALL_PAY_YEAR','=',$year)
         ->sum('SALARYALL_PAY_AMOUNT');   
        
 
         return $amountpay;
 }
 
 


 //---------------------------------จำนวนรายจ่าย จำนวนรายรับ
 public static function salarydetailperson(Request $request)
 {
    
    $salaryallid = $request->id;

    
     $salary_all =  DB::table('salary_all')->where('SALARYALL_ID','=',$salaryallid)->first();
     $totalreceive =  DB::table('salary_all_receive')->where('SALARYALL_ID','=',$salaryallid)->sum('SALARYALL_RECEIVE_AMOUNT');                                     
     $totalpay =  DB::table('salary_all_pay')->where('SALARYALL_ID','=',$salaryallid)->sum('SALARYALL_PAY_AMOUNT');     


     if($salary_all->SALARYALL_TYPE == 'salary'){
         $typename = 'เงินเดือน';
     }else{
         $typename = 'ค่าตอบแทน';
     }
     $receivepersons =  DB::table('salary_all_receive')->where('SALARYALL_ID','=',$salaryallid)->get();                                     
     $paypersons =  DB::table('salary_all_pay')->where('SALARYALL_ID','=',$salaryallid)->get();     

     
function MonthThai($strmonth)
{
 $strMonth= $strmonth;


 $strMonthCut = Array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
 $strMonthThai=$strMonthCut[$strMonth];
 return "$strMonthThai";
 }

     $output='    
     <div id="detailsalaryperson" class="modal" tabindex="-1" role="dialog">
     <div class="modal-dialog modal-xl">
 <div class="modal-content">
 <div class="modal-header">
  
 <div class="row">
 

 <div><h4  style="font-family: \'Kanit\', sans-serif;">&nbsp;&nbsp;&nbsp;&nbsp;รายละเอียดรายรับ - รายจ่าย '.$salary_all->SALARYALL_PERSON_NAME.' วันที่ '.$salary_all->SALARYALL_DAY_ID.' '.MonthThai($salary_all->SALARYALL_MONTH_ID).' '.$salary_all->SALARYALL_YEAR_ID.' ประเภท '.$typename.'</h4> </div>
 <div class="col-1">

 <a style="margin-left: 5em;  "href="' . url('manager_compensation/'.'pdfcompensation/'.'export_callcompensationdetail_sub/'.$salaryallid) . '" target="_blank">
     <button  style=" font-size: 1em; width: 4.5em; height: 2.5em;"  type="button" class="btn btn-info btn-md">PDF
     </button>
 </a>   

</div>
 </div>
   </div>
     <div class="modal-body" >
  
     <div class="row">
     <div class="col-sm-6">    
                    รายรับ
                           <table class="table-bordered table-striped table-vcenter" style="width: 100%;font-size: 13px;" >
                             <thead style="background-color: #FFEBCD;">
                             <tr height="20">
                             <th  class="text-font" style="border-color:#F0FFFF;text-align: center;" width="5%">ลำดับ</th>
                                 <th  class="text-font" style="border-color:#F0FFFF;text-align: center;">รายละเอียด</th>
                                 <th  class="text-font" style="border-color:#F0FFFF;text-align: center;" width="15%">จำนวน</th>
                       
                           
                         
                             </tr >
                         </thead>';


                         $munber1 = 0;
                         foreach ($receivepersons as $receiveperson) {

                             if($receiveperson->SALARYALL_RECEIVE_AMOUNT !== '' && $receiveperson->SALARYALL_RECEIVE_AMOUNT !== null){
                             $munber1++;   
                             $output.=' <tr>
                             <td class="text-font  text-pedding" style="text-align: center;">'.$munber1.'</td>
                             <td class="text-font text-pedding" >'.$receiveperson->SALARYALL_RECEIVE_LISTNAME.'</td>
                             <td class="text-font text-pedding"  style="text-align: right;">'.number_format($receiveperson->SALARYALL_RECEIVE_AMOUNT,2).'</td>
                         </tr>';
                             }
                         }     

                         $output.='<tbody>     
                         
                    
                         </tbody>   
                         </table> 
    </div>                       
    <div class="col-sm-6">               
                  
                           &nbsp;&nbsp;รายจ่าย
                           <table class="table-bordered table-striped table-vcenter " style="width: 100%;font-size: 13px;" >
                           <thead style="background-color: #FFEBCD;">
                           <tr height="20">
                           <th  class="text-font" style="border-color:#F0FFFF;text-align: center;" width="5%">ลำดับ</th>
                               <th  class="text-font" style="border-color:#F0FFFF;text-align: center;">รายละเอียด</th>
                               <th  class="text-font" style="border-color:#F0FFFF;text-align: center;" width="15%">จำนวน</th>
                     
                   
                           </tr >
                       </thead>
                       <tbody>';  
                       $munber2 = 0;
                       foreach ($paypersons as $payperson) {
                           
                           if($payperson->SALARYALL_PAY_AMOUNT !== '' && $payperson->SALARYALL_PAY_AMOUNT !== null){  
                             $munber2++; 
                             $output.=' <tr>
                           <td class="text-font  text-pedding" style="text-align: center;">'.$munber2.'</td>
                           <td class="text-font text-pedding" >'.$payperson->SALARYALL_PAY_LISTNAME.'</td>
                           <td class="text-font text-pedding"  style="text-align: right;">'.number_format($payperson->SALARYALL_PAY_AMOUNT,2).'</td>
                       </tr>';
                       
                           }
                       }
                       
                         $output.='</tbody>   
                     </table>
     </div>  
     </div>
     <br> 

     <table class="table-bordered table-striped table-vcenter " style="width: 100%;font-size: 13px;" >
     <thead style="background-color: #F0F8FF;">
     <tr height="20">
         <th  class="text-font" style="border-color:#F0FFFF;text-align: center;">รวมรับ</th>
         <th  class="text-font" style="border-color:#F0FFFF;text-align: center;">รวมรับ</th>
         <th  class="text-font" style="border-color:#F0FFFF;text-align: center;">คงเหลือ</th>


     </tr >
 </thead>
 <tbody>  
       <tr>
           <td class="text-font text-pedding"  style="text-align: right;">'.number_format($totalreceive,2).'</td>
           <td class="text-font text-pedding"  style="text-align: right;">'.number_format($totalpay,2).'</td>
           <td class="text-font text-pedding"  style="text-align: right;">'.number_format($salary_all->SALARYALL_TOTAL,2).'</td>
       </tr>
   
 
 </tbody>   
</table>

     <br>
<div class="modal-footer">

<button type="button" class="btn btn-secondary" data-dismiss="modal"  style="font-family: \'Kanit\', sans-serif;">ปิดหน้าต่าง</button>
</div>
</div>
</div>
</div>
             
     ';
 
     echo $output;
 }



 public static function salarydetailperson_process(Request $request)
 {
    
   $iduser = $request->id;
   $typecode = $request->typecode;
   
        $salaryperson = Person::where('ID','=',$iduser)->first();
        $amountreceive = Salaryreceiveperson::leftjoin('salary_receive','salary_receive.ID','=','salary_receive_person.SALARY_RECEIVE_ID')
        ->where('salary_receive.ACTIVE','=','TRUE')
        ->where('HR_PERSON_ID','=',$iduser)
        ->where('HR_RECEIVE_TYPE','=',$typecode)
        ->sum('AMOUNT');

        $totalreceive =   $amountreceive;

        $amountpay =   Salarypayperson::leftjoin('salary_pay','salary_pay.ID','=','salary_pay_person.SALARY_PAY_ID')
        ->where('salary_pay.ACTIVE','=','TRUE')
        ->where('HR_PERSON_ID','=',$iduser)
        ->where('HR_PAY_TYPE','=',$typecode)->sum('AMOUNT');

        $total =   $totalreceive - $amountpay;

        //----------------
        $receivepersons = Salaryreceiveperson::leftjoin('salary_receive','salary_receive.ID','=','salary_receive_person.SALARY_RECEIVE_ID')
        ->where('salary_receive.ACTIVE','=','TRUE')
        ->where('HR_PERSON_ID','=',$iduser)
        ->where('HR_RECEIVE_TYPE','=',$typecode)->get();

         //----------------
         $paypersons = Salarypayperson::leftjoin('salary_pay','salary_pay.ID','=','salary_pay_person.SALARY_PAY_ID')
         ->where('salary_pay.ACTIVE','=','TRUE')
         ->where('HR_PERSON_ID','=',$iduser)
         ->where('HR_PAY_TYPE','=',$typecode)->get();


    $output='    
    <div id="detailsalaryperson" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl">
<div class="modal-content">
<div class="modal-header">
 
<div class="row">


<div><h4  style="font-family: \'Kanit\', sans-serif;">&nbsp;&nbsp;&nbsp;&nbsp;รายการรับ - รายจ่าย ของ '.$salaryperson->HR_FNAME.' '.$salaryperson->HR_LNAME.'</h4></div>
 
</div>
  </div>
    <div class="modal-body" >
 
    <div class="row">
    <div class="col-sm-6">    
                  รายรับ

                          <table class="table-bordered table-striped table-vcenter" style="width: 100%;font-size: 13px;" >
                            <thead style="background-color: #FFEBCD;">
                            <tr height="20">
                            <th  class="text-font" style="border-color:#F0FFFF;text-align: center;" width="5%">ลำดับ</th>
                                <th  class="text-font" style="border-color:#F0FFFF;text-align: center;">รายละเอียด</th>
                                <th  class="text-font" style="border-color:#F0FFFF;text-align: center;" width="15%">จำนวน</th>
                      
                          
                        
                            </tr >
                        </thead>
                     
                        
                        <tbody>     
                        
             ';

                            $munber1 = 2;
                            foreach ($receivepersons as $receiveperson) {

                                if($receiveperson->AMOUNT !== '' && $receiveperson->AMOUNT !== null){
                                $munber1++;   
                                $output.=' <tr>
                                <td class="text-font  text-pedding" style="text-align: center;">'.$munber1.'</td>
                                <td class="text-font text-pedding" >'.$receiveperson->HR_RECEIVE_NAME.'</td>
                                <td class="text-font text-pedding"  style="text-align: right;">'.number_format($receiveperson->AMOUNT,2).'</td>
                            </tr>';
                                }
                              
                        }



            $output.='</tbody>   
                        </table> 
   </div>                       
   <div class="col-sm-6">               
                 
                          &nbsp;&nbsp;รายจ่าย
                          <table class="table-bordered table-striped table-vcenter " style="width: 100%;font-size: 13px;" >
                          <thead style="background-color: #FFEBCD;">
                          <tr height="20">
                          <th  class="text-font" style="border-color:#F0FFFF;text-align: center;" width="5%">ลำดับ</th>
                              <th  class="text-font" style="border-color:#F0FFFF;text-align: center;">รายละเอียด</th>
                              <th  class="text-font" style="border-color:#F0FFFF;text-align: center;" width="15%">จำนวน</th>
                    
                  
                          </tr >
                      </thead>
                      <tbody>';  
                      $munber2 = 0;
                      foreach ($paypersons as $payperson) {
                          $munber2++; 
                          if($payperson->AMOUNT !== '' && $payperson->AMOUNT !== null){  
                          $output.=' <tr>
                          <td class="text-font  text-pedding" style="text-align: center;">'.$munber2.'</td>
                          <td class="text-font text-pedding" >'.$payperson->HR_PAY_NAME.'</td>
                          <td class="text-font text-pedding"  style="text-align: right;">'.number_format($payperson->AMOUNT,2).'</td>
                      </tr>';
                          }
                        }
                      
                $output.='</tbody>   
                    </table>
    </div>  
    </div>
    <br> 

    <table class="table-bordered table-striped table-vcenter " style="width: 100%;font-size: 13px;" >
    <thead style="background-color: #F0F8FF;">
    <tr height="20">
        <th  class="text-font" style="border-color:#F0FFFF;text-align: center;">รวมรับ</th>
        <th  class="text-font" style="border-color:#F0FFFF;text-align: center;">รวมจ่าย</th>
        <th  class="text-font" style="border-color:#F0FFFF;text-align: center;">คงเหลือ</th>


    </tr >
</thead>
<tbody>  
      <tr>
          <td class="text-font text-pedding"  style="text-align: right;">'.number_format($totalreceive,2).'</td>
          <td class="text-font text-pedding"  style="text-align: right;">'.number_format($amountpay,2).'</td>
          <td class="text-font text-pedding"  style="text-align: right;">'.number_format($total,2).'</td>
      </tr>
  

</tbody>   
</table>

    <br>
<div class="modal-footer">

<button type="button" class="btn btn-secondary" data-dismiss="modal"  style="font-family: \'Kanit\', sans-serif;">ปิดหน้าต่าง</button>
</div>
</div>
</div>
</div>
            
    ';

    echo $output;
 }

 
 public static function salarydetailpersonsearch(Request $request)
 {
    
   $iduser = $request->id;
   $year = $request->year;
   $month = $request->month;

   $salaryperson = Person::where('ID','=',$iduser)->first();
   
   $amountreceive = Salaryallreceive::leftJoin('salary_all','salary_all.SALARYALL_ID','=','salary_all_receive.SALARYALL_ID')
        ->where('SALARYALL_PERSON_ID','=',$iduser)
        ->where('SALARYALL_RECEIVE_YEAR','=',$year)
         ->where('SALARYALL_RECEIVE_MONTH','=',$month)
         ->sum('SALARYALL_RECEIVE_AMOUNT');
   
   $amountpay =   Salaryallpay::leftJoin('salary_all','salary_all.SALARYALL_ID','=','salary_all_pay.SALARYALL_ID')
        ->where('SALARYALL_PERSON_ID','=',$iduser)
        ->where('SALARYALL_PAY_YEAR','=',$year)
        ->where('SALARYALL_PAY_MONTH','=',$month)
        ->sum('SALARYALL_PAY_AMOUNT');
   
   $total = $amountreceive - $amountpay;

        //----------------
        $receivepersons = Salaryallreceive::leftJoin('salary_all','salary_all.SALARYALL_ID','=','salary_all_receive.SALARYALL_ID')
        ->where('SALARYALL_PERSON_ID','=',$iduser)
        ->where('SALARYALL_RECEIVE_YEAR','=',$year)
         ->where('SALARYALL_RECEIVE_MONTH','=',$month)
         ->get();

         //----------------
         $paypersons = Salaryallpay::leftJoin('salary_all','salary_all.SALARYALL_ID','=','salary_all_pay.SALARYALL_ID')
         ->where('SALARYALL_PERSON_ID','=',$iduser)
         ->where('SALARYALL_PAY_YEAR','=',$year)
         ->where('SALARYALL_PAY_MONTH','=',$month)
         ->get();


    $output='    
    <div id="detailsalarypersonsearch" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl">
<div class="modal-content">
<div class="modal-header">
 
<div class="row">


<div><h4  style="font-family: \'Kanit\', sans-serif;">&nbsp;&nbsp;&nbsp;&nbsp;รายการรับ - รายจ่าย ของ '.$salaryperson->HR_FNAME.' '.$salaryperson->HR_LNAME.' ประจำเดือน มีนาคม ปี 2563</h4></div>
 
</div>
  </div>
    <div class="modal-body" >
 
    <div class="row">
    <div class="col-sm-6">    
                   รายละเอียดรายรับ
                          <table class="table-bordered table-striped table-vcenter" style="width: 100%;font-size: 13px;" >
                            <thead style="background-color: #FFEBCD;">
                            <tr height="20">
                            <th  class="text-font" style="border-color:#F0FFFF;text-align: center;" width="5%">ลำดับ</th>
                                <th  class="text-font" style="border-color:#F0FFFF;text-align: center;">รายละเอียด</th>
                                <th  class="text-font" style="border-color:#F0FFFF;text-align: center;" width="15%">จำนวน</th>
                      
                          
                        
                            </tr >
                        </thead>
                     
                        
                        <tbody>     
                        
         ';

                            $munber1 = 2;
                            foreach ($receivepersons as $receiveperson) {
                                $munber1++;   
                                if($receiveperson->SALARYALL_RECEIVE_AMOUNT !== null && $receiveperson->SALARYALL_RECEIVE_AMOUNT !== ''){
                                $output.=' <tr>
                                <td class="text-font  text-pedding" style="text-align: center;">'.$munber1.'</td>
                                <td class="text-font text-pedding" >'.$receiveperson->SALARYALL_RECEIVE_LISTNAME.'</td>
                                <td class="text-font text-pedding"  style="text-align: right;">'.$receiveperson->SALARYALL_RECEIVE_AMOUNT.'</td>
                            </tr>';
                                }
                                }



            $output.='</tbody>   
                        </table> 
   </div>                       
   <div class="col-sm-6">               
                 
                          &nbsp;&nbsp;รายละเอียดรายจ่าย
                          <table class="table-bordered table-striped table-vcenter " style="width: 100%;font-size: 13px;" >
                          <thead style="background-color: #FFEBCD;">
                          <tr height="20">
                          <th  class="text-font" style="border-color:#F0FFFF;text-align: center;" width="5%">ลำดับ</th>
                              <th  class="text-font" style="border-color:#F0FFFF;text-align: center;">รายละเอียด</th>
                              <th  class="text-font" style="border-color:#F0FFFF;text-align: center;" width="15%">จำนวน</th>
                    
                  
                          </tr >
                      </thead>
                      <tbody>';  
                      $munber2 = 0;
                      foreach ($paypersons as $payperson) {
                          $munber2++;   
                          if($payperson->SALARYALL_PAY_AMOUNT !== null && $payperson->SALARYALL_PAY_AMOUNT !== ''){
                          $output.=' <tr>
                          <td class="text-font  text-pedding" style="text-align: center;">'.$munber2.'</td>
                          <td class="text-font text-pedding" >'.$payperson->SALARYALL_PAY_LISTNAME.'</td>
                          <td class="text-font text-pedding"  style="text-align: right;">'.$payperson->SALARYALL_PAY_AMOUNT.'</td>
                      </tr>';
                          }
                        
                          }
                      
                $output.='</tbody>   
                    </table>
    </div>  
    </div>
    <br> 

    <table class="table-bordered table-striped table-vcenter " style="width: 100%;font-size: 13px;" >
    <thead style="background-color: #F0F8FF;">
    <tr height="20">
        <th  class="text-font" style="border-color:#F0FFFF;text-align: center;">รวมรับ</th>
        <th  class="text-font" style="border-color:#F0FFFF;text-align: center;">รวมจ่าย</th>
        <th  class="text-font" style="border-color:#F0FFFF;text-align: center;">คงเหลือ</th>


    </tr >
</thead>
<tbody>  
      <tr>
          <td class="text-font text-pedding"  style="text-align: right;">'.$amountreceive.'</td>
          <td class="text-font text-pedding"  style="text-align: right;">'.$amountpay.'</td>
          <td class="text-font text-pedding"  style="text-align: right;">'.$total.'</td>
      </tr>
  

</tbody>   
</table>

    <br>
<div class="modal-footer">

<button type="button" class="btn btn-secondary" data-dismiss="modal"  style="font-family: \'Kanit\', sans-serif;">ปิดหน้าต่าง</button>
</div>
</div>
</div>
</div>
            
    ';

    echo $output;
 }

  //===================================================================

  public function infocertificate(Request $request)
  {
    if($request->method() === 'POST'){
        $search     = $request->get('search');
        $status     = $request->SEND_STATUS;
        $datebigin  = $request->get('DATE_BIGIN');
        $dateend    = $request->get('DATE_END');
        $yearbudget = $request->BUDGET_YEAR;
        $data_search = json_encode_u([
            'search' => $search,
            'status' => $status,
            'datebigin' => $datebigin,
            'dateend' => $dateend,
            'yearbudget' => $yearbudget,
        ]);
        Cookie::queue('data_search', $data_search, 120,$request->server('REQUEST_URI'));
    }elseif(!empty(Cookie::get('data_search'))){
        $data_search    = json_decode(Cookie::get('data_search'));
        $search     = $data_search->search;
        $status     = $data_search->status;
        $datebigin     = $data_search->datebigin;
        $dateend     = $data_search->dateend;
        $yearbudget     = $data_search->yearbudget;
    }else{
        $search     = '';
        $status     = '';
        $yearbudget = getBudgetYear();
        $datebigin  = date('01/10/'.($yearbudget-1));
        $dateend    = date('30/09/'.$yearbudget);
    }

    $date_bigen_c = Carbon::createFromFormat('d/m/Y', $datebigin)->format('Y-m-d');
    $date_arrary=explode("-",$date_bigen_c);
    $y_sub_st = $date_arrary[0];

    if($y_sub_st >= 2500){
        $y = $y_sub_st-543;
    }else{
        $y = $y_sub_st;
    }

    $m = $date_arrary[1];
    $d = $date_arrary[2];  
    $displaydate_bigen= $y."-".$m."-".$d;
    $date_end_c = Carbon::createFromFormat('d/m/Y', $dateend)->format('Y-m-d');
    $date_arrary_e=explode("-",$date_end_c); 
    $y_sub_e = $date_arrary_e[0];
    
    if($y_sub_e >= 2500){
        $y_e = $y_sub_e-543;
    }else{
        $y_e = $y_sub_e;
    }

    $m_e = $date_arrary_e[1];
    $d_e = $date_arrary_e[2];  
    $displaydate_end= $y_e."-".$m_e."-".$d_e;
    $date = date('Y-m-d');
    $date_bigen_checks = strtotime($displaydate_bigen);
    $date_end_checks =  strtotime($displaydate_end);
    $dates =  strtotime($date);
    if($date_bigen_checks != $dates || $date_end_checks != $dates){
        $from = date($displaydate_bigen);
        $to = date($displaydate_end);
        if($status == null){
            $inforSalarycertificate =  Salarycertificate::where('CER_YEAR','=',$yearbudget)
            ->where(function($q) use ($search){
                $q->where('CER_NUMBER','like','%'.$search.'%');
                $q->orwhere('CER_HR_DEP_SUB_SUB_NAME','like','%'.$search.'%');
                $q->orwhere('CER_COMMENT','like','%'.$search.'%');    
                $q->orwhere('CER_HR_PERSON_NAME','like','%'.$search.'%');    
            }) 
            ->WhereBetween('CER_DATE',[$from,$to])          
            ->orderBy('CER_ID', 'DESC')->get();
        }else{
            $inforSalarycertificate =  Salarycertificate::where('CER_YEAR','=',$yearbudget)
            ->where('CER_STATUS','=',$status)
            ->where(function($q) use ($search){
            $q->where('CER_NUMBER','like','%'.$search.'%');
            $q->orwhere('CER_HR_DEP_SUB_SUB_NAME','like','%'.$search.'%');
            $q->orwhere('CER_COMMENT','like','%'.$search.'%');    
            $q->orwhere('CER_HR_PERSON_NAME','like','%'.$search.'%');    
        }) 
        ->WhereBetween('CER_DATE',[$from,$to])          
        ->orderBy('CER_ID', 'DESC')->get();
        }    
    }else{
        if($status == null){
            $inforSalarycertificate =  Salarycertificate::where('CER_YEAR','=',$yearbudget)
                ->where(function($q) use ($search){
                $q->where('CER_NUMBER','like','%'.$search.'%');
                $q->orwhere('CER_HR_DEP_SUB_SUB_NAME','like','%'.$search.'%');
                $q->orwhere('CER_COMMENT','like','%'.$search.'%');    
                $q->orwhere('CER_HR_PERSON_NAME','like','%'.$search.'%');    
            })    
            ->orderBy('CER_ID', 'DESC')->get();
        }else{
            $inforSalarycertificate =  Salarycertificate::where('CER_YEAR','=',$yearbudget)
                ->where('CER_STATUS','=',$status)
                ->where(function($q) use ($search){
                $q->where('CER_NUMBER','like','%'.$search.'%');
                $q->orwhere('CER_HR_DEP_SUB_SUB_NAME','like','%'.$search.'%');
                $q->orwhere('CER_COMMENT','like','%'.$search.'%');    
                $q->orwhere('CER_HR_PERSON_NAME','like','%'.$search.'%');    
            })    
            ->orderBy('CER_ID', 'DESC')->get();
        }
    }
    $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
    $info_sendstatus = DB::table('salary_status')->get();
    $year_id = $yearbudget;
    return view('manager_compensation.infocertificate',[
        'inforSalarycertificates' => $inforSalarycertificate,
        'info_sendstatuss' => $info_sendstatus,
        'budgets' =>  $budget,
        'displaydate_bigen'=> $displaydate_bigen,
        'displaydate_end'=> $displaydate_end,
        'status_check'=> $status,
        'search'=> $search,
        'year_id'=>$year_id, 
    ]);
  }

  public function searchinfocertificate(Request $request)
  {
    $search = $request->get('search');
    $status = $request->SEND_STATUS;
    $datebigin = $request->get('DATE_BIGIN');
    $dateend = $request->get('DATE_END');
    $yearbudget = $request->BUDGET_YEAR;
 

    if($search==''){
        $search="";
    }

   

    $date_bigen_c = Carbon::createFromFormat('d/m/Y', $datebigin)->format('Y-m-d');
    $date_arrary=explode("-",$date_bigen_c);

    $y_sub_st = $date_arrary[0];

    if($y_sub_st >= 2500){
        $y = $y_sub_st-543;
    }else{
        $y = $y_sub_st;
    }

    $m = $date_arrary[1];
    $d = $date_arrary[2];  
    $displaydate_bigen= $y."-".$m."-".$d;

    $date_end_c = Carbon::createFromFormat('d/m/Y', $dateend)->format('Y-m-d');
    $date_arrary_e=explode("-",$date_end_c); 

    $y_sub_e = $date_arrary_e[0];

    if($y_sub_e >= 2500){
        $y_e = $y_sub_e-543;
    }else{
        $y_e = $y_sub_e;
    }

    $m_e = $date_arrary_e[1];
    $d_e = $date_arrary_e[2];  
    $displaydate_end= $y_e."-".$m_e."-".$d_e;



        $date = date('Y-m-d');
        $date_bigen_checks = strtotime($displaydate_bigen);
        $date_end_checks =  strtotime($displaydate_end);
        $dates =  strtotime($date);

        if($date_bigen_checks != $dates || $date_end_checks != $dates){

            $from = date($displaydate_bigen);
            $to = date($displaydate_end);
   
if($status == null){


    $inforSalarycertificate =  Salarycertificate::where('CER_YEAR','=',$yearbudget)
        ->where(function($q) use ($search){
            $q->where('CER_NUMBER','like','%'.$search.'%');
            $q->orwhere('CER_HR_DEP_SUB_SUB_NAME','like','%'.$search.'%');
            $q->orwhere('CER_COMMENT','like','%'.$search.'%');    
            $q->orwhere('CER_HR_PERSON_NAME','like','%'.$search.'%');    
        }) 
        ->WhereBetween('CER_DATE',[$from,$to])          
        ->orderBy('CER_ID', 'DESC')->get();

   


}else{


    $inforSalarycertificate =  Salarycertificate::where('CER_YEAR','=',$yearbudget)
        ->where('CER_STATUS','=',$status)
        ->where(function($q) use ($search){
        $q->where('CER_NUMBER','like','%'.$search.'%');
        $q->orwhere('CER_HR_DEP_SUB_SUB_NAME','like','%'.$search.'%');
        $q->orwhere('CER_COMMENT','like','%'.$search.'%');    
        $q->orwhere('CER_HR_PERSON_NAME','like','%'.$search.'%');    
    }) 
    ->WhereBetween('CER_DATE',[$from,$to])          
    ->orderBy('CER_ID', 'DESC')->get();

 

}    




     }else{

    if($status == null){


        $inforSalarycertificate =  Salarycertificate::where('CER_YEAR','=',$yearbudget)
            ->where(function($q) use ($search){
            $q->where('CER_NUMBER','like','%'.$search.'%');
            $q->orwhere('CER_HR_DEP_SUB_SUB_NAME','like','%'.$search.'%');
            $q->orwhere('CER_COMMENT','like','%'.$search.'%');    
            $q->orwhere('CER_HR_PERSON_NAME','like','%'.$search.'%');    
        })    
        ->orderBy('CER_ID', 'DESC')->get();


    }else{


        $inforSalarycertificate =  Salarycertificate::where('CER_YEAR','=',$yearbudget)
            ->where('CER_STATUS','=',$status)
            ->where(function($q) use ($search){
            $q->where('CER_NUMBER','like','%'.$search.'%');
            $q->orwhere('CER_HR_DEP_SUB_SUB_NAME','like','%'.$search.'%');
            $q->orwhere('CER_COMMENT','like','%'.$search.'%');    
            $q->orwhere('CER_HR_PERSON_NAME','like','%'.$search.'%');    
        })    
        ->orderBy('CER_ID', 'DESC')->get();

    }

}
   
    $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
    $info_sendstatus = DB::table('salary_status')->get();
    $year_id = $yearbudget;

      
      return view('manager_compensation.infocertificate',[
        'inforSalarycertificates' => $inforSalarycertificate,
        'info_sendstatuss' => $info_sendstatus,
        'budgets' =>  $budget,
        'displaydate_bigen'=> $displaydate_bigen,
        'displaydate_end'=> $displaydate_end,
        'status_check'=> $status,
        'search'=> $search,
        'year_id'=>$year_id, 
        
    ]);
  }




  public function infocertificatelastapp(Request $request,$idref)
  {
    $inforSalarycertificate =  Salarycertificate::where('CER_ID','=',$idref)->first();
    $inforeceive = DB::table('salary_receive')->get();
    $inforeceiveperson = DB::table('salary_receive_person')->where('HR_PERSON_ID','=',$inforSalarycertificate->CER_HR_PERSON_ID)->get();
      return view('manager_compensation.infocertificatelastapp',[
        'inforSalarycertificate' => $inforSalarycertificate,
        'inforeceives' => $inforeceive,
        'inforeceivepersons' => $inforeceiveperson,
        
    ]);
  }

  
public function updatecertificatelastapp(Request $request)
{
    

    $id = $request->ID;

    

    $check =  $request->SUBMIT;

    if($check == 'approved'){
      $statuscode = 'SUCCESS';
 
    }else{
      $statuscode = 'NOTSUCCESS';
   
    }


      $updatelastapp = Salarycertificate::find($id);
      $updatelastapp->CER_STATUS = $statuscode ;
      $updatelastapp->save();



      
      if($request->RECEIV_ID[0] != '' || $request->RECEIV_ID[0] != null){
        $RECEIV_ID = $request->RECEIV_ID;
        $AMOUNT_PICE = $request->AMOUNT_PICE;
        $number =count($RECEIV_ID);
        $count = 0;
        for($count = 0; $count < $number; $count++)
        {
          

           $add = new Salarycertificatesub();
           $add->CER_ID =  $id;
           $add->CERSUB_RECEIVE_ID = $RECEIV_ID[$count];
           $inforeceive = DB::table('salary_receive')->where('ID','=', $RECEIV_ID[$count])->first();
           
           $add->CERSUB_RECEIVE_NAME = $inforeceive->HR_RECEIVE_NAME;
           $add->CERSUB_AMOUNT = $AMOUNT_PICE[$count];
           $add->save();


        }
    }





      return redirect()->route('mcompensation.infocertificate');


}



//-----------------------------


  public function infosalaryslip(Request $request)
  {
    if($request->method() === 'POST'){
        $search = $request->get('search');
        $status = $request->SEND_STATUS;
        $datebigin = $request->get('DATE_BIGIN');
        $dateend = $request->get('DATE_END');
        $yearbudget = $request->BUDGET_YEAR;
        $data_search = json_encode_u([
            'search' => $search,
            'status' => $status,
            'datebigin' => $datebigin,
            'dateend' => $dateend,
            'yearbudget' => $yearbudget,
        ]);
        Cookie::queue('data_search', $data_search, 120,$request->server('REQUEST_URI'));
    }elseif(!empty(Cookie::get('data_search'))){
        $data_search    = json_decode(Cookie::get('data_search'));
        $search     = $data_search->search;
        $status     = $data_search->status;
        $datebigin     = $data_search->datebigin;
        $dateend     = $data_search->dateend;
        $yearbudget     = $data_search->yearbudget;
    }else{
        $search     = '';
        $yearbudget = getBudgetYear();
        $datebigin  = date('01/10/'.($yearbudget-1));
        $dateend    = date('30/09/'.$yearbudget);
        $status     = '';
    }
 
    $date_bigen_c = Carbon::createFromFormat('d/m/Y', $datebigin)->format('Y-m-d');
    $date_arrary=explode("-",$date_bigen_c);
    $y_sub_st = $date_arrary[0];
    if($y_sub_st >= 2500){
        $y = $y_sub_st-543;
    }else{
        $y = $y_sub_st;
    }
    $m = $date_arrary[1];
    $d = $date_arrary[2];  
    $displaydate_bigen= $y."-".$m."-".$d;
    $date_end_c = Carbon::createFromFormat('d/m/Y', $dateend)->format('Y-m-d');
    $date_arrary_e=explode("-",$date_end_c); 
    $y_sub_e = $date_arrary_e[0];
    if($y_sub_e >= 2500){
        $y_e = $y_sub_e-543;
    }else{
        $y_e = $y_sub_e;
    }
    $m_e = $date_arrary_e[1];
    $d_e = $date_arrary_e[2];  
    $displaydate_end= $y_e."-".$m_e."-".$d_e;
    $date = date('Y-m-d');
    $date_bigen_checks = strtotime($displaydate_bigen);
    $date_end_checks =  strtotime($displaydate_end);
    $dates =  strtotime($date);
    if($date_bigen_checks != $dates || $date_end_checks != $dates){
        $from = date($displaydate_bigen);
        $to = date($displaydate_end);
        if($status == null){
            $inforSalaryslip =  Salaryslip::where('SLIP_YEAR','=',$yearbudget)
            ->where(function($q) use ($search){
                $q->where('SLIP_NUMBER','like','%'.$search.'%');
                $q->orwhere('SLIP_HR_DEP_SUB_SUB_NAME','like','%'.$search.'%');
                $q->orwhere('SLIP_COMMENT','like','%'.$search.'%');    
                $q->orwhere('SLIP_HR_PERSON_NAME','like','%'.$search.'%');    
            }) 
            ->WhereBetween('SLIP_DATE',[$from,$to])      
            ->orderBy('SLIP_ID', 'DESC')->get();
        }else{
            $inforSalaryslip =  Salaryslip::where('SLIP_YEAR','=',$yearbudget)
                ->where('SLIP_STATUS','=',$status)
                ->where(function($q) use ($search){
                $q->where('SLIP_NUMBER','like','%'.$search.'%');
                $q->orwhere('SLIP_HR_DEP_SUB_SUB_NAME','like','%'.$search.'%');
                $q->orwhere('SLIP_COMMENT','like','%'.$search.'%');    
                $q->orwhere('SLIP_HR_PERSON_NAME','like','%'.$search.'%');    
            }) 
            ->WhereBetween('SLIP_DATE',[$from,$to])      
            ->orderBy('SLIP_ID', 'DESC')->get();
        }    
    }else{
        if($status == null){
            $inforSalaryslip =  Salaryslip::where('SLIP_YEAR','=',$yearbudget)
                ->where(function($q) use ($search){
                $q->where('SLIP_NUMBER','like','%'.$search.'%');
                $q->orwhere('SLIP_HR_DEP_SUB_SUB_NAME','like','%'.$search.'%');
                $q->orwhere('SLIP_COMMENT','like','%'.$search.'%');    
                $q->orwhere('SLIP_HR_PERSON_NAME','like','%'.$search.'%');    
            }) 
            ->orderBy('SLIP_ID', 'DESC')->get();
        }else{
            $inforSalaryslip =  Salaryslip::where('SLIP_YEAR','=',$yearbudget)
                ->where('SLIP_STATUS','=',$status)
                ->where(function($q) use ($search){
                $q->where('SLIP_NUMBER','like','%'.$search.'%');
                $q->orwhere('SLIP_HR_DEP_SUB_SUB_NAME','like','%'.$search.'%');
                $q->orwhere('SLIP_COMMENT','like','%'.$search.'%');    
                $q->orwhere('SLIP_HR_PERSON_NAME','like','%'.$search.'%');    
            })     
            ->orderBy('SLIP_ID', 'DESC')->get();
        }
    }
    $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
    $info_sendstatus = DB::table('salary_status')->get();
    $year_id = $yearbudget;
    return view('manager_compensation.infosalaryslip',[
        'inforSalaryslips' => $inforSalaryslip,
        'info_sendstatuss' => $info_sendstatus,
        'budgets' =>  $budget,
        'displaydate_bigen'=> $displaydate_bigen,
        'displaydate_end'=> $displaydate_end,
        'status_check'=> $status,
        'search'=> $search,
        'year_id'=>$year_id, 
    ]);
  }

  public function searchinfosalaryslip(Request $request)
  {
    $search = $request->get('search');
    $status = $request->SEND_STATUS;
    $datebigin = $request->get('DATE_BIGIN');
    $dateend = $request->get('DATE_END');
    $yearbudget = $request->BUDGET_YEAR;
 

    if($search==''){
        $search="";
    }

   

    $date_bigen_c = Carbon::createFromFormat('d/m/Y', $datebigin)->format('Y-m-d');
    $date_arrary=explode("-",$date_bigen_c);

    $y_sub_st = $date_arrary[0];

    if($y_sub_st >= 2500){
        $y = $y_sub_st-543;
    }else{
        $y = $y_sub_st;
    }

    $m = $date_arrary[1];
    $d = $date_arrary[2];  
    $displaydate_bigen= $y."-".$m."-".$d;

    $date_end_c = Carbon::createFromFormat('d/m/Y', $dateend)->format('Y-m-d');
    $date_arrary_e=explode("-",$date_end_c); 

    $y_sub_e = $date_arrary_e[0];

    if($y_sub_e >= 2500){
        $y_e = $y_sub_e-543;
    }else{
        $y_e = $y_sub_e;
    }

    $m_e = $date_arrary_e[1];
    $d_e = $date_arrary_e[2];  
    $displaydate_end= $y_e."-".$m_e."-".$d_e;



        $date = date('Y-m-d');
        $date_bigen_checks = strtotime($displaydate_bigen);
        $date_end_checks =  strtotime($displaydate_end);
        $dates =  strtotime($date);


        if($date_bigen_checks != $dates || $date_end_checks != $dates){

            $from = date($displaydate_bigen);
            $to = date($displaydate_end);
   
if($status == null){

    $inforSalaryslip =  Salaryslip::where('SLIP_YEAR','=',$yearbudget)
    ->where(function($q) use ($search){
        $q->where('SLIP_NUMBER','like','%'.$search.'%');
        $q->orwhere('SLIP_HR_DEP_SUB_SUB_NAME','like','%'.$search.'%');
        $q->orwhere('SLIP_COMMENT','like','%'.$search.'%');    
        $q->orwhere('SLIP_HR_PERSON_NAME','like','%'.$search.'%');    
    }) 
    ->WhereBetween('SLIP_DATE',[$from,$to])      
    ->orderBy('SLIP_ID', 'DESC')->get();


   


}else{


    $inforSalaryslip =  Salaryslip::where('SLIP_YEAR','=',$yearbudget)
        ->where('SLIP_STATUS','=',$status)
        ->where(function($q) use ($search){
        $q->where('SLIP_NUMBER','like','%'.$search.'%');
        $q->orwhere('SLIP_HR_DEP_SUB_SUB_NAME','like','%'.$search.'%');
        $q->orwhere('SLIP_COMMENT','like','%'.$search.'%');    
        $q->orwhere('SLIP_HR_PERSON_NAME','like','%'.$search.'%');    
    }) 
    ->WhereBetween('SLIP_DATE',[$from,$to])      
    ->orderBy('SLIP_ID', 'DESC')->get();



 

}    




     }else{

    if($status == null){

        $inforSalaryslip =  Salaryslip::where('SLIP_YEAR','=',$yearbudget)
            ->where(function($q) use ($search){
            $q->where('SLIP_NUMBER','like','%'.$search.'%');
            $q->orwhere('SLIP_HR_DEP_SUB_SUB_NAME','like','%'.$search.'%');
            $q->orwhere('SLIP_COMMENT','like','%'.$search.'%');    
            $q->orwhere('SLIP_HR_PERSON_NAME','like','%'.$search.'%');    
        }) 
        ->orderBy('SLIP_ID', 'DESC')->get();





    }else{

        $inforSalaryslip =  Salaryslip::where('SLIP_YEAR','=',$yearbudget)
            ->where('SLIP_STATUS','=',$status)
            ->where(function($q) use ($search){
            $q->where('SLIP_NUMBER','like','%'.$search.'%');
            $q->orwhere('SLIP_HR_DEP_SUB_SUB_NAME','like','%'.$search.'%');
            $q->orwhere('SLIP_COMMENT','like','%'.$search.'%');    
            $q->orwhere('SLIP_HR_PERSON_NAME','like','%'.$search.'%');    
        })     
        ->orderBy('SLIP_ID', 'DESC')->get();


    

    }

}
   
    $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
    $info_sendstatus = DB::table('salary_status')->get();
    $year_id = $yearbudget;

      return view('manager_compensation.infosalaryslip',[
        'inforSalaryslips' => $inforSalaryslip,
        'info_sendstatuss' => $info_sendstatus,
        'budgets' =>  $budget,
        'displaydate_bigen'=> $displaydate_bigen,
        'displaydate_end'=> $displaydate_end,
        'status_check'=> $status,
        'search'=> $search,
        'year_id'=>$year_id, 
        
    ]);
  }


   
public function updatesliplastapp(Request $request)
{
    

    $id = $request->ID;

    $check =  $request->SUBMIT;

    if($check == 'approved'){
      $statuscode = 'SUCCESS';
 
    }else{
      $statuscode = 'NOTSUCCESS'; 
    }

      $updatelastapp = Salaryslip::find($id);
      $updatelastapp->SLIP_STATUS = $statuscode;
      $updatelastapp->save();

      return redirect()->route('mcompensation.infosalaryslip');

}

//-------------------------------------

  public function infoborrow(Request $request)
  {
    if($request->method() === 'POST'){
        $search     = $request->get('search');
        $status     = $request->SEND_STATUS;
        $datebigin  = $request->get('DATE_BIGIN');
        $dateend    = $request->get('DATE_END');
        $yearbudget = $request->BUDGET_YEAR;
        $data_search = json_encode_u([
            'search' => $search,
            'yearbudget' => $yearbudget,
            'datebigin' => $datebigin,
            'dateend' => $dateend,
            'status' => $status,
        ]);
        Cookie::queue('data_search', $data_search, 120,$request->server('REQUEST_URI'));
    }elseif(!empty(Cookie::get('data_search'))){
        $data_search    = json_decode(Cookie::get('data_search'));
        $search     = $data_search->search;
        $yearbudget     = $data_search->yearbudget;
        $datebigin     = $data_search->datebigin;
        $dateend     = $data_search->dateend;
        $status     = $data_search->status;
    }else{
        $search     = '';
        $yearbudget = getBudgetYear();
        $datebigin  = date('01/10/'.($yearbudget-1));
        $dateend    = date('30/09/'.$yearbudget);
        $status       = '';
    }
 
    $date_bigen_c = Carbon::createFromFormat('d/m/Y', $datebigin)->format('Y-m-d');
    $date_arrary=explode("-",$date_bigen_c);
    $y_sub_st = $date_arrary[0];
    if($y_sub_st >= 2500){
        $y = $y_sub_st-543;
    }else{
        $y = $y_sub_st;
    }
    $m = $date_arrary[1];
    $d = $date_arrary[2];  
    $displaydate_bigen= $y."-".$m."-".$d;
    $date_end_c = Carbon::createFromFormat('d/m/Y', $dateend)->format('Y-m-d');
    $date_arrary_e=explode("-",$date_end_c); 
    $y_sub_e = $date_arrary_e[0];
    if($y_sub_e >= 2500){
        $y_e = $y_sub_e-543;
    }else{
        $y_e = $y_sub_e;
    }
    $m_e = $date_arrary_e[1];
    $d_e = $date_arrary_e[2];  
    $displaydate_end= $y_e."-".$m_e."-".$d_e;
    $date = date('Y-m-d');
    $date_bigen_checks = strtotime($displaydate_bigen);
    $date_end_checks =  strtotime($displaydate_end);
    $dates =  strtotime($date);
    if($date_bigen_checks != $dates || $date_end_checks != $dates){
        $from = date($displaydate_bigen);
        $to = date($displaydate_end);
        if($status == null){
            $inforSalaryborrow =  Salaryborrow::where('BORROW_YEAR','=',$yearbudget)
            ->where(function($q) use ($search){
                $q->where('BORROW_NUMBER','like','%'.$search.'%');
                $q->orwhere('BORROW_COMMENT','like','%'.$search.'%');
                $q->orwhere('BORROW_HR_DEP_SUB_SUB_NAME','like','%'.$search.'%');    
                $q->orwhere('BORROW_HR_PERSON_NAME','like','%'.$search.'%');    
            }) 
            ->WhereBetween('BORROW_DATE',[$from,$to])      
            ->orderBy('BORROW_ID', 'DESC')->get();
        }else{
            $inforSalaryborrow =  Salaryborrow::where('BORROW_YEAR','=',$yearbudget)
            ->where('BORROW_STATUS','=',$status)
            ->where(function($q) use ($search){
                $q->where('BORROW_NUMBER','like','%'.$search.'%');
                $q->orwhere('BORROW_COMMENT','like','%'.$search.'%');
                $q->orwhere('BORROW_HR_DEP_SUB_SUB_NAME','like','%'.$search.'%');    
                $q->orwhere('BORROW_HR_PERSON_NAME','like','%'.$search.'%');    
            }) 
            ->WhereBetween('BORROW_DATE',[$from,$to])      
            ->orderBy('BORROW_ID', 'DESC')->get();
        }    
    }else{
        if($status == null){
            $inforSalaryborrow =  Salaryborrow::where('BORROW_YEAR','=',$yearbudget)
            ->where(function($q) use ($search){
                $q->where('BORROW_NUMBER','like','%'.$search.'%');
                $q->orwhere('BORROW_COMMENT','like','%'.$search.'%');
                $q->orwhere('BORROW_HR_DEP_SUB_SUB_NAME','like','%'.$search.'%');    
                $q->orwhere('BORROW_HR_PERSON_NAME','like','%'.$search.'%');    
            })  
            ->orderBy('BORROW_ID', 'DESC')->get();
        }else{
            $inforSalaryborrow =  Salaryborrow::where('BORROW_YEAR','=',$yearbudget)
            ->where('BORROW_STATUS','=',$status)
            ->where(function($q) use ($search){
                $q->where('BORROW_NUMBER','like','%'.$search.'%');
                $q->orwhere('BORROW_COMMENT','like','%'.$search.'%');
                $q->orwhere('BORROW_HR_DEP_SUB_SUB_NAME','like','%'.$search.'%');    
                $q->orwhere('BORROW_HR_PERSON_NAME','like','%'.$search.'%');    
            })      
            ->orderBy('BORROW_ID', 'DESC')->get();
        }

    }
    $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
    $info_sendstatus = DB::table('salary_borrow_status')->get();
    $year_id = $yearbudget;
    return view('manager_compensation.infoborrow',[
        'inforSalaryborrows' => $inforSalaryborrow,
        'info_sendstatuss' => $info_sendstatus,
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id, 
    ]);
  }
  
  public function searchinfoborrow(Request $request)
  {
    $search = $request->get('search');
    $status = $request->SEND_STATUS;
    $datebigin = $request->get('DATE_BIGIN');
    $dateend = $request->get('DATE_END');
    $yearbudget = $request->BUDGET_YEAR;
    if($search==''){
        $search="";
    }

    $date_bigen_c = Carbon::createFromFormat('d/m/Y', $datebigin)->format('Y-m-d');
    $date_arrary=explode("-",$date_bigen_c);

    $y_sub_st = $date_arrary[0];

    if($y_sub_st >= 2500){
        $y = $y_sub_st-543;
    }else{
        $y = $y_sub_st;
    }

    $m = $date_arrary[1];
    $d = $date_arrary[2];  
    $displaydate_bigen= $y."-".$m."-".$d;

    $date_end_c = Carbon::createFromFormat('d/m/Y', $dateend)->format('Y-m-d');
    $date_arrary_e=explode("-",$date_end_c); 

    $y_sub_e = $date_arrary_e[0];

    if($y_sub_e >= 2500){
        $y_e = $y_sub_e-543;
    }else{
        $y_e = $y_sub_e;
    }

    $m_e = $date_arrary_e[1];
    $d_e = $date_arrary_e[2];  
    $displaydate_end= $y_e."-".$m_e."-".$d_e;



        $date = date('Y-m-d');
        $date_bigen_checks = strtotime($displaydate_bigen);
        $date_end_checks =  strtotime($displaydate_end);
        $dates =  strtotime($date);

        if($date_bigen_checks != $dates || $date_end_checks != $dates){

            $from = date($displaydate_bigen);
            $to = date($displaydate_end);
   
if($status == null){


    $inforSalaryborrow =  Salaryborrow::where('BORROW_YEAR','=',$yearbudget)
    ->where(function($q) use ($search){
        $q->where('BORROW_NUMBER','like','%'.$search.'%');
        $q->orwhere('BORROW_COMMENT','like','%'.$search.'%');
        $q->orwhere('BORROW_HR_DEP_SUB_SUB_NAME','like','%'.$search.'%');    
        $q->orwhere('BORROW_HR_PERSON_NAME','like','%'.$search.'%');    
    }) 
    ->WhereBetween('BORROW_DATE',[$from,$to])      
    ->orderBy('BORROW_ID', 'DESC')->get();


}else{


    
    $inforSalaryborrow =  Salaryborrow::where('BORROW_YEAR','=',$yearbudget)
    ->where('BORROW_STATUS','=',$status)
    ->where(function($q) use ($search){
        $q->where('BORROW_NUMBER','like','%'.$search.'%');
        $q->orwhere('BORROW_COMMENT','like','%'.$search.'%');
        $q->orwhere('BORROW_HR_DEP_SUB_SUB_NAME','like','%'.$search.'%');    
        $q->orwhere('BORROW_HR_PERSON_NAME','like','%'.$search.'%');    
    }) 
    ->WhereBetween('BORROW_DATE',[$from,$to])      
    ->orderBy('BORROW_ID', 'DESC')->get();


 

}    




     }else{

    if($status == null){


           
    $inforSalaryborrow =  Salaryborrow::where('BORROW_YEAR','=',$yearbudget)
    ->where(function($q) use ($search){
        $q->where('BORROW_NUMBER','like','%'.$search.'%');
        $q->orwhere('BORROW_COMMENT','like','%'.$search.'%');
        $q->orwhere('BORROW_HR_DEP_SUB_SUB_NAME','like','%'.$search.'%');    
        $q->orwhere('BORROW_HR_PERSON_NAME','like','%'.$search.'%');    
    })  
    ->orderBy('BORROW_ID', 'DESC')->get();


    }else{

           
    $inforSalaryborrow =  Salaryborrow::where('BORROW_YEAR','=',$yearbudget)
    ->where('BORROW_STATUS','=',$status)
    ->where(function($q) use ($search){
        $q->where('BORROW_NUMBER','like','%'.$search.'%');
        $q->orwhere('BORROW_COMMENT','like','%'.$search.'%');
        $q->orwhere('BORROW_HR_DEP_SUB_SUB_NAME','like','%'.$search.'%');    
        $q->orwhere('BORROW_HR_PERSON_NAME','like','%'.$search.'%');    
    })      
    ->orderBy('BORROW_ID', 'DESC')->get();


    }

}
   
    $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
    $info_sendstatus = DB::table('salary_borrow_status')->get();
    $year_id = $yearbudget;



      return view('manager_compensation.infoborrow',[
        'inforSalaryborrows' => $inforSalaryborrow,
        'info_sendstatuss' => $info_sendstatus,
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id, 
        
    ]);
  }


  public function infoborrow_app(Request $request)
  {
    $id = $request->ID;

    $check =  $request->SUBMIT;

    if($check == 'approved'){
      $statuscode = 'APP';
 
    }else{
      $statuscode = 'NOTAPP'; 
    }

      $updatelastapp = Salaryborrow::find($id);
      $updatelastapp->BORROW_STATUS = $statuscode;
      $updatelastapp->save();

      return redirect()->route('mcompensation.infoborrow');

  }


  public function infoborrow_re(Request $request)
  {
  
        $BORROWBACKDATE = $request->BORROW_BACK_DATE;

  

        if($BORROWBACKDATE <> null || displaydate <> ''){
            $date_bigen_c = Carbon::createFromFormat('d/m/Y', $BORROWBACKDATE)->format('Y-m-d');
            $date_arrary=explode("-",$date_bigen_c);
    
            $y_sub_st = $date_arrary[0];
    
            if($y_sub_st >= 2500){
                $y = $y_sub_st-543;
            }else{
                $y = $y_sub_st;
            }
    
            $m = $date_arrary[1];
            $d = $date_arrary[2];  
            $displaydate= $y."-".$m."-".$d;

            
        }else{
            $displaydate = date('Y-m-d');
        }

        $id = $request->BORROW_ID;
      $updatelastre = Salaryborrow::find($id);
      $updatelastre->BORROW_STATUS = 'REMON';
      $updatelastre->BORROW_BACK_DATE = $displaydate;
      $updatelastre->save();

      return redirect()->route('mcompensation.infoborrow');

  }

  


//========================นับคำนวคนแต่ละรายการแลคำนวณจำนวนเงิน===========================================
 //--รายการรับ
public static function countreceive($idlist)
{
        $count =  Salaryreceiveperson::where('SALARY_RECEIVE_ID', '=', $idlist)->count();

    return $count;
}


public static function sumreceive($idlist)
{
        $sum =  Salaryreceiveperson::where('SALARY_RECEIVE_ID', '=', $idlist)->sum('AMOUNT');

    return $sum;
}

public static function sumreceiveall($typename)
{
        $sum =  Salaryreceiveperson::leftjoin('salary_receive','salary_receive.ID','=','salary_receive_person.SALARY_RECEIVE_ID')    
        ->where('HR_RECEIVE_TYPE', '=', $typename)->sum('AMOUNT');

    return $sum;
}
//--รายการจ่าย


public static function countpay($idlist)
{
        $count =  Salarypayperson::where('SALARY_PAY_ID', '=', $idlist)->count();

    return $count;
}


public static function sumpay($idlist)
{
        $sum =  Salarypayperson::where('SALARY_PAY_ID', '=', $idlist)->sum('AMOUNT');

    return $sum;
}


public static function sumpayall($typename)
{

        $sum =  Salarypayperson::leftjoin('salary_pay','salary_pay.ID','=','salary_pay_person.SALARY_PAY_ID')    
        ->where('HR_PAY_TYPE', '=',$typename)->sum('AMOUNT');

    return $sum;
}

///=======fileExcel=======


public function excelsalarybank(Request $request,$year,$month)
{


    $infoperson =  Salaryall::leftJoin('hrd_person','salary_all.SALARYALL_PERSON_ID','=','hrd_person.ID')
    ->where('SALARYALL_YEAR_ID','=',$year)
    ->where('SALARYALL_MONTH_ID','=',$month)
    ->orderBy('SALARYALL_PERSON_NAME', 'asc') 
    ->get();


    return view('manager_compensation.excelsalarybank',[
        'infopersons' => $infoperson, 
        'year' => $year, 
        'month' => $month 
      
    ]);
}




public function excelsalaryslip(Request $request,$year,$month)
{


    $infoperson =  Salaryall::leftJoin('hrd_person','salary_all.SALARYALL_PERSON_ID','=','hrd_person.ID')
    ->where('SALARYALL_YEAR_ID','=',$year)
    ->where('SALARYALL_MONTH_ID','=',$month)
    ->orderBy('SALARYALL_PERSON_NAME', 'asc') 
    ->get();


    return view('manager_compensation.excelsalaryslip',[
        'infopersons' => $infoperson, 
        'year' => $year, 
        'month' => $month 
      
    ]);
}

public static function perlistpay($year,$month,$iduser)
{
    $paypersons = Salaryallpay::leftJoin('salary_all','salary_all.SALARYALL_ID','=','salary_all_pay.SALARYALL_ID')
    ->where('SALARYALL_PERSON_ID','=',$iduser)
    ->where('SALARYALL_PAY_YEAR','=',$year)
    ->where('SALARYALL_PAY_MONTH','=',$month)
    ->get();
    $output='<br>'; 
            $munber2=0;
        foreach ($paypersons as $payperson) {
            $munber2++;   
            $output.= $munber2.'::'.$payperson->SALARYALL_PAY_LISTNAME.'::'.$payperson->SALARYALL_PAY_AMOUNT.'<br>';
          
            }

          
    return $output;
}

//==========================//
public function export_callcompensationdetail_sub(Request $request,$refid)
{
   
    $infoorg = DB::table('info_org')->where('ORG_ID','=',1)
    ->leftJoin('hrd_person','hrd_person.ID','=','info_org.ORG_LEADER_ID')
    ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->first();
    
    $salary_all =  DB::table('salary_all')->where('SALARYALL_ID','=',$refid)->first();
    $totalreceive =  DB::table('salary_all_receive')->where('SALARYALL_ID','=',$refid)->sum('SALARYALL_RECEIVE_AMOUNT');                                     
    $totalpay =  DB::table('salary_all_pay')->where('SALARYALL_ID','=',$refid)->sum('SALARYALL_PAY_AMOUNT');     

    $salary_allc =  DB::table('salary_all_receive')
    ->where('SALARYALL_ID','=',$refid)
    ->count();  


    if($salary_all->SALARYALL_TYPE == 'salary'){
        $typename = 'เงินเดือน';
    }else{
        $typename = 'ค่าตอบแทน';
    }
    $receivepersons =  DB::table('salary_all_receive')->where('SALARYALL_ID','=',$refid)->get();                                     
    $paypersons =  DB::table('salary_all_pay')->where('SALARYALL_ID','=',$refid)->get();     

    $month =$salary_all->SALARYALL_MONTH_ID;

    $se = ceil($salary_all->SALARYALL_TOTAL );

    $pdf = PDF::loadView('manager_compensation.export_pdfcallcompensationdetail_sub',[
        'salary_all' => $salary_all,
        'totalreceive' => $totalreceive,
        'totalpay' => $totalpay,
        'receivepersons' => $receivepersons,
        'typename' => $typename,
        'paypersons' => $paypersons,
        'infoorg' => $infoorg,
        'month' => $month,
        'salary_allc' => $salary_allc,
        'se' => $se,
        
    ]);

    return @$pdf->stream();
}

//==========================//
public function export_pdfcertificate(Request $request,$refid)
{
   
    $infoorg = DB::table('info_org')->where('ORG_ID','=',1)
    ->leftJoin('hrd_person','hrd_person.ID','=','info_org.ORG_LEADER_ID')
    ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->first();

    $infocertificate = DB::table('salary_certificate')
    ->leftJoin('hrd_person','hrd_person.ID','=','salary_certificate.CER_HR_PERSON_ID')
    ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
    ->leftJoin('hrd_person_type','hrd_person.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
    ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
    ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
    ->where('CER_ID','=',$refid)->first();

    $infocersub =  DB::table('salary_certificate_sub')->where('CER_ID','=',$refid)->get();
    $suminfocersum =  DB::table('salary_certificate_sub')->where('CER_ID','=',$refid)->sum('CERSUB_AMOUNT');

    $hrddepartment = DB::table('hrd_department')->where('HR_DEPARTMENT_ID','=',1)->first();
    
        
    $pdf = PDF::loadView('manager_compensation.export_pdfcertificate',[
        'infoorg' => $infoorg,
        'hrddepartment' => $hrddepartment,
        'infocertificate' => $infocertificate,
        'infocersubs' => $infocersub,
        'suminfocersum' => $suminfocersum,
    ]);

    return @$pdf->stream();
}
//==========================//
public function export_pdfborrow(Request $request,$idref)
{
    $infoorg = DB::table('info_org')->where('ORG_ID','=',1)
    ->leftJoin('hrd_person','hrd_person.ID','=','info_org.ORG_LEADER_ID')
    ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->first();

    $infosalaryborrow = DB::table('salary_borrow')
    ->leftJoin('hrd_person','hrd_person.ID','=','salary_borrow.BORROW_HR_PERSON_ID')
    ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
    ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
    ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
    ->where('BORROW_ID','=',$idref)->first();

    $id_user = Auth::user()->PERSON_ID;   

    $infover = DB::table('hrd_person')->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->where('ID','=',$id_user )->first();

    $detaillist = DB::table('salary_borrow_sub')->where('BORROW_ID','=',$idref)->get();
    $sumdetaillist = DB::table('salary_borrow_sub')->where('BORROW_ID','=',$idref)->sum('BORROW_SUB_PICE');

    if($infosalaryborrow->BORROW_DATE_AMOUNT <> '' && $infosalaryborrow->BORROW_DATE_AMOUNT <> null){
        $BORROWDATEAMOUNT = $infosalaryborrow->BORROW_DATE_AMOUNT;
    }else{
        $BORROWDATEAMOUNT = '30';
    }
        
    $pdf = PDF::loadView('manager_compensation.export_pdfborrow',[
        'infoorg' => $infoorg,
        'infosalaryborrow' => $infosalaryborrow,
        'infover' => $infover,
        'detaillists' => $detaillist,
        'sumdetaillist' => $sumdetaillist,
        'BORROWDATEAMOUNT' => $BORROWDATEAMOUNT,
    ]);
    return @$pdf->stream();
}

public function export_pdfreturnborrow(Request $request,$idref)
{
    $infoorg = DB::table('info_org')->where('ORG_ID','=',1)
    ->leftJoin('hrd_person','hrd_person.ID','=','info_org.ORG_LEADER_ID')
    ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->first();

    $infomation = DB::table('salary_borrow')->where('BORROW_ID','=',$idref)->first();

    $infomun = DB::table('salary_borrow_sub')->where('BORROW_ID','=',$idref)->sum('BORROW_SUB_PICE');

  
    $infopersonref = DB::table('hrd_person')->where('ID','=',$infomation->BORROW_HR_PERSON_ID)->first();

    $infodep = DB::table('salary_borrow')->where('BORROW_ID','=',$idref)
    ->leftJoin('hrd_person','hrd_person.ID','=','salary_borrow.BORROW_HR_PERSON_ID')
    ->first();
    

    $infohead = DB::table('hrd_department_sub_sub')
    ->leftJoin('hrd_person','hrd_person.ID','=','hrd_department_sub_sub.LEADER_HR_ID')
    ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->where('hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=',$infodep->HR_DEPARTMENT_SUB_SUB_ID)
    ->first();


    $info_staff = DB::table('salary_staff')
    ->leftJoin('hrd_person','hrd_person.ID','=','salary_staff.STAFF_HR_ID')
    ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->where('salary_staff.STAFF_ID','=','1')
    ->first();
    
    $info_leader= DB::table('salary_staff')
    ->leftJoin('hrd_person','hrd_person.ID','=','salary_staff.STAFF_LEADER_ID')
    ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->where('salary_staff.STAFF_ID','=','1')
    ->first();
    
    

    $hrddepartment = DB::table('hrd_department')->where('HR_DEPARTMENT_ID','=',1)->first();  

    $pdf = PDF::loadView('manager_compensation.export_pdfreborrow',[
        'infoorg' => $infoorg,
        'hrddepartment' => $hrddepartment,
        'infomation' => $infomation,
        'infohead' => $infohead,
        'infomun' => $infomun,
        'info_leader' => $info_leader,
        'info_staff' => $info_staff,
        'infopersonref' => $infopersonref,
    ]);
    return @$pdf->stream();
}

public function export_pdfborrowblack(Request $request,$idref)
{
   
    $pdf = PDF::loadView('manager_compensation.export_pdfborrowblack ');
    return @$pdf->stream();
}
//==========================//
public function export_pdfslip(Request $request,$refid)
{
   
    $infoorg = DB::table('info_org')->where('ORG_ID','=',1)
    ->leftJoin('hrd_person','hrd_person.ID','=','info_org.ORG_LEADER_ID')
    ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->first();

    $infosalary = DB::table('salary_all')->select('salary_all.created_at','SALARYALL_MONTH_ID','SALARYALL_YEAR_ID','SALARYALL_YEAR_ID','HR_POSITION_NUM','SALARYALL_PERSON_NAME','HR_CID','POSITION_IN_WORK','SALARYALL_BOOK_NUM','SALARYALL_TOTAL') 
    ->leftJoin('hrd_person','hrd_person.ID','=','salary_all.SALARYALL_PERSON_ID')
    ->where('SALARYALL_ID','=',$refid)->first();

    
    
    $inforeceive = DB::table('salary_all_receive')->where('SALARYALL_ID','=',$refid)->get();

    $infopay = DB::table('salary_all_pay')->where('SALARYALL_ID','=',$refid)->get();


    $suminforeceive = DB::table('salary_all_receive')->where('SALARYALL_ID','=',$refid)->sum('SALARYALL_RECEIVE_AMOUNT');

    $suminfopay = DB::table('salary_all_pay')->where('SALARYALL_ID','=',$refid)->sum('SALARYALL_PAY_AMOUNT');

        
    $pdf = PDF::loadView('manager_compensation.export_pdfslip',[
        'infoorg' => $infoorg,
        'infosalary' => $infosalary,
        'inforeceives' => $inforeceive,
        'infopays' => $infopay,
        'suminforeceive' => $suminforeceive,
        'suminfopay' => $suminfopay,
    ]);


    return @$pdf->stream();
}


//==================================================

  
  public function infopersonsalary()
  {
 
    $m_budget = date('m');
    if($m_budget>9){
    $yearbudget = date("Y")+544;
  
    }else{
    $yearbudget = date("Y")+543;
   
    }


       $infolistperson = Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                       ->leftJoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_SUB_ID')
                       ->orderBy('hrd_person.HR_FNAME', 'asc')    
                       ->get();
                       $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
     
      return view('manager_compensation.infopersonsalary',[
          'infopersons' => $infolistperson,
          'budgets' =>  $budget,
          'year_id' => $yearbudget
        
          ]);
  }





  public function infopersonsalarydetail(Request $request,$iduser)
  {

      $inforperson =  Person::where('ID','=',$iduser)->first();


      
      $inforpersonuser =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
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
      ->where('hrd_person.ID','=',$iduser)->first();
  
      $year = date('Y')+543;

      $infosalary = DB::table('salary_all_head')
      ->leftjoin('salary_all','salary_all.SALARYALL_HEAD_ID','=','salary_all_head.SALARYALL_HEAD_ID')
      ->where('SALARYALL_YEAR_ID','=',$year)
      ->where('SALARYALL_PERSON_ID','=',$iduser)
      ->orderBy('SALARYALL_MONTH_ID', 'asc')
      ->get();

      $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
  
      $checkyear = date('Y')+543;
      return view('manager_compensation.infopersonsalarydetail',[
          'inforperson' => $inforperson,
          'inforpersonuser' => $inforpersonuser,
          'infosalarys' => $infosalary,
          'budgets' => $budget,
          'checkyear' => $checkyear,
          
      ]);
  }

  
  public function infopersonsalarydetail_search(Request $request,$iduser)
  {

      $inforperson =  Person::where('ID','=',$iduser)->first();


      
      $inforpersonuser =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
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
      ->where('hrd_person.ID','=',$iduser)->first();
  
      $year = $request->BUDGET_YEAR;

      $infosalary = DB::table('salary_all_head')
      ->leftjoin('salary_all','salary_all.SALARYALL_HEAD_ID','=','salary_all_head.SALARYALL_HEAD_ID')
      ->where('SALARYALL_YEAR_ID','=',$year)
      ->where('SALARYALL_PERSON_ID','=',$iduser)
      ->orderBy('SALARYALL_MONTH_ID', 'asc')
      ->get();

      $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
  
      $checkyear = $year;
      return view('manager_compensation.infopersonsalarydetail',[
          'inforperson' => $inforperson,
          'inforpersonuser' => $inforpersonuser,
          'infosalarys' => $infosalary,
          'budgets' => $budget,
          'checkyear' => $checkyear,
          
      ]);
  }
  



  public static function borrowtotal($id)
  {
       $sumamount =  DB::table('salary_borrow_sub')->where('BORROW_ID','=',$id)->sum('BORROW_SUB_PICE');
       
    
       return $sumamount;
  }


  
  public function infodetailcompensation(Request $request)
  {
    if($request->method() === 'POST'){
        $year_id = $request->YEAR_ID;
        $m_budget = $request->MONTH_ID;
        $typecode = $request->TYPE_CODE;
        $data_search = json_encode_u([
            'year_id' => $year_id,
            'm_budget' => $m_budget,
            'typecode' => $typecode,
        ]);
        Cookie::queue('data_search', $data_search, 120,$request->server('REQUEST_URI'));
    }elseif(!empty(Cookie::get('data_search'))){
        $data_search    = json_decode(Cookie::get('data_search'));
        $year_id     = $data_search->year_id;
        $m_budget     = $data_search->m_budget;
        $typecode     = $data_search->typecode;
    }else{
        $year_id    = '';
        $m_budget   = '';
        $typecode   = '';
    }

    $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
      $infosalaryhead = DB::table('salary_all_head')
      ->where('SALARYALL_HEAD_YEAR_ID','=',$year_id)
      ->where('SALARYALL_HEAD_MONTH_ID','like','%'.$m_budget.'%')
      ->where('SALARYALL_HEAD_TYPE','like','%'.$typecode.'%')
      ->get();
      $counthead = DB::table('salary_all_head')
      ->where('SALARYALL_HEAD_YEAR_ID','=',$year_id)
      ->where('SALARYALL_HEAD_MONTH_ID','like','%'.$m_budget.'%')
      ->where('SALARYALL_HEAD_TYPE','like','%'.$typecode.'%')
      ->count();
      $sumamountall =  DB::table('salary_all')
       ->leftjoin('salary_all_head','salary_all_head.SALARYALL_HEAD_ID','=','salary_all.SALARYALL_HEAD_ID')
      ->where('SALARYALL_HEAD_YEAR_ID','=',$year_id)
      ->where('SALARYALL_HEAD_MONTH_ID','like','%'.$m_budget.'%')
      ->where('SALARYALL_HEAD_TYPE','like','%'.$typecode.'%')
      ->sum('SALARYALL_TOTAL');
      return view('manager_compensation.infodetailcompensation',[
        'infosalaryheads' => $infosalaryhead,
        'budgets' =>  $budget,
        'year_id'=>$year_id, 
        'm_budget' =>$m_budget,
        'counthead' =>$counthead,
        'sumamountall' =>$sumamountall,
        'typecode' =>$typecode,
                ]);
  }


  public function infodetailcompensationsearch(Request $request)
  {

    $year_id = $request->YEAR_ID;
    $m_budget = $request->MONTH_ID;
    $typecode = $request->TYPE_CODE;

    $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
  
      $infosalaryhead = DB::table('salary_all_head')
      ->where('SALARYALL_HEAD_YEAR_ID','=',$year_id)
      ->where('SALARYALL_HEAD_MONTH_ID','like','%'.$m_budget.'%')
      ->where('SALARYALL_HEAD_TYPE','like','%'.$typecode.'%')
      ->get();

      $counthead = DB::table('salary_all_head')
      ->where('SALARYALL_HEAD_YEAR_ID','=',$year_id)
      ->where('SALARYALL_HEAD_MONTH_ID','like','%'.$m_budget.'%')
      ->where('SALARYALL_HEAD_TYPE','like','%'.$typecode.'%')
      ->count();


      $sumamountall =  DB::table('salary_all')
       ->leftjoin('salary_all_head','salary_all_head.SALARYALL_HEAD_ID','=','salary_all.SALARYALL_HEAD_ID')
      ->where('SALARYALL_HEAD_YEAR_ID','=',$year_id)
      ->where('SALARYALL_HEAD_MONTH_ID','like','%'.$m_budget.'%')
      ->where('SALARYALL_HEAD_TYPE','like','%'.$typecode.'%')
      ->sum('SALARYALL_TOTAL');

      return view('manager_compensation.infodetailcompensation',[
        'infosalaryheads' => $infosalaryhead,
        'budgets' =>  $budget,
        'year_id'=>$year_id, 
        'm_budget' =>$m_budget,
        'counthead' =>$counthead,
        'sumamountall' =>$sumamountall,
        'typecode' =>$typecode,
                ]);

  }

  public function infodetailcompensation_linenotify($salary_head_id){
        $Salaryallhead = Salaryallhead::find($salary_head_id);
        if(empty($Salaryallhead)){
            return redirect(route('mcompensation.infodetailcompensation'));
        }
        $Salaryallhead->SALARYALL_IS_SENDED = 1;
        $Salaryallhead->save();

        $salary_all = Salaryallhead::leftJoin('salary_all','salary_all.SALARYALL_HEAD_ID','salary_all_head.SALARYALL_HEAD_ID')
        ->leftJoin('hrd_person','hrd_person.ID','salary_all.SALARYALL_PERSON_ID')
        ->orderBy('SALARYALL_PERSON_NAME', 'asc') 
        ->where('salary_all_head.SALARYALL_HEAD_ID',$salary_head_id)->get();
        $salaryreceive = Salaryallreceive::where(function($q) use ($salary_all){
            foreach ($salary_all as $row) {
                $q->orWhere('SALARYALL_ID',$row->SALARYALL_ID);
            }
        })->get();
        $salarypay = Salaryallpay::where(function($q) use ($salary_all){
            foreach ($salary_all as $row) {
                $q->orWhere('SALARYALL_ID',$row->SALARYALL_ID);
            }
        })->get();
        $arr = array();
        foreach ($salary_all as $row) {
            $receive = array();
            $sumreceive = 0;
            foreach($salaryreceive as $key => $receive_){
                if($row->SALARYALL_ID == $receive_->SALARYALL_ID){
                    $sumreceive += (float) $receive_->SALARYALL_RECEIVE_AMOUNT;
                    $receive[] = [
                        'name'=> $receive_->SALARYALL_RECEIVE_LISTNAME,
                        'salary'=> $receive_->SALARYALL_RECEIVE_AMOUNT
                    ];
                    unset($salaryreceive[$key]);
                }
            }
            $pay = array();
            $sumpay = 0;
            foreach($salarypay as $key => $pay_){
                if($row->SALARYALL_ID == $pay_->SALARYALL_ID){
                    $sumpay += (float) $pay_->SALARYALL_PAY_AMOUNT;
                    $pay[] = [
                        'name'=> $pay_->SALARYALL_PAY_LISTNAME,
                        'salary'=> $pay_->SALARYALL_PAY_AMOUNT
                    ];
                    unset($salarypay[$key]);
                }
            }

            $msg = 'รายได้ประจำวันที่ '.$row->SALARYALL_HEAD_DAY_ID.'/'.$row->SALARYALL_MONTH_ID.'/'.$row->SALARYALL_YEAR_ID.PHP_EOL.
                    'ชื่อ '.$row->SALARYALL_PERSON_NAME.PHP_EOL.
                    'ตำแหน่ง '.$row->POSITION_IN_WORK.PHP_EOL.
                    'รายรับ '.number_format($sumreceive,2).PHP_EOL.
                    'รายจ่าย '.number_format($sumpay,2).PHP_EOL.
                    'สุทธิ '.number_format(($sumreceive - $sumpay),2).PHP_EOL.
                    '*****************************'.PHP_EOL.
                    'รายรับ'.PHP_EOL;
            $number = 1;
            foreach ($receive as $receive_set) {
                if(!empty($receive_set['salary'])){
                    $msg .= $number++.'. '.$receive_set['name'].' :: '.$receive_set['salary'].PHP_EOL;
                }
            }
            $msg .= 'รายจ่าย'.PHP_EOL;
            $number = 1;
            foreach ($pay as $pay_set) {
                if(!empty($pay_set['salary'])){
                    $msg .= $number++.'. '.$pay_set['name'].' :: '.$pay_set['salary'].PHP_EOL;
                }
            }
            $msg .= '*****************************';
            $arr[] = $msg; 
            Line::msg_notify($msg,$row->HR_LINE);
        }
        return redirect(route('mcompensation.infodetailcompensation'));
  }

  public static function compensationvalue($id)
  {
       $sumamount =  DB::table('salary_all')->where('SALARYALL_HEAD_ID','=',$id)->sum('SALARYALL_TOTAL');
       
    
       return $sumamount;
  }


  


  public function callcompensationdetail_sub(Request $request,$idref)
  {
   
     $infohead = DB::table('salary_all_head')->where('SALARYALL_HEAD_ID','=',$idref)->first();
           
      $infoperson =  Salaryall::leftJoin('hrd_person','salary_all.SALARYALL_PERSON_ID','=','hrd_person.ID')
          ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
          ->leftJoin('hrd_person_type','hrd_person.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
          ->leftJoin('hrd_department_sub','hrd_department_sub.HR_DEPARTMENT_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_ID')
          ->where('SALARYALL_HEAD_ID','=',$idref)
          ->orderBy('SALARYALL_PERSON_NAME', 'asc') 
          ->get();

          $infocount =  Salaryall::leftJoin('hrd_person','salary_all.SALARYALL_PERSON_ID','=','hrd_person.ID')
          ->leftJoin('hrd_person_type','hrd_person.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
          ->leftJoin('hrd_department_sub','hrd_department_sub.HR_DEPARTMENT_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_ID')
          ->where('SALARYALL_HEAD_ID','=',$idref)
          ->orderBy('SALARYALL_PERSON_NAME', 'asc') 
          ->count();

          $total =  Salaryall::leftJoin('hrd_person','salary_all.SALARYALL_PERSON_ID','=','hrd_person.ID')
          ->leftJoin('hrd_person_type','hrd_person.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
          ->leftJoin('hrd_department_sub','hrd_department_sub.HR_DEPARTMENT_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_ID')
          ->where('SALARYALL_HEAD_ID','=',$idref)
          ->orderBy('SALARYALL_PERSON_NAME', 'asc') 
          ->sum('SALARYALL_TOTAL');


          $search= '';

      return view('manager_compensation.callcompensationdetail_sub',[
          'infopersons' => $infoperson,
          'infohead' => $infohead,
          'infocount' => $infocount,
          'total' => $total,
          'search' => $search,
    
          
          ]); 
  }


  public function callcompensationdetail_subsearch(Request $request,$idref)
  {

    $search = $request->get('search');


    if($search==''){
        $search="";
    }
   
     $infohead = DB::table('salary_all_head')->where('SALARYALL_HEAD_ID','=',$idref)->first();
           
      $infoperson =  Salaryall::leftJoin('hrd_person','salary_all.SALARYALL_PERSON_ID','=','hrd_person.ID')
          ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
          ->leftJoin('hrd_person_type','hrd_person.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
          ->leftJoin('hrd_department_sub','hrd_department_sub.HR_DEPARTMENT_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_ID')
          ->where('SALARYALL_HEAD_ID','=',$idref)
          ->where(function($q) use ($search){
            $q->where('HR_FNAME','like','%'.$search.'%');
            $q->orwhere('HR_LNAME','like','%'.$search.'%');  
            $q->orwhere('POSITION_IN_WORK','like','%'.$search.'%');
            $q->orwhere('HR_DEPARTMENT_SUB_NAME','like','%'.$search.'%');
            $q->orwhere('HR_PERSON_TYPE_NAME','like','%'.$search.'%');
            $q->orwhere('BOOK_BANK_NUMBER','like','%'.$search.'%');
        })
          ->orderBy('SALARYALL_PERSON_NAME', 'asc') 
          ->get();


          $infocount =  Salaryall::leftJoin('hrd_person','salary_all.SALARYALL_PERSON_ID','=','hrd_person.ID')
          ->leftJoin('hrd_person_type','hrd_person.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
          ->leftJoin('hrd_department_sub','hrd_department_sub.HR_DEPARTMENT_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_ID')
          ->where('SALARYALL_HEAD_ID','=',$idref)
          ->where(function($q) use ($search){
            $q->where('HR_FNAME','like','%'.$search.'%');
            $q->orwhere('HR_LNAME','like','%'.$search.'%');  
            $q->orwhere('POSITION_IN_WORK','like','%'.$search.'%');
            $q->orwhere('HR_DEPARTMENT_SUB_NAME','like','%'.$search.'%');
            $q->orwhere('HR_PERSON_TYPE_NAME','like','%'.$search.'%');
            $q->orwhere('BOOK_BANK_NUMBER','like','%'.$search.'%');
        })
          ->orderBy('SALARYALL_PERSON_NAME', 'asc') 
          ->count();

          $total =  Salaryall::leftJoin('hrd_person','salary_all.SALARYALL_PERSON_ID','=','hrd_person.ID')
          ->leftJoin('hrd_person_type','hrd_person.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
          ->leftJoin('hrd_department_sub','hrd_department_sub.HR_DEPARTMENT_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_ID')
          ->where('SALARYALL_HEAD_ID','=',$idref)
          ->where(function($q) use ($search){
            $q->where('HR_FNAME','like','%'.$search.'%');
            $q->orwhere('HR_LNAME','like','%'.$search.'%');  
            $q->orwhere('POSITION_IN_WORK','like','%'.$search.'%');
            $q->orwhere('HR_DEPARTMENT_SUB_NAME','like','%'.$search.'%');
            $q->orwhere('HR_PERSON_TYPE_NAME','like','%'.$search.'%');
            $q->orwhere('BOOK_BANK_NUMBER','like','%'.$search.'%');
        })
          ->orderBy('SALARYALL_PERSON_NAME', 'asc') 
          ->sum('SALARYALL_TOTAL');


      return view('manager_compensation.callcompensationdetail_sub',[
          'infopersons' => $infoperson,
          'infohead' => $infohead,
          'infocount' => $infocount,
          'total' => $total,
          'search' => $search,
          
          ]); 
  }


  


  public function callcompensationdetail_subexcel(Request $request,$idref)
  {
   
     $infohead = DB::table('salary_all_head')->where('SALARYALL_HEAD_ID','=',$idref)->first();
           
      $infoperson =  Salaryall::leftJoin('hrd_person','salary_all.SALARYALL_PERSON_ID','=','hrd_person.ID')
          ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
          ->leftJoin('hrd_person_type','hrd_person.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
          ->leftJoin('hrd_department_sub','hrd_department_sub.HR_DEPARTMENT_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_ID')
          ->where('SALARYALL_HEAD_ID','=',$idref)
          ->orderBy('SALARYALL_PERSON_NAME', 'asc') 
          ->get();

          $total =  Salaryall::leftJoin('hrd_person','salary_all.SALARYALL_PERSON_ID','=','hrd_person.ID')
          ->leftJoin('hrd_person_type','hrd_person.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
          ->leftJoin('hrd_department_sub','hrd_department_sub.HR_DEPARTMENT_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_ID')
          ->where('SALARYALL_HEAD_ID','=',$idref)
          ->orderBy('SALARYALL_PERSON_NAME', 'asc') 
          ->sum('SALARYALL_TOTAL');


      return view('manager_compensation.callcompensationdetail_subexcel',[
          'infopersons' => $infoperson,
          'infohead' => $infohead,
          'total' => $total,
          ]); 
  }

  //======================excel รายงานสรุป

  

  public function reportcallcompensationdetail_excel(Request $request,$idref)
  {
   
     $infohead = DB::table('salary_all_head')->where('SALARYALL_HEAD_ID','=',$idref)->first();
           
      $infoperson =  Salaryall::leftJoin('hrd_person','salary_all.SALARYALL_PERSON_ID','=','hrd_person.ID')
          ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
          ->leftJoin('hrd_person_type','hrd_person.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
          ->leftJoin('hrd_department_sub','hrd_department_sub.HR_DEPARTMENT_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_ID')
          ->where('SALARYALL_HEAD_ID','=',$idref)
          ->orderBy('SALARYALL_PERSON_NAME', 'asc') 
          ->get();

          $total =  Salaryall::leftJoin('hrd_person','salary_all.SALARYALL_PERSON_ID','=','hrd_person.ID')
          ->leftJoin('hrd_person_type','hrd_person.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
          ->leftJoin('hrd_department_sub','hrd_department_sub.HR_DEPARTMENT_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_ID')
          ->where('SALARYALL_HEAD_ID','=',$idref)
          ->orderBy('SALARYALL_PERSON_NAME', 'asc') 
          ->sum('SALARYALL_TOTAL');

        $inforeceive_list = DB::table('salary_receive')->where('ACTIVE','=','TRUE')->where('HR_RECEIVE_TYPE','=',$infohead->SALARYALL_HEAD_TYPE)->get(); 
        $infopay_list = DB::table('salary_pay')->where('ACTIVE','=','TRUE')->where('HR_PAY_TYPE','=',$infohead->SALARYALL_HEAD_TYPE)->get(); 
          

        $infohrdpersontype = DB::table('hrd_person_type')->get();
      return view('manager_compensation.reportcallcompensationdetail_excel',[
          'infopersons' => $infoperson,
          'infohead' => $infohead,
          'total' => $total,
          'inforeceive_lists' => $inforeceive_list,
          'infopay_lists' => $infopay_list,
          'infohrdpersontypes' => $infohrdpersontype,
          ]); 
  }

  //============================คั้งค่าเจ้าหน้าที่บัญชี

public function staff(Request $request)
  {
               
    $infolistperson = Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->leftJoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_person.HR_DEPARTMENT_SUB_SUB_ID')
    ->orderBy('hrd_person.HR_FNAME', 'asc')    
    ->get();

    $infostaff = Salarystaff::where('STAFF_ID','=',1)->first();

    
      return view('manager_compensation.staff',[
          'infolistpersons' => $infolistperson,
          'infostaff' => $infostaff,
          ]); 
  }


  public function updatestaff(Request $request)
  {
   
    
    $update = Salarystaff::find(1);  
    $update->STAFF_HR_ID = $request->STAFF_HR_ID;
    $update->STAFF_LEADER_ID = $request->STAFF_LEADER_ID;
    $update->save();

      return redirect()->route('mcompensation.staff'); 
  }


  public function purchase(Request $request)
  {    
    if($request->method() === 'POST'){
        $search     = $request->get('search');
        $status     = $request->SEND_STATUS;
        $dateselect = $request->DATE_SELECT;
        $datebigin  = $request->get('DATE_BIGIN');
        $dateend    = $request->get('DATE_END');
        $yearbudget = $request->BUDGET_YEAR;
        $data_search = json_encode_u([
            'search' => $search,
            'yearbudget' => $yearbudget,
            'dateselect' => $dateselect,
            'datebigin' => $datebigin,
            'dateend' => $dateend,
            'status' => $status,
        ]);
        Cookie::queue('data_search', $data_search, 120,$request->server('REQUEST_URI'));
    }elseif(!empty(Cookie::get('data_search'))){
        $data_search    = json_decode(Cookie::get('data_search'));
        $search     = $data_search->search;
        $yearbudget     = $data_search->yearbudget;
        $dateselect     = $data_search->dateselect;
        $datebigin     = $data_search->datebigin;
        $dateend     = $data_search->dateend;
        $status     = $data_search->status;
    }else{
        $search     = '';
        $yearbudget = getBudgetYear();
        $dateselect = '';
        $datebigin  = date('01/10/'.($yearbudget-1));
        $dateend    = date('30/09/'.$yearbudget);
        $status       = '';
    }
    $date_bigen_c = Carbon::createFromFormat('d/m/Y', $datebigin)->format('Y-m-d');
    $date_arrary=explode("-",$date_bigen_c);
    $y_sub_st = $date_arrary[0];
    if($y_sub_st >= 2500){
        $y = $y_sub_st-543;
    }else{
        $y = $y_sub_st;
    }
    $m = $date_arrary[1];
    $d = $date_arrary[2];  
    $displaydate_bigen= $y."-".$m."-".$d;
    $date_end_c = Carbon::createFromFormat('d/m/Y', $dateend)->format('Y-m-d');
    $date_arrary_e=explode("-",$date_end_c); 
    $y_sub_e = $date_arrary_e[0];
    if($y_sub_e >= 2500){
        $y_e = $y_sub_e-543;
    }else{
        $y_e = $y_sub_e;
    }
    $m_e = $date_arrary_e[1];
    $d_e = $date_arrary_e[2];  
    $displaydate_end= $y_e."-".$m_e."-".$d_e;
    $from = date($displaydate_bigen);
    $to = date($displaydate_end);
    if($dateselect == 'd2'){
        $DATESELECT = 'CHECK_DATE';
    }else{
        $DATESELECT = 'DATE_REGIS';
    }
    if($status == null){
        $infosupcon = Suppliescon::select('supplies_con.ID','CON_YEAR_ID','CON_NUM','supplies_request.REQUEST_ID','REGIS_STATUS_NAME','DATE_REGIS','EGP_PLAN_NAME','SUP_TYPE_NAME','VENDOR_NAME','supplies_con.BUDGET_SUM','CHECK_DATE','supplies_status_regis.REGIS_STATUS_ID','supplies_buy.BUY_NAME','supplies_budget.BUDGET_NAME')
        ->leftJoin('supplies_status_regis','supplies_con.REGIS_STATUS_ID','=','supplies_status_regis.REGIS_STATUS_ID')
        ->leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
        ->leftJoin('supplies_request','supplies_con.REQUEST_ID','=','supplies_request.ID')
        ->leftJoin('supplies_buy','supplies_con.BUY_ID','=','supplies_buy.BUY_ID')
        ->leftJoin('supplies_budget','supplies_con.BUDGET_ID','=','supplies_budget.BUDGET_ID')
        ->where('supplies_con.CON_YEAR_ID','=',$yearbudget)
        ->where(function($q) use ($search){
            $q->where('EGP_PLAN_NAME','like','%'.$search.'%');
            $q->orwhere('VENDOR_NAME','like','%'.$search.'%');
            $q->orwhere('CON_NUM','like','%'.$search.'%'); 
            $q->orwhere('supplies_con.BUDGET_SUM','like','%'.$search.'%');  
            $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');    
            $q->orwhere('supplies_request.REQUEST_ID','like','%'.$search.'%'); 
            $q->orwhere('BUDGET_NAME','like','%'.$search.'%'); 
            $q->orwhere('BUY_NAME','like','%'.$search.'%'); 
        })
        ->WhereBetween($DATESELECT,[$from,$to]) 
        ->orderBy('supplies_con.ID', 'desc')->get();
        $budgetsum =  Suppliescon::select('supplies_con.ID','CON_YEAR_ID','CON_NUM','supplies_request.REQUEST_ID','REGIS_STATUS_NAME','DATE_REGIS','EGP_PLAN_NAME','SUP_TYPE_NAME','VENDOR_NAME','supplies_con.BUDGET_SUM','CHECK_DATE','supplies_status_regis.REGIS_STATUS_ID','supplies_buy.BUY_NAME','supplies_budget.BUDGET_NAME')
        ->leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
        ->leftJoin('supplies_request','supplies_con.REQUEST_ID','=','supplies_request.ID')
        ->leftJoin('supplies_buy','supplies_con.BUY_ID','=','supplies_buy.BUY_ID')
        ->leftJoin('supplies_budget','supplies_con.BUDGET_ID','=','supplies_budget.BUDGET_ID')
        ->where('supplies_con.CON_YEAR_ID','=',$yearbudget)
        ->where(function($q) use ($search){
            $q->where('EGP_PLAN_NAME','like','%'.$search.'%');
            $q->orwhere('VENDOR_NAME','like','%'.$search.'%');
            $q->orwhere('CON_NUM','like','%'.$search.'%'); 
            $q->orwhere('supplies_con.BUDGET_SUM','like','%'.$search.'%');  
            $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');  
            $q->orwhere('supplies_request.REQUEST_ID','like','%'.$search.'%');  
            $q->orwhere('BUDGET_NAME','like','%'.$search.'%'); 
            $q->orwhere('BUY_NAME','like','%'.$search.'%');  
        })
        ->WhereBetween($DATESELECT,[$from,$to])
        ->sum('supplies_con.BUDGET_SUM');
        $count =  Suppliescon::select('supplies_con.ID','CON_YEAR_ID','CON_NUM','supplies_request.REQUEST_ID','REGIS_STATUS_NAME','DATE_REGIS','EGP_PLAN_NAME','SUP_TYPE_NAME','VENDOR_NAME','supplies_con.BUDGET_SUM','CHECK_DATE','supplies_status_regis.REGIS_STATUS_ID','supplies_buy.BUY_NAME','supplies_budget.BUDGET_NAME')
        ->leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
        ->leftJoin('supplies_request','supplies_con.REQUEST_ID','=','supplies_request.ID')
        ->leftJoin('supplies_buy','supplies_con.BUY_ID','=','supplies_buy.BUY_ID')
        ->leftJoin('supplies_budget','supplies_con.BUDGET_ID','=','supplies_budget.BUDGET_ID')
        ->where('supplies_con.CON_YEAR_ID','=',$yearbudget)
        ->where(function($q) use ($search){
            $q->where('EGP_PLAN_NAME','like','%'.$search.'%');
            $q->orwhere('VENDOR_NAME','like','%'.$search.'%');
            $q->orwhere('CON_NUM','like','%'.$search.'%'); 
            $q->orwhere('supplies_con.BUDGET_SUM','like','%'.$search.'%');  
            $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');  
            $q->orwhere('supplies_request.REQUEST_ID','like','%'.$search.'%');  
            $q->orwhere('BUDGET_NAME','like','%'.$search.'%'); 
            $q->orwhere('BUY_NAME','like','%'.$search.'%'); 
        })
        ->WhereBetween($DATESELECT,[$from,$to])
        ->count();
    }else{
        $infosupcon = Suppliescon::select('supplies_con.ID','CON_YEAR_ID','CON_NUM','supplies_request.REQUEST_ID','REGIS_STATUS_NAME','DATE_REGIS','EGP_PLAN_NAME','SUP_TYPE_NAME','VENDOR_NAME','supplies_con.BUDGET_SUM','CHECK_DATE','supplies_status_regis.REGIS_STATUS_ID','supplies_buy.BUY_NAME','supplies_budget.BUDGET_NAME')
        ->leftJoin('supplies_status_regis','supplies_con.REGIS_STATUS_ID','=','supplies_status_regis.REGIS_STATUS_ID')
        ->where('supplies_con.REGIS_STATUS_ID','=',$status)
        ->leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
        ->leftJoin('supplies_request','supplies_con.REQUEST_ID','=','supplies_request.ID')
        ->leftJoin('supplies_buy','supplies_con.BUY_ID','=','supplies_buy.BUY_ID')
        ->leftJoin('supplies_budget','supplies_con.BUDGET_ID','=','supplies_budget.BUDGET_ID')
        ->where('supplies_con.CON_YEAR_ID','=',$yearbudget)
        ->where(function($q) use ($search){
            $q->where('EGP_PLAN_NAME','like','%'.$search.'%');
            $q->orwhere('VENDOR_NAME','like','%'.$search.'%');
            $q->orwhere('CON_NUM','like','%'.$search.'%'); 
            $q->orwhere('supplies_con.BUDGET_SUM','like','%'.$search.'%');  
            $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%'); 
            $q->orwhere('supplies_request.REQUEST_ID','like','%'.$search.'%'); 
            $q->orwhere('BUDGET_NAME','like','%'.$search.'%'); 
            $q->orwhere('BUY_NAME','like','%'.$search.'%');     
        })
        ->WhereBetween($DATESELECT,[$from,$to]) 
        ->orderBy('supplies_con.ID', 'desc')->get();
        $budgetsum =  Suppliescon::select('supplies_con.ID','CON_YEAR_ID','CON_NUM','supplies_request.REQUEST_ID','REGIS_STATUS_NAME','DATE_REGIS','EGP_PLAN_NAME','SUP_TYPE_NAME','VENDOR_NAME','supplies_con.BUDGET_SUM','CHECK_DATE','supplies_status_regis.REGIS_STATUS_ID','supplies_buy.BUY_NAME','supplies_budget.BUDGET_NAME')
        ->leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
        ->leftJoin('supplies_request','supplies_con.REQUEST_ID','=','supplies_request.ID')
        ->leftJoin('supplies_buy','supplies_con.BUY_ID','=','supplies_buy.BUY_ID')
        ->leftJoin('supplies_budget','supplies_con.BUDGET_ID','=','supplies_budget.BUDGET_ID')
        ->where('supplies_con.CON_YEAR_ID','=',$yearbudget)
        ->where('supplies_con.REGIS_STATUS_ID','=',$status)
        ->where(function($q) use ($search){
            $q->where('EGP_PLAN_NAME','like','%'.$search.'%');
            $q->orwhere('VENDOR_NAME','like','%'.$search.'%');
            $q->orwhere('CON_NUM','like','%'.$search.'%'); 
            $q->orwhere('supplies_con.BUDGET_SUM','like','%'.$search.'%');  
            $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%'); 
            $q->orwhere('supplies_request.REQUEST_ID','like','%'.$search.'%'); 
            $q->orwhere('BUDGET_NAME','like','%'.$search.'%'); 
            $q->orwhere('BUY_NAME','like','%'.$search.'%');      
        })
        ->WhereBetween($DATESELECT,[$from,$to])
        ->sum('supplies_con.BUDGET_SUM');
        $count =  Suppliescon::select('supplies_con.ID','CON_YEAR_ID','CON_NUM','supplies_request.REQUEST_ID','REGIS_STATUS_NAME','DATE_REGIS','EGP_PLAN_NAME','SUP_TYPE_NAME','VENDOR_NAME','supplies_con.BUDGET_SUM','CHECK_DATE','supplies_status_regis.REGIS_STATUS_ID','supplies_buy.BUY_NAME','supplies_budget.BUDGET_NAME')
        ->leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
        ->leftJoin('supplies_request','supplies_con.REQUEST_ID','=','supplies_request.ID')
        ->leftJoin('supplies_buy','supplies_con.BUY_ID','=','supplies_buy.BUY_ID')
        ->leftJoin('supplies_budget','supplies_con.BUDGET_ID','=','supplies_budget.BUDGET_ID')
        ->where('supplies_con.CON_YEAR_ID','=',$yearbudget)
        ->where('supplies_con.REGIS_STATUS_ID','=',$status)
        ->where(function($q) use ($search){
            $q->where('EGP_PLAN_NAME','like','%'.$search.'%');
            $q->orwhere('VENDOR_NAME','like','%'.$search.'%');
            $q->orwhere('CON_NUM','like','%'.$search.'%'); 
            $q->orwhere('supplies_con.BUDGET_SUM','like','%'.$search.'%');  
            $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');   
            $q->orwhere('supplies_request.REQUEST_ID','like','%'.$search.'%'); 
            $q->orwhere('BUDGET_NAME','like','%'.$search.'%'); 
            $q->orwhere('BUY_NAME','like','%'.$search.'%'); 
        })
        ->WhereBetween($DATESELECT,[$from,$to])
        ->count();
    }    
    $suppliesstatus = DB::table('supplies_status_regis')->get();
    $budgetyear = DB::table('budget_year')->orderByDesc('LEAVE_YEAR_ID')->get();
    return view('manager_compensation.compen_purchase',[
        'infosupcons' => $infosupcon,
        'status_check' => $status,
        'search' => $search,
        'suppliesstatuss' => $suppliesstatus,
        'displaydate_bigen' => $displaydate_bigen,
        'displaydate_end' => $displaydate_end,
        'budgetyears' => $budgetyear,
        'year_id' => $yearbudget,
        'budgetsum' => $budgetsum,
        'count' => $count,
        'dateselect' => $dateselect,
    ]); 
  }


  public function searchpurchase(Request $request)
  {
      $search = $request->get('search');
      $status = $request->SEND_STATUS;
      $dateselect = $request->DATE_SELECT;
      $datebigin = $request->get('DATE_BIGIN');
      $dateend = $request->get('DATE_END');
      $yearbudget = $request->BUDGET_YEAR;
   

      if($search==''){
          $search="";
      }
  

      $date_bigen_c = Carbon::createFromFormat('d/m/Y', $datebigin)->format('Y-m-d');
      $date_arrary=explode("-",$date_bigen_c);

      $y_sub_st = $date_arrary[0];

      if($y_sub_st >= 2500){
          $y = $y_sub_st-543;
      }else{
          $y = $y_sub_st;
      }

      $m = $date_arrary[1];
      $d = $date_arrary[2];  
      $displaydate_bigen= $y."-".$m."-".$d;

      $date_end_c = Carbon::createFromFormat('d/m/Y', $dateend)->format('Y-m-d');
      $date_arrary_e=explode("-",$date_end_c); 

      $y_sub_e = $date_arrary_e[0];

      if($y_sub_e >= 2500){
          $y_e = $y_sub_e-543;
      }else{
          $y_e = $y_sub_e;
      }

      $m_e = $date_arrary_e[1];
      $d_e = $date_arrary_e[2];  
      $displaydate_end= $y_e."-".$m_e."-".$d_e;



          $date = date('Y-m-d');
          $date_bigen_checks = strtotime($displaydate_bigen);
          $date_end_checks =  strtotime($displaydate_end);
          $dates =  strtotime($date);
  
         //dd($displaydate_bigen);
  
  
              $from = date($displaydate_bigen);
              $to = date($displaydate_end);

              if($dateselect == 'd2'){
                  $DATESELECT = 'CHECK_DATE';
              }else{
                  $DATESELECT = 'DATE_REGIS';
              }
     
  if($status == null){


      $infosupcon = Suppliescon::select('supplies_con.ID','CON_YEAR_ID','CON_NUM','supplies_request.REQUEST_ID','REGIS_STATUS_NAME','DATE_REGIS','EGP_PLAN_NAME','SUP_TYPE_NAME','VENDOR_NAME','supplies_con.BUDGET_SUM','CHECK_DATE','supplies_status_regis.REGIS_STATUS_ID','supplies_buy.BUY_NAME','supplies_budget.BUDGET_NAME')
      ->leftJoin('supplies_status_regis','supplies_con.REGIS_STATUS_ID','=','supplies_status_regis.REGIS_STATUS_ID')
      ->leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
      ->leftJoin('supplies_request','supplies_con.REQUEST_ID','=','supplies_request.ID')
      ->leftJoin('supplies_buy','supplies_con.BUY_ID','=','supplies_buy.BUY_ID')
      ->leftJoin('supplies_budget','supplies_con.BUDGET_ID','=','supplies_budget.BUDGET_ID')
      ->where('supplies_con.CON_YEAR_ID','=',$yearbudget)
      ->where(function($q) use ($search){
          $q->where('EGP_PLAN_NAME','like','%'.$search.'%');
          $q->orwhere('VENDOR_NAME','like','%'.$search.'%');
          $q->orwhere('CON_NUM','like','%'.$search.'%'); 
          $q->orwhere('supplies_con.BUDGET_SUM','like','%'.$search.'%');  
          $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');    
          $q->orwhere('supplies_request.REQUEST_ID','like','%'.$search.'%'); 
          $q->orwhere('BUDGET_NAME','like','%'.$search.'%'); 
          $q->orwhere('BUY_NAME','like','%'.$search.'%'); 
      })
      ->WhereBetween($DATESELECT,[$from,$to]) 
      ->orderBy('supplies_con.ID', 'desc')->get();

      
      $budgetsum =  Suppliescon::select('supplies_con.ID','CON_YEAR_ID','CON_NUM','supplies_request.REQUEST_ID','REGIS_STATUS_NAME','DATE_REGIS','EGP_PLAN_NAME','SUP_TYPE_NAME','VENDOR_NAME','supplies_con.BUDGET_SUM','CHECK_DATE','supplies_status_regis.REGIS_STATUS_ID','supplies_buy.BUY_NAME','supplies_budget.BUDGET_NAME')
      ->leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
      ->leftJoin('supplies_request','supplies_con.REQUEST_ID','=','supplies_request.ID')
      ->leftJoin('supplies_buy','supplies_con.BUY_ID','=','supplies_buy.BUY_ID')
      ->leftJoin('supplies_budget','supplies_con.BUDGET_ID','=','supplies_budget.BUDGET_ID')
      ->where('supplies_con.CON_YEAR_ID','=',$yearbudget)
      ->where(function($q) use ($search){
          $q->where('EGP_PLAN_NAME','like','%'.$search.'%');
          $q->orwhere('VENDOR_NAME','like','%'.$search.'%');
          $q->orwhere('CON_NUM','like','%'.$search.'%'); 
          $q->orwhere('supplies_con.BUDGET_SUM','like','%'.$search.'%');  
          $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');  
          $q->orwhere('supplies_request.REQUEST_ID','like','%'.$search.'%');  
          $q->orwhere('BUDGET_NAME','like','%'.$search.'%'); 
          $q->orwhere('BUY_NAME','like','%'.$search.'%');  
      })
      ->WhereBetween($DATESELECT,[$from,$to])
      ->sum('supplies_con.BUDGET_SUM');

      $count =  Suppliescon::select('supplies_con.ID','CON_YEAR_ID','CON_NUM','supplies_request.REQUEST_ID','REGIS_STATUS_NAME','DATE_REGIS','EGP_PLAN_NAME','SUP_TYPE_NAME','VENDOR_NAME','supplies_con.BUDGET_SUM','CHECK_DATE','supplies_status_regis.REGIS_STATUS_ID','supplies_buy.BUY_NAME','supplies_budget.BUDGET_NAME')
      ->leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
      ->leftJoin('supplies_request','supplies_con.REQUEST_ID','=','supplies_request.ID')
      ->leftJoin('supplies_buy','supplies_con.BUY_ID','=','supplies_buy.BUY_ID')
      ->leftJoin('supplies_budget','supplies_con.BUDGET_ID','=','supplies_budget.BUDGET_ID')
      ->where('supplies_con.CON_YEAR_ID','=',$yearbudget)
      ->where(function($q) use ($search){
          $q->where('EGP_PLAN_NAME','like','%'.$search.'%');
          $q->orwhere('VENDOR_NAME','like','%'.$search.'%');
          $q->orwhere('CON_NUM','like','%'.$search.'%'); 
          $q->orwhere('supplies_con.BUDGET_SUM','like','%'.$search.'%');  
          $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');  
          $q->orwhere('supplies_request.REQUEST_ID','like','%'.$search.'%');  
          $q->orwhere('BUDGET_NAME','like','%'.$search.'%'); 
          $q->orwhere('BUY_NAME','like','%'.$search.'%'); 
      })
      ->WhereBetween($DATESELECT,[$from,$to])
      ->count();



  }else{


      $infosupcon = Suppliescon::select('supplies_con.ID','CON_YEAR_ID','CON_NUM','supplies_request.REQUEST_ID','REGIS_STATUS_NAME','DATE_REGIS','EGP_PLAN_NAME','SUP_TYPE_NAME','VENDOR_NAME','supplies_con.BUDGET_SUM','CHECK_DATE','supplies_status_regis.REGIS_STATUS_ID','supplies_buy.BUY_NAME','supplies_budget.BUDGET_NAME')
      ->leftJoin('supplies_status_regis','supplies_con.REGIS_STATUS_ID','=','supplies_status_regis.REGIS_STATUS_ID')
      ->where('supplies_con.REGIS_STATUS_ID','=',$status)
      ->leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
      ->leftJoin('supplies_request','supplies_con.REQUEST_ID','=','supplies_request.ID')
      ->leftJoin('supplies_buy','supplies_con.BUY_ID','=','supplies_buy.BUY_ID')
      ->leftJoin('supplies_budget','supplies_con.BUDGET_ID','=','supplies_budget.BUDGET_ID')
      ->where('supplies_con.CON_YEAR_ID','=',$yearbudget)
      ->where(function($q) use ($search){
          $q->where('EGP_PLAN_NAME','like','%'.$search.'%');
          $q->orwhere('VENDOR_NAME','like','%'.$search.'%');
          $q->orwhere('CON_NUM','like','%'.$search.'%'); 
          $q->orwhere('supplies_con.BUDGET_SUM','like','%'.$search.'%');  
          $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%'); 
          $q->orwhere('supplies_request.REQUEST_ID','like','%'.$search.'%'); 
          $q->orwhere('BUDGET_NAME','like','%'.$search.'%'); 
          $q->orwhere('BUY_NAME','like','%'.$search.'%');     
      })
      ->WhereBetween($DATESELECT,[$from,$to]) 
      ->orderBy('supplies_con.ID', 'desc')->get();


      $budgetsum =  Suppliescon::select('supplies_con.ID','CON_YEAR_ID','CON_NUM','supplies_request.REQUEST_ID','REGIS_STATUS_NAME','DATE_REGIS','EGP_PLAN_NAME','SUP_TYPE_NAME','VENDOR_NAME','supplies_con.BUDGET_SUM','CHECK_DATE','supplies_status_regis.REGIS_STATUS_ID','supplies_buy.BUY_NAME','supplies_budget.BUDGET_NAME')
      ->leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
      ->leftJoin('supplies_request','supplies_con.REQUEST_ID','=','supplies_request.ID')
      ->leftJoin('supplies_buy','supplies_con.BUY_ID','=','supplies_buy.BUY_ID')
      ->leftJoin('supplies_budget','supplies_con.BUDGET_ID','=','supplies_budget.BUDGET_ID')
      ->where('supplies_con.CON_YEAR_ID','=',$yearbudget)
      ->where('supplies_con.REGIS_STATUS_ID','=',$status)
      ->where(function($q) use ($search){
          $q->where('EGP_PLAN_NAME','like','%'.$search.'%');
          $q->orwhere('VENDOR_NAME','like','%'.$search.'%');
          $q->orwhere('CON_NUM','like','%'.$search.'%'); 
          $q->orwhere('supplies_con.BUDGET_SUM','like','%'.$search.'%');  
          $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%'); 
          $q->orwhere('supplies_request.REQUEST_ID','like','%'.$search.'%'); 
          $q->orwhere('BUDGET_NAME','like','%'.$search.'%'); 
          $q->orwhere('BUY_NAME','like','%'.$search.'%');      
      })
      ->WhereBetween($DATESELECT,[$from,$to])
      ->sum('supplies_con.BUDGET_SUM');

      $count =  Suppliescon::select('supplies_con.ID','CON_YEAR_ID','CON_NUM','supplies_request.REQUEST_ID','REGIS_STATUS_NAME','DATE_REGIS','EGP_PLAN_NAME','SUP_TYPE_NAME','VENDOR_NAME','supplies_con.BUDGET_SUM','CHECK_DATE','supplies_status_regis.REGIS_STATUS_ID','supplies_buy.BUY_NAME','supplies_budget.BUDGET_NAME')
      ->leftJoin('supplies_type','supplies_con.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
      ->leftJoin('supplies_request','supplies_con.REQUEST_ID','=','supplies_request.ID')
      ->leftJoin('supplies_buy','supplies_con.BUY_ID','=','supplies_buy.BUY_ID')
      ->leftJoin('supplies_budget','supplies_con.BUDGET_ID','=','supplies_budget.BUDGET_ID')
      ->where('supplies_con.CON_YEAR_ID','=',$yearbudget)
      ->where('supplies_con.REGIS_STATUS_ID','=',$status)
      ->where(function($q) use ($search){
          $q->where('EGP_PLAN_NAME','like','%'.$search.'%');
          $q->orwhere('VENDOR_NAME','like','%'.$search.'%');
          $q->orwhere('CON_NUM','like','%'.$search.'%'); 
          $q->orwhere('supplies_con.BUDGET_SUM','like','%'.$search.'%');  
          $q->orwhere('SUP_TYPE_NAME','like','%'.$search.'%');   
          $q->orwhere('supplies_request.REQUEST_ID','like','%'.$search.'%'); 
          $q->orwhere('BUDGET_NAME','like','%'.$search.'%'); 
          $q->orwhere('BUY_NAME','like','%'.$search.'%'); 
      })
      ->WhereBetween($DATESELECT,[$from,$to])
      ->count();


  }    




  

      

      $suppliesstatus = DB::table('supplies_status_regis')->get();
        
      $budgetyear = DB::table('budget_year')->get();

      return view('manager_compensation.compen_purchase',[
          'infosupcons' => $infosupcon,
          'status_check' => $status,
          'search' => $search,
          'suppliesstatuss' => $suppliesstatus,
          'displaydate_bigen' => $displaydate_bigen,
          'displaydate_end' => $displaydate_end,
          'budgetyears' => $budgetyear,
          'year_id' => $yearbudget,
          'budgetsum' => $budgetsum,
          'count' => $count,
          'dateselect' => $dateselect,
         
      ]); 


    
  }


  
     
public function otindex(Request $request)
{
   

        
      $infomationot = Otindex::leftjoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','ot_index.OT_DEP_SUB_SUB')
      ->get();
         
    return view('manager_compensation.otindex',[
        'infomationots' => $infomationot, 
        
    ]);
}

public function otsetdetail_edit(Request $request,$idref)
    {

        $PERSONALL =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->get();
    
        $operat = DB::table('operate_job')->get();
    
        $hrdsubsub = DB::table('hrd_department_sub_sub')->get();
    
         $infomationot = DB::table('ot_index')
         ->leftjoin('hrd_person','hrd_person.ID','=','ot_index.OT_INDEX_PERSON_ID')
         ->where('OT_INDEX_ID','=',$idref)->first();

         $infomationotsub =  DB::table('ot_index_sub')->where('OT_INDEX_ID','=',$idref)->get();

             
        return view('manager_compensation.otsetdetail_edit',[
            'hrdsubsubs' => $hrdsubsub,
            'operats' => $operat, 
            'PERSONALLs' => $PERSONALL, 
            'infomationot' => $infomationot, 
            'infomationotsubs' => $infomationotsub, 
            'idref' => $idref, 
            
        ]);
    }


  
    public function otsetdetail_update(Request $request)
    {
  
        $idrefot = $request->idrefot;
        $idusersave = $request->OT_INDEX_PERSON_ID;

        
        $addhead = Otindex::find($idrefot);
        $addhead->OT_YEAR =  $request->OT_YEAR;
        $addhead->OT_MONTH =  $request->OT_MONTH;  
        $addhead->OT_DEP_SUB_SUB =  $request->OT_DEP_SUB_SUB;   
        $addhead->OT_TYPE =  $request->OT_TYPE;    
        $addhead->OT_INDEX_PERSON_ID =  $request->OT_INDEX_PERSON_ID;    
        $addhead->OT_PERSON_NAME =  $request->OT_PERSON_NAME;
        $addhead->save(); 

     

        Otindexsub::where('OT_INDEX_ID','=',$idrefot)->delete(); 

         if($request->OT_PERSON_ID[0] != '' || $request->OT_PERSON_ID[0] != null){

         $OT_PERSON_ID = $request->OT_PERSON_ID;
         $OT_JOB = $request->OT_JOB;
         $OT_RATE = $request->OT_RATE;
         $OT_1DAY = $request->OT_1DAY;
         $OT_2DAY = $request->OT_2DAY;
         $OT_3DAY = $request->OT_3DAY;
         $OT_4DAY = $request->OT_4DAY;
         $OT_5DAY = $request->OT_5DAY;
         $OT_6DAY = $request->OT_6DAY;
         $OT_7DAY = $request->OT_7DAY;
         $OT_8DAY = $request->OT_8DAY;
         $OT_9DAY = $request->OT_9DAY;
         $OT_10DAY = $request->OT_10DAY;
         $OT_11DAY = $request->OT_11DAY;
         $OT_12DAY = $request->OT_12DAY;
         $OT_13DAY = $request->OT_13DAY;
         $OT_14DAY = $request->OT_14DAY;
         $OT_15DAY = $request->OT_15DAY;
         $OT_16DAY = $request->OT_16DAY;
         $OT_17DAY = $request->OT_17DAY;
         $OT_18DAY = $request->OT_18DAY;
         $OT_19DAY = $request->OT_19DAY;
         $OT_20DAY = $request->OT_20DAY;
         $OT_21DAY = $request->OT_21DAY;
         $OT_22DAY = $request->OT_22DAY;
         $OT_23DAY = $request->OT_23DAY;
         $OT_24DAY = $request->OT_24DAY;
         $OT_25DAY = $request->OT_25DAY;
         $OT_26DAY = $request->OT_26DAY;
         $OT_27DAY = $request->OT_27DAY;
         $OT_28DAY = $request->OT_28DAY;
         $OT_29DAY = $request->OT_29DAY;
         $OT_30DAY = $request->OT_30DAY;
         $OT_31DAY = $request->OT_31DAY;
        

         $number =count($OT_PERSON_ID);
         
         $count = 0;
         for($count = 0; $count < $number; $count++)
         {  
    
            if($OT_RATE[$count] <> false){$amountOT_RATE = $OT_RATE[$count];}else{$amountOT_RATE = 0;}
             
            if(isset($OT_1DAY[$count]) <> false){$amountOT_1DAY = $OT_1DAY[$count];}else{$amountOT_1DAY = 0;}
            if(isset($OT_2DAY[$count]) <> false){$amountOT_2DAY = $OT_2DAY[$count];}else{$amountOT_2DAY = 0;}
            if(isset($OT_3DAY[$count]) <> false){$amountOT_3DAY = $OT_3DAY[$count];}else{$amountOT_3DAY = 0;}
            if(isset($OT_4DAY[$count]) <> false){$amountOT_4DAY = $OT_4DAY[$count];}else{$amountOT_4DAY = 0;}
            if(isset($OT_5DAY[$count]) <> false){$amountOT_5DAY = $OT_5DAY[$count];}else{$amountOT_5DAY = 0;}
            if(isset($OT_6DAY[$count]) <> false){$amountOT_6DAY = $OT_6DAY[$count];}else{$amountOT_6DAY = 0;}
            if(isset($OT_7DAY[$count]) <> false){$amountOT_7DAY = $OT_7DAY[$count];}else{$amountOT_7DAY = 0;}
            if(isset($OT_8DAY[$count]) <> false){$amountOT_8DAY = $OT_8DAY[$count];}else{$amountOT_8DAY = 0;}
            if(isset($OT_9DAY[$count]) <> false){$amountOT_9DAY = $OT_9DAY[$count];}else{$amountOT_9DAY = 0;}
            if(isset($OT_10DAY[$count]) <> false){$amountOT_10DAY = $OT_10DAY[$count];}else{$amountOT_10DAY = 0;}
            if(isset($OT_11DAY[$count]) <> false){$amountOT_11DAY = $OT_11DAY[$count];}else{$amountOT_11DAY = 0;}
            if(isset($OT_12DAY[$count]) <> false){$amountOT_12DAY = $OT_12DAY[$count];}else{$amountOT_12DAY = 0;}
            if(isset($OT_13DAY[$count]) <> false){$amountOT_13DAY = $OT_13DAY[$count];}else{$amountOT_13DAY = 0;}
            if(isset($OT_14DAY[$count]) <> false){$amountOT_14DAY = $OT_14DAY[$count];}else{$amountOT_14DAY = 0;}
            if(isset($OT_15DAY[$count]) <> false){$amountOT_15DAY = $OT_15DAY[$count];}else{$amountOT_15DAY = 0;}
            if(isset($OT_16DAY[$count]) <> false){$amountOT_16DAY = $OT_16DAY[$count];}else{$amountOT_16DAY = 0;}
            if(isset($OT_17DAY[$count]) <> false){$amountOT_17DAY = $OT_17DAY[$count];}else{$amountOT_17DAY = 0;}
            if(isset($OT_18DAY[$count]) <> false){$amountOT_18DAY = $OT_18DAY[$count];}else{$amountOT_18DAY = 0;}
            if(isset($OT_19DAY[$count]) <> false){$amountOT_19DAY = $OT_19DAY[$count];}else{$amountOT_19DAY = 0;}
            if(isset($OT_20DAY[$count]) <> false){$amountOT_20DAY = $OT_20DAY[$count];}else{$amountOT_20DAY = 0;}
            if(isset($OT_21DAY[$count]) <> false){$amountOT_21DAY = $OT_21DAY[$count];}else{$amountOT_21DAY = 0;}
            if(isset($OT_22DAY[$count]) <> false){$amountOT_22DAY = $OT_22DAY[$count];}else{$amountOT_22DAY = 0;}
            if(isset($OT_23DAY[$count]) <> false){$amountOT_23DAY = $OT_23DAY[$count];}else{$amountOT_23DAY = 0;}
            if(isset($OT_24DAY[$count]) <> false){$amountOT_24DAY = $OT_24DAY[$count];}else{$amountOT_24DAY = 0;}
            if(isset($OT_25DAY[$count]) <> false){$amountOT_25DAY = $OT_25DAY[$count];}else{$amountOT_25DAY = 0;}
            if(isset($OT_26DAY[$count]) <> false){$amountOT_26DAY = $OT_26DAY[$count];}else{$amountOT_26DAY = 0;}
            if(isset($OT_27DAY[$count]) <> false){$amountOT_27DAY = $OT_27DAY[$count];}else{$amountOT_27DAY = 0;}
            if(isset($OT_28DAY[$count]) <> false){$amountOT_28DAY = $OT_28DAY[$count];}else{$amountOT_28DAY = 0;}
            if(isset($OT_29DAY[$count]) <> false){$amountOT_29DAY = $OT_29DAY[$count];}else{$amountOT_29DAY = 0;}
            if(isset($OT_30DAY[$count]) <> false){$amountOT_30DAY = $OT_30DAY[$count];}else{$amountOT_30DAY = 0;}
            if(isset($OT_31DAY[$count]) <> false){$amountOT_31DAY = $OT_31DAY[$count];}else{$amountOT_31DAY = 0;}
          
            $sumtotal = $amountOT_RATE * ($amountOT_1DAY +  $amountOT_2DAY+ $amountOT_3DAY+ $amountOT_4DAY+ $amountOT_5DAY+ $amountOT_6DAY+ $amountOT_7DAY+ $amountOT_8DAY+ $amountOT_9DAY + $amountOT_10DAY+ $amountOT_11DAY+ $amountOT_12DAY+ $amountOT_13DAY+ $amountOT_14DAY+ $amountOT_15DAY+ $amountOT_16DAY+ $amountOT_17DAY+ $amountOT_18DAY+ $amountOT_19DAY+ $amountOT_20DAY+ $amountOT_21DAY+ $amountOT_22DAY+ $amountOT_23DAY+ $amountOT_24DAY+ $amountOT_25DAY+ $amountOT_26DAY+ $amountOT_27DAY +$amountOT_28DAY+ $amountOT_29DAY+ $amountOT_30DAY+ $amountOT_31DAY);
            
           
            
            $add = new Otindexsub();
            $add->OT_PERSON_ID = $OT_PERSON_ID[$count];
            $add->OT_JOB = $OT_JOB[$count];
            $add->OT_INDEX_ID = $idrefot;
            $add->OT_RATE = $amountOT_RATE;
            $add->OT_1DAY = $amountOT_1DAY;
            $add->OT_2DAY = $amountOT_2DAY;
            $add->OT_3DAY = $amountOT_3DAY;
            $add->OT_4DAY = $amountOT_4DAY;
            $add->OT_5DAY = $amountOT_5DAY;
            $add->OT_6DAY = $amountOT_6DAY;
            $add->OT_7DAY = $amountOT_7DAY;
            $add->OT_8DAY = $amountOT_8DAY;
            $add->OT_9DAY = $amountOT_9DAY;
            $add->OT_10DAY = $amountOT_10DAY;
            $add->OT_11DAY = $amountOT_11DAY;
            $add->OT_12DAY = $amountOT_12DAY;
            $add->OT_13DAY = $amountOT_13DAY;
            $add->OT_14DAY = $amountOT_14DAY;
            $add->OT_15DAY = $amountOT_15DAY;
            $add->OT_16DAY = $amountOT_16DAY;
            $add->OT_17DAY = $amountOT_17DAY;
            $add->OT_18DAY = $amountOT_18DAY;
            $add->OT_19DAY = $amountOT_19DAY;
            $add->OT_20DAY = $amountOT_20DAY;
            $add->OT_21DAY = $amountOT_21DAY;
            $add->OT_22DAY = $amountOT_22DAY;
            $add->OT_23DAY = $amountOT_23DAY;
            $add->OT_24DAY = $amountOT_24DAY;
            $add->OT_25DAY = $amountOT_25DAY;
            $add->OT_26DAY = $amountOT_26DAY;
            $add->OT_27DAY = $amountOT_27DAY;
            $add->OT_28DAY = $amountOT_28DAY;
            $add->OT_29DAY = $amountOT_29DAY;
            $add->OT_30DAY = $amountOT_30DAY;
            $add->OT_31DAY = $amountOT_31DAY;
            $add->OT_SUM   = $sumtotal;
            $add->save(); 

         }

        }

        $infomaountsum = DB::table('ot_index_sub')->where('OT_INDEX_ID','=',$idrefot)->count();
        $infobudgetsum = DB::table('ot_index_sub')->where('OT_INDEX_ID','=',$idrefot)->sum('OT_SUM');
        
        $update = Otindex::find($idrefot);
        $update->OT_AMOUNT_PERSON = $infomaountsum;
        $update->OT_BUGGET_SUM = $infobudgetsum;
        $update->save(); 

        
         return redirect()->route('manager_compensation.otindex');

}


public function export_pdftrack1(Request $request,$idref)
{


    $infoorg = DB::table('info_org')->where('ORG_ID','=',1)
    ->leftJoin('hrd_person','hrd_person.ID','=','info_org.ORG_LEADER_ID')
    ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->first();

    $infomation = DB::table('salary_borrow')->where('BORROW_ID','=',$idref)->first();

    $infomun = DB::table('salary_borrow_sub')->where('BORROW_ID','=',$idref)->sum('BORROW_SUB_PICE');

  

    $infodep = DB::table('salary_borrow')->where('BORROW_ID','=',$idref)
    ->leftJoin('hrd_person','hrd_person.ID','=','salary_borrow.BORROW_HR_PERSON_ID')
    ->first();
    

    $infohead = DB::table('hrd_department_sub_sub')
    ->leftJoin('hrd_person','hrd_person.ID','=','hrd_department_sub_sub.LEADER_HR_ID')
    ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->where('hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=',$infodep->HR_DEPARTMENT_SUB_SUB_ID)
    ->first();


   
    $info_staff = DB::table('salary_staff')
    ->leftJoin('hrd_person','hrd_person.ID','=','salary_staff.STAFF_HR_ID')
    ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->where('salary_staff.STAFF_ID','=','1')
    ->first();
    
    $info_leader= DB::table('salary_staff')
    ->leftJoin('hrd_person','hrd_person.ID','=','salary_staff.STAFF_LEADER_ID')
    ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->where('salary_staff.STAFF_ID','=','1')
    ->first();
    

    $hrddepartment = DB::table('hrd_department')->where('HR_DEPARTMENT_ID','=',1)->first();   
    $pdf = PDF::loadView('manager_compensation.export_pdftrack1',[
        'infoorg' => $infoorg,
        'hrddepartment' => $hrddepartment,
        'infomation' => $infomation,
        'infohead' => $infohead,
        'infomun' => $infomun,
        'info_leader' => $info_leader,
        'info_staff' => $info_staff,
    ]);
    return @$pdf->stream();
}


public function export_pdftrack2(Request $request,$idref)
{
    $infoorg = DB::table('info_org')->where('ORG_ID','=',1)
    ->leftJoin('hrd_person','hrd_person.ID','=','info_org.ORG_LEADER_ID')
    ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->first();

    $infomation = DB::table('salary_borrow')->where('BORROW_ID','=',$idref)->first();

    $infomun = DB::table('salary_borrow_sub')->where('BORROW_ID','=',$idref)->sum('BORROW_SUB_PICE');

  

    $infodep = DB::table('salary_borrow')->where('BORROW_ID','=',$idref)
    ->leftJoin('hrd_person','hrd_person.ID','=','salary_borrow.BORROW_HR_PERSON_ID')
    ->first();
    

    $infohead = DB::table('hrd_department_sub_sub')
    ->leftJoin('hrd_person','hrd_person.ID','=','hrd_department_sub_sub.LEADER_HR_ID')
    ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->where('hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=',$infodep->HR_DEPARTMENT_SUB_SUB_ID)
    ->first();

    

    $hrddepartment = DB::table('hrd_department')->where('HR_DEPARTMENT_ID','=',1)->first();  

    $info_staff = DB::table('salary_staff')
    ->leftJoin('hrd_person','hrd_person.ID','=','salary_staff.STAFF_HR_ID')
    ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->where('salary_staff.STAFF_ID','=','1')
    ->first();
    
    $info_leader= DB::table('salary_staff')
    ->leftJoin('hrd_person','hrd_person.ID','=','salary_staff.STAFF_LEADER_ID')
    ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->where('salary_staff.STAFF_ID','=','1')
    ->first();
    
        
    $pdf = PDF::loadView('manager_compensation.export_pdftrack2',[
        'infoorg' => $infoorg,
        'hrddepartment' => $hrddepartment,
        'infomation' => $infomation,
        'infohead' => $infohead,
        'infomun' => $infomun,
        'info_leader' => $info_leader,
        'info_staff' => $info_staff,
    ]);
    return @$pdf->stream();
}



   //===============================ทะเบียนเช็ค

   public function account_check()
   {
       $infocheck = DB::table('account_check')
       ->orderBy('ACCOUNT_CHECK_ID', 'desc')
       ->get();

       $displaydate_bigen = '';
       $displaydate_end  = '';
       $search = '';

       return view('manager_compensation.account_check',[
           'infochecks' => $infocheck,
           'displaydate_bigen' => $displaydate_bigen,  
           'displaydate_end' => $displaydate_end, 
           'search' => $search, 
       ]);
   }

   public function account_checkpdf(Request $request,$idref)
   {
       
       $infocheck = DB::table('account_check')->where('ACCOUNT_CHECK_ID','=',$idref)->first();
       
       return view('manager_compensation.account_checkpdf',[
           'infocheck' => $infocheck,
          
       ]);
   }

   public function account_check_search(Request $request)
   {

       $search = $request->get('search');
       $datebigin = $request->get('DATE_BIGIN');
       $dateend = $request->get('DATE_END');

       if($search==''){
           $search="";
       }

       $date_bigen_c = Carbon::createFromFormat('d/m/Y', $datebigin)->format('Y-m-d');
       $date_arrary=explode("-",$date_bigen_c);

       $y_sub_st = $date_arrary[0];

       if($y_sub_st >= 2500){
           $y = $y_sub_st-543;
       }else{
           $y = $y_sub_st;
       }

       $m = $date_arrary[1];
       $d = $date_arrary[2];
       $displaydate_bigen= $y."-".$m."-".$d;

       $date_end_c = Carbon::createFromFormat('d/m/Y', $dateend)->format('Y-m-d');
       $date_arrary_e=explode("-",$date_end_c);

       $y_sub_e = $date_arrary_e[0];

       if($y_sub_e >= 2500){
           $y_e = $y_sub_e-543;
       }else{
           $y_e = $y_sub_e;
       }
       $m_e = $date_arrary_e[1];
       $d_e = $date_arrary_e[2];
       $displaydate_end= $y_e."-".$m_e."-".$d_e;
       $date = date('Y-m-d');
                
       $from = date($displaydate_bigen);
       $to = date($displaydate_end);


       $infocheck = DB::table('account_check')
       ->where(function($q) use ($search){
           $q->where('ACCOUNT_CHECK_NUMBER','like','%'.$search.'%');
           $q->orwhere('ACCOUNT_CHECK_CODE','like','%'.$search.'%');
           $q->orwhere('ACCOUNT_CHECK_VENDOR','like','%'.$search.'%');
       })
       ->WhereBetween('ACCOUNT_CHECK_OUT_DATE',[$from,$to]) 
       ->orderBy('ACCOUNT_CHECK_ID', 'desc')
       ->get();


       return view('manager_compensation.account_check',[
           'infochecks' => $infocheck,
           'displaydate_bigen' => $displaydate_bigen,  
           'displaydate_end' => $displaydate_end, 
           'search' => $search, 
       ]);
   }

   public function account_check_add()
   {
       $m_budget = date("m");
       if($m_budget>9){
       $yearbudget = date("Y")+544;
       }else{
       $yearbudget = date("Y")+543;
       }
       
       $budgetyear = DB::table('budget_year')->where('ACTIVE','=','True')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

       $infovendor= DB::table('supplies_vendor')->where('ACTIVE','=','True')->get();
     
       $infoaccount= DB::table('account')->where('ACCOUNT_TYPE','=','05')->get();

       return view('manager_compensation.account_check_add',[
           'yearbudget' => $yearbudget,
           'budgetyears' => $budgetyear,
           'infovendors' => $infovendor,
           'infoaccounts' => $infoaccount
        ]);
   }

   public function account_check_save(Request $request)
   {


       $datebigin = $request->get('ACCOUNT_CHECK_OUT_DATE');
       $dateend = $request->get('ACCOUNT_CHECK_SET_DATE');
   
   
       $date_bigen_c = Carbon::createFromFormat('d/m/Y', $datebigin)->format('Y-m-d');
       $date_arrary=explode("-",$date_bigen_c);
   
       $y_sub_st = $date_arrary[0];
   
       if($y_sub_st >= 2500){
           $y = $y_sub_st-543;
       }else{
           $y = $y_sub_st;
       }
   
       $m = $date_arrary[1];
       $d = $date_arrary[2];
       $displaydate_bigen= $y."-".$m."-".$d;
   
       $date_end_c = Carbon::createFromFormat('d/m/Y', $dateend)->format('Y-m-d');
       $date_arrary_e=explode("-",$date_end_c);
   
       $y_sub_e = $date_arrary_e[0];
   
       if($y_sub_e >= 2500){
           $y_e = $y_sub_e-543;
       }else{
           $y_e = $y_sub_e;
       }
       $m_e = $date_arrary_e[1];
       $d_e = $date_arrary_e[2];
       $displaydate_end= $y_e."-".$m_e."-".$d_e;


       $addinfo = new Accountcheck();
       $addinfo->ACCOUNT_CHECK_YEAR = $request->ACCOUNT_CHECK_YEAR; 
       $addinfo->ACCOUNT_CHECK_NUMBER = $request->ACCOUNT_CHECK_NUMBER;
       $addinfo->ACCOUNT_CHECK_CODE = $request->ACCOUNT_CHECK_CODE;

       $addinfo->ACCOUNT_CHECK_VENDOR_ID = $request->ACCOUNT_CHECK_VENDOR_ID;
       $infonamevendor = DB::table('supplies_vendor')->where('VENDOR_ID','=',$request->ACCOUNT_CHECK_VENDOR_ID)->first();

       $addinfo->ACCOUNT_CHECK_VENDOR = $infonamevendor->VENDOR_NAME;

       $addinfo->ACCOUNT_CHECK_OUT_DATE = $displaydate_bigen;
       $addinfo->ACCOUNT_CHECK_SET_DATE = $displaydate_end;

       $addinfo->ACCOUNT_CHECK_BANK = $request->ACCOUNT_CHECK_BANK;
       $addinfo->ACCOUNT_CHECK_BANK_BRANCH = $request->ACCOUNT_CHECK_BANK_BRANCH;

       $addinfo->ACCOUNT_CHECK_PICE = $request->ACCOUNT_CHECK_PICE;
       $addinfo->ACCOUNT_CHECK_REMARK = $request->ACCOUNT_CHECK_REMARK;

       $addinfo->save();


       $ACCOUNTCHECKID  = Accountcheck::max('ACCOUNT_CHECK_ID');
   
       if($request->ACCOUNT_CHECK_SUB_NUMBER !== '' || $request->ACCOUNT_CHECK_SUB_NUMBER !== null){
           
           $ACCOUNT_CHECK_SUB_NUMBER = $request->ACCOUNT_CHECK_SUB_NUMBER;
           $ACCOUNT_CHECK_SUB_DOC = $request->ACCOUNT_CHECK_SUB_DOC;
           $ACCOUNT_CHECK_SUB_VENDOR = $request->ACCOUNT_CHECK_SUB_VENDOR;
           $ACCOUNT_CHECK_SUB_PICE = $request->ACCOUNT_CHECK_SUB_PICE;
        
   
           $number =count($ACCOUNT_CHECK_SUB_NUMBER);
           $count = 0;
           for($count = 0; $count < $number; $count++)
           {           
              $addaccsub = new Accountchecksub();
              $addaccsub->ACCOUNT_CHECK_ID = $ACCOUNTCHECKID;
              $addaccsub->ACCOUNT_CHECK_SUB_NUMBER = $ACCOUNT_CHECK_SUB_NUMBER[$count];
              $addaccsub->ACCOUNT_CHECK_SUB_DOC = $ACCOUNT_CHECK_SUB_DOC[$count];
              $addaccsub->ACCOUNT_CHECK_SUB_VENDOR = $ACCOUNT_CHECK_SUB_VENDOR[$count];
              $addaccsub->ACCOUNT_CHECK_SUB_PICE = $ACCOUNT_CHECK_SUB_PICE[$count];            
              $addaccsub->save(); 


              DB::table('account')
              ->where('ACCOUNT_NUMBER','=',$ACCOUNT_CHECK_SUB_NUMBER[$count])
              ->update(['ACCOUNT_STATUS' => 'CHECK']);


             //---เพิ่มข้อมูลรายการจ่าย

             $infopay = DB::table('account')->where('ACCOUNT_NUMBER','=',$ACCOUNT_CHECK_SUB_NUMBER[$count])->first();

             
             
             $year = date('Y')+543;

             $maxnumber = DB::table('account')->where('ACCOUNT_YEAR','=',$year)
             ->where('ACCOUNT_TYPE','=','02')
             ->max('ACCOUNT_ID');  
     

           $refmax = DB::table('account')->where('ACCOUNT_ID','=',$maxnumber)->first();  
     
           if($maxnumber != '' ||  $maxnumber != null){
           if($refmax->ACCOUNT_ID != '' ||  $refmax->ACCOUNT_ID != null){
                     $maxref = substr($refmax->ACCOUNT_NUMBER, -5)+1;
           }else{
                     $maxref = 1;
           }
               
           $ref = str_pad($maxref, 5, "0", STR_PAD_LEFT);
            
           }else{
                 $ref = '00001';
           }
             $ye = date('Y')+543;
             $y = substr($ye, -2);
     
     
             $ACCOUNT_NUMBER = 'บจ'.$y.'/2'.$ref;
             
             
             $addinfo = new Account();
             $addinfo->ACCOUNT_TYPE = '02';
             $addinfo->ACCOUNT_YEAR = $infopay->ACCOUNT_YEAR;
             $addinfo->ACCOUNT_VENDOR_ID = $infopay->ACCOUNT_VENDOR_ID;
             $addinfo->ACCOUNT_VENDOR = $infopay->ACCOUNT_VENDOR;
             $addinfo->ACCOUNT_NUMBER = $ACCOUNT_NUMBER;
             $addinfo->ACCOUNT_OUT_DATE =  $infopay->ACCOUNT_OUT_DATE;
             $addinfo->ACCOUNT_DOCTAX_NUM = $infopay->ACCOUNT_DOCTAX_NUM;
             $addinfo->ACCOUNT_DOCTAX_DATE = $infopay->ACCOUNT_DOCTAX_DATE;
             $addinfo->ACCOUNT_DOCREF_NUM = $infopay->ACCOUNT_DOCREF_NUM;
             $addinfo->ACCOUNT_DOCREF_DATE = $infopay->ACCOUNT_DOCREF_DATE;
             $addinfo->ACCOUNT_INVOICE_NUM = $infopay->ACCOUNT_INVOICE_NUM;
             $addinfo->ACCOUNT_TEXPICE = $infopay->ACCOUNT_TEXPICE;
             $addinfo->ACCOUNT_DETAIL = $infopay->ACCOUNT_DETAIL;
             $addinfo->ACCOUNT_STATUS = 'CHECK';
             $addinfo->save();

             $ACCOUNTID  = Account::max('ACCOUNT_ID');
         
           
             $infopaysub = DB::table('account_sub')->where('ACCOUNT_ID','=',$infopay->ACCOUNT_ID)
             ->where('ACCOUNT_SUB_CREDIT','<>',null)
             ->first();
     

               $addaccsub = new Accountsub();
               $addaccsub->ACCOUNT_ID = $ACCOUNTID;
               $addaccsub->ACCOUNT_SUB_NUM = $infopaysub->ACCOUNT_SUB_NUM;
               $addaccsub->ACCOUNT_SUB_DETAIL = $infopaysub->ACCOUNT_SUB_DETAIL;
               $addaccsub->ACCOUNT_SUB_DEBIT = $infopaysub->ACCOUNT_SUB_CREDIT;
               $addaccsub->ACCOUNT_SUB_CREDIT = null; 
               $addaccsub->save(); 


               if($infopay->ACCOUNT_TEXPICE == '2'){
                   $totalnum = (($infopaysub->ACCOUNT_SUB_CREDIT*107)/100)*1/100;
               }else{
                   $totalnum = ($infopaysub->ACCOUNT_SUB_CREDIT*1/100);
               }
               
           
               $addaccsub = new Accountsub();
               $addaccsub->ACCOUNT_ID = $ACCOUNTID;
               $addaccsub->ACCOUNT_SUB_NUM = '2111020199.107';
               $addaccsub->ACCOUNT_SUB_DETAIL = 'ภาษีเงินได้หัก ณ ที่จ่ายรอนำส่ง';
               $addaccsub->ACCOUNT_SUB_DEBIT =  null;
               $addaccsub->ACCOUNT_SUB_CREDIT = $totalnum; 
               $addaccsub->save(); 


               $resule = $infopaysub->ACCOUNT_SUB_CREDIT - $totalnum;

               $addaccsub = new Accountsub();
               $addaccsub->ACCOUNT_ID = $ACCOUNTID;
               $addaccsub->ACCOUNT_SUB_NUM = '1101030102.101.01';
               $addaccsub->ACCOUNT_SUB_DETAIL = 'ออมทรัพย์ 433 1 00704 9(กรุงไทย)';
               $addaccsub->ACCOUNT_SUB_DEBIT = null;
               $addaccsub->ACCOUNT_SUB_CREDIT = $resule; 
               $addaccsub->save(); 
           
           }
       }

       return redirect()->route('mcompensation.account_check'); 
   }

   public function account_check_edit(Request $request,$idref)
   {
       $m_budget = date("m");
       if($m_budget>9){
       $yearbudget = date("Y")+544;
       }else{
       $yearbudget = date("Y")+543;
       }
       
       $budgetyear = DB::table('budget_year')->where('ACTIVE','=','True')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
  
       $infocheck = DB::table('account_check')->where('ACCOUNT_CHECK_ID','=',$idref)->first();

       $infoaccount= DB::table('account')->where('ACCOUNT_TYPE','=','EXPENSES')->get();

       $infovendor= DB::table('supplies_vendor')->where('ACTIVE','=','True')->get();

       return view('manager_compensation.account_check_edit',[
           'yearbudget' => $yearbudget,
           'budgetyears' => $budgetyear,
           'infocheck' => $infocheck,
           'infovendors' => $infovendor,
           'infoaccounts' => $infoaccount
        ]);
   }

public function export_pdfcompensation($idref)
{
    $id =  $idref;
    $infoorg = DB::table('info_org')->where('ORG_ID','=',1)
    ->leftJoin('hrd_person','hrd_person.ID','=','info_org.ORG_LEADER_ID')
    ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->first();

    $date_salary = DB::table('salary_all_head')
    ->where('SALARYALL_HEAD_ID','=',$idref)
    ->first();

    $infoperson = DB::table('salary_all_receive')
    ->leftJoin('salary_all','salary_all.SALARYALL_ID','=', 'salary_all_receive.SALARYALL_ID')
    ->where('salary_all.SALARYALL_HEAD_ID','=',$idref)
    ->select(DB::raw('sum(salary_all_receive.SALARYALL_RECEIVE_AMOUNT) as salary_sub,SALARYALL_RECEIVE_LISTNAME'))
    ->groupBy('SALARYALL_RECEIVE_LISTNAME')
    ->get(); 

   
    $pdf = PDF::loadView('manager_compensation.export_pdfcompensation',[
        'infoorg' => $infoorg,
        'infoperson' => $infoperson,
        'date_salary' => $date_salary,
        'id' => $id,
    ]);
    return @$pdf->stream();
}

public static function sumsalarysub($id){

    $infoperson = DB::table('salary_all_receive')
    ->leftJoin('salary_all','salary_all.SALARYALL_ID','=', 'salary_all_receive.SALARYALL_ID')
    ->where('salary_all.SALARYALL_HEAD_ID','=',$id)
    ->select(DB::raw('sum(salary_all_receive.SALARYALL_RECEIVE_AMOUNT) as salary_total'))
    ->first();

    if($infoperson == null){
        $salary_total = 0;
    }else{
        $salary_total = $infoperson->salary_total;
    }

    return $salary_total;

}
//==========================================//




   public function account_check_update(Request $request)
   {


       $datebigin = $request->get('ACCOUNT_CHECK_OUT_DATE');
       $dateend = $request->get('ACCOUNT_CHECK_SET_DATE');
   
   
       $date_bigen_c = Carbon::createFromFormat('d/m/Y', $datebigin)->format('Y-m-d');
       $date_arrary=explode("-",$date_bigen_c);
   
       $y_sub_st = $date_arrary[0];
   
       if($y_sub_st >= 2500){
           $y = $y_sub_st-543;
       }else{
           $y = $y_sub_st;
       }
   
       $m = $date_arrary[1];
       $d = $date_arrary[2];
       $displaydate_bigen= $y."-".$m."-".$d;
   
       $date_end_c = Carbon::createFromFormat('d/m/Y', $dateend)->format('Y-m-d');
       $date_arrary_e=explode("-",$date_end_c);
   
       $y_sub_e = $date_arrary_e[0];
   
       if($y_sub_e >= 2500){
           $y_e = $y_sub_e-543;
       }else{
           $y_e = $y_sub_e;
       }
       $m_e = $date_arrary_e[1];
       $d_e = $date_arrary_e[2];
       $displaydate_end= $y_e."-".$m_e."-".$d_e;

       $id = $request->ACCOUNT_CHECK_ID; 

       $addinfo = Accountcheck::find($id);
       $addinfo->ACCOUNT_CHECK_YEAR = $request->ACCOUNT_CHECK_YEAR; 
       $addinfo->ACCOUNT_CHECK_NUMBER = $request->ACCOUNT_CHECK_NUMBER;
       $addinfo->ACCOUNT_CHECK_CODE = $request->ACCOUNT_CHECK_CODE;

       $addinfo->ACCOUNT_CHECK_VENDOR_ID = $request->ACCOUNT_CHECK_VENDOR_ID;
       $infonamevendor = DB::table('supplies_vendor')->where('VENDOR_ID','=',$request->ACCOUNT_CHECK_VENDOR_ID)->first();

       $addinfo->ACCOUNT_CHECK_VENDOR = $infonamevendor->VENDOR_NAME;

       $addinfo->ACCOUNT_CHECK_OUT_DATE = $displaydate_bigen;
       $addinfo->ACCOUNT_CHECK_SET_DATE = $displaydate_end;

       $addinfo->ACCOUNT_CHECK_PICE = $request->ACCOUNT_CHECK_PICE;
       $addinfo->ACCOUNT_CHECK_REMARK = $request->ACCOUNT_CHECK_REMARK;

       $addinfo->save();


  
       
       Accountchecksub::where('ACCOUNT_CHECK_ID','=',$id)->delete();
       $ACCOUNTCHECKID  = $id;
   
       if($request->ACCOUNT_CHECK_SUB_NUMBER != '' || $request->ACCOUNT_CHECK_SUB_NUMBER != null){
           
           $ACCOUNT_CHECK_SUB_NUMBER = $request->ACCOUNT_CHECK_SUB_NUMBER;
           $ACCOUNT_CHECK_SUB_DOC = $request->ACCOUNT_CHECK_SUB_DOC;
           $ACCOUNT_CHECK_SUB_VENDOR = $request->ACCOUNT_CHECK_SUB_VENDOR;
           $ACCOUNT_CHECK_SUB_PICE = $request->ACCOUNT_CHECK_SUB_PICE;
        
   
           $number =count($ACCOUNT_CHECK_SUB_NUMBER);
           $count = 0;
           for($count = 0; $count < $number; $count++)
           {  
         
              $addaccsub = new Accountchecksub();
              $addaccsub->ACCOUNT_CHECK_ID = $ACCOUNTCHECKID;
              $addaccsub->ACCOUNT_CHECK_SUB_NUMBER = $ACCOUNT_CHECK_SUB_NUMBER[$count];
              $addaccsub->ACCOUNT_CHECK_SUB_DOC = $ACCOUNT_CHECK_SUB_DOC[$count];
              $addaccsub->ACCOUNT_CHECK_SUB_VENDOR = $ACCOUNT_CHECK_SUB_VENDOR[$count];
              $addaccsub->ACCOUNT_CHECK_SUB_PICE = $ACCOUNT_CHECK_SUB_PICE[$count];
             
              $addaccsub->save(); 

              DB::table('account')
              ->where('ACCOUNT_NUMBER','=',$ACCOUNT_CHECK_SUB_NUMBER[$count])
              ->update(['ACCOUNT_STATUS' => 'CHECK']);
              
           }
       }



       return redirect()->route('mcompensation.account_check'); 
   }

   function account_check_list(Request $request)
   {
      
        $VENDORID = $request->get('select');
    

        $query= DB::table('account')
        ->where('ACCOUNT_TYPE','=','05')
        ->where('ACCOUNT_VENDOR_ID','=',$VENDORID)
        ->get();

        $querysub= DB::table('account')
        ->where('ACCOUNT_TYPE','=','05')
        ->get();

        $count=0;
        $output='';
        foreach ($query as $row){

           $sumpice = DB::table('account_sub')
           ->where('ACCOUNT_ID','=',$row->ACCOUNT_ID)
           ->sum('ACCOUNT_SUB_CREDIT');
    
          $count++; 
           
           $output.= ' <tr height="20">
                       
           <td style="text-align: center;">
           '.$count.'
           </td>
           <td>               
               <select name="ACCOUNT_CHECK_SUB_NUMBER[]" id="ACCOUNT_CHECK_SUB_NUMBER0" class="form-control input-lg" style=" font-family: \'Kanit\', sans-serif;" >
                           <option value="">--กรุณาเลือก--</option>';
                           foreach ($querysub as $rowsub){
                              if($rowsub ->ACCOUNT_NUMBER == $row->ACCOUNT_NUMBER){
                               $output.= '<option value="'.$rowsub ->ACCOUNT_NUMBER.'" selected>'.$rowsub->ACCOUNT_NUMBER.'</option>';
                              }else{
                               $output.= '<option value="'.$rowsub ->ACCOUNT_NUMBER.'">'.$rowsub->ACCOUNT_NUMBER.'</option>';
                              }                             
                           
                           }
           $output.= '</select>  
           </td>
           <td style="text-align: center;">';
           if($row->ACCOUNT_STATUS == 'RECIVE'){
               $output.= '<span class="badge badge-success">รับเช็ค</span>';
           }elseif($row->ACCOUNT_STATUS == 'CHECK'){
               $output.= '<span class="badge badge-info">ออกเช็ค</span>';
           }elseif($row->ACCOUNT_STATUS == 'BILL'){
           $output.= '<span class="badge badge-warning">วางบิล</span>';
           }else{
               $output.= '<span class="badge badge-danger">บันทึก</span>';
                       }
           $output.= '</td>
           <td>
           '.$row->ACCOUNT_INVOICE_NUM.'
               <input type="hidden" name="ACCOUNT_CHECK_SUB_DOC[]" id="ACCOUNT_CHECK_SUB_DOC0" class="form-control input-sm" style=" font-family: \'Kanit\', sans-serif;"   value="'.$row->ACCOUNT_INVOICE_NUM.'">
           </td>
           <td>
           '.$row->ACCOUNT_VENDOR.'
               <input type="hidden" name="ACCOUNT_CHECK_SUB_VENDOR[]" id="ACCOUNT_CHECK_SUB_VENDOR0" class="form-control input-sm" style=" font-family: \'Kanit\', sans-serif;" value="'.$row->ACCOUNT_VENDOR.'" >
           </td>
           <td>
             
               <input name="ACCOUNT_CHECK_SUB_PICE[]" id="ACCOUNT_CHECK_SUB_PICE0" class="form-control input-sm" style=" font-family: \'Kanit\', sans-serif;"  value="'.$sumpice.'.00">
           </td>
               <td style="text-align: center;"><a class="btn btn-danger fa fa-trash-alt remove" style="color:#FFFFFF;"></a></td>
       
       </tr>';
   }

   echo $output;
       
   }
 
   //=================================================================


   public function account_bill()
   {
       $infobill = DB::table('account_bill')
       ->orderBy('ACCOUNT_BILL_ID', 'desc') 
       ->get();
   
       $displaydate_bigen = '';
       $displaydate_end = '';
       $search = '';
   
       return view('manager_compensation.account_bill',[
           'infobills' => $infobill,
           'displaydate_bigen' => $displaydate_bigen,  
           'displaydate_end' => $displaydate_end, 
           'search' => $search, 
       ]);
   }


   public function account_bill_search(Request $request)
   {
     $search = $request->get('search');
     $datebigin = $request->get('DATE_BIGIN');
     $dateend = $request->get('DATE_END');

     if($search==''){
         $search="";
     }

     $date_bigen_c = Carbon::createFromFormat('d/m/Y', $datebigin)->format('Y-m-d');
     $date_arrary=explode("-",$date_bigen_c);

     $y_sub_st = $date_arrary[0];

     if($y_sub_st >= 2500){
         $y = $y_sub_st-543;
     }else{
         $y = $y_sub_st;
     }

     $m = $date_arrary[1];
     $d = $date_arrary[2];
     $displaydate_bigen= $y."-".$m."-".$d;

     $date_end_c = Carbon::createFromFormat('d/m/Y', $dateend)->format('Y-m-d');
     $date_arrary_e=explode("-",$date_end_c);

     $y_sub_e = $date_arrary_e[0];

     if($y_sub_e >= 2500){
         $y_e = $y_sub_e-543;
     }else{
         $y_e = $y_sub_e;
     }
     $m_e = $date_arrary_e[1];
     $d_e = $date_arrary_e[2];
     $displaydate_end= $y_e."-".$m_e."-".$d_e;
     $date = date('Y-m-d');
              
     $from = date($displaydate_bigen);
     $to = date($displaydate_end);

    
     $infobill = DB::table('account_bill')
     ->where(function($q) use ($search){
         $q->where('ACCOUNT_BILL_NUMBER','like','%'.$search.'%');
         $q->orwhere('ACCOUNT_BILL_VENDOR','like','%'.$search.'%');
     })
     ->WhereBetween('ACCOUNT_BILL_OUT_DATE',[$from,$to]) 
     ->orderBy('ACCOUNT_BILL_ID', 'desc')   
     ->get();

       return view('manager_compensation.account_bill',[
           'infobills' => $infobill,
           'displaydate_bigen' => $displaydate_bigen,  
           'displaydate_end' => $displaydate_end, 
           'search' => $search, 
       ]);
   }

   public function account_bill_add()
   {
       $m_budget = date("m");
       if($m_budget>9){
       $yearbudget = date("Y")+544;
       }else{
       $yearbudget = date("Y")+543;
       }
       
       $budgetyear = DB::table('budget_year')->where('ACTIVE','=','True')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

       $infovendor= DB::table('supplies_vendor')->where('ACTIVE','=','True')->get();
     
       $infoaccount= DB::table('account')->where('ACCOUNT_TYPE','=','05')->get();

       return view('manager_compensation.account_bill_add',[
           'yearbudget' => $yearbudget,
           'budgetyears' => $budgetyear,
           'infovendors' => $infovendor,
           'infoaccounts' => $infoaccount
        ]);
   }

   public function account_bill_save(Request $request)
   {


       $datebigin = $request->get('ACCOUNT_BILL_OUT_DATE');
       $dateend = $request->get('ACCOUNT_BILL_SET_DATE');
   
   
       $date_bigen_c = Carbon::createFromFormat('d/m/Y', $datebigin)->format('Y-m-d');
       $date_arrary=explode("-",$date_bigen_c);
   
       $y_sub_st = $date_arrary[0];
   
       if($y_sub_st >= 2500){
           $y = $y_sub_st-543;
       }else{
           $y = $y_sub_st;
       }
   
       $m = $date_arrary[1];
       $d = $date_arrary[2];
       $displaydate_bigen= $y."-".$m."-".$d;
   
       $date_end_c = Carbon::createFromFormat('d/m/Y', $dateend)->format('Y-m-d');
       $date_arrary_e=explode("-",$date_end_c);
   
       $y_sub_e = $date_arrary_e[0];
   
       if($y_sub_e >= 2500){
           $y_e = $y_sub_e-543;
       }else{
           $y_e = $y_sub_e;
       }
       $m_e = $date_arrary_e[1];
       $d_e = $date_arrary_e[2];
       $displaydate_end= $y_e."-".$m_e."-".$d_e;


       $addinfo = new Accountbill();
       $addinfo->ACCOUNT_BILL_YEAR = $request->ACCOUNT_BILL_YEAR; 
       $addinfo->ACCOUNT_BILL_NUMBER = $request->ACCOUNT_BILL_NUMBER;
      

       $addinfo->ACCOUNT_BILL_VENDOR_ID = $request->ACCOUNT_BILL_VENDOR_ID;
       $infonamevendor = DB::table('supplies_vendor')->where('VENDOR_ID','=',$request->ACCOUNT_BILL_VENDOR_ID)->first();

       $addinfo->ACCOUNT_BILL_VENDOR = $infonamevendor->VENDOR_NAME;

       $addinfo->ACCOUNT_BILL_OUT_DATE = $displaydate_bigen;
       $addinfo->ACCOUNT_BILL_SET_DATE = $displaydate_end;

       $addinfo->ACCOUNT_BILL_PICE = $request->ACCOUNT_BILL_PICE;
       $addinfo->ACCOUNT_BILL_REMARK = $request->ACCOUNT_BILL_REMARK;

       $addinfo->save();


       $ACCOUNTBILLID  = Accountbill::max('ACCOUNT_BILL_ID');
       $te = $request->ACCOUNT_BILL_SUB_NUMBER;
     
       if($request->ACCOUNT_BILL_SUB_NUMBER != '' || $request->ACCOUNT_BILL_SUB_NUMBER != null){
         
         $ACCOUNT_BILL_SUB_NUMBER = $request->ACCOUNT_BILL_SUB_NUMBER;
         $ACCOUNT_BILL_SUB_DOC = $request->ACCOUNT_BILL_SUB_DOC;
         $ACCOUNT_BILL_SUB_VENDOR = $request->ACCOUNT_BILL_SUB_VENDOR;
         $ACCOUNT_BILL_SUB_PICE = $request->ACCOUNT_BILL_SUB_PICE;
      
 
         $number =count($ACCOUNT_BILL_SUB_NUMBER);
         $count = 0;
         for($count = 0; $count < $number; $count++)
         {  
       
            $addaccsub = new Accountbillsub();
            $addaccsub->ACCOUNT_BILL_ID = $ACCOUNTBILLID;
            $addaccsub->ACCOUNT_BILL_SUB_NUMBER = $ACCOUNT_BILL_SUB_NUMBER[$count];
            $addaccsub->ACCOUNT_BILL_SUB_DOC = $ACCOUNT_BILL_SUB_DOC[$count];
            $addaccsub->ACCOUNT_BILL_SUB_VENDOR = $ACCOUNT_BILL_SUB_VENDOR[$count];
            $addaccsub->ACCOUNT_BILL_SUB_PICE = $ACCOUNT_BILL_SUB_PICE[$count];          
            $addaccsub->save(); 
                 
            DB::table('account')
            ->where('ACCOUNT_NUMBER','=',$ACCOUNT_BILL_SUB_NUMBER[$count])
            ->update(['ACCOUNT_STATUS' => 'BILL']);

         }
     }

       return redirect()->route('mcompensation.account_bill'); 
   }


 public function account_bill_edit(Request $request,$idref)
 {
     $m_budget = date("m");
     if($m_budget>9){
     $yearbudget = date("Y")+544;
     }else{
     $yearbudget = date("Y")+543;
     }
     
     $budgetyear = DB::table('budget_year')->where('ACTIVE','=','True')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

     $infobill = DB::table('account_bill')->where('ACCOUNT_BILL_ID','=',$idref)->first();

     $infoaccount= DB::table('account')->where('ACCOUNT_TYPE','=','05')->get();

     $infovendor= DB::table('supplies_vendor')->where('ACTIVE','=','True')->get();

     return view('manager_compensation.account_bill_edit',[
         'yearbudget' => $yearbudget,
         'budgetyears' => $budgetyear,
         'infobill' => $infobill,
         'infovendors' => $infovendor,
         'infoaccounts' => $infoaccount
      ]);
 }

 public function account_bill_update(Request $request)
 {


     $datebigin = $request->get('ACCOUNT_BILL_OUT_DATE');
     $dateend = $request->get('ACCOUNT_BILL_SET_DATE');
 
 
     $date_bigen_c = Carbon::createFromFormat('d/m/Y', $datebigin)->format('Y-m-d');
     $date_arrary=explode("-",$date_bigen_c);
 
     $y_sub_st = $date_arrary[0];
 
     if($y_sub_st >= 2500){
         $y = $y_sub_st-543;
     }else{
         $y = $y_sub_st;
     }
 
     $m = $date_arrary[1];
     $d = $date_arrary[2];
     $displaydate_bigen= $y."-".$m."-".$d;
 
     $date_end_c = Carbon::createFromFormat('d/m/Y', $dateend)->format('Y-m-d');
     $date_arrary_e=explode("-",$date_end_c);
 
     $y_sub_e = $date_arrary_e[0];
 
     if($y_sub_e >= 2500){
         $y_e = $y_sub_e-543;
     }else{
         $y_e = $y_sub_e;
     }
     $m_e = $date_arrary_e[1];
     $d_e = $date_arrary_e[2];
     $displaydate_end= $y_e."-".$m_e."-".$d_e;

     $id = $request->ACCOUNT_BILL_ID; 

     $addinfo = Accountbill::find($id);
     $addinfo->ACCOUNT_BILL_YEAR = $request->ACCOUNT_BILL_YEAR; 
     $addinfo->ACCOUNT_BILL_NUMBER = $request->ACCOUNT_BILL_NUMBER;
   

     $addinfo->ACCOUNT_BILL_VENDOR_ID = $request->ACCOUNT_BILL_VENDOR_ID;
     $infonamevendor = DB::table('supplies_vendor')->where('VENDOR_ID','=',$request->ACCOUNT_BILL_VENDOR_ID)->first();

     $addinfo->ACCOUNT_BILL_VENDOR = $infonamevendor->VENDOR_NAME;

     $addinfo->ACCOUNT_BILL_OUT_DATE = $displaydate_bigen;
     $addinfo->ACCOUNT_BILL_SET_DATE = $displaydate_end;

     $addinfo->ACCOUNT_BILL_PICE = $request->ACCOUNT_BILL_PICE;
     $addinfo->ACCOUNT_BILL_REMARK = $request->ACCOUNT_BILL_REMARK;

     $addinfo->save();



     
     Accountbillsub::where('ACCOUNT_BILL_ID','=',$id)->delete();
     $ACCOUNTBILLID  = $id;
 
     if($request->ACCOUNT_BILL_SUB_NUMBER != '' || $request->ACCOUNT_BILL_SUB_NUMBER != null){
         
         $ACCOUNT_BILL_SUB_NUMBER = $request->ACCOUNT_BILL_SUB_NUMBER;
         $ACCOUNT_BILL_SUB_DOC = $request->ACCOUNT_BILL_SUB_DOC;
         $ACCOUNT_BILL_SUB_VENDOR = $request->ACCOUNT_BILL_SUB_VENDOR;
         $ACCOUNT_BILL_SUB_PICE = $request->ACCOUNT_BILL_SUB_PICE;
      
 
         $number =count($ACCOUNT_BILL_SUB_NUMBER);
         $count = 0;
         for($count = 0; $count < $number; $count++)
         {  
       
            $addaccsub = new Accountbillsub();
            $addaccsub->ACCOUNT_BILL_ID = $ACCOUNTBILLID;
            $addaccsub->ACCOUNT_BILL_SUB_NUMBER = $ACCOUNT_BILL_SUB_NUMBER[$count];
            $addaccsub->ACCOUNT_BILL_SUB_DOC = $ACCOUNT_BILL_SUB_DOC[$count];
            $addaccsub->ACCOUNT_BILL_SUB_VENDOR = $ACCOUNT_BILL_SUB_VENDOR[$count];
            $addaccsub->ACCOUNT_BILL_SUB_PICE = $ACCOUNT_BILL_SUB_PICE[$count];
           
            $addaccsub->save(); 
            
       
            DB::table('account')
            ->where('ACCOUNT_NUMBER','=',$ACCOUNT_BILL_SUB_NUMBER[$count])
            ->update(['ACCOUNT_STATUS' => 'BILL']);


        
         }
     }



     return redirect()->route('mcompensation.account_bill'); 
 }
 
   
 public function account_check_reseve(Request $request,$idref)
 {

     $query = DB::table('account_check_sub')
     ->where('ACCOUNT_CHECK_ID','=',$idref)
     ->get();

     foreach ($query as $row){

         DB::table('account')
         ->where('ACCOUNT_NUMBER','=',$row->ACCOUNT_CHECK_SUB_NUMBER)
         ->update(['ACCOUNT_STATUS' => 'RECIVE']);

     }

 
     return redirect()->route('mcompensation.account_check'); 
 }

 function inforeceipt(Request $request)
 {  
     $id = $request->inforeceipt;
   
     $departmentsubsubactive = Salaryreceive::find($id);
     $departmentsubsubactive->ACTIVE = $request->onoff;
     $departmentsubsubactive->save();
 }


 function infopay(Request $request)
 {  

     $id = $request->infopay;
     $departmentsubsubactive = Salarypay::find($id);
     $departmentsubsubactive->ACTIVE = $request->onoff;
     $departmentsubsubactive->save();
 }

 //------------------------------------------------------------


 public function Updatestatuscompen(Request $request)
    {
     
        $id =   $request->idref;
        $update = Salarycertificate::find($id);
        $update->CER_STATUS = 'DOCSUCCESS';
        $update->save();


    }

}
