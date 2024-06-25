<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\support\Facades\Hash;
use Illuminate\support\Facades\Validator;
use App\Models\User;
use App\Models\Department;
use App\Models\Departmentsub;
use App\Models\Departmentsubsub;
use App\Models\Products_vendor;
use App\Models\Status;
use App\Models\Position;
use App\Models\Book_read;
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
use App\Models\Car_status;
use App\Models\Car_index;
use App\Models\Article_status;
use App\Models\Car_type;
use App\Models\Product_brand;
use App\Models\Product_color;
use App\Models\Department_sub_sub;
use App\Models\Article;
use DataTables;
use PDF;
use Auth;

class UserbookController extends Controller
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
public function book_inside(Request $request)
{   
    $iddeb_ss = Auth::user()->dep_subsubtrueid;
    $date = date('Y-m-d');
    $y = date('Y') + 543;
    $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์  
    $newDate = date('Y-m-d', strtotime($date . ' -1 months')); //ย้อนหลัง 1 เดือน 
    $data['q'] = $request->query('q');
    $query = User::select('users.*')
    ->where(function ($query) use ($data){
        $query->where('pname','like','%'.$data['q'].'%');
        $query->orwhere('fname','like','%'.$data['q'].'%');
        $query->orwhere('lname','like','%'.$data['q'].'%');
        $query->orwhere('tel','like','%'.$data['q'].'%');
        $query->orwhere('username','like','%'.$data['q'].'%');
    });
    $data['users'] = $query->orderBy('id','DESC')->paginate(10);
    $data['department'] = Department::get();
    $data['department_sub'] = Departmentsub::get();
    $data['department_sub_sub'] = Departmentsubsub::get();
    $data['position'] = Position::get();
    $data['status'] = Status::get();
    // $data['bookrep'] = DB::table('bookrep')->where('bookrep_save_date','=',$newDate)->orderBy('bookrep_id','DESC')->get();
    // dd($newDate);
    
    $data['bookrep'] = DB::connection('mysql')->select('   
        SELECT * from bookrep b
        LEFT JOIN book_senddep_subsub bss on bss.bookrep_id = b.bookrep_id
        LEFT JOIN users u on u.dep_subsubtrueid = bss.senddep_depsubsub_id
        WHERE bookrep_save_date BETWEEN "'.$newDate .'" AND "'.$date .'" 
        AND u.dep_subsubtrueid= "'.$iddeb_ss.'"
        group by u.dep_subsubtrueid
        order by b.bookrep_id desc;
    ');
    return view('user_book.book_inside',$data);
}

public function book_send(Request $request)
{   
    $data['q'] = $request->query('q');
    $query = User::select('users.*')
    ->where(function ($query) use ($data){
        $query->where('pname','like','%'.$data['q'].'%');
        $query->orwhere('fname','like','%'.$data['q'].'%');
        $query->orwhere('lname','like','%'.$data['q'].'%');
        $query->orwhere('tel','like','%'.$data['q'].'%');
        $query->orwhere('username','like','%'.$data['q'].'%');
    });
    $data['users'] = $query->orderBy('id','DESC')->paginate(10);
    
    return view('user_book.book_send',$data);
}

public function book_advertise(Request $request)
{   
    $data['q'] = $request->query('q');
    $query = User::select('users.*')
    ->where(function ($query) use ($data){
        $query->where('pname','like','%'.$data['q'].'%');
        $query->orwhere('fname','like','%'.$data['q'].'%');
        $query->orwhere('lname','like','%'.$data['q'].'%');
        $query->orwhere('tel','like','%'.$data['q'].'%');
        $query->orwhere('username','like','%'.$data['q'].'%');
    });
    $data['users'] = $query->orderBy('id','DESC')->paginate(10);
    
    return view('user_book.book_advertise',$data);
}


public function user_bookdetail(Request $request,$id)
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

    $dataBook_read = DB::table('book_read')->where('bookrep_id','=',$id)->get();
    foreach ($dataBook_read as $key => $value) {
        $date = date('Y-m-d');
        $time = date('H:m:s');
        $check = Book_read::where('book_read_useropen_id','=', $userid)->where('status_book_read','=','CLOSE')->count();
        if ( $check>0) {
            Book_read::where('bookrep_id','=',$value->bookrep_id)->where('book_read_useropen_id', $userid) 
            ->update([  
                'status_book_read' => 'OPEN' ,
                'book_read_open_date'   => $date,
                'book_read_open_time'   => $time 
            ]);  
           
        }
        
       
    }
    

    return view('user_book.user_bookdetail',[
        'dataedits' =>$dataedit,
        'bookcount'=>$bookcount,
        'adcount'=>$adcount,
       ]);
}
public function user_book_send_file(Request $request,$id)
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

    return view('user_book.user_book_send_file',[
        'dataedits' =>$dataedit,
        'bookcount'=>$bookcount,
        'adcount'=>$adcount,
       ]);
}
public function user_book_send_deb(Request $request,$id)
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

    return view('user_book.user_book_send_deb',$data,[
        'dataedits' =>$dataedit,
        'bookcount'=>$bookcount,
        'adcount'=>$adcount,
       ]);
}
public function user_book_send_debsub(Request $request,$id)
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

    return view('user_book.user_book_send_debsub',$data,[
        'dataedits' =>$dataedit,
        'bookcount'=>$bookcount,
        'adcount'=>$adcount,
       ]);
}
public function user_book_send_debsubsub(Request $request,$id)
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

    return view('user_book.user_book_send_debsubsub',$data,[
        'dataedits' =>$dataedit,
        'bookcount'=>$bookcount,
        'adcount'=>$adcount,
       ]);
}

public function user_book_send_person(Request $request,$id)
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
     
        return view('user_book.user_book_send_person',$data,[
            'dataedits'=>$dataedit,            
            'bookcount'=>$bookcount,
            'adcount'=>$adcount,
        ]);
         
    }

public function user_book_send_team(Request $request,$id)
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
     
        return view('user_book.user_book_send_team',$data,[
            'dataedits'=>$dataedit,            
            'bookcount'=>$bookcount,
            'adcount'=>$adcount,
        ]);
         
    }

public function user_book_send_fileplus(Request $request,$id)
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
     
        return view('user_book.user_book_send_fileplus',$data,[
            'dataedits'=>$dataedit,            
            'bookcount'=>$bookcount,
            'adcount'=>$adcount,
        ]);
        // ->with('message','active');
    }

public function user_book_send_fileopen(Request $request,$id)
    {    
        // $data['bookrep'] = DB::table('bookrep')->get();
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์  
        $newDate = date('Y-m-d', strtotime($date . ' -1 months')); //ย้อนหลัง 1 เดือน 

        $dataedit = Bookrep::leftJoin('book_import_fam','bookrep.bookrep_import_fam','=','book_import_fam.import_fam_id')->where('bookrep_id','=',$id)->first(); 
        $userid = Auth::user()->id;
        $iddeb_ss = Auth::user()->dep_subsubtrueid;
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

        $data['book_read'] = DB::connection('mysql')->select('   
            SELECT * from book_read bss
            LEFT JOIN users u on u.id = bss.book_read_useropen_id
            LEFT JOIN users_prefix up on up.prefix_code = u.pname
            WHERE bss.bookrep_id= "'.$id.'" 
            
            AND bss.status_book_read="OPEN";
        ');
        // AND bss.book_read_useropen_id="'.$userid.'" 
    //     $data['book_read'] = DB::connection('mysql')->select('   
    //     SELECT * from bookrep b
    //     LEFT JOIN book_senddep_subsub bss on bss.bookrep_id = b.bookrep_id
    //     LEFT JOIN users u on u.dep_subsubtrueid = bss.senddep_depsubsub_id
    //     WHERE bookrep_save_date BETWEEN "'.$newDate .'" AND "'.$date .'" 
    //     AND u.bookrep_id= "'.$id.'"
    //     group by u.dep_subsubtrueid
    //     order by b.bookrep_id desc;
    // ');
        // where('bookrep_id','=',$value->bookrep_id)->where('book_read_useropen_id', $userid) 
     
        return view('user_book.user_book_send_fileopen',$data,[
            'dataedits'=>$dataedit,            
            'bookcount'=>$bookcount,
            'adcount'=>$adcount,
        ]);
        // ->with('message','active');
    }

}