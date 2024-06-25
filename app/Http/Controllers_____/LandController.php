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

use Illuminate\Support\Facades\File;
use DataTables;
use Intervention\Image\ImageManagerStatic as Image;

class LandController extends Controller
{  

public function land_index(Request $request)
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

    $data['land_data'] = Land::orderBy('land_id','DESC')->get();
    return view('land.land_index',$data);
}

public function selectfsn(Request $request)
{
    $detail = DB::table('product_prop')->where('prop_id','=',$request->id)->first();

    $output='<div class="col-md-12">
                <div class="form-group">
                <label for="">รหัสหมวดครุภัณฑ์</label>
                    <input id="article_fsn" type="text" class="form-control" name="article_fsn" value="'.$detail->fsn.'" > 
                </div>
            </div>';       
    echo $output;
}
 
public function land_index_add(Request $request)
{   
    $data['product_data'] = Products::get();
    $data['product_type'] = Products_type::get();
    $data['product_spyprice'] = Product_spyprice::get();
    $data['product_group'] = Product_group::get();
    $data['product_unit'] = Product_unit::get();
    $data['users'] = User::get(); 
    $data['article_status'] = Article_status::get(); 
    $data['car_type'] = Car_type::get(); 
    $data['product_brand'] = Product_brand::get(); 
    $data['product_color'] = Product_color::get();
    $data['department_sub_sub'] = Department_sub_sub::orderBy('DEPARTMENT_SUB_SUB_ID','DESC')->get(); 


    $data['data_province'] = DB::table('data_province')->get();
    $data['data_amphur'] = DB::table('data_amphur')->get();
    $data['data_tumbon'] = DB::table('data_tumbon')->get();

    return view('land.land_index_add',$data);
}
public function land_index_save(Request $request)
{    
        $add = new Land();
        $add->land_tonnage_number = $request->input('land_tonnage_number'); 
        $add->land_no = $request->input('land_no'); 
        $add->land_tonnage_no = $request->input('land_tonnage_no'); 
        $add->land_explore_page = $request->input('land_explore_page');
        $add->land_farm_area = $request->input('land_farm_area');
        $add->land_work_area = $request->input('land_work_area');
        $add->land_square_wah_area = $request->input('land_square_wah_area');
        $add->land_date = $request->input('land_date');
        $add->land_holder_name = $request->input('land_holder_name'); 
        $add->land_house_number = $request->input('land_house_number'); 
        $add->store_id = $request->input('store_id'); 
        
        $iduser = $request->input('land_user_id'); 
        if ($iduser != '') {
            $usersave = DB::table('users')->where('id','=',$iduser)->first();
            $add->land_user_id = $usersave->id; 
            $add->land_user_name = $usersave->fname. '  ' .$usersave->lname ; 
        } else {
            $add->land_user_id = ''; 
            $add->land_user_name =''; 
        }

        $proid = $request->input('land_province_location');
        if ($proid != '') {
            $prosave = DB::table('data_province')->where('ID','=',$proid)->first();
            $add->land_province_location = $prosave->ID; 
            $add->land_province_location_name = $prosave->PROVINCE_NAME; 
        }else{
            $add->land_province_location = '';
            $add->land_province_location_name = '';
        }

        $disid = $request->input('land_district_location');
        if ($disid != '') {
            $dissave = DB::table('data_amphur')->where('ID','=',$disid)->first();
            $add->land_district_location = $dissave->ID; 
            $add->land_district_location_name = $dissave->AMPHUR_NAME; 
        }else{
            $add->land_district_location = '';
            $add->land_district_location_name = '';
        }
        
        $tumid = $request->input('land_tumbon_location');
        if ($tumid != '') {
                $tumsave = DB::table('data_tumbon')->where('ID','=',$tumid)->first();
                $add->land_tumbon_location = $tumsave->ID; 
                $add->land_tumbon_location_name = $tumsave->TUMBON_NAME; 
        } else {
            $add->land_tumbon_location = ''; 
            $add->land_tumbon_location_name = ''; 
        }
     
           
        if ($request->hasfile('land_img')) {
            $file = $request->file('land_img');
            $extention = $file->getClientOriginalExtension();
            $filename = time().'.'.$extention;
            // $file->move('uploads/article/',$filename);
            $request->land_img->storeAs('land',$filename,'public');
            // $file->storeAs('article/',$filename);
            $add->land_img = $filename;
            $add->land_img_name = $filename;
        }
       
        $add->save();    
        return response()->json([
            'status'     => '200'
            ]);
}
public function land_index_edit(Request $request,$id)
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
    $data['land_data'] = Land::orderBy('land_id','DESC')->paginate(10);
    $dataedit = Land::where('land_id','=',$id)->first(); 
    $data['users'] = User::get(); 
    return view('land.land_index_edit',$data,[
        'dataedits'=>$dataedit
    ]);
}
public function land_index_update(Request $request)
{      
    $idland = $request->land_id;     
    $update = Land::find($idland);
    $update->land_tonnage_number = $request->input('land_tonnage_number'); 
    $update->land_no = $request->input('land_no'); 
    $update->land_tonnage_no = $request->input('land_tonnage_no'); 
    $update->land_explore_page = $request->input('land_explore_page');
    $update->land_farm_area = $request->input('land_farm_area');
    $update->land_work_area = $request->input('land_work_area');
    $update->land_square_wah_area = $request->input('land_square_wah_area');
    $update->land_date = $request->input('land_date');
    $update->land_holder_name = $request->input('land_holder_name'); 
    $update->land_house_number = $request->input('land_house_number'); 
    $update->store_id = $request->input('store_id');    
    
    $iduser = $request->input('land_user_id'); 
    if ($iduser != '') {
        $usersave = DB::table('users')->where('id','=',$iduser)->first();
        $update->land_user_id = $usersave->id; 
        $update->land_user_name = $usersave->fname. '  ' .$usersave->lname ; 
    } else {
        $update->land_user_id = ''; 
        $update->land_user_name =''; 
    }


    $proid = $request->input('land_province_location');
    if ($proid != '') {
        $prosave = DB::table('data_province')->where('ID','=',$proid)->first();
        $update->land_province_location = $prosave->ID; 
        $update->land_province_location_name = $prosave->PROVINCE_NAME; 
    }else{
        $update->land_province_location = '';
        $update->land_province_location_name = '';
    }

    $disid = $request->input('land_district_location');
    if ($disid != '') {
        $dissave = DB::table('data_amphur')->where('ID','=',$disid)->first();
        $update->land_district_location = $dissave->ID; 
        $update->land_district_location_name = $dissave->AMPHUR_NAME; 
    }else{
        $update->land_district_location = '';
        $update->land_district_location_name = '';
    }
    
    $tumid = $request->input('land_tumbon_location');
    if ($tumid != '') {
            $tumsave = DB::table('data_tumbon')->where('ID','=',$tumid)->first();
            $update->land_tumbon_location = $tumsave->ID; 
            $update->land_tumbon_location_name = $tumsave->TUMBON_NAME; 
    } else {
        $update->land_tumbon_location = ''; 
        $update->land_tumbon_location_name = ''; 
    }
               
    if ($request->hasfile('land_img')) {
        $description = 'storage/land/'.$update->land_img;
        if (File::exists($description))
        {
            File::delete($description);
        }
        $file = $request->file('land_img');
        $extention = $file->getClientOriginalExtension();
        $filename = time().'.'.$extention;
        // $file->move('uploads/article/',$filename);
        $request->land_img->storeAs('land',$filename,'public');
        $update->land_img = $filename;
        $update->land_img_name = $filename;
    }
   
    $update->save(); 
      
    return response()->json([
        'status'     => '200'
        ]);
}
public function land_destroy(Request $request,$id)
{
   $del = Land::find($id);  
   $description = 'storage/land/'.$del->land_img;
   if (File::exists($description)) {
       File::delete($description);
   }
   $del->delete(); 
    return response()->json(['status' => '200','success' => 'Delete Success']);
}
public static function refnumber()
{
    $year = date('Y');
    $maxnumber = DB::table('product_data')->max('product_id');  
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
    $refnumber = 'PRD'.'-'.$ref;
    return $refnumber;
}



}
