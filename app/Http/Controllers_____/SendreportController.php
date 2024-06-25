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
use App\Models\Rep_report;
use Auth;

class SendreportController extends Controller
{
    
    public function userrequest_report(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate; 

        $data['rep_report'] =  DB::connection('mysql')->select('
            select r.rep_report_id,r.img,r.rep_report_level,
            r.rep_report_date,
            concat(u.fname," ",u.lname) as fullname, 
            r.rep_report_time,
            r.rep_report_name,
            r.rep_report_status     
            from rep_report r
            left outer join users u on u.id = r.rep_report_rep_userid        
            where r.rep_report_date between "'.$startdate.'" and "'.$enddate.'" order by r.rep_report_id desc
                
        ');          
        return view('user_ot.userrequest_report', $data,[ 
            'startdate'      =>  $startdate,
            'enddate'      =>  $enddate,
            ]);
    }
    public function userrequest_report_save(Request $request)
    {        
        $dated =  date('Y-m-d');
        $timed = date("H:i:s");
        // $add_status = $request->rep_report_status;
        // dd($add_status);

        $add = new Rep_report();
        $add->rep_report_name = $request->rep_report_name;
        $add->rep_report_detail = $request->rep_report_detail;
        $add->rep_report_status = $request->rep_report_status;

       
        $add->rep_report_date = $dated;
        $add->rep_report_time = $timed;
        $add->rep_report_rep_userid = $request->rep_report_rep_userid; 
        $add->rep_report_status = 'Request';

        if ($request->hasfile('img')) {
            $file = $request->file('img');
            $extention = $file->getClientOriginalExtension();
            $filename = time().'.'.$extention; 
            $request->img->storeAs('report',$filename,'public'); 
            $add->img = $filename;
            $add->img_name = $filename;
        }
        $add->save(); 
            
        // return redirect()->back();
        return response()->json([
            'status'     => '200'
            ]);
    }
    public function userrequest_report_edit(Request $request, $id)
    {
        $rep = Rep_report::find($id);

        return response()->json([
            'status'     => '200',
            'rep'      =>  $rep,
        ]);
    }
    public function userrequest_report_update(Request $request)
    {        
        $dated =  date('Y-m-d');
        $timed = date("H:i:s");
        $id = $request->input('rep_report_id');

        $update = Rep_report::find($id);
        $update->rep_report_name = $request->rep_report_name;
        $update->rep_report_detail = $request->rep_report_detail;
        $update->rep_report_status = $request->rep_report_status;
        $update->rep_report_date = $dated;
        $update->rep_report_time = $timed;
        $update->rep_report_status = 'Request';
        $update->rep_report_rep_userid = $request->rep_report_rep_userid; 
                
        if ($request->hasfile('img')) {
            $description = 'storage/report/'.$update->img;
            if (File::exists($description))
            {
                File::delete($description);
            }
            $file = $request->file('img');
            $extention = $file->getClientOriginalExtension();
            $filename = time().'.'.$extention; 
            $request->img->storeAs('report',$filename,'public'); 
            $update->img = $filename;
            $update->img_name = $filename;
        }
        $update->save();

        return response()->json([
            'status'     => '200'
            ]);
    }
    public function recieve(Request $request,$id)
    {
        DB::table('rep_report')
        ->where('rep_report_id', $id)
        ->update([ 
            'rep_report_status' => 'Recieve' 
        ]);
        return response()->json([
            'status'     => '200'
            ]);
    }
    public function inprogress(Request $request,$id)
    {
        DB::table('rep_report')
        ->where('rep_report_id', $id)
        ->update([ 
            'rep_report_status' => 'Inprogress' 
        ]);
        return response()->json([
            'status'     => '200'
            ]);
    }
    public function submitwork(Request $request,$id)
    {
        DB::table('rep_report')
        ->where('rep_report_id', $id)
        ->update([ 
            'rep_report_status' => 'Submitwork' 
        ]);
        return response()->json([
            'status'     => '200'
            ]);
    }

    
    
}
