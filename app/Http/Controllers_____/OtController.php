<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\support\Facades\Hash;
use Illuminate\support\Facades\Validator;
use App\Models\User;
use App\Models\Ot_one;
use PDF;
use setasign\Fpdi\Fpdi;
use App\Models\Budget_year;
use Illuminate\Support\Facades\File;
use DataTables;
use Intervention\Image\ImageManagerStatic as Image;
// use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\OtExport;
// use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Department;
use App\Models\Departmentsub;
use App\Models\Departmentsubsub;
use App\Models\Position;
use App\Models\Product_spyprice;
use App\Models\Products;
use App\Models\Products_type;
use App\Models\Product_group;
use App\Models\Product_unit;
use App\Models\Products_category;
use App\Models\Article;
use App\Models\Product_prop;
use App\Models\Product_decline;
use App\Models\Department_sub_sub;
use App\Models\Products_vendor;
use App\Models\Status; 
use App\Models\Products_request;
use App\Models\Products_request_sub;   
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
use App\Models\Land;
use App\Models\Building;
use App\Models\Product_budget;
use App\Models\Product_method;
use App\Models\Product_buy;
use App\Models\Users_prefix;
use App\Models\Users_kind_type;
use App\Models\Users_group;
use Auth;

class OtController extends Controller
{
    public function otone(Request $request)
    {
        $datestart = $request->startdate;
        $dateend = $request->enddate;
        $iddep =  Auth::user()->dep_subsubtrueid;
        // dd($iddep);
        $reqsend = $request->ot_type_pk;

        $data['ot_one'] = DB::table('ot_one')
        ->leftjoin('users','users.id','=','ot_one.ot_one_nameid')
        ->leftjoin('users_prefix','users_prefix.prefix_code','=','users.pname')
        ->leftjoin('department_sub_sub','department_sub_sub.DEPARTMENT_SUB_SUB_ID','=','ot_one.dep_subsubtrueid')
        ->where('ot_one.dep_subsubtrueid','=',$iddep)
        ->where('users.users_group_id','=',$reqsend)
        // ->leftjoin('department_sub_sub','department_sub_sub.DEPARTMENT_SUB_SUB_ID','=','ot_one.dep_subsubtrueid')
        // ->where('ot_one_date','=',)->get();
        ->whereBetween('ot_one_date', [$datestart, $dateend])->get();

        $data['users'] = User::get();
        $data['leave_month'] = DB::table('leave_month')->get();
        $data['users_group'] = DB::table('users_group')->get();
        $data['ot_type_pk'] = DB::table('ot_type_pk')->get();

        return view('ot.otone', $data,[
            'start' => $datestart,
            'end' => $dateend,
            'reqsend' => $reqsend
        ]);
    }
    public function otonesearch(Request $request )
    {
        $datestart = $request->startdate;
        $dateend = $request->enddate;
        $iddep =  Auth::user()->dep_subsubtrueid;        
        $reqsend = $request->ot_type_pk;
        
        if ($reqsend != '') {
            if ($reqsend == 2) {             
                $data['ot_one'] = DB::connection('mysql')->select('
                    select o.ot_one_id,o.ot_one_date,o.ot_one_starttime,o.ot_one_endtime
                        ,o.ot_one_nameid,o.ot_one_fullname,o.ot_one_detail,o.ot_one_sign,o.ot_one_sign2
                        ,o.dep_subsubtrueid,de.DEPARTMENT_SUB_SUB_NAME,u.users_group_id,up.prefix_name
                        ,u.fname,u.lname

                        from ot_one o
                        left outer join users u on u.id = o.ot_one_nameid 
                        left outer join users_prefix up on up.prefix_code = u.pname  
                        left outer join department_sub_sub de on de.DEPARTMENT_SUB_SUB_ID = o.dep_subsubtrueid

                        where o.dep_subsubtrueid = "'.$iddep.'" 
                        AND u.users_group_id in("5","6","7")
                        AND o.ot_one_date between "'.$datestart.'" AND "'.$dateend.'"          
                ');
            }else if($reqsend == 1) {
                $data['ot_one'] = DB::connection('mysql')->select('
                select o.ot_one_id,o.ot_one_date,o.ot_one_starttime,o.ot_one_endtime
                    ,o.ot_one_nameid,o.ot_one_fullname,o.ot_one_detail,o.ot_one_sign,o.ot_one_sign2
                    ,o.dep_subsubtrueid,de.DEPARTMENT_SUB_SUB_NAME,u.users_group_id,up.prefix_name
                    ,u.fname,u.lname

                    from ot_one o
                    left outer join users u on u.id = o.ot_one_nameid 
                    left outer join users_prefix up on up.prefix_code = u.pname  
                    left outer join department_sub_sub de on de.DEPARTMENT_SUB_SUB_ID = o.dep_subsubtrueid

                    where o.dep_subsubtrueid = "'.$iddep.'" 
                    AND u.users_group_id in("1","2","3","4")
                    AND o.ot_one_date between "'.$datestart.'" AND "'.$dateend.'"          
            ');
            } else {                
            } 
        } else {    
            $reqsend == '';
        }
 
        $data['users'] = User::get();
        $data['leave_month'] = DB::table('leave_month')->get();
        $data['users_group'] = DB::table('users_group')->get();
        $data['ot_type_pk'] = DB::table('ot_type_pk')->get();
        $dateshow = date('Y-m-d');
        $strYear = date("Y", strtotime($dateshow)) + 543;
        $strM = date('m', strtotime($dateshow));
        $strD = date('d', strtotime($dateshow));
        // dd($strD);
        return view('ot.otone', $data,[
            'start' => $datestart,
            'end' => $dateend,
            'reqsend' => $reqsend
        ]);
    }

    public function otone_add(Request $request)
    {
        $iddep =  Auth::user()->dep_subsubtrueid;

        $event = array();
        $otservicess = DB::table('ot_one')
        ->leftjoin('users','users.id','=','ot_one.ot_one_nameid')
        ->leftjoin('department_sub_sub','department_sub_sub.DEPARTMENT_SUB_SUB_ID','=','users.dep_subsubtrueid')
        ->where('users.dep_subsubtrueid','=',$iddep)
        ->get();
        $tableuser = DB::table('users')->get();
        $iduser = Auth::user()->id;
        // $coloruser =  Auth::user()->color_ot;


        foreach ($otservicess as $item) {            
            // $dateend = $item->car_service_length_backdate;
            // $NewendDate = date ("Y-m-d", strtotime("1 day", strtotime($dateend)));
            $dateend = $item->ot_one_date;
            // $NewendDate = date ("Y-m-d", strtotime("1 day", strtotime($dateend)));
            // $NewendDate = date("Y-m-d", strtotime($dateend) - 1);  //ลบออก 1 วัน  เพื่อโชว์ปฎิทิน

            // $datestart=date('H:m');
            $timestart = $item->ot_one_starttime;
            $timeend = $item->ot_one_endtime;

            $starttime = substr($timestart, 0, 5);
            $endtime = substr($timeend, 0, 5);
            $showtitle = $item->ot_one_fullname. ' => ' . $starttime . '-' . $endtime;
            
            // if ($item->ot_one_nameid == $iduser) {
                $color = $item->color_ot;
            // }
            // foreach($tableuser as $item2){
                // $ius = DB::table('users')->where('id' == $item2->id)->first();
                // $item2->id == $ius;
            //     // $color = $coloruser;
            //     if ($item->ot_one_nameid == $item2->id) {
            //         // $color = item2->color_ot;
            //         $color = $coloruser; 
            //     } else {
                    // $color = '#C65705'; 
                    // $idu = item2->color_ot;

                    // dd(item2->id);
                // }
                
                // dd($item->ot_one_nameid);
                // dd($idu);
               
            // }
            // $coloruser =  $item->color_ot;
            
            // if ($item->ot_one_nameid == 754) {
            //     $color = '#F5770D';
            // }elseif($item->ot_one_nameid == 753){
            //     $color = '#C65705'; 
            // }elseif($item->ot_one_nameid == 98){
            //     $color = '#9DC605'; 
            // }elseif($item->ot_one_nameid == 581){
            //     $color = '#FD3BC5'; 
            // }elseif($item->ot_one_nameid == 102){
            //     $color = '#F90A2E'; 
            // }elseif($item->ot_one_nameid == 722){
            //     $color = '#0DF5F5'; 
            // }elseif($item->ot_one_nameid == 102){
            //     $color = '#FF50BF';   
            // }elseif($item->ot_one_nameid == 658){
            //     $color = '#0BC0A7';   
            // }elseif($item->ot_one_nameid == 155){
            //     $color = '#71FF4F';             
            // } else {
            //     $color = '#EEA509'; 
            //     }
            // foreach($tableuser as $item2){
            //     $color = item2->color_ot;
            // } 

            $event[] = [
                'id' => $item->ot_one_id,
                'title' => $showtitle, 
                'start' => $dateend,
                'end' => $dateend,
                'color' => $color
            ];
        }
        


        return view('ot.otone_add',[
            'events'     =>  $event,
        ]);
    }
    public function otone_save (Request $request)
    {
        $datebigin = $request->start_date;
        $dateend = $request->end_date;
        $iduser = $request->user_id;
        $starttime = $request->ot_one_starttime;
        $endtime = $request->ot_one_endtime;

        $checkdate = Ot_one::where('ot_one_date','=',$datebigin)->where('ot_one_nameid','=',$iduser)->count();

        if ($checkdate > 0) {
            return response()->json([
                'status'     => '100',
            ]);
        } else {
            $add = new Ot_one();
            $add->ot_one_date = $datebigin;
            $add->ot_one_starttime = $starttime;
            $add->ot_one_endtime = $endtime;
            $add->ot_one_detail = $request->input('ot_one_detail');

            $start = strtotime($starttime);
            $end = strtotime($endtime);
            $tot = ($end - $start) / 3600; 
            $add->ot_one_total = $tot;

            
            if ($iduser != '') {
                $usersave = DB::table('users')->where('id', '=', $iduser)->first(); 
                $add->ot_one_nameid = $usersave->id;
                $add->ot_one_fullname = $usersave->pnamelong . ' '.$usersave->fname . '  ' . $usersave->lname;
                $add->dep_subsubtrueid = $usersave->dep_subsubtrueid;
            } else {
                $add->ot_one_nameid = ''; 
                $add->ot_one_fullname = '';
                $add->dep_subsubtrueid = '';
            }

            $add->save();
            return response()->json([
                'status'     => '200',
            ]);
        }  
    }
    public function otone_edit(Request $request, $id)
    {
        $ot = Ot_one::find($id);

        return response()->json([
            'status'     => '200',
            'ot'      =>  $ot,
        ]);
    }
    public function otone_add_color(Request $request, $id)
    {
        $users_color = User::find($id);

        return response()->json([
            'status'     => '200',
            'users_color'      =>  $users_color,
        ]);
    }
    public function otone_updatecolor(Request $request)
    {
        $id = $request->user_id;
        $colorot = $request->color_ot;

        $update = User::find($id); 
        $update->color_ot = $colorot;
        $update->save();

        return response()->json([
            'status'     => '200' 
        ]);
    }

    public function otone_update (Request $request)
    {
        $datebigin = $request->ot_one_date;
        // $dateend = $request->end_date;
        $iduser = $request->user_id;
        $id = $request->ot_one_id;
        $starttime = $request->ot_one_starttime;
        $endtime = $request->ot_one_endtime;

        // $checkdate = Ot_one::where('ot_one_date','=',$datebigin)->where('ot_one_nameid','=',$iduser)->count();

        // if ($checkdate > 0) {
        //     return response()->json([
        //         'status'     => '100',
        //     ]);
        // } else {
            $update = Ot_one::find($id);
            $update->ot_one_date = $datebigin;
            $update->ot_one_starttime = $starttime;
            $update->ot_one_endtime = $endtime;
            $update->ot_one_detail = $request->input('ot_one_detail');

            $start = strtotime($starttime);
            $end = strtotime($endtime);
            $tot = ($end - $start) / 3600; 
            $update->ot_one_total = $tot;

            
            if ($iduser != '') {
                $usersave = DB::table('users')->where('id', '=', $iduser)->first(); 
                $update->ot_one_nameid = $usersave->id;
                $update->ot_one_fullname = $usersave->pnamelong . ' '.$usersave->fname . '  ' . $usersave->lname;
                $update->dep_subsubtrueid = $usersave->dep_subsubtrueid;
            } else {
                $update->ot_one_nameid = ''; 
                $update->ot_one_fullname = '';
                $update->dep_subsubtrueid = '';
            }

            $update->save();
            return response()->json([
                'status'     => '200',
            ]);
        // }  
    }

    public function otone_destroy(Request $request, $id)
    {
        $del = Ot_one::find($id);
        $del->delete();
        return response()->json(['status' => '200']);
    }

    public function otone_print(Request $request)
    {
        // $dataedit = Article::where('article_id', '=', $id)->first();
        // $carservicess = Car_service::all();
        $data['ot_one'] = DB::table('ot_one')->get();
        $data['users'] = User::get();
        $data['leave_month'] = DB::table('leave_month')->get();

        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        $pdf = PDF::loadView('ot.otone_print');
        Pdf::setOption(['dpi' => 150, 'defaultFont' => 'sans-serif']);
        return @$pdf->stream();
        // Pdf::loadHTML($html)->setPaper('a4', 'landscape');
        // ->setWarnings(false)->save('myfile.pdf');

        // $pdf = Pdf::loadView('ot.otone_print', $data);
        // return @$pdf->stream();
        // return $pdf->download('invoice.pdf');
    }
    public function export() 
    {
        return Excel::download(new OtExport, 'ot.xlsx');
    }
    public function ottwo(Request $request)
    {
        $data['com_tec'] = DB::table('com_tec')->get();
        $data['users'] = User::get();

        return view('ot.ottwo', $data);
    }

    public function profile_edit(Request $request,$id)
{   
    $data['q'] = $request->query('q');
    $query = User::select('users.*')
    // ->leftjoin('store_manager','store_manager.store_id','=','users.store_id')
    ->where(function ($query) use ($data){
        $query->where('pname','like','%'.$data['q'].'%');
        $query->orwhere('fname','like','%'.$data['q'].'%');
        $query->orwhere('lname','like','%'.$data['q'].'%');
        $query->orwhere('tel','like','%'.$data['q'].'%');
        $query->orwhere('username','like','%'.$data['q'].'%');
    });
    $data['users'] = $query->orderBy('id','DESC')->get();
    $data['department'] = Department::get();
    $data['department_sub'] = Departmentsub::get();
    $data['department_sub_sub'] = Departmentsubsub::get();
    $data['position'] = Position::get();
    $data['status'] = Status::get();
    $data['users_prefix'] = Users_prefix::get();
    $data['users_kind_type'] = Users_kind_type::get();
    $data['users_group'] = Users_group::get();

    $dataedit = User::where('id','=',$id)->first();

    return view('ot.profile_edit',$data,[
        'dataedits'=>$dataedit
    ]);
}
    public function profile_update(Request $request)
    {
        $date =  date('Y');
        $maxid = User::max('id');
        $idfile = $maxid+1;
    
        $idper = $request->input('id');
        $usernameup = $request->input('username');
        $count_check = User::where('username','=',$usernameup)->count(); 
             
                $update = User::find($idper);
                $update->fname = $request->fname;
                $update->lname = $request->lname;     
                $update->pname = $request->pname; 
                $update->cid = $request->cid;   
                $update->username = $usernameup; 
                $update->money = $request->money;
                $update->line_token = $request->line_token;
    
                $pass = $request->password;
                // $add->password = '$2y$10$Frngcw.RMaJh7otvZNygt.UNfQRnwqvcwlrt2x0Gc.kVC1JETj1sq';    
                $update->password = Hash::make($pass);
                // $update->member_id =  'MEM'. $date .'-'.$idfile;
    
                $depid = $request->dep_id; 
                $iddep = DB::table('department')->where('DEPARTMENT_ID','=',$depid)->first();
                $update->dep_id = $iddep->DEPARTMENT_ID; 
                $update->dep_name = $iddep->DEPARTMENT_NAME; 
    
                $depsubid = $request->dep_subid; 
                $iddepsub = DB::table('department_sub')->where('DEPARTMENT_SUB_ID','=',$depsubid)->first();
                $update->dep_subid = $iddepsub->DEPARTMENT_SUB_ID; 
                $update->dep_subname = $iddepsub->DEPARTMENT_SUB_NAME; 
    
                $depsubsubid = $request->dep_subsubid; 
                $iddepsubsub = DB::table('department_sub_sub')->where('DEPARTMENT_SUB_SUB_ID','=',$depsubsubid)->first();
                $update->dep_subsubid = $iddepsubsub->DEPARTMENT_SUB_SUB_ID;
                $update->dep_subsubname = $iddepsubsub->DEPARTMENT_SUB_SUB_NAME;    
    
                $depsubsubtrueid = $request->dep_subsubtrueid; 
                $iddepsubsubtrue = DB::table('department_sub_sub')->where('DEPARTMENT_SUB_SUB_ID','=',$depsubsubtrueid)->first();
                $update->dep_subsubtrueid = $iddepsubsubtrue->DEPARTMENT_SUB_SUB_ID; 
                $update->dep_subsubtruename = $iddepsubsubtrue->DEPARTMENT_SUB_SUB_NAME; 
    
                $posid = $request->position_id; 
                $idpos = DB::table('position')->where('POSITION_ID','=',$posid)->first();
                $update->position_id = $idpos->POSITION_ID;
                $update->position_name = $idpos->POSITION_NAME; 
    
                $typid = $request->users_type_id; 
                $typ = DB::table('users_kind_type')->where('users_kind_type_id','=',$typid)->first();
                $update->users_type_id = $typ->users_kind_type_id;
                $update->users_type_name = $typ->users_kind_type_name;
    
                $groupid = $request->users_group_id; 
                $idgroup = DB::table('users_group')->where('users_group_id','=',$groupid)->first();
                $update->users_group_id = $idgroup->users_group_id;
                $update->users_group_name = $idgroup->users_group_name;
    
                $update->start_date = $request->start_date;
                $update->end_date = $request->end_date;
                $update->status = $request->status;
    
                if ($request->hasfile('img')) {
                    $description = 'storage/person/'.$update->img;
                    if (File::exists($description))
                    {
                        File::delete($description);
                    }
                    $file = $request->file('img');
                    $extention = $file->getClientOriginalExtension();
                    $filename = time().'.'.$extention; 
                    $request->img->storeAs('person',$filename,'public'); 
                    $update->img = $filename;
                    $update->img_name = $filename;
                }
                $update->save();
    
                return response()->json([
                    'status'     => '200'
                ]);
          
      
        
    }
}
