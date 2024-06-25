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
// use Illuminate\Support\Facades\File;
use DataTables;
use Intervention\Image\ImageManagerStatic as Image;
// use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\OtExport;
// use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Department;
use App\Models\Departmentsub;
use App\Models\Departmentsubsub;

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
use App\Models\Aipn_stm;
use App\Models\Status;
use App\Models\Aipn_ipdx;
use App\Models\Aipn_ipop;
use App\Models\Aipn_session;
use App\Models\Aipn_billitems;
use App\Models\Aipn_ipadt;
use App\Models\Check_sit;
use App\Models\Stm;

use App\Models\D_export_ucep;
use App\Models\Dtemp_hosucep;
use App\Models\D_ucep;
use App\Models\D_ins;
use App\Models\D_pat;
use App\Models\D_opd;
use App\Models\D_orf;
use App\Models\D_odx;
use App\Models\D_cht;
use App\Models\D_cha;
use App\Models\D_oop;
use App\Models\Tempexport;
use App\Models\D_adp;
use App\Models\D_dru;
use App\Models\D_idx;
use App\Models\D_iop;
use App\Models\D_ipd;
use App\Models\D_aer;
use App\Models\D_irf;
use App\Models\Tempexport_ofc401;
use App\Models\D_export_ofc401;
use App\Models\D_query;

use Auth;
use ZipArchive;
use Storage;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use PhpParser\Node\Stmt\If_;
use Stevebauman\Location\Facades\Location;
use SoapClient;
use SplFileObject;
use File;
use Illuminate\Filesystem\Filesystem;


class Ofcopd401Controller extends Controller
{
    public function ofc(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;

        if ($startdate != '') {
            D_export_ofc401::truncate();
            // Dtemp_hosucep::truncate();
            D_ins::truncate();
            Tempexport_ofc401::truncate();
            D_adp::truncate();
            $data = DB::connection('mysql3')->select('
                    SELECT v.vn,o.an,v.cid,v.hn,
                    concat(pt.pname,pt.fname," ",pt.lname) ptname
                    ,v.vstdate,ptt.pttype  ,rd.sss_approval_code AS "Apphos",v.inc04 as xray,
                    rd.amount AS pricehos 
                    ,group_concat(distinct hh.appr_code,":",hh.transaction_amount,"/") AS AppKTB 
                    ,GROUP_CONCAT(DISTINCT ov.icd10 order by ov.diagtype) AS icd10 
                    FROM vn_stat v
                    LEFT JOIN patient pt ON v.hn=pt.hn
                    LEFT JOIN ovstdiag ov ON v.vn=ov.vn
                    LEFT JOIN ovst o ON v.vn=o.vn
                    LEFT JOIN opdscreen op ON v.vn = op.vn
                    LEFT JOIN pttype ptt ON v.pttype=ptt.pttype 
                    LEFT JOIN rcpt_debt rd ON v.vn=rd.vn
                    left join hos.hpc11_ktb_approval hh on hh.pid = pt.cid and hh.transaction_date = v.vstdate 
                    LEFT JOIN ipt ii on ii.vn = v.vn

                        where v.vstdate BETWEEN "'.$startdate.'" AND "'.$enddate.'"
                        AND v.pttype in ("o1","o2","o3","o4","o5")
                        AND v.pttype not in ("of","fo") 
                        and v.uc_money >"0"
                        AND ii.an is null
                        AND v.pdx <> ""
                        GROUP BY v.vn;
            ');
            // inner join claim.dtemp_hosucep zz on zz.an = o.an
            foreach ($data as $va2) {
                $date = date('Y-m-d');
                D_export_ofc401::insert([
                    'hn'                       => $va2->hn,
                    'an'                       => $va2->an,
                    'vn'                       => $va2->vn,
                    'cid'                      => $va2->cid,
                    'fullname'                 => $va2->ptname, 
                    'vstdate'                  => $va2->vstdate,
                    'icd10'                    => $va2->icd10,
                    'pttype'                   => $va2->pttype,
                    'Apphos'                   => $va2->Apphos,
                    'Appktb'                   => $va2->AppKTB,
                    'pricehos'                 => $va2->pricehos,
                ]);
                Tempexport_ofc401::insert([
                    'hn'                       => $va2->hn,
                    'an'                       => $va2->an,
                    'vn'                       => $va2->vn,
                    'cid'                      => $va2->cid,
                    'send_date'                => $date,
                ]);
            }
            
            //INS
            $data = DB::connection('mysql3')->select('
                    SELECT
                        "" d_ins_id
                        ,v.hn HN
                        ,if(i.an is null,p.hipdata_code,pp.hipdata_code) INSCL
                        ,if(i.an is null,p.pcode,pp.pcode) SUBTYPE
                        ,v.cid CID
                        ,DATE_FORMAT(if(i.an is null,v.pttype_begin,ap.begin_date), "%Y%m%d")  DATEIN
                        ,DATE_FORMAT(if(i.an is null,v.pttype_expire,ap.expire_date), "%Y%m%d")   DATEEXP
                        ,if(i.an is null,v.hospmain,ap.hospmain) HOSPMAIN
                        ,if(i.an is null,v.hospsub,ap.hospsub) HOSPSUB
                        ,"" GOVCODE
                        ,"" GOVNAME
                        ,ifnull(if(i.an is null,vp.claim_code or vp.auth_code,ap.claim_code),r.sss_approval_code) PERMITNO
                        ,"" DOCNO
                        ,"" OWNRPID
                        ,"" OWNRNAME
                        ,i.an AN
                        ,v.vn SEQ
                        ,"" SUBINSCL
                        ,"" RELINSCL
                        ,"" HTYPE
                        ,"" created_at
                        ,"" updated_at
                        from vn_stat v
                        LEFT JOIN pttype p on p.pttype = v.pttype
                        LEFT JOIN ipt i on i.vn = v.vn
                        LEFT JOIN pttype pp on pp.pttype = i.pttype
                        left join ipt_pttype ap on ap.an = i.an
                        left join visit_pttype vp on vp.vn = v.vn
                        LEFT JOIN rcpt_debt r on r.vn = v.vn
                        left join patient px on px.hn = v.hn
                        left join claim.d_export_ofc401 x on x.vn = v.vn
                    where x.active="N";
            ');
            foreach ($data as $va1) {
                $date = date('Y-m-d');
                D_ins::insert([
                    'HN'                     => $va1->HN,
                    'INSCL'                  => $va1->INSCL,
                    'SUBTYPE'                => $va1->SUBTYPE,
                    'CID'                    => $va1->CID,
                    'DATEIN'                 => $va1->DATEIN,
                    'DATEEXP'                => $va1->DATEEXP,
                    'HOSPMAIN'               => $va1->HOSPMAIN,
                    'HOSPSUB'                => $va1->HOSPSUB,
                    'GOVCODE'                => $va1->GOVCODE,
                    'GOVNAME'                => $va1->GOVNAME,
                    'PERMITNO'               => $va1->PERMITNO,
                    'DOCNO'                  => $va1->DOCNO,
                    'OWNRPID'                => $va1->OWNRPID,
                    'OWNRNAME'               => $va1->OWNRNAME,
                    'AN'                     => $va1->AN,
                    'SEQ'                    => $va1->SEQ,
                    'SUBINSCL'               => $va1->SUBINSCL,
                    'RELINSCL'               => $va1->RELINSCL,
                    'HTYPE'                  => $va1->HTYPE
                ]);
            }
            //ADP
            $data_adp = DB::connection('mysql3')->select('
                    SELECT HN,AN,DATEOPD,TYPE,CODE,sum(QTY) QTY,RATE,SEQ,"" "" a1,"" a2,"" a3,"" a4,"0" a5,"" a6,"0" a7 ,"" a8,"" TMLTCODE
                    ,"" STATUS1,"" BI,"" CLINIC,"" ITEMSRC,"" PROVIDER,"" GLAVIDA,"" GA_WEEK,"" DCIP,"0000-00-00" LMP,SP_ITEM
                    from (SELECT v.hn HN
                    ,if(v.an is null,"",v.an) AN
                    ,DATE_FORMAT(v.rxdate,"%Y%m%d") DATEOPD
                    ,n.nhso_adp_type_id TYPE
                    ,n.nhso_adp_code CODE
                    ,sum(v.QTY) QTY
                    ,round(v.unitprice,2) RATE
                    ,if(v.an is null,v.vn,"") SEQ
                    ,"" a1,"" a2,"" a3,"" a4,"0" a5,"" a6,"0" a7 ,"" a8
                    ,"" TMLTCODE,"" STATUS1,"" BI,"" CLINIC,"" ITEMSRC
                    ,"" PROVIDER,"" GLAVIDA,"" GA_WEEK,"" DCIP,"0000-00-00" LMP
                    ,(SELECT "01" from claim.dtemp_hosucep where an = v.an and icode = v.icode and rxdate = v.rxdate and rxtime = v.rxtime  limit 1) SP_ITEM
                    from opitemrece v
                    inner JOIN nondrugitems n on n.icode = v.icode and n.nhso_adp_code is not null
                    left join ipt i on i.an = v.an
                    AND i.an is not NULL
                    left join claim.tempexport_ofc401 x on x.vn = i.vn
                    where x.active="N"
                    AND n.icode <> "XXXXXX"
                    GROUP BY i.vn,n.nhso_adp_code,rate) a
                    GROUP BY an,CODE,rate
                    UNION
                    SELECT HN,AN,DATEOPD,TYPE,CODE,sum(QTY) QTY,RATE,SEQ,"" a1,"" a2,"" a3,"" a4,"0" a5,"" a6,"0" a7 ,"" a8,"" TMLTCODE
                    ,"" STATUS1,"" BI,"" CLINIC,"" ITEMSRC,"" PROVIDER,"" GLAVIDA,"" GA_WEEK,"" DCIP,"0000-00-00" LMP,"" SP_ITEM
                    from
                    (SELECT v.hn HN
                    ,if(v.an is null,"",v.an) AN
                    ,DATE_FORMAT(v.vstdate,"%Y%m%d") DATEOPD
                    ,n.nhso_adp_type_id TYPE
                    ,n.nhso_adp_code CODE
                    ,sum(v.QTY) QTY
                    ,round(v.unitprice,2) RATE
                    ,if(v.an is null,v.vn,"") SEQ,"" a1,"" a2,"" a3,"" a4,"0" a5,"" a6,"0" a7 ,"" a8
                    ,"" TMLTCODE,"" STATUS1,"" BI,"" CLINIC,"" ITEMSRC,"" PROVIDER,"" GLAVIDA,"" GA_WEEK,"" DCIP,"0000-00-00" LMP,"" SP_ITEM
                    from opitemrece v
                    inner JOIN nondrugitems n on n.icode = v.icode and n.nhso_adp_code is not null
                    left join ipt i on i.an = v.an
                    left join claim.tempexport_ofc401 x on x.vn = v.vn
                    where x.active="N"
                    AND n.icode <> "XXXXXX"
                    AND i.an is NULL
                    GROUP BY v.vn,n.nhso_adp_code,rate) b
                    GROUP BY seq,CODE,rate;
            ');
            foreach ($data_adp as $va4) {
                d_adp::insert([
                    'HN'                   => $va4->HN,
                    'AN'                   => $va4->AN,
                    'DATEOPD'              => $va4->DATEOPD,
                    'TYPE'                 => $va4->TYPE,
                    'CODE'                 => $va4->CODE,
                    'QTY'                  => $va4->QTY,
                    'RATE'                 => $va4->RATE,
                    'SEQ'                  => $va4->SEQ,
                    'CAGCODE'              => $va4->a1,
                    'DOSE'                 => $va4->a2,
                    'CA_TYPE'              => $va4->a3,
                    'SERIALNO'             => $va4->a4,
                    'TOTCOPAY'             => $va4->a5,
                    'USE_STATUS'           => $va4->a6,
                    'TOTAL'                => $va4->a7,
                    'QTYDAY'               => $va4->a8,
                    'TMLTCODE'             => $va4->TMLTCODE,
                    'STATUS1'              => $va4->STATUS1,
                    'BI'                   => $va4->BI,
                    'CLINIC'               => $va4->CLINIC,
                    'ITEMSRC'              => $va4->ITEMSRC,
                    'PROVIDER'             => $va4->PROVIDER,
                    'GLAVIDA'              => $va4->GLAVIDA,
                    'GA_WEEK'              => $va4->GA_WEEK,
                    'DCIP'                 => $va4->DCIP,
                    'LMP'                  => $va4->LMP,
                    'SP_ITEM'              => $va4->SP_ITEM,
                ]);
            }
            d_adp::where('CODE','=','XXXXXX')->delete();

            // $ucep = D_export_ucep::get();
            // $ucep = DB::connection('mysql3')->select('
            //     SELECT o.vn,o.an,o.hn,p.cid,o.vstdate,o.pttype
            //     ,DATE_FORMAT(o.vstdate,"%Y%m%d") DATEOPD                     
            //             from ovst o
            //             left outer join an_stat a on a.an = o.an 
            //             left outer join patient p on o.hn=p.hn
            //             left outer join er_regist g on g.vn=o.vn  
            //             left outer join pttype pt on pt.pttype = a.pttype

            //             where a.dchdate BETWEEN "'.$startdate.'" AND "'.$enddate.'"
            //             AND g.er_emergency_level_id IN("1","2")
            //             AND o.an <>"" and pt.hipdata_code ="UCS"
            //             group by o.vn;
            // ');
            // foreach ($ucep as $key => $v) {
            //     d_adp::insert([
            //         'HN'                   => $v->hn,
            //         'AN'                   => $v->an,
            //         'DATEOPD'              => $v->DATEOPD,
            //         'TYPE'                 => '5',
            //         'CODE'                 => 'UCEP24',
            //         'QTY'                  => '1',
            //         'RATE'                 => '0',
            //         'SEQ'                  => $v->vn,
            //         'CAGCODE'              => "",
            //         'DOSE'                 => "",
            //         'CA_TYPE'              => "",
            //         'SERIALNO'             => "",
            //         'TOTCOPAY'             => '0',
            //         'USE_STATUS'           => "",
            //         'TOTAL'                => '0',
            //         'QTYDAY'               => "",
            //         'TMLTCODE'             => "",
            //         'STATUS1'              => "",
            //         'BI'                   => "",
            //         'CLINIC'               => "",
            //         'ITEMSRC'              => "",
            //         'PROVIDER'             => "",
            //         'GLAVIDA'              => "",
            //         'GA_WEEK'              => "",
            //         'DCIP'                 => "",
            //         'LMP'                  => "",
            //         'SP_ITEM'              => "",
            //     ]);
            // }

        } else {
            $data = DB::connection('mysql3')->select('
                    SELECT v.vn,o.an,v.cid,v.hn,
                    concat(pt.pname,pt.fname," ",pt.lname) ptname
                    ,v.vstdate,ptt.pttype  ,rd.sss_approval_code AS "Apphos",v.inc04 as xray,
                    rd.amount AS pricehos 
                    ,group_concat(distinct hh.appr_code,":",hh.transaction_amount,"/") AS AppKTB 
                    ,GROUP_CONCAT(DISTINCT ov.icd10 order by ov.diagtype) AS icd10 
                    FROM vn_stat v
                    LEFT JOIN patient pt ON v.hn=pt.hn
                    LEFT JOIN ovstdiag ov ON v.vn=ov.vn
                    LEFT JOIN ovst o ON v.vn=o.vn
                    LEFT JOIN opdscreen op ON v.vn = op.vn
                    LEFT JOIN pttype ptt ON v.pttype=ptt.pttype 
                    LEFT JOIN rcpt_debt rd ON v.vn=rd.vn
                    left join hos.hpc11_ktb_approval hh on hh.pid = pt.cid and hh.transaction_date = v.vstdate 
                    LEFT JOIN ipt ii on ii.vn = v.vn

                        where v.vstdate BETWEEN "'.$startdate.'" AND "'.$enddate.'"
                        AND v.pttype in ("o1","o2","o3","o4","o5")
                        AND v.pttype not in ("of","fo") 
                        and v.uc_money >"0"
                        AND ii.an is null
                        AND v.pdx <> ""
                        GROUP BY v.vn;
            ');
        }
        // DB::table('acc_stm_ucs_excel')->insert($data);
        $data['data_show']     = D_export_ucep::get();
        $data['data_ins']      = D_ins::get();
        $data['data_pat']      = D_pat::get();
        $data['data_opd']      = D_opd::get();
        return view('claim.ofc',$data,[
            'startdate'        => $startdate,
            'enddate'          => $enddate,
        ]);
    }
    public function ofc_pull_a(Request $request)
    {
            D_opd::truncate();
            D_oop::truncate();
            D_orf::truncate();
            //D_opd
            $data_opd = DB::connection('mysql3')->select('
                    SELECT "" d_opd_id
                    ,v.hn HN
                    ,v.spclty CLINIC
                    ,DATE_FORMAT(v.vstdate,"%Y%m%d") DATEOPD
                    ,concat(substr(o.vsttime,1,2),substr(o.vsttime,4,2)) TIMEOPD
                    ,v.vn SEQ
                    ,"1" UUC
                    ,"" created_at
                    ,"" updated_at
                    from vn_stat v
                    LEFT JOIN ovst o on o.vn = v.vn
                    LEFT JOIN pttype p on p.pttype = v.pttype
                    LEFT JOIN ipt i on i.vn = v.vn
                    LEFT JOIN patient pt on pt.hn = v.hn
                    INNER JOIN claim.d_export_ucep x on x.vn = v.vn
                    where x.active="N";
            ');
            foreach ($data_opd as $va3) {
                D_opd::insert([
                    'HN'                  => $va3->HN,
                    'CLINIC'              => $va3->CLINIC,
                    'DATEOPD'             => $va3->DATEOPD,
                    'TIMEOPD'             => $va3->TIMEOPD,
                    'SEQ'                 => $va3->SEQ,
                    'UUC'                 => $va3->UUC
                ]);
            }
            //D_orf
            $data_orf = DB::connection('mysql3')->select('
                    SELECT
                    "" d_orf_id
                    ,v.hn HN
                    ,DATE_FORMAT(v.vstdate,"%Y%m%d") DATEOPD
                    ,v.spclty CLINIC
                    ,ifnull(r1.refer_hospcode,r2.refer_hospcode) REFER
                    ,"0100" REFERTYPE
                    ,v.vn SEQ
                    ,"" created_at
                    ,"" updated_at
                    from vn_stat v
                    LEFT JOIN ovst o on o.vn = v.vn
                    LEFT JOIN referin r1 on r1.vn = v.vn
                    LEFT JOIN referout r2 on r2.vn = v.vn
                    INNER JOIN claim.d_export_ucep x on x.vn = v.vn
                    where x.active="N"
                    and (r1.vn is not null or r2.vn is not null);
            ');
            foreach ($data_orf as $va4) {
                D_orf::insert([
                    'HN'                => $va4->HN,
                    'DATEOPD'           => $va4->DATEOPD,
                    'CLINIC'            => $va4->CLINIC,
                    'REFER'             => $va4->REFER,
                    'REFERTYPE'         => $va4->REFERTYPE,
                    'SEQ'               => $va4->SEQ
                ]);
            }
            //D_oop
            $data_oop = DB::connection('mysql3')->select('
                    SELECT "" d_oop_id
                    ,v.hn HN
                    ,DATE_FORMAT(v.vstdate,"%Y%m%d") DATEOPD
                    ,v.spclty CLINIC
                    ,o.icd10 OPER
                    ,if(d.licenseno="","-99999",d.licenseno) DROPID
                    ,pt.cid PERSON_ID
                    ,v.vn SEQ
                    ,"" created_at
                    ,"" updated_at
                    from vn_stat v
                    LEFT JOIN ovstdiag o on o.vn = v.vn
                    LEFT JOIN patient pt on v.hn=pt.hn
                    LEFT JOIN doctor d on d.`code` = o.doctor
                    LEFT JOIN icd9cm1 i on i.code = o.icd10
                    INNER JOIN claim.d_export_ucep x on x.vn = v.vn
                    where x.active="N";
            ');
            foreach ($data_oop as $va6) {
                D_oop::insert([
                    'HN'                => $va6->HN,
                    'DATEOPD'           => $va6->DATEOPD,
                    'CLINIC'            => $va6->CLINIC,
                    'OPER'              => $va6->OPER,
                    'DROPID'            => $va6->DROPID,
                    'PERSON_ID'         => $va6->PERSON_ID,
                    'SEQ'               => $va6->SEQ,
                ]);
            }

        return redirect()->back();
    }
    public function ofc_pull_b(Request $request)
    {
        D_odx::truncate();
        D_dru::truncate();
        D_idx::truncate();
        D_ipd::truncate();
        D_irf::truncate();

        $data_odx = DB::connection('mysql3')->select('
            SELECT
                "" d_odx_id
                ,v.hn HN
                ,DATE_FORMAT(v.vstdate,"%Y%m%d") DATEDX
                ,v.spclty CLINIC
                ,o.icd10 DIAG
                ,o.diagtype DXTYPE
                ,if(d.licenseno="","-99999",d.licenseno) DRDX
                ,v.cid PERSON_ID
                ,v.vn SEQ
                ,"" created_at
                ,"" updated_at
                from vn_stat v
                LEFT JOIN ovstdiag o on o.vn = v.vn
                LEFT JOIN doctor d on d.`code` = o.doctor
                LEFT JOIN icd101 i on i.code = o.icd10
                LEFT JOIN claim.d_export_ucep x on x.vn = v.vn
                where x.active="N";
        ');

        foreach ($data_odx as $va5) {
            D_odx::insert([
                'HN'                => $va5->HN,
                'DATEDX'            => $va5->DATEDX,
                'CLINIC'            => $va5->CLINIC,
                'DIAG'              => $va5->DIAG,
                'DXTYPE'            => $va5->DXTYPE,
                'DRDX'              => $va5->DRDX,
                'PERSON_ID'         => $va5->PERSON_ID,
                'SEQ'               => $va5->SEQ,
            ]);
        }

        $data_dru = DB::connection('mysql3')->select('
                SELECT "" d_dru_id,vv.hcode HCODE
                ,v.hn HN
                ,v.an AN
                ,vv.spclty CLINIC
                ,vv.cid PERSON_ID
                ,DATE_FORMAT(v.vstdate,"%Y%m%d") DATE_SERV
                ,d.icode DID
                ,concat(d.`name`," ",d.strength," ",d.units) DIDNAME
                ,sum(v.qty) AMOUNT
                ,round(v.unitprice,2) DRUGPRIC
                ,"0.00" DRUGCOST
                ,d.did DIDSTD
                ,d.units UNIT
                ,concat(d.packqty,"x",d.units) UNIT_PACK
                ,v.vn SEQ
                ,oo.presc_reason DRUGREMARK
                ,"" PA_NO
                ,"" TOTCOPAY
                ,if(v.item_type="H","2","1") USE_STATUS
                ,"" TOTAL,"" a1,""  a2,"" created_at,"" updated_at
                from opitemrece v
                LEFT JOIN drugitems d on d.icode = v.icode
                LEFT JOIN vn_stat vv on vv.vn = v.vn
                LEFT JOIN ovst_presc_ned oo on oo.vn = v.vn and oo.icode=v.icode
                LEFT JOIN claim.tempexport x on x.vn = v.vn
                where x.active="N"
                and d.did is not null
                GROUP BY v.vn,did

                UNION all

                SELECT "" d_dru_id,pt.hcode HCODE
                ,v.hn HN
                ,v.an AN
                ,v1.spclty CLINIC
                ,pt.cid PERSON_ID
                ,DATE_FORMAT((v.vstdate),"%Y%m%d") DATE_SERV
                ,d.icode DID
                ,concat(d.`name`," ",d.strength," ",d.units) DIDNAME
                ,sum(v.qty) AMOUNT
                ,round(v.unitprice,2) DRUGPRIC
                ,"0.00" DRUGCOST
                ,d.did DIDSTD
                ,d.units UNIT
                ,concat(d.packqty,"x",d.units) UNIT_PACK
                ,ifnull(v.vn,v.an) SEQ
                ,oo.presc_reason DRUGREMARK
                ,"" PA_NO
                ,"" TOTCOPAY
                ,if(v.item_type="H","2","1") USE_STATUS
                ,"" TOTAL,"" a1,""  a2,"" created_at,"" updated_at
                from opitemrece v
                LEFT JOIN drugitems d on d.icode = v.icode
                LEFT JOIN patient pt  on v.hn = pt.hn
                inner JOIN ipt v1 on v1.an = v.an
                LEFT JOIN ovst_presc_ned oo on oo.vn = v.vn and oo.icode=v.icode
                LEFT JOIN claim.tempexport x on x.vn = v1.vn
                where x.active="N"
                and d.did is not null AND v.qty<>"0"
                GROUP BY v.an,d.icode,USE_STATUS;
        ');
        foreach ($data_dru as $va9) {
            D_dru::insert([
                'HCODE'               => $va9->HCODE,
                'HN'                  => $va9->HN,
                'AN'                  => $va9->AN,
                'CLINIC'              => $va9->CLINIC,
                'PERSON_ID'           => $va9->PERSON_ID,
                'DATE_SERV'           => $va9->DATE_SERV,
                'DID'                 => $va9->DID,
                'DIDNAME'             => $va9->DIDNAME,
                'AMOUNT'              => $va9->AMOUNT,
                'DRUGPRIC'            => $va9->DRUGPRIC,
                'DRUGCOST'            => $va9->DRUGCOST,
                'DIDSTD'              => $va9->DIDSTD,
                'UNIT'                => $va9->UNIT,
                'UNIT_PACK'           => $va9->UNIT_PACK,
                'SEQ'                 => $va9->SEQ,
                'DRUGREMARK'          => $va9->DRUGREMARK,
                'PA_NO'               => $va9->PA_NO,
                'TOTCOPAY'            => $va9->TOTCOPAY,
                'USE_STATUS'          => $va9->USE_STATUS,
                'TOTAL'               => $va9->TOTAL,
                'SIGCODE'             => $va9->a1,
                'SIGTEXT'             => $va9->a2,
                'created_at'          => $va9->created_at,
                'updated_at'          => $va9->updated_at
            ]);
        }

        $data_idx = DB::connection('mysql3')->select('
             SELECT "" d_idx_id,v.an AN,o.icd10 DIAG
                    ,o.diagtype DXTYPE
                    ,if(d.licenseno="","-99999",d.licenseno) DRDX,"" created_at ,"" updated_at
                    FROM an_stat v
                    LEFT JOIN iptdiag o on o.an = v.an
                    LEFT JOIN doctor d on d.`code` = o.doctor
                    LEFT JOIN ipt ip on ip.an = v.an
                    INNER JOIN icd101 i on i.code = o.icd10
                    LEFT JOIN claim.d_export_ucep x on x.vn = v.vn
                    WHERE x.active="N";
        ');
        foreach ($data_idx as $va6) {
            D_idx::insert([
                'AN'                => $va6->AN,
                'DIAG'              => $va6->DIAG,
                'DXTYPE'            => $va6->DXTYPE,
                'DRDX'              => $va6->DRDX
            ]);
        }

        $data_ipd = DB::connection('mysql3')->select('
            SELECT "" d_ipd_id,v.hn HN,v.an AN
                ,DATE_FORMAT(o.regdate,"%Y%m%d") DATEADM
                ,Time_format(o.regtime,"%H%i") TIMEADM
                ,DATE_FORMAT(o.dchdate,"%Y%m%d") DATEDSC
                ,Time_format(o.dchtime,"%H%i")  TIMEDSC
                ,right(o.dchstts,1) DISCHS
                ,right(o.dchtype,1) DISCHT
                ,o.ward WARDDSC,o.spclty DEPT
                ,format(o.bw/1000,3) ADM_W
                ,"1" UUC ,"I" SVCTYPE,"" created_at,"" updated_at
                FROM an_stat v
                LEFT JOIN ipt o on o.an = v.an
                LEFT JOIN pttype p on p.pttype = v.pttype
                LEFT JOIN patient pt on pt.hn = v.hn
                LEFT JOIN claim.d_export_ucep x on x.vn = v.vn
                WHERE x.active="N";
        ');
        foreach ($data_ipd as $va10) {
            D_ipd::insert([
                'HN'                 => $va10->HN,
                'AN'                 => $va10->AN,
                'DATEADM'            => $va10->DATEADM,
                'TIMEADM'            => $va10->TIMEADM,
                'DATEDSC'            => $va10->DATEDSC,
                'TIMEDSC'            => $va10->TIMEDSC,
                'DISCHS'             => $va10->DISCHS,
                'DISCHT'             => $va10->DISCHT,
                'DEPT'               => $va10->DEPT,
                'ADM_W'              => $va10->ADM_W,
                'UUC'                => $va10->UUC,
                'SVCTYPE'            => $va10->SVCTYPE
            ]);
        }

        $data_irf = DB::connection('mysql3')->select('
                SELECT ""d_irf_id,v.an AN
                ,ifnull(o.refer_hospcode,oo.refer_hospcode) REFER
                ,"0100" REFERTYPE,"" created_at,"" updated_at
                FROM an_stat v
                LEFT JOIN referout o on o.vn =v.an
                LEFT JOIN referin oo on oo.vn =v.an
                LEFT JOIN ipt ip on ip.an = v.an
                LEFT JOIN claim.d_export_ucep x on x.vn = v.vn
                WHERE x.active="N"
                and (v.an in(select vn from referin where vn = oo.vn) or v.an in(select vn from referout where vn = o.vn));
        ');
        foreach ($data_irf as $va11) {
            D_irf::insert([
                'AN'                 => $va11->AN,
                'REFER'              => $va11->REFER,
                'REFERTYPE'          => $va11->REFERTYPE
            ]);
        }



        return redirect()->back();
    }
    public function ofc_pull_c(Request $request)
    {
        D_aer::truncate();
        D_iop::truncate();
        D_pat::truncate();
        D_cht::truncate();

        $data_aer = DB::connection('mysql3')->select('
                SELECT ""d_aer_id,v.hn HN,i.an AN
                ,v.vstdate DATEOPD,vv.claim_code AUTHAE
                ,"" AEDATE,"" AETIME,"" AETYPE,"" REFER_NO,"" REFMAINI
                ,"" IREFTYPE,"" REFMAINO,"" OREFTYPE,"" UCAE,"" EMTYPE,v.vn SEQ
                ,"" AESTATUS,"" DALERT,"" TALERT,"" created_at,"" updated_at
                from vn_stat v
                LEFT JOIN ipt i on i.vn = v.vn
                LEFT JOIN visit_pttype vv on vv.vn = v.vn
                LEFT OUTER JOIN pttype pt on pt.pttype =v.pttype
                LEFT JOIN claim.d_export_ucep x on x.vn = v.vn
                WHERE x.active="N"
                and i.an is null
                GROUP BY v.vn
                union all
                SELECT ""d_aer_id,v.hn HN
                ,v.an AN,v.dchdate DATEOPD,vv.claim_code AUTHAE
                ,"" AEDATE,"" AETIME,"" AETYPE,"" REFER_NO,"" REFMAINI
                ,"" IREFTYPE,"" REFMAINO,"" OREFTYPE,"" UCAE,"" EMTYPE
                ,"" SEQ,"" AESTATUS,"" DALERT,"" TALERT,"" created_at,"" updated_at
                from an_stat v
                LEFT JOIN ipt_pttype vv on vv.an = v.an
                LEFT OUTER JOIN pttype pt on pt.pttype =v.pttype
                LEFT JOIN claim.d_export_ucep x on x.vn = v.vn
                WHERE x.active="N"
                group by v.an;
        ');

        foreach ($data_aer as $va12) {
            D_aer::insert([
                'HN'                => $va12->HN,
                'AN'                => $va12->AN,
                'DATEOPD'           => $va12->DATEOPD,
                'AUTHAE'            => $va12->AUTHAE,
                'AEDATE'            => $va12->AEDATE,
                'AETIME'            => $va12->AETIME,
                'AETYPE'            => $va12->AETYPE,
                'REFER_NO'          => $va12->REFER_NO,
                'REFMAINI'          => $va12->REFMAINI,
                'IREFTYPE'          => $va12->IREFTYPE,
                'REFMAINO'          => $va12->REFMAINO,
                'OREFTYPE'          => $va12->OREFTYPE,
                'UCAE'              => $va12->UCAE,
                'SEQ'               => $va12->SEQ,
                'AESTATUS'          => $va12->AESTATUS,
                'DALERT'            => $va12->DALERT,
                'TALERT'            => $va12->TALERT,
            ]);
        }
         //D_iop
         $data_iop = DB::connection('mysql3')->select('
                SELECT "" d_iop_id,v.an AN
                ,o.icd9 OPER
                ,o.oper_type as OPTYPE
                ,if(d.licenseno="","-99999",d.licenseno) DROPID
                ,DATE_FORMAT(o.opdate,"%Y%m%d") DATEIN
                ,Time_format(o.optime,"%H%i") TIMEIN
                ,DATE_FORMAT(o.enddate,"%Y%m%d") DATEOUT
                ,Time_format(o.endtime,"%H%i") TIMEOUT,"" created_at,"" updated_at
                FROM an_stat v
                LEFT JOIN iptoprt o on o.an = v.an
                LEFT JOIN doctor d on d.`code` = o.doctor
                INNER JOIN icd9cm1 i on i.code = o.icd9
                LEFT JOIN ipt ip on ip.an = v.an
                LEFT JOIN claim.d_export_ucep x on x.vn = v.vn
                WHERE x.active="N";
        ');
        foreach ($data_iop as $va7) {
            D_iop::insert([
                'AN'                => $va7->AN,
                'OPER'              => $va7->OPER,
                'OPTYPE'            => $va7->OPTYPE,
                'DROPID'            => $va7->DROPID,
                'DATEIN'            => $va7->DATEIN,
                'TIMEIN'            => $va7->TIMEIN,
                'DATEOUT'           => $va7->DATEOUT,
                'TIMEOUT'           => $va7->TIMEOUT
            ]);
        }

        // D_pat
        $data_pat = DB::connection('mysql3')->select('
                SELECT "" d_pat_id
                ,v.hcode HCODE
                ,v.hn HN
                ,pt.chwpart CHANGWAT
                ,pt.amppart AMPHUR
                ,DATE_FORMAT(pt.birthday,"%Y%m%d") DOB
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
                ,"" created_at
                ,"" updated_at
                from vn_stat v
                LEFT JOIN pttype p on p.pttype = v.pttype
                LEFT JOIN ipt i on i.vn = v.vn
                LEFT JOIN patient pt on pt.hn = v.hn
                INNER JOIN claim.d_export_ucep x on x.vn = v.vn
                where x.active="N";
        ');
        foreach ($data_pat as $va2) {
            D_pat::insert([
                'HCODE'               => $va2->HCODE,
                'HN'                  => $va2->HN,
                'CHANGWAT'            => $va2->CHANGWAT,
                'AMPHUR'              => $va2->AMPHUR,
                'DOB'                 => $va2->DOB,
                'SEX'                 => $va2->SEX,
                'MARRIAGE'            => $va2->MARRIAGE,
                'OCCUPA'              => $va2->OCCUPA,
                'NATION'              => $va2->NATION,
                'PERSON_ID'           => $va2->PERSON_ID,
                'NAMEPAT'             => $va2->NAMEPAT,
                'TITLE'               => $va2->TITLE,
                'FNAME'               => $va2->FNAME,
                'LNAME'               => $va2->LNAME,
                'IDTYPE'              => $va2->IDTYPE
            ]);
        }

        $data_cht = DB::connection('mysql3')->select('
                SELECT "" d_cht_id
                ,v.hn HN
                ,v.an AN
                ,DATE_FORMAT(if(a.an is null,v.vstdate,a.dchdate),"%Y%m%d") DATE
                ,round(if(a.an is null,vv.income,a.income),2) TOTAL
                ,round(if(a.an is null,vv.paid_money,a.paid_money),2) PAID
                ,if(vv.paid_money >"0" or a.paid_money >"0","10",pt.pcode) PTTYPE
                ,pp.cid PERSON_ID
                ,v.vn SEQ
                ,"" created_at
                ,"" updated_at
                from ovst v
                LEFT JOIN vn_stat vv on vv.vn = v.vn
                LEFT JOIN an_stat a on a.an = v.an
                LEFT JOIN patient pp on pp.hn = v.hn
                LEFT JOIN pttype pt on pt.pttype = vv.pttype or pt.pttype=a.pttype
                LEFT JOIN pttype p on p.pttype = a.pttype
                LEFT JOIN claim.d_export_ucep x on x.vn = v.vn
                where x.active="N";
        ');
        foreach ($data_cht as $va7) {
            D_cht::insert([
                'HN'                => $va7->HN,
                'AN'                => $va7->AN,
                'DATE'              => $va7->DATE,
                'TOTAL'             => $va7->TOTAL,
                'PAID'              => $va7->PAID,
                'PTTYPE'            => $va7->PTTYPE,
                'PERSON_ID'         => $va7->PERSON_ID,
                'SEQ'               => $va7->SEQ,
            ]);
        }



        return redirect()->back();
    }
    public function ofc_pull_d(Request $request)
    {

        D_cha::truncate();

        $data_cha = DB::connection('mysql3')->select('
                SELECT "" d_cha_id,v.hn HN
                ,if(v1.an is null,"",v1.an) AN
                ,if(v1.an is null,DATE_FORMAT(v.vstdate,"%Y%m%d"),DATE_FORMAT(v1.dchdate,"%Y%m%d")) DATE
                ,if(v.paidst in("01","03"),dx.chrgitem_code2,dc.chrgitem_code1) CHRGITEM
                ,round(sum(v.sum_price),2) AMOUNT
                ,p.cid PERSON_ID
                ,ifnull(v.vn,v.an) SEQ,"" created_at,"" updated_at
                from opitemrece v
                LEFT JOIN vn_stat vv on vv.vn = v.vn
                LEFT JOIN patient p on p.hn = v.hn
                LEFT JOIN ipt v1 on v1.an = v.an
                LEFT JOIN income i on v.income=i.income
                LEFT JOIN drg_chrgitem dc on i.drg_chrgitem_id=dc.drg_chrgitem_id
                LEFT JOIN drg_chrgitem dx on i.drg_chrgitem_id= dx.drg_chrgitem_id
                left join claim.d_export_ucep x on x.vn = v.vn
                where x.active="N"
                group by v.vn,CHRGITEM
                union all
                SELECT "" d_cha_id,v.hn HN
                ,v1.an AN
                ,if(v1.an is null,DATE_FORMAT(v.vstdate,"%Y%m%d"),DATE_FORMAT(v1.dchdate,"%Y%m%d")) DATE
                ,if(v.paidst in("01","03"),dx.chrgitem_code2,dc.chrgitem_code1) CHRGITEM
                ,round(sum(v.sum_price),2) AMOUNT
                ,p.cid PERSON_ID
                ,ifnull(v.vn,v.an) SEQ,"" created_at,"" updated_at
                from opitemrece v
                LEFT JOIN vn_stat vv on vv.vn = v.vn
                LEFT JOIN patient p on p.hn = v.hn
                LEFT JOIN ipt v1 on v1.an = v.an
                LEFT JOIN income i on v.income=i.income
                LEFT JOIN drg_chrgitem dc on i.drg_chrgitem_id=dc.drg_chrgitem_id
                LEFT JOIN drg_chrgitem dx on i.drg_chrgitem_id= dx.drg_chrgitem_id
                left join claim.d_export_ucep x on x.vn = v1.vn
                where x.active="N"
                group by v.an,CHRGITEM;
        ');
        foreach ($data_cha as $va8) {
            D_cha::insert([
                'HN'                => $va8->HN,
                'AN'                => $va8->AN,
                'DATE'              => $va8->DATE,
                'CHRGITEM'          => $va8->CHRGITEM,
                'AMOUNT'            => $va8->AMOUNT,
                'PERSON_ID'         => $va8->PERSON_ID,
                'SEQ'               => $va8->SEQ,
            ]);
        }
        return redirect()->back();
    }

    public function ofc_send(Request $request)
    {
        $sss_date_now = date("Y-m-d");
        $sss_time_now = date("H:i:s");

        #ตัดขีด, ตัด : ออก
        $pattern_date = '/-/i';
        $sss_date_now_preg = preg_replace($pattern_date, '', $sss_date_now);
        $pattern_time = '/:/i';
        $sss_time_now_preg = preg_replace($pattern_time, '', $sss_time_now);
        #ตัดขีด, ตัด : ออก

         #delete file in folder ทั้งหมด
        $file = new Filesystem;
        $file->cleanDirectory('Export'); //ทั้งหมด
        // $file->cleanDirectory('UCEP_'.$sss_date_now_preg.'-'.$sss_time_now_preg); 
        $folder='UCEP_'.$sss_date_now_preg.'-'.$sss_time_now_preg;

         mkdir ('Export/'.$folder, 0777, true);  //Web
        //  mkdir ('C:Export/'.$folder, 0777, true); //localhost

        header("Content-type: text/txt");
        header("Cache-Control: no-store, no-cache");
        header('Content-Disposition: attachment; filename="content.txt"');

        //ins.txt
        $file_d_ins = "Export/".$folder."/INS.txt";
        $objFopen_opd1 = fopen($file_d_ins, 'w');
        $opd_head = 'HN|INSCL|SUBTYPE|CID|DATEIN|DATEEXP|HOSPMAIN|HOSPSUB|GOVCODE|GOVNAME|PERMITNO|DOCNO|OWNRPID|OWNNAME|AN|SEQ|SUBINSCL|RELINSCL|HTYPE';
        fwrite($objFopen_opd1, $opd_head);
        $ins = DB::connection('mysql7')->select('
            SELECT * from d_ins
        ');
        foreach ($ins as $key => $value1) {
            $a1 = $value1->HN;
            $a2 = $value1->INSCL;
            $a3 = $value1->SUBTYPE;
            $a4 = $value1->CID;
            $a5 = $value1->DATEIN;
            $a6 = $value1->DATEEXP;
            $a7 = $value1->HOSPMAIN;
            $a8 = $value1->HOSPSUB;
            $a9 = $value1->GOVCODE;
            $a10 = $value1->GOVNAME;
            $a11 = $value1->PERMITNO;
            $a12 = $value1->DOCNO;
            $a13 = $value1->OWNRPID;
            $a14= $value1->OWNRNAME;
            $a15 = $value1->AN;
            $a16= $value1->SEQ;
            $a17= $value1->SUBINSCL;
            $a18 = $value1->RELINSCL;
            $a19 = $value1->HTYPE;
            $strText1="\n".$a1."|".$a2."|".$a3."|".$a4."|".$a5."|".$a6."|".$a7."|".$a8."|".$a9."|".$a10."|".$a11."|".$a12."|".$a13."|".$a14."|".$a15."|".$a16."|".$a17."|".$a18."|".$a19;
            $ansitxt_pat1 = iconv('UTF-8', 'TIS-620', $strText1);
            fwrite($objFopen_opd1, $ansitxt_pat1);
        }
        fclose($objFopen_opd1);
     
        //iop.txt
        $file_d_iop = "Export/".$folder."/IOP.txt";
        $objFopen_opd2 = fopen($file_d_iop, 'w');
        $opd_head2 = 'AN|OPER|OPTYPE|DROPID|DATEIN|TIMEIN|DATEOUT|TIMEOUT';
        fwrite($objFopen_opd2, $opd_head2);
        $iop = DB::connection('mysql7')->select('
            SELECT * from d_iop
        ');
        foreach ($iop as $key => $value2) {
            $b1 = $value2->AN;
            $b2 = $value2->OPER;
            $b3 = $value2->OPTYPE;
            $b4 = $value2->DROPID;
            $b5 = $value2->DATEIN;
            $b6 = $value2->TIMEIN;
            $b7 = $value2->DATEOUT;
            $b8 = $value2->TIMEOUT;
           
            $strText2="\n".$b1."|".$b2."|".$b3."|".$b4."|".$b5."|".$b6."|".$b7."|".$b8;
            $ansitxt_pat2 = iconv('UTF-8', 'TIS-620', $strText2);
            fwrite($objFopen_opd2, $ansitxt_pat2);
        }
        fclose($objFopen_opd2);

         //adp.txt
        $file_d_adp = "Export/".$folder."/ADP.txt";
        $objFopen_opd3 = fopen($file_d_adp, 'w');
        $opd_head3 = 'HN|AN|DATEOPD|BILLMAUD|TYPE|CODE|QTY|RATE|SEQ|CAGCODE|DOSE|CA_TYPE|SERIALNO|TOTCOPAY|USE_STATUS|TOTAL|QTYDAY|TMLTCODE|STATUS1|GRAVIDA|GA_WEEK|DCIP|LMP|SP_ITEM';
        fwrite($objFopen_opd3, $opd_head3);
        $adp = DB::connection('mysql7')->select('
            SELECT * from d_adp
        ');
        foreach ($adp as $key => $value3) {
            $c1 = $value3->HN;
            $c2 = $value3->AN;
            $c3 = $value3->DATEOPD;
            $c4 = $value3->TYPE;
            $c5 = $value3->CODE;
            $c6 = $value3->QTY;
            $c7 = $value3->RATE;
            $c8 = $value3->SEQ;
            $c9 = $value3->CAGCODE;
            $c10 = $value3->DOSE;
            $c11 = $value3->CA_TYPE;
            $c12 = $value3->SERIALNO;
            $c13 = $value3->TOTCOPAY;
            $c14 = $value3->USE_STATUS;
            $c15 = $value3->TOTAL;
            $c16 = $value3->QTYDAY;
            $c17 = $value3->TMLTCODE;
            $c18 = $value3->STATUS1;
            $c19 = $value3->BI;
            $c20 = $value3->CLINIC;
            $c21 = $value3->ITEMSRC;
            $c22 = $value3->PROVIDER;
            $c23 = $value3->GLAVIDA;
            $c24 = $value3->GA_WEEK;
            $c25 = $value3->DCIP;
            $c26 = $value3->LMP;
            $c27 = $value3->SP_ITEM;           
            $strText3="\n".$c1."|".$c2."|".$c3."|".$c4."|".$c5."|".$c6."|".$c7."|".$c8."|".$c9."|".$c10."|".$c11."|".$c12."|".$c13."|".$c14."|".$c15."|".$c16."|".$c17."|".$c18."|".$c19."|".$c20."|".$c21."|".$c22."|".$c23."|".$c24."|".$c25."|".$c26."|".$c27;
            $ansitxt_pat3 = iconv('UTF-8', 'TIS-620', $strText3);
            fwrite($objFopen_opd3, $ansitxt_pat3);
        }
        fclose($objFopen_opd3);

        //aer.txt
        $file_d_aer = "Export/".$folder."/AER.txt";
        $objFopen_opd4 = fopen($file_d_aer, 'w');
        $opd_head4 = 'HN|AN|DATEOPD|AUTHAE|AEDATE|AETIME|AETYPE|REFER_NO|REFMAINI|IREFTYPE|REFMAINO|OREFTYPE|UCAE|EMTYPE|SEQ|AESTATUS|DALERT|TALERT';
        fwrite($objFopen_opd4, $opd_head4);
        $aer = DB::connection('mysql7')->select('
            SELECT * from d_aer
        ');
        foreach ($aer as $key => $value4) {
            $d1 = $value4->HN;
            $d2 = $value4->AN;
            $d3 = $value4->DATEOPD;
            $d4 = $value4->AUTHAE;
            $d5 = $value4->AEDATE;
            $d6 = $value4->AETIME;
            $d7 = $value4->AETYPE;
            $d8 = $value4->REFER_NO;
            $d9 = $value4->REFMAINI;
            $d10 = $value4->IREFTYPE;
            $d11 = $value4->REFMAINO;
            $d12 = $value4->OREFTYPE;
            $d13 = $value4->UCAE;
            $d14 = $value4->EMTYPE;
            $d15 = $value4->SEQ;
            $d16 = $value4->AESTATUS;
            $d17 = $value4->DALERT;
            $d18 = $value4->TALERT;        
            $strText4="\n".$d1."|".$d2."|".$d3."|".$d4."|".$d5."|".$d6."|".$d7."|".$d8."|".$d9."|".$d10."|".$d11."|".$d12."|".$d13."|".$d14."|".$d15."|".$d16."|".$d17."|".$d18;
            $ansitxt_pat4 = iconv('UTF-8', 'TIS-620', $strText4);
            fwrite($objFopen_opd4, $ansitxt_pat4);
        }
        fclose($objFopen_opd4);

        //cha.txt
        $file_d_cha = "Export/".$folder."/CHA.txt";
        $objFopen_opd5 = fopen($file_d_cha, 'w');
        $opd_head5 = 'HN|AN|DATE|CHRGITEM|AMOUNT|PERSON_ID|SEQ';
        fwrite($objFopen_opd5, $opd_head5);
        $cha = DB::connection('mysql7')->select('
            SELECT * from d_cha
        ');
        foreach ($cha as $key => $value5) {
            $e1 = $value5->HN;
            $e2 = $value5->AN;
            $e3 = $value5->DATE;
            $e4 = $value5->CHRGITEM;
            $e5 = $value5->AMOUNT;
            $e6 = $value5->PERSON_ID;
            $e7 = $value5->SEQ; 
            $strText5="\n".$e1."|".$e2."|".$e3."|".$e4."|".$e5."|".$e6."|".$e7;
            $ansitxt_pat5 = iconv('UTF-8', 'TIS-620', $strText5);
            fwrite($objFopen_opd5, $ansitxt_pat5);
        }
        fclose($objFopen_opd5);

        //cht.txt
        $file_d_cht = "Export/".$folder."/CHT.txt";
        $objFopen_opd6 = fopen($file_d_cht, 'w');
        $opd_head6 = 'HN|AN|DATE|TOTAL|PAID|PTTYPE|PERSON_ID|SEQ';
        fwrite($objFopen_opd6, $opd_head6);
        $cht = DB::connection('mysql7')->select('
            SELECT * from d_cht
        ');
        foreach ($cht as $key => $value6) {
            $f1 = $value6->HN;
            $f2 = $value6->AN;
            $f3 = $value6->DATE;
            $f4 = $value6->TOTAL;
            $f5 = $value6->PAID;
            $f6 = $value6->PTTYPE;
            $f7 = $value6->PERSON_ID; 
            $f8 = $value6->SEQ;
            $strText6="\n".$f1."|".$f2."|".$f3."|".$f4."|".$f5."|".$f6."|".$f7."|".$f8;
            $ansitxt_pat6 = iconv('UTF-8', 'TIS-620', $strText6);
            fwrite($objFopen_opd6, $ansitxt_pat6);
        }
        fclose($objFopen_opd6);

        //dru.txt
        $file_d_dru = "Export/".$folder."/DRU.txt";
        $objFopen_opd7 = fopen($file_d_dru, 'w');
        $opd_head7 = 'HCODE|HN|AN|CLINIC|PERSON_ID|DATE_SERV|DID|DIDNAME|AMOUNT|DRUGPRIC|DRUGCOST|DIDSTD|UNIT|UNIT_PACK|SEQ|DRUGTYPE|DRUGREMARK|PA_NO|TOTCOPAY|USE_STATUS|TOTAL';
        fwrite($objFopen_opd7, $opd_head7);
        $dru = DB::connection('mysql7')->select('
            SELECT * from d_dru
        ');
        foreach ($dru as $key => $value7) {
            $g1 = $value7->HCODE;
            $g2 = $value7->HN;
            $g3 = $value7->AN;
            $g4 = $value7->CLINIC;
            $g5 = $value7->PERSON_ID;
            $g6 = $value7->DATE_SERV;
            $g7 = $value7->DID;
            $g8 = $value7->DIDNAME;
            $g9 = $value7->AMOUNT;
            $g10 = $value7->DRUGPRIC;
            $g11 = $value7->DRUGCOST;
            $g12 = $value7->DIDSTD;
            $g13 = $value7->UNIT;
            $g14 = $value7->UNIT_PACK;
            $g15 = $value7->SEQ;
            $g16 = $value7->DRUGREMARK;
            $g17 = $value7->PA_NO;
            $g18 = $value7->TOTCOPAY;
            $g19 = $value7->USE_STATUS;
            $g20 = $value7->TOTAL;
            $g21 = $value7->SIGCODE;
            $g22 = $value7->SIGTEXT;        
            $strText7="\n".$g1."|".$g2."|".$g3."|".$g4."|".$g5."|".$g6."|".$g7."|".$g8."|".$g9."|".$g10."|".$g11."|".$g12."|".$g13."|".$g14."|".$g15."|".$g16."|".$g17."|".$g18."|".$g19."|".$g20."|".$g21."|".$g22;
            $ansitxt_pat7 = iconv('UTF-8', 'TIS-620', $strText7);
            fwrite($objFopen_opd7, $ansitxt_pat7);
        }
        fclose($objFopen_opd7);

        //idx.txt
        $file_d_idx = "Export/".$folder."/IDX.txt";
        $objFopen_opd8 = fopen($file_d_idx, 'w');
        $opd_head8 = 'AN|DIAG|DXTYPE|DRDX';
        fwrite($objFopen_opd8, $opd_head8);
        $idx = DB::connection('mysql7')->select('
            SELECT * from d_idx
        ');
        foreach ($idx as $key => $value8) {
            $h1 = $value8->AN;
            $h2 = $value8->DIAG;
            $h3 = $value8->DXTYPE;
            $h4 = $value8->DRDX; 
            $strText8="\n".$h1."|".$h2."|".$h3."|".$h4;
            $ansitxt_pat8 = iconv('UTF-8', 'TIS-620', $strText8);
            fwrite($objFopen_opd8, $ansitxt_pat8);
        }
        fclose($objFopen_opd8);

        //pat.txt
        $file_pat = "Export/".$folder."/PAT.txt";
        $objFopen_opd9 = fopen($file_pat, 'w');
        $opd_head9 = 'HCODE|HN|CHANGWAT|AMPHUR|DOB|SEX|MARRIAGE|OCCUPA|NATION|PERSON_ID|NAMEPAT|TITLE|FNAME|LNAME|IDTYPE';
        fwrite($objFopen_opd9, $opd_head9);
        $pat = DB::connection('mysql7')->select('
            SELECT * from d_pat
        ');
        foreach ($pat as $key => $value9) {
            $i1 = $value9->HCODE;
            $i2 = $value9->HN;
            $i3 = $value9->CHANGWAT;
            $i4 = $value9->AMPHUR;
            $i5 = $value9->DOB;
            $i6 = $value9->SEX;
            $i7 = $value9->MARRIAGE;
            $i8 = $value9->OCCUPA;
            $i9 = $value9->NATION;
            $i10 = $value9->PERSON_ID;
            $i11 = $value9->NAMEPAT;
            $i12 = $value9->TITLE;
            $i13 = $value9->FNAME;
            $i14 = $value9->LNAME;
            $i15 = $value9->IDTYPE;      
            $strText9="\n".$i1."|".$i2."|".$i3."|".$i4."|".$i5."|".$i6."|".$i7."|".$i8."|".$i9."|".$i10."|".$i11."|".$i12."|".$i13."|".$i14."|".$i15;
            $ansitxt_pat9 = iconv('UTF-8', 'TIS-620', $strText9);
            fwrite($objFopen_opd9, $ansitxt_pat9);
        }
        fclose($objFopen_opd9);

        //ipd.txt
        $file_d_ipd = "Export/".$folder."/IPD.txt";
        $objFopen_opd10 = fopen($file_d_ipd, 'w');
        $opd_head10 = 'HN|AN|DATEADM|TIMEADM|DATEDSC|TIMEDSC|DISCHS|DISCHT|WARDDSC|DEPT|ADM_W|UUC|SVCTYPE';
        fwrite($objFopen_opd10, $opd_head10);
        $ipd = DB::connection('mysql7')->select('
            SELECT * from d_ipd
        ');
        foreach ($ipd as $key => $value10) {
            $j1 = $value10->HN;
            $j2 = $value10->AN;
            $j3 = $value10->DATEADM;
            $j4 = $value10->TIMEADM;
            $j5 = $value10->DATEDSC;
            $j6 = $value10->TIMEDSC;
            $j7 = $value10->DISCHS;
            $j8 = $value10->DISCHT;
            $j9 = $value10->WARDDSC;
            $j10 = $value10->DEPT;
            $j11 = $value10->ADM_W;
            $j12 = $value10->UUC;
            $j13 = $value10->SVCTYPE;    
            $strText10="\n".$j1."|".$j2."|".$j3."|".$j4."|".$j5."|".$j6."|".$j7."|".$j8."|".$j9."|".$j10."|".$j11."|".$j12."|".$j13;
            $ansitxt_pat10 = iconv('UTF-8', 'TIS-620', $strText10);
            fwrite($objFopen_opd10, $ansitxt_pat10);
        }
        fclose($objFopen_opd10);

        //irf.txt
        $file_d_irf = "Export/".$folder."/IRF.txt";
        $objFopen_opd11 = fopen($file_d_irf, 'w');
        $opd_head11 = 'AN|REFER|REFERTYPE';
        fwrite($objFopen_opd11, $opd_head11);
        $irf = DB::connection('mysql7')->select('
            SELECT * from d_irf
        ');
        foreach ($irf as $key => $value11) {
            $k1 = $value11->AN;
            $k2 = $value11->REFER;
            $k3 = $value11->REFERTYPE; 
            $strText11="\n".$k1."|".$k2."|".$k3;
            $ansitxt_pat11 = iconv('UTF-8', 'TIS-620', $strText11);
            fwrite($objFopen_opd11, $ansitxt_pat11);
        }
        fclose($objFopen_opd11);

        //lvd.txt
        $file_d_lvd = "Export/".$folder."/LVD.txt";
        $objFopen_opd12 = fopen($file_d_lvd, 'w');
        $opd_head12 = 'SEQLVD|AN|DATEOUT|TIMEOUT|DATEIN|TIMEIN|QTYDAY';
        fwrite($objFopen_opd12, $opd_head12);
        $lvd = DB::connection('mysql7')->select('
            SELECT * from d_lvd
        ');
        foreach ($lvd as $key => $value12) {
            $L1 = $value12->SEQLVD;
            $L2 = $value12->AN;
            $L3 = $value12->DATEOUT; 
            $L4 = $value12->TIMEOUT; 
            $L5 = $value12->DATEIN; 
            $L6 = $value12->TIMEIN; 
            $L7 = $value12->QTYDAY; 
            $strText12="\n".$L1."|".$L2."|".$L3."|".$L4."|".$L5."|".$L6."|".$L7;
            $ansitxt_pat12 = iconv('UTF-8', 'TIS-620', $strText12);
            fwrite($objFopen_opd12, $ansitxt_pat12);
        }
        fclose($objFopen_opd12);

        //odx.txt
        $file_d_odx = "Export/".$folder."/ODX.txt";
        $objFopen_opd13 = fopen($file_d_odx, 'w');
        $opd_head13 = 'HN|DATEDX|CLINIC|DIAG|DXTYPE|DRDX|PERSON_ID|SEQ';
        fwrite($objFopen_opd13, $opd_head13);
        $odx = DB::connection('mysql7')->select('
            SELECT * from d_odx
        ');
        foreach ($odx as $key => $value13) {
            $m1 = $value13->HN;
            $m2 = $value13->DATEDX;
            $m3 = $value13->CLINIC; 
            $m4 = $value13->DIAG; 
            $m5 = $value13->DXTYPE; 
            $m6 = $value13->DRDX; 
            $m7 = $value13->PERSON_ID; 
            $m8 = $value13->SEQ; 
            $strText13="\n".$m1."|".$m2."|".$m3."|".$m4."|".$m5."|".$m6."|".$m7."|".$m8;
            $ansitxt_pat13 = iconv('UTF-8', 'TIS-620', $strText13);
            fwrite($objFopen_opd13, $ansitxt_pat13);
        }
        fclose($objFopen_opd13);

        //oop.txt
        $file_d_oop = "Export/".$folder."/OOP.txt";
        $objFopen_opd14 = fopen($file_d_oop, 'w');
        $opd_head14 = 'HN|DATEOPD|CLINIC|OPER|DROPID|PERSON_ID|SEQ';
        fwrite($objFopen_opd14, $opd_head14);
        $oop = DB::connection('mysql7')->select('
            SELECT * from d_oop
        ');
        foreach ($oop as $key => $value14) {
            $n1 = $value14->HN;
            $n2 = $value14->DATEOPD;
            $n3 = $value14->CLINIC; 
            $n4 = $value14->OPER; 
            $n5 = $value14->DROPID; 
            $n6 = $value14->PERSON_ID; 
            $n7 = $value14->SEQ;  
            $strText14="\n".$n1."|".$n2."|".$n3."|".$n4."|".$n5."|".$n6."|".$n7;
            $ansitxt_pat14 = iconv('UTF-8', 'TIS-620', $strText14);
            fwrite($objFopen_opd14, $ansitxt_pat14);
        }
        fclose($objFopen_opd14);

        //opd.txt
        $file_d_opd = "Export/".$folder."/OPD.txt";
        $objFopen_opd15 = fopen($file_d_opd, 'w');
        $opd_head15 = 'HN|CLINIC|DATEOPD|TIMEOPD|SEQ|UUC|DETAIL|BTEMP|SBP|DBP|PR|RR|OPTYPE|TYPEIN|TYPEOUT';
        fwrite($objFopen_opd15, $opd_head15);
        $opd = DB::connection('mysql7')->select('
            SELECT * from d_opd
        ');
        foreach ($opd as $key => $value15) {
            $o1 = $value15->HN;
            $o2 = $value15->CLINIC;
            $o3 = $value15->DATEOPD; 
            $o4 = $value15->TIMEOPD; 
            $o5 = $value15->SEQ; 
            $o6 = $value15->UUC;  
            $strText15="\n".$o1."|".$o2."|".$o3."|".$o4."|".$o5."|".$o6;
            $ansitxt_pat15 = iconv('UTF-8', 'TIS-620', $strText15);
            fwrite($objFopen_opd15, $ansitxt_pat15);
        }
        fclose($objFopen_opd15);

        //orf.txt
        $file_d_orf = "Export/".$folder."/ORF.txt";
        $objFopen_opd16 = fopen($file_d_orf, 'w');
        $opd_head16 = 'HN|DATEOPD|CLINIC|REFER|REFERTYPE|SEQ';
        fwrite($objFopen_opd16, $opd_head16);
        $orf = DB::connection('mysql7')->select('
            SELECT * from d_orf
        ');
        foreach ($orf as $key => $value16) {
            $p1 = $value16->HN;
            $p2 = $value16->DATEOPD;
            $p3 = $value16->CLINIC; 
            $p4 = $value16->REFER; 
            $p5 = $value16->REFERTYPE; 
            $p6 = $value16->SEQ;  
            $strText16="\n".$p1."|".$p2."|".$p3."|".$p4."|".$p5."|".$p6;
            $ansitxt_pat16 = iconv('UTF-8', 'TIS-620', $strText16);
            fwrite($objFopen_opd16, $ansitxt_pat16);
        }
        fclose($objFopen_opd16);


         //lab.txt
         $file_d_lab = "Export/".$folder."/LAB.txt";
         $objFopen_opd17 = fopen($file_d_lab, 'w');
         $opd_head17 = 'HCODE|HN|PERSON_ID|DATESERV|SEQ|LABTEST|LABRESULT';
         fwrite($objFopen_opd17, $opd_head17);

         fclose($objFopen_opd17);



        $pathdir =  "Export/".$folder."/";
        $zipcreated = $folder.".zip";

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
                    //// delete file
                    unlink($zipcreated);                    
                    //// Get the list of all of file names ลบไฟล์ในโฟลเดอทั้งหมด ทิ้งก่อน
                    //// in the folder. 
                    $files = glob($pathdir . '/*');                     
                    //// Loop through the file list 
                    foreach($files as $file) {                         
                        //// Check for file 
                        if(is_file($file)) {                             
                            //// Use unlink function to  
                            //// delete the file. 
                            // unlink($file); 
                        } 
                    }                     
                    // if(rmdir($pathdir)){ // ลบ folder ใน export                    
                    // }                    
                    return redirect()->route('claim.ssop');                    
                }
        }


            return redirect()->route('data.six');

    }

}






