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
use App\Models\Acc_imc_hos;
use App\Models\Check_sit_auto;
use App\Models\Acc_imc_an;
use App\Models\Acc_ucep24;
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
use App\Models\D_query;

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


class ImcController extends Controller
 { 
    // ***************** ucep24********************************

    public function imc(Request $request)
    { 
            $startdate = $request->startdate;
            $enddate = $request->enddate;     
            $date = date('Y-m-d');
            $y = date('Y') + 543;
            $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
            $newDate = date('Y-m-d', strtotime($date . ' -5 months')); //ย้อนหลัง 5 เดือน
            $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี
            $yearnew = date('Y');
            $yearold = date('Y')-1;
            $start = (''.$yearold.'-10-01');
            $end = (''.$yearnew.'-09-30'); 

            if ($startdate == '') {                 
                $data = DB::connection('mysql')->select('SELECT * from acc_imc_hos'); 
            } else {
                $iduser = Auth::user()->id;
                
                // Tempexport::where('user_id','=',$iduser)->delete();
              
                D_ins::where('d_anaconda_id','=','1')->delete(); 
                D_opd::where('d_anaconda_id','=','1')->delete();
                D_oop::where('d_anaconda_id','=','1')->delete();
                D_orf::where('d_anaconda_id','=','1')->delete();
                D_odx::where('d_anaconda_id','=','1')->delete();               
                D_idx::where('d_anaconda_id','=','1')->delete();
                D_ipd::where('d_anaconda_id','=','1')->delete();
                D_irf::where('d_anaconda_id','=','1')->delete();
                D_aer::where('d_anaconda_id','=','1')->delete();
                D_iop::where('d_anaconda_id','=','1')->delete();
                D_pat::where('d_anaconda_id','=','1')->delete();
                D_cht::where('d_anaconda_id','=','1')->delete();
                D_cha::where('d_anaconda_id','=','1')->delete();
                // D_adp::where('user_id','=',$iduser)->delete();
                D_dru::where('user_id','=',$iduser)->delete();

                // $data_ = DB::connection('mysql2')->select('  
                //     SELECT a.an from hos.an_stat a
                //     LEFT JOIN hos.iptdiag i on i.an = a.an
                //     where a.dchdate BETWEEN "'.$startdate.'" and "'.$enddate.'"
                //     and i.icd10 between "i60" and "i64"
                //     union
                //     SELECT a.an from hos.an_stat a
                //     LEFT JOIN hos.iptdiag i on i.an = a.an
                //     where a.dchdate BETWEEN "'.$startdate.'" and "'.$enddate.'"
                //     and i.icd10 between "s061" and "s069"
                //     union
                //     SELECT a.an from hos.an_stat a
                //     LEFT JOIN hos.iptdiag i on i.an = a.an
                //     where a.dchdate BETWEEN "'.$startdate.'" and "'.$enddate.'"
                //     and i.icd10 between "s140" and "s141"
                //     union
                //     SELECT a.an from hos.an_stat a
                //     LEFT JOIN hos.iptdiag i on i.an = a.an
                //     where a.dchdate BETWEEN "'.$startdate.'" and "'.$enddate.'"
                //     and i.icd10 between "s240" and "s241"
                //     union
                //     SELECT a.an from hos.an_stat a
                //     LEFT JOIN hos.iptdiag i on i.an = a.an
                //     where a.dchdate BETWEEN "'.$startdate.'" and "'.$enddate.'"
                //     and i.icd10 between "s340" and "s341"
                //     union
                //     SELECT a.an from hos.an_stat a
                //     LEFT JOIN hos.iptdiag i on i.an = a.an
                //     where a.dchdate BETWEEN "'.$startdate.'" and "'.$enddate.'"
                //     and i.icd10 between "s343" and "s343"
                //     union
                //     SELECT a.an from hos.an_stat a
                //     LEFT JOIN hos.iptdiag i on i.an = a.an
                //     where a.dchdate BETWEEN "'.$startdate.'" and "'.$enddate.'"
                //     and i.icd10 between "s720" and "s722";  
                // '); 
                // Acc_imc_an::truncate();
                // foreach ($data_ as $key => $value) {    
                //     Acc_imc_an::insert([ 
                //         'an'                => $value->an, 
                //     ]);
                // }
                $datamchos_ = DB::connection('mysql2')->select('
                    SELECT a.vn,a.hn,a.an,pa.cid,CONCAT(pa.pname,pa.fname," ",pa.lname) as ptname
                        ,GROUP_CONCAT(distinct d.icd10) as icd10
                        ,a.regdate,a.dchdate,a.pttype,a.income,a.uc_money,a.paid_money,a.income-a.paid_money as debit
                        from hos.an_stat a 
                        LEFT JOIN hos.pttype p on p.pttype = a.pttype
                        LEFT JOIN hos.patient pa on pa.hn = a.hn
                        LEFT JOIN hos.iptdiag d on d.an = a.an 
                        LEFT JOIN hos.ipt i1 on i1.an = a.an 
                        LEFT JOIN hos.opitemrece op on op.an = a.an
                        LEFT JOIN hos.nondrugitems n on n.icode = op.icode
                        where a.dchdate BETWEEN "'.$startdate.'" and "'.$enddate.'"
                        and p.hipdata_code ="ucs"
                        AND op.icode = "3010887" 
                        GROUP BY a.an
                        ORDER BY a.hn;
                ');
                Acc_imc_hos::truncate();
                Acc_imc_an::truncate();
                foreach ($datamchos_ as $key => $value2) {
                    Acc_imc_hos::insert([
                        'vn'          => $value2->vn,
                        'hn'          => $value2->hn,
                        'an'          => $value2->an,
                        'cid'         => $value2->cid,
                        'ptname'      => $value2->ptname,
                        'icd10'       => $value2->icd10,
                        'regdate'     => $value2->regdate,
                        'dchdate'     => $value2->dchdate,
                        'pttype'      => $value2->pttype,
                        'income'      => $value2->income,
                        'paid_money'  => $value2->paid_money,
                        'debit'       => $value2->debit,
                    ]);

                    Acc_imc_an::insert([ 
                        'vn'                => $value2->vn, 
                        'an'                => $value2->an
                    ]);
                }

                //D_ins
                $data_ins = DB::connection('mysql2')->select(' 
                        SELECT 
                            "" d_ins_id,v.hn HN
                            ,if(i.an is null,p.hipdata_code,pp.hipdata_code) INSCL
                            ,if(i.an is null,p.pcode,pp.pcode) SUBTYPE,v.cid CID
                            ,DATE_FORMAT(if(i.an is null,v.pttype_begin,ap.begin_date),"%Y%m%d") DATEIN
                            ,DATE_FORMAT(if(i.an is null,v.pttype_expire,ap.expire_date),"%Y%m%d") DATEEXP
                            ,if(i.an is null,v.hospmain,ap.hospmain) HOSPMAIN
                            ,if(i.an is null,v.hospsub,ap.hospsub) HOSPSUB
                            ,"" GOVCODE,"" GOVNAME
                            ,ifnull(if(i.an is null,vp.claim_code or vp.auth_code,ap.claim_code),r.sss_approval_code) PERMITNO 
                            ,"" DOCNO,"" OWNRPID,"" OWNRNAME,i.an AN,v.vn SEQ,"" SUBINSCL 
                            ,"" RELINSCL,"" HTYPE,"" created_at,"" updated_at 
                            from vn_stat v
                            LEFT JOIN pttype p on p.pttype = v.pttype
                            LEFT JOIN ipt i on i.vn = v.vn 
                            LEFT JOIN pttype pp on pp.pttype = i.pttype                    
                            left join ipt_pttype ap on ap.an = i.an
                            left join visit_pttype vp on vp.vn = v.vn                    
                            LEFT JOIN rcpt_debt r on r.vn = v.vn
                            left join patient px on px.hn = v.hn 
                            LEFT JOIN opitemrece op on op.an = i.an
                            WHERE i.dchdate BETWEEN "'.$startdate.'" AND "'.$enddate.'" 
                            AND p.hipdata_code ="ucs"
                            AND op.icode = "3010887" 
                            GROUP BY i.an
                ');        
                foreach ($data_ins as $va1) { 
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
                        'HTYPE'                  => $va1->HTYPE,
                        'd_anaconda_id'          => 1               
                    ]);
                } 

                //D_opd
                $data_opd = DB::connection('mysql2')->select('
                        SELECT  v.hn HN
                        ,v.spclty CLINIC
                        ,DATE_FORMAT(v.vstdate,"%Y%m%d") DATEOPD
                        ,concat(substr(o.vsttime,1,2),substr(o.vsttime,4,2)) TIMEOPD
                        ,v.vn SEQ
                        ,"1" UUC 
                        from vn_stat v
                        LEFT JOIN ovst o on o.vn = v.vn
                        LEFT JOIN pttype p on p.pttype = v.pttype
                        LEFT JOIN patient pt on pt.hn = v.hn
                        LEFT JOIN ipt i on i.vn = v.vn                        
                        LEFT JOIN opitemrece op on op.an = i.an
                        WHERE i.dchdate BETWEEN "'.$startdate.'" AND "'.$enddate.'" 
                        AND p.hipdata_code ="ucs"
                        AND op.icode = "3010887" 
                        GROUP BY i.an                   
                ');          
                foreach ($data_opd as $val3) {            
                    $addo = new D_opd;  
                    $addo->HN             = $val3->HN;
                    $addo->CLINIC         = $val3->CLINIC;
                    $addo->DATEOPD        = $val3->DATEOPD;
                    $addo->TIMEOPD        = $val3->TIMEOPD;
                    $addo->SEQ            = $val3->SEQ;
                    $addo->UUC            = $val3->UUC; 
                    $addo->user_id        = $iduser;
                    $addo->d_anaconda_id  = 1;
                    $addo->save();
                }

                //D_orf
                $data_orf = DB::connection('mysql2')->select('
                        SELECT v.hn HN
                        ,DATE_FORMAT(v.vstdate,"%Y%m%d") DATEOPD
                        ,v.spclty CLINIC
                        ,ifnull(r1.refer_hospcode,r2.refer_hospcode) REFER
                        ,"0100" REFERTYPE
                        ,v.vn SEQ 
                        from vn_stat v
                        LEFT JOIN ovst o on o.vn = v.vn
                        LEFT JOIN referin r1 on r1.vn = v.vn
                        LEFT JOIN referout r2 on r2.vn = v.vn
                        LEFT JOIN ipt i on i.vn = v.vn
                        LEFT JOIN pttype p on p.pttype = v.pttype
                        LEFT JOIN opitemrece op on op.an = i.an
                        WHERE i.dchdate BETWEEN "'.$startdate.'" AND "'.$enddate.'"                 
                        and (r1.vn is not null or r2.vn is not null)
                        AND p.hipdata_code ="ucs"
                        AND op.icode = "3010887" ;
                '); 
                foreach ($data_orf as $va4) {              
                    $addof = new D_orf;  
                    $addof->HN             = $va4->HN;
                    $addof->CLINIC         = $va4->CLINIC;
                    $addof->DATEOPD         = $va4->DATEOPD;
                    $addof->REFER          = $va4->REFER;
                    $addof->SEQ            = $va4->SEQ;
                    $addof->REFERTYPE      = $va4->REFERTYPE; 
                    $addof->user_id        = $iduser;
                    $addof->d_anaconda_id   = 1;
                    $addof->save();
                }
 
                // D_odx
                $data_odx = DB::connection('mysql2')->select('
                    SELECT v.hn HN
                        ,DATE_FORMAT(v.vstdate,"%Y%m%d") DATEDX
                        ,v.spclty CLINIC
                        ,o.icd10 DIAG
                        ,o.diagtype DXTYPE
                        ,if(d.licenseno="","-99999",d.licenseno) DRDX
                        ,v.cid PERSON_ID
                        ,v.vn SEQ 
                        from vn_stat v
                        LEFT JOIN ovstdiag o on o.vn = v.vn
                        LEFT JOIN doctor d on d.`code` = o.doctor
                        LEFT JOIN icd101 ic on ic.code = o.icd10
                        LEFT JOIN ipt i on i.vn = v.vn
                        LEFT JOIN pttype p on p.pttype = v.pttype
                        LEFT JOIN opitemrece op on op.an = i.an
                        WHERE i.dchdate BETWEEN "'.$startdate.'" AND "'.$enddate.'" 
                        AND p.hipdata_code ="ucs"
                        AND op.icode = "3010887"
                ');
                foreach ($data_odx as $va5) {
                    $adddx = new D_odx;  
                    $adddx->HN             = $va5->HN;
                    $adddx->CLINIC         = $va5->CLINIC;
                    $adddx->DATEDX         = $va5->DATEDX;
                    $adddx->DIAG           = $va5->DIAG;
                    $adddx->DXTYPE         = $va5->DXTYPE;
                    $adddx->DRDX           = $va5->DRDX; 
                    $adddx->PERSON_ID      = $va5->PERSON_ID; 
                    $adddx->SEQ            = $va5->SEQ; 
                    $adddx->user_id        = $iduser;
                    $adddx->d_anaconda_id  = 1;
                    $adddx->save();                    
                }

                //D_oop
                $data_oop = DB::connection('mysql2')->select('
                        SELECT v.hn HN
                        ,DATE_FORMAT(v.vstdate,"%Y%m%d") DATEOPD
                        ,v.spclty CLINIC
                        ,o.icd10 OPER
                        ,if(d.licenseno="","-99999",d.licenseno) DROPID
                        ,pt.cid PERSON_ID
                        ,v.vn SEQ 
                        from vn_stat v
                        LEFT JOIN ovstdiag o on o.vn = v.vn
                        LEFT JOIN patient pt on v.hn=pt.hn
                        LEFT JOIN doctor d on d.`code` = o.doctor
                        LEFT JOIN icd9cm1 ic on ic.code = o.icd10
                        LEFT JOIN ipt i on i.vn = v.vn
                        LEFT JOIN pttype p on p.pttype = v.pttype
                        LEFT JOIN opitemrece op on op.an = i.an
                        WHERE i.dchdate BETWEEN "'.$startdate.'" AND "'.$enddate.'" 
                        AND p.hipdata_code ="ucs"
                        AND op.icode = "3010887"
                ');
                foreach ($data_oop as $va6) {
                    $addoop = new D_oop;  
                    $addoop->HN             = $va6->HN;
                    $addoop->CLINIC         = $va6->CLINIC;
                    $addoop->DATEOPD        = $va6->DATEOPD;
                    $addoop->OPER           = $va6->OPER;
                    $addoop->DROPID         = $va6->DROPID;
                    $addoop->PERSON_ID      = $va6->PERSON_ID; 
                    $addoop->SEQ            = $va6->SEQ; 
                    $addoop->user_id        = $iduser;
                    $addoop->d_anaconda_id   = 1;
                    $addoop->save(); 
                }

                //d_idx
                $data_idx = DB::connection('mysql2')->select('
                    SELECT a.an AN,o.icd10 DIAG
                        ,o.diagtype DXTYPE
                        ,if(d.licenseno="","-99999",d.licenseno) DRDX
                        FROM an_stat a
                        LEFT JOIN iptdiag o on o.an = a.an
                        LEFT JOIN doctor d on d.`code` = o.doctor
                        LEFT JOIN ipt ip on ip.an = a.an
                        LEFT JOIN pttype p on p.pttype = a.pttype
                        LEFT JOIN opitemrece op on op.an = ip.an
                        INNER JOIN icd101 i on i.code = o.icd10 
                        LEFT JOIN vn_stat x on x.vn = ip.vn
                        WHERE ip.dchdate BETWEEN "'.$startdate.'" AND "'.$enddate.'" 
                        AND p.hipdata_code ="ucs"
                        AND op.icode = "3010887"
                ');
                foreach ($data_idx as $va7) {
                    $addidrx = new D_idx; 
                    $addidrx->AN             = $va7->AN;
                    $addidrx->DIAG           = $va7->DIAG;
                    $addidrx->DXTYPE         = $va7->DXTYPE;
                    $addidrx->DRDX           = $va7->DRDX; 
                    $addidrx->user_id        = $iduser;
                    $addidrx->d_anaconda_id  = 1;
                    $addidrx->save(); 
                }
                //D_ipd
                $data_ipd = DB::connection('mysql2')->select('
                    SELECT v.hn HN,v.an AN
                        ,DATE_FORMAT(i.regdate,"%Y%m%d") DATEADM
                        ,Time_format(i.regtime,"%H%i") TIMEADM
                        ,DATE_FORMAT(i.dchdate,"%Y%m%d") DATEDSC
                        ,Time_format(i.dchtime,"%H%i")  TIMEDSC
                        ,right(i.dchstts,1) DISCHS
                        ,right(i.dchtype,1) DISCHT
                        ,i.ward WARDDSC,i.spclty DEPT
                        ,format(i.bw/1000,3) ADM_W
                        ,"1" UUC ,"I" SVCTYPE 
                        FROM an_stat v
                        LEFT JOIN ipt i on i.an = v.an
                        LEFT JOIN pttype p on p.pttype = v.pttype
                        LEFT JOIN patient pt on pt.hn = v.hn
                        LEFT JOIN vn_stat x on x.vn = i.vn
                        LEFT JOIN opitemrece op on op.an = i.an
                        WHERE i.dchdate BETWEEN "'.$startdate.'" AND "'.$enddate.'" 
                        AND p.hipdata_code ="ucs"
                        AND op.icode = "3010887"
                ');
                foreach ($data_ipd as $va8) {                
                    $addipd = new D_ipd; 
                    $addipd->AN             = $va8->AN;
                    $addipd->HN             = $va8->HN;
                    $addipd->DATEADM        = $va8->DATEADM;
                    $addipd->TIMEADM        = $va8->TIMEADM; 
                    $addipd->DATEDSC        = $va8->DATEDSC; 
                    $addipd->TIMEDSC        = $va8->TIMEDSC; 
                    $addipd->DISCHS         = $va8->DISCHS; 
                    $addipd->DISCHT         = $va8->DISCHT; 
                    $addipd->DEPT           = $va8->DEPT; 
                    $addipd->ADM_W          = $va8->ADM_W; 
                    $addipd->UUC            = $va8->UUC; 
                    $addipd->SVCTYPE        = $va8->SVCTYPE; 
                    $addipd->user_id        = $iduser;
                    $addipd->d_anaconda_id  = 1;
                    $addipd->save();
                }
                //D_irf
                $data_irf = DB::connection('mysql2')->select('
                        SELECT ""d_irf_id,v.an AN
                        ,ifnull(o.refer_hospcode,oo.refer_hospcode) REFER
                        ,"0100" REFERTYPE,"" created_at,"" updated_at
                        FROM an_stat v
                        LEFT JOIN referout o on o.vn =v.an
                        LEFT JOIN referin oo on oo.vn =v.an
                        LEFT JOIN ipt ip on ip.an = v.an
                        LEFT JOIN vn_stat x on x.vn = ip.vn
                        LEFT JOIN pttype p on p.pttype = v.pttype
                        LEFT JOIN opitemrece op on op.an = ip.an
                        WHERE ip.dchdate BETWEEN "'.$startdate.'" AND "'.$enddate.'" 
                        and (v.an in(select vn from referin where vn = oo.vn) or v.an in(select vn from referout where vn = o.vn))
                        AND p.hipdata_code ="ucs"
                        AND op.icode = "3010887"
                ');
                foreach ($data_irf as $va9) {
                    D_irf::insert([
                        'AN'                 => $va9->AN,
                        'REFER'              => $va9->REFER,
                        'REFERTYPE'          => $va9->REFERTYPE,
                        'user_id'            => $iduser,
                        'd_anaconda_id'      => 1
                    ]);
                }
                //D_aer
                $data_aer = DB::connection('mysql2')->select('
                        SELECT ""d_aer_id,v.hn HN,i.an AN
                        ,v.vstdate DATEOPD,vv.claim_code AUTHAE
                        ,"" AEDATE,"" AETIME,"" AETYPE,"" REFER_NO,"" REFMAINI
                        ,"" IREFTYPE,"" REFMAINO,"" OREFTYPE,"" UCAE,"" EMTYPE,v.vn SEQ
                        ,"" AESTATUS,"" DALERT,"" TALERT,"" created_at,"" updated_at
                        from vn_stat v
                        LEFT JOIN ipt i on i.vn = v.vn
                        LEFT JOIN visit_pttype vv on vv.vn = v.vn
                        LEFT OUTER JOIN pttype pt on pt.pttype =v.pttype
                        LEFT JOIN opitemrece op on op.an = i.an
                        WHERE i.dchdate BETWEEN "'.$startdate.'" AND "'.$enddate.'" 
                        AND pt.hipdata_code ="ucs"
                        AND op.icode = "3010887"
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
                        LEFT JOIN opitemrece op on op.an = v.an
                        WHERE v.dchdate BETWEEN "'.$startdate.'" AND "'.$enddate.'" 
                        AND pt.hipdata_code ="ucs"
                        AND op.icode = "3010887"
                        group by v.an;
                ');

                foreach ($data_aer as $va10) {
                    D_aer::insert([
                        'HN'                => $va10->HN,
                        'AN'                => $va10->AN,
                        'DATEOPD'           => $va10->DATEOPD,
                        'AUTHAE'            => $va10->AUTHAE,
                        'AEDATE'            => $va10->AEDATE,
                        'AETIME'            => $va10->AETIME,
                        'AETYPE'            => $va10->AETYPE,
                        'REFER_NO'          => $va10->REFER_NO,
                        'REFMAINI'          => $va10->REFMAINI,
                        'IREFTYPE'          => $va10->IREFTYPE,
                        'REFMAINO'          => $va10->REFMAINO,
                        'OREFTYPE'          => $va10->OREFTYPE,
                        'UCAE'              => $va10->UCAE,
                        'SEQ'               => $va10->SEQ,
                        'AESTATUS'          => $va10->AESTATUS,
                        'DALERT'            => $va10->DALERT,
                        'TALERT'            => $va10->TALERT,
                        'user_id'           => $iduser,
                        'd_anaconda_id'     => 1
                    ]);
                }

                //D_iop
                $data_iop = DB::connection('mysql2')->select('
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
                        LEFT OUTER JOIN pttype pt on pt.pttype =v.pttype
                        LEFT JOIN opitemrece op on op.an = v.an
                        WHERE v.dchdate BETWEEN "'.$startdate.'" AND "'.$enddate.'" 
                        AND pt.hipdata_code ="ucs"
                        AND op.icode = "3010887"
                         
                ');
                foreach ($data_iop as $va11) {
                    D_iop::insert([
                        'AN'                => $va11->AN,
                        'OPER'              => $va11->OPER,
                        'OPTYPE'            => $va11->OPTYPE,
                        'DROPID'            => $va11->DROPID,
                        'DATEIN'            => $va11->DATEIN,
                        'TIMEIN'            => $va11->TIMEIN,
                        'DATEOUT'           => $va11->DATEOUT,
                        'TIMEOUT'           => $va11->TIMEOUT,
                        'user_id'           => $iduser,
                        'd_anaconda_id'     => 1
                    ]);
                }

                // D_pat
                $data_pat = DB::connection('mysql2')->select('
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
                        LEFT JOIN opitemrece op on op.an = i.an
                        WHERE i.dchdate BETWEEN "'.$startdate.'" AND "'.$enddate.'" 
                        AND p.hipdata_code ="ucs"
                        AND op.icode = "3010887"
                         
                 
                ');
                foreach ($data_pat as $va12) {
                    D_pat::insert([
                        'HCODE'               => $va12->HCODE,
                        'HN'                  => $va12->HN,
                        'CHANGWAT'            => $va12->CHANGWAT,
                        'AMPHUR'              => $va12->AMPHUR,
                        'DOB'                 => $va12->DOB,
                        'SEX'                 => $va12->SEX,
                        'MARRIAGE'            => $va12->MARRIAGE,
                        'OCCUPA'              => $va12->OCCUPA,
                        'NATION'              => $va12->NATION,
                        'PERSON_ID'           => $va12->PERSON_ID,
                        'NAMEPAT'             => $va12->NAMEPAT,
                        'TITLE'               => $va12->TITLE,
                        'FNAME'               => $va12->FNAME,
                        'LNAME'               => $va12->LNAME,
                        'IDTYPE'              => $va12->IDTYPE,
                        'user_id'             => $iduser,
                        'd_anaconda_id'       => 1
                    ]);
                }

                //D_cht
                $data_cht = DB::connection('mysql2')->select('
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
                        LEFT JOIN opitemrece op on op.an = a.an
                        WHERE a.dchdate BETWEEN "'.$startdate.'" AND "'.$enddate.'" 
                        AND pt.hipdata_code ="ucs"
                        AND op.icode = "3010887"
                ');
                foreach ($data_cht as $va13) {
                    D_cht::insert([
                        'HN'                => $va13->HN,
                        'AN'                => $va13->AN,
                        'DATE'              => $va13->DATE,
                        'TOTAL'             => $va13->TOTAL,
                        'PAID'              => $va13->PAID,
                        'PTTYPE'            => $va13->PTTYPE,
                        'PERSON_ID'         => $va13->PERSON_ID,
                        'SEQ'               => $va13->SEQ,
                        'user_id'           => $iduser,
                        'd_anaconda_id'     => 1
                    ]);
                }

                //D_cha
                $data_cha = DB::connection('mysql2')->select('
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
                        LEFT JOIN pttype pt on pt.pttype = vv.pttype
                        WHERE v1.dchdate BETWEEN "'.$startdate.'" AND "'.$enddate.'" 
                        AND pt.hipdata_code ="ucs"
                        AND v.icode = "3010887"
                        group by v.an,CHRGITEM

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
                        
                        LEFT JOIN pttype pt on pt.pttype = v1.pttype
                        WHERE v1.dchdate BETWEEN "'.$startdate.'" AND "'.$enddate.'" 
                        AND pt.hipdata_code ="ucs"
                        AND v.icode = "3010887"

                        group by v.an,CHRGITEM;
                ');
                foreach ($data_cha as $va14) {
                    D_cha::insert([
                        'HN'                => $va14->HN,
                        'AN'                => $va14->AN,
                        'DATE'              => $va14->DATE,
                        'CHRGITEM'          => $va14->CHRGITEM,
                        'AMOUNT'            => $va14->AMOUNT,
                        'PERSON_ID'         => $va14->PERSON_ID,
                        'SEQ'               => $va14->SEQ,
                        'user_id'           => $iduser,
                        'd_anaconda_id'     => 1
                    ]);
                }

                //D-dru
                // $data_dru = DB::connection('mysql2')->select('
                //         SELECT v.hcode HCODE ,op.hn HN ,op.an AN
                //         ,v.spclty CLINIC ,v.cid PERSON_ID ,DATE_FORMAT(op.vstdate,"%Y%m%d") DATE_SERV
                //         ,d.icode DID ,concat(d.`name`," ",d.strength, " ",d.units) DIDNAME
                //         ,sum(op.qty) AMOUNT ,round(op.unitprice,2) DRUGPRIC
                //         ,"0.00" DRUGCOST ,d.did DIDSTD ,d.units UNIT
                //         ,concat(d.packqty,"x",d.units) UNIT_PACK ,op.vn SEQ
                //         ,oo.presc_reason DRUGREMARK ," " PA_NO ," " TOTCOPAY
                //         ,if(op.item_type="H","2","1") USE_STATUS ," " TOTAL," " SIGCODE," "  SIGTEXT
                //         from opitemrece op
                //         LEFT JOIN drugitems d on d.icode = op.icode
                //         LEFT JOIN vn_stat v on v.vn = op.vn
                //         LEFT JOIN ovst_presc_ned oo on oo.vn = op.vn and oo.icode=op.icode
                //         LEFT JOIN ipt i on i.an = op.an
                //         where i.dchdate BETWEEN "'.$startdate.'" AND "'.$enddate.'" 
                //         and d.did is not null 
                //         GROUP BY op.an,did
                        
                //         UNION all 
                //         SELECT pt.hcode HCODE ,op.hn HN ,op.an AN ,i1.spclty CLINIC ,pt.cid PERSON_ID
                //         ,DATE_FORMAT((op.vstdate),"%Y%m%d") DATE_SERV
                //         ,d.icode DID ,concat(d.`name`," ",d.strength," ",d.units) DIDNAME
                //         ,sum(op.qty) AMOUNT,round(op.unitprice,2) DRUGPRIC ,"0.00" DRUGCOST
                //         ,d.did DIDSTD ,d.units UNIT ,concat(d.packqty,"x",d.units) UNIT_PACK
                //         ,ifnull(op.vn,op.an) SEQ ,oo.presc_reason DRUGREMARK
                //         ," " PA_NO ," " TOTCOPAY ,if(op.item_type="H","2","1") USE_STATUS ," " TOTAL," " SIGCODE," "  SIGTEXT
                //         from opitemrece op
                //         LEFT JOIN drugitems d on d.icode = op.icode
                //         inner JOIN ipt i1 on i1.an = op.an
                //         LEFT JOIN patient pt  on pt.hn = i1.hn 
                //         LEFT JOIN ovst_presc_ned oo on oo.vn = op.vn and oo.icode=op.icode 
                //         where i1.dchdate BETWEEN "'.$startdate.'" AND "'.$enddate.'" 
                //         and d.did is not null AND op.qty<>"0"
                //         GROUP BY op.an,d.icode,USE_STATUS;
                // ');
                // foreach ($data_dru as $va15) { 
                //     $adddrx = new D_dru;  
                //     $adddrx->HN             = $va15->HN;
                //     $adddrx->CLINIC         = $va15->CLINIC;
                //     $adddrx->HCODE          = $va15->HCODE;
                //     $adddrx->AN             = $va15->AN;
                //     $adddrx->PERSON_ID      = $va15->PERSON_ID;
                //     $adddrx->DATE_SERV      = $va15->DATE_SERV;
                //     $adddrx->DID            = $va15->DID; 
                //     $adddrx->DIDNAME        = $va15->DIDNAME; 
                //     $adddrx->AMOUNT         = $va15->AMOUNT;
                //     $adddrx->DRUGPRIC       = $va15->DRUGPRIC;
                //     $adddrx->DRUGCOST       = $va15->DRUGCOST;
                //     $adddrx->DIDSTD         = $va15->DIDSTD;
                //     $adddrx->UNIT           = $va15->UNIT;
                //     $adddrx->UNIT_PACK      = $va15->UNIT_PACK;
                //     $adddrx->SEQ            = $va15->SEQ;
                //     $adddrx->DRUGREMARK     = $va15->DRUGREMARK;
                //     $adddrx->PA_NO          = $va15->PA_NO;
                //     $adddrx->TOTCOPAY       = $va15->TOTCOPAY;
                //     $adddrx->USE_STATUS     = $va15->USE_STATUS;
                //     $adddrx->TOTAL          = $va15->TOTAL;
                //     $adddrx->SIGCODE        = $va15->SIGCODE; 
                //     $adddrx->SIGTEXT        = $va15->SIGTEXT; 
                //     $adddrx->user_id        = $iduser;
                //     $adddrx->d_anaconda_id  = 1;
                //     $adddrx->save();
                // }


                $data = DB::connection('mysql')->select('SELECT * from acc_imc_hos where dchdate between "'.$startdate.'" AND "'.$enddate.'"');  
            }
                  
            return view('claim.imc',[
                'startdate'        =>     $startdate,
                'enddate'          =>     $enddate, 
                'data'             =>     $data, 
            ]);
    }

    // public function ucep24_an(Request $request,$an)
    // { 
    //         $startdate = $request->startdate;
    //         $enddate = $request->enddate;
     
    //         $date = date('Y-m-d');
    //         $y = date('Y') + 543;
    //         $newweek = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
    //         $newDate = date('Y-m-d', strtotime($date . ' -5 months')); //ย้อนหลัง 5 เดือน
    //         $newyear = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี
    //         $yearnew = date('Y');
    //         $yearold = date('Y')-1;
    //         $start = (''.$yearold.'-10-01');
    //         $end = (''.$yearnew.'-09-30'); 
 
    //             $data = DB::connection('mysql')->select('   
                       

    //                     select o.an,i.income,i.name as nameliss,sum(o.qty) as qty,
    //                     (select sum(sum_price) from hos.opitemrece where an=o.an and income = o.income and paidst in("02")) as paidst02,
    //                     (select sum(sum_price) from hos.opitemrece where an=o.an and income = o.income and paidst in("01","03")) as paidst0103,
    //                     (select sum(u.sum_price) from acc_ucep24 u where u.an= o.an and i.income = u.income) as paidst_ucep
    //                     from hos.opitemrece o
    //                     left outer join hos.nondrugitems n on n.icode = o.icode
    //                     left outer join hos.income i on i.income = o.income
    //                     where o.an = "'.$an.'"  
    //                     group by i.name
    //                     order by i.income
                      
    //             '); 

    //             // SELECT o.an,o.hn,pt.cid,concat(pt.pname,pt.fname," ",pt.lname) ptname
    //             // ,i.dchdate,ii.pttype
    //             // ,o.icode,n.name as nameliss,a.vstdate,o.rxdate,a.vsttime,o.rxtime,o.income,o.qty,o.unitprice,o.sum_price
    //             // ,hour(TIMEDIFF(concat(a.vstdate," ",a.vsttime),concat(o.rxdate,"",o.rxtime))) ssz
    //             // from hos.opitemrece o
    //             // LEFT JOIN hos.ipt i on i.an = o.an
    //             // LEFT JOIN hos.ovst a on a.an = o.an
    //             // left JOIN hos.er_regist e on e.vn = i.vn
    //             // LEFT JOIN hos.ipt_pttype ii on ii.an = i.an
    //             // LEFT JOIN hos.pttype p on p.pttype = ii.pttype 
    //             // LEFT JOIN hos.s_drugitems n on n.icode = o.icode
    //             // LEFT JOIN hos.patient pt on pt.hn = a.hn
    //             // LEFT JOIN hos.pttype ptt on a.pttype = ptt.pttype	
                
    //             // WHERE i.an = "'.$an.'"  
    //             // and o.paidst ="02"
    //             // and p.hipdata_code ="ucs"
    //             // and DATEDIFF(o.rxdate,a.vstdate)<="1"
    //             // and hour(TIMEDIFF(concat(a.vstdate," ",a.vsttime),concat(o.rxdate," ",o.rxtime))) <="24"
    //             // and e.er_emergency_type  in("1","5")
    //             // and n.nhso_adp_code in(SELECT code from hshooterdb.h_ucep24)
    //             // select i.income,i.name,sum(o.qty),
    //             // (select sum(sum_price) from opitemrece where an=o.an and income = o.income and paidst in('02')),
    //             // (select sum(sum_price) from opitemrece where an=o.an and income = o.income and paidst in('01','03')),
    //             // (select sum(u.sum_price) from eclaimdb80.ucep_an u where u.an= o.an and i.income = u.income)

    //             // from opitemrece o
    //             // left outer join nondrugitems n on n.icode = o.icode
    //             // left outer join income i on i.income = o.income
    //             // where o.an ='666666666' 
    //             // group by i.name
    //             // order by i.income
             

    //         return view('ucep.ucep24_an',[
    //             'startdate'        =>     $startdate,
    //             'enddate'          =>     $enddate, 
    //             'data'             =>     $data, 
    //         ]);
    // }
    // public function ucep24_income(Request $request,$an,$income)
    // { 
    //         $startdate = $request->startdate;
    //         $enddate = $request->enddate;
    //         // select *
    //         // from acc_ucep24                         
    //         // where an = "'.$an.'"  and income = "'.$income.'" 
    //             $data = DB::connection('mysql')->select('  
    //                     select o.income,ifnull(n.icode,d.icode) as icode,ifnull(n.billcode,n.nhso_adp_code) as nhso_adp_code,ifnull(n.name,d.name) as dname,sum(o.qty) as qty,sum(sum_price) as sum_price
    //                     ,(SELECT sum(qty) from pkbackoffice.acc_ucep24 where an = o.an and icode = o.icode) as qty_ucep 
    //                     ,(SELECT sum(sum_price) from pkbackoffice.acc_ucep24 where an = o.an and icode = o.icode) as price_ucep
    //                     from hos.opitemrece o
    //                     left outer join hos.nondrugitems n on n.icode = o.icode
    //                     left outer join hos.drugitems d on d.icode = o.icode
    //                     left outer join hos.income i on i.income = o.income
    //                     where o.an = "'.$an.'"
    //                     and o.income = "'.$income.'" 
    //                     group by o.icode
    //                     order by o.icode
    //             '); 

    //         return view('ucep.ucep24_income',[
    //             'startdate'        =>     $startdate,
    //             'enddate'          =>     $enddate, 
    //             'data'             =>     $data, 
    //             'an'               =>     $an, 
    //             'income'           =>     $income, 
    //         ]);
    // }
    
    
   
 }