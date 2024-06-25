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
use App\Models\D_apiwalkin_ins;  
use App\Models\D_apiwalkin_adp;
use App\Models\D_apiwalkin_aer;
use App\Models\D_apiwalkin_orf;
use App\Models\D_apiwalkin_odx;
use App\Models\D_apiwalkin_cht;
use App\Models\D_apiwalkin_cha;
use App\Models\D_apiwalkin_oop;
use App\Models\D_claim; 
use App\Models\D_apiwalkin_dru;
use App\Models\D_apiwalkin_idx;
use App\Models\D_apiwalkin_iop;
use App\Models\D_apiwalkin_ipd;
use App\Models\D_apiwalkin_pat;
use App\Models\D_apiwalkin_opd;
use App\Models\D_walkin;
use App\Models\D_apiwalkin_ldv;
use App\Models\D_apiwalkin_irf;
use App\Models\D_hpv_report;
use Auth;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http; 
use SoapClient;
use Arr; 
 
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

class VaccineController extends Controller
{  
      
    public function hpv_report(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;
 
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $newday = date('Y-m-d', strtotime($date . ' -1 day')); //ย้อนหลัง 1 สัปดาห์
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -1 months')); //ย้อนหลัง 2 เดือน
        $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี
        $yearnew = date('Y');
        $yearold = date('Y')-1;
        $start = (''.$yearold.'-10-01');
        $end = (''.$yearnew.'-09-30'); 
        if ($startdate != '') {  
                // $hpv_report_ = DB::connection('mysql2')->select(' 
                //         SELECT 
                //         l1.vn,l1.hn,v.cid,v.vstdate,v.pttype,concat(p.pname,p.fname," ",p.lname) ptname 
                //         ,ac.debit,ac.pp,ac.fs,ac.total_approve,ac.va,ac.STMdoc,ac.va

                //         FROM lab_head l1
                //         LEFT OUTER JOIN patient p on p.hn=l1.hn 
                //         LEFT OUTER JOIN vn_stat v on v.vn = l1.vn 
                //         LEFT OUTER JOIN pkbackoffice.acc_stm_ucs ac on ac.cid = v.cid AND ac.debit IN("420.0","250.0") 
                //         WHERE v.vstdate BETWEEN "'.$startdate.'" and "'.$enddate.'" 
                //         AND l1.form_name LIKE "HPV%"
 
                // ');
                // foreach ($hpv_report_ as $key => $value) {
                //     $check = D_hpv_report::where('vn',$value->vn)->count();
                //     if ($check > 0) {
                //         D_hpv_report::where('vn',$value->vn)->update([ 
                //             'debit'              => $value->debit,
                //             'pp'                 => $value->pp,
                //             'fs'                 => $value->fs,
                //             'total_approve'      => $value->total_approve,
                //             'STMdoc'             => $value->STMdoc,   
                //             'va'                 => $value->va, 
                //         ]);
                //     } else {
                //         D_hpv_report::insert([
                //             'hn'                 => $value->hn, 
                //             'vn'                 => $value->vn,
                //             'cid'                => $value->cid,
                //             'ptname'             => $value->ptname,
                //             'pttype'             => $value->pttype,
                //             'vstdate'            => $value->vstdate,  
                //             'debit'              => $value->debit,
                //             'pp'                 => $value->pp,
                //             'fs'                 => $value->fs,
                //             'total_approve'      => $value->total_approve,
                //             'STMdoc'             => $value->STMdoc,   
                //             'va'                 => $value->va, 
                //         ]);
                //     }
                     
                // } 
                $hpv_report = DB::connection('mysql')->select('SELECT * FROM d_hpv_report WHERE vstdate BETWEEN "'.$startdate.'" and "'.$enddate.'"');
        } else { 
                $hpv_report = DB::connection('mysql')->select('SELECT * FROM d_hpv_report WHERE vstdate BETWEEN "'.$newDate.'" and "'.$date.'" '); 
        } 
       
        return view('report_stm.hpv_report',[
            'startdate'        => $startdate,
            'enddate'          => $enddate, 
            'hpv_report'       => $hpv_report, 
        ]);
    } 
    public function hpv_report_pull(Request $request)
    {
            $startdate   = $request->startdate;
            $enddate     = $request->enddate;
     
            if ($startdate != '') {  
                $hpv_report_ = DB::connection('mysql2')->select(' 
                        SELECT 
                        l1.vn,l1.hn,v.cid,v.vstdate,v.pttype,concat(p.pname,p.fname," ",p.lname) ptname 
                        ,ac.debit,ac.pp,ac.fs,ac.total_approve,ac.va,ac.STMdoc,ac.va

                        FROM lab_head l1
                        LEFT OUTER JOIN patient p on p.hn=l1.hn 
                        LEFT OUTER JOIN vn_stat v on v.vn = l1.vn 
                        LEFT OUTER JOIN pkbackoffice.acc_stm_ucs ac on ac.cid = v.cid AND ac.debit IN("420.0","250.0") 
                        WHERE v.vstdate BETWEEN "'.$startdate.'" and "'.$enddate.'" 
                        AND l1.form_name LIKE "HPV%"
 
                ');
                foreach ($hpv_report_ as $key => $value) {
                    $check = D_hpv_report::where('vn',$value->vn)->count();
                    if ($check > 0) {
                        D_hpv_report::where('vn',$value->vn)->update([ 
                            'debit'              => $value->debit,
                            'pp'                 => $value->pp,
                            'fs'                 => $value->fs,
                            'total_approve'      => $value->total_approve,
                            'STMdoc'             => $value->STMdoc,   
                            'va'                 => $value->va, 
                        ]);
                    } else {
                        D_hpv_report::insert([
                            'hn'                 => $value->hn, 
                            'vn'                 => $value->vn,
                            'cid'                => $value->cid,
                            'ptname'             => $value->ptname,
                            'pttype'             => $value->pttype,
                            'vstdate'            => $value->vstdate,  
                            'debit'              => $value->debit,
                            'pp'                 => $value->pp,
                            'fs'                 => $value->fs,
                            'total_approve'      => $value->total_approve,
                            'STMdoc'             => $value->STMdoc,   
                            'va'                 => $value->va, 
                        ]);
                    } 
                }  
            } else { 
                     
            } 
        return response()->json([ 
            'status'    => '200'
        ]);
    }
 
}
