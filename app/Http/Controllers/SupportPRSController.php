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
use App\Models\Acc_stm_lgo;
use App\Models\Acc_stm_lgoexcel;
use App\Models\Check_sit_auto;
use App\Models\Acc_stm_ucs_excel;
use App\Models\Fire_check;
use App\Models\Fire;
use App\Models\Cctv_report_months;
use App\Models\Product_budget;
use App\Models\Product_method;
use App\Models\Product_buy;
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
// use File;
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


class SupportPRSController extends Controller
 { 
    public function support_system_dashboard(Request $request)
    {
        $datenow = date('Y-m-d');
        $months = date('m');
        $year = date('Y'); 
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $dabudget_year = DB::table('budget_year')->where('active','=',true)->first();
        $leave_month_year = DB::table('leave_month')->orderBy('MONTH_ID', 'ASC')->get();
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -5 months')); //ย้อนหลัง 5 เดือน
        $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี
        $yearnew = date('Y');
        $yearold = date('Y')-1;
        $start = (''.$yearold.'-10-01');
        $end = (''.$yearnew.'-09-30'); 

        // $year_s = date('Y'); 
        // dd($y);
        $count_red_all                 = Fire::where('fire_color','red')->where('fire_edit','Narmal')->where('fire_backup','N')->count(); 
        $count_green_all               = Fire::where('fire_color','green')->where('fire_edit','Narmal')->where('fire_backup','N')->count(); 
        $count_red_allactive           = Fire::where('fire_color','red')->where('active','Y')->where('fire_edit','Narmal')->where('fire_backup','N')->count(); 
        $count_green_allactive         = Fire::where('fire_color','green')->where('active','Y')->where('fire_edit','Narmal')->where('fire_backup','N')->count(); 
        $data['count_red_back']        = Fire::where('fire_color','red')->where('fire_backup','Y')->count(); 
        $data['count_green_back']      = Fire::where('fire_color','green')->where('fire_backup','Y')->count(); 
        // Narmal
            $chart_red = DB::connection('mysql')->select(' 
                    SELECT * FROM
                    (SELECT COUNT(fire_num) as count_red FROM fire_check WHERE fire_check_color ="red" AND YEAR(check_date)= "'.$year.'" AND month(check_date)= "'.$months.'") reds
                    ,(SELECT COUNT(fire_num) as count_greens FROM fire_check WHERE fire_check_color ="green" AND YEAR(check_date)= "'.$year.'" AND month(check_date)= "'.$months.'") green
            '); 
            foreach ($chart_red as $key => $value) {                
                if ($value->count_red > 0) {
                    // $dataset_s[] = [ 
                        // $count_color_qty         = $value->count_color;
                        // $count_color_percent     = 100 / $count_red * $value->count_color;
                        $count_red_percent          = 100 / $count_red_all * $value->count_red; 
                        $count_color_red_qty        = $value->count_red;
                        $count_red_alls             = $count_red_all;

                        $count_green_percent        = 100 / $count_green_all * $value->count_greens; 
                        $count_color_green_qty      = $value->count_greens;
                        $count_green_alls           = $count_green_all;
                    // ];
                }else {
                    $count_red_percent = '';
                    $count_color_red_qty = '';
                    $count_red_alls = '';
                    $count_green_percent = '';
                    $count_color_green_qty = '';
                    $count_green_alls = '';
                }
            }
            $datareport = DB::connection('mysql')->select(
                'SELECT
                    YEAR(f.check_date) as years,(YEAR(f.check_date)+543) as yearsthai,MONTH(f.check_date) as months,l.MONTH_NAME

                    ,(SELECT COUNT(fire_id) FROM fire WHERE fire_color = "red") as red_all
                    ,(SELECT COUNT(fire_id) FROM fire WHERE fire_color = "red" AND fire_size ="10" AND fire_edit ="Narmal" AND fire_backup ="N") as redten
                    ,(SELECT COUNT(fire_id) FROM fire WHERE fire_color = "red" AND fire_size ="15" AND fire_edit ="Narmal" AND fire_backup ="N") as redfifteen
                    ,(SELECT COUNT(fire_id) FROM fire WHERE fire_color = "red" AND fire_size ="20" AND fire_edit ="Narmal" AND fire_backup ="N") as redtwenty 
                    ,(SELECT COUNT(fire_id) FROM fire WHERE fire_color = "green" AND fire_size ="10" AND fire_edit ="Narmal" AND fire_backup ="N") as greenten
                    ,(SELECT COUNT(fire_id) FROM fire WHERE fire_color = "red" AND fire_size ="10" AND fire_edit ="Narmal" AND fire_backup ="N")+
                    (SELECT COUNT(fire_id) FROM fire WHERE fire_color = "red" AND fire_size ="15" AND fire_edit ="Narmal" AND fire_backup ="N")+
                    (SELECT COUNT(fire_id) FROM fire WHERE fire_color = "red" AND fire_size ="20" AND fire_edit ="Narmal" AND fire_backup ="N")+
                    (SELECT COUNT(fire_id) FROM fire WHERE fire_color = "green" AND fire_size ="10" AND fire_edit ="Narmal" AND fire_backup ="N") total_all
                    
                    ,(SELECT COUNT(fc.fire_id) FROM fire_check fc LEFT JOIN fire f ON f.fire_id=fc.fire_id WHERE fc.fire_check_color = "red" AND f.fire_size ="10") as Check_redten
                    ,(SELECT COUNT(fc.fire_id) FROM fire_check fc LEFT JOIN fire f ON f.fire_id=fc.fire_id WHERE fc.fire_check_color = "red" AND f.fire_size ="15") as Check_redfifteen
                    ,(SELECT COUNT(fc.fire_id) FROM fire_check fc LEFT JOIN fire f ON f.fire_id=fc.fire_id WHERE fc.fire_check_color = "red" AND f.fire_size ="20") as Check_redtwenty
                    ,(SELECT COUNT(fc.fire_id) FROM fire_check fc LEFT JOIN fire f ON f.fire_id=fc.fire_id WHERE fc.fire_check_color = "green" AND f.fire_size ="10") as Check_greenten
                    ,(SELECT COUNT(fc.fire_id) FROM fire_check fc LEFT JOIN fire f ON f.fire_id=fc.fire_id WHERE fc.fire_check_color = "red" AND f.fire_size ="10")+
                    (SELECT COUNT(fc.fire_id) FROM fire_check fc LEFT JOIN fire f ON f.fire_id=fc.fire_id WHERE fc.fire_check_color = "red" AND f.fire_size ="15")+
                    (SELECT COUNT(fc.fire_id) FROM fire_check fc LEFT JOIN fire f ON f.fire_id=fc.fire_id WHERE fc.fire_check_color = "red" AND f.fire_size ="20")+
                    (SELECT COUNT(fc.fire_id) FROM fire_check fc LEFT JOIN fire f ON f.fire_id=fc.fire_id WHERE fc.fire_check_color = "green" AND f.fire_size ="10") as Checktotal_all

                    ,(SELECT COUNT(fire_id) FROM fire WHERE active = "N") as camroot
                    ,(SELECT COUNT(fire_id) FROM fire WHERE fire_color = "green") as green_all
                    ,(SELECT COUNT(fire_id) FROM fire_check WHERE fire_check_color = "green") as Checkgreen_all
                    ,(SELECT COUNT(fire_id) FROM fire WHERE fire_color = "red" AND fire_backup = "Y") as backup_red
                    ,(SELECT COUNT(fire_id) FROM fire WHERE fire_color = "green" AND fire_backup = "Y") as backup_green
                FROM fire_check f
                LEFT OUTER JOIN leave_month l on l.MONTH_ID = month(f.check_date)
                GROUP BY MONTH(f.check_date) 
            '); 
            
        return view('support_prs.support_system_dashboard',$data,[
            'startdate'               =>  $startdate,
            'enddate'                 =>  $enddate, 
            'count_color_red_qty'     =>  $count_color_red_qty,
            'count_red_all'           =>  $count_red_all,
            'count_green_all'         =>  $count_green_all,
            'count_red_percent'       =>  $count_red_percent,
            'datareport'              =>  $datareport,
            'count_green_percent'     =>  $count_green_percent,
            'count_color_green_qty'   =>  $count_color_green_qty,
            'count_red_allactive'     =>  $count_red_allactive,
            'count_green_allactive'   =>  $count_green_allactive,
        ]);
    }
    public function support_system_excel(Request $request)
    {
        $datenow = date('Y-m-d');
        $months = date('m');
        $year = date('Y'); 
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $dabudget_year = DB::table('budget_year')->where('active','=',true)->where('years_now','=','Y')->first();
        $data['ynow'] =  $dabudget_year->leave_year_id;
        $leave_month_year = DB::table('leave_month')->orderBy('MONTH_ID', 'ASC')->get();
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -5 months')); //ย้อนหลัง 5 เดือน
        $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี
        $yearnew = date('Y');
        $yearold = date('Y')-1;
        $start = (''.$yearold.'-10-01');
        $end = (''.$yearnew.'-09-30'); 
 
        $count_red_all                 = Fire::where('fire_color','red')->where('fire_edit','Narmal')->where('fire_backup','N')->count(); 
        $count_green_all               = Fire::where('fire_color','green')->where('fire_edit','Narmal')->where('fire_backup','N')->count(); 
        $count_red_allactive           = Fire::where('fire_color','red')->where('active','Y')->where('fire_edit','Narmal')->where('fire_backup','N')->count(); 
        $count_green_allactive         = Fire::where('fire_color','green')->where('active','Y')->where('fire_edit','Narmal')->where('fire_backup','N')->count(); 

        $count_red_alls_                 = Fire::where('fire_color','red')->where('fire_edit','Narmal')->count(); 
        $count_green_alls_               = Fire::where('fire_color','green')->where('fire_edit','Narmal')->count(); 
        $count_red_allactives_           = Fire::where('fire_color','red')->where('active','Y')->where('fire_edit','Narmal')->count(); 
        $count_green_allactives_         = Fire::where('fire_color','green')->where('active','Y')->where('fire_edit','Narmal')->count(); 

        $data['count_red_back']        = Fire::where('fire_color','red')->where('fire_backup','Y')->count(); 
        $data['count_green_back']      = Fire::where('fire_color','green')->where('fire_backup','Y')->count(); 
        // Narmal
            $chart_red = DB::connection('mysql')->select(' 
                    SELECT * FROM
                    (SELECT COUNT(fire_num) as count_red FROM fire_check WHERE fire_check_color ="red" AND YEAR(check_date)= "'.$year.'" AND month(check_date)= "'.$months.'") reds
                    ,(SELECT COUNT(fire_num) as count_greens FROM fire_check WHERE fire_check_color ="green" AND YEAR(check_date)= "'.$year.'" AND month(check_date)= "'.$months.'") green
            '); 
            foreach ($chart_red as $key => $value) {                
                if ($value->count_red > 0) {
                    // $dataset_s[] = [ 
                        // $count_color_qty         = $value->count_color;
                        // $count_color_percent     = 100 / $count_red * $value->count_color;
                        $count_red_percent          = 100 / $count_red_alls_ * $value->count_red; 
                        $count_color_red_qty        = $value->count_red;
                        $count_red_alls             = $count_red_alls_;

                        $count_green_percent        = 100 / $count_green_alls_ * $value->count_greens; 
                        $count_color_green_qty      = $value->count_greens;
                        $count_green_alls           = $count_green_alls_;
                    // ];
                }else {
                    $count_red_percent = '';
                    $count_color_red_qty = '';
                    $count_red_alls = '';
                    $count_green_percent = '';
                    $count_color_green_qty = '';
                    $count_green_alls = '';
                }
            }
            $datareport = DB::connection('mysql')->select(
                'SELECT
                    YEAR(f.check_date) as years,(YEAR(f.check_date)+543) as yearsthai,MONTH(f.check_date) as months,l.MONTH_NAME

                    ,(SELECT COUNT(fire_id) FROM fire WHERE fire_color = "red") as red_all
                    ,(SELECT COUNT(fire_id) FROM fire WHERE fire_color = "red" AND fire_size ="10" AND fire_edit ="Narmal" AND fire_backup ="N") as redten
                    ,(SELECT COUNT(fire_id) FROM fire WHERE fire_color = "red" AND fire_size ="15" AND fire_edit ="Narmal" AND fire_backup ="N") as redfifteen
                    ,(SELECT COUNT(fire_id) FROM fire WHERE fire_color = "red" AND fire_size ="20" AND fire_edit ="Narmal" AND fire_backup ="N") as redtwenty 
                    ,(SELECT COUNT(fire_id) FROM fire WHERE fire_color = "green" AND fire_size ="10" AND fire_edit ="Narmal" AND fire_backup ="N") as greenten
                    ,(SELECT COUNT(fire_id) FROM fire WHERE fire_color = "red" AND fire_size ="10" AND fire_edit ="Narmal" AND fire_backup ="N")+
                    (SELECT COUNT(fire_id) FROM fire WHERE fire_color = "red" AND fire_size ="15" AND fire_edit ="Narmal" AND fire_backup ="N")+
                    (SELECT COUNT(fire_id) FROM fire WHERE fire_color = "red" AND fire_size ="20" AND fire_edit ="Narmal" AND fire_backup ="N")+
                    (SELECT COUNT(fire_id) FROM fire WHERE fire_color = "green" AND fire_size ="10" AND fire_edit ="Narmal" AND fire_backup ="N") total_all
                    
                    ,(SELECT COUNT(fc.fire_id) FROM fire_check fc LEFT JOIN fire f ON f.fire_id=fc.fire_id WHERE fc.fire_check_color = "red" AND f.fire_size ="10") as Check_redten
                    ,(SELECT COUNT(fc.fire_id) FROM fire_check fc LEFT JOIN fire f ON f.fire_id=fc.fire_id WHERE fc.fire_check_color = "red" AND f.fire_size ="15") as Check_redfifteen
                    ,(SELECT COUNT(fc.fire_id) FROM fire_check fc LEFT JOIN fire f ON f.fire_id=fc.fire_id WHERE fc.fire_check_color = "red" AND f.fire_size ="20") as Check_redtwenty
                    ,(SELECT COUNT(fc.fire_id) FROM fire_check fc LEFT JOIN fire f ON f.fire_id=fc.fire_id WHERE fc.fire_check_color = "green" AND f.fire_size ="10") as Check_greenten
                    ,(SELECT COUNT(fc.fire_id) FROM fire_check fc LEFT JOIN fire f ON f.fire_id=fc.fire_id WHERE fc.fire_check_color = "red" AND f.fire_size ="10")+
                    (SELECT COUNT(fc.fire_id) FROM fire_check fc LEFT JOIN fire f ON f.fire_id=fc.fire_id WHERE fc.fire_check_color = "red" AND f.fire_size ="15")+
                    (SELECT COUNT(fc.fire_id) FROM fire_check fc LEFT JOIN fire f ON f.fire_id=fc.fire_id WHERE fc.fire_check_color = "red" AND f.fire_size ="20")+
                    (SELECT COUNT(fc.fire_id) FROM fire_check fc LEFT JOIN fire f ON f.fire_id=fc.fire_id WHERE fc.fire_check_color = "green" AND f.fire_size ="10") as Checktotal_all

                    ,(SELECT COUNT(fire_id) FROM fire WHERE active = "N") as camroot
                    ,(SELECT COUNT(fire_id) FROM fire WHERE fire_color = "green") as green_all
                    ,(SELECT COUNT(fire_id) FROM fire_check WHERE fire_check_color = "green") as Checkgreen_all
                    ,(SELECT COUNT(fire_id) FROM fire WHERE fire_color = "red" AND fire_backup = "Y") as backup_red
                    ,(SELECT COUNT(fire_id) FROM fire WHERE fire_color = "green" AND fire_backup = "Y") as backup_green
                FROM fire_check f
                LEFT OUTER JOIN leave_month l on l.MONTH_ID = month(f.check_date)
                GROUP BY MONTH(f.check_date) 
            '); 
            
        return view('support_prs.support_system_excel',$data,[
            'startdate'               =>  $startdate,
            'enddate'                 =>  $enddate, 
            'count_color_red_qty'     =>  $count_color_red_qty,
            'count_red_all'           =>  $count_red_all,
            'count_green_all'         =>  $count_green_all,
            'count_red_percent'       =>  $count_red_percent,
            'datareport'              =>  $datareport,
            'count_green_percent'     =>  $count_green_percent,
            'count_color_green_qty'   =>  $count_color_green_qty,
            'count_red_allactive'     =>  $count_red_allactive,
            'count_green_allactive'   =>  $count_green_allactive,
        ]);
    }
    public function support_system_nocheck(Request $request,$months,$years)
    {
        $datenow = date('Y-m-d'); 
        $datareport = DB::connection('mysql')->select('SELECT * FROM fire_check WHERE month(check_date) = "'.$months.'" AND year(check_date) = "'.$years.'" ORDER BY fire_check_id ASC'); 
         foreach ($datareport as $key => $value) {
            // $data_array[] = $value->fire_num;
            $count_c = Fire::where('fire_num','=',$value->fire_num)->count();
            if ($count_c > 0) {
                Fire::where('fire_num','=',$value->fire_num)
                ->update(['fire_for_nocheck' => 'Y']); 
            } else {
                // Fire::where('fire_num','<>',$value->fire_num)
                // Fire::where('fire_num','!=',$value->fire_num)->update(['fire_for_nocheck' => '']); 
            } 
            // Fire::where('fire_num','!=',$value->fire_num)->update(['fire_for_nocheck' => 'N']); 
         }
        //  $data_t = $data_array;
        //  dd($data_t);
        // $datafire = DB::select('SELECT * FROM fire WHERE fire_backup="N" AND fire_for_nocheck = "Y" AND fire_edit ="Narmal" AND active="Y"'); 
        // $datafire = DB::select('SELECT * FROM fire WHERE fire_for_nocheck = "N" AND active="Y"'); 
        $datafire = DB::select(
            'SELECT * FROM fire f
                LEFT JOIN fire_check fc ON fc.fire_id = f.fire_id
                LEFT JOIN users u ON u.id = fc.user_id
                WHERE f.fire_for_nocheck = "N" AND f.fire_edit ="Narmal" AND month(fc.check_date) = "'.$months.'" AND year(fc.check_date) = "'.$years.'"
        '); 
        //   AND fire_edit ="Narmal"
        //  foreach ($data_t as $key => $valuess) {
        //     dd($valuess);
            // Fire::where('fire_num',$valuess)->update(['fire_for_nocheck' => 'Y']); 
            // $datafire[] = DB::select('SELECT * FROM fire WHERE fire_num <> "'.$data_t[0].'" AND fire_backup="N"');
        //  }

        // $datafire[] = DB::select('SELECT * FROM fire WHERE fire_num <> "'.$data_t[0].'" AND fire_backup="N"');
        //  $data_tt = $datafire[0];
        //  foreach ($data_tt as $key => $valuett) {
        //     # code...
        //  }
        //  dd($data_tt);
        return view('support_prs.support_system_nocheck',[
            'datareport'     => $datareport,
            'datafire'       => $datafire, 
        ]);
    }  
    public function support_system_check(Request $request,$months,$years)
    {
        $datenow = date('Y-m-d'); 
        $datareport = DB::connection('mysql')->select('SELECT * FROM fire_check WHERE month(check_date) = "'.$months.'" AND year(check_date) = "'.$years.'" ORDER BY fire_check_id ASC'); 
         foreach ($datareport as $key => $value) { 
            $count_c = Fire::where('fire_num','=',$value->fire_num)->count();
            if ($count_c > 0) {
                Fire::where('fire_num','=',$value->fire_num)
                ->update(['fire_for_nocheck' => 'Y']); 
            } else {
                // Fire::where('fire_num','<>',$value->fire_num)
                // Fire::where('fire_num','!=',$value->fire_num)->update(['fire_for_nocheck' => '']); 
            } 
            // if ($value->fire_num !='') {
                // Fire::where('fire_num',$value->fire_num)->update(['fire_for_nocheck' => 'Y']); 
                // Fire::where('fire_num','=',$value->fire_num)
                // ->update(['fire_for_nocheck' => 'N']);
            // } else {
                // Fire::where('fire_num',$value->fire_num)->update(['fire_for_nocheck' => '']); 
            // } 
         }
       
        $datafire = DB::select(
            'SELECT * FROM fire f
                LEFT JOIN fire_check fc ON fc.fire_id = f.fire_id
                LEFT JOIN users u ON u.id = fc.user_id
                WHERE f.fire_for_nocheck = "Y" AND f.fire_edit ="Narmal" AND month(fc.check_date) = "'.$months.'" AND year(fc.check_date) = "'.$years.'"
        '); 
        // f.fire_backup="N" AND 
        // leftJoin('users', 'fire_check.user_id', '=', 'users.id') 
        return view('support_prs.support_system_check',[
            'datareport'     => $datareport,
            'datafire'       => $datafire, 
        ]);
    } 
    public function support_system_process(Request $request)
    {
        $startdate = $request->startdate;
        $enddate   = $request->enddate;

        $datareport = DB::connection('mysql')->select('SELECT * FROM fire_check WHERE check_date BETWEEN "'.$startdate.'" AND "'.$enddate.'"'); 
         foreach ($datareport as $key => $value) { 
            if ($value->fire_num !='') {
                Fire::where('fire_num',$value->fire_num)->update(['fire_for_nocheck' => 'Y']); 
            } else {
                Fire::where('fire_num',$value->fire_num)->update(['fire_for_nocheck' => '']); 
            } 
         }  
       
        return response()->json([
            'status'    => '2000'
        ]);
    } 
    public function support_dashboard_chart(Request $request)
    {
        $datenow = date('Y-m-d');
        $months = date('m');
        $year = date('Y'); 
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        // $count_red                     = Fire::where('fire_color','red')->where('fire_edit','Narmal')->where('fire_backup','N')->count(); 
        // $count_green                   = Fire::where('fire_color','green')->where('fire_edit','Narmal')->where('fire_backup','N')->count();

        $count_red_all                 = Fire::where('fire_color','red')->where('fire_edit','Narmal')->count(); 
        $count_green_all               = Fire::where('fire_color','green')->where('fire_edit','Narmal')->count();

        $count_red_allactive           = Fire::where('fire_color','red')->where('active','Y')->where('fire_edit','Narmal')->count(); 
        $count_green_allactive         = Fire::where('fire_color','green')->where('active','Y')->where('fire_edit','Narmal')->count(); 

        $data['count_red_back']        = Fire::where('fire_color','red')->where('fire_backup','Y')->count(); 
        $data['count_green_back']      = Fire::where('fire_color','green')->where('fire_backup','Y')->count();
       
            $chart_red = DB::connection('mysql')->select(' 
                    SELECT * FROM
                    (SELECT COUNT(fire_num) as count_red FROM fire_check WHERE fire_check_color ="red" AND YEAR(check_date)= "'.$year.'" AND month(check_date)= "'.$months.'") reds
                    ,(SELECT COUNT(fire_num) as count_greens FROM fire_check WHERE fire_check_color ="green" AND YEAR(check_date)= "'.$year.'" AND month(check_date)= "'.$months.'") green
            '); 
            foreach ($chart_red as $key => $value) {                
                if ($value->count_red > 0) {
                    $dataset2[] = [ 
                        'count_red'                  => 100 / $count_red_all * $value->count_red, 
                        'count_color_red_qty'        => $value->count_red,
                        'count_red_all'              => $count_red_all,

                        // $count_green_percent        = 100 / $count_green_all * $value->count_greens; 
                        'count_green_percent'        => 100 / $count_green_all * $value->count_greens, 
                        'count_color_green_qty'      => $value->count_greens,
                        'count_green_all'            => $count_green_all,
                    ];
                }
            }

            $Dataset1 = $dataset2;
            // dd($Dataset1);

            return response()->json([
                'status'                    => '200', 
                'Dataset1'                  => $Dataset1, 
                'count_red_allactive'       =>  $count_red_allactive,
                'count_green_allactive'     =>  $count_green_allactive,
            ]);
    }
    public function support_system(Request $request)
    {
        $datenow = date('Y-m-d');
        $months = date('m');
        $year = date('Y'); 
        $startdate = $request->startdate;
        $enddate = $request->enddate;
         
        return view('support_prs.support_system',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate, 
        ]);
    }    
 
    public function cctvqrcode(Request $request, $id)
    {

            $cctvprint = Article::where('article_id', '=', $id)->first();

        return view('cctv.cctvqrcode', [
            'cctvprint'  =>  $cctvprint
        ]);

    }
     
 

 }