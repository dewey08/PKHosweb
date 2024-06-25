<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\support\Facades\Hash;
use Illuminate\support\Facades\Validator;
use App\Models\User;
use App\Models\Acc_debtor;
use App\Models\Pttype_eclaim;
use App\Models\Account_listpercen;
use App\Models\Leave_month;
use App\Models\Acc_debtor_stamp;
use App\Models\Acc_debtor_sendmoney;
use App\Models\Pttype;
use App\Models\Pttype_acc;
use App\Models\Acc_stm_ti;
use App\Models\Acc_stm_ti_total;
use App\Models\Acc_opitemrece;
use App\Models\Acc_1102050101_202;
use App\Models\Acc_1102050101_217;
use App\Models\Acc_1102050101_2166;
use App\Models\Acc_stm_ucs;
use App\Models\Acc_1102050101_301;
use App\Models\Acc_1102050101_304;
use App\Models\Acc_1102050101_308;
use App\Models\Acc_1102050101_4011;
use App\Models\Acc_1102050101_3099;
use App\Models\Acc_1102050101_401;
use App\Models\Acc_1102050101_402;
use App\Models\Acc_1102050102_801;
use App\Models\Acc_1102050102_802;
use App\Models\Acc_1102050102_803;
use App\Models\Acc_1102050102_804;
use App\Models\Acc_1102050101_4022;
use App\Models\Acc_1102050102_602;
use App\Models\Acc_1102050102_603;
use App\Models\Acc_stm_prb;
use App\Models\Acc_stm_ti_totalhead;
use App\Models\Acc_stm_ti_excel;
use App\Models\Acc_stm_ofc;
use App\Models\acc_stm_ofcexcel;
use App\Models\Acc_stm_lgo;
use App\Models\Acc_stm_lgoexcel;
use App\Models\Check_sit_auto;
use App\Models\Acc_stm_ucs_excel;
use App\Models\Car_service;
use PDF;
use setasign\Fpdi\Fpdi;
use App\Models\Budget_year;
use Illuminate\Support\Facades\File;
use DataTables;
use Intervention\Image\ImageManagerStatic as Image;
use App\Mail\DissendeMail;
use Mail;
use Illuminate\Support\Facades\Storage;
use Auth;
use Http;
use SoapClient;
// use File;
// use SplFileObject;
use Arr;
// use Storage;
use GuzzleHttp\Client;

use App\Imports\ImportAcc_stm_ti;
use App\Imports\ImportAcc_stm_tiexcel_import;
use App\Imports\ImportAcc_stm_ofcexcel_import;
use App\Imports\ImportAcc_stm_lgoexcel_import;
use App\Models\Acc_1102050101_217_stam;
use App\Models\Acc_opitemrece_stm;

use SplFileObject;
use PHPExcel;
use PHPExcel_IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\IOFactory;

date_default_timezone_set("Asia/Bangkok");


class OpipController extends Controller
 {
    // ***************** 301********************************
     
    public function opdtoipd(Request $request)
    {
        $startdate        = $request->startdate;
        $enddate          = $request->enddate;
        $pttype_          = $request->pttype;
        $dabudget_year    = DB::table('budget_year')->where('active','=',true)->first();
        $leave_month_year = DB::table('leave_month')->orderBy('MONTH_ID', 'ASC')->get();
        $date             = date('Y-m-d');
        $y                = date('Y');
        $m                = date('m');
        $newweek          = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate          = date('Y-m-d', strtotime($date . ' -1 months')); //ย้อนหลัง 1 เดือน
        $newyear          = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี
        $pttype           = DB::connection('mysql3')->select('SELECT pttype,name from pttype');

        if ($startdate == '') {
            $datashow = DB::connection('mysql3')->select(' 
                SELECT 
                    year(v.vstdate) as year
                    ,month(v.vstdate) as month 
                    ,count(distinct a.an) as an
                    ,round(sum(v.income),2) as income
                    from hos.an_stat a
                    left outer join hos.ipt i on i.an = a.an
                    left outer join hos.vn_stat v on v.vn = i.vn                    
                    where v.vstdate between "'.$newDate.'" and "'.$date.'"
                    and v.income >"0"
                    GROUP BY month(v.vstdate)
            ');
            $datashow2 = DB::connection('mysql3')->select('
                    SELECT i.vn,a.hn,a.an,a.pttype,a.regdate,i.regtime,a.dchdate,format(a.income,2) as a_income
                    ,format(v.income,2) as v_income,group_concat(distinct r.rcpno,"/",r.bill_amount) as bill_amount,o.staff
                    ,p.cid,concat(p.pname,p.fname," ",p.lname) as ptname
                    from hos.an_stat a
                    left outer join hos.ipt i on i.an = a.an
                    left join vn_stat v on v.vn =i.vn
                    left join rcpt_print r on r.vn = v.vn
                    left join ovst o on o.an = a.an
                    left join patient p on p.hn =o.hn
                    where v.income >"0"
                    AND v.vstdate between "'.$newDate.'" and "'.$date.'"
                    group by a.an 
                    order by v.vstdate 
            ');
            // and year(v.vstdate) = "'.$y.'"
            // AND month(v.vstdate) = "'.$m.'" 

        } else {
            $datashow = DB::connection('mysql3')->select('
                SELECT 
                    year(v.vstdate) as year
                    ,month(v.vstdate) as month 
                    ,count(distinct a.an) as an
                    ,round(sum(v.income),2) as income
                    from hos.an_stat a
                    left outer join hos.ipt i on i.an = a.an
                    left outer join hos.vn_stat v on v.vn = i.vn
                    where v.vstdate between "'.$startdate.'" and "'.$enddate.'"
                    and v.income >"0"
                    GROUP BY month(v.vstdate)
            ');
            $datashow2 = DB::connection('mysql3')->select('
                    SELECT i.vn,a.hn,a.an,a.pttype,a.regdate,i.regtime,a.dchdate,format(a.income,2) as a_income
                    ,format(v.income,2) as v_income,group_concat(distinct r.rcpno,"/",r.bill_amount) as bill_amount,o.staff
                    ,p.cid,concat(p.pname,p.fname," ",p.lname) as ptname
                    from hos.an_stat a
                    left outer join hos.ipt i on i.an = a.an
                    left join vn_stat v on v.vn =i.vn
                    left join rcpt_print r on r.vn = v.vn
                    left join ovst o on o.an = a.an
                    left join patient p on p.hn =o.hn
                    where v.income >"0"
                    AND v.vstdate between "'.$startdate.'" and "'.$enddate.'"
                    AND v.pttype = "'.$pttype_.'"
                    group by a.an
                    order by v.vstdate 
            '); 
        }
        // group by a.an 
        // and year(v.vstdate) = "'.$year.'"
        // AND month(v.vstdate) = "'.$month.'"
 
        return view('report.opdtoipd',[
            'startdate'        => $startdate,
            'enddate'          => $enddate, 
            'datashow'         => $datashow,  
            'pttype'           => $pttype,
            'pttype_'          => $pttype_,
            'datashow2'        => $datashow2, 
        ]);
    }
    public function opdtoipd_sub(Request $request,$vn)
    {
        $startdate    = $request->startdate;
        $enddate      = $request->enddate;
     
            // $datashow = DB::connection('mysql3')->select('
            //         SELECT i.vn,a.hn,a.an,a.pttype,a.regdate,i.regtime,a.dchdate,format(a.income,2) as a_income
            //         ,format(v.income,2) as v_income,group_concat(distinct r.rcpno,"/",r.bill_amount) as bill_amount,o.staff
            //         ,p.cid,concat(p.pname,p.fname," ",p.lname) as ptname
            //         from hos.an_stat a
            //         left outer join hos.ipt i on i.an = a.an
            //         left join vn_stat v on v.vn =i.vn
            //         left join rcpt_print r on r.vn = v.vn
            //         left join ovst o on o.an = a.an
            //         left join patient p on p.hn =o.hn
            //         where v.income >"0" 
            //         AND v.vn = "'.$vn.'" 
            //         order by v.vstdate 
            // ');  
            $datashow = DB::connection('mysql3')->select('
                    select i.income,i.name,sum(o.qty) as qty,
                    (select format(sum(sum_price),2) from opitemrece where vn=o.vn and income = o.income and paidst in("02")) as claim,
                    (select format(sum(sum_price),2) from opitemrece where vn=o.vn and income = o.income and paidst in("01","03")) as noclaim
                    from opitemrece o
                    left outer join nondrugitems n on n.icode = o.icode
                    left outer join income i on i.income = o.income
                    where o.vn ="'.$vn.'" 
                    group by i.name
                    order by i.income
            ');

            $datashow2 = DB::connection('mysql3')->select(' 
                    select d.outdate,o.name as staff_name,d.intime,k1.department as from_department,d.outtime,k2.department as to_department
                    from ptdepart d  
                    left outer join kskdepartment k1 on k1.depcode = d.depcode 
                    left outer join kskdepartment k2 on k2.depcode = d.outdepcode  
                    left outer join opduser o on o.loginname = d.staff 
                    where d.vn = "'.$vn.'" order by d.intime
            ');  

        return view('report.opdtoipd_sub',[
            'startdate'        => $startdate,
            'enddate'          => $enddate, 
            'datashow'         => $datashow,
            'datashow2'        => $datashow2,  
            'vn'               => $vn,  
        ]);
    }

    public function opdtoipd_subsubclaim(Request $request,$vn,$income)
    {
        $startdate    = $request->startdate;
        $enddate      = $request->enddate;
      
            $datashow = DB::connection('mysql3')->select('
                   
                    select ifnull(n.billcode,d.icode) as icode,ifnull(n.name,d.name) as dname,sum(o.qty) as qty,format(sum(sum_price),2) as price,o.staff,o.rxtime,
                    (select regtime from ipt where an = o.an order by regtime limit 1) as rxtimeadmit
                    from opitemrece o
                    left outer join nondrugitems n on n.icode = o.icode
                    left outer join drugitems d on d.icode = o.icode
                    left outer join income i on i.income = o.income
                    left outer join ipt ii on ii.an = o.an
                    where o.vn ="'.$vn.'" 
                    and o.income = "'.$income.'"
                    group by o.icode
                    order by o.icode
            ');
 

        return view('report.opdtoipd_subsubclaim',[
            'startdate'        => $startdate,
            'enddate'          => $enddate, 
            'datashow'         => $datashow, 
            'vn'               => $vn,  
        ]);
    }
    public function opdtoipd_subsub(Request $request,$vn,$income)
    {
        $startdate    = $request->startdate;
        $enddate      = $request->enddate;
      
            $datashow = DB::connection('mysql3')->select('
                   
                    select ifnull(n.billcode,d.icode) as icode,ifnull(n.name,d.name) as dname,sum(o.qty) as qty,format(sum(sum_price),2) as price,o.staff,o.rxtime,
                    (select regtime from ipt where an = o.an order by regtime limit 1) as rxtimeadmit
                    from opitemrece o
                    left outer join nondrugitems n on n.icode = o.icode
                    left outer join drugitems d on d.icode = o.icode
                    left outer join income i on i.income = o.income
                    left outer join ipt ii on ii.an = o.an
                    where o.vn ="'.$vn.'" 
                    and o.income = "'.$income.'"
                    group by o.icode
                    order by o.icode
            ');
 

        return view('report.opdtoipd_subsub',[
            'startdate'        => $startdate,
            'enddate'          => $enddate, 
            'datashow'         => $datashow, 
            'vn'               => $vn,  
        ]);
    }

   
 

 }