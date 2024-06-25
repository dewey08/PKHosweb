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
use App\Models\Acc_1102050101_209;
use App\Models\Acc_1102050101_301;
use App\Models\Acc_1102050101_302;
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
use App\Models\Acc_1102050101_201;
use App\Models\Acc_1102050101_216;
use App\Models\Acc_1102050102_8011;
use App\Models\Acc_1102050101_307;
use App\Models\Acc_1102050101_309;
use App\Models\Acc_1102050101_310;
use App\Models\Acc_1102050102_106;
use App\Models\Acc_1102050102_107;
use App\Models\Acc_1102050101_501;
use App\Models\Acc_1102050101_502;
use App\Models\Acc_1102050101_503;
use App\Models\Acc_1102050101_504;
use App\Models\Acc_1102050101_701;
use App\Models\Acc_1102050101_702;
use App\Models\Acc_1102050101_704;
use App\Models\Acc_1102050101_203;
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


class MoveaccountController extends Controller
{
    public function chang_pttype_OPD(Request $request)
    {
        $hn = $request->HN;

        $acc_debtor = DB::select(
            'SELECT * FROM acc_debtor WHERE hn = "' . $hn . '" 
            ');
        $pang = DB::table('acc_setpang')->get();
        $pttype = DB::select('SELECT * FROM pttype');
            // AND debit_total <> 0
        // acc_debtor_id,vn,an,cid,ptname,vstdate,pttype,income
        return view('account_chang.chang_pttype_OPD', [
            'acc_debtor'       => $acc_debtor,
            'hn'               => $hn,
            'pang'             => $pang,
            'pttype'           => $pttype
        ]);
    }
    public function pttypeopd_destroy(Request $request, $id)
    {
        $ids = Acc_debtor::where('acc_debtor_id', $id)->first();
        $pang = $ids->account_code;
        $vn = $ids->vn;
        $an = $ids->an;

        if ($pang == '1102050101.201') {
            Acc_1102050101_201::where('vn', $vn)->delete();
        } elseif ($pang == '1102050102.106') {
            Acc_1102050102_106::where('vn', $vn)->delete();
        } elseif ($pang == '1102050102.107') {
            Acc_1102050102_107::where('an', $an)->delete();
        } elseif ($pang == '1102050101.202') {
            Acc_1102050101_202::where('an', $an)->delete();
        } elseif ($pang == '1102050101.203') {
            Acc_1102050101_203::where('vn', $vn)->delete();
        } elseif ($pang == '1102050101.209') {
            Acc_1102050101_209::where('vn', $vn)->delete();
        } elseif ($pang == '1102050101.216') {
            Acc_1102050101_216::where('vn', $vn)->delete();
        } elseif ($pang == '1102050101.217') {
            Acc_1102050101_217::where('an', $an)->delete();
        } elseif ($pang == '1102050101.301') {
            Acc_1102050101_301::where('vn', $vn)->delete();
        } elseif ($pang == '1102050101.302') {
            Acc_1102050101_302::where('an', $an)->delete();
        } elseif ($pang == '1102050101.304') {
            Acc_1102050101_304::where('an', $an)->delete();
        } elseif ($pang == '1102050101.307') {
            Acc_1102050101_307::where('vn', $vn)->delete();
        } elseif ($pang == '1102050101.308') {
            Acc_1102050101_308::where('an', $an)->delete();
        } elseif ($pang == '1102050101.309') {
            Acc_1102050101_309::where('vn', $vn)->delete();
        } elseif ($pang == '1102050101.310') {
            Acc_1102050101_310::where('an', $an)->delete();        
        } elseif ($pang == '1102050101.401') {
            Acc_1102050101_401::where('vn', $vn)->delete();            
        } elseif ($pang == '1102050101.402') {
            Acc_1102050101_402::where('an', $an)->delete();
        } elseif ($pang == '1102050101.2166') {
            Acc_1102050101_2166::where('vn', $vn)->delete();
        } elseif ($pang == '1102050101.3099') {
            Acc_1102050101_3099::where('vn', $vn)->delete();
        } elseif ($pang == '1102050101.4011') {
            Acc_1102050101_4011::where('vn', $vn)->delete();
        } elseif ($pang == '1102050101.4022') {
            Acc_1102050101_4022::where('an', $an)->delete(); 
        } elseif ($pang == '1102050102.602') {
            Acc_1102050102_602::where('vn', $vn)->delete();
        } elseif ($pang == '1102050102.603') {
            Acc_1102050102_603::where('an', $an)->delete();
        } elseif ($pang == '1102050102.801') {
            Acc_1102050102_801::where('vn', $vn)->delete();
        } elseif ($pang == '1102050102.802') {
            Acc_1102050102_802::where('an', $an)->delete();
        } elseif ($pang == '1102050102.803') {
            Acc_1102050102_803::where('vn', $vn)->delete();
        } elseif ($pang == '1102050102.804') {
            Acc_1102050102_804::where('an', $an)->delete();
        } elseif ($pang == '1102050102.8011') {
            Acc_1102050102_8011::where('vn', $vn)->delete(); 
        } elseif ($pang == '1102050101.501') {
            Acc_1102050101_501::where('vn', $vn)->delete();
        } elseif ($pang == '1102050101.502') {
            Acc_1102050101_502::where('an', $an)->delete();
        } elseif ($pang == '1102050101.503') {
            Acc_1102050101_503::where('vn', $vn)->delete();
        } elseif ($pang == '1102050101.504') {
            Acc_1102050101_504::where('an', $an)->delete();
        } elseif ($pang == '1102050101.701') {
            Acc_1102050101_701::where('vn', $vn)->delete();
        } elseif ($pang == '1102050101.702') {
            Acc_1102050101_702::where('vn', $vn)->delete();
        } elseif ($pang == '1102050101.704') {
            Acc_1102050101_704::where('an', $an)->delete(); 
        } else {
            # code...
        }
  
        $del = Acc_debtor::find($id);
        $del->delete();




        return response()->json(['status' => '200', 'success' => 'Delete Success']);
    }
    public function chang_pttype_opdstamp(Request $request)
    {
        $id = $request->ids;
        $iduser = Auth::user()->id;
        $data = Acc_debtor::whereIn('acc_debtor_id', explode(",", $id))->get();
        Acc_debtor::whereIn('acc_debtor_id', explode(",", $id))
            ->update([
                'stamp' => 'Y'
            ]);
        foreach ($data as $key => $value) {
            $ids = Acc_debtor::where('acc_debtor_id', $id)->first();
            $pang = $ids->account_code;
            $vn = $ids->vn;
            $an = $ids->an;

            if ($pang == '1102050101.201') {
                $check = Acc_1102050101_201::where('vn', $vn)->count();
                if ($check > 0) {
                    # code...
                } else {
                    Acc_1102050101_201::insert([
                        'vn'                => $value->vn,
                        'hn'                => $value->hn,
                        'an'                => $value->an,
                        'cid'               => $value->cid,
                        'ptname'            => $value->ptname,
                        'vstdate'           => $value->vstdate,
                        'regdate'           => $value->regdate,
                        'dchdate'           => $value->dchdate,
                        'pttype'            => $value->pttype,
                        'pttype_nhso'       => $value->pttype_spsch,
                        'acc_code'          => $value->acc_code,
                        'account_code'      => $value->account_code,
                        'income'            => $value->income,
                        'uc_money'          => $value->uc_money,
                        'discount_money'    => $value->discount_money,
                        'rcpt_money'        => $value->rcpt_money,
                        'debit'             => $value->debit,
                        'debit_drug'        => $value->debit_drug,
                        'debit_instument'   => $value->debit_instument,
                        'debit_refer'       => $value->debit_refer,
                        'debit_toa'         => $value->debit_toa,
                        'debit_total'       => $value->debit_total,
                        'max_debt_amount'   => $value->max_debt_amount,
                        'rw'                => $value->rw,
                        'adjrw'             => $value->adjrw,
                        'total_adjrw_income' => $value->total_adjrw_income,
                        'acc_debtor_userid' => $value->acc_debtor_userid
                    ]);
                }
            } elseif ($pang == '1102050101.202') {
                $check = Acc_1102050101_202::where('an', $an)->count();
                if ($check > 0) {
                    # code...
                } else {
                    Acc_1102050101_202::insert([
                        'vn'                => $value->vn,
                        'hn'                => $value->hn,
                        'an'                => $value->an,
                        'cid'               => $value->cid,
                        'ptname'            => $value->ptname,
                        'vstdate'           => $value->vstdate,
                        'regdate'           => $value->regdate,
                        'dchdate'           => $value->dchdate,
                        'pttype'            => $value->pttype,
                        'pttype_nhso'       => $value->pttype_spsch,
                        'acc_code'          => $value->acc_code,
                        'account_code'      => $value->account_code,
                        'income'            => $value->income,
                        'uc_money'          => $value->uc_money,
                        'discount_money'    => $value->discount_money,
                        'rcpt_money'        => $value->rcpt_money,
                        'debit'             => $value->debit,
                        'debit_drug'        => $value->debit_drug,
                        'debit_instument'   => $value->debit_instument,
                        'debit_refer'       => $value->debit_refer,
                        'debit_toa'         => $value->debit_toa,
                        'debit_total'       => $value->debit_total,
                        'max_debt_amount'   => $value->max_debt_amount,
                        'rw'                => $value->rw,
                        'adjrw'             => $value->adjrw,
                        'total_adjrw_income' => $value->total_adjrw_income,
                        'acc_debtor_userid' => $value->acc_debtor_userid
                    ]);
                }
                // Acc_1102050101_203
            } elseif ($pang == '1102050101.203') {
                $check = Acc_1102050101_203::where('vn', $vn)->count();
                if ($check > 0) {
                    # code...
                } else {
                    Acc_1102050101_203::insert([
                        'vn'                => $value->vn,
                        'hn'                => $value->hn,
                        'an'                => $value->an,
                        'cid'               => $value->cid,
                        'ptname'            => $value->ptname,
                        'vstdate'           => $value->vstdate,
                        'regdate'           => $value->regdate,
                        'dchdate'           => $value->dchdate,
                        'pttype'            => $value->pttype,
                        'pttype_nhso'       => $value->pttype_spsch,
                        'acc_code'          => $value->acc_code,
                        'account_code'      => $value->account_code,
                        'income'            => $value->income,
                        'uc_money'          => $value->uc_money,
                        'discount_money'    => $value->discount_money,
                        'rcpt_money'        => $value->rcpt_money,
                        'debit'             => $value->debit,
                        'debit_drug'        => $value->debit_drug,
                        'debit_instument'   => $value->debit_instument,
                        'debit_refer'       => $value->debit_refer,
                        'debit_toa'         => $value->debit_toa,
                        'debit_total'       => $value->debit_total,
                        'max_debt_amount'   => $value->max_debt_amount,
                        'rw'                => $value->rw,
                        'adjrw'             => $value->adjrw,
                        'total_adjrw_income' => $value->total_adjrw_income,
                        'acc_debtor_userid' => $value->acc_debtor_userid
                    ]);
                }
            } elseif ($pang == '1102050101.209') {
                $check = Acc_1102050101_209::where('vn', $vn)->count();
                if ($check > 0) {
                    # code...
                } else {
                    Acc_1102050101_209::insert([
                        'vn'                => $value->vn,
                        'hn'                => $value->hn,
                        'an'                => $value->an,
                        'cid'               => $value->cid,
                        'ptname'            => $value->ptname,
                        'vstdate'           => $value->vstdate,
                        'regdate'           => $value->regdate,
                        'dchdate'           => $value->dchdate,
                        'pttype'            => $value->pttype,
                        'pttype_nhso'       => $value->pttype_spsch,
                        'acc_code'          => $value->acc_code,
                        'account_code'      => $value->account_code,
                        'income'            => $value->income,
                        'uc_money'          => $value->uc_money,
                        'discount_money'    => $value->discount_money,
                        'rcpt_money'        => $value->rcpt_money,
                        'debit'             => $value->debit,
                        'debit_drug'        => $value->debit_drug,
                        'debit_instument'   => $value->debit_instument,
                        'debit_refer'       => $value->debit_refer,
                        'debit_toa'         => $value->debit_toa,
                        'debit_total'       => $value->debit_total,
                        'max_debt_amount'   => $value->max_debt_amount,
                        'rw'                => $value->rw,
                        'adjrw'             => $value->adjrw,
                        'total_adjrw_income' => $value->total_adjrw_income,
                        'acc_debtor_userid' => $value->acc_debtor_userid
                    ]);
                }
            } elseif ($pang == '1102050101.216') {
                $check = Acc_1102050101_216::where('vn', $vn)->count();
                if ($check > 0) {
                    # code...
                } else {
                    Acc_1102050101_216::insert([
                        'vn'                => $value->vn,
                        'hn'                => $value->hn,
                        'an'                => $value->an,
                        'cid'               => $value->cid,
                        'ptname'            => $value->ptname,
                        'vstdate'           => $value->vstdate,
                        'regdate'           => $value->regdate,
                        'dchdate'           => $value->dchdate,
                        'pttype'            => $value->pttype,
                        'pttype_nhso'       => $value->pttype_spsch,
                        'acc_code'          => $value->acc_code,
                        'account_code'      => $value->account_code,
                        'income'            => $value->income,
                        'uc_money'          => $value->uc_money,
                        'discount_money'    => $value->discount_money,
                        'rcpt_money'        => $value->rcpt_money,
                        'debit'             => $value->debit,
                        'debit_drug'        => $value->debit_drug,
                        'debit_instument'   => $value->debit_instument,
                        'debit_refer'       => $value->debit_refer,
                        'debit_toa'         => $value->debit_toa,
                        'debit_total'       => $value->debit_total,
                        'max_debt_amount'   => $value->max_debt_amount,
                        'rw'                => $value->rw,
                        'adjrw'             => $value->adjrw,
                        'total_adjrw_income' => $value->total_adjrw_income,
                        'acc_debtor_userid' => $value->acc_debtor_userid
                    ]);
                }
            } elseif ($pang == '1102050101.217') {
                $check = Acc_1102050101_217::where('an', $an)->count();
                if ($check > 0) {
                    # code...
                } else {
                    Acc_1102050101_217::insert([
                        'vn'                => $value->vn,
                        'hn'                => $value->hn,
                        'an'                => $value->an,
                        'cid'               => $value->cid,
                        'ptname'            => $value->ptname,
                        'vstdate'           => $value->vstdate,
                        'regdate'           => $value->regdate,
                        'dchdate'           => $value->dchdate,
                        'pttype'            => $value->pttype,
                        'pttype_nhso'       => $value->pttype_spsch,
                        'acc_code'          => $value->acc_code,
                        'account_code'      => $value->account_code,
                        'income'            => $value->income,
                        'uc_money'          => $value->uc_money,
                        'discount_money'    => $value->discount_money,
                        'rcpt_money'        => $value->rcpt_money,
                        'debit'             => $value->debit,
                        'debit_drug'        => $value->debit_drug,
                        'debit_instument'   => $value->debit_instument,
                        'debit_refer'       => $value->debit_refer,
                        'debit_toa'         => $value->debit_toa,
                        'debit_total'       => $value->debit_total,
                        'max_debt_amount'   => $value->max_debt_amount,
                        'rw'                => $value->rw,
                        'adjrw'             => $value->adjrw,
                        'total_adjrw_income' => $value->total_adjrw_income,
                        'acc_debtor_userid' => $value->acc_debtor_userid
                    ]);
                }
            } elseif ($pang == '1102050101.301') {
                $check = Acc_1102050101_301::where('vn', $vn)->count();
                if ($check > 0) {
                    # code...
                } else {
                    Acc_1102050101_301::insert([
                        'vn'                => $value->vn,
                        'hn'                => $value->hn,
                        'an'                => $value->an,
                        'cid'               => $value->cid,
                        'ptname'            => $value->ptname,
                        'vstdate'           => $value->vstdate,
                        'regdate'           => $value->regdate,
                        'dchdate'           => $value->dchdate,
                        'pttype'            => $value->pttype,
                        'pttype_nhso'       => $value->pttype_spsch,
                        'acc_code'          => $value->acc_code,
                        'account_code'      => $value->account_code,
                        'income'            => $value->income,
                        'uc_money'          => $value->uc_money,
                        'discount_money'    => $value->discount_money,
                        'rcpt_money'        => $value->rcpt_money,
                        'debit'             => $value->debit,
                        'debit_drug'        => $value->debit_drug,
                        'debit_instument'   => $value->debit_instument,
                        'debit_refer'       => $value->debit_refer,
                        'debit_toa'         => $value->debit_toa,
                        'debit_total'       => $value->debit_total,
                        'max_debt_amount'   => $value->max_debt_amount,
                        'rw'                => $value->rw,
                        'adjrw'             => $value->adjrw,
                        'total_adjrw_income' => $value->total_adjrw_income,
                        'acc_debtor_userid' => $value->acc_debtor_userid
                    ]);
                }
            } elseif ($pang == '1102050101.302') {
                $check = Acc_1102050101_302::where('an', $an)->count();
                if ($check > 0) {
                    # code...
                } else {
                    Acc_1102050101_302::insert([
                        'vn'                => $value->vn,
                        'hn'                => $value->hn,
                        'an'                => $value->an,
                        'cid'               => $value->cid,
                        'ptname'            => $value->ptname,
                        'vstdate'           => $value->vstdate,
                        'regdate'           => $value->regdate,
                        'dchdate'           => $value->dchdate,
                        'pttype'            => $value->pttype,
                        'pttype_nhso'       => $value->pttype_spsch,
                        'acc_code'          => $value->acc_code,
                        'account_code'      => $value->account_code,
                        'income'            => $value->income,
                        'uc_money'          => $value->uc_money,
                        'discount_money'    => $value->discount_money,
                        'rcpt_money'        => $value->rcpt_money,
                        'debit'             => $value->debit,
                        'debit_drug'        => $value->debit_drug,
                        'debit_instument'   => $value->debit_instument,
                        'debit_refer'       => $value->debit_refer,
                        'debit_toa'         => $value->debit_toa,
                        'debit_total'       => $value->debit_total,
                        'max_debt_amount'   => $value->max_debt_amount,
                        'rw'                => $value->rw,
                        'adjrw'             => $value->adjrw,
                        'total_adjrw_income' => $value->total_adjrw_income,
                        'acc_debtor_userid' => $value->acc_debtor_userid
                    ]);
                }
            } elseif ($pang == '1102050101.304') {
                $check = Acc_1102050101_304::where('an', $an)->count();
                if ($check > 0) {
                    # code...
                } else {
                    Acc_1102050101_304::insert([
                        'vn'                => $value->vn,
                        'hn'                => $value->hn,
                        'an'                => $value->an,
                        'cid'               => $value->cid,
                        'ptname'            => $value->ptname,
                        'vstdate'           => $value->vstdate,
                        'regdate'           => $value->regdate,
                        'dchdate'           => $value->dchdate,
                        'pttype'            => $value->pttype,
                        'pttype_nhso'       => $value->pttype_spsch,
                        'acc_code'          => $value->acc_code,
                        'account_code'      => $value->account_code,
                        'income'            => $value->income,
                        'uc_money'          => $value->uc_money,
                        'discount_money'    => $value->discount_money,
                        'rcpt_money'        => $value->rcpt_money,
                        'debit'             => $value->debit,
                        'debit_drug'        => $value->debit_drug,
                        'debit_instument'   => $value->debit_instument,
                        'debit_refer'       => $value->debit_refer,
                        'debit_toa'         => $value->debit_toa,
                        'debit_total'       => $value->debit_total,
                        'max_debt_amount'   => $value->max_debt_amount,
                        'rw'                => $value->rw,
                        'adjrw'             => $value->adjrw,
                        'total_adjrw_income' => $value->total_adjrw_income,
                        'acc_debtor_userid' => $value->acc_debtor_userid
                    ]);
                }
            } elseif ($pang == '1102050101.307') {
                $check = Acc_1102050101_307::where('vn', $vn)->count();
                if ($check > 0) {
                    # code...
                } else {
                    Acc_1102050101_307::insert([
                        'vn'                => $value->vn,
                        'hn'                => $value->hn,
                        'an'                => $value->an,
                        'cid'               => $value->cid,
                        'ptname'            => $value->ptname,
                        'vstdate'           => $value->vstdate,
                        'regdate'           => $value->regdate,
                        'dchdate'           => $value->dchdate,
                        'pttype'            => $value->pttype,
                        'pttype_nhso'       => $value->pttype_spsch,
                        'acc_code'          => $value->acc_code,
                        'account_code'      => $value->account_code,
                        'income'            => $value->income,
                        'uc_money'          => $value->uc_money,
                        'discount_money'    => $value->discount_money,
                        'rcpt_money'        => $value->rcpt_money,
                        'debit'             => $value->debit,
                        'debit_drug'        => $value->debit_drug,
                        'debit_instument'   => $value->debit_instument,
                        'debit_refer'       => $value->debit_refer,
                        'debit_toa'         => $value->debit_toa,
                        'debit_total'       => $value->debit_total,
                        'max_debt_amount'   => $value->max_debt_amount,
                        'rw'                => $value->rw,
                        'adjrw'             => $value->adjrw,
                        'total_adjrw_income' => $value->total_adjrw_income,
                        'acc_debtor_userid' => $value->acc_debtor_userid
                    ]);
                }
            } elseif ($pang == '1102050101.308') {
                $check = Acc_1102050101_308::where('an', $an)->count();
                if ($check > 0) {
                    # code...
                } else {
                    Acc_1102050101_308::insert([
                        'vn'                => $value->vn,
                        'hn'                => $value->hn,
                        'an'                => $value->an,
                        'cid'               => $value->cid,
                        'ptname'            => $value->ptname,
                        'vstdate'           => $value->vstdate,
                        'regdate'           => $value->regdate,
                        'dchdate'           => $value->dchdate,
                        'pttype'            => $value->pttype,
                        'pttype_nhso'       => $value->pttype_spsch,
                        'acc_code'          => $value->acc_code,
                        'account_code'      => $value->account_code,
                        'income'            => $value->income,
                        'uc_money'          => $value->uc_money,
                        'discount_money'    => $value->discount_money,
                        'rcpt_money'        => $value->rcpt_money,
                        'debit'             => $value->debit,
                        'debit_drug'        => $value->debit_drug,
                        'debit_instument'   => $value->debit_instument,
                        'debit_refer'       => $value->debit_refer,
                        'debit_toa'         => $value->debit_toa,
                        'debit_total'       => $value->debit_total,
                        'max_debt_amount'   => $value->max_debt_amount,
                        'rw'                => $value->rw,
                        'adjrw'             => $value->adjrw,
                        'total_adjrw_income' => $value->total_adjrw_income,
                        'acc_debtor_userid' => $value->acc_debtor_userid
                    ]);
                }
            } elseif ($pang == '1102050101.309') {
                $check = Acc_1102050101_309::where('vn', $vn)->count();
                if ($check > 0) {
                    # code...
                } else {
                    Acc_1102050101_309::insert([
                        'vn'                => $value->vn,
                        'hn'                => $value->hn,
                        'an'                => $value->an,
                        'cid'               => $value->cid,
                        'ptname'            => $value->ptname,
                        'vstdate'           => $value->vstdate,
                        'regdate'           => $value->regdate,
                        'dchdate'           => $value->dchdate,
                        'pttype'            => $value->pttype,
                        'pttype_nhso'       => $value->pttype_spsch,
                        'acc_code'          => $value->acc_code,
                        'account_code'      => $value->account_code,
                        'income'            => $value->income,
                        'uc_money'          => $value->uc_money,
                        'discount_money'    => $value->discount_money,
                        'rcpt_money'        => $value->rcpt_money,
                        'debit'             => $value->debit,
                        'debit_drug'        => $value->debit_drug,
                        'debit_instument'   => $value->debit_instument,
                        'debit_refer'       => $value->debit_refer,
                        'debit_toa'         => $value->debit_toa,
                        'debit_total'       => $value->debit_total,
                        'max_debt_amount'   => $value->max_debt_amount,
                        'rw'                => $value->rw,
                        'adjrw'             => $value->adjrw,
                        'total_adjrw_income' => $value->total_adjrw_income,
                        'acc_debtor_userid' => $value->acc_debtor_userid
                    ]);
                }
            } elseif ($pang == '1102050101.310') {
                $check = Acc_1102050101_310::where('an', $an)->count();
                if ($check > 0) {
                    # code...
                } else {
                    Acc_1102050101_310::insert([
                        'vn'                => $value->vn,
                        'hn'                => $value->hn,
                        'an'                => $value->an,
                        'cid'               => $value->cid,
                        'ptname'            => $value->ptname,
                        'vstdate'           => $value->vstdate,
                        'regdate'           => $value->regdate,
                        'dchdate'           => $value->dchdate,
                        'pttype'            => $value->pttype,
                        'pttype_nhso'       => $value->pttype_spsch,
                        'acc_code'          => $value->acc_code,
                        'account_code'      => $value->account_code,
                        'income'            => $value->income,
                        'uc_money'          => $value->uc_money,
                        'discount_money'    => $value->discount_money,
                        'rcpt_money'        => $value->rcpt_money,
                        'debit'             => $value->debit,
                        'debit_drug'        => $value->debit_drug,
                        'debit_instument'   => $value->debit_instument,
                        'debit_refer'       => $value->debit_refer,
                        'debit_toa'         => $value->debit_toa,
                        'debit_total'       => $value->debit_total,
                        'max_debt_amount'   => $value->max_debt_amount,
                        'rw'                => $value->rw,
                        'adjrw'             => $value->adjrw,
                        'total_adjrw_income' => $value->total_adjrw_income,
                        'acc_debtor_userid' => $value->acc_debtor_userid
                    ]);
                }
            } elseif ($pang == '1102050101.401') {
                $check = Acc_1102050101_401::where('vn', $vn)->count();
                if ($check > 0) {
                    # code...
                } else {
                    Acc_1102050101_401::insert([
                        'vn'                => $value->vn,
                        'hn'                => $value->hn,
                        'an'                => $value->an,
                        'cid'               => $value->cid,
                        'ptname'            => $value->ptname,
                        'vstdate'           => $value->vstdate,
                        'regdate'           => $value->regdate,
                        'dchdate'           => $value->dchdate,
                        'pttype'            => $value->pttype,
                        'pttype_nhso'       => $value->pttype_spsch,
                        'acc_code'          => $value->acc_code,
                        'account_code'      => $value->account_code,
                        'income'            => $value->income,
                        'uc_money'          => $value->uc_money,
                        'discount_money'    => $value->discount_money,
                        'rcpt_money'        => $value->rcpt_money,
                        'debit'             => $value->debit,
                        'debit_drug'        => $value->debit_drug,
                        'debit_instument'   => $value->debit_instument,
                        'debit_refer'       => $value->debit_refer,
                        'debit_toa'         => $value->debit_toa,
                        'debit_total'       => $value->debit_total,
                        'max_debt_amount'   => $value->max_debt_amount,
                        'rw'                => $value->rw,
                        'adjrw'             => $value->adjrw,
                        'total_adjrw_income' => $value->total_adjrw_income,
                        'acc_debtor_userid' => $value->acc_debtor_userid
                    ]);
                }
            } elseif ($pang == '1102050101.402') {
                $check = Acc_1102050101_402::where('an', $an)->count();
                if ($check > 0) {
                    # code...
                } else {
                    Acc_1102050101_402::insert([
                        'vn'                => $value->vn,
                        'hn'                => $value->hn,
                        'an'                => $value->an,
                        'cid'               => $value->cid,
                        'ptname'            => $value->ptname,
                        'vstdate'           => $value->vstdate,
                        'regdate'           => $value->regdate,
                        'dchdate'           => $value->dchdate,
                        'pttype'            => $value->pttype,
                        'pttype_nhso'       => $value->pttype_spsch,
                        'acc_code'          => $value->acc_code,
                        'account_code'      => $value->account_code,
                        'income'            => $value->income,
                        'uc_money'          => $value->uc_money,
                        'discount_money'    => $value->discount_money,
                        'rcpt_money'        => $value->rcpt_money,
                        'debit'             => $value->debit,
                        'debit_drug'        => $value->debit_drug,
                        'debit_instument'   => $value->debit_instument,
                        'debit_refer'       => $value->debit_refer,
                        'debit_toa'         => $value->debit_toa,
                        'debit_total'       => $value->debit_total,
                        'max_debt_amount'   => $value->max_debt_amount,
                        'rw'                => $value->rw,
                        'adjrw'             => $value->adjrw,
                        'total_adjrw_income' => $value->total_adjrw_income,
                        'acc_debtor_userid' => $value->acc_debtor_userid
                    ]);
                }
            } elseif ($pang == '1102050101.2166') {
                $check = Acc_1102050101_2166::where('vn', $vn)->count();
                if ($check > 0) {
                    # code...
                } else {
                    Acc_1102050101_2166::insert([
                        'vn'                => $value->vn,
                        'hn'                => $value->hn,
                        'an'                => $value->an,
                        'cid'               => $value->cid,
                        'ptname'            => $value->ptname,
                        'vstdate'           => $value->vstdate,
                        'regdate'           => $value->regdate,
                        'dchdate'           => $value->dchdate,
                        'pttype'            => $value->pttype,
                        'pttype_nhso'       => $value->pttype_spsch,
                        'acc_code'          => $value->acc_code,
                        'account_code'      => $value->account_code,
                        'income'            => $value->income,
                        'uc_money'          => $value->uc_money,
                        'discount_money'    => $value->discount_money,
                        'rcpt_money'        => $value->rcpt_money,
                        'debit'             => $value->debit,
                        'debit_drug'        => $value->debit_drug,
                        'debit_instument'   => $value->debit_instument,
                        'debit_refer'       => $value->debit_refer,
                        'debit_toa'         => $value->debit_toa,
                        'debit_total'       => $value->debit_total,
                        'max_debt_amount'   => $value->max_debt_amount,
                        'rw'                => $value->rw,
                        'adjrw'             => $value->adjrw,
                        'total_adjrw_income' => $value->total_adjrw_income,
                        'acc_debtor_userid' => $value->acc_debtor_userid
                    ]);
                }
            } elseif ($pang == '1102050101.3099') {
                $check = Acc_1102050101_3099::where('vn', $vn)->count();
                if ($check > 0) {
                    # code...
                } else {
                    Acc_1102050101_3099::insert([
                        'vn'                => $value->vn,
                        'hn'                => $value->hn,
                        'an'                => $value->an,
                        'cid'               => $value->cid,
                        'ptname'            => $value->ptname,
                        'vstdate'           => $value->vstdate,
                        'regdate'           => $value->regdate,
                        'dchdate'           => $value->dchdate,
                        'pttype'            => $value->pttype,
                        'pttype_nhso'       => $value->pttype_spsch,
                        'acc_code'          => $value->acc_code,
                        'account_code'      => $value->account_code,
                        'income'            => $value->income,
                        'uc_money'          => $value->uc_money,
                        'discount_money'    => $value->discount_money,
                        'rcpt_money'        => $value->rcpt_money,
                        'debit'             => $value->debit,
                        'debit_drug'        => $value->debit_drug,
                        'debit_instument'   => $value->debit_instument,
                        'debit_refer'       => $value->debit_refer,
                        'debit_toa'         => $value->debit_toa,
                        'debit_total'       => $value->debit_total,
                        'max_debt_amount'   => $value->max_debt_amount,
                        'rw'                => $value->rw,
                        'adjrw'             => $value->adjrw,
                        'total_adjrw_income' => $value->total_adjrw_income,
                        'acc_debtor_userid' => $value->acc_debtor_userid
                    ]);
                }
            } elseif ($pang == '1102050101.4011') {
                $check = Acc_1102050101_4011::where('vn', $vn)->count();
                if ($check > 0) {
                    # code...
                } else {
                    Acc_1102050101_4011::insert([
                        'vn'                => $value->vn,
                        'hn'                => $value->hn,
                        'an'                => $value->an,
                        'cid'               => $value->cid,
                        'ptname'            => $value->ptname,
                        'vstdate'           => $value->vstdate,
                        'regdate'           => $value->regdate,
                        'dchdate'           => $value->dchdate,
                        'pttype'            => $value->pttype,
                        'pttype_nhso'       => $value->pttype_spsch,
                        'acc_code'          => $value->acc_code,
                        'account_code'      => $value->account_code,
                        'income'            => $value->income,
                        'uc_money'          => $value->uc_money,
                        'discount_money'    => $value->discount_money,
                        'rcpt_money'        => $value->rcpt_money,
                        'debit'             => $value->debit,
                        'debit_drug'        => $value->debit_drug,
                        'debit_instument'   => $value->debit_instument,
                        'debit_refer'       => $value->debit_refer,
                        'debit_toa'         => $value->debit_toa,
                        'debit_total'       => $value->debit_total,
                        'max_debt_amount'   => $value->max_debt_amount,
                        'rw'                => $value->rw,
                        'adjrw'             => $value->adjrw,
                        'total_adjrw_income' => $value->total_adjrw_income,
                        'acc_debtor_userid' => $value->acc_debtor_userid
                    ]);
                }
            } elseif ($pang == '1102050101.4022') {

                $check = Acc_1102050101_4022::where('an', $an)->count();
                if ($check > 0) {
                    # code...
                } else {
                    Acc_1102050101_4022::insert([
                        'vn'                => $value->vn,
                        'hn'                => $value->hn,
                        'an'                => $value->an,
                        'cid'               => $value->cid,
                        'ptname'            => $value->ptname,
                        'vstdate'           => $value->vstdate,
                        'regdate'           => $value->regdate,
                        'dchdate'           => $value->dchdate,
                        'pttype'            => $value->pttype,
                        'pttype_nhso'       => $value->pttype_spsch,
                        'acc_code'          => $value->acc_code,
                        'account_code'      => $value->account_code,
                        'income'            => $value->income,
                        'uc_money'          => $value->uc_money,
                        'discount_money'    => $value->discount_money,
                        'rcpt_money'        => $value->rcpt_money,
                        'debit'             => $value->debit,
                        'debit_drug'        => $value->debit_drug,
                        'debit_instument'   => $value->debit_instument,
                        'debit_refer'       => $value->debit_refer,
                        'debit_toa'         => $value->debit_toa,
                        'debit_total'       => $value->debit_total,
                        'max_debt_amount'   => $value->max_debt_amount,
                        'rw'                => $value->rw,
                        'adjrw'             => $value->adjrw,
                        'total_adjrw_income' => $value->total_adjrw_income,
                        'acc_debtor_userid' => $value->acc_debtor_userid
                    ]);
                }
            } elseif ($pang == '1102050102.602') {
                $check = Acc_1102050102_602::where('vn', $vn)->count();
                if ($check > 0) {
                    # code...
                } else {
                    Acc_1102050102_602::insert([
                        'vn'                => $value->vn,
                        'hn'                => $value->hn,
                        'an'                => $value->an,
                        'cid'               => $value->cid,
                        'ptname'            => $value->ptname,
                        'vstdate'           => $value->vstdate,
                        'regdate'           => $value->regdate,
                        'dchdate'           => $value->dchdate,
                        'pttype'            => $value->pttype,
                        'pttype_nhso'       => $value->pttype_spsch,
                        'acc_code'          => $value->acc_code,
                        'account_code'      => $value->account_code,
                        'income'            => $value->income,
                        'uc_money'          => $value->uc_money,
                        'discount_money'    => $value->discount_money,
                        'rcpt_money'        => $value->rcpt_money,
                        'debit'             => $value->debit,
                        'debit_drug'        => $value->debit_drug,
                        'debit_instument'   => $value->debit_instument,
                        'debit_refer'       => $value->debit_refer,
                        'debit_toa'         => $value->debit_toa,
                        'debit_total'       => $value->debit_total,
                        'max_debt_amount'   => $value->max_debt_amount,
                        'rw'                => $value->rw,
                        'adjrw'             => $value->adjrw,
                        'total_adjrw_income' => $value->total_adjrw_income,
                        'acc_debtor_userid' => $value->acc_debtor_userid
                    ]);
                }
            } elseif ($pang == '1102050102.603') {
                $check = Acc_1102050102_603::where('an', $an)->count();
                if ($check > 0) {
                    # code...
                } else {
                    Acc_1102050102_603::insert([
                        'vn'                => $value->vn,
                        'hn'                => $value->hn,
                        'an'                => $value->an,
                        'cid'               => $value->cid,
                        'ptname'            => $value->ptname,
                        'vstdate'           => $value->vstdate,
                        'regdate'           => $value->regdate,
                        'dchdate'           => $value->dchdate,
                        'pttype'            => $value->pttype,
                        'pttype_nhso'       => $value->pttype_spsch,
                        'acc_code'          => $value->acc_code,
                        'account_code'      => $value->account_code,
                        'income'            => $value->income,
                        'uc_money'          => $value->uc_money,
                        'discount_money'    => $value->discount_money,
                        'rcpt_money'        => $value->rcpt_money,
                        'debit'             => $value->debit,
                        'debit_drug'        => $value->debit_drug,
                        'debit_instument'   => $value->debit_instument,
                        'debit_refer'       => $value->debit_refer,
                        'debit_toa'         => $value->debit_toa,
                        'debit_total'       => $value->debit_total,
                        'max_debt_amount'   => $value->max_debt_amount,
                        'rw'                => $value->rw,
                        'adjrw'             => $value->adjrw,
                        'total_adjrw_income' => $value->total_adjrw_income,
                        'acc_debtor_userid' => $value->acc_debtor_userid
                    ]);
                }
            } elseif ($pang == '1102050102.801') {
                $check = Acc_1102050102_801::where('vn', $vn)->count();
                if ($check > 0) {
                    # code...
                } else {
                    Acc_1102050102_801::insert([
                        'vn'                => $value->vn,
                        'hn'                => $value->hn,
                        'an'                => $value->an,
                        'cid'               => $value->cid,
                        'ptname'            => $value->ptname,
                        'vstdate'           => $value->vstdate,
                        'regdate'           => $value->regdate,
                        'dchdate'           => $value->dchdate,
                        'pttype'            => $value->pttype,
                        'pttype_nhso'       => $value->pttype_spsch,
                        'acc_code'          => $value->acc_code,
                        'account_code'      => $value->account_code,
                        'income'            => $value->income,
                        'uc_money'          => $value->uc_money,
                        'discount_money'    => $value->discount_money,
                        'rcpt_money'        => $value->rcpt_money,
                        'debit'             => $value->debit,
                        'debit_drug'        => $value->debit_drug,
                        'debit_instument'   => $value->debit_instument,
                        'debit_refer'       => $value->debit_refer,
                        'debit_toa'         => $value->debit_toa,
                        'debit_total'       => $value->debit_total,
                        'max_debt_amount'   => $value->max_debt_amount,
                        'rw'                => $value->rw,
                        'adjrw'             => $value->adjrw,
                        'total_adjrw_income' => $value->total_adjrw_income,
                        'acc_debtor_userid' => $value->acc_debtor_userid
                    ]);
                }
            } elseif ($pang == '1102050102.802') {
                $check = Acc_1102050102_802::where('an', $an)->count();
                if ($check > 0) {
                    # code...
                } else {
                    Acc_1102050102_802::insert([
                        'vn'                => $value->vn,
                        'hn'                => $value->hn,
                        'an'                => $value->an,
                        'cid'               => $value->cid,
                        'ptname'            => $value->ptname,
                        'vstdate'           => $value->vstdate,
                        'regdate'           => $value->regdate,
                        'dchdate'           => $value->dchdate,
                        'pttype'            => $value->pttype,
                        'pttype_nhso'       => $value->pttype_spsch,
                        'acc_code'          => $value->acc_code,
                        'account_code'      => $value->account_code,
                        'income'            => $value->income,
                        'uc_money'          => $value->uc_money,
                        'discount_money'    => $value->discount_money,
                        'rcpt_money'        => $value->rcpt_money,
                        'debit'             => $value->debit,
                        'debit_drug'        => $value->debit_drug,
                        'debit_instument'   => $value->debit_instument,
                        'debit_refer'       => $value->debit_refer,
                        'debit_toa'         => $value->debit_toa,
                        'debit_total'       => $value->debit_total,
                        'max_debt_amount'   => $value->max_debt_amount,
                        'rw'                => $value->rw,
                        'adjrw'             => $value->adjrw,
                        'total_adjrw_income' => $value->total_adjrw_income,
                        'acc_debtor_userid' => $value->acc_debtor_userid
                    ]);
                }
            } elseif ($pang == '1102050102.803') {
                $check = Acc_1102050102_803::where('vn', $vn)->count();
                if ($check > 0) {
                    # code...
                } else {
                    Acc_1102050102_803::insert([
                        'vn'                => $value->vn,
                        'hn'                => $value->hn,
                        'an'                => $value->an,
                        'cid'               => $value->cid,
                        'ptname'            => $value->ptname,
                        'vstdate'           => $value->vstdate,
                        'regdate'           => $value->regdate,
                        'dchdate'           => $value->dchdate,
                        'pttype'            => $value->pttype,
                        'pttype_nhso'       => $value->pttype_spsch,
                        'acc_code'          => $value->acc_code,
                        'account_code'      => $value->account_code,
                        'income'            => $value->income,
                        'uc_money'          => $value->uc_money,
                        'discount_money'    => $value->discount_money,
                        'rcpt_money'        => $value->rcpt_money,
                        'debit'             => $value->debit,
                        'debit_drug'        => $value->debit_drug,
                        'debit_instument'   => $value->debit_instument,
                        'debit_refer'       => $value->debit_refer,
                        'debit_toa'         => $value->debit_toa,
                        'debit_total'       => $value->debit_total,
                        'max_debt_amount'   => $value->max_debt_amount,
                        'rw'                => $value->rw,
                        'adjrw'             => $value->adjrw,
                        'total_adjrw_income' => $value->total_adjrw_income,
                        'acc_debtor_userid' => $value->acc_debtor_userid
                    ]);
                }
            } elseif ($pang == '1102050102.804') {
                $check = acc_1102050102_804::where('an', $an)->count();
                if ($check > 0) {
                    # code...
                } else {
                    acc_1102050102_804::insert([
                        'vn'                => $value->vn,
                        'hn'                => $value->hn,
                        'an'                => $value->an,
                        'cid'               => $value->cid,
                        'ptname'            => $value->ptname,
                        'vstdate'           => $value->vstdate,
                        'regdate'           => $value->regdate,
                        'dchdate'           => $value->dchdate,
                        'pttype'            => $value->pttype,
                        'pttype_nhso'       => $value->pttype_spsch,
                        'acc_code'          => $value->acc_code,
                        'account_code'      => $value->account_code,
                        'income'            => $value->income,
                        'uc_money'          => $value->uc_money,
                        'discount_money'    => $value->discount_money,
                        'rcpt_money'        => $value->rcpt_money,
                        'debit'             => $value->debit,
                        'debit_drug'        => $value->debit_drug,
                        'debit_instument'   => $value->debit_instument,
                        'debit_refer'       => $value->debit_refer,
                        'debit_toa'         => $value->debit_toa,
                        'debit_total'       => $value->debit_total,
                        'max_debt_amount'   => $value->max_debt_amount,
                        'rw'                => $value->rw,
                        'adjrw'             => $value->adjrw,
                        'total_adjrw_income' => $value->total_adjrw_income,
                        'acc_debtor_userid' => $value->acc_debtor_userid
                    ]);
                }
            } elseif ($pang == '1102050102.8011') {
                $check = Acc_1102050102_8011::where('vn', $vn)->count();
                if ($check > 0) {
                    # code...
                } else {
                    Acc_1102050102_8011::insert([
                        'vn'                => $value->vn,
                        'hn'                => $value->hn,
                        'an'                => $value->an,
                        'cid'               => $value->cid,
                        'ptname'            => $value->ptname,
                        'vstdate'           => $value->vstdate,
                        'regdate'           => $value->regdate,
                        'dchdate'           => $value->dchdate,
                        'pttype'            => $value->pttype,
                        'pttype_nhso'       => $value->pttype_spsch,
                        'acc_code'          => $value->acc_code,
                        'account_code'      => $value->account_code,
                        'income'            => $value->income,
                        'uc_money'          => $value->uc_money,
                        'discount_money'    => $value->discount_money,
                        'rcpt_money'        => $value->rcpt_money,
                        'debit'             => $value->debit,
                        'debit_drug'        => $value->debit_drug,
                        'debit_instument'   => $value->debit_instument,
                        'debit_refer'       => $value->debit_refer,
                        'debit_toa'         => $value->debit_toa,
                        'debit_total'       => $value->debit_total,
                        'max_debt_amount'   => $value->max_debt_amount,
                        'rw'                => $value->rw,
                        'adjrw'             => $value->adjrw,
                        'total_adjrw_income' => $value->total_adjrw_income,
                        'acc_debtor_userid' => $value->acc_debtor_userid
                    ]);
                }
            } else {
                # code...
            }
        }
        return response()->json([
            'status'    => '200'
        ]);
    }


    public function move_pang(Request $request, $id)
    {
        $data_pang = Acc_debtor::find($id);
        return response()->json([
            'status'                => '200',
            'data_pang'             =>  $data_pang,
        ]);
    }
    public function move_pang_save(Request $request)
    {
        $pangold           = $request->account_code;
        $pang              = $request->account_code_new;
        $vn                = $request->vn;
        $an                = $request->an;
        $hn                = $request->hn;
        $cid               = $request->cid;
        $vstdate           =  $request->vstdate;
        $dchdate           =  $request->dchdate;
        $comment           =  $request->comment;
        $ptname            =  $request->ptname;
        $pttype_new        =  $request->pttype_new;
        $debit_total_new   =  $request->debit_total_new;
        $date_req          =  $request->date_req;

        // dd($pang);
        if ($pang == '1102050101.201') {
            $check = Acc_1102050101_201::where('vn', $vn)->count();
            if ($check > 0) {
                # code...
            } else {
                Acc_1102050101_201::insert([
                    'vn'                => $vn,
                    'hn'                => $hn,
                    'an'                => $an,
                    'cid'               => $cid,
                    'ptname'            => $ptname,
                    'vstdate'           => $vstdate,
                    'dchdate'           => $dchdate,
                    'pttype'            => $pttype_new,
                    'account_code'      => $pang,
                    'debit'             => $debit_total_new,
                    'debit_total'       => $debit_total_new,
                    'comment'           => $comment,
                    'date_req'          => $date_req,
                    'acc_debtor_userid' => Auth::user()->id
                ]);
            }
            $check_acc = Acc_debtor::where('vn', $vn)->count();
            if ($check_acc > 0) {
                Acc_debtor::where('vn', $vn)->update([
                    'account_code'         => $pang,
                    'pttype'               => $pttype_new,
                    'debit'                => $debit_total_new,
                    'debit_total'          => $debit_total_new,
                ]);
            } else {
            }
            // $pangold
            if ($pangold == '1102050101.201') {
                // Acc_1102050101_201::where('vn', $vn)->delete();
                } elseif ($pangold == '1102050102.106') {
                    Acc_1102050102_106::where('vn', $vn)->delete();
                } elseif ($pangold == '1102050102.107') {
                    Acc_1102050102_107::where('an', $an)->delete();
                } elseif ($pangold == '1102050101.202') {
                    Acc_1102050101_202::where('an', $an)->delete();
                } elseif ($pangold == '1102050101.203') {
                    Acc_1102050101_202::where('vn', $vn)->delete();
                } elseif ($pangold == '1102050101.209') {
                    Acc_1102050101_209::where('vn', $vn)->delete();
                } elseif ($pangold == '1102050101.216') {
                    Acc_1102050101_216::where('vn', $vn)->delete();
                } elseif ($pangold == '1102050101.217') {
                    Acc_1102050101_217::where('an', $an)->delete();
                } elseif ($pangold == '1102050101.301') {
                    Acc_1102050101_301::where('vn', $vn)->delete();
                } elseif ($pangold == '1102050101.302') {
                    Acc_1102050101_302::where('an', $an)->delete();
                } elseif ($pangold == '1102050101.304') {
                    Acc_1102050101_304::where('an', $an)->delete();
                } elseif ($pangold == '1102050101.307') {
                    Acc_1102050101_307::where('vn', $vn)->delete();
                } elseif ($pangold == '1102050101.308') {
                    Acc_1102050101_308::where('an', $an)->delete();
                } elseif ($pangold == '1102050101.309') {
                    Acc_1102050101_309::where('vn', $vn)->delete();
                } elseif ($pangold == '1102050101.310') {
                    Acc_1102050101_310::where('an', $an)->delete();
                } elseif ($pangold == '1102050101.401') {
                    Acc_1102050101_401::where('vn', $vn)->delete();
                } elseif ($pangold == '1102050101.402') {
                    Acc_1102050101_402::where('an', $an)->delete();
                } elseif ($pangold == '1102050101.2166') {
                    Acc_1102050101_2166::where('vn', $vn)->delete();
                } elseif ($pangold == '1102050101.3099') {
                    Acc_1102050101_3099::where('vn', $vn)->delete();
                } elseif ($pangold == '1102050101.4011') {
                    Acc_1102050101_4011::where('vn', $vn)->delete();
                } elseif ($pangold == '1102050101.4022') {
                    Acc_1102050101_4022::where('an', $an)->delete(); 
                } elseif ($pangold == '1102050102.602') {
                    Acc_1102050102_602::where('vn', $vn)->delete();
                } elseif ($pangold == '1102050102.603') {
                    Acc_1102050102_603::where('an', $an)->delete();
                } elseif ($pangold == '1102050102.801') {
                    Acc_1102050102_801::where('vn', $vn)->delete();
                } elseif ($pangold == '1102050102.802') {
                    Acc_1102050102_802::where('an', $an)->delete();
                } elseif ($pangold == '1102050102.803') {
                    Acc_1102050102_803::where('vn', $vn)->delete();
                } elseif ($pangold == '1102050102.804') {
                    Acc_1102050102_804::where('an', $an)->delete();
                } elseif ($pangold == '1102050102.8011') {
                    Acc_1102050102_8011::where('vn', $vn)->delete();
    
                } elseif ($pangold == '1102050101.501') {
                    Acc_1102050101_501::where('vn', $vn)->delete();
                } elseif ($pangold == '1102050101.502') {
                    Acc_1102050101_502::where('an', $an)->delete();
                } elseif ($pangold == '1102050101.503') {
                    Acc_1102050101_503::where('vn', $vn)->delete();
                } elseif ($pangold == '1102050101.504') {
                    Acc_1102050101_504::where('an', $an)->delete();
                } elseif ($pangold == '1102050101.701') {
                    Acc_1102050101_701::where('vn', $vn)->delete();
                } elseif ($pangold == '1102050101.702') {
                    Acc_1102050101_702::where('vn', $vn)->delete();
                } elseif ($pangold == '1102050101.704') {
                    Acc_1102050101_704::where('an', $an)->delete();

                } else {
                    # code...
                }
        } elseif ($pang == '1102050102.106') {
            $check = Acc_1102050102_106::where('vn', $vn)->count();
            if ($check > 0) {
                # code...
            } else {
                Acc_1102050102_106::insert([
                    'vn'                => $vn,
                    'hn'                => $hn,
                    'an'                => $an,
                    'cid'               => $cid,
                    'ptname'            => $ptname,
                    'vstdate'           => $vstdate,
                    'dchdate'           => $dchdate,
                    'pttype'            => $pttype_new,
                    'account_code'      => $pang,
                    'debit'             => $debit_total_new,
                    'debit_total'       => $debit_total_new,
                    'comment'           => $comment,
                    'date_req'          => $date_req,
                    'acc_debtor_userid' => Auth::user()->id
                ]);
            }
            $check_acc = Acc_debtor::where('vn', $vn)->count();
            if ($check_acc > 0) {
                Acc_debtor::where('vn', $vn)->update([
                    'account_code'         => $pang,
                    'pttype'               => $pttype_new,
                    'debit'                => $debit_total_new,
                    'debit_total'          => $debit_total_new,
                ]);
            } else {
            }

            // $pangold
            if ($pangold == '1102050101.201') {
                Acc_1102050101_201::where('vn', $vn)->delete(); 
            } elseif ($pangold == '1102050102.107') {
                Acc_1102050102_107::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.202') {
                Acc_1102050101_202::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.203') {
                Acc_1102050101_202::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.209') {
                Acc_1102050101_209::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.216') {
                Acc_1102050101_216::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.217') {
                Acc_1102050101_217::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.301') {
                Acc_1102050101_301::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.302') {
                Acc_1102050101_302::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.304') {
                Acc_1102050101_304::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.307') {
                Acc_1102050101_307::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.308') {
                Acc_1102050101_308::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.309') {
                Acc_1102050101_309::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.310') {
                Acc_1102050101_310::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.401') {
                Acc_1102050101_401::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.402') {
                Acc_1102050101_402::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.2166') {
                Acc_1102050101_2166::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.3099') {
                Acc_1102050101_3099::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.4011') {
                Acc_1102050101_4011::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.4022') {
                Acc_1102050101_4022::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.602') {
                Acc_1102050102_602::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.603') {
                Acc_1102050102_603::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.801') {
                Acc_1102050102_801::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.802') {
                Acc_1102050102_802::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.803') {
                Acc_1102050102_803::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.804') {
                Acc_1102050102_804::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.8011') {
                Acc_1102050102_8011::where('vn', $vn)->delete();

            } elseif ($pangold == '1102050101.501') {
                Acc_1102050101_501::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.502') {
                Acc_1102050101_502::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.503') {
                Acc_1102050101_503::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.504') {
                Acc_1102050101_504::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.701') {
                Acc_1102050101_701::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.702') {
                Acc_1102050101_702::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.704') {
                Acc_1102050101_704::where('an', $an)->delete();
            } else {
                # code...
            }
        } elseif ($pang == '1102050102.107') {
            $check = Acc_1102050102_107::where('an', $an)->count();
            if ($check > 0) {
                # code...
            } else {
                Acc_1102050102_107::insert([
                    'vn'                => $vn,
                    'hn'                => $hn,
                    'an'                => $an,
                    'cid'               => $cid,
                    'ptname'            => $ptname,
                    'vstdate'           => $vstdate,
                    'dchdate'           => $dchdate,
                    'pttype'            => $pttype_new,
                    'account_code'      => $pang,
                    'debit'             => $debit_total_new,
                    'debit_total'       => $debit_total_new,
                    'comment'           => $comment,
                    'date_req'          => $date_req,
                    'acc_debtor_userid' => Auth::user()->id
                ]);
            }
            $check_acc = Acc_debtor::where('an', $an)->count();
            if ($check_acc > 0) {
                Acc_debtor::where('an', $an)->update([
                    'account_code'         => $pang,
                    'pttype'               => $pttype_new,
                    'debit'                => $debit_total_new,
                    'debit_total'          => $debit_total_new,
                ]);
            } else {
            }

            // $pangold
            if ($pangold == '1102050101.201') {
                Acc_1102050101_201::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.106') {
                Acc_1102050102_106::where('vn', $vn)->delete();
            // } elseif ($pangold == '1102050102.107') {
            //     Acc_1102050102_107::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.202') {
                Acc_1102050101_202::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.203') {
                Acc_1102050101_202::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.209') {
                Acc_1102050101_209::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.216') {
                Acc_1102050101_216::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.217') {
                Acc_1102050101_217::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.301') {
                Acc_1102050101_301::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.302') {
                Acc_1102050101_302::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.304') {
                Acc_1102050101_304::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.307') {
                Acc_1102050101_307::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.308') {
                Acc_1102050101_308::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.309') {
                Acc_1102050101_309::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.310') {
                Acc_1102050101_310::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.401') {
                Acc_1102050101_401::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.402') {
                Acc_1102050101_402::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.2166') {
                Acc_1102050101_2166::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.3099') {
                Acc_1102050101_3099::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.4011') {
                Acc_1102050101_4011::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.4022') {
                Acc_1102050101_4022::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.602') {
                Acc_1102050102_602::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.603') {
                Acc_1102050102_603::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.801') {
                Acc_1102050102_801::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.802') {
                Acc_1102050102_802::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.803') {
                Acc_1102050102_803::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.804') {
                Acc_1102050102_804::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.8011') {
                Acc_1102050102_8011::where('vn', $vn)->delete();

            } elseif ($pangold == '1102050101.501') {
                Acc_1102050101_501::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.502') {
                Acc_1102050101_502::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.503') {
                Acc_1102050101_503::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.504') {
                Acc_1102050101_504::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.701') {
                Acc_1102050101_701::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.702') {
                Acc_1102050101_702::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.704') {
                Acc_1102050101_704::where('an', $an)->delete();

            } else {
                # code...
            }
        } elseif ($pang == '1102050101.202') {
            $check = Acc_1102050101_202::where('an', $an)->count();
            if ($check > 0) {
                # code...
            } else {
                Acc_1102050101_202::insert([
                    'vn'                => $vn,
                    'hn'                => $hn,
                    'an'                => $an,
                    'cid'               => $cid,
                    'ptname'            => $ptname,
                    'vstdate'           => $vstdate,
                    'dchdate'           => $dchdate,
                    'pttype'            => $pttype_new,
                    'account_code'      => $pang,
                    'debit'             => $debit_total_new,
                    'debit_total'       => $debit_total_new,
                    'comment'           => $comment,
                    'date_req'          => $date_req,
                    'acc_debtor_userid' => Auth::user()->id
                ]);
            }
            $check_acc = Acc_debtor::where('an', $an)->count();
            if ($check_acc > 0) {
                Acc_debtor::where('an', $an)->update([
                    'account_code'         => $pang,
                    'pttype'               => $pttype_new,
                    'debit'                => $debit_total_new,
                    'debit_total'          => $debit_total_new,
                ]);
            } else {
            }
            // $pangold
            if ($pangold == '1102050101.201') {
                Acc_1102050101_201::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.106') {
                Acc_1102050102_106::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.107') {
                Acc_1102050102_107::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.203') {
                Acc_1102050101_202::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.209') {
                Acc_1102050101_209::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.216') {
                Acc_1102050101_216::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.217') {
                Acc_1102050101_217::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.301') {
                Acc_1102050101_301::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.302') {
                Acc_1102050101_302::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.304') {
                Acc_1102050101_304::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.307') {
                Acc_1102050101_307::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.308') {
                Acc_1102050101_308::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.309') {
                Acc_1102050101_309::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.310') {
                Acc_1102050101_310::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.401') {
                Acc_1102050101_401::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.402') {
                Acc_1102050101_402::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.2166') {
                Acc_1102050101_2166::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.3099') {
                Acc_1102050101_3099::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.4011') {
                Acc_1102050101_4011::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.4022') {
                Acc_1102050101_4022::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.602') {
                Acc_1102050102_602::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.603') {
                Acc_1102050102_603::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.801') {
                Acc_1102050102_801::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.802') {
                Acc_1102050102_802::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.803') {
                Acc_1102050102_803::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.804') {
                Acc_1102050102_804::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.8011') {
                Acc_1102050102_8011::where('vn', $vn)->delete();

            } elseif ($pangold == '1102050101.501') {
                Acc_1102050101_501::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.502') {
                Acc_1102050101_502::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.503') {
                Acc_1102050101_503::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.504') {
                Acc_1102050101_504::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.701') {
                Acc_1102050101_701::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.702') {
                Acc_1102050101_702::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.704') {
                Acc_1102050101_704::where('an', $an)->delete();

            } else {
                # code...
            }
        } elseif ($pang == '1102050101.203') {
            $check = Acc_1102050101_203::where('vn', $vn)->count();
            if ($check > 0) {
                # code...
            } else {
                Acc_1102050101_203::insert([
                    'vn'                => $vn,
                    'hn'                => $hn,
                    'an'                => $an,
                    'cid'               => $cid,
                    'ptname'            => $ptname,
                    'vstdate'           => $vstdate,
                    'dchdate'           => $dchdate,
                    'pttype'            => $pttype_new,
                    'account_code'      => $pang,
                    'debit'             => $debit_total_new,
                    'debit_total'       => $debit_total_new,
                    'comment'           => $comment,
                    'date_req'          => $date_req,
                    'acc_debtor_userid' => Auth::user()->id
                ]);
            }
            $check_acc = Acc_debtor::where('vn', $vn)->count();
            if ($check_acc > 0) {
                Acc_debtor::where('vn', $vn)->update([
                    'account_code'         => $pang,
                    'pttype'               => $pttype_new,
                    'debit'                => $debit_total_new,
                    'debit_total'          => $debit_total_new,
                ]);
            } else {
            }
            // $pangold
            if ($pangold == '1102050101.201') {
                Acc_1102050101_201::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.106') {
                Acc_1102050102_106::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.107') {
                Acc_1102050102_107::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.202') {
                Acc_1102050101_202::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.209') {
                Acc_1102050101_209::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.216') {
                Acc_1102050101_216::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.217') {
                Acc_1102050101_217::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.301') {
                Acc_1102050101_301::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.302') {
                Acc_1102050101_302::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.304') {
                Acc_1102050101_304::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.307') {
                Acc_1102050101_307::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.308') {
                Acc_1102050101_308::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.309') {
                Acc_1102050101_309::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.310') {
                Acc_1102050101_310::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.401') {
                Acc_1102050101_401::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.402') {
                Acc_1102050101_402::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.2166') {
                Acc_1102050101_2166::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.3099') {
                Acc_1102050101_3099::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.4011') {
                Acc_1102050101_4011::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.4022') {
                Acc_1102050101_4022::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.602') {
                Acc_1102050102_602::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.603') {
                Acc_1102050102_603::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.801') {
                Acc_1102050102_801::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.802') {
                Acc_1102050102_802::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.803') {
                Acc_1102050102_803::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.804') {
                Acc_1102050102_804::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.8011') {
                Acc_1102050102_8011::where('vn', $vn)->delete();

            } elseif ($pangold == '1102050101.501') {
                Acc_1102050101_501::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.502') {
                Acc_1102050101_502::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.503') {
                Acc_1102050101_503::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.504') {
                Acc_1102050101_504::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.701') {
                Acc_1102050101_701::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.702') {
                Acc_1102050101_702::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.704') {
                Acc_1102050101_704::where('an', $an)->delete();

            } else {
                # code...
            }
        } elseif ($pang == '1102050101.209') {
            $check = Acc_1102050101_209::where('vn', $vn)->count();
            if ($check > 0) {
                # code...
            } else {
                Acc_1102050101_209::insert([
                    'vn'                => $vn,
                    'hn'                => $hn,
                    'an'                => $an,
                    'cid'               => $cid,
                    'ptname'            => $ptname,
                    'vstdate'           => $vstdate,
                    'dchdate'           => $dchdate,
                    'pttype'            => $pttype_new,
                    'account_code'      => $pang,
                    'debit'             => $debit_total_new,
                    'debit_total'       => $debit_total_new,
                    'comment'           => $comment,
                    'date_req'          => $date_req,
                    'acc_debtor_userid' => Auth::user()->id
                ]);
            }
            $check_acc = Acc_debtor::where('vn', $vn)->count();
            if ($check_acc > 0) {
                Acc_debtor::where('vn', $vn)->update([
                    'account_code'         => $pang,
                    'pttype'               => $pttype_new,
                    'debit'                => $debit_total_new,
                    'debit_total'          => $debit_total_new,
                ]);
            } else {
            }
            // $pangold
            if ($pangold == '1102050101.201') {
                Acc_1102050101_201::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.106') {
                Acc_1102050102_106::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.107') {
                Acc_1102050102_107::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.202') {
                Acc_1102050101_202::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.203') {
                Acc_1102050101_202::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.216') {
                Acc_1102050101_216::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.217') {
                Acc_1102050101_217::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.301') {
                Acc_1102050101_301::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.302') {
                Acc_1102050101_302::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.304') {
                Acc_1102050101_304::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.307') {
                Acc_1102050101_307::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.308') {
                Acc_1102050101_308::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.309') {
                Acc_1102050101_309::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.310') {
                Acc_1102050101_310::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.401') {
                Acc_1102050101_401::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.402') {
                Acc_1102050101_402::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.2166') {
                Acc_1102050101_2166::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.3099') {
                Acc_1102050101_3099::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.4011') {
                Acc_1102050101_4011::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.4022') {
                Acc_1102050101_4022::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.602') {
                Acc_1102050102_602::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.603') {
                Acc_1102050102_603::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.801') {
                Acc_1102050102_801::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.802') {
                Acc_1102050102_802::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.803') {
                Acc_1102050102_803::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.804') {
                Acc_1102050102_804::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.8011') {
                Acc_1102050102_8011::where('vn', $vn)->delete();

            } elseif ($pangold == '1102050101.501') {
                Acc_1102050101_501::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.502') {
                Acc_1102050101_502::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.503') {
                Acc_1102050101_503::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.504') {
                Acc_1102050101_504::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.701') {
                Acc_1102050101_701::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.702') {
                Acc_1102050101_702::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.704') {
                Acc_1102050101_704::where('an', $an)->delete();

            } else {
                # code...
            }
        } elseif ($pang == '1102050101.216') {
            $check = Acc_1102050101_216::where('vn', $vn)->count();
            if ($check > 0) {
                # code...
            } else {
                Acc_1102050101_216::insert([
                    'vn'                => $vn,
                    'hn'                => $hn,
                    'an'                => $an,
                    'cid'               => $cid,
                    'ptname'            => $ptname,
                    'vstdate'           => $vstdate,
                    'dchdate'           => $dchdate,
                    'pttype'            => $pttype_new,
                    'account_code'      => $pang,
                    'debit'             => $debit_total_new,
                    'debit_total'       => $debit_total_new,
                    'comment'           => $comment,
                    'date_req'          => $date_req,
                    'acc_debtor_userid' => Auth::user()->id
                ]);
            }
            $check_acc = Acc_debtor::where('vn', $vn)->count();
            if ($check_acc > 0) {
                Acc_debtor::where('vn', $vn)->update([
                    'account_code'         => $pang,
                    'pttype'               => $pttype_new,
                    'debit'                => $debit_total_new,
                    'debit_total'          => $debit_total_new,
                ]);
            } else {
            }
            // $pangold
            if ($pangold == '1102050101.201') {
                Acc_1102050101_201::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.106') {
                Acc_1102050102_106::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.107') {
                Acc_1102050102_107::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.202') {
                Acc_1102050101_202::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.203') {
                Acc_1102050101_202::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.209') {
                Acc_1102050101_209::where('vn', $vn)->delete();
            // } elseif ($pangold == '1102050101.216') {
            //     Acc_1102050101_216::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.217') {
                Acc_1102050101_217::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.301') {
                Acc_1102050101_301::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.302') {
                Acc_1102050101_302::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.304') {
                Acc_1102050101_304::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.307') {
                Acc_1102050101_307::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.308') {
                Acc_1102050101_308::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.309') {
                Acc_1102050101_309::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.310') {
                Acc_1102050101_310::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.401') {
                Acc_1102050101_401::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.402') {
                Acc_1102050101_402::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.2166') {
                Acc_1102050101_2166::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.3099') {
                Acc_1102050101_3099::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.4011') {
                Acc_1102050101_4011::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.4022') {
                Acc_1102050101_4022::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.602') {
                Acc_1102050102_602::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.603') {
                Acc_1102050102_603::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.801') {
                Acc_1102050102_801::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.802') {
                Acc_1102050102_802::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.803') {
                Acc_1102050102_803::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.804') {
                Acc_1102050102_804::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.8011') {
                Acc_1102050102_8011::where('vn', $vn)->delete();

            } elseif ($pangold == '1102050101.501') {
                Acc_1102050101_501::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.502') {
                Acc_1102050101_502::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.503') {
                Acc_1102050101_503::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.504') {
                Acc_1102050101_504::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.701') {
                Acc_1102050101_701::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.702') {
                Acc_1102050101_702::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.704') {
                Acc_1102050101_704::where('an', $an)->delete();

            } else {
                # code...
            }
        } elseif ($pang == '1102050101.217') {
            $check = Acc_1102050101_217::where('an', $an)->count();
            if ($check > 0) {
                # code...
            } else {
                Acc_1102050101_217::insert([
                    'vn'                => $vn,
                    'hn'                => $hn,
                    'an'                => $an,
                    'cid'               => $cid,
                    'ptname'            => $ptname,
                    'vstdate'           => $vstdate,
                    'dchdate'           => $dchdate,
                    'pttype'            => $pttype_new,
                    'account_code'      => $pang,
                    'debit'             => $debit_total_new,
                    'debit_total'       => $debit_total_new,
                    'comment'           => $comment,
                    'date_req'          => $date_req,
                    'acc_debtor_userid' => Auth::user()->id
                ]);
            }
            $check_acc = Acc_debtor::where('an', $an)->count();
            if ($check_acc > 0) {
                Acc_debtor::where('an', $an)->update([
                    'account_code'         => $pang,
                    'pttype'               => $pttype_new,
                    'debit'                => $debit_total_new,
                    'debit_total'          => $debit_total_new,
                ]);
            } else {
            }
            // $pangold
            if ($pangold == '1102050101.201') {
                Acc_1102050101_201::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.106') {
                Acc_1102050102_106::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.107') {
                Acc_1102050102_107::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.202') {
                Acc_1102050101_202::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.209') {
                Acc_1102050101_209::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.203') {
                Acc_1102050101_202::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.216') {
                Acc_1102050101_216::where('vn', $vn)->delete();
            // } elseif ($pangold == '1102050101.217') {
            //     Acc_1102050101_217::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.301') {
                Acc_1102050101_301::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.302') {
                Acc_1102050101_302::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.304') {
                Acc_1102050101_304::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.307') {
                Acc_1102050101_307::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.308') {
                Acc_1102050101_308::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.309') {
                Acc_1102050101_309::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.310') {
                Acc_1102050101_310::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.401') {
                Acc_1102050101_401::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.402') {
                Acc_1102050101_402::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.2166') {
                Acc_1102050101_2166::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.3099') {
                Acc_1102050101_3099::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.4011') {
                Acc_1102050101_4011::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.4022') {
                Acc_1102050101_4022::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.602') {
                Acc_1102050102_602::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.603') {
                Acc_1102050102_603::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.801') {
                Acc_1102050102_801::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.802') {
                Acc_1102050102_802::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.803') {
                Acc_1102050102_803::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.804') {
                Acc_1102050102_804::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.8011') {
                Acc_1102050102_8011::where('vn', $vn)->delete();

            } elseif ($pangold == '1102050101.501') {
                Acc_1102050101_501::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.502') {
                Acc_1102050101_502::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.503') {
                Acc_1102050101_503::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.504') {
                Acc_1102050101_504::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.701') {
                Acc_1102050101_701::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.702') {
                Acc_1102050101_702::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.704') {
                Acc_1102050101_704::where('an', $an)->delete();

            } else {
                # code...
            }
        } elseif ($pang == '1102050101.301') {
            $check = Acc_1102050101_301::where('vn', $vn)->count();
            if ($check > 0) {
                # code...
            } else {
                Acc_1102050101_301::insert([
                    'vn'                => $vn,
                    'hn'                => $hn,
                    'an'                => $an,
                    'cid'               => $cid,
                    'ptname'            => $ptname,
                    'vstdate'           => $vstdate,
                    'dchdate'           => $dchdate,
                    'pttype'            => $pttype_new,
                    'account_code'      => $pang,
                    'debit'             => $debit_total_new,
                    'debit_total'       => $debit_total_new,
                    'comment'           => $comment,
                    'date_req'          => $date_req,
                    'acc_debtor_userid' => Auth::user()->id
                ]);
            }
            $check_acc = Acc_debtor::where('vn', $vn)->count();
            if ($check_acc > 0) {
                Acc_debtor::where('vn', $vn)->update([
                    'account_code'         => $pang,
                    'pttype'               => $pttype_new,
                    'debit'                => $debit_total_new,
                    'debit_total'          => $debit_total_new,
                ]);
            } else {
            }
            // $pangold
            if ($pangold == '1102050101.201') {
                Acc_1102050101_201::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.106') {
                Acc_1102050102_106::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.107') {
                Acc_1102050102_107::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.202') {
                Acc_1102050101_202::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.203') {
                Acc_1102050101_202::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.209') {
                Acc_1102050101_209::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.216') {
                Acc_1102050101_216::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.217') {
                Acc_1102050101_217::where('an', $an)->delete();
            // } elseif ($pangold == '1102050101.301') {
            //     Acc_1102050101_301::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.302') {
                Acc_1102050101_302::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.304') {
                Acc_1102050101_304::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.307') {
                Acc_1102050101_307::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.308') {
                Acc_1102050101_308::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.309') {
                Acc_1102050101_309::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.310') {
                Acc_1102050101_310::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.401') {
                Acc_1102050101_401::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.402') {
                Acc_1102050101_402::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.2166') {
                Acc_1102050101_2166::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.3099') {
                Acc_1102050101_3099::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.4011') {
                Acc_1102050101_4011::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.4022') {
                Acc_1102050101_4022::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.602') {
                Acc_1102050102_602::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.603') {
                Acc_1102050102_603::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.801') {
                Acc_1102050102_801::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.802') {
                Acc_1102050102_802::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.803') {
                Acc_1102050102_803::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.804') {
                Acc_1102050102_804::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.8011') {
                Acc_1102050102_8011::where('vn', $vn)->delete();

            } elseif ($pangold == '1102050101.501') {
                Acc_1102050101_501::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.502') {
                Acc_1102050101_502::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.503') {
                Acc_1102050101_503::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.504') {
                Acc_1102050101_504::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.701') {
                Acc_1102050101_701::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.702') {
                Acc_1102050101_702::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.704') {
                Acc_1102050101_704::where('an', $an)->delete();

            } else {
                # code...
            }
        } elseif ($pang == '1102050101.302') {
            $check = Acc_1102050101_302::where('an', $an)->count();
            if ($check > 0) {
                # code...
            } else {
                Acc_1102050101_302::insert([
                    'vn'                => $vn,
                    'hn'                => $hn,
                    'an'                => $an,
                    'cid'               => $cid,
                    'ptname'            => $ptname,
                    'vstdate'           => $vstdate,
                    'dchdate'           => $dchdate,
                    'pttype'            => $pttype_new,
                    'account_code'      => $pang,
                    'debit'             => $debit_total_new,
                    'debit_total'       => $debit_total_new,
                    'comment'           => $comment,
                    'date_req'          => $date_req,
                    'acc_debtor_userid' => Auth::user()->id
                ]);
            }
            $check_acc = Acc_debtor::where('an', $an)->count();
            if ($check_acc > 0) {
                Acc_debtor::where('an', $an)->update([
                    'account_code'         => $pang,
                    'pttype'               => $pttype_new,
                    'debit'                => $debit_total_new,
                    'debit_total'          => $debit_total_new,
                ]);
            } else {
            }
            // $pangold
            if ($pangold == '1102050101.201') {
                Acc_1102050101_201::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.106') {
                Acc_1102050102_106::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.107') {
                Acc_1102050102_107::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.202') {
                Acc_1102050101_202::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.203') {
                Acc_1102050101_202::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.209') {
                Acc_1102050101_209::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.216') {
                Acc_1102050101_216::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.217') {
                Acc_1102050101_217::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.301') {
                Acc_1102050101_301::where('vn', $vn)->delete();
            // } elseif ($pangold == '1102050101.302') {
            //     Acc_1102050101_302::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.304') {
                Acc_1102050101_304::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.307') {
                Acc_1102050101_307::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.308') {
                Acc_1102050101_308::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.309') {
                Acc_1102050101_309::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.310') {
                Acc_1102050101_310::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.401') {
                Acc_1102050101_401::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.402') {
                Acc_1102050101_402::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.2166') {
                Acc_1102050101_2166::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.3099') {
                Acc_1102050101_3099::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.4011') {
                Acc_1102050101_4011::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.4022') {
                Acc_1102050101_4022::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.602') {
                Acc_1102050102_602::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.603') {
                Acc_1102050102_603::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.801') {
                Acc_1102050102_801::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.802') {
                Acc_1102050102_802::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.803') {
                Acc_1102050102_803::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.804') {
                Acc_1102050102_804::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.8011') {
                Acc_1102050102_8011::where('vn', $vn)->delete();

            } elseif ($pangold == '1102050101.501') {
                Acc_1102050101_501::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.502') {
                Acc_1102050101_502::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.503') {
                Acc_1102050101_503::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.504') {
                Acc_1102050101_504::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.701') {
                Acc_1102050101_701::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.702') {
                Acc_1102050101_702::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.704') {
                Acc_1102050101_704::where('an', $an)->delete();

            } else {
                # code...
            }
        } elseif ($pang == '1102050101.304') {
            $check = Acc_1102050101_304::where('an', $an)->count();
            if ($check > 0) {
                # code...
            } else {
                Acc_1102050101_304::insert([
                    'vn'                => $vn,
                    'hn'                => $hn,
                    'an'                => $an,
                    'cid'               => $cid,
                    'ptname'            => $ptname,
                    'vstdate'           => $vstdate,
                    'dchdate'           => $dchdate,
                    'pttype'            => $pttype_new,
                    'account_code'      => $pang,
                    'debit'             => $debit_total_new,
                    'debit_total'       => $debit_total_new,
                    'comment'           => $comment,
                    'date_req'          => $date_req,
                    'acc_debtor_userid' => Auth::user()->id
                ]);
            }
            $check_acc = Acc_debtor::where('an', $an)->count();
            if ($check_acc > 0) {
                Acc_debtor::where('an', $an)->update([
                    'account_code'         => $pang,
                    'pttype'               => $pttype_new,
                    'debit'                => $debit_total_new,
                    'debit_total'          => $debit_total_new,
                ]);
            } else {
            }
            // $pangold
            if ($pangold == '1102050101.201') {
                Acc_1102050101_201::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.106') {
                Acc_1102050102_106::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.107') {
                Acc_1102050102_107::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.202') {
                Acc_1102050101_202::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.203') {
                Acc_1102050101_202::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.209') {
                Acc_1102050101_209::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.216') {
                Acc_1102050101_216::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.217') {
                Acc_1102050101_217::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.301') {
                Acc_1102050101_301::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.302') {
                Acc_1102050101_302::where('an', $an)->delete();
            // } elseif ($pangold == '1102050101.304') {
            //     Acc_1102050101_304::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.307') {
                Acc_1102050101_307::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.308') {
                Acc_1102050101_308::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.309') {
                Acc_1102050101_309::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.310') {
                Acc_1102050101_310::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.401') {
                Acc_1102050101_401::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.402') {
                Acc_1102050101_402::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.2166') {
                Acc_1102050101_2166::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.3099') {
                Acc_1102050101_3099::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.4011') {
                Acc_1102050101_4011::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.4022') {
                Acc_1102050101_4022::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.602') {
                Acc_1102050102_602::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.603') {
                Acc_1102050102_603::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.801') {
                Acc_1102050102_801::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.802') {
                Acc_1102050102_802::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.803') {
                Acc_1102050102_803::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.804') {
                Acc_1102050102_804::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.8011') {
                Acc_1102050102_8011::where('vn', $vn)->delete();

            } elseif ($pangold == '1102050101.501') {
                Acc_1102050101_501::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.502') {
                Acc_1102050101_502::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.503') {
                Acc_1102050101_503::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.504') {
                Acc_1102050101_504::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.701') {
                Acc_1102050101_701::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.702') {
                Acc_1102050101_702::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.704') {
                Acc_1102050101_704::where('an', $an)->delete();

            } else {
                # code...
            }
        } elseif ($pang == '1102050101.307') {
            $check = Acc_1102050101_307::where('vn', $vn)->count();
            if ($check > 0) {
                # code...
            } else {
                Acc_1102050101_307::insert([
                    'vn'                => $vn,
                    'hn'                => $hn,
                    'an'                => $an,
                    'cid'               => $cid,
                    'ptname'            => $ptname,
                    'vstdate'           => $vstdate,
                    'dchdate'           => $dchdate,
                    'pttype'            => $pttype_new,
                    'account_code'      => $pang,
                    'debit'             => $debit_total_new,
                    'debit_total'       => $debit_total_new,
                    'comment'           => $comment,
                    'date_req'          => $date_req,
                    'acc_debtor_userid' => Auth::user()->id
                ]);
            }
            $check_acc = Acc_debtor::where('vn', $vn)->count();
            if ($check_acc > 0) {
                Acc_debtor::where('vn', $vn)->update([
                    'account_code'         => $pang,
                    'pttype'               => $pttype_new,
                    'debit'                => $debit_total_new,
                    'debit_total'          => $debit_total_new,
                ]);
            } else {
            }
            // $pangold
            if ($pangold == '1102050101.201') {
                Acc_1102050101_201::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.106') {
                Acc_1102050102_106::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.107') {
                Acc_1102050102_107::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.202') {
                Acc_1102050101_202::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.203') {
                Acc_1102050101_202::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.209') {
                Acc_1102050101_209::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.216') {
                Acc_1102050101_216::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.217') {
                Acc_1102050101_217::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.301') {
                Acc_1102050101_301::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.302') {
                Acc_1102050101_302::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.304') {
                Acc_1102050101_304::where('an', $an)->delete();
            // } elseif ($pangold == '1102050101.307') {
            //     Acc_1102050101_307::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.308') {
                Acc_1102050101_308::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.309') {
                Acc_1102050101_309::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.310') {
                Acc_1102050101_310::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.401') {
                Acc_1102050101_401::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.402') {
                Acc_1102050101_402::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.2166') {
                Acc_1102050101_2166::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.3099') {
                Acc_1102050101_3099::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.4011') {
                Acc_1102050101_4011::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.4022') {
                Acc_1102050101_4022::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.602') {
                Acc_1102050102_602::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.603') {
                Acc_1102050102_603::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.801') {
                Acc_1102050102_801::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.802') {
                Acc_1102050102_802::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.803') {
                Acc_1102050102_803::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.804') {
                Acc_1102050102_804::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.8011') {
                Acc_1102050102_8011::where('vn', $vn)->delete();

            } elseif ($pangold == '1102050101.501') {
                Acc_1102050101_501::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.502') {
                Acc_1102050101_502::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.503') {
                Acc_1102050101_503::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.504') {
                Acc_1102050101_504::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.701') {
                Acc_1102050101_701::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.702') {
                Acc_1102050101_702::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.704') {
                Acc_1102050101_704::where('an', $an)->delete();

            } else {
                # code...
            }
        } elseif ($pang == '1102050101.308') {
            $check = Acc_1102050101_308::where('an', $an)->count();
            if ($check > 0) {
                # code...
            } else {
                Acc_1102050101_308::insert([
                    'vn'                => $vn,
                    'hn'                => $hn,
                    'an'                => $an,
                    'cid'               => $cid,
                    'ptname'            => $ptname,
                    'vstdate'           => $vstdate,
                    'dchdate'           => $dchdate,
                    'pttype'            => $pttype_new,
                    'account_code'      => $pang,
                    'debit'             => $debit_total_new,
                    'debit_total'       => $debit_total_new,
                    'comment'           => $comment,
                    'date_req'          => $date_req,
                    'acc_debtor_userid' => Auth::user()->id
                ]);
            }
            $check_acc = Acc_debtor::where('an', $an)->count();
            if ($check_acc > 0) {
                Acc_debtor::where('an', $an)->update([
                    'account_code'         => $pang,
                    'pttype'               => $pttype_new,
                    'debit'                => $debit_total_new,
                    'debit_total'          => $debit_total_new,
                ]);
            } else {
            }
            // $pangold
            if ($pangold == '1102050101.201') {
                Acc_1102050101_201::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.106') {
                Acc_1102050102_106::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.107') {
                Acc_1102050102_107::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.202') {
                Acc_1102050101_202::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.203') {
                Acc_1102050101_202::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.209') {
                Acc_1102050101_209::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.216') {
                Acc_1102050101_216::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.217') {
                Acc_1102050101_217::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.301') {
                Acc_1102050101_301::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.302') {
                Acc_1102050101_302::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.304') {
                Acc_1102050101_304::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.307') {
                Acc_1102050101_307::where('vn', $vn)->delete();
            // } elseif ($pangold == '1102050101.308') {
            //     Acc_1102050101_308::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.309') {
                Acc_1102050101_309::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.310') {
                Acc_1102050101_310::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.401') {
                Acc_1102050101_401::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.402') {
                Acc_1102050101_402::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.2166') {
                Acc_1102050101_2166::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.3099') {
                Acc_1102050101_3099::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.4011') {
                Acc_1102050101_4011::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.4022') {
                Acc_1102050101_4022::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.602') {
                Acc_1102050102_602::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.603') {
                Acc_1102050102_603::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.801') {
                Acc_1102050102_801::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.802') {
                Acc_1102050102_802::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.803') {
                Acc_1102050102_803::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.804') {
                Acc_1102050102_804::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.8011') {
                Acc_1102050102_8011::where('vn', $vn)->delete();

            } elseif ($pangold == '1102050101.501') {
                Acc_1102050101_501::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.502') {
                Acc_1102050101_502::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.503') {
                Acc_1102050101_503::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.504') {
                Acc_1102050101_504::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.701') {
                Acc_1102050101_701::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.702') {
                Acc_1102050101_702::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.704') {
                Acc_1102050101_704::where('an', $an)->delete();

            } else {
                # code...
            }
        } elseif ($pang == '1102050101.309') {
            $check = Acc_1102050101_309::where('vn', $vn)->count();
            if ($check > 0) {
                # code...
            } else {
                Acc_1102050101_309::insert([
                    'vn'                => $vn,
                    'hn'                => $hn,
                    'an'                => $an,
                    'cid'               => $cid,
                    'ptname'            => $ptname,
                    'vstdate'           => $vstdate,
                    'dchdate'           => $dchdate,
                    'pttype'            => $pttype_new,
                    'account_code'      => $pang,
                    'debit'             => $debit_total_new,
                    'debit_total'       => $debit_total_new,
                    'comment'           => $comment,
                    'date_req'          => $date_req,
                    'acc_debtor_userid' => Auth::user()->id
                ]);
            }
            $check_acc = Acc_debtor::where('vn', $vn)->count();
            if ($check_acc > 0) {
                Acc_debtor::where('vn', $vn)->update([
                    'account_code'         => $pang,
                    'pttype'               => $pttype_new,
                    'debit'                => $debit_total_new,
                    'debit_total'          => $debit_total_new,
                ]);
            } else {
            }
            // $pangold
            if ($pangold == '1102050101.201') {
                Acc_1102050101_201::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.106') {
                Acc_1102050102_106::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.107') {
                Acc_1102050102_107::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.202') {
                Acc_1102050101_202::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.203') {
                Acc_1102050101_202::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.209') {
                Acc_1102050101_209::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.216') {
                Acc_1102050101_216::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.217') {
                Acc_1102050101_217::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.301') {
                Acc_1102050101_301::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.302') {
                Acc_1102050101_302::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.304') {
                Acc_1102050101_304::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.307') {
                Acc_1102050101_307::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.308') {
                Acc_1102050101_308::where('an', $an)->delete();
            // } elseif ($pangold == '1102050101.309') {
            //     Acc_1102050101_309::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.310') {
                Acc_1102050101_310::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.401') {
                Acc_1102050101_401::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.402') {
                Acc_1102050101_402::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.2166') {
                Acc_1102050101_2166::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.3099') {
                Acc_1102050101_3099::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.4011') {
                Acc_1102050101_4011::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.4022') {
                Acc_1102050101_4022::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.602') {
                Acc_1102050102_602::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.603') {
                Acc_1102050102_603::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.801') {
                Acc_1102050102_801::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.802') {
                Acc_1102050102_802::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.803') {
                Acc_1102050102_803::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.804') {
                Acc_1102050102_804::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.8011') {
                Acc_1102050102_8011::where('vn', $vn)->delete();

            } elseif ($pangold == '1102050101.501') {
                Acc_1102050101_501::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.502') {
                Acc_1102050101_502::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.503') {
                Acc_1102050101_503::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.504') {
                Acc_1102050101_504::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.701') {
                Acc_1102050101_701::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.702') {
                Acc_1102050101_702::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.704') {
                Acc_1102050101_704::where('an', $an)->delete();

            } else {
                # code...
            }
        } elseif ($pang == '1102050101.310') {
            $check = Acc_1102050101_310::where('an', $an)->count();
            if ($check > 0) {
                # code...
            } else {
                Acc_1102050101_310::insert([
                    'vn'                => $vn,
                    'hn'                => $hn,
                    'an'                => $an,
                    'cid'               => $cid,
                    'ptname'            => $ptname,
                    'vstdate'           => $vstdate,
                    'dchdate'           => $dchdate,
                    'pttype'            => $pttype_new,
                    'account_code'      => $pang,
                    'debit'             => $debit_total_new,
                    'debit_total'       => $debit_total_new,
                    'comment'           => $comment,
                    'date_req'          => $date_req,
                    'acc_debtor_userid' => Auth::user()->id
                ]);
            }
            $check_acc = Acc_debtor::where('an', $an)->count();
            if ($check_acc > 0) {
                Acc_debtor::where('an', $an)->update([
                    'account_code'         => $pang,
                    'pttype'               => $pttype_new,
                    'debit'                => $debit_total_new,
                    'debit_total'          => $debit_total_new,
                ]);
            } else {
            }
            // $pangold
            if ($pangold == '1102050101.201') {
                Acc_1102050101_201::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.106') {
                Acc_1102050102_106::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.107') {
                Acc_1102050102_107::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.202') {
                Acc_1102050101_202::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.203') {
                Acc_1102050101_202::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.209') {
                Acc_1102050101_209::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.216') {
                Acc_1102050101_216::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.217') {
                Acc_1102050101_217::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.301') {
                Acc_1102050101_301::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.302') {
                Acc_1102050101_302::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.304') {
                Acc_1102050101_304::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.307') {
                Acc_1102050101_307::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.308') {
                Acc_1102050101_308::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.309') {
                Acc_1102050101_309::where('vn', $vn)->delete();
            // } elseif ($pangold == '1102050101.310') {
            //     Acc_1102050101_310::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.401') {
                Acc_1102050101_401::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.402') {
                Acc_1102050101_402::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.2166') {
                Acc_1102050101_2166::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.3099') {
                Acc_1102050101_3099::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.4011') {
                Acc_1102050101_4011::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.4022') {
                Acc_1102050101_4022::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.602') {
                Acc_1102050102_602::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.603') {
                Acc_1102050102_603::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.801') {
                Acc_1102050102_801::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.802') {
                Acc_1102050102_802::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.803') {
                Acc_1102050102_803::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.804') {
                Acc_1102050102_804::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.8011') {
                Acc_1102050102_8011::where('vn', $vn)->delete();

            } elseif ($pangold == '1102050101.501') {
                Acc_1102050101_501::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.502') {
                Acc_1102050101_502::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.503') {
                Acc_1102050101_503::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.504') {
                Acc_1102050101_504::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.701') {
                Acc_1102050101_701::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.702') {
                Acc_1102050101_702::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.704') {
                Acc_1102050101_704::where('an', $an)->delete();

            } else {
                # code...
            }
        } elseif ($pang == '1102050101.401') {
            $check = Acc_1102050101_401::where('vn', $vn)->count();
            if ($check > 0) {
                # code...
            } else {
                Acc_1102050101_401::insert([
                    'vn'                => $vn,
                    'hn'                => $hn,
                    'an'                => $an,
                    'cid'               => $cid,
                    'ptname'            => $ptname,
                    'vstdate'           => $vstdate,
                    'dchdate'           => $dchdate,
                    'pttype'            => $pttype_new,
                    'account_code'      => $pang,
                    'debit'             => $debit_total_new,
                    'debit_total'       => $debit_total_new,
                    'comment'           => $comment,
                    'date_req'          => $date_req,
                    'acc_debtor_userid' => Auth::user()->id
                ]);
            }
            $check_acc = Acc_debtor::where('vn', $vn)->count();
            if ($check_acc > 0) {
                Acc_debtor::where('vn', $vn)->update([
                    'account_code'         => $pang,
                    'pttype'               => $pttype_new,
                    'debit'                => $debit_total_new,
                    'debit_total'          => $debit_total_new,
                ]);
            } else {
            }
            // $pangold
            if ($pangold == '1102050101.201') {
                Acc_1102050101_201::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.106') {
                Acc_1102050102_106::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.107') {
                Acc_1102050102_107::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.202') {
                Acc_1102050101_202::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.203') {
                Acc_1102050101_202::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.209') {
                Acc_1102050101_209::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.216') {
                Acc_1102050101_216::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.217') {
                Acc_1102050101_217::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.301') {
                Acc_1102050101_301::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.302') {
                Acc_1102050101_302::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.304') {
                Acc_1102050101_304::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.307') {
                Acc_1102050101_307::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.308') {
                Acc_1102050101_308::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.309') {
                Acc_1102050101_309::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.310') {
                Acc_1102050101_310::where('an', $an)->delete();
            // } elseif ($pangold == '1102050101.401') {
            //     Acc_1102050101_401::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.402') {
                Acc_1102050101_402::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.2166') {
                Acc_1102050101_2166::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.3099') {
                Acc_1102050101_3099::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.4011') {
                Acc_1102050101_4011::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.4022') {
                Acc_1102050101_4022::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.602') {
                Acc_1102050102_602::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.603') {
                Acc_1102050102_603::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.801') {
                Acc_1102050102_801::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.802') {
                Acc_1102050102_802::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.803') {
                Acc_1102050102_803::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.804') {
                Acc_1102050102_804::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.8011') {
                Acc_1102050102_8011::where('vn', $vn)->delete();

            } elseif ($pangold == '1102050101.501') {
                Acc_1102050101_501::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.502') {
                Acc_1102050101_502::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.503') {
                Acc_1102050101_503::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.504') {
                Acc_1102050101_504::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.701') {
                Acc_1102050101_701::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.702') {
                Acc_1102050101_702::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.704') {
                Acc_1102050101_704::where('an', $an)->delete();

            } else {
                # code...
            }
        } elseif ($pang == '1102050101.402') {
            $check = Acc_1102050101_402::where('an', $an)->count();
            if ($check > 0) {
                # code...
            } else {
                Acc_1102050101_402::insert([
                    'vn'                => $vn,
                    'hn'                => $hn,
                    'an'                => $an,
                    'cid'               => $cid,
                    'ptname'            => $ptname,
                    'vstdate'           => $vstdate,
                    'dchdate'           => $dchdate,
                    'pttype'            => $pttype_new,
                    'account_code'      => $pang,
                    'debit'             => $debit_total_new,
                    'debit_total'       => $debit_total_new,
                    'comment'           => $comment,
                    'date_req'          => $date_req,
                    'acc_debtor_userid' => Auth::user()->id
                ]);
            }
            $check_acc = Acc_debtor::where('an', $an)->count();
            if ($check_acc > 0) {
                Acc_debtor::where('an', $an)->update([
                    'account_code'         => $pang,
                    'pttype'               => $pttype_new,
                    'debit'                => $debit_total_new,
                    'debit_total'          => $debit_total_new,
                ]);
            } else {
            }
            // $pangold
            if ($pangold == '1102050101.201') {
                Acc_1102050101_201::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.106') {
                Acc_1102050102_106::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.107') {
                Acc_1102050102_107::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.202') {
                Acc_1102050101_202::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.203') {
                Acc_1102050101_202::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.209') {
                Acc_1102050101_209::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.216') {
                Acc_1102050101_216::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.217') {
                Acc_1102050101_217::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.301') {
                Acc_1102050101_301::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.302') {
                Acc_1102050101_302::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.304') {
                Acc_1102050101_304::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.307') {
                Acc_1102050101_307::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.308') {
                Acc_1102050101_308::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.309') {
                Acc_1102050101_309::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.310') {
                Acc_1102050101_310::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.401') {
                Acc_1102050101_401::where('vn', $vn)->delete();
            // } elseif ($pangold == '1102050101.402') {
            //     Acc_1102050101_402::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.2166') {
                Acc_1102050101_2166::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.3099') {
                Acc_1102050101_3099::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.4011') {
                Acc_1102050101_4011::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.4022') {
                Acc_1102050101_4022::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.602') {
                Acc_1102050102_602::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.603') {
                Acc_1102050102_603::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.801') {
                Acc_1102050102_801::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.802') {
                Acc_1102050102_802::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.803') {
                Acc_1102050102_803::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.804') {
                Acc_1102050102_804::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.8011') {
                Acc_1102050102_8011::where('vn', $vn)->delete();

            } elseif ($pangold == '1102050101.501') {
                Acc_1102050101_501::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.502') {
                Acc_1102050101_502::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.503') {
                Acc_1102050101_503::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.504') {
                Acc_1102050101_504::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.701') {
                Acc_1102050101_701::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.702') {
                Acc_1102050101_702::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.704') {
                Acc_1102050101_704::where('an', $an)->delete();

            } else {
                # code...
            }
        } elseif ($pang == '1102050101.2166') {
            $check = Acc_1102050101_2166::where('vn', $vn)->count();
            if ($check > 0) {
                # code...
            } else {
                Acc_1102050101_2166::insert([
                    'vn'                => $vn,
                    'hn'                => $hn,
                    'an'                => $an,
                    'cid'               => $cid,
                    'ptname'            => $ptname,
                    'vstdate'           => $vstdate,
                    'dchdate'           => $dchdate,
                    'pttype'            => $pttype_new,
                    'account_code'      => $pang,
                    'debit'             => $debit_total_new,
                    'debit_total'       => $debit_total_new,
                    'comment'           => $comment,
                    'date_req'          => $date_req,
                    'acc_debtor_userid' => Auth::user()->id
                ]);
            }
            $check_acc = Acc_debtor::where('vn', $vn)->count();
            if ($check_acc > 0) {
                Acc_debtor::where('vn', $vn)->update([
                    'account_code'         => $pang,
                    'pttype'               => $pttype_new,
                    'debit'                => $debit_total_new,
                    'debit_total'          => $debit_total_new,
                ]);
            } else {
            }
            // $pangold
            if ($pangold == '1102050101.201') {
                Acc_1102050101_201::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.106') {
                Acc_1102050102_106::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.107') {
                Acc_1102050102_107::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.202') {
                Acc_1102050101_202::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.203') {
                Acc_1102050101_202::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.209') {
                Acc_1102050101_209::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.216') {
                Acc_1102050101_216::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.217') {
                Acc_1102050101_217::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.301') {
                Acc_1102050101_301::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.302') {
                Acc_1102050101_302::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.304') {
                Acc_1102050101_304::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.307') {
                Acc_1102050101_307::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.308') {
                Acc_1102050101_308::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.309') {
                Acc_1102050101_309::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.310') {
                Acc_1102050101_310::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.401') {
                Acc_1102050101_401::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.402') {
                Acc_1102050101_402::where('an', $an)->delete();
            // } elseif ($pangold == '1102050101.2166') {
            //     Acc_1102050101_2166::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.3099') {
                Acc_1102050101_3099::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.4011') {
                Acc_1102050101_4011::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.4022') {
                Acc_1102050101_4022::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.602') {
                Acc_1102050102_602::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.603') {
                Acc_1102050102_603::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.801') {
                Acc_1102050102_801::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.802') {
                Acc_1102050102_802::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.803') {
                Acc_1102050102_803::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.804') {
                Acc_1102050102_804::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.8011') {
                Acc_1102050102_8011::where('vn', $vn)->delete();

            } elseif ($pangold == '1102050101.501') {
                Acc_1102050101_501::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.502') {
                Acc_1102050101_502::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.503') {
                Acc_1102050101_503::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.504') {
                Acc_1102050101_504::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.701') {
                Acc_1102050101_701::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.702') {
                Acc_1102050101_702::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.704') {
                Acc_1102050101_704::where('an', $an)->delete();

            } else {
                # code...
            }
        } elseif ($pang == '1102050101.3099') {
            $check = Acc_1102050101_3099::where('vn', $vn)->count();
            if ($check > 0) {
                # code...
            } else {
                Acc_1102050101_3099::insert([
                    'vn'                => $vn,
                    'hn'                => $hn,
                    'an'                => $an,
                    'cid'               => $cid,
                    'ptname'            => $ptname,
                    'vstdate'           => $vstdate,
                    'dchdate'           => $dchdate,
                    'pttype'            => $pttype_new,
                    'account_code'      => $pang,
                    'debit'             => $debit_total_new,
                    'debit_total'       => $debit_total_new,
                    'comment'           => $comment,
                    'date_req'          => $date_req,
                    'acc_debtor_userid' => Auth::user()->id
                ]);
            }
            $check_acc = Acc_debtor::where('vn', $vn)->count();
            if ($check_acc > 0) {
                Acc_debtor::where('vn', $vn)->update([
                    'account_code'         => $pang,
                    'pttype'               => $pttype_new,
                    'debit'                => $debit_total_new,
                    'debit_total'          => $debit_total_new,
                ]);
            } else {
            }
            // $pangold
            if ($pangold == '1102050101.201') {
                Acc_1102050101_201::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.106') {
                Acc_1102050102_106::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.107') {
                Acc_1102050102_107::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.202') {
                Acc_1102050101_202::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.203') {
                Acc_1102050101_202::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.209') {
                Acc_1102050101_209::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.216') {
                Acc_1102050101_216::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.217') {
                Acc_1102050101_217::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.301') {
                Acc_1102050101_301::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.302') {
                Acc_1102050101_302::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.304') {
                Acc_1102050101_304::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.307') {
                Acc_1102050101_307::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.308') {
                Acc_1102050101_308::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.309') {
                Acc_1102050101_309::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.310') {
                Acc_1102050101_310::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.401') {
                Acc_1102050101_401::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.402') {
                Acc_1102050101_402::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.2166') {
                Acc_1102050101_2166::where('vn', $vn)->delete();
            // } elseif ($pangold == '1102050101.3099') {
            //     Acc_1102050101_3099::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.4011') {
                Acc_1102050101_4011::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.4022') {
                Acc_1102050101_4022::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.602') {
                Acc_1102050102_602::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.603') {
                Acc_1102050102_603::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.801') {
                Acc_1102050102_801::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.802') {
                Acc_1102050102_802::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.803') {
                Acc_1102050102_803::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.804') {
                Acc_1102050102_804::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.8011') {
                Acc_1102050102_8011::where('vn', $vn)->delete();

            } elseif ($pangold == '1102050101.501') {
                Acc_1102050101_501::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.502') {
                Acc_1102050101_502::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.503') {
                Acc_1102050101_503::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.504') {
                Acc_1102050101_504::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.701') {
                Acc_1102050101_701::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.702') {
                Acc_1102050101_702::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.704') {
                Acc_1102050101_704::where('an', $an)->delete();

            } else {
                # code...
            }
        } elseif ($pang == '1102050101.4011') {
            $check = Acc_1102050101_4011::where('vn', $vn)->count();
            if ($check > 0) {
                # code...
            } else {
                Acc_1102050101_4011::insert([
                    'vn'                => $vn,
                    'hn'                => $hn,
                    'an'                => $an,
                    'cid'               => $cid,
                    'ptname'            => $ptname,
                    'vstdate'           => $vstdate,
                    'dchdate'           => $dchdate,
                    'pttype'            => $pttype_new,
                    'account_code'      => $pang,
                    'debit'             => $debit_total_new,
                    'debit_total'       => $debit_total_new,
                    'comment'           => $comment,
                    'date_req'          => $date_req,
                    'acc_debtor_userid' => Auth::user()->id
                ]);
            }
            $check_acc = Acc_debtor::where('vn', $vn)->count();
            if ($check_acc > 0) {
                Acc_debtor::where('vn', $vn)->update([
                    'account_code'         => $pang,
                    'pttype'               => $pttype_new,
                    'debit'                => $debit_total_new,
                    'debit_total'          => $debit_total_new,
                ]);
            } else {
            }
            // $pangold
            if ($pangold == '1102050101.201') {
                Acc_1102050101_201::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.106') {
                Acc_1102050102_106::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.107') {
                Acc_1102050102_107::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.202') {
                Acc_1102050101_202::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.203') {
                Acc_1102050101_202::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.209') {
                Acc_1102050101_209::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.216') {
                Acc_1102050101_216::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.217') {
                Acc_1102050101_217::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.301') {
                Acc_1102050101_301::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.302') {
                Acc_1102050101_302::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.304') {
                Acc_1102050101_304::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.307') {
                Acc_1102050101_307::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.308') {
                Acc_1102050101_308::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.309') {
                Acc_1102050101_309::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.310') {
                Acc_1102050101_310::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.401') {
                Acc_1102050101_401::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.402') {
                Acc_1102050101_402::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.2166') {
                Acc_1102050101_2166::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.3099') {
                Acc_1102050101_3099::where('vn', $vn)->delete();
            // } elseif ($pangold == '1102050101.4011') {
            //     Acc_1102050101_4011::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.4022') {
                Acc_1102050101_4022::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.602') {
                Acc_1102050102_602::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.603') {
                Acc_1102050102_603::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.801') {
                Acc_1102050102_801::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.802') {
                Acc_1102050102_802::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.803') {
                Acc_1102050102_803::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.804') {
                Acc_1102050102_804::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.8011') {
                Acc_1102050102_8011::where('vn', $vn)->delete();

            } elseif ($pangold == '1102050101.501') {
                Acc_1102050101_501::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.502') {
                Acc_1102050101_502::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.503') {
                Acc_1102050101_503::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.504') {
                Acc_1102050101_504::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.701') {
                Acc_1102050101_701::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.702') {
                Acc_1102050101_702::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.704') {
                Acc_1102050101_704::where('an', $an)->delete();

            } else {
                # code...
            }
        } elseif ($pang == '1102050101.4022') {

            $check = Acc_1102050101_4022::where('an', $an)->count();
            if ($check > 0) {
                # code...
            } else {
                Acc_1102050101_4022::insert([
                    'vn'                => $vn,
                    'hn'                => $hn,
                    'an'                => $an,
                    'cid'               => $cid,
                    'ptname'            => $ptname,
                    'vstdate'           => $vstdate,
                    'dchdate'           => $dchdate,
                    'pttype'            => $pttype_new,
                    'account_code'      => $pang,
                    'debit'             => $debit_total_new,
                    'debit_total'       => $debit_total_new,
                    'comment'           => $comment,
                    'date_req'          => $date_req,
                    'acc_debtor_userid' => Auth::user()->id
                ]);
            }
            $check_acc = Acc_debtor::where('an', $an)->count();
            if ($check_acc > 0) {
                Acc_debtor::where('an', $an)->update([
                    'account_code'         => $pang,
                    'pttype'               => $pttype_new,
                    'debit'                => $debit_total_new,
                    'debit_total'          => $debit_total_new,
                ]);
            } else {
            }
            // $pangold
            if ($pangold == '1102050101.201') {
                Acc_1102050101_201::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.106') {
                Acc_1102050102_106::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.107') {
                Acc_1102050102_107::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.202') {
                Acc_1102050101_202::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.203') {
                Acc_1102050101_202::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.209') {
                Acc_1102050101_209::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.216') {
                Acc_1102050101_216::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.217') {
                Acc_1102050101_217::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.301') {
                Acc_1102050101_301::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.302') {
                Acc_1102050101_302::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.304') {
                Acc_1102050101_304::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.307') {
                Acc_1102050101_307::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.308') {
                Acc_1102050101_308::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.309') {
                Acc_1102050101_309::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.310') {
                Acc_1102050101_310::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.401') {
                Acc_1102050101_401::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.402') {
                Acc_1102050101_402::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.2166') {
                Acc_1102050101_2166::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.3099') {
                Acc_1102050101_3099::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.4011') {
                Acc_1102050101_4011::where('vn', $vn)->delete();
            // } elseif ($pangold == '1102050101.4022') {
            //     Acc_1102050101_4022::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.602') {
                Acc_1102050102_602::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.603') {
                Acc_1102050102_603::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.801') {
                Acc_1102050102_801::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.802') {
                Acc_1102050102_802::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.803') {
                Acc_1102050102_803::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.804') {
                Acc_1102050102_804::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.8011') {
                Acc_1102050102_8011::where('vn', $vn)->delete();

            } elseif ($pangold == '1102050101.501') {
                Acc_1102050101_501::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.502') {
                Acc_1102050101_502::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.503') {
                Acc_1102050101_503::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.504') {
                Acc_1102050101_504::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.701') {
                Acc_1102050101_701::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.702') {
                Acc_1102050101_702::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.704') {
                Acc_1102050101_704::where('an', $an)->delete();

            } else {
                # code...
            }
        } elseif ($pang == '1102050102.602') {
            $check = Acc_1102050102_602::where('vn', $vn)->count();
            if ($check > 0) {
                # code...
            } else {
                Acc_1102050102_602::insert([
                    'vn'                => $vn,
                    'hn'                => $hn,
                    'an'                => $an,
                    'cid'               => $cid,
                    'ptname'            => $ptname,
                    'vstdate'           => $vstdate,
                    'dchdate'           => $dchdate,
                    'pttype'            => $pttype_new,
                    'account_code'      => $pang,
                    'debit'             => $debit_total_new,
                    'debit_total'       => $debit_total_new,
                    'comment'           => $comment,
                    'date_req'          => $date_req,
                    'acc_debtor_userid' => Auth::user()->id
                ]);
            }
            $check_acc = Acc_debtor::where('vn', $vn)->count();
            if ($check_acc > 0) {
                Acc_debtor::where('vn', $vn)->update([
                    'account_code'         => $pang,
                    'pttype'               => $pttype_new,
                    'debit'                => $debit_total_new,
                    'debit_total'          => $debit_total_new,
                ]);
            } else {
            }
            // $pangold
            if ($pangold == '1102050101.201') {
                Acc_1102050101_201::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.106') {
                Acc_1102050102_106::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.107') {
                Acc_1102050102_107::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.202') {
                Acc_1102050101_202::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.203') {
                Acc_1102050101_202::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.209') {
                Acc_1102050101_209::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.216') {
                Acc_1102050101_216::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.217') {
                Acc_1102050101_217::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.301') {
                Acc_1102050101_301::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.302') {
                Acc_1102050101_302::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.304') {
                Acc_1102050101_304::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.307') {
                Acc_1102050101_307::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.308') {
                Acc_1102050101_308::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.309') {
                Acc_1102050101_309::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.310') {
                Acc_1102050101_310::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.401') {
                Acc_1102050101_401::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.402') {
                Acc_1102050101_402::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.2166') {
                Acc_1102050101_2166::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.3099') {
                Acc_1102050101_3099::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.4011') {
                Acc_1102050101_4011::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.4022') {
                Acc_1102050101_4022::where('an', $an)->delete();
            // } elseif ($pangold == '1102050102.602') {
            //     Acc_1102050102_602::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.603') {
                Acc_1102050102_603::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.801') {
                Acc_1102050102_801::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.802') {
                Acc_1102050102_802::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.803') {
                Acc_1102050102_803::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.804') {
                Acc_1102050102_804::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.8011') {
                Acc_1102050102_8011::where('vn', $vn)->delete();

            } elseif ($pangold == '1102050101.501') {
                Acc_1102050101_501::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.502') {
                Acc_1102050101_502::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.503') {
                Acc_1102050101_503::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.504') {
                Acc_1102050101_504::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.701') {
                Acc_1102050101_701::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.702') {
                Acc_1102050101_702::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.704') {
                Acc_1102050101_704::where('an', $an)->delete();

            } else {
                # code...
            }
        } elseif ($pang == '1102050102.603') {
            $check = Acc_1102050102_603::where('an', $an)->count();
            if ($check > 0) {
                # code...
            } else {
                Acc_1102050102_603::insert([
                    'vn'                => $vn,
                    'hn'                => $hn,
                    'an'                => $an,
                    'cid'               => $cid,
                    'ptname'            => $ptname,
                    'vstdate'           => $vstdate,
                    'dchdate'           => $dchdate,
                    'pttype'            => $pttype_new,
                    'account_code'      => $pang,
                    'debit'             => $debit_total_new,
                    'debit_total'       => $debit_total_new,
                    'comment'           => $comment,
                    'date_req'          => $date_req,
                    'acc_debtor_userid' => Auth::user()->id
                ]);
            }
            $check_acc = Acc_debtor::where('an', $an)->count();
            if ($check_acc > 0) {
                Acc_debtor::where('an', $an)->update([
                    'account_code'         => $pang,
                    'pttype'               => $pttype_new,
                    'debit'                => $debit_total_new,
                    'debit_total'          => $debit_total_new,
                ]);
            } else {
            }
            // $pangold
            if ($pangold == '1102050101.201') {
                Acc_1102050101_201::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.106') {
                Acc_1102050102_106::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.107') {
                Acc_1102050102_107::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.202') {
                Acc_1102050101_202::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.203') {
                Acc_1102050101_202::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.209') {
                Acc_1102050101_209::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.216') {
                Acc_1102050101_216::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.217') {
                Acc_1102050101_217::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.301') {
                Acc_1102050101_301::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.302') {
                Acc_1102050101_302::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.304') {
                Acc_1102050101_304::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.307') {
                Acc_1102050101_307::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.308') {
                Acc_1102050101_308::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.309') {
                Acc_1102050101_309::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.310') {
                Acc_1102050101_310::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.401') {
                Acc_1102050101_401::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.402') {
                Acc_1102050101_402::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.2166') {
                Acc_1102050101_2166::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.3099') {
                Acc_1102050101_3099::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.4011') {
                Acc_1102050101_4011::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.4022') {
                Acc_1102050101_4022::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.602') {
                Acc_1102050102_602::where('vn', $vn)->delete();
            // } elseif ($pangold == '1102050102.603') {
            //     Acc_1102050102_603::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.801') {
                Acc_1102050102_801::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.802') {
                Acc_1102050102_802::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.803') {
                Acc_1102050102_803::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.804') {
                Acc_1102050102_804::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.8011') {
                Acc_1102050102_8011::where('vn', $vn)->delete();

            } elseif ($pangold == '1102050101.501') {
                Acc_1102050101_501::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.502') {
                Acc_1102050101_502::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.503') {
                Acc_1102050101_503::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.504') {
                Acc_1102050101_504::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.701') {
                Acc_1102050101_701::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.702') {
                Acc_1102050101_702::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.704') {
                Acc_1102050101_704::where('an', $an)->delete();

            } else {
                # code...
            }
        } elseif ($pang == '1102050102.801') {
            $check = Acc_1102050102_801::where('vn', $vn)->count();
            if ($check > 0) {
                # code...
            } else {
                Acc_1102050102_801::insert([
                    'vn'                => $vn,
                    'hn'                => $hn,
                    'an'                => $an,
                    'cid'               => $cid,
                    'ptname'            => $ptname,
                    'vstdate'           => $vstdate,
                    'dchdate'           => $dchdate,
                    'pttype'            => $pttype_new,
                    'account_code'      => $pang,
                    'debit'             => $debit_total_new,
                    'debit_total'       => $debit_total_new,
                    'comment'           => $comment,
                    'date_req'          => $date_req,
                    'acc_debtor_userid' => Auth::user()->id
                ]);
            }
            $check_acc = Acc_debtor::where('vn', $vn)->count();
            if ($check_acc > 0) {
                Acc_debtor::where('vn', $vn)->update([
                    'account_code'         => $pang,
                    'pttype'               => $pttype_new,
                    'debit'                => $debit_total_new,
                    'debit_total'          => $debit_total_new,
                ]);
            } else {
            }
            // $pangold
            if ($pangold == '1102050101.201') {
                Acc_1102050101_201::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.106') {
                Acc_1102050102_106::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.107') {
                Acc_1102050102_107::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.202') {
                Acc_1102050101_202::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.203') {
                Acc_1102050101_202::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.209') {
                Acc_1102050101_209::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.216') {
                Acc_1102050101_216::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.217') {
                Acc_1102050101_217::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.301') {
                Acc_1102050101_301::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.302') {
                Acc_1102050101_302::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.304') {
                Acc_1102050101_304::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.307') {
                Acc_1102050101_307::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.308') {
                Acc_1102050101_308::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.309') {
                Acc_1102050101_309::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.310') {
                Acc_1102050101_310::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.401') {
                Acc_1102050101_401::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.402') {
                Acc_1102050101_402::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.2166') {
                Acc_1102050101_2166::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.3099') {
                Acc_1102050101_3099::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.4011') {
                Acc_1102050101_4011::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.4022') {
                Acc_1102050101_4022::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.602') {
                Acc_1102050102_602::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.603') {
                Acc_1102050102_603::where('an', $an)->delete();
            // } elseif ($pangold == '1102050102.801') {
            //     Acc_1102050102_801::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.802') {
                Acc_1102050102_802::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.803') {
                Acc_1102050102_803::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.804') {
                Acc_1102050102_804::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.8011') {
                Acc_1102050102_8011::where('vn', $vn)->delete();

            } elseif ($pangold == '1102050101.501') {
                Acc_1102050101_501::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.502') {
                Acc_1102050101_502::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.503') {
                Acc_1102050101_503::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.504') {
                Acc_1102050101_504::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.701') {
                Acc_1102050101_701::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.702') {
                Acc_1102050101_702::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.704') {
                Acc_1102050101_704::where('an', $an)->delete();

            } else {
                # code...
            }
        } elseif ($pang == '1102050102.802') {
            $check = Acc_1102050102_802::where('an', $an)->count();
            if ($check > 0) {
                # code...
            } else {
                Acc_1102050102_802::insert([
                    'vn'                => $vn,
                    'hn'                => $hn,
                    'an'                => $an,
                    'cid'               => $cid,
                    'ptname'            => $ptname,
                    'vstdate'           => $vstdate,
                    'dchdate'           => $dchdate,
                    'pttype'            => $pttype_new,
                    'account_code'      => $pang,
                    'debit'             => $debit_total_new,
                    'debit_total'       => $debit_total_new,
                    'comment'           => $comment,
                    'date_req'          => $date_req,
                    'acc_debtor_userid' => Auth::user()->id
                ]);
            }
            $check_acc = Acc_debtor::where('an', $an)->count();
            if ($check_acc > 0) {
                Acc_debtor::where('an', $an)->update([
                    'account_code'         => $pang,
                    'pttype'               => $pttype_new,
                    'debit'                => $debit_total_new,
                    'debit_total'          => $debit_total_new,
                ]);
            } else {
            }
            // $pangold
            if ($pangold == '1102050101.201') {
                Acc_1102050101_201::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.106') {
                Acc_1102050102_106::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.107') {
                Acc_1102050102_107::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.202') {
                Acc_1102050101_202::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.203') {
                Acc_1102050101_202::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.209') {
                Acc_1102050101_209::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.216') {
                Acc_1102050101_216::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.217') {
                Acc_1102050101_217::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.301') {
                Acc_1102050101_301::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.302') {
                Acc_1102050101_302::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.304') {
                Acc_1102050101_304::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.307') {
                Acc_1102050101_307::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.308') {
                Acc_1102050101_308::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.309') {
                Acc_1102050101_309::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.310') {
                Acc_1102050101_310::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.401') {
                Acc_1102050101_401::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.402') {
                Acc_1102050101_402::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.2166') {
                Acc_1102050101_2166::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.3099') {
                Acc_1102050101_3099::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.4011') {
                Acc_1102050101_4011::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.4022') {
                Acc_1102050101_4022::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.602') {
                Acc_1102050102_602::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.603') {
                Acc_1102050102_603::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.801') {
                Acc_1102050102_801::where('vn', $vn)->delete();
            // } elseif ($pangold == '1102050102.802') {
            //     Acc_1102050102_802::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.803') {
                Acc_1102050102_803::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.804') {
                Acc_1102050102_804::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.8011') {
                Acc_1102050102_8011::where('vn', $vn)->delete();

            } elseif ($pangold == '1102050101.501') {
                Acc_1102050101_501::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.502') {
                Acc_1102050101_502::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.503') {
                Acc_1102050101_503::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.504') {
                Acc_1102050101_504::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.701') {
                Acc_1102050101_701::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.702') {
                Acc_1102050101_702::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.704') {
                Acc_1102050101_704::where('an', $an)->delete();

            } else {
                # code...
            }
        } elseif ($pang == '1102050102.803') {
            $check = Acc_1102050102_803::where('vn', $vn)->count();
            if ($check > 0) {
                # code...
            } else {
                Acc_1102050102_803::insert([
                    'vn'                => $vn,
                    'hn'                => $hn,
                    'an'                => $an,
                    'cid'               => $cid,
                    'ptname'            => $ptname,
                    'vstdate'           => $vstdate,
                    'dchdate'           => $dchdate,
                    'pttype'            => $pttype_new,
                    'account_code'      => $pang,
                    'debit'             => $debit_total_new,
                    'debit_total'       => $debit_total_new,
                    'comment'           => $comment,
                    'date_req'          => $date_req,
                    'acc_debtor_userid' => Auth::user()->id
                ]);
            }
            $check_acc = Acc_debtor::where('vn', $vn)->count();
            if ($check_acc > 0) {
                Acc_debtor::where('vn', $vn)->update([
                    'account_code'         => $pang,
                    'pttype'               => $pttype_new,
                    'debit'                => $debit_total_new,
                    'debit_total'          => $debit_total_new,
                ]);
            } else {
            }
            // $pangold
            if ($pangold == '1102050101.201') {
                Acc_1102050101_201::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.106') {
                Acc_1102050102_106::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.107') {
                Acc_1102050102_107::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.202') {
                Acc_1102050101_202::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.203') {
                Acc_1102050101_202::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.209') {
                Acc_1102050101_209::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.216') {
                Acc_1102050101_216::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.217') {
                Acc_1102050101_217::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.301') {
                Acc_1102050101_301::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.302') {
                Acc_1102050101_302::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.304') {
                Acc_1102050101_304::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.307') {
                Acc_1102050101_307::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.308') {
                Acc_1102050101_308::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.309') {
                Acc_1102050101_309::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.310') {
                Acc_1102050101_310::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.401') {
                Acc_1102050101_401::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.402') {
                Acc_1102050101_402::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.2166') {
                Acc_1102050101_2166::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.3099') {
                Acc_1102050101_3099::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.4011') {
                Acc_1102050101_4011::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.4022') {
                Acc_1102050101_4022::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.602') {
                Acc_1102050102_602::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.603') {
                Acc_1102050102_603::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.801') {
                Acc_1102050102_801::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.802') {
                Acc_1102050102_802::where('an', $an)->delete();
            // } elseif ($pangold == '1102050102.803') {
            //     Acc_1102050102_803::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.804') {
                Acc_1102050102_804::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.8011') {
                Acc_1102050102_8011::where('vn', $vn)->delete();

            } elseif ($pangold == '1102050101.501') {
                Acc_1102050101_501::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.502') {
                Acc_1102050101_502::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.503') {
                Acc_1102050101_503::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.504') {
                Acc_1102050101_504::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.701') {
                Acc_1102050101_701::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.702') {
                Acc_1102050101_702::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.704') {
                Acc_1102050101_704::where('an', $an)->delete();

            } else {
                # code...
            }
        } elseif ($pang == '1102050102.804') {
            $check = acc_1102050102_804::where('an', $an)->count();
            if ($check > 0) {
                # code...
            } else {
                acc_1102050102_804::insert([
                    'vn'                => $vn,
                    'hn'                => $hn,
                    'an'                => $an,
                    'cid'               => $cid,
                    'ptname'            => $ptname,
                    'vstdate'           => $vstdate,
                    'dchdate'           => $dchdate,
                    'pttype'            => $pttype_new,
                    'account_code'      => $pang,
                    'debit'             => $debit_total_new,
                    'debit_total'       => $debit_total_new,
                    'comment'           => $comment,
                    'date_req'          => $date_req,
                    'acc_debtor_userid' => Auth::user()->id
                ]);
            }
            $check_acc = Acc_debtor::where('an', $an)->count();
            if ($check_acc > 0) {
                Acc_debtor::where('an', $an)->update([
                    'account_code'         => $pang,
                    'pttype'               => $pttype_new,
                    'debit'                => $debit_total_new,
                    'debit_total'          => $debit_total_new,
                ]);
            } else {
            }
            // $pangold
            if ($pangold == '1102050101.201') {
                Acc_1102050101_201::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.106') {
                Acc_1102050102_106::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.107') {
                Acc_1102050102_107::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.202') {
                Acc_1102050101_202::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.203') {
                Acc_1102050101_202::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.209') {
                Acc_1102050101_209::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.216') {
                Acc_1102050101_216::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.217') {
                Acc_1102050101_217::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.301') {
                Acc_1102050101_301::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.302') {
                Acc_1102050101_302::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.304') {
                Acc_1102050101_304::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.307') {
                Acc_1102050101_307::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.308') {
                Acc_1102050101_308::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.309') {
                Acc_1102050101_309::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.310') {
                Acc_1102050101_310::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.401') {
                Acc_1102050101_401::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.402') {
                Acc_1102050101_402::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.2166') {
                Acc_1102050101_2166::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.3099') {
                Acc_1102050101_3099::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.4011') {
                Acc_1102050101_4011::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.4022') {
                Acc_1102050101_4022::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.602') {
                Acc_1102050102_602::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.603') {
                Acc_1102050102_603::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.801') {
                Acc_1102050102_801::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.802') {
                Acc_1102050102_802::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.803') {
                Acc_1102050102_803::where('vn', $vn)->delete();
            // } elseif ($pangold == '1102050102.804') {
            //     Acc_1102050102_804::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.8011') {
                Acc_1102050102_8011::where('vn', $vn)->delete();

            } elseif ($pangold == '1102050101.501') {
                Acc_1102050101_501::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.502') {
                Acc_1102050101_502::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.503') {
                Acc_1102050101_503::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.504') {
                Acc_1102050101_504::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.701') {
                Acc_1102050101_701::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.702') {
                Acc_1102050101_702::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.704') {
                Acc_1102050101_704::where('an', $an)->delete();

            } else {
                # code...
            }
        } elseif ($pang == '1102050102.8011') {
            $check = Acc_1102050102_8011::where('vn', $vn)->count();
            if ($check > 0) {
                # code...
            } else {
                Acc_1102050102_8011::insert([
                    'vn'                => $vn,
                    'hn'                => $hn,
                    'an'                => $an,
                    'cid'               => $cid,
                    'ptname'            => $ptname,
                    'vstdate'           => $vstdate,
                    'dchdate'           => $dchdate,
                    'pttype'            => $pttype_new,
                    'account_code'      => $pang,
                    'debit'             => $debit_total_new,
                    'debit_total'       => $debit_total_new,
                    'comment'           => $comment,
                    'date_req'          => $date_req,
                    'acc_debtor_userid' => Auth::user()->id
                ]);
            }
            $check_acc = Acc_debtor::where('vn', $vn)->count();
            if ($check_acc > 0) {
                Acc_debtor::where('vn', $vn)->update([
                    'account_code'         => $pang,
                    'pttype'               => $pttype_new,
                    'debit'                => $debit_total_new,
                    'debit_total'          => $debit_total_new,
                ]);
            } else {
            }
            // $pangold
            if ($pangold == '1102050101.201') {
                Acc_1102050101_201::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.106') {
                Acc_1102050102_106::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.107') {
                Acc_1102050102_107::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.202') {
                Acc_1102050101_202::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.203') {
                Acc_1102050101_202::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.209') {
                Acc_1102050101_209::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.216') {
                Acc_1102050101_216::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.217') {
                Acc_1102050101_217::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.301') {
                Acc_1102050101_301::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.302') {
                Acc_1102050101_302::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.304') {
                Acc_1102050101_304::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.307') {
                Acc_1102050101_307::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.308') {
                Acc_1102050101_308::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.309') {
                Acc_1102050101_309::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.310') {
                Acc_1102050101_310::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.401') {
                Acc_1102050101_401::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.402') {
                Acc_1102050101_402::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.2166') {
                Acc_1102050101_2166::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.3099') {
                Acc_1102050101_3099::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.4011') {
                Acc_1102050101_4011::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.4022') {
                Acc_1102050101_4022::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.602') {
                Acc_1102050102_602::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.603') {
                Acc_1102050102_603::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.801') {
                Acc_1102050102_801::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.802') {
                Acc_1102050102_802::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.803') {
                Acc_1102050102_803::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.804') {
                Acc_1102050102_804::where('an', $an)->delete();
            // } elseif ($pangold == '1102050102.8011') {
            //     Acc_1102050102_8011::where('vn', $vn)->delete();

            } elseif ($pangold == '1102050101.501') {
                Acc_1102050101_501::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.502') {
                Acc_1102050101_502::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.503') {
                Acc_1102050101_503::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.504') {
                Acc_1102050101_504::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.701') {
                Acc_1102050101_701::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.702') {
                Acc_1102050101_702::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.704') {
                Acc_1102050101_704::where('an', $an)->delete();

            } else {
                # code...
            }
        } elseif ($pang == '1102050101.501') {
            $check = Acc_1102050101_501::where('vn', $vn)->count();
            if ($check > 0) {
                # code...
            } else {
                Acc_1102050101_501::insert([
                    'vn'                => $vn,
                    'hn'                => $hn,
                    'an'                => $an,
                    'cid'               => $cid,
                    'ptname'            => $ptname,
                    'vstdate'           => $vstdate,
                    'dchdate'           => $dchdate,
                    'pttype'            => $pttype_new,
                    'account_code'      => $pang,
                    'debit'             => $debit_total_new,
                    'debit_total'       => $debit_total_new,
                    'comment'           => $comment,
                    'date_req'          => $date_req,
                    'acc_debtor_userid' => Auth::user()->id
                ]);
            }
            $check_acc = Acc_debtor::where('vn', $vn)->count();
            if ($check_acc > 0) {
                Acc_debtor::where('vn', $vn)->update([
                    'account_code'         => $pang,
                    'pttype'               => $pttype_new,
                    'debit'                => $debit_total_new,
                    'debit_total'          => $debit_total_new,
                ]);
            } else {
            }
            // $pangold
            if ($pangold == '1102050101.201') {
                Acc_1102050101_201::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.106') {
                Acc_1102050102_106::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.107') {
                Acc_1102050102_107::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.202') {
                Acc_1102050101_202::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.203') {
                Acc_1102050101_202::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.209') {
                Acc_1102050101_209::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.216') {
                Acc_1102050101_216::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.217') {
                Acc_1102050101_217::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.301') {
                Acc_1102050101_301::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.302') {
                Acc_1102050101_302::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.304') {
                Acc_1102050101_304::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.307') {
                Acc_1102050101_307::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.308') {
                Acc_1102050101_308::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.309') {
                Acc_1102050101_309::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.310') {
                Acc_1102050101_310::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.401') {
                Acc_1102050101_401::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.402') {
                Acc_1102050101_402::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.2166') {
                Acc_1102050101_2166::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.3099') {
                Acc_1102050101_3099::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.4011') {
                Acc_1102050101_4011::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.4022') {
                Acc_1102050101_4022::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.602') {
                Acc_1102050102_602::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.603') {
                Acc_1102050102_603::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.801') {
                Acc_1102050102_801::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.802') {
                Acc_1102050102_802::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.803') {
                Acc_1102050102_803::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.804') {
                Acc_1102050102_804::where('an', $an)->delete();
            
            // } elseif ($pangold == '1102050101.501') {
            //     Acc_1102050101_501::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.502') {
                Acc_1102050101_502::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.503') {
                Acc_1102050101_503::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.504') {
                Acc_1102050101_504::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.701') {
                Acc_1102050101_701::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.702') {
                Acc_1102050101_702::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.704') {
                Acc_1102050101_704::where('an', $an)->delete();

            } else {
                # code...
            }
        } elseif ($pang == '1102050101.502') {
            $check = Acc_1102050101_502::where('an', $an)->count();
            if ($check > 0) {
                # code...
            } else {
                Acc_1102050101_502::insert([
                    'vn'                => $vn,
                    'hn'                => $hn,
                    'an'                => $an,
                    'cid'               => $cid,
                    'ptname'            => $ptname,
                    'vstdate'           => $vstdate,
                    'dchdate'           => $dchdate,
                    'pttype'            => $pttype_new,
                    'account_code'      => $pang,
                    'debit'             => $debit_total_new,
                    'debit_total'       => $debit_total_new,
                    'comment'           => $comment,
                    'date_req'          => $date_req,
                    'acc_debtor_userid' => Auth::user()->id
                ]);
            }
            $check_acc = Acc_debtor::where('an', $an)->count();
            if ($check_acc > 0) {
                Acc_debtor::where('an', $an)->update([
                    'account_code'         => $pang,
                    'pttype'               => $pttype_new,
                    'debit'                => $debit_total_new,
                    'debit_total'          => $debit_total_new,
                ]);
            } else {
            }
            // $pangold
            if ($pangold == '1102050101.201') {
                Acc_1102050101_201::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.106') {
                Acc_1102050102_106::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.107') {
                Acc_1102050102_107::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.202') {
                Acc_1102050101_202::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.203') {
                Acc_1102050101_202::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.209') {
                Acc_1102050101_209::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.216') {
                Acc_1102050101_216::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.217') {
                Acc_1102050101_217::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.301') {
                Acc_1102050101_301::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.302') {
                Acc_1102050101_302::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.304') {
                Acc_1102050101_304::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.307') {
                Acc_1102050101_307::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.308') {
                Acc_1102050101_308::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.309') {
                Acc_1102050101_309::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.310') {
                Acc_1102050101_310::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.401') {
                Acc_1102050101_401::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.402') {
                Acc_1102050101_402::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.2166') {
                Acc_1102050101_2166::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.3099') {
                Acc_1102050101_3099::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.4011') {
                Acc_1102050101_4011::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.4022') {
                Acc_1102050101_4022::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.602') {
                Acc_1102050102_602::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.603') {
                Acc_1102050102_603::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.801') {
                Acc_1102050102_801::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.802') {
                Acc_1102050102_802::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.803') {
                Acc_1102050102_803::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.804') {
                Acc_1102050102_804::where('an', $an)->delete();
            
            } elseif ($pangold == '1102050101.501') {
                Acc_1102050101_501::where('vn', $vn)->delete();
            // } elseif ($pangold == '1102050101.502') {
            //     Acc_1102050101_502::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.503') {
                Acc_1102050101_503::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.504') {
                Acc_1102050101_504::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.701') {
                Acc_1102050101_701::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.702') {
                Acc_1102050101_702::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.704') {
                Acc_1102050101_704::where('an', $an)->delete();

            } else {
                # code...
            }
        } elseif ($pang == '1102050101.503') {
            $check = Acc_1102050101_503::where('vn', $vn)->count();
            if ($check > 0) {
                # code...
            } else {
                Acc_1102050101_503::insert([
                    'vn'                => $vn,
                    'hn'                => $hn,
                    'an'                => $an,
                    'cid'               => $cid,
                    'ptname'            => $ptname,
                    'vstdate'           => $vstdate,
                    'dchdate'           => $dchdate,
                    'pttype'            => $pttype_new,
                    'account_code'      => $pang,
                    'debit'             => $debit_total_new,
                    'debit_total'       => $debit_total_new,
                    'comment'           => $comment,
                    'date_req'          => $date_req,
                    'acc_debtor_userid' => Auth::user()->id
                ]);
            }
            $check_acc = Acc_debtor::where('vn', $vn)->count();
            if ($check_acc > 0) {
                Acc_debtor::where('vn', $vn)->update([
                    'account_code'         => $pang,
                    'pttype'               => $pttype_new,
                    'debit'                => $debit_total_new,
                    'debit_total'          => $debit_total_new,
                ]);
            } else {
            }
            // $pangold
            if ($pangold == '1102050101.201') {
                Acc_1102050101_201::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.106') {
                Acc_1102050102_106::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.107') {
                Acc_1102050102_107::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.202') {
                Acc_1102050101_202::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.203') {
                Acc_1102050101_202::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.209') {
                Acc_1102050101_209::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.216') {
                Acc_1102050101_216::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.217') {
                Acc_1102050101_217::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.301') {
                Acc_1102050101_301::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.302') {
                Acc_1102050101_302::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.304') {
                Acc_1102050101_304::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.307') {
                Acc_1102050101_307::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.308') {
                Acc_1102050101_308::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.309') {
                Acc_1102050101_309::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.310') {
                Acc_1102050101_310::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.401') {
                Acc_1102050101_401::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.402') {
                Acc_1102050101_402::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.2166') {
                Acc_1102050101_2166::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.3099') {
                Acc_1102050101_3099::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.4011') {
                Acc_1102050101_4011::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.4022') {
                Acc_1102050101_4022::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.602') {
                Acc_1102050102_602::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.603') {
                Acc_1102050102_603::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.801') {
                Acc_1102050102_801::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.802') {
                Acc_1102050102_802::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.803') {
                Acc_1102050102_803::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.804') {
                Acc_1102050102_804::where('an', $an)->delete();
            
            } elseif ($pangold == '1102050101.501') {
                Acc_1102050101_501::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.502') {
                Acc_1102050101_502::where('an', $an)->delete();
            // } elseif ($pangold == '1102050101.503') {
            //     Acc_1102050101_503::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.504') {
                Acc_1102050101_504::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.701') {
                Acc_1102050101_701::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.702') {
                Acc_1102050101_702::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.704') {
                Acc_1102050101_704::where('an', $an)->delete();

            } else {
                # code...
            }
        } elseif ($pang == '1102050101.504') {
            $check = Acc_1102050101_504::where('an', $an)->count();
            if ($check > 0) {
                # code...
            } else {
                Acc_1102050101_504::insert([
                    'vn'                => $vn,
                    'hn'                => $hn,
                    'an'                => $an,
                    'cid'               => $cid,
                    'ptname'            => $ptname,
                    'vstdate'           => $vstdate,
                    'dchdate'           => $dchdate,
                    'pttype'            => $pttype_new,
                    'account_code'      => $pang,
                    'debit'             => $debit_total_new,
                    'debit_total'       => $debit_total_new,
                    'comment'           => $comment,
                    'date_req'          => $date_req,
                    'acc_debtor_userid' => Auth::user()->id
                ]);
            }
            $check_acc = Acc_debtor::where('an', $an)->count();
            if ($check_acc > 0) {
                Acc_debtor::where('an', $an)->update([
                    'account_code'         => $pang,
                    'pttype'               => $pttype_new,
                    'debit'                => $debit_total_new,
                    'debit_total'          => $debit_total_new,
                ]);
            } else {
            }
            // $pangold
            if ($pangold == '1102050101.201') {
                Acc_1102050101_201::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.106') {
                Acc_1102050102_106::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.107') {
                Acc_1102050102_107::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.202') {
                Acc_1102050101_202::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.203') {
                Acc_1102050101_202::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.209') {
                Acc_1102050101_209::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.216') {
                Acc_1102050101_216::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.217') {
                Acc_1102050101_217::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.301') {
                Acc_1102050101_301::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.302') {
                Acc_1102050101_302::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.304') {
                Acc_1102050101_304::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.307') {
                Acc_1102050101_307::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.308') {
                Acc_1102050101_308::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.309') {
                Acc_1102050101_309::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.310') {
                Acc_1102050101_310::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.401') {
                Acc_1102050101_401::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.402') {
                Acc_1102050101_402::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.2166') {
                Acc_1102050101_2166::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.3099') {
                Acc_1102050101_3099::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.4011') {
                Acc_1102050101_4011::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.4022') {
                Acc_1102050101_4022::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.602') {
                Acc_1102050102_602::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.603') {
                Acc_1102050102_603::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.801') {
                Acc_1102050102_801::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.802') {
                Acc_1102050102_802::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.803') {
                Acc_1102050102_803::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.804') {
                Acc_1102050102_804::where('an', $an)->delete();
            
            } elseif ($pangold == '1102050101.501') {
                Acc_1102050101_501::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.502') {
                Acc_1102050101_502::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.503') {
                Acc_1102050101_503::where('vn', $vn)->delete();
            // } elseif ($pangold == '1102050101.504') {
            //     Acc_1102050101_504::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.701') {
                Acc_1102050101_701::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.702') {
                Acc_1102050101_702::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.704') {
                Acc_1102050101_704::where('an', $an)->delete();

            } else {
                # code...
            }
        } elseif ($pang == '1102050101.701') {
            $check = Acc_1102050101_701::where('vn', $vn)->count();
            if ($check > 0) {
                # code...
            } else {
                Acc_1102050101_701::insert([
                    'vn'                => $vn,
                    'hn'                => $hn,
                    'an'                => $an,
                    'cid'               => $cid,
                    'ptname'            => $ptname,
                    'vstdate'           => $vstdate,
                    'dchdate'           => $dchdate,
                    'pttype'            => $pttype_new,
                    'account_code'      => $pang,
                    'debit'             => $debit_total_new,
                    'debit_total'       => $debit_total_new,
                    'comment'           => $comment,
                    'date_req'          => $date_req,
                    'acc_debtor_userid' => Auth::user()->id
                ]);
            }
            $check_acc = Acc_debtor::where('vn', $vn)->count();
            if ($check_acc > 0) {
                Acc_debtor::where('vn', $vn)->update([
                    'account_code'         => $pang,
                    'pttype'               => $pttype_new,
                    'debit'                => $debit_total_new,
                    'debit_total'          => $debit_total_new,
                ]);
            } else {
            }
            // $pangold
            if ($pangold == '1102050101.201') {
                Acc_1102050101_201::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.106') {
                Acc_1102050102_106::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.107') {
                Acc_1102050102_107::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.202') {
                Acc_1102050101_202::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.203') {
                Acc_1102050101_202::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.209') {
                Acc_1102050101_209::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.216') {
                Acc_1102050101_216::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.217') {
                Acc_1102050101_217::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.301') {
                Acc_1102050101_301::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.302') {
                Acc_1102050101_302::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.304') {
                Acc_1102050101_304::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.307') {
                Acc_1102050101_307::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.308') {
                Acc_1102050101_308::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.309') {
                Acc_1102050101_309::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.310') {
                Acc_1102050101_310::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.401') {
                Acc_1102050101_401::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.402') {
                Acc_1102050101_402::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.2166') {
                Acc_1102050101_2166::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.3099') {
                Acc_1102050101_3099::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.4011') {
                Acc_1102050101_4011::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.4022') {
                Acc_1102050101_4022::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.602') {
                Acc_1102050102_602::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.603') {
                Acc_1102050102_603::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.801') {
                Acc_1102050102_801::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.802') {
                Acc_1102050102_802::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.803') {
                Acc_1102050102_803::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.804') {
                Acc_1102050102_804::where('an', $an)->delete();
            
            } elseif ($pangold == '1102050101.501') {
                Acc_1102050101_501::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.502') {
                Acc_1102050101_502::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.503') {
                Acc_1102050101_503::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.504') {
                Acc_1102050101_504::where('an', $an)->delete();
            // } elseif ($pangold == '1102050101.701') {
            //     Acc_1102050101_701::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.702') {
                Acc_1102050101_702::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.704') {
                Acc_1102050101_704::where('an', $an)->delete();

            } else {
                # code...
            }
        } elseif ($pang == '1102050101.702') {
            $check = Acc_1102050101_702::where('vn', $vn)->count();
            if ($check > 0) {
                # code...
            } else {
                Acc_1102050101_702::insert([
                    'vn'                => $vn,
                    'hn'                => $hn,
                    'an'                => $an,
                    'cid'               => $cid,
                    'ptname'            => $ptname,
                    'vstdate'           => $vstdate,
                    'dchdate'           => $dchdate,
                    'pttype'            => $pttype_new,
                    'account_code'      => $pang,
                    'debit'             => $debit_total_new,
                    'debit_total'       => $debit_total_new,
                    'comment'           => $comment,
                    'date_req'          => $date_req,
                    'acc_debtor_userid' => Auth::user()->id
                ]);
            }
            $check_acc = Acc_debtor::where('vn', $vn)->count();
            if ($check_acc > 0) {
                Acc_debtor::where('vn', $vn)->update([
                    'account_code'         => $pang,
                    'pttype'               => $pttype_new,
                    'debit'                => $debit_total_new,
                    'debit_total'          => $debit_total_new,
                ]);
            } else {
            }
            // $pangold
            if ($pangold == '1102050101.201') {
                Acc_1102050101_201::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.106') {
                Acc_1102050102_106::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.107') {
                Acc_1102050102_107::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.202') {
                Acc_1102050101_202::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.203') {
                Acc_1102050101_202::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.209') {
                Acc_1102050101_209::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.216') {
                Acc_1102050101_216::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.217') {
                Acc_1102050101_217::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.301') {
                Acc_1102050101_301::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.302') {
                Acc_1102050101_302::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.304') {
                Acc_1102050101_304::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.307') {
                Acc_1102050101_307::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.308') {
                Acc_1102050101_308::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.309') {
                Acc_1102050101_309::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.310') {
                Acc_1102050101_310::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.401') {
                Acc_1102050101_401::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.402') {
                Acc_1102050101_402::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.2166') {
                Acc_1102050101_2166::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.3099') {
                Acc_1102050101_3099::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.4011') {
                Acc_1102050101_4011::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.4022') {
                Acc_1102050101_4022::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.602') {
                Acc_1102050102_602::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.603') {
                Acc_1102050102_603::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.801') {
                Acc_1102050102_801::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.802') {
                Acc_1102050102_802::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.803') {
                Acc_1102050102_803::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.804') {
                Acc_1102050102_804::where('an', $an)->delete();
            
            } elseif ($pangold == '1102050101.501') {
                Acc_1102050101_501::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.502') {
                Acc_1102050101_502::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.503') {
                Acc_1102050101_503::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.504') {
                Acc_1102050101_504::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.701') {
                Acc_1102050101_701::where('vn', $vn)->delete();
            // } elseif ($pangold == '1102050101.702') {
            //     Acc_1102050101_702::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.704') {
                Acc_1102050101_704::where('an', $an)->delete();

            } else {
                # code...
            }
        } elseif ($pang == '1102050101.704') {
            $check = Acc_1102050101_704::where('an', $an)->count();
            if ($check > 0) {
                # code...
            } else {
                Acc_1102050101_704::insert([
                    'vn'                => $vn,
                    'hn'                => $hn,
                    'an'                => $an,
                    'cid'               => $cid,
                    'ptname'            => $ptname,
                    'vstdate'           => $vstdate,
                    'dchdate'           => $dchdate,
                    'pttype'            => $pttype_new,
                    'account_code'      => $pang,
                    'debit'             => $debit_total_new,
                    'debit_total'       => $debit_total_new,
                    'comment'           => $comment,
                    'date_req'          => $date_req,
                    'acc_debtor_userid' => Auth::user()->id
                ]);
            }
            $check_acc = Acc_debtor::where('an', $an)->count();
            if ($check_acc > 0) {
                Acc_debtor::where('an', $an)->update([
                    'account_code'         => $pang,
                    'pttype'               => $pttype_new,
                    'debit'                => $debit_total_new,
                    'debit_total'          => $debit_total_new,
                ]);
            } else {
            }
            // $pangold
            if ($pangold == '1102050101.201') {
                Acc_1102050101_201::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.106') {
                Acc_1102050102_106::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.107') {
                Acc_1102050102_107::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.202') {
                Acc_1102050101_202::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.203') {
                Acc_1102050101_202::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.209') {
                Acc_1102050101_209::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.216') {
                Acc_1102050101_216::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.217') {
                Acc_1102050101_217::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.301') {
                Acc_1102050101_301::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.302') {
                Acc_1102050101_302::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.304') {
                Acc_1102050101_304::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.307') {
                Acc_1102050101_307::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.308') {
                Acc_1102050101_308::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.309') {
                Acc_1102050101_309::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.310') {
                Acc_1102050101_310::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.401') {
                Acc_1102050101_401::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.402') {
                Acc_1102050101_402::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.2166') {
                Acc_1102050101_2166::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.3099') {
                Acc_1102050101_3099::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.4011') {
                Acc_1102050101_4011::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.4022') {
                Acc_1102050101_4022::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.602') {
                Acc_1102050102_602::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.603') {
                Acc_1102050102_603::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.801') {
                Acc_1102050102_801::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.802') {
                Acc_1102050102_802::where('an', $an)->delete();
            } elseif ($pangold == '1102050102.803') {
                Acc_1102050102_803::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050102.804') {
                Acc_1102050102_804::where('an', $an)->delete();
            
            } elseif ($pangold == '1102050101.501') {
                Acc_1102050101_501::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.502') {
                Acc_1102050101_502::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.503') {
                Acc_1102050101_503::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.504') {
                Acc_1102050101_504::where('an', $an)->delete();
            } elseif ($pangold == '1102050101.701') {
                Acc_1102050101_701::where('vn', $vn)->delete();
            } elseif ($pangold == '1102050101.702') {
                Acc_1102050101_702::where('vn', $vn)->delete();
            // } elseif ($pangold == '1102050101.704') {
            //     Acc_1102050101_704::where('an', $an)->delete();

            } else {
                # code...
            }
        } else {
            # code...
        }
        return response()->json([
            'status'                => '200',
            // 'data_pang'             =>  $data_pang,
        ]);
    }
}
