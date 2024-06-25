<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\support\Facades\Hash;
use Illuminate\support\Facades\Validator;
use App\Models\User;
use App\Models\Acc_debtor;
use App\Models\Pttype_eclaim;
use App\Models\Account_listpercen;
use App\Models\Leave_month;
use App\Models\Acc_debtor_stamp;
use App\Models\Acc_debtor_sendmoney;
use App\Models\Pttype;
use App\Models\Pttype_acc; 
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
use App\Models\Acc_stm_prb;
use App\Models\Acc_stm_ti_totalhead;
use App\Models\Acc_stm_ti_excel;
use App\Models\Acc_stm_ofc;
use App\Models\acc_stm_ofcexcel;
use App\Models\Air_repaire;
use App\Models\Air_list;
use App\Models\Product_buy;
use App\Models\Fire_pramuan;
use App\Models\Air_repaire_ploblemsub;
use App\Models\Fire_pramuan_sub;
use App\Models\Cctv_report_months;
use App\Models\Product_budget;
use App\Models\Fire_check;
use App\Models\Fire;
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
use Http;
use SoapClient;
use Str;
// use SplFileObject;
use Arr;
// use Storage;
use GuzzleHttp\Client;

use App\Imports\ImportAcc_stm_ti;
use App\Imports\ImportAcc_stm_tiexcel_import;
use App\Imports\ImportAcc_stm_ofcexcel_import;
use App\Imports\ImportAcc_stm_lgoexcel_import;
use App\Models\Acc_1102050101_217_stam;
use App\Models\Acc_opitemrece_stm;

use SplFileObject;
use PHPExcel;
use PHPExcel_IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\IOFactory;

date_default_timezone_set("Asia/Bangkok");


class AirController extends Controller
 { 
    
    public function air_main(Request $request)
    {
        $datenow = date('Y-m-d');
        $months = date('m');
        $year = date('Y'); 
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $datashow = DB::select('SELECT * FROM air_list ORDER BY air_list_id DESC'); 
        // WHERE active="Y"
        return view('support_prs.air.air_main',[
            'startdate'     => $startdate,
            'enddate'       => $enddate, 
            'datashow'      => $datashow,
        ]);
    }
    public function air_repaire(Request $request, $id)
    { 
        // $data_count = Fire::where('fire_num','=', $id)->count(); 
        // if ($data_count < 1) {
 
        // } else {
            $datenow   = date('Y-m-d');
            $months    = date('m');
            $year      = date('Y'); 
            $startdate = $request->startdate;
            $enddate   = $request->enddate;
            $newweek   = date('Y-m-d', strtotime($datenow . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
            $newDate   = date('Y-m-d', strtotime($datenow . ' -3 months')); //ย้อนหลัง 3 เดือน
            $data_detail = Air_repaire::leftJoin('users', 'air_repaire.air_tech_id', '=', 'users.id') 
            ->leftJoin('air_list', 'air_list.air_list_id', '=', 'air_repaire.air_list_id') 
            ->where('air_list.air_list_id', '=', $id)
            ->get();
            $data['air_repaire_ploblem']     = DB::table('air_repaire_ploblem')->get();
            $data['users']                   = DB::table('users')->get();
            $data['users_tech']              = DB::table('users')->where('dep_id','=','1')->get();
            $data['air_tech']                = DB::table('air_tech')->where('air_type','=','IN')->get();
            $data_detail_ = Air_list::where('air_list_id', '=', $id)->first();
            // $signat = $data_detail_->air_img_base;
            // $pic_fire = base64_encode(file_get_contents($signat)); 
            $air_no = DB::connection('mysql6')->select(
                'SELECT * from informrepair_index 
                WHERE REPAIR_STATUS ="RECEIVE" AND TECH_RECEIVE_DATE BETWEEN "'.$newDate.'" AND "'.$datenow.'" ORDER BY REPAIR_ID ASC'); 
            // REPAIR_SYSTEM ="1" AND 
            return view('support_prs.air.air_repaire',$data, [
                // 'dataprint'    => $dataprint,
                'data_detail'   => $data_detail,
                'data_detail_'  => $data_detail_,
                'air_no'        => $air_no,
                'id'            => $id
            ]); 
    }
    public function air_repaire_edit(Request $request,$id)
    {  
        $data['department_sub_sub'] = Department_sub_sub::get();
        $data['article_status']     = Article_status::get();
        $data['product_decline']    = Product_decline::get();
        $data['product_prop']       = Product_prop::get();
        $data['supplies_prop']      = DB::table('supplies_prop')->get();
        $data['budget_year']        = DB::table('budget_year')->where('active','=',true)->orderBy('leave_year_id', 'DESC')->get();
        $data['product_data']       = Products::get();
        $data['product_category']   = Products_category::get();
        $data['product_type']       = Products_type::get();
        $data['product_spyprice']   = Product_spyprice::get();
        $data['product_group']      = Product_group::get();
        $data['product_unit']       = Product_unit::get();
        $data['data_province']      = DB::table('data_province')->get();
        $data['data_amphur']        = DB::table('data_amphur')->get();
        $data['data_tumbon']        = DB::table('data_tumbon')->get(); 
        $data['land_data']          = DB::table('land_data')->get();
        $data['product_budget']     = Product_budget::get(); 
        $data['product_buy']        = Product_buy::get();
        $data['users']              = User::get();
        $data['users_tech']              = DB::table('users')->where('dep_id','=','1')->get(); 
        $data['air_tech']                = DB::table('air_tech')->where('air_type','=','IN')->get();
        $data['products_vendor']    = Products_vendor::get(); 
        $data['product_brand']      = DB::table('product_brand')->get();
        $data['medical_typecat']    = DB::table('medical_typecat')->get();
        $data['building_data']      = DB::table('building_data')->get(); 
        $data_detail_ = Air_repaire::leftJoin('users', 'air_repaire.air_tech_id', '=', 'users.id') 
        ->leftJoin('air_list', 'air_list.air_list_id', '=', 'air_repaire.air_list_id') 
        ->where('air_repaire.air_repaire_id', '=', $id)
        ->first();
        $data_edit                  = Air_repaire::where('air_repaire_id', '=', $id)->first();
        // $signat                     = $data_edit->signature; 
        // $signature                  = base64_encode(file_get_contents($signat));
        // $signat2                    = $data_edit->signature2; 
        // $signature2                 = base64_encode(file_get_contents($signat2));
        // $signat3                    = $data_edit->signature3; 
        if ($data_edit->signature != '') {
            $signature            = base64_encode(file_get_contents($data_edit->signature));
        }else {
            $signature            = '';
        }
        if ($data_edit->signature2 != '') {
            $signature2            = base64_encode(file_get_contents($data_edit->signature2));
        }else {
            $signature2            = '';
        }
        if ($data_edit->signature3 != '') {
            $signature3            = base64_encode(file_get_contents($data_edit->signature3));
        }else {
            $signature3            = '';
        }             

        $air_no = DB::connection('mysql6')->select('SELECT * from informrepair_index WHERE REPAIR_SYSTEM ="1" AND REPAIR_STATUS ="RECEIVE" ORDER BY REPAIR_ID ASC'); 

        return view('support_prs.air.air_repaire_edit', $data,[
            'data_detail_'     => $data_detail_,
            'data_edit'        => $data_edit,
            'signature'        => $signature,
            'signature2'       => $signature2,
            'signature3'       => $signature3,
            'air_no'           => $air_no,
        ]);
    }
    public function air_repiare_update(Request $request)
    {
        $date_now    = date('Y-m-d');
        $add_img     = $request->input('signature');
        $add_img2    = $request->input('signature2');
        $add_img3    = $request->input('signature3');
        $id          = $request->input('air_repaire_id');

        $data_edit   = Air_repaire::where('air_repaire_id', '=', $id)->first();
        $idarticle   = $request->air_repaire_no; 
        $air_no = DB::connection('mysql6')->table('informrepair_index')->where('ID', '=', $idarticle)->first();
        // foreach ($air_no as $key => $value) {
                $repaire_id  = $air_no->REPAIR_ID;
                $repaire_num = $air_no->ARTICLE_ID;
        // }
        $data_2 = $request->air_2; 
        if ($data_2 == 'on') {
            $update = Air_repaire::find($id);
            $update->repaire_date        = $date_now;
            $update->air_repaire_no      = $repaire_id;
            $update->air_repaire_num     = $repaire_num;
            $update->air_list_id         = $request->air_list_id;
            $update->air_list_num        = $request->air_list_num;
            $update->air_list_name       = $request->air_list_name;
            $update->btu                 = $request->btu;
            $update->serial_no           = $request->serial_no;
            $update->air_location_id     = $request->air_location_id;
            $update->air_location_name   = $request->air_location_name;

            $update->air_problems_1      = $request->input('air_problems_1'); 
            $update->air_problems_2      = $request->air_problems_2;
            $update->air_problems_3      = $request->air_problems_3;
            $update->air_problems_4      = $request->air_problems_4;
            $update->air_problems_5      = $request->air_problems_5;
            $update->air_problems_6      = $request->air_problems_6;
            $update->air_problems_7      = $request->air_problems_7;
            $update->air_problems_8      = $request->air_problems_8;
            $update->air_problems_9      = $request->air_problems_9;
            $update->air_problems_10     = $request->air_problems_10;
            $update->air_problems_11     = $request->air_problems_11;
            $update->air_problems_12     = $request->air_problems_12;
            $update->air_problems_13     = $request->air_problems_13;
            $update->air_problems_14     = $request->air_problems_14;
            $update->air_problems_15     = $request->air_problems_15;
            $update->air_problems_16     = $request->air_problems_16;
            $update->air_problems_17     = $request->air_problems_17;
            $update->air_problems_18     = $request->air_problems_18;
            $update->air_problems_19     = $request->air_problems_19;
            $update->air_problems_20     = $request->air_problems_20;
            $update->air_problems_orther     = $request->air_problems_orther;
            $update->air_problems_orthersub  = $request->air_problems_orthersub;
            $update->signature           = $add_img;
            // $update->signature2          = $add_img2;
            // $update->signature3          = $add_img3;

            $update->air_status_techout  = $request->air_status_techout; 
            $update->air_techout_name    = $request->air_techout_name;  
            // $update->air_status_staff    = $request->air_status_staff;   
            // $update->air_staff_id        = $request->air_staff_id; 
            // $update->air_status_tech     = $request->air_status_tech; 
            // $update->air_tech_id         = $request->air_tech_id; 

            $update->save();   
        
            if ($request->air_status_techout == 'N' || $request->air_status_staff == 'N' || $request->air_status_tech == 'N') {
                Air_list::where('air_list_id', '=', $request->air_list_id)->update(['active' => 'N']); 
            } else {
                Air_list::where('air_list_id', '=', $request->air_list_id)->update(['active' => 'Y']); 
            }
        } else {
            if ($add_img =='') {
                // $checkcount   = Air_repaire::where('air_repaire_id', '=', $id)->where('signature', '=', '')->count();
                // if ($checkcount > 0) { 
                    return response()->json([
                        'status'     => '50'
                    ]);              
                // }            
            } else if ($add_img2 =='') {
                // $checkcount2   = Air_repaire::where('air_repaire_id', '=', $id)->where('signature2', '=', '')->count();
                // if ($checkcount2 > 0) { 
                    return response()->json([
                        'status'     => '60'
                    ]);  
                // }    
            } else if ($add_img3 =='') {
                // $checkcount3   = Air_repaire::where('air_repaire_id', '=', $id)->where('signature3', '=', '')->count();
                // if ($checkcount3 > 0) { 
                    return response()->json([
                        'status'     => '70'
                    ]);      
                // }  
            } else {       
                  
                    $update = Air_repaire::find($id);
                    $update->repaire_date        = $date_now;
                    $update->air_repaire_no      = $repaire_id;
                    $update->air_repaire_num     = $repaire_num;
                    $update->air_list_id         = $request->air_list_id;
                    $update->air_list_num        = $request->air_list_num;
                    $update->air_list_name       = $request->air_list_name;
                    $update->btu                 = $request->btu;
                    $update->serial_no           = $request->serial_no;
                    $update->air_location_id     = $request->air_location_id;
                    $update->air_location_name   = $request->air_location_name;

                    $update->air_problems_1      = $request->input('air_problems_1'); 
                    $update->air_problems_2      = $request->air_problems_2;
                    $update->air_problems_3      = $request->air_problems_3;
                    $update->air_problems_4      = $request->air_problems_4;
                    $update->air_problems_5      = $request->air_problems_5;
                    $update->air_problems_6      = $request->air_problems_6;
                    $update->air_problems_7      = $request->air_problems_7;
                    $update->air_problems_8      = $request->air_problems_8;
                    $update->air_problems_9      = $request->air_problems_9;
                    $update->air_problems_10     = $request->air_problems_10;
                    $update->air_problems_11     = $request->air_problems_11;
                    $update->air_problems_12     = $request->air_problems_12;
                    $update->air_problems_13     = $request->air_problems_13;
                    $update->air_problems_14     = $request->air_problems_14;
                    $update->air_problems_15     = $request->air_problems_15;
                    $update->air_problems_16     = $request->air_problems_16;
                    $update->air_problems_17     = $request->air_problems_17;
                    $update->air_problems_18     = $request->air_problems_18;
                    $update->air_problems_19     = $request->air_problems_19;
                    $update->air_problems_20     = $request->air_problems_20;
                    $update->air_problems_orther     = $request->air_problems_orther;
                    $update->air_problems_orthersub  = $request->air_problems_orthersub;
                    $update->signature           = $add_img;
                    $update->signature2          = $add_img2;
                    $update->signature3          = $add_img3;

                    $update->air_status_techout  = $request->air_status_techout; 
                    $update->air_techout_name    = $request->air_techout_name;  
                    $update->air_status_staff    = $request->air_status_staff;   
                    $update->air_staff_id        = $request->air_staff_id; 
                    $update->air_status_tech     = $request->air_status_tech; 
                    $update->air_tech_id         = $request->air_tech_id; 

                    $update->save();   
                
                    if ($request->air_status_techout == 'N' || $request->air_status_staff == 'N' || $request->air_status_tech == 'N') {
                        Air_list::where('air_list_id', '=', $request->air_list_id)->update(['active' => 'N']); 
                    } else {
                        Air_list::where('air_list_id', '=', $request->air_list_id)->update(['active' => 'Y']); 
                    }
                }
        }
        
        return response()->json([
            'status'     => '200'
        ]);      
    }
    public function air_main_repaire_destroy(Request $request,$id)
    {
        $del = Air_repaire::find($id);  
        $del->delete();  

        return response()->json(['status' => '200']);
    }
    public function air_repiare_save(Request $request)
    {
        $date_now = date('Y-m-d');
        $add_img  = $request->input('signature');
        $add_img2 = $request->input('signature2');
        $add_img3 = $request->input('signature3');
          
        if ($add_img =='') {
            return response()->json([
                'status'     => '50'
            ]);
        } else if ($add_img2 =='') {
            return response()->json([
                'status'     => '60'
            ]);
        } else { 
                $add = new Air_repaire();
                $add->repaire_date        = $date_now;
                $add->air_num             = $request->air_num;
                $add->air_repaire_no      = $request->air_repaire_no;
                $add->air_list_id         = $request->air_list_id;
                $add->air_list_num        = $request->air_list_num;
                $add->air_list_name       = $request->air_list_name;
                $add->btu                 = $request->btu;
                $add->serial_no           = $request->serial_no;
                $add->air_location_id     = $request->air_location_id;
                $add->air_location_name   = $request->air_location_name;

                $add->air_problems_1      = $request->air_problems_1;
                $add->air_problems_2      = $request->air_problems_2;
                $add->air_problems_3      = $request->air_problems_3;
                $add->air_problems_4      = $request->air_problems_4;
                $add->air_problems_5      = $request->air_problems_5;
                $add->air_problems_6      = $request->air_problems_6;
                $add->air_problems_7      = $request->air_problems_7;
                $add->air_problems_8      = $request->air_problems_8;
                $add->air_problems_9      = $request->air_problems_9;
                $add->air_problems_10     = $request->air_problems_10;
                $add->air_problems_11     = $request->air_problems_11;
                $add->air_problems_12     = $request->air_problems_12;
                $add->air_problems_13     = $request->air_problems_13;
                $add->air_problems_14     = $request->air_problems_14;
                $add->air_problems_15     = $request->air_problems_15;
                $add->air_problems_16     = $request->air_problems_16;
                $add->air_problems_17     = $request->air_problems_17;
                $add->air_problems_18     = $request->air_problems_18;
                $add->air_problems_19     = $request->air_problems_19;
                $add->air_problems_20     = $request->air_problems_20;
                $add->air_problems_orther     = $request->air_problems_orther;
                $add->air_problems_orthersub  = $request->air_problems_orthersub;

                $add->signature           = $add_img;
                $add->signature2          = $add_img2;
                $add->signature3          = $add_img3;

                $add->air_status_techout  = $request->air_status_techout; 
                $add->air_techout_name    = $request->air_techout_name;  
                $add->air_status_staff    = $request->air_status_staff;   
                $add->air_staff_id        = $request->air_staff_id; 
                $add->air_status_tech     = $request->air_status_tech; 
                $add->air_tech_id         = $request->air_tech_id; 
                
                $add->save();
                return response()->json([
                    'status'     => '200'
                ]);
        }

       
        
    }
    public function air_main_repaire(Request $request)
    {
        $datenow   = date('Y-m-d');
        $months    = date('m');
        $year      = date('Y'); 
        $startdate = $request->startdate;
        $enddate   = $request->enddate;
        $newweek   = date('Y-m-d', strtotime($datenow . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate   = date('Y-m-d', strtotime($datenow . ' -1 months')); //ย้อนหลัง 1 เดือน
        $newyear   = date('Y-m-d', strtotime($datenow . ' -1 year')); //ย้อนหลัง 1 ปี 
        if ($startdate =='') {
            $datashow = DB::select(
                'SELECT a.* ,al.air_imgname,al.active,al.detail,concat(p.fname," ",p.lname) as ptname,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = a.air_tech_id) as tectname
                FROM air_repaire a
                LEFT JOIN air_list al ON al.air_list_id = a.air_list_id
                 LEFT JOIN users p ON p.id = a.air_staff_id 
                 WHERE a.repaire_date BETWEEN "'.$newDate.'" AND "'.$datenow.'"
                ORDER BY air_repaire_id DESC
            '); 
        } else {
            $datashow = DB::select(
                'SELECT a.* ,al.air_imgname,al.active,al.detail,concat(p.fname," ",p.lname) as ptname,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = a.air_tech_id) as tectname
                FROM air_repaire a
                LEFT JOIN air_list al ON al.air_list_id = a.air_list_id
                LEFT JOIN users p ON p.id = a.air_staff_id 
                WHERE a.repaire_date BETWEEN "'.$startdate.'" AND "'.$enddate.'"
                ORDER BY air_repaire_id DESC
            '); 
        }
        
       
        // WHERE active="Y"
        return view('support_prs.air.air_main_repaire',[
            'startdate'     => $startdate,
            'enddate'       => $enddate, 
            'datashow'      => $datashow,
        ]);
    }
    public function air_report_type(Request $request)
    {
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $months         = date('m');
        $year           = date('Y'); 
        $startdate      = $request->startdate;
        $enddate        = $request->enddate;
        $repaire_type   = $request->air_repaire_type;
       
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -1 months')); //ย้อนหลัง 1 เดือน
        $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี 

        if ($repaire_type == '1') {
            $datashow  = DB::select(
                'SELECT a.air_repaire_id,a.repaire_date as repaire_date,concat(a.air_list_num," ",a.air_list_name) as air_list,a.btu as btu,a.air_location_name as air_location_name,al.detail as debsubsub
                    ,a.air_problems_1 as problems_1 ,a.air_problems_2 as problems_2 ,a.air_problems_3 as problems_3 ,a.air_problems_4 as problems_4 ,a.air_problems_5 as problems_5
                    ,al.air_imgname,al.active,concat(p.fname," ",p.lname) as staff_name
                    ,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = a.air_tech_id) as tect_name
                    ,a.air_techout_name,a.air_list_num
                   
                    FROM air_repaire a
                    LEFT JOIN air_list al ON al.air_list_id = a.air_list_id
                    LEFT JOIN users p ON p.id = a.air_staff_id 
                    WHERE (a.air_problems_1 = "on" OR a.air_problems_2 = "on" OR a.air_problems_3 = "on" OR a.air_problems_4 = "on" OR a.air_problems_5 = "on")
                    AND a.repaire_date BETWEEN "'.$startdate.'" AND "'.$enddate.'" GROUP BY al.air_list_id
                ORDER BY air_repaire_id DESC
            '); 
            
            // นับปัญหา
              // $datas_count_1= DB::select('SELECT COUNT(air_repaire_id) c_air_list_num FROM air_repaire WHERE air_list_num = "'.$item->air_list_num.'" AND air_problems_1 ="on"');
              // foreach ($datas_count_1 as $key => $value) {
              //     $count_p1 = $value->c_air_list_num; 
              // }
              // $datas_count_1= DB::select('SELECT COUNT(air_repaire_id) c_air_list_num FROM air_repaire WHERE air_list_num = "'.$item->air_list_num.'" AND air_problems_1 ="on"');
              // foreach ($datas_count_1 as $key => $value) {
              //     $count_p1 = $value->c_air_list_num; 
              // }
 
        }else if ($repaire_type == '2') {
            $datashow  = DB::select(
                'SELECT a.air_repaire_id,a.repaire_date as repaire_date,concat(a.air_list_num," ",a.air_list_name) as air_list,a.btu as btu,a.air_location_name as air_location_name,al.detail as debsubsub
                    ,a.air_problems_6 as problems_1 ,a.air_problems_7 as problems_2 ,a.air_problems_8 as problems_3 ,a.air_problems_9 as problems_4 ,a.air_problems_10 as problems_5 
                    ,al.air_imgname,al.active,concat(p.fname," ",p.lname) as staff_name
                    ,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = a.air_tech_id) as tect_name
                    ,a.air_techout_name,a.air_list_num
                    FROM air_repaire a
                    LEFT JOIN air_list al ON al.air_list_id = a.air_list_id
                    LEFT JOIN users p ON p.id = a.air_staff_id 
                    WHERE (a.air_problems_6 = "on" OR a.air_problems_7 = "on" OR a.air_problems_8 = "on" OR a.air_problems_9 = "on" OR a.air_problems_10 = "on")
                    AND a.repaire_date BETWEEN "'.$startdate.'" AND "'.$enddate.'" GROUP BY al.air_list_id
                ORDER BY air_repaire_id DESC
            '); 
        }else if ($repaire_type == '3') {
            $datashow  = DB::select(
                'SELECT a.air_repaire_id,a.repaire_date as repaire_date,concat(a.air_list_num," ",a.air_list_name) as air_list,a.btu as btu,a.air_location_name as air_location_name,al.detail as debsubsub
                    ,a.air_problems_11 as problems_1 ,a.air_problems_12 as problems_2 ,a.air_problems_13 as problems_3 ,a.air_problems_14 as problems_4 ,a.air_problems_15 as problems_5 
                   ,al.air_imgname,al.active,concat(p.fname," ",p.lname) as staff_name
                    ,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = a.air_tech_id) as tect_name
                    ,a.air_techout_name,a.air_list_num
                    FROM air_repaire a
                    LEFT JOIN air_list al ON al.air_list_id = a.air_list_id
                    LEFT JOIN users p ON p.id = a.air_staff_id 
                    WHERE (a.air_problems_11 = "on" OR a.air_problems_12 = "on" OR a.air_problems_13 = "on" OR a.air_problems_14 = "on" OR a.air_problems_15 = "on")
                    AND a.repaire_date BETWEEN "'.$startdate.'" AND "'.$enddate.'" GROUP BY al.air_list_id
                ORDER BY air_repaire_id DESC
            '); 
        }else if ($repaire_type == '4') {
                $datashow  = DB::select(
                    'SELECT a.air_repaire_id,a.repaire_date as repaire_date,concat(a.air_list_num," ",a.air_list_name) as air_list,a.btu as btu,a.air_location_name as air_location_name,al.detail as debsubsub
                    ,a.air_problems_16 as problems_1 ,a.air_problems_17 as problems_2 ,a.air_problems_18 as problems_3 ,a.air_problems_19 as problems_4 ,a.air_problems_20 as problems_5 
                    ,al.air_imgname,al.active,concat(p.fname," ",p.lname) as staff_name
                    ,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = a.air_tech_id) as tect_name
                    ,a.air_techout_name,a.air_list_num
                        FROM air_repaire a
                        LEFT JOIN air_list al ON al.air_list_id = a.air_list_id
                        LEFT JOIN users p ON p.id = a.air_staff_id 
                        WHERE (a.air_problems_16 = "on" OR a.air_problems_17 = "on" OR a.air_problems_18 = "on" OR a.air_problems_19 = "on" OR a.air_problems_20 = "on")
                        AND a.repaire_date BETWEEN "'.$startdate.'" AND "'.$enddate.'" GROUP BY al.air_list_id
                    ORDER BY air_repaire_id DESC
                '); 
        } else {
            $datashow  = DB::select(
                'SELECT a.air_repaire_id,a.repaire_date as repaire_date,concat(a.air_list_num," ",a.air_list_name) as air_list,a.btu as btu,a.air_location_name as air_location_name,al.detail as debsubsub
                    ,a.air_problems_1 as problems_1 ,a.air_problems_2 as problems_2 ,a.air_problems_3 as problems_3 ,a.air_problems_4 as problems_4 ,a.air_problems_5 as problems_5
                   ,al.air_imgname,al.active,concat(p.fname," ",p.lname) as staff_name
                    ,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = a.air_tech_id) as tect_name
                    ,a.air_techout_name,a.air_list_num
                    FROM air_repaire a
                    LEFT JOIN air_list al ON al.air_list_id = a.air_list_id
                    LEFT JOIN users p ON p.id = a.air_staff_id 
                    WHERE (a.air_problems_1 = "on" OR a.air_problems_2 = "on" OR a.air_problems_3 = "on" OR a.air_problems_4 = "on" OR a.air_problems_5 = "on")
                    AND a.repaire_date BETWEEN "'.$startdate.'" AND "'.$enddate.'" GROUP BY al.air_list_id
                ORDER BY air_repaire_id DESC
            '); 
        }
         

        $data['air_repaire_type']      = DB::table('air_repaire_type')->get();

        return view('support_prs.air.air_report_type',$data,[
            'startdate'     => $startdate,
            'enddate'       => $enddate, 
            'datashow'      => $datashow,
            'repaire_type'  => $repaire_type,
            
        ]);
    }
    public function air_report_typesub(Request $request,$id,$air_repaire_type,$startdate,$enddate)
    {
        $date = date('Y-m-d'); 
        $data_edit         = Air_repaire::where('air_repaire_id', '=', $id)->first();
        $air_list_id       = $data_edit->air_list_id;
        $air_list          = $data_edit->air_list_num.'   '.$data_edit->air_list_name;
        
        if ($air_repaire_type == '1') {
            $datashow  = DB::select(
                'SELECT a.air_repaire_id,a.repaire_date as repaire_date,concat(a.air_list_num," ",a.air_list_name) as air_list,a.btu as btu,a.air_location_name as air_location_name,al.detail as debsubsub
                    ,a.air_problems_1 as problems_1 ,a.air_problems_2 as problems_2 ,a.air_problems_3 as problems_3 ,a.air_problems_4 as problems_4 ,a.air_problems_5 as problems_5
                    ,al.air_imgname,al.active,concat(p.fname," ",p.lname) as staff_name
                    ,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = a.air_tech_id) as tect_name
                    ,a.air_techout_name,a.air_list_num
                   
                    FROM air_repaire a
                    LEFT JOIN air_list al ON al.air_list_id = a.air_list_id
                    LEFT JOIN users p ON p.id = a.air_staff_id 
                    WHERE (a.air_problems_1 = "on" OR a.air_problems_2 = "on" OR a.air_problems_3 = "on" OR a.air_problems_4 = "on" OR a.air_problems_5 = "on")
                    AND a.repaire_date BETWEEN "'.$startdate.'" AND "'.$enddate.'" GROUP BY al.air_list_id
                ORDER BY air_repaire_id DESC
            ');  
            $datashow_sub  = DB::select(
                'SELECT a.air_repaire_id,a.repaire_date as repaire_date,concat(a.air_list_num," ",a.air_list_name) as air_list,a.btu as btu,a.air_location_name as air_location_name,al.detail as debsubsub
                    ,a.air_problems_1 as problems_1 ,a.air_problems_2 as problems_2 ,a.air_problems_3 as problems_3 ,a.air_problems_4 as problems_4 ,a.air_problems_5 as problems_5
                    ,al.air_imgname,al.active,concat(p.fname," ",p.lname) as staff_name
                    ,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = a.air_tech_id) as tect_name
                    ,a.air_techout_name,a.air_list_num
                   
                    FROM air_repaire a
                    LEFT JOIN air_list al ON al.air_list_id = a.air_list_id
                    LEFT JOIN users p ON p.id = a.air_staff_id 
                    WHERE (a.air_problems_1 = "on" OR a.air_problems_2 = "on" OR a.air_problems_3 = "on" OR a.air_problems_4 = "on" OR a.air_problems_5 = "on")
                    AND a.repaire_date BETWEEN "'.$startdate.'" AND "'.$enddate.'" AND a.air_list_id ="'.$air_list_id.'"
                ORDER BY air_repaire_id DESC
            ');  
 
        }else if ($air_repaire_type == '2') {
            $datashow  = DB::select(
                'SELECT a.air_repaire_id,a.repaire_date as repaire_date,concat(a.air_list_num," ",a.air_list_name) as air_list,a.btu as btu,a.air_location_name as air_location_name,al.detail as debsubsub
                    ,a.air_problems_6 as problems_1 ,a.air_problems_7 as problems_2 ,a.air_problems_8 as problems_3 ,a.air_problems_9 as problems_4 ,a.air_problems_10 as problems_5 
                    ,al.air_imgname,al.active,concat(p.fname," ",p.lname) as staff_name
                    ,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = a.air_tech_id) as tect_name
                    ,a.air_techout_name,a.air_list_num
                    FROM air_repaire a
                    LEFT JOIN air_list al ON al.air_list_id = a.air_list_id
                    LEFT JOIN users p ON p.id = a.air_staff_id 
                    WHERE (a.air_problems_6 = "on" OR a.air_problems_7 = "on" OR a.air_problems_8 = "on" OR a.air_problems_9 = "on" OR a.air_problems_10 = "on")
                    AND a.repaire_date BETWEEN "'.$startdate.'" AND "'.$enddate.'" GROUP BY al.air_list_id
                ORDER BY air_repaire_id DESC
            '); 
            $datashow_sub  = DB::select(
                'SELECT a.air_repaire_id,a.repaire_date as repaire_date,concat(a.air_list_num," ",a.air_list_name) as air_list,a.btu as btu,a.air_location_name as air_location_name,al.detail as debsubsub
                    ,a.air_problems_6 as problems_1 ,a.air_problems_7 as problems_2 ,a.air_problems_8 as problems_3 ,a.air_problems_9 as problems_4 ,a.air_problems_10 as problems_5 
                    ,al.air_imgname,al.active,concat(p.fname," ",p.lname) as staff_name
                    ,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = a.air_tech_id) as tect_name
                    ,a.air_techout_name,a.air_list_num
                   
                    FROM air_repaire a
                    LEFT JOIN air_list al ON al.air_list_id = a.air_list_id
                    LEFT JOIN users p ON p.id = a.air_staff_id 
                    WHERE (a.air_problems_6 = "on" OR a.air_problems_7 = "on" OR a.air_problems_8 = "on" OR a.air_problems_9 = "on" OR a.air_problems_10 = "on")
                    AND a.repaire_date BETWEEN "'.$startdate.'" AND "'.$enddate.'" AND a.air_list_id ="'.$air_list_id.'"
                ORDER BY air_repaire_id DESC
            '); 
        }else if ($air_repaire_type == '3') {
            $datashow  = DB::select(
                'SELECT a.air_repaire_id,a.repaire_date as repaire_date,concat(a.air_list_num," ",a.air_list_name) as air_list,a.btu as btu,a.air_location_name as air_location_name,al.detail as debsubsub
                    ,a.air_problems_11 as problems_1 ,a.air_problems_12 as problems_2 ,a.air_problems_13 as problems_3 ,a.air_problems_14 as problems_4 ,a.air_problems_15 as problems_5 
                   ,al.air_imgname,al.active,concat(p.fname," ",p.lname) as staff_name
                    ,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = a.air_tech_id) as tect_name
                    ,a.air_techout_name,a.air_list_num
                    FROM air_repaire a
                    LEFT JOIN air_list al ON al.air_list_id = a.air_list_id
                    LEFT JOIN users p ON p.id = a.air_staff_id 
                    WHERE (a.air_problems_11 = "on" OR a.air_problems_12 = "on" OR a.air_problems_13 = "on" OR a.air_problems_14 = "on" OR a.air_problems_15 = "on")
                    AND a.repaire_date BETWEEN "'.$startdate.'" AND "'.$enddate.'" GROUP BY al.air_list_id
                ORDER BY air_repaire_id DESC
            '); 
            $datashow_sub  = DB::select(
                'SELECT a.air_repaire_id,a.repaire_date as repaire_date,concat(a.air_list_num," ",a.air_list_name) as air_list,a.btu as btu,a.air_location_name as air_location_name,al.detail as debsubsub
                    ,a.air_problems_11 as problems_1 ,a.air_problems_12 as problems_2 ,a.air_problems_13 as problems_3 ,a.air_problems_14 as problems_4 ,a.air_problems_15 as problems_5 
                   ,al.air_imgname,al.active,concat(p.fname," ",p.lname) as staff_name
                    ,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = a.air_tech_id) as tect_name
                    ,a.air_techout_name,a.air_list_num
                    FROM air_repaire a
                    LEFT JOIN air_list al ON al.air_list_id = a.air_list_id
                    LEFT JOIN users p ON p.id = a.air_staff_id 
                    WHERE (a.air_problems_11 = "on" OR a.air_problems_12 = "on" OR a.air_problems_13 = "on" OR a.air_problems_14 = "on" OR a.air_problems_15 = "on")
                    AND a.repaire_date BETWEEN "'.$startdate.'" AND "'.$enddate.'" AND a.air_list_id ="'.$air_list_id.'"
                ORDER BY air_repaire_id DESC
            '); 
        }else if ($air_repaire_type == '4') {
                $datashow  = DB::select(
                    'SELECT a.air_repaire_id,a.repaire_date as repaire_date,concat(a.air_list_num," ",a.air_list_name) as air_list,a.btu as btu,a.air_location_name as air_location_name,al.detail as debsubsub
                    ,a.air_problems_16 as problems_1 ,a.air_problems_17 as problems_2 ,a.air_problems_18 as problems_3 ,a.air_problems_19 as problems_4 ,a.air_problems_20 as problems_5 
                    ,al.air_imgname,al.active,concat(p.fname," ",p.lname) as staff_name
                    ,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = a.air_tech_id) as tect_name
                    ,a.air_techout_name,a.air_list_num
                        FROM air_repaire a
                        LEFT JOIN air_list al ON al.air_list_id = a.air_list_id
                        LEFT JOIN users p ON p.id = a.air_staff_id 
                        WHERE (a.air_problems_16 = "on" OR a.air_problems_17 = "on" OR a.air_problems_18 = "on" OR a.air_problems_19 = "on" OR a.air_problems_20 = "on")
                        AND a.repaire_date BETWEEN "'.$startdate.'" AND "'.$enddate.'" GROUP BY al.air_list_id
                    ORDER BY air_repaire_id DESC
                '); 
                $datashow_sub  = DB::select(
                    'SELECT a.air_repaire_id,a.repaire_date as repaire_date,concat(a.air_list_num," ",a.air_list_name) as air_list,a.btu as btu,a.air_location_name as air_location_name,al.detail as debsubsub
                       ,a.air_problems_16 as problems_1 ,a.air_problems_17 as problems_2 ,a.air_problems_18 as problems_3 ,a.air_problems_19 as problems_4 ,a.air_problems_20 as problems_5 
                       ,al.air_imgname,al.active,concat(p.fname," ",p.lname) as staff_name
                        ,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = a.air_tech_id) as tect_name
                        ,a.air_techout_name,a.air_list_num
                        FROM air_repaire a
                        LEFT JOIN air_list al ON al.air_list_id = a.air_list_id
                        LEFT JOIN users p ON p.id = a.air_staff_id 
                        WHERE (a.air_problems_16 = "on" OR a.air_problems_17 = "on" OR a.air_problems_18 = "on" OR a.air_problems_19 = "on" OR a.air_problems_20 = "on")
                        AND a.repaire_date BETWEEN "'.$startdate.'" AND "'.$enddate.'" AND a.air_list_id ="'.$air_list_id.'"
                    ORDER BY air_repaire_id DESC
                '); 
        } else {
            $datashow  = DB::select(
                'SELECT a.air_repaire_id,a.repaire_date as repaire_date,concat(a.air_list_num," ",a.air_list_name) as air_list,a.btu as btu,a.air_location_name as air_location_name,al.detail as debsubsub
                    ,a.air_problems_1 as problems_1 ,a.air_problems_2 as problems_2 ,a.air_problems_3 as problems_3 ,a.air_problems_4 as problems_4 ,a.air_problems_5 as problems_5
                   ,al.air_imgname,al.active,concat(p.fname," ",p.lname) as staff_name
                    ,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = a.air_tech_id) as tect_name
                    ,a.air_techout_name,a.air_list_num
                    FROM air_repaire a
                    LEFT JOIN air_list al ON al.air_list_id = a.air_list_id
                    LEFT JOIN users p ON p.id = a.air_staff_id 
                    WHERE (a.air_problems_1 = "on" OR a.air_problems_2 = "on" OR a.air_problems_3 = "on" OR a.air_problems_4 = "on" OR a.air_problems_5 = "on")
                    AND a.repaire_date BETWEEN "'.$startdate.'" AND "'.$enddate.'" GROUP BY al.air_list_id
                ORDER BY air_repaire_id DESC
            '); 
            $datashow_sub  = DB::select(
                'SELECT a.air_repaire_id,a.repaire_date as repaire_date,concat(a.air_list_num," ",a.air_list_name) as air_list,a.btu as btu,a.air_location_name as air_location_name,al.detail as debsubsub
                  ,a.air_problems_1 as problems_1 ,a.air_problems_2 as problems_2 ,a.air_problems_3 as problems_3 ,a.air_problems_4 as problems_4 ,a.air_problems_5 as problems_5
                   ,al.air_imgname,al.active,concat(p.fname," ",p.lname) as staff_name
                    ,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = a.air_tech_id) as tect_name
                    ,a.air_techout_name,a.air_list_num
                    FROM air_repaire a
                    LEFT JOIN air_list al ON al.air_list_id = a.air_list_id
                    LEFT JOIN users p ON p.id = a.air_staff_id 
                    WHERE (a.air_problems_1 = "on" OR a.air_problems_2 = "on" OR a.air_problems_3 = "on" OR a.air_problems_4 = "on" OR a.air_problems_5 = "on")
                    AND a.repaire_date BETWEEN "'.$startdate.'" AND "'.$enddate.'" AND a.air_list_id ="'.$air_list_id.'"
                ORDER BY air_repaire_id DESC
            ');
        }
         

        $data['air_repaire_type']      = DB::table('air_repaire_type')->get();

        return view('support_prs.air.air_report_typesub',$data,[
            'startdate'     => $startdate,
            'enddate'       => $enddate, 
            'datashow'      => $datashow,
            'repaire_type'  => $air_repaire_type,
            'datashow_sub'  => $datashow_sub,
            'air_list'      => $air_list
            
        ]);
    }
   
    // *******************************************************************

    public function air_add(Request $request)
    { 
        $data['article_data']       = DB::select('SELECT * from article_data WHERE cctv="Y" order by article_id desc'); 
        $data['department_sub_sub'] = Department_sub_sub::get();
        $data['article_status']     = Article_status::get();
        $data['product_decline']    = Product_decline::get();
        $data['product_prop']       = Product_prop::get();
        $data['supplies_prop']      = DB::table('supplies_prop')->get();
        $data['budget_year']        = DB::table('budget_year')->orderBy('leave_year_id', 'DESC')->get();
        $data['product_data']       = Products::get();
        $data['product_category']   = Products_category::get();
        $data['product_type']       = Products_type::get();
        $data['product_spyprice']   = Product_spyprice::get();
        $data['product_group']      = Product_group::get();
        $data['product_unit']       = Product_unit::get();
        $data['data_province']      = DB::table('data_province')->get();
        $data['data_amphur']        = DB::table('data_amphur')->get();
        $data['data_tumbon']        = DB::table('data_tumbon')->get();
        // $data['land_data']      = Land::get();
        $data['land_data']          = DB::table('land_data')->get();
        $data['product_budget']     = Product_budget::get();
        // $data['product_method']     = Product_method::get();
        $data['building_data']      = DB::table('building_data')->get();
        $data['product_buy']        = Product_buy::get();
        $data['users']              = User::get(); 
        $data['products_vendor']    = Products_vendor::get();
        // $data['product_brand']   = Product_brand::get();
        $data['product_brand']      = DB::table('product_brand')->get();
        $data['medical_typecat']    = DB::table('medical_typecat')->get();

        return view('support_prs.air.air_add', $data);
    }
    public function air_save(Request $request)
    {
        $air_list_num = $request->air_list_num;
        $add = new Air_list();
        $add->air_year            = $request->air_year;
        $add->air_recive_date     = $request->air_recive_date;
        $add->air_list_num        = $air_list_num;
        $add->air_list_name       = $request->air_list_name;
        $add->air_price           = $request->air_price;
        $add->active              = $request->active;
        $add->serial_no           = $request->serial_no;
        $add->detail              = $request->detail; 
        $add->btu                 = $request->btu;  
        $add->air_room_class      = $request->air_room_class;   
    
        $locationid = $request->input('air_location_id');
        if ($locationid != '') {
            $losave = DB::table('building_data')->where('building_id', '=', $locationid)->first(); 
            $add->air_location_id = $losave->building_id;
            $add->air_location_name = $losave->building_name;
        } else { 
            $add->air_location_id = '';
            $add->air_location_name = '';
        }
        // brand_id
        $branid = $request->input('bran_id');
        if ($branid != '') {
            $bransave = DB::table('product_brand')->where('brand_id', '=', $branid)->first(); 
            $add->bran_id = $bransave->brand_id;
            $add->brand_name = $bransave->brand_name;
        } else { 
            $add->bran_id = '';
            $add->brand_name = '';
        }
 
        if ($request->hasfile('air_imgname')) {
            $image_64 = $request->file('air_imgname'); 
            // $image_64 = $data['fire_imgname']; //your base64 encoded data
            // $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[0])[0];   // .jpg .png .pdf            
            // $replace = substr($image_64, 0, strpos($image_64, ',')+1);             
            // // find substring fro replace here eg: data:image/png;base64,      
            // $image = str_replace($replace, '', $image_64);             
            // $image = str_replace(' ', '+', $image);             
            // $imageName = Str::random(10).'.'.$extension;
            // Storage::disk('public')->put($imageName, base64_decode($image));

            $extention = $image_64->getClientOriginalExtension(); 
            $filename = $air_list_num. '.' . $extention;
            $request->air_imgname->storeAs('air', $filename, 'public');    

            // $destinationPath = public_path('/fire/');
            // $image_64->move($destinationPath, $filename);
            $add->air_img            = $filename;
            $add->air_imgname        = $filename;
            // $add->fire_imgname        = $destinationPath . $filename;
            if ($extention =='.jpg') {
                $file64 = "data:image/jpg;base64,".base64_encode(file_get_contents($request->file('air_imgname')));
                // $file65 = base64_encode(file_get_contents($request->file('fire_imgname')->pat‌​h($image_path)));
            } else {
                $file64 = "data:image/png;base64,".base64_encode(file_get_contents($request->file('air_imgname')));
                // $file65 = base64_encode(file_get_contents($request->file('fire_imgname')->pat‌​h($image_path)));
            }                       
  
            $add->air_img_base       = $file64;
            // $add->fire_img_base_name  = $file65;
        }
 
        $add->save();
        return response()->json([
            'status'     => '200'
        ]);
    }
    public function air_edit(Request $request,$id)
    {  
        $data['department_sub_sub'] = Department_sub_sub::get();
        $data['article_status']     = Article_status::get();
        $data['product_decline']    = Product_decline::get();
        $data['product_prop']       = Product_prop::get();
        $data['supplies_prop']      = DB::table('supplies_prop')->get();
        $data['budget_year']        = DB::table('budget_year')->where('active','=',true)->orderBy('leave_year_id', 'DESC')->get();
        $data['product_data']       = Products::get();
        $data['product_category']   = Products_category::get();
        $data['product_type']       = Products_type::get();
        $data['product_spyprice']   = Product_spyprice::get();
        $data['product_group']      = Product_group::get();
        $data['product_unit']       = Product_unit::get();
        $data['data_province']      = DB::table('data_province')->get();
        $data['data_amphur']        = DB::table('data_amphur')->get();
        $data['data_tumbon']        = DB::table('data_tumbon')->get(); 
        $data['land_data']          = DB::table('land_data')->get();
        $data['product_budget']     = Product_budget::get(); 
        $data['product_buy']        = Product_buy::get();
        $data['users']              = User::get(); 
        $data['products_vendor']    = Products_vendor::get(); 
        $data['product_brand']      = DB::table('product_brand')->get();
        $data['medical_typecat']    = DB::table('medical_typecat')->get();
        $data['building_data']      = DB::table('building_data')->get();
        // $data_edit                  = Fire::where('fire_id', '=', $id)->first();
        $data_edit                  = Air_list::where('air_list_id', '=', $id)->first();
        
        // $signat                     = $data_edit->fire_img_base;
        // dd($signat); 
        // $pic_fire = base64_encode(file_get_contents($signat)); 
        // dd($pic_fire); 
        return view('support_prs.air.air_edit', $data,[
            'data_edit'    => $data_edit,
            // 'pic_fire'     => $pic_fire
        ]);
    }
    public function air_update(Request $request)
    { 
        $id = $request->air_list_id; 
        $air_list_num = $request->air_list_num;
        $update = Air_list::find($id);
        $update->air_year            = $request->air_year;
        $update->air_recive_date     = $request->air_recive_date;
        $update->air_list_num        = $air_list_num;
        $update->air_list_name       = $request->air_list_name;
        $update->air_price           = $request->air_price;
        $update->active              = $request->active;
        $update->serial_no           = $request->serial_no;
        $update->detail              = $request->detail; 
        $update->btu                 = $request->btu;  
        $update->air_room_class      = $request->air_room_class;  

        $locationid = $request->input('air_location_id');
        if ($locationid != '') {
            $losave = DB::table('building_data')->where('building_id', '=', $locationid)->first(); 
            $update->air_location_id = $losave->building_id;
            $update->air_location_name = $losave->building_name;
        } else { 
            $update->air_location_id = '';
            $update->air_location_name = '';
        }
        // brand_id
        $branid = $request->input('bran_id');
        if ($branid != '') {
            $bransave = DB::table('product_brand')->where('brand_id', '=', $branid)->first(); 
            $update->bran_id = $bransave->brand_id;
            $update->brand_name = $bransave->brand_name;
        } else { 
            $update->bran_id = '';
            $update->brand_name = '';
        }
 
        if ($request->hasfile('air_imgname')) {

            $description = 'storage/air/' . $update->air_imgname;
            if (File::exists($description)) {
                File::delete($description);
            }
            $image_64 = $request->file('air_imgname');  
            $extention = $image_64->getClientOriginalExtension(); 
            $filename = $air_list_num. '.' . $extention;
            $request->air_imgname->storeAs('air', $filename, 'public');    

            // $destinationPath = public_path('/fire/');
            // $image_64->move($destinationPath, $filename);
            $update->air_img            = $filename;
            $update->air_imgname        = $filename;
            // $update->fire_imgname = $destinationPath . $filename;
            if ($extention =='.jpg') {
                $file64 = "data:image/jpg;base64,".base64_encode(file_get_contents($request->file('air_imgname')));
                // $file65 = base64_encode(file_get_contents($request->file('fire_imgname')->pat‌​h($image_path)));
            } else {
                $file64 = "data:image/png;base64,".base64_encode(file_get_contents($request->file('air_imgname')));
                // $file65 = base64_encode(file_get_contents($request->file('fire_imgname')->pat‌​h($image_path)));
            }
            // $file64 = "data:image/png;base64,".base64_encode(file_get_contents($request->file('fire_imgname')));
            // $file65 = base64_encode(file_get_contents($request->file('fire_imgname')->pat‌​h($image_path)));
  
            $update->air_img_base       = $file64;
            // $update->fire_img_base_name  = $file65;
        }
 
        $update->save();
        return response()->json([
            'status'     => '200'
        ]);
    }

    public function air_destroy(Request $request,$id)
    {
        $del = Air_list::find($id);  
        $description = 'storage/air/'.$del->air_imgname;
        if (File::exists($description)) {
            File::delete($description);
        }
        $del->delete(); 
        // Fire::whereIn('fire_id',explode(",",$id))->delete();

        return response()->json(['status' => '200']);
    }
    
    public function fire_report_day(Request $request)
    {
        $startdate   = $request->startdate;
        $enddate     = $request->enddate;
        $date        = date('Y-m-d');
        $y           = date('Y') + 543;
        $months = date('m');
        $year = date('Y'); 
        $newdays     = date('Y-m-d', strtotime($date . ' -1 days')); //ย้อนหลัง 1 วัน
        $newweek     = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate     = date('Y-m-d', strtotime($date . ' -1 months')); //ย้อนหลัง 1 เดือน
        $newyear     = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี
        $iduser = Auth::user()->id;
        if ($startdate == '') {
            // $acc_debtor = Acc_debtor::where('stamp','=','N')->whereBetween('dchdate', [$datenow, $datenow])->get();
            $datashow = DB::select(
                'SELECT c.fire_num,c.fire_name,c.fire_check_color,c.fire_check_location,c.check_date,c.fire_check_injection,c.fire_check_joystick,c.fire_check_body,c.fire_check_gauge,c.fire_check_drawback,concat(s.fname," ",s.lname) ptname 
                FROM fire_check c
                LEFT JOIN users s ON s.id = c.user_id
                WHERE c.check_date BETWEEN "'.$newDate.'" AND "'.$date.'"
                GROUP BY c.check_date,c.fire_num                
                '); 
        } else {
            $datashow = DB::select(
                'SELECT c.fire_num,c.fire_name,c.fire_check_color,c.fire_check_location,c.check_date,c.fire_check_injection,c.fire_check_joystick,c.fire_check_body,c.fire_check_gauge,c.fire_check_drawback,concat(s.fname," ",s.lname) ptname 
                FROM fire_check c
                LEFT JOIN users s ON s.id = c.user_id
                WHERE c.check_date BETWEEN "'.$startdate.'" AND "'.$enddate.'"
                GROUP BY c.check_date,c.fire_num                
            ');  
        }
         
        return view('support_prs.fire.fire_report_day',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'datashow'    =>     $datashow, 
        ]);
    }
 
    public function air_qrcode(Request $request, $id)
    {

            $dataprint = Air_list::where('air_list_id', '=', $id)->first();
            // $dataprint = Fire::where('fire_id', '=', $id)->get();

        return view('support_prs.air.air_qrcode', [
            'dataprint'  =>  $dataprint
        ]);

    }
    public function air_qrcode_all(Request $request)
    {  
            $dataprint = Air_list::get();

        return view('support_prs.air.air_qrcode_all', [
            'dataprint'  =>  $dataprint
        ]);

    }
   
    public function air_qrcode_detail_all(Request $request)
    {  
            $dataprint_main = Air_list::get();
           
        return view('support_prs.air.air_qrcode_detail_all', [
            'dataprint_main'  =>  $dataprint_main,
            // 'dataprint'        =>  $dataprint
        ]);

    }
    public function air_qrcode_repaire(Request $request)
    {  
            $dataprint_main = Air_list::get();
           
        return view('support_prs.air.air_qrcode_repaire', [
            'dataprint_main'  =>  $dataprint_main,
            // 'dataprint'        =>  $dataprint
        ]);

    }

    public function air_report_building(Request $request)
    {
        $startdate   = $request->startdate;
        $enddate     = $request->enddate;
        $date        = date('Y-m-d');
        $y           = date('Y') + 543;
        $months = date('m');
   
        $newdays     = date('Y-m-d', strtotime($date . ' -1 days')); //ย้อนหลัง 1 วัน
        $newweek     = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate     = date('Y-m-d', strtotime($date . ' -1 months')); //ย้อนหลัง 1 เดือน
        $newyear     = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี
      
        $iduser = Auth::user()->id;
        $datashow = DB::select(
            'SELECT a.building_id,a.building_name 
                ,(SELECT COUNT(air_list_id) FROM air_list WHERE air_location_id = a.building_id) as qtyall
                ,(SELECT COUNT(air_list_id) FROM air_list WHERE air_location_id = a.building_id AND btu < "10000" )	as less_10000
                ,(SELECT COUNT(air_list_id) FROM air_list WHERE air_location_id = a.building_id AND btu BETWEEN "10001" AND "20000" )	as one_two 
                ,(SELECT COUNT(air_list_id) FROM air_list WHERE air_location_id = a.building_id AND btu BETWEEN "20001" AND "30000" )	as two_tree
                ,(SELECT COUNT(air_list_id) FROM air_list WHERE air_location_id = a.building_id AND btu BETWEEN "30001" AND "40000" )	as tree_four
                ,(SELECT COUNT(air_list_id) FROM air_list WHERE air_location_id = a.building_id AND btu BETWEEN "40001" AND "50000" )	as four_five
                ,(SELECT COUNT(air_list_id) FROM air_list WHERE air_location_id = a.building_id AND btu > "50001" )	as more_five
            FROM air_list al 
            LEFT JOIN building_data a ON a.building_id = al.air_location_id 
            GROUP BY a.building_id
            ORDER BY building_id ASC
        ');
        // if ($startdate == '') {
        //     $yearnew     = date('Y');
        //     $year_old    = date('Y')-1; 
        //     $startdate   = (''.$year_old.'-10-01');
        //     $enddate     = (''.$yearnew.'-09-30'); 
            // $datashow = DB::select(
            //     'SELECT a.air_location_name,a.air_location_id,al.detail as debsubsub 
            //         FROM air_repaire a
            //         LEFT JOIN air_list al ON al.air_list_id = a.air_list_id
            //         LEFT JOIN users p ON p.id = a.air_staff_id 
            //         WHERE a.repaire_date BETWEEN "'.$startdate.'" AND "'.$enddate.'"
            //         GROUP BY a.air_location_id
            //         ORDER BY air_location_id ASC 
            // '); 
        // } else {
        //     $datashow = DB::select(
        //         'SELECT a.air_location_name,a.air_location_id,al.detail as debsubsub 
        //             FROM air_repaire a
        //             LEFT JOIN air_list al ON al.air_list_id = a.air_list_id
        //             LEFT JOIN users p ON p.id = a.air_staff_id 
        //             WHERE a.repaire_date BETWEEN "'.$startdate.'" AND "'.$enddate.'"
        //             GROUP BY a.air_location_id
        //             ORDER BY air_location_id ASC           
        //     ');  
        // }
         
        return view('support_prs.air.air_report_building',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'datashow'    =>     $datashow, 
        ]);
    }
    public function air_report_building_sub(Request $request,$id)
    {
        $startdate   = $request->startdate;
        $enddate     = $request->enddate;
      
        $iduser = Auth::user()->id;
        $datashow = DB::select(
            'SELECT a.building_id,a.building_name 
                ,(SELECT COUNT(air_list_id) FROM air_list WHERE air_location_id = a.building_id) as qtyall
                ,(SELECT COUNT(air_list_id) FROM air_list WHERE air_location_id = a.building_id AND btu < "10000" )	as less_10000
                ,(SELECT COUNT(air_list_id) FROM air_list WHERE air_location_id = a.building_id AND btu BETWEEN "10001" AND "20000" )	as one_two 
                ,(SELECT COUNT(air_list_id) FROM air_list WHERE air_location_id = a.building_id AND btu BETWEEN "20001" AND "30000" )	as two_tree
                ,(SELECT COUNT(air_list_id) FROM air_list WHERE air_location_id = a.building_id AND btu BETWEEN "30001" AND "40000" )	as tree_four
                ,(SELECT COUNT(air_list_id) FROM air_list WHERE air_location_id = a.building_id AND btu BETWEEN "40001" AND "50000" )	as four_five
                ,(SELECT COUNT(air_list_id) FROM air_list WHERE air_location_id = a.building_id AND btu > "50001" )	as more_five
            FROM air_list al 
            LEFT JOIN building_data a ON a.building_id = al.air_location_id 
            GROUP BY a.building_id
            ORDER BY building_id ASC
        ');

        $datashow_sub = DB::select('SELECT * FROM air_list WHERE air_location_id = "'.$id.'" ORDER BY air_list_id DESC'); 
  
        return view('support_prs.air.air_report_building_sub',[
            'startdate'     => $startdate,
            'enddate'       => $enddate,
            'datashow'      => $datashow, 
            'datashow_sub'  => $datashow_sub,
        ]);
    }
    public function air_report_building_excel(Request $request)
    {
        $startdate   = $request->startdate;
        $enddate     = $request->enddate;
        $date        = date('Y-m-d');
        $y           = date('Y') + 543;
        $months = date('m');
        $dabudget_year = DB::table('budget_year')->where('active','=',true)->where('years_now','=','Y')->first();
        $data['ynow'] =  $dabudget_year->leave_year_id;
        $newdays     = date('Y-m-d', strtotime($date . ' -1 days')); //ย้อนหลัง 1 วัน
        $newweek     = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate     = date('Y-m-d', strtotime($date . ' -1 months')); //ย้อนหลัง 1 เดือน
        $newyear     = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี
      
        $iduser = Auth::user()->id;
        $datashow = DB::select(
            'SELECT a.building_id,a.building_name 
                ,(SELECT COUNT(air_list_id) FROM air_list WHERE air_location_id = a.building_id) as qtyall
                ,(SELECT COUNT(air_list_id) FROM air_list WHERE air_location_id = a.building_id AND btu < "10000" )	as less_10000
                ,(SELECT COUNT(air_list_id) FROM air_list WHERE air_location_id = a.building_id AND btu BETWEEN "10001" AND "20000" )	as one_two 
                ,(SELECT COUNT(air_list_id) FROM air_list WHERE air_location_id = a.building_id AND btu BETWEEN "20001" AND "30000" )	as two_tree
                ,(SELECT COUNT(air_list_id) FROM air_list WHERE air_location_id = a.building_id AND btu BETWEEN "30001" AND "40000" )	as tree_four
                ,(SELECT COUNT(air_list_id) FROM air_list WHERE air_location_id = a.building_id AND btu BETWEEN "40001" AND "50000" )	as four_five
                ,(SELECT COUNT(air_list_id) FROM air_list WHERE air_location_id = a.building_id AND btu > "50001" )	as more_five
            FROM air_list al 
            LEFT JOIN building_data a ON a.building_id = al.air_location_id 
            GROUP BY a.building_id
            ORDER BY building_id ASC
        '); 
        return view('support_prs.air.air_report_building_excel',$data,[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'datashow'    =>     $datashow, 
        ]);
    }
    public function air_report_problems(Request $request)
    {
        $startdate   = $request->startdate;
        $enddate     = $request->enddate;
        $date        = date('Y-m-d');
        $y           = date('Y') + 543;
        $months = date('m');
   
        $newdays     = date('Y-m-d', strtotime($date . ' -1 days')); //ย้อนหลัง 1 วัน
        $newweek     = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate     = date('Y-m-d', strtotime($date . ' -1 months')); //ย้อนหลัง 1 เดือน
        $newyear     = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี
      
        $iduser       = Auth::user()->id;
        $datashow     = DB::select('SELECT * FROM air_repaire_ploblem ORDER BY air_repaire_ploblem_id ASC');
        
        if ($startdate =='') { 
        } else {
                Air_repaire_ploblemsub::truncate();
                $data_process_1 = DB::select('SELECT air_list_num, COUNT(*) as air_problems_1 FROM air_repaire WHERE air_problems_1 = "on" AND repaire_date BETWEEN "'.$startdate.'" AND "'.$enddate.'" GROUP BY air_list_num HAVING COUNT(*) > 1');
                foreach ($data_process_1 as $key => $value) { 
                    $check_1 = Air_repaire_ploblemsub::where('air_list_num',$value->air_list_num)->count();
                    if ($check_1 > 0) {
                        Air_repaire_ploblemsub::where('air_list_num',$value->air_list_num)->update(['air_problems_1'=> $value->air_problems_1]);
                    } else {
                        $add = new Air_repaire_ploblemsub();
                        $add->air_repaire_ploblem_id  = '1';
                        $add->air_list_num            = $value->air_list_num;
                        $add->air_problems_1          = $value->air_problems_1;
                        $add->repaire_date_start      = $startdate;
                        $add->repaire_date_end        = $enddate;
                        $add->save(); 
                    } 
                }
                $data_process_2 = DB::select('SELECT air_list_num, COUNT(*) as air_problems_2 FROM air_repaire WHERE air_problems_2 = "on" AND repaire_date BETWEEN "'.$startdate.'" AND "'.$enddate.'" GROUP BY air_list_num HAVING COUNT(*) > 1');
                foreach ($data_process_2 as $key => $value2) { 
                    $check_2 = Air_repaire_ploblemsub::where('air_list_num',$value2->air_list_num)->count();
                    if ( $check_2 > 0) {
                        Air_repaire_ploblemsub::where('air_list_num',$value2->air_list_num)->update(['air_problems_2'=> $value2->air_problems_2]);
                    } else {
                        $add = new Air_repaire_ploblemsub();
                        $add->air_repaire_ploblem_id  = '2';
                        $add->air_list_num            = $value2->air_list_num;
                        $add->air_problems_2          = $value2->air_problems_2;
                        $add->repaire_date_start      = $startdate;
                        $add->repaire_date_end        = $enddate;
                        $add->save(); 
                    } 
                }
                $data_process_3 = DB::select('SELECT air_list_num, COUNT(*) as air_problems_3 FROM air_repaire WHERE air_problems_3 = "on" AND repaire_date BETWEEN "'.$startdate.'" AND "'.$enddate.'" GROUP BY air_list_num HAVING COUNT(*) > 1');
                foreach ($data_process_3 as $key => $value3) { 
                    $check_3 = Air_repaire_ploblemsub::where('air_list_num',$value3->air_list_num)->count();
                    if ( $check_3 > 0) {
                        Air_repaire_ploblemsub::where('air_list_num',$value3->air_list_num)->update(['air_problems_3'=> $value3->air_problems_3]);
                    } else {
                        $add = new Air_repaire_ploblemsub();
                        $add->air_repaire_ploblem_id  = '3';
                        $add->air_list_num            = $value3->air_list_num;
                        $add->air_problems_3          = $value3->air_problems_3;
                        $add->repaire_date_start      = $startdate;
                        $add->repaire_date_end        = $enddate;
                        $add->save(); 
                    } 
                }
                $data_process_4 = DB::select('SELECT air_list_num, COUNT(*) as air_problems_4 FROM air_repaire WHERE air_problems_4 = "on" AND repaire_date BETWEEN "'.$startdate.'" AND "'.$enddate.'" GROUP BY air_list_num HAVING COUNT(*) > 1');
                foreach ($data_process_4 as $key => $value4) { 
                    $check_4 = Air_repaire_ploblemsub::where('air_list_num',$value4->air_list_num)->count();
                    if ( $check_4 > 0) {
                        Air_repaire_ploblemsub::where('air_list_num',$value4->air_list_num)->update(['air_problems_4'=> $value4->air_problems_4]);
                    } else {
                        $add = new Air_repaire_ploblemsub();
                        $add->air_repaire_ploblem_id  = '4';
                        $add->air_list_num            = $value4->air_list_num;
                        $add->air_problems_4          = $value4->air_problems_4;
                        $add->repaire_date_start      = $startdate;
                        $add->repaire_date_end        = $enddate;
                        $add->save(); 
                    } 
                }
                $data_process_5 = DB::select('SELECT air_list_num, COUNT(*) as air_problems_5 FROM air_repaire WHERE air_problems_5 = "on" AND repaire_date BETWEEN "'.$startdate.'" AND "'.$enddate.'" GROUP BY air_list_num HAVING COUNT(*) > 1');
                foreach ($data_process_5 as $key => $value5) { 
                    $check_5 = Air_repaire_ploblemsub::where('air_list_num',$value5->air_list_num)->count();
                    if ( $check_5 > 0) {
                        Air_repaire_ploblemsub::where('air_list_num',$value5->air_list_num)->update(['air_problems_5'=> $value5->air_problems_5]);
                    } else {
                        $add = new Air_repaire_ploblemsub();
                        $add->air_repaire_ploblem_id  = '5';
                        $add->air_list_num            = $value5->air_list_num;
                        $add->air_problems_5          = $value5->air_problems_5;
                        $add->repaire_date_start      = $startdate;
                        $add->repaire_date_end        = $enddate;
                        $add->save(); 
                    } 
                }
                $data_process_6 = DB::select('SELECT air_list_num, COUNT(*) as air_problems_orther FROM air_repaire WHERE air_problems_orther = "on" AND repaire_date BETWEEN "'.$startdate.'" AND "'.$enddate.'" GROUP BY air_list_num HAVING COUNT(*) > 1');
                foreach ($data_process_6 as $key => $value6) { 
                    $check_6 = Air_repaire_ploblemsub::where('air_list_num',$value6->air_list_num)->count();
                    if ( $check_6 > 0) {
                        Air_repaire_ploblemsub::where('air_list_num',$value6->air_list_num)->update(['air_problems_orther'=> $value6->air_problems_orther]);
                    } else {
                        $add = new Air_repaire_ploblemsub();
                        $add->air_repaire_ploblem_id  = '6';
                        $add->air_list_num            = $value6->air_list_num;
                        $add->air_problems_orther     = $value6->air_problems_orther;
                        $add->repaire_date_start      = $startdate;
                        $add->repaire_date_end        = $enddate;
                        $add->save(); 
                    } 
                }
        }
         
      
        return view('support_prs.air.air_report_problems',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'datashow'    =>     $datashow, 
        ]);
    }
    public function air_report_problem_detail(Request $request,$id)
    {
        $startdate   = $request->startdate;
        $enddate     = $request->enddate;      
        $iduser = Auth::user()->id;
        if ($id == '1') {
            $datashow = DB::select(
                'SELECT c.air_repaire_id,c.repaire_date,c.air_repaire_no,c.air_list_num,c.air_list_name,c.btu,c.air_location_id,c.air_location_name
                ,c.air_problems_1 as air_problems_1,c.air_problems_2 as air_problems_2,c.air_problems_3 as air_problems_3,c.air_problems_4 as air_problems_4,c.air_problems_5 as air_problems_5,c.air_problems_orther 
                ,concat(p.fname," ",p.lname) as ptname,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = c.air_tech_id) as tectname
                FROM air_repaire_ploblemsub b 
                LEFT JOIN air_repaire c ON c.air_list_num = b.air_list_num
                LEFT JOIN users p ON p.id = c.air_staff_id
                WHERE b.air_repaire_ploblem_id ="'.$id.'" AND (c.air_problems_1 = "on")
                ORDER BY air_list_num ASC
            ');
        }else if ($id == '2') {
            $datashow = DB::select(
                'SELECT c.air_repaire_id,c.repaire_date,c.air_repaire_no,c.air_list_num,c.air_list_name,c.btu,c.air_location_id,c.air_location_name
               ,c.air_problems_1 as air_problems_1,c.air_problems_2 as air_problems_2,c.air_problems_3 as air_problems_3,c.air_problems_4 as air_problems_4,c.air_problems_5 as air_problems_5,c.air_problems_orther 
                ,concat(p.fname," ",p.lname) as ptname,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = c.air_tech_id) as tectname
                FROM air_repaire_ploblemsub b 
                LEFT JOIN air_repaire c ON c.air_list_num = b.air_list_num
                LEFT JOIN users p ON p.id = c.air_staff_id
                WHERE b.air_repaire_ploblem_id ="'.$id.'" AND (c.air_problems_2 = "on")
                ORDER BY air_list_num ASC
            ');
        }else if ($id == '3') {
            $datashow = DB::select(
                'SELECT c.air_repaire_id,c.repaire_date,c.air_repaire_no,c.air_list_num,c.air_list_name,c.btu,c.air_location_id,c.air_location_name
                ,c.air_problems_1 as air_problems_1,c.air_problems_2 as air_problems_2,c.air_problems_3 as air_problems_3,c.air_problems_4 as air_problems_4,c.air_problems_5 as air_problems_5,c.air_problems_orther
                ,concat(p.fname," ",p.lname) as ptname,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = c.air_tech_id) as tectname
                FROM air_repaire_ploblemsub b 
                LEFT JOIN air_repaire c ON c.air_list_num = b.air_list_num
                LEFT JOIN users p ON p.id = c.air_staff_id
                WHERE b.air_repaire_ploblem_id ="'.$id.'" AND (c.air_problems_3 = "on")
                ORDER BY air_list_num ASC
            ');
        }else if ($id == '4') {
            $datashow = DB::select(
                'SELECT c.air_repaire_id,c.repaire_date,c.air_repaire_no,c.air_list_num,c.air_list_name,c.btu,c.air_location_id,c.air_location_name
                ,c.air_problems_1 as air_problems_1,c.air_problems_2 as air_problems_2,c.air_problems_3 as air_problems_3,c.air_problems_4 as air_problems_4,c.air_problems_5 as air_problems_5,c.air_problems_orther
                ,concat(p.fname," ",p.lname) as ptname,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = c.air_tech_id) as tectname
                FROM air_repaire_ploblemsub b 
                LEFT JOIN air_repaire c ON c.air_list_num = b.air_list_num
                LEFT JOIN users p ON p.id = c.air_staff_id
                WHERE b.air_repaire_ploblem_id ="'.$id.'" AND (c.air_problems_4 = "on")
                ORDER BY air_list_num ASC
            ');
        }else if ($id == '5') {
            $datashow = DB::select(
                'SELECT c.air_repaire_id,c.repaire_date,c.air_repaire_no,c.air_list_num,c.air_list_name,c.btu,c.air_location_id,c.air_location_name
                ,c.air_problems_1 as air_problems_1,c.air_problems_2 as air_problems_2,c.air_problems_3 as air_problems_3,c.air_problems_4 as air_problems_4,c.air_problems_5 as air_problems_5,c.air_problems_orther
                ,concat(p.fname," ",p.lname) as ptname,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = c.air_tech_id) as tectname
                FROM air_repaire_ploblemsub b 
                LEFT JOIN air_repaire c ON c.air_list_num = b.air_list_num
                LEFT JOIN users p ON p.id = c.air_staff_id
                WHERE b.air_repaire_ploblem_id ="'.$id.'" AND (c.air_problems_5 = "on")
                ORDER BY air_list_num ASC
            ');
         
        } else {
            $datashow = DB::select(
                'SELECT c.air_repaire_id,c.repaire_date,c.air_repaire_no,c.air_list_num,c.air_list_name,c.btu,c.air_location_id,c.air_location_name
                ,c.air_problems_1 as air_problems_1,c.air_problems_2 as air_problems_2,c.air_problems_3 as air_problems_3,c.air_problems_4 as air_problems_4,c.air_problems_5 as air_problems_5,c.air_problems_orther
                ,concat(p.fname," ",p.lname) as ptname,(SELECT concat(fname," ",lname) as ptname FROM users WHERE id = c.air_tech_id) as tectname
                FROM air_repaire_ploblemsub b 
                LEFT JOIN air_repaire c ON c.air_list_num = b.air_list_num
                LEFT JOIN users p ON p.id = c.air_staff_id
                WHERE b.air_repaire_ploblem_id ="'.$id.'" AND (c.air_problems_orther = "on")
                ORDER BY air_list_num ASC
            ');
        }
        
        

        $datashow_sub = DB::select('SELECT * FROM air_list WHERE air_location_id = "'.$id.'" ORDER BY air_list_id DESC'); 
  
        return view('support_prs.air.air_report_problem_detail',[
            'startdate'     => $startdate,
            'enddate'       => $enddate,
            'datashow'      => $datashow, 
            'datashow_sub'  => $datashow_sub,
            'id'            => $id,
        ]);
    }
      

 }