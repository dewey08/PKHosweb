<?php

namespace App\Http\Controllers;
use File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Bookindex;
use App\Models\Bookindexout;
use App\Models\Bookindexsendleader;
use App\Models\Booksend;
use App\Models\Booksendsub;
use App\Models\Booksendsubsub;
use App\Models\Booksendperson;
use App\Models\Person;
use App\Models\Recordorg;
use App\Models\Permislist;

use App\Models\Booksendcommandleader;
use App\Models\Booksendcommanddepart;
use App\Models\Booksendcommanddepartsub;
use App\Models\Booksendcommanddepartsubsub;
use App\Models\Booksendcommand;
use App\Models\Bookindexcommand;
use App\Models\Booksendcommandorg;

//------------หนังสือส่ง--------------------------
use App\Models\Booksendinsideleader;
use App\Models\Booksendinsidedepart;
use App\Models\Booksendinsidedepartsub;
use App\Models\Booksendinsidedepartsubsub;
use App\Models\Booksendinside;
use App\Models\Bookindexinside;
use App\Models\Booksendinsideorg;
//------------------------------------------

use App\Models\Booksendannounceleader;
use App\Models\Booksendannouncedepart;
use App\Models\Booksendannouncedepartsub;
use App\Models\Booksendannouncedepartsubsub;
use App\Models\Booksendannounce;
use App\Models\Bookindexannounce;
use App\Http\Controllers\Report\BookReportController;
use Cookie;

date_default_timezone_set("Asia/Bangkok");

class ManagerbookController extends Controller
{
    public function dashboard(Request $request)
    {
        if($request->method() == "POST"){
            $year = $request->year;
            $data_search = json_encode_u([
                'year' => $year,
            ]);
            Cookie::queue('data_search', $data_search, 120,$request->server('REQUEST_URI'));
        }elseif(!empty(Cookie::get('data_search'))){
            $data_search    = json_decode(Cookie::get('data_search'));
            $year = $data_search->year;
        }else{
            $year = date('Y') + 543;
        }
        $data['year'] = $year;
        $year_ad = $data['year'] - 543;
        $form   = $year_ad.date('-01-1');
        $to     = $year_ad.date('-12-31');
        $data['amount_receive'] = Bookindex::whereBetween('DATE_SAVE',[$form,$to])->where('BOOK_USE','=','true')->count();
        $data['amount_sent'] = Bookindexinside::whereBetween('DATE_SAVE',[$form,$to])->where('BOOK_USE','=','true')->count();
        $data['amount_command'] = Bookindexcommand::whereBetween('DATE_SAVE',[$form,$to])->where('BOOK_USE','=','true')->count();
        $data['amount_announce'] = Bookindexannounce::whereBetween('DATE_SAVE',[$form,$to])->where('BOOK_USE','=','true')->count();
        $bookReport = new BookReportController();
        $data['amount_recievebook_M'] =  $bookReport->countBookindex_M($year_ad);
        $data['amount_ebooksend_M'] =  $bookReport->countBooksend_M($year_ad);
        $data['amount_ReceiveebookUrgent_M'] =  $bookReport->countReceivebookUrgent($year_ad);
        $data['countTypeebookreceive'] =  $bookReport->countTypeebookreceive($year_ad);
        $data['countTypeebookreceive_byORG'] =  $bookReport->countTypeebookreceive_byORG($year_ad,10);
        $data['year_dropdown'] = getYearAmount();
        return view('manager_book.dashboard_book',$data);
    }

    public function report()
    {   
        return view('manager_book.report_book');
    }

    public function disposereceipt()
    {     
        
        $infobookreceipt = Bookindex::leftJoin('grecord_org','gbook_index.BOOK_ORG_ID','=','grecord_org.RECORD_ORG_ID')
        ->leftJoin('hrd_person','gbook_index.PERSON_SAVE_ID','=','hrd_person.ID')
        ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('gbook_index_send_leader','gbook_index.BOOK_ID','=','gbook_index_send_leader.BOOK_LD_ID')
        ->where('BOOK_USE','=','false')
        ->orderBy('gbook_index.BOOK_ID', 'desc') 
        ->get();


        $infobookstatus1 = DB::table('gbook_status')
        ->where('BOOK_STATUS_ID','=','1')
        ->first();
        $infobookstatus2 = DB::table('gbook_status')
        ->where('BOOK_STATUS_ID','=','2')
        ->first();
        $infobookstatus3 = DB::table('gbook_status')
        ->where('BOOK_STATUS_ID','=','3')
        ->first();
      
        $infobook_sendstatus = DB::table('gbook_status')
        ->get();


        $displaydate_bigen = '';
        $displaydate_end = '';
        $status = '';
        $search = '';

        return view('manager_book.report_disposereceipt',[
            'infobookreceipts' =>$infobookreceipt,
            'infobookstatus1'=> $infobookstatus1, 
            'infobookstatus2'=> $infobookstatus2,
            'infobookstatus3'=> $infobookstatus3,
            'infobook_sendstatuss'=>   $infobook_sendstatus,
            'displaydate_bigen'=> $displaydate_bigen, 
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search
           ]);
    }

    public function disposeout()
    {    
        $infobookinside = Bookindexinside::leftJoin('grecord_org','gbook_index_inside.BOOK_ORG_ID','=','grecord_org.RECORD_ORG_ID')
        ->leftJoin('hrd_person','gbook_index_inside.PERSON_SAVE_ID','=','hrd_person.ID')
        ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('gbook_index_send_leader','gbook_index_inside.BOOK_ID','=','gbook_index_send_leader.BOOK_LD_ID')
        ->where('BOOK_USE','=','false')
        ->orderBy('gbook_index_inside.BOOK_NUM_IN', 'desc') 
        ->get();


        $infobookstatus1 = DB::table('gbook_status')
        ->where('BOOK_STATUS_ID','=','1')
        ->first();
        $infobookstatus2 = DB::table('gbook_status')
        ->where('BOOK_STATUS_ID','=','2')
        ->first();
        $infobookstatus3 = DB::table('gbook_status')
        ->where('BOOK_STATUS_ID','=','3')
        ->first();
      
        $infobook_sendstatus = DB::table('gbook_status')
        ->get();


        $displaydate_bigen = '';
        $displaydate_end = '';
        $status = '';
        $search = '';


        return view('manager_book.report_disposeout',[
            'infobookinsides' =>$infobookinside,
            'infobookstatus1'=> $infobookstatus1, 
            'infobookstatus2'=> $infobookstatus2,
            'infobookstatus3'=> $infobookstatus3,
            'infobook_sendstatuss'=>   $infobook_sendstatus,
            'displaydate_bigen'=> $displaydate_bigen, 
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search
           ]);
    }


    //===============================หนังสือรับ==============================

    public function infobookreceipt(Request $request)
    {
        if(!empty($request->_token)){
            $yearbudget = $request->BUDGET_YEAR;
            $search = $request->get('search');
            $status = $request->SEND_STATUS;
            $datebigin = $request->get('DATE_BIGIN');
            $dateend = $request->get('DATE_END');
            session([
                'manager_book.bookreceipt.yearbudget' => $yearbudget,
                'manager_book.bookreceipt.search' => $search,
                'manager_book.bookreceipt.status' => $status,
                'manager_book.bookreceipt.datebigin' => $datebigin,
                'manager_book.bookreceipt.dateend' => $dateend,
            ]);
        }elseif(!empty(session('manager_book.bookreceipt'))){
            $yearbudget = session('manager_book.bookreceipt.yearbudget');
            $search = session('manager_book.bookreceipt.search');
            $status = session('manager_book.bookreceipt.status');
            $datebigin = session('manager_book.bookreceipt.datebigin');
            $dateend = session('manager_book.bookreceipt.dateend');
        }else{
            $yearbudget = getBudgetyear();
            $search = '';
            $status = '';
            $datebigin = date('1/m/Y');
            $dateend   = date('d/m/Y', strtotime(date('Y-m-1'). '+1month -1days'));
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
                $infobookreceipt=  Bookindex::leftJoin('grecord_org','gbook_index.BOOK_ORG_ID','=','grecord_org.RECORD_ORG_ID')
                ->leftJoin('hrd_person','gbook_index.PERSON_SAVE_ID','=','hrd_person.ID')
                ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                ->leftJoin('gbook_index_send_leader','gbook_index.BOOK_ID','=','gbook_index_send_leader.BOOK_LD_ID')
                ->where('BOOK_USE','=','true')
                ->where(function($q) use ($search){
                            $q->where('BOOK_NUM_IN','like','%'.$search.'%');
                            $q->orwhere('BOOK_NUMBER','like','%'.$search.'%');
                            $q->orwhere('BOOK_NAME','like','%'.$search.'%');
                            $q->orwhere('BOOK_DETAIL','like','%'.$search.'%');
                            $q->orwhere('RECORD_ORG_NAME','like','%'.$search.'%');
                })
                ->WhereBetween('DATE_SAVE',[$from,$to]) 
                ->orderBy('gbook_index.BOOK_NUM_IN', 'desc')    
                ->get();
            }else{
                $infobookreceipt=  Bookindex::leftJoin('grecord_org','gbook_index.BOOK_ORG_ID','=','grecord_org.RECORD_ORG_ID')
                ->leftJoin('hrd_person','gbook_index.PERSON_SAVE_ID','=','hrd_person.ID')
                ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                ->leftJoin('gbook_index_send_leader','gbook_index.BOOK_ID','=','gbook_index_send_leader.BOOK_LD_ID')
                ->where('BOOK_USE','=','true')
                    ->where('SEND_STATUS','=',$status)
                    ->where(function($q) use ($search){
                        $q->where('BOOK_NUM_IN','like','%'.$search.'%');
                        $q->orwhere('BOOK_NUMBER','like','%'.$search.'%');
                        $q->orwhere('BOOK_NAME','like','%'.$search.'%');
                        $q->orwhere('BOOK_DETAIL','like','%'.$search.'%');
                        $q->orwhere('RECORD_ORG_NAME','like','%'.$search.'%');
                    })
                    ->WhereBetween('DATE_SAVE',[$from,$to]) 
                    ->orderBy('gbook_index.BOOK_NUM_IN', 'desc')    
                    ->get();

            }
        $iduser  = Auth::user()->PERSON_ID; 
        $infobooksend = DB::table('hrd_person')
        ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->where('hrd_person.ID','=',$iduser)
        ->first();

        $infobookstatus1 = DB::table('gbook_status')
        ->where('BOOK_STATUS_ID','=','1')
        ->first();
        $infobookstatus2 = DB::table('gbook_status')
        ->where('BOOK_STATUS_ID','=','2')
        ->first();
        $infobookstatus3 = DB::table('gbook_status')
        ->where('BOOK_STATUS_ID','=','3')
        ->first();
      
        $infobook_sendstatus = DB::table('gbook_status')
        ->get();
  
        $budget = getYearAmount(10);

        $year_id = $yearbudget;
        
        return view('manager_book.infobookreceipt',[
            'infobookreceipts' =>$infobookreceipt,
            'infobookstatus1'=> $infobookstatus1, 
            'infobookstatus2'=> $infobookstatus2,
            'infobookstatus3'=> $infobookstatus3,
            'infobooksend'=>   $infobooksend,
            'infobook_sendstatuss'=> $infobook_sendstatus,
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id, 
          ]);
    }

    public function infobooksearch(Request $request)
    {

        $yearbudget = $request->BUDGET_YEAR;
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
                $infobookreceipt=  Bookindex::leftJoin('grecord_org','gbook_index.BOOK_ORG_ID','=','grecord_org.RECORD_ORG_ID')
                ->leftJoin('hrd_person','gbook_index.PERSON_SAVE_ID','=','hrd_person.ID')
                ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                ->leftJoin('gbook_index_send_leader','gbook_index.BOOK_ID','=','gbook_index_send_leader.BOOK_LD_ID')
                ->where('BOOK_USE','=','true')
                ->where(function($q) use ($search){
                            $q->where('BOOK_NUM_IN','like','%'.$search.'%');
                            $q->orwhere('BOOK_NUMBER','like','%'.$search.'%');
                            $q->orwhere('BOOK_NAME','like','%'.$search.'%');
                            $q->orwhere('BOOK_DETAIL','like','%'.$search.'%');
                            $q->orwhere('RECORD_ORG_NAME','like','%'.$search.'%');
                })
                ->WhereBetween('DATE_SAVE',[$from,$to]) 
                ->orderBy('gbook_index.DATE_SAVE', 'desc')    
                ->get();
            }else{
                $infobookreceipt=  Bookindex::leftJoin('grecord_org','gbook_index.BOOK_ORG_ID','=','grecord_org.RECORD_ORG_ID')
                ->leftJoin('hrd_person','gbook_index.PERSON_SAVE_ID','=','hrd_person.ID')
                ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                ->leftJoin('gbook_index_send_leader','gbook_index.BOOK_ID','=','gbook_index_send_leader.BOOK_LD_ID')
                ->where('BOOK_USE','=','true')
                    ->where('SEND_STATUS','=',$status)
                    ->where(function($q) use ($search){
                        $q->where('BOOK_NUM_IN','like','%'.$search.'%');
                        $q->orwhere('BOOK_NUMBER','like','%'.$search.'%');
                        $q->orwhere('BOOK_NAME','like','%'.$search.'%');
                        $q->orwhere('BOOK_DETAIL','like','%'.$search.'%');
                        $q->orwhere('RECORD_ORG_NAME','like','%'.$search.'%');
                    })
                    ->WhereBetween('DATE_SAVE',[$from,$to]) 
                    ->orderBy('gbook_index.DATE_SAVE', 'desc')    
                    ->get();

            }
    

     

        $iduser  = Auth::user()->PERSON_ID; 
        $infobooksend = DB::table('hrd_person')
        ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->where('hrd_person.ID','=',$iduser)
        ->first();

        $infobookstatus1 = DB::table('gbook_status')
        ->where('BOOK_STATUS_ID','=','1')
        ->first();
        $infobookstatus2 = DB::table('gbook_status')
        ->where('BOOK_STATUS_ID','=','2')
        ->first();
        $infobookstatus3 = DB::table('gbook_status')
        ->where('BOOK_STATUS_ID','=','3')
        ->first();
      
        $infobook_sendstatus = DB::table('gbook_status')
        ->get();
  
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $year_id = $yearbudget;
        
        return view('manager_book.infobookreceipt',[
            'infobookreceipts' =>$infobookreceipt,
            'infobookstatus1'=> $infobookstatus1, 
            'infobookstatus2'=> $infobookstatus2,
            'infobookstatus3'=> $infobookstatus3,
            'infobooksend'=>   $infobooksend,
            'infobook_sendstatuss'=> $infobook_sendstatus,
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id, 
            
            
          ]);
    }

    public function bookreceipt_excel(Request $request, $datebegin, $dateen, $status, $search)
    {

        $from = $datebegin;
        $to   = $dateen;

        if ($search == 'null') {
            $search = '';
        }

        if ($status == 'null') {
            $status = '';
        }
            if($status == null){
                $infobookreceipt=  Bookindex::leftJoin('grecord_org','gbook_index.BOOK_ORG_ID','=','grecord_org.RECORD_ORG_ID')
                ->leftJoin('hrd_person','gbook_index.PERSON_SAVE_ID','=','hrd_person.ID')
                ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                ->leftJoin('gbook_index_send_leader','gbook_index.BOOK_ID','=','gbook_index_send_leader.BOOK_LD_ID')
                ->where('BOOK_USE','=','true')
                ->where(function($q) use ($search){
                            $q->where('BOOK_NUM_IN','like','%'.$search.'%');
                            $q->orwhere('BOOK_NUMBER','like','%'.$search.'%');
                            $q->orwhere('BOOK_NAME','like','%'.$search.'%');
                            $q->orwhere('BOOK_DETAIL','like','%'.$search.'%');
                            $q->orwhere('RECORD_ORG_NAME','like','%'.$search.'%');
                })
                ->WhereBetween('DATE_SAVE',[$from,$to]) 
                ->orderBy('gbook_index.BOOK_NUM_IN', 'desc')    
                ->get();
            }else{
                $infobookreceipt=  Bookindex::leftJoin('grecord_org','gbook_index.BOOK_ORG_ID','=','grecord_org.RECORD_ORG_ID')
                ->leftJoin('hrd_person','gbook_index.PERSON_SAVE_ID','=','hrd_person.ID')
                ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                ->leftJoin('gbook_index_send_leader','gbook_index.BOOK_ID','=','gbook_index_send_leader.BOOK_LD_ID')
                ->where('BOOK_USE','=','true')
                    ->where('SEND_STATUS','=',$status)
                    ->where(function($q) use ($search){
                        $q->where('BOOK_NUM_IN','like','%'.$search.'%');
                        $q->orwhere('BOOK_NUMBER','like','%'.$search.'%');
                        $q->orwhere('BOOK_NAME','like','%'.$search.'%');
                        $q->orwhere('BOOK_DETAIL','like','%'.$search.'%');
                        $q->orwhere('RECORD_ORG_NAME','like','%'.$search.'%');
                    })
                    ->WhereBetween('DATE_SAVE',[$from,$to]) 
                    ->orderBy('gbook_index.BOOK_NUM_IN', 'desc')    
                    ->get();

            }
        $iduser  = Auth::user()->PERSON_ID; 
        $infobooksend = DB::table('hrd_person')
        ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->where('hrd_person.ID','=',$iduser)
        ->first();

        $infobookstatus1 = DB::table('gbook_status')
        ->where('BOOK_STATUS_ID','=','1')
        ->first();
        $infobookstatus2 = DB::table('gbook_status')
        ->where('BOOK_STATUS_ID','=','2')
        ->first();
        $infobookstatus3 = DB::table('gbook_status')
        ->where('BOOK_STATUS_ID','=','3')
        ->first();
      
        $infobook_sendstatus = DB::table('gbook_status')
        ->get();
  
        $budget = getYearAmount(10);

        $year_id = '';


        
        return view('manager_book.infobookreceipt_excel',[
            'infobookreceipts' =>$infobookreceipt,
            'infobookstatus1'=> $infobookstatus1, 
            'infobookstatus2'=> $infobookstatus2,
            'infobookstatus3'=> $infobookstatus3,
            'infobooksend'=>   $infobooksend,
            'infobook_sendstatuss'=>   $infobook_sendstatus,
            'budgets' =>  $budget,
       
           ]);
    }


    public function infobookreceiptinsert()
    {
        $budgetyear = DB::table('budget_year')->get();
        $booktype = DB::table('gbook_type')->get();
        $bookinstant = DB::table('gbook_instant')->get();
        $booksecret = DB::table('gbook_secret')->get();
        $bookorg = DB::table('grecord_org')->get();
        
        $iduser  = Auth::user()->PERSON_ID; 
        $infobooksave = DB::table('hrd_person')
        ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->where('hrd_person.ID','=',$iduser)
        ->first();

        $year=date('Y')+543;
        $maxnumber = Bookindex::where('BOOK_YEAR_ID','=',$year)->max('BOOK_NUM_IN');

        if($maxnumber == null){
            $maxnumberuse = '0';
        }else{
            $maxnumberuse =  $maxnumber+1;
        }
      
              
        return view('manager_book.infobookreceipt_add',[
            'budgetyears' =>$budgetyear,
            'booktypes'=>$booktype,
            'bookinstants'=>$bookinstant,
            'booksecrets'=>$booksecret,
            'bookorgs'=>$bookorg,
            'infobooksave' => $infobooksave,
            'maxnumberuse' => $maxnumberuse
     
           ]);
    }



    
    public function infobookreceiptedit(Request $request,$id)
    {
        $budgetyear = DB::table('budget_year')->get();
        $booktype = DB::table('gbook_type')->get();
        $bookinstant = DB::table('gbook_instant')->get();
        $booksecret = DB::table('gbook_secret')->get();
        $bookorg = DB::table('grecord_org')->get();
        
        $iduser  = Auth::user()->PERSON_ID; 
        $infobooksave = DB::table('hrd_person')
        ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->where('hrd_person.ID','=',$iduser)
        ->first();

        $infobookedit= Bookindex::leftJoin('grecord_org','gbook_index.BOOK_ORG_ID','=','grecord_org.RECORD_ORG_ID')
        ->leftJoin('hrd_person','gbook_index.PERSON_SAVE_ID','=','hrd_person.ID')
        ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->where('gbook_index.BOOK_ID','=',$id)
        ->first();


        return view('manager_book.infobookreceipt_edit',[
            'budgetyears' =>$budgetyear,
            'booktypes'=>$booktype,
            'bookinstants'=>$bookinstant,
            'booksecrets'=>$booksecret,
            'bookorgs'=>$bookorg,
            'infobooksave' => $infobooksave,
            'infobookedit' => $infobookedit
     
           ]);
    }

    public function infobookreceiptsend(Request $request,$id)
    {
       $idbook = $id;


        $infobookreceiptview = Bookindex::leftJoin('grecord_org','gbook_index.BOOK_ORG_ID','=','grecord_org.RECORD_ORG_ID')
        ->leftJoin('hrd_person','gbook_index.PERSON_SAVE_ID','=','hrd_person.ID')
        ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->where('gbook_index.BOOK_ID','=',$idbook)
        ->first();
        
        $bookdepartment = DB::table('hrd_department')->get();
        $bookdepartmentsubsub  = DB::table('hrd_department_sub_sub')->get();

        return view('manager_book.infobookreceipt_send',[
            'infobookreceiptview' =>$infobookreceiptview,
            'idbook' => $idbook,
            'bookdepartments'=>$bookdepartment, 
            'bookdepartmentsubsubs'=>$bookdepartmentsubsub
     
           ]);
    }
    
    public function savereceipt(Request $request)
    {

        $BOOK_DATE= $request->BOOK_DATE;
        $BOOK_DATE_EXPIRE=$request->BOOK_DATE_EXPIRE;
        $DATE_SAVE=$request->DATE_SAVE;

       $BOOK_REFER_DATE_1 = $request->BOOK_REFER_DATE_1;
       $BOOK_REFER_DATE_2 = $request->BOOK_REFER_DATE_2;

        if($BOOK_DATE != ''){
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $BOOK_DATE)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0]; 
            
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $BOOKDATE= $y_st."-".$m_st."-".$d_st;
            }else{
            $BOOKDATE= null;
        }

        if($BOOK_DATE_EXPIRE != ''){
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $BOOK_DATE_EXPIRE)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0]; 
            
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $BOOKDATEEXPIRE= $y_st."-".$m_st."-".$d_st;
            }else{
            $BOOKDATEEXPIRE= null;
        }

        if($DATE_SAVE != ''){
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $DATE_SAVE)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0]; 
            
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $DATESAVE= $y_st."-".$m_st."-".$d_st;
            }else{
            $DATESAVE= null;
        }


        if($BOOK_REFER_DATE_1 != ''){
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $BOOK_REFER_DATE_1)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0]; 
            
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $BOOK_REFER_DATE_1= $y_st."-".$m_st."-".$d_st;
            }else{
            $BOOK_REFER_DATE_1= null;
        }

        if($BOOK_REFER_DATE_2 != ''){
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $BOOK_REFER_DATE_2)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0]; 
            
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $BOOK_REFER_DATE_2= $y_st."-".$m_st."-".$d_st;
            }else{
            $BOOK_REFER_DATE_2= null;
        }

if($request->BOOK_NUMBER <> '' && $request->BOOK_NAME <> ''){

    $year=date('Y')+543;
    $maxnumber = Bookindex::where('BOOK_YEAR_ID','=',$year)->max('BOOK_NUM_IN');

    if($maxnumber == null){
        $maxnumberuse = '0';
    }else{
        $maxnumberuse =  $maxnumber+1;
    }

        $addreceipt = new Bookindex(); 
        $addreceipt->BOOK_NUM_IN = $maxnumberuse;
        $addreceipt->BOOK_YEAR_ID = $request->BOOK_YEAR_ID;
        $addreceipt->BOOK_URGENT_ID = $request->BOOK_URGENT_ID;
        $addreceipt->BOOK_SECRET_ID = $request->BOOK_SECRET_ID;

        $addreceipt->BOOK_DATE = $BOOKDATE;
        $addreceipt->BOOK_DATE_EXPIRE = $BOOKDATEEXPIRE;
        $addreceipt->DATE_SAVE = $DATESAVE;
        $addreceipt->DATE_TIME_SAVE = date('Y-m-d H:i:s');
        

        $addreceipt->BOOK_NUMBER = $request->BOOK_NUMBER;
        $addreceipt->BOOK_TYPE_ID = $request->BOOK_TYPE_ID;
        $addreceipt->BOOK_NAME = $request->BOOK_NAME;
        $addreceipt->BOOK_ORG_ID = $request->BOOK_ORG_ID;
        $addreceipt->PERSON_SAVE_ID = $request->PERSON_SAVE_ID;
        $addreceipt->BOOK_DETAIL = $request->BOOK_DETAIL;
        $addreceipt->SEND_STATUS = '1';

        $addreceipt->TIME_SAVE = $request->TIME_SAVE;
        $addreceipt->BOOK_REFER_NUM_1 = $request->BOOK_REFER_NUM_1;
        $addreceipt->BOOK_REFER_DATE_1 = $BOOK_REFER_DATE_1;
        $addreceipt->BOOK_REFER_NAME_1 = $request->BOOK_REFER_NAME_1;

        $addreceipt->BOOK_REFER_NUM_2 = $request->BOOK_REFER_NUM_2;
        $addreceipt->BOOK_REFER_DATE_2 = $BOOK_REFER_DATE_2;
        $addreceipt->BOOK_REFER_NAME_2 = $request->BOOK_REFER_NAME_2;
        $addreceipt->BOOK_LINK = $request->BOOK_LINK;

        $maxid = Bookindex::max('BOOK_ID');
        $idfile = $maxid+1;
        if($request->hasFile('pdfupload')){
            $newFileName = 'receipt_'.$idfile.'.'.$request->pdfupload->extension();
              
            $request->pdfupload->storeAs('bookpdf',$newFileName,'public');

            $addreceipt->BOOK_HAVE_FILE = 'True';
            $addreceipt->BOOK_FILE_NAME = $newFileName;
        }

        if($request->hasFile('fileupload')){
            $newFileName = 'receipt2_'.$idfile.'.'.$request->fileupload->extension();
              
            $request->fileupload->storeAs('bookpdf',$newFileName,'public');

            $addreceipt->BOOK_HAVE_FILE_2 = 'True';
            $addreceipt->BOOK_FILE_NAME_2 = $newFileName;
            $addreceipt->BOOK_FILE_NAME_OLD =  $request->file('fileupload')->getClientOriginalName();
        }



        $addreceipt->save();


    }
        $bookid = $request->BOOK_ID; 

        return redirect()->route('mbook.infobookreceipt',[
            'id' => $bookid
        ]);

    }


        
    public function infobookreceiptupdate(Request $request)
    {

        $BOOK_DATE= $request->BOOK_DATE;
        $BOOK_DATE_EXPIRE=$request->BOOK_DATE_EXPIRE;
        $DATE_SAVE=$request->DATE_SAVE;

       $BOOK_REFER_DATE_1 = $request->BOOK_REFER_DATE_1;
       $BOOK_REFER_DATE_2 = $request->BOOK_REFER_DATE_2;

        if($BOOK_DATE != ''){
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $BOOK_DATE)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0]; 
            
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $BOOKDATE= $y_st."-".$m_st."-".$d_st;
            }else{
            $BOOKDATE= null;
        }

        if($BOOK_DATE_EXPIRE != ''){
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $BOOK_DATE_EXPIRE)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0]; 
            
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $BOOKDATEEXPIRE= $y_st."-".$m_st."-".$d_st;
            }else{
            $BOOKDATEEXPIRE= null;
        }

        if($DATE_SAVE != ''){
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $DATE_SAVE)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0]; 
            
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $DATESAVE= $y_st."-".$m_st."-".$d_st;
            }else{
            $DATESAVE= null;
        }


        if($BOOK_REFER_DATE_1 != ''){
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $BOOK_REFER_DATE_1)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0]; 
            
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $BOOK_REFER_DATE_1= $y_st."-".$m_st."-".$d_st;
            }else{
            $BOOK_REFER_DATE_1= null;
        }

        if($BOOK_REFER_DATE_2 != ''){
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $BOOK_REFER_DATE_2)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0]; 
            
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $BOOK_REFER_DATE_2= $y_st."-".$m_st."-".$d_st;
            }else{
            $BOOK_REFER_DATE_2= null;
        }

if($request->BOOK_NUMBER <> '' && $request->BOOK_NAME <> ''){

        $updatereceipt = Bookindex::find($request->BOOK_ID); 
        $updatereceipt->BOOK_NUM_IN = $request->BOOK_NUM_IN;
        $updatereceipt->BOOK_YEAR_ID = $request->BOOK_YEAR_ID;
        $updatereceipt->BOOK_URGENT_ID = $request->BOOK_URGENT_ID;
        $updatereceipt->BOOK_SECRET_ID = $request->BOOK_SECRET_ID;

        $updatereceipt->BOOK_DATE = $BOOKDATE;
        $updatereceipt->BOOK_DATE_EXPIRE = $BOOKDATEEXPIRE;
        $updatereceipt->DATE_SAVE = $DATESAVE;
        $updatereceipt->DATE_TIME_SAVE = date('Y-m-d H:i:s');
        

        $updatereceipt->BOOK_NUMBER = $request->BOOK_NUMBER;
        $updatereceipt->BOOK_TYPE_ID = $request->BOOK_TYPE_ID;
        $updatereceipt->BOOK_NAME = $request->BOOK_NAME;
        $updatereceipt->BOOK_ORG_ID = $request->BOOK_ORG_ID;
        $updatereceipt->PERSON_SAVE_ID = $request->PERSON_SAVE_ID;
        $updatereceipt->BOOK_DETAIL = $request->BOOK_DETAIL;
        $updatereceipt->SEND_STATUS = '1';

        $updatereceipt->TIME_SAVE = $request->TIME_SAVE;
        $updatereceipt->BOOK_REFER_NUM_1 = $request->BOOK_REFER_NUM_1;
        $updatereceipt->BOOK_REFER_DATE_1 = $BOOK_REFER_DATE_1;
        $updatereceipt->BOOK_REFER_NAME_1 = $request->BOOK_REFER_NAME_1;

        $updatereceipt->BOOK_REFER_NUM_2 = $request->BOOK_REFER_NUM_2;
        $updatereceipt->BOOK_REFER_DATE_2 = $BOOK_REFER_DATE_2;
        $updatereceipt->BOOK_REFER_NAME_2 = $request->BOOK_REFER_NAME_2;
        $updatereceipt->BOOK_LINK = $request->BOOK_LINK;
        
        $updatereceipt->BOOK_USE = $request->BOOK_USE;
    


        $idfile = $request->BOOK_ID;
        if($request->hasFile('pdfupload')){
            $newFileName = 'receipt_'.$idfile.'.'.$request->pdfupload->extension();
              
            $request->pdfupload->storeAs('bookpdf',$newFileName,'public');

            $updatereceipt->BOOK_HAVE_FILE = 'True';
            $updatereceipt->BOOK_FILE_NAME = $newFileName;        

        }

        if($request->hasFile('fileupload')){
            $newFileName = 'receipt2_'.$idfile.'.'.$request->fileupload->extension();
              
            $request->fileupload->storeAs('bookpdf',$newFileName,'public');

            $updatereceipt->BOOK_HAVE_FILE_2 = 'True';
            $updatereceipt->BOOK_FILE_NAME_2 = $newFileName;
            $updatereceipt->BOOK_FILE_NAME_OLD =  $request->file('fileupload')->getClientOriginalName();
        }

        $updatereceipt->save();
    }
        $bookid = $request->BOOK_ID; 

        return redirect()->route('mbook.infobookreceipt',[
            'id' => $bookid
        ]);

    }




    public function saverpresent(Request $request)
    {

        $bookid = $request->BOOK_ID;

        $checksendleader = DB::table('gbook_index_send_leader')
        ->where('BOOK_LD_ID','=',$bookid)
        ->count(); 
     
       

        $date = date('Y-m-d');
        $datetime = date('Y-m-d H:i:s');
        
        $info_org = DB::table('info_org')->first();


        if($checksendleader !== 0 ){

            $sendid = DB::table('gbook_index_send_leader')
            ->where('BOOK_LD_ID','=',$bookid)
            ->first(); 

            if($request->SEND_LD_DETAIL_2 == '' ){

                $SEND_LD_BY_HR_NAME_2 = '';
                $SEND_LD_DETAIL_2 = '';
                $SEND_LD_BY_HR_ID_2 = null;

            }else{
                $SEND_LD_BY_HR_NAME_2 = $request->SEND_LD_BY_HR_NAME_2 ;
                $SEND_LD_DETAIL_2 = $request->SEND_LD_DETAIL_2;
                $SEND_LD_BY_HR_ID_2 =$request->SEND_LD_BY_HR_ID_2;
            }



            $addpresent = Bookindexsendleader::find($sendid->SEND_LD_ID);
            $addpresent->BOOK_LD_ID = $request->BOOK_ID;
            $addpresent->SEND_LD_HR_ID = $info_org->ORG_LEADER_ID;
            $addpresent->SEND_LD_HR_NAME = $info_org->ORG_LEADER;
            $addpresent->SEND_LD_BY_HR_ID = $request->SEND_LD_BY_HR_ID;
            $addpresent->SEND_LD_BY_HR_NAME = $request->SEND_LD_BY_HR_NAME;
            $addpresent->SEND_LD_DETAIL = $request->SEND_LD_DETAIL;
            $addpresent->SEND_LD_BY_HR_ID_2 = $SEND_LD_BY_HR_ID_2;
            $addpresent->SEND_LD_BY_HR_NAME_2  = $SEND_LD_BY_HR_NAME_2;
            $addpresent->SEND_LD_DETAIL_2  = $SEND_LD_DETAIL_2;
    
            $addpresent->SEND_LD_DATE = $date;
            $addpresent->SEND_LD_DATE_TIME = $datetime;
            $addpresent->SEND_LD_STATUS = 'SEND';
            $addpresent->save();


        }else{
        $addpresent = new Bookindexsendleader(); 
        $addpresent->BOOK_LD_ID = $request->BOOK_ID;
        $addpresent->SEND_LD_HR_ID = $info_org->ORG_LEADER_ID;
        $addpresent->SEND_LD_HR_NAME = $info_org->ORG_LEADER;
        $addpresent->SEND_LD_BY_HR_ID = $request->SEND_LD_BY_HR_ID;
        $addpresent->SEND_LD_BY_HR_NAME = $request->SEND_LD_BY_HR_NAME;
        $addpresent->SEND_LD_DETAIL = $request->SEND_LD_DETAIL;
        $addpresent->SEND_LD_BY_HR_ID_2 = $request->SEND_LD_BY_HR_ID_2 ;
        $addpresent->SEND_LD_BY_HR_NAME_2  = $request->SEND_LD_BY_HR_NAME_2 ;
        $addpresent->SEND_LD_DETAIL_2  = $request->SEND_LD_DETAIL_2 ;

        $addpresent->SEND_LD_DATE = $date;
        $addpresent->SEND_LD_DATE_TIME = $datetime;
        $addpresent->SEND_LD_STATUS = 'SEND';
        $addpresent->save();

     
        }


        return redirect()->route('mbook.infobookreceiptcontrol',[
            'id' => $bookid
        ]);



    }

    public function saveretire(Request $request)
    {
     
        $date = date('Y-m-d');
        $datetime = date('Y-m-d H:i:s');
        
        $info_org = DB::table('info_org')->first();
        $bookid = $request->BOOK_ID;
        

                     
        $addretire = Bookindexsendleader::find($request->SEND_LD_ID);
        $addretire->TOP_LEADER_AC_ID = $info_org->ORG_LEADER_ID;
        $addretire->TOP_LEADER_AC_NAME = $info_org->ORG_LEADER;
        $addretire->TOP_LEADER_AC_CMD = $request->TOP_LEADER_AC_CMD;
        $addretire->TOP_LEADER_AC_DATE = $date;
        $addretire->TOP_LEADER_AC_DATE_TIME = $datetime;
        $addretire->SEND_LD_STATUS = 'ํYES';
        $addretire->save();

        $addpresentupstatus = Bookindex::find($request->BOOK_ID);
        $addpresentupstatus->SEND_STATUS = '3';
        $addpresentupstatus->save();
        


        return redirect()->route('mbook.infobookreceiptcontrol',[
            'id' => $bookid
        ]);
    }



      //---------------จัดการหนังสือ

      public function infobookreceiptcontrol(Request $request,$id)
      {
         $iduser  = Auth::user()->PERSON_ID; 

        $infobooksend = DB::table('hrd_person')
        ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->where('hrd_person.ID','=',$iduser)
        ->first();


         $idbook = $id;
  
  
          $infobookreceiptview = Bookindex::leftJoin('grecord_org','gbook_index.BOOK_ORG_ID','=','grecord_org.RECORD_ORG_ID')
          ->leftJoin('hrd_person','gbook_index.PERSON_SAVE_ID','=','hrd_person.ID')
          ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
          ->leftJoin('gbook_index_send_leader','gbook_index.BOOK_ID','=','gbook_index_send_leader.BOOK_LD_ID')
          ->leftJoin('gbook_instant','gbook_index.BOOK_URGENT_ID','=','gbook_instant.INSTANT_ID')
          ->where('gbook_index.BOOK_ID','=',$idbook)
          ->first();
          
          $bookdepartment = DB::table('hrd_department')->get();
          $bookdepartmentsub  = DB::table('hrd_department_sub')->get();
          $bookdepartmentsubsub  = DB::table('hrd_department_sub_sub')->get();


          //-----------ความเห็น-----------------
          $checksendleader = DB::table('gbook_index_send_leader')
          ->where('BOOK_LD_ID','=',$idbook)
          ->count(); 

          if($checksendleader !== 0 ){
            $sendleaderquery  = DB::table('gbook_index_send_leader')
            ->where('BOOK_LD_ID','=',$idbook)
            ->first();
            
            $sendleader = $sendleaderquery->TOP_LEADER_AC_CMD;


            $sendleaderdetailid = $sendleaderquery->SEND_LD_BY_HR_ID;
            $sendleaderdetail = $sendleaderquery->SEND_LD_DETAIL;
            $sendleaderhrname = $sendleaderquery->SEND_LD_BY_HR_NAME;
            $sendleaderdetailid2 = $sendleaderquery->SEND_LD_BY_HR_ID_2;
            $sendleaderdetail2 = $sendleaderquery->SEND_LD_DETAIL_2;
            $sendleaderhrname2 = $sendleaderquery->SEND_LD_BY_HR_NAME_2;


          }else{
            $sendleader = '';
            
            $sendleaderdetailid = '';
            $sendleaderdetail = '';
            $sendleaderhrname = '';
            $sendleaderdetailid2 = '';
            $sendleaderdetail2 = '';
            $sendleaderhrname2 = '';
          }
           //----------------------------

           $booksend = DB::table('gbook_send')->where('BOOK_ID','=',$idbook)->get();
           $booksendsub = DB::table('gbook_send_sub')->where('BOOK_ID','=',$idbook)->get();
           $booksendsubsub = DB::table('gbook_send_sub_sub')->where('BOOK_ID','=',$idbook)->get();
       
              //--------------------------------------------
              $infordepartment  =  DB::table('hrd_department')->get();

              $inforsenddepartments =  DB::table('gbook_send')
              ->where('BOOK_ID','=',$idbook)
              ->get(); 
   
              $checksendinfordepartment = DB::table('gbook_send')
              ->where('BOOK_ID','=',$idbook)
              ->count(); 
   

              //--------------------------------------------
              $infordepartmentsub  =  DB::table('hrd_department_sub')->get();

              $inforsenddepartmentsubs =  DB::table('gbook_send_sub')
              ->where('BOOK_ID','=',$idbook)
              ->get(); 
   
              $checksendinfordepartmentsub = DB::table('gbook_send_sub')
              ->where('BOOK_ID','=',$idbook)
              ->count(); 
   
               //--------------------------------------------
              $infordepartmentsubsub  =  DB::table('hrd_department_sub_sub')->get();

              $inforsenddepartmentsubsubs =  DB::table('gbook_send_sub_sub')
              ->where('BOOK_ID','=',$idbook)
              ->get(); 
   
              $checksendinfordepartmentsubsub = DB::table('gbook_send_sub_sub')
              ->where('BOOK_ID','=',$idbook)
              ->count(); 
   
               //--------------------------------------------
           $inforposition  =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')->orderBy('hrd_person.HR_FNAME', 'asc')->get();

           $infosendbooks =  DB::table('gbook_send_person')
           ->where('BOOK_ID','=',$idbook)
           ->where('SEND_TYPE','=','4')
           ->get(); 

           $checksendbookper = DB::table('gbook_send_person')
           ->where('BOOK_ID','=',$idbook)
           ->where('SEND_TYPE','=','4')
          ->count(); 

            //---------------ประวัติการอ่าน-----------------------------

           $inforead = DB::table('gbook_send_person')->select('HR_FNAME','HR_LNAME','HR_DEPARTMENT_SUB_NAME','gbook_send_person.updated_at')
           ->leftJoin('hrd_person','hrd_person.ID','=','gbook_send_person.HR_PERSON_ID')
           ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
           ->where('BOOK_ID','=',$idbook)
           ->where('READ_STATUS','=','true')
           ->get();


            //------------------------------------------

          return view('manager_book.infobookreceipt_control',[
              'infobookreceiptview' =>$infobookreceiptview,
              'idbook' => $idbook,
              'infobooksend' => $infobooksend,
              'bookdepartments'=>$bookdepartment, 
              'bookdepartmentsubs'=>$bookdepartmentsub,
              'bookdepartmentsubsubs'=>$bookdepartmentsubsub,
              'sendleader' => $sendleader,
              'sendleaderdetail' => $sendleaderdetail,
              'sendleaderhrname' => $sendleaderhrname,
              'sendleaderdetail2' => $sendleaderdetail2,
              'sendleaderhrname2' => $sendleaderhrname2,
              'booksends' => $booksend,
              'booksendsubs' => $booksendsub,
              'booksendsubsubs' => $booksendsubsub,
              'checksendleader'=>$checksendleader,
              'iduser' => $iduser,
              'sendleaderdetailid' => $sendleaderdetailid,
              'sendleaderdetailid2' => $sendleaderdetailid2,
              'inforpositions' => $inforposition,
              'checksendbookper' => $checksendbookper,
              'infosendbooks' => $infosendbooks,
              'infordepartments' => $infordepartment,
              'checksendinfordepartment' => $checksendinfordepartment,
              'inforsenddepartments' => $inforsenddepartments,
              'infordepartmentsubs' => $infordepartmentsub,
              'checksendinfordepartmentsub' => $checksendinfordepartmentsub,
              'inforsenddepartmentsubs' => $inforsenddepartmentsubs,
              'infordepartmentsubsubs' => $infordepartmentsubsub,
              'checksendinfordepartmentsubsub' => $checksendinfordepartmentsubsub,
              'inforsenddepartmentsubsubs' => $inforsenddepartmentsubsubs,
              'inforeads' => $inforead
       
             ]);
      }

      
    public function sendreceipt(Request $request)
    {
     
        $typesend = $request->SUBMIT;
        $bookid = $request->BOOK_ID;
        $SEND_BY_ID = $request->SEND_BY_ID;
        $SEND_BY_NAME = $request->SEND_BY_NAME;

        
        $infobookreceiptview = Bookindex::where('gbook_index.BOOK_ID','=',$bookid)->first();
        $info_org = DB::table('info_org')->where('ORG_ID','=',1)->first();

        if($typesend == 'sendhead'){

            $addpresentupstatus = Bookindex::find($bookid);
            $addpresentupstatus->SEND_STATUS = '4';
            $addpresentupstatus->save();



          $permissheards = DB::table('gsy_permis_list')->where('PERMIS_ID','=','GMB003')->get();


          foreach ($permissheards as $permissheard) {

        
                $check6 = DB::table('gbook_send_person')
                ->where('BOOK_ID','=',$bookid)
                ->where('HR_PERSON_ID','=',$permissheard->PERSON_ID)
                ->count(); 
                
            
            if($check6== 0){
        
                $add_person6 = new Booksendperson();
                $add_person6->BOOK_ID = $bookid;
                $add_person6->HR_PERSON_ID = $permissheard->PERSON_ID;
                $add_person6->READ_STATUS = 'False';
                $add_person6->SEND_BY_ID = $SEND_BY_ID;
                $add_person6->SEND_BY_NAME = $SEND_BY_NAME;
                $add_person6->SEND_DATE_TIME = date('Y-m-d H:i:s');
                $add_person6->SEND_TYPE = '4';
                $add_person6->save();
        
            }
        
        
            }


        }else{
                                   if($request->row3 != '' || $request->row3 != null ||
                                   $request->row4 != '' || $request->row3 != null ||
                                   $request->row5 != '' || $request->row3 != null ||
                                   $request->MEMBER_ID != '' || $request->MEMBER_ID != null  
                                   ){

                              

                                    $checkstatus1 =Bookindex::where('BOOK_ID','=',$bookid)
                                    ->where('SEND_STATUS','=','3')
                                    ->count(); 

                                    $checkstatus2 =Bookindex::where('BOOK_ID','=',$bookid)
                                    ->where('SEND_STATUS','=','4')
                                    ->count(); 

                                      if($checkstatus1== 0 && $checkstatus2== 0){

                                        $addpresentupstatus = Bookindex::find($bookid);
                                        $addpresentupstatus->SEND_STATUS = '2';
                                        $addpresentupstatus->save();
  
                                      }
                                       

                                   }
                                
                                        Booksend::where('BOOK_ID','=',$bookid)->delete(); 
                                        Booksendsub::where('BOOK_ID','=',$bookid)->delete();
                                        Booksendsubsub::where('BOOK_ID','=',$bookid)->delete();  
                                
                                    if($request->row3 != '' || $request->row3 != null){
                                        $row3 = $request->row3;
                                        $number_3 =count($row3);
                                        $count_3 = 0;
                                        for($count_3 = 0; $count_3 < $number_3; $count_3++)
                                        {  
                                        
                                        $add_3 = new Booksend();
                                        $add_3->BOOK_ID = $bookid;
                                        $add_3->HR_DEPARTMENT_ID = $row3[$count_3];
                                        $add_3->save(); 
                                        
                                        $inforpersonusers =  Person::where('HR_DEPARTMENT_ID','=',$row3[$count_3])->get(); 
                                
                                        foreach($inforpersonusers as $inforpersonuser){
                                                
                                            $check3 = DB::table('gbook_send_person')
                                            ->where('BOOK_ID','=',$bookid)
                                            ->where('HR_PERSON_ID','=',$inforpersonuser->ID)
                                            ->count(); 
                                
                                            if($check3== 0){
                                                    $add_person3 = new Booksendperson();
                                                    $add_person3->BOOK_ID = $bookid;
                                                    $add_person3->HR_PERSON_ID = $inforpersonuser->ID;
                                                    $add_person3->READ_STATUS = 'False';
                                                    $add_person3->SEND_BY_ID = $SEND_BY_ID;
                                                    $add_person3->SEND_BY_NAME = $SEND_BY_NAME;
                                                    $add_person3->SEND_DATE_TIME = date('Y-m-d H:i:s');
                                                    $add_person3->SEND_TYPE = '1';
                                                    $add_person3->save();
                                            }
                                        }
                                
                                
                                        }
                                    }
                                
                                    if($request->row4 != '' || $request->row4 != null){
                                
                                        $row4 = $request->row4;
                                        $number_4 =count($row4);
                                        $count_4 = 0;
                                        for($count_4 = 0; $count_4 < $number_4; $count_4++)
                                        {  

                                        $add_4 = new Booksendsub();
                                        $add_4->BOOK_ID = $bookid;
                                        $add_4->HR_DEPARTMENT_SUB_ID = $row4[$count_4];
                                        $add_4->save(); 
                                
                                        //------เช็คตัวซ้ำก่อน------
                                
                                        $inforpersonusers_4 =  Person::where('HR_DEPARTMENT_SUB_ID','=',$row4[$count_4])->get(); 
                                
                                        foreach($inforpersonusers_4 as $inforpersonuser_4){
                                                
                                                $check4 = DB::table('gbook_send_person')
                                                ->where('BOOK_ID','=',$bookid)
                                                ->where('HR_PERSON_ID','=',$inforpersonuser_4->ID)
                                                ->count(); 
                                                
                                                
                                                if($check4== 0){
                                                    $add_person4 = new Booksendperson();
                                                    $add_person4->BOOK_ID = $bookid;
                                                    $add_person4->HR_PERSON_ID = $inforpersonuser_4->ID;
                                                    $add_person4->READ_STATUS = 'False';
                                                    $add_person4->SEND_BY_ID = $SEND_BY_ID;
                                                    $add_person4->SEND_BY_NAME = $SEND_BY_NAME;
                                                    $add_person4->SEND_DATE_TIME = date('Y-m-d H:i:s');
                                                    $add_person4->SEND_TYPE = '2';
                                                    $add_person4->save();
                                                }
                                        }
                                
                                        }
                                    }
                                
                                    if($request->row5 != '' || $request->row5 != null){
                                        $row5 = $request->row5;
                                        $number_5 =count($row5);
                                        $count_5 = 0;
                                        for($count_5 = 0; $count_5 < $number_5; $count_5++)
                                        {  
                 
                                        
                                        $add_5 = new Booksendsubsub();
                                        $add_5->BOOK_ID = $bookid;
                                        $add_5->HR_DEPARTMENT_SUB_SUB_ID = $row5[$count_5];
                                        $add_5->save(); 
                                
                                            //------เช็คตัวซ้ำก่อน------
                                
                                            $inforpersonusers_5 =  Person::where('HR_DEPARTMENT_SUB_SUB_ID','=',$row5[$count_5])->get(); 
                                
                                            foreach($inforpersonusers_5 as $inforpersonuser_5){
                                                    
                                                $check5 = DB::table('gbook_send_person')
                                                ->where('BOOK_ID','=',$bookid)
                                                ->where('HR_PERSON_ID','=',$inforpersonuser_5->ID)
                                                ->count(); 
                                                
                                                
                                                if($check5== 0){
                                                    $add_person5 = new Booksendperson();
                                                    $add_person5->BOOK_ID = $bookid;
                                                    $add_person5->HR_PERSON_ID = $inforpersonuser_5->ID;
                                                    $add_person5->READ_STATUS = 'False';
                                                    $add_person5->SEND_BY_ID = $SEND_BY_ID;
                                                    $add_person5->SEND_BY_NAME = $SEND_BY_NAME;
                                                    $add_person5->SEND_DATE_TIME = date('Y-m-d H:i:s');
                                                    $add_person5->SEND_TYPE = '3';
                                                    $add_person5->save();
                                                }
                                            }
                                
                                            
                                
                                        }
                                    }
                                    
                                  

                                    if($request->MEMBER_ID != '' || $request->MEMBER_ID != null){
                                
                                    $MEMBER_ID = $request->MEMBER_ID;
                                    $number =count($MEMBER_ID);
                                    $count = 0;

                                     $checkinfocount =  DB::table('gbook_send_person')
                                     ->where('BOOK_ID','=',$bookid)
                                     ->where('SEND_TYPE','=','4')
                                     ->count();   
                                     
                                     if($checkinfocount !== $number){
                                        DB::table('gbook_send_person')
                                        ->where('BOOK_ID','=',$bookid)
                                        ->where('SEND_TYPE','=','4')
                                        ->delete();   
                                     }

                                    for($count = 0; $count < $number; $count++)
                                    {  
                                
                                         $check6 = DB::table('gbook_send_person')
                                         ->where('BOOK_ID','=',$bookid)
                                         ->where('HR_PERSON_ID','=',$MEMBER_ID[$count])
                                         ->where('SEND_TYPE','=','4')
                                         ->count(); 
                                        
                                    
                                    if($check6 == 0){
                                
                                        $add_person6 = new Booksendperson();
                                        $add_person6->BOOK_ID = $bookid;
                                        $add_person6->HR_PERSON_ID = $MEMBER_ID[$count];
                                        $add_person6->READ_STATUS = 'False';
                                        $add_person6->SEND_BY_ID = $SEND_BY_ID;
                                        $add_person6->SEND_BY_NAME = $SEND_BY_NAME;
                                        $add_person6->SEND_DATE_TIME = date('Y-m-d H:i:s');
                                        $add_person6->SEND_TYPE = '4';
                                        $add_person6->save();




                                             //-----------------line notify---------------------------------------------
                                             $infobookindex = Bookindex::find($bookid);
            
                                               $header = "งานสารบรรณ";
                                               $message = $header.
                                               "\n"."รหัส : " . $bookid .  
                                               "\n"."เลขหนังสือ : " . $infobookindex->BOOK_NUMBER .
                                               "\n"."เรื่อง : " . $infobookindex->BOOK_NAME .  
                                               "\n"."วันที่ : " .date('Y-m-d H:i:s').  
                                               "\n"."ผู้ส่ง :".$SEND_BY_NAME.    
                                               "\n"."รายละเอียด >> ".$info_org->ORG_WEBSITE."/bookdetail/".$bookid;
                                               
                                           
                                               $name = DB::table('hrd_person')->where('ID','=',$MEMBER_ID[$count])->first();        
                                                $test =$name->HR_LINE;
                                       
                                               $chOne = curl_init();
                                               curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
                                               curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0);
                                               curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0);
                                               curl_setopt( $chOne, CURLOPT_POST, 1);
                                               curl_setopt( $chOne, CURLOPT_POSTFIELDS, $message);
                                               curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=$message");
                                               curl_setopt( $chOne, CURLOPT_FOLLOWLOCATION, 1);
                                               $headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$test.'', );
                                               curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
                                               curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1);
                                               $result = curl_exec( $chOne );
                                               if(curl_error($chOne)) { echo 'error:' . curl_error($chOne); }
                                               else { $result_ = json_decode($result, true);
                                               echo "status : ".$result_['status']; echo "message : ". $result_['message']; }
                                               curl_close( $chOne );
                                             
                                    }
                                
                                
                                    }
                                
                                
                                }


        }



                                    
     

        return redirect()->route('mbook.infobookreceipt');
    }


      //===============================หนังสือส่ง==============================

      public function infobookout()
      {
        $date = date('Y-m-d');
          $infobookout = Bookindexout::where('DATE_SAVE','=',$date)
          ->orderBy('BOOK_ID', 'desc') 
          ->get();
  
          $infobookstatus1 = DB::table('gbook_status')
          ->where('BOOK_STATUS_ID','=','1')
          ->first();
          $infobookstatus2 = DB::table('gbook_status')
          ->where('BOOK_STATUS_ID','=','2')
          ->first();
          $infobookstatus3 = DB::table('gbook_status')
          ->where('BOOK_STATUS_ID','=','3')
          ->first();

          $displaydate_bigen = '';
          $displaydate_end = '';
          $search = '';
  
          return view('manager_book.infobookout',[
              'infobookouts' =>$infobookout,
              'displaydate_bigen'=> $displaydate_bigen,
              'displaydate_end'=> $displaydate_end,
              'search'=> $search,
              
             ]);
      }


      public function infobookoutsearch(Request $request)
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
  
  
          if($date_bigen_checks != $dates || $date_end_checks != $dates){
  
  
              $from = date($displaydate_bigen);
              $to = date($displaydate_end);
  
            
                  $infobookout=  Bookindexout::leftJoin('grecord_org','gbook_index_out.BOOK_ORG_ID','=','grecord_org.RECORD_ORG_ID')
                  ->leftJoin('hrd_person','gbook_index_out.PERSON_SAVE_ID','=','hrd_person.ID')
                  ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                  ->where(function($q) use ($search){
                              $q->where('BOOK_NUM_OUT','like','%'.$search.'%');
                              $q->orwhere('BOOK_NUMBER','like','%'.$search.'%');
                              $q->orwhere('BOOK_NAME','like','%'.$search.'%');
        
                  })
                  ->WhereBetween('DATE_SAVE',[$from,$to]) 
                  ->orderBy('gbook_index_out.BOOK_NUM_OUT', 'desc')    
                  ->get();
          
      
  
           }else{
  
          
                $yearbudget = date("Y")+543;
            
           
                  $infobookout=  Bookindexout::where('gbook_index_out.BOOK_YEAR_ID','=',$yearbudget)
                  ->where(function($q) use ($search){
                              $q->where('BOOK_NUM_OUT','like','%'.$search.'%');
                              $q->orwhere('BOOK_NUMBER','like','%'.$search.'%');
                              $q->orwhere('BOOK_NAME','like','%'.$search.'%');
        
                  })
                  ->orderBy('gbook_index_out.BOOK_NUM_OUT', 'desc')    
                  ->get();
          
          }
          
  
  
  
          $iduser  = Auth::user()->PERSON_ID; 
          $infobooksend = DB::table('hrd_person')
          ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
          ->where('hrd_person.ID','=',$iduser)
          ->first();
  
          $infobookstatus1 = DB::table('gbook_status')
          ->where('BOOK_STATUS_ID','=','1')
          ->first();
          $infobookstatus2 = DB::table('gbook_status')
          ->where('BOOK_STATUS_ID','=','2')
          ->first();
          $infobookstatus3 = DB::table('gbook_status')
          ->where('BOOK_STATUS_ID','=','3')
          ->first();
        
    
          
          return view('manager_book.infobookout',[
              'infobookouts' =>$infobookout,
              'infobooksend'=>   $infobooksend,
              'displaydate_bigen'=> $displaydate_bigen, 
              'displaydate_end'=> $displaydate_end,
              'search'=> $search
              
            ]);

}

      public function infobookoutinsert()
      {
          $budgetyear = DB::table('budget_year')->get();
          $booktype = DB::table('gbook_type')->get();
          $bookinstant = DB::table('gbook_instant')->get();
          $booksecret = DB::table('gbook_secret')->get();
          $bookorg = DB::table('grecord_org')->get();
          
          $iduser  = Auth::user()->PERSON_ID; 
          $infobooksave = DB::table('hrd_person')
          ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
          ->where('hrd_person.ID','=',$iduser)
          ->first();
  
  
          return view('manager_book.infobookout_add',[
              'budgetyears' =>$budgetyear,
              'booktypes'=>$booktype,
              'bookinstants'=>$bookinstant,
              'booksecrets'=>$booksecret,
              'bookorgs'=>$bookorg,
              'infobooksave' => $infobooksave
       
             ]);
      }


      public function saverout(Request $request)
      {
          $BOOK_DATE= $request->BOOK_DATE;
          $BOOK_DATE_EXPIRE=$request->BOOK_DATE_EXPIRE;
          $DATE_SAVE=$request->DATE_SAVE;
  
          if($BOOK_DATE != ''){
              $STARTDAY = Carbon::createFromFormat('d/m/Y', $BOOK_DATE)->format('Y-m-d');
              $date_arrary_st=explode("-",$STARTDAY);  
              $y_sub_st = $date_arrary_st[0]; 
              
              if($y_sub_st >= 2500){
                  $y_st = $y_sub_st-543;
              }else{
                  $y_st = $y_sub_st;
              }
              $m_st = $date_arrary_st[1];
              $d_st = $date_arrary_st[2];  
              $BOOKDATE= $y_st."-".$m_st."-".$d_st;
              }else{
              $BOOKDATE= null;
          }
  
          if($BOOK_DATE_EXPIRE != ''){
              $STARTDAY = Carbon::createFromFormat('d/m/Y', $BOOK_DATE_EXPIRE)->format('Y-m-d');
              $date_arrary_st=explode("-",$STARTDAY);  
              $y_sub_st = $date_arrary_st[0]; 
              
              if($y_sub_st >= 2500){
                  $y_st = $y_sub_st-543;
              }else{
                  $y_st = $y_sub_st;
              }
              $m_st = $date_arrary_st[1];
              $d_st = $date_arrary_st[2];  
              $BOOKDATEEXPIRE= $y_st."-".$m_st."-".$d_st;
              }else{
              $BOOKDATEEXPIRE= null;
          }
  
          if($DATE_SAVE != ''){
              $STARTDAY = Carbon::createFromFormat('d/m/Y', $DATE_SAVE)->format('Y-m-d');
              $date_arrary_st=explode("-",$STARTDAY);  
              $y_sub_st = $date_arrary_st[0]; 
              
              if($y_sub_st >= 2500){
                  $y_st = $y_sub_st-543;
              }else{
                  $y_st = $y_sub_st;
              }
              $m_st = $date_arrary_st[1];
              $d_st = $date_arrary_st[2];  
              $DATESAVE= $y_st."-".$m_st."-".$d_st;
              }else{
              $DATESAVE= null;
          }
  
  
          $addout = new Bookindexout(); 
          $addout->BOOK_NUM_OUT = $request->BOOK_NUM_OUT;
          $addout->BOOK_YEAR_ID = $request->BOOK_YEAR_ID;
          $addout->BOOK_URGENT_ID = $request->BOOK_URGENT_ID;
          $addout->BOOK_SECRET_ID = $request->BOOK_SECRET_ID;
  
          $addout->BOOK_DATE = $BOOKDATE;
          $addout->BOOK_DATE_EXPIRE = $BOOKDATEEXPIRE;
          $addout->DATE_SAVE = $DATESAVE;
  
          $addout->BOOK_NUMBER = $request->BOOK_NUMBER;
          $addout->BOOK_TYPE_ID = $request->BOOK_TYPE_ID;
          $addout->BOOK_NAME = $request->BOOK_NAME;
          $addout->BOOK_ORG_TO_ID = $request->BOOK_ORG_TO_ID;
          $addout->PERSON_SAVE_ID = $request->PERSON_SAVE_ID;
          $addout->BOOK_DETAIL = $request->BOOK_DETAIL;
    
  
          $maxid = Bookindexout::max('BOOK_ID');
          $idfile = $maxid+1;
          if($request->hasFile('pdfupload')){
              $newFileName = 'out_'.$idfile.'.'.$request->pdfupload->extension();
                
              $request->pdfupload->storeAs('bookpdf',$newFileName,'public');
  
              $addout->BOOK_HAVE_FILE = 'True';
              $addout->BOOK_FILE_NAME = $newFileName;
              
  
          }
  
          $addout->save();
  
          $bookid = $request->BOOK_ID; 
  
          return redirect()->route('mbook.infobookout',[
              'id' => $bookid
          ]);
      }



      public function infobookoutcontrol(Request $request,$id)
      {

         $idbook = $id;
  
          $infobookoutview = Bookindexout::leftJoin('grecord_org','gbook_index_out.BOOK_ORG_TO_ID','=','grecord_org.RECORD_ORG_ID')
          ->leftJoin('hrd_person','gbook_index_out.PERSON_SAVE_ID','=','hrd_person.ID')
          ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
          ->leftJoin('gbook_instant','gbook_index_out.BOOK_URGENT_ID','=','gbook_instant.INSTANT_ID')
          ->where('gbook_index_out.BOOK_ID','=',$idbook)
          ->first();

          return view('manager_book.infobookout_control',[
              'infobookoutview' =>$infobookoutview,
              'idbook' => $idbook
          
             ]);
      }
  




      //===============================หนังสือภายใน==============================

      public function infobookinside(Request $request)
      {
          if(!empty($request->_token)){
            $yearbudget = $request->BUDGET_YEAR;
            $search = $request->get('search');
            $status = $request->SEND_STATUS;
            $datebigin = $request->get('DATE_BIGIN');
            $dateend = $request->get('DATE_END');
            session([
                'manager_book/bookinside.yearbudget' => $yearbudget,
                'manager_book/bookinside.search' => $search,
                'manager_book/bookinside.status' => $status,
                'manager_book/bookinside.datebigin' => $datebigin,
                'manager_book/bookinside.dateend' => $dateend
            ]);
          }elseif(!empty(session('manager_book/bookinside'))){
            $yearbudget = session('manager_book/bookinside.yearbudget');
            $search = session('manager_book/bookinside.search');
            $status = session('manager_book/bookinside.status');
            $datebigin = session('manager_book/bookinside.datebigin');
            $dateend = session('manager_book/bookinside.dateend');
          }else{
            $yearbudget = date('Y')+543;
            $search = '';
            $status = '';
            $datebigin = date('1/m/Y');
            $dateend   = date('d/m/Y', strtotime(date('Y-m-1'). '+1month -1days'));
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
                $infobookinside=  Bookindexinside::leftJoin('grecord_org','gbook_index_inside.BOOK_ORG_ID','=','grecord_org.RECORD_ORG_ID')
                ->leftJoin('hrd_person','gbook_index_inside.PERSON_SAVE_ID','=','hrd_person.ID')
                ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                ->leftJoin('gbook_send_inside_leader','gbook_index_inside.BOOK_ID','=','gbook_send_inside_leader.BOOK_LD_ID')
                ->where('BOOK_USE','=','true')
                ->where(function($q) use ($search){
                            $q->where('BOOK_NUM_IN','like','%'.$search.'%');
                            $q->orwhere('BOOK_NUMBER','like','%'.$search.'%');
                            $q->orwhere('BOOK_NAME','like','%'.$search.'%');
                            $q->orwhere('RECORD_ORG_NAME','like','%'.$search.'%');
                            $q->orwhere('BOOK_DETAIL','like','%'.$search.'%');
      
      
                })
                ->WhereBetween('DATE_SAVE',[$from,$to]) 
                ->orderBy('gbook_index_inside.BOOK_ID', 'desc')    
                ->get();
            }else{
                $infobookinside=  Bookindexinside::leftJoin('grecord_org','gbook_index_inside.BOOK_ORG_ID','=','grecord_org.RECORD_ORG_ID')
                ->leftJoin('hrd_person','gbook_index_inside.PERSON_SAVE_ID','=','hrd_person.ID')
                ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                ->leftJoin('gbook_send_inside_leader','gbook_index_inside.BOOK_ID','=','gbook_send_inside_leader.BOOK_LD_ID')
                ->where('BOOK_USE','=','true')   
                ->where('SEND_STATUS','=',$status)
                    ->where(function($q) use ($search){
                        $q->where('BOOK_NUM_IN','like','%'.$search.'%');
                        $q->orwhere('BOOK_NUMBER','like','%'.$search.'%');
                        $q->orwhere('BOOK_NAME','like','%'.$search.'%');
                        $q->orwhere('RECORD_ORG_NAME','like','%'.$search.'%');
                        $q->orwhere('BOOK_DETAIL','like','%'.$search.'%');
                    })
                    ->WhereBetween('DATE_SAVE',[$from,$to]) 
                    ->orderBy('gbook_index_inside.BOOK_ID', 'desc')    
                    ->get();

            }
    
        $iduser  = Auth::user()->PERSON_ID; 
        $infobooksend = DB::table('hrd_person')
        ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->where('hrd_person.ID','=',$iduser)
        ->first();

        $infobookstatus1 = DB::table('gbook_status')
        ->where('BOOK_STATUS_ID','=','1')
        ->first();
        $infobookstatus2 = DB::table('gbook_status')
        ->where('BOOK_STATUS_ID','=','2')
        ->first();
        $infobookstatus3 = DB::table('gbook_status')
        ->where('BOOK_STATUS_ID','=','3')
        ->first();
      
        $infobook_sendstatus = DB::table('gbook_status')
        ->get();
  
        $budget = getYearAmount();
        $year_id = $yearbudget;

        return view('manager_book.infobookinside',[
            'infobookinsides' =>$infobookinside,
            'infobookstatus1'=> $infobookstatus1, 
            'infobookstatus2'=> $infobookstatus2,
            'infobookstatus3'=> $infobookstatus3,
            'infobooksend'=>   $infobooksend,
            'infobook_sendstatuss'=> $infobook_sendstatus,
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id,
            
          ]);
      }

    public function infobookinsidesearch(Request $request)
    {
        $yearbudget = $request->BUDGET_YEAR;
        $search = $request->get('search');
        $status = $request->SEND_STATUS;
        $datebigin = $request->get('DATE_BIGIN');
        $dateend = $request->get('DATE_END');

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
                $infobookinside=  Bookindexinside::leftJoin('grecord_org','gbook_index_inside.BOOK_ORG_ID','=','grecord_org.RECORD_ORG_ID')
                ->leftJoin('hrd_person','gbook_index_inside.PERSON_SAVE_ID','=','hrd_person.ID')
                ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                ->leftJoin('gbook_send_inside_leader','gbook_index_inside.BOOK_ID','=','gbook_send_inside_leader.BOOK_LD_ID')
                ->where('BOOK_USE','=','true')
                ->where(function($q) use ($search){
                            $q->where('BOOK_NUM_IN','like','%'.$search.'%');
                            $q->orwhere('BOOK_NUMBER','like','%'.$search.'%');
                            $q->orwhere('BOOK_NAME','like','%'.$search.'%');
                            $q->orwhere('RECORD_ORG_NAME','like','%'.$search.'%');
      
      
                })
                ->WhereBetween('DATE_SAVE',[$from,$to]) 
                ->orderBy('gbook_index_inside.BOOK_ID', 'desc')    
                ->get();
            }else{
                $infobookinside=  Bookindexinside::leftJoin('grecord_org','gbook_index_inside.BOOK_ORG_ID','=','grecord_org.RECORD_ORG_ID')
                ->leftJoin('hrd_person','gbook_index_inside.PERSON_SAVE_ID','=','hrd_person.ID')
                ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                ->leftJoin('gbook_send_inside_leader','gbook_index_inside.BOOK_ID','=','gbook_send_inside_leader.BOOK_LD_ID')
                ->where('BOOK_USE','=','true')   
                ->where('SEND_STATUS','=',$status)
                    ->where(function($q) use ($search){
                        $q->where('BOOK_NUM_IN','like','%'.$search.'%');
                        $q->orwhere('BOOK_NUMBER','like','%'.$search.'%');
                        $q->orwhere('BOOK_NAME','like','%'.$search.'%');
                        $q->orwhere('RECORD_ORG_NAME','like','%'.$search.'%');
                    })
                    ->WhereBetween('DATE_SAVE',[$from,$to]) 
                    ->orderBy('gbook_index_inside.BOOK_ID', 'desc')    
                    ->get();

            }
    
        $iduser  = Auth::user()->PERSON_ID; 
        $infobooksend = DB::table('hrd_person')
        ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->where('hrd_person.ID','=',$iduser)
        ->first();

        $infobookstatus1 = DB::table('gbook_status')
        ->where('BOOK_STATUS_ID','=','1')
        ->first();
        $infobookstatus2 = DB::table('gbook_status')
        ->where('BOOK_STATUS_ID','=','2')
        ->first();
        $infobookstatus3 = DB::table('gbook_status')
        ->where('BOOK_STATUS_ID','=','3')
        ->first();
      
        $infobook_sendstatus = DB::table('gbook_status')
        ->get();
  
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $year_id = $yearbudget;

        return view('manager_book.infobookinside',[
            'infobookinsides' =>$infobookinside,
            'infobookstatus1'=> $infobookstatus1, 
            'infobookstatus2'=> $infobookstatus2,
            'infobookstatus3'=> $infobookstatus3,
            'infobooksend'=>   $infobooksend,
            'infobook_sendstatuss'=> $infobook_sendstatus,
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id,
            
          ]);
    }


    public function bookinside_excel(Request $request, $datebegin, $dateen, $status, $search)
    {

        $from = $datebegin;
        $to   = $dateen;

        if ($search == 'null') {
            $search = '';
        }

        if ($status == 'null') {
            $status = '';
        }


            if($status == null){
                $infobookinside=  Bookindexinside::leftJoin('grecord_org','gbook_index_inside.BOOK_ORG_ID','=','grecord_org.RECORD_ORG_ID')
                ->leftJoin('hrd_person','gbook_index_inside.PERSON_SAVE_ID','=','hrd_person.ID')
                ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                ->leftJoin('gbook_send_inside_leader','gbook_index_inside.BOOK_ID','=','gbook_send_inside_leader.BOOK_LD_ID')
                ->where('BOOK_USE','=','true')
                ->where(function($q) use ($search){
                            $q->where('BOOK_NUM_IN','like','%'.$search.'%');
                            $q->orwhere('BOOK_NUMBER','like','%'.$search.'%');
                            $q->orwhere('BOOK_NAME','like','%'.$search.'%');
                            $q->orwhere('RECORD_ORG_NAME','like','%'.$search.'%');
                            $q->orwhere('BOOK_DETAIL','like','%'.$search.'%');
                })
                ->WhereBetween('DATE_SAVE',[$from,$to]) 
                ->orderBy('gbook_index_inside.BOOK_ID', 'desc')    
                ->get();
            }else{
                $infobookinside=  Bookindexinside::leftJoin('grecord_org','gbook_index_inside.BOOK_ORG_ID','=','grecord_org.RECORD_ORG_ID')
                ->leftJoin('hrd_person','gbook_index_inside.PERSON_SAVE_ID','=','hrd_person.ID')
                ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                ->leftJoin('gbook_send_inside_leader','gbook_index_inside.BOOK_ID','=','gbook_send_inside_leader.BOOK_LD_ID')
                ->where('BOOK_USE','=','true')   
                ->where('SEND_STATUS','=',$status)
                    ->where(function($q) use ($search){
                        $q->where('BOOK_NUM_IN','like','%'.$search.'%');
                        $q->orwhere('BOOK_NUMBER','like','%'.$search.'%');
                        $q->orwhere('BOOK_NAME','like','%'.$search.'%');
                        $q->orwhere('RECORD_ORG_NAME','like','%'.$search.'%');
                        $q->orwhere('BOOK_DETAIL','like','%'.$search.'%');
                    })
                    ->WhereBetween('DATE_SAVE',[$from,$to]) 
                    ->orderBy('gbook_index_inside.BOOK_ID', 'desc')    
                    ->get();

            }
    
        $iduser  = Auth::user()->PERSON_ID; 
        $infobooksend = DB::table('hrd_person')
        ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->where('hrd_person.ID','=',$iduser)
        ->first();

        $infobookstatus1 = DB::table('gbook_status')
        ->where('BOOK_STATUS_ID','=','1')
        ->first();
        $infobookstatus2 = DB::table('gbook_status')
        ->where('BOOK_STATUS_ID','=','2')
        ->first();
        $infobookstatus3 = DB::table('gbook_status')
        ->where('BOOK_STATUS_ID','=','3')
        ->first();
      
        $infobook_sendstatus = DB::table('gbook_status')
        ->get();
  
        $budget = getYearAmount();
     

        return view('manager_book.infobookinside_excel',[
            'infobookinsides' =>$infobookinside,
            'infobookstatus1'=> $infobookstatus1, 
            'infobookstatus2'=> $infobookstatus2,
            'infobookstatus3'=> $infobookstatus3,
            'infobook_sendstatuss'=> $infobook_sendstatus,
            'budgets' =>  $budget,
          
           ]);
    }


      public function infobookinsideinsert()
      {
          $budgetyear = DB::table('budget_year')->get();
          $booktype = DB::table('gbook_type')->get();
          $bookinstant = DB::table('gbook_instant')->get();
          $booksecret = DB::table('gbook_secret')->get();
          $bookorg = DB::table('grecord_org')->get();
          
          $iduser  = Auth::user()->PERSON_ID; 
          $infobooksave = DB::table('hrd_person')
          ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
          ->where('hrd_person.ID','=',$iduser)
          ->first();
  
          $year=date('Y')+543;
          $maxnumber = Bookindexinside::where('BOOK_YEAR_ID','=',$year)->max('BOOK_NUM_IN');

          if($maxnumber == null){
            $maxnumberuse =  '0';
          }else{
            $maxnumberuse =  $maxnumber+1;
          }
         
  
          return view('manager_book.infobookinside_add',[
              'budgetyears' =>$budgetyear,
              'booktypes'=>$booktype,
              'bookinstants'=>$bookinstant,
              'booksecrets'=>$booksecret,
              'bookorgs'=>$bookorg,
              'infobooksave' => $infobooksave,
              'maxnumberuse' => $maxnumberuse
       
             ]);
      }


      public function infobookoutsave(Request $request)
      {
          $BOOK_DATE= $request->BOOK_DATE;
          $BOOK_DATE_EXPIRE=$request->BOOK_DATE_EXPIRE;
          $DATE_SAVE=$request->DATE_SAVE;

       $BOOK_REFER_DATE_1 = $request->BOOK_REFER_DATE_1;
       $BOOK_REFER_DATE_2 = $request->BOOK_REFER_DATE_2;
  
          if($BOOK_DATE != ''){
              $STARTDAY = Carbon::createFromFormat('d/m/Y', $BOOK_DATE)->format('Y-m-d');
              $date_arrary_st=explode("-",$STARTDAY);  
              $y_sub_st = $date_arrary_st[0]; 
              
              if($y_sub_st >= 2500){
                  $y_st = $y_sub_st-543;
              }else{
                  $y_st = $y_sub_st;
              }
              $m_st = $date_arrary_st[1];
              $d_st = $date_arrary_st[2];  
              $BOOKDATE= $y_st."-".$m_st."-".$d_st;
              }else{
              $BOOKDATE= null;
          }
  
          if($BOOK_DATE_EXPIRE != ''){
              $STARTDAY = Carbon::createFromFormat('d/m/Y', $BOOK_DATE_EXPIRE)->format('Y-m-d');
              $date_arrary_st=explode("-",$STARTDAY);  
              $y_sub_st = $date_arrary_st[0]; 
              
              if($y_sub_st >= 2500){
                  $y_st = $y_sub_st-543;
              }else{
                  $y_st = $y_sub_st;
              }
              $m_st = $date_arrary_st[1];
              $d_st = $date_arrary_st[2];  
              $BOOKDATEEXPIRE= $y_st."-".$m_st."-".$d_st;
              }else{
              $BOOKDATEEXPIRE= null;
          }
  
          if($DATE_SAVE != ''){
              $STARTDAY = Carbon::createFromFormat('d/m/Y', $DATE_SAVE)->format('Y-m-d');
              $date_arrary_st=explode("-",$STARTDAY);  
              $y_sub_st = $date_arrary_st[0]; 
              
              if($y_sub_st >= 2500){
                  $y_st = $y_sub_st-543;
              }else{
                  $y_st = $y_sub_st;
              }
              $m_st = $date_arrary_st[1];
              $d_st = $date_arrary_st[2];  
              $DATESAVE= $y_st."-".$m_st."-".$d_st;
              }else{
              $DATESAVE= date('Y-m-d');
          }


          if($BOOK_REFER_DATE_1 != ''){
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $BOOK_REFER_DATE_1)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0]; 
            
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $BOOK_REFER_DATE_1= $y_st."-".$m_st."-".$d_st;
            }else{
            $BOOK_REFER_DATE_1= null;
        }

        if($BOOK_REFER_DATE_2 != ''){
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $BOOK_REFER_DATE_2)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0]; 
            
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $BOOK_REFER_DATE_2= $y_st."-".$m_st."-".$d_st;
            }else{
            $BOOK_REFER_DATE_2= null;
        }
  
      



    $year=date('Y')+543;
    $maxnumber = Bookindexinside::where('BOOK_YEAR_ID','=',$year)->max('BOOK_NUM_IN');

    if($maxnumber == null){
      $maxnumberuse =  '0';
    }else{
      $maxnumberuse =  $maxnumber+1;
    }


          $addinside = new Bookindexinside(); 
          $addinside->BOOK_NUM_IN = $maxnumberuse;
          $addinside->BOOK_YEAR_ID = $request->BOOK_YEAR_ID;
          $addinside->BOOK_URGENT_ID = $request->BOOK_URGENT_ID;
          $addinside->BOOK_SECRET_ID = $request->BOOK_SECRET_ID;
  
          $addinside->BOOK_DATE = $BOOKDATE;
          $addinside->BOOK_DATE_EXPIRE = $BOOKDATEEXPIRE;
          $addinside->DATE_SAVE = $DATESAVE;
          $addinside->DATE_TIME_SAVE = date('Y-m-d H:i:s');
  
          $addinside->BOOK_NUMBER = $request->BOOK_NUMBER;
          $addinside->BOOK_TYPE_ID = $request->BOOK_TYPE_ID;
          $addinside->BOOK_NAME = $request->BOOK_NAME;
          $addinside->BOOK_ORG_ID = $request->BOOK_ORG_ID;
          $addinside->PERSON_SAVE_ID = $request->PERSON_SAVE_ID;
          $addinside->BOOK_DETAIL = $request->BOOK_DETAIL;
          $addinside->SEND_STATUS = '1';

          $addinside->TIME_SAVE = $request->TIME_SAVE;
          $addinside->BOOK_REFER_NUM_1 = $request->BOOK_REFER_NUM_1;
          $addinside->BOOK_REFER_DATE_1 = $BOOK_REFER_DATE_1;
          $addinside->BOOK_REFER_NAME_1 = $request->BOOK_REFER_NAME_1;
  
          $addinside->BOOK_REFER_NUM_2 = $request->BOOK_REFER_NUM_2;
          $addinside->BOOK_REFER_DATE_2 = $BOOK_REFER_DATE_2;
          $addinside->BOOK_REFER_NAME_2 = $request->BOOK_REFER_NAME_2;
  
          $maxid = Bookindexinside::max('BOOK_ID');
          $idfile = $maxid+1;
          if($request->hasFile('pdfupload')){
              $newFileName = 'inside_'.$idfile.'.'.$request->pdfupload->extension();
                
              $request->pdfupload->storeAs('bookpdf',$newFileName,'public');
  
              $addinside->BOOK_HAVE_FILE = 'True';
              $addinside->BOOK_FILE_NAME = $newFileName;
              
  
          }


          if($request->hasFile('fileupload')){
            $newFileName = 'inside2_'.$idfile.'.'.$request->fileupload->extension();
              
            $request->fileupload->storeAs('bookpdf',$newFileName,'public');

            $addinside->BOOK_HAVE_FILE_2 = 'True';
            $addinside->BOOK_FILE_NAME_2 = $newFileName;
            
            $addinside->BOOK_FILE_NAME_OLD =  $request->file('fileupload')->getClientOriginalName();
        }


  
          $addinside->save();

          $bookid = $request->BOOK_ID; 
  
          return redirect()->route('mbook.infobookinside',[
              'id' => $bookid
          ]);

      }
  

      public function infobookinsideedit(Request $request,$id)
      {
          $budgetyear = DB::table('budget_year')->get();
          $booktype = DB::table('gbook_type')->get();
          $bookinstant = DB::table('gbook_instant')->get();
          $booksecret = DB::table('gbook_secret')->get();
          $bookorg = DB::table('grecord_org')->get();
          
          $iduser  = Auth::user()->PERSON_ID; 
          $infobooksave = DB::table('hrd_person')
          ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
          ->where('hrd_person.ID','=',$iduser)
          ->first();
  
          $infobookedit= Bookindexinside::leftJoin('grecord_org','gbook_index_inside.BOOK_ORG_ID','=','grecord_org.RECORD_ORG_ID')
          ->leftJoin('hrd_person','gbook_index_inside.PERSON_SAVE_ID','=','hrd_person.ID')
          ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
          ->where('gbook_index_inside.BOOK_ID','=',$id)
          ->first();
  
  
          return view('manager_book.infobookinside_edit',[
              'budgetyears' =>$budgetyear,
              'booktypes'=>$booktype,
              'bookinstants'=>$bookinstant,
              'booksecrets'=>$booksecret,
              'bookorgs'=>$bookorg,
              'infobooksave' => $infobooksave,
              'infobookedit' => $infobookedit
       
             ]);
      }


      public function infobookinsideupdate(Request $request)
      {
          $BOOK_DATE= $request->BOOK_DATE;
          $BOOK_DATE_EXPIRE=$request->BOOK_DATE_EXPIRE;
          $DATE_SAVE=$request->DATE_SAVE;

          
       $BOOK_REFER_DATE_1 = $request->BOOK_REFER_DATE_1;
       $BOOK_REFER_DATE_2 = $request->BOOK_REFER_DATE_2;
  
          if($BOOK_DATE != ''){
              $STARTDAY = Carbon::createFromFormat('d/m/Y', $BOOK_DATE)->format('Y-m-d');
              $date_arrary_st=explode("-",$STARTDAY);  
              $y_sub_st = $date_arrary_st[0]; 
              
              if($y_sub_st >= 2500){
                  $y_st = $y_sub_st-543;
              }else{
                  $y_st = $y_sub_st;
              }
              $m_st = $date_arrary_st[1];
              $d_st = $date_arrary_st[2];  
              $BOOKDATE= $y_st."-".$m_st."-".$d_st;
              }else{
              $BOOKDATE= null;
          }
  
          if($BOOK_DATE_EXPIRE != ''){
              $STARTDAY = Carbon::createFromFormat('d/m/Y', $BOOK_DATE_EXPIRE)->format('Y-m-d');
              $date_arrary_st=explode("-",$STARTDAY);  
              $y_sub_st = $date_arrary_st[0]; 
              
              if($y_sub_st >= 2500){
                  $y_st = $y_sub_st-543;
              }else{
                  $y_st = $y_sub_st;
              }
              $m_st = $date_arrary_st[1];
              $d_st = $date_arrary_st[2];  
              $BOOKDATEEXPIRE= $y_st."-".$m_st."-".$d_st;
              }else{
              $BOOKDATEEXPIRE= null;
          }
  
          if($DATE_SAVE != ''){
              $STARTDAY = Carbon::createFromFormat('d/m/Y', $DATE_SAVE)->format('Y-m-d');
              $date_arrary_st=explode("-",$STARTDAY);  
              $y_sub_st = $date_arrary_st[0]; 
              
              if($y_sub_st >= 2500){
                  $y_st = $y_sub_st-543;
              }else{
                  $y_st = $y_sub_st;
              }
              $m_st = $date_arrary_st[1];
              $d_st = $date_arrary_st[2];  
              $DATESAVE= $y_st."-".$m_st."-".$d_st;
              }else{
              $DATESAVE= null;
          }


          if($BOOK_REFER_DATE_1 != ''){
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $BOOK_REFER_DATE_1)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0]; 
            
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $BOOK_REFER_DATE_1= $y_st."-".$m_st."-".$d_st;
            }else{
            $BOOK_REFER_DATE_1= null;
        }

        if($BOOK_REFER_DATE_2 != ''){
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $BOOK_REFER_DATE_2)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0]; 
            
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $BOOK_REFER_DATE_2= $y_st."-".$m_st."-".$d_st;
            }else{
            $BOOK_REFER_DATE_2= null;
        }
  
if($request->BOOK_NUMBER <> '' && $request->BOOK_NAME <> ''){

          $updateinside = Bookindexinside::find($request->BOOK_ID);
          $updateinside->BOOK_NUM_IN = $request->BOOK_NUM_IN;
          $updateinside->BOOK_YEAR_ID = $request->BOOK_YEAR_ID;
          $updateinside->BOOK_URGENT_ID = $request->BOOK_URGENT_ID;
          $updateinside->BOOK_SECRET_ID = $request->BOOK_SECRET_ID;
  
          $updateinside->BOOK_DATE = $BOOKDATE;
          $updateinside->BOOK_DATE_EXPIRE = $BOOKDATEEXPIRE;
          $updateinside->DATE_SAVE = $DATESAVE;
          $updateinside->DATE_TIME_SAVE = date('Y-m-d H:i:s');
  
          $updateinside->BOOK_NUMBER = $request->BOOK_NUMBER;
          $updateinside->BOOK_TYPE_ID = $request->BOOK_TYPE_ID;
          $updateinside->BOOK_NAME = $request->BOOK_NAME;
          $updateinside->BOOK_ORG_ID = $request->BOOK_ORG_ID;
          $updateinside->PERSON_SAVE_ID = $request->PERSON_SAVE_ID;
          $updateinside->BOOK_DETAIL = $request->BOOK_DETAIL;
          $updateinside->SEND_STATUS = '1';

          $updateinside->TIME_SAVE = $request->TIME_SAVE;
          $updateinside->BOOK_REFER_NUM_1 = $request->BOOK_REFER_NUM_1;
          $updateinside->BOOK_REFER_DATE_1 = $BOOK_REFER_DATE_1;
          $updateinside->BOOK_REFER_NAME_1 = $request->BOOK_REFER_NAME_1;
  
          $updateinside->BOOK_REFER_NUM_2 = $request->BOOK_REFER_NUM_2;
          $updateinside->BOOK_REFER_DATE_2 = $BOOK_REFER_DATE_2;
          $updateinside->BOOK_REFER_NAME_2 = $request->BOOK_REFER_NAME_2;

          $updateinside->BOOK_USE = $request->BOOK_USE;
  
       
          $idfile = $request->BOOK_ID;
          if($request->hasFile('pdfupload')){
              $newFileName = 'inside_'.$idfile.'.'.$request->pdfupload->extension();
                
              $request->pdfupload->storeAs('bookpdf',$newFileName,'public');
  
              $updateinside->BOOK_HAVE_FILE = 'True';
              $updateinside->BOOK_FILE_NAME = $newFileName;
              
  
          }


          if($request->hasFile('fileupload')){
            $newFileName = 'inside2_'.$idfile.'.'.$request->fileupload->extension();
              
            $request->fileupload->storeAs('bookpdf',$newFileName,'public');

            $updateinside->BOOK_HAVE_FILE_2 = 'True';
            $updateinside->BOOK_FILE_NAME_2 = $newFileName;
            
            $updateinside->BOOK_FILE_NAME_OLD =  $request->file('fileupload')->getClientOriginalName();
        }

  
          $updateinside->save();
    }
          $bookid = $request->BOOK_ID; 
  
          return redirect()->route('mbook.infobookinside',[
              'id' => $bookid
          ]);

      }



       //---------------จัดการหนังสือภายใน

       public function infobookentinsidecontrol(Request $request,$id)
       {
          $iduser  = Auth::user()->PERSON_ID; 
           
         $infobooksend = DB::table('hrd_person')
         ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
         ->where('hrd_person.ID','=',$iduser)
         ->first();
  
  
          $idbook = $id;
             
 
          $infobookreceiptview = Bookindexinside::leftJoin('grecord_org','gbook_index_inside.BOOK_ORG_ID','=','grecord_org.RECORD_ORG_ID')
          ->leftJoin('hrd_person','gbook_index_inside.PERSON_SAVE_ID','=','hrd_person.ID')
          ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
          ->leftJoin('gbook_send_inside_leader','gbook_index_inside.BOOK_ID','=','gbook_send_inside_leader.BOOK_LD_ID')
          ->leftJoin('gbook_instant','gbook_index_inside.BOOK_URGENT_ID','=','gbook_instant.INSTANT_ID')
          ->where('gbook_index_inside.BOOK_ID','=',$idbook)
          ->first();
           
           $bookdepartment = DB::table('hrd_department')->get();
           $bookdepartmentsub  = DB::table('hrd_department_sub')->get();
           $bookdepartmentsubsub  = DB::table('hrd_department_sub_sub')->get();
  
  
           //-----------ความเห็น-----------------
           $checksendleader = DB::table('gbook_send_inside_leader')
           ->where('BOOK_LD_ID','=',$idbook)
           ->count(); 
  
           if($checksendleader !== 0 ){
             $sendleaderquery  = DB::table('gbook_send_inside_leader')
             ->where('BOOK_LD_ID','=',$idbook)
             ->first();
             
             $sendleader = $sendleaderquery->TOP_LEADER_AC_CMD;
  
  
             $sendleaderdetailid = $sendleaderquery->SEND_LD_BY_HR_ID;
             $sendleaderdetail = $sendleaderquery->SEND_LD_DETAIL;
             $sendleaderhrname = $sendleaderquery->SEND_LD_BY_HR_NAME;
             $sendleaderdetailid2 = $sendleaderquery->SEND_LD_BY_HR_ID_2;
             $sendleaderdetail2 = $sendleaderquery->SEND_LD_DETAIL_2;
             $sendleaderhrname2 = $sendleaderquery->SEND_LD_BY_HR_NAME_2;
  
  
           }else{
             $sendleader = '';
             
             $sendleaderdetailid = '';
             $sendleaderdetail = '';
             $sendleaderhrname = '';
             $sendleaderdetailid2 = '';
             $sendleaderdetail2 = '';
             $sendleaderhrname2 = '';
           }
            //----------------------------
  
            $booksend = DB::table('gbook_send_inside_depart')->where('BOOK_ID','=',$idbook)->get();
            $booksendsub = DB::table('gbook_send_inside_sub')->where('BOOK_ID','=',$idbook)->get();
            $booksendsubsub = DB::table('gbook_send_inside_sub_sub')->where('BOOK_ID','=',$idbook)->get();
        
               //--------------------------------------------
               $infordepartment  =  DB::table('hrd_department')->get();
  
               $inforsenddepartments =  DB::table('gbook_send_inside_depart')
               ->where('BOOK_ID','=',$idbook)
               ->get(); 
    
               $checksendinfordepartment = DB::table('gbook_send_inside_depart')
               ->where('BOOK_ID','=',$idbook)
               ->count(); 
    
                //--------------------------------------------
  
                  //--------------------------------------------
               $infordepartmentsub  =  DB::table('hrd_department_sub')->get();
  
               $inforsenddepartmentsubs =  DB::table('gbook_send_inside_sub')
               ->where('BOOK_ID','=',$idbook)
               ->get(); 
    
               $checksendinfordepartmentsub = DB::table('gbook_send_inside_sub')
               ->where('BOOK_ID','=',$idbook)
               ->count(); 
    
                //--------------------------------------------
  
                               //--------------------------------------------
               $infordepartmentsubsub  =  DB::table('hrd_department_sub_sub')->get();
  
               $inforsenddepartmentsubsubs =  DB::table('gbook_send_inside_sub_sub')
               ->where('BOOK_ID','=',$idbook)
               ->get(); 
    
               $checksendinfordepartmentsubsub = DB::table('gbook_send_inside_sub_sub')
               ->where('BOOK_ID','=',$idbook)
               ->count(); 
    
                //--------------------------------------------
            //--------------------------------------------
            $inforposition  =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')->orderBy('hrd_person.HR_FNAME', 'asc')->get();
  
            $infosendbooks =  DB::table('gbook_send_inside')
            ->where('BOOK_ID','=',$idbook)
            ->where('SEND_TYPE','=','4')
            ->get(); 
  
            $checksendbookper = DB::table('gbook_send_inside')
            ->where('BOOK_ID','=',$idbook)
            ->where('SEND_TYPE','=','4')
           ->count(); 
  
             //--------------------------------------------

             
            $infororg  =  Recordorg::get();
  
            $infosendbookorg =  DB::table('gbook_send_inside_org')
            ->where('BOOK_ID','=',$idbook)
            ->get(); 
  
            $checksendbookorg = DB::table('gbook_send_inside_org')
            ->where('BOOK_ID','=',$idbook)
           ->count(); 

        
                 //---------------ประวัติการอ่าน-----------------------------

           $inforead = DB::table('gbook_send_inside')->select('HR_FNAME','HR_LNAME','HR_DEPARTMENT_SUB_NAME','gbook_send_inside.updated_at')
           ->leftJoin('hrd_person','hrd_person.ID','=','gbook_send_inside.HR_PERSON_ID')
           ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
           ->where('BOOK_ID','=',$idbook)
           ->where('READ_STATUS','=','true')
           ->get();

  
           return view('manager_book.infobookinside_control',[
               'infobookreceiptview' =>$infobookreceiptview,
               'idbook' => $idbook,
               'infobooksend' => $infobooksend,
               'bookdepartments'=>$bookdepartment, 
               'bookdepartmentsubs'=>$bookdepartmentsub,
               'bookdepartmentsubsubs'=>$bookdepartmentsubsub,
               'sendleader' => $sendleader,
               'sendleaderdetail' => $sendleaderdetail,
               'sendleaderhrname' => $sendleaderhrname,
               'sendleaderdetail2' => $sendleaderdetail2,
               'sendleaderhrname2' => $sendleaderhrname2,
               'booksends' => $booksend,
               'booksendsubs' => $booksendsub,
               'booksendsubsubs' => $booksendsubsub,
               'checksendleader'=>$checksendleader,
               'iduser' => $iduser,
               'sendleaderdetailid' => $sendleaderdetailid,
               'sendleaderdetailid2' => $sendleaderdetailid2,
               'inforpositions' => $inforposition,
               'checksendbookper' => $checksendbookper,
               'infosendbooks' => $infosendbooks,
               'infordepartments' => $infordepartment,
               'checksendinfordepartment' => $checksendinfordepartment,
               'inforsenddepartments' => $inforsenddepartments,
               'infordepartmentsubs' => $infordepartmentsub,
               'checksendinfordepartmentsub' => $checksendinfordepartmentsub,
               'inforsenddepartmentsubs' => $inforsenddepartmentsubs,
               'infordepartmentsubsubs' => $infordepartmentsubsub,
               'checksendinfordepartmentsubsub' => $checksendinfordepartmentsubsub,
               'inforsenddepartmentsubsubs' => $inforsenddepartmentsubsubs,
               'infororgs' => $infororg,
               'checksendbookorg' => $checksendbookorg,
               'infosendbookorgs' => $infosendbookorg,
               'inforeads' => $inforead
        
              ]);
       }
  
       
     public function sendinside(Request $request)
     {
         $typesend = $request->SUBMIT;
         $iduser = $request->ID_USER;
         $bookid = $request->BOOK_ID;
         $SEND_BY_ID = $request->SEND_BY_ID;
         $SEND_BY_NAME = $request->SEND_BY_NAME;


 
      
         if($typesend == 'sendhead'){
 
             $addpresentupstatus = Bookindexinside::find($bookid);
             $addpresentupstatus->SEND_STATUS = '4';
             $addpresentupstatus->save();
 
 
 
           $permissheards = DB::table('gsy_permis_list')->where('PERMIS_ID','=','GMB003')->get();
 
 
           foreach ($permissheards as $permissheard) {
 
         
                 $check6 = DB::table('gbook_send_inside')
                 ->where('BOOK_ID','=',$bookid)
                 ->where('HR_PERSON_ID','=',$permissheard->PERSON_ID)
                 ->count(); 
                 
             
             if($check6== 0){
         
                 $add_person6 = new Booksendinside();
                 $add_person6->BOOK_ID = $bookid;
                 $add_person6->HR_PERSON_ID = $permissheard->PERSON_ID;
                 $add_person6->READ_STATUS = 'False';
                 $add_person6->SEND_BY_ID = $SEND_BY_ID;
                 $add_person6->SEND_BY_NAME = $SEND_BY_NAME;
                 $add_person6->SEND_DATE_TIME = date('Y-m-d H:i:s');
                 $add_person6->SEND_TYPE = '4';
                 $add_person6->save();
         
             }
         
         
             }
 
 
         }else{
                                    if($request->row3 != '' || $request->row3 != null ||
                                    $request->row4 != '' || $request->row3 != null ||
                                    $request->row5 != '' || $request->row3 != null ||
                                    $request->MEMBER_ID != '' || $request->MEMBER_ID != null  
                                    ){
 
                               
 
                                     $checkstatus1 =Bookindexinside::where('BOOK_ID','=',$bookid)
                                     ->where('SEND_STATUS','=','3')
                                     ->count(); 
 
                                     $checkstatus2 =Bookindexinside::where('BOOK_ID','=',$bookid)
                                     ->where('SEND_STATUS','=','4')
                                     ->count(); 
 
                                       if($checkstatus1== 0 && $checkstatus2== 0){
 
                                         $addpresentupstatus = Bookindexinside::find($bookid);
                                         $addpresentupstatus->SEND_STATUS = '2';
                                         $addpresentupstatus->save();
   
                                       }
                                        
 
                                    }
                                 
  
         Booksendinsidedepart::where('BOOK_ID','=',$bookid)->delete(); 
         Booksendinsidedepartsub::where('BOOK_ID','=',$bookid)->delete();
         Booksendinsidedepartsubsub::where('BOOK_ID','=',$bookid)->delete();  
         Booksendinsideorg::where('BOOK_ID','=',$bookid)->delete();  

     if($request->row3 != '' || $request->row3 != null){
         $row3 = $request->row3;
         $number_3 =count($row3);
         $count_3 = 0;
         for($count_3 = 0; $count_3 < $number_3; $count_3++)
         {  
          
            $add_3 = new Booksendinsidedepart();
            $add_3->BOOK_ID = $bookid;
            $add_3->HR_DEPARTMENT_ID = $row3[$count_3];
            $add_3->save(); 
          
            $inforpersonusers =  Person::where('HR_DEPARTMENT_ID','=',$row3[$count_3])->get(); 
  
            foreach($inforpersonusers as $inforpersonuser){

                $check3 = DB::table('gbook_send_inside')
                ->where('BOOK_ID','=',$bookid)
                ->where('HR_PERSON_ID','=',$inforpersonuser->ID)
                ->count(); 
    
                if($check3== 0){
             
                     $add_person3 = new Booksendinside();
                     $add_person3->BOOK_ID = $bookid;
                     $add_person3->HR_PERSON_ID = $inforpersonuser->ID;
                     $add_person3->READ_STATUS = 'False';
                     $add_person3->SEND_BY_ID = $SEND_BY_ID;
                     $add_person3->SEND_BY_NAME = $SEND_BY_NAME;
                     $add_person3->SEND_DATE_TIME = date('Y-m-d H:i:s');
                     $add_person3->SEND_TYPE = '1';
                     $add_person3->save();

                  

                }
            }
  
  
         }
     }
  
     if($request->row4 != '' || $request->row4 != null){
  
         $row4 = $request->row4;
         $number_4 =count($row4);
         $count_4 = 0;
         for($count_4 = 0; $count_4 < $number_4; $count_4++)
         {  
        
            $add_4 = new Booksendinsidedepartsub();
            $add_4->BOOK_ID = $bookid;
            $add_4->HR_DEPARTMENT_SUB_ID = $row4[$count_4];
            $add_4->save(); 
  
            //------เช็คตัวซ้ำก่อน------
  
            $inforpersonusers_4 =  Person::where('HR_DEPARTMENT_SUB_ID','=',$row4[$count_4])->get(); 
  
            foreach($inforpersonusers_4 as $inforpersonuser_4){
                    
                  $check4 = DB::table('gbook_send_inside')
                  ->where('BOOK_ID','=',$bookid)
                  ->where('HR_PERSON_ID','=',$inforpersonuser_4->ID)
                  ->count(); 
                   
                 
                 if($check4== 0){
                     $add_person4 = new Booksendinside();
                     $add_person4->BOOK_ID = $bookid;
                     $add_person4->HR_PERSON_ID = $inforpersonuser_4->ID;
                     $add_person4->READ_STATUS = 'False';
                     $add_person4->SEND_BY_ID = $SEND_BY_ID;
                     $add_person4->SEND_BY_NAME = $SEND_BY_NAME;
                     $add_person4->SEND_DATE_TIME = date('Y-m-d H:i:s');
                     $add_person4->SEND_TYPE = '2';
                    $add_person4->save();

       


                 }
            }
  
         }
     }
  
     if($request->row5 != '' || $request->row5 != null){
         $row5 = $request->row5;
         $number_5 =count($row5);
         $count_5 = 0;
         for($count_5 = 0; $count_5 < $number_5; $count_5++)
         {  
         
            $add_5 = new Booksendinsidedepartsubsub();
            $add_5->BOOK_ID = $bookid;
            $add_5->HR_DEPARTMENT_SUB_SUB_ID = $row5[$count_5];
            $add_5->save(); 
  
             //------เช็คตัวซ้ำก่อน------
  
             $inforpersonusers_5 =  Person::where('HR_DEPARTMENT_SUB_SUB_ID','=',$row5[$count_5])->get(); 
  
             foreach($inforpersonusers_5 as $inforpersonuser_5){
                     
                   $check5 = DB::table('gbook_send_inside')
                   ->where('BOOK_ID','=',$bookid)
                   ->where('HR_PERSON_ID','=',$inforpersonuser_5->ID)
                   ->count(); 
                    
                  
                  if($check5== 0){
                      $add_person5 = new Booksendinside();
                      $add_person5->BOOK_ID = $bookid;
                      $add_person5->HR_PERSON_ID = $inforpersonuser_5->ID;
                      $add_person5->READ_STATUS = 'False';
                      $add_person5->SEND_BY_ID = $SEND_BY_ID;
                      $add_person5->SEND_BY_NAME = $SEND_BY_NAME;
                      $add_person5->SEND_DATE_TIME = date('Y-m-d H:i:s');
                      $add_person5->SEND_TYPE = '3';
                     $add_person5->save();



                  }
             }
  
             
       
  
         }
     }
     
   
     if($request->MEMBER_ID != '' || $request->MEMBER_ID != null){
  
     $MEMBER_ID = $request->MEMBER_ID;
     $number =count($MEMBER_ID);
     $count = 0;

     $checkinfocountinside =  DB::table('gbook_send_inside')
     ->where('BOOK_ID','=',$bookid)
     ->where('SEND_TYPE','=','4')
     ->count();   
     
     if($checkinfocountinside !== $number){
        DB::table('gbook_send_inside')
        ->where('BOOK_ID','=',$bookid)
        ->where('SEND_TYPE','=','4')
        ->delete();   
     }

     for($count = 0; $count < $number; $count++)
     {  
  
         $check6 = DB::table('gbook_send_inside')
         ->where('BOOK_ID','=',$bookid)
         ->where('HR_PERSON_ID','=',$MEMBER_ID[$count])
         ->count(); 
          
        
        if($check6== 0){
  
         $add_person6 = new Booksendinside();
         $add_person6->BOOK_ID = $bookid;
         $add_person6->HR_PERSON_ID = $MEMBER_ID[$count];
         $add_person6->READ_STATUS = 'False';
         $add_person6->SEND_BY_ID = $SEND_BY_ID;
         $add_person6->SEND_BY_NAME = $SEND_BY_NAME;
         $add_person6->SEND_DATE_TIME = date('Y-m-d H:i:s');
         $add_person6->SEND_TYPE = '4';
         $add_person6->save();

              
                 //-----------------line notify---------------------------------------------
                 $infobookinside = Bookindexinside::find($bookid);

                 if( $infobookinside->BOOK_URGENT_ID <> 1){
     
                  $header = "งานสารบรรณ มีหนังสือด่วน !!";
                  $message = $header.
                  "\n"."รหัส : " . $bookid .  
                  "\n"."เลขหนังสือ : " . $infobookinside->BOOK_NUMBER  . 
                  "\n"."เรื่อง : " . $infobookinside->BOOK_NAME .  
                  "\n"."วันที่ : " .date('Y-m-d H:i:s').  
                  "\n"."ผู้ส่ง :".$SEND_BY_NAME;             
              
                  $name = DB::table('hrd_person')->where('ID','=',$MEMBER_ID[$count])->first();        
                  $test =$name->HR_LINE;
      
                  $chOne = curl_init();
                  curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
                  curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0);
                  curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0);
                  curl_setopt( $chOne, CURLOPT_POST, 1);
                  curl_setopt( $chOne, CURLOPT_POSTFIELDS, $message);
                  curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=$message");
                  curl_setopt( $chOne, CURLOPT_FOLLOWLOCATION, 1);
                  $headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$test.'', );
                  curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
                  curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1);
                  $result = curl_exec( $chOne );
                  if(curl_error($chOne)) { echo 'error:' . curl_error($chOne); }
                  else { $result_ = json_decode($result, true);
                  echo "status : ".$result_['status']; echo "message : ". $result_['message']; }
                  curl_close( $chOne );
                  //--------------------------------------------------------------
     
                 }  
  
        }
  
  
     }

    }

     if($request->ORG_ID != '' || $request->ORG_ID != null){
  
        $ORG_ID = $request->ORG_ID;
        $number_7 =count($ORG_ID);
        $count_7 = 0;
        for($count_7 = 0; $count_7 < $number_7; $count_7++)
        {  
     
     
            $add_org = new Booksendinsideorg();
            $add_org->BOOK_ID = $bookid;
            $add_org->ORG_ID = $ORG_ID[$count_7];
            $add_org->save();
     
           }
     
     
        }
  
    }
   
  
         return redirect()->route('mbook.infobookinside');
     }
  
  
     
     public function saverpresentinside(Request $request)
     {
  
         $bookid = $request->BOOK_ID;
  
         $checksendleader = DB::table('gbook_send_inside_leader')
         ->where('BOOK_LD_ID','=',$bookid)
         ->count(); 
      
        
  
         $date = date('Y-m-d');
         $datetime = date('Y-m-d H:i:s');
         
         $info_org = DB::table('info_org')->first();
  
  
         if($checksendleader !== 0 ){
  
             $sendid = DB::table('gbook_send_inside_leader')
             ->where('BOOK_LD_ID','=',$bookid)
             ->first(); 
  
             if($request->SEND_LD_DETAIL_2 == '' ){
  
                 $SEND_LD_BY_HR_NAME_2 = '';
                 $SEND_LD_DETAIL_2 = '';
                 $SEND_LD_BY_HR_ID_2 = null;
  
             }else{
                 $SEND_LD_BY_HR_NAME_2 = $request->SEND_LD_BY_HR_NAME_2 ;
                 $SEND_LD_DETAIL_2 = $request->SEND_LD_DETAIL_2;
                 $SEND_LD_BY_HR_ID_2 =$request->SEND_LD_BY_HR_ID_2;
             }
  
  
  
             $addpresent = Booksendinsideleader::find($sendid->SEND_LD_ID);
             $addpresent->BOOK_LD_ID = $request->BOOK_ID;
             $addpresent->SEND_LD_HR_ID = $info_org->ORG_LEADER_ID;
             $addpresent->SEND_LD_HR_NAME = $info_org->ORG_LEADER;
             $addpresent->SEND_LD_BY_HR_ID = $request->SEND_LD_BY_HR_ID;
             $addpresent->SEND_LD_BY_HR_NAME = $request->SEND_LD_BY_HR_NAME;
             $addpresent->SEND_LD_DETAIL = $request->SEND_LD_DETAIL;
             $addpresent->SEND_LD_BY_HR_ID_2 = $SEND_LD_BY_HR_ID_2;
             $addpresent->SEND_LD_BY_HR_NAME_2  = $SEND_LD_BY_HR_NAME_2;
             $addpresent->SEND_LD_DETAIL_2  = $SEND_LD_DETAIL_2;
     
             $addpresent->SEND_LD_DATE = $date;
             $addpresent->SEND_LD_DATE_TIME = $datetime;
             $addpresent->SEND_LD_STATUS = 'SEND';
             $addpresent->save();
  
  
         }else{
         $addpresent = new Booksendinsideleader(); 
         $addpresent->BOOK_LD_ID = $request->BOOK_ID;
         $addpresent->SEND_LD_HR_ID = $info_org->ORG_LEADER_ID;
         $addpresent->SEND_LD_HR_NAME = $info_org->ORG_LEADER;
         $addpresent->SEND_LD_BY_HR_ID = $request->SEND_LD_BY_HR_ID;
         $addpresent->SEND_LD_BY_HR_NAME = $request->SEND_LD_BY_HR_NAME;
         $addpresent->SEND_LD_DETAIL = $request->SEND_LD_DETAIL;
         $addpresent->SEND_LD_BY_HR_ID_2 = $request->SEND_LD_BY_HR_ID_2 ;
         $addpresent->SEND_LD_BY_HR_NAME_2  = $request->SEND_LD_BY_HR_NAME_2 ;
         $addpresent->SEND_LD_DETAIL_2  = $request->SEND_LD_DETAIL_2 ;
  
         $addpresent->SEND_LD_DATE = $date;
         $addpresent->SEND_LD_DATE_TIME = $datetime;
         $addpresent->SEND_LD_STATUS = 'SEND';
         $addpresent->save();
  
         $addpresentupstatus = Bookindexinside::find($request->BOOK_ID);
         $addpresentupstatus->SEND_STATUS = '2';
         $addpresentupstatus->save();
         }
         $iduser = $request->ID_USER;
  
         return redirect()->route('mbook.infobookentinsidecontrol',[
             'id' => $bookid,
         ]);
         }
  
         public function saveretireinside(Request $request)
         {
            
             $date = date('Y-m-d');
             $datetime = date('Y-m-d H:i:s');
             
             $info_org = DB::table('info_org')->first();
             $bookid = $request->BOOK_ID;
             
     
                          
             $addretire = Booksendinsideleader::find($request->SEND_LD_ID);
             $addretire->TOP_LEADER_AC_ID = $info_org->ORG_LEADER_ID;
             $addretire->TOP_LEADER_AC_NAME = $info_org->ORG_LEADER;
             $addretire->TOP_LEADER_AC_CMD = $request->TOP_LEADER_AC_CMD;
             $addretire->TOP_LEADER_AC_DATE = $date;
             $addretire->TOP_LEADER_AC_DATE_TIME = $datetime;
             $addretire->SEND_LD_STATUS = 'ํYES';
             $addretire->save();
     
             $addpresentupstatus = Bookindexinside::find($request->BOOK_ID);
             $addpresentupstatus->SEND_STATUS = '3';
             $addpresentupstatus->save();
             
     
             $iduser = $request->ID_USER;
             return redirect()->route('mbook.infobookentinsidecontrol',[
                 'id' => $bookid,
             ]);
         }





       //===============================คำสั่ง==============================

       public function infobookcommand(Request $request)
       {
           if(!empty($request->_token)){
                $yearbudget = $request->BUDGET_YEAR;
                $search = $request->get('search');
                $datebigin = $request->get('DATE_BIGIN');
                $dateend = $request->get('DATE_END');
            session([
                'manager_book.bookcommand.yearbudget' => $yearbudget,
                'manager_book.bookcommand.search' => $search,
                'manager_book.bookcommand.datebigin' => $datebigin,
                'manager_book.bookcommand.dateend' => $dateend,
            ]);
           }elseif(!empty(session('manager_book.bookcommand'))){
                $yearbudget = session('manager_book.bookcommand.yearbudget');
                $search = session('manager_book.bookcommand.search');
                $datebigin = session('manager_book.bookcommand.datebigin');
                $dateend = session('manager_book.bookcommand.dateend');
           }else{
                $yearbudget = date('Y')+543;
                $search = '';
                $datebigin = date('1/m/Y');
                $dateend   = date('d/m/Y', strtotime(date('Y-m-1'). '+1month -1days'));
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
                   $infobookcommand=  Bookindexcommand::leftJoin('grecord_org','gbook_index_command.BOOK_ORG_ID','=','grecord_org.RECORD_ORG_ID')
                   ->leftJoin('hrd_person','gbook_index_command.PERSON_SAVE_ID','=','hrd_person.ID')
                   ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                   ->leftJoin('gbook_send_command_leader','gbook_index_command.BOOK_ID','=','gbook_send_command_leader.BOOK_LD_ID')
                   ->where(function($q) use ($search){
                               $q->where('BOOK_NUM_IN','like','%'.$search.'%');
                               $q->orwhere('BOOK_NUMBER','like','%'.$search.'%');
                               $q->orwhere('BOOK_NAME','like','%'.$search.'%');
                   })
                   ->WhereBetween('DATE_SAVE',[$from,$to]) 
                   ->orderBy('gbook_index_command.BOOK_ID', 'desc')    
                   ->get();
           $iduser  = Auth::user()->PERSON_ID; 
           $infobooksend = DB::table('hrd_person')
           ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
           ->where('hrd_person.ID','=',$iduser)
           ->first();
           $infobookstatus1 = DB::table('gbook_status')
           ->where('BOOK_STATUS_ID','=','1')
           ->first();
           $infobookstatus2 = DB::table('gbook_status')
           ->where('BOOK_STATUS_ID','=','2')
           ->first();
           $infobookstatus3 = DB::table('gbook_status')
           ->where('BOOK_STATUS_ID','=','3')
           ->first();
           $infobook_sendstatus = DB::table('gbook_status')
           ->get();
           $budget = getYearAmount();
           $year_id = $yearbudget;
           return view('manager_book.infobookcommand',[
               'infobookcommands' =>$infobookcommand,
               'infobookstatus1'=> $infobookstatus1, 
               'infobookstatus2'=> $infobookstatus2,
               'infobookstatus3'=> $infobookstatus3,
               'infobooksend'=>   $infobooksend,
               'infobook_sendstatuss'=> $infobook_sendstatus,
               'displaydate_bigen'=> $displaydate_bigen,
               'displaydate_end'=> $displaydate_end,
               'search'=> $search,
               'year_id'=>$year_id,  
               'budgets' =>  $budget,
             ]);
       }

       public function infobookcommandsearch(Request $request)
       {
   
   
        $yearbudget = $request->BUDGET_YEAR;
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
   
               
                   $infobookcommand=  Bookindexcommand::leftJoin('grecord_org','gbook_index_command.BOOK_ORG_ID','=','grecord_org.RECORD_ORG_ID')
                   ->leftJoin('hrd_person','gbook_index_command.PERSON_SAVE_ID','=','hrd_person.ID')
                   ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                   ->leftJoin('gbook_send_command_leader','gbook_index_command.BOOK_ID','=','gbook_send_command_leader.BOOK_LD_ID')
                   ->where(function($q) use ($search){
                               $q->where('BOOK_NUM_IN','like','%'.$search.'%');
                               $q->orwhere('BOOK_NUMBER','like','%'.$search.'%');
                               $q->orwhere('BOOK_NAME','like','%'.$search.'%');
         
                   })
                   ->WhereBetween('DATE_SAVE',[$from,$to]) 
                   ->orderBy('gbook_index_command.BOOK_ID', 'desc')    
                   ->get();
            
       
   
      
   
   
   
           $iduser  = Auth::user()->PERSON_ID; 
           $infobooksend = DB::table('hrd_person')
           ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
           ->where('hrd_person.ID','=',$iduser)
           ->first();
   
           $infobookstatus1 = DB::table('gbook_status')
           ->where('BOOK_STATUS_ID','=','1')
           ->first();
           $infobookstatus2 = DB::table('gbook_status')
           ->where('BOOK_STATUS_ID','=','2')
           ->first();
           $infobookstatus3 = DB::table('gbook_status')
           ->where('BOOK_STATUS_ID','=','3')
           ->first();
         
           $infobook_sendstatus = DB::table('gbook_status')
           ->get();

           $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
           $year_id = $yearbudget;
           
           return view('manager_book.infobookcommand',[
               'infobookcommands' =>$infobookcommand,
               'infobookstatus1'=> $infobookstatus1, 
               'infobookstatus2'=> $infobookstatus2,
               'infobookstatus3'=> $infobookstatus3,
               'infobooksend'=>   $infobooksend,
               'infobook_sendstatuss'=> $infobook_sendstatus,
               'displaydate_bigen'=> $displaydate_bigen,
               'displaydate_end'=> $displaydate_end,
               'search'=> $search,
               'year_id'=>$year_id,  
               'budgets' =>  $budget,
               
               
             ]);
   
   
   
       }

       public function bookcommand_excel(Request $request, $datebegin, $dateen, $search)
       {

        $from = $datebegin;
        $to   = $dateen;

        if ($search == 'null') {
            $search = '';
        }


        
            $infobookcommand=  Bookindexcommand::leftJoin('grecord_org','gbook_index_command.BOOK_ORG_ID','=','grecord_org.RECORD_ORG_ID')
            ->leftJoin('hrd_person','gbook_index_command.PERSON_SAVE_ID','=','hrd_person.ID')
            ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
            ->leftJoin('gbook_send_command_leader','gbook_index_command.BOOK_ID','=','gbook_send_command_leader.BOOK_LD_ID')
            ->where(function($q) use ($search){
                        $q->where('BOOK_NUM_IN','like','%'.$search.'%');
                        $q->orwhere('BOOK_NUMBER','like','%'.$search.'%');
                        $q->orwhere('BOOK_NAME','like','%'.$search.'%');
  
            })
            ->WhereBetween('DATE_SAVE',[$from,$to]) 
            ->orderBy('gbook_index_command.BOOK_ID', 'desc')    
            ->get();
     






    $iduser  = Auth::user()->PERSON_ID; 
    $infobooksend = DB::table('hrd_person')
    ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->where('hrd_person.ID','=',$iduser)
    ->first();

    $infobookstatus1 = DB::table('gbook_status')
    ->where('BOOK_STATUS_ID','=','1')
    ->first();
    $infobookstatus2 = DB::table('gbook_status')
    ->where('BOOK_STATUS_ID','=','2')
    ->first();
    $infobookstatus3 = DB::table('gbook_status')
    ->where('BOOK_STATUS_ID','=','3')
    ->first();
  
    $infobook_sendstatus = DB::table('gbook_status')
    ->get();

    $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

    
   
           return view('manager_book.infobookcommand_excel',[
               'infobookcommands' =>$infobookcommand,
               'infobookstatus1'=> $infobookstatus1, 
               'infobookstatus2'=> $infobookstatus2,
               'infobookstatus3'=> $infobookstatus3,
               'infobook_sendstatuss'=>   $infobook_sendstatus,
               'budgets' =>  $budget,
          
              ]);
       }
   


       public function infobookcommandinsert()
       {
           $budgetyear = DB::table('budget_year')->get();
           $booktype = DB::table('gbook_type')->get();
           $bookinstant = DB::table('gbook_instant')->get();
           $booksecret = DB::table('gbook_secret')->get();
           $bookorg = DB::table('grecord_org')->get();
           
           $iduser  = Auth::user()->PERSON_ID; 
           $infobooksave = DB::table('hrd_person')
           ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
           ->where('hrd_person.ID','=',$iduser)
           ->first();


           $year=date('Y')+543;
           $maxnumber = Bookindexcommand::where('BOOK_YEAR_ID','=',$year)->max('BOOK_NUMBER');
           $maxnumberuse =  $maxnumber+1;
   
   
           return view('manager_book.infobookcommand_add',[
               'budgetyears' =>$budgetyear,
               'booktypes'=>$booktype,
               'bookinstants'=>$bookinstant,
               'booksecrets'=>$booksecret,
               'bookorgs'=>$bookorg,
               'infobooksave' => $infobooksave,
               'maxnumberuse' => $maxnumberuse
        
              ]);
       }
 
 
       public function infobookcommandsave(Request $request)
       {        
           $BOOK_DATE= $request->BOOK_DATE;
           $BOOK_DATE_EXPIRE=$request->BOOK_DATE_EXPIRE;
           $DATE_SAVE=$request->DATE_SAVE;
   
           if($BOOK_DATE != ''){
               $STARTDAY = Carbon::createFromFormat('d/m/Y', $BOOK_DATE)->format('Y-m-d');
               $date_arrary_st=explode("-",$STARTDAY);  
               $y_sub_st = $date_arrary_st[0]; 
               
               if($y_sub_st >= 2500){
                   $y_st = $y_sub_st-543;
               }else{
                   $y_st = $y_sub_st;
               }
               $m_st = $date_arrary_st[1];
               $d_st = $date_arrary_st[2];  
               $BOOKDATE= $y_st."-".$m_st."-".$d_st;
               }else{
               $BOOKDATE= null;
           }
   
           if($BOOK_DATE_EXPIRE != ''){
               $STARTDAY = Carbon::createFromFormat('d/m/Y', $BOOK_DATE_EXPIRE)->format('Y-m-d');
               $date_arrary_st=explode("-",$STARTDAY);  
               $y_sub_st = $date_arrary_st[0]; 
               
               if($y_sub_st >= 2500){
                   $y_st = $y_sub_st-543;
               }else{
                   $y_st = $y_sub_st;
               }
               $m_st = $date_arrary_st[1];
               $d_st = $date_arrary_st[2];  
               $BOOKDATEEXPIRE= $y_st."-".$m_st."-".$d_st;
               }else{
               $BOOKDATEEXPIRE= null;
           }
   
           if($DATE_SAVE != ''){
               $STARTDAY = Carbon::createFromFormat('d/m/Y', $DATE_SAVE)->format('Y-m-d');
               $date_arrary_st=explode("-",$STARTDAY);  
               $y_sub_st = $date_arrary_st[0]; 
               
               if($y_sub_st >= 2500){
                   $y_st = $y_sub_st-543;
               }else{
                   $y_st = $y_sub_st;
               }
               $m_st = $date_arrary_st[1];
               $d_st = $date_arrary_st[2];  
               $DATESAVE= $y_st."-".$m_st."-".$d_st;
               }else{
               $DATESAVE= null;
           }
   
   
           $addcommand = new Bookindexcommand(); 
           $addcommand->BOOK_NUM_IN = $request->BOOK_NUM_IN;
           $addcommand->BOOK_YEAR_ID = $request->BOOK_YEAR_ID;
           $addcommand->BOOK_URGENT_ID = $request->BOOK_URGENT_ID;
           $addcommand->BOOK_SECRET_ID = $request->BOOK_SECRET_ID;
   
           $addcommand->BOOK_DATE = $BOOKDATE;
           $addcommand->BOOK_DATE_EXPIRE = $BOOKDATEEXPIRE;
           $addcommand->DATE_SAVE = $DATESAVE;
           $addcommand->DATE_TIME_SAVE = date('Y-m-d H:i:s');
           $addcommand->TIME_SAVE =$request->TIME_SAVE;
           
           $addcommand->BOOK_NUMBER = $request->BOOK_NUMBER;
           $addcommand->BOOK_TYPE_ID = $request->BOOK_TYPE_ID;
           $addcommand->BOOK_NAME = $request->BOOK_NAME;
           $addcommand->BOOK_ORG_ID = $request->BOOK_ORG_ID;
           $addcommand->PERSON_SAVE_ID = $request->PERSON_SAVE_ID;
           $addcommand->BOOK_DETAIL = $request->BOOK_DETAIL;
           $addcommand->SEND_STATUS = '1';
   
           $maxid = Bookindexcommand::max('BOOK_ID');
           $idfile = $maxid+1;
           if($request->hasFile('pdfupload')){
               $newFileName = 'command_'.$idfile.'.'.$request->pdfupload->extension();
                 
               $request->pdfupload->storeAs('bookpdf',$newFileName,'public');
   
               $addcommand->BOOK_HAVE_FILE = 'True';
               $addcommand->BOOK_FILE_NAME = $newFileName;
               
   
           }
   
           $addcommand->save();
   
           $bookid = $request->BOOK_ID; 
   
           return redirect()->route('mbook.infobookcommand',[
               'id' => $bookid
           ]);

       }

       public function infobookcomdocedit(Request $request,$id)
       {
           $budgetyear = DB::table('budget_year')->get();
           $booktype = DB::table('gbook_type')->get();
           $bookinstant = DB::table('gbook_instant')->get();
           $booksecret = DB::table('gbook_secret')->get();
           $bookorg = DB::table('grecord_org')->get();
           
           $iduser  = Auth::user()->PERSON_ID; 
           $infobooksave = DB::table('hrd_person')
           ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
           ->where('hrd_person.ID','=',$iduser)
           ->first();
   
           $infobookedit= Bookindexcommand::leftJoin('grecord_org','gbook_index_command.BOOK_ORG_ID','=','grecord_org.RECORD_ORG_ID')
           ->leftJoin('hrd_person','gbook_index_command.PERSON_SAVE_ID','=','hrd_person.ID')
           ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
           ->where('gbook_index_command.BOOK_ID','=',$id)
           ->first();
   
   
           return view('manager_book.infobookcommand_edit',[
               'budgetyears' =>$budgetyear,
               'booktypes'=>$booktype,
               'bookinstants'=>$bookinstant,
               'booksecrets'=>$booksecret,
               'bookorgs'=>$bookorg,
               'infobooksave' => $infobooksave,
               'infobookedit' => $infobookedit
        
              ]);
       }
 

       public function infobookcomdocupdate(Request $request)
       {
           $BOOK_DATE= $request->BOOK_DATE;
           $BOOK_DATE_EXPIRE=$request->BOOK_DATE_EXPIRE;
           $DATE_SAVE=$request->DATE_SAVE;
   
           if($BOOK_DATE != ''){
               $STARTDAY = Carbon::createFromFormat('d/m/Y', $BOOK_DATE)->format('Y-m-d');
               $date_arrary_st=explode("-",$STARTDAY);  
               $y_sub_st = $date_arrary_st[0]; 
               
               if($y_sub_st >= 2500){
                   $y_st = $y_sub_st-543;
               }else{
                   $y_st = $y_sub_st;
               }
               $m_st = $date_arrary_st[1];
               $d_st = $date_arrary_st[2];  
               $BOOKDATE= $y_st."-".$m_st."-".$d_st;
               }else{
               $BOOKDATE= null;
           }
   
           if($BOOK_DATE_EXPIRE != ''){
               $STARTDAY = Carbon::createFromFormat('d/m/Y', $BOOK_DATE_EXPIRE)->format('Y-m-d');
               $date_arrary_st=explode("-",$STARTDAY);  
               $y_sub_st = $date_arrary_st[0]; 
               
               if($y_sub_st >= 2500){
                   $y_st = $y_sub_st-543;
               }else{
                   $y_st = $y_sub_st;
               }
               $m_st = $date_arrary_st[1];
               $d_st = $date_arrary_st[2];  
               $BOOKDATEEXPIRE= $y_st."-".$m_st."-".$d_st;
               }else{
               $BOOKDATEEXPIRE= null;
           }
   
           if($DATE_SAVE != ''){
               $STARTDAY = Carbon::createFromFormat('d/m/Y', $DATE_SAVE)->format('Y-m-d');
               $date_arrary_st=explode("-",$STARTDAY);  
               $y_sub_st = $date_arrary_st[0]; 
               
               if($y_sub_st >= 2500){
                   $y_st = $y_sub_st-543;
               }else{
                   $y_st = $y_sub_st;
               }
               $m_st = $date_arrary_st[1];
               $d_st = $date_arrary_st[2];  
               $DATESAVE= $y_st."-".$m_st."-".$d_st;
               }else{
               $DATESAVE= null;
           }
   
   
           $updatecommand = Bookindexcommand::find($request->BOOK_ID);
           $updatecommand->BOOK_NUM_IN = $request->BOOK_NUM_IN;
           $updatecommand->BOOK_YEAR_ID = $request->BOOK_YEAR_ID;
           $updatecommand->BOOK_URGENT_ID = $request->BOOK_URGENT_ID;
           $updatecommand->BOOK_SECRET_ID = $request->BOOK_SECRET_ID;
   
           $updatecommand->BOOK_DATE = $BOOKDATE;
           $updatecommand->BOOK_DATE_EXPIRE = $BOOKDATEEXPIRE;
           $updatecommand->DATE_SAVE = $DATESAVE;
           $updatecommand->DATE_TIME_SAVE = date('Y-m-d H:i:s');
           $updatecommand->TIME_SAVE =$request->TIME_SAVE;

           $updatecommand->BOOK_USE =$request->BOOK_USE;
           
           $updatecommand->BOOK_NUMBER = $request->BOOK_NUMBER;
           $updatecommand->BOOK_TYPE_ID = $request->BOOK_TYPE_ID;
           $updatecommand->BOOK_NAME = $request->BOOK_NAME;
           $updatecommand->BOOK_ORG_ID = $request->BOOK_ORG_ID;
           $updatecommand->PERSON_SAVE_ID = $request->PERSON_SAVE_ID;
           $updatecommand->BOOK_DETAIL = $request->BOOK_DETAIL;
           $updatecommand->SEND_STATUS = '1';
   
    
           $idfile = $request->BOOK_ID;
           if($request->hasFile('pdfupload')){
               $newFileName = 'command_'.$idfile.'.'.$request->pdfupload->extension();
                 
               $request->pdfupload->storeAs('bookpdf',$newFileName,'public');
   
               $updatecommand->BOOK_HAVE_FILE = 'True';
               $updatecommand->BOOK_FILE_NAME = $newFileName;
               
   
           }
   
           $updatecommand->save();
   
           $bookid = $request->BOOK_ID; 
   
           return redirect()->route('mbook.infobookcommand',[
               'id' => $bookid
           ]);
       }
   


         //---------------จัดการหนังสือคำสั่ง

      public function infobookentcomdoccontrol(Request $request,$id)
      {
         $iduser  = Auth::user()->PERSON_ID; 
          
        $infobooksend = DB::table('hrd_person')
        ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->where('hrd_person.ID','=',$iduser)
        ->first();
 
 
         $idbook = $id;
  
  
         $infobookreceiptview = Bookindexcommand::leftJoin('grecord_org','gbook_index_command.BOOK_ORG_ID','=','grecord_org.RECORD_ORG_ID')
         ->leftJoin('hrd_person','gbook_index_command.PERSON_SAVE_ID','=','hrd_person.ID')
         ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
         ->leftJoin('gbook_send_command_leader','gbook_index_command.BOOK_ID','=','gbook_send_command_leader.BOOK_LD_ID')
         ->leftJoin('gbook_instant','gbook_index_command.BOOK_URGENT_ID','=','gbook_instant.INSTANT_ID')
         ->where('gbook_index_command.BOOK_ID','=',$idbook)
         ->first();
          
          $bookdepartment = DB::table('hrd_department')->get();
          $bookdepartmentsub  = DB::table('hrd_department_sub')->get();
          $bookdepartmentsubsub  = DB::table('hrd_department_sub_sub')->get();
 
 
          //-----------ความเห็น-----------------
          $checksendleader = DB::table('gbook_send_command_leader')
          ->where('BOOK_LD_ID','=',$idbook)
          ->count(); 
 
          if($checksendleader !== 0 ){
            $sendleaderquery  = DB::table('gbook_send_command_leader')
            ->where('BOOK_LD_ID','=',$idbook)
            ->first();
            
            $sendleader = $sendleaderquery->TOP_LEADER_AC_CMD;
 
 
            $sendleaderdetailid = $sendleaderquery->SEND_LD_BY_HR_ID;
            $sendleaderdetail = $sendleaderquery->SEND_LD_DETAIL;
            $sendleaderhrname = $sendleaderquery->SEND_LD_BY_HR_NAME;
            $sendleaderdetailid2 = $sendleaderquery->SEND_LD_BY_HR_ID_2;
            $sendleaderdetail2 = $sendleaderquery->SEND_LD_DETAIL_2;
            $sendleaderhrname2 = $sendleaderquery->SEND_LD_BY_HR_NAME_2;
 
 
          }else{
            $sendleader = '';
            
            $sendleaderdetailid = '';
            $sendleaderdetail = '';
            $sendleaderhrname = '';
            $sendleaderdetailid2 = '';
            $sendleaderdetail2 = '';
            $sendleaderhrname2 = '';
          }
           //----------------------------
 
           $booksend = DB::table('gbook_send_command_depart')->where('BOOK_ID','=',$idbook)->get();
           $booksendsub = DB::table('gbook_send_command_sub')->where('BOOK_ID','=',$idbook)->get();
           $booksendsubsub = DB::table('gbook_send_command_sub_sub')->where('BOOK_ID','=',$idbook)->get();
       
              //--------------------------------------------
              $infordepartment  =  DB::table('hrd_department')->get();
 
              $inforsenddepartments =  DB::table('gbook_send_command_depart')
              ->where('BOOK_ID','=',$idbook)
              ->get(); 
   
              $checksendinfordepartment = DB::table('gbook_send_command_depart')
              ->where('BOOK_ID','=',$idbook)
              ->count(); 
   
               //--------------------------------------------
 
              $infordepartmentsub  =  DB::table('hrd_department_sub')->get();
 
              $inforsenddepartmentsubs =  DB::table('gbook_send_command_sub')
              ->where('BOOK_ID','=',$idbook)
              ->get(); 
   
              $checksendinfordepartmentsub = DB::table('gbook_send_command_sub')
              ->where('BOOK_ID','=',$idbook)
              ->count(); 
   
               //--------------------------------------------
 
                              //--------------------------------------------
              $infordepartmentsubsub  =  DB::table('hrd_department_sub_sub')->get();
 
              $inforsenddepartmentsubsubs =  DB::table('gbook_send_command_sub_sub')
              ->where('BOOK_ID','=',$idbook)
              ->get(); 
   
              $checksendinfordepartmentsubsub = DB::table('gbook_send_command_sub_sub')
              ->where('BOOK_ID','=',$idbook)
              ->count(); 
   
               //--------------------------------------------
           //--------------------------------------------
           $inforposition  =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')->orderBy('hrd_person.HR_FNAME', 'asc')->get();
 
           $infosendbooks =  DB::table('gbook_send_person')
           ->where('BOOK_ID','=',$idbook)
           ->where('SEND_TYPE','=','4')
           ->get(); 
 
           $checksendbookper = DB::table('gbook_send_command')
           ->where('BOOK_ID','=',$idbook)
           ->where('SEND_TYPE','=','4')
          ->count(); 
 
               //--------------------------------------------

             
               $infororg  =  Recordorg::get();
  
               $infosendbookorg =  DB::table('gbook_send_command_org')
               ->where('BOOK_ID','=',$idbook)
               ->get(); 
     
               $checksendbookorg = DB::table('gbook_send_command_org')
               ->where('BOOK_ID','=',$idbook)
              ->count(); 
   
               //--------------------------------------------
 
          return view('manager_book.infobookcommand_control',[
              'infobookreceiptview' =>$infobookreceiptview,
              'idbook' => $idbook,
              'infobooksend' => $infobooksend,
              'bookdepartments'=>$bookdepartment, 
              'bookdepartmentsubs'=>$bookdepartmentsub,
              'bookdepartmentsubsubs'=>$bookdepartmentsubsub,
              'sendleader' => $sendleader,
              'sendleaderdetail' => $sendleaderdetail,
              'sendleaderhrname' => $sendleaderhrname,
              'sendleaderdetail2' => $sendleaderdetail2,
              'sendleaderhrname2' => $sendleaderhrname2,
              'booksends' => $booksend,
              'booksendsubs' => $booksendsub,
              'booksendsubsubs' => $booksendsubsub,
              'checksendleader'=>$checksendleader,
              'iduser' => $iduser,
              'sendleaderdetailid' => $sendleaderdetailid,
              'sendleaderdetailid2' => $sendleaderdetailid2,
              'inforpositions' => $inforposition,
              'checksendbookper' => $checksendbookper,
              'infosendbooks' => $infosendbooks,
              'infordepartments' => $infordepartment,
              'checksendinfordepartment' => $checksendinfordepartment,
              'inforsenddepartments' => $inforsenddepartments,
              'infordepartmentsubs' => $infordepartmentsub,
              'checksendinfordepartmentsub' => $checksendinfordepartmentsub,
              'inforsenddepartmentsubs' => $inforsenddepartmentsubs,
              'infordepartmentsubsubs' => $infordepartmentsubsub,
              'checksendinfordepartmentsubsub' => $checksendinfordepartmentsubsub,
              'inforsenddepartmentsubsubs' => $inforsenddepartmentsubsubs,
              'infororgs' => $infororg,
              'checksendbookorg' => $checksendbookorg,
              'infosendbookorgs' => $infosendbookorg
       
             ]);
      }
 
      
    public function sendcomdoc(Request $request)
    {
        $iduser = $request->ID_USER;
        $bookid = $request->BOOK_ID;
        $SEND_BY_ID = $request->SEND_BY_ID;
        $SEND_BY_NAME = $request->SEND_BY_NAME;

        Booksendcommanddepart::where('BOOK_ID','=',$bookid)->delete(); 
        Booksendcommanddepartsub::where('BOOK_ID','=',$bookid)->delete();
        Booksendcommanddepartsubsub::where('BOOK_ID','=',$bookid)->delete();  
        Booksendcommand::where('BOOK_ID','=',$bookid)->delete();  
 
    if($request->row3 != '' || $request->row3 != null){
        $row3 = $request->row3;
        $number_3 =count($row3);
        $count_3 = 0;
        for($count_3 = 0; $count_3 < $number_3; $count_3++)
        {  
         
           $add_3 = new Booksendcommanddepart();
           $add_3->BOOK_ID = $bookid;
           $add_3->HR_DEPARTMENT_ID = $row3[$count_3];
           $add_3->save(); 
         
           $inforpersonusers =  Person::where('HR_DEPARTMENT_ID','=',$row3[$count_3])->get(); 
 
           foreach($inforpersonusers as $inforpersonuser){

            $check3 = DB::table('gbook_send_command')
            ->where('BOOK_ID','=',$bookid)
            ->where('HR_PERSON_ID','=',$inforpersonuser->ID)
            ->count(); 

            if($check3== 0){
            
                    $add_person3 = new Booksendcommand();
                    $add_person3->BOOK_ID = $bookid;
                    $add_person3->HR_PERSON_ID = $inforpersonuser->ID;
                    $add_person3->READ_STATUS = 'False';
                    $add_person3->SEND_BY_ID = $SEND_BY_ID;
                    $add_person3->SEND_BY_NAME = $SEND_BY_NAME;
                    $add_person3->SEND_DATE_TIME = date('Y-m-d H:i:s');
                    $add_person3->SEND_TYPE = '1';
                    $add_person3->save();

            }
           }
 
 
        }
    }
 
    if($request->row4 != '' || $request->row4 != null){
 
        $row4 = $request->row4;
        $number_4 =count($row4);
        $count_4 = 0;
        for($count_4 = 0; $count_4 < $number_4; $count_4++)
        {  
 
       
           $add_4 = new Booksendcommanddepartsub();
           $add_4->BOOK_ID = $bookid;
           $add_4->HR_DEPARTMENT_SUB_ID = $row4[$count_4];
           $add_4->save(); 
 
           //------เช็คตัวซ้ำก่อน------
 
           $inforpersonusers_4 =  Person::where('HR_DEPARTMENT_SUB_ID','=',$row4[$count_4])->get(); 
 
           foreach($inforpersonusers_4 as $inforpersonuser_4){
                   
                 $check4 = DB::table('gbook_send_person')
                 ->where('BOOK_ID','=',$bookid)
                 ->where('HR_PERSON_ID','=',$inforpersonuser_4->ID)
                 ->count(); 
                  
                
                if($check4== 0){
                    $add_person4 = new Booksendcommand();
                    $add_person4->BOOK_ID = $bookid;
                    $add_person4->HR_PERSON_ID = $inforpersonuser_4->ID;
                    $add_person4->READ_STATUS = 'False';
                    $add_person4->SEND_BY_ID = $SEND_BY_ID;
                    $add_person4->SEND_BY_NAME = $SEND_BY_NAME;
                    $add_person4->SEND_DATE_TIME = date('Y-m-d H:i:s');
                    $add_person4->SEND_TYPE = '2';
                   $add_person4->save();
                }
           }
 
        }
    }
 
    if($request->row5 != '' || $request->row5 != null){
        $row5 = $request->row5;
        $number_5 =count($row5);
        $count_5 = 0;
        for($count_5 = 0; $count_5 < $number_5; $count_5++)
        {  
 
           $add_5 = new Booksendcommanddepartsubsub();
           $add_5->BOOK_ID = $bookid;
           $add_5->HR_DEPARTMENT_SUB_SUB_ID = $row5[$count_5];
           $add_5->save(); 
 
            //------เช็คตัวซ้ำก่อน------
 
            $inforpersonusers_5 =  Person::where('HR_DEPARTMENT_SUB_SUB_ID','=',$row5[$count_5])->get(); 
 
            foreach($inforpersonusers_5 as $inforpersonuser_5){
                    
                  $check5 = DB::table('gbook_send_person')
                  ->where('BOOK_ID','=',$bookid)
                  ->where('HR_PERSON_ID','=',$inforpersonuser_5->ID)
                  ->count(); 
                   
                 
                 if($check5== 0){
                     $add_person5 = new Booksendcommand();
                     $add_person5->BOOK_ID = $bookid;
                     $add_person5->HR_PERSON_ID = $inforpersonuser_5->ID;
                     $add_person5->READ_STATUS = 'False';
                     $add_person5->SEND_BY_ID = $SEND_BY_ID;
                     $add_person5->SEND_BY_NAME = $SEND_BY_NAME;
                     $add_person5->SEND_DATE_TIME = date('Y-m-d H:i:s');
                     $add_person5->SEND_TYPE = '3';
                    $add_person5->save();
                 }
            }
 
            
 
        }
    }
    
    if($request->MEMBER_ID != '' || $request->MEMBER_ID != null){
 
    $MEMBER_ID = $request->MEMBER_ID;
    $number =count($MEMBER_ID);
    $count = 0;
    for($count = 0; $count < $number; $count++)
    {  
 
        $check6 = DB::table('gbook_send_person')
        ->where('BOOK_ID','=',$bookid)
        ->where('HR_PERSON_ID','=',$MEMBER_ID[$count])
        ->count(); 
         
       
       if($check6== 0){
 
        $add_person6 = new Booksendcommand();
        $add_person6->BOOK_ID = $bookid;
        $add_person6->HR_PERSON_ID = $MEMBER_ID[$count];
        $add_person6->READ_STATUS = 'False';
        $add_person6->SEND_BY_ID = $SEND_BY_ID;
        $add_person6->SEND_BY_NAME = $SEND_BY_NAME;
        $add_person6->SEND_DATE_TIME = date('Y-m-d H:i:s');
        $add_person6->SEND_TYPE = '4';
        $add_person6->save();
 
       }
 
 
    }
 
   }



   if($request->ORG_ID != '' || $request->ORG_ID != null){
  
    $ORG_ID = $request->ORG_ID;
    $number_7 =count($ORG_ID);
    $count_7 = 0;
    for($count_7 = 0; $count_7 < $number_7; $count_7++)
    {  
 
 
        $add_org = new Booksendcommandorg();
        $add_org->BOOK_ID = $bookid;
        $add_org->ORG_ID = $ORG_ID[$count_7];
        $add_org->save();
 
       }
 
 
    }
 
        return redirect()->route('mbook.infobookcommand');
    }
 
 
    
    public function saverpresentcomdoc(Request $request)
    {
 
        $bookid = $request->BOOK_ID;
 
        $checksendleader = DB::table('gbook_send_command_leader')
        ->where('BOOK_LD_ID','=',$bookid)
        ->count(); 
     
       
        
        $date = date('Y-m-d');
        $datetime = date('Y-m-d H:i:s');
        
        $info_org = DB::table('info_org')->first();
 
 
        if($checksendleader !== 0 ){
 
            $sendid = DB::table('gbook_send_command_leader')
            ->where('BOOK_LD_ID','=',$bookid)
            ->first(); 
 
            if($request->SEND_LD_DETAIL_2 == '' ){
 
                $SEND_LD_BY_HR_NAME_2 = '';
                $SEND_LD_DETAIL_2 = '';
                $SEND_LD_BY_HR_ID_2 = null;
 
            }else{
                $SEND_LD_BY_HR_NAME_2 = $request->SEND_LD_BY_HR_NAME_2 ;
                $SEND_LD_DETAIL_2 = $request->SEND_LD_DETAIL_2;
                $SEND_LD_BY_HR_ID_2 =$request->SEND_LD_BY_HR_ID_2;
            }
 
 
 
            $addpresent = Booksendcommandleader::find($sendid->SEND_LD_ID);
            $addpresent->BOOK_LD_ID = $request->BOOK_ID;
            $addpresent->SEND_LD_HR_ID = $info_org->ORG_LEADER_ID;
            $addpresent->SEND_LD_HR_NAME = $info_org->ORG_LEADER;
            $addpresent->SEND_LD_BY_HR_ID = $request->SEND_LD_BY_HR_ID;
            $addpresent->SEND_LD_BY_HR_NAME = $request->SEND_LD_BY_HR_NAME;
            $addpresent->SEND_LD_DETAIL = $request->SEND_LD_DETAIL;
            $addpresent->SEND_LD_BY_HR_ID_2 = $SEND_LD_BY_HR_ID_2;
            $addpresent->SEND_LD_BY_HR_NAME_2  = $SEND_LD_BY_HR_NAME_2;
            $addpresent->SEND_LD_DETAIL_2  = $SEND_LD_DETAIL_2;
    
            $addpresent->SEND_LD_DATE = $date;
            $addpresent->SEND_LD_DATE_TIME = $datetime;
            $addpresent->SEND_LD_STATUS = 'SEND';
            $addpresent->save();
 
 
        }else{
        $addpresent = new Booksendcommandleader(); 
        $addpresent->BOOK_LD_ID = $request->BOOK_ID;
        $addpresent->SEND_LD_HR_ID = $info_org->ORG_LEADER_ID;
        $addpresent->SEND_LD_HR_NAME = $info_org->ORG_LEADER;
        $addpresent->SEND_LD_BY_HR_ID = $request->SEND_LD_BY_HR_ID;
        $addpresent->SEND_LD_BY_HR_NAME = $request->SEND_LD_BY_HR_NAME;
        $addpresent->SEND_LD_DETAIL = $request->SEND_LD_DETAIL;
        $addpresent->SEND_LD_BY_HR_ID_2 = $request->SEND_LD_BY_HR_ID_2 ;
        $addpresent->SEND_LD_BY_HR_NAME_2  = $request->SEND_LD_BY_HR_NAME_2 ;
        $addpresent->SEND_LD_DETAIL_2  = $request->SEND_LD_DETAIL_2 ;
 
        $addpresent->SEND_LD_DATE = $date;
        $addpresent->SEND_LD_DATE_TIME = $datetime;
        $addpresent->SEND_LD_STATUS = 'SEND';
        $addpresent->save();
 
        }
        $iduser = $request->ID_USER;
 
        return redirect()->route('mbook.infobookentcomdoccontrol',[
            'id' => $bookid
        ]);
        }
 
        public function saveretirecomdoc(Request $request)
        {
           
            $date = date('Y-m-d');
            $datetime = date('Y-m-d H:i:s');
            
            $info_org = DB::table('info_org')->first();
            $bookid = $request->BOOK_ID;
            
    
                         
            $addretire = Booksendcommandleader::find($request->SEND_LD_ID);
            $addretire->TOP_LEADER_AC_ID = $info_org->ORG_LEADER_ID;
            $addretire->TOP_LEADER_AC_NAME = $info_org->ORG_LEADER;
            $addretire->TOP_LEADER_AC_CMD = $request->TOP_LEADER_AC_CMD;
            $addretire->TOP_LEADER_AC_DATE = $date;
            $addretire->TOP_LEADER_AC_DATE_TIME = $datetime;
            $addretire->SEND_LD_STATUS = 'ํYES';
            $addretire->save();
    
            $addpresentupstatus = Bookindexcommand::find($request->BOOK_ID);
            $addpresentupstatus->save();
            
    
            $iduser = $request->ID_USER;
            return redirect()->route('mbook.infobookentcomdoccontrol',[
                'id' => $bookid
            ]);
        }

        //===============================ประกาศ==============================

        public function infobookannounce(Request $request)
        {
            if(!empty($request->_token)){
                $yearbudget = $request->YEAR_ID;
                $search = $request->get('search');
                $datebigin = $request->get('DATE_BIGIN');
                $dateend = $request->get('DATE_END');
                session([
                    'manager_book.bookannounce.search' => $search,
                    'manager_book.bookannounce.datebigin' => $datebigin,
                    'manager_book.bookannounce.dateend' => $dateend,
                    'manager_book.bookannounce.yearbudget' => $yearbudget,
                ]);
            }elseif(!empty(session('manager_book.bookannounce'))){
                $yearbudget = session('manager_book.bookannounce.yearbudget');
                $search = session('manager_book.bookannounce.search');
                $datebigin = session('manager_book.bookannounce.datebigin');
                $dateend = session('manager_book.bookannounce.dateend');
            }else{
                $yearbudget = date('Y')+543;
                $search = '';
                $datebigin = date('1/m/Y');
                $dateend   = date('d/m/Y', strtotime(date('Y-m-1'). '+1month -1days'));
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
    
                    $infobookannounce=  Bookindexannounce::leftJoin('grecord_org','gbook_index_announce.BOOK_ORG_ID','=','grecord_org.RECORD_ORG_ID')
                    ->leftJoin('hrd_person','gbook_index_announce.PERSON_SAVE_ID','=','hrd_person.ID')
                    ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                    ->leftJoin('gbook_send_announce_leader','gbook_index_announce.BOOK_ID','=','gbook_send_announce_leader.BOOK_LD_ID')
                    ->where(function($q) use ($search){
                                $q->where('BOOK_NUM_IN','like','%'.$search.'%');
                                $q->orwhere('BOOK_NUMBER','like','%'.$search.'%');
                                $q->orwhere('BOOK_NAME','like','%'.$search.'%');
                                $q->orwhere('BOOK_DETAIL','like','%'.$search.'%');
                    })
                    ->WhereBetween('DATE_SAVE',[$from,$to]) 
                    ->orderBy('gbook_index_announce.BOOK_ID', 'desc')    
                    ->get();
            $iduser  = Auth::user()->PERSON_ID; 
            $infobooksend = DB::table('hrd_person')
            ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
            ->where('hrd_person.ID','=',$iduser)
            ->first();
    
            $infobookstatus1 = DB::table('gbook_status')
            ->where('BOOK_STATUS_ID','=','1')
            ->first();
            $infobookstatus2 = DB::table('gbook_status')
            ->where('BOOK_STATUS_ID','=','2')
            ->first();
            $infobookstatus3 = DB::table('gbook_status')
            ->where('BOOK_STATUS_ID','=','3')
            ->first();
          
            $infobook_sendstatus = DB::table('gbook_status')
            ->get();
      
            $budget = getYearAmount();
            $year_id = $yearbudget;
            
            return view('manager_book.infobookannounce',[
                'infobookannounces' =>$infobookannounce,
                'infobookstatus1'=> $infobookstatus1, 
                'infobookstatus2'=> $infobookstatus2,
                'infobookstatus3'=> $infobookstatus3,
                'infobooksend'=>   $infobooksend,
                'infobook_sendstatuss'=> $infobook_sendstatus,
                'displaydate_bigen'=> $displaydate_bigen, 
                'displaydate_end'=> $displaydate_end,
                'search'=> $search,
                'budgets' =>  $budget,
                'year_id'=>$year_id
              ]);
        }


        public function infobookannouncesearch(Request $request)
        {
            $search = $request->get('search');
            $datebigin = $request->get('DATE_BIGIN');
            $dateend = $request->get('DATE_END');
            $yearbudget = $request->YEAR_ID;

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
    
                    $infobookannounce=  Bookindexannounce::leftJoin('grecord_org','gbook_index_announce.BOOK_ORG_ID','=','grecord_org.RECORD_ORG_ID')
                    ->leftJoin('hrd_person','gbook_index_announce.PERSON_SAVE_ID','=','hrd_person.ID')
                    ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                    ->leftJoin('gbook_send_announce_leader','gbook_index_announce.BOOK_ID','=','gbook_send_announce_leader.BOOK_LD_ID')
                    ->where(function($q) use ($search){
                                $q->where('BOOK_NUM_IN','like','%'.$search.'%');
                                $q->orwhere('BOOK_NUMBER','like','%'.$search.'%');
                                $q->orwhere('BOOK_NAME','like','%'.$search.'%');
                                $q->orwhere('BOOK_DETAIL','like','%'.$search.'%');

                                
          
                    })
                    ->WhereBetween('DATE_SAVE',[$from,$to]) 
                    ->orderBy('gbook_index_announce.BOOK_ID', 'desc')    
                    ->get();
            $iduser  = Auth::user()->PERSON_ID; 
            $infobooksend = DB::table('hrd_person')
            ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
            ->where('hrd_person.ID','=',$iduser)
            ->first();
    
            $infobookstatus1 = DB::table('gbook_status')
            ->where('BOOK_STATUS_ID','=','1')
            ->first();
            $infobookstatus2 = DB::table('gbook_status')
            ->where('BOOK_STATUS_ID','=','2')
            ->first();
            $infobookstatus3 = DB::table('gbook_status')
            ->where('BOOK_STATUS_ID','=','3')
            ->first();
          
            $infobook_sendstatus = DB::table('gbook_status')
            ->get();
      
            $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
            $year_id = $yearbudget;
            
            return view('manager_book.infobookannounce',[
                'infobookannounces' =>$infobookannounce,
                'infobookstatus1'=> $infobookstatus1, 
                'infobookstatus2'=> $infobookstatus2,
                'infobookstatus3'=> $infobookstatus3,
                'infobooksend'=>   $infobooksend,
                'infobook_sendstatuss'=> $infobook_sendstatus,
                'displaydate_bigen'=> $displaydate_bigen, 
                'displaydate_end'=> $displaydate_end,
                'search'=> $search,
                'budgets' =>  $budget,
                'year_id'=>$year_id
              ]);
        }

        
        public function bookannounce_excel(Request $request, $datebegin, $dateen, $search)
        {
 
         $from = $datebegin;
         $to   = $dateen;
 
         if ($search == 'null') {
             $search = '';
         }
                        $infobookannounce=  Bookindexannounce::leftJoin('grecord_org','gbook_index_announce.BOOK_ORG_ID','=','grecord_org.RECORD_ORG_ID')
                        ->leftJoin('hrd_person','gbook_index_announce.PERSON_SAVE_ID','=','hrd_person.ID')
                        ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                        ->leftJoin('gbook_send_announce_leader','gbook_index_announce.BOOK_ID','=','gbook_send_announce_leader.BOOK_LD_ID')
                        ->where(function($q) use ($search){
                                    $q->where('BOOK_NUM_IN','like','%'.$search.'%');
                                    $q->orwhere('BOOK_NUMBER','like','%'.$search.'%');
                                    $q->orwhere('BOOK_NAME','like','%'.$search.'%');
                                    $q->orwhere('BOOK_DETAIL','like','%'.$search.'%');   
                        })
                        ->WhereBetween('DATE_SAVE',[$from,$to]) 
                        ->orderBy('gbook_index_announce.BOOK_ID', 'desc')    
                        ->get();
                $iduser  = Auth::user()->PERSON_ID; 
                $infobooksend = DB::table('hrd_person')
                ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                ->where('hrd_person.ID','=',$iduser)
                ->first();

                $infobookstatus1 = DB::table('gbook_status')
                ->where('BOOK_STATUS_ID','=','1')
                ->first();
                $infobookstatus2 = DB::table('gbook_status')
                ->where('BOOK_STATUS_ID','=','2')
                ->first();
                $infobookstatus3 = DB::table('gbook_status')
                ->where('BOOK_STATUS_ID','=','3')
                ->first();

                $infobook_sendstatus = DB::table('gbook_status')
                ->get();

                $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();


            return view('manager_book.infobookannounce_excel',[
                'infobookannounces' =>$infobookannounce,
                'infobookstatus1'=> $infobookstatus1, 
                'infobookstatus2'=> $infobookstatus2,
                'infobookstatus3'=> $infobookstatus3,
                'infobook_sendstatuss'=>   $infobook_sendstatus,
         
               ]);
        }



        public function infobookannounceinsert()
        {
            $budgetyear = DB::table('budget_year')->get();
            $booktype = DB::table('gbook_type')->get();
            $bookinstant = DB::table('gbook_instant')->get();
            $booksecret = DB::table('gbook_secret')->get();
            $bookorg = DB::table('grecord_org')->get();
            
            $iduser  = Auth::user()->PERSON_ID; 
            $infobooksave = DB::table('hrd_person')
            ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
            ->where('hrd_person.ID','=',$iduser)
            ->first();
    
    
            return view('manager_book.infobookannounce_add',[
                'budgetyears' =>$budgetyear,
                'booktypes'=>$booktype,
                'bookinstants'=>$bookinstant,
                'booksecrets'=>$booksecret,
                'bookorgs'=>$bookorg,
                'infobooksave' => $infobooksave
         
               ]);
        }
  
  
        public function infobookannouncesave(Request $request)
        {
            $BOOK_DATE= $request->BOOK_DATE;
            $BOOK_DATE_EXPIRE=$request->BOOK_DATE_EXPIRE;
            $DATE_SAVE=$request->DATE_SAVE;
    
            if($BOOK_DATE != ''){
                $STARTDAY = Carbon::createFromFormat('d/m/Y', $BOOK_DATE)->format('Y-m-d');
                $date_arrary_st=explode("-",$STARTDAY);  
                $y_sub_st = $date_arrary_st[0]; 
                
                if($y_sub_st >= 2500){
                    $y_st = $y_sub_st-543;
                }else{
                    $y_st = $y_sub_st;
                }
                $m_st = $date_arrary_st[1];
                $d_st = $date_arrary_st[2];  
                $BOOKDATE= $y_st."-".$m_st."-".$d_st;
                }else{
                $BOOKDATE= null;
            }
    
            if($BOOK_DATE_EXPIRE != ''){
                $STARTDAY = Carbon::createFromFormat('d/m/Y', $BOOK_DATE_EXPIRE)->format('Y-m-d');
                $date_arrary_st=explode("-",$STARTDAY);  
                $y_sub_st = $date_arrary_st[0]; 
                
                if($y_sub_st >= 2500){
                    $y_st = $y_sub_st-543;
                }else{
                    $y_st = $y_sub_st;
                }
                $m_st = $date_arrary_st[1];
                $d_st = $date_arrary_st[2];  
                $BOOKDATEEXPIRE= $y_st."-".$m_st."-".$d_st;
                }else{
                $BOOKDATEEXPIRE= null;
            }
    
            if($DATE_SAVE != ''){
                $STARTDAY = Carbon::createFromFormat('d/m/Y', $DATE_SAVE)->format('Y-m-d');
                $date_arrary_st=explode("-",$STARTDAY);  
                $y_sub_st = $date_arrary_st[0]; 
                
                if($y_sub_st >= 2500){
                    $y_st = $y_sub_st-543;
                }else{
                    $y_st = $y_sub_st;
                }
                $m_st = $date_arrary_st[1];
                $d_st = $date_arrary_st[2];  
                $DATESAVE= $y_st."-".$m_st."-".$d_st;
                }else{
                $DATESAVE= null;
            }
    
    
            $addannounce = new Bookindexannounce(); 
            $addannounce->BOOK_NUM_IN = $request->BOOK_NUM_IN;
            $addannounce->BOOK_YEAR_ID = $request->BOOK_YEAR_ID;
            $addannounce->BOOK_URGENT_ID = $request->BOOK_URGENT_ID;
            $addannounce->BOOK_SECRET_ID = $request->BOOK_SECRET_ID;
    
            $addannounce->BOOK_DATE = $BOOKDATE;
            $addannounce->BOOK_DATE_EXPIRE = $BOOKDATEEXPIRE;
            $addannounce->DATE_SAVE = $DATESAVE;
            $addannounce->TIME_SAVE = $request->TIME_SAVE;
    
            $addannounce->BOOK_NUMBER = $request->BOOK_NUMBER;
            $addannounce->BOOK_TYPE_ID = $request->BOOK_TYPE_ID;
            $addannounce->BOOK_NAME = $request->BOOK_NAME;
            $addannounce->BOOK_ORG_ID = $request->BOOK_ORG_ID;
            $addannounce->PERSON_SAVE_ID = $request->PERSON_SAVE_ID;
            $addannounce->BOOK_DETAIL = $request->BOOK_DETAIL;
            $addannounce->SEND_STATUS = '1';
    
            $maxid = Bookindexannounce::max('BOOK_ID');
            $idfile = $maxid+1;
            if($request->hasFile('pdfupload')){
                $newFileName = 'announce_'.$idfile.'.'.$request->pdfupload->extension();
                  
                $request->pdfupload->storeAs('bookpdf',$newFileName,'public');
    
                $addannounce->BOOK_HAVE_FILE = 'True';
                $addannounce->BOOK_FILE_NAME = $newFileName;
                
    
            }
    
            $addannounce->save();
    
            $bookid = $request->BOOK_ID; 
    
            return redirect()->route('mbook.infobookannounce',[
                'id' => $bookid
            ]);
        }


        public function infobookannounceedit(Request $request,$id)
        {
            $budgetyear = DB::table('budget_year')->get();
            $booktype = DB::table('gbook_type')->get();
            $bookinstant = DB::table('gbook_instant')->get();
            $booksecret = DB::table('gbook_secret')->get();
            $bookorg = DB::table('grecord_org')->get();
            
            $iduser  = Auth::user()->PERSON_ID; 
            $infobooksave = DB::table('hrd_person')
            ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
            ->where('hrd_person.ID','=',$iduser)
            ->first();
    
            $infobookedit= Bookindexannounce::leftJoin('grecord_org','gbook_index_announce.BOOK_ORG_ID','=','grecord_org.RECORD_ORG_ID')
            ->leftJoin('hrd_person','gbook_index_announce.PERSON_SAVE_ID','=','hrd_person.ID')
            ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
            ->where('gbook_index_announce.BOOK_ID','=',$id)
            ->first();
    
    
            return view('manager_book.infobookannounce_edit',[
                'budgetyears' =>$budgetyear,
                'booktypes'=>$booktype,
                'bookinstants'=>$bookinstant,
                'booksecrets'=>$booksecret,
                'bookorgs'=>$bookorg,
                'infobooksave' => $infobooksave,
                'infobookedit' => $infobookedit
         
               ]);
        }


        public function infobookannounceupdate(Request $request)
        {
            $BOOK_DATE= $request->BOOK_DATE;
            $BOOK_DATE_EXPIRE=$request->BOOK_DATE_EXPIRE;
            $DATE_SAVE=$request->DATE_SAVE;
    
            if($BOOK_DATE != ''){
                $STARTDAY = Carbon::createFromFormat('d/m/Y', $BOOK_DATE)->format('Y-m-d');
                $date_arrary_st=explode("-",$STARTDAY);  
                $y_sub_st = $date_arrary_st[0]; 
                
                if($y_sub_st >= 2500){
                    $y_st = $y_sub_st-543;
                }else{
                    $y_st = $y_sub_st;
                }
                $m_st = $date_arrary_st[1];
                $d_st = $date_arrary_st[2];  
                $BOOKDATE= $y_st."-".$m_st."-".$d_st;
                }else{
                $BOOKDATE= null;
            }
    
            if($BOOK_DATE_EXPIRE != ''){
                $STARTDAY = Carbon::createFromFormat('d/m/Y', $BOOK_DATE_EXPIRE)->format('Y-m-d');
                $date_arrary_st=explode("-",$STARTDAY);  
                $y_sub_st = $date_arrary_st[0]; 
                
                if($y_sub_st >= 2500){
                    $y_st = $y_sub_st-543;
                }else{
                    $y_st = $y_sub_st;
                }
                $m_st = $date_arrary_st[1];
                $d_st = $date_arrary_st[2];  
                $BOOKDATEEXPIRE= $y_st."-".$m_st."-".$d_st;
                }else{
                $BOOKDATEEXPIRE= null;
            }
    
            if($DATE_SAVE != ''){
                $STARTDAY = Carbon::createFromFormat('d/m/Y', $DATE_SAVE)->format('Y-m-d');
                $date_arrary_st=explode("-",$STARTDAY);  
                $y_sub_st = $date_arrary_st[0]; 
                
                if($y_sub_st >= 2500){
                    $y_st = $y_sub_st-543;
                }else{
                    $y_st = $y_sub_st;
                }
                $m_st = $date_arrary_st[1];
                $d_st = $date_arrary_st[2];  
                $DATESAVE= $y_st."-".$m_st."-".$d_st;
                }else{
                $DATESAVE= null;
            }
    
    
            $updateannounce = Bookindexannounce::find($request->BOOK_ID);
            $updateannounce->BOOK_NUM_IN = $request->BOOK_NUM_IN;
            $updateannounce->BOOK_YEAR_ID = $request->BOOK_YEAR_ID;
            $updateannounce->BOOK_URGENT_ID = $request->BOOK_URGENT_ID;
            $updateannounce->BOOK_SECRET_ID = $request->BOOK_SECRET_ID;
    
            $updateannounce->BOOK_DATE = $BOOKDATE;
            $updateannounce->BOOK_DATE_EXPIRE = $BOOKDATEEXPIRE;
            $updateannounce->DATE_SAVE = $DATESAVE;
            $updateannounce->TIME_SAVE = $request->TIME_SAVE;
            $updateannounce->BOOK_USE = $request->BOOK_USE;
    
            $updateannounce->BOOK_NUMBER = $request->BOOK_NUMBER;
            $updateannounce->BOOK_TYPE_ID = $request->BOOK_TYPE_ID;
            $updateannounce->BOOK_NAME = $request->BOOK_NAME;
            $updateannounce->BOOK_ORG_ID = $request->BOOK_ORG_ID;
            $updateannounce->PERSON_SAVE_ID = $request->PERSON_SAVE_ID;
            $updateannounce->BOOK_DETAIL = $request->BOOK_DETAIL;
            $updateannounce->SEND_STATUS = '1';
    
          
            $idfile = $request->BOOK_ID;
            if($request->hasFile('pdfupload')){
                $newFileName = 'announce_'.$idfile.'.'.$request->pdfupload->extension();  
                $request->pdfupload->storeAs('bookpdf',$newFileName,'public');
                $updateannounce->BOOK_HAVE_FILE = 'True';
                $updateannounce->BOOK_FILE_NAME = $newFileName;
    
            }
    
            $updateannounce->save();
    
            $bookid = $request->BOOK_ID; 
    
            return redirect()->route('mbook.infobookannounce',[
                'id' => $bookid
            ]);
        }
    


         //---------------จัดการประกาศ

     public function infobookentannouncecontrol(Request $request,$id)
     {
        $iduser  = Auth::user()->PERSON_ID; 
         
       $infobooksend = DB::table('hrd_person')
       ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
       ->where('hrd_person.ID','=',$iduser)
       ->first();


        $idbook = $id;
 
 
        $infobookreceiptview = Bookindexannounce::leftJoin('grecord_org','gbook_index_announce.BOOK_ORG_ID','=','grecord_org.RECORD_ORG_ID')
        ->leftJoin('hrd_person','gbook_index_announce.PERSON_SAVE_ID','=','hrd_person.ID')
        ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('gbook_send_announce_leader','gbook_index_announce.BOOK_ID','=','gbook_send_announce_leader.BOOK_LD_ID')
        ->leftJoin('gbook_instant','gbook_index_announce.BOOK_URGENT_ID','=','gbook_instant.INSTANT_ID')
        ->where('gbook_index_announce.BOOK_ID','=',$idbook)
        ->first();
         
         $bookdepartment = DB::table('hrd_department')->get();
         $bookdepartmentsub  = DB::table('hrd_department_sub')->get();
         $bookdepartmentsubsub  = DB::table('hrd_department_sub_sub')->get();


         //-----------ความเห็น-----------------
         $checksendleader = DB::table('gbook_send_announce_leader')
         ->where('BOOK_LD_ID','=',$idbook)
         ->count(); 

         if($checksendleader !== 0 ){
           $sendleaderquery  = DB::table('gbook_send_announce_leader')
           ->where('BOOK_LD_ID','=',$idbook)
           ->first();
           
           $sendleader = $sendleaderquery->TOP_LEADER_AC_CMD;


           $sendleaderdetailid = $sendleaderquery->SEND_LD_BY_HR_ID;
           $sendleaderdetail = $sendleaderquery->SEND_LD_DETAIL;
           $sendleaderhrname = $sendleaderquery->SEND_LD_BY_HR_NAME;
           $sendleaderdetailid2 = $sendleaderquery->SEND_LD_BY_HR_ID_2;
           $sendleaderdetail2 = $sendleaderquery->SEND_LD_DETAIL_2;
           $sendleaderhrname2 = $sendleaderquery->SEND_LD_BY_HR_NAME_2;


         }else{
           $sendleader = '';
           
           $sendleaderdetailid = '';
           $sendleaderdetail = '';
           $sendleaderhrname = '';
           $sendleaderdetailid2 = '';
           $sendleaderdetail2 = '';
           $sendleaderhrname2 = '';
         }
          //----------------------------

          $booksend = DB::table('gbook_send_announce_depart')->where('BOOK_ID','=',$idbook)->get();
          $booksendsub = DB::table('gbook_send_announce_sub')->where('BOOK_ID','=',$idbook)->get();
          $booksendsubsub = DB::table('gbook_send_announce_sub_sub')->where('BOOK_ID','=',$idbook)->get();
      
             //--------------------------------------------
             $infordepartment  =  DB::table('hrd_department')->get();

             $inforsenddepartments =  DB::table('gbook_send_announce_depart')
             ->where('BOOK_ID','=',$idbook)
             ->get(); 
  
             $checksendinfordepartment = DB::table('gbook_send_announce_depart')
             ->where('BOOK_ID','=',$idbook)
             ->count(); 
  
              //--------------------------------------------
             $infordepartmentsub  =  DB::table('hrd_department_sub')->get();

             $inforsenddepartmentsubs =  DB::table('gbook_send_announce_sub')
             ->where('BOOK_ID','=',$idbook)
             ->get(); 
  
             $checksendinfordepartmentsub = DB::table('gbook_send_announce_sub')
             ->where('BOOK_ID','=',$idbook)
             ->count(); 
  
              //--------------------------------------------
             $infordepartmentsubsub  =  DB::table('hrd_department_sub_sub')->get();

             $inforsenddepartmentsubsubs =  DB::table('gbook_send_announce_sub_sub')
             ->where('BOOK_ID','=',$idbook)
             ->get(); 
  
             $checksendinfordepartmentsubsub = DB::table('gbook_send_announce_sub_sub')
             ->where('BOOK_ID','=',$idbook)
             ->count(); 
  
              //--------------------------------------------
          $inforposition  =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')->orderBy('hrd_person.HR_FNAME', 'asc')->get();

          $infosendbooks =  DB::table('gbook_send_announce')
          ->where('BOOK_ID','=',$idbook)
          ->where('SEND_TYPE','=','4')
          ->get(); 

          $checksendbookper = DB::table('gbook_send_announce')
          ->where('BOOK_ID','=',$idbook)
          ->where('SEND_TYPE','=','4')
         ->count(); 

           //--------------------------------------------

         return view('manager_book.infobookannounce_control',[
             'infobookreceiptview' =>$infobookreceiptview,
             'idbook' => $idbook,
             'infobooksend' => $infobooksend,
             'bookdepartments'=>$bookdepartment, 
             'bookdepartmentsubs'=>$bookdepartmentsub,
             'bookdepartmentsubsubs'=>$bookdepartmentsubsub,
             'sendleader' => $sendleader,
             'sendleaderdetail' => $sendleaderdetail,
             'sendleaderhrname' => $sendleaderhrname,
             'sendleaderdetail2' => $sendleaderdetail2,
             'sendleaderhrname2' => $sendleaderhrname2,
             'booksends' => $booksend,
             'booksendsubs' => $booksendsub,
             'booksendsubsubs' => $booksendsubsub,
             'checksendleader'=>$checksendleader,
             'iduser' => $iduser,
             'sendleaderdetailid' => $sendleaderdetailid,
             'sendleaderdetailid2' => $sendleaderdetailid2,
             'inforpositions' => $inforposition,
             'checksendbookper' => $checksendbookper,
             'infosendbooks' => $infosendbooks,
             'infordepartments' => $infordepartment,
             'checksendinfordepartment' => $checksendinfordepartment,
             'inforsenddepartments' => $inforsenddepartments,
             'infordepartmentsubs' => $infordepartmentsub,
             'checksendinfordepartmentsub' => $checksendinfordepartmentsub,
             'inforsenddepartmentsubs' => $inforsenddepartmentsubs,
             'infordepartmentsubsubs' => $infordepartmentsubsub,
             'checksendinfordepartmentsubsub' => $checksendinfordepartmentsubsub,
             'inforsenddepartmentsubsubs' => $inforsenddepartmentsubsubs
      
            ]);
     }

     
   public function sendannounce(Request $request)
   {
       $iduser = $request->ID_USER;
       $bookid = $request->BOOK_ID;
       $SEND_BY_ID = $request->SEND_BY_ID;
       $SEND_BY_NAME = $request->SEND_BY_NAME;

       Booksendannouncedepart::where('BOOK_ID','=',$bookid)->delete(); 
       Booksendannouncedepartsub::where('BOOK_ID','=',$bookid)->delete();
       Booksendannouncedepartsubsub::where('BOOK_ID','=',$bookid)->delete();  
       Booksendannounce::where('BOOK_ID','=',$bookid)->delete();  

   if($request->row3 != '' || $request->row3 != null){
       $row3 = $request->row3;
       $number_3 =count($row3);
       $count_3 = 0;
       for($count_3 = 0; $count_3 < $number_3; $count_3++)
       {    
          $add_3 = new Booksendannouncedepart();
          $add_3->BOOK_ID = $bookid;
          $add_3->HR_DEPARTMENT_ID = $row3[$count_3];
          $add_3->save(); 
        
          $inforpersonusers =  Person::where('HR_DEPARTMENT_ID','=',$row3[$count_3])->get(); 

          foreach($inforpersonusers as $inforpersonuser){

            $check3 = DB::table('gbook_send_announce')
            ->where('BOOK_ID','=',$bookid)
            ->where('HR_PERSON_ID','=',$inforpersonuser->ID)
            ->count(); 

            if($check3== 0){
           
                   $add_person3 = new Booksendannounce();
                   $add_person3->BOOK_ID = $bookid;
                   $add_person3->HR_PERSON_ID = $inforpersonuser->ID;
                   $add_person3->READ_STATUS = 'False';
                   $add_person3->SEND_BY_ID = $SEND_BY_ID;
                   $add_person3->SEND_BY_NAME = $SEND_BY_NAME;
                   $add_person3->SEND_DATE_TIME = date('Y-m-d H:i:s');
                   $add_person3->SEND_TYPE = '1';
                   $add_person3->save();

                }
          }


       }
   }

   if($request->row4 != '' || $request->row4 != null){

       $row4 = $request->row4;
       $number_4 =count($row4);
       $count_4 = 0;
       for($count_4 = 0; $count_4 < $number_4; $count_4++)
       {  
          $add_4 = new Booksendannouncedepartsub();
          $add_4->BOOK_ID = $bookid;
          $add_4->HR_DEPARTMENT_SUB_ID = $row4[$count_4];
          $add_4->save(); 

          //------เช็คตัวซ้ำก่อน------

          $inforpersonusers_4 =  Person::where('HR_DEPARTMENT_SUB_ID','=',$row4[$count_4])->get(); 

          foreach($inforpersonusers_4 as $inforpersonuser_4){
                  
                $check4 = DB::table('gbook_send_announce')
                ->where('BOOK_ID','=',$bookid)
                ->where('HR_PERSON_ID','=',$inforpersonuser_4->ID)
                ->count(); 
                 
               
               if($check4== 0){
                   $add_person4 = new Booksendannounce();
                   $add_person4->BOOK_ID = $bookid;
                   $add_person4->HR_PERSON_ID = $inforpersonuser_4->ID;
                   $add_person4->READ_STATUS = 'False';
                   $add_person4->SEND_BY_ID = $SEND_BY_ID;
                   $add_person4->SEND_BY_NAME = $SEND_BY_NAME;
                   $add_person4->SEND_DATE_TIME = date('Y-m-d H:i:s');
                   $add_person4->SEND_TYPE = '2';
                  $add_person4->save();
               }
          }

       }
   }

   if($request->row5 != '' || $request->row5 != null){
       $row5 = $request->row5;
       $number_5 =count($row5);
       $count_5 = 0;
       for($count_5 = 0; $count_5 < $number_5; $count_5++)
       {  
          $add_5 = new Booksendannouncedepartsubsub();
          $add_5->BOOK_ID = $bookid;
          $add_5->HR_DEPARTMENT_SUB_SUB_ID = $row5[$count_5];
          $add_5->save(); 

           //------เช็คตัวซ้ำก่อน------

           $inforpersonusers_5 =  Person::where('HR_DEPARTMENT_SUB_SUB_ID','=',$row5[$count_5])->get(); 

           foreach($inforpersonusers_5 as $inforpersonuser_5){
                   
                 $check5 = DB::table('gbook_send_announce')
                 ->where('BOOK_ID','=',$bookid)
                 ->where('HR_PERSON_ID','=',$inforpersonuser_5->ID)
                 ->count(); 
                  
                
                if($check5== 0){
                    $add_person5 = new Booksendannounce();
                    $add_person5->BOOK_ID = $bookid;
                    $add_person5->HR_PERSON_ID = $inforpersonuser_5->ID;
                    $add_person5->READ_STATUS = 'False';
                    $add_person5->SEND_BY_ID = $SEND_BY_ID;
                    $add_person5->SEND_BY_NAME = $SEND_BY_NAME;
                    $add_person5->SEND_DATE_TIME = date('Y-m-d H:i:s');
                    $add_person5->SEND_TYPE = '3';
                   $add_person5->save();
                }
           }

           

       }
   }
   
   if($request->MEMBER_ID != '' || $request->MEMBER_ID != null){

   $MEMBER_ID = $request->MEMBER_ID;
   $number =count($MEMBER_ID);
   $count = 0;
   for($count = 0; $count < $number; $count++)
   {  

       $check6 = DB::table('gbook_send_announce')
       ->where('BOOK_ID','=',$bookid)
       ->where('HR_PERSON_ID','=',$MEMBER_ID[$count])
       ->count(); 
        
      
      if($check6== 0){

       $add_person6 = new Booksendannounce();
       $add_person6->BOOK_ID = $bookid;
       $add_person6->HR_PERSON_ID = $MEMBER_ID[$count];
       $add_person6->READ_STATUS = 'False';
       $add_person6->SEND_BY_ID = $SEND_BY_ID;
       $add_person6->SEND_BY_NAME = $SEND_BY_NAME;
       $add_person6->SEND_DATE_TIME = date('Y-m-d H:i:s');
       $add_person6->SEND_TYPE = '4';
       $add_person6->save();

      }


   }

  }

       return redirect()->route('mbook.infobookannounce');
   }


   
   public function saverpresentannounce(Request $request)
   {

       $bookid = $request->BOOK_ID;

       $checksendleader = DB::table('gbook_send_announce_leader')
       ->where('BOOK_LD_ID','=',$bookid)
       ->count(); 
    
      

       $date = date('Y-m-d');
       $datetime = date('Y-m-d H:i:s');
       
       $info_org = DB::table('info_org')->first();


       if($checksendleader !== 0 ){

           $sendid = DB::table('gbook_send_announce_leader')
           ->where('BOOK_LD_ID','=',$bookid)
           ->first(); 

           if($request->SEND_LD_DETAIL_2 == '' ){

               $SEND_LD_BY_HR_NAME_2 = '';
               $SEND_LD_DETAIL_2 = '';
               $SEND_LD_BY_HR_ID_2 = null;

           }else{
               $SEND_LD_BY_HR_NAME_2 = $request->SEND_LD_BY_HR_NAME_2 ;
               $SEND_LD_DETAIL_2 = $request->SEND_LD_DETAIL_2;
               $SEND_LD_BY_HR_ID_2 =$request->SEND_LD_BY_HR_ID_2;
           }



           $addpresent = Booksendannounceleader::find($sendid->SEND_LD_ID);
           $addpresent->BOOK_LD_ID = $request->BOOK_ID;
           $addpresent->SEND_LD_HR_ID = $info_org->ORG_LEADER_ID;
           $addpresent->SEND_LD_HR_NAME = $info_org->ORG_LEADER;
           $addpresent->SEND_LD_BY_HR_ID = $request->SEND_LD_BY_HR_ID;
           $addpresent->SEND_LD_BY_HR_NAME = $request->SEND_LD_BY_HR_NAME;
           $addpresent->SEND_LD_DETAIL = $request->SEND_LD_DETAIL;
           $addpresent->SEND_LD_BY_HR_ID_2 = $SEND_LD_BY_HR_ID_2;
           $addpresent->SEND_LD_BY_HR_NAME_2  = $SEND_LD_BY_HR_NAME_2;
           $addpresent->SEND_LD_DETAIL_2  = $SEND_LD_DETAIL_2;
   
           $addpresent->SEND_LD_DATE = $date;
           $addpresent->SEND_LD_DATE_TIME = $datetime;
           $addpresent->SEND_LD_STATUS = 'SEND';
           $addpresent->save();


       }else{
       $addpresent = new Booksendannounceleader(); 
       $addpresent->BOOK_LD_ID = $request->BOOK_ID;
       $addpresent->SEND_LD_HR_ID = $info_org->ORG_LEADER_ID;
       $addpresent->SEND_LD_HR_NAME = $info_org->ORG_LEADER;
       $addpresent->SEND_LD_BY_HR_ID = $request->SEND_LD_BY_HR_ID;
       $addpresent->SEND_LD_BY_HR_NAME = $request->SEND_LD_BY_HR_NAME;
       $addpresent->SEND_LD_DETAIL = $request->SEND_LD_DETAIL;
       $addpresent->SEND_LD_BY_HR_ID_2 = $request->SEND_LD_BY_HR_ID_2 ;
       $addpresent->SEND_LD_BY_HR_NAME_2  = $request->SEND_LD_BY_HR_NAME_2 ;
       $addpresent->SEND_LD_DETAIL_2  = $request->SEND_LD_DETAIL_2 ;

       $addpresent->SEND_LD_DATE = $date;
       $addpresent->SEND_LD_DATE_TIME = $datetime;
       $addpresent->SEND_LD_STATUS = 'SEND';
       $addpresent->save();

       $addpresentupstatus = Bookindexannounce::find($request->BOOK_ID);
       $addpresentupstatus->SEND_STATUS = '2';
       $addpresentupstatus->save();
       }
       $iduser = $request->ID_USER;

       return redirect()->route('mbook.infobookentannouncecontrol',[
           'id' => $bookid
       ]);
       }

       public function saveretireannounce(Request $request)
       {
          
           $date = date('Y-m-d');
           $datetime = date('Y-m-d H:i:s');
           
           $info_org = DB::table('info_org')->first();
           $bookid = $request->BOOK_ID;
           
   
                        
           $addretire = Booksendannounceleader::find($request->SEND_LD_ID);
           $addretire->TOP_LEADER_AC_ID = $info_org->ORG_LEADER_ID;
           $addretire->TOP_LEADER_AC_NAME = $info_org->ORG_LEADER;
           $addretire->TOP_LEADER_AC_CMD = $request->TOP_LEADER_AC_CMD;
           $addretire->TOP_LEADER_AC_DATE = $date;
           $addretire->TOP_LEADER_AC_DATE_TIME = $datetime;
           $addretire->SEND_LD_STATUS = 'ํYES';
           $addretire->save();
   
           $addpresentupstatus = Bookindexannounce::find($request->BOOK_ID);
           $addpresentupstatus->SEND_STATUS = '3';
           $addpresentupstatus->save();
           
   
           $iduser = $request->ID_USER;
           return redirect()->route('mbook.infobookentannouncecontrol',[
               'id' => $bookid
           ]);
       }

        //===============================ฟังชันต่างๆ==============================

        function departmentrow3(Request $request)
    {

        $infordepartments=  DB::table('hrd_department')->get();

        $infordepartments_select=  DB::table('hrd_department')->get();
        $number = 0;
        foreach ( $infordepartments as  $infordepartment){ 
            $number++;
            echo '<tr><td>'; 
            echo '<select name="row3[]" id="row3'.$number.'" class="form-control input-lg" style=" font-family: \'Kanit\', sans-serif;" >';
            echo '<option value="">--กรุณาเลือกกลุ่มงาน--</option>';
                foreach ($infordepartments_select as $infordepartment_2){ 
                        if($infordepartment->HR_DEPARTMENT_ID == $infordepartment_2 ->HR_DEPARTMENT_ID){                                                    
                            echo  '<option value="'.$infordepartment_2->HR_DEPARTMENT_ID.'" selected>'.$infordepartment_2->HR_DEPARTMENT_NAME.'</option>';
                                }else{
                            echo  '<option value="'.$infordepartment_2->HR_DEPARTMENT_ID.'">'.$infordepartment_2->HR_DEPARTMENT_NAME.'</option>';
                                }
                            }              
            echo '</select>';      
            echo '</td>';                     
            echo '<td style="text-align: center;"><a class="btn btn-danger remove3" style="color:#FFFFFF;"><i class="fa fa-trash-alt"></i></a></td>';
            echo '</tr>';

            }

        
        
    }

    
    function departmentrow4(Request $request)
    {

        $infordepartments=  DB::table('hrd_department_sub')->get();

        $infordepartments_select=  DB::table('hrd_department_sub')->get();
        $number = 0;
        foreach ( $infordepartments as  $infordepartment){ 
            $number++;
            echo '<tr><td>'; 
            echo '<select name="row4[]" id="row4'.$number.'" class="form-control input-lg" style=" font-family: \'Kanit\', sans-serif;" >';
            echo '<option value="">--กรุณาเลือกฝ่าย/แผนก--</option>';
                foreach ($infordepartments_select as $infordepartment_2){ 
                        if($infordepartment->HR_DEPARTMENT_SUB_ID == $infordepartment_2 ->HR_DEPARTMENT_SUB_ID){                                                    
                            echo  '<option value="'.$infordepartment_2->HR_DEPARTMENT_SUB_ID.'" selected>'.$infordepartment_2->HR_DEPARTMENT_SUB_NAME.'</option>';
                                }else{
                            echo  '<option value="'.$infordepartment_2->HR_DEPARTMENT_SUB_ID.'">'.$infordepartment_2->HR_DEPARTMENT_SUB_NAME.'</option>';
                                }
                            }              
            echo '</select>';      
            echo '</td>';                     
            echo '<td style="text-align: center;"><a class="btn btn-danger remove4" style="color:#FFFFFF;"><i class="fa fa-trash-alt"></i></a></td>';
            echo '</tr>';

            }

        
        
    }

    
    function departmentrow5(Request $request)
    {

        $infordepartments=  DB::table('hrd_department_sub_sub')->get();

        $infordepartments_select=  DB::table('hrd_department_sub_sub')->get();
       $number = 0;
        foreach ( $infordepartments as  $infordepartment){ 
            $number++;

            echo '<tr><td>'; 
            echo '<select name="row5[]" id="row5'.$number.'" class="form-control input-lg" style=" font-family: \'Kanit\', sans-serif;" >';
            echo '<option value="">--กรุณาเลือกกลุ่มงาน--</option>';
                foreach ($infordepartments_select as $infordepartment_2){ 
                        if($infordepartment->HR_DEPARTMENT_SUB_SUB_ID == $infordepartment_2 ->HR_DEPARTMENT_SUB_SUB_ID){                                                    
                            echo  '<option value="'.$infordepartment_2->HR_DEPARTMENT_SUB_SUB_ID.'" selected>'.$infordepartment_2->HR_DEPARTMENT_SUB_SUB_NAME.'</option>';
                                }else{
                            echo  '<option value="'.$infordepartment_2->HR_DEPARTMENT_SUB_SUB_ID.'">'.$infordepartment_2->HR_DEPARTMENT_SUB_SUB_NAME.'</option>';
                                }
                            }              
            echo '</select>';      
            echo '</td>';                     
            echo '<td style="text-align: center;"><a class="btn btn-danger remove5" style="color:#FFFFFF;"><i class="fa fa-trash-alt"></i></a></td>';
            echo '</tr>';

            }

        
        
    }
  //---------------------------------addorg

  function addorg(Request $request)
  {
   
  

   if($request->record_org!= null || $request->record_org != ''){


    $contorg = Recordorg::where('RECORD_ORG_NAME','=',$request->record_org)->count();
        if($contorg == 0){
            $addrecord = new Recordorg(); 
            $addrecord->RECORD_ORG_NAME = $request->record_org;
            $addrecord->save();       
        }
    
   
    }
      $query =  DB::table('grecord_org')->get();
   
      $output='<option value="">--กรุณาเลือกหน่วยงาน--</option>';
      
      foreach ($query as $row){
            if($request->record_org == $row->RECORD_ORG_NAME){
              $output.= '<option value="'.$row->RECORD_ORG_ID.'" selected>'.$row->RECORD_ORG_NAME.'</option>';
            }else{
              $output.= '<option value="'.$row->RECORD_ORG_ID.'">'.$row->RECORD_ORG_NAME.'</option>';
            }

            
    }

      echo $output;
      
  }

     //--------------------------------------------check max year-------------------------------------
     function checkmaxindex(Request $request)
     {
        $year=$request->year;

        $maxnumber = Bookindex::where('BOOK_YEAR_ID','=',$year)->max('BOOK_NUM_IN');
        $maxnumberuse =  $maxnumber+1;

        $output='<input  name = "BOOK_NUM_IN"  id="BOOK_NUM_IN" class="form-control input-sm" style=" font-family: \'Kanit\', sans-serif;" value="'.$maxnumberuse.'">';
   
         
        echo $output;
     }


     function checkmaxinside(Request $request)
     {
        $year=$request->year;

        $maxnumber = Bookindexinside::where('BOOK_YEAR_ID','=',$year)->max('BOOK_NUM_IN');
        $maxnumberuse =  $maxnumber+1;

        $output='<input  name = "BOOK_NUM_IN"  id="BOOK_NUM_IN" class="form-control input-sm" style=" font-family: \'Kanit\', sans-serif;" value="'.$maxnumberuse.'">';
   
         
        echo $output;
     }


     function checkmaxcommand(Request $request)
     {
        $year=$request->year;

        $maxnumber = Bookindexcommand::where('BOOK_YEAR_ID','=',$year)->max('BOOK_NUMBER');
        $maxnumberuse =  $maxnumber+1;

        $output='<input  name = "BOOK_NUMBER"  id="BOOK_NUMBER" class="form-control input-sm" style=" font-family: \'Kanit\', sans-serif;" value="'.$maxnumberuse.'">';
   
         
        echo $output;
     }



    //--------------------------------------------check permis-------------------------------------

    public static function checkmanagerbookoffer($id_user)
    {
     $count =  Permislist::where('PERSON_ID','=',$id_user)
                           ->where('PERMIS_ID','=','GMB002')
                           ->count();   
    
     return $count;
    }

    public static function checkmanagerbookretire($id_user)
    {
     $count =  Permislist::where('PERSON_ID','=',$id_user)
                           ->where('PERMIS_ID','=','GMB003')
                           ->count();   
    
     return $count;
    }


    public static function checkmanagerbooksecret($id_user)
    {
     $count =  Permislist::where('PERSON_ID','=',$id_user)
                           ->where('PERMIS_ID','=','GMB004')
                           ->count();   
    
     return $count;
    }



    //--------------------------------note

    function takenotereceipt(Request $request)
    {  
        $id = $request->idbook;
        $BOOK_NOTE = $request->BOOK_NOTE;

        $note= Bookindex::find($id);
        $note->BOOK_NOTE = $request->BOOK_NOTE;
        $note->save();
    }


    function takenoteinside(Request $request)
    {  
        $id = $request->idbook;
        $BOOK_NOTE = $request->BOOK_NOTE;

        $note= Bookindexinside::find($id);
        $note->BOOK_NOTE = $request->BOOK_NOTE;
        $note->save();
    }


    public function bookdetail(Request $request,$idref)
    {
    
        $infomation = DB::table('gbook_index')->where('BOOK_ID','=',$idref)->first();
        return view('manager_book.bookdetail',[
            'infomation' =>$infomation,
           ]);
    }
    

}
