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
use App\Models\Products_request;
use App\Models\Products_request_sub;
use App\Models\Products;
use App\Models\Products_type;
use App\Models\Product_group;
use App\Models\Product_unit;
use App\Models\Products_category;
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
use App\Models\Warehouse_deb_req;
use App\Models\Warehouse_deb_req_sub;
use App\Models\Article_status;
use App\Models\Car_type;
use App\Models\Product_brand;
use App\Models\Product_color;
use App\Models\Department_sub_sub;
use App\Models\Article;
use App\Models\Warehouse_rep;
use App\Models\Warehouse_rep_sub;
use DataTables;
use PDF;
use Auth;
use Illuminate\Support\Facades\Storage;
use setasign\Fpdi\Fpdi;
use Illuminate\Support\Facades\File;

class UserwarehouseController extends Controller
{
    public static function refnumber()
    {
        $year = date('Y');
        $maxnumber = DB::table('warehouse_deb_req')->max('warehouse_deb_req_id');
        if ($maxnumber != '' ||  $maxnumber != null) {
            $refmax = DB::table('warehouse_deb_req')->where('warehouse_deb_req_id', '=', $maxnumber)->first();
            if ($refmax->warehouse_deb_req_code != '' ||  $refmax->warehouse_deb_req_code != null) {
                $maxref = substr($refmax->warehouse_deb_req_code, -5) + 1;
            } else {
                $maxref = 1;
            }
            $ref = str_pad($maxref, 6, "0", STR_PAD_LEFT);
        } else {
            $ref = '000001';
        }
        $ye = date('Y') + 543;
        $y = substr($ye, -2);
        $refnumber = 'REQ' . '-' . $ref;
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
        return view('user.warehouse_dashboard', $data);
    }

    public function warehouse_deb_sub_sub(Request $request)
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

        return view('user.warehouse_deb_sub_sub', $data);
    }
    public function warehouse_main_request(Request $request)
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

        return view('user.warehouse_main_request', $data);
    }

    public function warehouse_stock_sub(Request $request)
    {
        $iddebsubsubtrui = Auth::user()->dep_subsubtrueid;
        $iduser = Auth::user()->id;
        $data['product_category'] = Products_category::get();
        $data['product_type'] = Products_type::get();
        $data['product_group'] = Product_group::where('product_group_id', '=', 1)->orWhere('product_group_id', '=', 2)->get();
        $data['product_unit'] = Product_unit::get();
        $data['product_data'] = Products::where('product_groupid', '=', 1)->orwhere('product_groupid', '=', 2)->orderBy('product_id', 'DESC')->get();
        $data['countsttus'] = DB::table('warehouse_rep_sub')->where('warehouse_rep_sub_status', '=', '2')->count();

        $data['warehouse_stock_sub'] = DB::connection('mysql')
            ->select('select wr.warehouse_stock_sub_id,wr.warehouse_debsubtrue_id,wr.warehouse_debsubtrue_name,pd.product_name,pd.product_code,pu.unit_name,wr.product_qty
                ,wr.product_price_total,wr.warehouse_stock_sub_status,pd.product_categoryname
                from warehouse_stock_sub wr 
                left outer join product_data pd on pd.product_id=wr.product_id 
                left outer join product_unit pu on pu.unit_id=wr.product_unit_subid
                left outer join department_sub_sub dss on dss.DEPARTMENT_SUB_SUB_ID=wr.warehouse_debsubtrue_id 
                where wr.warehouse_debsubtrue_id = "' . $iddebsubsubtrui . '"
            
                ');
        $data['warehouse_deb_req'] = DB::connection('mysql')
                ->select('select warehouse_deb_req_id,warehouse_deb_req_code,warehouse_deb_req_year,warehouse_deb_req_date,warehouse_deb_req_savedate,
                warehouse_deb_req_inven_id,warehouse_deb_req_userid,warehouse_deb_req_debsubtruid,warehouse_deb_req_status,u.fname,u.lname,wi.warehouse_inven_name
                from warehouse_deb_req wd
                left outer join users u on u.id = wd.warehouse_deb_req_userid
                left outer join warehouse_inven wi on wi.warehouse_inven_id = wd.warehouse_deb_req_inven_id
                where warehouse_deb_req_debsubtruid = "' . $iddebsubsubtrui . '"   
                ');
                
                $data['budget_year'] = DB::table('budget_year')->get();
                $data['users'] = User::get();
                $data['products_vendor'] = Products_vendor::get();
                $data['warehouse_inven'] = DB::table('warehouse_inven')->get();
        
                $data['product_data'] = Products::where('product_groupid', '=', 1)->orwhere('product_groupid', '=', 2)->orderBy('product_id', 'DESC')->get();
                $data['products_typefree'] = DB::table('products_typefree')->get();
             
                
        return view('user_ware.warehouse_stock_sub', $data);
    }
    public function warehouse_stock_main(Request $request)
    {
        $data['warehouse_inven'] = DB::table('warehouse_inven')->get();

        return view('user_ware.warehouse_stock_main', $data);
    }
    public function warehouse_stock_sub_add(Request $request,$id)
    {
        $iduser = Auth::user()->id;
        $iddebsubsubtrui = Auth::user()->dep_subsubtrueid;

        $data['budget_year'] = DB::table('budget_year')->get();
        $data['users'] = User::get();
        $data['products_vendor'] = Products_vendor::get();
        $data['warehouse_inven'] = DB::table('warehouse_inven')->get();

        $data['product_data'] = Products::where('product_groupid', '=', 1)->orwhere('product_groupid', '=', 2)->orderBy('product_id', 'DESC')->get();
        $data['products_typefree'] = DB::table('products_typefree')->get();
        $data['product_unit'] = DB::table('product_unit')->get();

        $data_warehouse_stock = DB::table('warehouse_stock')->where('warehouse_inven_id','=',$id)->first();
        // $check =  Leave_leader_sub::where('user_id','=',$iduser)->first();  
        // dd($check->leader_id); 

        return view('user_ware.warehouse_stock_sub_add', $data,[
            'data_warehouse_stock'      =>   $data_warehouse_stock
        ]);
    }

    public static function checkhn($id_user)
    {
        $inforid =  User::where('id', '=', $id_user)->first();
        $iddepsubsub = $inforid->dep_subsubtrueid;

        if ($iddepsubsub == '' ||  $iddepsubsub == null) {
            $idleader = '';
        } else {
            $idleaderdepartment =  DB::table('department_sub_sub')->where('DEPARTMENT_SUB_SUB_ID', '=', $iddepsubsub)->first();
            $idleader = $idleaderdepartment->LEADER_ID;
        }

        return $idleader;
    }

    public function warehouse_stock_subbillsave(Request $request)
    {
        $iduser = Auth::user()->id;
        $iddebsubsubtrui = Auth::user()->dep_subsubtrueid;

        $add = new Warehouse_deb_req();
        $add->warehouse_deb_req_code = $request->warehouse_deb_req_code;
        $add->warehouse_deb_req_year = $request->warehouse_deb_req_year;
        $add->warehouse_deb_req_savedate = $request->warehouse_deb_req_savedate;
        $add->warehouse_deb_req_date = $request->warehouse_deb_req_date;
        // $add->warehouse_deb_req_hnid = $request->warehouse_deb_req_hnid;
        $add->warehouse_deb_req_inven_id = $request->warehouse_deb_req_inven_id;
        $add->warehouse_deb_req_userid = $iduser;
        $add->warehouse_deb_req_debsubtruid = $iddebsubsubtrui;
        $add->warehouse_deb_req_status = 'request';
        $add->save();

        return response()->json([
            'status'     => '200'
        ]);
    }

    public function warehouse_stock_subsave(Request $request)
    {
        $add = new Warehouse_deb_req();
        $add->warehouse_deb_req_code = $request->warehouse_deb_req_code;
        $add->warehouse_deb_req_year = $request->warehouse_deb_req_year;
        $add->warehouse_deb_req_savedate = $request->warehouse_deb_req_savedate;
        $add->warehouse_deb_req_date = $request->warehouse_deb_req_date;
        $add->warehouse_deb_req_hnid = $request->warehouse_deb_req_hnid;
        $add->warehouse_deb_req_because = $request->warehouse_deb_req_because;
        $add->warehouse_deb_req_status = 'request';

        $iduser = $request->warehouse_deb_req_userid;
        if ($iduser != '') {
            $usersave = DB::table('users')->where('id', '=', $iduser)->first();
            $add->warehouse_deb_req_userid = $usersave->id;
            $add->warehouse_deb_req_username = $usersave->fname . '  ' . $usersave->lname;
        } else {
            $add->warehouse_deb_req_userid = '';
            $add->warehouse_deb_req_username = '';
        }
        $add->save();

        if ($request->product_id != '' || $request->product_id != null) {
            $product_id = $request->product_id;
            $product_qty = $request->product_qty;
            $product_unit_subid = $request->product_unit_subid;

            dd($product_id);

            $number = count($product_id);
            $count = 0;
            for ($count = 0; $count < $number; $count++) {

                $idpro = DB::table('product_data')->where('product_id', '=', $product_id[$count])->first();
                $maxid = DB::table('warehouse_deb_req')->max('warehouse_deb_req_id');
                $maxcode = DB::table('warehouse_deb_req')->max('warehouse_deb_req_code');
                $date = date("Y-m-d H:i:s");

                // $idunit = DB::table('product_unit')->where('unit_id','=', $product_unit_subid[$count])->first();

                $add2 = new Warehouse_deb_req_sub();
                $add2->warehouse_deb_req_id = $maxid;
                $add2->warehouse_deb_req_code = $maxcode;
                $add2->product_id = $idpro->product_id;
                $add2->product_code = $idpro->product_code;
                $add2->product_name = $idpro->product_name;
                // $add2->product_type_id = $idtype->products_typefree_id;
                // $add2->product_type_name = $idtype->products_typefree_name;
                // $add2->product_unit_subid = $idunit->unit_id;
                // $add2->product_unit_subname = $idunit->unit_name;
                // $add2->product_lot = $product_lot[$count];
                // $add2->product_unit_subid = $product_unit_id[$count];
                $add2->product_qty = $product_qty[$count];

                $add2->save();
            }
        }

        return response()->json([
            'status'     => '200'
        ]);
    }
    function checkunituser(Request $request)
    {

        $productid  = $request->productid;
        $infoproduct = DB::table('product_data')->where('product_id', '=', $productid)->first();

        $infounits = DB::table('product_unit')->where('unit_id', '=', $infoproduct->product_unit_subid)->get();

        $output = ' 
                    <select name="product_unit_subid[]" id="product_unit_subid0"  class="form-control form-control-sm" style="width: 100%;" >
                ';
        foreach ($infounits as $infounit) {
            $output .= ' <option value="' . $infounit->unit_id . '" selected>' . $infounit->unit_name . '</option>';

            $output .= '</select> ';
            echo $output;
        }
    }


    function getdetailselect(Request $request)
    {
        $id_inven = $request->get('id_inven');
        $count = $request->get('count');
        $detailstocks = DB::table('warehouse_stock')->where('warehouse_inven_id', '=', $id_inven)->get();
        $output = '
                <table class="table-bordered table-striped table-vcenter" style="width: 100%;">
                <thead style="background-color: rgb(43, 86, 136)">
                    <tr>
                        <td style="text-align: center;border: 1px solid black;font-size: 13px;color:white;" width="20%">รหัส</td>                
                        <td style="text-align: center;border: 1px solid black;font-size: 13px;color:white;" >รายการวัสดุ</td>
                        <td style="text-align: center;border: 1px solid black;font-size: 13px;color:white;" width="12%">คงเหลือ</td>                        
                        <td style="text-align: center;border: 1px solid black;font-size: 13px;color:white;" width="6%">เลือก</td>
                    </tr>
                </thead>
                <tbody id="myTable">';
                        foreach ($detailstocks as $item) {
                            // $lotreceive =  DB::table('warehouse_store_receive_sub')->where('STORE_ID', '=', $item->STORE_ID)->sum('RECEIVE_SUB_AMOUNT');
                            // $sumlotexport = DB::table('warehouse_store_export_sub')->where('STORE_ID', '=', $item->STORE_ID)->sum('EXPORT_SUB_AMOUNT');
                            // $amountlot = $lotreceive;
                            // $amountexport = $sumlotexport;
                            // $total = $amountlot - $amountexport;      
                    $output .= '  
                        <tr height="20">
                            <td class="text-font" style="border: 1px solid black;padding-left:10px;font-size: 13px;">' . $item->product_code . '</td>
                            <td class="text-font" style="border: 1px solid black;padding-left:10px;font-size: 13px;" align="left" >' . $item->product_name . '</td>
                            <td class="text-font" style="border: 1px solid black;padding-right:10px;font-size: 13px;" align="right" >' . $item->product_qty . '</td>
                            <td class="text-font" style="border: 1px solid black;" align="center" >
                            <button type="button" class="btn btn-outline-primary btn-sm"  style="font-family: \'Kanit\', sans-serif; font-size: 13px;font-weight:normal;"  onclick="selectsupreq('.$item->warehouse_stock_id.','.$count.')">เลือก</button></td> 
                        </tr>';
                     }
                    $output .= '</tbody>
                    </table>';
        echo $output;
    }
    function selectsupreq(Request $request)
    {    
        $id_inven = $request->get('id_inven');
        $count = $request->get('count');
        $detailstocks = DB::table('warehouse_stock')->where('warehouse_stock_id','=',$id_inven)->first();

        $output = $detailstocks->product_name.'<input type="hidden" name="product_unit_subid[]" id="product_unit_subid'.$count.'" class="form-control input-sm" value="'.$detailstocks->product_id.'">';
        echo $output;
    }
    function selectsupunitname(Request $request)
    {    
        $id_inven = $request->get('id_inven');
        $count = $request->get('count');
        $detailstocks = DB::table('warehouse_stock')
        ->leftJoin('product_unit','warehouse_stock.product_unit_subid','=','product_unit.unit_id')
        ->where('warehouse_stock_id','=',$id_inven)->first();

        $output = $detailstocks->product_unit_subname.'<input type="hidden" name="product_unit_subid[]" id="product_unit_subid'.$count.'" class="form-control input-sm" value="'.$detailstocks->product_unit_subid.'">';
        echo $output;
    }

}
