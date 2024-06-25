<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\support\Facades\Hash;
use Illuminate\support\Facades\Validator;
use App\Models\User;
use App\Models\Ins_eclaimxxx;
use App\Models\D_claim_db_hipdata_code;
use App\Models\D_claim;

use PDF;
use setasign\Fpdi\Fpdi;
use App\Models\Budget_year;
use Illuminate\Support\Facades\File;
use DataTables;
use Intervention\Image\ImageManagerStatic as Image;

class PkclaimController extends Controller
{
    public function pkclaim_info(Request $request)
    { 
        $data['users'] = User::get();
        $ofc_10 = D_claim_db_hipdata_code::where(DB::raw("Month(vstdate)"),'10')->where("hipdata_code",'=','OFC')->sum('income_vn');
        $ofc_11 = D_claim_db_hipdata_code::where(DB::raw("Month(vstdate)"),'11')->where("hipdata_code",'=','OFC')->sum('income_vn');
        $ofc_12 = D_claim_db_hipdata_code::where(DB::raw("Month(vstdate)"),'12')->where("hipdata_code",'=','OFC')->sum('income_vn');
        $ofc_01 = D_claim_db_hipdata_code::where(DB::raw("Month(vstdate)"),'01')->where("hipdata_code",'=','OFC')->sum('income_vn');
        $ofc_02 = D_claim_db_hipdata_code::where(DB::raw("Month(vstdate)"),'02')->where("hipdata_code",'=','OFC')->sum('income_vn');
        $ofc_03 = D_claim_db_hipdata_code::where(DB::raw("Month(vstdate)"),'03')->where("hipdata_code",'=','OFC')->sum('income_vn');
        $ofc_04 = D_claim_db_hipdata_code::where(DB::raw("Month(vstdate)"),'04')->where("hipdata_code",'=','OFC')->sum('income_vn');
        $ofc_05 = D_claim_db_hipdata_code::where(DB::raw("Month(vstdate)"),'05')->where("hipdata_code",'=','OFC')->sum('income_vn');
        $ofc_06 = D_claim_db_hipdata_code::where(DB::raw("Month(vstdate)"),'06')->where("hipdata_code",'=','OFC')->sum('income_vn');
        $ofc_07 = D_claim_db_hipdata_code::where(DB::raw("Month(vstdate)"),'07')->where("hipdata_code",'=','OFC')->sum('income_vn');
        $ofc_08 = D_claim_db_hipdata_code::where(DB::raw("Month(vstdate)"),'08')->where("hipdata_code",'=','OFC')->sum('income_vn');
        $ofc_09 = D_claim_db_hipdata_code::where(DB::raw("Month(vstdate)"),'09')->where("hipdata_code",'=','OFC')->sum('income_vn');

        $lgo_10 = D_claim_db_hipdata_code::where(DB::raw("Month(vstdate)"),'10')->where("hipdata_code",'=','LGO')->sum('income_vn');
        $lgo_11 = D_claim_db_hipdata_code::where(DB::raw("Month(vstdate)"),'11')->where("hipdata_code",'=','LGO')->sum('income_vn');
        $lgo_12 = D_claim_db_hipdata_code::where(DB::raw("Month(vstdate)"),'12')->where("hipdata_code",'=','LGO')->sum('income_vn');
        $lgo_01 = D_claim_db_hipdata_code::where(DB::raw("Month(vstdate)"),'01')->where("hipdata_code",'=','LGO')->sum('income_vn');
        $lgo_02 = D_claim_db_hipdata_code::where(DB::raw("Month(vstdate)"),'02')->where("hipdata_code",'=','LGO')->sum('income_vn');
        $lgo_03 = D_claim_db_hipdata_code::where(DB::raw("Month(vstdate)"),'03')->where("hipdata_code",'=','LGO')->sum('income_vn');
        $lgo_04 = D_claim_db_hipdata_code::where(DB::raw("Month(vstdate)"),'04')->where("hipdata_code",'=','LGO')->sum('income_vn');
        $lgo_05 = D_claim_db_hipdata_code::where(DB::raw("Month(vstdate)"),'05')->where("hipdata_code",'=','LGO')->sum('income_vn');
        $lgo_06 = D_claim_db_hipdata_code::where(DB::raw("Month(vstdate)"),'06')->where("hipdata_code",'=','LGO')->sum('income_vn');
        $lgo_07 = D_claim_db_hipdata_code::where(DB::raw("Month(vstdate)"),'07')->where("hipdata_code",'=','LGO')->sum('income_vn');
        $lgo_08 = D_claim_db_hipdata_code::where(DB::raw("Month(vstdate)"),'08')->where("hipdata_code",'=','LGO')->sum('income_vn');
        $lgo_09 = D_claim_db_hipdata_code::where(DB::raw("Month(vstdate)"),'09')->where("hipdata_code",'=','LGO')->sum('income_vn');

        $herf_10 = D_claim::where(DB::raw("Month(vstdate)"),'10')->where("nhso_adp_code",'LIKE','%HERB%')->sum('sum_price');
        $herf_11 = D_claim::where(DB::raw("Month(vstdate)"),'11')->where("nhso_adp_code",'LIKE','%HERB%')->sum('sum_price');
        $herf_12 = D_claim::where(DB::raw("Month(vstdate)"),'12')->where("nhso_adp_code",'LIKE','%HERB%')->sum('sum_price');
        $herf_01 = D_claim::where(DB::raw("Month(vstdate)"),'01')->where("nhso_adp_code",'LIKE','%HERB%')->sum('sum_price');
        $herf_02 = D_claim::where(DB::raw("Month(vstdate)"),'02')->where("nhso_adp_code",'LIKE','%HERB%')->sum('sum_price');
        $herf_03 = D_claim::where(DB::raw("Month(vstdate)"),'03')->where("nhso_adp_code",'LIKE','%HERB%')->sum('sum_price');
        $herf_04 = D_claim::where(DB::raw("Month(vstdate)"),'04')->where("nhso_adp_code",'LIKE','%HERB%')->sum('sum_price');
        $herf_05 = D_claim::where(DB::raw("Month(vstdate)"),'05')->where("nhso_adp_code",'LIKE','%HERB%')->sum('sum_price');
        $herf_06 = D_claim::where(DB::raw("Month(vstdate)"),'06')->where("nhso_adp_code",'LIKE','%HERB%')->sum('sum_price');
        $herf_07 = D_claim::where(DB::raw("Month(vstdate)"),'07')->where("nhso_adp_code",'LIKE','%HERB%')->sum('sum_price');
        $herf_08 = D_claim::where(DB::raw("Month(vstdate)"),'08')->where("nhso_adp_code",'LIKE','%HERB%')->sum('sum_price');
        $herf_09 = D_claim::where(DB::raw("Month(vstdate)"),'09')->where("nhso_adp_code",'LIKE','%HERB%')->sum('sum_price');

        $a12001_10 = D_claim::where(DB::raw("Month(vstdate)"),'10')->where("nhso_adp_code",'=','12001')->sum('sum_price');
        $a12001_11 = D_claim::where(DB::raw("Month(vstdate)"),'11')->where("nhso_adp_code",'=','12001')->sum('sum_price');
        $a12001_12 = D_claim::where(DB::raw("Month(vstdate)"),'12')->where("nhso_adp_code",'=','12001')->sum('sum_price');
        $a12001_01 = D_claim::where(DB::raw("Month(vstdate)"),'01')->where("nhso_adp_code",'=','12001')->sum('sum_price');
        $a12001_02 = D_claim::where(DB::raw("Month(vstdate)"),'02')->where("nhso_adp_code",'=','12001')->sum('sum_price');
        $a12001_03 = D_claim::where(DB::raw("Month(vstdate)"),'03')->where("nhso_adp_code",'=','12001')->sum('sum_price');
        $a12001_04 = D_claim::where(DB::raw("Month(vstdate)"),'04')->where("nhso_adp_code",'=','12001')->sum('sum_price');
        $a12001_05 = D_claim::where(DB::raw("Month(vstdate)"),'05')->where("nhso_adp_code",'=','12001')->sum('sum_price');
        $a12001_06 = D_claim::where(DB::raw("Month(vstdate)"),'06')->where("nhso_adp_code",'=','12001')->sum('sum_price');
        $a12001_07 = D_claim::where(DB::raw("Month(vstdate)"),'07')->where("nhso_adp_code",'=','12001')->sum('sum_price');
        $a12001_08 = D_claim::where(DB::raw("Month(vstdate)"),'08')->where("nhso_adp_code",'=','12001')->sum('sum_price');
        $a12001_09 = D_claim::where(DB::raw("Month(vstdate)"),'09')->where("nhso_adp_code",'=','12001')->sum('sum_price');

        $a12002_10 = D_claim::where(DB::raw("Month(vstdate)"),'10')->where("nhso_adp_code",'=','12002')->sum('sum_price');
        $a12002_11 = D_claim::where(DB::raw("Month(vstdate)"),'11')->where("nhso_adp_code",'=','12002')->sum('sum_price');
        $a12002_12 = D_claim::where(DB::raw("Month(vstdate)"),'12')->where("nhso_adp_code",'=','12002')->sum('sum_price');
        $a12002_01 = D_claim::where(DB::raw("Month(vstdate)"),'01')->where("nhso_adp_code",'=','12002')->sum('sum_price');
        $a12002_02 = D_claim::where(DB::raw("Month(vstdate)"),'02')->where("nhso_adp_code",'=','12002')->sum('sum_price');
        $a12002_03 = D_claim::where(DB::raw("Month(vstdate)"),'03')->where("nhso_adp_code",'=','12002')->sum('sum_price');
        $a12002_04 = D_claim::where(DB::raw("Month(vstdate)"),'04')->where("nhso_adp_code",'=','12002')->sum('sum_price');
        $a12002_05 = D_claim::where(DB::raw("Month(vstdate)"),'05')->where("nhso_adp_code",'=','12002')->sum('sum_price');
        $a12002_06 = D_claim::where(DB::raw("Month(vstdate)"),'06')->where("nhso_adp_code",'=','12002')->sum('sum_price');
        $a12002_07 = D_claim::where(DB::raw("Month(vstdate)"),'07')->where("nhso_adp_code",'=','12002')->sum('sum_price');
        $a12002_08 = D_claim::where(DB::raw("Month(vstdate)"),'08')->where("nhso_adp_code",'=','12002')->sum('sum_price');
        $a12002_09 = D_claim::where(DB::raw("Month(vstdate)"),'09')->where("nhso_adp_code",'=','12002')->sum('sum_price');

        $a30010_10 = D_claim::where(DB::raw("Month(vstdate)"),'10')->where("nhso_adp_code",'=','30010')->sum('sum_price');
        $a30010_11 = D_claim::where(DB::raw("Month(vstdate)"),'11')->where("nhso_adp_code",'=','30010')->sum('sum_price');
        $a30010_12 = D_claim::where(DB::raw("Month(vstdate)"),'12')->where("nhso_adp_code",'=','30010')->sum('sum_price');
        $a30010_01 = D_claim::where(DB::raw("Month(vstdate)"),'01')->where("nhso_adp_code",'=','30010')->sum('sum_price');
        $a30010_02 = D_claim::where(DB::raw("Month(vstdate)"),'02')->where("nhso_adp_code",'=','30010')->sum('sum_price');
        $a30010_03 = D_claim::where(DB::raw("Month(vstdate)"),'03')->where("nhso_adp_code",'=','30010')->sum('sum_price');
        $a30010_04 = D_claim::where(DB::raw("Month(vstdate)"),'04')->where("nhso_adp_code",'=','30010')->sum('sum_price');
        $a30010_05 = D_claim::where(DB::raw("Month(vstdate)"),'05')->where("nhso_adp_code",'=','30010')->sum('sum_price');
        $a30010_06 = D_claim::where(DB::raw("Month(vstdate)"),'06')->where("nhso_adp_code",'=','30010')->sum('sum_price');
        $a30010_07 = D_claim::where(DB::raw("Month(vstdate)"),'07')->where("nhso_adp_code",'=','30010')->sum('sum_price');
        $a30010_08 = D_claim::where(DB::raw("Month(vstdate)"),'08')->where("nhso_adp_code",'=','30010')->sum('sum_price');
        $a30010_09 = D_claim::where(DB::raw("Month(vstdate)"),'09')->where("nhso_adp_code",'=','30010')->sum('sum_price');

        $a30011_10 = D_claim::where(DB::raw("Month(vstdate)"),'10')->where("nhso_adp_code",'=','30011')->sum('sum_price');
        $a30011_11 = D_claim::where(DB::raw("Month(vstdate)"),'11')->where("nhso_adp_code",'=','30011')->sum('sum_price');
        $a30011_12 = D_claim::where(DB::raw("Month(vstdate)"),'12')->where("nhso_adp_code",'=','30011')->sum('sum_price');
        $a30011_01 = D_claim::where(DB::raw("Month(vstdate)"),'01')->where("nhso_adp_code",'=','30011')->sum('sum_price');
        $a30011_02 = D_claim::where(DB::raw("Month(vstdate)"),'02')->where("nhso_adp_code",'=','30011')->sum('sum_price');
        $a30011_03 = D_claim::where(DB::raw("Month(vstdate)"),'03')->where("nhso_adp_code",'=','30011')->sum('sum_price');
        $a30011_04 = D_claim::where(DB::raw("Month(vstdate)"),'04')->where("nhso_adp_code",'=','30011')->sum('sum_price');
        $a30011_05 = D_claim::where(DB::raw("Month(vstdate)"),'05')->where("nhso_adp_code",'=','30011')->sum('sum_price');
        $a30011_06 = D_claim::where(DB::raw("Month(vstdate)"),'06')->where("nhso_adp_code",'=','30011')->sum('sum_price');
        $a30011_07 = D_claim::where(DB::raw("Month(vstdate)"),'07')->where("nhso_adp_code",'=','30011')->sum('sum_price');
        $a30011_08 = D_claim::where(DB::raw("Month(vstdate)"),'08')->where("nhso_adp_code",'=','30011')->sum('sum_price');
        $a30011_09 = D_claim::where(DB::raw("Month(vstdate)"),'09')->where("nhso_adp_code",'=','30011')->sum('sum_price');

        $a30012_10 = D_claim::where(DB::raw("Month(vstdate)"),'10')->where("nhso_adp_code",'=','30012')->sum('sum_price');
        $a30012_11 = D_claim::where(DB::raw("Month(vstdate)"),'11')->where("nhso_adp_code",'=','30012')->sum('sum_price');
        $a30012_12 = D_claim::where(DB::raw("Month(vstdate)"),'12')->where("nhso_adp_code",'=','30012')->sum('sum_price');
        $a30012_01 = D_claim::where(DB::raw("Month(vstdate)"),'01')->where("nhso_adp_code",'=','30012')->sum('sum_price');
        $a30012_02 = D_claim::where(DB::raw("Month(vstdate)"),'02')->where("nhso_adp_code",'=','30012')->sum('sum_price');
        $a30012_03 = D_claim::where(DB::raw("Month(vstdate)"),'03')->where("nhso_adp_code",'=','30012')->sum('sum_price');
        $a30012_04 = D_claim::where(DB::raw("Month(vstdate)"),'04')->where("nhso_adp_code",'=','30012')->sum('sum_price');
        $a30012_05 = D_claim::where(DB::raw("Month(vstdate)"),'05')->where("nhso_adp_code",'=','30012')->sum('sum_price');
        $a30012_06 = D_claim::where(DB::raw("Month(vstdate)"),'06')->where("nhso_adp_code",'=','30012')->sum('sum_price');
        $a30012_07 = D_claim::where(DB::raw("Month(vstdate)"),'07')->where("nhso_adp_code",'=','30012')->sum('sum_price');
        $a30012_08 = D_claim::where(DB::raw("Month(vstdate)"),'08')->where("nhso_adp_code",'=','30012')->sum('sum_price');
        $a30012_09 = D_claim::where(DB::raw("Month(vstdate)"),'09')->where("nhso_adp_code",'=','30012')->sum('sum_price');

        $a30013_10 = D_claim::where(DB::raw("Month(vstdate)"),'10')->where("nhso_adp_code",'=','30013')->sum('sum_price');
        $a30013_11 = D_claim::where(DB::raw("Month(vstdate)"),'11')->where("nhso_adp_code",'=','30013')->sum('sum_price');
        $a30013_12 = D_claim::where(DB::raw("Month(vstdate)"),'12')->where("nhso_adp_code",'=','30013')->sum('sum_price');
        $a30013_01 = D_claim::where(DB::raw("Month(vstdate)"),'01')->where("nhso_adp_code",'=','30013')->sum('sum_price');
        $a30013_02 = D_claim::where(DB::raw("Month(vstdate)"),'02')->where("nhso_adp_code",'=','30013')->sum('sum_price');
        $a30013_03 = D_claim::where(DB::raw("Month(vstdate)"),'03')->where("nhso_adp_code",'=','30013')->sum('sum_price');
        $a30013_04 = D_claim::where(DB::raw("Month(vstdate)"),'04')->where("nhso_adp_code",'=','30013')->sum('sum_price');
        $a30013_05 = D_claim::where(DB::raw("Month(vstdate)"),'05')->where("nhso_adp_code",'=','30013')->sum('sum_price');
        $a30013_06 = D_claim::where(DB::raw("Month(vstdate)"),'06')->where("nhso_adp_code",'=','30013')->sum('sum_price');
        $a30013_07 = D_claim::where(DB::raw("Month(vstdate)"),'07')->where("nhso_adp_code",'=','30013')->sum('sum_price');
        $a30013_08 = D_claim::where(DB::raw("Month(vstdate)"),'08')->where("nhso_adp_code",'=','30013')->sum('sum_price');
        $a30013_09 = D_claim::where(DB::raw("Month(vstdate)"),'09')->where("nhso_adp_code",'=','30013')->sum('sum_price');

        $a30015_10 = D_claim::where(DB::raw("Month(vstdate)"),'10')->where("nhso_adp_code",'=','30015')->sum('sum_price');
        $a30015_11 = D_claim::where(DB::raw("Month(vstdate)"),'11')->where("nhso_adp_code",'=','30015')->sum('sum_price');
        $a30015_12 = D_claim::where(DB::raw("Month(vstdate)"),'12')->where("nhso_adp_code",'=','30015')->sum('sum_price');
        $a30015_01 = D_claim::where(DB::raw("Month(vstdate)"),'01')->where("nhso_adp_code",'=','30015')->sum('sum_price');
        $a30015_02 = D_claim::where(DB::raw("Month(vstdate)"),'02')->where("nhso_adp_code",'=','30015')->sum('sum_price');
        $a30015_03 = D_claim::where(DB::raw("Month(vstdate)"),'03')->where("nhso_adp_code",'=','30015')->sum('sum_price');
        $a30015_04 = D_claim::where(DB::raw("Month(vstdate)"),'04')->where("nhso_adp_code",'=','30015')->sum('sum_price');
        $a30015_05 = D_claim::where(DB::raw("Month(vstdate)"),'05')->where("nhso_adp_code",'=','30015')->sum('sum_price');
        $a30015_06 = D_claim::where(DB::raw("Month(vstdate)"),'06')->where("nhso_adp_code",'=','30015')->sum('sum_price');
        $a30015_07 = D_claim::where(DB::raw("Month(vstdate)"),'07')->where("nhso_adp_code",'=','30015')->sum('sum_price');
        $a30015_08 = D_claim::where(DB::raw("Month(vstdate)"),'08')->where("nhso_adp_code",'=','30015')->sum('sum_price');
        $a30015_09 = D_claim::where(DB::raw("Month(vstdate)"),'09')->where("nhso_adp_code",'=','30015')->sum('sum_price');

        return view('pkclaim.pkclaim_info', compact(
            'ofc_10','ofc_11','ofc_12','ofc_01','ofc_02','ofc_03','ofc_04','ofc_05','ofc_06','ofc_07','ofc_08','ofc_09',
            'lgo_10','lgo_11','lgo_12','lgo_01','lgo_02','lgo_03','lgo_04','lgo_05','lgo_06','lgo_07','lgo_08','lgo_09',
            'herf_10','herf_11','herf_12','herf_01','herf_02','herf_03','herf_04','herf_05','herf_06','herf_07','herf_08','herf_09',
            'a12001_10','a12001_11','a12001_12','a12001_01','a12001_02','a12001_03','a12001_04','a12001_05','a12001_06','a12001_07','a12001_08','a12001_09',
            'a12002_10','a12002_11','a12002_12','a12002_01','a12002_02','a12002_03','a12002_04','a12002_05','a12002_06','a12002_07','a12002_08','a12002_09',
            'a30015_10','a30015_11','a30015_12','a30015_01','a30015_02','a30015_03','a30015_04','a30015_05','a30015_06','a30015_07','a30015_08','a30015_09',

            'a30010_10','a30010_11','a30010_12','a30010_01','a30010_02','a30010_03','a30010_04','a30010_05','a30010_06','a30010_07','a30010_08','a30010_09',
            'a30011_10','a30011_11','a30011_12','a30011_01','a30011_02','a30011_03','a30011_04','a30011_05','a30011_06','a30011_07','a30011_08','a30011_09',
            'a30012_10','a30012_11','a30012_12','a30012_01','a30012_02','a30012_03','a30012_04','a30012_05','a30012_06','a30012_07','a30012_08','a30012_09',
            'a30013_10','a30013_11','a30013_12','a30013_01','a30013_02','a30013_03','a30013_04','a30013_05','a30013_06','a30013_07','a30013_08','a30013_09',

        ));
    }
    public function fs_eclaim(Request $request)
    {
        $data['com_tec'] = DB::table('com_tec')->get();
        $data['users'] = User::get();

        Ins_eclaimxxx::truncate();
        $datashow_ = DB::connection('mysql7')->select('   
            SELECT HIPDATA_CODE as hipdata,count(distinct icode) as icodex from claim.ins_eclaimx
            GROUP BY HIPDATA_CODE;   
        '); 
        foreach ($datashow_ as $key => $value) {
            Ins_eclaimxxx::insert([
                'hipdata' => $value->hipdata,
                'icodex' => $value->icodex,                      
            ]);
        }
        $datashow = DB::connection('mysql7')->select('  
            SELECT * FROM ins_eclaimxxx
        '); 
        $datashow2 = DB::connection('mysql7')->select('  
            SELECT f.fs_eclaim_id,i.income,i.name as iname,count(f.billcode) as billcode 
            from claim.fs_eclaim f
            LEFT JOIN hos.income i on i.group2 = f.income
            GROUP BY i.income
        '); 
        $datashow3 = DB::connection('mysql3')->select('  
            SELECT i.income,i.name as iname,count(f.icode) as hosicode,count(distinct nn.icode) as xxxicode,count(distinct nm.icode) as icode999 
            FROM hos.nondrugitems f
            LEFT JOIN hos.income i on i.group2 = f.income
            LEFT JOIN nondrugitems nn on nn.icode = f.icode and nn.nhso_adp_code like "%xx%" and nn.istatus ="y"
            LEFT JOIN nondrugitems nm on nm.icode = f.icode and nm.nhso_adp_code like "%999%" and nm.istatus ="y"
            where f.istatus ="y"
            and f.income is not null
            GROUP BY f.income
        '); 
       
        return view('pkclaim.fs_eclaim',[
            'datashow'   => $datashow,
            'datashow2'  => $datashow2,
            'datashow3'  => $datashow3
        ]);
    }
    public function bk_getbar(Request $request)
    {
        $date = date("Y-m-d");
        $newDate = date('Y-m-d', strtotime($date . ' -1 months')); //ย้อนหลัง 1 เดือน  
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์  

        $type_chart5 = DB::connection('mysql3')->table('pttype')->select('pttype', 'name', 'pcode')->get(); 
        foreach ($type_chart5 as $item) {

            $data_count = DB::connection('mysql3')->table('ovst')->where('pttype', '=', $item->pttype)->WhereBetween('vstdate', [$newDate, $date])->count(); //ย้อนหลัง 1 เดือน  
            $data_count_week = DB::connection('mysql3')->table('ovst')->where('pttype', '=', $item->pttype)->WhereBetween('vstdate', [$newweek, $date])->count();  //ย้อนหลัง 1 สัปดาห์

            if ($data_count > 0) {
                $dataset[] = [
                    'label' => $item->name,
                    'count' => $data_count
                ];
            }

            if ($data_count_week > 0) {
                $dataset_2[] = [
                    'label_week' => $item->name,
                    'count_week' => $data_count_week
                ];
            }
        }
 
        $chartData_dataset = $dataset;
        $chartData_dataset_week = $dataset_2; 
        return response()->json([
            'status'             => '200', 
            'chartData_dataset_week'    => $chartData_dataset_week,
            'chartData_dataset'  => $chartData_dataset
        ]);
    }
    public function fs_eclaim_instu_eclaim(Request $request,$income)
    {
        $data['com_tec'] = DB::table('com_tec')->get(); 

        $datashow_ = DB::connection('mysql7')->select('  
            SELECT nn.icode,i.group2,f.billcode as fbillcode,n.billcode as nbillcode,f.dname,f.pay_rate,n.price,n.price2,n.price3,concat(n.nhso_adp_type_id,"=",n1.nhso_adp_code_name) as type
            ,n.nhso_adp_code 
            from claim.fs_eclaim f
            LEFT JOIN hos.income i on i.group2 = f.income
            LEFT JOIN hos.nondrugitems n on n.billcode = f.billcode 
            LEFT JOIN hos.nondrugitems nn on nn.icode = n.icode
            LEFT JOIN hos.nhso_adp_code n1 on n1.nhso_adp_code= nn.nhso_adp_code
            where i.group2 = "'.$income.'"
          
            group by f.billcode,f.dname,f.pay_rate 
            order by f.billcode
        '); 
        // and nn.icode <> ""
        return view('pkclaim.fs_eclaim_instu_eclaim',[
            'datashow_'   => $datashow_,            
        ]);
    }

    public function fs_eclaim_editable(Request $request)
    {
        if ($request->ajax())
         {
            if ($request->action == 'Edit') 
            {
               $data = array(
                'price'    =>   $request->price,
                'price2'   =>   $request->price2,
                'price3'   =>   $request->price3,
               );
               DB::connection('mysql3')->table('nondrugitems')
               ->where('icode',$request->icode)
               ->update($data);
            }
            return request()->json($request);
        }
    }
}
