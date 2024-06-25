<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\support\Facades\Hash;
use Illuminate\support\Facades\Validator;
use App\Models\User;
use App\Models\Account_main;
use App\Models\Account_percen;
use App\Models\Account_listpercen;
use App\Models\Account_monthlydebt;
use App\Models\Account_creditor;
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
use App\Models\Plan_control_budget_pay;
use PDF;
use setasign\Fpdi\Fpdi;
use App\Models\Budget_year;
use Illuminate\Support\Facades\File;
use DataTables;
use Intervention\Image\ImageManagerStatic as Image;
use App\Mail\DissendeMail;
use Mail;
use Illuminate\Support\Facades\Storage;
use Auth;
date_default_timezone_set("Asia/Bangkok");


class AccountPlanController extends Controller
{
    public function account_plane(Request $request)
    {
        // $startdate                  = $request->startdate;
        // $enddate                    = $request->enddate;
        $budget_year_               = $request->budget_year;
        $departmentsub              = $request->departmentsub;
        $data['budget_yearget']     = DB::table('budget_year')->where('active','True')->get();
        $data['users']              = User::get();
        $data['department_sub']     = Departmentsub::get();
        $data['department_sub_sub'] = Department_sub_sub::get();
        $data['plan_control_type']  = Plan_control_type::get();
        $data['plan_strategic']     = Plan_strategic::get();
        $datenow = date("Y-m-d");
        $y = date('Y') + 543;

        if ($budget_year_ == '') {
            $budget_year = $y;
            $data_year       = DB::table('budget_year')->where('leave_year_id',$budget_year)->first();
            $startdate       = $data_year->date_begin;
            $enddate         = $data_year->date_end;
        } else {
            $data_year       = DB::table('budget_year')->where('leave_year_id',$budget_year_)->first();
            $startdate       = $data_year->date_begin;
            $enddate         = $data_year->date_end;
        }
        
        if ($departmentsub != '') {
            $plan_control = DB::connection('mysql')->select('
                SELECT 
                plan_control_id,billno,plan_obj,plan_name,plan_reqtotal,pt.plan_control_typename,p.plan_price,p.plan_starttime,p.plan_endtime,p.`status`,s.DEPARTMENT_SUB_SUB_NAME
                ,p.plan_price_total,p.plan_req_no
                FROM
                plan_control p
                LEFT OUTER JOIN department_sub_sub s ON s.DEPARTMENT_SUB_SUB_ID = p.department
                LEFT OUTER JOIN plan_control_type pt ON pt.plan_control_type_id = p.plan_type
                WHERE p.department = "'.$departmentsub.'" 
                AND p.plan_year = "'.$budget_year_.'" 
                ORDER BY p.plan_control_id ASC
            ');   
            // AND p.plan_starttime BETWEEN "'.$startdate.'" AND "'.$enddate.'" 
            foreach ($plan_control as $key => $value) {
                $datapay_ = DB::select('
                    SELECT SUM(sum_total) as total FROM plan_control_budget_pay 
                    WHERE plan_control_id = "'.$value->plan_control_id.'" 
                ');
                foreach ($datapay_ as $key => $value_pay) { 
                    Plan_control::where('plan_control_id',$value->plan_control_id)->update(
                    ['plan_price'    => $value_pay->total]  
                    );
                }
            }
        } else {
            $plan_control = DB::connection('mysql')->select('
                SELECT 
                plan_control_id,billno,plan_obj,plan_name,plan_reqtotal,pt.plan_control_typename,p.plan_price,p.plan_starttime,p.plan_endtime,p.`status`,s.DEPARTMENT_SUB_SUB_NAME
                ,p.plan_price_total,p.plan_req_no
                FROM
                plan_control p
                LEFT OUTER JOIN department_sub_sub s ON s.DEPARTMENT_SUB_SUB_ID = p.department
                LEFT OUTER JOIN plan_control_type pt ON pt.plan_control_type_id = p.plan_type
                WHERE p.department = "'.$departmentsub.'" 
                AND p.plan_year = "'.$budget_year_.'" 
                ORDER BY p.plan_control_id ASC
            ');
        }
        // AND p.plan_starttime BETWEEN "'.$startdate.'" AND "'.$enddate.'"
        
        
       
        
    
        // AND p.plan_starttime BETWEEN "'.$startdate.'" AND "'.$enddate.'"
        return view('account.account_plane',$data, [ 
            'startdate'        =>  $startdate,
            'enddate'          =>  $enddate,
            'departmentsub'    =>  $departmentsub,
            'budget_year'      =>  $budget_year_,
            'plan_control'     =>  $plan_control
        ]);
    }

    public function account_plane_activity(Request $request,$id)
    {
        $data['startdate']             = $request->startdate;
        $data['enddate']               = $request->enddate;     
        $data['plan_control']          = Plan_control::where('plan_control_id',$id)->first();
        $data['plan_control_activity'] = Plan_control_activity::where('plan_control_id',$id)->get();
        $data_activity                 = Plan_control_activity::where('plan_control_id',$id)->first();
        $data['plan_control_budget']   = Plan_control_budget::where('plan_control_id',$id)->get();
        $data['department_sub']        = Departmentsub::get();
        $data['department_sub_sub']    = Department_sub_sub::get();
        $data['plan_control_type']     = Plan_control_type::get();
        $data['plan_strategic']        = Plan_strategic::get();
        $data['plan_list_budget']      = Plan_list_budget::get();  
        $data['plan_unit']             = DB::table('plan_unit')->get();  
        $data['users']                 = User::get();    
        
        return view('account.account_plane_activity', $data,[ 
            'id'    =>  $id  // plan_control_id
        ]);
    }
    public function account_plane_payedit(Request $request,$id)
    { 
        $data_show = Plan_control_activity::where('plan_control_activity_id',$id)->first();
        $sum_total = Plan_control_budget::where('plan_control_activity_id',$id)->where('plan_control_id',$data_show->plan_control_id)->sum('plan_control_budget_price');
        // dd($sum_total);
        return response()->json([
            'status'               => '200', 
            'data_show'            =>  $data_show,
            'sum_total'            =>  $sum_total,
        ]);
    }

    public function account_plane_paysave(Request $request)
    {  
        $plan_control_id                     = $request->input('plan_control_id'); 
        $plan_control_activity_id            = $request->input('plan_control_activity_id'); 
        $add = new Plan_control_budget_pay();
        $add->plan_control_id                = $plan_control_id;  
        $add->plan_control_activity_id       = $plan_control_activity_id;
        $add->user_id                        = $request->input('user_id');
        $add->plan_list_budget_name          = $request->input('plan_list_budget_name');
        $add->sum_total                      = $request->input('sum_total'); 
        $add->detail                         = $request->input('detail'); 
        $add->save();
       
        Plan_control::where('plan_control_id',$plan_control_id)->update(['status' => 'VERIFY']);
        Plan_control_activity::where('plan_control_activity_id',$plan_control_activity_id)->update(['status' => 'VERIFY']);
        return response()->json([
            'status'               => '200',  
        ]);
    }

     public function account_plane_pay(Request $request)
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
    




}
