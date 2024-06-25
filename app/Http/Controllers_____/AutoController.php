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
use Maatwebsite\Excel\Facades\Excel;
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
use App\Models\Ssop_stm;
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
use App\Models\Dashboard_authen_day;
use App\Models\Dashboard_department_authen;
use App\Models\Visit_pttype_authen_report;
use App\Models\Dashboard_authenstaff_day;
use App\Models\Acc_debtor;
use App\Models\Check_sit_auto_claim;
use App\Models\Db_year;
use App\Models\Db_authen;
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
// use File;

class AutoController extends Controller
{
    public function authencode_confirm(Request $request)
    {
        $date_now = date('Y-m-d');
        $date_start = "2023-05-07";
        $date_end = "2023-05-09";

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
                'Cookie: SESSION=NWY1NjU4N2YtN2E2Zi00OGQ1LWEzYjUtYzYyY2Y3NWJkNmNk; TS01bfdc7f=013bd252cb2f635ea275a9e2adb4f56d3ff24dc90de5421d2173da01a971bc0b2d397ab2bfbe08ef0e379c3946b8487cf4049afe9f2b340d8ce29a35f07f94b37287acd9c2; _ga_B75N90LD24=GS1.1.1665019756.2.0.1665019757.0.0.0; _ga=GA1.3.1794349612.1664942850; TS01e88bc2=013bd252cb8ac81a003458f85ce451e7bd5f66e6a3930b33701914767e3e8af7b92898dd63a6258beec555bbfe4b8681911d19bf0c; SESSION=YmI4MjUyNjYtODY5YS00NWFmLTlmZGItYTU5OWYzZmJmZWNh; TS01bfdc7f=013bd252cbc4ce3230a1e9bdc06904807c8155bd7d0a8060898777cf88368faf4a94f2098f920d5bbd729fbf29d55a388f507d977a65a3dbb3b950b754491e7a240f8f72eb; TS01e88bc2=013bd252cbe2073feef8c43b65869a02b9b370d9108007ac6a34a07f6ae0a96b2967486387a6a0575c46811259afa688d09b5dfd21',
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
        $result = json_decode($contents, true);
        @$content = $result['content'];
        // dd($content);

        foreach ($content as $key => $value) {
            $transId = $value['transId'];
            isset( $value['patientName'] ) ? $patientName = $value['patientName'] : $patientName = "";

            $claimDate = explode("T",$value['claimDate']);
            $checkdate = $claimDate[0];
            $checktime = $claimDate[1];
        }
        return view('auto.checkauthen_autospsch',[
            'response'  => $response,
            'result'  => $result,
        ]);

    }
    public function sit(Request $request)
    {
        return view('authen.sit');
    }
    public function repage(Request $request)
    {
        $date_now = date('Y-m-d');
        // $date_start = "2023-05-04";
        // $date_end = "2023-05-07";
        // $url = "https://authenservice.nhso.go.th/authencode/api/authencode-report?hcode=10978&provinceCode=3600&zoneCode=09&claimDateFrom=$date_now&claimDateTo=$date_now&page=0&size=100000";
        $url = "https://authenservice.nhso.go.th/authencode/#/report/eclaim";

        // dd($url);
        $curl = curl_init();
        curl_setopt_array($curl, array(
            // CURLOPT_URL => 'https://authenservice.nhso.go.th/authencode/api/authencode-report?hcode=10978&provinceCode=3600&zoneCode=09&claimDateFrom=2023-01-05&claimDateTo=2023-01-05&page=0&size=1000',
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Accept: application/json, text/plain, */*',
                'Accept-Language: th-TH,th;q=0.9,en-US;q=0.8,en;q=0.7',
                'Connection: keep-alive',
                'Cookie: SESSION=NWY1NjU4N2YtN2E2Zi00OGQ1LWEzYjUtYzYyY2Y3NWJkNmNk; TS01bfdc7f=013bd252cb2f635ea275a9e2adb4f56d3ff24dc90de5421d2173da01a971bc0b2d397ab2bfbe08ef0e379c3946b8487cf4049afe9f2b340d8ce29a35f07f94b37287acd9c2; _ga_B75N90LD24=GS1.1.1665019756.2.0.1665019757.0.0.0; _ga=GA1.3.1794349612.1664942850; TS01e88bc2=013bd252cb8ac81a003458f85ce451e7bd5f66e6a3930b33701914767e3e8af7b92898dd63a6258beec555bbfe4b8681911d19bf0c; SESSION=YmI4MjUyNjYtODY5YS00NWFmLTlmZGItYTU5OWYzZmJmZWNh; TS01bfdc7f=013bd252cbc4ce3230a1e9bdc06904807c8155bd7d0a8060898777cf88368faf4a94f2098f920d5bbd729fbf29d55a388f507d977a65a3dbb3b950b754491e7a240f8f72eb; TS01e88bc2=013bd252cbe2073feef8c43b65869a02b9b370d9108007ac6a34a07f6ae0a96b2967486387a6a0575c46811259afa688d09b5dfd21',
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
        return view('authen.repage');
    }
    // ดึงข้อมูลมาไว้เช็คสิทธิ์
    public function sit_pull_auto(Request $request)
    {
        // $data_check = DB::connection('mysql')->select('
        //         SELECT vn
        //         FROM check_sit_auto 
        // ');
        // foreach ($data_check as $key => $val) {
        //     $check_hos = Check_sit_auto::where('vn', $val->vn)->count();
        // }       

            $data_sits = DB::connection('mysql3')->select('
                SELECT o.an,o.vn,p.hn,p.cid,o.vstdate,o.vsttime,o.pttype,concat(p.pname,p.fname," ",p.lname) as fullname,op.name as staffname,p.hometel
                    ,pt.nhso_code,o.hospmain,o.hospsub
                    ,o.staff 
                    ,o.main_dep,v.income-v.discount_money-v.rcpt_money debit
                    FROM ovst o
                    LEFT JOIN vn_stat v on v.vn = o.vn
                    join patient p on p.hn=o.hn
                    JOIN pttype pt on pt.pttype=o.pttype
                    JOIN opduser op on op.loginname = o.staff
                    WHERE o.vstdate = "2023-07-22" 
                  
                    AND o.pttype NOT IN("M1","M2","M3","M4","M5","M6")
                    group by o.vn
                    
            ');
            // AND o.main_dep NOT IN("011","036","107")
            // AND o.pttype NOT IN("M1","M2","M3","M4","M5","M6","13","23","91")


            // ,p.hn,p.cid,o.vstdate,o.vsttime,o.pttype,concat(p.pname,p.fname," ",p.lname) as fullname
            // AND o.pttype NOT IN("M1","M2","M3","M4","M5","M6","13","23")
            // AND o.main_dep NOT IN("011","036","107")
            // AND o.pttype NOT IN("M1","M2","M3","M4","M5","M6")
            // SELECT o.an,o.vn,p.hn,p.cid,o.vstdate,o.vsttime,o.pttype,concat(p.pname,p.fname," ",p.lname) as fullname,o.staff,p.hometel
            //     ,pt.nhso_code,o.hospmain,o.hospsub,o.main_dep,v.income-v.discount_money-v.rcpt_money debit

            // SELECT o.vn,p.hn,p.cid,o.pttype,o.staff,p.hometel
            // ,o.main_dep,v.income-v.discount_money-v.rcpt_money debit
            // CURDATE() "2023-07-01"
            foreach ($data_sits as $key => $value) {
                $check = Check_sit_auto::where('vn', $value->vn)->count();

                if ($check > 0) {
                    Check_sit_auto::where('vn', $value->vn)
                        ->update([ 
                            'hometel'       => $value->hometel,
                            // 'vsttime'    => $value->vsttime,
                            // 'fullname'   => $value->fullname,
                            // 'pttype'     => $value->pttype,
                            // 'hospmain'   => $value->hospmain,
                            'staff_name'    => $value->staffname,
                            'main_dep'      => $value->main_dep,
                            'staff'         => $value->staff,
                            'debit'         => $value->debit
                        ]);
                } else {
                    Check_sit_auto::insert([
                        'vn'         => $value->vn,
                        'an'         => $value->an,
                        'hn'         => $value->hn,
                        'cid'        => $value->cid,
                        'vstdate'    => $value->vstdate,
                        'hometel'    => $value->hometel,
                        'vsttime'    => $value->vsttime,
                        'fullname'   => $value->fullname,
                        'pttype'     => $value->pttype,
                        'hospmain'   => $value->hospmain,
                        'hospsub'    => $value->hospsub,
                        'main_dep'   => $value->main_dep,
                        'staff'      => $value->staff,
                        'staff_name' => $value->staffname,
                        'debit'      => $value->debit
                    ]);

                }

            }
           
            return view('authen.sit_pull_auto');
    }

    public function sit_auto(Request $request)
    {
        $datestart = $request->datestart;
        $dateend = $request->dateend;
        $date = date('Y-m-d');
        $token_data = DB::connection('mysql')->select('
            SELECT cid,token FROM ssop_token
        ');
        // SELECT cid,token FROM nhso_token where token <> ""
        // SELECT cid,token FROM ssop_token
        // foreach ($token_data as $key => $valuetoken) {
        //     $cid_ = $valuetoken->cid;
        //     $token_ = $valuetoken->token;
        // }
        // $cid_ = DB::connection('mysql3')->table('nhso_token')->whereNotNull('token')->max('cid');
        // $token_ = DB::connection('mysql3')->table('nhso_token')->select('token')->whereNotNull('token')->max('token');

        //  $token_data = DB::connection('mysql3')->select('
        //     SELECT cid,token FROM nhso_token where token <> "" LIMIT 1;
        // ');
        foreach ($token_data as $key => $valuetoken) {
            $cid_ = $valuetoken->cid;
            $token_ = $valuetoken->token;
        }
        $data_sitss = DB::connection('mysql')->select('
            SELECT cid,vn,an
            FROM check_sit_auto
            WHERE vstdate = CURDATE()
            AND subinscl IS NULL
            LIMIT 30
        ');
        // BETWEEN "2023-07-01" AND "2023-05-16"       CURDATE()
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
                        // }else{
                            // Check_sit_auto::insert([
                            //     'status' => @$status,
                            //     'maininscl' => @$maininscl,
                            //     'startdate' => @$startdate,
                            //     'hmain' => @$hmain,
                            //     'subinscl' => @$subinscl,
                            //     'person_id_nhso' => @$person_id_nhso,
                            //     'hmain_op' => @$hmain_op,
                            //     'hmain_op_name' => @$hmain_op_name,
                            //     'hsub' => @$hsub,
                            //     'hsub_name' => @$hsub_name,
                            //     'subinscl_name' => @$subinscl_name,
                            //     'upsit_date'    => $date2
                            // ]);
                }

            }
        }

        return view('authen.sit_auto');

    }

    public function dbday_auto(Request $request)
    {
            $data_sits = DB::connection('mysql3')->select('
                    SELECT v.vstdate
                    ,count(distinct v.hn) as hn
                    ,count(distinct v.vn) as vn
                    ,count(distinct v.cid) as cid
                    ,"" as Kios
                    ,"" as Staff
                    ,"" as Success
                    ,"" as Unsuccess
                    FROM vn_stat v
                    left outer join hos.ovst o on o.vn = v.vn
                    left outer join hos.patient p on p.hn = v.hn
                    left outer join hos.pttype pt on pt.pttype = v.pttype
                    left outer join hos.leave_month l on l.MONTH_ID = month(v.vstdate)
                    WHERE o.vstdate = CURDATE()
                    group by DAY(v.vstdate)
            ');
            // CURDATE()
            foreach ($data_sits as $key => $value) {
                $check = Dashboard_authen_day::where('vstdate', $value->vstdate)->count();
                if ($check == 0) {
                    Dashboard_authen_day::insert([
                        'vn' => $value->vn,
                        'hn' => $value->hn,
                        'cid' => $value->cid,
                        'vstdate' => $value->vstdate
                    ]);
                } else {
                    Dashboard_authen_day::where('vstdate', $value->vstdate)
                        ->update([
                            'vn' => $value->vn,
                            'hn' => $value->hn,
                            'cid' => $value->cid,
                            'vstdate' => $value->vstdate

                        ]);
                }

            }
            $data_kios_all = DB::connection('mysql3')->select('
                    SELECT v.vstdate
                    ,COUNT(DISTINCT o.vn) as vn
                    ,count(DISTINCT p.cid) as cid
                    FROM ovst o
                    LEFT OUTER JOIN hos.vn_stat v on v.vn = o.vn
                    LEFT OUTER JOIN visit_pttype vp on vp.vn = o.vn
                    LEFT OUTER JOIN ovst_queue_server os on os.vn = o.vn
                    LEFT OUTER JOIN ovst_queue_server_authen oq on oq.vn = os.vn
                    LEFT OUTER JOIN patient p on p.hn=o.hn

                    WHERE o.vstdate = CURDATE()
                    AND os.staff LIKE "kiosk%"
                    GROUP BY o.vstdate
            ');
            // = CURDATE()
            // BETWEEN "2023-05-01" AND "2023-05-09"
            foreach ($data_kios_all as $key => $value2) {
                $check2 = Dashboard_authen_day::where('vstdate', $value2->vstdate)->count();
                if ($check2 == 0) {
                    Dashboard_authen_day::insert([
                        'Kios' => $value2->vn
                    ]);
                } else {
                    Dashboard_authen_day::where('vstdate', $value2->vstdate)
                        ->update([
                            'Kios' => $value2->vn
                        ]);
                }
            }
            $data_user_all = DB::connection('mysql3')->select('
                    SELECT v.vstdate,COUNT(o.vn) as VN
                    FROM ovst o
                    LEFT OUTER JOIN hos.vn_stat v on v.vn = o.vn
                    LEFT OUTER JOIN visit_pttype_authen_report wr ON wr.personalId = v.cid AND v.vstdate = wr.claimDate
                    WHERE o.vstdate = CURDATE()
                    AND o.staff not LIKE "kiosk%"
                    GROUP BY o.vstdate
            ');
            $data_total_all = DB::connection('mysql3')->select('
                    SELECT v.vstdate,count(DISTINCT wr.claimCode) as claimCode
                    FROM ovst o
                    LEFT OUTER JOIN hos.vn_stat v on v.vn = o.vn
                    LEFT OUTER JOIN visit_pttype_authen_report wr ON wr.personalId = v.cid AND v.vstdate = wr.claimDate
                    WHERE o.vstdate = CURDATE()
                    GROUP BY o.vstdate
            ');
            foreach ($data_total_all as $key => $value3) {
                $check3 = Dashboard_authen_day::where('vstdate', $value3->vstdate)->count();
                if ($check3 == 0) {
                    Dashboard_authen_day::insert([
                        'Total_Success' => $value3->claimCode
                    ]);
                } else {
                    Dashboard_authen_day::where('vstdate', $value3->vstdate)
                        ->update([
                            'Total_Success' => $value3->claimCode
                        ]);
                }
            }

            return view('auto.dbday_auto');
    }

    public function depauthen_auto(Request $request)
    {

            $data_authen = DB::connection('mysql3')->select('
                SELECT v.vstdate,o.main_dep,sk.department,COUNT(DISTINCT o.vn) as vn,count(DISTINCT wr.claimCode) as claimCode
                        ,count(DISTINCT wr.tel) as Success ,COUNT(DISTINCT o.vn)-count(DISTINCT wr.tel) as Unsuccess
                        FROM ovst o
                        LEFT JOIN vn_stat v on v.vn = o.vn
                        LEFT JOIN visit_pttype vp on vp.vn = o.vn
                        LEFT OUTER JOIN kskdepartment sk on sk.depcode = o.main_dep
                        LEFT OUTER JOIN patient p on p.hn=o.hn
                        LEFT OUTER JOIN visit_pttype_authen_report wr ON wr.personalId = p.cid and wr.claimDate = o.vstdate
                        WHERE o.vstdate = CURDATE()
                        GROUP BY o.main_dep,v.vstdate
            ');
            // = CURDATE()
            foreach ($data_authen as $key => $value) {
                $check = Dashboard_department_authen::where('vstdate', $value->vstdate)->where('main_dep', $value->main_dep)->count();
                if ($check == 0) {
                    Dashboard_department_authen::insert([
                        'vstdate'     => $value->vstdate,
                        'main_dep'    => $value->main_dep,
                        'department'  => $value->department,
                        'vn'          => $value->vn,
                        'claimCode'   => $value->claimCode,
                        'Success'     => $value->Success,
                        'Unsuccess'   => $value->Unsuccess
                    ]);
                } else {
                    Dashboard_department_authen::where('vstdate', $value->vstdate)->where('main_dep', $value->main_dep)
                    ->update([
                        'vstdate'     => $value->vstdate,
                        'main_dep'    => $value->main_dep,
                        'department'  => $value->department,
                        'vn'          => $value->vn,
                        'claimCode'   => $value->claimCode,
                        'Success'     => $value->Success,
                        'Unsuccess'   => $value->Unsuccess
                    ]);
                }
            }

            $data_authen_person = DB::connection('mysql3')->select('
                SELECT v.vstdate,op.loginname,o.staff as Staffmini,op.name as Stafffull,s.name as Spclty
                        ,COUNT(DISTINCT o.vn) as vn,count(DISTINCT vp.claimCode) as claimCode
                        ,count(DISTINCT vp.tel) as Success ,COUNT(DISTINCT o.vn)-count(DISTINCT vp.tel) as Unsuccess
                        FROM ovst o
                        LEFT JOIN vn_stat v on v.vn = o.vn
                        LEFT JOIN visit_pttype vt on vt.vn = o.vn
                        LEFT OUTER JOIN kskdepartment sk on sk.depcode = o.main_dep
                        LEFT OUTER JOIN spclty s ON s.spclty = sk.spclty
                        LEFT OUTER JOIN patient p on p.hn=o.hn
                        LEFT OUTER JOIN visit_pttype_authen_report vp ON vp.personalId = p.cid and vp.claimDate = o.vstdate
                        LEFT OUTER JOIN opduser op on op.loginname = o.staff
                        WHERE o.vstdate = CURDATE()
                        GROUP BY op.loginname,v.vstdate
            ');
            foreach ($data_authen_person as $key => $value2) {
                // $check2 = Dashboard_authenstaff_day::where('vstdate', $value2->vstdate)->count();
                $check2 = Dashboard_authenstaff_day::where('vstdate', $value2->vstdate)->where('loginname','=',$value2->loginname)->count();
                if ($check2 == 0) {
                    Dashboard_authenstaff_day::insert([
                        'vstdate'     => $value2->vstdate,
                        'loginname'   => $value2->loginname,
                        'Staff'       => $value2->Stafffull,
                        'Spclty'      => $value2->Spclty,
                        'vn'          => $value2->vn,
                        'claimCode'   => $value2->claimCode,
                        'Success'     => $value2->Success,
                        'Unsuccess'   => $value2->Unsuccess,
                        'data_date'   => $value2->vstdate
                    ]);
                } else {
                    Dashboard_authenstaff_day::where('vstdate', $value2->vstdate)->where('loginname','=',$value2->loginname)
                    ->update([
                        'vstdate'     => $value2->vstdate,
                        'loginname'   => $value2->loginname,
                        'Staff'       => $value2->Stafffull,
                        'Spclty'      => $value2->Spclty,
                        'vn'          => $value2->vn,
                        'claimCode'   => $value2->claimCode,
                        'Success'     => $value2->Success,
                        'Unsuccess'   => $value2->Unsuccess,
                        'data_date'   => $value2->vstdate
                    ]);
                }
            }

            Db_year::truncate();
            $date = date('Y-m-d');
            $y = date('Y');
            $db_year_ = DB::connection('mysql3')->select('
                        SELECT COUNT(DISTINCT o.vn) as countvn,COUNT(DISTINCT o.an) as countan,COUNT(DISTINCT ra.VN) as authenOPD
                        ,MONTH(o.vstdate) as month,YEAR(o.vstdate) as year
                        FROM ovst o
                        LEFT JOIN vn_stat v on v.vn = o.vn
                        LEFT JOIN patient p on p.hn = o.hn
                        LEFT JOIN rcmdb.authencode ra ON ra.VN = o.vn
                        WHERE YEAR(o.vstdate) = "'.$y.'"
                        AND o.an is null
                        GROUP BY month
			            ORDER BY year,month ASC
            ');

            // WHERE o.vstdate BETWEEN "2022-09-01" AND "2023-09-30"
            foreach ($db_year_ as $key => $value3) {
                Db_year::insert([
                    'month'       => $value3->month,
                    'year'        => $value3->year,
                    'countvn'     => $value3->countvn,
                    'authen_opd'  => $value3->authenOPD
                ]);
            }

            $db_year_update = DB::connection('mysql3')->select('
                    SELECT COUNT(DISTINCT o.vn) as countvn,COUNT(DISTINCT o.an) as countan,COUNT(DISTINCT ra.AN) as authenIPD
                        ,MONTH(o.vstdate) as months,YEAR(o.vstdate) as years
                        FROM ovst o
                        LEFT JOIN an_stat a on a.an = o.an
                        LEFT JOIN patient p on p.hn = o.hn
                        LEFT JOIN rcmdb.authencode ra ON ra.AN = o.an
                        WHERE YEAR(o.vstdate) = "'.$y.'"

                        GROUP BY months
                        ORDER BY years,months DESC
            ');
            // $db_year_update = DB::connection('mysql3')->select('
            //         SELECT COUNT(DISTINCT claimCode) as authen
            //         ,MONTH(claimDate) as months,YEAR(claimDate) as years
            //         FROM visit_pttype_authen_report
            //         GROUP BY months
            //         ORDER BY years DESC
            // ');

            foreach ($db_year_update as $key => $value4) {
                $yearnew = $value4->years;
                Db_year::where('month', $value4->months)->where('year', $yearnew)
                ->update([
                    'countan'        => $value4->countan,
                    'authen_ipd'     => $value4->authenIPD
                ]);
            }



            return view('auto.depauthen_auto');
    }

    public function checkauthen_autospsch(Request $request)
    {
        $date_now = date('Y-m-d');
        $date_start = "2023-05-07";
        $date_end = "2023-05-09";

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
                'Cookie: SESSION=NWY1NjU4N2YtN2E2Zi00OGQ1LWEzYjUtYzYyY2Y3NWJkNmNk; TS01bfdc7f=013bd252cb2f635ea275a9e2adb4f56d3ff24dc90de5421d2173da01a971bc0b2d397ab2bfbe08ef0e379c3946b8487cf4049afe9f2b340d8ce29a35f07f94b37287acd9c2; _ga_B75N90LD24=GS1.1.1665019756.2.0.1665019757.0.0.0; _ga=GA1.3.1794349612.1664942850; TS01e88bc2=013bd252cb8ac81a003458f85ce451e7bd5f66e6a3930b33701914767e3e8af7b92898dd63a6258beec555bbfe4b8681911d19bf0c; SESSION=YmI4MjUyNjYtODY5YS00NWFmLTlmZGItYTU5OWYzZmJmZWNh; TS01bfdc7f=013bd252cbc4ce3230a1e9bdc06904807c8155bd7d0a8060898777cf88368faf4a94f2098f920d5bbd729fbf29d55a388f507d977a65a3dbb3b950b754491e7a240f8f72eb; TS01e88bc2=013bd252cbe2073feef8c43b65869a02b9b370d9108007ac6a34a07f6ae0a96b2967486387a6a0575c46811259afa688d09b5dfd21',
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
        $result = json_decode($contents, true);
        @$content = $result['content'];
        // dd($content);

        foreach ($content as $key => $value) {
            $transId = $value['transId'];
            $hmain = $value['hmain'];
            // $personalId = $value['personalId'];
            // $patientName = $value['patientName'];
            // $mainInscl = $value['mainInscl'];
            // $mainInsclName = $value['mainInsclName'];
            // $subInscl = $value['subInscl'];
            // $subInsclName = $value['subInsclName'];
            // $hnCode = $value['hnCode'];
            // $createDate = $value['createDate'];


            // isset( $value['hmain'] ) ? $hmain = $value['hmain'] : $hmain = "";
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

            isset( $value['claimStatus'] ) ? $claimStatus = $value['claimStatus'] : $claimStatus = "";
            isset( $value['patientType'] ) ? $patientType = $value['patientType'] : $patientType = "";
            isset( $value['sourceChannel'] ) ? $sourceChannel = $value['sourceChannel'] : $sourceChannel = "";
            isset( $value['claimAuthen'] ) ? $claimAuthen = $value['claimAuthen'] : $claimAuthen = "";
            isset( $value['createBy'] ) ? $createBy = $value['createBy'] : $createBy = "";
            isset( $value['mainInsclWithName'] ) ? $mainInsclWithName = $value['mainInsclWithName'] : $mainInsclWithName = "";

            $claimDate = explode("T",$value['claimDate']);
            $checkdate = $claimDate[0];
            $checktime = $claimDate[1];
            // dd($transId);
                $datenow = date("Y-m-d");
                    $checktransId = Visit_pttype_authen_report::where('transId','=',$transId)->count();
                    // dd($checktransId);
                    if ($checktransId > 0) {

                            // Visit_pttype_authen_report::where('transId', $transId)
                                // ->update([
                                //             // 'transId'                           => $transId,
                                //             'hmain'                             => $hmain,
                                //             'personalId'                        => $personalId,
                                //             'patientName'                       => $patientName,
                                //             'addrNo'                            => $addrNo,
                                //             'moo'                               => $moo,
                                //             'moonanName'                        => $moonanName,
                                //             'tumbonName'                        => $tumbonName,
                                //             'amphurName'                        => $amphurName,
                                //             'changwatName'                      => $changwatName,
                                //             'birthdate'                         => $birthdate,
                                //             'tel'                               => $tel,
                                //             'mainInscl'                         => $mainInscl,
                                //             'mainInsclName'                     => $mainInsclName,
                                //             'subInscl'                          => $subInscl,
                                //             'subInsclName'                      => $subInsclName,
                                //             'claimDate'                         => $checkdate,
                                //             'claimTime'                         => $checktime,
                                //             'claimCode'                         => $claimCode,
                                //             'claimType'                         => $claimType,
                                //             'claimTypeName'                     => $claimTypeName,
                                //             'hnCode'                            => $hnCode,
                                //             'claimStatus'                       => $claimStatus,
                                //             'patientType'                       => $patientType,
                                //             'createBy'                          => $createBy,
                                //             'sourceChannel'                     => $sourceChannel,
                                //             'mainInsclWithName'                 => $mainInsclWithName,
                                //             'claimAuthen'                       => $claimAuthen,
                                //             'date_data'                         => $datenow
                                // ]);
                    } else {

                            $data_add = Visit_pttype_authen_report::create([
                                    'transId'                           => $transId,
                                    'hmain'                             => $hmain,
                                    'personalId'                        => $personalId,
                                    'patientName'                       => $patientName,
                                    'addrNo'                            => $addrNo,
                                    'moo'                               => $moo,
                                    'moonanName'                        => $moonanName,
                                    'tumbonName'                        => $tumbonName,
                                    'amphurName'                        => $amphurName,
                                    'changwatName'                      => $changwatName,
                                    'birthdate'                         => $birthdate,
                                    'tel'                               => $tel,
                                    'mainInscl'                         => $mainInscl,
                                    'mainInsclName'                     => $mainInsclName,
                                    'subInscl'                          => $subInscl,
                                    'subInsclName'                      => $subInsclName,
                                    'claimDate'                         => $checkdate,
                                    'claimTime'                         => $checktime,
                                    'claimCode'                         => $claimCode,
                                    'claimType'                         => $claimType,
                                    'claimTypeName'                     => $claimTypeName,
                                    'hnCode'                            => $hnCode,
                                    'claimStatus'                       => $claimStatus,
                                    'patientType'                       => $patientType,
                                    'createBy'                          => $createBy,
                                    'sourceChannel'                     => $sourceChannel,
                                    'mainInsclWithName'                 => $mainInsclWithName,
                                    'claimAuthen'                       => $claimAuthen,
                                    'date_data'                         => $datenow
                        ]);
                        $data_add->save();
                    }
        }
        return view('auto.checkauthen_autospsch',[
            'response'  => $response,
            'result'  => $result,
        ]);

    }

    public function sit_pullacc_auto______(Request $request)
    {
            $datashow = DB::connection('mysql3')->select('
                SELECT o.vn,ifnull(o.an,"") as an,o.hn,showcid(pt.cid) as cid
                        ,concat(pt.pname,pt.fname," ",pt.lname) as ptname
                        ,setdate(o.vstdate) as vstdate,totime(o.vsttime) as vsttime
                        ,v.hospmain
                        ,o.vstdate as vstdatesave
                        ,seekname(o.pt_subtype,"pt_subtype") as ptsubtype
                        ,ptt.pttype_eclaim_id
                        ,o.pttype,e.name as pttype_acc_name
                        ,e.gf_opd as gfmis,e.code as acc_code
                        ,e.ar_opd as account_code
                        ,e.name as account_name
                        ,v.income,v.uc_money,v.discount_money,v.paid_money,v.rcpt_money
                        ,v.rcpno_list as rcpno
                        ,v.income-v.discount_money-v.rcpt_money as debit
                    from ovst o
                    left join vn_stat v on v.vn=o.vn
                    left join patient pt on pt.hn=o.hn
                    left join pttype_acc ptt on ptt.pttype=o.pttype
                    left join pttype_eclaim e on e.code = ptt.pttype_eclaim_id
                where o.vstdate = CURDATE()
                and an IS NULL
                group by o.vn
            ');
            // CURDATE()
            // between "2023-01-08" and "2023-01-10"

            foreach ($datashow as $key => $value) {
                $check = Acc_debtor::where('vn', $value->vn)->count();
                if ($check > 0) {
                    // Acc_debtor::where('vn', $value->vn)
                    // ->update([
                        // 'hn'                => $value->hn,
                        // 'an'                => $value->an,
                        // 'cid'               => $value->cid,
                        // 'ptname'            => $value->ptname,
                        // 'ptsubtype'         => $value->ptsubtype,
                        // 'pttype_eclaim_id'  => $value->pttype_eclaim_id,
                        // 'hospmain'          => $value->hospmain,
                        // 'pttype'            => $value->pttype,
                        // 'pttypename'        => $value->pttype_acc_name,
                        // 'vstdate'           => $value->vstdatesave,
                        // 'vsttime'           => $value->vsttime,
                        // 'gfmis'             => $value->gfmis,
                        // 'acc_code'          => $value->acc_code,
                        // 'account_code'      => $value->account_code,
                        // 'account_name'      => $value->account_name,
                        // 'income'            => $value->income,
                        // 'uc_money'          => $value->uc_money,
                        // 'discount_money'    => $value->discount_money,
                        // 'paid_money'        => $value->paid_money,
                        // 'rcpt_money'        => $value->rcpt_money,
                        // 'rcpno'             => $value->rcpno,
                        // 'debit'             => $value->debit
                    // ]);
                } else {
                    Acc_debtor::insert([
                        'vn' => $value->vn,
                        'hn'                => $value->hn,
                        'an'                => $value->an,
                        'cid'               => $value->cid,
                        'ptname'            => $value->ptname,
                        'ptsubtype'         => $value->ptsubtype,
                        'pttype_eclaim_id'  => $value->pttype_eclaim_id,
                        'hospmain'          => $value->hospmain,
                        'pttype'            => $value->pttype,
                        'pttypename'        => $value->pttype_acc_name,
                        'vstdate'           => $value->vstdatesave,
                        'vsttime'           => $value->vsttime,
                        'gfmis'             => $value->gfmis,
                        'acc_code'          => $value->acc_code,
                        'account_code'      => $value->account_code,
                        'account_name'      => $value->account_name,
                        'income'            => $value->income,
                        'uc_money'          => $value->uc_money,
                        'discount_money'    => $value->discount_money,
                        'paid_money'        => $value->paid_money,
                        'rcpt_money'        => $value->rcpt_money,
                        'rcpno'             => $value->rcpno,
                        'debit'             => $value->debit
                    ]);
                }

            }
            // $datashow = DB::connection('mysql3')->select('
            //     SELECT o.vn,ifnull(o.an,"") as an,o.hn,showcid(pt.cid) as cid
            //             ,concat(pt.pname,pt.fname," ",pt.lname) as ptname
            //             ,setdate(o.vstdate) as vstdate,totime(o.vsttime) as vsttime
            //             ,v.hospmain
            //             ,o.vstdate as vstdatesave
            //             ,seekname(o.pt_subtype,"pt_subtype") as ptsubtype
            //             ,ptt.pttype_eclaim_id
            //             ,o.pttype,e.name as pttype_acc_name
            //             ,e.gf_opd as gfmis,e.code as acc_code
            //             ,e.ar_opd as account_code
            //             ,e.name as account_name
            //             ,v.income,v.uc_money,v.discount_money,v.paid_money,v.rcpt_money
            //             ,v.rcpno_list as rcpno
            //             ,v.income-v.discount_money-v.rcpt_money as debit
            //         from ovst o
            //         left join vn_stat v on v.vn=o.vn
            //         left join patient pt on pt.hn=o.hn
            //         left join pttype_acc ptt on ptt.pttype=o.pttype
            //         left join pttype_eclaim e on e.code = ptt.pttype_eclaim_id
            //     where o.vstdate = CURDATE()
            //     and an IS NULL
            //     group by o.vn
            // ');
            return view('auto.sit_pullacc_auto');
    }

    public function authen_auto_year(Request $request)
    {
        Db_authen::truncate();
            $date = date('Y-m-d');
            $y = date('Y');
            $db_year_ = DB::connection('mysql3')->select('
            SELECT  COUNT(DISTINCT o.vn) as countvn ,MONTH(o.vstdate) as month,YEAR(o.vstdate) as year
                        FROM ovst o
                        LEFT JOIN vn_stat v on v.vn = o.vn
                        LEFT JOIN patient p on p.hn = o.hn

                        WHERE YEAR(o.vstdate) = "'.$y.'"
                        AND o.main_dep NOT IN("011","036","107")
                        AND o.pttype NOT IN("M1","M2","M3","M4","M5","M6")
                        AND o.an is null
                        GROUP BY month
                    ORDER BY year,month ASC
            ');

            // WHERE o.vstdate BETWEEN "2022-09-01" AND "2023-09-30"
            foreach ($db_year_ as $key => $value3) {
                Db_authen::insert([
                    'month'       => $value3->month,
                    'year'        => $value3->year,
                    'countvn'     => $value3->countvn,
                    // 'authen_opd'  => $value3->authenOPD
                ]);
            }

            $db_year_update = DB::connection('mysql')->select('
                        SELECT COUNT(*) as count_authen,MONTH(vstdate) as months,YEAR(vstdate) as years
                        FROM check_authen
                        WHERE YEAR(vstdate) = "'.$y.'" AND claimtype ="PG0060001"
                        GROUP BY months
                        ORDER BY months ASC
            ');
            foreach ($db_year_update as $key => $value4) {
                $yearnew = $value4->years;
                Db_authen::where('month', $value4->months)->where('year', $yearnew)
                ->update([
                    'authen_opd'      => $value4->count_authen,
                ]);
            }

            return view('auto.authen_auto_year');
    }
    public function db_authen_detail(Request $request)
    {
        // Db_authen_detail
        $detail_auto = DB::connection('mysql3')->select('
                SELECT "" db_authen_detail_id
                ,o.vn,o.an,o.hn,showcid(p.cid) as cid,v.vstdate,concat(p.pname,p.fname," ",p.lname) as ptname,o.staff,v.income-v.discount_money-v.rcpt_money debit
                ,"" created_at,"" updated_at
                FROM ovst o
                LEFT JOIN vn_stat v on v.vn = o.vn
                LEFT JOIN patient p on p.hn = o.hn

                WHERE o.vstdate = CURDATE()
                AND o.main_dep NOT IN("011","036","107")
                AND o.pttype NOT IN("M1","M2","M3","M4","M5","M6")
                GROUP BY o.vn
            ');

            foreach ($detail_auto as $key => $value) {
                $check = Db_authen_detail::where('vn','=',$value->vn)->count();
                if ($check > 0) {
                    Db_authen_detail::where('vn', $value->vn)->update([
                        'an'           => $value->an,
                        'hn'           => $value->hn,
                        'cid'          => $value->cid,
                        'vstdate'      => $value->vstdate,
                        'ptname'       => $value->ptname,
                        'staff'        => $value->staff,
                        'debit'        => $value->debit,
                    ]);
                } else {
                    Db_authen_detail::insert([
                        'vn'           => $value->vn,
                        'an'           => $value->an,
                        'hn'           => $value->hn,
                        'cid'          => $value->cid,
                        'vstdate'      => $value->vstdate,
                        'ptname'       => $value->ptname,
                        'staff'        => $value->staff,
                        'debit'        => $value->debit,
                    ]);
                }


            }
        return view('auto.db_authen_detail');
    }

    public function sss_check_claimcode(Request $request)
    {
        date_default_timezone_set("Asia/Bangkok");
        $date = date('Y-m-d');
        // $newday = date('Y-m-d', strtotime($date . ' -30 day')); //ย้อนหลัง 30 วัน 
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์  
        $newdate = date('Y-m-d', strtotime($date . ' -1 months')); //ย้อนหลัง 1 เดือน 
        $treedate = date('Y-m-d', strtotime($date . ' -2 months')); //ย้อนหลัง 3 เดือน 
        // dd($newdate);
        // Db_authen_detail
        $detail_auto = DB::connection('mysql3')->select('
                select v1.vn,pa.cid,concat(pa.pname,pa.fname," ",pa.lname) as ptname,v1.pttype,p.name as pttype_name,o.vstdate,v1.debt_amount
                ,v1.hospmain,v1.hospsub,v1.pttypeno,v1.pttype_number
                ,concat(h1.hosptype," ",h1.name) as hospmain_name
                ,concat(h2.hosptype," ",h2.name) as hospsub_name
                ,v1.claim_code,  u.name as pttype_staff_name 
                ,vv.income-vv.discount_money-vv.rcpt_money as debit 
                from ovst o  
                left outer join vn_stat vv on vv.vn = o.vn 
                left outer join visit_pttype v1 on v1.vn = o.vn  
                left outer join opduser u on u.loginname=v1.staff  
                left outer join pttype p on p.pttype = v1.pttype  
                left outer join hospcode h1 on h1.hospcode = v1.hospmain  
                left outer join hospcode h2 on h2.hospcode = v1.hospsub  
                left outer join patient pa on pa.hn = o.hn
                
                where o.vstdate between "'.$newdate.'" AND "'.$date.'"
                AND v1.pttype IN("14","06","45","35")
                AND v1.claim_code is null order by v1.vn,v1.pttype_number
            ');

            // where o.vstdate between "'.$newweek.'" AND "'.$newdate.'"
            // where o.vstdate = CURDATE()
            foreach ($detail_auto as $key => $value) {
                  if ($value->claim_code <> '1') {
                     
                        $linetoken = "5VL5yl3CELeiLqk4cPZpdONlO25lQ1bMgSZntXrzzbD";
                        
                        $datesend = date('Y-m-d'); 
                        $header = "ClaimCode";
                        $message = $header.
                            "\n"."vn : "            . $value->vn.
                            "\n"."cid : "           . $value->cid.
                            "\n"."ptname : "        . $value->ptname.
                            "\n"."vstdate : "       . $value->vstdate.
                            "\n"."pttype : "        . $value->pttype.
                            "\n"."pttype_name : "   . $value->pttype_name.
                            "\n"."hospmain : "      . $value->hospmain.
                            "\n"."hospmain_name : " . $value->hospmain_name.
                            "\n"."hospmain : "      . $value->hospmain. 
                            "\n"."debit : "         . $value->debit.              
                            "\n"."วันที่แจ้ง : "        . $datesend.    
                            "\n"."เวลาแจ้ง : "        . date('H:i:s');  
                                    
                            if($linetoken == null){
                                $send_line ='';
                            }else{
                                $send_line = $linetoken;
                            }

                        if($send_line !== '' && $send_line !== null){  
                                $chOne = curl_init();
                                curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
                                curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0);
                                curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0);
                                curl_setopt( $chOne, CURLOPT_POST, 1);
                                curl_setopt( $chOne, CURLOPT_POSTFIELDS, $message);
                                curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=$message");
                                curl_setopt( $chOne, CURLOPT_FOLLOWLOCATION, 1);
                                $headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$send_line.'', );
                                curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
                                curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1);
                                $result = curl_exec( $chOne );
                                //  if(curl_error($chOne)) { echo 'error:' . curl_error($chOne); }
                                //     else { 
                                //         $result_ = json_decode($result, true);
                                //         echo "status : ".$result_['status']; echo "message : ". $result_['message'];
                                //         //  return response()->json([
                                //         //      'status'     => 200 , 
                                //         //      ]);
                                
                                // }
                                curl_close( $chOne );
                                
                        }
                        } else {
                            # code...
                        }
                  
            }
        return view('auto.sss_check_claimcode');
    }


}
