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

class SssController extends Controller
{
        public function sss_in(Request $request)
        {
                $start_date   = "2022-09-01"; 
                $end_date   = "2022-09-03"; 
                $date = date("Y-m-d");
                $date_m = date("MONTH(DATE($date))");

                $sss_check = DB::connection('mysql3')->select('select o.vn,o.hn,ce2be(o.vstdate) vstdate,totime(o.vsttime ) vsttime
                ,CONCAT( ps.pname, "-", ps.fname,"-",ps.lname ) full_name
                ,seekname(o.main_dep,"kskdepartment") room,seekname(o.spclty,"spclty") clinic,o.pttype,seekname(o.pttype,"pttype") pttypename,pe.name as eclaim_name 
                ,seekname(o.staff,"staff") staff,v.pdx,v.income ,doctorname(v.dx_doctor) dxdoctor,cast(s.cc as char(250)) cc from ovst o
                JOIN vn_stat v on o.vn=v.vn
                LEFT JOIN opdscreen s on s.vn=o.vn 
                LEFT JOIN person ps on ps.patient_hn=o.hn
                LEFT JOIN pttype pt on pt.pttype=o.pttype
                JOIN pttype_eclaim pe on pe.code=pt.pttype_eclaim_id
                WHERE o.vstdate BETWEEN "'.$start_date.'" AND "'.$end_date.'"
                and (v.pdx is null or v.pdx="" or v.pdx regexp "^[0-9]" or v.pdx regexp "[V-Y]")
                and (pt.pttype_eclaim_id ="10")
                and pt.name not like"%ว่าง%"
                and v.income>0
                ');
                // $physic = DB::connection('mysql3')->select('select MONTH(DATE(begin_datetime)) AS month,
                // COUNT(DISTINCT vn) as visit
                // FROM physic_list                        
                // WHERE DATE(begin_datetime) BETWEEN "'.$start_date.'" AND "'.$end_date.'"
                // GROUP BY MONTH(DATE(begin_datetime))
                // ORDER BY YEAR(DATE(begin_datetime)),MONTH(DATE(begin_datetime))');

                // $physic = DB::connection('mysql2')->select('select pname,fname,lname FROM person limit 30');

                return view('pkclaim.sss.sss_in',[
                'sss_check'   =>  $sss_check
                ]);
        }
        public function ipd_outlocate(Request $request)
        {  
                $startdate = $request->startdate;
                $enddate = $request->enddate; 

                $datashow = DB::connection('mysql3')->select('

                select year(a.dchdate) as monyear
                ,month(a.dchdate) as months
                ,count(distinct a.an) as an
                ,sum(a.an and a.an in (select an from ipt_pttype where an is not null and claim_code ="1")) as noman1
                ,sum(a.an and a.an in (select an from ipt_pttype where an is not null and (vp.claim_code is null or vp.claim_code ="2" or vp.claim_code =""))) as noman2
                ,round(sum(ii.adjrw),2) as adjrw
                ,sum(vp.nhso_ownright_pid) as nhso_ownright_pid
                ,sum(vp.nhso_ownright_name) as nhso_ownright_name
                from an_stat a
                left outer join ipt_pttype vp on vp.an = a.an
                left outer join pttype p on p.pttype = a.pttype
                left outer join ipt ii on ii.an = a.an
                where a.dchdate between "'.$startdate.'" AND "'.$enddate.'"
                and a.pttype in ("06","14","34","35","37","45","s7")
                group by month(a.dchdate) 
                '); 

                return view('sss.ipd_outlocate',[
                'datashow'   =>  $datashow,
                'startdate'  =>  $startdate,
                'enddate'    =>  $enddate,
                ]);
        }
        public function ipd_outlocate_sub(Request $request,$months,$startdate,$enddate)
        {        
                $data['data_outlocate_sub'] =  DB::connection('mysql3')->select('
                        select v.hn,v.an,concat(p.pname,p.fname," ",p.lname) as fullname,
                        p.cid,concat(day(p.birthday),"/",month(p.birthday),"/",year(p.birthday)+543) as birth,
                        v.regdate,i.regtime,s.name,v.dchdate,i.dchtime,ss.name as sname,
                        d.name as dname,dd.name as ddname,v.pdx,v.income,v.pttype,ddd.name as dddname,ddd.licenseno
                        from an_stat v
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
                        and v.pttype in ("06","14","34","35","37","45","s7")
                        and month(v.dchdate) = "'.$months.'"
                        group by v.an 
                '); 
                
                return view('sss.ipd_outlocate_sub', $data,[ 
                'startdate'      =>  $startdate,
                'enddate'      =>  $enddate,
                ]);
        }
        public function ipd_outlocate_pdx(Request $request,$an)
        {        
                $data['data_outlocate_pdx_icd10'] =  DB::connection('mysql3')->select('
                        select ip.icd10,i.name,ip.diagtype 
                        from iptdiag ip
                        left outer join icd101 i on i.code = ip.icd10
                        where ip.an ="'.$an.'" order by ip.diagtype 
                '); 
                $data['data_outlocate_pdx_icd9'] =  DB::connection('mysql3')->select('
                        select io.icd9,ii.name as iname,io.priority,io.opdate,io.optime,io.enddate,io.endtime 
                        from iptoprt io
                        left outer join icd9cm1 ii on ii.code = io.icd9
                        where io.an ="'.$an.'" 
                '); 
                
                return view('sss.ipd_outlocate_pdx', $data );
        }
        public function ipd_outlocate_income(Request $request,$an)
        {        
                $data['data_outlocate_incomesum'] =  DB::connection('mysql3')->select('
                        select sum(admdate) as sadmdate
                        from an_stat 
                        where an ="'.$an.'"                
                '); 
                $data['data_outlocate_income'] =  DB::connection('mysql3')->select('
                        select i.income,i.name as iname,sum(o.qty) as qty,
                        (select format(sum(sum_price),2) from opitemrece where an=o.an and income = o.income and paidst in("02")) as paidst,
                        (select format(sum(sum_price),2) from opitemrece where an=o.an and income = o.income and paidst in("01","03")) as nopaidst
                        from opitemrece o
                        left outer join nondrugitems n on n.icode = o.icode
                        left outer join income i on i.income = o.income
                        where o.an ="'.$an.'"  
                        group by i.name
                        order by i.income                               
                '); 
                $data['data_outlocate_room'] =  DB::connection('mysql3')->select('
                        select n.billcode,n.name,sum(o.qty) as qty,
                        sum(sum_price) as paidst,
                        (select sum(sum_price) from opitemrece where an=o.an and income = o.income and paidst in("01","03")) as nopaidst from opitemrece o
                        left outer join nondrugitems n on n.icode = o.icode
                        left outer join income i on i.income = o.income
                        where o.an ="'.$an.'" 
                        and o.income="01"
                        and o.icode not in ("3010708","3010601","3010605","3010590","3010604")
                        group by n.name
                        order by i.income                          
                '); 
                $data['data_outlocate_covid'] =  DB::connection('mysql3')->select('
                        select n.billcode,n.name,sum(o.qty) as qty,sum(sum_price) as paidst,
                        (select sum(sum_price) from opitemrece where an=o.an and income = o.income and paidst in("01","03") and income="02") as nopaidst from opitemrece o
                        left outer join nondrugitems n on n.icode = o.icode
                        left outer join income i on i.income = o.income 
                        where o.an ="'.$an.'"
                        and o.icode in("3010714","3010715","3010716","3010717","3010718","3010719","3010601","3010605","3010590","3010604","3010602","3010603","3010592","3010591","3010600"
                        ,"3000406"
                        ,"3000407","3010640","3010641","3010697","3010698","3010601","3010605","3010590","3010604","3010706","3010707","3010708")
                        group by n.name
                        order by i.income                        
                '); 
                $data['data_outlocate_covidci'] =  DB::connection('mysql3')->select('
                        select n.billcode,n.name,sum(o.qty) as qty,sum(sum_price) as paidst,
                        (select sum(sum_price) from opitemrece where an=o.an and income = o.income and paidst in("01","03") and income="02") as nopaidst from opitemrece o
                        left outer join nondrugitems n on n.icode = o.icode
                        left outer join income i on i.income = o.income 
                        where o.an ="'.$an.'" 
                        and o.icode in("3010706","3010707","3010708")
                        group by n.name
                        order by i.income                 
                ');
                $data['data_outlocate_list'] =  DB::connection('mysql3')->select('
                        select n.billcode,n.name,o.qty as qty,sum(sum_price) as paidst,
                        (select sum(sum_price) from opitemrece where an=o.an and income = o.income and paidst in("01","03") and income="02") as nopaidst from opitemrece o
                        left outer join nondrugitems n on n.icode = o.icode
                        left outer join income i on i.income = o.income 
                        where o.an ="'.$an.'"
                        and o.income="02"
                        group by n.name
                        order by i.income               
                ');  
                $data['data_outlocate_eclaim'] =  DB::connection('mysql3')->select('
                        select l.SERVICE_ITEM,REPLACE(mm.sev01,","," ") as SEVer,REPLACE(mm1.sev01,","," ") as repsev from eclaimdb.m_registerdata m
                        LEFT JOIN eclaimdb.m_serviceitem mm on mm.ECLAIM_NO = m.ECLAIM_NO and mm.servicetype="0"
                        LEFT JOIN eclaimdb.m_serviceitem mm1 on mm1.ECLAIM_NO = m.ECLAIM_NO and mm1.servicetype="1"
                        LEFT JOIN eclaimdb.l_serviceitem l on l.SERVICE_ID = "SEV01" 
                        where m.an ="'.$an.'" 
                        and m.status in ("0","1","4")
                        
                        UNION all
                        select l.SERVICE_ITEM,REPLACE(mm.sev02,","," "),REPLACE(mm1.sev02,","," ") from eclaimdb.m_registerdata m
                        LEFT JOIN eclaimdb.m_serviceitem mm on mm.ECLAIM_NO = m.ECLAIM_NO and mm.servicetype="0"
                        LEFT JOIN eclaimdb.m_serviceitem mm1 on mm1.ECLAIM_NO = m.ECLAIM_NO and mm1.servicetype="1"
                        LEFT JOIN eclaimdb.l_serviceitem l on l.SERVICE_ID = "SEV02"
                        where m.an ="'.$an.'" 
                        and m.status in ("0","1","4") 
                        
                        union all
                        select l.SERVICE_ITEM,REPLACE(mm.sev03,","," "),REPLACE(mm1.sev03,","," ") from eclaimdb.m_registerdata m
                        LEFT JOIN eclaimdb.m_serviceitem mm on mm.ECLAIM_NO = m.ECLAIM_NO and mm.servicetype="0"
                        LEFT JOIN eclaimdb.m_serviceitem mm1 on mm1.ECLAIM_NO = m.ECLAIM_NO and mm1.servicetype="1"
                        LEFT JOIN eclaimdb.l_serviceitem l on l.SERVICE_ID = "SEV03"
                        where m.an ="'.$an.'" 
                        and m.status in ("0","1","4") 
                        
                        union all
                        select l.SERVICE_ITEM,REPLACE(mm.sev04,","," "),REPLACE(mm1.sev04,","," ") from eclaimdb.m_registerdata m
                        LEFT JOIN eclaimdb.m_serviceitem mm on mm.ECLAIM_NO = m.ECLAIM_NO and mm.servicetype="0"
                        LEFT JOIN eclaimdb.m_serviceitem mm1 on mm1.ECLAIM_NO = m.ECLAIM_NO and mm1.servicetype="1"
                        LEFT JOIN eclaimdb.l_serviceitem l on l.SERVICE_ID = "SEV04"
                        where m.an ="'.$an.'" 
                        and m.status in ("0","1","4") 
                        

                        UNION all
                        select l.SERVICE_ITEM,REPLACE(mm.sev05,","," "),REPLACE(mm1.sev05,","," ") from eclaimdb.m_registerdata m
                        LEFT JOIN eclaimdb.m_serviceitem mm on mm.ECLAIM_NO = m.ECLAIM_NO and mm.servicetype="0"
                        LEFT JOIN eclaimdb.m_serviceitem mm1 on mm1.ECLAIM_NO = m.ECLAIM_NO and mm1.servicetype="1"
                        LEFT JOIN eclaimdb.l_serviceitem l on l.SERVICE_ID = "SEV05"
                        where m.an ="'.$an.'" 
                        and m.status in ("0","1","4") 
                        
                        union all
                        select l.SERVICE_ITEM,REPLACE(mm.sev06,","," "),REPLACE(mm1.sev06,","," ") from eclaimdb.m_registerdata m
                        LEFT JOIN eclaimdb.m_serviceitem mm on mm.ECLAIM_NO = m.ECLAIM_NO and mm.servicetype="0"
                        LEFT JOIN eclaimdb.m_serviceitem mm1 on mm1.ECLAIM_NO = m.ECLAIM_NO and mm1.servicetype="1"
                        LEFT JOIN eclaimdb.l_serviceitem l on l.SERVICE_ID = "SEV06"
                        where m.an ="'.$an.'" 
                        and m.status in ("0","1","4") 
                        
                        UNION all
                        select l.SERVICE_ITEM,REPLACE(mm.sev07,","," "),REPLACE(mm1.sev07,","," ") from eclaimdb.m_registerdata m
                        LEFT JOIN eclaimdb.m_serviceitem mm on mm.ECLAIM_NO = m.ECLAIM_NO and mm.servicetype="0"
                        LEFT JOIN eclaimdb.m_serviceitem mm1 on mm1.ECLAIM_NO = m.ECLAIM_NO and mm1.servicetype="1"
                        LEFT JOIN eclaimdb.l_serviceitem l on l.SERVICE_ID = "SEV07"
                        where m.an ="'.$an.'" 
                        and m.status in ("0","1","4") 
                        
                        union all
                        select l.SERVICE_ITEM,REPLACE(mm.sev08,","," "),REPLACE(mm1.sev08,","," ") from eclaimdb.m_registerdata m
                        LEFT JOIN eclaimdb.m_serviceitem mm on mm.ECLAIM_NO = m.ECLAIM_NO and mm.servicetype="0"
                        LEFT JOIN eclaimdb.m_serviceitem mm1 on mm1.ECLAIM_NO = m.ECLAIM_NO and mm1.servicetype="1"
                        LEFT JOIN eclaimdb.l_serviceitem l on l.SERVICE_ID = "SEV08"
                        where m.an ="'.$an.'" 
                        and m.status in ("0","1","4") 
                        
                        union all
                        select l.SERVICE_ITEM,REPLACE(mm.sev09,","," "),REPLACE(mm1.sev09,","," ") from eclaimdb.m_registerdata m
                        LEFT JOIN eclaimdb.m_serviceitem mm on mm.ECLAIM_NO = m.ECLAIM_NO and mm.servicetype="0"
                        LEFT JOIN eclaimdb.m_serviceitem mm1 on mm1.ECLAIM_NO = m.ECLAIM_NO and mm1.servicetype="1"
                        LEFT JOIN eclaimdb.l_serviceitem l on l.SERVICE_ID = "SEV09"
                        where m.an ="'.$an.'" 
                        and m.status in ("0","1","4") 
                        
                        UNION all
                        select l.SERVICE_ITEM,REPLACE(mm.sev10,","," "),REPLACE(mm1.sev10,","," ") from eclaimdb.m_registerdata m
                        LEFT JOIN eclaimdb.m_serviceitem mm on mm.ECLAIM_NO = m.ECLAIM_NO and mm.servicetype="0"
                        LEFT JOIN eclaimdb.m_serviceitem mm1 on mm1.ECLAIM_NO = m.ECLAIM_NO and mm1.servicetype="1"
                        LEFT JOIN eclaimdb.l_serviceitem l on l.SERVICE_ID = "SEV10"
                        where m.an ="'.$an.'" 
                        and m.status in ("0","1","4") 
                        
                        union all
                        select l.SERVICE_ITEM,REPLACE(mm.sev11,","," "),REPLACE(mm1.sev11,","," ") from eclaimdb.m_registerdata m
                        LEFT JOIN eclaimdb.m_serviceitem mm on mm.ECLAIM_NO = m.ECLAIM_NO and mm.servicetype="0"
                        LEFT JOIN eclaimdb.m_serviceitem mm1 on mm1.ECLAIM_NO = m.ECLAIM_NO and mm1.servicetype="1"
                        LEFT JOIN eclaimdb.l_serviceitem l on l.SERVICE_ID = "SEV11"
                        where m.an ="'.$an.'" 
                        and m.status in ("0","1","4") 
                        
                        union all
                        select l.SERVICE_ITEM,REPLACE(mm.sev12,","," "),REPLACE(mm1.sev12,","," ") from eclaimdb.m_registerdata m
                        LEFT JOIN eclaimdb.m_serviceitem mm on mm.ECLAIM_NO = m.ECLAIM_NO and mm.servicetype="0"
                        LEFT JOIN eclaimdb.m_serviceitem mm1 on mm1.ECLAIM_NO = m.ECLAIM_NO and mm1.servicetype="1"
                        LEFT JOIN eclaimdb.l_serviceitem l on l.SERVICE_ID = "SEV12"
                        where m.an ="'.$an.'" 
                        and m.status in ("0","1","4") 
                        
                        UNION all
                        select l.SERVICE_ITEM,REPLACE(mm.sev13,","," "),REPLACE(mm1.sev13,","," ") from eclaimdb.m_registerdata m
                        LEFT JOIN eclaimdb.m_serviceitem mm on mm.ECLAIM_NO = m.ECLAIM_NO and mm.servicetype="0"
                        LEFT JOIN eclaimdb.m_serviceitem mm1 on mm1.ECLAIM_NO = m.ECLAIM_NO and mm1.servicetype="1"
                        LEFT JOIN eclaimdb.l_serviceitem l on l.SERVICE_ID = "SEV13"
                        where m.an ="'.$an.'" 
                        and m.status in ("0","1","4") 
                        
                        union all
                        select l.SERVICE_ITEM,REPLACE(mm.sev14,","," "),REPLACE(mm1.sev14,","," ") from eclaimdb.m_registerdata m
                        LEFT JOIN eclaimdb.m_serviceitem mm on mm.ECLAIM_NO = m.ECLAIM_NO and mm.servicetype="0"
                        LEFT JOIN eclaimdb.m_serviceitem mm1 on mm1.ECLAIM_NO = m.ECLAIM_NO and mm1.servicetype="1"
                        LEFT JOIN eclaimdb.l_serviceitem l on l.SERVICE_ID = "SEV14"
                        where m.an ="'.$an.'" 
                        and m.status in ("0","1","4") 
                        
                        union all
                        select l.SERVICE_ITEM,REPLACE(mm.sev15,","," "),REPLACE(mm1.sev15,","," ") from eclaimdb.m_registerdata m
                        LEFT JOIN eclaimdb.m_serviceitem mm on mm.ECLAIM_NO = m.ECLAIM_NO and mm.servicetype="0"
                        LEFT JOIN eclaimdb.m_serviceitem mm1 on mm1.ECLAIM_NO = m.ECLAIM_NO and mm1.servicetype="1"
                        LEFT JOIN eclaimdb.l_serviceitem l on l.SERVICE_ID = "SEV15"
                        where m.an ="'.$an.'" 
                        and m.status in ("0","1","4") 
                        
                        UNION all
                        select l.SERVICE_ITEM,REPLACE(mm.sev16,","," "),REPLACE(mm1.sev16,","," ") from eclaimdb.m_registerdata m
                        LEFT JOIN eclaimdb.m_serviceitem mm on mm.ECLAIM_NO = m.ECLAIM_NO and mm.servicetype="0"
                        LEFT JOIN eclaimdb.m_serviceitem mm1 on mm1.ECLAIM_NO = m.ECLAIM_NO and mm1.servicetype="1"
                        LEFT JOIN eclaimdb.l_serviceitem l on l.SERVICE_ID = "SEV16"
                        where m.an ="'.$an.'" 
                        and m.status in ("0","1","4") 
                        
                        union all
                        select l.SERVICE_ITEM,REPLACE(mm.sev17,","," "),REPLACE(mm1.sev17,","," ") from eclaimdb.m_registerdata m
                        LEFT JOIN eclaimdb.m_serviceitem mm on mm.ECLAIM_NO = m.ECLAIM_NO and mm.servicetype="0"
                        LEFT JOIN eclaimdb.m_serviceitem mm1 on mm1.ECLAIM_NO = m.ECLAIM_NO and mm1.servicetype="1"
                        LEFT JOIN eclaimdb.l_serviceitem l on l.SERVICE_ID = "SEV17"
                        where m.an ="'.$an.'" 
                        and m.status in ("0","1","4") 
                        
                        union all
                        select l.SERVICE_ITEM,REPLACE(mm.sev18,","," "),REPLACE(mm1.sev18,","," ") from eclaimdb.m_registerdata m
                        LEFT JOIN eclaimdb.m_serviceitem mm on mm.ECLAIM_NO = m.ECLAIM_NO and mm.servicetype="0"
                        LEFT JOIN eclaimdb.m_serviceitem mm1 on mm1.ECLAIM_NO = m.ECLAIM_NO and mm1.servicetype="1"
                        LEFT JOIN eclaimdb.l_serviceitem l on l.SERVICE_ID = "SEV18"
                        where m.an ="'.$an.'" 
                        and m.status in ("0","1","4") 
                        
                        UNION all
                        select l.SERVICE_ITEM,REPLACE(mm.sev19,","," "),REPLACE(mm1.sev19,","," ") from eclaimdb.m_registerdata m
                        LEFT JOIN eclaimdb.m_serviceitem mm on mm.ECLAIM_NO = m.ECLAIM_NO and mm.servicetype="0"
                        LEFT JOIN eclaimdb.m_serviceitem mm1 on mm1.ECLAIM_NO = m.ECLAIM_NO and mm1.servicetype="1"
                        LEFT JOIN eclaimdb.l_serviceitem l on l.SERVICE_ID = "SEV19"
                        where m.an ="'.$an.'" 
                        and m.status in ("0","1","4")        
                ');
                
                return view('sss.ipd_outlocate_income', $data );
        }
        public function ipd_outlocate_subrep(Request $request,$months,$startdate,$enddate)
        {   
                $data['data_outlocate_subrep'] =  DB::connection('mysql3')->select('
                        select e.hn,e.an,e.dchdate,concat(p.pname,p.fname," ",p.lname) as fullname,e.inc08,e.income,e.pttype,
                        if(vp.claim_code ="1","เบิก"," ") as claim_code,vp.nhso_docno,vp.nhso_ownright_pid,vp.nhso_ownright_name 
                        from an_stat e
                        left outer join patient p on p.hn =e.hn
                        left outer join pttype pt on pt.pttype =e.pttype
                        left outer join ipt_pttype vp on vp.an = e.an
                        where e.dchdate between "'.$startdate.'" and "'.$enddate.'"
                        and month(e.dchdate) = "'.$months.'" 
                        and e.pttype in ("06","14","34","35","37","45","s7")
                        and vp.claim_code ="1"
                        group by e.an 
                        order by e.dchdate 
                ');  
                return view('sss.ipd_outlocate_subrep', $data );
        }
        public function ipd_outlocate_subnorep(Request $request,$months,$startdate,$enddate)
        {   
                $data['data_outlocate_subnorep'] =  DB::connection('mysql3')->select('
                        select e.hn,e.an,e.pdx,e.dchdate,concat(p.pname,p.fname," ",p.lname) as fullname,e.inc08,e.income,e.pttype,
                        if(vp.claim_code ="1","เบิก"," ") as claim_code,vp.nhso_docno,vp.nhso_ownright_pid,vp.nhso_ownright_name 
                        from an_stat e
                        left outer join patient p on p.hn =e.hn
                        left outer join pttype pt on pt.pttype =e.pttype
                        left outer join ipt_pttype vp on vp.an = e.an
                        where e.dchdate between "'.$startdate.'" and "'.$enddate.'"
                        and month(e.dchdate) = "'.$months.'" 
                        and e.pttype in ("06","14","34","35","37","45","s7")
                        and (vp.claim_code is null or vp.claim_code ="2" or vp.claim_code =" ")
                        group by e.an 
                        order by e.dchdate 
                ');  
                
                return view('sss.ipd_outlocate_subnorep', $data );
        }
        public function opd_outlocate(Request $request)
        {  
                $startdate = $request->startdate;
                $enddate = $request->enddate; 

                $datashow = DB::connection('mysql3')->select('
                        SELECT year(v.vstdate) as monyear,month(v.vstdate) as months,count(distinct v.hn) as hn,count(distinct v.vn) as vn
                                ,sum(v.pttype in ("06","14","34","35","45")and i.an is null
                                and v.income > "10") as sumincome
                                ,sum(v.pttype in ("14","34","35","45")and i.an is null
                                and v.income > "10" and vp.claim_code ="1") as sumclaim_code
                                ,sum(v.pttype in ("06")and i.an is null
                                and v.income > "10") sumsix
                                ,sum(v.pttype in ("06")and i.an is null
                                and v.income > "10" and vp.claim_code ="1") as sumclam
                                ,sum(v.pttype in ("06","14","34","35","45") and i.an is null
                                and v.income > "10" and (vp.claim_code =" " or vp.claim_code is null)) as invoice
                                ,sum(v.income) as sumin
                                FROM vn_stat v
                                left outer join visit_pttype vp on vp.vn = v.vn
                                left outer join ipt i on i.vn = v.vn
                                left outer join pttype pt on pt.pttype = v.pttype
                                left outer join hospcode h on h.hospcode = v.hospmain
                                WHERE v.vstdate between "'.$startdate.'" AND "'.$enddate.'"
                                and pt.hipdata_code in("SSS","SSI")
                                and v.pttype <>"a7"
                                and i.an is null
                                group by month(v.vstdate)
        
                '); 

                return view('sss.opd_outlocate',[
                'datashow'   =>  $datashow,
                'startdate'  =>  $startdate,
                'enddate'    =>  $enddate,
                ]);
        }
        public function opd_outlocate_sub(Request $request,$months,$startdate,$enddate)
        {        
                $data['data_opd_outlocate_sub'] =  DB::connection('mysql3')->select('
                        select e.hn,e.pdx,e.vstdate,concat(p.pname,p.fname," ",p.lname) as fullname,e.inc08,e.income from vn_stat e
                        left outer join patient p on p.hn = e.hn
                        left outer join ipt i on i.vn = e.vn
                        left outer join pttype pt on pt.pttype = e.pttype
                        where e.vstdate between "'.$startdate.'" and "'.$enddate.'"
                        and month(e.vstdate) = "'.$months.'"
                        and pt.hipdata_code ="SSS"
                        and e.pttype <>"a7"
                        and i.an is null
                        group by e.hn 
                        order by e.vstdate 
                        
                '); 
                
                return view('sss.opd_outlocate_sub', $data,[ 
                'startdate'      =>  $startdate,
                'enddate'      =>  $enddate,
                ]);
        }
        public function opd_outlocate_subrep(Request $request,$months,$startdate,$enddate)
        {   
                $data['data_opd_outlocate_subrep'] =  DB::connection('mysql3')->select('
                        select e.hn,e.pdx,e.vstdate,concat(p.pname,p.fname," ",p.lname) as fullname,e.inc08,e.income,e.pttype from vn_stat e
                        left outer join patient p on p.hn = e.hn
                        left outer join ipt i on i.vn = e.vn
                        left outer join pttype pt on pt.pttype= e.pttype
                        where e.vstdate between "'.$startdate.'" and "'.$enddate.'"
                        and month(e.vstdate) = "'.$months.'" 
                        and pt.hipdata_code ="SSS"
                        and e.pttype <>"a7"
                        and i.an is null
                        group by e.vn 
                        order by e.vstdate 
                ');  
                return view('sss.opd_outlocate_subrep', $data );
        }
        public function opd_outlocate_subnorep(Request $request,$months,$startdate,$enddate)
        {   
                $data['data_opd_outlocate_subnorep'] =  DB::connection('mysql3')->select('
                        select e.hn,e.pdx,oo.cc,h.name,ii.tname,e.vstdate,concat(p.pname,p.fname," ",p.lname) as fullname,p.cid,concat(p.addrpart,"หมู่",p.moopart,"ต.",t3.name," อ.",t2.name," จ.",t1.name) as fulladdressname,e.inc08,e.income,r.rcpno,bill_amount,e.pttype from vn_stat e
                        left outer join patient p on p.hn = e.hn
                        left outer join ipt i on i.vn = e.vn
                        left outer join pttype pt on pt.pttype= e.pttype
                        left outer join thaiaddress t1 on t1.chwpart=p.chwpart and
                        t1.amppart="00" and t1.tmbpart="00"
                        left outer join thaiaddress t2 on t2.chwpart=p.chwpart and
                        t2.amppart=p.amppart and t2.tmbpart="00"
                        left outer join thaiaddress t3 on t3.chwpart=p.chwpart and
                        t3.amppart=p.amppart and t3.tmbpart=p.tmbpart
                        left outer join opdscreen oo on oo.vn = e.vn
                        left outer join icd101 ii on ii.code = e.pdx
                        left outer join rcpt_print r on r.vn =e.vn
                        left outer join hospcode h on h.hospcode = e.hospmain
                        where e.vstdate between "'.$startdate.'" and "'.$enddate.'"
                        and month(e.vstdate) = "'.$months.'" 
                        and pt.hipdata_code in("SSS","SSI")
                        and e.pttype <>"a7"
                        and e.pttype in ("06","14","34","35","45")
                        and i.an is null
                        and e.income > "10"
                        group by e.vn 
                        order by e.vstdate
        
                ');  
                
                return view('sss.opd_outlocate_subnorep', $data );
        }
        public function opd_outlocate_keyrep (Request $request,$months,$startdate,$enddate)
        {   
                $data['data_opd_outlocate_keyrep'] =  DB::connection('mysql3')->select('
                        select e.hn,e.pdx,e.vstdate,concat(p.pname,p.fname," ",p.lname) as fullname,p.cid,e.inc08,e.income,e.pttype,
                        if(vp.claim_code ="1","เบิก"," ") as claim_code,vp.nhso_docno,vp.nhso_ownright_pid,vp.nhso_ownright_name from vn_stat e
                        left outer join visit_pttype vp on vp.vn = e.vn
                        left outer join patient p on p.hn = e.hn
                        left outer join ipt i on i.vn = e.vn
                        left outer join pttype pt on pt.pttype= e.pttype
                        where e.vstdate between "'.$startdate.'" and "'.$enddate.'"
                        and month(e.vstdate) = "'.$months.'" 
                        and pt.hipdata_code in("SSS","SSI")
                        and e.pttype <>"a7"
                        and e.pttype in ("06","14","34","35","45")
                        and vp.claim_code ="1"
                        and i.an is null
                        and e.income > "10"
                        group by e.vn 
                        order by e.vstdate  
                '); 
                $data['data_opd_outlocate_keyreptotal'] =  DB::connection('mysql3')->select('
                        select sum(e.income) as sumtotal from vn_stat e
                        left outer join visit_pttype vp on vp.vn = e.vn
                        left outer join patient p on p.hn = e.hn
                        left outer join ipt i on i.vn = e.vn
                        left outer join pttype pt on pt.pttype= e.pttype
                        where e.vstdate between "'.$startdate.'" and "'.$enddate.'"
                        and month(e.vstdate) = "'.$months.'" 
                        and pt.hipdata_code in("SSS","SSI")
                        and e.pttype <>"a7"
                        and e.pttype in ("06","14","34","35","45")
                        and vp.claim_code ="1"
                        and i.an is null
                ');          
                return view('sss.opd_outlocate_keyrep ', $data );
        }
        public function opd_outlocate_tupol (Request $request,$months,$startdate,$enddate)
        {   
                $data['data_opd_outlocate_tupol'] =  DB::connection('mysql3')->select('
                        select e.hn,e.pdx ,e.vstdate,concat(p.pname,p.fname," ",p.lname) as fullname,p.cid,e.inc08,e.income,e.pttype,
                        if(vp.claim_code ="1","เบิก"," ") as claim_code,vp.nhso_docno,vp.nhso_ownright_pid,vp.nhso_ownright_name from vn_stat e
                        left outer join visit_pttype vp on vp.vn = e.vn
                        left outer join patient p on p.hn = e.hn
                        left outer join ipt i on i.vn = e.vn
                        left outer join pttype pt on pt.pttype= e.pttype
                        where e.vstdate between "'.$startdate.'" and "'.$enddate.'"
                        and month(e.vstdate) = "'.$months.'" 
                        and pt.hipdata_code in("SSS","SSI")
                        and e.pttype <>"a7"
                        and e.pttype in ("06")
                        and i.an is null
                        and e.income > "10"
                        group by e.vn 
                        order by e.hn,e.vstdate 
                '); 
                // $data['data_opd_outlocate_tupol'] =  DB::connection('mysql3')->select(' ');  
                return view('sss.opd_outlocate_tupol ', $data );
        }
        public function opd_outlocate_tupolkey (Request $request,$months,$startdate,$enddate)
        {   
                $data['data_opd_outlocate_tupolkey'] =  DB::connection('mysql3')->select('
                        select e.hn,e.pdx,e.vstdate,concat(p.pname,p.fname," ",p.lname) as fullname,p.cid,e.inc08,e.income,e.pttype,
                        if(vp.claim_code ="1","เบิก"," ") as claim_code,vp.nhso_docno,vp.nhso_ownright_pid,vp.nhso_ownright_name from vn_stat e
                        left outer join visit_pttype vp on vp.vn = e.vn
                        left outer join patient p on p.hn = e.hn
                        left outer join ipt i on i.vn = e.vn
                        left outer join pttype pt on pt.pttype= e.pttype
                        where e.vstdate between "'.$startdate.'" and "'.$enddate.'"
                        and month(e.vstdate) = "'.$months.'" 
                        and pt.hipdata_code in("SSS","SSI")
                        and e.pttype <>"a7"
                        and e.pttype in ("06")
                        and vp.claim_code ="1"
                        and e.income > "10"
                        and i.an is null
                        group by e.vn 
                        order by e.vstdate 
                '); 
                $data['data_opd_outlocate_tupolkeytotal'] =  DB::connection('mysql3')->select(' 
                        select sum(e.income) as sumtotal from vn_stat e
                        left outer join visit_pttype vp on vp.vn = e.vn
                        left outer join patient p on p.hn = e.hn
                        left outer join ipt i on i.vn = e.vn
                        left outer join pttype pt on pt.pttype= e.pttype
                        where e.vstdate between "'.$startdate.'" and "'.$enddate.'"
                        and month(e.vstdate) = "'.$months.'" 
                        and pt.hipdata_code in("SSS","SSI")
                        and e.pttype  <>"a7"
                        and e.pttype in ("06","14","34","35","45")
                        and vp.claim_code ="1"
                        and i.an is null 
                ');  
                return view('sss.opd_outlocate_tupolkey ', $data );
        }
        public function opd_outlocate_total  (Request $request,$months,$startdate,$enddate)
        {   
                $data['data_opd_outlocate_total'] =  DB::connection('mysql3')->select('
                        select e.hn,e.pdx,e.vstdate,concat(p.pname,p.fname," ",p.lname) as fullname,e.cid,e.inc08,e.income,e.pttype,
                        if(vp.claim_code is null,"ยังไม่เบิก","เบิก") as claim_code
                        ,vp.nhso_docno,vp.nhso_ownright_pid,vp.nhso_ownright_name from vn_stat e
                        left outer join visit_pttype vp on vp.vn = e.vn
                        left outer join patient p on p.hn = e.hn
                        left outer join ipt i on i.vn = e.vn
                        left outer join pttype pt on pt.pttype= e.pttype
                        where e.vstdate between "'.$startdate.'" and "'.$enddate.'"
                        and month(e.vstdate) = "'.$months.'"  
                        and pt.hipdata_code in("SSS","SSI")
                        and e.pttype in ("06","14","34","35","45")
                   
                        and e.income > "10"
                        group by e.vn 
                        order by e.vstdate 
                '); 
                // and (vp.claim_code is null or vp.claim_code = " ")
                return view('sss.opd_outlocate_total  ', $data );
        }
        public function opd_chai(Request $request)
        {  
                $startdate = $request->startdate;
                $enddate = $request->enddate; 

                $datashow = DB::connection('mysql3')->select('
                        SELECT year(v.vstdate) as year,
                        month(v.vstdate) as months,
                        count(distinct v.hn) as hn,
                        count(distinct v.vn) as vn,
                        count(distinct r.vn) as disvn,
                        count(v.vn)- count(distinct r.vn) as tovn
                        ,sum(v.uc_money) as summony
                        FROM vn_stat v
                        left outer join ipt i on i.vn = v.vn
                        left join sssch ss on ss.cid = v.vn 
                        left join rcpt_debt r on r.vn = v.vn 
                        WHERE v.vstdate between "'.$startdate.'" AND "'.$enddate.'"
                        and v.pttype in ("a7")
                        and i.an is null
                        group by month(v.vstdate) 
                '); 
                return view('sss.opd_chai',[
                'datashow'   =>  $datashow,
                'startdate'  =>  $startdate,
                'enddate'    =>  $enddate,
                ]);
        }
        public function opd_chai_hn(Request $request)
        {  
                $startdate = $request->startdate;
                $enddate = $request->enddate; 

                $datashow = DB::connection('mysql3')->select('
                        SELECT year(v.vstdate) as monyear,month(v.vstdate) as months,count(distinct v.hn) as hn,count(distinct v.vn) as vn,
                        count(distinct r.vn) as sumincome,
                        count(v.vn)- count(distinct r.vn) as sumclaim_code,sum(v.uc_money) as uc_money
                        FROM vn_stat v
                        left outer join ipt i on i.vn = v.vn
                        left join sssch ss on ss.cid = v.vn 
                        left join rcpt_debt r on r.vn = v.vn 
                        WHERE v.vstdate between "'.$startdate.'" AND "'.$enddate.'"
                        and v.pttype in ("a7")
                        and i.an is null
                        group by month(v.vstdate) 
                '); 

                return view('sss.opd_chai_hn ',[
                'datashow'   =>  $datashow,
                'startdate'  =>  $startdate,
                'enddate'    =>  $enddate,
                ]);
        }
        public function opd_chai_list(Request $request)
        {  
                $checjtype = $request->typesick;
                $startdate = $request->startdate;
                $enddate = $request->enddate;
                // dd($checjtype); 

                if ($checjtype == 'OPD') {
                        $datashow = DB::connection('mysql3')->select(' 
                                SELECT 
                                year(o.vstdate) as year,month(o.vstdate) as months
                                ,count(distinct o.vn,o.icode) as vn
                                ,count(distinct vp.vn) as repvn
                                ,count(distinct o.vn,o.icode)- count(distinct vp.vn) as norep
                                ,sum(o.sum_price) as summony
                                FROM opitemrece o
                                left join vn_stat v on v.vn=o.vn
                                left outer join visit_pttype vp on vp.vn = o.vn
                                left outer join pttype pt on pt.pttype = o.pttype
                                left outer join hospcode h on h.hospcode = v.hospmain
                                LEFT JOIN nondrugitems n on n.icode = o.icode
                                LEFT JOIN eclaimdb.l_instrumentitem l on l.`CODE` = n.billcode and l.MAININSCL="sss" 
                                left join patient p on p.hn = v.hn
                                WHERE o.vstdate between "'.$startdate.'" AND "'.$enddate.'"
                                and o.income="02" 
                                and v.pttype="A7"
                                and n.billcode  not in (select `CODE` from eclaimdb.l_instrumentitem where `CODE`= l.`CODE`)
                                and n.billcode like "8%"
                                and n.billcode not in ("8608","8307")
                                and o.an is null                                 
                                group by month(o.vstdate)
                                order by o.vstdate                        
                        ');                 
                } else {
                        $datashow = DB::connection('mysql3')->select('
                                SELECT year(v.dchdate) as year,month(v.dchdate) as months,count(distinct o.an) as an
                                ,if(COUNT(vp.nhso_ownright_pid) > "0",COUNT(vp.nhso_ownright_pid),"0") as claim
                                ,count(v.an) - if(COUNT(vp.nhso_ownright_pid) > "0",COUNT(vp.nhso_ownright_pid),"0") as noclaim
                                ,sum(o.sum_price) as summony
                               
                                FROM opitemrece o
                                inner join an_stat v on v.an=o.an
                                left outer join ipt_pttype vp on vp.an = o.an  
                                left outer join pttype pt on pt.pttype = o.pttype
                                left outer join hospcode h on h.hospcode = vp.hospmain
                                LEFT JOIN nondrugitems n on n.icode = o.icode
                                LEFT JOIN eclaimdb.l_instrumentitem l on l.`CODE` = n.billcode and l.MAININSCL="sss" 
                                WHERE v.dchdate between "'.$startdate.'" AND "'.$enddate.'"                                
                                and o.income="02" 
                                and v.pttype="a7"
                                and n.billcode not in (select `CODE` from eclaimdb.l_instrumentitem where `CODE`= l.`CODE`)
                                and n.billcode like "8%"
                                and n.billcode not in("8608","8628","8361","8543","8152","8660")                            
                                group by month(v.dchdate) 
                        '); 
                }                
                
                return view('sss.opd_chai_list',[
                'datashow'       =>  $datashow,
                'startdate'      =>  $startdate,
                'enddate'        =>  $enddate,
                'typesick'       =>  $checjtype
                ]);
        }
        public function opd_chai_listvn(Request $request,$months,$startdate,$enddate)
        {   
                $datashow = DB::connection('mysql3')->select('
                        select v.vn,o.hn,v.pdx,o.vstdate,concat(p.pname,p.fname," ",p.lname) as fullname,o.icode,n.name,n.billcode
                        ,vp.claim_code,vp.nhso_docno,vp.max_debt_amount
                        ,o.qty,o.sum_price*o.qty as total
                        FROM hos.opitemrece o
                        left join hos.vn_stat v on v.vn=o.vn
                        left outer join hos.visit_pttype vp on vp.vn = o.vn
                        left outer join hos.pttype pt on pt.pttype = o.pttype
                        left outer join hos.hospcode h on h.hospcode = v.hospmain
                        LEFT JOIN hos.nondrugitems n on n.icode = o.icode
                        LEFT JOIN eclaimdb.l_instrumentitem l on l.`CODE` = n.billcode and l.MAININSCL="sss" 
                        left join hos.patient p on p.hn = v.hn
                        where o.vstdate between "'.$startdate.'" AND "'.$enddate.'"
                        and month(o.vstdate) = "'.$months.'" 
                        and o.pttype="a7"
                        and n.billcode not in(select `CODE` from eclaimdb.l_instrumentitem where `CODE`= l.`CODE`)
                        and n.billcode like "8%"
                        and n.billcode not in ("8608","8307")
                        and o.an is null
                    
                        group by v.vn
                        order by v.vstdate
        
                '); 

                return view('sss.opd_chai_listvn ',[
                'datashow'   =>  $datashow,
                'startdate'  =>  $startdate,
                'enddate'    =>  $enddate,
                ]);
        }
        public function opd_chai_listrep(Request $request,$months,$startdate,$enddate)
        {  
              
                $datashow = DB::connection('mysql3')->select('
                select v.vn,o.hn,v.pdx,o.vstdate,concat(p.pname,p.fname," ",p.lname) as fullname,n.name,n.billcode,o.qty,o.sum_price*o.qty as total
                ,vp.claim_code,vp.nhso_docno,vp.max_debt_amount,o.icode
                FROM hos.opitemrece o
                left join hos.vn_stat v on v.vn=o.vn
                left outer join hos.visit_pttype vp on vp.vn = o.vn
                left outer join hos.pttype pt on pt.pttype = o.pttype
                left outer join hos.hospcode h on h.hospcode = v.hospmain
                LEFT JOIN hos.nondrugitems n on n.icode = o.icode
                LEFT JOIN eclaimdb.l_instrumentitem l on l.`CODE` = n.billcode and l.MAININSCL="sss" 
                left join hos.patient p on p.hn = v.hn
        
                        where o.vstdate between "'.$startdate.'" AND "'.$enddate.'"
                        and month(o.vstdate) = "'.$months.'" 
                        and o.income="02" 
                        and o.pttype="a7"
                        and n.billcode  not in (select `CODE` from eclaimdb.l_instrumentitem where `CODE`= l.`CODE`)
                        and n.billcode like "8%"
                        and n.billcode not in ("8608","8307")
                        and o.an is null
                        
                        and vp.claim_code="1"
                        group by o.vn,o.icode 
                        order by v.vstdate 
                        
                '); 
                // and vp.max_debt_amount > 1

                // select o.hn,v.pdx,o.vstdate,concat(p.pname,p.fname,'  ',p.lname) as fullname,n.name,n.billcode,o.qty,o.sum_price*o.qty
                // FROM hos.opitemrece o
                // left join hos.vn_stat v on v.vn=o.vn
                // left outer join hos.visit_pttype vp on vp.vn = o.vn
                // left outer join hos.pttype pt on pt.pttype = o.pttype
                // left outer join hos.hospcode h on h.hospcode = v.hospmain
                // LEFT JOIN hos.nondrugitems n on n.icode = o.icode
                // LEFT JOIN eclaimdb.l_instrumentitem l on l.`CODE` = n.billcode and l.MAININSCL='sss' 
                // left join hos.patient p on p.hn = v.hn
                // where o.vstdate between '2021-10-01' and '2022-09-30'
                // and month(o.vstdate) = '".$month."' 
                // and o.income='02' 
                // and o.pttype='a7'
                // and n.billcode  not in (select `CODE` from eclaimdb.l_instrumentitem where `CODE`= l.`CODE`)
                // and n.billcode like '8%'
                // and n.billcode not in ('8608','8307')
                // and o.an is null
                // and vp.max_debt_amount is null
                // group by o.vn,o.icode 
                // order by v.vstdate
                //  and vp.max_debt_amount is null
                //         group by o.vn,o.icode 
        
                return view('sss.opd_chai_listrep ',[
                'datashow'   =>  $datashow,
                'startdate'  =>  $startdate,
                'enddate'    =>  $enddate,
                ]);
        }
        public function opd_chai_listnorep(Request $request,$months,$startdate,$enddate)
        {  
                 
                $datashow = DB::connection('mysql3')->select('
                        

                                select v.vn,o.hn,v.pdx,p.cid,o.vstdate,concat(p.pname,p.fname," ",p.lname) as fullname,n.name as nname,n.billcode,o.qty,o.sum_price*o.qty as total
                                        ,vp.claim_code,vp.nhso_docno,vp.max_debt_amount,o.icode
                                        FROM hos.opitemrece o
                                        left join hos.vn_stat v on v.vn=o.vn
                                        left outer join hos.visit_pttype vp on vp.vn = o.vn
                                        left outer join hos.pttype pt on pt.pttype = o.pttype
                                        left outer join hos.hospcode h on h.hospcode = v.hospmain
                                        LEFT JOIN hos.nondrugitems n on n.icode = o.icode
                                        LEFT JOIN eclaimdb.l_instrumentitem l on l.`CODE` = n.billcode and l.MAININSCL="sss" 
                                        left join hos.patient p on p.hn = v.hn
                                
                                                where o.vstdate between "'.$startdate.'" AND "'.$enddate.'"
                                                and month(o.vstdate) = "'.$months.'" 
                                                and o.income="02" 
                                                and o.pttype="a7"
                                                and n.billcode  not in (select `CODE` from eclaimdb.l_instrumentitem where `CODE`= l.`CODE`)
                                                and n.billcode like "8%"
                                                and n.billcode not in ("8608","8307")
                                                and o.an is null
                                                
                                                and vp.claim_code is null
                                                group by o.vn,o.icode 
                                                order by v.vstdate 
                '); 
                // select o.hn,v.vn,p.cid,p.birthday,v.pdx,o.vstdate,concat(p.pname,p.fname," ",p.lname) as fullname,n.name as nname,n.billcode,o.qty,o.sum_price*o.qty as total
                //         FROM hos.opitemrece o
                //         left join hos.vn_stat v on v.vn=o.vn
                //         left outer join hos.visit_pttype vp on vp.vn = o.vn
                //         left outer join hos.pttype pt on pt.pttype = o.pttype
                //         left outer join hos.hospcode h on h.hospcode = v.hospmain
                //         LEFT JOIN hos.nondrugitems n on n.icode = o.icode
                //         LEFT JOIN eclaimdb.l_instrumentitem l on l.`CODE` = n.billcode and l.MAININSCL="sss" 
                //         left join hos.patient p on p.hn = v.hn
                
                //                 where o.vstdate between "'.$startdate.'" AND "'.$enddate.'"
                //                 and month(o.vstdate) = "'.$months.'" 
                //                 and o.income="02" 
                //                 and o.pttype="a7"
                //                 and n.billcode  not in (select `CODE` from eclaimdb.l_instrumentitem where `CODE`= l.`CODE`)
                //                 and n.billcode like "8%"
                //                 and n.billcode not in ("8608","8307")
                //                 and o.an is null
                //                 and vp.max_debt_amount is null
                //                 group by o.vn,o.icode 
                //                 order by v.vstdate 
 
        
                return view('sss.opd_chai_listnorep ',[
                'datashow'   =>  $datashow,
                'startdate'  =>  $startdate,
                'enddate'    =>  $enddate,
                ]);
        }

        public function ipd_chai_vn(Request $request,$months,$startdate,$enddate)
        {   
                $datashow = DB::connection('mysql3')->select('
                        select o.hn,o.an,v.pdx,o.vstdate,v.dchdate ,concat(p.pname,p.fname," ",p.lname) as fullname,n.name,n.billcode,o.qty,o.sum_price*o.qty as total
                        ,vp.claim_code,vp.nhso_docno,vp.max_debt_amount,o.icode,vp.nhso_ownright_pid
                        FROM opitemrece o
                        left join an_stat v on v.an=o.an
                        left outer join ipt_pttype vp on vp.an = o.an
                        left outer join pttype pt on pt.pttype = o.pttype
                        left outer join hospcode h on h.hospcode = vp.hospmain
                        LEFT JOIN nondrugitems n on n.icode = o.icode
                        LEFT JOIN eclaimdb.l_instrumentitem l on l.`CODE` = n.billcode and l.MAININSCL="sss" 
                        left join patient p on p.hn = v.hn
                        where v.dchdate between "'.$startdate.'" AND "'.$enddate.'"
                        and month(v.dchdate) = "'.$months.'" 
                        and o.income="02" 
                        and o.pttype="a7"
                        and n.billcode  not in (select `CODE` from eclaimdb.l_instrumentitem where `CODE`= l.`CODE`)
                        and n.billcode like "8%"
                        and n.billcode not in("8608","8628","8361","8543","8152","8660")
                        group by v.an 
                        order by v.dchdate 
                '); 
                // group by o.an,o.icode 
                return view('sss.ipd_chai_vn ',[
                'datashow'   =>  $datashow,
                'startdate'  =>  $startdate,
                'enddate'    =>  $enddate,
                ]);
        }
                //     public function ipd_chai_rep(Request $request,$months,$startdate,$enddate)
                //     {  
                //         $startdate = $request->startdate;
                //         $enddate = $request->enddate; 

                //         $datashow = DB::connection('mysql3')->select('
                //                 select o.hn,o.an,v.pdx,o.vstdate,concat(p.pname,p.fname," ",p.lname) as fullname,n.name,n.billcode,o.qty,o.sum_price*o.qty as total
                //                 FROM hos.opitemrece o
                //                 left join hos.an_stat v on v.an=o.an
                //                 left outer join hos.ipt_pttype vp on vp.an = o.an
                //                 left outer join hos.pttype pt on pt.pttype = o.pttype
                //                 left outer join hos.hospcode h on h.hospcode = vp.hospmain
                //                 LEFT JOIN hos.nondrugitems n on n.icode = o.icode
                //                 LEFT JOIN eclaimdb.l_instrumentitem l on l.`CODE` = n.billcode and l.MAININSCL="sss" 
                //                 left join hos.patient p on p.hn = v.hn
                //                 where v.dchdate between "'.$startdate.'" AND "'.$enddate.'"
                //                 and month(v.dchdate) = "'.$months.'"  
                //                 and o.pttype="a7"
                //                 and n.billcode  not in (select `CODE` from eclaimdb.l_instrumentitem where `CODE`= l.`CODE`)
                //                 and n.billcode like "8%"
                //                 and n.billcode not in ("8608")
                //                 and vp.nhso_ownright_pid > 1
                //                 group by o.an,o.icode 
                //                 order by v.dchdate 
                //         '); 

                //         return view('sss.ipd_chai_rep ',[
                //             'datashow'   =>  $datashow,
                //             'startdate'  =>  $startdate,
                //             'enddate'    =>  $enddate,
                //         ]);
                //     }
        public function ipd_chai_rep(Request $request,$months,$startdate,$enddate)
        {   

                        $datashow = DB::connection('mysql3')->select('
                                select v.hn,o.hn,o.an,v.pdx,o.vstdate,v.dchdate ,concat(p.pname,p.fname," ",p.lname) as fullname,n.name as nname,n.billcode,o.qty,o.sum_price*o.qty as total 
                                ,vp.claim_code,vp.nhso_docno,vp.max_debt_amount,o.icode,vp.nhso_ownright_pid,i.regdate,i.regtime,p.cid
                                ,i.dchtime,ss.name as wardnamepay,d.name as typename,dd.name as typepay,v.pdx,v.income,v.pttype,s.name as wardname
                                ,sum(vp.nhso_ownright_pid) as nhso_ownright_pid,sum(vp.nhso_ownright_name) as nhso_ownright_name,V.inc08
                                ,if(vp.nhso_ownright_pid >"0","เบิก"," ") as rep
                                FROM opitemrece o
                                left join an_stat v on v.an=o.an
                                left outer join ipt i on i.an = v.an
                                left outer join spclty s on s.spclty = i.spclty
                                left outer join spclty ss on ss.spclty = i.ipt_spclty
                                left outer join dchstts d on d.dchstts = i.dchstts
                                left outer join dchtype dd on dd.dchtype = i.dchtype
                                left outer join ipt_pttype vp on vp.an = o.an
                                left outer join pttype pt on pt.pttype = o.pttype
                                left outer join hospcode h on h.hospcode = vp.hospmain
                                LEFT JOIN nondrugitems n on n.icode = o.icode
                                LEFT JOIN eclaimdb.l_instrumentitem l on l.`CODE` = n.billcode and l.MAININSCL="sss" 
                                left join patient p on p.hn = v.hn
                                where v.dchdate between "'.$startdate.'" AND "'.$enddate.'"
                                and month(v.dchdate) = "'.$months.'" 
                                and o.income="02" 
                                and o.pttype="a7"
                                and n.billcode  not in (select `CODE` from eclaimdb.l_instrumentitem where `CODE`= l.`CODE`)
                                and n.billcode like "8%"
                                and n.billcode not in("8608","8628","8361","8543","8152","8660") 
                           
                                and vp.nhso_docno is not null 
                                group by o.an,o.icode 
                        '); 
                        // and vp.nhso_ownright_pid > 1
                        $datashow2 = DB::connection('mysql3')->select('
                                        select count(distinct e.an) as an,sum(vp.nhso_ownright_pid) as nhso_ownright_pid,sum(vp.nhso_ownright_name) as nhso_ownright_name from an_stat e
                                        left outer join patient p on p.hn =e.hn
                                        left outer join pttype pt on pt.pttype =e.pttype
                                        left outer join ipt_pttype vp on vp.an = e.an
                                        where e.dchdate between "'.$startdate.'" AND "'.$enddate.'"
                                        and month(e.dchdate) = "'.$months.'"  
                                        and e.pttype in("a7","06")
                                        and vp.claim_code ="1"
                        '); 
                        // $datashow = DB::connection('mysql3')->select('
                        //         select e.hn,e.an,e.dchdate,concat(p.pname,p.fname," ",p.lname) as fullname,e.inc08,e.income,e.pttype,
                        //                 if(vp.claim_code ="1","เบิก"," ") as rep,vp.nhso_docno,vp.nhso_ownright_pid,vp.nhso_ownright_name 
                        //                      from an_stat e
                        //                 left outer join patient p on p.hn =e.hn
                        //                 left outer join pttype pt on pt.pttype =e.pttype
                        //                 left outer join ipt_pttype vp on vp.an = e.an
                        //                 where e.dchdate between "'.$startdate.'" AND "'.$enddate.'"
                        //                 and month(e.dchdate) = "'.$months.'"  
                        //                 and e.pttype in("a7")
                        //                 and vp.claim_code ="1"
                        //                 group by e.an 
                        //                 order by e.dchdate 
                        // '); 

                        return view('sss.ipd_chai_rep ',[
                                'datashow'   =>  $datashow,
                                'datashow2'   =>  $datashow2,
                                'startdate'  =>  $startdate,
                                'enddate'    =>  $enddate,
                        ]);
        }
        public function ipd_chai(Request $request)
        {  
                $startdate = $request->startdate;
                $enddate = $request->enddate; 

                $datashow = DB::connection('mysql3')->select('
                        select year(a.dchdate) as year
                        ,month(a.dchdate) as months
                        ,count(distinct a.an) as an
                        ,sum(a.an and a.an in (select an from ipt_pttype where an is not null and claim_code ="1")) as noman
                        ,sum(a.an and a.an in (select an from ipt_pttype where an is not null and claim_code is null)) as nonoman
                        ,round(sum(ii.adjrw),2) as adjrw
                        ,sum(vp.nhso_ownright_pid) as nhso_ownright_pid,sum(vp.nhso_ownright_name) as nhso_ownright_name
                        ,100*sum(a.an and a.an in (select an from ipt_pttype where an is not null and claim_code ="1"))/count(distinct a.an) as sumclaim_code
                        from an_stat a
                        left outer join pttype p on p.pttype = a.pttype
                        left outer join icd9cm1 i on i.code in("op0","op1","op2","op3","op4","op5","op6")
                        left outer join ipt_pttype vp on vp.an = a.an
                        left outer join ipt ii on ii.an = a.an
                        where a.dchdate between "'.$startdate.'" AND "'.$enddate.'"
                        and a.pttype in("a7")
                        group by month(a.dchdate) 
                '); 
                return view('sss.ipd_chai',[
                        'datashow'   =>  $datashow,
                        'startdate'  =>  $startdate,
                        'enddate'    =>  $enddate,
                ]);
        }
        public function ipd_chai_an(Request $request,$months,$startdate,$enddate)
        {   

                        $datashow = DB::connection('mysql3')->select('
                                select v.hn,v.an,concat(p.pname,p.fname," ",p.lname) as fullname,p.cid,concat(day(p.birthday),"/",month(p.birthday),"/",year(p.birthday)+543) as birth,
                                v.regdate,i.regtime,s.name as wardname,v.dchdate,i.dchtime,ss.name as payward,
                                d.name as status,dd.name as typename,v.pdx,v.income,v.pttype,ddd.name as doctor,ddd.licenseno,pp.claim_code
                                ,(select group_concat(distinct n.name) from opitemrece o
                                left outer join nondrugitems n on n.icode = o.icode
                                where o.an =v.an 
                                and o.icode in("3010601","3010605","3010590","3010604","3010602","3010603","3010592","3010591","3010600","3000406"
                                ,"3000407","3010640","3010641","3010697","3010698")
                                group by n.name limit 1) as Claimno
                                from an_stat v
                                left outer join opdscreen oo on oo.vn = v.vn
                                left outer join patient p on p.hn = v.hn
                                left outer join ipt i on i.an = v.an 
                                left outer join spclty s on s.spclty = i.spclty
                                left outer join spclty ss on ss.spclty = i.ipt_spclty
                                left outer join dchstts d on d.dchstts = i.dchstts
                                left outer join dchtype dd on dd.dchtype = i.dchtype
                                left outer join doctor ddd on ddd.code = i.dch_doctor
                                left outer join ipt_pttype pp on pp.an = v.an
                                where v.dchdate between "'.$startdate.'" AND "'.$enddate.'"
                                and v.pttype in("a7")
                                and month(v.dchdate) = "'.$months.'" 
                                group by v.an

                        '); 

                        return view('sss.ipd_chai_an ',[
                                'datashow'   =>  $datashow,
                                'startdate'  =>  $startdate,
                                'enddate'    =>  $enddate,
                        ]);
        }
        public function ipd_chai_norep(Request $request,$months,$startdate,$enddate)
        {   

                        $datashow = DB::connection('mysql3')->select(' 
                                select v.hn,o.hn,o.an,v.pdx,o.vstdate,v.dchdate ,concat(p.pname,p.fname," ",p.lname) as fullname,n.name as nname,n.billcode,o.qty,o.sum_price*o.qty as total 
                                ,vp.claim_code,vp.nhso_docno,vp.max_debt_amount,o.icode,vp.nhso_ownright_pid,i.regdate,i.regtime,p.cid
                                ,i.dchtime,ss.name as wardnamepay,d.name as typename,dd.name as typepay,v.pdx,v.income,v.pttype,s.name as wardname
                                FROM opitemrece o
                                left join an_stat v on v.an=o.an
                                left outer join ipt i on i.an = v.an
                                left outer join spclty s on s.spclty = i.spclty
                                left outer join spclty ss on ss.spclty = i.ipt_spclty
                                left outer join dchstts d on d.dchstts = i.dchstts
                                left outer join dchtype dd on dd.dchtype = i.dchtype
                                left outer join ipt_pttype vp on vp.an = o.an
                                left outer join pttype pt on pt.pttype = o.pttype
                                left outer join hospcode h on h.hospcode = vp.hospmain
                                LEFT JOIN nondrugitems n on n.icode = o.icode
                                LEFT JOIN eclaimdb.l_instrumentitem l on l.`CODE` = n.billcode and l.MAININSCL="sss" 
                                left join patient p on p.hn = v.hn
                                where v.dchdate between "'.$startdate.'" AND "'.$enddate.'"
                                and month(v.dchdate) = "'.$months.'" 
                                and o.income="02" 
                                and o.pttype="a7"
                                and n.billcode  not in (select `CODE` from eclaimdb.l_instrumentitem where `CODE`= l.`CODE`)
                                and n.billcode like "8%"
                                and n.billcode not in ("8608","8628","8361","8543","8152","8660") 
                                and vp.nhso_ownright_pid is null    
                        '); 
                        // and v.pttype in("a7")
                        // and (vp.claim_code is null or vp.claim_code="2")

                        // select v.hn,o.hn,o.an,v.pdx,o.vstdate,v.dchdate ,concat(p.pname,p.fname," ",p.lname) as fullname,n.name,n.billcode,o.qty,o.sum_price*o.qty as total
                        // ,vp.claim_code,vp.nhso_docno,vp.max_debt_amount,o.icode,vp.nhso_ownright_pid,i.regdate,i.regtime,p.cid,p.birthday
                        // FROM opitemrece o
                        // left join an_stat v on v.an=o.an
                        // left outer join ipt i on i.an = v.an
                        // left outer join ipt_pttype vp on vp.an = o.an
                        // left outer join pttype pt on pt.pttype = o.pttype
                        // left outer join hospcode h on h.hospcode = vp.hospmain
                        // LEFT JOIN nondrugitems n on n.icode = o.icode
                        // LEFT JOIN eclaimdb.l_instrumentitem l on l.`CODE` = n.billcode and l.MAININSCL="sss" 
                        // left join patient p on p.hn = v.hn
                        // where v.dchdate between "'.$startdate.'" AND "'.$enddate.'"
                        // and month(v.dchdate) = "'.$months.'" 
                        // and o.income="02" 
                        // and o.pttype="a7"
                        // and n.billcode  not in (select `CODE` from eclaimdb.l_instrumentitem where `CODE`= l.`CODE`)
                        // and n.billcode like "8%"
                        // and n.billcode not in ("8608","8628","8361","8543","8152","8660")
                        // group by v.an 
                        // order by v.dchdate 
 
                        return view('sss.ipd_chai_norep',[
                                'datashow'   =>  $datashow,
                                'startdate'  =>  $startdate,
                                'enddate'    =>  $enddate,
                        ]);
        }
        public function ipd_chairep(Request $request,$months,$year)
        {   
                        $datashow = DB::connection('mysql3')->select(' 
                                
                                select v.hn,v.an,concat(p.pname,p.fname," ",p.lname) as fullname,p.cid,concat(day(p.birthday),"/",month(p.birthday),"/",year(p.birthday)+543) as birth,
                                v.regdate,i.regtime,s.name as wardname,v.dchdate,i.dchtime,ss.name as payward,
                                d.name as status,dd.name as typename,v.pdx,v.income,v.pttype,ddd.name as doctor,ddd.licenseno,pp.claim_code
                                
                                from an_stat v
                                left outer join opdscreen oo on oo.vn = v.vn
                                left outer join patient p on p.hn = v.hn
                                left outer join ipt i on i.an = v.an 
                                left outer join spclty s on s.spclty = i.spclty
                                left outer join spclty ss on ss.spclty = i.ipt_spclty
                                left outer join dchstts d on d.dchstts = i.dchstts
                                left outer join dchtype dd on dd.dchtype = i.dchtype
                                left outer join doctor ddd on ddd.code = i.dch_doctor
                                left outer join ipt_pttype pp on pp.an = v.an
                                where year(v.dchdate) = "'.$year.'" 
                                and v.pttype in("a7")
                                and month(v.dchdate) = "'.$months.'" 
                                and pp.claim_code is not null
                                group by v.an
                        '); 
                        
 
                        return view('sss.ipd_chairep',[
                                'datashow'   =>  $datashow,
                                'year'       =>  $year,
                                'months'     =>  $months,
                        ]);
        }
        public function ipd_chaino(Request $request,$months,$year)
        {   
                        $datashow = DB::connection('mysql3')->select(' 
                                
                                select v.hn,v.an,concat(p.pname,p.fname," ",p.lname) as fullname,p.cid,concat(day(p.birthday),"/",month(p.birthday),"/",year(p.birthday)+543) as birth,
                                v.regdate,i.regtime,s.name as wardname,v.dchdate,i.dchtime,ss.name as payward,
                                d.name as status,dd.name as typename,v.pdx,v.income,v.pttype,ddd.name as doctor,ddd.licenseno,pp.claim_code
                                
                                from an_stat v
                                left outer join opdscreen oo on oo.vn = v.vn
                                left outer join patient p on p.hn = v.hn
                                left outer join ipt i on i.an = v.an 
                                left outer join spclty s on s.spclty = i.spclty
                                left outer join spclty ss on ss.spclty = i.ipt_spclty
                                left outer join dchstts d on d.dchstts = i.dchstts
                                left outer join dchtype dd on dd.dchtype = i.dchtype
                                left outer join doctor ddd on ddd.code = i.dch_doctor
                                left outer join ipt_pttype pp on pp.an = v.an
                                where year(v.dchdate) = "'.$year.'" 
                                and v.pttype in("a7")
                                and month(v.dchdate) = "'.$months.'" 
                                and pp.claim_code is null
                                group by v.an
                        '); 
                        
 
                        return view('sss.ipd_chaino',[
                                'datashow'   =>  $datashow,
                                'year'       =>  $year,
                                'months'     =>  $months,
                        ]);
        }
        public function ipd_chai_norep____(Request $request,$months,$startdate,$enddate)
        {   

                        $datashow = DB::connection('mysql3')->select('
                        select v.hn,v.an,concat(p.pname,p.fname," ",p.lname) as fullname,p.cid,p.birthday,
                        v.regdate,i.regtime,s.name as wardname,v.dchdate,i.dchtime,ss.name as wardnamepay,
                        d.name as typename,dd.name as typepay,v.pdx,v.income,v.pttype
                        from an_stat v
                        left outer join opdscreen oo on oo.vn = v.vn
                        left outer join patient p on p.hn = v.hn
                        left outer join ipt i on i.an = v.an 
                        left outer join spclty s on s.spclty = i.spclty
                        left outer join spclty ss on ss.spclty = i.ipt_spclty
                        left outer join dchstts d on d.dchstts = i.dchstts
                        left outer join dchtype dd on dd.dchtype = i.dchtype
                        left outer join ipt_pttype vp on vp.an = v.an
                        left join opitemrece o on v.an=o.an
                        LEFT JOIN nondrugitems n on n.icode = o.icode
                        LEFT JOIN eclaimdb.l_instrumentitem l on l.`CODE` = n.billcode and l.MAININSCL="sss" 
                        where v.dchdate between "'.$startdate.'" AND "'.$enddate.'"
                       
                        and month(v.dchdate) = "'.$months.'"
                        and o.income="02" 
                        and o.pttype="a7"
                        and n.billcode  not in (select `CODE` from eclaimdb.l_instrumentitem where `CODE`= l.`CODE`)
                        and n.billcode like "8%"
                        and n.billcode not in ("8608","8628","8361","8543","8152","8660")
                        group by v.an 

                               
                        '); 
                        // and v.pttype in("a7")
                        // and (vp.claim_code is null or vp.claim_code="2")

                        // select v.hn,o.hn,o.an,v.pdx,o.vstdate,v.dchdate ,concat(p.pname,p.fname," ",p.lname) as fullname,n.name,n.billcode,o.qty,o.sum_price*o.qty as total
                        // ,vp.claim_code,vp.nhso_docno,vp.max_debt_amount,o.icode,vp.nhso_ownright_pid,i.regdate,i.regtime,p.cid,p.birthday
                        // FROM opitemrece o
                        // left join an_stat v on v.an=o.an
                        // left outer join ipt i on i.an = v.an
                        // left outer join ipt_pttype vp on vp.an = o.an
                        // left outer join pttype pt on pt.pttype = o.pttype
                        // left outer join hospcode h on h.hospcode = vp.hospmain
                        // LEFT JOIN nondrugitems n on n.icode = o.icode
                        // LEFT JOIN eclaimdb.l_instrumentitem l on l.`CODE` = n.billcode and l.MAININSCL="sss" 
                        // left join patient p on p.hn = v.hn
                        // where v.dchdate between "'.$startdate.'" AND "'.$enddate.'"
                        // and month(v.dchdate) = "'.$months.'" 
                        // and o.income="02" 
                        // and o.pttype="a7"
                        // and n.billcode  not in (select `CODE` from eclaimdb.l_instrumentitem where `CODE`= l.`CODE`)
                        // and n.billcode like "8%"
                        // and n.billcode not in ("8608","8628","8361","8543","8152","8660")
                        // group by v.an 
                        // order by v.dchdate 
 
                        return view('sss.ipd_chai_norep',[
                                'datashow'   =>  $datashow,
                                'startdate'  =>  $startdate,
                                'enddate'    =>  $enddate,
                        ]);
        }
        public function inst_sss(Request $request)
        {     
                return view('sss.inst_sss');
        }
        public function inst_sss_todtan(Request $request)
        {     
                return view('sss.inst_sss_todtan');
        }}
