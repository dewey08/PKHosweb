<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
 
use Illuminate\Support\Facades\Hash;
use Illuminate\support\Facades\Validator;
use App\Models\User;
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
use Illuminate\Support\Facades\File;
use DataTables;

class PersonController extends Controller
{   
public function person_index(Request $request)
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
    $data['users'] = $query->orderBy('id','DESC')->get();
    $data['department'] = Department::get();
    $data['department_sub'] = Departmentsub::get();
    $data['department_sub_sub'] = Departmentsubsub::get();
    $data['position'] = Position::get();
    $data['status'] = Status::get();
    
    return view('person.person_index',$data);
}


// handle fetch all eamployees ajax request
        // public function person_index() {
        //     $emps = User::all();
        //     $output = '';
        //     if ($emps->count() > 0) {
        //         $output .= '<table class="table table-striped table-borderless">
        //         <thead>
        //           <tr>
        //             <th>ID</th>
        //             <th>Name</th>
        //             <th>E-mail</th>
        //             <th>Post</th>
        //             <th>Phone</th>
        //             <th>Action</th>
        //           </tr>
        //         </thead>
        //         <tbody>';
        //         foreach ($emps as $emp) {
        //             $output .= '<tr>
        //             <td>' . $emp->id . '</td>
                
        //             <td>' . $emp->fname . ' ' . $emp->lname . '</td>
        //             <td>' . $emp->email . '</td>
        //             <td>' . $emp->dep_subsubname . '</td>
        //             <td>' . $emp->position_name . '</td>
        //             <td>
        //               <a href="#" id="' . $emp->id . '" class="text-success mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#editEmployeeModal"><i class="bi-pencil-square h4"></i></a>

        //               <a href="#" id="' . $emp->id . '" class="text-danger mx-1 deleteIcon"><i class="bi-trash h4"></i></a>
        //             </td>
        //           </tr>';
        //         }
        //         $output .= '</tbody></table>';
        //         echo $output;
        //     } else {
        //         echo '<h1 class="text-center text-secondary my-5">No record present in the database!</h1>';
        //     }
// }
public function person_index_add(Request $request)
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
    $data['users'] = $query->orderBy('id','DESC')->paginate(15); 
    $data['department'] = Department::get();
    $data['department_sub'] = Departmentsub::get();
    $data['department_sub_sub'] = Departmentsubsub::get();
    $data['position'] = Position::get();
    $data['status'] = Status::get();
    $data['users_prefix'] = Users_prefix::get();
    $data['users_kind_type'] = Users_kind_type::get();
    $data['users_group'] = Users_group::get();

    return view('person.person_index_add',$data);
}

function addpre(Request $request)
{     
 if($request->prenew!= null || $request->prenew != ''){    
     $count_check = Users_prefix::where('prefix_name','=',$request->prenew)->count();  
     $maxid = Users_prefix::max('prefix_id'); 
     $code =  $maxid+1;        
        if($count_check == 0){    
                $add = new Users_prefix(); 
                $add->prefix_code = $code;
                $add->prefix_name = $request->prenew;
                $add->save(); 
        }
        }
            $query =  DB::table('users_prefix')->get();            
            $output='<option value="">--เลือก--</option>';                
            foreach ($query as $row){
                if($request->prenew == $row->prefix_name){
                    $output.= '<option value="'.$row->prefix_id.'" selected>'.$row->prefix_name.'</option>';
                }else{
                    $output.= '<option value="'.$row->prefix_id.'">'.$row->prefix_name.'</option>';
                }   
        }    
    echo $output;        
}


protected function create(array $data)
{
    return User::create([
        'fname' => $data['fname'],
        'lname' => $data['lname'],
        'username' => $data['username'],
        'tel' => $data['tel'],
        'email' => $data['email'],
        'password' => Hash::make($data['password']),
    ]);
}

public function person_save(Request $request)
{
    // return $request->all();
    $date =  date('Y');
    $maxid = User::max('id');
    $idfile = $maxid+1;

    $usernameup = $request->input('username');
    $count_check = User::where('username','=',$usernameup)->count(); 
    // dd($count_check);
    if ($count_check == 1) { 
                return response()->json([
                    'status'     => '0'
                    ]);  
    } else {
       
                $add = new User();
                $add->pname = $request->pname;
                $add->fname = $request->fname;
                $add->lname = $request->lname;
                $add->cid = $request->cid;   
                $add->username = $usernameup;

                $pass = $request->password; 
                $add->password = Hash::make($pass);
                $add->member_id =  'MEM'. $date .'-'.$idfile;

                $depid = $request->dep_id;           
                if ($depid != '') {
                    $iddep = DB::table('department')->where('DEPARTMENT_ID','=',$depid)->first();
                    $add->dep_id = $iddep->DEPARTMENT_ID; 
                    $add->dep_name = $iddep->DEPARTMENT_NAME;
                }else{
                    $add->dep_id = '';
                    $add->dep_name = '';
                }

                $depsubid = $request->dep_subid; 
                if ($depsubid != '') {
                    $iddepsub = DB::table('department_sub')->where('DEPARTMENT_SUB_ID','=',$depsubid)->first();
                    $add->dep_subid = $iddepsub->DEPARTMENT_SUB_ID; 
                    $add->dep_subname = $iddepsub->DEPARTMENT_SUB_NAME;
                }else{
                    $add->dep_subid = '';
                    $add->dep_subname = '';
                }            

                $depsubsubid = $request->dep_subsubid; 
                if ($depsubsubid != '') {
                    $iddepsubsub = DB::table('department_sub_sub')->where('DEPARTMENT_SUB_SUB_ID','=',$depsubsubid)->first();
                    $add->dep_subsubid = $iddepsubsub->DEPARTMENT_SUB_SUB_ID;
                    $add->dep_subsubname = $iddepsubsub->DEPARTMENT_SUB_SUB_NAME;
                }else{
                    $add->dep_subsubid = '';
                    $add->dep_subsubname = '';
                }

                $depsubsubtrueid = $request->dep_subsubtrueid;
                if ($depsubsubtrueid != '') {
                    $iddepsubsubtrue = DB::table('department_sub_sub')->where('DEPARTMENT_SUB_SUB_ID','=',$depsubsubtrueid)->first();
                    $add->dep_subsubtrueid = $iddepsubsubtrue->DEPARTMENT_SUB_SUB_ID; 
                    $add->dep_subsubtruename = $iddepsubsubtrue->DEPARTMENT_SUB_SUB_NAME; 
                }else{
                    $add->dep_subsubtrueid = '';
                    $add->dep_subsubtruename = '';
                } 
                
                $posid = $request->position_id; 
                if ($posid != '') {
                    $idpos = DB::table('position')->where('POSITION_ID','=',$posid)->first();
                    $add->position_id = $idpos->POSITION_ID;
                    $add->position_name = $idpos->POSITION_NAME;
                }else{
                    $add->position_id = '';
                    $add->position_name = '';
                }             

                $typid = $request->users_type_id;
                if ($typid != '') {
                    $typ = DB::table('users_kind_type')->where('users_kind_type_id','=',$typid)->first();
                    $add->users_type_id = $typ->users_kind_type_id;
                    $add->users_type_name = $typ->users_kind_type_name;
                }else{
                    $add->users_type_id = '';
                    $add->users_type_name = '';
                }  
            

                $groupid = $request->users_group_id; 
                if ($groupid != '') {
                    $idgroup = DB::table('users_group')->where('users_group_id','=',$groupid)->first();
                    $add->users_group_id = $idgroup->users_group_id;
                    $add->users_group_name = $idgroup->users_group_name;
                }else{
                    $add->users_group_id = '';
                    $add->users_group_name = '';
                }  
            
                $add->start_date = $request->start_date;
                $add->end_date = $request->end_date;
                $add->status = $request->status;

                if ($request->hasfile('img')) {
                    $file = $request->file('img');
                    $extention = $file->getClientOriginalExtension();
                    $filename = time().'.'.$extention; 
                    $request->img->storeAs('person',$filename,'public'); 
                    $add->img = $filename;
                    $add->img_name = $filename;
                }

            $add->save(); 

            return response()->json([
                'status'     => '200'
                ]);
    }
       
    
}

public function person_index_edit(Request $request,$id)
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

    return view('person.person_index_edit',$data,[
        'dataedits'=>$dataedit
    ]);
}

public function person_update(Request $request)
{
    $date =  date('Y');
    $maxid = User::max('id');
    $idfile = $maxid+1;

    $idper = $request->input('id');
    $usernameup = $request->input('username');
    $count_check = User::where('username','=',$usernameup)->count(); 
    
    // $up  = $request->input('fname');
    // dd($up);
    if ( $count_check == 1) {
            $update = User::find($idper);
            $update->fname = $request->fname;
            $update->lname = $request->lname;     
            $update->pname = $request->pname; 
            $update->cid = $request->cid;   
            $update->username = $usernameup; 

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
      
    }elseif($count_check == 1 || $username != $usernameup ){
            return response()->json([
                        'status'     => '0'
                        ]);
    } else {
                $update = User::find($idper);
                $update->fname = $request->fname;
                $update->lname = $request->lname;     
                $update->pname = $request->pname; 
                $update->cid = $request->cid;   
                $update->username = $usernameup; 

                $pass = $request->password;
                $data['password'] = $request->input('password');
                // $add->password = '$2y$10$Frngcw.RMaJh7otvZNygt.UNfQRnwqvcwlrt2x0Gc.kVC1JETj1sq';    
                $update->password = Hash::make($data['password']);
                // $update->member_id =  'MEM'. $date .'-'.$idfile;
                // 'password' => Hash::make($data['password']),

                // $depid = $request->dep_id; 
                // $iddep = DB::table('department')->where('DEPARTMENT_ID','=',$depid)->first();
                // $update->dep_id = $iddep->DEPARTMENT_ID; 
                // $update->dep_name = $iddep->DEPARTMENT_NAME; 

                // $depsubid = $request->dep_subid; 
                // $iddepsub = DB::table('department_sub')->where('DEPARTMENT_SUB_ID','=',$depsubid)->first();
                // $update->dep_subid = $iddepsub->DEPARTMENT_SUB_ID; 
                // $update->dep_subname = $iddepsub->DEPARTMENT_SUB_NAME; 

                // $depsubsubid = $request->dep_subsubid; 
                // $iddepsubsub = DB::table('department_sub_sub')->where('DEPARTMENT_SUB_SUB_ID','=',$depsubsubid)->first();
                // $update->dep_subsubid = $iddepsubsub->DEPARTMENT_SUB_SUB_ID;
                // $update->dep_subsubname = $iddepsubsub->DEPARTMENT_SUB_SUB_NAME;    

                // $depsubsubtrueid = $request->dep_subsubtrueid; 
                // $iddepsubsubtrue = DB::table('department_sub_sub')->where('DEPARTMENT_SUB_SUB_ID','=',$depsubsubtrueid)->first();
                // $update->dep_subsubtrueid = $iddepsubsubtrue->DEPARTMENT_SUB_SUB_ID; 
                // $update->dep_subsubtruename = $iddepsubsubtrue->DEPARTMENT_SUB_SUB_NAME; 

                // $posid = $request->position_id; 
                // $idpos = DB::table('position')->where('POSITION_ID','=',$posid)->first();
                // $update->position_id = $idpos->POSITION_ID;
                // $update->position_name = $idpos->POSITION_NAME; 

                // $typid = $request->users_type_id; 
                // $typ = DB::table('users_kind_type')->where('users_kind_type_id','=',$typid)->first();
                // $update->users_type_id = $typ->users_kind_type_id;
                // $update->users_type_name = $typ->users_kind_type_name;

                // $groupid = $request->users_group_id; 
                // $idgroup = DB::table('users_group')->where('users_group_id','=',$groupid)->first();
                // $update->users_group_id = $idgroup->users_group_id;
                // $update->users_group_name = $idgroup->users_group_name;

                // $update->start_date = $request->start_date;
                // $update->end_date = $request->end_date;
                // $update->status = $request->status;
 
                // if ($request->hasfile('img')) {
                //     $description = 'storage/person/'.$update->img;
                //     if (File::exists($description))
                //     {
                //         File::delete($description);
                //     }
                //     $file = $request->file('img');
                //     $extention = $file->getClientOriginalExtension();
                //     $filename = time().'.'.$extention;
                //     $request->img->storeAs('person',$filename,'public');
                //     $update->img = $filename;
                //     $update->img_name = $filename;
                // }

                $update->save();

                return response()->json([
                    'status'     => '200'
                    ]);
    }
    
}

public function person_index_edittype(Request $request,$id)
{
     $data = User::find($id);   
     return response()->json([
       'status'     => '200',
       'data'   =>  $data
       ]);
}
public function person_typeupdate(Request $request)
{    
    $id = $request->input('edittype_id');
    $data = User::find($id);
    $data->type = $request->input('type');
    $data->update();
    return response()->json([
        'statusCode'     => '200',
        'data'   =>  $data
        ]);
}

public function person_destroy(Request $request,$id)
{
   $del = User::find($id);  
   $del->delete(); 
    return response()->json(['status' => '200','success' => 'Delete Success']);
}



public function person_index_addsub(Request $request,$id)
{       
    $data['q'] = $request->query('q');
    $query = User::select('users.*');
    $data['users'] = $query->first(); 
    return view('person.person_index_addsub',$data);
}
public function member_save(Request $request)
{
    $date =  date('Y');
    $maxid = User::max('id');
    $idfile = $maxid+1;

    // dd($date);

    $add = new User();
    $add->fname = $request->fname;
    $add->lname = $request->lname;
    $add->email = $request->email; 
    $add->tel = $request->tel;   
    $add->username = $request->username;    
    $add->password = '$2y$10$Frngcw.RMaJh7otvZNygt.UNfQRnwqvcwlrt2x0Gc.kVC1JETj1sq';  
    $add->member_id =  'MEM'. $date .'-'.$idfile;
    $add->type =  $request->type; 
    $add->save();
    return redirect()->route('member.home');
}
public function member_update(Request $request)
{    
    $id = $request->id;
    $p = $request->password; 
    $update = User::find($id);
    $update->fname = $request->fname;
    $update->lname = $request->lname;
    $update->email = $request->email; 
    $update->tel = $request->tel;   
    $update->username = $request->username;   
    $update->password = $request->password;  
    if ($p != '') {
        $update->password = Hash::make($p);  
    }   
    
    $update->member_id =  $request->member_id; 
    $update->type =  $request->type; 
    $update->save();
    return redirect()->route('member.home');
}
public function member_destroy(Request $request)
{    
    $id = $request->id;
    User::where('id','=',$id)->delete(); 

    return redirect()->route('member.home');
    }

    function department(Request $request)
    {       
      $id = $request->get('select');
      $result=array();
      $query= DB::table('department')
      ->join('department_sub','department.DEPARTMENT_ID','=','department_sub.DEPARTMENT_ID')
      ->select('department_sub.DEPARTMENT_SUB_NAME','department_sub.DEPARTMENT_SUB_ID')
      ->where('department.DEPARTMENT_ID',$id)
      ->groupBy('department_sub.DEPARTMENT_SUB_NAME','department_sub.DEPARTMENT_SUB_ID')
      ->get();
      $output='<option value="">--ฝ่าย/แผนก--</option>';      
      foreach ($query as $row){
            $output.= '<option value="'.$row->DEPARTMENT_SUB_ID.'">'.$row->DEPARTMENT_SUB_NAME.'</option>';
        }
        echo $output;        
    }

    function departmenthsub(Request $request)
    {       
        $id = $request->get('select');
        $result=array();
        $query= DB::table('department_sub')
        ->join('department_sub_sub','department_sub.DEPARTMENT_SUB_ID','=','department_sub_sub.DEPARTMENT_SUB_ID')
        ->select('department_sub_sub.DEPARTMENT_SUB_SUB_NAME','department_sub_sub.DEPARTMENT_SUB_SUB_ID')
        ->where('department_sub.DEPARTMENT_SUB_ID',$id)
        ->groupBy('department_sub_sub.DEPARTMENT_SUB_SUB_NAME','department_sub_sub.DEPARTMENT_SUB_SUB_ID')
        ->get();
        $output='<option value="">--หน่วยงาน--</option>';
        
        foreach ($query as $row){
                $output.= '<option value="'.$row->DEPARTMENT_SUB_SUB_ID.'">'.$row->DEPARTMENT_SUB_SUB_NAME.'</option>';
        }
        echo $output;
        
    }

    function province_fect(Request $request)
    {           
          $id = $request->get('select');
          $result=array();
          $query= DB::table('data_province')
          ->join('data_amphur','data_province.ID','=','data_amphur.PROVINCE_ID')
          ->select('data_amphur.AMPHUR_NAME','data_amphur.ID')
          ->where('data_province.ID',$id)
          ->groupBy('data_amphur.AMPHUR_NAME','data_amphur.ID')
          ->get();
          $output='<option value="">--กรุณาเลือกอำเภอ--</option>';          
          foreach ($query as $row){    
                $output.= '<option value="'.$row->ID.'">'.$row->AMPHUR_NAME.'</option>';
            }
            echo $output;            
    }
    
    function district_fect(Request $request)
    {           
          $id = $request->get('select');
          $result=array();
          $query= DB::table('data_amphur')
          ->join('data_tumbon','data_amphur.ID','=','data_tumbon.AMPHUR_ID')
          ->select('data_tumbon.TUMBON_NAME','data_tumbon.ID')
          ->where('data_amphur.ID',$id)
          ->groupBy('data_tumbon.TUMBON_NAME','data_tumbon.ID')
          ->get();
          $output='<option value="">--กรุณาเลือกตำบล--</option>';      
          foreach ($query as $row){
                $output.= '<option value="'.$row->ID.'">'.$row->TUMBON_NAME.'</option>';
        }
        echo $output;
            
    }

}

 // function checkhrid(Request $request)
    // {      
    //   $cid= $request->get('select');
    //   $count= DB::table('hrd_person')
    //         ->where('hrd_person.HR_CID',$cid) 
    //         ->count();    
    //     $numlength = strlen((string)$cid);
    //         if($count >= 1){
    //             $output='*มีเลขประจำตัวดังกล่าวในระบบแล้ว
    //             <input type="hidden" name="checkcid" id="checkcid" value="notpass">';
    //             echo $output;
    //         }else if($numlength < 13){
    //             $output='*กรุณากรอกเลขบัตรให้ครบถ้วน
    //             <input type="hidden" name="checkcid" id="checkcid" value="notpass2">';
    //             echo $output;
    //         }   
    // }

    // function checkemail(Request $request)
    // {       
    //   $mail= $request->get('select');
    //   $count= DB::table('hrd_person')
    //         ->where('hrd_person.HR_EMAIL',$mail) 
    //         ->count();
    //         if($count== 1){
    //             $output='*มีอีเมลล์ดังกล่าวในระบบแล้ว';
    //             echo $output;
    //         }  
    //         if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
    //             $output='*กรุณาระบุอีเมล์ให้ถูกต้อง';
    //             echo $output;
    //           }           
                
    // }