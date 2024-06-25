<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Person;
use App\Models\Permislist;
use App\Models\Bookindex;
use App\Models\Recordorg;


use App\Models\Booksend;
use App\Models\Booksendsub;
use App\Models\Booksendsubsub;
use App\Models\Bookindexsendleader;
use App\Models\Booksendperson;

use App\Models\Booksendcommandleader;
use App\Models\Booksendcommanddepart;
use App\Models\Booksendcommanddepartsub;
use App\Models\Booksendcommanddepartsubsub;
use App\Models\Booksendcommand;
use App\Models\Bookindexcommand;
use App\Models\Booksendcommandorg;

use App\Models\Booksendinsideleader;
use App\Models\Booksendinsidedepart;
use App\Models\Booksendinsidedepartsub;
use App\Models\Booksendinsidedepartsubsub;
use App\Models\Booksendinside;
use App\Models\Bookindexinside;
use App\Models\Booksendinsideorg;

use App\Models\Booksendannounceleader;
use App\Models\Booksendannouncedepart;
use App\Models\Booksendannouncedepartsub;
use App\Models\Booksendannouncedepartsubsub;
use App\Models\Booksendannounce;
use App\Models\Bookindexannounce;

class DocumentController extends Controller
{
    public function enterdoc(Request $request,$iduser)
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
            
        $inforbook = Booksendperson::leftJoin('gbook_index','gbook_index.BOOK_ID','=','gbook_send_person.BOOK_ID')
            ->where('BOOK_USE','=','true')
            ->where('READ_STATUS','=','False')
            ->where('gbook_send_person.HR_PERSON_ID','=',$iduser )
            ->orderBy('ID', 'desc') 
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

            $displaydate_bigen  = date('Y').'-01-01';
            $displaydate_end    = date('Y').'-12-31';
            $status = '';
            $search = '';
            $year_id = date('Y')+543;
            $budget = getYearAmount();
        return view('general_document.gendocumentinfoenter',[
            'inforpersonuser' => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid, 
            'infobookstatus1'=> $infobookstatus1, 
            'infobookstatus2'=> $infobookstatus2,
            'infobookstatus3'=> $infobookstatus3,
            'inforbooks' =>$inforbook,
            'infobook_sendstatuss'=>   $infobook_sendstatus,
            'displaydate_bigen'=> $displaydate_bigen, 
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'budgets' =>  $budget,
            'year_id'=>$year_id 
            
        ]);


    }

    public function gendocumen_updateall(Request $request,$iduser)
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
            ->leftJoin('hrd_kind','hrd_person.HR_KIND_ID','=','hrd_kind.HR_KIND_ID')
            ->leftJoin('hrd_kind_type','hrd_person.HR_KIND_TYPE_ID','=','hrd_kind_type.HR_KIND_TYPE_ID')
            ->leftJoin('hrd_person_type','hrd_person.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
        ->where('hrd_person.ID','=',$iduser)->first();
            
        $inforbook = Booksendperson::leftJoin('gbook_index','gbook_index.BOOK_ID','=','gbook_send_person.BOOK_ID')
            ->where('BOOK_USE','=','true')
            ->where('READ_STATUS','=','False')
            ->where('gbook_send_person.HR_PERSON_ID','=',$iduser )
            ->orderBy('ID', 'desc') 
            ->get();

        // อัปเดท สถานะทั้งหมด  ********************************************
        $statuscode = 'True';
        $updatelastapp = Booksendperson::where('READ_STATUS','=','False')
            ->where('HR_PERSON_ID',$iduser)
            ->update(['READ_STATUS' => $statuscode]);
          
            return redirect()->route('document.enterdoc',[
                                'iduser' => $iduser
                ]);
            
    }




    public function enterdocsearch(Request $request,$iduser)
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


                $inforbook = Booksendperson::leftJoin('gbook_index','gbook_index.BOOK_ID','=','gbook_send_person.BOOK_ID')
                ->leftJoin('grecord_org','gbook_index.BOOK_ORG_ID','=','grecord_org.RECORD_ORG_ID')
                ->leftJoin('hrd_person','gbook_index.PERSON_SAVE_ID','=','hrd_person.ID')
                ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                ->leftJoin('gbook_index_send_leader','gbook_index.BOOK_ID','=','gbook_index_send_leader.BOOK_LD_ID')
                ->where('BOOK_USE','=','true')
                ->where('gbook_send_person.HR_PERSON_ID','=',$iduser )
                ->where(function($q) use ($search){
                    $q->where('BOOK_NUM_IN','like','%'.$search.'%');
                    $q->orwhere('BOOK_NUMBER','like','%'.$search.'%');
                    $q->orwhere('BOOK_NAME','like','%'.$search.'%');
                    $q->orwhere('BOOK_DETAIL','like','%'.$search.'%');
                    })
                 ->WhereBetween('DATE_SAVE',[$from,$to]) 
                 ->orderBy('gbook_send_person.ID', 'desc') 
                 ->get();


            }else{

                $inforbook = Booksendperson::leftJoin('gbook_index','gbook_index.BOOK_ID','=','gbook_send_person.BOOK_ID')
                ->leftJoin('grecord_org','gbook_index.BOOK_ORG_ID','=','grecord_org.RECORD_ORG_ID')
                ->leftJoin('hrd_person','gbook_index.PERSON_SAVE_ID','=','hrd_person.ID')
                ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                ->leftJoin('gbook_index_send_leader','gbook_index.BOOK_ID','=','gbook_index_send_leader.BOOK_LD_ID')
                ->where('BOOK_USE','=','true')
                ->where('gbook_send_person.HR_PERSON_ID','=',$iduser )
                ->where('SEND_STATUS','=',$status)
                ->where(function($q) use ($search){
                    $q->where('BOOK_NUM_IN','like','%'.$search.'%');
                    $q->orwhere('BOOK_NUMBER','like','%'.$search.'%');
                    $q->orwhere('BOOK_NAME','like','%'.$search.'%');
                    $q->orwhere('BOOK_DETAIL','like','%'.$search.'%');
                    })
                 ->WhereBetween('DATE_SAVE',[$from,$to]) 
                 ->orderBy('gbook_send_person.ID', 'desc') 
                 ->get();


            }
    

      

                
      

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

        return view('general_document.gendocumentinfoenter',[
            'inforpersonuser' => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid, 
            'infobookstatus1'=> $infobookstatus1, 
            'infobookstatus2'=> $infobookstatus2,
            'infobookstatus3'=> $infobookstatus3,
            'inforbooks' =>$inforbook,
            'infobook_sendstatuss'=>   $infobook_sendstatus,
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id, 
                
        ]);


    }


     //---------------จัดการหนังสือเข้า

     public function infobookenterdoccontrol(Request $request,$id,$iduser)
     {
        //$iduser  = Auth::user()->PERSON_ID; 
         
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

                //--------------------------------------------
             $infordepartmentsub  =  DB::table('hrd_department_sub')->get();

             $inforsenddepartmentsubs =  DB::table('gbook_send_sub')
             ->where('BOOK_ID','=',$idbook)
             ->get(); 
  
             $checksendinfordepartmentsub = DB::table('gbook_send_sub')
             ->where('BOOK_ID','=',$idbook)
             ->count(); 
  
              //--------------------------------------------

                             //--------------------------------------------
             $infordepartmentsubsub  =  DB::table('hrd_department_sub_sub')->get();

             $inforsenddepartmentsubsubs =  DB::table('gbook_send_sub_sub')
             ->where('BOOK_ID','=',$idbook)
             ->get(); 
  
             $checksendinfordepartmentsubsub = DB::table('gbook_send_sub_sub')
             ->where('BOOK_ID','=',$idbook)
             ->count(); 
  
              //--------------------------------------------
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

         return view('general_document.gendocumentinfoenter_control',[
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

     
    public function sendenterdoc(Request $request)
    {
         $typesend     = $request->SUBMIT;
         $iduser       = $request->ID_USER;
         $bookid       = $request->BOOK_ID;
         $SEND_BY_ID   = $request->SEND_BY_ID;
         $SEND_BY_NAME = $request->SEND_BY_NAME;

         if ($typesend == 'sendhead') {
            $addpresentupstatus              = Bookindex::find($bookid);
             $addpresentupstatus->SEND_STATUS = '4';
             $addpresentupstatus->save();
 

             Booksend::where('BOOK_ID', '=', $bookid)->delete();
             if ($request->row3 != '' || $request->row3 != null) {
                 $row3     = $request->row3;
                 $number_3 = count($row3);
                 $count_3  = 0;
                 for ($count_3 = 0; $count_3 < $number_3; $count_3++) {
 
                     $add_3                   = new Booksend();
                     $add_3->BOOK_ID          = $bookid;
                     $add_3->HR_DEPARTMENT_ID = $row3[$count_3];
                     $add_3->save();
 
                     $inforpersonusers = Person::where('HR_DEPARTMENT_ID', '=', $row3[$count_3])->get();
 
                     foreach ($inforpersonusers as $inforpersonuser) {
 
                         $check3 = DB::table('gbook_send_person')
                             ->where('BOOK_ID', '=', $bookid)
                             ->where('HR_PERSON_ID', '=', $inforpersonuser->ID)
                             ->count();
 
                         if ($check3 == 0) {
                             $add_person3                 = new Booksendperson();
                             $add_person3->BOOK_ID        = $bookid;
                             $add_person3->HR_PERSON_ID   = $inforpersonuser->ID;
                             $add_person3->READ_STATUS    = 'False';
                             $add_person3->SEND_BY_ID     = $SEND_BY_ID;
                             $add_person3->SEND_BY_NAME   = $SEND_BY_NAME;
                             $add_person3->SEND_DATE_TIME = date('Y-m-d H:i:s');
                             $add_person3->SEND_TYPE      = '1';
                             $add_person3->save();
                         }
                     }
 
                 }
             }
 
             Booksendsub::where('BOOK_ID', '=', $bookid)->delete();
             if ($request->row4 != '' || $request->row4 != null) {
 
                 $row4     = $request->row4;
                 $number_4 = count($row4);
                 $count_4  = 0;
                 for ($count_4 = 0; $count_4 < $number_4; $count_4++) { 
 
                     $add_4                       = new Booksendsub();
                     $add_4->BOOK_ID              = $bookid;
                     $add_4->HR_DEPARTMENT_SUB_ID = $row4[$count_4];
                     $add_4->save();
 
                     //------เช็คตัวซ้ำก่อน------
 
                     $inforpersonusers_4 = Person::where('HR_DEPARTMENT_SUB_ID', '=', $row4[$count_4])->get();
 
                     foreach ($inforpersonusers_4 as $inforpersonuser_4) {
 
                         $check4 = DB::table('gbook_send_person')
                             ->where('BOOK_ID', '=', $bookid)
                             ->where('HR_PERSON_ID', '=', $inforpersonuser_4->ID)
                             ->count();
 
                         if ($check4 == 0) {
                             $add_person4                 = new Booksendperson();
                             $add_person4->BOOK_ID        = $bookid;
                             $add_person4->HR_PERSON_ID   = $inforpersonuser_4->ID;
                             $add_person4->READ_STATUS    = 'False';
                             $add_person4->SEND_BY_ID     = $SEND_BY_ID;
                             $add_person4->SEND_BY_NAME   = $SEND_BY_NAME;
                             $add_person4->SEND_DATE_TIME = date('Y-m-d H:i:s');
                             $add_person4->SEND_TYPE      = '2';
                             $add_person4->save();
                         }
                     }
 
                 }
             }

             Booksendsubsub::where('BOOK_ID', '=', $bookid)->delete();
             if ($request->row5 != '' || $request->row5 != null) {
                 $row5     = $request->row5;
                 $number_5 = count($row5);
                 $count_5  = 0;
                 for ($count_5 = 0; $count_5 < $number_5; $count_5++) {
 
                     $add_5                           = new Booksendsubsub();
                     $add_5->BOOK_ID                  = $bookid;
                     $add_5->HR_DEPARTMENT_SUB_SUB_ID = $row5[$count_5];
                     $add_5->save();
 
                     //------เช็คตัวซ้ำก่อน------
 
                     $inforpersonusers_5 = Person::where('HR_DEPARTMENT_SUB_SUB_ID', '=', $row5[$count_5])->get();
 
                     foreach ($inforpersonusers_5 as $inforpersonuser_5) {
 
                         $check5 = DB::table('gbook_send_person')
                             ->where('BOOK_ID', '=', $bookid)
                             ->where('HR_PERSON_ID', '=', $inforpersonuser_5->ID)
                             ->count();
                         //dd($check5);
 
                         if ($check5 == 0) {
 
                             $add_person5                 = new Booksendperson();
                             $add_person5->BOOK_ID        = $bookid;
                             $add_person5->HR_PERSON_ID   = $inforpersonuser_5->ID;
                             $add_person5->READ_STATUS    = 'False';
                             $add_person5->SEND_BY_ID     = $SEND_BY_ID;
                             $add_person5->SEND_BY_NAME   = $SEND_BY_NAME;
                             $add_person5->SEND_DATE_TIME = date('Y-m-d H:i:s');
                             $add_person5->SEND_TYPE      = '3';
                             $add_person5->save();
                         }
                     }
 
                 }
             }
             

             if ($request->MEMBER_ID != '' || $request->MEMBER_ID != null) {
                 $MEMBER_ID = $request->MEMBER_ID;
                 $number    = count($MEMBER_ID);
                 $count     = 0;
                 for ($count = 0; $count < $number; $count++) {
                    $check6 = DB::table('gbook_send_person')
                    ->where('BOOK_ID', '=', $bookid)
                    ->where('HR_PERSON_ID', '=', $MEMBER_ID[$count])
                    ->count();
                    
                    if ($check6 == 0) {
                        $add_person6                 = new Booksendperson();
                        $add_person6->BOOK_ID        = $bookid;
                        $add_person6->HR_PERSON_ID   = $MEMBER_ID[$count];
                        $add_person6->READ_STATUS    = 'False';
                        $add_person6->SEND_BY_ID     = $SEND_BY_ID;
                        $add_person6->SEND_BY_NAME   = $SEND_BY_NAME;
                        $add_person6->SEND_DATE_TIME = date('Y-m-d H:i:s');
                        $add_person6->SEND_TYPE      = '4';
                        $add_person6->save();
                     }
                 }
             }
         } else {
             if ($request->row3 != '' || $request->row3 != null ||
                 $request->row4 != '' || $request->row3 != null ||
                 $request->row5 != '' || $request->row3 != null ||
                 $request->MEMBER_ID != '' || $request->MEMBER_ID != null
             ) {
                 $checkstatus1 = Bookindex::where('BOOK_ID', '=', $bookid)
                     ->where('SEND_STATUS', '=', '3')
                     ->count();
                 $checkstatus2 = Bookindex::where('BOOK_ID', '=', $bookid)
                     ->where('SEND_STATUS', '=', '4')
                     ->count();
                 if ($checkstatus1 == 0 && $checkstatus2 == 0) {
                     $addpresentupstatus              = Bookindex::find($bookid);
                     $addpresentupstatus->SEND_STATUS = '2';
                     $addpresentupstatus->save();
                 }
             }
 
        
             Booksend::where('BOOK_ID', '=', $bookid)->delete();
             if ($request->row3 != '' || $request->row3 != null) {
                 $row3     = $request->row3;
                 $number_3 = count($row3);
                 $count_3  = 0;
                 for ($count_3 = 0; $count_3 < $number_3; $count_3++) { 
 
                     $add_3                   = new Booksend();
                     $add_3->BOOK_ID          = $bookid;
                     $add_3->HR_DEPARTMENT_ID = $row3[$count_3];
                     $add_3->save();
 
                     $inforpersonusers = Person::where('HR_DEPARTMENT_ID', '=', $row3[$count_3])->get();
 
                     foreach ($inforpersonusers as $inforpersonuser) {
 
                         $check3 = DB::table('gbook_send_person')
                             ->where('BOOK_ID', '=', $bookid)
                             ->where('HR_PERSON_ID', '=', $inforpersonuser->ID)
                             ->count();
 
                         if ($check3 == 0) {
                             $add_person3                 = new Booksendperson();
                             $add_person3->BOOK_ID        = $bookid;
                             $add_person3->HR_PERSON_ID   = $inforpersonuser->ID;
                             $add_person3->READ_STATUS    = 'False';
                             $add_person3->SEND_BY_ID     = $SEND_BY_ID;
                             $add_person3->SEND_BY_NAME   = $SEND_BY_NAME;
                             $add_person3->SEND_DATE_TIME = date('Y-m-d H:i:s');
                             $add_person3->SEND_TYPE      = '1';
                             $add_person3->save();
                         }
                     }
 
                 }
             }
 
             Booksendsub::where('BOOK_ID', '=', $bookid)->delete();
             if ($request->row4 != '' || $request->row4 != null) {
 
                 $row4     = $request->row4;
                 $number_4 = count($row4);
                 $count_4  = 0;
                 for ($count_4 = 0; $count_4 < $number_4; $count_4++) {
 
                     $add_4                       = new Booksendsub();
                     $add_4->BOOK_ID              = $bookid;
                     $add_4->HR_DEPARTMENT_SUB_ID = $row4[$count_4];
                     $add_4->save();
 
                     //------เช็คตัวซ้ำก่อน------
 
                     $inforpersonusers_4 = Person::where('HR_DEPARTMENT_SUB_ID', '=', $row4[$count_4])->get();
 
                     foreach ($inforpersonusers_4 as $inforpersonuser_4) {
 
                         $check4 = DB::table('gbook_send_person')
                             ->where('BOOK_ID', '=', $bookid)
                             ->where('HR_PERSON_ID', '=', $inforpersonuser_4->ID)
                             ->count();
 
                         if ($check4 == 0) {
                             $add_person4                 = new Booksendperson();
                             $add_person4->BOOK_ID        = $bookid;
                             $add_person4->HR_PERSON_ID   = $inforpersonuser_4->ID;
                             $add_person4->READ_STATUS    = 'False';
                             $add_person4->SEND_BY_ID     = $SEND_BY_ID;
                             $add_person4->SEND_BY_NAME   = $SEND_BY_NAME;
                             $add_person4->SEND_DATE_TIME = date('Y-m-d H:i:s');
                             $add_person4->SEND_TYPE      = '2';
                             $add_person4->save();
                         }
                     }
 
                 }
             }

             Booksendsubsub::where('BOOK_ID', '=', $bookid)->delete();
             if ($request->row5 != '' || $request->row5 != null) {
                 $row5     = $request->row5;
                 $number_5 = count($row5);
                 $count_5  = 0;
                 for ($count_5 = 0; $count_5 < $number_5; $count_5++) { 
 
                     $add_5                           = new Booksendsubsub();
                     $add_5->BOOK_ID                  = $bookid;
                     $add_5->HR_DEPARTMENT_SUB_SUB_ID = $row5[$count_5];
                     $add_5->save();
 
                     //------เช็คตัวซ้ำก่อน------
 
                     $inforpersonusers_5 = Person::where('HR_DEPARTMENT_SUB_SUB_ID', '=', $row5[$count_5])->get();
 
                     foreach ($inforpersonusers_5 as $inforpersonuser_5) {
 
                         $check5 = DB::table('gbook_send_person')
                             ->where('BOOK_ID', '=', $bookid)
                             ->where('HR_PERSON_ID', '=', $inforpersonuser_5->ID)
                             ->count();
                        
 
                         if ($check5 == 0) {
 
                             $add_person5                 = new Booksendperson();
                             $add_person5->BOOK_ID        = $bookid;
                             $add_person5->HR_PERSON_ID   = $inforpersonuser_5->ID;
                             $add_person5->READ_STATUS    = 'False';
                             $add_person5->SEND_BY_ID     = $SEND_BY_ID;
                             $add_person5->SEND_BY_NAME   = $SEND_BY_NAME;
                             $add_person5->SEND_DATE_TIME = date('Y-m-d H:i:s');
                             $add_person5->SEND_TYPE      = '3';
                             $add_person5->save();
                         }
                     }
 
                 }
             }
             
             if ($request->MEMBER_ID != '' || $request->MEMBER_ID != null) {
                 $MEMBER_ID = $request->MEMBER_ID;
                 $number    = count($MEMBER_ID);
                 $count     = 0;
                 for ($count = 0; $count < $number; $count++) {
                    $check6 = DB::table('gbook_send_person')
                    ->where('BOOK_ID', '=', $bookid)
                    ->where('HR_PERSON_ID', '=', $MEMBER_ID[$count])
                    ->count();
               
                    if ($check6 == 0) {
                        $add_person6                 = new Booksendperson();
                        $add_person6->BOOK_ID        = $bookid;
                        $add_person6->HR_PERSON_ID   = $MEMBER_ID[$count];
                        $add_person6->READ_STATUS    = 'False';
                        $add_person6->SEND_BY_ID     = $SEND_BY_ID;
                        $add_person6->SEND_BY_NAME   = $SEND_BY_NAME;
                        $add_person6->SEND_DATE_TIME = date('Y-m-d H:i:s');
                        $add_person6->SEND_TYPE      = '4';
                        $add_person6->save();
                     }
                 }
             }
         }
 
         return redirect()->route('document.enterdoc', [
             'iduser' => $iduser
         ]);
    }


   
   public function saverpresententerdoc(Request $request)
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

       $addpresentupstatus = Bookindex::find($request->BOOK_ID);
       $addpresentupstatus->SEND_STATUS = '2';
       $addpresentupstatus->save();
       }
       $iduser = $request->ID_USER;

       return redirect()->route('document.infobookenterdoccontrol',[
           'id' => $bookid,
           'iduser' => $iduser
       ]);
       }

       public function saveretireenterdoc(Request $request)
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
           
   
           $iduser = $request->ID_USER;
           return redirect()->route('document.infobookenterdoccontrol',[
               'id' => $bookid,
               'iduser' => $iduser
           ]);
       }
   

  

    //===========================================================

    public function comdoc(Request $request,$iduser)
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
            
        $inforbook = Booksendcommand::leftJoin('gbook_index_command','gbook_index_command.BOOK_ID','=','gbook_send_command.BOOK_ID')
            ->where('gbook_send_command.HR_PERSON_ID','=',$iduser )
            ->where('gbook_send_command.READ_STATUS','=','False')
            ->orderBy('gbook_send_command.BOOK_ID', 'desc') 
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
         
          $displaydate_bigen    = date('Y').'-01-01';
          $displaydate_end      = date('Y').'-12-31';
          $status = '';
          $search = '';
          $year_id = date('Y')+543;
          $budget = getYearAmount();
        return view('general_document.gendocumentinfocom',[
            'inforpersonuser' => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid, 
            'infobookstatus1'=> $infobookstatus1, 
            'infobookstatus2'=> $infobookstatus2,
            'infobookstatus3'=> $infobookstatus3,
            'inforbooks' =>$inforbook,
            'infobook_sendstatuss'=>   $infobook_sendstatus,
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id,
            
        ]);
    }

    public function comdocsearch(Request $request,$iduser)
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



        $search = $request->get('search');
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

            $from = date($displaydate_bigen);
            $to = date($displaydate_end);

            $inforbook = Booksendcommand::leftJoin('gbook_index_command','gbook_index_command.BOOK_ID','=','gbook_send_command.BOOK_ID')
            ->leftJoin('grecord_org','gbook_index_command.BOOK_ORG_ID','=','grecord_org.RECORD_ORG_ID')
            ->leftJoin('hrd_person','gbook_index_command.PERSON_SAVE_ID','=','hrd_person.ID')
            ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
            ->leftJoin('gbook_send_command_leader','gbook_index_command.BOOK_ID','=','gbook_send_command_leader.BOOK_LD_ID')
            ->where('gbook_send_command.HR_PERSON_ID','=',$iduser )
            ->where(function($q) use ($search){
                $q->where('BOOK_NUM_IN','like','%'.$search.'%');
                $q->orwhere('BOOK_NUMBER','like','%'.$search.'%');
                $q->orwhere('BOOK_NAME','like','%'.$search.'%');
             })
            ->WhereBetween('DATE_SAVE',[$from,$to]) 
            ->orderBy('gbook_send_command.BOOK_ID', 'desc') 
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

        $budget = getYearAmount();
        $year_id = $yearbudget;
        
        return view('general_document.gendocumentinfocom',[
            'inforpersonuser' => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid, 
            'infobookstatus1'=> $infobookstatus1, 
            'infobookstatus2'=> $infobookstatus2,
            'infobookstatus3'=> $infobookstatus3,
            'inforbooks' =>$inforbook,
            'infobook_sendstatuss'=>   $infobook_sendstatus,
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'search'=> $search,
            'year_id'=>$year_id, 
            
        ]);



    }


      //---------------จัดการหนังสือคำสั่ง

      public function infobookentcomdoccontrol(Request $request,$id,$iduser)
      {
          
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
 
          return view('general_document.gendocumentinfocom_control',[
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
                   
                 $check4 = DB::table('gbook_send_command')
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
                    
                  $check5 = DB::table('gbook_send_command')
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
 
        return redirect()->route('document.comdoc',[
                     'iduser' => $iduser
        ]);
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
 
        return redirect()->route('document.infobookentcomdoccontrol',[
            'id' => $bookid,
            'iduser' => $iduser
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
            return redirect()->route('document.infobookentcomdoccontrol',[
                'id' => $bookid,
                'iduser' => $iduser
            ]);
        }
   //================================================================================= 


    public function insidedoc(Request $request,$iduser)
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
            
        $inforbook = Booksendinside::leftJoin('gbook_index_inside','gbook_index_inside.BOOK_ID','=','gbook_send_inside.BOOK_ID')
            ->leftJoin('grecord_org','gbook_index_inside.BOOK_ORG_ID','=','grecord_org.RECORD_ORG_ID')
            ->leftJoin('hrd_person','gbook_index_inside.PERSON_SAVE_ID','=','hrd_person.ID')
            ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
            ->leftJoin('gbook_send_inside_leader','gbook_index_inside.BOOK_ID','=','gbook_send_inside_leader.BOOK_LD_ID')
            ->where('gbook_send_inside.HR_PERSON_ID','=',$iduser )
            ->where('BOOK_USE','=','true')
            ->where('READ_STATUS','=','False')
            ->orderBy('gbook_send_inside.BOOK_ID', 'desc') 
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
      
            $displaydate_bigen  = date('Y').'-01-01';
            $displaydate_end    = date('Y').'-12-31';
            $status = '';
            $search = '';
            $year_id = date('Y')+543;
            $budget = getYearAmount();

        return view('general_document.gendocumentinfoinside',[
            'inforpersonuser' => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid, 
            'infobookstatus1'=> $infobookstatus1, 
            'infobookstatus2'=> $infobookstatus2,
            'infobookstatus3'=> $infobookstatus3,
            'inforbooks' =>$inforbook,
            'infobook_sendstatuss'=> $infobook_sendstatus,
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id,
            
        ]);
    }

    
    public function insidedocsearch(Request $request,$iduser)
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

            $from = date($displaydate_bigen);
            $to = date($displaydate_end);

            if($status == null){

                $inforbook = Booksendinside::leftJoin('gbook_index_inside','gbook_index_inside.BOOK_ID','=','gbook_send_inside.BOOK_ID')
                ->leftJoin('grecord_org','gbook_index_inside.BOOK_ORG_ID','=','grecord_org.RECORD_ORG_ID')
                ->leftJoin('hrd_person','gbook_index_inside.PERSON_SAVE_ID','=','hrd_person.ID')
                ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                ->leftJoin('gbook_send_inside_leader','gbook_index_inside.BOOK_ID','=','gbook_send_inside_leader.BOOK_LD_ID')
                ->where('gbook_send_inside.HR_PERSON_ID','=',$iduser )
                ->where('BOOK_USE','=','true')
                ->where(function($q) use ($search){
                            $q->where('BOOK_NUM_IN','like','%'.$search.'%');
                            $q->orwhere('BOOK_NUMBER','like','%'.$search.'%');
                            $q->orwhere('BOOK_NAME','like','%'.$search.'%');
      
                })
                ->WhereBetween('DATE_SAVE',[$from,$to]) 
                ->orderBy('gbook_send_inside.BOOK_ID', 'desc') 
                ->get();
          
                
             
            }else{

                $inforbook = Booksendinside::leftJoin('gbook_index_inside','gbook_index_inside.BOOK_ID','=','gbook_send_inside.BOOK_ID')
                ->leftJoin('grecord_org','gbook_index_inside.BOOK_ORG_ID','=','grecord_org.RECORD_ORG_ID')
                ->leftJoin('hrd_person','gbook_index_inside.PERSON_SAVE_ID','=','hrd_person.ID')
                ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                ->leftJoin('gbook_send_inside_leader','gbook_index_inside.BOOK_ID','=','gbook_send_inside_leader.BOOK_LD_ID')
                ->where('gbook_send_inside.HR_PERSON_ID','=',$iduser )
                ->where('BOOK_USE','=','true')
                ->where('SEND_STATUS','=',$status)
                ->where(function($q) use ($search){
                            $q->where('BOOK_NUM_IN','like','%'.$search.'%');
                            $q->orwhere('BOOK_NUMBER','like','%'.$search.'%');
                            $q->orwhere('BOOK_NAME','like','%'.$search.'%');
      
                })
                ->WhereBetween('DATE_SAVE',[$from,$to]) 
                ->orderBy('gbook_send_inside.BOOK_ID', 'desc') 
                ->get();

            }


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
        
        return view('general_document.gendocumentinfoinside',[
            'inforpersonuser' => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid, 
            'infobookstatus1'=> $infobookstatus1, 
            'infobookstatus2'=> $infobookstatus2,
            'infobookstatus3'=> $infobookstatus3,
            'inforbooks' =>$inforbook,
            'infobook_sendstatuss'=> $infobook_sendstatus,
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id,
          ]);



    }
    
      //---------------จัดการหนังสือภายใน

      public function infobookentinsidecontrol(Request $request,$id,$iduser)
      {
          
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

 
          return view('general_document.gendocumentinfoinside_control',[
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
 
        return redirect()->route('document.insidedoc',[
                     'iduser' => $iduser
        ]);
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
 
        return redirect()->route('document.infobookentinsidecontrol',[
            'id' => $bookid,
            'iduser' => $iduser
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
            return redirect()->route('document.infobookentinsidecontrol',[
                'id' => $bookid,
                'iduser' => $iduser
            ]);
        }
   //================================================================================= 


    public function announcedoc(Request $request,$iduser)
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
            
        $inforbook = Booksendannounce::leftJoin('gbook_index_announce','gbook_index_announce.BOOK_ID','=','gbook_send_announce.BOOK_ID')
            ->where('gbook_send_announce.HR_PERSON_ID','=',$iduser )
            ->where('gbook_send_announce.READ_STATUS','=','False')
            ->orderBy('gbook_send_announce.BOOK_ID', 'desc') 
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

            $budget = getYearAmount();

            $displaydate_bigen  = date('Y').'-01-01';
            $displaydate_end    = date('Y').'-12-31';
            $status = '';
            $search = '';
            $year_id = date('Y')+543;

                     

        return view('general_document.gendocumentinfoannounce',[
            'inforpersonuser' => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid, 
            'infobookstatus1'=> $infobookstatus1, 
            'infobookstatus2'=> $infobookstatus2,
            'infobookstatus3'=> $infobookstatus3,
            'inforbooks' =>$inforbook,
            'infobook_sendstatuss'=>   $infobook_sendstatus,
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id, 
            
        ]);
    }


    public function announcedocsearch(Request $request,$iduser)
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


        $search = $request->get('search');
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

            $from = date($displaydate_bigen);
            $to = date($displaydate_end);


            $inforbook = Booksendannounce::leftJoin('gbook_index_announce','gbook_index_announce.BOOK_ID','=','gbook_send_announce.BOOK_ID')
            ->leftJoin('grecord_org','gbook_index_announce.BOOK_ORG_ID','=','grecord_org.RECORD_ORG_ID')
            ->leftJoin('hrd_person','gbook_index_announce.PERSON_SAVE_ID','=','hrd_person.ID')
            ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
            ->leftJoin('gbook_send_announce_leader','gbook_index_announce.BOOK_ID','=','gbook_send_announce_leader.BOOK_LD_ID')
            ->where('gbook_send_announce.HR_PERSON_ID','=',$iduser )
            ->where(function($q) use ($search){
                $q->where('BOOK_NUM_IN','like','%'.$search.'%');
                $q->orwhere('BOOK_NUMBER','like','%'.$search.'%');
                $q->orwhere('BOOK_NAME','like','%'.$search.'%');

            })
             ->WhereBetween('DATE_SAVE',[$from,$to]) 
            ->orderBy('gbook_send_announce.BOOK_ID', 'desc') 
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
  
        $budget = getYearAmount();
        $year_id = $yearbudget;

        return view('general_document.gendocumentinfoannounce',[
            'inforpersonuser' => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid, 
            'infobookstatus1'=> $infobookstatus1, 
            'infobookstatus2'=> $infobookstatus2,
            'infobookstatus3'=> $infobookstatus3,
            'inforbooks' =>$inforbook,
            'infobook_sendstatuss'=>   $infobook_sendstatus,
            'budgets' =>  $budget,
        'displaydate_bigen'=> $displaydate_bigen,
        'displaydate_end'=> $displaydate_end,
        'search'=> $search,
        'year_id'=>$year_id,
            
        ]);



    }
     //---------------จัดการประกาศ

     public function infobookentannouncecontrol(Request $request,$id,$iduser)
     {
         
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

                //--------------------------------------------
             $infordepartmentsub  =  DB::table('hrd_department_sub')->get();

             $inforsenddepartmentsubs =  DB::table('gbook_send_announce_sub')
             ->where('BOOK_ID','=',$idbook)
             ->get(); 
  
             $checksendinfordepartmentsub = DB::table('gbook_send_announce_sub')
             ->where('BOOK_ID','=',$idbook)
             ->count(); 
  
              //--------------------------------------------

                             //--------------------------------------------
             $infordepartmentsubsub  =  DB::table('hrd_department_sub_sub')->get();

             $inforsenddepartmentsubsubs =  DB::table('gbook_send_announce_sub_sub')
             ->where('BOOK_ID','=',$idbook)
             ->get(); 
  
             $checksendinfordepartmentsubsub = DB::table('gbook_send_announce_sub_sub')
             ->where('BOOK_ID','=',$idbook)
             ->count(); 
  
              //--------------------------------------------
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

         return view('general_document.gendocumentinfoannounce_control',[
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

       return redirect()->route('document.announcedoc',[
                    'iduser' => $iduser
       ]);
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

       return redirect()->route('document.infobookentannouncecontrol',[
           'id' => $bookid,
           'iduser' => $iduser
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
           return redirect()->route('document.infobookentannouncecontrol',[
               'id' => $bookid,
               'iduser' => $iduser
           ]);
       }
  //================================================================================= 




      //===============================ฟังชั่นต่างๆ==============================

      function departmentrow3(Request $request)
      {
  
          $infordepartments=  DB::table('hrd_department')->get();
  
          $infordepartments_select=  DB::table('hrd_department')->get();
        
          foreach ( $infordepartments as  $infordepartment){ 
  
              echo '<tr><td>'; 
              echo '<select name="row3[]" id="row3" class="form-control input-lg" style=" font-family: \'Kanit\', sans-serif;" >';
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
              echo '<td style="text-align: center;"><a class="btn btn-danger fa fa-trash-alt remove3" style="color:#FFFFFF;"></a></td>';
              echo '</tr>';
  
              }
  
          
          
      }
  
      
      function departmentrow4(Request $request)
      {
  
          $infordepartments=  DB::table('hrd_department_sub')->get();
  
          $infordepartments_select=  DB::table('hrd_department_sub')->get();
        
          foreach ( $infordepartments as  $infordepartment){ 
  
              echo '<tr><td>'; 
              echo '<select name="row4[]" id="row4" class="form-control input-lg" style=" font-family: \'Kanit\', sans-serif;" >';
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
              echo '<td style="text-align: center;"><a class="btn btn-danger fa fa-trash-alt remove4" style="color:#FFFFFF;"></a></td>';
              echo '</tr>';
  
              }
  
          
          
      }
  
      
      function departmentrow5(Request $request)
      {
  
          $infordepartments=  DB::table('hrd_department_sub_sub')->get();
  
          $infordepartments_select=  DB::table('hrd_department_sub_sub')->get();
        
          foreach ( $infordepartments as  $infordepartment){ 
  
              echo '<tr><td>'; 
              echo '<select name="row5[]" id="row5" class="form-control input-lg" style=" font-family: \'Kanit\', sans-serif;" >';
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
              echo '<td style="text-align: center;"><a class="btn btn-danger fa fa-trash-alt remove5" style="color:#FFFFFF;"></a></td>';
              echo '</tr>';
  
              }
  
          
          
      }
  
      public function checkreadenter(Request $request)
      {
        date_default_timezone_set('Asia/Bangkok');
        $date = date('Y-m-d H:i:s');

        $infocheck = DB::table('gbook_send_person')
        ->where('HR_PERSON_ID','=',$request->userid)
        ->where('BOOK_ID','=',$request->bookid)
        ->where('READ_STATUS','=','True')
        ->count();

        if($infocheck == 0){

            DB::table('gbook_send_person')
            ->where('HR_PERSON_ID', $request->userid)
            ->where('BOOK_ID', $request->bookid)
            ->update(['updated_at' => $date]);
            
            }

            
        DB::table('gbook_send_person')
        ->where('HR_PERSON_ID', $request->userid)
        ->where('BOOK_ID', $request->bookid)
        ->update(['READ_STATUS' => 'True']);


     
   
      }
    

      public function checkreadinside(Request $request)
      {
        date_default_timezone_set('Asia/Bangkok');
        $date = date('Y-m-d H:i:s');

        $infocheckinside = DB::table('gbook_send_inside')
        ->where('HR_PERSON_ID','=',$request->userid)
        ->where('BOOK_ID','=',$request->bookid)
        ->where('READ_STATUS','=','True')
        ->count();

        if($infocheckinside == 0){

            DB::table('gbook_send_inside')
            ->where('HR_PERSON_ID', $request->userid)
            ->where('BOOK_ID', $request->bookid)
            ->update(['updated_at' => $date]);
            
        }
            

        DB::table('gbook_send_inside')
        ->where('HR_PERSON_ID', $request->userid)
        ->where('BOOK_ID', $request->bookid)
        ->update(['READ_STATUS' => 'True']);

    
   
      }


      public function checkreadcomdoc(Request $request)
      {

        date_default_timezone_set('Asia/Bangkok');
        $date = date('Y-m-d H:i:s');

        $infocheckcommand = DB::table('gbook_send_command')
        ->where('HR_PERSON_ID','=',$request->userid)
        ->where('BOOK_ID','=',$request->bookid)
        ->where('READ_STATUS','=','True')
        ->count();

        if($infocheckcommand == 0){

            DB::table('gbook_send_command')
            ->where('HR_PERSON_ID', $request->userid)
            ->where('BOOK_ID', $request->bookid)
            ->update(['updated_at' => $date]);

        }
            
            
        DB::table('gbook_send_command')
        ->where('HR_PERSON_ID', $request->userid)
        ->where('BOOK_ID', $request->bookid)
        ->update(['READ_STATUS' => 'True']);

      
      }


      public function checkreadannounce(Request $request)
      {

        date_default_timezone_set('Asia/Bangkok');
        $date = date('Y-m-d H:i:s');

        $infocheckannounce = DB::table('gbook_send_announce')
        ->where('HR_PERSON_ID','=',$request->userid)
        ->where('BOOK_ID','=',$request->bookid)
        ->where('READ_STATUS','=','True')
        ->count();

        if($infocheckannounce == 0){

            DB::table('gbook_send_announce')
            ->where('HR_PERSON_ID', $request->userid)
            ->where('BOOK_ID', $request->bookid)
            ->update(['updated_at' => $date]);

        }
            
            
        DB::table('gbook_send_announce')
        ->where('HR_PERSON_ID', $request->userid)
        ->where('BOOK_ID', $request->bookid)
        ->update(['READ_STATUS' => 'True']);

     
   
      }
  
      //--------------------------------------------check permis-------------------------------------
  
      public static function checkmanagerbookinfo($idbook,$id_user)
      {
       $count =  Booksendperson::where('HR_PERSON_ID','=',$id_user)
                             ->where('BOOK_ID','=',$idbook)
                             ->count();   
      
       return $count;
      }
     

      public static function checkmanagerbookinfocom($idbook,$id_user)
      {
       $count =  Booksendcommand::where('HR_PERSON_ID','=',$id_user)
                             ->where('BOOK_ID','=',$idbook)
                             ->count();   
      
       return $count;
      }

      public static function checkmanagerbookinfoinside($idbook,$id_user)
      {
       $count =  Booksendinside::where('HR_PERSON_ID','=',$id_user)
                             ->where('BOOK_ID','=',$idbook)
                             ->count();   
      
       return $count;
      }

      public static function checkmanagerbookinfoannounce($idbook,$id_user)
      {
       $count =  Booksendannounce::where('HR_PERSON_ID','=',$id_user)
                             ->where('BOOK_ID','=',$idbook)
                             ->count();   
      
       return $count;
      }
     
     
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
   

       //--------------------------------------------check read-------------------------------------
       public static function checkreadcountenter($id_user)
       {
        $count =  Booksendperson::where('HR_PERSON_ID','=',$id_user)
                              ->where('READ_STATUS','=','False')
                              ->count();   
       
        return $count;
       }

       public static function checkreadcountinside($id_user)
       {
        $count =  Booksendinside::where('HR_PERSON_ID','=',$id_user)
                              ->where('READ_STATUS','=','False')
                              ->count();   
       
        return $count;
       }

       public static function checkreadcountcommand($id_user)
       {
        $count =  Booksendcommand::where('HR_PERSON_ID','=',$id_user)
                              ->where('READ_STATUS','=','False')
                              ->count();   
       
        return $count;
       }

       public static function checkreadcountannounce($id_user)
       {
        $count =  Booksendannounce::where('HR_PERSON_ID','=',$id_user)
                              ->where('READ_STATUS','=','False')
                              ->count();   
       
        return $count;
       }


       

///=============================ผอ.อนุมัติ

function checkcomment(Request $request)
{

    $comment = $request->get('comment');
    $output=' <textarea  name = "TOP_LEADER_AC_CMD"  id="TOP_LEADER_AC_CMD" rows="3" cols="50" class="form-control textarea-sm" style=" font-family: \'Kanit\', sans-serif;">'.$comment.'</textarea>';


echo $output;

}

    

}
