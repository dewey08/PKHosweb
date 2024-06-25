<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Person;

use App\Models\Guesthousinfomation;

use App\Models\Guesthousinfomationperson;
use App\Models\Guesthousinfomationoutsider;
use App\Models\Guesthousinfomationasset;
use App\Models\Guesthousinfomationrepair;
use App\Models\Guesthousproblem;
use App\Models\Guesthouspetition;
use App\Models\Guesthouswater;
use App\Models\Guesthouswaterh;
use App\Models\Guesthouselec;
use Cookie;

date_default_timezone_set("Asia/Bangkok");

class ManagerguesthouseController extends Controller
{
    public function dashboard()
    {
        $year = date('Y'); 
        $year_id = $year+543; 

        $amount_f = DB::table('guesthous_infomation_person')
        ->leftjoin('guesthous_infomation','guesthous_infomation.INFMATION_ID','=','guesthous_infomation_person.INFMATION_ID')
        ->where('INFMATION_TYPE','=','1')
        ->where('INFMATION_PERSON_INDATE','like',$year.'%')->count();

        $amount_h = DB::table('guesthous_infomation_person')
        ->leftjoin('guesthous_infomation','guesthous_infomation.INFMATION_ID','=','guesthous_infomation_person.INFMATION_ID')
        ->where('INFMATION_TYPE','=','2')
        ->where('INFMATION_PERSON_INDATE','like',$year.'%')->count();

        $year_sum = $year-3;
        for($i=0; $i<5; $i++){
           $sum[] = $year_sum++;
        } 

        $i=0;
        $j=0;
        foreach($sum as $row[]){
            $year_falt[$i] = DB::table('guesthous_infomation_person')
            ->leftjoin('guesthous_infomation','guesthous_infomation.INFMATION_ID','=','guesthous_infomation_person.INFMATION_ID')
            ->where('INFMATION_TYPE','=','1')
            ->where('INFMATION_PERSON_INDATE','like',$row[$i].'%')->count();
            $i++;
        }  
        foreach($sum as $row[]){
            $year_house[$j] = DB::table('guesthous_infomation_person')
            ->leftjoin('guesthous_infomation','guesthous_infomation.INFMATION_ID','=','guesthous_infomation_person.INFMATION_ID')
            ->where('INFMATION_TYPE','=','2')
            ->where('INFMATION_PERSON_INDATE','like',$row[$j].'%')->count();
            $j++;
        }
 
        $m1_1 = DB::table('guesthous_infomation_person')->where('INFMATION_PERSON_INDATE','like',$year.'-01%')->count();
        $m2_1 = DB::table('guesthous_infomation_person')->where('INFMATION_PERSON_INDATE','like',$year.'-02%')->count();
        $m3_1 = DB::table('guesthous_infomation_person')->where('INFMATION_PERSON_INDATE','like',$year.'-03%')->count();
        $m4_1 = DB::table('guesthous_infomation_person')->where('INFMATION_PERSON_INDATE','like',$year.'-04%')->count();
        $m5_1 = DB::table('guesthous_infomation_person')->where('INFMATION_PERSON_INDATE','like',$year.'-05%')->count();
        $m6_1 = DB::table('guesthous_infomation_person')->where('INFMATION_PERSON_INDATE','like',$year.'-06%')->count();
        $m7_1 = DB::table('guesthous_infomation_person')->where('INFMATION_PERSON_INDATE','like',$year.'-07%')->count();
        $m8_1 = DB::table('guesthous_infomation_person')->where('INFMATION_PERSON_INDATE','like',$year.'-08%')->count();
        $m9_1 = DB::table('guesthous_infomation_person')->where('INFMATION_PERSON_INDATE','like',$year.'-09%')->count();
        $m10_1 = DB::table('guesthous_infomation_person')->where('INFMATION_PERSON_INDATE','like',$year.'-10%')->count();
        $m11_1 = DB::table('guesthous_infomation_person')->where('INFMATION_PERSON_INDATE','like',$year.'-11%')->count();
        $m12_1 = DB::table('guesthous_infomation_person')->where('INFMATION_PERSON_INDATE','like',$year.'-12%')->count();
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();


        $infomation_flat = DB::table('guesthous_infomation_person')->where('guesthous_infomation_person.INFMATION_PERSON_STATUS','=','1')
            ->leftJoin('hrd_person','hrd_person.ID','=','guesthous_infomation_person.INFMATION_PERSON_HRID')
            ->leftJoin('supplies_location_level_room','supplies_location_level_room.LEVEL_ROOM_ID','=','guesthous_infomation_person.LEVEL_ROOM_ID')
            ->leftJoin('guesthous_infomation','guesthous_infomation.INFMATION_ID','=','guesthous_infomation_person.INFMATION_ID')->where('guesthous_infomation.INFMATION_TYPE','=','1')
            ->leftJoin('guesthous_infomation_outsider','guesthous_infomation_outsider.INFMATION_OUTSIDER_RELATIONADD','=','guesthous_infomation_person.INFMATION_PERSON_HRID')
            ->select('guesthous_infomation_person.*','hrd_person.*','supplies_location_level_room.*','guesthous_infomation.*','guesthous_infomation_outsider.*')
            ->get();

        $infomation_house = DB::table('guesthous_infomation_person')->where('guesthous_infomation_person.INFMATION_PERSON_STATUS','=','1')
            ->leftJoin('hrd_person','hrd_person.ID','=','guesthous_infomation_person.INFMATION_PERSON_HRID')
            ->leftJoin('supplies_location_level_room','supplies_location_level_room.LEVEL_ROOM_ID','=','guesthous_infomation_person.LEVEL_ROOM_ID')
            ->leftJoin('guesthous_infomation','guesthous_infomation.INFMATION_ID','=','guesthous_infomation_person.INFMATION_ID')->where('guesthous_infomation.INFMATION_TYPE','=','2')
            ->leftJoin('guesthous_infomation_outsider','guesthous_infomation_outsider.INFMATION_OUTSIDER_RELATIONADD','=','guesthous_infomation_person.INFMATION_PERSON_HRID')
            ->select('guesthous_infomation_person.*','hrd_person.*','supplies_location_level_room.*','guesthous_infomation.*','guesthous_infomation_outsider.*')
            ->get();
        

        $count_flat = DB::table('supplies_location_level_room')
            ->leftJoin('supplies_location_level','supplies_location_level_room.LOCATION_LEVEL_ID','=','supplies_location_level.LOCATION_LEVEL_ID')
            ->leftJoin('guesthous_infomation','supplies_location_level.LOCATION_ID','=','guesthous_infomation.LOCATION_ID')
            ->where('guesthous_infomation.INFMATION_TYPE','=','1')
            ->get();
        $checkcount_flat = 0;
        $checkcount_flat_person = 0;
            foreach($count_flat as $infoflat){
                $check_flat = DB::table('guesthous_infomation_person')
                ->where('INFMATION_ID','=',$infoflat->INFMATION_ID)
                ->where('LOCATION_LEVEL_ID','=',$infoflat->LOCATION_LEVEL_ID)
                ->where('LEVEL_ROOM_ID','=',$infoflat->LEVEL_ROOM_ID)
                ->where('INFMATION_PERSON_STATUS','=','1')
                ->count();
                if($check_flat == 0){ 
                    $checkcount_flat++; //ว่าง
                }else if($check_flat == 1){
                    $checkcount_flat_person++;//คนที่อยู่
                }
            }
        //ข้อมูลบ้านพัก
        $count_house = DB::table('guesthous_infomation')->where('INFMATION_TYPE','=','2')->get();
        
        $checkcount_house = 0;
        $checkcount_house_person = 0;
            foreach($count_house as $infohouse){
                $check_house = DB::table('guesthous_infomation_person')
                ->where('INFMATION_ID','=',$infohouse->INFMATION_ID)
                ->where('INFMATION_PERSON_STATUS','=','1')
                ->count();
                if($check_house == 0){ 
                    $checkcount_house++;//ว่าง
                }else if($check_house == 1){
                    $checkcount_house_person++;//คนที่อยู่
                }
            }   

        //รายการขอ
        $count_request = DB::table('guesthous_petition')->count();
        $count_request_1 = DB::table('guesthous_petition')->where('guesthous_petition.PETITION_TYPE','=','1')->count();
        $count_request_2 = DB::table('guesthous_petition')->where('guesthous_petition.PETITION_TYPE','=','2')->count();
        $count_request_3 = DB::table('guesthous_petition')->where('guesthous_petition.PETITION_TYPE','=','3')->count();

        // แจ้งปัญหา
        $count_problem  = DB::table('guesthous_problem')->count();
        $count_problem_1 = DB::table('guesthous_problem')->where('guesthous_problem.PROBLEM_STATUS','=','REQUEST')->count();
        $count_problem_2 = DB::table('guesthous_problem')->where('guesthous_problem.PROBLEM_STATUS','=','SUCCESS')->count();
        $count_problem_3 = DB::table('guesthous_problem')->where('guesthous_problem.PROBLEM_STATUS','=','CANCEL')->count();
        $count_problem_4 = DB::table('guesthous_problem')->where('guesthous_problem.PROBLEM_STATUS','=','NOSUCCESS')->count();

        return view('manager_guesthouse.dashboard_guesthouse',[
           'amount_f' => $amount_f,
           'amount_h' => $amount_h,
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
            'year_id'=>$year_id,
            'infomations_flat' =>  $infomation_flat,
            'infomations_house' => $infomation_house,
            'checkcount_house' => $checkcount_house,
            'checkcount_flat' => $checkcount_flat,
            'count_request' => $count_request,
            'count_request_1' => $count_request_1,
            'count_request_2' => $count_request_2,
            'count_request_3' => $count_request_3,
            'count_problem' => $count_problem,
            'count_problem_1' => $count_problem_1,
            'count_problem_2' => $count_problem_2,
            'count_problem_3' => $count_problem_3,
            'count_problem_4' => $count_problem_4,
            'checkcount_house_person' => $checkcount_house_person, //คนที่อยู่บ้านพัก
            'checkcount_flat_person' => $checkcount_flat_person, //คนที่อยู่แฟลต
            'year_falt' => $year_falt,
            'year_house' => $year_house,
            'sum' => $sum
            
            ]);    
    }


    
    
    public function dashboardsearch(Request $request)
    {
        $year_id = $request->STATUS_CODE; //พ.ศ.
        $year = $year_id -543; //ค.ศ.
        $year_now = date('Y');

        //กราฟวงกลม
        $amount_f = DB::table('guesthous_infomation_person')
        ->leftjoin('guesthous_infomation','guesthous_infomation.INFMATION_ID','=','guesthous_infomation_person.INFMATION_ID')
        ->where('INFMATION_TYPE','=','1')
        ->where('INFMATION_PERSON_INDATE','like',$year.'%')->count();

        $amount_h = DB::table('guesthous_infomation_person')
        ->leftjoin('guesthous_infomation','guesthous_infomation.INFMATION_ID','=','guesthous_infomation_person.INFMATION_ID')
        ->where('INFMATION_TYPE','=','2')
        ->where('INFMATION_PERSON_INDATE','like',$year.'%')->count();
        
         //เเสดงในกราฟเส้น loop ปี
        $year_sum = $year_now-3;
        for($i=0; $i<5; $i++){
           $sum[] = $year_sum++;
          
        } 
        $i=0;
        $j=0;
            foreach($sum as $row[]){
                $year_falt[$i] = DB::table('guesthous_infomation_person')
                ->leftjoin('guesthous_infomation','guesthous_infomation.INFMATION_ID','=','guesthous_infomation_person.INFMATION_ID')
                ->where('INFMATION_TYPE','=','1')
                ->where('INFMATION_PERSON_INDATE','like',$row[$i].'%')->count();
                $i++;
            
            }  
            foreach($sum as $row[]){
            $year_house[$j] = DB::table('guesthous_infomation_person')
                ->leftjoin('guesthous_infomation','guesthous_infomation.INFMATION_ID','=','guesthous_infomation_person.INFMATION_ID')
                ->where('INFMATION_TYPE','=','2')
                ->where('INFMATION_PERSON_INDATE','like',$row[$j].'%')->count();
                $j++;
            } 

             //จำนวนผู้เข้าพักแต่ละเดือน
             $m1_1 = DB::table('guesthous_infomation_person')->where('INFMATION_PERSON_INDATE','like',$year.'-01%')->count();
             $m2_1 = DB::table('guesthous_infomation_person')->where('INFMATION_PERSON_INDATE','like',$year.'-02%')->count();
             $m3_1 = DB::table('guesthous_infomation_person')->where('INFMATION_PERSON_INDATE','like',$year.'-03%')->count();
             $m4_1 = DB::table('guesthous_infomation_person')->where('INFMATION_PERSON_INDATE','like',$year.'-04%')->count();
             $m5_1 = DB::table('guesthous_infomation_person')->where('INFMATION_PERSON_INDATE','like',$year.'-05%')->count();
             $m6_1 = DB::table('guesthous_infomation_person')->where('INFMATION_PERSON_INDATE','like',$year.'-06%')->count();
             $m7_1 = DB::table('guesthous_infomation_person')->where('INFMATION_PERSON_INDATE','like',$year.'-07%')->count();
             $m8_1 = DB::table('guesthous_infomation_person')->where('INFMATION_PERSON_INDATE','like',$year.'-08%')->get();
             $m9_1 = DB::table('guesthous_infomation_person')->where('INFMATION_PERSON_INDATE','like',$year.'-09%')->count();
             $m10_1 = DB::table('guesthous_infomation_person')->where('INFMATION_PERSON_INDATE','like',$year.'-10%')->count();
             $m11_1 = DB::table('guesthous_infomation_person')->where('INFMATION_PERSON_INDATE','like',$year.'-11%')->count();
             $m12_1 = DB::table('guesthous_infomation_person')->where('INFMATION_PERSON_INDATE','like',$year.'-12%')->count();
             $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

             //ข้อมูลใน modal
        $infomation_flat = DB::table('guesthous_infomation_person')->where('guesthous_infomation_person.INFMATION_PERSON_STATUS','=','1')
           ->leftJoin('hrd_person','hrd_person.ID','=','guesthous_infomation_person.INFMATION_PERSON_HRID')
           ->leftJoin('supplies_location_level_room','supplies_location_level_room.LEVEL_ROOM_ID','=','guesthous_infomation_person.LEVEL_ROOM_ID')
           ->leftJoin('guesthous_infomation','guesthous_infomation.INFMATION_ID','=','guesthous_infomation_person.INFMATION_ID')->where('guesthous_infomation.INFMATION_TYPE','=','1')
           ->leftJoin('guesthous_infomation_outsider','guesthous_infomation_outsider.INFMATION_OUTSIDER_RELATIONADD','=','guesthous_infomation_person.INFMATION_PERSON_HRID')
           ->select('guesthous_infomation_person.*','hrd_person.*','supplies_location_level_room.*','guesthous_infomation.*','guesthous_infomation_outsider.*')
           ->get();

       $infomation_house = DB::table('guesthous_infomation_person')->where('guesthous_infomation_person.INFMATION_PERSON_STATUS','=','1')
           ->leftJoin('hrd_person','hrd_person.ID','=','guesthous_infomation_person.INFMATION_PERSON_HRID')
           ->leftJoin('supplies_location_level_room','supplies_location_level_room.LEVEL_ROOM_ID','=','guesthous_infomation_person.LEVEL_ROOM_ID')
           ->leftJoin('guesthous_infomation','guesthous_infomation.INFMATION_ID','=','guesthous_infomation_person.INFMATION_ID')->where('guesthous_infomation.INFMATION_TYPE','=','2')
           ->leftJoin('guesthous_infomation_outsider','guesthous_infomation_outsider.INFMATION_OUTSIDER_RELATIONADD','=','guesthous_infomation_person.INFMATION_PERSON_HRID')
           ->select('guesthous_infomation_person.*','hrd_person.*','supplies_location_level_room.*','guesthous_infomation.*','guesthous_infomation_outsider.*')
           ->get();
       
       // ข้อมูลแฟลต
       $count_flat = DB::table('supplies_location_level_room')
           ->leftJoin('supplies_location_level','supplies_location_level_room.LOCATION_LEVEL_ID','=','supplies_location_level.LOCATION_LEVEL_ID')
           ->leftJoin('guesthous_infomation','supplies_location_level.LOCATION_ID','=','guesthous_infomation.LOCATION_ID')
           ->where('guesthous_infomation.INFMATION_TYPE','=','1')
           ->get();

       $checkcount_flat = 0;
       $checkcount_flat_person = 0;
           foreach($count_flat as $infoflat){
               $check_flat = DB::table('guesthous_infomation_person')
               ->where('INFMATION_ID','=',$infoflat->INFMATION_ID)
               ->where('LOCATION_LEVEL_ID','=',$infoflat->LOCATION_LEVEL_ID)
               ->where('LEVEL_ROOM_ID','=',$infoflat->LEVEL_ROOM_ID)
               ->where('INFMATION_PERSON_STATUS','=','1')
               ->count();
               if($check_flat == 0){ 
                   $checkcount_flat++; 
               }else if($check_flat == 1){
                   $checkcount_flat_person++;//คนที่อยู่
               }
           }
   
        // ข้อมูลแฟลต
       $count_house = DB::table('guesthous_infomation')->where('guesthous_infomation.INFMATION_TYPE','=','2')->get();
       $checkcount_house = 0;
       $checkcount_house_person = 0;
           foreach($count_house as $infohouse){
               $check_house = DB::table('guesthous_infomation_person')
               ->where('INFMATION_ID','=',$infohouse->INFMATION_ID)
               ->where('INFMATION_PERSON_STATUS','=','1')
               ->count();
               if($check_house == 0){ 
                   $checkcount_house++;
               }else if($check_house == 1){
                   $checkcount_house_person++;//คนที่อยู่
               }
       }

       //รายการขอ
       $count_request = DB::table('guesthous_petition')->count();
       $count_request_1 = DB::table('guesthous_petition')->where('guesthous_petition.PETITION_TYPE','=','1')->count();
       $count_request_2 = DB::table('guesthous_petition')->where('guesthous_petition.PETITION_TYPE','=','2')->count();
       $count_request_3 = DB::table('guesthous_petition')->where('guesthous_petition.PETITION_TYPE','=','3')->count();

       // แจ้งปัญหา
       $count_problem  = DB::table('guesthous_problem')->count();
       $count_problem_1 = DB::table('guesthous_problem')->where('guesthous_problem.PROBLEM_STATUS','=','REQUEST')->count();
       $count_problem_2 = DB::table('guesthous_problem')->where('guesthous_problem.PROBLEM_STATUS','=','SUCCESS')->count();
       $count_problem_3 = DB::table('guesthous_problem')->where('guesthous_problem.PROBLEM_STATUS','=','CANCEL')->count();
       $count_problem_4 = DB::table('guesthous_problem')->where('guesthous_problem.PROBLEM_STATUS','=','NOSUCCESS')->count();

        return view('manager_guesthouse.dashboard_guesthouse',[
            'amount_f' => $amount_f,
            'amount_h' => $amount_h,
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
            'year_id'=>$year_id,
            'infomations_flat' =>  $infomation_flat,
            'infomations_house' => $infomation_house,
            'checkcount_house' => $checkcount_house,
            'checkcount_flat' => $checkcount_flat,
            'count_request' => $count_request,
            'count_request_1' => $count_request_1,
            'count_request_2' => $count_request_2,
            'count_request_3' => $count_request_3,
            'count_problem' => $count_problem,
            'count_problem_1' => $count_problem_1,
            'count_problem_2' => $count_problem_2,
            'count_problem_3' => $count_problem_3,
            'count_problem_4' => $count_problem_4,
            'checkcount_house_person' => $checkcount_house_person, //คนที่อยู่บ้านพัก
            'checkcount_flat_person' => $checkcount_flat_person, //คนที่อยู่แฟลต
            'year_falt' => $year_falt,
            'year_house' => $year_house,
            'sum' => $sum,

            ]);

    }

   


//จัดสรรแฟลต
    public function guesthouserequestdetail_flat(Request $request,$id)
    {

        $infoguesthouse = DB::table('guesthous_infomation')
        ->leftJoin('supplies_location','supplies_location.LOCATION_ID','=','guesthous_infomation.LOCATION_ID')
        ->leftJoin('hrd_person','hrd_person.ID','=','guesthous_infomation.INFMATION_HR_ID')    

        ->where('guesthous_infomation.INFMATION_ID','=',$id)->first();
 

        $infoguesthouse_level = DB::table('supplies_location_level')
        ->where('LOCATION_ID','=',$infoguesthouse->LOCATION_ID)
        
        ->get();

       

        return view('manager_guesthouse.guesthouserequestdetail_flat',[
           'infoguesthouse' => $infoguesthouse,
           'infoguesthouse_levels' => $infoguesthouse_level,
        ]);
    }
//รายละเอียดที่พัก
    public function guesthouserequestdetail()
    {
        $infoinfomation  = DB::table('guesthous_infomation')->orderBy('INFMATION_TYPE', 'asc')->get();
        return view('manager_guesthouse.guesthouserequestdetail',[
            'infoinfomations'=>  $infoinfomation
        ]);
    }

//จัดสรรบ้านพัก
    public function guesthouserequestdetail_home(Request $request,$id,$type_check)
    {
        $type_check = $type_check;

            $infoguesthouse = DB::table('guesthous_infomation')
        ->leftJoin('guesthous_infomation_person','guesthous_infomation_person.INFMATION_ID','=','guesthous_infomation.INFMATION_ID')->where('guesthous_infomation.INFMATION_ID','=',$id)
        ->leftJoin('supplies_location','supplies_location.LOCATION_ID','=','guesthous_infomation.LOCATION_ID')
        ->leftJoin('supplies_location_level','supplies_location_level.LOCATION_ID','=','supplies_location.LOCATION_ID')
        ->leftJoin('supplies_location_level_room','supplies_location_level_room.LOCATION_LEVEL_ID','=','supplies_location_level.LOCATION_LEVEL_ID')
        ->leftJoin('hrd_person','hrd_person.ID','=','guesthous_infomation.INFMATION_HR_ID')
       ->first();

        $inforperson  =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->get();

        $infoguesthousperson  = DB::table('guesthous_infomation_person')
            ->leftJoin('hrd_person','hrd_person.ID','=','guesthous_infomation_person.INFMATION_PERSON_HRID')
            ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
            ->where('INFMATION_ID','=',$id)
            ->get();

        $infoguesthousoutsider  = DB::table('guesthous_infomation_outsider')
            ->leftJoin('hrd_person','hrd_person.ID','=','guesthous_infomation_outsider.INFMATION_OUTSIDER_RELATIONADD')
            ->leftJoin('supplies_location_level','supplies_location_level.LOCATION_LEVEL_ID','=','guesthous_infomation_outsider.LOCATION_LEVEL_ID')
            ->leftJoin('supplies_location_level_room','supplies_location_level_room.LEVEL_ROOM_ID','=','guesthous_infomation_outsider.LEVEL_ROOM_ID')
            ->where('INFMATION_ID','=',$id)
            ->get();

        $infoguesthousasset  = DB::table('guesthous_infomation_asset')
            ->leftJoin('supplies_location_level','supplies_location_level.LOCATION_LEVEL_ID','=','guesthous_infomation_asset.LOCATION_LEVEL_ID')
            ->leftJoin('supplies_location_level_room','supplies_location_level_room.LEVEL_ROOM_ID','=','guesthous_infomation_asset.LEVEL_ROOM_ID')
            ->where('INFMATION_ID','=',$id)
            ->get();
        
        $infoguesthousrepair  = DB::table('guesthous_infomation_repair')->where('INFMATION_ID','=',$id)->get();

      

        return view('manager_guesthouse.guesthouserequestdetail_home',[
            'infoguesthouse' => $infoguesthouse,
            'inforpersons' => $inforperson,
            'infoguesthouspersons' => $infoguesthousperson,
            'infoguesthousoutsiders' => $infoguesthousoutsider,
            'infoguesthousassets' => $infoguesthousasset,
            'infoguesthousrepairs' => $infoguesthousrepair,
            'id' => $id,
            'type_check' => $type_check
        ]);
    }

//แก้ไขข้อมูลที่พัก
    public function guesthouserequestdetail_home_edit(Request $request,$id)
    {
        $type_check = 'checkperson';

        $infoperson = Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->orderBy('hrd_person.HR_FNAME', 'asc')    
        ->get();

        $infolocation = DB::table('supplies_location')->get();

     
        $infoguesthouse = DB::table('guesthous_infomation')
        ->leftJoin('guesthous_infomation_person','guesthous_infomation_person.INFMATION_ID','=','guesthous_infomation.INFMATION_ID')
        ->leftJoin('supplies_location','supplies_location.LOCATION_ID','=','guesthous_infomation.LOCATION_ID')
        ->leftJoin('supplies_location_level','supplies_location_level.LOCATION_ID','=','supplies_location.LOCATION_ID')
        ->leftJoin('supplies_location_level_room','supplies_location_level_room.LOCATION_LEVEL_ID','=','supplies_location_level.LOCATION_LEVEL_ID')
        ->leftJoin('hrd_person','hrd_person.ID','=','guesthous_infomation.INFMATION_HR_ID')
        ->where('guesthous_infomation.INFMATION_ID','=',$id)->first();

       
        return view('manager_guesthouse.guesthouserequestdetail_home_edit',[
            'id' => $id,
            'infopersons'=> $infoperson,
            'infolocations'=> $infolocation,
            'infoguesthouse'=> $infoguesthouse,
        ]);
    }


    public function guesthouserequestdetail_home_update(Request $request)
    { 
     
        $id = $request->ID;
        $addinfomation =  Guesthousinfomation::find($id); 
        $addinfomation->LOCATION_ID = $request->LOCATION_ID;
        $addinfomation->INFMATION_NAME = $request->INFMATION_NAME;
        $addinfomation->INFMATION_TYPE = $request->INFMATION_TYPE;
        $addinfomation->INFMATION_STATUS = $request->INFMATION_STATUS;
        $addinfomation->INFMATION_HR_ID = $request->INFMATION_HR_ID;
        $INFMATION_HR_NAME =DB::table('hrd_person')->where('ID','=',$request->INFMATION_HR_ID)->first();
        $addinfomation->INFMATION_HR_NAME = $INFMATION_HR_NAME->HR_FNAME.' '.$INFMATION_HR_NAME->HR_LNAME;

        if($request->hasFile('picture')){
            
            $file = $request->file('picture');  
            $contents = $file->openFile()->fread($file->getSize());
            $addinfomation->IMG = $contents;   

        }

        $addinfomation->INFMATION_HR_TEL = $request->INFMATION_HR_TEL;   
        $addinfomation->save();

        $type_check = 'checkperson';

        return redirect()->route('mguesthouse.guesthouserequestdetail_home',[
            'id' => $id,
            'type_check' => $type_check
        ]);    
      
    }

    public function guesthouserequestdetail_flathome(Request $request,$id,$level_id,$room_id,$type_check)
    {
        
        $infoguesthouse = DB::table('guesthous_infomation')
        ->leftJoin('guesthous_infomation_person','guesthous_infomation_person.INFMATION_ID','=','guesthous_infomation.INFMATION_ID')
        ->leftJoin('supplies_location','supplies_location.LOCATION_ID','=','guesthous_infomation.LOCATION_ID')
        ->leftJoin('supplies_location_level','supplies_location_level.LOCATION_ID','=','supplies_location.LOCATION_ID')
        ->leftJoin('supplies_location_level_room','supplies_location_level_room.LOCATION_LEVEL_ID','=','supplies_location_level.LOCATION_LEVEL_ID')
        ->leftJoin('hrd_person','hrd_person.ID','=','guesthous_infomation.INFMATION_HR_ID')
        ->where('supplies_location_level.LOCATION_LEVEL_ID','=',$level_id)
        ->where('supplies_location_level_room.LEVEL_ROOM_ID','=',$room_id)
        ->where('guesthous_infomation_person.INFMATION_PERSON_ID','=',$id)->first();

        $inforperson  =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->orderBy('hrd_person.HR_FNAME', 'asc')->get();

        $infoguesthousperson  = DB::table('guesthous_infomation_person')
            ->leftJoin('hrd_person','hrd_person.ID','=','guesthous_infomation_person.INFMATION_PERSON_HRID')
            ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
            ->where('INFMATION_ID','=',$id)
            ->where('LOCATION_LEVEL_ID','=',$level_id)
            ->where('LEVEL_ROOM_ID','=',$room_id)
        ->get();

        $infoguesthousoutsider  = DB::table('guesthous_infomation_outsider')
            ->leftJoin('hrd_person','hrd_person.ID','=','guesthous_infomation_outsider.INFMATION_OUTSIDER_RELATIONADD')
            ->leftJoin('supplies_location_level','supplies_location_level.LOCATION_LEVEL_ID','=','guesthous_infomation_outsider.LOCATION_LEVEL_ID')
            ->leftJoin('supplies_location_level_room','supplies_location_level_room.LEVEL_ROOM_ID','=','guesthous_infomation_outsider.LEVEL_ROOM_ID')
            ->where('INFMATION_ID','=',$id)
            ->where('guesthous_infomation_outsider.LOCATION_LEVEL_ID','=',$level_id)
            ->where('guesthous_infomation_outsider.LEVEL_ROOM_ID','=',$room_id)
        ->get();

        $infoguesthousasset  = DB::table('guesthous_infomation_asset')
            ->leftJoin('supplies_location_level','supplies_location_level.LOCATION_LEVEL_ID','=','guesthous_infomation_asset.LOCATION_LEVEL_ID')
            ->leftJoin('supplies_location_level_room','supplies_location_level_room.LEVEL_ROOM_ID','=','guesthous_infomation_asset.LEVEL_ROOM_ID')
            ->where('INFMATION_ID','=',$id)
            ->where('guesthous_infomation_asset.LOCATION_LEVEL_ID','=',$level_id)
            ->where('guesthous_infomation_asset.LEVEL_ROOM_ID','=',$room_id)
        ->get();
        $infoguesthousrepair  = DB::table('guesthous_infomation_repair')->where('INFMATION_ID','=',$id)->get();

      

        return view('manager_guesthouse.guesthouserequestdetail_flathome',[
            'infoguesthouse' => $infoguesthouse,
            'inforpersons' => $inforperson,
            'infoguesthouspersons' => $infoguesthousperson,
            'infoguesthousoutsiders' => $infoguesthousoutsider,
            'infoguesthousassets' => $infoguesthousasset,
            'infoguesthousrepairs' => $infoguesthousrepair,
            'type_check' => $type_check
        ]);
    }

    public function guesthouserequestdetail_flat_room(Request $request,$id,$level_id,$room_id,$type_check)
    {

        $infoguesthouse = DB::table('guesthous_infomation')
        ->leftJoin('supplies_location','supplies_location.LOCATION_ID','=','guesthous_infomation.LOCATION_ID')
        ->leftJoin('hrd_person','hrd_person.ID','=','guesthous_infomation.INFMATION_HR_ID')
        ->where('INFMATION_ID','=',$id)->first();


        $inforperson  =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->orderBy('hrd_person.HR_FNAME', 'asc')
        ->get();

        $infoguesthousperson  = DB::table('guesthous_infomation_person')
        ->leftJoin('hrd_person','hrd_person.ID','=','guesthous_infomation_person.INFMATION_PERSON_HRID')
        ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->where('INFMATION_ID','=',$id)->where('LOCATION_LEVEL_ID','=',$level_id)->where('LEVEL_ROOM_ID','=',$room_id)
        ->OrderBy('guesthous_infomation_person.INFMATION_PERSON_ID','desc')
        ->get();

        $infoguesthousoutsider  = DB::table('guesthous_infomation_outsider')
        ->leftJoin('hrd_person','hrd_person.ID','=','guesthous_infomation_outsider.INFMATION_OUTSIDER_RELATIONADD')
        ->where('INFMATION_ID','=',$id)->where('LOCATION_LEVEL_ID','=',$level_id)->where('LEVEL_ROOM_ID','=',$room_id)->get();


        $infoguesthousasset  = DB::table('guesthous_infomation_asset')->where('INFMATION_ID','=',$id)->where('LOCATION_LEVEL_ID','=',$level_id)->where('LEVEL_ROOM_ID','=',$room_id)->get();
        $infoguesthousrepair  = DB::table('guesthous_infomation_repair')->where('INFMATION_ID','=',$id)->where('LOCATION_LEVEL_ID','=',$level_id)->where('LEVEL_ROOM_ID','=',$room_id)->get();


        $levelname = DB::table('supplies_location_level')->where('LOCATION_LEVEL_ID','=',$level_id)->first();
        $roomname = DB::table('supplies_location_level_room')->where('LEVEL_ROOM_ID','=',$room_id)->first();


        return view('manager_guesthouse.guesthouserequestdetail_flat_room',[
                        'id' => $id,
                        'level_id' => $level_id,
                        'room_id' => $room_id,
                        'infoguesthouse' => $infoguesthouse,
                        'inforpersons' => $inforperson,
                        'infoguesthouspersons' => $infoguesthousperson,
                        'infoguesthousoutsiders' => $infoguesthousoutsider,
                        'infoguesthousassets' => $infoguesthousasset,
                        'infoguesthousrepairs' => $infoguesthousrepair,
                        'type_check' => $type_check,
                        'levelname' => $levelname,
                        'roomname' => $roomname,

        ]);
    }

    public function guesthouserequestdetail_flat_roomsaveperson(Request $request)
    { 
        
        $TYPESAVE = $request->TYPESAVE;

        $infmation_id = $request->INFMATION_ID;
        $status = $request->INFMATION_PERSON_STATUS;
        $level_id = $request->LOCATION_LEVEL_ID;
        $room_id = $request->LEVEL_ROOM_ID;

        $INFMATION_PERSONINDATE = $request->INFMATION_PERSON_INDATE;

        if($INFMATION_PERSONINDATE != ''){
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $INFMATION_PERSONINDATE)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0]; 
            
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $INFMATIONPERSONINDATE= $y_st."-".$m_st."-".$d_st;
            }else{
            $INFMATIONPERSONINDATE= null;
        }

        $addinfomation = new Guesthousinfomationperson(); 

            $addinfomation->LOCATION_LEVEL_ID = $request->LOCATION_LEVEL_ID;
            $addinfomation->LEVEL_ROOM_ID = $request->LEVEL_ROOM_ID;

        $addinfomation->INFMATION_ID = $request->INFMATION_ID;
        $addinfomation->INFMATION_PERSON_HRID = $request->INFMATION_PERSON_HRID;
        $addinfomation->INFMATION_PERSON_STATUS = $request->INFMATION_PERSON_STATUS;
        $addinfomation->INFMATION_PERSON_INDATE =  $INFMATIONPERSONINDATE;
  
        $addinfomation->save();

        $type_check = 'checkperson';

        $infolocat = DB::table('guesthous_infomation')->where('INFMATION_ID','=',$request->INFMATION_ID)->first();
        

        $LOCATIONID =  $infolocat->LOCATION_ID;

         //=======================update คำร้อง=================
         if($TYPESAVE == 'flat'){
            DB::table('guesthous_petition')
              ->where('PETITION_HR_ID', $request->INFMATION_PERSON_HRID)
              ->update(['LOCATION_ID' => $LOCATIONID,'LOCATION_LEVEL_ID' => $request->LOCATION_LEVEL_ID,'LEVEL_ROOM_ID' => $request->LEVEL_ROOM_ID,'PETITION_STATUS' => 'SUCCESS']);

         }else{
            DB::table('guesthous_petition')
            ->where('PETITION_HR_ID', $request->INFMATION_PERSON_HRID)
            ->update(['LOCATION_ID' => $LOCATIONID,'LOCATION_LEVEL_ID' => null,'LEVEL_ROOM_ID' => null,'PETITION_STATUS' => 'SUCCESS']);

         }


        if($TYPESAVE == 'flat'){

            return redirect()->route('mguesthouse.guesthouserequestdetail_flat_room',[
                'id' => $infmation_id,
                'level_id' => $request->LOCATION_LEVEL_ID,
                'room_id' => $request->LEVEL_ROOM_ID,
                'type_check' =>  $type_check
            ]);    


        }else{

            return redirect()->route('mguesthouse.guesthouserequestdetail_flat_room',[
                'id' => $infmation_id,
                'type_check' =>  $type_check,
                'level_id' => $level_id,
                'room_id' => $room_id,
            ]);    
        }
      
      
    }

    public function guesthouserequestdetail_flat_roomupdateperson(Request $request)
    { 
        
        $TYPESAVE = $request->TYPESAVE;

        $INFMATION_PERSONINDATE = $request->INFMATION_PERSON_INDATE;
        $INFMATION_PERSONOUTDATE = $request->INFMATION_PERSON_OUTDATE;

        if($INFMATION_PERSONINDATE != ''){
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $INFMATION_PERSONINDATE)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0]; 
            
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $INFMATIONPERSONINDATE= $y_st."-".$m_st."-".$d_st;
            }else{
            $INFMATIONPERSONINDATE= null;
        }

        if($INFMATION_PERSONOUTDATE != ''){
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $INFMATION_PERSONOUTDATE)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0]; 
            
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $INFMATIONPERSONOUTDATE= $y_st."-".$m_st."-".$d_st;
            }else{
            $INFMATIONPERSONOUTDATE= null;
        }

        $infmation_id = $request->INFMATION_ID;
        $status = $request->INFMATION_PERSON_STATUS;
        $level_id = $request->LOCATION_LEVEL_ID;
        $room_id = $request->LEVEL_ROOM_ID;

        $addinfomation = Guesthousinfomationperson::find($request->ID); 

        if($TYPESAVE == 'flat'){
            $addinfomation->LOCATION_LEVEL_ID = $request->LOCATION_LEVEL_ID;
            $addinfomation->LEVEL_ROOM_ID = $request->LEVEL_ROOM_ID;
        }

        
        $addinfomation->INFMATION_ID = $infmation_id;
        $addinfomation->INFMATION_PERSON_HRID = $request->INFMATION_PERSON_HRID;
        $addinfomation->INFMATION_PERSON_STATUS = $status;
        $addinfomation->INFMATION_PERSON_INDATE =  $INFMATIONPERSONINDATE;

        if ( $status == 1) {
            $addinfomation->INFMATION_PERSON_OUTDATE =  NULL;
        } else {
            $addinfomation->INFMATION_PERSON_OUTDATE =  $INFMATIONPERSONOUTDATE;
            DB::table('guesthous_petition')
            ->where('PETITION_HR_ID', $request->INFMATION_PERSON_HRID)
            ->update(['PETITION_STATUS' => 'MOVEOUT']);

            Guesthousinfomationoutsider::where('INFMATION_OUTSIDER_RELATIONADD', $request->INFMATION_PERSON_HRID)
            ->update(['STATUS' => 'false']);
        }
   
        if($request->hasFile('picture')){
         
            $file = $request->file('picture');  
            $contents = $file->openFile()->fread($file->getSize());
            $addinfomation->IMG = $contents;   
          
        }
        
        $addinfomation->save();
     
        $type_check = 'checkperson';

         //=======================update คำร้องกรีย้ายออก================= 

          if($status == 2){
            DB::table('guesthous_petition')
            ->where('PETITION_HR_ID', $request->INFMATION_PERSON_HRID)
            ->where('PETITION_TYPE','3')
            ->update(['PETITION_STATUS' => 'MOVEOUT']);
          }     
                          
        if($TYPESAVE == 'flat'){
            return redirect()->route('mguesthouse.guesthouserequestdetail_flat_room',[
                'id' => $infmation_id,
                'level_id' => $request->LOCATION_LEVEL_ID,
                'room_id' => $request->LEVEL_ROOM_ID,
                'type_check' =>  $type_check
            ]); 
        }else{
            return redirect()->route('mguesthouse.guesthouserequestdetail_flat_room',[
                'id' => $infmation_id,
                'type_check' =>  $type_check,
                'level_id' => $level_id,
                'room_id' => $room_id,
            ]);    
        }            
    }

    //===============================แก้ไข===============

    public function guesthouserequestdetail_flat_edit(Request $request,$id)
    {

        $infoperson = Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->orderBy('hrd_person.HR_FNAME', 'asc')    
        ->get();

        $infolocation = DB::table('supplies_location')->get();

        $infoguesthouse= DB::table('guesthous_infomation')->where('INFMATION_ID','=',$id)->first();

        return view('manager_guesthouse.guesthouserequestdetail_flat_edit',[
            'id' => $id,
            'infopersons'=> $infoperson,
            'infolocations'=> $infolocation, 
            'infoguesthouse'=> $infoguesthouse, 
        ]);
    }


    public function guesthouserequestdetail_flat_update(Request $request)
    { 
        $id = $request->ID;
     
        $addinfomation =  Guesthousinfomation::find($id); 
        $addinfomation->LOCATION_ID = $request->LOCATION_ID;
        $addinfomation->INFMATION_NAME = $request->INFMATION_NAME;
        $addinfomation->INFMATION_TYPE = $request->INFMATION_TYPE;
        $addinfomation->INFMATION_STATUS = $request->INFMATION_STATUS;
        $addinfomation->INFMATION_HR_ID = $request->INFMATION_HR_ID;
        $INFMATION_HR_NAME =DB::table('hrd_person')->where('ID','=',$request->INFMATION_HR_ID)->first();
        $addinfomation->INFMATION_HR_NAME = $INFMATION_HR_NAME->HR_FNAME.' '.$INFMATION_HR_NAME->HR_LNAME;

        if($request->hasFile('picture')){
          
            
            $file = $request->file('picture');  
            $contents = $file->openFile()->fread($file->getSize());
            $addinfomation->IMG = $contents;   
          
        }
        
        $addinfomation->INFMATION_HR_TEL = $request->INFMATION_HR_TEL;   
        $addinfomation->save();

        $type_check = 'checkperson';

        return redirect()->route('mguesthouse.guesthouserequestdetail_flat',[
            'id' => $id,
            'type_check'=>$type_check
        ]);    
      
    }


   

    //======================================================================
    public function guesthouserequest(Request $request)
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
            $infopetition = DB::table('guesthous_petition')
            ->select('guesthous_petition.created_at','PETITION_STATUS','PETITION_TYPE','HR_FNAME','HR_LNAME','PETITION_HR_TEL','LOCATION_NAME','LOCATION_LEVEL_NAME','LEVEL_ROOM_NAME','PETITION_ID','INFMATION_HR_NAME','INFMATION_NAME')
            ->leftJoin('supplies_location','supplies_location.LOCATION_ID','=','guesthous_petition.LOCATION_ID')
            ->leftJoin('supplies_location_level','supplies_location_level.LOCATION_LEVEL_ID','=','guesthous_petition.LOCATION_LEVEL_ID')
            ->leftJoin('supplies_location_level_room','supplies_location_level_room.LEVEL_ROOM_ID','=','guesthous_petition.LEVEL_ROOM_ID')
            ->leftJoin('hrd_person','guesthous_petition.PETITION_HR_ID','=','hrd_person.ID')
            ->leftJoin('guesthous_infomation','guesthous_petition.LOCATION_ID','=','guesthous_infomation.LOCATION_ID')
            ->where(function($q) use ($search){
                $q->where('HR_FNAME','like','%'.$search.'%');
                $q->orwhere('HR_LNAME','like','%'.$search.'%');
                $q->orwhere('PETITION_HR_TEL','like','%'.$search.'%');
                $q->orwhere('LOCATION_NAME','like','%'.$search.'%');
                $q->orwhere('LOCATION_LEVEL_NAME','like','%'.$search.'%');
                $q->orwhere('LEVEL_ROOM_NAME','like','%'.$search.'%');
                })
                ->WhereBetween('guesthous_petition.created_at',[$from.' 00:00:00',$to.' 23:59:00']) 
            ->orderBy('guesthous_petition.created_at', 'DESC')
            ->get();
        }else{
            $infopetition = DB::table('guesthous_petition')
            ->select('guesthous_petition.created_at','PETITION_STATUS','PETITION_TYPE','HR_FNAME','HR_LNAME','PETITION_HR_TEL','LOCATION_NAME','LOCATION_LEVEL_NAME','LEVEL_ROOM_NAME','PETITION_ID','INFMATION_HR_NAME','INFMATION_NAME')
            ->leftJoin('supplies_location','supplies_location.LOCATION_ID','=','guesthous_petition.LOCATION_ID')
            ->leftJoin('supplies_location_level','supplies_location_level.LOCATION_LEVEL_ID','=','guesthous_petition.LOCATION_LEVEL_ID')
            ->leftJoin('supplies_location_level_room','supplies_location_level_room.LEVEL_ROOM_ID','=','guesthous_petition.LEVEL_ROOM_ID')
            ->leftJoin('hrd_person','guesthous_petition.PETITION_HR_ID','=','hrd_person.ID')
            ->leftJoin('guesthous_infomation','guesthous_petition.LOCATION_ID','=','guesthous_infomation.LOCATION_ID')
            ->where('PETITION_STATUS','=',$status)
            ->where(function($q) use ($search){
                $q->where('HR_FNAME','like','%'.$search.'%');
                $q->orwhere('HR_LNAME','like','%'.$search.'%');
                $q->orwhere('PETITION_HR_TEL','like','%'.$search.'%');
                $q->orwhere('LOCATION_NAME','like','%'.$search.'%');
                $q->orwhere('LOCATION_LEVEL_NAME','like','%'.$search.'%');
                $q->orwhere('LEVEL_ROOM_NAME','like','%'.$search.'%');
                })
                ->WhereBetween('guesthous_petition.created_at',[$from.' 00:00:00',$to.' 23:59:00']) 
            ->orderBy('guesthous_petition.created_at', 'DESC')
            ->get();
        }
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $year_id = $yearbudget;
        $infostatus = DB::table('guesthous_petition_status')->get();
        return view('manager_guesthouse.guesthouserequest',[
            'infopetitions' => $infopetition,
            'infostatuss' => $infostatus,
            'displaydate_bigen'=> $displaydate_bigen, 
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'budgets' =>  $budget,
            'year_id'=>$year_id
        ]);
    }

    public function guesthouserequestsearch(Request $request)
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

           $from = date($displaydate_bigen);
           $to = date($displaydate_end);   
        
        
        
        
        if($status == null){

    
            $infopetition = DB::table('guesthous_petition')
            ->select('guesthous_petition.created_at','PETITION_STATUS','PETITION_TYPE','HR_FNAME','HR_LNAME','PETITION_HR_TEL','LOCATION_NAME','LOCATION_LEVEL_NAME','LEVEL_ROOM_NAME','PETITION_ID','INFMATION_HR_NAME','INFMATION_NAME')
            ->leftJoin('supplies_location','supplies_location.LOCATION_ID','=','guesthous_petition.LOCATION_ID')
            ->leftJoin('supplies_location_level','supplies_location_level.LOCATION_LEVEL_ID','=','guesthous_petition.LOCATION_LEVEL_ID')
            ->leftJoin('supplies_location_level_room','supplies_location_level_room.LEVEL_ROOM_ID','=','guesthous_petition.LEVEL_ROOM_ID')
            ->leftJoin('hrd_person','guesthous_petition.PETITION_HR_ID','=','hrd_person.ID')
            ->leftJoin('guesthous_infomation','guesthous_petition.LOCATION_ID','=','guesthous_infomation.LOCATION_ID')
            ->where(function($q) use ($search){
                $q->where('HR_FNAME','like','%'.$search.'%');
                $q->orwhere('HR_LNAME','like','%'.$search.'%');
                $q->orwhere('PETITION_HR_TEL','like','%'.$search.'%');
                $q->orwhere('LOCATION_NAME','like','%'.$search.'%');
                $q->orwhere('LOCATION_LEVEL_NAME','like','%'.$search.'%');
                $q->orwhere('LEVEL_ROOM_NAME','like','%'.$search.'%');
                })
                ->WhereBetween('guesthous_petition.created_at',[$from.' 00:00:00',$to.' 23:59:00']) 
            ->orderBy('guesthous_petition.created_at', 'DESC')
            ->get();



        }else{


            $infopetition = DB::table('guesthous_petition')
            ->select('guesthous_petition.created_at','PETITION_STATUS','PETITION_TYPE','HR_FNAME','HR_LNAME','PETITION_HR_TEL','LOCATION_NAME','LOCATION_LEVEL_NAME','LEVEL_ROOM_NAME','PETITION_ID','INFMATION_HR_NAME','INFMATION_NAME')
            ->leftJoin('supplies_location','supplies_location.LOCATION_ID','=','guesthous_petition.LOCATION_ID')
            ->leftJoin('supplies_location_level','supplies_location_level.LOCATION_LEVEL_ID','=','guesthous_petition.LOCATION_LEVEL_ID')
            ->leftJoin('supplies_location_level_room','supplies_location_level_room.LEVEL_ROOM_ID','=','guesthous_petition.LEVEL_ROOM_ID')
            ->leftJoin('hrd_person','guesthous_petition.PETITION_HR_ID','=','hrd_person.ID')
            ->leftJoin('guesthous_infomation','guesthous_petition.LOCATION_ID','=','guesthous_infomation.LOCATION_ID')
            ->where('PETITION_STATUS','=',$status)
            ->where(function($q) use ($search){
                $q->where('HR_FNAME','like','%'.$search.'%');
                $q->orwhere('HR_LNAME','like','%'.$search.'%');
                $q->orwhere('PETITION_HR_TEL','like','%'.$search.'%');
                $q->orwhere('LOCATION_NAME','like','%'.$search.'%');
                $q->orwhere('LOCATION_LEVEL_NAME','like','%'.$search.'%');
                $q->orwhere('LEVEL_ROOM_NAME','like','%'.$search.'%');
                })
                ->WhereBetween('guesthous_petition.created_at',[$from.' 00:00:00',$to.' 23:59:00']) 
            ->orderBy('guesthous_petition.created_at', 'DESC')
            ->get();

        }
        
        
     


        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $year_id = $yearbudget;

        $infostatus = DB::table('guesthous_petition_status')->get();



        return view('manager_guesthouse.guesthouserequest',[
            'infopetitions' => $infopetition,
            'infostatuss' => $infostatus,
            'displaydate_bigen'=> $displaydate_bigen, 
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'budgets' =>  $budget,
            'year_id'=>$year_id
        ]);

    }



    public function guesthouserequestexcel(Request $request,$yearbudget,$datebigin,$dateend,$status,$search)
    {
       
    
            if($search=='null'){
                $search="";
            }else{
                $search     = $search;
            }


            
            if($status=='null'){
                $status="";
            }else{
                $status     = $status;
            }
        
        
        $from = $datebigin;
        $to = $dateend;  
        
        if($status == null){
            $infopetition = DB::table('guesthous_petition')
            ->select('guesthous_petition.created_at','PETITION_STATUS','PETITION_TYPE','HR_FNAME','HR_LNAME','PETITION_HR_TEL','LOCATION_NAME','LOCATION_LEVEL_NAME','LEVEL_ROOM_NAME','PETITION_ID','INFMATION_HR_NAME','INFMATION_NAME')
            ->leftJoin('supplies_location','supplies_location.LOCATION_ID','=','guesthous_petition.LOCATION_ID')
            ->leftJoin('supplies_location_level','supplies_location_level.LOCATION_LEVEL_ID','=','guesthous_petition.LOCATION_LEVEL_ID')
            ->leftJoin('supplies_location_level_room','supplies_location_level_room.LEVEL_ROOM_ID','=','guesthous_petition.LEVEL_ROOM_ID')
            ->leftJoin('hrd_person','guesthous_petition.PETITION_HR_ID','=','hrd_person.ID')
            ->leftJoin('guesthous_infomation','guesthous_petition.LOCATION_ID','=','guesthous_infomation.LOCATION_ID')
            ->where(function($q) use ($search){
                $q->where('HR_FNAME','like','%'.$search.'%');
                $q->orwhere('HR_LNAME','like','%'.$search.'%');
                $q->orwhere('PETITION_HR_TEL','like','%'.$search.'%');
                $q->orwhere('LOCATION_NAME','like','%'.$search.'%');
                $q->orwhere('LOCATION_LEVEL_NAME','like','%'.$search.'%');
                $q->orwhere('LEVEL_ROOM_NAME','like','%'.$search.'%');
                })
                ->WhereBetween('guesthous_petition.created_at',[$from.' 00:00:00',$to.' 23:59:00']) 
            ->orderBy('guesthous_petition.created_at', 'DESC')
            ->get();
        }else{
            $infopetition = DB::table('guesthous_petition')
            ->select('guesthous_petition.created_at','PETITION_STATUS','PETITION_TYPE','HR_FNAME','HR_LNAME','PETITION_HR_TEL','LOCATION_NAME','LOCATION_LEVEL_NAME','LEVEL_ROOM_NAME','PETITION_ID','INFMATION_HR_NAME','INFMATION_NAME')
            ->leftJoin('supplies_location','supplies_location.LOCATION_ID','=','guesthous_petition.LOCATION_ID')
            ->leftJoin('supplies_location_level','supplies_location_level.LOCATION_LEVEL_ID','=','guesthous_petition.LOCATION_LEVEL_ID')
            ->leftJoin('supplies_location_level_room','supplies_location_level_room.LEVEL_ROOM_ID','=','guesthous_petition.LEVEL_ROOM_ID')
            ->leftJoin('hrd_person','guesthous_petition.PETITION_HR_ID','=','hrd_person.ID')
            ->leftJoin('guesthous_infomation','guesthous_petition.LOCATION_ID','=','guesthous_infomation.LOCATION_ID')
            ->where('PETITION_STATUS','=',$status)
            ->where(function($q) use ($search){
                $q->where('HR_FNAME','like','%'.$search.'%');
                $q->orwhere('HR_LNAME','like','%'.$search.'%');
                $q->orwhere('PETITION_HR_TEL','like','%'.$search.'%');
                $q->orwhere('LOCATION_NAME','like','%'.$search.'%');
                $q->orwhere('LOCATION_LEVEL_NAME','like','%'.$search.'%');
                $q->orwhere('LEVEL_ROOM_NAME','like','%'.$search.'%');
                })
                ->WhereBetween('guesthous_petition.created_at',[$from.' 00:00:00',$to.' 23:59:00']) 
            ->orderBy('guesthous_petition.created_at', 'DESC')
            ->get();
        }
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $year_id = $yearbudget;
        $infostatus = DB::table('guesthous_petition_status')->get();
        return view('manager_guesthouse.guesthouserequest_excel',[
            'infopetitions' => $infopetition,
            'infostatuss' => $infostatus,
            'displaydate_bigen'=> $datebigin, 
            'displaydate_end'=> $dateend,
            'status_check'=> $status,
            'search'=> $search,
            'budgets' =>  $budget,
            'year_id'=>$year_id
        ]);
    }



    public function guesthouseinfomation_add()
    { 
        $infoperson = Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->orderBy('hrd_person.HR_FNAME', 'asc')    
        ->get();

        $infolocation = DB::table('supplies_location')->get();

        return view('manager_guesthouse.guesthouseinfomation_add',[
            'infopersons'=> $infoperson,
            'infolocations'=> $infolocation 
        ]);
    }



    public function guesthouseinfomation_save(Request $request)
    { 
     
        $addinfomation = new Guesthousinfomation(); 
        $addinfomation->LOCATION_ID = $request->LOCATION_ID;
        $addinfomation->INFMATION_NAME = $request->INFMATION_NAME;
        $addinfomation->INFMATION_TYPE = $request->INFMATION_TYPE;
        $addinfomation->INFMATION_STATUS = $request->INFMATION_STATUS;
        $addinfomation->INFMATION_HR_ID = $request->INFMATION_HR_ID;
          
        $INFMATION_HR_NAME =DB::table('hrd_person')->where('ID','=',$request->INFMATION_HR_ID)->first();
        $addinfomation->INFMATION_HR_NAME = $INFMATION_HR_NAME->HR_FNAME.' '.$INFMATION_HR_NAME->HR_LNAME;

        $addinfomation->INFMATION_HR_TEL = $request->INFMATION_HR_TEL;  
        

        if($request->hasFile('picture')){
            
            $file = $request->file('picture');  
            $contents = $file->openFile()->fread($file->getSize());
            $addinfomation->IMG = $contents;   
          
        }
        

        $addinfomation->save();

        return redirect()->route('mguesthouse.guesthouserequestdetail');    
      
    }

//--------------------------------------------
    public function guesthouseproblem(Request $request)
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
            $infoproblem = DB::table('guesthous_problem')
            ->select('PROBLEM_ID','guesthous_problem.created_at','PROBLEM_TYPE','HR_FNAME','HR_LNAME','PROBLEM_HR_TEL','LOCATION_NAME','LOCATION_LEVEL_NAME','LEVEL_ROOM_NAME','PROBLEM_NAME','PROBLEM_STATUS','INFMATION_HR_NAME','INFMATION_NAME','PROBLEM_IMG')
            ->leftJoin('supplies_location','supplies_location.LOCATION_ID','=','guesthous_problem.LOCATION_ID')
            ->leftJoin('supplies_location_level','supplies_location_level.LOCATION_LEVEL_ID','=','guesthous_problem.LOCATION_LEVEL_ID')
            ->leftJoin('supplies_location_level_room','supplies_location_level_room.LEVEL_ROOM_ID','=','guesthous_problem.LEVEL_ROOM_ID')
            ->leftJoin('hrd_person','guesthous_problem.PROBLEM_HR_ID','=','hrd_person.ID')
            ->leftJoin('guesthous_infomation','guesthous_problem.LOCATION_ID','=','guesthous_infomation.LOCATION_ID')
            ->where(function($q) use ($search){
                $q->where('HR_FNAME','like','%'.$search.'%');
                $q->orwhere('HR_LNAME','like','%'.$search.'%');
                $q->orwhere('PROBLEM_HR_TEL','like','%'.$search.'%');
                $q->orwhere('LOCATION_NAME','like','%'.$search.'%');
                $q->orwhere('LOCATION_LEVEL_NAME','like','%'.$search.'%');
                $q->orwhere('LEVEL_ROOM_NAME','like','%'.$search.'%');
                $q->orwhere('PROBLEM_NAME','like','%'.$search.'%');
                })
                ->WhereBetween('guesthous_problem.created_at',[$from.' 00:00:00',$to.' 23:59:00']) 
            ->orderBy('guesthous_problem.created_at', 'DESC')
            ->get();
        }else{
            $infoproblem = DB::table('guesthous_problem')
            ->select('PROBLEM_ID','guesthous_problem.created_at','PROBLEM_TYPE','HR_FNAME','HR_LNAME','PROBLEM_HR_TEL','LOCATION_NAME','LOCATION_LEVEL_NAME','LEVEL_ROOM_NAME','PROBLEM_NAME','PROBLEM_STATUS','INFMATION_HR_NAME','INFMATION_NAME','PROBLEM_IMG')
            ->leftJoin('supplies_location','supplies_location.LOCATION_ID','=','guesthous_problem.LOCATION_ID')
            ->leftJoin('supplies_location_level','supplies_location_level.LOCATION_LEVEL_ID','=','guesthous_problem.LOCATION_LEVEL_ID')
            ->leftJoin('supplies_location_level_room','supplies_location_level_room.LEVEL_ROOM_ID','=','guesthous_problem.LEVEL_ROOM_ID')
            ->leftJoin('hrd_person','guesthous_problem.PROBLEM_HR_ID','=','hrd_person.ID')
            ->leftJoin('guesthous_infomation','guesthous_problem.LOCATION_ID','=','guesthous_infomation.LOCATION_ID')
            ->where('PROBLEM_STATUS','=',$status)
            ->where(function($q) use ($search){
                $q->where('HR_FNAME','like','%'.$search.'%');
                $q->orwhere('HR_LNAME','like','%'.$search.'%');
                $q->orwhere('PROBLEM_HR_TEL','like','%'.$search.'%');
                $q->orwhere('LOCATION_NAME','like','%'.$search.'%');
                $q->orwhere('LOCATION_LEVEL_NAME','like','%'.$search.'%');
                $q->orwhere('LEVEL_ROOM_NAME','like','%'.$search.'%');
                $q->orwhere('PROBLEM_NAME','like','%'.$search.'%');
                })
                ->WhereBetween('guesthous_problem.created_at',[$from.' 00:00:00',$to.' 23:59:00']) 
            ->orderBy('guesthous_problem.created_at', 'DESC')
            ->get();
        }
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $year_id = $yearbudget;
        $infostatus = DB::table('guesthous_problem_status')->get();
        return view('manager_guesthouse.guesthouseproblem',[
            'infoproblems' => $infoproblem,
            'infostatuss' => $infostatus,
            'displaydate_bigen'=> $displaydate_bigen, 
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'budgets' =>  $budget,
            'year_id'=>$year_id
            
        ]);
    }



    public function guesthouseproblemsearch(Request $request)
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

           $from = date($displaydate_bigen);
           $to = date($displaydate_end);   
        
        
        
        
        if($status == null){

            $infoproblem = DB::table('guesthous_problem')
            ->select('PROBLEM_ID','guesthous_problem.created_at','PROBLEM_TYPE','HR_FNAME','HR_LNAME','PROBLEM_HR_TEL','LOCATION_NAME','LOCATION_LEVEL_NAME','LEVEL_ROOM_NAME','PROBLEM_NAME','PROBLEM_STATUS','INFMATION_HR_NAME','INFMATION_NAME','PROBLEM_IMG')
            ->leftJoin('supplies_location','supplies_location.LOCATION_ID','=','guesthous_problem.LOCATION_ID')
            ->leftJoin('supplies_location_level','supplies_location_level.LOCATION_LEVEL_ID','=','guesthous_problem.LOCATION_LEVEL_ID')
            ->leftJoin('supplies_location_level_room','supplies_location_level_room.LEVEL_ROOM_ID','=','guesthous_problem.LEVEL_ROOM_ID')
            ->leftJoin('hrd_person','guesthous_problem.PROBLEM_HR_ID','=','hrd_person.ID')
            ->leftJoin('guesthous_infomation','guesthous_problem.LOCATION_ID','=','guesthous_infomation.LOCATION_ID')
            ->where(function($q) use ($search){
                $q->where('HR_FNAME','like','%'.$search.'%');
                $q->orwhere('HR_LNAME','like','%'.$search.'%');
                $q->orwhere('PROBLEM_HR_TEL','like','%'.$search.'%');
                $q->orwhere('LOCATION_NAME','like','%'.$search.'%');
                $q->orwhere('LOCATION_LEVEL_NAME','like','%'.$search.'%');
                $q->orwhere('LEVEL_ROOM_NAME','like','%'.$search.'%');
                $q->orwhere('PROBLEM_NAME','like','%'.$search.'%');
                })
                ->WhereBetween('guesthous_problem.created_at',[$from.' 00:00:00',$to.' 23:59:00']) 
            ->orderBy('guesthous_problem.created_at', 'DESC')
            ->get();


        }else{


            $infoproblem = DB::table('guesthous_problem')
            ->select('PROBLEM_ID','guesthous_problem.created_at','PROBLEM_TYPE','HR_FNAME','HR_LNAME','PROBLEM_HR_TEL','LOCATION_NAME','LOCATION_LEVEL_NAME','LEVEL_ROOM_NAME','PROBLEM_NAME','PROBLEM_STATUS','INFMATION_HR_NAME','INFMATION_NAME','PROBLEM_IMG')
            ->leftJoin('supplies_location','supplies_location.LOCATION_ID','=','guesthous_problem.LOCATION_ID')
            ->leftJoin('supplies_location_level','supplies_location_level.LOCATION_LEVEL_ID','=','guesthous_problem.LOCATION_LEVEL_ID')
            ->leftJoin('supplies_location_level_room','supplies_location_level_room.LEVEL_ROOM_ID','=','guesthous_problem.LEVEL_ROOM_ID')
            ->leftJoin('hrd_person','guesthous_problem.PROBLEM_HR_ID','=','hrd_person.ID')
            ->leftJoin('guesthous_infomation','guesthous_problem.LOCATION_ID','=','guesthous_infomation.LOCATION_ID')
            ->where('PROBLEM_STATUS','=',$status)
            ->where(function($q) use ($search){
                $q->where('HR_FNAME','like','%'.$search.'%');
                $q->orwhere('HR_LNAME','like','%'.$search.'%');
                $q->orwhere('PROBLEM_HR_TEL','like','%'.$search.'%');
                $q->orwhere('LOCATION_NAME','like','%'.$search.'%');
                $q->orwhere('LOCATION_LEVEL_NAME','like','%'.$search.'%');
                $q->orwhere('LEVEL_ROOM_NAME','like','%'.$search.'%');
                $q->orwhere('PROBLEM_NAME','like','%'.$search.'%');
                })
                ->WhereBetween('guesthous_problem.created_at',[$from.' 00:00:00',$to.' 23:59:00']) 
            ->orderBy('guesthous_problem.created_at', 'DESC')
            ->get();



        }
        
        
     


        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $year_id = $yearbudget;

        $infostatus = DB::table('guesthous_problem_status')->get();


        return view('manager_guesthouse.guesthouseproblem',[
            'infoproblems' => $infoproblem,
            'infostatuss' => $infostatus,
            'displaydate_bigen'=> $displaydate_bigen, 
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'budgets' =>  $budget,
            'year_id'=>$year_id
            
        ]);
    }

    public function guesthouseproblem_edit(Request $request,$idref)
    {             
       
        $infoproblem = DB::table('guesthous_problem')->where('PROBLEM_ID','=',$idref)->first();

        $infolocation = DB::table('guesthous_infomation')->get();
        $infolocationlevel = DB::table('supplies_location_level')->get();
        $infolocationlevelroom= DB::table('supplies_location_level_room')->get();
        $infotype = DB::table('guesthous_problem_type')->get();
        $infoper = DB::table('hrd_person')->get();

        return view('manager_guesthouse.guesthouseproblem_edit ',[
            'infolocations' => $infolocation,
            'infolocationlevels' => $infolocationlevel,
            'infolocationlevelrooms' => $infolocationlevelroom,
            'infoproblem' => $infoproblem,
            'infotypes'=>$infotype,
            'infopers' => $infoper,
        ]);
    }
    
    public function guesthouseproblem_update(Request $request)
    {
        $id_pro = $request->PROBLEM_ID;
        $id_hr =  $request->INFMATION_HR_ID;
        
        $update = Guesthousproblem::find($id_pro);
        $update->PROBLEM_NAME = $request->PROBLEM_NAME;  
        $update->LOCATION_ID = $request->LOCATION_ID;     
        $update->LOCATION_LEVEL_ID = $request->LOCATION_LEVEL_ID;
        $update->LEVEL_ROOM_ID = $request->LEVEL_ROOM_ID;

        $id_u = DB::table('hrd_person')->where('ID','=',$id_hr)->first();

        $update->PROBLEM_HR_ID =  $id_u->ID;
        $update->PROBLEM_HR_NAME =  $id_u->HR_FNAME.''.$id_u->HR_LNAME;

        $update->PROBLEM_TYPE = $request->PROBLEM_TYPE;
        $update->PROBLEM_PICE = $request->PROBLEM_PICE;
       
        $update->PROBLEM_HR_TEL = $request->PROBLEM_HR_TEL;
        if($request->hasFile('picture')){            
            $file = $request->file('picture');  
            $contents = $file->openFile()->fread($file->getSize());
            $update->PROBLEM_IMG = $contents;             
        }
        $update->save();
      
        return redirect()->route('mguesthouse.guesthouseproblem');    
       
    }   
    public function guesthouseproblem_succes($idref)
    {     
        $infoproblem = DB::table('guesthous_problem')
        ->leftJoin('supplies_location','supplies_location.LOCATION_ID','=','guesthous_problem.LOCATION_ID')
        ->leftJoin('supplies_location_level','supplies_location_level.LOCATION_LEVEL_ID','=','guesthous_problem.LOCATION_LEVEL_ID')
        ->leftJoin('supplies_location_level_room','supplies_location_level_room.LEVEL_ROOM_ID','=','guesthous_problem.LEVEL_ROOM_ID')
        ->leftJoin('hrd_person','guesthous_problem.PROBLEM_HR_ID','=','hrd_person.ID')
        ->leftJoin('guesthous_problem_type','guesthous_problem.PROBLEM_TYPE','=','guesthous_problem_type.PROBLEM_TYPE_ID')
        ->where('PROBLEM_ID','=',$idref)
        ->first();
        
       
        return view('manager_guesthouse.guesthouseproblem_succes',[
           'infoproblem' => $infoproblem
        ]);
    }
        
    public function guesthouseproblem_updatesucces(Request $request)
    { 
       
        $id = $request->ID;

        $PROBLEM_NAME = $request->PROBLEM_NAME;
        $LOCATION_NAME = $request->LOCATION_NAME;
        $LOCATION_LEVEL_NAME = $request->LOCATION_LEVEL_NAME;
        $LEVEL_ROOM_NAME = $request->LEVEL_ROOM_NAME;
        $PROBLEM_TYPE_NAME = $request->PROBLEM_TYPE_NAME;
        $PROBLEM_HR_TEL = $request->PROBLEM_HR_TEL;

        $personid = $request->PERSON_ID;
        $person = DB::table('hrd_person')->where('ID','=',$personid)->first();
        $infoper = $person->HR_FNAME.'  '.$person->HR_LNAME;

        $update = Guesthousproblem::find($id); 
        $update->PROBLEM_STATUS = 'SUCCESS';  
    
        $update->save();

        function DateThailinecar($strDate)
        {
          $strYear = date("Y",strtotime($strDate))+543;
          $strMonth= date("n",strtotime($strDate));
          $strDay= date("j",strtotime($strDate));
  
          $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
          $strMonthThai=$strMonthCut[$strMonth];
          return "$strDay $strMonthThai $strYear";
          }

        $header = "การแก้ปัญหาบ้านพัก";
       
       $message = $header.
           "\n"."วันที่ : " . DateThailinecar(date('Y-m-d')) .          
           "\n"."ปัญหาที่พบ : " . $PROBLEM_NAME .
           "\n"."อาคาร : " . $LOCATION_NAME .
           "\n"."ชั้น : " . $LOCATION_LEVEL_NAME .
           "\n"."ห้อง : " . $LEVEL_ROOM_NAME .
           "\n"."ปัญหาประเภท : " . $PROBLEM_TYPE_NAME .
            "\n"."ผู้แจ้ง : " .  $infoper.                       
           "\n"."โทร : " . $PROBLEM_HR_TEL.
           "\n"."สถานะ :  เรียบร้อยแล้ว";
      

           ///=====แจ้งกลุ่มผู้ตรวจสอบ

           $name2 = DB::table('line_token')->where('ID_LINE_TOKEN','=','9')->first();        
           $test2 =$name2->LINE_TOKEN;
            $chOne2 = curl_init();
           curl_setopt( $chOne2, CURLOPT_URL, "https://notify-api.line.me/api/notify");
           curl_setopt( $chOne2, CURLOPT_SSL_VERIFYHOST, 0);
           curl_setopt( $chOne2, CURLOPT_SSL_VERIFYPEER, 0);
           curl_setopt( $chOne2, CURLOPT_POST, 1);
           curl_setopt( $chOne2, CURLOPT_POSTFIELDS, $message);
           curl_setopt( $chOne2, CURLOPT_POSTFIELDS, "message=$message");
           curl_setopt( $chOne2, CURLOPT_FOLLOWLOCATION, 1);
           $headers2 = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$test2.'', );
           curl_setopt($chOne2, CURLOPT_HTTPHEADER, $headers2);
           curl_setopt( $chOne2, CURLOPT_RETURNTRANSFER, 1);
           $result2 = curl_exec( $chOne2 );
           if(curl_error($chOne2)) { echo 'error:' . curl_error($chOne2); }
           else { $result_ = json_decode($result2, true);
           echo "status : ".$result_['status']; echo "message : ". $result_['message']; }
           curl_close( $chOne2 );

            return redirect()->route('mguesthouse.guesthouseproblem');    
        
      
      
    }
 

    public function guesthouseproblem_cancel(Request $request,$idref)
    {             
       
        $infoproblem = DB::table('guesthous_problem')->where('PROBLEM_ID','=',$idref)->first();

        $infolocation = DB::table('guesthous_infomation')->get();
        $infolocationlevel = DB::table('supplies_location_level')->get();
        $infolocationlevelroom= DB::table('supplies_location_level_room')->get();
        $infotype = DB::table('guesthous_problem_type')->get();
        $infoper = DB::table('hrd_person')->get();

        return view('manager_guesthouse.guesthouseproblem_cancel ',[
            'infolocations' => $infolocation,
            'infolocationlevels' => $infolocationlevel,
            'infolocationlevelrooms' => $infolocationlevelroom,
            'infoproblem' => $infoproblem,
            'infotypes'=>$infotype,
            'infopers' => $infoper,
        ]);
    }


    public function guesthouseproblem_updatecancel(Request $request)
    {
        $id_pro = $request->PROBLEM_ID;
               
        $update = Guesthousproblem::find($id_pro);
        $update->PROBLEM_STATUS = $request->PROBLEM_STATUS; 
      
        $update->save();
      
        return redirect()->route('mguesthouse.guesthouseproblem');    
       
    } 

    //===========================เพิ่มข้อมูลตารางลูก==============

    public function guesthouserequestdetail_saveperson(Request $request)
    { 
        
        $TYPESAVE = $request->TYPESAVE;

        $infmation_id = $request->INFMATION_ID;
        $status = $request->INFMATION_PERSON_STATUS;
        $level_id = $request->LOCATION_LEVEL_ID;
        $room_id = $request->LEVEL_ROOM_ID;

        $INFMATION_PERSONINDATE = $request->INFMATION_PERSON_INDATE;

        if($INFMATION_PERSONINDATE != ''){
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $INFMATION_PERSONINDATE)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0]; 
            
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $INFMATIONPERSONINDATE= $y_st."-".$m_st."-".$d_st;
            }else{
            $INFMATIONPERSONINDATE= null;
        }

        $addinfomation = new Guesthousinfomationperson(); 

            $addinfomation->LOCATION_LEVEL_ID = $request->LOCATION_LEVEL_ID;
            $addinfomation->LEVEL_ROOM_ID = $request->LEVEL_ROOM_ID;

        $addinfomation->INFMATION_ID = $request->INFMATION_ID;
        $addinfomation->INFMATION_PERSON_HRID = $request->INFMATION_PERSON_HRID;
        $addinfomation->INFMATION_PERSON_STATUS = $request->INFMATION_PERSON_STATUS;
        $addinfomation->INFMATION_PERSON_INDATE =  $INFMATIONPERSONINDATE;
  
        $addinfomation->save();

        $type_check = 'checkperson';

        $infolocat = DB::table('guesthous_infomation')->where('INFMATION_ID','=',$request->INFMATION_ID)->first();
        

        $LOCATIONID =  $infolocat->LOCATION_ID;

         //=======================update คำร้อง=================
         if($TYPESAVE == 'flat'){
            DB::table('guesthous_petition')
              ->where('PETITION_HR_ID', $request->INFMATION_PERSON_HRID)
              ->update(['LOCATION_ID' => $LOCATIONID,'LOCATION_LEVEL_ID' => $request->LOCATION_LEVEL_ID,'LEVEL_ROOM_ID' => $request->LEVEL_ROOM_ID,'PETITION_STATUS' => 'SUCCESS']);

         }else{
            DB::table('guesthous_petition')
            ->where('PETITION_HR_ID', $request->INFMATION_PERSON_HRID)
            ->update(['LOCATION_ID' => $LOCATIONID,'LOCATION_LEVEL_ID' => null,'LEVEL_ROOM_ID' => null,'PETITION_STATUS' => 'SUCCESS']);

         }


        if($TYPESAVE == 'flat'){

            return redirect()->route('mguesthouse.guesthouserequestdetail_flat_room',[
                'id' => $infmation_id,
                'level_id' => $request->LOCATION_LEVEL_ID,
                'room_id' => $request->LEVEL_ROOM_ID,
                'type_check' =>  $type_check
            ]);    


        }else{

            return redirect()->route('mguesthouse.guesthouserequestdetail_home',[
                'id' => $infmation_id,
                'type_check' =>  $type_check,
                'level_id' => $level_id,
                'room_id' => $room_id,
            ]);    
        }
      
      
    }


    public function guesthouserequestdetail_updateperson(Request $request)
    { 
        
        $TYPESAVE = $request->TYPESAVE;

        $INFMATION_PERSONINDATE = $request->INFMATION_PERSON_INDATE;
        $INFMATION_PERSONOUTDATE = $request->INFMATION_PERSON_OUTDATE;

        if($INFMATION_PERSONINDATE != ''){
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $INFMATION_PERSONINDATE)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0]; 
            
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $INFMATIONPERSONINDATE= $y_st."-".$m_st."-".$d_st;
            }else{
            $INFMATIONPERSONINDATE= null;
        }

        if($INFMATION_PERSONOUTDATE != ''){
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $INFMATION_PERSONOUTDATE)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0]; 
            
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $INFMATIONPERSONOUTDATE= $y_st."-".$m_st."-".$d_st;
            }else{
            $INFMATIONPERSONOUTDATE= null;
        }

        $infmation_id = $request->INFMATION_ID;
        $status = $request->INFMATION_PERSON_STATUS;
        $level_id = $request->LOCATION_LEVEL_ID;
        $room_id = $request->LEVEL_ROOM_ID;

        $addinfomation = Guesthousinfomationperson::find($request->ID); 

        if($TYPESAVE == 'flat'){
            $addinfomation->LOCATION_LEVEL_ID = $request->LOCATION_LEVEL_ID;
            $addinfomation->LEVEL_ROOM_ID = $request->LEVEL_ROOM_ID;
        }

        
        $addinfomation->INFMATION_ID = $infmation_id;
        $addinfomation->INFMATION_PERSON_HRID = $request->INFMATION_PERSON_HRID;
        $addinfomation->INFMATION_PERSON_STATUS = $status;
        $addinfomation->INFMATION_PERSON_INDATE =  $INFMATIONPERSONINDATE;

        if ( $status == 1) {
            $addinfomation->INFMATION_PERSON_OUTDATE =  NULL;
        } else {
            $addinfomation->INFMATION_PERSON_OUTDATE =  $INFMATIONPERSONOUTDATE;
            DB::table('guesthous_petition')
            ->where('PETITION_HR_ID', $request->INFMATION_PERSON_HRID)
            ->update(['PETITION_STATUS' => 'MOVEOUT']);

            Guesthousinfomationoutsider::where('INFMATION_OUTSIDER_RELATIONADD', $request->INFMATION_PERSON_HRID)
            ->update(['STATUS' => 'false']);
        }
   
        if($request->hasFile('picture')){
            
            $file = $request->file('picture');  
            $contents = $file->openFile()->fread($file->getSize());
            $addinfomation->IMG = $contents;   
          
        }
        
        $addinfomation->save();
     
        $type_check = 'checkperson';

         //=======================update คำร้องกรีย้ายออก================= 

          if($status == 2){
            DB::table('guesthous_petition')
            ->where('PETITION_HR_ID', $request->INFMATION_PERSON_HRID)
            ->where('PETITION_TYPE','3')
            ->update(['PETITION_STATUS' => 'MOVEOUT']);
          }     
                          
        if($TYPESAVE == 'flat'){
            return redirect()->route('mguesthouse.guesthouserequestdetail_flat_room',[
                'id' => $infmation_id,
                'level_id' => $request->LOCATION_LEVEL_ID,
                'room_id' => $request->LEVEL_ROOM_ID,
                'type_check' =>  $type_check
            ]); 
        }else{
            return redirect()->route('mguesthouse.guesthouserequestdetail_home',[
                'id' => $infmation_id,
                'type_check' =>  $type_check,
                'level_id' => $level_id,
                'room_id' => $room_id,
            ]);    
        }            
    }


    public function guesthouserequestdetail_destroyperson(Request $request,$id,$typesave,$level_id,$room_id,$idref)
    { 
        
        Guesthousinfomationperson::destroy($idref);   
  
        $type_check = 'checkperson';

        if($typesave == 'flat'){

            return redirect()->route('mguesthouse.guesthouserequestdetail_flat_room',[
                'id' => $id,
                'level_id' => $level_id,
                'room_id' => $room_id,
                'type_check' =>  $type_check
            ]);    


        }else{

            return redirect()->route('mguesthouse.guesthouserequestdetail_home',[
                'id' => $id,
                'level_id' => $level_id,
                'room_id' => $room_id,
                'type_check' =>  $type_check
            ]);    
        }
      
      
    }

  
    //=================================================================================================


    public function guesthouserequestdetail_saveoutsider(Request $request)
    { 

        $TYPESAVE = $request->TYPESAVE;

          $infmation_id = $request->INFMATION_ID;
          $status = $request->INFMATION_PERSON_STATUS;
          $level_id = $request->LOCATION_LEVEL_ID;
          $room_id = $request->LEVEL_ROOM_ID;

        $addinfomation = new Guesthousinfomationoutsider(); 
        
        
      
            $addinfomation->LOCATION_LEVEL_ID = $request->LOCATION_LEVEL_ID;
            $addinfomation->LEVEL_ROOM_ID = $request->LEVEL_ROOM_ID;

        $addinfomation->INFMATION_ID = $request->INFMATION_ID;
        $addinfomation->INFMATION_OUTSIDER_NAME = $request->INFMATION_OUTSIDER_NAME;
        $addinfomation->INFMATION_OUTSIDER_RELATION = $request->INFMATION_OUTSIDER_RELATION;
        $addinfomation->INFMATION_OUTSIDER_RELATIONADD = $request->INFMATION_OUTSIDER_RELATIONADD;
  
        $addinfomation->save();

        $type_check = 'checkoutsider';

      
        if($TYPESAVE == 'flat'){
  
            return redirect()->route('mguesthouse.guesthouserequestdetail_flat_room',[
                'id' => $request->INFMATION_ID,
                'level_id' => $request->LOCATION_LEVEL_ID,
                'room_id' => $request->LEVEL_ROOM_ID,
                'type_check' =>  $type_check
            ]);    


        }else{

            return redirect()->route('mguesthouse.guesthouserequestdetail_home',[
               
                'id' => $infmation_id,
                'type_check' =>  $type_check,
                'level_id' => $level_id,
                'room_id' => $room_id,
            ]);    
        }
      
    }



      //---------------------
      public function guesthouserequestdetail_updateoutsider(Request $request)
      { 
          
          $TYPESAVE = $request->TYPESAVE;
          $infmation_id = $request->INFMATION_ID;
          $status = $request->INFMATION_PERSON_STATUS;
          $level_id = $request->LOCATION_LEVEL_ID;
          $room_id = $request->LEVEL_ROOM_ID;


          $addinfomation = Guesthousinfomationoutsider::find($request->ID); 
  
          if($TYPESAVE == 'flat'){
            $addinfomation->LOCATION_LEVEL_ID = $request->LOCATION_LEVEL_ID;
            $addinfomation->LEVEL_ROOM_ID = $request->LEVEL_ROOM_ID;
        }

        $addinfomation->INFMATION_ID = $request->INFMATION_ID;
        $addinfomation->INFMATION_OUTSIDER_NAME = $request->INFMATION_OUTSIDER_NAME;
        $addinfomation->INFMATION_OUTSIDER_RELATION = $request->INFMATION_OUTSIDER_RELATION;
        $addinfomation->INFMATION_OUTSIDER_RELATIONADD = $request->INFMATION_OUTSIDER_RELATIONADD;
  
        $addinfomation->save();

        $type_check = 'checkoutsider';
  
  
  
          if($TYPESAVE == 'flat'){
  
              return redirect()->route('mguesthouse.guesthouserequestdetail_flat_room',[
                  'id' => $request->INFMATION_ID,
                  'level_id' => $request->LOCATION_LEVEL_ID,
                  'room_id' => $request->LEVEL_ROOM_ID,
                  'type_check' =>  $type_check
              ]);    
  
  
          }else{
  
              return redirect()->route('mguesthouse.guesthouserequestdetail_home',[
                 
                  'id' => $infmation_id,
                  'type_check' =>  $type_check,
                  'level_id' => $level_id,
                  'room_id' => $room_id,
              ]);    
          }
        
        
      }
  
  
      public function guesthouserequestdetail_destroyoutsider(Request $request,$id,$typesave,$level_id,$room_id,$idref)
      { 
          
        Guesthousinfomationoutsider::destroy($idref);   
    
          $type_check = 'checkoutsider';
  
          if($typesave == 'flat'){
  
              return redirect()->route('mguesthouse.guesthouserequestdetail_flat_room',[
                  'id' => $id,
                  'level_id' => $level_id,
                  'room_id' => $room_id,
                  'type_check' =>  $type_check
              ]);    
  
  
          }else{
  
              return redirect()->route('mguesthouse.guesthouserequestdetail_home',[
                  'id' => $id,
                  'level_id' => $level_id,
                'room_id' => $room_id,
                  'type_check' =>  $type_check
              ]);    
          }
        
        
      }

      //===========================================================


    public function guesthouserequestdetail_saveasset(Request $request)
    { 
     
        $TYPESAVE = $request->TYPESAVE;

        $infmation_id = $request->INFMATION_ID;
        $status = $request->INFMATION_PERSON_STATUS;
        $level_id = $request->LOCATION_LEVEL_ID;
        $room_id = $request->LEVEL_ROOM_ID;

        $INFMATION_ASSETBUYDATE = $request->INFMATION_ASSET_BUYDATE;

        if($INFMATION_ASSETBUYDATE != ''){
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $INFMATION_ASSETBUYDATE)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0]; 
            
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $INFMATIONASSETBUYDATE= $y_st."-".$m_st."-".$d_st;
            }else{
            $INFMATIONASSETBUYDATE= null;
        }


        $addinfomation = new Guesthousinfomationasset(); 

     
            $addinfomation->LOCATION_LEVEL_ID = $request->LOCATION_LEVEL_ID;
            $addinfomation->LEVEL_ROOM_ID = $request->LEVEL_ROOM_ID;

        $addinfomation->INFMATION_ID = $request->INFMATION_ID;
        $addinfomation->INFMATION_ASSET_NUMBER = $request->INFMATION_ASSET_NUMBER;
        $addinfomation->INFMATION_ASSET_NAME = $request->INFMATION_ASSET_NAME;
        $addinfomation->INFMATION_ASSET_VALUE = $request->INFMATION_ASSET_VALUE;
        $addinfomation->INFMATION_ASSET_BUYDATE = $INFMATIONASSETBUYDATE;
        $addinfomation->INFMATION_ASSET_STATUS = $request->INFMATION_ASSET_STATUS;   
        $addinfomation->save();

        $type_check = 'checkasset';

        if($TYPESAVE == 'flat'){

            return redirect()->route('mguesthouse.guesthouserequestdetail_flat_room',[
                'id' => $request->INFMATION_ID,
                'level_id' => $request->LOCATION_LEVEL_ID,
                'room_id' => $request->LEVEL_ROOM_ID,
                'type_check' =>  $type_check
            ]);    


        }else{

            return redirect()->route('mguesthouse.guesthouserequestdetail_home',[
                 'id' => $infmation_id,
                  'type_check' =>  $type_check,
                  'level_id' => $level_id,
                  'room_id' => $room_id,
            ]);    
        }
      
    }



    public function guesthouserequestdetail_updateasset(Request $request)
    { 
        
        $TYPESAVE = $request->TYPESAVE;

        $infmation_id = $request->INFMATION_ID;
        $status = $request->INFMATION_PERSON_STATUS;
        $level_id = $request->LOCATION_LEVEL_ID;
        $room_id = $request->LEVEL_ROOM_ID;
        
        $INFMATION_ASSETBUYDATE = $request->INFMATION_ASSET_BUYDATE;

        if($INFMATION_ASSETBUYDATE != ''){
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $INFMATION_ASSETBUYDATE)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0]; 
            
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $INFMATIONASSETBUYDATE= $y_st."-".$m_st."-".$d_st;
            }else{
            $INFMATIONASSETBUYDATE= null;
        }

        $INFMATIONASSET_DISDATE = $request->INFMATION_ASSET_DISDATE;

        if($INFMATIONASSET_DISDATE != ''){
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $INFMATIONASSET_DISDATE)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0]; 
            
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $INFMATIONASSETDISDATE= $y_st."-".$m_st."-".$d_st;
            }else{
            $INFMATIONASSETDISDATE= null;
        }

        $status = $request->INFMATION_ASSET_STATUS; 

        $addinfomation = Guesthousinfomationasset::find($request->ID); 

        if($TYPESAVE == 'flat'){
            $addinfomation->LOCATION_LEVEL_ID = $request->LOCATION_LEVEL_ID;
            $addinfomation->LEVEL_ROOM_ID = $request->LEVEL_ROOM_ID;
        }

        

        if ( $status == 1) {
            $addinfomation->INFMATION_ASSET_DISDATE =  '';
        } elseif( $status == 2) {
            $addinfomation->INFMATION_ASSET_DISDATE =  '';
        } else{
            $addinfomation->INFMATION_ASSET_DISDATE =  $status;
        }

        $addinfomation->INFMATION_ID = $request->INFMATION_ID;
        $addinfomation->INFMATION_ASSET_NUMBER = $request->INFMATION_ASSET_NUMBER;
        $addinfomation->INFMATION_ASSET_NAME = $request->INFMATION_ASSET_NAME;
        $addinfomation->INFMATION_ASSET_VALUE = $request->INFMATION_ASSET_VALUE;
        $addinfomation->INFMATION_ASSET_BUYDATE = $INFMATIONASSETBUYDATE;
        $addinfomation->INFMATION_ASSET_STATUS = $status;   
        $addinfomation->save();

        $type_check = 'checkasset';


        if($TYPESAVE == 'flat'){

            return redirect()->route('mguesthouse.guesthouserequestdetail_flat_room',[
                'id' => $request->INFMATION_ID,
                'level_id' => $request->LOCATION_LEVEL_ID,
                'room_id' => $request->LEVEL_ROOM_ID,
                'type_check' =>  $type_check
            ]);    

        }else{

            return redirect()->route('mguesthouse.guesthouserequestdetail_home',[
                'id' => $infmation_id,
                  'type_check' =>  $type_check,
                  'level_id' => $level_id,
                  'room_id' => $room_id,
            ]);    
        }
      
      
    }


    public function guesthouserequestdetail_destroyasset(Request $request,$id,$typesave,$level_id,$room_id,$idref)
    { 
        
        Guesthousinfomationasset::destroy($idref);   
  
        $type_check = 'checkasset';

        if($typesave == 'flat'){

            return redirect()->route('mguesthouse.guesthouserequestdetail_flat_room',[
                'id' => $id,
                'level_id' => $level_id,
                'room_id' => $room_id,
                'type_check' =>  $type_check
            ]);    


        }else{

            return redirect()->route('mguesthouse.guesthouserequestdetail_home',[
                'id' => $id,
                'level_id' => $level_id,
                'room_id' => $room_id,
                'type_check' =>  $type_check
            ]);    
        }
      
      
    }

    //===========================================================


    public function guesthouserequestdetail_saverepair(Request $request)
    { 

        $TYPESAVE = $request->TYPESAVE;

        $infmation_id = $request->INFMATION_ID;
        $status = $request->INFMATION_PERSON_STATUS;
        $level_id = $request->LOCATION_LEVEL_ID;
        $room_id = $request->LEVEL_ROOM_ID;

        $INFMATION_REPAIRDATE =  $request->INFMATION_REPAIR_DATE;

        if($INFMATION_REPAIRDATE != ''){
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $INFMATION_REPAIRDATE)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0]; 
            
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $INFMATIONREPAIRDATE= $y_st."-".$m_st."-".$d_st;
            }else{
            $INFMATIONREPAIRDATE= null;
        }

     
        $addinfomation = new Guesthousinfomationrepair(); 

            $addinfomation->LOCATION_LEVEL_ID = $request->LOCATION_LEVEL_ID;
            $addinfomation->LEVEL_ROOM_ID = $request->LEVEL_ROOM_ID;

        $addinfomation->INFMATION_ID = $request->INFMATION_ID;
        $addinfomation->INFMATION_REPAIR_NAME = $request->INFMATION_REPAIR_NAME;
        $addinfomation->INFMATION_REPAIR_VALUE = $request->INFMATION_REPAIR_VALUE;
        $addinfomation->INFMATION_REPAIR_DATE =  $INFMATIONREPAIRDATE;
 
        $addinfomation->save();

        $type_check = 'checkrepair';

        if($TYPESAVE == 'flat'){

            return redirect()->route('mguesthouse.guesthouserequestdetail_flat_room',[
                'id' => $request->INFMATION_ID,
                'level_id' => $request->LOCATION_LEVEL_ID,
                'room_id' => $request->LEVEL_ROOM_ID,
                'type_check' =>  $type_check
            ]);    


        }else{

            return redirect()->route('mguesthouse.guesthouserequestdetail_home',[
                'id' => $infmation_id,
                'type_check' =>  $type_check,
                'level_id' => $level_id,
                'room_id' => $room_id,
            ]);    
        }
      
    }


    public function guesthouserequestdetail_updaterepair(Request $request)
    { 
        
        $TYPESAVE = $request->TYPESAVE;
        $infmation_id = $request->INFMATION_ID;
        $status = $request->INFMATION_PERSON_STATUS;
        $level_id = $request->LOCATION_LEVEL_ID;
        $room_id = $request->LEVEL_ROOM_ID;
        
        $INFMATION_REPAIRDATE =  $request->INFMATION_REPAIR_DATE;

        if($INFMATION_REPAIRDATE != ''){
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $INFMATION_REPAIRDATE)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0]; 
            
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $INFMATIONREPAIRDATE= $y_st."-".$m_st."-".$d_st;
            }else{
            $INFMATIONREPAIRDATE= null;
        }

        $addinfomation = Guesthousinfomationrepair::find($request->ID); 

        if($TYPESAVE == 'flat'){
            $addinfomation->LOCATION_LEVEL_ID = $request->LOCATION_LEVEL_ID;
            $addinfomation->LEVEL_ROOM_ID = $request->LEVEL_ROOM_ID;
        }

        $addinfomation->INFMATION_ID = $request->INFMATION_ID;
        $addinfomation->INFMATION_REPAIR_NAME = $request->INFMATION_REPAIR_NAME;
        $addinfomation->INFMATION_REPAIR_VALUE = $request->INFMATION_REPAIR_VALUE;
        $addinfomation->INFMATION_REPAIR_DATE =  $INFMATIONREPAIRDATE;
 
        $addinfomation->save();

        $type_check = 'checkrepair';



        if($TYPESAVE == 'flat'){

            return redirect()->route('mguesthouse.guesthouserequestdetail_flat_room',[
                'id' => $request->INFMATION_ID,
                'level_id' => $request->LOCATION_LEVEL_ID,
                'room_id' => $request->LEVEL_ROOM_ID,
                'type_check' =>  $type_check
            ]);    


        }else{

            return redirect()->route('mguesthouse.guesthouserequestdetail_home',[
                'id' => $infmation_id,
                'type_check' =>  $type_check,
                'level_id' => $level_id,
                'room_id' => $room_id,
            ]);    
        }
      
      
    }


    public function guesthouserequestdetail_destroyrepair(Request $request,$id,$typesave,$level_id,$room_id,$idref)
    { 
        
        Guesthousinfomationrepair::destroy($idref);   
  
        $type_check = 'checkrepair';

        if($typesave == 'flat'){

            return redirect()->route('mguesthouse.guesthouserequestdetail_flat_room',[
                'id' => $id,
                'level_id' => $level_id,
                'room_id' => $room_id,
                'type_check' =>  $type_check
            ]);    


        }else{

            return redirect()->route('mguesthouse.guesthouserequestdetail_home',[
                'id' => $id,
                'type_check' =>  $type_check,
                'level_id' => $level_id,
                'room_id' => $room_id,
            ]);    
        }
      
      
    }

    //===========================================================

    public function guesthouserequest_edit(Request $request,$idref)
    {

        $infolocation = DB::table('supplies_location')->get();
        $infolocationlevel = DB::table('supplies_location_level')->get();
        $infolocationlevelroom= DB::table('supplies_location_level_room')->get();

        $infopetition = DB::table('guesthous_petition')
        ->leftjoin('hrd_person','hrd_person.ID','=','guesthous_petition.PETITION_HR_ID')
        ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
        ->where('PETITION_ID','=',$idref)->first();
    
        return view('manager_guesthouse.guesthouserequest_edit',[
            'infolocations' => $infolocation,
            'infolocationlevels' => $infolocationlevel,
            'infolocationlevelrooms' => $infolocationlevelroom,
            'infopetition' => $infopetition,


        ]);
    }




    public function guesthouserequest_update(Request $request)
    {

      
        $id = $request->PETITION_ID;
        $addpetition = Guesthouspetition::find($id);
        $addpetition->PETITION_HR_TEL = $request->PETITION_HR_TEL;
        $addpetition->PETITION_TYPE = $request->PETITION_TYPE;
        $addpetition->PETITION_ADD = $request->PETITION_ADD;  
        $addpetition->PETITION_REMARK = $request->PETITION_REMARK;  
        $addpetition->save();

        return redirect()->route('mguesthouse.guesthouserequest');    
    }




    public function guesthouserequest_destroy($idref) {

        Guesthouspetition::destroy($idref);
          return redirect()->route('mguesthouse.guesthouserequest');
      }


      //รายละเอียดค่าน้ำค่าไฟ
    public function guesthouseutilitybills()
    {   
        $infoinfomation  = DB::table('guesthous_infomation')->orderBy('INFMATION_TYPE', 'asc')->get();

        $infomaitonwaterhead = DB::table('guesthous_water_h')->get();
        $infomaitonelechead = DB::table('guesthous_elec_h')->get();

        return view('manager_guesthouse.guesthouseutilitybills',[
            'infoinfomations'=>  $infoinfomation,
            'infomaitonwaterheads'=>  $infomaitonwaterhead,
            'infomaitonelecheads'=>  $infomaitonelechead,
          
        ]);
    }


    public function guesthouseutilitybills_addwater()
    {   
        $infoinfomation  = DB::table('guesthous_infomation')->orderBy('INFMATION_TYPE', 'asc')->get();
        $budget = DB::table('budget_year')->get();

        $year_id  = date('Y')+543;
        $m_budget = date('m');

        return view('manager_guesthouse.guesthouseutilitybills_addwater',[
            'infoinfomations' => $infoinfomation,
            'year_id' => $year_id,
            'm_budget' => $m_budget,
            'budgets' => $budget,
          
        ]);
    }


    

    public function guesthouseutilitybills_savewater(Request $request)
    {       
        $addinfomationhead = new Guesthouswaterh(); 
        $addinfomationhead->GUEST_WATER_H_YEAR = $request->YEAR_ID;
        $addinfomationhead->GUEST_WATER_H_MONTH = $request->MONTH_ID;
        $addinfomationhead->save();
    }


    public function guesthouseutilitybills_addelec()
    {   
        $infoinfomation  = DB::table('guesthous_infomation')->orderBy('INFMATION_TYPE', 'asc')->get();
        $budget = DB::table('budget_year')->get();

        $year_id  = date('Y')+543;
        $m_budget = date('m');

        return view('manager_guesthouse.guesthouseutilitybills_addelec',[
            'infoinfomations' => $infoinfomation,
            'year_id' => $year_id,
            'm_budget' => $m_budget,
            'budgets' => $budget,
        ]);
    }


    

}

