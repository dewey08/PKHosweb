<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\support\Facades\Hash;
use Illuminate\support\Facades\Validator;
use App\Models\User;
use App\Models\Rep_report;
use App\Models\m_registerdata;
use PDF;
use setasign\Fpdi\Fpdi;
use App\Models\Budget_year;
use Illuminate\Support\Facades\File;
use DataTables;
use Intervention\Image\ImageManagerStatic as Image;

class PrbController extends Controller
{
    public function prb_opd(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate; 
        
       $data['data_prb'] =  DB::connection('mysql3')->select('
                    SELECT month(v.vstdate) as months,
                    count(distinct v.hn) as hn,
                    count(v.vn) as vn,
                    sum(r.rcpno is not null) as norcpno,
                    sum(r.rcpno is null) as rcpno,
                    sum(v.vn in (select vn from social_aid where vn is not null)) as social_aid,
                    sum(v.paid_money) as paid_money,
                    sum(r.bill_amount) as bill_amount,
                    sum(v.income) as income,
                    sum(v.income)-sum(r.bill_amount) as total
                    FROM vn_stat v
                    left outer join ipt i on i.vn = v.vn
                    left outer join rcpt_print r on r.vn =v.vn
                    left outer join social_aid s on s.vn = v.vn
                    WHERE v.vstdate between "'.$startdate.'" and "'.$enddate.'"
                    and v.pttype in ("09","32","33")
                    and i.an is null
                    group by month(v.vstdate)
                    '); 
        return view('prb.prb_opd', $data,[ 
            'startdate'      =>  $startdate,
            'enddate'      =>  $enddate,
            ]);
    }
    public function prb_opd_sub(Request $request,$months,$startdate,$enddate)
    { 
        $data['data_prb'] =  DB::connection('mysql3')->select('
                select o.vstdate,count(distinct o.vn) as countvn
                from ovst o
                LEFT OUTER JOIN patient p ON p.hn=o.hn
                left outer join rcpt_print r on r.vn =o.vn
                left outer join referout ro on ro.vn = o.vn
                where o.vstdate between "'.$startdate.'" and "'.$enddate.'"
                and o.pttype in ("09","32","33")
                and month(o.vstdate) = "'.$months.'"
                and o.an is null
                group by day(o.vstdate) 
            '); 
        return view('prb.prb_opd_sub', $data,[ 
            'startdate'      =>  $startdate,
            'enddate'      =>  $enddate,
            'months'      =>  $months,
            ]);
    }
    public function prb_opd_subsub(Request $request,$day,$months,$startdate,$enddate)
    { 
        $data['data_prb'] =  DB::connection('mysql3')->select('
                    select o.vstdate,o.vsttime,o.hn,p.cid,o.an,concat(p.pname,p.fname," ",p.lname) as fullname,w.name,o.pttype,group_concat(distinct r.rcpno," /",r.total_amount) as rcpno,v.income,ro.refer_hospcode,roo.refer_hospcode as hospcode,
                    (select concat(plain_text," " ,note_datetime," ",note_staff) from ptnote where note_staff in ("joy","Jamescup","toob","rung1234","จารุชา","เยี่ยมรัตน์")
                    and hn=o.hn order by note_datetime desc limit 1) as note
                    fROM ovst o
                    LEFT OUTER JOIN patient p ON p.hn=o.hn
                    left outer join rcpt_print r on r.vn =o.vn
                    left outer join referout ro on ro.vn = o.vn
                    left outer join referout roo on roo.vn = o.an
                    left outer join vn_stat v on v.vn = o.vn
                    left outer join an_stat a on a.an = o.an
                    left outer join ward w on w.ward = a.ward
                    WHERE o.vstdate BETWEEN "'.$startdate.'" and "'.$enddate.'"
                    and o.pttype in ("09","32","33")
                    and o.vstdate = "'.$day.'"
                    and o.an is null
                    and month(o.vstdate) = "'.$months.'" group by v.vn
            '); 
        return view('prb.prb_opd_subsub', $data);
    }


    public function prb_ipd(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate; 
        
        $data['data_prb'] =  DB::connection('mysql3')->select('
                SELECT month(v.regdate) as months,
                count(distinct v.hn) as hn,
                count(v.an) as an,
                sum(r.rcpno is not null) as norcpno,
                sum(r.rcpno is null) as rcpno,
                sum(v.vn in (select vn from social_aid where vn is not null)) as social_aid,
                sum(v.paid_money) as paid_money,
                sum(r.bill_amount) as bill_amount,
                sum(v.income) as income,
                sum(v.income)-sum(r.bill_amount) as total
                FROM an_stat v
                left outer join ipt i on i.an = v.an
                left outer join rcpt_print r on r.vn =i.vn
                left outer join social_aid s on s.vn = i.vn
                WHERE v.regdate between "'.$startdate.'" and "'.$enddate.'"
                and v.pttype in ("09","32","33")               
                group by month(v.regdate)
        '); 
        
        return view('prb.prb_ipd', $data,[ 
            'startdate'      =>  $startdate,
            'enddate'      =>  $enddate,
            ]);
    }
    public function prb_ipd_sub(Request $request,$months,$startdate,$enddate)
    { 
        $data['data_prb'] =  DB::connection('mysql3')->select('
                select o.regdate,count(distinct o.hn) as counthn
                from an_stat o
                LEFT OUTER JOIN patient p ON p.hn=o.hn
                left outer join rcpt_print r on r.vn =o.vn
                left outer join referout ro on ro.vn = o.vn
                where o.regdate between "'.$startdate.'" and "'.$enddate.'"
                and o.pttype  in ("09","32","33")
                and month(o.regdate) = "'.$months.'"
                group by day(o.regdate)
            '); 
                

        return view('prb.prb_ipd_sub', $data,[ 
            'startdate'      =>  $startdate,
            'enddate'      =>  $enddate,
            'months'      =>  $months,
            ]);
    }
    public function prb_ipd_subsub(Request $request,$day,$months,$startdate,$enddate)
    { 
        $data['data_prb'] =  DB::connection('mysql3')->select('
                  
                    select o.regdate,o.hn,o.vn,concat(p.pname,p.fname,"  ",p.lname) as fullname,o.pttype,o.paid_money,o.income
                    ,ifnull(group_concat(" ",rr.rcpno,"/",rr.amount),(SELECT group_concat(" ",r.rcpno,"/",r.bill_amount) from hos.rcpt_print r where r.vn=o.an)) as bill_amount, 
                    format(sum(rr.amount),2) as hos,
                    rr.paid,
                    if(ip.nhso_ownright_name like"%77%","เซนต์","") as nee,
                    if(ip.nhso_ownright_name like"%1%","ทวงครั้งที่ 1"," ") as book,
                    (select concat(plain_text," "  ,note_datetime," ",note_staff) from hos.ptnote 
                    where hn=o.hn order by note_datetime desc limit 1) as note,
                    w.name as wardname
                    fROM hos.an_stat o
                    LEFT OUTER JOIN hos.patient p ON p.hn=o.hn
                    left outer join hos.rcpt_print r on r.vn =o.an
                    left outer join hos.referout ro on ro.vn = o.vn
                    left outer join hos.rcpt_arrear rr on rr.vn = o.an
                    left outer join hos.ipt_pttype ip on ip.an = o.an
                    left outer join hos.ward w on w.ward = o.ward
                    where o.regdate between "'.$startdate.'" and "'.$enddate.'"
                    and o.pttype in ("09","32","33")
                    and o.regdate = "'.$day.'"
                    and month(o.regdate) = "'.$months.'" group by o.an
            '); 
        return view('prb.prb_ipd_subsub', $data);
    }

   
    public function prb_cpo(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate; 
        
        $data['data_cpo'] =  DB::connection('mysql3')->select('
                select v.hn,v.cid,v.vstdate,v.pdx,oo.cc,concat(p.pname,p.fname," ",p.lname) as fullname,
                v.pttype,v.income,v.paid_money,group_concat(distinct r.rcpno,"/",r.bill_amount) as bill_amount,
                o.rfrolct,o.has_insurance
                from vn_stat v
                left outer join ipt i on i.vn = v.vn
                left outer join ovst o on o.vn = v.vn
                left outer join opdscreen oo on oo.vn = v.vn
                left outer join patient p on p.hn = v.hn 
                left join rcpt_print r on r.vn = v.vn
                where v.vstdate between "'.$startdate.'" and "'.$enddate.'"
                and i.an is null
                and v.pttype in("09","31","32","33")
                and v.income >"0"
                group by v.vn
        '); 
        
        return view('prb.prb_cpo', $data,[ 
            'startdate'      =>  $startdate,
            'enddate'      =>  $enddate,
            ]);
    }

    public function prb_repopd(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate; 
        
        $data['data_repopd'] =  DB::connection('mysql3')->select('
                select month(v.vstdate) as vstdate
                ,count(distinct v.hn) as hn
                ,count(distinct v.vn) as vn
                ,sum(vp.claim_code ="1") as claim_code
                ,sum(vp.claim_code ="2" or vp.claim_code is null) as noclaim_code
                ,sum(v.income) as income
                ,sum(vp.nhso_ownright_pid) as ownright_pid
                ,sum(vp.nhso_ownright_name) as ownright_name
                from vn_stat v
                left outer join ipt i on i.vn = v.vn
                left outer join pttype p on p.pttype = v.pttype 
                left outer join visit_pttype vp on vp.vn = v.vn
                where v.vstdate between "'.$startdate.'" and "'.$enddate.'"
                and i.an is null
                and v.pttype in("36","37","38","39")
                group by month(v.vstdate)
        '); 
        
        return view('prb.prb_repopd', $data,[ 
            'startdate'      =>  $startdate,
            'enddate'      =>  $enddate,
            ]);
    }
    public function prb_repopd_subhn(Request $request,$months,$startdate,$enddate)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate; 
        
        $data['data_repopdsubhn'] =  DB::connection('mysql3')->select('
               
                select v.hn,v.cid,v.vstdate,v.pdx,oo.cc,concat(p.pname,p.fname," ",p.lname) as fullname,v.pttype,o.rfrolct,o.has_insurance
                    from vn_stat v
                    left outer join ipt i on i.vn = v.vn
                    left outer join ovst o on o.vn = v.vn
                    left outer join opdscreen oo on oo.vn = v.vn
                    left outer join patient p on p.hn = v.hn 
                    where v.vstdate between "'.$startdate.'" and "'.$enddate.'"
                    and i.an is null
                    and v.pttype in("36","37","38","39")
                    and month(v.vstdate) = "'.$months.'"
                    group by v.hn
        '); 
        
        return view('prb.prb_repopd_subhn', $data,[ 
            'startdate'      =>  $startdate,
            'enddate'      =>  $enddate,
            ]);
    }
    public function prb_repopd_subvn(Request $request,$months,$startdate,$enddate)
    {
      
        $data['data_repopdsubvn'] =  DB::connection('mysql3')->select(' 

                    select v.vn,v.hn,v.cid,v.vstdate,v.pdx,oo.cc,concat(p.pname,p.fname," ",p.lname) as fullname,v.pttype,
                    format(v.income,2) as income,
                    format(v.paid_money,2) as paid_money,
                    format(v.uc_money,2) as uc_money,
                    o.rfrolct,
                    o.has_insurance
                    from vn_stat v
                    left outer join ipt i on i.vn = v.vn
                    left outer join ovst o on o.vn = v.vn
                    left outer join opdscreen oo on oo.vn = v.vn
                    left outer join patient p on p.hn = v.hn 
                    where v.vstdate between "'.$startdate.'" and "'.$enddate.'"
                    and i.an is null
                    and v.pttype in("36","37","38","39")
                    and month(v.vstdate) = "'.$months.'"
                    group by v.vn
        '); 
        
        return view('prb.prb_repopd_subvn', $data,[ 
            'startdate'      =>  $startdate,
            'enddate'      =>  $enddate,
            ]);
    }
    public function prb_repopd_subsubvn(Request $request,$vn)
    {
      
        $data['data_repopdsubsubvn'] =  DB::connection('mysql3')->select(' 
                    select o.hn,o.an,concat(p.pname,p.fname," ",p.lname) as fullname,p.cid,ov.vstdate,ip.dchdate
                    from opitemrece o
                    left outer join nondrugitems n on n.icode = o.icode
                    left outer join income i on i.income = o.income
                    left outer join ovst ov on ov.vn = o.vn
                    left outer join ipt ip on ip.an = o.an
                    left outer join hos.patient p on p.hn = ov.hn 
                    where o.vn ="'.$vn.'" 
                    group by p.cid
        '); 
        $data['data_icd'] =  DB::connection('mysql3')->select(' 
                    select ip.icd10,i.name,i.tname,ip.diagtype from ovstdiag ip
                    left outer join icd101 i on i.code = ip.icd10
                    where ip.vn ="'.$vn.'" order by ip.diagtype 
        ');
        $data['data_payhos'] =  DB::connection('mysql3')->select(' 
                    select i.income,i.name,sum(o.qty) as qty,
                    (select format(sum(sum_price),2) from opitemrece where vn=o.vn and income = o.income and paidst in("02")) as pay,
                    (select format(sum(sum_price),2) from opitemrece where vn=o.vn and income = o.income and paidst in("01","03")) as nopay
                    from opitemrece o
                    left outer join nondrugitems n on n.icode = o.icode
                    left outer join income i on i.income = o.income
                    left outer join ovst ov on ov.vn = o.vn
                    left join eclaimdb.m_registerdata m on m.hn = o.hn 
                    and DATE_FORMAT(DATE_ADD((m.DATEADM), INTERVAL -543 YEAR),"%Y-%m-%d") = o.vstdate
                    and left(ov.vsttime,5) = mid(TIME_FORMAT(m.TIMEADM,"%r"),4,5) and m.status in("0","1","4","5")
                    left outer join eclaimdb.m_sumfund mm on mm.eclaim_no = m.eclaim_no
                    left join hshooterdb.m_stm s on s.vn = o.vn
                    where o.vn ="'.$vn.'" 
                    group by i.name
                    order by i.income 
        '); 

        $data['data_payhoslist'] =  DB::connection('mysql3')->select(' 
                    select d.icode,n.nhso_adp_code,ifnull(n.name,d.name) as name,sum(o.qty) as qty,format(sum(sum_price),2) as price
                    from opitemrece o
                    left outer join nondrugitems n on n.icode = o.icode
                    left outer join drugitems d on d.icode = o.icode
                    left outer join income i on i.income = o.income
                    where o.vn ="'.$vn.'"
                    group by o.icode
                    order by o.icode
        ');
        
        return view('prb.prb_repopd_subsubvn', $data);
    }
    public function prb_repopd_subreq(Request $request,$months,$startdate,$enddate)
    {
     
        $data['data_repopdsubreq'] =  DB::connection('mysql3')->select('
                select v.hn,v.cid,v.vstdate,v.pdx,concat(p.pname,p.fname,"",p.lname) as fullname,v.pttype,v.income,
                if(vp.claim_code ="1","เบิก","") as claim_code,
                vp.nhso_docno,vp.nhso_ownright_pid,vp.nhso_ownright_name
                from vn_stat v
                left outer join ipt i on i.vn = v.vn
                left outer join ovst o on o.vn = v.vn
                left outer join opdscreen oo on oo.vn = v.vn
                left outer join patient p on p.hn = v.hn 
                left outer join visit_pttype vp on vp.vn = v.vn
                where v.vstdate between "'.$startdate.'" and "'.$enddate.'"
                and i.an is null
                and v.pttype in("36","37","38","39")
                and vp.claim_code ="1"
                and month(v.vstdate) = "'.$months.'"
                group by v.vn
                order by v.hn,v.vstdate  
        '); 
        
        return view('prb.prb_repopd_subreq', $data,[ 
            'startdate'      =>  $startdate,
            'enddate'      =>  $enddate,
            ]);
    }
    public function prb_repopd_subnoreq(Request $request,$months,$startdate,$enddate)
    {
      
        $data['data_repopdsubnoreq'] =  DB::connection('mysql3')->select('
            select v.hn,v.cid,v.vstdate,v.pdx,concat(p.pname,p.fname," ",p.lname) as fullname,v.pttype,v.income,
            if(vp.claim_code ="1","เบิก","") as claim_code,
            vp.nhso_docno,vp.nhso_ownright_pid,vp.nhso_ownright_name
            from vn_stat v
            left outer join ipt i on i.vn = v.vn
            left outer join ovst o on o.vn = v.vn
            left outer join opdscreen oo on oo.vn = v.vn
            left outer join patient p on p.hn = v.hn 
            left outer join visit_pttype vp on vp.vn = v.vn
            where v.vstdate between "'.$startdate.'" and "'.$enddate.'"
            and i.an is null
            and v.pttype in("36","37","38","39")
            and month(v.vstdate) = "'.$months.'"
            and (vp.claim_code ="2" or vp.claim_code is null)
            group by v.vn
            order by v.hn,v.vstdate 
        '); 
        
        return view('prb.prb_repopd_subnoreq', $data,[ 
            'startdate'      =>  $startdate,
            'enddate'      =>  $enddate,
            ]);
    }


    public function prb_repipd(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate; 
        
        $data['data_repipd'] =  DB::connection('mysql3')->select('
                select month(v.dchdate) as months,
                count(distinct v.hn) as hn,count(distinct v.an) as an
                ,sum(vp.nhso_ownright_pid >"0") as nhso_ownright_pid
                ,count(distinct v.an)-sum(vp.claim_code ="1") as claim_code
                ,sum(v.income) as income
                ,sum(vp.nhso_ownright_pid) nhso_ownright_pidtotal
                ,sum(vp.nhso_ownright_name) as nhso_ownright_name
                ,100*sum(vp.claim_code ="1")/count(distinct v.an) as afterclaim_code
                from an_stat v
                left outer join pttype p on p.pttype = v.pttype 
                left outer join ipt_pttype vp on vp.an = v.an
                where v.dchdate between "'.$startdate.'" and "'.$enddate.'"
                and vp.pttype in("36","37","38","39","31","32")
                and vp.pttype_number ="1"
                group by month(v.dchdate)
 
        '); 
        
        return view('prb.prb_repipd', $data,[ 
            'startdate'      =>  $startdate,
            'enddate'      =>  $enddate,
            ]);
    }
    public function prb_repipd_subhn(Request $request,$months,$startdate,$enddate)
    {        
        $data['data_repipdsubhn'] =  DB::connection('mysql3')->select('
                select v.hn,v.an,p.cid,v.dchdate,v.pdx,oo.cc,concat(p.pname,p.fname," ",p.lname) as fullname,v.pttype
                from an_stat v
                left outer join opdscreen oo on oo.vn = v.vn
                left outer join patient p on p.hn = v.hn 
                where v.dchdate between "'.$startdate.'" and "'.$enddate.'"
                and v.pttype in("36","37","38","39")
                and month(v.dchdate) = "'.$months.'"
                group by v.hn
                
        '); 
        
        return view('prb.prb_repipd_subhn', $data,[ 
            'startdate'      =>  $startdate,
            'enddate'      =>  $enddate,
            ]);
    }
    public function prb_repipd_subvn(Request $request,$months,$startdate,$enddate)
    {
        $data['data_repipdsubvn'] =  DB::connection('mysql3')->select(' 
                    select v.hn,v.an,p.cid,v.dchdate,v.pdx,concat(p.pname,p.fname," ",p.lname) as fullname,
                    v.pttype,group_concat(distinct " ",r.rcpno,"/",r.total_amount) as amount,
                    v.income,v.paid_money,v.remain_money,vp.max_debt_amount,nhso_docno,vp.nhso_ownright_pid,vp.nhso_govname,
                    (select concat(plain_text," " ,note_datetime," ",note_staff) from hos.ptnote where note_staff in ("joy","toob","rung1234","จารุชา","เยี่ยมรัตน์")and hn=i.hn order by note_datetime desc limit 1) as note
                    from an_stat v
                    left outer join ipt i on i.an = v.an
                    left outer join patient p on p.hn = v.hn 
                    left outer join ipt_pttype vp on vp.an = i.an
                    left outer join rcpt_print r on r.vn =v.an
                    where v.dchdate between "'.$startdate.'" and "'.$enddate.'"
                    and v.pttype in("36","37","38","39","31","32")
                    and month(v.dchdate) = "'.$months.'"
                    group by v.an
                    order by v.pttype
        '); 
        
        return view('prb.prb_repipd_subvn', $data,[ 
            'startdate'      =>  $startdate,
            'enddate'      =>  $enddate,
            ]);
    }
    public function prb_repipd_subsuban(Request $request,$an,$startdate,$enddate)
    {
        
        $data['prb_repipd_subsuban'] =  DB::connection('mysql3')->select(' 
            select o.hn,o.an,concat(p.pname,p.fname," ",p.lname) as fullname,p.cid,ip.regdate,ip.dchdate
            from opitemrece o
            left outer join nondrugitems n on n.icode = o.icode
            left outer join income i on i.income = o.income
            left outer join ovst ov on ov.vn = o.vn
            left outer join ipt ip on ip.an = o.an
            left outer join hos.patient p on p.hn = ip.hn
            where o.an ="'.$an.'" 
            group by p.cid 
        '); 
        $data['prb_repipd_icd'] =  DB::connection('mysql3')->select(' 
            select ip.icd10,i.name as nameen,i.tname,ip.diagtype from iptdiag ip
            left outer join icd101 i on i.code = ip.icd10
            where ip.an ="'.$an.'" order by ip.diagtype
 
        '); 

        $data['prb_repipd_icd9'] =  DB::connection('mysql3')->select(' 
            select io.icd9,ii.name,io.priority,io.opdate,io.optime,io.enddate,io.endtime from iptoprt io
            left outer join icd9cm1 ii on ii.code = io.icd9
            where io.an ="'.$an.'" 
 
        '); 

        $data['prb_repipd_reportpay'] =  DB::connection('mysql3')->select(' 
            select i.income,i.name,sum(o.qty) as qty,
            (select format(sum(sum_price),2) from opitemrece where an=o.an and income = o.income and paidst in("02")) as paidst,
            (select format(sum(sum_price),2) from opitemrece where an=o.an and income = o.income and paidst in("01","03")) as nopaidst
            from opitemrece o
            left outer join nondrugitems n on n.icode = o.icode
            left outer join income i on i.income = o.income
            where o.an ="'.$an.'" 
            and o.pttype in ("36","37","38","39") 
            group by i.name
            order by i.income
  
        '); 
        $data['prb_repipd_room'] =  DB::connection('mysql3')->select(' 
            select n.billcode,n.name,sum(o.qty) as qty,
            sum(sum_price) as paidst,
            (select sum(sum_price) from opitemrece where an=o.an and income = o.income and paidst in("01","03")) as nopaidst from opitemrece o
            left outer join nondrugitems n on n.icode = o.icode
            left outer join income i on i.income = o.income
            where o.an ="'.$an.'" 
            and o.income="01"
            and o.pttype in ("36","37","38","39") 
            group by n.name
            order by i.income  
        '); 

        $data['prb_repipd_ti'] =  DB::connection('mysql3')->select(' 
            select n.billcode,n.name,sum(o.qty) as qty,
            sum(sum_price) as paidst,
            (select sum(sum_price) from opitemrece where an=o.an and income = o.income and paidst in("01","03")) as nopaidst from opitemrece o
            left outer join nondrugitems n on n.icode = o.icode
            left outer join income i on i.income = o.income
            where o.an ="'.$an.'" 
            and o.income="02"
            and o.pttype in ("36","37","38","39") 
            group by n.name
            order by i.income  
        ');
        $data['prb_repipd_drugnation'] =  DB::connection('mysql3')->select(' 
            select n.icode,n.name,sum(o.qty) as qty,
            sum(sum_price) as paidst,
            (select sum(sum_price) from opitemrece where an=o.an and income = o.income and paidst in("01","03")) as nopaidst from opitemrece o
            left outer join drugitems n on n.icode = o.icode
            left outer join income i on i.income = o.income
            where o.an ="'.$an.'"  
            and o.income="03"
            and o.pttype in ("36","37","38","39") 
            group by n.name
            order by i.income 
        ');

        $data['prb_repipd_drugopd'] =  DB::connection('mysql3')->select(' 
            select n.icode,n.name,sum(o.qty) as qty,
            
            sum(sum_price) as paidst,
            (select sum(sum_price) from opitemrece where an=o.an and income = o.income and paidst in("01","03")) as nopaidst from opitemrece o
            left outer join drugitems n on n.icode = o.icode
            left outer join income i on i.income = o.income
            where o.an ="'.$an.'"  
            and o.income="17"
            and o.pttype in ("36","37","38","39") 
            group by n.name
            order by i.income 
        ');
        $data['prb_repipd_drughome'] =  DB::connection('mysql3')->select(' 
            select n.icode as nicode,n.name as namedrug,sum(o.qty) as qty,
            i.name namecome,
            sum(sum_price) as paidst,
            (select sum(sum_price) from opitemrece where an=o.an and income = o.income and paidst in("01","03")) as nopaidst from opitemrece o
            left outer join drugitems n on n.icode = o.icode
            left outer join income i on i.income = o.income
            where o.an ="'.$an.'" 
            and o.income="04"
            and o.pttype in ("36","37","38","39") 
            group by n.name
            order by i.income 
        ');
        $data['prb_repipd_nondrug'] =  DB::connection('mysql3')->select(' 
            select n.icode as nicode,n.name as namedrug,sum(o.qty) as qty,
            sum(sum_price) as paidst,
            (select sum(sum_price) from opitemrece where an=o.an and income = o.income and paidst in("01","03")) as nopaidst from opitemrece o
            left outer join nondrugitems n on n.icode = o.icode
            left outer join income i on i.income = o.income
            where o.an ="'.$an.'" 
            and o.income="05"
            and o.pttype in ("36","37","38","39") 
            group by n.name
            order by i.income 
        ');
        $data['prb_repipd_tecnic'] =  DB::connection('mysql3')->select(' 
            select n.icode as nicode,n.name as namedrug,sum(o.qty) as qty,
            sum(sum_price) as paidst,
            (select sum(sum_price) from opitemrece where an=o.an and income = o.income and paidst in("01","03")) as nopaidst from opitemrece o
            left outer join nondrugitems n on n.icode = o.icode
            left outer join income i on i.income = o.income
            where o.an ="'.$an.'" 
            and o.income="07"
            and o.pttype in ("36","37","38","39") 
            group by n.name
            order by i.income 
        ');
        $data['prb_repipd_rungsee'] =  DB::connection('mysql3')->select(' 
            select n.icode as nicode,n.name as namedrug,sum(o.qty) as qty,
            sum(sum_price) as paidst,
            (select sum(sum_price) from opitemrece where an=o.an and income = o.income and paidst in("01","03")) as nopaidst from opitemrece o
            left outer join nondrugitems n on n.icode = o.icode
            left outer join income i on i.income = o.income
            where o.an ="'.$an.'" 
            and o.income="08"
            and o.pttype in ("36","37","38","39") 
            group by n.name
            order by i.income 
        ');
        $data['prb_repipd_medical'] =  DB::connection('mysql3')->select(' 
            select n.icode as nicode,n.name as namedrug,sum(o.qty) as qty,
            sum(sum_price) as paidst,
            (select sum(sum_price) from opitemrece where an=o.an and income = o.income and paidst in("01","03")) as nopaidst from opitemrece o
            left outer join nondrugitems n on n.icode = o.icode
            left outer join income i on i.income = o.income
            where o.an ="'.$an.'" 
            and o.income="10"
            and o.pttype in ("36","37","38","39") 
            group by n.name
            order by i.income 
        ');
        $data['prb_repipd_huttakarn'] =  DB::connection('mysql3')->select(' 
            select n.icode as nicode,n.name as namedrug,sum(o.qty) as qty,
            sum(sum_price) as paidst,
            (select sum(sum_price) from opitemrece where an=o.an and income = o.income and paidst in("01","03")) as nopaidst from opitemrece o
            left outer join nondrugitems n on n.icode = o.icode
            left outer join income i on i.income = o.income
            where o.an ="'.$an.'" 
            and o.income="11"
            and o.pttype in ("36","37","38","39") 
            group by n.name
            order by i.income 
        ');
        $data['prb_repipd_nurst'] =  DB::connection('mysql3')->select(' 
            select n.icode as nicode,n.name as namedrug,sum(o.qty) as qty,
            sum(sum_price) as paidst,
            (select sum(sum_price) from opitemrece where an=o.an and income = o.income and paidst in("01","03")) as nopaidst from opitemrece o
            left outer join nondrugitems n on n.icode = o.icode
            left outer join income i on i.income = o.income
            where o.an ="'.$an.'" 
            and o.income="12"
            and o.pttype in ("36","37","38","39") 
            group by n.name
            order by i.income 
        ');
        $data['prb_repipd_bumbad'] =  DB::connection('mysql3')->select(' 
            select n.icode as nicode,n.name as namedrug,sum(o.qty) as qty,
            sum(sum_price) as paidst,
            (select sum(sum_price) from opitemrece where an=o.an and income = o.income and paidst in("01","03")) as nopaidst from opitemrece o
            left outer join nondrugitems n on n.icode = o.icode
            left outer join income i on i.income = o.income
            where o.an ="'.$an.'" 
            and o.income="14"
            and o.pttype in ("36","37","38","39") 
            group by n.name
            order by i.income 
        ');
        $data['prb_repipd_carrefer'] =  DB::connection('mysql3')->select(' 
            select n.icode as nicode,n.name as namedrug,sum(o.qty) as qty,
            sum(sum_price) as paidst,
            (select sum(sum_price) from opitemrece where an=o.an and income = o.income and paidst in("01","03")) as nopaidst from opitemrece o
            left outer join nondrugitems n on n.icode = o.icode
            left outer join income i on i.income = o.income
            where o.an ="'.$an.'" 
            and o.income="18"
            and o.pttype in ("36","37","38","39") 
            group by n.name
            order by i.income 
        ');
        $data['prb_repipd_other'] =  DB::connection('mysql3')->select(' 
            select n.icode as nicode,n.name as namedrug,sum(o.qty) as qty,
            sum(sum_price) as paidst,
            (select sum(sum_price) from opitemrece where an=o.an and income = o.income and paidst in("01","03")) as nopaidst from opitemrece o
            left outer join nondrugitems n on n.icode = o.icode
            left outer join income i on i.income = o.income
            where o.an ="'.$an.'" 
            and o.income="20"
            and o.pttype in ("36","37","38","39") 
            group by n.name
            order by i.income 
        ');
        $data['prb_repipd_covid19'] =  DB::connection('mysql3')->select('
            select n.billcode as nicode,n.name as namedrug,sum(o.qty) as qty,sum(sum_price) as paidst,
            (select sum(sum_price) from opitemrece where an=o.an and income = o.income and paidst in("01","03") and income="02") as nopaidst from opitemrece o
            left outer join nondrugitems n on n.icode = o.icode
            left outer join income i on i.income = o.income 
            where o.an ="'.$an.'"
            and o.icode in("3010601","3010605","3010590","3010604","3010602","3010603","3010592","3010591","3010600","3000406"
            ,"3000407","3010640","3010641","3010697","3010698","3010677")
            and o.pttype in ("36","37","38","39") 
            group by n.name
            order by i.income 
        ');
        
        
        return view('prb.prb_repipd_subsuban', $data ,[
            'an'    =>   $an
        ]);
    }

    public function prb_repipd_subsuban_print(Request $request,$an)
    {
        
        $data['prb_repipd_subsuban'] =  DB::connection('mysql3')->select(' 
            select o.hn,o.an,concat(p.pname,p.fname," ",p.lname) as fullname,p.cid,ip.regdate,ip.dchdate
            from opitemrece o
            left outer join nondrugitems n on n.icode = o.icode
            left outer join income i on i.income = o.income
            left outer join ovst ov on ov.vn = o.vn
            left outer join ipt ip on ip.an = o.an
            left outer join hos.patient p on p.hn = ip.hn
            where o.an ="'.$an.'" 
            group by p.cid 
        '); 
        $data['prb_repipd_icd'] =  DB::connection('mysql3')->select(' 
            select ip.icd10,i.name as nameen,i.tname,ip.diagtype from iptdiag ip
            left outer join icd101 i on i.code = ip.icd10
            where ip.an ="'.$an.'" order by ip.diagtype
 
        '); 

        $data['prb_repipd_icd9'] =  DB::connection('mysql3')->select(' 
            select io.icd9,ii.name,io.priority,io.opdate,io.optime,io.enddate,io.endtime from iptoprt io
            left outer join icd9cm1 ii on ii.code = io.icd9
            where io.an ="'.$an.'" 
 
        '); 

        $data['prb_repipd_reportpay'] =  DB::connection('mysql3')->select(' 
            select i.income,i.name,sum(o.qty) as qty,
            (select format(sum(sum_price),2) from opitemrece where an=o.an and income = o.income and paidst in("02")) as paidst,
            (select format(sum(sum_price),2) from opitemrece where an=o.an and income = o.income and paidst in("01","03")) as nopaidst
            from opitemrece o
            left outer join nondrugitems n on n.icode = o.icode
            left outer join income i on i.income = o.income
            where o.an ="'.$an.'" 
            and o.pttype in ("36","37","38","39") 
            group by i.name
            order by i.income
  
        '); 
        $data['prb_repipd_room'] =  DB::connection('mysql3')->select(' 
            select n.billcode,n.name,sum(o.qty) as qty,
            sum(sum_price) as paidst,
            (select sum(sum_price) from opitemrece where an=o.an and income = o.income and paidst in("01","03")) as nopaidst from opitemrece o
            left outer join nondrugitems n on n.icode = o.icode
            left outer join income i on i.income = o.income
            where o.an ="'.$an.'" 
            and o.income="01"
            and o.pttype in ("36","37","38","39") 
            group by n.name
            order by i.income  
        '); 

        $data['prb_repipd_ti'] =  DB::connection('mysql3')->select(' 
            select n.billcode,n.name,sum(o.qty) as qty,
            sum(sum_price) as paidst,
            (select sum(sum_price) from opitemrece where an=o.an and income = o.income and paidst in("01","03")) as nopaidst from opitemrece o
            left outer join nondrugitems n on n.icode = o.icode
            left outer join income i on i.income = o.income
            where o.an ="'.$an.'" 
            and o.income="02"
            and o.pttype in ("36","37","38","39") 
            group by n.name
            order by i.income  
        ');
        $data['prb_repipd_drugnation'] =  DB::connection('mysql3')->select(' 
            select n.icode,n.name,sum(o.qty) as qty,
            sum(sum_price) as paidst,
            (select sum(sum_price) from opitemrece where an=o.an and income = o.income and paidst in("01","03")) as nopaidst from opitemrece o
            left outer join drugitems n on n.icode = o.icode
            left outer join income i on i.income = o.income
            where o.an ="'.$an.'"  
            and o.income="03"
            and o.pttype in ("36","37","38","39") 
            group by n.name
            order by i.income 
        ');

        $data['prb_repipd_drugopd'] =  DB::connection('mysql3')->select(' 
            select n.icode,n.name,sum(o.qty) as qty,
            
            sum(sum_price) as paidst,
            (select sum(sum_price) from opitemrece where an=o.an and income = o.income and paidst in("01","03")) as nopaidst from opitemrece o
            left outer join drugitems n on n.icode = o.icode
            left outer join income i on i.income = o.income
            where o.an ="'.$an.'"  
            and o.income="17"
            and o.pttype in ("36","37","38","39") 
            group by n.name
            order by i.income 
        ');
        $data['prb_repipd_drughome'] =  DB::connection('mysql3')->select(' 
            select n.icode as nicode,n.name as namedrug,sum(o.qty) as qty,
            i.name namecome,
            sum(sum_price) as paidst,
            (select sum(sum_price) from opitemrece where an=o.an and income = o.income and paidst in("01","03")) as nopaidst from opitemrece o
            left outer join drugitems n on n.icode = o.icode
            left outer join income i on i.income = o.income
            where o.an ="'.$an.'" 
            and o.income="04"
            and o.pttype in ("36","37","38","39") 
            group by n.name
            order by i.income 
        ');
        $data['prb_repipd_nondrug'] =  DB::connection('mysql3')->select(' 
            select n.icode as nicode,n.name as namedrug,sum(o.qty) as qty,
            sum(sum_price) as paidst,
            (select sum(sum_price) from opitemrece where an=o.an and income = o.income and paidst in("01","03")) as nopaidst from opitemrece o
            left outer join nondrugitems n on n.icode = o.icode
            left outer join income i on i.income = o.income
            where o.an ="'.$an.'" 
            and o.income="05"
            and o.pttype in ("36","37","38","39") 
            group by n.name
            order by i.income 
        ');
        $data['prb_repipd_tecnic'] =  DB::connection('mysql3')->select(' 
            select n.icode as nicode,n.name as namedrug,sum(o.qty) as qty,
            sum(sum_price) as paidst,
            (select sum(sum_price) from opitemrece where an=o.an and income = o.income and paidst in("01","03")) as nopaidst from opitemrece o
            left outer join nondrugitems n on n.icode = o.icode
            left outer join income i on i.income = o.income
            where o.an ="'.$an.'" 
            and o.income="07"
            and o.pttype in ("36","37","38","39") 
            group by n.name
            order by i.income 
        ');
        $data['prb_repipd_rungsee'] =  DB::connection('mysql3')->select(' 
            select n.icode as nicode,n.name as namedrug,sum(o.qty) as qty,
            sum(sum_price) as paidst,
            (select sum(sum_price) from opitemrece where an=o.an and income = o.income and paidst in("01","03")) as nopaidst from opitemrece o
            left outer join nondrugitems n on n.icode = o.icode
            left outer join income i on i.income = o.income
            where o.an ="'.$an.'" 
            and o.income="08"
            and o.pttype in ("36","37","38","39") 
            group by n.name
            order by i.income 
        ');
        $data['prb_repipd_medical'] =  DB::connection('mysql3')->select(' 
            select n.icode as nicode,n.name as namedrug,sum(o.qty) as qty,
            sum(sum_price) as paidst,
            (select sum(sum_price) from opitemrece where an=o.an and income = o.income and paidst in("01","03")) as nopaidst from opitemrece o
            left outer join nondrugitems n on n.icode = o.icode
            left outer join income i on i.income = o.income
            where o.an ="'.$an.'" 
            and o.income="10"
            and o.pttype in ("36","37","38","39") 
            group by n.name
            order by i.income 
        ');
        $data['prb_repipd_huttakarn'] =  DB::connection('mysql3')->select(' 
            select n.icode as nicode,n.name as namedrug,sum(o.qty) as qty,
            sum(sum_price) as paidst,
            (select sum(sum_price) from opitemrece where an=o.an and income = o.income and paidst in("01","03")) as nopaidst from opitemrece o
            left outer join nondrugitems n on n.icode = o.icode
            left outer join income i on i.income = o.income
            where o.an ="'.$an.'" 
            and o.income="11"
            and o.pttype in ("36","37","38","39") 
            group by n.name
            order by i.income 
        ');
        $data['prb_repipd_nurst'] =  DB::connection('mysql3')->select(' 
            select n.icode as nicode,n.name as namedrug,sum(o.qty) as qty,
            sum(sum_price) as paidst,
            (select sum(sum_price) from opitemrece where an=o.an and income = o.income and paidst in("01","03")) as nopaidst from opitemrece o
            left outer join nondrugitems n on n.icode = o.icode
            left outer join income i on i.income = o.income
            where o.an ="'.$an.'" 
            and o.income="12"
            and o.pttype in ("36","37","38","39") 
            group by n.name
            order by i.income 
        ');
        $data['prb_repipd_bumbad'] =  DB::connection('mysql3')->select(' 
            select n.icode as nicode,n.name as namedrug,sum(o.qty) as qty,
            sum(sum_price) as paidst,
            (select sum(sum_price) from opitemrece where an=o.an and income = o.income and paidst in("01","03")) as nopaidst from opitemrece o
            left outer join nondrugitems n on n.icode = o.icode
            left outer join income i on i.income = o.income
            where o.an ="'.$an.'" 
            and o.income="14"
            and o.pttype in ("36","37","38","39") 
            group by n.name
            order by i.income 
        ');
        $data['prb_repipd_carrefer'] =  DB::connection('mysql3')->select(' 
            select n.icode as nicode,n.name as namedrug,sum(o.qty) as qty,
            sum(sum_price) as paidst,
            (select sum(sum_price) from opitemrece where an=o.an and income = o.income and paidst in("01","03")) as nopaidst from opitemrece o
            left outer join nondrugitems n on n.icode = o.icode
            left outer join income i on i.income = o.income
            where o.an ="'.$an.'" 
            and o.income="18"
            and o.pttype in ("36","37","38","39") 
            group by n.name
            order by i.income 
        ');
        $data['prb_repipd_other'] =  DB::connection('mysql3')->select(' 
            select n.icode as nicode,n.name as namedrug,sum(o.qty) as qty,
            sum(sum_price) as paidst,
            (select sum(sum_price) from opitemrece where an=o.an and income = o.income and paidst in("01","03")) as nopaidst from opitemrece o
            left outer join nondrugitems n on n.icode = o.icode
            left outer join income i on i.income = o.income
            where o.an ="'.$an.'" 
            and o.income="20"
            and o.pttype in ("36","37","38","39") 
            group by n.name
            order by i.income 
        ');
        $data['prb_repipd_covid19'] =  DB::connection('mysql3')->select('
            select n.billcode as nicode,n.name as namedrug,sum(o.qty) as qty,sum(sum_price) as paidst,
            (select sum(sum_price) from opitemrece where an=o.an and income = o.income and paidst in("01","03") and income="02") as nopaidst from opitemrece o
            left outer join nondrugitems n on n.icode = o.icode
            left outer join income i on i.income = o.income 
            where o.an ="'.$an.'"
            and o.icode in("3010601","3010605","3010590","3010604","3010602","3010603","3010592","3010591","3010600","3000406"
            ,"3000407","3010640","3010641","3010697","3010698","3010677")
            and o.pttype in ("36","37","38","39") 
            group by n.name
            order by i.income 
        ');
        
        
        return view('prb.prb_repipd_subsuban_print', $data ,[
            'an'    =>   $an
        ]);
    }

    public function prb_repipd_subreq(Request $request,$months,$startdate,$enddate)
    {
        
        $data['data_repipdsubreq'] =  DB::connection('mysql3')->select('
                select v.hn,v.an,p.cid,v.dchdate,v.pdx,concat(p.pname,p.fname," ",p.lname) as fullname,v.pttype,
                group_concat(distinct " ",r.rcpno,"/",r.total_amount) as rcpno,v.income,v.paid_money,
                v.remain_money,nhso_docno,vp.nhso_ownright_pid,vp.max_debt_amount,vp.nhso_govname
                from an_stat v
                left outer join ipt i on i.an = v.an
                left outer join patient p on p.hn = v.hn 
                left outer join ipt_pttype vp on vp.an = i.an
                left outer join rcpt_print r on r.vn =v.an
                where v.dchdate between "'.$startdate.'" and "'.$enddate.'"
                and v.pttype in("36","37","38","39","31","32")
                and month(v.dchdate) = "'.$months.'"
                and vp.claim_code ="1"
                group by v.an
 
        '); 
        
        return view('prb.prb_repipd_subreq', $data,[ 
            'startdate'      =>  $startdate,
            'enddate'      =>  $enddate,
            ]);
    }
    public function prb_repipd_subnoreq(Request $request,$months,$startdate,$enddate)
    {
        $data['data_repipdsubnoreq'] =  DB::connection('mysql3')->select('
            select v.hn,v.an,p.cid,v.dchdate,v.pdx,concat(p.pname,p.fname,"  ",p.lname) as fullname,
            v.pttype,v.income,group_concat(distinct " ",r.rcpno,"/",r.total_amount) as amount,
            if(vp.claim_code ="1","เบิก"," ") as claim_code,vp.nhso_docno,vp.nhso_ownright_pid,vp.nhso_ownright_name
            from an_stat v
            left outer join ipt i on i.an = v.an
            left outer join patient p on p.hn = v.hn 
            left outer join ipt_pttype vp on vp.an = i.an 
            left outer join rcpt_print r on r.vn =v.an
            where v.dchdate between "'.$startdate.'" and "'.$enddate.'"
            and v.pttype in("36","37","38","39","31","32")
            and month(v.dchdate) = "'.$months.'"
            and vp.pttype_number ="1"
            and (vp.claim_code is null or vp.claim_code<>"1")
            group by v.an
 
        '); 
        
        return view('prb.prb_repipd_subnoreq', $data,[ 
            'startdate'      =>  $startdate,
            'enddate'      =>  $enddate,
            ]);
    }


    public function prb_repipdpay(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate; 
        
        $data['data_repipdpay'] =  DB::connection('mysql3')->select('
                select month(v.dchdate) as months,count(distinct v.hn) as hn,count(distinct v.an) as an
                ,sum(vp.nhso_ownright_pid >"0") as nhso_ownright_pidover
                ,count(distinct v.an)-sum(vp.claim_code ="1") as claim_code
                ,sum(v.income) as income
                ,sum(vp.nhso_ownright_pid) as nhso_ownright_pid
                ,sum(vp.nhso_ownright_name) as nhso_ownright_name
                ,100*sum(vp.claim_code ="1")/count(distinct v.an) as claim_codeafter
                from an_stat v
                left outer join pttype p on p.pttype = v.pttype 
                left outer join ipt_pttype vp on vp.an = v.an
                where v.dchdate between "'.$startdate.'" and "'.$enddate.'"
                and vp.pttype in("33","09","36","31","37","38")
                group by month(v.dchdate)
 
        '); 
        
        return view('prb.prb_repipdpay', $data,[ 
            'startdate'      =>  $startdate,
            'enddate'      =>  $enddate,
            ]);
    }
    public function prb_repipdpay_subhn(Request $request,$months,$startdate,$enddate)
    {
        $data['data_repipdsubhn'] =  DB::connection('mysql3')->select('
                select v.hn,v.an,p.cid,v.dchdate,v.pdx,oo.cc,concat(p.pname,p.fname," ",p.lname) as fullname,v.pttype,o.rfrolct,o.has_insurance
                from an_stat v
                left outer join ovst o on o.vn = v.an
                left outer join opdscreen oo on oo.vn = v.vn
                left outer join patient p on p.hn = v.hn 
                where v.dchdate between "'.$startdate.'" and "'.$enddate.'"
                and v.pttype in("09","33")
                and month(v.dchdate) = "'.$months.'"
                group by v.hn  
        ');         
        return view('prb.prb_repipdpay_subhn', $data,[ 
            'startdate'      =>  $startdate,
            'enddate'      =>  $enddate,
            ]);
    }

    public function prb_repipdpay_suban(Request $request,$months,$startdate,$enddate)
    {
        $data['data_repipdsubvn'] =  DB::connection('mysql3')->select(' 
                    select v.hn,v.an,p.cid,v.dchdate,v.pdx,concat(p.pname,p.fname," ",p.lname) as fullname,
                    v.pttype,group_concat(distinct " ",r.rcpno,"/",r.total_amount) as amount,
                    v.income,v.paid_money,v.remain_money,vp.max_debt_amount,nhso_docno,vp.nhso_ownright_pid,vp.nhso_govname,
                    (select concat(plain_text,  " "  ,note_datetime," ",note_staff) from hos.ptnote where note_staff in ("joy","toob","rung1234","จารุชา","เยี่ยมรัตน์")and hn=i.hn order by note_datetime desc limit 1) as note
                    from an_stat v
                    left outer join ipt i on i.an = v.an
                    left outer join patient p on p.hn = v.hn 
                    left outer join ipt_pttype vp on vp.an = i.an
                    left outer join rcpt_print r on r.vn =v.an
                    where v.dchdate between "'.$startdate.'" and "'.$enddate.'"
                    and v.pttype in("33","09","36","31","37","38")
                    and month(v.dchdate) = "'.$months.'"
                    group by v.an
                    order by v.pttype
 
        '); 
        
        return view('prb.prb_repipdpay_suban', $data,[ 
            'startdate'      =>  $startdate,
            'enddate'      =>  $enddate,
            ]);
    }
    public function prb_repipdpay_suban_amount(Request $request,$an)
    {
        $data['data_detail'] =  DB::connection('mysql3')->select(' 
                    select o.hn,o.an,concat(p.pname,p.fname," ",p.lname) as fullname,p.cid,ip.regdate,ip.dchdate
                    from opitemrece o
                    left outer join nondrugitems n on n.icode = o.icode
                    left outer join income i on i.income = o.income
                    left outer join ovst ov on ov.vn = o.vn
                    left outer join ipt ip on ip.an = o.an
                    left outer join hos.patient p on p.hn = ip.hn

                    where o.an ="'.$an.'" 
                    group by p.cid
                 '); 

        $data['data_detail_icd'] =  DB::connection('mysql3')->select(' 
                select ip.icd10,i.name ,i.tname,ip.diagtype from iptdiag ip
                left outer join icd101 i on i.code = ip.icd10
                where ip.an ="'.$an.'" order by ip.diagtype
 
              ');
              
        $data['data_detail_icd9'] =  DB::connection('mysql3')->select('
                select io.icd9,ii.name,io.priority,io.opdate,io.optime,io.enddate,io.endtime from iptoprt io
                left outer join icd9cm1 ii on ii.code = io.icd9
                where io.an = "'.$an.'" 
            ');

        $data['data_detail_paid'] =  DB::connection('mysql3')->select('
            select i.income,i.name,sum(o.qty) as sqty,
            (select format(sum(sum_price),2) from opitemrece where an=o.an and income = o.income and paidst in("02")) as reppay,
            (select format(sum(sum_price),2) from opitemrece where an=o.an and income = o.income and paidst in("01","03")) as reppayno
            from opitemrece o
            left outer join nondrugitems n on n.icode = o.icode
            left outer join income i on i.income = o.income
            where o.an ="'.$an.'"  
            and o.pttype in ("36","37","38") 
            group by i.name
            order by i.income 
        ');

        $data['data_detail_room'] =  DB::connection('mysql3')->select('
                select n.billcode,n.name,sum(o.qty) as sqty,
                sum(sum_price) as sum_price,
                (select sum(sum_price) from opitemrece where an=o.an and income = o.income and paidst in("01","03")) as sopaidst from opitemrece o
                left outer join nondrugitems n on n.icode = o.icode
                left outer join income i on i.income = o.income
                where o.an ="'.$an.'"
                and o.income="01"
                and o.pttype in ("36","37","38") 
                group by n.name
                order by i.income 
            ');

        $data['data_detail_tium'] =  DB::connection('mysql3')->select('
            select n.billcode,n.name,sum(o.qty) as sqty,
            sum(sum_price) as sum_price,
            (select sum(sum_price) from opitemrece where an=o.an and income = o.income and paidst in("01","03")) as sopaidst 
            from opitemrece o
            left outer join nondrugitems n on n.icode = o.icode
            left outer join income i on i.income = o.income
            where o.an ="'.$an.'"
            and o.income="02"
            and o.pttype in ("36","37","38") 
            group by n.name
            order by i.income 
        ');

        $data['data_detail_drug'] =  DB::connection('mysql3')->select('
            select n.income,n.name,sum(o.qty) as sqty,
            sum(sum_price) as sum_price,
            (select sum(sum_price) from opitemrece where an=o.an and income = o.income and paidst in("01","03")) as sopaidst  from opitemrece o
            left outer join drugitems n on n.icode = o.icode
            left outer join income i on i.income = o.income
            where o.an ="'.$an.'"
            and o.income="03"
            and o.pttype in ("36","37","38") 
            group by n.name
            order by i.income 
        ');

        $data['data_detail_drughome'] =  DB::connection('mysql3')->select('
            select n.income,n.name,sum(o.qty) as sqty,
            sum(sum_price) as sum_price,
            (select sum(sum_price) from opitemrece where an=o.an and income = o.income and paidst in("01","03")) as sopaidst  from opitemrece o
            left outer join drugitems n on n.icode = o.icode
            left outer join income i on i.income = o.income
            where o.an ="'.$an.'"
            and o.income="04"
            and o.pttype in ("36","37","38") 
            group by n.name
            order by i.income 
        ');
        $data['data_detail_nondrug'] =  DB::connection('mysql3')->select('
            select i.income,n.name,sum(o.qty) as sqty,
            sum(sum_price) as sum_price,
            (select sum(sum_price) from opitemrece where an=o.an and income = o.income and paidst in("01","03")) as sopaidst  from opitemrece o
            left outer join nondrugitems n on n.icode = o.icode
            left outer join income i on i.income = o.income
            where o.an ="'.$an.'"
            and o.income="05"
            and o.pttype in ("36","37","38") 
            group by n.name
            order by i.income 
        ');
        $data['data_detail_lab'] =  DB::connection('mysql3')->select('
            select i.income,n.name,sum(o.qty) as sqty,
            sum(sum_price) as sum_price,
            (select sum(sum_price) from opitemrece where an=o.an and income = o.income and paidst in("01","03")) as sopaidst  from opitemrece o
            left outer join nondrugitems n on n.icode = o.icode
            left outer join income i on i.income = o.income
            where o.an ="'.$an.'"
            and o.income="07"
            and o.pttype in ("36","37","38") 
            group by n.name
            order by i.income 
        ');

        $data['data_detail_labrung'] =  DB::connection('mysql3')->select('
            select i.income,n.name,sum(o.qty) as sqty,
            sum(sum_price) as sum_price,
            (select sum(sum_price) from opitemrece where an=o.an and income = o.income and paidst in("01","03")) as sopaidst  from opitemrece o
            left outer join nondrugitems n on n.icode = o.icode
            left outer join income i on i.income = o.income
            where o.an ="'.$an.'"
            and o.income="08"
            and o.pttype in ("36","37","38") 
            group by n.name
            order by i.income 
        ');

        $data['data_detail_med'] =  DB::connection('mysql3')->select('
            select i.income ,n.name,sum(o.qty) as sqty,
            sum(sum_price) as sum_price,
            (select sum(sum_price) from opitemrece where an=o.an and income = o.income and paidst in("01","03")) as sopaidst  from opitemrece o
            left outer join drugitems n on n.icode = o.icode
            left outer join income i on i.income = o.income
            where o.an ="'.$an.'"
            and o.income="10"
            and o.pttype in ("36","37","38") 
            group by n.name
            order by i.income 
        ');

        $data['data_detail_hut'] =  DB::connection('mysql3')->select('
            select i.income ,n.name,sum(o.qty) as sqty,
            sum(sum_price) as sum_price,
            (select sum(sum_price) from opitemrece where an=o.an and income = o.income and paidst in("01","03")) as sopaidst  from opitemrece o
            left outer join drugitems n on n.icode = o.icode
            left outer join income i on i.income = o.income
            where o.an ="'.$an.'"
            and o.income="11"
            and o.pttype in ("36","37","38") 
            group by n.name
            order by i.income 
        ');

        $data['data_detail_nurs'] =  DB::connection('mysql3')->select('
            select i.income ,n.name,sum(o.qty) as sqty,
            sum(sum_price) as sum_price,
            (select sum(sum_price) from opitemrece where an=o.an and income = o.income and paidst in("01","03")) as sopaidst  from opitemrece o
            left outer join drugitems n on n.icode = o.icode
            left outer join income i on i.income = o.income
            where o.an ="'.$an.'"
            and o.income="12"
            and o.pttype in ("36","37","38") 
            group by n.name
            order by i.income 
        ');

        $data['data_detail_wet'] =  DB::connection('mysql3')->select('
            select i.income,n.name,sum(o.qty) as sqty,
            sum(sum_price) as sum_price,
            (select sum(sum_price) from opitemrece where an=o.an and income = o.income and paidst in("01","03")) as sopaidst  from opitemrece o
            left outer join drugitems n on n.icode = o.icode
            left outer join income i on i.income = o.income
            where o.an ="'.$an.'"
            and o.income="14"
            and o.pttype in ("36","37","38") 
            group by n.name
            order by i.income 
        ');

        $data['data_detail_refer'] =  DB::connection('mysql3')->select('
            select i.income,n.name,sum(o.qty) as sqty,
            sum(sum_price) as sum_price,
            (select sum(sum_price) from opitemrece where an=o.an and income = o.income and paidst in("01","03")) as sopaidst  from opitemrece o
            left outer join drugitems n on n.icode = o.icode
            left outer join income i on i.income = o.income
            where o.an ="'.$an.'"
            and o.income="18"
            and o.pttype in ("36","37","38") 
            group by n.name
            order by i.income 
        ');

        $data['data_detail_nurstother'] =  DB::connection('mysql3')->select('
            select n.income,n.name,sum(o.qty) as sqty,
            sum(sum_price) as sum_price,
            (select sum(sum_price) from opitemrece where an=o.an and income = o.income and paidst in("01","03")) as sopaidst  from opitemrece o
            left outer join drugitems n on n.icode = o.icode
            left outer join income i on i.income = o.income
            where o.an ="'.$an.'"
            and o.income="20"
            and o.pttype in ("36","37","38") 
            group by n.name
            order by i.income 
        ');
     
        $data['data_detail_covid'] =  DB::connection('mysql3')->select('
                select n.income,n.name,sum(o.qty) as sqty,sum(sum_price) as sum_price,
                (select sum(sum_price) from opitemrece where an=o.an and income = o.income and paidst in("01","03") and income="02") as sopaidst from opitemrece o
                left outer join nondrugitems n on n.icode = o.icode
                left outer join income i on i.income = o.income 
                where o.an ="'.$an.'"
                and o.icode in("3010601","3010605","3010590","3010604","3010602","3010603","3010592","3010591","3010600","3000406"
                ,"3000407","3010640","3010641","3010697","3010698","3010677")
                and o.pttype in ("36","37","38") 
                group by n.name
                order by i.income
            
            ');   
        return view('prb.prb_repipdpay_suban_amount', $data,);
    }
    public function prb_repipdpay_subreq(Request $request,$months,$startdate,$enddate)
    {
        $date = date('Y-m-d');
            
        $data['data_repipdsubreq'] =  DB::connection('mysql3')->select('
                select v.hn,v.an,p.cid,v.dchdate,v.pdx,concat(p.pname,p.fname," ",p.lname) as fullname,v.pttype,
                group_concat(distinct " ",r.rcpno,"/",r.total_amount) as rcpno,v.income,v.paid_money,v.remain_money,
                nhso_docno,vp.nhso_ownright_pid,vp.max_debt_amount,vp.nhso_govname
                from an_stat v
                left outer join ipt i on i.an = v.an
                left outer join patient p on p.hn = v.hn 
                left outer join ipt_pttype vp on vp.an = i.an
                left outer join rcpt_print r on r.vn =v.an
                where v.dchdate between "'.$startdate.'" and "'.$enddate.'"
                and v.pttype in("33","09")
                and month(v.dchdate) = "'.$months.'"
                and vp.claim_code ="1"
                group by v.an               
        ');         
        return view('prb.prb_repipdpay_subreq', $data,[ 
            'startdate'      =>  $startdate,
            'enddate'      =>  $enddate,
            ]);
    }

    public function prb_repipdpay_subnoreq(Request $request,$months,$startdate,$enddate)
    {
        $data['prb_repipdpay_subnoreq'] =  DB::connection('mysql3')->select('
            select v.hn,v.an,p.cid,v.dchdate,v.pdx,concat(p.pname,p.fname," ",p.lname) as fullname,v.pttype,
            v.income,group_concat(distinct " ",r.rcpno,"/",r.total_amount) as amount,
            if(vp.claim_code ="1","เบิก"," ") as claim_code,vp.nhso_docno,vp.nhso_ownright_pid,vp.nhso_ownright_name
            from an_stat v
            left outer join ipt i on i.an = v.an
            left outer join patient p on p.hn = v.hn 
            left outer join ipt_pttype vp on vp.an = i.an 
            left outer join rcpt_print r on r.vn =v.an
            where v.dchdate between "'.$startdate.'" and "'.$enddate.'"
            and v.pttype in("33","09")
            and month(v.dchdate) = "'.$months.'"
            and vp.pttype_number ="1"
            and (vp.claim_code is null or vp.claim_code<>"1")
            group by v.an

        '); 
        
        return view('prb.prb_repipdpay_subnoreq', $data,[ 
            'startdate'      =>  $startdate,
            'enddate'      =>  $enddate,
            ]);
    }
    // and month(v.dchdate) = "'.$months.'"
    public function prb_repipdover(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate; 
        
        $data['data_repipdover'] =  DB::connection('mysql3')->select('
                select month(v.regdate) as months,count(distinct v.hn) as hn,count(distinct v.an) as an
                ,sum(vp.nhso_ownright_pid >"0") as nhso_ownright_pidover
                ,count(distinct v.an)-sum(vp.claim_code ="1") as claim_code
                ,sum(v.income) as income
                ,sum(vp.nhso_ownright_pid) as nhso_ownright_pid
                ,sum(vp.nhso_ownright_name) as nhso_ownright_name
                ,100*sum(vp.claim_code ="1")/count(distinct v.an) as claim_codeafter
                from an_stat v
                left outer join pttype p on p.pttype = v.pttype 
                left outer join ipt_pttype vp on vp.an = v.an
                where v.regdate between "'.$startdate.'" and "'.$enddate.'"
                and vp.pttype in("36","37","38","39","33","09","31","32","33")
                and vp.pttype_number ="1"
                and v.dchdate is null
                group by month(v.regdate) 
        '); 
        
        return view('prb.prb_repipdover', $data,[ 
            'startdate'      =>  $startdate,
            'enddate'      =>  $enddate,
            ]);
    }

    public function request_report(Request $request)
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
        return view('rep.request_report', $data,[ 
            'startdate'      =>  $startdate,
            'enddate'      =>  $enddate,
            ]);
    }
    public function request_report_save(Request $request)
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
    public function request_report_edit(Request $request, $id)
    {
        $rep = Rep_report::find($id);

        return response()->json([
            'status'     => '200',
            'rep'      =>  $rep,
        ]);
    }
    public function request_report_update(Request $request)
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

