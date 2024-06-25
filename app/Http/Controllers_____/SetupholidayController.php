<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\LeaveHolidays;
use App\Models\Leave_register;
use App\Models\Person;


class SetupholidayController extends Controller
{
    public function infoholiday()
    {
 
        $yearbudget = date("Y");
        

        $infoholiday = LeaveHolidays::where('DATE_HOLIDAY','like',$yearbudget.'-%')
        ->orderBy('DATE_HOLIDAY', 'asc')->get();

        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $year_id = $yearbudget+543;

        return view('admin.setupholiday',[
            'infoholidays' => $infoholiday, 
            'budgets' =>  $budget,
            'year_id' =>  $year_id,
            
            ]);
    }


    public function infoholidaysearch(Request $request)
    {
        $yearbudget = $request->BUDGET_YEAR-543;
        $infoholiday = LeaveHolidays::where('DATE_HOLIDAY','like',$yearbudget.'-%')
        ->orderBy('DATE_HOLIDAY', 'asc')->get();

                                     
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $year_id = $yearbudget+543;

        return view('admin.setupholiday',[
            'infoholidays' => $infoholiday, 
            'budgets' =>  $budget,
            'year_id' =>  $year_id,
        ]);
    }

    public function create(Request $request)
    {
       //dd($infoeducation);
        return view('admin.setupholiday_add');

    }

    public function save(Request $request)
    {    
                $checkstart= $request->DATE_HOLIDAY;
              
                 if($checkstart != ''){
         
                    
                     $STARTDAY = Carbon::createFromFormat('d/m/Y', $checkstart)->format('Y-m-d');
                     $date_arrary_st=explode("-",$STARTDAY);  
                     $y_sub_st = $date_arrary_st[0]; 
                     
                     if($y_sub_st >= 2500){
                         $y_st = $y_sub_st-543;
                     }else{
                         $y_st = $y_sub_st;
                     }
                     $m_st = $date_arrary_st[1];
                     $d_st = $date_arrary_st[2];  
                     $displaystartdate= $y_st."-".$m_st."-".$d_st;
                  
         
                     }else{
                     $displaystartdate= null;
                 }

            $addholiday = new LeaveHolidays(); 
            $addholiday->DATE_HOLIDAY = $displaystartdate;
            $addholiday->DATE_COMMENT = $request->DATE_COMMENT;
            $addholiday->DATE_TYPE = $request->DATE_TYPE;
 
            $addholiday->save();


            return redirect()->route('setup.indexholiday'); 
    }

    
        public function edit(Request $request,$id)
        {
            //return $request->all();

            $id_in= $request->id;

            $infoholiday = LeaveHolidays::where('ID','=',$id_in)
                                        ->first();
            //dd($infoholiday);

            return view('admin.setupholiday_edit',[
            'infoholidays' => $infoholiday 
                ]);
        }

public function update(Request $request)
{
    $id = $request->ID;
    $checkstart= $request->DATE_HOLIDAY;
              
    if($checkstart != ''){

       
        $STARTDAY = Carbon::createFromFormat('d/m/Y', $checkstart)->format('Y-m-d');
        $date_arrary_st=explode("-",$STARTDAY);  
        $y_sub_st = $date_arrary_st[0]; 
        
        if($y_sub_st >= 2500){
            $y_st = $y_sub_st-543;
        }else{
            $y_st = $y_sub_st;
        }
        $m_st = $date_arrary_st[1];
        $d_st = $date_arrary_st[2];  
        $displaystartdate= $y_st."-".$m_st."-".$d_st;
     

        }else{
        $displaystartdate= null;
    }

    $updateholiday = LeaveHolidays::find($id);
    $updateholiday->DATE_HOLIDAY = $displaystartdate;
    $updateholiday->DATE_COMMENT = $request->DATE_COMMENT;
    $updateholiday->DATE_TYPE = $request->DATE_TYPE;
 
    $updateholiday->save();
    
    
        return redirect()->route('setup.indexholiday'); 
}


public function destroy($id) { 
            
    LeaveHolidays::destroy($id);         
    //return redirect()->action('ChangenameController@infouserchangename');  
    return redirect()->route('setup.indexholiday');   
}


//---------------------คำนวณวันลาใหม่

public function callnewholiday(Request $request)
{    
     
    $datebigin = $request->get('DATE_BIGIN');
    $dateend = $request->get('DATE_END');


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




        $inforleaves=  Leave_register::WhereBetween('LEAVE_DATE_BEGIN',[$from,$to])->get();


        foreach ($inforleaves as $inforleave){


        $date = $inforleave->LEAVE_DATE_BEGIN;
        $end_date = $inforleave->LEAVE_DATE_END;
   

        $sumdate = round(abs(strtotime($date) - strtotime($end_date))/60/60/24)+1;

        date_default_timezone_set('Asia/Bangkok');
  
  
       $intHoliday=0;
       $intPublicHoliday=0;
       while (strtotime($date) <= strtotime($end_date)) {
  
          $count= DB::table('gleave_holiday')
                ->where('gleave_holiday.DATE_HOLIDAY',$date)
                ->count();
  
          $DayOfWeek = date("w", strtotime($date));
           if($DayOfWeek == 0 or $DayOfWeek ==6)  // 0 = Sunday, 6 = Saturday;
           {
               $intHoliday++;
           }elseif($count== 1)
           {
               $intPublicHoliday++;
  
           }
  
           $date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
       }
  
 
  
     $checkholiday =  Person::where('hrd_person.ID','=',$inforleave->LEAVE_PERSON_ID)->first();
  
     
                          //----------------------------คำนวนวันทำการ
                          if($inforleave->DATE_OFF == '' ||$inforleave->DATE_OFF== null){
                              $amountdateoff =  0;
                          }else{
                              $amountdateoff =  $inforleave->DATE_OFF;
                          }
  
  
                          //----------------------------คำนวนวันทำการ
                          if($inforleave->LEAVE_TYPE_CODE== '02' || $inforleave->LEAVE_TYPE_CODE== '05' || $inforleave->LEAVE_TYPE_CODE== '07' || $inforleave->LEAVE_TYPE_CODE== '08' || $inforleave->LEAVE_TYPE_CODE== '09' || $inforleave->LEAVE_TYPE_CODE== '10'){
                              $datework = $sumdate;
                          }else{
  
                          

                              if($checkholiday->LEAVEDAY_ACTIVE == 'True'){
  
                                  if($inforleave->DAY_TYPE_ID == '2'|| $inforleave->DAY_TYPE_ID == '3' || $inforleave->DAY_TYPE_ID == '02'|| $inforleave->DAY_TYPE_ID == '03'){
                                      $datework = '0.5';
                                  }else{
                                      $datework = $sumdate - $amountdateoff;
                                  }
                              
                              }else{
                                  if($inforleave->DAY_TYPE_ID == '2'|| $inforleave->DAY_TYPE_ID == '3' || $inforleave->DAY_TYPE_ID == '02'|| $inforleave->DAY_TYPE_ID == '03'){
                                      $datework = '0.5';
                                  }else{
                                      $datework = $sumdate - ($intHoliday + $intPublicHoliday);
                                  }
                              }
  
                          }
                          
     
  
               
                    $addleave = Leave_register::find($inforleave->ID); 
                    $addleave->WORK_DO = $datework;
                    $addleave->LEAVE_SUM_ALL = $sumdate;
                    $addleave->LEAVE_SUM_HOLIDAY = $intHoliday;
                    $addleave->LEAVE_SUM_SETSUN = $intPublicHoliday;
                    $addleave->save();

                }

        }            

        return redirect()->route('setup.indexholiday'); 
}




}
