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

class PctController extends Controller
{
    public function thalassemia_year(Request $request)
    {
        $datestart = $request->startdate;
        $dateend = $request->enddate; 
        // dd($iddep);
        $datashow_opd = DB::connection('mysql3')->select('
                select year(a.vstdate) as years,count(distinct a.vn) as VN 
                    from vn_stat a
                    left outer join patient p on p.hn = a.hn
                    left outer join ovstdiag i on i.vn = a.vn
                    left outer join pttype pt on pt.pttype=a.pttype
                    where a.vstdate between "'.$datestart.'" and "'.$dateend.'"
                    and i.icd10 between "d560" and "d599"
                    and pt.hipdata_code="UCS"
                    group by year(a.vstdate)
        ');
        $datashow_ipd = DB::connection('mysql3')->select('
                select year(a.dchdate) as years,count(distinct a.an) as AN 
                    from an_stat a
                    left outer join patient p on p.hn = a.hn
                    left outer join iptdiag i on i.an = a.an
                    left outer join iptoprt ii on ii.an = a.an
                    left outer join pttype pt on pt.pttype=a.pttype
                    where a.dchdate between "'.$datestart.'" and "'.$dateend.'"
                    and i.icd10 between "d560" and "d599"
                    and pt.hipdata_code="UCS"
                    group by year(a.dchdate)
        ');

        return view('pct.thalassemia_year',[
            'startdate'       =>  $datestart,
            'enddate'         =>  $dateend, 
            'datashow_opd'    =>  $datashow_opd,
            'datashow_ipd'    =>  $datashow_ipd
        ]);
    }
    public function thalassemia_yearsearch(Request $request)
    {
        $datestart = $request->startdate;
        $dateend = $request->enddate;  
        $datashow_opd = DB::connection('mysql3')->select('
        select year(a.vstdate) as years,count(distinct a.vn) as VN 
                    from vn_stat a
                    left outer join patient p on p.hn = a.hn
                    left outer join ovstdiag i on i.vn = a.vn
                    left outer join pttype pt on pt.pttype=a.pttype
                    where a.vstdate between "'.$datestart.'" and "'.$dateend.'"
                    and i.icd10 between "d560" and "d599"
                    and pt.hipdata_code="UCS"
                    group by year(a.vstdate)
        ');
        $datashow_ipd = DB::connection('mysql3')->select('
                    select year(a.dchdate) as years,count(distinct a.an) as AN 
                    from an_stat a
                    left outer join patient p on p.hn = a.hn
                    left outer join iptdiag i on i.an = a.an
                    left outer join iptoprt ii on ii.an = a.an
                    left outer join pttype pt on pt.pttype=a.pttype
                    where a.dchdate between "'.$datestart.'" and "'.$dateend.'"
                    and i.icd10 between "d560" and "d599"
                    and pt.hipdata_code="UCS"
                    group by year(a.dchdate)
            ');
        return view('pct.thalassemia_year',[
            'startdate'       =>  $datestart,
            'enddate'         =>  $dateend, 
            'datashow_opd'    =>  $datashow_opd,
            'datashow_ipd'    =>  $datashow_ipd
        ]);
    }
    
    public function thalassemia_ipd(Request $request)
    {
        $datestart = $request->startdate;
        $dateend = $request->enddate; 
        // dd($iddep);
        $datashow_opd = DB::connection('mysql3')->select('
                select year(a.vstdate) as years,count(distinct a.vn) as VN 
                    from vn_stat a
                    left outer join patient p on p.hn = a.hn
                    left outer join ovstdiag i on i.vn = a.vn
                    left outer join pttype pt on pt.pttype=a.pttype
                    where a.vstdate between "'.$datestart.'" and "'.$dateend.'"
                    and i.icd10 between "d560" and "d599"
                    and pt.hipdata_code="UCS"
                    group by year(a.vstdate)
        ');
        $datashow_ipd = DB::connection('mysql3')->select('
                select year(a.dchdate) as years,count(distinct a.an) as AN 
                    from an_stat a
                    left outer join patient p on p.hn = a.hn
                    left outer join iptdiag i on i.an = a.an
                    left outer join iptoprt ii on ii.an = a.an
                    left outer join pttype pt on pt.pttype=a.pttype
                    where a.dchdate between "'.$datestart.'" and "'.$dateend.'"
                    and i.icd10 between "d560" and "d599"
                    and pt.hipdata_code="UCS"
                    group by year(a.dchdate)
        ');

        return view('pct.thalassemia_ipd',[
            'startdate'       =>  $datestart,
            'enddate'         =>  $dateend, 
            'datashow_opd'    =>  $datashow_opd,
            'datashow_ipd'    =>  $datashow_ipd
        ]);
    }

    public function thalassemia_opd(Request $request,$months,$startdate,$enddate)
    { 
        $datashow_opd = DB::connection('mysql3')->select('             
                select month(a.vstdate) as months,count(distinct a.vn) as VN,count(distinct o.vn) as OVN from vn_stat a
                    left outer join patient p on p.hn = a.hn
                    left outer join ovstdiag i on i.vn = a.vn
                    left outer join pttype pt on pt.pttype=a.pttype
                    left outer join hos.opitemrece o on o.vn = a.vn and icode in("1520001","1570508","1590015")
                    left outer join ipt ip on ip.vn = a.vn
                    where a.vstdate between "'.$startdate.'" and "'.$enddate.'"
                    and i.icd10 between "d560" and "d599"
                    and pt.hipdata_code="UCS"
                    group by month(a.vstdate)
                ');
         
        return view('pct.thalassemia_opd',[
            'startdate'       =>  $startdate,
            'enddate'         =>  $enddate, 
            'datashow_opd'    =>  $datashow_opd, 
        ]);
    }
    public function thalassemia_opdsub(Request $request,$months,$startdate,$enddate)
    { 
        $datashow_opd = DB::connection('mysql3')->select('  
                    select a.hn,a.vn,concat(p.pname,p.fname," ",p.lname) as fullname,p.cid, year(now())-year(p.birthday) as age,a.vstdate,a.pdx
                        ,group_concat(distinct d.name,"=",o.qty) as xx
                        ,group_concat(distinct l2.lab_items_name,"=",l1.lab_order_result," ","(",l1.laborder_date,")" ) as lab
                        ,max(t.pid) as tpid,max(t.vstdate) as tvstdate,max(t.blood) as maxblood
                        ,max(t.med) as tmed from hos.vn_stat a
                        left outer join hos.ovstdiag i on i.vn = a.vn
                        left outer join hos.patient p on p.hn = a.hn
                        left outer join hos.pttype pt on pt.pttype=a.pttype
                        left outer join hos.opitemrece o on o.vn = a.vn
                        left outer join eclaimdb.tsh t on t.pid=p.cid and t.vstdate = a.vstdate
                        left outer join hos.drugitems d on d.icode = o.icode and d.icode in("1520001","1570508","1590015")
                        left join hos.lab_head l on l.vn = a.vn
                        left join hos.lab_order l1 on l1.lab_order_number =l.lab_order_number and l1.lab_items_code in ("253","254","546","935","899","223","223","224","225")
                        left outer join lab_items l2 on l2.lab_items_code = l1.lab_items_code
                        where i.icd10 between "d560" and "d599"
                        and pt.hipdata_code="UCS"

                        and a.vstdate between "'.$startdate.'" and "'.$enddate.'"
                        and month(a.vstdate) ="'.$months.'"
                        group by a.vn  order by a.vstdate
                ');
         
        return view('pct.thalassemia_opdsub',[
            'startdate'       =>  $startdate,
            'enddate'         =>  $enddate, 
            'datashow_opd'    =>  $datashow_opd, 
        ]);
    }

    public function thalassemia_opdsub_diag(Request $request,$hn,$startdate,$enddate)
    { 
        $datashow_diagipd = DB::connection('mysql3')->select('  
                    select a.hn,a.an,a.regdate,a.dchdate,i.icd10,n.name as listlab,(select nn.name from opitemrece oo
                        left outer join drugitems nn on nn.icode = oo.icode
                        where oo.an= a.an
                        and oo.icode in("1520001","1570508","1590015") ORDER BY oo.vstdate limit 1 ) as nname,(select icd9 from hos.iptoprt where an = a.an and icd9="9904" ORDER BY a.regdate limit 1 ) as blood,
                        (select icd9 from hos.iptoprt where an = a.an and icd9="9904" ORDER BY a.regdate limit 1 ) as iptoprt from 
                        an_stat a
                        left join ipt ii on ii.an = a.an
                        left join iptdiag i on i.an = a.an
                        left join icd101 n on n.code = i.icd10
                        left join iptoprt nn on nn.an = a.an
                        left join hos.lab_head l on l.vn = a.an
                        left join opdscreen o on o.vn = ii.vn
                        where a.hn ="'.$hn.'"
                        group by a.an
                        order by a.dchdate,i.diagtype
                ');
        $datashow_diagopd = DB::connection('mysql3')->select(' 
                select a.hn,a.vn,a.vstdate,a.pdx,n.name as listlab,
                    (select nn.name from opitemrece oo
                    left outer join drugitems nn on nn.icode = oo.icode
                    where oo.vn= a.vn
                    and oo.icode in("1520001","1570508","1590015") ORDER BY oo.vstdate limit 1 ) as nname ,(select icd10 from hos.ovstdiag where vn = a.vn and icd10="9904" ORDER BY a.vstdate limit 1 ) as blood,
                    (select icd10 from hos.ovstdiag where vn = a.vn and icd10="9904" ORDER BY a.vstdate limit 1 ) as iptoprt from 
                    vn_stat a
                    left join ipt ii on ii.vn = a.vn
                    left join ovstdiag i on i.vn = a.vn
                    left join icd101 n on n.code = i.icd10
                    left join hos.lab_head l on l.vn = a.vn
                    left join opdscreen o on o.vn = ii.vn
                    where a.hn ="'.$hn.'"
                    group by a.vn
                    order by a.vstdate,i.diagtype 
            ');
         
        return view('pct.thalassemia_opdsub_diag',[
            'startdate'       =>  $startdate,
            'enddate'         =>  $enddate, 
            'datashow_diagipd'    =>  $datashow_diagipd, 
            'datashow_diagopd'    =>  $datashow_diagopd, 
        ]);
    }
    public function thalassemia_opdsub_diag_vn(Request $request,$vn )
    { 
        $thalassemia_opdsub_diag_vn = DB::connection('mysql3')->select('  
                select ip.icd10,i.name as iname,ip.diagtype from ovstdiag ip
                left outer join icd101 i on i.code = ip.icd10
                where ip.vn ="'.$vn.'" order by ip.diagtype 
                ');
         
        return view('pct.thalassemia_opdsub_diag_vn',[ 
            'thalassemia_opdsub_diag_vn'    =>  $thalassemia_opdsub_diag_vn, 
        ]);
    }
    public function thalassemia_opdsubdrug(Request $request,$months,$startdate,$enddate)
    { 
        $datashow_opd = DB::connection('mysql3')->select('  
           
                    select a.hn,a.vn,concat(p.pname,p.fname," ",p.lname) as fullname,p.cid, year(now())-year(p.birthday) as age,a.vstdate,a.pdx
                        ,group_concat(distinct d.name,"=",o.qty) as xx
                        ,group_concat(distinct l2.lab_items_name,"=",l1.lab_order_result," ","(",l1.laborder_date,")") as lab
                        ,max(t.pid) as tpid,max(t.vstdate) as tvstdate,max(t.blood) as maxblood
                        ,max(t.med) as tmed from hos.vn_stat a
                        left outer join hos.ovstdiag i on i.vn = a.vn
                        left outer join hos.patient p on p.hn = a.hn
                        left outer join hos.pttype pt on pt.pttype=a.pttype
                        left outer join hos.opitemrece o on o.vn = a.vn
                        left outer join eclaimdb.tsh t on t.pid=p.cid and t.vstdate = o.vstdate
                        left outer join hos.drugitems d on d.icode = o.icode and d.icode in("1520001","1570508","1590015")
                        left join hos.lab_head l on l.vn = a.vn
                        left join hos.lab_order l1 on l1.lab_order_number =l.lab_order_number and l1.lab_items_code in ("253","254","546","935","899","223","223","224","225")
                        left outer join lab_items l2 on l2.lab_items_code = l1.lab_items_code
                        where i.icd10 between "d560" and "d599"
                        and pt.hipdata_code="UCS"

                        and o.vstdate between "'.$startdate.'" and "'.$enddate.'"
                        and month(a.vstdate) = "'.$months.'"
                        group by a.vn having  xx <> " " order by a.vstdate

                ');
         
        return view('pct.thalassemia_opdsubdrug',[
            'startdate'       =>  $startdate,
            'enddate'         =>  $enddate, 
            'datashow_opd'    =>  $datashow_opd, 
        ]);
    }
    public function thalassemia_opdsubdrug_hn(Request $request,$hn,$startdate,$enddate )
    { 
        $thalassemia_opdsubdrug_hn = DB::connection('mysql3')->select(' 
                select a.hn,a.an,a.regdate,a.dchdate,i.icd10,n.name as listlab,(select nn.name from opitemrece oo
                left outer join drugitems nn on nn.icode = oo.icode
                where oo.an= a.an
                and oo.icode in("1520001","1570508","1590015") ORDER BY oo.vstdate limit 1 ) as nname,(select icd9 from hos.iptoprt where an = a.an and icd9="9904" ORDER BY a.regdate limit 1 ) as blood,
                (select icd9 from hos.iptoprt where an = a.an and icd9="9904" ORDER BY a.regdate limit 1 ) as iptoprt
                from an_stat a
                left join ipt ii on ii.an = a.an
                left join iptdiag i on i.an = a.an
                left join icd101 n on n.code = i.icd10
                left join iptoprt nn on nn.an = a.an
                left join hos.lab_head l on l.vn = a.an
                left join opdscreen o on o.vn = ii.vn
                where a.regdate between "'.$startdate.'" and "'.$enddate.'"
                and a.hn ="'.$hn.'"
                group by a.an
                order by a.dchdate,i.diagtype                
                ');
                // where a.regdate between "'.$startdate.'" and "'.$enddate.'"
                // and a.hn ="'.$hn.'"

        $datashow_opd = DB::connection('mysql3')->select('  
                select a.hn,a.vn,a.vstdate,a.pdx,n.name as nname,
                    (select nn.name from opitemrece oo
                    left outer join drugitems nn on nn.icode = oo.icode
                    where oo.vn= a.vn
                    and oo.icode in("1520001","1570508","1590015") ORDER BY oo.vstdate limit 1 ) as listlab,(select icd10 from hos.ovstdiag where vn = a.vn and icd10="9904" ORDER BY a.vstdate limit 1 ) as blood,
                    (select icd10 from hos.ovstdiag where vn = a.vn and icd10="9904" ORDER BY a.vstdate limit 1 ) as iptoprt from 
                    vn_stat a
                    left join ipt ii on ii.vn = a.vn
                    left join ovstdiag i on i.vn = a.vn
                    left join icd101 n on n.code = i.icd10
                    left join hos.lab_head l on l.vn = a.vn
                    left join opdscreen o on o.vn = ii.vn
                    where a.vstdate between "'.$startdate.'" and "'.$enddate.'"
                    and a.hn ="'.$hn.'"
                    group by a.vn
                    order by a.vstdate,i.diagtype
            ');
         
        return view('pct.thalassemia_opdsubdrug_hn',[ 
            'thalassemia_opdsubdrug_hn'    =>  $thalassemia_opdsubdrug_hn, 
            'datashow_opd'    =>  $datashow_opd, 
        ]);
    }

    public function thalassemia_opdsubdrug_hos(Request $request,$vn,$startdate,$enddate)
    { 
        $datashow_hos = DB::connection('mysql3')->select(' 
                select n.name as nname,o.qty,o.sum_price,concat(d.name1," ",d.name2," ",d.name3) as drugchai,o.vstdate from opitemrece o
                    left outer join drugitems n on n.icode = o.icode
                    left outer join sp_use d on d.sp_use = o.sp_use
                    where o.icode in("1520001","1570508","1590015")
                    and o.vn ="'.$vn.'" 
                ');
         
        return view('pct.thalassemia_opdsubdrug_hos',[
            'startdate'       =>  $startdate,
            'enddate'         =>  $enddate, 
            'datashow_hos'    =>  $datashow_hos, 
        ]);
    }

    public function thalassemia(Request $request)
    {
        $datestart = $request->startdate;
        $dateend = $request->enddate; 
        // dd($iddep);
        $datashow_opd = DB::connection('mysql3')->select('
                select month(a.vstdate) as months,count(distinct a.vn) as VN 
                    from vn_stat a
                    left outer join patient p on p.hn = a.hn
                    left outer join ovstdiag i on i.vn = a.vn
                    left outer join pttype pt on pt.pttype=a.pttype
                    where a.vstdate between "'.$datestart.'" and "'.$dateend.'"
                    and i.icd10 between "d560" and "d599"
                    and pt.hipdata_code="UCS"
                    group by month(a.vstdate)
        ');
        $datashow_ipd = DB::connection('mysql3')->select('
                select month(a.dchdate) as months,count(distinct a.an) as AN 
                    from an_stat a
                    left outer join patient p on p.hn = a.hn
                    left outer join iptdiag i on i.an = a.an
                    left outer join iptoprt ii on ii.an = a.an
                    left outer join pttype pt on pt.pttype=a.pttype
                    where a.dchdate between "'.$datestart.'" and "'.$dateend.'"
                    and i.icd10 between "d560" and "d599"
                    and pt.hipdata_code="UCS"
                    group by month(a.dchdate)
        ');

        return view('pct.thalassemia',[
            'startdate'       =>  $datestart,
            'enddate'         =>  $dateend, 
            'datashow_opd'    =>  $datashow_opd,
            'datashow_ipd'    =>  $datashow_ipd
        ]);
    }
    public function thalassemia_search(Request $request)
    {
        $datestart = $request->startdate;
        $dateend = $request->enddate;  
        $datashow_opd = DB::connection('mysql3')->select('
                select month(a.vstdate) as months,count(distinct a.vn) as VN 
                    from vn_stat a
                    left outer join patient p on p.hn = a.hn
                    left outer join ovstdiag i on i.vn = a.vn
                    left outer join pttype pt on pt.pttype=a.pttype
                    where a.vstdate between "'.$datestart.'" and "'.$dateend.'"
                    and i.icd10 between "d560" and "d599"
                    and pt.hipdata_code="UCS"
                    group by month(a.vstdate)
        ');
        $datashow_ipd = DB::connection('mysql3')->select('
                    select month(a.dchdate) as months,count(distinct a.an) as AN 
                        from an_stat a
                        left outer join patient p on p.hn = a.hn
                        left outer join iptdiag i on i.an = a.an
                        left outer join iptoprt ii on ii.an = a.an
                        left outer join pttype pt on pt.pttype=a.pttype
                        where a.dchdate between "'.$datestart.'" and "'.$dateend.'"
                        and i.icd10 between "d560" and "d599"
                        and pt.hipdata_code="UCS"
                        group by month(a.dchdate)
            ');
        return view('pct.thalassemia',[
            'startdate'       =>  $datestart,
            'enddate'         =>  $dateend, 
            'datashow_opd'    =>  $datashow_opd,
            'datashow_ipd'    =>  $datashow_ipd
        ]);
    }
    public function thalassemia_opdsub_diag_an(Request $request,$an )
    { 
        $thalassemia_opdsub_diag_an = DB::connection('mysql3')->select(' 
                select ip.icd10,i.name as iname,ip.diagtype from iptdiag ip
                left outer join icd101 i on i.code = ip.icd10
                where ip.an ="'.$an.'" order by ip.diagtype  
                ');
        $thalassemia_opdsub_diag_an9 = DB::connection('mysql3')->select(' 
                select io.icd9,ii.name as iname,io.priority,io.opdate,io.optime,io.enddate,io.endtime from iptoprt io
                    left outer join icd9cm1 ii on ii.code = io.icd9
                    where io.an ="'.$an.'"               
                ');         
        return view('pct.thalassemia_opdsub_diag_an',[ 
            'thalassemia_opdsub_diag_an'    =>  $thalassemia_opdsub_diag_an, 
            'thalassemia_opdsub_diag_an9'    =>  $thalassemia_opdsub_diag_an9, 
        ]);
    }
    public function thalassemia_opdsub_diag_lab(Request $request,$an )
    { 
        $thalassemia_opdsub_diag_lab = DB::connection('mysql3')->select(' 
                select h.hn,h.order_date,l.lab_items_name,n.lab_order_result from lab_head h
                    left outer join lab_order n on n.lab_order_number = h.lab_order_number
                    left outer join lab_items l on l.lab_items_code = n.lab_items_code
                    where  h.vn ="'.$an.'" and  n.lab_order_result <>" "
                    and l.lab_items_code in ("253","254","546","935","899","223","223","224","225")
  
                ');
 
        return view('pct.thalassemia_opdsub_diag_lab',[ 
            'thalassemia_opdsub_diag_lab'    =>  $thalassemia_opdsub_diag_lab  
        ]);
    }
    public function thalassemia_opdsub_diag_blood(Request $request,$an )
    { 
        $thalassemia_opdsub_diag_blood = DB::connection('mysql3')->select(' 
            select n.name as nname,o.qty,o.sum_price,o.vstdate from opitemrece o
                left outer join nondrugitems n on n.icode = o.icode
                where o.icode in("3003108","3004148","3003096","3003111","3003112","3009204","3009203","3003109")
                and o.an ="'.$an.'" 
                ');
        $thalassemia_opdsub_diag_blood2 = DB::connection('mysql3')->select(' 
            select li.lab_items_name,l.lab_order_result,h.order_date from lab_head  h 
                LEFT JOIN lab_order l on l.lab_order_number = h.lab_order_number
                left join lab_items li on li.lab_items_code = l.lab_items_code
                where h.vn ="'.$an.'"
                and l.lab_order_result <>" "
                group by li.lab_items_code         
                ');         
        return view('pct.thalassemia_opdsub_diag_blood',[ 
            'thalassemia_opdsub_diag_blood'    =>  $thalassemia_opdsub_diag_blood, 
            'thalassemia_opdsub_diag_blood2'    =>  $thalassemia_opdsub_diag_blood2, 
        ]);
    }
    public function thalassemia_opdsub_diag_labvn(Request $request,$vn )
    { 
        $thalassemia_opdsub_diag_labvn = DB::connection('mysql3')->select(' 
                select h.hn,h.order_date,l.lab_items_name,n.lab_order_result from lab_head h
                    left outer join lab_order n on n.lab_order_number = h.lab_order_number
                    left outer join lab_items l on l.lab_items_code = n.lab_items_code
                    where  h.vn ="'.$vn.'" and  n.lab_order_result <>" "
                    and l.lab_items_code in ("253","254","546","935","899","223","223","224","225")  
                ');
         return view('pct.thalassemia_opdsub_diag_labvn',[ 
            'thalassemia_opdsub_diag_labvn'    =>  $thalassemia_opdsub_diag_labvn  
        ]);
    }
    public function thalassemia_opdsub_drugvn(Request $request,$vn )
    { 
        $thalassemia_opdsub_drugvn  = DB::connection('mysql3')->select(' 
                select n.name as nname,o.qty,o.sum_price,concat(d.name1," ",d.name2," ",d.name3) as dname,o.vstdate from opitemrece o
                    left outer join drugitems n on n.icode = o.icode
                    left outer join sp_use d on d.sp_use = o.sp_use
                    where o.icode in("1520001","1570508","1590015")
                    and o.vn ="'.$vn.'"
 
                ');
         return view('pct.thalassemia_opdsub_drugvn',[ 
            'thalassemia_opdsub_drugvn'    =>  $thalassemia_opdsub_drugvn   
        ]);
    }
     
    public function thalassemia_opdsub_drugdiag_hn(Request $request,$an )
    { 
        $thalassemia_opdsub_drugdiag_hn = DB::connection('mysql3')->select(' 
            select ip.icd10,i.name as iname,ip.diagtype from iptdiag ip
            left outer join icd101 i on i.code = ip.icd10
            where ip.an ="'.$an.'" order by ip.diagtype 
                ');
        $thalassemia_opdsub_drugdiag_lab = DB::connection('mysql3')->select(' 
                select io.icd9,ii.name as iname,io.priority,io.opdate,io.optime,io.enddate,io.endtime from iptoprt io
                left outer join icd9cm1 ii on ii.code = io.icd9
                where io.an ="'.$an.'"                      
                ');         
        return view('pct.thalassemia_opdsub_drugdiag_hn',[ 
            'thalassemia_opdsub_drugdiag_hn'    =>  $thalassemia_opdsub_drugdiag_hn, 
            'thalassemia_opdsub_drugdiag_lab'    =>  $thalassemia_opdsub_drugdiag_lab, 
        ]);
    }
 
}
