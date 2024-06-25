<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Person;
use App\Models\Checkin;

class CheckinController extends Controller
{
    

    public function selectcheck(Request $request,$iduser)
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
   
        $date = date('Y-m-d');

        $inforcheckin = Checkin::leftJoin('checkin_type','checkin_index.CHECKIN_TYPE_ID','=','checkin_type.CHECKIN_TYPE_ID')
        ->leftJoin('operate_job','checkin_index.OPERATE_JOB_ID','=','operate_job.OPERATE_JOB_ID')
        ->leftJoin('operate_type','operate_job.OPERATE_JOB_TYPE_ID','=','operate_type.OPERATE_TYPE_ID')        
        ->leftJoin('hrd_person','checkin_index.CHECKIN_PERSON_ID','=','hrd_person.ID')
        ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_position','checkin_index.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
        ->leftJoin('hrd_department_sub_sub','operate_job.OPERATE_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->where('checkin_index.CHECKIN_PERSON_ID','=',$iduser)
        ->where('CHEACKIN_DATE','=',$date)
        ->orderBy('CHECKIN_ID', 'desc') 
        ->get();

        return view('person_checkin.personinfocheckin',[
            'inforpersonuser' => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid, 
            'inforcheckins' => $inforcheckin, 
            
        ]);
    }

    public function checkin(Request $request,$idtype,$iduser)
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

        $depart =$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID;
        $checkintype = DB::table('checkin_type')->get();
        
        $operatejob = DB::table('operate_job')    
        ->where('OPERATE_DEPARTMENT_SUB_SUB_ID','=',$depart)
        ->get();

        return view('person_checkin.personinfocheckin_check',[
            'inforpersonuser' => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid, 
            'idtype' => $idtype,
            'checkintypes' => $checkintype, 
            'operatejobs' => $operatejob,
            'userid' => $id
            
        ]);
    }

    public function infocheck(Request $request,$iduser)
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

        $date = date('Y-m');

        $inforcheckin = Checkin::leftJoin('checkin_type','checkin_index.CHECKIN_TYPE_ID','=','checkin_type.CHECKIN_TYPE_ID')
        ->leftJoin('operate_job','checkin_index.OPERATE_JOB_ID','=','operate_job.OPERATE_JOB_ID')
        ->leftJoin('operate_type','operate_job.OPERATE_JOB_TYPE_ID','=','operate_type.OPERATE_TYPE_ID')        
        ->leftJoin('hrd_person','checkin_index.CHECKIN_PERSON_ID','=','hrd_person.ID')
        ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_position','checkin_index.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
        ->leftJoin('hrd_department_sub_sub','operate_job.OPERATE_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->orderBy('CHECKIN_ID', 'desc') 
        ->where('CHECKIN_PERSON_ID','=',$id) 
        ->where('CHEACKIN_DATE','like',$date.'%')
        ->get();

        $checkintype = DB::table('checkin_type')->get();

        $depart = DB::table('hrd_department_sub_sub')->get();

        $displaydate_bigen = '';
        $displaydate_end = '';
        $status = '';
        $search = '';

        return view('person_checkin.personinfocheckininfo',[
            'departs' => $depart,
            'inforpersonuser' => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid, 
            'inforcheckins' => $inforcheckin,
            'checkintypes' => $checkintype,
            'displaydate_bigen'=> $displaydate_bigen, 
            'displaydate_end'=> $displaydate_end,
            'status_check' => $status,
            'search' => $search
            
        ]);
    }

    public function search(Request $request,$iduser)
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
           $status = $request->STATUS_CODE;
           $datebigin = $request->get('DATE_BIGIN');
           $dateend = $request->get('DATE_END');  

           if($search==''){
               $search="";
           }
        

                   if( $datebigin != '' && $dateend != ''){

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
                                            $inforcheckin = Checkin::where('CHECKIN_PERSON_ID','=',$id)
                                            ->leftJoin('checkin_type','checkin_index.CHECKIN_TYPE_ID','=','checkin_type.CHECKIN_TYPE_ID')
                                            ->leftJoin('operate_job','checkin_index.OPERATE_JOB_ID','=','operate_job.OPERATE_JOB_ID')
                                            ->leftJoin('operate_type','operate_job.OPERATE_JOB_TYPE_ID','=','operate_type.OPERATE_TYPE_ID')        
                                            ->leftJoin('hrd_person','checkin_index.CHECKIN_PERSON_ID','=','hrd_person.ID')
                                            ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                                            ->leftJoin('hrd_position','checkin_index.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
                                            ->leftJoin('hrd_department_sub_sub','operate_job.OPERATE_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
                                            ->where(function($q) use ($search){
                                                $q->where('checkin_index.CHECKIN_ID','like','%'.$search.'%');
                                                $q->orwhere('CHECKIN_TYPE_NAME','like','%'.$search.'%');  
                                                $q->orwhere('OPERATE_JOB_NAME','like','%'.$search.'%');
                                                $q->orwhere('OPERATE_TYPE_NAME','like','%'.$search.'%'); 
                                                $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');                                                 
                                            })
                                            ->WhereBetween('CHEACKIN_DATE',[$from,$to]) 
                                            ->orderBy('checkin_index.CHECKIN_ID', 'desc')    
                                            ->get();
               }else{
                  
                                            $inforcheckin = Checkin::where('CHECKIN_PERSON_ID','=',$id)
                                            ->leftJoin('checkin_type','checkin_index.CHECKIN_TYPE_ID','=','checkin_type.CHECKIN_TYPE_ID')
                                            ->leftJoin('operate_job','checkin_index.OPERATE_JOB_ID','=','operate_job.OPERATE_JOB_ID')
                                            ->leftJoin('operate_type','operate_job.OPERATE_JOB_TYPE_ID','=','operate_type.OPERATE_TYPE_ID')        
                                            ->leftJoin('hrd_person','checkin_index.CHECKIN_PERSON_ID','=','hrd_person.ID')
                                            ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                                            ->leftJoin('hrd_position','checkin_index.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
                                            ->leftJoin('hrd_department_sub_sub','operate_job.OPERATE_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
                                            ->where('checkin_index.CHECKIN_TYPE_ID','=',$status) 
                                            ->where(function($q) use ($search){
                                                $q->where('checkin_index.CHECKIN_ID','like','%'.$search.'%');
                                                $q->orwhere('CHECKIN_TYPE_NAME','like','%'.$search.'%');  
                                                $q->orwhere('OPERATE_JOB_NAME','like','%'.$search.'%');
                                                $q->orwhere('OPERATE_TYPE_NAME','like','%'.$search.'%');  
                                                $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');                                                
                                            })
                                            ->WhereBetween('CHEACKIN_DATE',[$from,$to]) 
                                            ->orderBy('checkin_index.CHECKIN_ID', 'desc')    
                                            ->get();                   
                  
               }    
               
                }else{
                   if($status == null){ 
                                            $inforcheckin = Checkin::where('CHECKIN_PERSON_ID','=',$id)
                                            ->leftJoin('checkin_type','checkin_index.CHECKIN_TYPE_ID','=','checkin_type.CHECKIN_TYPE_ID')
                                            ->leftJoin('operate_job','checkin_index.OPERATE_JOB_ID','=','operate_job.OPERATE_JOB_ID')
                                            ->leftJoin('operate_type','operate_job.OPERATE_JOB_TYPE_ID','=','operate_type.OPERATE_TYPE_ID')        
                                            ->leftJoin('hrd_person','checkin_index.CHECKIN_PERSON_ID','=','hrd_person.ID')
                                            ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                                            ->leftJoin('hrd_position','checkin_index.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
                                            ->leftJoin('hrd_department_sub_sub','operate_job.OPERATE_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
                                            ->where(function($q) use ($search){
                                                $q->where('checkin_index.CHECKIN_ID','like','%'.$search.'%');
                                                $q->orwhere('CHECKIN_TYPE_NAME','like','%'.$search.'%');  
                                                $q->orwhere('OPERATE_JOB_NAME','like','%'.$search.'%');
                                                $q->orwhere('OPERATE_TYPE_NAME','like','%'.$search.'%');
                                                $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');                                                  
                                            })                                           
                                            ->orderBy('checkin_index.CHECKIN_ID', 'desc')    
                                            ->get(); 
                
                   }else{
                                            $inforcheckin = Checkin::where('CHECKIN_PERSON_ID','=',$id)
                                            ->leftJoin('checkin_type','checkin_index.CHECKIN_TYPE_ID','=','checkin_type.CHECKIN_TYPE_ID')
                                            ->leftJoin('operate_job','checkin_index.OPERATE_JOB_ID','=','operate_job.OPERATE_JOB_ID')
                                            ->leftJoin('operate_type','operate_job.OPERATE_JOB_TYPE_ID','=','operate_type.OPERATE_TYPE_ID')        
                                            ->leftJoin('hrd_person','checkin_index.CHECKIN_PERSON_ID','=','hrd_person.ID')
                                            ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                                            ->leftJoin('hrd_position','checkin_index.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
                                            ->leftJoin('hrd_department_sub_sub','operate_job.OPERATE_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
                                            ->where('checkin_index.CHECKIN_TYPE_ID','=',$status) 
                                            ->where(function($q) use ($search){
                                                $q->where('checkin_index.CHECKIN_ID','like','%'.$search.'%');
                                                $q->orwhere('CHECKIN_TYPE_NAME','like','%'.$search.'%');  
                                                $q->orwhere('OPERATE_JOB_NAME','like','%'.$search.'%');
                                                $q->orwhere('OPERATE_TYPE_NAME','like','%'.$search.'%');   
                                                $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');                                               
                                            })                                         
                                            ->orderBy('checkin_index.CHECKIN_ID', 'desc')    
                                            ->get();                      
                   }        
                }

                $checkintype = DB::table('checkin_type')->get();

                $depart = DB::table('hrd_department_sub_sub')->get();
       
               return view('person_checkin.personinfocheckininfo',[ 
                'departs' => $depart,
                    'inforpersonuser' => $inforpersonuser, 
                    'inforpersonuserid' => $inforpersonuserid,            
                   'inforcheckins' => $inforcheckin,
                   'checkintypes'=>$checkintype,
                   'displaydate_bigen'=> $displaydate_bigen, 
                    'displaydate_end'=> $displaydate_end,
                    'status_check' => $status,
                    'search' => $search
                                     
               ]);
              
   }
    public function save(Request $request)
    {

             date_default_timezone_set("Asia/Bangkok");
            $date_now = date('Y-m-d'); 
             

            $addcheckin= new Checkin(); 
         
            $addcheckin->CHECKIN_PERSON_ID = $request->CHECKIN_PERSON_ID;   
            $addcheckin->HR_POSITION_ID = $request->HR_POSITION_ID;   
            $addcheckin->HR_DEPARTMENT_SUB_SUB_ID = $request->HR_DEPARTMENT_SUB_SUB_ID;   
            $addcheckin->CHEACKIN_DATE = $date_now;   
            $addcheckin->CHEACKIN_TIME = $request->time;   
            $addcheckin->CHECKIN_TYPE_ID = $request->CHECKIN_TYPE_ID;   
            $addcheckin->OPERATE_JOB_ID = $request->OPERATE_JOB_ID;   
            $addcheckin->CHECKIN_REMARK = $request->CHECKIN_REMARK;   
            $addcheckin->IMG = $request->results;
            $addcheckin->CHECKIN_IP = $request->CHECKIN_IP;         
            
           $addcheckin->save();

           return redirect()->route('check.infocheck',['iduser'=>  $request->CHECKIN_PERSON_ID]);

    }
   
    public function excel_checkin(Request $request,$iduser)
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


        $date = date('Y-m-d');

        $inforcheckin = Checkin::leftJoin('checkin_type','checkin_index.CHECKIN_TYPE_ID','=','checkin_type.CHECKIN_TYPE_ID')
        ->leftJoin('operate_job','checkin_index.OPERATE_JOB_ID','=','operate_job.OPERATE_JOB_ID')
        ->leftJoin('operate_type','operate_job.OPERATE_JOB_TYPE_ID','=','operate_type.OPERATE_TYPE_ID')        
        ->leftJoin('hrd_person','checkin_index.CHECKIN_PERSON_ID','=','hrd_person.ID')
        ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_position','checkin_index.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
        ->leftJoin('hrd_department_sub_sub','operate_job.OPERATE_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->orderBy('CHECKIN_ID', 'desc') 
        ->where('CHECKIN_PERSON_ID','=',$id) 
        ->where('CHEACKIN_DATE','=',$date)
        ->get();

        return view('person_checkin.excel_checkin',[
            'inforpersonuser' => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid, 
            'inforcheckins' => $inforcheckin,
           
        ]);
    }


}
