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
use App\Models\Products_request;
use App\Models\Products_request_sub;
use App\Models\Products;
use App\Models\Products_type;
use App\Models\Product_group;
use App\Models\Product_unit;
use App\Models\Products_category;
use App\Models\Leave_leader;
use App\Models\Leave_leader_sub;
use App\Models\Line_token;
use App\Models\Orginfo;
use DataTables;
use Illuminate\Support\Facades\File;

class SettingController extends Controller
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
public function setting_index(Request $request)
{     
    // $data['department'] = Department::all();
    $data['department'] = Department::leftJoin('users','department.LEADER_ID','=','users.id')->orderBy('DEPARTMENT_ID','DESC')
    // ->select('users.*', 'department.DEPARTMENT_ID', 'department.DEPARTMENT_NAME', 'department.LINE_TOKEN')
    ->get();  
    $data['users'] = User::get();
    return view('setting.setting_index',$data);
}
public function setting_depsave(Request $request)
{         
        $add = new Department();
        $add->DEPARTMENT_NAME = $request->input('DEPARTMENT_NAME'); 
        $add->LINE_TOKEN = $request->input('LINE_TOKEN'); 
        
        $iduser = $request->input('LEADER_ID'); 
        if ($iduser != '') {
            $usersave = DB::table('users')->where('id','=',$iduser)->first();
            $add->LEADER_ID = $usersave->id; 
            // $add->LEADER_NAME = $usersave->fname. '  ' .$usersave->lname ; 
        } else {
            $add->LEADER_ID = ''; 
            // $add->LEADER_NAME =''; 
        }
        $add->save();    
        return response()->json([
            'status'     => '200'
    ]);
}
public function setting_index_edit(Request $request,$id)
{    
    // $data['department'] = Department::all();
    $data['department'] = Department::leftJoin('users','department.LEADER_ID','=','users.id')->orderBy('DEPARTMENT_ID','DESC')
    // ->select('users.*', 'department.DEPARTMENT_ID', 'department.DEPARTMENT_NAME', 'department.LINE_TOKEN')
    ->get();
    $data['users'] = User::get();
    $dataedit = Department::where('DEPARTMENT_ID','=',$id)->first(); 

    return view('setting.setting_index_edit',$data,[
        'dataedits'=>$dataedit
    ]);
}
public function setting_depupdate(Request $request)
{      
    $iddep = $request->DEPARTMENT_ID; 

    $update = Department::find($iddep);
    $update->DEPARTMENT_NAME = $request->input('DEPARTMENT_NAME'); 
    $update->LINE_TOKEN = $request->input('LINE_TOKEN'); 

    $iduser = $request->input('LEADER_ID'); 
    if ($iduser != '') {
        $usersave = DB::table('users')->where('id','=',$iduser)->first();
        $update->LEADER_ID = $usersave->id; 
        // $update->LEADER_NAME = $usersave->fname. '  ' .$usersave->lname ; 
    } else {
        $update->LEADER_ID = ''; 
        // $update->LEADER_NAME =''; 
    }
    
    $update->save(); 
        
    return response()->json([
        'status'     => '200'
        ]);
 
}

public function setting_index_destroy(Request $request,$id)
{
   $del = Department::find($id); 

   $del->delete(); 
    return response()->json(['status' => '200','success' => 'Delete Success']);
}

// *******************************************************

public function depsub_index(Request $request)
{     
    $data['department_sub'] = Departmentsub::leftJoin('users','department_sub.LEADER_ID','=','users.id')
    ->leftJoin('department','department_sub.DEPARTMENT_ID','=','department.DEPARTMENT_ID')
    ->select('users.*', 'department.DEPARTMENT_NAME','department_sub.DEPARTMENT_SUB_ID','department_sub.DEPARTMENT_SUB_NAME','department_sub.LINE_TOKEN')
    ->orderBy('DEPARTMENT_SUB_ID','DESC')
    ->get();  
    $data['users'] = User::get();
    $data['department'] = Department::get();
    return view('setting.depsub_index',$data);
}
public function depsub_save(Request $request)
{         
        $add = new Departmentsub();
        $add->DEPARTMENT_SUB_NAME = $request->input('DEPARTMENT_SUB_NAME');
        $add->DEPARTMENT_ID = $request->input('DEPARTMENT_ID'); 
        $add->LINE_TOKEN = $request->input('LINE_TOKEN'); 
        
        $iduser = $request->input('LEADER_ID'); 
        if ($iduser != '') {
            $usersave = DB::table('users')->where('id','=',$iduser)->first();
            $add->LEADER_ID = $usersave->id; 
            // $add->LEADER_NAME = $usersave->fname. '  ' .$usersave->lname ; 
        } else {
            $add->LEADER_ID = ''; 
            // $add->LEADER_NAME =''; 
        }

        $add->save();    
        return response()->json([
            'status'     => '200'
    ]);
}
public function depsub_edit(Request $request,$id)
{   
    $data['department_sub'] = Departmentsub::leftJoin('users','department_sub.LEADER_ID','=','users.id')
    ->leftJoin('department','department_sub.DEPARTMENT_ID','=','department.DEPARTMENT_ID')
    ->select('users.*', 'department.DEPARTMENT_NAME','department_sub.DEPARTMENT_SUB_ID','department_sub.DEPARTMENT_SUB_NAME', 'department_sub.LINE_TOKEN')
    ->orderBy('DEPARTMENT_SUB_ID','DESC')
    ->get();
    $data['users'] = User::get();
    $data['department'] = Department::get();
    $dataedit = Departmentsub::where('DEPARTMENT_SUB_ID','=',$id)->first(); 

    return view('setting.depsub_edit',$data,[
        'dataedits'=>$dataedit
    ]);
}
public function depsub_update(Request $request)
{         
        $iddepsub = $request->DEPARTMENT_SUB_ID; 

        $update = Departmentsub::find($iddepsub);
        $update->DEPARTMENT_SUB_NAME = $request->input('DEPARTMENT_SUB_NAME');
        $update->DEPARTMENT_ID = $request->input('DEPARTMENT_ID'); 
        $update->LINE_TOKEN = $request->input('LINE_TOKEN'); 
        
        $iduser = $request->input('LEADER_ID'); 
        if ($iduser != '') {
            $usersave = DB::table('users')->where('id','=',$iduser)->first();
            $update->LEADER_ID = $usersave->id; 
            // $update->LEADER_NAME = $usersave->fname. '  ' .$usersave->lname ; 
        } else {
            $update->LEADER_ID = ''; 
            // $update->LEADER_NAME =''; 
        }

        $update->save();    
        return response()->json([
            'status'     => '200'
    ]);
}
public function depsub_destroy(Request $request,$id)
{
   $del = Departmentsub::find($id); 
   $del->delete(); 
    return response()->json(['status' => '200','success' => 'Delete Success']);
}

// ************************ debsubsun ****************************

public function depsubsub_index(Request $request)
{     
    // Departmentsubsub
    // Departmentsubsub
    $data['department_sub_sub'] = Departmentsubsub::leftJoin('users','department_sub_sub.LEADER_ID','=','users.id')
    ->leftJoin('department_sub','department_sub_sub.DEPARTMENT_SUB_ID','=','department_sub.DEPARTMENT_SUB_ID')
    ->select('users.*', 'department_sub.DEPARTMENT_SUB_NAME','department_sub_sub.DEPARTMENT_SUB_SUB_ID','department_sub_sub.DEPARTMENT_SUB_SUB_NAME','department_sub_sub.LINE_TOKEN')
    ->orderBy('DEPARTMENT_SUB_SUB_ID','DESC')
    ->get();  
    $data['users'] = User::get();
    $data['department_sub'] = Departmentsub::get();
    return view('setting.depsubsub_index',$data);
}
public function depsubsub_add_color(Request $request, $id)
{
    $dss_color = Departmentsubsub::find($id);

    return response()->json([
        'status'     => '200',
        'dss_color'      =>  $dss_color,
    ]);
}
public function depsubsub_updatecolor(Request $request)
{
    $id = $request->dss_id;
    // $color = $request->dss_color;

    $update = Departmentsubsub::find($id); 
    $update->DSS_COLOR = $request->dss_color;
    $update->save();

    return response()->json([
        'status'     => '200' 
    ]);
}

public function depsubsub_save(Request $request)
{         
        $add = new Departmentsubsub();
        $add->DEPARTMENT_SUB_SUB_NAME = $request->input('DEPARTMENT_SUB_SUB_NAME');
        $add->DEPARTMENT_SUB_ID = $request->input('DEPARTMENT_SUB_ID'); 
        $add->LINE_TOKEN = $request->input('LINE_TOKEN'); 
        $add->DSS_COLOR = $request->input('DSS_COLOR'); 
        $iduser = $request->input('LEADER_ID'); 
        if ($iduser != '') {
            $usersave = DB::table('users')->where('id','=',$iduser)->first();
            $add->LEADER_ID = $usersave->id; 
            // $add->LEADER_NAME = $usersave->fname. '  ' .$usersave->lname ; 
        } else {
            $add->LEADER_ID = ''; 
            // $add->LEADER_NAME =''; 
        }

        $add->save();    
        return response()->json([
            'status'     => '200'
    ]);
}
public function depsubsub_edit(Request $request,$id)
{   
    $data['department_sub_sub'] = Departmentsubsub::leftJoin('users','department_sub_sub.LEADER_ID','=','users.id')
    ->leftJoin('department_sub','department_sub_sub.DEPARTMENT_SUB_ID','=','department_sub.DEPARTMENT_SUB_ID')
    ->select('users.*', 'department_sub.DEPARTMENT_SUB_NAME','department_sub_sub.DEPARTMENT_SUB_SUB_ID','department_sub_sub.DEPARTMENT_SUB_SUB_NAME','department_sub_sub.LINE_TOKEN')
    ->orderBy('DEPARTMENT_SUB_SUB_ID','DESC')
    ->get();
    $data['users'] = User::get();
    $data['department_sub'] = Departmentsub::get();
    $dataedit = Departmentsubsub::where('DEPARTMENT_SUB_SUB_ID','=',$id)->first(); 

    return view('setting.depsubsub_edit',$data,[
        'dataedits'=>$dataedit
    ]);
}
public function depsubsub_update(Request $request)
{         
        $iddepsubsub = $request->DEPARTMENT_SUB_SUB_ID; 
        $update = Departmentsubsub::find($iddepsubsub);
        $update->DEPARTMENT_SUB_SUB_NAME = $request->input('DEPARTMENT_SUB_SUB_NAME');
        $update->DEPARTMENT_SUB_ID = $request->input('DEPARTMENT_SUB_ID'); 
        $update->LINE_TOKEN = $request->input('LINE_TOKEN'); 
        $update->DSS_COLOR = $request->input('DSS_COLOR'); 
        
        
        $iduser = $request->input('LEADER_ID'); 
        if ($iduser != '') {
            $usersave = DB::table('users')->where('id','=',$iduser)->first();
            $update->LEADER_ID = $usersave->id; 
            // $update->LEADER_NAME = $usersave->fname. '  ' .$usersave->lname ; 
        } else {
            $update->LEADER_ID = ''; 
            // $update->LEADER_NAME =''; 
        }
        $update->save();    
        return response()->json([
            'status'     => '200'
    ]);
}

public function depsubsub_destroy(Request $request,$id)
{
   $del = Departmentsubsub::find($id); 
   $del->delete(); 
    return response()->json(['status' => '200','success' => 'Delete Success']);
}

public function leader(Request $request)
{  
    $data['leave_leader'] = Leave_leader::get();
    $data['leave_leader_sub'] = Leave_leader_sub::get();
    $data['users'] = User::get();
    return view('setting.leader',$data);
}
public function leader_save(Request $request)
{         
        $add = new Leave_leader();
              
        $iduser = $request->input('LEADER_ID'); 
        if ($iduser != '') {
            $usersave = DB::table('users')->where('id','=',$iduser)->first();
            $add->leader_id = $usersave->id; 
            $add->leader_name = $usersave->fname. '  ' .$usersave->lname ; 
        } else {
            $add->leader_id = ''; 
            $add->leader_name =''; 
        }

        $add->save();    
        return response()->json([
            'status'     => '200'
    ]);
}

public function leader_destroy(Request $request,$id)
{
   $del = Leave_leader::find($id); 
   $del->delete(); 
    return response()->json(['status' => '200','success' => 'Delete Success']);
}

public function leader_addsub(Request $request,$id)
{  
    $data['leave_leader'] = Leave_leader::get();
    $data['leave_leader_sub'] = Leave_leader_sub::where('leave_id','=',$id)->get();
    $data['users'] = User::get();
    $datasub = Leave_leader::where('leave_id','=',$id)->first();
    return view('setting.leader_sub',$data,[
        'datasubs' => $datasub
    ]);
}

public function leader_addsub_save(Request $request)
{         
        $add = new Leave_leader_sub();
        $leaveid = $request->input('leave_id');

        // $idle = $request->input('leader_id'); 
        if ($leaveid != '') {
            $leadsave = DB::table('leave_leader')->where('leave_id','=',$leaveid)->first();
            $add->leave_id = $leadsave->leave_id;
            $add->leader_id = $leadsave->leader_id; 
            $add->leader_name = $leadsave->leader_name ; 
        } else {
            $add->leader_id = ''; 
            $add->leader_name =''; 
        }

        $iduser = $request->input('USER_ID'); 
        if ($iduser != '') {
            $usersave = DB::table('users')->where('id','=',$iduser)->first();
            $add->user_id = $usersave->id; 
            $add->user_name = $usersave->fname. '  ' .$usersave->lname ; 
        } else {
            $add->user_id = ''; 
            $add->user_name =''; 
        }

        $add->save();    
        return response()->json([
            'status'     => '200'
    ]);
}

public function leadersub_destroy(Request $request,$id)
{
   $del = Leave_leader_sub::find($id); 
   $del->delete(); 
    return response()->json(['status' => '200','success' => 'Delete Success']);
}
// ***************  องค์กร *************
public function orginfo(Request $request)
{  
    $data['orginfo'] = Orginfo::where('orginfo_id','=',1)->first(); 
    $data['users'] = User::get();

    return view('setting.orginfo',$data);
}

public function orginfo_update(Request $request)
{  
    $id = $request->input('orginfo_id');

    $update = Orginfo::find($id); 
    $update->orginfo_name = $request->input('orginfo_name');
    $update->orginfo_code = $request->input('orginfo_code');
    $update->orginfo_link = $request->input('orginfo_link');
    $update->orginfo_email = $request->input('orginfo_email');
    $update->orginfo_address = $request->input('orginfo_address');
    $update->orginfo_tel = $request->input('orginfo_tel');

    $iduser = $request->input('orginfo_manage_id'); 
    if ($iduser != '') {
        $usersave = DB::table('users')->where('id','=',$iduser)->first();
        $update->orginfo_manage_id = $usersave->id; 
        $update->orginfo_manage_name = $usersave->fname. '  ' .$usersave->lname ; 
    } else {
        $update->orginfo_manage_id = ''; 
        $update->orginfo_manage_name =''; 
    }

    
    $iduserpo = $request->input('orginfo_po_id'); 
    if ($iduserpo != '') {
        $userposave = DB::table('users')->where('id','=',$iduserpo)->first();
        $update->orginfo_po_id = $userposave->id; 
        $update->orginfo_po_name = $userposave->fname. '  ' .$userposave->lname ; 
    } else {
        $update->orginfo_po_id = ''; 
        $update->orginfo_po_name =''; 
    }

    if ($request->hasfile('orginfo_img')) {
        $description = 'storage/org/'.$update->orginfo_img;
        if (File::exists($description))
        {
            File::delete($description);
        }
        $file = $request->file('orginfo_img');
        $extention = $file->getClientOriginalExtension();
        $filename = time().'.'.$extention;
        // $file->move('uploads/article/',$filename);
        $request->orginfo_img->storeAs('org',$filename,'public');
        $update->orginfo_img = $filename;
        $update->orginfo_img_name = $filename;
    }

    $update->save();
    
    return response()->json([
        'status'     => '200', 
        ]);
}

// *************** Line token *************
public function line_token(Request $request)
{  
    $data['line_token'] = Line_token::get(); 

    return view('setting.line_token',$data);
}

public function line_token_edit(Request $request,$id)
{  
    $line_token = Line_token::find($id); 
    
    return response()->json([
        'status'     => '200',
        'line_token'      =>  $line_token, 
        ]);
}
public function line_token_update(Request $request)
{  
    $line_id = $request->input('line_token_id');
    $update = Line_token::find($line_id); 
    // $update->line_token_name = $request->input('line_token_name');
    $update->line_token_code = $request->input('line_token_code');
    $update->save();
    
    return response()->json([
        'status'     => '200', 
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
public function hn_purchaseindex(Request $request)
{  
    $data['status'] = Status::paginate(15);
    return view('hn.hn_purchaseindex',$data);
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