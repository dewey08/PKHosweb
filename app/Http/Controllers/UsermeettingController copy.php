<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\support\Facades\Hash;
use Illuminate\support\Facades\Validator;
use App\Models\User;
use App\Models\Department;
use App\Models\Departmentsub;
use App\Models\Departmentsubsub;
use App\Models\Products_vendor;
use App\Models\Status;
use App\Models\Position;
use App\Models\Products_request;
use App\Models\Products_request_sub;
use App\Models\Products;
use App\Models\Products_type;
use App\Models\Product_group;
use App\Models\Product_unit;
use App\Models\Products_category;
use App\Models\Leave_leader;
use App\Models\Leave_leader_sub;
use App\Models\Book_type;
use App\Models\Book_import_fam;
use App\Models\Book_signature;
use App\Models\Bookrep;
use App\Models\Book_objective;
use App\Models\Book_senddep;
use App\Models\Book_senddep_sub;
use App\Models\Book_send_person;
use App\Models\Book_sendteam;
use App\Models\Bookrepdelete;
use App\Models\Car_status;
use App\Models\Car_index;
use App\Models\Article_status;
use App\Models\Car_type;
use App\Models\Product_brand;
use App\Models\Product_color;
use App\Models\Department_sub_sub;
use App\Models\Article;
use App\Models\Land;
use App\Models\Building;
use App\Models\Product_budget;
use App\Models\Product_method;
use App\Models\Product_buy;
use App\Models\Building_level;
use App\Models\Building_level_room;
use App\Models\Building_room_type;
use App\Models\Building_room_status;
use App\Models\Building_room_list;
use App\Models\Food_list;
use App\Models\Meeting_list;
use App\Models\Meeting_objective;
use App\Models\Budget_year;
use App\Models\Meeting_service;
use App\Models\Meeting_service_list;
use App\Models\Meeting_service_food;
use DataTables;
use Auth;

class UsermeettingControllerCopy extends Controller
{  
    public static function refnumber()
{
    $year = date('Y');
    $maxnumber = DB::table('products_request')->max('request_id');  
    if($maxnumber != '' ||  $maxnumber != null){
        $refmax = DB::table('products_request')->where('request_id','=',$maxnumber)->first();  
        if($refmax->request_code != '' ||  $refmax->request_code != null){
        $maxref = substr($refmax->request_code, -5)+1;
        }else{
        $maxref = 1;
        }
        $ref = str_pad($maxref, 6, "0", STR_PAD_LEFT);
    }else{
        $ref = '000001';
    }
    $ye = date('Y')+543;
    $y = substr($ye, -2);
    $refnumber = 'REP'.'-'.$ref;
    return $refnumber;
} 
public function meetting_dashboard(Request $request)
{   
    $data['q'] = $request->query('q');
    $query = User::select('users.*')
    ->where(function ($query) use ($data){
        $query->where('pname','like','%'.$data['q'].'%');
        $query->orwhere('fname','like','%'.$data['q'].'%');
        $query->orwhere('lname','like','%'.$data['q'].'%');
        $query->orwhere('tel','like','%'.$data['q'].'%');
        $query->orwhere('username','like','%'.$data['q'].'%');
    });
    $data['users'] = $query->orderBy('id','DESC')->paginate(10);
    $data['department'] = Department::get();
    $data['department_sub'] = Departmentsub::get();
    $data['department_sub_sub'] = Departmentsubsub::get();
    $data['position'] = Position::get();
    $data['status'] = Status::get();
    return view('user_meetting.meetting_dashboard',$data);
}

public function meetting_index(Request $request)
{   
    // $data['q'] = $request->query('q');
    // $query = User::select('users.*')
    // ->where(function ($query) use ($data){
    //     $query->where('pname','like','%'.$data['q'].'%');
    //     $query->orwhere('fname','like','%'.$data['q'].'%');
    //     $query->orwhere('lname','like','%'.$data['q'].'%');
    //     $query->orwhere('tel','like','%'.$data['q'].'%');
    //     $query->orwhere('username','like','%'.$data['q'].'%');
    // });
    // $data['users'] = $query->orderBy('id','DESC')->get();
    $idsubtrue = Auth::user()->dep_subsubtrueid;
    // dd($idsubtrue);
    $data['meeting_service'] = Meeting_service::where('meeting_debsubsubtrue_id','=',$idsubtrue)->get();

    return view('user_meetting.meetting_index',$data);
}
public function meetting_add(Request $request,$iduser)
{   
    $data['building_level_room'] = Building_level_room::where('room_type','!=','1')->get(); 

    $data['building_data'] = Building::leftJoin('building_level','building_data.building_id','=','building_level.building_id')
    ->leftJoin('building_level_room','building_level_room.building_level_id','=','building_level.building_level_id')
    ->where('room_type','!=','1')
    ->orderBy('room_id','DESC')
    ->get(); 
    
    return view('user_meetting.meetting_add',$data);
}

public function meetting_choose(Request $request,$iduser,$id)
{   
    $data['building_level_room'] = Building_level_room::where('room_type','!=','1')->where('room_id','=',$id)->first(); 

    $data['building_data'] = Building::leftJoin('building_level','building_data.building_id','=','building_level.building_id')
    ->leftJoin('building_level_room','building_level_room.building_level_id','=','building_level.building_level_id')
    ->where('room_type','!=','1')
    ->orderBy('room_id','DESC')
    ->get(); 
    $data['building_room_list'] = Building_room_list::get();
    $data['food_list'] = Food_list::get();
    $data['meeting_list'] = Meeting_list::get();
    $data['meeting_objective'] = Meeting_objective::get();
    $data['budget_year'] = Budget_year::orderBy('leave_year_id','DESC')->get();

    // $data = Car_index::leftJoin('car_status','car_index.car_index_status','=','car_status.car_status_code')->get();

    return view('user_meetting.meetting_choose',$data);
}
public function meetting_save(Request $request)
{    
    // dd($request->all());
    // $count_check = Building_level::where('building_level_name','=',$request->building_level_name)->where('building_id','=',$request->building_id)->count();  
    // dd($count_check);
    // if ($count_check == 0 ) {

        $userid = $request->iduser;
        $add = new Meeting_service();
        $add->meetting_title = $request->input('meetting_title'); 
        $add->meetting_year = $request->input('meetting_year');
        $add->meetting_person_qty = $request->input('meetting_person_qty');
        $add->meetting_target = $request->input('meetting_target');
        $add->meetting_status = 'REQUEST';

        //คนร้องขอ + หน่วยงาน
        $uid = $request->input('iduser');
        if ($uid != '') {
            $usave = DB::table('users')->where('id','=',$uid)->first();
            $add->meeting_user_id = $usave->id; 
            $add->meeting_user_name = $usave->fname .' '.$usave->lname;
            $add->meeting_debsubsub_id = $usave->dep_subsubtrueid; 
            $add->meeting_debsubsub_name = $usave->dep_subsubtruename;  
        }else{
            $add->meeting_user_id = '';
            $add->meeting_user_name = '';
            $add->meeting_debsubsub_id = '';
            $add->meeting_debsubsub_name = '';
        }

        $roid = $request->input('room_id');
        if ($roid != '') {
            $rosave = DB::table('building_level_room')->where('room_id','=',$roid)->first();
            $add->room_id = $rosave->room_id; 
            $add->room_name = $rosave->room_name; 
        }else{
            $add->room_id = '';
            $add->room_name = '';
        }

        $objid = $request->input('meeting_objective_id');
        if ($objid != '') {
            $objsave = DB::table('meeting_objective')->where('meeting_objective_id','=',$objid)->first();
            $add->meeting_objective_id = $objsave->meeting_objective_id; 
            $add->meeting_objective_name = $objsave->meeting_objective_name; 
        }else{
            $add->meeting_objective_id = '';
            $add->meeting_objective_name = '';
        }

        $add->meeting_tel = $request->input('meeting_tel');
        $add->meeting_date_begin = $request->input('meeting_date_begin');
        $add->meeting_date_end = $request->input('meeting_date_end');
        $add->meeting_time_begin = $request->input('meeting_time_begin');
        $add->meeting_time_end = $request->input('meeting_time_end'); 
        $add->save(); 

        $id_elec =  Meeting_service::max('meeting_id');

        if($request->MEETTINGLIST_ID != '' || $request->MEETTINGLIST_ID != null){

        $MEETTINGLIST_ID = $request->MEETTINGLIST_ID;
        $MEETTINGLIST_QTY = $request->MEETTINGLIST_QTY;
                           
        $number =count($MEETTINGLIST_ID);
        $count = 0;
        for($count = 0; $count< $number; $count++)
        { 
            $infolist = DB::table('meeting_list')->where('meeting_list_id','=',$MEETTINGLIST_ID[$count])->first();

            $add_sub = new Meeting_service_list();
            $add_sub->meeting_id = $id_elec;      
            $add_sub->meeting_service_list_id = $infolist->meeting_list_id;  
            $add_sub->meeting_service_list_name = $infolist->meeting_list_name; 
            $add_sub->meeting_service_list_qty = $MEETTINGLIST_QTY[$count];                           
            $add_sub->save(); 
        }
    }
        // $idservice = Meeting_service::max('meeting_id');

        // if ($request->meeting_service_list_id != '' || $request->meeting_service_list_id != null) {

        //     $meeting_service_list_id    = $request->meeting_service_list_id;
        //     $meeting_service_list_qty = $request->meeting_service_list_qty;

        //     $number2 = count($meeting_service_list_id);
        //     $count_2  = 0;
        //     for ($count_2 = 0; $count_2 < $number2; $count_2++) {

        //         $listid = $meeting_service_list_id[$count_2];

        //         $infolist = DB::table('meeting_list')->where('meeting_list_id', '=', $listid)->first();

        //         $add_2                    = new Meeting_service_list();
        //         $add_2->meeting_id        = $idservice[$count_2];
        //         $add_2->meeting_service_list_id   = $infolist->meeting_list_id;
        //         $add_2->meeting_service_list_name   = $infolist->meeting_list_name;
        //         $add_2->meeting_service_list_qty  = $meeting_service_list_qty[$count_2];
        //         $add_2->save();

        //     }
        // }

        // if ($request->meeting_service_food_id != '' || $request->meeting_service_food_id != null) {

        //     $meeting_service_food_id    = $request->meeting_service_food_id;
        //     $meeting_service_food_qty = $request->meeting_service_food_qty;

        //     $number3 = count($meeting_service_food_id);
        //     $count_3  = 0;
        //     for ($count_3 = 0; $count_3 < $number3; $count_3++) {

        //         $serid = $meeting_service_food_id[$count_3];

        //         $infofood = DB::table('food_list')->where('food_list_id', '=', $serid)->first();

        //         $add_3                    = new Meeting_service_food();
        //         $add_3->meeting_id        = $idservice;
        //         $add_3->meeting_service_food_id   = $infofood->food_list_id;
        //         $add_3->meeting_service_food_name   = $infofood->food_list_name;
        //         $add_3->meeting_service_food_qty  = $meeting_service_food_qty[$count_3];
        //         $add_3->save();

        //     }
        // }

        return response()->json([
            'status'     => '200',
            // 'iduser'     => $userid
            ]);
    // } else {
    //     return response()->json([
    //         'status'     => '0'
    //         ]);
    // }             
}

public function meetting_calenda(Request $request)
{   
    // $data['building_level_room'] = Building_level_room::where('room_type','!=','1')->where('room_id','=',$id)->first(); 

    $data['building_data'] = Building::leftJoin('building_level','building_data.building_id','=','building_level.building_id')
        ->leftJoin('building_level_room','building_level_room.building_level_id','=','building_level.building_level_id')
        ->where('room_type','!=','1')
        ->orderBy('room_id','DESC')
        ->get();   

    $data['building_data'] = Building::leftJoin('building_level','building_data.building_id','=','building_level.building_id')
    ->leftJoin('building_level_room','building_level_room.building_level_id','=','building_level.building_level_id')
    ->where('room_type','!=','1')
    ->orderBy('room_id','DESC')
    ->get(); 
    $data['building_room_list'] = Building_room_list::get();
    $data['food_list'] = Food_list::get();
    $data['meeting_list'] = Meeting_list::get();
    $data['meeting_objective'] = Meeting_objective::get();
    $data['budget_year'] = Budget_year::orderBy('leave_year_id','DESC')->get();

    $event = array();
    $meettings = Meeting_service::all();
    $data['building_level_room'] = Building_level_room::where('room_type','!=','1')->get();

    // $data['building_level_room'] = Building_level_room::leftJoin('meeting_service','building_level_room.room_id','=','meeting_service.room_id')
    // ->where('room_type','!=','1')->get();
    foreach ($meettings as $meetting) {
       
        if ($meetting->meetting_status == 'REQUEST') {
            $color = '#F48506';
        }elseif ($meetting->meetting_status == 'ALLOCATE') {
            $color = '#592DF7';           
        } else {
            $color = '#0AC58D';
        }

        $dateend = $meetting->meeting_date_end;
        $NewendDate = date ("Y-m-d", strtotime("1 day", strtotime($dateend)));

        // $datestart=date('H:m');
        $timestart = $meetting->meeting_time_begin;  
        $timeend = $meetting->meeting_time_end; 
        $starttime = substr($timestart, 0, 5);  
        $endtime = substr($timeend, 0, 5); 

        $showtitle = $meetting->room_name.'=>'.$starttime.'-'.$endtime;
        
        $event[] = [
            'id' => $meetting->meeting_id,
            // 'title' => $meetting->room_name,
            'title' => $showtitle,
            'start' => $meetting->meeting_date_begin,
            'end' => $NewendDate,
            // 'end' => $meetting->meeting_date_end,
            'color' => $color
        ];
    } 

    
    // $calculater = DB::connection('mysql2')->table('oapp')->where('oapp_id','=',$items->oappid)->first(); 
    // if ($calculater->nextdate == '') {
    //         $infobgcolor = "background-color:#D6EAF8";
    // }elseif($calculater->nextdate !== ''){
        // $countdateold =   round(abs(strtotime(date('Y-m-d')) - strtotime($calculater->nextdate))/60/60/24)+1; 
        // $datestartss = strtotime($calculater->nextdate);

        // $datestart = date('Y-m-d');
        // $strNewDate1 = date ("Y-m-d", strtotime("+1 day", strtotime($datestart)));  // มากกว่า 1 วัน
        // $strNewDate2 = date ("Y-m-d", strtotime("+2 day", strtotime($datestart)));  // มากกว่า 2 วัน
        // $strNewDate3 = date ("Y-m-d", strtotime("+3 day", strtotime($datestart)));  // มากกว่า 3 วัน
        // echo 'วันที่ '.$strNewDate;
        //   echo 'วันที่ '.$datestartss;
        // $datestart=strtotime(date('Y-m-d'));   
        // $dateend= $calculater->nextdate;
        
        // $calculate =strtotime("$dateend")-strtotime("$datestart");
        // $summary=floor($calculate / 86400); // 86400 มาจาก 24*360 (1วัน = 24 ชม.)
        // echo "$summary วัน";
                                                      
    //         if(strtotime($calculater->nextdate) == $datestart){
    //             $infobgcolor = "background-color:#56F378";
    //         }elseif($calculater->nextdate == $strNewDate1 ){                                                    
    //             $infobgcolor = "background-color:#7A9AF1";    
    //         }elseif($calculater->nextdate == $strNewDate2 ){                                                    
    //             $infobgcolor = "background-color:#F17ADD";  
    //         }elseif($calculater->nextdate == $strNewDate3 ){                                                    
    //             $infobgcolor = "background-color:#67F8F8";  
                
    //         }else{
    //             $infobgcolor = "";   // 23985 
    //         }
    // } else {
    //     $infobgcolor = "background-color:#F3FADA";
    // }                                                              


   
    return view('user_meetting.meetting_calenda',$data,[
        'events' => $event
    ]); 
}
public function calendar_save(Request $request)
{
    // return $request->all();

    $title = $request->meettingtitle;
    $startdate = $request->start_date;
    $starttime = $request->timbegin;
    $endtime = $request->timeend;

    $enddate = $request->end_date; 
    $Newenddate = date ("Y-m-d", strtotime("-1 day", strtotime($enddate)));
    $datesave = date ("Y-m-d HH:mm:ss");
    $status = $request->status;
    $year = $request->meettingyear;
    $target = $request->meettingtarget;
    $qty = $request->meettingpersonqty;
    $obj = $request->meetingobj;
    $tel = $request->meetingtel;
    $iduser = $request->userid;
    $idroom = $request->roomid;

    // $dateend = $meetting->meeting_date_end;
    // $strNewDate1 = date ("Y-m-d", strtotime("+1 day", strtotime($dateend)));

        $add = new Meeting_service();
        $add->meetting_title = $title; 
        $add->meetting_status = $status;
        $add->meeting_date_begin = $startdate;
        $add->meeting_date_end = $Newenddate;
        $add->meeting_date_save = $datesave;
        $add->meeting_time_begin = $starttime;
        $add->meeting_time_end = $endtime;
        $add->meetting_year = $year;
        $add->meetting_target = $target;
        $add->meetting_person_qty = $qty;
        $add->meeting_tel = $tel;  

        if ($idroom != '') {
            $rosave = DB::table('building_level_room')->where('room_id','=',$idroom)->first();
            $add->room_id = $rosave->room_id; 
            $add->room_name = $rosave->room_name; 
        }else{
            $add->room_id = '';
            $add->room_name = '';
        }
       
        if ($obj != '') {
            $objsave = DB::table('meeting_objective')->where('meeting_objective_id','=',$obj)->first();
            $add->meeting_objective_id = $objsave->meeting_objective_id; 
            $add->meeting_objective_name = $objsave->meeting_objective_name; 
        }else{
            $add->meeting_objective_id = '';
            $add->meeting_objective_name = '';
        }

        if ($iduser != '') {
            $usersave = DB::table('users')->where('id','=',$iduser)->first();
            $add->meeting_user_id = $usersave->id; 
            $add->meeting_user_name = $usersave->fname.' '.$usersave->lname; 
            $add->meeting_debsubsubtrue_id = $usersave->dep_subsubtrueid; 
            $add->meeting_debsubsubtrue_name = $usersave->dep_subsubtruename; 
        }else{
            $add->meeting_user_id = '';
            $add->meeting_user_name = '';
            $add->meeting_debsubsubtrue_id = '';
            $add->meeting_debsubsubtrue_name = '';
        }
 
        $add->save(); 

        // if ($status == 'REQUEST') {
        //     $color = '#F48506';
        // }

        //     function DateThailine($strDate)
        //         {
        //                 $strYear = date("Y",strtotime($strDate))+543;
        //                 $strMonth= date("n",strtotime($strDate));
        //                 $strDay= date("j",strtotime($strDate));
                
        //                 $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
        //                 $strMonthThai=$strMonthCut[$strMonth];
        //                 return "$strDay $strMonthThai $strYear";
        //         }
        //         function formatetime($strtime)
        //         {
        //         $H = substr($strtime,0,5);
        //         return $H;
        //         }
        //     $header = "จองห้องประชุม";

        //     $room = DB::table('building_level_room')->where('room_id','=',$idroom)->first(); 
        //     $userreq = DB::table('users')->where('id','=',$iduser)->first();            
        //     $message = $header.
        //     "\n"."ห้องประชุม : " . $room->room_name .
        //     "\n"."ผู้ขอ : " .$userreq->fname.'  '.$userreq->lname.
        //     "\n"."วันที่ : " . DateThailine($startdate)  .
        //     "\n"."เวลา : " . $starttime .  
        //     "\n"."ถึงวันที่ : " .DateThailine($Newenddate).    
        //     "\n"."เวลา : " .$endtime.  
        //     "\n"."โทร : " .$userreq->tel.    
        //     "\n"."สถานะ : " . 'ร้องขอ';    
            
        //     $line = DB::table('line_token')->where('line_token_id','=',4)->first();
          
        //     if($line == null){
        //        $sendline = '';
        //     }else{
        //        $sendline =$line->line_token_code;
        //     }            
          
        //     $chOne = curl_init();
        //     curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
        //     curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0);
        //     curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0);
        //     curl_setopt( $chOne, CURLOPT_POST, 1);
        //     curl_setopt( $chOne, CURLOPT_POSTFIELDS, $message);
        //     curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=$message");
        //     curl_setopt( $chOne, CURLOPT_FOLLOWLOCATION, 1);
        //     $headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$sendline.'', );
        //     curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
        //     curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1);
        //     $result = curl_exec( $chOne );
        //     if(curl_error($chOne)) { echo 'error:' . curl_error($chOne); }
        //     else { $result_ = json_decode($result, true);
        //     echo "status : ".$result_['status']; echo "message : ". $result_['message']; }
        //     curl_close( $chOne );

   return response()->json([
        'status'     => '200',
        'title'      =>  $title,
        'color'      =>  $color,
        'start'      =>  $startdate,
        'end'        =>  $Newenddate,
        ]);
}

public function calendar_update(Request $request ,$id)
{
        $meettings = Meeting_service::find($id);
        if(! $meettings) {
            return response()->json([
                'error' => 'Unable to locate the event'
            ], 404);
        }
        $meettings->update([
            'meeting_date_begin' => $request->start_date,
            'meeting_date_end' => $request->end_date,
        ]);
        // return response()->json('Event updated');
        return response()->json([
            'status'     => '200',
        ]);
}

public function meetting_calenda_add(Request $request ,$id)
{
    $data['building_level_room'] = Building_level_room::where('room_type','!=','1')->get();
    $dataedit = Building_level_room::where('room_type','!=','1')->where('room_id','=',$id)->first(); 
    $data['building_room_list'] = Building_room_list::get();
    $data['food_list'] = Food_list::get();
    $data['meeting_list'] = Meeting_list::get();
    $data['meeting_objective'] = Meeting_objective::get();
    $data['budget_year'] = Budget_year::orderBy('leave_year_id','DESC')->get();

    $event = array();
    // $meettings = Meeting_service::all();
    $meettings = Meeting_service::where('room_id','=',$id)->get();
    $data['building_level_room'] = Building_level_room::where('room_type','!=','1')->get();
    // $data['building_level_room'] = Building_level_room::leftJoin('meeting_service','building_level_room.room_id','=','meeting_service.room_id')
    // ->where('room_type','!=','1')->get();
    foreach ($meettings as $meetting) {
       
        if ($meetting->meetting_status == 'REQUEST') {
            $color = '#F48506';
        }elseif ($meetting->meetting_status == 'ALLOCATE') {
            $color = '#592DF7';           
        } else {
            $color = '#0AC58D';
        }   
        
        $dateend = $meetting->meeting_date_end;
        $NewendDate = date ("Y-m-d", strtotime("1 day", strtotime($dateend)));

        // $datestart=date('H:m');
        $timestart = $meetting->meeting_time_begin;  
        $timeend = $meetting->meeting_time_end; 
        $starttime = substr($timestart, 0, 5);  
        $endtime = substr($timeend, 0, 5); 

        $showtitle = $meetting->room_name.'=>'.$starttime.'-'.$endtime;

        $event[] = [
            'id' => $meetting->meeting_id,
            'title' => $showtitle,
            'start' => $meetting->meeting_date_begin,
            'end' => $NewendDate,
            // 'end' => $meetting->meeting_date_end,
            'color' => $color
        ];
    }

    return view('user_meetting.meetting_calenda_add',$data,[
        'dataedits'  => $dataedit,
        'events' => $event
    ]);
   
}

public function calendar_destroy($id)
{
    $meettings = Meeting_service::find($id);     
    $meettings->delete();
    return $id;
}
    //  $meetingservice = Meeting_service::create([
    //     'meetting_title' => $title,
    //     'meeting_date_begin' => $startdate,
    //     'meeting_date_end' => $enddate,
    //     'meetting_status' => $status,
    //     'meetting_person_qty' => $qty,
    //     'meeting_objective_id' => $objective_id,
    //     'meeting_objective_name' => $objective_name,
    // ]);
    // $color = null;

    // if($meetingservice->meetting_status == 'REQUEST') {
    //     $color = '#F48506';
    // }



public function calendarEvents(Request $request)
{
    switch ($request->type) {
        case 'create':
            $event = CrudEvents::create([
                'event_name' => $request->event_name,
                'event_start' => $request->event_start,
                'event_end' => $request->event_end,
            ]);

            return response()->json($event);
            break;

        case 'edit':
            $event = CrudEvents::find($request->id)->update([
                'event_name' => $request->event_name,
                'event_start' => $request->event_start,
                'event_end' => $request->event_end,
            ]);

            return response()->json($event);
            break;

        case 'delete':
            $event = CrudEvents::find($request->id)->delete();

            return response()->json($event);
            break;

        default:
            # ...
            break;
    }
}

public function storecalendar_save(Request $request)
{
    return $request->all();
}

//======================เว็คจองห้องซ้ำ ----------------------------------------------------
function checkroom(Request $request)
{
            $ROOM_ID = $request->get('ROOM_ID');
            $TIME_SC_ID = $request->get('TIME_SC_ID');
            $DATE_BEGIN = $request->get('DATE_BEGIN');
                
            $date_end_c = Carbon::createFromFormat('d/m/Y', $DATE_BEGIN)->format('Y-m-d');
            $date_arrary_e=explode("-",$date_end_c); 

            $y_sub_e = $date_arrary_e[0];

            if($y_sub_e >= 2500){
                $y_e = $y_sub_e-543;
            }else{
                $y_e = $y_sub_e;
            }

            $m_e = $date_arrary_e[1];
            $d_e = $date_arrary_e[2];  
            $DATEBEGIN= $y_e."-".$m_e."-".$d_e;

            $countroom = DB::table('meetingroom_service')->where('ROOM_ID','=',$ROOM_ID)->where('TIME_SC_ID','=',$TIME_SC_ID )->where('DATE_BEGIN','=',$DATEBEGIN)->where('STATUS','<>','CANCEL')->count();
            $countdate =  DB::table('meetingroom_service')->where('ROOM_ID','=',$ROOM_ID)->where('TIME_SC_ID','=',1 )->where('DATE_BEGIN','=',$DATEBEGIN)->where('STATUS','<>','CANCEL')->count();

            $countdate2 =  DB::table('meetingroom_service')->where('ROOM_ID','=',$ROOM_ID)->where('TIME_SC_ID','=',2 )->where('DATE_BEGIN','=',$DATEBEGIN)->where('STATUS','<>','CANCEL')->count();
            $countdate3 =  DB::table('meetingroom_service')->where('ROOM_ID','=',$ROOM_ID)->where('TIME_SC_ID','=',3 )->where('DATE_BEGIN','=',$DATEBEGIN)->where('STATUS','<>','CANCEL')->count();

            $nameroom = DB::table('meetingroom_index')->where('ROOM_ID','=',$ROOM_ID)->first();

            if($countdate > 0 ){

                $output='
                <input type="hidden" id="checkroomre" name="checkroomre" value="1">  
                    <center><h3 style="color: red;  font-family: \'Kanit\', sans-serif;">'.$nameroom->ROOM_NAME.' ถูกจองแล้ว กรุณาเลือกวันที่ ช่วงเวลาหรือห้องประชุมอื่น !! </h3></center>';
            
            }elseif($countroom > 0){
                $output='
                <input type="hidden" id="checkroomre" name="checkroomre" value="1">  
                <center><h3 style="color: red;  font-family: \'Kanit\', sans-serif;">'.$nameroom->ROOM_NAME.' ถูกจองแล้ว กรุณาเลือกวันที่ ช่วงเวลาหรือห้องประชุมอื่น !! </h3></center>';

            }elseif($countdate2 > 0 && $TIME_SC_ID == 1){
                $output='
                <input type="hidden" id="checkroomre" name="checkroomre" value="1">  
                <center><h3 style="color: red;  font-family: \'Kanit\', sans-serif;">'.$nameroom->ROOM_NAME.' ถูกจองแล้ว กรุณาเลือกวันที่ ช่วงเวลาหรือห้องประชุมอื่น !! </h3></center>';

            }elseif($countdate3 > 0 && $TIME_SC_ID == 1){
                $output='
                <input type="hidden" id="checkroomre" name="checkroomre" value="1">  
                <center><h3 style="color: red;  font-family: \'Kanit\', sans-serif;">'.$nameroom->ROOM_NAME.' ถูกจองแล้ว กรุณาเลือกวันที่ ช่วงเวลาหรือห้องประชุมอื่น !!</h3></center>';

            }else{

                $output='<input type="hidden" id="checkroomre" name="checkroomre" value="0">';

            }

            echo $output;

}



}