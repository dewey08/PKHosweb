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
use App\Models\Market_product;
use App\Models\Market_product_category;
use App\Models\Market_product_rep;
use App\Models\Market_product_repsub;
use App\Models\Market_customer;
use App\Models\Users_prefix;
use App\Models\Market_basket;
use App\Models\Market_basket_bill;
use Auth;

use Illuminate\Support\Facades\File;
use DataTables;
use Intervention\Image\ImageManagerStatic as Image;
class MarketController extends Controller
{  

public function product_index(Request $request)
{   
    $data['product_category'] = Products_category::get();
    // $data['product_type'] = Products_type::get();
   
    // $data['product_group'] = Product_group::where('product_group_id','=',1)->orWhere('product_group_id','=',2)->get();
    $data['product_unit'] = Product_unit::get();
    // $data['product_data'] = Products::where('product_groupid','=',1)->orwhere('product_groupid','=',2)->orderBy('product_id','DESC')->get();

    $data['market_product'] = Market_product::get();

    $product = array();
    $products = Market_product::all();
    foreach ($products as $item) {
        $product[] = [
            'productid' => $item->product_id,
            'productcode' => $item->product_code,
            'productname' => $item->product_name 
        ];
    }

    return view('market.product_index',$data,[
        'products'=>$product
    ]);
}

public function product_add(Request $request)
{   
    $data['department_sub_sub'] = Department_sub_sub::get();
    $data['product_decline'] = Product_decline::get();
    $data['product_prop'] = Product_prop::get();
    $data['supplies_prop'] = DB::table('supplies_prop')->get();
    $data['budget_year'] = DB::table('budget_year')->orderBy('leave_year_id','DESC')->get();
    $data['product_data'] = Products::get();
    $data['product_category'] = Products_category::get();
    $data['product_type'] = Products_type::get();
    $data['product_spyprice'] = Product_spyprice::get();
    $data['product_group'] = Product_group::get();
    $data['product_unit'] = Product_unit::get();
    $data['article_data'] = Article::get();
    $data['data_province'] = DB::table('data_province')->get();
    $data['data_amphur'] = DB::table('data_amphur')->get();
    $data['data_tumbon'] = DB::table('data_tumbon')->get();
    $data['land_data'] = Land::get();
    $data['product_budget'] = Product_budget::get();
    $data['product_method'] = Product_method::get();
    $data['product_buy'] = Product_buy::get();
    $data['users'] = User::get(); 
    $data['article_status'] = Article_status::get(); 
    $data['products_vendor'] = Products_vendor::get(); 
    $data['product_brand'] = Product_brand::get(); 
    $data['market_product_category'] = Market_product_category::get(); 

    return view('market.product_add',$data);
}
public function product_save(Request $request)
{   
        $add = new Market_product();
        $add->product_code = $request->input('product_code'); 
        $add->product_name = $request->input('product_name'); 
        $add->product_qty = $request->input('product_qty'); 
        $add->product_price = $request->input('product_price');
        $add->store_id = $request->input('store_id'); 
  
        $catid = $request->input('product_categoryid'); 
        if ($catid != '') {
            $catsave = DB::table('market_product_category')->where('category_id','=',$catid)->first();
            $add->product_categoryid = $catsave->category_id; 
            $add->product_categoryname = $catsave->category_name; 
        } else {
            $add->product_categoryid = ''; 
            $add->product_categoryname =''; 
        }

        $unitbigid = $request->input('product_unit_bigid'); 
        if ($unitbigid != '') {
            $idunibigtpack = DB::table('product_unit')->where('unit_id','=',$unitbigid)->first();
            $add->product_unit_bigid = $idunibigtpack->unit_id;   
            $add->product_unit_bigname = $idunibigtpack->unit_name;  
        } else {
            $add->product_unit_bigid = '';   
            $add->product_unit_bigname = ''; 
        }

        $unitid = $request->input('product_unit_subid'); 
        if ($unitid != '') {
            $idunitpack = DB::table('product_unit')->where('unit_id','=',$unitid)->first();
            $add->product_unit_subid = $idunitpack->unit_id;   
            $add->product_unit_subname = $idunitpack->unit_name;  
        } else {
            $add->product_unit_subid = '';   
            $add->product_unit_subname = ''; 
        }
     
        if ($request->hasfile('img')) {
            $file = $request->file('img');
            $extention = $file->getClientOriginalExtension();
            $filename = time().'.'.$extention; 
            $request->img->storeAs('products',$filename,'public');
            $add->img = $filename;
            $add->img_name = $filename;
        }
        $add->save();    
        return response()->json([
            'status'     => '200'
            ]);
}
public function product_edit(Request $request,$id)
{          
    $data['department_sub_sub'] = Department_sub_sub::get();
    $data['product_decline'] = Product_decline::get();
    $data['product_prop'] = Product_prop::get();
    $data['supplies_prop'] = DB::table('supplies_prop')->get();
    $data['budget_year'] = DB::table('budget_year')->orderBy('leave_year_id','DESC')->get();
    $data['product_data'] = Products::get();
    $data['product_category'] = Products_category::get();
    $data['product_type'] = Products_type::get();
    $data['product_spyprice'] = Product_spyprice::get();
    $data['product_group'] = Product_group::get();
    $data['product_unit'] = Product_unit::get();
    $data['article_data'] = Article::get();
    $data['data_province'] = DB::table('data_province')->get();
    $data['data_amphur'] = DB::table('data_amphur')->get();
    $data['data_tumbon'] = DB::table('data_tumbon')->get();
    $data['land_data'] = Land::get();
    $data['product_budget'] = Product_budget::get();
    $data['product_method'] = Product_method::get();
    $data['product_buy'] = Product_buy::get();
    $data['users'] = User::get(); 
    $data['article_status'] = Article_status::get(); 
    $data['products_vendor'] = Products_vendor::get(); 
    $data['product_brand'] = Product_brand::get(); 
    $data['market_product'] = Market_product::get();
    $data['market_product_category'] = Market_product_category::get(); 
    $dataedit = Market_product::where('product_id','=',$id)->first();
    $data['product_data'] = Products::where('product_groupid','=',1)->orwhere('product_groupid','=',2)->orderBy('product_id','DESC')->get();

    return view('market.product_edit',$data,[
        'dataedits'=>$dataedit
    ]);
}
public function product_update(Request $request)
{      
    $idproducts = $request->product_id;     
    $update = Market_product::find($idproducts);
    $update->product_code = $request->input('product_code'); 
    $update->product_name = $request->input('product_name'); 
    $update->product_qty = $request->input('product_qty'); 
    $update->product_price = $request->input('product_price');
    $update->store_id = $request->input('store_id'); 
 

    $catid = $request->input('product_categoryid'); 
    if ($catid != '') {
        $catsave = DB::table('market_product_category')->where('category_id','=',$catid)->first();
        $update->product_categoryid = $catsave->category_id; 
        $update->product_categoryname = $catsave->category_name; 
    } else {
        $update->product_categoryid = ''; 
        $update->product_categoryname =''; 
    }

    $unitbigid = $request->input('product_unit_bigid'); 
    if ($unitbigid != '') {
        $idunibigtpack = DB::table('product_unit')->where('unit_id','=',$unitbigid)->first();
        $update->product_unit_bigid = $idunibigtpack->unit_id;   
        $update->product_unit_bigname = $idunibigtpack->unit_name;  
    } else {
        $update->product_unit_bigid = '';   
        $update->product_unit_bigname = ''; 
    }

    $unitid = $request->input('product_unit_subid'); 
    if ($unitid != '') {
        $idunitpack = DB::table('product_unit')->where('unit_id','=',$unitid)->first();
        $update->product_unit_subid = $idunitpack->unit_id;   
        $update->product_unit_subname = $idunitpack->unit_name;  
    } else {
        $update->product_unit_subid = '';   
        $update->product_unit_subname = ''; 
    }

    if ($request->hasfile('img')) {
        $description = 'storage/products/'.$update->img;
        if (File::exists($description))
        {
            File::delete($description);
        }
        $file = $request->file('img');
        $extention = $file->getClientOriginalExtension();
        $filename = time().'.'.$extention;
        // $file->move('uploads/products/',$filename);
        $request->img->storeAs('products',$filename,'public');
        $update->img = $filename;
        $update->img_name = $filename;       
    }  
   
    $update->save(); 
      
    return response()->json([
        'status'     => '200'
        ]);
}

public function product_destroy(Request $request,$id)
{
   $del = Market_product::find($id);  
   $description = 'storage/products/'.$del->img;
   if (File::exists($description)) {
       File::delete($description);
   }
   $del->delete(); 
    return response()->json(['status' => '200','success' => 'Delete Success']);
}

public static function refnumber()
{
    $year = date('Y');
    $maxnumber = DB::table('market_product_rep')->max('request_id');  
    if($maxnumber != '' ||  $maxnumber != null){
        $refmax = DB::table('market_product_rep')->where('request_id','=',$maxnumber)->first();  
        if($refmax->request_code != '' ||  $refmax->request_code != null){
        $maxref = substr($refmax->request_code, -4)+1;
        }else{
        $maxref = 1;
        }
        $ref = str_pad($maxref, 5, "0", STR_PAD_LEFT);
    }else{
        $ref = '00001';
    }
    $ye = date('Y')+543;
    $y = substr($ye, -2);
    $refnumber = 'REP'.'-'.$ref;
    return $refnumber;
}

public static function refmaxid()
{
    $year = date('Y');
    $refmax = DB::table('market_product_rep')->max('request_id');  
    // $maxref = substr($refmax->request_id)+1;
    $refmaxid = $refmax;
    return $refmaxid;
}
public static function refmaxidfirst()
{
    $year = date('Y');
    $refmax = DB::table('market_product_rep')->max('request_id');  
    // $maxref = substr($refmax->request_id)+1;
    $refmaxidfirst = $refmax+1;
    return $refmaxidfirst;
}

public function rep_product(Request $request)
{   
    $data['product_category'] = Products_category::get();
    $data['product_type'] = Products_type::get();
    $data['product_spyprice'] = Product_spyprice::get();
    $data['product_group'] = Product_group::where('product_group_id','=',1)->orWhere('product_group_id','=',2)->get();
    $data['product_unit'] = Product_unit::get();
    $data['product_data'] = Products::where('product_groupid','=',1)->orwhere('product_groupid','=',2)->orderBy('product_id','DESC')->get();
    $data['market_product_rep'] = Market_product_rep::orderBy('request_id','DESC')->get();
    return view('market.rep_product',$data);
}
public function rep_product_add(Request $request)
{   
    // $data['department_sub_sub'] = Department_sub_sub::get();
    // $data['product_decline'] = Product_decline::get();
    // $data['product_prop'] = Product_prop::get();
    // $data['supplies_prop'] = DB::table('supplies_prop')->get();
    // $data['budget_year'] = DB::table('budget_year')->orderBy('leave_year_id','DESC')->get();
    // $data['product_data'] = Products::get();
    // $data['product_category'] = Products_category::get();
    // $data['product_type'] = Products_type::get();
    // $data['product_spyprice'] = Product_spyprice::get();
    // $data['product_group'] = Product_group::get();
    // $data['product_unit'] = Product_unit::get();
    // $data['article_data'] = Article::get();
    // $data['data_province'] = DB::table('data_province')->get();
    // $data['data_amphur'] = DB::table('data_amphur')->get();
    // $data['data_tumbon'] = DB::table('data_tumbon')->get();
    // $data['land_data'] = Land::get();
    // $data['product_budget'] = Product_budget::get();
    // $data['product_method'] = Product_method::get();
    // $data['product_buy'] = Product_buy::get();
    // $data['users'] = User::get(); 
    // $data['article_status'] = Article_status::get(); 
    $data['products_vendor'] = Products_vendor::get(); 
    // $data['product_brand'] = Product_brand::get(); 
    // $data['market_product_category'] = Market_product_category::get(); 
    // $data['products_request'] = Products_request::where('request_id','=',$idrep)->first();   

    $data['budget_year'] = DB::table('budget_year')->orderBy('leave_year_id','DESC')->get();
    $dataedit = User::leftjoin('users_prefix','users_prefix.prefix_code','=','users.pname')->get();
    // $data['products_request_sub'] = DB::table('products_request_sub')->where('request_id','=',$idrep)->paginate(15);
    $data['product_data'] = Products::where('product_groupid','=',1)->orwhere('product_groupid','=',2)->orderBy('product_id','DESC')->paginate(15);

    return view('market.rep_product_add',$data,
     [
        'dataedits'       =>  $dataedit,       
    ]);
}
public function rep_product_destroy(Request $request,$id)
{
   $del = Market_product_rep::find($id);  
    
   $del->delete(); 
    return response()->json(['status' => '200','success' => 'Delete Success']);
}
public function rep_product_save(Request $request)
{   
    $idmax = $request->input('refmaxid'); 
    $add = new Market_product_rep();
    $add->request_code = $request->input('request_code'); 
    $add->request_year = $request->input('request_year'); 
    $add->request_date = $request->input('request_date');
    $add->request_no_bill = $request->input('request_no_bill');
    // $add->request_phone = $request->input('request_phone');
    $add->store_id = $request->input('store_id'); 
    $add->request_status = '1'; 
 
    $iduser = $request->input('user_id'); 
    if ($iduser != '') {
        $usersave = DB::table('users')->where('id','=',$iduser)->first();
        $add->request_user_id = $usersave->id; 
        $add->request_user_name = $usersave->fname. '  ' .$usersave->lname ; 
    } else {
        $add->request_user_id = ''; 
        $add->request_user_name =''; 
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
        'idmax'         =>  $idmax,
        ]);
}
public function rep_product_addsub (Request $request,$idmax)
{       
    // dd($idmax);
    $dataedit = Market_product_rep::where('request_id','=',$idmax)->first(); 
    // $idrep = $dataedit->request_id;   
    $data['products_vendor'] = Products_vendor::get(); 
    $data['budget_year'] = DB::table('budget_year')->orderBy('leave_year_id','DESC')->get();
    $data['market_product'] = Market_product::get();
    $data['product_unit'] = Product_unit::get();
    // $repsub = Market_product_repsub::get();
    $repsub = Market_product_repsub::where('request_id','=',$dataedit->request_id)->orderBy('request_sub_id','DESC')->get();
    // $data['product_data'] = Products::where('product_groupid','=',1)->orwhere('product_groupid','=',2)->orderBy('product_id','DESC')->paginate(15);
    $y = date('Y');
    $m = date('m');
    $d = date('d');
    $lot = $y.''.$m.''.$d;
    return view('market.rep_product_addsub ',$data,
    [
        'dataedits'       =>  $dataedit,   
        'repsubs'       =>  $repsub,
        'idmax'       =>  $idmax,
        'lot'       =>  $lot,     
    ]);
}

public function rep_product_addsub_save(Request $request)
{   
        $qty = $request->input('request_sub_qty'); 
        $price = $request->input('request_sub_price');   

        $add = new Market_product_repsub();
        $add->request_id = $request->input('request_id'); 
        $add->request_sub_qty = $qty; 
        $add->request_sub_price = $price; 
        $add->request_sub_lot = $request->input('request_sub_lot'); 
        $add->request_sub_date_exp = $request->input('request_sub_date_exp');
        $add->request_sub_sum_price = $qty * $price; 
        $add->store_id = $request->input('store_id'); 
  
        $proid = $request->input('request_sub_product_id'); 
        if ($proid != '') {
            $prosave = DB::table('market_product')->where('product_id','=',$proid)->first();
            $add->request_sub_product_id = $prosave->product_id; 
            $add->request_sub_product_code = $prosave->product_code; 
            $add->request_sub_product_name = $prosave->product_name; 
            $add->request_sub_unitid = $prosave->product_unit_subid; 
            $add->request_sub_unitname = $prosave->product_unit_subname; 
        } else {
            $add->request_sub_product_id = ''; 
            $add->request_sub_product_code = ''; 
            $add->request_sub_product_name =''; 
            $add->request_sub_unitid =''; 
            $add->request_sub_unitname =''; 
        }

        // $unitid = $request->input('request_sub_unitid'); 
        // if ($unitid != '') {
        //     $idunitpack = DB::table('product_unit')->where('unit_id','=',$unitid)->first();
        //     $add->request_sub_unitid = $idunitpack->unit_id;   
        //     $add->request_sub_unitname = $idunitpack->unit_name;  
        // } else {
        //     $add->request_sub_unitid = '';   
        //     $add->request_sub_unitname = ''; 
        // }
     
      
        $add->save();   
        return back(); 
        // return response()->json([
        //     'status'     => '200'
        //     ]);
}
public function rep_product_detail (Request $request,$idmax)
{       
    // dd($idmax);
    $dataedit = Market_product_rep::where('request_id','=',$idmax)->first(); 
    // $idrep = $dataedit->request_id;   
    $data['products_vendor'] = Products_vendor::get(); 
    $data['budget_year'] = DB::table('budget_year')->orderBy('leave_year_id','DESC')->get();
    $data['market_product'] = Market_product::get();
    $data['product_unit'] = Product_unit::get();
    // $repsub = Market_product_repsub::get();
    $repsub = Market_product_repsub::where('request_id','=',$dataedit->request_id)->orderBy('request_sub_id','DESC')->get();
    // $data['product_data'] = Products::where('product_groupid','=',1)->orwhere('product_groupid','=',2)->orderBy('product_id','DESC')->paginate(15);
    $y = date('Y');
    $m = date('m');
    $d = date('d');
    $lot = $y.''.$m.''.$d;
    return view('market.rep_product_detail ',$data,
    [
        'dataedits'       =>  $dataedit,   
        'repsubs'       =>  $repsub,
        'idmax'       =>  $idmax,
        'lot'       =>  $lot,     
    ]);
}
public function rep_product_edit (Request $request,$idmax)
{       
    // dd($idmax);
    $dataedit = Market_product_rep::where('request_id','=',$idmax)->first(); 
    // $idrep = $dataedit->request_id;   
    $data['products_vendor'] = Products_vendor::get(); 
    $data['budget_year'] = DB::table('budget_year')->orderBy('leave_year_id','DESC')->get();
    $data['market_product'] = Market_product::get();
    $data['product_unit'] = Product_unit::get();
    // $repsub = Market_product_repsub::get();
    $repsub = Market_product_repsub::where('request_id','=',$dataedit->request_id)->orderBy('request_sub_id','DESC')->get();
    // $data['product_data'] = Products::where('product_groupid','=',1)->orwhere('product_groupid','=',2)->orderBy('product_id','DESC')->paginate(15);
    $y = date('Y');
    $m = date('m');
    $d = date('d');
    $lot = $y.''.$m.''.$d;
    return view('market.rep_product_edit ',$data,
    [
        'dataedits'       =>  $dataedit,   
        'repsubs'       =>  $repsub,
        'idmax'       =>  $idmax,
        'lot'       =>  $lot,     
    ]);
}
public function rep_product_update(Request $request)
{   
    $id = $request->request_id ; 
    $update = Market_product_rep::find($id);
    $update->request_code = $request->request_code; 
    $update->request_year = $request->request_year; 
    $update->request_date = $request->request_date;
    $update->request_no_bill = $request->request_no_bill; 
    $update->store_id = $request->store_id; 
    $update->request_status = '1'; 
 
    $iduser = $request->input('user_id'); 
    if ($iduser != '') {
        $usersave = DB::table('users')->where('id','=',$iduser)->first();
        $update->request_user_id = $usersave->id; 
        $update->request_user_name = $usersave->fname. '  ' .$usersave->lname ; 
    } else {
        $update->request_user_id = ''; 
        $update->request_user_name =''; 
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
        ]);
}

public function rep_product_addsub_destroy(Request $request,$id)
{
   $del = Market_product_repsub::find($id);  
    
   $del->delete(); 
    return response()->json(['status' => '200','success' => 'Delete Success']);
}
function addcategory(Request $request)
{     
 if($request->catnew!= null || $request->catnew != ''){    
     $count_check = Market_product_category::where('category_name','=',$request->catnew)->count();           
        if($count_check == 0){    
                $add = new Market_product_category(); 
                $add->category_name = $request->catnew;
                $add->save(); 
        }
        }
            $query =  DB::table('market_product_category')->get();            
            $output='<option value="">--เลือก--</option>';                
            foreach ($query as $row){
                if($request->catnew == $row->category_name){
                    $output.= '<option value="'.$row->category_id.'" selected>'.$row->category_name.'</option>';
                }else{
                    $output.= '<option value="'.$row->category_id.'">'.$row->category_name.'</option>';
                }   
        }    
    echo $output;        
}
function addvendor(Request $request)
{     
 if($request->vennew!= null || $request->vennew != ''){    
     $count_check = Products_vendor::where('vendor_name','=',$request->vennew)->count();           
        if($count_check == 0){    
                $add = new Products_vendor(); 
                $add->vendor_name = $request->vennew;
                $add->save(); 
        }
        }
            $query =  DB::table('products_vendor')->get();            
            $output='<option value="">--เลือก--</option>';                
            foreach ($query as $row){
                if($request->vennew == $row->vendor_name){
                    $output.= '<option value="'.$row->vendor_id.'" selected>'.$row->vendor_name.'</option>';
                }else{
                    $output.= '<option value="'.$row->vendor_id.'">'.$row->vendor_name.'</option>';
                }   
        }    
    echo $output;        
}

// ********************** รายชื่อลูกค้า ***********************
public static function refcustomer()
{
    $year = date('Y');
    $maxnumber = DB::table('market_customer')->max('customer_id');  
    if($maxnumber != '' ||  $maxnumber != null){
        $refmax = DB::table('market_customer')->where('customer_id','=',$maxnumber)->first();  
        if($refmax->pcustomer_code != '' ||  $refmax->pcustomer_code != null){
        $maxref = substr($refmax->pcustomer_code, -4)+1;
        }else{
        $maxref = 1;
        }
        $ref = str_pad($maxref, 5, "0", STR_PAD_LEFT);
    }else{
        $ref = '00001';
    }
    $ye = date('Y')+543;
    $y = substr($ye, -2);
    $refcustomer = 'CUS'.'-'.$ref;
    return $refcustomer;
}
public function customer(Request $request)
{   
    $data['product_category'] = Products_category::get();
    // $data['product_type'] = Products_type::get();
   
    // $data['product_group'] = Product_group::where('product_group_id','=',1)->orWhere('product_group_id','=',2)->get();
    $data['product_unit'] = Product_unit::get();
    // $data['product_data'] = Products::where('product_groupid','=',1)->orwhere('product_groupid','=',2)->orderBy('product_id','DESC')->get();

    $data['market_customer'] = Market_customer::leftjoin('users_prefix','users_prefix.prefix_code','=','market_customer.customer_pname')->get();
    return view('customer.customer',$data);
}
public function customer_add(Request $request)
{      
    $data['market_customer'] = Market_customer::get();
    $data['users_prefix'] = Users_prefix::get();
    return view('customer.customer_add',$data);
}
public function customer_save(Request $request)
{   
        $add = new Market_customer();
        $add->pcustomer_code = $request->input('pcustomer_code'); 
        $add->pcustomer_tel = $request->input('pcustomer_tel'); 
        $add->customer_pname = $request->input('customer_pname'); 
        $add->store_id = $request->input('store_id');  
        $add->pcustomer_fname = $request->input('pcustomer_fname');
        $add->pcustomer_lname = $request->input('pcustomer_lname');
        $add->pcustomer_address = $request->input('pcustomer_address');
       
     
        if ($request->hasfile('img')) {
            $file = $request->file('img');
            $extention = $file->getClientOriginalExtension();
            $filename = time().'.'.$extention; 
            $request->img->storeAs('customer',$filename,'public');
            $add->img = $filename;
            $add->img_name = $filename;
        }
        $add->save();    
        return response()->json([
            'status'     => '200'
            ]);
}
public function customer_edit(Request $request,$id)
{           
    $dataedit = Market_customer::where('customer_id','=',$id)->first();
    $data['users_prefix'] = Users_prefix::get();

    return view('customer.customer_edit',$data,[
        'dataedits'=>$dataedit
    ]);
}
public function customer_update(Request $request)
{   
        $id = $request->customer_id ;
        $update = Market_customer::find($id);
        $update->pcustomer_code = $request->input('pcustomer_code'); 
        $update->pcustomer_tel = $request->input('pcustomer_tel'); 
        $update->customer_pname = $request->input('customer_pname'); 
        $update->store_id = $request->input('store_id');    
        $update->pcustomer_fname = $request->input('pcustomer_fname');
        $update->pcustomer_lname = $request->input('pcustomer_lname');
        $update->pcustomer_address = $request->input('pcustomer_address');
        
        if ($request->hasfile('img')) {
            $description = 'storage/customer/'.$update->img;
            if (File::exists($description))
            {
                File::delete($description);
            }
            $file = $request->file('img');
            $extention = $file->getClientOriginalExtension();
            $filename = time().'.'.$extention;
            // $file->move('uploads/products/',$filename);
            $request->img->storeAs('customer',$filename,'public');
            $update->img = $filename;
            $update->img_name = $filename;       
        }  
        $update->save();    
        return response()->json([
            'status'     => '200'
            ]);
}
public function customer_destroy(Request $request,$id)
{
   $del = Market_customer::find($id);  
   $description = 'storage/customer/'.$del->img;
   if (File::exists($description)) {
       File::delete($description);
   }
   $del->delete(); 
    return response()->json(['status' => '200','success' => 'Delete Success']);
}

public function sale_index(Request $request)
{   
    $data['products_vendor'] = Products_vendor::get(); 
    $data['budget_year'] = DB::table('budget_year')->orderBy('leave_year_id','DESC')->get();
    $data['market_product'] = Market_product::get();
    $data['product_unit'] = Product_unit::get();
    
    date_default_timezone_set("Asia/Bangkok");
    $datenow = date('Y-m-d');
    $data['market_basket'] = Market_basket::get();
    $data['market_basket_bill'] = Market_basket_bill::get();
    // leftjoin('market_basket','market_basket_bill.bill_id','=','market_basket.bill_id')
    // ->groupBy('market_basket.bill_id')
    // ->get();

    return view('market.sale_index',$data);
}
public function sale(Request $request)
{   
    $data['products_vendor'] = Products_vendor::get(); 
    $data['budget_year'] = DB::table('budget_year')->orderBy('leave_year_id','DESC')->get();
    $data['market_product'] = Market_product::paginate(6);
    $data['product_unit'] = Product_unit::get();
    
    date_default_timezone_set("Asia/Bangkok");
    $datenow = date('Y-m-d');

    $year = date('Y');
    $maxnumber = DB::table('market_basket_bill')->max('bill_id');  
    if($maxnumber != '' ||  $maxnumber != null){
        $refmax = DB::table('market_basket_bill')->where('bill_id','=',$maxnumber)->first();  
        if($refmax->bill_no != '' ||  $refmax->bill_no != null){
        $maxref = substr($refmax->bill_no, -4)+1;
        }else{
        $maxref = 1;
        }
        $ref = str_pad($maxref, 5, "0", STR_PAD_LEFT);
    }else{
        $ref = '00001';
    }
    $ye = date('Y')+543;
    $y = substr($ye, -2);
    $refcustomer = 'SA'.'-'.$ref;
 
    $databill = $maxnumber+1;

    $data['market_basket'] = Market_basket::where('bill_id','=',$databill)->get();
    $data['market_basket_bill'] = Market_basket_bill::get();
    // $market_product = Market_product::get();
    $product = array();
    $products = Market_product::all();
    foreach ($products as $item) {
        $product[] = [
            'productid' => $item->product_id,
            'productcode' => $item->product_code,
            'productname' => $item->product_name 
        ];
    }

    return view('market.sale',$data ,
[
    'databills'        => $databill,
    // 'market_products'  => $market_product,
    'products'         => $product
]);
}
public function sale_save(Request $request)
{   
        $qty = $request->input('product_qty'); 
        $price = $request->input('product_price');

        $year = date('Y');
        $maxnumber = DB::table('market_basket_bill')->max('bill_id');  
        if($maxnumber != '' ||  $maxnumber != null){
            $refmax = DB::table('market_basket_bill')->where('bill_id','=',$maxnumber)->first();  
            if($refmax->bill_no != '' ||  $refmax->bill_no != null){
            $maxref = substr($refmax->bill_no, -4)+1;
            }else{
            $maxref = 1;
            }
            $ref = str_pad($maxref, 5, "0", STR_PAD_LEFT);
        }else{
            $ref = '00001';
        }
        $ye = date('Y')+543;
        $y = substr($ye, -2);
        $refcustomer = 'SA'.'-'.$ref;

        $maxnumber2 = DB::table('market_basket_bill')->max('bill_id');  
        if ($maxnumber2 == null) {
            $databill = $maxnumber2+1;
        } else {
            $databill = $maxnumber2+1;
        }
        
        $add = new Market_basket();
        $add->bill_id = $databill; 
        $add->basket_qty = $qty; 
        $add->basket_price = $price; 
        $add->bill_no = $refcustomer; 

        $proid = $request->input('product_id'); 

        if ($proid != '') {
            $prosave = DB::table('market_product')->where('product_id','=',$proid)->first();
            $add->basket_product_id = $prosave->product_id; 
            $add->basket_product_code = $prosave->product_code; 
            $add->basket_product_name = $prosave->product_name;
        } else {
            $add->basket_product_id = ''; 
            $add->basket_product_code =''; 
            $add->basket_product_name =''; 
        }
        $add->basket_sum_price = $qty * $price; 
        $add->save(); 
        return back();  
}

public function sale_savebill(Request $request)
{   
     date_default_timezone_set("Asia/Bangkok");
    $datenow = date('Y-m-d');

    $year = date('Y');
    $maxnumber = DB::table('market_basket_bill')->max('bill_id');  
    if($maxnumber != '' ||  $maxnumber != null){
        $refmax = DB::table('market_basket_bill')->where('bill_id','=',$maxnumber)->first();  
        if($refmax->bill_no != '' ||  $refmax->bill_no != null){
        $maxref = substr($refmax->bill_no, -4)+1;
        }else{
        $maxref = 1;
        }
        $ref = str_pad($maxref, 5, "0", STR_PAD_LEFT);
    }else{
        $ref = '00001';
    }
    $ye = date('Y')+543;
    $y = substr($ye, -2);
    $refcustomer = 'SA'.'-'.$ref;

    
    $add = new Market_basket_bill();
    $add->bill_no = $refcustomer; 
    $add->bill_date =$datenow; 
    $add->bill_status = 'finish'; 
    $add->bill_total = $request->input('bill_total'); 

    $userid = Auth::user()->id; 
    if ($userid != '') {
        $repsave = DB::table('users')->where('id','=',$userid)->first();
        $add->bill_user_id = $repsave->id; 
        $add->bill_user_name = $repsave->fname. '  ' .$repsave->lname ; 
    } else {
        $add->bill_user_id = ''; 
        $add->bill_user_name =''; 
    }
    $add->save(); 

    // $databill = Market_basket_bill::first();
    // $databill = $maxnumber+1;

    $data['market_basket_bill'] = Market_basket::get();

    return redirect()->route('mar.sale_index'); 
}
public function sale_updatebill(Request $request)
{ 
         $id = $request->input('bill_id'); 
    
        $update = Market_basket_bill::find($id);
        $update->bill_total = $request->input('bill_total');        
        $update->save(); 
        return redirect()->route('mar.sale_index'); 
}
public function sale_update(Request $request)
{   
        $qty = $request->input('basket_qty'); 
        $price = $request->input('basket_price');
        $id = $request->input('basket_id');
        // $billno = $request->input('bill_no2'); 
    
        $update = Market_basket::find($id);
        $update->basket_qty = $qty; 
        $update->basket_price = $price; 
        // $update->bill_no = $billno;

        $proid = $request->input('basket_product_id'); 
        if ($proid != '') {
            $prosave = DB::table('market_product')->where('product_id','=',$proid)->first();
            $update->basket_product_id = $prosave->product_id; 
            $update->basket_product_code = $prosave->product_code; 
            $update->basket_product_name = $prosave->product_name;
        } else {
            $update->basket_product_id = ''; 
            $update->basket_product_code =''; 
            $update->basket_product_name =''; 
        }
        $update->basket_sum_price = $qty * $price; 
        $update->save(); 
        return back();  
}
public function sale_edit(Request $request,$id)
{   
    $data['products_vendor'] = Products_vendor::get(); 
    $data['budget_year'] = DB::table('budget_year')->orderBy('leave_year_id','DESC')->get();
    $data['market_product'] = Market_product::get();
    $data['product_unit'] = Product_unit::get();
    
    date_default_timezone_set("Asia/Bangkok");
    $datenow = date('Y-m-d');

    // $databill = $maxnumber+1;

    $data['market_basket'] = Market_basket::where('bill_id','=',$id)->get();
    $data['market_basket_bill'] = Market_basket_bill::get();
    $dataedit = Market_basket::where('bill_id','=',$id)->first();

    return view('market.sale_edit',$data ,
[
    'dataedits'  => $dataedit
]);
}
public function editsale_save(Request $request)
{   
        $qty = $request->input('product_qty'); 
        $price = $request->input('product_price');

        $databill = $request->input('bill_id'); 
        $bill_no = $request->input('bill_no'); 
        // if ($maxnumber == null) {
        //     $databill = $maxnumber+1;
        // } else {
        //     $databill = $maxnumber;
        // }
        
        $add = new Market_basket();
        $add->bill_id = $databill; 
        $add->basket_qty = $qty; 
        $add->basket_price = $price;  
        $add->bill_no = $bill_no;
        // $add->bill_total = $request->input('bill_total'); 

        $proid = $request->input('product_id'); 

        if ($proid != '') {
            $prosave = DB::table('market_product')->where('product_id','=',$proid)->first();
            $add->basket_product_id = $prosave->product_id; 
            $add->basket_product_code = $prosave->product_code; 
            $add->basket_product_name = $prosave->product_name;
        } else {
            $add->basket_product_id = ''; 
            $add->basket_product_code =''; 
            $add->basket_product_name =''; 
        }
        $add->basket_sum_price = $qty * $price; 
        $add->save(); 


        // $update = Market_basket_bill::find($databill);
        // $update->bill_total = $qty * $price; 
        // $update->save(); 

        return back();  
}
public function sale_destroy(Request $request,$id)
{
   $del = Market_basket::find($id);  
    
   $del->delete(); 
    return response()->json(['status' => '200','success' => 'Delete Success']);
}
public function bill_destroy(Request $request,$id)
{
   $del = Market_basket_bill::find($id);  
   $del->delete(); 
    return response()->json(['status' => '200','success' => 'Delete Success']);
}
}