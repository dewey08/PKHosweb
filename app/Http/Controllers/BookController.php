<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\support\Facades\Hash;
use Illuminate\support\Facades\Validator;
// use Illuminate\support\Facades\File;
use App\Models\User;
use App\Models\Department;
use App\Models\Departmentsub;
use App\Models\Departmentsubsub;
use App\Models\Book_read;
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
use App\Models\Book_senddep_subsub;
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
use App\Models\Orginfo;
use DataTables;
use PDF;
use Auth;
use App\Mail\DissendeMail;
use Mail;
use File;
use Illuminate\Support\Facades\Storage;
use setasign\Fpdi\Fpdi;
date_default_timezone_set("Asia/Bangkok");

class BookController extends Controller
{  
   public function book_dashboard(Request $request)
   {   
       $data['department'] = Department::leftJoin('users','department.LEADER_ID','=','users.id')->orderBy('DEPARTMENT_ID','DESC')
       // ->select('users.*', 'department.DEPARTMENT_ID', 'department.DEPARTMENT_NAME', 'department.LINE_TOKEN')
       ->get();  
       $data['users'] = User::get();
       return view('book.book_dashboard',$data);
   }
   public function bookrep_index(Request $request)
   {   
       $data['department'] = Department::leftJoin('users','department.LEADER_ID','=','users.id')->orderBy('DEPARTMENT_ID','DESC')
    //    ->select('users.*', 'department.DEPARTMENT_ID', 'department.DEPARTMENT_NAME', 'department.LINE_TOKEN')
       ->get();  
       $data['users'] = User::get();
       $org =  Orginfo::where('orginfo_id','=',1)->first(); 
       $link =  $org->orginfo_link;

       return view('book.bookrep_index',$data);
   }
   public function bookrep_index_add(Request $request)
   {   
        $userid = Auth::user()->id;
        $data['users'] = User::get();
        $data['book_import_fam'] = DB::table('book_import_fam')->get();
        $data['speed_class'] = DB::table('speed_class')->get();
        $data['secret_class'] = DB::table('secret_class')->get();
        $data['book_type'] = DB::table('book_type')->get();
        $data['book_signature'] = Book_signature::where('user_id','=',$userid)->get();
        $org =  Orginfo::where('orginfo_id','=',1)->first(); 
        $orginfo = $org->orginfo_link;


       return view('book.bookrep_index_add',$data,[
        'orginfo' => $orginfo
       ]);
   }
   public function bookrep_index_save(Request $request)
    {         
            date_default_timezone_set("Asia/Bangkok");
            $datenow = date('Y-m-d H:i:s');
            // $timenow = date('H:i:s');

            $add = new Bookrep();
            $add->bookrep_repnum = $request->input('bookrep_repnum');
            $add->bookrep_recievenum = $request->input('bookrep_recievenum'); 
            $add->bookrep_repbooknum = $request->input('bookrep_repbooknum'); 
            $add->bookrep_save_date = $request->input('bookrep_save_date'); 
            $add->bookrep_save_time = date('H:i:s');
            $add->bookrep_follow_date = $request->input('bookrep_follow_date'); 
            $add->bookrep_import_fam = $request->input('bookrep_import_fam'); 
            $add->bookrep_send_code = 'waitsend'; 

            $secret = $request->input('bookrep_secret_class_id'); 
            if ($secret != '') {
                $secretsave = DB::table('secret_class')->where('secret_class_id','=',$secret)->first();
                $add->bookrep_secret_class_id = $secretsave->secret_class_id; 
                $add->bookrep_secret_class_name = $secretsave->secret_class_name; 
            } else {
                $add->bookrep_secret_class_id = ''; 
                $add->bookrep_secret_class_name =''; 
            }

            $speed = $request->input('bookrep_speed_class_id'); 
            if ($speed != '') {
                $speedsave = DB::table('speed_class')->where('speed_class_id','=',$speed)->first();
                $add->bookrep_speed_class_id = $speedsave->speed_class_id; 
                $add->bookrep_speed_class_name = $speedsave->speed_class_name; 
            } else {
                $add->bookrep_speed_class_id = ''; 
                $add->bookrep_speed_class_name =''; 
            }

            $type = $request->input('bookrep_type_id');
            if ($type != '') {
                $typesave = DB::table('book_type')->where('booktype_id','=',$type)->first();
                $add->bookrep_type_id = $typesave->booktype_id; 
                $add->bookrep_type_name = $typesave->booktype_name; 
            } else {
                $add->bookrep_type_id = ''; 
                $add->bookrep_type_name =''; 
            }    
            $userid = $request->input('user_id'); 
            if ($userid != '') {
                $repsave = DB::table('users')->where('id','=',$userid)->first();
                $add->bookrep_usersend_id = $repsave->id; 
                $add->bookrep_usersend_name = $repsave->fname. '  ' .$repsave->lname ; 
            } else {
                $add->bookrep_usersend_id = ''; 
                $add->bookrep_usersend_name =''; 
            }       

            $add->bookrep_name = $request->input('bookrep_name'); 
            $add->bookrep_story = $request->input('bookrep_story'); 
            $add->bookrep_assembly = $request->input('bookrep_assembly'); 

            $maxid = Bookrep::max('bookrep_id');
            $idfile = $maxid+1;
            if($request->hasFile('pdfupload')){
                $newFileName = 'bookrep_'.$idfile.'.'.$request->pdfupload->extension();                
                $request->pdfupload->storeAs('bookrep_pdf',$newFileName,'public');
                $add->bookrep_file = $newFileName;
            }
            if($request->hasFile('bookrep_file1')){
                $newFileName1 = 'bookrep_'.$idfile.'_1'.'.'.$request->bookrep_file1->extension();                
                $request->bookrep_file1->storeAs('bookrep_pdf',$newFileName1,'public');
                $add->bookrep_file1 = $newFileName1;
                // $addreceipt->BOOK_FILE_NAME_OLD =  $request->file('bookrep_file1')->getClientOriginalName();
            }
            if($request->hasFile('bookrep_file2')){
                $newFileName2 = 'bookrep_'.$idfile.'_2'.'.'.$request->bookrep_file2->extension();                
                $request->bookrep_file2->storeAs('bookrep_pdf',$newFileName2,'public');
                $add->bookrep_file2 = $newFileName2; 
            }
            if($request->hasFile('bookrep_file3')){
                $newFileName3 = 'bookrep_'.$idfile.'_3'.'.'.$request->bookrep_file3->extension();                
                $request->bookrep_file3->storeAs('bookrep_pdf',$newFileName3,'public');
                $add->bookrep_file3 = $newFileName3; 
            }
            if($request->hasFile('bookrep_file4')){
                $newFileName4 = 'bookrep_'.$idfile.'_4'.'.'.$request->bookrep_file4->extension();                
                $request->bookrep_file4->storeAs('bookrep_pdf',$newFileName4,'public');
                $add->bookrep_file4 = $newFileName4; 
            }
            if($request->hasFile('bookrep_file5')){
                $newFileName5 = 'bookrep_'.$idfile.'_5'.'.'.$request->bookrep_file5->extension();                
                $request->bookrep_file5->storeAs('bookrep_pdf',$newFileName5,'public');
                $add->bookrep_file5 = $newFileName5; 
            }
           

            $add->save();   
            $org =  Orginfo::where('orginfo_id','=',1)->first(); 
            $link =  $org->orginfo_link;

            return response()->json([
                'status'     => '200' 
                ]);
    }
   public function bookmake_index(Request $request)
   {   
        $startd = $request->startdate;
        $endd = $request->enddate; 

        if ($startd == '' || $endd == '') {  
            date_default_timezone_set("Asia/Bangkok");
            $date = date('Y-m-d');
             $newday = date('Y-m-d', strtotime($date . ' -30 day')); //ย้อนหลัง 30 วัน 
            // $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์  
            // $newdate = date('Y-m-d', strtotime($date . ' -1 months')); //ย้อนหลัง 1 เดือน 
            // dd( $newday);
            $enddate = '';
            $startdate = '';
            $data['bookrep'] = DB::connection('mysql')->select('
                    select * from bookrep b 
                    left outer join users u on u.id = b.bookrep_usersend_id   
                    left outer join speed_class s on s.speed_class_id = b.bookrep_speed_class_id         
                    where b.bookrep_save_date between "' . $newday . '" and "' . $date . '" 
                    order by bookrep_id desc  
                ');
        } else {
            $startdate = $startd;
            $enddate = $endd;
            $data['bookrep'] = DB::connection('mysql')->select('
                select * from bookrep b 
                left outer join users u on u.id = b.bookrep_usersend_id   
                left outer join speed_class s on s.speed_class_id = b.bookrep_speed_class_id         
                where b.bookrep_save_date between "' . $startdate . '" and "' . $enddate . '" 
                order by bookrep_id desc  
            ');
        }
        
        // $strYear = date("Y",strtotime($startd))+543;
        // $strM = date('m',strtotime($startd));
        // $strD = date('d',strtotime($startdate));

        // $endYear = date("Y",strtotime($enddate))+543;
        // $endM = date('m',strtotime($enddate));
        // $endD = date('d',strtotime($enddate)); 

        // $strdateadmit = $strYear.''.$strM.''.$strD;
        // $enddateadmit = $endYear.''.$endM.''.$endD;
      

        $data['department'] = Department::leftJoin('users','department.LEADER_ID','=','users.id')->orderBy('DEPARTMENT_ID','DESC')
        ->get();  
        $data['users'] = User::get();
        $data['book_objective'] = DB::table('book_objective')->get();
        // $data['bookrep'] = DB::table('bookrep')
        // ->leftJoin('users','bookrep.bookrep_usersend_id','=','users.id')
        // ->where('')
        // ->orderBy('bookrep_id','DESC')->get();
        // $data['bookrep'] = DB::connection('mysql')->select('
        //         select * from bookrep b 
        //         left outer join users u on u.id = b.bookrep_usersend_id           
        //         where b.bookrep_save_date between "' . $startdate . '" and "' . $startdate . '"  
        //     ');

       return view('book.bookmake_index',$data,[
        'startdate'     =>       $startdate,
        'enddate'     =>       $enddate,
       ]);
   }
   public function bookmake_index_edit(Request $request,$id)
    {    
            $dataedit = Bookrep::where('bookrep_id','=',$id)->first(); 
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

        return view('book.bookmake_index_edit',$data,[
            'dataedits'=>$dataedit
        ]);
    }
    public function bookmake_index_update(Request $request)
    {         
            date_default_timezone_set("Asia/Bangkok");
            $datenow = date('Y-m-d H:i:s');
            // $timenow = date('H:i:s');
            $idrep = $request->bookrep_id;

            $update = Bookrep::find($idrep);
            $update->bookrep_repnum = $request->input('bookrep_repnum');
            $update->bookrep_recievenum = $request->input('bookrep_recievenum'); 
            $update->bookrep_repbooknum = $request->input('bookrep_repbooknum'); 
            $update->bookrep_save_date = $request->input('bookrep_save_date'); 
            $update->bookrep_save_time = date('H:i:s');
            $update->bookrep_follow_date = $request->input('bookrep_follow_date'); 
            $update->bookrep_import_fam = $request->input('bookrep_import_fam'); 
            // $update->bookrep_send_code = 'waitsend'; 

            $secret = $request->input('bookrep_secret_class_id'); 
            if ($secret != '') {
                $secretsave = DB::table('secret_class')->where('secret_class_id','=',$secret)->first();
                $update->bookrep_secret_class_id = $secretsave->secret_class_id; 
                $update->bookrep_secret_class_name = $secretsave->secret_class_name; 
            } else {
                $update->bookrep_secret_class_id = ''; 
                $update->bookrep_secret_class_name =''; 
            }

            $speed = $request->input('bookrep_speed_class_id'); 
            if ($speed != '') {
                $speedsave = DB::table('speed_class')->where('speed_class_id','=',$speed)->first();
                $update->bookrep_speed_class_id = $speedsave->speed_class_id; 
                $update->bookrep_speed_class_name = $speedsave->speed_class_name; 
            } else {
                $update->bookrep_speed_class_id = ''; 
                $update->bookrep_speed_class_name =''; 
            }

            $type = $request->input('bookrep_type_id');
            if ($type != '') {
                $typesave = DB::table('book_type')->where('booktype_id','=',$type)->first();
                $update->bookrep_type_id = $typesave->booktype_id; 
                $update->bookrep_type_name = $typesave->booktype_name; 
            } else {
                $update->bookrep_type_id = ''; 
                $update->bookrep_type_name =''; 
            }    
            $userid = $request->input('user_id'); 
            if ($userid != '') {
                $repsave = DB::table('users')->where('id','=',$userid)->first();
                $update->bookrep_usersend_id = $repsave->id; 
                $update->bookrep_usersend_name = $repsave->fname. '  ' .$repsave->lname ; 
            } else {
                $update->bookrep_usersend_id = ''; 
                $update->bookrep_usersend_name =''; 
            }       

            $update->bookrep_name = $request->input('bookrep_name'); 
            $update->bookrep_story = $request->input('bookrep_story'); 
            $update->bookrep_assembly = $request->input('bookrep_assembly'); 

            // $maxid = Bookrep::max('bookrep_id');
            $idfile = $idrep;
            if($request->hasFile('pdfupload')){
                $description = 'storage/bookrep_pdf/'.$update->pdfupload;
                if (File::exists($description))
                {
                    File::delete($description);
                }
                $newFileName = 'bookrep_'.$idfile.'.'.$request->pdfupload->extension();                
                $request->pdfupload->storeAs('bookrep_pdf',$newFileName,'public');
                $update->bookrep_file = $newFileName;
            }
            if($request->hasFile('bookrep_file1')){
                // $description = 'storage/bookrep_pdf/'.$update->bookrep_file1;
                // if (File::exists($description))
                // {
                //     File::delete($description);
                // }
                $newFileName1 = 'bookrep_'.$idfile.'_1'.'.'.$request->bookrep_file1->extension();                
                $request->bookrep_file1->storeAs('bookrep_pdf',$newFileName1,'public');
                $update->bookrep_file1 = $newFileName1;
                // $addreceipt->BOOK_FILE_NAME_OLD =  $request->file('bookrep_file1')->getClientOriginalName();
            }
            if($request->hasFile('bookrep_file2')){
                // $description = 'storage/bookrep_pdf/'.$update->bookrep_file2;
                // if (File::exists($description))
                // {
                //     File::delete($description);
                // }
                $newFileName2 = 'bookrep_'.$idfile.'_2'.'.'.$request->bookrep_file2->extension();                
                $request->bookrep_file2->storeAs('bookrep_pdf',$newFileName2,'public');
                $update->bookrep_file2 = $newFileName2; 
            }
            if($request->hasFile('bookrep_file3')){
                // $description = 'storage/bookrep_pdf/'.$update->bookrep_file3;
                // if (File::exists($description))
                // {
                //     File::delete($description);
                // }
                $newFileName3 = 'bookrep_'.$idfile.'_3'.'.'.$request->bookrep_file3->extension();                
                $request->bookrep_file3->storeAs('bookrep_pdf',$newFileName3,'public');
                $update->bookrep_file3 = $newFileName3; 
            }
            if($request->hasFile('bookrep_file4')){
                $description = 'storage/bookrep_pdf/'.$update->bookrep_file4;
                if (File::exists($description))
                {
                    File::delete($description);
                }
                $newFileName4 = 'bookrep_'.$idfile.'_4'.'.'.$request->bookrep_file4->extension();                
                $request->bookrep_file4->storeAs('bookrep_pdf',$newFileName4,'public');
                $update->bookrep_file4 = $newFileName4; 
            }


            // $file_name = $file->bookrep_file4;
            // $file_id = $file->bookrep_id;
            // $filepath = public_path('storage/bookrep_pdf/'.$file_name);
            // $description = File::delete($filepath);

            if($request->hasFile('bookrep_file5')){
                // $description = 'storage/bookrep_pdf/'.$update->bookrep_file5;
                // if (File::exists($description))
                // {
                //     File::delete($description);
                // }
                $newFileName5 = 'bookrep_'.$idfile.'_5'.'.'.$request->bookrep_file5->extension();                
                $request->bookrep_file5->storeAs('bookrep_pdf',$newFileName5,'public');
                $update->bookrep_file5 = $newFileName5; 
            }
           
            $update->save();    
            return response()->json([
                'status'     => '200'
                ]);
    }
    public function bookmake_index_send(Request $request,$id)
    {    
        // $data['bookrep'] = DB::table('bookrep')->get();
        $dataedit = Bookrep::leftJoin('book_import_fam','bookrep.bookrep_import_fam','=','book_import_fam.import_fam_id')->where('bookrep_id','=',$id)->first(); 
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

        $bookcount = Bookrep::where('bookrep_id','=',$id)->where('bookrep_send_code','!=','waitsend')->count(); 

        $adcount =  Bookrep::where('bookrep_id','=',$id)->where('bookrep_send_code','=','waitallows')->count();   
     
        return view('book.bookmake_index_send',$data,[
            'dataedits'=>$dataedit,            
            'bookcount'=>$bookcount,
            'adcount'=>$adcount,
        ]);
        // ->with('message','active');
    }
    public function bookmake_index_send_deb(Request $request,$id)
    {    
        // $data['bookrep'] = DB::table('bookrep')->get();
        $dataedit = Bookrep::leftJoin('book_import_fam','bookrep.bookrep_import_fam','=','book_import_fam.import_fam_id')->where('bookrep_id','=',$id)->first(); 
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
        $bookcount = Bookrep::where('bookrep_id','=',$id)->where('bookrep_send_code','!=','waitsend')->count();
        $adcount =  Bookrep::where('bookrep_id','=',$id)->where('bookrep_send_code','=','waitallows')->count();  
        
        
     
        return view('book.bookmake_index_send_deb',$data,[
            'dataedits'=>$dataedit,            
            'bookcount'=>$bookcount,
            'adcount'=>$adcount,
        ]);
        // ->with('message','active');
    }
    public function bookmake_index_send_debsub(Request $request,$id)
    {    
        // $data['bookrep'] = DB::table('bookrep')->get();
        $dataedit = Bookrep::leftJoin('book_import_fam','bookrep.bookrep_import_fam','=','book_import_fam.import_fam_id')->where('bookrep_id','=',$id)->first(); 
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

        $bookcount = Bookrep::where('bookrep_id','=',$id)->where('bookrep_send_code','!=','waitsend')->count(); 

        $adcount =  Bookrep::where('bookrep_id','=',$id)->where('bookrep_send_code','=','waitallows')->count();   
     
        return view('book.bookmake_index_send_debsub',$data,[
            'dataedits'=>$dataedit,            
            'bookcount'=>$bookcount,
            'adcount'=>$adcount,
        ]);
        // ->with('message','active');
    }

    public function bookmake_index_send_debsubsub(Request $request,$id)
    {    
        // $data['bookrep'] = DB::table('bookrep')->get();
        $dataedit = Bookrep::leftJoin('book_import_fam','bookrep.bookrep_import_fam','=','book_import_fam.import_fam_id')->where('bookrep_id','=',$id)->first(); 
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
        $data['book_senddep_subsub'] = DB::table('book_senddep_subsub')->where('bookrep_id','=',$id)->get();

        $bookcount = Bookrep::where('bookrep_id','=',$id)->where('bookrep_send_code','!=','waitsend')->count(); 

        $adcount =  Bookrep::where('bookrep_id','=',$id)->where('bookrep_send_code','=','waitallows')->count();   
     
        return view('book.bookmake_index_send_debsubsub',$data,[
            'dataedits'=>$dataedit,            
            'bookcount'=>$bookcount,
            'adcount'=>$adcount,
        ]);
        // ->with('message','active');
    }
    public function bookmake_index_send_person(Request $request,$id)
    {    
        // $data['bookrep'] = DB::table('bookrep')->get();
        $dataedit = Bookrep::leftJoin('book_import_fam','bookrep.bookrep_import_fam','=','book_import_fam.import_fam_id')->where('bookrep_id','=',$id)->first(); 
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

        $bookcount = Bookrep::where('bookrep_id','=',$id)->where('bookrep_send_code','!=','waitsend')->count(); 

        $adcount =  Bookrep::where('bookrep_id','=',$id)->where('bookrep_send_code','=','waitallows')->count();   
     
        return view('book.bookmake_index_send_person',$data,[
            'dataedits'=>$dataedit,            
            'bookcount'=>$bookcount,
            'adcount'=>$adcount,
        ]);
        // ->with('message','active');
    }
    public function bookmake_index_send_team(Request $request,$id)
    {    
        // $data['bookrep'] = DB::table('bookrep')->get();
        $dataedit = Bookrep::leftJoin('book_import_fam','bookrep.bookrep_import_fam','=','book_import_fam.import_fam_id')->where('bookrep_id','=',$id)->first(); 
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

        $bookcount = Bookrep::where('bookrep_id','=',$id)->where('bookrep_send_code','!=','waitsend')->count(); 

        $adcount =  Bookrep::where('bookrep_id','=',$id)->where('bookrep_send_code','=','waitallows')->count();   
     
        return view('book.bookmake_index_send_team',$data,[
            'dataedits'=>$dataedit,            
            'bookcount'=>$bookcount,
            'adcount'=>$adcount,
        ]);
        // ->with('message','active');
    }
    public function bookmake_index_send_fileplus(Request $request,$id)
    {    
        // $data['bookrep'] = DB::table('bookrep')->get();
        $dataedit = Bookrep::leftJoin('book_import_fam','bookrep.bookrep_import_fam','=','book_import_fam.import_fam_id')->where('bookrep_id','=',$id)->first(); 
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

        $bookcount = Bookrep::where('bookrep_id','=',$id)->where('bookrep_send_code','!=','waitsend')->count(); 

        $adcount =  Bookrep::where('bookrep_id','=',$id)->where('bookrep_send_code','=','waitallows')->count();   
     
        return view('book.bookmake_index_send_fileplus',$data,[
            'dataedits'=>$dataedit,            
            'bookcount'=>$bookcount,
            'adcount'=>$adcount,
        ]);
        // ->with('message','active');
    }
    public function bookmake_index_send_open(Request $request,$id)
    {    
        // $data['bookrep'] = DB::table('bookrep')->get();
        $dataedit = Bookrep::leftJoin('book_import_fam','bookrep.bookrep_import_fam','=','book_import_fam.import_fam_id')->where('bookrep_id','=',$id)->first(); 
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

        $bookcount = Bookrep::where('bookrep_id','=',$id)->where('bookrep_send_code','!=','waitsend')->count(); 

        $adcount =  Bookrep::where('bookrep_id','=',$id)->where('bookrep_send_code','=','waitallows')->count();  
        $data['book_read'] = DB::connection('mysql')->select('   
            SELECT * from book_read bss
            LEFT JOIN users u on u.id = bss.book_read_useropen_id
            LEFT JOIN users_prefix up on up.prefix_code = u.pname
            WHERE bss.bookrep_id= "'.$id.'" 
            
            AND bss.status_book_read="OPEN";
        '); 
     
        return view('book.bookmake_index_send_open',$data,[
            'dataedits'=>$dataedit,            
            'bookcount'=>$bookcount,
            'adcount'=>$adcount,
        ]);
        // ->with('message','active');
    }
    public function bookmake_index_send_file(Request $request,$id)
    {    
        // $data['bookrep'] = DB::table('bookrep')->get();
        $dataedit = Bookrep::leftJoin('book_import_fam','bookrep.bookrep_import_fam','=','book_import_fam.import_fam_id')->where('bookrep_id','=',$id)->first(); 
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

        $bookcount = Bookrep::where('bookrep_id','=',$id)->where('bookrep_send_code','!=','waitsend')->count(); 

        $adcount =  Bookrep::where('bookrep_id','=',$id)->where('bookrep_send_code','=','waitallows')->count();   
     
        return view('book.bookmake_index_send_file',$data,[
            'dataedits'=>$dataedit,            
            'bookcount'=>$bookcount,
            'adcount'=>$adcount,
        ]);
        // ->with('message','active');
    }
    public function process(Request $request,$id)
    {
        $dataedit = Bookrep::where('bookrep_id','=',$id)->first(); 
        // download sample file.
        // Storage::disk('local')->put('test.pdf', file_get_contents('http://www.africau.edu/images/default/sample.pdf'));
        Storage::disk('local')->put('test.pdf', file_get_contents('storage/bookrep_pdf/'.$dataedit->bookrep_file));
        

        $outputFile = Storage::disk('local')->path('output.pdf');
        // $outputFile = 'storage/bookrep_pdf/'.$dataedit->bookrep_file;
        // fill data
        $this->fillPDF(Storage::disk('local')->path('test.pdf'), $outputFile);
        //output to browser
        return response()->file($outputFile);
    }

    public function fillPDF($file, $outputFile)
    {
        $fpdi = new FPDI;
        $fpdi->AddFont('helveticai','','helveticai.php'); //Regular
        // $fpdi->AddFont('angsana', '', 'angsana.ttc', true);
        // merger operations
        $count = $fpdi->setSourceFile($file);
        for ($i=1; $i<=$count; $i++) {
            $template   = $fpdi->importPage($i);
            $size       = $fpdi->getTemplateSize($template);
            // Add some Unicode font (uses UTF-8)
            // $fpdi->AddFont('upckb', '', 'upckb.ttf', true);
            // $fpdi->AddFont('DejaVuSansCondensed', 'B', 'DejaVuSansCondensed-Bold.ttf', true);
            $fpdi->AddPage($size['orientation'], array($size['width'], $size['height']));
            $fpdi->useTemplate($template);
            $left = 150;
            $top = 12;
            // $left = 140;
            // $top = 310;
            
            $fpdi->SetFont('helveticai');
            // $text = "เลขที่รับ";
            $text = "No. 25621/5215"; 
            $fpdi->SetTextColor(153,0,153);
            $fpdi->Text($left,$top,$text); //ลายนำ้
            $fpdi->Image('storage/test/dit.jpg', 150,200, 40, 20);
           
            // $pdf=new FPDF();
            // $pdf->AddPage();

            // $pdf->AddFont('THSarabun','','THSarabun.php');//ธรรมดา
            // $pdf->SetFont('THSarabun','',30);
            // $pdf->Cell(0,0,'ข้อความทดสอบ');
            // $pdf->Ln(15);

            // $pdf->AddFont('THSarabun','b','THSarabun Bold.php');//หนา
            // $pdf->SetFont('THSarabun','b',30);
            // $pdf->Cell(0,0,'ข้อความทดสอบ');
            // $pdf->Ln(15);

            // $pdf->AddFont('THSarabun','i','THSarabun Italic.php');//อียง
            // $pdf->SetFont('THSarabun','i',30);
            // $pdf->Cell(0,0,'ข้อความทดสอบ');
            // $pdf->Ln(15);

            // $pdf->AddFont('THSarabun','bi','THSarabun BoldItalic.php');//หนาเอียง
            // $pdf->SetFont('THSarabun','bi',30);
            // $pdf->Cell(0,0,'ข้อความทดสอบ');

            // $pdf->Output();
        }
        return $fpdi->Output($outputFile, 'F');
        // return $fpdi->Output($outputFile, 'I');
    }

 

    public function bookmake_sendretire(Request $request,$id)
    {    
        $data = Bookrep::find($id);
        $data->bookrep_send_code = 'waitretire';
        $data->bookrep_send_name = 'รอเกษียณ';
        $data->update();
        return response()->json([
            'statusCode'     => '200',
            'data'   =>  $data
            ]);
    }
    public function bookmake_sendpo(Request $request,$id)
    {    
        $data = Bookrep::find($id);
        $data->bookrep_send_code = 'waitallows';
        $data->bookrep_send_name = 'เสนอ ผอ.';
        $data->update();
        return response()->json([
            'statusCode'     => '200',
            'data'   =>  $data
            ]);
    }
    public function bookmake_index_senddebindex(Request $request,$id)
    {    
        // $data['bookrep'] = DB::table('bookrep')->get();
        $dataedit = Bookrep::leftJoin('book_import_fam','bookrep.bookrep_import_fam','=','book_import_fam.import_fam_id')->where('bookrep_id','=',$id)->first(); 
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
       
        $message = '';
        $message1 = 'active';
        $message2 = '';
        $message3 = '';
        $message4 = '';
        $message5 = '';
        $message6 = '';
        return view('book.bookmake_index_senddebindex',$data,[
            'dataedits'=>$dataedit,
            'message'=>$message,
            'message1'=>$message1,
            'message2'=>$message2,
            'message3'=>$message3,
            'message4'=>$message4,
            'message5'=>$message5,
            'message6'=>$message6,
        ]);
        // ->with('message','active');
    }

    public function book_send_email(Request $request,$id)
    {   
        $dataedit = DB::table('bookrep')->where('bookrep_id','=',$id)->first();
        return view('book.book_sendemail',[
            'dataedit' =>$dataedit,
           ]);

    }
    public function send_mailnewbook(Request $request)
    {   

        dd($request->all());
        // if ($this->isOnline()) {
           
            $maildata = [
            'email' => $request->email,
            'title' => $request->title,
            'content' => $request->content,
            'bookrep_file' => $request->bookrep_file,
            ];

            Mail::send('emails.sendemail',$maildata ,function($message)use ($maildata){
                $message->to($maildata['email'])
                ->subject($maildata['title'],$maildata['content']);
            });

        // } else {
        //     return redirect()->back()->with('success','ok');
        // }
    }

    public function book_sendemail_file(Request $request,$id)
    {  
        $dataedit = Bookrep::leftJoin('book_import_fam','bookrep.bookrep_import_fam','=','book_import_fam.import_fam_id')->where('bookrep_id','=',$id)->first(); 
        $filename = $dataedit-> bookrep_file;
        $pdf = PDF::loadView('book.book_sendemail',[            
            'filename' => $filename,           
            ]);
            return @$pdf->stream();
        // $dataedit = DB::table('bookrep')->where('bookrep_id','=',$id)->first();
        // return view('book.book_sendemail_file',[
        //     'dataedit' =>$dataedit,
        //    ]);

    }
        // public function disSendMail(Request $request)
        // {
        //     $email = $request->email;
        //     $title = $request->title;
        //     $content = $request->content; 

        //     $pdf = PDF::loadView('book.book_sendemail_file');
        //     $mailData = [
        //         'title' => $title,
        //         'content' => $content, 
        //     ];
    
        //     Mail::send('book.book_sendemail_file',)
        //     // Mail::to($email)->send(new SendMail($mailData));

        //     dd("Mail Send Successfully");
        // }

    public function bookmake_detail(Request $request,$id)
    {
    
        $infomation = DB::table('bookrep')->where('bookrep_id','=',$id)->first();
        return view('book.bookmake_detail',[
            'infomation' =>$infomation,
           ]);
    }
    function bookmake_index_senddep(Request $request )
    {     
        // return $request;
        date_default_timezone_set("Asia/Bangkok");
        $datenow = date('Y-m-d');
        $timenow = date('H:i:s');  
        $id = $request->DEPARTMENT_ID;   
        $bookrepid = $request->bookrep_id;
        $userid = $request->input('user_id'); 
        // dd($id);
          $count_check = Book_senddep::where('senddep_dep_id','=',$id)->where('bookrep_id','=',$bookrepid)->count();     
        //    dd($count_check);                           
            if($count_check > 0){
                return response()->json([
                    'status'   => '0' 
                    ]);
            } else {                 
                    $add = new Book_senddep(); 
                    $iddep = DB::table('department')->where('DEPARTMENT_ID','=',$id)->first();
                    $add->senddep_dep_id = $iddep->DEPARTMENT_ID; 
                    $add->senddep_dep_name = $iddep->DEPARTMENT_NAME; 
                    $add->bookrep_id = $bookrepid; 
                    $add->senddep_date = date('Y-m-d');
                    $add->senddep_time = date('H:i:s');

                    $objid = $request->input('book_objective');
                    if ($objid != '') {
                        $save = DB::table('book_objective')->where('objective_id','=',$objid)->first();
                        $add->objective_id = $save->objective_id; 
                        $add->objective_name = $save->objective_name; 
                    } else {
                        $add->objective_id = ''; 
                        $add->objective_name =''; 
                    }  

                    if ($userid != '') {
                        $repsave = DB::table('users')->where('id','=',$userid)->first();
                        $add->senddep_usersend_id = $repsave->id; 
                        $add->senddep_usersend_name = $repsave->fname. '  ' .$repsave->lname ; 
                    } else {
                        $add->senddep_usersend_id = ''; 
                        $add->senddep_usersend_name =''; 
                    }  
                    $add->save(); 

                    $update = Bookrep::find($bookrepid);
                    $update->bookrep_send_status_code = 'senddep';
                    $update->bookrep_send_status_name = 'ส่งหน่วยงาน';
                    $update->save();

                     // Book_read
                    $user_data = User::where('dep_id','=',$id)->get();
                    foreach ($user_data as $key => $value) {
                        $date = date('Y-m-d');
                        $time = date('H:m:s');
                        $check = Book_read::where('bookrep_id','=',$bookrepid)->where('book_read_useropen_id','=', $value->id)->count();
                        if ($check > 0) {
                            # code...
                        } else {
                            Book_read::insert([
                                'bookrep_id'               => $bookrepid, 
                                'book_read_useropen_id'    => $value->id,
                                'book_read_date'           => $date,
                                'book_read_time'           => $time                             
                            ]);
                        }
                        
                    }
                   
                        //แจ้งเตือน 
                        function DateThailine($strDate)
                            {
                                $strYear = date("Y",strtotime($strDate))+543;
                                $strMonth= date("n",strtotime($strDate));
                                $strDay= date("j",strtotime($strDate));
                        
                                $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
                                $strMonthThai=$strMonthCut[$strMonth];
                                return "$strDay $strMonthThai $strYear";
                            }

                        $header = "ข้อมูลสารบรรณ";            
                        $info = Bookrep:: where('bookrep_id','=',$bookrepid)->first();
                        $department = DB::table('department')->where('DEPARTMENT_ID','=',$id)->first(); 
                        $line = $department->LINE_TOKEN;

                        $obj = DB::table('book_senddep')->where('bookrep_id','=',$bookrepid)->where('senddep_dep_id','=',$id)->first(); 
                        // $url = href="{{asset('storage/bookrep_pdf/'.$dataedits->bookrep_file4)}}"><i class="fa-solid fa-2x fa-file-pdf text-danger "></i> </a> 
                        $link = DB::table('orginfo')->where('orginfo_id','=',1)->first(); 
                        $link_line = $link->orginfo_link;
                        
                        $datesend = date('Y-m-d');
                        $sendate = DateThailine($datesend);

                        $message = $header.
                            "\n"."เลขที่รับ : " . $info->bookrep_recievenum .
                            "\n"."ชื่อเรื่อง : " . $info->bookrep_name .
                            "\n"."เลขที่หนังสือ : " . $info->bookrep_repbooknum .
                            "\n"."กลุ่มงาน : " . $department->DEPARTMENT_NAME  .
                            "\n"."ชั้นความลับ : " . $info->bookrep_secret_class_name .
                            "\n"."วัตถุประสงค์ : " . $obj->objective_name.               
                            "\n"."วันที่ : " . $sendate.    
                            "\n"."เวลา : " . date('H:i:s'). 
                            "\n"."ไฟล์ : " . $link_line."/book/bookmake_detail/".$bookrepid;
                            
                            // "\n"."ผู้ตรวจสอบ : " . $infopersonver ->HR_PREFIX_NAME.''.$infopersonver ->HR_FNAME.' '.$infopersonver ->HR_LNAME .
                            "\n"."ชั้นความเร็ว : " .  $info->bookrep_speed_class_name; 

                                //    $org_h = DB::table('info_org')->where('ORG_ID','=','1')->first();
                                // $name = DB::table('hrd_person')->where('ID','=',$org_h->ORG_LEADER_ID)->first();
                                // $iddep = DB::table('department')->where('DEPARTMENT_ID','=',$id)->first();
                                $linesend = $line; 
                                // dd($linesend); 
                                // $department = DB::table('department')->where('HR_DEPARTMENT_ID','=',$iddep->DEPARTMENT_ID)->first();       
                            if($linesend == null){
                                $test ='';
                            }else{
                                $test = $linesend;
                            }

                        if($test !== '' && $test !== null){  
                                $chOne = curl_init();
                                curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
                                curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0);
                                curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0);
                                curl_setopt( $chOne, CURLOPT_POST, 1);
                                curl_setopt( $chOne, CURLOPT_POSTFIELDS, $message);
                                curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=$message");
                                curl_setopt( $chOne, CURLOPT_FOLLOWLOCATION, 1);
                                $headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$test.'', );
                                curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
                                curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1);
                                $result = curl_exec( $chOne );
                                if(curl_error($chOne)) { echo 'error:' . curl_error($chOne); }
                                else { 
                                    $result_ = json_decode($result, true);
                                    // echo "status : ".$result_['status']; echo "message : ". $result_['message'];
                                    return response()->json([
                                        'status'     => 200 , 
                                        ]);
                            
                            }
                                curl_close( $chOne );
                                
                        }
                        
            }  
            
    }

    
    function bookmake_index_senddepsub(Request $request )
    {     
        date_default_timezone_set("Asia/Bangkok");
        $datenow = date('Y-m-d');
        $timenow = date('H:i:s');
        $id = $request->DEPARTMENT_SUB_ID;
        $bookrepid = $request->bookrep_id;
        $userid = $request->input('user_id'); 
        // dd($id);
        if ($id == '') {
            return response()->json([
                'status'   => '10' 
                ]); 
        } else {
                          
          $count_check = Book_senddep_sub::where('senddep_depsub_id','=',$id)->where('bookrep_id','=',$bookrepid)->count();                     
            if($count_check > 0){ 
                return response()->json([
                    'status'   => '0' 
                    ]); 
            }else{

                $add = new Book_senddep_sub(); 

                $iddep = DB::table('department_sub')->where('DEPARTMENT_SUB_ID','=',$id)->first();
                $add->senddep_depsub_id = $iddep->DEPARTMENT_SUB_ID; 
                $add->senddep_depsub_name = $iddep->DEPARTMENT_SUB_NAME;

                $add->bookrep_id = $bookrepid; 
                $add->senddep_date = date('Y-m-d');
                $add->senddep_time = date('H:i:s');

                $objid = $request->input('book_objective2');
                if ($objid != '') {
                    $save = DB::table('book_objective')->where('objective_id','=',$objid)->first();
                    $add->objective_id = $save->objective_id; 
                    $add->objective_name = $save->objective_name; 
                } else {
                    $add->objective_id = ''; 
                    $add->objective_name =''; 
                }  

                if ($userid != '') {
                    $repsave = DB::table('users')->where('id','=',$userid)->first();
                    $add->senddepsub_usersend_id = $repsave->id; 
                    $add->senddepsub_usersend_name = $repsave->fname. '  ' .$repsave->lname ; 
                } else {
                    $add->senddepsub_usersend_id = ''; 
                    $add->senddepsub_usersend_name =''; 
                }  
                $add->save(); 

                $update = Bookrep::find($bookrepid);
                $update->bookrep_send_code = 'senddep';
                $update->save();

                // Book_read
                $user_data = User::where('dep_subid','=',$id)->get();
                foreach ($user_data as $key => $value) {
                    $date = date('Y-m-d');
                    $time = date('H:m:s');
                    $check = Book_read::where('bookrep_id','=',$bookrepid)->where('book_read_useropen_id','=', $value->id)->count();
                    if ($check > 0) {
                        # code...
                    } else {
                        Book_read::insert([
                            'bookrep_id'               => $bookrepid, 
                            'book_read_useropen_id'    => $value->id,
                            'book_read_date'           => $date,
                            'book_read_time'           => $time                             
                        ]);
                    }
                    
                }

                //แจ้งเตือน 
            function DateThailine($strDate)
            {
                    $strYear = date("Y",strtotime($strDate))+543;
                    $strMonth= date("n",strtotime($strDate));
                    $strDay= date("j",strtotime($strDate));
            
                    $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
                    $strMonthThai=$strMonthCut[$strMonth];
                    return "$strDay $strMonthThai $strYear";
               }

                $header = "ข้อมูลสารบรรณ";            
                $info = Bookrep:: where('bookrep_id','=',$bookrepid)->first();
                $depsub = DB::table('department_sub')->where('DEPARTMENT_SUB_ID','=',$id)->first(); 
                $line = $depsub->LINE_TOKEN;

                $obj = DB::table('book_senddep_sub')->where('bookrep_id','=',$bookrepid)->where('senddep_depsub_id','=',$id)->first(); 
                $link = DB::table('orginfo')->where('orginfo_id','=',1)->first(); 
                $link_line = $link->orginfo_link;

                $datesend = date('Y-m-d');
                $sendate = DateThailine($datesend);
            
                $message = $header.
                    "\n"."เลขที่รับ : " . $info->bookrep_recievenum .
                    "\n"."ชื่อเรื่อง : " . $info->bookrep_name .
                    "\n"."เลขที่หนังสือ : " . $info->bookrep_repbooknum .
                    "\n"."ฝ่าย/แผนก : " . $depsub->DEPARTMENT_SUB_NAME  .
                    "\n"."ชั้นความลับ : " . $info->bookrep_secret_class_name .
                    "\n"."วัตถุประสงค์ : " . $obj->objective_name.     
                    "\n"."ชั้นความเร็ว : " .  $info->bookrep_speed_class_name. 
                    "\n"."วันที่ : " . $sendate .    
                    "\n"."เวลา : " . date('H:i:s'). 
                    // "\n"."ไฟล์ : " . $link_line."/bookmake_detail/bookrep_".$bookrepid;
                    "\n"."ไฟล์ : " . $link_line."/book/bookmake_detail/".$bookrepid;
                        $linesend = $line;      
                    if($linesend == null){
                        $test ='';
                    }else{
                        $test = $linesend;
                    }

                if($test !== '' && $test !== null){  
                    $chOne = curl_init();
                    curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
                    curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0);
                    curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0);
                    curl_setopt( $chOne, CURLOPT_POST, 1);
                    curl_setopt( $chOne, CURLOPT_POSTFIELDS, $message);
                    curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=$message");
                    curl_setopt( $chOne, CURLOPT_FOLLOWLOCATION, 1);
                    $headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$test.'', );
                    curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1);
                    $result = curl_exec( $chOne );
                    if(curl_error($chOne)) { echo 'error:' . curl_error($chOne); }
                    else { $result_ = json_decode($result, true);
                    // echo "status : ".$result_['status']; echo "message : ". $result_['message'];
                    return response()->json([
                        'status'     => 200 , 
                        ]);
                
                }
                    curl_close( $chOne );
            }
            } 
        }      
            
    }

    function bookmake_index_senddepsubsub(Request $request )
    {     
        date_default_timezone_set("Asia/Bangkok");
        $datenow = date('Y-m-d');
        $timenow = date('H:i:s');
        $id = $request->dep_subsub_id;
        $bookrepid = $request->bookrep_id;
        $userid = $request->input('user_id'); 
        // dd($id);
        if ($id == '') {
            return response()->json([
                'status'   => '100',
 
                ]); 
        } else {
                          
          $count_check = Book_senddep_subsub::where('senddep_depsubsub_id','=',$id)->where('bookrep_id','=',$bookrepid)->count();                     
            if($count_check > 0){ 
                return response()->json([
                    'status'   => '0' 
                    ]); 
            }else{

                $add = new Book_senddep_subsub(); 

                $iddep = DB::table('department_sub_sub')->where('DEPARTMENT_SUB_SUB_ID','=',$id)->first();

                $add->senddep_depsubsub_id = $iddep->DEPARTMENT_SUB_SUB_ID; 
                $add->senddep_depsubsub_name = $iddep->DEPARTMENT_SUB_SUB_NAME;

                $add->bookrep_id = $bookrepid; 
                $add->senddep_date = date('Y-m-d');
                $add->senddep_time = date('H:i:s');

                $objid = $request->input('book_objective2');
                if ($objid != '') {
                    $save = DB::table('book_objective')->where('objective_id','=',$objid)->first();
                    $add->objective_id = $save->objective_id; 
                    $add->objective_name = $save->objective_name; 
                } else {
                    $add->objective_id = ''; 
                    $add->objective_name =''; 
                }  

                if ($userid != '') {
                    $repsave = DB::table('users')->where('id','=',$userid)->first();
                    $add->senddepsub_usersend_id = $repsave->id; 
                    $add->senddepsub_usersend_name = $repsave->fname. '  ' .$repsave->lname ; 
                } else {
                    $add->senddepsub_usersend_id = ''; 
                    $add->senddepsub_usersend_name =''; 
                }  
                $add->save(); 

                $update = Bookrep::find($bookrepid);
                $update->bookrep_send_code = 'senddep';
                $update->save();

                // Book_read
                $user_data = User::where('dep_subsubtrueid','=',$id)->get();
                foreach ($user_data as $key => $value) {
                    $date = date('Y-m-d');
                    $time = date('H:m:s');
                    $check = Book_read::where('bookrep_id','=',$bookrepid)->where('book_read_useropen_id','=', $value->id)->count();
                    if ($check > 0) {
                        # code...
                    } else {
                        Book_read::insert([
                            'bookrep_id'               => $bookrepid, 
                            'book_read_useropen_id'    => $value->id,
                            'book_read_date'           => $date,
                            'book_read_time'           => $time                             
                        ]);
                    }
                   
                }


                //แจ้งเตือน 
                function DateThailine($strDate)
                {
                        $strYear = date("Y",strtotime($strDate))+543;
                        $strMonth= date("n",strtotime($strDate));
                        $strDay= date("j",strtotime($strDate));
                
                        $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
                        $strMonthThai=$strMonthCut[$strMonth];
                        return "$strDay $strMonthThai $strYear";
                }

                    $header = "ข้อมูลสารบรรณ";            
                    $info = Bookrep:: where('bookrep_id','=',$bookrepid)->first();
                    $depsub = DB::table('department_sub_sub')->where('DEPARTMENT_SUB_SUB_ID','=',$id)->first(); 
                    $line = $depsub->LINE_TOKEN;

                    $obj = DB::table('book_senddep_subsub')->where('bookrep_id','=',$bookrepid)->where('senddep_depsubsub_id','=',$id)->first(); 

                    $link = DB::table('orginfo')->where('orginfo_id','=',1)->first(); 
                    $link_line = $link->orginfo_link;

                    $datesend = date('Y-m-d');
                    $sendate = DateThailine($datesend);
                
                    $message = $header.
                        "\n"."เลขที่รับ : " . $info->bookrep_recievenum .
                        "\n"."ชื่อเรื่อง : " . $info->bookrep_name .
                        "\n"."เลขที่หนังสือ : " . $info->bookrep_repbooknum .
                        "\n"."ฝ่าย/แผนก : " . $depsub->DEPARTMENT_SUB_SUB_NAME  .
                        "\n"."ชั้นความลับ : " . $info->bookrep_secret_class_name .
                        "\n"."วัตถุประสงค์ : " . $obj->objective_name.     
                        "\n"."ชั้นความเร็ว : " .  $info->bookrep_speed_class_name. 
                        "\n"."วันที่ : " . $sendate .    
                        "\n"."เวลา : " . date('H:i:s'). 
                        // "\n"."ไฟล์ : " . $link_line."/bookmake_detail/bookrep_".$bookrepid;
                        "\n"."ไฟล์ : " . $link_line."/book/bookmake_detail/".$bookrepid;
                            $linesend = $line;      
                        if($linesend == null){
                            $test ='';
                        }else{
                            $test = $linesend;
                        }

                    if($test !== '' && $test !== null){  
                        $chOne = curl_init();
                        curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
                        curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0);
                        curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0);
                        curl_setopt( $chOne, CURLOPT_POST, 1);
                        curl_setopt( $chOne, CURLOPT_POSTFIELDS, $message);
                        curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=$message");
                        curl_setopt( $chOne, CURLOPT_FOLLOWLOCATION, 1);
                        $headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$test.'', );
                        curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
                        curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1);
                        $result = curl_exec( $chOne );
                        if(curl_error($chOne)) { echo 'error:' . curl_error($chOne); }
                        else { $result_ = json_decode($result, true);
                        // echo "status : ".$result_['status']; echo "message : ". $result_['message'];
                        return response()->json([
                            'status'     => 200 , 
                           
                            ]);
                    
                    }
                        curl_close( $chOne );
                }
            } 
        }      
            
    }

    function bookmake_index_sendperson(Request $request )
    {     
        date_default_timezone_set("Asia/Bangkok");
        $datenow = date('Y-m-d');
        $id = $request->sendperson_user_id;
        $bookrepid = $request->bookrep_id;
        $userid = $request->input('user_id'); 

          $count_check = Book_send_person::where('bookrep_id','=',$bookrepid)->where('sendperson_user_id','=',$id)->count();   
        //   dd($count_check);        
        if($count_check > 0){ 
            return response()->json([
                'status'   => '0' 
                ]); 
        }else{   
                $add = new Book_send_person(); 
                $idusersend = DB::table('users')->where('id','=',$id)->first();
                $add->sendperson_user_id = $idusersend->id; 
                $add->sendperson_user_name = $idusersend->fname.'  '.$idusersend->lname; 

                $add->bookrep_id = $bookrepid; 
                $add->senddep_date = date('Y-m-d');
                $add->senddep_time = date('H:i:s');

                $objid = $request->input('book_objective3');
                if ($objid != '') {
                    $save = DB::table('book_objective')->where('objective_id','=',$objid)->first();
                    $add->objective_id = $save->objective_id; 
                    $add->objective_name = $save->objective_name; 
                } else {
                    $add->objective_id = ''; 
                    $add->objective_name =''; 
                }  

                if ($userid != '') {
                    $repsave = DB::table('users')->where('id','=',$userid)->first();
                    $add->sendperson_usersend_id = $repsave->id; 
                    $add->sendperson_usersend_name = $repsave->fname. '  ' .$repsave->lname ; 
                } else {
                    $add->sendperson_usersend_id = ''; 
                    $add->sendperson_usersend_name =''; 
                }  
                $add->save(); 

                $update = Bookrep::find($bookrepid);
                $update->bookrep_send_code = 'senddep';
                $update->save();

                 // Book_read
                 $user_data = User::where('id','=',$id)->get();
                 foreach ($user_data as $key => $value) {
                     $date = date('Y-m-d');
                     $time = date('H:m:s');
                    // $checkper = Book_send_person::where('bookrep_id','=',$bookrepid)->where('sendperson_user_id','=', $value->id)->count();                   
                    // if ($checkper > 0) {
                    //     return response()->json([
                    //         'status'     => 150 , 
                    //         ]);
                    // } else {
                        // $check = Book_read::where('bookrep_id','=',$bookrepid)->where('book_read_useropen_id','=', $value->id)->count();
                        // if ($check > 0) {
                        //     return response()->json([
                        //         'status'     => 150 , 
                        //         ]);
                        //  } else {
                             Book_read::insert([
                                 'bookrep_id'               => $bookrepid, 
                                 'book_read_useropen_id'    => $value->id,
                                 'book_read_date'           => $date,
                                 'book_read_time'           => $time                             
                             ]);
                        //  }
                    // }
                    
                     
                    
                 }

                //แจ้งเตือน 
                function DateThailine($strDate)
                {
                    $strYear = date("Y",strtotime($strDate))+543;
                    $strMonth= date("n",strtotime($strDate));
                    $strDay= date("j",strtotime($strDate));
            
                    $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
                    $strMonthThai=$strMonthCut[$strMonth];
                    return "$strDay $strMonthThai $strYear";
                }

                $header = "ข้อมูลสารบรรณ";            
                $info = Bookrep:: where('bookrep_id','=',$bookrepid)->first();
                $usersen = DB::table('users')->where('id','=',$id)->first(); 
                $line = $usersen->line_token;

                $obj = DB::table('book_send_person')->where('bookrep_id','=',$bookrepid)->where('sendperson_user_id','=',$id)->first(); 
                $link = DB::table('orginfo')->where('orginfo_id','=',1)->first(); 
                $link_line = $link->orginfo_link;

                $datesend = date('Y-m-d');
                $sendate = DateThailine($datesend);
            
                $message = $header.
                    "\n"."เลขที่รับ : " . $info->bookrep_recievenum .
                    "\n"."ชื่อเรื่อง : " . $info->bookrep_name .
                    "\n"."เลขที่หนังสือ : " . $info->bookrep_repbooknum .
                    "\n"."ชื่อ-นามกสุล : " . $usersen->fname. '  ' .$usersen->lname  .
                    "\n"."ชั้นความลับ : " . $info->bookrep_secret_class_name .
                    "\n"."วัตถุประสงค์ : " . $obj->objective_name.     
                    "\n"."ชั้นความเร็ว : " .  $info->bookrep_speed_class_name.
                    "\n"."วันที่ : " . $sendate.    
                    "\n"."เวลา : " . date('H:i:s'). 
                    // "\n"."ไฟล์ : " . $link_line."/bookmake_detail/bookrep_".$bookrepid;  
                    "\n"."ไฟล์ : " . $link_line."/book/bookmake_detail/".$bookrepid;
                        $linesend = $line;      
                    if($linesend == null){
                        $test ='';
                    }else{
                        $test = $linesend;
                    }

                if($test !== '' && $test !== null){  
                    $chOne = curl_init();
                    curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
                    curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0);
                    curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0);
                    curl_setopt( $chOne, CURLOPT_POST, 1);
                    curl_setopt( $chOne, CURLOPT_POSTFIELDS, $message);
                    curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=$message");
                    curl_setopt( $chOne, CURLOPT_FOLLOWLOCATION, 1);
                    $headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$test.'', );
                    curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1);
                    $result = curl_exec( $chOne );
                    if(curl_error($chOne)) { echo 'error:' . curl_error($chOne); }
                    else { 
                        $result_ = json_decode($result, true);
                    // echo "status : ".$result_['status']; echo "message : ". $result_['message'];
                    return response()->json([
                        'status'     => 200 , 
                        ]);
                }
                    curl_close( $chOne );
                }
                return response()->json([
                    'status'     => 200 , 
                    ]);
            }  
        // return back();      
    }
    function bookmake_index_sendteam(Request $request )
    {     
        date_default_timezone_set("Asia/Bangkok");
        $datenow = date('Y-m-d');
        $timenow = date('H:i:s');
        // $id = $request->org_team_id;
        $bookrepid = $request->bookrep_id;
        $userid = $request->input('user_id'); 
        $teamid = $request->input('org_team_id'); 
        // dd($id);
          $count_check = Book_sendteam::where('sendteam_team_id','=',$teamid)->where('bookrep_id','=',$bookrepid)->count();   

          if($count_check > 0){ 
            return response()->json([
                'status'   => '0' 
                ]); 
        }else{

                $add = new Book_sendteam(); 
                $iddep = DB::table('org_team')->where('org_team_id','=',$teamid)->first();
                $add->sendteam_team_id = $iddep->org_team_id; 
                $add->sendteam_team_name = $iddep->org_team_detail;
                $add->bookrep_id = $bookrepid; 
                $add->sendteam_date = date('Y-m-d');
                $add->sendteam_time = date('H:i:s');

                $objid = $request->input('book_objective5');
                if ($objid != '') {
                    $save = DB::table('book_objective')->where('objective_id','=',$objid)->first();
                    $add->objective_id = $save->objective_id; 
                    $add->objective_name = $save->objective_name; 
                } else {
                    $add->objective_id = ''; 
                    $add->objective_name =''; 
                }  

                if ($userid != '') {
                    $repsave = DB::table('users')->where('id','=',$userid)->first();
                    $add->sendteam_usersend_id = $repsave->id; 
                    $add->sendteam_usersend_name = $repsave->fname. '  ' .$repsave->lname ; 
                } else {
                    $add->sendteam_usersend_id = ''; 
                    $add->sendteam_usersend_name =''; 
                }  
                $add->save(); 

                $update = Bookrep::find($bookrepid);
                $update->bookrep_send_code = 'senddep';
                $update->save();

                //แจ้งเตือน 
            function DateThailine($strDate)
            {
                    $strYear = date("Y",strtotime($strDate))+543;
                    $strMonth= date("n",strtotime($strDate));
                    $strDay= date("j",strtotime($strDate));
            
                    $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
                    $strMonthThai=$strMonthCut[$strMonth];
                    return "$strDay $strMonthThai $strYear";
            }

                $header = "ข้อมูลสารบรรณ";            
                $info = Bookrep:: where('bookrep_id','=',$bookrepid)->first();
                $team = DB::table('org_team')->where('org_team_id','=',$teamid)->first(); 
                $line = $team->LINE_TOKEN;

                $obj = DB::table('book_sendteam')->where('bookrep_id','=',$bookrepid)->where('sendteam_id','=',$teamid)->first(); 
                $checkobj = Book_sendteam::where('sendteam_team_id','=',$teamid)->where('bookrep_id','=',$bookrepid)->first(); 
                $send =$checkobj->objective_name ;

                $link = DB::table('orginfo')->where('orginfo_id','=',1)->first(); 
                $link_line = $link->orginfo_link;
                
                $datesend = date('Y-m-d');
                $sendate = DateThailine($datesend);

                $message = $header.
                    "\n"."เลขที่รับ : " . $info->bookrep_recievenum .
                    "\n"."ชื่อเรื่อง : " . $info->bookrep_name .
                    "\n"."เลขที่หนังสือ : " . $info->bookrep_repbooknum .
                    "\n"."ทีมนำองค์กร : " . $team->org_team_detail  .
                    "\n"."ชั้นความลับ : " . $info->bookrep_secret_class_name .
                    "\n"."วัตถุประสงค์ : " . $send.               
                    "\n"."วันที่ : " . $sendate.    
                    "\n"."เวลา : " . date('H:i:s'). 
                    // "\n"."ไฟล์ : " . $link_line."/bookmake_detail/bookrep_".$bookrepid;
                    "\n"."ไฟล์ : " . $link_line."/book/bookmake_detail/".$bookrepid;
                    "\n"."ชั้นความเร็ว : " .  $info->bookrep_speed_class_name; 

                        $linesend = $line;       
                    if($linesend == null){
                        $test ='';
                    }else{
                        $test = $linesend;
                    }

                if($test !== '' && $test !== null){  
                    $chOne = curl_init();
                    curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
                    curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0);
                    curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0);
                    curl_setopt( $chOne, CURLOPT_POST, 1);
                    curl_setopt( $chOne, CURLOPT_POSTFIELDS, $message);
                    curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=$message");
                    curl_setopt( $chOne, CURLOPT_FOLLOWLOCATION, 1);
                    $headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$test.'', );
                    curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1);
                    $result = curl_exec( $chOne );
                    if(curl_error($chOne)) { echo 'error:' . curl_error($chOne); }
                    else { 
                        $result_ = json_decode($result, true);
                    // echo "status : ".$result_['status']; echo "message : ". $result_['message'];
                    return response()->json([
                        'status'     => 200 , 
                        ]);
                }
                    // curl_close( $chOne );
            }

            }  
       
        // return back();      
    }

    public function bookmake_index_openpdf(Request $request,$id)
    {    
        // $data['bookrep'] = DB::table('bookrep')->get();
        $dataedit = Bookrep::leftJoin('book_import_fam','bookrep.bookrep_import_fam','=','book_import_fam.import_fam_id')->where('bookrep_id','=',$id)->first(); 
        $userid = Auth::user()->id;
            $data['users'] = User::get();
            $data['book_import_fam'] = DB::table('book_import_fam')->get();
            $data['speed_class'] = DB::table('speed_class')->get();
            $data['secret_class'] = DB::table('secret_class')->get();
            $data['book_type'] = DB::table('book_type')->get();
            $data['book_signature'] = Book_signature::where('user_id','=',$userid)->get(); 

            $pdf = PDF::loadView('formpdf.11485.infowithdrawindex_billpaypdf_11485',[
                'dataedits'=>$dataedit
            ]);
            return @$pdf->stream();
        // return view('book.bookmake_index_send',$data,[
        //     'dataedits'=>$dataedit
        // ]);
    }

   public function booksend_index(Request $request)
   {   
       $data['department'] = Department::leftJoin('users','department.LEADER_ID','=','users.id')->orderBy('DEPARTMENT_ID','DESC')
       // ->select('users.*', 'department.DEPARTMENT_ID', 'department.DEPARTMENT_NAME', 'department.LINE_TOKEN')
       ->get();  
       $data['users'] = User::get();
       return view('book.booksend_index',$data);
   }
   public static function refnumber()
    {
        $year = date('Y');
        $maxnumber = DB::table('bookrep')->max('bookrep_id');  
        if($maxnumber != '' ||  $maxnumber != null){
            $refmax = DB::table('bookrep')->where('bookrep_id','=',$maxnumber)->first();  
            if($refmax->bookrep_repnum != '' ||  $refmax->bookrep_repnum != null){
            $maxref = substr($refmax->bookrep_repnum, -4)+1;
            }else{
            $maxref = 1;
            }
            $ref = str_pad($maxref, 5, "0", STR_PAD_LEFT);
        }else{
            $ref = '00001';
        }
        $ye = date('Y')+543;
        $y = substr($ye, -2);
        $refnumber = 'BO'.'-'.$ref;
        return $refnumber;
    }

    function addtype(Request $request)
    {     
     if($request->bookrep_type!= null || $request->bookrep_type != ''){    
         $count_check = Book_type::where('booktype_name','=',$request->bookrep_type)->count();           
            if($count_check == 0){    
                    $add = new Book_type(); 
                    $add->booktype_name = $request->bookrep_type;
                    $add->save(); 
            }
            }
                $query =  DB::table('book_type')->get();            
                $output='<option value="">--ประเภทหนังสือ--</option>';                
                foreach ($query as $row){
                    if($request->bookrep_type == $row->booktype_name){
                        $output.= '<option value="'.$row->booktype_id.'" selected>'.$row->booktype_name.'</option>';
                    }else{
                        $output.= '<option value="'.$row->booktype_id.'">'.$row->booktype_name.'</option>';
                    }   
            }    
        echo $output;        
    }
    function addfam(Request $request)
    {     
        if($request->book_fam!= null || $request->book_fam != ''){    
         $count_check = Book_import_fam::where('import_fam_name','=',$request->book_fam)->count();           
            if($count_check == 0){    
                    $add = new Book_import_fam(); 
                    $add->import_fam_name = $request->book_fam;
                    $add->save(); 
            }
            }
                $query =  DB::table('book_import_fam')->get();            
                $output='<option value="">--นำเข้าไว้ในแฟ้ม--</option>';                
                foreach ($query as $row){
                    if($request->book_fam == $row->import_fam_name){
                        $output.= '<option value="'.$row->import_fam_id.'" selected>'.$row->import_fam_name.'</option>';
                    }else{
                        $output.= '<option value="'.$row->import_fam_id.'">'.$row->import_fam_name.'</option>';
                    }   
            }    
        echo $output;        
    }

    public function signature_save(Request $request)
    {         

            $add = new Book_signature();

            $dataimg = $request->input('signature');
            $userid = $request->input('user_id'); 
            $bookrepid = $request->input('bookrep_id'); 

            $add->signature_name_text = $dataimg; 
            $add->signature_file = $dataimg;
            $add->user_id = $userid; 
            $add->bookrep_id = $bookrepid;
            $add->save(); 

            $update = Bookrep::find($bookrepid);
            $update->bookrep_send_code = 'retire';
            $update->bookrep_send_name = 'เกษียณ';
            $update->bookrep_comment2 = $request->input('bookrep_comment2'); 
            $userid = $request->input('user_id'); 
            if ($userid != '') {
                $repsave = DB::table('users')->where('id','=',$userid)->first();
                $update->bookrep_userretire_id = $repsave->id; 
                $update->bookrep_userretire_name = $repsave->fname. '  ' .$repsave->lname ; 
            } else {
                $update->bookrep_userretire_id = ''; 
                $update->bookrep_userretire_name =''; 
            }  

            $update->save(); 
            // if($request->hasFile('signature')){
                // $newFileName = $request->signature->extension();
                
                // $file = $request->file('signature');  
                // $contents = $file->openFile()->fread($file->getSize());
             
                // $add->signature_file = $contents;
                // $add->signature_name_text = $contents;  
                // $request->signature->storeAs('Signature',$newFileName,'public');
                //$inforpersonedit->HR_IMAGE_NAME = $newFileName; 
            // }

            // $request->signature->move('Signature','public');

            // $add = $request->file('signature')->store('Signature');

            // $dataimg->storeAs('Signature',$dataimg,'public');

            
            // $filename = time();
            // $request->signature->storeAs('Signature',$filename,'public');
            // if ($request->hasfile('signature')) {
            //     $file = $request->file('signature');
            //     $extention = $file->getClientOriginalExtension();
            //     $filename = time(); 
            //     $dataimg->storeAs('Signature',$filename,'public');
            //     // $add->img = $filename;
            //     $add->signature_name = $filename;
            // }
            // if ($request->hasfile('signature')) {
            //     $file = $request->file('signature');
            //     $extention = $file->getClientOriginalExtension();
            //     $filename = time().'.'.$extention;
            //     // $file->move('uploads/article/',$filename);
            //     $request->signature->storeAs('Signature',$filename,'public');
            //     // $file->storeAs('article/',$filename);
            //     $add->signature_name_text = $file;
            //     $add->signature_file = $file;
            //     // $add->article_img_name = $filename;
            // }

            // $add->save(); 
            // return back();   
            return response()->json([
                'status'     => '200'
                ]);
    }
    public function comment1_save(Request $request)
    {    
            $bookrepid = $request->input('bookrep_id'); 
            $update = Bookrep::find($bookrepid);
            $update->bookrep_comment1 = $request->input('bookrep_comment1');  
            $update->save(); 
         
            return response()->json([
                'status'     => '200'
                ]);
    }

    // public function sendpo_save(Request $request)
    // {    
    //         $bookrepid = $request->input('bookrep_id'); 
    //         $update = Bookrep::find($bookrepid);
    //         $update->bookrep_comment1 = $request->input('bookrep_comment1');  
    //         $update->save(); 
         
    //         return response()->json([
    //             'status'     => '200'
    //             ]);
    // }

    public function bookmake_destroy(Request $request,$id)
    {
       $del = Bookrep::find($id);  
       $del->delete(); 
        return response()->json(['status' => '200','success' => 'Delete Success']);
    }
    public function bookmake_senddep_destroy(Request $request,$id)
    {
       $del = Book_senddep::find($id);  
       $del->delete(); 
        return response()->json(['status' => '200','success' => 'Delete Success']);
    }
    public function bookmake_senddepsub_destroy(Request $request,$id)
    {
       $del = Book_senddep_sub::find($id);  
       $del->delete(); 
        return response()->json(['status' => '200','success' => 'Delete Success']);
    }
    public function bookmake_senddepsubsub_destroy(Request $request,$id)
    {
       $del = Book_senddep_subsub::find($id);  
       $del->delete(); 
        return response()->json(['status' => '200','success' => 'Delete Success']);
    }

    // Book_senddep_subsub



    public function bookmake_sendperson_destroy(Request $request,$id)
    {
      

        $idp = Book_send_person::where('sendperson_id','=',$id)->first();
        $bookrepid = $idp->bookrep_id;
        $iduser = $idp->sendperson_user_id;
    //    Book_read
        $deleted = Book_read::where('bookrep_id', '=',$bookrepid)->where('book_read_useropen_id', '=', $iduser)->get();
        foreach ($deleted as $key => $value) {
            $book_read_id = $value->book_read_id;
            $delr = Book_read::find($book_read_id);  
            $delr->delete();
        }
       

        $del = Book_send_person::find($id);  
        $del->delete();

        $active = 'active';
        return response()->json(['status' => '200','success' => 'Delete Success','active'=>$active]);
    }
    public function bookmake_sendteam_destroy(Request $request,$id)
    {
       $del = Book_sendteam::find($id);  
       $del->delete(); 
        $active = 'active';
        return response()->json(['status' => '200','success' => 'Delete Success','active'=>$active]);
    }

    public function bookrep_file1_destroy(Request $request,$id)
    {
       $file = Bookrep::find($id);  
        //    $file = DB::table('bookrep')->find($id);  

       $file_name = $file->bookrep_file1;

       $file_id = $file->bookrep_id;

        //    dd($file_id);
        //    $description = public_path('/bookrep_pdf/'.$file_name);
       $filepath = public_path('storage/bookrep_pdf/'.$file_name);
        //    dd($filepath);
       $description = File::delete($filepath);


      $data = DB::table('bookrep')
       ->where('bookrep_id','=', $file_id)
       ->get();

       foreach ($data as $item) {   
            DB::table('bookrep')
                ->where('bookrep_id','=', $file_id)
                ->update(['bookrep_file1' => null]);
                // dd($item->bookrep_file1);
        // $filedelete = $item->bookrep_file1;
        $filedelete = $item->bookrep_id;
        // Bookrepdelete::where('bookrep_id', $item->bookrep_id)->delete();
        // DB::table('bookrep')->where('bookrep_id', $item->bookrep_id)->delete($filedelete);
                // ->delete(['bookrep_file1' == '']);
        }
        // $dell = Test::where('id', 14)->where('colB', 'like', '%dd%')->first();
        // $dell->update(['colB' => null]);    
            // $file->bookrep_file1()->delete(); 
            // $file->delete(); 
        //    $file_path = storage('bookrep_pdf/'.$file_name);
        //    $file_path = public_path('bookrep_pdf/'.$file_name);
        //    unlink($file_path);
        //    $file->delete(); 
        // dd($id);
        // $description = 'storage/bookrep_pdf/'.$del->bookrep_file1;
        //         if (File::exists($description))
        //         {
        //             File::delete($description);
        //         }
        // $del->bookrep_file1->delete();
        //    $del->delete(); 
        // return response()->json(['status' => '200','success' => 'Delete Success']);
        return redirect()->back();
    }
    public function bookrep_file2_destroy(Request $request,$id)
    {
       $file = Bookrep::find($id);  
       $file_name = $file->bookrep_file2;
       $file_id = $file->bookrep_id;
       $filepath = public_path('storage/bookrep_pdf/'.$file_name);
       $description = File::delete($filepath);
      $data = DB::table('bookrep')
       ->where('bookrep_id','=', $file_id)
       ->get();
       foreach ($data as $item) {   
            DB::table('bookrep')
                ->where('bookrep_id','=', $file_id)
                ->update(['bookrep_file2' => null]);
        $filedelete = $item->bookrep_id;
    }   
        return redirect()->back();
    }
    public function bookrep_file3_destroy(Request $request,$id)
    {
       $file = Bookrep::find($id);  
       $file_name = $file->bookrep_file3;
       $file_id = $file->bookrep_id;
       $filepath = public_path('storage/bookrep_pdf/'.$file_name);
       $description = File::delete($filepath);
      $data = DB::table('bookrep')
       ->where('bookrep_id','=', $file_id)
       ->get();
       foreach ($data as $item) {   
            DB::table('bookrep')
                ->where('bookrep_id','=', $file_id)
                ->update(['bookrep_file3' => null]);
        $filedelete = $item->bookrep_id;
    }   
        return redirect()->back();
    }
    public function bookrep_file4_destroy(Request $request,$id)
    {
       $file = Bookrep::find($id);  
       $file_name = $file->bookrep_file4;
       $file_id = $file->bookrep_id;
       $filepath = public_path('storage/bookrep_pdf/'.$file_name);
       $description = File::delete($filepath);
      $data = DB::table('bookrep')
       ->where('bookrep_id','=', $file_id)
       ->get();
       foreach ($data as $item) {   
            DB::table('bookrep')
                ->where('bookrep_id','=', $file_id)
                ->update(['bookrep_file4' => null]);
        $filedelete = $item->bookrep_id;
    }   
        return redirect()->back();
    }
    public function bookrep_file5_destroy(Request $request,$id)
    {
       $file = Bookrep::find($id);  
       $file_name = $file->bookrep_file5;
       $file_id = $file->bookrep_id;
       $filepath = public_path('storage/bookrep_pdf/'.$file_name);
       $description = File::delete($filepath);
      $data = DB::table('bookrep')
       ->where('bookrep_id','=', $file_id)
       ->get();
       foreach ($data as $item) {   
            DB::table('bookrep')
                ->where('bookrep_id','=', $file_id)
                ->update(['bookrep_file5' => null]);
        $filedelete = $item->bookrep_id;
    }   
        return redirect()->back();
    }
    

    // ************** Download PDF *******************
    public function createPDF() {
        // retreive all records from db
        $data = Employee::all();
        // share data to view
        view()->share('employee',$data);
        $pdf = PDF::loadView('pdf_view', $data);
        // download PDF file with download method
        return $pdf->download('pdf_file.pdf');
      }

    // public function generatepdf(){
    //     $data = User::all();

    //     $pdf = PDF::loadView('pages.user', [ 'data' => $data]);

    //     return $pdf->download('latihanpdf.pdf');
    // }





}