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
use App\Models\Aipn_ipdx;
use App\Models\Aipn_ipop;   
use App\Models\Aipn_session;
use App\Models\Aipn_billitems;
use App\Models\Aipn_ipadt;
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
// use File;
 
 

class AipnController extends Controller
{
    public function aipn(Request $request)
    {
        $datestart = $request->startdate;
        $dateend = $request->enddate;
        $an = $request->AN;
        $data['users'] = User::get();
        $data['leave_month'] = DB::table('leave_month')->get();
        // dd($datestart);    
        $aipn_data = DB::connection('mysql7')->select('   
            SELECT * FROM aipn_ipadt 
        '); 
        $aipn_billitems = DB::connection('mysql7')->select('   
            SELECT * FROM aipn_billitems   
        ');
        $ssop_dispensing = DB::connection('mysql7')->select('   
            SELECT * FROM ssop_dispensing   
        ');   
        $ssop_dispenseditems = DB::connection('mysql7')->select('   
            SELECT * FROM ssop_dispenseditems   
        ');  
        $aipn_ipop = DB::connection('mysql7')->select('   
            SELECT * FROM aipn_ipop   
        ');
        $aipn_ipdx = DB::connection('mysql7')->select('   
            SELECT * FROM aipn_ipdx   
        ');
        
        return view('claim.aipn',$data,[
            'start'                => $datestart,
            'end'                  => $dateend,
            'aipn_data'            => $aipn_data,
            'aipn_billitems'       => $aipn_billitems,
            'ssop_dispensing'      => $ssop_dispensing,
            'ssop_dispenseditems'  => $ssop_dispenseditems,
            'an'                   => $an,
            'aipn_ipop'            => $aipn_ipop, 
            'aipn_ipdx'            => $aipn_ipdx
        ]);
    }
    public function aipnsearch (Request $request)
    {
        $datestart = $request->startdate;
        $dateend = $request->enddate;
        $an = $request->AN;
        // dd($an);
        if ($an != '') {
            $aipn_data = DB::connection('mysql3')->select('   
                SELECT
                    i.an,  
                    i.an as AN,i.hn as HN,"0" as IDTYPE 
                    ,showcid(if(pt.nationality=99,pt.cid,pc.cardno)) as PIDPAT
                    ,pt.pname as TITLE
                    ,concat(pt.fname," ",pt.lname) as NAMEPAT 
                    ,pt.birthday as DOB
                    ,a.sex as SEX
                    ,pt.marrystatus as MARRIAGE
                    ,pt.chwpart as CHANGWAT
                    ,pt.amppart as AMPHUR
                    ,pt.citizenship as NATION
                    ,"C" as AdmType
                    ,"O" as AdmSource
                    ,i.regdate as DTAdm_d
                    ,i.regtime as DTAdm_t
                    ,i.dchdate as DTDisch_d
                    ,i.dchtime as DTDisch_t 
                    ,"0" AS LeaveDay                
                    ,i.dchstts as DischStat
                    ,i.dchtype as DishType
                    ,"" as AdmWt
                    ,i.ward as DishWard
                    ,a.spclty as Dept
                    ,seekhipdata(ptt.hipdata_code,0) maininscl
                    ,i.pttype
                    ,concat(i.pttype,":",ptt.name) pttypename 
                    ,hospmain(i.an) HMAIN
                    ,"IP" as ServiceType
                    from ipt i
                    left join patient pt on pt.hn=i.hn
                    left join ptcardno pc on pc.hn=pt.hn and pc.cardtype="02"
                    left join an_stat a on a.an=i.an
                    left join pttype ptt on ptt.pttype=i.pttype
                    left join pttype_eclaim ec on ec.code=ptt.pttype_eclaim_id 
                    left join opitemrece oo on oo.an=i.an
                    left join income inc on inc.income=oo.income
                    left join s_drugitems d on d.icode=oo.icode 
                    WHERE i.an ="'.$an .'"                     
                    AND ptt.pttype = "A7"
                    group by i.an
                    order by hn
            ');
            // ,CONCAT(i.regdate,"T",i.regtime) as DTAdm
            // ,CONCAT(i.dchdate,"T",i.dchtime) as DTDisch 

            Aipn_ipadt::truncate();

            foreach ($aipn_data as $key => $value) {     
                Aipn_ipadt::insert([
                    'AN'             => $value->AN,
                    'HN'             => $value->HN,
                    'IDTYPE'         => $value->IDTYPE,
                    'PIDPAT'         => $value->PIDPAT,
                    'TITLE'          => $value->TITLE,
                    'NAMEPAT'        => $value->NAMEPAT,
                    'DOB'            => $value->DOB,
                    'SEX'            => $value->SEX,
                    'MARRIAGE'       => $value->MARRIAGE,
                    'CHANGWAT'       => $value->CHANGWAT,
                    'AMPHUR'         => $value->AMPHUR,
                    'NATION'         => $value->NATION,
                    'AdmType'        => $value->AdmType,
                    'AdmSource'      => $value->AdmSource,
                    'DTAdm_d'        => $value->DTAdm_d,
                    'DTAdm_t'        => $value->DTAdm_t,
                    'DTDisch_d'      => $value->DTDisch_d,
                    'DTDisch_t'      => $value->DTDisch_t,
                    'LeaveDay'       => $value->LeaveDay,
                    'DischStat'      => $value->DischStat,
                    'DishType'       => $value->DishType,
                    'AdmWt'          => $value->AdmWt,
                    'DishWard'       => $value->DishWard,
                    'Dept'           => $value->Dept,
                    'HMAIN'          => $value->HMAIN,
                    'ServiceType'    => $value->ServiceType 
                ]);
            }
            Aipn_billitems::truncate();
            foreach ($aipn_data as $key => $item) {   
                $aipn_billitems = DB::connection('mysql3')->select('   
                    SELECT  i.an,
                            i.an as AN,"" as sequence
                            
                            ,i.regdate as DTAdm_d
                            ,i.regtime as DTAdm_t
                            ,i.dchdate as ServDate
                            ,i.dchtime as ServTime 
                            ,case 
                            when oo.item_type="H" then "04"
                            else zero(inc.group1) end BillGr
                            ,oo.income as BillGrCS
                            ,ifnull(if(inc.group1 in (03,04),dd.tmt_tmlt,d.nhso_adp_code),"") CSCode
                            ,oo.icode 
                            ,concat_ws(" ",d.name,d.strength) Descript
                            ,sum(oo.qty) as QTY
                            ,oo.UnitPrice as pricehos
                            ,dd.UnitPrice as pricecat
                            ,sum(oo.sum_price) ChargeAmt_ 
                            ,dd.tmt_tmlt 
                            ,inc.group1
                            ,dd.billcode
                            ,"" as STDCode
                            ,case 
                            when oo.paidst in ("01","03") then "T"
                            else "D" end ClaimCat
                            ,"0" as ClaimUP
                            ,"0" as ClaimAmt
                            ,i.dchdate
                            ,sum(if(oo.paidst="04",sum_price,0)) Discount   
                            from ipt i
                            left outer join opitemrece oo on oo.an=i.an
                            left outer join an_stat a on a.an=i.an
                            left outer join patient pt on i.hn=pt.hn
                            left outer join income inc on inc.income=oo.income
                            left outer join income_group g on inc.income_group=g.income_group
                            left outer join s_drugitems d on oo.icode=d.icode
                            left join claim.aipn_drugcat_labcat dd on dd.icode=oo.icode	

                            WHERE i.an="'.$item->AN.'" 
                            and inc.group1 IN("03","04","06","07")
                            and oo.qty<>0
                            and oo.UnitPrice<>0
                            and oo.paidst not in ("01","03")                        
                            group by oo.icode
                            order by i.an desc
                    ');
                    // and i.an ="660000147"
                    // as CodeSys 
                    // and inc.group1 in ("03","04","06","07")
                    $i = 1;
                    foreach ($aipn_billitems as $key => $value2) { 
                    
                    $codesys = $value2->BillGr;
                    $cs = $value2->CSCode;
                    $billcs = $value2->BillGrCS;
                   

                    if ($codesys == '03' || $codesys == '04') {
                        $code_sys = 'TMT';
                        $stc = $value2->tmt_tmlt;
                    }elseif ($codesys == '06' || $codesys == '07') {
                        $code_sys = 'TMLT';  
                        $stc = $value2->tmt_tmlt;
                    } else {
                        $code_sys = '';
                    }

                    if ($cs == 'XXXX') {
                        $cs_ = '';
                    }elseif ($cs == 'XXXXX') {
                        $cs_ = '';  
                    }elseif ($cs == 'XXXXXX') {
                        $cs_ = '';  
                    } else {
                        $cs_ = $value2->CSCode;
                    }

                    if ($billcs == '04') {
                        $bilcs_ = '03'; 
                    } else {
                        $bilcs_ = $value2->BillGrCS;
                    }

                    $check_ = DB::connection('mysql7')->table('aipn_drugcat_labcat')->where('icode','=',$value2->icode)->count();
                    if ($check_ > 0) {
                        $price = $value2->pricecat;
                        $cm = $value2->QTY * $price;
                    } else {
                        $price = $value2->pricehos;
                        $cm = $value2->QTY * $price;
                    }
                   
                    
                    Aipn_billitems::insert([                        
                        'AN'                => $value2->AN,
                        'sequence'          => $i++,
                        'ServDate'          => $value2->ServDate,
                        'ServTime'          => $value2->ServTime,
                        'BillGr'            => $value2->BillGr,
                        'BillGrCS'          => $bilcs_,
                        'CSCode'            => $value2->billcode,
                        'LCCode'            => $value2->icode,
                        'Descript'          => $value2->Descript,
                        'QTY'               => $value2->QTY,
                        'UnitPrice'         => $price,
                        'ChargeAmt'         => $cm,
                        'ClaimSys'          => "SS",
                        'CodeSys'           => $code_sys,
                        'STDCode'           => $stc,
                        'Discount'          => "0.0000",
                        'ProcedureSeq'      => "0",
                        'DiagnosisSeq'      => "0",
                        'DateRev'          => $value2->ServDate,
                        'ClaimCat'          => $value2->ClaimCat,
                        'ClaimUP'           => $value2->ClaimUP,
                        'ClaimAmt'          => $value2->ClaimAmt 
                    ]);
                }
            }

            $aipn_ipop = DB::connection('mysql3')->select('   
                SELECT
                        i.an as AN
                        ,"" as sequence,"ICD9CM" as CodeSys 
                        ,cc.icd9 as Code
                        ,icdname(cc.icd9) as Procterm
                        ,doctorlicense(cc.doctor) as DR
                        ,date_format(if(opdate is null,caldatetime(regdate,regtime),caldatetime(opdate,optime)),"%Y-%m-%dT%T") as DateIn
                        ,date_format(if(enddate is null,caldatetime(regdate,regtime),caldatetime(enddate,endtime)),"%Y-%m-%dT%T") as DateOut
                        ," " as Location
                        from ipt i
                        join iptoprt cc on cc.an=i.an
                        WHERE i.an ="'.$an .'"    
            ');

            Aipn_ipop::truncate();
            $i = 1;  
            foreach ($aipn_ipop as $key => $valueipop) {  
                
                Aipn_ipop::insert([
                    'an'             => $valueipop->AN,
                    'sequence'       => $i++,
                    'CodeSys'        => $valueipop->CodeSys,
                    'Code'           => $valueipop->Code,
                    'Procterm'       => $valueipop->Procterm,
                    'DR'             => $valueipop->DR,
                    'DateIn'         => $valueipop->DateIn,
                    'DateOut'        => $valueipop->DateOut,
                    'Location'       => $valueipop->Location 
                ]);
            }

            $aipn_ipdx = DB::connection('mysql3')->select('   
                SELECT 
                        i.an as AN
                        ,"" as sequence
                        ,diagtype as DxType
                        ,if(ifnull(aa.codeset,"")="TT","ICD-10-TM","ICD-10") as CodeSys
                        ,dx.icd10 as Dcode
                        ,icdname(dx.icd10) as DiagTerm
                        ,doctorlicense(i.admdoctor) as DR,null datediag
                        from ipt i
                        join iptdiag dx on dx.an=i.an
                        left join icd101 aa on aa.code=dx.icd10
                        WHERE i.an ="'.$an .'" 
                        order by diagtype,ipt_diag_id 
            ');
            Aipn_ipdx::truncate();
            $j = 1;  
            foreach ($aipn_ipdx as $key => $valueip) {  
                
                Aipn_ipdx::insert([
                    'an'             => $valueip->AN,
                    'sequence'       => $j++,
                    'DxType'         => $valueip->DxType,
                    'CodeSys'        => $valueip->CodeSys,
                    'Dcode'          => $valueip->Dcode,
                    'DiagTerm'       => $valueip->DiagTerm,
                    'DR'             => $valueip->DR,
                    'datediag'       => $valueip->datediag
                ]);
            }

            $update_billitems = DB::connection('mysql7')->select('SELECT * FROM aipn_billitems WHERE STDCode IS NULL');
            foreach ($update_billitems as $key => $value) {
                $id = $value->aipn_billitems_id;
                $del = Aipn_billitems::find($id);
                $del->delete();            
            }

        } else {             
        
            $aipn_data = DB::connection('mysql3')->select('   
                SELECT  
                        i.an,  
                        i.an as AN,i.hn as HN,"0" as IDTYPE 
                        ,showcid(if(pt.nationality=99,pt.cid,pc.cardno)) as PIDPAT
                        ,pt.pname as TITLE
                        ,concat(pt.fname," ",pt.lname) as NAMEPAT 
                        ,pt.birthday as DOB
                        ,a.sex as SEX
                        ,pt.marrystatus as MARRIAGE
                        ,pt.chwpart as CHANGWAT
                        ,pt.amppart as AMPHUR
                        ,pt.citizenship as NATION
                        ,"C" as AdmType
                        ,"O" as AdmSource
                        ,i.regdate as DTAdm_d
                        ,i.regtime as DTAdm_t
                        ,i.dchdate as DTDisch_d
                        ,i.dchtime as DTDisch_t 
                        ,"0" AS LeaveDay                
                        ,i.dchstts as DischStat
                        ,i.dchtype as DishType
                        ,"" as AdmWt
                        ,i.ward as DishWard
                        ,a.spclty as Dept
                        ,seekhipdata(ptt.hipdata_code,0) maininscl
                        ,i.pttype
                        ,concat(i.pttype,":",ptt.name) pttypename 
                        ,hospmain(i.an) HMAIN
                        ,"IP" as ServiceType
                        from ipt i
                        left join patient pt on pt.hn=i.hn
                        left join ptcardno pc on pc.hn=pt.hn and pc.cardtype="02"
                        left join an_stat a on a.an=i.an
                        left join pttype ptt on ptt.pttype=i.pttype
                        left join pttype_eclaim ec on ec.code=ptt.pttype_eclaim_id 
                        left join opitemrece oo on oo.an=i.an
                        left join income inc on inc.income=oo.income
                        left join s_drugitems d on d.icode=oo.icode 
                        WHERE i.dchdate BETWEEN "'.$datestart.'" AND "'.$dateend.'"                    
                        AND ptt.pttype = "A7"
                        group by i.an
                        order by hn 
            ');
            // AND ptt.hipdata_code = "SSS"
            // ,ABS(DATEDIFF(i.regdate,a.dchdate)) AS LeaveDay
            Aipn_ipadt::truncate();

            foreach ($aipn_data as $key => $value) {     
                Aipn_ipadt::insert([
                    'AN'             => $value->AN,
                    'HN'             => $value->HN,
                    'IDTYPE'         => $value->IDTYPE,
                    'PIDPAT'         => $value->PIDPAT,
                    'TITLE'          => $value->TITLE,
                    'NAMEPAT'        => $value->NAMEPAT,
                    'DOB'            => $value->DOB,
                    'SEX'            => $value->SEX,
                    'MARRIAGE'       => $value->MARRIAGE,
                    'CHANGWAT'       => $value->CHANGWAT,
                    'AMPHUR'         => $value->AMPHUR,
                    'NATION'         => $value->NATION,
                    'AdmType'        => $value->AdmType,
                    'AdmSource'      => $value->AdmSource,
                    'DTAdm_d'        => $value->DTAdm_d,
                    'DTAdm_t'        => $value->DTAdm_t,
                    'DTDisch_d'      => $value->DTDisch_d,
                    'DTDisch_t'      => $value->DTDisch_t,
                    'LeaveDay'       => $value->LeaveDay,
                    'DischStat'      => $value->DischStat,
                    'DishType'       => $value->DishType,
                    'AdmWt'          => $value->AdmWt,
                    'DishWard'       => $value->DishWard,
                    'Dept'           => $value->Dept,
                    'HMAIN'          => $value->HMAIN,
                    'ServiceType'    => $value->ServiceType 
                ]);
            }

            // Aipn_billitems::truncate();
            // foreach ($aipn_data as $key => $item) {   
            //     $aipn_billitems = DB::connection('mysql3')->select('   
            //         SELECT  
            //                 i.an as AN,"" as sequence
            //                 ,i.regdate as ServDate,i.regtime as ServTime
            //                 ,case 
            //                 when oo.item_type="H" then "04"
            //                 else zero(inc.group1) end BillGr
            //                 ,oo.income as BillGrCS
            //                 ,ifnull(if(inc.group1 in (03,04),dd.tmtid,d.nhso_adp_code),"") CSCode
            //                 ,oo.icode 
            //                 ,concat_ws(" ",d.name,d.strength) Descript
            //                 ,sum(oo.qty) as QTY
            //                 ,oo.UnitPrice 
            //                 ,sum(oo.sum_price) ChargeAmt
            //                 ,dd.tmtid
            //                 ,l.tmlt 
            //                 ,inc.group1
            //                 ,"" as STDCode
            //                 ,case 
            //                 when oo.paidst in ("01","03") then "T"
            //                 else "D" end ClaimCat
            //                 ,"0" as ClaimUP
            //                 ,"0" as ClaimAmt
            //                 ,i.dchdate
            //                 ,sum(if(oo.paidst="04",sum_price,0)) Discount  
                                        
            //                 from ipt i
            //                 left outer join opitemrece oo on oo.an=i.an
            //                 left outer join an_stat a on a.an=i.an
            //                 left outer join patient pt on i.hn=pt.hn
            //                 left outer join income inc on inc.income=oo.income
            //                 left outer join income_group g on inc.income_group=g.income_group
            //                 left outer join s_drugitems d on oo.icode=d.icode 
            //                 left join claim.aipn_drugcat_sks dd on dd.hospdcode=oo.icode
            //                 left join claim.aipn_labcat_sks l on l.lccode=oo.icode and l.benifitpla regexp "SS"
            //             WHERE i.dchdate BETWEEN "'.$datestart.'" AND "'.$dateend.'" 
            //                 and i.an="'.$item->AN.'" 
            //                 and oo.qty<>0
            //                 and oo.UnitPrice<>0
            //                 and oo.paidst not in ("01","03")
                        
            //                 group by oo.icode
            //                 order by i.an desc
            //         ');
            //         // and i.an ="660000147"
            //         // as CodeSys

            //         // and inc.group1 in ("03","04","06","07")
        
            
            //     foreach ($aipn_billitems as $key => $value2) { 
                    
            //         $codesys = $value2->BillGr;
            //         $cs = $value2->CSCode;
            //         $billcs = $value2->BillGrCS;

            //         if ($codesys == '03') {
            //             $code_sys = 'TMT';
            //             $stc = $value2->tmtid;
            //         }elseif ($codesys == '07') {
            //             $code_sys = 'TMLT';  
            //             $stc = $value2->tmlt;
            //         } else {
            //             $code_sys = '';
            //         }

            //         if ($cs == 'XXXX') {
            //             $cs_ = '';
            //         }elseif ($cs == 'XXXXX') {
            //             $cs_ = '';  
            //         }elseif ($cs == 'XXXXXX') {
            //             $cs_ = ''; 
            //         // }elseif ($cs == '04') {
            //         //     $cs_ = '';
            //         } else {
            //             $cs_ = $value2->CSCode;
            //         }

            //         if ($billcs == '04') {
            //             $bilcs_ = '03'; 
            //         } else {
            //             $bilcs_ = $value2->BillGrCS;
            //         }
                    
            //         Aipn_billitems::insert([
                        
            //             'AN'                => $value2->AN,
            //             'sequence'          => $value2->sequence,
            //             'ServDate'          => $value2->ServDate,
            //             'ServTime'          => $value2->ServTime,
            //             'BillGr'            => $value2->BillGr,
            //             'BillGrCS'          => $bilcs_,
            //             'CSCode'            => $cs_,
            //             'LCCode'            => $value2->icode,
            //             'Descript'          => $value2->Descript,
            //             'QTY'               => $value2->QTY,
            //             'UnitPrice'         => $value2->UnitPrice,
            //             'ChargeAmt'         => $value2->ChargeAmt,
            //             'CodeSys'           => $code_sys,
            //             'STDCode'           => $stc,
            //             'ClaimCat'          => $value2->ClaimCat,
            //             'ClaimUP'           => $value2->ClaimUP,
            //             'ClaimAmt'          => $value2->ClaimAmt 
            //         ]);
            //     }

            // }

        }
        $aipn_billitems = DB::connection('mysql7')->select('   
            SELECT * FROM aipn_billitems   
        ');
        $aipn_ipop = DB::connection('mysql7')->select('   
            SELECT * FROM aipn_ipop   
        ');
        $aipn_ipdx = DB::connection('mysql7')->select('   
            SELECT * FROM aipn_ipdx   
        ');

        return view('claim.aipn',[
            'start'            => $datestart,
            'end'              => $dateend,
            'aipn_data'        => $aipn_data,
            'aipn_billitems'   => $aipn_billitems,
            'an'               => $an,
            'aipn_ipop'        => $aipn_ipop,
            'aipn_ipdx'        => $aipn_ipdx
        ]);
    } 
    public function aipn_send(Request $request)
    {
        $datestart = $request->startdate;
        $dateend = $request->enddate; 
        $an = $request->AN;
        $ip = $request->ip(); 
        // dd($datestart);
        $sss_date_now = date("Y-m-d");
        $aipn_time_now = date("H:i:s");
        $sesid_status = 'new'; #ส่งค่าสำหรับเงื่อนไขการบันทึกsession

        $folder_old='/*';
        $pathdir =  "C:/export/".$folder_old."/";
        $files = glob($pathdir . '/*');     
        foreach($files as $file) {     
            if(is_file($file)) {      
                // unlink($file); 
            } 
        }    

        #sessionid เป็นค่าว่าง แสดงว่ายังไม่เคยส่งออก ต้องสร้างไอดีใหม่ จาก max+1
        $maxid = Aipn_session::max('aipn_session_no');
        $aipn_session_no = $maxid+1;        

        #ตัดขีด, ตัด : ออก
        $pattern_date = '/-/i';
        $aipn_date_now_preg = preg_replace($pattern_date, '', $sss_date_now);
        $pattern_time = '/:/i';
        $aipn_time_now_preg = preg_replace($pattern_time, '', $aipn_time_now);
        #ตัดขีด, ตัด : ออก

        $folder='10978_AIPN'.$an;
 
        // $folder='10978_AIPN_'.$aipn_session_no.'-'.$aipn_date_now_preg.'-'.$aipn_time_now_preg;
        $add = new Aipn_session();
        $add->aipn_session_no = $aipn_session_no;
        $add->aipn_session_date = $sss_date_now;
        $add->aipn_session_time = $aipn_time_now;
        $add->aipn_session_filename = $folder;
        $add->aipn_session_ststus = "Send";
        $add->save();

        mkdir ('C:/export/'.$folder, 0777, true);
   
        header("Content-type: text/txt");
        header("Cache-Control: no-store, no-cache");
        header('Content-Disposition: attachment; filename="content.txt"');

        // $file_name = "/BillTran".$aipn_time_now_preg.".txt"; 
        $ssop_count = DB::connection('mysql7')->select('      
            SELECT COUNT(*) as Invno             
            FROM ssop_billtran            
        '); 
        foreach ($ssop_count as $key => $valuecount) {
            $count = $valuecount->Invno;
        }

        $file_pat = "C:/export/".$folder."/10978-AIPN-".$an.'-'.$aipn_date_now_preg.".xml";     
        $objFopen_opd = fopen($file_pat, 'w');

         
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

        $opd_head = "\n".'<DATETIME>'.$sss_date_now.'T'.$aipn_time_now.'</DATETIME>';
        fwrite($objFopen_opd, $opd_head);

        $opd_head = "\n".'<SESSNO>'.$aipn_session_no.'</SESSNO>';
        fwrite($objFopen_opd, $opd_head);

        $opd_head = "\n".'<RECCOUNT>'.$count.'</RECCOUNT>';
        fwrite($objFopen_opd, $opd_head);

        $opd_head = "\n".'</Header>';
        fwrite($objFopen_opd, $opd_head);
    
        $opd_head = "\n".'<BILLTRAN>';
        fwrite($objFopen_opd, $opd_head);

        // $ssop_Billtran = DB::connection('mysql7')->select('   
        //     SELECT * from ssop_billtran            
        // ');

        // foreach ($ssop_Billtran as $key => $value2) {
        //     $b1 = $value2->Station;
        //     // $b2 = $value2->B2;
        //     $b3 = $value2->DTtran;
        //     $b4 = $value2->Hcode;
        //     $b5 = $value2->Invno;
        //     // $b6 = $value2->B6;
        //     $b7 = $value2->HN;
        //     // $b8 = $value2->B8;
        //     $b9 = number_format($value2->Amount,2);
        //     $b10 = number_format($value2->Paid,2);
        //     // $b11 = $value2->B11;
        //     $b12 = $value2->Tflag;
        //     $b13 = $value2->Pid;
        //     $b14= $value2->Name;
        //     $b15 = $value2->HMain;
        //     $b16= $value2->PayPlan;
        //     $b17= number_format($value2->ClaimAmt,2);
        //     // $b18 = $value2->B18;
        //     $b19 = number_format($value2->OtherPay,2);
        //     $strText2="\n".$b1."||".$b3."|".$b4."|".$b5."||".$b7."||".$b9."|".$b10."||".$b12."|".$b13."|".$b14."|".$b15."|".$b16."|".$b17."||".$b19;
        //     $ansitxt_pat2 = iconv('UTF-8', 'TIS-620', $strText2);
        //     fwrite($objFopen_opd, $ansitxt_pat2);
        // }
         
        $opd_head = "\n".'</BILLTRAN>';
        fwrite($objFopen_opd, $opd_head);
  
        // $opd_head = "\n".'<BillItems>';
        // fwrite($objFopen_opd, $opd_head);
  
        // $ssop_items = DB::connection('mysql7')->select('   
        //     SELECT * FROM ssop_billitems  
        //     ');
        // foreach ($ssop_items as $key => $value) {
        //     $s1 = $value->Invno;
        //     $s2 = $value->SvDate;
        //     $s3 = $value->BillMuad;
        //     $s4 = $value->LCCode;
        //     $s5 = $value->STDCode;
        //     $s6 = $value->Desc;
        //     $s7 = number_format($value->QTY,2);
        //     $s8 = number_format($value->UnitPrice,2);
        //     $s9 = number_format($value->ChargeAmt,2);
        //     $s10 = number_format($value->ClaimUP,2);
        //     $s11 = number_format($value->ClaimAmount,2);
        //     $s12 = $value->SvRefID;
        //     $s13 = $value->ClaimCat;
            
        //     $strText="\n".$s1."|".$s2."|".$s3."|".$s4."|".$s5."|".$s6."|".$s7."|".$s8."|".$s9."|".$s10."|".$s11."|".$s12."|".$s13;
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


       
 
        
       
            return redirect()->route('claim.aipn',[
                'an'  => $an
            ]);      
           
    }
    public function aipn_send_an(Request $request)
    {
        $datestart = $request->startdate;
        $dateend = $request->enddate; 
        $an = $request->AN;
        $ip = $request->ip(); 
        // dd($datestart);
        $sss_date_now = date("Y-m-d");
        $aipn_time_now = date("H:i:s");
        $sesid_status = 'new'; #ส่งค่าสำหรับเงื่อนไขการบันทึกsession

        $folder_old='/*';
        $pathdir =  "C:/export/".$folder_old."/";
        $files = glob($pathdir . '/*');     
        foreach($files as $file) {     
            if(is_file($file)) {      
             
            } 
        }    

        #sessionid เป็นค่าว่าง แสดงว่ายังไม่เคยส่งออก ต้องสร้างไอดีใหม่ จาก max+1
        $maxid = Aipn_session::max('aipn_session_no');
        $aipn_session_no = $maxid+1;        

        #ตัดขีด, ตัด : ออก
        $pattern_date = '/-/i';
        $aipn_date_now_preg = preg_replace($pattern_date, '', $sss_date_now);
        $pattern_time = '/:/i';
        $aipn_time_now_preg = preg_replace($pattern_time, '', $aipn_time_now);
        #ตัดขีด, ตัด : ออก

        $folder='10978AIPN'.$aipn_session_no;
  
        $add = new Aipn_session();
        $add->aipn_session_no = $aipn_session_no;
        $add->aipn_session_date = $sss_date_now;
        $add->aipn_session_time = $aipn_time_now;
        $add->aipn_session_filename = $folder;
        $add->aipn_session_ststus = "Send";
        $add->save();

        mkdir ('C:/export/'.$folder, 0777, true);
   
        header("Content-type: text/txt");
        header("Cache-Control: no-store, no-cache");
        header('Content-Disposition: attachment; filename="content.txt"');

        // $file_name = "/BillTran".$aipn_time_now_preg.".txt"; 
        $ssop_count = DB::connection('mysql7')->select('      
            SELECT COUNT(*) as Invno             
            FROM ssop_billtran            
        '); 
        foreach ($ssop_count as $key => $valuecount) {
            $count = $valuecount->Invno;
        }
        // $file_pat = "C:/export/".$folder."/10978-AIPN-".$an.'-'.$aipn_date_now_preg.''.$aipn_time_now_preg.".xml";  
        
        $file_pat = "C:/export/".$folder."/10978-AIPN-".$an.'-'.$aipn_date_now_preg.''.$aipn_time_now_preg.".xml";     
        $objFopen_opd = fopen($file_pat, 'w');

        $opd_head = '<?xml version="1.0" encoding="windows-874"?>';
        fwrite($objFopen_opd, $opd_head);
       
        $opd_head = "\n".'<CIPN>';
        fwrite($objFopen_opd, $opd_head);

        $opd_head = "\n".'<Header>';
        fwrite($objFopen_opd, $opd_head);
 
        $opd_head = "\n".'<DocClass>IPClaim</DocClass>';
        fwrite($objFopen_opd, $opd_head);

        $opd_head = "\n".'<DocSysID version="2.1">AIPN</DocSysID>';
        fwrite($objFopen_opd, $opd_head);

        $opd_head = "\n".'<serviceEvent>ADT</serviceEvent>';
        fwrite($objFopen_opd, $opd_head);

        $opd_head = "\n".'<authorID>10978</authorID>';
        fwrite($objFopen_opd, $opd_head);

        $opd_head = "\n".'<authorName>รพ.ภูเขียวเฉลิมพระเกียรติ</authorName>';
        $opd_head_ansi = iconv('UTF-8', 'TIS-620', $opd_head);
        fwrite($objFopen_opd, $opd_head_ansi);

        $opd_head = "\n".'<effectiveTime>'.$sss_date_now.'T'.$aipn_time_now.'</effectiveTime>';
        fwrite($objFopen_opd, $opd_head);
 
        $opd_head = "\n".'</Header>';
        fwrite($objFopen_opd, $opd_head);

        $opd_head = "\n".'<ClaimAuth>';
        fwrite($objFopen_opd, $opd_head);

        $opd_head = "\n".'<AuthCode></AuthCode>';
        fwrite($objFopen_opd, $opd_head);

        $aipn_InvNumber_ = DB::connection('mysql7')->select('SELECT AN,CONCAT(DTAdm_d,"T",DTAdm_t) as DTAdm,CONCAT(DTDisch_d,"T",DTDisch_t) as DTDisch FROM aipn_ipadt');
        foreach ($aipn_InvNumber_ as $key => $val) {
            $inv = $val->AN;
            $audt = $val->DTAdm;
            $indt = $val->DTDisch;
        }  

        $opd_head = "\n".'<AuthDT>'.$audt.'</AuthDT>';
        fwrite($objFopen_opd, $opd_head);
        $opd_head = "\n".'<UPayPlan>80</UPayPlan>';
        fwrite($objFopen_opd, $opd_head);
        $opd_head = "\n".'<ServiceType>IP</ServiceType>';
        fwrite($objFopen_opd, $opd_head);
        $opd_head = "\n".'<ProjectCode></ProjectCode>';
        fwrite($objFopen_opd, $opd_head);
        $opd_head = "\n".'<EventCode> </EventCode>';
        fwrite($objFopen_opd, $opd_head);
        $opd_head = "\n".'<UserReserve> </UserReserve>';
        fwrite($objFopen_opd, $opd_head);
        $opd_head = "\n".'<Hmain>10702</Hmain>';
        fwrite($objFopen_opd, $opd_head);
        $opd_head = "\n".'<Hcare>10978</Hcare>';
        fwrite($objFopen_opd, $opd_head);
        $opd_head = "\n".'<CareAs>B</CareAs>';
        fwrite($objFopen_opd, $opd_head);
        $opd_head = "\n".'<ServiceSubType> </ServiceSubType>';
        fwrite($objFopen_opd, $opd_head);

        $opd_head = "\n".'</ClaimAuth>';
        fwrite($objFopen_opd, $opd_head);
        
        $opd_head = "\n".'<IPADT>';
        fwrite($objFopen_opd, $opd_head);
 
        $aipn_data = DB::connection('mysql7')->select('   
            SELECT 
            AN,HN,IDTYPE,PIDPAT,TITLE,NAMEPAT,DOB,SEX,MARRIAGE,CHANGWAT,AMPHUR,NATION,AdmType,AdmSource 
            ,CONCAT(DTAdm_d,"T",DTAdm_t) as DTAdm
            ,CONCAT(DTDisch_d,"T",DTDisch_t) as DTDisch 
            ,LeaveDay,DischStat,DishType,AdmWt,DishWard,Dept
            FROM aipn_ipadt 
        '); 

        foreach ($aipn_data as $key => $value2) {
            $b1 = $value2->AN;
            $b2 = $value2->HN;
            $b3 = $value2->IDTYPE;
            $b4 = $value2->PIDPAT;
            $b5 = $value2->TITLE;
            $b6 = $value2->NAMEPAT;
            $b7 = $value2->DOB;
            $b8 = $value2->SEX;
            $b9 = $value2->MARRIAGE;
            $b10 = $value2->CHANGWAT;    //number_format($value2->Paid,2);
            $b11 = $value2->AMPHUR;
            $b12 = $value2->NATION;
            $b13 = $value2->AdmType;
            $b14= $value2->AdmSource;
            $b15 = $value2->DTAdm;
            $b16= $value2->DTDisch;
            $b17= $value2->LeaveDay;
            $b18 = $value2->DischStat;
            $b19 = $value2->DishType;
            $b20 = $value2->AdmWt;
            $b21 = $value2->DishWard;
            $b22 = $value2->Dept;
            $strText2="\n".$b1."|".$b2."|".$b3."|".$b4."|".$b5."|".$b6."|".$b7."|".$b8."|".$b9."|".$b10."|".$b11."|".$b12."|".$b13."|".$b14."|".$b15."|".$b16."|".$b17."|".$b18."|".$b19."|".$b20."|".$b21."|".$b22;
            $ansitxt_pat2 = iconv('UTF-8', 'TIS-620', $strText2);
            fwrite($objFopen_opd, $ansitxt_pat2);
        }

        $opd_head = "\n".'</IPADT>';
        fwrite($objFopen_opd, $opd_head);
          
        $ipdx_count_ = DB::connection('mysql7')->select('SELECT COUNT(aipn_ipdx_id) as iCount FROM aipn_ipdx');
        foreach ($ipdx_count_ as $key => $value_c) {
            $ipdx_count = $value_c->iCount;
        }  
        $opd_head = "\n".'<IPDx Reccount="'.$ipdx_count.'">';
        fwrite($objFopen_opd, $opd_head);   
      
        $ipdx = DB::connection('mysql7')->select('   
            SELECT * FROM aipn_ipdx  
        ');        
        foreach ($ipdx as $key => $value_ip) {
            $s1 = $value_ip->sequence;
            $s2 = $value_ip->DxType;
            $s3 = $value_ip->CodeSys;
            $s4 = $value_ip->Dcode;
            $s5 = $value_ip->DiagTerm;
            $s6 = $value_ip->DR; 
            
            $strText="\n".$s1."|".$s2."|".$s3."|".$s4."|".$s5."|".$s6."|";
            $ansitxt_ipdx = iconv('UTF-8', 'TIS-620', $strText);
            fwrite($objFopen_opd, $ansitxt_ipdx);
        }         
        $opd_head = "\n".'</IPDx>';
        fwrite($objFopen_opd, $opd_head);
 
   
        $ipop_count_ = DB::connection('mysql7')->select('SELECT COUNT(aipn_ipop_id) as iopcount FROM aipn_ipop');
        foreach ($ipop_count_ as $key => $value_op) {
            $ipop_count = $value_op->iopcount;
        }    
        $opd_head = "\n".'<IPOp Reccount="'.$ipop_count.'">';
        fwrite($objFopen_opd, $opd_head); 
     
        $ipop = DB::connection('mysql7')->select('   
            SELECT 
            sequence,CodeSys,Code,Procterm,DR,DateIn,DateOut,Location 
            FROM aipn_ipop  
        ');
        foreach ($ipop as $key => $value_ipop) {
            $s1 = $value_ipop->sequence;
            $s2 = $value_ipop->CodeSys;
            $s3 = $value_ipop->Code;
            $s4 = $value_ipop->Procterm;
            $s5 = $value_ipop->DR;
            $s6 = $value_ipop->DateIn; 
            $s7 = $value_ipop->DateOut;

            $strText="\n".$s1."|".$s2."|".$s3."|".$s4."|".$s5."|".$s6."|".$s7."|";
            $ansitxt_ipop = iconv('UTF-8', 'TIS-620', $strText);
            fwrite($objFopen_opd, $ansitxt_ipop);
        }     
        $opd_head = "\n".'</IPOp>';
        fwrite($objFopen_opd, $opd_head);
                  
        $billitem_count_ = DB::connection('mysql7')->select('SELECT COUNT(aipn_billitems_id) as bill_count FROM aipn_billitems');
        foreach ($billitem_count_ as $key => $value_bill) {
            $billitem_count = $value_bill->bill_count;       
         }
        $opd_head = "\n".'<Invoices>';
        fwrite($objFopen_opd, $opd_head);

        $opd_head = "\n".'<InvNumber>'.$inv.'</InvNumber>';
        fwrite($objFopen_opd, $opd_head);

        $opd_head = "\n".'<InvDT>'.$indt.'</InvDT>';
        fwrite($objFopen_opd, $opd_head); 
            
        $opd_head = "\n".'<BillItems Reccount="'.$billitem_count.'">';
        fwrite($objFopen_opd, $opd_head);
        
        $text_billitems_ = DB::connection('mysql7')->select('SELECT * from aipn_billitems'); 
        foreach ($text_billitems_ as $key => $bitem) {
            $t1 = $bitem->sequence;
            $t2 = $bitem->ServDate;
            $t3 = $bitem->BillGr;
            $t4 = $bitem->LCCode;
            $t5 = $bitem->Descript;
            $t6 = $bitem->QTY;
            $t7 = number_format($bitem->UnitPrice,2);
            $t8 = number_format($bitem->ChargeAmt,4);
            $t9 = number_format($bitem->Discount,4);
            $t10 = $bitem->ProcedureSeq;   
            $t11 = $bitem->DiagnosisSeq;
            $t12 = $bitem->ClaimSys;
            $t13 = $bitem->BillGrCS;
            $t14= $bitem->CSCode;
            $t15= $bitem->CodeSys;
            $t16 = $bitem->STDCode;
            $t17= $bitem->ClaimCat;
            $t18= $bitem->DateRev;
            $t19 = number_format($bitem->ClaimUP,4);
            $t20 = number_format($bitem->ClaimAmt,4);
 
            $strText2="\n".$t1."|".$t2."|".$t3."|".$t4."|".$t5."|".$t6."|".$t7."|".$t8."|".$t9."|".$t10."|".$t11."|".$t12."|".$t13."|".$t14."|".$t15."|".$t16."|".$t17."|".$t18."|".$t19."|".$t20;
            $ansitxt_bitem = iconv('UTF-8', 'TIS-620', $strText2);
            fwrite($objFopen_opd, $ansitxt_bitem);
        }
        $sum_billitems_ = DB::connection('mysql7')->select('SELECT SUM(ChargeAmt) as Total from aipn_billitems');  
        foreach ($sum_billitems_ as $key => $value_sum) {
            $sum_billitems = $value_sum->Total;
        }      

        $opd_head = "\n".'</BillItems>';
        fwrite($objFopen_opd, $opd_head);

        $opd_head = "\n".'<InvAddDiscount>0.00</InvAddDiscount>';
        fwrite($objFopen_opd, $opd_head);
        $opd_head = "\n".'<DRGCharge>'.$sum_billitems.'</DRGCharge>';
        fwrite($objFopen_opd, $opd_head);
        $opd_head = "\n".'<XDRGClaim>0.0000</XDRGClaim>';
        fwrite($objFopen_opd, $opd_head);

        $opd_head = "\n".'</Invoices>';
        fwrite($objFopen_opd, $opd_head);
 
        $opd_head = "\n".'<Coinsurance> </Coinsurance>';
        fwrite($objFopen_opd, $opd_head);

        $opd_head = "\n".'</CIPN>';
        fwrite($objFopen_opd, $opd_head);
       
        $opd_head = "\n";
        fwrite($objFopen_opd, $opd_head);

        $opd_head = "\n";
        fwrite($objFopen_opd, $opd_head);


        $md5file = md5_file($file_pat,FALSE);
        $mdup = strtoupper($md5file);  

        $objFopen_opd = fopen($file_pat, 'a');
        $opd_head = '<?EndNote HMAC="'.$mdup.'" ?>';        
        fwrite($objFopen_opd, $opd_head);
 
        
            return redirect()->route('claim.aipn',[
                'an'  => $an
            ]);      
           
    }
    public function aipn_zip(Request $request)
    {    
        $filename = Aipn_session::max('aipn_session_no');
        $nzip = Aipn_session::where('aipn_session_no','=',$filename)->first(); 
        $namezip = $nzip->aipn_session_filename; 
 
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
                    unlink($zipcreated);     
                    $files = glob($pathdir . '/*');   
                    foreach($files as $file) {    
                        if(is_file($file)) {      
                        } 
                    }                   
                    return redirect()->route('claim.aipn');                    
                }
        }
    }
    public function aipn_send_chang(Request $request)
    {
        // Aipn_billitems::where('STDCode', '=','')->delete();
        // $aipn_billitems = DB::connection('mysql7')->select('DELETE FROM aipn_billitems WHERE STDCode IS NULL');
        $aipn_billitems = DB::connection('mysql7')->select('SELECT * FROM aipn_billitems WHERE STDCode IS NULL');
        foreach ($aipn_billitems as $key => $value) {
            $id = $value->aipn_billitems_id;
            $del = Aipn_billitems::find($id);
            $del->delete();            
        }
        return response()->json(['status' => '200']);
       
    }
}
   