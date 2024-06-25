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
use App\Models\Medical_borrow;
use App\Models\Land;
use App\Models\Building;
use App\Models\Product_budget;
use App\Models\Product_method;
use App\Models\Product_buy;
use App\Models\Medical_store_borrow;
use App\Models\Medical_store_borrowsub;
use App\Models\Medical_store_night;
use App\Models\Medical_store_nightsub;
use App\Models\Car_location;
use App\Models\Medical_store_repsub;
use App\Models\Medical_store_rep;
use App\Models\Medical_stock;
use App\Models\Medical_store_sub;
use App\Models\Medical_store;
use App\Models\Medical_typecat;
use App\Models\Medical_repaire;

use PDF;
use setasign\Fpdi\Fpdi;
use App\Models\Budget_year;

use Illuminate\Support\Facades\File;
use DataTables;
use Intervention\Image\ImageManagerStatic as Image;

class MedicalController extends Controller
{

    public function med_dashboard(Request $request)
    {
        $data['car_index'] = Car_index::leftJoin('car_status', 'car_index.car_index_status', '=', 'car_status.car_status_code')->orderBy('car_index_id', 'DESC')
            ->get();
        $data['users'] = User::get();
        $data['book_objective'] = DB::table('book_objective')->get();
        $data['bookrep'] = DB::table('bookrep')->get();
        $data['building_data'] = Building::leftjoin('product_decline', 'product_decline.decline_id', '=', 'building_data.building_decline_id')->where('building_type_id', '!=', '1')->where('building_type_id', '!=', '5')->orderBy('building_id', 'DESC')->get();
        $data['article_data'] = Article::where('article_categoryid', '=', '31')->orwhere('article_categoryid', '=', '63')
            ->orderBy('article_id', 'DESC')
            ->get();
        $data['medical_typecat'] = DB::table('medical_typecat')->get();

        return view('medical.med_dashboard', $data);
    }

    public function med_dashboard_detail(Request $request,$id)
    {  
        // $data['med_detail'] =  Medical_borrow::leftjoin('article_data', 'article_data.article_id', '=', 'medical_borrow.medical_borrow_article_id')
        //         ->leftjoin('department_sub_sub', 'department_sub_sub.DEPARTMENT_SUB_SUB_ID', '=', 'medical_borrow.medical_borrow_debsubsub_id')
        //         ->leftjoin('users', 'users.id', '=', 'medical_borrow.medical_borrow_backusers_id')
        //         ->where($id); 
                
                $med_detail = DB::connection('mysql')->select( '
                        SELECT a.article_id,a.article_num,a.article_name
                            ,d.DEPARTMENT_SUB_SUB_NAME,a.article_deb_subsub_id
                            ,a.article_status_id
                            FROM article_data a  
                            LEFT JOIN department_sub_sub d on d.DEPARTMENT_SUB_SUB_ID=a.article_deb_subsub_id
                            WHERE a.article_categoryid="31" AND a.article_status_id = "3"
                            AND a.medical_typecat_id="'.$id. '"
                    '); 
                return view('medical.med_dashboard_detail', [
                    'med_detail'    => $med_detail
                ]);
    }
    public function med_dashboard_night(Request $request,$id)
    {  
         $med_detail = DB::connection('mysql')->select( '
                    SELECT a.article_id,a.article_num,a.article_name
                        ,d.DEPARTMENT_SUB_SUB_NAME,a.article_deb_subsub_id
                        ,a.article_status_id
                        FROM article_data a  
                        LEFT JOIN department_sub_sub d on d.DEPARTMENT_SUB_SUB_ID=a.article_deb_subsub_id
                        WHERE a.article_categoryid="31" AND a.article_status_id = "1"
                        AND a.medical_typecat_id="'.$id. '"
                '); 
            return view('medical.med_dashboard_night', [
                'med_detail'    => $med_detail
            ]);
    }
    public function med_dashboard_repaire(Request $request,$id)
    {  
         $med_detail = DB::connection('mysql')->select( '
                    SELECT a.article_id,a.article_num,a.article_name
                        ,d.DEPARTMENT_SUB_SUB_NAME,a.article_deb_subsub_id
                        ,a.article_status_id
                        FROM article_data a  
                        LEFT JOIN department_sub_sub d on d.DEPARTMENT_SUB_SUB_ID=a.article_deb_subsub_id
                        WHERE a.article_categoryid="31" AND a.article_status_id = "2"
                        AND a.medical_typecat_id="'.$id. '"
                '); 
            return view('medical.med_dashboard_repaire', [
                'med_detail'    => $med_detail
            ]);
    }
    public function med_dashboard_deal(Request $request,$id)
    {  
         $med_detail = DB::connection('mysql')->select( '
                    SELECT a.article_id,a.article_num,a.article_name
                        ,d.DEPARTMENT_SUB_SUB_NAME,a.article_deb_subsub_id
                        ,a.article_status_id
                        FROM article_data a  
                        LEFT JOIN department_sub_sub d on d.DEPARTMENT_SUB_SUB_ID=a.article_deb_subsub_id
                        WHERE a.article_categoryid="31" AND a.article_status_id = "6"
                        AND a.medical_typecat_id="'.$id. '"
                '); 
            return view('medical.med_dashboard_deal', [
                'med_detail'    => $med_detail
            ]);
    }
    
    public function med_con(Request $request)
    {
        $data['article_data'] = Article::where('article_categoryid', '=', '31')->orwhere('article_categoryid', '=', '63')
            ->orderBy('article_id', 'DESC')
            ->get();
        $data['medical_typecat'] = DB::table('medical_typecat')->get();
        return view('medical.med_con', $data);
    }
    public function med_consave(Request $request)
    {
        $add = new Medical_typecat();
        $add->medical_typecatname = $request->input('medical_typecatname');
        if ($request->hasfile('img')) {
            $file = $request->file('img');
            $extention = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extention;
            // $file->move('uploads/article/',$filename);
            $request->img->storeAs('article', $filename, 'public');
            // $file->storeAs('article/',$filename);
            $add->img = $filename;
            $add->img_name = $filename;
        }
        $add->save();
        return response()->json([
            'status'     => '200'
        ]);
    }
    public function med_con_edit(Request $request,$id)
    {         
        $dataedit = Medical_typecat::where('medical_typecat_id','=',$id)->first(); 
        $data['medical_typecat'] = DB::table('medical_typecat')->get();
        return view('medical.med_con_edit',$data,[
            'dataedits'=>$dataedit
        ]);
    }
    public function med_con_update(Request $request)
    {
        $id = $request->medical_typecat_id;
        $update =Medical_typecat::find($id);
        $update->medical_typecatname = $request->input('medical_typecatname');
        if ($request->hasfile('img')) {
            $description = 'storage/article/'.$update->img;
            if (File::exists($description))
            {
                File::delete($description);
            }
            $file = $request->file('img');
            $extention = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extention;
            // $file->move('uploads/article/',$filename);
            $request->img->storeAs('article', $filename, 'public');
            // $file->storeAs('article/',$filename);
            $update->img = $filename;
            $update->img_name = $filename;
        }
        // if ($request->hasfile('article_img')) {
        //     $description = 'storage/article/'.$update->article_img;
        //     if (File::exists($description))
        //     {
        //         File::delete($description);
        //     }
        //     $file = $request->file('article_img');
        //     $extention = $file->getClientOriginalExtension();
        //     $filename = time().'.'.$extention;
        //     // $file->move('uploads/article/',$filename);
        //     $request->article_img->storeAs('article',$filename,'public');
        //     $update->article_img = $filename;
        //     $update->article_img_name = $filename;
        // }
        $update->save();
        return response()->json([
            'status'     => '200'
        ]);
    }
    public function med_condestroy(Request $request,$id)
    {
        $del = Medical_typecat::find($id);  
        $description = 'storage/article/'.$del->img;
        if (File::exists($description)) {
            File::delete($description);
        }
        $del->delete(); 
            return response()->json(['status' => '200']);
    }

    public function med_store(Request $request)
    {
        $data['article_data'] = Article::where('article_categoryid', '=', '31')->orwhere('article_categoryid', '=', '63')
            ->orderBy('article_id', 'DESC')
            ->get();
        $data['medical_typecat'] = DB::table('medical_typecat')->get();
        $data['budget_year'] = DB::table('budget_year')->get();
        $count = DB::connection('mysql')->select('   
            SELECT count(medical_typecat_id) as tcount FROM article_data  
        ');
        $datarep = DB::connection('mysql')->select('   
            SELECT * FROM medical_store_rep m
            left join medical_typecat mt on mt.medical_typecat_id = m.medical_typecat_id
            left join users u on u.id = m.user_rep
        ');
        $data_sumqty = DB::table('medical_stock')->sum('qty');
        return view('medical.med_store', $data,[
            'datarep'    =>  $datarep
        ]);
    }
    public function med_store_save(Request $request)
    {
        $add = new Medical_store_rep();
        $add->year = $request->input('year');
        $add->date_rep = $request->input('date_rep');
        $add->time_rep = $request->input('time_rep');
        $add->medical_typecat_id = $request->input('medical_typecat_id');
        $add->user_rep = $request->input('user_rep');
        $add->save();
        return response()->json([
            'status'     => '200'
        ]);
    }
   
    public function med_store_add(Request $request,$id)
    {         
        // $dataedit = Medical_typecat::where('medical_typecat_id','=',$id)->first(); 

        $data['article_data'] = Article::where('medical_typecat_id', '=',$id)
        // ->where('article_categoryid', '=', '31')->orwhere('article_categoryid', '=', '63')
        ->orderBy('article_id', 'DESC')
        ->get();

        $data['medical_typecat'] = DB::table('medical_typecat')->get();
        // $count = DB::connection('mysql')->select('   
        //     SELECT count(medical_typecat_id) as tcount FROM article_data 
        //     where medical_typecat_id = "'.$id.'"  
        // ');
        // $data['medical_store_repsub'] = DB::table('medical_store_repsub')
        // ->orderBy('medical_store_repsub_id', 'DESC')->get();

        $data_repsub = DB::connection('mysql')->select('   
            SELECT ms.article_id,a.article_num,a.article_name,ms.qty,u.unit_name 
            FROM medical_stock ms
          
            left join article_data a on a.article_id = ms.article_id
            left join product_unit u on u.unit_id = ms.article_unit_id
            where ms.medical_typecat_id="'.$id.'"
        ');
        // medical_store_repsub ms
         $count = DB::connection('mysql')->select('   
            SELECT count(article_id) as tcount FROM medical_stock  
        ');
        // where medical_typecat_id = "'.$id.'"  
        return view('medical.med_store_add',$data,[
            // 'dataedits'  => $dataedit,
            'data_repsub' => $data_repsub,
            'id'         => $id
        ]);
    }
    public function med_store_subsave(Request $request)
    {
        $id = $request->input('article_id');
        $article = Article::where('article_id','=',$id)->first(); 
        $rep_id = $request->input('medical_store_rep_id');

        $ddy = $article->article_id;
        // dd($ddy);
        $add = new Medical_store_repsub();
        $add->medical_store_rep_id = $rep_id;
        $add->article_id = $article->article_id;
       
        $add->article_unit_id = $article->article_unit_id;
        $add->qty = '1';
        $add->price = $article->article_price; 
        $add->total = $article->article_price * 1;
        $add->save();

        $add2 = new Medical_stock();
        $add2->medical_typecat_id = $article->medical_typecat_id; 
        $add2->article_id = $article->article_id; 
        $add2->article_unit_id = $article->article_unit_id; 

        // $qt = Medical_stock::where('article_id','=',$ddy)
        // // ->where('article_id','=',$article->article_id)
        // ->first();
        // // $ddg = $qt->qty;
        // dd($qt);
        // if ($qt->qty == null ) {
        //    $qtu = 0;
        // } else {
        //     $qtu = $qt->qty;
        // }
        
        $add2->qty = 1; 
        $add2->price = $article->article_price; 
        $add2->total = $article->article_price * 1;

        // $add2->total_qty = $qt->qty + $qt->total_qty;
        $add2->save();
 
        $qt = Medical_store_rep::where('medical_store_rep_id','=',$rep_id)->first();
        Medical_store_rep::where('medical_store_rep_id', $rep_id) 
                        ->update([  
                            'total_qty'    => $qt->total_qty + 1,
                            'total_price'  => $qt->total_price + $article->article_price
                        ]);

        // $qt = Medical_stock::where('article_id','=',$ddy)->first();
        // Medical_stock::where('article_id', $qt->article_id) 
        // ->update([  
        //     // 'qty'    => $qt->qty + 1,
        //     'price'  => $qt->price + $article->article_price,
        //     'total'  => $qt->total_price + $qt->price + $article->article_price
        // ]);

        return response()->json([
            'status'     => '200'
        ]);
    }
   
    public function medical_stock(Request $request,$id)
    {
        $dataedit = Medical_typecat::where('medical_typecat_id','=',$id)->first(); 

        $data['article_data'] = Article::where('medical_typecat_id', '=', $dataedit->medical_typecat_id)
        ->orderBy('article_id', 'DESC')
        ->get();

        $data['medical_typecat'] = DB::table('medical_typecat')->get();
        $count = DB::connection('mysql')->select('   
            SELECT count(medical_typecat_id) as tcount FROM article_data 
            where medical_typecat_id = "'.$id.'"  
        ');
        $data['budget_year'] = DB::table('budget_year')->get();

        return view('medical.medical_stock', $data,[
            'dataedits'  => $dataedit,
            'id'         => $id
        ]);
    }

    public function med_store_rep(Request $request,$id)
    { 
        $medical_typecat = DB::table('medical_typecat')->where('medical_typecat_id','=',$id)->first();
        $data['budget_year'] = DB::table('budget_year')->get();
        $count = DB::connection('mysql')->select('   
            SELECT count(medical_typecat_id) as tcount FROM article_data  
        ');
        $datarep = DB::connection('mysql')->select('   
            SELECT * FROM medical_store_rep m
            left join medical_typecat mt on mt.medical_typecat_id = m.medical_typecat_id
            left join users u on u.id = m.user_rep
        ');
        $data_stock = DB::connection('mysql')->select('   
            SELECT * FROM medical_stock m
            left join medical_typecat mt on mt.medical_typecat_id = m.medical_typecat_id
            left join article_data ad on ad.article_id = m.article_id 
            where m.medical_typecat_id = "'.$id.'"
        ');
        // $data['article_data'] = DB::table('article_data')->get();
        $data['article_data'] = Article::where('article_categoryid', '=', '31')
        ->where('medical_typecat_id','=',$medical_typecat->medical_typecat_id)
        // ->orwhere('article_categoryid', '=', '63')
        ->orderBy('article_id', 'DESC')
        ->get();
        $data_sumqty = DB::table('medical_stock')->sum('qty');
        return view('medical.med_store_rep', $data,[
            'datarep'          =>  $datarep,
            'data_stock'       =>  $data_stock,
            'medical_typecat'  => $medical_typecat
        ]);
    }

    public function med_store_repsave(Request $request)
    {
        $id = $request->input('article_id');
        $article = Article::where('article_id','=',$id)->first(); 
        // $rep_id = $request->input('medical_store_rep_id');

        // $ddy = $article->article_id;
        $check = Medical_stock::where('article_id','=',$id)->count();
        if ($check > 0) {
            // Medical_stock::where('article_id', $id) 
            // ->update([  
            //     'total_qty'    => 'total_qty' + 1,
            //     'total_price'  => 'total_price' + $article->article_price * 1
            // ]);
            return response()->json([
                'status'     => '100'
            ]);
        } else { 
            $date = date('Y-m-d');
            $add = new Medical_store_repsub();
            // $add->medical_store_rep_id = $rep_id;
            $add->daterep = $date;
            $add->article_id = $article->article_id;
        
            $add->article_unit_id = $article->article_unit_id;
            $add->qty = '1';
            $add->price = $article->article_price; 
            $add->total = $article->article_price * 1;
            $add->save();

            $add2 = new Medical_stock();
            $add2->medical_typecat_id = $article->medical_typecat_id; 
            $add2->article_id = $article->article_id; 
            $add2->article_unit_id = $article->article_unit_id; 
    
            $add2->qty = 1; 
            $add2->price = $article->article_price; 
            $add2->total = $article->article_price * 1; 
            $add2->total_qty = 1; 
            $add2->save();
               
            return response()->json([
                'status'     => '200'
            ]);
        }
    }
 
    public function med_index(Request $request)
    {
        $data['department_sub_sub'] = Department_sub_sub::get();
        $data['product_decline'] = Product_decline::get();
        $data['product_prop'] = Product_prop::get();
        $data['supplies_prop'] = DB::table('supplies_prop')->get();
        $data['budget_year'] = DB::table('budget_year')->orderBy('leave_year_id', 'DESC')->get();
        $data['product_data'] = Products::get();
        $data['product_category'] = Products_category::get();
        $data['product_type'] = Products_type::get();
        $data['product_spyprice'] = Product_spyprice::get();
        $data['product_group'] = Product_group::get();
        $data['product_unit'] = Product_unit::get();
        // $data['article_data'] = Article::get();
        $data['data_province'] = DB::table('data_province')->get();
        $data['data_amphur'] = DB::table('data_amphur')->get();
        $data['data_tumbon'] = DB::table('data_tumbon')->get();
        $data['land_data'] = Land::get();
        $data['product_budget'] = Product_budget::get();
        $data['product_method'] = Product_method::get();
        $data['product_buy'] = Product_buy::get();
        $data['building_data'] = Building::leftjoin('product_decline', 'product_decline.decline_id', '=', 'building_data.building_decline_id')->where('building_type_id', '!=', '1')->where('building_type_id', '!=', '5')->orderBy('building_id', 'DESC')->get();
        $data['article_data'] = Article::where('article_categoryid', '=', '31')->orwhere('article_categoryid', '=', '63')
            ->leftjoin('department_sub_sub', 'department_sub_sub.DEPARTMENT_SUB_SUB_ID', '=', 'article_data.article_deb_subsub_id')
            // ->groupBy('medical_typecat_id')
            ->orderBy('medical_typecat_id', 'DESC')
            ->get();
        $data['medical_typecat'] = DB::table('medical_typecat')->get();

        return view('medical.med_index', $data);
    }

    public function med_add(Request $request)
    {
        $data['article_data'] = Article::where('article_categoryid', '=', '31')->orwhere('article_categoryid', '=', '63')->where('article_status_id', '=', '1')
            ->orderBy('article_id', 'DESC')
            ->get();
        $data['department_sub_sub'] = Department_sub_sub::get();
        $data['article_status'] = Article_status::get();
        $data['product_decline'] = Product_decline::get();
        $data['product_prop'] = Product_prop::get();
        $data['supplies_prop'] = DB::table('supplies_prop')->get();
        $data['budget_year'] = DB::table('budget_year')->orderBy('leave_year_id', 'DESC')->get();
        $data['product_data'] = Products::get();
        $data['product_category'] = Products_category::get();
        $data['product_type'] = Products_type::get();
        $data['product_spyprice'] = Product_spyprice::get();
        $data['product_group'] = Product_group::get();
        $data['product_unit'] = Product_unit::get();
        $data['data_province'] = DB::table('data_province')->get();
        $data['data_amphur'] = DB::table('data_amphur')->get();
        $data['data_tumbon'] = DB::table('data_tumbon')->get();
        $data['land_data'] = Land::get();
        $data['product_budget'] = Product_budget::get();
        $data['product_method'] = Product_method::get();
        $data['product_buy'] = Product_buy::get();
        $data['users'] = User::get();

        $data['products_vendor'] = Products_vendor::get();
        $data['product_brand'] = Product_brand::get();
        $data['medical_typecat'] = DB::table('medical_typecat')->get();

        return view('medical.med_add', $data);
    }
    public function med_save(Request $request)
    {
        $add = new Article();
        $add->article_year = $request->input('article_year');
        $add->article_recieve_date = $request->input('article_recieve_date');
        $add->article_price = $request->input('article_price');
        $add->medical_typecat_id = $request->input('medical_typecat_id');
        $add->article_num = $request->input('article_num');
        $add->article_name = $request->input('article_name');
        $add->article_attribute = $request->input('article_attribute');
        $add->store_id = $request->input('store_id');
        $add->article_claim = $request->input('article_claim');
        $add->article_used = $request->input('article_used');

        $branid = $request->input('article_brand_id');
        if ($branid != '') {
            $bransave = DB::table('product_brand')->where('brand_id', '=', $branid)->first();
            $add->article_brand_id = $bransave->brand_id;
            $add->article_brand_name = $bransave->brand_name;
        } else {
            $add->article_brand_id = '';
            $add->article_brand_name = '';
        }


        $venid = $request->input('vendor_id');
        if ($venid != '') {
            $vensave = DB::table('products_vendor')->where('vendor_id', '=', $venid)->first();
            $add->article_vendor_id = $vensave->vendor_id;
            $add->article_vendor_name = $vensave->vendor_name;
        } else {
            $add->article_vendor_id = '';
            $add->article_vendor_name = '';
        }

        $buid = $request->input('article_buy_id');
        if ($buid != '') {
            $buysave = DB::table('product_buy')->where('buy_id', '=', $buid)->first();
            $add->article_buy_id = $buysave->buy_id;
            $add->article_buy_name = $buysave->buy_name;
        } else {
            $add->article_buy_id = '';
            $add->article_buy_name = '';
        }

        $decliid = $request->input('article_decline_id');
        if ($decliid != '') {
            $decsave = DB::table('product_decline')->where('decline_id', '=', $decliid)->first();
            $add->article_decline_id = $decsave->decline_id;
            $add->article_decline_name = $decsave->decline_name;
        } else {
            $add->article_decline_id = '';
            $add->article_decline_name = '';
        }

        $debid = $request->input('article_deb_subsub_id');
        if ($debid != '') {
            $debsave = DB::table('department_sub_sub')->where('DEPARTMENT_SUB_SUB_ID', '=', $debid)->first();
            $add->article_deb_subsub_id = $debsave->DEPARTMENT_SUB_SUB_ID;
            $add->article_deb_subsub_name = $debsave->DEPARTMENT_SUB_SUB_NAME;
        } else {
            $add->article_deb_subsub_id = '';
            $add->article_deb_subsub_name = '';
        }

        $staid = $request->input('article_status_id');
        if ($staid != '') {
            $stasave = DB::table('article_status')->where('article_status_id', '=', $staid)->first();
            $add->article_status_id = $stasave->article_status_id;
            $add->article_status_name = $stasave->article_status_name;
        } else {
            $add->article_status_id = '';
            $add->article_status_name = '';
        }

        $uniid = $request->input('article_unit_id');
        if ($uniid != '') {
            $unisave = DB::table('product_unit')->where('unit_id', '=', $uniid)->first();
            $add->article_unit_id = $unisave->unit_id;
            $add->article_unit_name = $unisave->unit_name;
        } else {
            $add->article_unit_id = '';
            $add->article_unit_name = '';
        }

        $groupid = $request->input('article_groupid');
        if ($groupid != '') {
            $groupsave = DB::table('product_group')->where('product_group_id', '=', $groupid)->first();
            $add->article_groupid = $groupsave->product_group_id;
            $add->article_groupname = $groupsave->product_group_name;
        } else {
            $add->article_groupid = '';
            $add->article_groupname = '';
        }

        $typeid = $request->input('article_typeid');
        if ($typeid != '') {
            $typesave = DB::table('product_type')->where('sub_type_id', '=', $typeid)->first();
            $add->article_typeid = $typesave->sub_type_id;
            $add->article_typename = $typesave->sub_type_name;
        } else {
            $add->article_typeid = '';
            $add->article_typename = '';
        }

        $catid = $request->input('article_categoryid');
        if ($catid != '') {
            $catsave = DB::table('product_category')->where('category_id', '=', $catid)->first();
            $add->article_categoryid = $catsave->category_id;
            $add->article_categoryname = $catsave->category_name;
        } else {
            $add->article_categoryid = '';
            $add->article_categoryname = '';
        }

        if ($request->hasfile('article_img')) {
            $file = $request->file('article_img');
            $extention = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extention;
            // $file->move('uploads/article/',$filename);
            $request->article_img->storeAs('article', $filename, 'public');
            // $file->storeAs('article/',$filename);
            $add->article_img = $filename;
            $add->article_img_name = $filename;
        }
        $add->save();
        return response()->json([
            'status'     => '200'
        ]);
    }
    public function med_edit(Request $request, $id)
    {
        $data['department_sub_sub'] = Department_sub_sub::get();
        $data['product_decline'] = Product_decline::get();
        $data['product_prop'] = Product_prop::get();
        $data['supplies_prop'] = DB::table('supplies_prop')->get();
        $data['budget_year'] = DB::table('budget_year')->orderBy('leave_year_id', 'DESC')->get();
        $data['product_data'] = Products::get();
        $data['product_category'] = Products_category::get();
        $data['product_type'] = Products_type::get();
        $data['product_spyprice'] = Product_spyprice::get();
        $data['product_group'] = Product_group::get();
        $data['product_unit'] = Product_unit::get();
        $data['article_data'] = Article::orderBy('article_id', 'DESC')->get();
        $data['products_vendor'] = Products_vendor::get();
        $data['product_buy'] = Product_buy::get();
        $data['article_status'] = Article_status::get();
        $data['products_vendor'] = Products_vendor::get();
        $data['product_brand'] = Product_brand::get();
        $dataedit = Article::where('article_id', '=', $id)->first();
        $data['medical_typecat'] = DB::table('medical_typecat')->get();
        return view('medical.med_edit', $data, [
            'dataedits' => $dataedit
        ]);
    }
    public function med_update(Request $request)
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
        $update->medical_typecat_id = $request->input('medical_typecat_id');
        $update->store_id = $request->input('store_id');
        $update->article_claim = $request->input('article_claim');
        $update->article_used = $request->input('article_used');
        $update->article_status_id = $request->input('article_status_id');

        $branid = $request->input('article_brand_id');
        if ($branid != '') {
            $bransave = DB::table('product_brand')->where('brand_id', '=', $branid)->first();
            $update->article_brand_id = $bransave->brand_id;
            $update->article_brand_name = $bransave->brand_name;
        } else {
            $update->article_brand_id = '';
            $update->article_brand_name = '';
        }

        $venid = $request->input('vendor_id');
        if ($venid != '') {
            $vensave = DB::table('products_vendor')->where('vendor_id', '=', $venid)->first();
            $update->article_vendor_id = $vensave->vendor_id;
            $update->article_vendor_name = $vensave->vendor_name;
        } else {
            $update->article_vendor_id = '';
            $update->article_vendor_name = '';
        }

        $buid = $request->input('article_buy_id');
        if ($buid != '') {
            $buysave = DB::table('product_buy')->where('buy_id', '=', $buid)->first();
            $update->article_buy_id = $buysave->buy_id;
            $update->article_buy_name = $buysave->buy_name;
        } else {
            $update->article_buy_id = '';
            $update->article_buy_name = '';
        }

        $uniid = $request->input('article_unit_id');
        if ($uniid != '') {
            $unisave = DB::table('product_unit')->where('unit_id', '=', $uniid)->first();
            $update->article_unit_id = $unisave->unit_id;
            $update->article_unit_name = $unisave->unit_name;
        } else {
            $update->article_unit_id = '';
            $update->article_unit_name = '';
        }


        $decliid = $request->input('article_decline_id');
        if ($decliid != '') {
            $decsave = DB::table('product_decline')->where('decline_id', '=', $decliid)->first();
            $update->article_decline_id = $decsave->decline_id;
            $update->article_decline_name = $decsave->decline_name;
        } else {
            $update->article_decline_id = '';
            $update->article_decline_name = '';
        }

        $debid = $request->input('article_deb_subsub_id');
        if ($debid != '') {
            $debsave = DB::table('department_sub_sub')->where('DEPARTMENT_SUB_SUB_ID', '=', $debid)->first();
            $update->article_deb_subsub_id = $debsave->DEPARTMENT_SUB_SUB_ID;
            $update->article_deb_subsub_name = $debsave->DEPARTMENT_SUB_SUB_NAME;
        } else {
            $update->article_deb_subsub_id = '';
            $update->article_deb_subsub_name = '';
        }

        $groupid = $request->input('article_groupid');
        if ($groupid != '') {
            $groupsave = DB::table('product_group')->where('product_group_id', '=', $groupid)->first();
            $update->article_groupid = $groupsave->product_group_id;
            $update->article_groupname = $groupsave->product_group_name;
        } else {
            $update->article_groupid = '';
            $update->article_groupname = '';
        }

        $typeid = $request->input('article_typeid');
        if ($typeid != '') {
            $typesave = DB::table('product_type')->where('sub_type_id', '=', $typeid)->first();
            $update->article_typeid = $typesave->sub_type_id;
            $update->article_typename = $typesave->sub_type_name;
        } else {
            $update->article_typeid = '';
            $update->article_typename = '';
        }

        $catid = $request->input('article_categoryid');
        if ($catid != '') {
            $catsave = DB::table('product_category')->where('category_id', '=', $catid)->first();
            $update->article_categoryid = $catsave->category_id;
            $update->article_categoryname = $catsave->category_name;
        } else {
            $update->article_categoryid = '';
            $update->article_categoryname = '';
        }

        if ($request->hasfile('article_img')) {
            $description = 'storage/article/' . $update->article_img;
            if (File::exists($description)) {
                File::delete($description);
            }
            $file = $request->file('article_img');
            $extention = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extention;
            // $file->move('uploads/article/',$filename);
            $request->article_img->storeAs('article', $filename, 'public');
            $update->article_img = $filename;
            $update->article_img_name = $filename;
        }

        $update->save();

        return response()->json([
            'status'     => '200'
        ]);
    }
    public function med_repair(Request $request)
    {
        $data['department_sub_sub'] = Department_sub_sub::get();
        $data['product_decline'] = Product_decline::get();
        $data['product_prop'] = Product_prop::get();
        $data['supplies_prop'] = DB::table('supplies_prop')->get();
        $data['budget_year'] = DB::table('budget_year')->orderBy('leave_year_id', 'DESC')->get();
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
        $data['building_data'] = Building::leftjoin('product_decline', 'product_decline.decline_id', '=', 'building_data.building_decline_id')->where('building_type_id', '!=', '1')->where('building_type_id', '!=', '5')->orderBy('building_id', 'DESC')->get();
        return view('medical.med_repair', $data);
    }
    public function med_report(Request $request)
    {
        $data['department_sub_sub'] = Department_sub_sub::get();
        $data['product_decline'] = Product_decline::get();
        $data['product_prop'] = Product_prop::get();
        $data['supplies_prop'] = DB::table('supplies_prop')->get();
        $data['budget_year'] = DB::table('budget_year')->orderBy('leave_year_id', 'DESC')->get();
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
        $data['building_data'] = Building::leftjoin('product_decline', 'product_decline.decline_id', '=', 'building_data.building_decline_id')->where('building_type_id', '!=', '1')->where('building_type_id', '!=', '5')->orderBy('building_id', 'DESC')->get();
        return view('medical.med_report', $data);
    }
    public function med_calenda(Request $request)
    {
        $ye = date('Y');
        $y = date('Y') + 543;
        $m = date('m');
        $d = date('d');
        $lotthai = $y . '-' . $m . '-' . $d;
        $loten = $ye . '-' . $m . '-' . $d;
        $data['budget_year'] = Budget_year::where('leave_year_id', '=', $y)->get();
        $data['users'] = User::get();

        $event = array();
        $medical = Medical_borrow::leftjoin('department_sub_sub', 'department_sub_sub.DEPARTMENT_SUB_SUB_ID', '=', 'medical_borrow.medical_borrow_debsubsub_id')
            ->get();

        foreach ($medical as $item) {
            // if ($item->medical_borrow_active == 'REQUEST') {
            //     $color = 'rgb(230, 143, 103)';
            // } elseif ($item->medical_borrow_active == 'SENDEB') {
            //     $color = 'rgb(137, 183, 235)';
            // } elseif ($item->medical_borrow_active == 'APPROVE') {
            //     $color = 'rgb(89, 196, 162)';
            // } elseif ($item->medical_borrow_active == 'cancel') {
            //     $color = '#ff0606';
            // } else {
            //     $color = '#499BFA';
            // }
            $color = $item->DSS_COLOR;
            $datestart = $item->medical_borrow_date;
            $backdate = $item->medical_borrow_backdate;
            $iddep = $item->DEPARTMENT_SUB_SUB_ID;
            $showtitle = $item->DEPARTMENT_SUB_SUB_NAME;
            // if ($showtitle_ == 'งานการพยาบาลผู้ป่วยหนัก ICU1') {
            //     $showtitle = 'rgb(230, 143, 103)';
            // } else {
            //     $showtitle = '';
            // }
            
           
            $event[] = [
                'id' => $item->medical_borrow_id,
                'title' => $showtitle,
                'start' => $datestart,
                'end' => $backdate,
                'color' => $color
            ];
        }

        return view('medical.med_calenda', $data, [
            'events'     =>  $event,
            // 'dataedits'  =>  $dataedit
        ]);
    }
    public function med_calenda_detail(Request $request,$id)
    {  
        $med_calenda =  Medical_borrow::leftjoin('article_data', 'article_data.article_id', '=', 'medical_borrow.medical_borrow_article_id')
                ->leftjoin('department_sub_sub', 'department_sub_sub.DEPARTMENT_SUB_SUB_ID', '=', 'medical_borrow.medical_borrow_debsubsub_id')
                ->leftjoin('users', 'users.id', '=', 'medical_borrow.medical_borrow_backusers_id')
                ->find($id);  
            return response()->json([
                'status'         => '200',
                'med_calenda'    =>  $med_calenda, 
                ]);
    }
    public function med_borrow(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์  
        $newDate = date('Y-m-d', strtotime($date . ' -1 months')); //ย้อนหลัง 1 เดือน 
        $data['users'] = User::get();
        $data['article_data'] = Article::where('article_categoryid', '=', '31')->orwhere('article_categoryid', '=', '63')->where('article_status_id', '=', '1')
            ->orderBy('article_id', 'DESC')
            ->get();

        $data['department_sub_sub'] = Department_sub_sub::get();
        // $data['medical_borrow'] = DB::table('medical_borrow')
        // ->leftjoin('article_data','article_data.article_id','=','medical_borrow.medical_borrow_article_id')
        // ->leftjoin('department_sub_sub','department_sub_sub.DEPARTMENT_SUB_SUB_ID','=','medical_borrow.medical_borrow_debsubsub_id')
        // ->orderBy('medical_borrow_id','DESC')->get();
        // if ($startdate == '' || $enddate = '') {

            $data['medical_borrow'] = DB::connection('mysql')->select('
            select m.medical_borrow_id,m.medical_borrow_active,m.medical_borrow_date,m.medical_borrow_backdate,a.article_deb_subsub_id
            ,a.article_name,d.DEPARTMENT_SUB_SUB_NAME,m.medical_borrow_qty,m.medical_borrow_debsubsub_id
            ,m.medical_borrow_users_id,m.medical_borrow_backusers_id,a.article_num,m.medical_borrow_article_id
            from medical_borrow m
            LEFT JOIN article_data a on a.article_id =m.medical_borrow_article_id
            LEFT JOIN department_sub_sub d on d.DEPARTMENT_SUB_SUB_ID=a.article_deb_subsub_id
            
            where m.medical_borrow_date between "' . $newDate . '" AND "' . $date . '"
        
            ');
            //     } else {
            //         $data['medical_borrow'] = DB::connection('mysql')->select('
            //     select m.medical_borrow_id,m.medical_borrow_active,m.medical_borrow_date,m.medical_borrow_backdate
            //     ,a.article_name,d.DEPARTMENT_SUB_SUB_NAME,m.medical_borrow_qty,m.medical_borrow_debsubsub_id
            //     ,m.medical_borrow_users_id,m.medical_borrow_backusers_id,a.article_num,m.medical_borrow_article_id
            //     from medical_borrow m
            //     LEFT JOIN article_data a on a.article_id =m.medical_borrow_article_id
            //     LEFT JOIN department_sub_sub d on d.DEPARTMENT_SUB_SUB_ID=m.medical_borrow_debsubsub_id
                
            //     where m.medical_borrow_date between "' . $startdate . '" AND "' . $enddate . '"
                
            // ');
            //     }
            // return $request->all();
                // return 'OK';
        return view('medical/med_borrow', $data, [
            'startdate'         =>  $startdate,
            'enddate'           =>  $enddate,
        ]);
    }

    public function med_borrow_search(Request $request)
    {
        // if(!empty($request->_token)){
        //     // $search = $request->search;
        //     $startdate = $request->startdate;
        //     $enddate = $request->enddate;
        //     session(['medical.med_borrow'=> $startdate]);
        //     session(['medical.med_borrow'=> $enddate]);
        // }elseif(!empty(session('medical.med_borrow'))){
        //     $startdate = session('medical.med_borrow');
        //     $enddate = session('medical.med_borrow');
        // }else{
        //     $startdate = '';
        //     $enddate = '';
        // }
        $startdate = $request->startdate;
        $enddate = $request->enddate;

        $data['users'] = User::get();
        $data['article_data'] = Article::where('article_categoryid', '=', '31')->orwhere('article_categoryid', '=', '63')->where('article_status_id', '=', '1')
            ->orderBy('article_id', 'DESC')
            ->get();

        $data['department_sub_sub'] = Department_sub_sub::get();
        // $data['medical_borrow'] = DB::table('medical_borrow')
        // ->leftjoin('article_data','article_data.article_id','=','medical_borrow.medical_borrow_article_id')
        // ->leftjoin('department_sub_sub','department_sub_sub.DEPARTMENT_SUB_SUB_ID','=','medical_borrow.medical_borrow_debsubsub_id')
        // ->orderBy('medical_borrow_id','DESC')->get();
        $data['medical_borrow'] = DB::connection('mysql')->select('
                select m.medical_borrow_id,m.medical_borrow_active,m.medical_borrow_date,m.medical_borrow_backdate
                ,a.article_name,d.DEPARTMENT_SUB_SUB_NAME,m.medical_borrow_qty,m.medical_borrow_debsubsub_id
                ,m.medical_borrow_users_id,m.medical_borrow_backusers_id,a.article_num,m.medical_borrow_article_id
                from medical_borrow m
                LEFT JOIN article_data a on a.article_id =m.medical_borrow_article_id
                LEFT JOIN department_sub_sub d on d.DEPARTMENT_SUB_SUB_ID=m.medical_borrow_debsubsub_id
                
                where m.medical_borrow_date between "' . $startdate . '" AND "' . $enddate . '"
                
        ');

        return view('medical.med_borrow', $data, [
            'startdate'         =>  $startdate,
            'enddate'           =>  $enddate,
        ]);
    }
    public function med_borrowsave(Request $request)
    {
        $date = date("Y-m-d H:i:s");
        $artcle = $request->medical_borrow_article_id;
        $artcleid = Article::where('article_id', '=', $artcle)->first();

        DB::table('medical_borrow')->insert([
            'medical_borrow_date' => $request->medical_borrow_date,
            'medical_borrow_article_id' => $artcle,
            'medical_borrow_typecat_id' => $artcleid->medical_typecat_id,
            'medical_borrow_qty' => $request->medical_borrow_qty,

            'medical_borrow_fromdebsubsub_id' => $artcleid->article_deb_subsub_id,

            'medical_borrow_debsubsub_id' => $request->medical_borrow_debsubsub_id,
            'medical_borrow_users_id' => $request->medical_borrow_users_id,
            'created_at' => $date,
            'updated_at' => $date
        ]);
        return response()->json([
            'status'     => '200',
        ]);
    }
    public function med_borrowDataupdate(Request $request)
    {
        $id = $request->medical_borrow_id;
        $artcle = $request->medical_borrow_article_id;
        $artcleid = Article::where('article_id', '=', $artcle)->first();

        Medical_borrow::where('medical_borrow_id', $id)
            ->update([
                'medical_borrow_date'           => $request->medical_borrow_date,
                'medical_borrow_article_id'     => $artcle,
                'medical_borrow_typecat_id'    => $artcleid->medical_typecat_id,
                'medical_borrow_qty'            => $request->medical_borrow_qty,
                'medical_borrow_debsubsub_id'   => $request->medical_borrow_debsubsub_id
            ]);

        return response()->json([
            'status'     => '200'
        ]);
    }

    public function med_borrowupdate_Noalert(Request $request)
    {
        $id = $request->medical_borrow_id;
        // $startdate = $request->startdate;
        // $enddate = $request->enddate;
        $artcle = $request->medical_borrow_article_id;
        $artcleid = Article::where('article_id', '=', $artcle)->first();

        Medical_borrow::where('medical_borrow_id', $id)
            ->update([
                'medical_borrow_date'             => $request->medical_borrow_date,
                'medical_borrow_article_id'       => $artcle,
                'medical_borrow_typecat_id'       => $artcleid->medical_typecat_id,
                'medical_borrow_qty'              => $request->medical_borrow_qty,
                'medical_borrow_debsubsub_id'     => $request->medical_borrow_debsubsub_id
            ]);

        $data['users'] = User::get();
        $data['article_data'] = Article::where('article_categoryid', '=', '31')->orwhere('article_categoryid', '=', '63')->where('article_status_id', '=', '1')
            ->orderBy('article_id', 'DESC')
            ->get();

        $data['department_sub_sub'] = Department_sub_sub::get();
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์  
        $newDate = date('Y-m-d', strtotime($date . ' -1 months')); //ย้อนหลัง 1 เดือน 

            $data['medical_borrow'] = DB::connection('mysql')->select('
                select m.medical_borrow_id,m.medical_borrow_active,m.medical_borrow_date,m.medical_borrow_backdate
                ,a.article_name,d.DEPARTMENT_SUB_SUB_NAME,m.medical_borrow_qty,m.medical_borrow_debsubsub_id
                ,m.medical_borrow_users_id,m.medical_borrow_backusers_id,a.article_num,m.medical_borrow_article_id
                from medical_borrow m
                LEFT JOIN article_data a on a.article_id =m.medical_borrow_article_id
                LEFT JOIN department_sub_sub d on d.DEPARTMENT_SUB_SUB_ID=m.medical_borrow_debsubsub_id
                
                where m.medical_borrow_date between "' . $newDate . '" AND "' . $date . '"
            
            ');
    
        // return redirect()->back();
        return redirect()->route('med.med_borrow');
        // return view('medical.med_borrow', $data, [
        //     'startdate'         =>  $startdate,
        //     'enddate'           =>  $enddate,
        // ]);
    }
    public function med_borrowedit(Request $request, $id)
    {
        $borrow =  Medical_borrow::leftjoin('article_data', 'article_data.article_id', '=', 'medical_borrow.medical_borrow_article_id')
            ->leftjoin('department_sub_sub', 'department_sub_sub.DEPARTMENT_SUB_SUB_ID', '=', 'medical_borrow.medical_borrow_debsubsub_id')
            ->leftjoin('users', 'users.id', '=', 'medical_borrow.medical_borrow_backusers_id')
            ->find($id);

        return response()->json([
            'status'    => '200',
            'borrow'    =>  $borrow
        ]);
    }
    public function med_borroweditpage(Request $request, $id)
    {
        $borrow =  Medical_borrow::leftjoin('article_data', 'article_data.article_id', '=', 'medical_borrow.medical_borrow_article_id')
            ->leftjoin('department_sub_sub', 'department_sub_sub.DEPARTMENT_SUB_SUB_ID', '=', 'medical_borrow.medical_borrow_debsubsub_id')
            ->leftjoin('users', 'users.id', '=', 'medical_borrow.medical_borrow_backusers_id')
            ->where('medical_borrow_id','=',$id)
            ->first();

        $data['department_sub_sub'] = Department_sub_sub::get();
        $data['users'] = User::get();
        $data['article_data'] = Article::where('article_categoryid', '=', '31')->orwhere('article_categoryid', '=', '63')->where('article_status_id', '=', '1')
            ->orderBy('article_id', 'DESC')
            ->get();

        return view('medical.med_borroweditpage',$data,[ 
            'borrow'    =>  $borrow
        ]);
    }

    public function med_borrowedit2(Request $request, $id)
    {
        $borrow =  Medical_borrow::leftjoin('article_data', 'article_data.article_id', '=', 'medical_borrow.medical_borrow_article_id')
            ->leftjoin('department_sub_sub', 'department_sub_sub.DEPARTMENT_SUB_SUB_ID', '=', 'medical_borrow.medical_borrow_debsubsub_id')
            ->leftjoin('users', 'users.id', '=', 'medical_borrow.medical_borrow_backusers_id')
            ->find($id);

        return response()->json([
            'status'    => '200',
            'borrow'    =>  $borrow
        ]);
    }
    public function med_borrowupdate(Request $request)
    {
        $id = $request->medical_borrow_id;
        $medical_borrowdate = $request->medical_borrow_date;
        $medical_borrowbackdate = $request->medical_borrow_backdate;
        $medical_borrowbackusers_id = $request->medical_borrow_backusers_id;
        Medical_borrow::where('medical_borrow_id', $id)
            ->update([
                'medical_borrow_date'                  => $medical_borrowdate,
                'medical_borrow_backdate'              => $medical_borrowbackdate,
                'medical_borrow_backusers_id'          => $medical_borrowbackusers_id,
                'medical_borrow_active'                => 'SENDEB'
            ]);

        $article = Medical_borrow::where('medical_borrow_id', $id)->first();

        $iddepsubsubtrue = DB::table('department_sub_sub')->where('DEPARTMENT_SUB_SUB_ID', '=', $article->medical_borrow_fromdebsubsub_id)->first();

        Article::where('article_id', $article->medical_borrow_article_id)
            ->update([
                'article_deb_subsub_id'  => $iddepsubsubtrue->DEPARTMENT_SUB_SUB_ID,
                'article_deb_subsub_name'  => $iddepsubsubtrue->DEPARTMENT_SUB_SUB_NAME,
                'article_status_id'        => '3'
            ]);

        return response()->json([
            'status'     => '200'
        ]);
    }
    public function med_borrowupdate_status(Request $request, $id)
    {

        Medical_borrow::where('medical_borrow_id', $id)
            ->update([
                'medical_borrow_active'  => 'APPROVE'
            ]);

        $article = Medical_borrow::where('medical_borrow_id', $id)->first();

        $iddepsubsubtrue = DB::table('department_sub_sub')->where('DEPARTMENT_SUB_SUB_ID', '=', $article->medical_borrow_debsubsub_id)->first();

        Article::where('article_id', $article->medical_borrow_article_id)
            ->update([
                'article_deb_subsub_id'    => $article->medical_borrow_debsubsub_id,
                'article_deb_subsub_name'  => $iddepsubsubtrue->DEPARTMENT_SUB_SUB_NAME,
                'article_status_id'        => '1'
            ]);


        return response()->json([
            'status'     => '200'
        ]);
    }
    public function med_rep1(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $typecat_id = $request->medical_typecat_id;
        $deb_subsub_id = $request->article_deb_subsub_id;
        $status_id = $request->article_status_id;

        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์  
        $newDate = date('Y-m-d', strtotime($date . ' -1 months')); //ย้อนหลัง 1 เดือน 

        $data['budget_year'] = DB::table('budget_year')->orderBy('leave_year_id', 'DESC')->get();
        $data['article_data'] = Article::get();
        $data['medical_typecat'] = DB::table('medical_typecat')->get();
        $data['department_sub_sub'] = Department_sub_sub::get();
        $data['article_status'] = Article_status::get();

        $data['medical_borrow'] = DB::connection('mysql')->select('    
            SELECT a.article_num,a.article_name,
            ABS(DATEDIFF(medical_borrow_date,medical_borrow_backdate)) AS Days
            ,ast.article_status_name as STATUS
            ,d.DEPARTMENT_SUB_SUB_NAME
            ,m.medical_borrow_date,m.medical_borrow_backdate,a.article_status_id,m.medical_borrow_active,m.medical_borrow_id
            FROM medical_borrow m
            LEFT JOIN article_data a on a.article_id = m.medical_borrow_article_id
            LEFT JOIN article_status ast on ast.article_status_id = a.article_status_id
            LEFT JOIN department_sub_sub d on d.DEPARTMENT_SUB_SUB_ID=m.medical_borrow_debsubsub_id 
            WHERE datediff(curdate(),medical_borrow_date)
        ');
        // select m.medical_borrow_id,m.medical_borrow_active,m.medical_borrow_date,m.medical_borrow_backdate
        // ,a.article_name,d.DEPARTMENT_SUB_SUB_NAME,m.medical_borrow_qty,m.medical_borrow_debsubsub_id,a.article_num
        // ,m.medical_borrow_users_id,m.medical_borrow_backusers_id,a.medical_typecat_id,a.article_status_id
        // from medical_borrow m
        // LEFT JOIN article_data a on a.article_id = m.medical_borrow_article_id
        // LEFT JOIN department_sub_sub d on d.DEPARTMENT_SUB_SUB_ID=m.medical_borrow_debsubsub_id    
        // where m.medical_borrow_date between "' . $newDate . '" AND "' . $date . '"    

        return view('medical.med_rep1', $data, [
            'startdate'         =>  $startdate,
            'enddate'           =>  $enddate,
            'typecat_id'        =>  $typecat_id,
            'deb_subsub_id'     =>  $deb_subsub_id,
            'status_id'         =>  $status_id
        ]);
    }

    public function med_borrowdestroy(Request $request, $id)
    {
        $del = Medical_borrow::find($id);
        $del->delete();
        return response()->json(['status' => '200']);
    }
    public function med_rep1_search(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $typecat_id = $request->medical_typecat_id;
        $deb_subsub_id = $request->article_deb_subsub_id;
        $status_id = $request->article_status_id;

        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์  
        $newDate = date('Y-m-d', strtotime($date . ' -1 months')); //ย้อนหลัง 1 เดือน 
        // $newDate = date('Y-m-d', strtotime($date . ' 1 months')); // 1 เดือน 
        // return $request->all();
        // dd( $typecat_id);
        $data['budget_year'] = DB::table('budget_year')->orderBy('leave_year_id', 'DESC')->get();
        $data['article_data'] = Article::get();
        $data['medical_typecat'] = DB::table('medical_typecat')->get();
        $data['department_sub_sub'] = Department_sub_sub::get();
        $data['article_status'] = Article_status::get();
        $data['department_sub_sub'] = Department_sub_sub::get();
  
 
        if ($startdate != '' && $enddate != '') {
            $data['medical_borrow'] = DB::connection('mysql')->select('   
                    SELECT a.article_num,a.article_name,
                    ABS(DATEDIFF(medical_borrow_date,medical_borrow_backdate)) AS Days
                    ,ast.article_status_name as STATUS
                    ,d.DEPARTMENT_SUB_SUB_NAME
                    ,m.medical_borrow_date,m.medical_borrow_backdate,a.article_status_id,m.medical_borrow_active,m.medical_borrow_id
                    FROM medical_borrow m
                    LEFT JOIN article_data a on a.article_id = m.medical_borrow_article_id
                    LEFT JOIN article_status ast on ast.article_status_id = a.article_status_id
                    LEFT JOIN department_sub_sub d on d.DEPARTMENT_SUB_SUB_ID=m.medical_borrow_debsubsub_id 
                    WHERE datediff(curdate(),medical_borrow_date)
                    AND m.medical_borrow_date between "' . $startdate . '" AND "' . $enddate . '" 
            ');
        } else if ($typecat_id != "" && $deb_subsub_id != "") {
            $data['medical_borrow'] = DB::connection('mysql')->select('
            SELECT a.article_num,a.article_name,
                    ABS(DATEDIFF(medical_borrow_date,medical_borrow_backdate)) AS Days
                    ,ast.article_status_name as STATUS
                    ,d.DEPARTMENT_SUB_SUB_NAME
                    ,m.medical_borrow_date,m.medical_borrow_backdate,a.article_status_id,m.medical_borrow_active,m.medical_borrow_id
                    FROM medical_borrow m
                    LEFT JOIN article_data a on a.article_id = m.medical_borrow_article_id
                    LEFT JOIN article_status ast on ast.article_status_id = a.article_status_id
                    LEFT JOIN department_sub_sub d on d.DEPARTMENT_SUB_SUB_ID=m.medical_borrow_debsubsub_id 
                    WHERE datediff(curdate(),medical_borrow_date)
                    
                    AND a.medical_typecat_id ="' . $typecat_id . '"
                    AND m.medical_borrow_debsubsub_id ="' . $deb_subsub_id .'"
                
            ');
        } else if ($startdate != '' && $enddate != '' && $typecat_id != '') {
            $data['medical_borrow'] = DB::connection('mysql')->select('  
                    SELECT a.article_num,a.article_name,
                    ABS(DATEDIFF(medical_borrow_date,medical_borrow_backdate)) AS Days
                    ,ast.article_status_name as STATUS
                    ,d.DEPARTMENT_SUB_SUB_NAME
                    ,m.medical_borrow_date,m.medical_borrow_backdate,a.article_status_id,m.medical_borrow_active,m.medical_borrow_id
                    ,a.medical_typecat_id
                    FROM medical_borrow m
                    LEFT JOIN article_data a on a.article_id = m.medical_borrow_article_id
                    LEFT JOIN article_status ast on ast.article_status_id = a.article_status_id
                    LEFT JOIN department_sub_sub d on d.DEPARTMENT_SUB_SUB_ID=m.medical_borrow_debsubsub_id 
                    WHERE datediff(curdate(),medical_borrow_date)
                    AND m.medical_borrow_date between "' . $startdate . '" AND "' . $enddate . '" 
                    AND a.medical_typecat_id = "' . $typecat_id . '"
            ');
        } else if ($typecat_id != '') {
            $data['medical_borrow'] = DB::connection('mysql')->select('
                     
                    SELECT a.article_num,a.article_name,
                    ABS(DATEDIFF(medical_borrow_date,medical_borrow_backdate)) AS Days
                    ,ast.article_status_name as STATUS
                    ,d.DEPARTMENT_SUB_SUB_NAME
                    ,m.medical_borrow_date,m.medical_borrow_backdate,a.article_status_id,m.medical_borrow_active,m.medical_borrow_id
                    FROM medical_borrow m
                    LEFT JOIN article_data a on a.article_id = m.medical_borrow_article_id
                    LEFT JOIN article_status ast on ast.article_status_id = a.article_status_id
                    LEFT JOIN department_sub_sub d on d.DEPARTMENT_SUB_SUB_ID=m.medical_borrow_debsubsub_id 
                    WHERE datediff(curdate(),medical_borrow_date)
              
                    AND a.medical_typecat_id = "' . $typecat_id . '"
            ');
       
        } else if ($deb_subsub_id != '') {
            $data['medical_borrow'] = DB::connection('mysql')->select('
                    SELECT a.article_num,a.article_name,
                    ABS(DATEDIFF(medical_borrow_date,medical_borrow_backdate)) AS Days
                    ,ast.article_status_name as STATUS
                    ,d.DEPARTMENT_SUB_SUB_NAME
                    ,m.medical_borrow_date,m.medical_borrow_backdate,a.article_status_id,m.medical_borrow_active,m.medical_borrow_id
                    FROM medical_borrow m
                    LEFT JOIN article_data a on a.article_id = m.medical_borrow_article_id
                    LEFT JOIN article_status ast on ast.article_status_id = a.article_status_id
                    LEFT JOIN department_sub_sub d on d.DEPARTMENT_SUB_SUB_ID=m.medical_borrow_debsubsub_id 
                    WHERE datediff(curdate(),medical_borrow_date)
          
                    AND m.medical_borrow_debsubsub_id = "' . $deb_subsub_id . '" 
            ');
        // } elseif ($status_id != '') {
        //     $data['medical_borrow'] = DB::connection('mysql')->select('
        //             select m.medical_borrow_id,m.medical_borrow_active,m.medical_borrow_date,m.medical_borrow_backdate
        //             ,a.article_name,d.DEPARTMENT_SUB_SUB_NAME,m.medical_borrow_qty,m.medical_borrow_debsubsub_id
        //             ,m.medical_borrow_users_id,m.medical_borrow_backusers_id,a.article_num,a.medical_typecat_id,a.article_status_id
        //             from medical_borrow m
        //             LEFT JOIN article_data a on a.article_id =m.medical_borrow_article_id
        //             LEFT JOIN department_sub_sub d on d.DEPARTMENT_SUB_SUB_ID=m.medical_borrow_debsubsub_id   
        //             where a.article_status_id = "' . $status_id . '" 
                               
        //     ');
        } else {
            $data['medical_borrow'] = DB::connection('mysql')->select('
            SELECT a.article_num,a.article_name,
                    ABS(DATEDIFF(medical_borrow_date,medical_borrow_backdate)) AS Days
                    ,ast.article_status_name as STATUS
                    ,d.DEPARTMENT_SUB_SUB_NAME
                    ,m.medical_borrow_date,m.medical_borrow_backdate,a.article_status_id,m.medical_borrow_active,m.medical_borrow_id
                    FROM medical_borrow m
                    LEFT JOIN article_data a on a.article_id = m.medical_borrow_article_id
                    LEFT JOIN article_status ast on ast.article_status_id = a.article_status_id
                    LEFT JOIN department_sub_sub d on d.DEPARTMENT_SUB_SUB_ID=m.medical_borrow_debsubsub_id 
                    WHERE datediff(curdate(),medical_borrow_date)
                     
                
            ');
        }

      return view('medical.med_rep1', $data, [
            'startdate'         =>  $startdate,
            'enddate'           =>  $enddate,
            'typecat_id'        =>  $typecat_id,
            'deb_subsub_id'     =>  $deb_subsub_id,
            'status_id'         =>  $status_id
        ]);
    }
    public function med_rep2(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $typecat_id = $request->medical_typecat_id;
        $deb_subsub_id = $request->article_deb_subsub_id;
        $status_id = $request->article_status_id;

        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์  
        $newDate = date('Y-m-d', strtotime($date . ' -1 months')); //ย้อนหลัง 1 เดือน 

        $data['budget_year'] = DB::table('budget_year')->orderBy('leave_year_id', 'DESC')->get();
        $data['article_data'] = Article::get();
        $data['medical_typecat'] = DB::table('medical_typecat')->get();
        $data['department_sub_sub'] = Department_sub_sub::get();
        $data['article_status'] = Article_status::get();

        $data['medical_borrow'] = DB::connection('mysql')->select('
        select m.medical_borrow_id,m.medical_borrow_active,m.medical_borrow_date,m.medical_borrow_backdate
            ,a.article_name,d.DEPARTMENT_SUB_SUB_NAME,m.medical_borrow_qty,m.medical_borrow_debsubsub_id,a.article_num
            ,m.medical_borrow_users_id,m.medical_borrow_backusers_id,a.medical_typecat_id,a.article_status_id
            ,m.medical_borrow_typecat_id,mt.medical_typecatname
            from medical_borrow m
            LEFT JOIN article_data a on a.article_id = m.medical_borrow_article_id
            LEFT JOIN department_sub_sub d on d.DEPARTMENT_SUB_SUB_ID = m.medical_borrow_debsubsub_id 
            LEFT JOIN medical_typecat mt on mt.medical_typecat_id = m.medical_borrow_typecat_id   
            where m.medical_borrow_date between "' . $startdate . '" AND "' . $enddate . '"     
        ');
        $medical_typecat = DB::connection('mysql')->select('select * from medical_typecat');
       
        // foreach ($medical_typecat as $key => $value) {
        //     $counttype = DB::table('medical_borrow')->where('medical_borrow_typecat_id','=',$value->medical_typecat_id);
        // }

        return view('medical.med_rep2', $data, [
            'startdate'         =>  $startdate,
            'enddate'           =>  $enddate,
            'typecat_id'        =>  $typecat_id,
            'deb_subsub_id'     =>  $deb_subsub_id,
            'status_id'         =>  $status_id,
            'medical_typecat'   =>  $medical_typecat
        ]);
    }
    public function med_rep2_search(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $typecat_id = $request->medical_typecat_id;
        $deb_subsub_id = $request->article_deb_subsub_id;
        $status_id = $request->article_status_id;

        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์  
        $newDate = date('Y-m-d', strtotime($date . ' -1 months')); //ย้อนหลัง 1 เดือน 

        $data['budget_year'] = DB::table('budget_year')->orderBy('leave_year_id', 'DESC')->get();
        $data['article_data'] = Article::get();
        $data['medical_typecat'] = DB::table('medical_typecat')->get();
        $data['department_sub_sub'] = Department_sub_sub::get();
        $data['article_status'] = Article_status::get();

        $data['medical_borrow'] = DB::connection('mysql')->select('
        select m.medical_borrow_id,m.medical_borrow_active,m.medical_borrow_date,m.medical_borrow_backdate
            ,a.article_name,d.DEPARTMENT_SUB_SUB_NAME,m.medical_borrow_qty,m.medical_borrow_debsubsub_id,a.article_num
            ,m.medical_borrow_users_id,m.medical_borrow_backusers_id,a.medical_typecat_id,a.article_status_id
            ,m.medical_borrow_typecat_id,mt.medical_typecatname
            from medical_borrow m
            LEFT JOIN article_data a on a.article_id = m.medical_borrow_article_id
            LEFT JOIN department_sub_sub d on d.DEPARTMENT_SUB_SUB_ID = m.medical_borrow_debsubsub_id 
            LEFT JOIN medical_typecat mt on mt.medical_typecat_id = m.medical_borrow_typecat_id   
            where m.medical_borrow_date between "' . $startdate . '" AND "' . $enddate . '"     
        ');
        $medical_typecat = DB::connection('mysql')->select('select * from medical_typecat');
       
      
        return view('medical.med_rep2', $data, [
            'startdate'         =>  $startdate,
            'enddate'           =>  $enddate,
            'typecat_id'        =>  $typecat_id,
            'deb_subsub_id'     =>  $deb_subsub_id,
            'status_id'         =>  $status_id,
            'medical_typecat'   =>  $medical_typecat
        ]);
    }
    public function med_rep3(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $typecat_id = $request->medical_typecat_id;
        $deb_subsub_id = $request->article_deb_subsub_id;
        $status_id = $request->article_status_id;
        
        // $ar = Article::where('article_categoryid', '=', '31')->orwhere('article_categoryid', '=', '63')->get();
    
        // $medical_deb = DB::connection('mysql')->select('
        //     select DEPARTMENT_SUB_SUB_ID,DEPARTMENT_SUB_SUB_NAME,a.article_deb_subsub_id
        //     from department_sub_sub d
        //     LEFT JOIN article_data a on a.article_deb_subsub_id =d.DEPARTMENT_SUB_SUB_ID
        //     GROUP BY a.article_deb_subsub_id
        //     ');

        // $medical_borrow = DB::connection('mysql')->select('
        //         select m.medical_borrow_id,m.medical_borrow_active,m.medical_borrow_date,m.medical_borrow_backdate
        //         ,d.DEPARTMENT_SUB_SUB_NAME,m.medical_borrow_qty,m.medical_borrow_debsubsub_id,m.medical_borrow_fromdebsubsub_id
        //         ,m.medical_borrow_users_id,m.medical_borrow_backusers_id, m.medical_borrow_article_id
        //         from medical_borrow m 
        //         LEFT JOIN department_sub_sub d on d.DEPARTMENT_SUB_SUB_ID=m.medical_borrow_debsubsub_id  
        //         GROUP BY d.DEPARTMENT_SUB_SUB_NAME
        //     ');

        //     $startdate = $request->startdate;
        //     $enddate = $request->enddate;
        //     $typecat_id = $request->medical_typecat_id;
        //     $deb_subsub_id = $request->article_deb_subsub_id;
        //     $status_id = $request->article_status_id;

            $date = date('Y-m-d');
            // $y = date('Y') + 543;
            // $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์  
            $newDate = date('Y-m-d', strtotime($date . ' -2 months')); //ย้อนหลัง 2 เดือน 

            // $data['budget_year'] = DB::table('budget_year')->orderBy('leave_year_id', 'DESC')->get();
            // $data['article_data'] = Article::get();
            // $data['medical_typecat'] = DB::table('medical_typecat')->get();
            // $data['department_sub_sub'] = Department_sub_sub::get();
            // $data['article_status'] = Article_status::get();


            // $data['medical_borrow_rep3'] = DB::connection('mysql')->select('
            // select m.medical_borrow_id,m.medical_borrow_active,m.medical_borrow_date,m.medical_borrow_backdate
            //     ,a.article_name,d.DEPARTMENT_SUB_SUB_NAME,m.medical_borrow_qty,m.medical_borrow_debsubsub_id,a.article_num
            //     ,m.medical_borrow_users_id,m.medical_borrow_backusers_id,a.medical_typecat_id,a.article_status_id
            //     from medical_borrow m
            //     LEFT JOIN article_data a on a.article_id = m.medical_borrow_article_id
            //     LEFT JOIN department_sub_sub d on d.DEPARTMENT_SUB_SUB_ID=m.medical_borrow_debsubsub_id    
            //     where m.medical_borrow_date between "' . $date . '" AND "' . $date . '"     
            // ');


            // WHERE datediff(curdate(),medical_borrow_date) >=14 

            // dd($newDate);
 
        if ($startdate == null || $enddate == null) {
            $medical_borrow_rep3 = DB::connection('mysql')->select('
                SELECT a.article_num,a.article_name,
                    ABS(DATEDIFF(medical_borrow_date,medical_borrow_backdate)) AS Days,d.DEPARTMENT_SUB_SUB_NAME
                    ,m.medical_borrow_date,m.medical_borrow_backdate,m.medical_borrow_id
                    FROM medical_borrow m
                    LEFT JOIN article_data a on a.article_id = m.medical_borrow_article_id
                    LEFT JOIN department_sub_sub d on d.DEPARTMENT_SUB_SUB_ID=m.medical_borrow_debsubsub_id 
                    where m.medical_borrow_date between "'.$newDate.'" AND "'.$date.'" 
                ');
        } else {
            $medical_borrow_rep3 = DB::connection('mysql')->select('
                SELECT a.article_num,a.article_name,
                    ABS(DATEDIFF(medical_borrow_date,medical_borrow_backdate)) AS Days,d.DEPARTMENT_SUB_SUB_NAME
                    ,m.medical_borrow_date,m.medical_borrow_backdate,m.medical_borrow_id
                    FROM medical_borrow m
                    LEFT JOIN article_data a on a.article_id = m.medical_borrow_article_id
                    LEFT JOIN department_sub_sub d on d.DEPARTMENT_SUB_SUB_ID=m.medical_borrow_debsubsub_id 
                    where m.medical_borrow_date between "' . $startdate . '" AND "' . $enddate . '" 
                ');
        }
         

            // foreach ($medical_borrow_rep3 as $key => $value) {
            //         // $date = date('Y-m-d');
            //         $d = date('d');
            //         $datestart = $value->medical_borrow_date;
            //         $newDatestart = date('Y-m-d', strtotime($datestart));
            //         $newDatestart2 = date('d', strtotime($datestart));
            //         $dateend = $value->medical_borrow_backdate;

            //         $countdateold =   round(abs(strtotime(date('Y-m-d')) - strtotime($value->medical_borrow_date))/60/60/24)+1; 
            //         $datestartss = strtotime($value->medical_borrow_date);
                    
            //         $total = DB::table('medical_borrow')
            //         ->whereBetween('medical_borrow_date', [$newDatestart, $date])->count(); 

            //             $start = strtotime($value->medical_borrow_date);
            //             $end = strtotime($date);
            //             $tot = ($end - $start) / 25200; 
                    
            //         if ($dateend == '') {
            //             $newDatetotal = $countdateold; 
            //         } else {      
            //             $newDateend  = date('d', strtotime($dateend));                                  
            //             $newDatetotal  = $newDateend - $newDatestart2;
            //         } 
            // }
        return view('medical.med_rep3',[
            'startdate'         =>  $startdate,
            'enddate'           =>  $enddate,
            'typecat_id'        =>  $typecat_id,
            'deb_subsub_id'     =>  $deb_subsub_id,
            'status_id'         =>  $status_id,
            'medical_borrow_rep3'       =>  $medical_borrow_rep3,
            // 'newDatetotal'  =>  $newDatetotal
        ]);
    }


    public function med_rep1_excel(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $typecat_id = $request->medical_typecat_id;
        $deb_subsub_id = $request->article_deb_subsub_id;
        $status_id = $request->article_status_id;

        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์  
        $newDate = date('Y-m-d', strtotime($date . ' -1 months')); //ย้อนหลัง 1 เดือน 

        $data['budget_year'] = DB::table('budget_year')->orderBy('leave_year_id', 'DESC')->get();
        $data['article_data'] = Article::get();
        $data['medical_typecat'] = DB::table('medical_typecat')->get();
        $data['department_sub_sub'] = Department_sub_sub::get();
        $data['article_status'] = Article_status::get();

        if ($startdate != '' && $enddate != '') {
            $data['medical_borrow'] = DB::connection('mysql')->select('   
                    SELECT a.article_num,a.article_name,
                    ABS(DATEDIFF(medical_borrow_date,medical_borrow_backdate)) AS Days
                    ,ast.article_status_name as STATUS
                    ,d.DEPARTMENT_SUB_SUB_NAME
                    ,m.medical_borrow_date,m.medical_borrow_backdate,a.article_status_id,m.medical_borrow_active,m.medical_borrow_id
                    FROM medical_borrow m
                    LEFT JOIN article_data a on a.article_id = m.medical_borrow_article_id
                    LEFT JOIN article_status ast on ast.article_status_id = a.article_status_id
                    LEFT JOIN department_sub_sub d on d.DEPARTMENT_SUB_SUB_ID=m.medical_borrow_debsubsub_id 
                    WHERE datediff(curdate(),medical_borrow_date)
                    AND m.medical_borrow_date between "' . $startdate . '" AND "' . $enddate . '" 
            ');
        } else if ($typecat_id != "" && $deb_subsub_id != "") {
            $data['medical_borrow'] = DB::connection('mysql')->select('
            SELECT a.article_num,a.article_name,
                    ABS(DATEDIFF(medical_borrow_date,medical_borrow_backdate)) AS Days
                    ,ast.article_status_name as STATUS
                    ,d.DEPARTMENT_SUB_SUB_NAME
                    ,m.medical_borrow_date,m.medical_borrow_backdate,a.article_status_id,m.medical_borrow_active,m.medical_borrow_id
                    FROM medical_borrow m
                    LEFT JOIN article_data a on a.article_id = m.medical_borrow_article_id
                    LEFT JOIN article_status ast on ast.article_status_id = a.article_status_id
                    LEFT JOIN department_sub_sub d on d.DEPARTMENT_SUB_SUB_ID=m.medical_borrow_debsubsub_id 
                    WHERE datediff(curdate(),medical_borrow_date)
                    
                    AND a.medical_typecat_id ="' . $typecat_id . '"
                    AND m.medical_borrow_debsubsub_id ="' . $deb_subsub_id .'"
                
            ');
        } else if ($startdate != '' && $enddate != '' && $typecat_id != '') {
            $data['medical_borrow'] = DB::connection('mysql')->select('  
                    SELECT a.article_num,a.article_name,
                    ABS(DATEDIFF(medical_borrow_date,medical_borrow_backdate)) AS Days
                    ,ast.article_status_name as STATUS
                    ,d.DEPARTMENT_SUB_SUB_NAME
                    ,m.medical_borrow_date,m.medical_borrow_backdate,a.article_status_id,m.medical_borrow_active,m.medical_borrow_id
                    ,a.medical_typecat_id
                    FROM medical_borrow m
                    LEFT JOIN article_data a on a.article_id = m.medical_borrow_article_id
                    LEFT JOIN article_status ast on ast.article_status_id = a.article_status_id
                    LEFT JOIN department_sub_sub d on d.DEPARTMENT_SUB_SUB_ID=m.medical_borrow_debsubsub_id 
                    WHERE datediff(curdate(),medical_borrow_date)
                    AND m.medical_borrow_date between "' . $startdate . '" AND "' . $enddate . '" 
                    AND a.medical_typecat_id = "' . $typecat_id . '"
            ');
        } else if ($typecat_id != '') {
            $data['medical_borrow'] = DB::connection('mysql')->select('
                     
                    SELECT a.article_num,a.article_name,
                    ABS(DATEDIFF(medical_borrow_date,medical_borrow_backdate)) AS Days
                    ,ast.article_status_name as STATUS
                    ,d.DEPARTMENT_SUB_SUB_NAME
                    ,m.medical_borrow_date,m.medical_borrow_backdate,a.article_status_id,m.medical_borrow_active,m.medical_borrow_id
                    FROM medical_borrow m
                    LEFT JOIN article_data a on a.article_id = m.medical_borrow_article_id
                    LEFT JOIN article_status ast on ast.article_status_id = a.article_status_id
                    LEFT JOIN department_sub_sub d on d.DEPARTMENT_SUB_SUB_ID=m.medical_borrow_debsubsub_id 
                    WHERE datediff(curdate(),medical_borrow_date)
              
                    AND a.medical_typecat_id = "' . $typecat_id . '"
            ');
       
        } else if ($deb_subsub_id != '') {
            $data['medical_borrow'] = DB::connection('mysql')->select('
                    SELECT a.article_num,a.article_name,
                    ABS(DATEDIFF(medical_borrow_date,medical_borrow_backdate)) AS Days
                    ,ast.article_status_name as STATUS
                    ,d.DEPARTMENT_SUB_SUB_NAME
                    ,m.medical_borrow_date,m.medical_borrow_backdate,a.article_status_id,m.medical_borrow_active,m.medical_borrow_id
                    FROM medical_borrow m
                    LEFT JOIN article_data a on a.article_id = m.medical_borrow_article_id
                    LEFT JOIN article_status ast on ast.article_status_id = a.article_status_id
                    LEFT JOIN department_sub_sub d on d.DEPARTMENT_SUB_SUB_ID=m.medical_borrow_debsubsub_id 
                    WHERE datediff(curdate(),medical_borrow_date)
          
                    AND m.medical_borrow_debsubsub_id = "' . $deb_subsub_id . '" 
            ');
         
        } else {
            $data['medical_borrow'] = DB::connection('mysql')->select('
            SELECT a.article_num,a.article_name,
                    ABS(DATEDIFF(medical_borrow_date,medical_borrow_backdate)) AS Days
                    ,ast.article_status_name as STATUS
                    ,d.DEPARTMENT_SUB_SUB_NAME
                    ,m.medical_borrow_date,m.medical_borrow_backdate,a.article_status_id,m.medical_borrow_active,m.medical_borrow_id
                    FROM medical_borrow m
                    LEFT JOIN article_data a on a.article_id = m.medical_borrow_article_id
                    LEFT JOIN article_status ast on ast.article_status_id = a.article_status_id
                    LEFT JOIN department_sub_sub d on d.DEPARTMENT_SUB_SUB_ID=m.medical_borrow_debsubsub_id 
                    WHERE datediff(curdate(),medical_borrow_date)
                     
                
            ');
        }

        return view('medical.med_rep1_excel', $data, [
            'startdate'         =>  $startdate,
            'enddate'           =>  $enddate,
            'typecat_id'        =>  $typecat_id,
            'deb_subsub_id'     =>  $deb_subsub_id,
            'status_id'         =>  $status_id
        ]);
    }
    public function med_rep2_excel(Request $request)
    {
        $medical_typecat = DB::connection('mysql')->select('select * from medical_typecat');

        return view('medical.med_rep2_excel',[
            'medical_typecat'         =>  $medical_typecat 
        ]);
    }
    public function med_rep3_excel(Request $request,$startdate,$enddate)
    {
        // $startdate = $request->startdate;
        // $enddate = $request->enddate;
        // $typecat_id = $request->medical_typecat_id;
        // $deb_subsub_id = $request->article_deb_subsub_id;
        // $status_id = $request->article_status_id;

        // $medical_deb = DB::connection('mysql')->select('
        //     select DEPARTMENT_SUB_SUB_ID,DEPARTMENT_SUB_SUB_NAME,a.article_deb_subsub_id
        //     from department_sub_sub d
        //     LEFT JOIN article_data a on a.article_deb_subsub_id =d.DEPARTMENT_SUB_SUB_ID
        //     GROUP BY a.article_deb_subsub_id
        //     ');
 
        // $medical_borrow = DB::connection('mysql')->select('
        //         select m.medical_borrow_id,m.medical_borrow_active,m.medical_borrow_date,m.medical_borrow_backdate
        //         ,d.DEPARTMENT_SUB_SUB_NAME,m.medical_borrow_qty,m.medical_borrow_debsubsub_id,m.medical_borrow_fromdebsubsub_id
        //         ,m.medical_borrow_users_id,m.medical_borrow_backusers_id, m.medical_borrow_article_id
        //         from medical_borrow m 
        //         LEFT JOIN department_sub_sub d on d.DEPARTMENT_SUB_SUB_ID=m.medical_borrow_debsubsub_id  
        //         GROUP BY d.DEPARTMENT_SUB_SUB_NAME
        //     ');
        $date = date('Y-m-d');
        // $y = date('Y') + 543;
        // $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์  
        $newDate = date('Y-m-d', strtotime($date . ' -1 months')); //ย้อนหลัง 1 เดือน 
        $medical_borrow_rep3 = DB::connection('mysql')->select('
                SELECT a.article_num,a.article_name,
                    ABS(DATEDIFF(medical_borrow_date,medical_borrow_backdate)) AS Days,d.DEPARTMENT_SUB_SUB_NAME
                    ,m.medical_borrow_date,m.medical_borrow_backdate,m.medical_borrow_id
                    FROM medical_borrow m
                    LEFT JOIN article_data a on a.article_id = m.medical_borrow_article_id
                    LEFT JOIN department_sub_sub d on d.DEPARTMENT_SUB_SUB_ID=m.medical_borrow_debsubsub_id 
                    where m.medical_borrow_date between "' . $startdate . '" AND "' . $enddate . '" 
                ');
                // where m.medical_borrow_date between "' . $newDate . '" AND "' . $date . '" 

        return view('medical.med_rep3_excel', [
            'startdate'         =>  $startdate,
            'enddate'           =>  $enddate,
            // 'typecat_id'        =>  $typecat_id,
            // 'deb_subsub_id'     =>  $deb_subsub_id,
            // 'status_id'         =>  $status_id,
            // 'medical_deb'       =>  $medical_deb,
            'medical_borrow_rep3'  =>  $medical_borrow_rep3
        ]);
    }

    public function med_maintenance(Request $request, $id)
    {
        $data['users'] = User::get();
        $article_data = Article::where('article_id','=', $id)
        // where('article_data.article_status_id', '=', '3')
            ->leftjoin('product_brand', 'product_brand.brand_id', '=', 'article_data.article_brand_id')
            ->leftjoin('department_sub_sub', 'department_sub_sub.DEPARTMENT_SUB_SUB_ID', '=', 'article_data.article_deb_subsub_id')
            ->leftjoin('article_status', 'article_status.article_status_id', '=', 'article_data.article_status_id')            
            ->first();
            // ->findOrFail($id);

            $image = $article_data->article_img;

            // dd($image);

        $data['department_sub_sub'] = Department_sub_sub::get();

        // $data['article_data'] = DB::connection('mysql')->select('
        //     select a.article_id,a.article_num,a.article_name,a.article_price
        //     ,a.article_year,d.DEPARTMENT_SUB_SUB_NAME,a.article_recieve_date,a.article_deb_subsub_id
        //     ,a.article_register,a.article_typeid,a.article_categoryid,a.article_serial_no,a.article_status_id
        //     from article_data a
        //     LEFT JOIN product_brand pb on pb.brand_id =a.article_brand_id
        //     LEFT JOIN department_sub_sub d on d.DEPARTMENT_SUB_SUB_ID=a.article_deb_subsub_id
        //     where a.article_status_id = "3" and article_categoryid = "31" or a.article_categoryid="63"
        //     and a.article_id = "'.$id.'"
        // '); 

        // where m.medical_borrow_date= "'.$id.'" 
        return view('medical.med_maintenance', $data,[
            'article_data'   => $article_data,
            'image'          => $image
        ]);
    }

    public function med_repaire(Request $request, $id)
    {
        $data['users'] = User::get();
        $data['article_data'] = Article::where('article_data.article_status_id', '=', '3')
            ->leftjoin('product_brand', 'product_brand.brand_id', '=', 'article_data.article_brand_id')
            ->leftjoin('department_sub_sub', 'department_sub_sub.DEPARTMENT_SUB_SUB_ID', '=', 'article_data.article_deb_subsub_id')
            ->leftjoin('article_status', 'article_status.article_status_id', '=', 'article_data.article_status_id')
            ->where('article_id', '=', $id)
            ->first();

        $data['department_sub_sub'] = Department_sub_sub::get();
 
        return view('medical.med_repaire', $data);
    }
    public static function refnumber()
    {
        $year = date('Y');
        $maxnumber = DB::table('medical_repaire')->max('medical_repaire_id');
        if ($maxnumber != '' ||  $maxnumber != null) {
            $refmax = DB::table('medical_repaire')->where('medical_repaire_id', '=', $maxnumber)->first();
            if ($refmax->medical_repaire_rep != '' ||  $refmax->medical_repaire_rep != null) {
                $maxref = substr($refmax->medical_repaire_rep, -5) + 1;
            } else {
                $maxref = 1;
            }
            $ref = str_pad($maxref, 6, "0", STR_PAD_LEFT);
        } else {
            $ref = '000001';
        }
        $ye = date('Y') + 543;
        $y = substr($ye, -2);
        $refnumber = 'MED'.'-'.$ye . '-' . $ref;
        return $refnumber;
       

    }

    public function med_repaire_save(Request $request)
    {
        $date = date("Y-m-d H:i:s");
        $artcle = $request->medical_repaire_article_id;
        $artcleid = Article::where('article_id', '=', $artcle)->first();

        DB::table('medical_repaire')->insert([
            'medical_repaire_rep' => $request->medical_repaire_rep,
            'medical_repaire_article_id' => $artcle,
            'medical_repaire_date' => $request->medical_repaire_date,
            'medical_repaire_vender' => $request->medical_repaire_vender,
            'medical_repaire_userrep' => $request->medical_repaire_userrep,
            'medical_repaire_because' => $request->medical_repaire_because,
            'medical_repaire_listgo' => $request->medical_repaire_listgo,
            'medical_repaire_users_id' => $request->medical_repaire_users_id,
            'created_at' => $date,
            'updated_at' => $date
        ]);

        // $article = Article::where('article_id', $artcle)->first();
  
        Article::where('article_id', $artcle)
            ->update([ 
                'article_status_id'        => '2'
            ]);

        return response()->json([
            'status'     => '200',
        ]);
    }
}
