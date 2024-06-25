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
use Http;
use SoapClient; 
use SplFileObject;
use Arr;
use Storage;

class MedicineController extends Controller
{
    public function medicine(Request $request)
    {
        $datestart = $request->startdate;
        $dateend = $request->enddate;
        $iddep =  Auth::user()->dep_subsubtrueid;
        // dd($iddep);
        $reqsend = $request->ot_type_pk;

        $data['ot_one'] = DB::table('ot_one')
        ->leftjoin('users','users.id','=','ot_one.ot_one_nameid')
        ->leftjoin('users_prefix','users_prefix.prefix_code','=','users.pname')
        ->leftjoin('department_sub_sub','department_sub_sub.DEPARTMENT_SUB_SUB_ID','=','ot_one.dep_subsubtrueid')
        ->where('ot_one.dep_subsubtrueid','=',$iddep)
        ->where('users.users_group_id','=',$reqsend) 
        ->whereBetween('ot_one_date', [$datestart, $dateend])->get();

        $data['users'] = User::get();
        $data['leave_month'] = DB::table('leave_month')->get();
        $data['users_group'] = DB::table('users_group')->get();
        $data['ot_type_pk'] = DB::table('ot_type_pk')->get();

        return view('medicine.medicine', $data,[
            'start' => $datestart,
            'end' => $dateend,
            'reqsend' => $reqsend
        ]);
    }
    public function medicine_salt (Request $request)
    {
        $datestart = $request->startdate;
        $dateend = $request->enddate;
        
        $data['users'] = User::get();
        $data['leave_month'] = DB::table('leave_month')->get();
       

        // เจน  hos_guid  จาก Hosxp
        $data_key = DB::connection('mysql5')->select('SELECT uuid() as keygen'); 
        $output = Arr::sort($data_key); 
        $output2 = Arr::query($data_key);       
        // $output3 = Arr::sort($data_key['keygen']);
        $output4 = Arr::sort($data_key); 
        foreach ($output4 as $key => $value) { 
            $output_show = $value->keygen; 
        }
        // dd($output_show);

        $datashow = DB::connection('mysql2')->select('
            SELECT year(i.labor_date) as years,month(i.labor_date) as months,count(distinct i.an) as countan
                from hos.ipt_pregnancy i
                LEFT JOIN hos.an_stat a on a.an = i.an
                left outer join hos.patient pt on pt.hn = a.hn
                left outer join hos.pttype p on p.pttype = a.pttype
                left outer join hos.ipt_pttype ii on ii.an = i.an
                left outer join hos.health_med_service h on h.hn= a.hn
                left outer join hos.health_med_service_operation ho on ho.health_med_service_id =h.health_med_service_id and ho.health_med_operation_item_id in("7","8","9","11","16")
                where i.labor_date between "' . $datestart . '" AND "' . $dateend . '"
                
                and p.hipdata_code ="UCS"
                and ii.hospmain ="10978"
                GROUP BY month(i.labor_date)
                order by year(i.labor_date) 
        ');

        return view('medicine.medicine_salt ', $data,[
            'start'     => $datestart,
            'end'       => $dateend,
            'datashow'  => $datashow,
            'data_key'  => $data_key,
            'output_show'    => $output_show
        ]);
    }
     
    public function medicine_saltsearch (Request $request)
    {
        $datestart = $request->startdate;
        $dateend = $request->enddate;
        // dd($dateend);
        $data['users'] = User::get();
        $data['leave_month'] = DB::table('leave_month')->get();
       
        // $data_key = DB::connection('mysql5')->select('SELECT uuid() as keygen');
        
        $datashow = DB::connection('mysql2')->select('
            SELECT year(i.labor_date) as years,month(i.labor_date) as months,count(distinct i.an) as countan,i.labor_date
                from hos.ipt_pregnancy i
                LEFT JOIN hos.an_stat a on a.an = i.an
                left outer join hos.patient pt on pt.hn = a.hn
                left outer join hos.pttype p on p.pttype = a.pttype
                left outer join hos.ipt_pttype ii on ii.an = i.an
                left outer join hos.health_med_service h on h.hn= a.hn
                left outer join hos.health_med_service_operation ho on ho.health_med_service_id =h.health_med_service_id and ho.health_med_operation_item_id in("7","8","9","11","16")
                where i.labor_date between "' . $datestart . '" AND "' . $dateend . '"
                
                and p.hipdata_code ="UCS"
                and ii.hospmain ="10978"
                GROUP BY month(i.labor_date)
                order by year(i.labor_date) 
        ');

        return view('medicine.medicine_salt ', $data,[
            'start'     => $datestart,
            'end'       => $dateend,
            'datashow'  => $datashow,
            // 'data_key'  => $data_key,
        ]);
    }

    public function medicine_salt_sub (Request $request,$months,$startdate,$enddate)
    { 
        $new = $enddate;
        $leave_month_year = DB::table('leave_month')->orderBy('MONTH_ID', 'ASC')->get();
        // $date = date('Y-m-d');
        $new_enddate_ = date('Y',strtotime($enddate . ' +1 year'));
        // $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        // $newDate = date('Y-m-d', strtotime($date . ' -5 months')); //ย้อนหลัง 5 เดือน
        // $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี
        $yearnew = date('Y')+1;
        // dd($y);
        // $start = (''.$yearold.'-10-01');
        $new_enddate = (''.$new_enddate_.'-09-30'); 
        // dd($new_enddate);
        $datashow = DB::connection('mysql10')->select('
            SELECT a.hn,a.an,pt.cid,i.labor_date,d.deliver_name,
                (select labor_date from hos.person_anc where person_id = pa.person_id ORDER BY labor_date desc limit 1) as dlabor_date,h.service_date,concat(pt.pname,pt.fname," ",pt.lname) as fullname,a.pttype,
                concat(pt.addrpart,"หมู่ ",pt.moopart," ต.",t3.name," อ.",t2.name," จ.",t1.name) as fulladdressname,hh.name as hname,concat(pt.hometel," ","/",pt.informtel) as informtel,
                
                (select GROUP_CONCAT(distinct hi.icd10tm," ","|"," ")  
                from hos.health_med_service hs 
                left outer join hos.health_med_service_operation ho on ho.health_med_service_id = hs.health_med_service_id and ho.health_med_operation_item_id in("7","8","9","11","16")
                left outer join hos.health_med_operation_item hi on hi.health_med_operation_item_id = ho.health_med_operation_item_id and hi.icd10tm in("9007712","9007713","9007714","9007716","9007730")
                where hs.service_date between "'.$startdate.'" AND "'.$new_enddate.'"
                and hs.an is null
                order by hs.service_date desc,hs.service_time desc limit 0,1)  as icd10tm
  
                from hos.an_stat a
                left outer join hos.ipt_pregnancy i on i.an = a.an
                left outer join hos.patient pt on pt.hn = a.hn
                left outer join hos.pttype p on p.pttype = a.pttype
                left outer join hos.ipt_pttype ii on ii.an = a.an
                left OUTER join hos.hospcode hh on hh.hospcode = ii.hospsub
                left outer join hos.thaiaddress t1 on t1.chwpart=pt.chwpart and
                    t1.amppart="00" and t1.tmbpart="00"
                left outer join hos.thaiaddress t2 on t2.chwpart=pt.chwpart and
                    t2.amppart=pt.amppart and t2.tmbpart="00"
                left outer join hos.thaiaddress t3 on t3.chwpart=pt.chwpart and
                    t3.amppart=pt.amppart and t3.tmbpart=pt.tmbpart
                left outer join hos.health_med_service h on h.hn= a.hn
                left outer join hos.health_med_service_operation ho on ho.health_med_service_id =h.health_med_service_id 
                left outer join hos.health_med_operation_item hi on hi.health_med_operation_item_id = ho.health_med_operation_item_id  and hi.icd10tm in("9007712","9007713","9007714","9007716","9007730")
                left OUTER join hos.person pp on pp.patient_hn = a.hn
                LEFT JOIN hos.person_anc pa on pa.person_id = pp.person_id
                left outer join hos.deliver_type d on d.deliver_type = i.deliver_type
                where i.labor_date between "'.$startdate.'" AND "'.$new_enddate.'"
                and p.hipdata_code ="UCS"
                and ii.hospmain ="10978"
                and month(i.labor_date) = "'.$months.'"
                GROUP BY a.an
                ORDER BY ii.hospsub 
            ');

        return view('medicine.medicine_salt_sub ',[
            'start'     => $startdate,
            'end'       => $enddate,
            'datashow'  => $datashow, 
        ]);
    }

    public function medicine_salt_subhn (Request $request,$hn)
    { 
        $datashow = DB::connection('mysql3')->select('
            SELECT h.service_date,(select GROUP_CONCAT(hi.icd10tm," ","|"," ") as icd10tm from hos.health_med_service hs 
                left outer join hos.health_med_service_operation ho on ho.health_med_service_id = hs.health_med_service_id 
                left outer join hos.health_med_operation_item hi on hi.health_med_operation_item_id = ho.health_med_operation_item_id 
                where hs.vn=h.vn and hi.icd10tm in ("9007712","9007713","9007714","9007716","9007730") order by hs.service_date desc,hs.service_time desc limit 0,1) as icd10tm
                from hos.health_med_service h 
                left outer join hos.health_med_service_operation ho on ho.health_med_service_id =h.health_med_service_id 
                left outer join hos.health_med_operation_item hi on hi.health_med_operation_item_id = ho.health_med_operation_item_id  and hi.icd10tm in(9007712,9007713,9007714,9007716,9007730)
                where h.hn ="'.$hn.'"
                and h.an is null
                group by h.vn,h.service_date
 
        ');

        return view('medicine.medicine_salt_subhn ',[ 
            'datashow'  => $datashow, 
        ]);
    }

}
