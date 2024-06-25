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
use DataTables;
use PDF;
use Auth;

class HnController extends Controller
{  
    public static function refnumber()
{
    $year = date('Y');
    $maxnumber = DB::table('products_request')->max('request_id');  
    if($maxnumber != '' ||  $maxnumber != null){
        $refmax = DB::table('products_request')->where('request_id','=',$maxnumber)->first();  
        if($refmax->request_code != '' ||  $refmax->request_code != null){
        $maxref = substr($refmax->request_code, -5)+1;
        }else{
        $maxref = 1;
        }
        $ref = str_pad($maxref, 6, "0", STR_PAD_LEFT);
    }else{
        $ref = '000001';
    }
    $ye = date('Y')+543;
    $y = substr($ye, -2);
    $refnumber = 'REP'.'-'.$ref;
    return $refnumber;
} 
public function hn_dashboard(Request $request,$iduser)
{   
    $data['status'] = Status::paginate(15);
    return view('hn.hn_dashboard',$data);
}
public function hn_bookindex(Request $request,$iduser)
{  
        // $iduser = Auth::user()->id;
        // $dataedit = Bookrep::leftJoin('book_import_fam','bookrep.bookrep_import_fam','=','book_import_fam.import_fam_id')
        // ->leftJoin('book_send_person','bookrep.bookrep_id','=','book_send_person.bookrep_id')
        // ->where('sendperson_user_id','=',$iduser)->get(); 
        
        // $data['department'] = Department::leftJoin('users','department.LEADER_ID','=','users.id')->orderBy('DEPARTMENT_ID','DESC')->get();  
        // $data['users'] = User::get();
        // $data['book_objective'] = DB::table('book_objective')->get();
        // $data['bookrep'] = DB::table('bookrep')
        // ->leftJoin('book_send_person','bookrep.bookrep_id','=','book_send_person.bookrep_id')
        // ->where('sendperson_user_id','=',$iduser)
        // ->get();
        // $data['status'] = Status::paginate(15);

        $data['users'] = User::get();
        $data['book_objective'] = DB::table('book_objective')->get();
        $data['bookrep'] = DB::table('bookrep') 
        // ->where('bookrep_send_code','=','retire') 
        // ->orwhere('bookrep_send_code','=','waitallows')
        ->get();

        $data['status'] = Status::get();
    return view('hn.hn_bookindex',$data);
}

public function hn_bookdetail(Request $request,$id)
{   
    $bookcount = Bookrep::where('bookrep_id','=',$id)->where('bookrep_send_code','!=','waitsend')->count(); 
    $adcount =  Bookrep::where('bookrep_id','=',$id)->where('bookrep_send_code','=','allows')->count(); 
    // $dataedit = DB::table('bookrep')->where('bookrep_id','=',$id)->first();
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

    return view('hn.hn_bookdetail',[
        'dataedits' =>$dataedit,
        'bookcount'=>$bookcount,
        'adcount'=>$adcount,
       ]);
}
public function hn_book_send_file(Request $request,$id)
{   
    $bookcount = Bookrep::where('bookrep_id','=',$id)->where('bookrep_send_code','!=','waitsend')->count(); 
    $adcount =  Bookrep::where('bookrep_id','=',$id)->where('bookrep_send_code','=','allows')->count(); 
    // $dataedit = DB::table('bookrep')->where('bookrep_id','=',$id)->first();
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

    return view('hn.hn_book_send_file',[
        'dataedits' =>$dataedit,
        'bookcount'=>$bookcount,
        'adcount'=>$adcount,
       ]);
}
public function hn_book_send_deb(Request $request,$id)
{   
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

    $adcount =  Bookrep::where('bookrep_id','=',$id)->where('bookrep_send_code','=','allows')->count(); 

    return view('hn.hn_book_send_deb',$data,[
        'dataedits' =>$dataedit,
        'bookcount'=>$bookcount,
        'adcount'=>$adcount,
       ]);
}
public function hn_book_send_debsub(Request $request,$id)
{   
    $bookcount = Bookrep::where('bookrep_id','=',$id)->where('bookrep_send_code','!=','waitsend')->count(); 
    $adcount =  Bookrep::where('bookrep_id','=',$id)->where('bookrep_send_code','=','allows')->count(); 
    // $dataedit = DB::table('bookrep')->where('bookrep_id','=',$id)->first();
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

    return view('hn.hn_book_send_debsub',$data,[
        'dataedits' =>$dataedit,
        'bookcount'=>$bookcount,
        'adcount'=>$adcount,
       ]);
}
public function hn_book_send_debsubsub(Request $request,$id)
{   
    $bookcount = Bookrep::where('bookrep_id','=',$id)->where('bookrep_send_code','!=','waitsend')->count(); 
    $adcount =  Bookrep::where('bookrep_id','=',$id)->where('bookrep_send_code','=','allows')->count(); 
    // $dataedit = DB::table('bookrep')->where('bookrep_id','=',$id)->first();
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

    return view('hn.hn_book_send_debsubsub',$data,[
        'dataedits' =>$dataedit,
        'bookcount'=>$bookcount,
        'adcount'=>$adcount,
       ]);
}

public function hn_book_send_person(Request $request,$id)
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

        $adcount =  Bookrep::where('bookrep_id','=',$id)->where('bookrep_send_code','=','allows')->count();   
     
        return view('hn.hn_book_send_person',$data,[
            'dataedits'=>$dataedit,            
            'bookcount'=>$bookcount,
            'adcount'=>$adcount,
        ]);
         
    }

public function hn_bookindex_comment(Request $request,$id,$iduser)
    {    
        // $data['bookrep'] = DB::table('bookrep')->get();
        $dataedit = Bookrep::leftJoin('book_import_fam','bookrep.bookrep_import_fam','=','book_import_fam.import_fam_id')
        ->leftJoin('book_send_person','bookrep.bookrep_id','=','book_send_person.bookrep_id')
        ->where('bookrep.bookrep_id','=',$id)->first(); 
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

    
        $message = 'active';
        $message1 = '';
        $message2 = '';
        $message3 = '';
        $message4 = '';
        $message5 = '';
        $message6 = '';
        return view('hn.hn_bookindex_comment',$data,[
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

public function hn_book_send_team(Request $request,$id)
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

        $adcount =  Bookrep::where('bookrep_id','=',$id)->where('bookrep_send_code','=','allows')->count();   
     
        return view('hn.hn_book_send_team',$data,[
            'dataedits'=>$dataedit,            
            'bookcount'=>$bookcount,
            'adcount'=>$adcount,
        ]);
         
    }

public function hn_book_send_fileplus(Request $request,$id)
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

        $adcount =  Bookrep::where('bookrep_id','=',$id)->where('bookrep_send_code','=','allows')->count();   
     
        return view('hn.hn_book_send_fileplus',$data,[
            'dataedits'=>$dataedit,            
            'bookcount'=>$bookcount,
            'adcount'=>$adcount,
        ]);
        // ->with('message','active');
    }

public function hn_book_send_fileopen(Request $request,$id)
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

        $adcount =  Bookrep::where('bookrep_id','=',$id)->where('bookrep_send_code','=','allows')->count();   
     
        return view('hn.hn_book_send_fileopen',$data,[
            'dataedits'=>$dataedit,            
            'bookcount'=>$bookcount,
            'adcount'=>$adcount,
        ]);
        // ->with('message','active');
    }

    
public function hn_bookindex_comment_edit(Request $request,$id)
{  
    $comments = Bookrep::find($id); 
    
    return response()->json([
        'status'     => '200',
        'comments'      =>  $comments, 
        ]);
}

public function hn_bookindex_comment_update(Request $request )
{    
    $idrep = $request->input('bookrep_id');

    // $comment1 = $request->input('bookrep_comment1');

    $update = Bookrep::find($idrep);
    $update->bookrep_comment1 = $request->input('bookrep_comment1');
    $update->save();

    return response()->json([
        'status'     => '200'
        ]);
}




public function hn_leaveindex(Request $request)
{  
    $data['status'] = Status::paginate(15);
    return view('hn.hn_leaveindex',$data);
}
public function hn_trainindex(Request $request)
{  
    $data['status'] = Status::paginate(15);
    return view('hn.hn_trainindex',$data);
}


public function hn_purchaseindex(Request $request,$id)
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
   
    // $data['leave_leader_sub'] = Leave_leader_sub::where('user_id','=',$datarequesr->id)->first();
    // $headid = $datarequesr->id;
    // if ($headid != null) {
    //     $data['leave_leader_sub'] = Leave_leader_sub::where('user_id','=',$datarequesr->id)->first();
    // } else {
    //     $data['leave_leader_sub'] = Leave_leader_sub::get();
    // }
    return view('hn.hn_purchaseindex',$data,
    [
        'datashows'=>$datashow,
        'datarequesr'=>$datarequesr,
        // 'dataedits'=>$dataedit,
    ]);
}
function hn_purchaseindex_detail(Request $request)
{
    $id = $request->get('id');
    // dd($id);
    $detail = DB::table('products_request')->where('request_id','=',$id)->first();
    $detail_sub = DB::table('products_request_sub')->where('request_id','=',$detail->request_id)->first();
    $output ='  <label class="form-label" for="up_request_code">เลขที่บิล</label>
               
    ';
    echo $output;


}

function suphn_detail(Request $request)
{
    
    echo 'OK';

}



public function hn_storeindex(Request $request)
{  
    $data['status'] = Status::paginate(15);
    return view('hn.hn_storeindex',$data);
}

// public function supplies_data_add_subdestroy(Request $request,$id)
// {
//    $del = Products_request_sub::find($id); 
//    $del->delete(); 
//     return response()->json(['status' => '200','success' => 'Delete Success']);
// }

}