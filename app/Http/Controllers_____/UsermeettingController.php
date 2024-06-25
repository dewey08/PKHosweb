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

class UsermeettingController extends Controller
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
public function meetting_choose_cancel(Request $request, $id)
{
    $update = Meeting_service::find($id);
    $update->meetting_status = 'CANCEL';
    $update->save();
    return response()->json(['status' => '200']);
}

public function meetting_index(Request $request)
{   
    $startdate = $request->startdate;
    $enddate = $request->enddate; 
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
    $datenow = date('Y-m-d');
    $yy = date('Y') + 543;
    $mo = date('m');
    $newweek = date('Y-m-d', strtotime($datenow . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
    $newDate = date('Y-m-d', strtotime($datenow . ' -1 months')); //ย้อนหลัง 1 เดือน
    $featureDate = date('Y-m-d', strtotime($datenow . ' +1 months')); //ล่วงหน้า 1 เดือน
    // dd($idsubtrue);
    if ($startdate == '') {
        // $data['meeting_service'] = Meeting_service::where('meeting_debsubsubtrue_id','=',$idsubtrue)->get();
        $data['meeting_service'] = DB::connection('mysql')->select(' 
            SELECT *
            FROM meeting_service         
            WHERE meeting_date_begin BETWEEN "'.$newDate.'" and "'.$featureDate.'" 
            AND meeting_debsubsubtrue_id = "'.$idsubtrue.'"      
        ');
    } else {
        
        // $data['meeting_service'] = Meeting_service::where('meeting_debsubsubtrue_id','=',$idsubtrue)->where('meeting_date_begin','=',)->get();
        $data['meeting_service'] = DB::connection('mysql')->select(' 
                SELECT *
                FROM meeting_service                
                WHERE meeting_date_begin BETWEEN "'.$startdate.'" and "'.$enddate.'" 
                AND meeting_debsubsubtrue_id = "'.$idsubtrue.'"      
            ');
    }
    
    

    return view('user_meetting.meetting_index',$data,[
        'startdate'        => $startdate,
        'enddate'          => $enddate, 
    ]);
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

public function meetting_choose(Request $request,$id)
{   
    // dd($id);
    // $data['building_level_room'] = Building_level_room::where('room_type','!=','1')->where('room_id','=',$id)->first(); 
    $dataedit = Building_level_room::where('room_type','!=','1')->where('room_id','=',$id)->first(); 
    $data['building_data'] = Building::leftJoin('building_level','building_data.building_id','=','building_level.building_id')
    ->leftJoin('building_level_room','building_level_room.building_level_id','=','building_level.building_level_id')
    ->where('room_type','!=','1')
    ->orderBy('room_id','DESC')
    ->get(); 
    $data['building_room_list'] = Building_room_list::get();
    $data['food_list'] = Food_list::get();
    $data['meeting_list'] = Meeting_list::where('room_id','=',$id)->get();
    $data['meeting_objective'] = Meeting_objective::get();
    $data['budget_year'] = Budget_year::orderBy('leave_year_id','DESC')->get();
  
    $count =  Meeting_service::where('room_id','=',$id)->count(); 
    //  dd($count);
    if ( $count == 0) {
        $event = array();
        // $meettings = Meeting_service::all();
        $meettings = Meeting_service::where('room_id','=',$id)->get(); 
        foreach ($meettings as $meetting) {       
            if ($meetting->meetting_status == 'REQUEST') {
                $color = '#F48506';
            }elseif ($meetting->meetting_status == 'ALLOCATE') {
                $color = '#592DF7';    
            }elseif ($meetting->meetting_status == 'CANCEL') {
                $color = '#ff0707';       
            } else {
                $color = '#0AC58D';
            }    
            
            $dateend = $meetting->meeting_date_end;
            $NewendDate = date ("Y-m-d", strtotime("1 day", strtotime($dateend)));

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
                'color' => $color
            ];           
        }
    } else {   
        $event = array();   
        $meet = Meeting_service::where('room_id','=',$id)->get();
        // $meet = Meeting_service::all();  
        foreach ($meet as $meetting) {       
            if ($meetting->meetting_status == 'REQUEST') {
                $color = '#F48506';
            }elseif ($meetting->meetting_status == 'ALLOCATE') {
                $color = '#592DF7';     
            }elseif ($meetting->meetting_status == 'CANCEL') {
                $color = '#ff0707';       
            } else {
                $color = '#0AC58D';
            }  
            $dateend = $meetting->meeting_date_end;
            $NewendDate = date ("Y-m-d", strtotime("1 day", strtotime($dateend)));

            $timestart = $meetting->meeting_time_begin;  
            $timeend = $meetting->meeting_time_end; 
            $starttime = substr($timestart, 0, 5);  
            $endtime = substr($timeend, 0, 5); 
    
            $showtitle = $meetting->meetting_title.'>'.$starttime.'-'.$endtime;

            $event[] = [
                'id' => $meetting->meeting_id,
                'title' => $showtitle,
                'start' => $meetting->meeting_date_begin, 
                'end' => $NewendDate, 
                'color' => $color
            ];             
        }
    }    
    // $meettings = Meeting_service::all(); 
    return view('user_meetting.meetting_choose',$data,[
        'dataedits'  => $dataedit,
        'events' => $event
    ]);
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
    $meettings = Meeting_service::where('meetting_status','<>','CANCEL')->get();
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
    // $datesave = date ("Y-m-d HH:mm:ss");
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
        // $add->meeting_date_save = $datesave;
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
       
       
            // function DateThailine($strDate)
            //     {
            //             $strYear = date("Y",strtotime($strDate))+543;
            //             $strMonth= date("n",strtotime($strDate));
            //             $strDay= date("j",strtotime($strDate));                
            //             $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
            //             $strMonthThai=$strMonthCut[$strMonth];
            //             return "$strDay $strMonthThai $strYear";
            //     }
                
            // // $header = "จองห้องประชุม";

            // // $room = DB::table('building_level_room')->where('room_id','=',$idroom)->first(); 
            // // $userreq = DB::table('users')->where('id','=',$iduser)->first();            
            // $message = "จองห้องประชุม".
            // "\n"."ห้องประชุม : " . $rosave->room_name .
            // "\n"."ผู้ขอ : " .$usersave->fname.'  '.$usersave->lname.
            // "\n"."วันที่ : " . DateThailine($startdate)  .
            // "\n"."เวลา : " . $starttime .  
            // "\n"."ถึงวันที่ : " .DateThailine($Newenddate).    
            // "\n"."เวลา : " .$endtime.  
            // "\n"."โทร : " .$usersave->tel.    
            // "\n"."สถานะ : " . 'ร้องขอ';    
            
            // $line = DB::table('line_token')->where('line_token_id','=',4)->first();
          
            // if($line == null){
            //    $sendline = '';
            // }else{
            //    $sendline =$line->line_token_code;
            // }           
          
            // $chOne = curl_init();
            // curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
            // curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0);
            // curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0);
            // curl_setopt( $chOne, CURLOPT_POST, 1);
            // curl_setopt( $chOne, CURLOPT_POSTFIELDS, $message);
            // curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=$message");
            // curl_setopt( $chOne, CURLOPT_FOLLOWLOCATION, 1);
            // $headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$sendline.'', );
            // curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
            // curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1);
            // $result = curl_exec( $chOne );
            // if(curl_error($chOne)) { echo 'error:' . curl_error($chOne); }
            // else { $result_ = json_decode($result, true);
            // echo "status_ : ".$result_['status_']; echo "message : ". $result_['message']; }
            // curl_close( $chOne );

            if ($status == 'REQUEST') {
                $color = '#F48506';
            }
            // return back();
        //     return redirect()->route('meetting.meetting_calenda_add',[
        //                 'status'     => '200',
        // 'title'      =>  $title,
        // 'color'      =>  $color,
        // 'start'      =>  $startdate,
        // 'end'        =>  $Newenddate,
        //     ]); 
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
    $meettings = Meeting_service::where('room_id','=',$id)->where('meetting_status','<>','CANCEL')->get();
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

        $showtitle = $meetting->meetting_title.'=>'.$starttime.'-'.$endtime;

        $event[] = [
            'id' => $meetting->meeting_id,
            'title' => $showtitle,
            'start' => $meetting->meeting_date_begin,
            // 'end' => $NewendDate,
            'end' => $meetting->meeting_date_end,
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
   
public function meetting_choose_save(Request $request)
{
    // return $request->all();

        $title = $request->meettingtitle;
        $startdate = $request->meetingdatebegin;
        $enddate = $request->meetingdateend;
        $starttime = $request->timbegin;
        $endtime = $request->timeend;   
        $status = $request->status;
        $year = $request->meettingyear;
        $target = $request->meettingtarget;
        $qty = $request->meettingpersonqty;
        $obj = $request->meetingobj;
        $tel = $request->meetingtel;
        $iduser = $request->userid;
        $idroom = $request->roomid;
        // $date = date("Y-m-d H:i:s"); 
        $date =  date('Y-m-d');

        $add = new Meeting_service();
        $add->meetting_title = $title; 
        $add->meetting_status = $status;
        $add->meeting_date_begin = $startdate;
        $add->meeting_date_end = $enddate; 
        $add->meeting_time_begin = $starttime;
        $add->meeting_time_end = $endtime;
        $add->meetting_year = $year;
        $add->meetting_target = $target;
        $add->meetting_person_qty = $qty;
        $add->meeting_tel = $tel;  
        $add->meeting_date_save = $date; 

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
        
        
            // function DateThailine($strDate)
            //     {
            //             $strYear = date("Y",strtotime($strDate))+543;
            //             $strMonth= date("n",strtotime($strDate));
            //             $strDay= date("j",strtotime($strDate));                
            //             $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
            //             $strMonthThai=$strMonthCut[$strMonth];
            //             return "$strDay $strMonthThai $strYear";
            //     }
                
            // // $header = "จองห้องประชุม";

            // // $room = DB::table('building_level_room')->where('room_id','=',$idroom)->first(); 
            // // $userreq = DB::table('users')->where('id','=',$iduser)->first();            
            // $message = "จองห้องประชุม".
            // "\n"."ห้องประชุม : " . $rosave->room_name .
            // "\n"."ผู้ขอ : " .$usersave->fname.'  '.$usersave->lname.
            // "\n"."วันที่ : " . DateThailine($startdate)  .
            // "\n"."เวลา : " . $starttime .  
            // "\n"."ถึงวันที่ : " .DateThailine($enddate).    
            // "\n"."เวลา : " .$endtime.  
            // "\n"."โทร : " .$usersave->tel.    
            // "\n"."สถานะ : " . 'ร้องขอ';    
            
            // $line = DB::table('line_token')->where('line_token_id','=',4)->first();
            
            // if($line == null){
            //    $sendline = '';
            // }else{
            //    $sendline =$line->line_token_code;
            // }           
            
            // $chOne = curl_init();
            // curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
            // curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0);
            // curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0);
            // curl_setopt( $chOne, CURLOPT_POST, 1);
            // curl_setopt( $chOne, CURLOPT_POSTFIELDS, $message);
            // curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=$message");
            // curl_setopt( $chOne, CURLOPT_FOLLOWLOCATION, 1);
            // $headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$sendline.'', );
            // curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
            // curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1);
            // $result = curl_exec( $chOne );
            // if(curl_error($chOne)) { echo 'error:' . curl_error($chOne); }
            // else { $result_ = json_decode($result, true);
            // echo "status_ : ".$result_['status_']; echo "message : ". $result_['message']; }
            // curl_close( $chOne );

            // if ($status == 'REQUEST') {
            //     $color = '#F48506';
            // }
            // return back();
            // return redirect()->route('meetting.meetting_index',[
            //             'status'     => '200',     
            // ]); 
    return response()->json([
        'status'     => '200'            
        ]);
}

public function meetting_choose_linesave(Request $request)
{
    // function dateDiff($date)
    // {
    //     $mydate= date("Y-m-d H:i:s");
    //     $theDiff="";
    //     //echo $mydate;//2014-06-06 21:35:55
    //     $datetime1 = date_create($date);
    //     $datetime2 = date_create($mydate);
    //     $interval = date_diff($datetime1, $datetime2);
    //     //echo $interval->format('%s Seconds %i Minutes %h Hours %d days %m Months %y Year    Ago')."<br>";
    //     $min=$interval->format('%i');
    //     $sec=$interval->format('%s');
    //     $hour=$interval->format('%h');
    //     $mon=$interval->format('%m');
    //     $day=$interval->format('%d');
    //     $year=$interval->format('%y');
    //     if($interval->format('%i%h%d%m%y')=="00000") {
    //         //echo $interval->format('%i%h%d%m%y')."<br>";
    //         return $sec." Seconds";
    //     } else if($interval->format('%h%d%m%y')=="0000"){
    //         return $min." Minutes";
    //     } else if($interval->format('%d%m%y')=="000"){
    //         return $hour." Hours";
    //     } else if($interval->format('%m%y')=="00"){
    //         return $day." Days";
    //     } else if($interval->format('%y')=="0"){
    //         return $mon." Months";
    //     } else{
    //         return $year." Years";
    //     }    
    // }
    // return $request->all(); 
        $startdate = $request->meeting_date_begin;
        $enddate = $request->meeting_date_end;
      
        // $start = date($startdate);
        // $end = strtotime($enddate);
        // $date = date('d');
        // dd($date);
        // $start = strtotime($startdate);
        // $end = strtotime($enddate);
        // $tot_ = $end - $start; 

        $start = date_create($startdate);
        $end = date_create($enddate);
        
        $tot_ = date_diff($end,$start);
        // $day = $tot_->format('%d')+1;
        $day = $tot_->format('%d');
        // $tot_ = ($end - $start) / 2400;
          // $tot_ = ($end - $start) / 1800;
        // $tot = number_format($tot_,2);
        // dd($day);
        // $countdateold =   round(abs(strtotime(date('Y-m-d')) - strtotime($calculater->nextdate))/60/60/24)+1;

        $i =   round(abs(strtotime($startdate) - strtotime($enddate))/60/60/24)+1; //นับวัน 
        // dd($countdate);
        $datestart = date ("Y-m-d", strtotime($startdate)-1);  //ลบออก 1 วัน เช่น 2022-08-22  -1 == 2022-08-21
        $dateend = date ("Y-m-d", strtotime($enddate)-1);
        while (strtotime($datestart) <= strtotime($dateend)) { 
            $datestart = date ("Y-m-d", strtotime("+1 days", strtotime($datestart))); // loop +1 วัน เอาเฉพาะวันที่ เช่น 2022-08-22
 
                    $title = $request->meetting_title;
                    $starttime = $request->meeting_time_begin;
                    $endtime = $request->meeting_time_end;   
                    $status = $request->status;
                    $year = $request->meetting_year;
                    $target = $request->meetting_target;
                    $qty = $request->meetting_person_qty;
                    $obj = $request->meeting_objective_id;
                    $tel = $request->meeting_tel;
                    $iduser = $request->userid;
                    $idroom = $request->room_id; 
                    $date =  date('Y-m-d');

                    $add = new Meeting_service();
                    $add->meetting_title = $title; 
                    $add->meetting_status = $status;

                    $add->meeting_date_begin = $datestart;
                    $add->meeting_date_end = $datestart;

                    $add->meeting_time_begin = $starttime;
                    $add->meeting_time_end = $endtime;
                    $add->meetting_year = $year;
                    $add->meetting_target = $target;
                    $add->meetting_person_qty = $qty;
                    $add->meeting_tel = $tel;  
                    $add->meeting_date_save = $date; 
                    $add->meeting_comment = $request->meeting_comment;

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
                    
                    $idservice = Meeting_service::max('meeting_id'); 
                    if ($request->MEETTINGLIST_ID != '' || $request->MEETTINGLIST_ID != null) {
                        $MEETTINGLIST_ID    = $request->MEETTINGLIST_ID;
                        $MEETTINGLIST_QTY = $request->MEETTINGLIST_QTY;
                        $number = count($MEETTINGLIST_ID);
                        $count  = 0;
                        for ($count = 0; $count < $number; $count++) {
                            $infolist = DB::table('meeting_list')->where('meeting_list_id', '=', $MEETTINGLIST_ID[$count])->first();
                            $add_2                    = new Meeting_service_list();
                            $add_2->meeting_id        = $idservice;
                            $add_2->meeting_list_id   = $infolist->meeting_list_id;
                            $add_2->meeting_list_name   = $infolist->meeting_list_name;
                            $add_2->meeting_service_list_qty  = $MEETTINGLIST_QTY[$count];
                            $add_2->save();

                        }
                    }
        }
        // if ($request->FOOD_LIST_ID != '' || $request->FOOD_LIST_ID != null) {

        //     $FOOD_LIST_ID    = $request->FOOD_LIST_ID;
        //     $FOOD_LIST_QTY = $request->FOOD_LIST_QTY;

        //     $number2 = count($FOOD_LIST_ID);
        //     $count_2  = 0;
        //     for ($count_2 = 0; $count_2 < $number2; $count_2++) {

        //         $foodid = $FOOD_LIST_ID[$count_2];

        //         $infofood = DB::table('food_list')->where('food_list_id', '=', $foodid)->first();

        //         $add_2                    = new Meeting_service_food();
        //         $add_2->meeting_id        = $idservice;
        //         $add_2->food_list_id   = $infofood->food_list_id;
        //         $add_2->food_list_name   = $infofood->food_list_name;
        //         $add_2->meeting_service_food_qty  = $FOOD_LIST_QTY[$count_2];
        //         $add_2->save();

        //     }
        // }
        
            function DateThailine($strDate)
                {
                        $strYear = date("Y",strtotime($strDate))+543;
                        $strMonth= date("n",strtotime($strDate));
                        $strDay= date("j",strtotime($strDate));                
                        $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
                        $strMonthThai=$strMonthCut[$strMonth];
                        return "$strDay $strMonthThai $strYear";
                }
                $ros = DB::table('building_level_room')->where('room_id','=',$idroom)->first();   
                $uset = DB::table('users')->where('id','=',$iduser)->first();
            // // $header = "จองห้องประชุม";

            // // $room = DB::table('building_level_room')->where('room_id','=',$idroom)->first(); 
            // // $userreq = DB::table('users')->where('id','=',$iduser)->first();            
            $message = "จองห้องประชุม".
            "\n"."ห้องประชุม : " . $ros->room_name .
            "\n"."ผู้ขอ : " .$uset->fname.'  '.$uset->lname.
            "\n"."วันที่ : " . DateThailine($startdate)  .
            "\n"."ถึงวันที่ : " .DateThailine($enddate).
            "\n"."เวลา : " . $starttime . 
            "\n"."ถึงเวลา : " .$endtime. 
            "\n"."โทร : " .$uset->tel.    
            "\n"."สถานะ : " . 'ร้องขอ';    
            
            $line = DB::table('line_token')->where('line_token_id','=',4)->first();
            
            if($line == null){
                $sendline = '';
            }else{
                $sendline =$line->line_token_code;
            }           
            
            $chOne = curl_init();
            curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
            curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt( $chOne, CURLOPT_POST, 1);
            curl_setopt( $chOne, CURLOPT_POSTFIELDS, $message);
            curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=$message");
            curl_setopt( $chOne, CURLOPT_FOLLOWLOCATION, 1);
            $headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$sendline.'', );
            curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
            curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1);
            $result = curl_exec( $chOne );
            if(curl_error($chOne)) { echo 'error:' . curl_error($chOne); }
            else { $result_ = json_decode($result, true);
            echo "status : ".$result_['status']; echo "message : ". $result_['message']; }
            curl_close( $chOne );
                        
    return redirect()->route('meetting.meetting_index'); 

}

public function meetting_choose_edit(Request $request,$id)
{
    // Meeting_service
    $dataedit = Meeting_service::where('meeting_id','=',$id)->first(); 

    $data['building_level_room'] = Building_level_room::where('room_type','!=','1')->get();
    // $dataedit = Building_level_room::where('room_type','!=','1')->where('meeting_id','=',$id)->first(); 
    $data['building_room_list'] = Building_room_list::get();
    $data['food_list'] = Food_list::get();
    $data['meeting_list'] = Meeting_list::get();
    $data['meeting_objective'] = Meeting_objective::get();
    $data['budget_year'] = Budget_year::orderBy('leave_year_id','DESC')->get();

    // meeting_service_food
    $data['meeting_service_food'] = Meeting_service_food::where('meeting_id','=',$id)->get();

    $data['meeting_service_list'] = Meeting_service_list::where('meeting_id','=',$id)->get();

    $event = array();
    // $meettings = Meeting_service::all();
    $meettings = Meeting_service::where('room_id','=',$dataedit->room_id)->get();
    $data['building_level_room'] = Building_level_room::where('room_type','!=','1')->get(); 
    foreach ($meettings as $meetting) {
       
        if ($meetting->meetting_status == 'REQUEST') {
            $color = '#F48506';
        }elseif ($meetting->meetting_status == 'ALLOCATE') {
            $color = '#592DF7';   
        }elseif ($meetting->meetting_status == 'CANCEL') {
            $color = '#ff0707';         
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

        $showtitle = $meetting->meetting_title.'=>'.$starttime.'-'.$endtime;

        $event[] = [
            'id' => $meetting->meeting_id,
            'title' => $showtitle,
            'start' => $meetting->meeting_date_begin,
            'end' => $NewendDate,
            // 'end' => $meetting->meeting_date_end,
            'color' => $color
        ];
    }

    return view('user_meetting.meetting_choose_edit',$data,[
        'dataedits'  => $dataedit,
        'events' => $event
    ]);
}

public function meetting_choose_lineupdate(Request $request)
{
    // return $request->all();
        $idmeetser = $request->meeting_id;
        $title = $request->meetting_title;
        $startdate = $request->meeting_date_begin;
        $enddate = $request->meeting_date_end;
        $starttime = $request->meeting_time_begin;
        $endtime = $request->meeting_time_end;   
        $status = $request->status;
        $year = $request->meetting_year;
        $target = $request->meetting_target;
        $qty = $request->meetting_person_qty;
        $obj = $request->meeting_objective_id;
        $tel = $request->meeting_tel;
        $iduser = $request->userid;
        $idroom = $request->room_id; 
        $date =  date('Y-m-d');

        $update = Meeting_service::find($idmeetser);
        $update->meetting_title = $title; 
        $update->meetting_status = $status;
        $update->meeting_date_begin = $startdate;
        $update->meeting_date_end = $enddate; 
        $update->meeting_time_begin = $starttime;
        $update->meeting_time_end = $endtime;
        $update->meetting_year = $year;
        $update->meetting_target = $target;
        $update->meetting_person_qty = $qty;
        $update->meeting_tel = $tel;  
        $update->meeting_date_save = $date; 
        $update->meeting_comment = $request->meeting_comment;

        if ($idroom != '') {
            $rosave = DB::table('building_level_room')->where('room_id','=',$idroom)->first();
            $update->room_id = $rosave->room_id; 
            $update->room_name = $rosave->room_name; 
        }else{
            $update->room_id = '';
            $update->room_name = '';
        }
        
        if ($obj != '') {
            $objsave = DB::table('meeting_objective')->where('meeting_objective_id','=',$obj)->first();
            $update->meeting_objective_id = $objsave->meeting_objective_id; 
            $update->meeting_objective_name = $objsave->meeting_objective_name; 
        }else{
            $update->meeting_objective_id = '';
            $update->meeting_objective_name = '';
        }

        if ($iduser != '') {
            $usersave = DB::table('users')->where('id','=',$iduser)->first();
            $update->meeting_user_id = $usersave->id; 
            $update->meeting_user_name = $usersave->fname.' '.$usersave->lname; 
            $update->meeting_debsubsubtrue_id = $usersave->dep_subsubtrueid; 
            $update->meeting_debsubsubtrue_name = $usersave->dep_subsubtruename; 
        }else{
            $update->meeting_user_id = '';
            $update->meeting_user_name = '';
            $update->meeting_debsubsubtrue_id = '';
            $update->meeting_debsubsubtrue_name = '';
        }    
        $update->save(); 
        
            // $idservice = Meeting_service::max('meeting_id');
            Meeting_service_list::where('meeting_id','=',$idmeetser)->delete();
        // $aa = $request->MEETTINGLIST_ID;
        // dd($aa);
        if ($request->MEETTINGLIST_ID != '' || $request->MEETTINGLIST_ID != null) {

            $MEETTINGLIST_ID    = $request->MEETTINGLIST_ID;
            $MEETTINGLIST_QTY = $request->MEETTINGLIST_QTY;

            $number = count($MEETTINGLIST_ID);
            $count  = 0;
            for ($count = 0; $count < $number; $count++) {

                // $listid = $MEETTINGLIST_ID[$count];

                $infolist = DB::table('meeting_list')->where('meeting_list_id', '=', $MEETTINGLIST_ID[$count])->first();

                $add_2                    = new Meeting_service_list();
                $add_2->meeting_id        = $idmeetser;
                $add_2->meeting_list_id   = $infolist->meeting_list_id;
                $add_2->meeting_list_name   = $infolist->meeting_list_name;
                $add_2->meeting_service_list_qty  = $MEETTINGLIST_QTY[$count];
                $add_2->save();

            }
        }

        // Meeting_service_food::where('meeting_id','=',$idmeetser)->delete();
        // if ($request->FOOD_LIST_ID != '' || $request->FOOD_LIST_ID != null) {

        //     $FOOD_LIST_ID    = $request->FOOD_LIST_ID;
        //     $FOOD_LIST_QTY = $request->FOOD_LIST_QTY;

        //     $number2 = count($FOOD_LIST_ID);
        //     $count_2  = 0;
        //     for ($count_2 = 0; $count_2 < $number2; $count_2++) {

        //         $foodid = $FOOD_LIST_ID[$count_2];

        //         $infofood = DB::table('food_list')->where('food_list_id', '=', $foodid)->first();

        //         $add_2                    = new Meeting_service_food();
        //         $add_2->meeting_id        = $idmeetser;
        //         $add_2->food_list_id   = $infofood->food_list_id;
        //         $add_2->food_list_name   = $infofood->food_list_name;
        //         $add_2->meeting_service_food_qty  = $FOOD_LIST_QTY[$count_2];
        //         $add_2->save();

        //     }
        // }
                  
                        
    return redirect()->route('meetting.meetting_index'); 

}

public function meetting_detail(Request $request,$id)
{  
    $mservice = Meeting_service::find($id); 
    
    return response()->json([
        'status'     => '200',
        'mservice'      =>  $mservice, 
        ]);
}
//======================เว็คจองห้องซ้ำ ----------------------------------------------------
// function checkroom(Request $request)
// {
//             $ROOM_ID = $request->get('ROOM_ID');
//             $TIME_SC_ID = $request->get('TIME_SC_ID');
//             $DATE_BEGIN = $request->get('DATE_BEGIN');
                
//             $date_end_c = Carbon::createFromFormat('d/m/Y', $DATE_BEGIN)->format('Y-m-d');
//             $date_arrary_e=explode("-",$date_end_c); 

//             $y_sub_e = $date_arrary_e[0];

//             if($y_sub_e >= 2500){
//                 $y_e = $y_sub_e-543;
//             }else{
//                 $y_e = $y_sub_e;
//             }

//             $m_e = $date_arrary_e[1];
//             $d_e = $date_arrary_e[2];  
//             $DATEBEGIN= $y_e."-".$m_e."-".$d_e;

//             $countroom = DB::table('meetingroom_service')->where('ROOM_ID','=',$ROOM_ID)->where('TIME_SC_ID','=',$TIME_SC_ID )->where('DATE_BEGIN','=',$DATEBEGIN)->where('STATUS','<>','CANCEL')->count();
//             $countdate =  DB::table('meetingroom_service')->where('ROOM_ID','=',$ROOM_ID)->where('TIME_SC_ID','=',1 )->where('DATE_BEGIN','=',$DATEBEGIN)->where('STATUS','<>','CANCEL')->count();

//             $countdate2 =  DB::table('meetingroom_service')->where('ROOM_ID','=',$ROOM_ID)->where('TIME_SC_ID','=',2 )->where('DATE_BEGIN','=',$DATEBEGIN)->where('STATUS','<>','CANCEL')->count();
//             $countdate3 =  DB::table('meetingroom_service')->where('ROOM_ID','=',$ROOM_ID)->where('TIME_SC_ID','=',3 )->where('DATE_BEGIN','=',$DATEBEGIN)->where('STATUS','<>','CANCEL')->count();

//             $nameroom = DB::table('meetingroom_index')->where('ROOM_ID','=',$ROOM_ID)->first();

//             if($countdate > 0 ){

//                 $output='
//                 <input type="hidden" id="checkroomre" name="checkroomre" value="1">  
//                     <center><h3 style="color: red;  font-family: \'Kanit\', sans-serif;">'.$nameroom->ROOM_NAME.' ถูกจองแล้ว กรุณาเลือกวันที่ ช่วงเวลาหรือห้องประชุมอื่น !! </h3></center>';
            
//             }elseif($countroom > 0){
//                 $output='
//                 <input type="hidden" id="checkroomre" name="checkroomre" value="1">  
//                 <center><h3 style="color: red;  font-family: \'Kanit\', sans-serif;">'.$nameroom->ROOM_NAME.' ถูกจองแล้ว กรุณาเลือกวันที่ ช่วงเวลาหรือห้องประชุมอื่น !! </h3></center>';

//             }elseif($countdate2 > 0 && $TIME_SC_ID == 1){
//                 $output='
//                 <input type="hidden" id="checkroomre" name="checkroomre" value="1">  
//                 <center><h3 style="color: red;  font-family: \'Kanit\', sans-serif;">'.$nameroom->ROOM_NAME.' ถูกจองแล้ว กรุณาเลือกวันที่ ช่วงเวลาหรือห้องประชุมอื่น !! </h3></center>';

//             }elseif($countdate3 > 0 && $TIME_SC_ID == 1){
//                 $output='
//                 <input type="hidden" id="checkroomre" name="checkroomre" value="1">  
//                 <center><h3 style="color: red;  font-family: \'Kanit\', sans-serif;">'.$nameroom->ROOM_NAME.' ถูกจองแล้ว กรุณาเลือกวันที่ ช่วงเวลาหรือห้องประชุมอื่น !!</h3></center>';

//             }else{

//                 $output='<input type="hidden" id="checkroomre" name="checkroomre" value="0">';

//             }

//             echo $output;

// }



}