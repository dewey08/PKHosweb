<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\support\Facades\Hash;
use Illuminate\support\Facades\Validator;
use App\Models\User;
use App\Models\Ot_one; 
use App\Models\Budget_year; 
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
use PDF;
use Auth;
use App\Mail\DissendeMail;
use Mail;
use File;
use Illuminate\Support\Facades\Storage;
use setasign\Fpdi\Fpdi;
date_default_timezone_set("Asia/Bangkok");

class P4puserController extends Controller
{
    public function p4p_dashboarduser(Request $request)
    {
        $datestart = $request->startdate;
        $dateend = $request->enddate;
        $iduser = Auth::user()->id;
        $date = date('Y-m-d');
        // $m = date('m');
        $m = substr(date("m"),1);  // ตัดเลข 0 หน้า 5 ออก เช่นเดือน 05 เหลือ 5
        // $data['y'] = date('Y')+543;
        $data['y'] = date('Y');
        // dd($m);
        $data['users'] = User::get();
        $data['leave_month'] = DB::table('leave_month')->get();
        $data_month = DB::table('leave_month')->where('MONTH_ID','=',$m)->first();
        $month = $data_month->MONTH_ID;
        // dd($data_month);
        $data['p4p_workgroupset_unit'] = DB::table('p4p_workgroupset_unit')->get();
        $data['p4p_workgroupset'] = P4p_workgroupset::where('p4p_workgroupset_user','=',$iduser)->get();
        $data['p4p_work'] = DB::table('p4p_work')
        ->leftjoin('leave_month','leave_month.MONTH_ID','=','p4p_work.p4p_work_month') 
        // ->where('p4p_work_user','=',$iduser)
        ->get();
        $data['budget_year'] = DB::table('budget_year')->get();

        return view('p4p_u.p4p_dashboarduser', $data,[
            'start'       => $datestart,
            'end'         => $dateend, 
            'month'       => $month
        ]);
    }
    public function p4p_user(Request $request)
    {
        $datestart = $request->startdate;
        $dateend = $request->enddate;
        $iduser = Auth::user()->id;
        $date = date('Y-m-d');
        // $m = date('m');
        $m = substr(date("m"),1);  // ตัดเลข 0 หน้า 5 ออก เช่นเดือน 05 เหลือ 5
        // $data['y'] = date('Y')+543;
        $data['y'] = date('Y');
        // dd($m);
        $data['users'] = User::get();
        $data['leave_month'] = DB::table('leave_month')->get();
        $data_month = DB::table('leave_month')->where('MONTH_ID','=',$m)->first();
        $month = $data_month->MONTH_ID;
        // dd($data_month);
        $data['p4p_workgroupset_unit'] = DB::table('p4p_workgroupset_unit')->get();
        $data['p4p_workgroupset'] = P4p_workgroupset::where('p4p_workgroupset_user','=',$iduser)->get();
        $data['p4p_work'] = DB::table('p4p_work')
        ->leftjoin('leave_month','leave_month.MONTH_ID','=','p4p_work.p4p_work_month') 
        // ->where('p4p_work_user','=',$iduser)
        ->get();
        $data['budget_year'] = DB::table('budget_year')->get();

        return view('p4p_u.p4p_user', $data,[
            'start'       => $datestart,
            'end'         => $dateend, 
            'month'       => $month
        ]);
    }
    public function p4p_user_save(Request $request)
    {  
        $yy = $request->p4p_work_year;
        $y =  $yy -543;
        $m = $request->p4p_work_month; 
        $check_data = Leave_month::where('MONTH_ID','=',$m)->first();
        
        $check = P4p_work::where('p4p_work_year','=',$y)->where('p4p_work_month','=',$m)->count();
        if ($check > 0) {
            return response()->json([
                'status'     => '100' 
            ]);
        } else {
            $add = new P4p_work(); 
            $add->p4p_work_user = $request->p4p_work_user;
            $add->p4p_work_month = $m;
            $add->p4p_work_year = $y;
            $add->p4p_work_code = $request->p4p_work_code; 
            $add->p4p_work_monthth = $check_data->MONTH_NAME; 
            $add->save();
            return response()->json([
                'status'     => '200' 
            ]);
        }
          
    }
    public function p4p_user_edit (Request $request,$id)
    { 
        $iduser = Auth::user()->id;
        $date = date('Y-m-d');
        // $m = date('m');
        $m = substr(date("m"),1);  // ตัดเลข 0 หน้า 5 ออก เช่นเดือน 05 เหลือ 5
        $data['y'] = date('Y')+543;
        $data['users'] = User::get();
        $data['leave_month'] = DB::table('leave_month')->get();
        $data_month = DB::table('leave_month')->where('MONTH_ID','=',$m)->first();
        $month = $data_month->MONTH_ID;


        $data_show = P4p_work::where('p4p_work_id','=',$id)->first();
        // $data['p4p_work'] = P4p_work::where('p4p_work_user','=',$iduser)->get();
        $data['budget_year'] = DB::table('budget_year')->get();
        $data['p4p_work'] = DB::table('p4p_work')
        ->leftjoin('leave_month','leave_month.MONTH_ID','=','p4p_work.p4p_work_month') 
        ->where('p4p_work_user','=',$iduser)
        ->get();
        return view('p4p_u.p4p_user_edit', $data,[
            'data_show' => $data_show,
            'month'       => $month 
        ]);
    }
    public function p4p_user_update(Request $request)
    {  
        $id = $request->p4p_work_id;
        $yy = $request->p4p_work_year;
        $y =  $yy -543;

        $update = P4p_work::find($id); 
        $update->p4p_work_user = $request->p4p_work_user;
        $update->p4p_work_month = $request->p4p_work_month;

        $check_data = Leave_month::where('MONTH_ID','=',$request->p4p_work_month)->first();
        $update->p4p_work_monthth = $check_data->MONTH_NAME; 

        $update->p4p_work_year = $y;
        $update->p4p_work_code = $request->p4p_work_code; 
        $update->save();

        return response()->json([
            'status'     => '200' 
        ]);
    }




    public function workgroupset(Request $request)
    {
        $datestart = $request->startdate;
        $dateend = $request->enddate;
        $iduser = Auth::user()->id;
        $data['users'] = User::get();
        $data['leave_month'] = DB::table('leave_month')->get();
        $data['users_group'] = DB::table('users_group')->get();
        $data['p4p_workgroupset'] = P4p_workgroupset::where('p4p_workgroupset_user','=',$iduser)->get();

        return view('p4p_u.workgroupset', $data,[
            'start' => $datestart,
            'end' => $dateend, 
        ]);
    }
    
    public function workgroupset_save(Request $request)
    {  
        $add = new P4p_workgroupset(); 
        $add->p4p_workgroupset_code = $request->p4p_workgroupset_code;
        $add->p4p_workgroupset_name = $request->p4p_workgroupset_name;
        $add->p4p_workgroupset_user = $request->p4p_workgroupset_user;
        $add->save();

        return response()->json([
            'status'     => '200' 
        ]);
    }
    public function workgroupset_edit (Request $request,$id)
    { 
        $iduser = Auth::user()->id;
        $data_show = P4p_workgroupset::where('p4p_workgroupset_id','=',$id)->first();
        $data['p4p_workgroupset'] = P4p_workgroupset::where('p4p_workgroupset_user','=',$iduser)->get();

        return view('p4p_u.workgroupset_edit', $data,[
            'data_show' => $data_show, 
        ]);
    }       
    public function workgroupset_update(Request $request)
    {  
        $id = $request->p4p_workgroupset_id;
        $update = P4p_workgroupset::find($id); 
        $update->p4p_workgroupset_code = $request->p4p_workgroupset_code;
        $update->p4p_workgroupset_name = $request->p4p_workgroupset_name;
        $update->p4p_workgroupset_user = $request->p4p_workgroupset_user;
        $update->save();

        return response()->json([
            'status'     => '200' 
        ]);
    }
    function workset_switchactive(Request $request)
    {  
        $id = $request->idfunc; 
        $active = P4p_workgroupset::find($id);
        $active->p4p_workgroupset_active = $request->onoff;
        $active->save();
    }
    public function workset (Request $request)
    {
        $datestart = $request->startdate;
        $dateend = $request->enddate;
        $iduser = Auth::user()->id;
        $data['users'] = User::get();
        $data['leave_month'] = DB::table('leave_month')->get(); 
        $data['p4p_workgroupset_unit'] = DB::table('p4p_workgroupset_unit')->get();
        $data['p4p_workgroupset'] = DB::table('p4p_workgroupset')->where('p4p_workgroupset_user','=',$iduser)->get();
        $data['p4p_workset'] = DB::table('p4p_workset')
        ->leftjoin('p4p_work_position','p4p_work_position.p4p_work_position_id','=','p4p_workset.p4p_workset_position')
        ->leftjoin('p4p_workgroupset_unit','p4p_workgroupset_unit.p4p_workgroupset_unit_id','=','p4p_workset.p4p_workset_unit')
        // ->where('p4p_workset_active','=',TRUE)
        ->where('p4p_workset_user','=',$iduser)
        ->get();
        $data['p4p_work_position'] = DB::table('p4p_work_position')->get();

        return view('p4p_u.workset ', $data,[
            'start' => $datestart,
            'end' => $dateend, 
        ]);
    }
    public function workset_save(Request $request)
    {  
        $add = new P4p_workset(); 
        $add->p4p_workset_code = $request->p4p_workset_code;
        $add->p4p_workset_name = $request->p4p_workset_name;
        $add->p4p_workset_time = $request->p4p_workset_time;
        $add->p4p_workset_score = $request->p4p_workset_score;
        $add->p4p_workset_user = $request->p4p_workset_user;
        $add->p4p_workset_unit = $request->p4p_workset_unit;
        $add->p4p_workset_group = $request->p4p_workset_group;
        $add->p4p_workset_wp = $request->p4p_workset_score * $request->p4p_workset_time;
        $add->p4p_workset_position = $request->p4p_workset_position;
        $add->save();

        return response()->json([
            'status'     => '200' 
        ]);
    }  
    public function workset_edit (Request $request,$id)
    { 
        $iduser = Auth::user()->id;

        $data_show = P4p_workset::where('p4p_workset_id','=',$id)->first();
        $data['p4p_workset'] = P4p_workset::leftjoin('p4p_workgroupset_unit','p4p_workgroupset_unit.p4p_workgroupset_unit_id','=','p4p_workset.p4p_workset_unit')
        ->where('p4p_workset_user','=',$iduser)->get();
        $data['p4p_workgroupset_unit'] = DB::table('p4p_workgroupset_unit')->get();
        $data['p4p_workgroupset'] = DB::table('p4p_workgroupset')->where('p4p_workgroupset_user','=',$iduser)->get();
        $data['p4p_work_position'] = DB::table('p4p_work_position')->get();

        return view('p4p_u.workset_edit', $data,[
            'data_show' => $data_show, 
        ]);
    }
   
    public function workset_update(Request $request)
    {  
        $id = $request->p4p_workset_id;
        $update = P4p_workset::find($id); 
        $update->p4p_workset_code = $request->p4p_workset_code;
        $update->p4p_workset_name = $request->p4p_workset_name;
        $update->p4p_workset_time = $request->p4p_workset_time;
        $update->p4p_workset_score = $request->p4p_workset_score;
        $update->p4p_workset_user = $request->p4p_workset_user;
        $update->p4p_workset_unit = $request->p4p_workset_unit;
        $update->p4p_workset_group = $request->p4p_workset_group;

        $update->p4p_workset_wp = $request->p4p_workset_score * $request->p4p_workset_time;

        $update->p4p_workset_position = $request->p4p_workset_position;
        $update->save();

        return response()->json([
            'status'     => '200' 
        ]);
    }
    function workset_switch(Request $request)
    {  
        $id = $request->idfunc; 
        $active = P4p_workset::find($id);
        $active->p4p_workset_active = $request->onoff;
        $active->save();
    }



    function addunitwork(Request $request)
    {     
    if($request->unitnew!= null || $request->unitnew != ''){    
        $count_check = P4p_workgroupset_unit::where('p4p_workgroupset_unit_name','=',$request->unitnew)->count();           
            if($count_check == 0){    
                    $add = new P4p_workgroupset_unit(); 
                    $add->p4p_workgroupset_unit_name = $request->unitnew;
                    $add->save(); 
            }
            }
                $query =  DB::table('p4p_workgroupset_unit')->get();            
                $output='<option value="">--เลือก--</option>';                
                foreach ($query as $row){
                    if($request->unitnew == $row->p4p_workgroupset_unit_name){
                        $output.= '<option value="'.$row->p4p_workgroupset_unit_id.'" selected>'.$row->p4p_workgroupset_unit_name.'</option>';
                    }else{
                        $output.= '<option value="'.$row->p4p_workgroupset_unit_id.'">'.$row->p4p_workgroupset_unit_name.'</option>';
                    }   
            }    
        echo $output;        
    }
    public static function refwork()
    {
        $year = date('Y');
        $maxnumber = DB::table('p4p_work')->max('p4p_work_id');
        if ($maxnumber != '' ||  $maxnumber != null) {
            $refmax = DB::table('p4p_work')->where('p4p_work_id', '=', $maxnumber)->first();
            if ($refmax->p4p_work_code != '' ||  $refmax->p4p_work_code != null) {
                $maxref = substr($refmax->p4p_work_code, -4) + 1;
            } else {
                $maxref = 1;
            }
            $ref = str_pad($maxref, 5, "0", STR_PAD_LEFT);
        } else {
            $ref = '00001';
        }
        $ye = date('Y') + 543;
        $y = substr($ye, -2);
        $refwork = 'WY'.$ye . '-' . $ref;
        return $refwork;       
    }
    public static function refnumber()
    {
        $year = date('Y');
        $maxnumber = DB::table('p4p_workgroupset')->max('p4p_workgroupset_id');
        if ($maxnumber != '' ||  $maxnumber != null) {
            $refmax = DB::table('p4p_workgroupset')->where('p4p_workgroupset_id', '=', $maxnumber)->first();
            if ($refmax->p4p_workgroupset_code != '' ||  $refmax->p4p_workgroupset_code != null) {
                $maxref = substr($refmax->p4p_workgroupset_code, -4) + 1;
            } else {
                $maxref = 1;
            }
            $ref = str_pad($maxref, 5, "0", STR_PAD_LEFT);
        } else {
            $ref = '00001';
        }
        $ye = date('Y') + 543;
        $y = substr($ye, -2);
        $refnumber = 'A'.$ye . '-' . $ref;
        return $refnumber;       
    }
    public static function refnumberwork()
    {
        $year = date('Y');
        $maxnumber = DB::table('p4p_workset')->max('p4p_workset_id');
        if ($maxnumber != '' ||  $maxnumber != null) {
            $refmax = DB::table('p4p_workset')->where('p4p_workset_id', '=', $maxnumber)->first();
            if ($refmax->p4p_workset_code != '' ||  $refmax->p4p_workset_code != null) {
                $maxref = substr($refmax->p4p_workset_code, -4) + 1;
            } else {
                $maxref = 1;
            }
            $ref = str_pad($maxref, 5, "0", STR_PAD_LEFT);
        } else {
            $ref = '00001';
        }
        $ye = date('Y') + 543;
        $y = substr($ye, -2);
        $refnumberwork = 'W'.$ye . '-' . $ref;
        return $refnumberwork;       
    }
    public static function refpositionnumber()
    {
        $year = date('Y');
        $maxnumber = DB::table('p4p_work_position')->max('p4p_work_position_id');
        if ($maxnumber != '' ||  $maxnumber != null) {
            $refmax = DB::table('p4p_work_position')->where('p4p_work_position_id', '=', $maxnumber)->first();
            if ($refmax->p4p_work_position_code != '' ||  $refmax->p4p_work_position_code != null) {
                $maxref = substr($refmax->p4p_work_position_code, -4) + 1;
            } else {
                $maxref = 1;
            }
            $ref = str_pad($maxref, 5, "0", STR_PAD_LEFT);
        } else {
            $ref = '00001';
        }
        $ye = date('Y') + 543;
        $y = substr($ye, -2);
        $refpositionnumber = 'PO'.$ye . '-' . $ref;
        return $refpositionnumber;       
    }
 
 
    public function work_choose (Request $request,$id)
    { 
        $iduser = Auth::user()->id;
        $date = date('Y-m-d');
        // $m = date('m');
        $m = substr(date("m"),1);  // ตัดเลข 0 หน้า 5 ออก เช่นเดือน 05 เหลือ 5
        $data['y'] = date('Y')+543;
        // dd($m); 
        $data_user = DB::table('users')->where('id','=',$iduser)->first();
        $p4p = $data_user->group_p4p;

        $data['leave_month'] = DB::table('leave_month')->get();
        $data_ = DB::table('p4p_work')->where('p4p_work_id','=',$id)->first();
        $check_year = $data_->p4p_work_year;
        $check_month = $data_->p4p_work_month;
        // dd($month);
        $data_month = DB::table('leave_month')->where('MONTH_ID','=',$data_->p4p_work_month)->first();
        $monthth = $data_month->MONTH_NAME;
        // dd($monthth);
        $data['p4p_workgroupset_unit'] = DB::table('p4p_workgroupset_unit')->get();
        $data['p4p_workgroupset'] = P4p_workgroupset::where('p4p_workgroupset_user','=',$iduser)->get();
     
        $data['p4p_workset'] = DB::table('p4p_workset')
        ->leftjoin('p4p_workgroupset_unit','p4p_workgroupset_unit.p4p_workgroupset_unit_id','=','p4p_workset.p4p_workset_unit') 
        ->where('p4p_workset_user','=',$iduser)->where('p4p_workset_active','=','TRUE')
        ->get();
        $data['budget_year'] = DB::table('budget_year')->get();

        // $data_p4p_work = DB::table('p4p_work')->get();
  
        $data_p4p_work = DB::select('
            SELECT * from p4p_work group by p4p_work_year;
        ');
 
        // $data['p4p_workset'] = DB::table('p4p_workset')
        // ->leftjoin('p4p_work_position','p4p_work_position.p4p_work_position_id','=','p4p_workset.p4p_workset_position')
        // ->leftjoin('p4p_workgroupset_unit','p4p_workgroupset_unit.p4p_workgroupset_unit_id','=','p4p_workset.p4p_workset_unit')
        // // ->where('p4p_workset_active','=',TRUE)
        // ->where('p4p_workset_user','=',$iduser)
        // ->get();

        $p4p_work_po = DB::table('p4p_work_position')->get();
        $p4p_workload = DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->get();
        $p4p_workload_count = DB::table('p4p_workload')->where('p4p_workload_user','=',$iduser)->first();
        
        $p4p_work_show = DB::select('
            SELECT * from p4p_work ;
        ');
        return view('p4p_u.work_choose', $data,[
            'check_year'        => $check_year, 
            'check_month'       => $check_month,
            'data_'             => $data_,
            'monthth'           => $monthth,
            'p4p_work_po'       => $p4p_work_po,
            'p4p_work_id'       => $id,
            'p4p_workload'      => $p4p_workload,
            'p4p_workload_count' => $p4p_workload_count,
            'data_p4p_work'     => $data_p4p_work,
            'p4p_work_show'     => $p4p_work_show
        ]);
    }

    public function work_choose_detail (Request $request,$id)
    {
        $iduser = Auth::user()->id;
        $date = date('Y-m-d');
        // $m = date('m');
        $m = substr(date("m"),1);  // ตัดเลข 0 หน้า 5 ออก เช่นเดือน 05 เหลือ 5
        $data['y'] = date('Y')+543;
        // dd($m); 
        $data_user = DB::table('users')->where('id','=',$iduser)->first();
        $p4p = $data_user->group_p4p;

        $data['leave_month'] = DB::table('leave_month')->get();
        $data_ = DB::table('p4p_work')->where('p4p_work_id','=',$id)->first();
        $check_year = $data_->p4p_work_year;
        $check_month = $data_->p4p_work_month;
        // dd($month);
        $data_month = DB::table('leave_month')->where('MONTH_ID','=',$data_->p4p_work_month)->first();
        $monthth = $data_month->MONTH_NAME;
        // dd($monthth);
        $data['p4p_workgroupset_unit'] = DB::table('p4p_workgroupset_unit')->get();
        $data['p4p_workgroupset'] = P4p_workgroupset::where('p4p_workgroupset_user','=',$iduser)->get();
     
        $data['p4p_workset'] = DB::table('p4p_workset')
        ->leftjoin('p4p_workgroupset_unit','p4p_workgroupset_unit.p4p_workgroupset_unit_id','=','p4p_workset.p4p_workset_unit') 
        ->where('p4p_workset_user','=',$iduser)
        ->get();
        $data['budget_year'] = DB::table('budget_year')->get();

        // $data_p4p_work = DB::table('p4p_work')->get();
 
        // $p4p_workload = DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->get();
        $data_p4p_= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workset_score');
        $qty1= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_1');
        $qty2= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_2');
        $qty3= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_3');
        $qty4= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_4');
        $qty5= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_5');
        $qty6= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_6');
        $qty7= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_7');
        $qty8= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_8');
        $qty9= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_9');
        $qty10= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_10');
        $qty11= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_11');
        $qty12= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_12');
        $qty13= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_13');
        $qty14= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_14');
        $qty15= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_15');
        $qty16= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_16');
        $qty17= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_17');
        $qty18= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_18');
        $qty19= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_19');
        $qty20= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_20');
        $qty21= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_21');
        $qty22= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_22');
        $qty23= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_23');
        $qty24= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_24');
        $qty25= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_25');
        $qty26= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_26');
        $qty27= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_27');
        $qty28= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_28');
        $qty29= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_29');
        $qty30= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_30');
        $qty31= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_31'); 

        $total_qty =  $qty1+ $qty2+ $qty3+ $qty4+ $qty5+ $qty6+ $qty7+ $qty8+ $qty9+ $qty10+ $qty11+ $qty12+ $qty13+ $qty14+ $qty15+ $qty16+ $qty17+ $qty18+ $qty19+ $qty20+$qty21+$qty22+$qty23+$qty24+$qty25+$qty26+$qty27+$qty28+$qty29+$qty30+$qty31;

        $data_p4p_sum= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_sum');
        // dd($data_p4p_sum);

        $p4p_workload_count = DB::table('p4p_workload')->where('p4p_workload_user','=',$iduser)->first();
        $p4p_workload = DB::select('
            SELECT * from p4p_workload w
            left join  p4p_workset s on s.p4p_workset_id = w.p4p_workset_id
            left join  p4p_workgroupset_unit u on u.p4p_workgroupset_unit_id = s.p4p_workset_unit
            where p4p_work_id = "'.$id.'" and p4p_workload_user = "'.$iduser.'"
            ;
        ');
        $p4p_work_show = DB::select('
            SELECT * from p4p_work ;
        ');
      
        return view('p4p_u.work_choose_detail',$data,[
            'check_year'        => $check_year, 
            'check_month'       => $check_month,
            'data_'             => $data_,
            'monthth'           => $monthth, 
            'p4p_work_id'       => $id,
            'p4p_workload'      => $p4p_workload,
            'p4p_workload_count' => $p4p_workload_count,
            'p4p_work_show'     => $p4p_work_show,
            'data_p4p_'      => $data_p4p_,
            'total_qty'      => $total_qty,
            'data_p4p_sum'      => $data_p4p_sum 
        ]);
    }
    public function work_export_excel2 (Request $request,$id)
    {
        $iduser = Auth::user()->id;
        $dep_sub = Auth::user()->dep_subsubtrueid;
        $id_dep = Auth::user()->dep_id;
        $date = date('Y-m-d');
        $m = date('m');
        $data['y'] = date('Y')+543;
        // dd($m); 
        $data_user = DB::table('users')
            ->leftjoin('position','position.POSITION_ID','=','users.position_id') 
            ->leftjoin('users_prefix','users_prefix.prefix_code','=','users.pname') 
            ->where('id','=',$iduser)
            ->first();
        $p4p = $data_user->group_p4p;
        $posi = $data_user->POSITION_NAME;
        $fullname = $data_user->prefix_name.' '.$data_user->fname.'  '.$data_user->lname;

        $data['leave_month'] = DB::table('leave_month')->get();
        $data_ = DB::table('p4p_work')->where('p4p_work_id','=',$id)->first();
        $check_year = $data_->p4p_work_year;
        $check_month = $data_->p4p_work_month;
        // dd($month);
        $data_month = DB::table('leave_month')->where('MONTH_ID','=',$data_->p4p_work_month)->first();
        $monthth = $data_month->MONTH_NAME;
        // dd($monthth);
        $data['p4p_workgroupset_unit'] = DB::table('p4p_workgroupset_unit')->get();
        $data['p4p_workgroupset'] = P4p_workgroupset::where('p4p_workgroupset_user','=',$iduser)->get();
     
        $data['p4p_workset'] = DB::table('p4p_workset')
        ->leftjoin('p4p_workgroupset_unit','p4p_workgroupset_unit.p4p_workgroupset_unit_id','=','p4p_workset.p4p_workset_unit') 
        ->where('p4p_workset_user','=',$iduser)->where('p4p_workset_active','=','TRUE')
        ->get();
        $data['budget_year'] = DB::table('budget_year')->get();

        // $data_p4p_work = DB::table('p4p_work')->get();
 
        // $p4p_workload = DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->get();
        $data_p4p_= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workset_score');
        $qty1= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_1');
        $qty2= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_2');
        $qty3= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_3');
        $qty4= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_4');
        $qty5= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_5');
        $qty6= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_6');
        $qty7= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_7');
        $qty8= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_8');
        $qty9= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_9');
        $qty10= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_10');
        $qty11= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_11');
        $qty12= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_12');
        $qty13= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_13');
        $qty14= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_14');
        $qty15= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_15');
        $qty16= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_16');
        $qty17= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_17');
        $qty18= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_18');
        $qty19= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_19');
        $qty20= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_20');
        $qty21= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_21');
        $qty22= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_22');
        $qty23= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_23');
        $qty24= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_24');
        $qty25= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_25');
        $qty26= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_26');
        $qty27= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_27');
        $qty28= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_28');
        $qty29= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_29');
        $qty30= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_30');
        $qty31= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_31'); 

        $total_qty =  $qty1+ $qty2+ $qty3+ $qty4+ $qty5+ $qty6+ $qty7+ $qty8+ $qty9+ $qty10+ $qty11+ $qty12+ $qty13+ $qty14+ $qty15+ $qty16+ $qty17+ $qty18+ $qty19+ $qty20+$qty21+$qty22+$qty23+$qty24+$qty25+$qty26+$qty27+$qty28+$qty29+$qty30+$qty31;

        $data_p4p_sum= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_sum');
        // dd($data_p4p_sum);

        $p4p_workload_count = DB::table('p4p_workload')->where('p4p_workload_user','=',$iduser)->first();
        $p4p_workload = DB::select('
            SELECT * from p4p_workload w
            left join  p4p_workset s on s.p4p_workset_id = w.p4p_workset_id
            left join  p4p_workgroupset_unit u on u.p4p_workgroupset_unit_id = s.p4p_workset_unit
            where p4p_work_id = "'.$id.'" and p4p_workload_user = "'.$iduser.'"
            ;
        ');
        $p4p_work_show = DB::select('
            SELECT * from p4p_work ;
        ');
      
        $dep_sub_sub = DB::table('department_sub_sub')->where('DEPARTMENT_SUB_SUB_ID','=',$dep_sub)->first();
        $dep = DB::table('department')->where('DEPARTMENT_ID','=',$id_dep)->first();
        
        return view('p4p_u.work_export_excel2',$data,[
            'check_year'        => $check_year, 
            'check_month'       => $check_month,
            'data_'             => $data_,
            'monthth'           => $monthth, 
            'p4p_work_id'       => $id,
            'p4p_workload'      => $p4p_workload,
            'p4p_workload_count' => $p4p_workload_count,
            'p4p_work_show'     => $p4p_work_show,
            'data_p4p_'         => $data_p4p_,
            'total_qty'         => $total_qty,
            'data_p4p_sum'      => $data_p4p_sum ,
            'dep_sub_sub'       =>  $dep_sub_sub,
            'dep'               => $dep,
            'posi'              => $posi,
            'fullname'          => $fullname
        ]);
    }
    public function work_export_excel (Request $request,$id)
    {
        $iduser = Auth::user()->id;
        $dep_sub = Auth::user()->dep_subsubtrueid;
        $id_dep = Auth::user()->dep_id;
        $date = date('Y-m-d');
        $m = date('m');
        $data['y'] = date('Y')+543;
        // dd($m); 
        $data_user = DB::table('users')->where('id','=',$iduser)->first();
        $p4p = $data_user->group_p4p;

        $data['leave_month'] = DB::table('leave_month')->get();
        $data_ = DB::table('p4p_work')->where('p4p_work_id','=',$id)->first();
        $check_year = $data_->p4p_work_year;
        $check_month = $data_->p4p_work_month;
        // dd($month);
        $data_month = DB::table('leave_month')->where('MONTH_ID','=',$data_->p4p_work_month)->first();
        $monthth = $data_month->MONTH_NAME;
        // dd($monthth);
        $data['p4p_workgroupset_unit'] = DB::table('p4p_workgroupset_unit')->get();
        $data['p4p_workgroupset'] = P4p_workgroupset::where('p4p_workgroupset_user','=',$iduser)->get();
     
        $data['p4p_workset'] = DB::table('p4p_workset')
        ->leftjoin('p4p_workgroupset_unit','p4p_workgroupset_unit.p4p_workgroupset_unit_id','=','p4p_workset.p4p_workset_unit') 
        ->where('p4p_workset_user','=',$iduser)->where('p4p_workset_active','=','TRUE')
        ->get();
        $data['budget_year'] = DB::table('budget_year')->get();

        // $data_p4p_work = DB::table('p4p_work')->get();
 
        // $p4p_workload = DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->get();
        $data_p4p_= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workset_score');
        $qty1= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_1');
        $qty2= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_2');
        $qty3= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_3');
        $qty4= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_4');
        $qty5= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_5');
        $qty6= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_6');
        $qty7= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_7');
        $qty8= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_8');
        $qty9= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_9');
        $qty10= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_10');
        $qty11= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_11');
        $qty12= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_12');
        $qty13= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_13');
        $qty14= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_14');
        $qty15= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_15');
        $qty16= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_16');
        $qty17= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_17');
        $qty18= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_18');
        $qty19= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_19');
        $qty20= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_20');
        $qty21= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_21');
        $qty22= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_22');
        $qty23= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_23');
        $qty24= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_24');
        $qty25= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_25');
        $qty26= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_26');
        $qty27= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_27');
        $qty28= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_28');
        $qty29= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_29');
        $qty30= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_30');
        $qty31= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_31'); 

        $total_qty =  $qty1+ $qty2+ $qty3+ $qty4+ $qty5+ $qty6+ $qty7+ $qty8+ $qty9+ $qty10+ $qty11+ $qty12+ $qty13+ $qty14+ $qty15+ $qty16+ $qty17+ $qty18+ $qty19+ $qty20+$qty21+$qty22+$qty23+$qty24+$qty25+$qty26+$qty27+$qty28+$qty29+$qty30+$qty31;

        $data_p4p_sum= DB::table('p4p_workload')->where('p4p_work_id','=',$id)->where('p4p_workload_user','=',$iduser)->sum('p4p_workload_sum');
        // dd($data_p4p_sum);

        $p4p_workload_count = DB::table('p4p_workload')->where('p4p_workload_user','=',$iduser)->first();
        $p4p_workload = DB::select('
            SELECT * from p4p_workload w
            left join  p4p_workset s on s.p4p_workset_id = w.p4p_workset_id
            left join  p4p_workgroupset_unit u on u.p4p_workgroupset_unit_id = s.p4p_workset_unit
            where p4p_work_id = "'.$id.'" and p4p_workload_user = "'.$iduser.'"
            ;
        ');
        $p4p_work_show = DB::select('
            SELECT * from p4p_work ;
        ');
      
        $dep_sub_sub = DB::table('department_sub_sub')->where('DEPARTMENT_SUB_SUB_ID','=',$dep_sub)->first();
        $dep = DB::table('department')->where('DEPARTMENT_ID','=',$id_dep)->first();
        
        return view('p4p_u.work_export_excel',$data,[
            'check_year'        => $check_year, 
            'check_month'       => $check_month,
            'data_'             => $data_,
            'monthth'           => $monthth, 
            'p4p_work_id'       => $id,
            'p4p_workload'      => $p4p_workload,
            'p4p_workload_count' => $p4p_workload_count,
            'p4p_work_show'     => $p4p_work_show,
            'data_p4p_'      => $data_p4p_,
            'total_qty'      => $total_qty,
            'data_p4p_sum'      => $data_p4p_sum ,
            'dep_sub_sub'     =>  $dep_sub_sub,
            'dep'             => $dep
        ]);
    }

    public function work_choose_processpdf(Request $request,$id)
    {
        $dataedit = P4p_work::where('p4p_work_id','=',$id)->first(); 
        // download sample file.
        // Storage::disk('local')->put('test.pdf', file_get_contents('http://www.africau.edu/images/default/sample.pdf'));
        Storage::disk('local')->put('test.pdf', file_get_contents('storage/p4p/'.$dataedit->p4p_work_file));
        

        $outputFile = Storage::disk('local')->path('output.pdf');
        // $outputFile = 'storage/bookrep_pdf/'.$dataedit->bookrep_file;
        // fill data
        $this->fillPDF(Storage::disk('local')->path('test.pdf'), $outputFile);
        //output to browser
        return response()->file($outputFile);
    }

    public function work_choose_pdf(Request $request, $id)
    {        
        $dataedit = P4p_work::where('p4p_work_id','=',$id)->first(); 
        $work_file = $dataedit->p4p_work_file;
        // $signature = DB::table('book_signature')->where('bookrep_id','=',$id)->first();
        $org = DB::table('orginfo')->where('orginfo_id','=',1)
        ->leftjoin('users','users.id','=','orginfo.orginfo_manage_id')
        ->leftjoin('users_prefix','users_prefix.prefix_code','=','users.pname')
        ->first();
        $rong = $org->prefix_name.' '.$org->fname.'  '.$org->lname;

        $orgpo = DB::table('orginfo')->where('orginfo_id','=',1)
        ->leftjoin('users','users.id','=','orginfo.orginfo_po_id')
        ->leftjoin('users_prefix','users_prefix.prefix_code','=','users.pname')
        ->first();
        $po = $orgpo->prefix_name.' '.$orgpo->fname.'  '.$orgpo->lname;

        $count = DB::table('p4p_work')->where('p4p_work_id','=',$id)->count();
        
        // dd($count);
        // if ($count != 0) {
        //     $signature = DB::table('book_signature')->where('bookrep_id','=',$id)->first();
        //     $siguser = $signature->signature_name_usertext; //ผู้รองขอ
        //     $sighn = $signature->signature_name_hntext; //หัวหน้า
        //     $sig = $signature->signature_name_text; //หัวหน้าบริหาร
        //     $sigpo = $signature->signature_name_potext; //ผอ
            
        // } else {
        //     $sig = '';
        //     $siguser = '';
        //     $sighn = '';
        //     $sigpo = '';
        // }
                
        define('FPDF_FONTPATH','font/');
        require(base_path('public')."/fpdf/WriteHTML.php");

        $pdf = new Fpdi();// Instantiation   start-up Fpdi
        $path = 'storage/p4p/'.$dataedit->p4p_work_file.'.pdf';// existing PDF Templates ( The material file is in   Project name \public\testA.pdf)
        $table = 'storage/p4p/p4p_1.pdf'; // 'p4p_work_file' => "p4p_".$y.'_'.$p4p_work_id
        
        
        $count = $pdf->setSourceFile($path);
        for ($i=1; $i<=$count; $i++) {
            $template   = $pdf->importPage($i);
            $size       = $pdf->getTemplateSize($template);
            $pdf->AddPage($size['orientation'], array($size['width'], $size['height']));
            $pdf->useTemplate($template);      
            $pdf->AddFont('THSarabunNew','','THSarabunNew.php');
            $pdf->SetFont('THSarabunNew','',15); 
            $left = 150;
            $top = 12;   
        }
        $pdf->Output('I', 'example.pdf');// Output results  I: Direct input ,D: Download the file ,F: Save to local file ,S: Return string 
            
    }
    public function openpdf(Request $request, $id)
    {
        $dataedit = P4p_work::where('p4p_work_id','=',$id)->first(); 
        $work_file = $dataedit->p4p_work_file;
        $pdf = PDF::loadView('formpdf.11485.infowithdrawindex_billpaypdf_11485',[
            'dataedits'=>$dataedit
        ]);
        return @$pdf->stream();
    }
    // public function p4p_work_choose_save(Request $request)
    // {  
       
    //     $p4p_work_id = $request->p4p_work_id;
    //     $p4p_workset_id = $request->p4p_workset_id;

    //     $check = P4p_work_score::where('p4p_work_id','=',$p4p_work_id)->where('p4p_workset_id','=',$p4p_workset_id)->count();
    //     if ($check > 0) { 
    //         return response()->json([
    //             'status'     => '100' 
    //         ]);
    //     } else {
    //         $add = new P4p_work_score(); 
    //         $add->p4p_workset_id = $request->p4p_workset_id;
    //         $add->p4p_work_id = $request->p4p_work_id; 
    //         $add->save();
    //         return response()->json([
    //             'status'     => '200' 
    //         ]);
    //     }

    //     return response()->json([
    //         'status'     => '200' 
    //     ]);
    // }
    public function work_load_save(Request $request)
    {  
        $workset_id = $request->p4p_workset_id;
        $iduser = $request->p4p_workload_user;
        $p4p_work_id = $request->p4p_work_id;
        $date = date('Y-m-d');
        $data_ = P4p_workload::where('p4p_workload_user','=',$iduser)->get();
        $ws = DB::table('p4p_workset')->where('p4p_workset_id','=',$workset_id)->first();
 
        if ($workset_id != '') {
            $add = new P4p_workload(); 
            $add->p4p_work_id = $p4p_work_id;
            $add->p4p_workload_date = $date;
            $add->p4p_workset_id = $ws->p4p_workset_id;
            $add->p4p_workset_code = $ws->p4p_workset_code;
            $add->p4p_workset_name = $ws->p4p_workset_name;
            $add->p4p_workset_unit = $ws->p4p_workset_unit;
            $add->p4p_workset_time = $ws->p4p_workset_time;
            $add->p4p_workset_score = $ws->p4p_workset_score; 

            $add->p4p_workload_user = $iduser;
            $add->save();

            $y = date('Y')+543;
            P4p_work::where('p4p_work_id', $p4p_work_id) 
            ->update([    
                'p4p_work_file' => "p4p_".$y.'_'.$p4p_work_id
            ]); 


            return response()->json([
                'status'     => '200' 
            ]);
        } else {
            return response()->json([
                'status'     => '100' 
            ]);
        }
        
               
             
    }
    public function work_load_saveCopy(Request $request)
    {  
        // $iduser = Auth::user()->id;
        $id = $request->id; 
        $p4p_work_id = $request->p4p_work_id2;  
        $iduser = $request->p4p_workload_user;
        if ( $p4p_work_id != '' || $p4p_work_id != null) { 
            $check_data = P4p_workload::where('p4p_work_id','=',$p4p_work_id)->where('p4p_workload_user','=',$iduser)->first(); 
            $workset_id =  $check_data->p4p_workset_id;
           
        
           
            $check_work = P4p_workload::where('p4p_work_id','=',$p4p_work_id)->where('p4p_workload_user','=',$iduser)->where('p4p_workset_id','=',$workset_id)->count();
            if ($check_work >0) {
                              
                // $check = P4p_workload::where('p4p_work_id','=',$p4p_work_id)->where('p4p_workset_id','=',$workset_id)->where('p4p_workload_user','=',$iduser)->count();
                // $check = P4p_workload::where('p4p_work_id','=',$p4p_work_id)->where('p4p_workload_user','=',$iduser)->count();
                // $workset_id = $request->p4p_workset_id;
               
                $date = date('Y-m-d');            
                // if ($check >0) {
                    $data_ = DB::select('
                        SELECT * from p4p_workload where p4p_workload_user = "'.$iduser.'" AND p4p_work_id = "'.$p4p_work_id.'";
                    ');

                    foreach ($data_ as $key => $value) { 
                        P4p_workload::insert([
                            'p4p_work_id' => $id,
                            'p4p_workload_date' => $date,
                            'p4p_workset_id' => $value->p4p_workset_id,
                            'p4p_workset_code' => $value->p4p_workset_code,
                            'p4p_workset_name' => $value->p4p_workset_name,
                            'p4p_workset_unit' => $value->p4p_workset_unit,
                            'p4p_workset_time' => $value->p4p_workset_time, 
                            'p4p_workset_score' => $value->p4p_workset_score,
                            'p4p_workload_user' => $iduser 
                            
                        ]);                
                    }                
                    return response()->json([
                        'status'     => '200' 
                    ]);
                   
                // } else {
                //     return response()->json([
                //         'status'     => '170' 
                //     ]);
                // }
            } else {
                
                return response()->json([
                    'status'     => '150' 
                ]);
            } 
             
        } else {
            return response()->json([
                'status'     => '120' 
            ]);
        }   
    }
    public function work_load_update(Request $request)
    {  
        $id = $request->id; 
       
        $p4p_work_id = $request->p4p_work_id;
        $p4p_workload_user = $request->p4p_workload_user;
        // dd($p4p_workload_user);
        // P4p_workload::where('p4p_work_id','=',$p4p_work_id)->delete();

        if($request->p4p_workload_1A != '' || $request->p4p_workload_1A != null){
            
            $p4p_workset_id = $request->p4p_workset_id;

            $p4p_workload_1 = $request->p4p_workload_1A;
            $p4p_workload_2 = $request->p4p_workload_2B;
            $p4p_workload_3 = $request->p4p_workload_3C;
            $p4p_workload_4 = $request->p4p_workload_4D;
            $p4p_workload_5 = $request->p4p_workload_5E;
            $p4p_workload_6 = $request->p4p_workload_6F;
            $p4p_workload_7 = $request->p4p_workload_7G;
            $p4p_workload_8 = $request->p4p_workload_8E;
            $p4p_workload_9 = $request->p4p_workload_9F;
            $p4p_workload_10 = $request->p4p_workload_10G;
            $p4p_workload_11 = $request->p4p_workload_11H;
            $p4p_workload_12 = $request->p4p_workload_12I;
            $p4p_workload_13 = $request->p4p_workload_13J;
            $p4p_workload_14 = $request->p4p_workload_14K;
            $p4p_workload_15 = $request->p4p_workload_15L;
            $p4p_workload_16 = $request->p4p_workload_16M;
            $p4p_workload_17 = $request->p4p_workload_17N;
            $p4p_workload_18 = $request->p4p_workload_18O;
            $p4p_workload_19 = $request->p4p_workload_19P;
            $p4p_workload_20 = $request->p4p_workload_20Q;
            $p4p_workload_21 = $request->p4p_workload_21R;
            $p4p_workload_22 = $request->p4p_workload_22S;
            $p4p_workload_23 = $request->p4p_workload_23T;
            $p4p_workload_24 = $request->p4p_workload_24U;
            $p4p_workload_25 = $request->p4p_workload_25V;
            $p4p_workload_26 = $request->p4p_workload_26W;
            $p4p_workload_27 = $request->p4p_workload_27X;
            $p4p_workload_28 = $request->p4p_workload_28Y;
            $p4p_workload_29 = $request->p4p_workload_29Z;
            $p4p_workload_30 = $request->p4p_workload_30ZZ;
            $p4p_workload_31 = $request->p4p_workload_31XZ;

            // dd($p4p_workload_2);
        $number =count($p4p_workload_1);
         
         $count = 0;
         for($count = 0; $count < $number; $count++)
            {  
                    if(isset($p4p_workload_1[$count]) <> false){$amount_1 = $p4p_workload_1[$count];}else{$amount_1 = 0;}
                    if(isset($p4p_workload_2[$count]) <> false){$amount_2 = $p4p_workload_2[$count];}else{$amount_2 = 0;}
                    if(isset($p4p_workload_3[$count]) <> false){$amount_3 = $p4p_workload_3[$count];}else{$amount_3 = 0;}
                    if(isset($p4p_workload_4[$count]) <> false){$amount_4 = $p4p_workload_4[$count];}else{$amount_4 = 0;}
                    if(isset($p4p_workload_5[$count]) <> false){$amount_5 = $p4p_workload_5[$count];}else{$amount_5 = 0;}
                    if(isset($p4p_workload_6[$count]) <> false){$amount_6 = $p4p_workload_6[$count];}else{$amount_6 = 0;}
                    if(isset($p4p_workload_7[$count]) <> false){$amount_7 = $p4p_workload_7[$count];}else{$amount_7 = 0;}
                    if(isset($p4p_workload_8[$count]) <> false){$amount_8 = $p4p_workload_8[$count];}else{$amount_8 = 0;}
                    if(isset($p4p_workload_9[$count]) <> false){$amount_9 = $p4p_workload_9[$count];}else{$amount_9 = 0;}
                    if(isset($p4p_workload_10[$count]) <> false){$amount_10 = $p4p_workload_10[$count];}else{$amount_10 = 0;}
                    if(isset($p4p_workload_11[$count]) <> false){$amount_11 = $p4p_workload_11[$count];}else{$amount_11 = 0;}
                    if(isset($p4p_workload_12[$count]) <> false){$amount_12 = $p4p_workload_12[$count];}else{$amount_12 = 0;}
                    if(isset($p4p_workload_13[$count]) <> false){$amount_13 = $p4p_workload_13[$count];}else{$amount_13 = 0;}
                    if(isset($p4p_workload_14[$count]) <> false){$amount_14 = $p4p_workload_14[$count];}else{$amount_14 = 0;}
                    if(isset($p4p_workload_15[$count]) <> false){$amount_15 = $p4p_workload_15[$count];}else{$amount_15 = 0;}
                    if(isset($p4p_workload_16[$count]) <> false){$amount_16 = $p4p_workload_16[$count];}else{$amount_16 = 0;}
                    if(isset($p4p_workload_17[$count]) <> false){$amount_17= $p4p_workload_17[$count];}else{$amount_17 = 0;}
                    if(isset($p4p_workload_18[$count]) <> false){$amount_18 = $p4p_workload_18[$count];}else{$amount_18 = 0;}
                    if(isset($p4p_workload_19[$count]) <> false){$amount_19 = $p4p_workload_19[$count];}else{$amount_19 = 0;}
                    if(isset($p4p_workload_20[$count]) <> false){$amount_20 = $p4p_workload_20[$count];}else{$amount_20 = 0;}
                    if(isset($p4p_workload_21[$count]) <> false){$amount_21 = $p4p_workload_21[$count];}else{$amount_21 = 0;}
                    if(isset($p4p_workload_22[$count]) <> false){$amount_22 = $p4p_workload_22[$count];}else{$amount_22 = 0;}
                    if(isset($p4p_workload_23[$count]) <> false){$amount_23 = $p4p_workload_23[$count];}else{$amount_23 = 0;}
                    if(isset($p4p_workload_24[$count]) <> false){$amount_24 = $p4p_workload_24[$count];}else{$amount_24 = 0;}
                    if(isset($p4p_workload_25[$count]) <> false){$amount_25= $p4p_workload_25[$count];}else{$amount_25 = 0;}
                    if(isset($p4p_workload_26[$count]) <> false){$amount_26 = $p4p_workload_26[$count];}else{$amount_26 = 0;}
                    if(isset($p4p_workload_27[$count]) <> false){$amount_27 = $p4p_workload_27[$count];}else{$amount_27 = 0;}
                    if(isset($p4p_workload_28[$count]) <> false){$amount_28 = $p4p_workload_28[$count];}else{$amount_28 = 0;}
                    if(isset($p4p_workload_29[$count]) <> false){$amount_29 = $p4p_workload_29[$count];}else{$amount_29 = 0;}
                    if(isset($p4p_workload_30[$count]) <> false){$amount_30 = $p4p_workload_30[$count];}else{$amount_30 = 0;}
                    if(isset($p4p_workload_31[$count]) <> false){$amount_31 = $p4p_workload_31[$count];}else{$amount_31 = 0;}

                    $date = date('Y-m-d');
                    $data_w = P4p_workset::where('p4p_workset_id','=',$p4p_workset_id[$count])->first();
                    $score = $data_w->p4p_workset_score;

                    $sumtotal = $score * ($amount_1+$amount_2+$amount_3+$amount_4+$amount_5+$amount_6+$amount_7+$amount_8+$amount_9+$amount_10+$amount_11+$amount_12+$amount_13+$amount_14+$amount_15+$amount_16+$amount_17+$amount_18+$amount_19+$amount_20+$amount_21+$amount_22+$amount_23+$amount_24+$amount_25+$amount_26+$amount_27+$amount_28+$amount_29+$amount_30+$amount_31);
                 
                    P4p_workload::where('p4p_work_id', $p4p_work_id)->where('p4p_workset_id', $p4p_workset_id[$count]) 
                    ->update([   
                        'p4p_work_id' => $p4p_work_id,
                        'p4p_workload_date' => $date,
                        'p4p_workset_code' => $data_w->p4p_workset_code,
                        'p4p_workset_name' => $data_w->p4p_workset_name,
                        'p4p_workset_unit' => $data_w->p4p_workset_unit,
                        'p4p_workset_score' => $data_w->p4p_workset_score,

                        'p4p_workset_id' => $p4p_workset_id[$count],
                        'p4p_workload_1' => $amount_1,
                        'p4p_workload_2' => $amount_2,
                        'p4p_workload_3' => $amount_3,
                        'p4p_workload_4' => $amount_4,
                        'p4p_workload_5' => $amount_5, 
                        'p4p_workload_6' => $amount_6,
                        'p4p_workload_7' => $amount_7,
                        'p4p_workload_8' => $amount_8,
                        'p4p_workload_9' => $amount_9,
                        'p4p_workload_10' => $amount_10,
                        'p4p_workload_11' => $amount_11,
                        'p4p_workload_12' => $amount_12,
                        'p4p_workload_13' => $amount_13,
                        'p4p_workload_14' => $amount_14,
                        'p4p_workload_15' => $amount_15,
                        'p4p_workload_16' => $amount_16,
                        'p4p_workload_17' => $amount_17,
                        'p4p_workload_18' => $amount_18,
                        'p4p_workload_19' => $amount_19,
                        'p4p_workload_20' => $amount_20,
                        'p4p_workload_21' => $amount_21,
                        'p4p_workload_22' => $amount_22,
                        'p4p_workload_23' => $amount_23,
                        'p4p_workload_24' => $amount_24,
                        'p4p_workload_25' => $amount_25,
                        'p4p_workload_26' => $amount_26,
                        'p4p_workload_27' => $amount_27,
                        'p4p_workload_28' => $amount_28,
                        'p4p_workload_29' => $amount_29,
                        'p4p_workload_30' => $amount_30,
                        'p4p_workload_31' => $amount_31,
                        'p4p_workload_user' => $p4p_workload_user, 
                        'p4p_workload_sum' => $sumtotal
                    ]);  

                    $y = date('Y')+543;
                    // P4p_work::where('p4p_work_id', $p4p_work_id) 
                    // ->update([    
                    //     'p4p_work_filename' => "p4p_".$y.'_'.$p4p_work_id,
                    //     // 'p4p_work_file' => p4p_work_filename->storeAs('bookrep_pdf', "p4p_".$y.'_'.$p4p_work_id,'public')
                    // ]); 
                    $filename = "p4p_".$y.'_'.$p4p_work_id;
                    $update = P4p_work::find($p4p_work_id);
                    $update->p4p_work_filename = $filename;
                    // $request->p4p_work_file->storeAs('p4p',$filename,'public');
                    $update->save();


                    // // if($request->hasFile('bookrep_file5')){
                    //     $newFileName5 = 'p4p_'.$idfile.'_5'.'.'.$request->bookrep_file5->extension();                
                    //     $request->bookrep_file5->storeAs('bookrep_pdf',$newFileName5,'public');
                    //     $add->bookrep_file5 = $newFileName5; 
                    // // }

            }
        }
        // return redirect()->route('user.p4p_user');
        return response()->json([
            'status'     => '200' 
        ]);
    }

    public function work_load_destroy(Request $request, $id)
    {
        $del = P4p_workload::find($id);
        $del->delete();
        return response()->json(['status' => '200']);
    }

    // public function p4p_work_choose_worksetsave(Request $request)
    // {  
    //     $work_id = $request->p4p_work_id;
    //     $iduser = $request->p4p_workgroupset_user;

    //     $data_ = P4p_workset::where('p4p_workset_user','=',$iduser)->get();
    //     // $data_ = P4p_workset::get();
       
    //     foreach ($data_ as $key => $value) {
    //         $check = P4p_work_score::where('p4p_work_id','=',$work_id)->where('p4p_workset_id','=',$value->p4p_workset_id)->count();
    //         // dd($check);
    //         if ($check > 0) {
    //             // $add = new P4p_work_score(); 
    //             // $add->p4p_work_id = $work_id;
    //             // $add->p4p_workset_id = $value->p4p_workset_id; 
    //             // $add->save();
    //             // return response()->json([
    //             //     'status'     => '200' 
    //             // ]);

    //             // $check2 = P4p_work_score::where('p4p_workset_id','=',$value->p4p_workset_id)->count();
    //             // if ($check2 > 0) {
    //             //     return response()->json([
    //             //         'status'     => '100' 
    //             //     ]);
    //             // } else {
    //             //     # code...
    //             // }       
    //                  return response()->json([
    //                     'status'     => '100' 
    //                 ]);                       
               
    //         } else {
    //             $add = new P4p_work_score(); 
    //             $add->p4p_work_id = $work_id;
    //             $add->p4p_workset_id = $value->p4p_workset_id; 
    //             $add->save();
    //             return response()->json([
    //                 'status'     => '200' 
    //             ]);
    //         }
            
    //         // return response()->json([
    //         //     'status'     => '200' 
    //         // ]);
    //     }
       

       
    // }
    // public function p4p_workgroupset_save(Request $request)
    // {  
    //     $add = new P4p_workgroupset(); 
    //     $add->p4p_workgroupset_code = $request->p4p_workgroupset_code;
    //     $add->p4p_workgroupset_name = $request->p4p_workgroupset_name;
    //     $add->p4p_workgroupset_user = $request->p4p_workgroupset_user;
    //     $add->save();

    //     return response()->json([
    //         'status'     => '200' 
    //     ]);
    // }
    // public function p4p_workgroupset_edit (Request $request,$id)
    // { 
    //     $iduser = Auth::user()->id;
    //     $data_show = P4p_workgroupset::where('p4p_workgroupset_id','=',$id)->first();
    //     $data['p4p_workgroupset'] = P4p_workgroupset::where('p4p_workgroupset_user','=',$iduser)->get();

    //     return view('p4p.p4p_workgroupset_edit', $data,[
    //         'data_show' => $data_show, 
    //     ]);
    // }       
    // public function p4p_workgroupset_update(Request $request)
    // {  
    //     $id = $request->p4p_workgroupset_id;
    //     $update = P4p_workgroupset::find($id); 
    //     $update->p4p_workgroupset_code = $request->p4p_workgroupset_code;
    //     $update->p4p_workgroupset_name = $request->p4p_workgroupset_name;
    //     $update->p4p_workgroupset_user = $request->p4p_workgroupset_user;
    //     $update->save();

    //     return response()->json([
    //         'status'     => '200' 
    //     ]);
    // }
    // function p4p_workgroupset_switchactive(Request $request)
    // {  
    //     $id = $request->idfunc; 
    //     $active = P4p_workgroupset::find($id);
    //     $active->p4p_workgroupset_active = $request->onoff;
    //     $active->save();
    // }
    // public function p4p_work_position (Request $request)
    // { 
    //     $iduser = Auth::user()->id;
    //     $date = date('Y-m-d');
    //     $m = date('m');
    //     $data['y'] = date('Y')+543;
    //     $data['users'] = User::get();
    //     $data['leave_month'] = DB::table('leave_month')->get(); 
    //     $data['budget_year'] = DB::table('budget_year')->get();
    //     $data['p4p_work_position'] = DB::table('p4p_work_position')
    //     // ->leftjoin('leave_month','leave_month.MONTH_ID','=','p4p_work.p4p_work_month') 
    //     // ->where('p4p_work_position_user','=',$iduser)
    //     ->get();
    //     return view('p4p.p4p_work_position', $data,[
    //         // 'data_show' => $data_show,
    //         // 'month'       => $month 
    //     ]);
    // }
    // public function p4p_work_position_save(Request $request)
    // {  
    //     $add = new P4p_work_position(); 
    //     $add->p4p_work_position_code = $request->p4p_work_position_code;
    //     $add->p4p_work_position_name = $request->p4p_work_position_name;
    //     $add->p4p_work_position_user = $request->p4p_work_position_user;
    //     // $add->p4p_work_code = $request->p4p_work_code; 
    //     $add->save();

    //     return response()->json([
    //         'status'     => '200' 
    //     ]);
    // }
   
    // public function p4p_work_position_edit (Request $request,$id)
    // { 
    //     $iduser = Auth::user()->id;
    //     $data_show = P4p_work_position::where('p4p_work_position_id','=',$id)->first();
    //     $data['p4p_work_position'] = P4p_work_position::where('p4p_work_position_user','=',$iduser)->get();

    //     return view('p4p.p4p_work_position_edit', $data,[
    //         'data_show' => $data_show, 
    //     ]);
    // }
    // public function p4p_work_position_update(Request $request)
    // {  
    //     $id = $request->p4p_work_position_id;
    //     $update = P4p_work_position::find($id); 
    //     $update->p4p_work_position_code = $request->p4p_work_position_code;
    //     $update->p4p_work_position_name = $request->p4p_work_position_name;
    //     $update->p4p_work_position_user = $request->p4p_work_position_user; 
    //     $update->save();

    //     return response()->json([
    //         'status'     => '200' 
    //     ]);
    // }
    // function p4p_work_position_switchactive(Request $request)
    // {  
    //     $id = $request->idfunc; 
    //     $active = P4p_work_position::find($id);
    //     $active->p4p_work_position_active = $request->onoff;
    //     $active->save();
    // }
    // public function p4p_work_position_sub (Request $request,$id)
    // {  
    //     $data['leave_month'] = DB::table('leave_month')->get(); 
    //     $data['budget_year'] = DB::table('budget_year')->get();
    //     $data['p4p_workgroupset_unit'] = DB::table('p4p_workgroupset_unit')->get();
    //     $data['p4p_workgroupset'] = DB::table('p4p_workgroupset')->get();

    //     $data['p4p_work_position'] = DB::table('p4p_work_position')
    //     ->where('p4p_work_position_id','=',$id)->first();

    //     $data['p4p_workset'] = DB::table('p4p_workset')
    //     ->leftjoin('p4p_work_position','p4p_work_position.p4p_work_position_id','=','p4p_workset.p4p_workset_position')
    //     ->leftjoin('p4p_workgroupset_unit','p4p_workgroupset_unit.p4p_workgroupset_unit_id','=','p4p_workset.p4p_workset_unit')
    //     // ->where('p4p_workset_active','=',TRUE)
    //     ->where('p4p_workset_position','=',$id)
    //     ->get();

    //     return view('p4p.p4p_work_position_sub', $data,[
    //         // 'data_show' => $data_show,
    //         // 'month'       => $month 
    //     ]);
    // }
    // public function p4p_work_scorenowsave(Request $request)
    // {  
       
    //     $p4p_workload_date = $request->p4p_workload_date;
    //     $p4p_workset_id = $request->p4p_workset_id;
    //     // $p4p_workset_score_now = $request->p4p_workset_score_now;

    //     $wset = P4p_workset::where('p4p_workset_id','=',$p4p_workset_id)->first();
    //     // if ($check > 0) { 
    //     //     return response()->json([
    //     //         'status'     => '100' 
    //     //     ]);
    //     // } else {
    //         $add = new P4p_workload(); 
    //         $add->p4p_workload_date = $p4p_workload_date;
    //         $add->p4p_workset_id = $p4p_workset_id; 
    //         $add->p4p_work_id = $request->p4p_work_id; 
    //         $add->p4p_workset_code = $wset->p4p_workset_code; 
    //         $add->p4p_workset_name = $wset->p4p_workset_name; 
    //         $add->p4p_workset_time = $wset->p4p_workset_time; 
    //         $add->p4p_workset_score = $wset->p4p_workset_score; 
    //         $add->p4p_workset_unit = $wset->p4p_workset_unit; 
    //         $add->p4p_workset_wp = $wset->p4p_workset_wp;

    //         $add->p4p_workset_score_now = $request->p4p_workset_score_now; 
    //         // $add->p4p_workload_totalscore = $request->p4p_workset_score_now; 
    //         $add->save();
    //         return response()->json([
    //             'status'     => '200' 
    //         ]);
    //     // }

    //     return response()->json([
    //         'status'     => '200' 
    //     ]);
    // }
 
 
}

 