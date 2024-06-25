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
use App\Models\Departmentsub; 
use App\Models\Plan_control_type;
use App\Models\Plan_control;
use App\Models\Plan_control_money;
use App\Models\Plan_control_obj;
use App\Models\Plan_control_kpi;
use App\Models\Plan_control_activity;
use App\Models\Plan_control_budget;
use App\Models\Plan_list_budget;
use App\Models\Plan_control_objactivity;
use App\Models\Plan_control_activity_sub;
use PDF;
use Auth;
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

    public function plan_control(Request $request)
    {
        $data['startdate'] = $request->startdate;
        $data['enddate'] = $request->enddate;
        $data['com_tec'] = DB::table('com_tec')->get();
        $data['users'] = User::get();
        $data['department_sub_sub'] = Department_sub_sub::get();
        $data['plan_control_type'] = Plan_control_type::get();
        $data['plan_strategic'] = Plan_strategic::get();
        
        // $data['plan_control'] = Plan_control::get();
        $data['plan_control'] = DB::connection('mysql')->select('
            SELECT 
            plan_control_id,billno,plan_obj,plan_name,plan_reqtotal,pt.plan_control_typename,p.plan_price,p.plan_starttime,p.plan_endtime,p.`status`,s.DEPARTMENT_SUB_SUB_NAME
            ,p.plan_price_total,p.plan_req_no
            FROM
            plan_control p
            LEFT OUTER JOIN department_sub_sub s ON s.DEPARTMENT_SUB_SUB_ID = p.department
            LEFT OUTER JOIN plan_control_type pt ON pt.plan_control_type_id = p.plan_type
            ORDER BY p.plan_control_id ASC
        ');    
        return view('plan.plan_control', $data);
    }
    public function plan_control_sub(Request $request,$id)
    {
        $data['startdate'] = $request->startdate;
        $data['enddate'] = $request->enddate;
        $data['com_tec'] = DB::table('com_tec')->get();
        $data['users'] = User::get();
        $data['department_sub_sub'] = Department_sub_sub::get();
        $data['plan_control_type'] = Plan_control_type::get();
        // $data['plan_control'] = Plan_control::get();
        $data['plan_control'] = DB::connection('mysql')->select('
            SELECT 
            plan_control_id,billno,plan_obj,plan_name,plan_reqtotal,pt.plan_control_typename,p.plan_price,p.plan_starttime,p.plan_endtime,p.`status`,s.DEPARTMENT_SUB_SUB_NAME
            ,p.plan_price_total,p.plan_req_no
            FROM
            plan_control p
            LEFT OUTER JOIN department_sub_sub s ON s.DEPARTMENT_SUB_SUB_ID = p.department
            LEFT OUTER JOIN plan_control_type pt ON pt.plan_control_type_id = p.plan_type
           
            WHERE p.plan_strategic_id = "'.$id.'" AND p.hos_group IN("1","2")
            ORDER BY p.plan_control_id ASC
        ');  
        // WHERE p.plan_type = "'.$id.'"  
        return view('plan.plan_control_sub', $data,[
            'id'    =>  $id
        ]);
    }
    public function plan_control_sub_pp(Request $request)
    {
        $data['startdate'] = $request->startdate;
        $data['enddate'] = $request->enddate;
        $data['com_tec'] = DB::table('com_tec')->get();
        $data['users'] = User::get();
        $data['department_sub_sub'] = Department_sub_sub::get();
        $data['plan_control_type'] = Plan_control_type::get();
        // $data['plan_control'] = Plan_control::get();
        $data['plan_control'] = DB::connection('mysql')->select('
            SELECT 
            plan_control_id,billno,plan_obj,plan_name,plan_reqtotal,pt.plan_control_typename,p.plan_price,p.plan_starttime,p.plan_endtime,p.`status`,s.DEPARTMENT_SUB_SUB_NAME
            ,p.plan_price_total,p.plan_req_no
            FROM
            plan_control p
            LEFT OUTER JOIN department_sub_sub s ON s.DEPARTMENT_SUB_SUB_ID = p.department
            LEFT OUTER JOIN plan_control_type pt ON pt.plan_control_type_id = p.plan_type
            WHERE plan_type = "1"
            ORDER BY p.plan_control_id ASC
        ');    
        return view('plan.plan_control_sub_pp', $data);
    }
    public function plan_control_add(Request $request,$id)
    {
        $data['startdate'] = $request->startdate;
        $data['enddate'] = $request->enddate;
        $data['com_tec'] = DB::table('com_tec')->get();
        $data['users'] = User::get();
        $data['plan_control_type']  = Plan_control_type::get();
        $data['department_sub']     = Departmentsub::get();
        $data['department_sub_sub'] = Department_sub_sub::get();
        $data['plan_strategic'] = Plan_strategic::get();
        
        return view('plan.plan_control_add', $data,[
            'id'    =>  $id
        ]);
    }
    public function plan_control_edit(Request $request,$id)
    {
        $data['startdate'] = $request->startdate;
        $data['enddate'] = $request->enddate;
        $data['com_tec'] = DB::table('com_tec')->get();
        $data['users'] = User::get();
        $data['plan_control'] = Plan_control::where('plan_control_id',$id)->first();
        $data['department_sub']     = Departmentsub::get();
        $data['department_sub_sub'] = Department_sub_sub::get();
        $data['plan_control_type'] = Plan_control_type::get();
        $data['plan_strategic'] = Plan_strategic::get();
        // $data['plan_control'] = DB::connection('mysql')->select('
        //     SELECT 
        //     p.plan_control_id,p.billno,p.plan_obj,p.plan_name,p.plan_reqtotal,pt.plan_control_typename,p.plan_price,p.plan_starttime,p.plan_endtime,p.`status`,s.DEPARTMENT_SUB_SUB_NAME
        //     FROM
        //     plan_control p
        //     LEFT OUTER JOIN department_sub_sub s ON s.DEPARTMENT_SUB_SUB_ID = p.department
        //     LEFT OUTER JOIN plan_control_type pt ON pt.plan_control_type_id = p.plan_type
        //     WHERE p.plan_control_id = "'.$id.'"
        // ');  

        return view('plan.plan_control_edit', $data);
    }
    public static function refnumber()
    {
        $year = date('Y');
        $maxnumber = DB::table('plan_control')->max('plan_control_id');
        if ($maxnumber != '' ||  $maxnumber != null) {
            $refmax = DB::table('plan_control')->where('plan_control_id', '=', $maxnumber)->first();
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
        $refnumber = 'PL' . '-' . $ref;
        return $refnumber;
    }
    public function plan_control_save(Request $request)
    {
        $add = new Plan_control();
        $add->billno                = $request->input('billno');
        $add->plan_name             = $request->input('plan_name');
        $add->plan_starttime        = $request->input('datepicker1');
        $add->plan_endtime          = $request->input('datepicker2');
        $add->plan_price            = $request->input('plan_price');
        $add->department            = $request->input('department');
        $add->plan_type             = $request->input('plan_type');
        $add->user_id               = $request->input('user_id'); 
        $add->plan_strategic_id     = $request->input('plan_strategic_id');
        $add->hos_group             = $request->input('hos_group');
        $add->save();

        return response()->json([
            'status'     => '200',
        ]);
    }
    public function plan_control_update(Request $request)
    {
        $id = $request->plan_control_id;
        $update = Plan_control::find($id);
        $update->billno                = $request->input('billno');
        $update->plan_name             = $request->input('plan_name');
        $update->plan_starttime        = $request->input('datepicker1');
        $update->plan_endtime          = $request->input('datepicker2');
        $update->plan_price            = $request->input('plan_price');
        $update->department            = $request->input('department');
        $update->plan_type             = $request->input('plan_type');
        $update->user_id               = $request->input('user_id'); 
        $update->plan_strategic_id     = $request->input('plan_strategic_id');
        $update->hos_group             = $request->input('hos_group');
        $update->save();

        return response()->json([
            'status'     => '200',
        ]);
    }

    public function plan_control_destroy(Request $request, $id)
    {
        $del = Plan_control::find($id);
        $del->delete();
        return response()->json(['status' => '200']);
    }
    public function plan_control_ssj(Request $request, $id)
    {
        $update = Plan_control::find($id);
        $update->status    =   'INPROGRESS_SSJ';
        $update->save();
        return response()->json(['status' => '200']);
    }
    public function plan_control_po(Request $request, $id)
    {
        $update = Plan_control::find($id);
        $update->status    =   'INPROGRESS_PO';
        $update->save();
        return response()->json(['status' => '200']);
    }

    public function plan_control_activ_ssj(Request $request, $id)
    {
        $update = Plan_control_activity::find($id);
        $update->status    =   'INPROGRESS_SSJ';
        $update->save();
        return response()->json(['status' => '200']);
    }
    public function plan_control_activ_po(Request $request, $id)
    {
        $update = Plan_control_activity::find($id);
        $update->status    =   'INPROGRESS_PO';
        $update->save();
        return response()->json(['status' => '200']);
    }

    public function plan_control_obj_save(Request $request)
    {
        $iduser = Auth::user()->id;
        $add = new Plan_control_obj();
        $add->billno                         = $request->input('obj_billno');
        $add->plan_control_id                = $request->input('obj_plan_control_id');
        $add->plan_control_obj_name          = $request->input('plan_control_obj_name');  
        $add->user_id                        = $iduser;  
        $add->save();
        return response()->json([
            'status'     => '200',
        ]);
    }
    public function subobj_destroy(Request $request, $id)
    {
        $del = Plan_control_obj::find($id);
        $del->delete();
        return response()->json(['status' => '200']);
    }
    public function plan_control_kpi_save(Request $request)
    {
        $iduser = Auth::user()->id;
        $add = new Plan_control_kpi();
        $add->billno                         = $request->input('kpi_billno');
        $add->plan_control_id                = $request->input('kpi_plan_control_id');
        $add->plan_control_kpi_name          = $request->input('plan_control_kpi_name');  
        $add->user_id                        = $iduser;  
        $add->save();
        return response()->json([
            'status'     => '200',
        ]);
    }
    public function subkpi_destroy(Request $request, $id)
    {
        $del = Plan_control_kpi::find($id);
        $del->delete();
        return response()->json(['status' => '200']);
    }

    public function plan_control_activity(Request $request,$id,$sid)
    {
        $data['startdate']             = $request->startdate;
        $data['enddate']               = $request->enddate;
     
        $data['plan_control']          = Plan_control::where('plan_control_id',$sid)->first();
        $data['plan_control_activity'] = Plan_control_activity::where('plan_control_id',$sid)->get();
        $data_activity = Plan_control_activity::where('plan_control_id',$sid)->first();
        $data['plan_control_budget']   = Plan_control_budget::where('plan_control_id',$sid)->get();

        $data['department_sub']        = Departmentsub::get();
        $data['department_sub_sub']    = Department_sub_sub::get();
        $data['plan_control_type']     = Plan_control_type::get();
        $data['plan_strategic']        = Plan_strategic::get();
        $data['plan_list_budget']      = Plan_list_budget::get();     
        // $data['plan_list_budget']      = DB::table('plan_list_budget')->get();
        $data['plan_unit']             = DB::table('plan_unit')->get();  
        $data['users']                 = User::get();    
        // $data['plan_control_activity'] = Plan_control_activity::where('plan_control_id',$sid)->where('plan_control_activity_id',$aid)->get();

        return view('plan.plan_control_activity', $data,[
            'id'     =>  $id,  //  ยุทธศาสตร์ plan_strategic_id
            'sid'    =>  $sid  // plan_control_id
        ]);
    }
    public function plan_control_subhosactivity(Request $request,$id,$sid)
    {
        $data['startdate']             = $request->startdate;
        $data['enddate']               = $request->enddate;
     
        $data['plan_control']          = Plan_control::where('plan_control_id',$sid)->first();
        $data['plan_control_activity'] = Plan_control_activity::where('plan_control_id',$sid)->get();
        $data_activity = Plan_control_activity::where('plan_control_id',$sid)->first();
        $data['plan_control_budget']   = Plan_control_budget::where('plan_control_id',$sid)->get();

        $data['department_sub']        = Departmentsub::get();
        $data['department_sub_sub']    = Department_sub_sub::get();
        $data['plan_control_type']     = Plan_control_type::get();
        $data['plan_strategic']        = Plan_strategic::get();
        $data['plan_list_budget']      = Plan_list_budget::get();     
        // $data['plan_list_budget']      = DB::table('plan_list_budget')->get();
        $data['plan_unit']             = DB::table('plan_unit')->get();  
        $data['users']                 = User::get();    
        // $data['plan_control_activity'] = Plan_control_activity::where('plan_control_id',$sid)->where('plan_control_activity_id',$aid)->get();

        return view('plan.plan_control_subhosactivity', $data,[
            'id'     =>  $id,  //  ยุทธศาสตร์ plan_strategic_id
            'sid'    =>  $sid  // plan_control_id
        ]);
    }
    public function plan_control_activity_save(Request $request)
    {
        $iduser = Auth::user()->id;
        // $b = $request->input('budget_source'); 
        // $b_s = Plan_control_type::where('plan_control_type_id',$b)->first(); 

        // $d = $request->input('responsible_person'); 
        // $d_s = Department_sub_sub::where('DEPARTMENT_SUB_SUB_ID',$d)->first(); 

        $b = $request->input('budget_source'); 
        if ($b  != '') {
            $b_s = Plan_control_type::where('plan_control_type_id',$b)->first(); 
            $plan_control_type_id = $b_s->plan_control_type_id;
            $plan_control_typename = $b_s->plan_control_typename;
        } else {
            $plan_control_type_id = '';
            $plan_control_typename = '';
        }

        $d = $request->input('responsible_person'); 
        if ($d  != '') {
            $d_s = Departmentsub::where('DEPARTMENT_SUB_ID',$d)->first(); 
            $DEPARTMENT_SUB_ID = $d_s->DEPARTMENT_SUB_ID;
            $DEPARTMENT_SUB_NAME = $d_s->DEPARTMENT_SUB_NAME;
        } else {
            $DEPARTMENT_SUB_ID = '';
            $DEPARTMENT_SUB_NAME = '';
        }

        $add = new Plan_control_activity();
        $add->plan_control_activity_name    = $request->input('plan_control_activity_name');
        $add->plan_control_activity_group   = $request->input('plan_control_activity_group');
        $add->qty                           = $request->input('qty');  
        $add->plan_control_unit             = $request->input('plan_control_unit');  
        $add->budget_detail                 = $request->input('budget_detail');  
        $add->budget_price                  = $request->input('budget_price');  
        $add->budget_source                 = $plan_control_type_id;  
        $add->budget_source_name            = $plan_control_typename;
        $add->trimart_11                    = $request->input('trimart_11');  
        $add->trimart_12                    = $request->input('trimart_12');  
        $add->trimart_13                    = $request->input('trimart_13');  
        $add->trimart_21                    = $request->input('trimart_21');  
        $add->trimart_22                    = $request->input('trimart_22');  
        $add->trimart_23                    = $request->input('trimart_23');  
        $add->trimart_31                    = $request->input('trimart_31');  
        $add->trimart_32                    = $request->input('trimart_32');  
        $add->trimart_33                    = $request->input('trimart_33');  
        $add->trimart_41                    = $request->input('trimart_41');  
        $add->trimart_42                    = $request->input('trimart_42');  
        $add->trimart_43                    = $request->input('trimart_43');  
        $add->responsible_person            = $DEPARTMENT_SUB_ID;  
        $add->responsible_person_name       = $DEPARTMENT_SUB_NAME;
        $add->plan_control_id               = $request->input('plan_control_id'); 
        $add->billno                        = $request->input('billno'); 
        $add->user_id                       = $iduser;  
        $add->save();

        // $budget_detail  = $request->input('budget_detail'); 
        // $add2 = new Plan_control_budget();
        // $add->plan_control_id               = $request->input('plan_control_id'); 
        // $add->billno                        = $request->input('billno'); 
        // $add->plan_control_budget_name      = $request->input('plan_control_budget_name'); 
        // $add->plan_control_budget_price     = $request->input('plan_control_budget_price'); 
        // $add2->save();
 
        return response()->json([
            'status'     => '200',
        ]);
    }
    public function plan_control_budget_save(Request $request)
    {
        $iduser = Auth::user()->id;
    
        $b = $request->input('plan_list_budget_id'); 
        if ($b  != '') {
            $b_s = DB::table('plan_list_budget')->where('plan_list_budget_id',$b)->first(); 
            $plan_list_budget_id = $b_s->plan_list_budget_id;
            $plan_list_budget_name = $b_s->plan_list_budget_name;
        } else {
            $plan_list_budget_id = '';
            $plan_list_budget_name = '';
        }

        $activity_id = $request->input('plan_control_activity_id'); 
        $activity_priced = $request->input('plan_control_budget_price'); 
        if ($activity_priced == '') {
            $activity_price_new = '0';
        } else {
            $activity_price_new = $activity_priced;
        }
        // plan_control_budget_price
        $plan_control_id = $request->plan_control_id;
        
        $price_old = Plan_control_activity::where('plan_control_activity_id',$activity_id)->first();
        $idbudget = Plan_control_budget::where('plan_control_id',$plan_control_id)->where('plan_control_activity_id',$activity_id)->where('plan_list_budget_id',$plan_list_budget_id)->first();
        // plan_control_budget_id
        $check = Plan_control_budget::where('plan_control_id',$plan_control_id)->where('plan_control_activity_id',$activity_id)->where('plan_list_budget_name','=',$plan_list_budget_name)->count();
        // $check = Plan_control_budget::where('plan_list_budget_name','=',$plan_list_budget_name)->count();
        if ($check > 0) {
            Plan_control_budget::where('plan_control_id',$plan_control_id)->where('plan_control_activity_id',$activity_id)->where('plan_list_budget_id',$plan_list_budget_id)->update([ 
                // Plan_control_budget::where('plan_control_activity_id',$price_old->plan_control_activity_id)->where('plan_control_id',$request->plan_control_id)->update([ 
                'plan_control_budget_price'       => ($idbudget->plan_control_budget_price + $activity_price_new)
            ]);

            $update = Plan_control_activity::find($activity_id); 
            $update->budget_price        = $price_old->budget_price + $activity_price_new; 
            $update->save(); 
        } else {
            $add2 = new Plan_control_budget();
            $add2->plan_control_id               = $plan_control_id; 
            $add2->billno                        = $request->input('billno'); 
            $add2->plan_control_activity_id      = $activity_id; 
            $add2->plan_list_budget_id           = $plan_list_budget_id; 
            $add2->plan_list_budget_name         = $plan_list_budget_name; 
            $add2->plan_control_budget_price     = $activity_price_new; 
            $add2->save();

            $update = Plan_control_activity::find($activity_id); 
            $update->budget_price        = $price_old->budget_price + $activity_price_new; 
            $update->save(); 

        }
        
        
       

      
 
        return response()->json([
            'status'     => '200',
        ]);
    }
    public function plan_control_activity_edit(Request $request,$id,$sid,$aid)
    {
        $data['startdate'] = $request->startdate;
        $data['enddate'] = $request->enddate;
        $data['com_tec'] = DB::table('com_tec')->get();
        $data['users'] = User::get();
        $data['department_sub']     = Departmentsub::get();
        $data['department_sub_sub'] = Department_sub_sub::get();
        $data['plan_control_type'] = Plan_control_type::get();
        $data['plan_strategic'] = Plan_strategic::get();
        $data['plan_list_budget']      = Plan_list_budget::get();     
        // $data['plan_list_budget']      = DB::table('plan_list_budget')->get();
        $data['plan_unit']             = DB::table('plan_unit')->get(); 
        $data_plan_control = Plan_control::where('plan_control_id',$sid)->first();
        $data_activity = Plan_control_activity::where('plan_control_id',$sid)->where('plan_control_activity_id',$aid)->first();
        // $data_activity = Plan_control_activity::where('plan_control_id',$sid)->first();
        $data['plan_control_activity'] = Plan_control_activity::where('plan_control_id',$sid)->get();
        $data['plan_control_budget']   = Plan_control_budget::where('plan_control_budget.plan_control_id',$sid)->where('plan_control_budget.plan_control_activity_id',$aid)->get();
        // LEFTJOIN('plan_control_activity','plan_control_activity.plan_control_id','=','plan_control_budget.plan_control_id')
        // ->where('plan_control_budget.plan_control_id',$sid)->where('plan_control_budget.plan_control_activity_id',$aid)->get();
        
        return view('plan.plan_control_activity_edit', $data,[
            'data_plan_control'    => $data_plan_control,
            'data_activity'        => $data_activity,
            'id'                   => $id,
            'sid'                  => $sid,
            'aid'                  => $aid
        ]);
    }
    public function plan_control_activity_update(Request $request)
    {
        $iduser = Auth::user()->id;
        $b = $request->input('budget_source'); 
        if ($b  != '') {
            $b_s = Plan_control_type::where('plan_control_type_id',$b)->first(); 
            $plan_control_type_id = $b_s->plan_control_type_id;
            $plan_control_typename = $b_s->plan_control_typename;
        } else {
            $plan_control_type_id = '';
            $plan_control_typename = '';
        }

        $d = $request->input('responsible_person'); 
        if ($d  != '') {
            $d_s = Departmentsub::where('DEPARTMENT_SUB_ID',$d)->first(); 
            $DEPARTMENT_SUB_ID = $d_s->DEPARTMENT_SUB_ID;
            $DEPARTMENT_SUB_NAME = $d_s->DEPARTMENT_SUB_NAME;
        } else {
            $DEPARTMENT_SUB_ID = '';
            $DEPARTMENT_SUB_NAME = '';
        }
        
        $id = $request->input('plan_control_id');  
        // $update = Plan_control_activity::find($id);
        // $update->save();
        // dd($request->input('trimart_11'));
        $sid = $request->input('plan_control_activity_id'); 
        $update = Plan_control_activity::find($sid);
        $update->plan_control_activity_name    = $request->input('plan_control_activity_name');
        $update->plan_control_activity_group   = $request->input('plan_control_activity_group');
        $update->qty                           = $request->input('qty');  
        $update->plan_control_unit             = $request->input('plan_control_unit');  
        // $update->budget_detail                 = $request->input('budget_detail');  
        // $update->budget_price                  = $request->input('budget_price');  
        $update->budget_source                 = $plan_control_type_id;  
        $update->budget_source_name            = $plan_control_typename;
        $update->trimart_11                    = $request->input('trimart_11');  
        $update->trimart_12                    = $request->input('trimart_12');  
        $update->trimart_13                    = $request->input('trimart_13');  
        $update->trimart_21                    = $request->input('trimart_21');  
        $update->trimart_22                    = $request->input('trimart_22');  
        $update->trimart_23                    = $request->input('trimart_23');  
        $update->trimart_31                    = $request->input('trimart_31');  
        $update->trimart_32                    = $request->input('trimart_32');  
        $update->trimart_33                    = $request->input('trimart_33');  
        $update->trimart_41                    = $request->input('trimart_41');  
        $update->trimart_42                    = $request->input('trimart_42');  
        $update->trimart_43                    = $request->input('trimart_43');  
        $update->responsible_person            = $DEPARTMENT_SUB_ID;  
        $update->responsible_person_name       = $DEPARTMENT_SUB_NAME; 
        $update->user_id                       = $iduser;  
        $update->save();
      
        return response()->json([
            'status'     => '200',
        ]);
    }
    public function plan_control_subhosactivity_edit(Request $request,$id,$sid,$aid)
    {
        $data['startdate'] = $request->startdate;
        $data['enddate'] = $request->enddate;
        $data['com_tec'] = DB::table('com_tec')->get();
        $data['users'] = User::get();
        $data['department_sub']     = Departmentsub::get();
        $data['department_sub_sub'] = Department_sub_sub::get();
        $data['plan_control_type'] = Plan_control_type::get();
        $data['plan_strategic'] = Plan_strategic::get();
        $data['plan_list_budget']      = Plan_list_budget::get();     
        // $data['plan_list_budget']      = DB::table('plan_list_budget')->get();
        $data['plan_unit']             = DB::table('plan_unit')->get(); 
        $data_plan_control = Plan_control::where('plan_control_id',$sid)->first();
        $data_activity = Plan_control_activity::where('plan_control_id',$sid)->where('plan_control_activity_id',$aid)->first();
        // $data_activity = Plan_control_activity::where('plan_control_id',$sid)->first();
        $data['plan_control_activity'] = Plan_control_activity::where('plan_control_id',$sid)->get();
        $data['plan_control_budget']   = Plan_control_budget::where('plan_control_budget.plan_control_id',$sid)->where('plan_control_budget.plan_control_activity_id',$aid)->get();
        // LEFTJOIN('plan_control_activity','plan_control_activity.plan_control_id','=','plan_control_budget.plan_control_id')
        // ->where('plan_control_budget.plan_control_id',$sid)->where('plan_control_budget.plan_control_activity_id',$aid)->get();
        
        return view('plan.plan_control_subhosactivity_edit', $data,[
            'data_plan_control'    => $data_plan_control,
            'data_activity'        => $data_activity,
            'id'                   => $id,
            'sid'                  => $sid,
            'aid'                  => $aid
        ]);
    }

    public function plan_control_budget_edit(Request $request, $id)
    {
        $budget = Plan_control_activity::find($id);

        return response()->json([
            'status'     => '200',
            'budget'      =>  $budget,
        ]);
    }
    public function plan_control_activity_destroy(Request $request, $id)
    {
        $idbud       = Plan_control_budget::where('plan_control_budget_id','=',$id)->first();
        $idbud_ac    = $idbud->plan_control_activity_id;
        $price_new = $idbud->plan_control_budget_price;

        $idactice    = Plan_control_activity::where('plan_control_activity_id','=',$idbud_ac)->first();
        $price_old = $idactice->budget_price;

        $del = Plan_control_budget::find($id);
        $del->delete();

        if ($price_old >= $price_new) {
            Plan_control_activity::where('plan_control_activity_id',$idbud_ac)->update([ 
                'budget_price'       => ($price_old - $price_new)
            ]);
        } else {
            # code...
        }
        
        
        //  return redirect()->back();
        return response()->json(['status' => '200']);
    }

    public function plan_control_subhos(Request $request,$id)
    {
        $data['startdate'] = $request->startdate;
        $data['enddate'] = $request->enddate;
        $data['com_tec'] = DB::table('com_tec')->get();
        $data['users'] = User::get();
        $data['department_sub_sub'] = Department_sub_sub::get();
        $data['plan_control_type'] = Plan_control_type::get();
        // $data['plan_control'] = Plan_control::get();
        $data['plan_control'] = DB::connection('mysql')->select('
            SELECT 
            plan_control_id,billno,plan_obj,plan_name,plan_reqtotal,pt.plan_control_typename,p.plan_price,p.plan_starttime,p.plan_endtime,p.`status`,s.DEPARTMENT_SUB_SUB_NAME
            ,p.plan_price_total,p.plan_req_no
            FROM
            plan_control p
            LEFT OUTER JOIN department_sub_sub s ON s.DEPARTMENT_SUB_SUB_ID = p.department
            LEFT OUTER JOIN plan_control_type pt ON pt.plan_control_type_id = p.plan_type           
            WHERE p.plan_strategic_id = "'.$id.'" AND p.hos_group IN("3")
            ORDER BY p.plan_control_id ASC
        ');  
        // WHERE p.plan_type = "'.$id.'"  
        return view('plan.plan_control_subhos', $data,[
            'id'    =>  $id
        ]);
    }
    
    public function plan_control_subhos_add(Request $request,$id)
    {
        $data['startdate'] = $request->startdate;
        $data['enddate'] = $request->enddate;
        $data_budget_year = DB::table('budget_year')->where('active','True')->first();
        $data['users'] = User::get();
        $data['plan_control_type']  = Plan_control_type::get();
        $data['department_sub']     = Departmentsub::get();
        $data['department_sub_sub'] = Department_sub_sub::get();
        $data['plan_strategic'] = Plan_strategic::get();
        $budget_year = DB::table('budget_year')->where('active','True')->get();
        
        return view('plan.plan_control_subhos_add', $data,[
            'id'                    => $id,
            'data_budget_year'      => $data_budget_year,
            'budget_year'           => $budget_year
        ]);
    }

    public function plan_control_subhossave(Request $request)
    {
        $add = new Plan_control();
        $add->billno                = $request->input('billno');
        $add->plan_name             = $request->input('plan_name');
        $add->plan_starttime        = $request->input('datepicker1');
        $add->plan_endtime          = $request->input('datepicker2');
        $add->plan_price            = $request->input('plan_price');
        $add->department            = $request->input('department');
        $add->plan_type             = $request->input('plan_type');
        $add->user_id               = $request->input('user_id'); 
        $add->plan_strategic_id     = $request->input('plan_strategic_id');
        $add->hos_group             = $request->input('hos_group');
        $add->plan_year             = $request->input('plan_year');
        $add->save();

        return response()->json([
            'status'     => '200',
        ]);
    }
    public function plan_control_subhos_edit(Request $request,$id)
    {
        $data['startdate'] = $request->startdate;
        $data['enddate'] = $request->enddate;
        $data['com_tec'] = DB::table('com_tec')->get();
        $data['users'] = User::get();
        $data['plan_control'] = Plan_control::where('plan_control_id',$id)->first();
        $data['department_sub']     = Departmentsub::get();
        $data['department_sub_sub'] = Department_sub_sub::get();
        $data['plan_control_type'] = Plan_control_type::get();
        $data['plan_strategic'] = Plan_strategic::get();
        $budget_year = DB::table('budget_year')->where('active','True')->get();

        return view('plan.plan_control_subhos_edit', $data,[
            'budget_year'           => $budget_year
        ]);
    }
    public function plan_control_subhosupdate(Request $request)
    {
        $id = $request->plan_control_id;
        $update = Plan_control::find($id);
        $update->billno                = $request->input('billno');
        $update->plan_name             = $request->input('plan_name');
        $update->plan_starttime        = $request->input('datepicker1');
        $update->plan_endtime          = $request->input('datepicker2');
        $update->plan_price            = $request->input('plan_price');
        $update->department            = $request->input('department');
        $update->plan_type             = $request->input('plan_type');
        $update->user_id               = $request->input('user_id'); 
        $update->plan_strategic_id     = $request->input('plan_strategic_id');
        $update->hos_group             = $request->input('hos_group');
        $update->plan_year             = $request->input('plan_year');
        $update->save();

        return response()->json([
            'status'     => '200',
        ]);
    }
    public function plan_control_activ_edit(Request $request,$id)
    { 
        $data_show = Plan_control_activity::where('plan_control_activity_id',$id)->first();
        
        return response()->json([
            'status'               => '200', 
            'data_show'            =>  $data_show,
        ]);
    }
    public function plan_control_activobj_save(Request $request)
    {
        $iduser = Auth::user()->id;
       
        $add = new Plan_control_objactivity();
        $add->plan_control_objactivity_name    = $request->input('plan_control_objactivity_name'); 
        $add->plan_control_activity_id               = $request->input('plan_control_activity_id');  
        $add->user_id                       = $iduser;  
        $add->save();
 
        return response()->json([
            'status'     => '200',
        ]);
    }
    public function plan_control_subhosactivity_subsave(Request $request)
    {
        $iduser = Auth::user()->id; 

        $b = $request->input('sub_budget_source'); 
        if ($b  != '') {
            $b_s = Plan_control_type::where('plan_control_type_id',$b)->first(); 
            $plan_control_type_id = $b_s->plan_control_type_id;
            $plan_control_typename = $b_s->plan_control_typename;
        } else {
            $plan_control_type_id = '';
            $plan_control_typename = '';
        }

        $d = $request->input('sub_responsible_person'); 
        if ($d  != '') {
            $d_s = Departmentsub::where('DEPARTMENT_SUB_ID',$d)->first(); 
            $DEPARTMENT_SUB_ID = $d_s->DEPARTMENT_SUB_ID;
            $DEPARTMENT_SUB_NAME = $d_s->DEPARTMENT_SUB_NAME;
        } else {
            $DEPARTMENT_SUB_ID = '';
            $DEPARTMENT_SUB_NAME = '';
        }
        // sub_plan_control_id
        // sub_plan_control_activity_id

        $add = new Plan_control_activity_sub();
        $add->plan_control_activity_sub_name    = $request->input('plan_control_activity_sub_name');
        $add->plan_control_activity_group       = $request->input('sub_plan_control_activity_group');
        $add->qty                               = $request->input('sub_qty');  
        $add->plan_control_unit                 = $request->input('sub_plan_control_unit');   
        $add->budget_source                     = $plan_control_type_id;  
        $add->budget_source_name                = $plan_control_typename;
        $add->trimart_11                        = $request->input('subtrimart_11');  
        $add->trimart_12                        = $request->input('subtrimart_12');  
        $add->trimart_13                        = $request->input('subtrimart_13');  
        $add->trimart_21                        = $request->input('subtrimart_21');  
        $add->trimart_22                        = $request->input('subtrimart_22');  
        $add->trimart_23                        = $request->input('subtrimart_23');  
        $add->trimart_31                        = $request->input('subtrimart_31');  
        $add->trimart_32                        = $request->input('subtrimart_32');  
        $add->trimart_33                        = $request->input('subtrimart_33');  
        $add->trimart_41                        = $request->input('subtrimart_41');  
        $add->trimart_42                        = $request->input('subtrimart_42');  
        $add->trimart_43                        = $request->input('subtrimart_43');  
        $add->responsible_person                = $DEPARTMENT_SUB_ID;  
        $add->responsible_person_name           = $DEPARTMENT_SUB_NAME;
        $add->plan_control_id                   = $request->input('sub_plan_control_id'); 
        $add->plan_control_activity_id          = $request->input('sub_plan_control_activity_id'); 
        $add->user_id                           = $iduser;  
        $add->save();
 
        return response()->json([
            'status'     => '200',
        ]);
    }
    public function plan_control_subhosactivity_sub_edit(Request $request, $id)
    {
        $budget = Plan_control_activity_sub::find($id);

        return response()->json([
            'status'     => '200',
            'budget'      =>  $budget,
        ]);
    }
    public function plan_control_subhosactivity_subupdate(Request $request)
    {
        $iduser = Auth::user()->id;
    
        $b = $request->input('plan_list_budget_id'); 
        if ($b  != '') {
            $b_s = DB::table('plan_list_budget')->where('plan_list_budget_id',$b)->first(); 
            $plan_list_budget_id = $b_s->plan_list_budget_id;
            $plan_list_budget_name = $b_s->plan_list_budget_name;
        } else {
            $plan_list_budget_id = '';
            $plan_list_budget_name = '';
        }

        $activity_id = $request->input('plan_control_activity_id'); 
        $activity_priced = $request->input('plan_control_budget_price'); 
        if ($activity_priced == '') {
            $activity_price_new = '0';
        } else {
            $activity_price_new = $activity_priced;
        }
        // plan_control_budget_price
        $plan_control_id = $request->plan_control_id;
        
        $price_old = Plan_control_activity::where('plan_control_activity_id',$activity_id)->first();
        $idbudget = Plan_control_budget::where('plan_control_id',$plan_control_id)->where('plan_control_activity_id',$activity_id)->where('plan_list_budget_id',$plan_list_budget_id)->first();
        // plan_control_budget_id
        $check = Plan_control_budget::where('plan_control_id',$plan_control_id)->where('plan_control_activity_id',$activity_id)->where('plan_list_budget_name','=',$plan_list_budget_name)->count();
        // $check = Plan_control_budget::where('plan_list_budget_name','=',$plan_list_budget_name)->count();
        if ($check > 0) {
            Plan_control_budget::where('plan_control_id',$plan_control_id)->where('plan_control_activity_id',$activity_id)->where('plan_list_budget_id',$plan_list_budget_id)->update([ 
                // Plan_control_budget::where('plan_control_activity_id',$price_old->plan_control_activity_id)->where('plan_control_id',$request->plan_control_id)->update([ 
                'plan_control_budget_price'       => ($idbudget->plan_control_budget_price + $activity_price_new)
            ]);

            $update = Plan_control_activity::find($activity_id); 
            $update->budget_price        = $price_old->budget_price + $activity_price_new; 
            $update->save(); 
        } else {
            $add2 = new Plan_control_budget();
            $add2->plan_control_id                  = $plan_control_id; 
            $add2->plan_control_activity_id         = $activity_id; 
            $add2->plan_control_activity_sub_id     = $request->input('plan_control_activity_sub_id');  
            $add2->plan_list_budget_id              = $plan_list_budget_id; 
            $add2->plan_list_budget_name            = $plan_list_budget_name; 
            $add2->plan_control_budget_price        = $activity_price_new; 
            $add2->save();

            $update = Plan_control_activity::find($activity_id); 
            $update->budget_price        = $price_old->budget_price + $activity_price_new; 
            $update->save(); 

        }
         
 
        return response()->json([
            'status'     => '200',
        ]);
    }

    function detail_plan(Request $request)
    {
        $id = $request->get('id');

        // $detail = DB::table('plan_control_obj')
        //     ->where('WAREHOUSE_ID', '=', $id)
        //     ->first();

        $detail = Plan_control::where('plan_control_id', '=', $id)->first();
        $output =
        '
                        <div class="row push" style="font-family: \'Kanit\', sans-serif;">
                        <input type="hidden"  name="ID" value="' .
                                $id .
                                '"/>
                        <div class="col-sm-10">
                        <div class="row">

                        <div class="col-sm-2">
                            <div class="form-group">
                            <label >ลงวันที่ :</label>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group" >
                            <h1 style="text-align: left;font-family: \'Kanit\', sans-serif; font-size:10px;font-size: 1.0rem;font-weight:normal;color:#778899;">' .
                                $detail->plan_name .
                                '</h1>
                            </div>
                        </div>
 

                        </div>
  
            ';
            $output .=
            '
            <table class="table-bordered table-striped table-vcenter js-dataTable-simple" style="width: 100%;">
            <thead style="background-color: #FFEBCD;">
                <tr height="30">
                    <th class="text-font" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;" width="5%">ลำดับ</th>
                    <th class="text-font" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">วัตถุประสงค์ /ตัวชี้วัด</th> 
                </tr >
            </thead>
            <tbody> ';
            $detail_sub = Plan_control_obj::where('plan_control_id', '=', $id)->get();
                    $count = 1;
                    foreach ($detail_sub as $item) {
                        $output .=
                            '  
                            <tr height="20">
                                <td class="text-font" align="center" style="border: 1px solid black;" >'. $count .'</td>
                                <td class="text-font text-pedding" style="border: 1px solid black;" >'.$item->plan_control_obj_name .'</td> 
                            </tr>';    
                        $count++;
                    }
            $output .=
            ' </tbody>
            </table> 
            ';  
            echo $output;

            
    }

    public function plan_control_moneyedit(Request $request,$id)
    {
        //    dd($id);
        // $data_show = Plan_control::leftJoin('plan_control_money', 'plan_control.plan_control_id', '=', 'plan_control_money.plan_control_id')
        // ->where('plan_control.plan_control_id',$id)->first();
        $data_show = Plan_control::where('plan_control_id',$id)->first();
        // $data_show = Plan_control_money::where('plan_control_id',$ids)->get();

        // $data_show = DB::connection('mysql')->select('
        //     SELECT 
 
        //     FROM
        //     plan_control p
        //     JOIN Plan_control_money s ON s.plan_control_id = p.plan_control_id 
        //     WHERE p.plan_control_id = "'.$id.'"
        //     group by p.plan_control_id
        // ');  
        // dd($data_show);
        return response()->json([
            'status'               => '200', 
            'data_show'            =>  $data_show,
        ]);
    }

    // Plan_control_money
    public function plan_control_repmoney(Request $request)
    { 
        $maxno_ = Plan_control_money::where('plan_control_id',$request->input('update_plan_control_id'))->max('plan_control_money_no');
        $maxno = $maxno_+1;
        $add = new Plan_control_money();
        $add->plan_control_id                = $request->input('update_plan_control_id'); 
        $add->plan_control_money_no          = $maxno;
        $add->plan_control_moneydate         = $request->input('plan_control_moneydate');
        $add->plan_control_moneyprice        = $request->input('plan_control_moneyprice');
        $add->plan_control_moneyuser_id      = $request->input('plan_control_moneyuser_id');
        $add->plan_control_moneycomment      = $request->input('plan_control_moneycomment'); 
        $add->save();

        $planid = $request->input('update_plan_control_id');
        $check_price = Plan_control::where('plan_control_id',$planid)->first();
        // $maxno_ = Plan_control::where('plan_control_id',$request->input('update_plan_control_id'))->max('plan_control_money_no');

        $check = Plan_control::where('plan_control_id',$planid)->count();
        // dd($request->plan_price);
        if ($check > 0) {
            Plan_control::where('plan_control_id',$planid)->update([
                'plan_req_no'        =>  ($check_price->plan_req_no) + 1,
                'plan_reqtotal'      =>  ($check_price->plan_reqtotal) + ($request->input('plan_control_moneyprice')),
                'plan_price_total'   =>  ($check_price->plan_price) - (($check_price->plan_reqtotal) + ($request->input('plan_control_moneyprice')))
            ]);
        } else {
             
        }
        

        return response()->json([
            'status'     => '200',
        ]);
    }


    public function plan_development(Request $request)
    {
        $data['com_tec'] = DB::table('com_tec')->get();
        $data['users'] = User::get();

        return view('plan.plan_development', $data);
    }
    public function plan_procurement(Request $request)
    { 
        $data['users'] = User::get();
        $data['department_sub']        = Departmentsub::get();
        $data['department_sub_sub']    = Department_sub_sub::get();
        $data['plan_control_type']     = Plan_control_type::get();
        $data['plan_strategic']        = Plan_strategic::get();
        $data['plan_list_budget']      = Plan_list_budget::get();    
        $data['plan_unit']             = DB::table('plan_unit')->get();  
        $data['users']                 = User::get();  
        // $data['plan_control_activity'] = Plan_control_activity::where('plan_group','1')->get();
        $data['plan_control_activity'] = DB::connection('mysql')->select('
            SELECT 
            p.plan_control_id,p.billno,plan_obj,plan_name,plan_reqtotal,pt.plan_control_typename,p.plan_price,p.plan_starttime,p.plan_endtime,p.`status`,s.DEPARTMENT_SUB_SUB_NAME
            ,p.plan_price_total,p.plan_req_no,pp.*,pp.plan_control_activity_name
            FROM
            plan_control p
            LEFT OUTER JOIN plan_control_activity pp ON pp.plan_control_id = p.plan_control_id
            LEFT OUTER JOIN department_sub_sub s ON s.DEPARTMENT_SUB_SUB_ID = p.department
            LEFT OUTER JOIN plan_control_type pt ON pt.plan_control_type_id = p.plan_type
            WHERE p.plan_group ="1"
            GROUP BY p.plan_control_id
            ORDER BY p.plan_control_id ASC
        ');    

        return view('plan.plan_procurement', $data);
    }
    public function plan_procurement_save(Request $request)
    {
        $iduser = Auth::user()->id; 

        $b = $request->input('budget_source'); 
        if ($b  != '') {
            $b_s = Plan_control_type::where('plan_control_type_id',$b)->first(); 
            $plan_control_type_id = $b_s->plan_control_type_id;
            $plan_control_typename = $b_s->plan_control_typename;
        } else {
            $plan_control_type_id = '';
            $plan_control_typename = '';
        }

        $d = $request->input('responsible_person'); 
        if ($d  != '') {
            $d_s = Departmentsub::where('DEPARTMENT_SUB_ID',$d)->first(); 
            $DEPARTMENT_SUB_ID = $d_s->DEPARTMENT_SUB_ID;
            $DEPARTMENT_SUB_NAME = $d_s->DEPARTMENT_SUB_NAME;
        } else {
            $DEPARTMENT_SUB_ID = '';
            $DEPARTMENT_SUB_NAME = '';
        }
        // $p = $request->input('plan_control_id'); 
        // if ($p  != '') {
        //     $p_s = Plan_control::where('plan_control_id',$p)->first(); 
        //     $plan_control_id = $p_s->plan_control_id;
        //     $billno          = $p_s->billno;
        // } else {
        //     $plan_control_id = '';
        //     $billno          = '';
        // }
         // $maxid    = DB::table('plan_control')->max('plan_control_id');
         $year = date('Y');
         $maxnumber = DB::table('plan_control')->max('plan_control_id');
         if ($maxnumber != '' ||  $maxnumber != null) {
             $refmax = DB::table('plan_control')->where('plan_control_id', '=', $maxnumber)->first();
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
         $billno = 'PL' . '-' . $ref;
         $maxid    =  $maxnumber + 1;

       
        $add = new Plan_control();
        $add->billno                = $billno;
        $add->plan_name             = $request->input('plan_control_activity_name');
        // $add->plan_starttime        = $request->input('datepicker1');
        // $add->plan_endtime          = $request->input('datepicker2');
        // $add->plan_price            = $request->input('plan_price');
        $add->department            = $DEPARTMENT_SUB_ID;
        $add->plan_type             = $plan_control_type_id;
        $add->user_id               = $iduser; 
        $add->plan_strategic_id     = $request->input('plan_strategic_id');
        $add->hos_group             = '3';
        $add->plan_group            = '1';
        $add->save();

       

        $add = new Plan_control_activity();
        $add->plan_control_activity_name    = $request->input('plan_control_activity_name');
        $add->plan_control_activity_group   = $request->input('plan_control_activity_group');
        $add->qty                           = $request->input('qty');  
        $add->plan_control_unit             = $request->input('plan_control_unit');  
        $add->budget_detail                 = $request->input('budget_detail');  
        $add->budget_price                  = $request->input('budget_price');  
        $add->budget_source                 = $plan_control_type_id;  
        $add->budget_source_name            = $plan_control_typename;
        $add->trimart_11                    = $request->input('trimart_11');  
        $add->trimart_12                    = $request->input('trimart_12');  
        $add->trimart_13                    = $request->input('trimart_13');  
        $add->trimart_21                    = $request->input('trimart_21');  
        $add->trimart_22                    = $request->input('trimart_22');  
        $add->trimart_23                    = $request->input('trimart_23');  
        $add->trimart_31                    = $request->input('trimart_31');  
        $add->trimart_32                    = $request->input('trimart_32');  
        $add->trimart_33                    = $request->input('trimart_33');  
        $add->trimart_41                    = $request->input('trimart_41');  
        $add->trimart_42                    = $request->input('trimart_42');  
        $add->trimart_43                    = $request->input('trimart_43');  
        $add->responsible_person            = $DEPARTMENT_SUB_ID;  
        $add->responsible_person_name       = $DEPARTMENT_SUB_NAME;
        $add->plan_control_id               = $maxid; 
        $add->billno                        = $billno; 
        $add->user_id                       = $iduser;  
        $add->save();
 
        return response()->json([
            'status'     => '200',
        ]);
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
