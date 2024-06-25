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
use Auth;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http; 
use SoapClient;
use Arr; 
use App\Imports\ImportAcc_stm_ti;
use App\Imports\ImportAcc_stm_tiexcel_import;
use App\Imports\ImportAcc_stm_ofcexcel_import;
use App\Imports\ImportAcc_stm_lgoexcel_import;
use App\Models\D_ofc_repexcel;
use App\Models\D_tb_main;
use SplFileObject;
use PHPExcel;
use PHPExcel_IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx; 
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\IOFactory; 
use ZipArchive;  
use Illuminate\Support\Facades\Redirect;
use PhpParser\Node\Stmt\If_;
use Stevebauman\Location\Facades\Location; 
use Illuminate\Filesystem\Filesystem;

use Mail;
use Illuminate\Support\Facades\Storage;
  
 
date_default_timezone_set("Asia/Bangkok");

class TbController extends Controller
{ 
    public function tb_main(Request $request)
    {
        $startdate = $request->startdate;
        $enddate   = $request->enddate;
        $data['users']     = User::get();  
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate = date('Y-m-d', strtotime($date . ' -1 months')); //ย้อนหลัง 1 เดือน
        $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี
      
        $yearnew = date('Y')+1;
        $yearold = date('Y')-1;
        $start = (''.$yearold.'-10-01');
        $end = (''.$yearnew.'-09-30'); 
               
        if ($startdate == '') {
            $data['d_tb_main']  = DB::connection('mysql')->select('
                SELECT group_code,group_screen,COUNT(DISTINCT vn) as Cvn,COUNT(DISTINCT ovn) as CXR 
                FROM d_tb_main WHERE vstdate BETWEEN "'.$newDate.'" AND "'.$date.'" 
                GROUP BY group_screen
            ');
        } else {
            $data['d_tb_main']  = DB::connection('mysql')->select('
                SELECT group_code,group_screen,COUNT(DISTINCT vn) as Cvn,COUNT(DISTINCT ovn) as CXR 
                FROM d_tb_main WHERE vstdate BETWEEN "'.$startdate.'" AND "'.$enddate.'" 
                GROUP BY group_screen
            ');
        }
         
        return view('tb.tb_main',$data,[
            'startdate'       => $startdate,
            'enddate'         => $enddate, 
        ]);
    }
    public function tb_main_pull(Request $request)
    {
        $startdate            = $request->startdate;
        $enddate              = $request->enddate;
        $data['users']        = User::get(); 
             
            if ($startdate == '') {
            # code...
            } else {
                $data_tb    = DB::connection('mysql2')->select('  
                                SELECT "01" as group_code,"ผู้สัมผัสผู้ป่วยวัณโรคปอด" as group_screen ,v.vn,o.vn as ovn,v.hn,v.cid,v.vstdate,v.pdx,v.pttype,o.icode,n.name as nname,v.income,v.inc04,CONCAT(p.pname ,p.fname," ",p.lname) as ptname
                                ,v.age_y,CONCAT(p.addrpart ," หมู่ ",p.moopart," ",t.full_name," ",te.PostCodeMain) as address
                                FROM vn_stat v 
                                LEFT JOIN patient p ON p.hn = v.hn
                                LEFT JOIN opitemrece o ON o.vn = v.vn AND o.icode IN("3001180","3002625","3002626","3002627","3010136","3010593","3010950")
                                LEFT JOIN nondrugitems n ON n.icode = o.icode
                                LEFT JOIN thaiaddress t ON t.tmbpart = p.tmbpart AND t.amppart = p.amppart AND t.chwpart = p.chwpart
                                LEFT JOIN thaiaddress_eng te ON te.TambonID = concat(p.chwpart,p.amppart,p.tmbpart)
                                WHERE v.pttype = "P1"
                                AND v.vstdate BETWEEN "'.$startdate.'" and "'.$enddate.'"
                                AND o.icode = "3010950"

                                UNION
                                SELECT "02" as group_code,"ผู้ต้องขัง ผู้อาศัยในสถานคุ้มครองและพัฒนาคนพิการ/สถานคุ้มครองคนไร้ที่พึ่ง" as group_screen,v.vn,o.vn as ovn,v.hn,v.cid,v.vstdate,v.pdx,v.pttype,o.icode,n.name as nname,v.income,v.inc04,CONCAT(p.pname ,p.fname," ",p.lname) as ptname
                                ,v.age_y,CONCAT(p.addrpart ," หมู่ ",p.moopart," ",t.full_name," ",te.PostCodeMain) as address
                                FROM vn_stat v 
                                LEFT JOIN patient p ON p.hn = v.hn
                                LEFT JOIN opitemrece o ON o.vn = v.vn AND o.icode IN("3001180","3002625","3002626","3002627","3010136","3010593")
                                LEFT JOIN nondrugitems n ON n.icode = o.icode
                                LEFT JOIN thaiaddress t ON t.tmbpart = p.tmbpart AND t.amppart = p.amppart AND t.chwpart = p.chwpart
                                LEFT JOIN thaiaddress_eng te ON te.TambonID = concat(p.chwpart,p.amppart,p.tmbpart)
                                WHERE v.pttype = "91"
                                AND v.vstdate BETWEEN "'.$startdate.'" and "'.$enddate.'"

                                UNION
                                SELECT "04" as group_code,"HBA1C>7" as group_screen,v.vn,o.vn as ovn,v.hn,v.cid,v.vstdate,v.pdx,v.pttype,o.icode,n.name as nname,v.income,v.inc04,CONCAT(p.pname ,p.fname," ",p.lname) as ptname
                                ,v.age_y,CONCAT(p.addrpart ," หมู่ ",p.moopart," ",t.full_name," ",p.po_code) as address
                                FROM vn_stat v 
                                LEFT JOIN patient p ON p.hn = v.hn
                                LEFT JOIN lab_head l ON l.vn = v.vn
                                LEFT JOIN lab_order la ON la.lab_order_number = l.lab_order_number 
                                LEFT JOIN opitemrece o ON o.vn = v.vn AND o.icode IN("3001180","3002625","3002626","3002627","3010136","3010593")
                                LEFT JOIN nondrugitems n ON n.icode = o.icode
                                LEFT JOIN thaiaddress t ON t.tmbpart = p.tmbpart AND t.amppart = p.amppart AND t.chwpart = p.chwpart 
                                WHERE v.vstdate BETWEEN "'.$startdate.'" and "'.$enddate.'" 
                                AND v.pdx BETWEEN "E100" AND "E149" AND la.lab_items_code ="123" AND la.lab_order_result >= "7"

                                UNION
                                SELECT "04" as group_code,"โรคไตวายเรื้อรัง" as group_screen,v.vn,o.vn as ovn,v.hn,v.cid,v.vstdate,v.pdx,v.pttype,o.icode,n.name as nname,v.income,v.inc04,CONCAT(p.pname ,p.fname," ",p.lname) as ptname
                                ,v.age_y
                                ,CONCAT(p.addrpart ," หมู่ ",p.moopart," ",t.full_name," ",p.po_code) as address
                                FROM vn_stat v 
                                LEFT JOIN patient p ON p.hn = v.hn
                                LEFT JOIN opitemrece o ON o.vn = v.vn AND o.icode IN("3001180","3002625","3002626","3002627","3010136","3010593")
                                LEFT JOIN nondrugitems n ON n.icode = o.icode
                                LEFT JOIN thaiaddress t ON t.tmbpart = p.tmbpart AND t.amppart = p.amppart AND t.chwpart = p.chwpart 
                                WHERE v.vstdate BETWEEN "'.$startdate.'" and "'.$enddate.'"
                                AND v.pdx = "N185"


                                UNION
                                SELECT "05" as group_code,"ผู้สูงอายุมากว่าหรือเท่ากับ 65 ปี ที่สูบบุหรี่หรือมีโรค COPD หรือ DM ร่วมด้วย" as group_screen,v.vn,o.vn as ovn,v.hn,v.cid,v.vstdate,v.pdx,v.pttype,o.icode,n.name as nname,v.income,v.inc04,CONCAT(p.pname ,p.fname," ",p.lname) as ptname
                                ,v.age_y,CONCAT(p.addrpart ," หมู่ ",p.moopart," ",t.full_name," ",te.PostCodeMain) as address
                                FROM vn_stat v 
                                LEFT JOIN patient p ON p.hn = v.hn
                                LEFT JOIN opitemrece o ON o.vn = v.vn AND o.icode IN("3001180","3002625","3002626","3002627","3010136","3010593")
                                LEFT JOIN nondrugitems n ON n.icode = o.icode
                                LEFT JOIN thaiaddress t ON t.tmbpart = p.tmbpart AND t.amppart = p.amppart AND t.chwpart = p.chwpart
                                LEFT JOIN thaiaddress_eng te ON te.TambonID = concat(p.chwpart,p.amppart,p.tmbpart)
                                WHERE v.age_y >= "65"
                                AND v.vstdate BETWEEN "'.$startdate.'" and "'.$enddate.'"
                                AND (v.pdx BETWEEN "J440" AND "J449" OR v.pdx BETWEEN "E100" AND "E149")

                                UNION
                                SELECT "06" as group_code,"ผู้ใช้สารเสพติด ติดสุราเรื้อรัง" as group_screen,v.vn,o.vn as ovn,v.hn,v.cid,v.vstdate,v.pdx,v.pttype,o.icode,n.name as nname,v.income,v.inc04,CONCAT(p.pname ,p.fname," ",p.lname) as ptname
                                ,v.age_y,CONCAT(p.addrpart ," หมู่ ",p.moopart," ",t.full_name," ",te.PostCodeMain) as address
                                FROM vn_stat v  
                                LEFT JOIN patient p ON p.hn = v.hn
                                LEFT JOIN opitemrece o ON o.vn = v.vn AND o.icode IN("3001180","3002625","3002626","3002627","3010136","3010593")
                                LEFT JOIN nondrugitems n ON n.icode = o.icode
                                LEFT JOIN thaiaddress t ON t.tmbpart = p.tmbpart AND t.amppart = p.amppart AND t.chwpart = p.chwpart
                                LEFT JOIN thaiaddress_eng te ON te.TambonID = concat(p.chwpart,p.amppart,p.tmbpart)
                                WHERE v.vstdate BETWEEN "'.$startdate.'" and "'.$enddate.'"
                                AND (v.pdx BETWEEN "Z720" AND "Z722" OR v.pdx BETWEEN "F100" AND "F109" OR v.pdx BETWEEN "F110" AND "F199") 

                                UNION
                                SELECT "07" as group_code,"บุคลากรสาธารณสุข" as group_screen,v.vn,o.vn as ovn,v.hn,v.cid,v.vstdate,v.pdx,v.pttype,o.icode,n.name as nname,v.income,v.inc04,CONCAT(p.pname ,p.fname," ",p.lname) as ptname
                                ,v.age_y,CONCAT(p.addrpart ," หมู่ ",p.moopart," ",t.full_name," ",te.PostCodeMain) as address
                                FROM vn_stat v  
                                LEFT JOIN patient p ON p.hn = v.hn
                                LEFT JOIN opitemrece o ON o.vn = v.vn AND o.icode IN("3001180","3002625","3002626","3002627","3010136","3010593")
                                LEFT JOIN nondrugitems n ON n.icode = o.icode
                                LEFT JOIN thaiaddress t ON t.tmbpart = p.tmbpart AND t.amppart = p.amppart AND t.chwpart = p.chwpart
                                LEFT JOIN thaiaddress_eng te ON te.TambonID = concat(p.chwpart,p.amppart,p.tmbpart)
                                LEFT OUTER JOIN ovst ov on ov.vn = v.vn
                                WHERE v.vstdate BETWEEN "'.$startdate.'" and "'.$enddate.'"
                                AND ov.main_dep = "078"
                                AND p.cid in (SELECT HR_CID FROM patient_hrd)                      
                ');
                foreach ($data_tb as $key => $value) {
                    $check = D_tb_main::where('vn',$value->vn)->count();
                    if ($check > 0) {
                        # code...
                    } else {
                        D_tb_main::insert([
                            'group_code'          => $value->group_code, 
                            'group_screen'        => $value->group_screen, 
                            'vn'                  => $value->vn,
                            'ovn'                 => $value->ovn,
                            'hn'                  => $value->hn,
                            'cid'                 => $value->cid,
                            'vstdate'             => $value->vstdate,
                            'ptname'              => $value->ptname,
                            'pdx'                 => $value->pdx,
                            'pttype'              => $value->pttype,
                            'icode'               => $value->icode, 
                            'nname'               => $value->nname,
                            'income'              => $value->income,
                            'inc04'               => $value->inc04, 
                            'age'                 => $value->age_y, 
                            'address'             => $value->address, 
                            'user_id'             => Auth::user()->id
                        ]);
                    } 
                }
        }        

        return response()->json([
            'status'    => '200'
        ]);
    }
    public function tb_main_detail(Request $request,$id)
    {
        $startdate            = $request->startdate;
        $enddate              = $request->enddate;
        $data['users']        = User::get(); 
        $data['d_tb_main']    = DB::connection('mysql')->select('SELECT vn,hn,cid,ptname,age,address as address2,vstdate,pdx,pttype,icode,nname,income,inc04 FROM d_tb_main WHERE group_code ="'.$id.'" ORDER BY vstdate ASC');
        $data_d_tb_main_name    = DB::connection('mysql')->select('SELECT group_screen FROM d_tb_main WHERE group_code ="'.$id.'" LIMIT 1');
        foreach ($data_d_tb_main_name as $key => $value) {
            $main_name = $value->group_screen;
        }

        return view('tb.tb_main_detail',$data,[
            'startdate'       => $startdate,
            'enddate'         => $enddate, 
            'main_name'       => $main_name, 
        ]);
    }
 
}
