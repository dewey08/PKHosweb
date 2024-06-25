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

class ArticleController extends Controller
{

public function article_dashboard(Request $request)
{
    $data['car_index'] = Car_index::leftJoin('car_status','car_index.car_index_status','=','car_status.car_status_code')->orderBy('car_index_id','DESC')
    ->get();
    $data['users'] = User::get();
    $data['book_objective'] = DB::table('book_objective')->get();
    $data['bookrep'] = DB::table('bookrep')->get();
    return view('article.article_dashboard',$data);
}

public function article_index(Request $request)
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
    $data['article_data'] = Article::select('article_id','article_num','article_name','article_decline_name','article_categoryname','article_deb_subsub_name')
    ->orderBy('article_id','DESC')->get();
    return view('article.article_index',$data);
}

public function selectfsn(Request $request)
{
    $detail = DB::table('product_prop')->where('prop_id','=',$request->id)->first();

    $output='<div class="col-md-12">
                <div class="form-group">
                    <input id="article_fsn" type="text" class="form-control" name="article_fsn" value="'.$detail->fsn.'" >
                </div>
            </div>';
    echo $output;
}

public function article_index_add(Request $request)
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

    return view('article.article_index_add',$data);
}
public function article_index_save(Request $request)
{
        $add = new Article();
        $add->article_year = $request->input('article_year');
        $add->article_recieve_date = $request->input('article_recieve_date');
        $add->article_price = $request->input('article_price');
        // $add->article_fsn = $request->input('article_fsn');
        $add->article_num = $request->input('article_num');
        $add->article_name = $request->input('article_name');
        $add->article_attribute = $request->input('article_attribute');
        $add->store_id = $request->input('store_id');
        $add->article_claim = $request->input('article_claim');
        $add->article_used = $request->input('article_used');

        $branid = $request->input('article_brand_id');
        if ($branid != '') {
            $bransave = DB::table('product_brand')->where('brand_id','=',$branid)->first();
            $add->article_brand_id = $bransave->brand_id;
            $add->article_brand_name = $bransave->brand_name;
        }else{
            $add->article_brand_id = '';
            $add->article_brand_name = '';
        }


        $venid = $request->input('vendor_id');
        if ($venid != '') {
            $vensave = DB::table('products_vendor')->where('vendor_id','=',$venid)->first();
            $add->article_vendor_id = $vensave->vendor_id;
            $add->article_vendor_name = $vensave->vendor_name;
        }else{
            $add->article_vendor_id = '';
            $add->article_vendor_name = '';
        }

        $buid = $request->input('article_buy_id');
        if ($buid != '') {
            $buysave = DB::table('product_buy')->where('buy_id','=',$buid)->first();
            $add->article_buy_id = $buysave->buy_id;
            $add->article_buy_name = $buysave->buy_name;
        }else{
            $add->article_buy_id = '';
            $add->article_buy_name = '';
        }

        $decliid = $request->input('article_decline_id');
        if ($decliid != '') {
            $decsave = DB::table('product_decline')->where('decline_id','=',$decliid)->first();
            $add->article_decline_id = $decsave->decline_id;
            $add->article_decline_name = $decsave->decline_name;
        }else{
            $add->article_decline_id = '';
            $add->article_decline_name = '';
        }

        $debid = $request->input('article_deb_subsub_id');
        if ($debid != '') {
            $debsave = DB::table('department_sub_sub')->where('DEPARTMENT_SUB_SUB_ID','=',$debid)->first();
            $add->article_deb_subsub_id = $debsave->DEPARTMENT_SUB_SUB_ID;
            $add->article_deb_subsub_name = $debsave->DEPARTMENT_SUB_SUB_NAME;
        }else{
            $add->article_deb_subsub_id = '';
            $add->article_deb_subsub_name = '';
        }

        $staid = $request->input('article_status_id');
        if ($staid != '') {
                $stasave = DB::table('article_status')->where('article_status_id','=',$staid)->first();
                $add->article_status_id = $stasave->article_status_id;
                $add->article_status_name = $stasave->article_status_name;
        } else {
            $add->article_status_id = '';
            $add->article_status_name = '';
        }

        $uniid = $request->input('article_unit_id');
        if ($uniid != '') {
                $unisave = DB::table('product_unit')->where('unit_id','=',$uniid)->first();
                $add->article_unit_id = $unisave->unit_id;
                $add->article_unit_name = $unisave->unit_name;
        } else {
            $add->article_unit_id = '';
            $add->article_unit_name = '';
        }

        $groupid = $request->input('article_groupid');
        if ($groupid != '') {
                $groupsave = DB::table('product_group')->where('product_group_id','=',$groupid)->first();
                $add->article_groupid = $groupsave->product_group_id;
                $add->article_groupname = $groupsave->product_group_name;
        } else {
            $add->article_groupid = '';
            $add->article_groupname = '';
        }

        $typeid = $request->input('article_typeid');
        if ($typeid != '') {
            $typesave = DB::table('product_type')->where('sub_type_id','=',$typeid)->first();
            $add->article_typeid = $typesave->sub_type_id;
            $add->article_typename = $typesave->sub_type_name;
        } else {
            $add->article_typeid = '';
            $add->article_typename ='';
        }

        $catid = $request->input('article_categoryid');
        if ($catid != '') {
            $catsave = DB::table('product_category')->where('category_id','=',$catid)->first();
            $add->article_categoryid = $catsave->category_id;
            $add->article_categoryname = $catsave->category_name;
        } else {
            $add->article_categoryid = '';
            $add->article_categoryname ='';
        }

        if ($request->hasfile('article_img')) {
            $file = $request->file('article_img');
            $extention = $file->getClientOriginalExtension();
            $filename = time().'.'.$extention;
            // $file->move('uploads/article/',$filename);
            $request->article_img->storeAs('article',$filename,'public');
            // $file->storeAs('article/',$filename);
            $add->article_img = $filename;
            $add->article_img_name = $filename;
        }
        $add->save();
        return response()->json([
            'status'     => '200'
            ]);
}
public function article_index_edit(Request $request,$id)
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
    $data['article_data'] = Article::orderBy('article_id','DESC')->get();
    $data['products_vendor'] = Products_vendor::get();
    $data['product_buy'] = Product_buy::get();
    $data['article_status'] = Article_status::get();
    $data['products_vendor'] = Products_vendor::get();
    $data['product_brand'] = Product_brand::get();
    $dataedit = Article::where('article_id','=',$id)->first();
    $data['car_type'] = DB::table('car_type')->get();
    $data['users_hos'] = DB::table('users_hos')->get();
    return view('article.article_index_edit',$data,[
        'dataedits'=>$dataedit
    ]);
}
public function article_index_update(Request $request)
{
    $idarticle = $request->article_id;
    $update = Article::find($idarticle);
    $update->article_year = $request->input('article_year');
    $update->article_recieve_date = $request->input('article_recieve_date');
    $update->article_price = $request->input('article_price');
    $update->article_fsn = $request->input('article_fsn');
    $update->article_num = $request->input('article_num');
    $update->article_name = $request->input('article_name');
    $update->article_attribute = $request->input('article_attribute');
    $update->store_id = $request->input('store_id');
    $update->article_claim = $request->input('article_claim');
    $update->article_used = $request->input('article_used');
    $update->article_type_id = $request->input('article_type_id');

    $branid = $request->input('article_brand_id');
    if ($branid != '') {
        $bransave = DB::table('product_brand')->where('brand_id','=',$branid)->first();
        $update->article_brand_id = $bransave->brand_id;
        $update->article_brand_name = $bransave->brand_name;
    }else{
        $update->article_brand_id = '';
        $update->article_brand_name = '';
    }

    $venid = $request->input('vendor_id');
    if ($venid != '') {
        $vensave = DB::table('products_vendor')->where('vendor_id','=',$venid)->first();
        $update->article_vendor_id = $vensave->vendor_id;
        $update->article_vendor_name = $vensave->vendor_name;
    }else{
        $update->article_vendor_id = '';
        $update->article_vendor_name = '';
    }

    $buid = $request->input('article_buy_id');
    if ($buid != '') {
        $buysave = DB::table('product_buy')->where('buy_id','=',$buid)->first();
        $update->article_buy_id = $buysave->buy_id;
        $update->article_buy_name = $buysave->buy_name;
    }else{
        $update->article_buy_id = '';
        $update->article_buy_name = '';
    }

    $uniid = $request->input('article_unit_id');
    if ($uniid != '') {
            $unisave = DB::table('product_unit')->where('unit_id','=',$uniid)->first();
            $update->article_unit_id = $unisave->unit_id;
            $update->article_unit_name = $unisave->unit_name;
    } else {
        $update->article_unit_id = '';
        $update->article_unit_name = '';
    }


    $decliid = $request->input('article_decline_id');
    if ($decliid != '') {
        $decsave = DB::table('product_decline')->where('decline_id','=',$decliid)->first();
        $update->article_decline_id = $decsave->decline_id;
        $update->article_decline_name = $decsave->decline_name;
    }else{
        $update->article_decline_id = '';
        $update->article_decline_name = '';
    }

    $debid = $request->input('article_deb_subsub_id');
    if ($debid != '') {
        $debsave = DB::table('department_sub_sub')->where('DEPARTMENT_SUB_SUB_ID','=',$debid)->first();
        $update->article_deb_subsub_id = $debsave->DEPARTMENT_SUB_SUB_ID;
        $update->article_deb_subsub_name = $debsave->DEPARTMENT_SUB_SUB_NAME;
    }else{
        $update->article_deb_subsub_id = '';
        $update->article_deb_subsub_name = '';
    }

    $groupid = $request->input('article_groupid');
    if ($groupid != '') {
            $groupsave = DB::table('product_group')->where('product_group_id','=',$groupid)->first();
            $update->article_groupid = $groupsave->product_group_id;
            $update->article_groupname = $groupsave->product_group_name;
    } else {
        $update->article_groupid = '';
        $update->article_groupname = '';
    }

    $typeid = $request->input('article_typeid');
    if ($typeid != '') {
        $typesave = DB::table('product_type')->where('sub_type_id','=',$typeid)->first();
        $update->article_typeid = $typesave->sub_type_id;
        $update->article_typename = $typesave->sub_type_name;
    } else {
        $update->article_typeid = '';
        $update->article_typename ='';
    }

    $catid = $request->input('article_categoryid');
    if ($catid != '') {
        $catsave = DB::table('product_category')->where('category_id','=',$catid)->first();
        $update->article_categoryid = $catsave->category_id;
        $update->article_categoryname = $catsave->category_name;
    } else {
        $update->article_categoryid = '';
        $update->article_categoryname ='';
    }

    if ($request->hasfile('article_img')) {
        $description = 'storage/article/'.$update->article_img;
        if (File::exists($description))
        {
            File::delete($description);
        }
        $file = $request->file('article_img');
        $extention = $file->getClientOriginalExtension();
        $filename = time().'.'.$extention;
        // $file->move('uploads/article/',$filename);
        $request->article_img->storeAs('article',$filename,'public');
        $update->article_img = $filename;
        $update->article_img_name = $filename;
    }

    $update->save();

    return response()->json([
        'status'     => '200'
        ]);
}
public function article_destroy(Request $request,$id)
{
   $del = Article::find($id);
   $description = 'storage/article/'.$del->article_img;
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

function addunit(Request $request)
{
 if($request->unitnew!= null || $request->unitnew != ''){
     $count_check = Product_unit::where('unit_name','=',$request->unitnew)->count();
        if($count_check == 0){
                $add = new Product_unit();
                $add->unit_name = $request->unitnew;
                $add->save();
        }
        }
            $query =  DB::table('product_unit')->get();
            $output='<option value="">--เลือก--</option>';
            foreach ($query as $row){
                if($request->unitnew == $row->unit_name){
                    $output.= '<option value="'.$row->unit_id.'" selected>'.$row->unit_name.'</option>';
                }else{
                    $output.= '<option value="'.$row->unit_id.'">'.$row->unit_name.'</option>';
                }
        }
    echo $output;
}

function addbrand(Request $request)
{
 if($request->brandnew!= null || $request->brandnew != ''){
            $count_check = Product_brand::where('brand_name','=',$request->brandnew)->count();
            if($count_check == 0){
                    $add = new Product_brand();
                    $add->brand_name = $request->brandnew;
                    $add->save();
            }
        }
            $query =  DB::table('product_brand')->get();
            $output='<option value="">--เลือก--</option>';
            foreach ($query as $row){
                if($request->brandnew == $row->brand_name){
                    $output.= '<option value="'.$row->brand_id.'" selected>'.$row->brand_name.'</option>';
                }else{
                    $output.= '<option value="'.$row->brand_id.'">'.$row->brand_name.'</option>';
                }
        }
    echo $output;
}

}





























// <div class="row mt-3">
//                 <div class="col-md-12">
//                     <div class="form-group">
//                         <input id="article_name" type="text" class="form-control" name="article_name" value="'.$detail->prop_name.'">
//                     </div>
//                 </div>
//             </div>
// public function selectfsn(Request $request,$prop_id)
// {
//    $del = Product_prop::where('prop_id','=',$prop_id)->first();
//    dd($del->fsn);
// //    $del->delete();
//     return response()->json(['status' => '200','success' => 'Delete Success']);
// }
// function detailsupselect(Request $request)
// {
//   $idinven = $request->get('idinven');
//   $count = $request->get('count');
//   $detailwarehousestorereceivesubs = DB::table('warehouse_store')
//   ->where('STORE_TYPE','=',$idinven)->get();
//   $output ='
//   <table class="table-bordered table-striped table-vcenter js-dataTable-simple" style="width: 100%;">
//   <thead style="background-color: #FFEBCD;">
//       <tr>
//            <td style="text-align: center;border: 1px solid black;" width="20%">รหัส</td>
//           <td style="text-align: center;border: 1px solid black;" >รายละเอียด</td>
//           <td style="text-align: center;border: 1px solid black;" width="20%">คงเหลือ</td>
//           <td style="text-align: center;border: 1px solid black;" width="10%">เลือก</td>
//       </tr>
//   </thead>
//   <tbody id="myTable">';
//   foreach ($detailwarehousestorereceivesubs as $detailwarehousestorereceivesub){
//     $lotreceive =  DB::table('warehouse_store_receive_sub')->where('STORE_ID','=',$detailwarehousestorereceivesub->STORE_ID)->sum('RECEIVE_SUB_AMOUNT');
//     $sumlotexport = DB::table('warehouse_store_export_sub')->where('STORE_ID','=',$detailwarehousestorereceivesub->STORE_ID)->sum('EXPORT_SUB_AMOUNT');
//     $amountlot = $lotreceive;
//     $amountexport = $sumlotexport;
//     $total = $amountlot - $amountexport;
//     $output.='  <tr height="20">
//     <td class="text-font text-pedding" style="border: 1px solid black;">'.$detailwarehousestorereceivesub->STORE_CODE.'</td>
//     <td class="text-font text-pedding" style="border: 1px solid black;" align="left" >'.$detailwarehousestorereceivesub->STORE_NAME.'</td>
//     <td class="text-font" style="border: 1px solid black;padding-right:10px;" align="right" >'.$total.'</td>
//     <td class="text-font" style="border: 1px solid black;" align="center" ><button type="button" class="btn btn-hero-sm btn-hero-info"  style="font-family: \'Kanit\', sans-serif; font-size: 10px;font-weight:normal;"  onclick="selectsupreq('.$detailwarehousestorereceivesub->STORE_ID.','.$count.')">เลือก</button></td>
//   </tr>';
//      }
// $output.='</tbody>
// </table>';
//  echo $output;

// }
