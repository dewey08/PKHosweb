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

use Illuminate\Support\Facades\File;
use DataTables;
use Intervention\Image\ImageManagerStatic as Image;
class SuppliesController extends Controller
{  


public function supplies_dashboard(Request $request)
{   
    $data['product_category'] = Products_category::get();
    $data['product_type'] = Products_type::get();
    $data['product_spyprice'] = Product_spyprice::get();
    $data['product_group'] = Product_group::where('product_group_id','=',1)->orWhere('product_group_id','=',2)->get();
    $data['product_unit'] = Product_unit::get();
    $data['product_data'] = Products::where('product_groupid','=',1)->orwhere('product_groupid','=',2)->orderBy('product_id','DESC')->paginate(10);
    return view('supplies.supplies_dashboard',$data);
}
public function supplies_index(Request $request)
{   
    $data['product_category'] = Products_category::get();
    $data['product_type'] = Products_type::get();
    $data['product_spyprice'] = Product_spyprice::get();
    $data['product_group'] = Product_group::where('product_group_id','=',1)->orWhere('product_group_id','=',2)->get();
    $data['product_unit'] = Product_unit::get();
    // $data['product_data'] = Products::where('product_groupid','=',1)->orwhere('product_groupid','=',2)->orderBy('product_id','DESC')->get();

    $data['product_data'] = DB::connection('mysql')
    ->select('select p.product_id,p.product_code,p.product_name,p.product_attribute
        ,p.product_spypriceid,pu.unit_name,p.product_spypricename,pg.product_group_name,p.product_claim
        ,p.product_categoryid,p.product_groupid,p.product_unit_subid,pt.sub_type_name,pc.category_name
        from product_data p  
        left outer join product_unit pu on pu.unit_id=p.product_unit_subid
        left outer join product_group pg on pg.product_group_id=p.product_groupid
        left outer join product_type pt on pt.sub_type_id=p.product_typeid
        left outer join product_category pc on pc.category_id=p.product_categoryid
        where p.product_groupid = "1" or p.product_groupid ="2" 
    
        ');

    return view('supplies.supplies_index',$data);
}

public function supplies_index_add(Request $request)
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


    return view('supplies.supplies_index_add',$data);
}
public function supplies_index_save(Request $request)
{         
        //     $validator = Validator::make($request->all(),[           
        //      'product_code'   => 'required',
        //      'product_name'   => 'required',
        //      'product_attribute'   => 'required',
        //      'product_groupid'   => 'required',
        //      'product_typeid'   => 'required',
        //      'product_spypriceid'   => 'required',
        //      'product_unit_bigid'   => 'required',
        //      'img'     => 'required|image|mimes:jpeg,png,jpg|max:2048'     
        //  ]);
        

        $add = new Products();
        $add->product_code = $request->input('product_code'); 
        $add->product_name = $request->input('product_name'); 
        $add->product_attribute = $request->input('product_attribute'); 
        $add->store_id = $request->input('store_id'); 
        $add->product_claim = $request->input('product_claim');

        $spypriceid = $request->input('product_spypriceid');
        if ($spypriceid != '') {
            $spysave = DB::table('product_spyprice')->where('spyprice_id','=',$spypriceid)->first();
            $add->product_spypriceid = $spysave->spyprice_id; 
            $add->product_spypricename = $spysave->spyprice_name; 
        }else{
            $add->product_spypriceid = '';
            $add->product_spypricename = '';
        }

        $groupid = $request->input('product_groupid');
        if ($groupid != '') {
                $groupsave = DB::table('product_group')->where('product_group_id','=',$groupid)->first();
                $add->product_groupid = $groupsave->product_group_id; 
                $add->product_groupname = $groupsave->product_group_name; 
        } else {
            $add->product_groupid = ''; 
            $add->product_groupname = ''; 
        }

        $typeid = $request->input('product_typeid'); 
        if ($typeid != '') {
            $typesave = DB::table('product_type')->where('sub_type_id','=',$typeid)->first();
            $add->product_typeid = $typesave->sub_type_id; 
            $add->product_typename = $typesave->sub_type_name; 
        } else {
            $add->product_typeid = ''; 
            $add->product_typename =''; 
        }

        $catid = $request->input('product_categoryid'); 
        if ($catid != '') {
            $catsave = DB::table('product_category')->where('category_id','=',$catid)->first();
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
            // $imgsize = Image::make($filename);
            // $imgresize = $imgsize->resize(150, 150);
            // $file->move('uploads/products/',$filename);
            $request->img->storeAs('products',$filename,'public');
            $add->img = $filename;
            $add->img_name = $filename;
        }
        $add->save();    
        return response()->json([
            'status'     => '200'
            ]);
}
public function supplies_index_edit(Request $request,$id)
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

    $dataedit = Products::where('product_id','=',$id)->first();
    $data['product_data'] = Products::where('product_groupid','=',1)->orwhere('product_groupid','=',2)->orderBy('product_id','DESC')->get();

    return view('supplies.supplies_index_edit',$data,[
        'dataedits'=>$dataedit
    ]);
}
public function supplies_index_update(Request $request)
{      
    $idproducts = $request->product_id;     
    $update = Products::find($idproducts);
    $update->product_code = $request->input('product_code'); 
    $update->product_name = $request->input('product_name'); 
    $update->product_attribute = $request->input('product_attribute'); 
    $update->store_id = $request->input('store_id'); 
    $update->product_claim = $request->input('product_claim');
    $spypriceid = $request->input('product_spypriceid');
    if ($spypriceid != '') {
        $spysave = DB::table('product_spyprice')->where('spyprice_id','=',$spypriceid)->first();
        $update->product_spypriceid = $spysave->spyprice_id; 
        $update->product_spypricename = $spysave->spyprice_name; 
    }else{
        $update->product_spypriceid = '';
        $update->product_spypricename = '';
    }

    $groupid = $request->input('product_groupid');
    if ($groupid != '') {
            $groupsave = DB::table('product_group')->where('product_group_id','=',$groupid)->first();
            $update->product_groupid = $groupsave->product_group_id; 
            $update->product_groupname = $groupsave->product_group_name; 
    } else {
        $update->product_groupid = ''; 
        $update->product_groupname = ''; 
    }

    $typeid = $request->input('product_typeid'); 
    if ($typeid != '') {
        $typesave = DB::table('product_type')->where('sub_type_id','=',$typeid)->first();
        $update->product_typeid = $typesave->sub_type_id; 
        $update->product_typename = $typesave->sub_type_name; 
    } else {
        $update->product_typeid = ''; 
        $update->product_typename =''; 
    }

    $catid = $request->input('product_categoryid'); 
    if ($catid != '') {
        $catsave = DB::table('product_category')->where('category_id','=',$catid)->first();
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

public function supplies_destroy(Request $request,$id)
{
   $del = Products::find($id);  
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
    $maxnumber = DB::table('product_data')->orwhere('product_groupid','=',1)->orwhere('product_groupid','=',2)->max('product_id');  
    if($maxnumber != '' ||  $maxnumber != null){
        $refmax = DB::table('product_data')->where('product_id','=',$maxnumber)->first();  
        if($refmax->product_code != '' ||  $refmax->product_code != null){
        $maxref = substr($refmax->product_code, -4)+1;
        }else{
        $maxref = 1;
        }
        $ref = str_pad($maxref, 5, "0", STR_PAD_LEFT);
    }else{
        $ref = '00001';
    }
    $ye = date('Y')+543;
    $y = substr($ye, -2);
    $refnumber = 'PRD'.'-'.$ref;
    return $refnumber;
}

}