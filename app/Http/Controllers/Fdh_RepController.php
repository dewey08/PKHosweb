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
use App\Models\Book_senddep;
use App\Models\Book_senddep_sub;
use App\Models\Book_send_person;
use App\Models\Book_sendteam;
use App\Models\Bookrepdelete;
use App\Models\Car_status;
use App\Models\Car_index;
use App\Models\Article_status;
use App\Models\Car_type;
use App\Models\Product_brand;
use App\Models\Product_color;  
use App\Models\Land;
use App\Models\Building;
use App\Models\Product_budget;
use App\Models\Product_method;
use App\Models\Product_buy;
use App\Models\Fdh_ofc_rep;
use App\Models\Fdh_noapprove;
use App\Models\Fdh_noapprove_excel;
use App\Models\D_fdh;
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
use App\Models\Acc_ucep24;
use App\Models\Fdh_ins;
use App\Models\Fdh_pat;
use App\Models\Fdh_opd;
use App\Models\Fdh_orf;
use App\Models\Fdh_odx;
use App\Models\Fdh_cht;
use App\Models\Fdh_cha;
use App\Models\Fdh_oop; 
use App\Models\Fdh_adp;
use App\Models\Fdh_dru;
use App\Models\Fdh_idx;
use App\Models\Fdh_iop;
use App\Models\Fdh_ipd;
use App\Models\Fdh_aer;
use App\Models\Fdh_irf;
use App\Models\Fdh_lvd; 
use App\Models\Fdh_ofc_repexcel;
use App\Models\D_fdh_rep;
use App\Models\D_fdh_repexcel;
use Auth;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http; 
use SoapClient;
use Arr; 
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
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\IOFactory; 
use ZipArchive;  
use Illuminate\Support\Facades\Redirect;
use PhpParser\Node\Stmt\If_;
use Stevebauman\Location\Facades\Location; 
use Illuminate\Filesystem\Filesystem;

class Fdh_RepController extends Controller
{ 
   
    public function fdh_rep(Request $request)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $datashow = DB::connection('mysql')->select('
            SELECT A,I,SUM(BB) as Sumprice,STMdoc,month(I) as months
            FROM d_fdh_repexcel
            GROUP BY A
            ');
        $countc = DB::table('d_fdh_repexcel')->count();  
        $data['d_fdh']    = DB::connection('mysql')->select('SELECT * from d_fdh WHERE active ="N" AND authen IS NOT NULL AND icd10 IS NOT NULL ORDER BY vn ASC');  
             
        return view('fdh.fdh_rep',$data,[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'datashow'      =>     $datashow,
            'countc'        =>     $countc
        ]);
    }
    function fdh_rep_save(Request $request)
    { 
        $this->validate($request, [
            'file' => 'required|file|mimes:xls,xlsx'
        ]);
        $the_file = $request->file('file'); 
        $file_ = $request->file('file')->getClientOriginalName(); //ชื่อไฟล์

        // dd($the_file);
            try{ 
                // Cheet 2
                $spreadsheet = IOFactory::load($the_file->getRealPath()); 
                $sheet        = $spreadsheet->setActiveSheetIndex(0);
                $row_limit    = $sheet->getHighestDataRow();
                $column_limit = $sheet->getHighestDataColumn();
                $row_range    = range( 9, $row_limit );
                $column_range = range( 'DM', $column_limit );
                $startcount = 9;
                $data = array();
                foreach ($row_range as $row ) {
                    $vst = $sheet->getCell( 'I' . $row )->getValue();  
                    $day = substr($vst,0,2);
                    $mo = substr($vst,3,2);
                    $year = substr($vst,6,4);
                    $vstdate = $year.'-'.$mo.'-'.$day;

                    $reg = $sheet->getCell( 'J' . $row )->getValue(); 
                    $regday = substr($reg, 0, 2);
                    $regmo = substr($reg, 3, 2);
                    $regyear = substr($reg, 6, 4);
                    $dchdate = $regyear.'-'.$regmo.'-'.$regday;

                    $k = $sheet->getCell( 'K' . $row )->getValue();
                    $del_k = str_replace(",","",$k);
                    $l = $sheet->getCell( 'L' . $row )->getValue();
                    $del_l = str_replace(",","",$l);
                    $am = $sheet->getCell( 'AM' . $row )->getValue();
                    $del_am = str_replace(",","",$am);
                    $an = $sheet->getCell( 'AN' . $row )->getValue();
                    $del_an = str_replace(",","",$an);
                    $ao = $sheet->getCell( 'AO' . $row )->getValue();
                    $del_ao = str_replace(",","",$ao);
                    $ap = $sheet->getCell( 'AP' . $row )->getValue();
                    $del_ap= str_replace(",","",$ap);
                    $aq = $sheet->getCell( 'AQ' . $row )->getValue();
                    $del_aq = str_replace(",","",$aq);
                    $ar = $sheet->getCell( 'AR' . $row )->getValue();
                    $del_ar = str_replace(",","",$ar);
                    $ax = $sheet->getCell( 'AX' . $row )->getValue();
                    $del_ax = str_replace(",","",$ax);
                    $ay = $sheet->getCell( 'AY' . $row )->getValue();
                    $del_ay = str_replace(",","",$ay);
                    $bb = $sheet->getCell( 'BB' . $row )->getValue();
                    $del_bb = str_replace(",","",$bb);
                    $by = $sheet->getCell( 'BY' . $row )->getValue();
                    $del_by = str_replace(",","",$by);
                    $bz = $sheet->getCell( 'BZ' . $row )->getValue();
                    $del_bz= str_replace(",","",$bz);
                    $cc= $sheet->getCell( 'CC' . $row )->getValue();
                    $del_cc = str_replace(",","",$cc);
                    $ce = $sheet->getCell( 'CE' . $row )->getValue();
                    $del_ce = str_replace(",","",$ce);
                    $cg = $sheet->getCell( 'CG' . $row )->getValue();
                    $del_cg = str_replace(",","",$cg);
                    $dh = $sheet->getCell( 'DH' . $row )->getValue();
                    $del_dh = str_replace(",","",$dh);
                   
 
                    $data[] = [
                        'A'            =>$sheet->getCell( 'A' . $row )->getValue(),
                        'B'            =>$sheet->getCell( 'B' . $row )->getValue(),
                        'C'            =>$sheet->getCell( 'C' . $row )->getValue(),
                        'D'            =>$sheet->getCell( 'D' . $row )->getValue(),
                        'E'            =>$sheet->getCell( 'E' . $row )->getValue(),
                        'F'            =>$sheet->getCell( 'F' . $row )->getValue(),
                        'G'            =>$sheet->getCell( 'G' . $row )->getValue(), 
                        'H'            =>$sheet->getCell( 'H' . $row )->getValue(),
                        'I'            =>$vstdate,
                        'J'            =>$dchdate,
                        'K'            =>$del_k,
                        'L'            =>$del_l,                        
                        'M'            =>$sheet->getCell( 'M' . $row )->getValue(),
                        'N'            =>$sheet->getCell( 'N' . $row )->getValue(),
                        'O'            =>$sheet->getCell( 'O' . $row )->getValue(),
                        'P'            =>$sheet->getCell( 'P' . $row )->getValue(),
                        'Q'            =>$sheet->getCell( 'Q' . $row )->getValue(),
                        'R'            =>$sheet->getCell( 'R' . $row )->getValue(),
                        'S'            =>$sheet->getCell( 'S' . $row )->getValue(),
                        'T'            =>$sheet->getCell( 'T' . $row )->getValue(),
                        'U'            =>$sheet->getCell( 'U' . $row )->getValue(),
                        'V'            =>$sheet->getCell( 'V' . $row )->getValue(),
                        'W'            =>$sheet->getCell( 'W' . $row )->getValue(),
                        'X'            =>$sheet->getCell( 'X' . $row )->getValue(),
                        'Y'            =>$sheet->getCell( 'Y' . $row )->getValue(),
                        'Z'            =>$sheet->getCell( 'Z' . $row )->getValue(),
                        'AA'            =>$sheet->getCell( 'AA' . $row )->getValue(),
                        'AB'            =>$sheet->getCell( 'AB' . $row )->getValue(),
                        'AC'            =>$sheet->getCell( 'AC' . $row )->getValue(),
                        'AD'            =>$sheet->getCell( 'AD' . $row )->getValue(),
                        'AE'            =>$sheet->getCell( 'AE' . $row )->getValue(),
                        'AF'            =>$sheet->getCell( 'AF' . $row )->getValue(),
                        'AG'            =>$sheet->getCell( 'AG' . $row )->getValue(),
                        'AH'            =>$sheet->getCell( 'AH' . $row )->getValue(),
                        'AI'            =>$sheet->getCell( 'AI' . $row )->getValue(),
                        'AJ'            =>$sheet->getCell( 'AJ' . $row )->getValue(),
                        'AK'            =>$sheet->getCell( 'AK' . $row )->getValue(),
                        'AL'            =>$sheet->getCell( 'AL' . $row )->getValue(),
                        'AM'            =>$del_am,
                        'AN'            =>$del_an,
                        'AO'            =>$del_ao,
                        'AP'            =>$del_ap,
                        'AQ'            =>$del_aq,
                        'AR'            =>$del_ar,
                        'AS'            =>$sheet->getCell( 'AS' . $row )->getValue(),
                        'AT'            =>$sheet->getCell( 'AT' . $row )->getValue(),
                        'AU'            =>$sheet->getCell( 'AU' . $row )->getValue(),
                        'AV'            =>$sheet->getCell( 'AV' . $row )->getValue(),
                        'AW'            =>$sheet->getCell( 'AW' . $row )->getValue(),                       
                        'AX'            =>$del_ax,
                        'AY'            =>$del_ay,                       
                        'AZ'            =>$sheet->getCell( 'AZ' . $row )->getValue(),
                        'BA'            =>$sheet->getCell( 'BA' . $row )->getValue(),
                        'BB'            =>$del_bb,
                        'BC'            =>$sheet->getCell( 'BC' . $row )->getValue(),
                        'BD'            =>$sheet->getCell( 'BD' . $row )->getValue(),
                        'BE'            =>$sheet->getCell( 'BE' . $row )->getValue(),
                        'BF'            =>$sheet->getCell( 'BF' . $row )->getValue(),
                        'BG'            =>$sheet->getCell( 'BG' . $row )->getValue(),
                        'BH'            =>$sheet->getCell( 'BH' . $row )->getValue(),
                        'BI'            =>$sheet->getCell( 'BI' . $row )->getValue(),
                        'BJ'            =>$sheet->getCell( 'BJ' . $row )->getValue(),
                        'BK'            =>$sheet->getCell( 'BK' . $row )->getValue(),
                        'BL'            =>$sheet->getCell( 'BL' . $row )->getValue(),
                        'BM'            =>$sheet->getCell( 'BM' . $row )->getValue(),
                        'BN'            =>$sheet->getCell( 'BN' . $row )->getValue(),
                        'BO'            =>$sheet->getCell( 'BO' . $row )->getValue(),
                        'BP'            =>$sheet->getCell( 'BP' . $row )->getValue(),
                        'BQ'            =>$sheet->getCell( 'BQ' . $row )->getValue(),
                        'BR'            =>$sheet->getCell( 'BR' . $row )->getValue(),
                        'BS'            =>$sheet->getCell( 'BS' . $row )->getValue(),
                        'BT'            =>$sheet->getCell( 'BT' . $row )->getValue(),
                        'BU'            =>$sheet->getCell( 'BU' . $row )->getValue(),
                        'BV'            =>$sheet->getCell( 'BV' . $row )->getValue(),
                        'BW'            =>$sheet->getCell( 'BW' . $row )->getValue(),
                        'BX'            =>$sheet->getCell( 'BX' . $row )->getValue(),
                        'BY'            =>$del_by,
                        'BZ'            =>$del_bz,
                        'CA'            =>$sheet->getCell( 'CA' . $row )->getValue(),
                        'CB'            =>$sheet->getCell( 'CB' . $row )->getValue(),
                        'CC'            =>$del_cc,
                        'CD'            =>$sheet->getCell( 'CD' . $row )->getValue(),
                        'CE'            =>$del_ce,
                        'CF'            =>$sheet->getCell( 'CF' . $row )->getValue(), 
                        'CG'            =>$del_cg,
                        'CH'            =>$sheet->getCell( 'CH' . $row )->getValue(),
                        'CI'            =>$sheet->getCell( 'CI' . $row )->getValue(),
                        'CJ'            =>$sheet->getCell( 'CJ' . $row )->getValue(),
                        'CK'            =>$sheet->getCell( 'CK' . $row )->getValue(),
                        'CL'            =>$sheet->getCell( 'CL' . $row )->getValue(),
                        'CM'            =>$sheet->getCell( 'CM' . $row )->getValue(),
                        'CN'            =>$sheet->getCell( 'CN' . $row )->getValue(),
                        'CO'            =>$sheet->getCell( 'CO' . $row )->getValue(),
                        'CP'            =>$sheet->getCell( 'CP' . $row )->getValue(),
                        'CQ'            =>$sheet->getCell( 'CQ' . $row )->getValue(),
                        'CR'            =>$sheet->getCell( 'CR' . $row )->getValue(),
                        'CS'            =>$sheet->getCell( 'CS' . $row )->getValue(),
                        'CT'            =>$sheet->getCell( 'CT' . $row )->getValue(),
                        'CU'            =>$sheet->getCell( 'CU' . $row )->getValue(),
                        'CV'            =>$sheet->getCell( 'CV' . $row )->getValue(),
                        'CW'            =>$sheet->getCell( 'CW' . $row )->getValue(),
                        'CX'            =>$sheet->getCell( 'CX' . $row )->getValue(),
                        'CY'            =>$sheet->getCell( 'CY' . $row )->getValue(),
                        'CZ'            =>$sheet->getCell( 'CZ' . $row )->getValue(),
                        'DA'            =>$sheet->getCell( 'DA' . $row )->getValue(),
                        'DB'            =>$sheet->getCell( 'DB' . $row )->getValue(),
                        'DC'            =>$sheet->getCell( 'DC' . $row )->getValue(),
                        'DD'            =>$sheet->getCell( 'DD' . $row )->getValue(),
                        'DE'            =>$sheet->getCell( 'DE' . $row )->getValue(),
                        'DF'            =>$sheet->getCell( 'DF' . $row )->getValue(),
                        'DG'            =>$sheet->getCell( 'DG' . $row )->getValue(),
                        'DH'            =>$del_dh,
                        'DI'            =>$sheet->getCell( 'DI' . $row )->getValue(),
                        'DJ'            =>$sheet->getCell( 'DJ' . $row )->getValue(),
                        'DK'            =>$sheet->getCell( 'DK' . $row )->getValue(),
                        'DL'            =>$sheet->getCell( 'DL' . $row )->getValue(),
                        'DM'            =>$sheet->getCell( 'DM' . $row )->getValue(),
                        'STMdoc'        =>$file_ 
                    ];
                    $startcount++; 

                }
                // DB::table('acc_stm_ucs_excel')->insert($data); 

                $for_insert = array_chunk($data, length:1000);
                foreach ($for_insert as $key => $data_) {
                    D_fdh_repexcel::insert($data_); 
                }
                // Acc_stm_ucs_excel::insert($data); 
 

            } catch (Exception $e) {
                $error_code = $e->errorInfo[1];
                return back()->withErrors('There was a problem uploading the data!');
            }
            // return back()->withSuccess('Great! Data has been successfully uploaded.');
            return response()->json([
            'status'    => '200',
        ]);
    }

    public function fdh_rep_send(Request $request)
    {
        try{
            $data_ = DB::connection('mysql')->select('SELECT * FROM d_fdh_repexcel WHERE F IS NOT NULL');
            foreach ($data_ as $key => $value) {
                if ($value->F != '') {
                    $check = D_fdh_rep::where('C','=',$value->C)->count();
                    if ($check > 0) {
                    } else {
                        $add = new D_fdh_rep();
                        $add->A        = $value->A;
                        $add->B        = $value->B;
                        $add->C        = $value->C;
                        $add->D        = $value->D;
                        $add->E        = $value->E;
                        $add->F        = $value->F;
                        $add->G        = $value->G;
                        $add->H        = $value->H;
                        $add->I        = $value->I;
                        $add->J        = $value->J;
                        $add->K        = $value->K;
                        $add->L        = $value->L;
                        $add->M        = $value->M;
                        $add->N        = $value->N;
                        $add->O        = $value->O;
                        $add->P        = $value->P;
                        $add->Q        = $value->Q;
                        $add->R        = $value->R;
                        $add->S        = $value->S;
                        $add->T        = $value->T;
                        $add->U        = $value->U;
                        $add->V        = $value->V;
                        $add->W        = $value->W;
                        $add->X        = $value->X;
                        $add->Y        = $value->Y;
                        $add->Z        = $value->Z;
                        $add->AA       = $value->AA;
                        $add->AB       = $value->AB;
                        $add->AC       = $value->AC;
                        $add->AD       = $value->AD;
                        $add->AE       = $value->AE;
                        $add->AF       = $value->AF;
                        $add->AG       = $value->AG;
                        $add->AH       = $value->AH;
                        $add->AI       = $value->AI;
                        $add->AJ       = $value->AJ;
                        $add->AK       = $value->AK;
                        $add->AL       = $value->AL;
                        $add->AM       = $value->AM;
                        $add->AN       = $value->AN;
                        $add->AO       = $value->AO;
                        $add->AP       = $value->AP;
                        $add->AQ       = $value->AQ;
                        $add->AR       = $value->AR;
                        $add->AS       = $value->AS;
                        $add->AT       = $value->AT;
                        $add->AU       = $value->AU;
                        $add->AV       = $value->AV;
                        $add->AW       = $value->AW;
                        $add->AX       = $value->AX;
                        $add->AY       = $value->AY;
                        $add->AZ       = $value->AZ;
                        $add->BA       = $value->BA;
                        $add->BB       = $value->BB;
                        $add->BC       = $value->BC;
                        $add->BD       = $value->BD;
                        $add->BE       = $value->BE;
                        $add->BF       = $value->BF;
                        $add->BG       = $value->BG;
                        $add->BH       = $value->BH;
                        $add->BI       = $value->BI;
                        $add->BJ       = $value->BJ;
                        $add->BK       = $value->BK;
                        $add->BL       = $value->BL;
                        $add->BM       = $value->BM;
                        $add->BN       = $value->BN;
                        $add->BO       = $value->BO;
                        $add->BP       = $value->BP;
                        $add->BQ       = $value->BQ;
                        $add->BR       = $value->BR;
                        $add->BS       = $value->BS;
                        $add->BT       = $value->BT;
                        $add->BU       = $value->BU;
                        $add->BV       = $value->BV;
                        $add->BW       = $value->BW;
                        $add->BX       = $value->BX;
                        $add->BY       = $value->BY;
                        $add->BZ       = $value->BZ;
                        $add->DA       = $value->DA;
                        $add->DB       = $value->DB;
                        $add->DC       = $value->DC;
                        $add->DD       = $value->DD;
                        $add->DE       = $value->DE;
                        $add->DF       = $value->DF;
                        $add->DG       = $value->DG;
                        $add->DH       = $value->DH;
                        $add->DI       = $value->DI;
                        $add->DJ       = $value->DJ;
                        $add->DK       = $value->DK;
                        $add->DL       = $value->DL;
                        $add->DM       = $value->DM;
                        $add->STMdoc   = $value->STMdoc;
                        $add->save();  
                    }  
                    
                        D_fdh::where('cid',$value->F)->where('vstdate',$value->I) 
                            ->update([
                                'active'          => 'R',
                                'debit_rep'       => $value->BB,
                                'error_code'      => $value->N,
                                'STMdoc'          => $value->STMdoc, 
                        ]);
                    
                   
                } else {
                }
            }
            } catch (Exception $e) {
                $error_code = $e->errorInfo[1];
                return back()->withErrors('There was a problem uploading the data!');
            }
            D_fdh_repexcel::truncate();
        return redirect()->back();
    }

    public function ofc_rep(Request $request)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $datashow = DB::connection('mysql')->select('
            SELECT A,I,SUM(BB) as Sumprice,STMdoc,month(I) as months
            FROM fdh_ofc_repexcel
            GROUP BY A
            ');
            // d_fdh_repexcel
        $countc = DB::table('fdh_ofc_repexcel')->count();  
        $data['d_fdh']    = DB::connection('mysql')->select('SELECT * from d_fdh WHERE active ="N" AND authen IS NOT NULL AND icd10 IS NOT NULL ORDER BY vn ASC');  
             
        return view('fdh.ofc_rep',$data,[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'datashow'      =>     $datashow,
            'countc'        =>     $countc
        ]);
    }
    function ofc_rep_save(Request $request)
    { 
        $this->validate($request, [
            'file' => 'required|file|mimes:xls,xlsx'
        ]);
        $the_file = $request->file('file'); 
        $file_ = $request->file('file')->getClientOriginalName(); //ชื่อไฟล์

        // dd($the_file);
            try{ 
                // Cheet 2
                $spreadsheet = IOFactory::load($the_file->getRealPath()); 
                $sheet        = $spreadsheet->setActiveSheetIndex(0);
                $row_limit    = $sheet->getHighestDataRow();
                $column_limit = $sheet->getHighestDataColumn();
                $row_range    = range( 8, $row_limit );
                $column_range = range( 'DM', $column_limit );
                $startcount = 8;
                $data = array();
                foreach ($row_range as $row ) {
                    $vst = $sheet->getCell( 'I' . $row )->getValue();  
                    $day = substr($vst,0,2);
                    $mo = substr($vst,3,2);
                    $year = substr($vst,6,4);
                    $vstdate = $year.'-'.$mo.'-'.$day;

                    $reg = $sheet->getCell( 'J' . $row )->getValue(); 
                    $regday = substr($reg, 0, 2);
                    $regmo = substr($reg, 3, 2);
                    $regyear = substr($reg, 6, 4);
                    $dchdate = $regyear.'-'.$regmo.'-'.$regday;

                    $k = $sheet->getCell( 'K' . $row )->getValue();
                    $del_k = str_replace(",","",$k);
                    $l = $sheet->getCell( 'L' . $row )->getValue();
                    $del_l = str_replace(",","",$l);

                    $ad = $sheet->getCell( 'AD' . $row )->getValue();
                    $del_ad = str_replace(",","",$ad);
                    $ae = $sheet->getCell( 'AE' . $row )->getValue();
                    $del_ae = str_replace(",","",$ae);
                    $af = $sheet->getCell( 'AF' . $row )->getValue();
                    $del_af = str_replace(",","",$af);
                    $ag = $sheet->getCell( 'AG' . $row )->getValue();
                    $del_ag = str_replace(",","",$ag);
                    $ah = $sheet->getCell( 'AH' . $row )->getValue();
                    $del_ah = str_replace(",","",$ah);
                    $ai = $sheet->getCell( 'AI' . $row )->getValue();
                    $del_ai = str_replace(",","",$ai);
                   


                    // $am = $sheet->getCell( 'AM' . $row )->getValue();
                    // $del_am = str_replace(",","",$am);
                    $an = $sheet->getCell( 'AN' . $row )->getValue();
                    $del_an = str_replace(",","",$an);
                    $ao = $sheet->getCell( 'AO' . $row )->getValue();
                    $del_ao = str_replace(",","",$ao);
                    $ap = $sheet->getCell( 'AP' . $row )->getValue();
                    $del_ap= str_replace(",","",$ap);
                    $aq = $sheet->getCell( 'AQ' . $row )->getValue();
                    $del_aq = str_replace(",","",$aq);
                    $ar = $sheet->getCell( 'AR' . $row )->getValue();
                    $del_ar = str_replace(",","",$ar);
                    $as = $sheet->getCell( 'AS' . $row )->getValue();
                    $del_as = str_replace(",","",$as);
                    $at = $sheet->getCell( 'AT' . $row )->getValue();
                    $del_at = str_replace(",","",$at);
                    $au = $sheet->getCell( 'AU' . $row )->getValue();
                    $del_au = str_replace(",","",$au);
                    $av = $sheet->getCell( 'AV' . $row )->getValue();
                    $del_av = str_replace(",","",$av);
                    
                   
 
                    $data[] = [
                        'A'            =>$sheet->getCell( 'A' . $row )->getValue(),
                        'B'            =>$sheet->getCell( 'B' . $row )->getValue(),
                        'C'            =>$sheet->getCell( 'C' . $row )->getValue(),
                        'D'            =>$sheet->getCell( 'D' . $row )->getValue(),
                        'E'            =>$sheet->getCell( 'E' . $row )->getValue(),
                        'F'            =>$sheet->getCell( 'F' . $row )->getValue(),
                        'G'            =>$sheet->getCell( 'G' . $row )->getValue(), 
                        'H'            =>$sheet->getCell( 'H' . $row )->getValue(),
                        'I'            =>$vstdate,
                        'J'            =>$dchdate,
                        'K'            =>$del_k,
                        'L'            =>$del_l,                        
                        'M'            =>$sheet->getCell( 'M' . $row )->getValue(),
                        'N'            =>$sheet->getCell( 'N' . $row )->getValue(),
                        'O'            =>$sheet->getCell( 'O' . $row )->getValue(),
                        'P'            =>$sheet->getCell( 'P' . $row )->getValue(),
                        'Q'            =>$sheet->getCell( 'Q' . $row )->getValue(),
                        'R'            =>$sheet->getCell( 'R' . $row )->getValue(),
                        'S'            =>$sheet->getCell( 'S' . $row )->getValue(),
                        'T'            =>$sheet->getCell( 'T' . $row )->getValue(),
                        'U'            =>$sheet->getCell( 'U' . $row )->getValue(),
                        'V'            =>$sheet->getCell( 'V' . $row )->getValue(),
                        'W'            =>$sheet->getCell( 'W' . $row )->getValue(),
                        'X'            =>$sheet->getCell( 'X' . $row )->getValue(),
                        'Y'            =>$sheet->getCell( 'Y' . $row )->getValue(),
                        'Z'            =>$sheet->getCell( 'Z' . $row )->getValue(),
                        'AA'            =>$sheet->getCell( 'AA' . $row )->getValue(),
                        'AB'            =>$sheet->getCell( 'AB' . $row )->getValue(),
                        'AC'            =>$sheet->getCell( 'AC' . $row )->getValue(),
                       
                        'AD'            =>$del_ad,
                        'AE'            =>$del_ae,
                        'AF'            =>$del_af,
                        'AG'            =>$del_ag,
                        'AH'            =>$del_ah,
                        'AI'            =>$del_ai,

                        'AJ'            =>$sheet->getCell( 'AJ' . $row )->getValue(),
                        'AK'            =>$sheet->getCell( 'AK' . $row )->getValue(),
                        'AL'            =>$sheet->getCell( 'AL' . $row )->getValue(),
                        'AM'            =>$sheet->getCell( 'AM' . $row )->getValue(),
                        'AN'            =>$del_an,
                        'AO'            =>$del_ao,
                        'AP'            =>$del_ap,
                        'AQ'            =>$del_aq,
                        'AR'            =>$del_ar,
                        'AS'            =>$sheet->getCell( 'AS' . $row )->getValue(),
                        'AT'            =>$sheet->getCell( 'AT' . $row )->getValue(),
                        'AU'            =>$sheet->getCell( 'AU' . $row )->getValue(),
                        'AV'            =>$sheet->getCell( 'AV' . $row )->getValue(),
                        'AW'            =>$sheet->getCell( 'AW' . $row )->getValue(),                       
                        'AX'            =>$sheet->getCell( 'AX' . $row )->getValue(), 
                        'AY'            =>$sheet->getCell( 'AY' . $row )->getValue(),                        
                        'AZ'            =>$sheet->getCell( 'AZ' . $row )->getValue(),
                        'BA'            =>$sheet->getCell( 'BA' . $row )->getValue(),
                        'BB'            =>$sheet->getCell( 'BB' . $row )->getValue(),
                        'BC'            =>$sheet->getCell( 'BC' . $row )->getValue(),
                        'BD'            =>$sheet->getCell( 'BD' . $row )->getValue(),
                        
                        'STMdoc'        =>$file_ 
                    ];
                    $startcount++; 

                }
                // DB::table('acc_stm_ucs_excel')->insert($data); 

                $for_insert = array_chunk($data, length:1000);
                foreach ($for_insert as $key => $data_) {
                    Fdh_ofc_repexcel::insert($data_); 
                }
                // Acc_stm_ucs_excel::insert($data); 
 

            } catch (Exception $e) {
                $error_code = $e->errorInfo[1];
                return back()->withErrors('There was a problem uploading the data!');
            }
            // return back()->withSuccess('Great! Data has been successfully uploaded.');
            return response()->json([
            'status'    => '200',
        ]);
    }

    public function ofc_rep_send(Request $request)
    {
        try{
            $data_ = DB::connection('mysql')->select('SELECT * FROM fdh_ofc_repexcel WHERE F IS NOT NULL');
            foreach ($data_ as $key => $value) {
                if ($value->F != '') {
                    $check = Fdh_ofc_rep::where('C','=',$value->C)->count();
                    if ($check > 0) {
                    } else {
                        $add = new Fdh_ofc_rep();
                        $add->A        = $value->A;
                        $add->B        = $value->B;
                        $add->C        = $value->C;
                        $add->D        = $value->D;
                        $add->E        = $value->E;
                        $add->F        = $value->F;
                        $add->G        = $value->G;
                        $add->H        = $value->H;
                        $add->I        = $value->I;
                        $add->J        = $value->J;
                        $add->K        = $value->K;
                        $add->L        = $value->L;
                        $add->M        = $value->M;
                        $add->N        = $value->N;
                        $add->O        = $value->O;
                        $add->P        = $value->P;
                        $add->Q        = $value->Q;
                        $add->R        = $value->R;
                        $add->S        = $value->S;
                        $add->T        = $value->T;
                        $add->U        = $value->U;
                        $add->V        = $value->V;
                        $add->W        = $value->W;
                        $add->X        = $value->X;
                        $add->Y        = $value->Y;
                        $add->Z        = $value->Z;
                        $add->AA       = $value->AA;
                        $add->AB       = $value->AB;
                        $add->AC       = $value->AC;
                        $add->AD       = $value->AD;
                        $add->AE       = $value->AE;
                        $add->AF       = $value->AF;
                        $add->AG       = $value->AG;
                        $add->AH       = $value->AH;
                        $add->AI       = $value->AI;
                        $add->AJ       = $value->AJ;
                        $add->AK       = $value->AK;
                        $add->AL       = $value->AL;
                        $add->AM       = $value->AM;
                        $add->AN       = $value->AN;
                        $add->AO       = $value->AO;
                        $add->AP       = $value->AP;
                        $add->AQ       = $value->AQ;
                        $add->AR       = $value->AR;
                        $add->AS       = $value->AS;
                        $add->AT       = $value->AT;
                        $add->AU       = $value->AU;
                        $add->AV       = $value->AV;
                        $add->AW       = $value->AW;
                        $add->AX       = $value->AX;
                        $add->AY       = $value->AY;
                        $add->AZ       = $value->AZ;
                        $add->BA       = $value->BA;
                        $add->BB       = $value->BB;
                        $add->BC       = $value->BC;
                        $add->BD       = $value->BD;
                        
                        $add->STMdoc   = $value->STMdoc;
                        $add->save();  
                    }  
                    
                        D_fdh::where('cid',$value->F)->where('vstdate',$value->I) 
                            ->update([
                                'active'          => 'R',
                                'debit_rep'       => $value->AF,
                                'error_code'      => $value->M,
                                'STMdoc'          => $value->STMdoc, 
                        ]);
                    
                   
                } else {
                }
            }
            } catch (Exception $e) {
                $error_code = $e->errorInfo[1];
                return back()->withErrors('There was a problem uploading the data!');
            }
            Fdh_ofc_repexcel::truncate();
        return redirect()->back();
    }

    public function fdh_rep_reject(Request $request)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $datashow = DB::connection('mysql')->select('
            SELECT *
            FROM fdh_noapprove_excel
            GROUP BY vn
            ');
        $countc = DB::table('fdh_noapprove_excel')->count();  
        $data['d_fdh']    = DB::connection('mysql')->select('SELECT * from d_fdh WHERE active ="N" AND authen IS NOT NULL AND icd10 IS NOT NULL ORDER BY vn ASC');  
             
        return view('fdh.fdh_rep_reject',$data,[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'datashow'      =>     $datashow,
            'countc'        =>     $countc
        ]);
    }
    function fdh_rep_reject_save(Request $request)
    { 
        $this->validate($request, [
            'file' => 'required|file|mimes:xls,xlsx'
        ]);
        $the_file = $request->file('file'); 
        $file_ = $request->file('file')->getClientOriginalName(); //ชื่อไฟล์

        // dd($the_file);
            try{ 
                // Cheet 2
                $spreadsheet = IOFactory::load($the_file->getRealPath()); 
                $sheet        = $spreadsheet->setActiveSheetIndex(0);
                $row_limit    = $sheet->getHighestDataRow();
                $column_limit = $sheet->getHighestDataColumn();
                $row_range    = range( 6, $row_limit );
                $column_range = range( 'DM', $column_limit );
                $startcount = 6;
                $data = array();
                foreach ($row_range as $row ) {
                    $vst = $sheet->getCell( 'F' . $row )->getValue();  
                    $day = substr($vst,0,2);
                    $mo = substr($vst,3,2);
                    $year = substr($vst,6,4);
                    $vstdate = $year.'-'.$mo.'-'.$day;

                    $reg = $sheet->getCell( 'G' . $row )->getValue(); 
                    $regday = substr($reg, 0, 2);
                    $regmo = substr($reg, 3, 2);
                    $regyear = substr($reg, 6, 4);
                    $regdate = $regyear.'-'.$regmo.'-'.$regday;

                    $dch = $sheet->getCell( 'H' . $row )->getValue(); 
                    $dchday = substr($dch, 0, 2);
                    $dchmo = substr($dch, 3, 2);
                    $dchyear = substr($dch, 6, 4);
                    $dchdate = $dchyear.'-'.$dchmo.'-'.$dchday; 

                    $spsch = $sheet->getCell( 'J' . $row )->getValue(); 
                    $spschday = substr($spsch, 0, 2);
                    $spschmo = substr($spsch, 3, 2);
                    $spschyear = substr($spsch, 6, 4);
                    $spschtime = substr($spsch, 11, 5);
                    $spschdate = $spschyear.'-'.$spschmo.'-'.$spschday.' '.$spschtime; 
 
                    $data[] = [ 
                        'hn'                 =>$sheet->getCell( 'B' . $row )->getValue(),
                        'vn'                 =>$sheet->getCell( 'C' . $row )->getValue(),
                        'an'                 =>$sheet->getCell( 'D' . $row )->getValue(),
                        'visit_type'         =>$sheet->getCell( 'E' . $row )->getValue(),
                        'vstdate'            =>$vstdate,
                        'regdate'            =>$regdate, 
                        'dchdate'            =>$dchdate, 
                        'UUC'                =>$sheet->getCell( 'I' . $row )->getValue(),
                        'datesend_spsch'     =>$spschdate,
                        'uid'                =>$sheet->getCell( 'K' . $row )->getValue(),
                        'hipdata_code'       =>$sheet->getCell( 'L' . $row )->getValue(),
                        'error_code'         =>$sheet->getCell( 'M' . $row )->getValue(),
                        'error_detail'       =>$sheet->getCell( 'N' . $row )->getValue(), 
                        'STMdoc'             =>$file_ 
                    ];
                    $startcount++; 

                }
                // DB::table('acc_stm_ucs_excel')->insert($data); 

                $for_insert = array_chunk($data, length:1000);
                foreach ($for_insert as $key => $data_) {
                    Fdh_noapprove_excel::insert($data_); 
                }
                // Acc_stm_ucs_excel::insert($data); 
 

            } catch (Exception $e) {
                $error_code = $e->errorInfo[1];
                return back()->withErrors('There was a problem uploading the data!');
            }
            // return back()->withSuccess('Great! Data has been successfully uploaded.');
            return response()->json([
            'status'    => '200',
        ]);
    }
    public function fdh_rep_reject_send(Request $request)
    {
        try{
                $data_ = DB::connection('mysql')->select('SELECT * FROM fdh_noapprove_excel WHERE visit_type ="IPD"');
                foreach ($data_ as $key => $value) {
                    if ($value->an != '') {
                        $check = Fdh_noapprove::where('an','=',$value->an)->where('error_code','=',$value->error_code)->count();
                        if ($check > 0) {
                        } else {
                            $add = new Fdh_noapprove();
                            $add->hn                 = $value->hn;
                            $add->vn                 = $value->vn;
                            $add->an                 = $value->an;
                            $add->visit_type         = $value->visit_type;
                            $add->vstdate            = $value->vstdate;
                            $add->regdate            = $value->regdate;
                            $add->dchdate            = $value->dchdate;
                            $add->UUC                = $value->UUC;
                            $add->datesend_spsch     = $value->datesend_spsch;
                            $add->uid                = $value->uid;
                            $add->hipdata_code       = $value->hipdata_code;
                            $add->error_code         = $value->error_code;
                            $add->error_detail       = $value->error_detail;
                            $add->nhso_reject        = $value->nhso_reject;
                            $add->STMdoc             = $value->STMdoc; 
                            $add->save();  
                        }  
                        
                        D_fdh::where('an',$value->an) 
                            ->update([
                                'active'          => 'E', 
                                'error_code'      => $value->error_code,
                                'STMdoc'          => $value->STMdoc, 
                        ]);
                        
                    
                    } else {
                    }
                }
            } catch (Exception $e) {
                $error_code = $e->errorInfo[1];
                return back()->withErrors('There was a problem uploading the data!');
            }

            try{
                $data_ = DB::connection('mysql')->select('SELECT * FROM fdh_noapprove_excel WHERE visit_type ="OPD"');
                foreach ($data_ as $key => $value) {
                    if ($value->vn != '') {
                        $check = Fdh_noapprove::where('vn','=',$value->vn)->where('error_code','=',$value->error_code)->count();
                        if ($check > 0) {
                        } else {
                            $add = new Fdh_noapprove();
                            $add->hn                 = $value->hn;
                            $add->vn                 = $value->vn;
                            $add->an                 = $value->an;
                            $add->visit_type         = $value->visit_type;
                            $add->vstdate            = $value->vstdate;
                            $add->regdate            = $value->regdate;
                            $add->dchdate            = $value->dchdate;
                            $add->UUC                = $value->UUC;
                            $add->datesend_spsch     = $value->datesend_spsch;
                            $add->uid                = $value->uid;
                            $add->hipdata_code       = $value->hipdata_code;
                            $add->error_code         = $value->error_code;
                            $add->error_detail       = $value->error_detail;
                            $add->nhso_reject        = $value->nhso_reject;
                            $add->STMdoc             = $value->STMdoc; 
                            $add->save();  
                        }  
                        
                        D_fdh::where('vn',$value->vn) 
                            ->update([
                                'active'          => 'E', 
                                'error_code'      => $value->error_code,
                                'STMdoc'          => $value->STMdoc, 
                        ]); 
                    } else {
                    }
                }
            } catch (Exception $e) {
                $error_code = $e->errorInfo[1];
                return back()->withErrors('There was a problem uploading the data!');
            }
            
            Fdh_noapprove_excel::truncate();
            
        return redirect()->back();
    }
    
 
}
