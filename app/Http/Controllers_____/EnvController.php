<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\support\Facades\Hash;
use Illuminate\support\Facades\Validator;
use App\Models\User;
use App\Models\Ot_one;
use PDF;
use setasign\Fpdi\Fpdi;
use App\Models\Budget_year;
use Illuminate\Support\Facades\File;
use DataTables;
use Intervention\Image\ImageManagerStatic as Image;
// use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\OtExport;
// use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Department;
use App\Models\Departmentsub;
use App\Models\Departmentsubsub;
use App\Models\Position;
use App\Models\Product_spyprice;
use App\Models\Products;
use App\Models\Products_type;
use App\Models\Product_group;
use App\Models\Product_unit;
use App\Models\Products_category;
use App\Models\Article;
use App\Models\Product_prop;
use App\Models\Product_decline;
use App\Models\Department_sub_sub;
use App\Models\Products_vendor;
use App\Models\Status; 
use App\Models\Products_request;
use App\Models\Products_request_sub;   
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
use App\Models\Leave_month;
use App\Models\P4p_workload;
use App\Models\P4p_work_position;
use App\Models\P4p_work_score;
use App\Models\P4p_work;
use App\Models\P4p_workset;
use App\Models\P4p_workgroupset_unit;
use App\Models\P4p_workgroupset;

use App\Models\Env_water_parameter;

use App\Models\Env_trash_parameter;
use App\Models\Env_trash_sub;
use App\Models\Env_trash_type;
use App\Models\Env_trash;

use App\Models\Env_water_save;
use App\Models\Env_water_sub;
use App\Models\Env_water;

use Auth;

class EnvController extends Controller
{
      
    public function env_dashboard (Request $request)
    {
        $datestart = $request->startdate;
        $dateend = $request->enddate;
        $iduser = Auth::user()->id;
        $data['users'] = User::get();
        $data['leave_month'] = DB::table('leave_month')->get();
        $data['users_group'] = DB::table('users_group')->get();
        $data['p4p_workgroupset'] = P4p_workgroupset::where('p4p_workgroupset_user','=',$iduser)->get();

        $acc_debtors = DB::select('
            SELECT count(*) as I from users u
            left join p4p_workload l on l.p4p_workload_user=u.id
            group by u.dep_subsubtrueid;
        ');
         

        return view('env.env_dashboard', $data,[
            'start' => $datestart,
            'end' => $dateend, 
        ]);
    }

//**************************************************************ระบบน้ำเสีย*********************************************

    public function env_water (Request $request)
    {
        $datestart = $request->startdate;
        $dateend = $request->enddate;
        $iduser = Auth::user()->id;
        $data['users'] = User::get();
        $data['leave_month'] = DB::table('leave_month')->get();
        $data['users_group'] = DB::table('users_group')->get();
        $data['p4p_workgroupset'] = P4p_workgroupset::where('p4p_workgroupset_user','=',$iduser)->get();
        

        $acc_debtors = DB::select('
            SELECT count(*) as I from users u
            left join p4p_workload l on l.p4p_workload_user=u.id
            group by u.dep_subsubtrueid;
        ');

        $water = DB::table('env_water')
            ->leftjoin('users','env_water.water_user','=','users.id')
            ->leftjoin('env_water_sub','env_water.water_id','=','env_water_sub.water_id')->get(); 
        
        $datashow = DB::connection('mysql')->select('
            SELECT DISTINCT(w.water_id),w.water_date,w.water_location,water_group_excample,w.water_comment,CONCAT(u.fname," ",u.lname) as water_user
            from env_water w
            LEFT JOIN env_water_sub ws on ws.water_id = w.water_id
            LEFT JOIN users u on u.id = w.water_user 
            ORDER BY w.water_id DESC;
            ');
         

        return view('env.env_water', $data,[
            'startdate' => $datestart,
            'enddate'   => $dateend, 
            'datashow'  => $datashow,
            'water'     => $water,
        ]);
    }

    public function env_water_add (Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $iduser = Auth::user()->id;
        $data['users'] = User::get();
        $data['leave_month'] = DB::table('leave_month')->get();
        $data['users_group'] = DB::table('users_group')->get();
        $data['p4p_workgroupset'] = P4p_workgroupset::where('p4p_workgroupset_user','=',$iduser)->get();

        $acc_debtors = DB::select('
            SELECT count(*) as I from users u
            left join p4p_workload l on l.p4p_workload_user=u.id
            group by u.dep_subsubtrueid;
        ');


        $data_parameter = DB::table('env_water_parameter')->where('water_parameter_active','=','TRUE')->get();
         

        return view('env.env_water_add', $data,[
            'start'           => $startdate,
            'end'             => $enddate, 
            'dataparameters'  => $data_parameter, 
        ]);
    }

    public function env_water_save (Request $request)
    {   
        $startdate = $request->startdate;
        $enddate = $request->enddate;

        // $iduser = Auth::user()->id;
        $iduser = $request->water_user1;
        $data['users'] = User::get();
        $data['leave_month'] = DB::table('leave_month')->get();
        $data['users_group'] = DB::table('users_group')->get();
        $data['p4p_workgroupset'] = P4p_workgroupset::where('p4p_workgroupset_user','=',$iduser)->get();

        $acc_debtors = DB::select('
            SELECT count(*) as I from users u
            left join p4p_workload l on l.p4p_workload_user=u.id
            group by u.dep_subsubtrueid;
        ');        
       
        $add = new Env_water();
        $add->water_date            = $request->input('water_date');
        $add->water_user            = $request->input('water_user');
        $add->water_location        = $request->input('water_location');
        $add->water_group_excample  = $request->input('water_group_excample');
        $add->water_comment         = $request->input('water_comment');
        $add->save();        

        $waterid =  Env_water::max('water_id');        

        if($request->water_parameter_id != '' || $request->water_parameter_id != null){

            $water_parameter_id                             = $request->water_parameter_id;
            $water_parameter_unit                           = $request->water_parameter_unit;
            $use_analysis_results                           = $request->use_analysis_results;
            $water_parameter_normal                         = $request->water_parameter_normal;
            $water_qty                                      = $request->water_qty;
            $water_parameter_short_name                     = $request->water_parameter_short_name;                             

            $number =count($water_parameter_id);
            $count = 0;
                for($count = 0; $count< $number; $count++)
                {
                    $idwater = Env_water_parameter::where('water_parameter_id','=',$water_parameter_id[$count])->first();
                    
                    $add_sub = new Env_water_sub();
                    $add_sub->water_id                              = $waterid;
                    $add_sub->water_list_idd                        = $idwater->water_parameter_id;
                    $add_sub->water_list_detail                     = $idwater->water_parameter_name;
                    $add_sub->water_list_unit                       = $water_parameter_unit[$count]; 
                    $add_sub->water_qty                             = $water_qty[$count];
                    $add_sub->water_results                         = $idwater->water_parameter_icon.''.$idwater->water_parameter_normal;

                    if ($idwater->water_parameter_id == 1 || $water_qty[$count]  <= 20) {
                        $status = 'ผิดปกติ';
                    } else {
                        $status = 'ปกติ';
                    }
                    if ($idwater->water_parameter_id == 2 || $water_qty[$count]  <= 120) {
                        $status = 'ผิดปกติ';
                    } else {
                        $status = 'ปกติ';
                    }
                    if ($idwater->water_parameter_id == 3 || $water_qty[$count]  <= 500) {
                        $status = 'ผิดปกติ';
                    } else {
                        $status = 'ปกติ';
                    }
                    if ($idwater->water_parameter_id == 4 || $water_qty[$count]  <= 30) {
                        $status = 'ผิดปกติ';
                    } else {
                        $status = 'ปกติ';
                    }
                    if ($idwater->water_parameter_id == 5 || $water_qty[$count]  <= 0.5) {
                        $status = 'ผิดปกติ';
                    } else {
                        $status = 'ปกติ';
                    }
                    if ($idwater->water_parameter_id == 6 || $water_qty[$count]  <= 35) {
                        $status = 'ผิดปกติ';
                    } else {
                        $status = 'ปกติ';
                    }  
                    if ($idwater->water_parameter_id == 7 || $water_qty[$count]  == 5 || $water_qty[$count]  == 6 || $water_qty[$count]  == 7 || $water_qty[$count]  == 8 || $water_qty[$count]  == 9 ) {
                        $status = 'ผิดปกติ';
                    } else {
                        $status = 'ปกติ';
                    }
                    if ($idwater->water_parameter_id == 8 || $water_qty[$count]  <= 1.0) {
                        $status = 'ผิดปกติ';
                    } else {
                        $status = 'ปกติ';
                    }
                    if ($idwater->water_parameter_id == 9 || $water_qty[$count]  <= 20) {
                        $status = 'ผิดปกติ';
                    } else {
                        $status = 'ปกติ';
                    }
                    if ($idwater->water_parameter_id == 10 || $water_qty[$count]  <= 5000) {
                        $status = 'ผิดปกติ';
                    } else {
                        $status = 'ปกติ';
                    }
                    if ($idwater->water_parameter_id == 11 || $water_qty[$count]  <= 1000) {
                        $status = 'ผิดปกติ';
                    } else {
                        $status = 'ปกติ';
                    }
                    if ($idwater->water_parameter_id == 12 || $water_qty[$count]  <= 1) {
                        $status = 'ผิดปกติ';
                    } else {
                        $status = 'ปกติ';
                    }
                    if ($idwater->water_parameter_id == 13 || $water_qty[$count]  <= 1000) {
                        $status = 'ผิดปกติ';
                    } else {
                        $status = 'ปกติ';
                    }
                    if ($idwater->water_parameter_id == 14 || $water_qty[$count]  >= 5) {
                        $status = 'ผิดปกติ';
                    } else {
                        $status = 'ปกติ';
                    }
                    if ($idwater->water_parameter_id == 15 || $water_qty[$count]  >= 400) {
                        $status = 'ผิดปกติ';
                    } else {
                        $status = 'ปกติ';
                    }
                    
                    $add_sub->status                         = $status;
                    $add_sub->water_parameter_short_name            = $water_parameter_short_name[$count];
                    $add_sub->save();        
                }
        } 

        // $idsub = Env_water_parameter::max('water_parameter_id');
        $data_loob = Env_water_sub::where('water_id','=',$waterid)->get();
        // $name = User::where('id','=',$iduser)->first();
        $data_users = User::where('id','=',$request->water_user)->first();
        $name = $data_users->fname.''.$data_users->lname;

        $mMessage = array();
        foreach ($data_loob as $key => $value) { 

               $mMessage[] = [
                    'water_parameter_short_name'    => $value->water_parameter_short_name,
                    'water_qty'                     => $value->water_qty, 
                    'status'                        => $value->status,           
                ];   
            }   
       
            // $linetoken = "q2PXmPgx0iC5IZXjtkeZUFiNwtmEkSGjRp1PsxFUaYe"; //ใส่ token line ENV แล้ว    
            $linetoken = "DVWB9QFYmafdjEl9rvwB0qdPgCdsD59NHoWV7WhqbN4"; //ใส่ token line ENV แล้ว       
           
            // $smessage = [];
            $header = "ข้อมูลตรวจน้ำ";
            $message =  $header. 
                    "\n"."วันที่บันทึก : "      . $request->input('water_date'). 
                   "\n"."ผู้บันทึก  : "        . $name . 
                   "\n"."สถานที่เก็บตัวอย่าง : " . $request->input('water_location'); 
 
            foreach ($mMessage as $key => $smes) {
                $na_mesage           = $smes['water_parameter_short_name'];
                $qt_mesage           = $smes['water_qty'];
                $status_mesage       = $smes['status'];

                $message.="\n"."รายการพารามิเตอร์" . $na_mesage .
                          "\n"."ผลการวิเคราะห์ : " . $qt_mesage . 
                          "\n"."สถานะ : "       . $status_mesage;  
            } 
              

                if($linetoken == null){
                    $send_line ='';
                }else{
                    $send_line = $linetoken;
                }  
                if($send_line !== '' && $send_line !== null){ 

                    // function notify_message($smessage,$linetoken)
                    // {
                        $chOne = curl_init();
                        curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
                        curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0);
                        curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0);
                        curl_setopt( $chOne, CURLOPT_POST, 1);
                        // curl_setopt( $chOne, CURLOPT_POSTFIELDS, $message);
                        curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=$message");
                        curl_setopt( $chOne, CURLOPT_FOLLOWLOCATION, 1);
                        $headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$linetoken.'', );
                        curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
                        curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1);
                        $result = curl_exec($chOne);
                        if (curl_error($chOne)) {echo 'error:' . curl_error($chOne);} else { $result_ = json_decode($result, true);
                            echo "status : " . $result_['status'];
                            echo "message : " . $result_['message'];}
                        curl_close($chOne);
                    // } 
                    // foreach ($mMessage as $linetoken) {
                    //     notify_message($linetoken,$smessage);
                    // } 

                }              
                    
        // } 
        return redirect()->route('env.env_water');
        
        
    }

    public function env_water_edit (Request $request,$id)
    {
        $datestart = $request->startdate;
        $dateend = $request->enddate;
        $iduser = Auth::user()->id;
        $data['users'] = User::get();
        $data['leave_month'] = DB::table('leave_month')->get();
        $data['users_group'] = DB::table('users_group')->get();
        $data['p4p_workgroupset'] = P4p_workgroupset::where('p4p_workgroupset_user','=',$iduser)->get();
 
        $water = DB::table('env_water')->where('water_id','=',$id)->first();

        $data['env_water_sub']  = DB::table('env_water_sub')->where('water_id','=',$id)->get();
  
        $data['water_parameter']  = DB::table('env_water_parameter')->get();
       
        $data['products_vendor'] = Products_vendor::get();

        return view('env.env_water_edit', $data,[
            'startdate'        => $datestart,
            'enddate'          => $dateend, 
            'water'            => $water,
            'data'             => $data,  
        ]);
    }

    public function env_water_update  (Request $request)
    { 
        $datenow = date('Y-m-d H:m:s');
        $id = $request->water_id;
        // $ff = $request->trash_bill_on;
        // dd($ff);
        $update = Env_water::find($id);
        
        $update->water_date             = $request->water_date;
        $update->water_user             = $request->water_user; 
        $update->water_location         = $request->water_location; 
        $update->water_group_excample   = $request->water_group_excample; 
        $update->water_comment          = $request->water_comment; 
        $update->save();
        
        Env_water_sub::where('water_id','=',$id)->delete();

        if($request->water_list_idd != '' || $request->water_list_idd != null){

            $water_list_idd             = $request->water_list_idd;
            $water_qty                  = $request->water_qty;
            $water_parameter_unit       = $request->water_parameter_unit;
                                
            $number =count($water_list_idd);
            $count = 0;
                for($count = 0; $count< $number; $count++)
                    { 
                        $idtrash = Env_water_parameter::where('SET_WATER_ID','=',$water_list_idd[$count])->first();

                                                
                        $add_sub = new Env_water_sub();
                        $add_sub->water_id              = $id;      
                    
                        $add_sub->water_list_idd        = $idtrash->water_parameter_id;  
                        $add_sub->water_list_detail     = $idtrash->water_parameter_name;

                        $add_sub->water_qty             = $water_qty[$count];  
                        $add_sub->water_list_unit       = $water_parameter_unit[$count];                          
                        $add_sub->save(); 
                    }
        }

        return redirect()->route('env.env_water');
        
    }

    public function env_water_delete (Request $request,$id)
    {
       Env_water::destroy($id); 
       Env_water_sub::where('water_id','=',$id)->delete();

        return redirect()->back();
    }

    public function env_water_datetime (Request $request)
    { 
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        
        
        return view('env.env_water', [
            'startdate'  =>  $startdate,
            'enddate'    =>  $enddate,

        ]);
    }
//**************************************************************ตั้งค่า parameter น้ำ*********************************************

    public function env_water_parameter (Request $request)
    {
        $datestart = $request->startdate;
        $dateend = $request->enddate;
        $iduser = Auth::user()->id;
        $data['users'] = User::get();
        $data['leave_month'] = DB::table('leave_month')->get();
        $data['users_group'] = DB::table('users_group')->get();
        $data['p4p_workgroupset'] = P4p_workgroupset::where('p4p_workgroupset_user','=',$iduser)->get();
 
        $data_water_parameter = DB::table('env_water_parameter')->get();         

        return view('env.env_water_parameter', $data,[
            'startdate'         => $datestart,
            'enddate'           => $dateend,
            'data_water_parameter' => $data_water_parameter, 
        ]);
    }

    public function env_water_parameter_add (Request $request)
    {
        $datestart = $request->startdate;
        $dateend = $request->enddate;
        $iduser = Auth::user()->id;
        $data['users'] = User::get();
        $data['leave_month'] = DB::table('leave_month')->get();
        $data['users_group'] = DB::table('users_group')->get();
        $data['p4p_workgroupset'] = P4p_workgroupset::where('p4p_workgroupset_user','=',$iduser)->get();
        $data['data_water_icon'] = DB::table('env_water_icon')->get();

        $acc_debtors = DB::select('
            SELECT count(*) as I from users u
            left join p4p_workload l on l.p4p_workload_user=u.id
            group by u.dep_subsubtrueid;
        ');

        $data_water_parameter = DB::table('env_water_parameter')->get();
        
         

        return view('env.env_water_parameter_add', $data,[
            'startdate'        => $datestart,
            'enddate'          => $dateend, 
            'data_water_parameter'   => $data_water_parameter, 
        ]);
    }

    public function env_water_parameter_edit (Request $request,$id)
    {
        $datestart = $request->startdate;
        $dateend = $request->enddate;
        $iduser = Auth::user()->id;
        $data['users'] = User::get();
        $data['leave_month'] = DB::table('leave_month')->get();
        $data['users_group'] = DB::table('users_group')->get();
        $data['p4p_workgroupset'] = P4p_workgroupset::where('p4p_workgroupset_user','=',$iduser)->get();
        $data['env_water_icon'] = DB::table('env_water_icon')->get();
 
        // $data_edit = DB::table('env_water_parameter')->where('water_parameter_id','=',$id)->first();

        $water_parameter = DB::table('env_water_parameter')->where('water_parameter_id','=',$id)->first();

        return view('env.env_water_parameter_edit', $data,[
            'startdate'        => $datestart,
            'enddate'          => $dateend,
            'water_parameter'  => $water_parameter, 
            // 'data_edit'        => $data_edit, 
        ]);
    }

    public function env_water_parameter_save (Request $request)
    {  
        // env_water_icon_name
        $datenow = date('Y-m-d H:m:s');
        Env_water_parameter::insert([
            'water_parameter_name'                   => $request->water_parameter_name,
            'water_parameter_short_name'             => $request->water_parameter_short_name,
            'water_parameter_unit'                   => $request->water_parameter_unit,
            'water_parameter_icon'                   => $request->water_parameter_icon,
            'water_parameter_normal'                 => $request->water_parameter_normal,
            'water_parameter_results'                => $request->water_parameter_results,
            'created_at'                             => $datenow
        ]);
        $data_water_parameter = DB::table('env_water_parameter')->get();
    
        return redirect()->route('env.env_water_parameter');

    }

    public function env_water_parameter_update  (Request $request)
    { 
        $datenow = date('Y-m-d H:m:s');
        $id = $request->water_parameter_id;
        
        Env_water_parameter::where('water_parameter_id','=',$id)
        ->update([
            'water_parameter_name'                   => $request->water_parameter_name,
            'water_parameter_short_name'             => $request->water_parameter_short_name,
            'water_parameter_unit'                   => $request->water_parameter_unit,
            // 'water_parameter_icon'                   => $request->env_water_icon,
            'water_parameter_normal'                 => $request->water_parameter_normal,
            'water_parameter_results'                => $request->water_parameter_results, 
            'updated_at'                             => $datenow
        ]);

        $data_water_parameter = DB::table('env_water_parameter')->get();
        // return redirect()->back();
        return redirect()->route('env.env_water_parameter');
        
    }

    function env_water_parameter_switchactive(Request $request)
    {  
        $id = $request->idfunc; 
        $active = Env_water_parameter::find($id);
        $active->water_parameter_active = $request->onoff;
        $active->save();
    }

    public function env_water_parameter_delete (Request $request,$id)
    {
       $del = Env_water_parameter::find($id);  
       $del->delete(); 

        return redirect()->back();
    }

//**************************************************************ระบบขยะติดเชื้อ*********************************************

    public function env_trash (Request $request)
    {
        // $datestart = $request->startdate;
        // $dateend = $request->enddate;
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $iduser = Auth::user()->id;
        $data['users'] = User::get();
        $data['leave_month'] = DB::table('leave_month')->get();
        $data['users_group'] = DB::table('users_group')->get();
        $data['p4p_workgroupset'] = P4p_workgroupset::where('p4p_workgroupset_user','=',$iduser)->get();



        $trash = DB::table('env_trash')
            ->leftjoin('users','env_trash.trash_user','=','users.id')
            ->leftjoin('env_trash_type','env_trash.trash_user','=','env_trash_type.trash_type_id')
            ->leftjoin('products_vendor','env_trash.trash_sub','=','products_vendor.vendor_id')->get(); 
        
        $datashow = DB::connection('mysql')->select('
            SELECT DISTINCT(t.trash_bill_on) ,t.trash_id , t.trash_date , t.trash_time ,t.trash_sub , pv.vendor_name ,
            CONCAT(u.fname," ",u.lname) as trash_user
            FROM env_trash t
            LEFT JOIN env_trash_sub ts on ts.trash_id = t.trash_id
		    LEFT JOIN products_vendor pv on pv.vendor_id = t.trash_sub
			LEFT JOIN users u on u.id = t.trash_user 
            order by t.trash_id desc;
            ');

        $trash_type = DB::table('env_trash_type') ->get();
        
        // $acc_debtors = DB::select('SELECT count(*) as I from users u
        //     left join p4p_workload l on l.p4p_workload_user=u.id
        //     group by u.dep_subsubtrueid;
        // ');
         
        return view('env.env_trash',[
            'startdate'     => $startdate,
            'enddate'       => $enddate,
            'trashs'        => $trash,
            'trash_type'    => $trash_type,
            'datashow'      => $datashow,                      

        ]);
    }

    public function env_trash_add (Request $request)
    {
        $datestart = $request->startdate;
        $dateend = $request->enddate;
        $iduser = Auth::user()->id;
        $data['users'] = User::get();
        $data['leave_month'] = DB::table('leave_month')->get();
        $data['users_group'] = DB::table('users_group')->get();
        $data['p4p_workgroupset'] = P4p_workgroupset::where('p4p_workgroupset_user','=',$iduser)->get();

        $acc_debtors = DB::select('
            SELECT count(*) as I from users u
            left join p4p_workload l on l.p4p_workload_user=u.id
            group by u.dep_subsubtrueid;
        ');        

        $data_parameter = DB::table('env_trash')->get();
        $trash_parameter = DB::table('env_trash_parameter')->get();
        $data_trash_sub = DB::table('env_trash_sub')->get();
        $data_trash_type = DB::table('env_trash_type')->get();
        $data['products_vendor'] = Products_vendor::get();

        $maxnum = Env_trash::max('trash_bill_on'); //****รันเลขที่อัตโนมัติ */
        if($maxnum != '' ||  $maxnum != null){
         $refmax = Env_trash::where('trash_bill_on','=',$maxnum)->first();

         if($refmax->trash_bill_on != '' ||  $refmax->trash_bill_on != null){
         $maxpo = substr($refmax->trash_bill_on, -2)+1;
         }else{
         $maxref = 1;
         }
         $refe = str_pad($maxpo, 5, "0", STR_PAD_LEFT);
         }else{
        $refe = '00001';
         }
         $billNo = 'TRA'.'-'.$refe;
         

        return view('env.env_trash_add', $data,[
            'startdate'        => $datestart,
            'enddate'          => $dateend, 
            'dataparameters'   => $data_parameter,
            'trash_parameter'  => $trash_parameter,
            'data_trash_sub'   => $data_trash_sub,
            'data_trash_type'  => $data_trash_type,
            'billNos'          => $billNo,
        ]);

    }

    public function env_trash_save (Request $request)
    {
        date_default_timezone_set("Asia/Bangkok");
        $datenow = date('Y-m-d H:i:s');
        $iduser = Auth::user()->id;
        $trash_parameter = DB::table('env_trash_parameter')->get();

        $add = new Env_trash();
        $add->trash_bill_on = $request->input('trash_bill_on');
        $add->trash_date    = $request->input('trash_date'); 
        $add->trash_time    = $request->input('trash_time'); 
        $add->trash_user    = $request->input('trash_user'); 
        $add->trash_sub     = $request->input('trash_sub'); 
        $add->save();
        
        $trash_id =  Env_trash::max('trash_id');

        if($request->trash_parameter_id != '' || $request->trash_parameter_id != null){

        $trash_parameter_id         = $request->trash_parameter_id;
        $trash_sub_qty              = $request->trash_sub_qty;
        $trash_sub_unit             = $request->trash_sub_unit;
        $trash_parameter_unit       = $request->trash_parameter_unit;
                            
        $number =count($trash_parameter_id);
        $count = 0;
            for($count = 0; $count< $number; $count++)
            { 
                $idtrash = Env_trash_parameter::where('trash_parameter_id','=',$trash_parameter_id[$count])->first();

                $add_sub = new Env_trash_sub();
                $add_sub->trash_id                = $trash_id;
                $add_sub->trash_sub_idd           = $idtrash->trash_parameter_id;  
                $add_sub->trash_sub_name          = $idtrash->trash_parameter_name; 
                $add_sub->trash_sub_qty           = $trash_sub_qty[$count];
                $add_sub->trash_sub_unit          = $trash_parameter_unit[$count];                 
                // $add_sub->trash_sub_unit          = $trash_sub_unit[$count];                          
                $add_sub->save(); 
            }
        } 
        return redirect()->route('env.env_trash');
        // return redirect()->route('env.env_trash');
    }

    public function env_trash_edit (Request $request,$id)
    {
        $datestart = $request->startdate;
        $dateend = $request->enddate;
        $iduser = Auth::user()->id;
        $data['users'] = User::get();
        $data['leave_month'] = DB::table('leave_month')->get();
        $data['users_group'] = DB::table('users_group')->get();
        $data['p4p_workgroupset'] = P4p_workgroupset::where('p4p_workgroupset_user','=',$iduser)->get();
 
        $trash = DB::table('env_trash')->where('trash_id','=',$id)->first();
        $data['env_trash_sub']  = DB::table('env_trash_sub')->where('trash_id','=',$id)->get();
  
        $data['trash_parameter']  = DB::table('env_trash_parameter')->get();
        // $data_trash_sub = DB::table('env_trash_sub')->get();
        // $data_trash_type = DB::table('env_trash_type')->get();
        $data['products_vendor'] = Products_vendor::get();

        return view('env.env_trash_edit', $data,[
            'startdate'        => $datestart,
            'enddate'          => $dateend, 
            'trash'            => $trash, 
        ]);
    }

    public function env_trash_update  (Request $request)
    { 
        $datenow = date('Y-m-d H:m:s');
        $id = $request->trash_id;
        // $ff = $request->trash_bill_on;
        // dd($ff);
        $update = Env_trash::find($id);
        
        $update->trash_bill_on = $request->trash_bill_on;
        $update->trash_date    = $request->trash_date; 
        $update->trash_time    = $request->trash_time; 
        $update->trash_user    = $request->trash_user; 
        $update->trash_sub     = $request->trash_sub; 
        $update->save();

        // Env_trash_sub::where('trash_id','=',$id)->delete();

        if($request->trash_sub_idd != '' || $request->trash_sub_idd != null){

            $trash_sub_idd              = $request->trash_sub_idd;
            $trash_sub_qty              = $request->trash_sub_qty;
            $trash_sub_unit             = $request->trash_sub_unit;
            $trash_parameter_unit       = $request->trash_parameter_unit;
                                
            $number =count($trash_sub_idd);
            $count = 0;
                for($count = 0; $count< $number; $count++)
                    { 
                        $idtrash = Env_trash_parameter::where('SET_TRASH_ID','=',$trash_sub_idd[$count])->first();
                        
                        $add_sub = new Env_trash_sub();
                        $add_sub->trash_id          = $id;      
                    
                        $add_sub->trash_sub_idd     = $idtrash->trash_parameter_id;  
                        $add_sub->trash_sub_name    = $idtrash->trash_parameter_name;

                        $add_sub->trash_sub_qty     = $trash_sub_qty[$count];  
                        $add_sub->trash_sub_unit    = $trash_parameter_unit[$count];                          
                        $add_sub->save(); 
                    }
        }

        return redirect()->route('env.env_trash');
        
    }

    public function env_trash_delete (Request $request,$id)
    {
       Env_trash::destroy($id); 
       Env_trash_sub::where('trash_id','=',$id)->delete();

        return redirect()->back();
    }

//**************************************************************ตั้งค่า   ประเภทขยะ*********************************************

    public function env_trash_parameter (Request $request) 
    {
        $datestart = $request->startdate;
        $dateend = $request->enddate;
        $iduser = Auth::user()->id;
        $data['users'] = User::get();
        $data['leave_month'] = DB::table('leave_month')->get();
        $data['users_group'] = DB::table('users_group')->get();
        $data['p4p_workgroupset'] = P4p_workgroupset::where('p4p_workgroupset_user','=',$iduser)->get();
 
        $data_parameter_list = DB::table('env_trash_parameter')->get();
         

        return view('env.env_trash_parameter', $data,[
            'startdate' => $datestart,
            'enddate' => $dateend,
            'dataparameterlist' => $data_parameter_list, 
        ]);
    }

    public function env_trash_parameter_add (Request $request)
    {
        $datestart = $request->startdate;
        $dateend = $request->enddate;
        $iduser = Auth::user()->id;
        $data['users'] = User::get();
        $data['leave_month'] = DB::table('leave_month')->get();
        $data['users_group'] = DB::table('users_group')->get();
        $data['p4p_workgroupset'] = P4p_workgroupset::where('p4p_workgroupset_user','=',$iduser)->get();

        $acc_debtors = DB::select('
            SELECT count(*) as I from users u
            left join p4p_workload l on l.p4p_workload_user=u.id
            group by u.dep_subsubtrueid;
        ');

        $data_parameter = DB::table('env_trash_parameter')->get();
         

        return view('env.env_trash_parameter_add', $data,[
            'startdate'        => $datestart,
            'enddate'          => $dateend, 
            'dataparameters'   => $data_parameter, 
        ]);
    }

    public function env_trash_parameter_edit (Request $request,$id)
    {
        $datestart = $request->startdate;
        $dateend = $request->enddate;
        $iduser = Auth::user()->id;
        $data['users'] = User::get();
        $data['leave_month'] = DB::table('leave_month')->get();
        $data['users_group'] = DB::table('users_group')->get();
        $data['p4p_workgroupset'] = P4p_workgroupset::where('p4p_workgroupset_user','=',$iduser)->get();
 
        $data_edit = DB::table('env_trash_parameter')->where('trash_parameter_id','=',$id)->first();

        return view('env.env_trash_parameter_edit', $data,[
            'startdate'        => $datestart,
            'enddate'          => $dateend, 
            'data_edit'        => $data_edit, 
        ]);
    }

    public function env_trash_parameter_save (Request $request)
    {  
        $datenow = date('Y-m-d H:m:s');

        Env_trash_parameter::insert([
            // 'trash_parameter_id'                    => $request->trash_parameter_id,
            'trash_parameter_name'                   => $request->trash_parameter_name,
            'trash_parameter_unit'                   => $request->trash_parameter_unit,
            'created_at'                             => $datenow
        ]);
        $data_parameter_list = DB::table('env_trash_parameter')->get();
    
        return redirect()->route('env.env_trash_parameter');

    }

    public function env_trash_parameter_update  (Request $request)
    { 
        $datenow = date('Y-m-d H:m:s');
        $id = $request->trash_parameter_id;
        // DB::table('env_parameter_list')->where('parameter_list_id','=',$id)
        Env_trash_parameter::where('trash_parameter_id','=',$id)
        ->update([
            'trash_parameter_name'                       => $request->trash_parameter_name,
            'trash_parameter_unit'                       => $request->trash_parameter_unit,
            'updated_at'                                 => $datenow
        ]);

        $data_parameter_list = DB::table('env_trash_type')->get();
        // return redirect()->back();
        return redirect()->route('env.env_trash_parameter');
        // return view('env.env_water_parameter',[ 
        //     'dataparameterlist' => $data_parameter_list, 
        // ]);
    }

    public function env_trash_parameter_delete (Request $request,$id)
    {
       $del = Env_trash_parameter::find($id);  
       $del->delete(); 

        return redirect()->back();
    }

//**************************************************************ตั้งค่า   แจ้งเตือน Line*********************************************

    // public function send_Line(Request $request)
    // {
    //     date_default_timezone_set("Asia/Bangkok");
    //     $date = date('Y-m-d');
    //     // $newday = date('Y-m-d', strtotime($date . ' -30 day')); //ย้อนหลัง 30 วัน 
    //     $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์  
    //     $newdate = date('Y-m-d', strtotime($date . ' -1 months')); //ย้อนหลัง 1 เดือน 
    //     $treedate = date('Y-m-d', strtotime($date . ' -2 months')); //ย้อนหลัง 3 เดือน 
    //     // dd($newdate);
    //     // Db_authen_detail
    //     $water = DB::table('env_water')->where('water_id','=',$id)->first();
    //     $data['env_water_sub']  = DB::table('env_water_sub')->where('water_id','=',$id)->get();
    //     $data['water_parameter']  = DB::table('env_water_parameter')->get();       

    //     $detail_auto = DB::connection('mysql')->select('
    //         SELECT w.water_date, CONCAT(u.fname," ",u.lname) as ptname, w.water_group_excample, ws.water_list_idd
    //         , ws.water_list_detail, ws.water_qty, ws.water_list_unit
    //         from env_water w 
    //         left outer join env_water_sub ws on ws.water_id = w.water_id 
    //         left outer join users u on u.id = w.water_user
    //         wHERE w.water_date BETWEEN "'.$newdate.'" AND "'.$date.'"
            
    //     ');

        
    //     foreach ($detail_auto as $key => $value) {
    //             if ($value->claim_code <> '1') {
                    
    //                 $linetoken = "q2PXmPgx0iC5IZXjtkeZUFiNwtmEkSGjRp1PsxFUaYe"; //ใส่ token line ENV แล้ว
                    
    //                 $datesend = date('Y-m-d'); 
    //                 $header = "ข้อมูลตรวจน้ำ";
    //                 $message = $header.
    //                     "\n"."วันที่แจ้ง : "        . $datesend.    
    //                     "\n"."เวลาแจ้ง : "        . date('H:i:s').
    //                     "\n"."สถานที่ตรวจ : "     . $value->water_group_excample.
    //                     "\n"."พารามิเตอร์ : "      . $value->water_list_detail.
    //                     "\n"."ค่าที่ตรวจได้ : "     . $value->water_qty.
    //                     "\n"."ผู้ตรวจน้ำ : "       . $value->vstdate;             
                            
                                
    //                     if($linetoken == null){
    //                         $send_line ='';
    //                     }else{
    //                         $send_line = $linetoken;
    //                     }

    //                 if($send_line !== '' && $send_line !== null){  
    //                         $chOne = curl_init();
    //                         curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
    //                         curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0);
    //                         curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0);
    //                         curl_setopt( $chOne, CURLOPT_POST, 1);
    //                         curl_setopt( $chOne, CURLOPT_POSTFIELDS, $message);
    //                         curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=$message");
    //                         curl_setopt( $chOne, CURLOPT_FOLLOWLOCATION, 1);
    //                         $headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$send_line.'', );
    //                         curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
    //                         curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1);
    //                         $result = curl_exec( $chOne );
    //                         //  if(curl_error($chOne)) { echo 'error:' . curl_error($chOne); }
    //                         //     else { 
    //                         //         $result_ = json_decode($result, true);
    //                         //         echo "status : ".$result_['status']; echo "message : ". $result_['message'];
    //                         //         //  return response()->json([
    //                         //         //      'status'     => 200 , 
    //                         //         //      ]);
                            
    //                         // }
    //                         curl_close( $chOne );
                            
    //                 }
    //                 } else {
    //                     # code...
    //                 }
                
    //     }
    //     return view('auto.sss_check_claimcode');
    // }
}