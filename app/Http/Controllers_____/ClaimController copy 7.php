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
use Auth;
use ZipArchive;
use Storage;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Stevebauman\Location\Facades\Location; 
use SoapClient; 
use SplFileObject;
// use File;
 
 

class ClaimController extends Controller
{
    public function ssop(Request $request)
    {
        $datestart = $request->startdate;
        $dateend = $request->enddate;
        $data['users'] = User::get();
        $data['leave_month'] = DB::table('leave_month')->get();
        // dd($datestart);    
        $ssop_billtran = DB::connection('mysql7')->select('   
            SELECT * FROM ssop_billtran 
        '); 
        $ssop_billitems = DB::connection('mysql7')->select('   
            SELECT * FROM ssop_billitems   
        ');
        $ssop_dispensing = DB::connection('mysql7')->select('   
            SELECT * FROM ssop_dispensing   
        ');   
        $ssop_dispenseditems = DB::connection('mysql7')->select('   
            SELECT * FROM ssop_dispenseditems   
        ');  
        $ssop_opservices = DB::connection('mysql7')->select('   
            SELECT * FROM ssop_opservices   
        ');
        $ssop_opdx_ = DB::connection('mysql7')->select('   
            SELECT * FROM ssop_opdx   
        ');
 
        return view('claim.ssop',$data,[
            'start'            => $datestart,
            'end'              => $dateend,
            'ssop_billtran'    => $ssop_billtran,
            'ssop_billitems'   => $ssop_billitems,
            'ssop_dispensing'  => $ssop_dispensing,
            'ssop_dispenseditems'  => $ssop_dispenseditems,
            'ssop_opservices'  => $ssop_opservices,
            'ssop_opdx_'  => $ssop_opdx_,
        ]);
    }
    public function ssop_search(Request $request)
    {
        $datestart = $request->startdate;
        $dateend = $request->enddate;
        $data['users'] = User::get();
        $data['leave_month'] = DB::table('leave_month')->get();
        // dd($datestart);
        $ssop_data = DB::connection('mysql3')->select('   
                SELECT v.hn as HN
                ,v.spclty as CLINIC
                ,DATE_FORMAT(v.vstdate, "%Y%m%d") as DATEOPD
                ,concat(substr(o.vsttime,1,2),substr(o.vsttime,4,2)) as TIMEOPD
                ,v.vn as SEQ 
                ,"1" AS UUC
                ,concat(pt.pname,pt.fname," ",pt.lname) as fullname
                ,o.vstdate
                ,o.vsttime
                ,pt.cid as CID
                from vn_stat v
                LEFT JOIN ovst o on o.vn = v.vn
                LEFT JOIN pttype p on p.pttype = v.pttype
                LEFT JOIN ipt i on i.vn = v.vn 
                LEFT JOIN patient pt on pt.hn = v.hn
                WHERE v.vstdate BETWEEN "'.$datestart.'" AND "'.$dateend.'" 
                AND p.pcode ="A7"
        ');

        Claim_temp_ssop::truncate();

        foreach ($ssop_data as $key => $value) {           
            $add= new Claim_temp_ssop();
            $add->HN = $value->HN ;
            $add->CID = $value->CID; 
            $add->SEQ = $value->SEQ; 
            $add->AN = ''; 
            $add->CHECK = 'Y';
            $add->STATUS = 'SEARCH';
            $add->save();
        }
       
        return view('claim.ssop',$data,[
            'start'       => $datestart,
            'end'         => $dateend,
            'ssop_data'   => $ssop_data
        ]);
    }
    public function ssop_save16(Request $request)
    { 
        $datestart = $request->startdate;
        $dateend = $request->enddate;
        $ssop_opd = DB::connection('mysql3')->select('   
                SELECT v.hn HN
                    ,v.spclty CLINIC
                    ,DATE_FORMAT(v.vstdate, "%Y%m%d") DATEOPD
                    ,concat(substr(o.vsttime,1,2),substr(o.vsttime,4,2)) TIMEOPD
                    ,v.vn SEQ 
                    ,"1" UUC 
                    from hos.vn_stat v
                    LEFT JOIN hos.ovst o on o.vn = v.vn
                    LEFT JOIN hos.pttype p on p.pttype = v.pttype
                    LEFT JOIN hos.ipt i on i.vn = v.vn 
                    LEFT JOIN hos.patient pt on pt.hn = v.hn
                   
                    join claim.claim_temp_ssop on claim.claim_temp_ssop.SEQ = v.vn   

                WHERE v.vstdate BETWEEN "'.$datestart.'" AND "'.$dateend.'" 
                AND claim.claim_temp_ssop.CHECK="Y"
        ');
        Claim_sixteen_opd::truncate();
        foreach ($ssop_opd as $key => $value) {           
            $add= new Claim_sixteen_opd();
            $add->HN = $value->HN ;
            $add->CLINIC = $value->CLINIC; 
            $add->DATEOPD = $value->DATEOPD; 
            $add->TIMEOPD = $value->TIMEOPD;
            $add->SEQ = $value->SEQ;
            $add->UUC = $value->UUC;
            $add->save();
        }
        $ssop_ins = DB::connection('mysql3')->select('   
            SELECT v.hn HN
                ,if(i.an is null,p.hipdata_code,pp.hipdata_code) INSCL
                ,if(i.an is null,p.pcode,pp.pcode) SUBTYPE
                ,v.cid CID
                ,DATE_FORMAT(if(i.an is null,v.pttype_begin,ap.begin_date), "%Y%m%d") DATEIN
                ,DATE_FORMAT(if(i.an is null,v.pttype_expire,ap.expire_date), "%Y%m%d") DATEEXP
                ,if(i.an is null,v.hospmain,ap.hospmain) HOSPMAIN
                ,if(i.an is null,v.hospsub,ap.hospsub) HOSPSUB
                ,"" GOVCODE
                ,"" GOVNAME
                ,ifnull(if(i.an is null,vp.claim_code,ap.claim_code),r.sss_approval_code) PERMITNO
                ,"" DOCNO
                ,"" OWNRPID 
                ,"" OWNRNAME
                ,i.an AN
                ,v.vn SEQ
                ,"" SUBINSCL 
                ,"" RELINSCL
                ,"" HTYPE
                ,v.vstdate
                from hos.vn_stat v
                LEFT JOIN hos.pttype p on p.pttype = v.pttype
                LEFT JOIN hos.ipt i on i.vn = v.vn 
                LEFT JOIN hos.pttype pp on pp.pttype = i.pttype
                left join hos.ipt_pttype ap on ap.an = i.an
                left join hos.visit_pttype vp on vp.vn = v.vn
                LEFT JOIN hos.rcpt_debt r on r.vn = v.vn
                left join hos.patient px on px.hn = v.hn

                join claim.claim_temp_ssop on claim.claim_temp_ssop.SEQ = v.vn   
                
                WHERE v.vstdate BETWEEN "'.$datestart.'" AND "'.$dateend.'" 
                AND claim.claim_temp_ssop.CHECK="Y"
        ');
        // join claim.claim_temp_ssop on claim.claim_temp_ssop.SEQ = hos.vn_stat.vn   
        Claim_sixteen_ins::truncate();
        foreach ($ssop_ins as $key => $value2) {           
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
        $ssop_pat = DB::connection('mysql3')->select('   
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

                join claim.claim_temp_ssop on claim.claim_temp_ssop.SEQ = v.vn   
                
                WHERE v.vstdate BETWEEN "'.$datestart.'" AND "'.$dateend.'" 
                AND claim.claim_temp_ssop.CHECK="Y"
        ');
        Claim_sixteen_pat::truncate();
        foreach ($ssop_pat as $key => $value3) {           
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
        $ssop_orf = DB::connection('mysql3')->select('   
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

                join claim.claim_temp_ssop on claim.claim_temp_ssop.SEQ = v.vn   
                
                WHERE v.vstdate BETWEEN "'.$datestart.'" AND "'.$dateend.'" 
                AND claim.claim_temp_ssop.CHECK="Y"
        ');
        Claim_sixteen_orf::truncate();
        foreach ($ssop_orf as $key => $value4) {           
            $add4= new Claim_sixteen_orf(); 
            $add4->HN = $value4->HN; 
            $add4->DATEOPD = $value4->DATEOPD; 
            $add4->CLINIC = $value4->CLINIC;
            $add4->REFER = $value4->REFER;
            $add4->REFERTYPE = $value4->REFERTYPE;
            $add4->SEQ = $value4->SEQ; 
            $add4->save();
        }
        $ssop_odx = DB::connection('mysql3')->select('   
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
                INNER JOIN hos.icd101 i on i.code = o.icd10

                join claim.claim_temp_ssop on claim.claim_temp_ssop.SEQ = v.vn   
                
                WHERE v.vstdate BETWEEN "'.$datestart.'" AND "'.$dateend.'" 
                AND claim.claim_temp_ssop.CHECK="Y"
        ');
        Claim_sixteen_odx::truncate();
        foreach ($ssop_odx as $key => $value5) {           
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
        $ssop_oop = DB::connection('mysql3')->select('   
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
                inner JOIN hos.icd9cm1 i on i.code = o.icd10

                join claim.claim_temp_ssop on claim.claim_temp_ssop.SEQ = v.vn   
                
                WHERE v.vstdate BETWEEN "'.$datestart.'" AND "'.$dateend.'" 
                AND claim.claim_temp_ssop.CHECK="Y"
        ');
        Claim_sixteen_oop::truncate();
        foreach ($ssop_oop as $key => $value6) {           
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
        $ssop_cht = DB::connection('mysql3')->select('   
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

                join claim.claim_temp_ssop on claim.claim_temp_ssop.SEQ = v.vn   
                
                WHERE v.vstdate BETWEEN "'.$datestart.'" AND "'.$dateend.'" 
                AND claim.claim_temp_ssop.CHECK="Y"
        ');
        Claim_sixteen_cht::truncate();
        foreach ($ssop_cht as $key => $value7) {           
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
        $ssop_cha = DB::connection('mysql3')->select('   
             
                SELECT v.hn HN
                    ,if(v1.an is null," ",v1.an) AN 
                    ,if(v1.an is null,DATE_FORMAT(v.vstdate,"%Y%m%d"),DATE_FORMAT(v1.dchdate,"%Y%m%d")) DATE
                    ,if(v.paidst in("01","03"),dx.chrgitem_code2,dc.chrgitem_code1) CHRGITEM
                    ,round(sum(v.sum_price),2) AMOUNT
                    ,p.cid PERSON_ID 
                    ,ifnull(v.vn,v.an) SEQ
                    from hos.opitemrece v
                    LEFT JOIN hos.vn_stat vv on vv.vn = v.vn
                    LEFT JOIN hos.patient p on p.hn = v.hn
                    LEFT JOIN hos.ipt v1 on v1.an = v.an
                    LEFT JOIN hos.income i on v.income=i.income
                    LEFT JOIN hos.drg_chrgitem dc on i.drg_chrgitem_id=dc.drg_chrgitem_id 
                    LEFT JOIN hos.drg_chrgitem dx on i.drg_chrgitem_id= dx.drg_chrgitem_id 

                    join claim.claim_temp_ssop on claim.claim_temp_ssop.SEQ = v.vn 

                    WHERE v.vstdate BETWEEN "'.$datestart.'" AND "'.$dateend.'" 
                    AND claim.claim_temp_ssop.CHECK="Y"
                    group by v.vn,CHRGITEM

                    union all
                    SELECT v.hn HN
                    ,v1.an AN 
                    ,if(v1.an is null,DATE_FORMAT(v.vstdate,"%Y%m%d"),DATE_FORMAT(v1.dchdate,"%Y%m%d")) DATE
                    ,if(v.paidst in("01","03"),dx.chrgitem_code2,dc.chrgitem_code1) CHRGITEM
                    ,round(sum(v.sum_price),2) AMOUNT
                    ,p.cid PERSON_ID 
                    ,ifnull(v.vn,v.an) SEQ
                    from hos.opitemrece v
                    LEFT JOIN hos.vn_stat vv on vv.vn = v.vn
                    LEFT JOIN hos.patient p on p.hn = v.hn
                    LEFT JOIN hos.ipt v1 on v1.an = v.an
                    LEFT JOIN hos.income i on v.income=i.income
                    LEFT JOIN hos.drg_chrgitem dc on i.drg_chrgitem_id=dc.drg_chrgitem_id 
                    LEFT JOIN hos.drg_chrgitem dx on i.drg_chrgitem_id= dx.drg_chrgitem_id 

                    join claim.claim_temp_ssop on claim.claim_temp_ssop.SEQ = v.vn 
                    AND claim.claim_temp_ssop.CHECK="Y"

                    WHERE v.vstdate BETWEEN "'.$datestart.'" AND "'.$dateend.'" 
                    group by v.an,CHRGITEM;

        ');
        Claim_sixteen_cha::truncate();
        foreach ($ssop_cha as $key => $value8) {           
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
        $ssop_adp = DB::connection('mysql3')->select('  
        
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
                    from (SELECT v.hn HN
                    ,v.an AN
                    ,DATE_FORMAT(v.rxdate,"%Y%m%d") DATEOPD
                    ,n.nhso_adp_type_id TYPE
                    ,n.nhso_adp_code CODE 
                    ,sum(v.QTY) QTY
                    ,round(v.unitprice,2) RATE
                    ,if(v.an is null,v.vn," ") SEQ
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
                    from hos.opitemrece v
                    inner JOIN hos.drugitems n on n.icode = v.icode and n.nhso_adp_code is not null
                    left join hos.ipt i on i.an = v.an
                    AND i.an is not NULL

                    join claim.claim_temp_ssop on claim.claim_temp_ssop.SEQ = v.vn 
                    WHERE v.vstdate BETWEEN "'.$datestart.'" AND "'.$dateend.'" 
                    AND claim.claim_temp_ssop.CHECK="Y"
                   

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
                    (SELECT v.hn HN
                    ,v.an AN
                    ,DATE_FORMAT(v.vstdate,"%Y%m%d") DATEOPD
                    ,n.nhso_adp_type_id TYPE
                    ,n.nhso_adp_code CODE 
                    ,sum(v.QTY) QTY
                    ,round(v.unitprice,2) RATE
                    ,if(v.an is null,v.vn," ") SEQ
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
                    from hos.opitemrece v
                    inner JOIN hos.drugitems n on n.icode = v.icode and n.nhso_adp_code is not null
                    left join hos.ipt i on i.an = v.an
                   
                    join claim.claim_temp_ssop on claim.claim_temp_ssop.SEQ = v.vn 
                    WHERE v.vstdate BETWEEN "'.$datestart.'" AND "'.$dateend.'" 
                    AND claim.claim_temp_ssop.CHECK="Y"

                    AND i.an is NULL
                    GROUP BY v.vn,n.nhso_adp_code,rate) b 
                    GROUP BY seq,CODE,rate 
 

        ');
        claim_sixteen_adp::truncate();
        foreach ($ssop_adp as $key => $value8) {           
            $add8 = new claim_sixteen_adp(); 
            $add8->HN = $value8->HN; 
            $add8->AN = $value8->AN;
            $add8->DATE = $value8->DATE; 
            $add8->CHRGITEM = $value8->CHRGITEM;
            $add8->AMOUNT = $value8->AMOUNT; 
            $add8->PERSON_ID = $value8->PERSON_ID; 
            $add8->SEQ = $value8->SEQ; 
            $add8->save();
        }

        $ssop_dru = DB::connection('mysql3')->select('   
                SELECT vv.hcode HCODE
                    ,v.hn HN
                    ,v.an AN
                    ,vv.spclty CLINIC
                    ,vv.cid PERSON_ID
                    ,DATE_FORMAT(v.vstdate,"%Y%m%d") DATE_SERV
                    ,d.icode DID
                    ,concat(d.name," ",d.strength," ",d.units) DIDNAME
                    ,v.qty AMOUNT
                    ,round(v.unitprice,2) DRUGPRIC
                    ,"0.00" DRUGCOST
                    ,d.did DIDSTD
                    ,d.units UNIT
                    ,concat(d.packqty,"x",d.units) UNIT_PACK
                    ,v.vn SEQ
                    ,oo.presc_reason DRUGREMARK
                    ," "PA_NO
                    ," " TOTCOPAY
                    ,if(v.item_type="H","2","1") USE_STATUS
                    ," " TOTAL," " a1," "  a2
                    from hos.opitemrece v
                    LEFT JOIN hos.drugitems d on d.icode = v.icode
                    LEFT JOIN hos.vn_stat vv on vv.vn = v.vn
                    LEFT JOIN hos.ovst_presc_ned oo on oo.vn = v.vn and oo.icode=v.icode
                    
                    join claim.claim_temp_ssop on claim.claim_temp_ssop.SEQ = v.vn               
                    WHERE v.vstdate BETWEEN "'.$datestart.'" AND "'.$dateend.'" 
                    AND claim.claim_temp_ssop.CHECK="Y"
                    and d.did is not null 
                    GROUP BY v.vn,did

                    UNION all
                    SELECT pt.hcode HCODE
                    ,v.hn HN
                    ,v.an AN
                    ,v1.spclty CLINIC
                    ,pt.cid PERSON_ID
                    ,DATE_FORMAT((v.vstdate),"%Y%m%d") DATE_SERV
                    ,d.icode DID
                    ,concat(d.name," ",d.strength," ",d.units) DIDNAME
                    ,sum(v.qty) AMOUNT
                    ,round(v.unitprice,2) DRUGPRIC
                    ,"0.00" DRUGCOST
                    ,d.did DIDSTD
                    ,d.units UNIT
                    ,concat(d.packqty,"x",d.units) UNIT_PACK
                    ,ifnull(v.vn,v.an) SEQ
                    ,oo.presc_reason DRUGREMARK
                    ," " PA_NO
                    ," " TOTCOPAY
                    ,if(v.item_type="H","2","1") USE_STATUS
                    ," " TOTAL," " a1," "  a2
                    from hos.opitemrece v
                    LEFT JOIN hos.drugitems d on d.icode = v.icode
                    LEFT JOIN hos.patient pt  on v.hn = pt.hn
                    inner JOIN hos.ipt v1 on v1.an = v.an
                    LEFT JOIN hos.ovst_presc_ned oo on oo.vn = v.vn and oo.icode=v.icode
 
                    join claim.claim_temp_ssop on claim.claim_temp_ssop.SEQ = v1.vn               
                    WHERE v.vstdate BETWEEN "'.$datestart.'" AND "'.$dateend.'" 
                    AND claim.claim_temp_ssop.CHECK="Y"

                    and d.did is not null AND v.qty<>"0"
                    GROUP BY v.an,d.icode,USE_STATUS
 
 
        ');
        Claim_sixteen_dru::truncate();
        foreach ($ssop_dru as $key => $value9) {           
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
            // $add9->STATUS1 = $value9->STATUS1;
            $add9->TOTAL = $value9->TOTAL;
            $add9->a1 = $value9->a1;
            $add9->a2 = $value9->a2;
            $add9->save();
        }
            
            return Redirect()->route('claim.ssop_detail'); 
       
    }
    public function ssop_detail(Request $request)
    {  
        // $ssop_data = DB::connection('mysql7')->select('   
        //     SELECT * from claim_sixteen_opd
        // ');
        $data['claim_sixteen_ins'] = DB::connection('mysql7')->select('   
            SELECT * from claim_sixteen_ins
        ');
        $data['claim_sixteen_pat'] = DB::connection('mysql7')->select('   
            SELECT * from claim_sixteen_pat
        ');
        $data['claim_sixteen_opd'] = DB::connection('mysql7')->select('   
            SELECT * from claim_sixteen_opd
        ');
        $data['claim_sixteen_orf'] = DB::connection('mysql7')->select('   
            SELECT * from claim_sixteen_orf
        ');
        $data['claim_sixteen_odx'] = DB::connection('mysql7')->select('   
            SELECT * from claim_sixteen_odx
        ');

        $data['claim_sixteen_oop'] = DB::connection('mysql7')->select('   
            SELECT * from claim_sixteen_oop
        ');
        $data['claim_sixteen_cht'] = DB::connection('mysql7')->select('   
            SELECT * from claim_sixteen_cht
        ');
        $data['claim_sixteen_cha'] = DB::connection('mysql7')->select('   
            SELECT * from claim_sixteen_cha
        ');
 
        return view('claim.ssop_detail',$data,[ 
            // 'ssop_data'   => $ssop_data
        ]);
    }
    public function ssop_claimsixteen(Request $request)
    {
        $datestart = $request->startdate;
        $dateend = $request->enddate;
        $data['users'] = User::get();
        $data['leave_month'] = DB::table('leave_month')->get();
        // dd($datestart);
        $ssop_data = DB::connection('mysql3')->select('   
            SELECT
                o.hn AS HN
                ,concat(p.pname,p.fname," ",p.lname) as fullname
                ,o.spclty AS CLINIC
                ,o.vstdate
                ,o.vsttime
                ,DATE_FORMAT(o.vstdate,"%Y%m%d") AS DATEOPD
                ,DATE_FORMAT(o.vsttime,"%H%i") AS TIMEOPD
                ,o.vn AS SEQ
                ,"1" AS UUC
                FROM ovst o
                LEFT OUTER JOIN patient p on p.hn = o.hn
                LEFT OUTER JOIN pttype pt on pt.pttype = o.pttype
                WHERE o.vstdate BETWEEN "'.$datestart.'" AND "'.$dateend.'" 
                AND pt.pcode ="A7"
                AND (o.an=" " OR o.an IS NULL) 
        ');
 
        return view('claim.ssop_claimsixteen',$data,[
            'start'       => $datestart,
            'end'         => $dateend,
            'ssop_data'   => $ssop_data
        ]);
    }
     
    public function ssop_data(Request $request)
    {
        $datestart = $request->startdate;
        $dateend = $request->enddate; 
  
        $ssop_billtran_ = DB::connection('mysql3')->select('   
            SELECT o.vn as Invno,p.hn as HN,o.an,o.vstdate,o.vsttime,o.hcode as Hcode,pt.pttype,v.pdx as Diag,v.dx0,v.dx1,v.dx2,v.dx3,v.dx4,v.dx5,v.sex,v.uc_money
            ,op.icode,op.qty,op.unitprice,op.income,op.paidst,op.sum_price,CONCAT(p.pname,p.fname," ",p.lname) AS "Name",pt.nhso_code
            ,d.name as doctorname,d.licenseno
            ,"01" AS "Station", "" AS "Authencode", CONCAT(o.vstdate,"T",o.vsttime) AS "DTtran","" AS "Billno"
            , "" AS "MemberNo",ROUND(SUM(op.sum_price) ,2) AS "Amount","0.00" AS "Paid"
            ,"" AS "VerCode", "A" AS "Tflag",v.cid AS "Pid"
            ,o.hospmain AS "HMain", "80" AS "PayPlan"
			,ROUND( SUM(op.sum_price) ,2) AS "ClaimAmt"
			,"" AS "OtherPayplan"
			,"0.00" AS "OtherPay" ,o.spclty 
            FROM ovst o 
			LEFT JOIN vn_stat v ON o.vn=v.vn
			LEFT JOIN opitemrece op ON o.vn=op.vn
			LEFT JOIN patient p ON o.hn=p.hn   
            LEFT JOIN pttype pt on pt.pttype = o.pttype 
			LEFT JOIN doctor d on d.code = o.doctor
            WHERE o.vstdate BETWEEN "'.$datestart.'" and "'.$dateend.'" 
            AND op.qty<>0
            AND pt.pttype ="A7"
			GROUP BY o.vn    
        '); 
        Ssop_billtran::truncate();
        foreach ($ssop_billtran_ as $key => $value) {           
            $add= new Ssop_billtran();
            $add->Station = $value->Station ;
            $add->Authencode = $value->Authencode; 
            $add->vstdate = $value->vstdate; 
            $add->DTtran = $value->DTtran;
          
            $add->Hcode = "10978";
                      
            $add->Invno = $value->Invno;
            $add->VerCode = $value->VerCode;
            $add->Tflag = $value->Tflag;
            $add->HMain = $value->HMain;
            $add->HN = $value->HN;
            $add->Pid = $value->Pid;
            $add->Name = $value->Name;
            $add->Amount = $value->Amount;
            $add->Paid = $value->Paid;
            $add->ClaimAmt = $value->ClaimAmt;
            $add->PayPlan = $value->PayPlan;
            $add->OtherPay = $value->OtherPay;
            $add->OtherPayplan = $value->OtherPayplan;
            $add->pttype = $value->pttype;
            $add->Diag = $value->Diag;
            $add->save();
        }    
        $ssop_billitems_ = DB::connection('mysql3')->select('   
            SELECT o.vn AS "Invno"
                ,o.vstdate AS "SvDate"
                , i.income_group AS "BillMuad"
                , op.icode AS "LCCode"
                ,sd.nhso_adp_code AS "STDCode"
                , sd.name AS "Desc"        
                ,op.qty AS "QTY"
                , ROUND(op.unitprice,2) AS "UnitPrice"
                , ROUND(op.sum_price,2) AS "ChargeAmt"
                , ROUND(op.unitprice,2) AS "ClaimUP"
                , ROUND(op.sum_price,2)  AS "ClaimAmount"
                , o.vn AS "SvRefID"
                , "OP1" AS "ClaimCat"
                ,"02" As "paidst"						
            FROM ovst o  
            LEFT JOIN opitemrece op ON o.vn=op.vn 
            LEFT JOIN patient p ON o.hn=p.hn   
            LEFT JOIN pttype pt on pt.pttype = o.pttype 
            LEFT JOIN doctor d on d.code = o.doctor
            LEFT JOIN s_drugitems sd ON sd.icode=op.icode  
            LEFT JOIN drugitems dt ON dt.icode=op.icode
            LEFT JOIN claim.income i ON i.income=op.income
            WHERE o.vstdate BETWEEN "'.$datestart.'" and "'.$dateend.'" 
            AND op.qty<>0
            AND op.paidst="02"
            AND pt.pttype ="A7"
            
        ');  
        Ssop_billitems::truncate();
        foreach ($ssop_billitems_ as $key => $value2) {           
            $add2= new Ssop_billitems();
            $add2->Invno = $value2->Invno ; 
            $add2->SvDate = $value2->SvDate; 
            $add2->BillMuad = $value2->BillMuad;
            $add2->LCCode = $value2->LCCode;
            if ($value2->STDCode == 'XXXXXX') {
                $add2->STDCode = '';
            } else {
                $add2->STDCode = $value2->STDCode;
            }
            
            
            $add2->Desc = $value2->Desc;
            $add2->QTY = $value2->QTY;
            $add2->UnitPrice = $value2->UnitPrice;
            $add2->ChargeAmt = $value2->ChargeAmt;
            $add2->ClaimUP = $value2->ClaimUP;
            $add2->ClaimAmount = $value2->ClaimAmount;
            $add2->SvRefID = $value2->SvRefID;
            $add2->ClaimCat = $value2->ClaimCat;
            $add2->paidst = $value2->paidst; 
            $add2->save();
        }  
        $ssop_dispensing_ = DB::connection('mysql3')->select('   
            SELECT "10978" AS "ProviderID" , o.vn AS "DispID" , o.vn AS "Invno", o.hn AS "HN", v.cid AS "PID"
			, CONCAT(o.vstdate,"T",o.vsttime) AS "Prescdt" , CONCAT(o.vstdate,"T",o.vsttime) AS "Dispdt"
			,IFNULL( (SELECT licenseno FROM doctor WHERE code=o.doctor) ,"ว64921") AS "Prescb"
			,SUM(IF(op.income IN ("03","17","05"),"1","")) AS "Itemcnt"
			,ROUND( SUM(IF(op.income IN ("03","17","05"),op.sum_price,0)) ,2) AS "ChargeAmt"
			,ROUND( SUM(IF(op.income IN ("03","17","05"),op.sum_price,0)) ,2) AS "ClaimAmt"
			,"0.00" AS "Paid" ,"0.00" AS "OtherPay" , "HP" AS "Reimburser" , "SS" AS "BenefitPlan" , "1" AS "DispeStat" , " " AS "SvID"," " AS "DayCover"				
            FROM ovst o 
			LEFT JOIN vn_stat v ON o.vn=v.vn
			LEFT JOIN opitemrece op ON o.vn=op.vn
			LEFT JOIN pttype pt on pt.pttype = o.pttype 
            WHERE o.vstdate BETWEEN "'.$datestart.'" and "'.$dateend.'" 
            AND op.income IN ("03","17","05") 
			AND op.qty<>0 
			AND op.paidst="02"
			AND pt.pttype ="A7"
            GROUP BY o.vn    
        ');  
        Ssop_dispensing::truncate();
        foreach ($ssop_dispensing_ as $key => $value3) {           
            $add3= new Ssop_dispensing();
            $add3->ProviderID = $value3->ProviderID ; 
            $add3->DispID = $value3->DispID; 
            $add3->Invno = $value3->Invno;
            $add3->HN = $value3->HN;
            $add3->PID = $value3->PID;
            $add3->Prescdt = $value3->Prescdt;
            $add3->Dispdt = $value3->Dispdt;
            $add3->Prescb = $value3->Prescb;
            $add3->Itemcnt = $value3->Itemcnt;
            $add3->ChargeAmt = $value3->ChargeAmt;
            $add3->ClaimAmt = $value3->ClaimAmt;
            $add3->Paid = $value3->Paid;
            $add3->OtherPay = $value3->OtherPay;
            $add3->Reimburser = $value3->Reimburser; 
            $add3->BenefitPlan = $value3->BenefitPlan; 
            $add3->DispeStat = $value3->DispeStat; 
            $add3->SvID = $value3->SvID; 
            $add3->DayCover = $value3->DayCover; 
            $add3->save();
        } 
         
        $ssop_dispenseditems_ = DB::connection('mysql3')->select('   
            SELECT  o.vn AS "DispID", IF(di.icode<>"",di.sks_product_category_id, di.sks_product_category_id) AS "PrdCat"
            ,op.icode AS "HospDrgID", IF(di.sks_drug_code!="",di.sks_drug_code,"") AS "DrgID" 
            ,di.name AS "dfsText", di.units AS "Packsize"
            ,IF(op.sp_use!="",op.sp_use,op.drugusage) AS "sigCode"
            ,IF(op.sp_use!=" "
                ,(SELECT CONCAT( ifnull(name1,""), ifnull(name2," "), ifnull(name3,"") ) FROM sp_use where sp_use=op.sp_use )
                ,(SELECT CONCAT( ifnull(name1,""), ifnull(name2," "), ifnull(name3,"") ) FROM drugusage WHERE drugusage=op.drugusage )
                ) AS "sigText"
                , op.qty AS "Quantity", ROUND(op.unitprice,2) AS "UnitPrice", ROUND(op.sum_price,2) AS "ChargeAmt", ROUND(op.unitprice,2) AS "ReimbPrice", ROUND(op.sum_price,2) AS "ReimbAmt","" AS "PrdSeCode"
                ,"OD" AS "Claimcont", "OP1" AS "ClaimCat"              
                ,"02" AS "paidst"
            FROM ovst o 
			LEFT JOIN vn_stat v ON o.vn=v.vn
			LEFT JOIN opitemrece op ON o.vn=op.vn
			LEFT JOIN pttype pt on pt.pttype = o.pttype 
            LEFT JOIN s_drugitems di ON di.icode=op.icode 
            WHERE o.vstdate BETWEEN "'.$datestart.'" and "'.$dateend.'" 
            AND op.income IN ("03","17","05") 
			AND op.qty<>0 
			AND op.paidst="02"
			AND pt.pttype ="A7"
               
        ');  
        Ssop_dispenseditems::truncate();
        foreach ($ssop_dispenseditems_ as $key => $value4) {           
            $add4= new Ssop_dispenseditems();
            $add4->DispID = $value4->DispID ; 
            $add4->PrdCat = $value4->PrdCat; 
            $add4->HospDrgID = $value4->HospDrgID;
            $add4->DrgID = $value4->DrgID;
            $add4->dfsText = $value4->dfsText;
            

            if ($value4->Packsize == '') {
                $add4->Packsize = "Unit";
            } else {
                $add4->Packsize = $value4->Packsize;
            }
            if ($value4->sigCode == '') {
                $add4->sigCode = "0004";
            } else {
                $add4->sigCode = $value4->sigCode;
            }
            if ($value4->sigText == '') {
                $add4->sigText = "ใช้ตามแพทย์สั่ง";
            } else {
                $add4->sigText = $value4->sigText;
            }
            
            $add4->Quantity = $value4->Quantity;
            $add4->UnitPrice = $value4->UnitPrice;
            $add4->ChargeAmt = $value4->ChargeAmt;
            $add4->ReimbPrice = $value4->ReimbPrice;
            $add4->ReimbAmt = $value4->ReimbAmt;
            $add4->PrdSeCode = $value4->PrdSeCode; 
            $add4->Claimcont = $value4->Claimcont; 
            $add4->ClaimCat = $value4->ClaimCat; 
            $add4->paidst = $value4->paidst;  
            $add4->save();
        } 
        
        $ssop_opservices_ = DB::connection('mysql3')->select('   
            SELECT o.vn AS "Invno", o.vn AS "SvID", "EC" AS "Class", "10978" AS "Hcode", o.hn AS "HN", v.cid AS "PID"
            ,"1" AS "CareAccount", "01" AS "TypeServ", "1" AS "TypeIn", "1" AS "TypeOut", "" AS "DTAppoint"
            ,IFNULL( (SELECT licenseno FROM doctor WHERE code=o.doctor) ,"ว64919") AS "SvPID"
            ,IF(o.spclty NOT IN ("01","02","03","04","05","06","07","08","09","10","11","12"),"99",o.spclty) AS "Clinic"
            , CONCAT(o.vstdate,"T",o.vsttime) AS "BegDT", CONCAT(o.vstdate,"T",o.vsttime) AS "EndDT"
            ,"" AS "LcCode", "" AS "CodeSet", "" AS "STDCode", "0.00" AS "SvCharge", "Y" AS "Completion", "" AS "SvTxCode", "OP1" AS "ClaimCat"

            FROM ovst o 
            LEFT JOIN vn_stat v ON o.vn=v.vn
            WHERE o.vstdate BETWEEN "'.$datestart.'" and "'.$dateend.'"  
            AND v.pttype ="A7"
            GROUP BY o.vn
            
            ');  
        Ssop_opservices::truncate();
        foreach ($ssop_opservices_ as $key => $value5) {           
            $add5= new Ssop_opservices();
            $add5->Invno = $value5->Invno ; 
            $add5->SvID = $value5->SvID; 
            $add5->Class = $value5->Class;
            $add5->Hcode = $value5->Hcode;
            $add5->HN = $value5->HN; 
            $add5->PID = $value5->PID;
            $add5->CareAccount = $value5->CareAccount;
            $add5->TypeServ = $value5->TypeServ;
            $add5->TypeIn = $value5->TypeIn;
            $add5->TypeOut = $value5->TypeOut;
            $add5->DTAppoint = $value5->DTAppoint; 
            $add5->SvPID = $value5->SvPID; 
            $add5->Clinic = $value5->Clinic; 
            $add5->BegDT = $value5->BegDT;
            $add5->EndDT = $value5->EndDT;
            $add5->LcCode = $value5->LcCode;
            $add5->CodeSet = $value5->CodeSet;
            $add5->STDCode = $value5->STDCode;
            $add5->SvCharge = $value5->SvCharge;
            $add5->Completion = $value5->Completion;
            $add5->SvTxCode = $value5->SvTxCode;
            $add5->ClaimCat = $value5->ClaimCat;  
            $add5->save();
        } 

        $ssop_opdx_ = DB::connection('mysql3')->select('   
            SELECT "EC" AS "Class", o.vn AS "SvID", od.diagtype AS "SL", "IT" AS "CodeSet" 
            ,IF(od.icd10 like "M%", SUBSTR(od.icd10,1,4) ,IF(od.icd10 like "Z%", SUBSTR(od.icd10,1,4) ,od.icd10)) as code
            ," " as "Desc"
          
            FROM ovst o 
            LEFT JOIN ovstdiag od ON o.vn=od.vn
            WHERE o.vstdate BETWEEN "'.$datestart.'" and "'.$dateend.'"  
            AND od.icd10 NOT BETWEEN "0000" AND "9999"            
            '); 
            Ssop_opdx::truncate();
            foreach ($ssop_opdx_ as $key => $valueop) {           
                $addop= new Ssop_opdx();
                $addop->Class = $valueop->Class ; 
                $addop->SvID = $valueop->SvID; 
                $addop->SL = $valueop->SL;
                $addop->CodeSet = $valueop->CodeSet;
                $addop->code = $valueop->code; 
                $addop->Desc = $valueop->Desc; 
                $addop->save();
            } 
            // dd($ssop_opdx);
        
        $ssop_billtran = DB::connection('mysql7')->select('   
            SELECT * FROM ssop_billtran 
        '); 
        $ssop_billitems = DB::connection('mysql7')->select('   
            SELECT * FROM ssop_billitems   
        ');
        $ssop_dispensing = DB::connection('mysql7')->select('   
            SELECT * FROM ssop_dispensing   
        '); 
        $ssop_dispenseditems = DB::connection('mysql7')->select('   
            SELECT * FROM ssop_dispenseditems   
        ');  
        $ssop_opservices = DB::connection('mysql7')->select('   
            SELECT * FROM ssop_opservices   
        ');
        $ssop_opdx_ = DB::connection('mysql7')->select('   
            SELECT * FROM ssop_opdx   
        ');

        return view('claim.ssop',[
            'start'              => $datestart,
            'end'                => $dateend, 
            'ssop_billtran'      => $ssop_billtran, 
            'ssop_billitems'     => $ssop_billitems,
            'ssop_dispensing'     => $ssop_dispensing,
            'ssop_dispenseditems' => $ssop_dispenseditems,
            'ssop_opservices'  => $ssop_opservices,
            'ssop_opdx_'        => $ssop_opdx_
        ]);
    }

    public function ssop_send(Request $request)
    {
        $datestart = $request->startdate;
        $dateend = $request->enddate; 
   $ip = $request->ip(); 
        // dd($datestart);
        $sss_date_now = date("Y-m-d");
        $sss_time_now = date("H:i:s");
        $sesid_status = 'new'; #ส่งค่าสำหรับเงื่อนไขการบันทึกsession

        #sessionid เป็นค่าว่าง แสดงว่ายังไม่เคยส่งออก ต้องสร้างไอดีใหม่ จาก max+1
        $maxid = Ssop_session::max('ssop_session_no');
        $ssop_session_no = $maxid+1;

        

        #ตัดขีด, ตัด : ออก
        $pattern_date = '/-/i';
        $sss_date_now_preg = preg_replace($pattern_date, '', $sss_date_now);
        $pattern_time = '/:/i';
        $sss_time_now_preg = preg_replace($pattern_time, '', $sss_time_now);
        #ตัดขีด, ตัด : ออก

        $folder='10978_SSOPBIL_'.$ssop_session_no.'_01_'.$sss_date_now_preg.'-'.$sss_time_now_preg;

        $add = new Ssop_session();
        $add->ssop_session_no = $ssop_session_no;
        $add->ssop_session_date = $sss_date_now;
        $add->ssop_session_time = $sss_time_now;
        $add->ssop_session_filename = $folder;
        $add->ssop_session_ststus = "Send";

        $add->save();

        mkdir ('C:/export/'.$folder, 0777, true);
   
        header("Content-type: text/txt");
        header("Cache-Control: no-store, no-cache");
        header('Content-Disposition: attachment; filename="content.txt"');

        $file_name = "/BillTran".$sss_time_now_preg.".txt";
        // SELECT COUNT(*) from claim_ssop
        $ssop_count = DB::connection('mysql7')->select('      
            SELECT COUNT(*) as Invno             
            FROM ssop_billtran            
        '); 
        foreach ($ssop_count as $key => $valuecount) {
            $count = $valuecount->Invno;
        }

        $file_pat = "C:/export/".$folder."/BillTran".$sss_date_now_preg.".txt";     
        $objFopen_opd = fopen($file_pat, 'w');

        $file_pat2 = "C:/export/".$folder."/BillDisp".$sss_date_now_preg.".txt";     
        $objFopen_opd2 = fopen($file_pat2, 'w');

        $file_pat3 = "C:/export/".$folder."/OPServices".$sss_date_now_preg.".txt";     
        $objFopen_opd3 = fopen($file_pat3, 'w');


        $opd_head = '<?xml version="1.0" encoding="windows-874"?>';
        fwrite($objFopen_opd, $opd_head);

        $opd_head = "\n".'<ClaimRec System="OP" PayPlan="SS" Version="0.93" Prgs="HS">';
        fwrite($objFopen_opd, $opd_head);

        $opd_head = "\n".'<Header>';
        fwrite($objFopen_opd, $opd_head);

        $opd_head = "\n".'<HCODE>10978</HCODE>';
        fwrite($objFopen_opd, $opd_head);

        $opd_head = "\n".'<HNAME>โรงพยาบาลภูเขียวเฉลิมพระเกีรติ</HNAME>';
        $opd_head_ansi = iconv('UTF-8', 'TIS-620', $opd_head);
        fwrite($objFopen_opd, $opd_head_ansi);

        $opd_head = "\n".'<DATETIME>'.$sss_date_now.'T'.$sss_time_now.'</DATETIME>';
        fwrite($objFopen_opd, $opd_head);

        $opd_head = "\n".'<SESSNO>'.$ssop_session_no.'</SESSNO>';
        fwrite($objFopen_opd, $opd_head);

        $opd_head = "\n".'<RECCOUNT>'.$count.'</RECCOUNT>';
        fwrite($objFopen_opd, $opd_head);

        $opd_head = "\n".'</Header>';
        fwrite($objFopen_opd, $opd_head);
    
        $opd_head = "\n".'<BILLTRAN>';
        fwrite($objFopen_opd, $opd_head);

        $ssop_Billtran = DB::connection('mysql7')->select('   
            SELECT * from ssop_billtran            
        ');

        foreach ($ssop_Billtran as $key => $value2) {
            $b1 = $value2->Station;
            // $b2 = $value2->B2;
            $b3 = $value2->DTtran;
            $b4 = $value2->Hcode;
            $b5 = $value2->Invno;
            // $b6 = $value2->B6;
            $b7 = $value2->HN;
            // $b8 = $value2->B8;
            $b9 = number_format($value2->Amount,2);
            $b10 = number_format($value2->Paid,2);
            // $b11 = $value2->B11;
            $b12 = $value2->Tflag;
            $b13 = $value2->Pid;
            $b14= $value2->Name;
            $b15 = $value2->HMain;
            $b16= $value2->PayPlan;
            $b17= number_format($value2->ClaimAmt,2);
            // $b18 = $value2->B18;
            $b19 = number_format($value2->OtherPay,2);
            $strText2="\n".$b1."||".$b3."|".$b4."|".$b5."||".$b7."||".$b9."|".$b10."||".$b12."|".$b13."|".$b14."|".$b15."|".$b16."|".$b17."||".$b19;
            $ansitxt_pat2 = iconv('UTF-8', 'TIS-620', $strText2);
            fwrite($objFopen_opd, $ansitxt_pat2);
        }
         

        $opd_head = "\n".'</BILLTRAN>';
        fwrite($objFopen_opd, $opd_head);
  
        $opd_head = "\n".'<BillItems>';
        fwrite($objFopen_opd, $opd_head);
  
        $ssop_items = DB::connection('mysql7')->select('   
            SELECT * FROM ssop_billitems  
            ');
        foreach ($ssop_items as $key => $value) {
            $s1 = $value->Invno;
            $s2 = $value->SvDate;
            $s3 = $value->BillMuad;
            $s4 = $value->LCCode;
            $s5 = $value->STDCode;
            $s6 = $value->Desc;
            $s7 = number_format($value->QTY,2);
            $s8 = number_format($value->UnitPrice,2);
            $s9 = number_format($value->ChargeAmt,2);
            $s10 = number_format($value->ClaimUP,2);
            $s11 = number_format($value->ClaimAmount,2);
            $s12 = $value->SvRefID;
            $s13 = $value->ClaimCat;
            
            $strText="\n".$s1."|".$s2."|".$s3."|".$s4."|".$s5."|".$s6."|".$s7."|".$s8."|".$s9."|".$s10."|".$s11."|".$s12."|".$s13;
            $ansitxt_pat = iconv('UTF-8', 'TIS-620', $strText);
            fwrite($objFopen_opd, $ansitxt_pat);
        }
  
        $opd_head = "\n".'</BillItems>';
        fwrite($objFopen_opd, $opd_head);

        $opd_head = "\n".'</ClaimRec>';
        fwrite($objFopen_opd, $opd_head);

        $opd_head = "\n";
        fwrite($objFopen_opd, $opd_head);

        if($objFopen_opd){
            echo "File BillTran writed."."<BR>";    
        }else{
            echo "File BillTran can not write";
        }
    
        fclose($objFopen_opd);

        $md5file = md5_file($file_pat,FALSE);

        $mdup = strtoupper($md5file);
      
        $objFopen_opd = fopen($file_pat, 'a');

        $opd_head = '<?EndNote Checksum="'.$mdup.'"?>';
        fwrite($objFopen_opd, $opd_head);

        $opd_head = "\n";
        fwrite($objFopen_opd, $opd_head);

        if($objFopen_opd){
            echo "File BillDisp MD5 writed."."<BR>";

        }else{
            echo "File BillDisp MD5 can not write";
        }

        fclose($objFopen_opd);


        // ****************************************************************************************
  
        $BillDispcount = DB::connection('mysql7')->select('      
            SELECT COUNT(*) as Invno             
            FROM ssop_dispensing            
        '); 
        foreach ($BillDispcount as $key => $values) {
            $count_BillDispcount = $values->Invno;         
        }
        $_head = '<?xml version="1.0" encoding="windows-874"?>';
        fwrite($objFopen_opd2, $_head);

        $_head = "\n".'<ClaimRec System="OP" PayPlan="SS" Version="0.93" Prgs="HS">';
        fwrite($objFopen_opd2, $_head);

        $_head = "\n".'<Header>';
        fwrite($objFopen_opd2, $_head);

        $_head = "\n".'<HCODE>10978</HCODE>';
        fwrite($objFopen_opd2, $_head);

        $_head = "\n".'<HNAME>โรงพยาบาลภูเขียวเฉลิมพระเกีรติ</HNAME>';
        $opd_head_ansi2 = iconv('UTF-8', 'TIS-620', $_head);
        fwrite($objFopen_opd2, $opd_head_ansi2);

        $_head = "\n".'<DATETIME>'.$sss_date_now.'T'.$sss_time_now.'</DATETIME>';
        fwrite($objFopen_opd2, $_head);

        $_head = "\n".'<SESSNO>'.$ssop_session_no.'</SESSNO>';
        fwrite($objFopen_opd2, $_head);

        $_head = "\n".'<RECCOUNT>'.$count_BillDispcount.'</RECCOUNT>';
        fwrite($objFopen_opd2, $_head);

        $_head = "\n".'</Header>';
        fwrite($objFopen_opd2, $_head);

        $_head = "\n".'<Dispensing>';
        fwrite($objFopen_opd2, $_head);

        $ssop_dispensing = DB::connection('mysql7')->select('   
            SELECT * from ssop_dispensing            
        ');

        foreach ($ssop_dispensing as $key => $value3) {
            $c1 = $value3->ProviderID;
            $c2 = $value3->DispID;
            $c3 = $value3->Invno;
            $c4 = $value3->HN;
            $c5 = $value3->PID;
            $c6 = $value3->Prescdt;
            $c7 = $value3->Dispdt;
            $c8 = $value3->Prescb;
            $c9 = $value3->Itemcnt;
            $c10 = number_format($value3->ChargeAmt,2);
            $c11 = number_format($value3->ClaimAmt,2);
            $c12 = number_format($value3->Paid,2);
            $c13 = number_format($value3->OtherPay,2);
            $c14= $value3->Reimburser;
            $c15 = $value3->BenefitPlan;
            $c16= $value3->DispeStat;           
            
            $strText3="\n".$c1."|".$c2."|".$c3."|".$c4."|".$c5."|".$c6."|".$c7."|".$c8."|".$c9."|".$c10."|".$c11."|".$c12."|".$c13."|".$c14."|".$c15."|".$c16."||";
            $ansitxt_pat3 = iconv('UTF-8', 'TIS-620', $strText3);
            fwrite($objFopen_opd2, $ansitxt_pat3);
        }        

        $_head = "\n".'</Dispensing>';
        fwrite($objFopen_opd2, $_head);

        $_head = "\n".'<DispensedItems>';
        fwrite($objFopen_opd2, $_head);

        $DispensedItems = DB::connection('mysql7')->select('   
            SELECT * from ssop_dispenseditems            
        ');

        foreach ($DispensedItems as $key => $value4) {
            $d1 = $value4->DispID;
            $d2 = $value4->PrdCat;
            $d3 = $value4->HospDrgID;
            $d4 = $value4->DrgID;
            // $d5 = $value4->PID;
            $d6 = $value4->dfsText;
            $d7 = $value4->Packsize;
            $d8 = $value4->sigCode;
            $d9 = $value4->sigText;
            $d10 = $value4->Quantity;
            $d11 = $value4->UnitPrice;
            $d12 = $value4->ChargeAmt;
            $d13 = $value4->ReimbPrice;
            $d14= $value4->ReimbAmt;
            // $d15 = $value4->BenefitPlan;
            // $d16= $value4->DispeStat;    
            $d17= $value4->ClaimCat;        
            
            $strText4="\n".$d1."|".$d2."|".$d3."|".$d4."||".$d6."|".$d7."|".$d8."|".$d9."|".$d10."|".$d11."|".$d12."|".$d13."|".$d14."|||".$d17."||";
            $ansitxt_pat4 = iconv('UTF-8', 'TIS-620', $strText4);
            fwrite($objFopen_opd2, $ansitxt_pat4);
        }      

        $_head = "\n".'</DispensedItems>';
        fwrite($objFopen_opd2, $_head);

        $_head = "\n".'</ClaimRec>';
        fwrite($objFopen_opd2, $_head);

        $_head = "\n";
        fwrite($objFopen_opd2, $_head);

        if($objFopen_opd2){
            echo "File BillTran writed."."<BR>";    
        }else{
            echo "File BillTran can not write";
        }
    
        fclose($objFopen_opd2);

        $md5file = md5_file($file_pat2,FALSE);

        $mdup = strtoupper($md5file);
      
        $objFopen_opd2 = fopen($file_pat2, 'a');

        $_head = '<?EndNote Checksum="'.$mdup.'"?>';
        fwrite($objFopen_opd2, $_head);

        $_head = "\n";
        fwrite($objFopen_opd2, $_head);

        if($objFopen_opd2){
            echo "File BillDisp MD5 writed."."<BR>";

        }else{
            echo "File BillDisp MD5 can not write";
        }

        fclose($objFopen_opd2);


        // ****************************************************************************************
  
        $opservices = DB::connection('mysql7')->select('      
            SELECT COUNT(*) as Invno             
            FROM ssop_opservices            
        '); 
        foreach ($opservices as $key => $value6) {
            $count_opservices = $value6->Invno;         
        }
        $op_head = '<?xml version="1.0" encoding="windows-874"?>';
        fwrite($objFopen_opd3, $op_head);

        $op_head = "\n".'<ClaimRec System="OP" PayPlan="SS" Version="0.93" Prgs="HS">';
        fwrite($objFopen_opd3, $op_head);

        $op_head = "\n".'<Header>';
        fwrite($objFopen_opd3, $op_head);

        $op_head = "\n".'<HCODE>10978</HCODE>';
        fwrite($objFopen_opd3, $op_head);

        $op_head = "\n".'<HNAME>โรงพยาบาลภูเขียวเฉลิมพระเกีรติ</HNAME>';
        $opd_head_ansi6 = iconv('UTF-8', 'TIS-620', $op_head);
        fwrite($objFopen_opd3, $opd_head_ansi6);

        $op_head = "\n".'<DATETIME>'.$sss_date_now.'T'.$sss_time_now.'</DATETIME>';
        fwrite($objFopen_opd3, $op_head);

        $op_head = "\n".'<SESSNO>'.$ssop_session_no.'</SESSNO>';
        fwrite($objFopen_opd3, $op_head);

        $op_head = "\n".'<RECCOUNT>'.$count_opservices.'</RECCOUNT>';
        fwrite($objFopen_opd3, $op_head);

        $op_head = "\n".'</Header>';
        fwrite($objFopen_opd3, $op_head);

        $op_head = "\n".'<OPServices>';
        fwrite($objFopen_opd3, $op_head);
        
        $opservices = DB::connection('mysql7')->select('   
            SELECT * from ssop_opservices            
        ');

    foreach ($opservices as $key => $valueO) {
        $e1 = $valueO->Invno;
        $e2 = $valueO->SvID;
        $e3 = $valueO->Class;
        $e4 = $valueO->Hcode;
        $e5 = $valueO->HN;
        $e6 = $valueO->PID;
        $e7 = $valueO->CareAccount;
        $e8 = $valueO->TypeServ;
        $e9 = $valueO->TypeIn;
        $e10 = $valueO->TypeOut;
        $e11 = $valueO->DTAppoint;
        $e12 = $valueO->SvPID;
        $e13 = $valueO->Clinic;
        $e14= $valueO->BegDT;
        $e15 = $valueO->EndDT;
        $e16= $valueO->LcCode;    
        $e17= $valueO->CodeSet;      
        $e18= $valueO->STDCode;
        $e19= $valueO->SvCharge;
        $e20= $valueO->Completion;
        $e21= $valueO->SvTxCode; 
        $e22= $valueO->ClaimCat;  
        
       
        $strTextO="\n".$e1."|".$e2."|".$e3."|".$e4."|".$e5."|".$e6."|".$e7."|".$e8."|".$e9."|".$e10."|".$e11."|".$e12."|".$e13."|".$e14."|".$e15."||||".$e19."|".$e20."||".$e22;
        $ansitxt_patO = iconv('UTF-8', 'TIS-620', $strTextO);
        fwrite($objFopen_opd3, $ansitxt_patO);
    }   
         
       

        $op_head = "\n".'</OPServices>';
        fwrite($objFopen_opd3, $op_head);

        $op_head = "\n".'<OPDx>';
        fwrite($objFopen_opd3, $op_head);

        $ssop_opdx_ = DB::connection('mysql7')->select('   
            SELECT * FROM ssop_opdx   
        ');      

        foreach ($ssop_opdx_ as $key => $valueO) {
            $f1 = $valueO->Class;
            $f2 = $valueO->SvID;
            $f3 = $valueO->SL;
            $f4 = $valueO->CodeSet;
            $f5 = $valueO->code;
            $f6 = $valueO->Desc; 
                       
            $strTextoo="\n".$f1."|".$f2."|".$f3."|".$f4."|".$f5."|".$f6;
            
            $ansitxt_patOo = iconv('UTF-8', 'TIS-620', $strTextoo);
            fwrite($objFopen_opd3, $ansitxt_patOo);
        }   

        $op_head = "\n".'</OPDx>';
        fwrite($objFopen_opd3, $op_head);

        $op_head = "\n".'</ClaimRec>';
        fwrite($objFopen_opd3, $op_head);

        $op_head = "\n";
        fwrite($objFopen_opd3, $op_head);

        if($objFopen_opd3){
            echo "File BillTran writed."."<BR>";    
        }else{
            echo "File BillTran can not write";
        }
    
        fclose($objFopen_opd3);

        $md5file = md5_file($file_pat3,FALSE);

        $mdup = strtoupper($md5file);
      
        $objFopen_opd3 = fopen($file_pat3, 'a');

        $op_head = '<?EndNote Checksum="'.$mdup.'"?>';
        fwrite($objFopen_opd3, $op_head);

        $op_head = "\n";
        fwrite($objFopen_opd3, $op_head);

        if($objFopen_opd3){
            echo "File BillDisp MD5 writed."."<BR>";

        }else{
            echo "File BillDisp MD5 can not write";
        }

        fclose($objFopen_opd3);
 
        // $pathdir = $folder."/";
        // $zipcreated = $folder.".zip";

    //     $newzip = new ZipArchive;

    //     $pathdir =  "C:/export/.$folder."."/";
    //     $zipcreated = "$folder.".".zip";

    //     $newzip = new ZipArchive;
    //     if($newzip -> open($zipcreated, ZipArchive::CREATE ) === TRUE) {
    //     $dir = opendir($pathdir);
    //     while($file = readdir($dir)) {
    //         if(is_file($pathdir.$file)) {
    //             $newzip -> addFile($pathdir.$file, $file);
    //         }
    //     }
    //     $newzip ->close();

    //    	if (file_exists($zipcreated)) {
    //         header('Content-Type: application/zip');
	//          header('Content-Disposition: attachment; filename="'.basename($zipcreated).'"');
	//          header('Content-Length: ' . filesize($zipcreated));

	//          flush();
	//          readfile($zipcreated);
	//          // delete file
	//          unlink($zipcreated);
            
    //         // Get the list of all of file names ลบไฟล์ในโฟลเดอทั้งหมด ทิ้งก่อน
    //         // in the folder. 
    //         $files = glob($pathdir . '/*'); 
              
    //         // Loop through the file list 
    //         foreach($files as $file) { 
                  
    //             // Check for file 
    //             if(is_file($file)) { 
                      
    //                 // Use unlink function to  
    //                 // delete the file. 
    //                 unlink($file); 
    //             } 
    //         }    
    //         if(rmdir($pathdir)){ // ลบ folder
            
    //         } 
    //     }
    // } 
            return redirect()->route('claim.ssop');
      
           
    }
    
    
    public function ssop_zip(Request $request)
    {     
        // $sss_date_now = date("Y-m-d");
        // $sss_time_now = date("H:i:s");
        // $maxid = Claim_ssop::max('ssop_session_no');
        // $ssop_session_no = $maxid+1;

        // #ตัดขีด, ตัด : ออก
        // $pattern_date = '/-/i';
        // $sss_date_now_preg = preg_replace($pattern_date, '', $sss_date_now);
        // $pattern_time = '/:/i';
        // $sss_time_now_preg = preg_replace($pattern_time, '', $sss_time_now);
        // #ตัดขีด, ตัด : ออก

        // $folder='10978_SSOPBIL_'.$ssop_session_no.'_01_'.$sss_date_now_preg.'-'.$sss_time_now_preg;
        // $pathdir =  "C:/export/".$folder."/";
        // $zipcreated = "$folder.".".zip";
          // $pathdir = $folder."/";
        // $zipcreated = $folder.".zip";
       
        $filename = Ssop_session::max('ssop_session_no');
        // dd($filename);
        $nzip = Ssop_session::where('ssop_session_no','=',$filename)->first();

        $namezip = $nzip->ssop_session_filename;
        // dd($namezip);
        $pathdir =  "C:/export/".$namezip."/";
        $zipcreated = $namezip.".zip";

        $newzip = new ZipArchive;
        if($newzip -> open($zipcreated, ZipArchive::CREATE ) === TRUE) {
        $dir = opendir($pathdir);
        while($file = readdir($dir)) {
            if(is_file($pathdir.$file)) {
                $newzip -> addFile($pathdir.$file, $file);
            }
        }
        $newzip ->close();

                if (file_exists($zipcreated)) {
                    header('Content-Type: application/zip');
                    header('Content-Disposition: attachment; filename="'.basename($zipcreated).'"');
                    header('Content-Length: ' . filesize($zipcreated));

                    flush();
                    readfile($zipcreated);
                    // delete file
                    unlink($zipcreated);
                    
                    // Get the list of all of file names ลบไฟล์ในโฟลเดอทั้งหมด ทิ้งก่อน
                    // in the folder. 
                    $files = glob($pathdir . '/*'); 
                    
                    // Loop through the file list 
                    foreach($files as $file) { 
                        
                        // Check for file 
                        if(is_file($file)) { 
                            
                            // Use unlink function to  
                            // delete the file. 
                            unlink($file); 
                        } 
                    } 
                    

                    // if(rmdir($pathdir)){ // ลบ folder ใน export
                    
                    // }
                    
                    return redirect()->route('claim.ssop');
                    
                }
        }
    }
    public function ssop_check(Request $request)
    {
        $datestart = $request->startdate;
        $dateend = $request->enddate; 
 
        $data['leave_month'] = DB::table('leave_month')->get();
        // dd($datestart);
        $sss_date_now = date("Y-m-d");
        $sss_time_now = date("H:i:s");
        $sesid_status = 'new'; #ส่งค่าสำหรับเงื่อนไขการบันทึกsession

        #sessionid เป็นค่าว่าง แสดงว่ายังไม่เคยส่งออก ต้องสร้างไอดีใหม่ จาก max+1
        $maxid = Claim_ssop::max('ssop_session_no');
        $ssop_session_no = $maxid+1;

        #ตัดขีด, ตัด : ออก
        $pattern_date = '/-/i';
        $sss_date_now_preg = preg_replace($pattern_date, '', $sss_date_now);
        $pattern_time = '/:/i';
        $sss_time_now_preg = preg_replace($pattern_time, '', $sss_time_now);
        #ตัดขีด, ตัด : ออก

        mkdir ('C:/export/'.'SSOP', 0777, true);
   
        header("Content-type: text/txt");
        header("Cache-Control: no-store, no-cache");
        header('Content-Disposition: attachment; filename="content.txt"');

        $file_name = "/BillTran".$sss_date_now_preg.".txt";
        // SELECT COUNT(*) from claim_ssop
        $ssop_count = DB::connection('mysql3')->select('      
            SELECT COUNT(DISTINCT o.vn) as VN
             
            FROM ssop_billtran 
           
        ');
        // AND op.income IN ("03","17","05")
        foreach ($ssop_count as $key => $valuecount) {
            $count = $valuecount->VN;
        }

        $file_pat = "C:/export/SSOP/BillTran".$sss_date_now_preg.".txt";
     
        $objFopen_opd = fopen($file_pat, 'w');
        $opd_head = '<?xml version="1.0" encoding="windows-874"?>';
        fwrite($objFopen_opd, $opd_head);

        $opd_head = "\n".'<ClaimRec System="OP" PayPlan="SS" Version="0.93">';
        fwrite($objFopen_opd, $opd_head);

        $opd_head = "\n".'<Header>';
        fwrite($objFopen_opd, $opd_head);

        $opd_head = "\n".'<HCODE>10978</HCODE>';
        fwrite($objFopen_opd, $opd_head);

        $opd_head = "\n".'<HNAME>โรงพยาบาลภูเขียวเฉลิมพระเกีรติ</HNAME>';
        $opd_head_ansi = iconv('UTF-8', 'TIS-620', $opd_head);
        fwrite($objFopen_opd, $opd_head_ansi);

        $opd_head = "\n".'<DATETIME>'.$sss_date_now.'T'.$sss_time_now.'</DATETIME>';
        fwrite($objFopen_opd, $opd_head);

        $opd_head = "\n".'<SESSNO>'.$ssop_session_no.'</SESSNO>';
        fwrite($objFopen_opd, $opd_head);

        $opd_head = "\n".'<RECCOUNT>'.$count.'</RECCOUNT>';
        fwrite($objFopen_opd, $opd_head);

        $opd_head = "\n".'</Header>';
        fwrite($objFopen_opd, $opd_head);
    
        $opd_head = "\n".'<BILLTRAN>';
        fwrite($objFopen_opd, $opd_head);

        $ssop_Billtran = DB::connection('mysql3')->select('   
            SELECT "01" AS "B1", "" AS "B2", CONCAT(o.vstdate,"T",o.vsttime) AS "B3", "10978" AS "B4", o.vn AS "B5"
			,"" AS "B6", o.hn AS "B7", "" AS "B8", ROUND(SUM(op.sum_price) ,2) AS "B9", "0.00" AS "B10"
			,"" AS "B11", "A" AS "B12", v.cid AS "B13"
			,CONCAT(pt.pname,pt.fname," ",pt.lname) AS "B14"
			,o.hospmain AS "B15", "80" AS "B16"
			,ROUND( SUM(op.sum_price) ,2) AS "B17"
			,"" AS "B18"
			,"0.00" AS "B19" 
            FROM ovst o 
			LEFT JOIN vn_stat v ON o.vn=v.vn
			LEFT JOIN opitemrece op ON o.vn=op.vn
			LEFT JOIN patient p ON o.hn=p.hn   
            LEFT OUTER JOIN pttype pt on pt.pttype = o.pttype     
            WHERE o.vstdate BETWEEN "'.$datestart.'" and "'.$dateend.'" 
            AND op.qty<>0 AND op.paidst="02"
            AND op.qty<>0             
            AND p.pcode ="A7"
            
        ');
        foreach ($ssop_Billtran as $key => $value2) {
            $b1 = $value2->B1;
            $b2 = $value2->B2;
            $b3 = $value2->B3;
            $b4 = $value2->B4;
            $b5 = $value2->B5;
            $b6 = $value2->B6;
            $b7 = $value2->B7;
            $b8 = $value2->B8;
            $b9 = $value2->B9;
            $b10 = $value2->B10;
            $b11 = $value2->B11;
            $b12 = $value2->B12;
            $b13 = $value2->B13;
            $b14= $value2->B14;
            $b15 = $value2->B15;
            $b16= $value2->B16;
            $b17= $value2->B17;
            $b18 = $value2->B18;
            $b19 = $value2->B19;
            $strText2="\n".$b1."|".$b2."|".$b3."|".$b4."|".$b5."|".$b6."|".$b7."|".$b8."|".$b9."|".$b10."|".$b11."|".$b12."|".$b13."|".$b14."|".$b15."|".$b16."|".$b17."|".$b18."|".$b19;
            $ansitxt_pat2 = iconv('UTF-8', 'TIS-620', $strText2);
            fwrite($objFopen_opd, $ansitxt_pat2);

        }
         

        $opd_head = "\n".'</BILLTRAN>';
        fwrite($objFopen_opd, $opd_head);
  
        $opd_head = "\n".'<BillItems>';
        fwrite($objFopen_opd, $opd_head);

        $ssop_items = DB::connection('mysql3')->select('   
            SELECT o.vn AS "S1"
            ,o.vstdate AS "S2"
            , ic.income_group AS "S3"
            , op.icode AS "S4",n.nhso_adp_code AS "S5", n.name AS "S6", op.qty AS "S7"
            , ROUND(op.unitprice,2) AS "S8"
            , ROUND(op.sum_price,2) AS "S9"
            , ROUND(op.unitprice,2) AS "S10"
            , ROUND(op.sum_price,2)  AS "S11"
            , o.vn AS "S12", "OP1" AS "S13"
                FROM ovst o 
                LEFT JOIN vn_stat v ON o.vn=v.vn
                LEFT JOIN opitemrece op ON o.vn=op.vn
                LEFT JOIN nondrugitems n ON n.icode=op.icode
                LEFT JOIN claim.income ic ON op.income=ic.income
                WHERE o.vstdate BETWEEN "'.$datestart.'" and "'.$dateend.'"

                AND op.qty<>0 AND op.paidst="02"
                ORDER BY op.income
                LIMIT 5000 
        
            ');
            foreach ($ssop_items as $key => $value) {
                $s1 = $value->S1;
                $s2 = $value->S2;
                $s3 = $value->S3;
                $s4 = $value->S4;
                $s5 = $value->S5;
                $s6 = $value->S6;
                $s7 = $value->S7;
                $s8 = $value->S8;
                $s9 = $value->S9;
                $s10 = $value->S10;
                $s11 = $value->S11;
                $s12 = $value->S12;
                $s13 = $value->S13;
                
                $strText="\n".$s1."|".$s2."|".$s3."|".$s4."|".$s5."|".$s6."|".$s7."|".$s8."|".$s9."|".$s10."|".$s11."|".$s12."|".$s13;
                $ansitxt_pat = iconv('UTF-8', 'TIS-620', $strText);
                fwrite($objFopen_opd, $ansitxt_pat);

            }



        // $ssop_data = DB::connection('mysql3')->select('   
        //     SELECT "10978" AS "S1" , o.vn AS "S2" , o.vn AS "S3", o.hn AS "S4", v.cid AS "S5"
        //     , CONCAT(o.vstdate,"T",o.vsttime) AS "S6" , CONCAT(o.vstdate,"T",o.vsttime) AS "S7"
        //     ,IFNULL( (SELECT licenseno FROM doctor WHERE code=o.doctor) ,"ว32434") AS "S8"
        //     ,(SELECT count(DISTINCT icode) FROM opitemrece WHERE vn=o.vn and income IN ("03","17","05") 
        //         AND qty <>0 ) AS "S9"
        //     ,ROUND( SUM(IF(op.income IN ("03","17","05"),op.sum_price,0)) ,2) AS "S10"
        //     ,"0" AS "S11"
        //     ,"0.00" AS "S12" 
        //     ,ROUND( SUM(IF(op.income IN ("03","17","05"),op.sum_price,0)) ,2) AS "S13"
        //     , "HP" AS "S14" , "SS" AS "S15" , "01" AS "S16" , " " AS "S17","" AS "S18"
        //     FROM ovst o 
        //     LEFT JOIN vn_stat v ON o.vn=v.vn
        //     LEFT JOIN opitemrece op ON o.vn=op.vn
        
        //     WHERE v.vstdate BETWEEN "'.$datestart.'" and "'.$dateend.'"

        //     AND op.income IN ("03","17","05") AND op.qty<>0 AND op.paidst="02"
        //     GROUP BY o.vn
        //     LIMIT 5000 
            
        // ');
        // foreach ($ssop_data as $key => $value) {
        //     $s1 = $value->S1;
        //     $s2 = $value->S2;
        //     $s3 = $value->S3;
        //     $s4 = $value->S4;
        //     $s5 = $value->S5;
        //     $s6 = $value->S6;
        //     $s7 = $value->S7;
        //     $s8 = $value->S8;
        //     $s9 = $value->S9;
        //     $s10 = $value->S10;
        //     $s11 = $value->S11;
        //     $s12 = $value->S12;
        //     $s13 = $value->S13;
        //     $s14= $value->S14;
        //     $s15 = $value->S15;
        //     $s16= $value->S16;
        //     $s17= $value->S17;
        //     $s18 = $value->S18;
       
        //     $strText="\n".$s1."|".$s2."|".$s3."|".$s4."|".$s5."|".$s6."|".$s7."|".$s8."|".$s9."|".$s10."|".$s11."|".$s12."|".$s13."|".$s14."|".$s15."|".$s16."|".$s17."|".$s18;
        //     $ansitxt_pat = iconv('UTF-8', 'TIS-620', $strText);
        //     fwrite($objFopen_opd, $ansitxt_pat);

        // }
  
        $opd_head = "\n".'</BillItems>';
        fwrite($objFopen_opd, $opd_head);

        $opd_head = "\n".'</ClaimRec>';
        fwrite($objFopen_opd, $opd_head);

        $opd_head = "\n";
        fwrite($objFopen_opd, $opd_head);

        if($objFopen_opd){
            echo "File BillTran writed."."<BR>";
    
        }else{
            echo "File BillTran can not write";
        }
    
        fclose($objFopen_opd);

        $md5file = md5_file($file_pat,FALSE);

        $mdup = strtoupper($md5file);
      
        $objFopen_opd = fopen($file_pat, 'a');

        $opd_head = '<?EndNote Checksum="'.$mdup.'"?>';
        fwrite($objFopen_opd, $opd_head);

        $opd_head = "\n";
        fwrite($objFopen_opd, $opd_head);

        if($objFopen_opd){
            echo "File BillDisp MD5 writed."."<BR>";

        }else{
            echo "File BillDisp MD5 can not write";
        }

        fclose($objFopen_opd);


        
        
        // foreach ($ssop_data as $key => $value) {
        //     $strText="\n".$value->S1['1']."|".$value->S2['2']."|".$value->S3['3']."|".$value->S4['4']."|".$value->S5['5']."|".$value->S6['6']."|".$value->S7['7']."|".$value->S8['8']."|".$value->S9['9']."|".$value->S10['10']."|".$value->S11['11']."|".$value->S12['12']."|".$value->S13['13']."|".$value->S14['14']."|".$value->S15['15']."|".$value->S16['16']."|".$value->S17['17']."|".$value->S18['18'];
        //     $ansitxt_pat = iconv('UTF-8', 'TIS-620', $strText);
        //     fwrite($objFopen_opd, $ansitxt_pat);          
        // }
        $opd_head = "\n".'</Dispensing>';
        fwrite($objFopen_opd, $opd_head);
       
        fclose($objFopen_opd);
    
        // if(rmdir($pathdir)){ // ลบ folder
        //     print "<script language = 'JavaScript'>\n";
        //     print "window.location='success.php'"; 
        //     print "</script>\n";
        //     }


        return view('claim.ssop',$data,[
            'start'       => $datestart,
            'end'         => $dateend, 
        ]);
    }
 
    public function acc_checksit(Request $request)
    {
        $datestart = $request->startdate;
        $dateend = $request->enddate;
        $date = date('Y-m-d');

 
        $data_sit = DB::connection('mysql8')->select('
            SELECT * FROM pang_stamp_temp
            WHERE vstdate BETWEEN "'.$date.'" AND "'.$date.'" 
        '); 
        //  WHERE vstdate BETWEEN "'.$datestart.'" AND "'.$dateend.'" 
        return view('claim.acc_checksit ',[            
            'data_sit'    => $data_sit, 
            'start'     => $datestart, 
            'end'        => $dateend,
            // 'person_id'    => $person_id            
        ]);
    }

    public function acc_checksit_spsch(Request $request)
    {
        $datestart = $request->startdate;
        $dateend = $request->enddate;
        // $date = date('Y-m-d');
        //  dd($date);
        // $contents = file('D:\UCAuthenticationMX\nhso_token.txt', FILE_SKIP_EMPTY_LINES|FILE_IGNORE_NEW_LINES);
        // foreach($contents as $line) {  
        // }
        // $chars = preg_split('//', $line, -1, PREG_SPLIT_NO_EMPTY);
        // $output = Arr::sort($chars,2);

        // $data['data17'] = $chars['17']; $data['data18'] = $chars['18']; $data['data19'] = $chars['19']; $data['data20'] = $chars['20'];
        // $data['data21'] = $chars['21']; $data['data22'] = $chars['22']; $data['data23'] = $chars['23']; $data['data24'] = $chars['24'];
        // $data['data25'] = $chars['25']; $data['data26'] = $chars['26']; $data['data27'] = $chars['27']; $data['data28'] = $chars['28'];
        // $data['data29'] = $chars['29']; $data['data30'] = $chars['30']; $data['data31'] = $chars['31']; $data['data32'] = $chars['32'];

        // $token_ = $chars['17'].''.$data['data18'].''.$data['data19'].''.$data['data20'].''.$data['data21'].''.$data['data22'].''.$data['data23'].''.$data['data24'].''.$data['data25'].''.$data['data26'].''.$data['data27']
        // .''.$data['data28'].''.$data['data29'].''.$data['data30'].''.$data['data31'].''.$data['data32'];
       
        $token_data = DB::connection('mysql7')->select('
            SELECT cid,token FROM ssop_token 
        '); 
        foreach ($token_data as $key => $valuetoken) {
            $cid_ = $valuetoken->cid;
            $token_ = $valuetoken->token;
        }

        $event = array(); 
        $data_sit = DB::connection('mysql8')->select('
            SELECT vn,cid,hn,an,vstdate,pang_stamp,pttype,check_sit_subinscl,pttype_stamp FROM pang_stamp_temp
            WHERE vstdate BETWEEN "'.$datestart.'" AND "'.$dateend.'" 
           
            AND pttype IN ("O1","O2","O3","O4","O5")
        '); 
        // dd($data_sit);
        // dd($data_sit['5']);

        foreach ($data_sit as $item) {
            // dd($item->cid);
            // $cid = $item->cid;
            $event[] = [
                'cid' => $item->cid, 
                'vn' => $item->vn, 
                'vstdate' => $item->vstdate 
            ];
            // dd($cid);  
        }

        // dd($event);
        // dd($event['5']);
        foreach ($event as $key => $value5) {
            $pids = $value5['cid'];
            $vn = $value5['vn'];
            $vstdate = $value5['vstdate'];

            // dd($pids);

            $client = new SoapClient("http://ucws.nhso.go.th/ucwstokenp1/UCWSTokenP1?wsdl",
                array(
                    "uri" => 'http://ucws.nhso.go.th/ucwstokenp1/UCWSTokenP1?xsd=1',
                                    "trace"      => 1,    
                                    "exceptions" => 0,    
                                    "cache_wsdl" => 0 
                    )
                );
                $params = array(
                    'sequence' => array(
                        "user_person_id" => "$cid_",
                        "smctoken" => "$token_",
                        "person_id" => "$pids"
                )
            ); 
            $contents = $client->__soapCall('searchCurrentByPID',$params);            
       
            // dd($contents);
            foreach ($contents as $key => $value) { 
                // isset( $person_id) ? $person_id = $person_id: $person_id = "";

                isset( $subinscl) ? $subinscl = $subinscl : $subinscl = "";
                isset( $maininscl ) ? $maininscl = $maininscl : $maininscl = "";
                isset( $hmain ) ? $hmain = $hmain : $hmain = "";

                    // $subinscl           = $value->subinscl;   
                    // $maininscl          = $value->maininscl;
                    // $hmain              = $value->hmain;

                // $maininscl_name           = $value->maininscl_name;  

                // dd($vn);   

                // if ($subinscl == "") {
                    Pang_stamp_temp::where('vn', $vn)
                    // ->where('check_sit_subinscl','=',null) 
                    ->update([ 
                        'check_sit_subinscl'    => $maininscl,
                        'pttype_stamp'          => $maininscl.'("'.$hmain.'" )'.$vstdate
                    ]);
                // } else {
                //     Pang_stamp_temp::where('vn', $vn)
                //     // ->where('pttype_stamp','=',null) 
                //     ->update([ 
                //         'check_sit_subinscl'    => $maininscl,
                //         'pttype_stamp'          => $subinscl.'( )'.$vstdate
                //     ]);
                // }
                
                
            }
        }
                   
        // $output4 = Arr::sort($data_sit); 
        // dd($output4['5']);
        // foreach ($output4 as $key => $value1) {
        //     $pid = $value1->cid; 
        //     $vn = $value1->vn;
        //     dd($pid);
        //     $client = new SoapClient("http://ucws.nhso.go.th/ucwstokenp1/UCWSTokenP1?wsdl",
        //         array(
        //             "uri" => 'http://ucws.nhso.go.th/ucwstokenp1/UCWSTokenP1?xsd=1',
        //                             "trace"      => 1,    
        //                             "exceptions" => 0,    
        //                             "cache_wsdl" => 0 
        //             )
        //         );
        //         $params = array(
        //             'sequence' => array(
        //                 "user_person_id" => "$cid_",
        //                 "smctoken" => "$token_",
        //                 "person_id" => "$pid",
        //         )
        //     ); 
        // }
               
        // $result = $client->__soapCall('searchCurrentByPID',$params);
        // dd($result);             
        // dd($fname);
            // }
        return view('claim.acc_checksit_spsch ',[            
            // 'maininscl'    => $maininscl, 
            'subinscl'     => $subinscl, 
            'start'        => $datestart,
            'end'          => $dateend,
            // 'person_id'    => $person_id,
            // 'result'       => $result ,
            'data_sit'     => $data_sit          
        ]);
    }


}
