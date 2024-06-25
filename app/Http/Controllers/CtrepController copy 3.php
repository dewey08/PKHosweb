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
use App\Models\Leave_leader;
use App\Models\Leave_leader_sub;
use App\Models\Book_type;
use App\Models\Book_import_fam;
use App\Models\Book_signature;
use App\Models\Bookrep;
use App\Models\Book_objective;

use App\Models\D_apiofc_ins;
use App\Models\D_apiofc_iop;
use App\Models\D_apiofc_adp;
use App\Models\D_apiofc_aer;
use App\Models\D_apiofc_cha;
use App\Models\D_apiofc_cht;
use App\Models\D_apiofc_dru;
use App\Models\D_apiofc_idx;  
use App\Models\D_apiofc_pat;
use App\Models\D_apiofc_ipd;
use App\Models\D_apiofc_irf;
use App\Models\D_apiofc_ldv;
use App\Models\D_apiofc_odx;
use App\Models\D_apiofc_oop;
use App\Models\D_apiofc_opd;
use App\Models\D_apiofc_orf;
use App\Models\A_ct_scan;
use App\Models\A_ct_item;
use App\Models\A_ct;
use App\Models\A_ct_excel;

use App\Models\D_ins;
use App\Models\D_pat;
use App\Models\D_opd;
use App\Models\D_orf;
use App\Models\D_odx;
use App\Models\D_cht;
use App\Models\D_cha;
use App\Models\D_oop;
use App\Models\D_claim;
use App\Models\D_adp;
use App\Models\D_dru;
use App\Models\D_idx;
use App\Models\D_iop;
use App\Models\D_ipd;
use App\Models\D_aer;
use App\Models\D_irf;
use App\Models\D_ofc_401;
use App\Models\A_stm_ct_item;
use App\Models\A_stm_ct;
use App\Models\A_stm_ct_excel;
use Auth;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http; 
use SoapClient;
use Arr; 
use App\Imports\ImportAcc_stm_ti;
use App\Imports\ImportAcc_stm_tiexcel_import;
use App\Imports\ImportAcc_stm_ofcexcel_import;
use App\Imports\ImportAcc_stm_lgoexcel_import;
use App\Models\D_ofc_repexcel;
use App\Models\A_ct_item_check;
use App\Models\A_ct_scan_visit;
use SplFileObject;
use PHPExcel;
use PHPExcel_IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx; 
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\IOFactory; 
use ZipArchive;  
use Illuminate\Support\Facades\Redirect;
use PhpParser\Node\Stmt\If_;
use Stevebauman\Location\Facades\Location; 
use Illuminate\Filesystem\Filesystem;

use Mail;
use Illuminate\Support\Facades\Storage;
  
 
date_default_timezone_set("Asia/Bangkok");

class CtrepController extends Controller
{  
    public function ct_rep(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate; 
 
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -2 months')); //ย้อนหลัง 2 เดือน
        $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี
        $yearnew = date('Y')+1;
        $yearold = date('Y');
        $start = (''.$yearold.'-10-01');
        $end = (''.$yearnew.'-09-30'); 
        // if ($startdate == '') {  
        //     $data['datashow'] = DB::connection('mysql')->select('
        //        SELECT a.a_stm_ct_id,a.vn,a.hn,a.cid,a.ptname,a.ct_date,a.pttypename,a.pttypename_spsch,a.price_check,a.total_price_check,a.opaque_price,a.before_price
        //        ,a.discount,a.vat,a.total,a.sumprice,a.paid,a.remain,a.sfhname,b.ct_check,a.active,a.ptty_spsch
        //        FROM a_stm_ct a 
        //        LEFT OUTER JOIN a_stm_ct_item b on b.hn = a.hn 
        //        WHERE a.ct_date BETWEEN "'.$newDate.'" and "'.$date.'" AND ward = "OPD"
        //     ');  
        // } else { 
        //     $data['datashow'] = DB::connection('mysql')->select('
        //        SELECT a.a_stm_ct_id,a.vn,a.hn,a.cid,a.ptname,a.ct_date,a.pttypename,a.pttypename_spsch,a.price_check,a.total_price_check,a.opaque_price,a.before_price
        //        ,a.discount,a.vat,a.total,a.sumprice,a.paid,a.remain,a.sfhname,b.ct_check,a.active,a.ptty_spsch
        //        FROM a_stm_ct a 
        //        LEFT OUTER JOIN a_stm_ct_item b on b.hn = a.hn 
        //        WHERE a.ct_date BETWEEN "'.$startdate.'" and "'.$enddate.'" AND ward = "OPD"
        //     ');  
        // } 
        if ($startdate != '') {  
                 
                // $data['datashow'] = DB::connection('mysql')->select('SELECT * FROM a_ct WHERE vstdate BETWEEN "' . $startdate . '" AND "' . $enddate . '" ORDER BY vstdate DESC'); 
                $data['datashow'] = DB::connection('mysql')->select('
                    SELECT a_ct_scan_id,vn,hn,cid,order_date,order_time,order_date_time,request_date,ptname,xray_list,confirm_all,department,department_code
                    ,department_name,pttype,ptty_spsch,xray_order_number,xray_price,total_price,department_list,priority_name,STMdoc,user_id,active
                    FROM a_ct_scan 
                    WHERE request_date BETWEEN "' . $startdate . '" AND "' . $enddate . '" 
                    GROUP BY vn
                    ORDER BY request_date ASC
                '); 

                // $data_ct_visit = DB::connection('mysql2')->select('
                //     SELECT o.vn,o.an,o.hn,o.vstdate,concat(p.pname," ",p.fname," ",p.lname) as ptname,concat(s.name," ",s.strength," ",s.units) as xray_list ,o.qty,o.paidst,o.unitprice,o.sum_price,op.cc
                //     FROM opitemrece o  
                //     LEFT OUTER JOIN s_drugitems s on s.icode=o.icode  
                //     LEFT OUTER JOIN patient p on p.hn=o.hn  
                //     LEFT JOIN vn_stat v on v.vn = o.vn 
                //     LEFT OUTER JOIN opdscreen op on op.vn = v.vn
                //     WHERE o.vstdate BETWEEN "' . $startdate . '" AND "' . $enddate . '"
                //     AND s.income = "08" 
                //     ORDER BY o.item_no
                // ');  
                // foreach ($data_ct_visit as $key => $v_visit) {
                //     $check3 = A_ct_scan_visit::where('hn', $v_visit->hn)->where('xray_list', $v_visit->xray_list)->count(); 
                //     if ($check3 > 0) {
                //         A_ct_scan_visit::where('hn', $v_visit->hn)->where('xray_list', $v_visit->xray_list)->update([
                //             'vn'                  => $v_visit->vn,
                //             'an'                  => $v_visit->an,
                //             'hn'                  => $v_visit->hn,   
                //             'vstdate'             => $v_visit->vstdate,
                //             'ptname'              => $v_visit->ptname,
                //             'xray_list'           => $v_visit->xray_list,
                //             'qty'                 => $v_visit->qty,
                //             'paidst'              => $v_visit->paidst,
                //             'unitprice'           => $v_visit->unitprice, 
                //             'sum_price'           => $v_visit->sum_price,  
                //             'cc'                  => $v_visit->cc,  
                //             'user_id'             => Auth::user()->id
                //         ]); 
                //     } else {
                //         A_ct_scan_visit::insert([
                //             'vn'                  => $v_visit->vn,
                //             'an'                  => $v_visit->an,
                //             'hn'                  => $v_visit->hn,   
                //             'vstdate'             => $v_visit->vstdate,
                //             'ptname'              => $v_visit->ptname,
                //             'xray_list'           => $v_visit->xray_list,
                //             'qty'                 => $v_visit->qty,
                //             'paidst'              => $v_visit->paidst,
                //             'unitprice'           => $v_visit->unitprice, 
                //             'sum_price'           => $v_visit->sum_price,  
                //             'cc'                  => $v_visit->cc,  
                //             'user_id'             => Auth::user()->id
                //         ]); 
                //     }
                // }

        } else { 
                $data['datashow'] = DB::connection('mysql')->select('
                    SELECT a_ct_scan_id,vn,hn,cid,order_date,order_time,order_date_time,request_date,ptname,xray_list,confirm_all,department,department_code
                    ,department_name,pttype,ptty_spsch,xray_order_number,xray_price,total_price,department_list,priority_name,STMdoc,user_id,active
                    FROM a_ct_scan 
                    WHERE request_date BETWEEN "2024-01-16" AND "2024-01-31"
                  
                    GROUP BY vn
                    ORDER BY request_date ASC
                '); 
                // AND active = "N"
                // WHERE request_date BETWEEN "' . $newDate . '" AND "' . $date . '"
                // $data['datashow'] = DB::connection('mysql')->select('SELECT * FROM a_ct WHERE vstdate BETWEEN "' . $newDate . '" AND "' . $date . '" ORDER BY vstdate DESC');
                // $data['datashow'] = DB::connection('mysql')->select('SELECT * FROM a_ct_scan WHERE order_date BETWEEN "' . $newDate . '" AND "' . $date . '" ORDER BY order_date_time DESC'); 
                // AND (xray_list LIKE "CX%" OR xray_list LIKE "CT%")
        }  
        // AND (xray_list LIKE "CX%" OR xray_list LIKE "CT%")
        
        return view('ct.ct_rep',$data,[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate, 
            // 'datashow'      =>     $datashow,
        ]);
    }
     
    public function ct_rep_pull(Request $request)
    {   
            $startdate = $request->startdate;
            $enddate = $request->enddate;
         
                $data_ct_new = DB::connection('mysql2')->select(' 
                    SELECT  
                        IFNULL(i.vn ,x.vn) vn
                        ,x.an,x.hn,x.request_date,x.report_date,p.cid
                        ,concat(p.pname," ",p.fname," ",p.lname) as ptname
                        ,xi.xray_items_name as xray_list,x.confirm as confirm_all 
                        ,case 
                        when xh.department is null then xt.department
                        else xh.department
                        end as department
                        ,case 
                        when xh.department_code is null then xt.department_code
                        else xh.department_code
                        end as department_code
                        ,case 
                        when xh.department_name is null then xt.department_name
                        else xh.department_name
                        end as department_name 
                        ,IFNULL(v.pttype ,i.pttype) pttype
                        ,case 
                        when xh.xray_order_number is null then xt.xray_order_number
                        else xh.xray_order_number
                        end as xray_order_number
                       
                        ,case 
                        when xi.service_price is null then xi.service_price_ipd
                        else xi.service_price
                        end as xray_price
                        ,case 
                        when xh.total_price is null then xt.total_price
                        else xh.total_price
                        end as total_price
                        ,case 
                        when xh.department_list is null then xt.department_list
                        else xh.department_list
                        end as department_list                            
                        ,y.priority_name

                        ,h.hospcode,ro.icd10 as referin_no,h.name as hospmain
                        
                        FROM xray_report x  
                        LEFT OUTER JOIN patient p on p.hn=x.hn  
                        LEFT JOIN vn_stat v on v.vn = x.vn   
                        LEFT JOIN ipt i on i.an = x.an 
                        LEFT OUTER JOIN xray_items xi on xi.xray_items_code=x.xray_items_code  
                        LEFT JOIN xray_head xh on xh.vn = x.vn
                        LEFT JOIN xray_head xt on xt.vn = x.an 
                        LEFT OUTER JOIN xray_priority y on y.xray_priority_id = xh.xray_priority_id 
                        LEFT OUTER JOIN hospcode h on h.hospcode = v.hospmain 
                        LEFT OUTER JOIN referin ro on ro.vn = v.vn 
                        WHERE x.request_date BETWEEN "' . $startdate . '" AND "' . $enddate . '" 
                        AND (xi.xray_items_group ="3") 

                         
                ');
                // ,case 
                // when xh.xray_price is null then xt.xray_price
                // else xh.xray_price
                // end as xray_price            
                foreach ($data_ct_new as $key => $value_new) {   
                    $check2 = A_ct_scan::where('vn', $value_new->vn)->where('xray_list', $value_new->xray_list)->count();               
                    if ($check2 > 0) {    
                        A_ct_scan::where('vn',$value_new->vn)->where('xray_list', $value_new->xray_list)->update([
                            // 'vn'                  => $value_new->vn,
                            // 'an'                  => $value_new->an,
                            // 'hn'                  => $value_new->hn,                                 
                            // 'cid'                 => $value_new->cid,  
                            // 'request_date'        => $value_new->request_date,
                            // 'ptname'              => $value_new->ptname,
                            // 'xray_list'           => $value_new->xray_list,
                            // 'confirm_all'         => $value_new->confirm_all,
                            // 'department'          => $value_new->department,
                            // 'department_code'     => $value_new->department_code, 
                            // 'department_name'     => $value_new->department_name, 
                            // 'pttype'              => $value_new->pttype, 
                            // 'xray_order_number'   => $value_new->xray_order_number, 
                            'xray_price'          => $value_new->xray_price, 
                            'total_price'         => $value_new->total_price, 
                            // 'department_list'     => $value_new->department_list, 
                            // 'priority_name'       => $value_new->priority_name,  
                            'user_id'             => Auth::user()->id,
                            'hospcode'            => $value_new->hospcode, 
                            'referin_no'          => $value_new->referin_no, 
                            'hospmain'            => $value_new->hospmain, 
                        ]);              
                    } else {
                        A_ct_scan::insert([
                            'vn'                  => $value_new->vn,
                            'an'                  => $value_new->an,
                            'hn'                  => $value_new->hn,                                 
                            'cid'                 => $value_new->cid,  
                            'request_date'        => $value_new->request_date,
                            'ptname'              => $value_new->ptname,
                            'xray_list'           => $value_new->xray_list,
                            'confirm_all'         => $value_new->confirm_all,
                            'department'          => $value_new->department,
                            'department_code'     => $value_new->department_code, 
                            'department_name'     => $value_new->department_name, 
                            'pttype'              => $value_new->pttype, 
                            'xray_order_number'   => $value_new->xray_order_number, 
                            'xray_price'          => $value_new->xray_price, 
                            'total_price'         => $value_new->total_price, 
                            'department_list'     => $value_new->department_list, 
                            'priority_name'       => $value_new->priority_name,  
                            'user_id'             => Auth::user()->id,
                            'hospcode'            => $value_new->hospcode, 
                            'referin_no'          => $value_new->referin_no, 
                            'hospmain'            => $value_new->hospmain, 
                        ]); 
                    }                    
                } 
                $data_ct_visit = DB::connection('mysql2')->select('
                    SELECT o.vn,o.an,o.hn,o.vstdate,concat(p.pname," ",p.fname," ",p.lname) as ptname,concat(s.name," ",s.strength," ",s.units) as xray_list ,o.qty,o.paidst,o.unitprice,o.sum_price,op.cc
                    FROM opitemrece o  
                    LEFT OUTER JOIN s_drugitems s on s.icode=o.icode  
                    LEFT OUTER JOIN patient p on p.hn=o.hn  
                    LEFT JOIN vn_stat v on v.vn = o.vn 
                    LEFT OUTER JOIN opdscreen op on op.vn = v.vn
                    WHERE o.vstdate BETWEEN "' . $startdate . '" AND "' . $enddate . '"
                    AND s.income = "08" 
                    ORDER BY o.item_no
                ');  
                foreach ($data_ct_visit as $key => $v_visit) {
                    $check3 = A_ct_scan_visit::where('hn', $v_visit->hn)->where('xray_list', $v_visit->xray_list)->count(); 
                    if ($check3 > 0) {
                        A_ct_scan_visit::where('hn', $v_visit->hn)->where('xray_list', $v_visit->xray_list)->update([
                            'vn'                  => $v_visit->vn,
                            'an'                  => $v_visit->an,
                            'hn'                  => $v_visit->hn,   
                            'vstdate'             => $v_visit->vstdate,
                            'ptname'              => $v_visit->ptname,
                            'xray_list'           => $v_visit->xray_list,
                            'qty'                 => $v_visit->qty,
                            'paidst'              => $v_visit->paidst,
                            'unitprice'           => $v_visit->unitprice, 
                            'sum_price'           => $v_visit->sum_price,  
                            'cc'                  => $v_visit->cc,  
                            'user_id'             => Auth::user()->id
                        ]); 
                    } else {
                        A_ct_scan_visit::insert([
                            'vn'                  => $v_visit->vn,
                            'an'                  => $v_visit->an,
                            'hn'                  => $v_visit->hn,   
                            'vstdate'             => $v_visit->vstdate,
                            'ptname'              => $v_visit->ptname,
                            'xray_list'           => $v_visit->xray_list,
                            'qty'                 => $v_visit->qty,
                            'paidst'              => $v_visit->paidst,
                            'unitprice'           => $v_visit->unitprice, 
                            'sum_price'           => $v_visit->sum_price,  
                            'cc'                  => $v_visit->cc,  
                            'user_id'             => Auth::user()->id
                        ]); 
                    }
                }
               $updatehcode = DB::connection('mysql')->select('SELECT vn,an,request_date FROM a_ct_scan WHERE request_date BETWEEN "' . $startdate . '" AND "' . $enddate . '" AND hospcode IS NULL');
               foreach ($updatehcode as $key => $val_up) {
                    $data_ct_new_ = DB::connection('mysql2')->select(' 
                        SELECT v.vn,h.hospcode,ro.icd10 as referin_no,h.name as hospmain
                        FROM vn_stat v
                        LEFT OUTER JOIN hospcode h on h.hospcode = v.hospmain 
                        LEFT OUTER JOIN referin ro on ro.vn = v.vn 
                        WHERE v.vn = "' . $val_up->vn . '"
                    ');
                    // WHERE vstdate BETWEEN "' . $startdate . '" AND "' . $enddate . '"
                    foreach ($data_ct_new_ as $key => $v_up) {
                        A_ct_scan::where('vn',$v_up->vn)->update([   
                            'hospcode'            => $value_new->hospcode, 
                            'referin_no'          => $value_new->referin_no, 
                            'hospmain'            => $value_new->hospmain, 
                        ]); 
                    }
                         
               }

                

            return response()->json([

                'status'    => '200'
            ]);
    }
    public function ct_rep_import(Request $request)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        // $datashow = DB::connection('mysql')->select('
        //     SELECT cid,vstdate,SUM(sum_price) as sumprice,STMdoc,month(vstdate) as months
        //     FROM a_ct
        //     WHERE cid is not null
        //     GROUP BY cid
        //     ORDER BY STMdoc DESC
        // ');
        $datashow = DB::connection('mysql')->select('
            SELECT cid,ct_date,SUM(sumprice) as sumprice,STMdoc,month(ct_date) as months
            FROM a_ct_excel
            WHERE cid is not null
            GROUP BY cid
            ORDER BY STMdoc DESC
        ');
            // SELECT cid,vstdate,SUM(sum_price) as sumprice,SUM(paid) as paid,SUM(remain) as remain,STMdoc,month(vstdate) as months
        $countc = DB::table('a_ct_excel')->count(); 
        return view('ct.ct_rep_import',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'datashow'      =>     $datashow,
            'countc'        =>     $countc
        ]);
    }  
    function ct_rep_import_save (Request $request)
    {  
        // A_ct_excel::truncate(); 

        $the_file = $request->file('file'); 
        $file_ = $request->file('file')->getClientOriginalName(); //ชื่อไฟล์
        // dd($file_);
            try{       
                $spreadsheet = IOFactory::load($the_file); 
                $sheet        = $spreadsheet->setActiveSheetIndex(0);
                $row_limit    = $sheet->getHighestDataRow();
                $column_limit = $sheet->getHighestDataColumn();
                $row_range    = range( 3, $row_limit );
                $column_range = range( 'AI', $column_limit );
                $startcount = 3;
                $data = array();

                // dd($data);
                foreach ($row_range as $row ) {
                    $vst = $sheet->getCell( 'B' . $row )->getValue();  
                    if ( $vst != '') {
                        $day = substr($vst,0,2);
                        $mo = substr($vst,3,2);
                        $year = (substr($vst,6,4)-543);  
                        $ct_date = $year.'-'.$mo.'-'.$day; 
                    } else {
                        $ct_date = '0000-00-00';
                    }
                    // $o = $sheet->getCell( 'O' . $row )->getValue();
                    // $del_o = str_replace(",","",$o);

                    $q = $sheet->getCell( 'Q' . $row )->getValue();
                    $del_q = str_replace(",","",$q);
                    $r= $sheet->getCell( 'R' . $row )->getValue();
                    $del_r = str_replace(",","",$r);

                    $t= $sheet->getCell( 'T' . $row )->getValue();
                    $del_t = str_replace(",","",$t);
                    $u= $sheet->getCell( 'U' . $row )->getValue();
                    $del_u = str_replace(",","",$u);
                    // $v= $sheet->getCell( 'V' . $row )->getValue();
                    // $del_v = str_replace(",","",$v);

                    $w= $sheet->getCell( 'W' . $row )->getValue();
                    $del_w = str_replace(",","",$w);
                    $w= $sheet->getCell( 'X' . $row )->getValue();
                    $del_x = str_replace(",","",$w);
                    $y= $sheet->getCell( 'Y' . $row )->getValue();
                    $del_y = str_replace(",","",$y);
                    $z= $sheet->getCell( 'Z' . $row )->getValue();
                    $del_z = str_replace(",","",$z);
                    $aa= $sheet->getCell( 'AA' . $row )->getValue();
                    $del_aa = str_replace(",","",$aa);
                    $ab= $sheet->getCell( 'AB' . $row )->getValue();
                    $del_ab = str_replace(",","",$ab);
                    $ac= $sheet->getCell( 'AC' . $row )->getValue();
                    $del_ac = str_replace(",","",$ac);
                    $ad= $sheet->getCell( 'AD' . $row )->getValue();
                    $del_ad = str_replace(",","",$ad);
                    $ae= $sheet->getCell( 'AE' . $row )->getValue();
                    $del_ae = str_replace(",","",$ae);


                    // total_opaque_price
                    $iduser = Auth::user()->id;
                    $data[] = [ 
                        'ct_date'                 =>$ct_date,
                        'ct_timein'               =>$sheet->getCell( 'C' . $row )->getValue(),
                        'hn'                      =>$sheet->getCell( 'D' . $row )->getValue(),
                        'an'                      =>$sheet->getCell( 'E' . $row )->getValue(),
                        'cid'                     =>$sheet->getCell( 'F' . $row )->getValue(),
                        'ptname'                  =>$sheet->getCell( 'G' . $row )->getValue(),
                        'sfhname'                 =>$sheet->getCell( 'H' . $row )->getValue(), 
                        'typename'                =>$sheet->getCell( 'I' . $row )->getValue(), 
                        'pttypename'              =>$sheet->getCell( 'J' . $row )->getValue(),  
                        'hname'                   =>$sheet->getCell( 'K' . $row )->getValue(), 
                        'cardno'                  =>$sheet->getCell( 'L' . $row )->getValue(),
                        'ward'                    =>$sheet->getCell( 'M' . $row )->getValue(),
                        'service'                 =>$sheet->getCell( 'N' . $row )->getValue(),
                        'icode_hos'               =>$sheet->getCell( 'O' . $row )->getValue(), 
                        'ct_check'                =>$sheet->getCell( 'P' . $row )->getValue(), 
                        'price_check'             =>$del_q,
                        'total_price_check'       =>$del_r,
                        'opaque'                  =>$sheet->getCell( 'S' . $row )->getValue(),
                        'opaque_price'            =>$del_t, 
                        'total_opaque_price'      =>$del_u, 
                        'other'                   =>$sheet->getCell( 'V' . $row )->getValue(), 
                        'other_price'             =>$del_u, 
                        'total_other_price'       =>$del_w, 
                        'before_price'            =>$del_y,
                        'discount'                =>$del_z,
                        'vat'                     =>$del_aa,
                        'total'                   =>$del_ab,
                        'sumprice'                =>$del_ac,
                        'paid'                    =>$del_ad,
                        'remain'                  =>$del_ae, 
                        'doctor'                  =>$sheet->getCell( 'AF' . $row )->getValue(), 
                        'doctor_read'             =>$sheet->getCell( 'AG' . $row )->getValue(), 
                        'technician'              =>$sheet->getCell( 'AH' . $row )->getValue(), 
                        'technician_sub'          =>$sheet->getCell( 'AI' . $row )->getValue(), 
                        'nurse'                   =>$sheet->getCell( 'AJ' . $row )->getValue(), 
                        'icd9'                    =>$sheet->getCell( 'AK' . $row )->getValue(),  
                        'user_id'                 =>$iduser,  
                        'STMDoc'                  =>$file_ 
                    ];
                    $startcount++;  

                    $check = A_ct_excel::where('ct_date',$ct_date)->where('cid',$sheet->getCell( 'F' . $row )->getValue())->count(); 
                    if ($check > 0) { 
                    } else { 
                        A_ct_excel::insert([
                            'ct_date'                 =>$ct_date,
                            'ct_timein'               =>$sheet->getCell( 'C' . $row )->getValue(),
                            'hn'                      =>$sheet->getCell( 'D' . $row )->getValue(),
                            'an'                      =>$sheet->getCell( 'E' . $row )->getValue(),
                            'cid'                     =>$sheet->getCell( 'F' . $row )->getValue(),
                            'ptname'                  =>$sheet->getCell( 'G' . $row )->getValue(),
                            'sfhname'                 =>$sheet->getCell( 'H' . $row )->getValue(), 
                            'typename'                =>$sheet->getCell( 'I' . $row )->getValue(), 
                            'pttypename'              =>$sheet->getCell( 'J' . $row )->getValue(),  
                            'hname'                   =>$sheet->getCell( 'K' . $row )->getValue(), 
                            'cardno'                  =>$sheet->getCell( 'L' . $row )->getValue(),
                            'ward'                    =>$sheet->getCell( 'M' . $row )->getValue(),
                            'service'                 =>$sheet->getCell( 'N' . $row )->getValue(),
                            'icode_hos'               =>$sheet->getCell( 'O' . $row )->getValue(), 
                            'ct_check'                =>$sheet->getCell( 'P' . $row )->getValue(), 
                            'price_check'             =>$del_q,
                            'total_price_check'       =>$del_r,
                            'opaque'                  =>$sheet->getCell( 'S' . $row )->getValue(),
                            'opaque_price'            =>$del_t, 
                            'total_opaque_price'      =>$del_u, 
                            'other'                   =>$sheet->getCell( 'V' . $row )->getValue(), 
                            'other_price'             =>$del_u, 
                            'total_other_price'       =>$del_w, 
                            'before_price'            =>$del_y,
                            'discount'                =>$del_z,
                            'vat'                     =>$del_aa,
                            'total'                   =>$del_ab,
                            'sumprice'                =>$del_ac,
                            'paid'                    =>$del_ad,
                            'remain'                  =>$del_ae, 
                            'doctor'                  =>$sheet->getCell( 'AF' . $row )->getValue(), 
                            'doctor_read'             =>$sheet->getCell( 'AG' . $row )->getValue(), 
                            'technician'              =>$sheet->getCell( 'AH' . $row )->getValue(), 
                            'technician_sub'          =>$sheet->getCell( 'AI' . $row )->getValue(), 
                            'nurse'                   =>$sheet->getCell( 'AJ' . $row )->getValue(), 
                            'icd9'                    =>$sheet->getCell( 'AK' . $row )->getValue(),  
                            'user_id'                 =>$iduser,  
                            'STMDoc'                  =>$file_                        
                        ]);
                    }

                    $check = A_ct_item_check::where('ct_date',$ct_date)->where('cid',$sheet->getCell( 'F' . $row )->getValue())->count(); 
                    if ($check > 0) { 
                    } else { 
                        A_ct_item_check::insert([
                            'ct_date'                 =>$ct_date,
                            'ct_timein'               =>$sheet->getCell( 'C' . $row )->getValue(),
                            'hn'                      =>$sheet->getCell( 'D' . $row )->getValue(),
                            'an'                      =>$sheet->getCell( 'E' . $row )->getValue(),
                            'cid'                     =>$sheet->getCell( 'F' . $row )->getValue(),
                            'ptname'                  =>$sheet->getCell( 'G' . $row )->getValue(),
                            'sfhname'                 =>$sheet->getCell( 'H' . $row )->getValue(), 
                            'typename'                =>$sheet->getCell( 'I' . $row )->getValue(), 
                            'pttypename'              =>$sheet->getCell( 'J' . $row )->getValue(),  
                            'hname'                   =>$sheet->getCell( 'K' . $row )->getValue(), 
                            'cardno'                  =>$sheet->getCell( 'L' . $row )->getValue(),
                            'ward'                    =>$sheet->getCell( 'M' . $row )->getValue(),
                            'service'                 =>$sheet->getCell( 'N' . $row )->getValue(),
                            'icode_hos'               =>$sheet->getCell( 'O' . $row )->getValue(), 
                            'ct_check'                =>$sheet->getCell( 'P' . $row )->getValue(), 
                            'price_check'             =>$del_q,
                            'total_price_check'       =>$del_r,
                            'opaque'                  =>$sheet->getCell( 'S' . $row )->getValue(),
                            'opaque_price'            =>$del_t, 
                            'total_opaque_price'      =>$del_u, 
                            'other'                   =>$sheet->getCell( 'V' . $row )->getValue(), 
                            'other_price'             =>$del_u, 
                            'total_other_price'       =>$del_w, 
                            'before_price'            =>$del_y,
                            'discount'                =>$del_z,
                            'vat'                     =>$del_aa,
                            'total'                   =>$del_ab,
                            'sumprice'                =>$del_ac,
                            'paid'                    =>$del_ad,
                            'remain'                  =>$del_ae, 
                            'doctor'                  =>$sheet->getCell( 'AF' . $row )->getValue(), 
                            'doctor_read'             =>$sheet->getCell( 'AG' . $row )->getValue(), 
                            'technician'              =>$sheet->getCell( 'AH' . $row )->getValue(), 
                            'technician_sub'          =>$sheet->getCell( 'AI' . $row )->getValue(), 
                            'nurse'                   =>$sheet->getCell( 'AJ' . $row )->getValue(), 
                            'icd9'                    =>$sheet->getCell( 'AK' . $row )->getValue(),  
                            'user_id'                 =>$iduser,  
                            'STMDoc'                  =>$file_                        
                        ]);
                    }
                } 
                // foreach (array_chunk($data,500) as $t)  
                // {  
                //     DB::table('a_ct_item_check')->insert($t);
                // }    
            } catch (Exception $e) {
                $error_code = $e->errorInfo[1];
                return back()->withErrors('There was a problem uploading the data!');
            }

            $data_sync_excel     = DB::connection('mysql')->select('
                SELECT ct_date,hn,an,cid,ptname,sfhname,pttypename,ward,icode_hos,ct_check,price_check,total_price_check,opaque,opaque_price,total_opaque_price
                ,other_price,total_other_price,before_price,discount,vat,total,sumprice,paid,remain,STMDoc
                FROM a_ct_excel 
            ');     
            foreach ($data_sync_excel as $key => $value) {     
                $check = A_ct_scan::where('request_date',$value->ct_date)->where('cid',$value->cid)->count();    
                if ($check > 0) {
                    A_ct_scan::where('request_date',$value->ct_date)->where('cid',$value->cid)->update([                
                        'STMDoc'             =>  $value->STMDoc,
                    ]);
                } else {
                    # code...
                }
                
               
                
            }
  
            A_ct_excel::truncate(); 

            return redirect()->route('ct.ct_rep_import');
       
    }  
    public function ct_rep_sync(Request $request)
    { 
        $startdate           = $request->startdate;
        $enddate             = $request->enddate;
        $data_sync_excel     = DB::connection('mysql')->select('
            SELECT ct_date,hn,an,cid,ptname,sfhname,pttypename,ward,icode_hos,ct_check,price_check,total_price_check,opaque,opaque_price,total_opaque_price
            ,other_price,total_other_price,before_price,discount,vat,total,sumprice,paid,remain,STMDoc
            FROM a_ct_excel
            WHERE ct_date BETWEEN "' . $startdate . '" AND "' . $enddate . '"           
        ');     
        foreach ($data_sync_excel as $key => $value) {            
            A_ct_scan::where('request_date',$value->ct_date)->where('cid',$value->cid)->update([                
                'STMDoc'             =>  $value->STMDoc,
            ]);
            
        }

        // A_ct_excel::truncate(); 
        return response()->json([
                'status'    => '200',
            ]);
    }
    public function ct_report(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;
 
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -1 months')); //ย้อนหลัง 2 เดือน
        $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี
        $yearnew = date('Y')+1;
        $yearold = date('Y');
        $start = (''.$yearold.'-10-01');
        $end = (''.$yearnew.'-09-30'); 
     
        if ($startdate != '') {   
                $data['datashow'] = DB::connection('mysql')->select('
                    SELECT *
                    FROM a_ct_scan 
                    WHERE request_date BETWEEN "' . $startdate . '" AND "' . $enddate . '" 
                    GROUP BY vn
                    ORDER BY request_date DESC
                '); 
        } else { 
                $data['datashow'] = DB::connection('mysql')->select('
                    SELECT *
                    FROM a_ct_scan 
                    WHERE request_date BETWEEN "' . $newDate . '" AND "' . $date . '" 
                    GROUP BY vn
                   ORDER BY request_date DESC
                ');                 
        }          
        
        return view('ct.ct_report',$data,[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate, 
            // 'datashow'      =>     $datashow,
        ]);
    }

    public function ct_report_hos(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;
 
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -1 months')); //ย้อนหลัง 2 เดือน
        $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี
        $yearnew = date('Y')+1;
        $yearold = date('Y');
        $start = (''.$yearold.'-10-01');
        $end = (''.$yearnew.'-09-30'); 
     
        if ($startdate != '') {   
                $data['datashow'] = DB::connection('mysql')->select('
                    SELECT *
                    FROM a_ct_scan 
                    WHERE request_date BETWEEN "' . $startdate . '" AND "' . $enddate . '" 
                    GROUP BY vn
                    ORDER BY request_date DESC
                '); 
        } else { 
                $data['datashow'] = DB::connection('mysql')->select('
                    SELECT *
                    FROM a_ct_scan 
                    WHERE request_date BETWEEN "' . $newDate . '" AND "' . $date . '" 
                    GROUP BY vn
                   ORDER BY request_date DESC
                ');                 
        }          
        
        return view('ct.ct_report_hos',$data,[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate, 
            // 'datashow'      =>     $datashow,
        ]);
    }

    public function ct_rep_pay(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;

        
 
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -2 months')); //ย้อนหลัง 2 เดือน
        $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี
        $yearnew = date('Y')+1;
        $yearold = date('Y');
        $start = (''.$yearold.'-10-01');
        $end = (''.$yearnew.'-09-30'); 
     
        if ($startdate != '') {   
                $data['datashow'] = DB::connection('mysql')->select('
                    SELECT a_ct_scan_id,vn,hn,cid,order_date,order_time,order_date_time,ptname,xray_list,confirm_all,department,department_code
                    ,department_name,pttype,ptty_spsch,xray_order_number,xray_price,total_price,department_list,priority_name,STMdoc,user_id,active
                    FROM a_ct_scan 
                    WHERE order_date BETWEEN "' . $startdate . '" AND "' . $enddate . '" AND active = "Y" ORDER BY order_date_time DESC
                '); 

        } else { 
                $data['datashow'] = DB::connection('mysql')->select('
                    SELECT a_ct_scan_id,vn,hn,cid,order_date,order_time,order_date_time,ptname,xray_list,confirm_all,department,department_code
                    ,department_name,pttype,ptty_spsch,xray_order_number,xray_price,total_price,department_list,priority_name,STMdoc,user_id,active
                    FROM a_ct_scan 
                    WHERE order_date BETWEEN "' . $newDate . '" AND "' . $date . '" AND active = "Y" ORDER BY order_date_time DESC
                '); 
                
        }  
        
        
        return view('ct.ct_rep_pay',$data,[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate, 
            // 'datashow'      =>     $datashow,
        ]);
    }
    public function ct_rep_import_send(Request $request)
    {

        try{
            $data_ = DB::connection('mysql')->select('SELECT * FROM a_stm_ct_excel');
            // dd($data_);
                foreach ($data_ as $key => $value) {
                    if ($value->ct_check != '') {
                        $check = A_stm_ct::where('ct_date','=',$value->ct_date)->where('cid','=',$value->cid)->count();
                        if ($check > 0) {
                        } else {
                            A_stm_ct::insert([
                                'ct_date'                  =>$value->ct_date,
                                'ct_timein'                =>$value->ct_timein,
                                'hn'                       =>$value->hn,
                                'an'                       =>$value->an,
                                'cid'                      =>$value->cid,
                                'ptname'                   =>$value->ptname,
                                'sfhname'                  =>$value->sfhname, 
                                'typename'                 =>$value->typename,
                                'pttypename'               =>$value->pttypename,
                                'hname'                    =>$value->hname,  
                                'cardno'                   =>$value->cardno,
                                'ward'                     =>$value->ward,
                                'service'                  =>$value->service,
                                'ct_check'                 =>$value->ct_check,
                                'price_check'              =>$value->price_check,
                                'total_price_check'        =>$value->total_price_check,
                                'opaque'                   =>$value->opaque, 
                                'opaque_price'             =>$value->opaque_price, 
                                'total_opaque_price'       =>$value->total_opaque_price, 
                                'other'                    =>$value->other, 
                                'other_price'              =>$value->other_price, 
                                'total_other_price'        =>$value->total_other_price, 
                                'before_price'             =>$value->before_price, 
                                'discount'                 =>$value->discount, 
                                'vat'                      =>$value->vat, 
                                'total'                    =>$value->total, 
                                'sumprice'                 =>$value->sumprice, 
                                'paid'                     =>$value->paid, 
                                'remain'                   =>$value->remain, 
                                'doctor'                   =>$value->doctor, 
                                'doctor_read'              =>$value->doctor_read, 
                                'technician'               =>$value->technician, 
                                'technician_sub'           =>$value->technician_sub, 
                                'nurse'                    =>$value->nurse, 
                                'icd9'                     =>$value->icd9, 
                                'user_id'                  =>$value->user_id, 
                                'STMDoc'                   =>$value->STMDoc, 
                                'vn'                       =>$value->vn,
                                'hos_check'                =>$value->hos_check,
                                'hos_price_check'          =>$value->hos_price_check,
                                'hos_total_price_check'    =>$value->hos_total_price_check,
                                
                            ]);
                            
                        }
                    } else {
                    }
                }
            } catch (Exception $e) {
                $error_code = $e->errorInfo[1];
                return back()->withErrors('There was a problem uploading the data!');
            }

            A_stm_ct_excel::truncate(); 

            return redirect()->route('ct.ct_rep_import');
    }
   
    public function ct_rep_sync222(Request $request)
    { 
        $startdate    = $request->startdate;
        $enddate      = $request->enddate;

        // ***** OPD *****
            $datasync     = DB::connection('mysql2')->select('
                SELECT o.vstdate,xr.vn,o.hn,p.cid,x.icode,x.xray_items_name ,x.service_price,xr.confirm   
                FROM xray_report xr  
                LEFT OUTER JOIN xray_items x on x.xray_items_code=xr.xray_items_code  
                LEFT OUTER JOIN ovst o on o.vn=xr.vn
                LEFT OUTER JOIN patient p on p.hn=o.hn
                WHERE o.vstdate BETWEEN "'.$startdate.'" AND "'.$enddate.'"
            ');
            foreach ($datasync as $key => $value) {
                $count = A_stm_ct_item::where('ct_date',$value->vstdate)->where('cid',$value->cid)->count('ct_check');
                
                if ($count > 1) {
                    $data_item = DB::connection('mysql')->select('SELECT ct_check FROM a_stm_ct_item WHERE ct_date = "'.$value->vstdate.'" AND cid = "'.$value->cid.'"');
                    foreach ($data_item as $v) {
                    if ($v->ct_check == 'CT Lower abdomen') {
                            A_stm_ct_item::where('ct_check','=','CT Lower abdomen')->where('ct_date',$value->vstdate)->where('cid',$value->cid)->update(['ct_check_hos' => 'CT Lower abdomen with contrast']);
                            A_stm_ct::where('ct_date',$value->vstdate)->where('cid',$value->cid)->update(['vn' => $value->vn]);
                        } elseif ($v->ct_check == 'CT Upper abdomen') {
                            A_stm_ct_item::where('ct_check','=','CT Upper abdomen')->where('ct_date',$value->vstdate)->where('cid',$value->cid)->update(['ct_check_hos' => 'CT Upper abdomen']);
                            A_stm_ct::where('ct_date',$value->vstdate)->where('cid',$value->cid)->update(['vn' => $value->vn]);
                        } elseif ($v->ct_check == 'CT Chest') {
                            A_stm_ct_item::where('ct_check','=','CT Chest')->where('ct_date',$value->vstdate)->where('cid',$value->cid)->update(['ct_check_hos' => 'CT Chest with contrast']);
                            A_stm_ct::where('ct_date',$value->vstdate)->where('cid',$value->cid)->update(['vn' => $value->vn]);
                        } elseif ($v->ct_check == 'CT Neck') {
                            A_stm_ct_item::where('ct_check','=','CT Neck')->where('ct_date',$value->vstdate)->where('cid',$value->cid)->update(['ct_check_hos' => 'CT Neck with contrast']);
                            A_stm_ct::where('ct_date',$value->vstdate)->where('cid',$value->cid)->update(['vn' => $value->vn]);
                        } elseif ($v->ct_check == 'CT BRAIN  WITHOUT CONTRAST STUDY') {
                            A_stm_ct_item::where('ct_check','=','CT BRAIN  WITHOUT CONTRAST STUDY')->where('ct_date',$value->vstdate)->where('cid',$value->cid)->update(['ct_check_hos' => 'CT Brain without contrast study']);
                            A_stm_ct::where('ct_date',$value->vstdate)->where('cid',$value->cid)->update(['vn' => $value->vn]);
                        } elseif ($v->ct_check == 'CT SPINE: CERVICAL') {
                            A_stm_ct_item::where('ct_check','=','CT SPINE: CERVICAL')->where('ct_date',$value->vstdate)->where('cid',$value->cid)->update(['ct_check_hos' => 'CT C-Spine']);
                            A_stm_ct::where('ct_date',$value->vstdate)->where('cid',$value->cid)->update(['vn' => $value->vn]);
                        } elseif ($v->ct_check == 'CT FACIAL BONE') {
                            A_stm_ct_item::where('ct_check','=','CT FACIAL BONE')->where('ct_date',$value->vstdate)->where('cid',$value->cid)->update(['ct_check_hos' => 'CT Facial bone']);
                            A_stm_ct::where('ct_date',$value->vstdate)->where('cid',$value->cid)->update(['vn' => $value->vn]);
                    } else {
                        # code...
                    }
                    
                    }
                } else {
                    A_stm_ct_item::where('ct_date',$value->vstdate)->where('cid',$value->cid)->update([
                        'ct_check_hos'    => $value->xray_items_name
                    ]);
                    A_stm_ct::where('ct_date',$value->vstdate)->where('cid',$value->cid)->update(['vn' => $value->vn]);
                } 
            }
     
            // return redirect()->route('ct.ct_rep');
        return response()->json([
                'status'    => '200',
            ]);
    }
    public function ct_rep_confirm(Request $request)
    { 
        $id    = $request->vn; 
        //   dd($id);
        // A_stm_ct::where('a_stm_ct_id',$id)->update(['active' => 'Y']); 
        A_ct_scan::where('vn',$id)->update(['active' => 'Y']); 
        return redirect()->route('ct.ct_rep');

        // return response()->json([
        //         'status'    => '200',
        //     ]);
    }
    public function ct_rep_edit(Request $request,$id)
    { 
        $data_ = A_stm_ct::where('a_stm_ct_id',$id)->first();
        $cid         = $data_->cid;
        $ct_date     = $data_->ct_date;
        $data_show = A_stm_ct_item::where('ct_date',$ct_date)->where('cid',$cid)->first();

     
        return response()->json([
            'status'               => '200', 
            'data_show'            =>  $data_show,
        ]);
    }
    public function ct_rep_checksit(Request $request)
    {
        $datestart = $request->datestart;
        $dateend = $request->dateend; 

                $token_data = DB::connection('mysql10')->select('SELECT * FROM nhso_token ORDER BY update_datetime desc limit 1');
                foreach ($token_data as $key => $value) {
                    $cid_    = $value->cid;
                    $token_  = $value->token;
                }
                // $ct_data = DB::connection('mysql')->select('SELECT cid,ct_date FROM a_stm_ct WHERE ct_date BETWEEN "'.$datestart.'" AND "'.$dateend.'"');
                $ct_data = DB::connection('mysql')->select('SELECT cid,request_date FROM a_ct_scan WHERE request_date BETWEEN "'.$datestart.'" AND "'.$dateend.'" AND ptty_spsch IS NULL');
                foreach ($ct_data as $key => $vv) {
                
                        $client = new SoapClient(
                            "http://ucws.nhso.go.th/ucwstokenp1/UCWSTokenP1?wsdl",
                            array("uri" => 'http://ucws.nhso.go.th/ucwstokenp1/UCWSTokenP1?xsd=1', "trace" => 1, "exceptions" => 0, "cache_wsdl" => 0)
                        );
                        $params = array(
                            'sequence' => array(
                                "user_person_id" => "$cid_",
                                "smctoken"       => "$token_",
                                "person_id"      => "$vv->cid"
                            )
                        );
                        $contents = $client->__soapCall('searchCurrentByPID', $params);
                        // dd($contents);
                        //   dd($hcode);
                        foreach ($contents as $v) {
                            @$status                   = $v->status;
                            @$maininscl                = $v->maininscl;  // maininscl": "WEL"
                            @$startdate                = $v->startdate;  //"25650728"
                            @$hmain                    = $v->hmain;   //"11066"
                            @$subinscl                  = $v->subinscl;    //subinscl": "73"
                            @$person_id_nhso           = $v->person_id;
                            if (@$maininscl == 'WEL') {
                                @$cardid                    = $v->cardid;  // "R73450035286038"
                            } else {
                                $cardid = '';
                            } 
                            @$hmain_op                 = $v->hmain_op;  //"10978"
                            @$hmain_op_name            = $v->hmain_op_name;  //"รพ.ภูเขียวเฉลิมพระเกียรติ"
                            @$hsub                     = $v->hsub;    //"04047"
                            @$hsub_name                = $v->hsub_name;   //"รพ.สต.แดงสว่าง"
                            @$subinscl_name            = $v->subinscl_name; //"ช่วงอายุ 12-59 ปี"
                            @$primary_amphur_name      = $v->primary_amphur_name;  // อำเภอ  "โพนทอง"
                            @$primary_moo              = $v->primary_moo;    //หมู่ที่ 01
                            @$primary_mooban_name      = $v->primary_mooban_name;  // ชื่อหมู่บ้าน  "หนองนกแก้ว"
                            @$primary_tumbon_name      = $v->primary_tumbon_name;   //ชื่อตำบล   "สระนกแก้ว"
                            @$primary_province_name    = $v->primary_province_name;  //ชื่อจังหวัด
                        } 
                        IF(@$maininscl == "" || @$maininscl == null || @$status == "003" ){ #ถ้าเป็นค่าว่างไม่ต้อง insert 
                                // A_stm_ct::where('cid', $vv->cid)->where('ct_date', $vv->ct_date)
                                // ->update([
                                //     'ptty_spsch'       => @$subinscl,
                                //     'pttypename_spsch' => @$maininscl,
                                
                                // ]); 
                                // A_ct::where('cid', $vv->cid)->where('vstdate', $vv->vstdate)
                                // ->update([
                                //     'ptty_spsch'       => @$subinscl,
                                //     // 'pttypename_spsch' => @$maininscl,                                
                                // ]);  
                                
                                A_ct_scan::where('cid', $vv->cid)->where('request_date', $vv->request_date)
                                ->update([
                                    'ptty_spsch'       => @$subinscl                                 
                                ]);  
                        }elseif(@$maininscl !="" || @$subinscl !=""){ 
                                // A_stm_ct::where('cid', $vv->cid)->where('ct_date', $vv->ct_date)
                                //     ->update([
                                //         'ptty_spsch'       => @$subinscl,
                                //         'pttypename_spsch' => @$maininscl,
                                       
                                // ]); 
                                // A_ct::where('cid', $vv->cid)->where('vstdate', $vv->vstdate)
                                //     ->update([
                                //         'ptty_spsch'       => @$subinscl, 
                                // ]); 
                                A_ct_scan::where('cid', $vv->cid)->where('request_date', $vv->request_date)
                                ->update([
                                    'ptty_spsch'       => @$subinscl ,                                
                                ]); 
                        }
                }
            // }
        // }
        return response()->json([
            'status'               => '200', 
            // 'data_show'            =>  $data_show,
        ]);
        // return view('rpst.checksit_pullhosauto');

    }



    
 
}
