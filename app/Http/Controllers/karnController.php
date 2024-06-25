<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\support\Facades\Hash;
use Illuminate\support\Facades\Validator;
use App\Models\User;
use PDF;
use setasign\Fpdi\Fpdi;
use App\Models\Budget_year;
use Illuminate\Support\Facades\File;
use DataTables;
use Intervention\Image\ImageManagerStatic as Image;

class karnController extends Controller
{
    public static function checkptpid($cid)
    {
      $checkptpid =  DB::table('karn_pt')->where('patien_pid','=',$cid)->count();  
      return $checkptpid;
    }
    public static function checkhicipid($cid)
    {
      $checkhicipid =  DB::table('karn_hici')->where('hici_pid','=',$cid)->count();    
      return $checkhicipid;
    }

    public function karn_main(Request $request)
    {
      $startdate = $request->startdate;
      $enddate = $request->enddate;

        $year_id = $request->year_id;
        $date = date('Y-m-d');
        $newweek = date('Y-m-d H:m:s', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์  
        $newDate = date('Y-m-d', strtotime($date . ' -1 months')); //ย้อนหลัง 1 เดือน  
        // $newDate2 = date('Y-m-d', strtotime($date . ' 1 months')); // 1 เดือน         
        // $newDate = date('Y-m-d H:m:s', strtotime($date . ' -1 months')); //ย้อนหลัง 1 เดือน  

        $year = DB::table('budget_year')->orderBy('leave_year_id', 'DESC')->get();
        // $data = DB::select('select patien_code,patien_hn,patien_pid,patien_fname,patien_lname from karn_pt');
        $data = DB::select('select ci_code,ci_hn,ci_pid,ci_fullname from karn_ci where created_at between "'.$newDate.'" and "'.$date.'"');
        
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
                where v.dchdate between "'.$newDate.'" and "'.$newDate.'"
                and vp.pttype in("33","09","36","31","37","38")
               
 
        '); 
        // group by month(v.dchdate)
        // dd($date);
        return view('karn.karn_main', [ 
            'year'          =>  $year, 
            'year_ids'      =>  $year_id,
            'data'          =>  $data
        ]);
    }
    public function karn_main_sss(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $date = date('Y-m-d');
        $newweek = date('Y-m-d H:m:s', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์  
        $newDate = date('Y-m-d', strtotime($date . ' -1 months')); //ย้อนหลัง 1 เดือน   
        $year = DB::table('budget_year')->orderBy('leave_year_id', 'DESC')->get(); 
        $data = DB::select('select ci_code,ci_hn,ci_pid,ci_fullname from karn_ci where created_at between "'.$newDate.'" and "'.$date.'"'); 

        $datashow = DB::connection('mysql3')->select('
        select v.hn,v.an,concat(p.pname,p.fname," ",p.lname) as fullname,p.cid,
        v.regdate,i.regtime,v.dchdate,i.dchtime,ss.name as debname,
        d.name as n1,dd.name as n2,v.pdx,v.income,v.pttype,ddd.name as doctor,ddd.licenseno
        ,n.billcode,op.sum_price
        ,op.income,ic.name as namelab
        from an_stat v
        left outer join opitemrece op on op.an = v.an
        left outer join income ic on ic.income = op.income
        left outer join nondrugitems n on n.icode = op.icode
        left outer join opdscreen oo on oo.vn = v.vn
        left outer join patient p on p.hn = v.hn
        left outer join ipt i on i.an = v.an 
        left outer join spclty s on s.spclty = i.spclty
        left outer join spclty ss on ss.spclty = i.ipt_spclty
        left outer join dchstts d on d.dchstts = i.dchstts
        left outer join dchtype dd on dd.dchtype = i.dchtype
        left outer join pttype pt on pt.pttype = v.pttype
        left outer join doctor ddd on ddd.code = i.dch_doctor
        left outer join ipt_pttype vp on vp.an = v.an     
        where v.dchdate between "'.$startdate.'" and "'.$enddate.'"
        and op.income = "07" and op.sum_price > "0" and n.billcode in("36597","36598")
        and v.pttype in ("06","14","34","35","37","45","s7")   
        group by v.an  
        ');

        // select v.hn,v.an,concat(p.pname,p.fname,' ',p.lname) as name,p.cid,concat(day(p.birthday),'/',month(p.birthday),'/',year(p.birthday)+543),
        // v.regdate,i.regtime,s.name,v.dchdate,i.dchtime,ss.name,
        // d.name,dd.name,v.pdx,v.income,v.pttype,ddd.name,ddd.licenseno
        // from an_stat v
        // left outer join opdscreen oo on oo.vn = v.vn
        // left outer join patient p on p.hn = v.hn
        // left outer join ipt i on i.an = v.an 
        // left outer join spclty s on s.spclty = i.spclty
        // left outer join spclty ss on ss.spclty = i.ipt_spclty
        // left outer join dchstts d on d.dchstts = i.dchstts
        // left outer join dchtype dd on dd.dchtype = i.dchtype
        // left outer join pttype pt on pt.pttype = v.pttype
        // left outer join doctor ddd on ddd.code = i.dch_doctor
        // left outer join ipt_pttype vp on vp.an = v.an
        // where v.dchdate between '2021-10-01' and '2022-09-30'
        // and v.pttype in ('06','14','34','35','37','45','s7')
        // and month(v.dchdate) = '".$month."'
        // and month(v.dchdate) = "8"
        // group by v.an

        return view('karn.karn_main_sss', [ 
          'datashow'      =>  $datashow,
            'year'          =>  $year, 
            'startdate'      =>  $startdate,
             'enddate'      =>  $enddate,
            'data'          =>  $data
        ]);
    }
    public function karn_main_sss_detail(Request $request,$an)
    {  
    $datadetail = DB::connection('mysql3')->select('    
    select n.billcode,ifnull(n.name,d.name) as namelab,sum(o.qty) as qt,format(sum(sum_price),2) as pricet
    from opitemrece o
    left outer join nondrugitems n on n.icode = o.icode
    left outer join drugitems d on d.icode = o.icode
    left outer join income i on i.income = o.income
    where o.an ="'.$an.'" 
    and o.income= "07"
    and o.sum_price > "0"
    group by o.icode
    order by o.icode
    ');
  
    // ->find($an); 
    
    return response()->json([
        'status'     => '200',
        'datadetail'      =>  $datadetail, 
        ]);
    }

    public function karn_sss_309(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $date = date('Y-m-d');
        $newweek = date('Y-m-d H:m:s', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์  
        $newDate = date('Y-m-d', strtotime($date . ' -1 months')); //ย้อนหลัง 1 เดือน   
        $year = DB::table('budget_year')->orderBy('leave_year_id', 'DESC')->get(); 
        $data = DB::select('select ci_code,ci_hn,ci_pid,ci_fullname from karn_ci where created_at between "'.$newDate.'" and "'.$date.'"'); 

        $datashow = DB::connection('mysql3')->select('
            select v.vstdate,v.hn,v.vn,i.an,concat(p.pname,p.fname," ",p.lname) as fullname,v.pttype,oo.cc,group_concat(distinct r.rcpno,"/",r.bill_amount) as bill_amount,v.income
            ,format(v.paid_money,2) as paid_money,sum(d.total) as total,
            s.amount,format(s.amount-sum(d.total),2) as toamo,max(m.rep) as mrep,v.cid
            fROM hos.vn_stat v
            inner join eclaimdb.opitemrece61dmis d on d.vn = v.vn
            inner  join hos.nondrugitems n on n.icode = d.icode
            inner join eclaimdb.l_instrumentitemxx l on l.code = n.billcode and l.MAININSCL ="sss" and GYEAR ="2020"
            LEFT OUTER JOIN hos.patient p ON p.hn=v.hn
            left outer join hos.rcpt_print r on r.vn =v.vn
            left outer join hos.pttype pt on pt.pttype = v.pttype
            left outer join hos.opdscreen oo on oo.vn=v.vn
            LEFT JOIN hos.ipt i on i.vn =v.vn
            LEFT JOIN hshooterdb.m_stm_from_sks s on s.vn = v.vn
            left outer join eclaimdb.m_registerdata m on m.opdseq = d.vn
            left outer join eclaimdb.m_sumfund mm on mm.eclaim_no = m.eclaim_no
            where v.vstdate between "'.$startdate.'" and "'.$enddate.'"
            and d.pttype in("M5","M2" )
            and i.an is null 
            group by v.vn
            union
            select v.vstdate,v.hn,v.vn,i.an,concat(p.pname,p.fname," ",p.lname) as fullname,v.pttype,oo.cc,group_concat(distinct r.rcpno,"/",r.bill_amount),v.income
            ,format(v.paid_money,2),sum(d.total),
            s.amount,format(s.amount-sum(d.total),2),max(m.rep),v.cid
            fROM hos.vn_stat v
            inner join eclaimdb.opitemrece61dmishd d on d.vn = v.vn

            LEFT OUTER JOIN hos.patient p ON p.hn=v.hn
            left outer join hos.rcpt_print r on r.vn =v.vn
            left outer join hos.pttype pt on pt.pttype = v.pttype
            left outer join hos.opdscreen oo on oo.vn=v.vn
            LEFT JOIN hos.ipt i on i.vn =v.vn
            LEFT JOIN hshooterdb.m_kidney s on s.hn = v.hn and left(s.dttran,10) = v.vstdate
            left outer join eclaimdb.m_registerdata m on m.opdseq = d.vn
            left outer join eclaimdb.m_sumfund mm on mm.eclaim_no = m.eclaim_no
            where v.vstdate between "'.$startdate.'" and "'.$enddate.'"
            and d.pttype in("M5","M2" )
            and i.an is null 
            group by v.vn
            union
            select v.vstdate,v.hn,v.vn,i.an,concat(p.pname,p.fname, " ",p.lname) as fullname,v.pttype,oo.cc,group_concat(distinct r.rcpno,"/",r.bill_amount),v.income
            ,format(v.paid_money,2),sum(v.uc_money),
            s.nhso_ownright_pid,format(s.nhso_ownright_pid-sum(v.uc_money),2),max(m.rep),v.cid
            fROM hos.vn_stat v

            LEFT OUTER JOIN hos.patient p ON p.hn=v.hn
            left outer join hos.rcpt_print r on r.vn =v.vn
            left outer join hos.pttype pt on pt.pttype = v.pttype
            left outer join hos.opdscreen oo on oo.vn=v.vn
            LEFT JOIN hos.ipt i on i.vn =v.vn
            LEFT JOIN hos.visit_pttype s on s.vn = v.vn
            left outer join eclaimdb.m_registerdata m on m.opdseq = v.vn
            left outer join eclaimdb.m_sumfund mm on mm.eclaim_no = m.eclaim_no
            where v.vstdate between "'.$startdate.'" and "'.$enddate.'"
            and v.pttype in("M5","M2" )
            and i.an is null 
            group by v.vn 
        ');
 
        return view('karn.karn_sss_309', [ 
          'datashow'      =>  $datashow,
            'year'          =>  $year, 
            'startdate'      =>  $startdate,
             'enddate'      =>  $enddate,
            'data'          =>  $data
        ]);
    }
    
}
