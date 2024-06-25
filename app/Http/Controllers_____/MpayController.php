<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\DB;
use App\Models\Person;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Mpaywithdrow;
use App\Models\Mpaywithdrowsub;

use App\Models\Mpaypay;
use App\Models\Mpaypaysub;



class MpayController extends Controller
{


    public function dashboard_mpay(Request $request,$iduser)
    {
        $email = Auth::user()->email;
        $inforpersonuserid =  Person::where('ID','=',$iduser)->first();

        $inforperson=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
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

  
        return view('general_mpay.dashboard_mpay',[
            'inforperson' => $inforperson,
            'inforpersonuserid' => $inforpersonuserid,
            
        ]);

    }


    public function stockcard_mpay(Request $request,$iduser)
    {
        $email = Auth::user()->email;
        $inforpersonuserid =  Person::where('ID','=',$iduser)->first();
            
        $inforpersonuser  =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
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

     

        return view('general_mpay.stockcard_mpay',[
            'inforpersonuser' => $inforpersonuser ,
            'inforpersonuserid' => $inforpersonuserid,
            
        ]);
    }


    public function withdraw_mpay(Request $request,$iduser)
    {
        $email = Auth::user()->email;
        $inforpersonuserid =  Person::where('ID','=',$iduser)->first();
            
        $inforpersonuser  =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
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

        $mpaywithdrow = DB::table('mpay_withdrow')
                        ->leftJoin('hrd_department_sub_sub','mpay_withdrow.MPAY_WITHDROW_DEP_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
                        ->leftJoin('hrd_person','mpay_withdrow.MPAY_WITHDROW_HR_ID','=','hrd_person.ID')
                        ->orderBy('MPAY_WITHDROW_ID', 'desc')
                        ->get();


                             
        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;
        }     
        
        
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';
        $status = '';
        $search = '';
        $year_id = $yearbudget;

        return view('general_mpay.withdraw_mpay',[
            'inforpersonuser' => $inforpersonuser ,
            'inforpersonuserid' => $inforpersonuserid,
            'mpaywithdrows' => $mpaywithdrow,
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id,
            
        ]);
    }


    public function withdraw_mpay_search(Request $request,$iduser)
    {
        $email = Auth::user()->email;
        $inforpersonuserid =  Person::where('ID','=',$iduser)->first();
            
        $inforpersonuser  =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
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

        $search = $request->get('search');
        $status = $request->STATUS_CODE;
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

      
            $from = date($displaydate_bigen);
            $to = date($displaydate_end);
      
       
    if($status == null){

        $mpaywithdrow = DB::table('mpay_withdrow') 
        ->leftJoin('hrd_department_sub_sub','mpay_withdrow.MPAY_WITHDROW_DEP_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->leftJoin('hrd_person','mpay_withdrow.MPAY_WITHDROW_HR_ID','=','hrd_person.ID')
        ->where(function($q) use ($search){
            $q->where('MPAY_WITHDROW_CODE','like','%'.$search.'%');
            $q->orwhere('MPAY_WITHDROW_COMMENT','like','%'.$search.'%');
            $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');
            $q->orwhere('HR_FNAME','like','%'.$search.'%');
            $q->orwhere('HR_LNAME','like','%'.$search.'%');
        })
        ->WhereBetween('MPAY_WITHDROW_DATE',[$from,$to]) 
        ->orderBy('MPAY_WITHDROW_ID', 'desc')
        ->get();

    }else{
      
        $mpaywithdrow = DB::table('mpay_withdrow') 
        ->leftJoin('hrd_department_sub_sub','mpay_withdrow.MPAY_WITHDROW_DEP_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->leftJoin('hrd_person','mpay_withdrow.MPAY_WITHDROW_HR_ID','=','hrd_person.ID')
        ->where(function($q) use ($search){
            $q->where('MPAY_WITHDROW_CODE','like','%'.$search.'%');
            $q->orwhere('MPAY_WITHDROW_COMMENT','like','%'.$search.'%');
            $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');
            $q->orwhere('HR_FNAME','like','%'.$search.'%');
            $q->orwhere('HR_LNAME','like','%'.$search.'%');
        })
        ->where('MPAY_WITHDROW_STATUS','=',$status)
        ->WhereBetween('MPAY_WITHDROW_DATE',[$from,$to])
        ->orderBy('MPAY_WITHDROW_ID', 'desc') 
        ->get();

    }    

    
    $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
    $year_id = $yearbudget;

        return view('general_mpay.withdraw_mpay',[
            'inforpersonuser' => $inforpersonuser ,
            'inforpersonuserid' => $inforpersonuserid,
            'mpaywithdrows' => $mpaywithdrow,
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id,
            
        ]);
    }



    public function withdrowmpay_add(Request $request,$iduser)
    {
        $inforpersonuserid =  Person::where('ID','=',$iduser)->first();

        $inforpersonuser=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
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


       $pessonall = Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')->orderBy('hrd_person.HR_FNAME', 'asc')->get();
    
        $departmentsubsub = DB::table('hrd_department_sub_sub')->where('ACTIVE','=','True')->get();
    
        $orgname = DB::table('info_org')->first();
    
    
        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;
        }
    
    
        $budget = DB::table('budget_year')->where('ACTIVE','=','True')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
    
        $mpay_setupasset = DB::table('mpay_setupasset_pieces')->get();
        
    
        return view('general_mpay.withdrowmpay_add ',[
            'budgets' => $budget,
            'inforpersonuser' => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid,
             'pessonalls' => $pessonall,
            'departmentsubsubs' => $departmentsubsub,
            'orgname' => $orgname->ORG_NAME,
            'year_id' => $yearbudget,
            'mpay_setupassets' => $mpay_setupasset,  
        ]);    
    }



    public function withdrowmpay_save(Request $request)
   {
      
       $datebigin = $request->MPAY_WITHDROW_DATE;
    
       
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
       $MPAYWITHDROW_DATE= $y."-".$m."-".$d;


       $add = new Mpaywithdrow();
       $add->MPAY_WITHDROW_CODE = $request->MPAY_WITHDROW_CODE;
       $add->MPAY_WITHDROW_YEAR = $request->MPAY_WITHDROW_YEAR;
       $add->MPAY_WITHDROW_COMMENT = $request->MPAY_WITHDROW_COMMENT;
       $add->MPAY_WITHDROW_DATE = $MPAYWITHDROW_DATE;
       $add->MPAY_WITHDROW_DEP_SUB_SUB_ID = $request->MPAY_WITHDROW_DEP_SUB_SUB_ID;
       $add->MPAY_WITHDROW_HR_ID = $request->MPAY_WITHDROW_HR_ID;
       $add->MPAY_WITHDROW_TIME = $request->MPAY_WITHDROW_TIME;
       $add->MPAY_WITHDROW_STATUS = 'Request';
       $add->save();

       $MPAYWITHDROWID = Mpaywithdrow::max('MPAY_WITHDROW_ID');  //==== นับ ID ต่อจากตัวที่มากที่สุด =====//

                    if($request->MPAY_WITHDROW_SUB_TYPE != '' || $request->MPAY_WITHDROW_SUB_TYPE != null){

                    $MPAY_WITHDROW_SUB_TYPE = $request->MPAY_WITHDROW_SUB_TYPE;
                    $MPAY_WITHDROW_SUB_AMOUNT = $request->MPAY_WITHDROW_SUB_AMOUNT;
                    $number =count($MPAY_WITHDROW_SUB_TYPE);
                    $count = 0;
                    for($count = 0; $count < $number; $count++)
                    {  
                        $add_sub = new Mpaywithdrowsub();
                        $add_sub->MPAY_WITHDROW_ID = $MPAYWITHDROWID;
                        $add_sub->MPAY_WITHDROW_SUB_TYPE = $MPAY_WITHDROW_SUB_TYPE[$count];
                        $add_sub->MPAY_WITHDROW_SUB_AMOUNT = $MPAY_WITHDROW_SUB_AMOUNT[$count];
                        $add_sub->save();

                    }

                    }

       return redirect()->route('gen_mpay.withdraw_mpay',[
                    'iduser' =>  $request->MPAY_WITHDROW_HR_ID
       ]);
   }


   
   public static function refnumberrev()
   {
       
       $year = date('Y')+543;


       $maxnumber = DB::table('mpay_withdrow')->where('MPAY_WITHDROW_YEAR','=',$year)
       ->max('MPAY_WITHDROW_ID');  

    

       if($maxnumber != '' ||  $maxnumber != null){
           
           $refmax = DB::table('mpay_withdrow')->where('MPAY_WITHDROW_ID','=',$maxnumber)->first();  


           if($refmax->MPAY_WITHDROW_ID != '' ||  $refmax->MPAY_WITHDROW_ID != null){
               $maxref = substr($refmax->MPAY_WITHDROW_CODE, -5)+1;
            }else{
               $maxref = 1;
            }

           $ref = str_pad($maxref, 5, "0", STR_PAD_LEFT);
      
       }else{
           $ref = '00001';
       }

       $ye = date('Y')+543;
       $y = substr($ye, -2);


    $refnumber = 'W'.$y.'/'.$ref;



    return $refnumber;
   }


   public function withdrowmpay_edit(Request $request,$id,$iduser)
   {
       $inforpersonuserid =  Person::where('ID','=',$iduser)->first();

       $inforpersonuser=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
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


       $pessonall = Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')->orderBy('hrd_person.HR_FNAME', 'asc')->get();
       $departmentsubsub = DB::table('hrd_department_sub_sub')->where('ACTIVE','=','True')->get();
       $orgname = DB::table('info_org')->first();
   
   
       $m_budget = date("m");
       if($m_budget>9){
       $yearbudget = date("Y")+544;
       }else{
       $yearbudget = date("Y")+543;
       }
   
   
       $budget = DB::table('budget_year')->where('ACTIVE','=','True')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
   
       $mpay_setupasset = DB::table('mpay_setupasset_pieces')->get();
       
       $mpaywithdrow = DB::table('mpay_withdrow')
       ->leftJoin('hrd_department_sub_sub','mpay_withdrow.MPAY_WITHDROW_DEP_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
       ->leftJoin('hrd_person','mpay_withdrow.MPAY_WITHDROW_HR_ID','=','hrd_person.ID')
       ->where('MPAY_WITHDROW_ID','=',$id)
       ->first();

       $mpaywithdrow_sub = DB::table('mpay_withdrow_sub')->where('MPAY_WITHDROW_ID','=',$id)->get();
   
       return view('general_mpay.withdrowmpay_edit ',[
           'budgets' => $budget,
           'inforpersonuser' => $inforpersonuser,
           'inforpersonuserid' => $inforpersonuserid,
           'pessonalls' => $pessonall,
           'departmentsubsubs' => $departmentsubsub,
           'orgname' => $orgname->ORG_NAME,
           'year_id' => $yearbudget,
           'mpay_setupassets' => $mpay_setupasset,  
           'mpaywithdrows' => $mpaywithdrow, 
           'mpaywithdrow_subs' => $mpaywithdrow_sub, 
       ]);    
   }

   public function withdrowmpay_update(Request $request)
   {
      
       $datebigin = $request->MPAY_WITHDROW_DATE;    
       
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
       $MPAYWITHDROW_DATE= $y."-".$m."-".$d;

       $id = $request->MPAY_WITHDROW_ID;

       $update = Mpaywithdrow::find($id);
       $update->MPAY_WITHDROW_CODE = $request->MPAY_WITHDROW_CODE;
       $update->MPAY_WITHDROW_YEAR = $request->MPAY_WITHDROW_YEAR;
       $update->MPAY_WITHDROW_COMMENT = $request->MPAY_WITHDROW_COMMENT;
       $update->MPAY_WITHDROW_DATE = $MPAYWITHDROW_DATE;
       $update->MPAY_WITHDROW_DEP_SUB_SUB_ID = $request->MPAY_WITHDROW_DEP_SUB_SUB_ID;
       $update->MPAY_WITHDROW_HR_ID = $request->MPAY_WITHDROW_HR_ID;
       $update->MPAY_WITHDROW_TIME = $request->MPAY_WITHDROW_TIME;
       $update->save();

    //    $MPAYWITHDROWID = Mpaywithdrow::max('MPAY_WITHDROW_ID');  //==== นับ ID ต่อจากตัวที่มากที่สุด =====//

    Mpaywithdrowsub::where('MPAY_WITHDROW_ID','=',$id)->delete();

                    if($request->MPAY_WITHDROW_SUB_TYPE != '' || $request->MPAY_WITHDROW_SUB_TYPE != null){

                    $MPAY_WITHDROW_SUB_TYPE = $request->MPAY_WITHDROW_SUB_TYPE;
                    $MPAY_WITHDROW_SUB_AMOUNT = $request->MPAY_WITHDROW_SUB_AMOUNT;
                    $number =count($MPAY_WITHDROW_SUB_TYPE);
                    $count = 0;
                    for($count = 0; $count < $number; $count++)
                    {  
                        $update_sub = new Mpaywithdrowsub();
                        $update_sub->MPAY_WITHDROW_ID = $id;
                        $update_sub->MPAY_WITHDROW_SUB_TYPE = $MPAY_WITHDROW_SUB_TYPE[$count];
                        $update_sub->MPAY_WITHDROW_SUB_AMOUNT = $MPAY_WITHDROW_SUB_AMOUNT[$count];
                        $update_sub->save();

                    }

                    }

       return redirect()->route('gen_mpay.withdraw_mpay',[
                    'iduser' =>  $request->MPAY_WITHDROW_HR_ID
       ]);
   }
   public function withdrowmpay_destroy(Request $request,$id,$iduser)
   {
        Mpaywithdrow::destroy($id);
        Mpaywithdrowsub::where('MPAY_WITHDROW_ID',$id)->delete();

       return redirect()->route('gen_mpay.withdraw_mpay',['iduser' => $iduser]);
   }





//===============================================================================//
    public function pay_mpay(Request $request,$iduser)
    {
        $email = Auth::user()->email;
        $inforpersonuserid =  Person::where('ID','=',$iduser)->first();
            
        $inforpersonuser  =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
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


        $mpaypay = DB::table('mpay_pay')
                    ->leftJoin('hrd_person','mpay_pay.MPAY_PAY_SAVE_HR_ID','=','hrd_person.ID')
                    ->get();

                    $m_budget = date("m");
                    if($m_budget>9){
                    $yearbudget = date("Y")+544;
                    }else{
                    $yearbudget = date("Y")+543;
                    }     
                    
                    
                    $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
                    $displaydate_bigen = ($yearbudget-544).'-10-01';
                    $displaydate_end = ($yearbudget-543).'-09-30';
                    $search = '';
                    $year_id = $yearbudget;


        return view('general_mpay.pay_mpay',[
            'inforpersonuser' => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid,
            'mpaypays' => $mpaypay,
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'search'=> $search,
            'year_id'=>$year_id,
            
            
        ]);
    }

    public function pay_mpay_search(Request $request,$iduser)
    {
        $email = Auth::user()->email;
        $inforpersonuserid =  Person::where('ID','=',$iduser)->first();
            
        $inforpersonuser  =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
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

                    
        $search = $request->get('search');
        $status = $request->STATUS_CODE;
        $datebigin = $request->get('DATE_BIGIN');
        $dateend = $request->get('DATE_END'); 
        $yearbudget = $request->BUDGET_YEAR;       
      // dd(dateend);
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

      
            $from = date($displaydate_bigen);
            $to = date($displaydate_end);
      
       
            
        $mpaypay = DB::table('mpay_pay')
        ->leftJoin('hrd_person','mpay_pay.MPAY_PAY_SAVE_HR_ID','=','hrd_person.ID')
        ->where(function($q) use ($search){
            $q->where('MPAY_PAY_COMMENT','like','%'.$search.'%');
            $q->orwhere('HR_FNAME','like','%'.$search.'%');
            $q->orwhere('HR_LNAME','like','%'.$search.'%');
            $q->orwhere('MPAY_PAY_TREASURT_NAME','like','%'.$search.'%');
        })
        ->WhereBetween('MPAY_PAY_DATE',[$from,$to])
        ->get();
  

    
    $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
    $year_id = $yearbudget;

        return view('general_mpay.pay_mpay',[
            'inforpersonuser' => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid,
            'mpaypays' => $mpaypay,
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'search'=> $search,
            'year_id'=>$year_id,
            
        ]);
    }



    public function paympay_add(Request $request,$iduser)
    {
        $inforpersonuserid =  Person::where('ID','=',$iduser)->first();
        $id = $inforpersonuserid->ID;

        $inforpersonuser=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
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

        $infotype = DB::table('launder_type')->get();

        $mpay_setupasset = DB::table('mpay_setupasset_pieces')->get();

        return view('general_mpay.paympay_add',[
            'inforpersonuserid' => $inforpersonuserid,
            'inforpersonuser' => $inforpersonuser,
            'infotypes'=>$infotype,
            'mpay_setupassets' => $mpay_setupasset,

        ]);

    }


    
   public static function refnumberpay()
   {
       
       $year = date('Y')+543;


       $maxnumber = DB::table('mpay_pay')->where('MPAY_PAY_DATE','like',date('Y').'-%')
       ->max('MPAY_PAY_ID');  

    

       if($maxnumber != '' ||  $maxnumber != null){
           
           $refmax = DB::table('mpay_pay')->where('MPAY_PAY_ID','=',$maxnumber)->first();  


           if($refmax->MPAY_PAY_ID != '' ||  $refmax->MPAY_PAY_ID != null){
               $maxref = substr($refmax->MPAY_PAY_CODE, -5)+1;
            }else{
               $maxref = 1;
            }

           $ref = str_pad($maxref, 5, "0", STR_PAD_LEFT);
      
       }else{
           $ref = '00001';
       }

       $ye = date('Y')+543;
       $y = substr($ye, -2);


    $refnumber = 'P'.$y.'/'.$ref;



    return $refnumber;
   }




    public function paympay_save(Request $request)
    {
       
        $datebigin = $request->MPAY_PAY_DATE;
     
        
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
        $MPAYPAY_DATE= $y."-".$m."-".$d;
 
 
        $add = new Mpaypay();
        $add->MPAY_PAY_CODE = $request->MPAY_PAY_CODE;
        $add->MPAY_PAY_DATE = $MPAYPAY_DATE;
        $add->MPAY_PAY_COMMENT = $request->MPAY_PAY_COMMENT;
        $add->MPAY_PAY_SAVE_HR_ID = $request->MPAY_PAY_SAVE_HR_ID;
        $add->MPAY_PAY_SAVE_HR_NAME = $request->MPAY_PAY_SAVE_HR_NAME;
        $add->MPAY_PAY_TREASURT_NAME = $request->MPAY_PAY_TREASURT_NAME;
        $add->MPAY_PAY_DEP = $request->MPAY_PAY_DEP;
        $add->MPAY_PAY_TYPE = $request->MPAY_PAY_TYPE;
        $add->save();
 
        $MPAYPAYID = Mpaypay::max('MPAY_PAY_ID');  //==== นับ ID ต่อจากตัวที่มากที่สุด =====//
 
            if($request->MPAY_PAY_SUB_TYPEID != '' || $request->MPAY_PAY_SUB_TYPEID != null){
 
                     $MPAY_PAY_SUB_TYPEID = $request->MPAY_PAY_SUB_TYPEID;
                     $MPAY_PAY_SUB_AMOUNT = $request->MPAY_PAY_SUB_AMOUNT;
                     $number =count($MPAY_PAY_SUB_TYPEID);
                     $count = 0;
                     for($count = 0; $count < $number; $count++)
                     {  
 
       
                         
                         $add_sub = new Mpaypaysub();
                         $add_sub->MPAY_PAY_ID = $MPAYPAYID;
                         $add_sub->MPAY_PAY_SUB_TYPEID = $MPAY_PAY_SUB_TYPEID[$count];
                         $add_sub->MPAY_PAY_SUB_AMOUNT = $MPAY_PAY_SUB_AMOUNT[$count];
                         $add_sub->save();
 
 
                     }
 
                     }
 
 
 
 
        return redirect()->route('gen_mpay.pay_mpay',[
                     'iduser' =>  $request->MPAY_PAY_SAVE_HR_ID
        ]);
    }



    public function paympay_edit(Request $request,$id,$iduser)
    {
        $inforpersonuserid =  Person::where('ID','=',$iduser)->first();

        $inforpersonuser=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
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

        $mpaypay = DB::table('mpay_pay')
        ->leftJoin('hrd_person','mpay_pay.MPAY_PAY_SAVE_HR_ID','=','hrd_person.ID')
        ->where('MPAY_PAY_ID','=',$id)->first();


        $infotype = DB::table('launder_type')->get();

        $mpay_setupasset = DB::table('mpay_setupasset_pieces')->get();

        $mpay_sub = DB::table('mpay_pay_sub')->where('MPAY_PAY_ID','=',$id)->get();
      
        return view('general_mpay.paympay_edit',[
            'inforpersonuserid' => $inforpersonuserid,
            'inforpersonuser' => $inforpersonuser,
            'infotypes'=>$infotype,
            'mpay_setupassets' => $mpay_setupasset,
            'mpaypays' => $mpaypay,
            'mpay_subs' => $mpay_sub,
        ]);

    }

    public function paympay_update(Request $request)
    {
       
        $datebigin = $request->MPAY_PAY_DATE;
     
        
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
        $MPAYPAY_DATE= $y."-".$m."-".$d;
 
        $id = $request->MPAY_PAY_ID;
 
        $update = Mpaypay::find($id);
        $update->MPAY_PAY_CODE = $request->MPAY_PAY_CODE;
        $update->MPAY_PAY_DATE = $MPAYPAY_DATE;
        $update->MPAY_PAY_COMMENT = $request->MPAY_PAY_COMMENT;
        $update->MPAY_PAY_SAVE_HR_ID = $request->MPAY_PAY_SAVE_HR_ID;
        $update->MPAY_PAY_SAVE_HR_NAME = $request->MPAY_PAY_SAVE_HR_NAME;
        $update->MPAY_PAY_TREASURT_NAME = $request->MPAY_PAY_TREASURT_NAME;
        $update->MPAY_PAY_DEP = $request->MPAY_PAY_DEP;
        $update->MPAY_PAY_TYPE = $request->MPAY_PAY_TYPE;
        $update->save();
 
        // $MPAYPAYID = Mpaypay::max('MPAY_PAY_ID');  //==== นับ ID ต่อจากตัวที่มากที่สุด =====//
        
        Mpaypaysub::where('MPAY_PAY_ID','=',$id)->delete();


                     if($request->MPAY_PAY_SUB_TYPEID != '' || $request->MPAY_PAY_SUB_TYPEID != null){
 
                     $MPAY_PAY_SUB_TYPEID = $request->MPAY_PAY_SUB_TYPEID;
                     $MPAY_PAY_SUB_AMOUNT = $request->MPAY_PAY_SUB_AMOUNT;
                     $number =count($MPAY_PAY_SUB_TYPEID);
                     $count = 0;
                     for($count = 0; $count < $number; $count++)
                     {  
    
                         $add_sub = new Mpaypaysub();
                         $add_sub->MPAY_PAY_ID = $id;
                         $add_sub->MPAY_PAY_SUB_TYPEID = $MPAY_PAY_SUB_TYPEID[$count];
                         $add_sub->MPAY_PAY_SUB_AMOUNT = $MPAY_PAY_SUB_AMOUNT[$count];
                         $add_sub->save();
  
                     }
 
                     }
 
        return redirect()->route('gen_mpay.pay_mpay',[
                     'iduser' =>  $request->MPAY_PAY_SAVE_HR_ID
        ]);
    }

    public function paympay_destroy(Request $request,$id,$iduser)
    {
        Mpaypay::destroy($id);
         Mpaypaysub::where('MPAY_PAY_ID',$id)->delete();
 
        return redirect()->route('gen_mpay.pay_mpay',['iduser' => $iduser]);
    }

//=============================================================//
    public function return_mpay(Request $request,$iduser)
    {
        $email = Auth::user()->email;
        $inforpersonuserid =  Person::where('ID','=',$iduser)->first();
            
        $inforpersonuser  =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
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

     

        return view('general_mpay.return_mpay',[
            'inforpersonuser' => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid,
            
        ]);
    }


    
    public function returnmpay_add(Request $request,$iduser)
    {
        $email = Auth::user()->email;
        $inforpersonuserid =  Person::where('ID','=',$iduser)->first();
            
        $inforpersonuser  =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
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

        $pessonall = Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')->orderBy('hrd_person.HR_FNAME', 'asc')->get();
    
        $departmentsubsub = DB::table('hrd_department_sub_sub')->where('ACTIVE','=','True')->get();
    
        $orgname = DB::table('info_org')->first();
    
    
        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;
        }
    
    
        $budget = DB::table('budget_year')->where('ACTIVE','=','True')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
    
      
    
        return view('general_mpay.returnmpay_add ',[
            'budgets' => $budget,
            'inforpersonuser' => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid,
            'pessonalls' => $pessonall,
            'departmentsubsubs' => $departmentsubsub,
            'orgname' => $orgname->ORG_NAME,
            'year_id' => $yearbudget,
     
           
    
        ]);
    }


  


}
