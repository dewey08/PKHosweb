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
use DataTables;

class UsersuppliesController extends Controller
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
public function supplies_dashboard(Request $request)
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
    $data['department'] = Department::get();
    $data['department_sub'] = Departmentsub::get();
    $data['department_sub_sub'] = Departmentsubsub::get();
    $data['position'] = Position::get();
    $data['status'] = Status::get();
    return view('user.supplies_dashboard',$data);
}

public function supplies_data(Request $request)
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
    $data['department'] = Department::get();
    $data['department_sub'] = Departmentsub::get();
    $data['department_sub_sub'] = Departmentsubsub::get();
    $data['position'] = Position::get();
    $data['status'] = Status::get();
    return view('user.supplies_data',$data);
}

public function supplies_data_add(Request $request,$id)
{       
    // dd($id);
    $datarequesr = User::where('id','=',$id)->first();
    $data['department'] = Department::get();
    $data['department_sub'] = Departmentsub::get();
    $data['department_sub_sub'] = Departmentsubsub::get();
    $data['position'] = Position::get();
    $data['status'] = Status::get();
    $data['budget_year'] = DB::table('budget_year')->orderBy('leave_year_id','DESC')->get();
    $datashow = User::get();
    $data['products_vendor'] = Products_vendor::get();
    $data['products_request'] = Products_request::join('products_status','products_request.request_status','=','products_status.products_status_code')->where('request_debsubsub_id','=',$datarequesr->dep_subsubtrueid)->orderBy('request_id','DESC')->get();
    // $data['products_request']
    // $count_idpro = Products_request_sub::where('request_sub_product_id','=',$idpro)->where('request_id','=',$requestid )->count();
    // $data['products_request_sub'] = Products_request_sub::where('request_sub_product_id','=',$idpro)->where('request_id','=',$requestid )->count();
    $headid = $datarequesr->id;
    if ($headid != null) {
        $data['leave_leader_sub'] = Leave_leader_sub::where('user_id','=',$datarequesr->id)->first();
    } else {
        $data['leave_leader_sub'] = Leave_leader_sub::get();
    }
    
   
    // $dataedit = Products_request::where('request_id','=',$id)->first();
    // dd($dataedit);
    return view('user.supplies_data_add',$data,
    [
        'datashows'=>$datashow,
        'datarequesr'=>$datarequesr,
        // 'dataedits'=>$dataedit,
    ]);
}
public function supplies_data_save(Request $request)
{  
    $add = new Products_request();
    $add->request_code = $request->input('request_code'); 
    $add->request_year = $request->input('request_year'); 
    $add->request_date = $request->input('request_date');
    $add->request_because = $request->input('request_because');
    $add->request_phone = $request->input('request_phone');
    $add->store_id = $request->input('store_id'); 
    $add->request_status = 'WAITPRO'; 

    $add->request_debsubsub_id = $request->input('dep_subsubtrueid'); 
    $add->request_debsubsub_name = $request->input('dep_subsubtruename'); 

    $repid = $request->input('request_user_id'); 
    if ($repid != '') {
        $repsave = DB::table('users')->where('id','=',$repid)->first();
        $add->request_user_id = $repsave->id; 
        $add->request_user_name = $repsave->fname. '  ' .$repsave->lname ; 
    } else {
        $add->request_user_id = ''; 
        $add->request_user_name =''; 
    }

    $iduser = $request->input('user_id'); 
    if ($iduser != '') {
        $usersave = DB::table('users')->where('id','=',$iduser)->first();
        $add->request_user_id = $usersave->id; 
        $add->request_user_name = $usersave->fname. '  ' .$usersave->lname ; 
    } else {
        $add->request_user_id = ''; 
        $add->request_user_name =''; 
    }

    $idhn = $request->input('request_hn_id'); 
    if ($idhn != '') {
        $hnsave = DB::table('users')->where('id','=',$idhn)->first();
        $add->request_hn_id = $hnsave->id; 
        $add->request_hn_name = $hnsave->fname. '  ' .$usersave->lname ; 
    } else {
        $add->request_hn_id = ''; 
        $add->request_hn_name =''; 
    }

    $venid = $request->input('request_vendor_id'); 
    if ($venid != '') {
        $vensave = DB::table('products_vendor')->where('vendor_id','=',$venid)->first();
        $add->request_vendor_id = $vensave->vendor_id; 
        $add->request_vendor_name = $vensave->vendor_name; 
    } else {
        $add->request_vendor_id = ''; 
        $add->request_vendor_name =''; 
    }
    $add->save(); 
    return response()->json([
        'status'     => '200',
        'id'         =>  $iduser
        ]);
}

// public function supplies_data_edit (Request $request,$id,$idrep)
// {       
//     $datarequesr = User::where('id','=',$id)->first();
//     $data['products_request'] = Products_request::where('request_id','=',$idrep)->first();
//     $data['budget_year'] = DB::table('budget_year')->orderBy('leave_year_id','DESC')->get();
//     $dataedit = User::get();
//     $data['products_vendor'] = Products_vendor::get();
//     $data['products_request_sub'] = DB::table('products_request_sub')->where('request_id','=',)->paginate(10);
//     $data['product_data'] = Products::where('product_groupid','=',1)->orwhere('product_groupid','=',2)->orderBy('product_id','DESC')->paginate(15);
//     // $dataedit_data = Products_request::where('product_groupid','=',1)->orwhere('product_groupid','=',2)->orderBy('request_id','DESC')->paginate(10);
//     $dataedit_data = Products_request::LEFTJOIN('products_status','products_request.request_status','=','products_status.products_status_code')
//     ->where('products_request.request_debsubsub_id','=',$datarequesr->dep_subsubtrueid)
//     ->orderBy('request_id','DESC')->paginate(15);
//     return view('user.supplies_data_edit ',$data,
//     [
//         'dataedits'=>$dataedit,
//         'dataedit_data'  =>  $dataedit_data
//     ]);
// }
public function supplies_data_edit(Request $request,$id)
{
     $data = Products_request::find($id);  
    //  $data['products_request'] = Products_request::where('request_id','=',$id)->first();
     return response()->json([
       'status'     => '200',
       'data'   =>  $data,
       ]);
}
public function supplies_data_update(Request $request)
{   
    $idrep = $request->request_id;     
    $update = Products_request::find($idrep);
    $update->request_code = $request->input('request_code'); 
    $update->request_year = $request->input('request_year'); 
    $update->request_date = $request->input('request_date');
    $update->request_because = $request->input('request_because');
    $update->request_phone = $request->input('tel');
    $update->store_id = $request->input('store_id'); 
    // $update->request_status = 'WAITPRO'; 

    $update->request_debsubsub_id = $request->input('dep_subsubtrueid'); 
    $update->request_debsubsub_name = $request->input('dep_subsubtruename'); 

    $repid = $request->input('request_user_id'); 
    if ($repid != '') {
        $repsave = DB::table('users')->where('id','=',$repid)->first();
        $update->request_user_id = $repsave->id; 
        $update->request_user_name = $repsave->fname. '  ' .$repsave->lname ; 
    } else {
        $update->request_user_id = ''; 
        $update->request_user_name =''; 
    }

    $iduser = $request->input('user_id'); 
    if ($iduser != '') {
        $usersave = DB::table('users')->where('id','=',$iduser)->first();
        $update->request_user_id = $usersave->id; 
        $update->request_user_name = $usersave->fname. '  ' .$usersave->lname ; 
    } else {
        $update->request_user_id = ''; 
        $update->request_user_name =''; 
    }

    $idhn = $request->input('request_hn_id'); 
    if ($idhn != '') {
        $hnsave = DB::table('users')->where('id','=',$idhn)->first();
        $update->request_hn_id = $hnsave->id; 
        $update->request_hn_name = $hnsave->fname. '  ' .$usersave->lname ; 
    } else {
        $update->request_hn_id = ''; 
        $update->request_hn_name =''; 
    }


    $venid = $request->input('request_vendor_id'); 
    if ($venid != '') {
        $vensave = DB::table('products_vendor')->where('vendor_id','=',$venid)->first();
        $update->request_vendor_id = $vensave->vendor_id; 
        $update->request_vendor_name = $vensave->vendor_name; 
    } else {
        $update->request_vendor_id = ''; 
        $update->request_vendor_name =''; 
    }

    $update->save(); 

    return response()->json([
        'status'     => '200',
        'id'         =>  $iduser
        ]);
}

public function supplies_data_add_sub (Request $request,$id,$idrep)
{       
    $data['products_request'] = Products_request::where('request_id','=',$idrep)->first();   

    $data['budget_year'] = DB::table('budget_year')->orderBy('leave_year_id','DESC')->get();
    $dataedit = User::get();
    $data['products_request_sub'] = DB::table('products_request_sub')->where('request_id','=',$idrep)->paginate(15);
    $data['product_data'] = Products::where('product_groupid','=',1)->orwhere('product_groupid','=',2)->orderBy('product_id','DESC')->paginate(15);
    
    return view('user.supplies_data_add_sub ',$data,
    [
        'dataedits'       =>  $dataedit,       
    ]);
}
public function supplies_data_add_subsave(Request $request)
{   
    // $storeid = $request->input('store_id'); 
    // $userid = $request->input('user_id');  
    $requestid = $request->input('request_id');
    
    $idpro = $request->input('product_id'); 
    $count_idpro = Products_request_sub::where('request_sub_product_id','=',$idpro)->where('request_id','=',$requestid )->count();

    // dd($count_idpro);

    // $add = new Products_request_sub();
    // $idpro = $request->input('product_id'); 
    // $count_idpro = Products_request_sub::where('product_id','=',$idpro)->where('request_id','=',$requestid )->count();
    $qty = $request->input('request_sub_qty'); 
    $price = $request->input('request_sub_price'); 

    if ($count_idpro == '0') {
        $add = new Products_request_sub();
         if ($idpro != '') {
            $prosave = DB::table('product_data')->where('product_id','=',$idpro)->first();
            $add->request_sub_product_id = $prosave->product_id; 
            $add->request_sub_product_code = $prosave->product_code;
            $add->request_sub_product_name = $prosave->product_name;
            $add->request_sub_unitid = $prosave->product_unit_subid; 
            $add->request_sub_unitname = $prosave->product_unit_subname;  
            // $add->request_sub_sum_price = $qty * $price;  
        } else {
            $add->request_sub_product_id = ''; 
            $add->request_sub_product_code =''; 
            $add->request_sub_product_name =''; 
            $add->request_sub_unitid =''; 
            $add->request_sub_unitname =''; 

        }

        $add->request_id = $requestid;
        $add->request_sub_qty = $qty;
        $add->request_sub_price = $price;
        $add->request_sub_sum_price = $qty * $price; 
        $add->store_id = $request->input('store_id');       
        $add->save();       
        
        $update = Products_request::find($requestid);
        $update->request_status = 'REQUEST';
        $update->save();

        return back(); 

    } else {
        Products_request_sub::where('request_sub_product_id','=',$idpro)->where('request_id','=',$requestid )->delete(); 

        $add = new Products_request_sub();
         if ($idpro != '') {
            $prosave = DB::table('product_data')->where('product_id','=',$idpro)->first();
            $add->request_sub_product_id = $prosave->product_id; 
            $add->request_sub_product_code = $prosave->product_code;
            $add->request_sub_product_name = $prosave->product_name;
            $add->request_sub_unitid = $prosave->product_unit_subid; 
            $add->request_sub_unitname = $prosave->product_unit_subname;  
            // $add->request_sub_unitname = $prosave->product_unit_subname;  
        } else {
            $add->request_sub_product_id = ''; 
            $add->request_sub_product_code =''; 
            $add->request_sub_product_name =''; 
            $add->request_sub_unitid =''; 
            $add->request_sub_unitname ='';  
        }
        $add->request_id = $requestid;
        $add->request_sub_qty = $qty;
        $add->request_sub_price = $price;
        $add->request_sub_sum_price = $qty * $price; 
        $add->store_id = $request->input('store_id');
  
        $add->save();
        
        $update = Products_request::find($requestid);
        $update->request_status = 'REQUEST';
        $update->save();

        return back(); 
      
    }
    
}

public function supplies_data_add_subupdate(Request $request)
{  

    $qty = $request->input('request_sub_qty'); 
    $price = $request->input('request_sub_price'); 
    $idsub = $request->input('request_sub_id');
    // Products_request_sub::where('request_sub_id','=',$idsub)->first(); 
    $update = Products_request_sub::find($idsub);
    $update->request_sub_qty = $qty; 
    $update->request_sub_price = $price; 
    $update->request_sub_sum_price = $qty * $price; 
    $update->save();
     
    return back(); 
      
}
public function supplies_data_add_destroy(Request $request,$id)
{
   $del = Products_request::find($id); 
   $del->delete(); 
    return response()->json(['status' => '200','success' => 'Delete Success']);
}

public function supplies_data_add_subdestroy(Request $request,$id)
{
    $re = Products_request_sub::where('request_sub_id','=',$id)->first();
    
    $count_id = Products_request_sub::where('request_id','=',$re->request_id)->count();
    $update = Products_request::find($re->request_id);
    $update->request_status = 'WAITPRO';
    $update->save();

    $del = Products_request_sub::find($id); 
    $del->delete();

    return response()->json(['status' => '200','success' => 'Delete Success']);
}

}