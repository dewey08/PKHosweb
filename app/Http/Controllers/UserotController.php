<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\support\Facades\Hash;
use Illuminate\support\Facades\Validator;
use App\Models\User;
use App\Models\Ot_one;
use PDF;
use setasign\Fpdi\Fpdi;
use App\Models\Budget_year;
use Illuminate\Support\Facades\File;
use DataTables;
use Intervention\Image\ImageManagerStatic as Image;
// use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\OtExport;
// use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
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
use Auth;

class UserotController extends Controller
{
    public function user_otone(Request $request)
    {
        $datestart = $request->startdate;
        $dateend = $request->enddate;
        $iddep =  Auth::user()->dep_subsubtrueid;
        // dd($iddep);

        $data['ot_one'] = DB::table('ot_one')
            ->leftjoin('users', 'users.id', '=', 'ot_one.ot_one_nameid')
            ->leftjoin('users_prefix', 'users_prefix.prefix_code', '=', 'users.pname')
            ->leftjoin('department_sub_sub', 'department_sub_sub.DEPARTMENT_SUB_SUB_ID', '=', 'ot_one.dep_subsubtrueid')
            ->where('ot_one.dep_subsubtrueid', '=', $iddep)
            // ->leftjoin('department_sub_sub','department_sub_sub.DEPARTMENT_SUB_SUB_ID','=','ot_one.dep_subsubtrueid')
            // ->where('ot_one_date','=',)->get();
            ->whereBetween('ot_one_date', [$datestart, $dateend])->get();
        $data['users'] = User::get();
        $data['leave_month'] = DB::table('leave_month')->get();

        return view('user_ot.user_otone', $data, [
            'start' => $datestart,
            'end' => $dateend,
        ]);
    }
    public function user_otone_add(Request $request)
    {
        $iddep =  Auth::user()->dep_subsubtrueid;

        $event = array();
        $otservicess = DB::table('ot_one')
            ->leftjoin('users', 'users.id', '=', 'ot_one.ot_one_nameid')
            ->leftjoin('department_sub_sub', 'department_sub_sub.DEPARTMENT_SUB_SUB_ID', '=', 'users.dep_subsubtrueid')
            ->where('users.dep_subsubtrueid', '=', $iddep)
            ->get();
        $tableuser = DB::table('users')->get();
        $iduser = Auth::user()->id;

        foreach ($otservicess as $item) {
            $dateend = $item->ot_one_date;
            $timestart = $item->ot_one_starttime;
            $timeend = $item->ot_one_endtime;
            $starttime = substr($timestart, 0, 5);
            $endtime = substr($timeend, 0, 5);
            $showtitle = $item->ot_one_fullname . ' => ' . $starttime . '-' . $endtime;
            $color = $item->color_ot;
            $event[] = [
                'id' => $item->ot_one_id,
                'title' => $showtitle,
                'start' => $dateend,
                'end' => $dateend,
                'color' => $color
            ];
        }

        return view('user_ot.user_otone_add', [
            'events'     =>  $event,
        ]);
    }
    public function user_otone_save(Request $request)
    {
        $datebigin = $request->start_date;
        $dateend = $request->end_date;
        $iduser = $request->user_id;

        $checkdate = Ot_one::where('ot_one_date', '=', $datebigin)->where('ot_one_nameid', '=', $iduser)->count();

        if ($checkdate > 0) {
            return response()->json([
                'status'     => '100',
            ]);
        } else {
            $add = new Ot_one();
            $add->ot_one_date = $datebigin;
            $add->ot_one_starttime = $request->input('ot_one_starttime');
            $add->ot_one_endtime = $request->input('ot_one_endtime');
            $add->ot_one_detail = $request->input('ot_one_detail');


            if ($iduser != '') {
                $usersave = DB::table('users')->where('id', '=', $iduser)->first();
                $add->ot_one_nameid = $usersave->id;
                $add->ot_one_fullname = $usersave->pnamelong . ' ' . $usersave->fname . '  ' . $usersave->lname;
                $add->dep_subsubtrueid = $usersave->dep_subsubtrueid;
            } else {
                $add->ot_one_nameid = '';
                $add->ot_one_fullname = '';
                $add->dep_subsubtrueid = '';
            }

            $add->save();
            return response()->json([
                'status'     => '200',
            ]);
        }
    }
    public function otone_edit(Request $request, $id)
    {
        $ot = Ot_one::find($id);

        return response()->json([
            'status'     => '200',
            'ot'      =>  $ot,
        ]);
    }
    public function otone_add_color(Request $request, $id)
    {
        $users_color = User::find($id);

        return response()->json([
            'status'     => '200',
            'users_color'      =>  $users_color,
        ]);
    }
    public function otone_updatecolor(Request $request)
    {
        $id = $request->user_id;
        $colorot = $request->color_ot;

        $update = User::find($id);
        $update->color_ot = $colorot;
        $update->save();

        return response()->json([
            'status'     => '200'
        ]);
    }

    public function user_otone_update(Request $request)
    {
        $datebigin = $request->ot_one_date; 
        $iduser = $request->user_id;
        $id = $request->ot_one_id;
 
        $update = Ot_one::find($id);
        $update->ot_one_date = $datebigin;
        $update->ot_one_starttime = $request->input('ot_one_starttime');
        $update->ot_one_endtime = $request->input('ot_one_endtime');
        $update->ot_one_detail = $request->input('ot_one_detail');


        if ($iduser != '') {
            $usersave = DB::table('users')->where('id', '=', $iduser)->first();
            $update->ot_one_nameid = $usersave->id;
            $update->ot_one_fullname = $usersave->pnamelong . ' ' . $usersave->fname . '  ' . $usersave->lname;
            $update->dep_subsubtrueid = $usersave->dep_subsubtrueid;
        } else {
            $update->ot_one_nameid = '';
            $update->ot_one_fullname = '';
            $update->dep_subsubtrueid = '';
        }

        $update->save();
        return response()->json([
            'status'     => '200',
        ]);
        // }  
    }

    public function user_otone_destroy(Request $request, $id)
    {
        $del = Ot_one::find($id);
        $del->delete();
        return response()->json(['status' => '200']);
    }

    public function otone_print(Request $request)
    { 
        $data['ot_one'] = DB::table('ot_one')->get();
        $data['users'] = User::get();
        $data['leave_month'] = DB::table('leave_month')->get();

        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        $pdf = PDF::loadView('ot.otone_print');
        Pdf::setOption(['dpi' => 150, 'defaultFont' => 'sans-serif']);
        return @$pdf->stream();
        
    }
    public function export()
    {
        return Excel::download(new OtExport, 'ot.xlsx');
    }
    

    
    
}
