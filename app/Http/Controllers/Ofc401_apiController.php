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
use App\Models\Book_send_person;
use App\Models\Book_sendteam;
use App\Models\Bookrepdelete;

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
use App\Models\D_ucep24_main;
use App\Models\D_ucep24;
use App\Models\D_claim_db_hipdata_code;
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
use App\Models\D_ofc_rep;
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

class Ofc401_apiController extends Controller
{ 
     
    public function ofc_401_exportapi(Request $request)
    {
        $sss_date_now = date("Y-m-d");
        $sss_time_now = date("H:i:s");

        #ตัดขีด, ตัด : ออก
        $pattern_date = '/-/i';
        $sss_date_now_preg = preg_replace($pattern_date, '', $sss_date_now);
        $pattern_time = '/:/i';
        $sss_time_now_preg = preg_replace($pattern_time, '', $sss_time_now);
        #ตัดขีด, ตัด : ออก

         #delete file in folder ทั้งหมด
        $file = new Filesystem;
        $file->cleanDirectory('Export'); //ทั้งหมด
        // $file->cleanDirectory('UCEP_'.$sss_date_now_preg.'-'.$sss_time_now_preg); 
        $folder='OFC_'.$sss_date_now_preg.'-'.$sss_time_now_preg;

         mkdir ('Export/'.$folder, 0777, true);  //Web
        //  mkdir ('C:Export/'.$folder, 0777, true); //localhost

        header("Content-type: text/txt");
        header("Cache-Control: no-store, no-cache");
        header('Content-Disposition: attachment; filename="content.txt"');

        //1 ins.txt
        $file_d_ins = "Export/".$folder."/INS.txt";
        // $objFopen_ins = fopen($file_d_ins, 'w');
        $objFopen_ins_utf = fopen($file_d_ins, 'w');
        $opd_head = 'HN|INSCL|SUBTYPE|CID|DATEIN|DATEEXP|HOSPMAIN|HOSPSUB|GOVCODE|GOVNAME|PERMITNO|DOCNO|OWNRPID|OWNNAME|AN|SEQ|SUBINSCL|RELINSCL|HTYPE';
        // fwrite($objFopen_ins, $opd_head);
        fwrite($objFopen_ins_utf, $opd_head);
        $ins = DB::connection('mysql')->select('
            SELECT * from d_ins where d_anaconda_id = "OFC_401"
        ');
        foreach ($ins as $key => $value1) {
            $a1 = $value1->HN;
            $a2 = $value1->INSCL;
            $a3 = $value1->SUBTYPE;
            $a4 = $value1->CID;
            $a5 = $value1->DATEIN;
            $a6 = $value1->DATEEXP;
            $a7 = $value1->HOSPMAIN;
            $a8 = $value1->HOSPSUB;
            $a9 = $value1->GOVCODE;
            $a10 = $value1->GOVNAME;
            $a11 = $value1->PERMITNO;
            $a12 = $value1->DOCNO;
            $a13 = $value1->OWNRPID;
            $a14= $value1->OWNRNAME;
            $a15 = $value1->AN;
            $a16= $value1->SEQ;
            $a17= $value1->SUBINSCL;
            $a18 = $value1->RELINSCL;
            $a19 = $value1->HTYPE;
            $str_ins="\n".$a1."|".$a2."|".$a3."|".$a4."|".$a5."|".$a6."|".$a7."|".$a8."|".$a9."|".$a10."|".$a11."|".$a12."|".$a13."|".$a14."|".$a15."|".$a16."|".$a17."|".$a18."|".$a19;
            // $ansitxt_ins = iconv('UTF-8', 'TIS-620', $str_ins);
            $ansitxt_ins_utf = iconv('UTF-8', 'UTF-8', $str_ins);
            // fwrite($objFopen_ins, $ansitxt_ins);
            fwrite($objFopen_ins_utf, $ansitxt_ins_utf);
        }
        // fclose($objFopen_ins);
        fclose($objFopen_ins_utf);
        D_apiofc_ins::truncate();
        $fread_file_ins = fread(fopen($file_d_ins,"r"),filesize($file_d_ins));
        $fread_file_ins_endcode = base64_encode($fread_file_ins);
        $read_file_ins_size = filesize($file_d_ins);

        // dd( $fread_file_ins);
        D_apiofc_ins::insert([
            'blobName'   =>  'INS.txt',
            'blobType'   =>  'text/plain',
            'blob'       =>   $fread_file_ins_endcode,
            'size'       =>   $read_file_ins_size,
            'encoding'   =>  'UTF-8'
        ]);

        //2 pat.txt
        $file_d_pat = "Export/".$folder."/PAT.txt";
        // $objFopen_pat = fopen($file_d_pat, 'w');
        $objFopen_pat_utf = fopen($file_d_pat, 'w');
        $opd_head_pat = 'HCODE|HN|CHANGWAT|AMPHUR|DOB|SEX|MARRIAGE|OCCUPA|NATION|PERSON_ID|NAMEPAT|TITLE|FNAME|LNAME|IDTYPE';
        // fwrite($objFopen_pat, $opd_head_pat);
        fwrite($objFopen_pat_utf, $opd_head_pat);
        $pat = DB::connection('mysql')->select('
            SELECT * from d_pat where d_anaconda_id = "OFC_401"
        ');
        foreach ($pat as $key => $value9) {
            $i1 = $value9->HCODE;
            $i2 = $value9->HN;
            $i3 = $value9->CHANGWAT;
            $i4 = $value9->AMPHUR;
            $i5 = $value9->DOB;
            $i6 = $value9->SEX;
            $i7 = $value9->MARRIAGE;
            $i8 = $value9->OCCUPA;
            $i9 = $value9->NATION;
            $i10 = $value9->PERSON_ID;
            $i11 = $value9->NAMEPAT;
            $i12 = $value9->TITLE;
            $i13 = $value9->FNAME;
            $i14 = $value9->LNAME;
            $i15 = $value9->IDTYPE;      
            $str_pat="\n".$i1."|".$i2."|".$i3."|".$i4."|".$i5."|".$i6."|".$i7."|".$i8."|".$i9."|".$i10."|".$i11."|".$i12."|".$i13."|".$i14."|".$i15;
            // $ansitxt_pat = iconv('UTF-8', 'TIS-620', $str_pat);
            $ansitxt_pat_utf = iconv('UTF-8', 'UTF-8', $str_pat);
            // fwrite($objFopen_pat, $ansitxt_pat);
            fwrite($objFopen_pat_utf, $ansitxt_pat_utf);
        }
        // fclose($objFopen_pat);
        fclose($objFopen_pat_utf);
        D_apiofc_pat::truncate();
        $fread_file_pat = fread(fopen($file_d_pat,"r"),filesize($file_d_pat));
        $fread_file_pat_endcode = base64_encode($fread_file_pat);
        $read_file_pat_size = filesize($file_d_pat);
        D_apiofc_pat::insert([
            'blobName'   =>  'PAT.txt',
            'blobType'   =>  'text/plain',
            'blob'       =>   $fread_file_pat_endcode,
            'size'       =>   $read_file_pat_size,
            'encoding'   =>  'UTF-8'
        ]);

        //3 opd.txt
        $file_d_opd = "Export/".$folder."/OPD.txt";
        // $objFopen_opd = fopen($file_d_opd, 'w');
        $objFopen_opd_utf = fopen($file_d_opd, 'w');
        $opd_head_opd = 'HN|CLINIC|DATEOPD|TIMEOPD|SEQ|UUC|DETAIL|BTEMP|SBP|DBP|PR|RR|OPTYPE|TYPEIN|TYPEOUT';
        // fwrite($objFopen_opd, $opd_head_opd);
        fwrite($objFopen_opd_utf, $opd_head_opd);
        $opd = DB::connection('mysql')->select('
            SELECT * from d_opd where d_anaconda_id = "OFC_401"
        ');
        foreach ($opd as $key => $value15) {
            $o1 = $value15->HN;
            $o2 = $value15->CLINIC;
            $o3 = $value15->DATEOPD; 
            $o4 = $value15->TIMEOPD; 
            $o5 = $value15->SEQ; 
            $o6 = $value15->UUC;  
            $str_opd="\n".$o1."|".$o2."|".$o3."|".$o4."|".$o5."|".$o6;
            // $ansitxt_opd = iconv('UTF-8', 'TIS-620', $str_opd);
            $ansitxt_opd_utf = iconv('UTF-8', 'UTF-8', $str_opd);
            // fwrite($objFopen_opd, $ansitxt_opd);
            fwrite($objFopen_opd_utf, $ansitxt_opd_utf);
        }
        // fclose($objFopen_opd);
        fclose($objFopen_opd_utf);
        D_apiofc_opd::truncate();
        $fread_file_opd = fread(fopen($file_d_opd,"r"),filesize($file_d_opd));
        $fread_file_opd_endcode = base64_encode($fread_file_opd);
        $read_file_opd_size = filesize($file_d_opd);
        D_apiofc_opd::insert([
            'blobName'   =>  'OPD.txt',
            'blobType'   =>  'text/plain',
            'blob'       =>   $fread_file_opd_endcode,
            'size'       =>   $read_file_opd_size,
            'encoding'   =>  'UTF-8'
        ]);

        //4 orf.txt
        $file_d_orf = "Export/".$folder."/ORF.txt";
        // $objFopen_orf = fopen($file_d_orf, 'w');
        $objFopen_orf_utf = fopen($file_d_orf, 'w');
        $opd_head_orf = 'HN|DATEOPD|CLINIC|REFER|REFERTYPE|SEQ';
        // fwrite($objFopen_orf, $opd_head_orf);
        fwrite($objFopen_orf_utf, $opd_head_orf);
        $orf = DB::connection('mysql')->select('
            SELECT * from d_orf where d_anaconda_id = "OFC_401"
        ');
        foreach ($orf as $key => $value16) {
            $p1 = $value16->HN;
            $p2 = $value16->DATEOPD;
            $p3 = $value16->CLINIC; 
            $p4 = $value16->REFER; 
            $p5 = $value16->REFERTYPE; 
            $p6 = $value16->SEQ;  
            $str_orf="\n".$p1."|".$p2."|".$p3."|".$p4."|".$p5."|".$p6;
            // $ansitxt_orf = iconv('UTF-8', 'TIS-620', $str_orf);
            $ansitxt_orf_utf = iconv('UTF-8', 'UTF-8', $str_orf);
            // fwrite($objFopen_orf, $ansitxt_orf);
            fwrite($objFopen_orf_utf, $ansitxt_orf_utf);
        }
        // fclose($objFopen_orf);
        fclose($objFopen_orf_utf);
        D_apiofc_orf::truncate();
        $fread_file_orf = fread(fopen($file_d_orf,"r"),filesize($file_d_orf));
        $fread_file_orf_endcode = base64_encode($fread_file_orf);
        $read_file_orf_size = filesize($file_d_orf);
        D_apiofc_orf::insert([
            'blobName'   =>  'ORF.txt',
            'blobType'   =>  'text/plain',
            'blob'       =>   $fread_file_orf_endcode,
            'size'       =>   $read_file_orf_size,
            'encoding'   =>  'UTF-8'
        ]);

        //5 odx.txt
        $file_d_odx = "Export/".$folder."/ODX.txt";
        // $objFopen_odx = fopen($file_d_odx, 'w');
        $objFopen_odx_utf = fopen($file_d_odx, 'w');
        $opd_head_odx = 'HN|DATEDX|CLINIC|DIAG|DXTYPE|DRDX|PERSON_ID|SEQ';
        // fwrite($objFopen_odx, $opd_head_odx);
        fwrite($objFopen_odx_utf, $opd_head_odx);
        $odx = DB::connection('mysql')->select('
            SELECT * from d_odx where d_anaconda_id = "OFC_401"
        ');
        foreach ($odx as $key => $value13) {
            $m1 = $value13->HN;
            $m2 = $value13->DATEDX;
            $m3 = $value13->CLINIC; 
            $m4 = $value13->DIAG; 
            $m5 = $value13->DXTYPE; 
            $m6 = $value13->DRDX; 
            $m7 = $value13->PERSON_ID; 
            $m8 = $value13->SEQ; 
            $str_odx="\n".$m1."|".$m2."|".$m3."|".$m4."|".$m5."|".$m6."|".$m7."|".$m8;
            // $ansitxt_odx = iconv('UTF-8', 'TIS-620', $str_odx);
            $ansitxt_odx_utf = iconv('UTF-8', 'UTF-8', $str_odx);
            // fwrite($objFopen_odx, $ansitxt_odx);
            fwrite($objFopen_odx_utf, $ansitxt_odx_utf);
        }
        // fclose($objFopen_odx);
        fclose($objFopen_odx_utf);
        D_apiofc_odx::truncate();
        $fread_file_odx = fread(fopen($file_d_odx,"r"),filesize($file_d_odx));
        $fread_file_odx_endcode = base64_encode($fread_file_odx);
        $read_file_odx_size = filesize($file_d_odx);
        D_apiofc_odx::insert([
            'blobName'   =>  'ODX.txt',
            'blobType'   =>  'text/plain',
            'blob'       =>   $fread_file_odx_endcode,
            'size'       =>   $read_file_odx_size,
            'encoding'   =>  'UTF-8'
        ]);

        //6 oop.txt
        $file_d_oop = "Export/".$folder."/OOP.txt";
        // $objFopen_oop = fopen($file_d_oop, 'w');
        $objFopen_oop_utf = fopen($file_d_oop, 'w');
        $opd_head_oop = 'HN|DATEOPD|CLINIC|OPER|DROPID|PERSON_ID|SEQ';
        // fwrite($objFopen_oop, $opd_head_oop);
        fwrite($objFopen_oop_utf, $opd_head_oop);
        $oop = DB::connection('mysql')->select('
            SELECT * from d_oop where d_anaconda_id = "OFC_401"
        ');
        foreach ($oop as $key => $value14) {
            $n1 = $value14->HN;
            $n2 = $value14->DATEOPD;
            $n3 = $value14->CLINIC; 
            $n4 = $value14->OPER; 
            $n5 = $value14->DROPID; 
            $n6 = $value14->PERSON_ID; 
            $n7 = $value14->SEQ;  
            $str_oop="\n".$n1."|".$n2."|".$n3."|".$n4."|".$n5."|".$n6."|".$n7;
            // $ansitxt_oop = iconv('UTF-8', 'TIS-620', $str_oop);
            $ansitxt_oop_utf = iconv('UTF-8', 'UTF-8', $str_oop);
            // fwrite($objFopen_oop, $ansitxt_oop);
            fwrite($objFopen_oop_utf, $ansitxt_oop_utf);
        }
        // fclose($objFopen_oop);
        fclose($objFopen_oop_utf);
        D_apiofc_oop::truncate();
        $fread_file_oop = fread(fopen($file_d_oop,"r"),filesize($file_d_oop));
        $fread_file_oop_endcode = base64_encode($fread_file_oop);
        $read_file_oop_size = filesize($file_d_oop);
        D_apiofc_oop::insert([
            'blobName'   =>  'OOP.txt',
            'blobType'   =>  'text/plain',
            'blob'       =>   $fread_file_oop_endcode,
            'size'       =>   $read_file_oop_size,
            'encoding'   =>  'UTF-8'
        ]);

        //7 ipd.txt
        $file_d_ipd = "Export/".$folder."/IPD.txt";
        // $objFopen_ipd = fopen($file_d_ipd, 'w');
        $objFopen_ipd_utf = fopen($file_d_ipd, 'w');
        $opd_head_ipd = 'HN|AN|DATEADM|TIMEADM|DATEDSC|TIMEDSC|DISCHS|DISCHT|WARDDSC|DEPT|ADM_W|UUC|SVCTYPE';
        // fwrite($objFopen_ipd, $opd_head_ipd);
        fwrite($objFopen_ipd_utf, $opd_head_ipd);
        $ipd = DB::connection('mysql')->select('
            SELECT * from d_ipd where d_anaconda_id = "OFC_401"
        ');
        foreach ($ipd as $key => $value10) {
            $j1 = $value10->HN;
            $j2 = $value10->AN;
            $j3 = $value10->DATEADM;
            $j4 = $value10->TIMEADM;
            $j5 = $value10->DATEDSC;
            $j6 = $value10->TIMEDSC;
            $j7 = $value10->DISCHS;
            $j8 = $value10->DISCHT;
            $j9 = $value10->WARDDSC;
            $j10 = $value10->DEPT;
            $j11 = $value10->ADM_W;
            $j12 = $value10->UUC;
            $j13 = $value10->SVCTYPE;    
            $str_ipd="\n".$j1."|".$j2."|".$j3."|".$j4."|".$j5."|".$j6."|".$j7."|".$j8."|".$j9."|".$j10."|".$j11."|".$j12."|".$j13;
            // $ansitxt_ipd = iconv('UTF-8', 'TIS-620', $str_ipd);
            $ansitxt_ipd_utf = iconv('UTF-8', 'UTF-8', $str_ipd);
            // fwrite($objFopen_ipd, $ansitxt_ipd);
            fwrite($objFopen_ipd_utf, $ansitxt_ipd_utf);
        }
        // fclose($objFopen_ipd);
        fclose($objFopen_ipd_utf);
        D_apiofc_ipd::truncate();
        $fread_file_ipd = fread(fopen($file_d_ipd,"r"),filesize($file_d_ipd));
        $fread_file_ipd_endcode = base64_encode($fread_file_ipd);
        $read_file_ipd_size = filesize($file_d_ipd);
        D_apiofc_ipd::insert([
            'blobName'   =>  'IPD.txt',
            'blobType'   =>  'text/plain',
            'blob'       =>   $fread_file_ipd_endcode,
            'size'       =>   $read_file_ipd_size,
            'encoding'   =>  'UTF-8'
        ]);

        //8 irf.txt
        $file_d_irf = "Export/".$folder."/IRF.txt";
        // $objFopen_irf = fopen($file_d_irf, 'w');
        $objFopen_irf_utf = fopen($file_d_irf, 'w');
        $opd_head_irf = 'AN|REFER|REFERTYPE';
        // fwrite($objFopen_irf, $opd_head_irf);
        fwrite($objFopen_irf_utf, $opd_head_irf);
        $irf = DB::connection('mysql')->select('
            SELECT * from d_irf where d_anaconda_id = "OFC_401"
        ');
        foreach ($irf as $key => $value11) {
            $k1 = $value11->AN;
            $k2 = $value11->REFER;
            $k3 = $value11->REFERTYPE; 
            $str_irf="\n".$k1."|".$k2."|".$k3;
            // $ansitxt_irf = iconv('UTF-8', 'TIS-620', $str_irf);
            $ansitxt_irf_utf = iconv('UTF-8', 'UTF-8', $str_irf);
            // fwrite($objFopen_irf, $ansitxt_irf);
            fwrite($objFopen_irf_utf, $ansitxt_irf_utf);
        }
        // fclose($objFopen_irf);
        fclose($objFopen_irf_utf);
        D_apiofc_irf::truncate();
        $fread_file_irf = fread(fopen($file_d_irf,"r"),filesize($file_d_irf));
        $fread_file_irf_endcode = base64_encode($fread_file_irf);
        $read_file_irf_size = filesize($file_d_irf);
        D_apiofc_irf::insert([
            'blobName'   =>  'IRF.txt',
            'blobType'   =>  'text/plain',
            'blob'       =>   $fread_file_irf_endcode,
            'size'       =>   $read_file_irf_size,
            'encoding'   =>  'UTF-8'
        ]);

        //9 idx.txt
        $file_d_idx = "Export/".$folder."/IDX.txt";
        // $objFopen_idx = fopen($file_d_idx, 'w');
        $objFopen_idx_utf = fopen($file_d_idx, 'w');
        $opd_head_idx = 'AN|DIAG|DXTYPE|DRDX';
        // fwrite($objFopen_idx, $opd_head_idx);
        fwrite($objFopen_idx_utf, $opd_head_idx);
        $idx = DB::connection('mysql')->select('
            SELECT * from d_idx where d_anaconda_id = "OFC_401"
        ');
        foreach ($idx as $key => $value8) {
            $h1 = $value8->AN;
            $h2 = $value8->DIAG;
            $h3 = $value8->DXTYPE;
            $h4 = $value8->DRDX; 
            $str_idx="\n".$h1."|".$h2."|".$h3."|".$h4;
            // $ansitxt_idx = iconv('UTF-8', 'TIS-620', $str_idx);
            $ansitxt_idx_utf = iconv('UTF-8', 'UTF-8', $str_idx);
            // fwrite($objFopen_idx, $ansitxt_idx);
            fwrite($objFopen_idx_utf, $ansitxt_idx_utf);
        }
        // fclose($objFopen_idx);
        fclose($objFopen_idx_utf);
        D_apiofc_idx::truncate();
        $fread_file_idx = fread(fopen($file_d_idx,"r"),filesize($file_d_idx));
        $fread_file_idx_endcode = base64_encode($fread_file_idx);
        $read_file_idx_size = filesize($file_d_idx);
        D_apiofc_idx::insert([
            'blobName'   =>  'IDX.txt',
            'blobType'   =>  'text/plain',
            'blob'       =>   $fread_file_idx_endcode,
            'size'       =>   $read_file_idx_size,
            'encoding'   =>  'UTF-8'
        ]);
                   
        //10 iop.txt
        $file_d_iop = "Export/".$folder."/IOP.txt";
        // $objFopen_iop = fopen($file_d_iop, 'w');
        $objFopen_iop_utf = fopen($file_d_iop, 'w');
        $opd_head_iop = 'AN|OPER|OPTYPE|DROPID|DATEIN|TIMEIN|DATEOUT|TIMEOUT';
        // fwrite($objFopen_iop, $opd_head_iop);
        fwrite($objFopen_iop_utf, $opd_head_iop);
        $iop = DB::connection('mysql')->select('
            SELECT * from d_iop where d_anaconda_id = "OFC_401"
        ');
        foreach ($iop as $key => $value2) {
            $b1 = $value2->AN;
            $b2 = $value2->OPER;
            $b3 = $value2->OPTYPE;
            $b4 = $value2->DROPID;
            $b5 = $value2->DATEIN;
            $b6 = $value2->TIMEIN;
            $b7 = $value2->DATEOUT;
            $b8 = $value2->TIMEOUT;
           
            $str_iop="\n".$b1."|".$b2."|".$b3."|".$b4."|".$b5."|".$b6."|".$b7."|".$b8;
            // $ansitxt_iop = iconv('UTF-8', 'TIS-620', $str_iop);
            $ansitxt_iop_utf = iconv('UTF-8', 'UTF-8', $str_iop);
            // fwrite($objFopen_iop, $ansitxt_iop);
            fwrite($objFopen_iop_utf, $ansitxt_iop_utf);
        }
        // fclose($objFopen_iop);
        fclose($objFopen_iop_utf);
        D_apiofc_iop::truncate();
        $fread_file_iop = fread(fopen($file_d_iop,"r"),filesize($file_d_iop));
        $fread_file_iop_endcode = base64_encode($fread_file_iop);
        $read_file_iop_size = filesize($file_d_iop);
        D_apiofc_iop::insert([
            'blobName'   =>  'IOP.txt',
            'blobType'   =>  'text/plain',
            'blob'       =>   $fread_file_iop_endcode,
            'size'       =>   $read_file_iop_size,
            'encoding'   =>  'UTF-8'
        ]);

        //11 cht.txt
        $file_d_cht = "Export/".$folder."/CHT.txt";
        // $objFopen_cht = fopen($file_d_cht, 'w');
        $objFopen_cht_utf = fopen($file_d_cht, 'w');
        $opd_head_cht = 'HN|AN|DATE|TOTAL|PAID|PTTYPE|PERSON_ID|SEQ';
        // fwrite($objFopen_cht, $opd_head_cht);
        fwrite($objFopen_cht_utf, $opd_head_cht);
        $cht = DB::connection('mysql')->select('
            SELECT * from d_cht where d_anaconda_id = "OFC_401"
        ');
        foreach ($cht as $key => $value6) {
            $f1 = $value6->HN;
            $f2 = $value6->AN;
            $f3 = $value6->DATE;
            $f4 = $value6->TOTAL;
            $f5 = $value6->PAID;
            $f6 = $value6->PTTYPE;
            $f7 = $value6->PERSON_ID; 
            $f8 = $value6->SEQ;
            $str_cht="\n".$f1."|".$f2."|".$f3."|".$f4."|".$f5."|".$f6."|".$f7."|".$f8;
            // $ansitxt_cht = iconv('UTF-8', 'TIS-620', $str_cht);
            $ansitxt_cht_utf = iconv('UTF-8', 'UTF-8', $str_cht);
            // fwrite($objFopen_cht, $ansitxt_cht);
            fwrite($objFopen_cht_utf, $ansitxt_cht_utf);
        }
        // fclose($objFopen_cht);
        fclose($objFopen_cht_utf);
        D_apiofc_cht::truncate();
        $fread_file_cht = fread(fopen($file_d_cht,"r"),filesize($file_d_cht));
        $fread_file_cht_endcode = base64_encode($fread_file_cht);
        $read_file_cht_size = filesize($file_d_cht);
        D_apiofc_cht::insert([
            'blobName'   =>  'CHT.txt',
            'blobType'   =>  'text/plain',
            'blob'       =>   $fread_file_cht_endcode,
            'size'       =>   $read_file_cht_size,
            'encoding'   =>  'UTF-8'
        ]);
               
        //12 cha.txt
        $file_d_cha = "Export/".$folder."/CHA.txt";
        // $objFopen_cha = fopen($file_d_cha, 'w');
        $objFopen_cha_utf = fopen($file_d_cha, 'w');
        $opd_head_cha = 'HN|AN|DATE|CHRGITEM|AMOUNT|PERSON_ID|SEQ';
        // fwrite($objFopen_cha, $opd_head_cha);
        fwrite($objFopen_cha_utf, $opd_head_cha);
        $cha = DB::connection('mysql')->select('
            SELECT * from d_cha where d_anaconda_id = "OFC_401"
        ');
        foreach ($cha as $key => $value5) {
            $e1 = $value5->HN;
            $e2 = $value5->AN;
            $e3 = $value5->DATE;
            $e4 = $value5->CHRGITEM;
            $e5 = $value5->AMOUNT;
            $e6 = $value5->PERSON_ID;
            $e7 = $value5->SEQ; 
            $str_cha="\n".$e1."|".$e2."|".$e3."|".$e4."|".$e5."|".$e6."|".$e7;
            // $ansitxt_cha = iconv('UTF-8', 'TIS-620', $str_cha);
            $ansitxt_cha_utf = iconv('UTF-8', 'UTF-8', $str_cha);
            // fwrite($objFopen_cha, $ansitxt_cha);
            fwrite($objFopen_cha_utf, $ansitxt_cha_utf);
        }
        // fclose($objFopen_cha);
        fclose($objFopen_cha_utf);
        D_apiofc_cha::truncate();
        $fread_file_cha = fread(fopen($file_d_cha,"r"),filesize($file_d_cha));
        $fread_file_cha_endcode = base64_encode($fread_file_cha);
        $read_file_cha_size = filesize($file_d_cha);
        D_apiofc_cha::insert([
            'blobName'   =>  'CHA.txt',
            'blobType'   =>  'text/plain',
            'blob'       =>   $fread_file_cha_endcode,
            'size'       =>   $read_file_cha_size,
            'encoding'   =>  'UTF-8'
        ]);

         //13 aer.txt
         $file_d_aer = "Export/".$folder."/AER.txt";
        //  $objFopen_aer = fopen($file_d_aer, 'w');
         $objFopen_aer_utf = fopen($file_d_aer, 'w');
         $opd_head_aer = 'HN|AN|DATEOPD|AUTHAE|AEDATE|AETIME|AETYPE|REFER_NO|REFMAINI|IREFTYPE|REFMAINO|OREFTYPE|UCAE|EMTYPE|SEQ|AESTATUS|DALERT|TALERT';
        //  fwrite($objFopen_aer, $opd_head_aer);
        fwrite($objFopen_aer_utf, $opd_head_aer);
        $aer = DB::connection('mysql')->select('
             SELECT * from d_aer where d_anaconda_id = "OFC_401"
         ');
         foreach ($aer as $key => $value4) {
             $d1 = $value4->HN;
             $d2 = $value4->AN;
             $d3 = $value4->DATEOPD;
             $d4 = $value4->AUTHAE;
             $d5 = $value4->AEDATE;
             $d6 = $value4->AETIME;
             $d7 = $value4->AETYPE;
             $d8 = $value4->REFER_NO;
             $d9 = $value4->REFMAINI;
             $d10 = $value4->IREFTYPE;
             $d11 = $value4->REFMAINO;
             $d12 = $value4->OREFTYPE;
             $d13 = $value4->UCAE;
             $d14 = $value4->EMTYPE;
             $d15 = $value4->SEQ;
             $d16 = $value4->AESTATUS;
             $d17 = $value4->DALERT;
             $d18 = $value4->TALERT;        
             $str_aer="\n".$d1."|".$d2."|".$d3."|".$d4."|".$d5."|".$d6."|".$d7."|".$d8."|".$d9."|".$d10."|".$d11."|".$d12."|".$d13."|".$d14."|".$d15."|".$d16."|".$d17."|".$d18;
            //  $ansitxt_aer = iconv('UTF-8', 'TIS-620', $str_aer);
             $ansitxt_aer_utf = iconv('UTF-8', 'UTF-8', $str_aer);
            //  fwrite($objFopen_aer, $ansitxt_aer);
             fwrite($objFopen_aer_utf, $ansitxt_aer_utf);
         }
        //  fclose($objFopen_aer);
         fclose($objFopen_aer_utf);
         D_apiofc_aer::truncate();
         $fread_file_aer = fread(fopen($file_d_aer,"r"),filesize($file_d_aer));
         $fread_file_aer_endcode = base64_encode($fread_file_aer);
         $read_file_aer_size = filesize($file_d_aer);
         D_apiofc_aer::insert([
             'blobName'   =>  'AER.txt',
             'blobType'   =>  'text/plain',
             'blob'       =>   $fread_file_aer_endcode,
             'size'       =>   $read_file_aer_size,
             'encoding'   =>  'UTF-8'
         ]);
                   
        //14 adp.txt
        $file_d_adp = "Export/".$folder."/ADP.txt";
        // $objFopen_adp = fopen($file_d_adp, 'w');
        $objFopen_adp_utf = fopen($file_d_adp, 'w');
        $opd_head_adp = 'HN|AN|DATEOPD|TYPE|CODE|QTY|RATE|SEQ|CAGCODE|DOSE|CA_TYPE|SERIALNO|TOTCOPAY|USE_STATUS|TOTAL|QTYDAY|TMLTCODE|STATUS1|BI|CLINIC|ITEMSRC|PROVIDER|GRAVIDA|GA_WEEK|DCIP|LMP|SP_ITEM';
        // fwrite($objFopen_adp, $opd_head_adp);
        fwrite($objFopen_adp_utf, $opd_head_adp);
        $adp = DB::connection('mysql')->select('
            SELECT * from d_adp where d_anaconda_id = "OFC_401"
        ');
        foreach ($adp as $key => $value3) {
            $c1 = $value3->HN;
            $c2 = $value3->AN;
            $c3 = $value3->DATEOPD;
            $c4 = $value3->TYPE;
            $c5 = $value3->CODE;
            $c6 = $value3->QTY;
            $c7 = $value3->RATE;
            $c8 = $value3->SEQ;
            $c9 = $value3->CAGCODE;
            $c10 = $value3->DOSE;
            $c11 = $value3->CA_TYPE;
            $c12 = $value3->SERIALNO;
            $c13 = $value3->TOTCOPAY;
            $c14 = $value3->USE_STATUS;
            $c15 = $value3->TOTAL;
            $c16 = $value3->QTYDAY;
            $c17 = $value3->TMLTCODE;
            $c18 = $value3->STATUS1;
            $c19 = $value3->BI;
            $c20 = $value3->CLINIC;
            $c21 = $value3->ITEMSRC;
            $c22 = $value3->PROVIDER;
            $c23 = $value3->GRAVIDA;
            $c24 = $value3->GA_WEEK;
            $c25 = $value3->DCIP;
            $c26 = $value3->LMP;
            $c27 = $value3->SP_ITEM;           
            $str_adp="\n".$c1."|".$c2."|".$c3."|".$c4."|".$c5."|".$c6."|".$c7."|".$c8."|".$c9."|".$c10."|".$c11."|".$c12."|".$c13."|".$c14."|".$c15."|".$c16."|".$c17."|".$c18."|".$c19."|".$c20."|".$c21."|".$c22."|".$c23."|".$c24."|".$c25."|".$c26."|".$c27;
            // $ansitxt_adp = iconv('UTF-8', 'TIS-620', $str_adp);
            $ansitxt_adp_utf = iconv('UTF-8', 'UTF-8', $str_adp);
            // fwrite($objFopen_adp, $ansitxt_adp);
            fwrite($objFopen_adp_utf, $ansitxt_adp_utf);
        }
        // fclose($objFopen_adp);
        fclose($objFopen_adp_utf);
        D_apiofc_adp::truncate();
        $fread_file_adp = fread(fopen($file_d_adp,"r"),filesize($file_d_adp));
        $fread_file_adp_endcode = base64_encode($fread_file_adp);
        $read_file_adp_size = filesize($file_d_adp);
        D_apiofc_adp::insert([
            'blobName'   =>  'ADP.txt',
            'blobType'   =>  'text/plain',
            'blob'       =>   $fread_file_adp_endcode,
            'size'       =>   $read_file_adp_size,
            'encoding'   =>  'UTF-8'
        ]);
        
         //15 lvd.txt
         $file_d_lvd = "Export/".$folder."/LVD.txt";
        //  $objFopen_lvd = fopen($file_d_lvd, 'w');
         $objFopen_lvd_utf = fopen($file_d_lvd, 'w');
         $opd_head_lvd = 'SEQLVD|AN|DATEOUT|TIMEOUT|DATEIN|TIMEIN|QTYDAY';
        //  fwrite($objFopen_lvd, $opd_head_lvd);
         fwrite($objFopen_lvd_utf, $opd_head_lvd);
         $lvd = DB::connection('mysql')->select('
             SELECT * from d_lvd where d_anaconda_id = "OFC_401"
         ');
         foreach ($lvd as $key => $value12) {
             $L1 = $value12->SEQLVD;
             $L2 = $value12->AN;
             $L3 = $value12->DATEOUT; 
             $L4 = $value12->TIMEOUT; 
             $L5 = $value12->DATEIN; 
             $L6 = $value12->TIMEIN; 
             $L7 = $value12->QTYDAY; 
             $str_lvd="\n".$L1."|".$L2."|".$L3."|".$L4."|".$L5."|".$L6."|".$L7;
            //  $ansitxt_lvd = iconv('UTF-8', 'TIS-620', $str_lvd);
             $ansitxt_lvd_utf = iconv('UTF-8', 'UTF-8', $str_lvd);
            //  fwrite($objFopen_lvd, $ansitxt_lvd);
             fwrite($objFopen_lvd_utf, $ansitxt_lvd_utf);
         }
        //  fclose($objFopen_lvd);
         fclose($objFopen_lvd_utf);
         D_apiofc_ldv::truncate();
         $fread_file_lvd = fread(fopen($file_d_lvd,"r"),filesize($file_d_lvd));
         $fread_file_lvd_endcode = base64_encode($fread_file_lvd);
         $read_file_lvd_size = filesize($file_d_lvd);
         D_apiofc_ldv::insert([
             'blobName'   =>  'LDV.txt',
             'blobType'   =>  'text/plain',
             'blob'       =>   $fread_file_lvd_endcode,
             'size'       =>   $read_file_lvd_size,
             'encoding'   =>  'UTF-8'
         ]);
 
        
        //16 dru.txt
        $file_d_dru = "Export/".$folder."/DRU.txt";
        // $objFopen_dru = fopen($file_d_dru, 'w');
        $objFopen_dru_utf = fopen($file_d_dru, 'w');
        $opd_head_dru = 'HCODE|HN|AN|CLINIC|PERSON_ID|DATE_SERV|DID|DIDNAME|AMOUNT|DRUGPRIC|DRUGCOST|DIDSTD|UNIT|UNIT_PACK|SEQ|DRUGREMARK|PA_NO|TOTCOPAY|USE_STATUS|TOTAL|SIGCODE|SIGTEXT|PROVIDER|SP_ITEM';
        // fwrite($objFopen_dru, $opd_head_dru);
        fwrite($objFopen_dru_utf, $opd_head_dru);
        $dru = DB::connection('mysql')->select('
            SELECT * from d_dru where d_anaconda_id = "UCEP24"
        ');
        foreach ($dru as $key => $value7) {
            $g1 = $value7->HCODE;
            $g2 = $value7->HN;
            $g3 = $value7->AN;
            $g4 = $value7->CLINIC;
            $g5 = $value7->PERSON_ID;
            $g6 = $value7->DATE_SERV;
            $g7 = $value7->DID;
            $g8 = $value7->DIDNAME;
            $g9 = $value7->AMOUNT;
            $g10 = $value7->DRUGPRIC;
            $g11 = $value7->DRUGCOST;
            $g12 = $value7->DIDSTD;
            $g13 = $value7->UNIT;
            $g14 = $value7->UNIT_PACK;
            $g15 = $value7->SEQ;
            // $g16 = $value7->DRUGTYPE;
            $g17 = $value7->DRUGREMARK;
            $g18 = $value7->PA_NO;
            $g19 = $value7->TOTCOPAY;
            $g20 = $value7->USE_STATUS;
            $g21 = $value7->TOTAL;
            $g22 = $value7->SIGCODE;
            $g23 = $value7->SIGTEXT;  
            $g24 = $value7->PROVIDER; 
            $g25 = $value7->SP_ITEM;      
            $str_dru="\n".$g1."|".$g2."|".$g3."|".$g4."|".$g5."|".$g6."|".$g7."|".$g8."|".$g9."|".$g10."|".$g11."|".$g12."|".$g13."|".$g14."|".$g15."|".$g17."|".$g18."|".$g19."|".$g20."|".$g21."|".$g22."|".$g23."|".$g24."|".$g25;
            // $ansitxt_dru = iconv('UTF-8', 'TIS-620', $str_dru);
            $ansitxt_dru_utf = iconv('UTF-8', 'UTF-8', $str_dru);
            // fwrite($objFopen_dru, $ansitxt_dru);
            fwrite($objFopen_dru_utf, $ansitxt_dru_utf);
        }



        // fclose($objFopen_dru);
        fclose($objFopen_dru_utf);
        D_apiofc_dru::truncate();
        $fread_file_dru = fread(fopen($file_d_dru,"r"),filesize($file_d_dru));
        $fread_file_dru_endcode = base64_encode($fread_file_dru);
        $read_file_dru_size = filesize($file_d_dru);
        D_apiofc_dru::insert([
            'blobName'   =>  'DRU.txt',
            'blobType'   =>  'text/plain',
            'blob'       =>   $fread_file_dru_endcode,
            'size'       =>   $read_file_dru_size,
            'encoding'   =>  'UTF-8'
        ]);

         //17 lab.txt
         $file_d_lab = "Export/".$folder."/LAB.txt";
         $objFopen_lab = fopen($file_d_lab, 'w');
         $opd_head_lab = 'HCODE|HN|PERSON_ID|DATESERV|SEQ|LABTEST|LABRESULT';
         fwrite($objFopen_lab, $opd_head_lab);
         fclose($objFopen_lab);
 
        //  ZIP ********************************
            // $pathdir =  "Export/".$folder."/";
            // $zipcreated = $folder.".zip";
            // $newzip = new ZipArchive;
            // if($newzip -> open($zipcreated, ZipArchive::CREATE ) === TRUE) {
            // $dir = opendir($pathdir);        
            // while($file = readdir($dir)) {
            //     if(is_file($pathdir.$file)) {
            //         $newzip -> addFile($pathdir.$file, $file);
            //     }
            // }
            // $newzip ->close();
            //         if (file_exists($zipcreated)) {
            //             header('Content-Type: application/zip');
            //             header('Content-Disposition: attachment; filename="'.basename($zipcreated).'"');
            //             header('Content-Length: ' . filesize($zipcreated));
            //             flush();
            //             readfile($zipcreated); 
            //             unlink($zipcreated);   
            //             $files = glob($pathdir . '/*');   
            //             foreach($files as $file) {   
            //                 if(is_file($file)) {      
            //                     // unlink($file); 
            //                 } 
            //             }                      
            //             return redirect()->route('claim.ofc_401');                    
            //         }
            // } 

            // return redirect()->route('claim.ofc_401');
            return response()->json([
                'status'    => '200'
            ]);
    }
  
    public function ofc_401_sendapi(Request $request)
    {  
        $iduser = Auth::user()->id;
        $data_token_ = DB::connection('mysql')->select(' SELECT * FROM api_neweclaim WHERE user_id = "'.$iduser.'"');  
        foreach ($data_token_ as $key => $val_to) {
            $username     = $val_to->api_neweclaim_user;
            $password     = $val_to->api_neweclaim_pass;
            $token        = $val_to->api_neweclaim_token;
        } 
        // dd($token);
          
        $data_table = array("d_apiofc_ins","d_apiofc_pat","d_apiofc_opd","d_apiofc_orf","d_apiofc_odx","d_apiofc_oop","d_apiofc_ipd","d_apiofc_irf","d_apiofc_idx","d_apiofc_iop","d_apiofc_cht","d_apiofc_cha","d_apiofc_aer","d_apiofc_adp","d_apiofc_ldv","d_apiofc_dru");
        // $data_table = array("ins","pat","opd","orf","odx","oop","ipd","irf","idx","iop","cht","cha","aer","adp","lvd","dru");
        foreach ($data_table as $key => $val_t) {        
                $data_all_ = DB::connection('mysql')->select('
                SELECT * FROM '.$val_t.'
                ');                
                foreach ($data_all_ as $val_field) {
                    $blob[] = $val_field->blob;
                    $size[] = $val_field->size;
                     
                 }     
            }
 
            // dd($blob[5]);
            $fame_send = curl_init();
            $postData_send = [
                "fileType" => "txt",
                "maininscl" => "OFC",
                "importDup" => true, //นำเข้าซ้ำ กรณีพบข้อมูลยังไม่ส่งเบิกชดเชย 
                "assignToMe" => true,  //กำหนดข้อมูลให้แสดงผลเฉพาะผู้นำเข้าเท่านั้น
                "dataTypes" => ["OP","IP"],
                "opRefer" => false, 
                    "file" => [ 
                        "ins" => [
                            "blobName"  => "INS.txt",
                            "blobType"  => "text/plain",
                            "blob"      => $blob[0],
                            "size"      => $size[0],
                            "encoding"  => "UTF-8"
                        ]
                        ,"pat" => [
                            "blobName"  => "PAT.txt",
                            "blobType"  => "text/plain",
                            "blob"      => $blob[1],
                            "size"      => $size[1],
                            "encoding"  => "UTF-8"
                        ]
                        ,"opd" => [
                            "blobName"  => "OPD.txt",
                            "blobType"  => "text/plain",
                            "blob"      => $blob[2],
                            "size"      => $size[2],
                            "encoding"  => "UTF-8"
                        ] 
                        ,"orf" => [
                            "blobName"  => "ORF.txt",
                            "blobType"  => "text/plain",
                            "blob"      => $blob[3],
                            "size"      => $size[3],
                            "encoding"  => "UTF-8"
                        ]
                        ,"odx" => [
                            "blobName"  => "ODX.txt",
                            "blobType"  => "text/plain",
                            "blob"      => $blob[4],
                            "size"      => $size[4],
                            "encoding"  => "UTF-8"
                        ]  
                        ,"oop" => [
                            "blobName"  => "OOP.txt",
                            "blobType"  => "text/plain",
                            "blob"      => $blob[5],
                            "size"      => $size[5],
                            "encoding"  => "UTF-8"
                        ]
                        ,"ipd" => [
                            "blobName"  => "IPD.txt",
                            "blobType"  => "text/plain",
                            "blob"      => $blob[6],
                            "size"      => $size[6],
                            "encoding"  => "UTF-8"
                        ]
                        ,"irf" => [
                            "blobName"  => "IRF.txt",
                            "blobType"  => "text/plain",
                            "blob"      => $blob[7],
                            "size"      => $size[7],
                            "encoding"  => "UTF-8"
                        ]
                        ,"idx" => [
                            "blobName"  => "IDX.txt",
                            "blobType"  => "text/plain",
                            "blob"      => $blob[8],
                            "size"      => $size[8],
                            "encoding"  => "UTF-8"
                        ]
                        ,"iop" => [
                            "blobName"  => "IOP.txt",
                            "blobType"  => "text/plain",
                            "blob"      => $blob[9],
                            "size"      => $size[9],
                            "encoding"  => "UTF-8"
                        ]
                        ,"cht" => [
                            "blobName"  => "CHT.txt",
                            "blobType"  => "text",
                            "blob"      => $blob[10],
                            "size"      => $size[10],
                            "encoding"  => "UTF-8"
                        ]
                        ,"cha" => [
                            "blobName"  => "CHA.txt",
                            "blobType"  => "text/plain",
                            "blob"      => $blob[11],
                            "size"      => $size[11],
                            "encoding"  => "UTF-8"
                        ]
                        ,"aer" => [
                            "blobName"  => "AER.txt",
                            "blobType"  => "text/plain",
                            "blob"      => $blob[12],
                            "size"      => $size[12],
                            "encoding"  => "UTF-8"
                        ]
                        ,"adp" => [
                            "blobName"  => "ADP.txt",
                            "blobType"  => "text/plain",
                            "blob"      => $blob[13],
                            "size"      => $size[13],
                            "encoding"  => "UTF-8"
                        ]
                        ,"lvd" => [
                            "blobName"  => "LVD.txt",
                            "blobType"  => "text/plain",
                            "blob"      => $blob[14],
                            "size"      => $size[14],
                            "encoding"  => "UTF-8"
                        ]
                        ,"dru" => [
                            "blobName" => "DRU.txt",
                            "blobType" => "text/plain",
                            "blob"     => $blob[15],
                            "size"     => $size[15],
                            "encoding" => "UTF-8"
                        ]                        
                        ,"lab" => null
                    ] 
            ];        
            // dd($postData_send);
            $headers_send  = [
                'Authorization : Bearer '.$token,
                'Content-Type: application/json',            
                'User-Agent:<platform>/<version><10978>'
                    
            ];

            curl_setopt($fame_send, CURLOPT_URL,"https://nhsoapi.nhso.go.th/FMU/ecimp/v1/send");
            curl_setopt($fame_send, CURLOPT_POST, 1);
            curl_setopt($fame_send, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($fame_send, CURLOPT_POSTFIELDS, json_encode($postData_send, JSON_UNESCAPED_SLASHES));
            curl_setopt($fame_send, CURLOPT_HTTPHEADER, $headers_send);
  
            $server_output     = curl_exec ($fame_send);
            $statusCode = curl_getinfo($fame_send, CURLINFO_HTTP_CODE);
            
            $content = $server_output;
            $result = json_decode($content, true);
            
            #echo "<BR>";
            @$status = $result['status'];
            #echo "<BR>";
            @$message = $result['message'];
            #echo "<BR>";
           
        
        return response()->json([
            'status'    => '200'
        ]);
    }
    public function ofc_401_sendapi_no(Request $request)
    {  
        $data_token_ = DB::connection('mysql')->select(' SELECT * FROM api_neweclaim');  
        foreach ($data_token_ as $key => $val_to) {
            $username     = $val_to->api_neweclaim_user;
            $password     = $val_to->api_neweclaim_pass;
            $token        = $val_to->api_neweclaim_token;
        } 
        // dd($token);
          
        $data_table = array("d_apiofc_ins","d_apiofc_pat","d_apiofc_opd","d_apiofc_orf","d_apiofc_odx","d_apiofc_oop","d_apiofc_ipd","d_apiofc_irf","d_apiofc_idx","d_apiofc_iop","d_apiofc_cht","d_apiofc_cha","d_apiofc_aer","d_apiofc_adp","d_apiofc_ldv","d_apiofc_dru");
        // $data_table = array("ins","pat","opd","orf","odx","oop","ipd","irf","idx","iop","cht","cha","aer","adp","lvd","dru");
        foreach ($data_table as $key => $val_t) {        
                $data_all_ = DB::connection('mysql')->select('
                SELECT * FROM '.$val_t.'
                ');                
                foreach ($data_all_ as $val_field) {
                    $blob[] = $val_field->blob;
                    $size[] = $val_field->size; 
                    
                 }      

            }
 
        // $response = Http::withHeaders([ 
        //     'User-Agent:<platform>/<version> <10978>',
        //     'Accept' => 'application/json',
        // ])->post('https://nhsoapi.nhso.go.th/FMU/ecimp/v1/auth', [
        //     'username'    =>  $username ,
        //     'password'    =>  $password 
        // ]);    
        // dd($blob[15]);
        $response = Http::withHeaders([  
            'Authorization : Bearer '.$token,
            'User-Agent:<platform>/<version> <10978>',           
            'Content-Type: application/json',            
            // 'User-Agent:<platform>/<version><10978>'
             // 'Accept' => 'application/json' 
        ])->post('https://nhsoapi.nhso.go.th/FMU/ecimp/v1/send', [
            "fileType"   => "txt",
            "maininscl"  => "OFC",
            "importDup"  => true, //นำเข้าซ้ำ กรณีพบข้อมูลยังไม่ส่งเบิกชดเชย 
            "assignToMe" => true,  //กำหนดข้อมูลให้แสดงผลเฉพาะผู้นำเข้าเท่านั้น
            "dataTypes"  => ["OP","IP"],
            "opRefer"    => false, 
                "file"   => [ 
                    "ins" => [
                        "blobName"  => "INS.txt",
                        "blobType"  => "text/plain",
                        "blob"      => $blob[0],
                        "size"      => $size[0],
                        "encoding"  => "UTF-8"
                    ]
                    ,"pat" => [
                        "blobName"  => "PAT.txt",
                        "blobType"  => "text/plain",
                        "blob"      => $blob[1],
                        "size"      => $size[1],
                        "encoding"  => "UTF-8"
                    ]
                    ,"opd" => [
                        "blobName"  => "OPD.txt",
                        "blobType"  => "text/plain",
                        "blob"      => $blob[2],
                        "size"      => $size[2],
                        "encoding"  => "UTF-8"
                    ] 
                    ,"orf" => [
                        "blobName"  => "ORF.txt",
                        "blobType"  => "text/plain",
                        "blob"      => $blob[3],
                        "size"      => $size[3],
                        "encoding"  => "UTF-8"
                    ]
                    ,"odx" => [
                        "blobName"  => "ODX.txt",
                        "blobType"  => "text/plain",
                        "blob"      => $blob[4],
                        "size"      => $size[4],
                        "encoding"  => "UTF-8"
                    ]  
                    ,"oop" => [
                        "blobName"  => "OOP.txt",
                        "blobType"  => "text/plain",
                        "blob"      => $blob[5],
                        "size"      => $size[5],
                        "encoding"  => "UTF-8"
                    ]
                    ,"ipd" => [
                        "blobName"  => "IPD.txt",
                        "blobType"  => "text/plain",
                        "blob"      => $blob[6],
                        "size"      => $size[6],
                        "encoding"  => "UTF-8"
                    ]
                    ,"irf" => [
                        "blobName"  => "IRF.txt",
                        "blobType"  => "text/plain",
                        "blob"      => $blob[7],
                        "size"      => $size[7],
                        "encoding"  => "UTF-8"
                    ]
                    ,"idx" => [
                        "blobName"  => "IDX.txt",
                        "blobType"  => "text/plain",
                        "blob"      => $blob[8],
                        "size"      => $size[8],
                        "encoding"  => "UTF-8"
                    ]
                    ,"iop" => [
                        "blobName"  => "IOP.txt",
                        "blobType"  => "text/plain",
                        "blob"      => $blob[9],
                        "size"      => $size[9],
                        "encoding"  => "UTF-8"
                    ]
                    ,"cht" => [
                        "blobName"  => "CHT.txt",
                        "blobType"  => "text",
                        "blob"      => $blob[10],
                        "size"      => $size[10],
                        "encoding"  => "UTF-8"
                    ]
                    ,"cha" => [
                        "blobName"  => "CHA.txt",
                        "blobType"  => "text/plain",
                        "blob"      => $blob[11],
                        "size"      => $size[11],
                        "encoding"  => "UTF-8"
                    ]
                    ,"aer" => [
                        "blobName"  => "AER.txt",
                        "blobType"  => "text/plain",
                        "blob"      => $blob[12],
                        "size"      => $size[12],
                        "encoding"  => "UTF-8"
                    ]
                    ,"adp" => [
                        "blobName"  => "ADP.txt",
                        "blobType"  => "text/plain",
                        "blob"      => $blob[13],
                        "size"      => $size[13],
                        "encoding"  => "UTF-8"
                    ]
                    ,"lvd" => [
                        "blobName"  => "LVD.txt",
                        "blobType"  => "text/plain",
                        "blob"      => $blob[14],
                        "size"      => $size[14],
                        "encoding"  => "UTF-8"
                    ]
                    ,"dru" => [
                        "blobName" => "DRU.txt",
                        "blobType" => "text/plain",
                        "blob"     => $blob[15],
                        "size"     => $size[15],
                        "encoding" => "UTF-8"
                   ]
                    ,"dru" => [
                        "blobName"  => "DRU.txt",
                        "blobType"  => "text/plain",
                        "blob"      => $blob[15],
                        "size"      => $size[15],
                        "encoding"  => "UTF-8"
                    ]
                    ,"lab" => null
                ] 
        ]);   
        // $token = $response->json('token');
        $status = $response->json('status');
        $message = $response->json('message');
         // $response = Http::withToken('thetoken')->post('https://nhsoapi.nhso.go.th/FMU/ecimp/v1/auth');
        // dump($response->json('token'));
        // dump($response->status());
        // dump($response->message());
        // $status2 = $response->getStatusCode();

        dd($status);
        
          
            // ************************
            // $response_send = Http::withHeaders([ 
            //     'Authorization : Bearer '.$token,
            //     'Content-Type: application/json',            
            //     'User-Agent:<platform>/<version><10978>'  
            // ])->post('https://nhsoapi.nhso.go.th/FMU/ecimp/v1/send', [
            //     'postData_send'    =>  $postData_send , 
            // ]);    
            // $token = $response_send->json('token');
            // dump($response_send->json('token'));
            // dump($response_send->status());
            // dump($response_send->message());


        
        return response()->json([
            'status'    => '200'
        ]);
    }
 
}
