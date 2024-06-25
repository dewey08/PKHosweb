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
use App\Models\Checksit_hos;
use App\Models\Checksit_hospcu;
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

class AutorpstController extends Controller
{
     
    // ดึงข้อมูลมาไว้เช็คสิทธิ์ เอาทุกสิทธิ์
    public function pullhosauto(Request $request)
    {           
        $data_sits = DB::connection('mysql')->select('
                SELECT o.an,o.vn,p.hn,p.cid,o.vstdate,o.vsttime,o.pttype,p.pname,p.fname,concat(p.pname,p.fname," ",p.lname) as ptname,op.name as staffname,p.hometel
                ,pt.nhso_code,o.hospmain,o.hospsub,p.birthday
                ,o.staff,op.name as sname
                ,o.main_dep,v.income-v.discount_money-v.rcpt_money debit
                FROM hosxp_pcu.ovst o
                LEFT JOIN hosxp_pcu.vn_stat v on v.vn = o.vn
                LEFT JOIN hosxp_pcu.patient p on p.hn=o.hn
                LEFT JOIN hosxp_pcu.pttype pt on pt.pttype=o.pttype
                LEFT JOIN hosxp_pcu.opduser op on op.loginname = o.staff
                WHERE o.vstdate = CURDATE() 
                AND p.nationality = "99" 
                group by o.vn
                    
        ');        
        //  AND p.birthday <> CURDATE()
        foreach ($data_sits as $key => $value) {
                $check = Checksit_hospcu::where('vn', $value->vn)->count();

                if ($check > 0) {
                
                } else {
                    Checksit_hospcu::insert([
                        'vn'         => $value->vn,
                        'an'         => $value->an,
                        'hn'         => $value->hn,
                        'cid'        => $value->cid,
                        'vstdate'    => $value->vstdate,
                        'hometel'    => $value->hometel,
                        'vsttime'    => $value->vsttime,
                        'ptname'     => $value->ptname,
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
        return view('rpst.pullhosauto');
    }
    public function checksit_pullhosauto(Request $request)
    {
        $datestart = $request->datestart;
        $dateend = $request->dateend;
        $date = date('Y-m-d');
        $token_data = DB::connection('mysql')->select('
            SELECT cid,token FROM ssop_token
        ');       
        foreach ($token_data as $key => $valuetoken) {
            $cid_   = $valuetoken->cid;
            $token_ = $valuetoken->token;
        }
        // $token_data = DB::connection('mysql')->select('
        //     SELECT cid,token FROM hos.nhso_token where token <> ""
        // ');
        $data_sitss = DB::connection('mysql')->select('
            SELECT cid,vn,an,vstdate
            FROM checksit_hospcu
            WHERE vstdate = CURDATE()
            AND subinscl IS NULL
            ORDER BY vstdate desc
            LIMIT 100
        '); 
        foreach ($data_sitss as $key => $item) {
            $pids = $item->cid;
            $vn = $item->vn;
            $an = $item->an;

            // foreach ($token_data as $key => $value) { 
                $client = new SoapClient("http://ucws.nhso.go.th/ucwstokenp1/UCWSTokenP1?wsdl",
                    array("uri" => 'http://ucws.nhso.go.th/ucwstokenp1/UCWSTokenP1?xsd=1', "trace"=> 1,"exceptions"=> 0,"cache_wsdl"=> 0)
                    );
                    $params = array(
                        'sequence' => array(
                            "user_person_id" => "$cid_",
                            "smctoken"       => "$token_",
                            "person_id"      => "$pids"
                    )
                   
                );
            // }
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
                    Checksit_hospcu::where('vn', $vn)
                            ->update([
                                'status'         => @$status,
                                'maininscl'      => @$maininscl,
                                'startdate'      => @$startdate,
                                'hmain'          => @$hmain,
                                'subinscl'       => @$subinscl,
                                'person_id_nhso' => @$person_id_nhso,
                                'hmain_op'       => @$hmain_op,
                                'hmain_op_name'  => @$hmain_op_name,
                                'hsub'           => @$hsub,
                                'hsub_name'      => @$hsub_name,
                                'subinscl_name'  => @$subinscl_name,
                                'upsit_date'     => $date
                        ]);
                       
                    
                }elseif(@$maininscl !="" || @$subinscl !=""){
                        $date2 = date("Y-m-d");
                        Checksit_hospcu::where('vn', $vn)
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

        return view('rpst.checksit_pullhosauto');

    }

    public function datahosauto(Request $request)
    {
        $datestart = $request->startdate;
        $dateend = $request->enddate;
 
            $data_sit = DB::connection('mysql')->select('
                SELECT c.vn,c.hn,c.cid,c.vstdate,c.ptname,c.pttype,c.subinscl,c.debit,c.claimcode,c.claimtype,c.hospmain,c.hometel,c.hospsub,c.main_dep,c.hmain,c.hsub,c.subinscl_name,c.staff_name,c.staff,k.department
                FROM checksit_hospcu c
                LEFT JOIN kskdepartment k ON k.depcode = c.main_dep

                WHERE c.vstdate BETWEEN "'.$datestart.'" AND "'.$dateend.'"
           
                GROUP BY c.vn
            ');
            // AND c.pttype NOT IN("M1","M2","M3","M4","M5","M6","13","23","91","X7")
            // AND c.main_dep NOT IN("011","036","107")
        // }
        // LEFT JOIN check_authen ca ON ca.cid = c.cid and c.vstdate = ca.vstdate AND c.fokliad = ca.claimtype
        // SELECT vn,cid,vstdate,fullname,pttype,hospmain,hospsub,subinscl,hmain,hsub,staff,subinscl_name
        return view('rpst.datahosauto',[
            'data_sit'    => $data_sit,
            'start'     => $datestart,
            'end'        => $dateend,
        ]);
    }

      

}
