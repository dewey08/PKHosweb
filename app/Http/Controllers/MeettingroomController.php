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
use App\Models\Meeting_status;
use DataTables;
use PDF;
use Auth;
use Illuminate\Support\Facades\File;

class MeettingroomController extends Controller
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
public function meettingroom_dashboard(Request $request)
{   
    $data['car_index'] = Car_index::leftJoin('car_status','car_index.car_index_status','=','car_status.car_status_code')->orderBy('car_index_id','DESC')
    ->get();  
    $data['users'] = User::get();
    $data['book_objective'] = DB::table('book_objective')->get();
    $data['bookrep'] = DB::table('bookrep')->get();

    $event = array();
    $meettings = Meeting_service::all();
    // $meettings = Meeting_service::where('room_id','=',$dataedit->room_id)->get();

    $data['building_level_room'] = Building_level_room::where('room_type','!=','1')->get(); 
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
            'end' => $NewendDate,
            // 'end' => $meetting->meeting_date_end,
            'color' => $color
        ];
    }

    return view('meetting.meettingroom_dashboard',$data,[
        'events' => $event
    ]);
}
public function meettingroom_index(Request $request)
{   
    $data['car_index'] = Car_index::leftJoin('car_status','car_index.car_index_status','=','car_status.car_status_code')->orderBy('car_index_id','DESC')
    ->get();  
    $data['users'] = User::get();
    $data['book_objective'] = DB::table('book_objective')->get();
    $data['bookrep'] = DB::table('bookrep')->get(); 
    $data['building_level_room'] = Building_level_room::where('room_type','!=','1')->get(); 

    $data['building_data'] = Building::leftJoin('building_level','building_data.building_id','=','building_level.building_id')
    ->leftJoin('building_level_room','building_level_room.building_level_id','=','building_level.building_level_id')
    ->where('room_type','!=','1')
    ->orderBy('room_id','DESC')
    ->get(); 

    $event = array();
    $meettings = Meeting_service::all();
    // $meettings = Meeting_service::where('room_id','=',$dataedit->room_id)->get();

    $data['building_level_room'] = Building_level_room::where('room_type','!=','1')->get(); 
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
            'end' => $NewendDate,
            // 'end' => $meetting->meeting_date_end,
            'color' => $color
        ];
    }
    
    return view('meetting.meettingroom_index',$data,[
        'events' => $event
    ]);
}
public function meettingroom_index_edit(Request $request,$id)
{   
    $data['car_index'] = Car_index::leftJoin('car_status','car_index.car_index_status','=','car_status.car_status_code')->orderBy('car_index_id','DESC')
    ->get();  
    $data['users'] = User::get();
    $data['book_objective'] = DB::table('book_objective')->get();
    $data['building_room_status'] = Building_room_status::get(); 
    $data['building_level_room'] = Building_level_room::where('room_type','!=','1')->get(); 

    $dataedit = Building::leftJoin('building_level','building_data.building_id','=','building_level.building_id')
    ->leftJoin('building_level_room','building_level_room.building_level_id','=','building_level.building_level_id')
    ->where('room_type','!=','1')->where('building_level_room.room_id','=',$id)
    ->first(); 
    $roomlist = Building_room_list::where('room_id','=',$id)->get();

    $event = array();
    $meettings = Meeting_service::all();
    // $meettings = Meeting_service::where('room_id','=',$dataedit->room_id)->get();

    $data['building_level_room'] = Building_level_room::where('room_type','!=','1')->get(); 
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
            'end' => $NewendDate,
            // 'end' => $meetting->meeting_date_end,
            'color' => $color
        ];
    }
      
    return view('meetting.meettingroom_index_edit',$data,[
        'dataedits' => $dataedit,
        'roomlists' => $roomlist,
        'events' => $event
    ]);
}

public function meettingroom_index_save(Request $request)
{    
        $idroom = $request->room_id;
        $update = Building_level_room::find($idroom);
        $update->room_name = $request->input('room_name'); 
        $update->room_amount = $request->input('room_amount'); 
        $update->room_status = $request->input('room_status'); 
        $update->room_color = $request->input('room_color');      

        $iduser = $request->input('room_user_id'); 
        if ($iduser != '') {
            $usersave = DB::table('users')->where('id','=',$iduser)->first();
            $update->room_user_id = $usersave->id; 
            $update->room_user_name = $usersave->fname. '  ' .$usersave->lname ; 
        } else {
            $update->room_user_id = ''; 
            $update->room_user_name =''; 
        }
                      
        if ($request->hasfile('room_img')) {
            $description = 'storage/meetting/'.$update->room_img;
            if (File::exists($description))
            {
                File::delete($description);
            }
            $file = $request->file('room_img');
            $extention = $file->getClientOriginalExtension();
            $filename = time().'.'.$extention; 
            $request->room_img->storeAs('meetting',$filename,'public'); 
            $update->room_img = $filename;
            $update->room_img_name = $filename;
        }

        // if ($request->hasfile('article_img')) {
        //     $description = 'storage/article/'.$update->article_img;
        //     if (File::exists($description))
        //     {
        //         File::delete($description);
        //     }
        //     $file = $request->file('article_img');
        //     $extention = $file->getClientOriginalExtension();
        //     $filename = time().'.'.$extention;
        //     // $file->move('uploads/article/',$filename);
        //     $request->article_img->storeAs('article',$filename,'public');
        //     $update->article_img = $filename;
        //     $update->article_img_name = $filename;
        // }
       
        $update->save();    
        return response()->json([
            'status'     => '200'
            ]);
}

public function meettingroom_index_tool(Request $request,$id)
{   
    $data['car_index'] = Car_index::leftJoin('car_status','car_index.car_index_status','=','car_status.car_status_code')->orderBy('car_index_id','DESC')
    ->get();  
    $data['users'] = User::get();
    $data['book_objective'] = DB::table('book_objective')->get();
    $data['building_room_status'] = Building_room_status::get(); 
    $data['building_level_room'] = Building_level_room::where('room_type','!=','1')->get(); 

    $dataedit = Building::leftJoin('building_level','building_data.building_id','=','building_level.building_id')
    ->leftJoin('building_level_room','building_level_room.building_level_id','=','building_level.building_level_id')
    ->where('room_type','!=','1')->where('building_level_room.room_id','=',$id)
    ->first(); 
    $roomlist = Building_room_list::where('room_id','=',$id)->get();

    $event = array();
    $meettings = Meeting_service::all();
    // $meettings = Meeting_service::where('room_id','=',$dataedit->room_id)->get();

    $data['building_level_room'] = Building_level_room::where('room_type','!=','1')->get(); 
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
            'end' => $NewendDate,
            // 'end' => $meetting->meeting_date_end,
            'color' => $color
        ];
    }
      
    return view('meetting.meettingroom_index_tool',$data,[
        'dataedits' => $dataedit,
        'roomlists' => $roomlist,
        'events' => $event
    ]);
}

public function meettingroom_index_toolsave(Request $request)
{    
        $add = new Building_room_list();
        $add->room_list_name = $request->input('room_list_name'); 
        $add->room_list_qty = $request->input('room_list_qty'); 
        $add->room_id = $request->input('room_id'); 
        $add->save();    

        $add2 = new Meeting_list();
        $add2->meeting_list_name = $request->input('room_list_name'); 
        $add2->meeting_list_qty = $request->input('room_list_qty'); 
        $add2->room_id = $request->input('room_id'); 
        $add2->save();

        return response()->json([
            'status'     => '200'
            ]);
}
public function room_listdestroy(Request $request,$id)
{
   $del = Building_room_list::find($id);  
   $del->delete(); 
    return response()->json(['status' => '200','success' => 'Delete Success']);
}
public function meettingroom_add(Request $request)
{   
    $data['car_index'] = Car_index::leftJoin('car_status','car_index.car_index_status','=','car_status.car_status_code')->orderBy('car_index_id','DESC')
    ->get(); 
    $data['users'] = User::get(); 
    $data['article_status'] = Article_status::get(); 
    $data['car_type'] = Car_type::get(); 
    $data['product_brand'] = Product_brand::get(); 
    $data['product_color'] = Product_color::get();
    $data['department_sub_sub'] = Department_sub_sub::orderBy('DEPARTMENT_SUB_SUB_ID','DESC')->get(); 
    
    return view('meetting.meettingroom_add',$data);
}

public function meettingroom_check(Request $request)
{   
    $idsubtrue = Auth::user()->dep_subsubtrueid;

    $data['q'] = $request->query('q');
    $data['year'] = $request->query('year');
    $startdate = $request->query('startdate');
    $enddate = $request->query('enddate');
    $datastatus = $request->query('meeting_status_code');
    $data['meeting_status'] = Meeting_status::orderBy('meeting_status_id','ASC')->get();
    // dd($datastatus);
    if ($datastatus != '') {
        $data['meeting_service'] = Meeting_service::join('meeting_status','meeting_status.meeting_status_code','=','meeting_service.meetting_status')
        ->where('meeting_service.meetting_status','=',$datastatus)
        ->WhereBetween('meeting_date_begin',[$startdate,$enddate])->get(); 
    } elseif($datastatus == 'ALL') {
        $data['meeting_service'] = Meeting_service::join('meeting_status','meeting_status.meeting_status_code','=','meeting_service.meetting_status')
        //  ->where('meeting_service.meetting_status','=','ALL')
        ->WhereBetween('meeting_date_begin',[$startdate,$enddate])->get(); 
    } else {
        $data['meeting_service'] = Meeting_service::join('meeting_status','meeting_status.meeting_status_code','=','meeting_service.meetting_status')
        ->WhereBetween('meeting_date_begin',[$startdate,$enddate])->get(); 
    }

    // if (condition) {
    //     # code...
    // }elseif (condition) {
    //     # code...
    
    // } else {
    //     # code...
    // }
    
    
 

    // $date = date('Y-m-d');
    // $date = date('m');
      
     // dd($date);

    // if ($datastatus== null) {
    //     $query = Meeting_service::select('meeting_service.*','meeting_status.*')
    //         ->join('meeting_status','meeting_status.meeting_status_code','=','meeting_service.meetting_status')
    //         // ->where('meeting_service.meetting_status',$data['meeting_status_code'])
    //         ->where(function ($query) use ($data){
    //             $query->where('meetting_title','like','%'.$data['q'].'%');
    //             $query->orwhere('meetting_year','like','%'.$data['q'].'%');
    //             $query->orwhere('meeting_objective_name','like','%'.$data['q'].'%');
    //             $query->orwhere('room_name','like','%'.$data['q'].'%');
    //             $query->orwhere('meeting_debsubsubtrue_name','like','%'.$data['q'].'%');
    //             $query->orwhere('meeting_status_code','like','%'.$data['q'].'%');
    //         })
    //         ->where('meetting_status','=','REQUEST') 
    //         ->orderBy('meeting_date_begin','DESC')
    //         ->orderBy('meeting_service.meeting_id','DESC');
    //         $data['meeting_service'] = $query->get(); 
    //     }elseif ($datastatus == 'ALL'){
    //         $query = Meeting_service::select('meeting_service.*','meeting_status.*')
    //         ->join('meeting_status','meeting_status.meeting_status_code','=','meeting_service.meetting_status')         
    //         ->where(function ($query) use ($data){
    //             $query->where('meetting_title','like','%'.$data['q'].'%');
    //             $query->orwhere('meetting_year','like','%'.$data['q'].'%');
    //             $query->orwhere('meeting_objective_name','like','%'.$data['q'].'%');
    //             $query->orwhere('room_name','like','%'.$data['q'].'%');
    //             $query->orwhere('meeting_debsubsubtrue_name','like','%'.$data['q'].'%');
    //             $query->orwhere('meeting_status_code','like','%'.$data['q'].'%');
    //         })
    //         ->orderBy('meeting_date_begin','DESC')
    //         ->orderBy('meeting_service.meeting_id','DESC');
    //         $data['meeting_service'] = $query->get();

    //     }elseif ($startdate != null || $enddate != null){
    //         $query = Meeting_service::select('meeting_service.*','meeting_status.*')
    //         ->join('meeting_status','meeting_status.meeting_status_code','=','meeting_service.meetting_status')         
    //         ->where(function ($query) use ($data){
    //             $query->where('meetting_title','like','%'.$data['q'].'%');
    //             $query->orwhere('meetting_year','like','%'.$data['q'].'%');
    //             $query->orwhere('meeting_objective_name','like','%'.$data['q'].'%');
    //             $query->orwhere('room_name','like','%'.$data['q'].'%');
    //             $query->orwhere('meeting_debsubsubtrue_name','like','%'.$data['q'].'%');
    //             $query->orwhere('meeting_status_code','like','%'.$data['q'].'%');
    //         })
    //         ->where('meetting_status','=',$datastatus) 
    //         ->WhereBetween('meeting_date_begin',[$startdate,$enddate])  
    //         ->orderBy('meeting_date_begin','DESC')
    //         ->orderBy('meeting_service.meeting_id','DESC');
    //         $data['meeting_service'] = $query->get();


    //     }else {
    //         $query = Meeting_service::select('meeting_service.*','meeting_status.*')
    //         ->join('meeting_status','meeting_status.meeting_status_code','=','meeting_service.meetting_status') 
    //         ->where(function ($query) use ($data){
    //             $query->where('meetting_title','like','%'.$data['q'].'%');
    //             $query->orwhere('meetting_year','like','%'.$data['q'].'%');
    //             $query->orwhere('meeting_objective_name','like','%'.$data['q'].'%');
    //             $query->orwhere('room_name','like','%'.$data['q'].'%');
    //             $query->orwhere('meeting_debsubsubtrue_name','like','%'.$data['q'].'%');
    //             $query->orwhere('meeting_status_code','like','%'.$data['q'].'%');
    //         })
    //         ->where('meetting_status','=',$datastatus) 
    //         ->orderBy('meeting_date_begin','DESC')
    //         ->orderBy('meeting_service.meeting_id','DESC');
    //         $data['meeting_service'] = $query->get(); 
    //     }
        

    // if($data['meeting_status_code'])
    // $query->where('meeting_service.meetting_status',$data['meeting_status_code']);

    // if($data['start'])
    //     $query->WhereBetween('meeting_date_begin',[$data['start'],$data['end']]); 
        
    // if($data['end'])
    // $query->WhereBetween('meeting_date_begin',[$data['start'],$data['end']]);  

    // $data['meeting_service'] = $query->get(); 

    // $data['budget_year'] = Budget_year::orderBy('leave_year_id','DESC')->get();
    // $datastatus = 'REQUEST';

    $event = array();
    $meettings = Meeting_service::all();
    // $meettings = Meeting_service::where('room_id','=',$dataedit->room_id)->get();

    $data['building_level_room'] = Building_level_room::where('room_type','!=','1')->get(); 
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
            'end' => $NewendDate,
            // 'end' => $meetting->meeting_date_end,
            'color' => $color
        ];
    }

    return view('meetting.meettingroom_check',$data,[
        'datastatus'        => $datastatus,
        'events'            => $event,
        'startdate'         =>  $startdate,
        'enddate'           =>  $enddate,
    ]);
}

public function meettingroom_check_search(Request $request)
{   
    $idsubtrue = Auth::user()->dep_subsubtrueid;

    $data['q'] = $request->query('q');
    $data['year'] = $request->query('year');
    $data['start'] = $request->query('start');
    $data['end'] = $request->query('end');
    $status = $request->query('meeting_status_code');
    $data['meeting_status'] = Meeting_status::all();

    // $date = date('Y-m-d');
    // $date = date('m');
      
    //  dd($status);

    if ($data['meeting_status_code'] == null) {
        $query = Meeting_service::select('meeting_service.*','meeting_status.*')
            ->join('meeting_status','meeting_status.meeting_status_code','=','meeting_service.meetting_status')
            // ->where('meeting_service.meetting_status',$data['meeting_status_code'])
            ->where(function ($query) use ($data){
                $query->where('meetting_title','like','%'.$data['q'].'%');
                $query->orwhere('meetting_year','like','%'.$data['q'].'%');
                $query->orwhere('meeting_objective_name','like','%'.$data['q'].'%');
                $query->orwhere('room_name','like','%'.$data['q'].'%');
                $query->orwhere('meeting_debsubsubtrue_name','like','%'.$data['q'].'%');
                $query->orwhere('meeting_status_code','like','%'.$data['q'].'%');
            })
            // ->where('meetting_status','=', $data['meeting_status_code']) 
            ->orderBy('meeting_date_begin','DESC')
            ->orderBy('meeting_service.meeting_id','DESC');
            $data['meeting_service'] = $query->get(); 

        }else{
            $query = Meeting_service::select('meeting_service.*','meeting_status.*')
            ->join('meeting_status','meeting_status.meeting_status_code','=','meeting_service.meetting_status')
            ->where('meeting_service.meetting_status',$data['meeting_status_code'])
            ->where(function ($query) use ($data){
                $query->where('meetting_title','like','%'.$data['q'].'%');
                $query->orwhere('meetting_year','like','%'.$data['q'].'%');
                $query->orwhere('meeting_objective_name','like','%'.$data['q'].'%');
                $query->orwhere('room_name','like','%'.$data['q'].'%');
                $query->orwhere('meeting_debsubsubtrue_name','like','%'.$data['q'].'%');
                $query->orwhere('meeting_status_code','like','%'.$data['q'].'%');
            })
           
            ->orderBy('meeting_date_begin','DESC')
            ->orderBy('meeting_service.meeting_id','DESC');
            $data['meeting_service'] = $query->get(); 
        }           

    // if($data['meeting_status_code'])
    // $query->where('meeting_service.meetting_status',$data['meeting_status_code']);

    // if($data['start'])
    //     $query->WhereBetween('meeting_date_begin',[$data['start'],$data['end']]); 
        
    // if($data['end'])
    // $query->WhereBetween('meeting_date_begin',[$data['start'],$data['end']]);  

    // $data['meeting_service'] = $query->get(); 

    // $data['budget_year'] = Budget_year::orderBy('leave_year_id','DESC')->get();

    return view('meetting.meettingroom_check',$data);
}
public function meettingroom_check_allow(Request $request,$id)
{   
    $idsubtrue = Auth::user()->dep_subsubtrueid;
 
    // $dataedit = Meeting_service::where('meetting_status','=','REQUEST')->where('meeting_id','=',$id)->first();
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

    return view('meetting.meettingroom_check_allow',$data,[
        'dataedits'  => $dataedit,
        'events' => $event
    ]);
}

public function meettingroom_check_allow_update(Request $request)
{  
    $id = $request->meeting_id;

    $update = Meeting_service::find($id); 
    $update->meetting_status = 'ALLOCATE';

    $update->meetting_title = $request->meetting_title;
    $update->meetting_target = $request->meetting_target;
    $update->meeting_objective_name = $request->meeting_objective_name;
    $update->meetting_year = $request->meetting_year;
    $update->meetting_person_qty = $request->meetting_person_qty;
    $update->meeting_date_begin = $request->meeting_date_begin;
    $update->meeting_date_end = $request->meeting_date_end;
    $update->meeting_time_begin = $request->meeting_time_begin;
    $update->meeting_time_end = $request->meeting_time_end;
    $update->meeting_tel = $request->meeting_tel;
    $update->save();

    return response()->json([
        'status'     => '200', 
        ]);
}
public function meettingroom_report(Request $request)
{   
    $data['car_index'] = Car_index::leftJoin('car_status','car_index.car_index_status','=','car_status.car_status_code')->orderBy('car_index_id','DESC')
    ->get();  
    $data['users'] = User::get();
    $data['book_objective'] = DB::table('book_objective')->get();
    $data['bookrep'] = DB::table('bookrep')->get();
    return view('meetting.meettingroom_report',$data);
}
// ************** ข้อมูลห้องประชุม ********************
// public function car_data_index(Request $request)
// {   
//     $data['article_data'] = Article::where('article_decline_id','=','6')->where('article_categoryid','=','26')->where('article_status_id','=','1')
//     ->orderBy('article_id','DESC')
//     ->get();  
   
//     return view('car.car_data_index',$data);
// }
// public function car_data_index_add(Request $request)
// {   
//     $data['car_index'] = Car_index::leftJoin('car_status','car_index.car_index_status','=','car_status.car_status_code')->orderBy('car_index_id','DESC')
//     ->get(); 
//     $data['users'] = User::get(); 
//     $data['article_status'] = Article_status::get(); 
//     $data['car_type'] = Car_type::get(); 
//     $data['product_brand'] = Product_brand::get(); 
//     $data['product_color'] = Product_color::get();
//     $data['department_sub_sub'] = Department_sub_sub::orderBy('DEPARTMENT_SUB_SUB_ID','DESC')->get(); 

//     return view('car.car_data_index_add',$data);
// }
// public function car_data_index_save(Request $request)
// {  
//         $add = new Article();
//         $add->article_year = $request->input('article_year'); 
//         $add->article_recieve_date = $request->input('article_recieve_date'); 
//         $add->article_price = $request->input('article_price');  
//         $add->article_num = $request->input('article_num');
//         $add->article_name = $request->input('article_name');
//         $add->article_attribute = $request->input('article_attribute');
//         $add->article_register = $request->input('article_register');
//         $add->store_id = $request->input('store_id'); 
//         $add->article_car_gas = $request->input('article_car_gas'); 
//         $add->article_car_number = $request->input('article_car_number');
//         $add->article_serial_no = $request->input('article_serial_no');  
      
//         $iduser = $request->input('article_user_id'); 
//         if ($iduser != '') {
//             $usersave = DB::table('users')->where('id','=',$iduser)->first();
//             $add->article_user_id = $usersave->id; 
//             $add->article_user_name = $usersave->fname. '  ' .$usersave->lname ; 
//         } else {
//             $add->article_user_id = ''; 
//             $add->article_user_name =''; 
//         }

//         $typeid = $request->input('article_typeid'); 
//         if ($typeid != '') {
//             $typesave = DB::table('product_type')->where('sub_type_id','=',$typeid)->first();
//             $add->article_typeid = $typesave->sub_type_id; 
//             $add->article_typename = $typesave->sub_type_name; 
//         } else {
//             $add->article_typeid = ''; 
//             $add->article_typename =''; 
//         }

//         $groupid = $request->input('article_groupid');
//         if ($groupid != '') {
//                 $groupsave = DB::table('product_group')->where('product_group_id','=',$groupid)->first();
//                 $add->article_groupid = $groupsave->product_group_id; 
//                 $add->article_groupname = $groupsave->product_group_name; 
//         } else {
//             $add->article_groupid = ''; 
//             $add->article_groupname = ''; 
//         }

//         $decliid = $request->input('article_decline_id');
//         if ($decliid != '') {
//             $decsave = DB::table('product_decline')->where('decline_id','=',$decliid)->first();
//             $add->article_decline_id = $decsave->decline_id; 
//             $add->article_decline_name = $decsave->decline_name; 
//         }else{
//             $add->article_decline_id = '';
//             $add->article_decline_name = '';
//         }

//         $debid = $request->input('article_deb_subsub_id');
//         if ($debid != '') {
//             $debsave = DB::table('department_sub_sub')->where('DEPARTMENT_SUB_SUB_ID','=',$debid)->first();
//             $add->article_deb_subsub_id = $debsave->DEPARTMENT_SUB_SUB_ID; 
//             $add->article_deb_subsub_name = $debsave->DEPARTMENT_SUB_SUB_NAME; 
//         }else{
//             $add->article_deb_subsub_id = '';
//             $add->article_deb_subsub_name = '';
//         }

//         $stsid = $request->input('article_status_id');
//         if ($stsid != '') {
//             $debsave = DB::table('article_status')->where('article_status_id','=',$stsid)->first();
//             $add->article_status_id = $debsave->article_status_id; 
//             $add->article_status_name = $debsave->article_status_name; 
//         }else{
//             $add->article_status_id = '';
//             $add->article_status_name = '';
//         }
        
//         $brandid = $request->input('article_brand_id');
//         if ($brandid != '') {
//             $groupsave = DB::table('product_brand')->where('brand_id','=',$brandid)->first();
//             $add->article_brand_id = $groupsave->brand_id; 
//             $add->article_brand_name = $groupsave->brand_name; 
//         } else {
//             $add->article_brand_id = ''; 
//             $add->article_brand_name = ''; 
//         }

//         $colorid = $request->input('article_color_id');
//         if ($colorid != '') {
//             $colsave = DB::table('product_color')->where('color_id','=',$colorid)->first();
//             $add->article_color_id = $colsave->color_id; 
//             $add->article_color_name = $colsave->color_name; 
//         } else {
//             $add->article_color_id = ''; 
//             $add->article_color_name = ''; 
//         }

//         $typecarid = $request->input('article_car_type_id'); 
//         if ($typecarid != '') {
//             $typesave = DB::table('car_type')->where('car_type_id','=',$typecarid)->first();
//             $add->article_car_type_id = $typesave->car_type_id; 
//             $add->article_car_type_name = $typesave->car_type_name; 
//         } else {
//             $add->article_car_type_id = ''; 
//             $add->article_car_type_name =''; 
//         }

//         $catid = $request->input('article_categoryid'); 
//         if ($catid != '') {
//             $catsave = DB::table('product_category')->where('category_id','=',$catid)->first();
//             $add->article_categoryid = $catsave->category_id; 
//             $add->article_categoryname = $catsave->category_name; 
//         } else {
//             $add->article_categoryid = ''; 
//             $add->article_categoryname =''; 
//         }
           

//         if ($request->hasfile('article_img')) {
//             $file = $request->file('article_img');
//             $extention = $file->getClientOriginalExtension();
//             $filename = time().'.'.$extention; 
//             $request->article_img->storeAs('car',$filename,'public'); 
//             $add->article_img = $filename;
//             $add->article_img_name = $filename;
//         }
        
       
//         $add->save(); 

//         return response()->json([
//             'status'     => '200'
//             ]);
// }

}