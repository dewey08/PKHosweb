<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Person;
use App\Models\Donationwealth;
use App\Models\Donationtopic;
use App\Models\Donationunit;
use App\Models\Donateperson;
use App\Models\Donateperson_sub;
use App\Models\Donationfund;
use App\Models\Donateopenform;

use PDF;
use Cookie;

date_default_timezone_set("Asia/Bangkok");

class ManagercrmController extends Controller
{
    public function dashboard()
    {   
        
        $year = date('Y');

        $amount_1 = DB::table('donation_person')->where('DONATE_PERSON_DATE','like',$year.'%')->count();
        $amount_2 = DB::table('donation_person_sub')->where('PERSON_DONATE_SUB_DATE','like',$year.'%')->sum('PERSON_DONATE_SUB_PRICE');
        $amount_3 = DB::table('donation_person_sub')->where('PERSON_DONATE_SUB_DATE','like',$year.'%')->count();
    

        $m1_1 = DB::table('donation_person_sub')->where('PERSON_DONATE_SUB_DATE','like',$year.'-01%')->sum('PERSON_DONATE_SUB_PRICE');
        $m2_1 = DB::table('donation_person_sub')->where('PERSON_DONATE_SUB_DATE','like',$year.'-02%')->sum('PERSON_DONATE_SUB_PRICE');
        $m3_1 = DB::table('donation_person_sub')->where('PERSON_DONATE_SUB_DATE','like',$year.'-03%')->sum('PERSON_DONATE_SUB_PRICE');
        $m4_1 = DB::table('donation_person_sub')->where('PERSON_DONATE_SUB_DATE','like',$year.'-04%')->sum('PERSON_DONATE_SUB_PRICE');
        $m5_1 = DB::table('donation_person_sub')->where('PERSON_DONATE_SUB_DATE','like',$year.'-05%')->sum('PERSON_DONATE_SUB_PRICE');
        $m6_1 = DB::table('donation_person_sub')->where('PERSON_DONATE_SUB_DATE','like',$year.'-06%')->sum('PERSON_DONATE_SUB_PRICE');
        $m7_1 = DB::table('donation_person_sub')->where('PERSON_DONATE_SUB_DATE','like',$year.'-07%')->sum('PERSON_DONATE_SUB_PRICE');
        $m8_1 = DB::table('donation_person_sub')->where('PERSON_DONATE_SUB_DATE','like',$year.'-08%')->sum('PERSON_DONATE_SUB_PRICE');
        $m9_1 = DB::table('donation_person_sub')->where('PERSON_DONATE_SUB_DATE','like',$year.'-09%')->sum('PERSON_DONATE_SUB_PRICE');
        $m10_1 = DB::table('donation_person_sub')->where('PERSON_DONATE_SUB_DATE','like',$year.'-10%')->sum('PERSON_DONATE_SUB_PRICE');
        $m11_1 = DB::table('donation_person_sub')->where('PERSON_DONATE_SUB_DATE','like',$year.'-11%')->sum('PERSON_DONATE_SUB_PRICE');
        $m12_1 = DB::table('donation_person_sub')->where('PERSON_DONATE_SUB_DATE','like',$year.'-12%')->sum('PERSON_DONATE_SUB_PRICE');


        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        $year_id = $year+543;

        $ranks = DB::table('donation_person_sub')
        ->select(DB::raw('sum(donation_person_sub.PERSON_DONATE_SUB_PRICE) as sum'),'DONATE_PERSON_NAME')
        ->leftJoin('donation_person', 'donation_person.DONATE_PERSON_ID', '=', 'donation_person_sub.DONATE_PERSON_ID')
        ->groupBy('donation_person.DONATE_PERSON_NAME')
        ->orderBy('sum','desc')
        ->where('donation_person_sub.PERSON_DONATE_SUB_DATE','like',$year.'%')
        ->limit(5)
        ->get();
        $rank = []; 
   
         

            $rank = DB::table('donation_person_sub')
            ->select(DB::raw('sum(donation_person_sub.PERSON_DONATE_SUB_PRICE) as sum'),'DONATE_PERSON_NAME')
            ->leftJoin('donation_person', 'donation_person.DONATE_PERSON_ID', '=', 'donation_person_sub.DONATE_PERSON_ID')
            ->groupBy('donation_person.DONATE_PERSON_NAME')
            ->orderBy('sum','desc')
           ->where('donation_person_sub.PERSON_DONATE_SUB_DATE','like',$year.'%')
    
            ->limit(2)
            ->get();

          

       
         
            return view('manager_crm.dashboard_crm',[
                'amount_1' => $amount_1,
                'amount_2' => $amount_2,
                'amount_3' => $amount_3,
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
                'budgets' =>  $budget,
                'year_id'=>$year_id ,
                'ranks'=>$ranks,
                'rank'=>$rank,
                
    
    
                ]);


    }


    
    public function dashboardsearch(Request $request)
    {
        $year_id = $request->STATUS_CODE;
        $year = $year_id -543;
        $amount_1 = DB::table('donation_person')->where('DONATE_PERSON_DATE','like',$year.'%')->count();
        $amount_2 = DB::table('donation_person_sub')->where('PERSON_DONATE_SUB_DATE','like',$year.'%')->sum('PERSON_DONATE_SUB_PRICE');
        $amount_3 = DB::table('donation_person_sub')->where('PERSON_DONATE_SUB_DATE','like',$year.'%')->count();
    

        $m1_1 = DB::table('donation_person_sub')->where('PERSON_DONATE_SUB_DATE','like',$year.'-01%')->sum('PERSON_DONATE_SUB_PRICE');
        $m2_1 = DB::table('donation_person_sub')->where('PERSON_DONATE_SUB_DATE','like',$year.'-02%')->sum('PERSON_DONATE_SUB_PRICE');
        $m3_1 = DB::table('donation_person_sub')->where('PERSON_DONATE_SUB_DATE','like',$year.'-03%')->sum('PERSON_DONATE_SUB_PRICE');
        $m4_1 = DB::table('donation_person_sub')->where('PERSON_DONATE_SUB_DATE','like',$year.'-04%')->sum('PERSON_DONATE_SUB_PRICE');
        $m5_1 = DB::table('donation_person_sub')->where('PERSON_DONATE_SUB_DATE','like',$year.'-05%')->sum('PERSON_DONATE_SUB_PRICE');
        $m6_1 = DB::table('donation_person_sub')->where('PERSON_DONATE_SUB_DATE','like',$year.'-06%')->sum('PERSON_DONATE_SUB_PRICE');
        $m7_1 = DB::table('donation_person_sub')->where('PERSON_DONATE_SUB_DATE','like',$year.'-07%')->sum('PERSON_DONATE_SUB_PRICE');
        $m8_1 = DB::table('donation_person_sub')->where('PERSON_DONATE_SUB_DATE','like',$year.'-08%')->sum('PERSON_DONATE_SUB_PRICE');
        $m9_1 = DB::table('donation_person_sub')->where('PERSON_DONATE_SUB_DATE','like',$year.'-09%')->sum('PERSON_DONATE_SUB_PRICE');
        $m10_1 = DB::table('donation_person_sub')->where('PERSON_DONATE_SUB_DATE','like',$year.'-10%')->sum('PERSON_DONATE_SUB_PRICE');
        $m11_1 = DB::table('donation_person_sub')->where('PERSON_DONATE_SUB_DATE','like',$year.'-11%')->sum('PERSON_DONATE_SUB_PRICE');
        $m12_1 = DB::table('donation_person_sub')->where('PERSON_DONATE_SUB_DATE','like',$year.'-12%')->sum('PERSON_DONATE_SUB_PRICE');


        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();


        $ranks = DB::table('donation_person_sub')
        ->select(DB::raw('sum(donation_person_sub.PERSON_DONATE_SUB_PRICE) as sum'),'DONATE_PERSON_NAME')
        ->leftJoin('donation_person', 'donation_person.DONATE_PERSON_ID', '=', 'donation_person_sub.DONATE_PERSON_ID')
        ->groupBy('donation_person.DONATE_PERSON_NAME')
        ->orderBy('sum','desc')
        ->where('donation_person_sub.PERSON_DONATE_SUB_DATE','like',$year.'%')
        ->limit(5)
        ->get();

        $rank = array(); 
   
         

            $rank = DB::table('donation_person_sub')
            ->select(DB::raw('sum(donation_person_sub.PERSON_DONATE_SUB_PRICE) as sum'),'DONATE_PERSON_NAME')
            ->leftJoin('donation_person', 'donation_person.DONATE_PERSON_ID', '=', 'donation_person_sub.DONATE_PERSON_ID')
            ->groupBy('donation_person.DONATE_PERSON_NAME')
            ->orderBy('sum','desc')
           ->where('donation_person_sub.PERSON_DONATE_SUB_DATE','like',$year.'%')
    
            ->limit(2)
            ->get();



        return view('manager_crm.dashboard_crm',[
            'amount_1' => $amount_1,
            'amount_2' => $amount_2,
            'amount_3' => $amount_3,
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
            'budgets' =>  $budget,
            'year_id'=>$year_id ,
            'ranks'=>$ranks,
            'rank'=>$rank,
            ]);
    }




    public function persondonate(Request $request)
    {    
        if($request->method() === 'POST'){
            $search = $request->get('search');
            $status = $request->SEND_STATUS;
            $datebigin = $request->get('DATE_BIGIN');
            $dateend = $request->get('DATE_END');
            $data_search = json_encode_u([
                'search' => $search,
                'datebigin' => $datebigin,
                'dateend' => $dateend,
                'status' => $status,
            ]);
            Cookie::queue('data_search', $data_search, 120,$request->server('REQUEST_URI'));
        }elseif(!empty(Cookie::get('data_search'))){
            $data_search    = json_decode(Cookie::get('data_search'));
            $search     = $data_search->search;
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
        $from = date($displaydate_bigen);
        $to = date($displaydate_end);
        if($status == null){
            $donateinfoperson = Donateperson::leftjoin('donation_status','donation_person.DONATE_PERSON_STATUS','=','donation_status.DONATE_STATUS_NAME')
                ->leftjoin('hrd_person','hrd_person.ID','=','donation_person.DONATE_PERSON_USER_ID')
                ->leftjoin('hrd_province','hrd_province.ID','=','donation_person.DONATE_PERSON_PROVINCE')
                ->leftjoin('hrd_amphur','hrd_amphur.ID','=','donation_person.DONATE_PERSON_AMPHER')
                ->leftjoin('hrd_tumbon','hrd_tumbon.ID','=','donation_person.DONATE_PERSON_TUMBON')
                ->where(function($q) use ($search){
                    $q->where('DONATE_PERSON_NAME','like','%'.$search.'%');
                    $q->orwhere('DONATE_PERSON_TEL','like','%'.$search.'%');
                    $q->orwhere('DONATE_PERSON_EMAIL','like','%'.$search.'%');
                    $q->orwhere('DONATE_PERSON_LINE','like','%'.$search.'%');
                    $q->orwhere('DONATE_PERSON_VAT_NO','like','%'.$search.'%');
                })
                ->WhereBetween('DONATE_PERSON_DATE',[$from,$to]) 
                ->orderBy('donation_person.DONATE_PERSON_DATE', 'desc')->get();
        }else{
            $donateinfoperson = Donateperson::leftjoin('donation_status','donation_person.DONATE_PERSON_STATUS','=','donation_status.DONATE_STATUS_NAME')
            ->leftjoin('hrd_person','hrd_person.ID','=','donation_person.DONATE_PERSON_USER_ID') 
            ->leftjoin('hrd_province','hrd_province.ID','=','donation_person.DONATE_PERSON_PROVINCE')
            ->leftjoin('hrd_amphur','hrd_amphur.ID','=','donation_person.DONATE_PERSON_AMPHER')
            ->leftjoin('hrd_tumbon','hrd_tumbon.ID','=','donation_person.DONATE_PERSON_TUMBON')
                ->where('PERSON_DONATE_SUB_WEALTH_ID','=',$status)                
                ->where(function($q) use ($search){
                    $q->where('DONATE_PERSON_NAME','like','%'.$search.'%');
                    $q->orwhere('DONATE_PERSON_TEL','like','%'.$search.'%');
                    $q->orwhere('DONATE_PERSON_EMAIL','like','%'.$search.'%');
                    $q->orwhere('DONATE_PERSON_LINE','like','%'.$search.'%');
                    $q->orwhere('DONATE_PERSON_VAT_NO','like','%'.$search.'%');
                })
                ->WhereBetween('DONATE_PERSON_DATE',[$from,$to]) 
                ->orderBy('donation_person.DONATE_PERSON_DATE', 'desc')->get();      
        }
        $donatestatus = DB::table('donation_status')->get();
        return view('manager_crm.persondonate',[           
            'donateinfopersons' => $donateinfoperson,
            'donatestatuss'=>$donatestatus,          
            'status_check'=> $status,
            'search'=> $search,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,            
        ]);
    }


    public function persondonatesearch(Request $request)
    { 

        $search = $request->get('search');
        $status = $request->SEND_STATUS;
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
        $date_bigen_checks = strtotime($displaydate_bigen);
        $date_end_checks =  strtotime($displaydate_end);
        $dates =  strtotime($date);
    
        $from = date($displaydate_bigen);
        $to = date($displaydate_end);
    
        if($status == null){
    
            $donateinfoperson = Donateperson::leftjoin('donation_status','donation_person.DONATE_PERSON_STATUS','=','donation_status.DONATE_STATUS_NAME')
                ->leftjoin('hrd_person','hrd_person.ID','=','donation_person.DONATE_PERSON_USER_ID')
                ->leftjoin('hrd_province','hrd_province.ID','=','donation_person.DONATE_PERSON_PROVINCE')
                ->leftjoin('hrd_amphur','hrd_amphur.ID','=','donation_person.DONATE_PERSON_AMPHER')
                ->leftjoin('hrd_tumbon','hrd_tumbon.ID','=','donation_person.DONATE_PERSON_TUMBON')
                ->where(function($q) use ($search){
                    $q->where('DONATE_PERSON_NAME','like','%'.$search.'%');
                    $q->orwhere('DONATE_PERSON_TEL','like','%'.$search.'%');
                    $q->orwhere('DONATE_PERSON_EMAIL','like','%'.$search.'%');
                    $q->orwhere('DONATE_PERSON_LINE','like','%'.$search.'%');
                    $q->orwhere('DONATE_PERSON_VAT_NO','like','%'.$search.'%');
                })
                ->WhereBetween('DONATE_PERSON_DATE',[$from,$to]) 
                ->orderBy('donation_person.DONATE_PERSON_DATE', 'desc')->get();
        
        }else{
    
            $donateinfoperson = Donateperson::leftjoin('donation_status','donation_person.DONATE_PERSON_STATUS','=','donation_status.DONATE_STATUS_NAME')
            ->leftjoin('hrd_person','hrd_person.ID','=','donation_person.DONATE_PERSON_USER_ID') 
            ->leftjoin('hrd_province','hrd_province.ID','=','donation_person.DONATE_PERSON_PROVINCE')
            ->leftjoin('hrd_amphur','hrd_amphur.ID','=','donation_person.DONATE_PERSON_AMPHER')
            ->leftjoin('hrd_tumbon','hrd_tumbon.ID','=','donation_person.DONATE_PERSON_TUMBON')
                ->where('PERSON_DONATE_SUB_WEALTH_ID','=',$status)                
                ->where(function($q) use ($search){
                    $q->where('DONATE_PERSON_NAME','like','%'.$search.'%');
                    $q->orwhere('DONATE_PERSON_TEL','like','%'.$search.'%');
                    $q->orwhere('DONATE_PERSON_EMAIL','like','%'.$search.'%');
                    $q->orwhere('DONATE_PERSON_LINE','like','%'.$search.'%');
                    $q->orwhere('DONATE_PERSON_VAT_NO','like','%'.$search.'%');
                })
                ->WhereBetween('DONATE_PERSON_DATE',[$from,$to]) 
                ->orderBy('donation_person.DONATE_PERSON_DATE', 'desc')->get();      
        }

        $donatestatus = DB::table('donation_status')->get();
       
        return view('manager_crm.persondonate',[           
            'donateinfopersons' => $donateinfoperson,
            'donatestatuss'=>$donatestatus,          
            'status_check'=> $status,
            'search'=> $search,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,            

        ]);
    }

    public function persondonate_add()
    {    
        $infoprovince =  DB::table('hrd_province')->get();
        return view('manager_crm.persondonate_add',[
            'infoprovinces' => $infoprovince,
        ]);
    }
    public function persondonate_save(Request $request)
    {    
        $datebigin = $request->get('DONATE_PERSON_DATE');

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


        $datebirth = $request->get('DONATE_BIRTH_DATE');
        $date_birth_s = Carbon::createFromFormat('d/m/Y', $datebirth)->format('Y-m-d');
        $date_arrary=explode("-",$date_birth_s);    
        $y_sub_st = $date_arrary[0];    
        if($y_sub_st >= 2500){
            $y = $y_sub_st-543;
        }else{
            $y = $y_sub_st;
        }    
        $m = $date_arrary[1];
        $d = $date_arrary[2];  
        $btrthday= $y."-".$m."-".$d;


        $add= new Donateperson();
        $add->DONATE_PERSON_NAME = $request->DONATE_PERSON_NAME;
        $add->DONATE_PERSON_TEL = $request->DONATE_PERSON_TEL;
        $add->DONATE_PERSON_CID = $request->DONATE_PERSON_CID;
        $add->DONATE_BIRTH_DATE = $btrthday;
        $add->DONATE_PERSON_EMAIL = $request->DONATE_PERSON_EMAIL;
        $add->DONATE_PERSON_LINE = $request->DONATE_PERSON_LINE;
        $add->DONATE_PERSON_VAT_NO = $request->DONATE_PERSON_VAT_NO;
        $add->DONATE_PERSON_NO_HOME = $request->DONATE_PERSON_NO_HOME;
        $add->DONATE_PERSON_ROAD = $request->DONATE_PERSON_ROAD;
        $add->DONATE_PERSON_MOO = $request->DONATE_PERSON_MOO;
        $add->DONATE_PERSON_BAN = $request->DONATE_PERSON_BAN;
        $add->DONATE_PERSON_TUMBON = $request->DONATE_PERSON_TUMBON;
        $add->DONATE_PERSON_AMPHER = $request->DONATE_PERSON_AMPHER;
        $add->DONATE_PERSON_PROVINCE = $request->DONATE_PERSON_PROVINCE;
        $add->DONATE_PERSON_POST = $request->DONATE_PERSON_POST;
        $add->DONATE_PERSON_USER_ID = $request->DONATE_PERSON_USER_ID;
        $add->DONATE_PERSON_DATE = $displaydate_bigen;
        $add->DONATE_PERSON_STATUS = 'NORMAL';
        $add->save();


        return redirect()->route('mcrm.persondonate');
    }
    public function persondonate_edit(Request $request,$id)
    {
        $id_in= $id;
        $donateinfoperson = Donateperson::leftjoin('hrd_person','hrd_person.ID','=','donation_person.DONATE_PERSON_USER_ID')
        ->leftjoin('hrd_amphur','hrd_amphur.ID','=','donation_person.DONATE_PERSON_AMPHER')
        ->leftjoin('hrd_tumbon','hrd_tumbon.ID','=','donation_person.DONATE_PERSON_TUMBON')
        ->where('DONATE_PERSON_ID','=',$id_in)->first();


        $infoprovince =  DB::table('hrd_province')->get();

        return view('manager_crm.persondonate_edit',[
            'donateinfopersons' => $donateinfoperson,
            'infoprovinces' => $infoprovince
         
        ]);
    }
    public function persondonate_update(Request $request)
    {
        $datebigin = $request->get('DONATE_PERSON_DATE');
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


        $datebirth = $request->get('DONATE_BIRTH_DATE');
        $date_birth = Carbon::createFromFormat('d/m/Y', $datebirth)->format('Y-m-d');
        $date_arrary=explode("-",$date_birth);    
        $y_sub_st = $date_arrary[0];    
        if($y_sub_st >= 2500){
            $y = $y_sub_st-543;
        }else{
            $y = $y_sub_st;
        }    
        $m = $date_arrary[1];
        $d = $date_arrary[2];  
        $DONATE_BIRTH_DATE= $y."-".$m."-".$d;

        $id = $request->DONATE_PERSON_ID;
        $update = Donateperson::find($id);
        $update->DONATE_PERSON_NAME = $request->DONATE_PERSON_NAME;
        $update->DONATE_PERSON_TEL = $request->DONATE_PERSON_TEL;
        $update->DONATE_PERSON_CID = $request->DONATE_PERSON_CID;
        $update->DONATE_BIRTH_DATE = $DONATE_BIRTH_DATE;
        $update->DONATE_PERSON_EMAIL = $request->DONATE_PERSON_EMAIL;
        $update->DONATE_PERSON_LINE = $request->DONATE_PERSON_LINE;
        $update->DONATE_PERSON_VAT_NO = $request->DONATE_PERSON_VAT_NO;
        $update->DONATE_PERSON_NO_HOME = $request->DONATE_PERSON_NO_HOME;
        $update->DONATE_PERSON_ROAD = $request->DONATE_PERSON_ROAD;
        $update->DONATE_PERSON_MOO = $request->DONATE_PERSON_MOO;
        $update->DONATE_PERSON_BAN = $request->DONATE_PERSON_BAN;
        $update->DONATE_PERSON_TUMBON = $request->DONATE_PERSON_TUMBON;
        $update->DONATE_PERSON_AMPHER = $request->DONATE_PERSON_AMPHER;
        $update->DONATE_PERSON_PROVINCE = $request->DONATE_PERSON_PROVINCE;
        $update->DONATE_PERSON_POST = $request->DONATE_PERSON_POST; 
        $update->DONATE_PERSON_USER_ID = $request->DONATE_PERSON_USER_ID;
        $update->DONATE_PERSON_DATE = $displaydate_bigen;
        $update->save();
        // Toastr::success('แก้ไขข้อมูลสำเร็จ');

        return redirect()->route('mcrm.persondonate');
    }
    public function persondonate_cancel(Request $request,$id)
    {
        $donateinfoperson = Donateperson::leftjoin('hrd_person','hrd_person.ID','=','donation_person.DONATE_PERSON_USER_ID')
        ->where('DONATE_PERSON_ID','=',$id)->first();

        return view('manager_crm.persondonate_cancel',[
            'donateinfopersons' => $donateinfoperson
        ]);
    }

    public function persondonate_savecancel(Request $request)
    {
        $id = $request->DONATE_PERSON_ID; 
        $updatecan = Donateperson::find($id);
        $updatecan->DONATE_PERSON_STATUS = 'CANCEL'; 
        $updatecan->save();    
       
          return redirect()->route('mcrm.persondonate');    
    }
//==============sub=====================//
    public function detaildonate(Request $request,$id)
    {    

        $donateinfoperson = Donateperson::leftjoin('hrd_person','hrd_person.ID','=','donation_person.DONATE_PERSON_USER_ID')->where('DONATE_PERSON_ID','=',$id)->first();
        $donatedetail = Donateperson_sub::leftjoin('donation_unit','donation_person_sub.PERSON_DONATE_SUB_ID','=','donation_unit.DONATIONUNIT_ID')
        ->leftjoin('donation_wealth','donation_person_sub.PERSON_DONATE_SUB_WEALTH_ID','=','donation_wealth.DONATIONWEALTH_ID')
        ->where('DONATE_PERSON_ID','=',$id)
        ->get();
        
        return view('manager_crm.detaildonate',[
            'donateinfopersons' => $donateinfoperson,
            'donatedetails'=>$donatedetail
        ]);
    }
    public function detaildonate_add(Request $request,$id)
    {    
        $donateinfoperson = Donateperson::leftjoin('hrd_person','hrd_person.ID','=','donation_person.DONATE_PERSON_USER_ID')->where('DONATE_PERSON_ID','=',$id)->first();
        $donateunit = Donationunit::get();
        $donatiwealth =Donationwealth::get();
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $donatfund = DB::table('donation_fund')->get();

        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;
        }

        $maxnum = Donateperson_sub::max('PERSON_DONATE_SUB_NO');
        if($maxnum != '' ||  $maxnum != null){
         $refmax = Donateperson_sub::where('PERSON_DONATE_SUB_NO','=',$maxnum)->first();

         if($refmax->PERSON_DONATE_SUB_NO != '' ||  $refmax->PERSON_DONATE_SUB_NO != null){
         $maxpo = substr($refmax->PERSON_DONATE_SUB_NO, -2)+1;
         }else{
         $maxref = 1;
         }
         $refe = str_pad($maxpo, 5, "0", STR_PAD_LEFT);
         }else{
        $refe = '00001';
         }
         $y = substr($yearbudget, -2); 
         $billNo = 'DN-'.$y.''.$refe;

         $maxnum2 = Donateperson_sub::max('PERSON_DONATE_SUB_BOOKNO');
         if($maxnum2 != '' ||  $maxnum2 != null){
          $refmax2 = Donateperson_sub::where('PERSON_DONATE_SUB_BOOKNO','=',$maxnum2)->first();
         if($refmax2->PERSON_DONATE_SUB_BOOKNO != '' ||  $refmax2->PERSON_DONATE_SUB_BOOKNO != null){
            $maxpo2 = substr($refmax2->PERSON_DONATE_SUB_BOOKNO, -2)+1;
            }else{
            $maxref2 = 1;
            }
            $refe2 = str_pad($maxpo2, 5, "0", STR_PAD_LEFT);
            }else{
           $refe2 = '00001';
            }
            $subNo = $refe2;


        return view('manager_crm.detaildonate_add',[
            'billNos'=>$billNo,
            'subNo'=>$subNo,
            'donateinfopersons'=>$donateinfoperson,
            'donateunits'=>$donateunit,
            'donatiwealths'=>$donatiwealth,
            'donatfunds'=>$donatfund,
            'budgets'=>$budget
        ]);
    }

 public function detaildonate_save(Request $request)
    {    
        $PERSON_DONATE_SUB_DATE = $request->PERSON_DONATE_SUB_DATE;  
        $id = $request->DONATE_PERSON_ID; 

        if($PERSON_DONATE_SUB_DATE != ''){
         $STARTDAY = Carbon::createFromFormat('d/m/Y', $PERSON_DONATE_SUB_DATE)->format('Y-m-d');
         $date_arrary_st=explode("-",$STARTDAY);  
         $y_sub_st = $date_arrary_st[0]; 
         
         if($y_sub_st >= 2500){
             $y_st = $y_sub_st-543;
         }else{
             $y_st = $y_sub_st;
         }
         $m_st = $date_arrary_st[1];
         $d_st = $date_arrary_st[2];  
         $PERSON_DONATE_SUB_DATE= $y_st."-".$m_st."-".$d_st;
         }else{
         $PERSON_DONATE_SUB_DATE= null;
     }

        
        $add= new Donateperson_sub();
        $add->DONATE_PERSON_ID = $request->DONATE_PERSON_ID;
        $add->PERSON_DONATE_SUB_FUND = $request->PERSON_DONATE_SUB_FUND;
        $add->PERSON_DONATE_SUB_BOOKNO = $request->PERSON_DONATE_SUB_BOOKNO;
        $add->PERSON_DONATE_SUB_NO = $request->PERSON_DONATE_SUB_NO;
        $add->PERSON_DONATE_SUB_YEAR = $request->PERSON_DONATE_SUB_YEAR;
        $add->PERSON_DONATE_SUB_WORK = $request->PERSON_DONATE_SUB_WORK;
        $add->PERSON_DONATE_SUB_WEALTH_ID = $request->PERSON_DONATE_SUB_WEALTH_ID;
        $add->PERSON_DONATE_SUB_DATE = $PERSON_DONATE_SUB_DATE;
        $add->PERSON_DONATE_SUB_COMENT = $request->PERSON_DONATE_SUB_COMENT;
        $add->PERSON_DONATE_SUB_DETAIL =$request->PERSON_DONATE_SUB_DETAIL;
        $add->PERSON_DONATE_SUB_QTY = $request->PERSON_DONATE_SUB_QTY;
        $add->PERSON_DONATE_SUB_UNIT_ID = $request->PERSON_DONATE_SUB_UNIT_ID;
        $add->PERSON_DONATE_SUB_PRICE = $request->PERSON_DONATE_SUB_PRICE;       
        $add->save();

        return redirect()->route('mcrm.detaildonate',['id'=>  $id]);
    }

    public function detaildonate_edit(Request $request,$id,$idref)
    {
        $donateinfoperson = Donateperson::where('DONATE_PERSON_ID','=',$idref)->first();       
        $donateinfopersonsub = Donateperson_sub::where('PERSON_DONATE_SUB_ID','=',$id)->first(); 
                 
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $donateunit = Donationunit::get();
        $donatiwealth =Donationwealth::get();
        $donatfund = DB::table('donation_fund')->get();

        return view('manager_crm.detaildonate_edit',[
            'donateinfopersons' => $donateinfoperson,
            'donateinfopersonsubs'=>$donateinfopersonsub,
            'budgets'=>$budget,
            'donateunits'=>$donateunit,
            'donatiwealths'=>$donatiwealth,
            'donatfunds'=>$donatfund,
            'IDREF' => $id,
        ]);
    }

    public function detaildonate_update(Request $request)
    {
        $id = $request->DONATE_PERSON_ID;
        $idref = $request->PERSON_DONATE_SUB_ID;
        $PERSON_DONATE_SUB_DATE = $request->PERSON_DONATE_SUB_DATE;  

        if($PERSON_DONATE_SUB_DATE != ''){
         $STARTDAY = Carbon::createFromFormat('d/m/Y', $PERSON_DONATE_SUB_DATE)->format('Y-m-d');
         $date_arrary_st=explode("-",$STARTDAY);  
         $y_sub_st = $date_arrary_st[0]; 
         
         if($y_sub_st >= 2500){
             $y_st = $y_sub_st-543;
         }else{
             $y_st = $y_sub_st;
         }
         $m_st = $date_arrary_st[1];
         $d_st = $date_arrary_st[2];  
         $PERSON_DONATE_SUBDATE= $y_st."-".$m_st."-".$d_st;
         }else{
         $PERSON_DONATE_SUBDATE= null;
     }
        $update = Donateperson_sub::find($idref);
        $update->DONATE_PERSON_ID = $id;
        $update->PERSON_DONATE_SUB_FUND = $request->PERSON_DONATE_SUB_FUND;
        $update->PERSON_DONATE_SUB_BOOKNO = $request->PERSON_DONATE_SUB_BOOKNO;
        $update->PERSON_DONATE_SUB_NO = $request->PERSON_DONATE_SUB_NO;
        $update->PERSON_DONATE_SUB_YEAR = $request->PERSON_DONATE_SUB_YEAR;
        $update->PERSON_DONATE_SUB_WORK = $request->PERSON_DONATE_SUB_WORK;
        $update->PERSON_DONATE_SUB_WEALTH_ID = $request->PERSON_DONATE_SUB_WEALTH_ID;

        $update->PERSON_DONATE_SUB_DATE = $PERSON_DONATE_SUBDATE;

        $update->PERSON_DONATE_SUB_COMENT = $request->PERSON_DONATE_SUB_COMENT;
        $update->PERSON_DONATE_SUB_DETAIL = $request->PERSON_DONATE_SUB_DETAIL;
        $update->PERSON_DONATE_SUB_QTY = $request->PERSON_DONATE_SUB_QTY;
        $update->PERSON_DONATE_SUB_UNIT_ID = $request->PERSON_DONATE_SUB_UNIT_ID;
        $update->PERSON_DONATE_SUB_PRICE = $request->PERSON_DONATE_SUB_PRICE;
        $update->save();
     
        return redirect()->route('mcrm.detaildonate',['id'=>  $id]);
    }
    public function detaildonate_destroy(Request $request,$idref, $id)
    {
         Donateperson_sub::destroy($idref);
  
         return redirect()->route('mcrm.detaildonate',['id'=>  $id]);

    }
    public function persondonate_list(Request $request)
    {
        if($request->method() === 'POST'){
            $search = $request->get('search');
            $status = $request->SEND_STATUS;
            $datebigin = $request->get('DATE_BIGIN');
            $dateend = $request->get('DATE_END');
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
        $from = date($displaydate_bigen);
        $to = date($displaydate_end);
        if($status == null){
                $donatedetail_list = Donateperson_sub::leftjoin('donation_unit','donation_person_sub.PERSON_DONATE_SUB_ID','=','donation_unit.DONATIONUNIT_ID')
                ->leftjoin('donation_person','donation_person_sub.DONATE_PERSON_ID','=','donation_person.DONATE_PERSON_ID')
                ->leftjoin('donation_wealth','donation_person_sub.PERSON_DONATE_SUB_WEALTH_ID','=','donation_wealth.DONATIONWEALTH_ID')
                ->where('PERSON_DONATE_SUB_YEAR','=',$yearbudget)    
                ->where(function($q) use ($search){
                    $q->where('PERSON_DONATE_SUB_BOOKNO','like','%'.$search.'%');
                    $q->orwhere('PERSON_DONATE_SUB_NO','like','%'.$search.'%');
                    $q->orwhere('PERSON_DONATE_SUB_WORK','like','%'.$search.'%'); 
                    $q->orwhere('PERSON_DONATE_SUB_COMENT','like','%'.$search.'%');  
                    $q->orwhere('PERSON_DONATE_SUB_DETAIL','like','%'.$search.'%');   
                    $q->orwhere('PERSON_DONATE_SUB_PRICE','like','%'.$search.'%');   
                })
                ->WhereBetween('PERSON_DONATE_SUB_DATE',[$from,$to]) 
                ->orderBy('PERSON_DONATE_SUB_ID', 'desc')->get();
                $counttotal = Donateperson_sub::leftjoin('donation_unit','donation_person_sub.PERSON_DONATE_SUB_ID','=','donation_unit.DONATIONUNIT_ID')
                ->leftjoin('donation_person','donation_person_sub.DONATE_PERSON_ID','=','donation_person.DONATE_PERSON_ID')
                ->leftjoin('donation_wealth','donation_person_sub.PERSON_DONATE_SUB_WEALTH_ID','=','donation_wealth.DONATIONWEALTH_ID')
                ->where('PERSON_DONATE_SUB_YEAR','=',$yearbudget)    
                ->where(function($q) use ($search){
                    $q->where('PERSON_DONATE_SUB_BOOKNO','like','%'.$search.'%');
                    $q->orwhere('PERSON_DONATE_SUB_NO','like','%'.$search.'%');
                    $q->orwhere('PERSON_DONATE_SUB_WORK','like','%'.$search.'%'); 
                    $q->orwhere('PERSON_DONATE_SUB_COMENT','like','%'.$search.'%');  
                    $q->orwhere('PERSON_DONATE_SUB_DETAIL','like','%'.$search.'%');   
                    $q->orwhere('PERSON_DONATE_SUB_PRICE','like','%'.$search.'%');   
                })
                ->WhereBetween('PERSON_DONATE_SUB_DATE',[$from,$to]) 
                ->orderBy('PERSON_DONATE_SUB_ID', 'desc')->count();
                $sumpice = Donateperson_sub::leftjoin('donation_unit','donation_person_sub.PERSON_DONATE_SUB_ID','=','donation_unit.DONATIONUNIT_ID')
                ->leftjoin('donation_person','donation_person_sub.DONATE_PERSON_ID','=','donation_person.DONATE_PERSON_ID')
                ->leftjoin('donation_wealth','donation_person_sub.PERSON_DONATE_SUB_WEALTH_ID','=','donation_wealth.DONATIONWEALTH_ID')
                ->where('PERSON_DONATE_SUB_YEAR','=',$yearbudget)    
                ->where(function($q) use ($search){
                    $q->where('PERSON_DONATE_SUB_BOOKNO','like','%'.$search.'%');
                    $q->orwhere('PERSON_DONATE_SUB_NO','like','%'.$search.'%');
                    $q->orwhere('PERSON_DONATE_SUB_WORK','like','%'.$search.'%'); 
                    $q->orwhere('PERSON_DONATE_SUB_COMENT','like','%'.$search.'%');  
                    $q->orwhere('PERSON_DONATE_SUB_DETAIL','like','%'.$search.'%');   
                    $q->orwhere('PERSON_DONATE_SUB_PRICE','like','%'.$search.'%');   
                })
                ->WhereBetween('PERSON_DONATE_SUB_DATE',[$from,$to]) 
                ->orderBy('PERSON_DONATE_SUB_ID', 'desc')->sum('PERSON_DONATE_SUB_PRICE');
        }else{
                $donatedetail_list = Donateperson_sub::leftjoin('donation_unit','donation_person_sub.PERSON_DONATE_SUB_ID','=','donation_unit.DONATIONUNIT_ID')
                ->leftjoin('donation_person','donation_person_sub.DONATE_PERSON_ID','=','donation_person.DONATE_PERSON_ID')
                ->leftjoin('donation_wealth','donation_person_sub.PERSON_DONATE_SUB_WEALTH_ID','=','donation_wealth.DONATIONWEALTH_ID')
                ->where('PERSON_DONATE_SUB_WEALTH_ID','=',$status)
                ->where('PERSON_DONATE_SUB_YEAR','=',$yearbudget)    
                ->where(function($q) use ($search){
                    $q->where('PERSON_DONATE_SUB_BOOKNO','like','%'.$search.'%');
                    $q->orwhere('PERSON_DONATE_SUB_NO','like','%'.$search.'%');
                    $q->orwhere('PERSON_DONATE_SUB_WORK','like','%'.$search.'%'); 
                    $q->orwhere('PERSON_DONATE_SUB_COMENT','like','%'.$search.'%');  
                    $q->orwhere('PERSON_DONATE_SUB_DETAIL','like','%'.$search.'%');   
                    $q->orwhere('PERSON_DONATE_SUB_PRICE','like','%'.$search.'%');
                })
                ->WhereBetween('PERSON_DONATE_SUB_DATE',[$from,$to]) 
                ->orderBy('PERSON_DONATE_SUB_ID', 'desc')->get();   
                
                $counttotal = Donateperson_sub::leftjoin('donation_unit','donation_person_sub.PERSON_DONATE_SUB_ID','=','donation_unit.DONATIONUNIT_ID')
                ->leftjoin('donation_person','donation_person_sub.DONATE_PERSON_ID','=','donation_person.DONATE_PERSON_ID')
                ->leftjoin('donation_wealth','donation_person_sub.PERSON_DONATE_SUB_WEALTH_ID','=','donation_wealth.DONATIONWEALTH_ID')
                ->where('PERSON_DONATE_SUB_WEALTH_ID','=',$status)
                ->where('PERSON_DONATE_SUB_YEAR','=',$yearbudget)    
                ->where(function($q) use ($search){
                    $q->where('PERSON_DONATE_SUB_BOOKNO','like','%'.$search.'%');
                    $q->orwhere('PERSON_DONATE_SUB_NO','like','%'.$search.'%');
                    $q->orwhere('PERSON_DONATE_SUB_WORK','like','%'.$search.'%'); 
                    $q->orwhere('PERSON_DONATE_SUB_COMENT','like','%'.$search.'%');  
                    $q->orwhere('PERSON_DONATE_SUB_DETAIL','like','%'.$search.'%');   
                    $q->orwhere('PERSON_DONATE_SUB_PRICE','like','%'.$search.'%');
                })
                ->WhereBetween('PERSON_DONATE_SUB_DATE',[$from,$to]) 
                ->orderBy('PERSON_DONATE_SUB_ID', 'desc')->count();   
                $sumpice = Donateperson_sub::leftjoin('donation_unit','donation_person_sub.PERSON_DONATE_SUB_ID','=','donation_unit.DONATIONUNIT_ID')
                ->leftjoin('donation_person','donation_person_sub.DONATE_PERSON_ID','=','donation_person.DONATE_PERSON_ID')
                ->leftjoin('donation_wealth','donation_person_sub.PERSON_DONATE_SUB_WEALTH_ID','=','donation_wealth.DONATIONWEALTH_ID')
                ->where('PERSON_DONATE_SUB_WEALTH_ID','=',$status)
                ->where('PERSON_DONATE_SUB_YEAR','=',$yearbudget)    
                ->where(function($q) use ($search){
                    $q->where('PERSON_DONATE_SUB_BOOKNO','like','%'.$search.'%');
                    $q->orwhere('PERSON_DONATE_SUB_NO','like','%'.$search.'%');
                    $q->orwhere('PERSON_DONATE_SUB_WORK','like','%'.$search.'%'); 
                    $q->orwhere('PERSON_DONATE_SUB_COMENT','like','%'.$search.'%');  
                    $q->orwhere('PERSON_DONATE_SUB_DETAIL','like','%'.$search.'%');   
                    $q->orwhere('PERSON_DONATE_SUB_PRICE','like','%'.$search.'%');
                })
                ->WhereBetween('PERSON_DONATE_SUB_DATE',[$from,$to]) 
                ->orderBy('PERSON_DONATE_SUB_ID', 'desc')->sum('PERSON_DONATE_SUB_PRICE');  
        }
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $type_check = DB::table('donation_wealth')->get();

        $openform_function = Donateopenform::where('OPENFORM_STATUS','=','True' )->first();


        if ($openform_function != '') {
       
            $code = $openform_function->OPENFORM_CODE;      

        } else {                      
            $code = '';
        }
       

        return view('manager_crm.persondonate_list',[
            'donatedetail_lists' =>$donatedetail_list,
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$yearbudget,
            'counttotal'=>$counttotal,
            'sumpice'=>$sumpice,
            'type_checks'=>$type_check,
            'openform_functions'=>$openform_function,
            'codes'=>$code,
        ]);

    }

    public function persondonate_list_edit(Request $request,$id)
    {           
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $donateunit = Donationunit::get();
        $donatiwealth =Donationwealth::get();
        $donatfund = DB::table('donation_fund')->get();

      
        $donateinfopersonsubs = Donateperson_sub::leftjoin('donation_unit','donation_person_sub.PERSON_DONATE_SUB_ID','=','donation_unit.DONATIONUNIT_ID')
        ->leftjoin('donation_wealth','donation_person_sub.PERSON_DONATE_SUB_WEALTH_ID','=','donation_wealth.DONATIONWEALTH_ID')
        ->where('PERSON_DONATE_SUB_ID','=',$id)
        ->first();

        $donateinfopersons = Donateperson::where('DONATE_PERSON_ID','=',$donateinfopersonsubs->DONATE_PERSON_ID )->first();

        return view('manager_crm.persondonate_list_edit',[
            'donateinfopersons'=>$donateinfopersons,
            'donateinfopersonsubs'=>$donateinfopersonsubs,
            'budgets' =>  $budget,
            'donateunits' =>  $donateunit,
            'donatiwealths' =>  $donatiwealth,
            'donatfunds' =>  $donatfund,
        ]);

    }

public function persondonate_list_update(Request $request)
{
    $id = $request->DONATE_PERSON_ID;
    $datesub = $request->get('PERSON_DONATE_SUB_DATE');

    $date_sub_c = Carbon::createFromFormat('d/m/Y', $datesub)->format('Y-m-d');
    $date_arrary=explode("-",$date_sub_c);
    $y_sub_st = $date_arrary[0];
    if($y_sub_st >= 2500){
        $y = $y_sub_st-543;
    }else{
        $y = $y_sub_st;
    }
    $m = $date_arrary[1];
    $d = $date_arrary[2];  
    $date_sub= $y."-".$m."-".$d;

    $update = Donateperson_sub::find($id);
    $update->PERSON_DONATE_SUB_FUND = $request->PERSON_DONATE_SUB_FUND;
    $update->PERSON_DONATE_SUB_BOOKNO = $request->PERSON_DONATE_SUB_BOOKNO;
    $update->PERSON_DONATE_SUB_NO = $request->PERSON_DONATE_SUB_NO;
    $update->PERSON_DONATE_SUB_YEAR = $request->PERSON_DONATE_SUB_YEAR;    
    $update->PERSON_DONATE_SUB_WORK = $request->PERSON_DONATE_SUB_WORK;
    $update->PERSON_DONATE_SUB_WEALTH_ID = $request->PERSON_DONATE_SUB_WEALTH_ID;

    $update->PERSON_DONATE_SUB_DATE = $date_sub;

    $update->PERSON_DONATE_SUB_COMENT = $request->PERSON_DONATE_SUB_COMENT;
    $update->PERSON_DONATE_SUB_DETAIL = $request->PERSON_DONATE_SUB_DETAIL;
    $update->PERSON_DONATE_SUB_QTY = $request->PERSON_DONATE_SUB_QTY;
    $update->PERSON_DONATE_SUB_UNIT_ID = $request->PERSON_DONATE_SUB_UNIT_ID;
    $update->PERSON_DONATE_SUB_PRICE = $request->PERSON_DONATE_SUB_PRICE;
    $update->save();

    return redirect()->route('mcrm.persondonate_list');
}

public function persondonatelistsearch(Request $request)
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

    $from = date($displaydate_bigen);
    $to = date($displaydate_end);

    if($status == null){

            $donatedetail_list = Donateperson_sub::leftjoin('donation_unit','donation_person_sub.PERSON_DONATE_SUB_ID','=','donation_unit.DONATIONUNIT_ID')
            ->leftjoin('donation_person','donation_person_sub.DONATE_PERSON_ID','=','donation_person.DONATE_PERSON_ID')
            ->leftjoin('donation_wealth','donation_person_sub.PERSON_DONATE_SUB_WEALTH_ID','=','donation_wealth.DONATIONWEALTH_ID')
            ->where('PERSON_DONATE_SUB_YEAR','=',$yearbudget)    
            ->where(function($q) use ($search){
                $q->where('PERSON_DONATE_SUB_BOOKNO','like','%'.$search.'%');
                $q->orwhere('PERSON_DONATE_SUB_NO','like','%'.$search.'%');
                $q->orwhere('PERSON_DONATE_SUB_WORK','like','%'.$search.'%'); 
                $q->orwhere('PERSON_DONATE_SUB_COMENT','like','%'.$search.'%');  
                $q->orwhere('PERSON_DONATE_SUB_DETAIL','like','%'.$search.'%');   
                $q->orwhere('PERSON_DONATE_SUB_PRICE','like','%'.$search.'%');   
      
            })
            ->WhereBetween('PERSON_DONATE_SUB_DATE',[$from,$to]) 
            ->orderBy('PERSON_DONATE_SUB_ID', 'desc')->get();


            $counttotal = Donateperson_sub::leftjoin('donation_unit','donation_person_sub.PERSON_DONATE_SUB_ID','=','donation_unit.DONATIONUNIT_ID')
            ->leftjoin('donation_person','donation_person_sub.DONATE_PERSON_ID','=','donation_person.DONATE_PERSON_ID')
            ->leftjoin('donation_wealth','donation_person_sub.PERSON_DONATE_SUB_WEALTH_ID','=','donation_wealth.DONATIONWEALTH_ID')
            ->where('PERSON_DONATE_SUB_YEAR','=',$yearbudget)    
            ->where(function($q) use ($search){
                $q->where('PERSON_DONATE_SUB_BOOKNO','like','%'.$search.'%');
                $q->orwhere('PERSON_DONATE_SUB_NO','like','%'.$search.'%');
                $q->orwhere('PERSON_DONATE_SUB_WORK','like','%'.$search.'%'); 
                $q->orwhere('PERSON_DONATE_SUB_COMENT','like','%'.$search.'%');  
                $q->orwhere('PERSON_DONATE_SUB_DETAIL','like','%'.$search.'%');   
                $q->orwhere('PERSON_DONATE_SUB_PRICE','like','%'.$search.'%');   
      
            })
            ->WhereBetween('PERSON_DONATE_SUB_DATE',[$from,$to]) 
            ->orderBy('PERSON_DONATE_SUB_ID', 'desc')->count();
    


            $sumpice = Donateperson_sub::leftjoin('donation_unit','donation_person_sub.PERSON_DONATE_SUB_ID','=','donation_unit.DONATIONUNIT_ID')
            ->leftjoin('donation_person','donation_person_sub.DONATE_PERSON_ID','=','donation_person.DONATE_PERSON_ID')
            ->leftjoin('donation_wealth','donation_person_sub.PERSON_DONATE_SUB_WEALTH_ID','=','donation_wealth.DONATIONWEALTH_ID')
            ->where('PERSON_DONATE_SUB_YEAR','=',$yearbudget)    
            ->where(function($q) use ($search){
                $q->where('PERSON_DONATE_SUB_BOOKNO','like','%'.$search.'%');
                $q->orwhere('PERSON_DONATE_SUB_NO','like','%'.$search.'%');
                $q->orwhere('PERSON_DONATE_SUB_WORK','like','%'.$search.'%'); 
                $q->orwhere('PERSON_DONATE_SUB_COMENT','like','%'.$search.'%');  
                $q->orwhere('PERSON_DONATE_SUB_DETAIL','like','%'.$search.'%');   
                $q->orwhere('PERSON_DONATE_SUB_PRICE','like','%'.$search.'%');   
      
            })
            ->WhereBetween('PERSON_DONATE_SUB_DATE',[$from,$to]) 
            ->orderBy('PERSON_DONATE_SUB_ID', 'desc')->sum('PERSON_DONATE_SUB_PRICE');
    
    
    }else{

            $donatedetail_list = Donateperson_sub::leftjoin('donation_unit','donation_person_sub.PERSON_DONATE_SUB_ID','=','donation_unit.DONATIONUNIT_ID')
            ->leftjoin('donation_person','donation_person_sub.DONATE_PERSON_ID','=','donation_person.DONATE_PERSON_ID')
            ->leftjoin('donation_wealth','donation_person_sub.PERSON_DONATE_SUB_WEALTH_ID','=','donation_wealth.DONATIONWEALTH_ID')
            ->where('PERSON_DONATE_SUB_WEALTH_ID','=',$status)
            ->where('PERSON_DONATE_SUB_YEAR','=',$yearbudget)    
            ->where(function($q) use ($search){
                $q->where('PERSON_DONATE_SUB_BOOKNO','like','%'.$search.'%');
                $q->orwhere('PERSON_DONATE_SUB_NO','like','%'.$search.'%');
                $q->orwhere('PERSON_DONATE_SUB_WORK','like','%'.$search.'%'); 
                $q->orwhere('PERSON_DONATE_SUB_COMENT','like','%'.$search.'%');  
                $q->orwhere('PERSON_DONATE_SUB_DETAIL','like','%'.$search.'%');   
                $q->orwhere('PERSON_DONATE_SUB_PRICE','like','%'.$search.'%');
             
            })
            ->WhereBetween('PERSON_DONATE_SUB_DATE',[$from,$to]) 
            ->orderBy('PERSON_DONATE_SUB_ID', 'desc')->get();   
            
            
            $counttotal = Donateperson_sub::leftjoin('donation_unit','donation_person_sub.PERSON_DONATE_SUB_ID','=','donation_unit.DONATIONUNIT_ID')
            ->leftjoin('donation_person','donation_person_sub.DONATE_PERSON_ID','=','donation_person.DONATE_PERSON_ID')
            ->leftjoin('donation_wealth','donation_person_sub.PERSON_DONATE_SUB_WEALTH_ID','=','donation_wealth.DONATIONWEALTH_ID')
            ->where('PERSON_DONATE_SUB_WEALTH_ID','=',$status)
            ->where('PERSON_DONATE_SUB_YEAR','=',$yearbudget)    
            ->where(function($q) use ($search){
                $q->where('PERSON_DONATE_SUB_BOOKNO','like','%'.$search.'%');
                $q->orwhere('PERSON_DONATE_SUB_NO','like','%'.$search.'%');
                $q->orwhere('PERSON_DONATE_SUB_WORK','like','%'.$search.'%'); 
                $q->orwhere('PERSON_DONATE_SUB_COMENT','like','%'.$search.'%');  
                $q->orwhere('PERSON_DONATE_SUB_DETAIL','like','%'.$search.'%');   
                $q->orwhere('PERSON_DONATE_SUB_PRICE','like','%'.$search.'%');
             
            })
            ->WhereBetween('PERSON_DONATE_SUB_DATE',[$from,$to]) 
            ->orderBy('PERSON_DONATE_SUB_ID', 'desc')->count();   


            $sumpice = Donateperson_sub::leftjoin('donation_unit','donation_person_sub.PERSON_DONATE_SUB_ID','=','donation_unit.DONATIONUNIT_ID')
            ->leftjoin('donation_person','donation_person_sub.DONATE_PERSON_ID','=','donation_person.DONATE_PERSON_ID')
            ->leftjoin('donation_wealth','donation_person_sub.PERSON_DONATE_SUB_WEALTH_ID','=','donation_wealth.DONATIONWEALTH_ID')
            ->where('PERSON_DONATE_SUB_WEALTH_ID','=',$status)
            ->where('PERSON_DONATE_SUB_YEAR','=',$yearbudget)    
            ->where(function($q) use ($search){
                $q->where('PERSON_DONATE_SUB_BOOKNO','like','%'.$search.'%');
                $q->orwhere('PERSON_DONATE_SUB_NO','like','%'.$search.'%');
                $q->orwhere('PERSON_DONATE_SUB_WORK','like','%'.$search.'%'); 
                $q->orwhere('PERSON_DONATE_SUB_COMENT','like','%'.$search.'%');  
                $q->orwhere('PERSON_DONATE_SUB_DETAIL','like','%'.$search.'%');   
                $q->orwhere('PERSON_DONATE_SUB_PRICE','like','%'.$search.'%');
             
            })
            ->WhereBetween('PERSON_DONATE_SUB_DATE',[$from,$to]) 
            ->orderBy('PERSON_DONATE_SUB_ID', 'desc')->sum('PERSON_DONATE_SUB_PRICE');  
    }

 
    $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;        }

        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();


         $type_check = DB::table('donation_wealth')->get();
        
        $year_id = $yearbudget;

    return view('manager_crm.persondonate_list',[
        'donatedetail_lists' =>$donatedetail_list,
        'budgets' =>  $budget,
        'displaydate_bigen'=> $displaydate_bigen,
        'displaydate_end'=> $displaydate_end,
        'status_check'=> $status,
        'search'=> $search,
        'year_id'=>$year_id,
        'counttotal'=>$counttotal,
        'sumpice'=>$sumpice,
        'type_checks'=>$type_check
    ]);

}
   

//===============================================//   
    public function donationwealth()
    {
        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;        }

        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';
        $status = '';
        $search = '';
        $year_id = $yearbudget;

        $wealth = DB::table('donation_wealth')->get();
    
        return view('manager_crm.donationwealth',[
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id,
            'wealths'=>$wealth,
        ]);
    }
    public function donationwealth_add()
    {
       
        return view('manager_crm.donationwealth_add');
    }
    public function savedonationwealth(Request $request)
    {
        
        $add= new Donationwealth();
        $add->DONATIONWEALTH_NAME = $request->DONATIONWEALTH_NAME;
        $add->save();

        return redirect()->route('mcrm.donationwealth');
    }
    public function donationwealth_edit(Request $request,$id)
    {
        $donationwealth = Donationwealth::where('DONATIONWEALTH_ID','=',$id)->first();

        return view('manager_crm.donationwealth_edit',[
            'donationwealths' => $donationwealth
        ]);
    }
    public function updatedonationwealth(Request $request)
    {
        $id = $request->DONATIONWEALTH_ID;
        $updat = Donationwealth::find($id);       
        $updat->DONATIONWEALTH_NAME = $request->DONATIONWEALTH_NAME; 
        $updat->save();
        return redirect()->route('mcrm.donationwealth');
    }
    public function destroydonationwealth($id)
    {
        Donationwealth::destroy($id);
        return redirect()->route('mcrm.donationwealth');
    }

//=============================================//

    public function openform()
    {   
        $openform = DB::table('donation_openform')->get();
    
        return view('manager_crm.openform',[
            'openforms' =>  $openform,        
        ]);
    }
    public function openform_add()
    {   
        $openform = DB::table('donation_openform')->get();
    
        return view('manager_crm.openform_add',[
            'openforms' =>  $openform,        
        ]);
    }
    public function openform_save(Request $request)
    {  
        $add= new Donateopenform();
        $add->OPENFORM_CODE = $request->OPENFORM_CODE;
        $add->OPENFORM_NAME = $request->OPENFORM_NAME;
        $add->save();

        return redirect()->route('mcrm.openform');
    }

    public function openform_edit(Request $request,$id)
    {
        $openform = Donateopenform::where('OPENFORM_ID','=',$id)->first();

        return view('manager_crm.openform_edit',[
            'openforms' =>  $openform, 
        ]);
    }
    public function openform_update(Request $request)
    {      
        $id = $request->OPENFORM_ID;
        $updat = Donateopenform::find($id);       
        $updat->OPENFORM_CODE = $request->OPENFORM_CODE;    
        $updat->OPENFORM_NAME = $request->OPENFORM_NAME;     
        $updat->save();

        return redirect()->route('mcrm.openform');
    }
    public function openform_destroy($id)
    {
        Donateopenform::destroy($id);

        return redirect()->route('mcrm.openform');
    }

    function openform_switchactive(Request $request)
    {  
        $id = $request->idfunc;
        $active = Donateopenform::find($id);
        $active->OPENFORM_STATUS = $request->onoff;
        $active->save();
    }

//=============================================//

    public function donationtopic()
    {
        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;        }


        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';
  
        $search = '';
        $year_id = $yearbudget;

        $donationtopic = DB::table('donation_topic')->get();

        return view('manager_crm.donationtopic',[
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'search'=> $search,
            'year_id'=>$year_id,
            'donationtopics' => $donationtopic
        ]);
    }


    public function donationtopicsearch(Request $request)
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
        $date_bigen_checks = strtotime($displaydate_bigen);
        $date_end_checks =  strtotime($displaydate_end);
        $dates =  strtotime($date);
    
        $from = date($displaydate_bigen);
        $to = date($displaydate_end);
          

        $donationtopic = DB::table('donation_topic')
            ->where(function($q) use ($search){
                $q->where('DONATIONTOPIC_NAME','like','%'.$search.'%');
                $q->orwhere('DONATIONTOPIC_TARGET','like','%'.$search.'%');
                
            })
            ->WhereBetween('DONATIONTOPIC_DATE_START',[$from,$to]) 
            ->orderBy('DONATIONTOPIC_ID', 'desc')->get();   
     
            
        return view('manager_crm.donationtopic',[
            'donationtopics' =>$donationtopic,           
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,           
            'search'=> $search,           
        ]);
    
    }


    public function donationtopic_add()
    {       
        return view('manager_crm.donationtopic_add');
    }
    public function savedonationtopic(Request $request)
    {       
        $DONATIONTOPIC_DATE_START = $request->DONATIONTOPIC_DATE_START;  

        if($DONATIONTOPIC_DATE_START != ''){
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $DONATIONTOPIC_DATE_START)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0]; 
            
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $DONATIONTOPIC_DATESTART= $y_st."-".$m_st."-".$d_st;
            }else{
            $DONATIONTOPIC_DATESTART= null;
        }


        $DONATIONTOPIC_DATE_END = $request->DONATIONTOPIC_DATE_END;

        if($DONATIONTOPIC_DATE_END != ''){
        $STARTDAY = Carbon::createFromFormat('d/m/Y', $DONATIONTOPIC_DATE_END)->format('Y-m-d');
        $date_arrary_st=explode("-",$STARTDAY);  
        $y_sub_st = $date_arrary_st[0]; 
        
        if($y_sub_st >= 2500){
            $y_st = $y_sub_st-543;
        }else{
            $y_st = $y_sub_st;
        }
        $m_st = $date_arrary_st[1];
        $d_st = $date_arrary_st[2];  
        $DONATIONTOPIC_DATEEND= $y_st."-".$m_st."-".$d_st;
        }else{
        $DONATIONTOPIC_DATEEND= null;
        }
            $add= new Donationtopic();
            $add->DONATIONTOPIC_NAME = $request->DONATIONTOPIC_NAME;
            $add->DONATIONTOPIC_DATE_START = $DONATIONTOPIC_DATESTART;
            $add->DONATIONTOPIC_DATE_END = $DONATIONTOPIC_DATEEND;
            $add->DONATIONTOPIC_TARGET = $request->DONATIONTOPIC_TARGET;
            $add->save();
            return redirect()->route('mcrm.donationtopic');
        }
        
   
        public function donationtopic_edit(Request $request,$id)
    {
            $donationtopic = Donationtopic::where('DONATIONTOPIC_ID','=',$id)->first();

            return view('manager_crm.donationtopic_edit',[
                'donationtopics' => $donationtopic
            ]);
    }
    public function updatedonationtopic(Request $request)
        {
            $DONATIONTOPIC_DATE_START = $request->DONATIONTOPIC_DATE_START;  

            if($DONATIONTOPIC_DATE_START != ''){
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $DONATIONTOPIC_DATE_START)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0]; 
            
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $DONATIONTOPIC_DATESTART= $y_st."-".$m_st."-".$d_st;
            }else{
            $DONATIONTOPIC_DATESTART= null;
        }


        $DONATIONTOPIC_DATE_END = $request->DONATIONTOPIC_DATE_END;

        if($DONATIONTOPIC_DATE_END != ''){
        $STARTDAY = Carbon::createFromFormat('d/m/Y', $DONATIONTOPIC_DATE_END)->format('Y-m-d');
        $date_arrary_st=explode("-",$STARTDAY);  
        $y_sub_st = $date_arrary_st[0]; 
        
        if($y_sub_st >= 2500){
            $y_st = $y_sub_st-543;
        }else{
            $y_st = $y_sub_st;
        }
        $m_st = $date_arrary_st[1];
        $d_st = $date_arrary_st[2];  
        $DONATIONTOPIC_DATEEND= $y_st."-".$m_st."-".$d_st;
        }else{
        $DONATIONTOPIC_DATEEND= null;
    }

        $id = $request->DONATIONTOPIC_ID;
        $updat = Donationtopic::find($id);       
        $updat->DONATIONTOPIC_NAME = $request->DONATIONTOPIC_NAME;
        $updat->DONATIONTOPIC_DATE_START = $DONATIONTOPIC_DATESTART;
        $updat->DONATIONTOPIC_DATE_END = $DONATIONTOPIC_DATEEND;
        $updat->DONATIONTOPIC_TARGET = $request->DONATIONTOPIC_TARGET;
        $updat->save();

        return redirect()->route('mcrm.donationtopic');
    }
    public function destroydonationtopic($id)
    {
        Donationtopic::destroy($id);
        Toastr::success('ลบข้อมูลสำเร็จ');
        return redirect()->route('mcrm.donationtopic');
    }
 //=============================================//
    public function donationunit()
    {
        $donationunit = DB::table('donation_unit')->get();
        $status = '';
        $search = '';
        return view('manager_crm.donationunit',[
            'donationunits' => $donationunit,
            'status_check'=> $status,
            'search'=> $search,
        ]);
    }
    public function donationunit_add()
    {       
        return view('manager_crm.donationunit_add');
    }
    public function savedonationunit(Request $request)
    {  
        $add= new Donationunit();
        $add->DONATIONUNIT_NAME = $request->DONATIONUNIT_NAME;
        $add->save();
 
        return redirect()->route('mcrm.donationunit');
    }
    public function donationunit_edit(Request $request,$id)
    {
        $donationunit = Donationunit::where('DONATIONUNIT_ID','=',$id)->first();

        return view('manager_crm.donationunit_edit',[
            'donationunits' => $donationunit
        ]);
    }
    public function updatedonationunit(Request $request)
    {      
        $id = $request->DONATIONUNIT_ID;
        $updat = Donationunit::find($id);       
        $updat->DONATIONUNIT_NAME = $request->DONATIONUNIT_NAME;       
        $updat->save();

        return redirect()->route('mcrm.donationunit');
    }
    public function destroydonationunit($id)
    {
        Donationunit::destroy($id);
        Toastr::success('ลบข้อมูลสำเร็จ');
        return redirect()->route('mcrm.donationunit');
    }

    //=============================================//

    public function donation_fund()
    {
        $donationfund = DB::table('donation_fund')->get();
        $status = '';
        $search = '';
        return view('manager_crm.donation_fund',[
            'donationfunds' => $donationfund,
            'status_check'=> $status,
            'search'=> $search,
        ]);
    }
    public function donation_fund_add()
    {       
        return view('manager_crm.donation_fund_add');
    }
    public function donation_fund_save(Request $request)
    {  
        $add= new Donationfund();
        $add->DONATE_FUND_NAME = $request->DONATE_FUND_NAME;

        $add->save();
        // Toastr::success('บันทึกข้อมูลสำเร็จ');
        return redirect()->route('mcrm.donation_fund');
    }
    public function donation_fund_edit(Request $request,$id)
    {
        $donationfund = Donationfund::where('DONATE_FUND_ID','=',$id)->first();

        return view('manager_crm.donation_fund_edit',[
            'donationfunds' => $donationfund
        ]);
    }
    public function donation_fund_update(Request $request)
    {      
        $id = $request->DONATE_FUND_ID;
        $updat = Donationfund::find($id);       
        $updat->DONATE_FUND_NAME = $request->DONATE_FUND_NAME;       
        $updat->save();
        // Toastr::success('แก้ไขข้อมูลสำเร็จ');
        return redirect()->route('mcrm.donation_fund');
    }
    public function donation_fund_destroy($id)
    {
        Donationfund::destroy($id);
        // Toastr::success('ลบข้อมูลสำเร็จ');
        return redirect()->route('mcrm.donation_fund');
    }






    function donation_fund_addajax(Request $request)
    {
     
        if($request->record_donulfun!= null || $request->record_donulfun != ''){
    
            $count_check = Donationfund::where('DONATE_FUND_NAME','=',$request->record_donulfun)->count();
            
                if($count_check == 0){
    
            $addrecord = new Donationfund(); 
            $addrecord->DONATE_FUND_NAME = $request->record_donulfun;
            $addrecord->save(); 
                }
        }
            $query =  DB::table('donation_fund')->get();
        
            $output='<option value="">--กรุณาเลือก--</option>';
            
            foreach ($query as $row){
                if($request->record_donulfun == $row->DONATE_FUND_NAME){
                    $output.= '<option value="'.$row->DONATE_FUND_ID.'" selected>'.$row->DONATE_FUND_NAME.'</option>';
                }else{
                    $output.= '<option value="'.$row->DONATE_FUND_ID.'">'.$row->DONATE_FUND_NAME.'</option>';
                }          
        }
            echo $output;
        
    }

    function donation_fund_addtypeajax(Request $request)
    {     
        if($request->record_typecrm!= null || $request->record_typecrm != ''){
    
            $count_check = Donationwealth::where('DONATIONWEALTH_NAME','=',$request->record_typecrm)->count();
            
                if($count_check == 0){
    
            $addrecord = new Donationwealth(); 
            $addrecord->DONATIONWEALTH_NAME = $request->record_typecrm;
            $addrecord->save(); 
                }
        }
            $query =  DB::table('donation_wealth')->get();
        
            $output='<option value="">--กรุณาเลือก--</option>';
            
            foreach ($query as $row){
                if($request->record_typecrm == $row->DONATIONWEALTH_NAME){
                    $output.= '<option value="'.$row->DONATIONWEALTH_ID.'" selected>'.$row->DONATIONWEALTH_NAME.'</option>';
                }else{
                    $output.= '<option value="'.$row->DONATIONWEALTH_ID.'">'.$row->DONATIONWEALTH_NAME.'</option>';
                }          
        }
            echo $output;
        
    }

    function donation_fund_addunitajax(Request $request)
    {     
        if($request->record_unitcrm!= null || $request->record_unitcrm != ''){
    
            $count_check = Donationunit::where('DONATIONUNIT_NAME','=',$request->record_unitcrm)->count();
            
                if($count_check == 0){
    
            $addrecord = new Donationunit(); 
            $addrecord->DONATIONUNIT_NAME = $request->record_unitcrm;
            $addrecord->save(); 
                }
        }
            $query =  DB::table('donation_unit')->get();
        
            $output='<option value="">--กรุณาเลือก--</option>';
            
            foreach ($query as $row){
                if($request->record_unitcrm == $row->DONATIONUNIT_NAME){
                    $output.= '<option value="'.$row->DONATIONUNIT_ID.'" selected>'.$row->DONATIONUNIT_NAME.'</option>';
                }else{
                    $output.= '<option value="'.$row->DONATIONUNIT_ID.'">'.$row->DONATIONUNIT_NAME.'</option>';
                }          
        }
            echo $output;
        
    }












    public function pdfcongrat(Request $request,$idref)
{
    
   
      $infocongrat = DB::table('donation_person_sub')
      ->leftjoin('donation_person','donation_person.DONATE_PERSON_ID','=','donation_person_sub.DONATE_PERSON_ID')
      ->where('PERSON_DONATE_SUB_ID','=',$idref)->first();
      
      $checksig = DB::table('gleave_function')->where('FUNCTION_ID','=',1)->where('ACTIVE','=','True')->count();

      $infoorg = DB::table('info_org')->where('ORG_ID','=','1')
      ->leftjoin('hrd_person','hrd_person.ID','=','info_org.ORG_LEADER_ID')
      ->first();

      $orgname =  DB::table('info_org')
        ->leftJoin('hrd_person','info_org.ORG_LEADER_ID','=','hrd_person.ID')
        ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->first();
      
      $sigin = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$orgname->ORG_LEADER_ID)->first();

      if($sigin !== null){
        $sig =  $sigin->FILE_NAME;
    }else{ $sig = '';}

    $pdf = PDF::loadView('manager_crm.pdfcongrat',[
          'infocongrat' => $infocongrat,
          'infoorg' => $infoorg,
          'sig' => $sig,
          'checksig' => $checksig,
          'orgname' => $orgname,
    ]);
   
    $pdf->setPaper('a4','landscape');

    return @$pdf->stream();
}
    

 //======function_count======

 public static function countamount($idref)
 {
         $count =  DB::table('donation_person_sub')->where('DONATE_PERSON_ID','=',$idref)->count();
 
     return $count;
 }
 
 public static function sumamount($idref)
 {
         $sumamount =   DB::table('donation_person_sub')->where('DONATE_PERSON_ID','=',$idref)->sum('PERSON_DONATE_SUB_PRICE');
 
     return $sumamount;
 }





}

