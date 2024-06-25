<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\support\Facades\Hash;
use Illuminate\support\Facades\Validator;
use App\Models\User;

use App\Models\Plan_mission;
use App\Models\Plan_strategic;
use App\Models\Plan_taget;
use App\Models\Plan_kpi;
use App\Models\Department_sub_sub;
use PDF;
use setasign\Fpdi\Fpdi;
use App\Models\Budget_year;
use Illuminate\Support\Facades\File;
use DataTables;
use Intervention\Image\ImageManagerStatic as Image;
use Auth;
use App\Models\Audiovisual;
use App\Models\Audiovisual_type;

class SoteController extends Controller
{
    public function audiovisual_work(Request $request)
    {
        $iduser = Auth::user()->id;
        $data['startdate'] = $request->startdate;
        $data['enddate'] = $request->enddate;
        $data['users'] = User::get();
        $data['department_sub_sub'] = DB::table('department_sub_sub')->get();
        $data['audiovisual_type'] = DB::table('audiovisual_type')->get();
        // $data['audiovisual'] = DB::connection('mysql')->select('
        //     SELECT a.*,i.fname,i.lname,d.DEPARTMENT_SUB_SUB_NAME,b.audiovisual_typename
        //     from audiovisual a
        //     LEFT JOIN users i on i.id = a.ptname
        //     LEFT JOIN audiovisual_type b on b.audiovisual_type_id = a.audiovisual_type
        //     left JOIN department_sub_sub d on d.DEPARTMENT_SUB_SUB_ID = a.department 
        //     WHERE a.ptname = "'.$iduser.'"
        // ');
        if ($data['startdate'] =='') { 
            $data['audiovisual'] = DB::connection('mysql')->select('
                SELECT a.*,i.fname,i.lname,d.DEPARTMENT_SUB_SUB_NAME,b.audiovisual_typename
                from audiovisual a
                LEFT JOIN users i on i.id = a.ptname
                LEFT JOIN audiovisual_type b on b.audiovisual_type_id = a.audiovisual_type
                left JOIN department_sub_sub d on d.DEPARTMENT_SUB_SUB_ID = a.department 
                WHERE a.ptname = "'.$iduser.'"
                ORDER BY a.audiovisual_id DESC
                LIMIT 50 
            ');
        } else { 
            $data['audiovisual'] = DB::connection('mysql')->select('
                SELECT a.*,i.fname,i.lname,d.DEPARTMENT_SUB_SUB_NAME,b.audiovisual_typename
                from audiovisual a
                LEFT JOIN users i on i.id = a.ptname
                LEFT JOIN audiovisual_type b on b.audiovisual_type_id = a.audiovisual_type
                left JOIN department_sub_sub d on d.DEPARTMENT_SUB_SUB_ID = a.department 
                WHERE a.work_order_date BETWEEN "'.$data['startdate'].'" AND "'.$data['enddate'].'" AND a.ptname = "'.$iduser.'"
            ');
        }

        return view('sote.audiovisual_work', $data);
    }
    public static function refnumber()
    {
        $year = date('Y');
        $maxnumber = DB::table('audiovisual')->max('audiovisual_id');
        if ($maxnumber != '' ||  $maxnumber != null) {
            $refmax = DB::table('audiovisual')->where('audiovisual_id', '=', $maxnumber)->first();
            if ($refmax->billno != '' ||  $refmax->billno != null) {
                $maxref = substr($refmax->billno, -4) + 1;
            } else {
                $maxref = 1;
            }
            $ref = str_pad($maxref, 5, "0", STR_PAD_LEFT);
        } else {
            $ref = '00001';
        }
        $ye = date('Y') + 543;
        $y = substr($ye, -2);
        $refnumber = 'SOTE' . '-' . $ref;
        return $refnumber;
    }

    public function audiovisual_work_add(Request $request)
    {
        $data['startdate'] = $request->startdate;
        $data['enddate'] = $request->enddate;
        $data['users'] = User::get();
        $data['department_sub_sub'] = DB::table('department_sub_sub')->get();
        $data['audiovisual_type'] = DB::table('audiovisual_type')->get();

        return view('sote.audiovisual_work_add', $data);
    }
    public function audiovisual_work_save(Request $request)
    {
        $add = new Audiovisual();
        $add->ptname                    = $request->input('ptname');
        $add->tel                       = $request->input('tel');
        $add->work_order_date           = $request->input('work_order_date');
        $add->job_request_date          = $request->input('job_request_date');
        $add->department                = $request->input('department');
        $add->audiovisual_type          = $request->input('audiovisual_type');
        $add->audiovisual_name          = $request->input('audiovisual_name');
        $add->audiovisual_qty           = $request->input('audiovisual_qty');
        $add->audiovisual_detail        = $request->input('audiovisual_detail');
        $add->billno                    = $request->input('billno');
        $add->lineid                    = $request->input('lineid');
        $add->save();

        return response()->json([
            'status'     => '200',
        ]);
    }

    public function audiovisual_work_edit(Request $request, $id)
    {
        $data['startdate'] = $request->startdate;
        $data['enddate'] = $request->enddate;
        $data['users'] = User::get();
        $data['department_sub_sub'] = DB::table('department_sub_sub')->get();
        $data['audiovisual_type'] = DB::table('audiovisual_type')->get();
        $data['audiovisual'] = DB::connection('mysql')->select('
            SELECT * 
            from audiovisual a
            LEFT JOIN users i on i.id = a.ptname
            LEFT JOIN audiovisual_type b on b.audiovisual_type_id = a.audiovisual_type
            left JOIN department_sub_sub d on d.DEPARTMENT_SUB_SUB_ID = a.department 
        ');
        $data['dataedit']  = Audiovisual::where('audiovisual_id', '=', $id)->first();
        // $data['work'] = Plan_strategic::leftjoin('plan_mission','plan_mission.plan_mission_id','=','plan_strategic.plan_mission_id')->get();
        // plan_taget
        // $data['plan_taget'] = Plan_taget::where('plan_strategic_id','=',$id)->get();
        // $work = Audiovisual::find($id);
        return view('sote.audiovisual_work_edit', $data);
        // return response()->json([
        //     'status'     => '200',
        //     'work'       =>  $work,
        // ]);
    }
    public function audiovisual_work_update(Request $request)
    {
        $id = $request->audiovisual_id;
        $update = Audiovisual::find($id);
        $update->ptname                    = $request->input('ptname');
        $update->tel                       = $request->input('tel');
        $update->work_order_date           = $request->input('work_order_date');
        $update->job_request_date          = $request->input('job_request_date');
        $update->department                = $request->input('department');
        $update->audiovisual_type          = $request->input('audiovisual_type');
        $update->audiovisual_name          = $request->input('audiovisual_name');
        $update->audiovisual_qty           = $request->input('audiovisual_qty');
        $update->audiovisual_detail        = $request->input('audiovisual_detail');
        $update->lineid                    = $request->input('lineid');
        // $update->billno                    = $request->input('billno'); 
        $update->save();

        return response()->json([
            'status'     => '200',
        ]);
    }
    public function audiovisual_work_cancel(Request $request, $id)
    {

        $update = Audiovisual::find($id);

        $update->audiovisual_status        = 'CANCEL';
        $update->save();

        return response()->json([
            'status'     => '200',
        ]);
    }

    public function audiovisual_work_detail(Request $request, $id)
    {
        $data['startdate'] = $request->startdate;
        $data['enddate'] = $request->enddate;
        $data['users'] = User::get();
        $data['department_sub_sub'] = DB::table('department_sub_sub')->get();
        $data['audiovisual_type'] = DB::table('audiovisual_type')->get();
        $data['audiovisual'] = DB::connection('mysql')->select('
            SELECT * 
            from audiovisual a
            LEFT JOIN users i on i.id = a.ptname
            LEFT JOIN audiovisual_type b on b.audiovisual_type_id = a.audiovisual_type
            left JOIN department_sub_sub d on d.DEPARTMENT_SUB_SUB_ID = a.department 
        ');
        // $data['dataedit']  = Audiovisual::where('audiovisual_id','=',$id)->first();

        $work = Audiovisual::find($id);

        return response()->json([
            'status'     => '200',
            'work'       =>  $work,
        ]);
    }
 

    // ************************ ผู้ดูแล ระบบงานโสต ********************

    public function audiovisual_admin(Request $request)
    {
        $data['startdate'] = $request->startdate;
        $data['enddate'] = $request->enddate;
        $data['users'] = User::get();
        $data['department_sub_sub'] = DB::table('department_sub_sub')->get();
        $data['audiovisual_type'] = DB::table('audiovisual_type')->get();

        if ($data['startdate'] =='') {
            // $data['audiovisual'] = DB::connection('mysql')->select('
            //     SELECT * 
            //     from audiovisual a
            //     LEFT JOIN users i on i.id = a.ptname
            //     LEFT JOIN audiovisual_type b on b.audiovisual_type_id = a.audiovisual_type
            //     left JOIN department_sub_sub d on d.DEPARTMENT_SUB_SUB_ID = a.department 
            //     LIMIT 30
            // ');
            $data['audiovisual'] = DB::connection('mysql')->select('
                SELECT a.*,i.fname,i.lname,d.DEPARTMENT_SUB_SUB_NAME,b.audiovisual_typename
                from audiovisual a
                LEFT JOIN users i on i.id = a.ptname
                LEFT JOIN audiovisual_type b on b.audiovisual_type_id = a.audiovisual_type
                left JOIN department_sub_sub d on d.DEPARTMENT_SUB_SUB_ID = a.department 
                
                ORDER BY a.audiovisual_id DESC
                LIMIT 50 
            ');
        } else {
            // $data['audiovisual'] = DB::connection('mysql')->select('
            //     SELECT * 
            //     from audiovisual a
            //     LEFT JOIN users i on i.id = a.ptname
            //     LEFT JOIN audiovisual_type b on b.audiovisual_type_id = a.audiovisual_type
            //     left JOIN department_sub_sub d on d.DEPARTMENT_SUB_SUB_ID = a.department 
            //     WHERE a.work_order_date BETWEEN "'.$data['startdate'].'" AND "'.$data['enddate'].'"
            // '); 
            $data['audiovisual'] = DB::connection('mysql')->select('
                SELECT a.*,i.fname,i.lname,d.DEPARTMENT_SUB_SUB_NAME,b.audiovisual_typename
                from audiovisual a
                LEFT JOIN users i on i.id = a.ptname
                LEFT JOIN audiovisual_type b on b.audiovisual_type_id = a.audiovisual_type
                left JOIN department_sub_sub d on d.DEPARTMENT_SUB_SUB_ID = a.department 
                WHERE a.work_order_date BETWEEN "'.$data['startdate'].'" AND "'.$data['enddate'].'"
            ');
        }
        
       

        return view('sote_admin.audiovisual_admin', $data);
    }
    public function audiovisual_admin_check(Request $request, $id)
    {
        $data['startdate'] = $request->startdate;
        $data['enddate'] = $request->enddate;
        $data['users'] = User::get();
        $data['department_sub_sub'] = DB::table('department_sub_sub')->get();
        $data['audiovisual_type'] = DB::table('audiovisual_type')->get();
        $data['audiovisual'] = DB::connection('mysql')->select('
            SELECT * 
            from audiovisual a
            LEFT JOIN users i on i.id = a.ptname
            LEFT JOIN audiovisual_type b on b.audiovisual_type_id = a.audiovisual_type
            left JOIN department_sub_sub d on d.DEPARTMENT_SUB_SUB_ID = a.department 
        ');
        $data['dataedit']  = Audiovisual::where('audiovisual_id', '=', $id)->first();
        
        return view('sote_admin.audiovisual_admin_check', $data); 
    }

    public function audiovisual_admin_save(Request $request)
    {
        $id = $request->audiovisual_id;
        // dd($id);
        $update = Audiovisual::find($id);

        $update->audiovisual_status        = 'ACCEPTING';
        $update->save();
        return redirect()->route('user.audiovisual_admin');
        // return response()->json([
        //     'status'     => '200',
        // ]);
        // return redirect()->back();
    }
    public function audiovisual_admin_cancel(Request $request, $id)
    {

        $update = Audiovisual::find($id);

        $update->audiovisual_status        = 'CONFIRM_CANCEL';
        $update->save();

        return response()->json([
            'status'     => '200',
        ]);
    }
    public function audiovisual_admin_going(Request $request, $id)
    {

        $update = Audiovisual::find($id);

        $update->audiovisual_status        = 'INPROGRESS';
        $update->save();

        return response()->json([
            'status'     => '200',
        ]);
    }
    public function audiovisual_admin_sendcheck(Request $request, $id)
    {

        $update = Audiovisual::find($id);

        $update->audiovisual_status        = 'VERIFY';
        $update->save();

        // return redirect()->route('user.audiovisual_admin');
        return response()->json([
            'status'     => '200',
        ]);
    }
    public function audiovisual_admin_finish(Request $request, $id)
    {

        $update = Audiovisual::find($id);

        $update->audiovisual_status        = 'FINISH';
        $update->save();

        return response()->json([
            'status'     => '200',
        ]);
    }
    

}
