<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Report\AssetReportController;
use App\Http\Controllers\Web_meta_data_Controller;
use App\Models\Assetarticle;
use App\Models\Assetbuilding;
use App\Models\Assetdepreciate;
use App\Models\Assetdepreciatebuilding;
use App\Models\Assetland;
use App\Models\Assetrequest;
use App\Models\Assetrequestlend;
use App\Models\Assetrequestlendsub;
use App\Models\Assetrequestsub;
use App\Models\Supplieslocation;
use App\Models\Supplieslocationlevel;
use App\Models\Supplieslocationlevelroom;
use App\Models\Informrepairindex;
use App\Models\Informcomrepair;
use App\Models\Assetcarerepair;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

use App\Models\Supplies;
use App\Models\Suppliesrequest;
use App\Models\Suppliescon;
use App\Models\Suppliesgroup;
use App\Models\Suppliesclass;
use App\Models\Suppliestypes;
use App\Models\Suppliesprop;
use App\Models\Suppliesunitref;
use App\Models\Suppliesconlist;
use App\Models\Suppliespurchase;
use App\Models\Suppliesconboard;
use App\Models\Suppliesconquotation;
use App\Models\Suppliesconboarddetail;

date_default_timezone_set("Asia/Bangkok");

class ManagerassetController extends Controller
{
    public function dashboard()
    {
        $data['budgetyear']          = 'all';
        $year_now                    = getBudgetYear() - 543; // ปี ค.ศ. ปัจจุบัน กำหนดก่อนมีการเลือกจาก dashboard
        $data['budgetyear_dropdown'] = getBudgetYearAmount_all();
        if (!empty($_GET['budgetyear'])) {
            $data['budgetyear'] = $_GET['budgetyear'];
        }
 
        $year                  = $data['budgetyear']; // ปี พ.ศ.
        $year_ad               = ($year != 'all')?$year - 543:'all'; // ปี ค.ศ.   // แยกใช้ตามแต่ฟังก์ชั่น
        $assetReport           = new AssetReportController();
        $data['durable_data']  = $assetReport->sum_and_count_durable($year_ad);
        $data['building_data'] = $assetReport->sum_and_count_building($year_ad);
        $data['asset_5year']   = $assetReport->sum_building_and_durable($year_now, 5); // กำหนดปีที่จะดึงออกมาได้ (ปีสิ้นสุดข้อมูล , จำนวนปีที่)
        $data['total_building']    = 0;
        $data['total_durable']    = 0;
        foreach ($data['asset_5year'] as $row) {
            $data['total_building'] += $row['total_building'];
            $data['total_durable'] += $row['total_durable'];
        }
        $data['supplies_budget'] =  $assetReport->sum_price_suppliesbudget_by_durable($year_ad);

        $durable_10year   = $assetReport->sum_durable_by_supplies_budget($year_now, 10); // กำหนดปีที่จะดึงออกมาได้ (ปีสิ้นสุดข้อมูล , จำนวนปีที่)
        $building_10year   = $assetReport->sum_building_by_supplies_budget($year_now, 10); // กำหนดปีที่จะดึงออกมาได้ (ปีสิ้นสุดข้อมูล , จำนวนปีที่)
        $title = "[[";
        foreach ($durable_10year['title'] as $value) {
            $title .= "'".$value."',";
        }
        $title .= "],";
        foreach($durable_10year['content'] as $row){
            $title .= "[";
            foreach($row as $key => $value){
                if($key == 'year'){
                    $title .= "'".$value."',";
                }else{
                    $title .= "".$value.",";
                }
            }
            $title .= "],";
        }
        $title .= "]";

        $data['durable_10year'] = $title;
        //////////////////////////////////////////////////////
        $title = "[[";
        foreach ($building_10year['title'] as $value) {
            $title .= "'".$value."',";
        }
        $title .= "],";
        foreach($building_10year['content'] as $row){
            $title .= "[";
            foreach($row as $key => $value){
                if($key == 'year'){
                    $title .= "'".$value."',";
                }else{
                    $title .= "".$value.",";
                }
            }
            $title .= "],";
        }
        $title .= "]";
        $data['building_10year'] = $title;
        unset($title);
        return view('manager_asset.dashboard_asset', $data);
    }

    public function durable_search()
    {
        $data['budgetyear']          = getBudgetYear();
        $data['budgetyear_dropdown'] = getBudgetYearAmount_all();
        $data['budget_dropdown'] = DB::table('supplies_budget')->where('ACTIVE',true)->get();
        $data['budget_dropdown_header'][0] = array(
            'BUDGET_ID' => 'all',
            'BUDGET_NAME' => 'ทุกประเภท'
        );
        $data['budgetyear'] = (!empty($_GET['year']))?$_GET['year']:$data['budgetyear'];
        $data['budget'] = (!empty($_GET['budget']))?$_GET['budget']:'all';
        $year_ad = ($data['budgetyear'] != 'all')?$data['budgetyear']-543:$data['budgetyear'];
        $assetReport = new AssetReportController();
        $data['duration_table'] = $assetReport->get_duration_by_budget_year($data['budget'],$year_ad);
        $data['duration_count'] = $assetReport->count_duration_by_budget_year($data['budget'],$year_ad);
        $data['duration_M'] = $assetReport->sum_duration_by_budget_M($data['budget'],$year_ad);
        $metadata = new Web_meta_data_Controller();
        $data['status_graph'] = $metadata->getValueByName('displaygraph_class');
        return view('manager_asset.asset_durable_search',$data);
    }
    public function buiding_search()
    {
        $data['budgetyear']          = getBudgetYear();
        $data['budgetyear_dropdown'] = getBudgetYearAmount_all();
        $data['budget_dropdown'] = DB::table('supplies_budget')->where('ACTIVE',true)->get();
        $data['budget_dropdown_header'][0] = array(
            'BUDGET_ID' => 'all',
            'BUDGET_NAME' => 'ทุกประเภท'
        );
        $data['budgetyear'] = (!empty($_GET['year']))?$_GET['year']:$data['budgetyear'];
        $data['budget'] = (!empty($_GET['budget']))?$_GET['budget']:'all';
        $year_ad = ($data['budgetyear'] != 'all')?$data['budgetyear']-543:$data['budgetyear'];
        $assetReport = new AssetReportController();
        $data['buiding_table'] = $assetReport->get_buiding_by_budget_year($data['budget'],$year_ad);
        $data['buiding_count'] = $assetReport->count_buiding_by_budget_year($data['budget'],$year_ad);
        $data['buiding_M'] = $assetReport->sum_buiding_by_budget_M($data['budget'],$year_ad);
        $metadata = new Web_meta_data_Controller();
        $data['status_graph'] = $metadata->getValueByName('displaygraph_class');
        return view('manager_asset.asset_buiding_search',$data);
        
    }
    public function durable_buiding_search()
    {
        $data['budgetyear']          = getBudgetYear();
        $data['budgetyear_dropdown'] = getBudgetYearAmount_all();
        $data['budget_dropdown'] = DB::table('supplies_budget')->where('ACTIVE',true)->get();
        $data['budget_dropdown_header'][0] = array(
            'BUDGET_ID' => 'all',
            'BUDGET_NAME' => 'ทุกประเภท'
        );
        $data['budgetyear'] = (!empty($_GET['year']))?$_GET['year']:$data['budgetyear'];
        $data['budget'] = (!empty($_GET['budget']))?$_GET['budget']:'all';
        $year_ad = ($data['budgetyear'] != 'all')?$data['budgetyear']-543:$data['budgetyear'];
        $assetReport = new AssetReportController();
        $data['buiding_table'] = $assetReport->get_buiding_by_budget_year($data['budget'],$year_ad);
        $data['buiding_count'] = $assetReport->count_buiding_by_budget_year($data['budget'],$year_ad);
        $data['duration_table'] = $assetReport->get_duration_by_budget_year($data['budget'],$year_ad);
        $data['duration_count'] = $assetReport->count_duration_by_budget_year($data['budget'],$year_ad);
        return view('manager_asset.asset_durable_buiding_search',$data);
    }

    public function assetinfo(Request $request)
    {
        if(!empty($request->_token)){
            $SEND_TYPE = $request->get('SEND_TYPE');
            $search = $request->get('search');
            session([
                'manager_asset.assetinfo.SEND_TYPE' => $SEND_TYPE,
                'manager_asset.assetinfo.search' => $search,
                ]);
        }elseif(!empty(session('manager_asset.assetinfo'))){
            $SEND_TYPE     = session('manager_asset.assetinfo.SEND_TYPE');
            $search     = session('manager_asset.assetinfo.search');
        }else{
            $SEND_TYPE     = '';
            $search     = '';
        }


            if($SEND_TYPE !== "" && $SEND_TYPE !== null){

                $infoasset = Assetarticle::leftJoin('supplies_decline', 'supplies_decline.DECLINE_ID', '=', 'asset_article.DECLINE_ID')
                ->leftJoin('hrd_department_sub_sub', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID', '=', 'asset_article.DEP_ID')
                ->leftJoin('supplies_location', 'supplies_location.LOCATION_ID', '=', 'asset_article.LOCATION_ID')
                ->leftJoin('supplies_location_level', 'supplies_location_level.LOCATION_LEVEL_ID', '=', 'asset_article.LOCATION_LEVEL_ID')
                ->leftJoin('supplies_location_level_room', 'supplies_location_level_room.LEVEL_ROOM_ID', '=', 'asset_article.LEVEL_ROOM_ID')
                ->where('asset_article.DECLINE_ID','=',$SEND_TYPE)
                ->where(function ($q) use ($search) {
                    $q->where('ARTICLE_NUM', 'like', '%' . $search . '%');
                    $q->orwhere('YEAR_ID', 'like', '%' . $search . '%');
                    $q->orwhere('ARTICLE_NAME', 'like', '%' . $search . '%');
                    $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME', 'like', '%' . $search . '%');
                })
                ->orderBy('ARTICLE_ID', 'desc')
                ->paginate(12);


                $countarticle = Assetarticle::leftJoin('supplies_decline', 'supplies_decline.DECLINE_ID', '=', 'asset_article.DECLINE_ID')
                ->leftJoin('hrd_department_sub_sub', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID', '=', 'asset_article.DEP_ID')
                ->leftJoin('supplies_location', 'supplies_location.LOCATION_ID', '=', 'asset_article.LOCATION_ID')
                ->leftJoin('supplies_location_level', 'supplies_location_level.LOCATION_LEVEL_ID', '=', 'asset_article.LOCATION_LEVEL_ID')
                ->leftJoin('supplies_location_level_room', 'supplies_location_level_room.LEVEL_ROOM_ID', '=', 'asset_article.LEVEL_ROOM_ID')
                ->where('asset_article.DECLINE_ID','=',$SEND_TYPE)
                ->where(function ($q) use ($search) {
                    $q->where('ARTICLE_NUM', 'like', '%' . $search . '%');
                    $q->orwhere('YEAR_ID', 'like', '%' . $search . '%');
                    $q->orwhere('ARTICLE_NAME', 'like', '%' . $search . '%');
                    $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME', 'like', '%' . $search . '%');
                })
                ->orderBy('ARTICLE_ID', 'desc')
                ->count();
    
            } else{
    
            $infoasset = Assetarticle::leftJoin('supplies_decline', 'supplies_decline.DECLINE_ID', '=', 'asset_article.DECLINE_ID')
            ->leftJoin('hrd_department_sub_sub', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID', '=', 'asset_article.DEP_ID')
            ->leftJoin('supplies_location', 'supplies_location.LOCATION_ID', '=', 'asset_article.LOCATION_ID')
            ->leftJoin('supplies_location_level', 'supplies_location_level.LOCATION_LEVEL_ID', '=', 'asset_article.LOCATION_LEVEL_ID')
            ->leftJoin('supplies_location_level_room', 'supplies_location_level_room.LEVEL_ROOM_ID', '=', 'asset_article.LEVEL_ROOM_ID')
            ->where(function ($q) use ($search) {
                $q->where('ARTICLE_NUM', 'like', '%' . $search . '%');
                $q->orwhere('YEAR_ID', 'like', '%' . $search . '%');
                $q->orwhere('ARTICLE_NAME', 'like', '%' . $search . '%');
                $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME', 'like', '%' . $search . '%');
            })
            ->orderBy('ARTICLE_ID', 'desc')
            ->paginate(12);


            $countarticle = Assetarticle::leftJoin('supplies_decline', 'supplies_decline.DECLINE_ID', '=', 'asset_article.DECLINE_ID')
            ->leftJoin('hrd_department_sub_sub', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID', '=', 'asset_article.DEP_ID')
            ->leftJoin('supplies_location', 'supplies_location.LOCATION_ID', '=', 'asset_article.LOCATION_ID')
            ->leftJoin('supplies_location_level', 'supplies_location_level.LOCATION_LEVEL_ID', '=', 'asset_article.LOCATION_LEVEL_ID')
            ->leftJoin('supplies_location_level_room', 'supplies_location_level_room.LEVEL_ROOM_ID', '=', 'asset_article.LEVEL_ROOM_ID')
            ->where(function ($q) use ($search) {
                $q->where('ARTICLE_NUM', 'like', '%' . $search . '%');
                $q->orwhere('YEAR_ID', 'like', '%' . $search . '%');
                $q->orwhere('ARTICLE_NAME', 'like', '%' . $search . '%');
                $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME', 'like', '%' . $search . '%');
            })
            ->orderBy('ARTICLE_ID', 'desc')
            ->count();
    
    
            }
    
            $type_check = $SEND_TYPE;


        $displaydate_bigen = date('Y-m-d');
        $displaydate_end = date('Y-m-d');

        $infodecline = DB::table('supplies_decline')->get();


        return view('manager_asset.assetinfo', [
            'infoassets'   => $infoasset,
            'countarticle' => $countarticle,
            'infodeclines' => $infodecline,
            'type_check' => $type_check,
            'search'       => $search

        ]);

    }
    public function assetinfosearch(Request $request)
    {

        $search = $request->get('search');
        $SEND_TYPE = $request->get('SEND_TYPE');

        if ($search == '') {
            $search = "";
        }

        if($SEND_TYPE !== ""){

            $infoasset = Assetarticle::leftJoin('supplies_decline', 'supplies_decline.DECLINE_ID', '=', 'asset_article.DECLINE_ID')
            ->leftJoin('hrd_department_sub_sub', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID', '=', 'asset_article.DEP_ID')
            ->leftJoin('supplies_location', 'supplies_location.LOCATION_ID', '=', 'asset_article.LOCATION_ID')
            ->leftJoin('supplies_location_level', 'supplies_location_level.LOCATION_LEVEL_ID', '=', 'asset_article.LOCATION_LEVEL_ID')
            ->leftJoin('supplies_location_level_room', 'supplies_location_level_room.LEVEL_ROOM_ID', '=', 'asset_article.LEVEL_ROOM_ID')
            ->where('asset_article.DECLINE_ID','=',$SEND_TYPE)
            ->where(function ($q) use ($search) {
                $q->where('ARTICLE_NUM', 'like', '%' . $search . '%');
                $q->orwhere('YEAR_ID', 'like', '%' . $search . '%');
                $q->orwhere('ARTICLE_NAME', 'like', '%' . $search . '%');
                $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME', 'like', '%' . $search . '%');
            })
            ->orderBy('ARTICLE_ID', 'desc')
            ->paginate(12);

        } else{

            $infoasset = Assetarticle::leftJoin('supplies_decline', 'supplies_decline.DECLINE_ID', '=', 'asset_article.DECLINE_ID')
            ->leftJoin('hrd_department_sub_sub', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID', '=', 'asset_article.DEP_ID')
            ->leftJoin('supplies_location', 'supplies_location.LOCATION_ID', '=', 'asset_article.LOCATION_ID')
            ->leftJoin('supplies_location_level', 'supplies_location_level.LOCATION_LEVEL_ID', '=', 'asset_article.LOCATION_LEVEL_ID')
            ->leftJoin('supplies_location_level_room', 'supplies_location_level_room.LEVEL_ROOM_ID', '=', 'asset_article.LEVEL_ROOM_ID')
            ->where(function ($q) use ($search) {
                $q->where('ARTICLE_NUM', 'like', '%' . $search . '%');
                $q->orwhere('YEAR_ID', 'like', '%' . $search . '%');
                $q->orwhere('ARTICLE_NAME', 'like', '%' . $search . '%');
                $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME', 'like', '%' . $search . '%');
            })
            ->orderBy('ARTICLE_ID', 'desc')
            ->paginate(12);


        } 

        $type_check = $SEND_TYPE;

        $countarticle = Assetarticle::count();
        $infodecline = DB::table('supplies_decline')->get();

        return view('manager_asset.assetinfo', [
            'infoassets'   => $infoasset,
            'countarticle' => $countarticle,
            'infodeclines' => $infodecline,
            'type_check' => $type_check,
            'search'       => $search

        ]);


    }
    public function assetinfoexcel()
    {

        $infoasset = Assetarticle::leftJoin('supplies_decline', 'supplies_decline.DECLINE_ID', '=', 'asset_article.DECLINE_ID')
            ->leftJoin('hrd_department_sub_sub', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID', '=', 'asset_article.DEP_ID')
            ->leftJoin('supplies_location', 'supplies_location.LOCATION_ID', '=', 'asset_article.LOCATION_ID')
            ->leftJoin('supplies_location_level', 'supplies_location_level.LOCATION_LEVEL_ID', '=', 'asset_article.LOCATION_LEVEL_ID')
            ->leftJoin('supplies_location_level_room', 'supplies_location_level_room.LEVEL_ROOM_ID', '=', 'asset_article.LEVEL_ROOM_ID')
            ->leftJoin('hrd_person', 'hrd_person.ID', '=', 'asset_article.PERSON_ID')

            ->leftJoin('supplies_unit', 'supplies_unit.SUP_UNIT_ID', '=', 'asset_article.UNIT_ID')
            ->leftJoin('supplies_brand', 'supplies_brand.BRAND_ID', '=', 'asset_article.BRAND_ID')
            ->leftJoin('supplies_color', 'supplies_color.COLOR_ID', '=', 'asset_article.COLOR_ID')
            ->leftJoin('supplies_model', 'supplies_model.MODEL_ID', '=', 'asset_article.MODEL_ID')
            ->leftJoin('supplies_size', 'supplies_size.SIZE_ID', '=', 'asset_article.SIZE_ID')
            ->leftJoin('asset_group_pm', 'asset_group_pm.PM_TYPE_ID', '=', 'asset_article.PM_TYPE_ID')
            ->leftJoin('asset_group_cal', 'asset_group_cal.CAL_TYPE_ID', '=', 'asset_article.CAL_TYPE_ID')

            ->leftJoin('supplies_method', 'supplies_method.METHOD_ID', '=', 'asset_article.METHOD_ID')
            ->leftJoin('supplies_budget', 'supplies_budget.BUDGET_ID', '=', 'asset_article.BUDGET_ID')
            ->leftJoin('supplies_type', 'supplies_type.SUP_TYPE_ID', '=', 'asset_article.TYPE_ID')
            ->leftJoin('supplies_buy', 'supplies_buy.BUY_ID', '=', 'asset_article.BUY_ID')
            ->leftJoin('supplies_vendor', 'supplies_vendor.VENDOR_ID', '=', 'asset_article.VENDOR_ID')

            ->orderBy('ARTICLE_ID', 'desc')
            ->get();

        $countarticle = Assetarticle::count();

        return view('manager_asset.assetinfoexcel', [
            'infoassets'   => $infoasset,
            'countarticle' => $countarticle

        ]);

    }

   

//======ฟังชันค้นหา======

    public function switchsearchassetinfo(Request $request)
    {

        function formate($strDate)
        {
            $strYear  = date("Y", strtotime($strDate));
            $strMonth = date("m", strtotime($strDate));
            $strDay   = date("d", strtotime($strDate));

            return $strDay . "/" . $strMonth . "/" . $strYear;
        }

        $budgets = DB::table('asset_article')
            ->select('YEAR_ID', DB::raw('count(*) as total'))
            ->groupBy('YEAR_ID')
            ->get();

        $departments = DB::table('hrd_department_sub_sub')->get();

        $types = DB::table('supplies_type')->get();

        $infolocations = DB::table('supplies_location')->get();

        $date = date('Y-m-d');

        $searchcode = $request->code;

        if ($searchcode == 'searchhight') {

            $output = '<div class="row" >

                        <div class="col-md-10">

                        <div class="row push" >
                                            <div class="col-md-0.5" style=" font-family: \'Kanit\', sans-serif;font-size: 14px;">
                                                &nbsp;ปีงบประมาณ&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                </div>
                                                <div class="col-md-3">
                                                    <span>
                                                <select name="" id="" class="form-control input-lg" style=" font-family: \'Kanit\', sans-serif;font-size: 14px;">
                                                        <option value="">--เลือกปีงบ--</option>';

            foreach ($budgets as $budget) {

                $output .= '<option value="' . $budget->YEAR_ID . '">' . $budget->YEAR_ID . '</option>';
            }

            $output .= '</select>
                                                </span>
                                                </div>
                                                        <div class="col-md-0.5" style=" font-family: \'Kanit\', sans-serif;font-size: 14px;">
                                                    &nbsp; วันที่ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                </div>
                                                <div class="col-md-3">

                                                        <input  name = "DATE_BIGIN"  id="DATE_BIGIN"  class="form-control input-lg datepicker1" data-date-format="mm/dd/yyyy" style=" font-family: \'Kanit\', sans-serif;font-size: 14px;" value="' . formate($date) . '" onclick="rundatepicker1();" readonly>

                                                </div>
                                                <div class="col-md-0.5" style=" font-family: \'Kanit\', sans-serif;font-size: 14px;">
                                                    &nbsp;ถึง &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                </div>
                                                <div class="col-md-3">

                                                        <input  name = "DATE_END"  id="DATE_END"  class="form-control input-lg datepicker2" data-date-format="mm/dd/yyyy" style=" font-family: \'Kanit\', sans-serif;font-size: 14px;" value="' . formate($date) . '" onclick="rundatepicker2();" readonly>

                                                </div>


                                                </div>

                                                <div class="row push" >
                                                <div class="col-md-0.5" style=" font-family: \'Kanit\', sans-serif;font-size: 14px;">
                                                &nbsp;ประจำหน่วยงาน &nbsp;
                                                </div>
                                                <div class="col-md-3">
                                                <span>
                                                <select name="SEND_STATUS" id="SEND_STATUS" class="form-control input-lg" style=" font-family: \'Kanit\', sans-serif;font-size: 14px;">
                                                    <option value="">--เลือกหน่วยงาน--</option>';

            foreach ($departments as $department) {

                $output .= '<option value="' . $department->HR_DEPARTMENT_SUB_SUB_ID . '">' . $department->HR_DEPARTMENT_SUB_SUB_NAME . '</option>';
            }

            $output .= '</select>
                                                </span>
                                                </div>


                                                <div class="col-md-0.5" style=" font-family: \'Kanit\', sans-serif;font-size: 14px;">
                                                &nbsp;ประเภทครุภัณฑ์ &nbsp;
                                                    </div>
                                                    <div class="col-md-3">
                                                        <span>
                                                            <select name="SEND_STATUS" id="SEND_STATUS" class="form-control input-lg" style=" font-family: \'Kanit\', sans-serif;font-size: 14px;">
                                                                <option value="">--เลือกประเภทครุภัณฑ์--</option>';

            foreach ($types as $type) {

                $output .= '<option value="' . $type->SUP_TYPE_ID . '">' . $type->SUP_TYPE_NAME . '</option>';
            }

            $output .= '</select>
                                                        </span>
                                                    </div>



                                            <div class="col-md-0.5" style=" font-family: \'Kanit\', sans-serif;font-size: 14px;">
                                            &nbsp; เลขครุภัณฑ์ &nbsp;
                                            </div>
                                            <div class="col-md-3">
                                            <input name="" id="" class="form-control input-sm" style=" font-family: \'Kanit\', sans-serif;font-size: 14px;" >
                                            </div>

                                                </div>



                                                <div class="row" >

                                                <div class="col-md-0.5" style=" font-family: \'Kanit\', sans-serif;font-size: 14px;">
                                                &nbsp;สถานที่ต้้ง &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                </div>
                                                <div class="col-md-3">
                                                <span>
                                                <select name="LOCATION_SEE_ID" id="LOCATION_SEE_ID" class="form-control input-lg location" style=" font-family: \'Kanit\', sans-serif;">
                                                <option value="">--กรุณาเลือกสถานที่--</option>';

            foreach ($infolocations as $infolocation) {

                $output .= '<option value="' . $infolocation->LOCATION_ID . '">' . $infolocation->LOCATION_NAME . '</option>';
            }

            $output .= ' </select>
                                                </span>
                                                </div>
                                                <div class="col-md-0.5" style=" font-family: \'Kanit\', sans-serif;font-size: 14px;">
                                                &nbsp;ชั้น &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                </div>
                                                <div class="col-md-3">
                                                <span>
                                                <select name="LOCATIONLEVEL_SEE_ID" id="LOCATIONLEVEL_SEE_ID" class="form-control input-lg locationlevel" style=" font-family: \'Kanit\', sans-serif;" >
                                                    <option value="">--กรุณาเลือกชั้น--</option>

                                                    </select>
                                                </span>
                                                </div>
                                                <div class="col-md-0.5" style=" font-family: \'Kanit\', sans-serif;font-size: 14px;">
                                                &nbsp;ห้อง &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                </div>
                                                <div class="col-md-3">
                                                <span>
                                                <select name="LOCATIONLEVELROOM_SEE_ID" id="LOCATIONLEVELROOM_SEE_ID" class="form-control input-lg locationlevelroom" style=" font-family: \'Kanit\', sans-serif;" >
                                                <option value="">--กรุณาเลือกห้อง--</option>

                                                </select>
                                                </span>
                                                </div>



                                                </div>


                                                </div>

                                                <div class="col-md-2">
                                                <div class="row" >
                                                                <div class="col-md-6">
                                                                <span>
                                                                <button type="submit" class="btn btn-info" style="font-family: \'Kanit\', sans-serif; font-size: 14px;font-weight:normal;">ค้นหา</button>
                                                                </span>
                                                                </div>
                                                                <div class="col-md-6">
                                                                <button type="button" class="btn btn-success" style="font-family: \'Kanit\', sans-serif; font-size: 14px;font-weight:normal;" onclick="switchsearch(\'searchnomal\');">ค้นหาปกติ</button>
                                                                </div>


                                                </div>
                                                </div>




                                                </div>





                                                </div>
                                                ';

        } else {

            $output = '<div class="row" >
                                                <div class="col-md-8">
                                                &nbsp;
                                                </div>
                                                <div class="col-md-2">
                                                <span>
                                                <input type="search"  name="search" class="form-control" style="font-family: \'Kanit\', sans-serif; font-size: 14px;font-weight:normal;">
                                                </span>
                                                </div>
                                                <div class="col-md-1">
                                                <span>
                                                <button type="submit" class="btn btn-info" style="font-family: \'Kanit\', sans-serif; font-size: 14px;font-weight:normal;">ค้นหา</button>
                                                </span>
                                                </div>
                                                <div class="col-md-1">
                                                <button type="button" class="btn btn-success" style="font-family: \'Kanit\', sans-serif; font-size: 14px;font-weight:normal;" onclick="switchsearch(\'searchhight\');">ค้นหาขั้นสูง</button>
                                                </div>
                                                </div>';

        }

        echo $output;

    }

    //=======================================รายละเอียดแก้ไข====================================================
    public function editassetinfo(Request $request, $id)
    {

        $infoasset = Assetarticle::where('ARTICLE_ID', '=', $id)->first();

        $infounit    = DB::table('supplies_unit')->get();
        $inbrand     = DB::table('supplies_brand')->get();
        $infocolor   = DB::table('supplies_color')->get();
        $inmodel     = DB::table('supplies_model')->get();
        $infosize    = DB::table('supplies_size')->get();
        $infomethod  = DB::table('supplies_method')->get();
        $infobuy     = DB::table('supplies_buy')->get();
        $infobudget  = DB::table('supplies_budget')->get();
        $infotype    = DB::table('supplies_type')->get();
        $infodecline = DB::table('supplies_decline')->get();
        $infovendor  = DB::table('supplies_vendor')->get();

        $infodep               = DB::table('hrd_department_sub_sub')->get();
        $infolocation          = DB::table('supplies_location')->get();
        $infolocationlevel     = DB::table('supplies_location_level')->get();
        $infolocationlevelroom = DB::table('supplies_location_level_room')->get();

        $infoperson = DB::table('hrd_person')->get();

        $infostatus    = DB::table('asset_status')->get();
        $infogroupcal  = DB::table('asset_group_cal')->get();
        $infogrouppm   = DB::table('asset_group_pm')->get();
        $infogrouprisk = DB::table('asset_group_risk')->get();

        return view('manager_asset.assetinfo_edit', [

            'infoasset'              => $infoasset,
            'infounits'              => $infounit,
            'inbrands'               => $inbrand,
            'infocolors'             => $infocolor,
            'inmodels'               => $inmodel,
            'infosizes'              => $infosize,
            'infomethods'            => $infomethod,
            'infobuys'               => $infobuy,
            'infobudgets'            => $infobudget,
            'infotypes'              => $infotype,
            'infodeclines'           => $infodecline,
            'infovendors'            => $infovendor,
            'infodeps'               => $infodep,
            'infolocations'          => $infolocation,
            'infolocationlevels'     => $infolocationlevel,
            'infolocationlevelrooms' => $infolocationlevelroom,
            'infopersons'            => $infoperson,
            'infostatuss'            => $infostatus,
            'infogroupcals'          => $infogroupcal,
            'infogrouppms'           => $infogrouppm,
            'infogrouprisks'         => $infogrouprisk

        ]);

    }

    public function updateassetinfo(Request $request)
    {

        $BUILD_CREATE = $request->RECEIVE_DATE;
        $BUILD_FINISH = $request->EXPIRE_DATE;

        if ($BUILD_CREATE != '') {
            $STARTDAY       = Carbon::createFromFormat('d/m/Y', $BUILD_CREATE)->format('Y-m-d');
            $date_arrary_st = explode("-", $STARTDAY);
            $y_sub_st       = $date_arrary_st[0];

            if ($y_sub_st >= 2500) {
                $y_st = $y_sub_st - 543;
            } else {
                $y_st = $y_sub_st;
            }
            $m_st        = $date_arrary_st[1];
            $d_st        = $date_arrary_st[2];
            $RECEIVEDATE = $y_st . "-" . $m_st . "-" . $d_st;
        } else {
            $RECEIVEDATE = null;
        }

        if ($BUILD_FINISH != '') {
            $STARTDAY       = Carbon::createFromFormat('d/m/Y', $BUILD_FINISH)->format('Y-m-d');
            $date_arrary_st = explode("-", $STARTDAY);
            $y_sub_st       = $date_arrary_st[0];

            if ($y_sub_st >= 2500) {
                $y_st = $y_sub_st - 543;
            } else {
                $y_st = $y_sub_st;
            }
            $m_st        = $date_arrary_st[1];
            $d_st        = $date_arrary_st[2];
            $EXPIRE_DATE = $y_st . "-" . $m_st . "-" . $d_st;
        } else {
            $EXPIRE_DATE = null;
        }

        $ARTICLE_ID = $request->ARTICLE_ID;

        $addinfoarticle                    = Assetarticle::find($ARTICLE_ID);
        $addinfoarticle->ARTICLE_NUM       = $request->ARTICLE_NUM;
        $addinfoarticle->YEAR_ID           = $request->YEAR_ID;
        $addinfoarticle->ARTICLE_NAME      = $request->ARTICLE_NAME;
        $addinfoarticle->ARTICLE_PROP      = $request->ARTICLE_PROP;
        $addinfoarticle->UNIT_ID           = $request->UNIT_ID;
        $addinfoarticle->SERIAL_NO         = $request->SERIAL_NO;
        $addinfoarticle->BRAND_ID          = $request->BRAND_ID;
        $addinfoarticle->COLOR_ID          = $request->COLOR_ID;
        $addinfoarticle->MODEL_ID          = $request->MODEL_ID;
        $addinfoarticle->SIZE_ID           = $request->SIZE_ID;
        $addinfoarticle->PRICE_PER_UNIT    = $request->PRICE_PER_UNIT;
        $addinfoarticle->RECEIVE_DATE      = $RECEIVEDATE;
        $addinfoarticle->METHOD_ID         = $request->METHOD_ID;
        $addinfoarticle->BUY_ID            = $request->BUY_ID;
        $addinfoarticle->BUDGET_ID         = $request->BUDGET_ID;
        $addinfoarticle->TYPE_ID           = $request->TYPE_ID;
        $addinfoarticle->DECLINE_ID        = $request->DECLINE_ID;
        $addinfoarticle->VENDOR_ID         = $request->VENDOR_ID;
        $addinfoarticle->DEP_ID            = $request->DEP_ID;
        $addinfoarticle->LOCATION_ID       = $request->LOCATION_ID;
        $addinfoarticle->LOCATION_LEVEL_ID = $request->LOCATION_LEVEL_ID;
        $addinfoarticle->LEVEL_ROOM_ID     = $request->LEVEL_ROOM_ID;
        $addinfoarticle->PERSON_ID         = $request->PERSON_ID;
        $addinfoarticle->REMARK            = $request->REMARK;
        $addinfoarticle->STATUS_ID         = $request->STATUS_ID;
        $addinfoarticle->OLD_USE           = $request->OLD_USE;

        $addinfoarticle->EXPIRE_DATE = $EXPIRE_DATE;

        $addinfoarticle->PM_TYPE_ID   = $request->PM_TYPE_ID;
        $addinfoarticle->CAL_TYPE_ID  = $request->CAL_TYPE_ID;
        $addinfoarticle->RISK_TYPE_ID = $request->RISK_TYPE_ID;

        $addinfoarticle->SUP_FSN = $request->SUP_FSN;

        if ($request->hasFile('picture')) {

            $file                = $request->file('picture');
            $contents            = $file->openFile()->fread($file->getSize());
            $addinfoarticle->IMG = $contents;

        }

        $addinfoarticle->save();

        $id = $ARTICLE_ID;

        Assetdepreciate::where('DEP_ASSET_ID', '=', $id)->delete();
        $infoasset = Assetarticle::where('asset_article.ARTICLE_ID', '=', $id)
            ->leftJoin('supplies_decline', 'supplies_decline.DECLINE_ID', '=', 'asset_article.DECLINE_ID')
            ->leftJoin('hrd_department_sub_sub', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID', '=', 'asset_article.DEP_ID')
            ->leftJoin('supplies_location', 'supplies_location.LOCATION_ID', '=', 'asset_article.LOCATION_ID')
            ->leftJoin('supplies_location_level', 'supplies_location_level.LOCATION_LEVEL_ID', '=', 'asset_article.LOCATION_LEVEL_ID')
            ->leftJoin('supplies_location_level_room', 'supplies_location_level_room.LEVEL_ROOM_ID', '=', 'asset_article.LEVEL_ROOM_ID')
            ->first();

        $depreciation = DB::table('supplies_decline')->where('supplies_decline.DECLINE_ID', '=', $infoasset->DECLINE_ID)->first();

        $start = $month = strtotime($infoasset->RECEIVE_DATE . ' + 1 month');

        $yearend = date("Y", strtotime($infoasset->RECEIVE_DATE)) + 60;

        $dateend = $yearend . '-01-01';

        $end = strtotime($dateend);

//=========================

        //--------------------------------สูตรคำนวน-----------------------------------------------
        $PICE              = $infoasset->PRICE_PER_UNIT;
        $per_year          = $depreciation->DECLINE_PERSEN;
        $Depreciation_mont = ($PICE * ($per_year / 100)) / 12;

        $checkdep = Assetdepreciate::where('DEP_ASSET_ID', '=', $id)->count();
        //-------------------------คำนวณเดือนแรก----------------------------

        $fristYear  = date("Y", strtotime($infoasset->RECEIVE_DATE)) + 543;
        $fristMonth = date("m", strtotime($infoasset->RECEIVE_DATE));
        $fristdate  = date("d", strtotime($infoasset->RECEIVE_DATE));


        if ($fristMonth == '04' || $fristMonth == '06' || $fristMonth == '09' || $fristMonth == '11') {
            $d = 30;
        } elseif ($fristMonth == '02') {
            if (($fristYear - 543) % 4 == 0) {
                $d = 29;
            } else {
                $d = 28;
            }

        } else {
            $d = 31;
        }

        $amountdate = $d - $fristdate;
        $Depdate    = $Depreciation_mont / $d;

        $fristDepreciation_mont = $amountdate * $Depdate;

        $fristDepreciation = $PICE - $fristDepreciation_mont;

        //-------------เพิ่มข้อมูลในตาราง----------------------------
        if ($checkdep == 0) {
            $adddepreciate                 = new Assetdepreciate();
            $adddepreciate->DEP_ASSET_ID   = $id;
            $adddepreciate->DEP_YEAR       = $fristYear;
            $adddepreciate->DEP_MONTH      = number_format($fristMonth);
            $adddepreciate->DEP_PRICE      = $PICE;
            $adddepreciate->DEP_FORWARD    = 0;
            $adddepreciate->DEP_DEPRECIATE = $fristDepreciation_mont;
            $adddepreciate->DEP_CUMULATIVE = $fristDepreciation_mont;
            $adddepreciate->DEP_VALUE      = $fristDepreciation;
            $adddepreciate->save();

        } //------------------------------------------

        //----------------------------------------------------

        $Depreciation_move = $fristDepreciation_mont;
        $Depreciation      = $Depreciation_mont + $Depreciation_move;

        while ($month < $end) {

            $year = date('Y', $month) + 543;

            $value_last = ($PICE - $Depreciation_move) - 1; //-----ตัวตัดค่าเสื่อมตัวสุดท้าย

            $value = $PICE - $Depreciation;

            if ($value <= 0) {
                $Depreciation_mont = $value_last;
                $Depreciation      = $Depreciation_move + $Depreciation_mont;
                $value             = 1;

            }

            //-------------เพิ่มข้อมูลในตาราง----------------------------
            if ($checkdep == 0) {
                $adddepreciate                 = new Assetdepreciate();
                $adddepreciate->DEP_ASSET_ID   = $id;
                $adddepreciate->DEP_YEAR       = $year;
                $adddepreciate->DEP_MONTH      = number_format(date('m', $month));
                $adddepreciate->DEP_PRICE      = $PICE;
                $adddepreciate->DEP_FORWARD    = $Depreciation_move;
                $adddepreciate->DEP_DEPRECIATE = $Depreciation_mont;
                $adddepreciate->DEP_CUMULATIVE = $Depreciation;
                $adddepreciate->DEP_VALUE      = $value;
                $adddepreciate->save();
            }
            //------------------------------------------

            if ($value == 1) {
                break;
            }
            $Depreciation = $Depreciation_mont + $Depreciation;

            $Depreciation_move = $Depreciation - $Depreciation_mont;

            $month = strtotime("+1 month", $month);

        }

        return redirect()->route('massete.assetinfo');

    }

//=====ลบครุภัณฑ์

    public function destroysuppliesinfoinasset($id, $asstid)
    {

        Assetarticle::destroy($asstid);

        return redirect()->route('msupplies.suppliesinfoinasset', [
            'id' => $id
        ]);
    }

    public function assetinfomation(Request $request, $id)
    {

        $infoasset = Assetarticle::where('ARTICLE_ID', '=', $id)->first();

        $infounit    = DB::table('supplies_unit')->get();
        $inbrand     = DB::table('supplies_brand')->get();
        $infocolor   = DB::table('supplies_color')->get();
        $inmodel     = DB::table('supplies_model')->get();
        $infosize    = DB::table('supplies_size')->get();
        $infomethod  = DB::table('supplies_method')->get();
        $infobuy     = DB::table('supplies_buy')->get();
        $infobudget  = DB::table('supplies_budget')->get();
        $infotype    = DB::table('supplies_type')->get();
        $infodecline = DB::table('supplies_decline')->get();
        $infovendor  = DB::table('supplies_vendor')->get();

        $infodep               = DB::table('hrd_department_sub_sub')->get();
        $infolocation          = DB::table('supplies_location')->get();
        $infolocationlevel     = DB::table('supplies_location_level')->get();
        $infolocationlevelroom = DB::table('supplies_location_level_room')->get();

        $infoperson = DB::table('hrd_person')->get();

        $infostatus    = DB::table('asset_status')->get();
        $infogroupcal  = DB::table('asset_group_cal')->get();
        $infogrouppm   = DB::table('asset_group_pm')->get();
        $infogrouprisk = DB::table('asset_group_risk')->get();

        return view('manager_asset.assetinfo_infomation', [

            'infoasset'              => $infoasset,
            'infounits'              => $infounit,
            'inbrands'               => $inbrand,
            'infocolors'             => $infocolor,
            'inmodels'               => $inmodel,
            'infosizes'              => $infosize,
            'infomethods'            => $infomethod,
            'infobuys'               => $infobuy,
            'infobudgets'            => $infobudget,
            'infotypes'              => $infotype,
            'infodeclines'           => $infodecline,
            'infovendors'            => $infovendor,
            'infodeps'               => $infodep,
            'infolocations'          => $infolocation,
            'infolocationlevels'     => $infolocationlevel,
            'infolocationlevelrooms' => $infolocationlevelroom,
            'infopersons'            => $infoperson,
            'infostatuss'            => $infostatus,
            'infogroupcals'          => $infogroupcal,
            'infogrouppms'           => $infogrouppm,
            'infogrouprisks'         => $infogrouprisk

        ]);

    }

//=======================================================
    public function depreciate(Request $request)
    {

        function MThai($Month)
        {
            $strMonth     = number_format($Month);
            $strMonthCut  = array("", "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
            $strMonthThai = $strMonthCut[$strMonth];
            return $strMonthThai;
        }

        $infoasset = Assetarticle::where('asset_article.ARTICLE_ID', '=', $request->id)
            ->leftJoin('supplies_decline', 'supplies_decline.DECLINE_ID', '=', 'asset_article.DECLINE_ID')
            ->leftJoin('hrd_department_sub_sub', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID', '=', 'asset_article.DEP_ID')
            ->leftJoin('supplies_location', 'supplies_location.LOCATION_ID', '=', 'asset_article.LOCATION_ID')
            ->leftJoin('supplies_location_level', 'supplies_location_level.LOCATION_LEVEL_ID', '=', 'asset_article.LOCATION_LEVEL_ID')
            ->leftJoin('supplies_location_level_room', 'supplies_location_level_room.LEVEL_ROOM_ID', '=', 'asset_article.LEVEL_ROOM_ID')
            ->first();

        $depreciation = DB::table('supplies_decline')->where('supplies_decline.DECLINE_ID', '=', $infoasset->DECLINE_ID)->first();

        $start = $month = strtotime($infoasset->RECEIVE_DATE . ' + 1 month');

        $yearend = date("Y", strtotime($infoasset->RECEIVE_DATE)) + 60;

        $dateend = $yearend . '-01-01';

        $end = strtotime($dateend);

        //=========================

        $output = '

                            <div class="row push" style="font-family: \'Kanit\', sans-serif;">

                            <div class="col-sm-9">

                            <div class="row">
                                <div class="col-lg-2" align="right">
                                <label>เลขครุภัณฑ์ :</label>
                                </div>
                                <div class="col-lg-4" align="left">
                                ' . $infoasset->ARTICLE_NUM . '
                                </div>

                                <div class="col-lg-2" align="right">
                                <label>ชื่อครุภัณฑ์  :</label>
                                </div>
                                <div class="col-lg-4" align="left">
                                ' . $infoasset->ARTICLE_NAME . '
                                </div>


                                </div>


                            <div class="row">
                                <div class="col-lg-2" align="right">
                                <label>ประเภทครุภัณฑ์ :</label>
                                </div>
                                <div class="col-lg-4" align="left">
                                ' . $infoasset->DECLINE_NAME . '
                                </div>
                                <div class="col-lg-2" align="right">
                                <label>ประจำหน่วยงาน :</label>
                                </div>
                                <div class="col-lg-4" align="left">
                                ' . $infoasset->HR_DEPARTMENT_SUB_SUB_NAME . '
                                </div>

                            </div>
                            <br>
                            <div style="height:400px;overflow-y:scroll;">
                            <table>

                            <table class="table-bordered table-striped table-vcenter js-dataTable-simple" style="width: 100%;">
                            <thead style="background-color: #FFEBCD;">
                                <tr height="40">
                                <th  class="text-font"  style="border-color:#F0FFFF;text-align: center;font-family: \'Kanit\', sans-serif;" width="5%">ปี</th>
                                <th  class="text-font" style="border-color:#F0FFFF;text-align: center;font-family: \'Kanit\', sans-serif;" width="10%">เดือน</th>
                                <th  class="text-font" style="border-color:#F0FFFF;text-align: center;font-family: \'Kanit\', sans-serif;"  width="15%">ราคาตั้งต้น</th>
                                <th  class="text-font" style="border-color:#F0FFFF;text-align: center;font-family: \'Kanit\', sans-serif;"   width="15%">ค่าเสื่อมยกมา</th>
                                <th  class="text-font" style="border-color:#F0FFFF;text-align: center;font-family: \'Kanit\', sans-serif;"   width="15%">ค่าเสื่อม</th>
                                <th  class="text-font" style="border-color:#F0FFFF;text-align: center;font-family: \'Kanit\', sans-serif;"   width="15%">ค่าเสื่อมสะสม</th>
                                <th  class="text-font" style="border-color:#F0FFFF;text-align: center;font-family: \'Kanit\', sans-serif;"   width="15%">มูลค่า</th>

                                        </tr>
                                        </thead>
                                        <tbody >';

        //--------------------------------สูตรคำนวน-----------------------------------------------
        $PICE              = $infoasset->PRICE_PER_UNIT;
        $per_year          = $depreciation->DECLINE_PERSEN;
        $Depreciation_mont = ($PICE * ($per_year / 100)) / 12;

        $checkdep = Assetdepreciate::where('DEP_ASSET_ID', '=', $request->id)->count();
        //-------------------------คำนวณเดือนแรก----------------------------

        $fristYear  = date("Y", strtotime($infoasset->RECEIVE_DATE)) + 543;
        $fristMonth = date("m", strtotime($infoasset->RECEIVE_DATE));
        $fristdate  = date("d", strtotime($infoasset->RECEIVE_DATE));

        if ($fristMonth == '04' || $fristMonth == '06' || $fristMonth == '09' || $fristMonth == '11') {
            $d = 30;
        } elseif ($fristMonth == '02') {
            if (($fristYear - 543) % 4 == 0) {
                $d = 29;
            } else {
                $d = 28;
            }

        } else {
            $d = 31;
        }

        $amountdate = $d - $fristdate;
        $Depdate    = $Depreciation_mont / $d;

        $fristDepreciation_mont = $amountdate * $Depdate;

        $fristDepreciation = $PICE - $fristDepreciation_mont;

        $output .= '<tr>';
        $output .= '<td class="text-font " align="center">' . $fristYear . '</td><td class="text-font text-pedding">' . MThai($fristMonth) . '</td><td class="text-font text-pedding" align="right">' . number_format($PICE, 2) . '</td><td class="text-font text-pedding" align="right">0.00</td><td class="text-font text-pedding" align="right">' . number_format($fristDepreciation_mont, 2) . '</td><td class="text-font text-pedding" align="right">' . number_format($fristDepreciation_mont, 2) . '</td><td class="text-font text-pedding" align="right">' . number_format($fristDepreciation, 2) . '</td>';
        $output .= '</tr>';

        //-------------เพิ่มข้อมูลในตาราง----------------------------
        if ($checkdep == 0) {
            $adddepreciate                 = new Assetdepreciate();
            $adddepreciate->DEP_ASSET_ID   = $request->id;
            $adddepreciate->DEP_YEAR       = $fristYear;
            $adddepreciate->DEP_MONTH      = number_format($fristMonth);
            $adddepreciate->DEP_PRICE      = $PICE;
            $adddepreciate->DEP_FORWARD    = 0;
            $adddepreciate->DEP_DEPRECIATE = $fristDepreciation_mont;
            $adddepreciate->DEP_CUMULATIVE = $fristDepreciation_mont;
            $adddepreciate->DEP_VALUE      = $fristDepreciation;
            $adddepreciate->save();

        }
        //----------------------------------------------------

        $Depreciation_move = $fristDepreciation_mont;
        $Depreciation      = $Depreciation_mont + $Depreciation_move;

        while ($month < $end) {

            $year = date('Y', $month) + 543;

            $value_last = ($PICE - $Depreciation_move) - 1; //-----ตัวตัดค่าเสื่อมตัวสุดท้าย

            $value = $PICE - $Depreciation;

            if ($value <= 0) {
                $Depreciation_mont = $value_last;
                $Depreciation      = $Depreciation_move + $Depreciation_mont;
                $value             = 1;

            }

            $output .= '<tr>';
            $output .= '<td class="text-font " align="center">' . $year . '</td><td class="text-font text-pedding">' . MThai(date('m', $month)) . '</td><td class="text-font text-pedding" align="right">' . number_format($PICE, 2) . '</td><td class="text-font text-pedding" align="right">' . number_format($Depreciation_move, 2) . '</td><td class="text-font text-pedding" align="right">' . number_format($Depreciation_mont, 2) . '</td><td class="text-font text-pedding" align="right">' . number_format($Depreciation, 2) . '</td><td class="text-font text-pedding" align="right">' . number_format($value, 2) . '</td>';
            $output .= '</tr>';

            //-------------เพิ่มข้อมูลในตาราง----------------------------
            if ($checkdep == 0) {
                $adddepreciate                 = new Assetdepreciate();
                $adddepreciate->DEP_ASSET_ID   = $request->id;
                $adddepreciate->DEP_YEAR       = $year;
                $adddepreciate->DEP_MONTH      = number_format(date('m', $month));
                $adddepreciate->DEP_PRICE      = $PICE;
                $adddepreciate->DEP_FORWARD    = $Depreciation_move;
                $adddepreciate->DEP_DEPRECIATE = $Depreciation_mont;
                $adddepreciate->DEP_CUMULATIVE = $Depreciation;
                $adddepreciate->DEP_VALUE      = $value;
                $adddepreciate->save();
            }
            //------------------------------------------

            if ($value == 1) {
                break;
            }
            $Depreciation = $Depreciation_mont + $Depreciation;

            $Depreciation_move = $Depreciation - $Depreciation_mont;

            $month = strtotime("+1 month", $month);

        }

        $output .= '</tbody ></table>

                                                                                        </div>
                                                                                        </div>

                                                                                        <div class="col-sm-3 text-left">

                                                                                        <div class="form-group">

                                                                                        <img src="data:image/png;base64,' . chunk_split(base64_encode($infoasset->IMG)) . '" id="image_upload_preview" alt="กรุณาเพิ่มรูปภาพ" height="200" width="200"/>
                                                                                        </div>

                                                                                        </div>
                                                                                        </div>
                                                                                        </div>
                                                                                        </div>';

        echo $output;

    }

    //====================รายการตึก===================================

    public function assetinfobuilding(Request $request)
    {
        if(!empty($request->_token)){
            $search     = $request->get('search');
            $status     = $request->SEND_STATUS;
            $datebigin  = $request->get('DATE_BIGIN');
            $dateend    = $request->get('DATE_END');
            $yearbudget = $request->BUDGET_YEAR;
            session([
                'manager_asset.assetinfobuilding.search' => $search,
                'manager_asset.assetinfobuilding.status' => $status,
                'manager_asset.assetinfobuilding.datebigin' => $datebigin,
                'manager_asset.assetinfobuilding.dateend' => $dateend,
                'manager_asset.assetinfobuilding.yearbudget' => $yearbudget
                ]);
        }elseif(!empty(session('manager_asset.assetinfobuilding'))){
            $search     = session('manager_asset.assetinfobuilding.search');
            $status     = session('manager_asset.assetinfobuilding.status');
            $datebigin  = session('manager_asset.assetinfobuilding.datebigin');
            $dateend    = session('manager_asset.assetinfobuilding.dateend');
            $yearbudget = session('manager_asset.assetinfobuilding.yearbudget');
        }else{
            $search     = '';
            $status     = '';         
            $datebigin = '01/10/1920';
            $dateend   = '30/09/'.(getBudgetyear()-543);
            $yearbudget = getBudgetyear();
        }

        $date_bigen_c = Carbon::createFromFormat('d/m/Y', $datebigin)->format('Y-m-d');
        $date_arrary  = explode("-", $date_bigen_c);

        $y_sub_st = $date_arrary[0];

        if ($y_sub_st >= 2500) {
            $y = $y_sub_st - 543;
        } else {
            $y = $y_sub_st;
        }

        $m                 = $date_arrary[1];
        $d                 = $date_arrary[2];
        $displaydate_bigen = $y . "-" . $m . "-" . $d;

        $date_end_c    = Carbon::createFromFormat('d/m/Y', $dateend)->format('Y-m-d');
        $date_arrary_e = explode("-", $date_end_c);

        $y_sub_e = $date_arrary_e[0];

        if ($y_sub_e >= 2500) {
            $y_e = $y_sub_e - 543;
        } else {
            $y_e = $y_sub_e;
        }

        $m_e             = $date_arrary_e[1];
        $d_e             = $date_arrary_e[2];
        $displaydate_end = $y_e . "-" . $m_e . "-" . $d_e;

        $date              = date('Y-m-d');
        $date_bigen_checks = strtotime($displaydate_bigen);
        $date_end_checks   = strtotime($displaydate_end);
        $dates             = strtotime($date);

        $from = date($displaydate_bigen);
        $to   = date($displaydate_end);

        if ($status == null) {

            $assetinfobuilding = DB::table('asset_building')
                ->select('asset_building.ID', 'BUILD_NAME', 'BUILD_NGUD_MONEY', 'BUILD_CREATE', 'OLD_USE', 'BUDGET_NAME', 'asset_land.LAND_RAWANG', 'DECLINE_NAME', 'METHOD_NAME', 'BUY_NAME', 'TOTAL', 'BUILD_FINISH', 'TRANSFER_DATE', 'HR_FNAME', 'HR_LNAME', 'BUILD_HR_TEL', 'ENGINEER_NAME', 'COMMENT', 'IMG')
                ->leftJoin('asset_land', 'asset_building.LAND_ID', '=', 'asset_land.ID')
                ->leftJoin('supplies_budget', 'asset_building.BUDGET_ID', '=', 'supplies_budget.BUDGET_ID')
                ->leftJoin('supplies_decline', 'asset_building.DECLINE_ID', '=', 'supplies_decline.DECLINE_ID')
                ->leftJoin('supplies_method', 'asset_building.METHOD_ID', '=', 'supplies_method.METHOD_ID')
                ->leftJoin('supplies_buy', 'asset_building.BUY_ID', '=', 'supplies_buy.BUY_ID')
                ->leftJoin('hrd_person', 'asset_building.BUILD_HR_ID', '=', 'hrd_person.ID')
                ->where(function ($q) use ($search) {
                    $q->where('BUILD_NAME', 'like', '%' . $search . '%');
                    $q->orwhere('BUILD_NGUD_MONEY', 'like', '%' . $search . '%');
                })
                ->WhereBetween('BUILD_CREATE', [$from, $to])
                ->orderBy('asset_building.ID', 'desc')->get();

            $countbuilding = DB::table('asset_building')
                ->leftJoin('asset_land', 'asset_building.LAND_ID', '=', 'asset_land.ID')
                ->leftJoin('supplies_budget', 'asset_building.BUDGET_ID', '=', 'supplies_budget.BUDGET_ID')
                ->where(function ($q) use ($search) {
                    $q->where('BUILD_NAME', 'like', '%' . $search . '%');
                    $q->orwhere('BUILD_NGUD_MONEY', 'like', '%' . $search . '%');
                })
                ->WhereBetween('BUILD_CREATE', [$from, $to])
                ->orderBy('asset_building.ID', 'desc')->count();

        } else {

            $assetinfobuilding = DB::table('asset_building')
                ->select('asset_building.ID', 'BUILD_NAME', 'BUILD_NGUD_MONEY', 'BUILD_CREATE', 'OLD_USE', 'BUDGET_NAME', 'asset_land.LAND_RAWANG', 'DECLINE_NAME', 'METHOD_NAME', 'BUY_NAME', 'TOTAL', 'BUILD_FINISH', 'TRANSFER_DATE', 'HR_FNAME', 'HR_LNAME', 'BUILD_HR_TEL', 'ENGINEER_NAME', 'COMMENT', 'IMG')
                ->leftJoin('asset_land', 'asset_building.LAND_ID', '=', 'asset_land.ID')
                ->leftJoin('supplies_budget', 'asset_building.BUDGET_ID', '=', 'supplies_budget.BUDGET_ID')
                ->leftJoin('supplies_decline', 'asset_building.DECLINE_ID', '=', 'supplies_decline.DECLINE_ID')
                ->leftJoin('supplies_method', 'asset_building.METHOD_ID', '=', 'supplies_method.METHOD_ID')
                ->leftJoin('supplies_buy', 'asset_building.BUY_ID', '=', 'supplies_buy.BUY_ID')
                ->leftJoin('hrd_person', 'asset_building.BUILD_HR_ID', '=', 'hrd_person.ID')
                ->where('asset_building.BUDGET_ID', '=', $status)
                ->where(function ($q) use ($search) {
                    $q->where('BUILD_NAME', 'like', '%' . $search . '%');
                    $q->orwhere('BUILD_NGUD_MONEY', 'like', '%' . $search . '%');
                })
                ->WhereBetween('BUILD_CREATE', [$from, $to])
                ->orderBy('asset_building.ID', 'desc')->get();

            $countbuilding = DB::table('asset_building')
                ->leftJoin('asset_land', 'asset_building.LAND_ID', '=', 'asset_land.ID')
                ->leftJoin('supplies_budget', 'asset_building.BUDGET_ID', '=', 'supplies_budget.BUDGET_ID')
                ->where('asset_building.BUDGET_ID', '=', $status)
                ->where(function ($q) use ($search) {
                    $q->where('BUILD_NAME', 'like', '%' . $search . '%');
                    $q->orwhere('BUILD_NGUD_MONEY', 'like', '%' . $search . '%');
                })
                ->WhereBetween('BUILD_CREATE', [$from, $to])
                ->orderBy('asset_building.ID', 'desc')->count();

        }

        $budget  = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $year_id = $yearbudget;

        $suppliesbudget = DB::table('supplies_budget')->get();

        return view('manager_asset.assetinfobuilding', [
            'assetinfobuildings' => $assetinfobuilding,
            'suppliesbudgets'    => $suppliesbudget,
            'countbuilding'      => $countbuilding,
            'budgets'            => $budget,
            'displaydate_bigen'  => $displaydate_bigen,
            'displaydate_end'    => $displaydate_end,
            'status_check'       => $status,
            'search'             => $search,
            'year_id'            => $year_id

        ]);

    }

    public function searchassetinfobuilding(Request $request)
    {
        $search     = $request->get('search');
        $status     = $request->SEND_STATUS;
        $datebigin  = $request->get('DATE_BIGIN');
        $dateend    = $request->get('DATE_END');
        $yearbudget = $request->BUDGET_YEAR;

        if ($search == '') {
            $search = "";
        }

        $date_bigen_c = Carbon::createFromFormat('d/m/Y', $datebigin)->format('Y-m-d');
        $date_arrary  = explode("-", $date_bigen_c);

        $y_sub_st = $date_arrary[0];

        if ($y_sub_st >= 2500) {
            $y = $y_sub_st - 543;
        } else {
            $y = $y_sub_st;
        }

        $m                 = $date_arrary[1];
        $d                 = $date_arrary[2];
        $displaydate_bigen = $y . "-" . $m . "-" . $d;

        $date_end_c    = Carbon::createFromFormat('d/m/Y', $dateend)->format('Y-m-d');
        $date_arrary_e = explode("-", $date_end_c);

        $y_sub_e = $date_arrary_e[0];

        if ($y_sub_e >= 2500) {
            $y_e = $y_sub_e - 543;
        } else {
            $y_e = $y_sub_e;
        }

        $m_e             = $date_arrary_e[1];
        $d_e             = $date_arrary_e[2];
        $displaydate_end = $y_e . "-" . $m_e . "-" . $d_e;

        $date              = date('Y-m-d');
        $date_bigen_checks = strtotime($displaydate_bigen);
        $date_end_checks   = strtotime($displaydate_end);
        $dates             = strtotime($date);

        $from = date($displaydate_bigen);
        $to   = date($displaydate_end);

        if ($status == null) {

            $assetinfobuilding = DB::table('asset_building')
                ->select('asset_building.ID', 'BUILD_NAME', 'BUILD_NGUD_MONEY', 'BUILD_CREATE', 'OLD_USE', 'BUDGET_NAME', 'asset_land.LAND_RAWANG', 'DECLINE_NAME', 'METHOD_NAME', 'BUY_NAME', 'TOTAL', 'BUILD_FINISH', 'TRANSFER_DATE', 'HR_FNAME', 'HR_LNAME', 'BUILD_HR_TEL', 'ENGINEER_NAME', 'COMMENT', 'IMG')
                ->leftJoin('asset_land', 'asset_building.LAND_ID', '=', 'asset_land.ID')
                ->leftJoin('supplies_budget', 'asset_building.BUDGET_ID', '=', 'supplies_budget.BUDGET_ID')
                ->leftJoin('supplies_decline', 'asset_building.DECLINE_ID', '=', 'supplies_decline.DECLINE_ID')
                ->leftJoin('supplies_method', 'asset_building.METHOD_ID', '=', 'supplies_method.METHOD_ID')
                ->leftJoin('supplies_buy', 'asset_building.BUY_ID', '=', 'supplies_buy.BUY_ID')
                ->leftJoin('hrd_person', 'asset_building.BUILD_HR_ID', '=', 'hrd_person.ID')
                ->where(function ($q) use ($search) {
                    $q->where('BUILD_NAME', 'like', '%' . $search . '%');
                    $q->orwhere('BUILD_NGUD_MONEY', 'like', '%' . $search . '%');
                })
                ->WhereBetween('BUILD_CREATE', [$from, $to])
                ->orderBy('asset_building.ID', 'desc')->get();

            $countbuilding = DB::table('asset_building')
                ->leftJoin('asset_land', 'asset_building.LAND_ID', '=', 'asset_land.ID')
                ->leftJoin('supplies_budget', 'asset_building.BUDGET_ID', '=', 'supplies_budget.BUDGET_ID')
                ->where(function ($q) use ($search) {
                    $q->where('BUILD_NAME', 'like', '%' . $search . '%');
                    $q->orwhere('BUILD_NGUD_MONEY', 'like', '%' . $search . '%');
                })
                ->WhereBetween('BUILD_CREATE', [$from, $to])
                ->orderBy('asset_building.ID', 'desc')->count();

        } else {

            $assetinfobuilding = DB::table('asset_building')
                ->select('asset_building.ID', 'BUILD_NAME', 'BUILD_NGUD_MONEY', 'BUILD_CREATE', 'OLD_USE', 'BUDGET_NAME', 'asset_land.LAND_RAWANG', 'DECLINE_NAME', 'METHOD_NAME', 'BUY_NAME', 'TOTAL', 'BUILD_FINISH', 'TRANSFER_DATE', 'HR_FNAME', 'HR_LNAME', 'BUILD_HR_TEL', 'ENGINEER_NAME', 'COMMENT', 'IMG')
                ->leftJoin('asset_land', 'asset_building.LAND_ID', '=', 'asset_land.ID')
                ->leftJoin('supplies_budget', 'asset_building.BUDGET_ID', '=', 'supplies_budget.BUDGET_ID')
                ->leftJoin('supplies_decline', 'asset_building.DECLINE_ID', '=', 'supplies_decline.DECLINE_ID')
                ->leftJoin('supplies_method', 'asset_building.METHOD_ID', '=', 'supplies_method.METHOD_ID')
                ->leftJoin('supplies_buy', 'asset_building.BUY_ID', '=', 'supplies_buy.BUY_ID')
                ->leftJoin('hrd_person', 'asset_building.BUILD_HR_ID', '=', 'hrd_person.ID')
                ->where('asset_building.BUDGET_ID', '=', $status)
                ->where(function ($q) use ($search) {
                    $q->where('BUILD_NAME', 'like', '%' . $search . '%');
                    $q->orwhere('BUILD_NGUD_MONEY', 'like', '%' . $search . '%');
                })
                ->WhereBetween('BUILD_CREATE', [$from, $to])
                ->orderBy('asset_building.ID', 'desc')->get();

            $countbuilding = DB::table('asset_building')
                ->leftJoin('asset_land', 'asset_building.LAND_ID', '=', 'asset_land.ID')
                ->leftJoin('supplies_budget', 'asset_building.BUDGET_ID', '=', 'supplies_budget.BUDGET_ID')
                ->where('asset_building.BUDGET_ID', '=', $status)
                ->where(function ($q) use ($search) {
                    $q->where('BUILD_NAME', 'like', '%' . $search . '%');
                    $q->orwhere('BUILD_NGUD_MONEY', 'like', '%' . $search . '%');
                })
                ->WhereBetween('BUILD_CREATE', [$from, $to])
                ->orderBy('asset_building.ID', 'desc')->count();

        }

        $budget  = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $year_id = $yearbudget;

        $suppliesbudget = DB::table('supplies_budget')->get();

        return view('manager_asset.assetinfobuilding', [
            'assetinfobuildings' => $assetinfobuilding,
            'suppliesbudgets'    => $suppliesbudget,
            'countbuilding'      => $countbuilding,
            'budgets'            => $budget,
            'displaydate_bigen'  => $displaydate_bigen,
            'displaydate_end'    => $displaydate_end,
            'status_check'       => $status,
            'search'             => $search,
            'year_id'            => $year_id

        ]);

    }

    public function createassetinfobuilding()
    {
        $supplie = DB::table('supplies')->get();

        $assetland = DB::table('asset_land')->get();

        $suppliesdecline = DB::table('supplies_decline')->get();

        $person = DB::table('hrd_person')->where('HR_STATUS_ID', '=', 1)->get();

        $suppliesbudget = DB::table('supplies_budget')->get();

        $suppliesmethod = DB::table('supplies_method')->get();

        $suppliesbuy = DB::table('supplies_buy')->get();

        return view('manager_asset.assetinfobuilding_add', [
            'supplies'         => $supplie,
            'assetlands'       => $assetland,
            'suppliesdeclines' => $suppliesdecline,
            'persons'          => $person,
            'suppliesbudgets'  => $suppliesbudget,
            'methods'          => $suppliesmethod,
            'buys'             => $suppliesbuy

        ]);

    }

    public function saveassetinfobuilding(Request $request)
    {
        $BUILD_CREATE  = $request->BUILD_CREATE;
        $BUILD_FINISH  = $request->BUILD_FINISH;
        $TRANSFER_DATE = $request->TRANSFER_DATE;

        if ($BUILD_CREATE != '') {
            $STARTDAY       = Carbon::createFromFormat('d/m/Y', $BUILD_CREATE)->format('Y-m-d');
            $date_arrary_st = explode("-", $STARTDAY);
            $y_sub_st       = $date_arrary_st[0];

            if ($y_sub_st >= 2500) {
                $y_st = $y_sub_st - 543;
            } else {
                $y_st = $y_sub_st;
            }
            $m_st        = $date_arrary_st[1];
            $d_st        = $date_arrary_st[2];
            $BUILDCREATE = $y_st . "-" . $m_st . "-" . $d_st;
        } else {
            $BUILDCREATE = null;
        }

        if ($BUILD_FINISH != '') {
            $STARTDAY       = Carbon::createFromFormat('d/m/Y', $BUILD_FINISH)->format('Y-m-d');
            $date_arrary_st = explode("-", $STARTDAY);
            $y_sub_st       = $date_arrary_st[0];

            if ($y_sub_st >= 2500) {
                $y_st = $y_sub_st - 543;
            } else {
                $y_st = $y_sub_st;
            }
            $m_st        = $date_arrary_st[1];
            $d_st        = $date_arrary_st[2];
            $BUILDFINISH = $y_st . "-" . $m_st . "-" . $d_st;
        } else {
            $BUILDFINISH = null;
        }

        if ($TRANSFER_DATE != '') {
            $STARTDAY       = Carbon::createFromFormat('d/m/Y', $TRANSFER_DATE)->format('Y-m-d');
            $date_arrary_st = explode("-", $STARTDAY);
            $y_sub_st       = $date_arrary_st[0];

            if ($y_sub_st >= 2500) {
                $y_st = $y_sub_st - 543;
            } else {
                $y_st = $y_sub_st;
            }
            $m_st         = $date_arrary_st[1];
            $d_st         = $date_arrary_st[2];
            $TRANSFERDATE = $y_st . "-" . $m_st . "-" . $d_st;
        } else {
            $TRANSFERDATE = null;
        }

        $addinfobuilding          = new Assetbuilding();
        $addinfobuilding->LAND_ID = $request->LAND_ID;

        $addinfobuilding->DECLINE_ID = $request->DECLINE_ID;

        $addinfobuilding->BUILD_NAME = $request->BUILD_NAME;

        $addinfobuilding->BUDGET_ID        = $request->BUDGET_ID;
        $addinfobuilding->METHOD_ID        = $request->METHOD_ID;
        $addinfobuilding->BUY_ID           = $request->BUY_ID;
        $addinfobuilding->BUILD_NGUD_MONEY = $request->BUILD_NGUD_MONEY;
        $addinfobuilding->TOTAL            = $request->TOTAL;
        $addinfobuilding->OLD_USE          = $request->OLD_USE;

        $addinfobuilding->BUILD_CREATE  = $BUILDCREATE;
        $addinfobuilding->BUILD_FINISH  = $BUILDFINISH;
        $addinfobuilding->TRANSFER_DATE = $TRANSFERDATE;

        $addinfobuilding->BUILD_HR_ID  = $request->BUILD_HR_ID;
        $addinfobuilding->BUILD_HR_TEL = $request->BUILD_HR_TEL;

        $addinfobuilding->ENGINEER_NAME = $request->ENGINEER_NAME;
        $addinfobuilding->COMMENT       = $request->COMMENT;

        if ($request->hasFile('picture')) {

            $file                 = $request->file('picture');
            $contents             = $file->openFile()->fread($file->getSize());
            $addinfobuilding->IMG = $contents;

        }

        $maxid  = Assetbuilding::max('ID');
        $idfile = $maxid + 1;
        if ($request->hasFile('pdfupload')) {
            $newFileName = 'assetbuilding_' . $idfile . '.' . $request->pdfupload->extension();

            $request->pdfupload->storeAs('assetpdf', $newFileName, 'public');

            $addinfobuilding->FILE_NAME = $newFileName;

        }

        $addinfobuilding->save();

        $addsupplieslocation                    = new Supplieslocation();
        $addsupplieslocation->LOCATION_NAME     = $request->BUILD_NAME;
        $addsupplieslocation->LOCATION_PHONE    = $request->BUILD_HR_TEL;
        $addsupplieslocation->PERSON_CONTACT_ID = $request->BUILD_HR_ID;

        $addsupplieslocation->save();

        return redirect()->route('massete.assetinfobuilding');
    }

    public function editassetinfobuilding(Request $request, $id)
    {
        $supplie = DB::table('supplies')->get();

        $assetland = DB::table('asset_land')->get();

        $suppliesdecline = DB::table('supplies_decline')->get();

        $person = DB::table('hrd_person')->where('HR_STATUS_ID', '=', 1)->get();

        $suppliesbudget = DB::table('supplies_budget')->get();

        $suppliesmethod = DB::table('supplies_method')->get();

        $suppliesbuy = DB::table('supplies_buy')->get();

        $infoassetbuilding = Assetbuilding::where('ID', '=', $id)
            ->first();

        return view('manager_asset.assetinfobuilding_edit', [
            'supplies'          => $supplie,
            'assetlands'        => $assetland,
            'suppliesdeclines'  => $suppliesdecline,
            'persons'           => $person,
            'suppliesbudgets'   => $suppliesbudget,
            'methods'           => $suppliesmethod,
            'buys'              => $suppliesbuy,
            'infoassetbuilding' => $infoassetbuilding

        ]);

    }

    public function updateassetinfobuilding(Request $request)
    {


        $BUILD_CREATE  = $request->BUILD_CREATE;
        $BUILD_FINISH  = $request->BUILD_FINISH;
        $TRANSFER_DATE = $request->TRANSFER_DATE;

        if ($BUILD_CREATE != '') {
            $STARTDAY       = Carbon::createFromFormat('d/m/Y', $BUILD_CREATE)->format('Y-m-d');
            $date_arrary_st = explode("-", $STARTDAY);
            $y_sub_st       = $date_arrary_st[0];

            if ($y_sub_st >= 2500) {
                $y_st = $y_sub_st - 543;
            } else {
                $y_st = $y_sub_st;
            }
            $m_st        = $date_arrary_st[1];
            $d_st        = $date_arrary_st[2];
            $BUILDCREATE = $y_st . "-" . $m_st . "-" . $d_st;
        } else {
            $BUILDCREATE = null;
        }

        if ($BUILD_FINISH != '') {
            $STARTDAY       = Carbon::createFromFormat('d/m/Y', $BUILD_FINISH)->format('Y-m-d');
            $date_arrary_st = explode("-", $STARTDAY);
            $y_sub_st       = $date_arrary_st[0];

            if ($y_sub_st >= 2500) {
                $y_st = $y_sub_st - 543;
            } else {
                $y_st = $y_sub_st;
            }
            $m_st        = $date_arrary_st[1];
            $d_st        = $date_arrary_st[2];
            $BUILDFINISH = $y_st . "-" . $m_st . "-" . $d_st;
        } else {
            $BUILDFINISH = null;
        }

        if ($TRANSFER_DATE != '') {
            $STARTDAY       = Carbon::createFromFormat('d/m/Y', $TRANSFER_DATE)->format('Y-m-d');
            $date_arrary_st = explode("-", $STARTDAY);
            $y_sub_st       = $date_arrary_st[0];

            if ($y_sub_st >= 2500) {
                $y_st = $y_sub_st - 543;
            } else {
                $y_st = $y_sub_st;
            }
            $m_st         = $date_arrary_st[1];
            $d_st         = $date_arrary_st[2];
            $TRANSFERDATE = $y_st . "-" . $m_st . "-" . $d_st;
        } else {
            $TRANSFERDATE = null;
        }

        $idref = $request->ID;

        $addinfobuilding          = Assetbuilding::find($idref);
        $addinfobuilding->LAND_ID = $request->LAND_ID;

        $addinfobuilding->DECLINE_ID = $request->DECLINE_ID;

        $addinfobuilding->BUILD_NAME = $request->BUILD_NAME;

        $addinfobuilding->BUDGET_ID        = $request->BUDGET_ID;
        $addinfobuilding->METHOD_ID        = $request->METHOD_ID;
        $addinfobuilding->BUY_ID           = $request->BUY_ID;
        $addinfobuilding->BUILD_NGUD_MONEY = $request->BUILD_NGUD_MONEY;
        $addinfobuilding->TOTAL            = $request->TOTAL;
        $addinfobuilding->OLD_USE          = $request->OLD_USE;

        $addinfobuilding->BUILD_CREATE  = $BUILDCREATE;
        $addinfobuilding->BUILD_FINISH  = $BUILDFINISH;
        $addinfobuilding->TRANSFER_DATE = $TRANSFERDATE;

        $addinfobuilding->BUILD_HR_ID  = $request->BUILD_HR_ID;
        $addinfobuilding->BUILD_HR_TEL = $request->BUILD_HR_TEL;

        $addinfobuilding->ENGINEER_NAME = $request->ENGINEER_NAME;
        $addinfobuilding->COMMENT       = $request->COMMENT;

        if ($request->hasFile('picture')) {

            $file                 = $request->file('picture');
            $contents             = $file->openFile()->fread($file->getSize());
            $addinfobuilding->IMG = $contents;

        }

        $idfile = $request->ID;
        if ($request->hasFile('pdfupload')) {
            $newFileName = 'assetbuilding_' . $idfile . '.' . $request->pdfupload->extension();

            $request->pdfupload->storeAs('assetpdf', $newFileName, 'public');

            $addinfobuilding->FILE_NAME = $newFileName;

        }

        $addinfobuilding->save();

        $id = $request->ID;

        $addsupplieslocation                    = Supplieslocation::find($id);
        $addsupplieslocation->LOCATION_NAME     = $request->BUILD_NAME;
        $addsupplieslocation->LOCATION_PHONE    = $request->BUILD_HR_TEL;
        $addsupplieslocation->PERSON_CONTACT_ID = $request->BUILD_HR_ID;

        $addsupplieslocation->save();

        Assetdepreciatebuilding::where('DEP_BUILDING_ASSET_ID', '=', $id)->delete();

        $building = DB::table('asset_building')->where('ID', '=', $id)->first();

        $depreciation = DB::table('supplies_decline')->where('supplies_decline.DECLINE_ID', '=', $building->DECLINE_ID)->first();
        $start        = $month        = strtotime($building->BUILD_CREATE . ' + 1 month');
        $yearend      = date("Y", strtotime($building->BUILD_CREATE)) + 60;

        $dateend = $yearend . '-01-01';

        $end = strtotime($dateend);

        //--------------------------------สูตรคำนวน-----------------------------------------------
        $PICE              = $building->BUILD_NGUD_MONEY;
        $per_year          = $depreciation->DECLINE_PERSEN;
        $Depreciation_mont = ($PICE * ($per_year / 100)) / 12;

        $checkdep = Assetdepreciatebuilding::where('DEP_BUILDING_ASSET_ID', '=', $id)->count();

        //-------------------------คำนวณเดือนแรก----------------------------

        $fristYear  = date("Y", strtotime($building->BUILD_CREATE)) + 543;
        $fristMonth = date("m", strtotime($building->BUILD_CREATE));
        $fristdate  = date("d", strtotime($building->BUILD_CREATE));


        if ($fristMonth == '04' || $fristMonth == '06' || $fristMonth == '09' || $fristMonth == '11') {
            $d = 30;
        } elseif ($fristMonth == '02') {
            if (($fristYear - 543) % 4 == 0) {
                $d = 29;
            } else {
                $d = 28;
            }

        } else {
            $d = 31;
        }

        $amountdate = $d - $fristdate;
        $Depdate    = $Depreciation_mont / $d;

        $fristDepreciation_mont = $amountdate * $Depdate;

        $fristDepreciation = $PICE - $fristDepreciation_mont;

        //-------------เพิ่มข้อมูลในตาราง----------------------------
        if ($checkdep == 0) {
            $adddepreciatebuilding                          = new Assetdepreciatebuilding();
            $adddepreciatebuilding->DEP_BUILDING_ASSET_ID   = $id;
            $adddepreciatebuilding->DEP_BUILDING_YEAR       = $fristYear;
            $adddepreciatebuilding->DEP_BUILDING_MONTH      = number_format($fristMonth);
            $adddepreciatebuilding->DEP_BUILDING_PRICE      = $PICE;
            $adddepreciatebuilding->DEP_BUILDING_FORWARD    = 0;
            $adddepreciatebuilding->DEP_BUILDING_DEPRECIATE = $fristDepreciation_mont;
            $adddepreciatebuilding->DEP_BUILDING_CUMULATIVE = $fristDepreciation_mont;
            $adddepreciatebuilding->DEP_BUILDING_VALUE      = $fristDepreciation;
            $adddepreciatebuilding->save();

        } //------------------------------------------

        //----------------------------------------------------

        $Depreciation_move = $fristDepreciation_mont;
        $Depreciation      = $Depreciation_mont + $Depreciation_move;

        while ($month < $end) {

            $year = date('Y', $month) + 543;

            $value_last = ($PICE - $Depreciation_move) - 1; //-----ตัวตัดค่าเสื่อมตัวสุดท้าย

            $value = $PICE - $Depreciation;

            if ($value <= 0) {
                $Depreciation_mont = $value_last;
                $Depreciation      = $Depreciation_move + $Depreciation_mont;
                $value             = 1;

            }

            //-------------เพิ่มข้อมูลในตาราง----------------------------
            if ($checkdep == 0) {
                $adddepreciatebuilding                          = new Assetdepreciatebuilding();
                $adddepreciatebuilding->DEP_BUILDING_ASSET_ID   = $id;
                $adddepreciatebuilding->DEP_BUILDING_YEAR       = $year;
                $adddepreciatebuilding->DEP_BUILDING_MONTH      = number_format(date('m', $month));
                $adddepreciatebuilding->DEP_BUILDING_PRICE      = $PICE;
                $adddepreciatebuilding->DEP_BUILDING_FORWARD    = $Depreciation_move;
                $adddepreciatebuilding->DEP_BUILDING_DEPRECIATE = $Depreciation_mont;
                $adddepreciatebuilding->DEP_BUILDING_CUMULATIVE = $Depreciation;
                $adddepreciatebuilding->DEP_BUILDING_VALUE      = $value;
                $adddepreciatebuilding->save();
            }
            //------------------------------------------

            if ($value == 1) {
                break;
            }
            $Depreciation = $Depreciation_mont + $Depreciation;

            $Depreciation_move = $Depreciation - $Depreciation_mont;

            $month = strtotime("+1 month", $month);
        }

        return redirect()->route('massete.assetinfobuilding');
    }

    public function infolocationlevel($idlocation)
    {
        $infosupplieslocationlevel = Supplieslocationlevel::where('LOCATION_ID', '=', $idlocation)
            ->orderBy('LOCATION_LEVEL_ID', 'asc')
            ->get();

        $infosupplocationlevelname = Supplieslocation::where('LOCATION_ID', '=', $idlocation)
            ->first();

        return view('manager_asset.assetinfobuilding_locationlevel', [
            'infosupplieslocationlevels' => $infosupplieslocationlevel,
            'infosupplocationlevelname'  => $infosupplocationlevelname
        ]);
    }

    public function infolocationlevelroom($idlocation, $idlocationlevel)
    {
        $infosupplieslocationlevelroom = Supplieslocationlevelroom::where('LOCATION_LEVEL_ID', '=', $idlocationlevel)
            ->orderBy('LEVEL_ROOM_ID', 'asc')
            ->get();

        $infosupplocationlevelname = Supplieslocationlevel::where('LOCATION_LEVEL_ID', '=', $idlocationlevel)
            ->first();

        $infosupplocationname = Supplieslocation::where('LOCATION_ID', '=', $idlocation)
            ->first();

        return view('manager_asset.assetinfobuilding_locationlevelroom', [
            'infosupplieslocationlevelrooms' => $infosupplieslocationlevelroom,
            'infosupplocationlevelname'      => $infosupplocationlevelname,
            'infosupplocationname'           => $infosupplocationname
        ]);
    }

    //--------------------------------ตั้งค่าชั้น-------------------------------

    public function savelocationlevel(Request $request)
    {

        $request->validate([
            'LOCATION_LEVEL_NAME' => 'required'
        ]);

        $idlocation = $request->LOCATION_ID;


        $addsupplieslocationlevel                      = new Supplieslocationlevel();
        $addsupplieslocationlevel->LOCATION_ID         = $idlocation;
        $addsupplieslocationlevel->LOCATION_LEVEL_NAME = $request->LOCATION_LEVEL_NAME;
        $addsupplieslocationlevel->save();


        return response()->json([
            'status' => 1,
            'url'    => url('manager_asset/setassetinfolocationlevel/' . $idlocation)
        ]);
    }

    public function updatelocationlevel(Request $request)
    {

        $request->validate([
            'LOCATION_LEVEL_NAME_EDIT' => 'required'
        ]);

        $id         = $request->ID;
        $idlocation = $request->LOCATION_ID;

        $updatesupplieslocationlevel                      = Supplieslocationlevel::find($id);
        $updatesupplieslocationlevel->LOCATION_ID         = $idlocation;
        $updatesupplieslocationlevel->LOCATION_LEVEL_NAME = $request->LOCATION_LEVEL_NAME_EDIT;

        $updatesupplieslocationlevel->save();

        return response()->json([
            'status' => 1,
            'url'    => url('manager_asset/setassetinfolocationlevel/' . $idlocation)
        ]);

    }

    public function destroylocationlevel($id, $idlocation)
    {

        Supplieslocationlevel::destroy($id);
        return redirect()->route('massete.infolocationlevel', [
            'idlocation' => $idlocation
        ]);
    }

    //--------------------------------ตั้งค่าห้อง-------------------------------

    public function saveinfolocationlevelroom(Request $request)
    {

        $request->validate([
            'LEVEL_ROOM_NAME' => 'required'
        ]);

        $idlocation      = $request->LOCATION_ID;
        $idlocationlevel = $request->LOCATION_LEVEL_ID;

        $addsupplieslocationlevelroom                    = new Supplieslocationlevelroom();
        $addsupplieslocationlevelroom->LOCATION_LEVEL_ID = $idlocationlevel;
        $addsupplieslocationlevelroom->LEVEL_ROOM_NAME   = $request->LEVEL_ROOM_NAME;
        $addsupplieslocationlevelroom->save();

        return response()->json([
            'status' => 1,
            'url'    => url('manager_asset/setassetinfolocationlevelroom/' . $idlocation . '/' . $idlocationlevel)
        ]);
    }

    public function updateinfolocationlevelroom(Request $request)
    {

        $id              = $request->LEVEL_ROOM_ID;
        $idlocation      = $request->LOCATION_ID;
        $idlocationlevel = $request->LOCATION_LEVEL_ID;

        $updatesupplieslocationlevelroom                    = Supplieslocationlevelroom::find($id);
        $updatesupplieslocationlevelroom->LOCATION_LEVEL_ID = $idlocationlevel;
        $updatesupplieslocationlevelroom->LEVEL_ROOM_NAME   = $request->LEVEL_ROOM_NAME_EDIT;

        $updatesupplieslocationlevelroom->save();

          return redirect()->route('massete.infolocationlevelroom',[
             'idlocation' => $idlocation,
            'idlocationlevel' => $idlocationlevel,
          ]);

    }

    public function destroyinfolocationlevelroom($id, $idlocation, $idlocationlevel)
    {

        Supplieslocationlevelroom::destroy($id);
        return redirect()->route('massete.infolocationlevelroom', [
            'idlocation'      => $idlocation,
            'idlocationlevel' => $idlocationlevel
        ]);
    }

    //-------------------------ค่าเสื่อม---------------------------------

    public function depreciatebuilding(Request $request)
    {

        function MThai($Month)
        {
            $strMonth     = number_format($Month);
            $strMonthCut  = array("", "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
            $strMonthThai = $strMonthCut[$strMonth];
            return $strMonthThai;
        }

        $building = DB::table('asset_building')->where('ID', '=', $request->id)

            ->first();

        $depreciation = DB::table('supplies_decline')->where('supplies_decline.DECLINE_ID', '=', $building->DECLINE_ID)->first();

        $start = $month = strtotime($building->BUILD_CREATE . ' + 1 month');

        $yearend = date("Y", strtotime($building->BUILD_CREATE)) + 60;

        $dateend = $yearend . '-01-01';

        $end = strtotime($dateend);

        //=========================

        $output = '

                              <div class="row push" style="font-family: \'Kanit\', sans-serif;">

                              <div class="col-sm-9">

                              <div class="row">
                                  <div class="col-lg-2" align="right">
                                  <label>เลข :</label>
                                  </div>
                                  <div class="col-lg-4" align="left">
                                  ' . $building->SUP_FSN . '
                                  </div>

                                  <div class="col-lg-2" align="right">
                                  <label>ชื่อตึก  :</label>
                                  </div>
                                  <div class="col-lg-4" align="left">
                                  ' . $building->BUILD_NAME . '
                                  </div>


                                  </div>



                              <br>
                              <div style="height:400px;overflow-y:scroll;">
                              <table>

                              <table class="table-bordered table-striped table-vcenter js-dataTable-simple" style="width: 100%;">
                              <thead style="background-color: #FFEBCD;">
                                  <tr height="40">
                                  <th  class="text-font"  style="border-color:#F0FFFF;text-align: center;font-family: \'Kanit\', sans-serif;" width="5%">ปี</th>
                                  <th  class="text-font" style="border-color:#F0FFFF;text-align: center;font-family: \'Kanit\', sans-serif;" width="10%">เดือน</th>
                                  <th  class="text-font" style="border-color:#F0FFFF;text-align: center;font-family: \'Kanit\', sans-serif;"  width="15%">ราคาตั้งต้น</th>
                                  <th  class="text-font" style="border-color:#F0FFFF;text-align: center;font-family: \'Kanit\', sans-serif;"   width="15%">ค่าเสื่อมยกมา</th>
                                  <th  class="text-font" style="border-color:#F0FFFF;text-align: center;font-family: \'Kanit\', sans-serif;"   width="15%">ค่าเสื่อม</th>
                                  <th  class="text-font" style="border-color:#F0FFFF;text-align: center;font-family: \'Kanit\', sans-serif;"   width="15%">ค่าเสื่อมสะสม</th>
                                  <th  class="text-font" style="border-color:#F0FFFF;text-align: center;font-family: \'Kanit\', sans-serif;"   width="15%">มูลค่า</th>

                                          </tr>
                                          </thead>
                                          <tbody >';

        //--------------------------------สูตรคำนวน-----------------------------------------------
        $PICE              = $building->BUILD_NGUD_MONEY;
        $per_year          = $depreciation->DECLINE_PERSEN;
        $Depreciation_mont = ($PICE * ($per_year / 100)) / 12;

        $checkdep = Assetdepreciatebuilding::where('DEP_BUILDING_ASSET_ID', '=', $request->id)->count();

        //-------------------------คำนวณเดือนแรก----------------------------

        $fristYear  = date("Y", strtotime($building->BUILD_CREATE)) + 543;
        $fristMonth = date("m", strtotime($building->BUILD_CREATE));
        $fristdate  = date("d", strtotime($building->BUILD_CREATE));

        if ($fristMonth == '04' || $fristMonth == '06' || $fristMonth == '09' || $fristMonth == '11') {
            $d = 30;
        } elseif ($fristMonth == '02') {
            if (($fristYear - 543) % 4 == 0) {
                $d = 29;
            } else {
                $d = 28;
            }

        } else {
            $d = 31;
        }

        $amountdate = $d - $fristdate;
        $Depdate    = $Depreciation_mont / $d;

        $fristDepreciation_mont = $amountdate * $Depdate;

        $fristDepreciation = $PICE - $fristDepreciation_mont;

        $output .= '<tr>';
        $output .= '<td class="text-font " align="center">' . $fristYear . '</td ><td class="text-font text-pedding">' . MThai($fristMonth) . '</td><td class="text-font text-pedding" align="right">' . number_format($PICE, 2) . '</td><td class="text-font text-pedding" align="right">0.00</td><td class="text-font text-pedding" align="right">' . number_format($fristDepreciation_mont, 2) . '</td><td class="text-font text-pedding" align="right">' . number_format($fristDepreciation_mont, 2) . '</td><td class="text-font text-pedding" align="right">' . number_format($fristDepreciation, 2) . '</td>';
        $output .= '</tr>';

        //-------------เพิ่มข้อมูลในตาราง----------------------------
        if ($checkdep == 0) {
            $adddepreciatebuilding                          = new Assetdepreciatebuilding();
            $adddepreciatebuilding->DEP_BUILDING_ASSET_ID   = $request->id;
            $adddepreciatebuilding->DEP_BUILDING_YEAR       = $fristYear;
            $adddepreciatebuilding->DEP_BUILDING_MONTH      = number_format($fristMonth);
            $adddepreciatebuilding->DEP_BUILDING_PRICE      = $PICE;
            $adddepreciatebuilding->DEP_BUILDING_FORWARD    = 0;
            $adddepreciatebuilding->DEP_BUILDING_DEPRECIATE = $fristDepreciation_mont;
            $adddepreciatebuilding->DEP_BUILDING_CUMULATIVE = $fristDepreciation_mont;
            $adddepreciatebuilding->DEP_BUILDING_VALUE      = $fristDepreciation;
            $adddepreciatebuilding->save();

        } //------------------------------------------

        //----------------------------------------------------

        $Depreciation_move = $fristDepreciation_mont;
        $Depreciation      = $Depreciation_mont + $Depreciation_move;

        while ($month < $end) {

            $year = date('Y', $month) + 543;

            $value_last = ($PICE - $Depreciation_move) - 1; //-----ตัวตัดค่าเสื่อมตัวสุดท้าย

            $value = $PICE - $Depreciation;

            if ($value <= 0) {
                $Depreciation_mont = $value_last;
                $Depreciation      = $Depreciation_move + $Depreciation_mont;
                $value             = 1;

            }

            $output .= '<tr>';
            $output .= '<td class="text-font " align="center">' . $year . '</td><td class="text-font text-pedding">' . MThai(date('m', $month)) . '</td><td class="text-font text-pedding" align="right" >' . number_format($PICE, 2) . '</td><td  class="text-font text-pedding" align="right">' . number_format($Depreciation_move, 2) . '</td><td  class="text-font text-pedding" align="right">' . number_format($Depreciation_mont, 2) . '</td><td  class="text-font text-pedding" align="right">' . number_format($Depreciation, 2) . '</td ><td class="text-font text-pedding" align="right">' . number_format($value, 2) . '</td>';
            $output .= '</tr>';

            //-------------เพิ่มข้อมูลในตาราง----------------------------
            if ($checkdep == 0) {
                $adddepreciatebuilding                          = new Assetdepreciatebuilding();
                $adddepreciatebuilding->DEP_BUILDING_ASSET_ID   = $request->id;
                $adddepreciatebuilding->DEP_BUILDING_YEAR       = $year;
                $adddepreciatebuilding->DEP_BUILDING_MONTH      = number_format(date('m', $month));
                $adddepreciatebuilding->DEP_BUILDING_PRICE      = $PICE;
                $adddepreciatebuilding->DEP_BUILDING_FORWARD    = $Depreciation_move;
                $adddepreciatebuilding->DEP_BUILDING_DEPRECIATE = $Depreciation_mont;
                $adddepreciatebuilding->DEP_BUILDING_CUMULATIVE = $Depreciation;
                $adddepreciatebuilding->DEP_BUILDING_VALUE      = $value;
                $adddepreciatebuilding->save();
            }
            //------------------------------------------

            if ($value == 1) {
                break;
            }
            $Depreciation = $Depreciation_mont + $Depreciation;

            $Depreciation_move = $Depreciation - $Depreciation_mont;

            $month = strtotime("+1 month", $month);

        }

        $output .= '</tbody ></table>

                              </div>
                              </div>
                              <div class="col-sm-3 text-left">

                              <div class="form-group">

                              <img src="data:image/png;base64,' . chunk_split(base64_encode($building->IMG)) . '" id="image_upload_preview" alt="กรุณาเพิ่มรูปภาพ" height="200" width="200"/>
                              </div>

                              </div>
                              </div>
                              </div>
                              </div>';

        echo $output;

    }

    //====================รายการที่ดิน===================================

    public function assetinfoland(Request $request)
    {
        if(!empty($request->_token)){
            $search = $request->get('search');
            session([
                'manager_asset.assetinfoland.search' => $search
                ]);
        }elseif(!empty(session('manager_asset.assetinfoland'))){
            $search = session('manager_asset.assetinfoland.search');
        }else{
            $search ='';
        }

        $assetinfoland = DB::table('asset_land')
            ->select('asset_land.ID', 'LAND_RAWANG', 'LAND_NUMBER', 'LAND_CHANOD', 'LAND_FONT_CHECK', 'LAND_ADD', 'hrd_tumbon.TUMBON_NAME', 'hrd_amphur.AMPHUR_NAME', 'hrd_province.PROVINCE_NAME', 'LAND_SIZE', 'LAND_SIZE_NGAN', 'LAND_SIZE_TARANGWA', 'LAND_OWNER', 'LAND_OWNER_DATE', 'LAND_LAT', 'LAND_LNG', 'LAND_OFFICE', 'LAND_OFFICE_PHONE')
            ->leftJoin('hrd_province', 'asset_land.PROVINCE_ID', '=', 'hrd_province.ID')
            ->leftJoin('hrd_amphur', 'asset_land.AMPHUR_ID', '=', 'hrd_amphur.ID')
            ->leftJoin('hrd_tumbon', 'asset_land.TUMBON_ID', '=', 'hrd_tumbon.ID')
            ->where(function ($q) use ($search) {
                $q->where('LAND_RAWANG', 'like', '%' . $search . '%');
                $q->orwhere('LAND_NUMBER', 'like', '%' . $search . '%');
                $q->orwhere('LAND_CHANOD', 'like', '%' . $search . '%');
                $q->orwhere('LAND_SIZE', 'like', '%' . $search . '%');
                $q->orwhere('LAND_SIZE_NGAN', 'like', '%' . $search . '%');
                $q->orwhere('LAND_SIZE_TARANGWA', 'like', '%' . $search . '%');
                $q->orwhere('LAND_OFFICE', 'like', '%' . $search . '%');
            })
            ->orderBy('asset_land.ID', 'desc')->get();

        $countland = DB::table('asset_land')->count();

        return view('manager_asset.assetinfoland', [
            'assetinfolands' => $assetinfoland,
            'countland'      => $countland,
            'search'         => $search

        ]);
    }

    public function searchassetinfoland(Request $request)
    {

        $search = $request->get('search');
        if ($search == '') {
            $search = "";
        }

        $assetinfoland = DB::table('asset_land')
            ->select('asset_land.ID', 'LAND_RAWANG', 'LAND_NUMBER', 'LAND_CHANOD', 'LAND_FONT_CHECK', 'LAND_ADD', 'hrd_tumbon.TUMBON_NAME', 'hrd_amphur.AMPHUR_NAME', 'hrd_province.PROVINCE_NAME', 'LAND_SIZE', 'LAND_SIZE_NGAN', 'LAND_SIZE_TARANGWA', 'LAND_OWNER', 'LAND_OWNER_DATE', 'LAND_LAT', 'LAND_LNG', 'LAND_OFFICE', 'LAND_OFFICE_PHONE')
            ->leftJoin('hrd_province', 'asset_land.PROVINCE_ID', '=', 'hrd_province.ID')
            ->leftJoin('hrd_amphur', 'asset_land.AMPHUR_ID', '=', 'hrd_amphur.ID')
            ->leftJoin('hrd_tumbon', 'asset_land.TUMBON_ID', '=', 'hrd_tumbon.ID')
            ->where(function ($q) use ($search) {
                $q->where('LAND_RAWANG', 'like', '%' . $search . '%');
                $q->orwhere('LAND_NUMBER', 'like', '%' . $search . '%');
                $q->orwhere('LAND_CHANOD', 'like', '%' . $search . '%');
                $q->orwhere('LAND_SIZE', 'like', '%' . $search . '%');
                $q->orwhere('LAND_SIZE_NGAN', 'like', '%' . $search . '%');
                $q->orwhere('LAND_SIZE_TARANGWA', 'like', '%' . $search . '%');
                $q->orwhere('LAND_OFFICE', 'like', '%' . $search . '%');
            })
            ->orderBy('asset_land.ID', 'desc')->get();

        $countland = DB::table('asset_land')->count();

        return view('manager_asset.assetinfoland', [
            'assetinfolands' => $assetinfoland,
            'countland'      => $countland,
            'search'         => $search

        ]);

    }

    public function createassetinfoland()
    {
        $infoprovince = DB::table('hrd_province')->get();

        $supplie = DB::table('supplies')->get();

        return view('manager_asset.assetinfoland_add', [
            'infoprovinces' => $infoprovince,
            'supplies'      => $supplie
        ]);

    }

    public function saveassetinfoland(Request $request)
    {
        $request->validate([
            'LAND_RAWANG'        => 'required',
            'LAND_NUMBER'        => 'required',
            'LAND_CHANOD'        => 'required',
            'LAND_FONT_CHECK'    => 'required',
            'LAND_ADD'           => 'required',
            'PROVINCE_ID'        => 'required',
            'AMPHUR_ID'          => 'required',
            'TUMBON_ID'          => 'required',
            'ZIPCODE'            => 'required',
            'LAND_SIZE'          => 'required',
            'LAND_SIZE_NGAN'     => 'required',
            'LAND_SIZE_TARANGWA' => 'required',
            'LAND_OWNER'         => 'required',
            'LAND_OWNER_DATE'    => 'required',
            'LAND_LAT'           => 'required',
            'LAND_LNG'           => 'required',
            'LAND_OFFICE'        => 'required',
            'LAND_OFFICE_PHONE'  => 'required'
        ]);

        $LAND_DATE = $request->LAND_OWNER_DATE;

        if ($LAND_DATE != '') {
            $STARTDAY       = Carbon::createFromFormat('d/m/Y', $LAND_DATE)->format('Y-m-d');
            $date_arrary_st = explode("-", $STARTDAY);
            $y_sub_st       = $date_arrary_st[0];

            if ($y_sub_st >= 2500) {
                $y_st = $y_sub_st - 543;
            } else {
                $y_st = $y_sub_st;
            }
            $m_st     = $date_arrary_st[1];
            $d_st     = $date_arrary_st[2];
            $LANDDATE = $y_st . "-" . $m_st . "-" . $d_st;
        } else {
            $LANDDATE = null;
        }

        $addinfoland                     = new Assetland();
        $addinfoland->LAND_RAWANG        = $request->LAND_RAWANG;
        $addinfoland->LAND_NUMBER        = $request->LAND_NUMBER;
        $addinfoland->LAND_CHANOD        = $request->LAND_CHANOD;
        $addinfoland->LAND_FONT_CHECK    = $request->LAND_FONT_CHECK;
        $addinfoland->LAND_ADD           = $request->LAND_ADD;
        $addinfoland->PROVINCE_ID        = $request->PROVINCE_ID;
        $addinfoland->AMPHUR_ID          = $request->AMPHUR_ID;
        $addinfoland->TUMBON_ID          = $request->TUMBON_ID;
        $addinfoland->ZIPCODE            = $request->ZIPCODE;
        $addinfoland->LAND_SIZE          = $request->LAND_SIZE;
        $addinfoland->LAND_SIZE_NGAN     = $request->LAND_SIZE_NGAN;
        $addinfoland->LAND_SIZE_TARANGWA = $request->LAND_SIZE_TARANGWA;
        $addinfoland->LAND_OWNER         = $request->LAND_OWNER;
        $addinfoland->LAND_OWNER_DATE    = $request->LANDDATE;
        $addinfoland->LAND_LAT           = $request->LAND_LAT;
        $addinfoland->LAND_LNG           = $request->LAND_LNG;
        $addinfoland->LAND_OFFICE        = $request->LAND_OFFICE;
        $addinfoland->LAND_OFFICE_PHONE  = $request->LAND_OFFICE_PHONE;

        $maxid  = Assetland::max('ID');
        $idfile = $maxid + 1;
        if ($request->hasFile('pdfupload')) {
            $newFileName = 'assetland_' . $idfile . '.' . $request->pdfupload->extension();

            $request->pdfupload->storeAs('assetpdf', $newFileName, 'public');

            $addinfoland->FILE_NAME = $newFileName;

        }

        $addinfoland->save();

        return response()->json([
            'status' => 1,
            'url'    => url('manager_asset/assetinfoland')
        ]);
    }

    public function editassetinfoland(Request $request, $id)
    {
        $infoprovince = DB::table('hrd_province')->get();

        $supplie = DB::table('supplies')->get();

        $infoassetland = Assetland::where('ID', '=', $id)
            ->first();

        $infoamphure = DB::table('hrd_amphur')->where('PROVINCE_ID', '=', $infoassetland->PROVINCE_ID)->get();

        $infotumbon = DB::table('hrd_tumbon')->where('AMPHUR_ID', '=', $infoassetland->AMPHUR_ID)->get();

        return view('manager_asset.assetinfoland_edit', [
            'infoassetland' => $infoassetland,
            'infoprovinces' => $infoprovince,
            'supplies'      => $supplie,
            'infoamphures'  => $infoamphure,
            'infotumbons'   => $infotumbon
        ]);

    }

    public function updateassetinfoland(Request $request)
    {
        $request->validate([
            'LAND_RAWANG'        => 'required',
            'LAND_NUMBER'        => 'required',
            'LAND_CHANOD'        => 'required',
            'LAND_FONT_CHECK'    => 'required',
            'LAND_ADD'           => 'required',
            'PROVINCE_ID'        => 'required',
            'AMPHUR_ID'          => 'required',
            'TUMBON_ID'          => 'required',
            'ZIPCODE'            => 'required',
            'LAND_SIZE'          => 'required',
            'LAND_SIZE_NGAN'     => 'required',
            'LAND_SIZE_TARANGWA' => 'required',
            'LAND_OWNER'         => 'required',
            'LAND_OWNER_DATE'    => 'required',
            'LAND_LAT'           => 'required',
            'LAND_LNG'           => 'required',
            'LAND_OFFICE'        => 'required',
            'LAND_OFFICE_PHONE'  => 'required'
        ]);
        $LAND_DATE = $request->LAND_OWNER_DATE;

        if ($LAND_DATE != '') {
            $STARTDAY       = Carbon::createFromFormat('d/m/Y', $LAND_DATE)->format('Y-m-d');
            $date_arrary_st = explode("-", $STARTDAY);
            $y_sub_st       = $date_arrary_st[0];

            if ($y_sub_st >= 2500) {
                $y_st = $y_sub_st - 543;
            } else {
                $y_st = $y_sub_st;
            }
            $m_st     = $date_arrary_st[1];
            $d_st     = $date_arrary_st[2];
            $LANDDATE = $y_st . "-" . $m_st . "-" . $d_st;
        } else {
            $LANDDATE = null;
        }

        $idref                           = $request->ID;
        $addinfoland                     = Assetland::find($idref);
        $addinfoland->LAND_RAWANG        = $request->LAND_RAWANG;
        $addinfoland->LAND_NUMBER        = $request->LAND_NUMBER;
        $addinfoland->LAND_CHANOD        = $request->LAND_CHANOD;
        $addinfoland->LAND_FONT_CHECK    = $request->LAND_FONT_CHECK;
        $addinfoland->LAND_ADD           = $request->LAND_ADD;
        $addinfoland->PROVINCE_ID        = $request->PROVINCE_ID;
        $addinfoland->AMPHUR_ID          = $request->AMPHUR_ID;
        $addinfoland->TUMBON_ID          = $request->TUMBON_ID;
        $addinfoland->ZIPCODE            = $request->ZIPCODE;
        $addinfoland->LAND_SIZE          = $request->LAND_SIZE;
        $addinfoland->LAND_SIZE_NGAN     = $request->LAND_SIZE_NGAN;
        $addinfoland->LAND_SIZE_TARANGWA = $request->LAND_SIZE_TARANGWA;
        $addinfoland->LAND_OWNER         = $request->LAND_OWNER;
        $addinfoland->LAND_OWNER_DATE    = $request->LANDDATE;
        $addinfoland->LAND_LAT           = $request->LAND_LAT;
        $addinfoland->LAND_LNG           = $request->LAND_LNG;
        $addinfoland->LAND_OFFICE        = $request->LAND_OFFICE;
        $addinfoland->LAND_OFFICE_PHONE  = $request->LAND_OFFICE_PHONE;

        $idfile = $request->ID;
        if ($request->hasFile('pdfupload')) {
            $newFileName = 'assetland_' . $idfile . '.' . $request->pdfupload->extension();

            $request->pdfupload->storeAs('assetpdf', $newFileName, 'public');

            $addinfoland->FILE_NAME = $newFileName;

        }

        $addinfoland->save();

        return response()->json([
            'status' => 1,
            'url'    => url('manager_asset/assetinfoland')
        ]);
    }

//===========================คำนวณค่าเสื่อม======================================

    public function assetinfocalculate(Request $request) 
    {
        if(!empty($request->_token)){
            $year_max = $request->get('YEAR_ID');
            $month    = $request->get('SEND_MONTH');
            session([
                'manager_asset.assetinfocalculate.year_max' => $year_max,
                'manager_asset.assetinfocalculate.month' => $month
                ]);
        }elseif(!empty(session('manager_asset.assetinfocalculate'))){
            $year_max     = session('manager_asset.assetinfocalculate.year_max');
            $month     = session('manager_asset.assetinfocalculate.month');
        }else{
            $year_max = getBudgetyear();
            $month    = date('m');
        }
 
        $budget = DB::table('asset_article')
            ->select('YEAR_ID', DB::raw('count(*) as total'))
            ->groupBy('YEAR_ID')
            ->orderBy('YEAR_ID', 'desc')
            ->get();
        $depbuilding = Assetdepreciatebuilding::leftJoin('asset_building', 'asset_depreciate_building.DEP_BUILDING_ASSET_ID', '=', 'asset_building.ID')
            ->leftJoin('supplies_decline', 'supplies_decline.DECLINE_ID', '=', 'asset_building.DECLINE_ID')
            ->where(function ($q) use ($year_max, $month) {
                $q->where('DEP_BUILDING_YEAR', '=', $year_max);
                $q->where('DEP_BUILDING_MONTH', '=', $month);
            })
            ->orwhere(function ($r) use ($year_max, $month) {
                $r->where('DEP_BUILDING_YEAR', '<', $year_max);
                $r->where('DEP_BUILDING_VALUE', '=', 1);
            })
            ->orwhere(function ($i) use ($year_max, $month) {
                $i->where('DEP_BUILDING_YEAR', '=', $year_max);
                $i->where('DEP_BUILDING_MONTH', '<', $month);
                $i->where('DEP_BUILDING_VALUE', '=', 1);
            })
            ->get();
        //=========================ผลรวมอาคารสิ่งก่อสร้าง

        $sumbuilding1 = Assetdepreciatebuilding::leftJoin('asset_building', 'asset_depreciate_building.DEP_BUILDING_ASSET_ID', '=', 'asset_building.ID')
            ->leftJoin('supplies_decline', 'supplies_decline.DECLINE_ID', '=', 'asset_building.DECLINE_ID')
            ->where(function ($q) use ($year_max, $month) {
                $q->where('DEP_BUILDING_YEAR', '=', $year_max);
                $q->where('DEP_BUILDING_MONTH', '=', $month);
            })
            ->orwhere(function ($r) use ($year_max, $month) {
                $r->where('DEP_BUILDING_YEAR', '<', $year_max);
                $r->where('DEP_BUILDING_VALUE', '=', 1);
            })
            ->orwhere(function ($i) use ($year_max, $month) {
                $i->where('DEP_BUILDING_YEAR', '=', $year_max);
                $i->where('DEP_BUILDING_MONTH', '<', $month);
                $i->where('DEP_BUILDING_VALUE', '=', 1);
            })
            ->sum('DEP_BUILDING_PRICE');
        $sumbuilding2 = Assetdepreciatebuilding::leftJoin('asset_building', 'asset_depreciate_building.DEP_BUILDING_ASSET_ID', '=', 'asset_building.ID')
            ->leftJoin('supplies_decline', 'supplies_decline.DECLINE_ID', '=', 'asset_building.DECLINE_ID')
            ->where(function ($q) use ($year_max, $month) {
                $q->where('DEP_BUILDING_YEAR', '=', $year_max);
                $q->where('DEP_BUILDING_MONTH', '=', $month);
            })
            ->orwhere(function ($r) use ($year_max, $month) {
                $r->where('DEP_BUILDING_YEAR', '<', $year_max);
                $r->where('DEP_BUILDING_VALUE', '=', 1);
            })
            ->orwhere(function ($i) use ($year_max, $month) {
                $i->where('DEP_BUILDING_YEAR', '=', $year_max);
                $i->where('DEP_BUILDING_MONTH', '<', $month);
                $i->where('DEP_BUILDING_VALUE', '=', 1);
            })
            ->sum('DEP_BUILDING_FORWARD');
        $sumbuilding3 = Assetdepreciatebuilding::leftJoin('asset_building', 'asset_depreciate_building.DEP_BUILDING_ASSET_ID', '=', 'asset_building.ID')
            ->leftJoin('supplies_decline', 'supplies_decline.DECLINE_ID', '=', 'asset_building.DECLINE_ID')
            ->where(function ($q) use ($year_max, $month) {
                $q->where('DEP_BUILDING_YEAR', '=', $year_max);
                $q->where('DEP_BUILDING_MONTH', '=', $month);
            })
            ->orwhere(function ($r) use ($year_max, $month) {
                $r->where('DEP_BUILDING_YEAR', '<', $year_max);
                $r->where('DEP_BUILDING_VALUE', '=', 1);
            })
            ->orwhere(function ($i) use ($year_max, $month) {
                $i->where('DEP_BUILDING_YEAR', '=', $year_max);
                $i->where('DEP_BUILDING_MONTH', '<', $month);
                $i->where('DEP_BUILDING_VALUE', '=', 1);
            })
            ->sum('DEP_BUILDING_DEPRECIATE');
        $sumbuilding4 = Assetdepreciatebuilding::leftJoin('asset_building', 'asset_depreciate_building.DEP_BUILDING_ASSET_ID', '=', 'asset_building.ID')
            ->leftJoin('supplies_decline', 'supplies_decline.DECLINE_ID', '=', 'asset_building.DECLINE_ID')
            ->where(function ($q) use ($year_max, $month) {
                $q->where('DEP_BUILDING_YEAR', '=', $year_max);
                $q->where('DEP_BUILDING_MONTH', '=', $month);
            })
            ->orwhere(function ($r) use ($year_max, $month) {
                $r->where('DEP_BUILDING_YEAR', '<', $year_max);
                $r->where('DEP_BUILDING_VALUE', '=', 1);
            })
            ->orwhere(function ($i) use ($year_max, $month) {
                $i->where('DEP_BUILDING_YEAR', '=', $year_max);
                $i->where('DEP_BUILDING_MONTH', '<', $month);
                $i->where('DEP_BUILDING_VALUE', '=', 1);
            })
            ->sum('DEP_BUILDING_CUMULATIVE');
        $sumbuilding5 = Assetdepreciatebuilding::leftJoin('asset_building', 'asset_depreciate_building.DEP_BUILDING_ASSET_ID', '=', 'asset_building.ID')
            ->leftJoin('supplies_decline', 'supplies_decline.DECLINE_ID', '=', 'asset_building.DECLINE_ID')
            ->where(function ($q) use ($year_max, $month) {
                $q->where('DEP_BUILDING_YEAR', '=', $year_max);
                $q->where('DEP_BUILDING_MONTH', '=', $month);
            })
            ->orwhere(function ($r) use ($year_max, $month) {
                $r->where('DEP_BUILDING_YEAR', '<', $year_max);
                $r->where('DEP_BUILDING_VALUE', '=', 1);
            })
            ->orwhere(function ($i) use ($year_max, $month) {
                $i->where('DEP_BUILDING_YEAR', '=', $year_max);
                $i->where('DEP_BUILDING_MONTH', '<', $month);
                $i->where('DEP_BUILDING_VALUE', '=', 1);
            })
            ->sum('DEP_BUILDING_VALUE');

        //==================================================================

        $depreciate = Assetdepreciate::leftJoin('asset_article', 'asset_depreciate.DEP_ASSET_ID', '=', 'asset_article.ARTICLE_ID')
            ->leftJoin('supplies_decline', 'supplies_decline.DECLINE_ID', '=', 'asset_article.DECLINE_ID')
            ->where(function ($q) use ($year_max, $month) {
                $q->where('DEP_YEAR', '=', $year_max);
                $q->where('DEP_MONTH', '=', $month);
            })
            ->orwhere(function ($r) use ($year_max, $month) {
                $r->where('DEP_YEAR', '<', $year_max);
                $r->where('DEP_VALUE', '=', 1);
            })
            ->orwhere(function ($i) use ($year_max, $month) {
                $i->where('DEP_YEAR', '=', $year_max);
                $i->where('DEP_MONTH', '<', $month);
                $i->where('DEP_VALUE', '=', 1);
            })
            ->get();

        //=========================ผลรวมครุภัณ
        $sumasset1 = Assetdepreciate::leftJoin('asset_article', 'asset_depreciate.DEP_ASSET_ID', '=', 'asset_article.ARTICLE_ID')
            ->leftJoin('supplies_decline', 'supplies_decline.DECLINE_ID', '=', 'asset_article.DECLINE_ID')
            ->where(function ($q) use ($year_max, $month) {
                $q->where('DEP_YEAR', '=', $year_max);
                $q->where('DEP_MONTH', '=', $month);
            })
            ->orwhere(function ($r) use ($year_max, $month) {
                $r->where('DEP_YEAR', '<', $year_max);
                $r->where('DEP_VALUE', '=', 1);
            })
            ->orwhere(function ($i) use ($year_max, $month) {
                $i->where('DEP_YEAR', '=', $year_max);
                $i->where('DEP_MONTH', '<', $month);
                $i->where('DEP_VALUE', '=', 1);
            })
            ->sum('DEP_PRICE');
        $sumasset2 = Assetdepreciate::leftJoin('asset_article', 'asset_depreciate.DEP_ASSET_ID', '=', 'asset_article.ARTICLE_ID')
            ->leftJoin('supplies_decline', 'supplies_decline.DECLINE_ID', '=', 'asset_article.DECLINE_ID')
            ->where(function ($q) use ($year_max, $month) {
                $q->where('DEP_YEAR', '=', $year_max);
                $q->where('DEP_MONTH', '=', $month);
            })
            ->orwhere(function ($r) use ($year_max, $month) {
                $r->where('DEP_YEAR', '<', $year_max);
                $r->where('DEP_VALUE', '=', 1);
            })
            ->orwhere(function ($i) use ($year_max, $month) {
                $i->where('DEP_YEAR', '=', $year_max);
                $i->where('DEP_MONTH', '<', $month);
                $i->where('DEP_VALUE', '=', 1);
            })
            ->sum('DEP_FORWARD');
        $sumasset3 = Assetdepreciate::leftJoin('asset_article', 'asset_depreciate.DEP_ASSET_ID', '=', 'asset_article.ARTICLE_ID')
            ->leftJoin('supplies_decline', 'supplies_decline.DECLINE_ID', '=', 'asset_article.DECLINE_ID')
            ->where(function ($q) use ($year_max, $month) {
                $q->where('DEP_YEAR', '=', $year_max);
                $q->where('DEP_MONTH', '=', $month);
            })
            ->orwhere(function ($r) use ($year_max, $month) {
                $r->where('DEP_YEAR', '<', $year_max);
                $r->where('DEP_VALUE', '=', 1);
            })
            ->orwhere(function ($i) use ($year_max, $month) {
                $i->where('DEP_YEAR', '=', $year_max);
                $i->where('DEP_MONTH', '<', $month);
                $i->where('DEP_VALUE', '=', 1);
            })
            ->sum('DEP_DEPRECIATE');
        $sumasset4 = Assetdepreciate::leftJoin('asset_article', 'asset_depreciate.DEP_ASSET_ID', '=', 'asset_article.ARTICLE_ID')
            ->leftJoin('supplies_decline', 'supplies_decline.DECLINE_ID', '=', 'asset_article.DECLINE_ID')
            ->where(function ($q) use ($year_max, $month) {
                $q->where('DEP_YEAR', '=', $year_max);
                $q->where('DEP_MONTH', '=', $month);
            })
            ->orwhere(function ($r) use ($year_max, $month) {
                $r->where('DEP_YEAR', '<', $year_max);
                $r->where('DEP_VALUE', '=', 1);
            })
            ->orwhere(function ($i) use ($year_max, $month) {
                $i->where('DEP_YEAR', '=', $year_max);
                $i->where('DEP_MONTH', '<', $month);
                $i->where('DEP_VALUE', '=', 1);
            })
            ->sum('DEP_CUMULATIVE');
        $sumasset5 = Assetdepreciate::leftJoin('asset_article', 'asset_depreciate.DEP_ASSET_ID', '=', 'asset_article.ARTICLE_ID')
            ->leftJoin('supplies_decline', 'supplies_decline.DECLINE_ID', '=', 'asset_article.DECLINE_ID')
            ->where('DEP_YEAR', '=', $year_max)
            ->where('DEP_MONTH', '=', $month)
            ->sum('DEP_VALUE');
        //==================================================================

        return view('manager_asset.assetinfocalculate', [
            'budgets'      => $budget,
            'depbuildings' => $depbuilding,
            'depreciates'  => $depreciate,
            'year_max'     => $year_max,
            'm_budget'     => $month,
            'sumbuilding1' => $sumbuilding1,
            'sumbuilding2' => $sumbuilding2,
            'sumbuilding3' => $sumbuilding3,
            'sumbuilding4' => $sumbuilding4,
            'sumbuilding5' => $sumbuilding5,
            'sumasset1'    => $sumasset1,
            'sumasset2'    => $sumasset2,
            'sumasset3'    => $sumasset3,
            'sumasset4'    => $sumasset4,
            'sumasset5'    => $sumasset5
        ]);
    }

    public function searchassetinfocalculate(Request $request)
    {
        
        $year_max = $request->get('YEAR_ID');
        $month    = $request->get('SEND_MONTH');

        $budget = DB::table('asset_article')
            ->select('YEAR_ID', DB::raw('count(*) as total'))
            ->groupBy('YEAR_ID')
            ->orderBy('YEAR_ID', 'desc')
            ->get();
        $depbuilding = Assetdepreciatebuilding::leftJoin('asset_building', 'asset_depreciate_building.DEP_BUILDING_ASSET_ID', '=', 'asset_building.ID')
            ->leftJoin('supplies_decline', 'supplies_decline.DECLINE_ID', '=', 'asset_building.DECLINE_ID')
            ->where(function ($q) use ($year_max, $month) {
                $q->where('DEP_BUILDING_YEAR', '=', $year_max);
                $q->where('DEP_BUILDING_MONTH', '=', $month);
            })
            ->orwhere(function ($r) use ($year_max, $month) {
                $r->where('DEP_BUILDING_YEAR', '<', $year_max);
                $r->where('DEP_BUILDING_VALUE', '=', 1);
            })
            ->orwhere(function ($i) use ($year_max, $month) {
                $i->where('DEP_BUILDING_YEAR', '=', $year_max);
                $i->where('DEP_BUILDING_MONTH', '<', $month);
                $i->where('DEP_BUILDING_VALUE', '=', 1);
            })
            ->get();
        //=========================ผลรวมอาคารสิ่งก่อสร้าง

        $sumbuilding1 = Assetdepreciatebuilding::leftJoin('asset_building', 'asset_depreciate_building.DEP_BUILDING_ASSET_ID', '=', 'asset_building.ID')
            ->leftJoin('supplies_decline', 'supplies_decline.DECLINE_ID', '=', 'asset_building.DECLINE_ID')
            ->where(function ($q) use ($year_max, $month) {
                $q->where('DEP_BUILDING_YEAR', '=', $year_max);
                $q->where('DEP_BUILDING_MONTH', '=', $month);
            })
            ->orwhere(function ($r) use ($year_max, $month) {
                $r->where('DEP_BUILDING_YEAR', '<', $year_max);
                $r->where('DEP_BUILDING_VALUE', '=', 1);
            })
            ->orwhere(function ($i) use ($year_max, $month) {
                $i->where('DEP_BUILDING_YEAR', '=', $year_max);
                $i->where('DEP_BUILDING_MONTH', '<', $month);
                $i->where('DEP_BUILDING_VALUE', '=', 1);
            })
            ->sum('DEP_BUILDING_PRICE');
        $sumbuilding2 = Assetdepreciatebuilding::leftJoin('asset_building', 'asset_depreciate_building.DEP_BUILDING_ASSET_ID', '=', 'asset_building.ID')
            ->leftJoin('supplies_decline', 'supplies_decline.DECLINE_ID', '=', 'asset_building.DECLINE_ID')
            ->where(function ($q) use ($year_max, $month) {
                $q->where('DEP_BUILDING_YEAR', '=', $year_max);
                $q->where('DEP_BUILDING_MONTH', '=', $month);
            })
            ->orwhere(function ($r) use ($year_max, $month) {
                $r->where('DEP_BUILDING_YEAR', '<', $year_max);
                $r->where('DEP_BUILDING_VALUE', '=', 1);
            })
            ->orwhere(function ($i) use ($year_max, $month) {
                $i->where('DEP_BUILDING_YEAR', '=', $year_max);
                $i->where('DEP_BUILDING_MONTH', '<', $month);
                $i->where('DEP_BUILDING_VALUE', '=', 1);
            })
            ->sum('DEP_BUILDING_FORWARD');
        $sumbuilding3 = Assetdepreciatebuilding::leftJoin('asset_building', 'asset_depreciate_building.DEP_BUILDING_ASSET_ID', '=', 'asset_building.ID')
            ->leftJoin('supplies_decline', 'supplies_decline.DECLINE_ID', '=', 'asset_building.DECLINE_ID')
            ->where(function ($q) use ($year_max, $month) {
                $q->where('DEP_BUILDING_YEAR', '=', $year_max);
                $q->where('DEP_BUILDING_MONTH', '=', $month);
            })
            ->orwhere(function ($r) use ($year_max, $month) {
                $r->where('DEP_BUILDING_YEAR', '<', $year_max);
                $r->where('DEP_BUILDING_VALUE', '=', 1);
            })
            ->orwhere(function ($i) use ($year_max, $month) {
                $i->where('DEP_BUILDING_YEAR', '=', $year_max);
                $i->where('DEP_BUILDING_MONTH', '<', $month);
                $i->where('DEP_BUILDING_VALUE', '=', 1);
            })
            ->sum('DEP_BUILDING_DEPRECIATE');
        $sumbuilding4 = Assetdepreciatebuilding::leftJoin('asset_building', 'asset_depreciate_building.DEP_BUILDING_ASSET_ID', '=', 'asset_building.ID')
            ->leftJoin('supplies_decline', 'supplies_decline.DECLINE_ID', '=', 'asset_building.DECLINE_ID')
            ->where(function ($q) use ($year_max, $month) {
                $q->where('DEP_BUILDING_YEAR', '=', $year_max);
                $q->where('DEP_BUILDING_MONTH', '=', $month);
            })
            ->orwhere(function ($r) use ($year_max, $month) {
                $r->where('DEP_BUILDING_YEAR', '<', $year_max);
                $r->where('DEP_BUILDING_VALUE', '=', 1);
            })
            ->orwhere(function ($i) use ($year_max, $month) {
                $i->where('DEP_BUILDING_YEAR', '=', $year_max);
                $i->where('DEP_BUILDING_MONTH', '<', $month);
                $i->where('DEP_BUILDING_VALUE', '=', 1);
            })
            ->sum('DEP_BUILDING_CUMULATIVE');
        $sumbuilding5 = Assetdepreciatebuilding::leftJoin('asset_building', 'asset_depreciate_building.DEP_BUILDING_ASSET_ID', '=', 'asset_building.ID')
            ->leftJoin('supplies_decline', 'supplies_decline.DECLINE_ID', '=', 'asset_building.DECLINE_ID')
            ->where(function ($q) use ($year_max, $month) {
                $q->where('DEP_BUILDING_YEAR', '=', $year_max);
                $q->where('DEP_BUILDING_MONTH', '=', $month);
            })
            ->orwhere(function ($r) use ($year_max, $month) {
                $r->where('DEP_BUILDING_YEAR', '<', $year_max);
                $r->where('DEP_BUILDING_VALUE', '=', 1);
            })
            ->orwhere(function ($i) use ($year_max, $month) {
                $i->where('DEP_BUILDING_YEAR', '=', $year_max);
                $i->where('DEP_BUILDING_MONTH', '<', $month);
                $i->where('DEP_BUILDING_VALUE', '=', 1);
            })
            ->sum('DEP_BUILDING_VALUE');

        //==================================================================

        $depreciate = Assetdepreciate::leftJoin('asset_article', 'asset_depreciate.DEP_ASSET_ID', '=', 'asset_article.ARTICLE_ID')
            ->leftJoin('supplies_decline', 'supplies_decline.DECLINE_ID', '=', 'asset_article.DECLINE_ID')
            ->where(function ($q) use ($year_max, $month) {
                $q->where('DEP_YEAR', '=', $year_max);
                $q->where('DEP_MONTH', '=', $month);
            })
            ->orwhere(function ($r) use ($year_max, $month) {
                $r->where('DEP_YEAR', '<', $year_max);
                $r->where('DEP_VALUE', '=', 1);
            })
            ->orwhere(function ($i) use ($year_max, $month) {
                $i->where('DEP_YEAR', '=', $year_max);
                $i->where('DEP_MONTH', '<', $month);
                $i->where('DEP_VALUE', '=', 1);
            })
            ->get();

        //=========================ผลรวมครุภัณ
        $sumasset1 = Assetdepreciate::leftJoin('asset_article', 'asset_depreciate.DEP_ASSET_ID', '=', 'asset_article.ARTICLE_ID')
            ->leftJoin('supplies_decline', 'supplies_decline.DECLINE_ID', '=', 'asset_article.DECLINE_ID')
            ->where(function ($q) use ($year_max, $month) {
                $q->where('DEP_YEAR', '=', $year_max);
                $q->where('DEP_MONTH', '=', $month);
            })
            ->orwhere(function ($r) use ($year_max, $month) {
                $r->where('DEP_YEAR', '<', $year_max);
                $r->where('DEP_VALUE', '=', 1);
            })
            ->orwhere(function ($i) use ($year_max, $month) {
                $i->where('DEP_YEAR', '=', $year_max);
                $i->where('DEP_MONTH', '<', $month);
                $i->where('DEP_VALUE', '=', 1);
            })
            ->sum('DEP_PRICE');
        $sumasset2 = Assetdepreciate::leftJoin('asset_article', 'asset_depreciate.DEP_ASSET_ID', '=', 'asset_article.ARTICLE_ID')
            ->leftJoin('supplies_decline', 'supplies_decline.DECLINE_ID', '=', 'asset_article.DECLINE_ID')
            ->where(function ($q) use ($year_max, $month) {
                $q->where('DEP_YEAR', '=', $year_max);
                $q->where('DEP_MONTH', '=', $month);
            })
            ->orwhere(function ($r) use ($year_max, $month) {
                $r->where('DEP_YEAR', '<', $year_max);
                $r->where('DEP_VALUE', '=', 1);
            })
            ->orwhere(function ($i) use ($year_max, $month) {
                $i->where('DEP_YEAR', '=', $year_max);
                $i->where('DEP_MONTH', '<', $month);
                $i->where('DEP_VALUE', '=', 1);
            })
            ->sum('DEP_FORWARD');
        $sumasset3 = Assetdepreciate::leftJoin('asset_article', 'asset_depreciate.DEP_ASSET_ID', '=', 'asset_article.ARTICLE_ID')
            ->leftJoin('supplies_decline', 'supplies_decline.DECLINE_ID', '=', 'asset_article.DECLINE_ID')
            ->where(function ($q) use ($year_max, $month) {
                $q->where('DEP_YEAR', '=', $year_max);
                $q->where('DEP_MONTH', '=', $month);
            })
            ->orwhere(function ($r) use ($year_max, $month) {
                $r->where('DEP_YEAR', '<', $year_max);
                $r->where('DEP_VALUE', '=', 1);
            })
            ->orwhere(function ($i) use ($year_max, $month) {
                $i->where('DEP_YEAR', '=', $year_max);
                $i->where('DEP_MONTH', '<', $month);
                $i->where('DEP_VALUE', '=', 1);
            })
            ->sum('DEP_DEPRECIATE');
        $sumasset4 = Assetdepreciate::leftJoin('asset_article', 'asset_depreciate.DEP_ASSET_ID', '=', 'asset_article.ARTICLE_ID')
            ->leftJoin('supplies_decline', 'supplies_decline.DECLINE_ID', '=', 'asset_article.DECLINE_ID')
            ->where(function ($q) use ($year_max, $month) {
                $q->where('DEP_YEAR', '=', $year_max);
                $q->where('DEP_MONTH', '=', $month);
            })
            ->orwhere(function ($r) use ($year_max, $month) {
                $r->where('DEP_YEAR', '<', $year_max);
                $r->where('DEP_VALUE', '=', 1);
            })
            ->orwhere(function ($i) use ($year_max, $month) {
                $i->where('DEP_YEAR', '=', $year_max);
                $i->where('DEP_MONTH', '<', $month);
                $i->where('DEP_VALUE', '=', 1);
            })
            ->sum('DEP_CUMULATIVE');
        $sumasset5 = Assetdepreciate::leftJoin('asset_article', 'asset_depreciate.DEP_ASSET_ID', '=', 'asset_article.ARTICLE_ID')
            ->leftJoin('supplies_decline', 'supplies_decline.DECLINE_ID', '=', 'asset_article.DECLINE_ID')
            ->where('DEP_YEAR', '=', $year_max)
            ->where('DEP_MONTH', '=', $month)
            ->sum('DEP_VALUE');
        //==================================================================

        return view('manager_asset.assetinfocalculate', [
            'budgets'      => $budget,
            'depbuildings' => $depbuilding,
            'depreciates'  => $depreciate,
            'year_max'     => $year_max,
            'm_budget'     => $month,
            'sumbuilding1' => $sumbuilding1,
            'sumbuilding2' => $sumbuilding2,
            'sumbuilding3' => $sumbuilding3,
            'sumbuilding4' => $sumbuilding4,
            'sumbuilding5' => $sumbuilding5,
            'sumasset1'    => $sumasset1,
            'sumasset2'    => $sumasset2,
            'sumasset3'    => $sumasset3,
            'sumasset4'    => $sumasset4,
            'sumasset5'    => $sumasset5
        ]);
    }

    //===========================ทดสอบคำนวณค่าเสื่อม======================================

    public function assetinfotestcal()
    {

        return view('manager_asset.assetinfotestcal');
    }

    public function assetinfocalallbuilding()
    {

        $depbuilding = Assetbuilding::get();

        return view('manager_asset.assetinfocalallbuilding', [
            'depbuildings' => $depbuilding

        ]);
    }

    public function assetinfocalall()
    {

        $asset = Assetarticle::get();

        return view('manager_asset.assetinfocalall', [
            'assets' => $asset

        ]);
    }

    //---สูตรคำนวนอาคาร
    public static function calallbuilding($id)
    {
        $building = DB::table('asset_building')->where('ID', '=', $id)->first();

        $depreciation = DB::table('supplies_decline')->where('supplies_decline.DECLINE_ID', '=', $building->DECLINE_ID)->first();
        $start        = $month        = strtotime($building->BUILD_CREATE . ' + 1 month');
        $yearend      = date("Y", strtotime($building->BUILD_CREATE)) + 60;

        $dateend = $yearend . '-01-01';

        $end = strtotime($dateend);

        //--------------------------------สูตรคำนวน-----------------------------------------------
        $PICE              = $building->BUILD_NGUD_MONEY;
        $per_year          = $depreciation->DECLINE_PERSEN;
        $Depreciation_mont = ($PICE * ($per_year / 100)) / 12;

        $checkdep = Assetdepreciatebuilding::where('DEP_BUILDING_ASSET_ID', '=', $id)->count();

        //-------------------------คำนวณเดือนแรก----------------------------

        $fristYear  = date("Y", strtotime($building->BUILD_CREATE)) + 543;
        $fristMonth = date("m", strtotime($building->BUILD_CREATE));
        $fristdate  = date("d", strtotime($building->BUILD_CREATE));

        if ($fristMonth == '04' || $fristMonth == '06' || $fristMonth == '09' || $fristMonth == '11') {
            $d = 30;
        } elseif ($fristMonth == '02') {
            if (($fristYear - 543) % 4 == 0) {
                $d = 29;
            } else {
                $d = 28;
            }

        } else {
            $d = 31;
        }

        $amountdate = $d - $fristdate;
        $Depdate    = $Depreciation_mont / $d;

        $fristDepreciation_mont = $amountdate * $Depdate;

        $fristDepreciation = $PICE - $fristDepreciation_mont;

        //-------------เพิ่มข้อมูลในตาราง----------------------------
        if ($checkdep == 0) {
            $adddepreciatebuilding                          = new Assetdepreciatebuilding();
            $adddepreciatebuilding->DEP_BUILDING_ASSET_ID   = $id;
            $adddepreciatebuilding->DEP_BUILDING_YEAR       = $fristYear;
            $adddepreciatebuilding->DEP_BUILDING_MONTH      = number_format($fristMonth);
            $adddepreciatebuilding->DEP_BUILDING_PRICE      = $PICE;
            $adddepreciatebuilding->DEP_BUILDING_FORWARD    = 0;
            $adddepreciatebuilding->DEP_BUILDING_DEPRECIATE = $fristDepreciation_mont;
            $adddepreciatebuilding->DEP_BUILDING_CUMULATIVE = $fristDepreciation_mont;
            $adddepreciatebuilding->DEP_BUILDING_VALUE      = $fristDepreciation;
            $adddepreciatebuilding->save();

        }

        $Depreciation_move = $fristDepreciation_mont;
        $Depreciation      = $Depreciation_mont + $Depreciation_move;

        while ($month < $end) {

            $year = date('Y', $month) + 543;

            $value_last = ($PICE - $Depreciation_move) - 1; //-----ตัวตัดค่าเสื่อมตัวสุดท้าย

            $value = $PICE - $Depreciation;

            if ($value <= 0) {
                $Depreciation_mont = $value_last;
                $Depreciation      = $Depreciation_move + $Depreciation_mont;
                $value             = 1;

            }

            //-------------เพิ่มข้อมูลในตาราง----------------------------
            if ($checkdep == 0) {
                $adddepreciatebuilding                          = new Assetdepreciatebuilding();
                $adddepreciatebuilding->DEP_BUILDING_ASSET_ID   = $id;
                $adddepreciatebuilding->DEP_BUILDING_YEAR       = $year;
                $adddepreciatebuilding->DEP_BUILDING_MONTH      = number_format(date('m', $month));
                $adddepreciatebuilding->DEP_BUILDING_PRICE      = $PICE;
                $adddepreciatebuilding->DEP_BUILDING_FORWARD    = $Depreciation_move;
                $adddepreciatebuilding->DEP_BUILDING_DEPRECIATE = $Depreciation_mont;
                $adddepreciatebuilding->DEP_BUILDING_CUMULATIVE = $Depreciation;
                $adddepreciatebuilding->DEP_BUILDING_VALUE      = $value;
                $adddepreciatebuilding->save();
            }
            //------------------------------------------

            if ($value == 1) {
                break;
            }
            $Depreciation = $Depreciation_mont + $Depreciation;

            $Depreciation_move = $Depreciation - $Depreciation_mont;

            $month = strtotime("+1 month", $month);

        }

    }

    public static function calallasset($id)
    {

        $infoasset = Assetarticle::where('asset_article.ARTICLE_ID', '=', $id)
            ->leftJoin('supplies_decline', 'supplies_decline.DECLINE_ID', '=', 'asset_article.DECLINE_ID')
            ->leftJoin('hrd_department_sub_sub', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID', '=', 'asset_article.DEP_ID')
            ->leftJoin('supplies_location', 'supplies_location.LOCATION_ID', '=', 'asset_article.LOCATION_ID')
            ->leftJoin('supplies_location_level', 'supplies_location_level.LOCATION_LEVEL_ID', '=', 'asset_article.LOCATION_LEVEL_ID')
            ->leftJoin('supplies_location_level_room', 'supplies_location_level_room.LEVEL_ROOM_ID', '=', 'asset_article.LEVEL_ROOM_ID')
            ->first();

        $depreciation = DB::table('supplies_decline')->where('supplies_decline.DECLINE_ID', '=', $infoasset->DECLINE_ID)->first();

        $start = $month = strtotime($infoasset->RECEIVE_DATE . ' + 1 month');

        $yearend = date("Y", strtotime($infoasset->RECEIVE_DATE)) + 60;

        $dateend = $yearend . '-01-01';

        $end = strtotime($dateend);

        //=========================

        //--------------------------------สูตรคำนวน-----------------------------------------------
        $PICE              = $infoasset->PRICE_PER_UNIT;
        $per_year          = $depreciation->DECLINE_PERSEN;
        $Depreciation_mont = ($PICE * ($per_year / 100)) / 12;

        $checkdep = Assetdepreciate::where('DEP_ASSET_ID', '=', $id)->count();
        //-------------------------คำนวณเดือนแรก----------------------------

        $fristYear  = date("Y", strtotime($infoasset->RECEIVE_DATE)) + 543;
        $fristMonth = date("m", strtotime($infoasset->RECEIVE_DATE));
        $fristdate  = date("d", strtotime($infoasset->RECEIVE_DATE));

        if ($fristMonth == '04' || $fristMonth == '06' || $fristMonth == '09' || $fristMonth == '11') {
            $d = 30;
        } elseif ($fristMonth == '02') {
            if (($fristYear - 543) % 4 == 0) {
                $d = 29;
            } else {
                $d = 28;
            }

        } else {
            $d = 31;
        }

        $amountdate = $d - $fristdate;
        $Depdate    = $Depreciation_mont / $d;

        $fristDepreciation_mont = $amountdate * $Depdate;

        $fristDepreciation = $PICE - $fristDepreciation_mont;

        //-------------เพิ่มข้อมูลในตาราง----------------------------
        if ($checkdep == 0) {
            $adddepreciate                 = new Assetdepreciate();
            $adddepreciate->DEP_ASSET_ID   = $id;
            $adddepreciate->DEP_YEAR       = $fristYear;
            $adddepreciate->DEP_MONTH      = number_format($fristMonth);
            $adddepreciate->DEP_PRICE      = $PICE;
            $adddepreciate->DEP_FORWARD    = 0;
            $adddepreciate->DEP_DEPRECIATE = $fristDepreciation_mont;
            $adddepreciate->DEP_CUMULATIVE = $fristDepreciation_mont;
            $adddepreciate->DEP_VALUE      = $fristDepreciation;
            $adddepreciate->save();

        } //------------------------------------------

        //----------------------------------------------------

        $Depreciation_move = $fristDepreciation_mont;
        $Depreciation      = $Depreciation_mont + $Depreciation_move;

        while ($month < $end) {

            $year = date('Y', $month) + 543;

            $value_last = ($PICE - $Depreciation_move) - 1; //-----ตัวตัดค่าเสื่อมตัวสุดท้าย

            $value = $PICE - $Depreciation;

            if ($value <= 0) {
                $Depreciation_mont = $value_last;
                $Depreciation      = $Depreciation_move + $Depreciation_mont;
                $value             = 1;

            }

            //-------------เพิ่มข้อมูลในตาราง----------------------------
            if ($checkdep == 0) {
                $adddepreciate                 = new Assetdepreciate();
                $adddepreciate->DEP_ASSET_ID   = $id;
                $adddepreciate->DEP_YEAR       = $year;
                $adddepreciate->DEP_MONTH      = number_format(date('m', $month));
                $adddepreciate->DEP_PRICE      = $PICE;
                $adddepreciate->DEP_FORWARD    = $Depreciation_move;
                $adddepreciate->DEP_DEPRECIATE = $Depreciation_mont;
                $adddepreciate->DEP_CUMULATIVE = $Depreciation;
                $adddepreciate->DEP_VALUE      = $value;
                $adddepreciate->save();
            }
            //------------------------------------------

            if ($value == 1) {
                break;
            }
            $Depreciation = $Depreciation_mont + $Depreciation;

            $Depreciation_move = $Depreciation - $Depreciation_mont;

            $month = strtotime("+1 month", $month);

        }

    }

    //=============================================เบิกจ่าย

    public function assetinfodisburse(Request $request)
    {
        if(!empty($request->_token)){
            $search     = $request->get('search');
            $status     = $request->SEND_STATUS;
            $datebigin  = $request->get('DATE_BIGIN');
            $dateend    = $request->get('DATE_END');
            $yearbudget = $request->BUDGET_YEAR;
            session([
                'manager_asset.assetinfodisburse.search' => $search,
                'manager_asset.assetinfodisburse.status' => $status,
                'manager_asset.assetinfodisburse.datebigin' => $datebigin,
                'manager_asset.assetinfodisburse.dateend' => $dateend,
                'manager_asset.assetinfodisburse.yearbudget' => $yearbudget
                ]);
        }elseif(!empty(session('manager_asset.assetinfodisburse'))){
            $search     = session('manager_asset.assetinfodisburse.search');
            $status     = session('manager_asset.assetinfodisburse.status');
            $datebigin  = session('manager_asset.assetinfodisburse.datebigin');
            $dateend    = session('manager_asset.assetinfodisburse.dateend');
            $yearbudget = session('manager_asset.assetinfodisburse.yearbudget');
        }else{
            $search     = '';
            $status     = '';
            $datebigin = date('1/m/Y');
            $dateend   = date('d/m/Y', strtotime(date('Y-m-1'). '+1month -1days'));
            $yearbudget = getBudgetyear();
        }


        $date_bigen_c = Carbon::createFromFormat('d/m/Y', $datebigin)->format('Y-m-d');
        $date_arrary  = explode("-", $date_bigen_c);

        $y_sub_st = $date_arrary[0];

        if ($y_sub_st >= 2500) {
            $y = $y_sub_st - 543;
        } else {
            $y = $y_sub_st;
        }

        $m                 = $date_arrary[1];
        $d                 = $date_arrary[2];
        $displaydate_bigen = $y . "-" . $m . "-" . $d;

        $date_end_c    = Carbon::createFromFormat('d/m/Y', $dateend)->format('Y-m-d');
        $date_arrary_e = explode("-", $date_end_c);

        $y_sub_e = $date_arrary_e[0];

        if ($y_sub_e >= 2500) {
            $y_e = $y_sub_e - 543;
        } else {
            $y_e = $y_sub_e;
        }
        $m_e               = $date_arrary_e[1];
        $d_e               = $date_arrary_e[2];
        $displaydate_end   = $y_e . "-" . $m_e . "-" . $d_e;
        $date              = date('Y-m-d');
        $date_bigen_checks = strtotime($displaydate_bigen);
        $date_end_checks   = strtotime($displaydate_end);
        $dates             = strtotime($date);

        $from = date($displaydate_bigen);
        $to   = date($displaydate_end);

        if ($status == null) {

            $inforequest = DB::table('asset_request')
                ->where(function ($q) use ($search) {
                    $q->where('REQUEST_FOR', 'like', '%' . $search . '%');
                    $q->orwhere('BILL_NUMBER', 'like', '%' . $search . '%');
                    $q->orwhere('DEP_SUB_SUB_NAME', 'like', '%' . $search . '%');
                })
                ->WhereBetween('DATE_TIME_SAVE', [$from, $to])
                ->orderBy('asset_request.ID', 'desc')
                ->get();
        } else {

            $inforequest = DB::table('asset_request')
                ->where('STATUS', '=', $status)
                ->where(function ($q) use ($search) {
                    $q->where('REQUEST_FOR', 'like', '%' . $search . '%');
                    $q->orwhere('BILL_NUMBER', 'like', '%' . $search . '%');
                    $q->orwhere('DEP_SUB_SUB_NAME', 'like', '%' . $search . '%');
                })
                ->WhereBetween('DATE_TIME_SAVE', [$from, $to])
                ->orderBy('asset_request.ID', 'desc')
                ->get();
        }

        $info_sendstatus = DB::table('asset_status_app')->get();

        $budget  = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $year_id = $yearbudget;

        return view('manager_asset.assetinfodisburse', [
            'inforequests'      => $inforequest,
            'info_sendstatuss'  => $info_sendstatus,
            'budgets'           => $budget,
            'displaydate_bigen' => $displaydate_bigen,
            'displaydate_end'   => $displaydate_end,
            'status_check'      => $status,
            'search'            => $search,
            'year_id'           => $year_id
        ]);

    }

    //=============================================เบิกจ่าย ค้นหา

    public function searchdisburse(Request $request)
    {

        $search     = $request->get('search');
        $status     = $request->SEND_STATUS;
        $datebigin  = $request->get('DATE_BIGIN');
        $dateend    = $request->get('DATE_END');
        $yearbudget = $request->BUDGET_YEAR;

        if ($search == '') {
            $search = "";
        }

        $date_bigen_c = Carbon::createFromFormat('d/m/Y', $datebigin)->format('Y-m-d');
        $date_arrary  = explode("-", $date_bigen_c);

        $y_sub_st = $date_arrary[0];

        if ($y_sub_st >= 2500) {
            $y = $y_sub_st - 543;
        } else {
            $y = $y_sub_st;
        }

        $m                 = $date_arrary[1];
        $d                 = $date_arrary[2];
        $displaydate_bigen = $y . "-" . $m . "-" . $d;

        $date_end_c    = Carbon::createFromFormat('d/m/Y', $dateend)->format('Y-m-d');
        $date_arrary_e = explode("-", $date_end_c);

        $y_sub_e = $date_arrary_e[0];

        if ($y_sub_e >= 2500) {
            $y_e = $y_sub_e - 543;
        } else {
            $y_e = $y_sub_e;
        }
        $m_e               = $date_arrary_e[1];
        $d_e               = $date_arrary_e[2];
        $displaydate_end   = $y_e . "-" . $m_e . "-" . $d_e;
        $date              = date('Y-m-d');
        $date_bigen_checks = strtotime($displaydate_bigen);
        $date_end_checks   = strtotime($displaydate_end);
        $dates             = strtotime($date);

        $from = date($displaydate_bigen);
        $to   = date($displaydate_end);

        if ($status == null) {

            $inforequest = DB::table('asset_request')
                ->where(function ($q) use ($search) {
                    $q->where('REQUEST_FOR', 'like', '%' . $search . '%');
                    $q->orwhere('BILL_NUMBER', 'like', '%' . $search . '%');
                    $q->orwhere('DEP_SUB_SUB_NAME', 'like', '%' . $search . '%');
                })
                ->WhereBetween('DATE_TIME_SAVE', [$from, $to])
                ->orderBy('asset_request.ID', 'desc')
                ->get();
        } else {

            $inforequest = DB::table('asset_request')
                ->where('STATUS', '=', $status)
                ->where(function ($q) use ($search) {
                    $q->where('REQUEST_FOR', 'like', '%' . $search . '%');
                    $q->orwhere('BILL_NUMBER', 'like', '%' . $search . '%');
                    $q->orwhere('DEP_SUB_SUB_NAME', 'like', '%' . $search . '%');
                })
                ->WhereBetween('DATE_TIME_SAVE', [$from, $to])
                ->orderBy('asset_request.ID', 'desc')
                ->get();
        }

        $info_sendstatus = DB::table('asset_status_app')->get();

        $budget  = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $year_id = $yearbudget;

        return view('manager_asset.assetinfodisburse', [
            'inforequests'      => $inforequest,
            'info_sendstatuss'  => $info_sendstatus,
            'budgets'           => $budget,
            'displaydate_bigen' => $displaydate_bigen,
            'displaydate_end'   => $displaydate_end,
            'status_check'      => $status,
            'search'            => $search,
            'year_id'           => $year_id
        ]);

    }

    //==============================รายละเอียดแก้ไข

    public function assetinfodisburseedit(Request $request, $id)
    {
        $infoassetrequest = Assetrequest::where('ID', '=', $id)->first();

        $inforequestasset = DB::table('asset_article')->where('DEP_ID', '=', $infoassetrequest->DEP_SUB_SUB_ID)->get();

        $budgetyear = DB::table('budget_year')->where('ACTIVE', '=', 'True')->get();

        $infoassetrequest    = Assetrequest::where('ID', '=', $id)->first();
        $infoassetrequestsub = Assetrequestsub::where('ASSET_REQUEST_ID', '=', $id)->get();
        $countchack          = Assetrequestsub::where('ASSET_REQUEST_ID', '=', $id)->count();

        return view('manager_asset.assetinfodisburseedit', [
            'inforequestassets'    => $inforequestasset,
            'budgetyears'          => $budgetyear,
            'infoassetrequest'     => $infoassetrequest,
            'infoassetrequestsubs' => $infoassetrequestsub,
            'countchack'           => $countchack

        ]);

    }

    public function assetinfodisburseupdate(Request $request)
    {

        $request->validate([
            'YEAR_ID'     => 'required',
            'BILL_NUMBER' => 'required',
            'DATE_WANT'   => 'required',
            'DATE_OPEN'   => 'required'
        ]);

        $id        = $request->ID;
        $DATE_WANT = $request->DATE_WANT;
        $DATE_OPEN = $request->DATE_OPEN;

        if ($DATE_WANT != '') {
            $STARTDAY       = Carbon::createFromFormat('d/m/Y', $DATE_WANT)->format('Y-m-d');
            $date_arrary_st = explode("-", $STARTDAY);
            $y_sub_st       = $date_arrary_st[0];

            if ($y_sub_st >= 2500) {
                $y_st = $y_sub_st - 543;
            } else {
                $y_st = $y_sub_st;
            }
            $m_st     = $date_arrary_st[1];
            $d_st     = $date_arrary_st[2];
            $DATEWANT = $y_st . "-" . $m_st . "-" . $d_st;
        } else {
            $DATEWANT = null;
        }

        if ($DATE_OPEN != '') {
            $STARTDAY       = Carbon::createFromFormat('d/m/Y', $DATE_OPEN)->format('Y-m-d');
            $date_arrary_st = explode("-", $STARTDAY);
            $y_sub_st       = $date_arrary_st[0];

            if ($y_sub_st >= 2500) {
                $y_st = $y_sub_st - 543;
            } else {
                $y_st = $y_sub_st;
            }
            $m_st     = $date_arrary_st[1];
            $d_st     = $date_arrary_st[2];
            $DATEOPEN = $y_st . "-" . $m_st . "-" . $d_st;
        } else {
            $DATEOPEN = null;
        }

        $addassetrequest = Assetrequest::find($id);

        $addassetrequest->YEAR_ID     = $request->YEAR_ID;
        $addassetrequest->BILL_NUMBER = $request->BILL_NUMBER;
        $addassetrequest->REQUEST_FOR = $request->REQUEST_FOR;

        $addassetrequest->DATE_WANT = $DATEWANT;
        $addassetrequest->DATE_OPEN = $DATEOPEN;

        $addassetrequest->DATE_TIME_SAVE = date('Y-m-d H:i:s');
        $addassetrequest->save();

        $ASSET_REQUEST_ID = $id;

        Assetrequestsub::where('ASSET_REQUEST_ID', '=', $id)->delete();
        if ($request->ASSET_REQUEST_SUB_ARTICLE_ID[0] != '' || $request->ASSET_REQUEST_SUB_ARTICLE_ID[0] != null) {
            $ASSET_REQUEST_SUB_ARTICLE_ID = $request->ASSET_REQUEST_SUB_ARTICLE_ID;
            $number                       = count($ASSET_REQUEST_SUB_ARTICLE_ID);
            $count                        = 0;
            for ($count = 0; $count < $number; $count++) {

                $add                               = new Assetrequestsub();
                $add->ASSET_REQUEST_ID             = $ASSET_REQUEST_ID;
                $add->ASSET_REQUEST_SUB_ARTICLE_ID = $ASSET_REQUEST_SUB_ARTICLE_ID[$count];

                $infoasset = DB::table('asset_article')->where('ARTICLE_ID', '=', $ASSET_REQUEST_SUB_ARTICLE_ID[$count])->first();

                $add->ASSET_REQUEST_SUB_NUMBER = $infoasset->ARTICLE_NUM;
                $add->ASSET_REQUEST_SUB_DETAIL = $infoasset->ARTICLE_NAME;
                $add->ASSET_REQUEST_SUB_UNIT   = $infoasset->UNIT_ID;
                $add->ASSET_REQUEST_SUB_PRICE  = $infoasset->PRICE_PER_UNIT;

                $add->save();

            }
        }

        return response()->json([
            'status' => 1,
            'url'    => url('manager_asset/assetinfodisburse')
        ]);
    }

//--------------------------แจ้งยกเลิก-----

    public function canceldisburseassetinfo(Request $request, $id)
    {

        $infoassetrequest    = Assetrequest::where('ID', '=', $id)->first();
        $infoassetrequestsub = Assetrequestsub::where('ASSET_REQUEST_ID', '=', $id)->get();

        return view('manager_asset.assetinfodisbursecancel', [
            'infoassetrequest'     => $infoassetrequest,
            'infoassetrequestsubs' => $infoassetrequestsub

        ]);

    }

    public function canceldisburseassetinfoupdate(Request $request)
    {
        $id     = $request->ID;
        $iduser = $request->iduser;

        $updateapp         = Assetrequest::find($id);
        $updateapp->STATUS = 'CANCEL';
        $updateapp->save();

        return redirect()->route('massete.assetinfodisburse');

    }

    //=======================================================

    public function assetinfodisburseapproval(Request $request, $id)
    {

        $inforequest = DB::table('asset_request')->where('ID', '=', $id)->first();
        $imgperson   = DB::table('hrd_person')->where('ID', '=', $inforequest->SAVE_HR_ID)->first();

        $infoassetrequest = DB::table('asset_request_sub')->where('ASSET_REQUEST_ID', '=', $inforequest->ID)->get();

        return view('manager_asset.assetinfodisburseapproval', [
            'id'                => $id,
            'inforequest'       => $inforequest,
            'imgperson'         => $imgperson,
            'infoassetrequests' => $infoassetrequest

        ]);

    }

    public function updatedisburseapp(Request $request)
    {

        $id = $request->ID;

        $check = $request->SUBMIT;

        if ($check == 'approved') {
            $updateapp         = Assetrequest::find($id);
            $updateapp->STATUS = 'APPROVE';
            $updateapp->save();

            $infoassetrequest = DB::table('asset_request_sub')->where('ASSET_REQUEST_ID', '=', $id)->get();

            foreach ($infoassetrequest as $request) {

                $idarticle = $request->ASSET_REQUEST_SUB_ARTICLE_ID;

                $updateopen        = Assetarticle::find($idarticle);
                $updateopen->OPENS = 'True';
                $updateopen->save();

            }

        } else {
            $updateapp         = Assetrequest::find($id);
            $updateapp->STATUS = 'NOTAPPROVE';
            $updateapp->save();

            $infoassetrequest = DB::table('asset_request_sub')->where('ASSET_REQUEST_ID', '=', $id)->get();

            foreach ($infoassetrequest as $request) {

                $idarticle = $request->ASSET_REQUEST_SUB_ARTICLE_ID;

                $updateopen        = Assetarticle::find($idarticle);
                $updateopen->OPENS = 'False';
                $updateopen->save();

            }
        }

        return redirect()->route('massete.assetinfodisburse');

    }

    public function disburseapprovaldestroy($id, $idlist)
    {

        Assetrequestsub::destroy($idlist);
        return redirect()->route('massete.assetinfodisburseapproval', ['id' => $id]);
    }

    //=============================================ยืมคืน

    public function assetinfolend(Request $request)
    {
        if(!empty($request->_token)){
            $search     = $request->get('search');
            $status     = $request->SEND_STATUS;
            $datebigin  = $request->get('DATE_BIGIN');
            $dateend    = $request->get('DATE_END');
            $yearbudget = $request->BUDGET_YEAR;
            session([
                'manager_asset.assetinfolend.search' => $search,
                'manager_asset.assetinfolend.status' => $status,
                'manager_asset.assetinfolend.datebigin' => $datebigin,
                'manager_asset.assetinfolend.dateend' => $dateend,
                'manager_asset.assetinfolend.yearbudget' => $yearbudget
                ]);
        }elseif(!empty(session('manager_asset.assetinfolend'))){
            $search     = session('manager_asset.assetinfolend.search');
            $status     = session('manager_asset.assetinfolend.status');
            $datebigin  = session('manager_asset.assetinfolend.datebigin');
            $dateend    = session('manager_asset.assetinfolend.dateend');
            $yearbudget = session('manager_asset.assetinfolend.yearbudget');
        }else{
            $search     = '';
            $status     = '';
            $datebigin = date('1/m/Y');
            $dateend   = date('d/m/Y', strtotime(date('Y-m-1'). '+1month -1days'));
            $yearbudget = getBudgetyear();
        }

        $date_bigen_c = Carbon::createFromFormat('d/m/Y', $datebigin)->format('Y-m-d');
        $date_arrary  = explode("-", $date_bigen_c);

        $y_sub_st = $date_arrary[0];

        if ($y_sub_st >= 2500) {
            $y = $y_sub_st - 543;
        } else {
            $y = $y_sub_st;
        }

        $m                 = $date_arrary[1];
        $d                 = $date_arrary[2];
        $displaydate_bigen = $y . "-" . $m . "-" . $d;

        $date_end_c    = Carbon::createFromFormat('d/m/Y', $dateend)->format('Y-m-d');
        $date_arrary_e = explode("-", $date_end_c);

        $y_sub_e = $date_arrary_e[0];

        if ($y_sub_e >= 2500) {
            $y_e = $y_sub_e - 543;
        } else {
            $y_e = $y_sub_e;
        }
        $m_e               = $date_arrary_e[1];
        $d_e               = $date_arrary_e[2];
        $displaydate_end   = $y_e . "-" . $m_e . "-" . $d_e;
        $date              = date('Y-m-d');
        $date_bigen_checks = strtotime($displaydate_bigen);
        $date_end_checks   = strtotime($displaydate_end);
        $dates             = strtotime($date);

        $from = date($displaydate_bigen);
        $to   = date($displaydate_end);

        if ($status == null) {

            $inforequest = DB::table('asset_request_lend')
                ->where(function ($q) use ($search) {
                    $q->where('REQUEST_FOR', 'like', '%' . $search . '%');
                    $q->orwhere('GIVE_DEP_SUB_SUB_NAME', 'like', '%' . $search . '%');
                    $q->orwhere('DEP_SUB_SUB_NAME', 'like', '%' . $search . '%');
                    $q->orwhere('SAVE_HR_NAME', 'like', '%' . $search . '%');
                })
                ->WhereBetween('DATE_TIME_SAVE', [$from, $to])
                ->orderBy('asset_request_lend.ID', 'desc')
                ->get();
        } else {

            $inforequest = DB::table('asset_request_lend')
                ->where('STATUS', '=', $status)
                ->where(function ($q) use ($search) {
                    $q->where('REQUEST_FOR', 'like', '%' . $search . '%');
                    $q->orwhere('GIVE_DEP_SUB_SUB_NAME', 'like', '%' . $search . '%');
                    $q->orwhere('DEP_SUB_SUB_NAME', 'like', '%' . $search . '%');
                    $q->orwhere('SAVE_HR_NAME', 'like', '%' . $search . '%');
                })
                ->WhereBetween('DATE_TIME_SAVE', [$from, $to])
                ->orderBy('asset_request_lend.ID', 'desc')
                ->get();
        }

        $budget  = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $year_id = $yearbudget;

        $info_sendstatus = DB::table('asset_status_app')->get();

        return view('manager_asset.assetinfolend', [
            'inforequests'      => $inforequest,
            'info_sendstatuss'  => $info_sendstatus,
            'budgets'           => $budget,
            'displaydate_bigen' => $displaydate_bigen,
            'displaydate_end'   => $displaydate_end,
            'status_check'      => $status,
            'search'            => $search,
            'year_id'           => $year_id
        ]);
    }

//====================ค้นหา=====================

    public function searchinfolend(Request $request)
    {

        $search     = $request->get('search');
        $status     = $request->SEND_STATUS;
        $datebigin  = $request->get('DATE_BIGIN');
        $dateend    = $request->get('DATE_END');
        $yearbudget = $request->BUDGET_YEAR;

        if ($search == '') {
            $search = "";
        }

        $date_bigen_c = Carbon::createFromFormat('d/m/Y', $datebigin)->format('Y-m-d');
        $date_arrary  = explode("-", $date_bigen_c);

        $y_sub_st = $date_arrary[0];

        if ($y_sub_st >= 2500) {
            $y = $y_sub_st - 543;
        } else {
            $y = $y_sub_st;
        }

        $m                 = $date_arrary[1];
        $d                 = $date_arrary[2];
        $displaydate_bigen = $y . "-" . $m . "-" . $d;

        $date_end_c    = Carbon::createFromFormat('d/m/Y', $dateend)->format('Y-m-d');
        $date_arrary_e = explode("-", $date_end_c);

        $y_sub_e = $date_arrary_e[0];

        if ($y_sub_e >= 2500) {
            $y_e = $y_sub_e - 543;
        } else {
            $y_e = $y_sub_e;
        }
        $m_e               = $date_arrary_e[1];
        $d_e               = $date_arrary_e[2];
        $displaydate_end   = $y_e . "-" . $m_e . "-" . $d_e;
        $date              = date('Y-m-d');
        $date_bigen_checks = strtotime($displaydate_bigen);
        $date_end_checks   = strtotime($displaydate_end);
        $dates             = strtotime($date);

        $from = date($displaydate_bigen);
        $to   = date($displaydate_end);

        if ($status == null) {

            $inforequest = DB::table('asset_request_lend')
                ->where(function ($q) use ($search) {
                    $q->where('REQUEST_FOR', 'like', '%' . $search . '%');
                    $q->orwhere('GIVE_DEP_SUB_SUB_NAME', 'like', '%' . $search . '%');
                    $q->orwhere('DEP_SUB_SUB_NAME', 'like', '%' . $search . '%');
                    $q->orwhere('SAVE_HR_NAME', 'like', '%' . $search . '%');
                })
                ->WhereBetween('DATE_TIME_SAVE', [$from, $to])
                ->orderBy('asset_request_lend.ID', 'desc')
                ->get();
        } else {

            $inforequest = DB::table('asset_request_lend')
                ->where('STATUS', '=', $status)
                ->where(function ($q) use ($search) {
                    $q->where('REQUEST_FOR', 'like', '%' . $search . '%');
                    $q->orwhere('GIVE_DEP_SUB_SUB_NAME', 'like', '%' . $search . '%');
                    $q->orwhere('DEP_SUB_SUB_NAME', 'like', '%' . $search . '%');
                    $q->orwhere('SAVE_HR_NAME', 'like', '%' . $search . '%');
                })
                ->WhereBetween('DATE_TIME_SAVE', [$from, $to])
                ->orderBy('asset_request_lend.ID', 'desc')
                ->get();
        }

        $budget  = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $year_id = $yearbudget;

        $info_sendstatus = DB::table('asset_status_app')->get();

        return view('manager_asset.assetinfolend', [
            'inforequests'      => $inforequest,
            'info_sendstatuss'  => $info_sendstatus,
            'budgets'           => $budget,
            'displaydate_bigen' => $displaydate_bigen,
            'displaydate_end'   => $displaydate_end,
            'status_check'      => $status,
            'search'            => $search,
            'year_id'           => $year_id
        ]);

    }

//--------------------------แก้ไข-----

    public function assetinfolendedit(Request $request, $id)
    {

        $infoassetrequestlend    = Assetrequestlend::where('ID', '=', $id)->first();
        $infoassetrequestlendsub = Assetrequestlendsub::where('ASSET_REQUEST_LEND_SUB_ID', '=', $id)->get();
        $countcheck              = Assetrequestlendsub::where('ASSET_REQUEST_LEND_SUB_ID', '=', $id)->count();

        $inforequestasset = DB::table('asset_article')->where('DEP_ID', '=', $infoassetrequestlend->GIVE_DEP_SUB_SUB_ID)->get();

        $dep_sub_sub = DB::table('hrd_department_sub_sub')->where('HR_DEPARTMENT_SUB_SUB_ID', '=', $infoassetrequestlend->GIVE_DEP_SUB_SUB_ID)->first();

        return view('manager_asset.assetinfolendedit', [
            'inforequestassets'        => $inforequestasset,
            'dep_sub_sub'              => $dep_sub_sub,
            'infoassetrequestlend'     => $infoassetrequestlend,
            'infoassetrequestlendsubs' => $infoassetrequestlendsub,
            'countcheck'               => $countcheck

        ]);

    }

    public function assetinfolendupdate(Request $request)
    {


        $id        = $request->ID;
        $DATE_WANT = $request->DATE_WANT;
        $DATE_LEND = $request->DATE_LEND;

        if ($DATE_WANT != '') {
            $STARTDAY       = Carbon::createFromFormat('d/m/Y', $DATE_WANT)->format('Y-m-d');
            $date_arrary_st = explode("-", $STARTDAY);
            $y_sub_st       = $date_arrary_st[0];

            if ($y_sub_st >= 2500) {
                $y_st = $y_sub_st - 543;
            } else {
                $y_st = $y_sub_st;
            }
            $m_st     = $date_arrary_st[1];
            $d_st     = $date_arrary_st[2];
            $DATEWANT = $y_st . "-" . $m_st . "-" . $d_st;
        } else {
            $DATEWANT = null;
        }

        if ($DATE_LEND != '') {
            $STARTDAY       = Carbon::createFromFormat('d/m/Y', $DATE_LEND)->format('Y-m-d');
            $date_arrary_st = explode("-", $STARTDAY);
            $y_sub_st       = $date_arrary_st[0];

            if ($y_sub_st >= 2500) {
                $y_st = $y_sub_st - 543;
            } else {
                $y_st = $y_sub_st;
            }
            $m_st     = $date_arrary_st[1];
            $d_st     = $date_arrary_st[2];
            $DATELEND = $y_st . "-" . $m_st . "-" . $d_st;
        } else {
            $DATELEND = null;
        }

        $addassetrequest = Assetrequestlend::find($id);

        $addassetrequest->REQUEST_FOR = $request->REQUEST_FOR;

        $addassetrequest->DATE_WANT = $DATEWANT;
        $addassetrequest->DATE_LEND = $DATELEND;

        $addassetrequest->DATE_TIME_SAVE = date('Y-m-d H:i:s');
        $addassetrequest->save();

        $ASSET_REQUEST_LEND_ID = $id;

        Assetrequestlendsub::where('ASSET_REQUEST_LEND_ID', '=', $id)->delete();

        if ($request->ASSET_REQUEST_LEND_SUB_ARTICLE_ID[0] != '' || $request->ASSET_REQUEST_LEND_SUB_ARTICLE_ID[0] != null) {
            $ASSET_REQUEST_LEND_SUB_ARTICLE_ID = $request->ASSET_REQUEST_LEND_SUB_ARTICLE_ID;
            $number                            = count($ASSET_REQUEST_LEND_SUB_ARTICLE_ID);
            $count                             = 0;
            for ($count = 0; $count < $number; $count++) {

                $add                                    = new Assetrequestlendsub();
                $add->ASSET_REQUEST_LEND_ID             = $ASSET_REQUEST_LEND_ID;
                $add->ASSET_REQUEST_LEND_SUB_ARTICLE_ID = $ASSET_REQUEST_LEND_SUB_ARTICLE_ID[$count];

                $infoasset = DB::table('asset_article')->where('ARTICLE_ID', '=', $ASSET_REQUEST_LEND_SUB_ARTICLE_ID[$count])->first();

                $add->ASSET_REQUEST_LEND_SUB_NUMBER = $infoasset->ARTICLE_NUM;
                $add->ASSET_REQUEST_LEND_SUB_DETAIL = $infoasset->ARTICLE_NAME;
                $add->ASSET_REQUEST_LEND_SUB_UNIT   = $infoasset->UNIT_ID;
                $add->ASSET_REQUEST_LEND_SUB_PRICE  = $infoasset->PRICE_PER_UNIT;

                $add->save();

            }
        }


        return response()->json([
            'status' => 1,
            'url'    => url('manager_asset/assetinfolend')
        ]);

    }

    public function assetbarcodepdf(Request $request, $id)
    {
        $infoasset = Assetarticle::leftJoin('supplies_decline', 'supplies_decline.DECLINE_ID', '=', 'asset_article.DECLINE_ID')
            ->leftJoin('hrd_department_sub_sub', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID', '=', 'asset_article.DEP_ID')
            ->leftJoin('supplies_location', 'supplies_location.LOCATION_ID', '=', 'asset_article.LOCATION_ID')
            ->leftJoin('supplies_location_level', 'supplies_location_level.LOCATION_LEVEL_ID', '=', 'asset_article.LOCATION_LEVEL_ID')
            ->leftJoin('supplies_location_level_room', 'supplies_location_level_room.LEVEL_ROOM_ID', '=', 'asset_article.LEVEL_ROOM_ID')
            ->where('ARTICLE_ID', '=', $id)
            ->first();

        $pdf = PDF::loadView('manager_asset.assetbarcodepdf', [
            'infoasset' => $infoasset
        ]);

        return @$pdf->stream();

    }

    public function assetbarcode(Request $request, $id)
    {
        $infoasset = Assetarticle::leftJoin('supplies_decline', 'supplies_decline.DECLINE_ID', '=', 'asset_article.DECLINE_ID')
            ->leftJoin('hrd_department_sub_sub', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID', '=', 'asset_article.DEP_ID')
            ->leftJoin('supplies_location', 'supplies_location.LOCATION_ID', '=', 'asset_article.LOCATION_ID')
            ->leftJoin('supplies_location_level', 'supplies_location_level.LOCATION_LEVEL_ID', '=', 'asset_article.LOCATION_LEVEL_ID')
            ->leftJoin('supplies_location_level_room', 'supplies_location_level_room.LEVEL_ROOM_ID', '=', 'asset_article.LEVEL_ROOM_ID')
            ->where('ARTICLE_ID', '=', $id)
            ->first();

        return view('manager_asset.assetbarcode', [
            'infoasset' => $infoasset
        ]);

    }

    public function assetqrcode(Request $request, $id)
    {

            $infoasset = Assetarticle::leftJoin('supplies_decline', 'supplies_decline.DECLINE_ID', '=', 'asset_article.DECLINE_ID')
            ->leftJoin('hrd_department_sub_sub', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID', '=', 'asset_article.DEP_ID')
            ->leftJoin('supplies_location','supplies_location.LOCATION_ID','=','asset_article.LOCATION_ID')
            ->leftJoin('supplies_location_level','supplies_location_level.LOCATION_LEVEL_ID','=','asset_article.LOCATION_LEVEL_ID')
            ->leftJoin('supplies_location_level_room','supplies_location_level_room.LEVEL_ROOM_ID','=','asset_article.LEVEL_ROOM_ID')
            ->leftjoin('supplies_brand','asset_article.BRAND_ID','=','supplies_brand.BRAND_ID')
            ->leftjoin('asset_color','asset_article.COLOR_ID','=','asset_color.COLOR_ID')
            ->leftjoin('supplies_model','asset_article.MODEL_ID','=','supplies_model.MODEL_ID')
            ->leftjoin('supplies_unit','asset_article.UNIT_ID','=','supplies_unit.SUP_UNIT_ID')
            ->leftjoin('supplies_size','asset_article.SIZE_ID','=','supplies_size.SIZE_ID')
            ->leftjoin('supplies_method','asset_article.METHOD_ID','=','supplies_method.METHOD_ID')
            ->leftjoin('supplies_buy','asset_article.BUY_ID','=','supplies_buy.BUY_ID')
            ->leftjoin('hrd_person','asset_article.PERSON_ID','=','hrd_person.ID')
            ->leftjoin('asset_status','asset_article.STATUS_ID','=','asset_status.STATUS_ID')
            ->leftjoin('supplies_type','asset_article.TYPE_ID','=','supplies_type.SUP_TYPE_ID')
            ->leftjoin('supplies_vendor','asset_article.VENDOR_ID','=','supplies_vendor.VENDOR_ID')
            ->leftjoin('supplies_budget','asset_article.BUDGET_ID','=','supplies_budget.BUDGET_ID')
            ->where('ARTICLE_ID', '=', $id)
            ->first();


        return view('manager_asset.assetqrcode', [
            'infoasset' => $infoasset
        ]);

    }

    //---------------ข้อมูลทรัพย์สิน

    public function infoasset(Request $request,$idasset)
    {


             $repairnomalinfoasset = DB::table('asset_article')
             ->leftJoin('supplies_location','supplies_location.LOCATION_ID','=','asset_article.LOCATION_ID')
             ->leftJoin('supplies_location_level','supplies_location_level.LOCATION_LEVEL_ID','=','asset_article.LOCATION_LEVEL_ID')
             ->leftJoin('supplies_location_level_room','supplies_location_level_room.LEVEL_ROOM_ID','=','asset_article.LEVEL_ROOM_ID')
             ->leftjoin('supplies_brand','asset_article.BRAND_ID','=','supplies_brand.BRAND_ID')
             ->leftjoin('asset_color','asset_article.COLOR_ID','=','asset_color.COLOR_ID')
             ->leftjoin('supplies_model','asset_article.MODEL_ID','=','supplies_model.MODEL_ID')
             ->where('asset_article.ARTICLE_ID','=',$idasset)->first(); 


    


  
          if($repairnomalinfoasset->DECLINE_ID == 18){
            $infohisrepair = Informcomrepair::where('informcom_repair.ARTICLE_ID','=',$repairnomalinfoasset->ARTICLE_ID)
            ->leftjoin('asset_article','asset_article.ARTICLE_ID','=','informcom_repair.ARTICLE_ID')
            ->orderBy('informcom_repair.ID', 'desc') 
            ->get();
          }else if($repairnomalinfoasset->DECLINE_ID == 17){
            $infohisrepair = Assetcarerepair::where('asset_care_repair.ARTICLE_ID','=',$repairnomalinfoasset->ARTICLE_ID)
            ->leftjoin('asset_article','asset_article.ARTICLE_ID','=','asset_care_repair.ARTICLE_ID')
            ->orderBy('asset_care_repair.ID', 'desc') 
            ->get();
          }else{
            $infohisrepair = Informrepairindex::where('informrepair_index.ARTICLE_ID','=',$repairnomalinfoasset->ARTICLE_ID)
            ->leftjoin('asset_article','asset_article.ARTICLE_ID','=','informrepair_index.ARTICLE_ID')
            ->orderBy('informrepair_index.ID', 'desc') 
            ->get();
          }


            $detailplan = DB::table('asset_care_list')->where('ARTICLE_ID','=',$repairnomalinfoasset->ARTICLE_ID) ->orderBy('CARE_LIST_ID', 'desc') ->get();
            $planrepair = DB::table('informrepair_plan')->where('REPAIR_PLAN_ARTICLE_ID','=',$repairnomalinfoasset->ARTICLE_ID)->where('REPAIR_TYPE_CHECK','=','plan') ->orderBy('REPAIR_PLAN_ID', 'desc') ->get();
            $checkrepair = DB::table('informrepair_plan')->where('REPAIR_PLAN_ARTICLE_ID','=',$repairnomalinfoasset->ARTICLE_ID)->orderBy('REPAIR_PLAN_ID', 'desc') ->get();
            $leader = DB::table('gleave_leader')->get(); 


            return view('manager_asset.asset_infomation',[
                'repairnomalinfoasset' => $repairnomalinfoasset,
                'infohisrepairs' => $infohisrepair,
                'detailplans' => $detailplan,
                'planrepairs' => $planrepair,
                'checkrepairs' => $checkrepair,
                'leaders' => $leader,
              
              
           
              ]);

        }


        

    public function infoasset_excel(Request $request,$idasset)
    {

             $repairnomalinfoasset = DB::table('asset_article')
             ->leftJoin('supplies_location','supplies_location.LOCATION_ID','=','asset_article.LOCATION_ID')
             ->leftJoin('supplies_location_level','supplies_location_level.LOCATION_LEVEL_ID','=','asset_article.LOCATION_LEVEL_ID')
             ->leftJoin('supplies_location_level_room','supplies_location_level_room.LEVEL_ROOM_ID','=','asset_article.LEVEL_ROOM_ID')
             ->leftjoin('supplies_brand','asset_article.BRAND_ID','=','supplies_brand.BRAND_ID')
             ->leftjoin('asset_color','asset_article.COLOR_ID','=','asset_color.COLOR_ID')
             ->leftjoin('supplies_model','asset_article.MODEL_ID','=','supplies_model.MODEL_ID')
             ->leftjoin('supplies_type','asset_article.TYPE_ID','=','supplies_type.SUP_TYPE_ID')
             ->leftjoin('hrd_department_sub_sub','asset_article.DEP_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
             ->leftjoin('supplies_vendor','asset_article.VENDOR_ID','=','supplies_vendor.VENDOR_ID')
             ->leftjoin('supplies_budget','asset_article.BUDGET_ID','=','supplies_budget.BUDGET_ID')
             ->where('asset_article.ARTICLE_ID','=',$idasset)->first(); 



          if($repairnomalinfoasset->DECLINE_ID == 18){
            $infohisrepair = Informcomrepair::where('informcom_repair.ARTICLE_ID','=',$repairnomalinfoasset->ARTICLE_ID)
            ->leftjoin('asset_article','asset_article.ARTICLE_ID','=','informcom_repair.ARTICLE_ID')
            ->orderBy('informcom_repair.ID', 'desc') 
            ->get();
          }else if($repairnomalinfoasset->DECLINE_ID == 17){
            $infohisrepair = Assetcarerepair::where('asset_care_repair.ARTICLE_ID','=',$repairnomalinfoasset->ARTICLE_ID)
            ->leftjoin('asset_article','asset_article.ARTICLE_ID','=','asset_care_repair.ARTICLE_ID')
            ->orderBy('asset_care_repair.ID', 'desc') 
            ->get();
          }else{
            $infohisrepair = Informrepairindex::where('informrepair_index.ARTICLE_ID','=',$repairnomalinfoasset->ARTICLE_ID)
            ->leftjoin('asset_article','asset_article.ARTICLE_ID','=','informrepair_index.ARTICLE_ID')
            ->orderBy('informrepair_index.ID', 'desc') 
            ->get();
          }


            $detailplan = DB::table('asset_care_list')->where('ARTICLE_ID','=',$repairnomalinfoasset->ARTICLE_ID) ->orderBy('CARE_LIST_ID', 'desc') ->get();

            $planrepair = DB::table('informrepair_plan')->where('REPAIR_PLAN_ARTICLE_ID','=',$repairnomalinfoasset->ARTICLE_ID)->where('REPAIR_TYPE_CHECK','=','plan') ->orderBy('REPAIR_PLAN_ID', 'desc') ->get();

            $checkrepair = DB::table('informrepair_plan')->where('REPAIR_PLAN_ARTICLE_ID','=',$repairnomalinfoasset->ARTICLE_ID)->orderBy('REPAIR_PLAN_ID', 'desc') ->get();

            $leader = DB::table('gleave_leader')->get(); 

            $date1 = strtotime($repairnomalinfoasset->RECEIVE_DATE); 
            $date2 = strtotime($repairnomalinfoasset->EXPIRE_DATE); 
            
            $diff = abs($date2 - $date1); 

            $years = floor($diff / (365*60*60*24));
            $months = floor(($diff - $years * 365*60*60*24)
                               / (30*60*60*24));
            $days = floor(($diff - $years * 365*60*60*24 - 
                               $months*30*60*60*24)/ (60*60*24));

            $ageassetyears = $years." ปี ".$months." เดือน ".$days." วัน ";
            
            return view('manager_asset.asset_infomation_excel',[
                'repairnomalinfoasset' => $repairnomalinfoasset,
                'infohisrepairs' => $infohisrepair,
                'detailplans' => $detailplan,
                'planrepairs' => $planrepair,
                'checkrepairs' => $checkrepair,
                'ageassetyears' => $ageassetyears,
                'leaders' => $leader,
              
           
              ]);

        }

    

        function amountdayexp(Request $request)
    {
       
      $RECEIVE_DATE = $request->get('RECEIVE_DATE');

      if ($RECEIVE_DATE != '') {
        $STARTDAY       = Carbon::createFromFormat('d/m/Y', $RECEIVE_DATE)->format('Y-m-d');
        $date_arrary_st = explode("-", $STARTDAY);
        $y_sub_st       = $date_arrary_st[0];

        if ($y_sub_st >= 2500) {
            $y_st = $y_sub_st - 543;
        } else {
            $y_st = $y_sub_st;
        }
        $m_st     = $date_arrary_st[1];
        $d_st     = $date_arrary_st[2];
        $RECEIVE_DATE_use = $y_st . "-" . $m_st . "-" . $d_st;
    } else {
        $RECEIVE_DATE_use = null;
    }

      $DECLINE_ID = $request->get('DECLINE_ID');


      $infoyearexp = DB::table('supplies_decline')->where('DECLINE_ID','=',$DECLINE_ID)->first();
      
      $dateexp = $infoyearexp->OLD_YEAR*365;
      
      $detaildate_EXP =  date("d/m/Y", strtotime("+$dateexp day", strtotime($RECEIVE_DATE_use)));
     

      $output =  '  <div class="col">
      <p style="text-align: left">อายุการใช้งาน</p>
      </div>
      <div class="col-md-3" >
      <input name="OLD_USE" id="OLD_USE" class="form-control input-lg" style=" font-family: \'Kanit\', sans-serif;" value="'.$infoyearexp->OLD_YEAR.'" >
      </div>
      <div class="col-md-1" >
      ปี
     </div>
   
      <div class="col-md-2">
      <p style="text-align: left">หมดสภาพ</p>
      </div>
      <div class="col-md-4" >
      <input name="EXPIRE_DATE" id="EXPIRE_DATE" class="form-control input-lg datepicker" style=" font-family: \'Kanit\', sans-serif;" data-date-format="mm/dd/yyyy"  value="'.$detaildate_EXP.'" readonly>
      </div>';

    echo $output;
        
    }
        

    //==============================================================

    public function suppliesinfoarticle(Request $request)
    {

        $typedetail = 'article';

        if($typedetail == 'parcel'){
            $detail = '1';
            if(!empty($request->_token)){
                $search = $request->get('search');
                $typekind = $request->SEND_TYPEKIND;
                $type = $request->SEND_TYPE;
                $typedetail = $request->typedetail;
                session([
                    'manager_asset.suppliesinfo.parcel.search' => $search,
                    'manager_asset.suppliesinfo.parcel.typekind' => $typekind,
                    'manager_asset.suppliesinfo.parcel.type' => $type,
                    'manager_asset.suppliesinfo.parcel.typedetail' => $typedetail,
                    ]);
            }elseif(!empty(session('manager_asset.suppliesinfo.parcel'))){
                $search     = session('manager_asset.suppliesinfo.parcel.search');
                $typekind     = session('manager_asset.suppliesinfo.parcel.typekind');
                $type  = session('manager_asset.suppliesinfo.parcel.type');
                $typedetail    = session('manager_asset.suppliesinfo.parcel.typedetail');
            }else{
                $search     = '';
                $typekind     = '';
                $type  = '';
                $typedetail    = 'parcel';
            }
        }elseif($typedetail == 'article'){
            $detail = '2';  
            if(!empty($request->_token)){
                $search = $request->get('search');
                $typekind = $request->SEND_TYPEKIND;
                $type = $request->SEND_TYPE;
                $typedetail = $request->typedetail;
                session([
                    'manager_asset.suppliesinfo.article.search' => $search,
                    'manager_asset.suppliesinfo.article.typekind' => $typekind,
                    'manager_asset.suppliesinfo.article.type' => $type,
                    'manager_asset.suppliesinfo.article.typedetail' => $typedetail,
                    ]);
            }elseif(!empty(session('manager_asset.suppliesinfo.article'))){
                $search     = session('manager_asset.suppliesinfo.article.search');
                $typekind     = session('manager_asset.suppliesinfo.article.typekind');
                $type  = session('manager_asset.suppliesinfo.article.type');
                $typedetail    = session('manager_asset.suppliesinfo.article.typedetail');
            }else{
                $search     = '';
                $typekind     = '';
                $type  = '';
                $typedetail    = 'article';
            }
        }elseif($typedetail == 'service'){
            $detail = '3';   
            if(!empty($request->_token)){
                $search = $request->get('search');
                $typekind = $request->SEND_TYPEKIND;
                $type = $request->SEND_TYPE;
                $typedetail = $request->typedetail;
                session([
                    'manager_asset.suppliesinfo.service.search' => $search,
                    'manager_asset.suppliesinfo.service.typekind' => $typekind,
                    'manager_asset.suppliesinfo.service.type' => $type,
                    'manager_asset.suppliesinfo.service.typedetail' => $typedetail,
                    ]);
            }elseif(!empty(session('manager_asset.suppliesinfo.service'))){
                $search     = session('manager_asset.suppliesinfo.service.search');
                $typekind     = session('manager_asset.suppliesinfo.service.typekind');
                $type  = session('manager_asset.suppliesinfo.service.type');
                $typedetail    = session('manager_asset.suppliesinfo.service.typedetail');
            }else{
                $search     = '';
                $typekind     = '';
                $type  = '';
                $typedetail    = 'service';
            }
        }elseif($typedetail == 'building'){
            $detail = '5';            
            if(!empty($request->_token)){
                $search = $request->get('search');
                $typekind = $request->SEND_TYPEKIND;
                $type = $request->SEND_TYPE;
                $typedetail = $request->typedetail;
                session([
                    'manager_asset.suppliesinfo.building.search' => $search,
                    'manager_asset.suppliesinfo.building.typekind' => $typekind,
                    'manager_asset.suppliesinfo.building.type' => $type,
                    'manager_asset.suppliesinfo.building.typedetail' => $typedetail,
                    ]);
            }elseif(!empty(session('manager_asset.suppliesinfo.building'))){
                $search     = session('manager_asset.suppliesinfo.building.search');
                $typekind     = session('manager_asset.suppliesinfo.building.typekind');
                $type  = session('manager_asset.suppliesinfo.building.type');
                $typedetail    = session('manager_asset.suppliesinfo.building.typedetail');
            }else{
                $search     = '';
                $typekind     = '';
                $type  = '';
                $typedetail    = 'building';
            }
        }else{
            return redirect()->back();
        }

        if($typekind == null || $typekind == ''){
            if($type == null || $type == ''){
                $infosupplies= Supplies::select('supplies.ID','supplies.ACTIVE','SUP_FSN_NUM','SUP_NAME','SUP_TYPE_KIND_NAME','SUP_TYPE_NAME','SUP_PROP','TPU_NUMBER','CONTINUE_PRICE_NAME')
                ->leftJoin('supplies_type','supplies.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
                ->leftJoin('supplies_continue','supplies.CONTINUE_PRICE_ID','=','supplies_continue.CONTINUE_PRICE_ID')
                ->leftJoin('supplies_type_kind','supplies.SUP_TYPE_KIND_ID','=','supplies_type_kind.SUP_TYPE_KIND_ID')
                                ->where('supplies_type_kind.SUP_TYPE_MASTER_ID','=',$detail)
                                ->where(function($q) use ($search){
                                    $q->where('SUP_FSN_NUM','like','%'.$search.'%');
                                    $q->orwhere('SUP_NAME','like','%'.$search.'%');  
                                    $q->orwhere('CONTINUE_PRICE_NAME','like','%'.$search.'%'); 
                                })
                                ->orderBy('ID', 'desc') 
                                ->paginate(12);
            }else{
                $infosupplies=  Supplies::select('supplies.ID','supplies.ACTIVE','SUP_FSN_NUM','SUP_NAME','SUP_TYPE_KIND_NAME','SUP_TYPE_NAME','SUP_PROP','TPU_NUMBER','CONTINUE_PRICE_NAME')
                ->leftJoin('supplies_type','supplies.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
                ->leftJoin('supplies_continue','supplies.CONTINUE_PRICE_ID','=','supplies_continue.CONTINUE_PRICE_ID')
                ->leftJoin('supplies_type_kind','supplies.SUP_TYPE_KIND_ID','=','supplies_type_kind.SUP_TYPE_KIND_ID')
                ->where('supplies.SUP_TYPE_ID','=',$type)
                ->where('supplies_type_kind.SUP_TYPE_MASTER_ID','=',$detail)
                ->where(function($q) use ($search){
                    $q->where('SUP_FSN_NUM','like','%'.$search.'%');
                    $q->orwhere('SUP_NAME','like','%'.$search.'%');
                    $q->orwhere('CONTINUE_PRICE_NAME','like','%'.$search.'%');   
                })
                ->orderBy('ID', 'desc') 
                ->paginate(12);
            }
         }else{
            if($type == null || $type == ''){
                $infosupplies=  Supplies::select('supplies.ID','supplies.ACTIVE','SUP_FSN_NUM','SUP_NAME','SUP_TYPE_KIND_NAME','SUP_TYPE_NAME','SUP_PROP','TPU_NUMBER','CONTINUE_PRICE_NAME')
                ->leftJoin('supplies_type','supplies.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
                ->leftJoin('supplies_continue','supplies.CONTINUE_PRICE_ID','=','supplies_continue.CONTINUE_PRICE_ID')
                ->leftJoin('supplies_type_kind','supplies.SUP_TYPE_KIND_ID','=','supplies_type_kind.SUP_TYPE_KIND_ID')
                                ->where('supplies.SUP_TYPE_KIND_ID','=',$typekind)
                                ->where('supplies_type_kind.SUP_TYPE_MASTER_ID','=',$detail)
                                
                                ->where(function($q) use ($search){
                                    $q->where('SUP_FSN_NUM','like','%'.$search.'%');
                                    $q->orwhere('SUP_NAME','like','%'.$search.'%'); 
                                    $q->orwhere('CONTINUE_PRICE_NAME','like','%'.$search.'%');  
                                })
                                ->orderBy('ID', 'desc') 
                                ->paginate(12);
            }else{
                $infosupplies=  Supplies::select('supplies.ID','supplies.ACTIVE','SUP_FSN_NUM','SUP_NAME','SUP_TYPE_KIND_NAME','SUP_TYPE_NAME','SUP_PROP','TPU_NUMBER','CONTINUE_PRICE_NAME')
                ->leftJoin('supplies_type','supplies.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
                ->leftJoin('supplies_continue','supplies.CONTINUE_PRICE_ID','=','supplies_continue.CONTINUE_PRICE_ID')
                ->leftJoin('supplies_type_kind','supplies.SUP_TYPE_KIND_ID','=','supplies_type_kind.SUP_TYPE_KIND_ID')
                ->where('supplies.SUP_TYPE_ID','=',$type)
                ->where('supplies.SUP_TYPE_KIND_ID','=',$typekind)
                ->where('supplies_type_kind.SUP_TYPE_MASTER_ID','=',$detail)
                
                ->where(function($q) use ($search){
                    $q->where('SUP_FSN_NUM','like','%'.$search.'%');
                    $q->orwhere('SUP_NAME','like','%'.$search.'%');  
                    $q->orwhere('CONTINUE_PRICE_NAME','like','%'.$search.'%'); 
                })
                ->orderBy('ID', 'desc') 
                ->paginate(12);
            }
        }
        $suppliestype = DB::table('supplies_type')->where('SUP_TYPE_MASTER_ID','=',$detail)->get();
        $suppliestypekind = DB::table('supplies_type_kind')->where('SUP_TYPE_MASTER_ID','=',$detail)->get();
        $typekind_check = $typekind;
        $type_check = $type;
        return view('manager_asset.suppliesinfoasset',[
            'infosuppliess' => $infosupplies,
            'suppliestypes' => $suppliestype,
            'suppliestypekinds' => $suppliestypekind,
            'typekind_check' => $typekind_check,
            'type_check' => $type_check,
            'search' => $search,
            'typedetail' => $typedetail,
        ]);
    
    }

    public function suppliesinfoarticle_add (Request $request)
    {    

        $typedetail = 'article';

        if($typedetail == 'parcel'){
            $detail = '1';
        }elseif($typedetail == 'article'){
            $detail = '2';  
        }elseif($typedetail == 'service'){
            $detail = '3';   
        }else{
            $detail = '5';
        }

        $suppliestypekind = DB::table('supplies_type_kind')->where('SUP_TYPE_MASTER_ID','=',$detail)->get();
        $suppliestype = DB::table('supplies_type')->where('SUP_TYPE_MASTER_ID','=',$detail)->get();
        $suppliestypemaster = DB::table('supplies_type_master')->where('SUP_TYPE_MASTER_ID','=',$detail)->get();

        $suppliesprop = DB::table('supplies_prop')->get();

        $suppliesunit = DB::table('supplies_unit')->get();

        $suppliesvendor = DB::table('supplies_vendor')->get();

        return view('manager_asset.suppliesinfoarticle_add',[
            'suppliestypekinds' => $suppliestypekind,
            'suppliestypes' => $suppliestype,
            'suppliestypemasters' => $suppliestypemaster,
            'typedetail' => $typedetail,
            'suppliesprops' => $suppliesprop,
            'suppliesunits' => $suppliesunit,
            'suppliesvendor' => $suppliesvendor,
        ]);    
    }

    public function savesuppliesinfoarticle(Request $request) 
    {

        $typedetail = $request->typedetail;
      
        $count= DB::table('supplies')
        ->where('supplies.SUP_FSN_NUM',$request->SUP_FSN_NUM) 
        ->count();

     if($count == 0){


        $addinfosup = new Supplies(); 
      
        $addinfosup->SUP_FSN_NUM = $request->SUP_FSN_NUM;
        $addinfosup->SUP_TYPE_KIND_ID = $request->SUP_TYPE_KIND_ID;
        $addinfosup->SUP_NAME = $request->SUP_NAME;
        $addinfosup->CONTINUE_PRICE_ID = $request->CONTINUE_PRICE_ID;
        $addinfosup->SUP_PROP = $request->SUP_PROP;
        $addinfosup->SUP_TYPE_ID = $request->SUP_TYPE_ID;
        $addinfosup->SUP_TYPE_MASTER_ID = $request->SUP_TYPE_MASTER_ID;
        $addinfosup->CONTENT = $request->CONTENT;
        $addinfosup->TPU_NUMBER = $request->TPU_NUMBER;
        $addinfosup->MIN = $request->MIN;
        $addinfosup->MAX = $request->MAX;

        if($request->hasFile('picture')){
            
            $file = $request->file('picture');  
            $contents = $file->openFile()->fread($file->getSize());
            $addinfosup->IMG = $contents;   
          
        }

        $addinfosup->save();


        $SUP_ID = Supplies::max('ID');


        if($request->SUP_UNIT_ID0 !== null ){
            $add = new Suppliesunitref();
            $add->SUP_ID = $SUP_ID;
            $add->SUP_UNIT_ID = $request->SUP_UNIT_ID0;
            $SUPUNITNAME = DB::table('supplies_unit')->where('SUP_UNIT_ID','=',$request->SUP_UNIT_ID0)->first();
            $add->SUP_UNIT_NAME = $SUPUNITNAME->SUP_UNIT_NAME;
            $add->SUP_TOTAL = $request->SUP_TOTAL0; 
            $add->save(); 
        }

        if($request->SUP_UNIT_ID1 !== null ){   

            $add = new Suppliesunitref();
            $add->SUP_ID = $SUP_ID;
            $add->SUP_UNIT_ID = $request->SUP_UNIT_ID1;
            $SUPUNITNAME = DB::table('supplies_unit')->where('SUP_UNIT_ID','=',$request->SUP_UNIT_ID1)->first();
            $add->SUP_UNIT_NAME = $SUPUNITNAME->SUP_UNIT_NAME;
            $add->SUP_TOTAL = $request->SUP_TOTAL1; 
            $add->save(); 
        }

    }

        $typedetail = $request->typedetail;

    

        return redirect()->route('massete.suppliesinfoarticle');

      

    }
//=================================================

function suppliesinfoarticle_edit(Request $request,$id)
{

    $typedetail = 'article';

    if($typedetail == 'parcel'){
        $detail = '1';
    }elseif($typedetail == 'article'){
        $detail = '2';  
    }elseif($typedetail == 'service'){
        $detail = '3';   
    }else{
        $detail = '5';
    }

  

    $suppliestypekind = DB::table('supplies_type_kind')->where('SUP_TYPE_MASTER_ID','=',$detail)->get();
    $suppliestype = DB::table('supplies_type')->where('SUP_TYPE_MASTER_ID','=',$detail)->get();
    $suppliestypemaster = DB::table('supplies_type_master')->where('SUP_TYPE_MASTER_ID','=',$detail)->get();

    $infosupplie = DB::table('supplies')->where('ID','=',$id)->first();

    $suppliesprop = DB::table('supplies_prop')->get();

    $countSuppliesunitref = Suppliesunitref::where('SUP_ID','=',$id)->get();

    $infoSuppliesunitref = Suppliesunitref::where('SUP_ID','=',$id)->get();

    $suppliesunit = DB::table('supplies_unit')->get();

    //------unit

    $infounitref_1 = Suppliesunitref::where('SUP_ID','=',$id)->where('SUP_TOTAL','=',1)->first();

    if($infounitref_1 == null){
        $infounitref1 = 'null';
    }else{
        $infounitref1 = $infounitref_1;
    }
   
   
    $infounitref_2 = Suppliesunitref::where('SUP_ID','=',$id)->where('SUP_TOTAL','!=',1)->first();

    if($infounitref_2 == null){
        $infounitref2 = 'null';
    }else{
        $infounitref2 = $infounitref_2;
    }

    return view('manager_asset.suppliesinfoarticle_edit',[
        'suppliestypekinds' => $suppliestypekind,
        'suppliestypes' => $suppliestype,
        'suppliestypemasters' => $suppliestypemaster,
        'infosupplie' => $infosupplie,
        'typedetail' => $typedetail,
        'suppliesprops' => $suppliesprop,
        'infoSuppliesunitrefs' => $infoSuppliesunitref,
        'countSuppliesunitref' => $countSuppliesunitref,
        'suppliesunits' => $suppliesunit,
        'infounitref1' => $infounitref1,
        'infounitref2' => $infounitref2,
    ]);

}

public function updatesuppliesinfoarticle(Request $request)
{
    $typedetail = $request->typedetail;


    $id = $request->ID;

    $count= DB::table('supplies')
    ->where('supplies.SUP_FSN_NUM',$request->SUP_FSN_NUM) 
    ->count();

  

    $addinfosup = Supplies::find($id);
  
    $addinfosup->SUP_FSN_NUM = $request->SUP_FSN_NUM;
    $addinfosup->SUP_TYPE_KIND_ID = $request->SUP_TYPE_KIND_ID;
    $addinfosup->SUP_NAME = $request->SUP_NAME;
    $addinfosup->CONTINUE_PRICE_ID = $request->CONTINUE_PRICE_ID;
    $addinfosup->SUP_PROP = $request->SUP_PROP;
    $addinfosup->SUP_TYPE_ID = $request->SUP_TYPE_ID;
    $addinfosup->SUP_TYPE_MASTER_ID = $request->SUP_TYPE_MASTER_ID;
    $addinfosup->CONTENT = $request->CONTENT;
    $addinfosup->TPU_NUMBER = $request->TPU_NUMBER;
    $addinfosup->MIN = $request->MIN;
    $addinfosup->MAX = $request->MAX;

    if($request->hasFile('picture')){
        
        $file = $request->file('picture');  
        $contents = $file->openFile()->fread($file->getSize());
        $addinfosup->IMG = $contents;   
      
    }

    $addinfosup->save();


          
    $SUP_ID =  $id;
           
            if($request->checkid1!== 'null'){

                $idunit = $request->checkid1; 
                
                $add = Suppliesunitref::find($idunit);
                $add->SUP_ID = $SUP_ID;
                $add->SUP_UNIT_ID = $request->SUP_UNIT_ID0;
                $SUPUNITNAME = DB::table('supplies_unit')->where('SUP_UNIT_ID','=',$request->SUP_UNIT_ID0)->first();
                $add->SUP_UNIT_NAME = $SUPUNITNAME->SUP_UNIT_NAME;
                $add->SUP_TOTAL = $request->SUP_TOTAL0; 
                $add->save(); 

            }elseif($request->SUP_UNIT_ID0 !== null ){
                $add = new Suppliesunitref();
                $add->SUP_ID = $SUP_ID;
                $add->SUP_UNIT_ID = $request->SUP_UNIT_ID0;
                $SUPUNITNAME = DB::table('supplies_unit')->where('SUP_UNIT_ID','=',$request->SUP_UNIT_ID0)->first();
                $add->SUP_UNIT_NAME = $SUPUNITNAME->SUP_UNIT_NAME;
                $add->SUP_TOTAL = $request->SUP_TOTAL0; 
                $add->save(); 
            }
      
         
            if($request->checkid2 !== 'null'){
                $idunit = $request->checkid2; 

           
                if($request->SUP_UNIT_ID1 !== '' && $request->SUP_UNIT_ID1 !== null){
               
                $add = Suppliesunitref::find($idunit);
                $add->SUP_ID = $SUP_ID;
                $add->SUP_UNIT_ID = $request->SUP_UNIT_ID1;
                $SUPUNITNAME = DB::table('supplies_unit')->where('SUP_UNIT_ID','=',$request->SUP_UNIT_ID1)->first();
                $add->SUP_UNIT_NAME = $SUPUNITNAME->SUP_UNIT_NAME;
                $add->SUP_TOTAL = $request->SUP_TOTAL1;       
                $add->save(); 
                }else{

                    $add = Suppliesunitref::find($idunit);
                    $add->SUP_ID = $SUP_ID;
                    $add->SUP_UNIT_ID = '';
                    $add->SUP_UNIT_NAME = '';
                    $add->SUP_TOTAL = 0;       
                    $add->save();

                }

            }elseif($request->SUP_UNIT_ID1 !== null ){

            

                $add = new Suppliesunitref();
                $add->SUP_ID = $SUP_ID;
                $add->SUP_UNIT_ID = $request->SUP_UNIT_ID1;
                $SUPUNITNAME = DB::table('supplies_unit')->where('SUP_UNIT_ID','=',$request->SUP_UNIT_ID1)->first();
                $add->SUP_UNIT_NAME = $SUPUNITNAME->SUP_UNIT_NAME;
                $add->SUP_TOTAL = $request->SUP_TOTAL1; 
                $add->save(); 
            }

    $typedetail = $request->typedetail;


    return redirect()->route('massete.suppliesinfoarticle');

}



//=========================เพิ่มทรัพย์สินครุภัณท์

function suppliesinfoarticle_suppliesinfo(Request $request,$id)
{


    $infosupplie = DB::table('supplies')
    ->leftJoin('supplies_decline','supplies.DECLINE_ID','=','supplies_decline.DECLINE_ID')
    ->where('ID','=',$id)->first();

    $infosupplieinasset =  Assetarticle::leftJoin('supplies_decline','supplies_decline.DECLINE_ID','=','asset_article.DECLINE_ID')
    ->leftJoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','asset_article.DEP_ID')
    ->leftJoin('supplies_location','supplies_location.LOCATION_ID','=','asset_article.LOCATION_ID')
    ->leftJoin('supplies_location_level','supplies_location_level.LOCATION_LEVEL_ID','=','asset_article.LOCATION_LEVEL_ID')
    ->leftJoin('supplies_location_level_room','supplies_location_level_room.LEVEL_ROOM_ID','=','asset_article.LEVEL_ROOM_ID')
    ->where('SUP_FSN','=',$infosupplie->SUP_FSN_NUM )
    ->orderBy('ARTICLE_ID', 'desc') 
    ->get();

    return view('manager_asset.suppliesinfoinassetdata',[
        'infosupplie' => $infosupplie,
        'infosupplieinassets' => $infosupplieinasset,
       
    ]);

}


function suppliesinfoarticle_suppliesinfo_add(Request $request,$id)
{
    
    $infosupplie = DB::table('supplies')->where('ID','=',$id)->first();

    $infobudgetyear = DB::table('budget_year')->get();
   
    $infounit = DB::table('supplies_unit')->get();
    $inbrand = DB::table('supplies_brand')->get();
    $infocolor = DB::table('supplies_color')->get();
    $inmodel = DB::table('supplies_model')->get();
    $infosize = DB::table('supplies_size')->get();
    $infomethod = DB::table('supplies_method')->get();
    $infobuy = DB::table('supplies_buy')->get();
    $infobudget= DB::table('supplies_budget')->get();
    $infotype = DB::table('supplies_type')->get();
    $infodecline = DB::table('supplies_decline')->get();
    $infovendor= DB::table('supplies_vendor')->get();

    $infodep= DB::table('hrd_department_sub_sub')->get();
    $infolocation = DB::table('supplies_location')->get();
    $infolocationlevel = DB::table('supplies_location_level')->get();
    $infolocationlevelroom= DB::table('supplies_location_level_room')->get();

    $infoperson = DB::table('hrd_person')->get();
      
    $infostatus= DB::table('asset_status')->get();
    $infogroupcal = DB::table('asset_group_cal')->get();     
    $infogrouppm = DB::table('asset_group_pm')->get(); 
    $infogrouprisk = DB::table('asset_group_risk')->get();

    return view('manager_asset.suppliesinfoarticle_suppliesinfo_add',[
        'infosupplie' => $infosupplie,
        'infobudgetyears' => $infobudgetyear,
        'infounits' => $infounit,
        'inbrands' => $inbrand,
        'infocolors' => $infocolor, 
        'inmodels' => $inmodel,
        'infosizes' => $infosize,   
        'infomethods' => $infomethod,
        'infobuys' => $infobuy,  
        'infobudgets' => $infobudget,
        'infotypes' => $infotype,   
        'infodeclines' => $infodecline,
        'infovendors' => $infovendor, 
        'infodeps' => $infodep,
        'infolocations' => $infolocation,   
        'infolocationlevels' => $infolocationlevel,
        'infolocationlevelrooms' => $infolocationlevelroom,  
        'infopersons' => $infoperson,  
        'infostatuss' => $infostatus,
        'infogroupcals' => $infogroupcal,
        'infogrouppms' => $infogrouppm,
        'infogrouprisks' => $infogrouprisk, 
    ]);

}



public function savesuppliesinfoarticle_suppliesinfo(Request $request)
{
    $BUILD_CREATE= $request->RECEIVE_DATE;
    $BUILD_FINISH= $request->EXPIRE_DATE;
 

    if($BUILD_CREATE != ''){
        $STARTDAY = Carbon::createFromFormat('d/m/Y', $BUILD_CREATE)->format('Y-m-d');
        $date_arrary_st=explode("-",$STARTDAY);  
        $y_sub_st = $date_arrary_st[0]; 
        
        if($y_sub_st >= 2500){
            $y_st = $y_sub_st-543;
        }else{
            $y_st = $y_sub_st;
        }
        $m_st = $date_arrary_st[1];
        $d_st = $date_arrary_st[2];  
        $RECEIVEDATE= $y_st."-".$m_st."-".$d_st;
        }else{
        $RECEIVEDATE= null;
    }


    if($BUILD_FINISH != ''){
        $STARTDAY = Carbon::createFromFormat('d/m/Y', $BUILD_FINISH)->format('Y-m-d');
        $date_arrary_st=explode("-",$STARTDAY);  
        $y_sub_st = $date_arrary_st[0]; 
        
        if($y_sub_st >= 2500){
            $y_st = $y_sub_st-543;
        }else{
            $y_st = $y_sub_st;
        }
        $m_st = $date_arrary_st[1];
        $d_st = $date_arrary_st[2];  
        $EXPIRE_DATE= $y_st."-".$m_st."-".$d_st;
        }else{
        $EXPIRE_DATE= null;
    }


    $addinfoarticle = new Assetarticle(); 
    $addinfoarticle->ARTICLE_NUM = $request->ARTICLE_NUM;
    $addinfoarticle->YEAR_ID = $request->YEAR_ID;
    $addinfoarticle->ARTICLE_NAME = $request->ARTICLE_NAME;
    $addinfoarticle->ARTICLE_PROP = $request->ARTICLE_PROP;
    $addinfoarticle->UNIT_ID = $request->UNIT_ID;
    $addinfoarticle->SERIAL_NO = $request->SERIAL_NO;
    $addinfoarticle->BRAND_ID = $request->BRAND_ID;
    $addinfoarticle->COLOR_ID = $request->COLOR_ID;
    $addinfoarticle->MODEL_ID = $request->MODEL_ID;
    $addinfoarticle->SIZE_ID = $request->SIZE_ID;
    $addinfoarticle->PRICE_PER_UNIT = $request->PRICE_PER_UNIT;
    $addinfoarticle->RECEIVE_DATE = $RECEIVEDATE;
    $addinfoarticle->METHOD_ID = $request->METHOD_ID;
    $addinfoarticle->BUY_ID = $request->BUY_ID;
    $addinfoarticle->BUDGET_ID = $request->BUDGET_ID;
    $addinfoarticle->TYPE_ID = $request->TYPE_ID;
    $addinfoarticle->DECLINE_ID = $request->DECLINE_ID;
    $addinfoarticle->VENDOR_ID = $request->VENDOR_ID;
    $addinfoarticle->DEP_ID = $request->DEP_ID;
    $addinfoarticle->LOCATION_ID = $request->LOCATION_ID;
    $addinfoarticle->LOCATION_LEVEL_ID = $request->LOCATION_LEVEL_ID;
    $addinfoarticle->LEVEL_ROOM_ID = $request->LEVEL_ROOM_ID;
    $addinfoarticle->PERSON_ID = $request->PERSON_ID;
    $addinfoarticle->REMARK = $request->REMARK;
    $addinfoarticle->STATUS_ID = $request->STATUS_ID;
    $addinfoarticle->OLD_USE = $request->OLD_USE;

    $addinfoarticle->EXPIRE_DATE = $EXPIRE_DATE;

    $addinfoarticle->PM_TYPE_ID = $request->PM_TYPE_ID;
    $addinfoarticle->CAL_TYPE_ID = $request->CAL_TYPE_ID;
    $addinfoarticle->RISK_TYPE_ID = $request->RISK_TYPE_ID;
  
    $addinfoarticle->OPENS = 'False';
    $addinfoarticle->SUP_FSN = $request->SUP_FSN;

    if($request->hasFile('picture')){
        
        $file = $request->file('picture');  
        $contents = $file->openFile()->fread($file->getSize());
        $addinfoarticle->IMG = $contents;   
      
    }

   

    $addinfoarticle->save();


    return redirect()->route('massete.suppliesinfoarticle_suppliesinfo',[
        'id' => $request->ID,
    ]);
}


//=====แก้ไขครุภัณฑ์

function suppliesinfoarticle_suppliesinfo_edit(Request $request,$id,$asstid)
{
    
    $infosupplie = DB::table('supplies')->where('ID','=',$id)->first();

    $infobudgetyear = DB::table('budget_year')->get();
   
    $infounit = DB::table('supplies_unit')->get();
    $inbrand = DB::table('supplies_brand')->get();
    $infocolor = DB::table('supplies_color')->get();
    $inmodel = DB::table('supplies_model')->get();
    $infosize = DB::table('supplies_size')->get();
    $infomethod = DB::table('supplies_method')->get();
    $infobuy = DB::table('supplies_buy')->get();
    $infobudget= DB::table('supplies_budget')->get();
    $infotype = DB::table('supplies_type')->get();
    $infodecline = DB::table('supplies_decline')->get();
    $infovendor= DB::table('supplies_vendor')->get();

    $infodep= DB::table('hrd_department_sub_sub')->get();
    $infolocation = DB::table('supplies_location')->get();
    $infolocationlevel = DB::table('supplies_location_level')->get();
    $infolocationlevelroom= DB::table('supplies_location_level_room')->get();

    $infoperson = DB::table('hrd_person')->get();
      
    $infostatus= DB::table('asset_status')->get();
    $infogroupcal = DB::table('asset_group_cal')->get();     
    $infogrouppm = DB::table('asset_group_pm')->get(); 
    $infogrouprisk = DB::table('asset_group_risk')->get();

    //==============================================
    $infoassetarticle = DB::table('asset_article')->where('ARTICLE_ID','=',$asstid)->first();
   

    return view('manager_asset.suppliesinfoarticle_suppliesinfo_edit',[
        'infosupplie' => $infosupplie,
        'infobudgetyears' => $infobudgetyear,
        'infounits' => $infounit,
        'inbrands' => $inbrand,
        'infocolors' => $infocolor, 
        'inmodels' => $inmodel,
        'infosizes' => $infosize,   
        'infomethods' => $infomethod,
        'infobuys' => $infobuy,  
        'infobudgets' => $infobudget,
        'infotypes' => $infotype,   
        'infodeclines' => $infodecline,
        'infovendors' => $infovendor, 
        'infodeps' => $infodep,
        'infolocations' => $infolocation,   
        'infolocationlevels' => $infolocationlevel,
        'infolocationlevelrooms' => $infolocationlevelroom,  
        'infopersons' => $infoperson,  
        'infostatuss' => $infostatus,
        'infogroupcals' => $infogroupcal,
        'infogrouppms' => $infogrouppm,
        'infogrouprisks' => $infogrouprisk,
        'infoassetarticle' => $infoassetarticle,
         
      
       
    ]);

}



public function updatesuppliesinfoarticle_suppliesinfo(Request $request)
{
 
    $BUILD_CREATE= $request->RECEIVE_DATE;
    $BUILD_FINISH= $request->EXPIRE_DATE;
 

    if($BUILD_CREATE != ''){
        $STARTDAY = Carbon::createFromFormat('d/m/Y', $BUILD_CREATE)->format('Y-m-d');
        $date_arrary_st=explode("-",$STARTDAY);  
        $y_sub_st = $date_arrary_st[0]; 
        
        if($y_sub_st >= 2500){
            $y_st = $y_sub_st-543;
        }else{
            $y_st = $y_sub_st;
        }
        $m_st = $date_arrary_st[1];
        $d_st = $date_arrary_st[2];  
        $RECEIVEDATE= $y_st."-".$m_st."-".$d_st;
        }else{
        $RECEIVEDATE= null;
    }


    if($BUILD_FINISH != ''){
        $STARTDAY = Carbon::createFromFormat('d/m/Y', $BUILD_FINISH)->format('Y-m-d');
        $date_arrary_st=explode("-",$STARTDAY);  
        $y_sub_st = $date_arrary_st[0]; 
        
        if($y_sub_st >= 2500){
            $y_st = $y_sub_st-543;
        }else{
            $y_st = $y_sub_st;
        }
        $m_st = $date_arrary_st[1];
        $d_st = $date_arrary_st[2];  
        $EXPIRE_DATE= $y_st."-".$m_st."-".$d_st;
        }else{
        $EXPIRE_DATE= null;
    }

 
    $ARTICLE_ID= $request->ARTICLE_ID;

    $addinfoarticle = Assetarticle::find($ARTICLE_ID);
    $addinfoarticle->ARTICLE_NUM = $request->ARTICLE_NUM;
    $addinfoarticle->YEAR_ID = $request->YEAR_ID;
    $addinfoarticle->ARTICLE_NAME = $request->ARTICLE_NAME;
    $addinfoarticle->ARTICLE_PROP = $request->ARTICLE_PROP;
    $addinfoarticle->UNIT_ID = $request->UNIT_ID;
    $addinfoarticle->SERIAL_NO = $request->SERIAL_NO;
    $addinfoarticle->BRAND_ID = $request->BRAND_ID;
    $addinfoarticle->COLOR_ID = $request->COLOR_ID;
    $addinfoarticle->MODEL_ID = $request->MODEL_ID;
    $addinfoarticle->SIZE_ID = $request->SIZE_ID;
    $addinfoarticle->PRICE_PER_UNIT = $request->PRICE_PER_UNIT;
    $addinfoarticle->RECEIVE_DATE = $RECEIVEDATE;
    $addinfoarticle->METHOD_ID = $request->METHOD_ID;
    $addinfoarticle->BUY_ID = $request->BUY_ID;
    $addinfoarticle->BUDGET_ID = $request->BUDGET_ID;
    $addinfoarticle->TYPE_ID = $request->TYPE_ID;
    $addinfoarticle->DECLINE_ID = $request->DECLINE_ID;
    $addinfoarticle->VENDOR_ID = $request->VENDOR_ID;
    $addinfoarticle->DEP_ID = $request->DEP_ID;
    $addinfoarticle->LOCATION_ID = $request->LOCATION_ID;
    $addinfoarticle->LOCATION_LEVEL_ID = $request->LOCATION_LEVEL_ID;
    $addinfoarticle->LEVEL_ROOM_ID = $request->LEVEL_ROOM_ID;
    $addinfoarticle->PERSON_ID = $request->PERSON_ID;
    $addinfoarticle->REMARK = $request->REMARK;
    $addinfoarticle->STATUS_ID = $request->STATUS_ID;
    $addinfoarticle->OLD_USE = $request->OLD_USE;

    $addinfoarticle->EXPIRE_DATE = $EXPIRE_DATE;

    $addinfoarticle->PM_TYPE_ID = $request->PM_TYPE_ID;
    $addinfoarticle->CAL_TYPE_ID = $request->CAL_TYPE_ID;
    $addinfoarticle->RISK_TYPE_ID = $request->RISK_TYPE_ID;
  
    $addinfoarticle->SUP_FSN = $request->SUP_FSN;

    if($request->hasFile('picture')){
        
        $file = $request->file('picture');  
        $contents = $file->openFile()->fread($file->getSize());
        $addinfoarticle->IMG = $contents;   
      
    }

   

    $addinfoarticle->save();



    


    $id =   $ARTICLE_ID;

    Assetdepreciate::where('DEP_ASSET_ID','=',$id)->delete();
    $infoasset= Assetarticle::where('asset_article.ARTICLE_ID','=',$id)
    ->leftJoin('supplies_decline','supplies_decline.DECLINE_ID','=','asset_article.DECLINE_ID')
    ->leftJoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','asset_article.DEP_ID')
    ->leftJoin('supplies_location','supplies_location.LOCATION_ID','=','asset_article.LOCATION_ID')
    ->leftJoin('supplies_location_level','supplies_location_level.LOCATION_LEVEL_ID','=','asset_article.LOCATION_LEVEL_ID')
    ->leftJoin('supplies_location_level_room','supplies_location_level_room.LEVEL_ROOM_ID','=','asset_article.LEVEL_ROOM_ID')
    ->first();




    $depreciation= DB::table('supplies_decline')->where('supplies_decline.DECLINE_ID','=',$infoasset->DECLINE_ID)->first();


    $start = $month = strtotime($infoasset->RECEIVE_DATE. ' + 1 month');

    $yearend = date("Y",strtotime($infoasset->RECEIVE_DATE))+60;

    $dateend = $yearend.'-01-01';

    $end = strtotime($dateend);

//=========================

                                           //--------------------------------สูตรคำนวน-----------------------------------------------
                                                        $PICE = $infoasset->PRICE_PER_UNIT;
                                                        $per_year = $depreciation->DECLINE_PERSEN;
                                                        $Depreciation_mont =  ($PICE*($per_year/100))/12;

                                                        $checkdep  =  Assetdepreciate::where('DEP_ASSET_ID','=',$id)->count();
                                                        //-------------------------คำนวณเดือนแรก----------------------------



                                                        $fristYear= date("Y",strtotime($infoasset->RECEIVE_DATE))+543;
                                                        $fristMonth= date("m",strtotime($infoasset->RECEIVE_DATE));
                                                        $fristdate= date("d",strtotime($infoasset->RECEIVE_DATE));

                                                        if($fristMonth == '04' || $fristMonth == '06' || $fristMonth == '09' || $fristMonth == '11'){
                                                            $d = 30;
                                                        }elseif($fristMonth == '02'){
                                                            if(($fristYear-543)%4 == 0){
                                                                $d = 29;
                                                            }else{
                                                                $d = 28;
                                                            }
                                                           
                                                        }else{
                                                            $d = 31;
                                                        }

                                                        $amountdate =  $d - $fristdate;
                                                        $Depdate = $Depreciation_mont/$d;

                                                    $fristDepreciation_mont = $amountdate * $Depdate;

                                                    $fristDepreciation = $PICE - $fristDepreciation_mont;



                                                                    //-------------เพิ่มข้อมูลในตาราง----------------------------
                                                    if($checkdep == 0 ){
                                                        $adddepreciate= new Assetdepreciate();
                                                        $adddepreciate->DEP_ASSET_ID = $id;
                                                        $adddepreciate->DEP_YEAR = $fristYear;
                                                        $adddepreciate->DEP_MONTH = number_format($fristMonth);
                                                        $adddepreciate->DEP_PRICE = $PICE;
                                                        $adddepreciate->DEP_FORWARD = 0;
                                                        $adddepreciate->DEP_DEPRECIATE = $fristDepreciation_mont;
                                                        $adddepreciate->DEP_CUMULATIVE = $fristDepreciation_mont;
                                                        $adddepreciate->DEP_VALUE = $fristDepreciation;
                                                        $adddepreciate->save();

                                                     }            


                                                        $Depreciation_move = $fristDepreciation_mont;
                                                        $Depreciation = $Depreciation_mont + $Depreciation_move;

                                                                while($month < $end)
                                                    {


                                                        $year = date('Y', $month)+543;
                                                        $value_last = ($PICE -$Depreciation_move)-1 ; //-----ตัวตัดค่าเสื่อมตัวสุดท้าย
                                                        $value = $PICE - $Depreciation;

                                                        if($value <=0){
                                                            $Depreciation_mont = $value_last;
                                                            $Depreciation = $Depreciation_move+$Depreciation_mont;
                                                            $value = 1;

                                                        }



                                                        //-------------เพิ่มข้อมูลในตาราง----------------------------
                                                        if($checkdep == 0 ){
                                                            $adddepreciate = new Assetdepreciate();
                                                            $adddepreciate->DEP_ASSET_ID = $id;
                                                            $adddepreciate->DEP_YEAR = $year;
                                                            $adddepreciate->DEP_MONTH = number_format(date('m', $month));
                                                            $adddepreciate->DEP_PRICE = $PICE;
                                                            $adddepreciate->DEP_FORWARD = $Depreciation_move;
                                                            $adddepreciate->DEP_DEPRECIATE = $Depreciation_mont;
                                                            $adddepreciate->DEP_CUMULATIVE = $Depreciation;
                                                            $adddepreciate->DEP_VALUE = $value;
                                                            $adddepreciate->save();
                                                            }
                                                            //------------------------------------------

                                                        if($value ==1){
                                                        break;
                                                        }
                                                        $Depreciation = $Depreciation_mont + $Depreciation;

                                                        $Depreciation_move = $Depreciation - $Depreciation_mont;



                                                        $month = strtotime("+1 month", $month);



                                                    }


    return redirect()->route('massete.suppliesinfoarticle_suppliesinfo',[
        'id' => $request->ID,
    ]);
}


//===============================ฟังชั่นโคลน


public function detailfsn(Request $request)
{

  $id =  $request->id;

  $infoasset = DB::table('asset_article')
  ->select('supplies.ID','ARTICLE_NUM')
  ->leftjoin('supplies','supplies.SUP_FSN_NUM','=','asset_article.SUP_FSN')
  ->where('ARTICLE_ID','=',$id)->first();

  $output = '<input  type="text" name="FSN_NUMBER" class="form-control input-sm " style=" font-family: \'Kanit\', sans-serif;" value="'.$infoasset->ARTICLE_NUM.'" />
  <input type="hidden" type="text" name="ASSET_ID" value="'.$id.'" />
  <input type="hidden" type="text" name="ID_SUP" value="'.$infoasset->ID.'" />';



echo $output;

}


public function detailfsn_save(Request $request)
{
 
     $idasset = $request->ASSET_ID;
     $idsup  = $request->ID_SUP;

     $check = DB::table('asset_article')->where('ARTICLE_NUM','=',$request->FSN_NUMBER)->count();

     $infoasset = DB::table('asset_article')->where('ARTICLE_ID','=',$idasset)->first();

    $addinfoarticle = new Assetarticle(); 
    $addinfoarticle->ARTICLE_NUM = $request->FSN_NUMBER;
    $addinfoarticle->YEAR_ID = $infoasset->YEAR_ID;
    $addinfoarticle->ARTICLE_NAME = $infoasset->ARTICLE_NAME;
    $addinfoarticle->ARTICLE_PROP = $infoasset->ARTICLE_PROP;
    $addinfoarticle->UNIT_ID = $infoasset->UNIT_ID;
    $addinfoarticle->SERIAL_NO = $infoasset->SERIAL_NO;
    $addinfoarticle->BRAND_ID = $infoasset->BRAND_ID;
    $addinfoarticle->COLOR_ID = $infoasset->COLOR_ID;
    $addinfoarticle->MODEL_ID = $infoasset->MODEL_ID;
    $addinfoarticle->SIZE_ID = $infoasset->SIZE_ID;
    $addinfoarticle->PRICE_PER_UNIT = $infoasset->PRICE_PER_UNIT;
    $addinfoarticle->RECEIVE_DATE = $infoasset->RECEIVE_DATE;
    $addinfoarticle->METHOD_ID = $infoasset->METHOD_ID;
    $addinfoarticle->BUY_ID = $infoasset->BUY_ID;
    $addinfoarticle->BUDGET_ID = $infoasset->BUDGET_ID;
    $addinfoarticle->TYPE_ID = $infoasset->TYPE_ID;
    $addinfoarticle->DECLINE_ID = $infoasset->DECLINE_ID;
    $addinfoarticle->VENDOR_ID = $infoasset->VENDOR_ID;
    $addinfoarticle->DEP_ID = $infoasset->DEP_ID;
    $addinfoarticle->LOCATION_ID = $infoasset->LOCATION_ID;
    $addinfoarticle->LOCATION_LEVEL_ID = $infoasset->LOCATION_LEVEL_ID;
    $addinfoarticle->LEVEL_ROOM_ID = $infoasset->LEVEL_ROOM_ID;
    $addinfoarticle->PERSON_ID = $infoasset->PERSON_ID;
    $addinfoarticle->REMARK = $infoasset->REMARK;
    $addinfoarticle->STATUS_ID = $infoasset->STATUS_ID;
    $addinfoarticle->OLD_USE = $infoasset->OLD_USE;

    $addinfoarticle->EXPIRE_DATE = $infoasset->EXPIRE_DATE;

    $addinfoarticle->PM_TYPE_ID = $infoasset->PM_TYPE_ID;
    $addinfoarticle->CAL_TYPE_ID = $infoasset->CAL_TYPE_ID;
    $addinfoarticle->RISK_TYPE_ID = $infoasset->RISK_TYPE_ID;
  
    $addinfoarticle->OPENS = 'False';
    $addinfoarticle->SUP_FSN = $infoasset->SUP_FSN;

    $addinfoarticle->IMG = $infoasset->IMG;   
       
    if($check == 0){
        $addinfoarticle->save();
    }
    


    return redirect()->route('massete.suppliesinfoarticle_suppliesinfo',[
        'id' =>   $idsup ,
    ]);
}


//=====ลบครุภัณฑ์

public function destroysuppliesinfoinassetsub($id,$asstid) { 
                
    Assetarticle::destroy($asstid); 


    return redirect()->route('massete.suppliesinfoarticle_suppliesinfo',[
        'id' => $id,
    ]);
}



}
