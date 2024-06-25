<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\support\Facades\Hash;
use Illuminate\support\Facades\Validator;
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

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data['product_data'] = Products::get();
        $product = array();
        $products = Market_product::all();
        foreach ($products as $item) {
            $product[] = [
                'productid' => $item->product_id,
                'productcode' => $item->product_code,
                'productname' => $item->product_name 
            ];
        }
        return view('admin',$data,[
            'products'  =>  $product
        ]);
    }

public function customerHome(Request $request)
{
    return view('customer.home');
}
public function adminHome(Request $request)
{
    return view('admin');
}
public function staffHome(Request $request)
{
    return view('staff/staff_index');
}
public function manageHome(Request $request)
{
    return view('manageHome');
}

public function memberHome(Request $request)
{
    // $data['users'] = User::all();
    $data['q'] = $request->query('q');
    $query = User::select('users.*','store_manager.*')
    ->leftjoin('store_manager','store_manager.store_id','=','users.store_id')
    ->where(function ($query) use ($data){
        $query->where('pname','like','%'.$data['q'].'%');
        $query->orwhere('fname','like','%'.$data['q'].'%');
        $query->orwhere('lname','like','%'.$data['q'].'%');
        $query->orwhere('tel','like','%'.$data['q'].'%');
        $query->orwhere('username','like','%'.$data['q'].'%');
    //   ->orderBy('RISK_TIME_ID','DESC')  
    });
    $data['users'] = $query->orderBy('id','DESC')->paginate(15);
    // $maxid = User::max('id');
    // $idfile = $maxid+1;
    // $data['users'] = User::leftjoin('store_manager','store_manager.store_id','=','users.store_id')
    // ->paginate(15);
    return view('manage.member',$data);
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
}

