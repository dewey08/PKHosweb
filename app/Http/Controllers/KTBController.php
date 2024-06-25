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
use Stevebauman\Location\Facades\Location;
use Http;
use SoapClient; 
use SplFileObject;
use Arr;
use Storage;
use GuzzleHttp\Client;
use App\Models\Tempexport;
use App\Models\D_aer;
use App\Models\D_adp;
use App\Models\D_cha;  
use App\Models\D_cht;
use App\Models\D_oop;
use App\Models\D_odx;
use App\Models\D_orf;
use App\Models\D_pat;
use App\Models\D_ins;
use App\Models\D_dru;
use App\Models\D_opd;
use App\Models\D_ktb_b17;
use App\Models\Stm;
use App\Models\D_export;

class KTBController extends Controller
{
    public function ktb_getcard(Request $request)
    { 
        $data['users'] = User::get();
        $budget = DB::table('budget_year')->where('active','=','True')->first();
        $datestart = $budget->date_begin;
        $dateend = $budget->date_end;
         
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

                // $url = "http://localhost:3000/moi/getCardData";
                $url = "https://3doctor.hss.moph.go.th/main/PersonalController/insert_person";
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "$url",
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_CUSTOMREQUEST => 'GET',
            ));
         
            $response = curl_exec($curl);
            curl_close($curl);
            $content = $response;
            $result = json_decode($content, true);

            dd($result);

            
            @$responseCode = $result['responseCode'];
            // dd($responseCode);
            if (@$responseCode < 0) {
                $smartcard = 'NO_CONNECT';
            } else { 
                $smartcard = 'CONNECT';
            }
            // dd($smartcard);
                @$readerName = $result['readerName'];
                @$responseDesc = $result['responseDesc'];
                @$pid = $result['pid'];
                @$cid = $result['cid'];
                @$chipId = $result['chipId'];
                @$fullNameTH = $result['fullNameTH'];
                @$fullNameEN = $result['fullNameEN'];
                @$birthTH = $result['birthTH'];
                @$birthEN = $result['birthEN'];
                @$sex = $result['sex'];
                @$cardId = $result['cardId'];
                @$sourceData = $result['sourceData'];
                @$issueCode = $result['issueCode'];
                @$dateIssueTH = $result['dateIssueTH'];
                @$dateIssueEN = $result['dateIssueEN'];
                @$dateExpTH = $result['dateExpTH'];
                @$dateExpEN = $result['dateExpEN'];
                @$address = $result['address'];
                @$image = $result['image'];
                @$imageNo = $result['imageNo'];
                @$cardVersion = $result['cardVersion'];
                @$customerPid = $result['customerPid'];
                @$customerCid = $result['customerCid'];
                @$ktbKeyY = $result['ktbKeyY'];
                @$customerKeyY = $result['customerKeyY'];

                $pid         = @$pid;
                $cid         = @$cid;
                $image_      = @$image;
                $chipId      = @$chipId;
                $fullNameTH  = @$fullNameTH;
                $fullNameEN  = @$fullNameEN;
                $birthTH     = @$birthTH;
                $birthEN     = @$birthEN;
                $address     = @$address;
                $dateIssueTH = @$dateIssueTH;
                $dateExpTH   = @$dateExpTH;
                 
                // dd( @$fullNameTH); 
        return view('ktb.ktb_getcard', $data,[ 
            'data_ogclgo'   =>  $data_ogclgo,
            'smartcard'     =>  $smartcard,
            'image_'        => $image_,
            'pid'           => $pid,
            'cid'           => $cid,
            'chipId'        => $chipId,
            'fullNameTH'    => $fullNameTH,
            'fullNameEN'    => $fullNameEN,
            'birthTH'       => $birthTH,
            'birthEN'       => $birthEN,
            'address'       => $address,
            'dateIssueTH'   => $dateIssueTH,
            'dateExpTH'     => $dateExpTH,
        ]);
    }
    public function ktb(Request $request)
    { 
        $datestart = $request->startdate;
        $dateend = $request->enddate;
        $ins_ = DB::connection('mysql7')->select('   
            SELECT * FROM d_ins   
        ');
        $pat_ = DB::connection('mysql7')->select('   
            SELECT * FROM d_pat   
        ');
        $opd_ = DB::connection('mysql7')->select('   
            SELECT * FROM d_opd   
        ');
        $odx_ = DB::connection('mysql7')->select('   
            SELECT * FROM d_odx   
        ');
        $adp_ = DB::connection('mysql7')->select('   
            SELECT * FROM d_adp   
        ');
        $dru_ = DB::connection('mysql7')->select('   
            SELECT * FROM d_dru   
        ');

        return view('claim.ktb',[
            'start'            => $datestart,
            'end'              => $dateend,
            'ins_'              => $ins_,
            'pat_'              => $pat_,
            'opd_'              => $opd_,
            'odx_'              => $odx_,
            'adp_'              => $adp_,
            'dru_'              => $dru_
        ]);
    }
    public function ktb_search(Request $request)
    { 
        $datestart = $request->startdate;
        $dateend = $request->enddate;
        $data_opd = DB::connection('mysql3')->select('   
                SELECT p.hn,v.vn,p.cid,i.an from hos.vn_stat v 
                left join opitemrece o on o.vn = v.vn  
                left join ipt i on i.vn=v.vn 
                left outer join patient p on p.hn = v.hn
                WHERE v.vstdate BETWEEN "'.$datestart.'" AND "'.$dateend.'"  
                and o.icode = "3000149"
                and o.pttype NOT IN ("98","99","50","49","O1","O2","O3","O4","O5","L1","L2","L3","L4","L5","L6") 
                and o.an is null
                GROUP BY v.hn,v.vstdate;
        ');
        Tempexport::truncate();
        foreach ($data_opd as $key => $value) {           
            $add= new Tempexport();
            $add->vn = $value->vn ;
            $add->hn = $value->hn; 
            $add->an = $value->an; 
            $add->cid = $value->cid; 
            $add->ACTIVE = 'N';
            $add->save();
        }

        $data_ktb_b17 = DB::connection('mysql3')->select('   
                SELECT p.hn,v.vn,p.cid,i.an,v.uc_money,v.uc_money AS ClaimAmt
                ,v.vstdate,CONCAT(p.pname,p.fname," ",p.lname) AS FULLNAME
                 from hos.vn_stat v 
                left join opitemrece o on o.vn = v.vn  
                left join ipt i on i.vn=v.vn 
                left outer join patient p on p.hn = v.hn 
                WHERE v.vstdate BETWEEN "'.$datestart.'" AND "'.$dateend.'"   
                and o.icode = "3000149"
                and o.pttype NOT IN ("98","99","50","49","O1","O2","O3","O4","O5","L1","L2","L3","L4","L5","L6") 
                and o.an is null
                GROUP BY v.hn;
        '); 
       
        // D_ktb_b17::truncate();
        foreach ($data_ktb_b17 as $key => $item2) { 
            $checkvn = D_ktb_b17::where('vn','=',$item2->vn)->count();
            $datenow = date('Y-m-d H:m:s');
            if ($checkvn > 0) { 
            } else { 
                D_ktb_b17::insert([                        
                    'vn'         => $item2->vn,
                    'hn'         => $item2->hn,
                    'an'         => $item2->an,
                    'cid'        => $item2->cid,
                    'vstdate'    => $item2->vstdate,
                    'created_at' => $datenow, 
                ]);
            }          

            $check_vn = Stm::where('VN','=',$item2->vn)->count(); 
            
            if ($check_vn > 0) { 
            } else {
                Stm::insert([                        
                        'AN'                => $item2->an, 
                        'VN'                => $item2->vn,
                        'HN'                => $item2->hn,
                        'PID'               => $item2->cid,
                        'VSTDATE'           => $item2->vstdate,
                        'FULLNAME'          => $item2->FULLNAME,  
                        'MAININSCL'         => "",
                        'created_at'        => $datenow, 
                        'ClaimAmt'          =>$item2->ClaimAmt
                    ]);
            }
            
        }

        D_ins::truncate();
        $inst_ = DB::connection('mysql3')->select('   
                SELECT v.hn HN
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
                ,v.vstdate

                from vn_stat v
                LEFT JOIN opitemrece o on o.vn = v.vn
                LEFT JOIN pttype p on p.pttype = v.pttype
                LEFT JOIN ipt i on i.vn = v.vn 
                LEFT JOIN pttype pp on pp.pttype = i.pttype
                left join ipt_pttype ap on ap.an = i.an
                left join visit_pttype vp on vp.vn = v.vn
                LEFT JOIN rcpt_debt r on r.vn = v.vn
                left join patient px on px.hn = v.hn
                left join claim.tempexport x on x.vn = v.vn
                where x.ACTIVE="N" 
                GROUP BY v.hn,v.vstdate; 
        ');
        
        foreach ($inst_ as $key => $ins) {
            D_ins::insert([                        
                'HN'                => $ins->HN, 
                'INSCL'             => $ins->INSCL,
                'SUBTYPE'            => $ins->SUBTYPE,
                'CID'               => $ins->CID,
                'DATEIN'            => $ins->DATEIN,
                'DATEEXP'           => $ins->DATEEXP,  
                'HOSPMAIN'          => $ins->HOSPMAIN,
                'HOSPSUB'           => $ins->HOSPSUB, 
                'GOVCODE'           =>$ins->GOVCODE,
                'GOVNAME'           =>$ins->GOVNAME,
                'PERMITNO'          =>$ins->PERMITNO,
                'DOCNO'             =>$ins->DOCNO,
                'OWNRPID'           =>$ins->OWNRPID,
                'OWNRNAME'          =>$ins->OWNRNAME,
                'AN'                =>$ins->AN,
                'SEQ'               =>$ins->SEQ,
                'SUBINSCL'          =>$ins->SUBINSCL,
                'RELINSCL'          =>$ins->RELINSCL,
                'HTYPE'             =>$ins->HTYPE
            ]);
        }

        D_pat::truncate();
        $patt_ = DB::connection('mysql3')->select('   
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
                LEFT JOIN opitemrece o on o.vn = v.vn
                LEFT JOIN pttype p on p.pttype = v.pttype
                LEFT JOIN ipt i on i.vn = v.vn  
                left join patient pt on pt.hn = v.hn
                left join claim.tempexport x on x.vn = v.vn
                where x.ACTIVE="N" 
                GROUP BY v.hn,v.vstdate; 
        ');
        
        foreach ($patt_ as $key => $pat) {
            D_pat::insert([                        
                'HN'                => $pat->HN, 
                'HCODE'             => $pat->HCODE,
                'CHANGWAT'          => $pat->CHANGWAT,
                'AMPHUR'            => $pat->AMPHUR,
                'DOB'               => $pat->DOB,
                'SEX'               => $pat->SEX,  
                'MARRIAGE'          => $pat->MARRIAGE,
                'OCCUPA'            => $pat->OCCUPA, 
                'NATION'            => $pat->NATION,
                'PERSON_ID'         => $pat->PERSON_ID,
                'NAMEPAT'           => $pat->NAMEPAT,
                'TITLE'             => $pat->TITLE,
                'FNAME'             => $pat->FNAME,
                'LNAME'             => $pat->LNAME,
                'IDTYPE'            => $pat->IDTYPE  
            ]);
        }

        D_opd::truncate();
        $opdt_ = DB::connection('mysql3')->select('   
                SELECT v.hn as HN
                ,v.spclty as CLINIC
                ,DATE_FORMAT(v.vstdate, "%Y%m%d") as DATEOPD
                ,concat(substr(o.vsttime,1,2),substr(o.vsttime,4,2)) as TIMEOPD
                ,v.vn as SEQ 
                ,"1" UUC
                ,v.vstdate 

                from vn_stat v
                LEFT JOIN ovst o on o.vn = v.vn
                LEFT JOIN pttype p on p.pttype = v.pttype
                LEFT JOIN ipt i on i.vn = v.vn 
                LEFT JOIN patient pt on pt.hn = v.hn
                left join claim.tempexport x on x.vn = v.vn
                where x.ACTIVE="N"                
                GROUP BY SEQ; 
        ');
        
        foreach ($opdt_ as $key => $opd) {
            D_opd::insert([                        
                'HN'                => $opd->HN, 
                'CLINIC'            => $opd->CLINIC,
                'DATEOPD'           => $opd->DATEOPD,
                'TIMEOPD'           => $opd->TIMEOPD,
                'SEQ'               => $opd->SEQ,
                'UUC'               => $opd->UUC 
            ]);
        }

        D_odx::truncate();
        $odxt_ = DB::connection('mysql3')->select('   
                SELECT v.hn HN
                ,DATE_FORMAT(v.vstdate,"%Y%m%d") DATEDX
                ,v.spclty CLINIC
                ,o.icd10 DIAG
                ,o.diagtype DXTYPE
                ,if(d.licenseno="","-99999",d.licenseno) DRDX
                ,v.cid PERSON_ID 
                ,v.vn SEQ
                ,v.vstdate 
                ,v.pttype

                from vn_stat v
                LEFT JOIN ovstdiag o on o.vn = v.vn
                LEFT JOIN doctor d on d.`code` = o.doctor
                inner JOIN icd101 i on i.code = o.icd10 
                left join claim.tempexport x on x.vn = v.vn
                where x.ACTIVE="N"  
                GROUP BY SEQ; 
        ');
         
        foreach ($odxt_ as $key => $odx) {
            D_odx::insert([                        
                'HN'                => $odx->HN, 
                'CLINIC'            => $odx->CLINIC,
                'DATEDX'            => $odx->DATEDX,
                'DIAG'              => $odx->DIAG,
                'DXTYPE'            => $odx->DXTYPE,
                'DRDX'              => $odx->DRDX,
                'PERSON_ID'         => $odx->PERSON_ID,
                'SEQ'               => $odx->SEQ 
            ]);
        }

        D_adp::truncate();
        $adpt_ = DB::connection('mysql3')->select('   
            SELECT HN,AN,DATEOPD,TYPE,CODE,sum(QTY) QTY
            ,RATE,SEQ
            ,"" CAGCODE,"" DOSE,"" CA_TYPE,"" SERIALNO,"" TOTCOPAY,"" USE_STATUS,"" TOTAL ,"" QTYDAY
            ,"" TMLTCODE
            ,"" STATUS1
            ,"" BI
            ,"" CLINIC
            ,"" ITEMSRC
            ,"" PROVIDER
            ,"" GLAVIDA
            ,"" GA_WEEK
            ,"" DCIP
            ,"0000-00-00" LMP
            from (SELECT v.hn HN
            ,if(v.an is null,"",v.an) AN
            ,DATE_FORMAT(v.rxdate,"%Y%m%d") DATEOPD
            ,n.nhso_adp_type_id TYPE
            ,n.nhso_adp_code CODE 
            ,sum(v.QTY) QTY
            ,round(v.unitprice,2) RATE
            ,if(v.an is null,v.vn,"") SEQ
            ,"" CAGCODE,"" DOSE,"" CA_TYPE,"" SERIALNO,"" TOTCOPAY,"" USE_STATUS,"" TOTAL ,"" QTYDAY
            ,"" TMLTCODE
            ,"" STATUS1
            ,"" BI
            ,"" CLINIC
            ,"" ITEMSRC
            ,"" PROVIDER
            ,"" GLAVIDA
            ,"" GA_WEEK
            ,"" DCIP
            ,"0000-00-00" LMP
            from opitemrece v
            inner JOIN drugitems n on n.icode = v.icode and n.nhso_adp_code is not null
            left join ipt i on i.an = v.an
            AND i.an is not NULL
            left join claim.tempexport x on x.vn = i.vn
            where x.ACTIVE="N"
            GROUP BY i.vn,n.nhso_adp_code,rate) a 
            GROUP BY an,CODE,rate
            UNION
            SELECT HN,AN,DATEOPD,TYPE,CODE,sum(QTY) QTY,RATE,SEQ,"" "" CAGCODE,"" DOSE,"" CA_TYPE,"" SERIALNO,"0" TOTCOPAY,"" USE_STATUS,"0" TOTAL ,"" QTYDAY
            ,""TMLTCODE
            ,"" STATUS1
            ,"" BI
            ,"" CLINIC
            ,"" ITEMSRC
            ,"" PROVIDER
            ,"" GLAVIDA
            ,"" GA_WEEK
            ,"" DCIP
            ,"0000-00-00" LMP
            from
            (SELECT v.hn HN
            ,if(v.an is null,"",v.an) AN
            ,DATE_FORMAT(v.vstdate,"%Y%m%d") DATEOPD
            ,n.nhso_adp_type_id TYPE
            ,n.nhso_adp_code CODE 
            ,sum(v.QTY) QTY
            ,round(v.unitprice,2) RATE
            ,if(v.an is null,v.vn,"") SEQ
            ,"" CAGCODE,"" DOSE,"" CA_TYPE,"" SERIALNO,"0" TOTCOPAY,"" USE_STATUS,"0" TOTAL ,"" QTYDAY
            ,"" TMLTCODE
            ,"" STATUS1
            ,"" BI
            ,"" CLINIC
            ,"" ITEMSRC
            ,"" PROVIDER
            ,"" GLAVIDA
            ,"" GA_WEEK
            ,"" DCIP
            ,"0000-00-00" LMP
            from opitemrece v
            inner JOIN drugitems n on n.icode = v.icode and n.nhso_adp_code is not null
            left join ipt i on i.an = v.an
            left join claim.tempexport x on x.vn = v.vn
            where x.ACTIVE="N"
            AND i.an is NULL
            GROUP BY v.vn,n.nhso_adp_code,rate) b 
            GROUP BY seq,CODE,rate ;              
        ');
         
        foreach ($adpt_ as $key => $adp) {
            D_adp::insert([                        
                'HN'                => $adp->HN, 
                'AN'                => $adp->AN,
                'DATEOPD'           => $adp->DATEOPD,
                'TYPE'              => $adp->TYPE,
                'CODE'              => $adp->CODE,
                'QTY'               => $adp->QTY,
                'RATE'              => $adp->RATE,
                'SEQ'               => $adp->SEQ ,
                'CAGCODE'           => $adp->CAGCODE ,
                'DOSE'              => $adp->DOSE, 
                'CA_TYPE'           => $adp->CA_TYPE ,
                'SERIALNO'          => $adp->SERIALNO ,
                'TOTCOPAY'          => $adp->TOTCOPAY ,
                'USE_STATUS'        => $adp->USE_STATUS ,
                'TOTAL'             => $adp->TOTAL, 
                'QTYDAY'            => $adp->QTYDAY,
                'TMLTCODE'          => $adp->TMLTCODE,
                'STATUS1'           => $adp->STATUS1,
                'BI'                => $adp->BI,
                'CLINIC'            => $adp->CLINIC,
                'ITEMSRC'           => $adp->ITEMSRC,
                'PROVIDER'          => $adp->PROVIDER,
                'GLAVIDA'           => $adp->GLAVIDA,
                'GA_WEEK'           => $adp->GA_WEEK,
                'DCIP'              => $adp->DCIP,
                'LMP'               => $adp->LMP
            ]);
        }

        D_dru::truncate();
        $drut_ = DB::connection('mysql3')->select('   
            SELECT vv.hcode HCODE
            ,v.hn HN
            ,v.an AN
            ,vv.spclty CLINIC
            ,vv.cid PERSON_ID
            ,DATE_FORMAT(v.vstdate,"%Y%m%d") DATE_SERV
            ,d.icode DID
            ,concat(d.`name`," ",d.strength," ",d.units) DIDNAME
            ,v.qty AMOUNT
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
            , " " TOTAL,"" SIGCODE,""  SIGTEXT
            from opitemrece v
            LEFT JOIN drugitems d on d.icode = v.icode
            LEFT JOIN vn_stat vv on vv.vn = v.vn
            LEFT JOIN ovst_presc_ned oo on oo.vn = v.vn and oo.icode=v.icode
            left join claim.tempexport x on x.vn = v.vn
            where x.ACTIVE="N"
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
            ," " TOTAL,"" SIGCODE,""  SIGTEXT
            from opitemrece v
            LEFT JOIN drugitems d on d.icode = v.icode
            LEFT JOIN patient pt  on v.hn = pt.hn
            inner JOIN ipt v1 on v1.an = v.an
            LEFT JOIN ovst_presc_ned oo on oo.vn = v.vn and oo.icode=v.icode 
            left join claim.tempexport x on x.vn = v1.vn
            where x.ACTIVE="N"
            and d.did is not null AND v.qty<>"0"
            GROUP BY v.an,d.icode,USE_STATUS; 
        ');
         
        foreach ($drut_ as $key => $dru) {
            D_dru::insert([                        
                'HN'           => $dru->HN, 
                'HCODE'         => $dru->HCODE,
                'AN'            => $dru->AN,
                'CLINIC'        => $dru->CLINIC,
                'PERSON_ID'     => $dru->PERSON_ID,
                'DATE_SERV'     => $dru->DATE_SERV,
                'DID'           => $dru->DID,
                'DIDNAME'       => $dru->DIDNAME,
                'AMOUNT'        => $dru->AMOUNT,
                'DRUGPRIC'      => $dru->DRUGPRIC,
                'DRUGCOST'      => $dru->DRUGCOST,
                'DIDSTD'        => $dru->DIDSTD,
                'UNIT'          => $dru->UNIT,
                'UNIT_PACK'     => $dru->UNIT_PACK,
                'SEQ'           => $dru->SEQ,
                'DRUGREMARK'    => $dru->DRUGREMARK,
                'PA_NO'         => $dru->PA_NO,
                'TOTCOPAY'      => $dru->TOTCOPAY,
                'USE_STATUS'    => $dru->USE_STATUS,
                // 'STATUS1'       => $dru->STATUS1,
                'TOTAL'         => $dru->TOTAL,
                'SIGCODE'       => $dru->SIGCODE,
                'SIGTEXT'       => $dru->SIGTEXT 


            ]);
        }

        $ins_ = DB::connection('mysql7')->select('   
            SELECT * FROM d_ins   
        ');
        $pat_ = DB::connection('mysql7')->select('   
            SELECT * FROM d_pat   
        ');
        $opd_ = DB::connection('mysql7')->select('   
            SELECT * FROM d_opd   
        ');
        $odx_ = DB::connection('mysql7')->select('   
            SELECT * FROM d_odx   
        ');
        $adp_ = DB::connection('mysql7')->select('   
            SELECT * FROM d_adp   
        ');
        $dru_ = DB::connection('mysql7')->select('   
            SELECT * FROM d_dru   
        ');
 
        // return response()->json(['status' => '200']); 
        return view('claim.ktb',[
            'start'            => $datestart,
            'end'              => $dateend,
            'ins_'              => $ins_,
            'pat_'              => $pat_,
            'opd_'              => $opd_,
            'odx_'              => $odx_,
            'adp_'              => $adp_,
            'dru_'              => $dru_
        ]);
    }
    public function ktb_ancdental_search(Request $request)
    { 
        $datestart = $request->startdate;
        $dateend = $request->enddate;
        $data_opd = DB::connection('mysql3')->select('   
                SELECT if(dt.vstdate<"2022-09-01","",getwordnum(group_concat(if(d.icd10tm_operation_code in ("2387010", "2330011"),dt.vn,null) order by dt.vn),1)) vn 
                    ,pt.hn,p.cid,oo.an,v.vstdate,concat(p.pname,p.fname," ",p.lname) as FULLNAME,t.hipdata_code,v.income-v.discount_money-v.rcpt_money as ClaimAmt
                    
                    from person_anc a
                    join person p on p.person_id=a.person_id 
                    join patient pt on pt.cid=p.cid
                    left join person_anc_service  ps on ps.person_anc_id=a.person_anc_id 
                    LEFT JOIN dtmain dt on dt.hn=pt.hn  and dt.vstdate>a.lmp
                    LEFT JOIN dttm d on d.code=dt.tmcode
                    left join ovstdiag o on o.vn=dt.vn
                    left join vn_stat v on v.vn=o.vn
                    left join pttype t on t.pttype=v.pttype
                    left join opitemrece oo on oo.vn=o.vn
                    left join nondrugitems nd on nd.icode=oo.icode 
                    left join hshooterdb.m_stm s on s.vn = o.vn 
                    where d.code IN("000254","000253")
                    and v.vstdate BETWEEN "'.$datestart.'" AND "'.$dateend.'" 
                    and p.nationality="99" 
                    GROUP BY p.cid 
                    order by vn;
        ');
        Tempexport::truncate();
        foreach ($data_opd as $key => $value) {           
            $add= new Tempexport();
            $add->vn = $value->vn ;
            $add->hn = $value->hn; 
            $add->an = $value->an; 
            $add->cid = $value->cid; 
            $add->ACTIVE = 'N';
            $add->save();

            $check_vn = Stm::where('VN','=',$value->vn)->count(); 
            $datenow = date('Y-m-d H:m:s');
            if ($check_vn > 0) { 
            } else {
                Stm::insert([                        
                        'AN'                => $value->an, 
                        'VN'                => $value->vn,
                        'HN'                => $value->hn,
                        'PID'               => $value->cid,
                        'VSTDATE'           => $value->vstdate,
                        'FULLNAME'          => $value->FULLNAME,  
                        'MAININSCL'         => $value->hipdata_code,
                        'created_at'        => $datenow, 
                        'ClaimAmt'          =>$value->ClaimAmt
                    ]);
            }

        }

        $data_ktb_D04 = DB::connection('mysql3')->select(' 
                SELECT if(dt.vstdate<"2022-09-01","",getwordnum(group_concat(if(d.icd10tm_operation_code in ("2387010", "2330011"),dt.vn,null) order by dt.vn),1)) vn 
                    ,pt.hn,p.cid,a.preg_no,oo.an,asnumber(TIMESTAMPDIFF(WEEK,a.lmp,now())) ga_now
                    ,ce2be(a.lmp) lmp, ce2be(DATE_ADD(a.lmp, INTERVAL 168 DAY)) lastdate
                    ,d.icd10tm_operation_code as check_code ,v.vstdate
                    ,if(dt.vstdate is null,null,asnumber(TIMESTAMPDIFF(WEEK,a.lmp,dt.vstdate))) Scaling_Week
                    ,v.income money_hosxp,v.discount_money,v.rcpt_money,v.income-v.discount_money-v.rcpt_money debit
                    from person_anc a
                    join person p on p.person_id=a.person_id 
                    join patient pt on pt.cid=p.cid
                    left join person_anc_service  ps on ps.person_anc_id=a.person_anc_id 
                    LEFT JOIN dtmain dt on dt.hn=pt.hn  and dt.vstdate>a.lmp
                    LEFT JOIN dttm d on d.code=dt.tmcode
                    left join ovstdiag o on o.vn=dt.vn
                    left join vn_stat v on v.vn=o.vn
                    left join pttype t on t.pttype=v.pttype
                    left join opitemrece oo on oo.vn=o.vn
                    left join nondrugitems nd on nd.icode=oo.icode 
                    left join hshooterdb.m_stm s on s.vn = o.vn 
                    where d.code IN("000254","000253")
                    and v.vstdate BETWEEN "'.$datestart.'" AND "'.$dateend.'" 
                    and p.nationality="99" 
                    GROUP BY p.cid 
                    order by vn;
 
        '); 
       
        D_ktb_b17::truncate();
        foreach ($data_ktb_D04 as $key => $item2) { 
            $checkvn = D_ktb_b17::where('vn','=',$item2->vn)->count();
            $datenow = date('Y-m-d H:m:s');
            if ($checkvn > 0) { 
            } else { 
                D_ktb_b17::insert([                        
                    'vn'         => $item2->vn,
                    'hn'         => $item2->hn,
                    'an'         => $item2->an,
                    'cid'        => $item2->cid,
                    'vstdate'    => $item2->vstdate,
                    'created_at' => $datenow, 
                ]);
            }          

            $check_vn = Stm::where('VN','=',$item2->vn)->count(); 
            
            if ($check_vn > 0) { 
            } else {
                Stm::insert([                        
                        'AN'                => $item2->an, 
                        'VN'                => $item2->vn,
                        'HN'                => $item2->hn,
                        'PID'               => $item2->cid,
                        'VSTDATE'           => $item2->vstdate,
                        'FULLNAME'          => $item2->FULLNAME,  
                        'MAININSCL'         => "",
                        'created_at'        => $datenow, 
                        'ClaimAmt'          =>$item2->ClaimAmt
                    ]);
            }
            
        }

        D_ins::truncate();
        $inst_ = DB::connection('mysql3')->select('   
                SELECT v.hn HN
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
                ,v.vstdate

                from vn_stat v
                LEFT JOIN opitemrece o on o.vn = v.vn
                LEFT JOIN pttype p on p.pttype = v.pttype
                LEFT JOIN ipt i on i.vn = v.vn 
                LEFT JOIN pttype pp on pp.pttype = i.pttype
                left join ipt_pttype ap on ap.an = i.an
                left join visit_pttype vp on vp.vn = v.vn
                LEFT JOIN rcpt_debt r on r.vn = v.vn
                left join patient px on px.hn = v.hn
                left join claim.tempexport x on x.vn = v.vn
                where x.ACTIVE="N" 
                GROUP BY v.hn,v.vstdate; 
        ');
        
        foreach ($inst_ as $key => $ins) {
            D_ins::insert([                        
                'HN'                => $ins->HN, 
                'INSCL'             => $ins->INSCL,
                'SUBTYPE'            => $ins->SUBTYPE,
                'CID'               => $ins->CID,
                'DATEIN'            => $ins->DATEIN,
                'DATEEXP'           => $ins->DATEEXP,  
                'HOSPMAIN'          => $ins->HOSPMAIN,
                'HOSPSUB'           => $ins->HOSPSUB, 
                'GOVCODE'           =>$ins->GOVCODE,
                'GOVNAME'           =>$ins->GOVNAME,
                'PERMITNO'          =>$ins->PERMITNO,
                'DOCNO'             =>$ins->DOCNO,
                'OWNRPID'           =>$ins->OWNRPID,
                'OWNRNAME'          =>$ins->OWNRNAME,
                'AN'                =>$ins->AN,
                'SEQ'               =>$ins->SEQ,
                'SUBINSCL'          =>$ins->SUBINSCL,
                'RELINSCL'          =>$ins->RELINSCL,
                'HTYPE'             =>$ins->HTYPE
            ]);
        }

        D_pat::truncate();
        $patt_ = DB::connection('mysql3')->select('   
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
                LEFT JOIN opitemrece o on o.vn = v.vn
                LEFT JOIN pttype p on p.pttype = v.pttype
                LEFT JOIN ipt i on i.vn = v.vn  
                left join patient pt on pt.hn = v.hn
                left join claim.tempexport x on x.vn = v.vn
                where x.ACTIVE="N" 
                GROUP BY v.hn,v.vstdate; 
        ');
        
        foreach ($patt_ as $key => $pat) {
            D_pat::insert([                        
                'HN'                => $pat->HN, 
                'HCODE'             => $pat->HCODE,
                'CHANGWAT'          => $pat->CHANGWAT,
                'AMPHUR'            => $pat->AMPHUR,
                'DOB'               => $pat->DOB,
                'SEX'               => $pat->SEX,  
                'MARRIAGE'          => $pat->MARRIAGE,
                'OCCUPA'            => $pat->OCCUPA, 
                'NATION'            => $pat->NATION,
                'PERSON_ID'         => $pat->PERSON_ID,
                'NAMEPAT'           => $pat->NAMEPAT,
                'TITLE'             => $pat->TITLE,
                'FNAME'             => $pat->FNAME,
                'LNAME'             => $pat->LNAME,
                'IDTYPE'            => $pat->IDTYPE  
            ]);
        }

        D_opd::truncate();
        $opdt_ = DB::connection('mysql3')->select('   
                SELECT v.hn as HN
                ,v.spclty as CLINIC
                ,DATE_FORMAT(v.vstdate, "%Y%m%d") as DATEOPD
                ,concat(substr(o.vsttime,1,2),substr(o.vsttime,4,2)) as TIMEOPD
                ,v.vn as SEQ 
                ,"1" UUC
                ,v.vstdate 

                from vn_stat v
                LEFT JOIN ovst o on o.vn = v.vn
                LEFT JOIN pttype p on p.pttype = v.pttype
                LEFT JOIN ipt i on i.vn = v.vn 
                LEFT JOIN patient pt on pt.hn = v.hn
                left join claim.tempexport x on x.vn = v.vn
                where x.ACTIVE="N"                
                GROUP BY SEQ; 
        ');
        
        foreach ($opdt_ as $key => $opd) {
            D_opd::insert([                        
                'HN'                => $opd->HN, 
                'CLINIC'            => $opd->CLINIC,
                'DATEOPD'           => $opd->DATEOPD,
                'TIMEOPD'           => $opd->TIMEOPD,
                'SEQ'               => $opd->SEQ,
                'UUC'               => $opd->UUC 
            ]);
        }

        D_odx::truncate();
        $odxt_ = DB::connection('mysql3')->select('   
                SELECT v.hn HN
                ,DATE_FORMAT(v.vstdate,"%Y%m%d") DATEDX
                ,v.spclty CLINIC
                ,o.icd10 DIAG
                ,o.diagtype DXTYPE
                ,if(d.licenseno="","-99999",d.licenseno) DRDX
                ,v.cid PERSON_ID 
                ,v.vn SEQ
                ,v.vstdate 
                ,v.pttype

                from vn_stat v
                LEFT JOIN ovstdiag o on o.vn = v.vn
                LEFT JOIN doctor d on d.`code` = o.doctor
                inner JOIN icd101 i on i.code = o.icd10 
                left join claim.tempexport x on x.vn = v.vn
                where x.ACTIVE="N"  
                GROUP BY SEQ; 
        ');
         
        foreach ($odxt_ as $key => $odx) {
            D_odx::insert([                        
                'HN'                => $odx->HN, 
                'CLINIC'            => $odx->CLINIC,
                'DATEDX'            => $odx->DATEDX,
                'DIAG'              => $odx->DIAG,
                'DXTYPE'            => $odx->DXTYPE,
                'DRDX'              => $odx->DRDX,
                'PERSON_ID'         => $odx->PERSON_ID,
                'SEQ'               => $odx->SEQ 
            ]);
        }

        D_adp::truncate();
        $adpt_ = DB::connection('mysql3')->select('   
            SELECT HN,AN,DATEOPD,TYPE,CODE,sum(QTY) QTY
            ,RATE,SEQ
            ,"" CAGCODE,"" DOSE,"" CA_TYPE,"" SERIALNO,"" TOTCOPAY,"" USE_STATUS,"" TOTAL ,"" QTYDAY
            ,"" TMLTCODE
            ,"" STATUS1
            ,"" BI
            ,"" CLINIC
            ,"" ITEMSRC
            ,"" PROVIDER
            ,"" GLAVIDA
            ,"" GA_WEEK
            ,"" DCIP
            ,"0000-00-00" LMP
            from (SELECT v.hn HN
            ,if(v.an is null,"",v.an) AN
            ,DATE_FORMAT(v.rxdate,"%Y%m%d") DATEOPD
            ,n.nhso_adp_type_id TYPE
            ,n.nhso_adp_code CODE 
            ,sum(v.QTY) QTY
            ,round(v.unitprice,2) RATE
            ,if(v.an is null,v.vn,"") SEQ
            ,"" CAGCODE,"" DOSE,"" CA_TYPE,"" SERIALNO,"" TOTCOPAY,"" USE_STATUS,"" TOTAL ,"" QTYDAY
            ,"" TMLTCODE
            ,"" STATUS1
            ,"" BI
            ,"" CLINIC
            ,"" ITEMSRC
            ,"" PROVIDER
            ,"" GLAVIDA
            ,"" GA_WEEK
            ,"" DCIP
            ,"0000-00-00" LMP
            from opitemrece v
            inner JOIN drugitems n on n.icode = v.icode and n.nhso_adp_code is not null
            left join ipt i on i.an = v.an
            AND i.an is not NULL
            left join claim.tempexport x on x.vn = i.vn
            where x.ACTIVE="N"
            GROUP BY i.vn,n.nhso_adp_code,rate) a 
            GROUP BY an,CODE,rate
            UNION
            SELECT HN,AN,DATEOPD,TYPE,CODE,sum(QTY) QTY,RATE,SEQ,"" "" CAGCODE,"" DOSE,"" CA_TYPE,"" SERIALNO,"0" TOTCOPAY,"" USE_STATUS,"0" TOTAL ,"" QTYDAY
            ,""TMLTCODE
            ,"" STATUS1
            ,"" BI
            ,"" CLINIC
            ,"" ITEMSRC
            ,"" PROVIDER
            ,"" GLAVIDA
            ,"" GA_WEEK
            ,"" DCIP
            ,"0000-00-00" LMP
            from
            (SELECT v.hn HN
            ,if(v.an is null,"",v.an) AN
            ,DATE_FORMAT(v.vstdate,"%Y%m%d") DATEOPD
            ,n.nhso_adp_type_id TYPE
            ,n.nhso_adp_code CODE 
            ,sum(v.QTY) QTY
            ,round(v.unitprice,2) RATE
            ,if(v.an is null,v.vn,"") SEQ
            ,"" CAGCODE,"" DOSE,"" CA_TYPE,"" SERIALNO,"0" TOTCOPAY,"" USE_STATUS,"0" TOTAL ,"" QTYDAY
            ,"" TMLTCODE
            ,"" STATUS1
            ,"" BI
            ,"" CLINIC
            ,"" ITEMSRC
            ,"" PROVIDER
            ,"" GLAVIDA
            ,"" GA_WEEK
            ,"" DCIP
            ,"0000-00-00" LMP
            from opitemrece v
            inner JOIN drugitems n on n.icode = v.icode and n.nhso_adp_code is not null
            left join ipt i on i.an = v.an
            left join claim.tempexport x on x.vn = v.vn
            where x.ACTIVE="N"
            AND i.an is NULL
            GROUP BY v.vn,n.nhso_adp_code,rate) b 
            GROUP BY seq,CODE,rate ;              
        ');
         
        foreach ($adpt_ as $key => $adp) {
            D_adp::insert([                        
                'HN'                => $adp->HN, 
                'AN'                => $adp->AN,
                'DATEOPD'           => $adp->DATEOPD,
                'TYPE'              => $adp->TYPE,
                'CODE'              => $adp->CODE,
                'QTY'               => $adp->QTY,
                'RATE'              => $adp->RATE,
                'SEQ'               => $adp->SEQ ,
                'CAGCODE'           => $adp->CAGCODE ,
                'DOSE'              => $adp->DOSE, 
                'CA_TYPE'           => $adp->CA_TYPE ,
                'SERIALNO'          => $adp->SERIALNO ,
                'TOTCOPAY'          => $adp->TOTCOPAY ,
                'USE_STATUS'        => $adp->USE_STATUS ,
                'TOTAL'             => $adp->TOTAL, 
                'QTYDAY'            => $adp->QTYDAY,
                'TMLTCODE'          => $adp->TMLTCODE,
                'STATUS1'           => $adp->STATUS1,
                'BI'                => $adp->BI,
                'CLINIC'            => $adp->CLINIC,
                'ITEMSRC'           => $adp->ITEMSRC,
                'PROVIDER'          => $adp->PROVIDER,
                'GLAVIDA'           => $adp->GLAVIDA,
                'GA_WEEK'           => $adp->GA_WEEK,
                'DCIP'              => $adp->DCIP,
                'LMP'               => $adp->LMP
            ]);
        }

        D_dru::truncate();
        $drut_ = DB::connection('mysql3')->select('   
            SELECT vv.hcode HCODE
            ,v.hn HN
            ,v.an AN
            ,vv.spclty CLINIC
            ,vv.cid PERSON_ID
            ,DATE_FORMAT(v.vstdate,"%Y%m%d") DATE_SERV
            ,d.icode DID
            ,concat(d.`name`," ",d.strength," ",d.units) DIDNAME
            ,v.qty AMOUNT
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
            , " " TOTAL,"" SIGCODE,""  SIGTEXT
            from opitemrece v
            LEFT JOIN drugitems d on d.icode = v.icode
            LEFT JOIN vn_stat vv on vv.vn = v.vn
            LEFT JOIN ovst_presc_ned oo on oo.vn = v.vn and oo.icode=v.icode
            left join claim.tempexport x on x.vn = v.vn
            where x.ACTIVE="N"
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
            ," " TOTAL,"" SIGCODE,""  SIGTEXT
            from opitemrece v
            LEFT JOIN drugitems d on d.icode = v.icode
            LEFT JOIN patient pt  on v.hn = pt.hn
            inner JOIN ipt v1 on v1.an = v.an
            LEFT JOIN ovst_presc_ned oo on oo.vn = v.vn and oo.icode=v.icode 
            left join claim.tempexport x on x.vn = v1.vn
            where x.ACTIVE="N"
            and d.did is not null AND v.qty<>"0"
            GROUP BY v.an,d.icode,USE_STATUS; 
        ');
         
        foreach ($drut_ as $key => $dru) {
            D_dru::insert([                        
                'HN'           => $dru->HN, 
                'HCODE'         => $dru->HCODE,
                'AN'            => $dru->AN,
                'CLINIC'        => $dru->CLINIC,
                'PERSON_ID'     => $dru->PERSON_ID,
                'DATE_SERV'     => $dru->DATE_SERV,
                'DID'           => $dru->DID,
                'DIDNAME'       => $dru->DIDNAME,
                'AMOUNT'        => $dru->AMOUNT,
                'DRUGPRIC'      => $dru->DRUGPRIC,
                'DRUGCOST'      => $dru->DRUGCOST,
                'DIDSTD'        => $dru->DIDSTD,
                'UNIT'          => $dru->UNIT,
                'UNIT_PACK'     => $dru->UNIT_PACK,
                'SEQ'           => $dru->SEQ,
                'DRUGREMARK'    => $dru->DRUGREMARK,
                'PA_NO'         => $dru->PA_NO,
                'TOTCOPAY'      => $dru->TOTCOPAY,
                'USE_STATUS'    => $dru->USE_STATUS,
                // 'STATUS1'       => $dru->STATUS1,
                'TOTAL'         => $dru->TOTAL,
                'SIGCODE'       => $dru->SIGCODE,
                'SIGTEXT'       => $dru->SIGTEXT 
            ]);
        }

        $ins_ = DB::connection('mysql7')->select('   
            SELECT * FROM d_ins   
        ');
        $pat_ = DB::connection('mysql7')->select('   
            SELECT * FROM d_pat   
        ');
        $opd_ = DB::connection('mysql7')->select('   
            SELECT * FROM d_opd   
        ');
        $odx_ = DB::connection('mysql7')->select('   
            SELECT * FROM d_odx   
        ');
        $adp_ = DB::connection('mysql7')->select('   
            SELECT * FROM d_adp   
        ');
        $dru_ = DB::connection('mysql7')->select('   
            SELECT * FROM d_dru   
        ');
 
        // return response()->json(['status' => '200']); 
        return view('claim.ktb',[
            'start'            => $datestart,
            'end'              => $dateend,
            'ins_'              => $ins_,
            'pat_'              => $pat_,
            'opd_'              => $opd_,
            'odx_'              => $odx_,
            'adp_'              => $adp_,
            'dru_'              => $dru_
        ]);
    }
    
    public function anc_Pregnancy_test(Request $request)
    { 
        $datestart = $request->startdate;
        $dateend = $request->enddate;
        $ins_ = DB::connection('mysql7')->select('   
            SELECT * FROM d_ins   
        ');
        $pat_ = DB::connection('mysql7')->select('   
            SELECT * FROM d_pat   
        ');
        $opd_ = DB::connection('mysql7')->select('   
            SELECT * FROM d_opd   
        ');
        $odx_ = DB::connection('mysql7')->select('   
            SELECT * FROM d_odx   
        ');
        $adp_ = DB::connection('mysql7')->select('   
            SELECT * FROM d_adp   
        ');
        $dru_ = DB::connection('mysql7')->select('   
            SELECT * FROM d_dru   
        ');

        return view('claim.anc_Pregnancy_test',[
            'start'            => $datestart,
            'end'              => $dateend,
            'ins_'              => $ins_,
            'pat_'              => $pat_,
            'opd_'              => $opd_,
            'odx_'              => $odx_,
            'adp_'              => $adp_,
            'dru_'              => $dru_
        ]);
    }
    public function anc_Pregnancy_testsearch(Request $request)
    { 
        $datestart = $request->startdate;
        $dateend = $request->enddate;
        // $data_opd = DB::connection('mysql3')->select(' 
        //     SELECT p.hn,v.vn,p.cid,i.an,v.vstdate 
        //         from hos.ovst o 
        //         left join vn_stat v on v.vn=o.vn
        //         left join opitemrece oo on oo.vn = o.vn  
        //         left join patient pt on pt.hn=o.hn
        //         left join ipt i on i.vn=v.vn 
        //         left outer join patient p on p.hn = v.hn
        //         left join s_drugitems n on n.icode = oo.icode
        //         left join pttype ptt on ptt.pttype=o.pttype   
               
        //         WHERE v.vstdate BETWEEN "'.$datestart.'" AND "'.$dateend.'"   
        //         and n.nhso_adp_code in ("31101","30014")
        //         and pt.sex=2
        //         group by o.vn;
        // ');
        $data_opd = DB::connection('mysql3')->select(' 
                SELECT o.vn,i.an
                ,o.hn,p.cid
                ,concat(p.pname,p.fname," ",p.lname) as ptname
                ,o.pttype 
                ,group_concat(distinct og.icd10) "icd10&9"
                ,n.name as nname 
                ,v.uc_money  
                ,s.amountpay  
                from vn_stat v
                left join opitemrece o on o.vn = v.vn 
                left join s_drugitems n on n.icode = o.icode
                left join ipt i on i.vn=v.vn
                left join opdscreen od on od.vn=v.vn
                left join ovstdiag og on og.vn=v.vn
                left outer join patient p on p.hn = v.hn  
                left join hshooterdb.m_stm s on s.vn = v.vn
                WHERE v.vstdate BETWEEN "'.$datestart.'" AND "'.$dateend.'"   
                and n.nhso_adp_code in ("31101","30014")
                and p.sex = 2 
                and o.an is null
                GROUP BY v.hn,v.vstdate;
        ');

       
        Tempexport::truncate();
        foreach ($data_opd as $key => $value) {           
            $add= new Tempexport();
            $add->vn = $value->vn ;
            $add->hn = $value->hn; 
            $add->an = $value->an; 
            $add->cid = $value->cid; 
            $add->ACTIVE = 'N';
            $add->save();
        }

        $data_ktb_b17 = DB::connection('mysql3')->select('  
            SELECT p.hn,v.vn,p.cid,i.an,v.vstdate ,CONCAT(pt.pname,pt.fname," ",pt.lname) AS FULLNAME,v.uc_money,v.uc_money AS ClaimAmt
                from hos.ovst o 
                left join vn_stat v on v.vn=o.vn
                left join opitemrece oo on oo.vn = o.vn  
                left join patient pt on pt.hn=o.hn
                left join ipt i on i.vn=v.vn 
                left outer join patient p on p.hn = v.hn
                left join nondrugitems d on d.icode=oo.icode  and d.nhso_adp_code in("30014","31101")
                left join pttype ptt on ptt.pttype=o.pttype   
               
                WHERE v.vstdate BETWEEN "'.$datestart.'" AND "'.$dateend.'"  
                and (o.an="" or o.an is null)
                and pt.nationality="99" and pt.sex=2  and ptt.pttype_eclaim_id<>"27"
                and ((d.nhso_adp_code in("30014","31101")) or v.pdx in("Z321","Z320"))
                group by o.vn;

              
        '); 
       
        // D_ktb_b17::truncate();
        foreach ($data_ktb_b17 as $key => $item2) { 
            $checkvn = D_ktb_b17::where('vn','=',$item2->vn)->count();
            $datenow = date('Y-m-d H:m:s');
            if ($checkvn > 0) { 
            } else { 
                D_ktb_b17::insert([                        
                    'vn'         => $item2->vn,
                    'hn'         => $item2->hn,
                    'an'         => $item2->an,
                    'cid'        => $item2->cid,
                    'vstdate'    => $item2->vstdate,
                    'created_at' => $datenow, 
                ]);
            }          

            $check_vn = Stm::where('VN','=',$item2->vn)->count(); 
            
            if ($check_vn > 0) { 
            } else {
                Stm::insert([                        
                        'AN'                => $item2->an, 
                        'VN'                => $item2->vn,
                        'HN'                => $item2->hn,
                        'PID'               => $item2->cid,
                        'VSTDATE'           => $item2->vstdate,
                        'FULLNAME'          => $item2->FULLNAME,  
                        'MAININSCL'         => "",
                        'created_at'        => $datenow, 
                        'ClaimAmt'          =>$item2->ClaimAmt
                    ]);
            }
            
        }

        D_ins::truncate();
        $inst_ = DB::connection('mysql3')->select('   
                SELECT v.hn HN
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
                ,v.vstdate

                from vn_stat v
                LEFT JOIN opitemrece o on o.vn = v.vn
                LEFT JOIN pttype p on p.pttype = v.pttype
                LEFT JOIN ipt i on i.vn = v.vn 
                LEFT JOIN pttype pp on pp.pttype = i.pttype
                left join ipt_pttype ap on ap.an = i.an
                left join visit_pttype vp on vp.vn = v.vn
                LEFT JOIN rcpt_debt r on r.vn = v.vn
                left join patient px on px.hn = v.hn
                left join claim.tempexport x on x.vn = v.vn
                where x.ACTIVE="N" 
                GROUP BY v.hn,v.vstdate; 
        ');
        
        foreach ($inst_ as $key => $ins) {
            D_ins::insert([                        
                'HN'                => $ins->HN, 
                'INSCL'             => $ins->INSCL,
                'SUBTYPE'            => $ins->SUBTYPE,
                'CID'               => $ins->CID,
                'DATEIN'            => $ins->DATEIN,
                'DATEEXP'           => $ins->DATEEXP,  
                'HOSPMAIN'          => $ins->HOSPMAIN,
                'HOSPSUB'           => $ins->HOSPSUB, 
                'GOVCODE'           =>$ins->GOVCODE,
                'GOVNAME'           =>$ins->GOVNAME,
                'PERMITNO'          =>$ins->PERMITNO,
                'DOCNO'             =>$ins->DOCNO,
                'OWNRPID'           =>$ins->OWNRPID,
                'OWNRNAME'          =>$ins->OWNRNAME,
                'AN'                =>$ins->AN,
                'SEQ'               =>$ins->SEQ,
                'SUBINSCL'          =>$ins->SUBINSCL,
                'RELINSCL'          =>$ins->RELINSCL,
                'HTYPE'             =>$ins->HTYPE
            ]);
        }

        D_pat::truncate();
        $patt_ = DB::connection('mysql3')->select('   
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
                LEFT JOIN opitemrece o on o.vn = v.vn
                LEFT JOIN pttype p on p.pttype = v.pttype
                LEFT JOIN ipt i on i.vn = v.vn  
                left join patient pt on pt.hn = v.hn
                left join claim.tempexport x on x.vn = v.vn
                where x.ACTIVE="N" 
                GROUP BY v.hn,v.vstdate; 
        ');
        
        foreach ($patt_ as $key => $pat) {
            D_pat::insert([                        
                'HN'                => $pat->HN, 
                'HCODE'             => $pat->HCODE,
                'CHANGWAT'          => $pat->CHANGWAT,
                'AMPHUR'            => $pat->AMPHUR,
                'DOB'               => $pat->DOB,
                'SEX'               => $pat->SEX,  
                'MARRIAGE'          => $pat->MARRIAGE,
                'OCCUPA'            => $pat->OCCUPA, 
                'NATION'            => $pat->NATION,
                'PERSON_ID'         => $pat->PERSON_ID,
                'NAMEPAT'           => $pat->NAMEPAT,
                'TITLE'             => $pat->TITLE,
                'FNAME'             => $pat->FNAME,
                'LNAME'             => $pat->LNAME,
                'IDTYPE'            => $pat->IDTYPE  
            ]);
        }

        D_opd::truncate();
        $opdt_ = DB::connection('mysql3')->select('   
                SELECT v.hn as HN
                ,v.spclty as CLINIC
                ,DATE_FORMAT(v.vstdate, "%Y%m%d") as DATEOPD
                ,concat(substr(o.vsttime,1,2),substr(o.vsttime,4,2)) as TIMEOPD
                ,v.vn as SEQ 
                ,"1" UUC
                ,v.vstdate 

                from vn_stat v
                LEFT JOIN ovst o on o.vn = v.vn
                LEFT JOIN pttype p on p.pttype = v.pttype
                LEFT JOIN ipt i on i.vn = v.vn 
                LEFT JOIN patient pt on pt.hn = v.hn
                left join claim.tempexport x on x.vn = v.vn
                where x.ACTIVE="N"                
                GROUP BY SEQ; 
        ');
        
        foreach ($opdt_ as $key => $opd) {
            D_opd::insert([                        
                'HN'                => $opd->HN, 
                'CLINIC'            => $opd->CLINIC,
                'DATEOPD'           => $opd->DATEOPD,
                'TIMEOPD'           => $opd->TIMEOPD,
                'SEQ'               => $opd->SEQ,
                'UUC'               => $opd->UUC 
            ]);
        }

        D_odx::truncate();
        $odxt_ = DB::connection('mysql3')->select('   
                SELECT v.hn HN
                ,DATE_FORMAT(v.vstdate,"%Y%m%d") DATEDX
                ,v.spclty CLINIC
                ,o.icd10 DIAG
                ,o.diagtype DXTYPE
                ,if(d.licenseno="","-99999",d.licenseno) DRDX
                ,v.cid PERSON_ID 
                ,v.vn SEQ
                ,v.vstdate 
                ,v.pttype

                from vn_stat v
                LEFT JOIN ovstdiag o on o.vn = v.vn
                LEFT JOIN doctor d on d.`code` = o.doctor
                inner JOIN icd101 i on i.code = o.icd10 
                left join claim.tempexport x on x.vn = v.vn
                where x.ACTIVE="N"  
                GROUP BY SEQ; 
        ');
         
        foreach ($odxt_ as $key => $odx) {
            D_odx::insert([                        
                'HN'                => $odx->HN, 
                'CLINIC'            => $odx->CLINIC,
                'DATEDX'            => $odx->DATEDX,
                'DIAG'              => $odx->DIAG,
                'DXTYPE'            => $odx->DXTYPE,
                'DRDX'              => $odx->DRDX,
                'PERSON_ID'         => $odx->PERSON_ID,
                'SEQ'               => $odx->SEQ 
            ]);
        }

        D_adp::truncate();
        $adpt_ = DB::connection('mysql3')->select('   
            SELECT HN,AN,DATEOPD,TYPE,CODE,sum(QTY) QTY
            ,RATE,SEQ
            ,"" CAGCODE,"" DOSE,"" CA_TYPE,"" SERIALNO,"" TOTCOPAY,"" USE_STATUS,"" TOTAL ,"" QTYDAY
            ,"" TMLTCODE
            ,"" STATUS1
            ,"" BI
            ,"" CLINIC
            ,"" ITEMSRC
            ,"" PROVIDER
            ,"" GLAVIDA
            ,"" GA_WEEK
            ,"" DCIP
            ,"00000000" LMP
            from (SELECT v.hn HN
            ,if(v.an is null,"",v.an) AN
            ,DATE_FORMAT(v.rxdate,"%Y%m%d") DATEOPD
            ,n.nhso_adp_type_id TYPE
            ,n.nhso_adp_code CODE 
            ,sum(v.QTY) QTY
            ,round(v.unitprice,2) RATE
            ,if(v.an is null,v.vn,"") SEQ
            ,"" CAGCODE,"" DOSE,"" CA_TYPE,"" SERIALNO,"" TOTCOPAY,"" USE_STATUS,"" TOTAL ,"" QTYDAY
            ,"" TMLTCODE
            ,"" STATUS1
            ,"" BI
            ,"" CLINIC
            ,"" ITEMSRC
            ,"" PROVIDER
            ,"" GLAVIDA
            ,"" GA_WEEK
            ,"" DCIP
            ,"00000000" LMP
            from opitemrece v
            inner JOIN s_drugitems n on n.icode = v.icode and n.nhso_adp_code is not null
            left join ipt i on i.an = v.an
            AND i.an is not NULL
            left join claim.tempexport x on x.vn = i.vn
            where x.ACTIVE="N"
            and n.nhso_adp_code in ("31101","30014")
            GROUP BY i.vn,n.nhso_adp_code,rate) a 
            GROUP BY an,CODE,rate
            UNION
            SELECT HN,AN,DATEOPD,TYPE,CODE,sum(QTY) QTY,RATE,SEQ,"" "" CAGCODE,"" DOSE,"" CA_TYPE,"" SERIALNO,"0" TOTCOPAY,"" USE_STATUS,"0" TOTAL ,"" QTYDAY
            ,""TMLTCODE
            ,"" STATUS1
            ,"" BI
            ,"" CLINIC
            ,"" ITEMSRC
            ,"" PROVIDER
            ,"" GLAVIDA
            ,"" GA_WEEK
            ,"" DCIP
            ,"00000000" LMP
            from
            (SELECT v.hn HN
            ,if(v.an is null,"",v.an) AN
            ,DATE_FORMAT(v.vstdate,"%Y%m%d") DATEOPD
            ,n.nhso_adp_type_id TYPE
            ,n.nhso_adp_code CODE 
            ,sum(v.QTY) QTY
            ,round(v.unitprice,2) RATE
            ,if(v.an is null,v.vn,"") SEQ
            ,"" CAGCODE,"" DOSE,"" CA_TYPE,"" SERIALNO,"0" TOTCOPAY,"" USE_STATUS,"0" TOTAL ,"" QTYDAY
            ,"" TMLTCODE
            ,"" STATUS1
            ,"" BI
            ,"" CLINIC
            ,"" ITEMSRC
            ,"" PROVIDER
            ,"" GLAVIDA
            ,"" GA_WEEK
            ,"" DCIP
            ,"00000000" LMP
            from opitemrece v
            inner JOIN s_drugitems n on n.icode = v.icode and n.nhso_adp_code is not null
            left join ipt i on i.an = v.an
            left join claim.tempexport x on x.vn = v.vn
            where x.ACTIVE="N"
            and n.nhso_adp_code in ("31101","30014")
            AND i.an is NULL
            GROUP BY v.vn,n.nhso_adp_code,rate) b 
            GROUP BY seq,CODE,rate ;              
        ');
         
        foreach ($adpt_ as $key => $adp) {
            D_adp::insert([                        
                'HN'                => $adp->HN, 
                'AN'                => $adp->AN,
                'DATEOPD'           => $adp->DATEOPD,
                'TYPE'              => $adp->TYPE,
                'CODE'              => $adp->CODE,
                'QTY'               => $adp->QTY,
                'RATE'              => $adp->RATE,
                'SEQ'               => $adp->SEQ ,
                'CAGCODE'           => $adp->CAGCODE ,
                'DOSE'              => $adp->DOSE, 
                'CA_TYPE'           => $adp->CA_TYPE ,
                'SERIALNO'          => $adp->SERIALNO ,
                'TOTCOPAY'          => $adp->TOTCOPAY ,
                'USE_STATUS'        => $adp->USE_STATUS ,
                'TOTAL'             => $adp->TOTAL, 
                'QTYDAY'            => $adp->QTYDAY,
                'TMLTCODE'          => $adp->TMLTCODE,
                'STATUS1'           => $adp->STATUS1,
                'BI'                => $adp->BI,
                'CLINIC'            => $adp->CLINIC,
                'ITEMSRC'           => $adp->ITEMSRC,
                'PROVIDER'          => $adp->PROVIDER,
                'GLAVIDA'           => $adp->GLAVIDA,
                'GA_WEEK'           => $adp->GA_WEEK,
                'DCIP'              => $adp->DCIP,
                'LMP'               => $adp->LMP
            ]);
        }

        D_dru::truncate();
        $drut_ = DB::connection('mysql3')->select('   
            SELECT vv.hcode HCODE
            ,v.hn HN
            ,v.an AN
            ,vv.spclty CLINIC
            ,vv.cid PERSON_ID
            ,DATE_FORMAT(v.vstdate,"%Y%m%d") DATE_SERV
            ,d.icode DID
            ,concat(d.`name`," ",d.strength," ",d.units) DIDNAME
            ,v.qty AMOUNT
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
            , " " TOTAL,"" SIGCODE,""  SIGTEXT
            from opitemrece v
            LEFT JOIN drugitems d on d.icode = v.icode
            LEFT JOIN vn_stat vv on vv.vn = v.vn
            LEFT JOIN ovst_presc_ned oo on oo.vn = v.vn and oo.icode=v.icode
            left join claim.tempexport x on x.vn = v.vn
            where x.ACTIVE="N"
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
            ," " TOTAL,"" SIGCODE,""  SIGTEXT
            from opitemrece v
            LEFT JOIN drugitems d on d.icode = v.icode
            LEFT JOIN patient pt  on v.hn = pt.hn
            inner JOIN ipt v1 on v1.an = v.an
            LEFT JOIN ovst_presc_ned oo on oo.vn = v.vn and oo.icode=v.icode 
            left join claim.tempexport x on x.vn = v1.vn
            where x.ACTIVE="N"
            and d.did is not null AND v.qty<>"0"
            GROUP BY v.an,d.icode,USE_STATUS; 
        ');
         
        foreach ($drut_ as $key => $dru) {
            D_dru::insert([                        
                'HN'           => $dru->HN, 
                'HCODE'         => $dru->HCODE,
                'AN'            => $dru->AN,
                'CLINIC'        => $dru->CLINIC,
                'PERSON_ID'     => $dru->PERSON_ID,
                'DATE_SERV'     => $dru->DATE_SERV,
                'DID'           => $dru->DID,
                'DIDNAME'       => $dru->DIDNAME,
                'AMOUNT'        => $dru->AMOUNT,
                'DRUGPRIC'      => $dru->DRUGPRIC,
                'DRUGCOST'      => $dru->DRUGCOST,
                'DIDSTD'        => $dru->DIDSTD,
                'UNIT'          => $dru->UNIT,
                'UNIT_PACK'     => $dru->UNIT_PACK,
                'SEQ'           => $dru->SEQ,
                'DRUGREMARK'    => $dru->DRUGREMARK,
                'PA_NO'         => $dru->PA_NO,
                'TOTCOPAY'      => $dru->TOTCOPAY,
                'USE_STATUS'    => $dru->USE_STATUS,
                // 'STATUS1'       => $dru->STATUS1,
                'TOTAL'         => $dru->TOTAL,
                'SIGCODE'       => $dru->SIGCODE,
                'SIGTEXT'       => $dru->SIGTEXT 


            ]);
        }

        $ins_ = DB::connection('mysql7')->select('   
            SELECT * FROM d_ins   
        ');
        $pat_ = DB::connection('mysql7')->select('   
            SELECT * FROM d_pat   
        ');
        $opd_ = DB::connection('mysql7')->select('   
            SELECT * FROM d_opd   
        ');
        $odx_ = DB::connection('mysql7')->select('   
            SELECT * FROM d_odx   
        ');
        $adp_ = DB::connection('mysql7')->select('   
            SELECT * FROM d_adp   
        ');
        $dru_ = DB::connection('mysql7')->select('   
            SELECT * FROM d_dru   
        ');
 
        // return response()->json(['status' => '200']); 
        return view('claim.ktb',[
            'start'            => $datestart,
            'end'              => $dateend,
            'ins_'              => $ins_,
            'pat_'              => $pat_,
            'opd_'              => $opd_,
            'odx_'              => $odx_,
            'adp_'              => $adp_,
            'dru_'              => $dru_
        ]);
    }

    public function anc_Pregnancy_test_export(Request $request)
    { 
        $datestart = $request->startdate;
        $dateend = $request->enddate;

        $date_now = date("Y-m-d");
        $yy = date("Y")+543;
        $y = substr(date("Y"),2);
        $yx = substr($yy,2);
        $m = date('m');
        $t = date("Hi");
        $time_now = date("H:i");

        // dd($yx);
      
         #ตัดขีด, ตัด : ออก
        // $year = substr(date("Y"),2) +43;
        // $mounts = date('m');
        // $day = date('d');
        // $time = date("His");  
        // $vn = $year.''.$mounts.''.$day.''.$time;
        // dd($y);
        #sessionid เป็นค่าว่าง แสดงว่ายังไม่เคยส่งออก ต้องสร้างไอดีใหม่ จาก max+1
        $maxid = D_export::max('session_no');
        $session_no = $maxid+1;        

        #ตัดขีด, ตัด : ออก
        $pattern_date = '/-/i';
        $date_now_preg = preg_replace($pattern_date, '', $date_now);
        $pattern_time = '/:/i';
        $time_now_preg = preg_replace($pattern_time, '', $time_now);
        #ตัดขีด, ตัด : ออก

        $folder='10978_KTBBIL_'.$session_no.'_01_'.$date_now_preg.'-'.$time_now_preg;

        $add = new D_export();
        $add->session_no = $session_no;
        $add->session_date = $date_now;
        $add->session_time = $time_now;
        $add->session_filename = $folder;
        $add->session_ststus = "Send";
        $add->ACTIVE = "Y";
        $add->save();

        mkdir ('C:/export/'.$folder, 0777, true);
   
        // ดาวโหลด
        // header("Content-type: text/txt");
        // header("Cache-Control: no-store, no-cache");
        // header('Content-Disposition: attachment; filename="content.txt"');

        $file_pat = "C:/export/".$folder."/ADP".$yx."".$m."".$t.".txt";     
        $objFopen_opd = fopen($file_pat, 'w');

        $file_pat2 = "C:/export/".$folder."/DRU".$yx."".$m."".$t.".txt";     
        $objFopen_opd2 = fopen($file_pat2, 'w');

        $file_pat3 = "C:/export/".$folder."/INS".$yx."".$m."".$t.".txt";     
        $objFopen_opd3 = fopen($file_pat3, 'w');

        $file_pat4 = "C:/export/".$folder."/ODX".$yx."".$m."".$t.".txt";     
        $objFopen_opd4 = fopen($file_pat4, 'w');

        $file_pat5 = "C:/export/".$folder."/OPD".$yx."".$m."".$t.".txt";     
        $objFopen_opd5 = fopen($file_pat5, 'w');

        $file_pat6 = "C:/export/".$folder."/PAT".$yx."".$m."".$t.".txt";     
        $objFopen_opd6 = fopen($file_pat6, 'w');

        // ********* ADP****
        $opd_head = 'HN|AN|DATEOPD|TYPE|CODE|QTY|RATE|SEQ|CAGCODE|DOSE|CA_TYPE|SERIALNO|TOTCOPAY|USE_STATUS|TOTAL|QTYDAY|TMLTCODE|STATUS1|BI|CLINIC|ITEMSRC|PROVIDER|GLAVIDA|GA_WEEK|DCIP|LMP';
        fwrite($objFopen_opd, $opd_head);
        $adp_data = DB::connection('mysql7')->select('   
            SELECT HN,AN,DATEOPD,TYPE,CODE,QTY,RATE,SEQ,CAGCODE,DOSE,CA_TYPE,SERIALNO,TOTCOPAY,USE_STATUS ,TOTAL ,QTYDAY ,TMLTCODE,STATUS1,BI,CLINIC,ITEMSRC,PROVIDER,GLAVIDA,GA_WEEK,DCIP,LMP
            FROM d_adp 
        '); 
        foreach ($adp_data as $key => $val1) {
            $b1 = $val1->HN; $b2 = $val1->AN; $b3 = $val1->DATEOPD; $b4 = $val1->TYPE; $b5 = $val1->CODE; 
            $b6 = $val1->QTY; $b7 = $val1->RATE;  $b8 = $val1->SEQ; $b9 = $val1->CAGCODE;  $b10 = $val1->DOSE;   
            $b11 = $val1->CA_TYPE; $b12 = $val1->SERIALNO; $b13 = $val1->TOTCOPAY;  $b14= $val1->USE_STATUS;
            $b15 = $val1->TOTAL; $b16= $val1->QTYDAY; $b17= $val1->TMLTCODE; $b18 = $val1->STATUS1;
            $b19 = $val1->BI;  $b20 = $val1->CLINIC; $b21 = $val1->ITEMSRC;  $b22 = $val1->PROVIDER;
            $b23 = $val1->GLAVIDA;  $b24 = $val1->GA_WEEK; $b25 = $val1->DCIP; $b26 = $val1->LMP;
            $strText1="\n".$b1."|".$b2."|".$b3."|".$b4."|".$b5."|".$b6."|".$b7."|".$b8."|".$b9."|".$b10."|".$b11."|".$b12."|".$b13."|".$b14."|".$b15."|".$b16."|".$b17."|".$b18."|".$b19."|".$b20."|".$b21."|".$b22."|".$b23."|".$b24."|".$b25."|".$b26;
            $ansitxt_pat1 = iconv('UTF-8', 'TIS-620', $strText1);
            fwrite($objFopen_opd, $ansitxt_pat1);
        }

        // ********* DRU**** 
        $opd_head2 = 'HCODE|HN|AN|CLINIC|PERSON_ID|DATE_SERV|DID|DIDNAME|AMOUNT|DRUGPRIC|DRUGCOST|DIDSTD|UNIT|UNIT_PACK|SEQ|DRUGREMARK|PA_NO|TOTCOPAY|USE_STATUS|TOTAL|SIGCODE|SIGTEXT';
        fwrite($objFopen_opd2, $opd_head2);
        $dru_data = DB::connection('mysql7')->select('   
            SELECT HCODE,HN,AN,CLINIC,PERSON_ID,DATE_SERV,DID,DIDNAME,AMOUNT,DRUGPRIC,DRUGCOST,DIDSTD,UNIT,UNIT_PACK ,SEQ ,DRUGREMARK ,PA_NO,TOTCOPAY,USE_STATUS,TOTAL,SIGCODE,SIGTEXT 
            FROM d_dru 
        ');
        foreach ($dru_data as $key => $val2) {
            $c1 = $val2->HCODE; 
            $c2 = $val2->HN;
            $c3 = $val2->AN; 
            $c4 = $val2->CLINIC; 
            $c5 = $val2->PERSON_ID; 
            $c6 = $val2->DATE_SERV; 
            $c7 = $val2->DID;  
            $c8 = $val2->DIDNAME; 
            $c9 = $val2->AMOUNT;  
            $c10 = $val2->DRUGPRIC;   
            $c11 = $val2->DRUGCOST; 
            $c12 = $val2->DIDSTD; 
            $c13 = $val2->UNIT;  
            $c14= $val2->UNIT_PACK;
            $c15 = $val2->SEQ; 
            $c16= $val2->DRUGREMARK; 
            $c17= $val2->PA_NO; 
            $c18 = $val2->USE_STATUS;
            $c19 = $val2->TOTAL;  
            $c20 = $val2->SIGCODE; 
            $c21 = $val2->SIGTEXT; 
            $strText2="\n".$c1."|".$c2."|".$c3."|".$c4."|".$c5."|".$c6."|".$c7."|".$c8."|".$c9."|".$c10."|".$c11."|".$c12."|".$c13."|".$c14."|".$c15."|".$c16."|".$c17."|".$c18."|".$c19."|".$c20."|".$c21;
            $ansitxt_pat2 = iconv('UTF-8', 'TIS-620', $strText2);
            fwrite($objFopen_opd2, $ansitxt_pat2);
        }

        // ********* INS**** 
        $opd_head3 = 'HN|INSCL|SUBTYPE|CID|DATEIN|DATEEXP|HOSPMAIN|HOSPSUB|GOVCODE|GOVNAME|PERMITNO|DOCNO|OWNRPID|OWNRNAME|AN|SEQ|SUBINSCL|RELINSCL|HTYPE';
        fwrite($objFopen_opd3, $opd_head3);
        $ins_data = DB::connection('mysql7')->select('   
            SELECT HN,INSCL,SUBTYPE,CID,DATEIN,DATEEXP,HOSPMAIN,HOSPSUB,GOVCODE,GOVNAME,PERMITNO,DOCNO,OWNRPID,OWNRNAME ,AN ,SEQ ,SUBINSCL,RELINSCL,HTYPE  
            FROM d_ins 
        ');
        foreach ($ins_data as $key => $val3) {
            $cc1 = $val3->HN; 
            $cc2 = $val3->INSCL;
            $cc3 = $val3->SUBTYPE; 
            $cc4 = $val3->CID; 
            $cc5 = $val3->DATEIN; 
            $cc6 = $val3->DATEEXP; 
            $cc7 = $val3->HOSPMAIN;  
            $cc8 = $val3->HOSPSUB; 
            $cc9 = $val3->GOVCODE;  
            $cc10 = $val3->GOVNAME;   
            $cc11 = $val3->PERMITNO; 
            $cc12 = $val3->DOCNO; 
            $cc13 = $val3->OWNRPID;  
            $cc14= $val3->OWNRNAME;
            $cc15 = $val3->AN; 
            $cc16= $val3->SEQ; 
            $cc17= $val3->SUBINSCL; 
            $cc18 = $val3->RELINSCL;
            $cc19 = $val3->HTYPE;   
            $strText3="\n".$cc1."|".$cc2."|".$cc3."|".$cc4."|".$cc5."|".$cc6."|".$cc7."|".$cc8."|".$cc9."|".$cc10."|".$cc11."|".$cc12."|".$cc13."|".$cc14."|".$cc15."|".$cc16."|".$cc17."|".$cc18."|".$cc19;
            $ansitxt_pat3 = iconv('UTF-8', 'TIS-620', $strText3);
            fwrite($objFopen_opd3, $ansitxt_pat3);
        }

         // ********* ODX**** 
        $opd_head4 = 'HN|DATEDX|CLINIC|DIAG|DXTYPE|DRDX|PERSON_ID|SEQ';
        fwrite($objFopen_opd4, $opd_head4);
        $odx_data = DB::connection('mysql7')->select('   
            SELECT HN,DATEDX,CLINIC,DIAG,DXTYPE,DRDX,PERSON_ID,SEQ
            FROM d_odx 
        ');
        foreach ($odx_data as $key => $val4) {
            $d1 = $val4->HN; 
            $d2 = $val4->DATEDX;
            $d3 = $val4->CLINIC; 
            $d4 = $val4->DIAG; 
            $d5 = $val4->DXTYPE; 
            $d6 = $val4->DRDX; 
            $d7 = $val4->PERSON_ID;  
            $d8 = $val4->SEQ; 
             
            $strText4="\n".$d1."|".$d2."|".$d3."|".$d4."|".$d5."|".$d6."|".$d7."|".$d8;
            $ansitxt_pat4 = iconv('UTF-8', 'TIS-620', $strText4);
            fwrite($objFopen_opd4, $ansitxt_pat4);
        }

        // ********* OPD**** 
        $opd_head5 = 'HN|CLINIC|DATEOPD|TIMEOPD|SEQ|UUC';
        fwrite($objFopen_opd5, $opd_head5);
        $opd_data = DB::connection('mysql7')->select('   
            SELECT HN,CLINIC,DATEOPD,TIMEOPD,SEQ,UUC 
            FROM d_opd
        ');
        foreach ($opd_data as $key => $val5) {
            $e1 = $val5->HN; 
            $e2 = $val5->CLINIC;
            $e3 = $val5->DATEOPD; 
            $e4 = $val5->TIMEOPD; 
            $e5 = $val5->SEQ; 
            $e6 = $val5->UUC;  
             
            $strText5="\n".$e1."|".$e2."|".$e3."|".$e4."|".$e5."|".$e6;
            $ansitxt_pat5 = iconv('UTF-8', 'TIS-620', $strText5);
            fwrite($objFopen_opd5, $ansitxt_pat5);
        }

             // ********* PAT**** 
        $opd_head6 = 'HCODE|HN|CHANGWAT|AMPHUR|DOB|SEX|MARRIAGE|OCCUPA|NATION|PERSON_ID|NAMEPAT|TITLE|FNAME|LNAME|IDTYPE';
        fwrite($objFopen_opd6, $opd_head6);
        $pat_data = DB::connection('mysql7')->select('   
            SELECT HCODE,HN,CHANGWAT,AMPHUR,DOB,SEX,MARRIAGE,OCCUPA,NATION,PERSON_ID,NAMEPAT,TITLE,FNAME,LNAME,IDTYPE 
            FROM d_pat
        ');
        foreach ($pat_data as $key => $val6) {
            $f1 = $val6->HCODE; 
            $f2 = $val6->HN;
            $f3 = $val6->CHANGWAT; 
            $f4 = $val6->AMPHUR; 
            $f5 = $val6->DOB; 
            $f6 = $val6->SEX; 
            $f7 = $val6->MARRIAGE;
            $f8 = $val6->OCCUPA;
            $f9 = $val6->NATION;
            $f10 = $val6->PERSON_ID;
            $f11 = $val6->NAMEPAT;
            $f12 = $val6->TITLE;
            $f13 = $val6->FNAME;
            $f14 = $val6->LNAME;
            $f15 = $val6->IDTYPE; 
             
            $strText6="\n".$f1."|".$f2."|".$f3."|".$f4."|".$f5."|".$f6."|".$f7."|".$f8."|".$f9."|".$f10."|".$f11."|".$f12."|".$f13."|".$f14."|".$f15;
            $ansitxt_pat6 = iconv('UTF-8', 'TIS-620', $strText6);
            fwrite($objFopen_opd6, $ansitxt_pat6);
        }

         

        $ins_ = DB::connection('mysql7')->select('   
            SELECT * FROM d_ins   
        ');
        $pat_ = DB::connection('mysql7')->select('   
            SELECT * FROM d_pat   
        ');
        $opd_ = DB::connection('mysql7')->select('   
            SELECT * FROM d_opd   
        ');
        $odx_ = DB::connection('mysql7')->select('   
            SELECT * FROM d_odx   
        ');
        $adp_ = DB::connection('mysql7')->select('   
            SELECT * FROM d_adp   
        ');
        $dru_ = DB::connection('mysql7')->select('   
            SELECT * FROM d_dru   
        ');

        return view('claim.anc_Pregnancy_test',[
            'start'            => $datestart,
            'end'              => $dateend,
            'ins_'              => $ins_,
            'pat_'              => $pat_,
            'opd_'              => $opd_,
            'odx_'              => $odx_,
            'adp_'              => $adp_,
            'dru_'              => $dru_
        ]);
    }

    public function ktb_spawn(Request $request)
    { 
        $datestart = $request->startdate;
        $dateend = $request->enddate;

        return view('claim.ktb_spawn',[
            'start'            => $datestart,
            'end'              => $dateend,
        ]);
    }
    public function ktb_ferrofolic(Request $request)
    { 
        $datestart = $request->startdate;
        $dateend = $request->enddate;
        $ins_ = DB::connection('mysql7')->select('   
            SELECT * FROM d_ins   
        ');
        $pat_ = DB::connection('mysql7')->select('   
            SELECT * FROM d_pat   
        ');
        $opd_ = DB::connection('mysql7')->select('   
            SELECT * FROM d_opd   
        ');
        $odx_ = DB::connection('mysql7')->select('   
            SELECT * FROM d_odx   
        ');
        $adp_ = DB::connection('mysql7')->select('   
            SELECT * FROM d_adp   
        ');
        $dru_ = DB::connection('mysql7')->select('   
            SELECT * FROM d_dru   
        ');

        return view('claim.ktb_ferrofolic',[
            'start'            => $datestart,
            'end'              => $dateend,
            'ins_'              => $ins_,
            'pat_'              => $pat_,
            'opd_'              => $opd_,
            'odx_'              => $odx_,
            'adp_'              => $adp_,
            'dru_'              => $dru_
        ]);
    }

    public function ktb_ferrofolic_search(Request $request)
    { 
        $datestart = $request->startdate;
        $dateend = $request->enddate;
      
        $data_opd = DB::connection('mysql3')->select(' 
                SELECT o.vn,o.hn,o.an,pt.cid,ptname(o.hn,1) ptname
                ,ce2be(o.vstdate) vstdate,date_format(o.vsttime,"%T") vsttime 
                ,ptt.pttype inscl,ptt.name pttypename 
                ,v.pdx,group_concat(d.icode," ",d.name) drug
                ,sum(oo.sum_price) money_hosxp,ptt.paidst
                ,v.discount_money,v.rcpt_money
                ,v.income-v.discount_money-v.rcpt_money debit
                ,v.rcpno_list rcpno
                ,s.amountpay  
                from ovst o
                join vn_stat v on v.vn=o.vn
                join patient pt on pt.hn=o.hn
                join opitemrece oo on oo.vn=o.vn
                join drugitems d on d.icode=oo.icode  
                left join pttype ptt on ptt.pttype=o.pttype
                left join hshooterdb.m_stm s on s.vn = v.vn 
                where o.vstdate BETWEEN "'.$datestart.'" AND "'.$dateend.'" 
                and (o.an=" " or o.an is null)
                and v.age_y between 13 and 45 and pt.nationality="99" and pt.sex=2 
                and  d.did in ("202030120137819920381422","100488000004203120381169","100489000004320121881267","100489000004320121881267","100488000004203121781674","100488000004203120381442","100488000004203120381013","100488000004203121781144",
                "100488000004203120381053","100488000004203120381144","100488000004203120381271","100488000004203120381341","100488000004203120381626","100488000004203121881626","100488000004203121781144","100488000004203121881442",
                "100488000004203121881553","100489000004192121881506","100489000004320120381122","100489000004320120381506","100489000004203120381555","100489000004203120381084","100489000004203120381144","100489000004203120381619",
                "100489000004203120381477","100489000004203120381544","100489000004203120381546")
                group by o.vn;
 
        ');
       
        Tempexport::truncate();
        foreach ($data_opd as $key => $value) {           
            $add= new Tempexport();
            $add->vn = $value->vn ;
            $add->hn = $value->hn; 
            $add->an = $value->an; 
            $add->cid = $value->cid; 
            $add->ACTIVE = 'N';
            $add->save();
        }

        $data_ktb_I02 = DB::connection('mysql3')->select('  
          
                SELECT o.vn,o.hn,o.an,pt.cid,ptname(o.hn,1) FULLNAME
                ,ce2be(o.vstdate) vstdate,date_format(o.vsttime,"%T") vsttime 
                ,ptt.pttype inscl,ptt.name pttypename 
                ,v.pdx,group_concat(d.icode," ",d.name) drug
                ,sum(oo.sum_price) money_hosxp,ptt.paidst
                ,v.discount_money,v.rcpt_money
                ,v.income-v.discount_money-v.rcpt_money debit
                ,v.uc_money AS ClaimAmt
                ,v.rcpno_list rcpno
                ,s.amountpay  
                from ovst o
                join vn_stat v on v.vn=o.vn
                join patient pt on pt.hn=o.hn
                join opitemrece oo on oo.vn=o.vn
                join drugitems d on d.icode=oo.icode  
                left join pttype ptt on ptt.pttype=o.pttype
                left join hshooterdb.m_stm s on s.vn = v.vn 
                where o.vstdate BETWEEN "'.$datestart.'" AND "'.$dateend.'" 
                and (o.an=" " or o.an is null)
                and v.age_y between 13 and 45 and pt.nationality="99" and pt.sex=2 
                and  d.did in ("202030120137819920381422","100488000004203120381169","100489000004320121881267","100489000004320121881267","100488000004203121781674","100488000004203120381442","100488000004203120381013","100488000004203121781144",
                "100488000004203120381053","100488000004203120381144","100488000004203120381271","100488000004203120381341","100488000004203120381626","100488000004203121881626","100488000004203121781144","100488000004203121881442",
                "100488000004203121881553","100489000004192121881506","100489000004320120381122","100489000004320120381506","100489000004203120381555","100489000004203120381084","100489000004203120381144","100489000004203120381619",
                "100489000004203120381477","100489000004203120381544","100489000004203120381546")
                group by o.vn;

              
        '); 
       
        // D_ktb_b17::truncate();
        foreach ($data_ktb_I02 as $key => $item2) { 
            // $checkvn = D_ktb_b17::where('vn','=',$item2->vn)->count();
            $datenow = date('Y-m-d H:m:s');
            // if ($checkvn > 0) { 
            // } else { 
            //     D_ktb_b17::insert([                        
            //         'vn'         => $item2->vn,
            //         'hn'         => $item2->hn,
            //         'an'         => $item2->an,
            //         'cid'        => $item2->cid,
            //         'vstdate'    => $item2->vstdate,
            //         'created_at' => $datenow, 
            //     ]);
            // }          

            $check_vn = Stm::where('VN','=',$item2->vn)->count(); 
            
            if ($check_vn > 0) { 
            } else {
                Stm::insert([                        
                        'AN'                => $item2->an, 
                        'VN'                => $item2->vn,
                        'HN'                => $item2->hn,
                        'PID'               => $item2->cid,
                        'VSTDATE'           => $item2->vstdate,
                        'FULLNAME'          => $item2->FULLNAME,  
                        'MAININSCL'         => "",
                        'created_at'        => $datenow, 
                        'ClaimAmt'          =>$item2->ClaimAmt
                    ]);
            }
            
        }

        D_ins::truncate();
        $inst_ = DB::connection('mysql3')->select('   
                SELECT v.hn HN
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
                ,v.vstdate

                from vn_stat v
                LEFT JOIN opitemrece o on o.vn = v.vn
                LEFT JOIN pttype p on p.pttype = v.pttype
                LEFT JOIN ipt i on i.vn = v.vn 
                LEFT JOIN pttype pp on pp.pttype = i.pttype
                left join ipt_pttype ap on ap.an = i.an
                left join visit_pttype vp on vp.vn = v.vn
                LEFT JOIN rcpt_debt r on r.vn = v.vn
                left join patient px on px.hn = v.hn
                left join claim.tempexport x on x.vn = v.vn
                where x.ACTIVE="N" 
                GROUP BY v.hn,v.vstdate; 
        ');
        
        foreach ($inst_ as $key => $ins) {
            D_ins::insert([                        
                'HN'                => $ins->HN, 
                'INSCL'             => $ins->INSCL,
                'SUBTYPE'            => $ins->SUBTYPE,
                'CID'               => $ins->CID,
                'DATEIN'            => $ins->DATEIN,
                'DATEEXP'           => $ins->DATEEXP,  
                'HOSPMAIN'          => $ins->HOSPMAIN,
                'HOSPSUB'           => $ins->HOSPSUB, 
                'GOVCODE'           =>$ins->GOVCODE,
                'GOVNAME'           =>$ins->GOVNAME,
                'PERMITNO'          =>$ins->PERMITNO,
                'DOCNO'             =>$ins->DOCNO,
                'OWNRPID'           =>$ins->OWNRPID,
                'OWNRNAME'          =>$ins->OWNRNAME,
                'AN'                =>$ins->AN,
                'SEQ'               =>$ins->SEQ,
                'SUBINSCL'          =>$ins->SUBINSCL,
                'RELINSCL'          =>$ins->RELINSCL,
                'HTYPE'             =>$ins->HTYPE
            ]);
        }

        D_pat::truncate();
        $patt_ = DB::connection('mysql3')->select('   
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
                LEFT JOIN opitemrece o on o.vn = v.vn
                LEFT JOIN pttype p on p.pttype = v.pttype
                LEFT JOIN ipt i on i.vn = v.vn  
                left join patient pt on pt.hn = v.hn
                left join claim.tempexport x on x.vn = v.vn
                where x.ACTIVE="N" 
                GROUP BY v.hn,v.vstdate; 
        ');
        
        foreach ($patt_ as $key => $pat) {
            D_pat::insert([                        
                'HN'                => $pat->HN, 
                'HCODE'             => $pat->HCODE,
                'CHANGWAT'          => $pat->CHANGWAT,
                'AMPHUR'            => $pat->AMPHUR,
                'DOB'               => $pat->DOB,
                'SEX'               => $pat->SEX,  
                'MARRIAGE'          => $pat->MARRIAGE,
                'OCCUPA'            => $pat->OCCUPA, 
                'NATION'            => $pat->NATION,
                'PERSON_ID'         => $pat->PERSON_ID,
                'NAMEPAT'           => $pat->NAMEPAT,
                'TITLE'             => $pat->TITLE,
                'FNAME'             => $pat->FNAME,
                'LNAME'             => $pat->LNAME,
                'IDTYPE'            => $pat->IDTYPE  
            ]);
        }

        D_opd::truncate();
        $opdt_ = DB::connection('mysql3')->select('   
                SELECT v.hn as HN
                ,v.spclty as CLINIC
                ,DATE_FORMAT(v.vstdate, "%Y%m%d") as DATEOPD
                ,concat(substr(o.vsttime,1,2),substr(o.vsttime,4,2)) as TIMEOPD
                ,v.vn as SEQ 
                ,"1" UUC
                ,v.vstdate 

                from vn_stat v
                LEFT JOIN ovst o on o.vn = v.vn
                LEFT JOIN pttype p on p.pttype = v.pttype
                LEFT JOIN ipt i on i.vn = v.vn 
                LEFT JOIN patient pt on pt.hn = v.hn
                left join claim.tempexport x on x.vn = v.vn
                where x.ACTIVE="N"                
                GROUP BY SEQ; 
        ');
        
        foreach ($opdt_ as $key => $opd) {
            D_opd::insert([                        
                'HN'                => $opd->HN, 
                'CLINIC'            => $opd->CLINIC,
                'DATEOPD'           => $opd->DATEOPD,
                'TIMEOPD'           => $opd->TIMEOPD,
                'SEQ'               => $opd->SEQ,
                'UUC'               => $opd->UUC 
            ]);
        }

        D_odx::truncate();
        $odxt_ = DB::connection('mysql3')->select('   
                SELECT v.hn HN
                ,DATE_FORMAT(v.vstdate,"%Y%m%d") DATEDX
                ,v.spclty CLINIC
                ,o.icd10 DIAG
                ,o.diagtype DXTYPE
                ,if(d.licenseno="","-99999",d.licenseno) DRDX
                ,v.cid PERSON_ID 
                ,v.vn SEQ
                ,v.vstdate 
                ,v.pttype

                from vn_stat v
                LEFT JOIN ovstdiag o on o.vn = v.vn
                LEFT JOIN doctor d on d.`code` = o.doctor
                inner JOIN icd101 i on i.code = o.icd10 
                left join claim.tempexport x on x.vn = v.vn
                where x.ACTIVE="N"  
                GROUP BY SEQ; 
        ');
         
        foreach ($odxt_ as $key => $odx) {
            D_odx::insert([                        
                'HN'                => $odx->HN, 
                'CLINIC'            => $odx->CLINIC,
                'DATEDX'            => $odx->DATEDX,
                'DIAG'              => $odx->DIAG,
                'DXTYPE'            => $odx->DXTYPE,
                'DRDX'              => $odx->DRDX,
                'PERSON_ID'         => $odx->PERSON_ID,
                'SEQ'               => $odx->SEQ 
            ]);
        }

        D_adp::truncate();
        $adpt_ = DB::connection('mysql3')->select('   
            SELECT HN,AN,DATEOPD,TYPE,CODE,sum(QTY) QTY
            ,RATE,SEQ
            ,"" CAGCODE,"" DOSE,"" CA_TYPE,"" SERIALNO,"" TOTCOPAY,"" USE_STATUS,"" TOTAL ,"" QTYDAY
            ,"" TMLTCODE
            ,"" STATUS1
            ,"" BI
            ,"" CLINIC
            ,"" ITEMSRC
            ,"" PROVIDER
            ,"" GLAVIDA
            ,"" GA_WEEK
            ,"" DCIP
            ,"00000000" LMP
            from (SELECT v.hn HN
            ,if(v.an is null,"",v.an) AN
            ,DATE_FORMAT(v.rxdate,"%Y%m%d") DATEOPD
            ,n.nhso_adp_type_id TYPE
            ,n.nhso_adp_code CODE 
            ,sum(v.QTY) QTY
            ,round(v.unitprice,2) RATE
            ,if(v.an is null,v.vn,"") SEQ
            ,"" CAGCODE,"" DOSE,"" CA_TYPE,"" SERIALNO,"" TOTCOPAY,"" USE_STATUS,"" TOTAL ,"" QTYDAY
            ,"" TMLTCODE
            ,"" STATUS1
            ,"" BI
            ,"" CLINIC
            ,"" ITEMSRC
            ,"" PROVIDER
            ,"" GLAVIDA
            ,"" GA_WEEK
            ,"" DCIP
            ,"00000000" LMP
            from opitemrece v
            inner JOIN drugitems n on n.icode = v.icode and n.nhso_adp_code is not null
            left join ipt i on i.an = v.an
            AND i.an is not NULL
            left join claim.tempexport x on x.vn = i.vn
            where x.ACTIVE="N"
            and n.did in ("202030120137819920381422","100488000004203120381169","100489000004320121881267","100489000004320121881267","100488000004203121781674","100488000004203120381442","100488000004203120381013","100488000004203121781144",
            "100488000004203120381053","100488000004203120381144","100488000004203120381271","100488000004203120381341","100488000004203120381626","100488000004203121881626","100488000004203121781144","100488000004203121881442",
            "100488000004203121881553","100489000004192121881506","100489000004320120381122","100489000004320120381506","100489000004203120381555","100489000004203120381084","100489000004203120381144","100489000004203120381619",
            "100489000004203120381477","100489000004203120381544","100489000004203120381546")
            GROUP BY i.vn,n.nhso_adp_code,rate) a 
            GROUP BY an,CODE,rate
            UNION
            SELECT HN,AN,DATEOPD,TYPE,CODE,sum(QTY) QTY,RATE,SEQ,"" "" CAGCODE,"" DOSE,"" CA_TYPE,"" SERIALNO,"0" TOTCOPAY,"" USE_STATUS,"0" TOTAL ,"" QTYDAY
            ,""TMLTCODE
            ,"" STATUS1
            ,"" BI
            ,"" CLINIC
            ,"" ITEMSRC
            ,"" PROVIDER
            ,"" GLAVIDA
            ,"" GA_WEEK
            ,"" DCIP
            ,"00000000" LMP
            from
            (SELECT v.hn HN
            ,if(v.an is null,"",v.an) AN
            ,DATE_FORMAT(v.vstdate,"%Y%m%d") DATEOPD
            ,n.nhso_adp_type_id TYPE
            ,n.nhso_adp_code CODE 
            ,sum(v.QTY) QTY
            ,round(v.unitprice,2) RATE
            ,if(v.an is null,v.vn,"") SEQ
            ,"" CAGCODE,"" DOSE,"" CA_TYPE,"" SERIALNO,"0" TOTCOPAY,"" USE_STATUS,"0" TOTAL ,"" QTYDAY
            ,"" TMLTCODE
            ,"" STATUS1
            ,"" BI
            ,"" CLINIC
            ,"" ITEMSRC
            ,"" PROVIDER
            ,"" GLAVIDA
            ,"" GA_WEEK
            ,"" DCIP
            ,"00000000" LMP
            from opitemrece v
            inner JOIN drugitems n on n.icode = v.icode and n.nhso_adp_code is not null
            left join ipt i on i.an = v.an
            left join claim.tempexport x on x.vn = v.vn
            where x.ACTIVE="N"
            and n.did in ("202030120137819920381422","100488000004203120381169","100489000004320121881267","100489000004320121881267","100488000004203121781674","100488000004203120381442","100488000004203120381013","100488000004203121781144",
            "100488000004203120381053","100488000004203120381144","100488000004203120381271","100488000004203120381341","100488000004203120381626","100488000004203121881626","100488000004203121781144","100488000004203121881442",
            "100488000004203121881553","100489000004192121881506","100489000004320120381122","100489000004320120381506","100489000004203120381555","100489000004203120381084","100489000004203120381144","100489000004203120381619",
            "100489000004203120381477","100489000004203120381544","100489000004203120381546")
            AND i.an is NULL
            GROUP BY v.vn,n.nhso_adp_code,rate) b 
            GROUP BY seq,CODE,rate ;              
        ');
         
        foreach ($adpt_ as $key => $adp) {
            D_adp::insert([                        
                'HN'                => $adp->HN, 
                'AN'                => $adp->AN,
                'DATEOPD'           => $adp->DATEOPD,
                'TYPE'              => $adp->TYPE,
                'CODE'              => $adp->CODE,
                'QTY'               => $adp->QTY,
                'RATE'              => $adp->RATE,
                'SEQ'               => $adp->SEQ ,
                'CAGCODE'           => $adp->CAGCODE ,
                'DOSE'              => $adp->DOSE, 
                'CA_TYPE'           => $adp->CA_TYPE ,
                'SERIALNO'          => $adp->SERIALNO ,
                'TOTCOPAY'          => $adp->TOTCOPAY ,
                'USE_STATUS'        => $adp->USE_STATUS ,
                'TOTAL'             => $adp->TOTAL, 
                'QTYDAY'            => $adp->QTYDAY,
                'TMLTCODE'          => $adp->TMLTCODE,
                'STATUS1'           => $adp->STATUS1,
                'BI'                => $adp->BI,
                'CLINIC'            => $adp->CLINIC,
                'ITEMSRC'           => $adp->ITEMSRC,
                'PROVIDER'          => $adp->PROVIDER,
                'GLAVIDA'           => $adp->GLAVIDA,
                'GA_WEEK'           => $adp->GA_WEEK,
                'DCIP'              => $adp->DCIP,
                'LMP'               => $adp->LMP
            ]);
        }

        D_dru::truncate();
        $drut_ = DB::connection('mysql3')->select('   
            SELECT vv.hcode HCODE
            ,v.hn HN
            ,v.an AN
            ,vv.spclty CLINIC
            ,vv.cid PERSON_ID
            ,DATE_FORMAT(v.vstdate,"%Y%m%d") DATE_SERV
            ,d.icode DID
            ,concat(d.`name`," ",d.strength," ",d.units) DIDNAME
            ,v.qty AMOUNT
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
            , " " TOTAL,"" SIGCODE,""  SIGTEXT
            from opitemrece v
            LEFT JOIN drugitems d on d.icode = v.icode
            LEFT JOIN vn_stat vv on vv.vn = v.vn
            LEFT JOIN ovst_presc_ned oo on oo.vn = v.vn and oo.icode=v.icode
            left join claim.tempexport x on x.vn = v.vn
            where x.ACTIVE="N"
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
            ," " TOTAL,"" SIGCODE,""  SIGTEXT
            from opitemrece v
            LEFT JOIN drugitems d on d.icode = v.icode
            LEFT JOIN patient pt  on v.hn = pt.hn
            inner JOIN ipt v1 on v1.an = v.an
            LEFT JOIN ovst_presc_ned oo on oo.vn = v.vn and oo.icode=v.icode 
            left join claim.tempexport x on x.vn = v1.vn
            where x.ACTIVE="N"
           
            and d.did in ("202030120137819920381422","100488000004203120381169","100489000004320121881267","100489000004320121881267","100488000004203121781674","100488000004203120381442","100488000004203120381013","100488000004203121781144",
            "100488000004203120381053","100488000004203120381144","100488000004203120381271","100488000004203120381341","100488000004203120381626","100488000004203121881626","100488000004203121781144","100488000004203121881442",
            "100488000004203121881553","100489000004192121881506","100489000004320120381122","100489000004320120381506","100489000004203120381555","100489000004203120381084","100489000004203120381144","100489000004203120381619",
            "100489000004203120381477","100489000004203120381544","100489000004203120381546") 
            AND v.qty<>"0"
            GROUP BY v.an,d.icode,USE_STATUS; 
        ');
        // and d.did is not null
        // group by o.vn;
        foreach ($drut_ as $key => $dru) {
            D_dru::insert([                        
                'HN'           => $dru->HN, 
                'HCODE'         => $dru->HCODE,
                'AN'            => $dru->AN,
                'CLINIC'        => $dru->CLINIC,
                'PERSON_ID'     => $dru->PERSON_ID,
                'DATE_SERV'     => $dru->DATE_SERV,
                'DID'           => $dru->DID,
                'DIDNAME'       => $dru->DIDNAME,
                'AMOUNT'        => $dru->AMOUNT,
                'DRUGPRIC'      => $dru->DRUGPRIC,
                'DRUGCOST'      => $dru->DRUGCOST,
                'DIDSTD'        => $dru->DIDSTD,
                'UNIT'          => $dru->UNIT,
                'UNIT_PACK'     => $dru->UNIT_PACK,
                'SEQ'           => $dru->SEQ,
                'DRUGREMARK'    => $dru->DRUGREMARK,
                'PA_NO'         => $dru->PA_NO,
                'TOTCOPAY'      => $dru->TOTCOPAY,
                'USE_STATUS'    => $dru->USE_STATUS,
                // 'STATUS1'       => $dru->STATUS1,
                'TOTAL'         => $dru->TOTAL,
                'SIGCODE'       => $dru->SIGCODE,
                'SIGTEXT'       => $dru->SIGTEXT 


            ]);
        }

        $ins_ = DB::connection('mysql7')->select('   
            SELECT * FROM d_ins   
        ');
        $pat_ = DB::connection('mysql7')->select('   
            SELECT * FROM d_pat   
        ');
        $opd_ = DB::connection('mysql7')->select('   
            SELECT * FROM d_opd   
        ');
        $odx_ = DB::connection('mysql7')->select('   
            SELECT * FROM d_odx   
        ');
        $adp_ = DB::connection('mysql7')->select('   
            SELECT * FROM d_adp   
        ');
        $dru_ = DB::connection('mysql7')->select('   
            SELECT * FROM d_dru   
        ');
 
       
        return view('claim.ktb_ferrofolic',[
            'start'            => $datestart,
            'end'              => $dateend,
            'ins_'              => $ins_,
            'pat_'              => $pat_,
            'opd_'              => $opd_,
            'odx_'              => $odx_,
            'adp_'              => $adp_,
            'dru_'              => $dru_
        ]);
    }

    public function ktb_kids_glasses(Request $request)
    { 
        $datestart = $request->startdate;
        $dateend = $request->enddate;
        $ins_ = DB::connection('mysql7')->select('   
            SELECT * FROM d_ins   
        ');
        $pat_ = DB::connection('mysql7')->select('   
            SELECT * FROM d_pat   
        ');
        $opd_ = DB::connection('mysql7')->select('   
            SELECT * FROM d_opd   
        ');
        $odx_ = DB::connection('mysql7')->select('   
            SELECT * FROM d_odx   
        ');
        $adp_ = DB::connection('mysql7')->select('   
            SELECT * FROM d_adp   
        ');
        $dru_ = DB::connection('mysql7')->select('   
            SELECT * FROM d_dru   
        ');

        return view('claim.ktb_kids_glasses',[
            'start'            => $datestart,
            'end'              => $dateend,
            'ins_'              => $ins_,
            'pat_'              => $pat_,
            'opd_'              => $opd_,
            'odx_'              => $odx_,
            'adp_'              => $adp_,
            'dru_'              => $dru_
        ]);
    }
    public function ktb_kids_glasses_search(Request $request)
    { 
        $datestart = $request->startdate;
        $dateend = $request->enddate;
      
        $data_opd = DB::connection('mysql3')->select(' 
             
            SELECT o.vn,pt.cid,o.hn,o.an,concat(pt.pname,pt.fname,"  ",pt.lname) as Fullname
                ,o.vstdate,settime(o.vsttime) vsttime
                ,ptt.pcode,o.pttype,ptt.name pttypename,v.pdx
                ,group_concat(distinct concat(d.nhso_adp_code,":",d.name,"#",numberformat(sum_price,2))) list
                ,v.income hosxp_money,v.discount_money,v.rcpt_money
                ,sum(if(d.nhso_adp_type_id=2 and d.nhso_adp_code regexp "2206|2207",sum_price,0)) instrument  
                ,v.rcpno_list billno
                ,doctorname(o.doctor) doctorname                                
                from ovst o 
                left join patient pt on pt.hn=o.hn
                left join vn_stat v on v.vn=o.vn
                left join pttype ptt on ptt.pttype=o.pttype
                left join opitemrece oo on oo.vn=o.vn
                left join nondrugitems d on d.icode=oo.icode
                left join hshooterdb.m_stm s on s.an = o.an
                where o.vstdate BETWEEN "'.$datestart.'" AND "'.$dateend.'" 
                and pt.nationality="99" and v.age_y between 3 and 12
                and (o.an=" " or o.an is null)
                and billcode IN("2206","2207") 
                group by o.vn
                order by vn;
 
        ');
       
        Tempexport::truncate();
        foreach ($data_opd as $key => $value) {           
            $add= new Tempexport();
            $add->vn = $value->vn ;
            $add->hn = $value->hn; 
            $add->an = $value->an; 
            $add->cid = $value->cid; 
            $add->ACTIVE = 'N';
            $add->save();
        }

        $data_ktb_G01 = DB::connection('mysql3')->select(' 
           SELECT o.vn,pt.cid,o.hn,o.an,concat(pt.pname,pt.fname," ",pt.lname) as FULLNAME
                ,o.vstdate,settime(o.vsttime) vsttime
                ,ptt.pcode,o.pttype,ptt.name pttypename,v.pdx
                ,group_concat(distinct concat(d.nhso_adp_code,":",d.name,"#",numberformat(sum_price,2))) list
                ,v.income hosxp_money,v.discount_money,v.rcpt_money,v.uc_money AS ClaimAmt
                ,sum(if(d.nhso_adp_type_id=2 and d.nhso_adp_code regexp "2206|2207",sum_price,0)) instrument  
                ,v.rcpno_list billno
                ,doctorname(o.doctor) doctorname                                
                from ovst o 
                left join patient pt on pt.hn=o.hn
                left join vn_stat v on v.vn=o.vn
                left join pttype ptt on ptt.pttype=o.pttype
                left join opitemrece oo on oo.vn=o.vn
                left join nondrugitems d on d.icode=oo.icode
                left join hshooterdb.m_stm s on s.an = o.an
                where o.vstdate BETWEEN "'.$datestart.'" AND "'.$dateend.'" 
                and pt.nationality="99" 
                and v.age_y between 3 and 12
                and (o.an=" " or o.an is null)
                and d.billcode IN("2206","2207") 
                group by o.vn
                order by vn; 
          
                 
        '); 
       
        // D_ktb_b17::truncate();
        foreach ($data_ktb_G01 as $key => $item2) { 
            // $checkvn = D_ktb_b17::where('vn','=',$item2->vn)->count();
            $datenow = date('Y-m-d H:m:s');
            // if ($checkvn > 0) { 
            // } else { 
            //     D_ktb_b17::insert([                        
            //         'vn'         => $item2->vn,
            //         'hn'         => $item2->hn,
            //         'an'         => $item2->an,
            //         'cid'        => $item2->cid,
            //         'vstdate'    => $item2->vstdate,
            //         'created_at' => $datenow, 
            //     ]);
            // }          

            $check_vn = Stm::where('VN','=',$item2->vn)->count(); 
            
            if ($check_vn > 0) { 
            } else {
                Stm::insert([                        
                        'AN'                => $item2->an, 
                        'VN'                => $item2->vn,
                        'HN'                => $item2->hn,
                        'PID'               => $item2->cid,
                        'VSTDATE'           => $item2->vstdate,
                        'FULLNAME'          => $item2->FULLNAME,  
                        'MAININSCL'         => "",
                        'created_at'        => $datenow, 
                        'ClaimAmt'          =>$item2->ClaimAmt
                    ]);
            }
            
        }

        D_ins::truncate();
        $inst_ = DB::connection('mysql3')->select('   
                SELECT v.hn HN
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
                ,v.vstdate

                from vn_stat v
                LEFT JOIN opitemrece o on o.vn = v.vn
                LEFT JOIN pttype p on p.pttype = v.pttype
                LEFT JOIN ipt i on i.vn = v.vn 
                LEFT JOIN pttype pp on pp.pttype = i.pttype
                left join ipt_pttype ap on ap.an = i.an
                left join visit_pttype vp on vp.vn = v.vn
                LEFT JOIN rcpt_debt r on r.vn = v.vn
                left join patient px on px.hn = v.hn
                left join claim.tempexport x on x.vn = v.vn
                where x.ACTIVE="N" 
                GROUP BY v.hn,v.vstdate; 
        ');
        
        foreach ($inst_ as $key => $ins) {
            D_ins::insert([                        
                'HN'                => $ins->HN, 
                'INSCL'             => $ins->INSCL,
                'SUBTYPE'            => $ins->SUBTYPE,
                'CID'               => $ins->CID,
                'DATEIN'            => $ins->DATEIN,
                'DATEEXP'           => $ins->DATEEXP,  
                'HOSPMAIN'          => $ins->HOSPMAIN,
                'HOSPSUB'           => $ins->HOSPSUB, 
                'GOVCODE'           =>$ins->GOVCODE,
                'GOVNAME'           =>$ins->GOVNAME,
                'PERMITNO'          =>$ins->PERMITNO,
                'DOCNO'             =>$ins->DOCNO,
                'OWNRPID'           =>$ins->OWNRPID,
                'OWNRNAME'          =>$ins->OWNRNAME,
                'AN'                =>$ins->AN,
                'SEQ'               =>$ins->SEQ,
                'SUBINSCL'          =>$ins->SUBINSCL,
                'RELINSCL'          =>$ins->RELINSCL,
                'HTYPE'             =>$ins->HTYPE
            ]);
        }

        D_pat::truncate();
        $patt_ = DB::connection('mysql3')->select('   
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
                LEFT JOIN opitemrece o on o.vn = v.vn
                LEFT JOIN pttype p on p.pttype = v.pttype
                LEFT JOIN ipt i on i.vn = v.vn  
                left join patient pt on pt.hn = v.hn
                left join claim.tempexport x on x.vn = v.vn
                where x.ACTIVE="N" 
                GROUP BY v.hn,v.vstdate; 
        ');
        
        foreach ($patt_ as $key => $pat) {
            D_pat::insert([                        
                'HN'                => $pat->HN, 
                'HCODE'             => $pat->HCODE,
                'CHANGWAT'          => $pat->CHANGWAT,
                'AMPHUR'            => $pat->AMPHUR,
                'DOB'               => $pat->DOB,
                'SEX'               => $pat->SEX,  
                'MARRIAGE'          => $pat->MARRIAGE,
                'OCCUPA'            => $pat->OCCUPA, 
                'NATION'            => $pat->NATION,
                'PERSON_ID'         => $pat->PERSON_ID,
                'NAMEPAT'           => $pat->NAMEPAT,
                'TITLE'             => $pat->TITLE,
                'FNAME'             => $pat->FNAME,
                'LNAME'             => $pat->LNAME,
                'IDTYPE'            => $pat->IDTYPE  
            ]);
        }

        D_opd::truncate();
        $opdt_ = DB::connection('mysql3')->select('   
                SELECT v.hn as HN
                ,v.spclty as CLINIC
                ,DATE_FORMAT(v.vstdate, "%Y%m%d") as DATEOPD
                ,concat(substr(o.vsttime,1,2),substr(o.vsttime,4,2)) as TIMEOPD
                ,v.vn as SEQ 
                ,"1" UUC
                ,v.vstdate 

                from vn_stat v
                LEFT JOIN ovst o on o.vn = v.vn
                LEFT JOIN pttype p on p.pttype = v.pttype
                LEFT JOIN ipt i on i.vn = v.vn 
                LEFT JOIN patient pt on pt.hn = v.hn
                left join claim.tempexport x on x.vn = v.vn
                where x.ACTIVE="N"                
                GROUP BY SEQ; 
        ');
        
        foreach ($opdt_ as $key => $opd) {
            D_opd::insert([                        
                'HN'                => $opd->HN, 
                'CLINIC'            => $opd->CLINIC,
                'DATEOPD'           => $opd->DATEOPD,
                'TIMEOPD'           => $opd->TIMEOPD,
                'SEQ'               => $opd->SEQ,
                'UUC'               => $opd->UUC 
            ]);
        }

        D_odx::truncate();
        $odxt_ = DB::connection('mysql3')->select('   
                SELECT v.hn HN
                ,DATE_FORMAT(v.vstdate,"%Y%m%d") DATEDX
                ,v.spclty CLINIC
                ,o.icd10 DIAG
                ,o.diagtype DXTYPE
                ,if(d.licenseno="","-99999",d.licenseno) DRDX
                ,v.cid PERSON_ID 
                ,v.vn SEQ
                ,v.vstdate 
                ,v.pttype

                from vn_stat v
                LEFT JOIN ovstdiag o on o.vn = v.vn
                LEFT JOIN doctor d on d.`code` = o.doctor
                inner JOIN icd101 i on i.code = o.icd10 
                left join claim.tempexport x on x.vn = v.vn
                where x.ACTIVE="N"  
                GROUP BY SEQ; 
        ');
         
        foreach ($odxt_ as $key => $odx) {
            D_odx::insert([                        
                'HN'                => $odx->HN, 
                'CLINIC'            => $odx->CLINIC,
                'DATEDX'            => $odx->DATEDX,
                'DIAG'              => $odx->DIAG,
                'DXTYPE'            => $odx->DXTYPE,
                'DRDX'              => $odx->DRDX,
                'PERSON_ID'         => $odx->PERSON_ID,
                'SEQ'               => $odx->SEQ 
            ]);
        }

        D_adp::truncate();
        $adpt_ = DB::connection('mysql3')->select('   
            SELECT HN,AN,DATEOPD,TYPE,CODE,sum(QTY) QTY
            ,RATE,SEQ
            ,"" CAGCODE,"" DOSE,"" CA_TYPE,"" SERIALNO,"" TOTCOPAY,"" USE_STATUS,"" TOTAL ,"" QTYDAY
            ,"" TMLTCODE
            ,"" STATUS1
            ,"" BI
            ,"" CLINIC
            ,"" ITEMSRC
            ,"" PROVIDER
            ,"" GLAVIDA
            ,"" GA_WEEK
            ,"" DCIP
            ,"00000000" LMP
            from (SELECT v.hn HN
            ,if(v.an is null,"",v.an) AN
            ,DATE_FORMAT(v.rxdate,"%Y%m%d") DATEOPD
            ,n.nhso_adp_type_id TYPE
            ,n.nhso_adp_code CODE 
            ,sum(v.QTY) QTY
            ,round(v.unitprice,2) RATE
            ,if(v.an is null,v.vn,"") SEQ
            ,"" CAGCODE,"" DOSE,"" CA_TYPE,"" SERIALNO,"" TOTCOPAY,"" USE_STATUS,"" TOTAL ,"" QTYDAY
            ,"" TMLTCODE
            ,"" STATUS1
            ,"" BI
            ,"" CLINIC
            ,"" ITEMSRC
            ,"" PROVIDER
            ,"" GLAVIDA
            ,"" GA_WEEK
            ,"" DCIP
            ,"00000000" LMP
            from opitemrece v
            inner JOIN nondrugitems n on n.icode = v.icode and n.nhso_adp_code is not null
            left join ipt i on i.an = v.an
            AND i.an is not NULL
            left join claim.tempexport x on x.vn = i.vn
            where x.ACTIVE="N"
            and n.billcode IN("2206","2207") 
            GROUP BY i.vn,n.nhso_adp_code,rate) a 
            GROUP BY an,CODE,rate
            UNION
            SELECT HN,AN,DATEOPD,TYPE,CODE,sum(QTY) QTY,RATE,SEQ,"" "" CAGCODE,"" DOSE,"" CA_TYPE,"" SERIALNO,"0" TOTCOPAY,"" USE_STATUS,"0" TOTAL ,"" QTYDAY
            ,""TMLTCODE
            ,"" STATUS1
            ,"" BI
            ,"" CLINIC
            ,"" ITEMSRC
            ,"" PROVIDER
            ,"" GLAVIDA
            ,"" GA_WEEK
            ,"" DCIP
            ,"00000000" LMP
            from
            (SELECT v.hn HN
            ,if(v.an is null,"",v.an) AN
            ,DATE_FORMAT(v.vstdate,"%Y%m%d") DATEOPD
            ,n.nhso_adp_type_id TYPE
            ,n.nhso_adp_code CODE 
            ,sum(v.QTY) QTY
            ,round(v.unitprice,2) RATE
            ,if(v.an is null,v.vn,"") SEQ
            ,"" CAGCODE,"" DOSE,"" CA_TYPE,"" SERIALNO,"0" TOTCOPAY,"" USE_STATUS,"0" TOTAL ,"" QTYDAY
            ,"" TMLTCODE
            ,"" STATUS1
            ,"" BI
            ,"" CLINIC
            ,"" ITEMSRC
            ,"" PROVIDER
            ,"" GLAVIDA
            ,"" GA_WEEK
            ,"" DCIP
            ,"00000000" LMP
            from opitemrece v
            inner JOIN nondrugitems n on n.icode = v.icode and n.nhso_adp_code is not null
            left join ipt i on i.an = v.an
            left join claim.tempexport x on x.vn = v.vn
            where x.ACTIVE="N"
            and n.billcode IN("2206","2207") 
            AND i.an is NULL
            GROUP BY v.vn,n.nhso_adp_code,rate) b 
            GROUP BY seq,CODE,rate ;              
        ');
         
        foreach ($adpt_ as $key => $adp) {
            D_adp::insert([                        
                'HN'                => $adp->HN, 
                'AN'                => $adp->AN,
                'DATEOPD'           => $adp->DATEOPD,
                'TYPE'              => $adp->TYPE,
                'CODE'              => $adp->CODE,
                'QTY'               => $adp->QTY,
                'RATE'              => $adp->RATE,
                'SEQ'               => $adp->SEQ ,
                'CAGCODE'           => $adp->CAGCODE ,
                'DOSE'              => $adp->DOSE, 
                'CA_TYPE'           => $adp->CA_TYPE ,
                'SERIALNO'          => $adp->SERIALNO ,
                'TOTCOPAY'          => $adp->TOTCOPAY ,
                'USE_STATUS'        => $adp->USE_STATUS ,
                'TOTAL'             => $adp->TOTAL, 
                'QTYDAY'            => $adp->QTYDAY,
                'TMLTCODE'          => $adp->TMLTCODE,
                'STATUS1'           => $adp->STATUS1,
                'BI'                => $adp->BI,
                'CLINIC'            => $adp->CLINIC,
                'ITEMSRC'           => $adp->ITEMSRC,
                'PROVIDER'          => $adp->PROVIDER,
                'GLAVIDA'           => $adp->GLAVIDA,
                'GA_WEEK'           => $adp->GA_WEEK,
                'DCIP'              => $adp->DCIP,
                'LMP'               => $adp->LMP
            ]);
        }

        D_dru::truncate();
        $drut_ = DB::connection('mysql3')->select('   
            SELECT vv.hcode HCODE
            ,v.hn HN
            ,v.an AN
            ,vv.spclty CLINIC
            ,vv.cid PERSON_ID
            ,DATE_FORMAT(v.vstdate,"%Y%m%d") DATE_SERV
            ,d.icode DID
            ,concat(d.`name`," ",d.strength," ",d.units) DIDNAME
            ,v.qty AMOUNT
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
            , " " TOTAL,"" SIGCODE,""  SIGTEXT
            from opitemrece v
            LEFT JOIN drugitems d on d.icode = v.icode
            LEFT JOIN vn_stat vv on vv.vn = v.vn
            LEFT JOIN ovst_presc_ned oo on oo.vn = v.vn and oo.icode=v.icode
            left join claim.tempexport x on x.vn = v.vn
            where x.ACTIVE="N"
            and d.billcode IN("2206","2207") 
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
            ," " TOTAL,"" SIGCODE,""  SIGTEXT
            from opitemrece v
            LEFT JOIN drugitems d on d.icode = v.icode
            LEFT JOIN patient pt  on v.hn = pt.hn
            inner JOIN ipt v1 on v1.an = v.an
            LEFT JOIN ovst_presc_ned oo on oo.vn = v.vn and oo.icode=v.icode 
            left join claim.tempexport x on x.vn = v1.vn
            where x.ACTIVE="N"
            and d.billcode IN("2206","2207") 
            AND v.qty<>"0"
            GROUP BY v.an,d.icode,USE_STATUS; 
        ');
        // and d.did is not null
        // group by o.vn;
        foreach ($drut_ as $key => $dru) {
            D_dru::insert([                        
                'HN'           => $dru->HN, 
                'HCODE'         => $dru->HCODE,
                'AN'            => $dru->AN,
                'CLINIC'        => $dru->CLINIC,
                'PERSON_ID'     => $dru->PERSON_ID,
                'DATE_SERV'     => $dru->DATE_SERV,
                'DID'           => $dru->DID,
                'DIDNAME'       => $dru->DIDNAME,
                'AMOUNT'        => $dru->AMOUNT,
                'DRUGPRIC'      => $dru->DRUGPRIC,
                'DRUGCOST'      => $dru->DRUGCOST,
                'DIDSTD'        => $dru->DIDSTD,
                'UNIT'          => $dru->UNIT,
                'UNIT_PACK'     => $dru->UNIT_PACK,
                'SEQ'           => $dru->SEQ,
                'DRUGREMARK'    => $dru->DRUGREMARK,
                'PA_NO'         => $dru->PA_NO,
                'TOTCOPAY'      => $dru->TOTCOPAY,
                'USE_STATUS'    => $dru->USE_STATUS,
                // 'STATUS1'       => $dru->STATUS1,
                'TOTAL'         => $dru->TOTAL,
                'SIGCODE'       => $dru->SIGCODE,
                'SIGTEXT'       => $dru->SIGTEXT 


            ]);
        }

        $ins_ = DB::connection('mysql7')->select('   
            SELECT * FROM d_ins   
        ');
        $pat_ = DB::connection('mysql7')->select('   
            SELECT * FROM d_pat   
        ');
        $opd_ = DB::connection('mysql7')->select('   
            SELECT * FROM d_opd   
        ');
        $odx_ = DB::connection('mysql7')->select('   
            SELECT * FROM d_odx   
        ');
        $adp_ = DB::connection('mysql7')->select('   
            SELECT * FROM d_adp   
        ');
        $dru_ = DB::connection('mysql7')->select('   
            SELECT * FROM d_dru   
        ');
 
       
        return view('claim.ktb_kids_glasses',[
            'start'            => $datestart,
            'end'              => $dateend,
            'ins_'              => $ins_,
            'pat_'              => $pat_,
            'opd_'              => $opd_,
            'odx_'              => $odx_,
            'adp_'              => $adp_,
            'dru_'              => $dru_
        ]);
    }
    public function treedoc(Request $request)
    { 
        $data['users'] = User::get();
        $budget = DB::table('budget_year')->where('active','=','True')->first();
        $datestart = $budget->date_begin;
        $dateend = $budget->date_end;

        $inputCid = '1234567891234';
       
                // $url = "http://localhost:3000/moi/getCardData";
                $url = "https://3doctor.hss.moph.go.th/main/dashboard";
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "$url",
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_CUSTOMREQUEST => 'GET',
            ));
         
            $response = curl_exec($curl);
            curl_close($curl);
            $content = $response;
            $result = json_decode($content, true);

            dd($result);

            
            @$responseCode = $result['responseCode'];
            // dd($responseCode);
            if (@$responseCode < 0) {
                $smartcard = 'NO_CONNECT';
            } else { 
                $smartcard = 'CONNECT';
            }
            // dd($smartcard);
                @$readerName = $result['readerName'];
                @$responseDesc = $result['responseDesc'];
                @$pid = $result['pid'];
                @$cid = $result['cid'];
                @$chipId = $result['chipId'];
                @$fullNameTH = $result['fullNameTH'];
                @$fullNameEN = $result['fullNameEN'];
                @$birthTH = $result['birthTH'];
                @$birthEN = $result['birthEN'];
                @$sex = $result['sex'];
                @$cardId = $result['cardId'];
                @$sourceData = $result['sourceData'];
                @$issueCode = $result['issueCode'];
                @$dateIssueTH = $result['dateIssueTH'];
                @$dateIssueEN = $result['dateIssueEN'];
                @$dateExpTH = $result['dateExpTH'];
                @$dateExpEN = $result['dateExpEN'];
                @$address = $result['address'];
                @$image = $result['image'];
                @$imageNo = $result['imageNo'];
                @$cardVersion = $result['cardVersion'];
                @$customerPid = $result['customerPid'];
                @$customerCid = $result['customerCid'];
                @$ktbKeyY = $result['ktbKeyY'];
                @$customerKeyY = $result['customerKeyY'];

                $pid         = @$pid;
                $cid         = @$cid;
                $image_      = @$image;
                $chipId      = @$chipId;
                $fullNameTH  = @$fullNameTH;
                $fullNameEN  = @$fullNameEN;
                $birthTH     = @$birthTH;
                $birthEN     = @$birthEN;
                $address     = @$address;
                $dateIssueTH = @$dateIssueTH;
                $dateExpTH   = @$dateExpTH;
                 
                // dd( @$fullNameTH); 
        return view('ktb.ktb_getcard', $data,[ 
            'data_ogclgo'   =>  $data_ogclgo,
            'smartcard'     =>  $smartcard,
            'image_'        => $image_,
            'pid'           => $pid,
            'cid'           => $cid,
            'chipId'        => $chipId,
            'fullNameTH'    => $fullNameTH,
            'fullNameEN'    => $fullNameEN,
            'birthTH'       => $birthTH,
            'birthEN'       => $birthEN,
            'address'       => $address,
            'dateIssueTH'   => $dateIssueTH,
            'dateExpTH'     => $dateExpTH,
        ]);
    }


    
    
}
