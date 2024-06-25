<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\support\Facades\Hash;
use Illuminate\support\Facades\Validator;
use Illuminate\support\Facades\File;
use App\Models\User;
use App\Models\Department;
use App\Models\Departmentsub;
use App\Models\Departmentsubsub;
use App\Models\Products_vendor;
use App\Models\Status;
use App\Models\Position;
use App\Models\Products_request;
use App\Models\Products_request_sub;
use App\Models\Products;
use App\Models\Products_type;
use App\Models\Product_group;
use App\Models\Product_unit;
use App\Models\Products_category;
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
// use App\Models\Orginfo;
use DataTables;
use PDF;
use Auth; 
use Illuminate\Support\Facades\Storage;
use setasign\Fpdi\Fpdi;

class RongController extends Controller
{  
 
    // public static function orginfo_headep($iduser)
    // {
    //   $org_headep =  Orginfo::where('orginfo_manage_id','=',$iduser)->first();   
      
    //   return $org_headep;
    // }
public function rong_bookindex(Request $request,$iduser)
{        
        $data['users'] = User::get();
        $data['book_objective'] = DB::table('book_objective')->get();
        $data['bookrep'] = DB::table('bookrep')
        // ->leftJoin('book_send_person','bookrep.bookrep_id','=','book_send_person.bookrep_id')
        // ->where('sendperson_user_id','=',$iduser)
        ->where('bookrep_send_code','=','waitretire')
        ->get();

        $data['status'] = Status::get();
    return view('rong.rong_bookindex',$data);
}

public function rong_bookindex_detail(Request $request,$id,$iduser)
{  
        $dataedit = Bookrep::where('bookrep_send_code','=','waitretire')
        ->where('bookrep_id','=',$id)
        ->first(); 

        $userid = Auth::user()->id;
        $data['users'] = User::get();
        $data['book_import_fam'] = DB::table('book_import_fam')->get();
        $data['speed_class'] = DB::table('speed_class')->get();
        $data['secret_class'] = DB::table('secret_class')->get();
        $data['book_type'] = DB::table('book_type')->get();
        $data['book_signature'] = Book_signature::where('user_id','=',$userid)->get(); 
        $data['department'] = Department::get();
        $data['department_sub'] = Departmentsub::get();
        $data['department_sub_sub'] = Departmentsubsub::get();
        $data['book_senddep'] = Book_senddep::where('bookrep_id','=',$id)->get();
        $data['book_objective'] = DB::table('book_objective')->get();
        $data['org_team'] = DB::table('org_team')->get();
        $data['book_senddep_sub'] = DB::table('book_senddep_sub')->where('bookrep_id','=',$id)->get();
        $data['book_send_person'] = DB::table('book_send_person')->where('bookrep_id','=',$id)->get();
        $data['book_sendteam'] = DB::table('book_sendteam')->where('bookrep_id','=',$id)->get();
        $data['book_signature'] = Book_signature::where('user_id','=',$userid)->get(); 
    return view('rong.rong_bookindex_detail',$data,[
        'dataedits'   =>   $dataedit
    ]);
}
public function rong_bookindex_retire(Request $request,$id)
{  
        // $dataedit = Bookrep::
        // where('bookrep_send_code','=','waitretire')
        $dataedit = Bookrep::where('bookrep_id','=',$id)
        ->first(); 

        $dataedit_2 = Bookrep::where('bookrep_send_code','=','retire')
        ->where('bookrep_id','=',$id)
        ->first();

        $userid = Auth::user()->id;
        $data['users'] = User::get();
        $data['book_import_fam'] = DB::table('book_import_fam')->get();
        $data['speed_class'] = DB::table('speed_class')->get();
        $data['secret_class'] = DB::table('secret_class')->get();
        $data['book_type'] = DB::table('book_type')->get();
        $data['book_signature'] = Book_signature::where('user_id','=',$userid)->get(); 
        $data['department'] = Department::get();
        $data['department_sub'] = Departmentsub::get();
        $data['department_sub_sub'] = Departmentsubsub::get();
        $data['book_senddep'] = Book_senddep::where('bookrep_id','=',$id)->get();
        $data['book_objective'] = DB::table('book_objective')->get();
        $data['org_team'] = DB::table('org_team')->get();
        $data['book_senddep_sub'] = DB::table('book_senddep_sub')->where('bookrep_id','=',$id)->get();
        $data['book_send_person'] = DB::table('book_send_person')->where('bookrep_id','=',$id)->get();
        $data['book_sendteam'] = DB::table('book_sendteam')->where('bookrep_id','=',$id)->get();
        $data['book_signature'] = Book_signature::where('user_id','=',$userid)->get(); 

        $bookcount = Bookrep::where('bookrep_id','=',$id)->where('bookrep_send_code','=','retire')->count(); 

    return view('rong.rong_bookindex_retire',$data,[
        'dataedits'   =>   $dataedit,
        'dataedit_2s' =>   $dataedit_2,
        'bookcount'=>$bookcount,
    ]);
}

public function bookmake_retirerong(Request $request)
    {        
            $add = new Book_signature();

            $dataimg = $request->input('signature');
            $userid = $request->input('user_id'); 
            $bookrepid = $request->input('bookrep_id'); 

            $add->signature_name_text = $dataimg; 
            $add->signature_file = $dataimg;
            // $add->user_id = $userid; 
            $add->bookrep_id = $bookrepid;
            $add->save(); 

            $update = Bookrep::find($bookrepid);
            $update->bookrep_send_code = 'retire';
            $update->bookrep_send_name = 'เกษียณ';
            $update->bookrep_comment2 = $request->input('bookrep_comment2'); 
         
            if ($userid != '') {
                $repsave = DB::table('users')->where('id','=',$userid)->first();
                $update->bookrep_userretire_id = $repsave->id; 
                $update->bookrep_userretire_name = $repsave->fname. '  ' .$repsave->lname ; 
            } else {
                $update->bookrep_userretire_id = ''; 
                $update->bookrep_userretire_name =''; 
            }  
            $update->save();  

            return response()->json([
                'status'     => '200'
                ]);
    }


public function rong_bookindex_retire_get(Request $request,$id)
    {
        $dataedit = Bookrep::where('bookrep_id','=',$id)->first(); 
        // download sample file.
        // Storage::disk('local')->put('test.pdf', file_get_contents('http://www.africau.edu/images/default/sample.pdf'));
        Storage::disk('local')->put('test.pdf', file_get_contents('storage/bookrep_pdf/'.$dataedit->bookrep_file));
        

        $outputFile = Storage::disk('local')->path('output.pdf');
        $signa = Bookrep::where('bookrep_id','=',$id)->first();
        
        $signature = $signa->signature_name_text;
        // $outputFile = 'storage/bookrep_pdf/'.$dataedit->bookrep_file;
        // fill data
        $this->fillPDF(Storage::disk('local')->path('test.pdf'), $outputFile);

        // $this->fillPDF($signature);
        //output to browser
        return response()->file($outputFile,[
            'id'  => $id
        ]);
    }

    public function fillPDF($file, $outputFile)
    {
        $fpdi = new FPDI;
        $fpdi->AddFont('helveticai','','helveticai.php'); //Regular
        // $fpdi->AddFont('angsana', '', 'angsana.ttc', true);
        // merger operations
        // $signa = Bookrep::where('bookrep_id','=',$bookrep_file)->first();
        $count = $fpdi->setSourceFile($file);
        for ($i=1; $i<=$count; $i++) {
            $template   = $fpdi->importPage($i);
            $size       = $fpdi->getTemplateSize($template);
            $fpdi->AddPage($size['orientation'], array($size['width'], $size['height']));
            $fpdi->useTemplate($template);
            $left = 150;
            $top = 12;            
            $fpdi->SetFont('helveticai');
            // $text = $file->bookrep_id;
            $text = "No. 25621/5215"; 
            $fpdi->SetTextColor(153,0,153);
            $fpdi->Text($left,$top,$text); //ลายนำ้
            // $fpdi->Image($signature, 150,200, 40, 20);
            $fpdi->Image('storage/test/dit.jpg', 150,200, 40, 20);
          
        }
        return $fpdi->Output($outputFile, 'F');
        // return $fpdi->Output($outputFile, 'I');
    }

    public function rong_bookindex_printdetail(Request $request, $id)
    {        
        $dataedit = Bookrep::where('bookrep_id','=',$id)->first();  
        // $signature = DB::table('book_signature')->where('bookrep_id','=',$id)->first();
        $org = DB::table('orginfo')->where('orginfo_id','=',1)
        ->leftjoin('users','users.id','=','orginfo.orginfo_manage_id')
        ->leftjoin('users_prefix','users_prefix.prefix_code','=','users.pname')
        ->first();
        $rong = $org->prefix_name.' '.$org->fname.'  '.$org->lname;

        $orgpo = DB::table('orginfo')->where('orginfo_id','=',1)
        ->leftjoin('users','users.id','=','orginfo.orginfo_po_id')
        ->leftjoin('users_prefix','users_prefix.prefix_code','=','users.pname')
        ->first();
        $po = $orgpo->prefix_name.' '.$orgpo->fname.'  '.$orgpo->lname;

        $count = DB::table('book_signature')->where('bookrep_id','=',$id)->count();
        // $sig = $signature->signature_name_text;
        // $signature = DB::table('book_signature')->where('bookrep_id','=',$id)->first();
        // dd($count);
        if ($count != 0) {
            $signature = DB::table('book_signature')->where('bookrep_id','=',$id)->first();
            $siguser = $signature->signature_name_usertext; //ผู้รองขอ
            $sighn = $signature->signature_name_hntext; //หัวหน้า
            $sig = $signature->signature_name_text; //หัวหน้าบริหาร
            $sigpo = $signature->signature_name_potext; //ผอ
            
        } else {
            $sig = '';
            $siguser = '';
            $sighn = '';
            $sigpo = '';
        }
        
        // dd($sig);
        // <img id="image_upload_preview" src="data:img/png;base64,{{ chunk_split(base64_encode($org->img_logo)) }}" height="180" width="250"> 

        define('FPDF_FONTPATH','font/');
        require(base_path('public')."/fpdf/WriteHTML.php");

        $pdf = new Fpdi();// Instantiation   start-up Fpdi
        $path = 'storage/bookrep_pdf/'.$dataedit->bookrep_file;// existing PDF Templates ( The material file is in   Project name \public\testA.pdf)
        $table = 'storage/bookrep_pdf/table_1.png';
        // dd($path);
        
        $count = $pdf->setSourceFile($path);
        for ($i=1; $i<=$count; $i++) {
            $template   = $pdf->importPage($i);
            $size       = $pdf->getTemplateSize($template);
            $pdf->AddPage($size['orientation'], array($size['width'], $size['height']));
            $pdf->useTemplate($template);      
            $pdf->AddFont('THSarabunNew','','THSarabunNew.php');
            $pdf->SetFont('THSarabunNew','',15); 
            $left = 150;
            $top = 12;        
            
            if ($sig != null) {
                $pdf->Cell(145);
                $no = $pdf->Text(160,15,iconv( 'UTF-8','TIS-620','เลขที่รับ ' .$dataedit->bookrep_recievenum));
                $pdf->Text(160,22,iconv( 'UTF-8','TIS-620','เลขที่หนังสือ ' .$dataedit->bookrep_repbooknum));
                $pdf->Cell(50,15,$no, 1,0, 'C');
                $pdf->Image($sig, 8,241, 50, 17,"png");
            $pdf->Text(13,260,iconv( 'UTF-8','TIS-620', $rong)); 
            $pdf->Text(19,265,iconv( 'UTF-8','TIS-620','หัวหน้าบริหาร '  ));
                $pdf->SetTextColor(0, 0, 0);// Set the color of new text 
                // Coordinate 
                // $pdf->SetXY(52, 28);// Set the position coordinates of the new text 

            } else {
                // $pdf->Image($sig, 150,220, 40, 20,"png");
            }

            if ($sigpo != null) {
                $pdf->Cell(145);
                $no = $pdf->Text(160,15,iconv( 'UTF-8','TIS-620','เลขที่รับ ' .$dataedit->bookrep_recievenum)); 
                $pdf->Text(160,22,iconv( 'UTF-8','TIS-620','เลขที่หนังสือ ' .$dataedit->bookrep_repbooknum));
                $pdf->Cell(50,15,$no, 1,0, 'C');
                $pdf->Image($sigpo, 156,263, 50, 17,"png");
                $pdf->Text(154,283,iconv( 'UTF-8','TIS-620', $po)); 
                $pdf->Text(150,288,iconv( 'UTF-8','TIS-620','ผู้อำนวยการ'.$orgpo->orginfo_name  ));
                $pdf->SetTextColor(0, 0, 0);// Set the color of new text 
                // Coordinate 
                // $pdf->SetXY(52, 28);// Set the position coordinates of the new text 
    
            } else {
                // $pdf->Image($sig, 150,220, 40, 20,"png");
            }
            
          
        }
        $pdf->Output('I', 'example.pdf');// Output results  I: Direct input ,D: Download the file ,F: Save to local file ,S: Return string 
    }

    public function bookmake_allowrong(Request $request)
    {    
        $databooks =  Bookrep::where('bookrep_send_code','=','waitretire') 
        ->get();
    
        $iduser = $request->input('user_id'); 
        $dataimg = $request->input('signature');

        $comment2 = $request->input('bookrep_comment2');
        // $comment3 = $request->input('bookrep_comment_b');
        // $comment4 = $request->input('bookrep_comment_c');
        // $comment5 = $request->input('bookrep_comment_d');
        // $comment6 = $request->input('bookrep_comment_e');
        // $comment7 = $request->input('bookrep_comment_f');
    
            foreach ($databooks as $items){ 
                $bookrepid = $items->bookrep_id;
                $updateall = Bookrep::find($bookrepid);
                $updateall->bookrep_send_code = 'retire';
                $updateall->bookrep_send_name = 'เกษียณ'; 
                $updateall->bookrep_comment2 = $comment2;
                // if ($comment2 != null) {
                //     $updateall->bookrep_comment2 = 'อนุมัติ'; 
                // } elseif($comment3 != null){
                //     $updateall->bookrep_comment2 = 'ไม่อนุมัติ'; 
                // } elseif($comment4 != null){
                //     $updateall->bookrep_comment2 = 'ทราบ'; 
                // } elseif($comment5 != null){
                //     $updateall->bookrep_comment2 = 'เห็นชอบ'; 
                // } elseif($comment6 != null){
                //     $updateall->bookrep_comment2 = 'อนุญาต'; 
                // } elseif($comment7 != null){
                //     $updateall->bookrep_comment2 = 'แจ้ง'; 
                // } else {
                //     $updateall->bookrep_comment2 = ''; 
                // }
                
                
               
    
                if ($iduser != '') {
                    $repsave = DB::table('users')->where('id','=',$iduser)->first();
                    $updateall->bookrep_userretire_id = $repsave->id; 
                    $updateall->bookrep_userretire_name = $repsave->fname. '  ' .$repsave->lname ; 
                } else {
                    $updateall->bookrep_userretire_id = ''; 
                    $updateall->bookrep_userretire_name =''; 
                }  
    
                $updateall->save();

                $add = new Book_signature();  
                $add->signature_name_text = $dataimg;       
                $add->bookrep_id = $bookrepid;      
                $add->save(); 
                         
            }
    
            
    
        return response()->json([
            'statusCode'     => '200' 
            ]);
    }



public function rong_leaveindex(Request $request,$iduser)
{  
        // $iduser = Auth::user()->id;
        $dataedit = Bookrep::leftJoin('book_import_fam','bookrep.bookrep_import_fam','=','book_import_fam.import_fam_id')
        ->leftJoin('book_send_person','bookrep.bookrep_id','=','book_send_person.bookrep_id')
        ->where('sendperson_user_id','=',$iduser)->get(); 
        
        $data['department'] = Department::leftJoin('users','department.LEADER_ID','=','users.id')->orderBy('DEPARTMENT_ID','DESC')->get();  
        $data['users'] = User::get();
        $data['book_objective'] = DB::table('book_objective')->get();
        $data['bookrep'] = DB::table('bookrep')
        ->leftJoin('book_send_person','bookrep.bookrep_id','=','book_send_person.bookrep_id')
        ->where('sendperson_user_id','=',$iduser)
        ->get();
        $data['status'] = Status::paginate(15);
    return view('rong.rong_leaveindex',$data,[
        'dataedit'   =>   $dataedit
    ]);
}
public function rong_trainindex(Request $request,$iduser)
{  
        // $iduser = Auth::user()->id;
        $dataedit = Bookrep::leftJoin('book_import_fam','bookrep.bookrep_import_fam','=','book_import_fam.import_fam_id')
        ->leftJoin('book_send_person','bookrep.bookrep_id','=','book_send_person.bookrep_id')
        ->where('sendperson_user_id','=',$iduser)->get(); 
        
        $data['department'] = Department::leftJoin('users','department.LEADER_ID','=','users.id')->orderBy('DEPARTMENT_ID','DESC')->get();  
        $data['users'] = User::get();
        $data['book_objective'] = DB::table('book_objective')->get();
        $data['bookrep'] = DB::table('bookrep')
        ->leftJoin('book_send_person','bookrep.bookrep_id','=','book_send_person.bookrep_id')
        ->where('sendperson_user_id','=',$iduser)
        ->get();
        $data['status'] = Status::paginate(15);
    return view('rong.rong_trainindex',$data,[
        'dataedit'   =>   $dataedit
    ]);
}
public function rong_storeindex(Request $request,$iduser)
{  
        // $iduser = Auth::user()->id;
        $dataedit = Bookrep::leftJoin('book_import_fam','bookrep.bookrep_import_fam','=','book_import_fam.import_fam_id')
        ->leftJoin('book_send_person','bookrep.bookrep_id','=','book_send_person.bookrep_id')
        ->where('sendperson_user_id','=',$iduser)->get(); 
        
        $data['department'] = Department::leftJoin('users','department.LEADER_ID','=','users.id')->orderBy('DEPARTMENT_ID','DESC')->get();  
        $data['users'] = User::get();
        $data['book_objective'] = DB::table('book_objective')->get();
        $data['bookrep'] = DB::table('bookrep')
        ->leftJoin('book_send_person','bookrep.bookrep_id','=','book_send_person.bookrep_id')
        ->where('sendperson_user_id','=',$iduser)
        ->get();
        $data['status'] = Status::paginate(15);
    return view('rong.rong_storeindex',$data,[
        'dataedit'   =>   $dataedit
    ]);
}

public function rong_purchaseindex(Request $request,$id)
{  
    $datarequesr = User::where('id','=',$id)->first();
    $data['department'] = Department::get();
    $data['department_sub'] = Departmentsub::get();
    $data['department_sub_sub'] = Departmentsubsub::get();
    $data['position'] = Position::get();
    $data['status'] = Status::get();
    $data['budget_year'] = DB::table('budget_year')->orderBy('leave_year_id','DESC')->get();
    $datashow = User::get();
    $data['products_vendor'] = Products_vendor::get();
    $data['products_request'] = Products_request::join('products_status','products_request.request_status','=','products_status.products_status_code')
    ->join('products_request_sub','products_request_sub.request_id','=','products_request.request_id')
    // ->where('request_debsubsub_id','=',$datarequesr->dep_subsubtrueid)
    ->where('request_hn_id','=',$id)
    ->where('request_status','=','REQUEST')
    ->orderBy('products_request.request_id','DESC')->get();
 
    return view('rong.rong_purchaseindex',$data,
    [
        'datashows'=>$datashow,
        'datarequesr'=>$datarequesr,
        // 'dataedits'=>$dataedit,
    ]);
}
}