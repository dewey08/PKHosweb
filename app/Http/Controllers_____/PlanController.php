<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\support\Facades\Hash;
use Illuminate\support\Facades\Validator;
use App\Models\User;
use App\Models\Plan_type;
use App\Models\Plan_vision;
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

class PlanController extends Controller
{
    public function plan(Request $request)
    {
        $data['com_tec'] = DB::table('com_tec')->get();
        $data['users'] = User::get();

        return view('plan.plan', $data);
    }
    public function plan_project(Request $request)
    {
        $data['com_tec'] = DB::table('com_tec')->get();
        $data['users'] = User::get();

        return view('plan.plan_project', $data);
    }
    public function plan_project_add(Request $request)
    {
        $data['budget_year'] = DB::table('budget_year')->get();
        $data['users'] = User::get();

        return view('plan.plan_project_add', $data);
    }




    public function plan_development(Request $request)
    {
        $data['com_tec'] = DB::table('com_tec')->get();
        $data['users'] = User::get();

        return view('plan.plan_development', $data);
    }
    public function plan_procurement(Request $request)
    {
        $data['com_tec'] = DB::table('com_tec')->get();
        $data['users'] = User::get();

        return view('plan.plan_procurement', $data);
    }
    public function plan_maintenance(Request $request)
    {
        $data['com_tec'] = DB::table('com_tec')->get();
        $data['users'] = User::get();

        return view('plan.plan_maintenance', $data);
    }

    public function plan_type(Request $request)
    {
        $data['plan_type'] = Plan_type::get();
        $data['users'] = User::get();

        return view('plan.plan_type', $data);
    }
    public function plan_save(Request $request)
    {
        $add = new Plan_type();
        $add->plan_type_name = $request->input('plan_type_name');
        $add->save();

        return response()->json([
            'status'     => '200',
        ]);
    }
    public function plan_edit(Request $request, $id)
    {
        $type = Plan_type::find($id);

        return response()->json([
            'status'     => '200',
            'type'      =>  $type,
        ]);
    }
    public function plan_update(Request $request)
    {
        $id = $request->input('plan_type_id');

        $update = Plan_type::find($id);
        $update->plan_type_name = $request->input('plan_type_name');
        $update->save();

        return response()->json([
            'status'     => '200',
        ]);
    }
    public function plan_destroy(Request $request, $id)
    {
        $del = Plan_type::find($id);
        $del->delete();
        return response()->json(['status' => '200']);
    }

    // ********************************************

    public function plan_vision(Request $request)
    {
        $data['com_tec'] = DB::table('com_tec')->get();
        $data['plan_vision'] = Plan_vision::get();

        return view('plan.plan_vision', $data);
    }
    public function plan_vision_save(Request $request)
    {
        $add = new Plan_vision();
        $add->plan_vision_name = $request->input('plan_vision_name');
        $add->save();

        return response()->json([
            'status'     => '200',
        ]);
    }
    public function plan_vision_edit(Request $request, $id)
    {
        $plan = Plan_vision::find($id);

        return response()->json([
            'status'     => '200',
            'plan'      =>  $plan,
        ]);
    }
    public function plan_vision_update(Request $request)
    {
        $id = $request->input('plan_vision_id');

        $update = Plan_vision::find($id);
        $update->plan_vision_name = $request->input('plan_vision_name');
        $update->save();

        return response()->json([
            'status'     => '200',
        ]);
    }
    public function plan_vision_destroy(Request $request, $id)
    {
        $del = Plan_vision::find($id);
        $del->delete();
        return response()->json(['status' => '200']);
    }

    // ******************************************

    public function plan_mission(Request $request)
    {
        $data['com_tec'] = DB::table('com_tec')->get();
        $data['plan_mission'] = Plan_mission::leftjoin('plan_vision','plan_vision.plan_vision_id','=','plan_mission.plan_vision_id')->get();
        $data['plan_vision'] = Plan_vision::get();
        return view('plan.plan_mission', $data);
    }
    public function plan_mission_save(Request $request)
    {
        $add = new Plan_mission();
        $add->plan_mission_name = $request->input('plan_mission_name');
        $add->plan_vision_id = $request->input('plan_vision_id');
        $add->save();

        return response()->json([
            'status'     => '200',
        ]);
    }
    public function plan_mission_edit(Request $request, $id)
    {
        $mission = Plan_mission::find($id);

        return response()->json([
            'status'     => '200',
            'mission'      =>  $mission,
        ]);
    }
    public function plan_mission_update(Request $request)
    {
        $id = $request->input('editplan_mission_id');

        $update = Plan_mission::find($id);
        $update->plan_mission_name = $request->input('editplan_mission_name');
        $update->plan_vision_id = $request->input('editplan_vision_id');
        $update->save();

        return response()->json([
            'status'     => '200',
        ]);
    }
    public function plan_mission_destroy(Request $request, $id)
    {
        $del = Plan_mission::find($id);
        $del->delete();
        return response()->json(['status' => '200']);
    }

    // ***************************************

    public function plan_strategic(Request $request)
    {
        $data['plan_mission'] = Plan_mission::get();
        $data['plan_strategic'] = Plan_strategic::leftjoin('plan_mission','plan_mission.plan_mission_id','=','plan_strategic.plan_mission_id')->get();

        return view('plan.plan_strategic', $data);
    }
    public function plan_strategic_save(Request $request)
    {
        $add = new Plan_strategic();
        $add->plan_mission_id = $request->input('plan_mission_id');
        $add->plan_strategic_name = $request->input('plan_strategic_name');
        $add->plan_strategic_startyear = $request->input('plan_strategic_startyear');
        $add->plan_strategic_endyear = $request->input('plan_strategic_endyear');
        $add->save();

        return response()->json([
            'status'     => '200',
        ]);
    }
    public function plan_strategic_update(Request $request)
    { 
        $id = $request->input('editplan_strategic_id');

        $update = Plan_strategic::find($id);
        $update->plan_mission_id = $request->input('editplan_mission_id');
        $update->plan_strategic_name = $request->input('editplan_strategic_name');
        $update->plan_strategic_startyear = $request->input('editplan_strategic_startyear');
        $update->plan_strategic_endyear = $request->input('editplan_strategic_endyear');
        $update->save();

        return response()->json([
            'status'     => '200',
        ]);
    }

    // ********************************************

    public function plan_taget(Request $request,$id)
    {
        $data_plan_strategic = Plan_strategic::where('plan_strategic_id','=',$id)->first();
        $data['plan_strategic'] = Plan_strategic::leftjoin('plan_mission','plan_mission.plan_mission_id','=','plan_strategic.plan_mission_id')->get();
        // plan_taget
        $data['plan_taget'] = Plan_taget::where('plan_strategic_id','=',$id)->get();

        return view('plan.plan_taget', $data,[
            'data_plan_strategic'       =>       $data_plan_strategic
        ]);
    }
    public function plan_taget_save(Request $request)
    {
        $add = new Plan_taget();
        $add->plan_strategic_id = $request->input('plan_strategic_id');
        $add->plan_taget_code = $request->input('plan_taget_code');
        $add->plan_taget_name = $request->input('plan_taget_name'); 
        $add->save();

        return response()->json([
            'status'     => '200',
        ]);
    }
    public function plan_taget_update(Request $request)
    { 
        $id = $request->input('editplan_taget_id');

        $update = Plan_taget::find($id);
        $update->plan_strategic_id = $request->input('editplan_strategic_id');
        $update->plan_taget_code = $request->input('editplan_taget_code');
        $update->plan_taget_name = $request->input('editplan_taget_name'); 
        $update->save();

        return response()->json([
            'status'     => '200',
        ]);
    }

    // ********************************************
    public function plan_kpi(Request $request,$strategic_id,$taget_id)
    {
        $data_plan_strategic = Plan_strategic::where('plan_strategic_id','=',$strategic_id)->first();
        // $data['plan_strategic'] = Plan_strategic::leftjoin('plan_mission','plan_mission.plan_mission_id','=','plan_strategic.plan_mission_id')->get();
        // plan_taget
        $data_plan_taget = Plan_taget::where('plan_taget_id','=',$taget_id)->first();

        $data['plan_kpi'] = Plan_kpi::get();
        $data['budget_year'] = Budget_year::get();
        $data['dep_subsub'] = Department_sub_sub::get();
        $data['user'] = User::get();
        $yearnow = date('Y')+543;

        return view('plan.plan_kpi', $data,[
            'data_plan_strategic'       =>       $data_plan_strategic,
            'data_plan_taget'           =>       $data_plan_taget,
            'yearnow'                   =>       $yearnow
        ]);
    }
    public function plan_kpi_save(Request $request)
    {
        $add = new Plan_kpi();
        $add->plan_strategic_id = $request->input('plan_strategic_id');
        $add->plan_taget_id = $request->input('plan_taget_id');
        $add->plan_kpi_code = $request->input('plan_kpi_code');
        $add->plan_kpi_name = $request->input('plan_kpi_name'); 
        $add->plan_kpi_year = $request->input('leave_year_id'); 
        $add->save();
        
        return response()->json([
            'status'     => '200',
        ]);
    }
    public function plan_kpi_update(Request $request)
    { 
        $id = $request->input('editplan_kpi_id');

        $update = Plan_kpi::find($id);
        $update->plan_strategic_id = $request->input('editplan_strategic_id');
        $update->plan_taget_id = $request->input('editplan_taget_id');
        $update->plan_kpi_code = $request->input('editplan_kpi_code');
        $update->plan_kpi_name = $request->input('editplan_kpi_name'); 
        $update->plan_kpi_year = $request->input('editleave_year_id'); 
        $update->save();

        return response()->json([
            'status'     => '200',
        ]);
    }
    public function plan_kpi_destroy(Request $request, $id)
    {
        $del = Plan_kpi::find($id);
        $del->delete();
        return response()->json(['status' => '200']);
    }
     
}
