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

use App\Models\Acc_stm_repmoney;
use App\Models\Acc_stm_repmoney_file;
use App\Models\Acc_trimart;
use App\Models\Acc_1102050101_304;
use App\Models\Acc_1102050101_307;
use App\Models\Acc_1102050101_308;
use App\Models\Acc_1102050101_309;
use App\Models\Acc_1102050102_602;
use App\Models\Acc_1102050102_603;
 
use SplFileObject;
use Arr;
 
/** PHPExcel */
// require_once '../upstm/Classes/PHPExcel.php';

/** PHPExcel_IOFactory - Reader */
// include '../upstm/Classes/PHPExcel/IOFactory.php';

class UpstmController extends Controller
{ 
    public function uprep_money(Request $request)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        // $datashow = DB::connection('mysql')->select('SELECT * FROM acc_stm_repmoney ar LEFT JOIN acc_trimart_liss a ON a.acc_trimart_liss_id = ar.acc_stm_repmoney_tri ORDER BY acc_stm_repmoney_id DESC');
        $datashow = DB::connection('mysql')->select('
            SELECT YEAR(a.acc_trimart_start_date) as year,ar.acc_stm_repmoney_id,a.acc_trimart_code,a.acc_trimart_name
            ,ar.acc_stm_repmoney_book,ar.acc_stm_repmoney_no,ar.acc_stm_repmoney_price301,ar.acc_stm_repmoney_price302,ar.acc_stm_repmoney_price310,ar.acc_stm_repmoney_date,concat(u.fname," ",u.lname) as fullname
            FROM acc_stm_repmoney ar 
            LEFT JOIN acc_trimart a ON a.acc_trimart_id = ar.acc_trimart_id 
            LEFT JOIN users u ON u.id = ar.user_id 
            ORDER BY acc_stm_repmoney_id DESC
        ');
        $countc = DB::table('acc_stm_ucs_excel')->count();
        // $data['acc_trimart_liss'] = DB::table('acc_trimart_liss')->get();
        $data['trimart'] = DB::table('acc_trimart')->get();

        return view('account_pk.uprep_money',$data,[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
            'datashow'      =>     $datashow,
            'countc'        =>     $countc
        ]);
    }
    public function uprep_money_save(Request $request)
    {
        $add = new Acc_stm_repmoney();
        $add->acc_trimart_id               = $request->acc_stm_repmoney_tri;
        $add->acc_stm_repmoney_book        = $request->acc_stm_repmoney_book;
        $add->acc_stm_repmoney_no          = $request->acc_stm_repmoney_no;
        $add->acc_stm_repmoney_price301    = $request->acc_stm_repmoney_price301;
        $add->acc_stm_repmoney_price302    = $request->acc_stm_repmoney_price302;
        $add->acc_stm_repmoney_price310    = $request->acc_stm_repmoney_price310;
        $add->acc_stm_repmoney_date        = $request->acc_stm_repmoney_date;
        $add->user_id                      = $request->user_id;
        $add->save();
         
        return response()->json([
            'status'    => '200' 
        ]); 
    }
    public function uprep_money_edit(Request $request,$id)
    {
        $data_show = Acc_stm_repmoney::find($id);
        return response()->json([
            'status'               => '200', 
            'data_show'            =>  $data_show,
        ]);
    }
    public function uprep_money_update(Request $request)
    {
        $id = $request->acc_stm_repmoney_id;
        $update = Acc_stm_repmoney::find($id);
        $update->acc_trimart_id               = $request->acc_stm_repmoney_tri;
        $update->acc_stm_repmoney_book        = $request->acc_stm_repmoney_book;
        $update->acc_stm_repmoney_no          = $request->acc_stm_repmoney_no;
        $update->acc_stm_repmoney_price301    = $request->acc_stm_repmoney_price301;
        $update->acc_stm_repmoney_price302    = $request->acc_stm_repmoney_price302;
        $update->acc_stm_repmoney_price310    = $request->acc_stm_repmoney_price310;
        $update->acc_stm_repmoney_date        = $request->acc_stm_repmoney_date;
        $update->user_id                      = $request->user_id;
        $update->save();
         
        return response()->json([
            'status'    => '200' 
        ]); 
    }
    public function uprep_money_updatefile(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|file|mimes:xls,xlsx,pdf,png,jpeg'
        ]);
        // $the_file = $request->file('file'); 
        $file_name = $request->file('file')->getClientOriginalName(); //ชื่อไฟล์
        //    dd($file_name);
 
        $add = new Acc_stm_repmoney_file();
        $add->acc_stm_repmoney_id      = $request->input('acc_stm_repmoney_id');
        $add->file                     = $request->file('file');
        if($request->hasFile('file')){               
            $request->file->storeAs('account',$file_name,'public');
            $add->filename             = $file_name;
        }
        $add->save();
        return redirect()->route('acc.uprep_money');
        // return response()->json([
        //     'status'    => '200' 
        // ]); 
    }
    public function uprepdestroy(Request $request,$id)
    {
        
        $file_ = Acc_stm_repmoney_file::find($id);  
        $file_name = $file_->filename; 
        $filepath = public_path('storage/account/'.$file_name);
        $description = File::delete($filepath);

        $del = Acc_stm_repmoney_file::find($id);  
        $del->delete(); 

        return redirect()->route('acc.uprep_money');
        // return response()->json(['status' => '200']);
    }

    
     public function uprep_sss_304(Request $request)
     { 
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $data['users'] = User::get(); 
        if ($startdate != '') {
            $data['data'] = DB::select('
            SELECT U1.acc_1102050101_304_id,U1.an,U1.vn,U1.hn,U1.cid,U1.ptname,U1.vstdate,U1.pttype,U1.debit_total,U1.nhso_docno,U1.dchdate,U1.recieve_no
                from acc_1102050101_304 U1 
                WHERE U1.dchdate BETWEEN "'.$startdate.'" AND "'.$enddate.'"
                GROUP BY U1.an
        ');  
        } else {
            $data['data'] = DB::select('
                SELECT U1.acc_1102050101_304_id,U1.an,U1.vn,U1.hn,U1.cid,U1.ptname,U1.vstdate,U1.pttype,U1.debit_total,U1.nhso_docno,U1.dchdate,U1.recieve_no
                    from acc_1102050101_304 U1
                
                    WHERE U1.nhso_docno <> ""
                    GROUP BY U1.an
            ');  
        }      
         return view('account_304.uprep_sss_304', $data,[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
         ]);
     }
     public function uprep_sss_304edit(Request $request,$id)
     {
         $data_show = Acc_1102050101_304::find($id);
         return response()->json([
             'status'               => '200', 
             'data_show'            =>  $data_show,
         ]);
     }
     public function uprep_sss_304_update(Request $request)
     {
         $id = $request->acc_1102050101_304_id;
         $update = Acc_1102050101_304::find($id);
         $update->recieve_true      = $request->recieve_true;
         $update->difference        = $request->difference;
         $update->recieve_no        = $request->recieve_no;
         $update->recieve_date      = $request->recieve_date;
         $update->recieve_user      = $request->user_id; 
         $update->save();
          
         return response()->json([
             'status'    => '200' 
         ]); 
     }

     public function uprep_sss_307(Request $request)
     { 
        $startdate = $request->startdate;
        $enddate = $request->enddate;
         $data['users'] = User::get(); 
         if ($startdate != '') {
            $data['data'] = DB::select('
            SELECT U1.acc_1102050101_307_id,U1.an,U1.vn,U1.hn,U1.cid,U1.ptname,U1.vstdate,U1.pttype,U1.debit_total,U1.nhso_docno,U1.dchdate,U1.recieve_no
                from acc_1102050101_307 U1
            
                WHERE U1.vstdate BETWEEN "'.$startdate.'" AND "'.$enddate.'"
                GROUP BY U1.vn
        ');   
         } else {
            $data['data'] = DB::select('
            SELECT U1.acc_1102050101_307_id,U1.an,U1.vn,U1.hn,U1.cid,U1.ptname,U1.vstdate,U1.pttype,U1.debit_total,U1.nhso_docno,U1.dchdate,U1.recieve_no
                from acc_1102050101_307 U1
               
                GROUP BY U1.vn
        ');   
         }
        //  WHERE U1.pttype IN("ss","C4","C5") 
        //  WHERE U1.nhso_docno <> ""      
         return view('account_307.uprep_sss_307', $data,[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
         ]);
     }
     public function uprep_sss_307edit(Request $request,$id)
     {
         $data_show = Acc_1102050101_307::find($id);
         return response()->json([
             'status'               => '200', 
             'data_show'            =>  $data_show,
         ]);
     }
     public function uprep_sss_307_update(Request $request)
     {
         $id = $request->acc_1102050101_307_id;
         $update = Acc_1102050101_307::find($id);
         $update->recieve_true      = $request->recieve_true;
         $update->difference        = $request->difference;
         $update->recieve_no        = $request->recieve_no;
         $update->recieve_date      = $request->recieve_date;
         $update->recieve_user      = $request->user_id; 
         $update->save();
          
         return response()->json([
             'status'    => '200' 
         ]); 
     }
     public function uprep_sss_308(Request $request)
     { 
        $startdate = $request->startdate;
        $enddate = $request->enddate;
         $data['users'] = User::get(); 
            if ($startdate != '') {
                $data['data'] = DB::select('
                    SELECT U1.acc_1102050101_308_id,U1.an,U1.vn,U1.hn,U1.cid,U1.ptname,U1.vstdate,U1.pttype,U1.debit_total,U1.nhso_docno,U1.dchdate,U1.recieve_no
                        from acc_1102050101_308 U1 
                        WHERE U1.dchdate BETWEEN "'.$startdate.'" AND "'.$enddate.'"
                        GROUP BY U1.an
                ');  
            } else {
                $data['data'] = DB::select('
                    SELECT U1.acc_1102050101_308_id,U1.an,U1.vn,U1.hn,U1.cid,U1.ptname,U1.vstdate,U1.pttype,U1.debit_total,U1.nhso_docno,U1.dchdate,U1.recieve_no
                        from acc_1102050101_308 U1
                    
                        WHERE U1.nhso_docno <> ""
                        GROUP BY U1.an
                ');  
            }      
          
         return view('account_308.uprep_sss_308', $data,[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
         ]);
     }
     public function uprep_sss_308edit(Request $request,$id)
     {
         $data_show = Acc_1102050101_308::find($id);
         return response()->json([
             'status'               => '200', 
             'data_show'            =>  $data_show,
         ]);
     }
     public function uprep_sss_308_update(Request $request)
     {
         $id = $request->acc_1102050101_308_id;
         $update = Acc_1102050101_308::find($id);
         $update->recieve_true      = $request->recieve_true;
         $update->difference        = $request->difference;
         $update->recieve_no        = $request->recieve_no;
         $update->recieve_date      = $request->recieve_date;
         $update->recieve_user      = $request->user_id; 
         $update->save();
          
         return response()->json([
             'status'    => '200' 
         ]); 
     }
     public function uprep_sss_309(Request $request)
     { 
        $startdate = $request->startdate;
        $enddate = $request->enddate;
         $data['users'] = User::get(); 
            if ($startdate != '') {
                $data['data'] = DB::select('
                    SELECT U1.acc_1102050101_309_id,U1.an,U1.vn,U1.hn,U1.cid,U1.ptname,U1.vstdate,U1.pttype,U1.debit_total,U1.nhso_docno,U1.dchdate,U1.recieve_no
                        from acc_1102050101_309 U1 
                        WHERE U1.vstdate BETWEEN "'.$startdate.'" AND "'.$enddate.'"
                        GROUP BY U1.vn
                ');  
            } else {
                $data['data'] = DB::select('
                    SELECT U1.acc_1102050101_309_id,U1.an,U1.vn,U1.hn,U1.cid,U1.ptname,U1.vstdate,U1.pttype,U1.debit_total,U1.nhso_docno,U1.dchdate,U1.recieve_no
                        from acc_1102050101_309 U1
                    
                        WHERE U1.nhso_docno <> ""
                        GROUP BY U1.vn
                ');  
            } 
          
         return view('account_309.uprep_sss_309', $data,[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
         ]);
     }
     public function uprep_sss_all(Request $request)
     { 
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -3 months')); //ย้อนหลัง 3 เดือน
        $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี
        $yearnew = date('Y')+1;
        $yearold = date('Y');
        $start = (''.$yearold.'-10-01');
        $end = (''.$yearnew.'-09-30'); 

        // BETWEEN "2023-10-01" AND "2023-10-31" 

         $data['users'] = User::get(); 
            if ($startdate != '') {
                // AND U2.nhso_docno <> "" AND U2.nhso_ownright_pid <> ""
                $data['data'] = DB::select('                  
                        SELECT U1.acc_1102050101_304_id as id,U1.an,U1.vn,U1.hn,U1.cid,U1.ptname,U1.vstdate,U1.dchdate,U1.pttype,U1.debit_total,U1.account_code,U1.nhso_docno,U1.recieve_no,U1.nhso_ownright_pid,U1.recieve_true,U1.difference,U1.recieve_no,U1.recieve_date,U1.recieve_user
                        from acc_1102050101_304 U1 
                        WHERE U1.dchdate BETWEEN "'.$startdate.'" AND "'.$enddate.'" 

                        UNION 
                        
                        SELECT U2.acc_1102050101_307_id as id,U2.an,U2.vn,U2.hn,U2.cid,U2.ptname,U2.vstdate,U2.dchdate,U2.pttype,U2.debit_total,U2.account_code,U2.nhso_docno,U2.recieve_no,U2.nhso_ownright_pid,U2.recieve_true,U2.difference,U2.recieve_no,U2.recieve_date,U2.recieve_user
                        from acc_1102050101_307 U2 
                        WHERE U2.vstdate BETWEEN "'.$startdate.'" AND "'.$enddate.'" 
                       
                        
                        UNION 
                        
                        SELECT U3.acc_1102050101_308_id as id,U3.an,U3.vn,U3.hn,U3.cid,U3.ptname,U3.vstdate,U3.dchdate,U3.pttype,U3.debit_total,U3.account_code,U3.nhso_docno,U3.recieve_no,U3.nhso_ownright_pid,U3.recieve_true,U3.difference,U3.recieve_no,U3.recieve_date,U3.recieve_user
                        from acc_1102050101_308 U3 
                        WHERE U3.dchdate BETWEEN "'.$startdate.'" AND "'.$enddate.'" 

                        UNION 
                        
                        SELECT U4.acc_1102050101_309_id as id,U4.an,U4.vn,U4.hn,U4.cid,U4.ptname,U4.vstdate,U4.dchdate,U4.pttype,U4.debit_total,U4.account_code,U4.nhso_docno,U4.recieve_no,U4.nhso_ownright_pid,U4.recieve_true,U4.difference,U4.recieve_no,U4.recieve_date,U4.recieve_user
                        from acc_1102050101_309 U4 
                        WHERE U4.vstdate BETWEEN "'.$startdate.'" AND "'.$enddate.'"  
                ');  
                // AND U2.nhso_ownright_pid <> ""
                // AND U2.nhso_docno <> ""
            } else {
                $data['data'] = DB::select('
                        SELECT U1.acc_1102050101_304_id as id,U1.an,U1.vn,U1.hn,U1.cid,U1.ptname,U1.vstdate,U1.dchdate,U1.pttype,U1.debit_total,U1.account_code,U1.nhso_docno,U1.recieve_no,U1.nhso_ownright_pid,U1.recieve_true,U1.difference,U1.recieve_no,U1.recieve_date,U1.recieve_user
                        from acc_1102050101_304 U1 
                        WHERE U1.dchdate BETWEEN "'.$newDate.'" AND "'.$date.'"  

                        UNION 
                        
                        SELECT U2.acc_1102050101_307_id as id,U2.an,U2.vn,U2.hn,U2.cid,U2.ptname,U2.vstdate,U2.dchdate,U2.pttype,U2.debit_total,U2.account_code,U2.nhso_docno,U2.recieve_no,U2.nhso_ownright_pid,U2.recieve_true,U2.difference,U2.recieve_no,U2.recieve_date,U2.recieve_user
                        from acc_1102050101_307 U2 
                        WHERE U2.vstdate BETWEEN "'.$newDate.'" AND "'.$date.'" 

                        UNION 
                        
                        SELECT U3.acc_1102050101_308_id as id,U3.an,U3.vn,U3.hn,U3.cid,U3.ptname,U3.vstdate,U3.dchdate,U3.pttype,U3.debit_total,U3.account_code,U3.nhso_docno,U3.recieve_no,U3.nhso_ownright_pid,U3.recieve_true,U3.difference,U3.recieve_no,U3.recieve_date,U3.recieve_user
                        from acc_1102050101_308 U3 
                        WHERE U3.dchdate BETWEEN "'.$newDate.'" AND "'.$date.'"  

                        UNION 
                        
                        SELECT U4.acc_1102050101_309_id as id,U4.an,U4.vn,U4.hn,U4.cid,U4.ptname,U4.vstdate,U4.dchdate,U4.pttype,U4.debit_total,U4.account_code,U4.nhso_docno,U4.recieve_no,U4.nhso_ownright_pid,U4.recieve_true,U4.difference,U4.recieve_no,U4.recieve_date,U4.recieve_user
                        from acc_1102050101_309 U4 
                        WHERE U4.vstdate BETWEEN "'.$newDate.'" AND "'.$date.'" 
                ');  
            } 
            // AND U2.nhso_docno <> "" AND U2.nhso_ownright_pid <> ""
            // AND U2.nhso_docno <> "" AND U2.nhso_ownright_pid <> ""
            // AND U3.nhso_docno <> "" AND U3.nhso_ownright_pid <> ""
            // AND U4.nhso_docno <> "" AND U4.nhso_ownright_pid <> "" 
            // WHERE U2.nhso_ownright_pid <> ""
            // U2.nhso_docno <> "" AND 
         return view('account_stm.uprep_sss_all', $data,[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
         ]);
     }
     public function uprep_sss_alleditpage(Request $request,$account,$id)
     { 
        // dd($account);
        if ($account == '1102050101.304') {
            $data_show = Acc_1102050101_304::where('acc_1102050101_304_id',$id)->first();

        } elseif ($account == '1102050101.307') {
            $data_show = Acc_1102050101_307::where('acc_1102050101_307_id',$id)->first();
          
        } elseif ($account == '1102050101.308') {
            $data_show = Acc_1102050101_308::where('acc_1102050101_308_id',$id)->first();

        } elseif ($account == '1102050101.309') {
            $data_show = Acc_1102050101_309::where('acc_1102050101_309_id',$id)->first();

        } else {
            # code...
        }
         
        // dd($data_show->acc_1102050101_307_id);
        // dd($account);
         return view('account_stm.uprep_sss_alleditpage',[
            'data_show'     =>     $data_show ,
            'id'            =>     $id,
            'account'       =>     $account
         ]);
     }
     public function uprep_sss_all_update(Request $request)
     {
            $account        = $request->account_code;
            $id             = $request->id;
            $recieve_true   = $request->recieve_true; 
            $debit_total    = $request->debit_total;
       
            if ($recieve_true <= $debit_total) {
                $difference     = ($debit_total - $recieve_true);
            }elseif ($debit_total <= $recieve_true) {
                $difference     = - ($recieve_true - $debit_total);
            } else { 
                $difference     = $recieve_true - $debit_total;
            }
                           
            if ($account == '1102050101.304') { 
                $update = Acc_1102050101_304::find($id);
                $update->recieve_true      = $request->recieve_true;
                $update->difference        = $difference;
                $update->recieve_no        = $request->recieve_no;
                $update->recieve_date      = $request->recieve_date;
                $update->recieve_user      = $request->user_id; 
                $update->save(); 
            } elseif ($account == '1102050101.307') {
                $update2 = Acc_1102050101_307::find($id);
                $update2->recieve_true      = $request->recieve_true;
                $update2->difference        = $difference;
                $update2->recieve_no        = $request->recieve_no;
                $update2->recieve_date      = $request->recieve_date;
                $update2->recieve_user      = $request->user_id; 
                $update2->save();  
            } elseif ($account == '1102050101.308') {
                $update3 = Acc_1102050101_308::find($id);
                $update3->recieve_true      = $request->recieve_true;
                $update3->difference        = $difference;
                $update3->recieve_no        = $request->recieve_no;
                $update3->recieve_date      = $request->recieve_date;
                $update3->recieve_user      = $request->user_id; 
                $update3->save();  

            } elseif ($account == '1102050101.309') {
                $update4 = Acc_1102050101_309::find($id);
                $update4->recieve_true      = $request->recieve_true;
                $update4->difference        = $difference;
                $update4->recieve_no        = $request->recieve_no;
                $update4->recieve_date      = $request->recieve_date;
                $update4->recieve_user      = $request->user_id; 
                $update4->save();   
            } else {
                # code...
            }
             
            return response()->json([
                'status'    => '200' 
            ]); 
     }

     public function uprep_sss_alledit(Request $request,$pang,$id)
     {
        if ($pang == '1102050101.304') {
            // $data_show = Acc_1102050101_304::where('acc_1102050101_304_id',$id)->first();
            $data_show = Acc_1102050101_304::find($id);
        } elseif ($pang == '1102050101.307') {
            // $data_show = Acc_1102050101_307::where('acc_1102050101_307_id',$id)->first();
            $data_show = Acc_1102050101_307::find($id);
        } elseif ($pang == '1102050101.308') {
            // $data_show = Acc_1102050101_308::where('acc_1102050101_308_id',$id)->first();
            $data_show = Acc_1102050101_308::find($id);
        } elseif ($pang == '1102050101.309') {
            // $data_show = Acc_1102050101_309::where('acc_1102050101_309_id',$id)->first();
            $data_show = Acc_1102050101_309::find($id);
        } else {
            # code...
        }
        // $pang = substr($pang,0,14);        
        // dd($data_show);

        //  $data_show = Acc_1102050101_309::find($id);
         return response()->json([
             'status'          => '200', 
             'data_show'       =>  $data_show,
             'pang'            =>  $pang,
             'id'              =>  $id,
         ]);
     }
     public function uprep_sss_syncall(Request $request)
     {
         $startdate      = $request->startdate;
         $enddate        = $request->enddate;
        //  $sync = DB::connection('mysql2')->select(' 
        //         SELECT U1.acc_1102050101_304_id as id,U1.an,U1.vn,U1.hn,U1.cid,U1.ptname,U1.vstdate,U1.dchdate,U1.pttype,U1.debit_total,U1.account_code,U1.nhso_docno,U1.recieve_no,U1.nhso_ownright_pid,U1.recieve_true,U1.difference,U1.recieve_no,U1.recieve_date,U1.recieve_user
        //         from acc_1102050101_304 U1 
        //         WHERE U1.dchdate BETWEEN "'.$startdate.'" AND "'.$enddate.'"
        //         AND U1.nhso_docno <> "" AND U1.nhso_ownright_pid <> ""

        //         UNION 
                
        //         SELECT U2.acc_1102050101_307_id as id,U2.an,U2.vn,U2.hn,U2.cid,U2.ptname,U2.vstdate,U2.dchdate,U2.pttype,U2.debit_total,U2.account_code,U2.nhso_docno,U2.recieve_no,U2.nhso_ownright_pid,U2.recieve_true,U2.difference,U2.recieve_no,U2.recieve_date,U2.recieve_user
        //         from acc_1102050101_307 U2 
        //         WHERE U2.vstdate BETWEEN "'.$startdate.'" AND "'.$enddate.'"
        //         AND U1.nhso_docno <> "" AND U1.nhso_ownright_pid <> ""
                
        //         UNION 
                
        //         SELECT U3.acc_1102050101_308_id as id,U3.an,U3.vn,U3.hn,U3.cid,U3.ptname,U3.vstdate,U3.dchdate,U3.pttype,U3.debit_total,U3.account_code,U3.nhso_docno,U3.recieve_no,U3.nhso_ownright_pid,U3.recieve_true,U3.difference,U3.recieve_no,U3.recieve_date,U3.recieve_user
        //         from acc_1102050101_308 U3 
        //         WHERE U3.dchdate BETWEEN "'.$startdate.'" AND "'.$enddate.'" AND U3.nhso_docno <> "" AND U3.nhso_ownright_pid <> ""

        //         UNION 
                
        //         SELECT U4.acc_1102050101_309_id as id,U4.an,U4.vn,U4.hn,U4.cid,U4.ptname,U4.vstdate,U4.dchdate,U4.pttype,U4.debit_total,U4.account_code,U4.nhso_docno,U4.recieve_no,U4.nhso_ownright_pid,U4.recieve_true,U4.difference,U4.recieve_no,U4.recieve_date,U4.recieve_user
        //         from acc_1102050101_309 U4 
        //         WHERE U4.vstdate BETWEEN "'.$startdate.'" AND "'.$enddate.'" AND U4.nhso_docno <> "" AND U4.nhso_ownright_pid <> ""
                                
        //      ');
            $sync_304 = DB::connection('mysql')->select(' 
                SELECT ac.acc_1102050101_304_id,a.an,ip.pttype,ip.nhso_ownright_pid,ip.nhso_docno 
                FROM hos.an_stat a
                LEFT JOIN hos.ipt_pttype ip ON ip.an = a.an
                LEFT JOIN pkbackoffice.acc_1102050101_304 ac ON ac.an = a.an
                WHERE a.dchdate BETWEEN "'.$startdate.'" AND "'.$enddate.'" 
                AND ip.nhso_ownright_pid  <> "" 
                AND ip.nhso_docno  <> "" 
                AND ac.acc_1102050101_304_id <> ""
                and ip.pttype ="s7"
                
            ');
            foreach ($sync_304 as $key => $value) {                     
                    Acc_1102050101_304::where('an',$value->an) 
                        ->update([ 
                            'nhso_docno'           => $value->nhso_docno ,
                            'nhso_ownright_pid'    => $value->nhso_ownright_pid
                    ]);
            }
            
             return response()->json([
                 'status'    => '200'
             ]);
         
         
     }
    //  SELECT ac.acc_1102050101_304_id,a.an,ip.pttype,ip.nhso_ownright_pid,ip.nhso_docno 
    //  FROM hos.an_stat a
    //  LEFT JOIN hos.ipt_pttype ip ON ip.an = a.an
    //  LEFT JOIN pkbackoffice.acc_1102050101_304 ac ON ac.an = a.an
    //  WHERE month(a.dchdate) = "'.$startdate.'" 
    //  AND year(a.dchdate) = "'.$enddate.'" 
    //  AND ip.nhso_ownright_pid  <> "" 
    //  AND ip.nhso_docno  <> "" 
    //  AND ac.acc_1102050101_304_id <> ""
    //  and ip.pttype ="s7" 


     public function uprep_sss_309edit(Request $request,$id)
     {
         $data_show = Acc_1102050101_309::find($id);
         return response()->json([
             'status'               => '200', 
             'data_show'            =>  $data_show,
         ]);
     }
     public function uprep_sss_309_update(Request $request)
     {
         $id = $request->acc_1102050101_309_id;
         $update = Acc_1102050101_309::find($id);
         $update->recieve_true      = $request->recieve_true;
         $update->difference        = $request->difference;
         $update->recieve_no        = $request->recieve_no;
         $update->recieve_date      = $request->recieve_date;
         $update->recieve_user      = $request->user_id; 
         $update->save();
          
         return response()->json([
             'status'    => '200' 
         ]); 
     }
    // ***************           **************
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
                // $tar_file = "C:/Stm/".$file;             
                $name_file = $filename.'.'.$extension; 
                $xmlString = file_get_contents(public_path($tar_file));
                $xmlObject = simplexml_load_string($xmlString);
                $json = json_encode($xmlObject);
                // $json = json_encode($file);
                $result = json_decode($json, true); 
           
                dd($result);
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

                    // dd($hd_bills);   
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
    public function stm_aipn(Request $request)
    { 
        $data['users'] = User::get();
        $inputFileName = 'sample.xlsx';
         
        return view('upstm.stm_aipn', $data);
    }
    public function import_stm_aipn(Request $request)
    {  
            $tar_file_ = $request->file_; 
            $file = $request->file('file_')->getClientOriginalName(); //ชื่อไฟล์
            $filename = pathinfo($file, PATHINFO_FILENAME);
            $extension = pathinfo($file, PATHINFO_EXTENSION);           

            $xmlString = file_get_contents(($tar_file_));
            $xmlObject = simplexml_load_string($xmlString);
            $json = json_encode($xmlObject);
            // $json = json_encode($file);
            $result = json_decode($json, true); 
        
            // dd($result);
            @$stmAccountID = $result['stmAccountID'];
            @$stmdat = $result['stmdat'];
            @$hname = $result['hname'];
            @$MADat = $result['MADat'];
            @$ticket = $result['ticket']; //
            @$cfgs = $result['cfgs']; // 
            @$Remarks = $result['Remarks'];  // array
            // @$TBills2 = $result['TBills']['ST']['HG'];  // array
            // $madat_1      = $result['MADat'];  //มากกว่า 1 คน
            // $madat_2      = $result['MADat']['Bills'];
            // $madat_      = @$MADat['Bills']['ST'];
            // dd($madat_1);
            $Ref = $result['MADat']['Ref'];
            $adjrw = $result['MADat']['adjrw'];
            // dd($Ref);
            $madat_2      = $result['MADat']['Bills']['Bill']; // 1 คน
            // dd($madat_2);
            $an = $madat_2['an'];
            $hn = $madat_2['hn'];
            $pid = $madat_2['pid'];
            $drg = $madat_2['drg'];
            $rw = $madat_2['rw'];
            $adjrw2 = $madat_2['adjrw'];
            $rid = $madat_2['rid'];
            $PP = $madat_2['PP'];
            $Reimb = $madat_2['Reimb'];
            // dd($an);
            Stm::where('AN', $an) 
                        ->update([ 
                            'AdjRW'              => $adjrw,
                            'AdjRW2'             => $adjrw2,
                            'drg'                => $drg,
                            'PP'                 => $PP,
                            'REPNO'              => $Ref, 
                            'Filename'           => $file,
                            'total_back_stm'     => $Reimb,
                            'status'             => 'STATMENT'                                
                        ]); 
            // foreach ($madat_1 as $key => $value) { 
            //     $Ahcode = $value['Ahcode'];
            //     dd($Ahcode);
            //     $Ahname = @$value['Ahname'];
            //     $Mhcode = @$value['Mhcode'];
            //     $Mhname = @$value['Mhname'];
            //     $Ref = @$value['Ref'];
            //     $cases = @$value['cases'];
            //     $adjrw = @$value['adjrw'];
            //     $STMdat = @$value['STMdat'];
            //     $Bills = @$value['Bills']['Bill'];
            //     dd($Ahcode);
            //     $bills_       = @$Bills;
            //     foreach ($bills_ as $item) {
            //         $hn_ = $item['hn'];
            //         $an_ = $item['an'];
            //         $pid_ = $item['pid'];
            //         $name_ = $item['name'];
            //         $dateadm_ = $item['dateadm'];
            //         $datedsc_ = $item['datedsc'];
            //         $drg_ = $item['drg'];
            //         $rw_ = $item['rw'];
            //         $adjrw2_ = $item['adjrw'];
            //         $rptype_ = $item['rptype'];
            //         $rid_ = $item['rid'];
            //         $Reimb_ = $item['Reimb'];
            //         $Copay_ = $item['Copay'];
            //         $CP_ = $item['CP'];
            //         $PP_ = $item['PP'];
            //         $an = $an_;
            //         dd($an);
            //         Stm::where('AN', $an) 
            //             ->update([ 
            //                 'AdjRW'              => $adjrw,
            //                 'AdjRW2'             => $adjrw2,
            //                 'DRUG'               => $drg,
            //                 'PP'                 => $PP,
            //                 'REPNO'              => $Ref, 
            //                 'Filename'           => $file,
            //                 'total_back_stm'     => $Reimb,
            //                 'status'             => 'STATMENT'                                
            //             ]); 
            //     }
            // }

                return redirect()->back();
        // return view('upstm.import_stm_aipn', $data);
    }
    public function import_stm_aipnmax(Request $request)
    {  
            $tar_file_ = $request->file_; 
            $file = $request->file('file_')->getClientOriginalName(); //ชื่อไฟล์
            $filename = pathinfo($file, PATHINFO_FILENAME);
            $extension = pathinfo($file, PATHINFO_EXTENSION);           

            $xmlString = file_get_contents(($tar_file_));
            $xmlObject = simplexml_load_string($xmlString);
            $json = json_encode($xmlObject);
            // $json = json_encode($file);
            $result = json_decode($json, true); 
        
            // dd($result);
            @$stmAccountID = $result['stmAccountID'];
            @$stmdat = $result['stmdat'];
            @$hname = $result['hname'];
            // @$MADat = $result['MADat'];
            @$ticket = $result['ticket']; //
            @$cfgs = $result['cfgs']; // 
            @$Remarks = $result['Remarks'];  // array
            // @$TBills2 = $result['TBills']['ST']['HG'];  // array
            $madat_1      = $result['MADat'];  //มากกว่า 1 คน
            // $madat_2      = $result['MADat']['Bills'];
            // dd($result);
            // foreach ($madat_1 as $key => $value) { 
                $Ahcode = @$result['MADat']['Ahcode'];
                // dd($Ahcode);
                $Ahname = @$result['MADat']['Ahname'];
                $Mhcode = @$result['MADat']['Mhcode'];
                $Mhname = @$result['MADat']['Mhname'];
                $Ref = @$result['MADat']['Ref'];
                $cases = @$result['MADat']['cases'];
                $adjrw1 = @$result['MADat']['adjrw'];
                $STMdat = @$result['MADat']['STMdat'];
                $Bills = @$result['MADat']['Bills']['Bill'];
                // dd($STMdat);
                $bills_       = @$Bills; 
                // dd($bills_);
                foreach ($bills_ as $item) { 
                    isset( $item['an'] ) ? $an = $item['an'] : $an = "";
                    isset( $item['adjrw'] ) ? $adjrw = $item['adjrw'] : $adjrw = "";
                    isset( $item['drg'] ) ? $drg = $item['drg'] : $drg = "";
                    isset( $item['PP'] ) ? $PP = $item['PP'] : $PP = "";
                    isset( $item['name'] ) ? $name = $item['name'] : $name = "";

                    isset( $item['dateadm'] ) ? $dateadm = $item['dateadm'] : $dateadm = "";
                    isset( $item['datedsc'] ) ? $datedsc = $item['datedsc'] : $datedsc = "";
                    isset( $item['pid'] ) ? $pid = $item['pid'] : $pid = "";
                    isset( $item['Reimb'] ) ? $Reimb = $item['Reimb'] : $Reimb = "";
                    isset( $item['rid'] ) ? $rid = $item['rid'] : $rid = "";
                    isset( $item['Copay'] ) ? $Copay = $item['Copay'] : $Copay = "";
                    isset( $item['CP'] ) ? $CP = $item['CP'] : $CP = "";
                    isset( $item['rw'] ) ? $rw = $item['rw'] : $rw = "";
 
                    Stm::where('AN', $an) 
                        ->update([ 
                            'AdjRW'              => $adjrw1,
                            'AdjRW2'             => $adjrw,
                            'drg'               => $drg,
                            'PP'                 => $PP,
                            'REPNO'              => $Ref, 
                            'Filename'           => $file,
                            'total_back_stm'     => $Reimb,
                            'status'             => 'STATMENT'                                
                        ]); 
                }
            // }

                return redirect()->back();
        // return view('upstm.import_stm_aipn', $data);
    }
    public function import_rep_aipn(Request $request)
    { 
        $data['users'] = User::get();
        $inputFileName = 'sample.xlsx';
         
        return view('upstm.import_rep_aipn', $data);
    }
    public function import_rep_aipn_save(Request $request)
    { 

                $tar_file = $request->file_; 
                $file = $request->file('file_')->getClientOriginalName();
                // dd($file);
                $filename = pathinfo($file, PATHINFO_FILENAME);
               
                $path = "Stm/".$file;

                $txt_file = fopen('C:/REP/'.$filename.'.txt', 'r');
                $a = 1;
                while ($line = fgets($txt_file)) {
                    echo($a." ".$line)."<br>";
 
                    $a++;
                   }
                // while(! feof($txt_file))  {
                //     $result = fgets($txt_file);
                //     echo $result."<br> "; 
                //     $a++;
                //     // echo $result;
                //     // dd($result);
                //   }

                  dd($line);
     
                //   $string = file_get_contents( $tar_file );         
                //   $lines = explode('\n', $string);         
                      
                //   $line_count = 0;                  
                  
                //   foreach( $lines as $line ){
              
                //       $code .= 'Line: '.$line_count.' | '.$line.'<br />';         
              
                //       // iterate count ##
                //       $line_count ++;      
              
                //   }       
                //   dd($code);
                // $result = fgets($fn, 20);
                // echo $result;
                // fclose($fn);
                // $myFile = new SplFileObject('C:/REP/'.$filename.'.txt');

                // while (!$myFile->eof()) {
                //     echo $myFile->fgets() . PHP_EOL;
                // }

                // $contents = fopen('C:/REP/'.$filename.'.txt', 'r');
                // // dd($contents);
                // function get_all_lines($contents) { 
                //     while (!feof($contents)) {
                //         yield fgets($contents);
                //     }
                // }
               
                // $count = 0;
                // foreach (get_all_lines($contents) as $line) {
                //     $count += 1;
                //     echo $line."<br>";
                //     // $output = Arr::sort($line,2); 
                //     // echo $count."<br> ".$line; 
                // }
                // dd($line);
                // fclose($contents);

                // dd($contents);
                // $contents = file('C:/REP/'.$filename.'.txt', FILE_SKIP_EMPTY_LINES|FILE_IGNORE_NEW_LINES); 
                // $count = 0;
                // foreach($contents as $line) {
                //     $count += 1;
                //     echo str_pad($count, 2, 0, STR_PAD_LEFT).". ".$line;
                // }
                // dd($count);
                    // $contents = file($filename.''.'txt', FILE_SKIP_EMPTY_LINES|FILE_IGNORE_NEW_LINES);
                    // dd($contents);
                    // foreach($contents as $line) {  
                    // }
                    // $chars = preg_split('//', $line, -1, PREG_SPLIT_NO_EMPTY);
                    // $output = Arr::sort($chars,2);
                    // // dd($line[34]);
                    // dd($output);
                    // $data['data34'] = $chars['34'];
                    // $data['data17'] = $chars['17']; $data['data18'] = $chars['18']; $data['data19'] = $chars['19']; $data['data20'] = $chars['20'];
                    // $data['data21'] = $chars['21']; $data['data22'] = $chars['22']; $data['data23'] = $chars['23']; $data['data24'] = $chars['24'];
                    // $data['data25'] = $chars['25']; $data['data26'] = $chars['26']; $data['data27'] = $chars['27']; $data['data28'] = $chars['28'];
                    // $data['data29'] = $chars['29']; $data['data30'] = $chars['30']; $data['data31'] = $chars['31']; $data['data32'] = $chars['32'];
                    // $token_ = $chars['34'];
                    // $token_ = $chars['17'].''.$data['data18'].''.$data['data19'].''.$data['data20'].''.$data['data21'].''.$data['data22'].''.$data['data23'].''.$data['data24'].''.$data['data25'].''.$data['data26'].''.$data['data27']
                    // .''.$data['data28'].''.$data['data29'].''.$data['data30'].''.$data['data31'].''.$data['data32'];
                    // dd($token_);

                    // $pid = $collection['pid'];
                // $content = @file_get_contents($path);
                
               
                // $jsonArray = json_decode($content, true);
                // if(file_exists($url)){
                //     $content = file_get_contents($url);
                //   }
                //Basically adding headers to the request
                // $context = stream_context_create($opts);
                // $html = file_get_contents($url,false,$context);
                // $html = htmlspecialchars($html);

                // $fileaa = fopen(storage_path("Stm/".$file), "r");
                // dd($fileaa);
                // $xmlObject = simplexml_load_string($xmlString);
                // dd($content);  
                //      dd($content[15]);                   

                // $json = json_encode($html);
                // // $json = json_encode($file);
                // $result = json_decode($json, true); 
           
                // dd($result);

                // @$stmAccountID = $result['stmAccountID'];
                // @$hcode = $result['hcode'];
                // @$hname = $result['hname'];
                // @$AccPeriod = $result['AccPeriod'];
                // @$STMdoc = $result['STMdoc']; //ชื่อไฟล์
                // @$dateStart = $result['dateStart']; //"5  ธันวาคม  2565"
                           
                // @$STMdat = $result['STMdat'];  // array 
                // @$TBills1 = $result['TBills']['ST']['HG']['TBill'];  // array
                // @$TBills2 = $result['TBills']['ST']['HG'];  // array

                // @$Remarks = $result['Remarks'];  // array
                // @$config = $result['config'];  // array
                
                // $dates = date('Y-m-d H:m:s');
                // $namedoc = $STMdoc.'.'.$extension;
                // $check = Stm_head::where('STMdoc','=',$namedoc)->count();           
                    
                //     $hd_bills        = @$TBills1;
                //     $hd_bills2       = @$TBills2;
                //     // dd($hd_bills2);   
                //     if ($hd_bills == null) {
                        // foreach ($hd_bills2 as $key => $value) {  
                        //         $tb_ = $value['TBill']; 
                        // } 
                        // foreach ($tb_ as $key => $value) {
                        //     $invno = @$value['invno'];
                        //     $total = @$value['total']; 
                        //     // dd($invno);
                        //     Stm::where('VN', $invno) 
                        //     ->update([ 
                        //         'Filename'           => $name_file,
                        //         'total_back_stm'     => $total,
                        //         'status'             =>'REP'                                
                        //     ]); 

                        // }
                          
                // } else {
                        // foreach ($hd_bills as $key => $item) {  
                        //     $invno = $item['invno'];
                        //     $dttran = $item['dttran'];    
                        //     $ex_dttran = explode("T",$item['dttran']);
                        //     $dttran1 = $ex_dttran[0];
                        //     $dttran2 = $ex_dttran[1]; 
                        //     $ye = date('Y',strtotime($dttran1))+543;
                        //     $y = substr($ye, -2);
                        //     $m = date('m',strtotime($dttran1));
                        //     $d = date('d',strtotime($dttran1));
                        //     $dttran_1 =  $y.''.$m.''.$d;
                    
                        //     $time_now = date("H:i:s"); 
                        //     $pattern_date = '/-/i';
                        //     $aipn_date_now_preg = preg_replace($pattern_date, '', $dttran1);
                        //     $pattern_time = '/:/i';
                        //     $aipn_time_now_preg = preg_replace($pattern_time, '', $dttran2);
                       
                        //     $pid = $item['pid'];
                        //     $hn = $item['hn'];
                        //     $total = $item['total'];
                        //     $rid = $item['rid']; 

                        //     Stm::where('VN', $invno) 
                        //     ->update([ 
                        //         'Filename'           => $name_file,
                        //         'total_back_stm'     => @$total,
                        //         'status'             =>'REP' 
                        //     ]);  
                        // }
                // }
                                                   
        return redirect()->back();
    }
    public function uprep_money_plb(Request $request)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -5 months')); //ย้อนหลัง 5 เดือน
        $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี
        $yearnew = date('Y');
        $yearold = date('Y')-1;
        $start = (''.$yearold.'-10-01');
        $end = (''.$yearnew.'-09-30'); 

        if ($startdate != '') {
            $datashow = DB::select(' 
                SELECT U1.acc_1102050102_602_id,U2.req_no,U1.an,U1.vn,U1.hn,U1.cid,U1.ptname,U1.vstdate,U1.pttype,U1.debit_total
                ,U1.nhso_docno,U1.nhso_ownright_pid,U1.recieve_true,U1.difference,U1.recieve_no,U1.recieve_date,U2.money_billno,U2.payprice
                from acc_1102050102_602 U1 
                LEFT JOIN acc_stm_prb U2 ON U2.acc_1102050102_602_sid = U1.acc_1102050102_602_id
                WHERE U1.vstdate = "'.$startdate.'" AND year(U1.vstdate) = "'.$enddate.'"           
                GROUP BY U1.vn
            ');
        } else {
            $datashow = DB::select(' 
                SELECT U1.acc_1102050102_602_id,U2.req_no,U1.an,U1.vn,U1.hn,U1.cid,U1.ptname,U1.vstdate,U1.pttype,U1.debit_total
                ,U1.nhso_docno,U1.nhso_ownright_pid,U1.recieve_true,U1.difference,U1.recieve_no,U1.recieve_date,U2.money_billno,U2.payprice
                from acc_1102050102_602 U1 
                LEFT JOIN acc_stm_prb U2 ON U2.acc_1102050102_602_sid = U1.acc_1102050102_602_id
                WHERE U1.vstdate = "'.$start.'" AND year(U1.vstdate) = "'.$end.'"           
                GROUP BY U1.vn
            '); 
        }
        

        
       
        return view('upstm.uprep_money_plb', [ 
            'datashow'      =>  $datashow,
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate
        ]);
            
         
    }
    public function uprep_money_plbhn(Request $request)
    { 
        $startdate = $request->datepicker;
        $enddate = $request->datepicker2;
        $date = date('Y-m-d');
        $y = date('Y') + 543; 
        $yearnew = date('Y')+1;
        $yearold = date('Y');
        $start = (''.$yearold.'-10-01');
        $end = (''.$yearnew.'-09-30'); 
        $newDate = date('Y-m-d', strtotime($date . ' -5 months')); //ย้อนหลัง 1 เดือน 
        if ($startdate != '') {
            $patient = DB::connection('mysql2')->select('
                SELECT v.vn,p.hn,p.cid,concat(p.pname,p.fname," ",p.lname) as ptname,v.vstdate,v.income
                from patient p 
                LEFT JOIN vn_stat v ON p.hn = v.hn
                WHERE v.vstdate BETWEEN "'.$startdate.'" AND "'.$enddate.'"
                AND p.death = "N" AND v.income <> 0
                AND v.pttype IN("31","36","37","38","39")
            ');
        } else {
            $patient = DB::connection('mysql2')->select('
                SELECT v.vn,p.hn,p.cid,concat(p.pname,p.fname," ",p.lname) as ptname,v.vstdate,v.income
                from patient p 
                LEFT JOIN vn_stat v ON p.hn = v.hn
                WHERE v.vstdate BETWEEN "'.$newDate.'" AND "'.$date.'"
                AND p.death = "N" AND v.income <> 0
                AND v.pttype IN("31","36","37","38","39")
            ');
        }
        
       
       
         
        return view('upstm.uprep_money_plbhn', [  
            'patient'       =>  $patient,
            'startdate'     =>  $startdate,
            'enddate'       =>  $enddate
        ]);
            
         
    }
    public function uprep_money_plbop_all(Request $request)
    { 
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $date = date('Y-m-d');
        $y = date('Y') + 543; 
        $yearnew = date('Y')+1;
        $yearold = date('Y')-1;
        $start = (''.$yearold.'-10-01');
        $end = (''.$yearnew.'-09-30'); 
       
        $newDate = date('Y-m-d', strtotime($date . ' -3 months')); //ย้อนหลัง 5 เดือน
        if ($startdate != '') {
            $data = DB::select('  
                SELECT U1.acc_1102050102_602_id as id,U1.an,U1.vn,U1.hn,U1.cid,U1.ptname,U1.vstdate,U1.dchdate,U1.pttype,U1.debit_total,U1.account_code
                ,U1.nhso_docno,U1.nhso_ownright_pid,U1.recieve_true,U1.difference,U1.recieve_no,U1.recieve_date
                from acc_1102050102_602 U1  
                WHERE U1.vstdate BETWEEN "'.$startdate.'" AND "'.$enddate.'"    
                GROUP BY U1.vn
        

                UNION ALL

                SELECT U2.acc_1102050102_603_id as id,U2.an,U2.vn,U2.hn,U2.cid,U2.ptname,U2.vstdate,U2.dchdate,U2.pttype,U2.debit_total,U2.account_code
                ,U2.nhso_docno,U2.nhso_ownright_pid,U2.recieve_true,U2.difference,U2.recieve_no,U2.recieve_date 
                from acc_1102050102_603 U2 
                WHERE U2.dchdate BETWEEN "'.$startdate.'" AND "'.$enddate.'"        
                GROUP BY U2.an
                ORDER BY nhso_docno DESC
            ');
            // AND U1.recieve_no IS NULL 
        } else {
            $data = DB::select(' 
            SELECT U1.acc_1102050102_602_id as id,U1.an,U1.vn,U1.hn,U1.cid,U1.ptname,U1.vstdate,U1.dchdate,U1.pttype,U1.debit_total,U1.account_code
                ,U1.nhso_docno,U1.nhso_ownright_pid,U1.recieve_true,U1.difference,U1.recieve_no,U1.recieve_date
                from acc_1102050102_602 U1  
                WHERE U1.vstdate BETWEEN "'.$start.'" AND "'.$date.'"    
                GROUP BY U1.vn
    

                UNION ALL

                SELECT U2.acc_1102050102_603_id as id,U2.an,U2.vn,U2.hn,U2.cid,U2.ptname,U2.vstdate,U2.dchdate,U2.pttype,U2.debit_total,U2.account_code
                ,U2.nhso_docno,U2.nhso_ownright_pid,U2.recieve_true,U2.difference,U2.recieve_no,U2.recieve_date 
                from acc_1102050102_603 U2 
                WHERE U2.dchdate BETWEEN "'.$start.'" AND "'.$date.'"        
                GROUP BY U2.an
                ORDER BY nhso_docno DESC
 
            '); 
            // AND U1.recieve_no IS NULL  
        }
             
        return view('account_stm.uprep_money_plbop_all', [ 
            'data'          =>  $data, 
            'startdate'     =>  $startdate,
            'enddate'       =>  $enddate
        ]);
            
         
    }
    public function uprep_money_plbop_alledit(Request $request,$account,$id)
    { 
       // dd($account);
       if ($account == '1102050102.602') {
           $data_show = Acc_1102050102_602::where('acc_1102050102_602_id',$id)->first();

       } elseif ($account == '1102050102.603') {
           $data_show = Acc_1102050102_603::where('acc_1102050102_603_id',$id)->first();
      
       } else {
           # code...
       }
    
        return view('account_stm.uprep_money_plbop_alledit',[
           'data_show'     =>     $data_show ,
           'id'            =>     $id,
           'account'       =>     $account
        ]);
    }
    public function uprep_money_plbop_allupdate(Request $request)
    {
           $account = $request->account_code;
           $id = $request->id;
           $recieve_true = $request->recieve_true;
           $difference = $request->difference;
           $recieve_no = $request->recieve_no;
           $recieve_date = $request->recieve_date;
           $user_id = $request->user_id; 
           // dd($recieve_true);
           if ($account == '1102050102.602') { 
               $update = Acc_1102050102_602::find($id);
               $update->recieve_true      = $recieve_true;
               $update->difference        = $difference;
               $update->recieve_no        = $recieve_no;
               $update->recieve_date      = $recieve_date;
               $update->recieve_user      = $user_id; 
               $update->save();

           } elseif ($account == '1102050102.603') {
               $update2 = Acc_1102050102_603::find($id);
               $update2->recieve_true      = $recieve_true;
               $update2->difference        = $difference;
               $update2->recieve_no        = $recieve_no;
               $update2->recieve_date      = $recieve_date;
               $update2->recieve_user      = $user_id; 
               $update2->save();
         
           } else {
               # code...
           }
           
          
           
           return response()->json([
               'status'    => '200' 
           ]); 
    }
    public function uprep_money_plbop(Request $request)
    { 
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $date = date('Y-m-d');
        $y = date('Y') + 543; 
        $yearnew = date('Y')+1;
        $yearold = date('Y')-1;
        $start = (''.$yearold.'-10-01');
        $end = (''.$yearnew.'-09-30'); 
       
        $newDate = date('Y-m-d', strtotime($date . ' -3 months')); //ย้อนหลัง 5 เดือน
        if ($startdate != '') {
            $datashow = DB::select('  
                SELECT U1.acc_1102050102_602_id,U2.req_no,U1.an,U1.vn,U1.hn,U1.cid,U1.ptname,U1.vstdate,U1.pttype,U1.debit_total
                ,U1.nhso_docno,U1.nhso_ownright_pid,U1.recieve_true,U1.difference,U1.recieve_no,U1.recieve_date,U2.money_billno,U2.payprice
                from acc_1102050102_602 U1 
                LEFT JOIN acc_stm_prb U2 ON U2.acc_1102050102_602_sid = U1.acc_1102050102_602_id
                WHERE U1.vstdate BETWEEN "'.$startdate.'" AND "'.$enddate.'"  
                  
                GROUP BY U1.vn
            ');
            // AND U1.recieve_no IS NULL 
        } else {
            $datashow = DB::select(' 
                SELECT U1.acc_1102050102_602_id,U2.req_no,U1.an,U1.vn,U1.hn,U1.cid,U1.ptname,U1.vstdate,U1.pttype,U1.debit_total
                    ,U1.nhso_docno,U1.nhso_ownright_pid,U1.recieve_true,U1.difference,U1.recieve_no,U1.recieve_date,U2.money_billno,U2.payprice
                    from acc_1102050102_602 U1 
                    LEFT JOIN acc_stm_prb U2 ON U2.acc_1102050102_602_sid = U1.acc_1102050102_602_id 
                    WHERE U1.vstdate BETWEEN "'.$start.'" AND "'.$date.'" 
                         
                    GROUP BY U1.vn 
            '); 
            // AND U1.recieve_no IS NULL  
        }
             
        return view('upstm.uprep_money_plbop', [ 
            'datashow'      =>  $datashow, 
            'startdate'     =>  $startdate,
            'enddate'       =>  $enddate
        ]);
            
         
    }
    public function uprep_money_plbip(Request $request)
    {
        $datenow = date('Y-m-d');
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -5 months')); //ย้อนหลัง 5 เดือน
        $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี
        $yearnew = date('Y')+1;
        $yearold = date('Y')-1;
        $start = (''.$yearold.'-10-01');
        $end = (''.$yearnew.'-09-30'); 
        // dd($start);
        if ($startdate != '') {
            $datashow = DB::select(' 
                SELECT U1.acc_1102050102_603_id,U1.an,U1.vn,U1.hn,U1.cid,U1.ptname,U1.vstdate,U1.dchdate,U1.pttype,U1.debit_total
                ,U1.nhso_docno,U1.nhso_ownright_pid,U1.recieve_true,U1.difference,U1.recieve_no,U1.recieve_date 
                from acc_1102050102_603 U1 
                  
                WHERE U1.dchdate BETWEEN "'.$startdate.'" AND "'.$enddate.'"         
                GROUP BY U1.an
            ');
            // LEFT JOIN acc_stm_prb U2 ON U2.acc_1102050102_602_sid = U1.acc_1102050102_602_id
        } else {
            $datashow = DB::select(' 
                SELECT U1.acc_1102050102_603_id,U1.an,U1.vn,U1.hn,U1.cid,U1.ptname,U1.vstdate,U1.dchdate,U1.pttype,U1.debit_total
                ,U1.nhso_docno,U1.nhso_ownright_pid,U1.recieve_true,U1.difference,U1.recieve_no,U1.recieve_date 
                from acc_1102050102_603 U1 
               
                WHERE U1.dchdate BETWEEN "'.$start.'" AND "'.$date.'"        
                GROUP BY U1.an
            '); 
        }
         
       
        return view('upstm.uprep_money_plbip', [ 
            'datashow'      =>     $datashow,
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate
        ]);
            
         
    }

   
}

