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
use App\Models\Land;
use App\Models\Building;
use App\Models\Product_budget;
use App\Models\Product_method;
use App\Models\Product_buy;

use Illuminate\Support\Facades\File;
use DataTables;
use Intervention\Image\ImageManagerStatic as Image;

class ServeController extends Controller
{  

public function serve_index(Request $request)
{   
    $data['department_sub_sub'] = Department_sub_sub::get();
    $data['product_decline'] = Product_decline::get();
    $data['product_prop'] = Product_prop::get();
    $data['supplies_prop'] = DB::table('supplies_prop')->get();
    $data['budget_year'] = DB::table('budget_year')->orderBy('leave_year_id','DESC')->get(); 
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
    $data['building_data'] = Building::get();
    $data['product_data'] = Products::where('product_groupid','=',4)->orderBy('product_id','DESC')->get();

    return view('serve.serve_index',$data);
}

public function serve_index_add(Request $request)
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
    $data['building_data'] = Building::get();
    $data['product_data'] = Products::where('product_groupid','=',4)->orderBy('product_id','DESC')->get();


    return view('serve.serve_index_add',$data);
}

public function serve_index_save(Request $request)
{    
    $add = new Products();
    $add->product_code = $request->input('product_code'); 
    $add->product_name = $request->input('product_name'); 
    $add->product_attribute = $request->input('product_attribute');
    $add->store_id = $request->input('store_id'); 
 
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
  
 
    if ($request->hasfile('img')) {
        $file = $request->file('img');
        $extention = $file->getClientOriginalExtension();
        $filename = time().'.'.$extention;
        $request->img->storeAs('serve',$filename,'public');
        $add->img = $filename;
        $add->img_name = $filename;
    }
    $add->save();            
       

        return response()->json([
            'status'     => '200'
            ]);
}
public function serve_index_edit(Request $request,$id)
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
    $data['building_data'] = Building::get();
    $data['product_data'] = Products::where('product_groupid','=',4)->orderBy('product_id','DESC')->paginate(10);
    $dataedit = Products::where('product_id','=',$id)->first(); 
    return view('serve.serve_index_edit',$data,[
        'dataedits'=>$dataedit
    ]);
}
public function serve_index_update(Request $request)
{      
    $idpro = $request->product_id;     
    $update = Products::find($idpro);
    $update->product_code = $request->input('product_code'); 
    $update->product_name = $request->input('product_name'); 
    $update->product_attribute = $request->input('product_attribute');
    $update->store_id = $request->input('store_id'); 
 
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

    if ($request->hasfile('img')) {
        $description = 'storage/serve/'.$update->img;
        if (File::exists($description))
        {
            File::delete($description);
        }
        $file = $request->file('img');
        $extention = $file->getClientOriginalExtension();
        $filename = time().'.'.$extention;
        // $file->move('uploads/article/',$filename);
        $request->img->storeAs('serve',$filename,'public');
        $update->img = $filename;
        $update->img_name = $filename;
    }
   
    $update->save(); 
      
    return response()->json([
        'status'     => '200'
        ]);
}
public function serve_destroy(Request $request,$id)
{
    $del = Products::find($id);  
    $description = 'storage/serve/'.$del->img;
    if (File::exists($description)) {
        File::delete($description);
    }
    $del->delete(); 
    return response()->json(['status' => '200','success' => 'Delete Success']);
}

public static function refserve()
{
    $year = date('Y');
    $maxnumber = DB::table('product_data')->where('product_groupid','=',4)->max('product_id');  
    if($maxnumber != '' ||  $maxnumber != null){
        $refmax = DB::table('product_data')->where('product_id','=',$maxnumber)->first();  
        
        if($refmax->product_code != '' ||  $refmax->product_code != null){
        $maxref = substr($refmax->product_code, -4)+1;
        }else{
        $maxref = 1;
        }
        $ref = str_pad($maxref, 5, "0", STR_PAD_LEFT);

    }else{
        $ref = '000001';
    }
    $ye = date('Y')+543;
    $y = substr($ye, -2);
    $refnumber = 'SRV'.'-'.$ref;
    return $refnumber;
}



}
