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
use App\Models\Building_level;
use App\Models\Building_level_room;
use App\Models\Building_room_type;
use App\Models\Building_type;
use App\Models\Car_location;
use App\Models\Carservice_signature;
use App\Models\Car_service_personjoin;
use App\Models\Car_drive;
use App\Models\Com_repaire;
use App\Models\Com_repaire_signature;
use App\Models\Warehouse_pay;
use App\Models\Warehouse_pay_sub;
use App\Models\Medical_repaire;

use DataTables;
use PDF;
use Auth;
use Illuminate\Support\Facades\Storage;
use setasign\Fpdi\Fpdi;
use Intervention\Image\ImageManagerStatic as Image;

class WarehousePayController extends Controller
{
    public static function refnumber()
    {
        $year = date('Y');
        $maxnumber = DB::table('warehouse_pay')->max('warehouse_pay_id');
        if ($maxnumber != '' ||  $maxnumber != null) {
            $refmax = DB::table('warehouse_pay')->where('warehouse_pay_id', '=', $maxnumber)->first();
            if ($refmax->pay_code != '' ||  $refmax->pay_code != null) {
                $maxref = substr($refmax->pay_code, -5) + 1;
            } else {
                $maxref = 1;
            }
            $ref = str_pad($maxref, 6, "0", STR_PAD_LEFT);
        } else {
            $ref = '000001';
        }
        $ye = date('Y') + 543;
        $y = substr($ye, -2);
        $refnumber = 'PA'.$ye . '-' . $ref;
        return $refnumber;
    }
    public function warehouse_pay(Request $request)
    {
        $data['budget_year'] = DB::table('budget_year')->get();
        $data['users'] = User::get();
        $data['products_vendor'] = Products_vendor::get();
        $data['warehouse_inven'] = DB::table('warehouse_inven')->get();
        $data['article_data'] = Article::where('article_data.article_status_id', '=', '3')
            ->leftjoin('product_brand', 'product_brand.brand_id', '=', 'article_data.article_brand_id')
            ->leftjoin('department_sub_sub', 'department_sub_sub.DEPARTMENT_SUB_SUB_ID', '=', 'article_data.article_deb_subsub_id')
            ->leftjoin('article_status', 'article_status.article_status_id', '=', 'article_data.article_status_id')
            // ->where('article_id', '=', $id)
            ->get();
        $data['warehouse_pay'] = DB::table('warehouse_pay')->get();

        $data['department_sub_sub'] = Department_sub_sub::get();

        $data['warehouse_pay'] = DB::connection('mysql')->select('
            select  ds.DEPARTMENT_SUB_SUB_NAME,w.warehouse_pay_id,w.pay_code,w.payout_inven_id
                ,w.pay_type,w.pay_user_id,w.pay_date
                ,w.payin_inven_id,w.pay_status,
                w.pay_send,w.pay_total,w.store_id,w.pay_year,u.fname,u.lname,w.pay_payuser_id

                from warehouse_pay w
                LEFT JOIN warehouse_inven wi on wi.warehouse_inven_id = w.payin_inven_id
                LEFT JOIN department_sub_sub ds on ds.DEPARTMENT_SUB_SUB_ID = w.payin_inven_id
                LEFT JOIN users u on u.id = w.pay_user_id
                LEFT JOIN warehouse_pay_status wp on wp.warehouse_pay_status_code = w.pay_status
                ORDER BY w.warehouse_pay_id DESC
        ');



        // ,wp.pay_status_name
        // select m.medical_borrow_id,m.medical_borrow_active,m.medical_borrow_date,m.medical_borrow_backdate
        // ,a.article_name,d.DEPARTMENT_SUB_SUB_NAME,m.medical_borrow_qty,m.medical_borrow_debsubsub_id,a.article_num
        // ,m.medical_borrow_users_id,m.medical_borrow_backusers_id,a.medical_typecat_id,a.article_status_id
        // ,m.medical_borrow_typecat_id,mt.medical_typecatname
        // from warehouse_pay m
        // LEFT JOIN article_data a on a.article_id = m.medical_borrow_article_id
        // LEFT JOIN department_sub_sub d on d.DEPARTMENT_SUB_SUB_ID = m.medical_borrow_debsubsub_id
        // LEFT JOIN medical_typecat mt on mt.medical_typecat_id = m.medical_borrow_typecat_id
        // where m.medical_borrow_date between "' . $newDate . '" AND "' . $date . '"

        return view('warehouse.warehouse_pay', $data);
    }
    public function warehouse_pay_edit(Request $request,$id)
    {
        $data['warehouse_pay'] = DB::table('warehouse_pay')->where('warehouse_pay_id','=',$id)->first();
        $data['budget_year'] = DB::table('budget_year')->get();
        $data['users'] = User::get();
        $data['products_vendor'] = Products_vendor::get();
        $data['warehouse_inven'] = DB::table('warehouse_inven')->get();
        $data['department_sub_sub'] = Department_sub_sub::get();
        return view('warehouse.warehouse_pay_edit',$data);
    }

    public function warehouse_paysave(Request $request)
    {
        $date = date("Y-m-d H:i:s");
        $artcle = $request->medical_repaire_article_id;
        $artcleid = Article::where('article_id', '=', $artcle)->first();

        DB::table('warehouse_pay')->insert([
            'pay_code'         => $request->pay_code,
            'pay_year'         => $request->pay_year,
            'pay_payuser_id'  => $request->pay_payuser_id,
            'pay_user_id'   => $request->pay_user_id,
            'pay_date'         => $request->pay_date,
            'payout_inven_id' => $request->payout_inven_id,
            'payin_inven_id'     => $request->payin_inven_id,
            'store_id'                   => $request->store_id,
            'pay_status'       => 'pay',
            'created_at' => $date,
            'updated_at' => $date
        ]);

        return response()->json([
            'status'     => '200',
        ]);
    }
    public function warehouse_paymodal_edit(Request $request,$id)
    {
        $warehouse_pays = Warehouse_pay::find($id);
        // $warehouse_pay = DB::connection('mysql')->select('
        //     select  w.warehouse_pay_id,ds.DEPARTMENT_SUB_SUB_NAME,w.warehouse_pay_id,w.pay_code,w.payout_inven_id
        //         ,w.pay_type,w.pay_user_id,w.pay_date
        //         ,w.payin_inven_id,w.pay_status,
        //         w.pay_send,w.pay_total,w.store_id,w.pay_year,u.fname,u.lname,w.pay_payuser_id

        //         from warehouse_pay w
        //         LEFT JOIN warehouse_inven wi on wi.warehouse_inven_id = w.payin_inven_id
        //         LEFT JOIN department_sub_sub ds on ds.DEPARTMENT_SUB_SUB_ID = w.payin_inven_id
        //         LEFT JOIN users u on u.id = w.pay_user_id
        //         LEFT JOIN warehouse_pay_status wp on wp.warehouse_pay_status_code = w.pay_status
        //         WHERE w.warehouse_pay_id ="'.$id.'"
        // ');
        $warehouse_pay = Warehouse_pay::where('warehouse_pay_id',$id)->get();
        $budget_year = DB::table('budget_year')->where('leave_year_id',$warehouse_pay[0]['leave_year_id'])->get();
        $users = User::where('id',$warehouse_pay[0]['id'])->get();

        $products_vendor = Products_vendor::all();
        $warehouse_inven = DB::table('warehouse_inven')->get();
        $department_sub_sub = Department_sub_sub::get();

        return response()->json([
            'status'               => '200',
            'warehouse_pay'        =>  $warehouse_pay,
            'warehouse_pays'        =>  $warehouse_pays,
            'budget_year'          =>  $budget_year,
            'users'                =>  $users,
        ]);
    }
    public function get_year(Request $request,$id)
    {
        $budgetyear = DB::table('budget_year')->where('leave_year_id',$id)->get();


        return response()->json([
            'status'               => '200',
            'budgetyear'        =>  $budgetyear,

        ]);
    }

    public function warehouse_payupdate(Request $request)
    {
        $date = date("Y-m-d H:i:s");
        $pay_id = $request->editwarehouse_pay_id;

        Warehouse_pay::where('warehouse_pay_id', $pay_id)
        ->update([
            'pay_code'              => $request->editpay_code,
            'pay_year'              => $request->editpay_year,
            'pay_payuser_id'        => $request->editpay_payuser_id,
            'pay_user_id'           => $request->editpay_user_id,
            'pay_date'              => $request->editpay_date,
            'payout_inven_id'       => $request->editpayout_inven_id,
            'payin_inven_id'        => $request->editpayin_inven_id,
            'store_id'              => $request->editstore_id,

            'created_at' => $date,
            'updated_at' => $date
        ]);

        return response()->json([
            'status'     => '200',
        ]);
    }
    public function warehouse_pay_sub(Request $request,$id)
    {
        $data['warehouse_pay'] = DB::table('warehouse_pay')->where('warehouse_pay_id','=',$id)->first();
        $data['product_data'] = Products::where('product_groupid', '=', 1)->orwhere('product_groupid', '=', 2)->orderBy('product_id', 'DESC')->get();
        $data['products_typefree'] = DB::table('products_typefree')->get();
        $data['product_unit'] = DB::table('product_unit')->get();

        return view('warehouse.warehouse_pay_sub',$data);
    }
    public function warehouse_payadd(Request $request,$id)
    {
        $data['warehouse_pay'] = DB::table('warehouse_pay')->where('warehouse_pay_id','=',$id)->first();
        $data['budget_year'] = DB::table('budget_year')->get();
        $data['users'] = User::get();
        $data['products_vendor'] = Products_vendor::get();
        $data['warehouse_inven'] = DB::table('warehouse_inven')->get();
        $data['department_sub_sub'] = Department_sub_sub::get();

        $data_inven = DB::table('warehouse_pay')
        ->leftjoin('warehouse_inven','warehouse_inven.warehouse_inven_id','=','warehouse_pay.payout_inven_id')
        ->where('warehouse_pay_id','=',$id)->first();

        $data['product_data'] = Products::where('store_id', '=', Auth::user()->store_id)->orderBy('product_id', 'DESC')->get();
        $data['products_typefree'] = DB::table('products_typefree')->get();
        $data['product_unit'] = DB::table('product_unit')->get();
        $data['warehouse_pay_sub'] = DB::table('warehouse_pay_sub')
        ->leftjoin('product_unit','product_unit.unit_id','=','warehouse_pay_sub.product_unit_subid')
        ->where('warehouse_pay_id','=',$id)
        ->get();

        $data['product'] = DB::select('
                SELECT wr.warehouse_recieve_sub_id
                    ,wp.warehouse_pay_id
                    ,pd.product_id,pd.product_code,wr.product_lot,pd.product_name,pu.unit_name

                    ,ifnull(case
                    when wr.product_qty ="" then "0"
                    else wr.product_qty end,"0") recieve_qty

                    ,ifnull(case
                    when wp.product_qty ="" then "0"
                    else wp.product_qty end,"0") pay_qty

                    ,ifnull(case
                    when wr.product_qty > 0 then wr.product_qty
                    when wp.product_qty > 0 then wp.product_qty
                    else wr.product_qty-wp.product_qty end,"0") total

                    ,wr.product_price as price
                    ,wr.product_price_total as price_total

                    FROM product_data pd
                    left outer join warehouse_recieve_sub wr on wr.product_id = pd.product_id
					left outer join warehouse_recieve w on w.warehouse_recieve_id = wr.warehouse_recieve_id
                    left outer join warehouse_pay_sub wp on wp.product_id = pd.product_id
					left outer join warehouse_inven wi on wi.warehouse_inven_id = w.warehouse_recieve_inven_id
                    left outer join product_category pc on pc.category_id = pd.product_categoryid
                    left outer join product_unit pu on pu.unit_id = wr.product_unit_subid
                    where w.warehouse_recieve_inven_id = "'.$data_inven->payout_inven_id.'"
        ');

        return view('warehouse.warehouse_payadd',$data,[
            'data_inven'    =>  $data_inven
        ]);
    }

    public function warehouse_payedit(Request $request,$id)
    {
        $data['budget_year'] = DB::table('budget_year')->get();
        $data_warehouse_pay = DB::table('warehouse_pay')->where('warehouse_pay_id','=',$id)->first();
        $data['users'] = User::get();
        $data['products_vendor'] = Products_vendor::get();
        $data['warehouse_inven'] = DB::table('warehouse_inven')->get();
        $data['article_data'] = Article::where('article_data.article_status_id', '=', '3')
            ->leftjoin('product_brand', 'product_brand.brand_id', '=', 'article_data.article_brand_id')
            ->leftjoin('department_sub_sub', 'department_sub_sub.DEPARTMENT_SUB_SUB_ID', '=', 'article_data.article_deb_subsub_id')
            ->leftjoin('article_status', 'article_status.article_status_id', '=', 'article_data.article_status_id')
            // ->where('article_id', '=', $id)
            ->get();
        $data['warehouse_pay'] = DB::table('warehouse_pay')->get();

        $data['department_sub_sub'] = Department_sub_sub::get();

        $data['warehouse_pay'] = DB::connection('mysql')->select('
        select  ds.DEPARTMENT_SUB_SUB_NAME,w.warehouse_pay_id,w.pay_code,w.payout_inven_id
            ,w.pay_type,w.pay_user_id,w.pay_date
            ,w.payin_inven_id,w.pay_status,
            w.pay_send,w.pay_total,w.store_id,w.pay_year,u.fname,u.lname,w.pay_payuser_id

            from warehouse_pay w
            LEFT JOIN warehouse_inven wi on wi.warehouse_inven_id = w.payin_inven_id
            LEFT JOIN department_sub_sub ds on ds.DEPARTMENT_SUB_SUB_ID = w.payin_inven_id
            LEFT JOIN users u on u.id = w.pay_user_id
            LEFT JOIN warehouse_pay_status wp on wp.warehouse_pay_status_code = w.pay_status

        ');



        return view('warehouse.warehouse_payedit',$data,[
            'data_warehouse_pay'    =>  $data_warehouse_pay
        ]);
    }
    public function warehouse_payadd_save(Request $request)
    {
        $warehouse_pay_id      = $request->warehouse_pay_id;
        $warehouse_inven_id    = $request->warehouse_inven_id;
        $warehouse_recieve_sub_id = $request->product_id;
        $product_qty = $request->product_qty;
        $data_product = DB::select('
                SELECT wr.warehouse_recieve_sub_id,pd.product_id,pd.product_code,wr.product_lot,pd.product_name ,pu.unit_id ,pu.unit_name

                    ,ifnull(case
                    when wr.product_qty ="" then "0"
                    else wr.product_qty end,"0") recieve_qty

                    ,ifnull(case
                    when wp.product_qty ="" then "0"
                    else wp.product_qty end,"0") pay_qty

                    ,ifnull(case
                    when wr.product_qty > 0 then wr.product_qty
                    when wp.product_qty > 0 then wp.product_qty
                    else wr.product_qty-wp.product_qty end,"0") total

                    ,wr.product_price as price
                    ,wr.product_price_total as price_total
                    ,wr.warehouse_recieve_sub_exedate
					,wr.warehouse_recieve_sub_expdate
                    ,wr.warehouse_recieve_sub_total

                    FROM product_data pd
                    left outer join warehouse_recieve_sub wr on wr.product_id = pd.product_id
                    left outer join warehouse_pay_sub wp on wp.product_id = pd.product_id
                    left outer join product_category pc on pc.category_id = pd.product_categoryid
                    left outer join product_unit pu on pu.unit_id = wr.product_unit_subid
                    where wr.warehouse_recieve_sub_id = "'.$warehouse_recieve_sub_id.'"
        ');
        foreach ($data_product as $key => $value) {
            Warehouse_pay_sub::insert([
                'warehouse_pay_id'                   => $warehouse_pay_id,
                'product_id'                         => $value->product_id,
                'product_code'                       => $value->product_code,
                'product_name'                       => $value->product_name,
                // 'product_type_id'                    => $value->product_type_id,
                // 'product_unit_bigid'                 => $value->product_unit_bigid,
                'product_unit_subid'                 => $value->unit_id,
                // 'product_unit_total'                 => $value->product_unit_total,
                'product_qty'                        => $product_qty,
                'product_price'                      => $value->price,
                'product_price_total'                => $product_qty * $value->price,
                'product_lot'                        => $value->product_lot,
                'pay_sub_exedate'                    => $value->warehouse_recieve_sub_exedate,
                'pay_sub_expdate'                    => $value->warehouse_recieve_sub_expdate,
                'pay_sub_status'                     => '3',
                'pay_sub_total'                      => $value->warehouse_recieve_sub_total,
                'warehouse_recieve_sub_id'           => $value->warehouse_recieve_sub_id,
            ]);
        }
        return redirect()->back();
        // return response()->json([
        //     'status'     => '200'
        // ]);
    }


    public function warehouse_addsave(Request $request)
    {
        $warehouse_rep_id    = $request->warehouse_rep_id;
        $store_id            = $request->store_id;
        $warehouse_inven_id  = $request->warehouse_inven_id;

            if ($request->product_id != '' || $request->product_id != null) {
                $product_id = $request->product_id;
                $product_type_id = $request->product_type_id;
                $product_qty = $request->product_qty;
                $product_price = $request->product_price;
                $product_unit_subid = $request->product_unit_subid;
                $product_lot = $request->product_lot;
                $warehouse_rep_sub_exedate = $request->warehouse_rep_sub_exedate;
                $warehouse_rep_sub_expdate = $request->warehouse_rep_sub_expdate;
                $warehouse_rep_sub_status = $request->warehouse_rep_sub_status;

                $number = count($product_id);
                $count = 0;
                for ($count = 0; $count < $number; $count++) {

                    $idpro = DB::table('product_data')->where('product_id', '=', $product_id[$count])->first();
                    $maxcode = DB::table('warehouse_rep')->max('warehouse_rep_code');
                    $date = date("Y-m-d H:i:s");
                    $idtype = DB::table('products_typefree')->where('products_typefree_id','=', $product_type_id[$count])->first();
                    $idunit = DB::table('product_unit')->where('unit_id','=', $product_unit_subid[$count])->first();

                    $add2 = new Warehouse_rep_sub();
                    $add2->warehouse_rep_id = $warehouse_rep_id;
                    $add2->product_id = $idpro->product_id;
                    $add2->product_code = $idpro->product_code;
                    $add2->product_name = $idpro->product_name;
                    $add2->product_type_id = $idtype->products_typefree_id;
                    $add2->product_type_name = $idtype->products_typefree_name;
                    $add2->product_unit_subid = $idunit->unit_id;
                    $add2->product_unit_subname = $idunit->unit_name;
                    $add2->product_lot = $product_lot[$count];
                    $add2->product_qty = $product_qty[$count];
                    $add2->product_price = $product_price[$count];
                    $add2->warehouse_rep_sub_exedate = $warehouse_rep_sub_exedate[$count];
                    $add2->warehouse_rep_sub_expdate = $warehouse_rep_sub_expdate[$count];
                    $add2->warehouse_rep_sub_status = $warehouse_rep_sub_status[$count];
                    $total = $product_qty[$count] * $product_price[$count];
                    $add2->product_price_total = $total;
                    $add2->save();


                }
                $sumrecieve  =  Warehouse_rep_sub::where('warehouse_rep_id','=',$warehouse_rep_id)->sum('product_price_total');
                $countsttus = DB::table('warehouse_rep_sub')->where('warehouse_rep_id', '=',$warehouse_rep_id)->where('warehouse_rep_sub_status', '=','2')->count();
                $update = Warehouse_rep::find($warehouse_rep_id);
                $update->warehouse_rep_total = $sumrecieve;
                if ($countsttus == '0') {
                    $update->warehouse_rep_send = 'FINISH';
                } else {
                    $update->warehouse_rep_send = 'STALE';
                }

                $update->save();

            }
            return response()->json([
                'status'     => '200'
            ]);
    }

}
