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
use App\Models\Building_level;
use App\Models\Building_level_room;
use App\Models\Building_room_type;
use App\Models\Building_type;

use Illuminate\Support\Facades\File;
use DataTables;
use Intervention\Image\ImageManagerStatic as Image;

class BuildingController extends Controller
{  

public function building_index(Request $request)
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
    $data['building_data'] = Building::leftjoin('product_decline','product_decline.decline_id','=','building_data.building_decline_id')->orderBy('building_id','DESC')->get();

    return view('building.building_index',$data);
}

public function building_index_add(Request $request)
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
    $data['building_type'] = Building_type::get(); 

    $data['data_province'] = DB::table('data_province')->get();
    $data['data_amphur'] = DB::table('data_amphur')->get();
    $data['data_tumbon'] = DB::table('data_tumbon')->get();

    return view('building.building_index_add',$data);
}

public function building_index_save(Request $request)
{    
        $add = new Building();
        $add->building_name = $request->input('building_name'); 
        $add->building_budget_price = $request->input('building_budget_price'); 
        $add->building_creation_date = $request->input('building_creation_date');
        $add->building_completion_date = $request->input('building_completion_date');
        $add->building_delivery_date = $request->input('building_delivery_date');
        $add->building_long = $request->input('building_long');
        $add->store_id = $request->input('store_id');  
        $add->building_engineer = $request->input('building_engineer');        

        $iduser = $request->input('building_userid'); 
        if ($iduser != '') {
            $usersave = DB::table('users')->where('id','=',$iduser)->first();
            $add->building_userid = $usersave->id; 
            $add->building_username = $usersave->fname. '  ' .$usersave->lname ; 
        } else {
            $add->building_userid = ''; 
            $add->building_username =''; 
        }

        $lanid = $request->input('building_tonnage_number');
        if ($lanid != '') {
            $landsave = DB::table('land_data')->where('land_id','=',$lanid)->first();
            $add->building_land_id = $landsave->land_id; 
            $add->building_tonnage_number = $landsave->land_tonnage_number; 
        }else{
            $add->building_land_id = '';
            $add->building_tonnage_number = '';
        }

        $budid = $request->input('building_budget_id');
        if ($budid != '') {
            $dissave = DB::table('product_budget')->where('budget_id','=',$budid)->first();
            $add->building_budget_id = $dissave->budget_id; 
            $add->building_budget_name = $dissave->budget_name; 
        }else{
            $add->building_budget_id = '';
            $add->building_budget_name = '';
        }
        
        $meid = $request->input('building_method_id');
        if ($meid != '') {
            $mesave = DB::table('product_method')->where('method_id','=',$meid)->first();
            $add->building_method_id = $mesave->method_id; 
            $add->building_method_name = $mesave->method_name; 
        }else{
            $add->building_method_id = '';
            $add->building_method_name = '';
        }

        $buyid = $request->input('building_buy_id');
        if ($buyid != '') {
            $buysave = DB::table('product_buy')->where('buy_id','=',$buyid)->first();
            $add->building_buy_id = $buysave->buy_id; 
            $add->building_buy_name = $buysave->buy_name; 
        }else{
            $add->building_buy_id = '';
            $add->building_buy_name = '';
        }

        $decliid = $request->input('building_decline_id');
        if ($decliid != '') {
            $decsave = DB::table('product_decline')->where('decline_id','=',$decliid)->first();
            $add->building_decline_id = $decsave->decline_id; 
            $add->building_decline_name = $decsave->decline_name; 
        }else{
            $add->building_decline_id = '';
            $add->building_decline_name = '';
        }
     
        $btypeid = $request->input('building_type_id');
        if ($btypeid != '') {
            $btypesave = DB::table('building_type')->where('building_type_id','=',$btypeid)->first();
            $add->building_type_id = $btypesave->building_type_id; 
            $add->building_type_name = $btypesave->building_type_name; 
        }else{
            $add->building_type_id = '';
            $add->building_type_name = '';
        }
     
           
        if ($request->hasfile('building_img')) {
            $file = $request->file('building_img');
            $extention = $file->getClientOriginalExtension();
            $filename = time().'.'.$extention;
            // $file->move('uploads/article/',$filename);
            $request->building_img->storeAs('building',$filename,'public');
            // $file->storeAs('article/',$filename);
            $add->building_img = $filename;
            $add->building_img_name = $filename;
        }
       
        $add->save();    
        return response()->json([
            'status'     => '200'
            ]);
}
public function building_index_edit(Request $request,$id)
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
    $data['building_data'] = Building::orderBy('building_id','DESC')->get();
    $dataedit = Building::where('building_id','=',$id)->first();
    $data['building_type'] = Building_type::get(); 

    $data['users'] = User::get();  

    return view('building.building_index_edit',$data,[
        'dataedits'=>$dataedit
    ]);
}
public function building_index_update(Request $request)
{      
    $idbuilding = $request->building_id;     
    $update = Building::find($idbuilding);
    $update->building_name = $request->input('building_name'); 
    $update->building_budget_price = $request->input('building_budget_price'); 
    $update->building_creation_date = $request->input('building_creation_date');
    $update->building_completion_date = $request->input('building_completion_date');
    $update->building_delivery_date = $request->input('building_delivery_date');
    $update->building_long = $request->input('building_long');
    $update->store_id = $request->input('store_id');    
    $update->building_engineer = $request->input('building_engineer');    
    
    $iduser = $request->input('building_userid'); 
        if ($iduser != '') {
            $usersave = DB::table('users')->where('id','=',$iduser)->first();
            $update->building_userid = $usersave->id; 
            $update->building_username = $usersave->fname. '  ' .$usersave->lname ; 
        } else {
            $update->building_userid = ''; 
            $update->building_username =''; 
        }

    $lanid = $request->input('building_tonnage_number');
    if ($lanid != '') {
        $landsave = DB::table('land_data')->where('land_id','=',$lanid)->first();
        $update->building_land_id = $landsave->land_id; 
        $update->building_tonnage_number = $landsave->land_tonnage_number; 
    }else{
        $update->building_land_id = '';
        $update->building_tonnage_number = '';
    }

    $budid = $request->input('building_budget_id');
    if ($budid != '') {
        $dissave = DB::table('product_budget')->where('budget_id','=',$budid)->first();
        $update->building_budget_id = $dissave->budget_id; 
        $update->building_budget_name = $dissave->budget_name; 
    }else{
        $update->building_budget_id = '';
        $update->building_budget_name = '';
    }
    
    $meid = $request->input('building_method_id');
    if ($meid != '') {
        $mesave = DB::table('product_method')->where('method_id','=',$meid)->first();
        $update->building_method_id = $mesave->method_id; 
        $update->building_method_name = $mesave->method_name; 
    }else{
        $update->building_method_id = '';
        $update->building_method_name = '';
    }

    $buyid = $request->input('building_buy_id');
    if ($buyid != '') {
        $buysave = DB::table('product_buy')->where('buy_id','=',$buyid)->first();
        $update->building_buy_id = $buysave->buy_id; 
        $update->building_buy_name = $buysave->buy_name; 
    }else{
        $update->building_buy_id = '';
        $update->building_buy_name = '';
    }

    $decliid = $request->input('building_decline_id');
    if ($decliid != '') {
        $decsave = DB::table('product_decline')->where('decline_id','=',$decliid)->first();
        $update->building_decline_id = $decsave->decline_id; 
        $update->building_decline_name = $decsave->decline_name; 
    }else{
        $update->building_decline_id = '';
        $update->building_decline_name = '';
    }

    $btypeid = $request->input('building_type_id');
    if ($btypeid != '') {
        $btypesave = DB::table('building_type')->where('building_type_id','=',$btypeid)->first();
        $update->building_type_id = $btypesave->building_type_id; 
        $update->building_type_name = $btypesave->building_type_name; 
    }else{
        $update->building_type_id = '';
        $update->building_type_name = '';
    }
      

    if ($request->hasfile('building_img')) {
        $description = 'storage/building/'.$update->building_img;
        if (File::exists($description))
        {
            File::delete($description);
        }
        $file = $request->file('building_img');
        $extention = $file->getClientOriginalExtension();
        $filename = time().'.'.$extention;
        // $file->move('uploads/article/',$filename);
        $request->building_img->storeAs('building',$filename,'public');
        $update->building_img = $filename;
        $update->building_img_name = $filename;
    }
   
    $update->save(); 
      
    return response()->json([
        'status'     => '200'
        ]);
}
public function building_destroy(Request $request,$id)
{
   $del = Building::find($id);  
   $description = 'storage/land/'.$del->article_img;
   if (File::exists($description)) {
       File::delete($description);
   }
   $del->delete(); 
    return response()->json(['status' => '200','success' => 'Delete Success']);
}

public function building_addlevel(Request $request,$id)
{  
    $dataedit = Building::where('building_id','=',$id)->first();
    $data['users'] = User::get(); 
    $data['building_level'] = Building_level::where('building_id','=',$id)->get();      

    return view('building.building_addlevel',$data,[
        'dataedits'=>$dataedit
    ]);
}
public function building_addlevelone_save(Request $request)
{    
    $count_check = Building_level::where('building_level_name','=',$request->building_level_name)->where('building_id','=',$request->building_id)->count();  
    // dd($count_check);
    if ($count_check == 0 ) {
        $add = new Building_level();
        $add->building_level_name = $request->input('building_level_name'); 
        $add->building_id = $request->input('building_id');
        $add->save(); 
        return response()->json([
            'status'     => '200'
            ]);
    } else {
        return response()->json([
            'status'     => '0'
            ]);
    }             
}
public function building_addlevel_save(Request $request)
{    
    $level = $request->input('building_level_name'); 
    $a = 1;
    while ($a <= $level) {
        $data2 = array(
            'building_level_name' => $a , $a++,
            'building_id' => $request->building_id
        );
        Building_level::create($data2);
     }
        return response()->json([
                'status'     => '200'
                ]);
    
} 
public function building_leveldestroy(Request $request,$id)
{
   $del = Building_level::find($id); 
   $del->delete(); 

   $delsub = Building_level_room::where('building_level_id','=',$id);
   $delsub->delete(); 
    return response()->json(['status' => '200','success' => 'Delete Success']);
}

public function building_addlevel_room(Request $request,$idbu,$id)
{  

    $dataedit = Building::where('building_id','=',$idbu)->first();
    $data['users'] = User::get(); 
    $data['building_level'] = Building_level::where('building_id','=',$idbu)->get();   

    $dataedit_lev = Building_level::where('building_level_id','=',$id)->first();
    // dd($dataedit_lev->building_level_id);
    
    $data['building_level_room'] = Building_level_room::leftjoin('building_room_type','building_room_type.room_type_id','=','building_level_room.room_type')->where('building_level_id','=',$id)->get(); 

    $data['building_room_type'] = Building_room_type::get(); 

    return view('building.building_addlevel_room',$data,[
        'dataedits'=>$dataedit,
        'dataedit_levs'=>$dataedit_lev,
    ]);
}

public function building_addlevel_room_save(Request $request)
{    
    $count_check = Building_level_room::where('room_name','=',$request->room_name)->where('building_level_id','=',$request->building_level_id)->count(); 
    // $roommeetting_open = $request->input('roommeetting_open'); 
    // dd($roommeetting_open);
    if ($count_check == 0 ) {
        $add = new Building_level_room();
        $add->room_name = $request->input('room_name'); 
        $add->building_level_id = $request->input('building_level_id');
        $add->room_type = $request->input('room_type');
        $add->save(); 
        return response()->json([
            'status'     => '200'
            ]);
    } else {
        return response()->json([
            'status'     => '0'
            ]);
    }             
}
function addroomtype(Request $request)
{     
 if($request->roomtypenew!= null || $request->roomtypenew != ''){    
     $count_check = Building_room_type::where('room_type_name','=',$request->roomtypenew)->count();           
        if($count_check == 0){    
                $add = new Building_room_type(); 
                $add->room_type_name = $request->roomtypenew;
                $add->save(); 
        }
        }
            $query =  DB::table('building_room_type')->get();            
            $output='<option value="">--เลือก--</option>';                
            foreach ($query as $row){
                if($request->roomtypenew == $row->room_type_name){
                    $output.= '<option value="'.$row->room_type_id.'" selected>'.$row->room_type_name.'</option>';
                }else{
                    $output.= '<option value="'.$row->room_type_id.'">'.$row->room_type_name.'</option>';
                }   
        }    
    echo $output;        
}

public function building_levelroomdestroy(Request $request,$id)
{
   $del = Building_level_room::find($id); 
   $del->delete(); 
    return response()->json(['status' => '200','success' => 'Delete Success']);
}
    // dd($level);
    // $number =count($level);
    // dd($number);

        // foreach ($level as $items) {
        //     $nameitem = $items++;
        //     dd($nameitem);
        // }
    //     $i=0;
    // for ($i=0; $i < $level; $i++) { 
    //         $add = new Building_level();
    //         $add->building_level_name = $level[$i]; 
    //         $add->building_id = $request->building_id[$i];
    //         $add->save();    
    //         return response()->json([
    //             'status'     => '200'
    //             ]);
    
    // }
    // for ($j=0; $j < $level; $j++) { 
    //     $add = new Building_level();
    //     $add->building_level_name = $j[$i]; 
    //     $add->building_id = $request->building_id[$i];
    //     $add->save();    
    //     return response()->json([
    //         'status'     => '200'
    //         ]);
    // }     

    //     $p = $i++;
    //     $add = new Building_level();
    //     $add->building_level_name = $p; 
    //     $add->building_id = $request->building_id;
    //     $add->save();    
    //     return response()->json([
    //         'status'     => '200'
    //         ]);
    // }

    // foreach ($level as $items) {

    // }
    // $level = DB::table('gsy_permis')->get();
        // $add = new Building_level();
        // $add->building_level_name = $request->input('building_level_name'); 
        // $add->building_id = $request->input('building_id');
        // $add->save();    
        // return response()->json([
        //     'status'     => '200'
    //     ]);
}

// if($request->PERSON_ID[0] != '' || $request->PERSON_ID[0] != null){
//     $PERSON_ID = $request->PERSON_ID;
//     $number_3 =count($PERSON_ID);
//     $count_3 = 0;
//     for($count_3 = 0; $count_3 < $number_3; $count_3++)
//     {  
//        $add_3 = new Vehiclecarindexperson();
//        $add_3->RESERVE_ID = $RESERVE_ID;
//        $PERSON =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
//        ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
//        ->where('hrd_person.ID','=',$PERSON_ID[$count_3])->first();
//        $add_3->HR_PERSON_ID =  $PERSON->ID;
//        $add_3->HR_FULLNAME =  $PERSON->HR_PREFIX_NAME.''.$PERSON->HR_FNAME.' '.$PERSON->HR_LNAME;
//        $add_3->HR_POSITION =  $PERSON->POSITION_IN_WORK;
//        $add_3->HR_DEPARTMENT_ID = $PERSON->HR_DEPARTMENT_ID;
//        $add_3->HR_LEVEL = $PERSON->HR_LEVEL_ID;
//        $add_3->save();   
//     }
// }

// public function save(Request $request)
// { 
    // $userid = $request->USER_ID;
    // $id =  Person::where('hrd_person.ID','=',$userid)->first();
   
    // Permislist::where('PERSON_ID','=',$id->ID)->delete();

    // $permis = DB::table('gsy_permis')->get();
 
    //     foreach ($permis as $items) {

    //         $nameitem = $items->PERMIS_ID;

    //         $valuepermis = $request->$nameitem;

    //     if ($valuepermis == 'on') {
    //         $addusepermis = new Permislist(); 
    //         $addusepermis->PERSON_ID = $id->ID; 
    //         $addusepermis->PERMIS_ID = $nameitem;  
    //         $addusepermis->save();      
    //     }
    // }
// }
// }
