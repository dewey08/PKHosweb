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
use App\Models\Check_sit_auto;
use App\Models\Check_sit;
use App\Models\Check_sit_auto_claim;
use App\Models\Ssop_stm;
use App\Models\Acc_debtor;
use App\Models\Ssop_session;
use App\Models\Ssop_opdx;
use App\Models\Pang_stamp_temp;
use App\Models\Ssop_token;
use App\Models\Ssop_opservices;
use App\Models\Ssop_dispenseditems;
use App\Models\Ssop_dispensing;
use App\Models\Ssop_billtran;
use App\Models\Ssop_billitems;
use App\Models\Claim_ssop;
use App\Models\Claim_sixteen_dru;
use App\Models\claim_sixteen_adp;
use App\Models\Claim_sixteen_cha;
use App\Models\Claim_sixteen_cht;
use App\Models\Claim_sixteen_oop;
use App\Models\Claim_sixteen_odx;
use App\Models\Claim_sixteen_orf;
use App\Models\Claim_sixteen_pat;
use App\Models\Claim_sixteen_ins;
use App\Models\Claim_temp_ssop;
use App\Models\Claim_sixteen_opd;
use App\Models\Check_authen;
use App\Models\Check_authen_temp;
use App\Models\Visit_pttype_authen_report;
use App\Models\Db_authen_detail;
use App\Models\Api_neweclaim;
use Auth;
use ZipArchive;
use Storage;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Stevebauman\Location\Facades\Location;
use SoapClient;
use SplFileObject;

use App\Imports\ImportAuthenexcel_import;



use PHPExcel;
use PHPExcel_IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\IOFactory;



class Checksit_reportController extends Controller
{
    // public function CountSupcon_M($year)
    public function Count_CheckAuthen_all($year)
    {
        //year รับปี ค.ศ.
            $arr[1] = DB::table('check_sit_auto')->whereNotIn('pttype',["M1","M2","M3","M4","M5","M6","13","23","91","X7"])->whereNotIn('main_dep',["011","036","107"])->whereMonth('vstdate','01')->whereYear('vstdate',$year)->count();
            $arr[2] = DB::table('check_sit_auto')->whereNotIn('pttype',["M1","M2","M3","M4","M5","M6","13","23","91","X7"])->whereNotIn('main_dep',["011","036","107"])->whereMonth('vstdate','02')->whereYear('vstdate',$year)->count();
            $arr[3] = DB::table('check_sit_auto')->whereNotIn('pttype',["M1","M2","M3","M4","M5","M6","13","23","91","X7"])->whereNotIn('main_dep',["011","036","107"])->whereMonth('vstdate','03')->whereYear('vstdate',$year)->count();
            $arr[4] = DB::table('check_sit_auto')->whereNotIn('pttype',["M1","M2","M3","M4","M5","M6","13","23","91","X7"])->whereNotIn('main_dep',["011","036","107"])->whereMonth('vstdate','04')->whereYear('vstdate',$year)->count();
            $arr[5] = DB::table('check_sit_auto')->whereNotIn('pttype',["M1","M2","M3","M4","M5","M6","13","23","91","X7"])->whereNotIn('main_dep',["011","036","107"])->whereMonth('vstdate','05')->whereYear('vstdate',$year)->count();
            $arr[6] = DB::table('check_sit_auto')->whereNotIn('pttype',["M1","M2","M3","M4","M5","M6","13","23","91","X7"])->whereNotIn('main_dep',["011","036","107"])->whereMonth('vstdate','06')->whereYear('vstdate',$year)->count();
            $arr[7] = DB::table('check_sit_auto')->whereNotIn('pttype',["M1","M2","M3","M4","M5","M6","13","23","91","X7"])->whereNotIn('main_dep',["011","036","107"])->whereMonth('vstdate','07')->whereYear('vstdate',$year)->count();
            $arr[8] = DB::table('check_sit_auto')->whereNotIn('pttype',["M1","M2","M3","M4","M5","M6","13","23","91","X7"])->whereNotIn('main_dep',["011","036","107"])->whereMonth('vstdate','08')->whereYear('vstdate',$year)->count();
            $arr[9] = DB::table('check_sit_auto')->whereNotIn('pttype',["M1","M2","M3","M4","M5","M6","13","23","91","X7"])->whereNotIn('main_dep',["011","036","107"])->whereMonth('vstdate','09')->whereYear('vstdate',$year)->count();
            $arr[10] = DB::table('check_sit_auto')->whereNotIn('pttype',["M1","M2","M3","M4","M5","M6","13","23","91","X7"])->whereNotIn('main_dep',["011","036","107"])->whereMonth('vstdate','10')->whereYear('vstdate',$year-1)->count();
            $arr[11] = DB::table('check_sit_auto')->whereNotIn('pttype',["M1","M2","M3","M4","M5","M6","13","23","91","X7"])->whereNotIn('main_dep',["011","036","107"])->whereMonth('vstdate','11')->whereYear('vstdate',$year-1)->count();
            $arr[12] = DB::table('check_sit_auto')->whereNotIn('pttype',["M1","M2","M3","M4","M5","M6","13","23","91","X7"])->whereNotIn('main_dep',["011","036","107"])->whereMonth('vstdate','12')->whereYear('vstdate',$year-1)->count();
        return $arr;
    }

    public function Count_CheckAuthen($year)
    {
        //year รับปี ค.ศ.
            $arr[1] = DB::table('check_sit_auto')->whereNotNull('claimcode')->whereNotIn('pttype',["M1","M2","M3","M4","M5","M6","13","23","91","X7"])->whereNotIn('main_dep',["011","036","107"])->whereMonth('vstdate','01')->whereYear('vstdate',$year)->count();
            $arr[2] = DB::table('check_sit_auto')->whereNotNull('claimcode')->whereNotIn('pttype',["M1","M2","M3","M4","M5","M6","13","23","91","X7"])->whereNotIn('main_dep',["011","036","107"])->whereMonth('vstdate','02')->whereYear('vstdate',$year)->count();
            $arr[3] = DB::table('check_sit_auto')->whereNotNull('claimcode')->whereNotIn('pttype',["M1","M2","M3","M4","M5","M6","13","23","91","X7"])->whereNotIn('main_dep',["011","036","107"])->whereMonth('vstdate','03')->whereYear('vstdate',$year)->count();
            $arr[4] = DB::table('check_sit_auto')->whereNotNull('claimcode')->whereNotIn('pttype',["M1","M2","M3","M4","M5","M6","13","23","91","X7"])->whereNotIn('main_dep',["011","036","107"])->whereMonth('vstdate','04')->whereYear('vstdate',$year)->count();
            $arr[5] = DB::table('check_sit_auto')->whereNotNull('claimcode')->whereNotIn('pttype',["M1","M2","M3","M4","M5","M6","13","23","91","X7"])->whereNotIn('main_dep',["011","036","107"])->whereMonth('vstdate','05')->whereYear('vstdate',$year)->count();
            $arr[6] = DB::table('check_sit_auto')->whereNotNull('claimcode')->whereNotIn('pttype',["M1","M2","M3","M4","M5","M6","13","23","91","X7"])->whereNotIn('main_dep',["011","036","107"])->whereMonth('vstdate','06')->whereYear('vstdate',$year)->count();
            $arr[7] = DB::table('check_sit_auto')->whereNotNull('claimcode')->whereNotIn('pttype',["M1","M2","M3","M4","M5","M6","13","23","91","X7"])->whereNotIn('main_dep',["011","036","107"])->whereMonth('vstdate','07')->whereYear('vstdate',$year)->count();
            $arr[8] = DB::table('check_sit_auto')->whereNotNull('claimcode')->whereNotIn('pttype',["M1","M2","M3","M4","M5","M6","13","23","91","X7"])->whereNotIn('main_dep',["011","036","107"])->whereMonth('vstdate','08')->whereYear('vstdate',$year)->count();
            $arr[9] = DB::table('check_sit_auto')->whereNotNull('claimcode')->whereNotIn('pttype',["M1","M2","M3","M4","M5","M6","13","23","91","X7"])->whereNotIn('main_dep',["011","036","107"])->whereMonth('vstdate','09')->whereYear('vstdate',$year)->count();
            $arr[10] = DB::table('check_sit_auto')->whereNotNull('claimcode')->whereNotIn('pttype',["M1","M2","M3","M4","M5","M6","13","23","91","X7"])->whereNotIn('main_dep',["011","036","107"])->whereMonth('vstdate','10')->whereYear('vstdate',$year-1)->count();
            $arr[11] = DB::table('check_sit_auto')->whereNotNull('claimcode')->whereNotIn('pttype',["M1","M2","M3","M4","M5","M6","13","23","91","X7"])->whereNotIn('main_dep',["011","036","107"])->whereMonth('vstdate','11')->whereYear('vstdate',$year-1)->count();
            $arr[12] = DB::table('check_sit_auto')->whereNotNull('claimcode')->whereNotIn('pttype',["M1","M2","M3","M4","M5","M6","13","23","91","X7"])->whereNotIn('main_dep',["011","036","107"])->whereMonth('vstdate','12')->whereYear('vstdate',$year-1)->count();
        return $arr;
    }
    public function Count_CheckAuthen_Null($year)
    {
        //year รับปี ค.ศ.
            $arr[1] = DB::table('check_sit_auto')->whereNull('claimcode')->whereNotIn('pttype',["M1","M2","M3","M4","M5","M6","13","23","91","X7"])->whereNotIn('main_dep',["011","036","107"])->whereMonth('vstdate','01')->whereYear('vstdate',$year)->count();
            $arr[2] = DB::table('check_sit_auto')->whereNull('claimcode')->whereNotIn('pttype',["M1","M2","M3","M4","M5","M6","13","23","91","X7"])->whereNotIn('main_dep',["011","036","107"])->whereMonth('vstdate','02')->whereYear('vstdate',$year)->count();
            $arr[3] = DB::table('check_sit_auto')->whereNull('claimcode')->whereNotIn('pttype',["M1","M2","M3","M4","M5","M6","13","23","91","X7"])->whereNotIn('main_dep',["011","036","107"])->whereMonth('vstdate','03')->whereYear('vstdate',$year)->count();
            $arr[4] = DB::table('check_sit_auto')->whereNull('claimcode')->whereNotIn('pttype',["M1","M2","M3","M4","M5","M6","13","23","91","X7"])->whereNotIn('main_dep',["011","036","107"])->whereMonth('vstdate','04')->whereYear('vstdate',$year)->count();
            $arr[5] = DB::table('check_sit_auto')->whereNull('claimcode')->whereNotIn('pttype',["M1","M2","M3","M4","M5","M6","13","23","91","X7"])->whereNotIn('main_dep',["011","036","107"])->whereMonth('vstdate','05')->whereYear('vstdate',$year)->count();
            $arr[6] = DB::table('check_sit_auto')->whereNull('claimcode')->whereNotIn('pttype',["M1","M2","M3","M4","M5","M6","13","23","91","X7"])->whereNotIn('main_dep',["011","036","107"])->whereMonth('vstdate','06')->whereYear('vstdate',$year)->count();
            $arr[7] = DB::table('check_sit_auto')->whereNull('claimcode')->whereNotIn('pttype',["M1","M2","M3","M4","M5","M6","13","23","91","X7"])->whereNotIn('main_dep',["011","036","107"])->whereMonth('vstdate','07')->whereYear('vstdate',$year)->count();
            $arr[8] = DB::table('check_sit_auto')->whereNull('claimcode')->whereNotIn('pttype',["M1","M2","M3","M4","M5","M6","13","23","91","X7"])->whereNotIn('main_dep',["011","036","107"])->whereMonth('vstdate','08')->whereYear('vstdate',$year)->count();
            $arr[9] = DB::table('check_sit_auto')->whereNull('claimcode')->whereNotIn('pttype',["M1","M2","M3","M4","M5","M6","13","23","91","X7"])->whereNotIn('main_dep',["011","036","107"])->whereMonth('vstdate','09')->whereYear('vstdate',$year)->count();
            $arr[10] = DB::table('check_sit_auto')->whereNull('claimcode')->whereNotIn('pttype',["M1","M2","M3","M4","M5","M6","13","23","91","X7"])->whereNotIn('main_dep',["011","036","107"])->whereMonth('vstdate','10')->whereYear('vstdate',$year-1)->count();
            $arr[11] = DB::table('check_sit_auto')->whereNull('claimcode')->whereNotIn('pttype',["M1","M2","M3","M4","M5","M6","13","23","91","X7"])->whereNotIn('main_dep',["011","036","107"])->whereMonth('vstdate','11')->whereYear('vstdate',$year-1)->count();
            $arr[12] = DB::table('check_sit_auto')->whereNull('claimcode')->whereNotIn('pttype',["M1","M2","M3","M4","M5","M6","13","23","91","X7"])->whereNotIn('main_dep',["011","036","107"])->whereMonth('vstdate','12')->whereYear('vstdate',$year-1)->count();
        return $arr;
    }


   

}

