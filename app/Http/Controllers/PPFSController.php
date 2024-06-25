<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Http;
use SoapClient;
use File;
use SplFileObject;
use Arr;
use Storage;
use App\Models\Six_temp;
use App\Models\Check_sit;
use App\Models\Ssop_stm;
use App\Models\Ssop_session;
use App\Models\Ssop_opdx;
use App\Models\Pang_stamp_temp;
use App\Models\Ssop_token;
use App\Models\Ssop_opservices;
use App\Models\Ssop_dispenseditems;
use App\Models\Ssop_dispensing;
use App\Models\Ssop_billtran;
use App\Models\Ssop_billitems;
use App\Models\Claim_ssop;
use App\Models\Claim_sixteen_dru;
use App\Models\claim_sixteen_adp;
use App\Models\Claim_sixteen_cha;  
use App\Models\Claim_sixteen_cht;
use App\Models\Claim_sixteen_oop;
use App\Models\Claim_sixteen_odx;
use App\Models\Claim_sixteen_orf;
use App\Models\Claim_sixteen_pat;
use App\Models\Claim_sixteen_ins;
use App\Models\Claim_temp_ssop;
use App\Models\Claim_sixteen_opd;

use App\Models\D_cha;
use App\Models\D_lvd;
use App\Models\D_odx;
use App\Models\D_oop;
use App\Models\D_opd;
use App\Models\D_orf;
use App\Models\D_pat;
use App\Models\d_adp;
use App\Models\D_aer;
use App\Models\D_cht;
use App\Models\D_dru;
use App\Models\D_idx;
use App\Models\D_ins;
use App\Models\D_iop;
use App\Models\D_ipd;
use App\Models\D_irf;

class PPFSController extends Controller
{
    public function screening_cigarette(Request $request)
    {
        $date = date('Y-m-d');
       
        $countalls_data = DB::connection('mysql3')->select('
            SELECT COUNT(o.vn) as VN
            FROM ovst o
            LEFT OUTER JOIN ovst_queue_server_authen oq on oq.vn=o.vn
            LEFT OUTER JOIN kskdepartment sk on sk.depcode=o.main_dep
            LEFT OUTER JOIN patient p on p.hn=o.hn
            WHERE o.vstdate = CURDATE()
            ORDER BY o.vsttime
        ');
 
        return view('ppsf.screening_cigarette',[
            'countalls_data'       => $countalls_data,           
        ] );
    }
    public function screening_spirits(Request $request)
    {
        $date = date('Y-m-d');
       
        $data_spirits = DB::connection('mysql3')->select('
                select p.person_id,p.patient_hn,p.cid,concat(p.pname,p.fname,"",p.lname) ptname
                    ,thaiage(p.birthdate,"'.$date.'") age
                    ,p.house_regist_type_id typearea,h.address,v.village_moo moo,v.village_name
                    ,cast(group_concat(distinct if(t.pp_special_code like"1B6%","Y",null)) as char(1))  Drink
                    ,cast(group_concat(distinct if(t.pp_special_code="1B600","Y",null)) as char(1))  Social 
                    ,cast(group_concat(distinct if(t.pp_special_code="1B601","Y",null)) as char(1))  Home 
                    ,cast(group_concat(distinct if(t.pp_special_code in("1B602","1B603","1B604"),"Y",null)) as char(1))  Bed 
                    ,group_concat(distinct if(t.pp_special_code in ("1B600","1B601","1B602","1B603","1B604"),t.pp_special_code,null) order by pp.entry_datetime desc) Code
                    ,group_concat(distinct if(t.pp_special_code in ("1B600","1B601","1B602","1B603","1B604"),t.pp_special_type_name,null) order by pp.entry_datetime desc) Cname
                    ,group_concat(distinct if(t.pp_special_code in ("1B600","1B601","1B602","1B603","1B604"),ce2be(pp.entry_datetime),null) order by pp.entry_datetime desc) Vstdate
                    ,cast(group_concat(distinct if(t.pp_special_code ="1B602","Y",null)) as char(1))  low
                    ,cast(group_concat(distinct if(t.pp_special_code ="1B610","Y",null)) as char(1)) be
                    ,cast(group_concat(distinct if(t.pp_special_code="1B603","Y",null)) as char(1))  mid
                    ,cast(group_concat(distinct if(t.pp_special_code ="1B611","Y",null)) as char(1)) co
                    ,cast(group_concat(distinct if(t.pp_special_code="1B604","Y",null)) as char(1))  Height 
                    ,cast(group_concat(distinct if(t.pp_special_code ="1B611","Y",null)) as char(1)) cco
                    ,cast(group_concat(distinct if(t.pp_special_code ="1B612","Y",null)) as char(1)) re
                    from person p
                    LEFT JOIN village v on v.village_id=p.village_id
                    LEFT JOIN house h on h.house_id=p.house_id
                    left join pp_special pp on pp.hn=p.patient_hn and pp.entry_datetime between "'.$date.'" and "'.$date.'"
                    left join pp_special_type t on t.pp_special_type_id=pp.pp_special_type_id
                    where p.nationality="99" and TIMESTAMPDIFF(YEAR,p.birthdate,"'.$date.'")>14
                    and p.house_regist_type_id in(1,3) and p.person_discharge_id=9
                    group by p.person_id
                    order by v.village_moo,p.birthdate
            
        ');
 
        return view('ppsf.screening_spirits',[
            'data_spirits'       => $data_spirits,           
        ] );
    }
    public function anc_14001(Request $request)
    { 
        $datestart = $request->startdate;
        $dateend = $request->enddate;
        $anc14001_ = DB::connection('mysql3')->select('   
            SELECT
                    o.vn,o.hn,o.an,pt.cid,ptname(o.hn,1) fullname
                    ,ce2be(o.vstdate) vstdate,date_format(o.vsttime,"%T") vsttime 
                    ,ptt.pttype inscl,ptt.name pttypename
                    ,ac.authencode,v.pdx,group_concat(d.icode," ",d.name) drug
                    ,sum(oo.sum_price) money_hosxp,ptt.paidst
                    ,v.discount_money,v.rcpt_money
                    ,v.income-v.discount_money-v.rcpt_money debit
                    ,ifnull(eclaim_money,0) money_eclaim
                    ,ifnull(r.income,0) money_rep
                    ,ifnull(n.income,0) money_invoice
                    ,v.rcpno_list rcpno
                    from ovst o
                    join vn_stat v on v.vn=o.vn
                    join patient pt on pt.hn=o.hn
                    join opitemrece oo on oo.vn=o.vn
                    join drugitems d on d.icode=oo.icode 
                    left join test.tmpeclaim e on e.vn=o.vn
                    left join test.tmprep r on r.vn=o.vn
                    left join test.tmpnhso n on n.vn=o.vn
                    left join pttype ptt on ptt.pttype=o.pttype
                    left join rcmdb.authencode ac on ac.vn=o.vn
                    where  o.vstdate BETWEEN "'.$datestart.'" AND "'.$dateend.'" 
                    and (o.an="" or o.an is null)
                    and v.age_y between 13 and 45 and pt.nationality="99" and pt.sex=2 
                    and  d.did in ("202030120137819920381422","100488000004203120381169","100489000004320121881267","100489000004320121881267"
                    ,"100488000004203121781674","100488000004203120381442","100488000004203120381013","100488000004203121781144"
                    ,"100488000004203120381053","100488000004203120381144","100488000004203120381271","100488000004203120381341"
                    ,"100488000004203120381626","100488000004203121881626","100488000004203121781144","100488000004203121881442"
                    ,"100488000004203121881553","100489000004192121881506","100489000004320120381122","100489000004320120381506"
                    ,"100489000004203120381555","100489000004203120381084","100489000004203120381144","100489000004203120381619"
                    ,"100489000004203120381477","100489000004203120381544","100489000004203120381546")
                    group by o.vn;
        ');
        Six_temp::truncate();
        foreach ($anc14001_ as $key => $value) {           
            $add= new Six_temp();
            $add->hn = $value->hn ;
            $add->vn = $value->vn; 
            $add->an = $value->an; 
            $add->cid = $value->cid;
            $add->fullname = $value->fullname; 
            $add->inscl = $value->inscl;
            $add->pdx = $value->pdx;
            $add->drug = $value->drug; 
            $add->money_hosxp = $value->money_hosxp; 
            $add->paidst = $value->paidst; 
            $add->discount_money = $value->discount_money; 
            $add->rcpt_money = $value->rcpt_money; 
            $add->debit = $value->debit; 
            $add->save();
        }
        $anc14001 = DB::connection('mysql7')->select('   
            SELECT * FROM six_temp 
        ');
        // $opd = DB::connection('mysql7')->select('   
        //     SELECT * FROM claim_sixteen_opd 
        // '); 
        // $odx = DB::connection('mysql7')->select('   
        //     SELECT * FROM Claim_sixteen_odx 
        // ');
        // $oop = DB::connection('mysql7')->select('   
        //     SELECT * FROM claim_sixteen_oop 
        // ');
        
        return view('claim.anc_14001',[
            'anc14001'  => $anc14001,
            'start'     => $datestart,
            'end'       => $dateend, 
            // 'opd'       => $opd, 
            // 'odx'       => $odx,
            // 'oop'       => $oop,           
        ] );
       
    }
    public function anc_14001_pull(Request $request)
    { 
        $datestart = $request->startdate;
        $dateend = $request->enddate;
        $anc14001 = DB::connection('mysql7')->select('   
            SELECT * FROM six_temp 
        ');
        $ins = DB::connection('mysql3')->select('   
                SELECT v.hn HN
                ,if(i.an is null,p.hipdata_code,pp.hipdata_code) INSCL
                ,if(i.an is null,p.pcode,pp.pcode) SUBTYPE
                ,v.cid CID
                ,DATE_FORMAT(if(i.an is null,v.pttype_begin,ap.begin_date), "%Y%m%d")  DATEIN
                ,DATE_FORMAT(if(i.an is null,v.pttype_expire,ap.expire_date), "%Y%m%d")   DATEEXP
                ,if(i.an is null,v.hospmain,ap.hospmain) HOSPMAIN
                ,if(i.an is null,v.hospsub,ap.hospsub) HOSPSUB
                ,"" as GOVCODE
                ,"" as GOVNAME
                ,ifnull(if(i.an is null,vp.claim_code,ap.claim_code),r.sss_approval_code) PERMITNO
                ,"" as DOCNO
                ,"" as OWNRPID 
                ,"" as OWNRNAME
                ,i.an AN
                ,v.vn SEQ
                ,"" as SUBINSCL 
                ,"" as RELINSCL
                ,"" as HTYPE
                from vn_stat v
                LEFT JOIN pttype p on p.pttype = v.pttype
                LEFT JOIN ipt i on i.vn = v.vn 
                LEFT JOIN pttype pp on pp.pttype = i.pttype
                left join ipt_pttype ap on ap.an = i.an
                left join visit_pttype vp on vp.vn = v.vn
                LEFT JOIN rcpt_debt r on r.vn = v.vn
                left join patient px on px.hn = v.hn
                left join claim.six_temp st on st.vn = v.vn
                where st.status="PULL";
        ');
        Claim_sixteen_ins::truncate();
        foreach ($ins as $key => $value2) {           
            $add2= new Claim_sixteen_ins();
            $add2->HN = $value2->HN ;
            $add2->INSCL = $value2->INSCL; 
            $add2->SUBTYPE = $value2->SUBTYPE; 
            $add2->CID = $value2->CID;
            $add2->DATEIN = $value2->DATEIN;
            $add2->DATEEXP = $value2->DATEEXP;
            $add2->HOSPMAIN = $value2->HOSPMAIN;
            $add2->HOSPSUB = $value2->HOSPSUB;
            $add2->GOVCODE = $value2->GOVCODE;
            $add2->GOVNAME = $value2->GOVNAME;
            $add2->PERMITNO = $value2->PERMITNO;
            $add2->DOCNO = $value2->DOCNO;
            $add2->OWNRPID = $value2->OWNRPID;
            $add2->OWNRNAME = $value2->OWNRNAME;
            $add2->AN = $value2->AN;
            $add2->SEQ = $value2->SEQ;
            $add2->SUBINSCL = $value2->SUBINSCL;
            $add2->RELINSCL = $value2->RELINSCL;
            $add2->HTYPE = $value2->HTYPE;
            $add2->save();
        }
        $opd_ = DB::connection('mysql3')->select('   
            SELECT v.hn HN
            ,v.spclty CLINIC
            ,DATE_FORMAT(v.vstdate, "%Y%m%d") DATEOPD
            ,concat(substr(o.vsttime,1,2),substr(o.vsttime,4,2)) TIMEOPD
            ,v.vn SEQ 
            ,"1" UUC 
            from vn_stat v
            LEFT JOIN ovst o on o.vn = v.vn
            LEFT JOIN pttype p on p.pttype = v.pttype
            LEFT JOIN ipt i on i.vn = v.vn 
            LEFT JOIN patient pt on pt.hn = v.hn
            left join claim.six_temp st on st.vn = v.vn
            where st.status="PULL";
        ');
        Claim_sixteen_opd::truncate();
        foreach ($opd_ as $key => $value) {           
            $add= new Claim_sixteen_opd();
            $add->HN = $value->HN ;
            $add->CLINIC = $value->CLINIC; 
            $add->DATEOPD = $value->DATEOPD; 
            $add->TIMEOPD = $value->TIMEOPD;
            $add->SEQ = $value->SEQ;
            $add->UUC = $value->UUC;
            $add->save();
        }       
        $pat_ = DB::connection('mysql3')->select('   
            SELECT v.hcode HCODE
                ,v.hn HN
                ,pt.chwpart CHANGWAT
                ,pt.amppart AMPHUR
                ,DATE_FORMAT(pt.birthday, "%Y%m%d") DOB
                ,pt.sex SEX
                ,pt.marrystatus MARRIAGE 
                ,pt.occupation OCCUPA
                ,lpad(pt.nationality,3,0) NATION
                ,pt.cid PERSON_ID
                ,concat(pt.fname," ",pt.lname,",",pt.pname) NAMEPAT
                ,pt.pname TITLE
                ,pt.fname FNAME 
                ,pt.lname LNAME
                ,"1" IDTYPE
                ,v.vstdate 
                from vn_stat v
                LEFT JOIN hos.pttype p on p.pttype = v.pttype
                LEFT JOIN hos.ipt i on i.vn = v.vn 
                LEFT JOIN hos.patient pt on pt.hn = v.hn
                LEFT JOIN claim.six_temp st on st.vn = v.vn
                where st.status="PULL";
        ');
        Claim_sixteen_pat::truncate();
        foreach ($pat_ as $key => $value3) {           
            $add3= new Claim_sixteen_pat();
            $add3->HCODE = $value3->HCODE ;
            $add3->HN = $value3->HN; 
            $add3->CHANGWAT = $value3->CHANGWAT; 
            $add3->AMPHUR = $value3->AMPHUR;
            $add3->DOB = $value3->DOB;
            $add3->SEX = $value3->SEX;
            $add3->MARRIAGE = $value3->MARRIAGE;
            $add3->OCCUPA = $value3->OCCUPA;
            $add3->NATION = $value3->NATION;
            $add3->PERSON_ID = $value3->PERSON_ID;
            $add3->NAMEPAT = $value3->NAMEPAT;
            $add3->TITLE = $value3->TITLE;
            $add3->FNAME = $value3->FNAME;
            $add3->LNAME = $value3->LNAME; 
            $add3->IDTYPE = $value3->IDTYPE; 
            $add3->save();
        }
        $orf_ = DB::connection('mysql3')->select('   
                SELECT v.hn HN
                ,DATE_FORMAT(v.vstdate, "%Y%m%d") DATEOPD
                ,v.spclty CLINIC
                ,ifnull(r1.refer_hospcode,r2.refer_hospcode) REFER
                ,"0100" REFERTYPE
                ,v.vn SEQ
                ,v.vstdate 
                from hos.vn_stat v
                LEFT JOIN hos.pttype p on p.pttype = v.pttype
                LEFT JOIN hos.referin r1 on r1.vn = v.vn 
                LEFT JOIN hos.referout r2 on r2.vn = v.vn 
                left join claim.six_temp st on st.vn = v.vn
                where st.status="PULL"
                and (r1.vn is not null or r2.vn is not null);
        ');
        Claim_sixteen_orf::truncate();
        foreach ($orf_ as $key => $value4) {           
            $add4= new Claim_sixteen_orf(); 
            $add4->HN = $value4->HN; 
            $add4->DATEOPD = $value4->DATEOPD; 
            $add4->CLINIC = $value4->CLINIC;
            $add4->REFER = $value4->REFER;
            $add4->REFERTYPE = $value4->REFERTYPE;
            $add4->SEQ = $value4->SEQ; 
            $add4->save();
        }
        $odx_ = DB::connection('mysql3')->select('   
                SELECT v.hn HN
                ,DATE_FORMAT(v.vstdate,"%Y%m%d") DATEDX
                ,v.spclty CLINIC
                ,o.icd10 DIAG
                ,o.diagtype DXTYPE
                ,if(d.licenseno=" ","-99999",d.licenseno) DRDX
                ,v.cid PERSON_ID 
                ,v.vn SEQ
                ,v.vstdate 
                from hos.vn_stat v
                LEFT JOIN hos.ovstdiag o on o.vn = v.vn
                LEFT JOIN hos.doctor d on d.`code` = o.doctor  
                LEFT JOIN claim.six_temp st on st.vn = v.vn
                where st.status="PULL";
        '); 
        Claim_sixteen_odx::truncate();
        foreach ($odx_ as $key => $value5) {           
            $add5 = new Claim_sixteen_odx(); 
            $add5->HN = $value5->HN; 
            $add5->DATEDX = $value5->DATEDX; 
            $add5->CLINIC = $value5->CLINIC;
            $add5->DIAG = $value5->DIAG;
            $add5->DXTYPE = $value5->DXTYPE;
            $add5->DRDX = $value5->DRDX;
            $add5->PERSON_ID = $value5->PERSON_ID; 
            $add5->SEQ = $value5->SEQ; 
            $add5->save();
        }
        $oop_ = DB::connection('mysql3')->select('   
                SELECT v.hn HN
                ,DATE_FORMAT(v.vstdate,"%Y%m%d") DATEOPD
                ,v.spclty CLINIC
                ,o.icd10 OPER
                ,if(d.licenseno=" ","-99999",d.licenseno) DROPID
                ,pt.cid PERSON_ID 
                ,v.vn SEQ
                ,v.vstdate 
                from hos.vn_stat v
                LEFT JOIN hos.ovstdiag o on o.vn = v.vn
                LEFT JOIN hos.patient pt on v.hn=pt.hn
                LEFT JOIN hos.doctor d on d.code = o.doctor
                LEFT JOIN claim.six_temp st on st.vn = v.vn
                where st.status="PULL";
        ');
        Claim_sixteen_oop::truncate();
        foreach ($oop_ as $key => $value6) {           
            $add6 = new Claim_sixteen_oop(); 
            $add6->HN = $value6->HN; 
            $add6->DATEOPD = $value6->DATEOPD; 
            $add6->CLINIC = $value6->CLINIC;
            $add6->OPER = $value6->OPER;
            $add6->DROPID = $value6->DROPID;
            $add6->PERSON_ID = $value6->PERSON_ID; 
            $add6->SEQ = $value6->SEQ; 
            $add6->save();
        }
        $cht_ = DB::connection('mysql3')->select('   
                SELECT v.hn HN
                ,v.an AN
                ,DATE_FORMAT(if(a.an is null,v.vstdate,a.dchdate),"%Y%m%d") DATE
                ,round(if(a.an is null,vv.income,a.income),2) TOTAL
                ,round(if(a.an is null,vv.paid_money,a.paid_money),2) PAID
                ,if(vv.paid_money >"0" or a.paid_money >"0","10",pt.pcode) PTTYPE
                ,pp.cid PERSON_ID  
                ,v.vn SEQ
                ,v.vstdate 
                from hos.ovst v
                LEFT JOIN hos.vn_stat vv on vv.vn = v.vn
                LEFT JOIN hos.an_stat a on a.an = v.an
                LEFT JOIN hos.patient pp on pp.hn = v.hn
                LEFT JOIN hos.pttype pt on pt.pttype = vv.pttype or pt.pttype=a.pttype
                LEFT JOIN hos.pttype p on p.pttype = a.pttype
                LEFT JOIN claim.six_temp st on st.vn = v.vn
                where st.status="PULL";
        ');
        Claim_sixteen_cht::truncate();
        foreach ($cht_ as $key => $value7) {           
            $add7 = new Claim_sixteen_cht(); 
            $add7->HN = $value7->HN; 
            $add7->AN = $value7->AN;
            $add7->DATE = $value7->DATE; 
            $add7->TOTAL = $value7->TOTAL;
            $add7->PAID = $value7->PAID;
            $add7->PTTYPE = $value7->PTTYPE;
            $add7->PERSON_ID = $value7->PERSON_ID; 
            $add7->SEQ = $value7->SEQ; 
            $add7->save();
        }
        $cha_ = DB::connection('mysql3')->select('   
             
            SELECT v.hn HN
                ,if(ip.an is null,"",ip.an) AN 
                ,if(ip.an is null,DATE_FORMAT(v.vstdate,"%Y%m%d"),DATE_FORMAT(ip.dchdate,"%Y%m%d")) DATE
                ,if(v.paidst in("01","03"),dx.chrgitem_code2,dc.chrgitem_code1) CHRGITEM
                ,round(sum(v.sum_price),2) AMOUNT
                ,p.cid PERSON_ID 
                ,ifnull(v.vn,v.an) SEQ
                from opitemrece v
                LEFT JOIN vn_stat vv on vv.vn = v.vn
                LEFT JOIN patient p on p.hn = v.hn
                LEFT JOIN ipt ip on ip.an = v.an
                LEFT JOIN income i on v.income=i.income
                LEFT JOIN drg_chrgitem dc on i.drg_chrgitem_id=dc.drg_chrgitem_id 
                LEFT JOIN drg_chrgitem dx on i.drg_chrgitem_id= dx.drg_chrgitem_id 
                LEFT JOIN claim.six_temp st on st.vn = v.vn
                where st.status="PULL"
                group by v.vn,CHRGITEM
                union all
                SELECT v.hn HN
                ,ip.an AN 
                ,if(ip.an is null,DATE_FORMAT(v.vstdate,"%Y%m%d"),DATE_FORMAT(ip.dchdate,"%Y%m%d")) DATE
                ,if(v.paidst in("01","03"),dx.chrgitem_code2,dc.chrgitem_code1) CHRGITEM
                ,round(sum(v.sum_price),2) AMOUNT
                ,p.cid PERSON_ID 
                ,ifnull(v.vn,v.an) SEQ
                from opitemrece v
                LEFT JOIN vn_stat vv on vv.vn = v.vn
                LEFT JOIN patient p on p.hn = v.hn
                LEFT JOIN ipt ip on ip.an = v.an
                LEFT JOIN income i on v.income=i.income
                LEFT JOIN drg_chrgitem dc on i.drg_chrgitem_id=dc.drg_chrgitem_id 
                LEFT JOIN drg_chrgitem dx on i.drg_chrgitem_id= dx.drg_chrgitem_id 
                
                LEFT JOIN claim.six_temp st on st.vn = ip.vn
                where st.status="PULL"
                group by v.an,CHRGITEM;

        ');
        Claim_sixteen_cha::truncate();
        foreach ($cha_ as $key => $value8) {           
            $add8 = new Claim_sixteen_cha(); 
            $add8->HN = $value8->HN; 
            $add8->AN = $value8->AN;
            $add8->DATE = $value8->DATE; 
            $add8->CHRGITEM = $value8->CHRGITEM;
            $add8->AMOUNT = $value8->AMOUNT; 
            $add8->PERSON_ID = $value8->PERSON_ID; 
            $add8->SEQ = $value8->SEQ; 
            $add8->save();
        }
        $adp_ = DB::connection('mysql3')->select('          
                SELECT HN,AN,DATEOPD,TYPE,CODE,sum(QTY) QTY
                        ,RATE,SEQ
                        ," " a1," " a2," " a3," " a4,"0" a5," " a6,"0" a7 ," " a8
                        ," " TMLTCODE
                        ," " STATUS1
                        ," " BI
                        ," " CLINIC
                        ," " ITEMSRC
                        ," " PROVIDER
                        ," " GLAVIDA
                        ," " GA_WEEK
                        ," " DCIP
                        ,"0000-00-00" LMP
                        from (SELECT op.hn HN
                        ,op.an AN
                        ,DATE_FORMAT(op.rxdate,"%Y%m%d") DATEOPD
                        ,n.nhso_adp_type_id TYPE
                        ,n.nhso_adp_code CODE 
                        ,sum(op.QTY) QTY
                        ,round(op.unitprice,2) RATE
                        ,if(op.an is null,op.vn," ") SEQ
                        ," " a1," " a2," " a3," " a4," " a5," " a6," " a7 ," " a8
                        ," " TMLTCODE
                        ," " STATUS1
                        ," " BI
                        ," " CLINIC
                        ," " ITEMSRC
                        ," " PROVIDER
                        ," " GLAVIDA
                        ," " GA_WEEK
                        ," " DCIP
                        ,"0000-00-00" LMP
                        from hos.opitemrece op
                        inner JOIN hos.drugitems n on n.icode = op.icode and n.nhso_adp_code is not null
                        left join hos.ipt i on i.an = op.an
                        AND i.an is not NULL
  
                        LEFT JOIN claim.six_temp st on st.vn = i.vn
                        where st.status="PULL"                    

                        GROUP BY i.vn,n.nhso_adp_code,rate) a 
                        GROUP BY an,CODE,rate
                        UNION
                        SELECT HN,AN,DATEOPD,TYPE,CODE,sum(QTY) QTY,RATE,SEQ," " " " a1," " a2," " a3," " a4,"0" a5," " a6,"0" a7 ," " a8
                        ," "TMLTCODE
                        ," " STATUS1
                        ," " BI
                        ," " CLINIC
                        ," " ITEMSRC
                        ," " PROVIDER
                        ," " GLAVIDA
                        ," " GA_WEEK
                        ," " DCIP
                        ,"0000-00-00" LMP
                        from
                        (SELECT op.hn HN
                        ,op.an AN
                        ,DATE_FORMAT(op.vstdate,"%Y%m%d") DATEOPD
                        ,n.nhso_adp_type_id TYPE
                        ,n.nhso_adp_code CODE 
                        ,sum(op.QTY) QTY
                        ,round(op.unitprice,2) RATE
                        ,if(op.an is null,op.vn," ") SEQ
                        ," " a1," " a2," " a3," " a4,"0" a5,"" a6,"0" a7 ,"" a8
                        ," " TMLTCODE
                        ," " STATUS1
                        ," " BI
                        ," " CLINIC
                        ," " ITEMSRC
                        ," " PROVIDER
                        ," " GLAVIDA
                        ," " GA_WEEK
                        ," " DCIP
                        ,"0000-00-00" LMP
                        from hos.opitemrece op
                        inner JOIN hos.drugitems n on n.icode = op.icode and n.nhso_adp_code is not null
                        left join hos.ipt i on i.an = op.an
                    
                        LEFT JOIN claim.six_temp st on st.vn = op.vn
                        where st.status="PULL"

                        AND i.an is NULL
                        GROUP BY op.vn,n.nhso_adp_code,rate) b 
                        GROUP BY seq,CODE,rate  
        ');
        claim_sixteen_adp::truncate();
        foreach ($adp_ as $key => $value8) {           
            $add8 = new claim_sixteen_adp(); 
            $add8->HN = $value8->HN; 
            $add8->AN = $value8->AN;
            $add8->DATEOPD = $value8->DATEOPD; 
            $add8->TYPE = $value8->TYPE;
            $add8->CODE = $value8->CODE; 
            $add8->QTY = $value8->QTY; 
            $add8->RATE = $value8->RATE; 
            $add8->SEQ = $value8->SEQ; 
            $add8->save();
        }
        // $dru_ = DB::connection('mysql3')->select('   
        //         SELECT vv.hcode HCODE
        //             ,op.hn HN
        //             ,op.an AN
        //             ,vv.spclty CLINIC
        //             ,vv.cid PERSON_ID
        //             ,DATE_FORMAT(op.vstdate,"%Y%m%d") DATE_SERV
        //             ,d.icode DID
        //             ,concat(d.name," ",d.strength," ",d.units) DIDNAME
        //             ,op.qty AMOUNT
        //             ,round(op.unitprice,2) DRUGPRIC
        //             ,"0.00" DRUGCOST
        //             ,d.did DIDSTD
        //             ,d.units UNIT
        //             ,concat(d.packqty,"x",d.units) UNIT_PACK
        //             ,op.vn SEQ
        //             ,oo.presc_reason DRUGREMARK
        //             ," "PA_NO
        //             ," " TOTCOPAY
        //             ,if(op.item_type="H","2","1") USE_STATUS
        //             ," " TOTAL," " a1," "  a2
        //             from hos.opitemrece op
        //             LEFT JOIN hos.drugitems d on d.icode = op.icode
        //             LEFT JOIN hos.vn_stat vv on vv.vn = op.vn
        //             LEFT JOIN hos.ovst_presc_ned oo on oo.vn = op.vn and oo.icode=op.icode
                    
        //             LEFT JOIN claim.six_temp st on st.vn = op.vn
        //             where st.status="PULL"
        //             and d.did is not null 
        //             GROUP BY op.vn,did

        //             UNION all
        //             SELECT pt.hcode HCODE
        //             ,op.hn HN
        //             ,op.an AN
        //             ,ip.spclty CLINIC
        //             ,pt.cid PERSON_ID
        //             ,DATE_FORMAT((op.vstdate),"%Y%m%d") DATE_SERV
        //             ,d.icode DID
        //             ,concat(d.name," ",d.strength," ",d.units) DIDNAME
        //             ,sum(op.qty) AMOUNT
        //             ,round(op.unitprice,2) DRUGPRIC
        //             ,"0.00" DRUGCOST
        //             ,d.did DIDSTD
        //             ,d.units UNIT
        //             ,concat(d.packqty,"x",d.units) UNIT_PACK
        //             ,ifnull(op.vn,op.an) SEQ
        //             ,oo.presc_reason DRUGREMARK
        //             ,"" PA_NO
        //             ,"" TOTCOPAY
        //             ,if(op.item_type="H","2","1") USE_STATUS
        //             ,"" TOTAL," " a1," "  a2
        //             from hos.opitemrece op
        //             LEFT JOIN hos.drugitems d on d.icode = op.icode
        //             LEFT JOIN hos.patient pt  on op.hn = pt.hn
        //             inner JOIN hos.ipt ip on ip.an = op.an
        //             LEFT JOIN hos.ovst_presc_ned oo on oo.vn = op.vn and oo.icode=op.icode

        //             LEFT JOIN claim.six_temp st on st.vn = ip.vn
        //             where st.status="PULL"

        //             and d.did is not null AND op.qty<>"0"
        //             GROUP BY op.an,d.icode,USE_STATUS


        // ');
        // Claim_sixteen_dru::truncate();
        // foreach ($dru_ as $key => $value9) {           
        //     $add9 = new Claim_sixteen_dru(); 
        //     $add9->HCODE = $value9->HCODE; 
        //     $add9->HN = $value9->HN;
        //     $add9->AN = $value9->AN; 
        //     $add9->CLINIC = $value9->CLINIC;
        //     $add9->PERSON_ID = $value9->PERSON_ID;
        //     $add9->DATE_SERV = $value9->DATE_SERV;
        //     $add9->DID = $value9->DID; 
        //     $add9->DIDNAME = $value9->DIDNAME;
        //     $add9->AMOUNT = $value9->AMOUNT; 
        //     $add9->DRUGPRIC = $value9->DRUGPRIC;
        //     $add9->DRUGCOST = $value9->DRUGCOST;
        //     $add9->DIDSTD = $value9->DIDSTD;
        //     $add9->UNIT = $value9->UNIT;
        //     $add9->UNIT_PACK = $value9->UNIT_PACK;
        //     $add9->SEQ = $value9->SEQ;
        //     $add9->DRUGREMARK = $value9->DRUGREMARK;
        //     $add9->PA_NO = $value9->PA_NO;
        //     $add9->TOTCOPAY = $value9->TOTCOPAY;
        //     $add9->USE_STATUS = $value9->USE_STATUS;
        //     // $add9->STATUS1 = $value9->STATUS1;
        //     $add9->TOTAL = $value9->TOTAL;
        //     $add9->a1 = $value9->a1;
        //     $add9->a2 = $value9->a2;
        //     $add9->save();
        // }

        return view('claim.anc_14001',[
            'anc14001'  => $anc14001,
            'start'     => $datestart,
            'end'       => $dateend, 
        ] );
    }

    public function anc_14001_pull2(Request $request)
    {
        $datestart = $request->startdate;
        $dateend = $request->enddate;
        $anc14001 = DB::connection('mysql7')->select('   
            SELECT * FROM six_temp 
        ');
         $dru_ = DB::connection('mysql3')->select('   
                SELECT vv.hcode HCODE
                    ,op.hn HN
                    ,op.an AN
                    ,vv.spclty CLINIC
                    ,vv.cid PERSON_ID
                    ,DATE_FORMAT(op.vstdate,"%Y%m%d") DATE_SERV
                    ,d.icode DID
                    ,concat(d.name," ",d.strength," ",d.units) DIDNAME
                    ,op.qty AMOUNT
                    ,round(op.unitprice,2) DRUGPRIC
                    ,"0.00" DRUGCOST
                    ,d.did DIDSTD
                    ,d.units UNIT
                    ,concat(d.packqty,"x",d.units) UNIT_PACK
                    ,op.vn SEQ
                    ,oo.presc_reason DRUGREMARK
                    ," "PA_NO
                    ," " TOTCOPAY
                    ,if(op.item_type="H","2","1") USE_STATUS
                    ," " TOTAL," " a1," "  a2
                    from hos.opitemrece op
                    LEFT JOIN hos.drugitems d on d.icode = op.icode
                    LEFT JOIN hos.vn_stat vv on vv.vn = op.vn
                    LEFT JOIN hos.ovst_presc_ned oo on oo.vn = op.vn and oo.icode=op.icode
                    
                    LEFT JOIN claim.six_temp st on st.vn = op.vn
                    where st.status="PULL"
                    and d.did is not null 
                    GROUP BY op.vn,did

                    UNION all
                    SELECT pt.hcode HCODE
                    ,op.hn HN
                    ,op.an AN
                    ,ip.spclty CLINIC
                    ,pt.cid PERSON_ID
                    ,DATE_FORMAT((op.vstdate),"%Y%m%d") DATE_SERV
                    ,d.icode DID
                    ,concat(d.name," ",d.strength," ",d.units) DIDNAME
                    ,sum(op.qty) AMOUNT
                    ,round(op.unitprice,2) DRUGPRIC
                    ,"0.00" DRUGCOST
                    ,d.did DIDSTD
                    ,d.units UNIT
                    ,concat(d.packqty,"x",d.units) UNIT_PACK
                    ,ifnull(op.vn,op.an) SEQ
                    ,oo.presc_reason DRUGREMARK
                    ,"" PA_NO
                    ,"" TOTCOPAY
                    ,if(op.item_type="H","2","1") USE_STATUS
                    ,"" TOTAL," " a1," "  a2
                    from hos.opitemrece op
                    LEFT JOIN hos.drugitems d on d.icode = op.icode
                    LEFT JOIN hos.patient pt  on op.hn = pt.hn
                    inner JOIN hos.ipt ip on ip.an = op.an
                    LEFT JOIN hos.ovst_presc_ned oo on oo.vn = op.vn and oo.icode=op.icode

                    LEFT JOIN claim.six_temp st on st.vn = ip.vn
                    where st.status="PULL"
                    and d.did is not null AND op.qty<>"0"
                    GROUP BY op.an,d.icode,USE_STATUS

        ');
        Claim_sixteen_dru::truncate();
        foreach ($dru_ as $key => $value9) {           
            $add9 = new Claim_sixteen_dru(); 
            $add9->HCODE = $value9->HCODE; 
            $add9->HN = $value9->HN;
            $add9->AN = $value9->AN; 
            $add9->CLINIC = $value9->CLINIC;
            $add9->PERSON_ID = $value9->PERSON_ID;
            $add9->DATE_SERV = $value9->DATE_SERV;
            $add9->DID = $value9->DID; 
            $add9->DIDNAME = $value9->DIDNAME;
            $add9->AMOUNT = $value9->AMOUNT; 
            $add9->DRUGPRIC = $value9->DRUGPRIC;
            $add9->DRUGCOST = $value9->DRUGCOST;
            $add9->DIDSTD = $value9->DIDSTD;
            $add9->UNIT = $value9->UNIT;

            $add9->UNIT_PACK = $value9->UNIT_PACK;
            $add9->SEQ = $value9->SEQ;
            $add9->DRUGREMARK = $value9->DRUGREMARK;
            $add9->PA_NO = $value9->PA_NO;
            $add9->TOTCOPAY = $value9->TOTCOPAY;
            $add9->USE_STATUS = $value9->USE_STATUS; 
            $add9->TOTAL = $value9->TOTAL;
            $add9->a1 = $value9->a1;
            $add9->a2 = $value9->a2;
            $add9->save();
        }
        return view('claim.anc_14001',[
            'anc14001'  => $anc14001,
            'start'     => $datestart,
            'end'       => $dateend, 
        ] );
    }


}