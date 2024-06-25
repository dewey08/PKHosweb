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
use App\Models\Acc_stm_ti;
use App\Models\Acc_stm_ti_total;
use App\Models\Acc_opitemrece;
use App\Models\Acc_1102050101_202;
use App\Models\Acc_1102050101_217;
use App\Models\Acc_1102050101_2166;
use App\Models\Acc_stm_ucs;
use App\Models\Acc_1102050101_304;
use App\Models\Acc_1102050101_308;
use App\Models\Acc_1102050101_4011;
use App\Models\Acc_1102050101_3099;
use App\Models\Acc_1102050101_401;
use App\Models\Acc_1102050101_402;
use App\Models\Acc_1102050102_801;
use App\Models\Acc_1102050102_802;
use App\Models\Acc_1102050102_803;
use App\Models\Acc_1102050102_804;
use App\Models\Acc_1102050101_4022;
use App\Models\Acc_1102050102_602;
use App\Models\Acc_1102050102_603;
use App\Models\Acc_1102050102_8011;
use App\Models\Acc_stm_prb;
use App\Models\Acc_stm_ti_totalhead;
use App\Models\Acc_stm_ti_excel;
use App\Models\Acc_stm_ofc;
use App\Models\Acc_stm_ofcexcel;
use App\Models\Acc_stm_lgo;
use App\Models\Acc_stm_lgoexcel;
use App\Models\Check_sit_auto;
use App\Models\Acc_stm_ucs_excel;
use App\Models\D_rep_eclaim;
use App\Models\D_rep_eclaim_excel;
use App\Models\Acc_stm_lgoti;
use App\Models\Acc_stm_repmoney_file;
use App\Models\Acc_trimart;

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
use GuzzleHttp\Client;

use App\Imports\ImportAcc_stm_ti;
use App\Imports\ImportAcc_stm_tiexcel_import;
use App\Imports\ImportAcc_stm_ofcexcel_import;
use App\Imports\ImportAcc_stm_lgoexcel_import;
use App\Models\Acc_1102050101_217_stam;
use App\Models\Acc_opitemrece_stm; 
use PHPExcel;
use PHPExcel_IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\IOFactory;
use SplFileObject;
use Arr;
date_default_timezone_set("Asia/Bangkok");
 

class UprepController extends Controller
{  
    
     public function uprep_eclaim(Request $request)
     { 
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $data['users'] = User::get(); 
        $countc = DB::table('d_rep_eclaim_excel')->count();
        $datashow = DB::table('d_rep_eclaim_excel')->get();

         return view('up_rep.uprep_eclaim', $data,[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'datashow'      =>     $datashow,
            'countc'        =>     $countc
         ]);
     }
     
    // *********************************************************

    
    function uprep_eclaim_save(Request $request)
    { 
        // $this->validate($request, [
        //     'file' => 'required|file|mimes:xls,xlsx'
        // ]);
        $the_file = $request->file('file'); 
        $file_ = $request->file('file')->getClientOriginalName(); //ชื่อไฟล์
        // dd($file_);
            try{                
                // Cheet 2  originalName
                // $spreadsheet = IOFactory::createReader($the_file);
                // $spreadsheet = IOFactory::load($the_file->getRealPath()); 
                $spreadsheet = IOFactory::load($the_file); 
                $sheet        = $spreadsheet->setActiveSheetIndex(0);
                $row_limit    = $sheet->getHighestDataRow();
                $column_limit = $sheet->getHighestDataColumn();
                $row_range    = range( 9, $row_limit );
                $column_range = range( 'AO', $column_limit );
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
                    $l= $sheet->getCell( 'L' . $row )->getValue();
                    $del_l = str_replace(",","",$l);
                    $am = $sheet->getCell( 'AM' . $row )->getValue();
                    $del_am = str_replace(",","",$am);
                    $an= $sheet->getCell( 'AN' . $row )->getValue();
                    $del_an = str_replace(",","",$an);
                    $ao = $sheet->getCell( 'AO' . $row )->getValue();
                    $del_ao = str_replace(",","",$ao);
                    $ap = $sheet->getCell( 'AP' . $row )->getValue();
                    $del_ap = str_replace(",","",$ap);
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
                    $del_bz = str_replace(",","",$bz);
                    $cc= $sheet->getCell( 'CC' . $row )->getValue();
                    $del_cc = str_replace(",","",$cc);
                    $ce = $sheet->getCell( 'CE' . $row )->getValue();
                    $del_ce = str_replace(",","",$ce);
                    $cg = $sheet->getCell( 'CG' . $row )->getValue();
                    $del_cg = str_replace(",","",$cg);
                    $cn = $sheet->getCell( 'CN' . $row )->getValue();
                    $del_cn = str_replace(",","",$cn);
                    $cr = $sheet->getCell( 'CR' . $row )->getValue();
                    $del_cr = str_replace(",","",$cr);
                    $cs = $sheet->getCell( 'CS' . $row )->getValue();
                    $del_cs= str_replace(",","",$cs);
                    $df = $sheet->getCell( 'DF' . $row )->getValue();
                    $del_df= str_replace(",","",$df);

                    // $rep_ = $sheet->getCell( 'A' . $row )->getValue();
 
                    $data[] = [
                        'a'                   =>$sheet->getCell( 'A' . $row )->getValue(),
                        'b'                   =>$sheet->getCell( 'B' . $row )->getValue(),
                        'c'                   =>$sheet->getCell( 'C' . $row )->getValue(),
                        'd'                   =>$sheet->getCell( 'D' . $row )->getValue(),
                        'e'                   =>$sheet->getCell( 'E' . $row )->getValue(),
                        'f'                   =>$sheet->getCell( 'F' . $row )->getValue(),
                        'g'                   =>$sheet->getCell( 'G' . $row )->getValue(), 
                        'h'                   =>$sheet->getCell( 'H' . $row )->getValue(),
                        'i'                   =>$vstdate,
                        'j'                   =>$dchdate,  
                        'k'                   =>$sheet->getCell( 'K' . $row )->getValue(),
                        'l'                   =>$sheet->getCell( 'L' . $row )->getValue(),
                        'm'                   =>$sheet->getCell( 'M' . $row )->getValue(),
                        'n'                   =>$sheet->getCell( 'N' . $row )->getValue(),
                        'o'                   =>$sheet->getCell( 'O' . $row )->getValue(),
                        'p'                   =>$sheet->getCell( 'P' . $row )->getValue(),
                        'q'                   =>$sheet->getCell( 'Q' . $row )->getValue(), 
                        'r'                   =>$sheet->getCell( 'R' . $row )->getValue(), 
                        's'                   =>$sheet->getCell( 'S' . $row )->getValue(), 
                        't'                   =>$sheet->getCell( 'T' . $row )->getValue(), 
                        'u'                   =>$sheet->getCell( 'U' . $row )->getValue(), 
                        'v'                   =>$sheet->getCell( 'V' . $row )->getValue(), 
                        'w'                   =>$sheet->getCell( 'W' . $row )->getValue(), 
                        'x'                   =>$sheet->getCell( 'X' . $row )->getValue(), 
                        'y'                   =>$sheet->getCell( 'Y' . $row )->getValue(), 
                        'z'                   =>$sheet->getCell( 'Z' . $row )->getValue(), 
                        'aa'                  =>$sheet->getCell( 'AA' . $row )->getValue(), 
                        'ab'                  =>$sheet->getCell( 'AB' . $row )->getValue(), 
                        'ac'                  =>$sheet->getCell( 'AC' . $row )->getValue(), 
                        'ad'                  =>$sheet->getCell( 'AD' . $row )->getValue(), 
                        'ae'                  =>$sheet->getCell( 'AE' . $row )->getValue(), 
                        'af'                  =>$sheet->getCell( 'AF' . $row )->getValue(), 
                        'ag'                  =>$sheet->getCell( 'AG' . $row )->getValue(), 
                        'ah'                  =>$sheet->getCell( 'AH' . $row )->getValue(), 
                        'ai'                  =>$sheet->getCell( 'AI' . $row )->getValue(), 
                        'ak'                  =>$sheet->getCell( 'AK' . $row )->getValue(), 
                        'al'                  =>$sheet->getCell( 'AL' . $row )->getValue(), 
                        'am'                  =>$del_am,
                        'an'                  =>$del_an,
                        'ao'                  =>$del_ao,
                        'ap'                  =>$del_ap,
                        'aq'                  =>$del_aq,
                        'ar'                  =>$del_ar,
                        'ass'                 =>$sheet->getCell( 'AS' . $row )->getValue(), 
                        'att'                 =>$sheet->getCell( 'AT' . $row )->getValue(), 
                        'au'                  =>$sheet->getCell( 'AU' . $row )->getValue(), 
                        'av'                  =>$sheet->getCell( 'AV' . $row )->getValue(), 
                        'aw'                  =>$sheet->getCell( 'AW' . $row )->getValue(), 
                        'ax'                  =>$del_ax,
                        'ay'                  =>$del_ay,
                        'az'                  =>$sheet->getCell( 'AZ' . $row )->getValue(), 
                        'ba'                  =>$sheet->getCell( 'BA' . $row )->getValue(), 
                        'bb'                  =>$del_bb,
                        'bc'                  =>$sheet->getCell( 'BC' . $row )->getValue(), 
                        'bd'                  =>$sheet->getCell( 'BD' . $row )->getValue(), 
                        'be'                  =>$sheet->getCell( 'BE' . $row )->getValue(), 
                        'bf'                  =>$sheet->getCell( 'BF' . $row )->getValue(), 
                        'bg'                  =>$sheet->getCell( 'BG' . $row )->getValue(), 
                        'bh'                  =>$sheet->getCell( 'BH' . $row )->getValue(), 
                        'bi'                  =>$sheet->getCell( 'BI' . $row )->getValue(), 
                        'bj'                  =>$sheet->getCell( 'BJ' . $row )->getValue(), 
                        'bk'                  =>$sheet->getCell( 'BK' . $row )->getValue(), 
                        'bl'                  =>$sheet->getCell( 'BL' . $row )->getValue(), 
                        'bm'                  =>$sheet->getCell( 'BM' . $row )->getValue(), 
                        'bn'                  =>$sheet->getCell( 'BN' . $row )->getValue(), 
                        'bo'                  =>$sheet->getCell( 'BO' . $row )->getValue(), 
                        'bp'                  =>$sheet->getCell( 'BP' . $row )->getValue(), 
                        'bq'                  =>$sheet->getCell( 'BQ' . $row )->getValue(), 
                        'br'                  =>$sheet->getCell( 'BR' . $row )->getValue(), 
                        'bs'                  =>$sheet->getCell( 'BS' . $row )->getValue(), 
                        'bt'                  =>$sheet->getCell( 'BT' . $row )->getValue(), 
                        'bu'                  =>$sheet->getCell( 'BU' . $row )->getValue(), 
                        'bv'                  =>$sheet->getCell( 'BV' . $row )->getValue(), 
                        'bw'                  =>$sheet->getCell( 'BW' . $row )->getValue(), 
                        'bx'                  =>$sheet->getCell( 'BX' . $row )->getValue(), 
                        'byy'                 =>$del_by,
                        'bz'                  =>$del_bz,
                        'ca'                  =>$sheet->getCell( 'CA' . $row )->getValue(), 
                        'cb'                  =>$sheet->getCell( 'CB' . $row )->getValue(), 
                        'cc'                  =>$del_cc,
                        'cd'                  =>$sheet->getCell( 'CD' . $row )->getValue(),
                        'ce'                  =>$del_ce,
                        'cf'                  =>$sheet->getCell( 'CF' . $row )->getValue(),
                        'cg'                  =>$del_cg,
                        'ch'                  =>$sheet->getCell( 'CH' . $row )->getValue(),
                        'ci'                  =>$sheet->getCell( 'CI' . $row )->getValue(),
                        'cj'                  =>$sheet->getCell( 'CJ' . $row )->getValue(),
                        'ck'                  =>$sheet->getCell( 'CK' . $row )->getValue(),
                        'cl'                  =>$sheet->getCell( 'CL' . $row )->getValue(),
                        'cm'                  =>$sheet->getCell( 'CM' . $row )->getValue(),
                        'cn'                  =>$del_cn,
                        'co'                  =>$sheet->getCell( 'CO' . $row )->getValue(),
                        'cp'                  =>$sheet->getCell( 'CP' . $row )->getValue(),
                        'cq'                  =>$sheet->getCell( 'CQ' . $row )->getValue(),
                        'cr'                  =>$del_cr,
                        'cs'                  =>$del_cs,
                        'ct'                  =>$sheet->getCell( 'CT' . $row )->getValue(),
                        'cu'                  =>$sheet->getCell( 'CU' . $row )->getValue(),
                        'cv'                  =>$sheet->getCell( 'CV' . $row )->getValue(),
                        'cw'                  =>$sheet->getCell( 'CW' . $row )->getValue(),
                        'cx'                  =>$sheet->getCell( 'CX' . $row )->getValue(),
                        'cy'                  =>$sheet->getCell( 'CY' . $row )->getValue(),
                        'cz'                  =>$sheet->getCell( 'CZ' . $row )->getValue(),
                        'da'                  =>$sheet->getCell( 'DA' . $row )->getValue(),
                        'db'                  =>$sheet->getCell( 'DB' . $row )->getValue(),
                        'dc'                  =>$sheet->getCell( 'DC' . $row )->getValue(),
                        'dd'                  =>$sheet->getCell( 'DD' . $row )->getValue(),
                        'de'                  =>$sheet->getCell( 'DE' . $row )->getValue(),
                        'df'                  =>$del_df, 
                        'dg'                  =>$sheet->getCell( 'DG' . $row )->getValue(),
                        'dh'                  =>$sheet->getCell( 'DH' . $row )->getValue(),
                        'di'                  =>$sheet->getCell( 'DI' . $row )->getValue(),
                        'STMdoc'              =>$file_ 
                    ];
                    $startcount++; 

                }
                // DB::table('acc_stm_ucs_excel')->insert($data); 

                // $for_insert = array_chunk($data, length:1000);
                // foreach ($for_insert as $key => $data_) {
                //     D_rep_eclaim_excel::insert($data_); 
                // }



                foreach (array_chunk($data,500) as $t)  
                { 
                    DB::table('d_rep_eclaim_excel')->insert($t);
                }

               
                 
                // $the_file->delete('public/File_eclaim/'.$file_); 
                $the_file->storeAs('Import/',$file_);   // ย้าย ไฟล์   
                Storage::delete('File_eclaim/'.$file_);   // ลบไฟล์  
                // ลบไฟล์   
                if(file_exists(public_path('File_eclaim/'.$file_))){
                    unlink(public_path('File_eclaim/'.$file_));
                    // Storage::delete('File_eclaim/'.$file_);   // ลบไฟล์  
                }else{
                    dd('File does not exists.');
                }
                
                // $the_file->storeAs('Import/',$file_);   // ย้าย ไฟล์   
                // foreach (array_chunk($data,500) as $t)  
                // {
                //     // DB::table('table_name')->insert($t);
                //     // D_rep_eclaim_excel::insert($t);  
                //     DB::table('d_rep_eclaim_excel')->insert($t);
                // }
                // $folder = 'OP';
                // mkdir('Import/' . $folder, 0777, true);  //Web  
              
                // File::move('Import/OP'.$file_, 'Import_New/'.$file_);
                // storeAs('article',$file_,'public');
                  
                // Storage::move('Import/'.$file_, $the_file);
                // File::move(public_path('exist/test.png'), public_path('move/test_move.png'));  
                // $the_file->storeAs('Import/'.$file_, '/Import'.$file_); 
                // $pathdir = public_path('Import/'.$file_);
                // File::move("File_eclaim/".$file_, $pathdir);
                // $description = "File_eclaim/".$file_;
                // if (File::exists($description))
                // {
                //     File::delete($description);
                // }

                // if(File::exists(public_path('File_eclaim/',$file_)))
                // { 
                //     File::delete(public_path('File_eclaim/',$file_)); 
                // }
                // else
                // { 
                //     dd('File does not exists.');
                // } 
                // if (file_exists($pathdir)) {
                //     // header('Content-Type: application/zip');
                //     // header('Content-Disposition: attachment; filename="'.basename($pathdir).'"');
                //     // header('Content-Length: ' . filesize($pathdir));
                //     // flush();
                //     // readfile($pathdir);
                //     //// delete file
                //     unlink($pathdir);        
                //     $files = glob($pathdir . '/*');     
                //     foreach($files as $file) {                         
                //         //// Check for file 
                //         if(is_file($file)) {    
                //             unlink($file); 
                //         } 
                //     }                     
                //     // if(rmdir($pathdir)){ // ลบ folder ใน export                    
                //     // }                    
                //     // return redirect()->route('data.ucep24_claim');                    
                // }
                // $filepath = public_path('Import/'.$file_);
                // unlink($filepath);
                
                
            } catch (Exception $e) {
                $error_code = $e->errorInfo[1];
                return back()->withErrors('There was a problem uploading the data!');
            }
            // return redirect()->back();
            return response()->json([
                'status'    => '200',
            ]);
    }

    public function uprep_eclaim_send(Request $request)
    {

        try{
            $data_ = DB::connection('mysql')->select('
                SELECT *
                FROM d_rep_eclaim_excel
            ');
                foreach ($data_ as $key => $value) {
                    if ($value->b != '') {
                        $check = D_rep_eclaim::where('a','=',$value->a)->where('b','=',$value->b)->count();
                        if ($check > 0) {
                        } else {
                            D_rep_eclaim::insert([
                                'a'               =>$value->a,
                                'b'                   =>$value->b,
                                'c'                   =>$value->c,
                                'd'                   =>$value->d,
                                'e'                   =>$value->e,
                                'f'                   =>$value->f,
                                'g'                   =>$value->g, 
                                'h'                   =>$value->h,
                                'i'                   =>$value->i,
                                'j'                   =>$value->j,  
                                'k'                   =>$value->k,
                                'l'                   =>$value->l,
                                'm'                   =>$value->m,
                                'n'                   =>$value->n,
                                'o'                   =>$value->o,
                                'p'                   =>$value->p,
                                'q'                   =>$value->q, 
                                'r'                   =>$value->r, 
                                's'                   =>$value->s, 
                                't'                   =>$value->t, 
                                'u'                   =>$value->u, 
                                'v'                   =>$value->v, 
                                'w'                   =>$value->w, 
                                'x'                   =>$value->x, 
                                'y'                   =>$value->y, 
                                'z'                   =>$value->z, 
                                'aa'                  =>$value->aa, 
                                'ab'                  =>$value->ab, 
                                'ac'                  =>$value->ac, 
                                'ad'                  =>$value->ad, 
                                'ae'                  =>$value->ae, 
                                'af'                  =>$value->af, 
                                'ag'                  =>$value->ag, 
                                'ah'                  =>$value->ah, 
                                'ai'                  =>$value->ai, 
                                'ak'                  =>$value->ak, 
                                'al'                  =>$value->al, 
                                'am'                  =>$value->am,
                                'an'                  =>$value->an,
                                'ao'                  =>$value->ao,
                                'ap'                  =>$value->ap,
                                'aq'                  =>$value->aq,
                                'ar'                  =>$value->ar,
                                'ass'                 =>$value->ass, 
                                'att'                 =>$value->att, 
                                'au'                  =>$value->au, 
                                'av'                  =>$value->av, 
                                'aw'                  =>$value->aw, 
                                'ax'                  =>$value->ax,
                                'ay'                  =>$value->ay,
                                'az'                  =>$value->az, 
                                'ba'                  =>$value->ba, 
                                'bb'                  =>$value->bb,
                                'bc'                  =>$value->bc, 
                                'bd'                  =>$value->bd, 
                                'be'                  =>$value->be, 
                                'bf'                  =>$value->bf, 
                                'bg'                  =>$value->bg, 
                                'bh'                  =>$value->bh, 
                                'bi'                  =>$value->bi, 
                                'bj'                  =>$value->bj, 
                                'bk'                  =>$value->bk, 
                                'bl'                  =>$value->bl, 
                                'bm'                  =>$value->bm, 
                                'bn'                  =>$value->bn, 
                                'bo'                  =>$value->bo, 
                                'bp'                  =>$value->bp, 
                                'bq'                  =>$value->bq, 
                                'br'                  =>$value->br, 
                                'bs'                  =>$value->bs, 
                                'bt'                  =>$value->bt, 
                                'bu'                  =>$value->bu, 
                                'bv'                  =>$value->bv, 
                                'bw'                  =>$value->bw, 
                                'bx'                  =>$value->bx, 
                                'byy'                 =>$value->byy,
                                'bz'                  =>$value->bz,
                                'ca'                  =>$value->ca, 
                                'cb'                  =>$value->cb, 
                                'cc'                  =>$value->cc,
                                'cd'                  =>$value->cd,
                                'ce'                  =>$value->ce,
                                'cf'                  =>$value->cf,
                                'cg'                  =>$value->cg,
                                'ch'                  =>$value->ch,
                                'ci'                  =>$value->ci,
                                'cj'                  =>$value->cj,
                                'ck'                  =>$value->ck,
                                'cl'                  =>$value->cl,
                                'cm'                  =>$value->cm,
                                'cn'                  =>$value->cn,
                                'co'                  =>$value->co,
                                'cp'                  =>$value->cp,
                                'cq'                  =>$value->cq,
                                'cr'                  =>$value->cr,
                                'cs'                  =>$value->cs,
                                'ct'                  =>$value->ct,
                                'cu'                  =>$value->cu,
                                'cv'                  =>$value->cv,
                                'cw'                  =>$value->cw,
                                'cx'                  =>$value->cx,
                                'cy'                  =>$value->cy,
                                'cz'                  =>$value->cz,
                                'da'                  =>$value->da,
                                'db'                  =>$value->db,
                                'dc'                  =>$value->dc,
                                'dd'                  =>$value->dd,
                                'de'                  =>$value->de,
                                'df'                  =>$value->df, 
                                'dg'                  =>$value->dg,
                                'dh'                  =>$value->dh,
                                'di'                  =>$value->di,
                                'STMdoc'              =>$value->STMdoc
                            ]);
                            
                        }
                    } else {
                    }
                }
            } catch (Exception $e) {
                $error_code = $e->errorInfo[1];
                return back()->withErrors('There was a problem uploading the data!');
            }
            D_rep_eclaim_excel::truncate();


        return redirect()->back();
    }
    
   
    

   
}

