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
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

class ReportOrtherController extends Controller
{
    public function phthisis_opd(Request $request)
    {
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -1 months')); //ย้อนหลัง 1 เดือน

        $data['startdate'] = $request->startdate;
        $data['enddate'] = $request->enddate;
        if ($data['startdate'] == '') {
            $data['phthisis_opd'] = DB::connection('mysql2')->select('
                SELECT v.pttype,pt.name,COUNT(DISTINCT v.vn) countvn 
                    from vn_stat v   
                    left outer join pttype pt on pt.pttype = v.pttype 
                    where v.vstdate BETWEEN "'.$newDate.'" and "'.$date.'"
                    AND v.main_pdx BETWEEN "A150" AND "A199" 
                    GROUP BY v.pttype 
            '); 
        } else {
            $data['phthisis_opd'] = DB::connection('mysql2')->select('
                SELECT v.pttype,pt.name,COUNT(DISTINCT v.vn) countvn 
                        from vn_stat v   
                        left outer join pttype pt on pt.pttype = v.pttype 
                        where v.vstdate BETWEEN "'.$data['startdate'].'" and "'.$data['enddate'].'"
                        AND v.main_pdx BETWEEN "A150" AND "A199" 
                        GROUP BY v.pttype 
            '); 
        }
        
        
        return view('report_orther.phthisis_opd', $data );
    }
    public function phthisis_ipd(Request $request)
    {
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -1 months')); //ย้อนหลัง 1 เดือน

        $data['startdate'] = $request->startdate;
        $data['enddate'] = $request->enddate;
        if ($data['startdate'] == '') {
            $data['phthisis_ipd'] = DB::connection('mysql2')->select('
                SELECT i.pttype,pt.name,COUNT(DISTINCT i.an) countan 
                    from ipt i
                    left outer join an_stat a on a.an = i.an
                    left outer join pttype pt on pt.pttype = i.pttype 
                    where i.dchdate BETWEEN "'.$newDate.'" and "'.$date.'"
                    AND a.pdx BETWEEN "A150" AND "A199" 
                    GROUP BY i.pttype 
            '); 
        } else {
            $data['phthisis_ipd'] = DB::connection('mysql2')->select('
                SELECT i.pttype,pt.name,COUNT(DISTINCT i.an) countan 
                        from ipt i
                        left outer join an_stat a on a.an = i.an
                        left outer join pttype pt on pt.pttype = i.pttype 
                        where i.dchdate BETWEEN "'.$data['startdate'].'" and "'.$data['enddate'].'"
                        AND a.pdx BETWEEN "A150" AND "A199" 
                        GROUP BY i.pttype 
            '); 
        } 
        
        return view('report_orther.phthisis_ipd', $data );
    }
     
 
}
