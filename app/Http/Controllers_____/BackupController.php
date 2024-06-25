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
use App\Models\Acc_1102050101_301;
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
use App\Models\Acc_stm_prb;
use App\Models\Acc_stm_ti_totalhead;
use App\Models\Acc_stm_ti_excel;
use App\Models\Acc_stm_ofc;
use App\Models\acc_stm_ofcexcel;
use App\Models\Acc_stm_lgo;
use App\Models\Acc_stm_lgoexcel;
use App\Models\Check_sit_auto;
use App\Models\Acc_stm_ucs_excel;
use App\Models\Car_service;
use App\Models\Oapp;
use PDF;
use setasign\Fpdi\Fpdi;
use App\Models\Budget_year;
// use Illuminate\Support\Facades\File;
use DataTables;
use Intervention\Image\ImageManagerStatic as Image;
use App\Mail\DissendeMail;
use Mail;
// use Illuminate\Support\Facades\Storage;
use Auth;
use Http;
use SoapClient;
// use File;
// use SplFileObject;
use Arr;
use Artisan;
use Storage;
use File;
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


class BackupController extends Controller
{
    public function index(){

        return view('backups.index');
    }

    public function listbody(Request $request)
    {
        $allFiles = Storage::allFiles('backupDB');
        $files = array();
        $total = 0;
        $i = 0;
        foreach ($allFiles as $file) {
            $files[] = $this->fileInfo(pathinfo(storage_path() . '/app/' . $file));
            $index = $i++;
            $total += $files[$index]['count'];
        }

        return view('backups.viewbackup', compact('files'))
                ->with('total', formatSizeUnits($total));
    }

    public function fileInfo($filePath)
    {

        $file = array();
            $file['name'] = $filePath['filename'];
            $file['extension'] = $filePath['extension'];
            $file['size'] = formatSizeUnits(filesize($filePath['dirname'] . '/' . $filePath['basename']));
            $file['count'] = filesize($filePath['dirname'] . '/' . $filePath['basename']);

        return $file;
    }

    public function totalUnit()
    {
        $allFiles = Storage::allFiles('backupDB');
        $files = array();
        $total = 0;
        $i = 0;
        foreach ($allFiles as $file) {
            $files[] = $this->fileInfo(pathinfo(storage_path() . '/app/' . $file));
            $index = $i++;
            $total += $files[$index]['count'];
        }

        return formatSizeUnits($total);

    }


    public function backupnow(){
        $path = storage_path('app/backupDB');
        if(!File::isDirectory($path)){
            File::makeDirectory($path, 0777, true, true);
        }
        return Artisan::call('db:backup');
    }

    function download($name){
        // return Storage::disk('backupDB')->download($name.'.sql');
        // return Storage::disk('backupDB')->download($name.'.gz');
        // $pathdir =  "Export/".$folder."/";
        $pathdir = Storage::disk('backupDB');
        $zipcreated = $name.".gzip";

        $newzip = new ZipArchive;
        if($newzip -> open($zipcreated, ZipArchive::CREATE ) === TRUE) {
        $dir = opendir($pathdir);

        while($file = readdir($dir)) {
            if(is_file($pathdir.$file)) {
                $newzip -> addFile($pathdir.$file, $file);
            }
        }
        $newzip ->close();
                if (file_exists($zipcreated)) {
                    header('Content-Type: application/zip');
                    header('Content-Disposition: attachment; filename="'.basename($zipcreated).'"');
                    header('Content-Length: ' . filesize($zipcreated));
                    flush();
                    readfile($zipcreated);
                    //// delete file
                    unlink($zipcreated);
                    //// Get the list of all of file names ลบไฟล์ในโฟลเดอทั้งหมด ทิ้งก่อน
                    //// in the folder.
                    $files = glob($pathdir . '/*');
                    //// Loop through the file list
                    foreach($files as $file) {
                        //// Check for file
                        if(is_file($file)) {
                            //// Use unlink function to
                            //// delete the file.
                            // unlink($file);
                        }
                    }
                    // if(rmdir($pathdir)){ // ลบ folder ใน export
                    // }
                    return redirect()->back();
                }
        }
    }

    public function delete(Request $request){
        return response()->json([
            'success' => Storage::delete('backupDB/'.$request->id.'.gzip'),
            'message' => $request->id,
        ]);
    }


 }
