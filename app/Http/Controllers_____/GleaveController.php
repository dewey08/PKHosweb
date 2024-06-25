<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use Illuminate\Support\Facades\Hash;
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
use App\Models\Users_prefix;
use App\Models\Users_kind_type;
use App\Models\Users_group;
use Illuminate\Support\Facades\File;
use DataTables;
use PDF;
use Auth;
use App\Mail\DissendeMail;
use Mail;
use Illuminate\Support\Facades\Storage;
use setasign\Fpdi\Fpdi;

date_default_timezone_set("Asia/Bangkok");

class GleaveController extends Controller
{
    public function gleave(Request $request)
    {
        $datestart = $request->startdate;
        $dateend = $request->enddate;
        $store_id = Auth::user()->store_id;
        $data['q'] = $request->query('q');
        $query = User::select(
            'users.id',
            'users.fname',
            'users.lname',
            'users.position_name',
            'users.dep_name',
            'store_id',
            'users.dep_subname',
            'users.dep_subsubname',
            'users.type',
            'position.POSITION_NAME',
            'department.DEPARTMENT_NAME',
            'department_sub.DEPARTMENT_SUB_NAME',
            'department_sub_sub.DEPARTMENT_SUB_SUB_NAME'
        )
            ->leftJoin('position', 'position.POSITION_ID', '=', 'users.position_id')
            ->leftJoin('department', 'department.DEPARTMENT_ID', '=', 'users.dep_id')
            ->leftJoin('department_sub', 'department_sub.DEPARTMENT_SUB_ID', '=', 'users.dep_subid')
            ->leftJoin('department_sub_sub', 'department_sub_sub.DEPARTMENT_SUB_SUB_ID', '=', 'users.dep_subsubid')
            ->where('store_id', '=', $store_id)
            ->where(function ($query) use ($data) {
                $query->where('users.pname', 'like', '%' . $data['q'] . '%');
                $query->orwhere('users.fname', 'like', '%' . $data['q'] . '%');
                $query->orwhere('users.lname', 'like', '%' . $data['q'] . '%');
                $query->orwhere('department.DEPARTMENT_NAME', 'like', '%' . $data['q'] . '%');
                $query->orwhere('department_sub.DEPARTMENT_SUB_NAME', 'like', '%' . $data['q'] . '%');
                $query->orwhere('department_sub_sub.DEPARTMENT_SUB_SUB_NAME', 'like', '%' . $data['q'] . '%');
                $query->orwhere('position.POSITION_NAME', 'like', '%' . $data['q'] . '%');
            });
        $data['users'] = $query->orderBy('id', 'DESC')->get();
        $data['department'] = Department::get();
        $data['department_sub'] = Departmentsub::get();
        $data['department_sub_sub'] = Departmentsubsub::get();
        $data['position'] = Position::get();
        $data['status'] = Status::get();

        return view('gleave.gleave', $data,[
            'start' => $datestart,
            'end' => $dateend, 
        ]);
    }
    public function gleave_config(Request $request)
    {
        $datestart = $request->startdate;
        $dateend = $request->enddate;
        $store_id = Auth::user()->store_id;
        $data['q'] = $request->query('q');
        $query = User::select(
            'users.id',
            'users.fname',
            'users.lname',
            'users.position_name',
            'users.dep_name',
            'store_id',
            'users.dep_subname',
            'users.dep_subsubname',
            'users.type',
            'position.POSITION_NAME',
            'department.DEPARTMENT_NAME',
            'department_sub.DEPARTMENT_SUB_NAME',
            'department_sub_sub.DEPARTMENT_SUB_SUB_NAME'
        )
            ->leftJoin('position', 'position.POSITION_ID', '=', 'users.position_id')
            ->leftJoin('department', 'department.DEPARTMENT_ID', '=', 'users.dep_id')
            ->leftJoin('department_sub', 'department_sub.DEPARTMENT_SUB_ID', '=', 'users.dep_subid')
            ->leftJoin('department_sub_sub', 'department_sub_sub.DEPARTMENT_SUB_SUB_ID', '=', 'users.dep_subsubid')
            ->where('store_id', '=', $store_id)
            ->where(function ($query) use ($data) {
                $query->where('users.pname', 'like', '%' . $data['q'] . '%');
                $query->orwhere('users.fname', 'like', '%' . $data['q'] . '%');
                $query->orwhere('users.lname', 'like', '%' . $data['q'] . '%');
                $query->orwhere('department.DEPARTMENT_NAME', 'like', '%' . $data['q'] . '%');
                $query->orwhere('department_sub.DEPARTMENT_SUB_NAME', 'like', '%' . $data['q'] . '%');
                $query->orwhere('department_sub_sub.DEPARTMENT_SUB_SUB_NAME', 'like', '%' . $data['q'] . '%');
                $query->orwhere('position.POSITION_NAME', 'like', '%' . $data['q'] . '%');
            });
        $data['users'] = $query->orderBy('id', 'DESC')->get();
        $data['department'] = Department::get();
        $data['department_sub'] = Departmentsub::get();
        $data['department_sub_sub'] = Departmentsubsub::get();
        $data['position'] = Position::get();
        $data['status'] = Status::get();

        return view('gleave.gleave_config', $data,[
            'start' => $datestart,
            'end' => $dateend, 
        ]);
    }
}
