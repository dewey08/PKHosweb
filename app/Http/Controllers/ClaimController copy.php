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
use App\Models\Claim_sixteen;
use Auth;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;

class ClaimController extends Controller
{
    public function ssop(Request $request)
    {
        $datestart = $request->startdate;
        $dateend = $request->enddate;
        $data['users'] = User::get();
        $data['leave_month'] = DB::table('leave_month')->get();
        // dd($datestart);
        $ssop_data = DB::connection('mysql3')->select('   
            SELECT
                o.hn AS HN
                ,concat(p.pname,p.fname," ",p.lname) as fullname
                ,o.spclty AS CLINIC
                ,o.vstdate
                ,o.vsttime
                ,DATE_FORMAT(o.vstdate,"%Y%m%d") AS DATEOPD
                ,DATE_FORMAT(o.vsttime,"%H%i") AS TIMEOPD
                ,o.vn AS SEQ
                ,"1" AS UUC
                FROM ovst o
                LEFT OUTER JOIN patient p on p.hn = o.hn
                LEFT OUTER JOIN pttype pt on pt.pttype = o.pttype
                WHERE o.vstdate BETWEEN "'.$datestart.'" AND "'.$dateend.'" 
                AND pt.pcode ="A7"
                AND (o.an=" " OR o.an IS NULL) 
        ');
 
        return view('claim.ssop',$data,[
            'start'       => $datestart,
            'end'         => $dateend,
            'ssop_data'   => $ssop_data
        ]);
    }
    public function ssop_save16(Request $request)
    {
        $datestart = $request->startdate;
        $dateend = $request->enddate;
   
        Claim_sixteen::truncate();

        if($request->HN != '' || $request->HN != null){
       
            $HN = $request->HN;
            $CLINIC = $request->CLINIC;
            $DATEOPD = $request->DATEOPD;
            $TIMEOPD = $request->TIMEOPD;
            $SEQ = $request->SEQ;
            $UUC = $request->UUC; 
            
            $number =count($HN);
            $count = 0;
            for($count = 0; $count< $number; $count++)
                {
                    $add= new Claim_sixteen();
                    $add->HN = $HN[$count];
                    $add->CLINIC = $CLINIC[$count];
                    $add->DATEOPD = $DATEOPD[$count]; 
                    $add->TIMEOPD = $TIMEOPD[$count];
                    $add->SEQ = $SEQ[$count];
                    $add->UUC = $UUC[$count];  
                    $add->save();
                }
            }
            // return Redirect()->back();
            return view('claim.ssop_claimsixteen',[
                'start'       => $datestart,
                'end'         => $dateend, 
            ]);
       
    }
    public function ssop_claimsixteen(Request $request)
    {
        $datestart = $request->startdate;
        $dateend = $request->enddate;
        $data['users'] = User::get();
        $data['leave_month'] = DB::table('leave_month')->get();
        // dd($datestart);
        $ssop_data = DB::connection('mysql3')->select('   
            SELECT
                o.hn AS HN
                ,concat(p.pname,p.fname," ",p.lname) as fullname
                ,o.spclty AS CLINIC
                ,o.vstdate
                ,o.vsttime
                ,DATE_FORMAT(o.vstdate,"%Y%m%d") AS DATEOPD
                ,DATE_FORMAT(o.vsttime,"%H%i") AS TIMEOPD
                ,o.vn AS SEQ
                ,"1" AS UUC
                FROM ovst o
                LEFT OUTER JOIN patient p on p.hn = o.hn
                LEFT OUTER JOIN pttype pt on pt.pttype = o.pttype
                WHERE o.vstdate BETWEEN "'.$datestart.'" AND "'.$dateend.'" 
                AND pt.pcode ="A7"
                AND (o.an=" " OR o.an IS NULL) 
        ');
 
        return view('claim.ssop_claimsixteen',$data,[
            'start'       => $datestart,
            'end'         => $dateend,
            'ssop_data'   => $ssop_data
        ]);
    }
     
 
}
