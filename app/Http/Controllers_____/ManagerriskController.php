<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Person;
use App\Models\Incidence;
use Illuminate\Support\Facades\Session;
use App\Models\Risk_internalcontrol;
use App\Models\Risk_internalcontrol_sub;
use App\Models\Risk_internalcontrol_subsub;
use App\Models\Riskrep;
use App\Models\Risk_setupincidence_level;
use App\Models\Risk_internalcontrol_subsub_detail;
use App\Models\Risk_notify_repeat_sub;
use App\Models\Risk_notify_accept_sub;
use App\Models\Risk_notify_repeat_sub_infer;
use App\Models\Risk_notify_repeat_sub_inferlist;
use App\Models\Risk_notify_repeat_sub_board;
use App\Models\Risk_notify_repeat_sub_board_out;
use App\Models\Risk_notify_repeat_sub_topic_infer;
use App\Models\Risk_internalcontrol_subsub_detail_sub;
use App\Models\Risk_internalcontrol_subsub_detail_make;
use App\Models\Risk_internalcontrol_subsub_detail_risk;
use App\Models\Risk_internalcontrol_pk5_depart;
use App\Models\Risk_internalcontrol_pk5_depart_sub;
use App\Models\Risk_internalcontrol_pk5_depart_subsub;
use App\Models\Risk_internalcontrol_pk5_depart_subsub_detail;
use App\Models\Risk_internalcontrol_pk5;
use App\Models\Risk_internalcontrol_pk5_sub;
use App\Models\Risk_internalcontrol_organi;
use App\Models\Risk_internalcontrol_organi_sub;
use App\Models\Risk_rep_time;
use App\Models\Risk_rep_location;
use App\Models\Risk_rep_group;
use App\Models\Risk_rep_groupsub;
use App\Models\Risk_rep_groupsubsub;
use App\Models\Risk_rep_detail;
use App\Models\Risk_rep_items;
use App\Models\Risk_rep_program;
use App\Models\Risk_rep_program_sub;
use App\Models\Risk_rep_program_subsub;
use App\Models\Risk_rep_typereason;
use App\Models\Risk_rep_typereason_sys;
use App\Models\Risk_rep_level;
use App\Models\Team;
use App\Models\Risk_rep_items_sub;
use App\Models\Risk_rep_usereffect;
use App\Models\Risk_rep_teamlist;
use App\Models\Risk_rep_department;
use App\Models\Risk_rep_department_sub;
use App\Models\Risk_rep_department_subsub;
use App\Models\Risk_rep_infoperson;
use App\Models\Risk_account;
use App\Models\Risk_account_type;
use App\Models\Riskfunction;
use App\Models\Riskrecheck;

use App\Models\Risk_account_detail;
use App\Models\Risk_account_detail_level;
use App\Models\Setupincidence_origin;
use App\Models\Risk_img_matrix; 
use App\Models\Risk_setupincidence_usereffect;
use App\Http\Controllers\Report\RiskReportController;
use PDF;
use Alert;
use Cookie;



date_default_timezone_set("Asia/Bangkok");

class ManagerriskController extends Controller
{
   
    public function dashboard()
    {
        $budgetyear_dropdown   = getBudgetYearAmount();
        $budgetyear           = (!empty($_GET['budgetyear']))?$_GET['budgetyear']:getBudgetYear();
        $year                           = $budgetyear- 543; // ปี ค.ศ.

        // สถานะการดำเนินการความเสี่ยง และอุบัติการ
        // 1	REPEAT	ทบทวน
        // 2	ACCEPT	ตอบกลับ
        // 3	CONFIRM	รอยืนยัน
        // 4	SUCCESS	สรุปรายงาน
        // 5	REPORT	รายงาน
        // 6	CANCEL	ยกเลิก
        // 7	CANCELED	แจ้งยกเลิก
        // 8	CHECK	ตรวจสอบ
        // 9	CHECKOK	ยืนยันความเสี่ยง
        $list_status = ['REPORT','REPEAT','ACCEPT','CONFIRM','CHECKOK'];

        $riskreport = new RiskReportController();


        $time_incidence_M      = $riskreport->countRiskRep_M($year,$list_status); //อุบัติการณ์

            $from = ($budgetyear-544).'-10-01';
            $to = ($budgetyear-543).'-09-30';
        

     

        $inforisk = DB::table('risk_rep')->WhereBetween('RISKREP_DATESAVE',[$from,$to])->count();
        $inforisk_info = DB::table('risk_rep')->WhereBetween('RISKREP_DATESAVE',[$from,$to])->get();

       
        $infotodate =  DB::table('risk_rep')->where('RISKREP_DATESAVE',date('Y-m-d'))->count();

                
                 $infostatus1 = 0;
                 $infostatus2 = 0;
                 $infostatus3 = 0;

                 $lev_A = 0;
                 $lev_B = 0;
                 $lev_C = 0;
                 $lev_D = 0;
                 $lev_E = 0;
                 $lev_F = 0;
                 $lev_G = 0;
                 $lev_H = 0;
                 $lev_I = 0;
                 $lev_1 = 0;
                 $lev_2 = 0;
                 $lev_3 = 0;
                 $lev_4 = 0;
                 $lev_5 = 0;

                 $month10 = 0;
                 $month11 = 0;
                 $month12 = 0;
                 $month01 = 0;
                 $month02 = 0;
                 $month03 = 0;
                 $month04 = 0;
                 $month05 = 0;
                 $month06 = 0;
                 $month07 = 0;
                 $month08 = 0;
                 $month09 = 0;
             
                foreach($inforisk_info as $risk) {

                     if($risk->RISKREP_STATUS == 'REPORT'){ $infostatus1++;}
                     if($risk->RISKREP_STATUS == 'CHECK'){ $infostatus2++; }
                     if($risk->RISKREP_STATUS == 'CONFIRM'){ $infostatus3++; }

                     if($risk->RISKREP_LEVEL == '1'){ $lev_A++; }
                     if($risk->RISKREP_LEVEL == '2'){ $lev_B++; }
                     if($risk->RISKREP_LEVEL == '3'){ $lev_C++; }
                     if($risk->RISKREP_LEVEL == '4'){ $lev_D++; }
                     if($risk->RISKREP_LEVEL == '5'){ $lev_E++; }
                     if($risk->RISKREP_LEVEL == '6'){ $lev_F++; }
                     if($risk->RISKREP_LEVEL == '7'){ $lev_G++; }
                     if($risk->RISKREP_LEVEL == '8'){ $lev_H++; }
                     if($risk->RISKREP_LEVEL == '9'){ $lev_I++; }
                     if($risk->RISKREP_LEVEL == '10'){ $lev_1++; }
                     if($risk->RISKREP_LEVEL == '11'){ $lev_2++; }
                     if($risk->RISKREP_LEVEL == '12'){ $lev_3++; }
                     if($risk->RISKREP_LEVEL == '13'){ $lev_4++; }
                     if($risk->RISKREP_LEVEL == '14'){ $lev_5++; }

                     $yearold= $year-1;
                     if(date('Y-m',strtotime($risk->RISKREP_DATESAVE)) == $yearold.'-10'){ $month10++; }
                     if(date('Y-m',strtotime($risk->RISKREP_DATESAVE)) == $yearold.'-11'){ $month11++; }
                     if(date('Y-m',strtotime($risk->RISKREP_DATESAVE)) == $yearold.'-12'){ $month12++; }
                     if(date('Y-m',strtotime($risk->RISKREP_DATESAVE)) == $year.'-01'){ $month01++; }
                     if(date('Y-m',strtotime($risk->RISKREP_DATESAVE)) == $year.'-02'){ $month02++; }
                     if(date('Y-m',strtotime($risk->RISKREP_DATESAVE)) == $year.'-03'){ $month03++; }
                     if(date('Y-m',strtotime($risk->RISKREP_DATESAVE)) == $year.'-04'){ $month04++; }
                     if(date('Y-m',strtotime($risk->RISKREP_DATESAVE)) == $year.'-05'){ $month05++; }
                     if(date('Y-m',strtotime($risk->RISKREP_DATESAVE)) == $year.'-06'){ $month06++; }
                     if(date('Y-m',strtotime($risk->RISKREP_DATESAVE)) == $year.'-07'){ $month07++; }
                     if(date('Y-m',strtotime($risk->RISKREP_DATESAVE)) == $year.'-08'){ $month08++; }
                     if(date('Y-m',strtotime($risk->RISKREP_DATESAVE)) == $year.'-09'){ $month09++; }
                    

                     
                }

                $infogroup_dev= DB::table('risk_rep') 
                ->select('RISK_REP_DEPARTMENT_SUBNAME', DB::raw('count(*) as total'))
                ->leftjoin('risk_rep_department_sub','risk_rep.RISKREP_ID','=','risk_rep_department_sub.RISKREP_ID')
                ->WhereBetween('RISKREP_DATESAVE',[$from,$to])
                ->groupBy('RISK_REP_DEPARTMENT_SUBNAME')->get();

                $infogroup_team= DB::table('risk_rep')
                ->select('RISK_REP_TEAMLIST_NAME', DB::raw('count(*) as total'))
                ->leftjoin('risk_rep_teamlist','risk_rep.RISKREP_ID','=','risk_rep_teamlist.RISKREP_ID')
                ->WhereBetween('RISKREP_DATESAVE',[$from,$to])
                ->groupBy('RISK_REP_TEAMLIST_NAME')->get();


                

                $inforisk_1 = $lev_3 + $lev_4 + $lev_5; 
                $inforisk_2 = $lev_G + $lev_H + $lev_I; 
                $inforisk_3 = $lev_F + $lev_E; 




        return view('manager_risk.dashboard_risk',[
            'budgetyear_dropdown' =>$budgetyear_dropdown,  
            'budgetyear' => $budgetyear,
            'inforisk' => $inforisk,
            'inforisk_1' => $inforisk_1,
            'inforisk_2' => $inforisk_2,
            'inforisk_3' => $inforisk_3,
            'infostatus1' => $infostatus1,
            'infostatus2' => $infostatus2,
            'infostatus3' => $infostatus3,
            'infotodate' => $infotodate,
            'lev_A' => $lev_A,  
            'lev_B' => $lev_B,  
            'lev_C' => $lev_C,  
            'lev_D' => $lev_D,  
            'lev_E' => $lev_E,  
            'lev_F' => $lev_F,  
            'lev_G' => $lev_G,  
            'lev_H' => $lev_H,  
            'lev_I' => $lev_I,  
            'lev_1' => $lev_1,  
            'lev_2' => $lev_2,  
            'lev_3' => $lev_3,  
            'lev_4' => $lev_4,  
            'lev_5' => $lev_5,
            'month10' => $month10,  
            'month11' => $month11,  
            'month12' => $month12, 
            'month01' => $month01, 
            'month02' => $month02, 
            'month03' => $month03,
            'month04' => $month04,
            'month05' => $month05, 
            'month06' => $month06,
            'month07' => $month07,
            'month08' => $month08,
            'month09' => $month09,
            'infogroup_devs' => $infogroup_dev,
            'infogroup_teams' => $infogroup_team,
            
            
        ]);
    }



    public function risktime(Request $request)
    {    
        $risktime = DB::table('risk_rep_time')->orderBy('RISK_TIME_ID','DESC')->get();      

        return view('manager_risk.risktime',[
            'risktimes'=>$risktime,          
        ]);
    }
    public function risktime_save(Request $request)
    {    
        $add = new Risk_rep_time();
        $add->RISK_TIME_NAME = $request->RISK_TIME_NAME;
        $add->RISK_TIME_START = $request->RISK_TIME_START;
        $add->RISK_TIME_END = $request->RISK_TIME_END; 
        $add->RISK_TIME_COMMENT = $request->RISK_TIME_COMMENT;      
        $add->save();
        return redirect()->route('mrisk.risktime');
    }
    public function risktime_update(Request $request)
    {    
        $id = $request->risktime_id;
        $update = Risk_rep_time::find($id);
        $update->RISK_TIME_NAME = $request->RISK_TIME_NAME;
        $update->RISK_TIME_START = $request->RISK_TIME_START;
        $update->RISK_TIME_END = $request->RISK_TIME_END;
        $update->RISK_TIME_COMMENT = $request->RISK_TIME_COMMENT;      
        $update->save();
        return redirect()->route('mrisk.risktime');
    }
    public function risktime_destroy(Request $request,$id)
    {    
        Risk_rep_time::destroy($id);

        return redirect()->route('mrisk.risktime');
    }


    public function risklocation(Request $request)
    {    
        $risklo = Risk_rep_location::leftJoin('risk_setupincidence_tpyelocation','risk_setupincidence_tpyelocation.SETUP_TYPELOCATION_ID','=','risk_rep_location.SETUP_TYPELOCATION_ID')
        ->orderBy('RISK_LOCATION_ID','DESC')->get(); 
            
        $location = DB::table('risk_setupincidence_tpyelocation')->get();

        return view('manager_risk.risklocation',[
            'risklos'=>$risklo, 
            'locations'=>$location,         
        ]);
    }
    public function risklocation_save(Request $request)
    {    
        $add = new Risk_rep_location();
        $add->SETUP_TYPELOCATION_ID = $request->SETUP_TYPELOCATION_ID;
        $add->RISK_LOCATION_CODE = $request->RISK_LOCATION_CODE;
        $add->RISK_LOCATION_NAME = $request->RISK_LOCATION_NAME;
        $add->RISK_LOCATION_COMMENT = $request->RISK_LOCATION_COMMENT;
        $add->save();
        return redirect()->route('mrisk.risklocation');
    }
    public function risklocation_update(Request $request)
    {    
        $id = $request->risk_id;
        $update = Risk_rep_location::find($id);
        $update->SETUP_TYPELOCATION_ID = $request->SETUP_TYPELOCATION_ID;
        $update->RISK_LOCATION_CODE = $request->RISK_LOCATION_CODE;
        $update->RISK_LOCATION_NAME = $request->RISK_LOCATION_NAME;
        $update->RISK_LOCATION_COMMENT = $request->RISK_LOCATION_COMMENT;
        $update->save();
        return redirect()->route('mrisk.risklocation');
    }
    public function risklocation_destroy(Request $request,$id)
    {    
        Risk_rep_location::destroy($id);

        return redirect()->route('mrisk.risklocation');
    }

    public function riskgroup(Request $request)
    {    
        $risk = Risk_rep_group::orderBy('RISK_GROUP_ID','DESC')->get();        

        return view('manager_risk.riskgroup',[
            'risks'=>$risk,          
        ]);
    }
    public function riskgroup_save(Request $request)
    {    
        $add = new Risk_rep_group();
        $add->RISK_GROUP_CODE = $request->RISK_GROUP_CODE;
        $add->RISK_GROUP_NAME = $request->RISK_GROUP_NAME;
        $add->save();
        return redirect()->route('mrisk.riskgroup');
    }
    public function riskgroup_update(Request $request)
    {    
        $id = $request->risk_id;
        $update = Risk_rep_group::find($id);
        $update->RISK_GROUP_CODE = $request->RISK_GROUP_CODE;
        $update->RISK_GROUP_NAME = $request->RISK_GROUP_NAME;
        $update->save();
        return redirect()->route('mrisk.riskgroup');
    }
    public function riskgroup_destroy(Request $request,$id)
    {    
        Risk_rep_group::destroy($id);

        return redirect()->route('mrisk.riskgroup');
    }


    public function riskgroupsub(Request $request)
    {    
        $riskgs = Risk_rep_groupsub::leftJoin('risk_rep_group','risk_rep_group.RISK_GROUP_ID','=','risk_rep_groupsub.RISK_GROUP_ID')
        ->orderBy('RISK_GROUPSUB_ID','DESC')->get();   
        
        $riskgroup = Risk_rep_group::get();

        return view('manager_risk.riskgroupsub',[
            'riskgss'=>$riskgs,  
            'riskgroups'=>$riskgroup,         
        ]);
    }
    public function riskgroupsub_save(Request $request)
    {    

        $add = new Risk_rep_groupsub();
        $add->RISK_GROUPSUB_CODE = $request->RISK_GROUPSUB_CODE;
        $add->RISK_GROUPSUB_NAME = $request->RISK_GROUPSUB_NAME;
        $add->RISK_GROUP_ID = $request->RISK_GROUP_ID;
        $add->save();
        return redirect()->route('mrisk.riskgroupsub');
    }
    public function riskgroupsub_update(Request $request)
    {    
        $id = $request->risk_id;
        $update = Risk_rep_groupsub::find($id);
        $update->RISK_GROUPSUB_CODE = $request->RISK_GROUPSUB_CODE;
        $update->RISK_GROUPSUB_NAME = $request->RISK_GROUPSUB_NAME;
        $update->RISK_GROUP_ID = $request->RISK_GROUP_ID;
        $update->save();
        return redirect()->route('mrisk.riskgroupsub');
    }
    public function riskgroupsub_destroy(Request $request,$id)
    {    
        Risk_rep_groupsub::destroy($id);

        return redirect()->route('mrisk.riskgroupsub');
    }


    public function riskgroupsubsub(Request $request)
    {    
        $risk = Risk_rep_groupsubsub::leftJoin('risk_rep_groupsub','risk_rep_groupsub.RISK_GROUPSUB_ID','=','risk_rep_groupsub_sub.RISK_GROUPSUB_ID')
        ->leftJoin('risk_rep_group','risk_rep_group.RISK_GROUP_ID','=','risk_rep_groupsub_sub.RISK_GROUP_ID')
        ->orderBy('RISK_GROUPSUBSUB_ID','DESC')->get();     
        
        $riskgroup = Risk_rep_group::get();
        $riskgroupsub = Risk_rep_groupsub::get();

        return view('manager_risk.riskgroupsubsub',[
            'risks'=>$risk,    
            'riskgroups'=>$riskgroup, 
            'riskgroupsubs'=>$riskgroupsub,     
        ]);
    }
    public function riskgroupsubsub_save(Request $request)
    {    
        $add = new Risk_rep_groupsubsub();
        $add->RISK_GROUPSUBSUB_CODE = $request->RISK_GROUPSUBSUB_CODE;
        $add->RISK_GROUPSUBSUB_NAME = $request->RISK_GROUPSUBSUB_NAME;
        $add->RISK_GROUPSUB_ID = $request->RISK_GROUPSUB_ID;
        $add->RISK_GROUP_ID = $request->RISK_GROUP_ID;
        $add->save();
        return redirect()->route('mrisk.riskgroupsubsub');
    }
    public function riskgroupsubsub_update(Request $request)
    {    
        $id = $request->risk_id;
        $update = Risk_rep_groupsubsub::find($id);
        $update->RISK_GROUPSUBSUB_CODE = $request->RISK_GROUPSUBSUB_CODE;
        $update->RISK_GROUPSUBSUB_NAME = $request->RISK_GROUPSUBSUB_NAME;
        $update->RISK_GROUPSUB_ID = $request->RISK_GROUPSUB_ID;
        $update->RISK_GROUP_ID = $request->RISK_GROUP_ID;
        $update->save();
        return redirect()->route('mrisk.riskgroupsubsub');
    }
    public function riskgroupsubsub_destroy(Request $request,$id)
    {    
        Risk_rep_groupsubsub::destroy($id);

        return redirect()->route('mrisk.riskgroupsubsub');
    }

    public function riskrepdetail(Request $request)
    {    
        $risk = Risk_rep_detail::leftJoin('risk_rep_groupsub_sub','risk_rep_groupsub_sub.RISK_GROUPSUBSUB_ID','=','risk_rep_detail.RISK_GROUPSUBSUB_ID')
        ->leftJoin('risk_rep_groupsub','risk_rep_groupsub.RISK_GROUPSUB_ID','=','risk_rep_detail.RISK_GROUPSUB_ID')
        ->leftJoin('risk_rep_group','risk_rep_group.RISK_GROUP_ID','=','risk_rep_detail.RISK_GROUP_ID')
        ->orderBy('RISK_REPDETAIL_ID','DESC')->get();     
        
        $riskgroup = Risk_rep_group::get();
        $riskgroupsub = Risk_rep_groupsub::get();
        $riskgroupsubsub = Risk_rep_groupsubsub::get();

        return view('manager_risk.riskrepdetail',[
            'risks'=>$risk,    
            'riskgroups'=>$riskgroup, 
            'riskgroupsubs'=>$riskgroupsub,
            'riskgroupsubsubs'=>$riskgroupsubsub,     

        ]);
    }
    public function riskrepdetail_save(Request $request)
    {   
        $add = new Risk_rep_detail();
        $add->RISK_REPDETAIL_CODE = $request->RISK_REPDETAIL_CODE;
        $add->RISK_REPDETAIL_NAME = $request->RISK_REPDETAIL_NAME;
        $add->RISK_GROUPSUBSUB_ID = $request->RISK_GROUPSUBSUB_ID;
        $add->RISK_GROUPSUB_ID = $request->RISK_GROUPSUB_ID;
        $add->RISK_GROUP_ID = $request->RISK_GROUP_ID;
        $add->save();
        return redirect()->route('mrisk.riskrepdetail');
    }
    public function riskrepdetail_update(Request $request)
    {   
        $id = $request->risk_id;
        $update = Risk_rep_detail::find($id);
        $update->RISK_REPDETAIL_CODE = $request->RISK_REPDETAIL_CODE;
        $update->RISK_REPDETAIL_NAME = $request->RISK_REPDETAIL_NAME;
        $update->RISK_GROUPSUBSUB_ID = $request->RISK_GROUPSUBSUB_ID;
        $update->RISK_GROUPSUB_ID = $request->RISK_GROUPSUB_ID;
        $update->RISK_GROUP_ID = $request->RISK_GROUP_ID;
        $update->save();
        return redirect()->route('mrisk.riskrepdetail');
    }
    public function riskrepdetail_destroy(Request $request,$id)
    {    
        Risk_rep_detail::destroy($id);

        return redirect()->route('mrisk.riskrepdetail');
    }

    public function riskrepitems(Request $request)
    {    
       
        $risk = Risk_rep_items::leftJoin('risk_rep_group','risk_rep_group.RISK_GROUP_ID','=','risk_rep_items.RISK_GROUP_ID')
        ->leftJoin('risk_rep_groupsub','risk_rep_groupsub.RISK_GROUPSUB_ID','=','risk_rep_items.RISK_GROUPSUB_ID')
        ->leftJoin('risk_rep_groupsub_sub','risk_rep_groupsub_sub.RISK_GROUPSUBSUB_ID','=','risk_rep_items.RISK_GROUPSUBSUB_ID')
        ->leftJoin('risk_rep_detail','risk_rep_detail.RISK_REPDETAIL_ID','=','risk_rep_items.RISK_REPDETAIL_ID')
        ->orderBy('RISK_REPITEMS_ID','DESC')->get(); 
        
        $riskgroup = Risk_rep_group::get();
        $riskgroupsub = Risk_rep_groupsub::get();
        $riskgroupsubsub = Risk_rep_groupsubsub::get();
        $riskrepdetail = Risk_rep_detail::get();

        return view('manager_risk.riskrepitems',[
            'risks'=>$risk,    
            'riskgroups'=>$riskgroup, 
            'riskgroupsubs'=>$riskgroupsub,
            'riskgroupsubsubs'=>$riskgroupsubsub,  
            'riskrepdetails'=>$riskrepdetail,    

        ]);
    }
    public function riskrepitems_save(Request $request)
    {   
        $add = new Risk_rep_items();
        $add->RISK_REPITEMS_CODE = $request->RISK_REPITEMS_CODE;
        $add->RISK_REPITEMS_NAME = $request->RISK_REPITEMS_NAME;
        $add->RISK_GROUP_ID = $request->RISK_GROUP_ID;
        $add->RISK_GROUPSUB_ID = $request->RISK_GROUPSUB_ID;
        $add->RISK_GROUPSUBSUB_ID = $request->RISK_GROUPSUBSUB_ID;
        $add->RISK_REPDETAIL_ID = $request->RISK_REPDETAIL_ID;
        $add->RISK_REPITEMS_COMMENT = $request->RISK_REPITEMS_COMMENT;
        $add->RISK_REPITEMS_DETAIL = $request->RISK_REPITEMS_DETAIL;
        $add->save();
        return redirect()->route('mrisk.riskrepitems');
    }
    public function riskrepitems_update(Request $request)
    {   
        $id = $request->risk_id;
        $update = Risk_rep_items::find($id);
        $update->RISK_REPITEMS_CODE = $request->RISK_REPITEMS_CODE;
        $update->RISK_REPITEMS_NAME = $request->RISK_REPITEMS_NAME;
        $update->RISK_GROUP_ID = $request->RISK_GROUP_ID;
        $update->RISK_GROUPSUB_ID = $request->RISK_GROUPSUB_ID;
        $update->RISK_GROUPSUBSUB_ID = $request->RISK_GROUPSUBSUB_ID;
        $update->RISK_REPDETAIL_ID = $request->RISK_REPDETAIL_ID;
        $update->RISK_REPITEMS_COMMENT = $request->RISK_REPITEMS_COMMENT;
        $update->RISK_REPITEMS_DETAIL = $request->RISK_REPITEMS_DETAIL;
        $update->save();
        return redirect()->route('mrisk.riskrepitems');
    }
    public function riskrepitems_destroy(Request $request,$id)
    {    
        Risk_rep_items::destroy($id);

        return redirect()->route('mrisk.riskrepitems');
    }

    public function riskrepitemsub(Request $request)
    {    
        $riskitemsub = Risk_rep_items_sub::orderBy('RISK_REPITEMSSUB_ID','DESC')
        ->leftjoin('risk_rep_items','risk_rep_items.RISK_REPITEMS_ID','=','risk_rep_items_sub.RISK_REPITEMS_ID')
        ->get();    
        
        $riskitem = Risk_rep_items::get();
        
       
        return view('manager_risk.riskrepitemsub',[
            'riskitemsubs'=>$riskitemsub,
            'riskitems'=>$riskitem,
        ]);
    }
    public function riskrepitemsub_save(Request $request)
    {    
        $add = new Risk_rep_items_sub();
        $add->RISK_REPITEMSSUB_CODE = $request->RISK_REPITEMSSUB_CODE;
        $add->RISK_REPITEMSSUB_NAME = $request->RISK_REPITEMSSUB_NAME;
        $add->RISK_REPITEMS_ID = $request->RISK_REPITEMS_ID;
        $add->save();
        return redirect()->route('mrisk.riskrepitemsub');
    }
    public function riskrepitemsub_update(Request $request)
    {    
        $id = $request->risk_id;
        $update = Risk_rep_items_sub::find($id);
        $update->RISK_REPITEMSSUB_CODE = $request->RISK_REPITEMSSUB_CODE;
        $update->RISK_REPITEMSSUB_NAME = $request->RISK_REPITEMSSUB_NAME;
        $update->RISK_REPITEMS_ID = $request->RISK_REPITEMS_ID;
        $update->save();
        return redirect()->route('mrisk.riskrepitemsub');
    }
    public function riskrepitemsub_destroy(Request $request,$id)
    {    
        Risk_rep_items_sub::destroy($id);

        return redirect()->route('mrisk.riskrepitemsub');
    }


    public function riskrepprogram(Request $request)
    {    
        $risk = Risk_rep_program::orderBy('RISK_REPPROGRAM_ID','DESC')->get();        

        return view('manager_risk.riskrepprogram',[
            'risks'=>$risk,          
        ]);
    }
    public function riskrepprogram_save(Request $request)
    {    
        $add = new Risk_rep_program();

        $add->RISK_REPPROGRAM_NAME = $request->RISK_REPPROGRAM_NAME;
        $add->save();
        return redirect()->route('mrisk.riskrepprogram');
    }
    public function riskrepprogram_update(Request $request)
    {    
        $id = $request->risk_id;
        $update = Risk_rep_program::find($id);

        $update->RISK_REPPROGRAM_NAME = $request->RISK_REPPROGRAM_NAME;
        $update->save();
        return redirect()->route('mrisk.riskrepprogram');
    }
    public function riskrepprogram_destroy(Request $request,$id)
    {    
        Risk_rep_program::destroy($id);

        return redirect()->route('mrisk.riskrepprogram');
    }

    public function riskrepprogramsub(Request $request)
    {    
        $risk = Risk_rep_program_sub::leftJoin('risk_rep_program','risk_rep_program.RISK_REPPROGRAM_ID','=','risk_rep_program_sub.RISK_REPPROGRAM_ID')
        ->orderBy('RISK_REPPROGRAMSUB_ID','DESC')->get();
        
        
        $riskprogram = Risk_rep_program::get();

        return view('manager_risk.riskrepprogramsub',[
            'risks'=>$risk,  
            'riskprograms'=>$riskprogram,        
        ]);
    }
    public function riskrepprogramsub_save(Request $request)
    {    
        $add = new Risk_rep_program_sub();
        $add->RISK_REPPROGRAMSUB_NAME = $request->RISK_REPPROGRAMSUB_NAME;
        $add->RISK_REPPROGRAM_ID = $request->RISK_REPPROGRAM_ID;
        $add->save();
        return redirect()->route('mrisk.riskrepprogramsub');
    }
    public function riskrepprogramsub_update(Request $request)
    {    
        $id = $request->risk_id;
        $update = Risk_rep_program_sub::find($id);
        $update->RISK_REPPROGRAMSUB_NAME = $request->RISK_REPPROGRAMSUB_NAME;
        $update->RISK_REPPROGRAM_ID = $request->RISK_REPPROGRAM_ID;
        $update->save();
        return redirect()->route('mrisk.riskrepprogramsub');
    }
    public function riskrepprogramsub_destroy(Request $request,$id)
    {    
        Risk_rep_program_sub::destroy($id);

        return redirect()->route('mrisk.riskrepprogramsub');
    }


    public function riskrepprogramsubsub(Request $request)
    {    
        $risk = Risk_rep_program_subsub::leftJoin('risk_rep_program_sub','risk_rep_program_sub.RISK_REPPROGRAMSUB_ID','=','risk_rep_program_subsub.RISK_REPPROGRAMSUB_ID')
        ->orderBy('RISK_REPPROGRAMSUBSUB_ID','DESC')->get(); 
        
        $riskprogramsub = Risk_rep_program_sub::get();

        return view('manager_risk.riskrepprogramsubsub',[
            'risks'=>$risk, 
            'riskprogramsubs'=>$riskprogramsub,          
        ]);
    }
    public function riskrepprogramsubsub_save(Request $request)
    {    
        $add = new Risk_rep_program_subsub();
        $add->RISK_REPPROGRAMSUBSUB_NAME = $request->RISK_REPPROGRAMSUBSUB_NAME;
        $add->RISK_REPPROGRAMSUB_ID = $request->RISK_REPPROGRAMSUB_ID;
        $add->save();
        return redirect()->route('mrisk.riskrepprogramsubsub');
    }
    public function riskrepprogramsubsub_update(Request $request)
    {    
        $id = $request->risk_id;
        $update = Risk_rep_program_subsub::find($id);
        $update->RISK_REPPROGRAMSUBSUB_NAME = $request->RISK_REPPROGRAMSUBSUB_NAME;
        $update->RISK_REPPROGRAMSUB_ID = $request->RISK_REPPROGRAMSUB_ID;
        $update->save();
        return redirect()->route('mrisk.riskrepprogramsubsub');
    }
    public function riskrepprogramsubsub_destroy(Request $request,$id)
    {    
        Risk_rep_program_subsub::destroy($id);

        return redirect()->route('mrisk.riskrepprogramsubsub');
    }

    public function riskrep_typereason(Request $request)
    {    
        $risk = Risk_rep_typereason::orderBy('RISK_REPTYPERESON_ID','DESC')->get();        

        return view('manager_risk.riskrep_typereason',[
            'risks'=>$risk,          
        ]);
    }
    public function riskrep_typereason_save(Request $request)
    {    
        $add = new Risk_rep_typereason();
        $add->RISK_REPTYPERESON_NAME = $request->RISK_REPTYPERESON_NAME;
        $add->save();
        return redirect()->route('mrisk.riskrep_typereason');
    }
    public function riskrep_typereason_update(Request $request)
    {    
        $id = $request->risk_id;
        $update = Risk_rep_typereason::find($id);
        $update->RISK_REPTYPERESON_NAME = $request->RISK_REPTYPERESON_NAME;
        $update->save();
        return redirect()->route('mrisk.riskrep_typereason');
    }
    public function riskrep_typereason_destroy(Request $request,$id)
    {    
        Risk_rep_typereason::destroy($id);

        return redirect()->route('mrisk.riskrep_typereason');
    }

    public function riskrep_typereason_sys(Request $request)
    {    
        $risk = Risk_rep_typereason_sys::orderBy('RISK_REPTYPERESONSYS_ID','DESC')->get();        

        return view('manager_risk.riskrep_typereason_sys',[
            'risks'=>$risk,          
        ]);
    }
    public function riskrep_typereason_sys_save(Request $request)
    {    
        $add = new Risk_rep_typereason_sys();
        $add->RISK_REPTYPERESONSYS_NAME = $request->RISK_REPTYPERESONSYS_NAME;
        $add->RISK_REPTYPERESONSYS_DETAIL = $request->RISK_REPTYPERESONSYS_DETAIL;
        $add->save();
        return redirect()->route('mrisk.riskrep_typereason_sys');
    }
    public function riskrep_typereason_sys_update(Request $request)
    {    
        $id = $request->risk_id;
        $update = Risk_rep_typereason_sys::find($id);
        $update->RISK_REPTYPERESONSYS_NAME = $request->RISK_REPTYPERESONSYS_NAME;
        $update->RISK_REPTYPERESONSYS_DETAIL = $request->RISK_REPTYPERESONSYS_DETAIL;
        $update->save();
        return redirect()->route('mrisk.riskrep_typereason_sys');
    }
    public function riskrep_typereason_sys_destroy(Request $request,$id)
    {    
        Risk_rep_typereason_sys::destroy($id);

        return redirect()->route('mrisk.riskrep_typereason_sys');
    }

    public function riskrep_level(Request $request)
    {    
        $risk = Risk_rep_level::orderBy('RISK_REP_LEVEL_ID','DESC')->get();        

        return view('manager_risk.riskrep_level',[
            'risks'=>$risk,          
        ]);
    }
    public function riskrep_level_save(Request $request)
    {    
        $add = new Risk_rep_level();
        $add->RISK_REP_LEVEL_CODE = $request->RISK_REP_LEVEL_CODE;
        $add->RISK_REP_LEVEL_NAME = $request->RISK_REP_LEVEL_NAME;
        $add->RISK_REP_LEVEL_DETAIL = $request->RISK_REP_LEVEL_DETAIL;
        $add->save();
        return redirect()->route('mrisk.riskrep_level');
    }
    public function riskrep_level_update(Request $request)
    {    
        $id = $request->risk_id;
        $update = Risk_rep_level::find($id);
        $update->RISK_REP_LEVEL_CODE = $request->RISK_REP_LEVEL_CODE;
        $update->RISK_REP_LEVEL_NAME = $request->RISK_REP_LEVEL_NAME;
        $update->RISK_REP_LEVEL_DETAIL = $request->RISK_REP_LEVEL_DETAIL;
        $update->save();
        return redirect()->route('mrisk.riskrep_level');
    }
    public function riskrep_level_destroy(Request $request,$id)
    {    
        Risk_rep_level::destroy($id);

        return redirect()->route('mrisk.riskrep_level');
    }


    public function riskrep_function(Request $request)
    {    
        $inforiskfunction = DB::table('risk_function')->get();     

        return view('manager_risk.riskrep_function',[
            'inforiskfunctions' =>$inforiskfunction 
        ]);

    }    

    function switchfunction(Request $request)
    {  
     
        $id = $request->idfunc;
        $active = Riskfunction::find($id);
        $active->ACTIVE = $request->onoff;
        $active->save();
    }
    


    public function riskrep_matrixtable(Request $request)
    {   
        $inforiskimgmatrix = DB::table('risk_img_matrix')->where('RISK_IMG_ID','=','1')->first();   
        
      
        return view('manager_risk.riskrep_matrixtable',[
            'inforiskimgmatrix' =>$inforiskimgmatrix 
        ]);

    }
    
    function riskrep_matrixtableupdate(Request $request)
    {  
      
        $id = $request->RISK_IMG_ID;
        $imgactive = Risk_img_matrix::find($id);
        if($request->hasFile('picture')){
          
            
            $file = $request->file('picture');  
            $contents = $file->openFile()->fread($file->getSize());
            $imgactive->RISK_IMG_MATRIX = $contents;   
         
        }


        $imgactive->save();

        return redirect()->route('mrisk.riskrep_matrixtable');
    }


        public function risk_account(Request $request)
    {

        if($request->method() === 'POST'){
            $search     = $request->get('search');
            $type     = $request->TYPE;
     
        $data_search = json_encode_u([
                'search' => $search,
                'type' => $type,
            ]);
            Cookie::queue('data_search', $data_search, 120,$request->server('REQUEST_URI'));
        }elseif(!empty(Cookie::get('data_search'))){
            $data_search    = json_decode(Cookie::get('data_search'));
            $search     = $data_search->search;
            $type     = $data_search->type;
        }else{
            $search     = '';
            $type       = '';
        }

        
      
        if( $type !== '' && $type !== null){
            
            $infomation = DB::table('risk_account_detail')
            ->leftjoin('risk_type','risk_type.RISK_TYPE_ID','=','risk_account_detail.RISK_TYPE_ID')
            ->leftjoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','risk_account_detail.RISK_ACC_AGENCY')
            ->where('risk_type.RISK_TYPE_ID','=',$type)
            ->where(function($q) use ($search){
                $q->where('RISK_ACC_MISSION','like','%'.$search.'%');
                $q->orwhere('RISK_ACC_ISSUE','like','%'.$search.'%');
                $q->orwhere('RISK_ACC_FACTOR','like','%'.$search.'%');
                $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');
            })
            ->get();

        }else{
            $infomation = DB::table('risk_account_detail')
            ->leftjoin('risk_type','risk_type.RISK_TYPE_ID','=','risk_account_detail.RISK_TYPE_ID')
            ->leftjoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','risk_account_detail.RISK_ACC_AGENCY')
            ->where(function($q) use ($search){
                $q->where('RISK_ACC_MISSION','like','%'.$search.'%');
                $q->orwhere('RISK_ACC_ISSUE','like','%'.$search.'%');
                $q->orwhere('RISK_ACC_FACTOR','like','%'.$search.'%');
                $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');
            })
            ->get();
        }
       
      

        $infomationrist = DB::table('risk_internalcontrol_analyze')->get();
        $inforisktype = DB::table('risk_type')->get();    
        $infodepartment = DB::table('hrd_department_sub_sub')->get();   

        

        return view('manager_risk.risk_account',[
            'infomations' => $infomation,
            'infomationrists' => $infomationrist,  
            'inforisktypes' => $inforisktype,
            'infodepartments' => $infodepartment,
            'search' => $search,
            'type' => $type
        ]);
    }

    public function risk_account_detail(Request $request,$id)
    {       
      
        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;        }

        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';
        $status = '';
        $search = '';
        $year_id = $yearbudget; 
        
        $status = DB::table('risk_status')->get();
        $infoper = DB::table('hrd_person')->get();
    
       $risk_account_type = DB::table('risk_account_type')->get();
       $scope = DB::table('risk_account_scope')->get();
       $riskef = DB::table('risk_account_riskeffect')->get();
       $risklevel = DB::table('risk_account_risk_level')->get();
     
       $riskacc = Risk_account::leftjoin('hrd_department_sub','risk_account.RISK_ACCOUNT_DEBSUBSUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
       ->leftjoin('risk_account_type','risk_account.RISK_ACCOUNT_RISK','=','risk_account_type.RISK_ACCOUNTTYPE_ID')
       ->leftjoin('hrd_person','risk_account.RISK_ACCOUNT_USERID','=','hrd_person.ID')
       ->where('RISK_ACCOUNT_ID','=',$id)
       ->first();

        return view('manager_risk.risk_account_detail',[
            'risk_account_types' => $risk_account_type,
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id,
            'statuss'=>$status,
            'riskaccs'=>$riskacc,
            'scopes'=>$scope,
            'riskefs'=>$riskef,
            'risklevels'=>$risklevel,
        ]);
    }
    public function risk_account_add(Request $request)
    {
                 
                $origin = DB::table('risk_setupincidence_origin')->get(); 
                $typelocationf = DB::table('risk_setupincidence_tpyelocation')->first();
                $grouplocation = DB::table('risk_rep_location')->where('SETUP_TYPELOCATION_ID','=',$typelocationf->SETUP_TYPELOCATION_ID)->get();
                $worktime = DB::table('risk_rep_time')->get();
                $typelocation = DB::table('risk_setupincidence_tpyelocation')->get();
                $infoper = DB::table('hrd_person')->get();
                $uefect = DB::table('risk_setupincidence_usereffect')->get();
               
                $riskcategory = DB::table('risk_setincidence_category')->get();
                $location = DB::table('risk_setupincidence_location')->get();
                $level = DB::table('risk_rep_level')->get();
                $setting = DB::table('risk_setincidence_setting')->get(); 
                $incidentsub = DB::table('risk_setupincidence_sub')->get();
                $riskitem = Risk_rep_items::get();
                $sex = DB::table('hrd_sex')->get();
                $effect = DB::table('risk_setupincidence_usereffect')->get();
                
                $riskprogram  = DB::table('risk_rep_program')->get();
                $riskprogramsub  = DB::table('risk_rep_program_sub')->get();
                $riskprogramsubsub  = DB::table('risk_rep_program_subsub')->get();
                $risktypereason  = DB::table('risk_rep_typereason')->get();
                $risktypereasonsys  = DB::table('risk_rep_typereason_sys')->get();
                $item = DB::table('risk_rep_items')->get();
                $itemsub = DB::table('risk_rep_items_sub')->get();
                $infoteam = Team::orderBy('HR_TEAM_ID', 'asc')->get();
    
    
                $team =  DB::table('hrd_team')->get(); 
                $riskrepdep = DB::table('risk_rep_typedep')->get(); 
                $department  =  DB::table('hrd_department')->get();
                //--------------------------  ฝ่าย/แผนก ------------------
                $infordepartmentsub  =  DB::table('hrd_department_sub')->get();  
                //-----------------   หน่วยงาน --------------------------
                $departsub = DB::table('hrd_department_sub_sub')->get();
                $infordepartmentsubsub  =  DB::table('hrd_department_sub_sub')->get();
    
       
            return view('manager_risk.risk_account_add',[
                'departsubs'=>$departsub,
                'riskcategorys'=>$riskcategory,
                'locations'=>$location,
                'levels'=>$level,
                'settings'=>$setting,
                'incidentsubs'=>$incidentsub,
                'origins'=>$origin,
                'sexs'=>$sex,
                'infopers'=>$infoper,
                'grouplocations'=>$grouplocation,
                'worktimes'=>$worktime,
                'typelocations'=>$typelocation,
                'departments'=>$department,
                'infordepartmentsubs'=>$infordepartmentsub,
                'infordepartmentsubsubs'=>$infordepartmentsubsub,
                'riskprograms'=>$riskprogram,
                'riskprogramsubs'=>$riskprogramsub,
                'riskprogramsubsubs'=>$riskprogramsubsub,
                'risktypereasons'=>$risktypereason,
                'risktypereasonsyss'=>$risktypereasonsys,
                'uefects'=>$uefect,
                'infoteams'=>$infoteam,
                'items'=>$item,
                'riskitems'=>$riskitem,
                'itemsubs'=>$itemsub,
                'riskrepdeps'=>$riskrepdep,
                
            ]);
        
    }
    public function detail(Request $request)
    {   
        
    
        if($request->method() === 'POST'){
            $search     = $request->get('search');
            $yearbudget     = $request->BUDGET_YEAR;
            $status     = $request->STATUS;
            $datebigin  = $request->get('DATE_BIGIN');
            $dateend    = $request->get('DATE_END');
            $data_search = json_encode_u([
                'search' => $search,
                'yearbudget' => $yearbudget,
                'datebigin' => $datebigin,
                'dateend' => $dateend,
                'status' => $status,
            ]);
            Cookie::queue('data_search', $data_search, 120,$request->server('REQUEST_URI'));
        }elseif(!empty(Cookie::get('data_search'))){
            $data_search    = json_decode(Cookie::get('data_search'));
            $search     = $data_search->search;
            $yearbudget     = $data_search->yearbudget;
            $datebigin     = $data_search->datebigin;
            $dateend     = $data_search->dateend;
            $status     = $data_search->status;
        }else{
            $search     = null;
            $yearbudget = getBudgetYear();
            $datebigin  = date('01/10/'.(($yearbudget-1)-543));
            $dateend    = date('30/09/'.($yearbudget-543));
            $status       = null;
        }


   
       
      

        $date_bigen_c = Carbon::createFromFormat('d/m/Y', $datebigin)->format('Y-m-d');
        $date_arrary=explode("-",$date_bigen_c);
        $y_sub_st = $date_arrary[0];
        if($y_sub_st >= 2500){
            $y = $y_sub_st-543;
        }else{
            $y = $y_sub_st;
        }
        $m = $date_arrary[1];
        $d = $date_arrary[2];  
        $displaydate_bigen= $y."-".$m."-".$d;
        $date_end_c = Carbon::createFromFormat('d/m/Y', $dateend)->format('Y-m-d');
        $date_arrary_e=explode("-",$date_end_c); 
        $y_sub_e = $date_arrary_e[0];
        if($y_sub_e >= 2500){
            $y_e = $y_sub_e-543;
        }else{
            $y_e = $y_sub_e;
        }
        $m_e = $date_arrary_e[1];
        $d_e = $date_arrary_e[2];  
        $displaydate_end= $y_e."-".$m_e."-".$d_e;
        $from = date($displaydate_bigen);
        $to = date($displaydate_end);

        if($status !== null){
            $rigrep = Riskrep::leftjoin('risk_setincidence_setting','risk_rep.RISKREP_TITLE','=','risk_setincidence_setting.INCIDENCE_SETTING_ID')
            ->leftjoin('risk_status','risk_rep.RISKREP_STATUS','=','risk_status.RISK_STATUS_NAME')
            ->leftJoin('risk_rep_level','risk_rep.RISKREP_LEVEL','=','risk_rep_level.RISK_REP_LEVEL_ID')
            ->leftJoin('risk_rep_items','risk_rep.RISK_REPITEMS_ID','=','risk_rep_items.RISK_REPITEMS_ID')
            ->leftjoin('risk_setupincidence_location','risk_rep.RISKREP_SEARCHLOCATE','=','risk_setupincidence_location.INCIDENCE_LOCATION_ID')
            ->leftjoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','risk_rep.RISKREP_DEPARTMENT_SUB')
            ->leftjoin('risk_setupincidence_tpyelocation','risk_setupincidence_tpyelocation.SETUP_TYPELOCATION_ID','=','risk_rep.RISKREP_TYPE')
            ->leftjoin('risk_setupincidence_grouplocation','risk_setupincidence_grouplocation.SETUP_GROUPLOCATION_ID','=','risk_rep.RISKREP_LOCAL')
            ->leftjoin('risk_setupincidence_sub','risk_setupincidence_sub.INCIDENCE_SUB_ID','=','risk_rep.RISKREP_SUBTITLE')
            ->leftjoin('hrd_sex','hrd_sex.SEX_ID','=','risk_rep.RISKREP_SEX')
            ->where('risk_rep.RISKREP_STATUS','=',$status)
            ->where(function($q) use ($search){
                $q->where('RISK_REP_LEVEL_NAME','like','%'.$search.'%');
                $q->orwhere('RISKREP_BASICMANAGE','like','%'.$search.'%');
                $q->orwhere('RISKREP_DETAILRISK','like','%'.$search.'%'); 
                $q->orwhere('RISK_STATUS_NAME_TH','like','%'.$search.'%');   
                $q->orwhere('INCIDENCE_LOCATION_NAME','like','%'.$search.'%');  
                $q->orwhere('RISKREP_NO','like','%'.$search.'%');  
            })
            ->WhereBetween('RISKREP_DATESAVE',[$from,$to]) 
            ->orderBy('RISKREP_ID','DESC')
            ->get();
             
    
        }else{
            $rigrep = Riskrep::leftjoin('risk_setincidence_setting','risk_rep.RISKREP_TITLE','=','risk_setincidence_setting.INCIDENCE_SETTING_ID')
            ->leftjoin('risk_status','risk_rep.RISKREP_STATUS','=','risk_status.RISK_STATUS_NAME')
            ->leftJoin('risk_rep_level','risk_rep.RISKREP_LEVEL','=','risk_rep_level.RISK_REP_LEVEL_ID')
            ->leftJoin('risk_rep_items','risk_rep.RISK_REPITEMS_ID','=','risk_rep_items.RISK_REPITEMS_ID')
            ->leftjoin('risk_setupincidence_location','risk_rep.RISKREP_SEARCHLOCATE','=','risk_setupincidence_location.INCIDENCE_LOCATION_ID')
            ->leftjoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','risk_rep.RISKREP_DEPARTMENT_SUB')
            ->leftjoin('risk_setupincidence_tpyelocation','risk_setupincidence_tpyelocation.SETUP_TYPELOCATION_ID','=','risk_rep.RISKREP_TYPE')
            ->leftjoin('risk_setupincidence_grouplocation','risk_setupincidence_grouplocation.SETUP_GROUPLOCATION_ID','=','risk_rep.RISKREP_LOCAL')
            ->leftjoin('risk_setupincidence_sub','risk_setupincidence_sub.INCIDENCE_SUB_ID','=','risk_rep.RISKREP_SUBTITLE')
            ->leftjoin('hrd_sex','hrd_sex.SEX_ID','=','risk_rep.RISKREP_SEX')
            ->where(function($q) use ($search){
                $q->where('RISK_REP_LEVEL_NAME','like','%'.$search.'%');
                $q->orwhere('RISKREP_BASICMANAGE','like','%'.$search.'%');
                $q->orwhere('RISKREP_DETAILRISK','like','%'.$search.'%'); 
                $q->orwhere('RISK_STATUS_NAME_TH','like','%'.$search.'%');   
                $q->orwhere('INCIDENCE_LOCATION_NAME','like','%'.$search.'%');   
                $q->orwhere('RISKREP_NO','like','%'.$search.'%');  
            })
            ->WhereBetween('RISKREP_DATESAVE',[$from,$to]) 
            ->orderBy('RISKREP_ID','DESC')
            ->get();
             
    
        }

        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $displaydate_bigen  = $from;
        $displaydate_end    = $to;
        $year_id = $yearbudget;
        $status_info = DB::table('risk_status')->get();
        return view('manager_risk.riskdetail',[           
            'rigreps'=>$rigrep,
            'status_check'=> $status,
            'search'=> $search,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,  
            'budgets' =>  $budget,
            'year_id'=>$year_id,  
            'statuss'=>$status_info, 
        ]);
    }

    

    public function detail_detail(Request $request,$id)
    {   
        $rigrep = DB::table('risk_rep')->where('RISKREP_ID','=',$id)
            ->leftJoin('risk_rep_level','risk_rep.RISKREP_LEVEL','=','risk_rep_level.RISK_REP_LEVEL_ID')
            ->leftJoin('risk_setupincidence_location','risk_rep.RISKREP_SEARCHLOCATE','=','risk_setupincidence_location.INCIDENCE_LOCATION_ID')
            ->leftJoin('risk_setup_origindepart','risk_rep.RISKREP_LOCAL','=','risk_setup_origindepart.ORIGIN_DEPART_ID')
            ->leftJoin('hrd_department_sub_sub','risk_rep.RISKREP_DEPARTMENT_SUB','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
            ->leftJoin('risk_setupincidence_tpyelocation','risk_rep.RISKREP_TYPE','=','risk_setupincidence_tpyelocation.SETUP_TYPELOCATION_ID')
            ->leftJoin('risk_rep_items','risk_rep.RISK_REPITEMS_ID','=','risk_rep_items.RISK_REPITEMS_ID')
            ->leftJoin('hrd_person','risk_rep.RISKREP_USEREFFECT','=','hrd_person.ID')
            ->leftJoin('hrd_sex','risk_rep.RISKREP_SEX','=','hrd_sex.SEX_ID')
            ->leftJoin('risk_workingtime','risk_rep.RISKREP_FATE','=','risk_workingtime.WORKING_TIME_ID')
            ->leftjoin('hrd_team','hrd_team.HR_TEAM_NAME','=','risk_rep.RISKREP_TEAM_CODE')
            ->leftjoin('risk_rep_location','risk_rep_location.RISK_LOCATION_ID','=','risk_rep.RISKREP_LOCAL')

            ->leftjoin('risk_rep_program','risk_rep_program.RISK_REPPROGRAM_ID','=','risk_rep.RISK_REPPROGRAM_ID')
            ->leftjoin('risk_rep_program_sub','risk_rep_program_sub.RISK_REPPROGRAMSUB_ID','=','risk_rep.RISK_REPPROGRAMSUB_ID')
            ->leftjoin('risk_rep_program_subsub','risk_rep_program_subsub.RISK_REPPROGRAMSUBSUB_ID','=','risk_rep.RISK_REPPROGRAMSUBSUB_ID')

            ->leftjoin('risk_rep_typereason','risk_rep_typereason.RISK_REPTYPERESON_ID','=','risk_rep.RISK_REPTYPERESON_ID')
            ->leftjoin('risk_rep_typereason_sys','risk_rep_typereason_sys.RISK_REPTYPERESONSYS_ID','=','risk_rep.RISK_REPTYPERESONSYS_ID')

            ->leftjoin('risk_setupincidence_usereffect','risk_setupincidence_usereffect.INCEDENCE_USEREFFECT_ID','=','risk_rep.RISK_REP_EFFECT')
            ->leftjoin('risk_rep_items_sub','risk_rep_items_sub.RISK_REPITEMSSUB_ID','=','risk_rep.RISK_REPITEMSSUB_ID')
            ->leftjoin('risk_rep_typedep','risk_rep_typedep.RISKREP_TYPEDEPART_ID','=','risk_rep.RISKREP_TYPEDEP')
        ->first();
        $riskprogram  = DB::table('risk_rep_program')->get();
        $riskprogramsub  = DB::table('risk_rep_program_sub')->get();
        $riskprogramsubsub  = DB::table('risk_rep_program_subsub')->get();
        $risktypereason  = DB::table('risk_rep_typereason')->get();
        $risktypereasonsys  = DB::table('risk_rep_typereason_sys')->get();
        $item = DB::table('risk_rep_items')->get();
        $itemsub = DB::table('risk_rep_items_sub')->get();
        $infoteam = Team::orderBy('HR_TEAM_ID', 'asc')->get(); 
        $uefect = DB::table('risk_setupincidence_usereffect')->get();
        
        $departsub = DB::table('hrd_department_sub_sub')->get();
        $riskcategory = DB::table('risk_setincidence_category')->get();
        $location = DB::table('risk_setupincidence_location')->get();
        $level = DB::table('risk_setupincidence_level')->get();
        $setting = DB::table('risk_setincidence_setting')->get();
        $incidentsub = DB::table('risk_setupincidence_sub')->get();
        $origin = DB::table('risk_setupincidence_origin')->get();
        $sex = DB::table('hrd_sex')->get();
        $infoper = DB::table('hrd_person')->get();

        return view('manager_risk.detail_detail',[
            'departsubs'=>$departsub,
            'rigreps'=>$rigrep,
            'riskcategorys'=>$riskcategory,
            'locations'=>$location,
            'levels'=>$level,
            'settings'=>$setting,
            'incidentsubs'=>$incidentsub,
            'origins'=>$origin,
            'sexs'=>$sex,
            'infopers'=>$infoper,
        ]);
    }
    public function detail_search(Request $request)
    { 
        $search = $request->get('search');
        $status = $request->STATUS;
        $datebigin = $request->get('DATE_BIGIN');
        $dateend = $request->get('DATE_END');
        
    
        if($search==''){
            $search="";
        }
    
        $date_bigen_c = Carbon::createFromFormat('d/m/Y', $datebigin)->format('Y-m-d');
        $date_arrary=explode("-",$date_bigen_c);
    
        $y_sub_st = $date_arrary[0];
    
        if($y_sub_st >= 2500){
            $y = $y_sub_st-543;
        }else{
            $y = $y_sub_st;
        }
    
        $m = $date_arrary[1];
        $d = $date_arrary[2];  
        $displaydate_bigen= $y."-".$m."-".$d;
    
        $date_end_c = Carbon::createFromFormat('d/m/Y', $dateend)->format('Y-m-d');
        $date_arrary_e=explode("-",$date_end_c); 
    
        $y_sub_e = $date_arrary_e[0];
    
        if($y_sub_e >= 2500){
            $y_e = $y_sub_e-543;
        }else{
            $y_e = $y_sub_e;
        }
    
        $m_e = $date_arrary_e[1];
        $d_e = $date_arrary_e[2];  
        $displaydate_end= $y_e."-".$m_e."-".$d_e;
    
        $date = date('Y-m-d');
        $date_bigen_checks = strtotime($displaydate_bigen);
        $date_end_checks =  strtotime($displaydate_end);
        $dates =  strtotime($date);
    
        $from = date($displaydate_bigen);
        $to = date($displaydate_end);


           
        if($status !== null){

            $rigrep =Riskrep::leftjoin('risk_setincidence_setting','risk_rep.RISKREP_TITLE','=','risk_setincidence_setting.INCIDENCE_SETTING_ID') 
            ->leftJoin('risk_rep_level','risk_rep.RISKREP_LEVEL','=','risk_rep_level.RISK_REP_LEVEL_ID')    
            ->leftJoin('risk_rep_items','risk_rep.RISK_REPITEMS_ID','=','risk_rep_items.RISK_REPITEMS_ID')  
            ->leftjoin('risk_status','risk_rep.RISKREP_STATUS','=','risk_status.RISK_STATUS_NAME')
            ->leftjoin('risk_setupincidence_location','risk_rep.RISKREP_SEARCHLOCATE','=','risk_setupincidence_location.INCIDENCE_LOCATION_ID')
            ->leftjoin('hrd_department_sub_sub','risk_rep.RISKREP_DEPARTMENT_SUB','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
            ->leftjoin('hrd_department_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
            ->leftjoin('hrd_department','hrd_department_sub.HR_DEPARTMENT_ID','=','hrd_department.HR_DEPARTMENT_ID')
            ->leftjoin('hrd_team','hrd_team.HR_TEAM_NAME','=','risk_rep.RISKREP_TEAM_CODE')
            ->leftjoin('risk_rep_location','risk_rep_location.RISK_LOCATION_ID','=','risk_rep.RISKREP_LOCAL')
            ->where('risk_rep.RISKREP_STATUS','=',$status)
            ->where(function($q) use ($search){
                $q->where('RISKREP_NO','like','%'.$search.'%');
                $q->orwhere('RISK_REP_LEVEL_NAME','like','%'.$search.'%');
                $q->orwhere('RISK_REPITEMS_CODE','like','%'.$search.'%');
                $q->orwhere('RISKREP_TYPEDEP_NAME','like','%'.$search.'%');
                $q->orwhere('RISKREP_TYPESUB_NAME','like','%'.$search.'%');                                
                $q->orwhere('RISKREP_TYPESUBSUB_NAME','like','%'.$search.'%');
                $q->orwhere('HR_TEAM_NAME','like','%'.$search.'%');
                $q->orwhere('HR_TEAM_DETAIL','like','%'.$search.'%');
                $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');
            })
            ->WhereBetween('RISKREP_STARTDATE',[$from,$to]) 
            ->orderBy('RISKREP_ID', 'desc')->get();    

        }else{

       
            $rigrep =Riskrep::leftjoin('risk_setincidence_setting','risk_rep.RISKREP_TITLE','=','risk_setincidence_setting.INCIDENCE_SETTING_ID') 
            ->leftJoin('risk_rep_level','risk_rep.RISKREP_LEVEL','=','risk_rep_level.RISK_REP_LEVEL_ID')    
            ->leftJoin('risk_rep_items','risk_rep.RISK_REPITEMS_ID','=','risk_rep_items.RISK_REPITEMS_ID')  
            ->leftjoin('risk_status','risk_rep.RISKREP_STATUS','=','risk_status.RISK_STATUS_NAME')
            ->leftjoin('risk_setupincidence_location','risk_rep.RISKREP_SEARCHLOCATE','=','risk_setupincidence_location.INCIDENCE_LOCATION_ID')
            ->leftjoin('hrd_department_sub_sub','risk_rep.RISKREP_DEPARTMENT_SUB','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
            ->leftjoin('hrd_department_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
            ->leftjoin('hrd_department','hrd_department_sub.HR_DEPARTMENT_ID','=','hrd_department.HR_DEPARTMENT_ID')
            ->leftjoin('hrd_team','hrd_team.HR_TEAM_NAME','=','risk_rep.RISKREP_TEAM_CODE')
            ->leftjoin('risk_rep_location','risk_rep_location.RISK_LOCATION_ID','=','risk_rep.RISKREP_LOCAL')
            ->where(function($q) use ($search){
                $q->where('RISKREP_NO','like','%'.$search.'%');
                $q->orwhere('RISK_REP_LEVEL_NAME','like','%'.$search.'%');
                $q->orwhere('RISK_REPITEMS_CODE','like','%'.$search.'%');
                $q->orwhere('RISKREP_TYPEDEP_NAME','like','%'.$search.'%');
                $q->orwhere('RISKREP_TYPESUB_NAME','like','%'.$search.'%');                                
                $q->orwhere('RISKREP_TYPESUBSUB_NAME','like','%'.$search.'%');
                $q->orwhere('HR_TEAM_NAME','like','%'.$search.'%');
                $q->orwhere('HR_TEAM_DETAIL','like','%'.$search.'%');
                $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');
            })
            ->WhereBetween('RISKREP_STARTDATE',[$from,$to]) 
            ->orderBy('RISKREP_ID', 'desc')->get();    
        }
           
            $m_budget = date("m");
            if($m_budget>9){
            $yearbudget = date("Y")+544;
            }else{
            $yearbudget = date("Y")+543;        }
    
            $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
    
            $displaydate_bigen = ($yearbudget-544).'-10-01';
            $displaydate_end = ($yearbudget-543).'-09-30';
          
            $year_id = $yearbudget;
                   

            $status_info = DB::table('risk_status')->get();

        return view('manager_risk.riskdetail',[           
            'rigreps'=>$rigrep,
            'status_check'=> $status,
            'search'=> $search,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,  
            'budgets' =>  $budget,
            'year_id'=>$year_id,  
            'statuss'=>$status_info, 
        ]);
    }

    //-------------------------------------ฟังชันรันเลขอ้างอิง--------------------
    
    public static function refnumberRisk()
    {   
            $m_budget = date("m");
            if($m_budget>9){
            $yearbudget = date("Y")+544;
            }else{
            $yearbudget = date("Y")+543;
            }
        $maxnumber = DB::table('risk_rep')->where('BUDGET_YEAR','=',$yearbudget)->max('RISKREP_ID');  

        if($maxnumber != '' ||  $maxnumber != null){
            
            $refmax = DB::table('risk_rep')->where('RISKREP_ID','=',$maxnumber)->first();  
            if($refmax->RISKREP_ID != '' ||  $refmax->RISKREP_ID != null){
                $maxref = substr($refmax->RISKREP_ID, -4)+1;
            }else{
                $maxref = 1;
            }
            $ref = str_pad($maxref, 4, "0", STR_PAD_LEFT);
        
        }else{
            $ref = '0001';
        }  
        $y = substr($yearbudget, -2);
        $refnumber ='R'.$y.'-'.$ref;
        return $refnumber;
    }

    public function detail_add()
    {    
        $infoper = DB::table('hrd_person')->first();
   
        $riskcategory = DB::table('risk_setincidence_category')->get();
        $location = DB::table('risk_setupincidence_location')->get();
        $level = DB::table('risk_setupincidence_level')->get();
        $setting = DB::table('risk_setincidence_setting')->get();
        $incidentsub = DB::table('risk_setupincidence_sub')->get();
        $typelocation = DB::table('risk_setupincidence_tpyelocation')->get();
        $sex = DB::table('hrd_sex')->get();
        $grouplocation = DB::table('risk_setup_origindepart')->get();
        $worktime = DB::table('risk_workingtime')->get();
        
        $iduser = Auth::user()->PERSON_ID;

        $inforpersonuser=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_sex','hrd_person.SEX','=','hrd_sex.SEX_ID')
        ->leftJoin('hrd_status','hrd_person.HR_STATUS_ID','=','hrd_status.HR_STATUS_ID')
        ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
        ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->leftJoin('hrd_department','hrd_person.HR_DEPARTMENT_ID','=','hrd_department.HR_DEPARTMENT_ID')
        ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')      
        ->where('hrd_person.ID','=',$iduser)->first();

        $departsub = DB::table('hrd_department_sub_sub')
        ->where('HR_DEPARTMENT_SUB_SUB_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)
        ->get();

        $leader =  DB::table('gleave_leader_person')
        ->leftJoin('gleave_leader','gleave_leader.LEADER_ID','=','gleave_leader_person.LEADER_ID')
        ->where('PERSON_ID','=',$inforpersonuser->ID)
        ->get();

        return view('manager_risk.detail_add',[
            'departsubs'=>$departsub,
            'riskcategorys'=>$riskcategory,
            'locations'=>$location,
            'levels'=>$level,
            'settings'=>$setting,
            'incidentsubs'=>$incidentsub,
            'typelocations'=>$typelocation,
            'sexs'=>$sex,
            'infopers'=>$infoper,
            'grouplocations'=>$grouplocation,
            'worktimes'=>$worktime,
            'leaders'=>$leader,
        ]);
    }
    public function detail_save(Request $request)
    {    
        $savedate= $request->RISKREP_DATESAVE;
        if($savedate != ''){           
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $savedate)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0];             
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $save_date= $y_st."-".$m_st."-".$d_st;   
            }else{
            $save_date= null;
        }
        $repstart= $request->RISKREP_STARTDATE;
        if($repstart != ''){           
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $repstart)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0];             
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $start_date= $y_st."-".$m_st."-".$d_st;   
            }else{
            $start_date= null;
        }
        $checkdigget= $request->RISKREP_DIGDATE;
        if($checkdigget != ''){           
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $checkdigget)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0];             
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $dig_date= $y_st."-".$m_st."-".$d_st;   
            }else{
            $dig_date= null;
        }


        $iduser = Auth::user()->PERSON_ID;

        $inforpersonuser=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_sex','hrd_person.SEX','=','hrd_sex.SEX_ID')
        ->leftJoin('hrd_status','hrd_person.HR_STATUS_ID','=','hrd_status.HR_STATUS_ID')
        ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
        ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->leftJoin('hrd_department','hrd_person.HR_DEPARTMENT_ID','=','hrd_department.HR_DEPARTMENT_ID')
        ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')      
       ->where('hrd_person.ID','=',$iduser)->first();

        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;
        }
        //===============สร้างเลขR isk ==================//
        $maxnumber = DB::table('risk_rep')->where('BUDGET_YEAR','=',$yearbudget)->max('RISKREP_ID');     
        if($maxnumber != '' ||  $maxnumber != null){        
            $refmax = DB::table('risk_rep')->where('RISKREP_ID','=',$maxnumber)->first();  
            if($refmax->RISKREP_ID != '' ||  $refmax->RISKREP_ID != null){
                $maxref = substr($refmax->RISKREP_ID, -4)+1;
            }else{
                $maxref = 1;
            }
            $ref = str_pad($maxref, 4, "0", STR_PAD_LEFT);        
        }else{
            $ref = '0001';
        }       
        $y = substr($yearbudget, -2); 
        $refnumber ='Risk-'.$y.''.$ref;

        $idleader = $request->LEADER_PERSON_ID;
        $inforpersonleader =  Person::where('ID','=',$idleader)->first();

        // dd($iduser);
        $add = new Riskrep();
        $add->RISKREP_NO =  $request->RISKREP_NO;
        $add->RISKREP_DATESAVE =  $save_date;
        $add->RISKREP_SEARCHLOCATE =  $request->RISKREP_SEARCHLOCATE;
        $add->RISKREP_DEPARTMENT_SUB = $request->RISKREP_DEPARTMENT_SUB;  
        $add->RISKREP_TYPE =  $request->RISKREP_TYPE;
        $add->RISKREP_DETAILRISK =  $request->RISKREP_DETAILRISK; 
        $add->RISKREP_BASICMANAGE =  $request->RISKREP_BASICMANAGE;
        $add->RISKREP_STATUS = 'REPORT'; 
        $add->BUDGET_YEAR = $yearbudget;
        $add->RISKREP_USEREFFECT =  $inforpersonuser->ID;
        $add->RISKREP_USEREFFECT_FULLNAME =  $inforpersonuser->HR_FNAME. '  ' .$inforpersonuser->HR_LNAME;
        $add->LEADER_PERSON_ID =  $inforpersonleader->ID;
        $add->LEADER_PERSON_NAME =  $inforpersonleader->HR_FNAME. '  ' .$inforpersonleader->HR_LNAME;

        $maxid = Riskrep::max('RISKREP_ID');
        $idfile = $maxid+1;

        if($request->hasFile('RISKREP_DOCFILE')){
            
            $newFileName = 'riskrep_'.$idfile.'.'.$request->RISKREP_DOCFILE->extension();
              
            $request->RISKREP_DOCFILE->storeAs('riskrep',$newFileName,'public');

            $add->RISKREP_DOCFILE = $newFileName;
        }        
      
        if($request->hasFile('RISK_REP_IMG')){
            $file = $request->file('RISK_REP_IMG');
            $contents = $file->openFile()->fread($file->getSize());
            $add->RISK_REP_IMG = $contents;
        }
       
       $add->save();

       function DateThailinerisk($strDate)
       {
         $strYear = date("Y",strtotime($strDate))+543;
         $strMonth= date("n",strtotime($strDate));
         $strDay= date("j",strtotime($strDate));
 
         $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
         $strMonthThai=$strMonthCut[$strMonth];
         return "$strDay $strMonthThai $strYear";
         }

       $header = "รายงานความเสี่ยง";
       $LRISKREP_DATESAVE = DateThailinerisk($save_date);  // วันที่
       $LRISKREP_DEPARTMENT_SUB = $request->RISKREP_DEPARTMENT_SUB; // หน่วยงาน
       $LSEARCHLOCATE = $request->RISKREP_SEARCHLOCATE; //แหล่งที่มา  
       $LRISKREP_TYPE = $request->RISKREP_TYPE; //สถานที่ 
       $LRISKREP_DETAILRISK = $request->RISKREP_DETAILRISK; //รายละเอียด 
       $LRISKREP_BASICMANAGE = $request->RISKREP_BASICMANAGE; //การจัดการเบื้องต้น 
       $LRISKREP_STATUS = 'REPORT'; //สถานะ รายงาน 

       if($request->RISKREP_ID != ''){
          $RISKREP_ID = $request->RISKREP_ID;
          }        
                   
          $departmentsubsub = DB::table('hrd_department_sub_sub')->where('HR_DEPARTMENT_SUB_SUB_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)->first();   
          $HR_DEPARTMENT_SUB_SUB_NAME = $departmentsubsub->HR_DEPARTMENT_SUB_SUB_NAME;

          $searlocate = DB::table('risk_setupincidence_location')->where('INCIDENCE_LOCATION_ID','=',$request->RISKREP_SEARCHLOCATE)->first();
          $slocate = $searlocate->INCIDENCE_LOCATION_NAME;

          $reptype = DB::table('risk_setupincidence_tpyelocation')->where('SETUP_TYPELOCATION_ID','=',$request->RISKREP_TYPE)->first();
          $riskreptype = $reptype->SETUP_TYPELOCATION_NAME;

       $message = $header.
           "\n"."วันที่ : " . $LRISKREP_DATESAVE .
           "\n"."หน่วยงาน : " . $HR_DEPARTMENT_SUB_SUB_NAME .
           "\n"."แหล่งที่มา : " . $slocate .
           "\n"."สถานที่ : " . $riskreptype .
           "\n"."รายละเอียด : " . $LRISKREP_DETAILRISK .
           "\n"."การจัดการเบื้องต้น : " . $LRISKREP_BASICMANAGE .  
           "\n"."สถานะ : " . $LRISKREP_STATUS ;
                       
                   $name = DB::table('line_token')->where('ID_LINE_TOKEN','=',10)->first();        
                   $sending =$name->LINE_TOKEN;
       
                   $chOne = curl_init();
                   curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
                   curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0);
                   curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0);
                   curl_setopt( $chOne, CURLOPT_POST, 1);
                   curl_setopt( $chOne, CURLOPT_POSTFIELDS, $message);
                   curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=$message");
                   curl_setopt( $chOne, CURLOPT_FOLLOWLOCATION, 1);
                   $headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$sending.'', );
                   curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
                   curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1);
                   $result = curl_exec( $chOne );
                   if(curl_error($chOne)) { echo 'error:' . curl_error($chOne); }
                   else { $result_ = json_decode($result, true);
                   echo "status : ".$result_['status']; echo "message : ". $result_['message']; }
                   curl_close( $chOne );

          //แจ้งเตือนกลุ่มหน่วยงาน
          $name_request = DB::table('hrd_department_sub_sub')->where('HR_DEPARTMENT_SUB_SUB_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)->first();        
          $subsending =$name_request->LINE_TOKEN;

          $chOne3 = curl_init();
           curl_setopt( $chOne3, CURLOPT_URL, "https://notify-api.line.me/api/notify");
           curl_setopt( $chOne3, CURLOPT_SSL_VERIFYHOST, 0);
           curl_setopt( $chOne3, CURLOPT_SSL_VERIFYPEER, 0);
           curl_setopt( $chOne3, CURLOPT_POST, 1);
           curl_setopt( $chOne3, CURLOPT_POSTFIELDS, $message);
           curl_setopt( $chOne3, CURLOPT_POSTFIELDS, "message=$message");
           curl_setopt( $chOne3, CURLOPT_FOLLOWLOCATION, 1);
           $headers3 = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$subsending.'', );
           curl_setopt($chOne3, CURLOPT_HTTPHEADER, $headers3);
           curl_setopt( $chOne3, CURLOPT_RETURNTRANSFER, 1);
           $result3 = curl_exec( $chOne3 );
           if(curl_error($chOne3)) { echo 'error:' . curl_error($chOne3); }
           else { $result_ = json_decode($result3, true);
           echo "status : ".$result_['status']; echo "message : ". $result_['message']; }
           curl_close( $chOne3 );

        return redirect()->route('mrisk.detail');
    }

    public function detail_edit(Request $request,$id)
    {    
       
        $rigrep = Riskrep::leftjoin('risk_status','risk_status.RISK_STATUS_NAME','=','risk_rep.RISKREP_STATUS')
        ->leftjoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','risk_rep.RISKREP_DEPARTMENT_SUB')
        ->leftjoin('risk_setupincidence_tpyelocation','risk_setupincidence_tpyelocation.SETUP_TYPELOCATION_ID','=','risk_rep.RISKREP_TYPE')
        ->leftjoin('risk_setupincidence_grouplocation','risk_setupincidence_grouplocation.SETUP_GROUPLOCATION_ID','=','risk_rep.RISKREP_LOCAL')
        ->leftjoin('risk_setincidence_setting','risk_setincidence_setting.INCIDENCE_SETTING_ID','=','risk_rep.RISKREP_TITLE')
        ->leftjoin('risk_setupincidence_sub','risk_setupincidence_sub.INCIDENCE_SUB_ID','=','risk_rep.RISKREP_SUBTITLE')
        ->leftjoin('hrd_sex','hrd_sex.SEX_ID','=','risk_rep.RISKREP_SEX')
        ->leftjoin('risk_setupincidence_location','risk_setupincidence_location.INCIDENCE_LOCATION_ID','=','risk_rep.RISKREP_SEARCHLOCATE')
        ->where('risk_rep.RISKREP_ID','=',$id)->first();

       
            $origin = DB::table('risk_setupincidence_origin')->get(); 
            $typelocationf = DB::table('risk_setupincidence_tpyelocation')->first();
            $grouplocation = DB::table('risk_rep_location')->where('SETUP_TYPELOCATION_ID','=',$typelocationf->SETUP_TYPELOCATION_ID)->get();

            $worktime = DB::table('risk_rep_time')->get();
            $typelocation = DB::table('risk_setupincidence_tpyelocation')->get();
            $infoper = DB::table('hrd_person')->get();
            $uefect = DB::table('risk_setupincidence_usereffect')->get();
      
            $riskcategory = DB::table('risk_setincidence_category')->get();
            $location = DB::table('risk_setupincidence_location')->get();
            $level = DB::table('risk_rep_level')->get();
            $setting = DB::table('risk_setincidence_setting')->get(); 
            $incidentsub = DB::table('risk_setupincidence_sub')->get();
            $riskitem = Risk_rep_items::get();
            $sex = DB::table('hrd_sex')->get();
            $effect = DB::table('risk_setupincidence_usereffect')->get();
            $departmentsub  =  DB::table('hrd_department')->get();
            $riskprogram  = DB::table('risk_rep_program')->get();
            $riskprogramsub  = DB::table('risk_rep_program_sub')->get();
            $riskprogramsubsub  = DB::table('risk_rep_program_subsub')->get();
            $risktypereason  = DB::table('risk_rep_typereason')->get();
            $risktypereasonsys  = DB::table('risk_rep_typereason_sys')->get();
            $item = DB::table('risk_rep_items')->get();
            $itemsub = DB::table('risk_rep_items_sub')->get();
            $infoteam = Team::orderBy('HR_TEAM_ID', 'asc')->get();  

            $departsub = DB::table('hrd_department_sub_sub')->where('HR_DEPARTMENT_SUB_SUB_ID','=',$rigrep->RISKREP_DEPARTMENT_SUB)->get();
            //--------------------------  ฝ่าย/แผนก ------------------
            $infordepartmentsub  =  DB::table('hrd_department_sub')->get();           

                //-----------------   หน่วยงาน --------------------------
              $infordepartmentsubsub  =  DB::table('hrd_department_sub_sub')->get();

              $inforiskacc = DB::table('risk_account_detail')->get();

              $locationuse = DB::table('risk_setupincidence_origin')->get();

              $infolocation = DB::table('supplies_location')->get();
              $infolocationlevel = DB::table('supplies_location_level')->get();
              $infolocationlevelroom = DB::table('supplies_location_level_room')->get();

        return view('manager_risk.detail_edit',[
            'inforiskaccs'=>$inforiskacc,
            'departsubs'=>$departsub,
            'rigreps'=>$rigrep,
            'riskcategorys'=>$riskcategory,
            'locations'=>$location,
            'levels'=>$level,
            'settings'=>$setting,
            'incidentsubs'=>$incidentsub,
            'origins'=>$origin,
            'sexs'=>$sex,
            'infopers'=>$infoper,
            'grouplocations'=>$grouplocation,
            'worktimes'=>$worktime,
            'typelocations'=>$typelocation,
            'departmentsubs'=>$departmentsub,
            'infordepartmentsubs'=>$infordepartmentsub,
            'infordepartmentsubsubs'=>$infordepartmentsubsub,
            'riskprograms'=>$riskprogram,
            'riskprogramsubs'=>$riskprogramsub,
            'riskprogramsubsubs'=>$riskprogramsubsub,
            'risktypereasons'=>$risktypereason,
            'risktypereasonsyss'=>$risktypereasonsys,
            'uefects'=>$uefect,
            'infoteams'=>$infoteam,
            'items'=>$item,
            'riskitems'=>$riskitem,
            'itemsubs'=>$itemsub,
            'locationuses'=>$locationuse,
            'infolocations' => $infolocation,
            'infolocationlevels' => $infolocationlevel,
            'infolocationlevelrooms' => $infolocationlevelroom, 
        ]);
    }

    public function detail_update(Request $request)
    {   
      
        $savedate= $request->RISKREP_DATESAVE;
        if($savedate != ''){           
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $savedate)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0];             
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $save_date= $y_st."-".$m_st."-".$d_st;   
            }else{
            $save_date= null;
        }
        $repstart= $request->RISKREP_STARTDATE;
        if($repstart != ''){           
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $repstart)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0];             
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $start_date= $y_st."-".$m_st."-".$d_st;   
            }else{
            $start_date= null;
        }
        $checkdigget= $request->RISKREP_DIGDATE;
        if($checkdigget != ''){           
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $checkdigget)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0];             
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $dig_date= $y_st."-".$m_st."-".$d_st;   
            }else{
            $dig_date= null;
        }
        $date_notify= $request->RISKREP_DATENOTIFY;
        if($date_notify != ''){           
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $date_notify)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0];             
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $datenotify= $y_st."-".$m_st."-".$d_st;   
            }else{
            $datenotify= null;
        }

        $date_confirm= $request->RISKREP_DATECONFIRM;
        if($date_confirm != ''){           
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $date_confirm)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0];             
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $dateconfirm= $y_st."-".$m_st."-".$d_st;   
            }else{
            $dateconfirm= null;
        }


    // ความเห็นหัวหน้าหน่วยงาน     
        $id = $request->RISKREP_ID;
        $update =Riskrep::find($id);    
        $update->RISKREP_NO =  $request->RISKREP_NO;        
        $update->RISKREP_DATESAVE =  $save_date;
        $update->RISKREP_SEARCHLOCATE =  $request->RISKREP_SEARCHLOCATE;
        $update->RISKREP_DEPARTMENT_SUB = $request->RISKREP_DEPARTMENT_SUB;
        $update->RISKREP_TYPE =  $request->RISKREP_TYPE;   
        $update->RISKREP_USEREFFECT =  $request->RISKREP_USEREFFECT;      
        $update->RISKREP_DETAILRISK =  $request->RISKREP_DETAILRISK; 
        $update->RISKREP_BASICMANAGE =  $request->RISKREP_BASICMANAGE;

    // ความเห็นหัวหน้าหน่วยงาน     
        $update->RISKREP_STARTDATE =  $start_date; 
        $update->RISKREP_DIGDATE =  $dig_date; 
        $update->RISKREP_LOCAL =  $request->RISKREP_LOCAL;
        $update->RISK_REPPROGRAM_ID =  $request->RISK_REPPROGRAM_ID; 
        $update->RISK_REPPROGRAMSUB_ID =  $request->RISK_REPPROGRAMSUB_ID; 
        $update->RISK_REPPROGRAMSUBSUB_ID =  $request->RISK_REPPROGRAMSUBSUB_ID;   
        $update->RISK_REPTYPERESON_ID =  $request->RISK_REPTYPERESON_ID;    
        $update->RISK_REPTYPERESONSYS_ID =  $request->RISK_REPTYPERESONSYS_ID;  
        $update->RISKREP_FATE =  $request->RISKREP_FATE; 
        $update->RISKREP_TIME =  $request->RISKREP_TIME; 
        $update->RISKREP_LEVEL =  $request->RISKREP_LEVEL; 
        $update->RISK_REP_FEEDBACK =  $request->RISK_REP_FEEDBACK;
        $update->RISK_REP_EFFECT =  $request->RISK_REP_EFFECT;
        $update->RISKREP_SEX =  $request->RISKREP_SEX; 
        $update->RISKREP_AGE =  $request->RISKREP_AGE;
        $update->RISKREP_ACC_ID =  $request->RISKREP_ACC_ID; 
        $update->RISKREP_LOCALUSE =  $request->RISKREP_LOCALUSE; 

        $update->RISKREP_LOCATION_ID =  $request->RISKREP_LOCATION_ID; 
        $update->RISKREP_LOCATION_LEVEL =  $request->RISKREP_LOCATION_LEVEL; 
        $update->RISKREP_LOCATION_LEVEL_ROOM =  $request->RISKREP_LOCATION_LEVEL_ROOM;
        $update->RISKREP_LOCATION_OTHER =  $request->RISKREP_LOCATION_OTHER;
        
    // กรรมการบริหารความเสี่ยง
        $update->RISKREP_STATUS = 'REPORT';              
        $update->save();        
        return redirect()->route('mrisk.detail');
    }
    public function detail_check(Request $request,$id)
    {           
        $rigrep = Riskrep::leftjoin('risk_status','risk_status.RISK_STATUS_NAME','=','risk_rep.RISKREP_STATUS')
          ->leftjoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','risk_rep.RISKREP_DEPARTMENT_SUB')
          ->leftjoin('hrd_team','hrd_team.HR_TEAM_NAME','=','risk_rep.RISKREP_TEAM_CODE')
          ->leftjoin('risk_setupincidence_tpyelocation','risk_setupincidence_tpyelocation.SETUP_TYPELOCATION_ID','=','risk_rep.RISKREP_TYPE')
          ->leftjoin('risk_setupincidence_grouplocation','risk_setupincidence_grouplocation.SETUP_GROUPLOCATION_ID','=','risk_rep.RISKREP_LOCAL')
          ->leftjoin('risk_setincidence_setting','risk_setincidence_setting.INCIDENCE_SETTING_ID','=','risk_rep.RISKREP_TITLE')
          ->leftjoin('risk_setupincidence_sub','risk_setupincidence_sub.INCIDENCE_SUB_ID','=','risk_rep.RISKREP_SUBTITLE')
          ->leftjoin('hrd_sex','hrd_sex.SEX_ID','=','risk_rep.RISKREP_SEX')
          ->leftjoin('risk_setupincidence_location','risk_setupincidence_location.INCIDENCE_LOCATION_ID','=','risk_rep.RISKREP_SEARCHLOCATE')
          ->where('risk_rep.RISKREP_ID','=',$id)->first();

        $ueffect = DB::table('risk_rep_usereffect')->where('RISKREP_ID','=',$id)->get(); 
        $teamlist = Risk_rep_teamlist::where('RISKREP_ID','=',$id)->get(); 
        $rep_dep = Risk_rep_department::where('RISKREP_ID','=',$id)->get();
        $rep_dep_sub = Risk_rep_department_sub::where('RISKREP_ID','=',$id)->get();
        $rep_dep_subsub = Risk_rep_department_subsub::where('RISKREP_ID','=',$id)->get();
        $rep_infoper = Risk_rep_infoperson::where('RISKREP_ID','=',$id)->get();



            $origin = DB::table('risk_setupincidence_origin')->get(); 
            $typelocationf = DB::table('risk_setupincidence_tpyelocation')->first();
            $grouplocation = DB::table('risk_rep_location')->where('SETUP_TYPELOCATION_ID','=',$typelocationf->SETUP_TYPELOCATION_ID)->get();
            $worktime = DB::table('risk_rep_time')->get();
            $typelocation = DB::table('risk_setupincidence_tpyelocation')->get();
            $infoper = DB::table('hrd_person')->get();
            $uefect = DB::table('risk_setupincidence_usereffect')->get();
           
            $riskcategory = DB::table('risk_setincidence_category')->get();
            $location = DB::table('risk_setupincidence_location')->get();
            $level = DB::table('risk_rep_level')->get();
            $setting = DB::table('risk_setincidence_setting')->get(); 
            $incidentsub = DB::table('risk_setupincidence_sub')->get();
            $riskitem = Risk_rep_items::get();
            $sex = DB::table('hrd_sex')->get();
            $effect = DB::table('risk_setupincidence_usereffect')->get();
            
            $riskprogram  = DB::table('risk_rep_program')->get();
            $riskprogramsub  = DB::table('risk_rep_program_sub')->get();
            $riskprogramsubsub  = DB::table('risk_rep_program_subsub')->get();
            $risktypereason  = DB::table('risk_rep_typereason')->get();
            $risktypereasonsys  = DB::table('risk_rep_typereason_sys')->get();
            $item = DB::table('risk_rep_items')->get();
            $itemsub = DB::table('risk_rep_items_sub')->get();
            $infoteam = Team::orderBy('HR_TEAM_ID', 'asc')->get();


            $team =  DB::table('hrd_team')->get(); 
            $riskrepdep = DB::table('risk_rep_typedep')->get(); 
            $department  =  DB::table('hrd_department')->get();
            //--------------------------  ฝ่าย/แผนก ------------------
            $infordepartmentsub  =  DB::table('hrd_department_sub')->get();  
            //-----------------   หน่วยงาน --------------------------
            $departsub = DB::table('hrd_department_sub_sub')->get();
            $infordepartmentsubsub  =  DB::table('hrd_department_sub_sub')->get();

            $inforiskacc = DB::table('risk_account_detail')->get();

            $infoperson = DB::table('hrd_person')
            ->where('HR_STATUS_ID','=','1')
            ->get();

            $locationuse = DB::table('risk_setupincidence_origin')->get();

            
            $infolocation = DB::table('supplies_location')->get();
            $infolocationlevel = DB::table('supplies_location_level')->get();
            $infolocationlevelroom = DB::table('supplies_location_level_room')->get();

            $inforecheck = DB::table('risk_recheck')
            ->leftJoin('hrd_person','hrd_person.ID','=','risk_recheck.RISK_RECHECK_PERSON')
            ->where('RISK_RECHECK_RISKID','=',$id)->get();
        


        return view('manager_risk.detail_check',[
            'inforechecks'=>$inforecheck,
            'inforiskaccs'=>$inforiskacc,
            'departsubs'=>$departsub,
            'rigreps'=>$rigrep,
            'riskcategorys'=>$riskcategory,
            'locations'=>$location,
            'levels'=>$level,
            'settings'=>$setting,
            'incidentsubs'=>$incidentsub,
            'origins'=>$origin,
            'sexs'=>$sex,
            'infopers'=>$infoper,
            'grouplocations'=>$grouplocation,
            'worktimes'=>$worktime,
            'typelocations'=>$typelocation,
            'departments'=>$department,
            'infordepartmentsubs'=>$infordepartmentsub,
            'infordepartmentsubsubs'=>$infordepartmentsubsub,
            'riskprograms'=>$riskprogram,
            'riskprogramsubs'=>$riskprogramsub,
            'riskprogramsubsubs'=>$riskprogramsubsub,
            'risktypereasons'=>$risktypereason,
            'risktypereasonsyss'=>$risktypereasonsys,
            'uefects'=>$uefect,
            'infoteams'=>$infoteam,
            'items'=>$item,
            'riskitems'=>$riskitem,
            'itemsubs'=>$itemsub,
            'riskrepdeps'=>$riskrepdep,
            'ueffects'=>$ueffect,
            'teams'=>$team,
            'teamlists'=>$teamlist,
            'rep_deps'=>$rep_dep,
            'rep_dep_subs'=>$rep_dep_sub,
            'rep_dep_subsubs'=>$rep_dep_subsub,
            'rep_infopers'=>$rep_infoper,
            'infopersons'=>$infoperson,
            'locationuses'=>$locationuse,
            'infolocations' => $infolocation,
            'infolocationlevels' => $infolocationlevel,
            'infolocationlevelrooms' => $infolocationlevelroom, 

        ]);
    }
    public function detail_checkupdate(Request $request)
    {    

        $savedate= $request->RISKREP_DATESAVE;
        if($savedate != ''){           
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $savedate)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0];             
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $save_date= $y_st."-".$m_st."-".$d_st;   
            }else{
            $save_date= null;
        }
        $repstart= $request->RISKREP_STARTDATE;
        if($repstart != ''){           
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $repstart)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0];             
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $start_date= $y_st."-".$m_st."-".$d_st;   
            }else{
            $start_date= null;
        }
        $checkdigget= $request->RISKREP_DIGDATE;
        if($checkdigget != ''){           
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $checkdigget)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0];             
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $dig_date= $y_st."-".$m_st."-".$d_st;   
            }else{
            $dig_date= null;
        }
        $date_notify= $request->RISKREP_DATENOTIFY;
        if($date_notify != ''){           
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $date_notify)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0];             
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $datenotify= $y_st."-".$m_st."-".$d_st;   
            }else{
            $datenotify= null;
        }

        $date_confirm= $request->RISKREP_DATECONFIRM;
        if($date_confirm != ''){           
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $date_confirm)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0];             
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $dateconfirm= $y_st."-".$m_st."-".$d_st;   
            }else{
            $dateconfirm= null;
        }
    //UPDATE
        $id = $request->RISKREP_ID;
        $update =Riskrep::find($id);    
        $update->RISKREP_NO =  $request->RISKREP_NO;        
        $update->RISKREP_DATESAVE =  $save_date;
        $update->RISKREP_SEARCHLOCATE =  $request->RISKREP_SEARCHLOCATE;
        $update->RISKREP_DEPARTMENT_SUB = $request->RISKREP_DEPARTMENT_SUB;
        $update->RISKREP_TYPE =  $request->RISKREP_TYPE;   
        $update->RISKREP_USEREFFECT =  $request->RISKREP_USEREFFECT;      
        $update->RISKREP_DETAILRISK =  $request->RISKREP_DETAILRISK; 
        $update->RISKREP_BASICMANAGE =  $request->RISKREP_BASICMANAGE;

    // ความเห็นหัวหน้าหน่วยงาน     
        $update->RISKREP_STARTDATE =  $start_date; 
        $update->RISKREP_DIGDATE =  $dig_date; 
        $update->RISKREP_LOCAL =  $request->RISKREP_LOCAL;
        $update->RISK_REPPROGRAM_ID =  $request->RISK_REPPROGRAM_ID; 
        $update->RISK_REPPROGRAMSUB_ID =  $request->RISK_REPPROGRAMSUB_ID; 
        $update->RISK_REPPROGRAMSUBSUB_ID =  $request->RISK_REPPROGRAMSUBSUB_ID;   
        $update->RISK_REPTYPERESON_ID =  $request->RISK_REPTYPERESON_ID;    
        $update->RISK_REPTYPERESONSYS_ID =  $request->RISK_REPTYPERESONSYS_ID;  
        $update->RISKREP_FATE =  $request->RISKREP_FATE; 
        $update->RISKREP_TIME =  $request->RISKREP_TIME; 
        $update->RISKREP_LEVEL =  $request->RISKREP_LEVEL; 
        $update->RISK_REP_FEEDBACK =  $request->RISK_REP_FEEDBACK;
        $update->RISK_REP_EFFECT =  $request->RISK_REP_EFFECT;
        $update->RISKREP_SEX =  $request->RISKREP_SEX; 
        $update->RISKREP_AGE =  $request->RISKREP_AGE;  
        $update->RISKREP_ACC_ID =  $request->RISKREP_ACC_ID; 
        $update->RISKREP_LOCALUSE =  $request->RISKREP_LOCALUSE; 

        $update->RISKREP_LOCATION_ID =  $request->RISKREP_LOCATION_ID; 
        $update->RISKREP_LOCATION_LEVEL =  $request->RISKREP_LOCATION_LEVEL; 
        $update->RISKREP_LOCATION_LEVEL_ROOM =  $request->RISKREP_LOCATION_LEVEL_ROOM;
        $update->RISKREP_LOCATION_OTHER =  $request->RISKREP_LOCATION_OTHER;

    // กรรมการบริหารความเสี่ยง
        $update->RISK_REPITEMS_ID =  $request->RISK_REPITEMS_ID; 
        $update->RISK_REPITEMSSUB_ID =  $request->RISK_REPITEMSSUB_ID; 
        $namesub = $request->RISKREP_TYPEDEP;
        $subid = $request->RISKREP_TYPESUB;

        if ($namesub == '1') {
            $update->RISKREP_TYPEDEP =  '1'; 

            $depid = DB::table('hrd_department')->where('HR_DEPARTMENT_ID','=',$subid)->first();
            $update->RISKREP_TYPEDEP_ID =  $depid->HR_DEPARTMENT_ID; 
            $update->RISKREP_TYPEDEP_NAME =  $depid->HR_DEPARTMENT_NAME; 

            $update->RISKREP_TYPESUB = '';
            $update->RISKREP_TYPESUB_NAME = '';
            $update->RISKREP_TYPESUBSUB_ID = '';
            $update->RISKREP_TYPESUBSUB_NAME = '';
            $update->RISKREP_TEAM_ID = '';
            $update->RISKREP_TEAM_CODE = '';

        } elseif($namesub == '2'){
            $update->RISKREP_TYPEDEP =  '2'; 
            
            $depsubid = DB::table('hrd_department_sub')->where('HR_DEPARTMENT_SUB_ID','=',$subid)->first();
            $update->RISKREP_TYPESUB =  $depsubid->HR_DEPARTMENT_SUB_ID; 
            $update->RISKREP_TYPESUB_NAME =  $depsubid->HR_DEPARTMENT_SUB_NAME; 

            $update->RISKREP_TYPEDEP_ID = '';
            $update->RISKREP_TYPEDEP_NAME = '';
            $update->RISKREP_TYPESUBSUB_ID = '';
            $update->RISKREP_TYPESUBSUB_NAME = '';
            $update->RISKREP_TEAM_ID = '';
            $update->RISKREP_TEAM_CODE = '';
            
        } elseif($namesub == '3'){
            $update->RISKREP_TYPEDEP =  '3'; 

            $depsubsubid = DB::table('hrd_department_sub_sub')->where('HR_DEPARTMENT_SUB_SUB_ID','=',$subid)->first();
            $update->RISKREP_TYPESUBSUB_ID =  $depsubsubid->HR_DEPARTMENT_SUB_SUB_ID; 
            $update->RISKREP_TYPESUBSUB_NAME =  $depsubsubid->HR_DEPARTMENT_SUB_SUB_NAME; 

            $update->RISKREP_TYPEDEP_ID = '';
            $update->RISKREP_TYPEDEP_NAME = '';
            $update->RISKREP_TYPESUB = '';
            $update->RISKREP_TYPESUB_NAME = '';
            $update->RISKREP_TEAM_ID = '';
            $update->RISKREP_TEAM_CODE = '';
       
        }elseif($namesub == '4'){
            $update->RISKREP_TYPEDEP =  '4'; 

            $teamid = DB::table('hrd_team')->where('HR_TEAM_NAME','=',$subid)->first();           
            $update->RISKREP_TEAM_ID =  $teamid->HR_TEAM_ID; 
            $update->RISKREP_TEAM_CODE =  $teamid->HR_TEAM_NAME; 

            $update->RISKREP_TYPEDEP_ID = '';
            $update->RISKREP_TYPEDEP_NAME = '';
            $update->RISKREP_TYPESUB = '';
            $update->RISKREP_TYPESUB_NAME = '';
            $update->RISKREP_TYPESUBSUB_ID = '';
            $update->RISKREP_TYPESUBSUB_NAME = '';
        }else{
        }
       
        $update->RISKREP_DATENOTIFY =  $datenotify;  
        $update->RISKREP_DATECONFIRM =  $dateconfirm; 
        $update->RISKREP_DETAILRISK2 =  $request->RISKREP_DETAILRISK2;   
        $update->RISKREP_STATUS = 'CONFIRM';              
        $update->save();  
     
    //ผู้ได้รับผลกระทบ
        Risk_rep_usereffect::where('RISKREP_ID','=',$id)->delete(); 

            if($request->RISK_REPEFFECT_FULLNAME != '' || $request->RISK_REPEFFECT_FULLNAME != null){
                
            $RISK_REPEFFECT_FULLNAME = $request->RISK_REPEFFECT_FULLNAME;
            $RISK_REPEFFECT_AGE = $request->RISK_REPEFFECT_AGE;
            $RISK_REPEFFECT_SEX = $request->RISK_REPEFFECT_SEX;
            $RISK_REPEFFECT_HN = $request->RISK_REPEFFECT_HN;
            $RISK_REPEFFECT_DATEIN = $request->RISK_REPEFFECT_DATEIN;         
            $RISK_REPEFFECT_AN = $request->RISK_REPEFFECT_AN; 
            $RISK_REPEFFECT_DATEADMIN = $request->RISK_REPEFFECT_DATEADMIN;             
                               
            $number =count($RISK_REPEFFECT_FULLNAME);
            $count = 0;           
            for($count = 0; $count< $number; $count++)
            {           
                if($RISK_REPEFFECT_DATEIN[$count] != ''){
                    $DAY = Carbon::createFromFormat('d/m/Y',$RISK_REPEFFECT_DATEIN[$count])->format('Y-m-d');
                    $date_arrary_st=explode("-",$DAY);
                    $y_sub_st = $date_arrary_st[0];
    
                    if($y_sub_st >= 2500){
                        $y_st = $y_sub_st-543;
                    }else{
                        $y_st = $y_sub_st;
                    }
                    $m_st = $date_arrary_st[1];
                    $d_st = $date_arrary_st[2];
                    $DATEIN= $y_st."-".$m_st."-".$d_st;
                    }else{
                    $DATEIN= null;
                } 
                if($RISK_REPEFFECT_DATEADMIN[$count] != ''){
                    $DAY = Carbon::createFromFormat('d/m/Y',$RISK_REPEFFECT_DATEADMIN[$count])->format('Y-m-d');
                    $date_arrary_st=explode("-",$DAY);
                    $y_sub_st = $date_arrary_st[0];
    
                    if($y_sub_st >= 2500){
                        $y_st = $y_sub_st-543;
                    }else{
                        $y_st = $y_sub_st;
                    }
                    $m_st = $date_arrary_st[1];
                    $d_st = $date_arrary_st[2];
                    $DATADMIT= $y_st."-".$m_st."-".$d_st;
                    }else{
                    $DATADMIT= null;
                } 
            $add_sub = new Risk_rep_usereffect();
            $add_sub->RISKREP_ID = $id;  
            $add_sub->RISK_REPEFFECT_FULLNAME = $RISK_REPEFFECT_FULLNAME[$count];     
            $add_sub->RISK_REPEFFECT_AGE = $RISK_REPEFFECT_AGE[$count]; 
            $add_sub->RISK_REPEFFECT_SEX = $RISK_REPEFFECT_SEX[$count]; 
            $add_sub->RISK_REPEFFECT_HN = $RISK_REPEFFECT_HN[$count];   
            $add_sub->RISK_REPEFFECT_DATEIN = $DATEIN; 
            $add_sub->RISK_REPEFFECT_AN = $RISK_REPEFFECT_AN[$count]; 
            $add_sub->RISK_REPEFFECT_DATEADMIN = $DATADMIT;                         
            $add_sub->save(); 
            }
        }  
    //ทีมนำ
        Risk_rep_teamlist::where('RISKREP_ID','=',$id)->delete();
        
            if($request->RISK_REP_TEAMLIST_NAME != '' || $request->RISK_REP_TEAMLIST_NAME != null){                
            $RISK_REP_TEAMLIST_NAME = $request->RISK_REP_TEAMLIST_NAME;                       
                               
            $number =count($RISK_REP_TEAMLIST_NAME);
            $count = 0;           
            for($count = 0; $count< $number; $count++)
            {     
                $idteam = DB::table('hrd_team')->where('HR_TEAM_ID','=',$RISK_REP_TEAMLIST_NAME[$count])->first(); 
                $add_sub = new Risk_rep_teamlist();
                $add_sub->RISKREP_ID = $id;  
                $add_sub->RISK_REP_TEAMLIST_CODE = $idteam->HR_TEAM_NAME; 
                $add_sub->RISK_REP_TEAMLIST_NAME = $idteam->HR_TEAM_DETAIL;  
                $add_sub->save(); 
            }
        }  
    //กลุ่มงาน
        Risk_rep_department::where('RISKREP_ID','=',$id)->delete(); 
            if($request->RISK_REP_DEPARTMENT_ID != '' || $request->RISK_REP_DEPARTMENT_ID != null){                
            $RISK_REP_DEPARTMENT_ID = $request->RISK_REP_DEPARTMENT_ID;                       
                            
            $number =count($RISK_REP_DEPARTMENT_ID);
            $count = 0;           
            for($count = 0; $count< $number; $count++)
            {     
                $iddep = DB::table('hrd_department')->where('HR_DEPARTMENT_ID','=',$RISK_REP_DEPARTMENT_ID[$count])->first(); 
                $add_sub = new Risk_rep_department();
                $add_sub->RISKREP_ID = $id; 
                $add_sub->HR_DEPARTMENT_ID = $iddep->HR_DEPARTMENT_ID;  
                $add_sub->RISK_REP_DEPARTMENT_NAME = $iddep->HR_DEPARTMENT_NAME;  
                $add_sub->save(); 
            }
        }
    //แผนก/ฝ่าย
        Risk_rep_department_sub::where('RISKREP_ID','=',$id)->delete(); 
                if($request->RISK_REP_DEPARTMENT_SUBID != '' || $request->RISK_REP_DEPARTMENT_SUBID != null){                
                $RISK_REP_DEPARTMENT_SUBID = $request->RISK_REP_DEPARTMENT_SUBID;                       
                                
                $number =count($RISK_REP_DEPARTMENT_SUBID);
                $count = 0;           
                for($count = 0; $count< $number; $count++)
                {     
                    $iddepsub = DB::table('hrd_department_sub')->where('HR_DEPARTMENT_SUB_ID','=',$RISK_REP_DEPARTMENT_SUBID[$count])->first(); 
                    $add_sub = new Risk_rep_department_sub();
                    $add_sub->RISKREP_ID = $id;  
                    $add_sub->HR_DEPARTMENT_SUB_ID = $iddepsub->HR_DEPARTMENT_SUB_ID; 
                    $add_sub->RISK_REP_DEPARTMENT_SUBNAME = $iddepsub->HR_DEPARTMENT_SUB_NAME;  
                    $add_sub->save(); 
                }
        }   
    //หน่วยงาน
        Risk_rep_department_subsub::where('RISKREP_ID','=',$id)->delete(); 
            if($request->RISK_REP_DEPARTMENT_SUBSUBID != '' || $request->RISK_REP_DEPARTMENT_SUBSUBID != null){                
            $RISK_REP_DEPARTMENT_SUBSUBID = $request->RISK_REP_DEPARTMENT_SUBSUBID;                       
                            
            $number =count($RISK_REP_DEPARTMENT_SUBSUBID);
            $count = 0;           
            for($count = 0; $count< $number; $count++)
            {     
                $iddepsubsub = DB::table('hrd_department_sub_sub')->where('HR_DEPARTMENT_SUB_SUB_ID','=',$RISK_REP_DEPARTMENT_SUBSUBID[$count])->first(); 
                $add_sub = new Risk_rep_department_subsub();
                $add_sub->RISKREP_ID = $id; 
                $add_sub->HR_DEPARTMENT_SUB_SUB_ID = $iddepsubsub->HR_DEPARTMENT_SUB_SUB_ID;  
                $add_sub->RISK_REP_DEPARTMENT_SUBSUBNAME = $iddepsubsub->HR_DEPARTMENT_SUB_SUB_NAME;  
                $add_sub->save(); 
            }
        }
    //บุคคล
        Risk_rep_infoperson::where('RISKREP_ID','=',$id)->delete(); 
            if($request->RISK_REP_PERSON_NAME != '' || $request->RISK_REP_PERSON_NAME != null){                
                $RISK_REP_PERSON_NAME = $request->RISK_REP_PERSON_NAME;                       
                                
                $number =count($RISK_REP_PERSON_NAME);
                $count = 0;           
                for($count = 0; $count< $number; $count++)
                {     
                    $add_sub = new Risk_rep_infoperson();
                    $add_sub->RISKREP_ID = $id;  
                    $add_sub->RISK_REP_PERSON_NAME = $request->RISK_REP_PERSON_NAME[$count];  
                    $add_sub->save(); 
                }
        }
        return redirect()->route('mrisk.detail');
    }

    public function detail_check_cancel(Request $request,$id)
    {   
        $rigrep = DB::table('risk_rep')->where('RISKREP_ID','=',$id)
            ->leftJoin('risk_rep_level','risk_rep.RISKREP_LEVEL','=','risk_rep_level.RISK_REP_LEVEL_ID')
            ->leftJoin('risk_setupincidence_location','risk_rep.RISKREP_SEARCHLOCATE','=','risk_setupincidence_location.INCIDENCE_LOCATION_ID')
            ->leftJoin('risk_setup_origindepart','risk_rep.RISKREP_LOCAL','=','risk_setup_origindepart.ORIGIN_DEPART_ID')
            ->leftJoin('hrd_department_sub_sub','risk_rep.RISKREP_DEPARTMENT_SUB','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
            ->leftJoin('risk_setupincidence_tpyelocation','risk_rep.RISKREP_TYPE','=','risk_setupincidence_tpyelocation.SETUP_TYPELOCATION_ID')
            ->leftJoin('risk_rep_items','risk_rep.RISK_REPITEMS_ID','=','risk_rep_items.RISK_REPITEMS_ID')
            ->leftJoin('hrd_person','risk_rep.RISKREP_USEREFFECT','=','hrd_person.ID')
            ->leftJoin('hrd_sex','risk_rep.RISKREP_SEX','=','hrd_sex.SEX_ID')
            ->leftJoin('risk_workingtime','risk_rep.RISKREP_FATE','=','risk_workingtime.WORKING_TIME_ID')
            ->leftjoin('hrd_team','hrd_team.HR_TEAM_NAME','=','risk_rep.RISKREP_TEAM_CODE')
            ->leftjoin('risk_rep_location','risk_rep_location.RISK_LOCATION_ID','=','risk_rep.RISKREP_LOCAL')
            ->leftjoin('risk_rep_program','risk_rep_program.RISK_REPPROGRAM_ID','=','risk_rep.RISK_REPPROGRAM_ID')
            ->leftjoin('risk_rep_program_sub','risk_rep_program_sub.RISK_REPPROGRAMSUB_ID','=','risk_rep.RISK_REPPROGRAMSUB_ID')
            ->leftjoin('risk_rep_program_subsub','risk_rep_program_subsub.RISK_REPPROGRAMSUBSUB_ID','=','risk_rep.RISK_REPPROGRAMSUBSUB_ID')
            ->leftjoin('risk_rep_typereason','risk_rep_typereason.RISK_REPTYPERESON_ID','=','risk_rep.RISK_REPTYPERESON_ID')
            ->leftjoin('risk_rep_typereason_sys','risk_rep_typereason_sys.RISK_REPTYPERESONSYS_ID','=','risk_rep.RISK_REPTYPERESONSYS_ID')
            ->leftjoin('risk_setupincidence_usereffect','risk_setupincidence_usereffect.INCEDENCE_USEREFFECT_ID','=','risk_rep.RISK_REP_EFFECT')
            ->leftjoin('risk_rep_items_sub','risk_rep_items_sub.RISK_REPITEMSSUB_ID','=','risk_rep.RISK_REPITEMSSUB_ID')
            ->leftjoin('risk_rep_typedep','risk_rep_typedep.RISKREP_TYPEDEPART_ID','=','risk_rep.RISKREP_TYPEDEP')
        ->first();
        $riskprogram  = DB::table('risk_rep_program')->get();
        $riskprogramsub  = DB::table('risk_rep_program_sub')->get();
        $riskprogramsubsub  = DB::table('risk_rep_program_subsub')->get();
        $risktypereason  = DB::table('risk_rep_typereason')->get();
        $risktypereasonsys  = DB::table('risk_rep_typereason_sys')->get();
        $item = DB::table('risk_rep_items')->get();
        $itemsub = DB::table('risk_rep_items_sub')->get();
        $infoteam = Team::orderBy('HR_TEAM_ID', 'asc')->get(); 
        $uefect = DB::table('risk_setupincidence_usereffect')->get();
        
        $departsub = DB::table('hrd_department_sub_sub')->get();
        $riskcategory = DB::table('risk_setincidence_category')->get();
        $location = DB::table('risk_setupincidence_location')->get();
        $level = DB::table('risk_setupincidence_level')->get();
        $setting = DB::table('risk_setincidence_setting')->get();
        $incidentsub = DB::table('risk_setupincidence_sub')->get();
        $origin = DB::table('risk_setupincidence_origin')->get();
        $sex = DB::table('hrd_sex')->get();
        $infoper = DB::table('hrd_person')->get();

        return view('manager_risk.detail_check_cancel',[
            'departsubs'=>$departsub,
            'rigreps'=>$rigrep,
            'riskcategorys'=>$riskcategory,
            'locations'=>$location,
            'levels'=>$level,
            'settings'=>$setting,
            'incidentsubs'=>$incidentsub,
            'origins'=>$origin,
            'sexs'=>$sex,
            'infopers'=>$infoper,
        ]);
    }

    public function detail_check_updatecancel(Request $request)
    {         
        $id = $request->RISKREP_ID;         
        $update =Riskrep::find($id); 
        $update->RISKREP_STATUS = 'CANCEL';              
        $update->save();        
        return redirect()->route('mrisk.detail');
    }

    public function detail_check_infer(Request $request,$id,$iduser)
    {           
            $rigrep = Riskrep::leftjoin('risk_status','risk_status.RISK_STATUS_NAME','=','risk_rep.RISKREP_STATUS')
                ->leftjoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','risk_rep.RISKREP_DEPARTMENT_SUB')
                ->leftjoin('hrd_team','hrd_team.HR_TEAM_NAME','=','risk_rep.RISKREP_TEAM_CODE')
                ->leftjoin('risk_setupincidence_tpyelocation','risk_setupincidence_tpyelocation.SETUP_TYPELOCATION_ID','=','risk_rep.RISKREP_TYPE')
                ->leftjoin('risk_setupincidence_grouplocation','risk_setupincidence_grouplocation.SETUP_GROUPLOCATION_ID','=','risk_rep.RISKREP_LOCAL')
                ->leftjoin('risk_setincidence_setting','risk_setincidence_setting.INCIDENCE_SETTING_ID','=','risk_rep.RISKREP_TITLE')
                ->leftjoin('risk_setupincidence_sub','risk_setupincidence_sub.INCIDENCE_SUB_ID','=','risk_rep.RISKREP_SUBTITLE')
                ->leftjoin('hrd_sex','hrd_sex.SEX_ID','=','risk_rep.RISKREP_SEX')
                ->leftjoin('risk_setupincidence_location','risk_setupincidence_location.INCIDENCE_LOCATION_ID','=','risk_rep.RISKREP_SEARCHLOCATE')
            ->where('risk_rep.RISKREP_ID','=',$id)->first();
            
            $ueffect = DB::table('risk_rep_usereffect')->where('RISKREP_ID','=',$id)->get(); 
            $teamlist = Risk_rep_teamlist::where('RISKREP_ID','=',$id)->get(); 
            $rep_dep = Risk_rep_department::where('RISKREP_ID','=',$id)->get();
            $rep_dep_sub = Risk_rep_department_sub::where('RISKREP_ID','=',$id)->get();
            $rep_dep_subsub = Risk_rep_department_subsub::where('RISKREP_ID','=',$id)->get();
            $rep_infoper = Risk_rep_infoperson::where('RISKREP_ID','=',$id)->get();
       
            $origin = DB::table('risk_setupincidence_origin')->get(); 
            $typelocationf = DB::table('risk_setupincidence_tpyelocation')->first();
            $grouplocation = DB::table('risk_rep_location')->where('SETUP_TYPELOCATION_ID','=',$typelocationf->SETUP_TYPELOCATION_ID)->get();
            $worktime = DB::table('risk_rep_time')->get();
            $typelocation = DB::table('risk_setupincidence_tpyelocation')->get();
            $infoper = DB::table('hrd_person')->get();
            $uefect = DB::table('risk_setupincidence_usereffect')->get();           
            $riskcategory = DB::table('risk_setincidence_category')->get();
            $location = DB::table('risk_setupincidence_location')->get();
            $level = DB::table('risk_rep_level')->get();
            $setting = DB::table('risk_setincidence_setting')->get(); 
            $incidentsub = DB::table('risk_setupincidence_sub')->get();
            $riskitem = Risk_rep_items::get();
            $sex = DB::table('hrd_sex')->get();
            $effect = DB::table('risk_setupincidence_usereffect')->get();            
            $riskprogram  = DB::table('risk_rep_program')->get();
            $riskprogramsub  = DB::table('risk_rep_program_sub')->get();
            $riskprogramsubsub  = DB::table('risk_rep_program_subsub')->get();
            $risktypereason  = DB::table('risk_rep_typereason')->get();
            $risktypereasonsys  = DB::table('risk_rep_typereason_sys')->get();
            $item = DB::table('risk_rep_items')->get();
            $itemsub = DB::table('risk_rep_items_sub')->get();
            $infoteam = Team::orderBy('HR_TEAM_ID', 'asc')->get();
            $riskrepdep = DB::table('risk_rep_typedep')->get();
            $department  =  DB::table('hrd_department')->get();
            $team =  DB::table('hrd_team')->get(); 
            //--------------------------  ฝ่าย/แผนก ------------------
            $infordepartmentsub  =  DB::table('hrd_department_sub')->get();  
            //-----------------   หน่วยงาน --------------------------
            $departsub = DB::table('hrd_department_sub_sub')->get();
            $infordepartmentsubsub  =  DB::table('hrd_department_sub_sub')->get();

            $perinfo = DB::table('hrd_person')->where('ID','=',$iduser)->first();
            // $perinfo = DB::table('hrd_person')->where('ID','=',$inp->ID)->get();

            $inforiskacc = DB::table('risk_account_detail')->get();

            $locationuse = DB::table('risk_setupincidence_origin')->get();

            $infolocation = DB::table('supplies_location')->get();
            $infolocationlevel = DB::table('supplies_location_level')->get();
            $infolocationlevelroom = DB::table('supplies_location_level_room')->get();

            $inforecheck = DB::table('risk_recheck')
            ->leftJoin('hrd_person','hrd_person.ID','=','risk_recheck.RISK_RECHECK_PERSON')
            ->where('RISK_RECHECK_RISKID','=',$id)->get();
        

           
        return view('manager_risk.detail_check_infer',[
            'inforechecks'=>$inforecheck,
            'inforiskaccs'=>$inforiskacc,
            'departsubs'=>$departsub,
            'rigreps'=>$rigrep,
            'riskcategorys'=>$riskcategory,
            'locations'=>$location,
            'levels'=>$level,
            'settings'=>$setting,
            'incidentsubs'=>$incidentsub,
            'origins'=>$origin,
            'sexs'=>$sex,
            'infopers'=>$infoper,
            'grouplocations'=>$grouplocation,
            'worktimes'=>$worktime,
            'typelocations'=>$typelocation,
            'departments'=>$department,
            'infordepartmentsubs'=>$infordepartmentsub,
            'infordepartmentsubsubs'=>$infordepartmentsubsub,
            'riskprograms'=>$riskprogram,
            'riskprogramsubs'=>$riskprogramsub,
            'riskprogramsubsubs'=>$riskprogramsubsub,
            'risktypereasons'=>$risktypereason,
            'risktypereasonsyss'=>$risktypereasonsys,
            'uefects'=>$uefect,
            'infoteams'=>$infoteam,
            'items'=>$item,
            'riskitems'=>$riskitem,
            'itemsubs'=>$itemsub,
            'riskrepdeps'=>$riskrepdep,
            'perinfos'=>$perinfo,
            'ueffects'=>$ueffect,
            'teams'=>$team,
            'teamlists'=>$teamlist,
            'rep_deps'=>$rep_dep,
            'rep_dep_subs'=>$rep_dep_sub,
            'rep_dep_subsubs'=>$rep_dep_subsub,
            'rep_infopers'=>$rep_infoper,
            'locationuses'=>$locationuse,
            'infolocations' => $infolocation,
            'infolocationlevels' => $infolocationlevel,
            'infolocationlevelrooms' => $infolocationlevelroom, 
        ]);
    }

    public function detail_check_inferupdate(Request $request)
    {    
        $savedate= $request->RISKREP_DATESAVE;
        if($savedate != ''){           
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $savedate)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0];             
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $save_date= $y_st."-".$m_st."-".$d_st;   
            }else{
            $save_date= null;
        }
        $repstart= $request->RISKREP_STARTDATE;
        if($repstart != ''){           
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $repstart)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0];             
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $start_date= $y_st."-".$m_st."-".$d_st;   
            }else{
            $start_date= null;
        }
        $checkdigget= $request->RISKREP_DIGDATE;
        if($checkdigget != ''){           
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $checkdigget)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0];             
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $dig_date= $y_st."-".$m_st."-".$d_st;   
            }else{
            $dig_date= null;
        }
        $date_notify= $request->RISKREP_DATENOTIFY;
        if($date_notify != ''){           
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $date_notify)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0];             
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $datenotify= $y_st."-".$m_st."-".$d_st;   
            }else{
            $datenotify= null;
        }

        $date_confirm= $request->RISKREP_DATECONFIRM;
        if($date_confirm != ''){           
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $date_confirm)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0];             
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $dateconfirm= $y_st."-".$m_st."-".$d_st;   
            }else{
            $dateconfirm= null;
        }
        
        $day_problem= $request->RISKREP_INFER_DAYENDPROBLEM;
        if($day_problem != ''){           
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $day_problem)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0];             
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $dayproblem= $y_st."-".$m_st."-".$d_st;   
            }else{
            $dayproblem= null;
        }
        $day_save= $request->RISKREP_INFER_DAYSAVE;
        if($day_save != ''){           
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $day_save)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0];             
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $daysave= $y_st."-".$m_st."-".$d_st;   
            }else{
            $daysave= null;
        }

        $id = $request->RISKREP_ID;
        $update =Riskrep::find($id); 
        $update->RISKREP_NO =  $request->RISKREP_NO;        
        $update->RISKREP_DATESAVE =  $save_date;
        $update->RISKREP_SEARCHLOCATE =  $request->RISKREP_SEARCHLOCATE;
        $update->RISKREP_DEPARTMENT_SUB = $request->RISKREP_DEPARTMENT_SUB;
        $update->RISKREP_TYPE =  $request->RISKREP_TYPE;   
        $update->RISKREP_USEREFFECT =  $request->RISKREP_USEREFFECT;      
        $update->RISKREP_DETAILRISK =  $request->RISKREP_DETAILRISK; 
        $update->RISKREP_BASICMANAGE =  $request->RISKREP_BASICMANAGE;

    // ความเห็นหัวหน้าหน่วยงาน     
        $update->RISKREP_STARTDATE =  $start_date; 
        $update->RISKREP_DIGDATE =  $dig_date; 
        $update->RISKREP_LOCAL =  $request->RISKREP_LOCAL;
        $update->RISK_REPPROGRAM_ID =  $request->RISK_REPPROGRAM_ID; 
        $update->RISK_REPPROGRAMSUB_ID =  $request->RISK_REPPROGRAMSUB_ID; 
        $update->RISK_REPPROGRAMSUBSUB_ID =  $request->RISK_REPPROGRAMSUBSUB_ID;   
        $update->RISK_REPTYPERESON_ID =  $request->RISK_REPTYPERESON_ID;    
        $update->RISK_REPTYPERESONSYS_ID =  $request->RISK_REPTYPERESONSYS_ID;  
        $update->RISKREP_FATE =  $request->RISKREP_FATE; 
        $update->RISKREP_TIME =  $request->RISKREP_TIME; 
        $update->RISKREP_LEVEL =  $request->RISKREP_LEVEL; 
        $update->RISK_REP_FEEDBACK =  $request->RISK_REP_FEEDBACK;
        $update->RISK_REP_EFFECT =  $request->RISK_REP_EFFECT;
        $update->RISKREP_SEX =  $request->RISKREP_SEX; 
        $update->RISKREP_AGE =  $request->RISKREP_AGE; 
        $update->RISKREP_ACC_ID =  $request->RISKREP_ACC_ID; 
        $update->RISKREP_LOCALUSE =  $request->RISKREP_LOCALUSE; 

        $update->RISKREP_LOCATION_ID =  $request->RISKREP_LOCATION_ID; 
        $update->RISKREP_LOCATION_LEVEL =  $request->RISKREP_LOCATION_LEVEL; 
        $update->RISKREP_LOCATION_LEVEL_ROOM =  $request->RISKREP_LOCATION_LEVEL_ROOM;
        $update->RISKREP_LOCATION_OTHER =  $request->RISKREP_LOCATION_OTHER;
    // กรรมการบริหารความเสี่ยง
        $update->RISK_REPITEMS_ID =  $request->RISK_REPITEMS_ID; 
        $update->RISK_REPITEMSSUB_ID =  $request->RISK_REPITEMSSUB_ID; 
        $namesub = $request->RISKREP_TYPEDEP;
        $subid = $request->RISKREP_TYPESUB;

        if ($namesub == '1') {
            $update->RISKREP_TYPEDEP =  '1'; 

            $depid = DB::table('hrd_department')->where('HR_DEPARTMENT_ID','=',$subid)->first();
            $update->RISKREP_TYPEDEP_ID =  $depid->HR_DEPARTMENT_ID; 
            $update->RISKREP_TYPEDEP_NAME =  $depid->HR_DEPARTMENT_NAME; 

            $update->RISKREP_TYPESUB = '';
            $update->RISKREP_TYPESUB_NAME = '';
            $update->RISKREP_TYPESUBSUB_ID = '';
            $update->RISKREP_TYPESUBSUB_NAME = '';
            $update->RISKREP_TEAM_ID = '';
            $update->RISKREP_TEAM_CODE = '';

        } elseif($namesub == '2'){
            $update->RISKREP_TYPEDEP =  '2'; 
            
            $depsubid = DB::table('hrd_department_sub')->where('HR_DEPARTMENT_SUB_ID','=',$subid)->first();
            $update->RISKREP_TYPESUB =  $depsubid->HR_DEPARTMENT_SUB_ID; 
            $update->RISKREP_TYPESUB_NAME =  $depsubid->HR_DEPARTMENT_SUB_NAME; 

            $update->RISKREP_TYPEDEP_ID = '';
            $update->RISKREP_TYPEDEP_NAME = '';
            $update->RISKREP_TYPESUBSUB_ID = '';
            $update->RISKREP_TYPESUBSUB_NAME = '';
            $update->RISKREP_TEAM_ID = '';
            $update->RISKREP_TEAM_CODE = '';
            
        } elseif($namesub == '3'){
            $update->RISKREP_TYPEDEP =  '3'; 

            $depsubsubid = DB::table('hrd_department_sub_sub')->where('HR_DEPARTMENT_SUB_SUB_ID','=',$subid)->first();
            $update->RISKREP_TYPESUBSUB_ID =  $depsubsubid->HR_DEPARTMENT_SUB_SUB_ID; 
            $update->RISKREP_TYPESUBSUB_NAME =  $depsubsubid->HR_DEPARTMENT_SUB_SUB_NAME; 

            $update->RISKREP_TYPEDEP_ID = '';
            $update->RISKREP_TYPEDEP_NAME = '';
            $update->RISKREP_TYPESUB = '';
            $update->RISKREP_TYPESUB_NAME = '';
            $update->RISKREP_TEAM_ID = '';
            $update->RISKREP_TEAM_CODE = '';
       
        }elseif($namesub == '4'){
            $update->RISKREP_TYPEDEP =  '4'; 

            $teamid = DB::table('hrd_team')->where('HR_TEAM_NAME','=',$subid)->first();           
            $update->RISKREP_TEAM_ID =  $teamid->HR_TEAM_ID; 
            $update->RISKREP_TEAM_CODE =  $teamid->HR_TEAM_NAME; 

            $update->RISKREP_TYPEDEP_ID = '';
            $update->RISKREP_TYPEDEP_NAME = '';
            $update->RISKREP_TYPESUB = '';
            $update->RISKREP_TYPESUB_NAME = '';
            $update->RISKREP_TYPESUBSUB_ID = '';
            $update->RISKREP_TYPESUBSUB_NAME = '';
        }else{
        }
       
        $update->RISKREP_DATENOTIFY =  $datenotify;  
        $update->RISKREP_DATECONFIRM =  $dateconfirm; 
        $update->RISKREP_DETAILRISK2 =  $request->RISKREP_DETAILRISK2;   
        $update->RISKREP_STATUS = 'SUCCESS';

    //สรุปผลการดำเนินงานแก้ไขปัญหา
            $update->RISKREP_INFER_EDIT =  $request->RISKREP_INFER_EDIT;   
            $update->RISKREP_INFER_GROUPPROBLEM =  $request->RISKREP_INFER_GROUPPROBLEM;      
            $update->RISKREP_INFER_PERFORMANCE =  $request->RISKREP_INFER_PERFORMANCE; 
            $update->RISKREP_INFER_IMPROVE =  $request->RISKREP_INFER_IMPROVE;
            $update->RISKREP_INFER_DAYENDPROBLEM =  $dayproblem;
            $update->RISKREP_INFER_USERSAVE = $request->RISKREP_INFER_USERSAVE;
            $update->RISKREP_INFER_DAYSAVE =  $daysave;
        $update->save();  
           
     
        //ผู้ได้รับผลกระทบ
            Risk_rep_usereffect::where('RISKREP_ID','=',$id)->delete(); 

                if($request->RISK_REPEFFECT_FULLNAME != '' || $request->RISK_REPEFFECT_FULLNAME != null){
                    
                $RISK_REPEFFECT_FULLNAME = $request->RISK_REPEFFECT_FULLNAME;
                $RISK_REPEFFECT_AGE = $request->RISK_REPEFFECT_AGE;
                $RISK_REPEFFECT_SEX = $request->RISK_REPEFFECT_SEX;
                $RISK_REPEFFECT_HN = $request->RISK_REPEFFECT_HN;
                $RISK_REPEFFECT_DATEIN = $request->RISK_REPEFFECT_DATEIN;         
                $RISK_REPEFFECT_AN = $request->RISK_REPEFFECT_AN; 
                $RISK_REPEFFECT_DATEADMIN = $request->RISK_REPEFFECT_DATEADMIN;             
                                    
                $number =count($RISK_REPEFFECT_FULLNAME);
                $count = 0;           
                for($count = 0; $count< $number; $count++)
                {           
                    if($RISK_REPEFFECT_DATEIN[$count] != ''){
                        $DAY = Carbon::createFromFormat('d/m/Y',$RISK_REPEFFECT_DATEIN[$count])->format('Y-m-d');
                        $date_arrary_st=explode("-",$DAY);
                        $y_sub_st = $date_arrary_st[0];

                        if($y_sub_st >= 2500){
                            $y_st = $y_sub_st-543;
                        }else{
                            $y_st = $y_sub_st;
                        }
                        $m_st = $date_arrary_st[1];
                        $d_st = $date_arrary_st[2];
                        $DATEIN= $y_st."-".$m_st."-".$d_st;
                        }else{
                        $DATEIN= null;
                    } 
                    if($RISK_REPEFFECT_DATEADMIN[$count] != ''){
                        $DAY = Carbon::createFromFormat('d/m/Y',$RISK_REPEFFECT_DATEADMIN[$count])->format('Y-m-d');
                        $date_arrary_st=explode("-",$DAY);
                        $y_sub_st = $date_arrary_st[0];

                        if($y_sub_st >= 2500){
                            $y_st = $y_sub_st-543;
                        }else{
                            $y_st = $y_sub_st;
                        }
                        $m_st = $date_arrary_st[1];
                        $d_st = $date_arrary_st[2];
                        $DATADMIT= $y_st."-".$m_st."-".$d_st;
                        }else{
                        $DATADMIT= null;
                    } 
                $add_sub = new Risk_rep_usereffect();
                $add_sub->RISKREP_ID = $id;  
                $add_sub->RISK_REPEFFECT_FULLNAME = $RISK_REPEFFECT_FULLNAME[$count];     
                $add_sub->RISK_REPEFFECT_AGE = $RISK_REPEFFECT_AGE[$count]; 
                $add_sub->RISK_REPEFFECT_SEX = $RISK_REPEFFECT_SEX[$count]; 
                $add_sub->RISK_REPEFFECT_HN = $RISK_REPEFFECT_HN[$count];   
                $add_sub->RISK_REPEFFECT_DATEIN = $DATEIN; 
                $add_sub->RISK_REPEFFECT_AN = $RISK_REPEFFECT_AN[$count]; 
                $add_sub->RISK_REPEFFECT_DATEADMIN = $DATADMIT;                         
                $add_sub->save(); 
                }
            }  
        //ทีมนำ
            Risk_rep_teamlist::where('RISKREP_ID','=',$id)->delete();
                if($request->RISK_REP_TEAMLIST_NAME != '' || $request->RISK_REP_TEAMLIST_NAME != null){                
                $RISK_REP_TEAMLIST_NAME = $request->RISK_REP_TEAMLIST_NAME;                       
                                    
                $number =count($RISK_REP_TEAMLIST_NAME);
                $count = 0;           
                for($count = 0; $count< $number; $count++)
                {     
                    $idteam = DB::table('hrd_team')->where('HR_TEAM_ID','=',$RISK_REP_TEAMLIST_NAME[$count])->first(); 
                    $add_sub = new Risk_rep_teamlist();
                    $add_sub->RISKREP_ID = $id;  
                    $add_sub->RISK_REP_TEAMLIST_CODE = $idteam->HR_TEAM_NAME; 
                    $add_sub->RISK_REP_TEAMLIST_NAME = $idteam->HR_TEAM_DETAIL;  
                    $add_sub->save(); 
                }
            }  
        //กลุ่มงาน
            Risk_rep_department::where('RISKREP_ID','=',$id)->delete(); 
                if($request->RISK_REP_DEPARTMENT_ID != '' || $request->RISK_REP_DEPARTMENT_ID != null){                
                $RISK_REP_DEPARTMENT_ID = $request->RISK_REP_DEPARTMENT_ID;                       
                                
                $number =count($RISK_REP_DEPARTMENT_ID);
                $count = 0;           
                for($count = 0; $count< $number; $count++)
                {     
                    $iddep = DB::table('hrd_department')->where('HR_DEPARTMENT_ID','=',$RISK_REP_DEPARTMENT_ID[$count])->first(); 
                    $add_sub = new Risk_rep_department();
                    $add_sub->RISKREP_ID = $id; 
                    $add_sub->HR_DEPARTMENT_ID = $iddep->HR_DEPARTMENT_ID;  
                    $add_sub->RISK_REP_DEPARTMENT_NAME = $iddep->HR_DEPARTMENT_NAME;  
                    $add_sub->save(); 
                }
            }
        //แผนก/ฝ่าย
                Risk_rep_department_sub::where('RISKREP_ID','=',$id)->delete(); 
                        if($request->RISK_REP_DEPARTMENT_SUBID != '' || $request->RISK_REP_DEPARTMENT_SUBID != null){                
                        $RISK_REP_DEPARTMENT_SUBID = $request->RISK_REP_DEPARTMENT_SUBID;                       
                                        
                        $number =count($RISK_REP_DEPARTMENT_SUBID);
                        $count = 0;           
                        for($count = 0; $count< $number; $count++)
                        {     
                            $iddepsub = DB::table('hrd_department_sub')->where('HR_DEPARTMENT_SUB_ID','=',$RISK_REP_DEPARTMENT_SUBID[$count])->first(); 
                            $add_sub = new Risk_rep_department_sub();
                            $add_sub->RISKREP_ID = $id;  
                            $add_sub->HR_DEPARTMENT_SUB_ID = $iddepsub->HR_DEPARTMENT_SUB_ID; 
                            $add_sub->RISK_REP_DEPARTMENT_SUBNAME = $iddepsub->HR_DEPARTMENT_SUB_NAME;  
                            $add_sub->save(); 
                        }              
                }   
        //หน่วยงาน
            Risk_rep_department_subsub::where('RISKREP_ID','=',$id)->delete(); 
                if($request->RISK_REP_DEPARTMENT_SUBSUBID != '' || $request->RISK_REP_DEPARTMENT_SUBSUBID != null){                
                $RISK_REP_DEPARTMENT_SUBSUBID = $request->RISK_REP_DEPARTMENT_SUBSUBID;                       
                                
                $number =count($RISK_REP_DEPARTMENT_SUBSUBID);
                $count = 0;           
                for($count = 0; $count< $number; $count++)
                {     
                    $iddepsubsub = DB::table('hrd_department_sub_sub')->where('HR_DEPARTMENT_SUB_SUB_ID','=',$RISK_REP_DEPARTMENT_SUBSUBID[$count])->first(); 
                    $add_sub = new Risk_rep_department_subsub();
                    $add_sub->RISKREP_ID = $id; 
                    $add_sub->HR_DEPARTMENT_SUB_SUB_ID = $iddepsubsub->HR_DEPARTMENT_SUB_SUB_ID;  
                    $add_sub->RISK_REP_DEPARTMENT_SUBSUBNAME = $iddepsubsub->HR_DEPARTMENT_SUB_SUB_NAME;  
                    $add_sub->save(); 
                }
            }
        //บุคคล
            Risk_rep_infoperson::where('RISKREP_ID','=',$id)->delete(); 
                if($request->RISK_REP_PERSON_NAME != '' || $request->RISK_REP_PERSON_NAME != null){                
                    $RISK_REP_PERSON_NAME = $request->RISK_REP_PERSON_NAME;                       
                                    
                    $number =count($RISK_REP_PERSON_NAME);
                    $count = 0;           
                    for($count = 0; $count< $number; $count++)
                    {     
                      
                        $add_sub = new Risk_rep_infoperson();
                        $add_sub->RISKREP_ID = $id; 
                        $add_sub->RISK_REP_PERSON_NAME = $request->RISK_REP_PERSON_NAME[$count];  
                        $add_sub->save(); 
                    }
            }

        return redirect()->route('mrisk.detail');
    }

    public function detail_destroy(Request $request,$id)
    {    
        Riskrep::destroy($id);
      
        return redirect()->route('mrisk.detail');
    }

    public function detail_cancel (Request $request,$id)
    {    


        $rigrep = DB::table('risk_rep')->where('RISKREP_ID','=',$id)
        ->leftJoin('risk_setupincidence_level','risk_rep.RISKREP_LEVEL','=','risk_setupincidence_level.INCIDENCE_LEVEL_NAME')
        ->leftJoin('risk_setupincidence_location','risk_rep.RISKREP_SEARCHLOCATE','=','risk_setupincidence_location.INCIDENCE_LOCATION_ID')
        ->leftJoin('risk_setup_origindepart','risk_rep.RISKREP_LOCAL','=','risk_setup_origindepart.ORIGIN_DEPART_ID')
        ->leftJoin('hrd_department_sub_sub','risk_rep.RISKREP_DEPARTMENT_SUB','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->leftJoin('risk_setupincidence_tpyelocation','risk_rep.RISKREP_TYPE','=','risk_setupincidence_tpyelocation.SETUP_TYPELOCATION_ID')
        ->leftJoin('risk_setincidence_setting','risk_rep.RISKREP_TITLE','=','risk_setincidence_setting.INCIDENCE_SETTING_ID')
        ->leftJoin('hrd_person','risk_rep.RISKREP_USEREFFECT','=','hrd_person.ID')
        ->leftJoin('hrd_sex','risk_rep.RISKREP_SEX','=','hrd_sex.SEX_ID')
        ->leftJoin('risk_workingtime','risk_rep.RISKREP_FATE','=','risk_workingtime.WORKING_TIME_ID')
        ->first();

   
      $origin = DB::table('risk_setupincidence_origin')->get(); 
      

        $infoper = DB::table('hrd_person')->get();
        $departsub = DB::table('hrd_department_sub_sub')->get();
        $riskcategory = DB::table('risk_setincidence_category')->get();
        $location = DB::table('risk_setupincidence_location')->get();
        $level = DB::table('risk_setupincidence_level')->get();
        $setting = DB::table('risk_setincidence_setting')->get();
        $incidentsub = DB::table('risk_setupincidence_sub')->get();
        $typelocation = DB::table('risk_setupincidence_tpyelocation')->get();
        $sex = DB::table('hrd_sex')->get();
        $grouplocation = DB::table('risk_setup_origindepart')->get();
        $worktime = DB::table('risk_workingtime')->get();
        $effect = DB::table('risk_setupincidence_usereffect')->get();


        return view('manager_risk.detail_cancel',[
            'departsubs'=>$departsub,
            'rigreps'=>$rigrep,
            'riskcategorys'=>$riskcategory,
            'locations'=>$location,
            'levels'=>$level,
            'settings'=>$setting,
            'incidentsubs'=>$incidentsub,
            'origins'=>$origin,
            'sexs'=>$sex,
            'infopers'=>$infoper,
            'grouplocations'=>$grouplocation,
            'worktimes'=>$worktime,
            'typelocations'=>$typelocation,
        ]);
    }

    public function detail_updatecancel  (Request $request)
    {   
        $id = $request->RISKREP_ID;   
        $update =Riskrep::find($id);
        $update->RISKREP_STATUS = 'CANCELED'; 
        $update->save(); 
       
        return redirect()->route('mrisk.detail');
    }

    public function internalcontrol(Request $request)
    {    
        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;        }

        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';
        $status = '';
        $search = '';
        $year_id = $yearbudget;

       

        $internalcontrol = Risk_internalcontrol::leftjoin('hrd_department_sub','risk_internalcontrol.INTERNALCONTROL_GROUP_NAME','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
        ->leftjoin('hrd_person','risk_internalcontrol.INTERNALCONTROL_HEAD_WORK','=','hrd_person.ID')
        ->get();



        return view('manager_risk.internalcontrol',[
           
            'internalcontrols'=>$internalcontrol,
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id,
        ]);
    }

    public function internalcontrol_pk5_depart(Request $request,$id)
    {    
        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;        }

        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';
        $status = '';
        $search = '';
        $year_id = $yearbudget;

    

        $icontrol = Risk_internalcontrol::where('INTERNALCONTROL_ID','=',$id)->first();
        
        $internalcontrol = Risk_internalcontrol::leftjoin('hrd_department_sub','risk_internalcontrol.INTERNALCONTROL_GROUP_NAME','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
        ->leftjoin('hrd_person','risk_internalcontrol.INTERNALCONTROL_HEAD_WORK','=','hrd_person.ID')
        ->where('risk_internalcontrol.INTERNALCONTROL_ID','=',$id)
        ->first();

        $incontrol_pk5 = Risk_internalcontrol_pk5::leftjoin('hrd_person','risk_internalcontrol_pk5.PK5_DEPART_HEAD','=','hrd_person.ID')
        ->leftjoin('hrd_department_sub','risk_internalcontrol_pk5.PK5_DEPART_DEPART','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
        ->where('INTERNALCONTROL_ID','=',$id)
        ->get();

       

        return view('manager_risk.internalcontrol_pk5_depart',[
            'icontrols'=>$icontrol,
            'internalcontrols'=>$internalcontrol,
            'incontrol_pk5s'=>$incontrol_pk5,
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id,
        ]);
    }
    
    public function internalcontrol_pk5_depart_add(Request $request,$id)
    {    
        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;        }

        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';
        $status = '';
        $search = '';
        $year_id = $yearbudget;

        $departmentsub = DB::table('hrd_department_sub')->where('ACTIVE','=','True')->get();

        $infodepartmentsub = DB::table('hrd_department_sub')
        ->leftjoin('hrd_person','hrd_department_sub.LEADER_HR_ID','=','hrd_person.ID')
        ->where('ACTIVE','=','True')->get();

        $icontrol = Risk_internalcontrol::where('INTERNALCONTROL_ID','=',$id)->first();
       
        $icontrol_sub = Risk_internalcontrol::leftjoin('risk_internalcontrol_sub','risk_internalcontrol_sub.INTERNALCONTROL_ID','=','risk_internalcontrol.INTERNALCONTROL_ID')
                        ->where('risk_internalcontrol.INTERNALCONTROL_ID','=',$id)->get();

        $icontrol_detailsubsub = Risk_internalcontrol_subsub_detail_sub::where('INTERNALCONTROL_ID','=',$id)->get();

        $rowlist = Risk_internalcontrol_subsub_detail_sub::where('INTERNALCONTROL_ID','=',$id)->count();

        $internalcontrol = Risk_internalcontrol::leftjoin('hrd_department_sub','risk_internalcontrol.INTERNALCONTROL_GROUP_NAME','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
        ->leftjoin('hrd_person','risk_internalcontrol.INTERNALCONTROL_HEAD_WORK','=','hrd_person.ID')
        ->where('risk_internalcontrol.INTERNALCONTROL_ID','=',$id)
        ->first();

        $incontrol_pk5 = Risk_internalcontrol_pk5::leftjoin('hrd_person','risk_internalcontrol_pk5.PK5_DEPART_HEAD','=','hrd_person.ID')
        ->leftjoin('hrd_department_sub','risk_internalcontrol_pk5.PK5_DEPART_DEPART','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
        ->where('INTERNALCONTROL_ID','=',$id)
        ->first();

        

        return view('manager_risk.internalcontrol_pk5_depart_add',[
            'icontrols'=>$icontrol,
            'incontrol_pk5s'=>$incontrol_pk5,
            'icontrol_subs'=>$icontrol_sub,
            'icontrol_detailsubsubs'=>$icontrol_detailsubsub,
            'internalcontrols'=>$internalcontrol,
            'infodepartmentsubs'=>$infodepartmentsub,
            'departmentsubs'=>$departmentsub,
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id,
            'rowlist' => $rowlist,
            'id' => $id
        ]);
    }
   
    public function internalcontrol_pk5_depart_save(Request $request)
    {             
        $ic_date = $request->PK5_DEPART_DATE;

            if($ic_date != ''){
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $ic_date)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0]; 
            
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $icontrol_date= $y_st."-".$m_st."-".$d_st;
            }else{
            $icontrol_date= null;
            }

            $datebigin = $request->get('DATE_BIGIN');
            $dateend = $request->get('DATE_END');

            $date_bigen_c = Carbon::createFromFormat('d/m/Y', $datebigin)->format('Y-m-d');
            $date_arrary=explode("-",$date_bigen_c);
        
            $y_sub_st = $date_arrary[0];
        
            if($y_sub_st >= 2500){
                $y = $y_sub_st-543;
            }else{
                $y = $y_sub_st;
            }
        
            $m = $date_arrary[1];
            $d = $date_arrary[2];  
            $displaydate_bigen= $y."-".$m."-".$d;
        
            $date_end_c = Carbon::createFromFormat('d/m/Y', $dateend)->format('Y-m-d');
            $date_arrary_e=explode("-",$date_end_c); 
        
            $y_sub_e = $date_arrary_e[0];
        
            if($y_sub_e >= 2500){
                $y_e = $y_sub_e-543;
            }else{
                $y_e = $y_sub_e;
            }
        
            $m_e = $date_arrary_e[1];
            $d_e = $date_arrary_e[2];  
            $displaydate_end= $y_e."-".$m_e."-".$d_e;
        
            $date = date('Y-m-d');
            $date_bigen_checks = strtotime($displaydate_bigen);
            $date_end_checks =  strtotime($displaydate_end);
            $dates =  strtotime($date);
        
            $from = date($displaydate_bigen);
            $to = date($displaydate_end);

        $iduser = $request->PK5_DEPART_HEAD;
        $iddepart = $request->PK5_DEPART_DEPART;
        $idcon = $request->INTERNALCONTROL_ID;

            $add= new Risk_internalcontrol_pk5();
            $add->PK5_DEPART_DEPART = $iddepart;
            $add->PK5_DEPART_HEAD = $iduser;
            $add->INTERNALCONTROL_ID = $idcon;
            $add->PK5_DEPART_DATE = $icontrol_date;
            $add->PK5_DEPART_YEAR = $request->BUDGET_YEAR;
            $add->PK5_DEPART_START_DATE = $from;
            $add->PK5_DEPART_LAST_DATE =  $to;
            $add->save();

           
            $id_pk5 = Risk_internalcontrol_pk5::max('PK5_DEPART_ID'); 

            if($request->PK5_DEPART_SUB_RISK[0] != '' || $request->PK5_DEPART_SUB_RISK[0] != null){
                
            $PK5_DEPART_SUB_RISK = $request->PK5_DEPART_SUB_RISK;
            $PK5_DEPART_SUB_CONTROL = $request->PK5_DEPART_SUB_CONTROL;
            $PK5_DEPART_SUB_EVACONTROL = $request->PK5_DEPART_SUB_EVACONTROL;
            $PK5_DEPART_SUB_HAVERISK = $request->PK5_DEPART_SUB_HAVERISK;
            $PK5_DEPART_ID = $request->PK5_DEPART_ID;
                               
            $number =count($PK5_DEPART_SUB_RISK);
            $count = 0;
           
            for($count = 0; $count< $number; $count++)
            { 

            $add_sub = new Risk_internalcontrol_pk5_sub();
            $add_sub->PK5_DEPART_ID = $id_pk5;    
            $add_sub->INTERNALCONTROL_ID = $PK5_DEPART_ID[$count];  
            $add_sub->PK5_DEPART_SUB_RISK = $PK5_DEPART_SUB_RISK[$count];     
            $add_sub->PK5_DEPART_SUB_CONTROL = $PK5_DEPART_SUB_CONTROL[$count]; 
            $add_sub->PK5_DEPART_SUB_EVACONTROL = $PK5_DEPART_SUB_EVACONTROL[$count]; 
            $add_sub->PK5_DEPART_SUB_HAVERISK = $PK5_DEPART_SUB_HAVERISK[$count];                           
            $add_sub->save(); 
            }
        }                

        return redirect()->route('mrisk.internalcontrol_pk5_depart',[
            'id'=>$idcon,
            'iduser'=>$iduser,
            'iddepart'=>$iddepart,
        ]);
    }
    public function internalcontrol_pk5_depart_edit(Request $request,$id)
    { 
        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;        }

        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';
        $status = '';
        $search = '';
        $year_id = $yearbudget;

        $departmentsub = DB::table('hrd_department_sub')->where('ACTIVE','=','True')->get();

        $infodepartmentsub = DB::table('hrd_department_sub')
        ->leftjoin('hrd_person','hrd_department_sub.LEADER_HR_ID','=','hrd_person.ID')
        ->where('ACTIVE','=','True')->get();


        $infodetail= DB::table('risk_internalcontrol_pk5')->where('PK5_DEPART_ID','=',$id)->first();

        $icontrol = Risk_internalcontrol::leftjoin('risk_internalcontrol_pk5','risk_internalcontrol_pk5.INTERNALCONTROL_ID','=','risk_internalcontrol.INTERNALCONTROL_ID')
        ->leftjoin('hrd_department_sub','risk_internalcontrol.INTERNALCONTROL_GROUP_NAME','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
        ->where('risk_internalcontrol.INTERNALCONTROL_ID','=',$infodetail->INTERNALCONTROL_ID)->first();
      

        $icontrol_sub = Risk_internalcontrol::leftjoin('risk_internalcontrol_sub','risk_internalcontrol_sub.INTERNALCONTROL_ID','=','risk_internalcontrol.INTERNALCONTROL_ID')
                        ->where('risk_internalcontrol.INTERNALCONTROL_ID','=',$infodetail->INTERNALCONTROL_ID)->get();

   

        $rowlist = Risk_internalcontrol_pk5_sub::where('INTERNALCONTROL_ID','=',$id)->count();

      
        $internalcontrol = Risk_internalcontrol::leftjoin('hrd_department_sub','risk_internalcontrol.INTERNALCONTROL_GROUP_NAME','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
        ->leftjoin('hrd_person','risk_internalcontrol.INTERNALCONTROL_HEAD_WORK','=','hrd_person.ID')
        ->where('risk_internalcontrol.INTERNALCONTROL_ID','=',$id)
        ->get();

        $icontrol_pk5 = Risk_internalcontrol_pk5::leftjoin('hrd_person','risk_internalcontrol_pk5.PK5_DEPART_HEAD','=','hrd_person.ID')->where('PK5_DEPART_ID','=',$id)->first();

        $icontrol_detailsubsub = Risk_internalcontrol_pk5_sub::where('PK5_DEPART_ID','=',$id)
        ->get();

        return view('manager_risk.internalcontrol_pk5_depart_edit',[
            'icontrols'=>$icontrol,
            'icontrol_subs'=>$icontrol_sub,
            'icontrol_pk5s'=>$icontrol_pk5,
            'icontrol_detailsubsubs'=>$icontrol_detailsubsub,
            'internalcontrols'=>$internalcontrol,
            'infodepartmentsubs'=>$infodepartmentsub,
            'departmentsubs'=>$departmentsub,
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id,
            'rowlist' => $rowlist,
            'id' => $id
        ]);
    }
    
    public function internalcontrol_pk5_depart_update(Request $request)
    {             
        $ic_date = $request->PK5_DEPART_DATE;

            if($ic_date != ''){
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $ic_date)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0]; 
            
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $icontrol_date= $y_st."-".$m_st."-".$d_st;
            }else{
            $icontrol_date= null;
            }

            $datebigin = $request->get('DATE_BIGIN');
            $dateend = $request->get('DATE_END');

            $date_bigen_c = Carbon::createFromFormat('d/m/Y', $datebigin)->format('Y-m-d');
            $date_arrary=explode("-",$date_bigen_c);
        
            $y_sub_st = $date_arrary[0];
        
            if($y_sub_st >= 2500){
                $y = $y_sub_st-543;
            }else{
                $y = $y_sub_st;
            }
        
            $m = $date_arrary[1];
            $d = $date_arrary[2];  
            $displaydate_bigen= $y."-".$m."-".$d;
        
            $date_end_c = Carbon::createFromFormat('d/m/Y', $dateend)->format('Y-m-d');
            $date_arrary_e=explode("-",$date_end_c); 
        
            $y_sub_e = $date_arrary_e[0];
        
            if($y_sub_e >= 2500){
                $y_e = $y_sub_e-543;
            }else{
                $y_e = $y_sub_e;
            }
        
            $m_e = $date_arrary_e[1];
            $d_e = $date_arrary_e[2];  
            $displaydate_end= $y_e."-".$m_e."-".$d_e;
        
            $date = date('Y-m-d');
            $date_bigen_checks = strtotime($displaydate_bigen);
            $date_end_checks =  strtotime($displaydate_end);
            $dates =  strtotime($date);
        
            $from = date($displaydate_bigen);
        $to = date($displaydate_end);

        $iduser = $request->PK5_DEPART_HEAD;
        $iddepart = $request->PK5_DEPART_DEPART;
        $idcon = $request->INTERNALCONTROL_ID;
        $idpk5 = $request->PK5_DEPART_ID;
 
            $update = Risk_internalcontrol_pk5::find($idpk5);   
            $update->PK5_DEPART_DEPART = $iddepart;
            $update->PK5_DEPART_HEAD = $iduser;
            $update->INTERNALCONTROL_ID = $idcon;
            $update->PK5_DEPART_DATE = $icontrol_date;
            $update->PK5_DEPART_YEAR = $request->BUDGET_YEAR;
            $update->PK5_DEPART_START_DATE = $from;
            $update->PK5_DEPART_LAST_DATE =  $to;
            $update->save();

            Risk_internalcontrol_pk5_sub::where('PK5_DEPART_ID','=',$idpk5)->delete(); 

            if($request->PK5_DEPART_SUB_RISK[0] != '' || $request->PK5_DEPART_SUB_RISK[0] != null){
                
            $PK5_DEPART_SUB_RISK = $request->PK5_DEPART_SUB_RISK;
            $PK5_DEPART_SUB_CONTROL = $request->PK5_DEPART_SUB_CONTROL;
            $PK5_DEPART_SUB_EVACONTROL = $request->PK5_DEPART_SUB_EVACONTROL;
            $PK5_DEPART_SUB_HAVERISK = $request->PK5_DEPART_SUB_HAVERISK;
            $PK5_DEPART_SUB_ID = $request->PK5_DEPART_SUB_ID;
                               
            $number =count($PK5_DEPART_SUB_RISK);
            $count = 0;
           
            for($count = 0; $count< $number; $count++)
            { 

            $add_sub = new Risk_internalcontrol_pk5_sub();
            $add_sub->PK5_DEPART_ID = $request->PK5_DEPART_SUB_ID[$count];     
            $add_sub->INTERNALCONTROL_ID = $idcon;   
            $add_sub->PK5_DEPART_SUB_RISK = $PK5_DEPART_SUB_RISK[$count];     
            $add_sub->PK5_DEPART_SUB_CONTROL = $PK5_DEPART_SUB_CONTROL[$count]; 
            $add_sub->PK5_DEPART_SUB_EVACONTROL = $PK5_DEPART_SUB_EVACONTROL[$count]; 
            $add_sub->PK5_DEPART_SUB_HAVERISK = $PK5_DEPART_SUB_HAVERISK[$count];                           
            $add_sub->save(); 
            }
        }                

        return redirect()->route('mrisk.internalcontrol_pk5_depart',[
            'id'=>$idcon,
            'iduser'=>$iduser,
            'iddepart'=>$iddepart,
        ]);
    }

    public function internalcontrol_pk5_depart_destroy(Request $request,$id,$iduser,$iddepart)
    {    
      
        $infodetail= DB::table('risk_internalcontrol_pk5')->where('PK5_DEPART_ID','=',$id)->first();

        Risk_internalcontrol_pk5::destroy($id);
        Risk_internalcontrol_pk5_sub::where('PK5_DEPART_ID','=',$infodetail->PK5_DEPART_ID)->delete(); 
      
        return redirect()->route('mrisk.internalcontrol_pk5_depart',[
            'id'=>$infodetail->INTERNALCONTROL_ID,
            'iduser'=>$iduser,
            'iddepart'=>$iddepart,
        ]);
    }

    public function excel_risk_depart(Request $request,$id)
    {
        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;        }

        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';
        $status = '';
        $search = '';
        $year_id = $yearbudget;

        $departmentsub = DB::table('hrd_department_sub')->where('ACTIVE','=','True')->get();

        $infodepartmentsub = DB::table('hrd_department_sub')
        ->leftjoin('hrd_person','hrd_department_sub.LEADER_HR_ID','=','hrd_person.ID')
        ->where('ACTIVE','=','True')->get();


        $infodetail= DB::table('risk_internalcontrol_pk5')->where('PK5_DEPART_ID','=',$id)->first();

        $icontrol = Risk_internalcontrol::leftjoin('risk_internalcontrol_pk5','risk_internalcontrol_pk5.INTERNALCONTROL_ID','=','risk_internalcontrol.INTERNALCONTROL_ID')
        ->leftjoin('hrd_department_sub','risk_internalcontrol.INTERNALCONTROL_GROUP_NAME','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
        ->where('risk_internalcontrol.INTERNALCONTROL_ID','=',$infodetail->INTERNALCONTROL_ID)->first();
      

        $icontrol_sub = Risk_internalcontrol::leftjoin('risk_internalcontrol_sub','risk_internalcontrol_sub.INTERNALCONTROL_ID','=','risk_internalcontrol.INTERNALCONTROL_ID')
                        ->where('risk_internalcontrol.INTERNALCONTROL_ID','=',$infodetail->INTERNALCONTROL_ID)->get();

   

        $rowlist = Risk_internalcontrol_pk5_sub::where('INTERNALCONTROL_ID','=',$id)->count();

      
        $internalcontrol = Risk_internalcontrol::leftjoin('hrd_department_sub','risk_internalcontrol.INTERNALCONTROL_GROUP_NAME','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
        ->leftjoin('hrd_person','risk_internalcontrol.INTERNALCONTROL_HEAD_WORK','=','hrd_person.ID')
        ->where('risk_internalcontrol.INTERNALCONTROL_ID','=',$id)
        ->get();

        $icontrol_pk5 = Risk_internalcontrol_pk5::leftjoin('hrd_person','risk_internalcontrol_pk5.PK5_DEPART_HEAD','=','hrd_person.ID')->where('PK5_DEPART_ID','=',$id)->first();

        $icontrol_detailsubsub = Risk_internalcontrol_pk5_sub::where('PK5_DEPART_ID','=',$id)
        ->get();

        return view('manager_risk.excel_risk_depart',[
            'icontrols'=>$icontrol,
            'icontrol_subs'=>$icontrol_sub,
            'icontrol_pk5s'=>$icontrol_pk5,
            'icontrol_detailsubsubs'=>$icontrol_detailsubsub,
            'internalcontrols'=>$internalcontrol,
            'infodepartmentsubs'=>$infodepartmentsub,
            'departmentsubs'=>$departmentsub,
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id,
            'rowlist' => $rowlist,
            'id' => $id
        ]);
    }
    public function excel_risk_organi(Request $request,$id)
    {
        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543; }

        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';
        $status = '';
        $search = '';
        $year_id = $yearbudget;

        $departmentsub = DB::table('hrd_department_sub')->where('ACTIVE','=','True')->get();

        $infodepartmentsub = DB::table('hrd_department_sub')
        ->leftjoin('hrd_person','hrd_department_sub.LEADER_HR_ID','=','hrd_person.ID')
        ->where('ACTIVE','=','True')->get();


        $infodetail= DB::table('risk_internalcontrol_organi')->where('PK5_ORGANI_ID','=',$id)->first();

        $icontrol = Risk_internalcontrol::leftjoin('risk_internalcontrol_organi','risk_internalcontrol_organi.INTERNALCONTROL_ID','=','risk_internalcontrol.INTERNALCONTROL_ID')
        ->where('risk_internalcontrol.INTERNALCONTROL_ID','=',$infodetail->INTERNALCONTROL_ID)->first();
      

        $icontrol_sub = Risk_internalcontrol::leftjoin('risk_internalcontrol_sub','risk_internalcontrol_sub.INTERNALCONTROL_ID','=','risk_internalcontrol.INTERNALCONTROL_ID')
                        ->where('risk_internalcontrol.INTERNALCONTROL_ID','=',$infodetail->INTERNALCONTROL_ID)->get();

   
        $rowlist = Risk_internalcontrol_organi_sub::where('INTERNALCONTROL_ID','=',$id)->count();

        $internalcontrol = Risk_internalcontrol::leftjoin('hrd_department_sub','risk_internalcontrol.INTERNALCONTROL_GROUP_NAME','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
        ->leftjoin('hrd_person','risk_internalcontrol.INTERNALCONTROL_HEAD_WORK','=','hrd_person.ID')
        ->first();

        $icontrol_organi = Risk_internalcontrol_organi::where('PK5_ORGANI_ID','=',$id)->first();

        $icontrol_organisub = Risk_internalcontrol_organi_sub::where('PK5_ORGANI_ID','=',$id)->get();
        return view('manager_risk.excel_risk_organi',[
            'icontrols'=>$icontrol,
            'icontrol_subs'=>$icontrol_sub,
            'icontrol_organis'=>$icontrol_organi,
            'icontrol_organisubs'=>$icontrol_organisub,
            'internalcontrols'=>$internalcontrol,
            'infodepartmentsubs'=>$infodepartmentsub,
            'departmentsubs'=>$departmentsub,
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id,
            'rowlist' => $rowlist,
            'id' => $id
        ]);
    }

    public function internalcontrol_pk5_organi(Request $request,$id)
    {    
        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;        }

        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';
        $status = '';
        $search = '';
        $year_id = $yearbudget;

        $icontrol = Risk_internalcontrol::where('INTERNALCONTROL_ID','=',$id)->first();
        
        $internalcontrol = Risk_internalcontrol::leftjoin('hrd_department_sub','risk_internalcontrol.INTERNALCONTROL_GROUP_NAME','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
        ->leftjoin('hrd_person','risk_internalcontrol.INTERNALCONTROL_HEAD_WORK','=','hrd_person.ID')
        ->first();

        $incontrol_organi = Risk_internalcontrol_organi::leftjoin('hrd_person','risk_internalcontrol_organi.PK5_ORGANI_HEADER','=','hrd_person.ID')
        ->leftjoin('hrd_department_sub','risk_internalcontrol_organi.PK5_ORGANI_DEPART','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
        ->get();

        return view('manager_risk.internalcontrol_pk5_organi',[
            'icontrols'=>$icontrol,
            'internalcontrols'=>$internalcontrol,
            'incontrol_organis'=>$incontrol_organi,
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id,
        ]);
    }

    public function internalcontrol_pk5_organi_add(Request $request,$id)
    {    
        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;        }

        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';
        $status = '';
        $search = '';
        $year_id = $yearbudget;

        $departmentsub = DB::table('hrd_department_sub')->where('ACTIVE','=','True')->get();

        $infodepartmentsub = DB::table('hrd_department_sub')
        ->leftjoin('hrd_person','hrd_department_sub.LEADER_HR_ID','=','hrd_person.ID')
        ->where('ACTIVE','=','True')->get();

        $icontrol = Risk_internalcontrol::where('INTERNALCONTROL_ID','=',$id)->first();
       
        $icontrol_sub = Risk_internalcontrol::leftjoin('risk_internalcontrol_sub','risk_internalcontrol_sub.INTERNALCONTROL_ID','=','risk_internalcontrol.INTERNALCONTROL_ID')
                        ->where('risk_internalcontrol.INTERNALCONTROL_ID','=',$id)->get();

        $icontrol_detailsubsub = Risk_internalcontrol_pk5_sub::where('PK5_DEPART_ID','=',$id)->get();

        $rowlist = Risk_internalcontrol_pk5_sub::where('PK5_DEPART_ID','=',$id)->count();

        $internalcontrol = Risk_internalcontrol::leftjoin('hrd_department_sub','risk_internalcontrol.INTERNALCONTROL_GROUP_NAME','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
        ->leftjoin('hrd_person','risk_internalcontrol.INTERNALCONTROL_HEAD_WORK','=','hrd_person.ID')
        ->first();

        


        return view('manager_risk.internalcontrol_pk5_organi_add',[
            'icontrols'=>$icontrol,
            'icontrol_subs'=>$icontrol_sub,
            'icontrol_detailsubsubs'=>$icontrol_detailsubsub,
            'internalcontrols'=>$internalcontrol,
            'infodepartmentsubs'=>$infodepartmentsub,
            'departmentsubs'=>$departmentsub,
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id,
            'rowlist' => $rowlist,
            'id' => $id
        ]);
    }

    public function internalcontrol_pk5_organi_save(Request $request)
    {             
        $ic_date = $request->PK5_ORGANI_DATE;

            if($ic_date != ''){
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $ic_date)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0]; 
            
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $icontrol_date= $y_st."-".$m_st."-".$d_st;
            }else{
            $icontrol_date= null;
            }

            $datebigin = $request->get('DATE_BIGIN');
            $dateend = $request->get('DATE_END');

            $date_bigen_c = Carbon::createFromFormat('d/m/Y', $datebigin)->format('Y-m-d');
            $date_arrary=explode("-",$date_bigen_c);
        
            $y_sub_st = $date_arrary[0];
        
            if($y_sub_st >= 2500){
                $y = $y_sub_st-543;
            }else{
                $y = $y_sub_st;
            }
        
            $m = $date_arrary[1];
            $d = $date_arrary[2];  
            $displaydate_bigen= $y."-".$m."-".$d;
        
            $date_end_c = Carbon::createFromFormat('d/m/Y', $dateend)->format('Y-m-d');
            $date_arrary_e=explode("-",$date_end_c); 
        
            $y_sub_e = $date_arrary_e[0];
        
            if($y_sub_e >= 2500){
                $y_e = $y_sub_e-543;
            }else{
                $y_e = $y_sub_e;
            }
        
            $m_e = $date_arrary_e[1];
            $d_e = $date_arrary_e[2];  
            $displaydate_end= $y_e."-".$m_e."-".$d_e;
        
            $date = date('Y-m-d');
            $date_bigen_checks = strtotime($displaydate_bigen);
            $date_end_checks =  strtotime($displaydate_end);
            $dates =  strtotime($date);
        
            $from = date($displaydate_bigen);
        $to = date($displaydate_end);

        $iduser = $request->PK5_ORGANI_HEADER;
        $iddepart = $request->PK5_ORGANI_DEPART;
        $idcon = $request->INTERNALCONTROL_ID;

            $add= new Risk_internalcontrol_organi();
            $add->PK5_ORGANI_DEPART = $iddepart;
            $add->PK5_ORGANI_HEADER = $iduser;
            $add->INTERNALCONTROL_ID = $idcon;
            $add->PK5_ORGANI_DATE = $icontrol_date;
            $add->PK5_ORGANI_YEAR = $request->BUDGET_YEAR;
            $add->PK5_ORGANI_START_DATE = $from;
            $add->PK5_ORGANI_END_DATE =  $to;
            $add->save();

            $id_organi = Risk_internalcontrol_organi::max('PK5_ORGANI_ID'); 
           
          
            if($request->PK5_ORGANI_SUB_CONTROL[0] != '' || $request->PK5_ORGANI_SUB_CONTROL[0] != null){
                
            $PK5_ORGANI_SUB_CONTROL = $request->PK5_ORGANI_SUB_CONTROL;
            $PK5_ORGANI_SUB_HAVERISK = $request->PK5_ORGANI_SUB_HAVERISK;
            $PK5_ORGANI_SUB_UPDATECONTROL = $request->PK5_ORGANI_SUB_UPDATECONTROL;
            $PK5_ORGANI_SUB_USER = $request->PK5_ORGANI_SUB_USER;
            $PK5_ORGANI_ID = $request->PK5_ORGANI_ID;
                               
            $number =count($PK5_ORGANI_SUB_CONTROL);
            $count = 0;
           
            for($count = 0; $count< $number; $count++)
            { 

            $add_sub = new Risk_internalcontrol_organi_sub();
            $add_sub->PK5_ORGANI_ID = $id_organi; 
            $add_sub->INTERNALCONTROL_ID = $PK5_ORGANI_ID[$count];  
            $add_sub->PK5_ORGANI_SUB_CONTROL = $PK5_ORGANI_SUB_CONTROL[$count];     
            $add_sub->PK5_ORGANI_SUB_HAVERISK = $PK5_ORGANI_SUB_HAVERISK[$count]; 
            $add_sub->PK5_ORGANI_SUB_UPDATECONTROL = $PK5_ORGANI_SUB_UPDATECONTROL[$count]; 
            $add_sub->PK5_ORGANI_SUB_USER = $PK5_ORGANI_SUB_USER[$count];                           
            $add_sub->save(); 
            }
        }                

        return redirect()->route('mrisk.internalcontrol_pk5_organi',[
            'id'=>$idcon,
            'iduser'=>$iduser,
            'iddepart'=>$iddepart,
        ]);
    }
    
    public function internalcontrol_pk5_organi_edit(Request $request,$id)
    { 
        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;        }

        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';
        $status = '';
        $search = '';
        $year_id = $yearbudget;

        $departmentsub = DB::table('hrd_department_sub')->where('ACTIVE','=','True')->get();

        $infodepartmentsub = DB::table('hrd_department_sub')
        ->leftjoin('hrd_person','hrd_department_sub.LEADER_HR_ID','=','hrd_person.ID')
        ->where('ACTIVE','=','True')->get();


        $infodetail= DB::table('risk_internalcontrol_organi')->where('PK5_ORGANI_ID','=',$id)->first();

        $icontrol = Risk_internalcontrol::leftjoin('risk_internalcontrol_organi','risk_internalcontrol_organi.INTERNALCONTROL_ID','=','risk_internalcontrol.INTERNALCONTROL_ID')
        ->where('risk_internalcontrol.INTERNALCONTROL_ID','=',$infodetail->INTERNALCONTROL_ID)->first();
      

        $icontrol_sub = Risk_internalcontrol::leftjoin('risk_internalcontrol_sub','risk_internalcontrol_sub.INTERNALCONTROL_ID','=','risk_internalcontrol.INTERNALCONTROL_ID')
                        ->where('risk_internalcontrol.INTERNALCONTROL_ID','=',$infodetail->INTERNALCONTROL_ID)->get();

   
        $rowlist = Risk_internalcontrol_organi_sub::where('INTERNALCONTROL_ID','=',$id)->count();

        $internalcontrol = Risk_internalcontrol::leftjoin('hrd_department_sub','risk_internalcontrol.INTERNALCONTROL_GROUP_NAME','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
        ->leftjoin('hrd_person','risk_internalcontrol.INTERNALCONTROL_HEAD_WORK','=','hrd_person.ID')
        ->first();

        $icontrol_organi = Risk_internalcontrol_organi::where('PK5_ORGANI_ID','=',$id)->first();

        $icontrol_organisub = Risk_internalcontrol_organi_sub::where('PK5_ORGANI_ID','=',$id)->get();

        return view('manager_risk.internalcontrol_pk5_organi_edit',[
            'icontrols'=>$icontrol,
            'icontrol_subs'=>$icontrol_sub,
            'icontrol_organis'=>$icontrol_organi,
            'icontrol_organisubs'=>$icontrol_organisub,
            'internalcontrols'=>$internalcontrol,
            'infodepartmentsubs'=>$infodepartmentsub,
            'departmentsubs'=>$departmentsub,
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id,
            'rowlist' => $rowlist,
            'id' => $id
        ]);
    }
    
    public function internalcontrol_pk5_organi_update(Request $request)
    {             
        $ic_date = $request->PK5_ORGANI_DATE;

            if($ic_date != ''){
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $ic_date)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0]; 
            
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $icontrol_date= $y_st."-".$m_st."-".$d_st;
            }else{
            $icontrol_date= null;
            }

            $datebigin = $request->get('DATE_BIGIN');
            $dateend = $request->get('DATE_END');

            $date_bigen_c = Carbon::createFromFormat('d/m/Y', $datebigin)->format('Y-m-d');
            $date_arrary=explode("-",$date_bigen_c);
        
            $y_sub_st = $date_arrary[0];
        
            if($y_sub_st >= 2500){
                $y = $y_sub_st-543;
            }else{
                $y = $y_sub_st;
            }
        
            $m = $date_arrary[1];
            $d = $date_arrary[2];  
            $displaydate_bigen= $y."-".$m."-".$d;
        
            $date_end_c = Carbon::createFromFormat('d/m/Y', $dateend)->format('Y-m-d');
            $date_arrary_e=explode("-",$date_end_c); 
        
            $y_sub_e = $date_arrary_e[0];
        
            if($y_sub_e >= 2500){
                $y_e = $y_sub_e-543;
            }else{
                $y_e = $y_sub_e;
            }
        
            $m_e = $date_arrary_e[1];
            $d_e = $date_arrary_e[2];  
            $displaydate_end= $y_e."-".$m_e."-".$d_e;
        
            $date = date('Y-m-d');
            $date_bigen_checks = strtotime($displaydate_bigen);
            $date_end_checks =  strtotime($displaydate_end);
            $dates =  strtotime($date);
        
            $from = date($displaydate_bigen);
        $to = date($displaydate_end);

        $iduser = $request->PK5_ORGANI_HEADER;
        $iddepart = $request->PK5_ORGANI_DEPART;
        $idcon = $request->INTERNALCONTROL_ID;
        $idpk5 = $request->PK5_ORGANI_ID;

            $update = Risk_internalcontrol_organi::find($idpk5);   
            $update->PK5_ORGANI_DEPART = $iddepart;
            $update->PK5_ORGANI_HEADER = $iduser;
            $update->INTERNALCONTROL_ID = $idcon;
            $update->PK5_ORGANI_DATE = $icontrol_date;
            $update->PK5_ORGANI_YEAR = $request->BUDGET_YEAR;
            $update->PK5_ORGANI_START_DATE = $from;
            $update->PK5_ORGANI_END_DATE =  $to;
            $update->save();

            Risk_internalcontrol_organi_sub::where('PK5_ORGANI_ID','=',$idpk5)->delete(); 

            if($request->PK5_ORGANI_SUB_CONTROL[0] != '' || $request->PK5_ORGANI_SUB_CONTROL[0] != null){
                
            $PK5_ORGANI_SUB_CONTROL = $request->PK5_ORGANI_SUB_CONTROL;
            $PK5_ORGANI_SUB_HAVERISK = $request->PK5_ORGANI_SUB_HAVERISK;
            $PK5_ORGANI_SUB_UPDATECONTROL = $request->PK5_ORGANI_SUB_UPDATECONTROL;
            $PK5_ORGANI_SUB_USER = $request->PK5_ORGANI_SUB_USER;
            $PK5_ORGANI_SUB_ID = $request->PK5_ORGANI_SUB_ID;
                               
            $number =count($PK5_ORGANI_SUB_CONTROL);
            $count = 0;
           
            for($count = 0; $count< $number; $count++)
            { 

           
            $add_sub = new Risk_internalcontrol_organi_sub();
            $add_sub->PK5_ORGANI_ID = $request->PK5_ORGANI_SUB_ID[$count]; 
            $add_sub->INTERNALCONTROL_ID = $idcon;   
            $add_sub->PK5_ORGANI_SUB_CONTROL = $PK5_ORGANI_SUB_CONTROL[$count];     
            $add_sub->PK5_ORGANI_SUB_HAVERISK = $PK5_ORGANI_SUB_HAVERISK[$count]; 
            $add_sub->PK5_ORGANI_SUB_UPDATECONTROL = $PK5_ORGANI_SUB_UPDATECONTROL[$count]; 
            $add_sub->PK5_ORGANI_SUB_USER = $PK5_ORGANI_SUB_USER[$count];                           
            $add_sub->save(); 
            }
        }                

        return redirect()->route('mrisk.internalcontrol_pk5_organi',[
            'id'=>$idcon,
            'iduser'=>$iduser,
            'iddepart'=>$iddepart,
        ]);
    }

    public function internalcontrol_pk5_organi_destroy(Request $request,$id,$iduser,$iddepart)
    {    
      
        $infodetail= DB::table('risk_internalcontrol_organi')->where('PK5_ORGANI_ID','=',$id)->first();

        Risk_internalcontrol_organi::destroy($id);
        Risk_internalcontrol_organi_sub::where('PK5_ORGANI_ID','=',$infodetail->PK5_ORGANI_ID)->delete(); 
      
        return redirect()->route('mrisk.internalcontrol_pk5_organi',[
            'id'=>$infodetail->INTERNALCONTROL_ID,
            'iduser'=>$iduser,
            'iddepart'=>$iddepart,
        ]);
    }

    public function internalcontrol_detail(Request $request,$id)
    {   

        $internalcontrol = Risk_internalcontrol::leftjoin('hrd_department_sub','risk_internalcontrol.INTERNALCONTROL_GROUP_NAME','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
        ->leftjoin('hrd_person','risk_internalcontrol.INTERNALCONTROL_HEAD_WORK','=','hrd_person.ID')
        ->where('INTERNALCONTROL_ID','=',$id)->first();

        $internalcontrol_sub = Risk_internalcontrol_sub::where('INTERNALCONTROL_ID','=',$id)->get();
        $internalcontrol_subsub = Risk_internalcontrol_subsub::where('INTERNALCONTROL_ID','=',$id)->get();

        $departmentsub = DB::table('hrd_department_sub')->where('ACTIVE','=','True')->get();

        $infodepartmentsub = DB::table('hrd_department_sub')
        ->leftjoin('hrd_person','hrd_department_sub.LEADER_HR_ID','=','hrd_person.ID')
        ->where('ACTIVE','=','True')->get();


        return view('manager_risk.internalcontrol_detail',[
            'internalcontrols'=>$internalcontrol,
            'internalcontrol_subs'=>$internalcontrol_sub,
            'internalcontrol_subsubs'=>$internalcontrol_subsub,
            'infodepartmentsubs' =>$infodepartmentsub,
            'departmentsubs'=>$departmentsub,
        ]);
    }

    public function internalcontrolsearch(Request $request)
    { 

        $search = $request->get('search');
        $status = $request->SEND_STATUS;
        $datebigin = $request->get('DATE_BIGIN');
        $dateend = $request->get('DATE_END');
        
    
        if($search==''){
            $search="";
        }
    
        $date_bigen_c = Carbon::createFromFormat('d/m/Y', $datebigin)->format('Y-m-d');
        $date_arrary=explode("-",$date_bigen_c);
    
        $y_sub_st = $date_arrary[0];
    
        if($y_sub_st >= 2500){
            $y = $y_sub_st-543;
        }else{
            $y = $y_sub_st;
        }
    
        $m = $date_arrary[1];
        $d = $date_arrary[2];  
        $displaydate_bigen= $y."-".$m."-".$d;
    
        $date_end_c = Carbon::createFromFormat('d/m/Y', $dateend)->format('Y-m-d');
        $date_arrary_e=explode("-",$date_end_c); 
    
        $y_sub_e = $date_arrary_e[0];
    
        if($y_sub_e >= 2500){
            $y_e = $y_sub_e-543;
        }else{
            $y_e = $y_sub_e;
        }
    
        $m_e = $date_arrary_e[1];
        $d_e = $date_arrary_e[2];  
        $displaydate_end= $y_e."-".$m_e."-".$d_e;
    
        $date = date('Y-m-d');
        $date_bigen_checks = strtotime($displaydate_bigen);
        $date_end_checks =  strtotime($displaydate_end);
        $dates =  strtotime($date);
    
        $from = date($displaydate_bigen);
        $to = date($displaydate_end);
           
    
            $internalcontrol = Risk_internalcontrol::leftjoin('hrd_department_sub','risk_internalcontrol.INTERNALCONTROL_GROUP_NAME','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
                ->leftjoin('hrd_person','risk_internalcontrol.INTERNALCONTROL_HEAD_WORK','=','hrd_person.ID')       
                ->where(function($q) use ($search){
                    $q->where('INTERNALCONTROL_MISSION','like','%'.$search.'%');
                    $q->orwhere('HR_DEPARTMENT_SUB_NAME','like','%'.$search.'%');
                    $q->orwhere('HR_FNAME','like','%'.$search.'%');
                    $q->orwhere('HR_LNAME','like','%'.$search.'%');
                                      
                })
                ->WhereBetween('INTERNALCONTROL_DATE',[$from,$to]) 
                ->orderBy('INTERNALCONTROL_ID', 'desc')->get();
               
                $m_budget = date("m");
                if($m_budget>9){
                $yearbudget = date("Y")+544;
                }else{
                $yearbudget = date("Y")+543;        }
        
                $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        
                $displaydate_bigen = ($yearbudget-544).'-10-01';
                $displaydate_end = ($yearbudget-543).'-09-30';
                $year_id = $yearbudget;
                

                return view('manager_risk.internalcontrol',[           
            'internalcontrols'=>$internalcontrol,
            'status_check'=> $status,
            'search'=> $search,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,  
            'budgets' =>  $budget,
            'year_id'=>$year_id,
        ]);
    }

    public function internalcontrol_add()
    {    
        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;        }

        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';
        $status = '';
        $search = '';
        $year_id = $yearbudget;

        $departmentsub = DB::table('hrd_department_sub')->where('ACTIVE','=','True')->get();

        $infodepartmentsub = DB::table('hrd_department_sub')
        ->leftjoin('hrd_person','hrd_department_sub.LEADER_HR_ID','=','hrd_person.ID')
        ->where('ACTIVE','=','True')->get();

        return view('manager_risk.internalcontrol_add',[
            'infodepartmentsubs'=>$infodepartmentsub,
            'departmentsubs'=>$departmentsub,
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id,
        ]);
    }
    public function internalcontrol_save(Request $request)
    {       
      
        $internalcontroldate = $request->INTERNALCONTROL_DATE;

            if($internalcontroldate != ''){
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $internalcontroldate)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0]; 
            
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $icontrol_date= $y_st."-".$m_st."-".$d_st;
            }else{
            $icontrol_date= null;
            }

            $datebigin = $request->get('DATE_BIGIN');
            $dateend = $request->get('DATE_END');

            $date_bigen_c = Carbon::createFromFormat('d/m/Y', $datebigin)->format('Y-m-d');
            $date_arrary=explode("-",$date_bigen_c);
        
            $y_sub_st = $date_arrary[0];
        
            if($y_sub_st >= 2500){
                $y = $y_sub_st-543;
            }else{
                $y = $y_sub_st;
            }
        
            $m = $date_arrary[1];
            $d = $date_arrary[2];  
            $displaydate_bigen= $y."-".$m."-".$d;
        
            $date_end_c = Carbon::createFromFormat('d/m/Y', $dateend)->format('Y-m-d');
            $date_arrary_e=explode("-",$date_end_c); 
        
            $y_sub_e = $date_arrary_e[0];
        
            if($y_sub_e >= 2500){
                $y_e = $y_sub_e-543;
            }else{
                $y_e = $y_sub_e;
            }
        
            $m_e = $date_arrary_e[1];
            $d_e = $date_arrary_e[2];  
            $displaydate_end= $y_e."-".$m_e."-".$d_e;
        
            $date = date('Y-m-d');
            $date_bigen_checks = strtotime($displaydate_bigen);
            $date_end_checks =  strtotime($displaydate_end);
            $dates =  strtotime($date);
        
            $from = date($displaydate_bigen);
        $to = date($displaydate_end);

            $add= new Risk_internalcontrol();
            $add->INTERNALCONTROL_GROUP_NAME = $request->INTERNALCONTROL_GROUP_NAME;
            $add->INTERNALCONTROL_HEAD_WORK = $request->INTERNALCONTROL_HEAD_WORK;
            $add->INTERNALCONTROL_DATE = $icontrol_date;
            $add->INTERNALCONTROL_YEAR = $request->BUDGET_YEAR;
            $add->INTERNALCONTROL_START_DAY = $from;
            $add->INTERNALCONTROL_END_DAY =  $to;
            $add->INTERNALCONTROL_POSITION = $request->INTERNALCONTROL_POSITION;
            $add->INTERNALCONTROL_MISSION = $request->INTERNALCONTROL_MISSION;
            $add->save();

            $id_control =  Risk_internalcontrol::max('INTERNALCONTROL_ID');

            if($request->INTERNALCONTROL_OBJECTIVE != '' || $request->INTERNALCONTROL_OBJECTIVE != null){
    
            $INTERNALCONTROL_OBJECTIVE = $request->INTERNALCONTROL_OBJECTIVE;
                               
            $number =count($INTERNALCONTROL_OBJECTIVE);
            $count = 0;
            for($count = 0; $count< $number; $count++)
            { 

            $add_sub = new Risk_internalcontrol_sub();
            $add_sub->INTERNALCONTROL_ID = $id_control;      
            $add_sub->INTERNALCONTROL_OBJECTIVE = $INTERNALCONTROL_OBJECTIVE[$count];                               
            $add_sub->save(); 
            }
        }   
        
        if($request->INTERNALCONTROL_SUBSUB_NAME != '' || $request->INTERNALCONTROL_SUBSUB_NAME != null){
    
            $INTERNALCONTROL_SUBSUB_NAME = $request->INTERNALCONTROL_SUBSUB_NAME;
                                
            $number =count($INTERNALCONTROL_SUBSUB_NAME);
            $count = 0;
            for($count = 0; $count< $number; $count++)
            { 

            $add_subsub = new Risk_internalcontrol_subsub();
            $add_subsub->INTERNALCONTROL_ID = $id_control; 
            $add_subsub->INTERNALCONTROL_SUBSUB_NAME = $INTERNALCONTROL_SUBSUB_NAME[$count];                               
            $add_subsub->save(); 
            }
        } 

        if($request->INTERNALCONTROL_SUBSUB_NAME != '' || $request->INTERNALCONTROL_SUBSUB_NAME != null){
    
            $INTERNALCONTROL_SUBSUB_NAME = $request->INTERNALCONTROL_SUBSUB_NAME;
                                
            $number =count($INTERNALCONTROL_SUBSUB_NAME);
            $count = 0;
            for($count = 0; $count< $number; $count++)
            { 

            $add_subsub_detail_sub = new Risk_internalcontrol_subsub_detail_sub();
            $add_subsub_detail_sub->INTERNALCONTROL_ID = $id_control; 
            $add_subsub_detail_sub->INTERNALCONTROL_SUBSUB_DETAIL_SUB_NAME = $INTERNALCONTROL_SUBSUB_NAME[$count];                               
            $add_subsub_detail_sub->save(); 
            }
        }  


        return redirect()->route('mrisk.internalcontrol');
    }
    public function internalcontrol_subsub_add(Request $request,$idref)
    {    
        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;        }

        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';
        $status = '';
        $search = '';
        $year_id = $yearbudget;



        $internalcontrol = Risk_internalcontrol::where('INTERNALCONTROL_ID','=',$idref)->first();
        $internalcontrol_sub = Risk_internalcontrol_sub::where('INTERNALCONTROL_ID','=',$idref)->get();
        $internalcontrol_subsub = Risk_internalcontrol_subsub::where('INTERNALCONTROL_ID','=',$idref)->get();

        $departmentsub = DB::table('hrd_department_sub')->where('ACTIVE','=','True')->get();

        $infodepartmentsub = DB::table('hrd_department_sub')
        ->leftjoin('hrd_person','hrd_department_sub.LEADER_HR_ID','=','hrd_person.ID')
        ->where('ACTIVE','=','True')->get();



        return view('manager_risk.internalcontrol_subsub_add',[
            'internalcontrol'=>$internalcontrol,
            'internalcontrol_subs'=>$internalcontrol_sub,
            'internalcontrol_subsubs'=>$internalcontrol_subsub,
            'infodepartmentsubs' =>$infodepartmentsub,
            'departmentsubs'=>$departmentsub,
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id,
        ]);
    }
    
    //=======================================================================//

    public function internalcontrol_subsub_detailadd(Request $request,$idref)
    {    
        $m_budget = date("m");
            if($m_budget>9){
            $yearbudget = date("Y")+544;
            }else{
            $yearbudget = date("Y")+543;        }

            $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

            $displaydate_bigen = ($yearbudget-544).'-10-01';
            $displaydate_end = ($yearbudget-543).'-09-30';
            $status = '';
            $search = '';
        $year_id = $yearbudget;

        $internalcontrol = Risk_internalcontrol::where('INTERNALCONTROL_ID','=',$idref)->first();
        $internalcontrol_subsub_detail = Risk_internalcontrol_subsub::where('INTERNALCONTROL_ID','=',$idref)->first();
        $risk_subsub_detail_sub = Risk_internalcontrol_subsub_detail_sub::where('INTERNALCONTROL_ID','=',$idref)->get();
       

        return view('manager_risk.internalcontrol_subsub_detailadd',[            
           
            'internalcontrol'=>$internalcontrol,
            'internalcontrol_subsub_details'=>$internalcontrol_subsub_detail,
            'risk_subsub_detail_subs'=>$risk_subsub_detail_sub,
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id,
        ]);
    }
    public function internalcontrol_subsub_detailadd_save(Request $request)
    {

         $idref = $request->INTERNALCONTROL_ID;
         $idsub = $request->INTERNALCONTROL_SUBSUB_ID;
        Risk_internalcontrol_subsub_detail_sub::where('INTERNALCONTROL_ID', '=', $idref )->delete();

        if($request->INTERNALCONTROL_SUBSUB_DETAIL_SUB_NAME != '' || $request->INTERNALCONTROL_SUBSUB_DETAIL_SUB_NAME != null){
    
            $INTERNALCONTROL_SUBSUB_DETAIL_SUB_NAME = $request->INTERNALCONTROL_SUBSUB_DETAIL_SUB_NAME;
            $INTERNALCONTROL_SUBSUB_DETAIL_SUB_DOWN = $request->INTERNALCONTROL_SUBSUB_DETAIL_SUB_DOWN;
            $INTERNALCONTROL_SUBSUB_DETAIL_SUB_MAKE = $request->INTERNALCONTROL_SUBSUB_DETAIL_SUB_MAKE;
                               
            $number =count($INTERNALCONTROL_SUBSUB_DETAIL_SUB_NAME);
            $count = 0;
            for($count = 0; $count< $number; $count++)
            { 
                $add_subsub_detail = new Risk_internalcontrol_subsub_detail_sub();
                $add_subsub_detail->INTERNALCONTROL_ID = $idref;   
                $add_subsub_detail->INTERNALCONTROL_SUBSUB_ID = $idsub;    
                $add_subsub_detail->INTERNALCONTROL_SUBSUB_DETAIL_SUB_NAME = $INTERNALCONTROL_SUBSUB_DETAIL_SUB_NAME[$count];  
                $add_subsub_detail->INTERNALCONTROL_SUBSUB_DETAIL_SUB_DOWN = $INTERNALCONTROL_SUBSUB_DETAIL_SUB_DOWN[$count]; 
                $add_subsub_detail->INTERNALCONTROL_SUBSUB_DETAIL_SUB_MAKE = $INTERNALCONTROL_SUBSUB_DETAIL_SUB_MAKE[$count];                              
                $add_subsub_detail->save(); 
            }
        }   

        Risk_internalcontrol_subsub::where('INTERNALCONTROL_ID', '=', $idref )->delete();

        if($request->INTERNALCONTROL_SUBSUB_DETAIL_SUB_NAME != '' || $request->INTERNALCONTROL_SUBSUB_DETAIL_SUB_NAME != null){
    
            $INTERNALCONTROL_SUBSUB_DETAIL_SUB_NAME = $request->INTERNALCONTROL_SUBSUB_DETAIL_SUB_NAME;
                                
            $number =count($INTERNALCONTROL_SUBSUB_DETAIL_SUB_NAME);
            $count = 0;
            for($count = 0; $count< $number; $count++)
            { 

            $add_subsub = new Risk_internalcontrol_subsub();
            $add_subsub->INTERNALCONTROL_ID = $idref; 
            $add_subsub->INTERNALCONTROL_SUBSUB_NAME = $INTERNALCONTROL_SUBSUB_DETAIL_SUB_NAME[$count];                               
            $add_subsub->save(); 
            }
        }
        return redirect()->route('mrisk.internalcontrol_subsub_add',[
            'idref'=>$idref,
            
        ]);
    }

    //=======================================================================//
    
    public function internalcontrol_subsub_detailadd_make(Request $request,$idref)
    {    
        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;        }

        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';
        $status = '';
        $search = '';
        $year_id = $yearbudget;

        $internalcontrol = Risk_internalcontrol::where('INTERNALCONTROL_ID','=',$idref)->first();
        $internalcontrol_subsub_detail = Risk_internalcontrol_subsub::where('INTERNALCONTROL_ID','=',$idref)->first();
        $risk_subsub_detail_make = Risk_internalcontrol_subsub_detail_make::where('INTERNALCONTROL_ID','=',$idref)->get();


        return view('manager_risk.internalcontrol_subsub_detailadd_make',[
            'internalcontrol'=>$internalcontrol,
            'risk_subsub_detail_makes'=>$risk_subsub_detail_make,
            'internalcontrol_subsub_details'=>$internalcontrol_subsub_detail,          
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id,
        ]);
    }
    public function internalcontrol_subsub_detailadd_make_save(Request $request)
    {

         $idref = $request->INTERNALCONTROL_ID;
         $idsub = $request->INTERNALCONTROL_SUBSUB_ID;
         Risk_internalcontrol_subsub_detail_make::where('INTERNALCONTROL_SUBSUB_ID', '=', $idsub )->delete();

        if($request->INTERNALCONTROL_SUBSUB_DETAIL_MAKE_DETAIL != '' || $request->INTERNALCONTROL_SUBSUB_DETAIL_MAKE_DETAIL != null){
    
            $INTERNALCONTROL_SUBSUB_DETAIL_MAKE_DETAIL = $request->INTERNALCONTROL_SUBSUB_DETAIL_MAKE_DETAIL;
            $INTERNALCONTROL_SUBSUB_DETAIL_MAKE_RISK = $request->INTERNALCONTROL_SUBSUB_DETAIL_MAKE_RISK;
            $INTERNALCONTROL_SUBSUB_DETAIL_MAKE_NORISK = $request->INTERNALCONTROL_SUBSUB_DETAIL_MAKE_NORISK;
                               
            $number =count($INTERNALCONTROL_SUBSUB_DETAIL_MAKE_DETAIL);
            $count = 0;
            for($count = 0; $count< $number; $count++)
            { 
                $add_subsub_detail = new Risk_internalcontrol_subsub_detail_make();
                $add_subsub_detail->INTERNALCONTROL_ID = $idref;   
                $add_subsub_detail->INTERNALCONTROL_SUBSUB_ID = $idsub;    
                $add_subsub_detail->INTERNALCONTROL_SUBSUB_DETAIL_MAKE_DETAIL = $INTERNALCONTROL_SUBSUB_DETAIL_MAKE_DETAIL[$count];  
                $add_subsub_detail->INTERNALCONTROL_SUBSUB_DETAIL_MAKE_RISK = $INTERNALCONTROL_SUBSUB_DETAIL_MAKE_RISK[$count]; 
                $add_subsub_detail->INTERNALCONTROL_SUBSUB_DETAIL_MAKE_NORISK = $INTERNALCONTROL_SUBSUB_DETAIL_MAKE_NORISK[$count];                              
                $add_subsub_detail->save(); 
            }
        }   

        return redirect()->route('mrisk.internalcontrol_subsub_add',[
            'idref'=>$idref,
            
        ]);
    }

//=======================================================================//

    public function internalcontrol_subsub_detailadd_risk(Request $request,$idref)
    {    
        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;        }

        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';
        $status = '';
        $search = '';
        $year_id = $yearbudget;

        $internalcontrol = Risk_internalcontrol::where('INTERNALCONTROL_ID','=',$idref)->first();
        $internalcontrol_subsub_detail = Risk_internalcontrol_subsub::where('INTERNALCONTROL_ID','=',$idref)->first();
        $risk_subsub_detail_risk = Risk_internalcontrol_subsub_detail_risk::where('INTERNALCONTROL_ID','=',$idref)->get();

        return view('manager_risk.internalcontrol_subsub_detailadd_risk',[
            'internalcontrol'=>$internalcontrol,
            'risk_subsub_detail_risks'=>$risk_subsub_detail_risk,
            'internalcontrol_subsub_details'=>$internalcontrol_subsub_detail,
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id,
        ]);
    }

    public function internalcontrol_subsub_detailadd_risk_save(Request $request)
    {

         $idref = $request->INTERNALCONTROL_ID;
         $idsub = $request->INTERNALCONTROL_SUBSUB_ID;
         Risk_internalcontrol_subsub_detail_risk::where('INTERNALCONTROL_SUBSUB_ID', '=', $idsub )->delete();
        

        if($request->INTERNALCONTROL_SUBSUB_DETAIL_RISK_MOTIVE != '' || $request->INTERNALCONTROL_SUBSUB_DETAIL_RISK_MOTIVE != null){
    
            $INTERNALCONTROL_SUBSUB_DETAIL_RISK_MOTIVE = $request->INTERNALCONTROL_SUBSUB_DETAIL_RISK_MOTIVE;
            $INTERNALCONTROL_SUBSUB_DETAIL_RISK_MOTIVE_EDIT = $request->INTERNALCONTROL_SUBSUB_DETAIL_RISK_MOTIVE_EDIT;
            $INTERNALCONTROL_SUBSUB_DETAIL_RISK_DEPART = $request->INTERNALCONTROL_SUBSUB_DETAIL_RISK_DEPART;
                               
            $number =count($INTERNALCONTROL_SUBSUB_DETAIL_RISK_MOTIVE);
            $count = 0;
            for($count = 0; $count< $number; $count++)
            { 
                $add_subsub_detail = new Risk_internalcontrol_subsub_detail_risk();
                $add_subsub_detail->INTERNALCONTROL_ID = $idref;   
                $add_subsub_detail->INTERNALCONTROL_SUBSUB_ID = $idsub;    
                $add_subsub_detail->INTERNALCONTROL_SUBSUB_DETAIL_RISK_MOTIVE = $INTERNALCONTROL_SUBSUB_DETAIL_RISK_MOTIVE[$count];  
                $add_subsub_detail->INTERNALCONTROL_SUBSUB_DETAIL_RISK_MOTIVE_EDIT = $INTERNALCONTROL_SUBSUB_DETAIL_RISK_MOTIVE_EDIT[$count]; 
                $add_subsub_detail->INTERNALCONTROL_SUBSUB_DETAIL_RISK_DEPART = $INTERNALCONTROL_SUBSUB_DETAIL_RISK_DEPART[$count];                              
                $add_subsub_detail->save(); 
            }
        }   

        return redirect()->route('mrisk.internalcontrol_subsub_add',[
            'idref'=>$idref,
            
        ]);
    }
   //=======================================================================//

    public function internalcontrol_subsub_detailadd_sub(Request $request,$idref,$idsub,$idaddsub)
    {    
        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;        }

        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';
        $status = '';
        $search = '';
        $year_id = $yearbudget;

        $internalcontrol = Risk_internalcontrol::where('INTERNALCONTROL_ID','=',$idref)->first();
        $internalcontrol_sub = Risk_internalcontrol_sub::where('INTERNALCONTROL_ID','=',$idref)->get();
        $internalcontrol_subsub = Risk_internalcontrol_subsub::where('INTERNALCONTROL_ID','=',$idref)->get();
        
        $internalcontrol_subsub_detail = Risk_internalcontrol_subsub::where('INTERNALCONTROL_SUBSUB_ID','=',$idsub)->first();

        $departmentsub = DB::table('hrd_department_sub')->where('ACTIVE','=','True')->get();

        $infodepartmentsub = DB::table('hrd_department_sub')
        ->leftjoin('hrd_person','hrd_department_sub.LEADER_HR_ID','=','hrd_person.ID')
        ->where('ACTIVE','=','True')->get();



        return view('manager_risk.internalcontrol_subsub_detailadd_sub',[
            'internalcontrol'=>$internalcontrol,
            'internalcontrol_subs'=>$internalcontrol_sub,
            'internalcontrol_subsubs'=>$internalcontrol_subsub,
            'internalcontrol_subsub_details'=>$internalcontrol_subsub_detail,
            'infodepartmentsubs' =>$infodepartmentsub,
            'departmentsubs'=>$departmentsub,
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id,
        ]);
    } 
 
    public function savesubsub_detail(Request $request)
    {

        $idref = $request->INTERNALCONTROL_ID;
        $idsub = $request->INTERNALCONTROL_SUBSUB_ID;

         if($request->INTERNALCONTROL_SUBSUB_DETAIL_NAME[0] != '' || $request->INTERNALCONTROL_SUBSUB_DETAIL_NAME[0] != null){            

            $INTERNALCONTROL_ID = $request->INTERNALCONTROL_ID;
            $INTERNALCONTROL_SUBSUB_ID = $request->INTERNALCONTROL_SUBSUB_ID;
            $INTERNALCONTROL_SUBSUB_DETAIL_NAME = $request->INTERNALCONTROL_SUBSUB_DETAIL_NAME;
                       

            $number =count($INTERNALCONTROL_SUBSUB_DETAIL_NAME);
            $count = 0;
            for($count = 0; $count < $number; $count++)
            {                
               $addsup = new Risk_internalcontrol_subsub_detail();
               $addsup->INTERNALCONTROL_ID = $INTERNALCONTROL_ID;
               $addsup->INTERNALCONTROL_SUBSUB_ID = $INTERNALCONTROL_SUBSUB_ID;
               $addsup->INTERNALCONTROL_SUBSUB_DETAIL_NAME = $INTERNALCONTROL_SUBSUB_DETAIL_NAME[$count];                  
               $addsup->save();                 
               
            }
        }
    
        return redirect()->route('mrisk.internalcontrol_subsub_detailadd',[
            'idref'=> $request->INTERNALCONTROL_ID,
            'idsub' => $request->INTERNALCONTROL_SUBSUB_ID
         ]);
 

    }
    public function internalcontrol_edit(Request $request,$idref)
    {    
        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;        }

        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';
        $status = '';
        $search = '';
        $year_id = $yearbudget;



        $internalcontrol = Risk_internalcontrol::where('INTERNALCONTROL_ID','=',$idref)->first();
        $internalcontrol_sub = Risk_internalcontrol_sub::where('INTERNALCONTROL_ID','=',$idref)->get();
        $internalcontrol_subsub = Risk_internalcontrol_subsub::where('INTERNALCONTROL_ID','=',$idref)->get();

        $departmentsub = DB::table('hrd_department_sub')->where('ACTIVE','=','True')->get();

        $infodepartmentsub = DB::table('hrd_department_sub')
        ->leftjoin('hrd_person','hrd_department_sub.LEADER_HR_ID','=','hrd_person.ID')
        ->where('ACTIVE','=','True')->get();



        return view('manager_risk.internalcontrol_edit',[
            'internalcontrol'=>$internalcontrol,
            'internalcontrol_subs'=>$internalcontrol_sub,
            'internalcontrol_subsubs'=>$internalcontrol_subsub,
            'infodepartmentsubs' =>$infodepartmentsub,
            'departmentsubs'=>$departmentsub,
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id,
        ]);
    }


    public function internalcontrol_update(Request $request)
    {    
       
        $checkdigget= $request->INTERNALCONTROL_DATE;
        if($checkdigget != ''){           
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $checkdigget)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0];             
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $icontrol_date= $y_st."-".$m_st."-".$d_st;   
            }else{
            $icontrol_date= null;
        }

        $datebigin = $request->get('DATE_BIGIN');
            $dateend = $request->get('DATE_END');

            $date_bigen_c = Carbon::createFromFormat('d/m/Y', $datebigin)->format('Y-m-d');
            $date_arrary=explode("-",$date_bigen_c);
        
            $y_sub_st = $date_arrary[0];
        
            if($y_sub_st >= 2500){
                $y = $y_sub_st-543;
            }else{
                $y = $y_sub_st;
            }
        
            $m = $date_arrary[1];
            $d = $date_arrary[2];  
            $displaydate_bigen= $y."-".$m."-".$d;
        
            $date_end_c = Carbon::createFromFormat('d/m/Y', $dateend)->format('Y-m-d');
            $date_arrary_e=explode("-",$date_end_c); 
        
            $y_sub_e = $date_arrary_e[0];
        
            if($y_sub_e >= 2500){
                $y_e = $y_sub_e-543;
            }else{
                $y_e = $y_sub_e;
            }
        
            $m_e = $date_arrary_e[1];
            $d_e = $date_arrary_e[2];  
            $displaydate_end= $y_e."-".$m_e."-".$d_e;
        
            $date = date('Y-m-d');
            $date_bigen_checks = strtotime($displaydate_bigen);
            $date_end_checks =  strtotime($displaydate_end);
            $dates =  strtotime($date);
        
            $from = date($displaydate_bigen);
            $to = date($displaydate_end);

            $id = $request->INTERNALCONTROL_ID;
            $update = Risk_internalcontrol::find($id);            
            $update->INTERNALCONTROL_DATE = $icontrol_date; 
            $update->INTERNALCONTROL_GROUP_NAME = $request->INTERNALCONTROL_GROUP_NAME; 
            $update->INTERNALCONTROL_HEAD_WORK = $request->INTERNALCONTROL_HEAD_WORK; 
            $update->INTERNALCONTROL_YEAR = $request->BUDGET_YEAR;
            $update->INTERNALCONTROL_START_DAY = $from;
            $update->INTERNALCONTROL_END_DAY =  $to;
            $update->INTERNALCONTROL_POSITION = $request->INTERNALCONTROL_POSITION; 
            $update->INTERNALCONTROL_MISSION = $request->INTERNALCONTROL_MISSION; 
            $update->save();

            $INTERNALCONTROL_ID = $id;
            Risk_internalcontrol_sub::where('INTERNALCONTROL_ID','=',$id)->delete(); 
           
            if($request->INTERNALCONTROL_OBJECTIVE[0] != '' || $request->INTERNALCONTROL_OBJECTIVE[0] != null){
            
                $INTERNALCONTROL_OBJECTIVE = $request->INTERNALCONTROL_OBJECTIVE;                           
    
                $number =count($INTERNALCONTROL_OBJECTIVE);
                $count = 0;
                for($count = 0; $count < $number; $count++)
                {                
                   $addsup = new Risk_internalcontrol_sub();
                   $addsup->INTERNALCONTROL_ID = $INTERNALCONTROL_ID;
                   $addsup->INTERNALCONTROL_OBJECTIVE = $INTERNALCONTROL_OBJECTIVE[$count];                  
                   $addsup->save();                 
                   
                }
            }
            Risk_internalcontrol_subsub::where('INTERNALCONTROL_ID','=',$id)->delete(); 
           
            if($request->INTERNALCONTROL_SUBSUB_NAME[0] != '' || $request->INTERNALCONTROL_SUBSUB_NAME[0] != null){
            
                $INTERNALCONTROL_SUBSUB_NAME = $request->INTERNALCONTROL_SUBSUB_NAME;                           
    
                $number =count($INTERNALCONTROL_SUBSUB_NAME);
                $count = 0;
                for($count = 0; $count < $number; $count++)
                {                
                   $addsupsub = new Risk_internalcontrol_subsub();
                   $addsupsub->INTERNALCONTROL_ID = $INTERNALCONTROL_ID;
                   $addsupsub->INTERNALCONTROL_SUBSUB_NAME = $INTERNALCONTROL_SUBSUB_NAME[$count];                  
                   $addsupsub->save();                 
                   
                }
            }


            return redirect()->action('ManagerriskController@internalcontrol');



    }
    public function internalcontrol_destroy(Request $request,$id)
    {    
        Risk_internalcontrol::destroy($id);
       
        return redirect()->action('ManagerriskController@internalcontrol');
    }

    public function internalcontrol_sub()
    {    
        return view('manager_risk.internalcontrol_sub');
    }


  
    public function internalcontrol_sub_add()
    {    
        return view('manager_risk.internalcontrol_sub_add');
    }

//================start=====incidence================================//
    public function alert_save(Request $request)
    {
        $add = new Alerttest(); 
        $add->name = $request->NAME; 
        $add->save();
        

        return redirect()->route('mrisk.incidence');
    }

    public function incidence()
    {    
        $incidence = Incidence::get();
        return view('manager_risk.incidence',[
            'incidences' => $incidence
        ]);
    }
    public function incidence_add()
    {    
        return view('manager_risk.incidence_add');
    }
    public function incidence_save(Request $request)
    {    
        $checkbeget= $request->RISK_INCIDENCE_BEGET_DATE;
        if($checkbeget != ''){           
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $checkbeget)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0];             
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $begetdate= $y_st."-".$m_st."-".$d_st;   
            }else{
            $begetdate= null;
        } 
        $checkdigget= $request->RISK_INCIDENCE_DIG_DATE;
        if($checkdigget != ''){           
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $checkdigget)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0];             
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $digdate= $y_st."-".$m_st."-".$d_st;   
            }else{
            $digdate= null;
        }           
        $add = new Incidence();   
             $add->RISK_INCIDENCE_BEGET_DATE = $begetdate;
             $add->RISK_INCIDENCE_DIG_DATE = $digdate; 
             $add->RISK_INCIDENCE_DEPARTMENT = $request->RISK_INCIDENCE_DEPARTMENT; 
             $add->RISK_INCIDENCE_ORIGIN = $request->RISK_INCIDENCE_ORIGIN; 
             $add->RISK_INCIDENCE_TYPEORIGIN = $request->RISK_INCIDENCE_TYPEORIGIN; 
             $add->RISK_INCIDENCE_TITLE = $request->RISK_INCIDENCE_TITLE; 
             $add->RISK_INCIDENCE_SUB = $request->RISK_INCIDENCE_SUB; 
             $add->RISK_INCIDENCE_INFER = $request->RISK_INCIDENCE_INFER; 
             $add->RISK_INCIDENCE_LEVEL = $request->RISK_INCIDENCE_LEVEL; 
             $add->RISK_INCIDENCE_USER = $request->RISK_INCIDENCE_USER; 
             $add->RISK_INCIDENCE_SEX = $request->RISK_INCIDENCE_SEX; 
             $add->RISK_INCIDENCE_AGE = $request->RISK_INCIDENCE_AGE; 
             $add->RISK_INCIDENCE_PHASE_FATE = $request->RISK_INCIDENCE_PHASE_FATE; 
             $add->RISK_INCIDENCE_LOCATION = $request->RISK_INCIDENCE_LOCATION; 
             $add->RISK_INCIDENCE_DETAIL = $request->RISK_INCIDENCE_DETAIL; 
             $add->RISK_INCIDENCE_DOCUMENT_ONE = $request->RISK_INCIDENCE_DOCUMENT_ONE; 
             $add->RISK_INCIDENCE_BASICMANAGE = $request->RISK_INCIDENCE_BASICMANAGE; 
             $add->RISK_INCIDENCE_DOCUMENT_TWO = $request->RISK_INCIDENCE_DOCUMENT_TWO;  
        $add->save();    
      
        Session::flash('statussuccess','info');
        return redirect()->route('mrisk.incidence')->with('status','Save Success');
    }
    public function incidence_edit(Request $request,$id)
    {    
        $incidence = Incidence::where('RISK_INCIDENCE_ID','=',$id)->first();

        return view('manager_risk.incidence_edit',[
            'incidences' => $incidence,
        ]);
    }
    public function incidence_update(Request $request)
    {    
        $checkbeget= $request->RISK_INCIDENCE_BEGET_DATE;
        if($checkbeget != ''){           
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $checkbeget)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0];             
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $begetdate= $y_st."-".$m_st."-".$d_st;   
            }else{
            $begetdate= null;
        } 
        $checkdigget= $request->RISK_INCIDENCE_DIG_DATE;
        if($checkdigget != ''){           
            $STARTDAY = Carbon::createFromFormat('d/m/Y', $checkdigget)->format('Y-m-d');
            $date_arrary_st=explode("-",$STARTDAY);  
            $y_sub_st = $date_arrary_st[0];             
            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];  
            $digdate= $y_st."-".$m_st."-".$d_st;   
            }else{
            $digdate= null;
        }
        $id = $request->RISK_INCIDENCE_ID;
            $update = Incidence::find($id);
            $update->RISK_INCIDENCE_BEGET_DATE = $begetdate;
            $update->RISK_INCIDENCE_DIG_DATE = $digdate; 
            $update->RISK_INCIDENCE_DEPARTMENT = $request->RISK_INCIDENCE_DEPARTMENT; 
            $update->RISK_INCIDENCE_ORIGIN = $request->RISK_INCIDENCE_ORIGIN; 
            $update->RISK_INCIDENCE_TYPEORIGIN = $request->RISK_INCIDENCE_TYPEORIGIN; 
            $update->RISK_INCIDENCE_TITLE = $request->RISK_INCIDENCE_TITLE; 
            $update->RISK_INCIDENCE_SUB = $request->RISK_INCIDENCE_SUB; 
            $update->RISK_INCIDENCE_INFER = $request->RISK_INCIDENCE_INFER; 
            $update->RISK_INCIDENCE_LEVEL = $request->RISK_INCIDENCE_LEVEL; 
            $update->RISK_INCIDENCE_USER = $request->RISK_INCIDENCE_USER; 
            $update->RISK_INCIDENCE_SEX = $request->RISK_INCIDENCE_SEX; 
            $update->RISK_INCIDENCE_AGE = $request->RISK_INCIDENCE_AGE; 
            $update->RISK_INCIDENCE_PHASE_FATE = $request->RISK_INCIDENCE_PHASE_FATE; 
            $update->RISK_INCIDENCE_LOCATION = $request->RISK_INCIDENCE_LOCATION; 
            $update->RISK_INCIDENCE_DETAIL = $request->RISK_INCIDENCE_DETAIL; 
            $update->RISK_INCIDENCE_DOCUMENT_ONE = $request->RISK_INCIDENCE_DOCUMENT_ONE; 
            $update->RISK_INCIDENCE_BASICMANAGE = $request->RISK_INCIDENCE_BASICMANAGE; 
            $update->RISK_INCIDENCE_DOCUMENT_TWO = $request->RISK_INCIDENCE_DOCUMENT_TWO; 
        $update->save();

        return redirect()->route('mrisk.incidence');
    }
    public function incidence_destroy(Request $request,$id)
    {    
        Incidence::destroy($id);
        return redirect()->back()->with('flash_message','Delete Success');
     
    }
    public function delete($id)
    {    
        $del = Incidence::findOrFail($id);
        $del->delete();
        return response()->json(['status'=>'Delete Success']);
        
    }
  //================End=====incidence================================//

//------------------------Start Report------------------------------------//

  public function report_riskincedentsprofile()
  {    
    $infoper = DB::table('hrd_person')->get();
    $departsub = DB::table('hrd_department_sub_sub')->where('ACTIVE','=','True')->get();
    $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'asc')->get();             //ปี
    $mount = DB::table('leave_month')->get();
    $level = DB::table('risk_setupincidence_level')->get();                                //ระดับ
    $typelocation = DB::table('risk_setupincidence_tpyelocation')->get();
    $grouplocation = DB::table('risk_setupincidence_grouplocation')->get();
    $worktime = DB::table('risk_workingtime')->get();
    $status = DB::table('risk_setupincidence_status')->get();        
    
    $location = DB::table('risk_setupincidence_location')->get();    
    $setting = DB::table('risk_setincidence_setting')->get();
    $incidentsub = DB::table('risk_setupincidence_sub')->get();
    $origin = DB::table('risk_setupincidence_origin')->get();
    $depart = DB::table('hrd_department')->where('ACTIVE','=','True')->get();
    $categorydepart = DB::table('risk_category_department')->get();                 //ประเภทหน่วยงาน

    $reportheader = DB::table('risk_setupincidence_reportheader')->get();   // รายงานโดยใช้
    $incidence_report = DB::table('risk_setupincidence_report')->get();   // การรายงานอุบัติการณ์
    $incidence_modify = DB::table('risk_setupincidence_modify')->get();   // การแก้ไขอุบัติการณ์

    $rigrep = Riskrep::leftjoin('risk_setincidence_setting','risk_rep.RISKREP_TITLE','=','risk_setincidence_setting.INCIDENCE_SETTING_ID')
    ->leftjoin('risk_status','risk_rep.RISKREP_STATUS','=','risk_status.RISK_STATUS_NAME')
    ->leftJoin('risk_rep_level','risk_rep.RISKREP_LEVEL','=','risk_rep_level.RISK_REP_LEVEL_ID')
    ->leftjoin('risk_setupincidence_location','risk_rep.RISKREP_SEARCHLOCATE','=','risk_setupincidence_location.INCIDENCE_LOCATION_ID')
    ->leftjoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','risk_rep.RISKREP_DEPARTMENT_SUB')
    ->leftjoin('risk_setupincidence_tpyelocation','risk_setupincidence_tpyelocation.SETUP_TYPELOCATION_ID','=','risk_rep.RISKREP_TYPE')
    ->leftjoin('risk_setupincidence_grouplocation','risk_setupincidence_grouplocation.SETUP_GROUPLOCATION_ID','=','risk_rep.RISKREP_LOCAL')
    ->leftjoin('risk_setupincidence_sub','risk_setupincidence_sub.INCIDENCE_SUB_ID','=','risk_rep.RISKREP_SUBTITLE')
    ->leftjoin('hrd_sex','hrd_sex.SEX_ID','=','risk_rep.RISKREP_SEX')
    ->orderBy('RISKREP_ID','DESC')
    ->get();

    $m_budget = date("m");
    if($m_budget>9){
    $yearbudget = date("Y")+544;
    }else{
    $yearbudget = date("Y")+543;   
     }

    $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

    $displaydate_bigen = ($yearbudget-544).'-10-01';
    $displaydate_end = ($yearbudget-543).'-09-30';
    $status = '';
    $search = '';
    $year_id = $yearbudget;  
    
    $status = DB::table('risk_status')->get();
    $repeat = DB::table('risk_notify_repeat_sub')->where('STATUS_REPEAT','=','REPEAT')->count();
    $accept = DB::table('risk_notify_accept_sub')->where('STATUS_ACCEPT','=','ACCEPT')->count();

      return view('manager_risk.report_riskincedentsprofile',[
        'rigreps'=>$rigrep,        
        'departsubs'=>$departsub,        
        'typelocations'=>$typelocation,
        'locations'=>$location,
        'levels'=>$level,
        'settings'=>$setting,
        'incidentsubs'=>$incidentsub,
        'origins'=>$origin,
        'budgets'=>$budget,
        'mounts'=>$mount,
        'grouplocations'=>$grouplocation,
        'worktimes'=>$worktime,
        'statuss'=>$status,
        'infopers'=>$infoper,
        'departs'=>$depart,
        'reportheaders'=>$reportheader,
        'incidence_reports'=>$incidence_report,
        'incidence_modifys'=>$incidence_modify,
        'categorydeparts'=>$categorydepart,
        'displaydate_bigen'=> $displaydate_bigen,
        'displaydate_end'=> $displaydate_end,
        'status_check'=> $status,
        'search'=> $search,
        'year_id'=>$year_id,
        'repeat'=>$repeat,
        'accept'=>$accept,
        'statuss'=>$status,
      ]);
  }

  public function report_riskincedentsprofile_search(Request $request)
  {    

    $search = $request->get('search');
    $status = $request->STATUS_CODE;
    $datebigin = $request->get('DATE_BIGIN');
    $dateend = $request->get('DATE_END');
    $yearbudget = $request->BUDGET_YEAR; 

   // การแก้ไขอุบัติการณ์

    if($search==''){
        $search="";
    }

    $date_bigen_c = Carbon::createFromFormat('d/m/Y', $datebigin)->format('Y-m-d');
    $date_arrary=explode("-",$date_bigen_c);

    $y_sub_st = $date_arrary[0];

    if($y_sub_st >= 2500){
        $y = $y_sub_st-543;
    }else{
        $y = $y_sub_st;
    }

    $m = $date_arrary[1];
    $d = $date_arrary[2];  
    $displaydate_bigen= $y."-".$m."-".$d;

    $date_end_c = Carbon::createFromFormat('d/m/Y', $dateend)->format('Y-m-d');
    $date_arrary_e=explode("-",$date_end_c); 

    $y_sub_e = $date_arrary_e[0];

    if($y_sub_e >= 2500){
        $y_e = $y_sub_e-543;
    }else{
        $y_e = $y_sub_e;
    }

    $m_e = $date_arrary_e[1];
    $d_e = $date_arrary_e[2];  
    $displaydate_end= $y_e."-".$m_e."-".$d_e;
 

    $from = date($displaydate_bigen);
    $to = date($displaydate_end);
  
    if($status !== null && $status !== ''){
     
        $rigrep = Riskrep::leftjoin('risk_setincidence_setting','risk_rep.RISKREP_TITLE','=','risk_setincidence_setting.INCIDENCE_SETTING_ID')
        ->leftjoin('risk_status','risk_rep.RISKREP_STATUS','=','risk_status.RISK_STATUS_NAME')
        ->leftJoin('risk_rep_level','risk_rep.RISKREP_LEVEL','=','risk_rep_level.RISK_REP_LEVEL_ID')
        ->leftjoin('risk_setupincidence_location','risk_rep.RISKREP_SEARCHLOCATE','=','risk_setupincidence_location.INCIDENCE_LOCATION_ID')
        ->leftjoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','risk_rep.RISKREP_DEPARTMENT_SUB')
        ->leftjoin('risk_setupincidence_tpyelocation','risk_setupincidence_tpyelocation.SETUP_TYPELOCATION_ID','=','risk_rep.RISKREP_TYPE')
        ->leftjoin('risk_setupincidence_grouplocation','risk_setupincidence_grouplocation.SETUP_GROUPLOCATION_ID','=','risk_rep.RISKREP_LOCAL')
        ->leftjoin('risk_setupincidence_sub','risk_setupincidence_sub.INCIDENCE_SUB_ID','=','risk_rep.RISKREP_SUBTITLE')
        ->leftjoin('hrd_sex','hrd_sex.SEX_ID','=','risk_rep.RISKREP_SEX')
        ->where('risk_rep.RISKREP_STATUS','=',$status)
        ->where(function($q) use ($search){
            $q->where('RISK_REP_LEVEL_NAME','like','%'.$search.'%');
            $q->orwhere('RISKREP_BASICMANAGE','like','%'.$search.'%');
            $q->orwhere('RISKREP_DETAILRISK','like','%'.$search.'%'); 
            $q->orwhere('RISK_STATUS_NAME_TH','like','%'.$search.'%');   
            $q->orwhere('INCIDENCE_LOCATION_NAME','like','%'.$search.'%');   
            
        })
        ->WhereBetween('RISKREP_DATESAVE',[$from,$to]) 
        ->orderBy('RISKREP_ID','DESC')
        ->get();
         

    }else{
      

        $rigrep = Riskrep::leftjoin('risk_setincidence_setting','risk_rep.RISKREP_TITLE','=','risk_setincidence_setting.INCIDENCE_SETTING_ID')
        ->leftjoin('risk_status','risk_rep.RISKREP_STATUS','=','risk_status.RISK_STATUS_NAME')
        ->leftJoin('risk_rep_level','risk_rep.RISKREP_LEVEL','=','risk_rep_level.RISK_REP_LEVEL_ID')
        ->leftjoin('risk_setupincidence_location','risk_rep.RISKREP_SEARCHLOCATE','=','risk_setupincidence_location.INCIDENCE_LOCATION_ID')
        ->leftjoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','risk_rep.RISKREP_DEPARTMENT_SUB')
        ->leftjoin('risk_setupincidence_tpyelocation','risk_setupincidence_tpyelocation.SETUP_TYPELOCATION_ID','=','risk_rep.RISKREP_TYPE')
        ->leftjoin('risk_setupincidence_grouplocation','risk_setupincidence_grouplocation.SETUP_GROUPLOCATION_ID','=','risk_rep.RISKREP_LOCAL')
        ->leftjoin('risk_setupincidence_sub','risk_setupincidence_sub.INCIDENCE_SUB_ID','=','risk_rep.RISKREP_SUBTITLE')
        ->leftjoin('hrd_sex','hrd_sex.SEX_ID','=','risk_rep.RISKREP_SEX')
        ->where(function($q) use ($search){
            $q->where('RISK_REP_LEVEL_NAME','like','%'.$search.'%');
            $q->orwhere('RISKREP_BASICMANAGE','like','%'.$search.'%');
            $q->orwhere('RISKREP_DETAILRISK','like','%'.$search.'%'); 
            $q->orwhere('RISK_STATUS_NAME_TH','like','%'.$search.'%');   
            $q->orwhere('INCIDENCE_LOCATION_NAME','like','%'.$search.'%');   
            
        })
        ->WhereBetween('RISKREP_DATESAVE',[$from,$to]) 
        ->orderBy('RISKREP_ID','DESC')
        ->get();
         

    }

    
    $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();


    $status =  $status;
    $search = $search;
    $year_id = $yearbudget;  
    
    $status_info = DB::table('risk_status')->get();
    $repeat = DB::table('risk_notify_repeat_sub')->where('STATUS_REPEAT','=','REPEAT')->count();
    $accept = DB::table('risk_notify_accept_sub')->where('STATUS_ACCEPT','=','ACCEPT')->count();

    $infoper = DB::table('hrd_person')->get();
    $departsub = DB::table('hrd_department_sub_sub')->where('ACTIVE','=','True')->get();
    $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'asc')->get();             //ปี
    $mount = DB::table('leave_month')->get();
    $level = DB::table('risk_setupincidence_level')->get();                                //ระดับ
    $typelocation = DB::table('risk_setupincidence_tpyelocation')->get();
    $grouplocation = DB::table('risk_setupincidence_grouplocation')->get();
    $worktime = DB::table('risk_workingtime')->get();      
    
    $location = DB::table('risk_setupincidence_location')->get();    
    $setting = DB::table('risk_setincidence_setting')->get();
    $incidentsub = DB::table('risk_setupincidence_sub')->get();
    $origin = DB::table('risk_setupincidence_origin')->get();
    $depart = DB::table('hrd_department')->where('ACTIVE','=','True')->get();
    $categorydepart = DB::table('risk_category_department')->get();                 //ประเภทหน่วยงาน

    $reportheader = DB::table('risk_setupincidence_reportheader')->get();   // รายงานโดยใช้
    $incidence_report = DB::table('risk_setupincidence_report')->get();   // การรายงานอุบัติการณ์
    $incidence_modify = DB::table('risk_setupincidence_modify')->get();  

      return view('manager_risk.report_riskincedentsprofile',[
        'rigreps'=>$rigrep,        
        'departsubs'=>$departsub,        
        'typelocations'=>$typelocation,
        'locations'=>$location,
        'levels'=>$level,
        'settings'=>$setting,
        'incidentsubs'=>$incidentsub,
        'origins'=>$origin,
        'budgets'=>$budget,
        'mounts'=>$mount,
        'grouplocations'=>$grouplocation,
        'worktimes'=>$worktime,
        'infopers'=>$infoper,
        'departs'=>$depart,
        'reportheaders'=>$reportheader,
        'incidence_reports'=>$incidence_report,
        'incidence_modifys'=>$incidence_modify,
        'categorydeparts'=>$categorydepart,
        'displaydate_bigen'=> $displaydate_bigen,
        'displaydate_end'=> $displaydate_end,
        'status_check'=> $status,
        'search'=> $search,
        'year_id'=>$year_id,
        'repeat'=>$repeat,
        'accept'=>$accept,
        'statuss'=>$status_info,
        
      ]);
  }


  
  public function report_riskincedentsprofile_excel()
  {    
    $infoper = DB::table('hrd_person')->get();
    $departsub = DB::table('hrd_department_sub_sub')->where('ACTIVE','=','True')->get();
    $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'asc')->get();             //ปี
    $mount = DB::table('leave_month')->get();
    $level = DB::table('risk_setupincidence_level')->get();                                //ระดับ
    $typelocation = DB::table('risk_setupincidence_tpyelocation')->get();
    $grouplocation = DB::table('risk_setupincidence_grouplocation')->get();
    $worktime = DB::table('risk_workingtime')->get();
    $status = DB::table('risk_setupincidence_status')->get();        
    
    $location = DB::table('risk_setupincidence_location')->get();    
    $setting = DB::table('risk_setincidence_setting')->get();
    $incidentsub = DB::table('risk_setupincidence_sub')->get();
    $origin = DB::table('risk_setupincidence_origin')->get();
    $depart = DB::table('hrd_department')->where('ACTIVE','=','True')->get();
    $categorydepart = DB::table('risk_category_department')->get();                 //ประเภทหน่วยงาน

    $reportheader = DB::table('risk_setupincidence_reportheader')->get();   // รายงานโดยใช้
    $incidence_report = DB::table('risk_setupincidence_report')->get();   // การรายงานอุบัติการณ์
    $incidence_modify = DB::table('risk_setupincidence_modify')->get();   // การแก้ไขอุบัติการณ์

    $rigrep = Riskrep::leftjoin('risk_setincidence_setting','risk_rep.RISKREP_TITLE','=','risk_setincidence_setting.INCIDENCE_SETTING_ID')
    ->leftjoin('risk_status','risk_rep.RISKREP_STATUS','=','risk_status.RISK_STATUS_NAME')
    ->leftJoin('risk_rep_level','risk_rep.RISKREP_LEVEL','=','risk_rep_level.RISK_REP_LEVEL_ID')
    ->leftjoin('risk_setupincidence_location','risk_rep.RISKREP_SEARCHLOCATE','=','risk_setupincidence_location.INCIDENCE_LOCATION_ID')
    ->leftjoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','risk_rep.RISKREP_DEPARTMENT_SUB')
    ->leftjoin('risk_setupincidence_tpyelocation','risk_setupincidence_tpyelocation.SETUP_TYPELOCATION_ID','=','risk_rep.RISKREP_TYPE')
    ->leftjoin('risk_setupincidence_grouplocation','risk_setupincidence_grouplocation.SETUP_GROUPLOCATION_ID','=','risk_rep.RISKREP_LOCAL')
    ->leftjoin('risk_setupincidence_sub','risk_setupincidence_sub.INCIDENCE_SUB_ID','=','risk_rep.RISKREP_SUBTITLE')
    ->leftjoin('hrd_sex','hrd_sex.SEX_ID','=','risk_rep.RISKREP_SEX')
    ->orderBy('RISKREP_ID','DESC')
    ->get();

    $m_budget = date("m");
    if($m_budget>9){
    $yearbudget = date("Y")+544;
    }else{
    $yearbudget = date("Y")+543;   
     }

    $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

    $displaydate_bigen = ($yearbudget-544).'-10-01';
    $displaydate_end = ($yearbudget-543).'-09-30';
    $status = '';
    $search = '';
    $year_id = $yearbudget;  
    
    $status = DB::table('risk_status')->get();
    $repeat = DB::table('risk_notify_repeat_sub')->where('STATUS_REPEAT','=','REPEAT')->count();
    $accept = DB::table('risk_notify_accept_sub')->where('STATUS_ACCEPT','=','ACCEPT')->count();

      return view('manager_risk.report_riskincedentsprofile_excel',[
        'rigreps'=>$rigrep,        
        'departsubs'=>$departsub,        
        'typelocations'=>$typelocation,
        'locations'=>$location,
        'levels'=>$level,
        'settings'=>$setting,
        'incidentsubs'=>$incidentsub,
        'origins'=>$origin,
        'budgets'=>$budget,
        'mounts'=>$mount,
        'grouplocations'=>$grouplocation,
        'worktimes'=>$worktime,
        'statuss'=>$status,
        'infopers'=>$infoper,
        'departs'=>$depart,
        'reportheaders'=>$reportheader,
        'incidence_reports'=>$incidence_report,
        'incidence_modifys'=>$incidence_modify,
        'categorydeparts'=>$categorydepart,
        'displaydate_bigen'=> $displaydate_bigen,
        'displaydate_end'=> $displaydate_end,
        'status_check'=> $status,
        'search'=> $search,
        'year_id'=>$year_id,
        'repeat'=>$repeat,
        'accept'=>$accept,
        'statuss'=>$status,
      ]);
  }

  public function report_riskupdatefinish()
  {    
    $group = DB::table('risk_setincidence_group')->get();       //ประเภทเสี่ยง
    $category = DB::table('risk_setincidence_category')->get();        //กลุ่มเสี่ยง
    $category_sub = DB::table('risk_setincidence_category_sub')->get();      //หมวดเสี่ยง    
    $group_sub = DB::table('risk_setincidence_group_sub')->get();        //ประเภทเสี่ยงย่อย
    $level = DB::table('risk_setupincidence_level')->get();                //ระดับ
    $reportheader = DB::table('risk_setupincidence_reportheader')->get();   // รายงานโดยใช้
    $modify_leveldepartsub = DB::table('risk_setupincidence_modify_leveldepartsub')->get();   // ระดับกลุ่ม/หน่วยงานหลักที่แก้ไข
    $modify_departsub = DB::table('risk_setupincidence_modify_departsub')->get();   // กลุ่ม/หน่วยงานหลักที่แก้ไข
    $modify_today = DB::table('risk_setupincidence_modify_today')->get();   // = , >=

      return view('manager_risk.report_riskupdatefinish',[
        'groups'=>$group,
        'categorys'=>$category,
        'category_subs'=>$category_sub,
        'group_subs'=>$group_sub,
        'levels'=>$level,
        'reportheaders'=>$reportheader,
        'modify_leveldepartsubs'=>$modify_leveldepartsub,
        'modify_departsubs'=>$modify_departsub,
        'modify_todays'=>$modify_today,
      ]);
  }

  public function report_riskincidencelevel()
  {    
    $group = DB::table('risk_setincidence_group')->get();       //ประเภทเสี่ยง
    $category = DB::table('risk_setincidence_category')->get();        //กลุ่มเสี่ยง
    $category_sub = DB::table('risk_setincidence_category_sub')->get();      //หมวดเสี่ยง    
    $group_sub = DB::table('risk_setincidence_group_sub')->get();        //ประเภทเสี่ยงย่อย
    $reportheader = DB::table('risk_setupincidence_reportheader')->get();   // รายงานโดยใช้

    $riskprogram  = DB::table('risk_rep_program')->get();

    $m_budget = date("m");
    if($m_budget>9){
    $yearbudget = date("Y")+544;
    }else{
    $yearbudget = date("Y")+543;   
     }
    
    $displaydate_bigen = ($yearbudget-544).'-10-01';
    $displaydate_end = ($yearbudget-543).'-09-30';

    $search="";

      return view('manager_risk.report_riskincidencelevel',[
        'groups'=>$group,
        'categorys'=>$category,
        'category_subs'=>$category_sub,
        'group_subs'=>$group_sub,
        'reportheaders'=>$reportheader,
        'riskprograms'=>$riskprogram,
        'displaydate_bigen'=> $displaydate_bigen,
        'displaydate_end'=> $displaydate_end,
        'search' => $search
      ]);
  }

  public function report_riskincidencelevel_search(Request $request)
  {   
    
    $datebigin = $request->get('DATE_BIGIN');
    $dateend = $request->get('DATE_END');

    $search = $request->get('search');

    
    $date_bigen_c = Carbon::createFromFormat('d/m/Y', $datebigin)->format('Y-m-d');
    $date_arrary=explode("-",$date_bigen_c);

    $y_sub_st = $date_arrary[0];

    if($y_sub_st >= 2500){
        $y = $y_sub_st-543;
    }else{
        $y = $y_sub_st;
    }

    $m = $date_arrary[1];
    $d = $date_arrary[2];  
    $displaydate_bigen= $y."-".$m."-".$d;

    $date_end_c = Carbon::createFromFormat('d/m/Y', $dateend)->format('Y-m-d');
    $date_arrary_e=explode("-",$date_end_c); 

    $y_sub_e = $date_arrary_e[0];

    if($y_sub_e >= 2500){
        $y_e = $y_sub_e-543;
    }else{
        $y_e = $y_sub_e;
    }

    $m_e = $date_arrary_e[1];
    $d_e = $date_arrary_e[2];  
    $displaydate_end= $y_e."-".$m_e."-".$d_e;


    
    $group = DB::table('risk_setincidence_group')->get();       //ประเภทเสี่ยง
    $category = DB::table('risk_setincidence_category')->get();        //กลุ่มเสี่ยง
    $category_sub = DB::table('risk_setincidence_category_sub')->get();      //หมวดเสี่ยง    
    $group_sub = DB::table('risk_setincidence_group_sub')->get();        //ประเภทเสี่ยงย่อย
    $reportheader = DB::table('risk_setupincidence_reportheader')->get();   // รายงานโดยใช้

    $riskprogram  = DB::table('risk_rep_program')
    ->where(function($q) use ($search){
        $q->where('RISK_REPPROGRAM_NAME','like','%'.$search.'%');       
    })
    ->get();


      return view('manager_risk.report_riskincidencelevel',[
        'groups'=>$group,
        'categorys'=>$category,
        'category_subs'=>$category_sub,
        'group_subs'=>$group_sub,
        'reportheaders'=>$reportheader,
        'riskprograms'=>$riskprogram,
        'displaydate_bigen'=> $displaydate_bigen,
        'displaydate_end'=> $displaydate_end,
        'search' => $search
      ]);
  }

  
  public function report_riskincidencelevel_excel()
  {    
    $group = DB::table('risk_setincidence_group')->get();       //ประเภทเสี่ยง
    $category = DB::table('risk_setincidence_category')->get();        //กลุ่มเสี่ยง
    $category_sub = DB::table('risk_setincidence_category_sub')->get();      //หมวดเสี่ยง    
    $group_sub = DB::table('risk_setincidence_group_sub')->get();        //ประเภทเสี่ยงย่อย
    $reportheader = DB::table('risk_setupincidence_reportheader')->get();   // รายงานโดยใช้

    $riskprogram  = DB::table('risk_rep_program')->get();

    $m_budget = date("m");
    if($m_budget>9){
    $yearbudget = date("Y")+544;
    }else{
    $yearbudget = date("Y")+543;   
     }
    
    $displaydate_bigen = ($yearbudget-544).'-10-01';
    $displaydate_end = ($yearbudget-543).'-09-30';

      return view('manager_risk.report_riskincidencelevel_excel',[
        'groups'=>$group,
        'categorys'=>$category,
        'category_subs'=>$category_sub,
        'group_subs'=>$group_sub,
        'reportheaders'=>$reportheader,
        'riskprograms'=>$riskprogram,
        'displaydate_bigen'=> $displaydate_bigen,
        'displaydate_end'=> $displaydate_end,
      ]);
  }


  public function report_riskdepartment()
  {    
    $depart = DB::table('hrd_department')->where('ACTIVE','=','True')->get();
    $departsub = DB::table('hrd_department_sub_sub')->where('ACTIVE','=','True')->get();
    $categorydepart = DB::table('risk_category_department')->get();                     //ประเภทหน่วยงาน
    $reportheader = DB::table('risk_setupincidence_reportheader')->get();   // รายงานโดยใช้
    $reportlevelbegin = DB::table('risk_setupincidence_level_begin')->get();   // อันดับของการเกิด

    $lev_1 = DB::table('risk_rep')->Where('RISKREP_LEVEL','=','A')->count();
    $lev_2 = DB::table('risk_rep')->Where('RISKREP_LEVEL','=','B')->count();
    $lev_3 = DB::table('risk_rep')->Where('RISKREP_LEVEL','=','C')->count();
    $lev_4 = DB::table('risk_rep')->Where('RISKREP_LEVEL','=','D')->count();
    $lev_5 = DB::table('risk_rep')->Where('RISKREP_LEVEL','=','E')->count();
    $lev_6 = DB::table('risk_rep')->Where('RISKREP_LEVEL','=','F')->count();
    $lev_7 = DB::table('risk_rep')->Where('RISKREP_LEVEL','=','G')->count();
    $lev_8 = DB::table('risk_rep')->Where('RISKREP_LEVEL','=','H')->count();
    $lev_9 = DB::table('risk_rep')->Where('RISKREP_LEVEL','=','I')->count();

    $data = DB::table('risk_rep')
    ->leftjoin('risk_setincidence_setting','risk_rep.RISKREP_TITLE','=','risk_setincidence_setting.INCIDENCE_SETTING_ID')
    ->get();  

    $item = DB::table('risk_rep_items')->get();

    
    $m_budget = date("m");
    if($m_budget>9){
    $yearbudget = date("Y")+544;
    }else{
    $yearbudget = date("Y")+543;   
     }
    
    $displaydate_bigen = ($yearbudget-544).'-10-01';
    $displaydate_end = ($yearbudget-543).'-09-30';
    
    $search ='';

      return view('manager_risk.report_riskdepartment',[
        'departs'=>$depart,
        'departsubs'=>$departsub,
        'reportlevelbegins'=>$reportlevelbegin,
        'categorydeparts'=>$categorydepart,
        'items'=>$item,
        'lev_1'=>$lev_1,
        'lev_2'=>$lev_2,
        'lev_3'=>$lev_3,
        'lev_4'=>$lev_4,
        'lev_5'=>$lev_5,
        'lev_6'=>$lev_6,
        'lev_7'=>$lev_7,
        'lev_8'=>$lev_8,
        'lev_9'=>$lev_9,
        'datas'=>$data,
        'reportheaders'=>$reportheader,
        'displaydate_bigen'=> $displaydate_bigen,
        'displaydate_end'=> $displaydate_end,
        'search' => $search
      ]);
  }

  
  public function report_riskdepartment_search(Request $request)
  {    
    $depart = DB::table('hrd_department')->where('ACTIVE','=','True')->get();
    $departsub = DB::table('hrd_department_sub_sub')->where('ACTIVE','=','True')->get();
    $categorydepart = DB::table('risk_category_department')->get();                     //ประเภทหน่วยงาน
    $reportheader = DB::table('risk_setupincidence_reportheader')->get();   // รายงานโดยใช้
    $reportlevelbegin = DB::table('risk_setupincidence_level_begin')->get();   // อันดับของการเกิด

    $lev_1 = DB::table('risk_rep')->Where('RISKREP_LEVEL','=','1')->count();
    $lev_2 = DB::table('risk_rep')->Where('RISKREP_LEVEL','=','2')->count();
    $lev_3 = DB::table('risk_rep')->Where('RISKREP_LEVEL','=','3')->count();
    $lev_4 = DB::table('risk_rep')->Where('RISKREP_LEVEL','=','4')->count();
    $lev_5 = DB::table('risk_rep')->Where('RISKREP_LEVEL','=','5')->count();
    $lev_6 = DB::table('risk_rep')->Where('RISKREP_LEVEL','=','6')->count();
    $lev_7 = DB::table('risk_rep')->Where('RISKREP_LEVEL','=','7')->count();
    $lev_8 = DB::table('risk_rep')->Where('RISKREP_LEVEL','=','8')->count();
    $lev_9 = DB::table('risk_rep')->Where('RISKREP_LEVEL','=','9')->count();

    $search = $request->get('search');

    $data = DB::table('risk_rep')
    ->leftjoin('risk_setincidence_setting','risk_rep.RISKREP_TITLE','=','risk_setincidence_setting.INCIDENCE_SETTING_ID')
    ->get();  

    $item = DB::table('risk_rep_items')
    ->where(function($q) use ($search){
        $q->where('RISK_REPITEMS_CODE','like','%'.$search.'%');
        $q->orwhere('RISK_REPITEMS_NAME','like','%'.$search.'%');
    })
    ->get();

    
    $datebigin = $request->get('DATE_BIGIN');
    $dateend = $request->get('DATE_END');


    
    $date_bigen_c = Carbon::createFromFormat('d/m/Y', $datebigin)->format('Y-m-d');
    $date_arrary=explode("-",$date_bigen_c);

    $y_sub_st = $date_arrary[0];

    if($y_sub_st >= 2500){
        $y = $y_sub_st-543;
    }else{
        $y = $y_sub_st;
    }

    $m = $date_arrary[1];
    $d = $date_arrary[2];  
    $displaydate_bigen= $y."-".$m."-".$d;

    $date_end_c = Carbon::createFromFormat('d/m/Y', $dateend)->format('Y-m-d');
    $date_arrary_e=explode("-",$date_end_c); 

    $y_sub_e = $date_arrary_e[0];

    if($y_sub_e >= 2500){
        $y_e = $y_sub_e-543;
    }else{
        $y_e = $y_sub_e;
    }

    $m_e = $date_arrary_e[1];
    $d_e = $date_arrary_e[2];  
    $displaydate_end= $y_e."-".$m_e."-".$d_e;

      return view('manager_risk.report_riskdepartment',[
        'departs'=>$depart,
        'departsubs'=>$departsub,
        'reportlevelbegins'=>$reportlevelbegin,
        'categorydeparts'=>$categorydepart,
        'items'=>$item,
        'lev_1'=>$lev_1,
        'lev_2'=>$lev_2,
        'lev_3'=>$lev_3,
        'lev_4'=>$lev_4,
        'lev_5'=>$lev_5,
        'lev_6'=>$lev_6,
        'lev_7'=>$lev_7,
        'lev_8'=>$lev_8,
        'lev_9'=>$lev_9,
        'datas'=>$data,
        'reportheaders'=>$reportheader,
        'displaydate_bigen'=> $displaydate_bigen,
        'displaydate_end'=> $displaydate_end,
        'search' => $search
      ]);
  }

  
  public function report_riskdepartment_excel()
  {    
    $depart = DB::table('hrd_department')->where('ACTIVE','=','True')->get();
    $departsub = DB::table('hrd_department_sub_sub')->where('ACTIVE','=','True')->get();
    $categorydepart = DB::table('risk_category_department')->get();                     //ประเภทหน่วยงาน
    $reportheader = DB::table('risk_setupincidence_reportheader')->get();   // รายงานโดยใช้
    $reportlevelbegin = DB::table('risk_setupincidence_level_begin')->get();   // อันดับของการเกิด

    $lev_1 = DB::table('risk_rep')->Where('RISKREP_LEVEL','=','1')->count();
    $lev_2 = DB::table('risk_rep')->Where('RISKREP_LEVEL','=','2')->count();
    $lev_3 = DB::table('risk_rep')->Where('RISKREP_LEVEL','=','3')->count();
    $lev_4 = DB::table('risk_rep')->Where('RISKREP_LEVEL','=','4')->count();
    $lev_5 = DB::table('risk_rep')->Where('RISKREP_LEVEL','=','5')->count();
    $lev_6 = DB::table('risk_rep')->Where('RISKREP_LEVEL','=','6')->count();
    $lev_7 = DB::table('risk_rep')->Where('RISKREP_LEVEL','=','7')->count();
    $lev_8 = DB::table('risk_rep')->Where('RISKREP_LEVEL','=','8')->count();
    $lev_9 = DB::table('risk_rep')->Where('RISKREP_LEVEL','=','9')->count();

    $data = DB::table('risk_rep')
    ->leftjoin('risk_setincidence_setting','risk_rep.RISKREP_TITLE','=','risk_setincidence_setting.INCIDENCE_SETTING_ID')
    ->get();  

    $item = DB::table('risk_rep_items')->get();

    
    $m_budget = date("m");
    if($m_budget>9){
    $yearbudget = date("Y")+544;
    }else{
    $yearbudget = date("Y")+543;   
     }
    
    $displaydate_bigen = ($yearbudget-544).'-10-01';
    $displaydate_end = ($yearbudget-543).'-09-30';

      return view('manager_risk.report_riskdepartment_excel',[
        'departs'=>$depart,
        'departsubs'=>$departsub,
        'reportlevelbegins'=>$reportlevelbegin,
        'categorydeparts'=>$categorydepart,
        'items'=>$item,
        'lev_1'=>$lev_1,
        'lev_2'=>$lev_2,
        'lev_3'=>$lev_3,
        'lev_4'=>$lev_4,
        'lev_5'=>$lev_5,
        'lev_6'=>$lev_6,
        'lev_7'=>$lev_7,
        'lev_8'=>$lev_8,
        'lev_9'=>$lev_9,
        'datas'=>$data,
        'reportheaders'=>$reportheader,
        'displaydate_bigen'=> $displaydate_bigen,
        'displaydate_end'=> $displaydate_end,
      ]);
  }


  public static function countrisklevel($i,$j,$displaydate_bigen,$displaydate_end)
  {   
    $from = date($displaydate_bigen);
    $to = date($displaydate_end);

    $infolevel_id = DB::table('risk_rep_level')->where('RISK_REP_LEVEL_NAME','=',$i)->first();
    
      $count =  Riskrep::where('RISKREP_LEVEL','=',$infolevel_id->RISK_REP_LEVEL_ID)
      ->where('RISK_REPPROGRAM_ID','=',$j)
      ->WhereBetween('RISKREP_DATESAVE',[$from,$to]) 
      ->count();  

      return $count;
  }

  public static function countrisklevel_sum($j,$displaydate_bigen,$displaydate_end)
  {   
    $from = date($displaydate_bigen);
    $to = date($displaydate_end);
    
      $count =  Riskrep::where('RISK_REPPROGRAM_ID','=',$j)
      ->WhereBetween('RISKREP_DATESAVE',[$from,$to]) 
      ->count();  

      return $count;
  }
  
  public static function countrisklevel_sumall($displaydate_bigen,$displaydate_end)
  {   
    $from = date($displaydate_bigen);
    $to = date($displaydate_end);
    
      $count =  Riskrep::WhereBetween('RISKREP_DATESAVE',[$from,$to]) 
      ->count();  

      return $count;
  }


  public static function countriskrepitem($i,$z,$displaydate_bigen,$displaydate_end)
  {        
    $from = date($displaydate_bigen);
    $to = date($displaydate_end);

    $infolevel_id = DB::table('risk_rep_level')->where('RISK_REP_LEVEL_NAME','=',$i)->first();

      $count =  Riskrep::where('RISKREP_LEVEL','=', $infolevel_id->RISK_REP_LEVEL_ID)
      ->where('RISK_REPITEMS_ID','=',$z)
      ->WhereBetween('RISKREP_DATESAVE',[$from,$to]) 
      ->count();  

      return $count;
  }


  public static function countriskrepitem_sum($z,$displaydate_bigen,$displaydate_end)
  {        
    $from = date($displaydate_bigen);
    $to = date($displaydate_end);

      $count =  Riskrep::where('RISK_REPITEMS_ID','=',$z)
      ->WhereBetween('RISKREP_DATESAVE',[$from,$to]) 
      ->count();  

      return $count;
  }


  public static function countriskrepitem_sumall($displaydate_bigen,$displaydate_end)
  {        
    $from = date($displaydate_bigen);
    $to = date($displaydate_end);

      $count =  Riskrep::WhereBetween('RISKREP_DATESAVE',[$from,$to]) 
      ->count();  

      return $count;
  }

  //------------------
  public static function countriskdepsubsub($i,$a,$displaydate_bigen,$displaydate_end)
  {    
    $from = date($displaydate_bigen);
    $to = date($displaydate_end);

    $infolevel_id = DB::table('risk_rep_level')->where('RISK_REP_LEVEL_NAME','=',$i)->first();

      $count =  Riskrep::where('RISKREP_LEVEL','=',$infolevel_id->RISK_REP_LEVEL_ID)
      ->where('RISKREP_DEPARTMENT_SUB','=',$a)
      ->WhereBetween('RISKREP_DATESAVE',[$from,$to]) 
      ->count();  

      return $count;
  }

  public static function countriskdepsubsub_sum($a,$displaydate_bigen,$displaydate_end)
  {    
    $from = date($displaydate_bigen);
    $to = date($displaydate_end);

      $count =  Riskrep::where('RISKREP_DEPARTMENT_SUB','=',$a)
      ->WhereBetween('RISKREP_DATESAVE',[$from,$to]) 
      ->count();  

      return $count;
  }

  public static function countriskdepsubsub_sumall($displaydate_bigen,$displaydate_end)
  {    
    $from = date($displaydate_bigen);
    $to = date($displaydate_end);

      $count =  Riskrep::WhereBetween('RISKREP_DATESAVE',[$from,$to]) 
      ->count();  

      return $count;
  }

 //------------------

 public static function countriskdepsubsub_self($i,$a,$displaydate_bigen,$displaydate_end)
 {    
   $from = date($displaydate_bigen);
   $to = date($displaydate_end);

   $infolevel_id = DB::table('risk_rep_level')->where('RISK_REP_LEVEL_NAME','=',$i)->first();

     $count =  Riskrep::leftjoin('risk_account_detail','.RISKREP_ACC_ID','=','risk_account_detail.RISK_ACC_ID')
     ->where('RISKREP_LEVEL','=', $infolevel_id->RISK_REP_LEVEL_ID)
     ->where('RISKREP_DEPARTMENT_SUB','=',$a)
     ->where('RISK_ACC_AGENCY','=',$a)
     ->WhereBetween('RISKREP_DATESAVE',[$from,$to]) 
     ->count();  

     return $count;
 }

 public static function countriskdepsubsub_self_sum($i,$a,$displaydate_bigen,$displaydate_end)
 {    
   $from = date($displaydate_bigen);
   $to = date($displaydate_end);

     $count =  Riskrep::leftjoin('risk_account_detail','.RISKREP_ACC_ID','=','risk_account_detail.RISK_ACC_ID')
     ->where('RISKREP_DEPARTMENT_SUB','=',$a)
     ->where('RISK_ACC_AGENCY','=',$a)
     ->WhereBetween('RISKREP_DATESAVE',[$from,$to]) 
     ->count();  

     return $count;
 }

 public static function countriskdepsubsub_self_all($i,$a,$displaydate_bigen,$displaydate_end)
 {    
   $from = date($displaydate_bigen);
   $to = date($displaydate_end);

     $infos =  Riskrep::leftjoin('risk_account_detail','.RISKREP_ACC_ID','=','risk_account_detail.RISK_ACC_ID')
     ->WhereBetween('RISKREP_DATESAVE',[$from,$to]) 
     ->get();  

     $count =0;

     foreach ($infos as $info){

        if($info->RISK_ACC_AGENCY == $info->RISKREP_DEPARTMENT_SUB){
            $count++;
        }
    }

     return $count;
 }
  

  public function report_riskincidence_group()
  {    
      return view('manager_risk.report_riskincidence_group');
  }
  public function report_unrisk()
  {    
    $level = DB::table('risk_setupincidence_level')->get(); //ระดับ
    $reportheader = DB::table('risk_setupincidence_reportheader')->get();   // รายงานโดยใช้

      return view('manager_risk.report_unrisk',[
        'levels'=>$level,
        'reportheaders'=>$reportheader,
      ]);
  }
  public function report_riskdevelop()
  {    
    $reportheader = DB::table('risk_setupincidence_reportheader')->get();   // รายงานโดยใช้

      return view('manager_risk.report_riskdevelop',[
        'reportheaders'=>$reportheader,
      ]);
  }
  public function report_riskgroupdepatment()
  {    
    $depart = DB::table('hrd_department')->where('ACTIVE','=','True')->get();   //กลุ่มหน่วยงาน
    $reportheader = DB::table('risk_setupincidence_reportheader')->get();   // รายงานโดยใช้
    $categorydepart = DB::table('risk_category_department')->get();     //ประเภทหน่วยงาน

      return view('manager_risk.report_riskgroupdepatment',[
        'departs'=>$depart,       
        'categorydeparts'=>$categorydepart,
        'reportheaders'=>$reportheader,
      ]);
  }
  public function report_riskincidencecategory()
  {    
    $typelocation = DB::table('risk_setupincidence_tpyelocation')->get();   // ชนิดสถานที่
    $grouplocation = DB::table('risk_setupincidence_grouplocation')->get();  // ประเภทสถานที่
    $reportheader = DB::table('risk_setupincidence_reportheader')->get();   // รายงานโดยใช้
      return view('manager_risk.report_riskincidencecategory',[
            'typelocations'=>$typelocation,
            'grouplocations'=>$grouplocation,
            'reportheaders'=>$reportheader,
      ]);
  }
  public function report_riskincidencelocation()
  {    
    $reportheader = DB::table('risk_setupincidence_reportheader')->get();   // รายงานโดยใช้

      return view('manager_risk.report_riskincidencelocation',[
        'reportheaders'=>$reportheader,
      ]);
  }
  public function report_riskdigtime()
  {    
    $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'asc')->get();             //ปี
    $reportheader = DB::table('risk_setupincidence_reportheader')->get();   // รายงานโดยใช้
      return view('manager_risk.report_riskdigtime',[
        'budgets'=>$budget,
        'reportheaders'=>$reportheader,
      ]);
  }

  public function report_riskdepartment_sub()
  {    
    $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'asc')->get();             //ปี
    $reportheader = DB::table('risk_setupincidence_reportheader')->get();   // รายงานโดยใช้
      return view('manager_risk.report_riskdepartment_sub',[
        'budgets'=>$budget,
        'reportheaders'=>$reportheader,
      ]);
  }




  public function report_risksub()
  {    
    $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'asc')->get();             //ปี
    $group = DB::table('risk_setincidence_group')->get();       //ประเภทเสี่ยง
    $category = DB::table('risk_setincidence_category')->get();        //กลุ่มเสี่ยง
    $category_sub = DB::table('risk_setincidence_category_sub')->get();      //หมวดเสี่ยง    
    $group_sub = DB::table('risk_setincidence_group_sub')->get();        //ประเภทอุบัติการความเสี่ยง
    $reportheader = DB::table('risk_setupincidence_reportheader')->get();   // รายงานโดยใช้
    $category_subsub = DB::table('risk_setincidence_category_subsub')->get();        //ประเภทอุบัติการความเสี่ยงย่อย
    
      return view('manager_risk.report_risksub',[
        'budgets'=>$budget,
        'groups'=>$group,
        'categorys'=>$category,
        'category_subs'=>$category_sub,
        'group_subs'=>$group_sub,       
        'reportheaders'=>$reportheader,
        'category_subsubs'=>$category_subsub,
      ]);
  }
  public function report_riskdataset_day()
  {    
      return view('manager_risk.report_riskdataset_day');
  }
  public function report_riskdataset_month()
  {    
      return view('manager_risk.report_riskdataset_month');
  }
  public function report_riskdataset_year()
  {    
      return view('manager_risk.report_riskdataset_year');
  }
  public function report_riskimplement()
  {    
      return view('manager_risk.report_riskimplement');
  }


  public function report_riskdepartment_subsub()
  {    
    $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'asc')->get();
    $reportheader = DB::table('risk_setupincidence_reportheader')->get();   // รายงานโดยใช้


    $infodepsubsub = DB::table('hrd_department_sub_sub')
    ->get();

    $m_budget = date("m");
    if($m_budget>9){
    $yearbudget = date("Y")+544;
    }else{
    $yearbudget = date("Y")+543;   
     }
    
    $displaydate_bigen = ($yearbudget-544).'-10-01';
    $displaydate_end = ($yearbudget-543).'-09-30';

    $search ='';

      return view('manager_risk.report_riskdepartment_subsub',[
          'budgets'=>$budget,
          'reportheaders'=>$reportheader,
          'infodepsubsubs'=>$infodepsubsub,
          'displaydate_bigen'=> $displaydate_bigen,
          'displaydate_end'=> $displaydate_end,
          'search'=>$search
      ]);
  }


  
  public function report_riskdepartment_subsub_search(Request $request)
  {    
    $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'asc')->get();
    $reportheader = DB::table('risk_setupincidence_reportheader')->get();   // รายงานโดยใช้

    
    $search = $request->get('search');

    $infodepsubsub = DB::table('hrd_department_sub_sub')
    ->where(function($q) use ($search){
        $q->where('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');
    })
    ->get();

    $datebigin = $request->get('DATE_BIGIN');
    $dateend = $request->get('DATE_END');

    
    $date_bigen_c = Carbon::createFromFormat('d/m/Y', $datebigin)->format('Y-m-d');
    $date_arrary=explode("-",$date_bigen_c);

    $y_sub_st = $date_arrary[0];

    if($y_sub_st >= 2500){
        $y = $y_sub_st-543;
    }else{
        $y = $y_sub_st;
    }

    $m = $date_arrary[1];
    $d = $date_arrary[2];  
    $displaydate_bigen= $y."-".$m."-".$d;

    $date_end_c = Carbon::createFromFormat('d/m/Y', $dateend)->format('Y-m-d');
    $date_arrary_e=explode("-",$date_end_c); 

    $y_sub_e = $date_arrary_e[0];

    if($y_sub_e >= 2500){
        $y_e = $y_sub_e-543;
    }else{
        $y_e = $y_sub_e;
    }

    $m_e = $date_arrary_e[1];
    $d_e = $date_arrary_e[2];  
    $displaydate_end= $y_e."-".$m_e."-".$d_e;

      return view('manager_risk.report_riskdepartment_subsub',[
          'budgets'=>$budget,
          'reportheaders'=>$reportheader,
          'infodepsubsubs'=>$infodepsubsub,
          'displaydate_bigen'=> $displaydate_bigen,
          'displaydate_end'=> $displaydate_end,
          'search' => $search
      ]);
  }

  
  public function report_riskdepartment_subsub_excel()
  {    
    $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'asc')->get();
    $reportheader = DB::table('risk_setupincidence_reportheader')->get();   // รายงานโดยใช้

    $infodepsubsub = DB::table('hrd_department_sub_sub')->get();

    $m_budget = date("m");
    if($m_budget>9){
    $yearbudget = date("Y")+544;
    }else{
    $yearbudget = date("Y")+543;   
     }
    
    $displaydate_bigen = ($yearbudget-544).'-10-01';
    $displaydate_end = ($yearbudget-543).'-09-30';

      return view('manager_risk.report_riskdepartment_subsub_excel',[
          'budgets'=>$budget,
          'reportheaders'=>$reportheader,
          'infodepsubsubs'=>$infodepsubsub,
          'displaydate_bigen'=> $displaydate_bigen,
          'displaydate_end'=> $displaydate_end,
      ]);
  }

  //-------------------------------

  public function report_riskdepartment_self_subsub()
  {    
    $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'asc')->get();
    $reportheader = DB::table('risk_setupincidence_reportheader')->get();   // รายงานโดยใช้

    $infodepsubsub = DB::table('hrd_department_sub_sub')->get();

    $m_budget = date("m");
    if($m_budget>9){
    $yearbudget = date("Y")+544;
    }else{
    $yearbudget = date("Y")+543;   
     }
    
    $displaydate_bigen = ($yearbudget-544).'-10-01';
    $displaydate_end = ($yearbudget-543).'-09-30';


    $from = date($displaydate_bigen);
    $to = date($displaydate_end);

        $information =  Riskrep::leftjoin('risk_account_detail','.RISKREP_ACC_ID','=','risk_account_detail.RISK_ACC_ID')
        ->WhereBetween('RISKREP_DATESAVE',[$from,$to]) 
        ->get();

        $sumA=0;$sumB=0;$sumC=0;$sumD=0;$sumE=0;$sumF=0;$sumG=0;$sumH=0;$sumI=0;
        $sumnum1=0;$sumnum2=0;$sumnum3=0;$sumnum4=0;$sumnum5=0;$sumuse=0;$sumall=0;
        $sumnull=0;
        foreach ($information as $info){
            $sumall++;
                if($info->RISKREP_DEPARTMENT_SUB == $info->RISK_ACC_AGENCY){
                    
                    $sumuse++;
                    
                    if($info->RISKREP_LEVEL == '1'){ $sumA++; }
                    elseif($info->RISKREP_LEVEL== '2'){ $sumB++; }
                    elseif($info->RISKREP_LEVEL== '3'){ $sumC++; }
                    elseif($info->RISKREP_LEVEL== '4'){ $sumD++; }
                    elseif($info->RISKREP_LEVEL== '5'){ $sumE++; }
                    elseif($info->RISKREP_LEVEL== '6'){ $sumF++; }
                    elseif($info->RISKREP_LEVEL== '7'){ $sumG++; }
                    elseif($info->RISKREP_LEVEL== '8'){ $sumH++; }
                    elseif($info->RISKREP_LEVEL== '9'){ $sumI++; }
                    elseif($info->RISKREP_LEVEL== '10'){ $sumnum1++; }
                    elseif($info->RISKREP_LEVEL== '11'){ $sumnum2++; }
                    elseif($info->RISKREP_LEVEL== '12'){ $sumnum3++; }
                    elseif($info->RISKREP_LEVEL== '13'){ $sumnum4++; }
                    elseif($info->RISKREP_LEVEL== '14'){ $sumnum5++; }
                    else{ $sumnull++;}
                }



        }


        if($sumuse == 0){
          $sumA_re= 0;
          $sumB_re= 0;
          $sumC_re= 0;
          $sumD_re= 0;
          $sumE_re= 0;
          $sumF_re= 0;
          $sumG_re= 0;
          $sumH_re= 0;
          $sumI_re= 0;
          $sumnull_re= 0;
          $sumnum1_re= 0;
          $sumnum2_re= 0;
          $sumnum3_re= 0;
          $sumnum4_re= 0;
          $sumnum5_re= 0;
          $sumuse_re= 0;

        }else{
           
            $sumA_re=  ($sumA/$sumuse)*100;
            $sumB_re=($sumB/$sumuse)*100;
            $sumC_re=($sumC/$sumuse)*100;
            $sumD_re= ($sumD/$sumuse)*100;
            $sumE_re= ($sumE/$sumuse)*100;
            $sumF_re= ($sumF/$sumuse)*100;
            $sumG_re= ($sumG/$sumuse)*100;
            $sumH_re=($sumH/$sumuse)*100;
            $sumI_re= ($sumI/$sumuse)*100;
            $sumnull_re= ($sumnull/$sumuse)*100;
            $sumnum1_re= ($sumnum1/$sumuse)*100;
            $sumnum2_re= ($sumnum2/$sumuse)*100;
            $sumnum3_re= ($sumnum3/$sumuse)*100;
            $sumnum4_re= ($sumnum4/$sumuse)*100;
            $sumnum5_re= ($sumnum5/$sumuse)*100;
            $sumuse_re = ($sumuse/$sumuse)*100;
        }
       
  
    

      return view('manager_risk.report_riskdepartment_self_subsub',[
          'budgets'=>$budget,
          'reportheaders'=>$reportheader,
          'infodepsubsubs'=>$infodepsubsub,
          'displaydate_bigen'=> $displaydate_bigen,
          'displaydate_end'=> $displaydate_end,
          'sumA'=> $sumA,
          'sumB'=> $sumB,
          'sumC'=> $sumC,
          'sumD'=> $sumD,
          'sumE'=> $sumE,
          'sumF'=> $sumF,
          'sumG'=> $sumG,
          'sumH'=> $sumH,
          'sumI'=> $sumI,
          'sumnum1'=> $sumnum1,
          'sumnum2'=> $sumnum2,
          'sumnum3'=> $sumnum3,
          'sumnum4'=> $sumnum4,
          'sumnum5'=> $sumnum5,
          'sumnull'=> $sumnull,
          'sumall'=> $sumall,
          'sumuse'=> $sumuse,
          'sumA_re'=> $sumA_re,
          'sumB_re'=> $sumB_re,
          'sumC_re'=> $sumC_re,
          'sumD_re'=> $sumD_re,
          'sumE_re'=> $sumE_re,
          'sumF_re'=> $sumF_re,
          'sumG_re'=> $sumG_re,
          'sumH_re'=> $sumH_re,
          'sumI_re'=> $sumI_re,
          'sumnum1_re'=> $sumnum1_re,
          'sumnum2_re'=> $sumnum2_re,
          'sumnum3_re'=> $sumnum3_re,
          'sumnum4_re'=> $sumnum4_re,
          'sumnum5_re'=> $sumnum5_re,
          'sumnull_re'=> $sumnull_re,
          'sumuse_re'=> $sumuse_re,
          

      ]);
  }


  public function report_riskdepartment_self_subsub_search(Request $request)
  {    
    $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'asc')->get();
    $reportheader = DB::table('risk_setupincidence_reportheader')->get();   // รายงานโดยใช้

    $infodepsubsub = DB::table('hrd_department_sub_sub')->get();

    $datebigin = $request->get('DATE_BIGIN');
    $dateend = $request->get('DATE_END');

    
    $date_bigen_c = Carbon::createFromFormat('d/m/Y', $datebigin)->format('Y-m-d');
    $date_arrary=explode("-",$date_bigen_c);

    $y_sub_st = $date_arrary[0];

    if($y_sub_st >= 2500){
        $y = $y_sub_st-543;
    }else{
        $y = $y_sub_st;
    }

    $m = $date_arrary[1];
    $d = $date_arrary[2];  
    $displaydate_bigen= $y."-".$m."-".$d;

    $date_end_c = Carbon::createFromFormat('d/m/Y', $dateend)->format('Y-m-d');
    $date_arrary_e=explode("-",$date_end_c); 

    $y_sub_e = $date_arrary_e[0];

    if($y_sub_e >= 2500){
        $y_e = $y_sub_e-543;
    }else{
        $y_e = $y_sub_e;
    }

    $m_e = $date_arrary_e[1];
    $d_e = $date_arrary_e[2];  
    $displaydate_end= $y_e."-".$m_e."-".$d_e;


    $from = date($displaydate_bigen);
    $to = date($displaydate_end);

        $information =  Riskrep::leftjoin('risk_account_detail','.RISKREP_ACC_ID','=','risk_account_detail.RISK_ACC_ID')
        ->WhereBetween('RISKREP_DATESAVE',[$from,$to]) 
        ->get();

        $sumA=0;$sumB=0;$sumC=0;$sumD=0;$sumE=0;$sumF=0;$sumG=0;$sumH=0;$sumI=0;
        $sumnum1=0;$sumnum2=0;$sumnum3=0;$sumnum4=0;$sumnum5=0;$sumuse=0;$sumall=0;
        $sumnull=0;
        foreach ($information as $info){
            $sumall++;
                if($info->RISKREP_DEPARTMENT_SUB == $info->RISK_ACC_AGENCY){
                    
                    $sumuse++;
                    
                    if($info->RISKREP_LEVEL == '1'){ $sumA++; }
                    elseif($info->RISKREP_LEVEL== '2'){ $sumB++; }
                    elseif($info->RISKREP_LEVEL== '3'){ $sumC++; }
                    elseif($info->RISKREP_LEVEL== '4'){ $sumD++; }
                    elseif($info->RISKREP_LEVEL== '5'){ $sumE++; }
                    elseif($info->RISKREP_LEVEL== '6'){ $sumF++; }
                    elseif($info->RISKREP_LEVEL== '7'){ $sumG++; }
                    elseif($info->RISKREP_LEVEL== '8'){ $sumH++; }
                    elseif($info->RISKREP_LEVEL== '9'){ $sumI++; }
                    elseif($info->RISKREP_LEVEL== '10'){ $sumnum1++; }
                    elseif($info->RISKREP_LEVEL== '11'){ $sumnum2++; }
                    elseif($info->RISKREP_LEVEL== '12'){ $sumnum3++; }
                    elseif($info->RISKREP_LEVEL== '13'){ $sumnum4++; }
                    elseif($info->RISKREP_LEVEL== '14'){ $sumnum5++; }
                    else{ $sumnull++;}
                }



        }


        

        if($sumuse == 0){
            $sumA_re= 0;
            $sumB_re= 0;
            $sumC_re= 0;
            $sumD_re= 0;
            $sumE_re= 0;
            $sumF_re= 0;
            $sumG_re= 0;
            $sumH_re= 0;
            $sumI_re= 0;
            $sumnull_re= 0;
            $sumnum1_re= 0;
            $sumnum2_re= 0;
            $sumnum3_re= 0;
            $sumnum4_re= 0;
            $sumnum5_re= 0;
            $sumuse_re= 0;
  
          }else{
             
              $sumA_re=  ($sumA/$sumuse)*100;
              $sumB_re=($sumB/$sumuse)*100;
              $sumC_re=($sumC/$sumuse)*100;
              $sumD_re= ($sumD/$sumuse)*100;
              $sumE_re= ($sumE/$sumuse)*100;
              $sumF_re= ($sumF/$sumuse)*100;
              $sumG_re= ($sumG/$sumuse)*100;
              $sumH_re=($sumH/$sumuse)*100;
              $sumI_re= ($sumI/$sumuse)*100;
              $sumnull_re= ($sumnull/$sumuse)*100;
              $sumnum1_re= ($sumnum1/$sumuse)*100;
              $sumnum2_re= ($sumnum2/$sumuse)*100;
              $sumnum3_re= ($sumnum3/$sumuse)*100;
              $sumnum4_re= ($sumnum4/$sumuse)*100;
              $sumnum5_re= ($sumnum5/$sumuse)*100;
              $sumuse_re = ($sumuse/$sumuse)*100;
          }

      return view('manager_risk.report_riskdepartment_self_subsub',[
          'budgets'=>$budget,
          'reportheaders'=>$reportheader,
          'infodepsubsubs'=>$infodepsubsub,
          'displaydate_bigen'=> $displaydate_bigen,
          'displaydate_end'=> $displaydate_end,
          'sumA'=> $sumA,
          'sumB'=> $sumB,
          'sumC'=> $sumC,
          'sumD'=> $sumD,
          'sumE'=> $sumE,
          'sumF'=> $sumF,
          'sumG'=> $sumG,
          'sumH'=> $sumH,
          'sumI'=> $sumI,
          'sumnum1'=> $sumnum1,
          'sumnum2'=> $sumnum2,
          'sumnum3'=> $sumnum3,
          'sumnum4'=> $sumnum4,
          'sumnum5'=> $sumnum5,
          'sumnull'=> $sumnull,
          'sumall'=> $sumall,
          'sumuse'=> $sumuse,
          'sumA_re'=> $sumA_re,
          'sumB_re'=> $sumB_re,
          'sumC_re'=> $sumC_re,
          'sumD_re'=> $sumD_re,
          'sumE_re'=> $sumE_re,
          'sumF_re'=> $sumF_re,
          'sumG_re'=> $sumG_re,
          'sumH_re'=> $sumH_re,
          'sumI_re'=> $sumI_re,
          'sumnum1_re'=> $sumnum1_re,
          'sumnum2_re'=> $sumnum2_re,
          'sumnum3_re'=> $sumnum3_re,
          'sumnum4_re'=> $sumnum4_re,
          'sumnum5_re'=> $sumnum5_re,
          'sumnull_re'=> $sumnull_re,
          'sumuse_re'=> $sumuse_re,
          
      ]);
  }



  
  public function report_riskdepartment_self_subsub_excel()
  {    
    $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'asc')->get();
    $reportheader = DB::table('risk_setupincidence_reportheader')->get();   // รายงานโดยใช้

    $infodepsubsub = DB::table('hrd_department_sub_sub')->get();

    $m_budget = date("m");
    if($m_budget>9){
    $yearbudget = date("Y")+544;
    }else{
    $yearbudget = date("Y")+543;   
     }
    
    $displaydate_bigen = ($yearbudget-544).'-10-01';
    $displaydate_end = ($yearbudget-543).'-09-30';

    $from = date($displaydate_bigen);
    $to = date($displaydate_end);

        $information =  Riskrep::leftjoin('risk_account_detail','.RISKREP_ACC_ID','=','risk_account_detail.RISK_ACC_ID')
        ->WhereBetween('RISKREP_DATESAVE',[$from,$to]) 
        ->get();

        $sumA=0;$sumB=0;$sumC=0;$sumD=0;$sumE=0;$sumF=0;$sumG=0;$sumH=0;$sumI=0;
        $sumnum1=0;$sumnum2=0;$sumnum3=0;$sumnum4=0;$sumnum5=0;$sumuse=0;$sumall=0;$sumnull=0;
        foreach ($information as $info){
            $sumall++;
                if($info->RISKREP_DEPARTMENT_SUB == $info->RISK_ACC_AGENCY){
                    
                    $sumuse++;
                    
                    if($info->RISKREP_LEVEL == '1'){ $sumA++; }
                    elseif($info->RISKREP_LEVEL== '2'){ $sumB++; }
                    elseif($info->RISKREP_LEVEL== '3'){ $sumC++; }
                    elseif($info->RISKREP_LEVEL== '4'){ $sumD++; }
                    elseif($info->RISKREP_LEVEL== '5'){ $sumE++; }
                    elseif($info->RISKREP_LEVEL== '6'){ $sumF++; }
                    elseif($info->RISKREP_LEVEL== '7'){ $sumG++; }
                    elseif($info->RISKREP_LEVEL== '8'){ $sumH++; }
                    elseif($info->RISKREP_LEVEL== '9'){ $sumI++; }
                    elseif($info->RISKREP_LEVEL== '10'){ $sumnum1++; }
                    elseif($info->RISKREP_LEVEL== '11'){ $sumnum2++; }
                    elseif($info->RISKREP_LEVEL== '12'){ $sumnum3++; }
                    elseif($info->RISKREP_LEVEL== '13'){ $sumnum4++; }
                    elseif($info->RISKREP_LEVEL== '14'){ $sumnum5++; }
                    else{ $sumnull++;}
                }



        }

        if($sumuse == 0){
            $sumA_re= 0;
            $sumB_re= 0;
            $sumC_re= 0;
            $sumD_re= 0;
            $sumE_re= 0;
            $sumF_re= 0;
            $sumG_re= 0;
            $sumH_re= 0;
            $sumI_re= 0;
            $sumnull_re= 0;
            $sumnum1_re= 0;
            $sumnum2_re= 0;
            $sumnum3_re= 0;
            $sumnum4_re= 0;
            $sumnum5_re= 0;
            $sumuse_re= 0;
  
          }else{
             
              $sumA_re=  ($sumA/$sumuse)*100;
              $sumB_re=($sumB/$sumuse)*100;
              $sumC_re=($sumC/$sumuse)*100;
              $sumD_re= ($sumD/$sumuse)*100;
              $sumE_re= ($sumE/$sumuse)*100;
              $sumF_re= ($sumF/$sumuse)*100;
              $sumG_re= ($sumG/$sumuse)*100;
              $sumH_re=($sumH/$sumuse)*100;
              $sumI_re= ($sumI/$sumuse)*100;
              $sumnull_re= ($sumnull/$sumuse)*100;
              $sumnum1_re= ($sumnum1/$sumuse)*100;
              $sumnum2_re= ($sumnum2/$sumuse)*100;
              $sumnum3_re= ($sumnum3/$sumuse)*100;
              $sumnum4_re= ($sumnum4/$sumuse)*100;
              $sumnum5_re= ($sumnum5/$sumuse)*100;
              $sumuse_re = ($sumuse/$sumuse)*100;
          }

      return view('manager_risk.report_riskdepartment_self_subsub_excel',[
          'budgets'=>$budget,
          'reportheaders'=>$reportheader,
          'infodepsubsubs'=>$infodepsubsub,
          'displaydate_bigen'=> $displaydate_bigen,
          'displaydate_end'=> $displaydate_end,
          'sumA'=> $sumA,
          'sumB'=> $sumB,
          'sumC'=> $sumC,
          'sumD'=> $sumD,
          'sumE'=> $sumE,
          'sumF'=> $sumF,
          'sumG'=> $sumG,
          'sumH'=> $sumH,
          'sumI'=> $sumI,
          'sumnum1'=> $sumnum1,
          'sumnum2'=> $sumnum2,
          'sumnum3'=> $sumnum3,
          'sumnum4'=> $sumnum4,
          'sumnum5'=> $sumnum5,
          'sumnull'=> $sumnull,
          'sumall'=> $sumall,
          'sumuse'=> $sumuse,
          'sumA_re'=> $sumA_re,
          'sumB_re'=> $sumB_re,
          'sumC_re'=> $sumC_re,
          'sumD_re'=> $sumD_re,
          'sumE_re'=> $sumE_re,
          'sumF_re'=> $sumF_re,
          'sumG_re'=> $sumG_re,
          'sumH_re'=> $sumH_re,
          'sumI_re'=> $sumI_re,
          'sumnum1_re'=> $sumnum1_re,
          'sumnum2_re'=> $sumnum2_re,
          'sumnum3_re'=> $sumnum3_re,
          'sumnum4_re'=> $sumnum4_re,
          'sumnum5_re'=> $sumnum5_re,
          'sumnull_re'=> $sumnull_re,
          'sumuse_re'=> $sumuse_re,
      ]);
  }


  //------------------------End Report------------------------------------//

    public function dataset()
    {    
        return view('manager_risk.dataset');
    }
    public function report()
    {    
        return view('manager_risk.report');
    }
    public function know()
    {    
        return view('manager_risk.know');
    }
    public function unlock_incidence()
    {    
        return view('manager_risk.unlock_incidence');
    }
    public function reportdelete_incidence()
    {    
        return view('manager_risk.reportdelete_incidence');
    }
    public function requestformat_incidence()
    {    
        return view('manager_risk.requestformat_incidence');
    }
    public function incidence_group()
    {    
        return view('manager_risk.incidence_group');
    }
    public function incidence_category()
    {    
        return view('manager_risk.incidence_category');
    }
    public function incidence_setting()
    {    
        return view('manager_risk.incidence_setting');
    }
    public function incidence_groupuser()
    {    
        return view('manager_risk.incidence_groupuser');
    }
    public function incidence_level()
    {    
      return view('manager_risk.incidence_level');
    }
    public function incidence_location()
    {    
        return view('manager_risk.incidence_location');
    }
    public function incidence_origin()
    {    
        return view('manager_risk.incidence_origin');
    }
    public function incidence_listdataset()
    {    
        return view('manager_risk.incidence_listdataset');
    }
    public function incidence_sub()
    {    
        return view('manager_risk.incidence_sub');
    }

    public function risk_evaluate_a()
    {    
        return view('manager_risk.risk_evaluate_a');
    }

    public function risk_evaluate_pdf()
    {    
      
        $pdf = PDF::loadView('manager_risk.risk_evaluate_pdf');
        $pdf->setOptions([
            'mode' => 'utf-8',           
            'default_font_size' => 17,
            'defaultFont' => 'THSarabunNew'                       
            ]);
        $pdf->setPaper('a4', 'landscape');

      return @$pdf->stream();
    }

    public function risk_evaluate_pdf_b()
    {         
        $pdf = PDF::loadView('manager_risk.risk_evaluate_pdf_b');
        $pdf->setOptions([
            'mode' => 'utf-8',           
            'default_font_size' => 17,
            'defaultFont' => 'THSarabunNew'                       
            ]);
        $pdf->setPaper('a4', 'landscape');

      return @$pdf->stream();
    }

    public function excel_risk_evaluate()
    {
        return view('manager_risk.excel_risk_evaluate');
    }

    public function risk_notify_accept(Request $request,$id)
    {
        $rigrep = Riskrep::where('RISKREP_ID','=',$id)->first();
      
        $notify_accept= Risk_notify_accept_sub::leftjoin('hrd_person','risk_notify_accept_sub.NOTIFY_ACCEPT_USER_SAVE','=','hrd_person.ID')  
            ->leftjoin('risk_rep','risk_notify_accept_sub.RISKREP_ID','=','risk_rep.RISKREP_ID')           
            ->where('risk_notify_accept_sub.RISKREP_ID','=',$id)->get();
    
        return view('manager_risk.risk_notify_accept',[
            'rigreps'=> $rigrep,
            'notify_accepts'=> $notify_accept,
        ]);
    }
    public function risk_notify_accept_sub(Request $request,$id)
    {
        $rigrep = Riskrep::leftjoin('risk_setincidence_setting','risk_rep.RISKREP_TITLE','=','risk_setincidence_setting.INCIDENCE_SETTING_ID')
        ->leftjoin('risk_setupincidence_grouplocation','risk_rep.RISKREP_LOCAL','=','risk_setupincidence_grouplocation.SETUP_GROUPLOCATION_ID')
        ->where('RISKREP_ID','=',$id)->first();

       $notify_repeat = Risk_notify_accept_sub::where('RISKREP_ID','=',$id)->get();
       $infoper = DB::table('hrd_person')->get();

       $maxnum = Risk_notify_accept_sub::max('NOTIFY_ACCEPT_NO');
       if($maxnum != '' ||  $maxnum != null){
        $refmax = Risk_notify_accept_sub::where('NOTIFY_ACCEPT_NO','=',$maxnum)->first();

        if($refmax->NOTIFY_ACCEPT_NO != '' ||  $refmax->NOTIFY_ACCEPT_NO != null){
        $maxpo = substr($refmax->NOTIFY_ACCEPT_NO, -2)+1;
        }else{
        $maxref = 1;
        }
        $refe = str_pad($maxpo, 3, "0", STR_PAD_LEFT);
        }else{
       $refe = '001';
        }
        $billNo = $refe;
        
        return view('manager_risk.risk_notify_accept_sub',[
            'infopers'=>$infoper,
            'rigreps'=>$rigrep,
            'notify_repeats'=> $notify_repeat,
            'billNos'=>$billNo,
        ]);
    }
    public function risk_notify_accept_sub_save(Request $request)
    {
        $id_rig = $request->RISKREP_ID;
        $date_repeat = $request->get('NOTIFY_ACCEPT_DATE');      
        $date_bigen_c = Carbon::createFromFormat('d/m/Y', $date_repeat)->format('Y-m-d');
        $date_arrary=explode("-",$date_bigen_c);
    
        $y_sub_st = $date_arrary[0];
    
        if($y_sub_st >= 2500){
            $y = $y_sub_st-543;
        }else{
            $y = $y_sub_st;
        }
    
        $m = $date_arrary[1];
        $d = $date_arrary[2];  
        $displaydate_repeat= $y."-".$m."-".$d;
    
           
        $date = date('Y-m-d');
        $date_bigen_checks = strtotime($displaydate_repeat);
       
        $dates =  strtotime($date);
    
        $date_rep = date($displaydate_repeat);
        

        $add = new Risk_notify_accept_sub();  
        $add->NOTIFY_ACCEPT_NO = $request->NOTIFY_ACCEPT_NO;
        $add->NOTIFY_ACCEPT_DATE = $date_rep;
        $add->NOTIFY_ACCEPT_ABOUT = $request->NOTIFY_ACCEPT_ABOUT;
        $add->NOTIFY_ACCEPT_DETAIL = $request->NOTIFY_ACCEPT_DETAIL;
        $add->NOTIFY_ACCEPT_USER_SAVE =$request->NOTIFY_ACCEPT_USER_SAVE;
        $add->RISKREP_ID = $id_rig;
        $add->save();
       
        return redirect()->route('mrisk.risk_notify_accept',[
            'id'=> $id_rig 
        ]);
    }
    public function risk_notify_accept_sub_edit(Request $request,$id,$idrig)
    {
       
         $rigrep = Riskrep::leftjoin('risk_setincidence_setting','risk_rep.RISKREP_TITLE','=','risk_setincidence_setting.INCIDENCE_SETTING_ID')
         ->leftjoin('risk_setupincidence_grouplocation','risk_rep.RISKREP_LOCAL','=','risk_setupincidence_grouplocation.SETUP_GROUPLOCATION_ID')
         ->where('RISKREP_ID','=',$idrig)->first();

        $notify_accept = Risk_notify_accept_sub::where('NOTIFY_ACCEPT_ID','=',$id)->first();

        $infoper = DB::table('hrd_person')->get();


        $maxnum = Risk_notify_accept_sub::max('NOTIFY_ACCEPT_NO');
        if($maxnum != '' ||  $maxnum != null){
         $refmax = Risk_notify_accept_sub::where('NOTIFY_ACCEPT_NO','=',$maxnum)->first();

         if($refmax->NOTIFY_ACCEPT_NO != '' ||  $refmax->NOTIFY_ACCEPT_NO != null){
         $maxpo = substr($refmax->NOTIFY_ACCEPT_NO, -2)+1;
         }else{
         $maxref = 1;
         }
         $refe = str_pad($maxpo, 3, "0", STR_PAD_LEFT);
         }else{
        $refe = '001';
         }
         $billNo = $refe;



        return view('manager_risk.risk_notify_accept_sub_edit',[
            'infopers'=>$infoper,
            'rigreps'=>$rigrep,
            'notify_accepts'=> $notify_accept,
            'billNos'=>$billNo,
        ]);
    }
    public function risk_notify_accept_sub_update(Request $request)
    {
        $id_repeat_sub = $request->NOTIFY_ACCEPT_ID;
        $id_rig = $request->RISKREP_ID;
     
        $date_repeat = $request->get('NOTIFY_ACCEPT_DATE');      
        $date_bigen_c = Carbon::createFromFormat('d/m/Y', $date_repeat)->format('Y-m-d');
        $date_arrary=explode("-",$date_bigen_c);
    
        $y_sub_st = $date_arrary[0];
    
        if($y_sub_st >= 2500){
            $y = $y_sub_st-543;
        }else{
            $y = $y_sub_st;
        }    
        $m = $date_arrary[1];
        $d = $date_arrary[2];  
        $displaydate_repeat= $y."-".$m."-".$d;   
           
        $date = date('Y-m-d');
        $date_bigen_checks = strtotime($displaydate_repeat);       
        $dates =  strtotime($date);    
        $date_rep = date($displaydate_repeat);           
     
        $update = Risk_notify_accept_sub::find($id_repeat_sub);  
        $update->NOTIFY_ACCEPT_NO = $request->NOTIFY_ACCEPT_NO;
        $update->NOTIFY_ACCEPT_DATE = $date_rep;
        $update->NOTIFY_ACCEPT_ABOUT = $request->NOTIFY_ACCEPT_ABOUT;
        $update->NOTIFY_ACCEPT_DETAIL = $request->NOTIFY_ACCEPT_DETAIL;
        $update->NOTIFY_ACCEPT_USER_SAVE =$request->NOTIFY_ACCEPT_USER_SAVE;
        $update->RISKREP_ID = $id_rig;
        $update->save();
       
        return redirect()->route('mrisk.risk_notify_accept',[
            'id'=> $id_rig 
        ]);
    }
    public function risk_notify_accept_sub_destroy(Request $request,$id,$idrig)
    {
        Risk_notify_accept_sub::destroy($id);  

        return redirect()->route('mrisk.risk_notify_accept',[
            'id'=> $idrig
         ]);

    }

    //================================================================//



    public function risk_notify_repeat(Request $request,$id)
    {
        $rigrep = Riskrep::where('RISKREP_ID','=',$id)->first();
        $notify_repeat = Risk_notify_repeat_sub::leftjoin('hrd_person','risk_notify_repeat_sub.NOTIFY_REPEAT_USER_SAVE','=','hrd_person.ID')  
            ->leftjoin('risk_rep','risk_notify_repeat_sub.RISKREP_ID','=','risk_rep.RISKREP_ID')
            ->leftjoin('risk_setincidence_setting','risk_rep.RISKREP_TITLE','=','risk_setincidence_setting.INCIDENCE_SETTING_ID')
            ->leftjoin('risk_setupincidence_grouplocation','risk_rep.RISKREP_LOCAL','=','risk_setupincidence_grouplocation.SETUP_GROUPLOCATION_ID')
            ->where('risk_notify_repeat_sub.RISKREP_ID','=',$id)->get();
    
        return view('manager_risk.risk_notify_repeat',[
            'rigreps'=> $rigrep,
            'notify_repeats'=> $notify_repeat,
        ]);
    }

    public function risk_notify_repeat_sub(Request $request,$id)
    {
         $rigrep = Riskrep::leftjoin('risk_setincidence_setting','risk_rep.RISKREP_TITLE','=','risk_setincidence_setting.INCIDENCE_SETTING_ID')
         ->leftjoin('risk_setupincidence_grouplocation','risk_rep.RISKREP_LOCAL','=','risk_setupincidence_grouplocation.SETUP_GROUPLOCATION_ID')
         ->where('RISKREP_ID','=',$id)->first();

        $notify_repeat = Risk_notify_repeat_sub::where('RISKREP_ID','=',$id)->get();       
       
        $infoper = DB::table('hrd_person')->get();

        $maxnum = Risk_notify_repeat_sub::max('NOTIFY_REPEAT_NO');
        if($maxnum != '' ||  $maxnum != null){
         $refmax = Risk_notify_repeat_sub::where('NOTIFY_REPEAT_NO','=',$maxnum)->first();

         if($refmax->NOTIFY_REPEAT_NO != '' ||  $refmax->NOTIFY_REPEAT_NO != null){
         $maxpo = substr($refmax->NOTIFY_REPEAT_NO, -2)+1;
         }else{
         $maxref = 1;
         }
         $refe = str_pad($maxpo, 3, "0", STR_PAD_LEFT);
         }else{
        $refe = '001';
         }
         $billNo = $refe;



        return view('manager_risk.risk_notify_repeat_sub',[
            'infopers'=>$infoper,
            'rigreps'=>$rigrep,
            'notify_repeats'=> $notify_repeat,
            'billNos'=>$billNo,
        ]);
    }
    public function risk_notify_repeat_sub_save(Request $request)
    {
        $id_rig = $request->RISKREP_ID;
        $id_user = $request->PERSON;
       
        $date_repeat = $request->get('NOTIFY_REPEAT_DATE');      
        $date_bigen_c = Carbon::createFromFormat('d/m/Y', $date_repeat)->format('Y-m-d');
        $date_arrary=explode("-",$date_bigen_c);
    
        $y_sub_st = $date_arrary[0];
    
        if($y_sub_st >= 2500){
            $y = $y_sub_st-543;
        }else{
            $y = $y_sub_st;
        }    
        $m = $date_arrary[1];
        $d = $date_arrary[2];  
        $displaydate_repeat= $y."-".$m."-".$d;   
           
        $date = date('Y-m-d');
        $date_bigen_checks = strtotime($displaydate_repeat);       
        $dates =  strtotime($date);    
        $date_rep = date($displaydate_repeat);

        $add = new Risk_notify_repeat_sub();  
        $add->NOTIFY_REPEAT_NO = $request->NOTIFY_REPEAT_NO;
        $add->NOTIFY_REPEAT_DATE = $date_rep;       
        $add->NOTIFY_REPEAT_DETAIL = $request->NOTIFY_REPEAT_DETAIL;
        $add->NOTIFY_REPEAT_USER_SAVE = $id_user;
        $add->RISKREP_ID = $id_rig;
        if($request->hasFile('NOTIFY_REPEAT_FILE')){
            $file = $request->file('NOTIFY_REPEAT_FILE');
            $contents = $file->openFile()->fread($file->getSize());
            $add->NOTIFY_REPEAT_FILE = $contents;
        }
        $add->save();

        $id_repeat_sub =  Risk_notify_repeat_sub::max('NOTIFY_REPEAT_ID');

        if($request->INFER_REPEAT_DETAIL != '' || $request->INFER_REPEAT_DETAIL != null){
            $INFER_REPEAT_DETAIL = $request->INFER_REPEAT_DETAIL;           

            $number =count($INFER_REPEAT_DETAIL);
            $count = 0;
            for($count = 0; $count< $number; $count++)
            {            
                $add_infer_repeat = new Risk_notify_repeat_sub_infer();
                $add_infer_repeat->NOTIFY_REPEAT_ID = $id_repeat_sub;
                $add_infer_repeat->INFER_REPEAT_DETAIL = $INFER_REPEAT_DETAIL[$count];
                $add_infer_repeat->save();
            }
        }


        if($request->LIST_INFER_DETAIL != '' || $request->LIST_INFER_DETAIL != null){
            $LIST_INFER_DETAIL = $request->LIST_INFER_DETAIL;           

            $number =count($LIST_INFER_DETAIL);
            $count = 0;
            for($count = 0; $count< $number; $count++)
            {            
                $add_infer_list = new Risk_notify_repeat_sub_inferlist();
                $add_infer_list->NOTIFY_REPEAT_ID = $id_repeat_sub;
                $add_infer_list->LIST_INFER_DETAIL = $LIST_INFER_DETAIL[$count];
                $add_infer_list->save();
            }
        }


        if($request->BOARD_ID != '' || $request->BOARD_ID != null){
            $BOARD_ID = $request->BOARD_ID;           

            $number =count($BOARD_ID);
            $count = 0;
            for($count = 0; $count< $number; $count++)
            {            
                $user_info = DB::table('hrd_person')->where('ID','=',$BOARD_ID[$count])->first();

                $add_board = new Risk_notify_repeat_sub_board();
                $add_board->NOTIFY_REPEAT_ID = $id_repeat_sub;
                $add_board->BOARD_PER_ID = $BOARD_ID[$count];
                $add_board->BOARD_FNAME = $user_info->HR_FNAME;
                $add_board->BOARD_LNAME = $user_info->HR_LNAME;
                $add_board->save();
            }
        }

        
        if($request->BOARD_OUT_FNAME != '' || $request->BOARD_OUT_FNAME != null){
            $BOARD_OUT_FNAME = $request->BOARD_OUT_FNAME;    
            $BOARD_OUT_LNAME = $request->BOARD_OUT_LNAME;        

            $number =count($BOARD_OUT_FNAME);
            $count = 0;
            for($count = 0; $count< $number; $count++)
            {         
                $add_board_out = new Risk_notify_repeat_sub_board_out();
                $add_board_out->NOTIFY_REPEAT_ID = $id_repeat_sub;
                $add_board_out->BOARD_OUT_FNAME = $BOARD_OUT_FNAME[$count];
                $add_board_out->BOARD_OUT_LNAME = $BOARD_OUT_LNAME[$count];
                $add_board_out->save();
            }
        }


        if($request->TOPIC_REPEAT_HEAD != '' || $request->TOPIC_REPEAT_HEAD != null){
            $TOPIC_REPEAT_HEAD = $request->TOPIC_REPEAT_HEAD;   
            $TOPIC_REPEAT_DETAIL = $request->TOPIC_REPEAT_DETAIL;  
          
            $number =count($TOPIC_REPEAT_HEAD);
            $count = 0;
            for($count = 0; $count< $number; $count++)
            {         
                $add_topic = new Risk_notify_repeat_sub_topic_infer();
                $add_topic->NOTIFY_REPEAT_ID = $id_repeat_sub;
                $add_topic->TOPIC_REPEAT_HEAD = $TOPIC_REPEAT_HEAD[$count];   
                $add_topic->TOPIC_REPEAT_DETAIL = $TOPIC_REPEAT_DETAIL[$count];             
                $add_topic->save();
            }
        }


        return redirect()->route('mrisk.risk_notify_repeat',[
            'id'=> $id_rig 
        ]);
    }


    public function risk_notify_repeat_sub_edit(Request $request,$id,$idrig)
    {
       
         $rigrep = Riskrep::leftjoin('risk_setincidence_setting','risk_rep.RISKREP_TITLE','=','risk_setincidence_setting.INCIDENCE_SETTING_ID')
         ->leftjoin('risk_setupincidence_grouplocation','risk_rep.RISKREP_LOCAL','=','risk_setupincidence_grouplocation.SETUP_GROUPLOCATION_ID')
         ->where('RISKREP_ID','=',$idrig)->first();

        $notify_repeat = Risk_notify_repeat_sub::where('NOTIFY_REPEAT_ID','=',$id)->first();
        
        $infer_repeat = DB::table('risk_notify_repeat_sub_infer')->where('NOTIFY_REPEAT_ID','=',$id)->get();
        $infer_list_repeat = DB::table('risk_notify_repeat_sub_inferlist')->where('NOTIFY_REPEAT_ID','=',$id)->get();
        $board_repeat = DB::table('risk_notify_repeat_sub_board')->where('NOTIFY_REPEAT_ID','=',$id)->get();
        $board_out_repeat = DB::table('risk_notify_repeat_sub_board_out')->where('NOTIFY_REPEAT_ID','=',$id)->get();
        $topic_repeat = DB::table('risk_notify_repeat_sub_topic_infer')->where('NOTIFY_REPEAT_ID','=',$id)->get();
 
        $infoper = DB::table('hrd_person')->get();

        $maxnum = Risk_notify_repeat_sub::max('NOTIFY_REPEAT_NO');
        if($maxnum != '' ||  $maxnum != null){
         $refmax = Risk_notify_repeat_sub::where('NOTIFY_REPEAT_NO','=',$maxnum)->first();

         if($refmax->NOTIFY_REPEAT_NO != '' ||  $refmax->NOTIFY_REPEAT_NO != null){
         $maxpo = substr($refmax->NOTIFY_REPEAT_NO, -2)+1;
         }else{
         $maxref = 1;
         }
         $refe = str_pad($maxpo, 3, "0", STR_PAD_LEFT);
         }else{
        $refe = '001';
         }
         $billNo = $refe;



        return view('manager_risk.risk_notify_repeat_sub_edit',[
            'infopers'=>$infoper,
            'rigreps'=>$rigrep,
            'notify_repeats'=> $notify_repeat,
            
            'notify_repeats'=> $notify_repeat,
            'infer_repeats'=> $infer_repeat,
            'infer_list_repeats'=> $infer_list_repeat,
            'board_repeats'=> $board_repeat,
            'board_out_repeats'=> $board_out_repeat,
            'topic_repeats'=> $topic_repeat,
        ]);
    }
    public function risk_notify_repeat_sub_update(Request $request)
    {
        $id_repeat_sub = $request->NOTIFY_REPEAT_ID;
        $id_rig = $request->RISKREP_ID;
        $iduser = $request->PERSON;
     
        $date_repeat = $request->get('NOTIFY_REPEAT_DATE');      
        $date_bigen_c = Carbon::createFromFormat('d/m/Y', $date_repeat)->format('Y-m-d');
        $date_arrary=explode("-",$date_bigen_c);
    
        $y_sub_st = $date_arrary[0];
    
        if($y_sub_st >= 2500){
            $y = $y_sub_st-543;
        }else{
            $y = $y_sub_st;
        }
    
        $m = $date_arrary[1];
        $d = $date_arrary[2];  
        $displaydate_repeat= $y."-".$m."-".$d;
    
           
        $date = date('Y-m-d');
        $date_bigen_checks = strtotime($displaydate_repeat);
       
        $dates =  strtotime($date);
    
        $date_rep = date($displaydate_repeat);           
        $id_repeat_sub = $request->NOTIFY_REPEAT_ID;

        $update = Risk_notify_repeat_sub::find($id_repeat_sub);  
        $update->NOTIFY_REPEAT_NO = $request->NOTIFY_REPEAT_NO;
        $update->NOTIFY_REPEAT_DATE = $date_rep;       
        $update->NOTIFY_REPEAT_DETAIL = $request->NOTIFY_REPEAT_DETAIL;
        $update->NOTIFY_REPEAT_USER_SAVE =$iduser;
        $update->RISKREP_ID = $id_rig;
        if($request->hasFile('NOTIFY_REPEAT_FILE')){
            $file = $request->file('NOTIFY_REPEAT_FILE');
            $contents = $file->openFile()->fread($file->getSize());
            $update->NOTIFY_REPEAT_FILE = $contents;
        }
        $update->save();

        
        Risk_notify_repeat_sub_infer::where('NOTIFY_REPEAT_ID','=',$id_repeat_sub)->delete();

        if($request->INFER_REPEAT_DETAIL != '' || $request->INFER_REPEAT_DETAIL != null){
            $INFER_REPEAT_DETAIL = $request->INFER_REPEAT_DETAIL;           

            $number =count($INFER_REPEAT_DETAIL);
            $count = 0;
            for($count = 0; $count< $number; $count++)
            {            
                $up_infer_repeat = new Risk_notify_repeat_sub_infer();
                $up_infer_repeat->NOTIFY_REPEAT_ID = $id_repeat_sub;
                $up_infer_repeat->INFER_REPEAT_DETAIL = $INFER_REPEAT_DETAIL[$count];
                $up_infer_repeat->save();
            }
        }

        Risk_notify_repeat_sub_inferlist::where('NOTIFY_REPEAT_ID','=',$id_repeat_sub)->delete();

        if($request->LIST_INFER_DETAIL != '' || $request->LIST_INFER_DETAIL != null){
            $LIST_INFER_DETAIL = $request->LIST_INFER_DETAIL;           

            $number =count($LIST_INFER_DETAIL);
            $count = 0;
            for($count = 0; $count< $number; $count++)
            {            
                $up_infer_list = new Risk_notify_repeat_sub_inferlist();
                $up_infer_list->NOTIFY_REPEAT_ID = $id_repeat_sub;
                $up_infer_list->LIST_INFER_DETAIL = $LIST_INFER_DETAIL[$count];
                $up_infer_list->save();
            }
        }

        Risk_notify_repeat_sub_board::where('NOTIFY_REPEAT_ID','=',$id_repeat_sub)->delete();
        
        if($request->BOARD_ID != '' || $request->BOARD_ID != null){
            $BOARD_ID = $request->BOARD_ID;           

            $number =count($BOARD_ID);
            $count = 0;
            for($count = 0; $count< $number; $count++)
            {            
                $user_info = DB::table('hrd_person')->where('ID','=',$BOARD_ID[$count])->first();

                $up_board = new Risk_notify_repeat_sub_board();
                $up_board->NOTIFY_REPEAT_ID = $id_repeat_sub;
                $up_board->BOARD_PER_ID = $BOARD_ID[$count];
                $up_board->BOARD_FNAME = $user_info->HR_FNAME;
                $up_board->BOARD_LNAME = $user_info->HR_LNAME;
                $up_board->save();
            }
        }

        Risk_notify_repeat_sub_board_out::where('NOTIFY_REPEAT_ID','=',$id_repeat_sub)->delete();
        
        if($request->BOARD_OUT_FNAME != '' || $request->BOARD_OUT_FNAME != null){
            $BOARD_OUT_FNAME = $request->BOARD_OUT_FNAME;    
            $BOARD_OUT_LNAME = $request->BOARD_OUT_LNAME;        

            $number =count($BOARD_OUT_FNAME);
            $count = 0;
            for($count = 0; $count< $number; $count++)
            {         
                $up_board_out = new Risk_notify_repeat_sub_board_out();
                $up_board_out->NOTIFY_REPEAT_ID = $id_repeat_sub;
                $up_board_out->BOARD_OUT_FNAME = $BOARD_OUT_FNAME[$count];
                $up_board_out->BOARD_OUT_LNAME = $BOARD_OUT_LNAME[$count];
                $up_board_out->save();
            }
        }

        Risk_notify_repeat_sub_topic_infer::where('NOTIFY_REPEAT_ID','=',$id_repeat_sub)->delete();

        if($request->TOPIC_REPEAT_HEAD != '' || $request->TOPIC_REPEAT_HEAD != null){
            $TOPIC_REPEAT_HEAD = $request->TOPIC_REPEAT_HEAD;   
            $TOPIC_REPEAT_DETAIL = $request->TOPIC_REPEAT_DETAIL;  
          
            $number =count($TOPIC_REPEAT_HEAD);
            $count = 0;
            for($count = 0; $count< $number; $count++)
            {         
                $up_topic = new Risk_notify_repeat_sub_topic_infer();
                $up_topic->NOTIFY_REPEAT_ID = $id_repeat_sub;
                $up_topic->TOPIC_REPEAT_HEAD = $TOPIC_REPEAT_HEAD[$count];   
                $up_topic->TOPIC_REPEAT_DETAIL = $TOPIC_REPEAT_DETAIL[$count];             
                $up_topic->save();
            }
        }
       
        return redirect()->route('mrisk.risk_notify_repeat',[
            'id'=> $id_rig ,
            'iduser'=> $iduser 
        ]);
    }
    public function risk_notify_repeat_sub_destroy(Request $request,$id,$idrig)
    {
       
        Risk_notify_repeat_sub::destroy($id);
        Risk_notify_repeat_sub_infer::where('NOTIFY_REPEAT_ID',$id)->delete();
        Risk_notify_repeat_sub_inferlist::where('NOTIFY_REPEAT_ID',$id)->delete();
        Risk_notify_repeat_sub_board::where('NOTIFY_REPEAT_ID',$id)->delete();
        Risk_notify_repeat_sub_board_out::where('NOTIFY_REPEAT_ID',$id)->delete();
        Risk_notify_repeat_sub_topic_infer::where('NOTIFY_REPEAT_ID',$id)->delete();

        return redirect()->route('mrisk.risk_notify_repeat',[
            'id'=> $idrig,
           
         ]);

    }



    public function risk_report4(Request $request)
    {
       
   
        $infomationre4 = DB::table('risk_notify_report4')
        ->leftJoin('hrd_person','hrd_person.ID','=','risk_notify_report4.RISK_NOTIFY_RE4_PERSON')
        ->leftJoin('hrd_department_sub_sub','risk_notify_report4.RISK_NOTIFY_RE4_DEP','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->get();




        return view('manager_risk.risk_report4',[
            'infomationre4s'=>$infomationre4,          
        ]);

    }

    public function risk_report4_detail(Request $request,$idref)
    {
       
        $infore4 = DB::table('risk_notify_report4')
        ->leftJoin('hrd_person','hrd_person.ID','=','risk_notify_report4.RISK_NOTIFY_RE4_PERSON')
        ->leftJoin('hrd_department_sub_sub','risk_notify_report4.RISK_NOTIFY_RE4_DEP','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->where('RISK_NOTIFY_RE4_ID','=',$idref)->first();

        return view('manager_risk.risk_report4_detail',[
            'infore4'=>$infore4,          
        ]);

    }



    public function risk_report5(Request $request)
    {
       
        $infomationreport5 = DB::table('risk_notify_report5')
        ->select('RISK_NOTIFY_RE5_PERSON','RISK_NOTIFY_RE5_DEP','RISK_NOTIFY_RE5_ID','RISK_NOTIFY_RE5_YEAR','RISK_NOTIFY_RE5_ROUND','RISK_NOTIFY_RE5_BEGINDATE','RISK_NOTIFY_RE5_ENDDATE','HR_DEPARTMENT_SUB_SUB_NAME','HR_FNAME','HR_LNAME','risk_notify_report5.created_at')
        ->leftJoin('hrd_person','hrd_person.ID','=','risk_notify_report5.RISK_NOTIFY_RE5_PERSON')
        ->leftJoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','risk_notify_report5.RISK_NOTIFY_RE5_DEP')
        ->get();
   
        return view('manager_risk.risk_report5',[
            'infomationreport5s'=>$infomationreport5,          
        ]);
    }

    public function risk_report5_sub(Request $request,$idref)
    {
       
        $infomationreport5sub = DB::table('risk_notify_report5_sub')
        ->leftJoin('hrd_department_sub_sub','risk_notify_report5_sub.RISK_NOTIFY_RE5_SUB_DEP','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->where('RISK_NOTIFY_RE5_ID','=',$idref)->get();
   

        return view('manager_risk.risk_report5_sub',[
            'infomationreport5subs'=>$infomationreport5sub,  
        ]);

    }


     
 public function risk_account_incidence(Request $request,$idref)
 {    


 


       $inforisk = DB::table('risk_account_detail')->where('RISK_ACC_ID','=',$idref)->first();

        $infoincidence = Riskrep::leftjoin('risk_setincidence_setting','risk_rep.RISKREP_TITLE','=','risk_setincidence_setting.INCIDENCE_SETTING_ID')
        ->leftjoin('risk_status','risk_rep.RISKREP_STATUS','=','risk_status.RISK_STATUS_NAME')
        ->leftJoin('risk_rep_level','risk_rep.RISKREP_LEVEL','=','risk_rep_level.RISK_REP_LEVEL_ID')
        ->leftjoin('risk_setupincidence_location','risk_rep.RISKREP_SEARCHLOCATE','=','risk_setupincidence_location.INCIDENCE_LOCATION_ID')
        ->leftjoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','risk_rep.RISKREP_DEPARTMENT_SUB')
        ->leftjoin('risk_setupincidence_tpyelocation','risk_setupincidence_tpyelocation.SETUP_TYPELOCATION_ID','=','risk_rep.RISKREP_TYPE')
        ->leftjoin('risk_setupincidence_grouplocation','risk_setupincidence_grouplocation.SETUP_GROUPLOCATION_ID','=','risk_rep.RISKREP_LOCAL')
        ->leftjoin('risk_setupincidence_sub','risk_setupincidence_sub.INCIDENCE_SUB_ID','=','risk_rep.RISKREP_SUBTITLE')
        ->leftjoin('hrd_sex','hrd_sex.SEX_ID','=','risk_rep.RISKREP_SEX')
        ->where('risk_rep.RISKREP_ACC_ID','=',$idref)
        ->orderBy('RISKREP_ID','DESC')
        ->get();
 

     return view('manager_risk.risk_account_incidence',[      
         'infoincidences' => $infoincidence,   
         'inforisk' => $inforisk,   
         'idref' => $idref,  
        
     ]);
 }

    

 //===========================การทบทวน==============================

 public function detail_check_recheck(Request $request,$id)
 {
    $inforecheck = DB::table('risk_recheck')
    ->leftJoin('hrd_person','hrd_person.ID','=','risk_recheck.RISK_RECHECK_PERSON')
    ->where('RISK_RECHECK_RISKID','=',$id)->get();
    return view('manager_risk.detail_check_recheck',[
        'riskid' => $id,
        'inforechecks'=> $inforecheck
     ]);
 }


 public function detail_check_recheck_add(Request $request,$id)
 {           
    $person = DB::table('hrd_person')->get(); 
    $infodetailrisk = DB::table('risk_rep')->where('RISKREP_ID','=',$id)->first();
     return view('manager_risk.detail_check_recheck_add',[
        'riskid' => $id,
        'infodetailrisk' => $infodetailrisk,
        'persons' => $person 
     ]);
 }


 public function detail_check_recheck_save(Request $request)
 {

    $RECHECK_DATE= $request->RISK_RECHECK_DATE;

    if($RECHECK_DATE != ''){
        $STARTDAY = Carbon::createFromFormat('d/m/Y', $RECHECK_DATE)->format('Y-m-d');
        $date_arrary_st=explode("-",$STARTDAY);  
        $y_sub_st = $date_arrary_st[0]; 
        
        if($y_sub_st >= 2500){
            $y_st = $y_sub_st-543;
        }else{
            $y_st = $y_sub_st;
        }
        $m_st = $date_arrary_st[1];
        $d_st = $date_arrary_st[2];  
        $RECHECKDATE= $y_st."-".$m_st."-".$d_st;
        }else{
        $RECHECKDATE= null;
    }



    $addrecheck = new Riskrecheck(); 
    
    $addrecheck->RISK_RECHECK_DATE_SAVE  = date('Y-m-d');
    $addrecheck->RISK_RECHECK_DATE = $RECHECKDATE;

    $addrecheck->RISK_RECHECK_RISKID = $request->RISK_RECHECK_RISKID;

    $addrecheck->RISK_RECHECK_HEAD = $request->RISK_RECHECK_HEAD;
    $addrecheck->RISK_RECHECK_DETAIL = $request->RISK_RECHECK_DETAIL;
    $addrecheck->RISK_RECHECK_TOTAL = $request->RISK_RECHECK_TOTAL;
    $addrecheck->RISK_RECHECK_PERSON = $request->RISK_RECHECK_PERSON;



    $maxid = Riskrecheck::max('RISK_RECHECK_ID');

    $idfile = $maxid+1;
    if($request->hasFile('pdfupload')){
        $newFileName = 'recheck_'.$idfile.'.'.$request->pdfupload->extension();
          
        $request->pdfupload->storeAs('riskpdf',$newFileName,'public');

        $addrecheck->RISK_RECHECK_FILE = 'True';
        $addrecheck->RISK_RECHECKE_NAME = $newFileName;
    }

    if($request->hasFile('fileupload')){
        $newFileName = 'recheck2_'.$idfile.'.'.$request->fileupload->extension();
          
        $request->fileupload->storeAs('riskpdf',$newFileName,'public');

        $addrecheck->RISK_RECHECK_FILE_2 = 'True';
        $addrecheck->RISK_RECHECK_NAME_2 = $newFileName;
        $addrecheck->RISK_RECHECK_NAME_OLD =  $request->file('fileupload')->getClientOriginalName();
    }

    $addrecheck->save();


    $risk_id = $addrecheck->RISK_RECHECK_RISKID;


    return redirect()->route('mrisk.detail_check_recheck',[
        'id' => $risk_id
    ]);

 }

 
 public function detail_check_recheck_edit(Request $request,$id,$idref)
 {             
    $person = DB::table('hrd_person')->get(); 
    $inforecheck  = DB::table('risk_recheck')->where('RISK_RECHECK_ID','=',$idref)->first(); 

     return view('manager_risk.detail_check_recheck_edit',[
        'riskid' => $id,
        'persons' => $person, 
        'inforecheck' => $inforecheck
     ]);
 }


 public function detail_check_recheck_update(Request $request)
 {

    $RECHECK_DATE= $request->RISK_RECHECK_DATE;

    if($RECHECK_DATE != ''){
        $STARTDAY = Carbon::createFromFormat('d/m/Y', $RECHECK_DATE)->format('Y-m-d');
        $date_arrary_st=explode("-",$STARTDAY);  
        $y_sub_st = $date_arrary_st[0]; 
        
        if($y_sub_st >= 2500){
            $y_st = $y_sub_st-543;
        }else{
            $y_st = $y_sub_st;
        }
        $m_st = $date_arrary_st[1];
        $d_st = $date_arrary_st[2];  
        $RECHECKDATE= $y_st."-".$m_st."-".$d_st;
        }else{
        $RECHECKDATE= null;
    }

    $idref =  $request->RISK_RECHECK_ID;

    $addrecheck =  Riskrecheck::find($idref); 
    
    $addrecheck->RISK_RECHECK_DATE_SAVE  = date('Y-m-d');
    $addrecheck->RISK_RECHECK_DATE = $RECHECKDATE;

    $addrecheck->RISK_RECHECK_RISKID = $request->RISK_RECHECK_RISKID;

    $addrecheck->RISK_RECHECK_HEAD = $request->RISK_RECHECK_HEAD;
    $addrecheck->RISK_RECHECK_DETAIL = $request->RISK_RECHECK_DETAIL;
    $addrecheck->RISK_RECHECK_TOTAL = $request->RISK_RECHECK_TOTAL;
    $addrecheck->RISK_RECHECK_PERSON = $request->RISK_RECHECK_PERSON;



    $maxid = Riskrecheck::max('RISK_RECHECK_ID');

    $idfile = $maxid+1;
    if($request->hasFile('pdfupload')){
        $newFileName = 'recheck_'.$idfile.'.'.$request->pdfupload->extension();
          
        $request->pdfupload->storeAs('riskpdf',$newFileName,'public');

        $addrecheck->RISK_RECHECK_FILE = 'True';
        $addrecheck->RISK_RECHECKE_NAME = $newFileName;
    }

    if($request->hasFile('fileupload')){
        $newFileName = 'recheck2_'.$idfile.'.'.$request->fileupload->extension();
          
        $request->fileupload->storeAs('riskpdf',$newFileName,'public');

        $addrecheck->RISK_RECHECK_FILE_2 = 'True';
        $addrecheck->RISK_RECHECK_NAME_2 = $newFileName;
        $addrecheck->RISK_RECHECK_NAME_OLD =  $request->file('fileupload')->getClientOriginalName();
    }

    $addrecheck->save();


    $risk_id = $addrecheck->RISK_RECHECK_RISKID;


    return redirect()->route('mrisk.detail_check_recheck',[
        'id' => $risk_id
    ]);

 }

  //===========

  public function risk_notify_account_level(Request $request,$idref)
 {     
        $infomationlevel = DB::table('risk_account_detail_level')
        ->leftJoin('risk_account_detail_leveltype','risk_account_detail_level.RISK_ACCDE_LE_RATE','=','risk_account_detail_leveltype.RISK_LEVELTYPE_ID')
        ->where('RISK_ACC_ID','=',$idref)->get();
 
        $infoleveltype = DB::table('risk_account_detail_leveltype')->get();

     return view('manager_risk.risk_notify_account_level',[     
         'infomationlevels' => $infomationlevel,  
         'infoleveltypes' => $infoleveltype, 
         'idref' => $idref,  
        
     ]);
 }

 
 public function risk_account_detail_level_save(Request $request)
    {  


        $RISKACCID = $request->RISK_ACC_ID;


                $add= new risk_account_detail_level();
                $add->RISK_ACC_ID = $RISKACCID;
                $add->RISK_ACCDE_LE_YEAR = $request->RISK_ACCDE_LE_YEAR;   
                $add->RISK_ACCDE_LE_RATE = $request->RISK_ACCDE_LE_RATE; 
                $add->RISK_ACCDE_LE_CHANCE = $request->RISK_ACCDE_LE_CHANCE; 
                $add->RISK_ACCDE_LE_EFFECT = $request->RISK_ACCDE_LE_EFFECT;         
                $add->RISK_ACCDE_LE_SCORE = $request->RISK_ACCDE_LE_SCORE; 
                $add->RISK_ACCDE_LE_ACCEPTABLE = $request->RISK_ACCDE_LE_ACCEPTABLE; 
                $add->save();


        return redirect()->route('mrisk.risk_notify_account_level',[
            'idref'=> $RISKACCID,
            ]);
    }


 public function risk_account_detail_level_update(Request $request)
 {  


     $RISKACCID = $request->RISK_ACC_ID;

     $idref = $request->RISK_ACCDE_LE_ID;

             $add=  risk_account_detail_level::find($idref);
             $add->RISK_ACC_ID = $RISKACCID;
             $add->RISK_ACCDE_LE_YEAR = $request->RISK_ACCDE_LE_YEAR;   
             $add->RISK_ACCDE_LE_RATE = $request->RISK_ACCDE_LE_RATE; 
             $add->RISK_ACCDE_LE_CHANCE = $request->RISK_ACCDE_LE_CHANCE; 
             $add->RISK_ACCDE_LE_EFFECT = $request->RISK_ACCDE_LE_EFFECT;         
             $add->RISK_ACCDE_LE_SCORE = $request->RISK_ACCDE_LE_SCORE; 
             $add->RISK_ACCDE_LE_ACCEPTABLE = $request->RISK_ACCDE_LE_ACCEPTABLE; 
             $add->save();


             return redirect()->route('mrisk.risk_notify_account_level',[
                 'idref'=> $RISKACCID,
                 ]);
 }


 
public function risk_account_detail_update(Request $request)
{  


    $idref = $request->RISK_ACC_ID;

  
            $add=  Risk_account_detail::find($idref);
            $add->RISK_TYPE_ID  = $request->RISK_TYPE_ID;  
            $add->RISK_ACC_FACTOR  = $request->RISK_ACC_FACTOR;  
            $add->RISK_ACC_ISSUE = $request->RISK_ACC_ISSUE;   
            $add->RISK_ACC_MISSION = $request->RISK_ACC_MISSION; 
            $add->RISK_ACC_OBJ = $request->RISK_ACC_OBJ;  
            $add->RISK_ACC_CONTROLS = $request->RISK_ACC_CONTROLS; 
            $add->RISK_ACC_AGENCY = $request->RISK_ACC_AGENCY;
            $add->save();


            return redirect()->route('mrisk.risk_account');
}



    
public function risk_notify_account_incidence(Request $request,$idref)
{    
 


      $inforisk = DB::table('risk_account_detail')->where('RISK_ACC_ID','=',$idref)->first();

       $infoincidence = Riskrep::leftjoin('risk_setincidence_setting','risk_rep.RISKREP_TITLE','=','risk_setincidence_setting.INCIDENCE_SETTING_ID')
       ->leftjoin('risk_status','risk_rep.RISKREP_STATUS','=','risk_status.RISK_STATUS_NAME')
       ->leftJoin('risk_rep_level','risk_rep.RISKREP_LEVEL','=','risk_rep_level.RISK_REP_LEVEL_ID')
       ->leftjoin('risk_setupincidence_location','risk_rep.RISKREP_SEARCHLOCATE','=','risk_setupincidence_location.INCIDENCE_LOCATION_ID')
       ->leftjoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','risk_rep.RISKREP_DEPARTMENT_SUB')
       ->leftjoin('risk_setupincidence_tpyelocation','risk_setupincidence_tpyelocation.SETUP_TYPELOCATION_ID','=','risk_rep.RISKREP_TYPE')
       ->leftjoin('risk_setupincidence_grouplocation','risk_setupincidence_grouplocation.SETUP_GROUPLOCATION_ID','=','risk_rep.RISKREP_LOCAL')
       ->leftjoin('risk_setupincidence_sub','risk_setupincidence_sub.INCIDENCE_SUB_ID','=','risk_rep.RISKREP_SUBTITLE')
       ->leftjoin('hrd_sex','hrd_sex.SEX_ID','=','risk_rep.RISKREP_SEX')
       ->where('risk_rep.RISKREP_ACC_ID','=',$idref)
       ->orderBy('RISKREP_ID','DESC')
       ->get();


    return view('manager_risk.risk_notify_account_incidence',[     
        'infoincidences' => $infoincidence,   
        'inforisk' => $inforisk,   
        'idref' => $idref,  
       
    ]);
}



//------------------------Start Report------------------------------------//

public function report_riskNRLS()
{    
 

    $m_budget = date("m");
    if($m_budget>9){
    $yearbudget = date("Y")+544;
    }else{
    $yearbudget = date("Y")+543;   
     }
 

    $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
  
    $displaydate_bigen = ($yearbudget-544).'-10-01';
    $displaydate_end = ($yearbudget-543).'-09-30';
    $search = '';
    $year_id = $yearbudget;  
  
    
    $rigrep =Riskrep::leftjoin('risk_setincidence_setting','risk_rep.RISKREP_TITLE','=','risk_setincidence_setting.INCIDENCE_SETTING_ID') 
    ->leftJoin('risk_rep_level','risk_rep.RISKREP_LEVEL','=','risk_rep_level.RISK_REP_LEVEL_ID')    
    ->leftJoin('risk_rep_items','risk_rep.RISK_REPITEMS_ID','=','risk_rep_items.RISK_REPITEMS_ID')  
    ->leftjoin('risk_status','risk_rep.RISKREP_STATUS','=','risk_status.RISK_STATUS_NAME')
    ->leftjoin('risk_setupincidence_location','risk_rep.RISKREP_SEARCHLOCATE','=','risk_setupincidence_location.INCIDENCE_LOCATION_ID')
    ->leftjoin('hrd_department_sub_sub','risk_rep.RISKREP_DEPARTMENT_SUB','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
    ->leftjoin('hrd_department_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
    ->leftjoin('hrd_department','hrd_department_sub.HR_DEPARTMENT_ID','=','hrd_department.HR_DEPARTMENT_ID')
    ->leftjoin('hrd_team','hrd_team.HR_TEAM_NAME','=','risk_rep.RISKREP_TEAM_CODE')
    ->leftjoin('risk_rep_location','risk_rep_location.RISK_LOCATION_ID','=','risk_rep.RISKREP_LOCAL')
    ->leftjoin('risk_rep_time','risk_rep_time.RISK_TIME_ID','=','risk_rep.RISKREP_FATE')
    ->leftjoin('risk_setupincidence_usereffect','risk_setupincidence_usereffect.INCEDENCE_USEREFFECT_ID','=','risk_rep.RISK_REP_EFFECT')
    ->leftjoin('risk_setupincidence_origin','risk_setupincidence_origin.INCIDENCE_ORIGIN_ID','=','risk_rep.RISKREP_LOCALUSE')
    ->WhereBetween('RISKREP_STARTDATE',[$displaydate_bigen,$displaydate_end]) 
    ->orderBy('RISKREP_ID', 'desc')->get();    


    $info_org = DB::table('info_org')->where('ORG_ID','=','1')->first();


    return view('manager_risk.report_riskNRLS',[
      'displaydate_bigen'=> $displaydate_bigen,
      'displaydate_end'=> $displaydate_end,
      'search'=> $search,
      'budgets' =>  $budget,
      'year_id'=>$year_id,
      'rigreps'=>$rigrep,
      'info_org'=>$info_org,
    ]);
}


public function report_riskNRLS_search(Request $request)
{    
 

    $search = $request->get('search');
    $datebigin = $request->get('DATE_BIGIN');
    $dateend = $request->get('DATE_END');
    $yearbudget = $request->BUDGET_YEAR;
   
    if($search==''){
        $search="";
    }

    $date_bigen_c = Carbon::createFromFormat('d/m/Y', $datebigin)->format('Y-m-d');
    $date_arrary=explode("-",$date_bigen_c);

    $y_sub_st = $date_arrary[0];

    if($y_sub_st >= 2500){
        $y = $y_sub_st-543;
    }else{
        $y = $y_sub_st;
    }

    $m = $date_arrary[1];
    $d = $date_arrary[2];  
    $displaydate_bigen= $y."-".$m."-".$d;

    $date_end_c = Carbon::createFromFormat('d/m/Y', $dateend)->format('Y-m-d');
    $date_arrary_e=explode("-",$date_end_c); 

    $y_sub_e = $date_arrary_e[0];

    if($y_sub_e >= 2500){
        $y_e = $y_sub_e-543;
    }else{
        $y_e = $y_sub_e;
    }

    $m_e = $date_arrary_e[1];
    $d_e = $date_arrary_e[2];  
    $displaydate_end= $y_e."-".$m_e."-".$d_e;
 

    $from = date($displaydate_bigen);
    $to = date($displaydate_end);


    
    $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
  
    $year_id = $yearbudget; 
  
    
    $rigrep =Riskrep::leftjoin('risk_setincidence_setting','risk_rep.RISKREP_TITLE','=','risk_setincidence_setting.INCIDENCE_SETTING_ID') 
    ->leftJoin('risk_rep_level','risk_rep.RISKREP_LEVEL','=','risk_rep_level.RISK_REP_LEVEL_ID')    
    ->leftJoin('risk_rep_items','risk_rep.RISK_REPITEMS_ID','=','risk_rep_items.RISK_REPITEMS_ID')  
    ->leftjoin('risk_status','risk_rep.RISKREP_STATUS','=','risk_status.RISK_STATUS_NAME')
    ->leftjoin('risk_setupincidence_location','risk_rep.RISKREP_SEARCHLOCATE','=','risk_setupincidence_location.INCIDENCE_LOCATION_ID')
    ->leftjoin('hrd_department_sub_sub','risk_rep.RISKREP_DEPARTMENT_SUB','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
    ->leftjoin('hrd_department_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
    ->leftjoin('hrd_department','hrd_department_sub.HR_DEPARTMENT_ID','=','hrd_department.HR_DEPARTMENT_ID')
    ->leftjoin('hrd_team','hrd_team.HR_TEAM_NAME','=','risk_rep.RISKREP_TEAM_CODE')
    ->leftjoin('risk_rep_location','risk_rep_location.RISK_LOCATION_ID','=','risk_rep.RISKREP_LOCAL')
    ->leftjoin('risk_rep_time','risk_rep_time.RISK_TIME_ID','=','risk_rep.RISKREP_FATE')
    ->leftjoin('risk_setupincidence_usereffect','risk_setupincidence_usereffect.INCEDENCE_USEREFFECT_ID','=','risk_rep.RISK_REP_EFFECT')
    ->leftjoin('risk_setupincidence_origin','risk_setupincidence_origin.INCIDENCE_ORIGIN_ID','=','risk_rep.RISKREP_LOCALUSE')
    ->where(function($q) use ($search){
        $q->where('RISK_REPITEMS_CODE','like','%'.$search.'%');
        $q->orwhere('RISKREP_DETAILRISK2','like','%'.$search.'%'); 
        $q->orwhere('RISKREP_SEX','like','%'.$search.'%');   
        $q->orwhere('RISKREP_AGE','like','%'.$search.'%');   
        $q->orwhere('INCEDENCE_USEREFFECT_CODE','like','%'.$search.'%');   
        $q->orwhere('INCIDENCE_ORIGIN_NAME','like','%'.$search.'%');
        $q->orwhere('RISK_TIME_COMMENT','like','%'.$search.'%');   
        $q->orwhere('RISK_REP_LEVEL_CODE','like','%'.$search.'%');   
        $q->orwhere('RISKREP_DETAILRISK','like','%'.$search.'%');           
    })
    ->WhereBetween('RISKREP_STARTDATE',[$from,$to]) 
    ->orderBy('RISKREP_ID', 'desc')->get();    


    $info_org = DB::table('info_org')->where('ORG_ID','=','1')->first();


    return view('manager_risk.report_riskNRLS',[
      'displaydate_bigen'=> $displaydate_bigen,
      'displaydate_end'=> $displaydate_end,
      'search'=> $search,
      'budgets' =>  $budget,
      'year_id'=>$year_id,
      'rigreps'=>$rigrep,
      'info_org'=>$info_org,
    ]);
}


public function report_riskNRLS_excel(Request $request,$year_id,$displaydate_bigen,$displaydate_end,$search)
{    
 

    $search = $search;
    $datebigin = $displaydate_bigen;
    $dateend = $displaydate_end;
    $yearbudget = $year_id;
   
    if($search=='null'){
        $search="";
    }

    

    $from = $displaydate_bigen;
    $to = $displaydate_end;


    
    $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
  
    $year_id = $yearbudget; 
  
    
    $rigrep =Riskrep::leftjoin('risk_setincidence_setting','risk_rep.RISKREP_TITLE','=','risk_setincidence_setting.INCIDENCE_SETTING_ID') 
    ->leftJoin('risk_rep_level','risk_rep.RISKREP_LEVEL','=','risk_rep_level.RISK_REP_LEVEL_ID')    
    ->leftJoin('risk_rep_items','risk_rep.RISK_REPITEMS_ID','=','risk_rep_items.RISK_REPITEMS_ID')  
    ->leftjoin('risk_status','risk_rep.RISKREP_STATUS','=','risk_status.RISK_STATUS_NAME')
    ->leftjoin('risk_setupincidence_location','risk_rep.RISKREP_SEARCHLOCATE','=','risk_setupincidence_location.INCIDENCE_LOCATION_ID')
    ->leftjoin('hrd_department_sub_sub','risk_rep.RISKREP_DEPARTMENT_SUB','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
    ->leftjoin('hrd_department_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
    ->leftjoin('hrd_department','hrd_department_sub.HR_DEPARTMENT_ID','=','hrd_department.HR_DEPARTMENT_ID')
    ->leftjoin('hrd_team','hrd_team.HR_TEAM_NAME','=','risk_rep.RISKREP_TEAM_CODE')
    ->leftjoin('risk_rep_location','risk_rep_location.RISK_LOCATION_ID','=','risk_rep.RISKREP_LOCAL')
    ->leftjoin('risk_rep_time','risk_rep_time.RISK_TIME_ID','=','risk_rep.RISKREP_FATE')
    ->leftjoin('risk_setupincidence_usereffect','risk_setupincidence_usereffect.INCEDENCE_USEREFFECT_ID','=','risk_rep.RISK_REP_EFFECT')
    ->leftjoin('risk_setupincidence_origin','risk_setupincidence_origin.INCIDENCE_ORIGIN_ID','=','risk_rep.RISKREP_LOCALUSE')
    ->where(function($q) use ($search){
        $q->where('RISK_REPITEMS_CODE','like','%'.$search.'%');
        $q->orwhere('RISKREP_DETAILRISK2','like','%'.$search.'%'); 
        $q->orwhere('RISKREP_SEX','like','%'.$search.'%');   
        $q->orwhere('RISKREP_AGE','like','%'.$search.'%');   
        $q->orwhere('INCEDENCE_USEREFFECT_CODE','like','%'.$search.'%');   
        $q->orwhere('INCIDENCE_ORIGIN_NAME','like','%'.$search.'%');
        $q->orwhere('RISK_TIME_COMMENT','like','%'.$search.'%');   
        $q->orwhere('RISK_REP_LEVEL_CODE','like','%'.$search.'%');   
        $q->orwhere('RISKREP_DETAILRISK','like','%'.$search.'%');           
    })
    ->WhereBetween('RISKREP_STARTDATE',[$from,$to]) 
    ->orderBy('RISKREP_ID', 'desc')->get();    


    $info_org = DB::table('info_org')->where('ORG_ID','=','1')->first();


    return view('manager_risk.report_riskNRLS_excel',[
      'displaydate_bigen'=> $displaydate_bigen,
      'displaydate_end'=> $displaydate_end,
      'search'=> $search,
      'budgets' =>  $budget,
      'year_id'=>$year_id,
      'rigreps'=>$rigrep,
      'info_org'=>$info_org,
    ]);
}



//======================================

public function riskaffectperson(Request $request)
{    
    $riskinfoperson = DB::table('risk_setupincidence_usereffect')->get(); 
        
    return view('manager_risk.riskaffectperson',[
        'riskinfopersons'=>$riskinfoperson,        
    ]);
}
public function riskaffectperson_save(Request $request)
{    
    $add = new Risk_setupincidence_usereffect();
    $add->INCEDENCE_USEREFFECT_CODE = $request->INCEDENCE_USEREFFECT_CODE;
    $add->INCEDENCE_USEREFFECT_NAME = $request->INCEDENCE_USEREFFECT_NAME;
    $add->save();
    return redirect()->route('mrisk.riskaffectperson');
}
public function riskaffectperson_update(Request $request)
{    
    $id = $request->risk_id;
    $update = Risk_setupincidence_usereffect::find($id);
    $update->INCEDENCE_USEREFFECT_CODE = $request->INCEDENCE_USEREFFECT_CODE;
    $update->INCEDENCE_USEREFFECT_NAME = $request->INCEDENCE_USEREFFECT_NAME;
    $update->save();
    return redirect()->route('mrisk.riskaffectperson');
}
public function riskaffectperson_destroy(Request $request,$id)
{    
    Risk_setupincidence_usereffect::destroy($id);

    return redirect()->route('mrisk.riskaffectperson');
}


//======================================

public function risklocationuse(Request $request)
{    
    $riskinfocidence_origin = DB::table('risk_setupincidence_origin')
    ->leftJoin('risk_rep_location','risk_setupincidence_origin.ORIGIN_DEPART_ID','=','risk_rep_location.RISK_LOCATION_ID')
    ->get(); 
    
    $infolocation = DB::table('supplies_location')->get();
    $infolocationtype =  DB::table('risk_rep_location')->get();

    return view('manager_risk.risklocationuse',[
        'riskinfocidence_origins'=>$riskinfocidence_origin,   
        'infolocations'=>$infolocation,
        'infolocationtypes'=>$infolocationtype,     
    ]);
}
public function risklocationuse_save(Request $request)
{    
    $add = new Setupincidence_origin();
    $add->INCIDENCE_ORIGIN_CODE = $request->INCIDENCE_ORIGIN_CODE;
    $add->LOCATION_ID = $request->LOCATION_ID;
    $add->LOCATION_NAME = $request->LOCATION_NAME;
      $datalocation = DB::table('supplies_location')->where('LOCATION_ID','=',$request->LOCATION_ID)->first();
    $add->INCIDENCE_ORIGIN_NAME = $datalocation->LOCATION_NAME;
    $add->ORIGIN_DEPART_ID = $request->ORIGIN_DEPART_ID;
    $add->save();

    return redirect()->route('mrisk.risklocationuse');
}
public function risklocationuse_update(Request $request)
{    
    $id = $request->risk_id;
    $update = Setupincidence_origin::find($id);
    $update->LOCATION_ID = $request->LOCATION_ID;
    $update->LOCATION_NAME = $request->LOCATION_NAME;
    
        $datalocation = DB::table('supplies_location')->where('LOCATION_ID','=',$request->LOCATION_ID)->first();
    $update->INCIDENCE_ORIGIN_NAME = $datalocation->LOCATION_NAME;
    $update->ORIGIN_DEPART_ID = $request->ORIGIN_DEPART_ID;
    $update->save();
    return redirect()->route('mrisk.risklocationuse');
}
public function risklocationuse_destroy(Request $request,$id)
{    
    Setupincidence_origin::destroy($id);

    return redirect()->route('mrisk.risklocationuse');
}

}

