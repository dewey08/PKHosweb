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
use Auth;

class P4pController extends Controller
{
    public function p4p(Request $request)
    {
        $datestart = $request->startdate;
        $dateend = $request->enddate;
        $iddep =  Auth::user()->dep_subsubtrueid;
        // dd($iddep);
        $reqsend = $request->ot_type_pk;

        $data['ot_one'] = DB::table('ot_one')
        ->leftjoin('users','users.id','=','ot_one.ot_one_nameid')
        ->leftjoin('users_prefix','users_prefix.prefix_code','=','users.pname')
        ->leftjoin('department_sub_sub','department_sub_sub.DEPARTMENT_SUB_SUB_ID','=','ot_one.dep_subsubtrueid')
        ->where('ot_one.dep_subsubtrueid','=',$iddep)
        ->where('users.users_group_id','=',$reqsend) 
        ->whereBetween('ot_one_date', [$datestart, $dateend])->get();

        $data['users'] = User::get();
        $data['leave_month'] = DB::table('leave_month')->get();
        $data['users_group'] = DB::table('users_group')->get();
        $data['ot_type_pk'] = DB::table('ot_type_pk')->get();

        return view('p4p.p4p', $data,[
            'start' => $datestart,
            'end' => $dateend,
            'reqsend' => $reqsend
        ]);
    }
    public function p4p_activity (Request $request)
    {
        $datestart = $request->startdate;
        $dateend = $request->enddate;
        
        $data['users'] = User::get();
        $data['leave_month'] = DB::table('leave_month')->get();
        $data['users_group'] = DB::table('users_group')->get();
        $data['ot_type_pk'] = DB::table('ot_type_pk')->get();

        return view('p4p.p4p_activity ', $data,[
            'start' => $datestart,
            'end' => $dateend, 
        ]);
    }
    public function p4p_workset (Request $request)
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

        return view('p4p.p4p_workset ', $data,[
            'start' => $datestart,
            'end' => $dateend, 
        ]);
    }
    public function p4p_workset_edit (Request $request,$id)
    { 
        $iduser = Auth::user()->id;

        $data_show = P4p_workset::where('p4p_workset_id','=',$id)->first();
        $data['p4p_workset'] = P4p_workset::leftjoin('p4p_workgroupset_unit','p4p_workgroupset_unit.p4p_workgroupset_unit_id','=','p4p_workset.p4p_workset_unit')
        ->where('p4p_workset_user','=',$iduser)->get();
        $data['p4p_workgroupset_unit'] = DB::table('p4p_workgroupset_unit')->get();
        $data['p4p_workgroupset'] = DB::table('p4p_workgroupset')->where('p4p_workgroupset_user','=',$iduser)->get();
        $data['p4p_work_position'] = DB::table('p4p_work_position')->get();

        return view('p4p.p4p_workset_edit', $data,[
            'data_show' => $data_show, 
        ]);
    }
    public function p4p_workset_save(Request $request)
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
    public function p4p_workset_update(Request $request)
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
    function p4p_workset_switchactive(Request $request)
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

    public function p4p_workgroupset (Request $request)
    {
        $datestart = $request->startdate;
        $dateend = $request->enddate;
        $iduser = Auth::user()->id;
        $data['users'] = User::get();
        $data['leave_month'] = DB::table('leave_month')->get();
        $data['users_group'] = DB::table('users_group')->get();
        $data['p4p_workgroupset'] = P4p_workgroupset::where('p4p_workgroupset_user','=',$iduser)->get();

        return view('p4p.p4p_workgroupset', $data,[
            'start' => $datestart,
            'end' => $dateend, 
        ]);
    }
    
    public function p4p_work (Request $request)
    {
        $datestart = $request->startdate;
        $dateend = $request->enddate;
        $iduser = Auth::user()->id;
        $date = date('Y-m-d');
        $m = date('m');
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

        return view('p4p.p4p_work', $data,[
            'start'       => $datestart,
            'end'         => $dateend, 
            'month'       => $month
        ]);
    }
    public function p4p_work_save(Request $request)
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
    public function p4p_work_edit (Request $request,$id)
    { 
        $iduser = Auth::user()->id;
        $date = date('Y-m-d');
        $m = date('m');
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
        return view('p4p.p4p_work_edit', $data,[
            'data_show' => $data_show,
            'month'       => $month 
        ]);
    }
    public function p4p_work_update(Request $request)
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
 
    public function p4p_work_choose (Request $request,$id)
    { 
        $iduser = Auth::user()->id;
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
        ->where('p4p_workset_user','=',$iduser)
        ->get();
        $data['budget_year'] = DB::table('budget_year')->get();

        // $data_p4p_work = DB::table('p4p_work')->get();
  
        $data_p4p_work = DB::select('
            SELECT * from p4p_work group by p4p_work_year;
        ');
 
        $data['p4p_workset'] = DB::table('p4p_workset')
        ->leftjoin('p4p_work_position','p4p_work_position.p4p_work_position_id','=','p4p_workset.p4p_workset_position')
        ->leftjoin('p4p_workgroupset_unit','p4p_workgroupset_unit.p4p_workgroupset_unit_id','=','p4p_workset.p4p_workset_unit')
        // ->where('p4p_workset_active','=',TRUE)
        ->where('p4p_workset_user','=',$iduser)
        ->get();

        $p4p_work_po = DB::table('p4p_work_position')->get();
        $p4p_workload = DB::table('p4p_workload')->where('p4p_work_id','=',$id)->get();
        $p4p_workload_count = DB::table('p4p_workload')->where('p4p_workload_user','=',$iduser)->first();
        
        $p4p_work_show = DB::select('
            SELECT * from p4p_work ;
        ');
        return view('p4p.p4p_work_choose', $data,[
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
    public function p4p_work_choose_save(Request $request)
    {  
       
        $p4p_work_id = $request->p4p_work_id;
        $p4p_workset_id = $request->p4p_workset_id;

        $check = P4p_work_score::where('p4p_work_id','=',$p4p_work_id)->where('p4p_workset_id','=',$p4p_workset_id)->count();
        if ($check > 0) { 
            return response()->json([
                'status'     => '100' 
            ]);
        } else {
            $add = new P4p_work_score(); 
            $add->p4p_workset_id = $request->p4p_workset_id;
            $add->p4p_work_id = $request->p4p_work_id; 
            $add->save();
            return response()->json([
                'status'     => '200' 
            ]);
        }

        return response()->json([
            'status'     => '200' 
        ]);
    }
    public function p4p_work_load_save(Request $request)
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
            return response()->json([
                'status'     => '200' 
            ]);
        } else {
            return response()->json([
                'status'     => '100' 
            ]);
        }
        
               
             
    }
    public function p4p_work_load_saveCopy(Request $request)
    {  
        $id = $request->id; 
        $p4p_work_id = $request->p4p_work_id2;  

        if ( $p4p_work_id != '') {
            $check_data = P4p_work::where('p4p_work_id','=',$p4p_work_id)->first();
            $month =  $check_data->p4p_work_month; 
            $year =  $check_data->p4p_work_year; 
    
            $check = P4p_work::where('p4p_work_year','=',$year)->where('p4p_work_month','=',$month)->count();
            // $workset_id = $request->p4p_workset_id;
            $iduser = $request->p4p_workload_user;
            $date = date('Y-m-d');
            // $data_ = P4p_workload::where('p4p_workload_user','=',$iduser)->where('p4p_work_id','=',$p4p_work_id)->get(); 
            // $data_ = P4p_workload::where('p4p_workload_user','=',$iduser)->where('p4p_work_id','=',$id)->where('p4p_workset_id','=',$workset_id)->get(); 
           
            
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
                    // 'p4p_workset_time' => $value->p4p_workset_time, 
                    'p4p_workset_score' => $value->p4p_workset_score,
                    'p4p_workload_user' => $iduser 
                     
                ]);                
            }
            return response()->json([
                'status'     => '200' 
            ]);
           
            
            // $ws = DB::table('p4p_workset')->where('p4p_workset_id','=',$workset_id)->first();
            // if ($check > 0) {
            //     if ($year != '' && $month != '') {
            //         // $data_count = P4p_workload::where('p4p_workload_user','=',$iduser)->where('p4p_workset_id','=',$workset_id)->count(); 
            //         // if ($data_count > 0) {
                        
            //         // } else {
            //             $data_ = P4p_workload::where('p4p_workload_user','=',$iduser)->where('p4p_work_id','=',$p4p_work_id)->get(); 
            //             // $data_ = P4p_workload::where('p4p_workload_user','=',$iduser)->where('p4p_work_id','=',$id)->where('p4p_workset_id','=',$workset_id)->get(); 
            //             foreach ($data_ as $key => $value) {
            //                 $add = new P4p_workload(); 
            //                 $add->p4p_work_id =       $id;
            //                 $add->p4p_workload_date = $date;
            //                 $add->p4p_workset_id =    $value->p4p_workset_id;
            //                 $add->p4p_workset_code =  $value->p4p_workset_code;
            //                 $add->p4p_workset_name =  $value->p4p_workset_name;
            //                 $add->p4p_workset_unit =  $value->p4p_workset_unit;
            //                 $add->p4p_workset_time =  $value->p4p_workset_time;
            //                 $add->p4p_workset_score = $value->p4p_workset_score; 
            //                 $add->p4p_workload_user = $iduser;
            //                 $add->save();
            //                 return response()->json([
            //                     'status'     => '200' 
            //                 ]);
            //             }
            //         // }
                    
                   
                    
            //     } else {
            //         return response()->json([
            //             'status'     => '100' 
            //         ]);
            //     }
            // } else {
            //     return response()->json([
            //         'status'     => '150' 
            //     ]);
            // }




        } else {
            return response()->json([
                'status'     => '120' 
            ]);
        }
        
       
        
           
        
               
             
    }
    public function p4p_work_choose_worksetsave(Request $request)
    {  
        $work_id = $request->p4p_work_id;
        $iduser = $request->p4p_workgroupset_user;

        $data_ = P4p_workset::where('p4p_workset_user','=',$iduser)->get();
        // $data_ = P4p_workset::get();
       
        foreach ($data_ as $key => $value) {
            $check = P4p_work_score::where('p4p_work_id','=',$work_id)->where('p4p_workset_id','=',$value->p4p_workset_id)->count();
            // dd($check);
            if ($check > 0) {
                // $add = new P4p_work_score(); 
                // $add->p4p_work_id = $work_id;
                // $add->p4p_workset_id = $value->p4p_workset_id; 
                // $add->save();
                // return response()->json([
                //     'status'     => '200' 
                // ]);

                // $check2 = P4p_work_score::where('p4p_workset_id','=',$value->p4p_workset_id)->count();
                // if ($check2 > 0) {
                //     return response()->json([
                //         'status'     => '100' 
                //     ]);
                // } else {
                //     # code...
                // }       
                     return response()->json([
                        'status'     => '100' 
                    ]);                       
               
            } else {
                $add = new P4p_work_score(); 
                $add->p4p_work_id = $work_id;
                $add->p4p_workset_id = $value->p4p_workset_id; 
                $add->save();
                return response()->json([
                    'status'     => '200' 
                ]);
            }
            
            // return response()->json([
            //     'status'     => '200' 
            // ]);
        }
       

       
    }
    public function p4p_workgroupset_save(Request $request)
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
    public function p4p_workgroupset_edit (Request $request,$id)
    { 
        $iduser = Auth::user()->id;
        $data_show = P4p_workgroupset::where('p4p_workgroupset_id','=',$id)->first();
        $data['p4p_workgroupset'] = P4p_workgroupset::where('p4p_workgroupset_user','=',$iduser)->get();

        return view('p4p.p4p_workgroupset_edit', $data,[
            'data_show' => $data_show, 
        ]);
    }
    
   
    public function p4p_workgroupset_update(Request $request)
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
    function p4p_workgroupset_switchactive(Request $request)
    {  
        $id = $request->idfunc; 
        $active = P4p_workgroupset::find($id);
        $active->p4p_workgroupset_active = $request->onoff;
        $active->save();
    }
    public function p4p_work_position (Request $request)
    { 
        $iduser = Auth::user()->id;
        $date = date('Y-m-d');
        $m = date('m');
        $data['y'] = date('Y')+543;
        $data['users'] = User::get();
        $data['leave_month'] = DB::table('leave_month')->get(); 
        $data['budget_year'] = DB::table('budget_year')->get();
        $data['p4p_work_position'] = DB::table('p4p_work_position')
        // ->leftjoin('leave_month','leave_month.MONTH_ID','=','p4p_work.p4p_work_month') 
        // ->where('p4p_work_position_user','=',$iduser)
        ->get();
        return view('p4p.p4p_work_position', $data,[
            // 'data_show' => $data_show,
            // 'month'       => $month 
        ]);
    }
    public function p4p_work_position_save(Request $request)
    {  
        $add = new P4p_work_position(); 
        $add->p4p_work_position_code = $request->p4p_work_position_code;
        $add->p4p_work_position_name = $request->p4p_work_position_name;
        $add->p4p_work_position_user = $request->p4p_work_position_user;
        // $add->p4p_work_code = $request->p4p_work_code; 
        $add->save();

        return response()->json([
            'status'     => '200' 
        ]);
    }
   
    public function p4p_work_position_edit (Request $request,$id)
    { 
        $iduser = Auth::user()->id;
        $data_show = P4p_work_position::where('p4p_work_position_id','=',$id)->first();
        $data['p4p_work_position'] = P4p_work_position::where('p4p_work_position_user','=',$iduser)->get();

        return view('p4p.p4p_work_position_edit', $data,[
            'data_show' => $data_show, 
        ]);
    }
    public function p4p_work_position_update(Request $request)
    {  
        $id = $request->p4p_work_position_id;
        $update = P4p_work_position::find($id); 
        $update->p4p_work_position_code = $request->p4p_work_position_code;
        $update->p4p_work_position_name = $request->p4p_work_position_name;
        $update->p4p_work_position_user = $request->p4p_work_position_user; 
        $update->save();

        return response()->json([
            'status'     => '200' 
        ]);
    }
    function p4p_work_position_switchactive(Request $request)
    {  
        $id = $request->idfunc; 
        $active = P4p_work_position::find($id);
        $active->p4p_work_position_active = $request->onoff;
        $active->save();
    }
    public function p4p_work_position_sub (Request $request,$id)
    {  
        $data['leave_month'] = DB::table('leave_month')->get(); 
        $data['budget_year'] = DB::table('budget_year')->get();
        $data['p4p_workgroupset_unit'] = DB::table('p4p_workgroupset_unit')->get();
        $data['p4p_workgroupset'] = DB::table('p4p_workgroupset')->get();

        $data['p4p_work_position'] = DB::table('p4p_work_position')
        ->where('p4p_work_position_id','=',$id)->first();

        $data['p4p_workset'] = DB::table('p4p_workset')
        ->leftjoin('p4p_work_position','p4p_work_position.p4p_work_position_id','=','p4p_workset.p4p_workset_position')
        ->leftjoin('p4p_workgroupset_unit','p4p_workgroupset_unit.p4p_workgroupset_unit_id','=','p4p_workset.p4p_workset_unit')
        // ->where('p4p_workset_active','=',TRUE)
        ->where('p4p_workset_position','=',$id)
        ->get();

        return view('p4p.p4p_work_position_sub', $data,[
            // 'data_show' => $data_show,
            // 'month'       => $month 
        ]);
    }
    public function p4p_work_scorenowsave(Request $request)
    {  
       
        $p4p_workload_date = $request->p4p_workload_date;
        $p4p_workset_id = $request->p4p_workset_id;
        // $p4p_workset_score_now = $request->p4p_workset_score_now;

        $wset = P4p_workset::where('p4p_workset_id','=',$p4p_workset_id)->first();
        // if ($check > 0) { 
        //     return response()->json([
        //         'status'     => '100' 
        //     ]);
        // } else {
            $add = new P4p_workload(); 
            $add->p4p_workload_date = $p4p_workload_date;
            $add->p4p_workset_id = $p4p_workset_id; 
            $add->p4p_work_id = $request->p4p_work_id; 
            $add->p4p_workset_code = $wset->p4p_workset_code; 
            $add->p4p_workset_name = $wset->p4p_workset_name; 
            $add->p4p_workset_time = $wset->p4p_workset_time; 
            $add->p4p_workset_score = $wset->p4p_workset_score; 
            $add->p4p_workset_unit = $wset->p4p_workset_unit; 
            $add->p4p_workset_wp = $wset->p4p_workset_wp;

            $add->p4p_workset_score_now = $request->p4p_workset_score_now; 
            // $add->p4p_workload_totalscore = $request->p4p_workset_score_now; 
            $add->save();
            return response()->json([
                'status'     => '200' 
            ]);
        // }

        return response()->json([
            'status'     => '200' 
        ]);
    }

    // $add = new P4p_workset(); 
    // $add->p4p_workset_code = $request->p4p_workset_code;
    // $add->p4p_workset_name = $request->p4p_workset_name;
    // $add->p4p_workset_time = $request->p4p_workset_time;
    // $add->p4p_workset_score = $request->p4p_workset_score;
    // $add->p4p_workset_user = $request->p4p_workset_user;
    // $add->p4p_workset_unit = $request->p4p_workset_unit;
    // $add->p4p_workset_group = $request->p4p_workset_group;
    // $add->p4p_workset_wp = $request->p4p_workset_score * $request->p4p_workset_time;
    // $add->p4p_workset_position = $request->p4p_workset_position;
    // $add->save();
 
}


// $table->string('p4p_workset_code')->nullable();// 
// $table->string('p4p_workset_name')->nullable();//  
// $table->string('p4p_workset_unit')->nullable();// 
// $table->string('p4p_workset_time')->nullable();// ระยะเวลาที่ใช้จริง
// $table->string('p4p_workset_score')->nullable();// ค่าคะแนน/นาที
// $table->string('p4p_workset_wp')->nullable();//  รวมคคะแนน  /นาที

// $table->string('p4p_workset_score_now')->nullable();// คะแนนที่ได้

// $table->string('p4p_workload_sum')->nullable();// รวมชิ้นงาน
// $table->string('p4p_workload_totalscore')->nullable();// รวมคคะแนน