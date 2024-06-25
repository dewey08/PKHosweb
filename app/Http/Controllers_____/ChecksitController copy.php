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



class ChecksitController extends Controller
{
    public function check_authen(Request $request)
    {
        $datestart = $request->startdate;
        $dateend = $request->enddate;

            $data_show = DB::connection('mysql')->select('
                SELECT *
                FROM check_authen
                GROUP BY vstdate
                ORDER BY vstdate DESC;
            ');
            // WHERE vstdate BETWEEN "'.$datestart.'" AND "'.$dateend.'"
        return view('authen.check_authen',[
            'data_show'       => $data_show,
            'datestart'      => $datestart,
            'dateend'        => $dateend,
        ]);
    }
    

    function check_authen_excel(Request $request){
        $this->validate($request, [
            'uploaded_file' => 'required|file|mimes:xls,xlsx'
        ]);
        $the_file = $request->file('uploaded_file');
        try{
            $spreadsheet = IOFactory::load($the_file->getRealPath());
            $sheet        = $spreadsheet->getActiveSheet();
            $row_limit    = $sheet->getHighestDataRow();
            $column_limit = $sheet->getHighestDataColumn();
            $row_range    = range( 2, $row_limit );
            $column_range = range( 'F', $column_limit );
            $startcount = 2;
            $data = array();
            foreach ( $row_range as $row ) {
                $data[] = [
                    'hcode'                 =>$sheet->getCell( 'A' . $row )->getValue(),
                    'hosname'               =>$sheet->getCell( 'B' . $row )->getValue(),
                    'cid'                   =>$sheet->getCell( 'C' . $row )->getValue(),
                    'fullname'              =>$sheet->getCell( 'D' . $row )->getValue(),
                    'birthday'              =>$sheet->getCell( 'E' . $row )->getValue(),
                    'homtel'                =>$sheet->getCell( 'F' . $row )->getValue(),
                    'mainpttype'            =>$sheet->getCell( 'G' . $row )->getValue(),
                    'subpttype'             =>$sheet->getCell( 'H' . $row )->getValue(),
                    'repcode'               =>$sheet->getCell( 'I' . $row )->getValue(),
                    'claimcode'             =>$sheet->getCell( 'J' . $row )->getValue(),
                    'claimtype'             =>$sheet->getCell( 'K' . $row )->getValue(),
                    'servicerep'            =>$sheet->getCell( 'L' . $row )->getValue(),
                    'servicename'           =>$sheet->getCell( 'M' . $row )->getValue(),
                    'hncode'                =>$sheet->getCell( 'N' . $row )->getValue(),
                    'ancode'                =>$sheet->getCell( 'O' . $row )->getValue(),
                    'vstdate'               =>$sheet->getCell( 'P' . $row )->getValue(),
                    'regdate'               =>$sheet->getCell( 'Q' . $row )->getValue(),
                    'status'                =>$sheet->getCell( 'R' . $row )->getValue(),
                    'requestauthen'         =>$sheet->getCell( 'S' . $row )->getValue(),
                    'authentication'        =>$sheet->getCell( 'T' . $row )->getValue(),
                    'staff_service'         =>$sheet->getCell( 'U' . $row )->getValue(),
                    'date_editauthen'       =>$sheet->getCell( 'V' . $row )->getValue(),
                    'name_editauthen'       =>$sheet->getCell( 'W' . $row )->getValue(),
                    'comment'               =>$sheet->getCell( 'X' . $row )->getValue(),
                ];
                $startcount++;
            }
            DB::table('check_authenexcel')->insert($data);
            // DB::table('check_authen')->insert($data);
        } catch (Exception $e) {
            $error_code = $e->errorInfo[1];
            return back()->withErrors('There was a problem uploading the data!');
        }
            // return back()->withSuccess('Great! Data has been successfully uploaded.');
                    return response()->json([
                    'status'    => '200',
                ]);

    }


    public function upstm_ofcexcel_senddata(Request $request)
    {
        $data_ = DB::connection('mysql')->select('
            SELECT *
            FROM acc_stm_ofcexcel
        ');
        // GROUP BY cid,vstdate
        foreach ($data_ as $key => $value) {
                Acc_stm_ofc::create([
                    'repno'             => $value->repno,
                    'no'                => $value->no,
                    'hn'                => $value->hn,
                    'an'                => $value->an,
                    'cid'               => $value->cid,
                    'fullname'          => $value->fullname,
                    'vstdate'           => $value->vstdate,
                    'dchdate'           => $value->dchdate,
                    'PROJCODE'          => $value->PROJCODE,
                    'AdjRW'             => $value->AdjRW,
                    'price_req'         => $value->price_req,
                    'prb'               => $value->prb,
                    'room'              => $value->room,
                    'inst'              => $value->inst,
                    'drug'              => $value->drug,
                    'income'            => $value->income,
                    'refer'             => $value->refer,
                    'waitdch'           => $value->waitdch,
                    'service'           => $value->service,
                    'pricereq_all'      => $value->pricereq_all,
                    'STMdoc'            => $value->STMdoc,
                    'HDflag'            => 'OFC'
                ]);
                acc_1102050101_4022::where('cid',$value->cid)->where('vstdate',$value->vstdate)
                ->update([
                    'status'   => 'Y'
                ]);
        }
        Acc_stm_ofcexcel::truncate();
        // return response()->json([
        //     'status'    => '200',
        // ]);
        return redirect()->back();
    }
    public function check_sit_day(Request $request)
    {
        $datestart = $request->startdate;
        $dateend = $request->enddate;

            $data_sit = DB::connection('mysql')->select('
                SELECT
                c.vn,c.hn,c.an,c.cid,c.hometel,c.vstdate,c.fullname,c.hospmain,c.hospsub,c.pttype,c.subinscl,c.main_dep
                ,c.hmain,c.hsub,c.subinscl_name,c.`status`,ca.claimcode,ca.servicerep,ca.claimtype,c.staff,c.fokliad,k.department
                FROM check_sit_auto c
                LEFT JOIN kskdepartment k ON k.depcode = c.main_dep
                LEFT JOIN check_authen ca ON ca.cid = c.cid and c.vstdate = ca.vstdate 

                WHERE c.vstdate BETWEEN "'.$datestart.'" AND "'.$dateend.'"
                AND c.pttype NOT IN("M1","M2","M3","M4","M5","M6")
                GROUP BY c.vn
            ');
        // }
        // LEFT JOIN check_authen ca ON ca.cid = c.cid and c.vstdate = ca.vstdate AND c.fokliad = ca.claimtype
        // SELECT vn,cid,vstdate,fullname,pttype,hospmain,hospsub,subinscl,hmain,hsub,staff,subinscl_name
        return view('authen.check_sit_day',[
            'data_sit'    => $data_sit,
            'start'     => $datestart,
            'end'        => $dateend,
        ]);
    }
    public function check_sit_daysearch(Request $request)
    {
        $datestart = $request->datestart;
        $dateend = $request->dateend;
        // dd($dateend);

        if ($datestart == '') {
            $data_sits = DB::connection('mysql3')->select('
                SELECT o.vn,p.hn,p.cid,o.vstdate,o.vsttime,o.pttype,concat(p.pname,p.fname," ",p.lname) as fullname,o.staff,pt.nhso_code,o.hospmain,o.hospsub
                FROM ovst o
                join patient p on p.hn=o.hn
                JOIN pttype pt on pt.pttype=o.pttype
                JOIN opduser op on op.loginname = o.staff
                WHERE o.vstdate = CURDATE()
                group by p.cid
            ');
            // AND pt.pttype_eclaim_id not in("06","27","28","36")
            foreach ($data_sits as $key => $value) {
                // Check_sit_auto::truncate();
                $check = Check_sit_auto::where('vn', $value->vn)->count();
                if ($check > 0) {
                    Check_sit_auto::where('vn', $value->vn)
                        ->update([
                            'hn' => $value->hn,
                            'cid' => $value->cid,
                            'vstdate' => $value->vstdate,
                            'vsttime' => $value->vsttime,
                            'fullname' => $value->fullname,
                            'hospmain' => $value->hospmain,
                            'hospsub' => $value->hospsub,
                            'pttype' => $value->pttype,
                            'staff' => $value->staff
                        ]);
                } else {
                    Check_sit_auto::insert([
                        'vn' => $value->vn,
                        'hn' => $value->hn,
                        'cid' => $value->cid,
                        'vstdate' => $value->vstdate,
                        'vsttime' => $value->vsttime,
                        'fullname' => $value->fullname,
                        'pttype' => $value->pttype,
                        'hospmain' => $value->hospmain,
                        'hospsub' => $value->hospsub,
                        'staff' => $value->staff
                    ]);
                }
            }

            $data_sit = DB::connection('mysql7')->select('
                SELECT *
                FROM check_sit_auto
                WHERE vstdate = CURDATE()
            ');

        } else {
            $data_sits = DB::connection('mysql3')->select('
                SELECT o.vn,p.hn,p.cid,o.vstdate,o.vsttime,o.pttype,concat(p.pname,p.fname," ",p.lname) as fullname,o.staff,pt.nhso_code,o.hospmain,o.hospsub
                FROM ovst o
                join patient p on p.hn=o.hn
                JOIN pttype pt on pt.pttype=o.pttype
                JOIN opduser op on op.loginname = o.staff
                WHERE o.vstdate BETWEEN "'.$datestart.'" AND "'.$dateend.'"
                group by p.cid
            ');
                foreach ($data_sits as $key => $value) {
                    // Check_sit_auto::truncate();
                    $check = Check_sit_auto::where('vn', $value->vn)->count();
                    if ($check > 0) {
                        Check_sit_auto::where('vn', $value->vn)
                            ->update([
                                'hn' => $value->hn,
                                'cid' => $value->cid,
                                'vstdate' => $value->vstdate,
                                'vsttime' => $value->vsttime,
                                'fullname' => $value->fullname,
                                'hospmain' => $value->hospmain,
                                'hospsub' => $value->hospsub,
                                'pttype' => $value->pttype,
                                'staff' => $value->staff
                            ]);
                    } else {
                        Check_sit_auto::insert([
                            'vn' => $value->vn,
                            'hn' => $value->hn,
                            'cid' => $value->cid,
                            'vstdate' => $value->vstdate,
                            'vsttime' => $value->vsttime,
                            'fullname' => $value->fullname,
                            'pttype' => $value->pttype,
                            'hospmain' => $value->hospmain,
                            'hospsub' => $value->hospsub,
                            'staff' => $value->staff
                        ]);
                    }
                }
            $data_sit = DB::connection('mysql7')->select('
                SELECT *
                FROM check_sit_auto
                WHERE vstdate BETWEEN "'.$datestart.'" AND "'.$dateend.'"
            ');

        }
        // AND pt.pttype_eclaim_id not in("06","27","28","36")


        // if ($datestart == '') {
        //     $data_sit = DB::connection('mysql7')->select('
        //         SELECT *
        //         FROM check_sit_auto
        //         WHERE vstdate = CURDATE()
        //     ');
        // } else {
        //     $data_sit = DB::connection('mysql7')->select('
        //         SELECT *
        //         FROM check_sit_auto
        //         WHERE vstdate BETWEEN "'.$datestart.'" AND "'.$dateend.'"
        //     ');
        // }
        return response()->json([
            'status'     => '200',
             'data_sit'    => $data_sit,
            'start'     => $datestart,
            'end'        => $dateend,
        ]);
        // return view('authen.check_sit_day ',[
        //     'data_sit'    => $data_sit,
        //     'start'     => $datestart,
        //     'end'        => $dateend,
        // ]);
    }
     // ดึงข้อมูลมาไว้เช็คสิทธิ์
     public function check_sit_daypullauto(Request $request)
     {
             $data_sits = DB::connection('mysql3')->select('
                 SELECT o.an,o.vn,p.hn,p.cid,p.hometel,o.vstdate,o.vsttime,o.pttype,concat(p.pname,p.fname," ",p.lname) as fullname,o.main_dep,o.staff,pt.nhso_code,o.hospmain,o.hospsub
                 ,if(op.icode IN ("3010058"),sum_price,0) as fokliad
                 FROM ovst o
                 LEFT JOIN opitemrece op ON op.vn = o.vn
                 join patient p on p.hn=o.hn
                 JOIN pttype pt on pt.pttype=o.pttype
                 JOIN opduser od on od.loginname = o.staff
                 WHERE o.vstdate = CURDATE() 
                 AND o.main_dep NOT IN("011","036","107")
                 AND o.pttype NOT IN("M1","M2","M3","M4","M5","M6")
                 group by o.vn
                 limit 1500
             ');
             // CURDATE() "2023-07-10"
             foreach ($data_sits as $key => $value) {
                 $check = Check_sit_auto::where('vn', $value->vn)->count();
                //  $check = Check_sit_auto::where('vn', $value->vn)->where('fokliad', '>', 0)->count();
                    if ($check > 0) {
                        Check_sit_auto::where('vn', $value->vn)
                        ->update([
                            'vn' => $value->vn,
                            'an' => $value->an,
                            'hn' => $value->hn,
                            'cid' => $value->cid,
                            'hometel' => $value->hometel,
                            'vstdate' => $value->vstdate,
                            'vsttime' => $value->vsttime,
                            'fullname' => $value->fullname,
                            'pttype' => $value->pttype,
                            'hospmain' => $value->hospmain,
                            'hospsub' => $value->hospsub,
                            'staff' => $value->staff,
                            'main_dep' => $value->main_dep,
                            // 'fokliad' => 'PG0130001'
                            'fokliad' => $value->fokliad
                        ]);
                    } else {
                        Check_sit_auto::insert([
                            'vn' => $value->vn,
                            'an' => $value->an,
                            'hn' => $value->hn,
                            'cid' => $value->cid,
                            'hometel' => $value->hometel,
                            'vstdate' => $value->vstdate,
                            'vsttime' => $value->vsttime,
                            'fullname' => $value->fullname,
                            'pttype' => $value->pttype,
                            'hospmain' => $value->hospmain,
                            'hospsub' => $value->hospsub,
                            'staff' => $value->staff,
                            'main_dep' => $value->main_dep,
                            // 'fokliad' => 'PG0060001'
                            'fokliad' => $value->fokliad
                        ]);
                    }

             }
             $data_sits_ipd = DB::connection('mysql3')->select('
                SELECT a.an,a.vn,p.hn,p.cid,a.dchdate,a.pttype
                from ovst o
                LEFT JOIN hos.ipt ip ON ip.an = o.an
                LEFT JOIN hos.an_stat a ON ip.an = a.an
                LEFT JOIN hos.vn_stat v on v.vn = a.vn
                LEFT JOIN patient p on p.hn=a.hn
                WHERE a.dchdate = CURDATE()
                group by p.cid
                limit 1500

             ');
             // CURDATE()
             foreach ($data_sits_ipd as $key => $value2) {
                 $check = Check_sit_auto::where('an', $value2->an)->count();
                 if ($check == 0) {
                     Check_sit_auto::insert([
                         'vn' => $value2->vn,
                         'an' => $value2->an,
                         'hn' => $value2->hn,
                         'cid' => $value2->cid,
                         'pttype' => $value2->pttype,
                         'dchdate' => $value2->dchdate
                     ]);
                 }
             }
             return view('authen.check_sit_daypullauto');
     }
     public function check_sit_daysitauto(Request $request)
     {
         $datestart = $request->datestart;
         $dateend = $request->dateend;
         $date = date('Y-m-d');
         $token_data = DB::connection('mysql')->select('
             SELECT cid,token FROM ssop_token
         ');

         foreach ($token_data as $key => $valuetoken) {
             $cid_ = $valuetoken->cid;
             $token_ = $valuetoken->token;
         }
         $data_sitss = DB::connection('mysql')->select('
             SELECT cid,vn,an
             FROM check_sit_auto
             WHERE vstdate = CURDATE()
             AND subinscl IS NULL
             LIMIT 100
         ');
        //  AND `status` is null
         // BETWEEN "2023-07-01" AND "2023-07-13"      = CURDATE()     WHERE vstdate BETWEEN "2023-06-01" AND "2023-06-30"
         foreach ($data_sitss as $key => $item) {
             $pids = $item->cid;
             $vn = $item->vn;
             $an = $item->an;
             $client = new SoapClient("http://ucws.nhso.go.th/ucwstokenp1/UCWSTokenP1?wsdl",
                 array(
                     "uri" => 'http://ucws.nhso.go.th/ucwstokenp1/UCWSTokenP1?xsd=1',
                                     "trace"      => 1,
                                     "exceptions" => 0,
                                     "cache_wsdl" => 0
                     )
                 );
                 $params = array(
                     'sequence' => array(
                         "user_person_id" => "$cid_",
                         "smctoken" => "$token_",
                         "person_id" => "$pids"
                 )
             );
             $contents = $client->__soapCall('searchCurrentByPID',$params);
             foreach ($contents as $v) {
                 @$status = $v->status ;
                 @$maininscl = $v->maininscl;
                 @$startdate = $v->startdate;
                 @$hmain = $v->hmain ;
                 @$subinscl = $v->subinscl ;
                 @$person_id_nhso = $v->person_id;

                 @$hmain_op = $v->hmain_op;  //"10978"
                 @$hmain_op_name = $v->hmain_op_name;  //"รพ.ภูเขียวเฉลิมพระเกียรติ"
                 @$hsub = $v->hsub;    //"04047"
                 @$hsub_name = $v->hsub_name;   //"รพ.สต.แดงสว่าง"
                 @$subinscl_name = $v->subinscl_name ; //"ช่วงอายุ 12-59 ปี"


                 IF(@$maininscl == "" || @$maininscl == null || @$status == "003" ){ #ถ้าเป็นค่าว่างไม่ต้อง insert
                     $date = date("Y-m-d");
                     Check_sit_auto::where('vn', $vn)
                         ->update([
                             'status' => 'จำหน่าย/เสียชีวิต',
                             'maininscl' => @$maininscl,
                             'startdate' => @$startdate,
                             'hmain' => @$hmain,
                             'subinscl' => @$subinscl,
                             'person_id_nhso' => @$person_id_nhso,
                             'hmain_op' => @$hmain_op,
                             'hmain_op_name' => @$hmain_op_name,
                             'hsub' => @$hsub,
                             'hsub_name' => @$hsub_name,
                             'subinscl_name' => @$subinscl_name,
                             'upsit_date'    => $date
                     ]);
                     Check_sit_auto_claim::where('vn', $vn)
                         ->update([
                             'status' => 'จำหน่าย/เสียชีวิต',
                             'maininscl' => @$maininscl,
                             'startdate' => @$startdate,
                             'hmain' => @$hmain,
                             'subinscl' => @$subinscl,
                             'person_id_nhso' => @$person_id_nhso,
                             'hmain_op' => @$hmain_op,
                             'hmain_op_name' => @$hmain_op_name,
                             'hsub' => @$hsub,
                             'hsub_name' => @$hsub_name,
                             'subinscl_name' => @$subinscl_name,
                             'upsit_date'    => $date
                     ]);

                     Acc_debtor::where('vn', $vn)
                         ->update([
                             'status' => @$status,
                             'maininscl' => @$maininscl,
                             'hmain' => @$hmain,
                             'subinscl' => @$subinscl,
                             'pttype_spsch' => @$subinscl,
                             'hsub' => @$hsub,

                     ]);
                 }elseif(@$maininscl !="" || @$subinscl !=""){
                         $date2 = date("Y-m-d");
                             Check_sit_auto::where('vn', $vn)
                             ->update([
                                 'status' => @$status,
                                 'maininscl' => @$maininscl,
                                 'startdate' => @$startdate,
                                 'hmain' => @$hmain,
                                 'subinscl' => @$subinscl,
                                 'person_id_nhso' => @$person_id_nhso,
                                 'hmain_op' => @$hmain_op,
                                 'hmain_op_name' => @$hmain_op_name,
                                 'hsub' => @$hsub,
                                 'hsub_name' => @$hsub_name,
                                 'subinscl_name' => @$subinscl_name,
                                 'upsit_date'    => $date2
                             ]);
                             Check_sit_auto_claim::where('vn', $vn)
                             ->update([
                                 'status' => @$status,
                                 'maininscl' => @$maininscl,
                                 'startdate' => @$startdate,
                                 'hmain' => @$hmain,
                                 'subinscl' => @$subinscl,
                                 'person_id_nhso' => @$person_id_nhso,
                                 'hmain_op' => @$hmain_op,
                                 'hmain_op_name' => @$hmain_op_name,
                                 'hsub' => @$hsub,
                                 'hsub_name' => @$hsub_name,
                                 'subinscl_name' => @$subinscl_name,
                                 'upsit_date'    => $date2
                             ]);
                             Acc_debtor::where('vn', $vn)
                                 ->update([
                                     'status' => @$status,
                                     'maininscl' => @$maininscl,
                                     'hmain' => @$hmain,
                                     'subinscl' => @$subinscl,
                                     'pttype_spsch' => @$subinscl,
                                     'hsub' => @$hsub,

                                 ]);
                             Acc_debtor::where('an', $an)
                                 ->update([
                                     'status' => @$status,
                                     'maininscl' => @$maininscl,
                                     'hmain' => @$hmain,
                                     'subinscl' => @$subinscl,
                                     'pttype_spsch' => @$subinscl,
                                     'hsub' => @$hsub,

                                 ]);

                 }

             }
         }

         return view('authen.check_sit_daysitauto');

     }

    public function check_sit_pull(Request $request)
    {
        $datestart = $request->datestart;
        $dateend = $request->dateend;
        // dd($datestart);

        // if ($datestart == '') {
        //     $data_sits = DB::connection('mysql3')->select('
        //         SELECT o.vn,p.hn,p.cid,o.vstdate,o.vsttime,o.pttype,concat(p.pname,p.fname," ",p.lname) as fullname,o.staff,pt.nhso_code,o.hospmain,o.hospsub
        //         FROM ovst o
        //         join patient p on p.hn=o.hn
        //         JOIN pttype pt on pt.pttype=o.pttype
        //         JOIN opduser op on op.loginname = o.staff
        //         WHERE o.vstdate = CURDATE()
        //         group by p.cid
        //     ');

        //     foreach ($data_sits as $key => $value) {
        //         $check = Check_sit_auto::where('vn', $value->vn)->count();
        //         if ($check > 0) {
        //             Check_sit_auto::where('vn', $value->vn)
        //                 ->update([
        //                     'hn' => $value->hn,
        //                     'cid' => $value->cid,
        //                     'vstdate' => $value->vstdate,
        //                     'vsttime' => $value->vsttime,
        //                     'fullname' => $value->fullname,
        //                     'hospmain' => $value->hospmain,
        //                     'hospsub' => $value->hospsub,
        //                     'pttype' => $value->pttype,
        //                     'staff' => $value->staff
        //                 ]);
        //         } else {
        //             Check_sit_auto::insert([
        //                 'vn' => $value->vn,
        //                 'hn' => $value->hn,
        //                 'cid' => $value->cid,
        //                 'vstdate' => $value->vstdate,
        //                 'vsttime' => $value->vsttime,
        //                 'fullname' => $value->fullname,
        //                 'pttype' => $value->pttype,
        //                 'hospmain' => $value->hospmain,
        //                 'hospsub' => $value->hospsub,
        //                 'staff' => $value->staff
        //             ]);
        //         }
        //     }

        // } else {
            $data_sits = DB::connection('mysql3')->select('
                SELECT o.vn,p.hn,p.cid,o.vstdate,o.vsttime,o.pttype,concat(p.pname,p.fname," ",p.lname) as fullname,o.staff,pt.nhso_code,o.hospmain,o.hospsub
                FROM ovst o
                join patient p on p.hn=o.hn
                JOIN pttype pt on pt.pttype=o.pttype
                JOIN opduser op on op.loginname = o.staff
                WHERE o.vstdate BETWEEN "'.$datestart.'" AND "'.$dateend.'"
                group by p.cid
            ');
                foreach ($data_sits as $key => $value) {
                    // Check_sit_auto::truncate();
                    $check = Check_sit_auto::where('vn', $value->vn)->count();
                    if ($check > 0) {
                        Check_sit_auto::where('vn', $value->vn)
                            ->update([
                                'hn' => $value->hn,
                                'cid' => $value->cid,
                                'vstdate' => $value->vstdate,
                                'vsttime' => $value->vsttime,
                                'fullname' => $value->fullname,
                                'hospmain' => $value->hospmain,
                                'hospsub' => $value->hospsub,
                                'pttype' => $value->pttype,
                                'staff' => $value->staff
                            ]);
                    } else {
                        Check_sit_auto::insert([
                            'vn' => $value->vn,
                            'hn' => $value->hn,
                            'cid' => $value->cid,
                            'vstdate' => $value->vstdate,
                            'vsttime' => $value->vsttime,
                            'fullname' => $value->fullname,
                            'pttype' => $value->pttype,
                            'hospmain' => $value->hospmain,
                            'hospsub' => $value->hospsub,
                            'staff' => $value->staff
                        ]);
                    }
                }
            // $data_sit = DB::connection('mysql7')->select('
            //     SELECT *
            //     FROM check_sit_auto
            //     WHERE vstdate BETWEEN "'.$datestart.'" AND "'.$dateend.'"
            // ');

        // }

        return response()->json([
            'status'     => '200',
            //  'data_sit'    => $data_sit,
            'start'     => $datestart,
            'end'        => $dateend,
        ]);
        // return view('authen.check_sit_day ',[
        //     'data_sit'    => $data_sit,
        //     'start'     => $datestart,
        //     'end'        => $dateend,
        // ]);
    }
    public function check_sit_font(Request $request)
    {
        $datestart = $request->datestart;
        $dateend = $request->dateend;
        $date = date('Y-m-d');

        $token_data = DB::connection('mysql')->select('
            SELECT cid,token FROM ssop_token
        ');
        foreach ($token_data as $key => $valuetoken) {
            $cid_ = $valuetoken->cid;
            $token_ = $valuetoken->token;
        }
        // $data_sitss = DB::connection('mysql7')->select('
        $data_sitss = DB::connection('mysql')->select('
            SELECT cid,vn
            FROM check_sit_auto
            WHERE vstdate BETWEEN "'.$datestart.'" AND "'.$dateend.'"
            AND subinscl IS NULL
            AND upsit_date IS NULL
            LIMIT 30
        ');
        // AND person_id_nhso IS NULL

        // AND upsit_date IS NULL
        // AND status <> "จำหน่าย/เสียชีวิต"
        // dd($data_sitss);
        // WHERE vstdate BETWEEN "'.$datestart.'" AND "'.$dateend.'"

        // WHERE vstdate = CURDATE()
        // WHERE vstdate = "2023-01-25"
        // WHERE vstdate = CURDATE()
        // BETWEEN "'.$datestart.'" AND "'.$dateend.'"
        // set_time_limit(1000);
        // $i = 0;
        foreach ($data_sitss as $key => $item) {
            $pids = $item->cid;
            $vn = $item->vn;

            // sleep(1000);
            // $i++;
            // dd($pids);
            $client = new SoapClient("http://ucws.nhso.go.th/ucwstokenp1/UCWSTokenP1?wsdl",
                array(
                    "uri" => 'http://ucws.nhso.go.th/ucwstokenp1/UCWSTokenP1?xsd=1',
                                    "trace"      => 1,
                                    "exceptions" => 0,
                                    "cache_wsdl" => 0
                    )
                );
                $params = array(
                    'sequence' => array(
                        "user_person_id" => "$cid_",
                        "smctoken" => "$token_",
                        "person_id" => "$pids"
                )
            );
            $contents = $client->__soapCall('searchCurrentByPID',$params);

            // dd($contents);
            foreach ($contents as $v) {
                @$status = $v->status ;
                @$maininscl = $v->maininscl;
                @$startdate = $v->startdate;
                @$hmain = $v->hmain ;
                @$subinscl = $v->subinscl ;
                @$person_id_nhso = $v->person_id;

                @$hmain_op = $v->hmain_op;  //"10978"
                @$hmain_op_name = $v->hmain_op_name;  //"รพ.ภูเขียวเฉลิมพระเกียรติ"
                @$hsub = $v->hsub;    //"04047"
                @$hsub_name = $v->hsub_name;   //"รพ.สต.แดงสว่าง"
                @$subinscl_name = $v->subinscl_name ; //"ช่วงอายุ 12-59 ปี"
                IF(@$maininscl == "" || @$maininscl == null || @$status == "003" ){ #ถ้าเป็นค่าว่างไม่ต้อง insert
                    $date = date("Y-m-d");
                    Check_sit_auto::where('vn', $vn)
                                ->update([
                                    'status' => 'จำหน่าย/เสียชีวิต',
                                    'maininscl' => @$maininscl,
                                    'startdate' => @$startdate,
                                    'hmain' => @$hmain,
                                    'subinscl' => @$subinscl,
                                    'person_id_nhso' => @$person_id_nhso,

                                    'hmain_op' => @$hmain_op,
                                    'hmain_op_name' => @$hmain_op_name,
                                    'hsub' => @$hsub,
                                    'hsub_name' => @$hsub_name,
                                    'subinscl_name' => @$subinscl_name,
                                    'upsit_date'    => $date
                                ]);
                }elseif(@$maininscl !="" || @$subinscl !=""){
                        $date2 = date("Y-m-d");
                            Check_sit_auto::where('vn', $vn)
                            ->update([
                                'status' => @$status,
                                'maininscl' => @$maininscl,
                                'startdate' => @$startdate,
                                'hmain' => @$hmain,
                                'subinscl' => @$subinscl,
                                'person_id_nhso' => @$person_id_nhso,

                                'hmain_op' => @$hmain_op,
                                'hmain_op_name' => @$hmain_op_name,
                                'hsub' => @$hsub,
                                'hsub_name' => @$hsub_name,
                                'subinscl_name' => @$subinscl_name,
                                'upsit_date'    => $date2
                            ]);

                }

            }
        }
        $data_sit = DB::connection('mysql')->select('
                SELECT vn,cid,vstdate,fullname,pttype,hospmain,hospsub,subinscl,hmain,hsub,staff,subinscl_name
                FROM check_sit_auto
                WHERE vstdate BETWEEN "'.$datestart.'" AND "'.$dateend.'"
            ');

        // return view('authen.check_sit_auto ',[
        //     'data_sit'    => $data_sit,
        //     'start'     => $datestart,
        //     'end'        => $dateend,
        // ]);
        // return redirect()->back();
        //  return view('authen.check_sit_day ',[
        //     'status'     => '200',
        //     'data_sit'    => $data_sit,
        //     'start'     => $datestart,
        //     'end'        => $dateend,
        // ]);
        return response()->json([
            'status'     => '200',
            // 'data_sit'    => $data_sit,
            'start'     => $datestart,
            'end'        => $dateend,
        ]);
    }


    public function acc_checksit_spsch_pangstamp(Request $request)
    {
        $datestart = $request->startdate;
        $dateend = $request->enddate;
        // dd($datestart);
        $token_data = DB::connection('mysql7')->select('
            SELECT cid,token FROM ssop_token
        ');
        foreach ($token_data as $key => $valuetoken) {
            $cid_ = $valuetoken->cid;
            $token_ = $valuetoken->token;
        }

        $data_sitss = DB::connection('mysql8')->select('
            SELECT * FROM pang_stamp_temp
            WHERE vstdate BETWEEN "'.$datestart.'" AND "'.$dateend.'"
            AND check_sit_subinscl IS NULL
        ');

        // dd($data_sitss);
        foreach ($data_sitss as $key => $item) {
            $pids = $item->cid;
            $vn = $item->vn;
            $vstdate = $item->vstdate;
            // dd($pids);
            $client = new SoapClient("http://ucws.nhso.go.th/ucwstokenp1/UCWSTokenP1?wsdl",
                array(
                    "uri" => 'http://ucws.nhso.go.th/ucwstokenp1/UCWSTokenP1?xsd=1',
                                    "trace"      => 1,
                                    "exceptions" => 0,
                                    "cache_wsdl" => 0
                    )
                );
                $params = array(
                    'sequence' => array(
                        "user_person_id" => "$cid_",
                        "smctoken" => "$token_",
                        "person_id" => "$pids"
                )
            );
            $contents = $client->__soapCall('searchCurrentByPID',$params);

            // dd($contents);
            foreach ($contents as $key => $v) {
                @$status = $v->status ;
                @$maininscl = $v->maininscl;
                @$startdate = $v->startdate;
                @$hmain = $v->hmain ;
                @$subinscl = $v->subinscl ;
                @$person_id_nhso = $v->person_id;
                // dd(@$status);
                IF(@$maininscl =="" || @$maininscl==null || @$status =="003" ){ #ถ้าเป็นค่าว่างไม่ต้อง insert

                        $date_now = date('Y-m-d');
                        Pang_stamp_temp::where('vn', $vn)
                                ->update([
                                    'check_sit_subinscl'       => @$subinscl,
                                    'pttype_stamp'             => 'จำหน่าย/เสียชีวิต'
                                ]);
                  }elseif(@$maininscl !="" || @$subinscl !=""){
                    $date_now2 = date('Y-m-d');
                    Pang_stamp_temp::where('vn', $vn)
                                ->update([
                                    'check_sit_subinscl'          => @$subinscl,
                                    'pttype_stamp'             => @$subinscl.'('.@$hmain.')'.$date_now2
                                ]);

                // }elseif($maininscl=="" && $status=="" ){
                //     Pang_stamp_temp::where('vn', $vn)
                //                 ->update([
                //                     'check_sit_subinscl'          => @$subinscl,
                //                     'pttype_stamp'             => @$subinscl.'('.@$hmain.')'.$date_now
                //                 ]);
                  }

            }
        }
        $data_sit = DB::connection('mysql8')->select('
            SELECT * FROM pang_stamp_temp
            WHERE vstdate BETWEEN "'.$datestart.'" AND "'.$dateend.'"
        ');
        return view('claim.acc_checksit ',[
            'subinscl'     => @$subinscl,
            'start'        => $datestart,
            'end'          => $dateend,
            'data_sit'     => $data_sit
        ]);
    }

    public function check_sit_token(Request $request)
    {
        $datestart = $request->datestart;
        $dateend = $request->dateend;
        $cid = $request->cid;
        $token = $request->token;

        Ssop_token::truncate();

        $data_add = Ssop_token::create([
            'cid'               => $cid,
            'token'             => $token
        ]);
        $data_add->save();

        return response()->json([
            'status'     => '200',
            'start'     => $datestart,
            'end'        => $dateend,
        ]);
    }
    public function check_sit_money(Request $request)
    {
        $datestart = $request->startdate;
        $dateend = $request->enddate;

            $data_sit = DB::connection('mysql5')->select('
                SELECT *
                FROM pang_stamp_temp
                WHERE vstdate BETWEEN "'.$datestart.'" AND "'.$dateend.'"
            ');
        return view('authen.check_sit_money ',[
            'data_sit'    => $data_sit,
            'start'     => $datestart,
            'end'        => $dateend,
        ]);
    }
    public function check_sit_money_pk(Request $request)
    {
        $datestart = $request->datepicker;
        $dateend = $request->datepicker2;
        $date = date('Y-m-d');

        $token_data = DB::connection('mysql7')->select('
            SELECT cid,token FROM ssop_token
        ');
        foreach ($token_data as $key => $valuetoken) {
            $cid_ = $valuetoken->cid;
            $token_ = $valuetoken->token;
        }

        $data_sitss = DB::connection('mysql5')->select('
            SELECT *
            FROM pang_stamp_temp
            WHERE vstdate BETWEEN "'.$datestart.'" AND "'.$dateend.'"
            AND pang_stamp IN("1102050101.401","1102050101.402","1102050102.801","1102050102.802","1102050102.803","1102050102.804")
            AND check_sit_subinscl IS NULL;
        ');

        foreach ($data_sitss as $item) {
            $pids = $item->cid;
            $vn = $item->vn;
            $hn = $item->hn;
            $vstdate = $item->vstdate;

            $client = new SoapClient("http://ucws.nhso.go.th/ucwstokenp1/UCWSTokenP1?wsdl",
                array(
                    "uri" => 'http://ucws.nhso.go.th/ucwstokenp1/UCWSTokenP1?xsd=1',
                                    "trace"      => 1,
                                    "exceptions" => 0,
                                    "cache_wsdl" => 0
                    )
                );
                $params = array(
                    'sequence' => array(
                        "user_person_id" => "$cid_",
                        "smctoken" => "$token_",
                        "person_id" => "$pids"
                )
            );
            $contents = $client->__soapCall('searchCurrentByPID',$params);

            // dd($contents);
            foreach ($contents as $key => $v) {
                @$status = $v->status ;
                @$maininscl = $v->maininscl;
                @$startdate = $v->startdate;
                @$hmain = $v->hmain ;
                @$subinscl = $v->subinscl ;
                @$person_id_nhso = $v->person_id;

                @$hmain_op = $v->hmain_op;  //"10978"
                @$hmain_op_name = $v->hmain_op_name;  //"รพ.ภูเขียวเฉลิมพระเกียรติ"
                @$hsub = $v->hsub;    //"04047"
                @$hsub_name = $v->hsub_name;   //"รพ.สต.แดงสว่าง"
                @$subinscl_name = $v->subinscl_name ; //"ช่วงอายุ 12-59 ปี"
                // dd(@$maininscl);
                IF(@$maininscl =="" || @$maininscl==null || @$status =="003" ){ #ถ้าเป็นค่าว่างไม่ต้อง insert

                  }elseif(@$maininscl !="" || @$subinscl !=""){
                    $date_now2 = date('Y-m-d');
                    Pang_stamp_temp::where('vn', $vn)
                    ->update([
                        // 'status' => @$status,
                        // 'maininscl' => @$maininscl,
                        // 'startdate' => @$startdate,
                        // 'hmain' => @$hmain,
                        'check_sit_subinscl' => @$subinscl,
                        'pttype_stamp' => @$subinscl.'() 0000-00-00'
                        // 'pttype_stamp' => @$subinscl.' '.@$startdate

                        // 'hmain_op' => @$hmain_op,
                        // 'hmain_op_name' => @$hmain_op_name,
                        // 'hsub' => @$hsub,
                        // 'hsub_name' => @$hsub_name,
                        // 'subinscl_name' => @$subinscl_name
                    ]);

                  }

            }
        }
        $data_sit = DB::connection('mysql5')->select('
            SELECT *
            FROM pang_stamp_temp
            WHERE vstdate BETWEEN "'.$datestart.'" AND "'.$dateend.'"
            AND pang_stamp IN("1102050101.401","1102050101.402","1102050102.801","1102050102.802","1102050102.803","1102050102.804");
        ');

        return response()->json([
            'status'     => '200',
            'data_sit'    => $data_sit,
            'start'     => $datestart,
            'end'        => $dateend,
        ]);
    }
    public function check_spsch(Request $request)
    {
        $date_now = date('Y-m-d');
        $date_start = "2023-04-26";
        $date_end = "2023-04-26";
        $url = "https://authenservice.nhso.go.th/authencode/api/authencode-report?hcode=10978&provinceCode=3600&zoneCode=09&claimDateFrom=$date_now&claimDateTo=$date_now&page=0&size=1000&sort=transId,desc";
        // $url = "https://authenservice.nhso.go.th/authencode/api/erm-reg-claim?claimStatus=E&claimDateFrom=$date_now&claimDateTo=$date_now&page=0&size=1000&sort=claimDate,desc";

        // dd($url);https://authenservice.nhso.go.th/authencode/api/authencode-report?hcode=10978&provinceCode=3600&zoneCode=09&claimDateFrom=2023-05-09&claimDateTo=2023-05-09
        $curl = curl_init();
        curl_setopt_array($curl, array(
            // CURLOPT_URL => 'https://authenservice.nhso.go.th/authencode/api/authencode-report?hcode=10978&provinceCode=3600&zoneCode=09&claimDateFrom=2023-05-09&claimDateTo=2023-01-05&page=0&size=1000',
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Accept: application/json, text/plain, */*',
                'Accept-Language: th-TH,th;q=0.9,en-US;q=0.8,en;q=0.7',
                'Connection: keep-alive',
                'Cookie: SESSION=Y2Q0YTI5MmItNWEzNi00ZDQ1LTg4ZjUtNzc3ZWMwNjAxNTIw; TS01bfdc7f=013bd252cb2f635ea275a9e2adb4f56d3ff24dc90de5421d2173da01a971bc0b2d397ab2bfbe08ef0e379c3946b8487cf4049afe9f2b340d8ce29a35f07f94b37287acd9c2; _ga_B75N90LD24=GS1.1.1665019756.2.0.1665019757.0.0.0; _ga=GA1.3.1794349612.1664942850; TS01e88bc2=013bd252cb8ac81a003458f85ce451e7bd5f66e6a3930b33701914767e3e8af7b92898dd63a6258beec555bbfe4b8681911d19bf0c; SESSION=YmI4MjUyNjYtODY5YS00NWFmLTlmZGItYTU5OWYzZmJmZWNh; TS01bfdc7f=013bd252cbc4ce3230a1e9bdc06904807c8155bd7d0a8060898777cf88368faf4a94f2098f920d5bbd729fbf29d55a388f507d977a65a3dbb3b950b754491e7a240f8f72eb; TS01e88bc2=013bd252cbe2073feef8c43b65869a02b9b370d9108007ac6a34a07f6ae0a96b2967486387a6a0575c46811259afa688d09b5dfd21',
                'Referer: https://authenservice.nhso.go.th/authencode/',
                'Sec-Fetch-Dest: empty',
                'Sec-Fetch-Mode: cors',
                'Sec-Fetch-Site: same-origin',
                'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36',
                'sec-ch-ua: "Not?A_Brand";v="8", "Chromium";v="108", "Google Chrome";v="108"',
                'sec-ch-ua-mobile: ?0',
                'sec-ch-ua-platform: "Windows"'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        // dd($curl);
        $contents = $response;
        // dd($contents);
        $result = json_decode($contents, true);

        @$content = $result['content'];
        // dd($content);

        foreach ($content as $key => $value) {
            $transId = $value['transId'];

            isset( $value['hmain'] ) ? $hmain = $value['hmain'] : $hmain = "";
            isset( $value['hname'] ) ? $hname = $value['hname'] : $hname = "";
            isset( $value['personalId'] ) ? $personalId = $value['personalId'] : $personalId = "";
            isset( $value['patientName'] ) ? $patientName = $value['patientName'] : $patientName = "";
            isset( $value['addrNo'] ) ? $addrNo = $value['addrNo'] : $addrNo = "";
            isset( $value['moo'] ) ? $moo = $value['moo'] : $moo = "";
            isset( $value['moonanName'] ) ? $moonanName = $value['moonanName'] : $moonanName = "";
            isset( $value['tumbonName'] ) ? $tumbonName = $value['tumbonName'] : $tumbonName = "";
            isset( $value['amphurName'] ) ? $amphurName = $value['amphurName'] : $amphurName = "";
            isset( $value['changwatName'] ) ? $changwatName = $value['changwatName'] : $changwatName = "";
            isset( $value['birthdate'] ) ? $birthdate = $value['birthdate'] : $birthdate = "";
            isset( $value['tel'] ) ? $tel = $value['tel'] : $tel = "";
            isset( $value['mainInscl'] ) ? $mainInscl = $value['mainInscl'] : $mainInscl = "";
            isset( $value['mainInsclName'] ) ? $mainInsclName = $value['mainInsclName'] : $mainInsclName = "";
            isset( $value['subInscl'] ) ? $subInscl = $value['subInscl'] : $subInscl = "";
            isset( $value['subInsclName'] ) ? $subInsclName = $value['subInsclName'] : $subInsclName = "";
            isset( $value['claimStatus'] ) ? $claimStatus = $value['claimStatus'] : $claimStatus = "";
            isset( $value['patientType'] ) ? $patientType = $value['patientType'] : $patientType = "";
            isset( $value['claimCode'] ) ? $claimCode = $value['claimCode'] : $claimCode = "";
            isset( $value['claimType'] ) ? $claimType = $value['claimType'] : $claimType = "";
            isset( $value['claimTypeName'] ) ? $claimTypeName = $value['claimTypeName'] : $claimTypeName = "";
            isset( $value['hnCode'] ) ? $hnCode = $value['hnCode'] : $hnCode = "";
            isset( $value['createDate'] ) ? $createDate = $value['createDate'] : $createDate = "";
            isset( $value['claimAuthen'] ) ? $claimAuthen = $value['claimAuthen'] : $claimAuthen = "";
            isset( $value['createBy'] ) ? $createBy = $value['createBy'] : $createBy = "";
            isset( $value['mainInsclWithName'] ) ? $mainInsclWithName = $value['mainInsclWithName'] : $mainInsclWithName = "";
            isset( $value['sourceChannel'] ) ? $sourceChannel = $value['sourceChannel'] : $sourceChannel = "";

            $claimDate = explode("T",$value['claimDate']);
            $checkdate = $claimDate[0];
            $checktime = $claimDate[1];
            // dd($transId);
                $datenow = date("Y-m-d");        
                            //   Visit_pttype_authen_report::where('transId', $transId)
                            //     ->update([
                            //         'personalId'                        => $personalId,
                            //         'patientName'                       => $patientName,
                            //         'addrNo'                            => $addrNo,
                            //         'moo'                               => $moo,
                            //         'moonanName'                        => $moonanName,
                            //         'tumbonName'                        => $tumbonName,
                            //         'amphurName'                        => $amphurName,
                            //         'changwatName'                      => $changwatName,
                            //         'birthdate'                         => $birthdate,
                            //         'tel'                               => $tel,
                            //         'mainInscl'                         => $mainInscl,
                            //         'mainInsclName'                     => $mainInsclName,
                            //         'subInscl'                          => $subInscl,
                            //         'subInsclName'                      => $subInsclName,
                            //         'claimCode'                         => $claimCode,
                            //         'claimType'                         => $claimType,
                            //         'claimTypeName'                     => $claimTypeName,
                            //         'hnCode'                            => $hnCode,
                            //         'createBy'                          => $createBy,
                            //         'mainInsclWithName'                 => $mainInsclWithName,
                            //         'claimAuthen'                        => $claimAuthen,
                            //         'date_data'                          => $datenow
                            //     ]);
                    // } else {
                        // $checkcCode = Check_sit_auto::where('vstdate','=',$checkdate)->where('cid','=',$personalId)->where('fokliad','>','0')->count();
                       
                        // if ($claimType > 0) {
                                // $checkc = Check_authen_temp::where('claimtype','=','PG0130001')->count();
                                if ($claimType == 'PG0130001') {
                                    // Check_authen_temp::where('claimCode', $claimCode)
                                    //     ->update([
                                    //         'cid'                        => $personalId,
                                    //         'fullname'                   => $patientName,
                                    //         'hosname'                    => $hname,
                                    //         'hcode'                      => $hmain,
                                    //         'vstdate'                    => $checkdate,
                                    //         'regdate'                    => $checkdate,
                                    //         'claimcode'                  => $claimCode,
                                    //         'claimtype'                  => $claimType,
                                    //         'birthday'                   => $birthdate,
                                    //         'homtel'                     => $tel,
                                    //         'repcode'                    => $claimStatus,
                                    //         'hncode'                     => $hnCode,
                                    //         'servicerep'                 => $patientType,
                                    //         'servicename'                => $claimTypeName,
                                    //         'mainpttype'                 => $mainInsclWithName,
                                    //         'subpttype'                  => $subInsclName,
                                    //         'requestauthen'              => $sourceChannel,
                                    //         'authentication'             => $claimAuthen,
                                    //         // 'PG0130001',
                                    //     ]);
                                } else {  
                                    $checkcs = Check_authen::where('claimCode','=',$claimCode)->count();  
                                    if ($checkcs > 0) {
                                        Check_sit_auto::where('claimcode', $claimCode)
                                        ->update([ 
                                            'claimcode'       => $claimCode, 
                                            'claimtype'       => $claimType,  
                                        ]);
                                       
                                    } else {
                                        Check_authen::create([
                                            'cid'                        => $personalId,
                                            'fullname'                   => $patientName,
                                            'hosname'                    => $hname,
                                            'hcode'                      => $hmain,
                                            'vstdate'                    => $checkdate,
                                            'regdate'                    => $checkdate,
                                            'claimcode'                  => $claimCode,
                                            'claimtype'                  => $claimType,
                                            'birthday'                   => $birthdate,
                                            'homtel'                     => $tel,
                                            'repcode'                    => $claimStatus,
                                            'hncode'                     => $hnCode,
                                            'servicerep'                 => $patientType,
                                            'servicename'                => $claimTypeName,
                                            'mainpttype'                 => $mainInsclWithName,
                                            'subpttype'                  => $subInsclName,
                                            'requestauthen'              => $sourceChannel,
                                            'authentication'             => $claimAuthen,

                                        ]);
                                    }

                                    $check_detail = Db_authen_detail::where('cid','=',$personalId)->where('vstdate','=',$checkdate)->count();  
                                    if ($check_detail > 0) {
                                        Db_authen_detail::where('claimcode', $claimCode)->update([
                                            'claimcode'       => $claimCode, 
                                            'claimtype'       => $claimType, 
                                        ]);
                                    } else {
                                        # code...
                                    }
                                    

                                    
                                    
                                       
                                }
                        // } else {
                        //     // $checkc_ = Check_authen::where('claimtype','=','PG0130001')->count();
                        //    if ($claimType == 'PG0130001') {
                        //     # code...
                        //    } else {
                        //         Check_authen::create([
                        //             'cid'                        => $personalId,
                        //             'fullname'                   => $patientName,
                        //             'hosname'                    => $hname,
                        //             'hcode'                      => $hmain,
                        //             'vstdate'                    => $checkdate,
                        //             'regdate'                    => $checkdate,
                        //             'claimcode'                  => $claimCode,
                        //             'claimtype'                  => $claimType,
                        //             'birthday'                   => $birthdate,
                        //             'homtel'                     => $tel,
                        //             'repcode'                    => $claimStatus,
                        //             'hncode'                     => $hnCode,
                        //             'servicerep'                 => $patientType,
                        //             'servicename'                => $claimTypeName,
                        //             'mainpttype'                 => $mainInsclWithName,
                        //             'subpttype'                  => $subInsclName,
                        //             'requestauthen'              => $sourceChannel,
                        //             'authentication'             => $claimAuthen,

                        //         ]);
                        //    }
                           
                           
                        // }
                    }

                    // }
        // }
        // $update_ = DB::connection('mysql')->select('
        //         SELECT *  
        //         FROM check_authen  
        //         WHERE vstdate = CURDATE()
        //         AND claimtype <> "PG0130001"
        //         GROUP BY vn
        // ');
        // foreach ($update_ as $key => $value) {
        //     $checkcss = Check_authen::where('claimCode','=',$claimCode)->count();
        //     if ($checkcss > 0) {
        //         Check_authen::where('claimCode', $claimCode)->update([
        //             'cid'                        => $value->personalId,
        //             'fullname'                   => $value->patientName,
        //             'hosname'                    => $value->hname,
        //             'hcode'                      => $value->hmain,
        //             'vstdate'                    => $value->checkdate,
        //             'regdate'                    => $value->checkdate,
        //             'claimcode'                  => $value->claimCode,
        //             'claimtype'                  => $value->claimType,
        //             'birthday'                   => $value->birthdate,
        //             'homtel'                     => $value->tel,
        //             'repcode'                    => $value->claimStatus,
        //             'hncode'                     => $value->hnCode,
        //             'servicerep'                 => $value->patientType,
        //             'servicename'                => $value->claimTypeName,
        //             'mainpttype'                 => $value->mainInsclWithName,
        //             'subpttype'                  => $value->subInsclName,
        //             'requestauthen'              => $value->sourceChannel,
        //             'authentication'             => $value->claimAuthen,
    
        //         ]);
        //     } else {
        //         Check_authen::create([
        //             'cid'                        => $value->personalId,
        //             'fullname'                   => $value->patientName,
        //             'hosname'                    => $value->hname,
        //             'hcode'                      => $value->hmain,
        //             'vstdate'                    => $value->checkdate,
        //             'regdate'                    => $value->checkdate,
        //             'claimcode'                  => $value->claimCode,
        //             'claimtype'                  => $value->claimType,
        //             'birthday'                   => $value->birthdate,
        //             'homtel'                     => $value->tel,
        //             'repcode'                    => $value->claimStatus,
        //             'hncode'                     => $value->hnCode,
        //             'servicerep'                 => $value->patientType,
        //             'servicename'                => $value->claimTypeName,
        //             'mainpttype'                 => $value->mainInsclWithName,
        //             'subpttype'                  => $value->subInsclName,
        //             'requestauthen'              => $value->sourceChannel,
        //             'authentication'             => $value->claimAuthen,
    
        //         ]);
        //     }
            
           
        // }


        return view('authen.check_spsch',[
            'response'  => $response,
            'result'  => $result,
        ]);

    }

    public function check_spsch_detail(Request $request)
    {
        $date_now = date('Y-m-d');
        $date_start = "2023-04-26";
        $date_end = "2023-04-26";
        $url = "https://authenservice.nhso.go.th/authencode/api/authencode-report?hcode=10978&provinceCode=3600&zoneCode=09&claimDateFrom=$date_now&claimDateTo=$date_now&page=0&size=1000&sort=transId,desc";
       
        $curl = curl_init();
        curl_setopt_array($curl, array(
            // CURLOPT_URL => 'https://authenservice.nhso.go.th/authencode/api/authencode-report?hcode=10978&provinceCode=3600&zoneCode=09&claimDateFrom=2023-05-09&claimDateTo=2023-01-05&page=0&size=1000',
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Accept: application/json, text/plain, */*',
                'Accept-Language: th-TH,th;q=0.9,en-US;q=0.8,en;q=0.7',
                'Connection: keep-alive',
                'Cookie: SESSION=Y2Q0YTI5MmItNWEzNi00ZDQ1LTg4ZjUtNzc3ZWMwNjAxNTIw; TS01bfdc7f=013bd252cb2f635ea275a9e2adb4f56d3ff24dc90de5421d2173da01a971bc0b2d397ab2bfbe08ef0e379c3946b8487cf4049afe9f2b340d8ce29a35f07f94b37287acd9c2; _ga_B75N90LD24=GS1.1.1665019756.2.0.1665019757.0.0.0; _ga=GA1.3.1794349612.1664942850; TS01e88bc2=013bd252cb8ac81a003458f85ce451e7bd5f66e6a3930b33701914767e3e8af7b92898dd63a6258beec555bbfe4b8681911d19bf0c; SESSION=YmI4MjUyNjYtODY5YS00NWFmLTlmZGItYTU5OWYzZmJmZWNh; TS01bfdc7f=013bd252cbc4ce3230a1e9bdc06904807c8155bd7d0a8060898777cf88368faf4a94f2098f920d5bbd729fbf29d55a388f507d977a65a3dbb3b950b754491e7a240f8f72eb; TS01e88bc2=013bd252cbe2073feef8c43b65869a02b9b370d9108007ac6a34a07f6ae0a96b2967486387a6a0575c46811259afa688d09b5dfd21',
                'Referer: https://authenservice.nhso.go.th/authencode/',
                'Sec-Fetch-Dest: empty',
                'Sec-Fetch-Mode: cors',
                'Sec-Fetch-Site: same-origin',
                'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36',
                'sec-ch-ua: "Not?A_Brand";v="8", "Chromium";v="108", "Google Chrome";v="108"',
                'sec-ch-ua-mobile: ?0',
                'sec-ch-ua-platform: "Windows"'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        // dd($curl);
        $contents = $response;
        // dd($contents);
        $result = json_decode($contents, true);

        @$content = $result['content'];
        // dd($content);

        foreach ($content as $key => $value) {
            $transId = $value['transId'];

            isset( $value['hmain'] ) ? $hmain = $value['hmain'] : $hmain = "";
            isset( $value['hname'] ) ? $hname = $value['hname'] : $hname = "";
            isset( $value['personalId'] ) ? $personalId = $value['personalId'] : $personalId = "";
            isset( $value['patientName'] ) ? $patientName = $value['patientName'] : $patientName = "";
            isset( $value['addrNo'] ) ? $addrNo = $value['addrNo'] : $addrNo = "";
            isset( $value['moo'] ) ? $moo = $value['moo'] : $moo = "";
            isset( $value['moonanName'] ) ? $moonanName = $value['moonanName'] : $moonanName = "";
            isset( $value['tumbonName'] ) ? $tumbonName = $value['tumbonName'] : $tumbonName = "";
            isset( $value['amphurName'] ) ? $amphurName = $value['amphurName'] : $amphurName = "";
            isset( $value['changwatName'] ) ? $changwatName = $value['changwatName'] : $changwatName = "";
            isset( $value['birthdate'] ) ? $birthdate = $value['birthdate'] : $birthdate = "";
            isset( $value['tel'] ) ? $tel = $value['tel'] : $tel = "";
            isset( $value['mainInscl'] ) ? $mainInscl = $value['mainInscl'] : $mainInscl = "";
            isset( $value['mainInsclName'] ) ? $mainInsclName = $value['mainInsclName'] : $mainInsclName = "";
            isset( $value['subInscl'] ) ? $subInscl = $value['subInscl'] : $subInscl = "";
            isset( $value['subInsclName'] ) ? $subInsclName = $value['subInsclName'] : $subInsclName = "";
            isset( $value['claimStatus'] ) ? $claimStatus = $value['claimStatus'] : $claimStatus = "";
            isset( $value['patientType'] ) ? $patientType = $value['patientType'] : $patientType = "";
            isset( $value['claimCode'] ) ? $claimCode = $value['claimCode'] : $claimCode = "";
            isset( $value['claimType'] ) ? $claimType = $value['claimType'] : $claimType = "";
            isset( $value['claimTypeName'] ) ? $claimTypeName = $value['claimTypeName'] : $claimTypeName = "";
            isset( $value['hnCode'] ) ? $hnCode = $value['hnCode'] : $hnCode = "";
            isset( $value['createDate'] ) ? $createDate = $value['createDate'] : $createDate = "";
            isset( $value['claimAuthen'] ) ? $claimAuthen = $value['claimAuthen'] : $claimAuthen = "";
            isset( $value['createBy'] ) ? $createBy = $value['createBy'] : $createBy = "";
            isset( $value['mainInsclWithName'] ) ? $mainInsclWithName = $value['mainInsclWithName'] : $mainInsclWithName = "";
            isset( $value['sourceChannel'] ) ? $sourceChannel = $value['sourceChannel'] : $sourceChannel = "";

            $claimDate = explode("T",$value['claimDate']);
            $checkdate = $claimDate[0];
            $checktime = $claimDate[1];
            // dd($transId);
                $datenow = date("Y-m-d"); 
           
                        if ($claimType == 'PG0130001') {
            
                        } else {   
                            // $check_detail = Db_authen_detail::where('cid','=',$personalId)->where('vstdate','=',$checkdate)->count(); 
                            $check_detail = Db_authen_detail::where('claimcode','=',$claimCode)->count();  
                            if ($check_detail > 0) {
                                Db_authen_detail::where('cid','=',$personalId)->where('vstdate','=',$checkdate)->update([
                                    'claimcode'       => $claimCode, 
                                    'claimtype'       => $claimType, 
                                ]);
                            } else {
                                Db_authen_detail::where('cid','=',$personalId)->where('vstdate','=',$checkdate)->update([
                                    'claimcode'       => $claimCode, 
                                    'claimtype'       => $claimType, 
                                ]);
                            }
                                
                        }
                       
                    }
 
        return view('authen.check_spsch',[
            'response'  => $response,
            'result'  => $result,
        ]);

    }
    

    public function check_dashboard(Request $request)
    {
        $date = date('Y-m-d');
        $y = date('Y');
      
        $data_year2 = DB::connection('mysql')->select('
            SELECT month,year,countvn,authen_opd 
            FROM db_authen 
            WHERE year = "'.$y.'" and authen_opd <> 0
        ');
       
        return view('dashboard.check_dashboard',[ 
            'data_year2'              => $data_year2, 
        ] );
    }
    public function check_dashboard_bar(Request $request)
    {
        $y = date('Y');
        $date = date('Y-m-d');
        $year_ = DB::connection('mysql')->select('
            SELECT * FROM budget_year WHERE active = "True"
        ');
        foreach ($year_ as $key => $value) {
            $startdate = $value->date_begin;
            $enddate = $value->date_end;
        }
        $chart = DB::connection('mysql')->select('
            SELECT * FROM db_authen WHERE year = "'.$y.'"
        ');
        $labels = [
          1 => "ม.ค", "ก.พ", "มี.ค", "เม.ย", "พ.ย", "มิ.ย", "ก.ค","ส.ค","ก.ย","ต.ค","พ.ย","ธ.ค"
        ];
         $countvn = $countan = $authen_opd = $noauthen_opd = $authen_ipd = [];

        foreach ($chart as $key => $chartitems) {
            $countvn[$chartitems->month] = $chartitems->countvn;
            $authen_opd[$chartitems->month] = $chartitems->authen_opd;
            $noauthen_opd[$chartitems->month] = $chartitems->countvn - $chartitems->authen_opd;
        }
        foreach ($labels as $month => $name) {
           if (!array_key_exists($month,$countvn)) {
            $countvn[$month] = 0;
           }
           if (!array_key_exists($month,$authen_opd)) {
            $authen_opd[$month] = 0;
           }
           if (!array_key_exists($month,$noauthen_opd)) {
            $noauthen_opd[$month] = 0;
           }
        }
        ksort($countvn);
        ksort($authen_opd);
        ksort($noauthen_opd);
        return [
            'labels'          =>  array_values($labels),
            'datasets'     =>  [
                [
                    'label'           =>  'คนไข้ที่มารับบริการ OPD ยกเว้นแผนก 011,036,107 และสิทธิ์ M1-M6',
                    'borderColor'     => 'rgba(255, 205, 86 , 1)',
                    'backgroundColor' => 'rgba(255, 205, 86 , 0.2)',
                    'borderWidth'     => '1',
                    'barPercentage'   => '0.9',
                    'data'            =>  array_values($countvn) 
                ],
                [
                    'label'           =>  'Authen Code',
                    'borderColor'     => 'rgba(75, 192, 192, 1)',
                    'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                    'borderWidth'     => '1',
                    'barPercentage'   => '0.9',
                    'data'            => array_values($authen_opd)
                ],
                [
                    'label'           =>  'ไม่ Authen',
                    'borderColor'     => 'rgba(255, 99, 132, 1)',
                    'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                    'borderWidth'     => '1',
                    'barPercentage'   => '0.9',
                    'data'            => array_values($noauthen_opd)
                ],
            ],
        ];
        // 255, 26, 104 ชมพู
        // 255, 205, 86
    }
}
// AND o.main_dep NOT IN("011","036","107")
// AND o.pttype NOT IN("M1","M2","M3","M4","M5","M6")