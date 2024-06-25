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

class CheckwardController extends Controller
{
    public function check_ward(Request $request)
    { 
        $data['users'] = User::get();
        $budget = DB::table('budget_year')->where('active','=','True')->first();
        $datestart = $budget->date_begin;
        $dateend = $budget->date_end;
        $data_ward = DB::connection('mysql3')->select('   
            select i.ward,w.name as wardname,count(distinct i.an) as AA,(count(distinct i.an)-count(distinct pt.hn))+count(distinct ptt.hn) as BB
                ,count(distinct pi.an) as CC,count(distinct px.an) as DD
                from hos.ipt i 
                left outer join hos.doctor d on d.code = i.admdoctor
                left outer join hos.an_stat aa on aa.an = i.an
                left outer join hos.pttype p on p.pttype = aa.pttype
                left outer join hos.ipt_pttype pi on pi.an = i.an and pi.claim_code is null
                and pi.pttype in("o1","o2","o3","o4","o5","20","l1","l2","l3","l4","l5","l6","l7","21")
                left outer join hos.ipt_pttype px on px.an = i.an and px.pttype in("a7","14","15","34","35","37") 
                left outer join hos.ward w on w.ward = i.ward
                left outer join hos.ptnote pt on pt.hn =(select hn from hos.ptnote where note_staff in ("joy","toob","rung1234","จารุชา","เยี่ยมรัตน์","kanjana","Justeyely","Saranya","ARUNEE","jariya")
                and hn=i.hn order by note_datetime desc limit 1)
                left outer join hos.ptnote ptt on ptt.hn =(select hn from hos.ptnote where note_staff in ("joy","toob","rung1234","จารุชา","เยี่ยมรัตน์","kanjana","Justeyely","Saranya","arunee","jariya")
                and hn=i.hn 
                and (select note_datetime from hos.ptnote where note_staff in ("joy","toob","rung1234","จารุชา","เยี่ยมรัตน์","kanjana","Justeyely","Saranya","arunee","jariya")
                and hn=i.hn order by note_datetime desc limit 1) < i.regdate
                order by note_datetime desc limit 1)
                where aa.dchdate is null
                group by w.name
        ');

        $data_ogclgo = DB::connection('mysql3')->select('
            select month(i.dchdate) as months,count(distinct i.an) as cAN,count(distinct po.an) as poan,count(distinct pi.an) as pian

            from hos.ipt i 
            left outer join hos.doctor d on d.code = i.admdoctor
                left outer join hos.an_stat aa on aa.an = i.an
                left outer join hos.pttype p on p.pttype = aa.pttype
                left outer join hos.ipt_pttype pi on pi.an = i.an and pi.claim_code is null
                left outer join hos.ipt_pttype po on po.an = i.an and po.claim_code is not null                
                where aa.dchdate between "'.$datestart.'" and "'.$dateend.'"
                and aa.pttype in("o1","o2","o3","o4","o5","20","l1","l2","l3","l4","l5","l6","l7","21")
                group by month(i.dchdate)
                order by year(i.dchdate),month(i.dchdate)
                ');

        return view('ward.check_ward', $data,[
            'data_ward'   => $data_ward,
            'data_ogclgo'   => $data_ogclgo
        ]);
    }

    public function check_warddetail(Request $request,$id)
    { 
        $data['users'] = User::get();
        
        $data_warddetatil = DB::connection('mysql3')->select('   
            select a.hn,a.an,concat(p.pname,p.fname," ",p.lname) as fullname,p.cid,a.pdx,a.regdate,a.dchdate,a.admdate,round(a.income) as Aincome,round(a.inc08,2) as inc08,
            (select concat(plain_text, ""  ,note_datetime," ",note_staff) from hos.ptnote where note_staff in ("joy","toob","rung1234","จารุชา"
            ,"เยี่ยมรัตน์","kanjana","Justeyely","Saranya","arunee","jariya")
            and hn=i.hn order by note_datetime desc limit 1) as nn,r.name as abname
            ,i.pttype AS "HOSpttype"
            ,cs.check_sit_subinscl AS "spsch"
            ,ip.hospmain
            ,group_concat(distinct cs.check_sit_hmain,"<br/>",cs.check_sit_startdate) AS "datestart"
            from hos.ipt i
            left outer join hos.an_stat a on a.an = i.an
            left outer join hos.patient p on p.hn = i.hn
            left outer join hos.doctor d on d.code = i.dch_doctor
            left outer join hos.ward w on w.ward = i.ward
            left outer join hos.roomno r on r.an = i.an
            left outer join hos.ipt_pttype ip on ip.an = i.an
            left join money_bn.check_sit cs on cs.check_sit_vn = i.vn
            where a.dchdate is null
            and w.ward = "'.$id.'" group by i.an
        ');

        

        return view('ward.check_warddetail', $data,[
            'data_warddetatil'   => $data_warddetatil
        ]);
    }

    public function check_wardnonote(Request $request,$id)
    { 
        $data['users'] = User::get();
        
        $data_warddetatil = DB::connection('mysql3')->select('    
            SELECT a.hn,a.an,concat(p.pname,p.fname," ",p.lname) as fullname,p.cid
            ,i.pttype AS HOSpttype
            ,ifnull(cs.check_sit_subinscl,c1.check_sit_subinscl) AS spsch
            ,ip.hospmain
                ,ifnull(group_concat(distinct cs.check_sit_hmain,"<br/>",cs.check_sit_startdate),group_concat(distinct c1.check_sit_hmain,"<br/>",c1.check_sit_startdate)) AS hosstartdate,a.pdx,a.regdate,a.dchdate,a.admdate,round(a.income) as Aincome,round(a.inc08,2) as inc08,
            (select concat(plain_text, ""  ,note_datetime," ",note_staff) from hos.ptnote where note_staff in ("joy","toob","rung1234","จารุชา","เยี่ยมรัตน์","kanjana","Justeyely","Saranya","arunee","jariya")
            and hn=i.hn order by note_datetime desc limit 1) as nn,r.name as abname
            
            from hos.ipt i
            left outer join hos.an_stat a on a.an = i.an
            left outer join hos.patient p on p.hn = i.hn
            left outer join hos.doctor d on d.code = i.dch_doctor
            left outer join hos.ward w on w.ward = i.ward
            left outer join hos.roomno r on r.an = i.an
            left outer join hos.ptnote pt on pt.hn =(select hn from hos.ptnote where note_staff in ("joy","toob","rung1234","จารุชา","เยี่ยมรัตน์","kanjana","Justeyely","Saranya","arunee","jariya")
            and hn=i.hn order by note_datetime desc limit 1)
            left outer join hos.ipt_pttype ip on ip.an = i.an
            left join money_bn.check_sit cs on cs.check_sit_vn = i.vn
            left join money_bn.check_sit c1 on c1.check_sit_an = i.an
            where a.dchdate is null
            and (select note_datetime from hos.ptnote where note_staff in ("joy","toob","rung1234","จารุชา","เยี่ยมรัตน์","kanjana","Justeyely","Saranya","arunee","jariya")
            and hn=i.hn  order by note_datetime desc limit 1) < a.regdate
            and w.ward = "'.$id.'" group by i.an
            union
            select a.hn,a.an,concat(p.pname,p.fname," ",p.lname) as name,p.cid,i.pttype AS HOSpttype
                    ,ifnull(cs.check_sit_subinscl,c1.check_sit_subinscl) AS spsch
            ,ip.hospmain
                ,ifnull(group_concat(distinct cs.check_sit_hmain,"<br/>",cs.check_sit_startdate),group_concat(distinct c1.check_sit_hmain,"<br/>",c1.check_sit_startdate)) AS hosstartdate,a.pdx,a.regdate,a.dchdate,a.admdate,round(a.income),round(a.inc08,2),
            (select concat(plain_text, ""  ,note_datetime," ",note_staff) from hos.ptnote where note_staff in ("joy","toob","rung1234","จารุชา","เยี่ยมรัตน์","kanjana","Justeyely","Saranya","arunee","jariya")
            and hn=i.hn order by note_datetime desc limit 1),r.name

            from hos.ipt i
            left outer join hos.an_stat a on a.an = i.an
            left outer join hos.patient p on p.hn = i.hn
            left outer join hos.doctor d on d.code = i.dch_doctor
            left outer join hos.ward w on w.ward = i.ward
            left outer join hos.roomno r on r.an = i.an
            left outer join hos.ptnote pt on pt.hn =(select hn from hos.ptnote where note_staff in ("joy","toob","rung1234","จารุชา","เยี่ยมรัตน์","kanjana","Justeyely","Saranya","arunee","jariya")
            and hn=i.hn order by note_datetime desc limit 1)
            left outer join hos.ipt_pttype ip on ip.an = i.an
            left join money_bn.check_sit cs on cs.check_sit_vn = i.vn
            left join money_bn.check_sit c1 on c1.check_sit_an = i.an
            where a.dchdate is null
            and pt.hn is null
            and w.ward = "'.$id.'" group by i.an  

        ');

        

        return view('ward.check_wardnonote', $data,[
            'data_warddetatil'   => $data_warddetatil
        ]);
    }

    public function check_wardnoclaim(Request $request,$id)
    { 
        $data['users'] = User::get();
        
        $data_wardsss = DB::connection('mysql3')->select('    
        select a.hn,a.an,concat(p.pname,p.fname," ",p.lname) as fullname ,p.cid,pi.claim_code
        ,i.pttype AS HOSpttype
                ,cs.check_sit_subinscl AS spsch
       ,ip.hospmain
              ,group_concat(distinct cs.check_sit_hmain,"<br/>",cs.check_sit_startdate) AS hosstartdate,a.pdx,a.regdate,a.dchdate,a.admdate,round(a.income) as Aincome ,round(a.inc08,2) as inc08,
       (select concat(plain_text,  ""  ,note_datetime," ",note_staff) from hos.ptnote where note_staff in ("joy","toob","rung1234","จารุชา","เยี่ยมรัตน์","kanjana","Justeyely","Saranya","arunee","jariya")
       and hn=i.hn order by note_datetime desc limit 1) as nn,r.name as abname 
         
       from hos.ipt i
       left outer join hos.an_stat a on a.an = i.an
       left outer join hos.patient p on p.hn = i.hn
       left outer join hos.doctor d on d.code = i.dch_doctor
       left outer join hos.ward w on w.ward = i.ward
       left outer join hos.roomno r on r.an = i.an
       left outer join hos.ptnote pt on pt.hn =(select hn from hos.ptnote where note_staff in ("joy","toob","rung1234","จารุชา","เยี่ยมรัตน์","kanjana","Justeyely","Saranya","arunee","jariya")
       and hn=i.hn order by note_datetime desc limit 1)
       left outer join hos.ipt_pttype ip on ip.an = i.an
       left join money_bn.check_sit cs on cs.check_sit_vn = i.an
       left outer join hos.ipt_pttype pi on pi.an = i.an 
       where a.dchdate is null
       
       and a.pttype in("o1","o2","o3","o4","o5","20","l1","l2","l3","l4","l5","l6","l7","21")
       and pi.claim_code is null
       and w.ward = "'.$id.'" group by i.an
       union
       select a.hn,a.an,concat(p.pname,p.fname," ",p.lname) as name,p.cid,pi.claim_code
       ,i.pttype AS HOSpttype
                ,cs.check_sit_subinscl AS spsch
       ,ip.hospmain
              ,group_concat(distinct "<br/>",cs.check_sit_hmain,"<br/>",cs.check_sit_startdate) AS hosstartdate,a.pdx,a.regdate,a.dchdate,a.admdate,round(a.income),round(a.inc08,2),
       (select concat(plain_text,  ""  ,note_datetime," ",note_staff) from hos.ptnote where note_staff in ("joy","toob","rung1234","จารุชา","เยี่ยมรัตน์","kanjana","Justeyely","Saranya","arunee","jariya")
       and hn=i.hn order by note_datetime desc limit 1),r.name
       
       from hos.ipt i
       left outer join hos.an_stat a on a.an = i.an
       left outer join hos.patient p on p.hn = i.hn
       left outer join hos.doctor d on d.code = i.dch_doctor
       left outer join hos.ward w on w.ward = i.ward
       left outer join hos.roomno r on r.an = i.an
       left outer join hos.ptnote pt on pt.hn =(select hn from hos.ptnote where note_staff in ("joy","toob","rung1234","จารุชา","เยี่ยมรัตน์","kanjana","Justeyely","Saranya","arunee","jariya")
       and hn=i.hn order by note_datetime desc limit 1)
       left outer join hos.ipt_pttype ip on ip.an = i.an
       left join money_bn.check_sit cs on cs.check_sit_vn = i.an
       left outer join hos.ipt_pttype pi on pi.an = i.an 
       
       where a.dchdate is null
       and a.pttype in("o1","o2","o3","o4","o5","20","l1","l2","l3","l4","l5","l6","l7","21")
       and pi.claim_code is null
        and pt.hn is null
        and w.ward = "'.$id.'" group by i.an
 
        ');        

        return view('ward.check_wardnoclaim', $data,[
            'data_wardsss'   => $data_wardsss
        ]);
    }

    public function check_wardsss(Request $request,$id)
    { 
        $data['users'] = User::get();
        
        $data_wardsss = DB::connection('mysql3')->select('    
        select a.hn,a.an,concat(p.pname,p.fname," ",p.lname) as fullname ,p.cid,pi.claim_code
        ,i.pttype AS HOSpttype
                ,cs.check_sit_subinscl AS spsch
       ,ip.hospmain
              ,group_concat(distinct cs.check_sit_hmain,"<br/>",cs.check_sit_startdate) AS hosstartdate,a.pdx,a.regdate,a.dchdate,a.admdate,round(a.income) as Aincome ,round(a.inc08,2) as inc08,
       (select concat(plain_text,  ""  ,note_datetime," ",note_staff) from hos.ptnote where note_staff in ("joy","toob","rung1234","จารุชา","เยี่ยมรัตน์","kanjana","Justeyely","Saranya","arunee","jariya")
       and hn=i.hn order by note_datetime desc limit 1) as nn,r.name as abname 
         
       from hos.ipt i
       left outer join hos.an_stat a on a.an = i.an
       left outer join hos.patient p on p.hn = i.hn
       left outer join hos.doctor d on d.code = i.dch_doctor
       left outer join hos.ward w on w.ward = i.ward
       left outer join hos.roomno r on r.an = i.an
       left outer join hos.ptnote pt on pt.hn =(select hn from hos.ptnote where note_staff in ("joy","toob","rung1234","จารุชา","เยี่ยมรัตน์","kanjana","Justeyely","Saranya","arunee","jariya")
       and hn=i.hn order by note_datetime desc limit 1)
       left outer join hos.ipt_pttype ip on ip.an = i.an
       left join money_bn.check_sit cs on cs.check_sit_vn = i.an
       left outer join hos.ipt_pttype pi on pi.an = i.an 
       where a.dchdate is null
       
       and a.pttype in("a7","14","15","34","35","37")
       and pi.claim_code is null
       and w.ward = "'.$id.'" group by i.an
       union
       select a.hn,a.an,concat(p.pname,p.fname," ",p.lname) as name,p.cid,pi.claim_code
       ,i.pttype AS HOSpttype
                ,cs.check_sit_subinscl AS spsch
       ,ip.hospmain
              ,group_concat(distinct "<br/>",cs.check_sit_hmain,"<br/>",cs.check_sit_startdate) AS hosstartdate,a.pdx,a.regdate,a.dchdate,a.admdate,round(a.income),round(a.inc08,2),
       (select concat(plain_text,  ""  ,note_datetime," ",note_staff) from hos.ptnote where note_staff in ("joy","toob","rung1234","จารุชา","เยี่ยมรัตน์","kanjana","Justeyely","Saranya","arunee","jariya")
       and hn=i.hn order by note_datetime desc limit 1),r.name
       
       from hos.ipt i
       left outer join hos.an_stat a on a.an = i.an
       left outer join hos.patient p on p.hn = i.hn
       left outer join hos.doctor d on d.code = i.dch_doctor
       left outer join hos.ward w on w.ward = i.ward
       left outer join hos.roomno r on r.an = i.an
       left outer join hos.ptnote pt on pt.hn =(select hn from hos.ptnote where note_staff in ("joy","toob","rung1234","จารุชา","เยี่ยมรัตน์","kanjana","Justeyely","Saranya","arunee","jariya")
       and hn=i.hn order by note_datetime desc limit 1)
       left outer join hos.ipt_pttype ip on ip.an = i.an
       left join money_bn.check_sit cs on cs.check_sit_vn = i.an
       left outer join hos.ipt_pttype pi on pi.an = i.an 
       
       where a.dchdate is null
       and a.pttype in("a7","14","15","34","35","37")
       and pt.hn is null
       and w.ward = "'.$id.'" group by i.an  

        ');        

        return view('ward.check_wardsss', $data,[
            'data_wardsss'   => $data_wardsss
        ]);
    }
    
}
