<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Person;
use App\Models\Operateindex;
use App\Models\Operateactivity;
use App\Models\Operatemember;
use App\Models\Operatetrade;
use App\Models\Otcommand;
use App\Models\Operateswap;
use App\Models\Permislist;
use PDF;


class OperateController extends Controller
{
    public function operatesearch(Request $request,$iduser)
    {
          //------เริ่มการค้นหา------------
          $searchmonth = $request->OPERATE_MONTH;
          $searchyear = $request->get('OPERATE_INDEX_YEAR')-543;
          $status = $request->SEND_STATUS;
          $search = $request->get('search'); 
  
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



          if($search==''){
              $search="";
          }
        if($searchmonth == '' && $searchyear == '' && $status=='' ){

            $operateindex = DB::table('operate_index')
            ->leftJoin('operate_status','operate_index.OPERATE_STATUS','=','operate_status.OPERATE_STATUS_CODE')
            ->leftJoin('hrd_department_sub_sub','operate_index.OPERATE_DEPARTMENT_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
            ->leftJoin('operate_type','operate_index.OPERATE_TYPE','=','operate_type.OPERATE_TYPE_ID')
            ->where(function($q) use ($search){                   
                $q->where('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');  
                $q->orwhere('OPERATE_ORGANIZER_NAME','like','%'.$search.'%');              
            })              
            ->orderby('OPERATE_INDEX_ID','desc')         
            ->get();

        }elseif($searchmonth != '' && $searchyear == '' && $status ==''){
           
            $operateindex = DB::table('operate_index')
            ->leftJoin('operate_status','operate_index.OPERATE_STATUS','=','operate_status.OPERATE_STATUS_CODE')
            ->leftJoin('hrd_department_sub_sub','operate_index.OPERATE_DEPARTMENT_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
            ->leftJoin('operate_type','operate_index.OPERATE_TYPE','=','operate_type.OPERATE_TYPE_ID')
            ->where('operate_index.OPERATE_INDEX_MONTH','=',$searchmonth)
            ->where(function($q) use ($search){                   
                $q->where('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');  
                $q->orwhere('OPERATE_ORGANIZER_NAME','like','%'.$search.'%');              
            })              
            ->orderby('OPERATE_INDEX_ID','desc')         
            ->get();

        }else if($searchmonth != '' && $searchyear != '' && $status ==''){
           
            $operateindex = DB::table('operate_index')
            ->leftJoin('operate_status','operate_index.OPERATE_STATUS','=','operate_status.OPERATE_STATUS_CODE')
            ->leftJoin('hrd_department_sub_sub','operate_index.OPERATE_DEPARTMENT_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
            ->leftJoin('operate_type','operate_index.OPERATE_TYPE','=','operate_type.OPERATE_TYPE_ID')
            ->where('operate_index.OPERATE_INDEX_MONTH','=',$searchmonth)
            ->where('operate_index.OPERATE_INDEX_YEAR','=',$searchyear)
            ->where(function($q) use ($search){                   
                $q->where('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');  
                $q->orwhere('OPERATE_ORGANIZER_NAME','like','%'.$search.'%');              
            })              
            ->orderby('OPERATE_INDEX_ID','desc')         
            ->get();

        }elseif($searchmonth != '' && $searchyear != '' && $status !=''){
           
            $operateindex = DB::table('operate_index')
            ->leftJoin('operate_status','operate_index.OPERATE_STATUS','=','operate_status.OPERATE_STATUS_CODE')
            ->leftJoin('hrd_department_sub_sub','operate_index.OPERATE_DEPARTMENT_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
            ->leftJoin('operate_type','operate_index.OPERATE_TYPE','=','operate_type.OPERATE_TYPE_ID')
            ->where('operate_index.OPERATE_INDEX_MONTH','=',$searchmonth)
            ->where('operate_index.OPERATE_INDEX_YEAR','=',$searchyear)
            ->where('operate_index.OPERATE_STATUS','=',$status)
            ->where(function($q) use ($search){                   
                $q->where('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');  
                $q->orwhere('OPERATE_ORGANIZER_NAME','like','%'.$search.'%');              
            })              
            ->orderby('OPERATE_INDEX_ID','desc')         
            ->get(); 

        }elseif($searchmonth == '' && $searchyear == '' && $status !=''){
          
            $operateindex = DB::table('operate_index')
            ->leftJoin('operate_status','operate_index.OPERATE_STATUS','=','operate_status.OPERATE_STATUS_CODE')
            ->leftJoin('hrd_department_sub_sub','operate_index.OPERATE_DEPARTMENT_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
            ->leftJoin('operate_type','operate_index.OPERATE_TYPE','=','operate_type.OPERATE_TYPE_ID')
            ->where('operate_index.OPERATE_STATUS','=',$status)
            ->where(function($q) use ($search){                   
                $q->where('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');  
                $q->orwhere('OPERATE_ORGANIZER_NAME','like','%'.$search.'%');              
            })              
            ->orderby('OPERATE_INDEX_ID','desc')         
            ->get(); 
            
        }elseif($searchmonth == '' && $searchyear != '' && $status ==''){
           
            $operateindex = DB::table('operate_index')
            ->leftJoin('operate_status','operate_index.OPERATE_STATUS','=','operate_status.OPERATE_STATUS_CODE')
            ->leftJoin('hrd_department_sub_sub','operate_index.OPERATE_DEPARTMENT_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID') 
            ->leftJoin('operate_type','operate_index.OPERATE_TYPE','=','operate_type.OPERATE_TYPE_ID')
            ->where('operate_index.OPERATE_INDEX_YEAR','=',$searchyear)
            ->where(function($q) use ($search){                   
                $q->where('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');  
                $q->orwhere('OPERATE_ORGANIZER_NAME','like','%'.$search.'%');              
            })              
            ->orderby('OPERATE_INDEX_ID','desc')         
            ->get(); 
  
                  
         }else if($searchmonth == '' && $searchyear != '' && $status !=''){
            
            $operateindex = DB::table('operate_index')
            ->leftJoin('operate_status','operate_index.OPERATE_STATUS','=','operate_status.OPERATE_STATUS_CODE')
            ->leftJoin('hrd_department_sub_sub','operate_index.OPERATE_DEPARTMENT_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
            ->leftJoin('operate_type','operate_index.OPERATE_TYPE','=','operate_type.OPERATE_TYPE_ID')
            ->where('operate_index.OPERATE_INDEX_YEAR','=',$searchyear)
             ->where('operate_index.OPERATE_STATUS','=',$status)
            ->where(function($q) use ($search){                   
                $q->where('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');  
                $q->orwhere('OPERATE_ORGANIZER_NAME','like','%'.$search.'%');              
            })              
            ->orderby('OPERATE_INDEX_ID','desc')         
            ->get();

        
        }else if($searchmonth != '' && $searchyear == '' && $status !==''){            
           
            $operateindex = DB::table('operate_index')
            ->leftJoin('operate_status','operate_index.OPERATE_STATUS','=','operate_status.OPERATE_STATUS_CODE')
            ->leftJoin('hrd_department_sub_sub','operate_index.OPERATE_DEPARTMENT_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
            ->leftJoin('operate_type','operate_index.OPERATE_TYPE','=','operate_type.OPERATE_TYPE_ID')
            ->where('operate_index.OPERATE_INDEX_MONTH','=',$searchmonth)
             ->where('operate_index.OPERATE_STATUS','=',$status)
            ->where(function($q) use ($search){                   
                $q->where('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');  
                $q->orwhere('OPERATE_ORGANIZER_NAME','like','%'.$search.'%');              
            })              
            ->orderby('OPERATE_INDEX_ID','desc')         
            ->get();
           
        }
      
     
       
        $operatejob = DB::table('operate_job')->get();
        
        $leavemonth = DB::table('leave_month')->get();
        $operatestatus = DB::table('operate_status')->get();

        $budgetyear = DB::table('budget_year')
        ->get();
       
        $searchyear_check = $searchyear+543;
      
        return view('general_operate.geninfooperate_set',[
            'inforpersonuser' => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid,
            'operateindexs' => $operateindex, 
            'operatejobs' => $operatejob ,
            'status_check' => $status , 
            'search' => $search , 
            'searchmonth_check' => $searchmonth ,        
            'searchyear_check' => $searchyear_check,
           'leavemonths' => $leavemonth,
           'operatestatuss' => $operatestatus,
           'budgetyears' => $budgetyear
           
            
        ]);
    }

//////---------------------------end---------------------------------------------------//



//========================== แลกเวร  ==========================================//

public function genoperatetrade(Request $request,$iduser)
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

            

              $leavemonth = DB::table('leave_month')->get();

              $operatestatus = DB::table('operate_status')->get();

              $budgetyear = DB::table('budget_year')
              ->get();
             
              $searchmonth = '';
              $searchyear = date('Y');
              $status = '';
              $search = '';

              $operate_trade = DB::table('operate_trade')
              ->leftjoin('operate_status','operate_status.OPERATE_STATUS_CODE','=','operate_trade.OPERATETRADE_STATUS')
              ->leftjoin('hrd_person','hrd_person.ID','=','operate_trade.OPERATETRADE_CHANG_USERID')
              ->leftjoin('operate_job','operate_job.OPERATE_JOB_ID','=','operate_trade.OPERATETRADE_OPERATE_JOB')
              ->leftjoin('hrd_position','hrd_position.HR_POSITION_ID','=','operate_trade.OPERATETRADE_CHANG_POSITION')
              ->get();

        return view('general_operate.genoperatetrade',[
            'operate_trades' => $operate_trade,
            'inforpersonuser' => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid, 
            'status_check' => $status,
             'search' => $search,
             'searchmonth_check' => $searchmonth,
             'searchyear_check' => $searchyear,
             'leavemonths' => $leavemonth,
             'operatestatuss' => $operatestatus,
             'budgetyears' => $budgetyear

           
            
        ]);
    }

public function genoperatetrade_search(Request $request,$iduser)
{
        //------เริ่มการค้นหา------------
    $searchmonth = $request->OPERATETRADE_MOUNT;
    $searchyear = $request->get('OPERATETRADE_YEAR')-543;
    $status = $request->SEND_STATUS;
    $search = $request->get('search'); 

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

        
        if($search==''){
        $search="";
        }

        if($searchmonth == '' && $searchyear == '' && $status=='' ){
            $operate_trade = DB::table('operate_trade')
            ->leftjoin('operate_status','operate_status.OPERATE_STATUS_CODE','=','operate_trade.OPERATETRADE_STATUS')
            ->leftjoin('hrd_person','hrd_person.ID','=','operate_trade.OPERATETRADE_USERTRADE')
            ->leftjoin('operate_job','operate_job.OPERATE_JOB_ID','=','operate_trade.OPERATETRADE_OPERATE_JOB')
            ->leftjoin('hrd_position','hrd_position.HR_POSITION_ID','=','operate_trade.OPERATETRADE_CHANG_POSITION')
            ->where(function($q) use ($search){                   
            $q->where('OPERATETRADE_OPERATE_JOB','like','%'.$search.'%');  
            $q->orwhere('OPERATETRADE_OPERATE_JOBCHANG','like','%'.$search.'%');              
            $q->orwhere('OPERATETRADE_CHANG_USERNAME','like','%'.$search.'%'); 
        })              
        ->orderby('OPERATETRADE_ID','desc') 
            ->get();

        }elseif($searchmonth != '' && $searchyear == '' && $status ==''){
            $operate_trade = DB::table('operate_trade')
            ->leftjoin('operate_status','operate_status.OPERATE_STATUS_CODE','=','operate_trade.OPERATETRADE_STATUS')
            ->leftjoin('hrd_person','hrd_person.ID','=','operate_trade.OPERATETRADE_USERTRADE')
            ->leftjoin('operate_job','operate_job.OPERATE_JOB_ID','=','operate_trade.OPERATETRADE_OPERATE_JOB')
            ->leftjoin('hrd_position','hrd_position.HR_POSITION_ID','=','operate_trade.OPERATETRADE_CHANG_POSITION')
            ->where('operate_trade.OPERATETRADE_MOUNT','=',$searchmonth)
            ->where(function($q) use ($search){                   
            $q->where('OPERATETRADE_OPERATE_JOB','like','%'.$search.'%');  
            $q->orwhere('OPERATETRADE_OPERATE_JOBCHANG','like','%'.$search.'%');              
            $q->orwhere('OPERATETRADE_CHANG_USERNAME','like','%'.$search.'%'); 
        })              
        ->orderby('OPERATETRADE_ID','desc') 
            ->get();

        }else if($searchmonth != '' && $searchyear != '' && $status ==''){       
        $operate_trade = DB::table('operate_trade')
        ->leftjoin('operate_status','operate_status.OPERATE_STATUS_CODE','=','operate_trade.OPERATETRADE_STATUS')
        ->leftjoin('hrd_person','hrd_person.ID','=','operate_trade.OPERATETRADE_USERTRADE')
        ->leftjoin('operate_job','operate_job.OPERATE_JOB_ID','=','operate_trade.OPERATETRADE_OPERATE_JOB')
        ->leftjoin('hrd_position','hrd_position.HR_POSITION_ID','=','operate_trade.OPERATETRADE_CHANG_POSITION')
        ->where('operate_trade.OPERATETRADE_MOUNT','=',$searchmonth)
        ->where('operate_trade.OPERATETRADE_YEAR','=',$searchyear)
        ->where(function($q) use ($search){                   
            $q->where('OPERATETRADE_OPERATE_JOB','like','%'.$search.'%');  
            $q->orwhere('OPERATETRADE_OPERATE_JOBCHANG','like','%'.$search.'%');              
            $q->orwhere('OPERATETRADE_CHANG_USERNAME','like','%'.$search.'%'); 
        })              
        ->orderby('OPERATETRADE_ID','desc') 
        ->get();

        }elseif($searchmonth != '' && $searchyear != '' && $status !=''){
        
        $operate_trade = DB::table('operate_trade')
        ->leftjoin('operate_status','operate_status.OPERATE_STATUS_CODE','=','operate_trade.OPERATETRADE_STATUS')
        ->leftjoin('hrd_person','hrd_person.ID','=','operate_trade.OPERATETRADE_USERTRADE')
        ->leftjoin('operate_job','operate_job.OPERATE_JOB_ID','=','operate_trade.OPERATETRADE_OPERATE_JOB')
        ->leftjoin('hrd_position','hrd_position.HR_POSITION_ID','=','operate_trade.OPERATETRADE_CHANG_POSITION')
        ->where('operate_trade.OPERATETRADE_MOUNT','=',$searchmonth)
        ->where('operate_trade.OPERATETRADE_YEAR','=',$searchyear)
        ->where('operate_trade.OPERATETRADE_STATUS','=',$status)
        ->where(function($q) use ($search){                   
            $q->where('OPERATETRADE_OPERATE_JOB','like','%'.$search.'%');  
            $q->orwhere('OPERATETRADE_OPERATE_JOBCHANG','like','%'.$search.'%');              
            $q->orwhere('OPERATETRADE_CHANG_USERNAME','like','%'.$search.'%'); 
        })              
        ->orderby('OPERATETRADE_ID','desc') 
        ->get();

        }elseif($searchmonth == '' && $searchyear == '' && $status !=''){
        
    
        $operate_trade = DB::table('operate_trade')
        ->leftjoin('operate_status','operate_status.OPERATE_STATUS_CODE','=','operate_trade.OPERATETRADE_STATUS')
        ->leftjoin('hrd_person','hrd_person.ID','=','operate_trade.OPERATETRADE_USERTRADE')
        ->leftjoin('operate_job','operate_job.OPERATE_JOB_ID','=','operate_trade.OPERATETRADE_OPERATE_JOB')
        ->leftjoin('hrd_position','hrd_position.HR_POSITION_ID','=','operate_trade.OPERATETRADE_CHANG_POSITION')           
        ->where('operate_trade.OPERATETRADE_STATUS','=',$status)
        ->where(function($q) use ($search){                   
            $q->where('OPERATETRADE_OPERATE_JOB','like','%'.$search.'%');  
            $q->orwhere('OPERATETRADE_OPERATE_JOBCHANG','like','%'.$search.'%');              
            $q->orwhere('OPERATETRADE_CHANG_USERNAME','like','%'.$search.'%'); 
        })              
        ->orderby('OPERATETRADE_ID','desc') 
        ->get();
            
        }elseif($searchmonth == '' && $searchyear != '' && $status ==''){
            
    
        $operate_trade = DB::table('operate_trade')
        ->leftjoin('operate_status','operate_status.OPERATE_STATUS_CODE','=','operate_trade.OPERATETRADE_STATUS')
        ->leftjoin('hrd_person','hrd_person.ID','=','operate_trade.OPERATETRADE_USERTRADE')
        ->leftjoin('operate_job','operate_job.OPERATE_JOB_ID','=','operate_trade.OPERATETRADE_OPERATE_JOB')
        ->leftjoin('hrd_position','hrd_position.HR_POSITION_ID','=','operate_trade.OPERATETRADE_CHANG_POSITION')
        ->where('operate_trade.OPERATETRADE_YEAR','=',$searchyear)
        ->where(function($q) use ($search){                   
            $q->where('OPERATETRADE_OPERATE_JOB','like','%'.$search.'%');  
            $q->orwhere('OPERATETRADE_OPERATE_JOBCHANG','like','%'.$search.'%');              
            $q->orwhere('OPERATETRADE_CHANG_USERNAME','like','%'.$search.'%'); 
        })              
        ->orderby('OPERATETRADE_ID','desc') 
        ->get();
                
        }else if($searchmonth == '' && $searchyear != '' && $status !=''){
    
        $operate_trade = DB::table('operate_trade')
        ->leftjoin('operate_status','operate_status.OPERATE_STATUS_CODE','=','operate_trade.OPERATETRADE_STATUS')
        ->leftjoin('hrd_person','hrd_person.ID','=','operate_trade.OPERATETRADE_USERTRADE')
        ->leftjoin('operate_job','operate_job.OPERATE_JOB_ID','=','operate_trade.OPERATETRADE_OPERATE_JOB')
        ->leftjoin('hrd_position','hrd_position.HR_POSITION_ID','=','operate_trade.OPERATETRADE_CHANG_POSITION')
        ->where('operate_trade.OPERATETRADE_YEAR','=',$searchyear)
        ->where('operate_trade.OPERATETRADE_STATUS','=',$status)
        ->where(function($q) use ($search){                   
            $q->where('OPERATETRADE_OPERATE_JOB','like','%'.$search.'%');  
            $q->orwhere('OPERATETRADE_OPERATE_JOBCHANG','like','%'.$search.'%');              
            $q->orwhere('OPERATETRADE_CHANG_USERNAME','like','%'.$search.'%'); 
        })              
        ->orderby('OPERATETRADE_ID','desc') 
        ->get();

        
        }else if($searchmonth != '' && $searchyear == '' && $status !==''){            
            
    
        $operate_trade = DB::table('operate_trade')
        ->leftjoin('operate_status','operate_status.OPERATE_STATUS_CODE','=','operate_trade.OPERATETRADE_STATUS')
        ->leftjoin('hrd_person','hrd_person.ID','=','operate_trade.OPERATETRADE_USERTRADE')
        ->leftjoin('operate_job','operate_job.OPERATE_JOB_ID','=','operate_trade.OPERATETRADE_OPERATE_JOB')
        ->leftjoin('hrd_position','hrd_position.HR_POSITION_ID','=','operate_trade.OPERATETRADE_CHANG_POSITION')
        ->where('operate_trade.OPERATETRADE_MOUNT','=',$searchmonth)
        ->where('operate_trade.OPERATETRADE_STATUS','=',$status)
        ->where(function($q) use ($search){                   
            $q->where('OPERATETRADE_OPERATE_JOB','like','%'.$search.'%');  
            $q->orwhere('OPERATETRADE_OPERATE_JOBCHANG','like','%'.$search.'%');              
            $q->orwhere('OPERATETRADE_CHANG_USERNAME','like','%'.$search.'%'); 
        })              
        ->orderby('OPERATETRADE_ID','desc') 
        ->get();
            
        }
    
        
        $operatejob = DB::table('operate_job')->get();   

        $leavemonth = DB::table('leave_month')->get();
        $operatestatus = DB::table('operate_status')->get();  
        $budgetyear = DB::table('budget_year')
        ->get();         
        $searchyear_check = $searchyear+543;
    
        return view('general_operate.genoperatetrade',[
            'inforpersonuser' => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid,
            'operate_trades' => $operate_trade, 
            'operatejobs' => $operatejob ,
            'status_check' => $status , 
            'search' => $search , 
            'searchmonth_check' => $searchmonth ,        
            'searchyear_check' => $searchyear_check,
            'leavemonths' => $leavemonth,
            'operatestatuss' => $operatestatus,
            'budgetyears' => $budgetyear
            
            
        ]);
}


public function genoperatetrade_add(Request $request,$iduser)
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

    $infodepartment = DB::table('hrd_department_sub_sub')->get();
    
    $infoorg = DB::table('info_org')
    ->leftJoin('hrd_person','hrd_person.ID','=','info_org.ORG_LEADER_ID')
    ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->first();

    $info =  Person::get();
    $operatejob = DB::table('operate_job')->get();
    $position = DB::table('hrd_position')->get();

    $inforperson =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')->get();
    $inforposition  =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')->get();

    $infobudget = DB::table('budget_year')->get();


    return view('general_operate.genoperatetrade_add',[
      
        'infos' => $info,
        'positions' => $position,
        'operatejobs' => $operatejob,
        'inforpersonuser' => $inforpersonuser,
        'inforpersonuserid' => $inforpersonuserid, 
        'infodepartments' => $infodepartment,
        'infoorg' => $infoorg,
        'inforpersons' => $inforperson,
        'inforpositions' => $inforposition,
        'infobudgets' => $infobudget
        
    ]);
}

public function genoperatetrade_save(Request $request)
{
    $datebigin = $request->get('OPERATETRADE_DATE_JOB');
    $dateend = $request->get('OPERATETRADE_DATE_JOBCNANG');

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
    $datejob= $y."-".$m."-".$d;

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
    $datejob_chang= $y_e."-".$m_e."-".$d_e;

       $from_datejob = date($datejob);
       $to_datejob_chang = date($datejob_chang); 
    
       $iduser = $request->OPERATETRADE_USERTRADE;
      


    $add = new Operatetrade();
    $add->OPERATETRADE_USERTRADE = $iduser;
    $add->OPERATETRADE_POSITION_TRADE = $request->OPERATETRADE_POSITION_TRADE;
    $add->OPERATETRADE_DATE_JOB = $from_datejob;
    $add->OPERATETRADE_OPERATE_JOB = $request->OPERATETRADE_OPERATE_JOB;

        $userchang = Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->where('hrd_person.ID','=',$request->OPERATETRADE_CHANG_USERID)->first();

    $add->OPERATETRADE_CHANG_USERID = $userchang->ID;
    $add->OPERATETRADE_CHANG_USERNAME = $userchang->HR_PREFIX_NAME.' '.$userchang->HR_FNAME.' '.$userchang->HR_LNAME;
    $add->OPERATETRADE_CHANG_POSITION = $request->OPERATETRADE_CHANG_POSITION;
    $add->OPERATETRADE_DATE_JOBCNANG = $to_datejob_chang;

    $jobchang = DB::table('operate_job')->where('OPERATE_JOB_ID','=',$request->OPERATETRADE_OPERATE_JOBCHANG)->first();

    $add->OPERATETRADE_OPERATE_JOBCHANG = $jobchang->OPERATE_JOB_ID;   
    $add->OPERATETRADE_OPERATE_JOBCHANG_NAME = $jobchang->OPERATE_JOB_NAME; 
    $add->OPERATETRADE_STATUS = 'Pending';  
    
    $add->OPERATETRADE_MOUNT = $request->OPERATETRADE_MOUNT;
    $add->OPERATETRADE_YEAR = $request->OPERATETRADE_YEAR;
    $add->OPERATETRADE_COMMENT = $request->OPERATETRADE_COMMENT;
    $add->save(); 

    return redirect()->route('operate.genoperatetrade',['iduser'=>$iduser]);
}

public function genoperatetrade_edit(Request $request,$idref,$iduser)
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

    $infodepartment = DB::table('hrd_department_sub_sub')->get();
    
    $infoorg = DB::table('info_org')
    ->leftJoin('hrd_person','hrd_person.ID','=','info_org.ORG_LEADER_ID')
    ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->first();

    $info =  Person::get();
    $operatejob = DB::table('operate_job')->get();
    $position = DB::table('hrd_position')->get();

    $inforperson =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')->get();
    $inforposition  =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')->get();

    $infobudget = DB::table('budget_year')->get();

    $operate_trade = DB::table('operate_trade')
              ->leftjoin('operate_status','operate_status.OPERATE_STATUS_CODE','=','operate_trade.OPERATETRADE_STATUS')
              ->leftjoin('hrd_person','hrd_person.ID','=','operate_trade.OPERATETRADE_USERTRADE')
              ->leftjoin('operate_job','operate_job.OPERATE_JOB_ID','=','operate_trade.OPERATETRADE_OPERATE_JOB')
              ->leftjoin('hrd_position','hrd_position.HR_POSITION_ID','=','operate_trade.OPERATETRADE_CHANG_POSITION')
              ->where('OPERATETRADE_ID','=',$idref)
              ->first();


    return view('general_operate.genoperatetrade_edit',[
      'operate_trades'=> $operate_trade,
        'infos' => $info,
        'positions' => $position,
        'operatejobs' => $operatejob,
        'inforpersonuser' => $inforpersonuser,
        'inforpersonuserid' => $inforpersonuserid, 
        'infodepartments' => $infodepartment,
        'infoorg' => $infoorg,
        'inforpersons' => $inforperson,
        'inforpositions' => $inforposition,
        'infobudgets' => $infobudget
        
    ]);
}

public function genoperatetrade_update(Request $request)
{
    $datebigin = $request->get('OPERATETRADE_DATE_JOB');
    $dateend = $request->get('OPERATETRADE_DATE_JOBCNANG');

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
    $datejob= $y."-".$m."-".$d;

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
    $datejob_chang= $y_e."-".$m_e."-".$d_e;

       $from_datejob = date($datejob);
       $to_datejob_chang = date($datejob_chang); 
    
       $iduser = $request->OPERATETRADE_USERTRADE;
      
       $idref = $request->OPERATETRADE_ID;

    $update = Operatetrade::find($idref);
    $update->OPERATETRADE_USERTRADE = $iduser;
    $update->OPERATETRADE_POSITION_TRADE = $request->OPERATETRADE_POSITION_TRADE;
    $update->OPERATETRADE_DATE_JOB = $from_datejob;
    $update->OPERATETRADE_OPERATE_JOB = $request->OPERATETRADE_OPERATE_JOB;

        $userchang = Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->where('hrd_person.ID','=',$request->OPERATETRADE_CHANG_USERID)->first();

    $update->OPERATETRADE_CHANG_USERID = $userchang->ID;
    $update->OPERATETRADE_CHANG_USERNAME = $userchang->HR_PREFIX_NAME.' '.$userchang->HR_FNAME.' '.$userchang->HR_LNAME;
    $update->OPERATETRADE_CHANG_POSITION = $request->OPERATETRADE_CHANG_POSITION;
    $update->OPERATETRADE_DATE_JOBCNANG = $to_datejob_chang;

    $jobchang = DB::table('operate_job')->where('OPERATE_JOB_ID','=',$request->OPERATETRADE_OPERATE_JOBCHANG)->first();

    $update->OPERATETRADE_OPERATE_JOBCHANG = $jobchang->OPERATE_JOB_ID;   
    $update->OPERATETRADE_OPERATE_JOBCHANG_NAME = $jobchang->OPERATE_JOB_NAME;  
    
    $update->OPERATETRADE_MOUNT = $request->OPERATETRADE_MOUNT;
    $update->OPERATETRADE_YEAR = $request->OPERATETRADE_YEAR;
    $update->OPERATETRADE_COMMENT = $request->OPERATETRADE_COMMENT;
    $update->save(); 

    return redirect()->route('operate.genoperatetrade',['iduser'=>$iduser]);
}

public function genoperatetrade_cancel(Request $request,$idref,$iduser)
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

    $infodepartment = DB::table('hrd_department_sub_sub')->get();
    
    $infoorg = DB::table('info_org')
    ->leftJoin('hrd_person','hrd_person.ID','=','info_org.ORG_LEADER_ID')
    ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->first();

    $info =  Person::get();
    $operatejob = DB::table('operate_job')->get();
    $position = DB::table('hrd_position')->get();

    $inforperson =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')->get();
    $inforposition  =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')->get();

    $infobudget = DB::table('budget_year')->get();

    $operate_trade = DB::table('operate_trade')
              ->leftjoin('operate_status','operate_status.OPERATE_STATUS_CODE','=','operate_trade.OPERATETRADE_STATUS')
              ->leftjoin('hrd_person','hrd_person.ID','=','operate_trade.OPERATETRADE_USERTRADE')
              ->leftjoin('operate_job','operate_job.OPERATE_JOB_ID','=','operate_trade.OPERATETRADE_OPERATE_JOB')
              ->leftjoin('hrd_position','hrd_position.HR_POSITION_ID','=','operate_trade.OPERATETRADE_CHANG_POSITION')
              ->where('OPERATETRADE_ID','=',$idref)
              ->first();


    return view('general_operate.genoperatetrade_cancel',[
      'operate_trades'=> $operate_trade,
        'infos' => $info,
        'positions' => $position,
        'operatejobs' => $operatejob,
        'inforpersonuser' => $inforpersonuser,
        'inforpersonuserid' => $inforpersonuserid, 
        'infodepartments' => $infodepartment,
        'infoorg' => $infoorg,
        'inforpersons' => $inforperson,
        'inforpositions' => $inforposition,
        'infobudgets' => $infobudget
        
    ]);
}

public function genoperatetrade_updatecancel(Request $request)
{
      
       $iduser = $request->OPERATETRADE_USERTRADE;
      
       $idref = $request->OPERATETRADE_ID;

    $update = Operatetrade::find($idref);
    $update->OPERATETRADE_STATUS = 'Cancel';
     
    $update->save(); 

    return redirect()->route('operate.genoperatetrade',['iduser'=>$iduser]);
}

function genoperatetrade_pdf(Request $request,$idref,$iduser)
{

    $infoorg = DB::table('info_org')->where('ORG_ID','=',1)
                ->leftJoin('hrd_person','hrd_person.ID','=','info_org.ORG_LEADER_ID')
                ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                ->first();

     $operate_trade = DB::table('operate_trade')
                ->leftjoin('operate_status','operate_status.OPERATE_STATUS_CODE','=','operate_trade.OPERATETRADE_STATUS')
                ->leftjoin('hrd_person','hrd_person.ID','=','operate_trade.OPERATETRADE_USERTRADE')
                ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                ->leftjoin('operate_job','operate_job.OPERATE_JOB_ID','=','operate_trade.OPERATETRADE_OPERATE_JOB')
                ->leftjoin('hrd_position','hrd_position.HR_POSITION_ID','=','operate_trade.OPERATETRADE_CHANG_POSITION')
                ->where('OPERATETRADE_ID','=',$idref)->first();

    $inforsuprequestsub = DB::table('supplies_request_sub')->where('SUPPLIES_REQUEST_ID','=',$idref)->get();
 
    $pdf = PDF::loadView('general_operate.genoperatetrade_pdf',[
        'infoorgs' => $infoorg,
        'operate_trades' => $operate_trade,
        'inforsuprequestsubs' => $inforsuprequestsub,
    ]);
    return @$pdf->stream();

}



//===========================  End  ==========================================/ 

public function infoindex(Request $request,$iduser)
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
     

    $operateindex1 =  DB::table('operate_index')
    ->where('operate_index.OPERATE_DEPARTMENT_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)
    ->where('operate_index.OPERATE_INDEX_MONTH','=',date('m'))
    ->where('operate_index.OPERATE_INDEX_YEAR','=',date('Y'))
    ->where('operate_index.OPERATE_TYPE','=','1')
    ->where('operate_index.OPERATE_STATUS','=','Allow')
    ->first();


    if($operateindex1 <> null){$idactivity =   $operateindex1->OPERATE_INDEX_ID; }else{$idactivity = '';}

    $infoactivity =  DB::table('operate_member')
    ->leftJoin('operate_activity','operate_member.OPERATE_MEMBER_PERSON_ID','=','operate_activity.OPERATE_ACTIVITY_PERSON_ID')
    ->where('operate_member.OPERATE_MEMBER_INDEX_ID','=',$idactivity)
    ->where('operate_activity.OPERATE_ACTIVITY_INDEX_ID','=',$idactivity)
    ->get();

   
        $operatejob = DB::table('operate_job')
        ->where('OPERATE_JOB_TYPE_ID','=','1')
        ->where('OPERATE_DEPARTMENT_SUB_SUB_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)->get();    
        
        $leavemonth = DB::table('leave_month')->get();

        $operatestatus = DB::table('operate_status')->get();
        $budgetyear = DB::table('budget_year')
        ->get();

        $searchyear_check = date('Y')+543;
        $searchmonth_check  = date('m');
        $searchtype_check  = '';
        
        $operatetype = DB::table('operate_type')->get();

    return view('general_operate.geninfooperateindex',[
        'inforpersonuser' => $inforpersonuser,
        'inforpersonuserid' => $inforpersonuserid,
        'infoactivitys' => $infoactivity, 
        'operatetypes' => $operatetype, 
        'leavemonths' => $leavemonth, 
        'operatestatus' => $operatestatus, 
        'searchyear_check' => $searchyear_check, 
        'searchmonth_check' => $searchmonth_check, 
        'searchtype_check' => $searchtype_check, 
        'budgetyears' => $budgetyear, 
        'operatejobs' => $operatejob        
        
    ]);
}


public function infoindexsearch(Request $request,$iduser)
{


    $OPERATE_MONTH = $request->OPERATE_MONTH;
    $OPERATE_INDEX_YEAR = $request->OPERATE_INDEX_YEAR;
    $SEND_TYPE = $request->SEND_TYPE;


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
     
   
   

    $operateindex1 =  DB::table('operate_index')
    ->where('operate_index.OPERATE_DEPARTMENT_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)
    ->where('operate_index.OPERATE_INDEX_MONTH','=',$OPERATE_MONTH)
    ->where('operate_index.OPERATE_INDEX_YEAR','=',$OPERATE_INDEX_YEAR-543)
    ->where('operate_index.OPERATE_TYPE','=',$SEND_TYPE)
    ->where('operate_index.OPERATE_STATUS','=','Allow')
    ->first();



    if($operateindex1 <> null){$idactivity =   $operateindex1->OPERATE_INDEX_ID; }else{$idactivity = '';}

    $infoactivity =  DB::table('operate_member')
    ->leftJoin('operate_activity','operate_member.OPERATE_MEMBER_PERSON_ID','=','operate_activity.OPERATE_ACTIVITY_PERSON_ID')
    ->where('operate_member.OPERATE_MEMBER_INDEX_ID','=',$idactivity)
    ->where('operate_activity.OPERATE_ACTIVITY_INDEX_ID','=',$idactivity)
    ->get();

   
        $operatejob = DB::table('operate_job')
        ->where('OPERATE_JOB_TYPE_ID','=',$SEND_TYPE)
        ->where('OPERATE_DEPARTMENT_SUB_SUB_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)
        ->get();

        
        $leavemonth = DB::table('leave_month')->get();

        $operatestatus = DB::table('operate_status')->get();

        $budgetyear = DB::table('budget_year')
        ->get();

        $searchyear_check = $OPERATE_INDEX_YEAR;
        $searchmonth_check  = $OPERATE_MONTH;
        $searchtype_check  = $SEND_TYPE;


        
        $operatetype = DB::table('operate_type')->get();

    return view('general_operate.geninfooperateindex',[
        'inforpersonuser' => $inforpersonuser,
        'inforpersonuserid' => $inforpersonuserid,
        'infoactivitys' => $infoactivity, 
        'operatetypes' => $operatetype, 
        'leavemonths' => $leavemonth, 
        'operatestatus' => $operatestatus, 
        'searchyear_check' => $searchyear_check, 
        'searchmonth_check' => $searchmonth_check, 
        'searchtype_check' => $searchtype_check, 
        'budgetyears' => $budgetyear, 
        'operatejobs' => $operatejob    
    ]);
}


    public function createoperate(Request $request,$iduser)
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

        $infodepartment = DB::table('hrd_department_sub_sub')->get();
        
        $infoorg = DB::table('info_org')
        ->leftJoin('hrd_person','hrd_person.ID','=','info_org.ORG_LEADER_ID')
        ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->first();


        $inforperson =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->where('hrd_person.HR_STATUS_ID', '<>', 5)
        ->where('hrd_person.HR_STATUS_ID', '<>', 6)
        ->where('hrd_person.HR_STATUS_ID', '<>', 7)
        ->where('hrd_person.HR_STATUS_ID', '<>', 8)
        ->get();

        $infotype = DB::table('operate_type')->get();

        $inforposition  =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')->get();

        $infobudget = DB::table('budget_year')->get();



        return view('general_operate.geninfooperate_add',[
            'inforpersonuser' => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid, 
            'infodepartments' => $infodepartment,
            'infoorg' => $infoorg,
            'inforpersons' => $inforperson,
            'inforpositions' => $inforposition,
            'infobudgets' => $infobudget,
            'infotypes' => $infotype,
            
        ]);
    }

    public function saveoperate(Request $request)
    {

        $addoperateindex = new Operateindex(); 
        $addoperateindex->OPERATE_DEPARTMENT_ID = $request->OPERATE_DEPARTMENT_ID;
        $addoperateindex->OPERATE_INDEX_MONTH = $request->OPERATE_INDEX_MONTH;
        $addoperateindex->OPERATE_INDEX_YEAR = $request->OPERATE_INDEX_YEAR;
        $addoperateindex->OPERATE_TYPE = $request->OPERATE_TYPE;

        //----------------------------------------------------
        $addoperateindex->OPERATE_ORGANIZER_ID = $request->OPERATE_ORGANIZER_ID;
        $operateorgnizername=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->where('hrd_person.ID','=',$request->OPERATE_ORGANIZER_ID)->first();
        $addoperateindex->OPERATE_ORGANIZER_NAME = $operateorgnizername->HR_PREFIX_NAME.''.$operateorgnizername->HR_FNAME.' '.$operateorgnizername->HR_LNAME;
        //----------------------------------------------------

        $addoperateindex->OPERATE_VERIFY_1_ID = $request->OPERATE_VERIFY_1_ID;
        $operateverify1=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->where('hrd_person.ID','=',$request->OPERATE_VERIFY_1_ID)->first();
        $addoperateindex->OPERATE_VERIFY_1_NAME = $operateverify1->HR_PREFIX_NAME.''.$operateverify1->HR_FNAME.' '.$operateverify1->HR_LNAME;
      //----------------------------------------------------

        $addoperateindex->OPERATE_VERIFY_2_ID = $request->OPERATE_VERIFY_2_ID;
        $operateverify2=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->where('hrd_person.ID','=',$request->OPERATE_VERIFY_2_ID)->first();
        $addoperateindex->OPERATE_VERIFY_2_NAME = $operateverify2->HR_PREFIX_NAME.''.$operateverify2->HR_FNAME.' '.$operateverify2->HR_LNAME;
    
        $addoperateindex->OPERATE_STATUS = 'Pending';

        $addoperateindex->save(); 

        //======================================================================

        $idmaxoperate = Operateindex::max('OPERATE_INDEX_ID'); 

            $MEMBER_ID = $request->MEMBER_ID;
            $number =count($MEMBER_ID);
            $count = 0;
            for($count = 0; $count < $number; $count++)
        {  

        $addactivity = new Operateactivity();
        $addactivity->OPERATE_ACTIVITY_INDEX_ID = $idmaxoperate;
        $addactivity->OPERATE_ACTIVITY_PERSON_ID = $MEMBER_ID[$count];
    
        $addactivity->save(); 
        

       $idmaxactivity = Operateactivity::max('OPERATE_ACTIVITY_ID'); 

       $id_person = $MEMBER_ID[$count];

       $inforpersonuser=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                               ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
                               ->where('hrd_person.ID','=',$id_person)->first();

       $add = new Operatemember();
       $add->OPERATE_MEMBER_INDEX_ID = $idmaxoperate;
       $add->OPERATE_MEMBER_PERSON_ID = $MEMBER_ID[$count];
       $add->OPERATE_MEMBER_PERSON_NAME = $inforpersonuser->HR_PREFIX_NAME.''.$inforpersonuser->HR_FNAME.' '.$inforpersonuser->HR_LNAME;
       $add->OPERATE_MEMBER_POSITION_ID = $inforpersonuser->HR_POSITION_ID;
       $add->OPERATE_MEMBER_POSITION_NAME = $inforpersonuser->POSITION_IN_WORK;
       $add->OPERATE_MEMBER_POSITION_NAME = $inforpersonuser->POSITION_IN_WORK;
       $add->OPERATE_MEMBER_ACTIVITY_ID = $idmaxactivity;
       
       $add->save(); 

  
    }

    return redirect()->route('operate.setoperate',['iduser'=>  $request->PERSON_ID]);

    }



    public function setoperate(Request $request,$iduser)
    {
        //$email = Auth::user()->email;
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

              $operateindex = DB::table('operate_index')
              ->leftJoin('operate_status','operate_index.OPERATE_STATUS','=','operate_status.OPERATE_STATUS_CODE')
              ->leftJoin('hrd_department_sub_sub','operate_index.OPERATE_DEPARTMENT_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
              ->leftJoin('operate_type','operate_index.OPERATE_TYPE','=','operate_type.OPERATE_TYPE_ID')
              ->where(function($q){
                $q->where('OPERATE_STATUS','=','Pending');
    
            })
              ->where('HR_DEPARTMENT_SUB_SUB_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)
              ->orderby('OPERATE_INDEX_ID','desc') 
              ->get();

              $leavemonth = DB::table('leave_month')->get();

              $operatestatus = DB::table('operate_status')->get();

              $budgetyear = DB::table('budget_year')
              ->orderBy('LEAVE_YEAR_ID', 'desc')
              ->get();
             

              $searchmonth = date('m');
              $searchyear = date('Y');
              $status = 'Pending';
              $search = '';

        return view('general_operate.geninfooperate_set',[
            'inforpersonuser' => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid, 
            'operateindexs' => $operateindex,
            'status_check' => $status,
             'search' => $search,
             'searchmonth_check' => $searchmonth,
             'searchyear_check' => $searchyear,
             'leavemonths' => $leavemonth,
             'operatestatuss' => $operatestatus,
             'budgetyears' => $budgetyear

           
            
        ]);
    }


    

    public function setactivity(Request $request,$idactivity,$iduser)
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

              $infoactivity =  DB::table('operate_member')
              ->leftJoin('operate_activity','operate_member.OPERATE_MEMBER_PERSON_ID','=','operate_activity.OPERATE_ACTIVITY_PERSON_ID')
              ->where('operate_member.OPERATE_MEMBER_INDEX_ID','=',$idactivity)
              ->where('operate_activity.OPERATE_ACTIVITY_INDEX_ID','=',$idactivity)
              ->get();
              
              $infooper= DB::table('operate_index')
              ->leftJoin('hrd_department_sub_sub','operate_index.OPERATE_DEPARTMENT_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
              ->leftJoin('operate_type','operate_type.OPERATE_TYPE_ID','=','operate_index.OPERATE_TYPE')
              ->where('OPERATE_INDEX_ID','=',$idactivity)->first();

              $operatejob = DB::table('operate_job')
              ->where('OPERATE_DEPARTMENT_SUB_SUB_ID','=', $infooper->OPERATE_DEPARTMENT_ID)
              ->where('OPERATE_JOB_TYPE_ID','=', $infooper->OPERATE_TYPE)
              ->get();

             
        return view('general_operate.geninfooperate_setactivity',[
            'inforpersonuser' => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid, 
            'infoactivitys' => $infoactivity,
            'operatejobs' => $operatejob,
            'infooper' => $infooper,
            'idactivity' => $idactivity,
            
            
        ]);
    }
    

    public function updateactivity(Request $request)
    {
       
        
     
        $OPERATE_INDEX_ID = $request->OPERATE_INDEX_ID;
        $PERSON_ID = $request->PERSON_ID;

        Operateactivity::where('OPERATE_ACTIVITY_INDEX_ID','=',$OPERATE_INDEX_ID)->delete(); 

         if($request->OPERATE_MEMBER_PERSON_ID[0] != '' || $request->OPERATE_MEMBER_PERSON_ID[0] != null){

         $OPERATE_MEMBER_PERSON_ID = $request->OPERATE_MEMBER_PERSON_ID;

       
         $DATE_1 = $request->DATE_1;
         $DATE_2 = $request->DATE_2;
         $DATE_3 = $request->DATE_3;
         $DATE_4 = $request->DATE_4;
         $DATE_5 = $request->DATE_5;
         $DATE_6 = $request->DATE_6;
         $DATE_7 = $request->DATE_7;
         $DATE_8 = $request->DATE_8;
         $DATE_9 = $request->DATE_9;
         $DATE_10 = $request->DATE_10;
         $DATE_11 = $request->DATE_11;
         $DATE_12 = $request->DATE_12;
         $DATE_13 = $request->DATE_13;
         $DATE_14 = $request->DATE_14;
         $DATE_15 = $request->DATE_15;
         $DATE_16 = $request->DATE_16;
         $DATE_17 = $request->DATE_17;
         $DATE_18 = $request->DATE_18;
         $DATE_19 = $request->DATE_19;
         $DATE_20 = $request->DATE_20;
         $DATE_21 = $request->DATE_21;
         $DATE_22 = $request->DATE_22;
         $DATE_23 = $request->DATE_23;
         $DATE_24 = $request->DATE_24;
         $DATE_25 = $request->DATE_25;
         $DATE_26 = $request->DATE_26;
         $DATE_27 = $request->DATE_27;
         $DATE_28 = $request->DATE_28;
         $DATE_29 = $request->DATE_29;
         $DATE_30 = $request->DATE_30;
         $DATE_31 = $request->DATE_31;
        

         $number =count($OPERATE_MEMBER_PERSON_ID);
         
         
         $count = 0;
         for($count = 0; $count < $number; $count++)
         {  
    
           
            
            $add = new Operateactivity();
            $add->OPERATE_ACTIVITY_PERSON_ID = $OPERATE_MEMBER_PERSON_ID[$count];
            $add->DATE_1 = $DATE_1[$count];
            $add->DATE_2 = $DATE_2[$count];
            $add->DATE_3 = $DATE_3[$count];
            $add->DATE_4 = $DATE_4[$count];
            $add->DATE_5 = $DATE_5[$count];
            $add->DATE_6 = $DATE_6[$count];
            $add->DATE_7 = $DATE_7[$count];
            $add->DATE_8 = $DATE_8[$count];
            $add->DATE_9 = $DATE_9[$count];
            $add->DATE_10 = $DATE_10[$count];
            $add->DATE_11 = $DATE_11[$count];
            $add->DATE_12 = $DATE_12[$count];
            $add->DATE_13 = $DATE_13[$count];
            $add->DATE_14 = $DATE_14[$count];
            $add->DATE_15 = $DATE_15[$count];
            $add->DATE_16 = $DATE_16[$count];
            $add->DATE_17 = $DATE_17[$count];
            $add->DATE_18 = $DATE_18[$count];
            $add->DATE_19 = $DATE_19[$count];
            $add->DATE_20 = $DATE_20[$count];
            $add->DATE_21 = $DATE_21[$count];
            $add->DATE_22 = $DATE_22[$count];
            $add->DATE_23 = $DATE_23[$count];
            $add->DATE_24 = $DATE_24[$count];
            $add->DATE_25 = $DATE_25[$count];
            $add->DATE_26 = $DATE_26[$count];
            $add->DATE_27 = $DATE_27[$count];
            $add->DATE_28 = $DATE_28[$count];
            $add->DATE_29 = $DATE_29[$count];
            $add->DATE_30 = $DATE_30[$count];
            $add->DATE_31 = $DATE_31[$count];
            $add->OPERATE_ACTIVITY_INDEX_ID   = $OPERATE_INDEX_ID;
          
            $add->save(); 

         }

        }

          



        return redirect()->route('operate.setoperate',['iduser'=>  $PERSON_ID]);




    }
//========================================ตรวจสอบ=============================
public function operateversearch(Request $request,$iduser)
{
      //------เริ่มการค้นหา------------
      $searchmonth = $request->OPERATE_MONTH;
      $searchyear = $request->get('OPERATE_INDEX_YEAR')-543;
      $status = $request->SEND_STATUS;
      $search = $request->get('search'); 

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



      if($search==''){
          $search="";
      }
    if($searchmonth == '' && $searchyear == '' && $status=='' ){

        $operateindex = DB::table('operate_index')
        ->leftJoin('operate_status','operate_index.OPERATE_STATUS','=','operate_status.OPERATE_STATUS_CODE')
        ->leftJoin('hrd_department_sub_sub','operate_index.OPERATE_DEPARTMENT_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->leftJoin('operate_type','operate_index.OPERATE_TYPE','=','operate_type.OPERATE_TYPE_ID')
        ->where(function($q) use ($search){                   
            $q->where('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');  
            $q->orwhere('OPERATE_ORGANIZER_NAME','like','%'.$search.'%');              
        })              
        ->orderby('OPERATE_INDEX_ID','desc')         
        ->get();

    }elseif($searchmonth != '' && $searchyear == '' && $status ==''){
       
        $operateindex = DB::table('operate_index')
        ->leftJoin('operate_status','operate_index.OPERATE_STATUS','=','operate_status.OPERATE_STATUS_CODE')
        ->leftJoin('hrd_department_sub_sub','operate_index.OPERATE_DEPARTMENT_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->leftJoin('operate_type','operate_index.OPERATE_TYPE','=','operate_type.OPERATE_TYPE_ID')
        ->where('operate_index.OPERATE_INDEX_MONTH','=',$searchmonth)
        ->where(function($q) use ($search){                   
            $q->where('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');  
            $q->orwhere('OPERATE_ORGANIZER_NAME','like','%'.$search.'%');              
        })              
        ->orderby('OPERATE_INDEX_ID','desc')         
        ->get();

    }else if($searchmonth != '' && $searchyear != '' && $status ==''){
       
        $operateindex = DB::table('operate_index')
        ->leftJoin('operate_status','operate_index.OPERATE_STATUS','=','operate_status.OPERATE_STATUS_CODE')
        ->leftJoin('hrd_department_sub_sub','operate_index.OPERATE_DEPARTMENT_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->leftJoin('operate_type','operate_index.OPERATE_TYPE','=','operate_type.OPERATE_TYPE_ID')
        ->where('operate_index.OPERATE_INDEX_MONTH','=',$searchmonth)
        ->where('operate_index.OPERATE_INDEX_YEAR','=',$searchyear)
        ->where(function($q) use ($search){                   
            $q->where('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');  
            $q->orwhere('OPERATE_ORGANIZER_NAME','like','%'.$search.'%');              
        })              
        ->orderby('OPERATE_INDEX_ID','desc')         
        ->get();

    }elseif($searchmonth != '' && $searchyear != '' && $status !=''){
       
        $operateindex = DB::table('operate_index')
        ->leftJoin('operate_status','operate_index.OPERATE_STATUS','=','operate_status.OPERATE_STATUS_CODE')
        ->leftJoin('hrd_department_sub_sub','operate_index.OPERATE_DEPARTMENT_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->leftJoin('operate_type','operate_index.OPERATE_TYPE','=','operate_type.OPERATE_TYPE_ID')
        ->where('operate_index.OPERATE_INDEX_MONTH','=',$searchmonth)
        ->where('operate_index.OPERATE_INDEX_YEAR','=',$searchyear)
        ->where('operate_index.OPERATE_STATUS','=',$status)
        ->where(function($q) use ($search){                   
            $q->where('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');  
            $q->orwhere('OPERATE_ORGANIZER_NAME','like','%'.$search.'%');              
        })              
        ->orderby('OPERATE_INDEX_ID','desc')         
        ->get(); 

    }elseif($searchmonth == '' && $searchyear == '' && $status !=''){
      
        $operateindex = DB::table('operate_index')
        ->leftJoin('operate_status','operate_index.OPERATE_STATUS','=','operate_status.OPERATE_STATUS_CODE')
        ->leftJoin('hrd_department_sub_sub','operate_index.OPERATE_DEPARTMENT_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->leftJoin('operate_type','operate_index.OPERATE_TYPE','=','operate_type.OPERATE_TYPE_ID')
        ->where('operate_index.OPERATE_STATUS','=',$status)
        ->where(function($q) use ($search){                   
            $q->where('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');  
            $q->orwhere('OPERATE_ORGANIZER_NAME','like','%'.$search.'%');              
        })              
        ->orderby('OPERATE_INDEX_ID','desc')         
        ->get(); 
        
    }elseif($searchmonth == '' && $searchyear != '' && $status ==''){
       
        $operateindex = DB::table('operate_index')
        ->leftJoin('operate_status','operate_index.OPERATE_STATUS','=','operate_status.OPERATE_STATUS_CODE')
        ->leftJoin('hrd_department_sub_sub','operate_index.OPERATE_DEPARTMENT_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID') 
        ->leftJoin('operate_type','operate_index.OPERATE_TYPE','=','operate_type.OPERATE_TYPE_ID')
        ->where('operate_index.OPERATE_INDEX_YEAR','=',$searchyear)
        ->where(function($q) use ($search){                   
            $q->where('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');  
            $q->orwhere('OPERATE_ORGANIZER_NAME','like','%'.$search.'%');              
        })              
        ->orderby('OPERATE_INDEX_ID','desc')         
        ->get(); 

              
     }else if($searchmonth == '' && $searchyear != '' && $status !=''){
        
        $operateindex = DB::table('operate_index')
        ->leftJoin('operate_status','operate_index.OPERATE_STATUS','=','operate_status.OPERATE_STATUS_CODE')
        ->leftJoin('hrd_department_sub_sub','operate_index.OPERATE_DEPARTMENT_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->leftJoin('operate_type','operate_index.OPERATE_TYPE','=','operate_type.OPERATE_TYPE_ID')
        ->where('operate_index.OPERATE_INDEX_YEAR','=',$searchyear)
         ->where('operate_index.OPERATE_STATUS','=',$status)
        ->where(function($q) use ($search){                   
            $q->where('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');  
            $q->orwhere('OPERATE_ORGANIZER_NAME','like','%'.$search.'%');              
        })              
        ->orderby('OPERATE_INDEX_ID','desc')         
        ->get();

    
    }else if($searchmonth != '' && $searchyear == '' && $status !==''){            
       
        $operateindex = DB::table('operate_index')
        ->leftJoin('operate_status','operate_index.OPERATE_STATUS','=','operate_status.OPERATE_STATUS_CODE')
        ->leftJoin('hrd_department_sub_sub','operate_index.OPERATE_DEPARTMENT_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->leftJoin('operate_type','operate_index.OPERATE_TYPE','=','operate_type.OPERATE_TYPE_ID')
        ->where('operate_index.OPERATE_INDEX_MONTH','=',$searchmonth)
         ->where('operate_index.OPERATE_STATUS','=',$status)
        ->where(function($q) use ($search){                   
            $q->where('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');  
            $q->orwhere('OPERATE_ORGANIZER_NAME','like','%'.$search.'%');              
        })              
        ->orderby('OPERATE_INDEX_ID','desc')         
        ->get();
       
    }
  
   
    $operatejob = DB::table('operate_job')->get();
    
    $leavemonth = DB::table('leave_month')->get();
    $operatestatus = DB::table('operate_status')->get();

    $budgetyear = DB::table('budget_year')
    ->get();
   
    $searchyear_check = $searchyear+543;
  
    return view('general_operate.geninfooperate_ver',[
        'inforpersonuser' => $inforpersonuser,
        'inforpersonuserid' => $inforpersonuserid,
        'operateindexs' => $operateindex, 
        'operatejobs' => $operatejob ,
        'status_check' => $status , 
        'search' => $search , 
        'searchmonth_check' => $searchmonth ,        
        'searchyear_check' => $searchyear_check,
       'leavemonths' => $leavemonth,
       'operatestatuss' => $operatestatus,
       'budgetyears' => $budgetyear
       
        
    ]);
}

public function veroperate(Request $request,$iduser)
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

          $operateindex = DB::table('operate_index')
          ->leftJoin('operate_status','operate_index.OPERATE_STATUS','=','operate_status.OPERATE_STATUS_CODE')
          ->leftJoin('hrd_department_sub_sub','operate_index.OPERATE_DEPARTMENT_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
          ->leftJoin('operate_type','operate_index.OPERATE_TYPE','=','operate_type.OPERATE_TYPE_ID')
          ->where(function($q){
            $q->where('OPERATE_STATUS','=','Approve');

        })
          ->get();

          $leavemonth = DB::table('leave_month')->get();
          $operatestatus = DB::table('operate_status')->get();
          $budgetyear = DB::table('budget_year')
          ->orderBy('LEAVE_YEAR_ID', 'desc')
          ->get();
         

          $searchmonth = date('m');
          $searchyear = date('Y');
          $status = 'Approve';
          $search = '';

    return view('general_operate.geninfooperate_ver',[
        'inforpersonuser' => $inforpersonuser,
        'inforpersonuserid' => $inforpersonuserid, 
        'operateindexs' => $operateindex,
        'status_check' => $status,
        'search' => $search,
        'searchmonth_check' => $searchmonth,
        'searchyear_check' => $searchyear,
        'leavemonths' => $leavemonth,
        'operatestatuss' => $operatestatus,
        'budgetyears' => $budgetyear

        
    ]);
}

public function vercheckoperate(Request $request,$id,$iduser)
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

          $operateindexinfo = DB::table('operate_index')
          ->leftJoin('operate_status','operate_index.OPERATE_STATUS','=','operate_status.OPERATE_STATUS_CODE')
          ->leftJoin('hrd_department_sub_sub','operate_index.OPERATE_DEPARTMENT_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
          ->where('OPERATE_INDEX_ID','=',$id)
          ->first();


    return view('general_operate.geninfooperate_vercheck',[
        'inforpersonuser' => $inforpersonuser,
        'inforpersonuserid' => $inforpersonuserid, 
        'operateindexinfo' => $operateindexinfo,
        'infooperateid' => $id
       
        
    ]);
}


public function updatever(Request $request)
{
    $id = $request->ID; 

    $check =  $request->SUBMIT; 

    if($check == 'approved'){
      $statuscode = 'Verify';
    }else{
      $statuscode = 'Disverify';
    }


      $updatever = Operateindex::find($id);
      $updatever->OPERATE_VERIFY_ID = $request->OPERATE_VERIFY_ID;
      $updatever->OPERATE_VERIFY_COMMENT = $request->OPERATE_VERIFY_COMMENT;
      $updatever->OPERATE_STATUS = $statuscode; 
//-----------------------------------------------------
      $updatever->save();

          return redirect()->route('operate.veroperate',['iduser'=>  $request->OPERATE_VERIFY_ID]);

}


//========================================อนุมัติ=============================

public function operateappsearch(Request $request,$iduser)
{
      //------เริ่มการค้นหา------------
      $searchmonth = $request->OPERATE_MONTH;
      $searchyear = $request->get('OPERATE_INDEX_YEAR')-543;
      $status = $request->SEND_STATUS;
      $search = $request->get('search'); 

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



      if($search==''){
          $search="";
      }
    if($searchmonth == '' && $searchyear == '' && $status=='' ){

        $operateindex = DB::table('operate_index')
        ->leftJoin('operate_status','operate_index.OPERATE_STATUS','=','operate_status.OPERATE_STATUS_CODE')
        ->leftJoin('hrd_department_sub_sub','operate_index.OPERATE_DEPARTMENT_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->leftJoin('operate_type','operate_index.OPERATE_TYPE','=','operate_type.OPERATE_TYPE_ID')
        ->where(function($q) use ($search){                   
            $q->where('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');  
            $q->orwhere('OPERATE_ORGANIZER_NAME','like','%'.$search.'%');              
        })              
        ->orderby('OPERATE_INDEX_ID','desc')         
        ->get();

    }elseif($searchmonth != '' && $searchyear == '' && $status ==''){
       
        $operateindex = DB::table('operate_index')
        ->leftJoin('operate_status','operate_index.OPERATE_STATUS','=','operate_status.OPERATE_STATUS_CODE')
        ->leftJoin('hrd_department_sub_sub','operate_index.OPERATE_DEPARTMENT_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->leftJoin('operate_type','operate_index.OPERATE_TYPE','=','operate_type.OPERATE_TYPE_ID')
        ->where('operate_index.OPERATE_INDEX_MONTH','=',$searchmonth)
        ->where(function($q) use ($search){                   
            $q->where('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');  
            $q->orwhere('OPERATE_ORGANIZER_NAME','like','%'.$search.'%');              
        })              
        ->orderby('OPERATE_INDEX_ID','desc')         
        ->get();

    }else if($searchmonth != '' && $searchyear != '' && $status ==''){
       
        $operateindex = DB::table('operate_index')
        ->leftJoin('operate_status','operate_index.OPERATE_STATUS','=','operate_status.OPERATE_STATUS_CODE')
        ->leftJoin('hrd_department_sub_sub','operate_index.OPERATE_DEPARTMENT_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->leftJoin('operate_type','operate_index.OPERATE_TYPE','=','operate_type.OPERATE_TYPE_ID')
        ->where('operate_index.OPERATE_INDEX_MONTH','=',$searchmonth)
        ->where('operate_index.OPERATE_INDEX_YEAR','=',$searchyear)
        ->where(function($q) use ($search){                   
            $q->where('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');  
            $q->orwhere('OPERATE_ORGANIZER_NAME','like','%'.$search.'%');              
        })              
        ->orderby('OPERATE_INDEX_ID','desc')         
        ->get();

    }elseif($searchmonth != '' && $searchyear != '' && $status !=''){
       
        $operateindex = DB::table('operate_index')
        ->leftJoin('operate_status','operate_index.OPERATE_STATUS','=','operate_status.OPERATE_STATUS_CODE')
        ->leftJoin('hrd_department_sub_sub','operate_index.OPERATE_DEPARTMENT_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->leftJoin('operate_type','operate_index.OPERATE_TYPE','=','operate_type.OPERATE_TYPE_ID')
        ->where('operate_index.OPERATE_INDEX_MONTH','=',$searchmonth)
        ->where('operate_index.OPERATE_INDEX_YEAR','=',$searchyear)
        ->where('operate_index.OPERATE_STATUS','=',$status)
        ->where(function($q) use ($search){                   
            $q->where('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');  
            $q->orwhere('OPERATE_ORGANIZER_NAME','like','%'.$search.'%');              
        })              
        ->orderby('OPERATE_INDEX_ID','desc')         
        ->get(); 

    }elseif($searchmonth == '' && $searchyear == '' && $status !=''){
      
        $operateindex = DB::table('operate_index')
        ->leftJoin('operate_status','operate_index.OPERATE_STATUS','=','operate_status.OPERATE_STATUS_CODE')
        ->leftJoin('hrd_department_sub_sub','operate_index.OPERATE_DEPARTMENT_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->leftJoin('operate_type','operate_index.OPERATE_TYPE','=','operate_type.OPERATE_TYPE_ID')
        ->where('operate_index.OPERATE_STATUS','=',$status)
        ->where(function($q) use ($search){                   
            $q->where('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');  
            $q->orwhere('OPERATE_ORGANIZER_NAME','like','%'.$search.'%');              
        })              
        ->orderby('OPERATE_INDEX_ID','desc')         
        ->get(); 
        
    }elseif($searchmonth == '' && $searchyear != '' && $status ==''){
       
        $operateindex = DB::table('operate_index')
        ->leftJoin('operate_status','operate_index.OPERATE_STATUS','=','operate_status.OPERATE_STATUS_CODE')
        ->leftJoin('hrd_department_sub_sub','operate_index.OPERATE_DEPARTMENT_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID') 
        ->leftJoin('operate_type','operate_index.OPERATE_TYPE','=','operate_type.OPERATE_TYPE_ID')
        ->where('operate_index.OPERATE_INDEX_YEAR','=',$searchyear)
        ->where(function($q) use ($search){                   
            $q->where('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');  
            $q->orwhere('OPERATE_ORGANIZER_NAME','like','%'.$search.'%');              
        })              
        ->orderby('OPERATE_INDEX_ID','desc')         
        ->get(); 

              
     }else if($searchmonth == '' && $searchyear != '' && $status !=''){
        
        $operateindex = DB::table('operate_index')
        ->leftJoin('operate_status','operate_index.OPERATE_STATUS','=','operate_status.OPERATE_STATUS_CODE')
        ->leftJoin('hrd_department_sub_sub','operate_index.OPERATE_DEPARTMENT_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->leftJoin('operate_type','operate_index.OPERATE_TYPE','=','operate_type.OPERATE_TYPE_ID')
        ->where('operate_index.OPERATE_INDEX_YEAR','=',$searchyear)
         ->where('operate_index.OPERATE_STATUS','=',$status)
        ->where(function($q) use ($search){                   
            $q->where('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');  
            $q->orwhere('OPERATE_ORGANIZER_NAME','like','%'.$search.'%');              
        })              
        ->orderby('OPERATE_INDEX_ID','desc')         
        ->get();

    
    }else if($searchmonth != '' && $searchyear == '' && $status !==''){            
       
        $operateindex = DB::table('operate_index')
        ->leftJoin('operate_status','operate_index.OPERATE_STATUS','=','operate_status.OPERATE_STATUS_CODE')
        ->leftJoin('hrd_department_sub_sub','operate_index.OPERATE_DEPARTMENT_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->leftJoin('operate_type','operate_index.OPERATE_TYPE','=','operate_type.OPERATE_TYPE_ID') 
        ->where('operate_index.OPERATE_INDEX_MONTH','=',$searchmonth)
         ->where('operate_index.OPERATE_STATUS','=',$status)
        ->where(function($q) use ($search){                   
            $q->where('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');  
            $q->orwhere('OPERATE_ORGANIZER_NAME','like','%'.$search.'%');              
        })              
        ->orderby('OPERATE_INDEX_ID','desc')         
        ->get();
       
    }
  
   
    $operatejob = DB::table('operate_job')->get();
    
    $leavemonth = DB::table('leave_month')->get();
    $operatestatus = DB::table('operate_status')->get();

    $budgetyear = DB::table('budget_year')
    ->get();
   
    $searchyear_check = $searchyear+543;
  
    return view('general_operate.geninfooperate_app',[
        'inforpersonuser' => $inforpersonuser,
        'inforpersonuserid' => $inforpersonuserid,
        'operateindexs' => $operateindex, 
        'operatejobs' => $operatejob ,
        'status_check' => $status , 
        'search' => $search , 
        'searchmonth_check' => $searchmonth ,        
        'searchyear_check' => $searchyear_check,
       'leavemonths' => $leavemonth,
       'operatestatuss' => $operatestatus,
       'budgetyears' => $budgetyear
       
        
    ]);
}



public function appoperate(Request $request,$iduser)
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

          $operateindex = DB::table('operate_index')
          ->leftJoin('operate_status','operate_index.OPERATE_STATUS','=','operate_status.OPERATE_STATUS_CODE')
          ->leftJoin('hrd_department_sub_sub','operate_index.OPERATE_DEPARTMENT_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
          ->leftJoin('operate_type','operate_index.OPERATE_TYPE','=','operate_type.OPERATE_TYPE_ID')
          ->where(function($q){
            $q->where('OPERATE_STATUS','=','Verify');

        })
          ->get();

 
          $leavemonth = DB::table('leave_month')

          ->get();
          $operatestatus = DB::table('operate_status')->get();
          $budgetyear = DB::table('budget_year')
          ->orderBy('LEAVE_YEAR_ID', 'desc')
          ->get();
         

          $searchmonth = date('m');
          $searchyear = date('Y');
          $status = 'Verify';
          $search = '';

      

    return view('general_operate.geninfooperate_app',[
        'inforpersonuser' => $inforpersonuser,
        'inforpersonuserid' => $inforpersonuserid, 
        'operateindexs' => $operateindex,
        'status_check' => $status,
        'search' => $search,
        'searchmonth_check' => $searchmonth,
        'searchyear_check' => $searchyear,
        'leavemonths' => $leavemonth,
        'operatestatuss' => $operatestatus,
        'budgetyears' => $budgetyear,
   
       
        
    ]);
}


public function appcheckoperate(Request $request,$id,$iduser)
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

          $operateindexinfo = DB::table('operate_index')
          ->leftJoin('operate_status','operate_index.OPERATE_STATUS','=','operate_status.OPERATE_STATUS_CODE')
          ->leftJoin('hrd_department_sub_sub','operate_index.OPERATE_DEPARTMENT_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
          ->where('OPERATE_INDEX_ID','=',$id)
          ->first();


    return view('general_operate.geninfooperate_appcheck',[
        'inforpersonuser' => $inforpersonuser,
        'inforpersonuserid' => $inforpersonuserid, 
        'operateindexinfo' => $operateindexinfo,
        'infooperateid' => $id
       
        
    ]);
}


public function updateapp(Request $request)
{
    $id = $request->ID; 

    $check =  $request->SUBMIT; 

    if($check == 'approved'){
      $statuscode = 'Allow';
    }else{
      $statuscode = 'Disallow';
    }


      $updatever = Operateindex::find($id);
      $updatever->OPERATE_APPROV_ID = $request->OPERATE_APPROV_ID;
      $updatever->OPERATE_APPROV_COMMENT = $request->OPERATE_APPROV_COMMENT;
      $updatever->OPERATE_STATUS = $statuscode; 
//-----------------------------------------------------
      $updatever->save();
      
          return redirect()->route('operate.appoperate',['iduser'=>  $request->OPERATE_APPROV_ID]);

}
   //=========================================excel=======================

    public function excelactivity(Request $request,$idactivity,$iduser)
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

 

              $operateindexinfo = DB::table('operate_index')
              ->leftJoin('operate_status','operate_index.OPERATE_STATUS','=','operate_status.OPERATE_STATUS_CODE')
              ->leftJoin('hrd_department_sub_sub','operate_index.OPERATE_DEPARTMENT_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
              ->where('OPERATE_INDEX_ID','=',$idactivity)
              ->first();
              


              $infoactivity =  DB::table('operate_member')
              ->leftJoin('operate_activity','operate_member.OPERATE_MEMBER_PERSON_ID','=','operate_activity.OPERATE_ACTIVITY_PERSON_ID')
              ->where('operate_member.OPERATE_MEMBER_INDEX_ID','=',$idactivity)
              ->where('operate_activity.OPERATE_ACTIVITY_INDEX_ID','=',$idactivity)
              ->get();
              
              $infooper= DB::table('operate_index')
              ->leftJoin('hrd_department_sub_sub','operate_index.OPERATE_DEPARTMENT_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
              ->leftJoin('operate_type','operate_type.OPERATE_TYPE_ID','=','operate_index.OPERATE_TYPE')
              ->where('OPERATE_INDEX_ID','=',$idactivity)->first();

              $operatejob = DB::table('operate_job')
              ->where('OPERATE_DEPARTMENT_SUB_SUB_ID','=', $infooper->OPERATE_DEPARTMENT_ID)
              ->where('OPERATE_JOB_TYPE_ID','=', $infooper->OPERATE_TYPE)
              ->get();


         
              $infooper= DB::table('operate_index')
              ->leftJoin('hrd_department_sub_sub','operate_index.OPERATE_DEPARTMENT_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
              ->leftJoin('operate_type','operate_type.OPERATE_TYPE_ID','=','operate_index.OPERATE_TYPE')
              ->where('OPERATE_INDEX_ID','=',$idactivity)->first();
              

        return view('general_operate.exceloperate',[
            'inforpersonuser' => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid, 
            'infoactivitys' => $infoactivity,
            'operatejobs' => $operatejob,
            'infooper' => $infooper,
            'operateindexinfo' => $operateindexinfo
            
        ]);
    }

    public function excelactivity_ot(Request $request,$idactivity,$iduser)
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

              $infoactivity =  DB::table('operate_member')
              ->leftJoin('operate_activity','operate_member.OPERATE_MEMBER_PERSON_ID','=','operate_activity.OPERATE_ACTIVITY_PERSON_ID')
              ->where('OPERATE_MEMBER_INDEX_ID','=',$idactivity)
              ->get();

              $operateindexinfo = DB::table('operate_index')
              ->leftJoin('operate_status','operate_index.OPERATE_STATUS','=','operate_status.OPERATE_STATUS_CODE')
              ->leftJoin('hrd_department_sub_sub','operate_index.OPERATE_DEPARTMENT_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
              ->where('OPERATE_INDEX_ID','=',$idactivity)
              ->first();
              

              $operatejob = DB::table('operate_job')->get();

        return view('general_operate.exceloperate_ot',[
            'inforpersonuser' => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid, 
            'infoactivitys' => $infoactivity,
            'operatejobs' => $operatejob,
            'operateindexinfo' => $operateindexinfo
            
        ]);
    }
    //================================แก้ไข==================================================

    public function editoperate(Request $request,$id,$iduser)
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

        $infodepartment = DB::table('hrd_department_sub_sub')->get();
        $infoorg = DB::table('info_org')
        ->leftJoin('hrd_person','hrd_person.ID','=','info_org.ORG_LEADER_ID')
        ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->first();

        $inforperson =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->where('hrd_person.HR_STATUS_ID', '<>', 5)
        ->where('hrd_person.HR_STATUS_ID', '<>', 6)
        ->where('hrd_person.HR_STATUS_ID', '<>', 7)
        ->where('hrd_person.HR_STATUS_ID', '<>', 8)
        ->get();

        $infotype = DB::table('operate_type')->get();
       
        $inforposition  =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')->get();


        $infooperate=  Operateindex::leftJoin('hrd_person','hrd_person.ID','=','operate_index.OPERATE_ORGANIZER_ID')
                        ->where('OPERATE_INDEX_ID','=',$id)->first();

        $infooperatemember=  Operatemember::leftJoin('operate_activity','operate_member.OPERATE_MEMBER_ACTIVITY_ID','=','operate_activity.OPERATE_ACTIVITY_ID')
                             ->where('OPERATE_MEMBER_INDEX_ID','=',$id)->get();
      
         $infobudget = DB::table('budget_year')->get();


        return view('general_operate.geninfooperate_edit',[
            'inforpersonuser' => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid, 
            'infodepartments' => $infodepartment,
            'infoorg' => $infoorg,
            'inforpersons' => $inforperson,
            'inforpositions' => $inforposition,
            'infooperate' => $infooperate,
            'infooperatemembers' => $infooperatemember,
            'infobudgets' => $infobudget,
            'infotypes' => $infotype,
            
        ]);
    }

    public function updateoperate(Request $request)
    {
        $id = $request->OPERATE_INDEX_ID;
        $addoperateindex = Operateindex::find($id); 
        $addoperateindex->OPERATE_DEPARTMENT_ID = $request->OPERATE_DEPARTMENT_ID;
        $addoperateindex->OPERATE_INDEX_MONTH = $request->OPERATE_INDEX_MONTH;
        $addoperateindex->OPERATE_INDEX_YEAR = $request->OPERATE_INDEX_YEAR;
        $addoperateindex->OPERATE_TYPE = $request->OPERATE_TYPE;
        //----------------------------------------------------
        $addoperateindex->OPERATE_ORGANIZER_ID = $request->OPERATE_ORGANIZER_ID;
        $operateorgnizername=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->where('hrd_person.ID','=',$request->OPERATE_ORGANIZER_ID)->first();
        $addoperateindex->OPERATE_ORGANIZER_NAME = $operateorgnizername->HR_PREFIX_NAME.''.$operateorgnizername->HR_FNAME.' '.$operateorgnizername->HR_LNAME;
        //----------------------------------------------------

        $addoperateindex->OPERATE_VERIFY_1_ID = $request->OPERATE_VERIFY_1_ID;
        $operateverify1=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->where('hrd_person.ID','=',$request->OPERATE_VERIFY_1_ID)->first();
        $addoperateindex->OPERATE_VERIFY_1_NAME = $operateverify1->HR_PREFIX_NAME.''.$operateverify1->HR_FNAME.' '.$operateverify1->HR_LNAME;
      //----------------------------------------------------

        $addoperateindex->OPERATE_VERIFY_2_ID = $request->OPERATE_VERIFY_2_ID;
        $operateverify2=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->where('hrd_person.ID','=',$request->OPERATE_VERIFY_2_ID)->first();
        $addoperateindex->OPERATE_VERIFY_2_NAME = $operateverify2->HR_PREFIX_NAME.''.$operateverify2->HR_FNAME.' '.$operateverify2->HR_LNAME;
    
        $addoperateindex->OPERATE_STATUS = 'Pending';

        $addoperateindex->save(); 

    //======================================================================
    Operateactivity::where('OPERATE_ACTIVITY_INDEX_ID','=',$id)->delete(); 
    Operatemember::where('OPERATE_MEMBER_INDEX_ID','=',$id)->delete(); 

    //=======================================================================

    $idindex = $id; 

    $MEMBER_ID = $request->MEMBER_ID;
    $DATE_1 = $request->DATE_1;
    $DATE_2 = $request->DATE_2;
    $DATE_3 = $request->DATE_3;
    $DATE_4 = $request->DATE_4;
    $DATE_5 = $request->DATE_5;
    $DATE_6 = $request->DATE_6;
    $DATE_7 = $request->DATE_7;
    $DATE_8 = $request->DATE_8;
    $DATE_9 = $request->DATE_9;
    $DATE_10 = $request->DATE_10;
    $DATE_11 = $request->DATE_11;
    $DATE_12 = $request->DATE_12;
    $DATE_13 = $request->DATE_13;
    $DATE_14 = $request->DATE_14;
    $DATE_15 = $request->DATE_15;
    $DATE_16 = $request->DATE_16;
    $DATE_17 = $request->DATE_17;
    $DATE_18 = $request->DATE_18;
    $DATE_19 = $request->DATE_19;
    $DATE_20 = $request->DATE_20;
    $DATE_21 = $request->DATE_21;
    $DATE_22 = $request->DATE_22;
    $DATE_23 = $request->DATE_23;
    $DATE_24 = $request->DATE_24;
    $DATE_25 = $request->DATE_25;
    $DATE_26 = $request->DATE_26;
    $DATE_27 = $request->DATE_27;
    $DATE_28 = $request->DATE_28;
    $DATE_29 = $request->DATE_29;
    $DATE_30 = $request->DATE_30;
    $DATE_31 = $request->DATE_31;

    $number =count($MEMBER_ID);
    $count = 0;
    for($count = 0; $count < $number; $count++)
    {  

        $addactivity = new Operateactivity();
        $addactivity->OPERATE_ACTIVITY_INDEX_ID = $idindex;
        $addactivity->OPERATE_ACTIVITY_PERSON_ID = $MEMBER_ID[$count];
        $addactivity->DATE_1 = $request->DATE_1[$count];
        $addactivity->DATE_2 = $request->DATE_2[$count];
        $addactivity->DATE_3 = $request->DATE_3[$count];
        $addactivity->DATE_4 = $request->DATE_4[$count];
        $addactivity->DATE_5 = $request->DATE_5[$count];
        $addactivity->DATE_6 = $request->DATE_6[$count];
        $addactivity->DATE_7 = $request->DATE_7[$count];
        $addactivity->DATE_8 = $request->DATE_8[$count];
        $addactivity->DATE_9 = $request->DATE_9[$count];
        $addactivity->DATE_10 = $request->DATE_10[$count];
        $addactivity->DATE_11 = $request->DATE_11[$count];
        $addactivity->DATE_12 = $request->DATE_12[$count];
        $addactivity->DATE_13 = $request->DATE_13[$count];
        $addactivity->DATE_14 = $request->DATE_14[$count];
        $addactivity->DATE_15 = $request->DATE_15[$count];
        $addactivity->DATE_16 = $request->DATE_16[$count];
        $addactivity->DATE_17 = $request->DATE_17[$count];
        $addactivity->DATE_18 = $request->DATE_18[$count];
        $addactivity->DATE_19 = $request->DATE_19[$count];
        $addactivity->DATE_20 = $request->DATE_20[$count];
        $addactivity->DATE_21 = $request->DATE_21[$count];
        $addactivity->DATE_22 = $request->DATE_22[$count];
        $addactivity->DATE_23 = $request->DATE_23[$count];
        $addactivity->DATE_24 = $request->DATE_24[$count];
        $addactivity->DATE_25 = $request->DATE_25[$count];
        $addactivity->DATE_26 = $request->DATE_26[$count];
        $addactivity->DATE_27 = $request->DATE_27[$count];
        $addactivity->DATE_28 = $request->DATE_28[$count];
        $addactivity->DATE_29 = $request->DATE_29[$count];
        $addactivity->DATE_30 = $request->DATE_30[$count];
        $addactivity->DATE_31 = $request->DATE_31[$count];
        $addactivity->save(); 
        

       $idmaxactivity = Operateactivity::max('OPERATE_ACTIVITY_ID'); 

       $id_person = $MEMBER_ID[$count];

       $inforpersonuser=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                               ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
                               ->where('hrd_person.ID','=',$id_person)->first();

       $add = new Operatemember();
       $add->OPERATE_MEMBER_INDEX_ID = $idindex;
       $add->OPERATE_MEMBER_PERSON_ID = $MEMBER_ID[$count];
       $add->OPERATE_MEMBER_PERSON_NAME = $inforpersonuser->HR_PREFIX_NAME.''.$inforpersonuser->HR_FNAME.' '.$inforpersonuser->HR_LNAME;
       $add->OPERATE_MEMBER_POSITION_ID = $inforpersonuser->HR_POSITION_ID;
       $add->OPERATE_MEMBER_POSITION_NAME = $inforpersonuser->POSITION_IN_WORK;
       $add->OPERATE_MEMBER_POSITION_NAME = $inforpersonuser->POSITION_IN_WORK;
       $add->OPERATE_MEMBER_ACTIVITY_ID = $idmaxactivity;
       
       $add->save(); 

  
    }

    return redirect()->route('operate.setoperate',['iduser'=>  $request->PERSON_ID]);

    }

    //=============================================แจ้งยกเลิก====================================
   
public function inform(Request $request,$id,$iduser)
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

          $operateindexinfo = DB::table('operate_index')
          ->leftJoin('operate_status','operate_index.OPERATE_STATUS','=','operate_status.OPERATE_STATUS_CODE')
          ->leftJoin('hrd_department_sub_sub','operate_index.OPERATE_DEPARTMENT_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
          ->where('OPERATE_INDEX_ID','=',$id)
          ->first();


    return view('general_operate.geninfooperate_inform',[
        'inforpersonuser' => $inforpersonuser,
        'inforpersonuserid' => $inforpersonuserid, 
        'operateindexinfo' => $operateindexinfo,
        'infooperateid' => $id
       
        
    ]);
}


public function updateinform(Request $request)
{
    $id = $request->ID; 

      $update = Operateindex::find($id);
      $update->OPERATE_INFORM_ID = $request->OPERATE_INFORM_ID;
      $update->OPERATE_INFORM_COMMENT = $request->OPERATE_INFORM_COMMENT;
      $update->OPERATE_STATUS = 'Inform'; 
//-----------------------------------------------------
      $update->save();
      
          return redirect()->route('operate.setoperate',['iduser'=>  $request->OPERATE_INFORM_ID]);

}



    //=========================================ยกเลิก====================================
  
      
public function cancel(Request $request,$id,$iduser)
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

          $operateindexinfo = DB::table('operate_index')
          ->leftJoin('operate_status','operate_index.OPERATE_STATUS','=','operate_status.OPERATE_STATUS_CODE')
          ->leftJoin('hrd_department_sub_sub','operate_index.OPERATE_DEPARTMENT_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
          ->where('OPERATE_INDEX_ID','=',$id)
          ->first();


    return view('general_operate.geninfooperate_cancel',[
        'inforpersonuser' => $inforpersonuser,
        'inforpersonuserid' => $inforpersonuserid, 
        'operateindexinfo' => $operateindexinfo,
        'infooperateid' => $id
       
        
    ]);
}


public function updatecancel(Request $request)
{
    $id = $request->ID; 

      $update = Operateindex::find($id);
      $update->OPERATE_CANCEL_ID = $request->OPERATE_CANCEL_ID;
      $update->OPERATE_CANCEL_COMMENT = $request->OPERATE_CANCEL_COMMENT;
      $update->OPERATE_STATUS = 'Cancel'; 
//-----------------------------------------------------
  
      $update->save();
      
          return redirect()->route('operate.veroperate',['iduser'=>  $request->OPERATE_CANCEL_ID]);

}


    //=============================================ฟังชัน===============================

    

    function checkpositionver1(Request $request)
    {
        $iduser = $request->OPERATE_VERIFY_1_ID;
        $inforposition=  Person::where('ID','=',$iduser)->first();
        echo '<label>'.$inforposition->POSITION_IN_WORK.'</label>';
        
    }

    function checkpositionver2(Request $request)
    {
        $iduser = $request->OPERATE_VERIFY_2_ID;
        $inforposition=  Person::where('ID','=',$iduser)->first();
        echo '<label>'.$inforposition->POSITION_IN_WORK.'</label>';
        
    }

    function checkposition(Request $request)
    {
        $iduser = $request->MEMBER_ID;
        $inforposition=  Person::where('ID','=',$iduser)->first();
        echo $inforposition->POSITION_IN_WORK;
        
    }

    function member(Request $request)
    {
        $iddepartment = $request->OPERATE_DEPARTMENT_ID;
        $inforpositions=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                                ->where('HR_DEPARTMENT_SUB_SUB_ID','=',$iddepartment)
                                ->where('hrd_person.HR_STATUS_ID','<>',5)
                                ->where('hrd_person.HR_STATUS_ID','<>',6)
                                ->where('hrd_person.HR_STATUS_ID','<>',7)
                                ->where('hrd_person.HR_STATUS_ID','<>',8)
                                ->get();

        $inforpositions_select=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                                ->where('hrd_person.HR_STATUS_ID','<>',5)
                                ->where('hrd_person.HR_STATUS_ID','<>',6)
                                ->where('hrd_person.HR_STATUS_ID','<>',7)
                                ->where('hrd_person.HR_STATUS_ID','<>',8)
                                ->get();

        $count = 0; $number =1 ;
        foreach ( $inforpositions as  $inforposition){ 
          
            echo '<tr><td style="text-align: center;" >'.$number.'</td><td>'; 
            echo '<select name="MEMBER_ID[]" id="MEMBER_ID'.$count.'" class="form-control input-lg" style=" font-family: \'Kanit\', sans-serif;" onchange="checkposition('.$count.');">';
            echo '<option value="">--กรุณาเลือกสมาชิก--</option>';
                foreach ($inforpositions_select as $inforposition_2){ 
                        if($inforposition->ID == $inforposition_2 ->ID){                                                    
                            echo  '<option value="'.$inforposition_2->ID.'" selected>'.$inforposition_2->HR_PREFIX_NAME.' '.$inforposition_2->HR_FNAME.' '.$inforposition_2->HR_LNAME.'</option>';
                                }else{
                            echo  '<option value="'.$inforposition_2->ID.'">'.$inforposition_2->HR_PREFIX_NAME.' '.$inforposition_2->HR_FNAME.' '.$inforposition_2->HR_LNAME.'</option>';
                                }
                            }              
            echo '</select>';      
            echo '</td>';
            echo '<td><div class="showposition'.$count.'"></div></td>';                         
            echo '<td style="text-align: center;"><a class="btn btn-danger remove" style="color:#FFFFFF;"><i class=" fa fa-trash-alt"></i></a></td>';
            echo '</tr>';
             
            $count++; $number++;
            // Code Here
            }

        
        
    }

    //====================================================ฟังชั่นเพิ่มเติมตารางเวร=======


    
  
public function geotsetdetail_com(Request $request,$idref,$iduser)
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

             
    $check = DB::table('ot_command')->where('OT_INDEX_ID','=',$idref)->count();
    
    $info_detail =  DB::table('ot_command')->where('OT_INDEX_ID','=',$idref)->first();
   if($info_detail <> '' && $info_detail <> null){
    $detail = $info_detail->OT_DETAIL;
   }else{
    $detail = '';
   }
    

         
    return view('general_operate.geotsetdetail_com',[
        'inforpersonuser' => $inforpersonuser,
        'inforpersonuserid' => $inforpersonuserid, 
        'idref' => $idref,
        'check' => $check, 
        'detail' => $detail,  
        
    ]);
}

    

    public function geotsetdetail_comupdate(Request $request)
    {

        $idrefot = $request->idrefot;
        $idusersave = $request->idusersave;

        $check = DB::table('ot_command')->where('OT_INDEX_ID','=',$idrefot)->count();

        if($check <> 0){

          $idnumber_detail =  DB::table('ot_command')->where('OT_INDEX_ID','=',$idrefot)->first();
          $idnumber =  $idnumber_detail->OT_COMMAND_ID;
            $addhead = Otcommand::find($idnumber); 
            $addhead->OT_INDEX_ID =  $idrefot;   
            $addhead->OT_DETAIL =  $request->OT_DETAIL;    
            $addhead->save(); 
        }else{

            $addhead = new Otcommand();
            $addhead->OT_INDEX_ID =  $idrefot;   
            $addhead->OT_DETAIL =  $request->OT_DETAIL;    
            $addhead->save();
        
     

        }

        
         return redirect()->route('operate.setoperate',['iduser'=>$idusersave]);

}




                //------ประกาศคำสั่ง
                function pdfcommand_1(Request $request,$idref)
                {
                    $infoorg = DB::table('info_org')->where('ORG_ID','=',1)
                    ->leftJoin('hrd_person','hrd_person.ID','=','info_org.ORG_LEADER_ID')
                    ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                    ->first();
                
                    $info = DB::table('ot_command')->where('OT_INDEX_ID','=',$idref)->first();
                
                    $infomaion_command = $info->OT_DETAIL;
                
                
                    $pdf = PDF::loadView('general_ot.pdfcommand_1',[
                        'infoorg' => $infoorg, 
                        'infomaion_command' => $infomaion_command,
                        
                    ]);
                    return @$pdf->stream();
                
                }
                
                function pdfcommand_2(Request $request,$idref)
                {
                    $infoorg = DB::table('info_org')->where('ORG_ID','=',1)
                    ->leftJoin('hrd_person','hrd_person.ID','=','info_org.ORG_LEADER_ID')
                    ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                    ->first();
                
                    $info = DB::table('ot_command')->where('OT_INDEX_ID','=',$idref)->first();
                
                    $infomaion_command = $info->OT_DETAIL;
                
                
                    $pdf = PDF::loadView('general_ot.pdfcommand_2',[
                        'infoorg' => $infoorg, 
                        'infomaion_command' => $infomaion_command,
                        
                    ]);
                    return @$pdf->stream();
                
                }


                
function pdfpersonwork(Request $request,$idref)
{
    $infoorg = DB::table('info_org')->where('ORG_ID','=',1)
    ->leftJoin('hrd_person','hrd_person.ID','=','info_org.ORG_LEADER_ID')
    ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->first();

    $infoperson = DB::table('operate_member')
    ->leftJoin('hrd_person','hrd_person.ID','=','operate_member.OT_PERSON_ID')
    ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->where('OPERATE_MEMBER_INDEX_ID','=',$idref)->get();


    $pdf = PDF::loadView('general_ot.pdfpersonwork',[
        'infoorg' => $infoorg, 
        'infopersons' => $infoperson, 
    
        
    ]);
    return @$pdf->stream();

}
 
public function geot_savemessage_pdf()
 {    
   
     $pdf = PDF::loadView('general_ot.geot_savemessage_pdf');

   return @$pdf->stream();
 }

//===============================แลกเวร=========================================


public function genoperateswap(Request $request,$iduser)
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
     

    $infodepsubsub = DB::table('hrd_department_sub_sub')->get();
    $infoperson = DB::table('hrd_person')->get();
    $infojob = DB::table('operate_job')->get();
    $operateswap = DB::table('operate_swap')->get();
    

    return view('general_operate.genoperateswap',[
        'inforpersonuser' => $inforpersonuser,
        'inforpersonuserid' => $inforpersonuserid,
        'infodepsubsubs' => $infodepsubsub,
        'infopersons' => $infoperson,
        'operateswaps' => $operateswap,
        'infojobs' => $infojob,
        
    ]);
}



public function genoperateswap_save(Request $request)
{

    $datebigin = $request->get('OPSWAP_DATE_1');
    $dateend = $request->get('OPSWAP_DATE_2');

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
    $datejob= $y."-".$m."-".$d;

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
    $datejob_chang= $y_e."-".$m_e."-".$d_e;

       $from_datejob = date($datejob);
       $to_datejob_chang = date($datejob_chang); 
    


   $add = new Operateswap();
   $add->OPSWAP_DEP = $request->OPSWAP_DEP;
   $infodep = DB::table('hrd_department_sub_sub')->where('HR_DEPARTMENT_SUB_SUB_ID','=',$request->OPSWAP_DEP)->first();
   $add->OPSWAP_DEP_NAME = $infodep->HR_DEPARTMENT_SUB_SUB_NAME;
 
   $add->OPSWAP_PERSON_1 = $request->OPSWAP_PERSON_1;
   $infoperson1 = DB::table('hrd_person')->where('ID','=',$request->OPSWAP_PERSON_1)->first();
   $add->OPSWAP_PERSON_1_NAME =  $infoperson1->HR_FNAME.' '.$infoperson1->HR_LNAME;

   $add->OPSWAP_PERSON_2 = $request->OPSWAP_PERSON_2;
   $infoperson2 = DB::table('hrd_person')->where('ID','=',$request->OPSWAP_PERSON_2)->first();
   $add->OPSWAP_PERSON_2_NAME =$infoperson2->HR_FNAME.' '.$infoperson2->HR_LNAME;

   $add->OPSWAP_DATE_1 = $from_datejob;
   $add->OPSWAP_JOB_1 = $request->OPSWAP_JOB_1;
   $add->OPSWAP_REMARK = $request->OPSWAP_REMARK;
   $add->OPSWAP_DATE_2 = $to_datejob_chang;
   $add->OPSWAP_JOB_2 = $request->OPSWAP_JOB_2;
   
   $add->save(); 


return redirect()->route('operate.genoperateswap',['iduser'=>  $request->USER_ID]);

}




public function genoperateswap_update(Request $request)
{

    $datebigin = $request->get('OPSWAP_DATE_1');
    $dateend = $request->get('OPSWAP_DATE_2');

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
    $datejob= $y."-".$m."-".$d;

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
    $datejob_chang= $y_e."-".$m_e."-".$d_e;

       $from_datejob = date($datejob);
       $to_datejob_chang = date($datejob_chang); 
    
       $idrefnumber = $request->OPSWAP_ID;

   $add =  Operateswap::find($idrefnumber);
   $add->OPSWAP_DEP = $request->OPSWAP_DEP;
   $infodep = DB::table('hrd_department_sub_sub')->where('HR_DEPARTMENT_SUB_SUB_ID','=',$request->OPSWAP_DEP)->first();
   $add->OPSWAP_DEP_NAME = $infodep->HR_DEPARTMENT_SUB_SUB_NAME;
 
   $add->OPSWAP_PERSON_1 = $request->OPSWAP_PERSON_1;
   $infoperson1 = DB::table('hrd_person')->where('ID','=',$request->OPSWAP_PERSON_1)->first();
   $add->OPSWAP_PERSON_1_NAME =  $infoperson1->HR_FNAME.' '.$infoperson1->HR_LNAME;

   $add->OPSWAP_PERSON_2 = $request->OPSWAP_PERSON_2;
   $infoperson2 = DB::table('hrd_person')->where('ID','=',$request->OPSWAP_PERSON_2)->first();
   $add->OPSWAP_PERSON_2_NAME =$infoperson2->HR_FNAME.' '.$infoperson2->HR_LNAME;

   $add->OPSWAP_DATE_1 = $from_datejob;
   $add->OPSWAP_JOB_1 = $request->OPSWAP_JOB_1;
   $add->OPSWAP_REMARK = $request->OPSWAP_REMARK;
   $add->OPSWAP_DATE_2 = $to_datejob_chang;
   $add->OPSWAP_JOB_2 = $request->OPSWAP_JOB_2;
   
   $add->save(); 


return redirect()->route('operate.genoperateswap',['iduser'=>  $request->USER_ID]);

}



function infogenoperatechange_pdf(Request $request,$idref)
{

    $infoorg = DB::table('info_org')->where('ORG_ID','=',1)
                ->leftJoin('hrd_person','hrd_person.ID','=','info_org.ORG_LEADER_ID')
                ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                ->first();

 
    $pdf = PDF::loadView('general_operate.infogenoperatechange_pdf',[
        'infoorgs' => $infoorg,
    ]);
    return @$pdf->stream();

}


function infogenoperateswap_pdf(Request $request,$idref)
{

    $infoorg = DB::table('info_org')->where('ORG_ID','=',1)
                ->leftJoin('hrd_person','hrd_person.ID','=','info_org.ORG_LEADER_ID')
                ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                ->first();

 
    $pdf = PDF::loadView('general_operate.infogenoperateswap_pdf',[
        'infoorgs' => $infoorg,
    ]);
    return @$pdf->stream();

}



public function operatesignature_excel(Request $request,$idref,$iduser)
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


     $infomationoperate = DB::table('operate_index')->where('OPERATE_INDEX_ID','=',$idref)->first(); 

     $year =  $infomationoperate->OPERATE_INDEX_YEAR;
     $month = $infomationoperate->OPERATE_INDEX_MONTH;
 
     if($month == '04'|| $month == '06' || $month == '09' || $month == '11'){
        $lastdate =  '30';
     }else{
        $lastdate = '31';
     }
      


    return view('general_operate.operatesignature_excel',[
        'inforpersonuser' => $inforpersonuser,
        'inforpersonuserid' => $inforpersonuserid, 
        'year' => $year, 
        'month' => $month,
        'lastdate' => $lastdate, 
    ]);
}



  //===================รายงานรวมตารางเวร

  public function genoperateindex_allreport(Request $request,$year,$month,$iduser)
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
       

      $operateindex1 =  DB::table('operate_index')
      ->where('operate_index.OPERATE_DEPARTMENT_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)
      ->where('operate_index.OPERATE_INDEX_MONTH','=',$month)
      ->where('operate_index.OPERATE_INDEX_YEAR','=',$year)
      ->where('operate_index.OPERATE_STATUS','=','Allow')
      ->first();
      
      
      $operateindex2 =  DB::table('operate_index')
      ->where('operate_index.OPERATE_DEPARTMENT_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)
      ->where('operate_index.OPERATE_INDEX_MONTH','=',$month)
      ->where('operate_index.OPERATE_INDEX_YEAR','=',$year)
      ->where('operate_index.OPERATE_STATUS','=','Allow')
      ->get();


      $operateindex2_count =  DB::table('operate_index')
      ->where('operate_index.OPERATE_DEPARTMENT_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)
      ->where('operate_index.OPERATE_INDEX_MONTH','=',$month)
      ->where('operate_index.OPERATE_INDEX_YEAR','=',$year)
      ->where('operate_index.OPERATE_STATUS','=','Allow')
      ->count();




      if($operateindex1 <> null){$idactivity =   $operateindex1->OPERATE_INDEX_ID; }else{$idactivity = '';}

      $infoactivity =  DB::table('operate_member')
      ->leftJoin('operate_activity','operate_member.OPERATE_MEMBER_PERSON_ID','=','operate_activity.OPERATE_ACTIVITY_PERSON_ID')
      ->where('operate_member.OPERATE_MEMBER_INDEX_ID','=',$idactivity)
      ->where('operate_activity.OPERATE_ACTIVITY_INDEX_ID','=',$idactivity)
      ->get();

     
          $operatejob = DB::table('operate_job')
          ->where('OPERATE_DEPARTMENT_SUB_SUB_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)->get();    
          
          $leavemonth = DB::table('leave_month')->get();

          $operatestatus = DB::table('operate_status')->get();
          $budgetyear = DB::table('budget_year')
          ->get();

          $searchyear_check = date('Y');
          $searchmonth_check  = date('m');
          $searchtype_check  = '';
          
          $operatetype = DB::table('operate_type')->get();

      return view('general_operate.geninfooperateindex_all',[
          'inforpersonuser' => $inforpersonuser,
          'inforpersonuserid' => $inforpersonuserid,
          'operateindex2s' => $operateindex2, 
          'infoactivitys' => $infoactivity, 
          'operatetypes' => $operatetype, 
          'leavemonths' => $leavemonth, 
          'operatestatus' => $operatestatus, 
          'searchyear_check' => $searchyear_check, 
          'searchmonth_check' => $searchmonth_check, 
          'searchtype_check' => $searchtype_check, 
          'budgetyears' => $budgetyear, 
          'operateindex2_count' => $operateindex2_count, 
          'year' => $year, 
          'month' => $month, 
          'operatejobs' => $operatejob        
         
      ]);
  }


  //===========================ตรวจสอบสิทธิ์การเข้าถึง================================================================

       public static function checkoperate_ver($id_user)
    {
        $count =  Permislist::where('PERSON_ID','=',$id_user)
        ->where('PERMIS_ID','=','OPA001')
        ->count();    
    
     return $count;
    }

    public static function checkoperate_allow($id_user)
    {
        $count =  Permislist::where('PERSON_ID','=',$id_user)
        ->where('PERMIS_ID','=','OPA002')
        ->count();    
    
     return $count;
    }




}
