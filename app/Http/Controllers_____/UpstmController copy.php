<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\support\Facades\Hash;
use Illuminate\support\Facades\Validator;
use App\Models\User;
use App\Models\Stm;
use App\Models\m_registerdata;
use PDF;
use setasign\Fpdi\Fpdi;
use App\Models\Budget_year;
use Illuminate\Support\Facades\File;
use DataTables;
use Intervention\Image\ImageManagerStatic as Image;
use Rector\Config\RectorConfig;
use Rector\PHPOffice\Set\PHPOfficeSetList;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PHPExcel_IOFactory;
use App\Models\Stm_head;
use App\Models\Stm_import;
/** PHPExcel */
// require_once '../upstm/Classes/PHPExcel.php';

/** PHPExcel_IOFactory - Reader */
// include '../upstm/Classes/PHPExcel/IOFactory.php';

class UpstmController extends Controller
{ 
    public function import_stm(Request $request)
    { 
        $data['users'] = User::get();
        $inputFileName = 'sample.xlsx';
         
        return view('upstm.import_stm', $data);
    }
    public function import_stm_save(Request $request)
    { 

                $tar_file = $request->file_; 
                $file = $request->file('file_')->getClientOriginalName();

                $filename = pathinfo($file, PATHINFO_FILENAME);
                $extension = pathinfo($file, PATHINFO_EXTENSION);           
                $tar_file = "Stm/".$file;               
                $name_file = $filename.'.'.$extension; 
                $xmlString = file_get_contents(public_path($tar_file));
                $xmlObject = simplexml_load_string($xmlString);
                $json = json_encode($xmlObject);
                // $json = json_encode($file);
                $result = json_decode($json, true); 
           
                // dd($result);
                @$stmAccountID = $result['stmAccountID'];
                @$hcode = $result['hcode'];
                @$hname = $result['hname'];
                @$AccPeriod = $result['AccPeriod'];
                @$STMdoc = $result['STMdoc']; //ชื่อไฟล์
                @$dateStart = $result['dateStart']; //"5  ธันวาคม  2565"
                @$dateEnd = $result['dateEnd'];  //"18  ธันวาคม  2565"
                @$dateData = $result['dateData'];  //"3  มกราคม  2566"
                @$dateIssue = $result['dateIssue'];  //"4  มกราคม  2566"
                @$acount = $result['acount'];  //"102"
                @$amount = $result['amount'];  //"192100.0000"
                @$thamount = $result['thamount'];  // "หนึ่งแสนเก้าหมื่นสองพันหนึ่งร้อยบาทถ้วน"
               
                @$STMdat = $result['STMdat'];  // array
                // @$TBills = $result['TBills'];  // array
                                
                @$TBills1 = $result['TBills']['ST']['HG']['TBill'];  // array
                @$TBills2 = $result['TBills']['ST']['HG'];  // array

                @$Remarks = $result['Remarks'];  // array
                @$config = $result['config'];  // array
                
                $dates = date('Y-m-d H:m:s');
                $namedoc = $STMdoc.'.'.$extension;
                $check = Stm_head::where('STMdoc','=',$namedoc)->count();
                if ($check >0) {
                    # code...
                } else {
                    Stm_head::insert([                        
                        'stmAccountID'       => $stmAccountID, 
                        'hcode'              => $hcode,
                        'hname'              => $hname,
                        'AccPeriod'          => $AccPeriod,
                        'STMdoc'             => $STMdoc.'.'.$extension,
                        'dateStart'          => $dateStart,
                        'dateEnd'            => $dateEnd,
                        'dateData'           => $dateData,
                        'dateIssue'          => $dateIssue,
                        'acount'             => $acount,
                        'amount'             => $amount,
                        'thamount'           => $thamount,
                        'created_at'         => $dates
                    ]); 
                }
                
                              
                               
                    $hd_bills        = @$TBills1;
                    $hd_bills2       = @$TBills2;

                    // dd($hd_bills2);   
                    if ($hd_bills == null) {
                        foreach ($hd_bills2 as $key => $value) {  
                                $tb_ = $value['TBill']; 
                        }
                        // dd($tb_); 
                        foreach ($tb_ as $key => $value) {
                            $invno = @$value['invno'];
                            $total = @$value['total'];

                            // dd($invno);
                            Stm::where('VN', $invno) 
                            ->update([ 
                                'Filename'           => $name_file,
                                'total_back_stm'     => $total,
                                'status'             =>'REP'                                
                            ]); 

                        }
                            // @$TBill = $value['TBill']; 
                           
                            // $invno = @$TBill[1]['invno'];
                            // $total = @$TBill[1]['total'];
                            // // dd($invno); 
                        
                            // Stm_head::insert([                        
                            //     'stmAccountID'       => $stmAccountID, 
                            //     'hcode'              => $hcode,
                            //     'hname'              => $hname,
                            //     'AccPeriod'          => $AccPeriod,
                            //     'STMdoc'             => $STMdoc.'.'.$extension,
                            //     'dateStart'          => $dateStart,
                            //     'dateEnd'            => $dateEnd,
                            //     'dateData'           => $dateData,
                            //     'dateIssue'          => $dateIssue,
                            //     'acount'             => $acount,
                            //     'amount'             => $amount,
                            //     'thamount'           => $thamount,
                            //     'created_at'         => $dates
                            // ]);                
                                 


                            // dd($tbil);  
                            // foreach ($tbil as $item) {
                            //     dd($item->invno);  
                            //     $invno = $item->invno;
                            //     $dttran = $item->dttran;    
                            //     $ex_dttran = explode("T",$item->dttran);
                            //     $dttran1 = $ex_dttran[0];
                            //     $dttran2 = $ex_dttran[1]; 
                            //     $ye = date('Y',strtotime($dttran1))+543;
                            //     $y = substr($ye, -2);
                            //     $m = date('m',strtotime($dttran1));
                            //     $d = date('d',strtotime($dttran1));
                            //     $dttran_1 =  $y.''.$m.''.$d; 
                            //     $time_now = date("H:i:s");
                            //         #ตัดขีด, ตัด : ออก
                            //     $pattern_date = '/-/i';
                            //     $aipn_date_now_preg = preg_replace($pattern_date, '', $dttran1);
                            //     $pattern_time = '/:/i';
                            //     $aipn_time_now_preg = preg_replace($pattern_time, '', $dttran2);
                                
                            //     $pid = $item->pid;
                            //     $hn = $item->hn;
                            //     $total = $item->total;
                            //     $rid = $item->rid; 
    
                                // Stm::where('VN', $invno) 
                                // ->update([ 
                                //     'Filename'           => $name_file,
                                //     'total_back_stm'     => @$total,
                                //     'status'             =>'REP'                                
                                // ]); 
                            // }

                            
                        // }
                        // @$TBills1 = $result['TBills']['ST']['HG']['TBill']; 
                    } else {
                        foreach ($hd_bills as $key => $item) {  
                            $invno = $item['invno'];
                            $dttran = $item['dttran'];    
                            $ex_dttran = explode("T",$item['dttran']);
                            $dttran1 = $ex_dttran[0];
                            $dttran2 = $ex_dttran[1]; 
                            $ye = date('Y',strtotime($dttran1))+543;
                            $y = substr($ye, -2);
                            $m = date('m',strtotime($dttran1));
                            $d = date('d',strtotime($dttran1));
                            $dttran_1 =  $y.''.$m.''.$d;
                            // dd($d);
                            // $sss_date_now = date("Y-m-d");
                            $time_now = date("H:i:s");
                                #ตัดขีด, ตัด : ออก
                            $pattern_date = '/-/i';
                            $aipn_date_now_preg = preg_replace($pattern_date, '', $dttran1);
                            $pattern_time = '/:/i';
                            $aipn_time_now_preg = preg_replace($pattern_time, '', $dttran2);
                            #ตัดขีด, ตัด : ออก
                            // $year = substr(date("Y"),2) +43;
                            // $mounts = date('m');
                            // $day = date('d');
                            // $time = date("His");  
                            // $vn = $year.''.$mounts.''.$day.''.$time;
                            $pid = $item['pid'];
                            $hn = $item['hn'];
                            $total = $item['total'];
                            $rid = $item['rid']; 

                            Stm::where('VN', $invno) 
                            ->update([ 
                                'Filename'           => $name_file,
                                'total_back_stm'     => @$total,
                                'status'             =>'REP' 
                            ]);  
                    }
                    }
                                    
  
                   
                     
                 
        return redirect()->back();
    }
}

