<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Person;


use App\Models\Assetarticle;
use App\Models\Assetland;
use App\Models\Assetbuilding;
use App\Models\Supplieslocation;
use App\Models\Supplieslocationlevel;
use App\Models\Supplieslocationlevelroom;
use App\Models\Assetdepreciatebuilding;
use App\Models\Assetdepreciate;
use App\Models\Assetborrow;
use App\Models\Assetrequest;
use App\Models\Assetrequestsub;

use App\Models\Assetrequestlend;
use App\Models\Assetrequestlendsub;
use App\Models\Suppliesvendor;
use App\Models\Accounttype;
use App\Models\Accountchart;
use App\Models\Accountchartsub;


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


use PDF;
use Picqer;

date_default_timezone_set("Asia/Bangkok");

class ManageraccountController extends Controller
{
    public function dashboard()
    {
        $year = date('Y');

        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        $year_id = $year+543;

        $m1_11 = DB::table('account')->leftjoin('account_sub','account_sub.ACCOUNT_ID','=','account.ACCOUNT_ID')->where('ACCOUNT_OUT_DATE','like',$year.'-01%')->sum('ACCOUNT_SUB_DEBIT');
        $m2_11 = DB::table('account')->leftjoin('account_sub','account_sub.ACCOUNT_ID','=','account.ACCOUNT_ID')->where('ACCOUNT_OUT_DATE','like',$year.'-02%')->sum('ACCOUNT_SUB_DEBIT');
        $m3_11 = DB::table('account')->leftjoin('account_sub','account_sub.ACCOUNT_ID','=','account.ACCOUNT_ID')->where('ACCOUNT_OUT_DATE','like',$year.'-03%')->sum('ACCOUNT_SUB_DEBIT');
        $m4_11 = DB::table('account')->leftjoin('account_sub','account_sub.ACCOUNT_ID','=','account.ACCOUNT_ID')->where('ACCOUNT_OUT_DATE','like',$year.'-04%')->sum('ACCOUNT_SUB_DEBIT');
        $m5_11 = DB::table('account')->leftjoin('account_sub','account_sub.ACCOUNT_ID','=','account.ACCOUNT_ID')->where('ACCOUNT_OUT_DATE','like',$year.'-05%')->sum('ACCOUNT_SUB_DEBIT');
        $m6_11 = DB::table('account')->leftjoin('account_sub','account_sub.ACCOUNT_ID','=','account.ACCOUNT_ID')->where('ACCOUNT_OUT_DATE','like',$year.'-06%')->sum('ACCOUNT_SUB_DEBIT');
        $m7_11 = DB::table('account')->leftjoin('account_sub','account_sub.ACCOUNT_ID','=','account.ACCOUNT_ID')->where('ACCOUNT_OUT_DATE','like',$year.'-07%')->sum('ACCOUNT_SUB_DEBIT');
        $m8_11 = DB::table('account')->leftjoin('account_sub','account_sub.ACCOUNT_ID','=','account.ACCOUNT_ID')->where('ACCOUNT_OUT_DATE','like',$year.'-08%')->sum('ACCOUNT_SUB_DEBIT');
        $m9_11 = DB::table('account')->leftjoin('account_sub','account_sub.ACCOUNT_ID','=','account.ACCOUNT_ID')->where('ACCOUNT_OUT_DATE','like',$year.'-09%')->sum('ACCOUNT_SUB_DEBIT');
        $m10_11 = DB::table('account')->leftjoin('account_sub','account_sub.ACCOUNT_ID','=','account.ACCOUNT_ID')->where('ACCOUNT_OUT_DATE','like',$year.'-10%')->sum('ACCOUNT_SUB_DEBIT');
        $m11_11 = DB::table('account')->leftjoin('account_sub','account_sub.ACCOUNT_ID','=','account.ACCOUNT_ID')->where('ACCOUNT_OUT_DATE','like',$year.'-11%')->sum('ACCOUNT_SUB_DEBIT');
        $m12_11 = DB::table('account')->leftjoin('account_sub','account_sub.ACCOUNT_ID','=','account.ACCOUNT_ID')->where('ACCOUNT_OUT_DATE','like',$year.'-12%')->sum('ACCOUNT_SUB_DEBIT');


        $m1_12 = DB::table('account')->leftjoin('account_sub','account_sub.ACCOUNT_ID','=','account.ACCOUNT_ID')->where('ACCOUNT_OUT_DATE','like',$year.'-01%')->sum('ACCOUNT_SUB_CREDIT');
        $m2_12 = DB::table('account')->leftjoin('account_sub','account_sub.ACCOUNT_ID','=','account.ACCOUNT_ID')->where('ACCOUNT_OUT_DATE','like',$year.'-02%')->sum('ACCOUNT_SUB_CREDIT');
        $m3_12 = DB::table('account')->leftjoin('account_sub','account_sub.ACCOUNT_ID','=','account.ACCOUNT_ID')->where('ACCOUNT_OUT_DATE','like',$year.'-03%')->sum('ACCOUNT_SUB_CREDIT');
        $m4_12 = DB::table('account')->leftjoin('account_sub','account_sub.ACCOUNT_ID','=','account.ACCOUNT_ID')->where('ACCOUNT_OUT_DATE','like',$year.'-04%')->sum('ACCOUNT_SUB_CREDIT');
        $m5_12 = DB::table('account')->leftjoin('account_sub','account_sub.ACCOUNT_ID','=','account.ACCOUNT_ID')->where('ACCOUNT_OUT_DATE','like',$year.'-05%')->sum('ACCOUNT_SUB_CREDIT');
        $m6_12 = DB::table('account')->leftjoin('account_sub','account_sub.ACCOUNT_ID','=','account.ACCOUNT_ID')->where('ACCOUNT_OUT_DATE','like',$year.'-06%')->sum('ACCOUNT_SUB_CREDIT');
        $m7_12 = DB::table('account')->leftjoin('account_sub','account_sub.ACCOUNT_ID','=','account.ACCOUNT_ID')->where('ACCOUNT_OUT_DATE','like',$year.'-07%')->sum('ACCOUNT_SUB_CREDIT');
        $m8_12 = DB::table('account')->leftjoin('account_sub','account_sub.ACCOUNT_ID','=','account.ACCOUNT_ID')->where('ACCOUNT_OUT_DATE','like',$year.'-08%')->sum('ACCOUNT_SUB_CREDIT');
        $m9_12 = DB::table('account')->leftjoin('account_sub','account_sub.ACCOUNT_ID','=','account.ACCOUNT_ID')->where('ACCOUNT_OUT_DATE','like',$year.'-09%')->sum('ACCOUNT_SUB_CREDIT');
        $m10_12 = DB::table('account')->leftjoin('account_sub','account_sub.ACCOUNT_ID','=','account.ACCOUNT_ID')->where('ACCOUNT_OUT_DATE','like',$year.'-10%')->sum('ACCOUNT_SUB_CREDIT');
        $m11_12 = DB::table('account')->leftjoin('account_sub','account_sub.ACCOUNT_ID','=','account.ACCOUNT_ID')->where('ACCOUNT_OUT_DATE','like',$year.'-11%')->sum('ACCOUNT_SUB_CREDIT');
        $m12_12 = DB::table('account')->leftjoin('account_sub','account_sub.ACCOUNT_ID','=','account.ACCOUNT_ID')->where('ACCOUNT_OUT_DATE','like',$year.'-12%')->sum('ACCOUNT_SUB_CREDIT');

        $infobill = DB::table('account_bill_sub')->sum('ACCOUNT_BILL_SUB_PICE');
        $inforevenue = DB::table('account_sub')->sum('ACCOUNT_SUB_DEBIT');
        $inforepay = DB::table('account_sub')->sum('ACCOUNT_SUB_CREDIT');

        $infocheck = DB::table('account_check')->sum('ACCOUNT_CHECK_PICE');
           
       
    
        return view('manager_account.dashboard_account',[
            'budgets' =>  $budget,
            'year_id'=>$year_id,
            'inforevenues' =>  $inforevenue,
            'inforepays' =>  $inforepay,
            'infobills' =>  $infobill,
            'infochecks' =>  $infocheck,
            'm1_12' => $m1_12,
            'm2_12' => $m2_12,
            'm3_12' => $m3_12,
            'm4_12' => $m4_12,
            'm5_12' => $m5_12,
            'm6_12' => $m6_12,
            'm7_12' => $m7_12,
            'm8_12' => $m8_12,
            'm9_12' => $m9_12,
            'm10_12' => $m10_12,
            'm11_12' => $m11_12,
            'm12_12' => $m12_12,
            'm1_11' => $m1_11,
            'm2_11' => $m2_11,
            'm3_11' => $m3_11,
            'm4_11' => $m4_11,
            'm5_11' => $m5_11,
            'm6_11' => $m6_11,
            'm7_11' => $m7_11,
            'm8_11' => $m8_11,
            'm9_11' => $m9_11,
            'm10_11' => $m10_11,
            'm11_11' => $m11_11,
            'm12_11' => $m12_11,
        ]);
    }


    
    public function account_type()
    {

        return view('manager_account.account_type');
    }

    public function account_type_sub(Request $request,$typename)
    {

        if($typename == 'revenue'){
            $inforevenue = DB::table('account')->where('ACCOUNT_TYPE','=','01')
            ->orderBy('ACCOUNT_ID', 'desc')->get();
        }elseif($typename == 'expenditure'){
            $inforevenue = DB::table('account')->where('ACCOUNT_TYPE','=','02')
            ->orderBy('ACCOUNT_ID', 'desc')->get();
        }elseif($typename == 'general'){
            $inforevenue = DB::table('account')->where('ACCOUNT_TYPE','=','03')
            ->orderBy('ACCOUNT_ID', 'desc')->get();
        }elseif($typename == 'debtor'){
            $inforevenue = DB::table('account')->where('ACCOUNT_TYPE','=','04')
            ->orderBy('ACCOUNT_ID', 'desc')->get();
        }elseif($typename == 'daily'){
            $inforevenue = DB::table('account')->where('ACCOUNT_TYPE','=','05')
            ->orderBy('ACCOUNT_ID', 'desc')->get();
        }

        $displaydate_bigen = '';
        $displaydate_end = '';
        $search = '';

        return view('manager_account.account_type_sub',[
                'typename' => $typename,
                'inforevenues' => $inforevenue,
                'displaydate_bigen' => $displaydate_bigen,  
                'displaydate_end' => $displaydate_end, 
                'search' => $search, 
        ]);
    }


    public function account_type_sub_search(Request $request,$typename)
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

        if($typename == 'revenue'){
            $inforevenue = DB::table('account')->where('ACCOUNT_TYPE','=','01')
            ->where(function($q) use ($search){
                $q->where('ACCOUNT_NUMBER','like','%'.$search.'%');
                $q->orwhere('ACCOUNT_VENDOR','like','%'.$search.'%');
                $q->orwhere('ACCOUNT_DETAIL','like','%'.$search.'%');
            })
            ->WhereBetween('ACCOUNT_OUT_DATE',[$from,$to]) 
            ->orderBy('ACCOUNT_ID', 'desc')
            ->get();
        }elseif($typename == 'expenditure'){
            $inforevenue = DB::table('account')->where('ACCOUNT_TYPE','=','02')
            ->where(function($q) use ($search){
                $q->where('ACCOUNT_NUMBER','like','%'.$search.'%');
                $q->orwhere('ACCOUNT_VENDOR','like','%'.$search.'%');
                $q->orwhere('ACCOUNT_DETAIL','like','%'.$search.'%');
            })
            ->WhereBetween('ACCOUNT_OUT_DATE',[$from,$to]) 
            ->orderBy('ACCOUNT_ID', 'desc')
            ->get();
        }elseif($typename == 'general'){
            $inforevenue = DB::table('account')->where('ACCOUNT_TYPE','=','03')
            ->where(function($q) use ($search){
                $q->where('ACCOUNT_NUMBER','like','%'.$search.'%');
                $q->orwhere('ACCOUNT_VENDOR','like','%'.$search.'%');
                $q->orwhere('ACCOUNT_DETAIL','like','%'.$search.'%');
            })
            ->WhereBetween('ACCOUNT_OUT_DATE',[$from,$to]) 
            ->orderBy('ACCOUNT_ID', 'desc')
            ->get();
        }elseif($typename == 'debtor'){
            $inforevenue = DB::table('account')->where('ACCOUNT_TYPE','=','04')
            ->where(function($q) use ($search){
                $q->where('ACCOUNT_NUMBER','like','%'.$search.'%');
                $q->orwhere('ACCOUNT_VENDOR','like','%'.$search.'%');
                $q->orwhere('ACCOUNT_DETAIL','like','%'.$search.'%');
            })
            ->WhereBetween('ACCOUNT_OUT_DATE',[$from,$to])
            ->orderBy('ACCOUNT_ID', 'desc')      
            ->get();
        }elseif($typename == 'daily'){
            $inforevenue = DB::table('account')->where('ACCOUNT_TYPE','=','05')
            ->where(function($q) use ($search){
                $q->where('ACCOUNT_NUMBER','like','%'.$search.'%');
                $q->orwhere('ACCOUNT_VENDOR','like','%'.$search.'%');
                $q->orwhere('ACCOUNT_DETAIL','like','%'.$search.'%');
            })
            ->WhereBetween('ACCOUNT_OUT_DATE',[$from,$to]) 
            ->orderBy('ACCOUNT_ID', 'desc')
            ->get();
        }

    

        return view('manager_account.account_type_sub',[
                'typename' => $typename,
                'inforevenues' => $inforevenue,
                'displaydate_bigen' => $displaydate_bigen,  
                'displaydate_end' => $displaydate_end, 
                'search' => $search, 
        ]);
    }


       
    public function account_report()
    {
        $inforevenue = DB::table('account')
        ->orderBy('ACCOUNT_ID', 'desc')
        ->get();

        $displaydate_bigen = '';
        $displaydate_end = '';
        $search = '';
        $status_check = '';

        

        $infostatus = DB::table('account_status')->get();

        return view('manager_account.account_report',[
            'inforevenues' => $inforevenue,
            'displaydate_bigen' => $displaydate_bigen,  
            'displaydate_end' => $displaydate_end, 
            'search' => $search,
            'infostatuss' => $infostatus,  
            'status_check' => $status_check,
    ]);
    }

    public function account_report_search(Request $request)
    {
        $search = $request->get('search');
        $datebigin = $request->get('DATE_BIGIN');
        $dateend = $request->get('DATE_END');
        $status = $request->SEND_STATUS;

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


        if($status == null){


        $inforevenue = DB::table('account')
        ->where(function($q) use ($search){
            $q->where('ACCOUNT_NUMBER','like','%'.$search.'%');
            $q->orwhere('ACCOUNT_VENDOR','like','%'.$search.'%');
            $q->orwhere('ACCOUNT_DETAIL','like','%'.$search.'%');
        })
        ->WhereBetween('ACCOUNT_OUT_DATE',[$from,$to])
        ->orderBy('ACCOUNT_ID', 'desc')
        ->get();

    }else{
     
        $inforevenue = DB::table('account')
        ->where('ACCOUNT_STATUS','=',$status)
        ->where(function($q) use ($search){
            $q->where('ACCOUNT_NUMBER','like','%'.$search.'%');
            $q->orwhere('ACCOUNT_VENDOR','like','%'.$search.'%');
            $q->orwhere('ACCOUNT_DETAIL','like','%'.$search.'%');
        })
        ->WhereBetween('ACCOUNT_OUT_DATE',[$from,$to])
        ->orderBy('ACCOUNT_ID', 'desc')
        ->get();

    }

    $status_check = $status;

    $infostatus = DB::table('account_status')->get();

        return view('manager_account.account_report',[
            'inforevenues' => $inforevenue,
            'displaydate_bigen' => $displaydate_bigen,  
            'displaydate_end' => $displaydate_end, 
            'search' => $search, 
            'infostatuss' => $infostatus, 
            'status_check' => $status_check,
            
    ]);
    }

    

    
    public function account_type_subadd(Request $request,$typename)
    {
       
       
        $infoaccount = DB::table('account_chart')->get();


        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;
        }
        
        $budgetyear = DB::table('budget_year')->where('ACTIVE','=','True')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        $infovendor= DB::table('supplies_vendor')->where('ACTIVE','=','True')->get();

        $theme = DB::table('account_theme')->get(); 

        return view('manager_account.account_type_subadd',[
           'infoaccounts' => $infoaccount,
           'yearbudget' => $yearbudget,
           'budgetyears' => $budgetyear,
           'infovendors' => $infovendor,
           'typename' => $typename,
           'themes' => $theme,

           
        ]);
    }


    public function account_type_subadd_theme(Request $request,$typename,$infotheme)
    {
       
    
       
        $infoaccount = DB::table('account_chart')->get();


        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;
        }
        
        $budgetyear = DB::table('budget_year')->where('ACTIVE','=','True')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        $infovendor= DB::table('supplies_vendor')->where('ACTIVE','=','True')->get();


        $infoacc = Accounttheme::where('ACCOUNT_ID','=',$infotheme)->first();
        $infoaccsub = Accountsubtheme::where('ACCOUNT_ID','=',$infotheme)->get();

        $theme = DB::table('account_theme')->get(); 

        return view('manager_account.account_type_subtheme',[
           'infoaccounts' => $infoaccount,
           'yearbudget' => $yearbudget,
           'budgetyears' => $budgetyear,
           'infovendors' => $infovendor,
           'typename' => $typename,
           'infoacc' => $infoacc,
           'infoaccsubs' => $infoaccsub,
           'themes' => $theme,
           
        ]);
    }

    //-----------------------------------------

    public function account_type_subedit(Request $request,$typename,$idref)
    {
        $infoaccount = DB::table('account_chart')->get();


        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;
        }
        
        $budgetyear = DB::table('budget_year')->where('ACTIVE','=','True')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        $infovendor= DB::table('supplies_vendor')->where('ACTIVE','=','True')->get();

        $infoacc = Account::where('ACCOUNT_ID','=',$idref)->first();
        $infoaccsub = Accountsub::where('ACCOUNT_ID','=',$idref)->get();

        return view('manager_account.account_type_subedit',[
           'infoaccounts' => $infoaccount,
           'yearbudget' => $yearbudget,
           'budgetyears' => $budgetyear,
           'infovendors' => $infovendor,
           'typename' => $typename,
           'infoacc' => $infoacc,
           'infoaccsubs' => $infoaccsub,

           
        ]);
    }


    public function revenue()
    {
    
        $inforevenue = DB::table('account')->where('ACCOUNT_TYPE','=','REVENUE')->get();

        return view('manager_account.account_revenue',[
            'inforevenues' => $inforevenue
        ]);
    }

    
  


    public function revenue_add()
    {
        $infoaccount = DB::table('account_chart')->get();


        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;
        }
        
        $budgetyear = DB::table('budget_year')->where('ACTIVE','=','True')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        $infovendor= DB::table('supplies_vendor')->where('ACTIVE','=','True')->get();

        return view('manager_account.account_revenue_add',[
           'infoaccounts' => $infoaccount,
           'yearbudget' => $yearbudget,
           'budgetyears' => $budgetyear,
           'infovendors' => $infovendor
        ]);
    }

    public function revenue_edit(Request $request,$idref)
    {
        $infoacc = Account::where('ACCOUNT_ID','=',$idref)->first();
        $infoaccsub = Accountsub::where('ACCOUNT_ID','=',$idref)->get();

    
        return view('manager_account.account_revenue_edit',[
            'infoacc'=>$infoacc,
            'infoaccsubs'=>$infoaccsub,
        ]);
    }

    public function expenses()
    {
    
        $infoexpensen = DB::table('account')->where('ACCOUNT_TYPE','=','EXPENSES')->get();

        return view('manager_account.account_expenses',[
            'infoexpensens' => $infoexpensen
        ]);
    }

    public function expenses_add()
    {
        $infoaccount = DB::table('account_chart')->get();

        
        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;
        }
        
        $budgetyear = DB::table('budget_year')->where('ACTIVE','=','True')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        $infovendor= DB::table('supplies_vendor')->where('ACTIVE','=','True')->get();

        return view('manager_account.account_expenses_add',[
            'infoaccounts' => $infoaccount,
            'yearbudget' => $yearbudget,
            'budgetyears' => $budgetyear,
            'infovendors' => $infovendor
         ]);
    }

    public function expenses_edit(Request $request,$idref)
    {

        $infoacc = Account::where('ACCOUNT_ID','=',$idref)->first();
        $infoaccsub = Accountsub::where('ACCOUNT_ID','=',$idref)->get();

        return view('manager_account.account_expenses_edit',[
            'infoacc'=>$infoacc,
            'infoaccsubs'=>$infoaccsub,
        ]);
    }


    public function revenueexpenses_save(Request $request)
    {
       

        if($request->ACCOUNT_TYPE == '01'){
            $typename = 'revenue';

        }elseif($request->ACCOUNT_TYPE == '02'){
            $typename = 'expenditure';

        }elseif($request->ACCOUNT_TYPE == '03'){
            $typename = 'general';

        }elseif($request->ACCOUNT_TYPE == '04'){
            $typename = 'debtor';

        }elseif($request->ACCOUNT_TYPE == '05'){
            $typename = 'daily';

        }
    

        $ACCOUNTOUT_DATE = $request->get('ACCOUNT_OUT_DATE');
        $ACCOUNTDOCTAX_DATE = $request->get('ACCOUNT_DOCTAX_DATE');
        $ACCOUNTDOCREF_DATE = $request->get('ACCOUNT_DOCREF_DATE');
      
        if($ACCOUNTOUT_DATE !== '' || $ACCOUNTOUT_DATE !== null){
        $date_bigen_c = Carbon::createFromFormat('d/m/Y', $ACCOUNTOUT_DATE)->format('Y-m-d');
        $date_arrary=explode("-",$date_bigen_c);
    
        $y_sub_st = $date_arrary[0];
    
        if($y_sub_st >= 2500){
            $y = $y_sub_st-543;
        }else{
            $y = $y_sub_st;
        }
    
        $m = $date_arrary[1];
        $d = $date_arrary[2];
            $ACCOUNTOUTDATE = $y."-".$m."-".$d;
        }else{
            $ACCOUNTOUTDATE = '';
        }
        
        if($ACCOUNTDOCTAX_DATE != '' || $ACCOUNTDOCTAX_DATE != null){
          
        $date_end_c = Carbon::createFromFormat('d/m/Y', $ACCOUNTDOCTAX_DATE)->format('Y-m-d');
        $date_arrary_e=explode("-",$date_end_c);
    
        $y_sub_e = $date_arrary_e[0];
    
        if($y_sub_e >= 2500){
            $y_e = $y_sub_e-543;
        }else{
            $y_e = $y_sub_e;
        }
        $m_e = $date_arrary_e[1];
        $d_e = $date_arrary_e[2];
            $ACCOUNTDOCTAXDATE= $y_e."-".$m_e."-".$d_e;
        }else{
            $ACCOUNTDOCTAXDATE= null;
        }

        if($ACCOUNTDOCREF_DATE != '' || $ACCOUNTDOCREF_DATE != null){
        $date_doc_c = Carbon::createFromFormat('d/m/Y', $ACCOUNTDOCREF_DATE)->format('Y-m-d');
        $date_arrary=explode("-",$date_doc_c);
    
        $y_sub_st = $date_arrary[0];
    
        if($y_sub_st >= 2500){
            $y = $y_sub_st-543;
        }else{
            $y = $y_sub_st;
        }
    
        $m = $date_arrary[1];
        $d = $date_arrary[2];
            $ACCOUNTDOCREFDATE= $y."-".$m."-".$d;
        }else{
            $ACCOUNTDOCREFDATE = null;
        }

        
        if( $request->SUBMIT == 'savetheme'){

           $check = Accounttheme::where('ACCOUNT_NUMBER','=',$request->ACCOUNT_NUMBER)->count();
         

           if( $check == 0){
                        $addinfo = new Accounttheme();
                        $addinfo->ACCOUNT_TYPE = $request->ACCOUNT_TYPE;
                        $addinfo->ACCOUNT_YEAR = $request->ACCOUNT_YEAR;
                        
                        $addinfo->ACCOUNT_VENDOR_ID = $request->ACCOUNT_VENDOR_ID;
                        $infonamevendor = DB::table('supplies_vendor')->where('VENDOR_ID','=',$request->ACCOUNT_VENDOR_ID)->first();
                        $addinfo->ACCOUNT_VENDOR = $infonamevendor->VENDOR_NAME;

                        $addinfo->ACCOUNT_NUMBER = $request->ACCOUNT_NUMBER;
                        $addinfo->ACCOUNT_OUT_DATE = $ACCOUNTOUTDATE;

                        $addinfo->ACCOUNT_DOCTAX_NUM = $request->ACCOUNT_DOCTAX_NUM;
                        $addinfo->ACCOUNT_DOCTAX_DATE = $ACCOUNTDOCTAXDATE;

                        $addinfo->ACCOUNT_DOCREF_NUM = $request->ACCOUNT_DOCREF_NUM;
                        $addinfo->ACCOUNT_DOCREF_DATE = $ACCOUNTDOCREFDATE;

                        $addinfo->ACCOUNT_TEXPICE = $request->ACCOUNT_TEXPICE;
                        
                        $addinfo->ACCOUNT_DETAIL = $request->ACCOUNT_DETAIL;
                        $addinfo->save();

                        
                        

                        $ACCOUNTID  = Accounttheme::max('ACCOUNT_ID');
                    
                        if($request->ACCOUNT_SUB_NUM[0] != '' || $request->ACCOUNT_SUB_NUM[0] != null){
                            
                            $ACCOUNT_SUB_NUM = $request->ACCOUNT_SUB_NUM;
                            $ACCOUNT_SUB_DETAIL = $request->ACCOUNT_SUB_DETAIL;
                            $ACCOUNT_SUB_DEBIT = $request->ACCOUNT_SUB_DEBIT;
                            $ACCOUNT_SUB_CREDIT = $request->ACCOUNT_SUB_CREDIT;
                        
                    
                            $number =count($ACCOUNT_SUB_NUM);
                            $count = 0;
                            for($count = 0; $count < $number; $count++)
                            {  
                        
                            $addaccsub = new Accountsubtheme();
                            $addaccsub->ACCOUNT_ID = $ACCOUNTID;
                            $addaccsub->ACCOUNT_SUB_NUM = $ACCOUNT_SUB_NUM[$count];

                            $infoaccount = DB::table('account_chart')->where('ACCOUNT_CHART_CODE','=',$ACCOUNT_SUB_NUM[$count])->first();
                            $addaccsub->ACCOUNT_SUB_DETAIL = $infoaccount->ACCOUNT_CHART_NAME ;

                            $addaccsub->ACCOUNT_SUB_DEBIT = $ACCOUNT_SUB_DEBIT[$count];
                            $addaccsub->ACCOUNT_SUB_CREDIT = $ACCOUNT_SUB_CREDIT[$count];
                            
                            $addaccsub->save(); 
                            
                            
                            }
                        }
                    }else{
                        $infotheme = Accounttheme::where('ACCOUNT_NUMBER','=',$request->ACCOUNT_NUMBER)->first();
                        $ACCOUNTID  =  $infotheme->ACCOUNT_ID;
                    }

                            return redirect()->route('maccount.account_type_subadd_theme',[
                                'typename' => $typename,
                                'infotheme' =>  $ACCOUNTID 
                            ]); 

        }else{
                    $addinfo = new Account();
                    $addinfo->ACCOUNT_TYPE = $request->ACCOUNT_TYPE;
                    $addinfo->ACCOUNT_YEAR = $request->ACCOUNT_YEAR;
                    
                    $addinfo->ACCOUNT_VENDOR_ID = $request->ACCOUNT_VENDOR_ID;
                    $infonamevendor = DB::table('supplies_vendor')->where('VENDOR_ID','=',$request->ACCOUNT_VENDOR_ID)->first();
                    $addinfo->ACCOUNT_VENDOR = $infonamevendor->VENDOR_NAME;

                    $addinfo->ACCOUNT_NUMBER = $request->ACCOUNT_NUMBER;
                    $addinfo->ACCOUNT_OUT_DATE = $ACCOUNTOUTDATE;

                    $addinfo->ACCOUNT_DOCTAX_NUM = $request->ACCOUNT_DOCTAX_NUM;
                    $addinfo->ACCOUNT_DOCTAX_DATE = $ACCOUNTDOCTAXDATE;

                    $addinfo->ACCOUNT_DOCREF_NUM = $request->ACCOUNT_DOCREF_NUM;
                    $addinfo->ACCOUNT_DOCREF_DATE = $ACCOUNTDOCREFDATE;

                    $addinfo->ACCOUNT_TEXPICE = $request->ACCOUNT_TEXPICE;
                    $addinfo->ACCOUNT_INVOICE_NUM = $request->ACCOUNT_INVOICE_NUM;
                    $addinfo->ACCOUNT_DETAIL = $request->ACCOUNT_DETAIL;
            
                    $addinfo->ACCOUNT_STATUS = 'SAVE';
                    $addinfo->save();

                    
                    

                    $ACCOUNTID  = Account::max('ACCOUNT_ID');
                
                    if($request->ACCOUNT_SUB_NUM[0] != '' || $request->ACCOUNT_SUB_NUM[0] != null){
                        
                        $ACCOUNT_SUB_NUM = $request->ACCOUNT_SUB_NUM;
                        $ACCOUNT_SUB_DETAIL = $request->ACCOUNT_SUB_DETAIL;
                        $ACCOUNT_SUB_DEBIT = $request->ACCOUNT_SUB_DEBIT;
                        $ACCOUNT_SUB_CREDIT = $request->ACCOUNT_SUB_CREDIT;
                    
                
                        $number =count($ACCOUNT_SUB_NUM);
                        $count = 0;
                        for($count = 0; $count < $number; $count++)
                        {  
                    
                        $addaccsub = new Accountsub();
                        $addaccsub->ACCOUNT_ID = $ACCOUNTID;
                        $addaccsub->ACCOUNT_SUB_NUM = $ACCOUNT_SUB_NUM[$count];

                        $infoaccount = DB::table('account_chart')->where('ACCOUNT_CHART_CODE','=',$ACCOUNT_SUB_NUM[$count])->first();
                        $addaccsub->ACCOUNT_SUB_DETAIL = $infoaccount->ACCOUNT_CHART_NAME ;

                        $addaccsub->ACCOUNT_SUB_DEBIT = $ACCOUNT_SUB_DEBIT[$count];
                        $addaccsub->ACCOUNT_SUB_CREDIT = $ACCOUNT_SUB_CREDIT[$count];
                        
                        $addaccsub->save(); 
                        
                        
                        }
                    }


                        return redirect()->route('maccount.account_type_sub',[
                            'typename' => $typename
                        ]); 
                
            }         
    
      
        
    }


    public function revenueexpenses_update(Request $request)
    {
        if($request->ACCOUNT_TYPE == '01'){
            $typename = 'revenue';

        }elseif($request->ACCOUNT_TYPE == '02'){
            $typename = 'expenditure';

        }elseif($request->ACCOUNT_TYPE == '03'){
            $typename = 'general';

        }elseif($request->ACCOUNT_TYPE == '04'){
            $typename = 'debtor';

        }elseif($request->ACCOUNT_TYPE == '05'){
            $typename = 'daily';

        }
    

        $ACCOUNTOUT_DATE = $request->get('ACCOUNT_OUT_DATE');
        $ACCOUNTDOCTAX_DATE = $request->get('ACCOUNT_DOCTAX_DATE');
        $ACCOUNTDOCREF_DATE = $request->get('ACCOUNT_DOCREF_DATE');
      
        if($ACCOUNTOUT_DATE !== '' || $ACCOUNTOUT_DATE !== null){
        $date_bigen_c = Carbon::createFromFormat('d/m/Y', $ACCOUNTOUT_DATE)->format('Y-m-d');
        $date_arrary=explode("-",$date_bigen_c);
    
        $y_sub_st = $date_arrary[0];
    
        if($y_sub_st >= 2500){
            $y = $y_sub_st-543;
        }else{
            $y = $y_sub_st;
        }
    
        $m = $date_arrary[1];
        $d = $date_arrary[2];
            $ACCOUNTOUTDATE = $y."-".$m."-".$d;
        }else{
            $ACCOUNTOUTDATE = '';
        }
        
        if($ACCOUNTDOCTAX_DATE != '' || $ACCOUNTDOCTAX_DATE != null){
          
        $date_end_c = Carbon::createFromFormat('d/m/Y', $ACCOUNTDOCTAX_DATE)->format('Y-m-d');
        $date_arrary_e=explode("-",$date_end_c);
    
        $y_sub_e = $date_arrary_e[0];
    
        if($y_sub_e >= 2500){
            $y_e = $y_sub_e-543;
        }else{
            $y_e = $y_sub_e;
        }
        $m_e = $date_arrary_e[1];
        $d_e = $date_arrary_e[2];
            $ACCOUNTDOCTAXDATE= $y_e."-".$m_e."-".$d_e;
        }else{
            $ACCOUNTDOCTAXDATE= null;
        }

        if($ACCOUNTDOCREF_DATE != '' || $ACCOUNTDOCREF_DATE != null){
        $date_doc_c = Carbon::createFromFormat('d/m/Y', $ACCOUNTDOCREF_DATE)->format('Y-m-d');
        $date_arrary=explode("-",$date_doc_c);
    
        $y_sub_st = $date_arrary[0];
    
        if($y_sub_st >= 2500){
            $y = $y_sub_st-543;
        }else{
            $y = $y_sub_st;
        }
    
        $m = $date_arrary[1];
        $d = $date_arrary[2];
            $ACCOUNTDOCREFDATE= $y."-".$m."-".$d;
        }else{
            $ACCOUNTDOCREFDATE = null;
        }

                    $id = $request->ACCOUNT_ID;
                    $addinfo = Account::find($id); 
                    $addinfo->ACCOUNT_TYPE = $request->ACCOUNT_TYPE;
                    $addinfo->ACCOUNT_YEAR = $request->ACCOUNT_YEAR;
                    
                    $addinfo->ACCOUNT_VENDOR_ID = $request->ACCOUNT_VENDOR_ID;
                    $infonamevendor = DB::table('supplies_vendor')->where('VENDOR_ID','=',$request->ACCOUNT_VENDOR_ID)->first();
                    $addinfo->ACCOUNT_VENDOR = $infonamevendor->VENDOR_NAME;

                    $addinfo->ACCOUNT_NUMBER = $request->ACCOUNT_NUMBER;
                    $addinfo->ACCOUNT_OUT_DATE = $ACCOUNTOUTDATE;

                    $addinfo->ACCOUNT_DOCTAX_NUM = $request->ACCOUNT_DOCTAX_NUM;
                    $addinfo->ACCOUNT_DOCTAX_DATE = $ACCOUNTDOCTAXDATE;

                    $addinfo->ACCOUNT_DOCREF_NUM = $request->ACCOUNT_DOCREF_NUM;
                    $addinfo->ACCOUNT_DOCREF_DATE = $ACCOUNTDOCREFDATE;

                    $addinfo->ACCOUNT_TEXPICE = $request->ACCOUNT_TEXPICE;
                    $addinfo->ACCOUNT_INVOICE_NUM = $request->ACCOUNT_INVOICE_NUM;
                    $addinfo->ACCOUNT_DETAIL = $request->ACCOUNT_DETAIL;
                    $addinfo->save();

                    Accountsub::where('ACCOUNT_ID','=',$id)->delete();
                    $ACCOUNTID  = $id;

                
                    if($request->ACCOUNT_SUB_NUM[0] != '' || $request->ACCOUNT_SUB_NUM[0] != null){
                        
                        $ACCOUNT_SUB_NUM = $request->ACCOUNT_SUB_NUM;
                        $ACCOUNT_SUB_DETAIL = $request->ACCOUNT_SUB_DETAIL;
                        $ACCOUNT_SUB_DEBIT = $request->ACCOUNT_SUB_DEBIT;
                        $ACCOUNT_SUB_CREDIT = $request->ACCOUNT_SUB_CREDIT;
                    
                
                        $number =count($ACCOUNT_SUB_NUM);
                        $count = 0;
                        for($count = 0; $count < $number; $count++)
                        {  
                    
                        $addaccsub = new Accountsub();
                        $addaccsub->ACCOUNT_ID = $ACCOUNTID;
                        $addaccsub->ACCOUNT_SUB_NUM = $ACCOUNT_SUB_NUM[$count];

                        $infoaccount = DB::table('account_chart')->where('ACCOUNT_CHART_CODE','=',$ACCOUNT_SUB_NUM[$count])->first();
                        $addaccsub->ACCOUNT_SUB_DETAIL = $infoaccount->ACCOUNT_CHART_NAME ;

                        $addaccsub->ACCOUNT_SUB_DEBIT = $ACCOUNT_SUB_DEBIT[$count];
                        $addaccsub->ACCOUNT_SUB_CREDIT = $ACCOUNT_SUB_CREDIT[$count];
                        
                        $addaccsub->save(); 
                        
                        
                        }
                    


                    return redirect()->route('maccount.account_type_sub',[
                        'typename' => $typename
                    ]);
        
        }
 
        
    }


    

    public function account_pdfcertificate(Request $request,$idref)
{  
    
    $infoaccount =  DB::table('account')->where('ACCOUNT_ID','=',$idref)->first();
    $infosub =  DB::table('account_sub')->where('ACCOUNT_ID','=',$idref)->get();

    $sumdebit =  DB::table('account_sub')->where('ACCOUNT_ID','=',$idref)->sum('ACCOUNT_SUB_DEBIT');
    $sumcredit =  DB::table('account_sub')->where('ACCOUNT_ID','=',$idref)->sum('ACCOUNT_SUB_CREDIT');


    $infoperson1 =  DB::table('account_board')
            ->where('ACCOUNT_BOARD_POSITION_ID','=','1')
            ->leftJoin('hrd_person','account_board.ACCOUNT_BOARD_PERSON_ID','=','hrd_person.ID')
            ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
            ->first();
    $infoperson2 =  DB::table('account_board')
            ->leftJoin('hrd_person','account_board.ACCOUNT_BOARD_PERSON_ID','=','hrd_person.ID')
            ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
            ->where('ACCOUNT_BOARD_POSITION_ID','=','2')
            ->first();
    $infoperson3 =  DB::table('account_board')
            ->leftJoin('hrd_person','account_board.ACCOUNT_BOARD_PERSON_ID','=','hrd_person.ID')
            ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
            ->where('ACCOUNT_BOARD_POSITION_ID','=','3')
            ->first();
    


    $pdf = PDF::loadView('manager_account.account_pdfcertificate',[
        'infoaccount' => $infoaccount,
        'infosubs' => $infosub,
        'sumdebit' => $sumdebit,
        'sumcredit' => $sumcredit,
        'infoperson1' => $infoperson1,
        'infoperson2' => $infoperson2,
        'infoperson3' => $infoperson3,
        



    ]);
    return @$pdf->stream();
}


//=============================================


public function account_board()
{  
    $infoperson =  Person::where('HR_STATUS_ID','=','1')
    ->orderBy('hrd_person.HR_FNAME', 'asc')
    ->get();
    
    $countcheck = Accountboard::count();

    $infoaccboard = Accountboard::get();
    return view('manager_account.account_board',[
        'infopersons'=>$infoperson, 
        'countcheck'=>$countcheck, 
        'infoaccboards'=>$infoaccboard, 
    ]);
}

public function account_boardupdate(Request $request)
{ 
    
    Accountboard::truncate();

   if($request->ACCOUNT_BOARD_PERSON_ID != '' || $request->ACCOUNT_BOARD_PERSON_ID !=null){

            $ACCOUNT_BOARD_PERSON_ID = $request->ACCOUNT_BOARD_PERSON_ID;
            $ACCOUNT_BOARD_POSITION_ID = $request->ACCOUNT_BOARD_POSITION_ID;
            $number =count($ACCOUNT_BOARD_PERSON_ID);
            $count = 0;
            for($count = 0; $count < $number; $count++)
            {  
        
            $add = new Accountboard();
            $add->ACCOUNT_BOARD_PERSON_ID = $ACCOUNT_BOARD_PERSON_ID[$count];
            $add->ACCOUNT_BOARD_POSITION_ID = $ACCOUNT_BOARD_POSITION_ID[$count];
            $add->save(); 

            
            }

   }
    
    return redirect()->route('maccount.account_board');
  
}


    
//==========================================



    public function decline()
    {

        $budget = DB::table('asset_article')
        ->select('YEAR_ID', DB::raw('count(*) as total'))
        ->groupBy('YEAR_ID')
        ->orderBy('YEAR_ID', 'desc')
        ->get();

        $year_max = DB::table('asset_article')->max('YEAR_ID');
        $month = date('m');

        $depbuilding = Assetdepreciatebuilding::leftJoin('asset_building','asset_depreciate_building.DEP_BUILDING_ASSET_ID','=','asset_building.ID')
        ->leftJoin('supplies_decline','supplies_decline.DECLINE_ID','=','asset_building.DECLINE_ID')
        ->where('DEP_BUILDING_YEAR','=',$year_max)
        ->where('DEP_BUILDING_MONTH','=',$month)
        ->get();
        //=========================ผลรวมอาคารสิ่งก่อสร้าง

        $sumbuilding1 = Assetdepreciatebuilding::leftJoin('asset_building','asset_depreciate_building.DEP_BUILDING_ASSET_ID','=','asset_building.ID')
        ->leftJoin('supplies_decline','supplies_decline.DECLINE_ID','=','asset_building.DECLINE_ID')
        ->where('DEP_BUILDING_YEAR','=',$year_max)
        ->where('DEP_BUILDING_MONTH','=',$month)
        ->sum('DEP_BUILDING_PRICE');
        $sumbuilding2 = Assetdepreciatebuilding::leftJoin('asset_building','asset_depreciate_building.DEP_BUILDING_ASSET_ID','=','asset_building.ID')
        ->leftJoin('supplies_decline','supplies_decline.DECLINE_ID','=','asset_building.DECLINE_ID')
        ->where('DEP_BUILDING_YEAR','=',$year_max)
        ->where('DEP_BUILDING_MONTH','=',$month)
        ->sum('DEP_BUILDING_FORWARD');
        $sumbuilding3 = Assetdepreciatebuilding::leftJoin('asset_building','asset_depreciate_building.DEP_BUILDING_ASSET_ID','=','asset_building.ID')
        ->leftJoin('supplies_decline','supplies_decline.DECLINE_ID','=','asset_building.DECLINE_ID')
        ->where('DEP_BUILDING_YEAR','=',$year_max)
        ->where('DEP_BUILDING_MONTH','=',$month)
        ->sum('DEP_BUILDING_DEPRECIATE');
        $sumbuilding4 = Assetdepreciatebuilding::leftJoin('asset_building','asset_depreciate_building.DEP_BUILDING_ASSET_ID','=','asset_building.ID')
        ->leftJoin('supplies_decline','supplies_decline.DECLINE_ID','=','asset_building.DECLINE_ID')
        ->where('DEP_BUILDING_YEAR','=',$year_max)
        ->where('DEP_BUILDING_MONTH','=',$month)
        ->sum('DEP_BUILDING_CUMULATIVE');
        $sumbuilding5 = Assetdepreciatebuilding::leftJoin('asset_building','asset_depreciate_building.DEP_BUILDING_ASSET_ID','=','asset_building.ID')
        ->leftJoin('supplies_decline','supplies_decline.DECLINE_ID','=','asset_building.DECLINE_ID')
        ->where('DEP_BUILDING_YEAR','=',$year_max)
        ->where('DEP_BUILDING_MONTH','=',$month)
        ->sum('DEP_BUILDING_VALUE');
    //==================================================================




        $depreciate = Assetdepreciate::leftJoin('asset_article','asset_depreciate.DEP_ASSET_ID','=','asset_article.ARTICLE_ID')
        ->leftJoin('supplies_decline','supplies_decline.DECLINE_ID','=','asset_article.DECLINE_ID')
        ->where('DEP_YEAR','=',$year_max)
        ->where('DEP_MONTH','=',$month)
        ->get();

        //=========================ผลรวมครุภัณ
        $sumasset1 = Assetdepreciate::leftJoin('asset_article','asset_depreciate.DEP_ASSET_ID','=','asset_article.ARTICLE_ID')
        ->leftJoin('supplies_decline','supplies_decline.DECLINE_ID','=','asset_article.DECLINE_ID')
        ->where('DEP_YEAR','=',$year_max)
        ->where('DEP_MONTH','=',$month)
        ->sum('DEP_PRICE');
        $sumasset2 = Assetdepreciate::leftJoin('asset_article','asset_depreciate.DEP_ASSET_ID','=','asset_article.ARTICLE_ID')
        ->leftJoin('supplies_decline','supplies_decline.DECLINE_ID','=','asset_article.DECLINE_ID')
        ->where('DEP_YEAR','=',$year_max)
        ->where('DEP_MONTH','=',$month)
        ->sum('DEP_FORWARD');
        $sumasset3 = Assetdepreciate::leftJoin('asset_article','asset_depreciate.DEP_ASSET_ID','=','asset_article.ARTICLE_ID')
        ->leftJoin('supplies_decline','supplies_decline.DECLINE_ID','=','asset_article.DECLINE_ID')
        ->where('DEP_YEAR','=',$year_max)
        ->where('DEP_MONTH','=',$month)
        ->sum('DEP_DEPRECIATE');
        $sumasset4 = Assetdepreciate::leftJoin('asset_article','asset_depreciate.DEP_ASSET_ID','=','asset_article.ARTICLE_ID')
        ->leftJoin('supplies_decline','supplies_decline.DECLINE_ID','=','asset_article.DECLINE_ID')
        ->where('DEP_YEAR','=',$year_max)
        ->where('DEP_MONTH','=',$month)
        ->sum('DEP_CUMULATIVE');
        $sumasset5 = Assetdepreciate::leftJoin('asset_article','asset_depreciate.DEP_ASSET_ID','=','asset_article.ARTICLE_ID')
        ->leftJoin('supplies_decline','supplies_decline.DECLINE_ID','=','asset_article.DECLINE_ID')
        ->where('DEP_YEAR','=',$year_max)
        ->where('DEP_MONTH','=',$month)
        ->sum('DEP_VALUE');
       //==================================================================

    
        return view('manager_account.account_decline',[
            'budgets' =>  $budget,
            'depbuildings' =>  $depbuilding,
            'depreciates' =>  $depreciate,
            'year_max' =>  $year_max,
            'm_budget' =>  $month,
            'sumbuilding1' =>  $sumbuilding1,
            'sumbuilding2' =>  $sumbuilding2,
            'sumbuilding3' =>  $sumbuilding3,
            'sumbuilding4' =>  $sumbuilding4,
            'sumbuilding5' =>  $sumbuilding5,
            'sumasset1' =>  $sumasset1,
            'sumasset2' =>  $sumasset2,
            'sumasset3' =>  $sumasset3,
            'sumasset4' =>  $sumasset4,
            'sumasset5' =>  $sumasset5,


        ]);
    }


    public function searchdecline(Request $request)
    {
        $budget = DB::table('asset_article')
        ->select('YEAR_ID', DB::raw('count(*) as total'))
        ->groupBy('YEAR_ID')
        ->orderBy('YEAR_ID', 'desc')
        ->get();

        $year_max = $request->get('YEAR_ID');
        $month = $request->get('SEND_MONTH');

        $depbuilding = Assetdepreciatebuilding::leftJoin('asset_building','asset_depreciate_building.DEP_BUILDING_ASSET_ID','=','asset_building.ID')
        ->leftJoin('supplies_decline','supplies_decline.DECLINE_ID','=','asset_building.DECLINE_ID')
        ->where('DEP_BUILDING_YEAR','=',$year_max)
        ->where('DEP_BUILDING_MONTH','=',$month)
        ->get();

          //=========================ผลรวมอาคารสิ่งก่อสร้าง

          $sumbuilding1 = Assetdepreciatebuilding::leftJoin('asset_building','asset_depreciate_building.DEP_BUILDING_ASSET_ID','=','asset_building.ID')
          ->leftJoin('supplies_decline','supplies_decline.DECLINE_ID','=','asset_building.DECLINE_ID')
          ->where('DEP_BUILDING_YEAR','=',$year_max)
          ->where('DEP_BUILDING_MONTH','=',$month)
          ->sum('DEP_BUILDING_PRICE');
          $sumbuilding2 = Assetdepreciatebuilding::leftJoin('asset_building','asset_depreciate_building.DEP_BUILDING_ASSET_ID','=','asset_building.ID')
          ->leftJoin('supplies_decline','supplies_decline.DECLINE_ID','=','asset_building.DECLINE_ID')
          ->where('DEP_BUILDING_YEAR','=',$year_max)
          ->where('DEP_BUILDING_MONTH','=',$month)
          ->sum('DEP_BUILDING_FORWARD');
          $sumbuilding3 = Assetdepreciatebuilding::leftJoin('asset_building','asset_depreciate_building.DEP_BUILDING_ASSET_ID','=','asset_building.ID')
          ->leftJoin('supplies_decline','supplies_decline.DECLINE_ID','=','asset_building.DECLINE_ID')
          ->where('DEP_BUILDING_YEAR','=',$year_max)
          ->where('DEP_BUILDING_MONTH','=',$month)
          ->sum('DEP_BUILDING_DEPRECIATE');
          $sumbuilding4 = Assetdepreciatebuilding::leftJoin('asset_building','asset_depreciate_building.DEP_BUILDING_ASSET_ID','=','asset_building.ID')
          ->leftJoin('supplies_decline','supplies_decline.DECLINE_ID','=','asset_building.DECLINE_ID')
          ->where('DEP_BUILDING_YEAR','=',$year_max)
          ->where('DEP_BUILDING_MONTH','=',$month)
          ->sum('DEP_BUILDING_CUMULATIVE');
          $sumbuilding5 = Assetdepreciatebuilding::leftJoin('asset_building','asset_depreciate_building.DEP_BUILDING_ASSET_ID','=','asset_building.ID')
          ->leftJoin('supplies_decline','supplies_decline.DECLINE_ID','=','asset_building.DECLINE_ID')
          ->where('DEP_BUILDING_YEAR','=',$year_max)
          ->where('DEP_BUILDING_MONTH','=',$month)
          ->sum('DEP_BUILDING_VALUE');
      //==================================================================


        $depreciate = Assetdepreciate::leftJoin('asset_article','asset_depreciate.DEP_ASSET_ID','=','asset_article.ARTICLE_ID')
        ->leftJoin('supplies_decline','supplies_decline.DECLINE_ID','=','asset_article.DECLINE_ID')
        ->where('DEP_YEAR','=',$year_max)
        ->where('DEP_MONTH','=',$month)
        ->get();


        //=========================ผลรวมครุภัณ
        $sumasset1 = Assetdepreciate::leftJoin('asset_article','asset_depreciate.DEP_ASSET_ID','=','asset_article.ARTICLE_ID')
        ->leftJoin('supplies_decline','supplies_decline.DECLINE_ID','=','asset_article.DECLINE_ID')
        ->where('DEP_YEAR','=',$year_max)
        ->where('DEP_MONTH','=',$month)
        ->sum('DEP_PRICE');
        $sumasset2 = Assetdepreciate::leftJoin('asset_article','asset_depreciate.DEP_ASSET_ID','=','asset_article.ARTICLE_ID')
        ->leftJoin('supplies_decline','supplies_decline.DECLINE_ID','=','asset_article.DECLINE_ID')
        ->where('DEP_YEAR','=',$year_max)
        ->where('DEP_MONTH','=',$month)
        ->sum('DEP_FORWARD');
        $sumasset3 = Assetdepreciate::leftJoin('asset_article','asset_depreciate.DEP_ASSET_ID','=','asset_article.ARTICLE_ID')
        ->leftJoin('supplies_decline','supplies_decline.DECLINE_ID','=','asset_article.DECLINE_ID')
        ->where('DEP_YEAR','=',$year_max)
        ->where('DEP_MONTH','=',$month)
        ->sum('DEP_DEPRECIATE');
        $sumasset4 = Assetdepreciate::leftJoin('asset_article','asset_depreciate.DEP_ASSET_ID','=','asset_article.ARTICLE_ID')
        ->leftJoin('supplies_decline','supplies_decline.DECLINE_ID','=','asset_article.DECLINE_ID')
        ->where('DEP_YEAR','=',$year_max)
        ->where('DEP_MONTH','=',$month)
        ->sum('DEP_CUMULATIVE');
        $sumasset5 = Assetdepreciate::leftJoin('asset_article','asset_depreciate.DEP_ASSET_ID','=','asset_article.ARTICLE_ID')
        ->leftJoin('supplies_decline','supplies_decline.DECLINE_ID','=','asset_article.DECLINE_ID')
        ->where('DEP_YEAR','=',$year_max)
        ->where('DEP_MONTH','=',$month)
        ->sum('DEP_VALUE');
       //==================================================================



        return view('manager_account.account_decline',[
            'budgets' =>  $budget,
            'depbuildings' =>  $depbuilding,
            'depreciates' =>  $depreciate,
            'year_max' =>  $year_max,
            'm_budget' =>  $month,
            'sumbuilding1' =>  $sumbuilding1,
            'sumbuilding2' =>  $sumbuilding2,
            'sumbuilding3' =>  $sumbuilding3,
            'sumbuilding4' =>  $sumbuilding4,
            'sumbuilding5' =>  $sumbuilding5,
            'sumasset1' =>  $sumasset1,
            'sumasset2' =>  $sumasset2,
            'sumasset3' =>  $sumasset3,
            'sumasset4' =>  $sumasset4,
            'sumasset5' =>  $sumasset5,
        ]);
    }


    
    public function creditor()
    {
    
        $inforvendor = DB::table('supplies_vendor')->get();

        return view('manager_account.account_creditor',[
            'inforvendors' =>  $inforvendor 
        ]);
    }


        
    public function creditor_edit(Request $request,$idref)
    {
         $infocreditor = DB::table('supplies_vendor')->where('VENDOR_ID','=',$idref)->first();

        return view('manager_account.account_creditor_edit',[
          'infocreditor' => $infocreditor
        ]);
    }

    public function account_creditor_update(Request $request)
    {
        $id = $request->VENDOR_ID;

        $addsuppliesvendor= Suppliesvendor::find($id); 
        $addsuppliesvendor->VENDOR_NAME = $request->VENDOR_NAME; 
        $addsuppliesvendor->VENDOR_EMAIL = $request->VENDOR_EMAIL;
        $addsuppliesvendor->VENDOR_ADDRESS = $request->VENDOR_ADDRESS;
        $addsuppliesvendor->VENDOR_PHONE = $request->VENDOR_PHONE;
        $addsuppliesvendor->VENDOR_POSTCODE = $request->VENDOR_POSTCODE;
        $addsuppliesvendor->VENDOR_NAME_SHOT = $request->VENDOR_NAME_SHOT;
        $addsuppliesvendor->VAT_NUM = $request->VAT_NUM;
        $addsuppliesvendor->VENDOR_NUM = $request->VENDOR_NUM;
        $addsuppliesvendor->ACTIVE = $request->ACTIVE;
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


    
        return redirect()->route('maccount.creditor'); 

    }

    public function repoort()
    {
    
        return view('manager_account.account_repoort');
    }

    public function accountschart()
    {
    
        $accountchart = DB::table('account_chart')
        ->leftjoin('supplies_type','supplies_type.SUP_TYPE_ID','=','account_chart.ACCOUNT_CHART_SUPTYPEID')
        ->get();
           $search='';
        return view('manager_account.setupaccount_accountschart',[
           'accountcharts' => $accountchart,
           'search' => $search,
        ]);
    }

    
    public function accountschart_search(Request $request)
    {
       
        $search = $request->get('search');
       

        if($search==''){
            $search="";
        }

        $accountchart = DB::table('account_chart')
        ->leftjoin('supplies_type','supplies_type.SUP_TYPE_ID','=','account_chart.ACCOUNT_CHART_SUPTYPEID')
        ->where(function($q) use ($search){
            $q->where('ACCOUNT_CHART_CODE','like','%'.$search.'%');
            $q->orwhere('ACCOUNT_CHART_NAME','like','%'.$search.'%');
        })
        ->get();

        return view('manager_account.setupaccount_accountschart',[
           'accountcharts' => $accountchart,
           'search' => $search, 
        ]);
    }

    public function accountschart_add()
    {

        $infoaccounttype = DB::table('account_type')->get();

        $infoaccountgroup = DB::table('account_group')->get();
        $infoaccountgroupsub1 = DB::table('account_group_sub1')->get();
        $infoaccountgroupsub2 = DB::table('account_group_sub2')->get();
        $infoaccountgroupsub3 = DB::table('account_group_sub3')->get();

        $infosuptype = DB::table('supplies_type')->get();

        return view('manager_account.setupaccount_accountschart_add',[
            'infoaccounttypes' =>  $infoaccounttype, 
            'infoaccountgroups' =>  $infoaccountgroup, 
            'infoaccountgroupsub1s' =>  $infoaccountgroupsub1, 
            'infoaccountgroupsub2s' =>  $infoaccountgroupsub2, 
            'infoaccountgroupsub3s' =>  $infoaccountgroupsub3, 
            'infosuptypes' => $infosuptype
        ]);
    }


    public function accountschart_save(Request $request)
    {
        $addinfo = new Accountchart(); 
        $addinfo->ACCOUNT_TYPE = $request->ACCOUNT_TYPE;
        $addinfo->ACCOUNT_CHART_CODE = $request->ACCOUNT_CHART_CODE;
        $addinfo->ACCOUNT_CHART_NAME = $request->ACCOUNT_CHART_NAME;
        $addinfo->ACCOUNT_CHART_DETAIL = $request->ACCOUNT_CHART_DETAIL;
        $addinfo->ACCOUNT_CHART_TAX = $request->ACCOUNT_CHART_TAX;
        $addinfo->ACCOUNT_CHART_SUPTYPEID = $request->ACCOUNT_CHART_SUPTYPEID;
        $addinfo->ACCOUNT_CHART_DC = $request->ACCOUNT_CHART_DC;
        $addinfo->save();

        return redirect()->route('maccount.accountschart'); 
    }

    public function accountschart_edit(Request $request,$idref)
    {

        $infoaccounttype = DB::table('account_type')->get();

        $infoaccountgroup = DB::table('account_group')->get();
        $infoaccountgroupsub1 = DB::table('account_group_sub1')->get();
        $infoaccountgroupsub2 = DB::table('account_group_sub2')->get();
        $infoaccountgroupsub3 = DB::table('account_group_sub3')->get();

        $infosuptype = DB::table('supplies_type')->get();

        $infoaccount = DB::table('account_chart')->where('ACCOUNT_CHART_ID','=',$idref)->first();

        return view('manager_account.setupaccount_accountschart_edit',[
            'infoaccounttypes' =>  $infoaccounttype, 
            'infoaccountgroups' =>  $infoaccountgroup, 
            'infoaccountgroupsub1s' =>  $infoaccountgroupsub1, 
            'infoaccountgroupsub2s' =>  $infoaccountgroupsub2, 
            'infoaccountgroupsub3s' =>  $infoaccountgroupsub3, 
            'infosuptypes' => $infosuptype,
            'infoaccount' => $infoaccount,
        ]);
    }


    public function accountschart_update(Request $request)
    {
        $id = $request->ACCOUNT_CHART_ID;

        $addinfo =  Accountchart::find($id); 
        $addinfo->ACCOUNT_TYPE = $request->ACCOUNT_TYPE;
        $addinfo->ACCOUNT_CHART_CODE = $request->ACCOUNT_CHART_CODE;
        $addinfo->ACCOUNT_CHART_NAME = $request->ACCOUNT_CHART_NAME;
        $addinfo->ACCOUNT_CHART_DETAIL = $request->ACCOUNT_CHART_DETAIL;
        $addinfo->ACCOUNT_CHART_TAX = $request->ACCOUNT_CHART_TAX;
        $addinfo->ACCOUNT_CHART_SUPTYPEID = $request->ACCOUNT_CHART_SUPTYPEID;
        $addinfo->ACCOUNT_CHART_DC = $request->ACCOUNT_CHART_DC;
        $addinfo->save();

        return redirect()->route('maccount.accountschart'); 
    }


    //-----------------------------------------------------------------

    public function accountschart_sub(Request $request,$idref)
    {
    
        $accountchartsub = DB::table('account_chart_sub')
        ->leftjoin('supplies_type','supplies_type.SUP_TYPE_ID','=','account_chart_sub.ACCOUNT_CHART_SUB_SUPTYPEID')
        ->where('ACCOUNT_CHART_ID','=',$idref)->get();


        $infoaccount = DB::table('account_chart')->where('ACCOUNT_CHART_ID','=',$idref)->first();
        return view('manager_account.setupaccount_accountschart_sub',[
            'infoaccount' => $infoaccount,
           'accountchartsubs' => $accountchartsub 
        ]);
    }

    public function accountschart_sub_add(Request $request,$idref)
    {

        $infosuptype = DB::table('supplies_type')->get();

        return view('manager_account.setupaccount_accountschart_sub_add',[
                        'idref' => $idref,
                        'infosuptypes' => $infosuptype
        ]);
    }


    public function accountschart_sub_save(Request $request)
    {
        $addinfo = new Accountchartsub(); 
        $addinfo->ACCOUNT_CHART_SUB_CODE = $request->ACCOUNT_CHART_SUB_CODE;
        $addinfo->ACCOUNT_CHART_SUB_NAME = $request->ACCOUNT_CHART_SUB_NAME;
        $addinfo->ACCOUNT_CHART_ID = $request->ACCOUNT_CHART_ID;
        $addinfo->ACCOUNT_CHART_SUB_SUPTYPEID = $request->ACCOUNT_CHART_SUB_SUPTYPEID;
        $addinfo->ACCOUNT_CHART_SUB_DC = $request->ACCOUNT_CHART_SUB_DC;
        $addinfo->save();

      
        return redirect()->route('maccount.accountschart_sub',[
            'idref' => $request->ACCOUNT_CHART_ID
        ]); 
    }



    public function setupaccount_accountschart_sub_edit(Request $request,$idref,$idsub)
    {

        $infosuptype = DB::table('supplies_type')->get();

        $infoidsub = DB::table('account_chart_sub')->where('ACCOUNT_CHART_SUB_ID','=',$idsub)->first();

        return view('manager_account.setupaccount_accountschart_sub_edit',[
                        'idref' => $idref,
                        'infosuptypes' => $infosuptype,
                        'infoidsub' => $infoidsub,
        ]);
    }


    public function setupaccount_accountschart_sub_update(Request $request)
    {
        $id = $request->ACCOUNT_CHART_SUB_ID;

        $addinfo = Accountchartsub::find($id); 
        $addinfo->ACCOUNT_CHART_SUB_CODE = $request->ACCOUNT_CHART_SUB_CODE;
        $addinfo->ACCOUNT_CHART_SUB_NAME = $request->ACCOUNT_CHART_SUB_NAME;
        $addinfo->ACCOUNT_CHART_ID = $request->ACCOUNT_CHART_ID;
        $addinfo->ACCOUNT_CHART_SUB_SUPTYPEID = $request->ACCOUNT_CHART_SUB_SUPTYPEID;
        $addinfo->ACCOUNT_CHART_SUB_DC = $request->ACCOUNT_CHART_SUB_DC;
        $addinfo->save();

      
        return redirect()->route('maccount.accountschart_sub',[
            'idref' => $request->ACCOUNT_CHART_ID
        ]); 
    }


    //-----------------------------------------------------------------


    public function accounttype()
    {
    
        $accounttype = DB::table('account_type')->get();
    
        return view('manager_account.setupaccount_accounttype',[
            'accounttypes' => $accounttype 
        ]);
    }

   
    public function accounttype_add()
    {

        return view('manager_account.setupaccount_accounttype_add');
    }
    

    public function accounttype_save(Request $request)
    {


        $addinfo = new Accounttype(); 
        $addinfo->ACCOUNT_TYPE_CODE = $request->ACCOUNT_TYPE_CODE;
        $addinfo->ACCOUNT_TYPE_NAME = $request->ACCOUNT_TYPE_NAME;
        $addinfo->save();

      
        return redirect()->route('maccount.accounttype'); 
    }
    


    public function accounttype_edit(Request $request,$idref)
    {
        $infotype = Accounttype::where('ACCOUNT_TYPE_ID','=',$idref)->first();

        return view('manager_account.setupaccount_accounttype_edit',[
            'infotype' => $infotype
        ]);
    }
    

    public function accounttype_update(Request $request)
    {
        $id = $request->ACCOUNT_TYPE_ID;
        $addinfo =  Accounttype::find($id); 
        $addinfo->ACCOUNT_TYPE_CODE = $request->ACCOUNT_TYPE_CODE;
        $addinfo->ACCOUNT_TYPE_NAME = $request->ACCOUNT_TYPE_NAME;
        $addinfo->save();

        return redirect()->route('maccount.accounttype'); 
    }
    
    

     
    public function account_group()
    {
    
        $infoaccountgroup = DB::table('account_group')->get();
        return view('manager_account.account_group',[
          'infoaccountgroups' => $infoaccountgroup 
        ]);
    }

    public function account_group_save()
    {
    
        return view('manager_account.account_group_save');
    }


    public function account_group_update(Request $request)
    {
        $addinfo = new Accountgroup(); 
        $addinfo->ACCOUNT_GROUP_CODE = $request->ACCOUNT_GROUP_CODE;
        $addinfo->ACCOUNT_GROUP_NAME = $request->ACCOUNT_GROUP_NAME;
    
        $addinfo->save();

      
        return redirect()->route('maccount.account_group'); 
    }

    
    public function account_group_sub1()
    {
        $infoaccountgroupsub1 = DB::table('account_group_sub1')
        ->leftjoin('account_group','account_group.ACCOUNT_GROUP_CODE','=','account_group_sub1.ACCOUNT_GROUP_ID')
        ->get();
    
        return view('manager_account.account_group_sub1',[
            'infoaccountgroupsub1s' => $infoaccountgroupsub1 
            ]);
    }

    public function account_group_sub1_save()
    {
        $infoaccountgroup = DB::table('account_group')->get();
        return view('manager_account.account_group_sub1_save',[
            'infoaccountgroups' => $infoaccountgroup 
            ]);
       
    }

    public function account_group_sub1_update(Request $request)
    {
        $addinfo = new Accountgroupsub1(); 
        $addinfo->ACCOUNT_GROUP_ID = $request->ACCOUNT_GROUP_ID;
        $addinfo->ACCOUNT_GROUP_SUB1_CODE = $request->ACCOUNT_GROUP_SUB1_CODE;
        $addinfo->ACCOUNT_GROUP_SUB1_NAME = $request->ACCOUNT_GROUP_SUB1_NAME;
    
        $addinfo->save();

      
        return redirect()->route('maccount.account_group_sub1'); 
    }


    
    public function account_group_sub2()
    {
    
        $infoaccountgroupsub2 = DB::table('account_group_sub2')
        ->leftjoin('account_group_sub1','account_group_sub1.ACCOUNT_GROUP_SUB1_CODE','=','account_group_sub2.ACCOUNT_GROUP_SUB1_ID')
        ->get();

        return view('manager_account.account_group_sub2',[
            'infoaccountgroupsub2s' => $infoaccountgroupsub2
        ]);
    }

    public function account_group_sub2_save()
    {
        $infoaccountgroupsub1 = DB::table('account_group_sub1')->get();
    
        return view('manager_account.account_group_sub2_save',[
            'infoaccountgroupsub1s' => $infoaccountgroupsub1
        ]);
    }
    public function account_group_sub2_update(Request $request)
    {
        $addinfo = new Accountgroupsub2(); 
        $addinfo->ACCOUNT_GROUP_SUB1_ID = $request->ACCOUNT_GROUP_SUB1_ID;
        $addinfo->ACCOUNT_GROUP_SUB2_CODE = $request->ACCOUNT_GROUP_SUB2_CODE;
        $addinfo->ACCOUNT_GROUP_SUB2_NAME = $request->ACCOUNT_GROUP_SUB2_NAME;
    
        $addinfo->save();

      
        return redirect()->route('maccount.account_group_sub2'); 
    }


    public function account_group_sub3()
    {
    
        $infoaccountgroupsub3 = DB::table('account_group_sub3')
        ->leftjoin('account_group_sub2','account_group_sub2.ACCOUNT_GROUP_SUB2_CODE','=','account_group_sub3.ACCOUNT_GROUP_SUB2_ID')
        ->get();

        return view('manager_account.account_group_sub3',[
            'infoaccountgroupsub3s' => $infoaccountgroupsub3
        ]);
    }

    public function account_group_sub3_save()
    {
        $infoaccountgroupsub2 = DB::table('account_group_sub2')->get();
    
        return view('manager_account.account_group_sub3_save',[
            'infoaccountgroupsub2s' => $infoaccountgroupsub2
        ]);
    }
    public function account_group_sub3_update(Request $request)
    {
        $addinfo = new Accountgroupsub3(); 
        $addinfo->ACCOUNT_GROUP_SUB2_ID = $request->ACCOUNT_GROUP_SUB2_ID;
        $addinfo->ACCOUNT_GROUP_SUB3_CODE = $request->ACCOUNT_GROUP_SUB3_CODE;
        $addinfo->ACCOUNT_GROUP_SUB3_NAME = $request->ACCOUNT_GROUP_SUB3_NAME;
    
        $addinfo->save();

      
        return redirect()->route('maccount.account_group_sub3'); 
    }

    //================================================บัญชีย่อย
    public function account_group_sub4()
    {
    
        $infoaccountgroupsub4 = DB::table('account_group_sub4')
        ->leftjoin('account_group_sub3','account_group_sub3.ACCOUNT_GROUP_SUB3_CODE','=','account_group_sub4.ACCOUNT_GROUP_SUB3_ID')
        ->get();

        return view('manager_account.account_group_sub4',[
            'infoaccountgroupsub4s' => $infoaccountgroupsub4
        ]);
    }

    public function account_group_sub4_save()
    {
        $infoaccountgroupsub3 = DB::table('account_group_sub3')->get();
    
        return view('manager_account.account_group_sub4_save',[
            'infoaccountgroupsub3s' => $infoaccountgroupsub3
        ]);
    }
    public function account_group_sub4_update(Request $request)
    {
        $addinfo = new Accountgroupsub4(); 
        $addinfo->ACCOUNT_GROUP_SUB3_ID = $request->ACCOUNT_GROUP_SUB3_ID;
        $addinfo->ACCOUNT_GROUP_SUB4_CODE = $request->ACCOUNT_GROUP_SUB4_CODE;
        $addinfo->ACCOUNT_GROUP_SUB4_NAME = $request->ACCOUNT_GROUP_SUB4_NAME;
    
        $addinfo->save();

      
        return redirect()->route('maccount.account_group_sub4'); 
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

        return view('manager_account.account_check',[
            'infochecks' => $infocheck,
            'displaydate_bigen' => $displaydate_bigen,  
            'displaydate_end' => $displaydate_end, 
            'search' => $search, 
        ]);
    }


    public function account_checkpdf(Request $request,$idref)
    {
        
        $infocheck = DB::table('account_check')->where('ACCOUNT_CHECK_ID','=',$idref)->first();
        
        return view('manager_account.account_checkpdf',[
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


        return view('manager_account.account_check',[
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

        return view('manager_account.account_check_add',[
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
    
        if($request->ACCOUNT_CHECK_SUB_NUMBER[0] !== '' || $request->ACCOUNT_CHECK_SUB_NUMBER[0] !== null){
            
            $ACCOUNT_CHECK_SUB_NUMBER = $request->ACCOUNT_CHECK_SUB_NUMBER;
            $ACCOUNT_CHECK_SUB_DOC = $request->ACCOUNT_CHECK_SUB_DOC;
            $ACCOUNT_CHECK_SUB_VENDOR = $request->ACCOUNT_CHECK_SUB_VENDOR;
            $ACCOUNT_CHECK_SUB_PICE = $request->ACCOUNT_CHECK_SUB_PICE;
         
    
            $number =count($ACCOUNT_CHECK_SUB_NUMBER);
            $count = 0;
            for($count = 0; $count < $number; $count++)
            {  
              //echo $row3[$count_3]."<br>";
          
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

        return redirect()->route('maccount.account_check'); 
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

        return view('manager_account.account_check_edit',[
            'yearbudget' => $yearbudget,
            'budgetyears' => $budgetyear,
            'infocheck' => $infocheck,
            'infovendors' => $infovendor,
            'infoaccounts' => $infoaccount
         ]);
    }

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
    
        if($request->ACCOUNT_CHECK_SUB_NUMBER[0] != '' || $request->ACCOUNT_CHECK_SUB_NUMBER[0] != null){
            
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



        return redirect()->route('maccount.account_check'); 
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

      //===============================ทะเบียนบิล

      public function account_bill()
      {
          $infobill = DB::table('account_bill')
          ->orderBy('ACCOUNT_BILL_ID', 'desc') 
          ->get();

          $displaydate_bigen = '';
          $displaydate_end = '';
          $search = '';
  
          return view('manager_account.account_bill',[
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

        

        
  
          return view('manager_account.account_bill',[
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
  
          return view('manager_account.account_bill_add',[
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
      
        
          if($request->ACCOUNT_BILL_SUB_NUMBER[0] != '' || $request->ACCOUNT_BILL_SUB_NUMBER[0] != null){
            
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

  
  
          return redirect()->route('maccount.account_bill'); 
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
        $infoaccount= DB::table('account')->where('ACCOUNT_TYPE','=','EXPENSES')->get();
        $infovendor= DB::table('supplies_vendor')->where('ACTIVE','=','True')->get();

        return view('manager_account.account_bill_edit',[
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
    
        if($request->ACCOUNT_BILL_SUB_NUMBER[0] != '' || $request->ACCOUNT_BILL_SUB_NUMBER[0] != null){
            
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



        return redirect()->route('maccount.account_bill'); 
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

    
        return redirect()->route('maccount.account_check'); 
    }

    //------------------------------------------------------------

    function account_bill_list(Request $request)
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
                <select name="ACCOUNT_BILL_SUB_NUMBER[]" id="ACCOUNT_BILL_SUB_NUMBER0" class="form-control input-lg" style=" font-family: \'Kanit\', sans-serif;" >
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
                <input type="hidden" name="ACCOUNT_BILL_SUB_DOC[]" id="ACCOUNT_BILL_SUB_DOC0" class="form-control input-sm" style=" font-family: \'Kanit\', sans-serif;"   value="'.$row->ACCOUNT_INVOICE_NUM.'">
            </td>
            <td>
            '.$row->ACCOUNT_VENDOR.'
                <input type="hidden" name="ACCOUNT_BILL_SUB_VENDOR[]" id="ACCOUNT_BILL_SUB_VENDOR0" class="form-control input-sm" style=" font-family: \'Kanit\', sans-serif;" value="'.$row->ACCOUNT_VENDOR.'" >
            </td>
            <td>
              
                <input name="ACCOUNT_BILL_SUB_PICE[]" id="ACCOUNT_BILL_SUB_PICE0" class="form-control input-sm" style=" font-family: \'Kanit\', sans-serif;"  value="'.$sumpice.'.00">
            </td>
                <td style="text-align: center;"><a class="btn btn-danger fa fa-trash-alt remove" style="color:#FFFFFF;"></a></td>
        
        </tr>';
    }

    echo $output;
        
    }

    //==================รวมเดบิตเคดิต

    public static function sumdebit($id)
    {
        $total =  DB::table('account_sub')->where('ACCOUNT_ID','=',$id)->sum('ACCOUNT_SUB_DEBIT');
        

        return $total;
    }

    public static function sumcredit($id)
    {
        $total =  DB::table('account_sub')->where('ACCOUNT_ID','=',$id)->sum('ACCOUNT_SUB_CREDIT');

        return $total;
    }


    function showaccount(Request $request)
    {
        $idaccount = $request->ACCOUNT_SUB_NUM;
        $inforaccount=  Accountchart::where('ACCOUNT_CHART_CODE','=',$idaccount)->first();
        echo $inforaccount->ACCOUNT_CHART_NAME;
        
    }




    public static function refnumberrev($typename)
    {
        
        $year = date('Y')+543;

        if($typename == 'revenue'){
            $accounttype ='01';
            $mono = 'บร';
            $typenum = '1';

        }elseif($typename == 'expenditure'){
            $accounttype ='02';
            $mono = 'บจ';
            $typenum = '2';
        }elseif($typename == 'general'){
            $accounttype ='03';
            $mono = 'บท';
            $typenum = '3';
        }elseif($typename == 'debtor'){
            $accounttype ='04';
            $mono = 'บท';
            $typenum = '4';

        }elseif($typename == 'daily'){
               $accounttype ='05';
               $mono = 'บท';
               $typenum = '5';
        }


        $maxnumber = DB::table('account')->where('ACCOUNT_YEAR','=',$year)
        ->where('ACCOUNT_TYPE','=',$accounttype)
        ->max('ACCOUNT_ID');  

     

        if($maxnumber != '' ||  $maxnumber != null){
            
            $refmax = DB::table('account')->where('ACCOUNT_ID','=',$maxnumber)->first();  


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


     $refnumber = $mono.''.$y.'/'.$typenum.''.$ref;



     return $refnumber;
    }


    public static function refnumberexp()
    {
        $year = date('Y')+543;

        $maxnumber = DB::table('account')->where('ACCOUNT_YEAR','like',$year)->max('ACCOUNT_ID');  

     

        if($maxnumber != '' ||  $maxnumber != null){
            
            $refmax = DB::table('account')->where('ACCOUNT_ID','=',$maxnumber)->first();  


            if($refmax->ACCOUNT_ID != '' ||  $refmax->ACCOUNT_ID != null){
                $maxref = substr($refmax->ACCOUNT_NUMBER, -5)+1;
             }else{
                $maxref = 1;
             }

            $ref = str_pad($maxref, 6, "0", STR_PAD_LEFT);
       
        }else{
            $ref = '000001';
        }

        $ye = date('Y')+543;
        $y = substr($ye, -2);

     $refnumber ='EXP'.$y.'-'.$ref;



     return $refnumber;
    }

    public static function refnumbercheck()
    {
        $year = date('Y')+543;

        $maxnumber = DB::table('account_check')->where('ACCOUNT_CHECK_YEAR','like',$year)->max('ACCOUNT_CHECK_ID');  

     

        if($maxnumber != '' ||  $maxnumber != null){
            
            $refmax = DB::table('account_check')->where('ACCOUNT_CHECK_ID','=',$maxnumber)->first();  


            if($refmax->ACCOUNT_CHECK_ID != '' ||  $refmax->ACCOUNT_CHECK_ID != null){
                $maxref = substr($refmax->ACCOUNT_CHECK_NUMBER, -5)+1;
             }else{
                $maxref = 1;
             }

            $ref = str_pad($maxref, 6, "0", STR_PAD_LEFT);
       
        }else{
            $ref = '000001';
        }

        $ye = date('Y')+543;
        $y = substr($ye, -2);

     $refnumber ='C'.$y.'-'.$ref;



     return $refnumber;
    }


    public static function refnumberbill()
    {
        $year = date('Y')+543;

        $maxnumber = DB::table('account_bill')->where('ACCOUNT_BILL_YEAR','like',$year)->max('ACCOUNT_BILL_ID');  

     

        if($maxnumber != '' ||  $maxnumber != null){
            
            $refmax = DB::table('account_bill')->where('ACCOUNT_BILL_ID','=',$maxnumber)->first();  


            if($refmax->ACCOUNT_BILL_ID != '' ||  $refmax->ACCOUNT_BILL_ID != null){
                $maxref = substr($refmax->ACCOUNT_BILL_NUMBER, -5)+1;
             }else{
                $maxref = 1;
             }

            $ref = str_pad($maxref, 6, "0", STR_PAD_LEFT);
       
        }else{
            $ref = '000001';
        }

        $ye = date('Y')+543;
        $y = substr($ye, -2);


     $refnumber ='B'.$y.'-'.$ref;

     return $refnumber;
    }

    
    public function account_pdfbook_1()
    {
        $pdf = PDF::loadView('manager_account.account_pdfbook_1');
        return @$pdf->stream();
    }
    public function account_pdfbook_2()
    {
        $pdf = PDF::loadView('manager_account.account_pdfbook_2');
        return @$pdf->stream();
    }
    public function account_pdfbook_type_1()
    {
        $pdf = PDF::loadView('manager_account.account_pdfbook_type_1');
        return @$pdf->stream();
    }
    public function account_pdfbook_type_2()
    {
        $pdf = PDF::loadView('manager_account.account_pdfbook_type_2');
        return @$pdf->stream();
    }
    public function account_pdf_reportday()
    {
        $pdf = PDF::loadView('manager_account.account_pdf_reportday');
        return @$pdf->stream();
    }



}

