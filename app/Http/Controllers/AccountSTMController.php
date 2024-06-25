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
use App\Models\Acc_1102050101_216;
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
use App\Models\Acc_stm_repmoney;
use App\Models\Acc_stm_lgoti_excel;
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
// use File;
// use SplFileObject;
use Arr;
// use Storage;
use GuzzleHttp\Client;

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
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\IOFactory;

date_default_timezone_set("Asia/Bangkok");


class AccountSTMController extends Controller
{   
    public function upstm_ofcexcel(Request $request)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $datashow = DB::connection('mysql')->select('
                SELECT repno,vstdate,SUM(pricereq_all) as Sumprice,STMdoc,month(vstdate) as months
                FROM acc_stm_ofcexcel
                GROUP BY repno
            ');
        $countc = DB::table('acc_stm_ofcexcel')->count();
        // dd($countc );
        return view('account_pk.upstm_ofcexcel',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'datashow'      =>     $datashow,
            'countc'        =>     $countc
        ]);
    }
    // upstm_ofcexcel_senddata
    public function upstm_ofcexcel_save(Request $request)
    {
            // Excel::import(new ImportAcc_stm_ofcexcel_import, $request->file('file')->store('files'));
            //  return response()->json([
            //     'status'    => '200',
            // ]);

            $this->validate($request, [
                'file' => 'required|file|mimes:xls,xlsx'
            ]);
            $the_file = $request->file('file');
            $file_ = $request->file('file')->getClientOriginalName(); //ชื่อไฟล์

            try{
                $spreadsheet = IOFactory::load($the_file->getRealPath());
                // $sheet        = $spreadsheet->getActiveSheet();
                $sheet        = $spreadsheet->setActiveSheetIndex(0);
                $row_limit    = $sheet->getHighestDataRow();
                $column_limit = $sheet->getHighestDataColumn();
                $row_range    = range( '12', $row_limit );
                $column_range = range( 'AO', $column_limit );
                $startcount = '12';
                // $row_range_namefile  = range( 9, $sheet->getCell( 'A' . $row )->getValue() );
                $data = array();
                foreach ($row_range as $row ) {

                    $vst = $sheet->getCell( 'G' . $row )->getValue();
                    // $starttime = substr($vst, 0, 5);
                    $day = substr($vst,0,2);
                    $mo = substr($vst,3,2);
                    $year = substr($vst,7,4);
                    $vstdate = $year.'-'.$mo.'-'.$day;
 
                    $reg = $sheet->getCell( 'H' . $row )->getValue();
                    // $starttime = substr($reg, 0, 5);
                    $regday = substr($reg, 0, 2);
                    $regmo = substr($reg, 3, 2);
                    $regyear = substr($reg, 7, 4);
                    $dchdate = $regyear.'-'.$regmo.'-'.$regday;

                    $k = $sheet->getCell( 'K' . $row )->getValue();
                    $del_k = str_replace(",","",$k);
                    $l = $sheet->getCell( 'L' . $row )->getValue();
                    $del_l = str_replace(",","",$l);
                    $m = $sheet->getCell( 'M' . $row )->getValue();
                    $del_m = str_replace(",","",$m);
                    $n = $sheet->getCell( 'N' . $row )->getValue();
                    $del_n = str_replace(",","",$n);
                    $o = $sheet->getCell( 'O' . $row )->getValue();
                    $del_o = str_replace(",","",$o);
                    $p = $sheet->getCell( 'P' . $row )->getValue();
                    $del_p = str_replace(",","",$p);
                    $q = $sheet->getCell( 'Q' . $row )->getValue();
                    $del_q = str_replace(",","",$q);
                    $r = $sheet->getCell( 'R' . $row )->getValue();
                    $del_r = str_replace(",","",$r);
                    $s = $sheet->getCell( 'S' . $row )->getValue();
                    $del_s = str_replace(",","",$s);
                    $t = $sheet->getCell( 'T' . $row )->getValue();
                    $del_t = str_replace(",","",$t);
                        $data[] = [
                            'repno'                   =>$sheet->getCell( 'A' . $row )->getValue(),
                            'no'                      =>$sheet->getCell( 'B' . $row )->getValue(),
                            'hn'                      =>$sheet->getCell( 'C' . $row )->getValue(),
                            'an'                      =>$sheet->getCell( 'D' . $row )->getValue(),
                            'cid'                     =>$sheet->getCell( 'E' . $row )->getValue(),
                            'fullname'                =>$sheet->getCell( 'F' . $row )->getValue(),
                            'vstdate'                 =>$vstdate,
                            'dchdate'                 =>$dchdate,
                            'PROJCODE'                =>$sheet->getCell( 'I' . $row )->getValue(),
                            'AdjRW'                   =>$sheet->getCell( 'J' . $row )->getValue(),
                            'price_req'               =>$del_k,
                            'prb'                     =>$del_l,
                            'room'                    =>$del_m,
                            'inst'                    =>$del_n,
                            'drug'                    =>$del_o,
                            'income'                  =>$del_p,
                            'refer'                   =>$del_q,
                            'waitdch'                 =>$del_r,
                            'service'                 =>$del_s,
                            'pricereq_all'            =>$del_t,
                            'STMdoc'                  =>$file_
                        ]; 
                    $startcount++;
                    
                }
                $for_insert = array_chunk($data, length:1000);
                foreach ($for_insert as $key => $data_) {
                   
                        Acc_stm_ofcexcel::insert($data_); 
                   
                    
                    
                }
                // DB::table('acc_stm_ofcexcel')->insert($data);
            } catch (Exception $e) {
                $error_code = $e->errorInfo[1];
                return back()->withErrors('There was a problem uploading the data!');
            }
               return response()->json([
                'status'    => '200',
            ]);
    }

    public function upstm_bkkexcel(Request $request)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $datashow = DB::connection('mysql')->select('
                SELECT repno,vstdate,SUM(pricereq_all) as Sumprice,STMdoc,month(vstdate) as months
                FROM acc_stm_ofcexcel
                GROUP BY repno
            ');
        $countc = DB::table('acc_stm_ofcexcel')->count();
        // dd($countc );
        return view('account_pk.upstm_bkkexcel',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'datashow'      =>     $datashow,
            'countc'        =>     $countc
        ]);
    }



    public function upstm_ofcexcel_senddata(Request $request)
    {        
        // dd($type);
        try{
                $data_ = DB::connection('mysql')->select('
                    SELECT *
                    FROM acc_stm_ofcexcel
                    WHERE income <> "" AND repno <> ""
                    
                ');
                $type = $request->type;
                
                foreach ($data_ as $key => $value) {
                    // $value->no != '' && $value->repno != 'REP' &&
                    if ($value->repno != 'REP%' || $value->repno != '') {
                            $check = Acc_stm_ofc::where('repno','=',$value->repno)->where('no','=',$value->no)->count();
                            if ($check > 0) {
                            //     $add = Acc_stm_ofc::where('repno','=',$value->repno)->where('no','=',$value->no)->update([
                            //         'type'     => $type
                            //     ]); 
                            } else {
                                $add = new Acc_stm_ofc();
                                $add->repno          = $value->repno;
                                $add->no             = $value->no;
                                $add->hn             = $value->hn;
                                $add->an             = $value->an;
                                $add->cid            = $value->cid;
                                $add->fullname       = $value->fullname;
                                $add->vstdate        = $value->vstdate;
                                $add->dchdate        = $value->dchdate;
                                $add->PROJCODE       = $value->PROJCODE;
                                $add->AdjRW          = $value->AdjRW;
                                $add->price_req      = $value->price_req;
                                $add->prb            = $value->prb;
                                $add->room           = $value->room;
                                $add->inst           = $value->inst;
                                $add->drug           = $value->drug;
                                $add->income         = $value->income;
                                $add->refer          = $value->refer;
                                $add->waitdch        = $value->waitdch;
                                $add->service        = $value->service;
                                $add->pricereq_all   = $value->pricereq_all;
                                $add->STMdoc         = $value->STMdoc;
                                $add->type           = $type;
                                $add->save(); 
                            }  
                            // $check401 = Acc_1102050101_401::where('cid',$value->cid)->where('vstdate',$value->vstdate)->where('STMdoc',NULL)->count();
                            // if ($check401 > 0) {
                            //     Acc_1102050101_401::where('cid',$value->cid)->where('vstdate',$value->vstdate)
                            //     ->update([
                            //         'stm_rep'         => $value->price_req,
                            //         'stm_money'       => $value->pricereq_all,
                            //         'stm_rcpno'       => $value->repno.'-'.$value->no,
                            //         'stm_total'       => $value->pricereq_all,
                            //         'STMdoc'          => $value->STMdoc,
                            //     ]); 
                            // }   
                    } else {
                        # code...
                    }
                     
                }
        } catch (Exception $e) {
            $error_code = $e->errorInfo[1];
            return back()->withErrors('There was a problem uploading the data!');
        }
        
        return response()->json([
                'status'    => '200',
            ]);
    }
   
    
    public function upstm_lgoexcel_save(Request $request)
    { 
            $this->validate($request, [
                'file' => 'required|file|mimes:xls,xlsx'
            ]);
            $the_file = $request->file('file');
            $file_ = $request->file('file')->getClientOriginalName(); //ชื่อไฟล์

            try{
                $spreadsheet = IOFactory::load($the_file->getRealPath()); 
                $sheet        = $spreadsheet->setActiveSheetIndex(0);
                $row_limit    = $sheet->getHighestDataRow();
                $column_limit = $sheet->getHighestDataColumn();
                $row_range    = range( '8', $row_limit );
                $column_range = range( 'AO', $column_limit );
                $startcount = '8';
                // $row_range_namefile  = range( 9, $sheet->getCell( 'A' . $row )->getValue() );
                $data = array();
                foreach ($row_range as $row ) {

                    $vst = $sheet->getCell( 'I' . $row )->getValue();
                    // $starttime = substr($vst, 0, 5);
                    $day = substr($vst,0,2);
                    $mo = substr($vst,3,2);
                    $year = substr($vst,6,4);
                    $vstdate = $year.'-'.$mo.'-'.$day;

                    $dch = $sheet->getCell( 'J' . $row )->getValue();
                    // $starttime = substr($vst, 0, 5);
                    $day2 = substr($dch,0,2);
                    $mo2 = substr($dch,3,2);
                    $year2 = substr($dch,6,4);
                    $dchdate = $year2.'-'.$mo2.'-'.$day2;
  
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
                    $an = $sheet->getCell( 'AN' . $row )->getValue();
                    $del_an = str_replace(",","",$an);
                    $ao = $sheet->getCell( 'AO' . $row )->getValue();
                    $del_ao = str_replace(",","",$ao);
                    $ap = $sheet->getCell( 'AP' . $row )->getValue();
                    $del_ap = str_replace(",","",$ap);
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
                        $data[] = [
                            'rep_a'                   =>$sheet->getCell( 'A' . $row )->getValue(),
                            'no_b'                    =>$sheet->getCell( 'B' . $row )->getValue(),
                            'tranid_c'                =>$sheet->getCell( 'C' . $row )->getValue(),
                            'hn_d'                    =>$sheet->getCell( 'D' . $row )->getValue(),
                            'an_e'                    =>$sheet->getCell( 'E' . $row )->getValue(),
                            'cid_f'                   =>$sheet->getCell( 'F' . $row )->getValue(),
                            'fullname_g'              =>$sheet->getCell( 'G' . $row )->getValue(),
                            'type_h'                  =>$sheet->getCell( 'H' . $row )->getValue(),
                            'vstdate_i'               =>$vstdate,
                            'dchdate_j'               =>$dchdate, 
                            'price1_k'                =>$del_k,
                            'pp_spsch_l'              =>$del_l,
                            'errorcode_m'             =>$sheet->getCell( 'M' . $row )->getValue(),
                            'kongtoon_n'              =>$sheet->getCell( 'N' . $row )->getValue(),
                            'typeservice_o'           =>$sheet->getCell( 'O' . $row )->getValue(),
                            'refer_p'                 =>$sheet->getCell( 'P' . $row )->getValue(),
                            'pttype_have_q'           =>$sheet->getCell( 'Q' . $row )->getValue(),
                            'pttype_true_r'           =>$sheet->getCell( 'R' . $row )->getValue(),
                            'mian_pttype_s'           =>$sheet->getCell( 'S' . $row )->getValue(),
                            'secon_pttype_t'          =>$sheet->getCell( 'T' . $row )->getValue(),
                            'href_u'                  =>$sheet->getCell( 'U' . $row )->getValue(),
                            'HCODE_v'                 =>$sheet->getCell( 'V' . $row )->getValue(),
                            'prov1_w'                 =>$sheet->getCell( 'W' . $row )->getValue(),
                            'code_dep_x'              =>$sheet->getCell( 'X' . $row )->getValue(),
                            'name_dep_y'              =>$sheet->getCell( 'Y' . $row )->getValue(),
                            'proj_z'                  =>$sheet->getCell( 'Z' . $row )->getValue(),
                            'pa_aa'                   =>$sheet->getCell( 'AA' . $row )->getValue(),
                            'drg_ab'                  =>$sheet->getCell( 'AB' . $row )->getValue(),
                            'rw_ac'                   =>$sheet->getCell( 'AC' . $row )->getValue(),
                            'income_ad'               =>$del_ad,
                            'pp_gep_ae'               =>$del_ae,
                            'claim_true_af'           =>$del_af,
                            'claim_false_ag'          =>$del_ag,
                            'cash_money_ah'           =>$del_ah,
                            'pay_ai'                  =>$del_ai,
                            'ps_aj'                   =>$sheet->getCell( 'AJ' . $row )->getValue(),
                            'ps_percent_ak'           =>$sheet->getCell( 'AK' . $row )->getValue(),
                            'ccuf_al'                 =>$sheet->getCell( 'AL' . $row )->getValue(),
                            'AdjRW_am'                =>$sheet->getCell( 'AM' . $row )->getValue(),
                            'plb_an'                  =>$del_an,
                            'IPLG_ao'                 =>$del_ao,
                            'OPLG_ap'                 =>$del_ap,
                            'PALG_aq'                 =>$del_aq,
                            'INSTLG_ar'               =>$del_ar,
                            'OTLG_as'                 =>$del_as,
                            'PP_at'                   =>$del_at,
                            'DRUG_au'                 =>$del_au,
                            'IPLG2'                   =>$sheet->getCell( 'AV' . $row )->getValue(),
                            'OPLG2'                   =>$sheet->getCell( 'AW' . $row )->getValue(),
                            'PALG2'                   =>$sheet->getCell( 'AX' . $row )->getValue(),
                            'INSTLG2'                 =>$sheet->getCell( 'AY' . $row )->getValue(),
                            'OTLG2'                   =>$sheet->getCell( 'AZ' . $row )->getValue(),
                            'ORS'                     =>$sheet->getCell( 'BA' . $row )->getValue(),
                            'VA'                      =>$sheet->getCell( 'BB' . $row )->getValue(),
                            'STMdoc'                  =>$file_
                        ]; 
                    $startcount++;
                    
                }
                $for_insert = array_chunk($data, length:1000);
                foreach ($for_insert as $key => $data_) {                     
                        Acc_stm_lgoexcel::insert($data_);                       
                }
             
            } catch (Exception $e) {
                $error_code = $e->errorInfo[1];
                return back()->withErrors('There was a problem uploading the data!');
            }
               return response()->json([
                'status'    => '200',
            ]);
    }
   
    

    // public function upstm_ucs(Request $request)
    // {
    //     $datenow = date('Y-m-d');
    //     $startdate = $request->startdate;
    //     $enddate = $request->enddate;
    //     $datashow = DB::connection('mysql')->select('
    //         SELECT rep,vstdate,SUM(ip_paytrue) as Sumprice,STMdoc,month(vstdate) as months
    //         FROM acc_stm_ucs_excel
    //         GROUP BY rep
    //         ');
    //     $countc = DB::table('acc_stm_ucs_excel')->count();
    //     // dd($countc );
    //     // SELECT STMDoc,SUM(total_approve) as total FROM acc_stm_ucs GROUP BY STMDoc
    //     return view('account_pk.upstm_ucs',[
    //         'startdate'     =>     $startdate,
    //         'enddate'       =>     $enddate,
    //         'datashow'      =>     $datashow,
    //         'countc'        =>     $countc
    //     ]);
    // }
    // function upstm_ucsopdsave(Request $request)
    // { 
    //     // $this->validate($request, [
    //     //     'file' => 'required|file|mimes:xls,xlsx'
    //     // ]);
    //     $the_file = $request->file('file'); 
    //     $file_ = $request->file('file')->getClientOriginalName(); //ชื่อไฟล์

    //     // dd($the_file);
    //         try{
    //             // $a = array('2','3');
    //             // foreach($a as $value){
    //             //     $table_insert = $sss[0];
    //             //     $sheet_read = $sss[1];
    //             //     // code($sheet_read)
    //             //     // insert_table $table_insert
    //             // }

    //             // Cheet 2
    //             $spreadsheet = IOFactory::load($the_file->getRealPath()); 
    //             $sheet        = $spreadsheet->setActiveSheetIndex(2);
    //             $row_limit    = $sheet->getHighestDataRow();
    //             $column_limit = $sheet->getHighestDataColumn();
    //             $row_range    = range( 15, $row_limit );
    //             $column_range = range( 'AO', $column_limit );
    //             $startcount = 15;
    //             $data = array();
    //             foreach ($row_range as $row ) {
    //                 $vst = $sheet->getCell( 'H' . $row )->getValue();  
    //                 $day = substr($vst,0,2);
    //                 $mo = substr($vst,3,2);
    //                 $year = substr($vst,6,4);
    //                 $vstdate = $year.'-'.$mo.'-'.$day;

    //                 $reg = $sheet->getCell( 'I' . $row )->getValue(); 
    //                 $regday = substr($reg, 0, 2);
    //                 $regmo = substr($reg, 3, 2);
    //                 $regyear = substr($reg, 6, 4);
    //                 $dchdate = $regyear.'-'.$regmo.'-'.$regday;

    //                 $s = $sheet->getCell( 'S' . $row )->getValue();
    //                 $del_s = str_replace(",","",$s);
    //                 $t = $sheet->getCell( 'T' . $row )->getValue();
    //                 $del_t = str_replace(",","",$t);
    //                 $u = $sheet->getCell( 'U' . $row )->getValue();
    //                 $del_u = str_replace(",","",$u);
    //                 $v= $sheet->getCell( 'V' . $row )->getValue();
    //                 $del_v = str_replace(",","",$v);
    //                 $w = $sheet->getCell( 'W' . $row )->getValue();
    //                 $del_w = str_replace(",","",$w);
    //                 $x = $sheet->getCell( 'X' . $row )->getValue();
    //                 $del_x = str_replace(",","",$x);
    //                 $y = $sheet->getCell( 'Y' . $row )->getValue();
    //                 $del_y = str_replace(",","",$y);
    //                 $z = $sheet->getCell( 'Z' . $row )->getValue();
    //                 $del_z = str_replace(",","",$z);
    //                 $aa = $sheet->getCell( 'AA' . $row )->getValue();
    //                 $del_aa = str_replace(",","",$aa);
    //                 $ab = $sheet->getCell( 'AB' . $row )->getValue();
    //                 $del_ab = str_replace(",","",$ab);
    //                 $ac = $sheet->getCell( 'AC' . $row )->getValue();
    //                 $del_ac = str_replace(",","",$ac);
    //                 $ad = $sheet->getCell( 'AD' . $row )->getValue();
    //                 $del_ad = str_replace(",","",$ad);
    //                 $ae = $sheet->getCell( 'AE' . $row )->getValue();
    //                 $del_ae = str_replace(",","",$ae);
    //                 $af= $sheet->getCell( 'AF' . $row )->getValue();
    //                 $del_af = str_replace(",","",$af);
    //                 $ag = $sheet->getCell( 'AG' . $row )->getValue();
    //                 $del_ag = str_replace(",","",$ag);
    //                 $ah = $sheet->getCell( 'AH' . $row )->getValue();
    //                 $del_ah = str_replace(",","",$ah);
    //                 $ai = $sheet->getCell( 'AI' . $row )->getValue();
    //                 $del_ai = str_replace(",","",$ai);
    //                 $aj = $sheet->getCell( 'AJ' . $row )->getValue();
    //                 $del_aj = str_replace(",","",$aj);
    //                 $ak = $sheet->getCell( 'AK' . $row )->getValue();
    //                 $del_ak = str_replace(",","",$ak);
    //                 $al = $sheet->getCell( 'AL' . $row )->getValue();
    //                 $del_al = str_replace(",","",$al);

    //                 // $rep_ = $sheet->getCell( 'A' . $row )->getValue();
 
    //                 $data[] = [
    //                     'rep'                   =>$sheet->getCell( 'A' . $row )->getValue(),
    //                     'repno'                 =>$sheet->getCell( 'B' . $row )->getValue(),
    //                     'tranid'                =>$sheet->getCell( 'C' . $row )->getValue(),
    //                     'hn'                    =>$sheet->getCell( 'D' . $row )->getValue(),
    //                     'an'                    =>$sheet->getCell( 'E' . $row )->getValue(),
    //                     'cid'                   =>$sheet->getCell( 'F' . $row )->getValue(),
    //                     'fullname'              =>$sheet->getCell( 'G' . $row )->getValue(), 
    //                     'vstdate'               =>$vstdate,
    //                     'dchdate'               =>$dchdate, 
    //                     'maininscl'             =>$sheet->getCell( 'J' . $row )->getValue(),
    //                     'projectcode'           =>$sheet->getCell( 'K' . $row )->getValue(),
    //                     'debit'                 =>$sheet->getCell( 'L' . $row )->getValue(),
    //                     'debit_prb'             =>$sheet->getCell( 'M' . $row )->getValue(),
    //                     'adjrw'                 =>$sheet->getCell( 'N' . $row )->getValue(),
    //                     'ps1'                   =>$sheet->getCell( 'O' . $row )->getValue(),
    //                     'ps2'                   =>$sheet->getCell( 'P' . $row )->getValue(),
    //                     'ccuf'                  =>$sheet->getCell( 'Q' . $row )->getValue(),
    //                     'adjrw2'                =>$sheet->getCell( 'R' . $row )->getValue(), 
    //                     'pay_money'             => $del_s,
    //                     'pay_slip'              => $del_t,
    //                     'pay_after'             => $del_u,
    //                     'op'                    => $del_v,
    //                     'ip_pay1'               => $del_w,
    //                     'ip_paytrue'            => $del_x,
    //                     'hc'                    => $del_y,
    //                     'hc_drug'               => $del_z,
    //                     'ae'                    => $del_aa,
    //                     'ae_drug'               => $del_ab,
    //                     'inst'                  => $del_ac,
    //                     'dmis_money1'           => $del_ad,
    //                     'dmis_money2'           => $del_ae,
    //                     'dmis_drug'             => $del_af,
    //                     'palliative_care'       => $del_ag,
    //                     'dmishd'                => $del_ah,
    //                     'pp'                    => $del_ai,
    //                     'fs'                    => $del_aj,
    //                     'opbkk'                 => $del_ak,
    //                     'total_approve'         => $del_al, 
    //                     'va'                    =>$sheet->getCell( 'AM' . $row )->getValue(),
    //                     'covid'                 =>$sheet->getCell( 'AN' . $row )->getValue(),
    //                     // 'ao'                    =>$sheet->getCell( 'AO' . $row )->getValue(),
    //                     'STMdoc'                =>$file_ 
    //                 ];
    //                 $startcount++; 

    //             }
    //             // DB::table('acc_stm_ucs_excel')->insert($data); 

    //             $for_insert = array_chunk($data, length:1000);
    //             foreach ($for_insert as $key => $data_) {
    //                 Acc_stm_ucs_excel::insert($data_); 
    //             }
    //             // Acc_stm_ucs_excel::insert($data); 

                
    //             // Cheet 3
    //             $spreadsheet2 = IOFactory::load($the_file->getRealPath()); 
    //             $sheet2        = $spreadsheet2->setActiveSheetIndex(3);
    //             $row_limit2    = $sheet2->getHighestDataRow();
    //             $column_limit2 = $sheet2->getHighestDataColumn();
    //             $row_range2    = range( '15', $row_limit2 );
    //             $column_range2 = range( 'AO', $column_limit2 );
    //             $startcount2 = '15';
    //             $data2 = array();
    //             foreach ($row_range2 as $row2 ) {
    //                 $vst2 = $sheet2->getCell( 'H' . $row2 )->getValue();  
    //                 $day2 = substr($vst2,0,2);
    //                 $mo2 = substr($vst2,3,2);
    //                 $year2 = substr($vst2,6,4);
    //                 $vstdate2 = $year2.'-'.$mo2.'-'.$day2;

    //                 $reg2 = $sheet2->getCell( 'I' . $row2 )->getValue(); 
    //                 $regday2 = substr($reg2, 0, 2);
    //                 $regmo2 = substr($reg2, 3, 2);
    //                 $regyear2 = substr($reg2, 6, 4);
    //                 $dchdate2 = $regyear2.'-'.$regmo2.'-'.$regday2;

    //                 $ss = $sheet2->getCell( 'S' . $row2 )->getValue();
    //                 $del_ss = str_replace(",","",$ss);
    //                 $tt = $sheet2->getCell( 'T' . $row2 )->getValue();
    //                 $del_tt = str_replace(",","",$tt);
    //                 $uu = $sheet2->getCell( 'U' . $row2 )->getValue();
    //                 $del_uu = str_replace(",","",$uu);
    //                 $vv= $sheet2->getCell( 'V' . $row2 )->getValue();
    //                 $del_vv = str_replace(",","",$vv);
    //                 $ww = $sheet2->getCell( 'W' . $row2 )->getValue();
    //                 $del_ww = str_replace(",","",$ww);
    //                 $xx = $sheet2->getCell( 'X' . $row2 )->getValue();
    //                 $del_xx = str_replace(",","",$xx);
    //                 $yy = $sheet2->getCell( 'Y' . $row2 )->getValue();
    //                 $del_yy = str_replace(",","",$yy);
    //                 $zz = $sheet2->getCell( 'Z' . $row2 )->getValue();
    //                 $del_zz = str_replace(",","",$zz);
    //                 $aa2 = $sheet2->getCell( 'AA' . $row2 )->getValue();
    //                 $del_aa2 = str_replace(",","",$aa2);
    //                 $ab2 = $sheet2->getCell( 'AB' . $row2 )->getValue();
    //                 $del_ab2 = str_replace(",","",$ab2);
    //                 $ac2 = $sheet2->getCell( 'AC' . $row2 )->getValue();
    //                 $del_ac2 = str_replace(",","",$ac2);
    //                 $ad2 = $sheet2->getCell( 'AD' . $row2 )->getValue();
    //                 $del_ad2 = str_replace(",","",$ad2);
    //                 $ae2 = $sheet2->getCell( 'AE' . $row2 )->getValue();
    //                 $del_ae2 = str_replace(",","",$ae2);
    //                 $af2= $sheet2->getCell( 'AF' . $row2 )->getValue();
    //                 $del_af2 = str_replace(",","",$af2);
    //                 $ag2 = $sheet2->getCell( 'AG' . $row2 )->getValue();
    //                 $del_ag2 = str_replace(",","",$ag2);
    //                 $ah2 = $sheet2->getCell( 'AH' . $row2 )->getValue();
    //                 $del_ah2 = str_replace(",","",$ah2);
    //                 $ai2 = $sheet2->getCell( 'AI' . $row2 )->getValue();
    //                 $del_ai2 = str_replace(",","",$ai2);
    //                 $aj2 = $sheet2->getCell( 'AJ' . $row2 )->getValue();
    //                 $del_aj2 = str_replace(",","",$aj2);
    //                 $ak2 = $sheet2->getCell( 'AK' . $row2 )->getValue();
    //                 $del_ak2 = str_replace(",","",$ak2);
    //                 $al2 = $sheet2->getCell( 'AL' . $row2 )->getValue();
    //                 $del_al2 = str_replace(",","",$al2);

 
    //                 $data2[] = [
    //                     'rep'                   =>$sheet2->getCell( 'A' . $row2 )->getValue(),
    //                     'repno'                 =>$sheet2->getCell( 'B' . $row2 )->getValue(),
    //                     'tranid'                =>$sheet2->getCell( 'C' . $row2 )->getValue(),
    //                     'hn'                    =>$sheet2->getCell( 'D' . $row2 )->getValue(),
    //                     'an'                    =>$sheet2->getCell( 'E' . $row2 )->getValue(),
    //                     'cid'                   =>$sheet2->getCell( 'F' . $row2 )->getValue(),
    //                     'fullname'              =>$sheet2->getCell( 'G' . $row2 )->getValue(), 
    //                     'vstdate'               =>$vstdate2,
    //                     'dchdate'               =>$dchdate2, 
    //                     'maininscl'             =>$sheet2->getCell( 'J' . $row2 )->getValue(),
    //                     'projectcode'           =>$sheet2->getCell( 'K' . $row2 )->getValue(),
    //                     'debit'                 =>$sheet2->getCell( 'L' . $row2 )->getValue(),
    //                     'debit_prb'             =>$sheet2->getCell( 'M' . $row2 )->getValue(),
    //                     'adjrw'                 =>$sheet2->getCell( 'N' . $row2 )->getValue(),
    //                     'ps1'                   =>$sheet2->getCell( 'O' . $row2 )->getValue(),
    //                     'ps2'                   =>$sheet2->getCell( 'P' . $row2 )->getValue(),
    //                     'ccuf'                  =>$sheet2->getCell( 'Q' . $row2 )->getValue(),
    //                     'adjrw2'                =>$sheet2->getCell( 'R' . $row2 )->getValue(), 
    //                     'pay_money'             => $del_ss,
    //                     'pay_slip'              => $del_tt,
    //                     'pay_after'             => $del_uu,
    //                     'op'                    => $del_vv,
    //                     'ip_pay1'               => $del_ww,
    //                     'ip_paytrue'            => $del_xx,
    //                     'hc'                    => $del_yy,
    //                     'hc_drug'               => $del_zz,
    //                     'ae'                    => $del_aa2,
    //                     'ae_drug'               => $del_ab2,
    //                     'inst'                  => $del_ac2,
    //                     'dmis_money1'           => $del_ad2,
    //                     'dmis_money2'           => $del_ae2,
    //                     'dmis_drug'             => $del_af2,
    //                     'palliative_care'       => $del_ag2,
    //                     'dmishd'                => $del_ah2,
    //                     'pp'                    => $del_ai2,
    //                     'fs'                    => $del_aj2,
    //                     'opbkk'                 => $del_ak2,
    //                     'total_approve'         => $del_al2, 
    //                     'va'                    =>$sheet2->getCell( 'AM' . $row2 )->getValue(),
    //                     'covid'                 =>$sheet2->getCell( 'AN' . $row2 )->getValue(),
    //                     // 'ao'                    =>$sheet->getCell( 'AO' . $row )->getValue(),
    //                     'STMdoc'                =>$file_ 
    //                 ];
    //                 $startcount2++; 

    //             }
    //             // DB::table('acc_stm_ucs_excel')->Transaction::insert($data2); 
    //             $for_insert2 = array_chunk($data2, length:1000);
    //             foreach ($for_insert2 as $key => $data2_) {
    //                 Acc_stm_ucs_excel::insert($data2_); 
    //             }



    //         } catch (Exception $e) {
    //             $error_code = $e->errorInfo[1];
    //             return back()->withErrors('There was a problem uploading the data!');
    //         }
    //         // return back()->withSuccess('Great! Data has been successfully uploaded.');
    //         return response()->json([
    //         'status'    => '200',
    //     ]);
    // }

    // public function upstm_ucs_sendexcel(Request $request)
    // {
    //     try{
    //         $data_ = DB::connection('mysql')->select('
    //             SELECT *
    //             FROM acc_stm_ucs_excel
    //         ');
    //         foreach ($data_ as $key => $value) {
    //             if ($value->cid != '') {
    //                 $check = Acc_stm_ucs::where('tranid','=',$value->tranid)->count();
    //                 if ($check > 0) {
    //                 } else {
    //                     $add = new Acc_stm_ucs();
    //                     $add->rep            = $value->rep;
    //                     $add->repno          = $value->repno;
    //                     $add->tranid         = $value->tranid;
    //                     $add->hn             = $value->hn;
    //                     $add->an             = $value->an;
    //                     $add->cid            = $value->cid;
    //                     $add->fullname       = $value->fullname;
    //                     $add->vstdate        = $value->vstdate;
    //                     $add->dchdate        = $value->dchdate;
    //                     $add->maininscl      = $value->maininscl;
    //                     $add->projectcode    = $value->projectcode;
    //                     $add->debit          = $value->debit;
    //                     $add->debit_prb      = $value->debit_prb;
    //                     $add->adjrw          = $value->adjrw;
    //                     $add->ps1            = $value->ps1;
    //                     $add->ps2            = $value->ps2;

    //                     $add->ccuf           = $value->ccuf;
    //                     $add->adjrw2         = $value->adjrw2;
    //                     $add->pay_money      = $value->pay_money;
    //                     $add->pay_slip       = $value->pay_slip;
    //                     $add->pay_after      = $value->pay_after;
    //                     $add->op             = $value->op;
    //                     $add->ip_pay1        = $value->ip_pay1;
    //                     $add->ip_paytrue     = $value->ip_paytrue;
    //                     $add->hc             = $value->hc;
    //                     $add->hc_drug        = $value->hc_drug;
    //                     $add->ae             = $value->ae;
    //                     $add->ae_drug        = $value->ae_drug;
    //                     $add->inst           = $value->inst;
    //                     $add->dmis_money1    = $value->dmis_money1;
    //                     $add->dmis_money2    = $value->dmis_money2;
    //                     $add->dmis_drug      = $value->dmis_drug;
    //                     $add->palliative_care = $value->palliative_care;
    //                     $add->dmishd         = $value->dmishd;
    //                     $add->pp             = $value->pp;
    //                     $add->fs             = $value->fs;
    //                     $add->opbkk          = $value->opbkk;
    //                     $add->total_approve  = $value->total_approve;
    //                     $add->va             = $value->va;
    //                     $add->covid          = $value->covid;
    //                     $add->date_save      = $value->date_save;
    //                     $add->STMdoc         = $value->STMdoc;
    //                     $add->save(); 
    //                     // $check202 = Acc_1102050101_202::where('an',$value->an)->where('STMdoc',NULL)->count();               
    //                     // if ($check202 > 0) {                            
    //                         // AND (s.hc_drug+ s.hc+ s.ae_drug+s.inst+s.dmis_money2 + s.dmis_drug <> 0 OR s.hc_drug+ s.hc+ s.ae_drug+s.inst+s.dmis_money2 + s.dmis_drug <> "") 
    //                     // } else {                
    //                     //     Acc_1102050101_202::where('an',$value->an) 
    //                     //     ->update([
    //                     //             'status'          => 'Y',
    //                     //             'stm_rep'         => $value->debit,
    //                     //             'stm_money'       => $value->ip_paytrue,
    //                     //             'stm_rcpno'       => $value->rep.'-'.$value->repno,
    //                     //             'stm_trainid'     => $value->tranid,
    //                     //             'STMdoc'          => $value->STMdoc,
    //                     //     ]);
    //                     // }     
    //                 } 

    //                 if ($value->ip_paytrue == "0.00") {
    //                     Acc_1102050101_202::where('an',$value->an) 
    //                         ->update([
    //                             'status'          => 'Y',
    //                             'stm_rep'         => $value->debit,
    //                             // 'stm_money'       => $value->ip_paytrue,
    //                             'stm_rcpno'       => $value->rep.'-'.$value->repno,
    //                             'stm_trainid'     => $value->tranid,
    //                             'stm_total'       => $value->total_approve,
    //                             'STMdoc'          => $value->STMdoc,
    //                             'va'              => $value->va,
    //                     ]);
    //                 }else if ($value->ip_paytrue > "0.00") {
    //                         Acc_1102050101_202::where('an',$value->an) 
    //                             ->update([
    //                                 'status'          => 'Y',
    //                                 'stm_rep'         => $value->debit,
    //                                 'stm_money'       => $value->ip_paytrue,
    //                                 'stm_rcpno'       => $value->rep.'-'.$value->repno,
    //                                 'stm_trainid'     => $value->tranid,
    //                                 'stm_total'       => $value->total_approve,
    //                                 'STMdoc'          => $value->STMdoc,
    //                                 'va'              => $value->va,
    //                         ]);
    //                 } else {
    //                 }

    //                 if ($value->hc_drug+$value->hc+$value->ae+$value->ae_drug+$value->inst+$value->dmis_money2+$value->dmis_drug == "0") {
    //                     Acc_1102050101_217::where('an',$value->an) 
    //                         ->update([
    //                             'status'          => 'Y',
    //                             'stm_rep'         => $value->debit,
    //                             // 'stm_money'       => $value->hc_drug+$value->hc+$value->ae+$value->ae_drug+$value->inst+$value->dmis_money2+$value->dmis_drug,
    //                             'stm_rcpno'       => $value->rep.'-'.$value->repno,
    //                             'stm_trainid'     => $value->tranid,
    //                             'stm_total'       => $value->total_approve,
    //                             'STMdoc'          => $value->STMdoc,
    //                             'va'              => $value->va,
    //                     ]);
    //                 }else if ($value->hc_drug+$value->hc+$value->ae+$value->ae_drug+$value->inst+$value->dmis_money2+$value->dmis_drug > "0") {
    //                     Acc_1102050101_217::where('an',$value->an) 
    //                         ->update([
    //                             'status'          => 'Y',
    //                             'stm_rep'         => $value->debit,
    //                             'stm_money'       => $value->hc_drug+$value->hc+$value->ae+$value->ae_drug+$value->inst+$value->dmis_money2+$value->dmis_drug,
    //                             'stm_rcpno'       => $value->rep.'-'.$value->repno,
    //                             'stm_trainid'     => $value->tranid,
    //                             'stm_total'       => $value->total_approve,
    //                             'STMdoc'          => $value->STMdoc,
    //                             'va'              => $value->va,
    //                     ]);
    //                 } else {    
    //                 }
                    
                    

    //             } else {
    //             }
    //         }
    //         } catch (Exception $e) {
    //             $error_code = $e->errorInfo[1];
    //             return back()->withErrors('There was a problem uploading the data!');
    //         }
    //         Acc_stm_ucs_excel::truncate();
    //     return redirect()->back();
    // }

    public function upstm_ucsopd(Request $request)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $datashow = DB::connection('mysql')->select('
            SELECT rep,vstdate,SUM(ip_paytrue) as Sumprice,STMdoc,month(vstdate) as months
            FROM acc_stm_ucs_excel
            GROUP BY rep
            ');
        $countc = DB::table('acc_stm_ucs_excel')->count(); 
        return view('account_pk.upstm_ucsopd',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'datashow'      =>     $datashow,
            'countc'        =>     $countc
        ]);
    }
    function upstm_ucsopdsave(Request $request)
    { 
        // $this->validate($request, [
        //     'file' => 'required|file|mimes:xls,xlsx'
        // ]);
        $the_file = $request->file('file_stm'); 
        $file_ = $request->file('file_stm')->getClientOriginalName(); //ชื่อไฟล์

        // dd($the_file);
            // try{
                 
                // Cheet 2
                $spreadsheet = IOFactory::load($the_file->getRealPath()); 
                $sheet        = $spreadsheet->setActiveSheetIndex(2);
                $row_limit    = $sheet->getHighestDataRow();
                $column_limit = $sheet->getHighestDataColumn();
                $row_range    = range('15',$row_limit );
                // $column_range = range('AQ',$column_limit );
                $startcount = '15';
                $data = array();
                foreach ($row_range as $row ) {
                    $vst = $sheet->getCell( 'H' . $row )->getValue();  
                    $day = substr($vst,0,2);
                    $mo = substr($vst,3,2);
                    $year = substr($vst,6,4);
                    $vstdate = $year.'-'.$mo.'-'.$day;

                    $reg = $sheet->getCell( 'I' . $row )->getValue(); 
                    $regday = substr($reg, 0, 2);
                    $regmo = substr($reg, 3, 2);
                    $regyear = substr($reg, 6, 4);
                    $dchdate = $regyear.'-'.$regmo.'-'.$regday;

                    $s = $sheet->getCell( 'S' . $row )->getValue();
                    $del_s = str_replace(",","",$s);
                    $t = $sheet->getCell( 'T' . $row )->getValue();
                    $del_t = str_replace(",","",$t);
                    $u = $sheet->getCell( 'U' . $row )->getValue();
                    $del_u = str_replace(",","",$u);
                    $v= $sheet->getCell( 'V' . $row )->getValue();
                    $del_v = str_replace(",","",$v);
                    $w = $sheet->getCell( 'W' . $row )->getValue();
                    $del_w = str_replace(",","",$w);
                    $x = $sheet->getCell( 'X' . $row )->getValue();
                    $del_x = str_replace(",","",$x);
                    $y = $sheet->getCell( 'Y' . $row )->getValue();
                    $del_y = str_replace(",","",$y);
                    $z = $sheet->getCell( 'Z' . $row )->getValue();
                    $del_z = str_replace(",","",$z);
                    $aa = $sheet->getCell( 'AA' . $row )->getValue();
                    $del_aa = str_replace(",","",$aa);
                    $ab = $sheet->getCell( 'AB' . $row )->getValue();
                    $del_ab = str_replace(",","",$ab);
                    $ac = $sheet->getCell( 'AC' . $row )->getValue();
                    $del_ac = str_replace(",","",$ac);
                    $ad = $sheet->getCell( 'AD' . $row )->getValue();
                    $del_ad = str_replace(",","",$ad);
                    $ae = $sheet->getCell( 'AE' . $row )->getValue();
                    $del_ae = str_replace(",","",$ae);
                    $af= $sheet->getCell( 'AF' . $row )->getValue();
                    $del_af = str_replace(",","",$af);
                    $ag = $sheet->getCell( 'AG' . $row )->getValue();
                    $del_ag = str_replace(",","",$ag);
                    $ah = $sheet->getCell( 'AH' . $row )->getValue();
                    $del_ah = str_replace(",","",$ah);
                    $ai = $sheet->getCell( 'AI' . $row )->getValue();
                    $del_ai = str_replace(",","",$ai);
                    $aj = $sheet->getCell( 'AJ' . $row )->getValue();
                    $del_aj = str_replace(",","",$aj);
                    $ak = $sheet->getCell( 'AK' . $row )->getValue();
                    $del_ak = str_replace(",","",$ak);
                    $al = $sheet->getCell( 'AL' . $row )->getValue();
                    $del_al = str_replace(",","",$al);
 
                    $data[] = [
                        'rep'                   =>$sheet->getCell( 'A' . $row )->getValue(),
                        'repno'                 =>$sheet->getCell( 'B' . $row )->getValue(),
                        'tranid'                =>$sheet->getCell( 'C' . $row )->getValue(),
                        'hn'                    =>$sheet->getCell( 'D' . $row )->getValue(),
                        'an'                    =>$sheet->getCell( 'E' . $row )->getValue(),
                        'cid'                   =>$sheet->getCell( 'F' . $row )->getValue(),
                        'fullname'              =>$sheet->getCell( 'G' . $row )->getValue(), 
                        'vstdate'               =>$vstdate,
                        'dchdate'               =>$dchdate, 
                        'maininscl'             =>$sheet->getCell( 'J' . $row )->getValue(),
                        'projectcode'           =>$sheet->getCell( 'K' . $row )->getValue(),
                        'debit'                 =>$sheet->getCell( 'L' . $row )->getValue(),
                        'debit_prb'             =>$sheet->getCell( 'M' . $row )->getValue(),
                        'adjrw'                 =>$sheet->getCell( 'N' . $row )->getValue(),
                        'ps1'                   =>$sheet->getCell( 'O' . $row )->getValue(),
                        'ps2'                   =>$sheet->getCell( 'P' . $row )->getValue(),
                        'ccuf'                  =>$sheet->getCell( 'Q' . $row )->getValue(),
                        'adjrw2'                =>$sheet->getCell( 'R' . $row )->getValue(), 
                        'pay_money'             => $del_s,
                        'pay_slip'              => $del_t,
                        'pay_after'             => $del_u,
                        'op'                    => $del_v,
                        'ip_pay1'               => $del_w,
                        'ip_paytrue'            => $del_x,
                        'hc'                    => $del_y,
                        'hc_drug'               => $del_z,
                        'ae'                    => $del_aa,
                        'ae_drug'               => $del_ab,
                        'inst'                  => $del_ac,
                        'dmis_money1'           => $del_ad,
                        'dmis_money2'           => $del_ae,
                        'dmis_drug'             => $del_af,
                        'palliative_care'       => $del_ag,
                        'dmishd'                => $del_ah,
                        'pp'                    => $del_ai,
                        'fs'                    => $del_aj,
                        'opbkk'                 => $del_ak,
                        'total_approve'         => $del_al, 
                        'va'                    =>$sheet->getCell( 'AM' . $row )->getValue(),
                        'covid'                 =>$sheet->getCell( 'AN' . $row )->getValue(),
                        // 'ao'                    =>$sheet->getCell( 'AO' . $row )->getValue(),
                        'STMdoc'                =>$file_ 
                    ];
                    $startcount++; 

                }
                // DB::table('acc_stm_ucs_excel')->insert($data); 

                $for_insert = array_chunk($data, length:1000);
                foreach ($for_insert as $key => $data_) {
                    Acc_stm_ucs_excel::insert($data_); 
                }
                // Acc_stm_ucs_excel::insert($data);  

                // Cheet 3
                $spreadsheet2 = IOFactory::load($the_file->getRealPath()); 
                $sheet2        = $spreadsheet2->setActiveSheetIndex(3);
                $row_limit2    = $sheet2->getHighestDataRow();
                $column_limit2 = $sheet2->getHighestDataColumn();
                $row_range2    = range('15',$row_limit2 );
                // $column_range2 = range('AQ',$column_limit2 );
                $startcount2 = '15';
                $data2 = array();
                foreach ($row_range2 as $row2 ) {
                    $vst2 = $sheet2->getCell( 'H' . $row2 )->getValue();  
                    $day2 = substr($vst2,0,2);
                    $mo2 = substr($vst2,3,2);
                    $year2 = substr($vst2,6,4);
                    $vstdate2 = $year2.'-'.$mo2.'-'.$day2;

                    $reg2 = $sheet2->getCell( 'I' . $row2 )->getValue(); 
                    $regday2 = substr($reg2, 0, 2);
                    $regmo2 = substr($reg2, 3, 2);
                    $regyear2 = substr($reg2, 6, 4);
                    $dchdate2 = $regyear2.'-'.$regmo2.'-'.$regday2;

                    $ss = $sheet2->getCell( 'S' . $row2 )->getValue();
                    $del_ss = str_replace(",","",$ss);
                    $tt = $sheet2->getCell( 'T' . $row2 )->getValue();
                    $del_tt = str_replace(",","",$tt);
                    $uu = $sheet2->getCell( 'U' . $row2 )->getValue();
                    $del_uu = str_replace(",","",$uu);
                    $vv= $sheet2->getCell( 'V' . $row2 )->getValue();
                    $del_vv = str_replace(",","",$vv);
                    $ww = $sheet2->getCell( 'W' . $row2 )->getValue();
                    $del_ww = str_replace(",","",$ww);
                    $xx = $sheet2->getCell( 'X' . $row2 )->getValue();
                    $del_xx = str_replace(",","",$xx);
                    $yy = $sheet2->getCell( 'Y' . $row2 )->getValue();
                    $del_yy = str_replace(",","",$yy);
                    $zz = $sheet2->getCell( 'Z' . $row2 )->getValue();
                    $del_zz = str_replace(",","",$zz);
                    $aa2 = $sheet2->getCell( 'AA' . $row2 )->getValue();
                    $del_aa2 = str_replace(",","",$aa2);
                    $ab2 = $sheet2->getCell( 'AB' . $row2 )->getValue();
                    $del_ab2 = str_replace(",","",$ab2);
                    $ac2 = $sheet2->getCell( 'AC' . $row2 )->getValue();
                    $del_ac2 = str_replace(",","",$ac2);
                    $ad2 = $sheet2->getCell( 'AD' . $row2 )->getValue();
                    $del_ad2 = str_replace(",","",$ad2);
                    $ae2 = $sheet2->getCell( 'AE' . $row2 )->getValue();
                    $del_ae2 = str_replace(",","",$ae2);
                    $af2= $sheet2->getCell( 'AF' . $row2 )->getValue();
                    $del_af2 = str_replace(",","",$af2);
                    $ag2 = $sheet2->getCell( 'AG' . $row2 )->getValue();
                    $del_ag2 = str_replace(",","",$ag2);
                    $ah2 = $sheet2->getCell( 'AH' . $row2 )->getValue();
                    $del_ah2 = str_replace(",","",$ah2);
                    $ai2 = $sheet2->getCell( 'AI' . $row2 )->getValue();
                    $del_ai2 = str_replace(",","",$ai2);
                    $aj2 = $sheet2->getCell( 'AJ' . $row2 )->getValue();
                    $del_aj2 = str_replace(",","",$aj2);
                    $ak2 = $sheet2->getCell( 'AK' . $row2 )->getValue();
                    $del_ak2 = str_replace(",","",$ak2);
                    $al2 = $sheet2->getCell( 'AL' . $row2 )->getValue();
                    $del_al2 = str_replace(",","",$al2);

 
                    $data2[] = [
                        'rep'                   =>$sheet2->getCell( 'A' . $row2 )->getValue(),
                        'repno'                 =>$sheet2->getCell( 'B' . $row2 )->getValue(),
                        'tranid'                =>$sheet2->getCell( 'C' . $row2 )->getValue(),
                        'hn'                    =>$sheet2->getCell( 'D' . $row2 )->getValue(),
                        'an'                    =>$sheet2->getCell( 'E' . $row2 )->getValue(),
                        'cid'                   =>$sheet2->getCell( 'F' . $row2 )->getValue(),
                        'fullname'              =>$sheet2->getCell( 'G' . $row2 )->getValue(), 
                        'vstdate'               =>$vstdate2,
                        'dchdate'               =>$dchdate2, 
                        'maininscl'             =>$sheet2->getCell( 'J' . $row2 )->getValue(),
                        'projectcode'           =>$sheet2->getCell( 'K' . $row2 )->getValue(),
                        'debit'                 =>$sheet2->getCell( 'L' . $row2 )->getValue(),
                        'debit_prb'             =>$sheet2->getCell( 'M' . $row2 )->getValue(),
                        'adjrw'                 =>$sheet2->getCell( 'N' . $row2 )->getValue(),
                        'ps1'                   =>$sheet2->getCell( 'O' . $row2 )->getValue(),
                        'ps2'                   =>$sheet2->getCell( 'P' . $row2 )->getValue(),
                        'ccuf'                  =>$sheet2->getCell( 'Q' . $row2 )->getValue(),
                        'adjrw2'                =>$sheet2->getCell( 'R' . $row2 )->getValue(), 
                        'pay_money'             => $del_ss,
                        'pay_slip'              => $del_tt,
                        'pay_after'             => $del_uu,
                        'op'                    => $del_vv,
                        'ip_pay1'               => $del_ww,
                        'ip_paytrue'            => $del_xx,
                        'hc'                    => $del_yy,
                        'hc_drug'               => $del_zz,
                        'ae'                    => $del_aa2,
                        'ae_drug'               => $del_ab2,
                        'inst'                  => $del_ac2,
                        'dmis_money1'           => $del_ad2,
                        'dmis_money2'           => $del_ae2,
                        'dmis_drug'             => $del_af2,
                        'palliative_care'       => $del_ag2,
                        'dmishd'                => $del_ah2,
                        'pp'                    => $del_ai2,
                        'fs'                    => $del_aj2,
                        'opbkk'                 => $del_ak2,
                        'total_approve'         => $del_al2, 
                        'va'                    =>$sheet2->getCell( 'AM' . $row2 )->getValue(),
                        'covid'                 =>$sheet2->getCell( 'AN' . $row2 )->getValue(),
                        // 'ao'                    =>$sheet->getCell( 'AO' . $row )->getValue(),
                        'STMdoc'                =>$file_ 
                    ];
                    $startcount2++; 

                }
                // DB::table('acc_stm_ucs_excel')->Transaction::insert($data2); 
                $for_insert2 = array_chunk($data2, length:1000);
                foreach ($for_insert2 as $key => $data2_) {
                    Acc_stm_ucs_excel::insert($data2_); 
                }
 
            // } catch (Exception $e) {
            //     $error_code = $e->errorInfo[1];
            //     return back()->withErrors('There was a problem uploading the data!');
            // }
            return redirect()->back();
            // return response()->json([
            //     'status'    => '200',
            // ]);
    }
    public function upstm_ucsopdsend(Request $request)
    {
        try{
            $data_ = DB::connection('mysql')->select('SELECT * FROM acc_stm_ucs_excel WHERE cid IS NOT NULL');
            foreach ($data_ as $key => $value) {
                if ($value->cid != '') {
                    $check = Acc_stm_ucs::where('tranid','=',$value->tranid)->count();
                    if ($check > 0) {
                    } else {
                        $add = new Acc_stm_ucs();
                        $add->rep            = $value->rep;
                        $add->repno          = $value->repno;
                        $add->tranid         = $value->tranid;
                        $add->hn             = $value->hn;
                        $add->an             = $value->an;
                        $add->cid            = $value->cid;
                        $add->fullname       = $value->fullname;
                        $add->vstdate        = $value->vstdate;
                        $add->dchdate        = $value->dchdate;
                        $add->maininscl      = $value->maininscl;
                        $add->projectcode    = $value->projectcode;
                        $add->debit          = $value->debit;
                        $add->debit_prb      = $value->debit_prb;
                        $add->adjrw          = $value->adjrw;
                        $add->ps1            = $value->ps1;
                        $add->ps2            = $value->ps2;

                        $add->ccuf           = $value->ccuf;
                        $add->adjrw2         = $value->adjrw2;
                        $add->pay_money      = $value->pay_money;
                        $add->pay_slip       = $value->pay_slip;
                        $add->pay_after      = $value->pay_after;
                        $add->op             = $value->op;
                        $add->ip_pay1        = $value->ip_pay1;
                        $add->ip_paytrue     = $value->ip_paytrue;
                        $add->hc             = $value->hc;
                        $add->hc_drug        = $value->hc_drug;
                        $add->ae             = $value->ae;
                        $add->ae_drug        = $value->ae_drug;
                        $add->inst           = $value->inst;
                        $add->dmis_money1    = $value->dmis_money1;
                        $add->dmis_money2    = $value->dmis_money2;
                        $add->dmis_drug      = $value->dmis_drug;
                        $add->palliative_care = $value->palliative_care;
                        $add->dmishd         = $value->dmishd;
                        $add->pp             = $value->pp;
                        $add->fs             = $value->fs;
                        $add->opbkk          = $value->opbkk;
                        $add->total_approve  = $value->total_approve;
                        $add->va             = $value->va;
                        $add->covid          = $value->covid;
                        $add->date_save      = $value->date_save;
                        $add->STMdoc         = $value->STMdoc;
                        $add->save(); 
                     
                    } 

                    // if ($value->ip_paytrue == "0.00") {
                    //     Acc_1102050101_202::where('an',$value->an) 
                    //         ->update([
                    //             'status'          => 'Y',
                    //             'stm_rep'         => $value->debit,
                    //             // 'stm_money'       => $value->ip_paytrue,
                    //             'stm_rcpno'       => $value->rep.'-'.$value->repno,
                    //             'stm_trainid'     => $value->tranid,
                    //             'stm_total'       => $value->total_approve,
                    //             'STMdoc'          => $value->STMdoc,
                    //             'va'              => $value->va,
                    //     ]);
                    // }else if ($value->ip_paytrue > "0.00") {
                    //         Acc_1102050101_202::where('an',$value->an) 
                    //             ->update([
                    //                 'status'          => 'Y',
                    //                 'stm_rep'         => $value->debit,
                    //                 'stm_money'       => $value->ip_paytrue,
                    //                 'stm_rcpno'       => $value->rep.'-'.$value->repno,
                    //                 'stm_trainid'     => $value->tranid,
                    //                 'stm_total'       => $value->total_approve,
                    //                 'STMdoc'          => $value->STMdoc,
                    //                 'va'              => $value->va,
                    //         ]);
                    // } else {
                    // }

                    if ($value->hc_drug+$value->hc+$value->ae+$value->ae_drug+$value->inst+$value->dmis_money2+$value->dmis_drug == "0") {
                        
                        Acc_1102050101_216::where('hn',$value->hn)->where('vstdate',$value->vstdate)
                            ->update([
                                'status'          => 'Y',
                                'stm_rep'         => $value->debit, 
                                'stm_rcpno'       => $value->rep.'-'.$value->repno,
                                'stm_trainid'     => $value->tranid,
                                'stm_total'       => $value->total_approve,
                                'STMDoc'          => $value->STMdoc,
                                'va'              => $value->va,
                        ]);
                        
                    }else if ($value->hc_drug+$value->hc+$value->ae+$value->ae_drug+$value->inst+$value->dmis_money2+$value->dmis_drug > "0") {
                        
                        Acc_1102050101_216::where('hn',$value->hn)->where('vstdate',$value->vstdate)
                            ->update([
                                'status'          => 'Y',
                                'stm_rep'         => $value->debit,
                                'stm_money'       => $value->hc_drug+$value->hc+$value->ae+$value->ae_drug+$value->inst+$value->dmis_money2+$value->dmis_drug,
                                'stm_rcpno'       => $value->rep.'-'.$value->repno,
                                'stm_trainid'     => $value->tranid,
                                'stm_total'       => $value->total_approve,
                                'STMDoc'          => $value->STMdoc,
                                'va'              => $value->va,
                        ]);
                    } else {    
                    }
  
                } else {
                }
            }
            } catch (Exception $e) {
                $error_code = $e->errorInfo[1];
                return back()->withErrors('There was a problem uploading the data!');
            }
            Acc_stm_ucs_excel::truncate();
        return redirect()->back();
    }
    function upstm_ucsopdsave_____(Request $request)
    { 
        
        // $this->validate($request, [
        //     'file' => 'required|file|mimes:xls,xlsx'
        // ]);
        $path = $request->file('file'); 
        // $inputFileType = 'xls';
        // $path = $request->file('file'); 
        // if (file_exists($path)){
            // return response()->download($path); 
            $file_ = $request->file('file')->getClientOriginalName(); //ชื่อไฟล์ 
            // dd($path);
            try{

                // $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($path);
                // dd($inputFileType);
                /**  Create a new Reader of the type that has been identified  **/
                // $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
                // dd($reader);
                /**  Load $inputFileName to a Spreadsheet Object  **/
                // $spreadsheet = $reader->load($path);
                // dd($spreadsheet);
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
                $reader->setReadDataOnly(true);
                $spreadsheet = $reader->load($path);

                // $reader->setReadEmptyCells(false);
                // $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($the_file);
                // $spreadsheet = $reader->load($the_file);
                // $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($the_file);
                // Cheet 2
                // $spreadsheet = IOFactory::load($the_file->getRealPath()); 
                // $reader = IOFactory::createReader($inputFileType);
                // $reader->setLoadSheetsOnly($file_);
                // $spreadsheet = $reader->load($file_);
                $sheet        = $spreadsheet->setActiveSheetIndex(2);
                // $sheet        = $spreadsheet->setActiveSheetIndex(2)->toArray(null, true, true, true);
                // $sheet        = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
                $row_limit    = $sheet->getHighestDataRow();
                $column_limit = $sheet->getHighestDataColumn();
                $row_range    = range( '15', $row_limit );
                $column_range = range( 'AQ', $column_limit );
                $startcount = '15';
                $data = array();
                foreach ($row_range as $row ) {
                    $vst = $sheet->getCell( 'H' . $row )->getValue();  
                    $day = substr($vst,0,2);
                    $mo = substr($vst,3,2);
                    $year = substr($vst,6,4);
                    $vstdate = $year.'-'.$mo.'-'.$day;

                    $reg = $sheet->getCell( 'I' . $row )->getValue(); 
                    $regday = substr($reg, 0, 2);
                    $regmo = substr($reg, 3, 2);
                    $regyear = substr($reg, 6, 4);
                    $dchdate = $regyear.'-'.$regmo.'-'.$regday;

                    $s = $sheet->getCell( 'S' . $row )->getValue();
                    $del_s = str_replace(",","",$s);
                    $t = $sheet->getCell( 'T' . $row )->getValue();
                    $del_t = str_replace(",","",$t);
                    $u = $sheet->getCell( 'U' . $row )->getValue();
                    $del_u = str_replace(",","",$u);
                    $v= $sheet->getCell( 'V' . $row )->getValue();
                    $del_v = str_replace(",","",$v);
                    $w = $sheet->getCell( 'W' . $row )->getValue();
                    $del_w = str_replace(",","",$w);
                    $x = $sheet->getCell( 'X' . $row )->getValue();
                    $del_x = str_replace(",","",$x);
                    $y = $sheet->getCell( 'Y' . $row )->getValue();
                    $del_y = str_replace(",","",$y);
                    $z = $sheet->getCell( 'Z' . $row )->getValue();
                    $del_z = str_replace(",","",$z);
                    $aa = $sheet->getCell( 'AA' . $row )->getValue();
                    $del_aa = str_replace(",","",$aa);
                    $ab = $sheet->getCell( 'AB' . $row )->getValue();
                    $del_ab = str_replace(",","",$ab);
                    $ac = $sheet->getCell( 'AC' . $row )->getValue();
                    $del_ac = str_replace(",","",$ac);
                    $ad = $sheet->getCell( 'AD' . $row )->getValue();
                    $del_ad = str_replace(",","",$ad);
                    $ae = $sheet->getCell( 'AE' . $row )->getValue();
                    $del_ae = str_replace(",","",$ae);
                    $af= $sheet->getCell( 'AF' . $row )->getValue();
                    $del_af = str_replace(",","",$af);
                    $ag = $sheet->getCell( 'AG' . $row )->getValue();
                    $del_ag = str_replace(",","",$ag);
                    $ah = $sheet->getCell( 'AH' . $row )->getValue();
                    $del_ah = str_replace(",","",$ah);
                    $ai = $sheet->getCell( 'AI' . $row )->getValue();
                    $del_ai = str_replace(",","",$ai);
                    $aj = $sheet->getCell( 'AJ' . $row )->getValue();
                    $del_aj = str_replace(",","",$aj);
                    $ak = $sheet->getCell( 'AK' . $row )->getValue();
                    $del_ak = str_replace(",","",$ak);
                    $al = $sheet->getCell( 'AL' . $row )->getValue();
                    $del_al = str_replace(",","",$al);
                    $an = $sheet->getCell( 'AN' . $row )->getValue();
                    $del_an = str_replace(",","",$an);

                    // $rep_ = $sheet->getCell( 'A' . $row )->getValue();
 
                    $data[] = [
                        'rep'                   =>$sheet->getCell( 'A' . $row )->getValue(),
                        'repno'                 =>$sheet->getCell( 'B' . $row )->getValue(),
                        'tranid'                =>$sheet->getCell( 'C' . $row )->getValue(),
                        'hn'                    =>$sheet->getCell( 'D' . $row )->getValue(),
                        'an'                    =>$sheet->getCell( 'E' . $row )->getValue(),
                        'cid'                   =>$sheet->getCell( 'F' . $row )->getValue(),
                        'fullname'              =>$sheet->getCell( 'G' . $row )->getValue(), 
                        'vstdate'               =>$vstdate,
                        'dchdate'               =>$dchdate, 
                        'maininscl'             =>$sheet->getCell( 'J' . $row )->getValue(),
                        'projectcode'           =>$sheet->getCell( 'K' . $row )->getValue(),
                        'debit'                 =>$sheet->getCell( 'L' . $row )->getValue(),
                        'debit_prb'             =>$sheet->getCell( 'M' . $row )->getValue(),
                        'adjrw'                 =>$sheet->getCell( 'N' . $row )->getValue(),
                        'ps1'                   =>$sheet->getCell( 'O' . $row )->getValue(),
                        'ps2'                   =>$sheet->getCell( 'P' . $row )->getValue(),
                        'ccuf'                  =>$sheet->getCell( 'Q' . $row )->getValue(),
                        'adjrw2'                =>$sheet->getCell( 'R' . $row )->getValue(), 
                        'pay_money'             => $del_s,
                        'pay_slip'              => $del_t,
                        'pay_after'             => $del_u,
                        'op'                    => $del_v,
                        'ip_pay1'               => $del_w,
                        'ip_paytrue'            => $del_x,
                        'hc'                    => $del_y,
                        'hc_drug'               => $del_z,
                        'ae'                    => $del_aa,
                        'ae_drug'               => $del_ab,
                        'inst'                  => $del_ac,
                        'dmis_money1'           => $del_ad,
                        'dmis_money2'           => $del_ae,
                        'dmis_drug'             => $del_af,
                        'palliative_care'       => $del_ag,
                        'dmishd'                => $del_ah,
                        'pp'                    => $del_ai,
                        'fs'                    => $del_aj,
                        'opbkk'                 => $del_ak,
                        'total_approve'         => $del_al, 
                        'va'                    =>$sheet->getCell( 'AM' . $row )->getValue(),
                        // 'covid'                 =>$sheet->getCell( 'AN' . $row )->getValue(),
                        'covid'                 => $del_an, 
                        'STMdoc'                =>$file_,
                        'ao'                    =>$sheet->getCell( 'AO' . $row )->getValue(),
                        'ap'                    =>$sheet->getCell( 'AP' . $row )->getValue(),
                        'aq'                    =>$sheet->getCell( 'AQ' . $row )->getValue(),
                        'ar'                    =>$sheet->getCell( 'AR' . $row )->getValue(),
                        'STMdoc'                =>$file_ 
                    ];

                    // Acc_stm_ucs_excel::insert([
                    //     'rep'                   =>$sheet->getCell( 'A' . $row )->getValue(),
                    //     'repno'                 =>$sheet->getCell( 'B' . $row )->getValue(),
                    //     'tranid'                =>$sheet->getCell( 'C' . $row )->getValue(),
                    //     'hn'                    =>$sheet->getCell( 'D' . $row )->getValue(),
                    //     'an'                    =>$sheet->getCell( 'E' . $row )->getValue(),
                    //     'cid'                   =>$sheet->getCell( 'F' . $row )->getValue(),
                    //     'fullname'              =>$sheet->getCell( 'G' . $row )->getValue(), 
                    //     'vstdate'               =>$vstdate,
                    //     'dchdate'               =>$dchdate, 
                    //     'maininscl'             =>$sheet->getCell( 'J' . $row )->getValue(),
                    //     'projectcode'           =>$sheet->getCell( 'K' . $row )->getValue(),
                    //     'debit'                 =>$sheet->getCell( 'L' . $row )->getValue(),
                    //     'debit_prb'             =>$sheet->getCell( 'M' . $row )->getValue(),
                    //     'adjrw'                 =>$sheet->getCell( 'N' . $row )->getValue(),
                    //     'ps1'                   =>$sheet->getCell( 'O' . $row )->getValue(),
                    //     'ps2'                   =>$sheet->getCell( 'P' . $row )->getValue(),
                    //     'ccuf'                  =>$sheet->getCell( 'Q' . $row )->getValue(),
                    //     'adjrw2'                =>$sheet->getCell( 'R' . $row )->getValue(), 
                    //     'pay_money'             => $del_s,
                    //     'pay_slip'              => $del_t,
                    //     'pay_after'             => $del_u,
                    //     'op'                    => $del_v,
                    //     'ip_pay1'               => $del_w,
                    //     'ip_paytrue'            => $del_x,
                    //     'hc'                    => $del_y,
                    //     'hc_drug'               => $del_z,
                    //     'ae'                    => $del_aa,
                    //     'ae_drug'               => $del_ab,
                    //     'inst'                  => $del_ac,
                    //     'dmis_money1'           => $del_ad,
                    //     'dmis_money2'           => $del_ae,
                    //     'dmis_drug'             => $del_af,
                    //     'palliative_care'       => $del_ag,
                    //     'dmishd'                => $del_ah,
                    //     'pp'                    => $del_ai,
                    //     'fs'                    => $del_aj,
                    //     'opbkk'                 => $del_ak,
                    //     'total_approve'         => $del_al, 
                    //     'va'                    =>$sheet->getCell( 'AM' . $row )->getValue(),
                    //     'covid'                 =>$sheet->getCell( 'AN' . $row )->getValue(),
                    //     // 'ao'                    =>$sheet->getCell( 'AO' . $row )->getValue(),
                    //     'STMdoc'                =>$file_ 
                    // ]);


                    $startcount++; 

                }
                // DB::table('acc_stm_ucs_excel')->insert($data); 

                $for_insert = array_chunk($data, length:2000);
                foreach ($for_insert as $key => $data_) {
                    Acc_stm_ucs_excel::insert($data_); 
                }
                // Acc_stm_ucs_excel::insert($data); 

                
                // // Cheet 3
                // $spreadsheet2 = IOFactory::load($path->getRealPath()); 

                // $reader2 = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
                // $reader2->setReadDataOnly(true); 
                // $spreadsheet2 = $reader2->load($path);

                // $sheet2        = $spreadsheet2->setActiveSheetIndex(3);
                // $row_limit2    = $sheet2->getHighestDataRow();
                // $column_limit2 = $sheet2->getHighestDataColumn();
                // $row_range2    = range( 15, $row_limit2 );
                // $column_range2 = range( 'AQ', $column_limit2 );
                // $startcount2 = 15;
                // $data2 = array();
                // foreach ($row_range2 as $row2 ) {
                //     $vst2 = $sheet2->getCell( 'H' . $row2 )->getValue();  
                //     $day2 = substr($vst2,0,2);
                //     $mo2 = substr($vst2,3,2);
                //     $year2 = substr($vst2,6,4);
                //     $vstdate2 = $year2.'-'.$mo2.'-'.$day2;

                //     $reg2 = $sheet2->getCell( 'I' . $row2 )->getValue(); 
                //     $regday2 = substr($reg2, 0, 2);
                //     $regmo2 = substr($reg2, 3, 2);
                //     $regyear2 = substr($reg2, 6, 4);
                //     $dchdate2 = $regyear2.'-'.$regmo2.'-'.$regday2;

                //     $ss = $sheet2->getCell( 'S' . $row2 )->getValue();
                //     $del_ss = str_replace(",","",$ss);
                //     $tt = $sheet2->getCell( 'T' . $row2 )->getValue();
                //     $del_tt = str_replace(",","",$tt);
                //     $uu = $sheet2->getCell( 'U' . $row2 )->getValue();
                //     $del_uu = str_replace(",","",$uu);
                //     $vv= $sheet2->getCell( 'V' . $row2 )->getValue();
                //     $del_vv = str_replace(",","",$vv);
                //     $ww = $sheet2->getCell( 'W' . $row2 )->getValue();
                //     $del_ww = str_replace(",","",$ww);
                //     $xx = $sheet2->getCell( 'X' . $row2 )->getValue();
                //     $del_xx = str_replace(",","",$xx);
                //     $yy = $sheet2->getCell( 'Y' . $row2 )->getValue();
                //     $del_yy = str_replace(",","",$yy);
                //     $zz = $sheet2->getCell( 'Z' . $row2 )->getValue();
                //     $del_zz = str_replace(",","",$zz);
                //     $aa2 = $sheet2->getCell( 'AA' . $row2 )->getValue();
                //     $del_aa2 = str_replace(",","",$aa2);
                //     $ab2 = $sheet2->getCell( 'AB' . $row2 )->getValue();
                //     $del_ab2 = str_replace(",","",$ab2);
                //     $ac2 = $sheet2->getCell( 'AC' . $row2 )->getValue();
                //     $del_ac2 = str_replace(",","",$ac2);
                //     $ad2 = $sheet2->getCell( 'AD' . $row2 )->getValue();
                //     $del_ad2 = str_replace(",","",$ad2);
                //     $ae2 = $sheet2->getCell( 'AE' . $row2 )->getValue();
                //     $del_ae2 = str_replace(",","",$ae2);
                //     $af2= $sheet2->getCell( 'AF' . $row2 )->getValue();
                //     $del_af2 = str_replace(",","",$af2);
                //     $ag2 = $sheet2->getCell( 'AG' . $row2 )->getValue();
                //     $del_ag2 = str_replace(",","",$ag2);
                //     $ah2 = $sheet2->getCell( 'AH' . $row2 )->getValue();
                //     $del_ah2 = str_replace(",","",$ah2);
                //     $ai2 = $sheet2->getCell( 'AI' . $row2 )->getValue();
                //     $del_ai2 = str_replace(",","",$ai2);
                //     $aj2 = $sheet2->getCell( 'AJ' . $row2 )->getValue();
                //     $del_aj2 = str_replace(",","",$aj2);
                //     $ak2 = $sheet2->getCell( 'AK' . $row2 )->getValue();
                //     $del_ak2 = str_replace(",","",$ak2);
                //     $al2 = $sheet2->getCell( 'AL' . $row2 )->getValue();
                //     $del_al2 = str_replace(",","",$al2);
                //     $an2 = $sheet2->getCell( 'AN' . $row2 )->getValue();
                //     $del_an2 = str_replace(",","",$an2);

 
                //     $data2[] = [
                //         'rep'                   =>$sheet2->getCell( 'A' . $row2 )->getValue(),
                //         'repno'                 =>$sheet2->getCell( 'B' . $row2 )->getValue(),
                //         'tranid'                =>$sheet2->getCell( 'C' . $row2 )->getValue(),
                //         'hn'                    =>$sheet2->getCell( 'D' . $row2 )->getValue(),
                //         'an'                    =>$sheet2->getCell( 'E' . $row2 )->getValue(),
                //         'cid'                   =>$sheet2->getCell( 'F' . $row2 )->getValue(),
                //         'fullname'              =>$sheet2->getCell( 'G' . $row2 )->getValue(), 
                //         'vstdate'               =>$vstdate2,
                //         'dchdate'               =>$dchdate2, 
                //         'maininscl'             =>$sheet2->getCell( 'J' . $row2 )->getValue(),
                //         'projectcode'           =>$sheet2->getCell( 'K' . $row2 )->getValue(),
                //         'debit'                 =>$sheet2->getCell( 'L' . $row2 )->getValue(),
                //         'debit_prb'             =>$sheet2->getCell( 'M' . $row2 )->getValue(),
                //         'adjrw'                 =>$sheet2->getCell( 'N' . $row2 )->getValue(),
                //         'ps1'                   =>$sheet2->getCell( 'O' . $row2 )->getValue(),
                //         'ps2'                   =>$sheet2->getCell( 'P' . $row2 )->getValue(),
                //         'ccuf'                  =>$sheet2->getCell( 'Q' . $row2 )->getValue(),
                //         'adjrw2'                =>$sheet2->getCell( 'R' . $row2 )->getValue(), 
                //         'pay_money'             => $del_ss,
                //         'pay_slip'              => $del_tt,
                //         'pay_after'             => $del_uu,
                //         'op'                    => $del_vv,
                //         'ip_pay1'               => $del_ww,
                //         'ip_paytrue'            => $del_xx,
                //         'hc'                    => $del_yy,
                //         'hc_drug'               => $del_zz,
                //         'ae'                    => $del_aa2,
                //         'ae_drug'               => $del_ab2,
                //         'inst'                  => $del_ac2,
                //         'dmis_money1'           => $del_ad2,
                //         'dmis_money2'           => $del_ae2,
                //         'dmis_drug'             => $del_af2,
                //         'palliative_care'       => $del_ag2,
                //         'dmishd'                => $del_ah2,
                //         'pp'                    => $del_ai2,
                //         'fs'                    => $del_aj2,
                //         'opbkk'                 => $del_ak2,
                //         'total_approve'         => $del_al2, 
                //         'va'                    =>$sheet2->getCell( 'AM' . $row2 )->getValue(),
                //         // 'covid'                 =>$sheet2->getCell( 'AN' . $row2 )->getValue(),
                //         // // 'ao'                    =>$sheet->getCell( 'AO' . $row )->getValue(),
                //         // 'STMdoc'                =>$file_ 

                //         'covid'                 => $del_an2, 
                //         'STMdoc'                =>$sheet2,
                //         'ao'                    =>$sheet2->getCell( 'AO' . $row2 )->getValue(),
                //         'ap'                    =>$sheet2->getCell( 'AP' . $row2 )->getValue(),
                //         'aq'                    =>$sheet2->getCell( 'AQ' . $row2 )->getValue(),
                //         'ar'                    =>$sheet2->getCell( 'AR' . $row2 )->getValue(),
                //         'STMdoc'                =>$file_ 
                //     ];
                //     $startcount2++; 

                // }
                // DB::table('acc_stm_ucs_excel')->Transaction::insert($data2); 
                // $for_insert2 = array_chunk($data2, length:10000);
                // foreach ($for_insert2 as $key => $data2_) {
                //     Acc_stm_ucs_excel::insert($data2_); 
                // }
 
            } catch (Exception $e) {
                $error_code = $e->errorInfo[1];
                return back()->withErrors('There was a problem uploading the data!');
            }
             return response()->json([
                'status'    => '200',
            ]);
        // }else{
        //     // abort(404);
        //      return response()->json([
        //         'status'    => '100',
        //     ]);
        // }
            // return back()->withSuccess('Great! Data has been successfully uploaded.');
            // return response()->json([
            //     'status'    => '200',
            // ]);
            return redirect()->back();
    }
    // function upstm_ucs_opsaveexcel(Request $request)
    // { 
    //      // $this->validate($request, [
    //     //     'file' => 'required|file|mimes:xls,xlsx'
    //     // ]);
    //     $the_file_ = $request->file('file'); 
    //     // $file_ = $the_file->getClientOriginalName();
    //     // $file_ = $request->file('upload_file')->getClientOriginalName(); //ชื่อไฟล์
    //     if($request->hasFile('file')){
    //         $the_file = $request->file('file');
    //         $file_ = $the_file->getClientOriginalName();
    //     }
    //     // dd($file);
    //         try{
    //             // $a = array('2','3');
    //             // foreach($a as $value){
    //             //     $table_insert = $sss[0];
    //             //     $sheet_read = $sss[1];
    //             //     // code($sheet_read)
    //             //     // insert_table $table_insert
    //             // }

    //             // Cheet 2
    //             $spreadsheet = IOFactory::load($the_file_->getRealPath()); 
    //             $sheet        = $spreadsheet->setActiveSheetIndex(2);
    //             $row_limit    = $sheet->getHighestDataRow();
    //             $column_limit = $sheet->getHighestDataColumn();
    //             $row_range    = range( 15, $row_limit );
    //             // $column_range = range( 'AO', $column_limit );
    //             $startcount = 15;
    //             $data = array();
    //             foreach ($row_range as $row ) {
    //                 $vst = $sheet->getCell( 'H' . $row )->getValue();  
    //                 $day = substr($vst,0,2);
    //                 $mo = substr($vst,3,2);
    //                 $year = substr($vst,6,4);
    //                 $vstdate = $year.'-'.$mo.'-'.$day;

    //                 $reg = $sheet->getCell( 'I' . $row )->getValue(); 
    //                 $regday = substr($reg, 0, 2);
    //                 $regmo = substr($reg, 3, 2);
    //                 $regyear = substr($reg, 6, 4);
    //                 $dchdate = $regyear.'-'.$regmo.'-'.$regday;

    //                 $s = $sheet->getCell( 'S' . $row )->getValue();
    //                 $del_s = str_replace(",","",$s);
    //                 $t = $sheet->getCell( 'T' . $row )->getValue();
    //                 $del_t = str_replace(",","",$t);
    //                 $u = $sheet->getCell( 'U' . $row )->getValue();
    //                 $del_u = str_replace(",","",$u);
    //                 $v= $sheet->getCell( 'V' . $row )->getValue();
    //                 $del_v = str_replace(",","",$v);
    //                 $w = $sheet->getCell( 'W' . $row )->getValue();
    //                 $del_w = str_replace(",","",$w);
    //                 $x = $sheet->getCell( 'X' . $row )->getValue();
    //                 $del_x = str_replace(",","",$x);
    //                 $y = $sheet->getCell( 'Y' . $row )->getValue();
    //                 $del_y = str_replace(",","",$y);
    //                 $z = $sheet->getCell( 'Z' . $row )->getValue();
    //                 $del_z = str_replace(",","",$z);
    //                 $aa = $sheet->getCell( 'AA' . $row )->getValue();
    //                 $del_aa = str_replace(",","",$aa);
    //                 $ab = $sheet->getCell( 'AB' . $row )->getValue();
    //                 $del_ab = str_replace(",","",$ab);
    //                 $ac = $sheet->getCell( 'AC' . $row )->getValue();
    //                 $del_ac = str_replace(",","",$ac);
    //                 $ad = $sheet->getCell( 'AD' . $row )->getValue();
    //                 $del_ad = str_replace(",","",$ad);
    //                 $ae = $sheet->getCell( 'AE' . $row )->getValue();
    //                 $del_ae = str_replace(",","",$ae);
    //                 $af= $sheet->getCell( 'AF' . $row )->getValue();
    //                 $del_af = str_replace(",","",$af);
    //                 $ag = $sheet->getCell( 'AG' . $row )->getValue();
    //                 $del_ag = str_replace(",","",$ag);
    //                 $ah = $sheet->getCell( 'AH' . $row )->getValue();
    //                 $del_ah = str_replace(",","",$ah);
    //                 $ai = $sheet->getCell( 'AI' . $row )->getValue();
    //                 $del_ai = str_replace(",","",$ai);
    //                 $aj = $sheet->getCell( 'AJ' . $row )->getValue();
    //                 $del_aj = str_replace(",","",$aj);
    //                 $ak = $sheet->getCell( 'AK' . $row )->getValue();
    //                 $del_ak = str_replace(",","",$ak);
    //                 $al = $sheet->getCell( 'AL' . $row )->getValue();
    //                 $del_al = str_replace(",","",$al);

    //                 // $rep_ = $sheet->getCell( 'A' . $row )->getValue();
 
    //                 $data[] = [
    //                     'rep'                   =>$sheet->getCell( 'A' . $row )->getValue(),
    //                     'repno'                 =>$sheet->getCell( 'B' . $row )->getValue(),
    //                     'tranid'                =>$sheet->getCell( 'C' . $row )->getValue(),
    //                     'hn'                    =>$sheet->getCell( 'D' . $row )->getValue(),
    //                     'an'                    =>$sheet->getCell( 'E' . $row )->getValue(),
    //                     'cid'                   =>$sheet->getCell( 'F' . $row )->getValue(),
    //                     'fullname'              =>$sheet->getCell( 'G' . $row )->getValue(), 
    //                     'vstdate'               =>$vstdate,
    //                     'dchdate'               =>$dchdate, 
    //                     'maininscl'             =>$sheet->getCell( 'J' . $row )->getValue(),
    //                     'projectcode'           =>$sheet->getCell( 'K' . $row )->getValue(),
    //                     'debit'                 =>$sheet->getCell( 'L' . $row )->getValue(),
    //                     'debit_prb'             =>$sheet->getCell( 'M' . $row )->getValue(),
    //                     'adjrw'                 =>$sheet->getCell( 'N' . $row )->getValue(),
    //                     'ps1'                   =>$sheet->getCell( 'O' . $row )->getValue(),
    //                     'ps2'                   =>$sheet->getCell( 'P' . $row )->getValue(),
    //                     'ccuf'                  =>$sheet->getCell( 'Q' . $row )->getValue(),
    //                     'adjrw2'                =>$sheet->getCell( 'R' . $row )->getValue(), 
    //                     'pay_money'             => $del_s,
    //                     'pay_slip'              => $del_t,
    //                     'pay_after'             => $del_u,
    //                     'op'                    => $del_v,
    //                     'ip_pay1'               => $del_w,
    //                     'ip_paytrue'            => $del_x,
    //                     'hc'                    => $del_y,
    //                     'hc_drug'               => $del_z,
    //                     'ae'                    => $del_aa,
    //                     'ae_drug'               => $del_ab,
    //                     'inst'                  => $del_ac,
    //                     'dmis_money1'           => $del_ad,
    //                     'dmis_money2'           => $del_ae,
    //                     'dmis_drug'             => $del_af,
    //                     'palliative_care'       => $del_ag,
    //                     'dmishd'                => $del_ah,
    //                     'pp'                    => $del_ai,
    //                     'fs'                    => $del_aj,
    //                     'opbkk'                 => $del_ak,
    //                     'total_approve'         => $del_al, 
    //                     'va'                    =>$sheet->getCell( 'AM' . $row )->getValue(),
    //                     'covid'                 =>$sheet->getCell( 'AN' . $row )->getValue(),
    //                     // 'ao'                    =>$sheet->getCell( 'AO' . $row )->getValue(),
    //                     'STMdoc'                =>$file_ 
    //                 ];
    //                 $startcount++; 

    //             }
    //             // DB::table('acc_stm_ucs_excel')->insert($data); 

    //             $for_insert = array_chunk($data, length:5000);
    //             foreach ($for_insert as $key => $data_) {
    //                 Acc_stm_ucs_excel::insert($data_); 
    //             }
    //             // Acc_stm_ucs_excel::insert($data); 

                
    //             // Cheet 3
    //             // $spreadsheet2 = IOFactory::load($the_file_->getRealPath()); 
    //             // $sheet2        = $spreadsheet2->setActiveSheetIndex(3);
    //             // $row_limit2    = $sheet2->getHighestDataRow();
    //             // $column_limit2 = $sheet2->getHighestDataColumn();
    //             // $row_range2    = range( 15, $row_limit2 );
    //             // // $column_range2 = range( 'AO', $column_limit2 );
    //             // $startcount2 = 15;
    //             // $data2 = array();
    //             // foreach ($row_range2 as $row2 ) {
    //             //     $vst2 = $sheet2->getCell( 'H' . $row2 )->getValue();  
    //             //     $day2 = substr($vst2,0,2);
    //             //     $mo2 = substr($vst2,3,2);
    //             //     $year2 = substr($vst2,6,4);
    //             //     $vstdate2 = $year2.'-'.$mo2.'-'.$day2;

    //             //     $reg2 = $sheet2->getCell( 'I' . $row2 )->getValue(); 
    //             //     $regday2 = substr($reg2, 0, 2);
    //             //     $regmo2 = substr($reg2, 3, 2);
    //             //     $regyear2 = substr($reg2, 6, 4);
    //             //     $dchdate2 = $regyear2.'-'.$regmo2.'-'.$regday2;

    //             //     $ss = $sheet2->getCell( 'S' . $row2 )->getValue();
    //             //     $del_ss = str_replace(",","",$ss);
    //             //     $tt = $sheet2->getCell( 'T' . $row2 )->getValue();
    //             //     $del_tt = str_replace(",","",$tt);
    //             //     $uu = $sheet2->getCell( 'U' . $row2 )->getValue();
    //             //     $del_uu = str_replace(",","",$uu);
    //             //     $vv= $sheet2->getCell( 'V' . $row2 )->getValue();
    //             //     $del_vv = str_replace(",","",$vv);
    //             //     $ww = $sheet2->getCell( 'W' . $row2 )->getValue();
    //             //     $del_ww = str_replace(",","",$ww);
    //             //     $xx = $sheet2->getCell( 'X' . $row2 )->getValue();
    //             //     $del_xx = str_replace(",","",$xx);
    //             //     $yy = $sheet2->getCell( 'Y' . $row2 )->getValue();
    //             //     $del_yy = str_replace(",","",$yy);
    //             //     $zz = $sheet2->getCell( 'Z' . $row2 )->getValue();
    //             //     $del_zz = str_replace(",","",$zz);
    //             //     $aa2 = $sheet2->getCell( 'AA' . $row2 )->getValue();
    //             //     $del_aa2 = str_replace(",","",$aa2);
    //             //     $ab2 = $sheet2->getCell( 'AB' . $row2 )->getValue();
    //             //     $del_ab2 = str_replace(",","",$ab2);
    //             //     $ac2 = $sheet2->getCell( 'AC' . $row2 )->getValue();
    //             //     $del_ac2 = str_replace(",","",$ac2);
    //             //     $ad2 = $sheet2->getCell( 'AD' . $row2 )->getValue();
    //             //     $del_ad2 = str_replace(",","",$ad2);
    //             //     $ae2 = $sheet2->getCell( 'AE' . $row2 )->getValue();
    //             //     $del_ae2 = str_replace(",","",$ae2);
    //             //     $af2= $sheet2->getCell( 'AF' . $row2 )->getValue();
    //             //     $del_af2 = str_replace(",","",$af2);
    //             //     $ag2 = $sheet2->getCell( 'AG' . $row2 )->getValue();
    //             //     $del_ag2 = str_replace(",","",$ag2);
    //             //     $ah2 = $sheet2->getCell( 'AH' . $row2 )->getValue();
    //             //     $del_ah2 = str_replace(",","",$ah2);
    //             //     $ai2 = $sheet2->getCell( 'AI' . $row2 )->getValue();
    //             //     $del_ai2 = str_replace(",","",$ai2);
    //             //     $aj2 = $sheet2->getCell( 'AJ' . $row2 )->getValue();
    //             //     $del_aj2 = str_replace(",","",$aj2);
    //             //     $ak2 = $sheet2->getCell( 'AK' . $row2 )->getValue();
    //             //     $del_ak2 = str_replace(",","",$ak2);
    //             //     $al2 = $sheet2->getCell( 'AL' . $row2 )->getValue();
    //             //     $del_al2 = str_replace(",","",$al2);

 
    //             //     $data2[] = [
    //             //         'rep'                   =>$sheet2->getCell( 'A' . $row2 )->getValue(),
    //             //         'repno'                 =>$sheet2->getCell( 'B' . $row2 )->getValue(),
    //             //         'tranid'                =>$sheet2->getCell( 'C' . $row2 )->getValue(),
    //             //         'hn'                    =>$sheet2->getCell( 'D' . $row2 )->getValue(),
    //             //         'an'                    =>$sheet2->getCell( 'E' . $row2 )->getValue(),
    //             //         'cid'                   =>$sheet2->getCell( 'F' . $row2 )->getValue(),
    //             //         'fullname'              =>$sheet2->getCell( 'G' . $row2 )->getValue(), 
    //             //         'vstdate'               =>$vstdate2,
    //             //         'dchdate'               =>$dchdate2, 
    //             //         'maininscl'             =>$sheet2->getCell( 'J' . $row2 )->getValue(),
    //             //         'projectcode'           =>$sheet2->getCell( 'K' . $row2 )->getValue(),
    //             //         'debit'                 =>$sheet2->getCell( 'L' . $row2 )->getValue(),
    //             //         'debit_prb'             =>$sheet2->getCell( 'M' . $row2 )->getValue(),
    //             //         'adjrw'                 =>$sheet2->getCell( 'N' . $row2 )->getValue(),
    //             //         'ps1'                   =>$sheet2->getCell( 'O' . $row2 )->getValue(),
    //             //         'ps2'                   =>$sheet2->getCell( 'P' . $row2 )->getValue(),
    //             //         'ccuf'                  =>$sheet2->getCell( 'Q' . $row2 )->getValue(),
    //             //         'adjrw2'                =>$sheet2->getCell( 'R' . $row2 )->getValue(), 
    //             //         'pay_money'             => $del_ss,
    //             //         'pay_slip'              => $del_tt,
    //             //         'pay_after'             => $del_uu,
    //             //         'op'                    => $del_vv,
    //             //         'ip_pay1'               => $del_ww,
    //             //         'ip_paytrue'            => $del_xx,
    //             //         'hc'                    => $del_yy,
    //             //         'hc_drug'               => $del_zz,
    //             //         'ae'                    => $del_aa2,
    //             //         'ae_drug'               => $del_ab2,
    //             //         'inst'                  => $del_ac2,
    //             //         'dmis_money1'           => $del_ad2,
    //             //         'dmis_money2'           => $del_ae2,
    //             //         'dmis_drug'             => $del_af2,
    //             //         'palliative_care'       => $del_ag2,
    //             //         'dmishd'                => $del_ah2,
    //             //         'pp'                    => $del_ai2,
    //             //         'fs'                    => $del_aj2,
    //             //         'opbkk'                 => $del_ak2,
    //             //         'total_approve'         => $del_al2, 
    //             //         'va'                    =>$sheet2->getCell( 'AM' . $row2 )->getValue(),
    //             //         'covid'                 =>$sheet2->getCell( 'AN' . $row2 )->getValue(),
    //             //         // 'ao'                    =>$sheet->getCell( 'AO' . $row )->getValue(),
    //             //         'STMdoc'                =>$file_ 
    //             //     ];
    //             //     $startcount2++; 

    //             // }
    //             // // DB::table('acc_stm_ucs_excel')->Transaction::insert($data2); 
    //             // $for_insert2 = array_chunk($data2, length:5000);
    //             // foreach ($for_insert2 as $key => $data2_) {
    //             //     Acc_stm_ucs_excel::insert($data2_); 
    //             // }



    //         } catch (Exception $e) {
    //             $error_code = $e->errorInfo[1];
    //             return back()->withErrors('There was a problem uploading the data!');
    //         }
    //         // return back()->withSuccess('Great! Data has been successfully uploaded.');
    //         return response()->json([
    //         'status'    => '200',
    //     ]);
    // }
    public function upstm_ucsopdsend_____(Request $request)
    {
        try{
            $data_ = DB::connection('mysql')->select('
                SELECT *
                FROM acc_stm_ucs_excel WHERE cid IS NOT NULL
            ');
            foreach ($data_ as $key => $value) {
                if ($value->cid != '') {
                    $check = Acc_stm_ucs::where('tranid','=',$value->tranid)->count();
                    if ($check > 0) {
                    } else {
                        $add = new Acc_stm_ucs();
                        $add->rep            = $value->rep;
                        $add->repno          = $value->repno;
                        $add->tranid         = $value->tranid;
                        $add->hn             = $value->hn;
                        $add->an             = $value->an;
                        $add->cid            = $value->cid;
                        $add->fullname       = $value->fullname;
                        $add->vstdate        = $value->vstdate;
                        $add->dchdate        = $value->dchdate;
                        $add->maininscl      = $value->maininscl;
                        $add->projectcode    = $value->projectcode;
                        $add->debit          = $value->debit;
                        $add->debit_prb      = $value->debit_prb;
                        $add->adjrw          = $value->adjrw;
                        $add->ps1            = $value->ps1;
                        $add->ps2            = $value->ps2;

                        $add->ccuf           = $value->ccuf;
                        $add->adjrw2         = $value->adjrw2;
                        $add->pay_money      = $value->pay_money;
                        $add->pay_slip       = $value->pay_slip;
                        $add->pay_after      = $value->pay_after;
                        $add->op             = $value->op;
                        $add->ip_pay1        = $value->ip_pay1;
                        $add->ip_paytrue     = $value->ip_paytrue;
                        $add->hc             = $value->hc;
                        $add->hc_drug        = $value->hc_drug;
                        $add->ae             = $value->ae;
                        $add->ae_drug        = $value->ae_drug;
                        $add->inst           = $value->inst;
                        $add->dmis_money1    = $value->dmis_money1;
                        $add->dmis_money2    = $value->dmis_money2;
                        $add->dmis_drug      = $value->dmis_drug;
                        $add->palliative_care = $value->palliative_care;
                        $add->dmishd         = $value->dmishd;
                        $add->pp             = $value->pp;
                        $add->fs             = $value->fs;
                        $add->opbkk          = $value->opbkk;
                        $add->total_approve  = $value->total_approve;
                        $add->va             = $value->va;
                        $add->covid          = $value->covid;
                        // $add->date_save      = $value->date_save;
                        $add->STMdoc         = $value->STMdoc;
                        $add->ao             = $value->ao;
                        $add->ap             = $value->ap;
                        $add->aq             = $value->aq;
                        $add->save(); 
                       
                    } 
 

                    if ($value->hc_drug+$value->hc+$value->ae+$value->ae_drug+$value->inst+$value->dmis_money2+$value->dmis_drug == "0") {
                        Acc_1102050101_216::where('hn',$value->hn)->where('vstdate',$value->vstdate)
                            ->update([
                                'status'          => 'Y',
                                'stm_rep'         => $value->debit,
                                // 'stm_money'       => $value->hc_drug+$value->hc+$value->ae+$value->ae_drug+$value->inst+$value->dmis_money2+$value->dmis_drug,
                                'stm_rcpno'       => $value->rep.'-'.$value->repno,
                                'stm_trainid'     => $value->tranid,
                                'stm_total'       => $value->total_approve,
                                'STMDoc'          => $value->STMdoc,
                                'va'              => $value->va,
                        ]);
                    }else if ($value->hc_drug+$value->hc+$value->ae+$value->ae_drug+$value->inst+$value->dmis_money2+$value->dmis_drug > "0") {
                        Acc_1102050101_216::where('hn',$value->hn)->where('vstdate',$value->vstdate)
                            ->update([
                                'status'          => 'Y',
                                'stm_rep'         => $value->debit,
                                'stm_money'       => $value->hc_drug+$value->hc+$value->ae+$value->ae_drug+$value->inst+$value->dmis_money2+$value->dmis_drug,
                                'stm_rcpno'       => $value->rep.'-'.$value->repno,
                                'stm_trainid'     => $value->tranid,
                                'stm_total'       => $value->total_approve,
                                'STMDoc'          => $value->STMdoc,
                                'va'              => $value->va,
                        ]);
                    } else {    
                    }
                    
                    

                } else {
                }
            }
            } catch (Exception $e) {
                $error_code = $e->errorInfo[1];
                return back()->withErrors('There was a problem uploading the data!');
            }
            Acc_stm_ucs_excel::truncate();
        return redirect()->back();
    }
 

}
