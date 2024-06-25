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
use App\Models\Opitemrece;
use Auth;
use Http;
use SoapClient; 
use SplFileObject;
use Arr;
use Storage;

class PrisonerController extends Controller
{
    public function prisoner_opd(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $leave_month_year = DB::table('leave_month')->orderBy('MONTH_ID', 'ASC')->get();
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์  
        $newDate = date('Y-m-d', strtotime($date . ' -1 months')); //ย้อนหลัง 1 เดือน 
        $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี 
 
        if ($startdate == '') {
            $datashow_ =  DB::connection('mysql3')->select('
                SELECT month(v.vstdate) as months,year(v.vstdate) as year,l.MONTH_NAME
                    ,count(distinct v.hn) as hn
                    ,count(distinct v.vn) as vn 
                    ,sum(v.paid_money) as paid_money
                    ,sum(r.bill_amount) as bill_amount
                    ,sum(v.income) as income                 
                    ,sum(v.income)-sum(v.discount_money)-sum(v.rcpt_money) as total
                  
                    
                    FROM vn_stat v 
                    left outer join opitemrece oo on oo.vn = v.vn 
                    left outer join patient p on p.hn = v.hn   
                    left outer join pttype pt on pt.pttype = v.pttype
                    left outer join rcpt_print r on r.vn =v.vn
                    left outer join social_aid s on s.vn = v.vn
                    left outer join leave_month l on l.MONTH_ID = month(v.vstdate)
                   
                    WHERE v.vstdate between "'.$newyear.'" and "'.$date.'"
                    AND p.addrpart = "438"
                    group by month(v.vstdate) asc
            '); 
            // ,sum(v.income)-sum(r.bill_amount) as total
        } else {
            $datashow_ =  DB::connection('mysql3')->select('
                SELECT month(v.vstdate) as months,year(v.vstdate) as year,l.MONTH_NAME
                    ,count(distinct v.hn) as hn
                    ,count(distinct v.vn) as vn 
                    ,sum(v.paid_money) as paid_money
                    ,sum(r.bill_amount) as bill_amount
                    ,sum(v.income) as income
                    ,sum(v.income)-sum(v.discount_money)-sum(v.rcpt_money) as total
                   

                    FROM vn_stat v 
                    left outer join opitemrece oo on oo.vn = v.vn 
                    left outer join patient p on p.hn = v.hn   
                    left outer join pttype pt on pt.pttype = v.pttype
                    left outer join rcpt_print r on r.vn =v.vn
                    left outer join social_aid s on s.vn = v.vn
                    left outer join leave_month l on l.MONTH_ID = month(v.vstdate)
                    
                    WHERE v.vstdate between "'.$startdate.'" and "'.$enddate.'"                    
                    AND p.addrpart = "438"
                    group by month(v.vstdate) asc
            '); 
        }
        
        // and v.pttype in ("91","92") 

        return view('prisoner.prisoner_opd',[
            'startdate'        => $startdate,
            'enddate'          => $enddate,
            'leave_month_year' => $leave_month_year,
            'datashow'         => $datashow_,
            'newyear'          => $newyear,
            'date'             => $date,
        ]);
    }
    public function prisoner_opd_detail(Request $request,$month,$startdate,$enddate)
    {
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์  
        $newDate = date('Y-m-d', strtotime($date . ' -1 months')); //ย้อนหลัง 1 เดือน 
        $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี 

        if ($startdate == '') {
            $datashow_ =  DB::connection('mysql3')->select('
                SELECT 
                    month(v.vstdate) as months,v.pdx
                    ,year(v.vstdate) as year,v.cid,pt.name as tname
                    ,l.MONTH_NAME,concat(p.pname,p.fname," ",p.lname) as fullname,v.pttype
                    ,v.hn ,v.vn,v.vstdate,v.income,v.paid_money
                    ,sum(oo.sum_price) money_hosxp
                    ,v.discount_money,v.rcpt_money
                    ,v.income-v.discount_money-v.rcpt_money as debit 
                    
                    ,v.rcpno_list rcpno  
             

                    FROM vn_stat v 
                    left outer join opitemrece oo on oo.vn = v.vn 
                    left outer join patient p on p.hn = v.hn   
                    left outer join pttype pt on pt.pttype = v.pttype
                    left outer join rcpt_print r on r.vn =v.vn
                    left outer join social_aid s on s.vn = v.vn
                    left outer join leave_month l on l.MONTH_ID = month(v.vstdate)
               
                    WHERE v.vstdate between "'.$newyear.'" and "'.$date.'"
                    AND p.addrpart = "438"
					AND month(v.vstdate) ="'.$month.'" 
                    group by v.vn asc
            '); 
        } else {
            $datashow_ =  DB::connection('mysql3')->select('
                SELECT 
                    month(v.vstdate) as months,v.pdx
                    ,year(v.vstdate) as year,v.cid,pt.name as tname
                    ,l.MONTH_NAME,concat(p.pname,p.fname," ",p.lname) as fullname,v.pttype
                    ,v.hn ,v.vn,v.vstdate,v.income,v.paid_money  
                    ,sum(oo.sum_price) money_hosxp
                    ,v.discount_money,v.rcpt_money
                    ,v.income-v.discount_money-v.rcpt_money as debit 
                    ,v.rcpno_list rcpno  
                

                    FROM vn_stat v 
                    left outer join opitemrece oo on oo.vn = v.vn 
                    left outer join patient p on p.hn = v.hn   
                    left outer join pttype pt on pt.pttype = v.pttype
                    left outer join rcpt_print r on r.vn =v.vn
                    left outer join social_aid s on s.vn = v.vn
                    left outer join leave_month l on l.MONTH_ID = month(v.vstdate)
                
                    WHERE v.vstdate between "'.$startdate.'" and "'.$enddate.'"
                    AND p.addrpart = "438"
					AND month(v.vstdate) ="'.$month.'"
                    group by v.vn asc
            '); 
        }
         
        return view('prisoner.prisoner_opd_detail',[
            'startdate'        => $startdate,
            'enddate'          => $enddate,          
            'datashow'         => $datashow_,
            'newyear'          => $newyear,
            'date'             => $date,
            'month'             => $month,
        ]);
    }
    public function prisoner_opd_detail_show(Request $request, $vn)
    {
        $detail_ =  DB::connection('mysql3')->select('
                SELECT o.vn,o.hn,o.icode,s.name,o.qty,o.unitprice,o.sum_price 
                FROM opitemrece o
                left outer join s_drugitems s on s.icode = o.icode 
                WHERE o.vn ="'.$vn.'" 
            '); 
        // foreach ($detail_ as $key => $value) {
        //     # code...
        // }
        // $detail =  DB::connection('mysql3')->select('
        // SELECT opitemrece.vn,opitemrece.hn,opitemrece.icode,s_drugitems.name,opitemrece.qty,opitemrece.unitprice,opitemrece.sum_price 
        // FROM opitemrece
        // left outer join s_drugitems s on s.icode = o.icode 
        // ')
        // ->leftjoin('s_drugitems', 's_drugitems.icode', '=', 'opitemrece.icode') 
        // ->find($vn);
        // $detail_ =  Opitemrece::find($vn);
        // dd();

        return response()->json([
            'status'    => '200',
            'detail'    =>  $detail_
        ]);
    }
  
    public function prisoner_opd_detail_excel(Request $request,$month,$startdate,$enddate)
    {   
        $org_ = DB::connection('mysql')->table('orginfo')->where('orginfo_id', '=', 1)->first();
        $org = $org_->orginfo_name;
        $export = DB::connection('mysql3')->select('              
                SELECT 
                month(v.vstdate) as months,v.pdx
                ,year(v.vstdate) as year,v.cid,pt.name as tname
                ,l.MONTH_NAME,concat(p.pname,p.fname," ",p.lname) as fullname,v.pttype
                ,v.hn ,v.vn,v.vstdate,v.income,v.paid_money  
                ,sum(oo.sum_price) money_hosxp
                ,v.discount_money,v.rcpt_money
                ,v.income-v.discount_money-v.rcpt_money as debit 
                ,v.rcpno_list rcpno  
              

                FROM vn_stat v 
                left outer join opitemrece oo on oo.vn = v.vn 
                left outer join patient p on p.hn = v.hn   
                left outer join pttype pt on pt.pttype = v.pttype
                left outer join rcpt_print r on r.vn =v.vn
                left outer join social_aid s on s.vn = v.vn
                left outer join leave_month l on l.MONTH_ID = month(v.vstdate)
              
                WHERE v.vstdate between "'.$startdate.'" and "'.$enddate.'"
                AND p.addrpart = "438"
                AND month(v.vstdate) ="'.$month.'"
                group by v.vn asc
        ');
        
        return view('prisoner.prisoner_opd_detail_excel', [ 
            'export'           =>  $export, 
            'org'              => $org,  
            'm_'                => $month, 
            'startdate'        => $startdate,
            'enddate'          => $enddate,
        ]);
    }

    public function prisoner_ipd(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $leave_month_year = DB::table('leave_month')->orderBy('MONTH_ID', 'ASC')->get();
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์  
        $newDate = date('Y-m-d', strtotime($date . ' -1 months')); //ย้อนหลัง 1 เดือน 
        $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี 
 
        if ($startdate == '') {
            $datashow_ =  DB::connection('mysql3')->select('  
                    SELECT 
			            month(i.dchdate) as months,year(i.dchdate) as year,l.MONTH_NAME
                        ,count(distinct a.hn) as hn
                        ,count(distinct a.an) as an 
                        ,sum(a.paid_money) as paid_money 
                        ,sum(a.income) as income 
                       
                        
                        FROM ipt i
                        left outer join an_stat a on a.an = i.an
                        left outer join opitemrece oo on oo.an = i.an
                        left outer join patient p on p.hn = i.hn   
                        left outer join pttype pt on pt.pttype = i.pttype 
                        left outer join leave_month l on l.MONTH_ID = month(i.dchdate) 
                        WHERE i.dchdate BETWEEN "'.$newyear.'" and "'.$date.'"
                        AND p.addrpart = "438"
                        group by month(i.dchdate) asc
            '); 
        } else {
            $datashow_ =  DB::connection('mysql3')->select('
                    SELECT 
			            month(i.dchdate) as months,year(i.dchdate) as year,l.MONTH_NAME
                        ,count(distinct a.hn) as hn
                        ,count(distinct a.an) as an 
                        ,sum(a.paid_money) as paid_money 
                        ,sum(a.income) as income 
                       
                        FROM ipt i
                        left outer join an_stat a on a.an = i.an
                        left outer join opitemrece oo on oo.an = i.an
                        left outer join patient p on p.hn = i.hn   
                        left outer join pttype pt on pt.pttype = i.pttype 
                        left outer join leave_month l on l.MONTH_ID = month(i.dchdate)
                     
                        WHERE i.dchdate BETWEEN "'.$startdate.'" and "'.$enddate.'" 
                        AND p.addrpart = "438"
                        group by month(i.dchdate) asc
 
            '); 
        }
         
        return view('prisoner.prisoner_ipd',[
            'startdate'        => $startdate,
            'enddate'          => $enddate,
            'leave_month_year' => $leave_month_year,
            'datashow'         => $datashow_,
            'newyear'          => $newyear,
            'date'             => $date,
        ]);
    }
    public function prisoner_ipd_detail(Request $request,$month,$startdate,$enddate)
    {
        $date = date('Y-m-d');
        $y = date('Y') + 543;
        $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์  
        $newDate = date('Y-m-d', strtotime($date . ' -1 months')); //ย้อนหลัง 1 เดือน 
        $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี 

        if ($startdate == '') {
            $datashow_ =  DB::connection('mysql3')->select('
                    SELECT 
                            month(i.dchdate) as months,a.pdx
                            ,year(i.dchdate) as year,p.cid,pt.name as tname
                            ,l.MONTH_NAME,concat(p.pname,p.fname," ",p.lname) as fullname,i.pttype
                            ,i.hn ,i.an,i.dchdate,a.income,a.paid_money
                            ,sum(oo.sum_price) money_hosxp
                            ,a.discount_money 
                            ,m.amountpay     
                            FROM ipt i
                            left outer join hos.an_stat a on a.an = i.an
                            left outer join hos.opitemrece oo on oo.an = i.an
                            left outer join hos.patient p on p.hn = i.hn   
                            left outer join hos.pttype pt on pt.pttype = i.pttype 
                            left outer join hos.leave_month l on l.MONTH_ID = month(i.dchdate)
                            left outer join hshooterdb.m_stm m on m.an = i.an
                            WHERE i.dchdate BETWEEN "'.$newyear.'" and "'.$date.'"
                            AND p.addrpart = "438"
                            AND month(i.dchdate) ="'.$month.'" 
                            group by i.an asc 
            '); 
        } else {
            $datashow_ =  DB::connection('mysql3')->select('
                        SELECT 
                            month(i.dchdate) as months,a.pdx
                            ,year(i.dchdate) as year,p.cid,pt.name as tname
                            ,l.MONTH_NAME,concat(p.pname,p.fname," ",p.lname) as fullname,i.pttype
                            ,i.hn ,i.an,i.dchdate,a.income,a.paid_money
                            ,sum(oo.sum_price) money_hosxp
                            ,a.discount_money 
                            ,m.amountpay     
                            FROM ipt i
                            left outer join hos.an_stat a on a.an = i.an
                            left outer join hos.opitemrece oo on oo.an = i.an
                            left outer join hos.patient p on p.hn = i.hn   
                            left outer join hos.pttype pt on pt.pttype = i.pttype 
                            left outer join hos.leave_month l on l.MONTH_ID = month(i.dchdate)
                            left outer join hshooterdb.m_stm m on m.an = i.an
                            WHERE i.dchdate BETWEEN "'.$startdate.'" and "'.$enddate.'"
                            AND p.addrpart = "438"
                            AND month(i.dchdate) ="'.$month.'" 
                            group by i.an asc  
            '); 
        }
         
        return view('prisoner.prisoner_ipd_detail',[
            'startdate'        => $startdate,
            'enddate'          => $enddate,          
            'datashow'         => $datashow_,
            'newyear'          => $newyear,
            'date'             => $date,
            'month'             => $month,
        ]);
    }
    public function prisoner_ipd_detail_excel(Request $request,$month,$startdate,$enddate)
    {   
        $org_ = DB::connection('mysql')->table('orginfo')->where('orginfo_id', '=', 1)->first();
        $org = $org_->orginfo_name;
        $export = DB::connection('mysql3')->select('              
                SELECT 
                month(i.dchdate) as months,a.pdx
                ,year(i.dchdate) as year,p.cid,pt.name as tname
                ,l.MONTH_NAME,concat(p.pname,p.fname," ",p.lname) as fullname,i.pttype
                ,i.hn ,i.an,i.dchdate,a.income,a.paid_money
                ,sum(oo.sum_price) money_hosxp
                ,a.discount_money 
                ,m.amountpay     
                FROM ipt i
                left outer join hos.an_stat a on a.an = i.an
                left outer join hos.opitemrece oo on oo.an = i.an
                left outer join hos.patient p on p.hn = i.hn   
                left outer join hos.pttype pt on pt.pttype = i.pttype 
                left outer join hos.leave_month l on l.MONTH_ID = month(i.dchdate)
                left outer join hshooterdb.m_stm m on m.an = i.an
                WHERE i.dchdate BETWEEN "'.$startdate.'" and "'.$enddate.'"
                AND p.addrpart = "438"
                AND month(i.dchdate) ="'.$month.'" 
                group by i.an asc  
        ');
        
        return view('prisoner.prisoner_ipd_detail_excel', [ 
            'export'           =>  $export, 
            'org'              => $org,  
            'm_'                => $month, 
            'startdate'        => $startdate,
            'enddate'          => $enddate,
        ]);
    }
    
 

}
