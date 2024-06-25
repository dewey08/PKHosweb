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
use App\Models\Warehouse_inven;
use App\Models\Warehouse_inven_person;
use App\Models\Warehouse_rep;
use App\Models\Warehouse_rep_sub;
use App\Models\Warehouse_recieve;
use App\Models\Warehouse_recieve_sub;
use App\Models\Warehouse_stock;
use Illuminate\Support\Facades\File;
use DataTables;
use PDF;
use Auth;
use Illuminate\Support\Facades\Storage;
use setasign\Fpdi\Fpdi;
use Intervention\Image\ImageManagerStatic as Image;

class WarehouseController extends Controller
{
    public static function refnumber()
    {
        $year = date('Y');
        $maxnumber = DB::table('warehouse_rep')->max('warehouse_rep_id');
        if ($maxnumber != '' ||  $maxnumber != null) {
            $refmax = DB::table('warehouse_rep')->where('warehouse_rep_id', '=', $maxnumber)->first();
            if ($refmax->warehouse_rep_code != '' ||  $refmax->warehouse_rep_code != null) {
                $maxref = substr($refmax->warehouse_rep_code, -5) + 1;
            } else {
                $maxref = 1;
            }
            $ref = str_pad($maxref, 6, "0", STR_PAD_LEFT);
        } else {
            $ref = '000001';
        }
        $ye = date('Y') + 543;
        $y = substr($ye, -2);
        $refnumber = $ye . '-' . $ref;
        return $refnumber;


    }
    public function warehouse_dashboard(Request $request)
    {
        $data['q'] = $request->query('q');
        $query = User::select('users.*')
            ->where(function ($query) use ($data) {
                $query->where('pname', 'like', '%' . $data['q'] . '%');
                $query->orwhere('fname', 'like', '%' . $data['q'] . '%');
                $query->orwhere('lname', 'like', '%' . $data['q'] . '%');
                $query->orwhere('tel', 'like', '%' . $data['q'] . '%');
                $query->orwhere('username', 'like', '%' . $data['q'] . '%');
            });
        $data['users'] = $query->orderBy('id', 'DESC')->paginate(10);
        $data['department'] = Department::get();
        $data['department_sub'] = Departmentsub::get();
        $data['department_sub_sub'] = Departmentsubsub::get();
        $data['position'] = Position::get();
        $data['status'] = Status::get();
        return view('warehouse.warehouse_dashboard', $data);
    }
    public function warehouse_index(Request $request)
    {
        $data['product_category'] = Products_category::get();
        $data['product_type'] = Products_type::get();
        $data['product_group'] = Product_group::where('product_group_id', '=', 1)->orWhere('product_group_id', '=', 2)->get();
        $data['product_unit'] = Product_unit::get();
        $data['product_data'] = Products::where('product_groupid', '=', 1)->orwhere('product_groupid', '=', 2)->orderBy('product_id', 'DESC')->get();
        $data['countsttus'] = DB::table('warehouse_rep_sub')->where('warehouse_rep_sub_status', '=','2')->count();
        $data['warehouse_rep'] = DB::connection('mysql')
            ->select('select wr.warehouse_rep_id,wr.warehouse_rep_code,wr.warehouse_rep_no_bill,wr.warehouse_rep_po,wr.warehouse_rep_year,wr.warehouse_rep_send
        ,wr.warehouse_rep_user_id,wr.warehouse_rep_user_name,wr.warehouse_rep_inven_id,wr.warehouse_rep_inven_name,wr.warehouse_rep_total
        ,wr.warehouse_rep_vendor_id,wr.warehouse_rep_vendor_name,wr.warehouse_rep_date,wr.warehouse_rep_status
        ,wr.warehouse_rep_type
        from warehouse_rep wr
        order by wr.warehouse_rep_id desc
        ');
        // left outer join warehouse_rep_sub wrs on wrs.warehouse_rep_id = wr.warehouse_rep_id
        $data['users'] = User::get();
        $data['budget_year'] = DB::table('budget_year')->where('active','=','True')->get();
        $data['products_vendor'] = Products_vendor::get();
        $data['warehouse_inven'] = DB::table('warehouse_inven')->get();

        return view('warehouse.warehouse_index', $data);
    }
    public function warehouse_add(Request $request)
    {
        $data['budget_year'] = DB::table('budget_year')->get();
        $data['users'] = User::get();
        $data['products_vendor'] = Products_vendor::get();
        $data['warehouse_inven'] = DB::table('warehouse_inven')->get();

        $data['product_data'] = Products::where('product_groupid', '=', 1)->orwhere('product_groupid', '=', 2)->orderBy('product_id', 'DESC')->get();
        $data['products_typefree'] = DB::table('products_typefree')->get();
        $data['product_unit'] = DB::table('product_unit')->get();

        return view('warehouse.warehouse_add', $data);
    }

    public function warehouse_billsave(Request $request)
    {
        $invenid = $request->warehouse_rep_inven_id;
        $vendorid = $request->warehouse_rep_vendor_id;
        $sendid = $request->warehouse_rep_send;
        // $proid = $request->product_id;

        if ($invenid == '') {
            return response()->json([
                'status'     => '100'
            ]);
        }else if ($vendorid == ''){
            return response()->json([
                'status'     => '150'
            ]);
        } else {

            // 2565-000002

            $add = new Warehouse_rep();
            $add->warehouse_rep_code = $request->warehouse_rep_code;
            $add->warehouse_rep_no_bill = $request->warehouse_rep_no_bill;
            $add->warehouse_rep_po = $request->warehouse_rep_po;
            $add->warehouse_rep_year = $request->warehouse_rep_year;
            $add->warehouse_rep_date = $request->warehouse_rep_date;
            $add->warehouse_rep_status = 'recieve';
            $add->warehouse_rep_send = '';
            $add->store_id = $request->store_id;

            $iduser = $request->warehouse_rep_user_id;
            if ($iduser != '') {
                $usersave = DB::table('users')->where('id', '=', $iduser)->first();
                $add->warehouse_rep_user_id = $usersave->id;
                $add->warehouse_rep_user_name = $usersave->fname . '  ' . $usersave->lname;
            } else {
                $add->warehouse_rep_user_id = '';
                $add->warehouse_rep_user_name = '';
            }


            if ($invenid != '') {
                $invensave = DB::table('warehouse_inven')->where('warehouse_inven_id', '=', $invenid)->first();
                $add->warehouse_rep_inven_id = $invensave->warehouse_inven_id;
                $add->warehouse_rep_inven_name = $invensave->warehouse_inven_name;
            } else {
                $add->warehouse_rep_inven_id = '';
                $add->warehouse_rep_inven_name = '';
            }


            if ($vendorid != '') {
                $vendorsave = DB::table('products_vendor')->where('vendor_id', '=', $vendorid)->first();
                $add->warehouse_rep_vendor_id = $vendorsave->vendor_id;
                $add->warehouse_rep_vendor_name = $vendorsave->vendor_name;
            } else {
                $add->warehouse_rep_vendor_id = '';
                $add->warehouse_rep_vendor_name = '';
            }

            $add->save();


            return response()->json([
                'status'     => '200'
            ]);

        }

    }
    public function warehouse_billupdate(Request $request)
    {
        $invenid = $request->warehouse_rep_inven_id;
        $vendorid = $request->warehouse_rep_vendor_id;
        $sendid = $request->warehouse_rep_send;
        $id = $request->warehouse_rep_id;
        if ($invenid == '') {
            return response()->json([
                'status'     => '100'
            ]);
        }else if ($vendorid == ''){
            return response()->json([
                'status'     => '150'
            ]);
        } else {
            $update = Warehouse_rep::find($id);
            $update->warehouse_rep_code = $request->warehouse_rep_code;
            $update->warehouse_rep_no_bill = $request->warehouse_rep_no_bill;
            $update->warehouse_rep_po = $request->warehouse_rep_po;
            $update->warehouse_rep_year = $request->warehouse_rep_year;
            $update->warehouse_rep_date = $request->warehouse_rep_date;
            // $update->warehouse_rep_status = 'recieve';
            // $update->warehouse_rep_send = $sendid;
            $update->store_id = $request->store_id;
            $iduser = $request->warehouse_rep_user_id;
            if ($iduser != '') {
                $usersave = DB::table('users')->where('id', '=', $iduser)->first();
                $update->warehouse_rep_user_id = $usersave->id;
                $update->warehouse_rep_user_name = $usersave->fname . '  ' . $usersave->lname;
            } else {
                $update->warehouse_rep_user_id = '';
                $update->warehouse_rep_user_name = '';
            }
            if ($invenid != '') {
                $invensave = DB::table('warehouse_inven')->where('warehouse_inven_id', '=', $invenid)->first();
                $update->warehouse_rep_inven_id = $invensave->warehouse_inven_id;
                $update->warehouse_rep_inven_name = $invensave->warehouse_inven_name;
            } else {
                $update->warehouse_rep_inven_id = '';
                $update->warehouse_rep_inven_name = '';
            }

            if ($vendorid != '') {
                $vendorsave = DB::table('products_vendor')->where('vendor_id', '=', $vendorid)->first();
                $update->warehouse_rep_vendor_id = $vendorsave->vendor_id;
                $update->warehouse_rep_vendor_name = $vendorsave->vendor_name;
            } else {
                $update->warehouse_rep_vendor_id = '';
                $update->warehouse_rep_vendor_name = '';
            }
            $update->save();


            return response()->json([
                'status'     => '200'
            ]);

        }

    }

    public function warehouse_save(Request $request)
    {
        $invenid = $request->warehouse_rep_inven_id;
        $vendorid = $request->warehouse_rep_vendor_id;
        $sendid = $request->warehouse_rep_send;
        // $proid = $request->product_id;

        if ($invenid == '') {
            return response()->json([
                'status'     => '100'
            ]);
        }else if ($vendorid == ''){
            return response()->json([
                'status'     => '150'
            ]);
        // }else if ($proid == ''){
        //     return response()->json([
        //         'status'     => '500'
        //     ]);

        } else {

            $add = new Warehouse_rep();
            $add->warehouse_rep_code = $request->warehouse_rep_code;
            $add->warehouse_rep_no_bill = $request->warehouse_rep_no_bill;
            $add->warehouse_rep_po = $request->warehouse_rep_po;
            $add->warehouse_rep_year = $request->warehouse_rep_year;
            $add->warehouse_rep_date = $request->warehouse_rep_date;
            $add->warehouse_rep_status = 'recieve';
            // $add->warehouse_rep_send = $sendid;

            $iduser = $request->warehouse_rep_user_id;
            if ($iduser != '') {
                $usersave = DB::table('users')->where('id', '=', $iduser)->first();
                $add->warehouse_rep_user_id = $usersave->id;
                $add->warehouse_rep_user_name = $usersave->fname . '  ' . $usersave->lname;
            } else {
                $add->warehouse_rep_user_id = '';
                $add->warehouse_rep_user_name = '';
            }


            if ($invenid != '') {
                $invensave = DB::table('warehouse_inven')->where('warehouse_inven_id', '=', $invenid)->first();
                $add->warehouse_rep_inven_id = $invensave->warehouse_inven_id;
                $add->warehouse_rep_inven_name = $invensave->warehouse_inven_name;
            } else {
                $add->warehouse_rep_inven_id = '';
                $add->warehouse_rep_inven_name = '';
            }


            if ($vendorid != '') {
                $vendorsave = DB::table('products_vendor')->where('vendor_id', '=', $vendorid)->first();
                $add->warehouse_rep_vendor_id = $vendorsave->vendor_id;
                $add->warehouse_rep_vendor_name = $vendorsave->vendor_name;
            } else {
                $add->warehouse_rep_vendor_id = '';
                $add->warehouse_rep_vendor_name = '';
            }

            $add->save();

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
                    $maxid = DB::table('warehouse_rep')->max('warehouse_rep_id');
                    $maxcode = DB::table('warehouse_rep')->max('warehouse_rep_code');
                    $date = date("Y-m-d H:i:s");
                    $idtype = DB::table('products_typefree')->where('products_typefree_id','=', $product_type_id[$count])->first();
                    $idunit = DB::table('product_unit')->where('unit_id','=', $product_unit_subid[$count])->first();

                    $add2 = new Warehouse_rep_sub();
                    $add2->warehouse_rep_id = $maxid;
                    $add2->warehouse_rep_code = $maxcode;
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
                $sumrecieve  =  Warehouse_rep_sub::where('warehouse_rep_id','=',$maxid)->sum('product_price_total');
                $countsttus = DB::table('warehouse_rep_sub')->where('warehouse_rep_id', '=',$maxid)->where('warehouse_rep_sub_status', '=','2')->count();
                $update = Warehouse_rep::find($maxid);
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
    public function warehouse_detail(Request $request,$id)
    {
        $data['budget_year'] = DB::table('budget_year')->get();
        $data['users'] = User::get();
        $data['products_vendor'] = Products_vendor::get();
        $data['warehouse_inven'] = DB::table('warehouse_inven')->get();
        $data['product_data'] = Products::where('product_groupid', '=', 1)->orwhere('product_groupid', '=', 2)->orderBy('product_id', 'DESC')->get();
        $data['products_typefree'] = DB::table('products_typefree')->get();
        $data['product_unit'] = DB::table('product_unit')->get();
        $warehouse_rep = DB::connection('mysql')->table('warehouse_rep')->where('warehouse_rep_id','=',$id)->first();
        $warehouse_repsub = DB::connection('mysql')->table('warehouse_rep_sub')->where('warehouse_rep_id','=',$id)->get();
        $countsttus = DB::table('warehouse_rep_sub')->where('warehouse_rep_id', '=',$id)->where('warehouse_rep_sub_status', '=','2')->count();

        $count = DB::table('warehouse_rep_sub')->where('warehouse_rep_id','=',$id)->count();
        return view('warehouse.warehouse_detail', $data,[
            'warehouse_rep'    => $warehouse_rep,
            'warehouse_repsub' => $warehouse_repsub,
            'count'            => $count,
            'countsttus'       => $countsttus
        ]);
    }

    public function warehouse_confirm(Request $request,$id)
    {
        $update = Warehouse_rep::find($id);
        $update->warehouse_rep_status = 'allow';
        $update->warehouse_rep_send = 'FINISH';
        $update->save();

        DB::table('warehouse_rep_sub')
            ->where('warehouse_rep_id','=', $id)
            ->update(['warehouse_rep_sub_status' => '1']);

        $inven = Warehouse_rep::where('warehouse_rep_id','=',$id)->first();
        $checkproduct = Warehouse_rep_sub::where('warehouse_rep_id', '=', $id)->get();

        $couninven = DB::table('warehouse_stock')->where('warehouse_inven_id', '=', $inven->warehouse_rep_inven_id)->count();

            // $counproduct = DB::table('warehouse_stock')->where('product_id', '=', $item->product_id)->orwhere('warehouse_inven_id', '=', $inven->warehouse_inven_id)->count();
            //   dd($counproduct);
            foreach ($checkproduct as $key => $item) {
            if ($couninven > 0) {

                    $counproduct = DB::table('warehouse_stock')->where('product_id', '=', $item->product_id)->where('warehouse_inven_id','=',$inven->warehouse_rep_inven_id)->count();
                    if ($counproduct > 0) {

                        $productlist = Warehouse_stock::where('warehouse_inven_id','=',$inven->warehouse_rep_inven_id)->where('product_id', '=', $item->product_id)->get();
                        foreach ($productlist as $itemstock){
                            // $invenqty = Warehouse_stock::where('warehouse_inven_id','=',$inven->warehouse_rep_inven_id)->where('product_id','=', $item->product_id)->first();
                            $qtystock = $itemstock->product_qty + $item->product_qty;
                            // $qtystockprice = $itemstock->product_price + $item->product_price;
                            $pricetotakstock = $itemstock->product_price_total + $item->product_price_total;

                            DB::table('warehouse_stock')
                            ->where('warehouse_inven_id','=', $inven->warehouse_rep_inven_id)
                            ->where('product_id', '=', $itemstock->product_id)
                            ->update([
                                'product_qty' => $qtystock,
                                'product_price' => $item->product_price,
                                'product_price_total'  => $pricetotakstock
                            ]);

                        }
                    } else {
                        $stock = new Warehouse_stock();
                        $stock->warehouse_inven_id = $inven->warehouse_rep_inven_id;
                        $stock->warehouse_inven_name = $inven->warehouse_rep_inven_name;
                        $stock->product_id = $item->product_id;
                        $stock->product_code = $item->product_code;
                        $stock->product_name = $item->product_name;
                        $stock->product_type_id = $item->product_type_id;
                        $stock->product_type_name = $item->product_type_name;
                        $stock->product_unit_subid = $item->product_unit_subid;
                        $stock->product_unit_subname = $item->product_unit_subname;
                        $stock->product_qty = $item->product_qty;
                        $stock->product_price = $item->product_price;
                        $stock->product_price_total = $item->product_price_total;
                        $stock->save();
                    }
            } else {
                $stock = new Warehouse_stock();
                $stock->warehouse_inven_id = $inven->warehouse_rep_inven_id;
                $stock->warehouse_inven_name = $inven->warehouse_rep_inven_name;
                $stock->product_id = $item->product_id;
                $stock->product_code = $item->product_code;
                $stock->product_name = $item->product_name;
                $stock->product_type_id = $item->product_type_id;
                $stock->product_type_name = $item->product_type_name;
                $stock->product_unit_subid = $item->product_unit_subid;
                $stock->product_unit_subname = $item->product_unit_subname;
                $stock->product_qty = $item->product_qty;
                $stock->product_price = $item->product_price;
                $stock->product_price_total = $item->product_price_total;
                $stock->save();
            }

            }
        // return response()->json([
        //     'status'     => '200'
        // ]);
    }

    public function warehouse_confirmbefor(Request $request,$id)
    {
        $update = Warehouse_rep::find($id);
        $update->warehouse_rep_status = 'beforallow';
        // $update->warehouse_rep_send = 'FINISH';
        $update->save();

        // DB::table('warehouse_rep_sub')
        //     ->where('warehouse_rep_id','=', $id)
        //     ->update(['warehouse_rep_sub_status' => '1']);

        $inven = Warehouse_rep::where('warehouse_rep_id','=',$id)->first();
        $checkproduct = Warehouse_rep_sub::where('warehouse_rep_id', '=', $id)->get();

        $couninven = DB::table('warehouse_stock')->where('warehouse_inven_id', '=', $inven->warehouse_rep_inven_id)->count();

            // $counproduct = DB::table('warehouse_stock')->where('product_id', '=', $item->product_id)->orwhere('warehouse_inven_id', '=', $inven->warehouse_inven_id)->count();
            //   dd($counproduct);
            foreach ($checkproduct as $key => $item) {
            if ($couninven > 0) {

                    $counproduct = DB::table('warehouse_stock')->where('product_id', '=', $item->product_id)->where('warehouse_inven_id','=',$inven->warehouse_rep_inven_id)->count();
                    if ($counproduct > 0) {

                        $productlist = Warehouse_stock::where('warehouse_inven_id','=',$inven->warehouse_rep_inven_id)->where('product_id', '=', $item->product_id)->get();
                        foreach ($productlist as $itemstock){
                            // $invenqty = Warehouse_stock::where('warehouse_inven_id','=',$inven->warehouse_rep_inven_id)->where('product_id','=', $item->product_id)->first();
                            $qtystock = $itemstock->product_qty + $item->product_qty;
                            $pricetotakstock = $itemstock->product_price_total + $item->product_price_total;

                            DB::table('Warehouse_stock')
                            ->where('warehouse_inven_id','=', $inven->warehouse_rep_inven_id)
                            ->where('product_id', '=', $itemstock->product_id)
                            ->update([
                                'product_qty' => $qtystock,
                                'product_price_total'  => $pricetotakstock
                            ]);

                        }
                    } else {
                        $stock = new Warehouse_stock();
                        $stock->warehouse_inven_id = $inven->warehouse_rep_inven_id;
                        $stock->warehouse_inven_name = $inven->warehouse_rep_inven_name;
                        $stock->product_id = $item->product_id;
                        $stock->product_code = $item->product_code;
                        $stock->product_name = $item->product_name;
                        $stock->product_type_id = $item->product_type_id;
                        $stock->product_type_name = $item->product_type_name;
                        $stock->product_unit_subid = $item->product_unit_subid;
                        $stock->product_unit_subname = $item->product_unit_subname;
                        $stock->product_qty = $item->product_qty;
                        $stock->product_price_total = $item->product_price_total;
                        $stock->save();
                    }
            } else {
                $stock = new Warehouse_stock();
                $stock->warehouse_inven_id = $inven->warehouse_rep_inven_id;
                $stock->warehouse_inven_name = $inven->warehouse_rep_inven_name;
                $stock->product_id = $item->product_id;
                $stock->product_code = $item->product_code;
                $stock->product_name = $item->product_name;
                $stock->product_type_id = $item->product_type_id;
                $stock->product_type_name = $item->product_type_name;
                $stock->product_unit_subid = $item->product_unit_subid;
                $stock->product_unit_subname = $item->product_unit_subname;
                $stock->product_qty = $item->product_qty;
                $stock->product_price_total = $item->product_price_total;
                $stock->save();
            }

            }
        // return response()->json([
        //     'status'     => '200'
        // ]);
    }

    public function warehouse_edit(Request $request,$id)
    {
        $data['budget_year'] = DB::table('budget_year')->get();
        $data['users'] = User::get();
        $data['products_vendor'] = Products_vendor::get();
        $data['warehouse_inven'] = DB::table('warehouse_inven')->get();
        $data['product_data'] = Products::where('product_groupid', '=', 1)->orwhere('product_groupid', '=', 2)->orderBy('product_id', 'DESC')->get();
        $data['products_typefree'] = DB::table('products_typefree')->get();
        $data['product_unit'] = DB::table('product_unit')->get();
        $warehouse_rep = DB::connection('mysql')->table('warehouse_rep')->where('warehouse_rep_id','=',$id)->first();
        $warehouse_repsub = DB::connection('mysql')->table('warehouse_rep_sub')->where('warehouse_rep_id','=',$id)->get();
        $countsttus = DB::table('warehouse_rep_sub')->where('warehouse_rep_id', '=',$id)->where('warehouse_rep_sub_status', '=','2')->count();
        // ->select('select wr.warehouse_rep_id,wr.warehouse_rep_code,wr.warehouse_rep_no_bill,wr.warehouse_rep_po,wr.warehouse_rep_year,wr.warehouse_rep_send
        //     ,wr.warehouse_rep_user_id,wr.warehouse_rep_user_name,wr.warehouse_rep_inven_id,wr.warehouse_rep_inven_name,wr.warehouse_rep_total
        //     ,wr.warehouse_rep_vendor_id,wr.warehouse_rep_vendor_name,wr.warehouse_rep_date,wr.warehouse_rep_status
        //     ,wr.warehouse_rep_type
        //     from warehouse_rep wr
        //     where wr.warehouse_rep_id = "'.$id.'"

        //     ');
        $count = DB::table('warehouse_rep_sub')->where('warehouse_rep_id','=',$id)->count();
        return view('warehouse.warehouse_edit', $data,[
            'warehouse_rep'    => $warehouse_rep,
            'warehouse_repsub' => $warehouse_repsub,
            'count'            => $count,
            'countsttus'       => $countsttus
        ]);
    }

    public function warehouse_update(Request $request)
    {
        $id = $request->warehouse_rep_id;
        $code = $request->warehouse_rep_code;
        $update = Warehouse_rep::find($id);
        $update->warehouse_rep_code = $code;
        $update->warehouse_rep_no_bill = $request->warehouse_rep_no_bill;
        $update->warehouse_rep_po = $request->warehouse_rep_po;
        $update->warehouse_rep_year = $request->warehouse_rep_year;
        $update->warehouse_rep_date = $request->warehouse_rep_date;
        $update->warehouse_rep_status = 'recieve';


        // $update->warehouse_rep_send = $request->warehouse_rep_send;

        $iduser = $request->warehouse_rep_user_id;
        if ($iduser != '') {
            $usersave = DB::table('users')->where('id', '=', $iduser)->first();
            $update->warehouse_rep_user_id = $usersave->id;
            $update->warehouse_rep_user_name = $usersave->fname . '  ' . $usersave->lname;
        } else {
            $update->warehouse_rep_user_id = '';
            $update->warehouse_rep_user_name = '';
        }

        $invenid = $request->warehouse_rep_inven_id;
        if ($invenid != '') {
            $invensave = DB::table('warehouse_inven')->where('warehouse_inven_id', '=', $invenid)->first();
            $update->warehouse_rep_inven_id = $invensave->warehouse_inven_id;
            $update->warehouse_rep_inven_name = $invensave->warehouse_inven_name;
        } else {
            $update->warehouse_rep_inven_id = '';
            $update->warehouse_rep_inven_name = '';
        }

        $vendorid = $request->warehouse_rep_vendor_id;
        if ($vendorid != '') {
            $vendorsave = DB::table('products_vendor')->where('vendor_id', '=', $vendorid)->first();
            $update->warehouse_rep_vendor_id = $vendorsave->vendor_id;
            $update->warehouse_rep_vendor_name = $vendorsave->vendor_name;
        } else {
            $update->warehouse_rep_vendor_id = '';
            $update->warehouse_rep_vendor_name = '';
        }
        $update->save();

        Warehouse_rep_sub::where('warehouse_rep_id','=',$id)->delete();

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
                // $maxid = DB::table('warehouse_rep')->max('warehouse_rep_id');
                // $maxcode = DB::table('warehouse_rep')->max('warehouse_rep_code');
                $date = date("Y-m-d H:i:s");
                $idtype = DB::table('products_typefree')->where('products_typefree_id','=', $product_type_id[$count])->first();
                $idunit = DB::table('product_unit')->where('unit_id','=', $product_unit_subid[$count])->first();

                $add2 = new Warehouse_rep_sub();
                $add2->warehouse_rep_id = $id;
                $add2->warehouse_rep_code = $code;
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
            $sumrecieve  =  Warehouse_rep_sub::where('warehouse_rep_id','=',$id)->sum('product_price_total');
             // $update->warehouse_rep_send = $request->warehouse_rep_send;
            $update3 = Warehouse_rep::find($id);
            $update3->warehouse_rep_total = $sumrecieve;
            $countsttus = DB::table('warehouse_rep_sub')->where('warehouse_rep_id', '=',$id)->where('warehouse_rep_sub_status', '=','2')->count();
            if ($countsttus == '0') {
                $update3->warehouse_rep_send = 'FINISH';
            } else {
                $update3->warehouse_rep_send = 'STALE';
            }
            $update3->save();
        }


        return response()->json([
            'status'     => '200'
        ]);
    }


    public function warehouse_main(Request $request)
    {
        $data['warehouse_inven'] = DB::table('warehouse_inven')->get();

        return view('warehouse.warehouse_main', $data);
    }
    public function warehouse_main_detail(Request $request,$id)
    {
        $data['product_category'] = Products_category::get();
        $data['product_type'] = Products_type::get();
        $data['product_group'] = Product_group::where('product_group_id', '=', 1)->orWhere('product_group_id', '=', 2)->get();
        $data['product_unit'] = Product_unit::get();
        $data['product_data'] = Products::where('product_groupid', '=', 1)->orwhere('product_groupid', '=', 2)->orderBy('product_id', 'DESC')->get();
        $data['countsttus'] = DB::table('warehouse_rep_sub')->where('warehouse_rep_sub_status', '=','2')->count();

        $data['warehouse_stock'] = DB::connection('mysql')
            ->select('select wr.warehouse_stock_id,wr.warehouse_inven_id,wi.warehouse_inven_name,pd.product_name,pd.product_code,pu.unit_name,wr.product_qty
            ,wr.product_price_total,wr.warehouse_stock_status,pd.product_categoryname
            from warehouse_stock wr
            left outer join product_data pd on pd.product_id=wr.product_id
            left outer join warehouse_inven wi on wi.warehouse_inven_id=wr.warehouse_inven_id
            left outer join product_unit pu on pu.unit_id=wr.product_unit_subid
            where wr.warehouse_inven_id = "'.$id.'"

            ');
            // group by wr.warehouse_inven_id
        // left outer join warehouse_rep_sub wrs on wrs.warehouse_rep_id = wr.warehouse_rep_id
        return view('warehouse.warehouse_main_detail', $data);
    }

    public function warehouse_addsub(Request $request,$id)
    {
        $data['budget_year'] = DB::table('budget_year')->get();
        $data['users'] = User::get();
        $data['products_vendor'] = Products_vendor::get();
        $data['warehouse_inven'] = DB::table('warehouse_inven')->get();
        $data['product_data'] = Products::where('product_groupid', '=', 1)->orwhere('product_groupid', '=', 2)->orderBy('product_id', 'DESC')->get();
        $data['products_typefree'] = DB::table('products_typefree')->get();
        $data['product_unit'] = DB::table('product_unit')->get();
        $warehouse_rep = DB::connection('mysql')->table('warehouse_rep')->where('warehouse_rep_id','=',$id)->first();
        // $warehouse_repsub_ok = DB::connection('mysql')->table('warehouse_rep_sub')->where('warehouse_rep_id','=',$id)->where('warehouse_rep_sub_status','=','1')->get();
        $warehouse_repsub_ok = DB::connection('mysql')->table('warehouse_rep_sub')->where('warehouse_rep_id','=',$id)->get();
        $warehouse_repsub = DB::connection('mysql')->table('warehouse_rep_sub')->where('warehouse_rep_id','=',$id)->where('warehouse_rep_sub_status','=','2')->get();

        $count = DB::table('warehouse_rep_sub')->where('warehouse_rep_id','=',$id)->count();

        $counproduct = DB::table('warehouse_rep_sub')->where('warehouse_rep_id','=',$id)->where('warehouse_rep_sub_status','=','2')->count();

        return view('warehouse.warehouse_addsub', $data,[
            'warehouse_rep'    => $warehouse_rep,
            'warehouse_repsub_ok' => $warehouse_repsub_ok,
            'warehouse_repsub' => $warehouse_repsub,
            'count'            => $count,
            'counproduct'      => $counproduct
        ]);
    }
    public function warehouse_add_product(Request $request,$id)
    {
        $data['budget_year'] = DB::table('budget_year')->get();
        $data['users'] = User::get();
        $data['products_vendor'] = Products_vendor::get();

        $data['warehouse_inven'] = DB::table('warehouse_inven')->get();

        $data['product_data'] = Products::where('store_id', '=', Auth::user()->store_id)->orderBy('product_id', 'DESC')->get();

        $data['products_typefree'] = DB::table('products_typefree')->get();
        $data['product_unit'] = DB::table('product_unit')->get();
        $warehouse_rep = DB::connection('mysql')->table('warehouse_rep')->where('warehouse_rep_id','=',$id)->first();
        // $warehouse_repsub_ok = DB::connection('mysql')->table('warehouse_rep_sub')->where('warehouse_rep_id','=',$id)->where('warehouse_rep_sub_status','=','1')->get();
        $warehouse_repsub_ok = DB::connection('mysql')->table('warehouse_rep_sub')->where('warehouse_rep_id','=',$id)->get();
        $warehouse_repsub = DB::connection('mysql')->table('warehouse_rep_sub')->where('warehouse_rep_id','=',$id)->where('warehouse_rep_sub_status','=','2')->get();

        $count = DB::table('warehouse_rep_sub')->where('warehouse_rep_id','=',$id)->count();

        $counproduct = DB::table('warehouse_rep_sub')->where('warehouse_rep_id','=',$id)->where('warehouse_rep_sub_status','=','2')->count();

        $inven = DB::table('warehouse_rep')
        ->leftjoin('warehouse_inven','warehouse_inven.warehouse_inven_id','=','warehouse_rep.warehouse_rep_inven_id')
        ->where('warehouse_rep_id','=',$id)->first();




        return view('warehouse.warehouse_add_product', $data,[
            'warehouse_rep'       => $warehouse_rep,
            'warehouse_repsub_ok' => $warehouse_repsub_ok,
            'warehouse_repsub'    => $warehouse_repsub,
            'count'               => $count,
            'counproduct'         => $counproduct,
            'inven'               => $inven,

        ]);
    }
    public function warehouse_addsave(Request $request)
    {
        $warehouse_rep_id    = $request->warehouse_rep_id;
        $store_id            = $request->store_id;
        $warehouse_inven_id  = $request->warehouse_inven_id;
        // $proid = $request->product_id;

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
                    // $maxid = DB::table('warehouse_rep')->max('warehouse_rep_id');
                    $maxcode = DB::table('warehouse_rep')->max('warehouse_rep_code');
                    $date = date("Y-m-d H:i:s");
                    $idtype = DB::table('products_typefree')->where('products_typefree_id','=', $product_type_id[$count])->first();
                    $idunit = DB::table('product_unit')->where('unit_id','=', $product_unit_subid[$count])->first();

                    $add2 = new Warehouse_rep_sub();
                    $add2->warehouse_rep_id = $warehouse_rep_id;
                    // $add2->warehouse_rep_code = $maxcode;
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
    public function warehouse_edit_product(Request $request,$id)
    {
        $data['budget_year'] = DB::table('budget_year')->get();
        $data['users'] = User::get();
        $data['products_vendor'] = Products_vendor::get();

        $data['warehouse_inven'] = DB::table('warehouse_inven')->get();

        $data['product_data'] = Products::where('store_id', '=', Auth::user()->store_id)->orderBy('product_id', 'DESC')->get();

        $data['products_typefree'] = DB::table('products_typefree')->get();
        $data['product_unit'] = DB::table('product_unit')->get();
        $warehouse_rep = DB::connection('mysql')->table('warehouse_rep')->where('warehouse_rep_id','=',$id)->first();
        // $warehouse_repsub_ok = DB::connection('mysql')->table('warehouse_rep_sub')->where('warehouse_rep_id','=',$id)->where('warehouse_rep_sub_status','=','1')->get();
        $warehouse_repsub_ok = DB::connection('mysql')->table('warehouse_rep_sub')->where('warehouse_rep_id','=',$id)->get();
        $warehouse_repsub = DB::connection('mysql')->table('warehouse_rep_sub')->where('warehouse_rep_id','=',$id)->where('warehouse_rep_sub_status','=','2')->get();

        $count = DB::table('warehouse_rep_sub')->where('warehouse_rep_id','=',$id)->count();

        $counproduct = DB::table('warehouse_rep_sub')->where('warehouse_rep_id','=',$id)->count();
        $inven = DB::table('warehouse_rep')
        ->leftjoin('warehouse_inven','warehouse_inven.warehouse_inven_id','=','warehouse_rep.warehouse_rep_inven_id')
        ->where('warehouse_rep_id','=',$id)->first();
        $data_sub = DB::table('warehouse_rep_sub')->where('warehouse_rep_id','=',$id)->get();
        return view('warehouse.warehouse_edit_product', $data,[
            'warehouse_rep'       => $warehouse_rep,
            'warehouse_repsub_ok' => $warehouse_repsub_ok,
            'warehouse_repsub'    => $warehouse_repsub,
            'count'               => $count,
            'counproduct'         => $counproduct,
            'inven'               => $inven,
            'data_sub'            => $data_sub
        ]);
    }
    public function warehouse_update_product(Request $request)
    {
        $id = $request->warehouse_rep_id;

        $code = $request->warehouse_rep_code;
        $update = Warehouse_rep::find($id);
        $update->warehouse_rep_status = 'recieve';
        $update->save();

        $checkproduct = Warehouse_rep_sub::where('warehouse_rep_id', '=', $id)->get();
        $counproduct = DB::table('warehouse_rep_sub')->where('warehouse_rep_id','=',$id)->where('warehouse_rep_sub_status','=','2')->count();
        $warehouse_repsub = DB::connection('mysql')->table('warehouse_rep_sub')->where('warehouse_rep_id','=',$id)->where('warehouse_rep_sub_status','=','2')->get();

        // foreach ($checkproduct as $key => $item) {

        // if ($counproduct > 0 ) {
        //     foreach ($warehouse_repsub as $itemstock){
        //         $qtystock = $itemstock->product_qty + $item->product_qty;
        //         $pricetotakstock = $itemstock->product_price_total + $item->product_price_total;

        //         DB::table('warehouse_rep_sub')
        //         ->where('warehouse_rep_id','=', $id)
        //         ->where('product_id', '=', $itemstock->product_id)
        //         ->update([
        //             'product_qty' => $qtystock,
        //             'product_price_total'  => $pricetotakstock,
        //             'warehouse_rep_sub_status' => '1'
        //         ]);
        //     }
        //     $sumrecieve  =  Warehouse_rep_sub::where('warehouse_rep_id','=',$id)->sum('product_price_total');
        //     $update3 = Warehouse_rep::find($id);
        //     $update3->warehouse_rep_total = $sumrecieve;
        //     $countsttus = DB::table('warehouse_rep_sub')->where('warehouse_rep_id', '=',$id)->where('warehouse_rep_sub_status', '=','2')->count();
        //     if ($countsttus == '0') {
        //         $update3->warehouse_rep_send = 'FINISH';
        //     } else {
        //         $update3->warehouse_rep_send = 'STALE';
        //     }
        //     $update3->save();
        // } else {
            Warehouse_rep_sub::where('warehouse_rep_id','=',$id)->delete();

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

                    $idsub = $request->warehouse_rep_sub_id;
                    $idsubcode = $request->warehouse_rep_code;

                    $number = count($product_id);
                    $count = 0;
                    for ($count = 0; $count < $number; $count++) {

                        $idcode_ = DB::table('warehouse_rep')->where('warehouse_rep_id', '=', $id)->first();
                        $id_code = $idcode_->warehouse_rep_code;

                        $idpro = DB::table('product_data')->where('product_id', '=', $product_id[$count])->first();
                        $date = date("Y-m-d H:i:s");
                        $idtype = DB::table('products_typefree')->where('products_typefree_id','=', $product_type_id[$count])->first();
                        $idunit = DB::table('product_unit')->where('unit_id','=', $product_unit_subid[$count])->first();

                        // $update5 = Warehouse_rep_sub::find($idsub[$count]);
                        // $update5->warehouse_rep_id = $id;
                        // $update5->warehouse_rep_code = $id_code;
                        // $update5->product_id = $idpro->product_id;
                        // $update5->product_code = $idpro->product_code;
                        // $update5->product_name = $idpro->product_name;
                        // $update5->product_type_id = $idtype->products_typefree_id;
                        // $update5->product_type_name = $idtype->products_typefree_name;
                        // $update5->product_unit_subid = $idunit->unit_id;
                        // $update5->product_unit_subname = $idunit->unit_name;
                        // $update5->product_lot = $product_lot[$count];
                        // $update5->product_qty = $product_qty[$count];
                        // $update5->product_price = $product_price[$count];
                        // $update5->warehouse_rep_sub_exedate = $warehouse_rep_sub_exedate[$count];
                        // $update5->warehouse_rep_sub_expdate = $warehouse_rep_sub_expdate[$count];
                        // $update5->warehouse_rep_sub_status = $warehouse_rep_sub_status[$count];
                        // $total = $product_qty[$count] * $product_price[$count];
                        // $update5->product_price_total = $total;
                        // $update5->save();

                        $add2 = new Warehouse_rep_sub();
                        $add2->warehouse_rep_id = $id;
                        $add2->warehouse_rep_code = $id_code;
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
                    $sumrecieve  =  Warehouse_rep_sub::where('warehouse_rep_id','=',$id)->sum('product_price_total');
                    $update3 = Warehouse_rep::find($id);
                    $update3->warehouse_rep_total = $sumrecieve;
                    $countsttus = DB::table('warehouse_rep_sub')->where('warehouse_rep_id', '=',$id)->where('warehouse_rep_sub_status', '=','2')->count();
                    if ($countsttus == '0') {
                        $update3->warehouse_rep_send = 'FINISH';
                    } else {
                        $update3->warehouse_rep_send = 'STALE';
                    }
                    $update3->save();
                // }

            // }
        }
        return response()->json([
            'status'     => '200'
        ]);
    }


    public function warehouse_destroy(Request $request,$id)
    {
        $del = Warehouse_rep::find($id);
        $del->delete();

        Warehouse_rep_sub::where('warehouse_rep_id','=',$id)->delete();

        return response()->json(['status' => '200']);
    }


    //======================ฟังชั่น====================

    function checksummoney(Request $request)
    {
        $SUP_TOTAL = $request->get('SUP_TOTAL');
        $PRICE_PER_UNIT = $request->get('PRICE_PER_UNIT');

        $sum = $SUP_TOTAL * $PRICE_PER_UNIT;

        $output = '<input type="hidden" type="text" name="sum" value="' . $sum . '" /><div style="text-align: right; margin-right: 10px;font-size: 14px;">' . number_format($sum, 5) . '</div>';
        echo $output;
    }


    function checkunitref(Request $request)
    {

        $unitn  = $request->unitnew;
        // $SUP_UNIT_ID_H = $request->get('SUP_UNIT_ID_H');

        $infoproduct = DB::table('product_data')->where('product_id', '=', $unitn)->first();

        $infounits = DB::table('product_unit')->where('unit_id', '=', $infoproduct->product_unit_subid)->get();

        $output = '
                    <select name="product_unit_subid[]" id="product_unit_subid[]"  class="form-control form-control-sm" style="width: 100%;" >
                ';
        foreach ($infounits as $infounit) {
            $output .= ' <option value="' . $infounit->unit_id . '" selected>' . $infounit->unit_name . '</option>';

            $output .= '</select> ';
            echo $output;
        }
    }



    public function warehouse_inven(Request $request)
    {
        $data['users'] = User::get();
        $data['warehouse_inven'] = DB::table('warehouse_inven')
        ->leftjoin('users','users.id','=','warehouse_inven.warehouse_inven_userid')->get();
        $data['warehouse_inven_person'] = DB::table('warehouse_inven_person')->get();

        return view('warehouse.warehouse_inven', $data);
    }
    public function warehouse_inven_add(Request $request)
    {
        $data['product_brand'] = Product_brand::get();

        return view('warehouse.warehouse_inven_add', $data);
    }
    public function warehouse_invensave(Request $request)
    {
        $add = new Warehouse_inven();
        $add->warehouse_inven_name = $request->input('warehouse_inven_name');

        $iduser = $request->input('warehouse_inven_userid');
        if ($iduser != '') {
            $usersave = DB::table('users')->where('id','=',$iduser)->first();
            $add->warehouse_inven_userid = $usersave->id;
            $add->warehouse_inven_username = $usersave->fname. '  ' .$usersave->lname ;
        } else {
            $add->warehouse_inven_userid = '';
            $add->warehouse_inven_username ='';
        }

        $add->save();

        return response()->json([
            'status'     => '200',
        ]);
    }
    public function warehouse_inven_edit(Request $request, $id)
    {
        $inven = Warehouse_inven::find($id);

        return response()->json([
            'status'     => '200',
            'inven'      =>  $inven,
        ]);
    }
    public function warehouse_invenupdate(Request $request)
    {
        $id = $request->warehouse_inven_id;
        $update = Warehouse_inven::find($id);
        $update->warehouse_inven_name = $request->input('warehouse_inven_name');

        $iduser = $request->input('warehouse_inven_userid');
        if ($iduser != '') {
            $usersave = DB::table('users')->where('id','=',$iduser)->first();
            $update->warehouse_inven_userid = $usersave->id;
            $update->warehouse_inven_username = $usersave->fname. '  ' .$usersave->lname ;
        } else {
            $update->warehouse_inven_userid = '';
            $update->warehouse_inven_username ='';
        }

        $update->save();

        return response()->json([
            'status'     => '200',
        ]);
    }
    public function warehouse_inven_destroy(Request $request, $id)
    {
        $del = Warehouse_inven::find($id);
        $del->delete();

        DB::table('warehouse_inven_person')->where('warehouse_inven_id','=',$id)->delete();
        // Warehouse_inven_person::where('warehouse_inven_id','=',$id)->delete();
        return response()->json(['status' => '200']);
    }

    public function warehouse_inven_addper(Request $request, $id)
    {
        $data['user'] = User::get();
        $data['warehouse_inven_person'] = Warehouse_inven_person::where('warehouse_inven_id', '=', $id)->get();
        return view('warehouse.warehouse_inven_addper', $data, [
            'id'  => $id
        ]);
    }

    public function warehouse_inven_addpersave(Request $request)
    {
        $inven_id = $request->input('warehouse_inven_id');

        $update = new Warehouse_inven_person();
        $update->warehouse_inven_id = $inven_id;

        $inven_person_userid = $request->input('warehouse_inven_person_userid');
        if ($inven_person_userid != '') {
            $usersave = DB::table('users')->where('id', '=', $inven_person_userid)->first();
            $update->warehouse_inven_person_userid = $usersave->id;
            $update->warehouse_inven_person_username = $usersave->fname . '  ' . $usersave->lname;
        } else {
            $update->warehouse_inven_person_userid = '';
            $update->warehouse_inven_person_username = '';
        }

        $update->save();

        return response()->json([
            'status'     => '200',
        ]);
    }
    public function warehouse_inven_addper_destroy(Request $request, $id)
    {
        $del = Warehouse_inven_person::find($id);

        $del->delete();
        return response()->json(['status' => '200']);
    }

    public function warehouse_vendor(Request $request)
    {
        $data['user'] = User::get();
        $data['warehouse_inven_person'] = Warehouse_inven_person::get();

        $data['products_vendor'] = Products_vendor::get();
        return view('warehouse.warehouse_vendor', $data);
    }
    public function warehouse_vendorsave(Request $request)
    {
        $add = new Products_vendor();
        $add->vendor_name = $request->input('vendor_name');
        $add->save();

        return response()->json([
            'status'     => '200',
        ]);
    }
    public function warehouse_vendor_edit(Request $request, $id)
    {
        $vendor = Products_vendor::find($id);

        return response()->json([
            'status'     => '200',
            'vendor'      =>  $vendor,
        ]);
    }
    public function warehouse_vendorupdte(Request $request)
    {
        $id = $request->input('editvendor_id');

        $updte = Products_vendor::find($id);
        $updte->vendor_name = $request->input('editvendor_name');
        $updte->save();

        return response()->json([
            'status'     => '200',
        ]);
    }
    public function warehouse_vendor_destroy(Request $request, $id)
    {
        $del = Products_vendor::find($id);
        $del->delete();
        return response()->json(['status' => '200']);
    }
}
